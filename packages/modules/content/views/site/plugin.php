<?php
use yii\helpers\Html;

?>

<div class='control-group'>
	<label class="control-label"><?php echo __('plugin');?></label>
	<div class="controls"> 
		<?php echo Html::dropDownList('plugin',$plugin_value ,$plugin , array('style'=>'width:150px;'));?>
	</div>
</div>
<div class='control-group'>
	<label class="control-label"><?php echo __('plugin config');?></label>
	<div class="controls"> 
		<?php echo Html::textArea('plugin_config' , $plugin_config);?>
	</div>
</div>