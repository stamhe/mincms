<?php
/**
* some modules use function
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/
function image_url($file,$option=null){
	$url =  module_class('imagecache.Classes.image',$file,$option);
	return $url;
}
function image_origin($file){
	$url =  module_class('imagecache.Classes.get_origin',$file);
	return $url;
}

function image($file,$option=null,$params=null){
	$url =  module_class('imagecache.Classes.image',$file,$option);
	return \yii\helpers\Html::img($url,$params);
}

function node($name,$id){
	if(is_array($id)){
		$id['where']['display'] = 1;
		$all = \application\modules\content\Classes::all($name,$id); 
		return $all[0]; 
	}
	return \application\modules\content\Classes::one_full($name,$id); 
}
/**
* node_pager 
*
* Example
*
* <code>
*	$data = node_pager('post',array(
*		'where'=>array(
*			'type'=>$id
*		), 
*	),10); 
*	return $this->render('list',$data);		
*	foreach($models as $model){
*	}
*	echo \application\core\LinkPager::widget(array(
*	      'pagination' => $pages,
*	)); 
* </code>
*/
function node_pager($slug,$params=array(),$config=null,$route=null){
	$params['where']['display'] = 1;
	if(!$params['orderBy'])
		$params['orderBy'] = 'sort desc,id desc';
	return \application\modules\content\Classes::pager($slug,$params,$config,$route); 
}
function node_all($slug,$params=array()){
	$params['where']['display'] = 1;
	if(!$params['orderBy'])
		$params['orderBy'] = 'sort desc,id desc';
	return \application\modules\content\Classes::all($slug,$params); 
}
/**
*
*	$node = node_save('post',array(
*	 	'title'=>1,
*	 	 'body'=>$str
*	 ));
*	 if $array['id'] will update
*/
function node_save($name,$array=array(),$nid=null){ 
	return \application\modules\content\classes\Node::save($name,$array,$nid); 
}

/**
* plugin url
*/
function plugin_url($name){
	return url('content/plugin/index',array('class'=>base64_encode($name)));
}