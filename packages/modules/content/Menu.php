<?php 
namespace application\modules\content; 
class Menu
{
	static function add(){
		$menu['content'] = array(  
			'content type'=>array('content/site/index'),  
		);
	 
			
	 
		return $menu;
	}
}