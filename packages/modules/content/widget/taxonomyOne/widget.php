<?php namespace application\modules\content\widget\taxonomyOne;  
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
class Widget extends \application\modules\content\Widget
{  
	public $theme;	
	/***
	* when content type choice relation
	*/
  	static function content_type($selected=null){  
  		$all = Classes::all('taxonomy',array('orderBy'=>'sort desc,id desc'),true);   
  		if($all){
	  	 	foreach($all as $v){
				$taxonomy[$v->id] = $v;
			} 
	  		$all = \application\core\Arr::tree($taxonomy);  
  		}
  		if(!$all) $all = array();
  		else{
  			foreach($all as $k=>$v){
  				$n['taxonomy:'.$k] = $v;
  			}
  			$all = $n;
  		}
  		$id = $_GET['id'];  
  		$str = '<div class="control-group">';   
 		$str .= "<p class='controls'>".Html::dropDownList('Field[relate]',$selected,$all,array('id'=>'Field_relate','style'=>'width:260px'))."</p>"; 
  	 	$str .= "</div>"; 
 		return $str; 
	}
 	static function node_type(){  
		 return 'int';
	}
	function run(){  
		unset($all);
		$name = $this->name;   
 		$relate = $this->structure[$name]['relate'];
 		$root = str_replace('taxonomy:','',$relate); 
 		$all = Classes::all('taxonomy',array('orderBy'=>'sort desc,id desc'),true);   
  	 	foreach($all as $v){
			$taxonomy[$v->id] = $v;
		}  
		$a1[''] = __('please select');    
  		$all = \application\core\Arr::tree($taxonomy,'name','id','pid',$root);  
  		if(!$all) $all = array(); 
  		else{
  			$all = $a1+$all;
  		} 
 		echo  Html::dropDownList($this->_name,$this->value , $all ,array('id'=>$this->id ,'style'=>'width:260px'));   
 		 
 		 
	}
}