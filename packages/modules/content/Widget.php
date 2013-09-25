<?php 
namespace application\modules\content; 
use application\modules\content\models\NodeActiveRecord;
use application\core\Arr;
use yii\helpers\Html; 
class Widget extends \yii\base\Widget
{
	public $label;
    public $name;//field name
    public $model;
    public $form;
  	public $value;
  	public $_name;
  	public $_opt;
  	public $slug;
  	public $structure;
  	public $id;
  	function init(){
  		parent::init();
  		$name = $this->name;   
  		$this->id = "nodeactiverecord-".$this->name; 
  		$this->_name = "NodeActiveRecord[".$this->name."]"; 
		$this->slug = $_GET['name'];
		$this->structure =  Classes::structure($this->slug);
		$this->_opt = $this->structure[$name]['widget_config']; 
		if(!$this->model){
			$model =  new NodeActiveRecord;
			$model::$table = $this->name;
			$this->model = $model;
			$this->model->rules = array(); 
		} 
  		if($this->value)
  			$this->model->$name = $this->value;
  		else
  			$this->value = $this->model->$name;
  	}
  	
  	function multiple($values,$type = 'dropDownList'){  
 		$id = "nodeactiverecord-".$this->name; 
 		$str = ""; 
 		if($this->value){
 			if(is_array($this->value)){ 
 				$sort = $values;
 				unset($values);
 				foreach(array_keys($this->value) as $i) {
 					$values[$i] = $sort[$i];
 				 	unset($sort[$i]);
 				}
 				$values = $sort+$values;  
 				$str = implode($this->value,','); 
 			}else
 				$str = $this->value;
 		}
 	 	if(!$values) $values = array();
 	 	
 	 	echo  Html::dropDownList($this->_name.'[]',$this->value , $values ,array('id'=>$this->id ,'style'=>'width:260px' , 'multiple'=>'multiple'));   
 	 
 		js("
 			var ret = [".$str."];
 			$('#".$id." option').each(function(){
 				var i = $(this).val(); 
 				if(in_array(i, ret)){
 					$(this).attr('selected',true);
 				}
 			});
 		"); 
  	}
  	function value_type(){
	 	 return ;
	}
  	 
}