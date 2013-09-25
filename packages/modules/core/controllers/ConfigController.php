<?php namespace application\modules\core\controllers; 
use application\modules\core\models\Config; 
/**
*   
* 
* @author Sun < mincms@outlook.com >
*/
class ConfigController extends \application\core\AuthController
{ 
	function init(){
		parent::init();
		$this->active = array('system','core.config.index');
	}
	public function actionCreate()
	{  
		$this->view->title = __('create config');
		$model = new Config();
	 	$model->scenario = 'all';
		if ($model->load($_POST) && $model->validate()) { 
		 	$model->save();
		 	flash('success',__('create config sucessful'));
			refresh();
		} 
		return $this->render('form', array(
		   'model' => $model,
		   'name'=>'user_create', 
		));
	}
	public function actionUpdate($id)
	{  
		$this->view->title = __('update config') ."#".$id;
		$model = Config::find($id);
	 	$model->scenario = 'all'; 
		if ($model->load($_POST) && $model->validate()) { 
		 	$model->save();
		 	flash('success',__('update config sucessful'));
			refresh();
		} 
		$k = 'get_config'.$model->slug;
        cache($k,false);
	
		return $this->render('form', array(
		   'model' => $model, 
		   'name'=>'user_update',
		));
	}
	public function actionDelete($id){
		if($_POST['action']==1){ 
			$model = Config::find($id); 
			$model->delete();
			echo json_encode(array('id'=>array($id),'class'=>'alert-success','message'=>__('delete config success')));
			exit;
		} 
	}
	public function actionIndex()
	{    
		$rt = \application\core\Pagination::run('\application\modules\core\models\Config' , 'active');  
 		
		return $this->render('index', array(
		   'models' => $rt->models,
		   'pages' => $rt->pages,
		));
	}

	 
}
