<?php 
namespace application\modules\imagecache; 
class Menu
{
	static function add(){ 
		$menu['system'] = array( 
			'image cache'=>array('imagecache/admin/index'),   
		); 
		return $menu;
	}
}