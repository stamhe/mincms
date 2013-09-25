<?php namespace application\modules\host\controllers; 
use application\modules\host\models\Host;
use application\modules\core\Classes;
use application\core\DB;
/**
*  
* @author Sun < mincms@outlook.com >
*/
class SiteController extends \application\core\AuthController
{ 
	public $config_key = 'module_host';
	function init(){
		parent::init();
		$this->active = array('extend','host.site.index'); 
	}
	function actionConfig(){ 
		$value = Classes::get_config($this->config_key);
		
		if($value==1)
			$value = 0;
		else
			$value = 1;
		Classes::set_config_lock($this->config_key,$value);
		cache_pre_delete('hooks');
		flash('success',__('sucessful'));
		$this->redirect(url('host/site/index'));
	}
	function actionSort(){ 
 		$ids = $sort = $_POST['ids']; 
 		arsort($sort); 
 		$sort = array_merge($sort,array()); 
 		$table = "host";
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
		$one = DB::one('host',array(
			'where'=>array('id'=>$id)
		));
		$display = $one['display']==1?0:1;
		DB::update('oauth_config',array(
			'display'=>$display
		),'id=:id',array(':id'=>$id));
		flash('success',__('sucessful'));
		$this->redirect(url('host/site/index'));
	}
	public function actionCreate()
	{  
		$this->view->title = __('create host');
		$model = new Host();
	 	$model->scenario = 'all';
		if ($model->load($_POST) && $model->validate()) { 
		 	$model->save();
		 	flash('success',__('create sucessful'));
			$this->redirect(url('host/site/index'));
		} 
		return $this->render('form', array(
		   'model' => $model 
		));
	}
	public function actionUpdate($id)
	{  
		$this->view->title = __('update host') ."#".$id;
		$model = Host::find($id);
	 	$model->scenario = 'all';
		if ($model->load($_POST) && $model->validate()) { 
		 	$model->save();
		 	flash('success',__('update sucessful'));
			$this->redirect(url('host/site/index'));
		} 
		return $this->render('form', array(
		   'model' => $model,  
		));
	}
	public function actionDelete($id){
		if($_POST['action']==1){ 
			$model = Host::find($id); 
			$model->delete();
			echo json_encode(array('id'=>array($id),'class'=>'alert-success','message'=>__('delete success')));
			exit;
		} 
	}
	public function actionIndex()
	{    
		$this->active = array('system','host.site.index');
		$value = Classes::get_config($this->config_key);
		$rt = \application\core\Pagination::run('\application\modules\host\models\Host',array('orderBy'=>'sort desc,id desc'),array('pageSize'=>50));  
 		
		return $this->render('index', array(
		   'models' => $rt->models,
		   'pages' => $rt->pages,
		   'value'=>$value,
		));
	}
	 
}
