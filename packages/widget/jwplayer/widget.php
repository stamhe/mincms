<?php namespace application\widget\jwplayer;  
use yii\helpers\Json;
/**
*  
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/ 
class Widget extends \yii\base\Widget
{  
 	public $tag;
 	public $options; // file
 	public $file ;  
 	public $image ; 
 	public $width = 400; 
 	public $height = 300 ; 
	function run(){   
		$base = publish(__DIR__.'/assets');   
	 	$this->options['flashplayer'] = $base."/jwplayer.flash.swf";
	 	$this->options['width'] = $this->options['width']?:$this->width;
	 	$this->options['height'] = $this->options['height']?:$this->height;
	 	if($this->file)
	 		$this->options['file'] = $this->file;
	 	if($this->image)
	 		$this->options['image'] = $this->image;
		$opts = Json::encode($this->options);  
		$tag = $this->tag;
		$tag = str_replace('#','',$tag);
		$tag = str_replace('.','',$tag);
 		js('  
	 		jwplayer("'.$tag.'").setup('.$opts.');
 		'); 
 		js_file($base.'/jwplayer.js');
 		
	}
}