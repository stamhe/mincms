<?php 
namespace application\modules\payment; 
class Menu
{
	static function add(){ 
		$menu['extend'] = array( 
			'payment'=>array('payment/admin/index'),  
		); 
		return $menu;
	}
}