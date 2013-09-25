<?php namespace application\widget\jtag;  
use yii\helpers\Json;
use yii\web\JsExpression;
/**
* jpictag
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @link  https://github.com/djpate/jTag
* @version 2.0.1
*/
class Widget extends \yii\base\Widget
{  
 	public $tag;
 	public $options;  
 	public $debug = false;
 	/**
	* how to use 
	* <code>	
	*	<img src="<?php echo $url;?>" id="image1"  > 
	*	<?php widget('jtag',array(
	*	'tag'=>'#image1',
	*	 
	*	));
	*	?>
	* </code>
	*/
	function run(){   
		$base = publish(__DIR__.'/assets');   
		$this->options['minWidth'] = 10; 
		$this->options['minHeight'] = 10;
		$this->options['defaultWidth'] = 100; 
		$this->options['defaultHeight'] = 100;
		$flag = false; 
		if( uid() > 0)
			$flag = true; 
		$this->options['canTag'] = $flag;
		$this->options['canDelete'] = $$flag;
		if( uid() > 0){
			$this->options['save'] = new JsExpression("function(url,width,height,top_pos,left,label,the_tag){  
				$.post('".url('file/tag/post')."',{'url':url,'width':width,'height':height,'top':top_pos,'left':left,'label':label},function(id){
					the_tag.setId(id);
				});
			}"); 
			$this->options['remove'] = new JsExpression("function(id){
				$.post('".url('file/tag/remove')."',{'id':id});
			}");  
		}
		$this->options['canDelete'] = false;
		if( uid() > 0)
			$this->options['canDelete'] = true;
	 
			
	 		
		$opts = Json::encode($this->options); 
		if( uid() > 0 )
			css_file($base.'/css/jquery.tag.min.admin.css');  
		else
 			css_file($base.'/css/jquery.tag.min.css'); 
 		css_file($base.'/css/jquery-ui.custom.css');  
 		
 		js(' 
 			
 			$("'.$this->tag.'").tag('.$opts.');  
			$.post("'.url('file/tag/get').'",{"url":$("'.$this->tag.'").attr("src")},function(data){
			 	var tags = $.parseJSON(data);  
			 	if(tags){
				 	$.each(tags, function(key,tag){
						$("'.$this->tag.'").addTag(tag.width,tag.height,tag.top,tag.left,tag.label,tag.id); 
					}); 
				}
			}); 
 		
 		'); 
 		
 		
 		if(true === $this->debug)
 			js_file($base.'/source/jquery.tag.js');  
 		else
 			js_file($base.'/js/jquery.tag.min.js');  
 		
	}
}