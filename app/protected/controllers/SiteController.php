<?php namespace app\controllers; 
use application\core\MongoDB;

class SiteController extends \application\core\FrontController
{ 
	public $minify = false;
	//�������ݿ�,�ڰ�װ�ɹ�����ɾ��
	public $db = false;
	function init(){
		parent::init();
		$this->theme = 'default';
		 
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
