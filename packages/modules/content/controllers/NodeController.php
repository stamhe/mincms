<?php namespace application\modules\content\controllers;   
use application\modules\content\models\Field;
use application\modules\content\models\Widget;
use application\modules\content\models\FormBuilder;
use application\modules\content\Classes;
use application\core\DB;
/** 
* @author Sun < mincms@outlook.com >
*/
class NodeController extends \application\core\AuthController
{ 
	//允许操作的列表
	public $_allowAccess = array('content.node.index');
 	function loadHook(){
 		$dirs = array(
 			'app'=>\Yii::getAlias('@app/hook'),
 			'application'=>\Yii::getAlias('@application/hook')
 		); 
 		foreach($dirs as $k=>$d ){  
 			$list = scandir($d);
 			if(!$list) continue;
			foreach($list as $vo){   
				if($vo !="."&& $vo !=".." && $vo !=".svn" && strpos($vo , '.php')!==false)
				{ 
					$name = str_replace('.php' , '' ,$vo);
					$out[$name] = "\\".$k."\hook\\$name";
				}
				
			}
		}
		if($out)
			hook_add('cck_hook',$out); 
	 
 	}
	function init(){
		parent::init();
		$this->loadHook();  
		$this->active = array('content','content.node.index'); 
	}
	public function actionSort(){ 
 		$ids = $sort = $_POST['ids']; 
 	 	$slug = $_POST['name']; 
 		arsort($sort); 
 		$sort = array_merge($sort,array()); 
 		$table = "node_{$slug}";
 		$fid = $id; 
 		foreach($ids as $k=>$id){ 
 		 	DB::update($table,
	 			array(
	 				'sort'=>$sort[$k]
	 			),'id=:id', array(':id'=>$id)
 		 	); 
 		}   
 		\Yii::$app->cache->flush();
 		return 1; 
	}
	public function actionDisplay($name,$id){
		$model = Classes::one_full($name,$id); 
		if(!self($model->uid) && uid()!==1){
			throw new \Exception(__('not your create'));
		}
		$id = (int)$id;
		if($id<1) exit;
		$table = "node_{$name}";
		$one = DB::one($table,array(
			'where'=>array('id'=>$id)
		));
		$display = $one['display']==1?0:1;
		DB::update($table,array(
			'display'=>$display
		),'id=:id',array(':id'=>$id)); 
		flash('success',__('sucessful'));
		\Yii::$app->cache->flush();
		$this->redirect(url('content/node/index',array('name'=>$name)));
	}
	
	public function actionCreate($name)
	{  
		$this->active = array('content.node.index','content.node.cck.'.$name); 
		
		$one = Field::find()->where(array('slug'=>$name))->one();
		$this->view->title = __('create');
		return $this->render('form',array(
			'name'=>$name,
			'one'=>$one
		));
	}
	public function actionUpdate($name,$id)
	{  
		$this->active = array('content.node.index','content.node.cck.'.$name); 
		$one = Field::find()->where(array('slug'=>$name))->one();
		$model = Classes::one_full($name,$id); 
		if(!self($model->uid) && uid()!==1){
			throw new \Exception(__('not your create'));
		}
		$this->view->title = __('update').' #'.$id;
		return $this->render('form',array(
			'name'=>$name,
			'one'=>$one,
			'id'=>$id
		));
	}
	public function actionDelete($id){
		$model = Classes::one_full($name,$id); 
		if(!self($model->uid) && uid()!==1){
			throw new \Exception(__('not your create'));
		}
		if($_POST['action']==1){ 
			$model = Field::find($id); 
			$model->delete();
			\Yii::$app->cache->flush();
			echo json_encode(array('id'=>array($id),'class'=>'alert-success','message'=>__('delete success')));
			exit;
		} 
	}
	/***
	* content list
	*/
	public function actionIndex()
	{     
		$name = $_GET['name']?:"";
		if(!$name) throw new \Exception('params error');
		$rest = $_GET['rest']?:"";
		$pid = $_GET['pid']?:0;
		$this->active = array('cck_content','content.node.cck.'.$name); 
 		/**
	 	* set filter cookie.
	 	* if no post [NodeActiveRecord] will try use cookie
	 	*/
	 	$filterCookieId = "filter_cookie_".md5(cookie('guest_unique').uid().$name); 
	 	$filters =  cookie($filterCookieId);  
	 	if($rest){
	 		remove_cookie($filterCookieId);  
	 		flash('success',__('reset filter success'));
	 		redirect(url('content/node/index',array('name'=>$name)));
	 	}
	 	if($_POST['NodeActiveRecord']){ 
	 		$post = $_POST['NodeActiveRecord'];
	 	 	$filters = array();
	 	 	$hidden = $_POST['hidden']; 
	 		foreach($post as $k=>$v){
	 			if($v){ 
	 				if($hidden[$k]){
	 					$filters[] = array($k,'like',trim($v));
	 				}
	 				else{
	 					$filters[$k] = trim($v);
	 				}
	 			}
	 		} 
	 		if($filters)
	 			cookie($filterCookieId,$filters); 
	 		flash('success',__('set filter success'));
	 	}
	 	$condition['orderBy'] = 'sort desc,id desc';
	 	if($filters){
	 		$condition['where'] = $filters;
	 	}
	 	if($name == 'taxonomy'){
	 		$condition['where'] = array('pid'=>$pid); 
	 	}
	 	/**
	 	* load pager data
	 	*/
 		$data = Classes::pager($name,$condition,50);
 		 
 	 
 		$data['name'] = $name;
 		$one = DB::one('content_type_field',array(
	 		'where'=>array('slug'=>$name,'pid'=>0)
	 	)); 
	 	if(!$one['id']) {
	 		
	 		exit;
	 	}
	 	$fid = $one['id'];	
	 	$data['fid']  = $fid;
	 	$data['filters']  = $filters; 
		$data['types'] = Field::find()->where(array('pid'=>0))->orderBy('sort desc,id asc')->all(); 
		$data['name'] = $name;
		$db = DB::one('content_type_field',array(
			'where'=>array(
				'slug'=>$name
			)
		));
		$data['label'] = $db['name'];
		 
		if($pid>0){
			$m = Classes::one($name,$pid); 
			$data['pid'] = $m->id;
			
		}
 		if($name == 'taxonomy'){
 			return $this->render('taxonomy' ,$data );
 		}else
			return $this->render('index' ,$data );
	}

	 
}
