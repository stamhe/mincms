<?php 
namespace application\modules\content; 
 
class Hook
{
 	static function backend_admin_page($obj){
		return "<div class='alert alert-info'>".__('custom content is actived').'</div>';
	}
	 
}