<?php namespace application\core;  
/**
*  
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/
class ActiveRecord extends \yii\db\ActiveRecord
{ 
	function beforeSave($insert){
		parent::beforeSave($insert);
		hook('beforeSave',$this);
		return true;
	}
	function afterFind(){
		parent::afterFind();
		hook('afterFind',$this);
		return true;
	}
 	public function save($runValidation = true, $attributes = null)
	{
		if ($this->getIsNewRecord()) {
			$r = $this->insert($runValidation, $attributes);
			$this->afterSave(true);
		} else {
			$r = $this->update($runValidation, $attributes) !== false;
			$this->afterSave(false);
		}
		
		return $r;
	}
 	/*
 	* 属性自动翻译
 	*
 	*/
	public function attributeLabels()
	{
		$class = new \ReflectionClass($this);
		$names = array();
		foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
			$name = $property->getName();
			if (!$property->isStatic()) {
				$names[] = $name;
			}
		}
		$names = array_merge($names,$this->attributes()); 
	 
		foreach($names as $v){
			$out[$v] = __($v);
		} 
	 
		return $out;
	}
}