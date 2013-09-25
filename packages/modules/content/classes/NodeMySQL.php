<?php namespace application\modules\content\classes; 
use application\modules\content\models\Field;
use application\modules\content\models\NodeActiveRecord;
use application\modules\content\Classes;
use application\modules\content\classes\Node; 
use application\core\DB;
use application\core\Arr; 
use application\core\Str;
/**
*  mysql drive for content module
*  
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1 
*/
class NodeMySQL{ 
	 
	/**
 	*  save content base on FormBuilder
 	* @params $name content_type_name
 	* @params $model Model
 	* @params $attrs 属性
 	* @params $return 为true时返回nid
 	*/
 	static function save_model($name,$model,$attrs,$nid=null,$return=false){   
 		foreach($attrs as $key=>$value){
 			$model->$key = $value; 
 		} 
 		$out = "##ajax-form-alert##:";
 		if(!$model->validate()){
 			$errors = $model->getErrors(); 
 			$out.= "<ul class='alert alert-error info'>";
 			foreach($errors as $key=>$e){
 				foreach($e as $r)
 					$out.= '<li>'.$r.'</li>';
 			}
 			$out.="</ul>"; 
 			if(true === $return){
 				return $out;
 			}
 			exit($out);
 		}  
 		// get  structure 
 		$structs = Classes::structure($name); 
 		$table = "node_".$name;// node table  
 		//data to [relate] like [node_post_relate]
 		$relate = $table.'_relate'; 
 		if($nid>0){   
 		 	$display = 1;
 		 	if($model->display)
 				$display = $model->display; 
 		    	DB::update($table,array( 
			 			'updated'=>time(),
			 			'display'=>$display, 
			 		),'id=:id',array( ':id'=>$nid)
			 		);  
 		 
 		}else{ 
 			$sort = DB::all($table,array(
 				'limit'=>1,
 				'orderBy'=>'id desc'
 			));
 			$sort = $sort[0]['id']+1;
	 		DB::insert($table,array(
		 			'created'=>time(),
		 			'updated'=>time(),
		 			'sort'=>$sort,
		 			'uid'=>uid()
		 		)); 
	 		$nid = DB::id();
 		}   
 		
 		foreach($structs as $k=>$v){ 
 			$value = $model->$k;
 			//if(){ //属性有值时 才会查寻数据库
 				$fid = $v['fid'];//字段ID
 				$table = "content_".$v['mysql'];  
 				unset($_check_relate[$table][$fid]);
 				if($v['relate']){
 					$_check_relate[$table][$fid] = true;  
 				}
 				$batchs[$table][$fid][] = $value;  
 				$wherein[$table][] = $value;  
 			//} 
 		}   
 		/**  
		[content_text] => Array
		    (
		        [3] => Array
		            (
		                [0] => 222
		            )

		    ) 
 		*/  
 	   
 		foreach($batchs as $table=>$values){ 
 			//echo Arr::deep($value); 
 		 	foreach($values as $fid=>$v){ //$k  filed_id
 		 		foreach($v as $_v){ // $_v value  
 		 			if(is_array($_v)){
 		 				$_v = array_unique ($_v); 
 		 				if($nid>0){
 		 					DB::delete($relate,'nid=:nid and fid=:fid',
	 		 					array( 
					 				':nid'=>$nid ,
					 				':fid'=>$fid 
					 			)
				 			); 
				 		}  
 		 				foreach($_v as $_nv){ 
 		 					if(! $_check_relate[$table][$fid] )
 		 						$value = Node::__save_array($table , $_nv ,$relate ,$fid ,$nid); 
 		 					else
 		 			 			$value = $_nv;
 		 					DB::insert($relate,array( 
				 				'nid'=>$nid ,
				 				'fid'=>$fid,
				 				'value'=>$value
				 			)); 
 		 				} 
 		 			}else{  
 		 				if(! $_check_relate[$table][$fid] )
 		 					$value = Node::__save_array($table , $_v ,$relate ,$fid ,$nid);  
 		 			 	else
 		 			 		$value = $_v;  
 		 				$one = DB::one($relate,array( 
				 				'where'=>array(
					 				'nid'=>$nid ,
					 				'fid'=>$fid,
				 			 	)
				 			));  
						//$value  is node value id
						if(!$one){ 
							if($value){
								DB::insert($relate,array( 
					 				'nid'=>$nid ,
					 				'fid'=>$fid,
					 				'value'=>$value
					 			)); 
				 			}
						}elseif($one['value']!=$value && $value){
							 DB::update($relate,array(  
				 				'value'=>$value
				 			 ),'nid=:nid and fid=:fid',array(
				 			 	':nid'=>$nid ,
				 				':fid'=>$fid,
				 			 ));
						}
 		 			}
 		 			 
 		 		}
 		 	} 
 		}  
 		$out.= 1; 
		//remove cache
		$cacheId = "_one_module_content_node_{$name}_{$nid}";
		cache($cacheId,false);
		$cacheId = "module_content_node_{$name}_{$nid}";
		cache($cacheId,false);
		// create cache 
		Classes::one($name,$nid);
	 	Classes::_one($name,$nid);
	 	\Yii::$app->cache->flush();
		if(true === $return){ 
			return $nid;
		} 
		
		exit($out);  
 	}
 	static function one_full($slug , $id){ 
		$table = "node_".$slug;
		$model = DB::one($table,array(
			'where'=>array(
				'id'=>$id
			)
		));
		$node = static::one($slug,$model['id']); 
		$node->id = $model['id'];
		$node->uid = $model['uid'];
		$node->created = $model['created'];
		$node->updated = $model['updated'];
		$node->admin = $model['admin'];
		$node->display = $model['display']; 
		return $node;
	}
	static function all($slug,$params=array(),$backend=false){ 
		$ch = Classes::structure($slug);
		if(!$ch) return; 
		$cacheID = "module_content_class_pager_list".$slug;
		if($params){
			$cacheID .=json_encode($params);
		} 
		$cacheID = md5($cacheID); 
		$out = cache($cacheID);
		if(!$out){
			
			$table = "node_".$slug;// node table   
			$wh = $params['where'];
			$params['orderBy'] = $params['orderBy']?:"sort desc , id desc";
			$flag = false;
			if($wh){
				foreach($wh as $w=>$v){
					if(!in_array($w,Classes::default_columns())){
						$flag = true;
					}
				}
			} 
			if($flag === false){ 
				$all = DB::all($table,$params); 
			}else{
				$_params = static::params($slug,$params); 
				$sql = "SELECT t.* FROM  $table t " . $_params['sql'] ;
				if($_params['where']) 
					$sql .= " WHERE ".$_params['where'];
				$sql .= " ORDER BY ".$_params['orderBy'];
				if($params['limit'])
					$sql .= " LIMIT  ".$params['limit'];   
			 
				$all = DB::queryAll($sql); 
			}  
			foreach($all as $model){
				if(true == $backend){
					$node = static::_one($slug,$model['id']);
				}else{
					$node = static::one($slug,$model['id']);
				}
				$node->id = $model['id'];
				$node->uid = $model['uid'];
				$node->created = $model['created'];
				$node->updated = $model['updated'];
				$node->admin = $model['admin'];
				$node->display = $model['display']; 
				$out[] = $node;
			}
			//if(true !== YII_DEBUG)
				cache($cacheID,$out );
		}
		return $out; 
	}
	/**
	* where , orderBy , and so on conditions.
	* some fileds not in the master table. like node_post
	* it is in node_post_relate
	* 
	*/
	static function params($slug,$params){
		$structure = Classes::structure($slug); 
		$relate_table = "node_{$slug}_relate";
		/**
		'where'=>array(
			'type'=>1
		),
		*/
		$wh = $params['where'];
		if($wh){
			$where = " 1=1 ";
			$i=1;
			foreach($wh as $w=>$v){ 
				$i++;
				if(is_array($v)){
					$w = $v[0];
				}
				if(!in_array($w,Classes::default_columns())){
					$f = $structure[$w];   
					$fid = $f['fid'];
					$relate = $f['relate'];  
					if(!$relate){ 
						$content_table = "content_".$f['mysql'];   
					} else{
						$content_table = $relate;  
					}
					$alias = $slug.'_'.$f['slug'].$i;
					if(is_array($v)){
						$a = $v[0];
						$b = $v[1];
						$c = $v[2];
						$c = Str::escape_str($c); 
						if(trim(strtolower($b))=='like'){
							$c = "%$c%";
						}
						if(!$relate){
							$all = DB::all($content_table,array(
								'select'=>'id',
								'where'=>array(
									$b ,'value', $c
								)
							)); 
						}else{
							/**
							* 此处在关联时有问题
							*
							*/
							/*$all = DB::all($relate,array(
								'select'=>'id',
								'where'=>array(
									'id' =>$v
								)
							)); */
						}
						if($all){
							$value = array();
							foreach($all as $al){
								$value[] = $al['id'];
							}
						}
						$sql .= "
					 		LEFT JOIN $relate_table $alias
					 		ON {$alias}.nid = t.id 
					 	";
					 	$where .= " AND {$alias}.fid = $fid	"; 
					 	if($value){ 
					 		$where .= " AND {$alias}.`value` in( ".implode(',',$value) .")";
					 	}else{
					 		$where .= " AND {$alias}.`value` = '' ";
					 	} 
						 
					} else{
						$v = Str::escape_str($v);
						if(!$relate){
							$one = DB::one($content_table,array(
								'select'=>'id',
								'where'=>array(
									'value'=>$v
								)
							)); 
							$value = $one['id']; 
							
						} else{
							 $value = $v;  
						}
						$sql .= "
					 		LEFT JOIN $relate_table $alias
					 		ON {$alias}.nid = t.id 
					 	";
					 	$where .= " AND {$alias}.fid = $fid	"; 
					 	if($value){   
					 		$where .= " AND {$alias}.`value` = $value ";
					 	}else{
					 		 
					 		if($value==0) {
					 			$where .= " AND {$alias}.`value` = 0 ";
					 		}else
					 			$where .= " AND {$alias}.`value` = '' ";
					 	}
						
					 	
				 	}
					  
				}else{
					if(is_array($v)){
						$a = $v[0];
						$b = $v[1];
						$c = $v[2];
						$c = Str::escape_str($c); 
						if(trim(strtolower($b))=='like'){
							$c = "%$c%";
						}
						$where .= " AND t.$a $b $c	";
					} 
					else{
						$v = Str::escape_str($v);
						$where .= " AND t.$w = $v	";
					}
					 
				}
			}
		}
		$orderBy = $params['orderBy']; 
		$arr = explode(',',$orderBy);
		unset($orderBy);
		foreach($arr as $v){
			$ar = explode(' ',$v); 
			foreach($ar as $k=>$v){
				if($v){
					$new[] = $v;
				}
			}
			
		}
		$i = 0; 
		foreach($new as $v){
			if($i%2 != 0 ){
				$field = $new[$i-1];
				$sort = $v;
			 	$orderBy .= $field . " ".$sort .",";
			}
			$i++;
		} 
	 
		return array('sql'=>$sql,'where'=>$where ,'orderBy'=>substr($orderBy,0,-1));
	}
	/**
	*
	$data = node_pager('post');
	<div class='pagination'>
		<?php  echo \application\core\LinkPager::widget(array(
		      'pagination' => $pages,
		  ));?>
	</div>
	<?php foreach($models as $model){?>
		<p><?php  dump($model);?> </p>
	<?php }?>
	*/
	static function pager($slug,$params=array(),$config=10,$admin=false,$route=null){
		$ch = Classes::structure($slug);
		if(!$ch) return;
		$cacheID = "module_content_class_pager_list".$slug."_".$_GET['page'];
		if($params){
			$cacheID .=json_encode($params);
		}
		if($config){
			if(is_array($config)){
				$cacheID .=json_encode($config);
			}else{
				$cacheID .=$config;
			}
		}
		$cacheID .= $route;
		$cacheID = md5($cacheID); 
		$row = cache($cacheID);
		if(!$row){
			$table = "node_".$slug;// node table   
			$wh = $params['where'];
			$params['orderBy'] = $params['orderBy']?:"sort desc , id desc";
			if(!is_array($config)) $config = array('pageSize'=>$config);
			$flag = false;
			if($wh){
				foreach($wh as $w=>$v){
					if(is_array($v)){
						$w = $v[0];
					}
					if(!in_array($w,Classes::default_columns())){
						$flag = true;
					} 
				}
			}
		
			if($flag === false){  
				$pager = DB::pagination($table,$params,$config,$route);
				$models = $pager->models;
				$pages = $pager->pages;
			}else{
				$_params = static::params($slug,$params); 
				$sql = "SELECT t.* FROM  $table t " . $_params['sql'] ;
				$count_sql = " SELECT count(*) count FROM  $table t  " .$_params['sql'] ;
				if($_params['where']) {
					$sql .= " WHERE ".$_params['where'];
					$count_sql .= " WHERE ".$_params['where'];
				} 
		 
				$one = DB::queryRow($count_sql); 
				$config['totalCount'] = $one['count'];				
				$pages = new \yii\data\Pagination($config); 
				if($route)
					$pages->route = $route;
				$offset = $pages->offset > 0 ? $pages->offset:0;
				$limit = $pages->limit > 0 ? $pages->limit:10;     
				$sql .= " ORDER BY ".$_params['orderBy'];
				$sql .= " LIMIT $offset,$limit ";
			
				$models = DB::queryAll($sql);   
			} 
		 
			foreach($models as $model){
				if(true === $admin){
					$node = static::_one($slug,$model['id']); 
				}else
					$node = static::one($slug,$model['id']); 
				$node->id = $model['id'];
				$node->uid = $model['uid'];
				$node->created = $model['created'];
				$node->updated = $model['updated'];
				$node->admin = $model['admin'];
				$node->display = $model['display']; 
				$out[] = $node;
			}
			$row = array(
				'models' => $out,
				'pages' => $pages
			);
			//if(true !== YII_DEBUG)
				cache($cacheID,$row );
		}
		return $row;
	}
	static function one($slug,$nid){
		$ch = Classes::structure($slug);
		if(!$ch) return;
		$cacheId = "module_content_node_{$slug}_{$nid}";
		$row = cache($cacheId);
		if(!$row){
			$row = static::_one($slug,$nid);
			// relate ship 
			$s = Classes::structure($slug);  
			foreach($row as $k=>$v){ 
				//get relation value
				$relate = $s[$k]['relate'];   
				if($relate){
					$row->$k = static::_relation($s , $k ,$v , $relate);
				}
			} 
			//if(true !== YII_DEBUG)
				cache($cacheId,$row);
		}
		return $row;
	}
	static function  _relation($s , $k ,$v , $relate){ 
		if($relate == 'file'){
			$condition['where']  = array(
				'id'=>$v
			);
			if(is_array($v))
				$condition['orderBy']  = array('FIELD(`id`, '.implode(',',$v).')'=>''); 
			
			$all = DB::all('file',$condition);
			$return = $all; 
		}else{
			$relate = str_replace('node_' , '' ,$relate);  
			if($relate && strpos($relate,'taxonomy:')!==false){
				$relate = substr($relate,0,strpos($relate,':'));
			} 
			if(is_array($v) ){ 
				if( count($v) < 1 ) return ;
				foreach($v as $_v){	
					$r = (array)static::_one($relate,$_v);   
					if($r)
						$vo[$_v] = Arr::first($r);
				}
				$return = $vo;
			}else{ 
				$r = (array)static::_one($relate,$v);  
				if($r)
		 			$return = Arr::first($r);
			}
			
		}
 		return $return;
	
	}
 
	/**
	* load one full data
	*/
	static function _one($slug,$nid){   
		$cacheId = "_one_module_content_node_{$slug}_{$nid}";
		$row = cache($cacheId);
		if(!$row){
			$table = "node_".$slug;// node table  
	 		//data to [relate] like [node_post_relate]
	 		$relate = $table.'_relate'; 
			$structs = Classes::structure($slug); 
		  	if(!$structs) return;
			foreach($structs as $k=>$v){  
				$fid = $v['fid'];//字段ID 
				$table = "content_".$v['mysql'];  
				$is_relate = $v['relate']; //判断是不是关联表的值
				if($is_relate && strpos($is_relate,'taxonomy:')!==false){
					$is_relate = substr($is_relate,0,strpos($is_relate,':'));
				} 
				unset($one); 
				 
				$all = DB::all($relate,array(
					'where'=>array(
						'nid'=>$nid,
						'fid'=>$fid,
					),
					'orderBy'=>'id asc'
				));  
				if(count($all) == 1){
					$one = $all[0]['value'];
				}else{ 
					foreach($all as $al){
						$one[$al['value']] = $al['value'];
					}
				} 
				
				$batchs[$table][$v['slug']] = $one;  
				if($is_relate)
					 $new_relate[$v['slug']]= $is_relate;
	 		} 
	 	 	$row = (object)array();   
	 	 	
			foreach($batchs as $table=>$value_ids){
			 	foreach($value_ids as $field_name=>$_id){ 
			 		$condition = array();
			 		$condition['where'] = array(
					 	'id'=>$_id
					); 
					if(is_array($_id)){ 
						$condition['orderBy']  = array('FIELD(`id`, '.implode(',',$_id).')'=>''); 
					} 
					if($new_relate[$field_name]) { 
					 	$one = $_id;
					}else{ 
						$all = DB::all($table,$condition);    
						if(count($all) == 1){
							$one = $all[0]['value'];
						}else{ 
							$one = array();
							foreach($all as $al){
								$one[] = $al['value'];
							}  
						}  
					}
					$rt = Classes::_value_array($structs[$field_name]['widget']);
					if($rt){
						$d = $one;
						unset($one);
						if($d){
							if(!is_array($d))
								$one[$d] = $d;
							else
								$one = $d;
						}
					}
					if($one)
						$row->$field_name = $one; 
				}
			} 
			//if(true !== YII_DEBUG) 
				cache($cacheId,$row);
		}
		return $row;
	}
 	
}