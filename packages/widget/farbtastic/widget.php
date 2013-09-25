<?php namespace application\widget\farbtastic;  
use yii\helpers\Json;
/**
* farbtastic widget
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @link https://github.com/mattfarina/farbtastic    offical website
* @link http://mincms.com/demo-farbtastic.html   demo
* @version 2.0.1
*/
class Widget extends \yii\base\Widget
{  
 	public $tag;
 	public $options;
 	public $to;
	function run(){ 
		if($this->options)
			$opts = Json::encode($this->options);
		$base = publish(__DIR__.'/assets');  
	    js("
	    	$(function(){
	    		$('".$this->tag."').farbtastic('".$this->to."');
	    	});
	    
	    ");
	    css_file($base.'/farbtastic.css'); 
		js_file($base.'/farbtastic.js'); 
	    
	}
}