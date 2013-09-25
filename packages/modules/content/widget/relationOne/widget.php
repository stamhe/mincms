<?php namespace application\modules\content\widget\relationOne;  
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
  		$arr = Classes::table_columns();  
  		$id = $_GET['id'];  
  		$str = '<div class="control-group">';  
  		if(!$arr['table']) return;
 		$str .= "<p class='controls'>".Html::dropDownList('Field[relate]',$selected,$arr['table'],
 			array('id'=>'Field_relate'))."</p>"; 
  	 	$str .= "</div>"; 
 		return $str; 
	}
 	static function node_type(){  
		 return 'int';
	}
	function run(){  
		$name = $this->name;   
 		$relate = $this->structure[$name]['relate']; 
 		//contnet type
 		$contype = $_GET['name'];
 	 
 		$a1[''] = $values = array(0=>__('please select'));
 		if(strpos($relate , 'node_') !== false){
 			$relate = str_replace('node_' , '' , $relate);
 			if( $contype == 'taxonomy')
 				$all = Classes::all($relate , array(), true);  
 			else
 				$all = Classes::all($relate);  
 			if($all){ 
 				if( $contype == 'taxonomy'){
			  	 	foreach($all as $v){
						$taxonomy[$v->id] = $v;
					}  
					$a1[''] = __('please select');    
			  		$values = \application\core\Arr::tree($taxonomy,'name','id','pid');  
			  		if($values)
			  			$values = $a1+$values;
		  		}else{
		 			foreach($all as $v){  
		 				$v = (array)$v;
		 				$values[$v['id']] = Arr::first($v);
		 			} 
	 			}
 			}
 		}
 		echo  Html::dropDownList($this->_name,$this->value , $values ,array('id'=>$this->id ,'style'=>'width:260px'));   
 	 
 		 
	}
}