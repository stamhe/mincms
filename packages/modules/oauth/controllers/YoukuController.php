<?php namespace application\modules\oauth\controllers; 
use application\modules\oauth\libraries\oauth2\OAuth2;
use application\modules\oauth\libraries\oauth2\Token;
use application\modules\oauth\libraries\oauth2\Provider\Youku;
use application\core\Load;
use application\core\Arr;
/**
 * ## 优酷
 * @author Sun <mincms@outlook.com>
 * @copyright 2013 The MinCMS Group
 * @license http://mincms.com/licenses
 * @version 2.0.1
*/
class YoukuController extends OauthController
{ 
	public $type = 'youku'; 
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
 	public function actionIndex()
	{
	 	$code_url = Youku::url_authorize()."?client_id=".$this->app_key."&redirect_uri=".urlencode($this->url)."&response_type=code";
 		header("location:$code_url"); 
 		exit;
	}
	function actionReturn(){
		$this->auth = OAuth2::provider('Youku', array(
	    	'id' =>$this->app_key, 
	        'secret' => $this->app_secret, 
		));     
		$params['redirect_uri'] = $this->url;
		$params['grant_type'] = 'authorization_code';
		$o = $this->auth->access($_GET['code'],$params); 
		$access_token = $o->access_token;
		cache('oauth_youku'.cookie('guest_unique') , $access_token);
		cache('oauth_youku_expires'.cookie('guest_unique') , $o->expires);
		 
		$url = "https://openapi.youku.com/v2/users/myinfo.json?client_id=".$this->app_key."&access_token=".$access_token;  
		$data = json_decode(file_get_contents($url)); 
	 	if($data->id){
	 			$me['id'] = $data->id;
 				$me['name'] = $data->name;  
				$r = $this->member_get_third_set_user($me,$this->oauth_id,$access_token);   
		 	 	flash('success',__('login success'));
				$this->redirect(return_url());
	 	}else{
	 		flash('error',__('login error'));
			$this->redirect(return_url());
	 	}
	}
	
 
	 

 
}
