<?php namespace application\modules\email\models; 
use yii\helpers\Security;
 
class Config extends \application\core\ActiveRecord 
{ 
	public $old;
	public static function tableName()
    {
        return 'email_config';
    }  
    /**
    * $model->scenario = 'all';
    */
    function scenarios() {
		 return array( 
		 	'all' => array('from_email','from_name','from_password','smtp','type','port'),
		   
		 );
	}
	public function rules()
	{ 
		return array(
			array('from_email, from_name, type,port', 'required'), 
		);
	}   
	function getPass(){
		return decode($this->old);
	}
 	/**
 	* 密码为空时，密码字段使用原来的密码
 	*/
    function beforeSave($insert){
    	parent::beforeSave($insert); 
    	if($this->from_password)
    		$this->from_password = encode($this->from_password);
     	else
     		$this->from_password = $this->old;
     	return true;
    }
    function afterFind(){
    	parent::afterFind();
    	$this->old = $this->from_password;
    	$this->from_password = "";
    }
 
	 
}