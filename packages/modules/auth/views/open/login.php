<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha; 
?>
 
<div class="row">
  	<div class='col-lg-4'>
<?php $form = ActiveForm::begin(array('options' => array('class' => 'form-horizontal'),'enableClientValidation'=>false,'validateOnSubmit'=>false,'validateOnChange'=>false)); ?>
	<?php echo $form->field($model, 'username')->textInput(); ?>
	<?php echo $form->field($model, 'password')->passwordInput(); ?>
	<?php echo $form->field($model, 'verifyCode')->widget(Captcha::className(), array(
		'options' => array('class' => 'input-medium'),
		'captchaAction'=>'/auth/open/captcha',
		'template'=>"{input} \n {image} ",

	)); ?>
	<div class="controls margin-top">
		<?php echo Html::submitButton(__('login'),  array('class' => 'label label-default')); ?>
	
	<?php if(module_exists('email')){?>	
		<a href="<?php echo url('auth/open/forgot');?>" class='label label-info' style='margin-left:20px;'><?php echo __('forget password');?>?</a>
	<?php }?></div>
<?php ActiveForm::end(); ?>
</div>
<div class='col-lg-6' style='padding-left:20px;'> 
<?php if(module_exists('oauth')){?>
	<blockquote>
			<h3> <?php echo __('login oauth');?> </h3>  
	</blockquote> 
	<?php echo widget('@application/modules/oauth/widget/login',array('admin_login'=>1));?>
	
<?php }?>
</div>
<?php
js("$('#loginform-verifycode-image').click(function(){

return false;
});");		
?>
