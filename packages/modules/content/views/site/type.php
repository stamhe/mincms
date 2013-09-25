<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;  
?>
<?php  
	echo \application\core\widget\Form::widget(array(
	'model'=>$model,
	'form'=>false,
	'yaml' => "@application/modules/content/forms/content_type.yaml",
));?>
 

<div class="controls margin-top"  >
	<?php echo Html::submitButton(__('save'),  array('class' => 'btn btn-default')); ?>
</div>
<?php ActiveForm::end();?>