<?php namespace application\widget\switchlanguage;  
use yii\helpers\Json;
/**
* 
* @author Sun < mincms@outlook.com >
*/
class Widget extends \yii\base\Widget
{ 
 
 	public $tag='#polyglotLanguageSwitcher';
 	public $options;
 
	function run(){ 
		$this->options['effect'] = 'fade';
		$this->options['onChange'] = "js:function(evt){
			alert('The selected language is: '+evt.selectedItem);
		}";
		$this->options['paramName'] = "language";
		$this->options['openMode'] = 'hover';  
	 
		$opts = Json::encode($this->options);
		$base = publish(__DIR__.'/assets'); 
		css_file($base.'/css/polyglot-language-switcher.css'); 
		js_file($base.'/js/jquery.polyglot.language.switcher.js'); 
		echo $this->render('@application/widget/switchlanguage/views/form',array('base'=>$base));
	    js(" 
    		$('".$this->tag."').polyglotLanguageSwitcher($opts); 
	    
	    ");
	     
    
	}
}