<?php 
namespace application\modules\theme; 
class Menu
{
	static function add(){
		$menu['extend'] = array( 
			'theme'=>array('theme/admin/index'), 
		);
		return $menu;
	}
}