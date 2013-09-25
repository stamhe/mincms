<?php echo widget('plupload',array('info'=>'上传图片','ext'=>'jpg,png,gif,bmp'));?>  
<a href="<?php echo plugin_url($url);?>" class="fancybox fancybox.ajax" rel="group" >
<?php echo __('insert image');?>
</a>
 <?php
widget('fancyBox',array(
	'tag'=>'.fancybox',
	 
));

?>

