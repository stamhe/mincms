<?php namespace application\modules\oauth\libraries\oauth2\Provider; 
use application\modules\oauth\libraries\oauth2\Provider;
use application\modules\oauth\libraries\oauth2\Token\Access;
/**
* facebook.com api
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/

class Facebook extends Provider
{
	protected $scope = array('offline_access', 'email', 'read_stream');

	public function url_authorize()
	{
		return 'https://www.facebook.com/dialog/oauth';
	}

	public function url_access_token()
	{
		return 'https://graph.facebook.com/oauth/access_token';
	}

	public function get_user_info(Access $token)
	{
		$url = 'https://graph.facebook.com/me?'.http_build_query(array(
			'access_token' => $token->access_token,
		));

		$user = json_decode(file_get_contents($url));

		// Create a response from the request
		return array(
			'uid' => $user->id,
			'nickname' => isset($user->username) ? $user->username : null,
			'name' => $user->name,
			'first_name' => $user->first_name,
			'last_name' => $user->last_name,
			'email' => isset($user->email) ? $user->email : null,
			'location' => isset($user->hometown->name) ? $user->hometown->name : null,
			'description' => isset($user->bio) ? $user->bio : null,
			'image' => 'https://graph.facebook.com/me/picture?type=normal&access_token='.$token->access_token,
			'urls' => array(
			  'Facebook' => $user->link,
			),
		);
	}
}
