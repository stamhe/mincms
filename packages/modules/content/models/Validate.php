<?php namespace application\modules\content\models; 

use yii\helpers\Html;
class Validate extends \application\core\ActiveRecord 
{
 
 
	public static function tableName()
    {
        return 'content_type_validate';
    } 
    function scenarios() {
		 return array( 
		 	'default' => array('field_id','value'), 
		 );
	}
	public function rules()
	{ 
		return array(
			array('field_id, value', 'required'),  
		);
	} 
	 
 
	 
}