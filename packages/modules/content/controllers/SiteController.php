<?php namespace application\modules\content\controllers; 
use application\modules\content\models\Field;
use application\modules\content\models\FieldView;
use application\modules\content\models\Widget;
use application\modules\content\Classes;
use application\core\DB;
/** 
* @author Sun < mincms@outlook.com >
*/
class SiteController extends \application\core\AuthController
{ 
	public $widget;
	public $plugin;
	function init(){
		parent::init();
		if(YII_DEBUG !== true){
			exit(__('locked cck')); 
		}
		cache('show_tables',false);
		$this->active = array('content','content.site.index');
		$this->widget = Field::widgets();
		$first[''] = __('please select');
		$this->widget = $first+$this->widget;
		$dir = \Yii::getAlias('@application')."/plugin"; 
		$list = scandir($dir); 
		foreach($list as $vo){   
			if($vo !="."&& $vo !=".." && $vo !=".svn"  && !is_dir($dir.'/'.$vo) )
			{  
				$v = substr($vo,0,-4); 
				$out[$v] = $v;
			}
		} 
		$this->plugin = $out; 
	}
	/**
	* ajax load plugin
	*/
	function actionPlugin(){
		$this->layout = false;
		$id = (int)$_POST['id'];
		if($id>0){
			$model = Field::find($id); 
			$data['plugin_value'] = $model->plugin; 
			$data['plugin_config'] = $model->plugin_config;
		}
		$value = strtolower($_POST['value']);  
		if(!$this->plugin) return;  
		$out[] = __('please select');
		foreach($this->plugin as $k=>$v){
			$n = strtolower($k);
			if(strpos($n ,$value) !== false){
				$test[$k] = $out[$k] = $v;
			}
		}
		if(!$test) return;
		
		$data['plugin'] = $out;
		
		return  $this->render('plugin' , $data); 
		 
	}
	function actionSort(){  
		$model = Field::find((int)$_POST['pid']);
		$slug = $model->slug;
 		$ids = $sort = $_POST['ids']; 
 		arsort($sort); 
 		$sort = array_merge($sort,array()); 
 		$table = "content_type_field";
 		$fid = $id; 
 		foreach($ids as $k=>$id){ 
 		 	DB::update($table,
	 			array(
	 				'sort'=>$sort[$k]
	 			),'id=:id', array(':id'=>$id)
 		 	); 
 		}  
 	  	$cacheId = "modules_content_Class_structure{$slug}";
		cache($cacheId,false);
 		return 1;
 		
  
	}
	/**
	* set search filed
	*
	*/
	function actionSearch($slug , $name ,$type='search'){
	 	$one = DB::one('content_type_field',array(
	 		'where'=>array('slug'=>$slug,'pid'=>0)
	 	));
	 	if(!$one) exit('access deny');
	 	$fid = $one['id'];	  
	 	$model = FieldView::find()->where(array('fid'=>$fid))->one(); 
	  
	 	if(!$model){
	 		$model = new FieldView;
	 		$model->$type = array($name=>$name);
	 	}else{
	 		$search = $model->$type;
	 		if($model->$type && in_array($name , $model->$type )){  
	 			unset($search[$name]);
	 		 	$model->$type = $search;
	 		}else{
	 		 	$search[$name] = $name;
	 			$model->$type = $search;
	 		}
	 	} 
	 	$model->fid = $fid; 
	 	$model->save();
	 	flash('success',__('set success'));
	 	$cacheId = "modules_content_Class_structure{$slug}";
		cache($cacheId,false);
		
	 	$this->redirect(url('content/node/index',array('name'=>$slug)));
	 	
	}
	function actionAjax(){
		if(!is_ajax()) exit('access deny');
		/**
		* create relate table
		* autoload widget from content module.
		* 
		static function content_type(){  
			return "<input type='hidden' name='Field[relate]' value='file'>";
		}
		*/  
		$w = $_POST['w'];
		if($w){ 
			$selected = $_POST['selected'];	
			$new = \application\modules\content\models\Field::widgets(false,$selected);
		 
			return $new[$w];
		}
	}
	public function actionCreate()
	{  
		$this->view->title = __('create content type');
		$model = new Field(); 
		if ($model->load($_POST) && $model->validate()) { 
		 	$model->save();
		 	flash('success',__('create sucessful'));
			//refresh();
		} 
		return $this->render('form', array(
		   'model' => $model,
		   'name'=>'content', 
		   'widget'=>$this->widget
		));
	}
	public function actionUpdate($id)
	{  
		$this->view->title = __('update content type') ."#".$id;
		$model = Field::find($id);
		if($model->pid > 0 ){
			$p = Field::find($model->pid);
		} 
		if ($model->load($_POST) && $model->validate()) { 
		 	$model->save(); 
		 	flash('success',__('update sucessful'));
			refresh();
		} 
		return $this->render('form', array(
		   'model' => $model, 
		   'name'=>'content',
		   'p'=>$p,
		   'id' =>$id,
		   'widget'=>$this->widget, 
		));
	}
	public function actionDelete($id){ 
		if($_POST['action']==1){
			$model = Field::find($id);  
			$model->delete();
			echo json_encode(array('id'=>array($id),'class'=>'alert-success','message'=>__('delete success')));
			exit;
		} 
	}
	public function actionIndex()
	{    
		$rt = \application\core\Pagination::run('\application\modules\content\models\Field',array('scope'=>'active','orderBy'=>'sort desc,id asc'),array('pageSize'=>500));  
 		if($_GET['pid'])
 			$model = Field::find((int)$_GET['pid']);
		return $this->render('index', array(
		   'models' => $rt->models,
		   'pages' => $rt->pages,
		   'model'=>$model
		));
	}

	 
}
