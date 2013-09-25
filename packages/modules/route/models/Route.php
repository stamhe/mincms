<?php namespace application\modules\route\models;  
 
class Route extends \application\core\ActiveRecord 
{
 
 
	public static function tableName()
    {
        return 'route';
    } 
    function scenarios() {
		 return array( 
		 	'all' => array('route','route_to','sort'),
		   
		 );
	}
	public function rules()
	{ 
		return array(
			array('route, route_to', 'required'),  
		);
	} 
	function getIds(){ 
		return '<i class="drag"></i>'.\yii\helpers\Html::hiddenInput('ids[]',$this->id).$this->id; 
	}
	 
 
	 
}