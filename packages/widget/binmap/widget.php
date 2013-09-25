<?php namespace application\widget\binmap;  
use yii\helpers\Json;
/**
* bin map api
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/ 
class Widget extends \yii\base\Widget
{  
 	public $tag;
 	public $address;  
 	public $width=200;
 	public $height=200;
 	public $info;
 	public $key='Avo2UtmOY6TnwF5egxhfyN6QdNym5A2T4UorHgF6nCUn9qqLi9KZGVHVVoSwaztC';
 	/**
 	* example
 	*
 	* <code>
	* 	echo widget('binmap',array(
	*		'tag'=>'maps',
	*		'address'=>'上海淮海中路1008号',
	*		'width'=>600,
	*		'height'=>360,
	*		'info'=>'活动场地在进门后左侧'
	*	));
 	* </code>
 	*/
	function run(){   
		$lang = strtolower(\Yii::$app->language);
		$id = substr(md5(uniqid()),0,6);
	 	echo "<div style=\"position:relative;width:".$this->width."px;height:".$this->height."px;\" id='".$this->tag."' ></div>";
	  	js(" 
	  		var myMap".$id." = null;
	  		function LoadMap".$id."()
			{
			    myMap".$id." = new VEMap('".$this->tag."'); 
			    myMap".$id.".SetCredentials('".$this->key."');
			    myMap".$id.".LoadMap();
			    StartGeocoding".$id."('".$this->address."');
			} 
			LoadMap".$id."();
	  	");
	  	js("
	  	function GeocodeCallback".$id." (shapeLayer, findResults, places, moreResults, errorMsg)
		{ 
			if(places == null)
			{
				return;
			}
			var bestPlace = places[0];
			var location = bestPlace.LatLong;
			var newShape = new VEShape(VEShapeType.Pushpin,location);
			var desc = '".$this->info."';
			newShape.SetDescription(desc);
			newShape.SetTitle(bestPlace.Name);
			myMap".$id.".AddShape(newShape);
		} 
		function StartGeocoding".$id."( address )
		{
			myMap".$id.".Find(null,address,null,null,null,null,null,null,null,	null,GeocodeCallback".$id.");
		} 
	  	");
 		js_file("http://dev.ditu.live.com/mapcontrol/mapcontrol.ashx?v=6.2&mkt=".$lang);
 	 	
 		
	}
}