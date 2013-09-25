<?php 
namespace app\modules\user; 
use application\core\DB;
/**
 *  
 * @author Sun < mincms@outlook.com >
 * @Coprighty  http://mincms.com
 */
class Auth
{
	/**
	* 返回用户信息
	*
	*/
	static function get_member($id){
		$cacheId = 'get_member_'.$id;
		$one = \Yii::$app->cache->get($cacheId);
		if(!$one){
			$one = DB::one('oauth_users',array(
				'where'=>array('id'=>$id)
			));
			$one = (object)$one;
			\Yii::$app->cache->set($cacheId,$one,86400*360*360);
		}
		return $one;
	}
	/**
	* 返回会员ID
	*/
	static function id(){
		$info = static::info();
		return $info->id?:0;
	}
	static function check(){
		return static::is_login();
	} 
	static function is_login(){ 
		$info = static::info();
		if($info && $info->id){
			return true;
		}
		return false;
	}
	static function info(){ 
		$value = cookie('user'); 
		$value = (object)json_decode($value); 
		return $value;
	}
	static function logout(){ 
		remove_cookie('user');  
	}
}