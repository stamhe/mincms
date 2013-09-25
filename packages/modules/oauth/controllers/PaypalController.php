<?php namespace application\modules\oauth\controllers; 
use application\modules\oauth\libraries\oauth2\OAuth2;
use application\modules\oauth\libraries\oauth2\Token;
use application\modules\oauth\libraries\oauth2\Provider\Youku;
use application\core\Load;
use application\core\Arr;
/**
 * ## 贝宝 Paypal
 * @author Sun <mincms@outlook.com>
 * @copyright 2013 The MinCMS Group
 * @license http://mincms.com/licenses
 * @version 2.0.1
*/
class PaypalController extends OauthController
{ 
	public $type = 'paypal'; 
 	/**
 	* load some required files
 	*/
	function init(){
		parent::init(); 
	 	$row = $this->member_get_oauth_type($this->type);
		if(!$row->id){
			exit('access deny');
		} 
		$this->oauth_id = $row->id; 
		$this->app_key = $row->key1;
		$this->app_secret = $row->key2;
		$this->url = host().url('oauth/'.$this->type.'/return');  
	 
	}
 	 
	function actionReturn(){
		$this->auth = OAuth2::provider('Paypal', array(
	    	'id' =>$this->app_key, 
	        'secret' => $this->app_secret, 
		));     
		$params['redirect_uri'] = $this->url;
		$params['grant_type'] = 'authorization_code';
		$o = $this->auth->access($_GET['code'],$params); 
		$access_token = $o->access_token;
		$this->auth =  OAuth2::provider('Paypal', array(
	    	'id' =>$this->app_key, 
   			'secret' => $this->app_secret, 
	    ));  
        
        $url = 'https://api.paypal.com/v1/identity/openidconnect/userinfo/?schema=openid&access_token=' . $access_token; 
        $data = json_decode(file_get_contents($url));  
	 	if($data){
	 			//https://www.paypal.com/webapps/auth/identity/user/7RF98wL_m56OYSB1Ri1mXTnY
	 			$me['id'] = md5($data->user_id);
 				$me['name'] = $data->email;  
 				$me['email'] = $data->email;
				$r = $this->member_get_third_set_user($me,$this->oauth_id,$access_token);   
		 	 	flash('success',__('login success'));
				echo "<script>
				window.opener.location.reload(true);
				this.window.opener = null;  
				window.close(); 
				</script>";
	 	}else{
	 		flash('error',__('login error'));
			$this->redirect(return_url());
	 	}
	}
	
 
	 

 
}
