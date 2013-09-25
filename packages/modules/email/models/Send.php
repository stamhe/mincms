<?php namespace application\modules\email\models; 
/**
* send mailer log
* 
* @author Sun < mincms@outlook.com >
*/
 
class Send extends \application\core\ActiveRecord 
{
  
	public static function tableName()
    {
        return 'email_send';
    } 
    function scenarios() {
		 return array( 
		 	'all' => array('to_email','title','body','to_name','attach'),
		   
		 );
	}
 
	public function rules()
	{ 
		return array(
			array('to_email,title,body', 'required'), 
		);
	}   
	function beforeSave($insert){
		parent::beforeSave($insert);
		if($this->attach){
			if(is_array($this->attach)){
				$this->attach = serialize($this->attach);
			}
		}else{
			$this->attach = "";
		}
		return true;
	}
	public function behaviors()
	{
	  return array(
	      'timestamp' => array(
	          'class' => 'application\core\TimeBehavior',
	      ),
	  );
	}
 
 
	 
}