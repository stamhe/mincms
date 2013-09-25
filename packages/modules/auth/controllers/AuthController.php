<?php namespace application\modules\auth\controllers; 
use application\modules\auth\models\Access;
use application\modules\auth\models\GroupAccess;
use application\core\Dir;
use application\core\Arr;
use application\core\DB;
/**
* generate access lists
* 
* @author Sun < mincms@outlook.com >
*/
class AuthController extends \application\core\AuthController
{ 
	function init(){
		parent::init();
		$this->active = array('auth');
	}
	/**
	* 用户组绑定权限
	*/
	public function actionIndex($id)
	{ 	
		$id = (int)$id;
		$model = \application\modules\auth\models\Group::find($id);
		foreach($model->access as $g){
			$access[] =  $g->access_id;
		} 
		$cache = cache('auth_controller_file');
		if(!$cache){ 
			$d = $this->_get_modules(\Yii::getAlias('@application/modules'));   
			if($d)
		   		Access::generate($d);  
		   	Dir::$kep_list_file = false; 
		   	$d = $this->_get_modules(\Yii::getAlias('@app/modules'));  
		    if($d)
		   		Access::generate($d); 
		   	cache('auth_controller_file',true);
	   	} 
	   	$rows = DB::all('auth_access',array(
	   		'select'=>"id,name,pid"
	   	));
	     
		foreach($rows as $v){
			$out[$v['id']] = $v;
		}
		$rows = Arr::_tree_id($rows); 
 	 	if($_POST){
 	 		$auth = $_POST['auth'];
 	 		GroupAccess::saveAccess($id,$auth);
 	 		flash('success',__('set access success'));
 	 		redirect(url('auth/auth/index',array('id'=>$id))); 
 	 	}
		return $this->render('index',array(
			'rows'=>$rows,
			'out'=>$out,
			'model'=>$model,
			'id'=>$id,
			'access'=>$access
		));
	}
	
	/**
	* get all controller as key ,actions as value
	*/
	protected function _get_modules($dir){
		unset($actions);
		$p = $dir;  
		$lists = \application\core\Dir::listFile($p,'Controller.php');   
		
		$dirs = $lists['dir'];   
		if(!$dirs) return; 
		$i=0; 
		foreach($dirs as $dir){ 
			$key = substr($dir,0,-4); 
			$name = str_replace($p,'',$key);
			if(substr($name,0,1)=='/') $name = substr($name,1); 
			$module_name =  substr($name,0,strpos($name,'/'));   
			$class = ucfirst(substr($key,strrpos($key,'/')+1)); 
			$line = @file_get_contents($dir);  
			preg_match_all('/.*class.*extends(.*)/i',$line,$out);    
			if(false!==strpos($out[1][0],'\application\core\AuthController')) { 
				 $new_dirs[$module_name.'.'.$class."##".$i] = $dir; 
				 $i++;
			}  		

		}  
		if(!$new_dirs) return; 
		foreach($new_dirs as $k=>$dir){ 
			$lineNumber = 0; 
			$file = fopen($dir, 'r');
			while( feof($file)===false )
			{ 
				++$lineNumber;
				$line = fgets($file);
				preg_match('/public[ \t]+function[ \t]+action([A-Z]{1}[a-zA-Z0-9]+)[ \t]*\(/', $line, $matches);
				if( $matches!==array() )
				{
					$name = $matches[1];
					$k = str_replace('Controller','',$k);
					$k = strtolower($k); 
					$actions[substr($k,0,strpos($k,'##'))][ strtolower($name) ] = array(
						'name'=>$name,
						'line'=>$lineNumber
					);
				
					
				}
			}
		} 
		return $actions; 
	}

	 
}
