<?php error_reporting(0);
use yii\helpers\Html;
use yii\widgets\ActiveForm;  
$this->title = __('image cache');
$this->params['breadcrumbs'][] =  array('label'=>__('image cache'),'url'=>url('imagecache/admin/index'));  
$this->params['breadcrumbs'][] = __('create'); 
	
$form = ActiveForm::begin(array(
	'options' => array('class' => 'form-horizontal'),
	'fieldConfig' => array('inputOptions' => array('class' => 'input-xlarge')),
)); ?> 
<?php echo  $form->field($model, 'slug')->textInput();  ?>
<div class="control-group">
	<label class="control-label" for="image-slug"><?php echo __('type');?></label>
	<div class="controls">
		<?php echo Html::dropDownList("Image[type][]",$model->type ,$image,array('multiple'=>'multiple','id'=>'type','style'=>'width:300px;'));?> 
	</div>
</div>
<div id='resize' class='well control-group imagecache_form'>
	<p><?php echo __('resize');?></p>
	<p><?php echo __('width');?>:<input name="memo[resize][]" value="<?php echo $model->memo['resize'][0];?>" class='input-xlarge'></p>
	<p><?php echo __('height');?>:<input name="memo[resize][]" value="<?php echo $model->memo['resize'][1];?>" class='input-xlarge'></p>
	<p><?php echo __('keepar');?>:<br><?php echo Html::dropDownList("memo[resize][]",$model->memo['resize'][2],array(
			''=>__('please select'),1=>__('yes'),0=>__('no')
		));?></p>
	<p><?php echo __('pad');?>: <br><?php echo Html::dropDownList("memo[resize][]",$model->memo['resize'][3],array(
			''=>__('please select'),1=>__('yes'),0=>__('no')
		));?></p>
</div>
	
<div id='crop'  class='  well control-group imagecache_form'>
	<p><?php echo __('crop');?></p>
	<p><?php echo __('x1');?>:<input name="memo[crop][]" value="<?php echo $model->memo['crop'][0];?>" class='input-xlarge'></p>
	<p><?php echo __('y1');?>:<input name="memo[crop][]" value="<?php echo $model->memo['crop'][1];?>" class='input-xlarge'></p>
	<p><?php echo __('x2');?>:<input name="memo[crop][]" value="<?php echo $model->memo['crop'][2];?>" class='input-xlarge' ></p>
	<p><?php echo __('y2');?>:<input name="memo[crop][]" value="<?php echo $model->memo['crop'][3];?>" class='input-xlarge'></p>
</div>

<div id='crop_resize'  class='  well control-group imagecache_form'>
	<p><?php echo __('crop_resize');?></p>
	<p><?php echo __('width');?>:<input name="memo[crop_resize][]" value="<?php echo $model->memo['crop_resize'][0];?>" class='input-xlarge'></p>
	<p><?php echo __('height');?>:<input name="memo[crop_resize][]" value="<?php echo $model->memo['crop_resize'][1];?>" class='input-xlarge'></p> 
</div> 

<div id='flip'  class='  well control-group imagecache_form'>
	<p><?php echo __('flip');?></p>
	<p><?php echo __('direction');?>:
		<?php echo Html::dropDownList("memo[flip]",$model->memo['flip'] ,array(
			''=>__('please select'),'vertical'=>'vertical','horizontal'=>'horizontal','both'=>'both',
		));?>
	</p>
 
</div>
<div id='rotate'  class='  well control-group imagecache_form'>
	<p><?php echo __('rotate');?></p>
	<p><?php echo __('degrees');?>:<input name="memo[rotate]"  value="<?php echo $model->memo['rotate'];?>"  class='input-xlarge'></p> 
</div>
	
<div id='watermark'  class='  well control-group imagecache_form'>
	<p><?php echo __('watermark');?></p>
	<p><?php echo __('filename');?>: 
	
	<input name="memo[watermark][]"  value="<?php echo $model->memo['watermark'][0];?>"  class='input-xlarge'></p> 
	<p><?php echo __('position');?>:
		<p>
		  <input type="radio" class='watermark' name="memo[watermark][ps]"  value="top left" />
		  <input type="radio" class='watermark' name="memo[watermark][ps]"  value="top middle" />
		  <input type="radio" class='watermark' name="memo[watermark][ps]"   value="top right" />
		</p>
		<p>
		  <input type="radio" class='watermark' name="memo[watermark][ps]"  value="center left" />
		  <input type="radio" class='watermark' name="memo[watermark][ps]"  value="center middle" />
		  <input type="radio" class='watermark' name="memo[watermark][ps]"  value="center right" />
		</p>
		<p>
		  <input type="radio" class='watermark' name="memo[watermark][ps]"   value="bottom left" />
		  <input type="radio" class='watermark' name="memo[watermark][ps]"   value="bottom middle" />
		  <input type="radio" class='watermark' name="memo[watermark][ps]"  value="bottom right" />
		</p>	
		
	</p> 
	<p><?php echo __('padding');?>:<input name="memo[watermark][]"  value="<?php echo $model->memo['watermark'][1];?>"  class='input-xlarge'></p> 
	
</div>
<div id='border'  class='  well control-group imagecache_form'>
	<p><?php echo __('border');?></p>
	<p><?php echo __('size');?>:<input name="memo[border][]" value="<?php echo $model->memo['border'][0];?>"  class='input-xlarge'></p> 
	<p>
		<?php echo __('color');?>:
		<input name="memo[border][]" id='border_color' value="<?php echo $model->memo['border'][1];?>"  class='input-xlarge'>
		<div id='farbtastic'></div>
	</p>  
</div>
<div id='mask'  class='  well control-group imagecache_form'>
	<p><?php echo __('mask');?></p>
	<p><?php echo __('maskimage');?>:<input name="memo[mask]" value="<?php echo $model->memo['mask'];?>"  class='input-xlarge'></p>  
</div>
<div id='rounded'  class='  well control-group imagecache_form'>
	<p><?php echo __('rounded');?></p>
	<p><?php echo __('radius');?>:<input name="memo[rounded][]" value="<?php echo $model->memo['rounded'][0];?>"  class='input-xlarge'></p>  
	<p><?php echo __('sides');?>:<input name="memo[rounded][]" value="<?php echo $model->memo['rounded'][1];?>"  class='input-xlarge'></p>  
	<p><?php echo __('antialias');?>:<input name="memo[rounded][]" value="<?php echo $model->memo['rounded'][2];?>"  class='input-xlarge'></p>  
	
</div>
<div id='grayscale'  class='  well control-group imagecache_form'>
	<p><?php echo __('grayscale');?></p>
	<p><?php echo __('grayscale');?>:
	<?php echo Html::dropDownList("memo[grayscale]",$model->memo['grayscale'] ,array(
			''=>__('please select'), 1=>__('yes'),0=>__('no')
		));?>
	</p>  
</div>

	
<?php echo  $form->field($model, 'description')->textArea();  ?>

<div class="form-actions">
	<?php echo Html::submitButton(__('save'),  array('class' => 'btn ')); ?>
</div>
 
<?php ActiveForm::end(); 


js("
	var water = '".$model->memo['watermark']['ps']."';
	$('.watermark').each(function(){
		if($(this).val()==water){
			$(this).attr('checked','checked');
		}
	});
	$('.imagecache_form').hide(); 
	
	$('#type option:selected').each(function(){
		var v = $(this).val(); 
		$('#'+v).show();
	}); 
 
	$('#type').change(function(){
		var v = $(this).val();
		$('.imagecache_form').hide();
		for(p in v){
			$('#'+v[p]).show();
		} 
	  
	});
	 
");	
js_file('js/php.js');
js_file('js/jquery.dump.js');
widget('farbtastic',array(
	'tag'=>'#farbtastic',
	'to'=>'#border_color'
	));
?>