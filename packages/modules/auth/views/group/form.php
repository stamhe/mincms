<?php
use yii\helpers\Html;
/**
 * @var yii\base\View $this
 */ 
$this->params['breadcrumbs'][] =  array('label'=>__('user group'),'url'=>url('auth/group/index'));  
$this->params['breadcrumbs'][] = $this->title;
?>

<?php echo \application\core\widget\Form::widget(array(
	'model'=>$model,
	'yaml' => "@application/modules/auth/forms/".$name.".yaml",
));?>

