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
		<?php  if(!$model) {echo $this->title;} else{ echo $model->slug;} ?> 
	</h3>
</blockquote>
<?php $form = ActiveForm::begin(array(
	'options' => array('class' => 'form-horizontal','id'=>'oauth-sort'),
	'fieldConfig' => array('inputOptions' => array('class' => 'input-xlarge')),
)); ?>
<input type='hidden' name='pid' value="<?php echo (int)$_GET['pid'];?>">
<?php echo application\core\widget\Table::widget(array(
	'models'=>$models,
	'pages'=>$pages,
	'create_url'=>url('content/site/create',array('pid'=>$_GET['pid'])),
	'fields'=>array('ids','slug','name','link')	
)); 

\application\core\UI::sort('#oauth-sort',url('content/site/sort'))
?> 

<?php ActiveForm::end(); ?>
<?php echo core_widget('Modal');?>