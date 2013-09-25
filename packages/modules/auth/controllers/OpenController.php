<?php namespace application\modules\auth\controllers;
use application\core\FrontController;
use application\modules\auth\models\LoginForm;   
use application\modules\auth\models\Forgot;
use application\modules\email\Mailer;
use application\core\Str;
use yii\helpers\Html;
use application\core\DB;
use application\modules\auth\models\User;
/**
* very one can visit
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/

class OpenController extends FrontController
{  
	public $_access; 
	public function init(){
		parent::init();
		$this->theme = 'admin';   
	}
	
	public function actions()
	{
		return array(
			'captcha' => array(
				'class' => 'yii\captcha\CaptchaAction', 
				'transparent'=>true,
				'testLimit'=>3,
				'minLength'=>3,
				'maxLength'=>4
			),
		);
	} 
	
	public function actionLogin()
	{    
		$model = new LoginForm();
		if ($model->load($_POST) && $model->login()) {
			redirect(url('core/site/index'));
		} else {
			return $this->render('login', array(
				'model' => $model,
			));
		}
	}
	public function actionForgot()
	{
		
		$model = new Forgot;
		if ($model->load($_POST) && $model->validate()) {
			$name = $model->username;
			$t = Mailer::template('admin_forgot_password'); 
			$body = $t->body;
			$body = str_replace('{username}',$name,$body);
			$code = Str::srand(10);
		 	$body = str_replace('{link}',Html::a(__('reset password'),host().url('auth/open/reset',array('id'=>encode($model->id),'code'=>encode($code)))),$body);
		 
		 	DB::insert('auth_user_reset',array(
		 		'uid'=>$model->id,
		 		'code'=>$code,
		 		'created'=>time()
		 	)); 
		 	Mailer::send($t->title,$body,$model->email); 
		 	flash('success',__('confirm reset password email had send,please check you email'));
		 	$this->redirect(url('auth/open/login'));
		}
		return $this->render('forgot', array(
			'model' => $model,
		));		
	 
	}
	public function actionReset($id,$code)
	{
		$id = (int)decode($id);
		$code = decode($code);
	 	if($id<1) throw new \Exception(__('reboot'));
	 	$one = DB::one('auth_user_reset',array(
		 	'where'=>array(
		 		'uid'=>$id,
		 		'code'=>$code, 
		 	)
		 ));
	 
		if(!$one) throw new \Exception(__('reboot'));
		
		$code = Str::srand(9);
		$user = User::find($id);
		$user->scenario = 'reset';
		$user->new_password = $code;
		$user->save();
		
		$t = Mailer::template('admin_reset_password'); 
		$body = $t->body;
		$body = str_replace('{username}',$user->username,$body); 
	 	$body = str_replace('{password}',$code,$body);
		
		Mailer::send($t->title,$body,$user->email); 
	 	flash('success',__('reset password email had send,please check you email'));
	 	$this->redirect(url('auth/open/login'));  
	}

	public function actionLogout()
	{
		\Yii::$app->getUser()->logout();
		redirect(url('auth/open/login'));
	}

	 
}
