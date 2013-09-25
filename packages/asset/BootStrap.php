<?php
  
namespace application\asset;

 
 
class BootStrap extends \application\core\AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = array( 
		'//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css', 
		'//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css'
	);
	public $js = array(
		'//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js',
		'js/jquery.form.js',
		'//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js',
	);
	 
}