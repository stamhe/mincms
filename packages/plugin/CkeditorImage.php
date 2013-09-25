<?php namespace application\plugin;  
use yii\helpers\Json;
use yii\helpers\Html;
use application\core\DB;
/**
* ckeditor image plugin
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @link http://www.starplugins.com/cloudzoom   get license  
* @link http://mincms.com/demo-cloudzoom.html   demo
* @version 2.0.1
*/

class CkeditorImage extends \application\core\Plugin
{  
	/**
	*
	* find::CkeditorImageFind find is static function. CkeditorImageFind is view file
	*/
	function run(){    
		$this->url .= 'find::CkeditorImageFind::'.$this->field;  
		$data['url'] = $this->url; 
		echo $this->view('CkeditorImage',$data);
	}
	
	static function find(){ 
		$data = (array)DB::pager('file' ,array(
			'where'=>array(
			 	'like', 'type', '%image%'  
			),
			'orderBy'=>'id desc'
		), 12);  
		return $data;
		 
	}
	
}