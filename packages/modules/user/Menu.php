<?php 
namespace app\modules\user; 
class Menu
{
	static function add(){ 
		$menu['extend'] = array( 
			'member'=>array('user/site/index'), 
		 
		); 
		return $menu;
	}
}