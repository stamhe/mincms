<?php namespace application\modules\content\widget\datepicker;  
use application\core\DB;
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
		 return 'int';
	}
	function run(){   
		$name = $this->name;  
		hook_add('cck_hook',array($this->slug=>array($name=>"\application\modules\content\widget\datepicker\widget")));  
		if(is_array($this->model->$name)) $this->model->$name = '';   
		echo  Html::textInput($this->_name,$this->value , array('id'=>$this->id ));  
		$this->_opt['dateFormat'] = $this->_opt['dateFormat']?:"yy-mm-dd"; 
 		widget('datepicker',array('tag'=>'#'.$this->id , 'options'=>$this->_opt)); 
	}
	static function beforeSave($insert,$k){ 
		$v = $insert->$k ;
		if($v){
			$insert->$k = strtotime($v);
		}
		return $insert; 
	}
	static function afterFind($insert , $k){
		$v = $insert->$k ;
		if($v){
			$insert->$k = date('Y-m-d',$v);
		} 
		return $insert; 
	 
	}
}