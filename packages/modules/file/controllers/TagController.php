<?php namespace application\modules\file\controllers; 
use application\core\DB;
/**
* for ajax request  application\widget\jpictag
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/
class TagController extends \application\core\FrontController
{ 
	function init(){
		parent::init(); 
	}
	public function actionIndex($url){
		if(!$url) exit();
		return $this->render('index',array(
			'url'=>$url
		));
	}
	 
	function actionGet(){
		$this->layout = false;
		if(!$_POST['url']) return;
		$url = md5($_POST['url']);  
		$out = cache('file_tag_'.$url); 
		if(!$out){
			$db = 'file_tag';
			$all = DB::all($db,array(
				'where'=>array(
					'url'=>$url
				) 
			)); 
			if($all){
				foreach($all as $one){
					$data = $one['tag'];
					$data = (array)json_decode($data);
					$data['id'] = $one['id'];
					$out[] = $data;
				}
				cache('file_tag_'.$url ,$out );
			}
		}
		if($out) { 
			return json_encode($out);
		}
		return false; 
	}
	function actionPost(){
		$this->layout = false;
		if(!\Yii::$app->user->identity->id){
			exit;
		}
		$tag['width'] = $_POST['width'];
		$tag['height'] = $_POST['height'];
	 
		$tag['top'] = $_POST['top'];
		$tag['left'] = $_POST['left'];
		
		$tag['top'] = str_replace('px','',strtolower($tag['top']));
	 	$tag['left'] = str_replace('px','',strtolower($tag['left']));
	 	
		$tag['label'] = $_POST['label'];   
		$url = $_POST['url']; 
		return $this->save(md5($url),$tag); 
	}
	function actionRemove(){
		$id = $_REQUEST['id'];
		if($id<1) exit;
		$one = DB::one('file_tag',array('where'=>array('id'=>$id))); 
		DB::delete('file_tag','id=:id',array(':id'=>$id));
		cache('file_tag_'.$one['url'] , false);
	 
	}
	function save($url,$tag){
		$this->layout = false; 
		$dbtag = json_encode($tag); 
		DB::insert('file_tag',array(
			'url'=>$url,
			'tag'=>$dbtag
		));
		$id = DB::id();  
		cache('file_tag_'.$url,false);
	 
	}

	 
}
