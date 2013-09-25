<?php 
namespace application\modules\auth; 
use application\core\DB;
class Auth
{
	/**
	* where uid in 
	*/
	static function in(){
		 $uid = \Yii::$app->user->identity->id;  
		 return array($uid);
	}
	static function user($id){
		$k = 'user_id'.$id;
		$one = cache($k);
		if(!$one){
			$one = (object)DB::one('auth_users',array(
				'where'=>array('id'=>$id)
			));
			cache($k , $one);
		}
		return $one;
	}
}