<?php namespace application\widget\gallery;  
use yii\helpers\Json;
/**
* gallery widget
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @link http://galleria.io/   offical website
* @link http://mincms.com/demo-gallery.html   demo
* @version 2.0.1
*/
class Widget extends \yii\base\Widget
{  
 	public $tag;
 	public $options;  
 	/**
 	* classic , azur ,dots,fullscreen,twelve
 	*/
 	public $theme = 'classic';
 	/**
 	* Example
 	*
 	* <code> 
	*	<?php widget('gallery',array(
	*		'tag'=>'#galleria',
	*		'theme'=>'classic',// classic , azur ,dots,fullscreen,twelve
	*	));
	*	?>
	*
	*	<div id="galleria" style="width:800px;height:600px;">
	*		<?php foreach($post->img as $im){ ?>
	*	    <a href="<?php echo image_url($im['path'] , array('resize'=>array(800)));?>"><img 
	*	    	src="<?php echo image_url($im['path'] , array('resize'=>array(120,90)));?>"   
	*	    	 data-title="<?php echo $post->name;?>" data-description="<?php echo $post->name;?>"></a>
	*	    <?php }?>
	*	</div>
	* </code>
 	*/
	function run(){  
		$this->options['autoplay'] = $this->options['autoplay']?:3000;
		$opts = Json::encode($this->options);
		$base = publish(__DIR__.'/assets');  
 		if(!$this->tag) return; 
 		js(" 
 			Galleria.loadTheme('".$base."/themes/".$this->theme."/galleria.".$this->theme.".js');
			Galleria.configure(".$opts.");
			Galleria.run('".$this->tag."');
 		");  
 		js_file($base."/galleria-1.2.8.min.js");
 		css_file($base."/themes/".$this->theme."/galleria.".$this->theme.".css");
	}
}