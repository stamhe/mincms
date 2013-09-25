<?php 
namespace application\modules\imagecache; 
use application\core\DB; 
use application\core\File;
use application\core\Url;
/**
 *  
 * @author Sun < mincms@outlook.com >
 * @Coprighty  http://mincms.com
 */
class Classes
{
	 static function get_origin($arr){
	 	 $img = $arr[1];
	 	 $img = str_replace('/imagine/','',$img);
	 	 $ext = \application\core\File::ext($img);
	 	 $img = substr($img,0 ,strrpos($img,'=')).$ext; 
	 	 return $img;
	 }
	 static function image($args){ 
	    $file = $args[1];
	    $option = $args[2]; 
	    if(!is_array($option)){
	    	$option = static::get_image($option);
	    } 
	    if(!$option) $option = array('resize'=>array(300,200,true,false));
		if(is_array($option)){
			$s = Url::short(serialize($option));
		} 
		$name = File::name($file);
		$ext = File::ext($file); 
		return base_url()."imagine/".$name."=$s{$ext}";
	}
	
	static function get_image($id){
		$cacheId = "table_imagecache_".$id;
		$one = cache($cacheId);
		if(!$one){
			$one = DB::one("imagecache",array(
				'where'=>array(
					'id'=>$id
				),
				'orWhere'=>array(
					'slug'=>$id
				),
			));
			if(!$one){
				return array();
			}
			$one['memo'] = unserialize($one['memo']);
			foreach($one['memo'] as $k=>$v){
				if(!in_array($k,$one['memo']['_type']))
					unset($one['memo'][$k]);
			}
			unset($one['memo']['_type']);
			$one = $one['memo'];
			cache($cacheId,$one);
		}
		return $one;
	}
}