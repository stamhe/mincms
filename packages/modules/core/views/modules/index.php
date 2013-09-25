<blockquote>
	<h3>
		<?php echo __('app modules');?>   
	</h3>
</blockquote>
<?php if($app){?>
<table class="table table-striped table-bordered table-condensed">
  <tr>
	<td><?php echo __('name'); ?></td> 
	<td><?php echo __('install'); ?></td> 
  </tr>
  <?php  
  foreach($app as $post){  
  ?>
  <tr>
	<td><blockquote><?php echo $post['name']; ?>  [<?php echo $post['info']['memo']; ?>]
	  <small><?php echo $post['path']; ?></small>
	  </blockquote></td>
  
	<td  class="<?php echo 'show_'.$post['name'];?>"> 
	 
		<?php if($post['active'] == 1){?>  
			<span class="label label-success">
				<a class='ajax_add hander'  href="<?php echo url('core/modules/install',array(
				'id'=>$post['name']));?>" rel=1 id="<?php echo $post['name'];?>"><i class="glyphicon glyphicon-trash glyphicon-white"></i></a> </span>
		<?php }else{?>
		<a class='ajax_add hander' id="<?php echo $post['name'];?>" href="<?php echo url('core/modules/install',array('id'=>$post['name']));?>"><i class="glyphicon glyphicon-plus"></i></a>
		<?php }?>
	 
	</td>
   
  </tr>
   
  
  <?php } ?>
</table> 
<?php }else{?>
<div class='alert alert-info'><?php echo __('no @app modules');?></div> 
<?php }?>
<?php echo $this->render('package',array(
	'data'=>$data,'models'=>$models,'_core_modules'=>$_core_modules	
));?>
