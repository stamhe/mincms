<?php namespace application\modules\content\widget\taxonomy;  
use application\modules\content\Classes;
use yii\helpers\Html;
use application\core\Arr;
use application\core\DB;
/**
*  
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/
class Widget extends \application\modules\content\widget\taxonomyOne\Widget
{  
 	function value_type(){
	 	return true;
	 }
	function run(){  
		unset($all);
		$name = $this->name;   
 		$relate = $this->structure[$name]['relate'];
 		$root = str_replace('taxonomy:','',$relate); 
 		$all = Classes::all('taxonomy',array('orderBy'=>'sort desc,id desc'),true);   
 		if($all){
	  	 	foreach($all as $v){
				$taxonomy[$v->id] = $v;
			}  
			$a1[''] = __('please select');    
	  		$all = \application\core\Arr::tree($taxonomy,'name','id','pid',$root);  
  		}
  		if(!$all) $all = array(); 
  		else{
  			$all = $a1+$all;
  		}  
 		
 		$this->multiple($all);
	}
}