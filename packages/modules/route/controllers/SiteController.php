<?php namespace application\modules\route\controllers;  
use application\core\DB;
use application\modules\route\models\Route;  
/**
*   
* 
* @author Sun < mincms@outlook.com >
*/
class SiteController extends \application\core\AuthController
{ 
	function init(){
		parent::init();
		$this->active = array('system','route.site.index'); 
	}
	function actionSort(){ 
 		$ids = $sort = $_POST['ids']; 
 		arsort($sort); 
 		$sort = array_merge($sort,array()); 
 		$table = "route";
 		$fid = $id; 
 		foreach($ids as $k=>$id){ 
 		 	DB::update($table,
	 			array(
	 				'sort'=>$sort[$k]
	 			),'id=:id', array(':id'=>$id)
 		 	); 
 		}  
 		$this->clear_cache();
 		return 1; 
	}
	
	public function actionCreate()
	{  
		$this->view->title = __('create route');
		$model = new Route();
	 	$model->scenario = 'all';
		if ($model->load($_POST) && $model->validate()) { 
		 	$model->save();
		 	$this->clear_cache();
		 	flash('success',__('create sucessful'));
			$this->redirect(url('route/site/index'));
		} 
	 
		return $this->render('form', array(
		   'model' => $model, 
		));
	}
	public function actionUpdate($id)
	{  
		$this->view->title = __('update route') ."#".$id;
		$model = Route::find($id);
	 	$model->scenario = 'all';
		if ($model->load($_POST) && $model->validate()) { 
		 	$model->save();
		 	$this->clear_cache();
		 	flash('success',__('update sucessful'));
			$this->redirect(url('route/site/index'));
		} 
		return $this->render('form', array(
		   'model' => $model,  
		));
	}
	public function actionDelete($id){
		if($_POST['action']==1){ 
			$model = Route::find($id); 
			$model->delete();
			echo json_encode(array('id'=>array($id),'class'=>'alert-success','message'=>__('delete success')));
			exit;
		} 
	}
	public function actionIndex()
	{    
		$rt = \application\core\Pagination::run('\application\modules\route\models\Route',array('orderBy'=>'sort desc,id desc'),array('pageSize'=>50));  
 		
		return $this->render('index', array(
		   'models' => $rt->models,
		   'pages' => $rt->pages,
		));
	}
	protected function clear_cache(){ 
		$all = Route::find()->all(); 
		if($all){
			foreach($all as $v){
				$a = $v->route;
				$a = str_replace('[','<',$a);
				$a = str_replace(']','>',$a); 
				$route[$a] = $v->route_to;
 			}  
			\MinCache::set('route',$route);
		} 
	}

	 
}
