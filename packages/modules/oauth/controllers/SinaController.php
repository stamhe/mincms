<?php namespace application\modules\oauth\controllers; 
use application\core\Load;
 
/**
 * ## 新浪微博
 * @author Sun <mincms@outlook.com>
 * @copyright 2013 The MinCMS Group
 * @license http://mincms.com/licenses
 * @version 2.0.1
*/
class SinaController extends OauthController
{
 
	public $type = 'sina';
 	/**
 	* load some required files
 	*/
	function init(){
		parent::init(); 
		import ('@application/modules/oauth/libraries/sina/SaeTOAuthV2'); 
	 	$row = $this->member_get_oauth_type($this->type);
		if(!$row->id){
			exit('access deny');
		} 
		$this->oauth_id = $row->id; 
		$this->app_key = $row->key1;
		$this->app_secret = $row->key2;
		$this->url = host().url('oauth/'.$this->type.'/return'); 
        session_start();  
		
	}
 	public function actionIndex()
	{
	 	$o = new \SaeTOAuthV2( $this->app_key , $this->app_secret );  
		$code_url = $o->getAuthorizeURL($this->url);  
		header("location:$code_url"); 
 		exit;
	}
	
	function actionReturn(){ 
		$o = new \SaeTOAuthV2( $this->app_key , $this->app_secret); 
		if ($_REQUEST['code']) {
			$keys = array();
			$keys['code'] = $_REQUEST['code'];
			$keys['redirect_uri'] = $this->url;
			try {
				$token = $o->getAccessToken( 'code', $keys ) ;
				$access_token = $token['access_token'];
				$c = new \SaeTClientV2($this->app_key , $this->app_secret, $access_token );  
				$uid_get = $c->get_uid();
				$uid = $uid_get['uid']; 
				$me = $c->show_user_by_id($uid );   
				$me['name'] = $me['screen_name'];
				$me['options'] = array('url'=>$me['profile_url']);
			 	$r = $this->member_get_third_set_user($me,$this->oauth_id,$access_token);   
				
		 	 	flash('success',__('login success'));
				$this->redirect(return_url());
				
			} catch (OAuthException $e) {
				flash('error',__('login error'));
				$this->redirect(return_url());
			}
		}
		exit; 
	}

 
}
