<?php namespace application\modules\content\classes; 
use application\modules\content\models\Field;
use application\modules\content\models\NodeActiveRecord;
use application\modules\content\Classes;
use application\core\DB;
use application\core\Arr; 
/**
* 
* @author Sun < mincms@outlook.com >
*/
class NodeMongoDB{   
	
 	static function save_model($name,$model,$attrs,$nid=null,$return=false){   
 		$mongo = \Yii::$app->controller->mongo_db;
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
 		$relate = $table.'_relate'; 
 		unset($values);
 		foreach($structs as $k=>$v){ 
 			$values[$k] = $model->$k;
 		}
 	 	$mongo->insert($table,$values);
 		 
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
		$cacheID = "module_content_class_pager_list".$slug;
		if($params){
			$cacheID .=json_encode($params);
		} 
		$cacheID = md5($cacheID); 
		$out = cache($cacheID);
		if(!$out){  
		 	$mongo = static::params($params); 
		 	$table = static::table($slug); 
		 	$array = $mongo->get($table);
		 	$i = 0;
		 	foreach($array as $one){
		 		$out[$i] = $one;
		 		$out[$i]['id'] = (string)$one['_id'];
		 		unset($out[$i]['_id']);
		 		$i++;
		 	}
		 	
			//	cache($cacheID,$out );
		}  
		 
		return $out; 
	}
 	static function table($slug){
 		return "node_".$slug; 
 	}
	static function params($params){ 
		$mongo = \Yii::$app->controller->mongo_db; 
		if($params['where']){
			$mongo = $mongo->where( $params['where'] );
		}
		if($params['orderBy']){
			if(!is_array($params['orderBy'])){
				$orderBy = $params['orderBy'];
				$arr = explode(',',$orderBy);
				foreach($arr as $v){
					$a = explode(' ',$v);
					$sort[$a[0]] = $a[1];
				}
				$params['orderBy'] = $sort;
			}
		//	$mongo = $mongo->order_by( $params['orderBy'] );
		}
		return $mongo;
	}
	static function pagination($slug,$params=array(),$config=array('pageSize'=>10),$route=null){
		if(!is_array($config)){
			$config=array('pageSize'=>$config);
		} 
		$mongo = static::params($params);
		$table = static::table($slug);
		$count = $mongo->count($table); 
		$config['totalCount'] = $count;
		$pages = new \yii\data\Pagination($config); 
		if($route)
			$pages->route = $route;
		$params['offset'] = $pages->offset;
		$params['limit'] = $pages->limit;  
     	$models = static::all($slug,$params); 
     	return array(
			'pages'=>$pages,
			'models'=>$models
		);
	}
	static function pager($slug,$params=array(),$config=10,$admin=false,$route=null){
		$ch = Classes::structure($slug);
		if(!$ch) return;
		$cacheID = "module_content_class_pager_list".$slug;
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
		$object = cache($cacheID);
		if(!$object){ 
			$wh = $params['where'];echo 1; 
			$params['orderBy'] = $params['orderBy']?: array( "sort"=> 'desc' , '_id'=> "desc");
			if(!is_array($config)) $config = array('pageSize'=>$config); 
		 
			$object = static::pagination ($slug,$params , $config);
		  
			 
		 
			//if(true !== YII_DEBUG)
			//	cache($cacheID,$object );
		}
		return $object;
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
		 
			//	cache($cacheId,$row);
		}
		return $row;
	}
	static function  _relation($s , $k ,$v , $relate){ 
		if($relate == 'file'){
			$condition['where']  = array(
				'id'=>$v
			);
			if(is_array($v))
				$condition['orderBy']  = array('FIELD (`id`, '.implode(',',$v).')'=>''); 
			
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
						$condition['orderBy']  = array('FIELD (`id`, '.implode(',',$_id).')'=>''); 
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