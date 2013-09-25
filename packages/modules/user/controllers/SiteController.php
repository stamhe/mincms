<?php namespace app\modules\user\controllers; 
/**
*  购物车，只有管理员看到
*  如是会员才能看到的 extends application\modules\member\AuthController
*  如是管理员才能看到的 extends \application\core\AuthController
* 
* @author Sun < mincms@outlook.com >
*/
class SiteController extends \application\core\AuthController
{ 
	public function actionIndex()
	{ 
		return $this->render('index');
	}

	 
}
