<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;  
?>
 
<?php 
if(!$form){	
	$form = ActiveForm::begin(array(
		'options' => array('class' => 'form-horizontal'),
		'fieldConfig' => array('inputOptions' => array('class' => 'input-xlarge')),
	)); 
}
?>
	<?php foreach($fields as $k=>$v){ 
	?>
		<?php $out = $form->field($model, $k);  
			  if($v['value'])
			  	echo $out->$v['html']($v['value']);  
			  else
			  	echo $out->$v['html']();  
		?> 
	<?php }?>
	<?php if(true === $show_form){?>
		<div class="controls margin-top">
			<?php echo Html::submitButton(__('save'), array('class' => 'btn btn-default')); ?>
		</div>
	<?php }?>
<?php if(true === $show_form) ActiveForm::end(); ?>
