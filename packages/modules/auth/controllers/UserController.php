<?php namespace application\modules\auth\controllers; 
use application\core\DB;
/**
* admin create, update, delete, change password for auth_users
* this is backend users
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/ 
class UserController extends \application\core\AuthController
{ 
	//允许操作的列表
	public $_allowAccess = array('auth.user.change');
	function init(){
		parent::init();
		$this->active = array('auth','auth.user.index');
	}
	public function actionCreate()
	{  
		$this->view->title = __('create user');
		$model = new \application\modules\auth\models\User();
	 	$model->scenario = 'create';
		if ($model->load($_POST) && $model->validate()) { 
		 	$model->save();
		 	flash('success',__('create user sucessful'));
			refresh();
		} 
		return $this->render('form', array(
		   'model' => $model,
		   'name'=>'user_create', 
		));
	}
	public function actionUpdate($id)
	{  
		$this->view->title = __('update user') ."#".$id;
		$model = \application\modules\auth\models\User::find($id);
	 	$model->scenario = 'update';
		if ($model->load($_POST) && $model->validate()) { 
		 	$model->save();
		 	flash('success',__('update password sucessful'));
			refresh();
		} 
		return $this->render('form', array(
		   'model' => $model, 
		   'name'=>'user_update',
		));
	}
	public function actionDelete($id){
		if($_POST['action']==1){
			if($id==1){
				echo json_encode(array('id'=>array(0),'class'=>'alert-danger','message'=>__('supper user can not delete')));
 				exit;
			}
			if($id === uid()){ 
				echo json_encode(array('id'=>array(0),'class'=>'alert-danger','message'=>__('you can not remove yourself')));
				exit;
			}
			$model = \application\modules\auth\models\User::find($id); 
			$model->delete();
			echo json_encode(array('id'=>array($id),'class'=>'alert-success','message'=>__('delete user success')));
			exit;
		} 
	}
	public function actionIndex()
	{    
		$rt = \application\core\Pagination::run('\application\modules\auth\models\User');  
 		
		return $this->render('index', array(
		   'models' => $rt->models,
		   'pages' => $rt->pages,
		));
	}
	
	public function actionChange()
	{  
		$id = uid(); 
		if(module_exists('oauth')){
			$all = DB::all('auth_oauth',array('where'=>array('uid'=>$id)));
			if($all){
				foreach($all as $one){
					//relation  oauth_users 
					$user = DB::one('oauth_users',array('where'=>array('id'=>$one['oauth_id'])));
					$row = DB::one('oauth_config',array('where'=>array('id'=>$user['oauth_id'])));
					$third[] = array(
						'id'=>$one['id'],
						'username'=>$user['name'],
						'email'=>$user['email'],
						'token'=>$user['token'],
						'uid'=>$user['uid'],
						'slug'=>$row['slug'],
						'name'=>$row['name'],
					);
				}
				
			}
			$base = publish(\Yii::getAlias('@application/modules/oauth/assets'));   
		}
		$this->view->title = __('update user') ."#".$id;
		$model = \application\modules\auth\models\User::find($id);
	 	$model->scenario = 'change';
		if ($model->load($_POST) && $model->validate()) { 
			if(trim($_POST['User']['new_password']) || trim($_POST['User']['confirm_password'])){
				$model->scenario = 'update';
				if ($model->load($_POST) && $model->validate()) { 
					 $model->save();
					 flash('success',__('update sucessful'));
					 refresh();
				} else{
					flash('error',__('update failed'));
					refresh();
				}
			}else{ 
			  	$model->save();
			 	flash('success',__('update password sucessful'));
				refresh();
			}
		} 
		return $this->render('change', array(
		   'model' => $model, 
		   'name'=>'user_update',
		   'base' => $base, 
		   'third' => $third, 
		     
		));
	}
	public function actionUnbind($id){
		$id = (int)$id;
		if($id<1) throw new \Exception(__('reboot'));
		DB::delete('auth_oauth','id=:id',array(':id'=>$id));
		flash('success',__('action sucessful'));
		$this->redirect(url('auth/user/change'));
	}
	 
}
