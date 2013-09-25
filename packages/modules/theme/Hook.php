<?php 
namespace application\modules\theme; 
use application\modules\core\Classes; 
class Hook
{
	static function action_init_front(){ 
		$arr = func_get_args();
 		$obj = $arr[0]; 
		$value = Classes::get_config('_theme_front');  
	 	if($value){ 
			$obj->theme = $value;
		} 
		if($obj->theme != 'default') return; 
	 
	}
 	static function action_init_auth(){
 		$arr = func_get_args();
 		$obj = $arr[0]; 
		$value = Classes::get_config('_theme_admin'.uid());  
		if($value){ 
			$obj->theme = $value;
		}
	}
}