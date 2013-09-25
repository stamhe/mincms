<?php namespace application\modules\oauth\widget;  
use application\core\DB;
/**
* 
* @author Sun < mincms@outlook.com >
*/
class Login extends \yii\base\Widget
{ 
 	public $img = true;
 	public $admin = false;
 	public $admin_login = false;
	function run(){ 
		$base = publish(__DIR__.'/../assets');
		
		$rows = DB::all('oauth_config',array('orderBy'=>'sort desc,id desc','where'=>array('display'=>1)));
		echo $this->render('@application/modules/oauth/widget/views/login',array(
			'rows'=>$rows,
			'img'=>$this->img,
			'base'=>$base,
			'admin'=>$this->admin,
			'admin_login'=>$this->admin_login,
		));
	 
	}
}