<?php namespace application\modules\core\controllers; 
/**
* minify
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/
class MinifyController extends \application\core\Controller
{ 
	/**
	* for \application\core\View
	*/
	public function actionIndex()
	{ 
		$g = $_GET['g'];  
		$f = urldecode($_GET['files']); 
		$files = explode(',',$f);  
		unset($_GET['files']); 
		$groups[$g] = $files;    
	 
		$this->minify($groups);
		 
	}
	public function minify($groups){
		define('MINIFY_MIN_DIR', __DIR__.'/../libraries/min'); 
		// load config
		require MINIFY_MIN_DIR . '/config.php';  
		require "$min_libPath/Minify/Loader.php"; 
		\Minify_Loader::register(); 
		\Minify::$uploaderHoursBehind = $min_uploaderHoursBehind;
		\Minify::setCache(
		    isset($min_cachePath) ? $min_cachePath : ''
		    ,$min_cacheFileLocking
		); 
		if ($min_documentRoot) {
		    $_SERVER['DOCUMENT_ROOT'] = $min_documentRoot;
		    \Minify::$isDocRootSet = true;
		} 
		$min_serveOptions['minifierOptions']['text/css']['symlinks'] = $min_symlinks;
		// auto-add targets to allowDirs
		foreach ($min_symlinks as $uri => $target) {
		    $min_serveOptions['minApp']['allowDirs'][] = $target;
		} 
		if ($min_allowDebugFlag) {
		    $min_serveOptions['debug'] = \Minify_DebugDetector::shouldDebugRequest($_COOKIE, $_GET, $_SERVER['REQUEST_URI']);
		} 
		if ($min_errorLogger) {
		    if (true === $min_errorLogger) {
		        $min_errorLogger = \FirePHP::getInstance(true);
		    }
		    \Minify_Logger::setLogger($min_errorLogger);
		} 
		// check for URI versioning
		if (preg_match('/&\\d/', $_SERVER['QUERY_STRING'])) {
		    $min_serveOptions['maxAge'] = 31536000;
		} 
		$min_serveOptions['minApp']['groups'] = $groups; 
	    if (! isset($min_serveController)) {
	        $min_serveController = new \Minify_Controller_MinApp();
	    }
	    \Minify::serve($min_serveController, $min_serveOptions); 
		 
	}

	 
}
