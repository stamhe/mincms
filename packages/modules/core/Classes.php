<?php 
namespace application\modules\core; 
use application\core\DB;
class Classes
{
	
	static function get_config($name){
		$one = DB::one('core_config',array(
			'where'=>array('slug'=>$name) 
		));
		return $one['body'];
	}
	static function set_config($name,$value){
		$one = DB::one('core_config',array(
			'where'=>array('slug'=>$name) 
		));
		if($one){
			DB::update('core_config',array(
				'body'=>$value
			),'slug=:slug',array(':slug'=>$name));
		}else{
			DB::insert('core_config',array(
				'slug'=>$name,
				'body'=>$value
			));
		}
		
	}
	static function set_config_lock($name,$value){
		$one = DB::one('core_config',array(
			'where'=>array('slug'=>$name) 
		));
		if($one){
			DB::update('core_config',array(
				'body'=>$value
			),'slug=:slug',array(':slug'=>$name));
		}else{
			DB::insert('core_config',array(
				'slug'=>$name,
				'body'=>$value,
				'lock'=>1
			));
		}
		
	}

}