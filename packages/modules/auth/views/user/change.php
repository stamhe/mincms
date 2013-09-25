<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;  
use application\modules\member\Auth;
use application\core\DB;
?>
<div class="row">
  	<div class='col-lg-6'>
		<blockquote>
			<h3>
				<?php echo __('bind oauth');?>
			</h3> 
			<small> 
				<?php if(!module_exists('oauth')){?>
					<?php echo __('it is need enable oauth module');?>  
					<a href="<?php echo url('core/modules/install',array('id'=>'oauth','ret'=>url('auth/user/change')));?>"><?php echo __('enable oauth');?></a>
				<?php }else{?>
						<a href="<?php echo url('oauth/site/index');?>" target='_blank'><?php echo __('set oauth');?></a>
						
				<?php }?>
			</small> 
		</blockquote>
		<?php if(module_exists('oauth')){
			 
		?>
			<blockquote>
					<h3> <?php echo __('had binded oauth');?> </h3>  
			</blockquote> 
			<?php if($third){
				foreach($third as $row){
			?>
				<div class='btn btn-default'>
					<img title="<?php echo $row['name'];?>"  src="<?php echo $base;?>/<?php echo $row['slug'];?>.png" />
					<?php echo $row['username'];?>
					&nbsp;&nbsp;
					<a href="<?php echo url('auth/user/unbind',array('id'=>$row['id']));?>"
						 onclick="return confirm('<?php echo __('remove oauth login');?>');">
							<i class="glyphicon glyphicon-trash glyphicon-white"></i>
					</a>
				</div>
			<?php }}?>	
			<blockquote>
					<h3> <?php echo __('oauth login bind');?> </h3>  
			</blockquote> 
			<p>	
			<?php echo widget('@application/modules/oauth/widget/login',array('admin'=>encode(uid())));?>
			</p>
		<?php }?>
	 	
	</div>
	<div class='col-lg-6'>
		<blockquote>
			<h3>
				<?php echo __('change password');?>
			</h3>
			<div class='alert alert-info'>
				<?php echo __('if you just want to change profile not change password,keep new password and confirm password empty');?> 
			</div>
		</blockquote>
		<?php echo \application\core\widget\Form::widget(array(
			'model'=>$model,
			'yaml' => "@application/modules/auth/forms/".$name.".yaml",
		));?>
	</div>
	
</div>
 
<?php
js("
$('#user-username').attr('readonly',true);
");
?>