<?php 
namespace application\modules\auth;  
use application\core\DB; 
use yii\helpers\Html;
class Hook
{
	 
	static function backend_admin_page($obj){
		if(!module_exists('email')) return;
		$one = DB::one('email_template',array(
			'where'=>array('slug'=>'admin_forgot_password')
		));
		if(!$one)
			$str = "<div class='alert alert-danger'>".__('email module template not set'). Html::a(__('template'),url('email/template/create',array('id'=>'admin_forgot_password'))).'</div>';
		$one = DB::one('email_template',array(
			'where'=>array('slug'=>'admin_reset_password')
		));
		if(!$one)
			$str .= "<div class='alert alert-danger'>".__('email module template not set'). Html::a(__('template'),url('email/template/create',array('id'=>'admin_reset_password'))).'</div>';
		
		return $str;
	}
	
	 
}