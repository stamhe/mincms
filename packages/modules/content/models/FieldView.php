<?php namespace application\modules\content\models;  
use yii\helpers\Html;
class FieldView extends \application\core\ActiveRecord 
{
 
 
	public static function tableName()
    {
        return 'content_type_field_view';
    } 
    function scenarios() {
		 return array( 
		 	'default' => array('fid','list','search'), 
		 );
	}
	public function rules()
	{ 
		return array(
			array('fid', 'required'),  
		);
	} 
	function beforeSave($insert){
		parent::beforeSave($insert);  
		if($this->list) 
			$this->list =  serialize($this->list);
		if($this->search)  
			$this->search =  serialize($this->search); 
		return true;
	}
	function afterFind(){
		parent::afterFind();
		if($this->list)
			$this->list =  unserialize($this->list);
		if($this->search)
			$this->search =  unserialize($this->search);
	 
	}
 
	 
}