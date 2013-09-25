<?php namespace application\modules\content\widget\text;  
use yii\helpers\Html;
/**
*  
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/
class Widget extends \application\modules\content\Widget
{  
  
 	static function node_type(){  
		 return 'text';
	}
	function run(){   
		echo  Html::textArea($this->_name,$this->value , array('id'=>$this->id));  
	}
}