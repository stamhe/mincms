<?php namespace application\core\widget;  
/**
*  FormBuilder
* 
slug: 
   html:dropDownList
   value:php:value  
name:
   html:textInput
key1:
   html:textInput
key2:
   html:textInput
model.php
value:php:value 
function value(){
	$first[0] = __('please select');
	$data = static::find()->all();
	if($data){ 
		$out = \application\core\Arr::model_tree($data);  
		$out = $first+$out; 
	}else{
		$out = $first;
	}
	return $out;
}
* @author Sun < mincms@outlook.com >
*/
class Form extends \yii\base\Widget
{ 
	public $model;
	public $fields;  
	public $yaml;
	public $form=true;
	public $open;
	function run(){ 
		if($this->yaml){
			import('@application/lib/Spyc'); 
			if(strpos($this->yaml,'@')!==false){
				$alia = substr($this->yaml,0, strpos($this->yaml,'/'));
				$path = \Yii::getAlias($alia).substr($this->yaml,strpos($this->yaml,'/'));
			}else{
				$path = $this->yaml;
			}  
		 
			$yaml = \Spyc::YAMLLoad($path);   
			foreach($yaml as $k=>$v){  
				if(strpos($v['value'],'php:')!==false){
					$m = str_replace('php:','',$v['value']);
					$v['value'] = $this->model->$m();
				}
				$data[$k] = $v;
			}
		 
		}
 
	 	echo $this->render('@application/core/widget/views/form',array(
	 		'model'=>$this->model,
	 		'fields'=>$data, 
	 		'form'=>$this->open,
	 		'show_form'=>$this->form
	 	));
	}
}