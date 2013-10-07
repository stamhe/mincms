<?php namespace application\core;  
/**
* array
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/
class Arr
{ 
	static $_tree;
	static $_ptree;
	static $_i = 0;
	static $_j = 0;
	static $tree; 
 	static $deep = 0; 
 	
 	static function first($arr){
 		if(!is_array($arr)) return;
		foreach($arr as $ar){
			return $ar;
		}
	}
	static function limit($arr , $limit = 1){
		$i = 0;
		foreach($arr as $ar){
			if($i< $limit){
				$array[] = $ar;
			}
			$i++;
		}
		return $array;
	}
	/**
	* 数组键相同时，值相加
	*/
	static function valueadd($a, $b){
	   if (is_array($a) && is_array($b)){ 
	    	foreach ($a as $k=>$v) { 
	    		if($k && $b[$k]){
	  				$arr[$k] = $v + $b[$k];
	     		} else {
	      			$arr[$k] = $v;
	     		}
	    	}
	    	return $arr+$b;
	   	}  
	}

 	/**
 	* 判断数组有没有值
 	*
 	$memo = $_POST['memo'];
	foreach($memo as $k=>$arr){ 
		if(Arr::null($arr)<1){ 
			unset($_POST['memo'][$k]);
		}
	}
 	*/
 	static function null($arr){
 		if(!is_array($arr)){
 			if(!empty($arr)) return 1;
 			return 0;
 		} 
 		foreach($arr as $k=>$v){
 			if(is_array($v)){
 				static::null($arr);
 			}
 			if(empty($v) || $v==null){
 				unset($arr[$k]);
 			}
 		} 
 		return count($arr);
 	}
 	 
	/**
	* 向下生成tree,返回的是数组 
	* 给select框使用
	
	$all = \application\modules\auth\models\Group::find()->all(); 
	$d = \application\core\Arr::tree($out);
	echo 'out:<br>';
	dump($d);
	*/
	static function model_tree($data=array(),$value='name',$id='id',$pid='pid',$root=0){   
		foreach($data as $v){ 
			$v = (object)$v;
			if($v->attributes)
				$out[$v->$id] = $v->attributes;
			else
				$out[$v->$id] = (array)$v;
		}  
		return static::tree($out,$value,$id,$pid,$root);  
	 
	}
	/**
	* 向下生成tree,返回的是数组 
	* 给select框使用
	
	$all = \application\modules\auth\models\Group::find()->all();
	foreach($all as $v){
		$out[$v->id] = $v->attributes;
	} 
	$d = \application\core\Arr::tree($out);
	echo 'out:<br>';
	dump($d);
	
	$all = Classes::all('taxonomy',array('orderBy'=>'sort desc,id desc'),true);   
 	foreach($all as $v){
		$taxonomy[$v->id] = $v;
	} 
	$all = \application\core\Arr::tree($taxonomy); 
	
	*/
	static function tree($data=array(),$value='name',$id='id',$pid='pid',$root=0){  
		static::$tree = array();
		$ids = static::_tree_id($data,$value,$id,$pid,$root);    
		$out = static::loop($data,$ids,$value);  
		return $out;
	}
	/**
	* 给tree方法使用。
	*/
	static function loop($data,$ids,$value,$j=0){   
		$span = ""; 
		for($i=0;$i<$j;$i++){
			$span .= "    "; 
		} 
		$j++; 
		if(is_array($ids)){
			foreach($ids as $id=>$vo){  
				$vi = (array)$data[$id];
				static::$tree[$id] = $span . $vi[$value]; 
				static::loop($data,$vo,$value,$j); 
			}
			$j = 0; 
		}
		return static::$tree;
	}
	
	static function deep($arr = array()){
		foreach($arr as $v){
			static::$deep++;
			if(is_array($v))
				static::deep($v);
			goto a;
		}
		a:
		return static::$deep;
	}
	/**
	* 返回树状的id结构
	*/
	static function _tree_id($data=array(),$value='name',$id='id',$pid='pid',$root=0){  
		foreach($data as $v){  
			$v = (object)$v;  
			if($v->$pid == $root){   
				$s = static::_tree_id($data,$value,$id,$pid,$v->id);    
				$_tree[$v->$id] = $s;  
			} 
		}  
		return $_tree;
	}
	/**
	* 向上生成tree
	*/
	static function parentTree($data=array(),$parent=null,$root=0,$value='name',$id='id',$pid='pid'){
		static::$_j = 0;
		if(static::$_j == 0){static::$_ptree=array();}
		foreach($data as $v){ 
			$out[$v->$id] = $v->$value; 
		}  
		foreach($data as $v){
			if($v->$id == $parent &&  $v->$pid != $root){  
				static::$_j++;
			 	static::parentTree($data,$v->$pid,$root,$value,$id,$pid); 
				
			} 
		} 
		static::$_ptree[$parent] = $out[$parent];  
		return  static::$_ptree;
	}
	/**
	* 判断一个数组的值，在另一个数组中。
	如 array('a') in array('c','a') return true;
	或  'a' in array('c','a') return true;
	* $a 支持数据或字符串
	*/
	static function array_in_array($a,$b){
		if(!is_array($b)) return false;
		if(!is_array($a)) $a = array($a);
		foreach($a as $v){
			if(!in_array($v,$b))
				return false;
		} 
		return true;
	}
}