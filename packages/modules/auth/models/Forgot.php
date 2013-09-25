<?php namespace application\modules\auth\models;  
use Yii;
use application\core\Model; 
use application\modules\auth\models\User;
/**
 * LoginForm is the model behind the login form.
 */
class Forgot extends Model
{
	public $username;
  	public $id;
  	public $email;
	public function rules()
	{
		return array(		
			array('email', 'required'),
			array('email', 'check'),
		);
	} 
	
	function check($attribute){
		$user = User::find()->where('email=:email', array('email'=>$this->$attribute))->one();
	 	$this->id = $user->id;
	 	$this->email = $user->email;
	 	$this->username = $user->username;
		if(!$user)
			$this->addError('username',__('not find')); 
	}
}
