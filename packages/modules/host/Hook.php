<?php 
namespace application\modules\host; 
use application\modules\core\Classes;
use application\core\DB;
use application\core\Str;
class Hook
{
	static function action_init(){
		$value = Classes::get_config('module_host');
		if($value==1){
			$all = DB::all('host');
			if(!$all) return;
			foreach($all as $v){
				$url = $v['url'];
				$redirect = $v['redirect']; 
				$arr[$url] = $redirect;
			}
			$host = Str::new_replace(host(),array(
				'http://'=>'',
				'https://'=>'',
			)); 
			if($arr[$host]){
				redirect("http://".$arr[$host].$_SERVER['REQUEST_URI']);
			} 
		}
	}
	 
}