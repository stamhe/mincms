<?php 
/**
* comm functions
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/ 
/**
* copyRight infomation
* 
*/
function copyRight(){
	return "&copy;<a href='http://mincms.com/' target='_blank'>MinCMS 2.0.1</a>";
}

function send_file($file,$name=null){
	$ext = \application\core\File::ext($file);
	\Yii::$app->response->sendFile($file,$name.$ext);
}

function xsend_file($file,$name=null){
	\Yii::$app->response->xSendFile($file,$name);
}

function import($alias){
	static $_import;
	$f = \Yii::getAlias($alias).'.php';
	$nid = md5($f);
	if(!isset($_import[$nid])){
		@include $f;
		$_import[$nid] = true;
	}
	 
}
function http(){
	$array = \Yii::$app->params['misc']; 
	if($array){
		$k = array_rand($array);
		$u = $array[$k]; 
	}
	if($u)
		return $u;
	return base_url();  
}
function merge($a, $b)
{
	$args = func_get_args();
	$res = array_shift($args);
	while (!empty($args)) {
		$next = array_shift($args);
		foreach ($next as $k => $v) {
			if (is_integer($k)) {
				isset($res[$k]) ? $res[] = $v : $res[$k] = $v;
			} elseif (is_array($v) && isset($res[$k]) && is_array($res[$k])) {
				$res[$k] = merge($res[$k], $v);
			} else {
				$res[$k] = $v;
			}
		}
	}
	return $res;
}
/**
* Yii params config
* 
*/
function params($key = null){
	if($key == null)
		return \Yii::$app->params;
	return \Yii::$app->params[$key];
}
/**
* redirect to other page
*
* Example:
* <code> 
* redirect( url('site/index') ); 
* </code>  
* @param  string $url   controller/action
* @param  array $parmas  params 
*/
function redirect($url, $statusCode = null){ 
	header('Location: '.$url , true,$statusCode);
}
/**
* refresh current page
*
* Example:
* <code> 
* refresh();
* </code>  
*/
function refresh(){ 
	return Yii::$app->response->refresh();
}
/**
* call widget ,the widget path under @application\widget
*
* Example:
* <code> 
* widget('ckeditor',array('tag'=>'ck'));
* the widget should be exists under
* @application\widget\ckeditor
* </code>
* @param  string $name   widget name
* @param  array  $params  params
* @return what's widget return,here will return same.
*/

function widget_application($name,$params=null){
	if(strpos($name,'::')!==false){
		$arr  = explode('::',$name);
		$name = $arr[0];
		$file = $arr[1];
	}else{
		$file = 'widget';
	}
	$cls = "application\widget\\$name\\$file";
	return $cls::widget($params);
}
function widget($name,$params=null){
	if(strpos($name,'@')!==false){
		 $n = substr($name,1);
		 $n = str_replace('/','\\',$n);
		 $n = str_replace('.','\\',$n);
		 return$n::widget($params);
	}else{
		return widget_application($name,$params);
	} 
}
/**
* call core widget. path is @application\core\widget
*
* Example:
* <code> 
* widget('modal');
* </code>
* @param  string $url   controller/action
* @param  array $parmas  params
* @return string  what's widget return,here will return same.
*/
function core_widget($name,$params=null){
	$cls = "application\core\widget\\$name";
	return $cls::widget($params);
}
/**
* plugin
* 
* @param  string $url   controller/action
* @param  array $parmas  params 
*/
function plugin($name,$params=null , $tag){
	$params['tag'] = $tag;
	$cls = "\application\plugin\\$name"; 
	echo $cls::widget( array( 'tag'=>'','params'=>$params ));
}
/**
* call module widget. path is @application\modules\$module\widget\$name 
*/
function module_widget($module,$name,$params=null){
	if(strpos($name,'::')!==false){
		$arr  = explode('::',$name);
		$name = $arr[0];
		$file = $arr[1];
	}
	$cls = "application\modules\\$module\widget\\$name";
	if($file) $cls = $cls."\\$file";
	return $cls::widget($params);
}
function module_exists($name){
	$modules = cache_pre('all_modules');
	if(!$modules) return false;
	if($modules[$name]) return true;
	return false;
}
/**
* get/set return url.
*
* Example:
* <code> 
* set return url path
* return_url( url('site/index') );
* get return url path
* return_url();
* </code>
* @param  string $url  url path. can called url function
*/
function return_url($url=null){
	if($url)
		return \Yii::$app->user->setReturnUrl($url);
	return host().\Yii::$app->user->returnUrl;
}
/**
* check current request is or not ajax request 
*/
function is_ajax(){ 
	return \Yii::$app->request->isAjax ? true:false;
}
/**
* get client ip address
*/
function ip(){
	return \Yii::$app->request->userHostAddress;
}

/**
* lauguage settings. it is support backend and front web page language set.
* it is use cookie and GET request.
*
* Example:
* <code> 
* language();
* language('admin_language'); 
* </code>
* @param  string $name   key 
* @return string  current language 
*/
function language($name='language'){ 
	if($_GET[$name]){
 		if($_GET[$name]){
 			cookie($name,$_GET[$name]);
 		}
 		return \Yii::$app->language = $_GET[$name];
 	}elseif(cookie($name)){ 
 		return \Yii::$app->language = cookie($name);
 	}
 	$lan = \Yii::$app->request->getAcceptedLanguages();
	$lan = $lan[0]; 
	return \Yii::$app->language = $lan;
 	
}
/**
* get web host address
* it is the same as  \Yii::$app->request->hostInfo
*/
function host(){
	return \Yii::$app->request->hostInfo;
}
 
 
/**
* get/set flash message
*
* Example:
*
* set flash message
* <code> 
* flash('success',__('success')); 
* </code>
* get flash message
* <code> 
* flash('success'); 
* </code>
* @param  string $type   flash message type
* @param  array $message  message
* @return string  if $message is null will return flash message
*/
function flash($type,$message=null){ 
	if($message)
		return Yii::$app->session->setFlash($type,$message);
	return Yii::$app->session->getFlash($type);
}
/**
* backend administrator user id
*
* Example:
* <code> 
* uid();
* </code>
* @return string  administrator logined user id
*/
function uid(){
	return \Yii::$app->user->identity->id;
}
/**
* check flash message type is exists or not.
*
* Example:
* <code> 
* has_flash('success');
* </code>
* @param  string $type   flash message type
* @return string  true/flase
*/
function has_flash($type){ 
	return Yii::$app->session->hasFlash($type); 
}
/**
* publish assets package
*
* Example:
* <code> 
* $path = publish( __DIR__.'/assets');
* </code>
* @param  string $assets   dir 
* @return string  asset url
*/
function publish($assets){
	$base = \Yii::$app->view->getAssetManager()->publish($assets);
	return $base[1];
}
/**
* generation css link  
*
* Example:
* <code> 
* css_file('css/admin.css'); 
* </code>
* @param  string $url   css file url
* @param  array $options   view \Yii::$app->view->registerCssFile
* @param  string $key  view \Yii::$app->view->registerCssFile 
*/
function css_file($url, $options = array(), $key = null){
	\Yii::$app->view->registerCssFile($url, $options , $key); 
}
/**
* generation javascript link  
*
* Example:
* <code> 
* js_file('js/jquery.js'); 
* </code>
* @param  string $url   javascript file url
* @param  array $options   view \Yii::$app->view->registerJsFile
* @param  string $key  view \Yii::$app->view->registerJsFile 
*/
function js_file($url, $options = array(), $key = null){
	\Yii::$app->view->registerJsFile($url, $options , $key); 
}
/**
* generation css style  code
*
* Example:
* <code> 
* css("
*	#top{
*		color:blue;
*	}	
*  "); 
* </code>
* @param  string $css   css style code 
*/
function css($css){
	\Yii::$app->view->registerCss($css); 
}
/**
* generation javascript code  
*
* Example:
* <code> 
* js("
	$('#top').hide();
  "); 
* </code>
* @param  string $js   javascript style code 
*/
function js($js){
	\Yii::$app->view->registerJs($js); 
}

/**
* generation url
*
* Example:
* <code> 
* url('site/index');
* url('site/posts',array('id'=>1));
* </code>
* @param  string $url   controller/action
* @param  array $parmas  params
* @return string  url string
*/
function url($url,$parmas=null){ 
	if(true===$url || false===$url || strpos($url,'/')===false){
		$aid = \Yii::$app->controller->action->id;
		if(strpos($url,'/')===false) $aid = $url;
		$url = \Yii::$app->controller->id.'/'.$aid;
		$module = \Yii::$app->controller->module->id; 
		if($module && $module!=\Yii::$app->id)
			$url = $module.'/'.$url;  
	}
	return \application\core\Html::url($url,$parmas);
} 
/**
* current used theme url
*/
function theme_url(){
	return Yii::$app->view->theme->baseUrl.'/';
}
/**
* current used theme path
*/
function theme_path(){
	return Yii::$app->view->theme->basePath.'/';
}
/**
* this application base url
*/
function base_url(){
	return Yii::$app->request->baseUrl.'/';
}
/**
* this application base path
*/
function base_path(){
	return Yii::$app->basePath.'/';
}
/**
* this application root path. it is relative [public] dir
*/
function root_path(){
	return Yii::$app->basePath.'/../public/';
}
/**
* current controller action's url
*
* Example:
* <code> 
* url_action('index'); 
* if current controller is site. it is the same as url('site/index')
* </code>
* @param  string $url   action
* @param  array $parmas  params
* @return string  url path
*/
function url_action($url=null,$parmas=null){ 
	if(!$url)  $url = \Yii::$app->controller->action->id;
	$url = \Yii::$app->controller->id.'/'.$url;
	$module = \Yii::$app->controller->module->id; 
	if($module && $module!=\Yii::$app->id)
		$url = $module.'/'.$url;  
	return application\core\Html::url($url,$parmas);
}
/**
* translation i18n
*
* Example:
* <code> 
* __('welcome'); 
* __('webcome','admin');
* </code>
* @param  string $message   message should be english
* @param  array $category  category for translation. default value 'application'
* @return string  tanslated string.
*/
function __($message,$category='app',  $params = array(), $language = null){ 
	return Yii::t($category, trim($message), $params = array(), $language = null);
}
/**
* get/set cookie
*
* Example:
* 
* set cookie:
* <code>  
* cookie('language','en'); 
* </code>
* get cookie:
* <code> 
* cookie('language');
* </code>
* @param  string $name   cookie name
* @param  array $value  params
* @param  string $expire  expire time. default is forever
* @return string  no $value return cookie value
*/
function cookie($name,$value=null,$expire=null){  
	if(false === $value){ 
		\Yii::$app->response->cookies->remove($name); 
	}elseif($value==null){  
		return \Yii::$app->request->cookies->getValue($name); 
	} 
	$options['name'] = $name;
	$options['value'] = $value; 
	$options['expire'] = $expire?:time()+86400*365; 
	$cookie = new \yii\web\Cookie($options);
 	\Yii::$app->response->cookies->add($cookie); 
}
/**
* remove cookie value
*
* Example:
* <code> 
* remove_cookie('language'); 
* </code>
* @param  string $name   cookie name 
*/
function remove_cookie($name){ 
	cookie($name,false);
}
/**
* system hook very good for controller hook or others 
* it is Hook.php file exists on modules/module_name/Hook.php
*
* Example:
* <code>
* hook('action_init');
* </code>
*/
function hook(){
	$array = null;
	$hooks = cache_pre('hooks'); 
	if(!$hooks) return;
	$args = func_get_args();  
	$name = $args[0];
	unset($args[0]);    
	$h = $hooks[$name]; 
	if(!is_array($h)) return; 
	foreach($h as  $cls){  
		$array[] = $cls::$name($args[1]);
	} 
	
	return $array;
 
}
function hooks(){
	return cache_pre('hooks');
}
/**
* add hooks 
*
* Example:
* <code>
* hook_add('beforeSave',"\application\modules\content\widget\datepicker\Widget");
* </code>
*/
function hook_add($name,$cls){
	if(!$name || !$cls) return;
	$hooks = cache_pre('hooks');
	if($hooks){
 		if($hooks[$name]){
 			$hooks[$name] = merge($hooks[$name] , $cls);
 		}else
			$hooks[$name] = $cls;  
		cache_pre('hooks' , $hooks); 
		 
	} 
 
}
/**
* dump array style.
* like print_r
*/
if ( ! function_exists('dump'))
{
	function dump($str){
		print_r('<pre>');
		print_r($str);
		print_r('</pre>');
	} 
}
/**
* cache something before application start
*
* Example:
*
* set cache:
* <code>  
* cache_pre('modules',array());
* </code>
* get cache:
* <code>  
* cache_pre('modules');
* </code>
* @param  string $name   cache key
* @param  string $value  value
* @return string   
*/
if ( ! function_exists('cache_pre'))
{
	function cache_pre($name,$value=null){ 
	 	return MinCache::set($name,$value);
	}
}
/**
* delete cache
* @param  string $name   cache key 
*/
function cache_pre_delete($name){ 
 	return MinCache::delete($name);
}
/**
* Yii cache 
*
* Example:
*
* set cache:
* <code> 
* cache('a',123);
* </code>
* get cache:
* <code> 
* cache('a');
* </code>
* @param  string $name   cache key
* @param  string $value  cache value
* @param  string $expire  expire time. default forever
* @return string  if $value null, return cache value
*/
function cache($name,$value=null,$expire=0){  
	if($value===false) return \Yii::$app->cache->delete($name);
	$data = \Yii::$app->cache->get($name);
	if(!$value) return $data; 
	\Yii::$app->cache->set($name,$value,$expire); 
}
/**
* encode string
*
* Example:
* <code> 
* encode('mincms','key');
* encode('yii');
* </code>
* @param  string $data   encode data
* @param  array $key  encode key
* @return string  base64_encode string
*/
function encode($data, $key=null){
	if(!$key) $key = \Yii::$app->params['SecurityHelper']; 
	$code = \yii\helpers\Security::encrypt($data, $key);
	return base64_encode($code);
}
/**
* decode encode value
*
* Example:
* <code> 
* $code = encode('mincms','a');
* decode($code, 'a');
* </code>
* @param  string $data   encode value
* @param  array $key  encode key
* @return string  decode value
*/
function decode($data, $key=null){
	if(!$key) $key = \Yii::$app->params['SecurityHelper'];
	return \yii\helpers\Security::decrypt(base64_decode($data), $key);
}
/**
* backend administrator auth check is it option your self?
* @param  string $value   auth value 
* @return bool true/false
*/
function self($value){
	$in = application\modules\auth\Auth::in();   
	$self = \Yii::$app->user->identity->yourself; 
	if(!$self) return true;
	if(false === $in){
		return false;
	}else if(in_array($value,$in)){
		return true;
	} 
	
}
function user($name){
	return \Yii::$app->user->identity->$name;
}

 
/**
* get core config value
* @param  string $name   config key 
* @return string  config value
*/
function get_config($name){
	$k = 'get_config'.$name;
	$data = cache($k);
	if(!$data){
		$model = \application\modules\core\models\Config::find(array('slug'=>$name));
		$data = $model->body;
		cache($k,$data);
	}
	return $data;
}
/**
* use module Classes , it is easy create usefull function .
*
* Example:
* <code> 
* module_class('image.Classes.image','upload/1.jpg',array(
*	'resize'=>array(160,120)
*  ));
* namespace application\modules\image;  
*	class Classes
*	{
*		 static function image($args){
*		    $file = $args[1];
*		    $option = $args[2]; 
*			if(is_array($option)){
*				$s = base64_encode(json_encode($option));
*			} 
*			return "/imagine/".$s.$file;
*		}
*	} 
* </code> 
*/
function module_class(){
	$args = func_get_args(); 
	$classes = $args[0];
	unset($args[0]);  
	$arr = explode('.',$classes);
	$module = $arr[0];
	$class=$arr[1];
	$method=$arr[2];
	$cls = "\application\modules\\$module\\$class";
	return $cls::$method($args);

}

