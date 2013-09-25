<?php namespace application\modules\core\models; 

 
class Config extends \application\core\ActiveRecord 
{
 
	public $old_pid;
	public static function tableName()
    {
        return 'core_config';
    } 
    function scenarios() {
		 return array( 
		 	'all' => array('slug','body','memo'),
		   
		 );
	}
	public function rules()
	{ 
		return array(
			array('slug, body', 'required'),
		 
		);
	}   
	public static function active($query)
    {
        $query->andWhere('`lock` = 0');
    }
 
}