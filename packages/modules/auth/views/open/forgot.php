<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha; 
?>
 
<div class="row">
  	<div class='col-lg-4'>
<?php $form = ActiveForm::begin(array('options' => array('class' => 'form-horizontal'))); ?>
	
 	<?php echo $form->field($model, 'email')->textInput(); ?>
 	
	<div class="controls margin-top">
		<?php echo Html::submitButton(__('get password'),  array('class' => 'btn btn-default')); ?>
	</div>
	 
<?php ActiveForm::end(); ?>
</div>
 
