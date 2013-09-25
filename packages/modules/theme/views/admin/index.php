<?php
use yii\helpers\Html;	
?>
<blockquote>
	<h3>
		<?php echo __('themes');?>	 
		<small><?php echo __('here can set front theme and backend theme');?></small>
	</h3>
</blockquote>
<div id='theme'>
<blockquote>
	<span class='label label-info'><?php echo __('admin theme');?>	 </span>
</blockquote>
<?php $i=0; if($admin){foreach($admin as $k=>$v){?> 
	<div class="col-lg-3 <?php if($i==0){?> margin0 <?php }?> img-polaroid"  style='margin-right:30px;' >
	<img src="<?php echo image_url('themes/'.$k.'/'.$v['file'],array('resize'=>array(300,200,true,true)));?>" class="img-rounded" >
	<p class='label text-left'> 
			<?php echo $k;?>  <br>
			<?php echo __('author');?>: <?php echo $v['auth'];?><br>
			<?php echo __('licensed');?>: <?php echo $v['licensed'];?>
	 
	</p>
 
	<?php if($actived == $k){?>
			<span class="btn btn-danger clear">
				<?php echo __('selected');?>
			</span> 
	<?php }else{?>
		<span class="btn btn-primary clear" >
			<?php echo Html::a(__('active'),url('theme/admin/selected',array('name'=>$k)));?>
		</span>
	<?php }?>
	</div>	 
<?php $i++;}}?>
 
<blockquote class='clear '>
	<span class='label label-info'><?php echo __('front theme');?>	  </span>
</blockquote>
<?php $i=0; if($front){foreach($front as $k=>$v){?> 
	<div class="col-lg-3 <?php if($i==0){?> margin0 <?php }?> img-polaroid" style='margin-right:30px;'>
	<img src="<?php echo image_url('themes/'.$k.'/'.$v['file'],array('resize'=>array(300,200,true,true)));?>" class="img-rounded">
	<p class='label text-left'> 
			<?php echo $k;?> <br>
			<?php echo __('author');?>: <?php echo $v['auth'];?><br>
			<?php echo __('licensed');?>: <?php echo $v['licensed'];?> 
	</p>
 	
	<?php if($actived_front == $k){?>
			<span class="btn btn-danger">
				<?php echo __('selected');?>
			</span> 
	<?php }else{?>
		<span class="btn btn-primary">
			<?php echo Html::a(__('active'),url('theme/admin/selectedfront',array('name'=>$k)));?>
		</span>
	<?php }?>
	</div>	 
<?php $i++;}}?>
</div>
<div class='clear'></div>
