<?php namespace application\core;  
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
}