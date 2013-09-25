<blockquote>
	<h3>
		<?php echo __('packages modules');?>   
	</h3>
</blockquote>
<table class="table table-striped table-bordered table-condensed">
  <tr>
	<td><?php echo __('name'); ?></td> 
	<td><?php echo __('install'); ?></td> 
  </tr>
  <?php  
  foreach($data as $post){  
  ?>
  <tr>
	<td><blockquote><?php echo $post['name']; ?>  [<?php echo $post['info']['memo']; ?>]
	  <small><?php echo $post['path']; ?></small>
	  </blockquote></td>
  
	<td  class="<?php echo 'show_'.$post['name'];?>"> 
		<?php if($post['default']==true || in_array($post['name'],$_core_modules)){?>
			<span class='label label-info'><?php echo __('core module');?></span>
		<?php }else{?>
			<?php if($post['active'] == 1){?>  
				<span class="label label-success">
					<a class='ajax_add hander'  href="<?php echo url('core/modules/install',array(
					'id'=>$post['name']));?>" rel=1 id="<?php echo $post['name'];?>"><i class="glyphicon glyphicon-trash glyphicon-white"></i></a> </span>
			<?php }else{?>
			<a class='ajax_add hander' id="<?php echo $post['name'];?>" href="<?php echo url('core/modules/install',array('id'=>$post['name']));?>"><i class="glyphicon glyphicon-plus"></i></a>
			<?php }?>
		<?php }?>
	</td>
   
  </tr>
   
  
  <?php } ?>
</table> 


<div class='ajax_ok top_fixed hide'>
	<img src="<?php echo base_url().'img/ajax-loader.gif';?>" />
</div>
<div class="ajax_error alert alert-error top_fixed animate hide">
	<?php echo __('error happlicationend');?>
</div>
 
