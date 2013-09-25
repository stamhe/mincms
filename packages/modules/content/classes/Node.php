<?php namespace application\modules\content\classes; 
use application\modules\content\models\Field;
use application\modules\content\models\NodeActiveRecord;
use application\modules\content\Classes;
use application\modules\content\classes\NodeMongoDB;
use application\modules\content\classes\NodeMySQL;
use application\core\DB;
use application\core\Arr; 
/**
* 
* @author Sun < mincms@outlook.com >
*/
class Node{ 
	/**
	* 
	$node = node_save('post',array(
  	 	'title'=>1,
  	 	 'body'=>$str
  	 ));
	*/
	static function save($name,$array=array(),$nid=null){
		if($array['id']) {
			$nid = $array['id'];
			unset($array['id']);
		}
		$model = new NodeActiveRecord;
	 	$structure = Classes::structure($name); 
		$model::$table = $name;
		if($nid>0){
			$row = Classes::_one($name,$nid);
	 		foreach($row as $k=>$v){
	 			$model->$k=$v;
	 		} 
		}
		$data = Node::set_rules($structure); 
		$attrs_data = $data['attrs'];  
	 	/**
	 	* 验证规则赋值给Model中的ruels属性
	 	*/
		$model->rules = $data['rules']; 
		$attrs = array();
 		foreach($attrs_data as $get){
 			$attrs[$get] = trim($array[$get]);
 		}
 		$return = static::save_model($name,$model,$attrs,$nid,true);
 		return str_replace('##ajax-form-alert##','',$return);
	}
	/**
 	*  save content base on FormBuilder
 	* @params $name content_type_name
 	* @params $model Model
 	* @params $attrs 属性
 	* @params $return 为true时返回nid
 	*/
 	static function save_model($name,$model,$attrs,$nid=null,$return=false){    
 		if(\Yii::$app->controller->mongo_db){
 			NodeMongoDB::save_model($name,$model,$attrs,$nid,$return);
 		}else{
 			NodeMySQL::save_model($name,$model,$attrs,$nid,$return);
 		}
 	}
 	static function __save_array($table , $_v ,$relate ,$fid ,$nid){
 		$one = DB::one($table,array(
			'where'=>array(
				'value'=>$_v
			)
		));
		//$value  is node value id
		if(!$one){ 
			DB::insert($table,array( 
 				'value'=>$_v 
 			));
 			$value = DB::id(); 
		}else{
			$value = $one['id'];
		} 
		return $value;
 	}
	/**
	 * 设置验证规则
	 */
	 function set_rules($data){
	 	//set validate rules && plugins
	 	$i=0;  
		foreach($data as $field=>$value){ 
			/**
			* 设置字段对应的验证规则，
			* 至少有一个验证规则。
			* 如果都没有验证规则，则无法显示表单。
			* 因为数据库不需要保留全为空的值
			*/
			$attrs[] = $field;
			$validates = $value['validates'];
			if(!$validates) continue;
			foreach($validates as $k=>$v){  
				if(is_bool($v) || is_numeric($v) ){
					$rules[$i] = array($field,$k);
				}else if(is_array($v)){ 
					$rules[$i][] = $field; 
					$rules[$i][] = $k; 
					foreach($v as $_k=>$_v){  
						$rules[$i][$_k] = $_v;
					} 
				} 
				$i++;
			}
		} 
		/**
		* 无规则直接报错
		*/
	 	if(!$rules){
	 		exit(__('admin','No Validate Rules'));
	 	} 
		return array(
			'rules'=>$rules,
			'attrs'=>$attrs,
			'plugins'=>$out_plugins,
		);

	 }
	   
	static function delete_cache($name,$nid){
		$cache_id = "node_{$name}_{$nid}"; 
		\Yii::$app->cache->delete($cache_id);
	}  
 	
}