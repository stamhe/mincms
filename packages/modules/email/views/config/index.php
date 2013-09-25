<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;  
?>



<div class='row'>
	<div class='col-lg-6'>
		<blockquote>
			<h3><?php echo __('mail settings');?></h3>
		</blockquote>
		<?php $form = ActiveForm::begin(array(
			'options' => array('class' => 'form-horizontal'),
			'fieldConfig' => array('inputOptions' => array('class' => 'input-xlarge')),
		)); ?>
		 	<?php echo $form->field($model, 'type')->dropDownList(array(1=>'smtp',2=>'send mail',3=>'mail'),array('style'=>'width:130px;')); ?>
			<?php echo $form->field($model, 'from_email')->textInput(); ?>
			<?php echo $form->field($model, 'from_name')->textInput(); ?>
			<?php echo $form->field($model, 'from_password')->passwordInput(); ?> 
			<?php echo $form->field($model, 'smtp')->textInput(); ?>
			<?php echo $form->field($model, 'port')->textInput(); ?>
			
		 
			<div class="controls margin-top">
				<?php echo Html::submitButton(__('save'),  array('class' => 'btn btn-default')); ?>
			</div>
		<?php ActiveForm::end(); ?>
	</div>
	<div class='col-lg-6'>
		<blockquote>
			<h3><?php echo __('test');?></h3>
		</blockquote>
		<?php $form = ActiveForm::begin(array(
				'options' => array('class' => 'form-horizontal'),
				'fieldConfig' => array('inputOptions' => array('class' => 'input-xlarge')),
			)); ?>
			 	<?php echo $form->field($send, 'to_email')->textInput(); ?>
				<?php echo $form->field($send, 'to_name')->textInput(); ?>
				<?php echo $form->field($send, 'title')->textInput(); ?> 
				<?php echo $form->field($send, 'body')->textArea(); ?>
				<?php echo $form->field($send, 'attach')->textInput(); ?>
				
			 
				<div class="controls margin-top">
					<?php echo Html::submitButton(__('send mail'),  array('class' => 'btn btn-default')); ?>
				</div>
			<?php ActiveForm::end(); 
					
			widget('redactor',array(
				'tag'=>'#send-body'
			));		
			?>	
	</div>
</div>