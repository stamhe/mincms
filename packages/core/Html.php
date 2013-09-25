<?php namespace application\core;  
/**
*  extend yii\helpers\Html
* 
* @author Sun < mincms@outlook.com >
*/
class Html extends \yii\helpers\Html
{ 
	static function url($url,$parmas=null){
		$arr[] = '/'.$url; 
		if(is_array($parmas)){  
			$arr = array_merge($arr,$parmas);
		} 
		return \yii\helpers\Html::url($arr);
	}
	 
}