<?php namespace application\core;
/**
*  all admin controllers should be exnteds this controller
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/ 
class AuthController extends Controller
{ 
	private $supperUsers = array(1);
	//部分允许操作列表
	public $_allowAccess = array();
	public $_skip = false;
	public $theme = 'admin';
	public $full_action;
	public $minify = false; 
	//所有允许的操作列表
	public $_access;
	function init(){
		parent::init();  
	 	language('language_');  
	 	if(\Yii::$app->user->isGuest){ 
			flash('error',__('login first'));   
			header('Location: '.url('auth/open/login'));  
			exit;
		}       
		\Yii::$app->session->open();
		hook('action_init_auth',$this);   
	  
	}
	/**
	* request 前
	*/
	function beforeAction($action){  
		parent::beforeAction($action);   
		if(\Yii::$app->user->isGuest){ 
			exit;
		}
		//判断用户是否有权限
		$url = $action->controller->id.'.'.$action->controller->action->id;
		$module = $action->controller->module->id; 
		if($module && $module!=$action->id)
			$url = $module.'.'.$url; 
		//所当前的URL 传入判断权限   
		$this->full_action = $url;
		$this->checkUserAccess($url);    
		return true;
	}
	/**
    * check access
    */
    protected function checkUserAccess($action_id){  
    	$uid = \Yii::$app->user->identity->id;//当前用户ID
     	$this->_access =\application\modules\auth\models\User::access($uid);   
    	if(in_array($uid,$this->supperUsers)) return true; 
    	if(true === $this->_skip ) return true;
    	if(is_array($this->_allowAccess) && in_array($action_id,$this->_allowAccess)) return true;  
    	if(!$this->_access || !in_array($action_id,$this->_access)){
    	  	throw new \Exception(__('access deny'));
    	}
    	
    }

	 
}
