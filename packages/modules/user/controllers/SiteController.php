<?php namespace app\modules\user\controllers; 
/**
*  ���ﳵ��ֻ�й���Ա����
*  ���ǻ�Ա���ܿ����� extends application\modules\member\AuthController
*  ���ǹ���Ա���ܿ����� extends \application\core\AuthController
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
