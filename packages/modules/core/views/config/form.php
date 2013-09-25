<?php
use yii\helpers\Html;
/**
 * @var yii\base\View $this
 */
$this->params['breadcrumbs'][] =  array('label'=>__('config'),'url'=>url('core/config/index')); 
$this->params['breadcrumbs'][] = $this->title;
?>

<?php echo \application\core\widget\Form::widget(array(
	'model'=>$model,
	'yaml' => "@application/modules/core/forms/config.yaml",
));
widget('redactor',array(
	'tag'=>'#config-body'
));
?>

