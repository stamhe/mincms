<?php namespace app\modules\user\controllers; 
use app\modules\member\Auth;
/**
 *  
 * @author Sun < mincms@outlook.com >
 * @Coprighty  http://mincms.com
 */
class LogoutController extends \application\core\FrontController
{
 
	public function actionIndex()
	{
		Auth::logout();
		flash('success',__('logout success'));
		$this->redirect(return_url());
	}
	

	 
}
