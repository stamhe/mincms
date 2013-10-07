<?php namespace application\core;  
/**  
*
* @author Sun < mincms@outlook.com >
* @date 2013
*/
class Curl{
	/**
	* CURL GET
	* data 可以使用 http_build_query
	*/
	static function get($url,$data ,$header = null,$show_header = false,$method = 'GET'){
		if(is_array($header)){
	 		foreach($header as $k=>$v){
	 			$http .= "$k:$v \r\n";
	 		}
	 	}
		$opts = array('http' =>
		    array(
		        'method'  => $method,
		        'header'  => 
		    		"Content-Type: application/x-www-form-urlencoded; charset=UTF-8 \r\n".
		   			"Accept-Language: zh-cn  \r\n".
		   			"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8  \r\n".
       				"Accept-Encoding: gzip, deflate \r\n".
        			"Cache-Control:no-cache \r\n".        		
		    		"User-Agent:Mozilla/5.0 (Windows NT 6.1; rv:23.0) Gecko/20100101 Firefox/23.0 \r\n".
		    		$http, 
		   		'content' => $data
		    )
		); 
		return static::file_get_contents($url ,$opts,$show_header);
	}
	/**
	* CURL POST
	* data 可以使用 http_build_query
	*/
	static function post($url,$data ,$header = null,$show_header = false){
		return static::get($url,$data ,$http,$show_header,'POST');
	}
	/**
	*   建议直接使用 post/get 方法
	*/
	static function file_get_contents($url,$opts=null,$header = false){
		if(null==$opts) return file_get_contents($url);
		$context = stream_context_create($opts); 
		$content = file_get_contents($url, false, $context);
		if(true === $header){
			return array('content'=>$content,'header'=>$http_response_header);
		}else			 
			return $content;
	}
	/** 
	* 取得 static::file_get_contents 返回的COOKIE
	* 返回数组
	* <code> 
	* 	$rt = Curl::post($url,$opts,null,true);
	* 	$content = json_decode($rt['content']);
	* 	$cookie = Curl::cookie($rt['header']); 
	* 	unset($cookie['Path']);
	* 	$cook = http_build_query($cookie);
	* 	$cook = str_replace('&','; ',$cook); 
	*   echo $cook;
	* </code>
	*/
	static function cookie($header){
		preg_match_all( "/Set-Cookie:(.*?)(.*)/" , implode( "\r\n" ,  $header ),  $cookies );
		$cook = $cookies[2];
		if(!$cook) return ; 
		$cook = implode(';',$cook);
		$cook = explode(';',$cook);
		foreach($cook as $v){
			if(strpos($v , '=') !== false){
				$a = substr($v ,0 , strpos($v , '=') );
				$b = substr($v , strpos($v , '=')+1); 
				$vo[trim($a)] = $b;
			}
		}  
		return $vo;
	} 
}