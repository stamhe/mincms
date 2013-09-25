<?php namespace application\modules\email\controllers; 
use  application\modules\email\models\Template;
/**
* template setting
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/ 
class TemplateController extends \application\core\AuthController
{  
	
	function init(){
		parent::init();
		$this->active = array('system','email.template.index');
	}
	
	public function actionIndex()
	{   
		$rt = \application\core\Pagination::run('\application\modules\email\models\Template');   
		return $this->render('index', array(
		   'models' => $rt->models,
		   'pages' => $rt->pages,
		));
		 
	}
	public function actionDelete($id){
		if($_POST['action']==1){ 
			$model = Template::find($id); 
			$model->delete();
			echo json_encode(array('id'=>array($id),'class'=>'alert-success','message'=>__('delete success')));
			exit;
		} 
	}
	public function actionCreate()
	{   
 		$model = new Template;
 		$model->scenario = 'all';
 		if($_GET['id']) $model->slug = $_GET['id'];
		if ($model->load($_POST) && $model->validate()) {
		 	$model->save();
		 	flash('success',__('success'));
		 	$this->redirect(array('index'));
		} 
		return $this->render('form',array('model'=>$model)); 
	}
	public function actionUpdate($id)
	{   
 		$model = Template::find($id);
 		$model->scenario = 'all'; 
		if ($model->load($_POST) && $model->validate()) {
		 	$model->save();
		 	flash('success',__('success'));
		 	$this->redirect(array('index'));
		} 
		return $this->render('form',array('model'=>$model)); 
	}
	 

	 
}
