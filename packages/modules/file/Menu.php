<?php 
namespace application\modules\file; 
class Menu
{
	static function add(){ 
		$menu['system'] = array( 
			'file'=>array('file/site/index'),   
		); 
		return $menu;
	}
}