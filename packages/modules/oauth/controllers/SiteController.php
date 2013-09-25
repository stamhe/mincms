<?php namespace application\modules\oauth\controllers; 
use application\modules\oauth\models\OauthConfig;
use application\core\DB;
/**
 * oauth admin settings
 * @author Sun <mincms@outlook.com>
 * @copyright 2013 The MinCMS Group
 * @license http://mincms.com/licenses
 * @version 2.0.1
*/
class SiteController extends \application\core\AuthController
{ 
	function init(){
		parent::init();
		$this->active = array('extend','oauth.site.index'); 
	}
	function actionSort(){ 
 		$ids = $sort = $_POST['ids']; 
 		arsort($sort); 
 		$sort = array_merge($sort,array()); 
 		$table = "oauth_config";
 		$fid = $id; 
 		foreach($ids as $k=>$id){ 
 		 	DB::update($table,
	 			array(
	 				'sort'=>$sort[$k]
	 			),'id=:id', array(':id'=>$id)
 		 	); 
 		}  
 	  
 		return 1;
 		
  
	}
	function actionDisplay($id){
		$id = (int)$id;
		if($id<1) exit;
		$one = DB::one('oauth_config',array(
			'where'=>array('id'=>$id)
		));
		$display = $one['display']==1?0:1;
		DB::update('oauth_config',array(
			'display'=>$display
		),'id=:id',array(':id'=>$id));
		flash('success',__('sucessful'));
		$this->redirect(url('oauth/site/index'));
	}
	public function actionCreate()
	{  
		$this->view->title = __('create oauth');
		$model = new OauthConfig();
	 	$model->scenario = 'all';
		if ($model->load($_POST) && $model->validate()) { 
		 	$model->save();
		 	flash('success',__('create sucessful'));
			$this->redirect(url('oauth/site/index'));
		} 
		return $this->render('form', array(
		   'model' => $model,
		   'name'=>'oauth_config', 
		));
	}
	public function actionUpdate($id)
	{  
		$this->view->title = __('update oauth') ."#".$id;
		$model = OauthConfig::find($id);
	 	$model->scenario = 'all';
		if ($model->load($_POST) && $model->validate()) { 
		 	$model->save();
		 	flash('success',__('update sucessful'));
			$this->redirect(url('oauth/site/index'));
		} 
		return $this->render('form', array(
		   'model' => $model, 
		   'name'=>'oauth_config',
		));
	}
	public function actionDelete($id){
		if($_POST['action']==1){ 
			$model = OauthConfig::find($id); 
			$model->delete();
			echo json_encode(array('id'=>array($id),'class'=>'alert-success','message'=>__('delete success')));
			exit;
		} 
	}
	public function actionIndex()
	{    
		$rt = \application\core\Pagination::run('\application\modules\oauth\models\OauthConfig',array('orderBy'=>'sort desc,id desc'),array('pageSize'=>200));  
 		
		return $this->render('index', array(
		   'models' => $rt->models,
		   'pages' => $rt->pages,
		));
	}

	 
}
