<?php namespace application\modules\auth\controllers; 
use application\modules\auth\models\Group;
use application\modules\auth\models\UserGroup;
use application\core\Arr;
/**
*  用户组
* 
* @author Sun < mincms@outlook.com >
*/
class GroupController extends \application\core\AuthController
{ 
	function init(){
		parent::init();
		$this->active = array('auth','auth.group.index');
	}
	/**
	* 用户绑定到组
	*/
	public function actionBind($id)
	{ 	
		$id = (int)$id;
		$model = \application\modules\auth\models\User::find($id);
		foreach($model->groups as $g){
			$groups[] =  $g->group_id;
		}  
		$rows = Group::find()->all();
		if($rows)
			$rows = Arr::model_tree($rows); 
 	 	if($_POST){
 	 		$group = $_POST['group'];
 	 	 	//绑定用户到组
 	 		UserGroup::UserGroupSave($id,$group); 
 	 		flash('success',__('bin user group success'). " # ".$id);
 	 		redirect(url('auth/group/bind',array('id'=>$id))); 
 	 	}
 	  
		return $this->render('bind',array(
			'rows'=>$rows, 
			'groups'=>$groups,
			'model'=>$model,
			'id'=>$id,
		 	'self'=>$model->yourself
		));
	}
	public function actionCreate()
	{   
		$this->view->title = __('create group');
		$model = new \application\modules\auth\models\Group();
	 	$model->scenario = 'create';
		if ($model->load($_POST) && $model->validate()) { 
		 	$model->save();
		 	flash('success',__('create group sucessful'));
			refresh();
		} 
		return $this->render('form', array(
		   'model' => $model,
		   'name'=>'group_create', 
		));
	}
	public function actionUpdate($id)
	{   
		$this->view->title = __('update group');
		$model = \application\modules\auth\models\Group::find($id);
	 	$model->scenario = 'update';
		if ($model->load($_POST) && $model->validate()) { 
		 	$model->save();
		 	flash('success',__('update group sucessful'));
			refresh();
		} 
		return $this->render('form', array(
		   'model' => $model, 
		   'name'=>'group_create',
		));
	}
	public function actionDelete($id){
		if($_POST['action']==1){
			$model = \application\modules\auth\models\Group::find($id); 
			$ids =  $model->delete_ids;
			$model->delete();
		 
			$n = " #".implode('_',$ids);
			echo json_encode(array('id'=>$ids,'class'=>'alert-success','message'=>__('delete group success').$n ));
			exit;
		} 
	}
	public function actionIndex()
	{    
		$rt = \application\core\Pagination::run('\application\modules\auth\models\Group'); 
		return $this->render('index', array(
		   'models' => $rt->models,
		   'pages' => $rt->pages,
		));
	}

	 
}
