<?php namespace application\widget\cloudzoom;  
use yii\helpers\Json;
use yii\helpers\Html;
/**
* cloudzomm widget
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @link http://www.starplugins.com/cloudzoom   get license  
* @link http://mincms.com/demo-cloudzoom.html   demo
* @version 2.0.1
*/

class Widget extends \yii\base\Widget
{  
	/**
	* array image. key is small picture, value is big
	*/
 	public $img; 
 	/**
 	* array options
 	*/
 	public $options; 
 	/**
 	* object 
 	*/
 	static $obj;
  	
 	/**
	*  
	* Example 
	*  
	* <code> 
	*	echo widget('cloudzoom',array(
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
	 	if($this->options)
			$opts = Json::encode($this->options);    
		if(!static::$obj){
			js("CloudZoom.quickStart();");  
			static::$obj = true;
		}
		
		unset($img);
		if($this->img){ 
			foreach($this->img as $k=>$v){
				$img  .= "<a href='".$v."'>".Html::img($k,array(
					'class' => 'cloudzoom', 
				)).'</a>'; 
            } 
            echo $img;
		} 
		css_file($base.'/cloudzoom.css');
		js_file($base.'/cloudzoom.js');  
		 
	}
}