<?php namespace application\modules\payment\controllers;   
use application\core\Str;
use Omnipay\Common\GatewayFactory;
/**
 *  
 * @author Sun < mincms@outlook.com >
 * @Coprighty  http://mincms.com
 */
class AdminController extends \application\core\AuthController
{ 
  
	function init(){
		parent::init();  
	 
	}
 	public function actionIndex()
	{
	  	return $this->render('index');
	}
 
	
 

 
}
