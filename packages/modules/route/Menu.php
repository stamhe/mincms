<?php 
namespace application\modules\route; 
class Menu
{
	static function add(){
		$menu['system'] = array( 
			'route'=>array('route/site/index'), 
		); 
		return $menu;
	}
}