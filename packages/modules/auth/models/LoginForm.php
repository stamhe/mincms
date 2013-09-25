<?php namespace application\modules\auth\models;  
use Yii;
use application\core\Model; 
/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
	public $username;
	public $password;
	public $rememberMe = true;
	public $user;
	public $verifyCode;
	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return array(
			// username and password are both required
			array('username, password', 'required'),
			// password is validated by validatePassword()
			array('password', 'validatePassword'),
			// rememberMe must be a boolean value
			array('rememberMe', 'boolean'),
			array('verifyCode', 'captcha','captchaAction'=>'auth/open/captcha'),
		);
	}

	/**
	 * Validates the password.
	 * This method serves as the inline validation for password.
	 */
	public function validatePassword()
	{
		$this->user = User::findByUsername($this->username);
		if (!$this->user || !$this->user->validatePassword($this->password)) {
			$this->addError('password', 'Incorrect username or password.');
		}
	}

	/**
	 * Logs in a user using the provided username and password.
	 * @return boolean whether the user is logged in successfully
	 */
	public function login()
	{
		if ($this->validate()) {  
			\Yii::$app->user->login($this->user, $this->rememberMe ? 3600*24*30 : 0);
			return true;
		} else {
			return false;
		}
	}
}
