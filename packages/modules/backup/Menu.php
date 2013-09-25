<?php 
namespace application\modules\backup; 
class Menu
{
	static function add(){
		$menu['extend'] = array( 
			'database backup'=>array('backup/admin/index'),   
		);
		return $menu;
	}
}