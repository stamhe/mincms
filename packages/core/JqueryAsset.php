<?php
 
namespace application\core;  
 
class JqueryAsset extends \application\core\AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = array(
	 
	);
	public $js = array( 
		'//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js',
	);
	public $depends = array(
		'yii\web\YiiAsset', 
	);
}