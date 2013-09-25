<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;  
 
/**
 * @var yii\base\View $this
 */
$this->params['breadcrumbs'][] =  array('label'=>__('route'),'url'=>url('route/site/index')); 
$this->params['breadcrumbs'][] = $this->title;
?>
 
<?php echo \application\core\widget\Form::widget(array(
	'model'=>$model,
	'form'=>false,
	'yaml' => "@application/modules/route/forms/route.yaml",
));?>
 
<div class="controls margin-top"  >
	<?php echo Html::submitButton(__('save'),  array('class' => 'btn btn-default ')); ?>
</div>
<?php ActiveForm::end();?>

