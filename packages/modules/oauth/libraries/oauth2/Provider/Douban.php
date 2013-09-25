<?php namespace application\modules\oauth\libraries\oauth2\Provider; 
use application\modules\oauth\libraries\oauth2\Provider;
use application\modules\oauth\libraries\oauth2\Token\Access;
use application\core\Load;
/**
* douban.com api
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/
 

class Douban extends Provider
{
	public function url_authorize()
	{
		return 'https://www.douban.com/service/auth2/auth';
	}

	public function url_access_token()
	{
		return 'https://www.douban.com/service/auth2/token';
	}
	public function url_access()
	{
		return 'https://api.douban.com/v2/user/~me';
	}
	public function get_user_info(Access $token)
	{
		$t = urlencode($token->access_token);
		$user = Load::url($this->url_access(),array(
		  'http'=>array(
		    'method'=>"GET",
		    'header'=>"Accept-language: en\r\n" .
		              "Authorization: Bearer ".$t."\r\n"
		  )
		));
		$user = json_decode($user);  
		// Create a response from the request
		return array(
			'id' => $user->id, 
			'name' => $user->name, 
		);
	}
	

	 
}