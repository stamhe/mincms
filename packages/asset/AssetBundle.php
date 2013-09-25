<?php
  
namespace application\asset; 
 
class AssetBundle extends \yii\web\AssetBundle
{
 	public function registerAssets($view)
	{
		foreach ($this->depends as $name) {
			$view->registerAssetBundle($name);
		} 
		$this->publish($view->getAssetManager());
 
		foreach ($this->js as $js) {
			if( strpos($js,'//')!==false || strpos($js,'http://')!==false || strpos($js,'https://')!==false)
				$view->registerJsFile( $js, $this->jsOptions);
			else
				$view->registerJsFile( http() . $js, $this->jsOptions);
		}
		foreach ($this->css as $css) {
			if( strpos($css,'//')!==false || strpos($css,'http://')!==false || strpos($css,'https://')!==false)
				$view->registerJsFile( $css, $this->jsOptions);
			else
				$view->registerCssFile(http() . $css, $this->cssOptions);
		}
	}
}