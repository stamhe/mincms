<?php
use yii\helpers\Html;
/**
 * @var yii\base\View $this
 */
$this->params['breadcrumbs'][] =  array('label'=>__('host'),'url'=>url('host/site/index')); 
$this->params['breadcrumbs'][] = $this->title;
?>

<?php echo \application\core\widget\Form::widget(array(
	'model'=>$model,
	'yaml' => "@application/modules/host/forms/host.yaml",
));?>

