<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;  
?>
 
<div class='row'>
 
	<div class='col-lg-6'>
		<blockquote>
			<h3><?php echo __('mail template');?></h3>
		</blockquote>
		<?php $form = ActiveForm::begin(array(
				'options' => array('class' => 'form-horizontal'),
				'fieldConfig' => array('inputOptions' => array('class' => 'input-xlarge')),
			)); ?>
			 	<?php echo $form->field($model, 'slug')->textInput(); ?> 
				<?php echo $form->field($model, 'title')->textInput(); ?> 
				<?php echo $form->field($model, 'body')->textArea(); ?> 
				<?php echo $form->field($model, 'memo')->textInput(); ?> 
				<div class="controls margin-top">
					<?php echo Html::submitButton(__('save'),  array('class' => 'btn btn-default ')); ?>
				</div>
			<?php ActiveForm::end(); ?>	
	</div>
</div>
<?php
widget('redactor',array(
		'tag'=>'#template-body'
	));	
?>