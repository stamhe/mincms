<?php namespace application\widget\prettify;  
/**
* class: prettyprint lang-js linenums
* https://code.google.com/p/google-code-prettify/wiki/GettingStarted
* <pre class="prettyprint">
*    	 <?php echo file_get_contents(base_path().'../composer.json');?>	 
* </pre>
* need't add code to <body
* <body  onload="prettyPrint()">
* @author Sun < mincms@outlook.com >
*/
class Widget extends \yii\base\Widget
{  
 	public $tag;
 	public $options;  
 	public $theme = 0;
	function run(){  
	$base = publish(__DIR__.'/google-code-prettify'); 
 		js_file($base.'/prettify.js'); 
 	//js_file('https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js');
 		css_file($base.'/theme/'.$this->theme.'.css'); 
 	 	js("prettyPrint();");
 	 
	}
}