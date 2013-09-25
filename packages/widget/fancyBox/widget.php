<?php namespace application\widget\fancyBox;  
use yii\helpers\Json;
use yii\helpers\Html;
use yii\web\JsExpression;
/**
* fancyBox widget
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @link http://fancyapplications.com/fancybox/    offical website 
* @version 2.0.1
*/

class Widget extends \yii\base\Widget
{  
	/**
	* html element
	*/
 	public $tag; 
 	/**
 	* theme support 1 to 5
 	*/ 
 	public $theme = 1;
 	/**
 	* array options
 	*/
 	public $options; 
  
 	/**
	*  
	* Example 
	*  
	* <code> 
	* class="fancybox fancybox.ajax"
	* <a class="fancybox" rel="group" href="big_image_1.jpg">
	*	widget('fancyBox',array(
	*		'tag'=>'.insertCK', 
	*       'options'=>array()
	*	));
	*</code> 
	*/ 
	function run(){   
		$base = publish(__DIR__.'/assets');    
	 	$options['canTag'] = false;
		$options['canDelete'] = false;
		$jtag = Json::encode($options);   
	 	$this->options['afterShow'] = $this->options['afterShow']?new JsExpression("
	 		function(){
	 				var img = $('.fancybox-inner .fancybox-image');
	 				$('.fancybox-inner').applicationend('<div clsss=jTagTag ></div>');
			 		var url = img.attr('src');
			 		$.post('".url('file/tag/get')."',{url:url},function(data){
				 	var tags = $.parseJSON(data);  
				 	img.tag(".$jtag.");  
				 	if(tags){
					 	$.each(tags, function(key,tag){ 
							img.addTag(tag.width,tag.height,tag.top,tag.left,tag.label,tag.id); 
						}); 
					}
				}); 
			 	 
			}
	 	"):"";
	 	if(!$this->options['afterShow']) unset($this->options['afterShow']);
		
	  
	 	if($this->options)
			$opts = Json::encode($this->options);    
	 	$this->tag = $this->tag?:".fancybox";
		js("$('".$this->tag."').fancybox($opts);");   
 	 	js_file($base.'/jtag/jquery.tag.min.js');
	 	css_file($base.'/jtag/jquery.tag.min.css');
		/*js_file($base.'/lib/jquery.mousewheel-3.0.6.pack.js'); 
		js_file($base.'/source/helpers/jquery.fancybox-buttons.js');  
		js_file($base.'/source/helpers/jquery.fancybox-thumbs.js'); 
		js_file($base.'/source/helpers/jquery.fancybox-media.js');    */
		js_file($base.'/source/jquery.fancybox.pack.js'); 
		css_file($base.'/source/jquery.fancybox.css'); 
		css_file($base.'/source/helpers/jquery.fancybox-buttons.css'); 
		css_file($base.'/source/helpers/jquery.fancybox-thumbs.css'); 
		
		 
	}
}