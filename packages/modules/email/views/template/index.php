<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;  
?>
 
<div class='row'>
 
	<div class='col-lg-12'>
		<blockquote>
			<h3><?php echo __('mail template');?></h3>
		</blockquote>
		<?php echo application\core\widget\Table::widget(array(
			'models'=>$models,
			'pages'=>$pages,
			'modal'=>true,
			'title'=>__('remove template'),
		//	'content'=>'do you want to do this',
			'fields'=>array('slug','memo','title')	,
		));?>
	</div>
</div>