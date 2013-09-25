<?php namespace application\widget\jqte;  
use yii\helpers\Json;
/**
* 
* @author Sun < mincms@outlook.com >
*/
class Widget extends \yii\base\Widget
{  
 	public $tag;
 	public $options; 
 	public $css; 
 	public $lang = 'us'; // zh
	function run(){   
		$base = publish(__DIR__.'/assets');  
 		$tag = $this->tag; 
 		$zh = $this->lang;  
		if($zh == 'zh'){
		 	$params['titletext'][]['title'] = '字体大小';
		 	$params['titletext'][]['title'] = '颜色';
		 	$params['titletext'][]['title'] = '加粗';
		 	$params['titletext'][]['title'] = '斜体';
		 	$params['titletext'][]['title'] = '下划线';
		 	$params['titletext'][]['title'] = '列表';
		 	$params['titletext'][]['title'] = '无序列表';
		 	$params['titletext'][]['title'] = '下标';
		 	$params['titletext'][]['title'] = '上标';
		 	$params['titletext'][]['title'] = '左缩进';
		 	$params['titletext'][]['title'] = '右缩进';
		 	$params['titletext'][]['title'] = '左对齐';
		 	$params['titletext'][]['title'] = '居中';
		 	$params['titletext'][]['title'] = '右对齐';
		 	$params['titletext'][]['title'] = '删除线';
		 	$params['titletext'][]['title'] = '添加链接';
		 	$params['titletext'][]['title'] = '移除链接';
		 	$params['titletext'][]['title'] = '清除样式';
		 	$params['titletext'][]['title'] = '水平线';
		 	$params['titletext'][]['title'] = '源码'; 
	 		$params['button'] = '确认';
	 		js_file($base.'/jquery-te-1.3.3.js');
 		}else{
 			js_file($base.'/jquery-te-1.3.3.min.js');
 		}
		if($params)
			$opts = Json::encode($params);
		 
 		css_file($base.'/jquery-te-1.3.3.css'); 
 		
 		if($this->css)
 			css_file($base.'/'.$this->css.'.css');  
 		js(' 
 			$("'.$tag.'").jqte('.$opts.'); 
 		'); 
	}
}