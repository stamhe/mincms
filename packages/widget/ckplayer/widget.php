<?php namespace application\widget\ckplayer;  
use yii\helpers\Json;
/**
* 
* @author Sun < mincms@outlook.com >
*/
class Widget extends \yii\base\Widget
{  
 	public $tag;
 	public $options; //  
 	public $file ;  
 	public $image ;  
 	public $width = 400; 
 	public $height = 300 ; 
	function run(){   
		$base = publish(__DIR__.'/assets');   
		if(!$this->options['bgcolor'])
	 		$this->options['bgcolor'] = "#000";
	  	if(!$this->options['allowFullScreen'])
	 		$this->options['allowFullScreen'] = true;
	 	if(!$this->options['allowScriptAccess'])
	 		$this->options['allowScriptAccess'] = "always";
	  
	  
	 	$this->options = Json::encode($this->options);
		 
		$tag = $this->tag;
		$tag = str_replace('#','',$tag);
		$tag = str_replace('.','',$tag);
 		js("
 			var flashvars={
			f:'".$this->file."',
			c:0
		}; 
		var attributes={id:'".$tag."',name:'".$tag."'};
		swfobject.embedSWF('".$base."/ckplayer.swf', '".$tag."', ".$this->width.", ".$this->height.", '10.0.0','".$base."/expressInstall.swf', flashvars, ".$this->options.", attributes);  
	 	 
 		"); 
 		js_file($base.'/swfobject.js');
 		js_file($base.'/ckplayer.js');
 		
	}
}