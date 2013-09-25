<?php namespace application\modules\imagecache\controllers;  
use application\modules\imagecache\models\Image;
 
/**
* 图片缓存后台管理
*  
* @author Sun < mincms@outlook.com >
*/
class AdminController extends \application\core\AuthController
{ 
	public $imagecache;
	function init(){
		parent::init();
		$imagecache = array(
			'resize','crop','crop_resize','rotate',
			'flip','watermark','border','mask',
			'rounded','grayscale',
		);
		foreach($imagecache as $i){
			$this->imagecache[$i] = $i;
		}
		$this->active = array('system','imagecache.admin.index');
	}
	 
	public function actionCreate()
	{  
		$this->view->title = __('create image');
		$model = new Image();
	 	$model->scenario = 'all';
	 	
		if ($model->load($_POST) && $model->validate()) {  
		 	$model->save(); 
		 	flash('success',__('create sucessful'));
			$this->redirect(url('imagecache/admin/index'));
		} 
		return $this->render('form', array(
		   'model' => $model, 
		   'image' => $this->imagecache
		));
	}
	public function actionUpdate($id)
	{  
		$this->view->title = __('update image') ."#".$id;
		$model = Image::find($id);
	 	$model->scenario = 'all';
		if ($model->load($_POST) && $model->validate()) { 
		 	$model->save();
		 	flash('success',__('update sucessful'));
			$this->redirect(url('imagecache/admin/index'));
		} 
		return $this->render('form', array(
		   'model' => $model, 
		   'image' => $this->imagecache
		));
	}
	public function actionDelete($id){
		if($_POST['action']==1){ 
			$model = Image::find($id); 
			$model->delete();
			echo json_encode(array('id'=>array($id),'class'=>'alert-success','message'=>__('delete success')));
			exit;
		} 
	}
	public function actionIndex()
	{    
		$rt = \application\core\Pagination::run('\application\modules\imagecache\models\Image',null,array('pageSize'=>50));  
 		
		return $this->render('index', array(
		   'models' => $rt->models,
		   'pages' => $rt->pages,
		));
	}
}
