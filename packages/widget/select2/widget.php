<?php namespace application\widget\select2;  
/**
* 
* @author Sun < mincms@outlook.com >
*/
class Widget extends \yii\base\Widget
{ 
	public $i18n = false;
 	public $tag;
 	public $options;
 
	function run(){ 
		$base = publish(__DIR__.'/assets'); 
		css_file($base.'/select2/select2.css'); 
		js_file($base.'/select2/select2.js'); 
		 
	    js("
	    	$(function(){
	    		$('select').select2();
	    	});
	    
	    ");
    
	}
}