<?php namespace application\core;  
use application\core\JqueryAsset;
/**
* Minify View
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/

class View extends \yii\base\View
{ 
	public function registerJs($js, $position = self::POS_READY, $key = null)
	{
		$key = $key ?: md5($js);
		$this->js[$position][$key] = $js;
		if ($position === self::POS_READY) {
			JqueryAsset::register($this);
		}
	}
	/**
	*
	*  <code>
	*	'view' => array( 
	*		'class' => 'application\core\View',  
    *       'theme' => array(
    *        	'class' => 'application\core\Theme' 
	*	    ), 
    *   ),
    *  </code>
	*/
	public function renderFile($viewFile, $params = array(), $context = null)
	{
		$out = parent::renderFile($viewFile, $params , $context );
		if(\Yii::$app->controller->minify){ 
			$out =  preg_replace(array('/ {2,}/','/<!--.*?-->|\t|(?:\r?\n[\t]*)+/s'),array(' ',''),$out); 
		}
		return $out;
	} 
	protected function renderHeadHtml()
	{  
		if(\Yii::$app->controller->minify_css === true){ 
			$js = $this->cssFiles;  
			unset($this->cssFiles);
			$out = parent::renderHeadHtml(); 
			foreach($js as $k=>$v){ 
				if(strpos($k,'//')!==false){
					$httpJS[] = $v;
				}else if(strpos( $k , 'assets') !== false){  
					$files[] = $k;
				}else{ 
					$new .= $v; 
				}
			}   
			$jsfile = $this->minify($files , $httpJS ,'css'); 
			$out = $new . $jsfile . $out; 
			return $out;
		}
		return parent::renderHeadHtml(); 
	}
	protected function renderBodyEndHtml()
	{  
		if(\Yii::$app->controller->minify_js === true){ 
			$js = $this->jsFiles[self::POS_END];  
			unset($this->jsFiles[self::POS_END]);
			$out = parent::renderBodyEndHtml();  
			foreach($js as $k=>$v){ 
				if(strpos($k,'//')!==false){
					$httpJS[] = $v;
				}else{  
					if(substr($k,0,1) == '/')
						$k = substr($k,1);
					$files[] = $k;
				}
			}   
			$jsfile = $this->minify($files , $httpJS ,'js'); 
			$out = $jsfile . $out; 
			return $out;
		}
		return parent::renderBodyEndHtml(); 
	}
	
	protected function minify($files , $httpJS  , $type='js'){
		$dir = root_path().'/assets/cache/';
		if(!is_dir($dir))mkdir($dir,0777,true); 
		if($files){
			$u = md5(implode(',',$files)).'.min.'.$type; 
			$ui = base_url().'assets/cache/'.$u;  
			if(!file_exists($dir.$u)){ 
				if($files){
					$files = urlencode(implode(',',$files));
					$url = host().url('core/minify/index',array('g'=>$type , 'files'=>$files));  
					$js = @file_get_contents($url); 
					if($js)
						@file_put_contents($dir.$u , $js);
				}else{
					$ui =false;
				}
			}  
		}
		if($httpJS)
			$jsfile = implode("\n", $httpJS);
		if($ui){
			if($type == 'js')
				$jsfile .= "<script src='".$ui."' 'type'='text/javascript'></script>";
			else
				$jsfile .= "<link href='".$ui."' 'rel'='stylesheet'>";
		}
		return $jsfile;
		 
	}
	

}