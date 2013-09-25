<?php
use yii\helpers\Html;
/**
 * @var yii\base\View $this
 */
$this->title = __('bind group');
$this->params['breadcrumbs'][] =  array('label'=>__('user group'),'url'=>url('auth/group/index'));  
$this->params['breadcrumbs'][] = __('save user group'); 
?>
<blockquote>
	<h3>
		<?php echo $model->email;?>  
		<small><?php echo Html::encode($this->title); ?></small>
	</h3>
</blockquote>
<?php $form = application\core\ActiveForm::begin(array(
	'options' => array('class' => 'form-horizontal'),
	'fieldConfig' => array('inputOptions' => array('class' => 'input-xlarge')),
)); ?>
<p>
<input type='hidden' name='hidden' value=1>
<label class="label <?php if($self==1){?> label-info <?php }?>">
	<input type='checkbox' name='self' value=1 
		<?php if($self==1){?>
			checked='checked' 
		<?php }?>
		>
	<?php echo __('myself');?>
</label>
</p>
<?php echo Html::dropDownList('group[]',$groups,$rows,array('multiple'=>'multiple','style'=>'width:300px;'));?>
 
	<div class="controls margin-top">
		<?php echo Html::submitButton(__('save user group'), array('class' => 'btn')); ?>
	</div>
<?php application\core\ActiveForm::end(); ?>