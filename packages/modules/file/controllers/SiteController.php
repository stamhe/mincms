<?php namespace application\modules\file\controllers;
use application\core\File;
/**
*  
* 
* @author Sun < mincms@outlook.com >
*/ 
class SiteController extends \application\core\AuthController
{ 
	  

	public function actionIndex()
	{
		//$file = root_path().'upload/1.jpg';
 	 	//$d = exif_read_data  ($file);  
	 	return $this->render('index');
	}
	/**
	* 管理员上传
	*/
	function actionUpload(){
		$name = $_REQUEST['field']; 
 		if(!$name) exit;
 		$file = new File;
 		$file->uid = uid();
 		$file->admin = 1;
 		
		$rt = $file->upload();  
		
		if(!$rt) return; 
		$new[] = $rt;  
		$out = File::input($new,$name);
		echo $out;
		exit(); 
	}

	 
}
