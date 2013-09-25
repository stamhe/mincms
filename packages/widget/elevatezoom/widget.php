<?php namespace application\widget\elevatezoom;  
use yii\helpers\Json;
use yii\helpers\Html;
/**
* elevatezoom widget
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @link http://www.elevateweb.co.uk/image-zoom    offical website
* @link http://mincms.com/demo-elevatezoom.html   demo
* @version 2.0.1
*/

class Widget extends \yii\base\Widget
{  
	/**
	* html element
	*/
	public $tag;
	/**
	* array image. key is small picture, value is big
	*/
 	public $img; 
 	/**
 	* array options
 	*/
 	public $options;  
 	/**
	*  
	* Example :
	*  
	* <code> 
	* 	echo widget('elevatezoom',array(
	*		'tag'=>'img',
	*		'img'=>array(
	*			image_url('upload/t/6.jpg',array(
	*				'resize'=>array(400,300)
	*			)) => base_url().'upload/t/6.jpg'
	*		),
	*	));
	*</code> 
	*/ 
	function run(){   
		$base = publish(__DIR__.'/assets');   
	 	$this->options['borderSize'] = $this->options['borderSize']?:1;
		$opts = Json::encode($this->options);    
		 
		js("$('".$this->tag."').elevateZoom($opts)");   
	 
		if($this->img){ 
			foreach($this->img as $k=>$v){
				$img  .= Html::img($k,array(
					'data-zoom-image' => $v, 
				)); 
            } 
            echo $img;
		} 
		 
		js_file($base.'/jquery.elevateZoom-2.5.5.min.js');  
		 
	}
}