<?php 
namespace application\modules\oauth\controllers; 
use application\core\DB;
use application\modules\auth\models\User;
/**
 * oauth comm controller
 * @author Sun <mincms@outlook.com>
 * @copyright 2013 The MinCMS Group
 * @license http://mincms.com/licenses
 * @version 2.0.1
*/
class OauthController extends \application\core\FrontController
{
	public $url;
	public $app_key;
	public $app_secret;
	public $oauth_id; 
	public $auth;
 
	function init(){
		parent::init(); 
		session_start(); 
		$admin = $_GET['admin']; 
		if($admin){
			$admin = decode($admin);
			if(uid() == $admin){ 
				\Yii::$app->session->set('oauth_admin_set',uid());
			}
		}
		$admin_login = $_GET['admin_login'];
		if($admin_login){
			\Yii::$app->session->set('oauth_admin_login',1);
		}
		  
	}
	function member_get_oauth_type($name){ 
		$row = DB::one('oauth_config',array(
			'where'=>array('slug'=>$name,'display'=>1)
		));
		return (object)$row;
	}
	function member_get_third_set_user($me,$oauth_id,$token){
		 
		$me['email'] = $me['email']?:'info';
		$uniqid = md5(uniqid(microtime()));
	 
		if(!$me['id']){
			flash('error',__('login failed'));
			$this->redirect(return_url());
		}
		$one = DB::one('oauth_users',array(
			'where'=>array(
				'uid'=>$me['id'],
				'oauth_id'=>$oauth_id
			)
		));
		if($one){
			DB::update('oauth_users',array( 
				'name'=>$me['name'],
				'email'=>$me['email'], 
				'token'=>$token,
				'uuid'=>$uniqid, 
			),"id=:id",array(':id'=>$one['id']));
		}else{
			DB::insert('oauth_users',array(
				'uid'=>$me['id'],
				'name'=>$me['name'],
				'email'=>$me['email'],
				'oauth_id'=>$oauth_id, 
				'token'=>$token,
				'uuid'=>$uniqid, 
			));
		}
		$one = DB::one('oauth_users',array(
			'where'=>array(
				'uuid'=>$uniqid,
				'oauth_id'=>$oauth_id, 
			)
		));
		if($one){
			$value = array(
				'id'=>$one['id'],
				'name'=>$one['name'],
				'email'=>$one['email'],
				'oauth'=>true
			);
			cookie('user',json_encode($value),0);
		}
		//bind admin account
		$sid = \Yii::$app->session->get('oauth_admin_set');
		if($sid>0){
			$auth_one = DB::one('auth_oauth',array(
				'where'=>array(
					'uid'=>$sid,
					'oauth_id'=>$one['id']
				)
			));
			if(!$auth_one){
				DB::insert('auth_oauth',array(
					'uid'=>$sid,
					'oauth_id'=>$one['id']
				));
			}  
			\Yii::$app->session->remove('oauth_admin_set');
		}
		hook('cart_init',array('mid'=>$one['id']));
		
		$login = \Yii::$app->session->get('oauth_admin_login');
		flash('success',__('login success'));
		
		if($login){
			// set admin login
			$user = DB::one('auth_oauth',array(
				'where'=>array( 
					'oauth_id'=>$one['id']
				)
			));
			$user = User::find($user['uid']); 
			if($user)
				\Yii::$app->user->login($user,0); 
			\Yii::$app->session->remove('oauth_admin_login');
			return_url(url('core/site/index')); 
		}  
	 
	}
}