<?php namespace application\widget\icheck;  
use yii\helpers\Json;
use yii\helpers\Html;
/**
* icheck widget
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @link http://damirfoy.com/iCheck/   offical website 
* @link http://mincms.com/demo-icheck.html   demo
* @version 2.0.1
*/

class Widget extends \yii\base\Widget
{  
	 
 	/**
 	* array options
 	*/
 	public $options;  
 	/**
 	* skin set values square/flat/minimal/
 	*/
 	public $skin = 'flat';
 	/**
 	* color
 	*/
 	public $color = 'blue';
 	/**
	*  
	* Example :
	*  
	* <code> 
	*	widget('icheck' , array(
	*		'skin'=>'flat', 
	*		'color'=>'blue'
	*	));
	*</code> 
	*/ 
	function run(){   
		$base = publish(__DIR__.'/assets');   
	 	$this->options['checkboxClass'] = $this->options['checkboxClass']?:'icheckbox_'.$this->skin;
	 	$this->options['radioClass'] = $this->options['radioClass']?:'iradio_'.$this->skin;
	 	if($this->color){
	 		$this->options['checkboxClass'] .= "-".$this->color;
	 		$this->options['radioClass'] .= "-".$this->color;
	 	}
	 	
		$opts = Json::encode($this->options);    
 	
		js("$('input').iCheck($opts);");    
	  
	 	$skin = $this->skin."/".$this->skin;
	  	$color = $this->skin."/".$this->color;
		css_file($base.'/skins/'.$skin.'.css');
		css_file($base.'/skins/'.$color.'.css');
		css_file($base.'/skins/flat/blue.css');
		js_file($base.'/jquery.icheck.min.js');  
		 
	}
}