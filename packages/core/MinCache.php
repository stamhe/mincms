<?php
/**
* 在框架运行前
* cache_pre($name,$value,$expre);
* cache_pre_delete($name);
* @author Sun < mincms@outlook.com >
* @since Yii 2.0
*/

class MinCache{
	static $type;
	static $obj;
	static $file;
	/**
	* 搜索在@application 与 @app下的文件
	*/
	static function muit_dir_list($dir){
		$application  = \Yii::getAlias('@applicatin/'.$dir);
		
	}
	static function modules($flg = false){
		global $app; 
		$a  = $app['application'].'/modules'; 
		$b  = $app['app'].'/modules'; 
		$list = scandir($a);
		foreach($list as $vo){  
			if($vo !="."&& $vo !=".." && $vo !=".svn" )
			{ 
				$aa[$vo] = "application";
			}
		}
		$list = scandir($b);
		foreach($list as $vo){  
			if($vo !="."&& $vo !=".." && $vo !=".svn" )
			{ 
				$bb[$vo] = "app";
			}
		}
		if($flg===true){
			if($bb)
				return array_merge($aa,$bb);
			return $aa;
		}
		if($bb){
			$c = array_intersect_key($aa,$bb); 
			if($c) return array('##'=>$c); 
		}
		
	}
	static function key($name){
		$host = $_SERVER['HTTP_HOST'];
		$host = str_replace("http://",'',$host);
		$host = str_replace("https://",'',$host);
		return md5($host.'.'.$name); 
		
	}
	static function set($name,$value=null){ 
		$name = static::key($name); 
		if(extension_loaded('memcache')){ 
			if(!static::$obj){
				static::$obj = new Memcache;
				static::$obj->connect('127.0.0.1', 11211) or die ("memcache is enable but not work, 127.0.0.1 11211");  
		 		static::$type = 'memcache'; 
	 		}
			if($value){
				static::$obj->set($name, $value ,false ,0 ); 
			 	return $value;
			}else
				return static::$obj->get($name);
	 	}elseif(extension_loaded('apc')){ 
	 		static::$type = 'apc';
			if($value){
				apc_add($name, $value);
				return $value;
			}
			else
				return apc_fetch($name);
	 	}
	 	else{ 
	 		global $app;
	 		$runtime = $app['runtimePath'];
	 		if($runtime)
	 			static::$file = $file = $runtime.'/'.md5($name).'.php';
	 		else
				static::$file = $file = __DIR__.'/../../runtime/'.md5($name).'.php';
			 
			if(!$value){
				if(!file_exists($file)) return false;
				return unserialize(include $file);
			} 
			$str = "<?php return '";
			$str .= serialize($value);
			$str .= "';";
			file_put_contents($file,$str);
			return $value;
		}
	}
	static function delete($name){ 
		$name = static::key($name); 
		if(static::$type == 'memcache'){
			static::$obj->delete($name);
		}elseif(static::$type == 'apc'){
			apc_delete($name);
		}else{
			@unlink(static::$file);
		}
	}  
	
}