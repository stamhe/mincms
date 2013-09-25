<?php namespace application\core;  
use application\core\DB;
/** 
 *
* @author Sun < mincms@outlook.com >
* @date 2013
*/
class Url{
	
	static function short($url){
		$old_url = $url;
	    $url= crc32($url);
	    $result= sprintf("%u", $url);
	    $sUrl= '';
	    while($result>0){
	        $s= $result%62;
	        if($s>35){
	            $s= chr($s+61);
	        } elseif($s>9 && $s<=35){
	            $s= chr($s+ 55);
	        }
	        $sUrl.= $s;
	        $result= floor($result/62);
	    }
	    static::insert($old_url,$sUrl);
	    return $sUrl;
	}
	static function short_back($short){
	     $id = "table_core_shorturl_".$short;
		 $one = cache($id);
		 if(!$one){
			$one = DB::one('core_shorturl',array(
				'select'=>'url,short',
				'where'=>array(
					'short'=>$short
				)
			)); 
			cache($id,$one);
		}
		 return $one['url'];
	}
	
	static function insert($url,$short){
		$one = static::get($url,$short);
		if(!$one){
			DB::insert('core_shorturl',array( 
				'url'=>$url,
			 	'short'=>$short,
			));
		}
	}
	
	static function get($url,$short){
		$id = "table_core_shorturl_".$short; 
		$one = cache($id);
		if(!$one){
			$one = DB::one('core_shorturl',array(
				'select'=>'url,short',
				'where'=>array(
					'url'=>$url
				)
			)); 
			cache($id,$one);
		}
		return $one;
	}
 
	 
}