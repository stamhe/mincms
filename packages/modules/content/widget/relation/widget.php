<?php namespace application\modules\content\widget\relation;  
use application\modules\content\Classes;
use yii\helpers\Html;
use application\core\Arr;
/**
*  
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/

class Widget extends \application\modules\content\widget\relationOne\widget
{  
	 function value_type(){
	 	return true;
	 }
	 function run(){  
	 	$name = $this->name;   
 		$relate = $this->structure[$name]['relate']; 
 		//contnet type
 		$values = array(0=>__('please select'));
 		if(strpos($relate , 'node_') !== false){
 			$relate = str_replace('node_' , '' , $relate);
 			$all = Classes::all($relate);  
 			if($all){
	 			foreach($all as $v){  
	 				$v = (array)$v;
	 				$values[$v['id']] = Arr::first($v);
	 			} 
	 		 
 			}
 		} 
		 $this->multiple($values);
	}
	
	
}