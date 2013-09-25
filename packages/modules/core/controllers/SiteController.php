<?php namespace application\modules\core\controllers; 
/**
*  
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/ 
class SiteController extends \application\core\AuthController
{ 
	//无需验证权限
	public $_skip = true;
	public function actionIndex()
	{ 
		return $this->render('index');
	}

	 
}
