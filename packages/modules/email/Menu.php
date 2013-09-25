<?php 
namespace application\modules\email; 
class Menu
{
	static function add(){
		$menu['system'] = array( 
			'mail'=>array('email/config/index'), 
			'mail template'=>array('email/template/index'), 
		);
 
		return $menu;
	}
}