<?php namespace application\core;  
use application\core\DB;
/**
*  default controller
* 
* @author Sun < mincms@outlook.com >
*/
class Controller extends \yii\web\Controller
{ 
	public $theme = 'classic';
	/**
	* active menu
	* 启用的菜单
	*/
	public $active; 
	/**
	* guest unique cookie
	* 访问用户的唯一值
	*/
	public $guest_unique;
	/**
	* view title
	*/
	public $title;
	/**
	* minify code
	*/
	public $minify = true;
	public $minify_js = false;
	public $minify_css = false;
	/**
	* mongo_db
	*/
	public $mongo_db; 
	function init(){
		parent::init();  
		/*
		* load modules 
		* 加载模块
		*/
		 
		if(YII_DEBUG ===true || !MinCache::set('all_modules')) 
			$this->_load();  
			 
		if(class_exists('Mongo') && true === params('mongo_enable') )
			$this->mongo_db = new MongoDB;
	 
		$unique = cookie('guest_unique');  
		if(!$unique){ 
			$unique = uniqid(); 
			cookie('guest_unique',$unique);
		}
		$this->guest_unique = $unique;  
		language();   
		hook('action_init',$this); 
			
	} 
	public function beforeAction($action)
	{
		parent::beforeAction($action);
		hook('action_before',$this); 
		return true;
	}
	public function afterAction($action, &$result)
	{
		parent::afterAction($action, $result);
		hook('action_after',$this); 
		return true;
	}
 	function redirect($url, $statusCode = null){
 		redirect($url , $statusCode);  
 	}
	/**
	* 渲染多个视图中第一个存在的视图
	$arr = array(theme_path().'_elements/do','do'); 
	echo $this->render($this->view($arr),$data); 
	*/
	function view($path){
		foreach($path as $p){ 
			$file  = $this->findViewFile($p); 
			$flag = false;
			if(strpos($p,'@web/themes')!==false){
				$file = root_path().$file; 
				$flag = true;
			}
			if(file_exists($file)){
				if($flag === true) 
					return "@web/web/".substr($p,5);
				else
					return $p;
			}
		}
	}
	
	/*
	* load modules 
	* 加载模块
	*/
	protected function _load(){ 
		$sql = "select * from core_modules where active=1 order by sort desc,id asc";  
		$all = DB::queryAll($sql);  
		$m = \MinCache::modules(true);  
	 	if(!$all) {
	 		$all = array('core', 'auth','imagecache','file' ,'route');
	 	}
	 	 
		foreach($all as $v){ 
			if(is_array($v))
				$name = $v['name']; 
			else
				 $name = $v;  
			$out[$name] = 1;
			//加载Hook.php
			$alis = $m[$name];			
	 		$dir = $app[$alis].'/modules/';
			$h = $dir.$name.'/Hook.php';
			if(file_exists($h)){ 
				include_once($h);
		 		$reflection = new \ReflectionClass("\\".$alis."\modules\\$name\Hook"); 
				$methods = $reflection->getMethods();  
				if($methods){
					foreach($methods as $method){
						$action[$method->name][$name] = "\\".$method->class;
					} 
				} 
			 
			} 
		} 
		$sql = "select * from route  order by sort desc,id asc";
		$all = DB::queryAll($sql); 
		if($all){
			foreach($all as $v){
				$a = $v->route;
				$a = str_replace('[','<',$a);
				$a = str_replace(']','>',$a); 
				$route[$a] = $v->route_to;
 			}  
			\MinCache::set('route',$route);
		} 
		
		\MinCache::set('all_modules_alias',$m); 
		\MinCache::set('all_modules',$out);  
		$hooks = \MinCache::set('hooks');
		if($hooks && $action) $action = merge($hooks,$action); 
		\MinCache::set('hooks',$action); 
		
	}
}