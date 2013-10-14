<?php namespace app\controllers; 
use application\core\MongoDB;

class SiteController extends \application\core\FrontController
{ 
	public $minify = false;
	//启用数据库,在安装成功后请删除
	public $db = false;
	function init(){
		parent::init();
		$this->theme = 'default';
		//安装完成后可删除
		MinCache::delete('all_modules_alias');
		MinCache::delete('all_modules');
		MinCache::delete('hooks');
	}
	public function actions()
	{
		return array(
			'captcha' => array(
				'class' => 'yii\web\CaptchaAction',
				'fixedVerifyCode' => YII_ENV === 'test' ? 'testme' : null,
			),
		);
	}
 
	public function actionIndex()
	{     
		$data['url'] = $url;
		return $this->render('index',$data);
	}
	
	
	 
 
 
	 
}
