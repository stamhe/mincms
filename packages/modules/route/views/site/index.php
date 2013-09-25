<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm; 
/**
 * @var yii\base\View $this
 */
 
$this->title = __('content type');
$this->params['breadcrumbs'][] =  array('label'=>__('content type'),'url'=>url('content/site/index'));  
$this->params['breadcrumbs'][] = __('list'); 
?>
<blockquote>
	<h3>
		<?php echo $this->title; ?> 
	</h3>
</blockquote>
<?php $form = ActiveForm::begin(array(
	'options' => array('class' => 'form-horizontal','id'=>'sort'),
	'fieldConfig' => array('inputOptions' => array('class' => 'input-xlarge')),
)); ?>
<?php echo application\core\widget\Table::widget(array(
	'models'=>$models,
	'pages'=>$pages,
	'fields'=>array('ids','route','route_to')	
)); 
\application\core\UI::sort('#sort',url('route/site/sort'))
?> 

<?php ActiveForm::end(); ?>
<?php echo core_widget('Modal');?>
