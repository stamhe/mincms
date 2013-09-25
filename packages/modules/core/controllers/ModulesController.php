<?php namespace application\modules\core\controllers; 
use application\modules\core\models\Modules;
use application\core\DB; 
/**
* modules install
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/ 
class ModulesController extends \application\core\AuthController
{ 
	public $_base;
	public $bin;
	public $name;
	public $pwd;
	public $db_name;
	public $host;
	public $app;
	
	/**
	* 内核主要模块，不能改动。
	*/
	protected $_core_modules = array(
		'core', 'auth','imagecache','file' ,'route'
	);
	
	function init(){ 
		parent::init();
		$this->active = array('system','core.modules.index');
 		$this->_base = \Yii::getAlias('@application').'/modules/';
		$this->app = \Yii::getAlias('@app').'/modules/';
		foreach($this->_core_modules as $m){
			$load = Modules::find()->where(array('name'=>$m))->one();
			if($load) continue;
			$this->load_module($m,true);
		}
		$row = DB::queryOne("SHOW VARIABLES LIKE '%basedir%'");
		foreach($row as $k=>$v){
			$k = strtolower($k);
			if($k=='value')
				$this->bin = $v.'/bin/';
		}   
		$dsn = \Yii::$app->db->dsn;
		$n = explode(';',$dsn); 
		$this->host = substr( $n[0] ,strpos($dsn,'=')+1);  
		$this->db_name = substr( $dsn ,strrpos($dsn,'=') +1); 
		$this->name = \Yii::$app->db->username;
		$this->pwd = \Yii::$app->db->password;
	}
	
	public function actionIndex()
	{    
		
		$base = $this->_base;
		$models = Modules::find()->where(array('active'=>1))->orderBy('core asc,sort desc,id asc')->all();
		if($models){
			foreach($models as $model){
				$name = $model->name;
				$array[$name]['name'] = $name;
				$array[$name]['active'] = $model->active;
				$array[$name]['core'] = $model->core;
				$array[$name]['path'] = $base.$name;
				$array[$name]['info'] = @include $base.$name.'/info.php';
			}
		} 
		foreach (glob($base.'*') as $v)
		{
			$a = '/controllers';
			$name = str_replace($base,'',$v); 
			if(!is_dir($v)) continue; 
			$data[$name]['default'] = false;
			if(file_exists($v.'/lock')){ 
				unset($data[$name]);
				continue;
			} 
			$data[$name]['name'] = $name;
			$data[$name]['path'] = $v;
			$data[$name]['info'] = @include $v.'/info.php';
			if($array[$name]){
				unset($data[$name]); 
			} 
			$file[$name] = $name;
		}  
		
		if($array){ 
 			$data = array_merge($data,$array); 
 		} 
 		/**
 		* load app modules
 		*/ 
 		foreach (glob($this->app.'*') as $v)
		{
			$name = str_replace($this->app,'',$v); 
			$app[$name]['name'] = $name;
			$app[$name]['path'] = $v;
			$app[$name]['active'] = $array[$name]['active']?:false;
			$app[$name]['info'] = @include $v.'/info.php'; 
			$file[$name] = $name;
		} 
	 
		if($array){
			$error = null;
			foreach($array as $k=>$v){
				if(!in_array($k,$file)){ 
					$m = Modules::find(array('name'=>$k));
					if($m){
						$m->delete(); 
						$error .= '<br>remove module:'.$k.'<br>';
					}
					unset($array[$k]);
				}
			}
			if($error)
				flash('error',$error);
		}
		$a = \MinCache::modules(false); 
 	 	if($a['##']){
 	 		return $this->render('error' , array('rows'=>$a['##']));
 	 	}
 	 	
 	 	if($app){
 	 		foreach($app as $k=>$v)
 	 			unset($data[$k]);
 	 	}
		return $this->render('index',array('data'=>$data,'models'=>$models,'_core_modules'=>$this->_core_modules,'app'=>$app));
		 
	}
	protected function load_module($id,$flag=false){ 
		$alias = cache_pre('all_modules_alias');
		$alia = $alias[$id];
		$path = \Yii::getAlias("@".$alia."/modules/");
		$active = 1;
		$model = Modules::find(array('name'=>$id));
		if($model){
			if($model->active == 1)
				$active = 0;
		}
		else{
			$model = new Modules; 
	 	}
	 	$model->core = $flag;
	 	if(true === $flag) $active = 1;
		$info =  @include $path.$id.'/info.php'; 
		 
		$classes = $path.$id.'/class.php';  
	 
		$model->name = $id;
		$model->label = $info['label']; 
		$model->memo = $info['memo'];
		$model->active = $active; 
	 
		if(!$model->save()){ 
		}
	 
		/**
		* reload modules
		* 重新加载模块
		*/ 
		$this->_load();  
	 	return $model->active;
	}
	 
	/**
	* 安装数据库
	*/ 
	public function actionInstall($id){ 
		$id = $_GET['id'];  
		$alias = cache_pre('all_modules_alias');
		$alia = $alias[$id];
		$file = \Yii::getAlias("@".$alia."/modules/$id/{$id}.sql");
	 
		$model = Modules::find(array('name'=>$id));  
		if(file_exists($file) && !$model){
			$sql = $this->bin."mysql -h ".$this->host." -u".$this->name." -p\"".$this->pwd."\" ".$this->db_name." <  ".$file; 
			exec($sql);  
		}
	 
		$this->load_module($id); 
	 
		flash('success',__('success'));
		$ret = $_GET['ret'];
		if($ret)
			$this->redirect(url($ret));
		$this->redirect(url('core/modules/index'));
	}

	 
}
