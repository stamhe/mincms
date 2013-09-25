<?php namespace application\modules\email\models; 
 
 
class Template extends \application\core\ActiveRecord 
{
  
	public static function tableName()
    {
        return 'email_template';
    } 
    function scenarios() {
		 return array( 
		 	'all' => array('slug','memo','body','title'),
		   
		 );
	}
 
	public function rules()
	{ 
		return array(
			array('slug,memo,body,title', 'required'), 
		);
	}   
 
 
 
	 
}