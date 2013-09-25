<?php namespace application\modules\oauth\libraries\oauth2\Provider; 
use application\modules\oauth\libraries\oauth2\Provider;
use application\modules\oauth\libraries\oauth2\Token\Access;
/**
* github.com api
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/

class Github extends Provider
{
	public function url_authorize()
	{
		return 'https://github.com/login/oauth/authorize';
	}

	public function url_access_token()
	{
		return 'https://github.com/login/oauth/access_token';
	}

	public function get_user_info(Access $token)
	{
		$url = "https://api.github.com/user?".http_build_query(array(
			'access_token' => urlencode($token->access_token),
		)); 
		$user = json_decode(file_get_contents($url)); 
		// Create a response from the request
		return array(
			'uid' => $user->id,
			'nickname' => $user->login,
			'name' => $user->name,
			'email' => $user->email,
			'urls' => array(
			  'GitHub' => 'http://github.com/'.$user->login,
			  'Blog' => $user->blog,
			),
		);
	}
}