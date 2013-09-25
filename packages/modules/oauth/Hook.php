<?php 
namespace application\modules\oauth;  
use application\core\DB;
use application\core\Str;
class Hook
{
	static function action_before(){
		$d = cache('oauth_setting');
		if(!$d){
			$d = DB::all('oauth_config');
			if($d){
				foreach($d as $v){
					$out[$v['slug']] = array('key1'=>$v['key1'],'key2'=>$v['key2']);
				}
				cache('oauth_setting' , $out);
			}
		}
	}
	 
}