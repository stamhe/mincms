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
		 	$params['titletext'][]['title'] = '�����С';
		 	$params['titletext'][]['title'] = '��ɫ';
		 	$params['titletext'][]['title'] = '�Ӵ�';
		 	$params['titletext'][]['title'] = 'б��';
		 	$params['titletext'][]['title'] = '�»���';
		 	$params['titletext'][]['title'] = '�б�';
		 	$params['titletext'][]['title'] = '�����б�';
		 	$params['titletext'][]['title'] = '�±�';
		 	$params['titletext'][]['title'] = '�ϱ�';
		 	$params['titletext'][]['title'] = '������';
		 	$params['titletext'][]['title'] = '������';
		 	$params['titletext'][]['title'] = '�����';
		 	$params['titletext'][]['title'] = '����';
		 	$params['titletext'][]['title'] = '�Ҷ���';
		 	$params['titletext'][]['title'] = 'ɾ����';
		 	$params['titletext'][]['title'] = '�������';
		 	$params['titletext'][]['title'] = '�Ƴ�����';
		 	$params['titletext'][]['title'] = '�����ʽ';
		 	$params['titletext'][]['title'] = 'ˮƽ��';
		 	$params['titletext'][]['title'] = 'Դ��'; 
	 		$params['button'] = 'ȷ��';
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