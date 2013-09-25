<?php namespace application\widget\magiczoom;  
use yii\helpers\Json;
use yii\helpers\Html;
/**
* magiczoom widget
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @link http://www.magictoolbox.com/magiczoom/   get license 
* @link http://mincms.com/demo-magiczoom.html   demo
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
	*   
	* Example:
	*  
	* <code> 
	*	echo widget('magiczoom',array(
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
		
		unset($img);
		if($this->img){ 
			foreach($this->img as $k=>$v){
				$img  .= "<a href='".$v."' class='MagicZoom'>".Html::img($k).'</a>'; 
            } 
            echo $img;
		} 
		css_file($base.'/magiczoom.css');
		js_file($base.'/magiczoom.js');  
		 
	}
}