<div id='ajax_body' >
	<div id='up' style='display:none;' class='label label-success'><?php echo __('add success');?></div>
	<div  id='masonry'>
		<ul>
			<?php 
			if($models){
				foreach($models as $model){
			?>
				<li class='item'>
					<?php echo image($model['path'],array(
						'resize'=>array(130,78 , true ,true)
					),array('rel'=>image_url($model['path'] ,array(
						'resize'=>array(600)
					) ) , 'class'=>'hander'));?>
				</li>
			<?php }}?> 
		<ul>
	</div>
	<div class='ajax_pagination'>
		<?php echo \application\core\LinkPager::widget(array(
			'pagination' => $pages,
		));
		?>
	</div>
</div>
<?php
 
css("
	#ajax_body{
		padding:20px;
	}
	.ajax_pagination{
		clear:both;
		margin-top:20px;
	}
	ul{margin:0;}
    #masonry li{
        list-style:none;
        float:left;
        margin:0 10px 10px 0;
        
    }
");
$tag = 'CK'.$field;
js(" 
	$('#ajax_body img').click(function(){  
		var rel = $(this).attr('rel'); 
		".$tag.".insertHtml('<img src='+rel+' />');
		$('#ajax_body #up').fadeIn().fadeOut(2000);
	}); 
 
");
\application\core\Pagination::ajax('.ajax_pagination a' , '#ajax_body');
?>