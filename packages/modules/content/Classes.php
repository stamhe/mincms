<?php 
namespace application\modules\content; 
use application\core\DB;  
use application\core\Arr;
use application\core\Str;
use application\modules\content\models\FieldView;
use application\modules\content\classes\NodeMongoDB;
use application\modules\content\classes\NodeMySQL;
/**
 *  
 * @author Sun < mincms@outlook.com >
 * @Coprighty  http://mincms.com
 */
class Classes
{
	static $mongo;
	static function init(){
		static::$mongo = \Yii::$app->controller->mongo_db;
		if(static::$mongo){
			return 'NodeMongoDB';
		}
		return 'NodeMySQL';
	}
	static function one_full($slug , $id){ 
		static::init();
		if(static::$mongo){
			return NodeMongoDB::one_full($slug , $id);
		}
		return NodeMySQL::one_full($slug , $id); 
	}
	static function all($slug,$params=array(),$backend=false){ 
		static::init();
		if(static::$mongo){
			return NodeMongoDB::all($slug,$params,$backend);
		}
		return NodeMySQL::all($slug,$params,$backend); 
	}
	static function pager($slug,$params=array(),$config=10,$admin=false,$route=null){
		static::init();
		if(static::$mongo){
			return NodeMongoDB::pager($slug,$params,$config,$admin,$route);
		}
		return NodeMySQL::pager($slug,$params,$config,$admin,$route); 
	}
	static function one($slug,$nid){
		static::init();
		if(static::$mongo){
			return NodeMongoDB::one($slug , $nid);
		}
		return NodeMySQL::one($slug , $nid); 
	 
	}
	static function _one($slug,$nid){   
		static::init();
		if(static::$mongo){
			return NodeMongoDB::_one($slug , $nid);
		}
		return NodeMySQL::_one($slug , $nid); 
	}
 
	
	// check field value is array
	static function _value_array($widget){
		$widget = 'application\modules\content\widget\\'.$widget.'\widget';  
		return $widget::value_type(); 
	}
	
	static function cck_list(){
		$cache = cache('show_tables');
		if(!$cache){
			$rows = DB::queryAll("SHOW TABLES"); 
			foreach($rows as $r){
				foreach($r as $v)
					$cache[$v] = $v;
			}
			cache('show_tables',$cache);
		}
		if(!$cache['content_type_field']) return false;
		return DB::all('content_type_field',array( 
			'where'=>array('pid'=>0),
 			'orderBy'=>'sort desc, id asc',
 		));   
 		 
	}
	
	/**
	* set value for /node/index field. 
	* value is string or array
	*/
	static function field_show_list($slug,$field,$value){
		if(!is_array($value)) return $value;
		$s = static::structure($slug);
		$relate = $s[$field]['relate'];   
		if($relate == 'file'){  
			 $value = Arr::first($value); 
			 if(is_array($value) && $value['path']){
				 return \application\core\File::input_one($value,$field ,false);
			 }
		} else{
			if(is_array($value)){
				return implode($value,',');
			}
			return $value;
			
		}
	}
	static function table_columns(){ 
	 	$all = DB::all('content_type_field',array('where'=>array('pid'=>0)));
		unset($tables , $table);
		foreach($all as $v){   
			$slug = $v['slug'];
			$stuct =  Classes::structure($slug);
			if(!$stuct) continue;
	 		foreach($stuct as $field=>$config){
	 			$fs[] = $field; 
	 		}
	 		$tables['node_'.$slug] = Arr::first($fs); 
	 		$table['node_'.$slug] = 'node_'.$slug;
		} 
		$data = array('table'=>$table,'tables'=>$tables);		
		return $data;
	}
	 
	
	/**
	* create formBuilder need field structure
	*/
 	static function structure($slug){
 		$cacheId = "modules_content_Class_structure{$slug}";
		$out = cache($cacheId);
		if(!$out){
	 		$one = DB::one('content_type_field',array(
	 				'where'=>array('slug'=>$slug,'pid'=>0),
	 				'orWhere'=>array('id'=>$slug), 
	 		));
	 		$all = DB::all('content_type_field',array(
	 			'where'=>array('pid'=>$one['id']),
	 			'orderBy'=>'sort desc, id asc',
	 		));   
	 		$field_id = $one['id'];
	 		$model = FieldView::find()->where(array('fid'=>$field_id))->one(); 
	 		$show_list = $model->list;
			$filter = $model->search;  
	 		foreach($all as $v){
	 			$n = $v['slug'];
	 			//get widget . widget is input/text/dropDonwList ...
	 			$w = DB::one('content_type_widget',array(
	 				'where'=>array('field_id'=>$v['id'])
	 			));
	 			$widget =  $out[$n]['widget'] = $w['name'];
	 			$out[$n]['widget_config'] = unserialize($w['memo']);
	 			//get validates
	 			$vali = DB::one('content_type_validate',array(
	 				'where'=>array('field_id'=>$v['id'])
	 			));
	 			// plugins
	 			$plugin = DB::one('content_type_plugin',array(
	 				'where'=>array('field_id'=>$v['id'])
	 			));
	 			$validates = unserialize($vali['value']); 
	 			$out[$n]['validates'] = $validates;
	 			$out[$n]['slug'] = $v['slug'];
	 			$out[$n]['name'] = $v['name'];
	 			$out[$n]['fid'] = $v['id'];
	 			$out[$n]['relate'] = $v['relate'];
	 			if($plugin['name']){ 
	 				$out[$n]['plugins'][$plugin['name']] = unserialize($plugin['memo']); 
	 			}
	 			$is_search = $is_list = 0;
	 			if($show_list && in_array($n,$show_list)){
	 				$is_list = 1;
	 			}
	 			if($filter && in_array($n,$filter)){
	 				$is_search = 1;
	 			}
	 			$out[$n]['list'] = $is_list;
	 			$out[$n]['filter'] = $is_search;
	 			if(!$widget) continue;
	 			$cls = "\application\modules\content\widget\\$widget\widget"; 
	 			$out[$n]['mysql'] = $cls::node_type(); 
	 		}
	 		cache($cacheId,$out);
	 	}
 	  
 		return $out;
 	}
 	static function default_columns(){
 		return array(
			'id',
			'display',
			'sort',
			'created',
			'updated',
			'admin',
			'uid'
		);
 	}
 	 
	 

 	 
 
}