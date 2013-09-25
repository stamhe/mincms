<?php namespace application\core;  
/**
* dir class
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/
class Dir 
{ 
    /**
    * keep list array
    */
	static $kep_list_file; 
	/**
	* list dir files and dirs
	*
	* Example:
	* <code> 
	* use \application\core\Dir;
	* Dir::listFile('public'); 
	* </code>  
	* @param  string $dir   controller/action
	* @param  string $contain  seach key. like 'Contorller' or 'Controller,Model' 
	* @param  string $uncontain  uncontian key.
	*/ 
	static	function listFile($dir,$contain=null,$uncontain=null)
	{    
		$tag = true;
		if(substr($dir,-1)!='/'){
			$dir.='/';
		} 
		$list = scandir($dir);
		foreach($list as $vo){   
			if($vo !="."&& $vo !=".." && $vo !=".svn" )
			{ 
				$k = md5($dir.$vo);
				if($contain){  
					//并且的搜索,以,英文下豆号分隔 
					$douSearch = explode(',',$contain);
					$cnum = count($douSearch);
					if($cnum>1){
						foreach($douSearch as $dou){ 
							$s = strstr($dir.$vo, $dou);
							$tag = $tag && $s; 
						} 
						if($uncontain){ 
							$t = self::_listFile($dir.$vo,$uncontain);
							$tag = $tag && $t;
						} 
					}
					else{ 
						if (strpos($dir.$vo, $contain) === false)
							goto a;
						if($uncontain){ 
							$t = self::_listFile($dir.$vo,$uncontain);
							$tag = $tag && $t;
						}  
					} 
					if (!$tag)
					{
						if(is_dir($dir.$vo) && $vo !="Thumbs.db" && $vo !="."&& $vo !=".." && $vo !=".svn" ){
							 self::listFile($dir.$vo.'/'.$vo2,$contain,$uncontain);
						} 	
					}
				}
				
				self::$kep_list_file['file'][$k] = $vo;
				self::$kep_list_file['dir'][$k] = $dir.$vo;  
			}
			a:
			if(is_dir($dir.$vo) && $vo !="Thumbs.db" && $vo !="."&& $vo !=".." && $vo !=".svn" ){
				 self::listFile($dir.$vo.'/'.$vo2,$contain,$uncontain);
			} 
		}
		return self::$kep_list_file;
	}
	/**
	* inner function can't use as Function.
	*
	* it is for listFile function
	*/
	static function _listFile($value,$string){
		$tag = true;
		$array = explode(',',$string);
		$num = count($array);
		if($num>1){
			foreach($array as $item){ 
				$s = strstr($value, $item);
				$tag = $tag && $s; 
			} 
		}
		else{ 
			$t = !strstr($value, $string);
			$tag = $tag && $t; 
		}
		return $tag;
	}	
 

	/**
	 * mkdir
	 */
	static function mkdir($dir, $mode = 0755)
	{
		if (is_dir($dir) || @mkdir($dir,$mode)) return true;
		if (!self::mkdir(dirname($dir),$mode)) return false;
		return @mkdir($dir,$mode);
	}
	/**
	* return dir 
	*/
	static function dir($file_name){ 
		return substr($file_name,0, strrpos($file_name,'/'));
	}
 	/**
	* return file_name 
	*/
	static function file_name($file_name){
		return substr($file_name,strrpos($file_name,'/')+1);
	}
 		 
}