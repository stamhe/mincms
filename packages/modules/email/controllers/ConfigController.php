<?php namespace application\modules\email\controllers; 
use application\modules\email\models\Config; 
use  application\modules\email\models\Send;
use application\core\Arr;
/**  
* @author Sun < mincms@outlook.com >
*/
class ConfigController extends \application\core\AuthController
{ 
 	function init(){
		parent::init();
		$this->active = array('system','email.config.index');
	}
	
	public function actionIndex()
	{   
		$a = array(array('s'=>2)); 
		$model = Config::find()->one();
		if(!$model)
	  		$model = new Config();
	 	if(!$model->port) $model->port = 25;
	  	$model->scenario = 'all'; 
		if ($model->load($_POST) && $model->save()) {
		 	flash('success',__('mail settings success'));
		 	$this->refresh();
		} 
		
		$send = new Send;
 		$send->scenario = 'all';
		if ($send->load($_POST) && $send->validate()) {
			//send mail
		 	\application\modules\email\Mailer::send($send->title,$send->body,array($send->to_email=>$send->to_name),$attachment=null);
		 	flash('success',__('send mail success'));
		 	$this->refresh();
		}
		
		return $this->render('index',array('model'=>$model , 'send'=>$send));
	 
	}
	 

	 
}
