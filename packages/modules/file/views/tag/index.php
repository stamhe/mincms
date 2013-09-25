<?php 
use yii\helpers\Html;

?>
<span class='label'><?php echo __('tag image');?></span> 

<img src="<?php echo $url;?>" id="image1"  > 
<?php widget('jtag',array(
'tag'=>'#image1', 
));
?>