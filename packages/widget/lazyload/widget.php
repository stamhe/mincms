<?php namespace application\widget\lazyload;  
use yii\helpers\Json;
/**
* 
* @author Sun < mincms@outlook.com >
*/
class Widget extends \yii\base\Widget
{  
 	public $tag;
 	public $options; 
 	function run(){  
	 	$base = publish(__DIR__.'/assets');
	 	$this->options['placeholder'] = $this->options['placeholder']?:$base.'/default.png';
	 	$this->options['effect'] = $this->options['effect']?:'fadeIn';
		$opts =  Json::encode($this->options);
		  
 		if(!$this->tag) return;  
 		js(" 
 			$('".$this->tag."').lazyload($opts); 
 		"); 
 		js_file($base.'/jquery.lazyload.min.js'); 
	}
}