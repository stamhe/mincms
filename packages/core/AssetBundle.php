<?php
  
namespace application\core;  
class AssetBundle extends \yii\web\AssetBundle
{
 	function url($url){
 		if(strpos($url,'//')!==false || strpos($url,'http://')!==false || strpos($url,'https://')!==false ) 
 			return $url;
 		else
 			return http().$url;
 	}
	public function registerAssets($view)
	{
		foreach ($this->depends as $name) {
			$view->registerAssetBundle($name);
		}

		$this->publish($view->getAssetManager());
 
		foreach ($this->js as $js) {
			$view->registerJsFile( $this->url( $js ), $this->jsOptions);
		} 
		foreach ($this->css as $css) {
			$view->registerCssFile( $this->url( $css ), $this->cssOptions);
		}
	}

	 
}
