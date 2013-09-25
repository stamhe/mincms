<?php 
use application\modules\content\models\FormBuilder;
use yii\widgets\ActiveForm;  
use yii\helpers\Html;
$id = 'form'.uniqid();  
$form = ActiveForm::begin(array(
	'options' => array('class' => 'form-horizontal cck','id'=>$id),
	'fieldConfig' => array('inputOptions' => array('class' => 'input-xlarge')),
));  ?>
<div class="<?php echo $id;?>"></div>

<?php foreach($data as $field=>$value){?>
	<?php 

	if(strpos($value['widget'] , 'hidden') === false){ 
		echo "<label>".__($value['name'])."</label>";
	}
 
	/**
	* 后台自动加载插件改变的值
	*/
	$plugins = $value['plugins'];
	if($plugins){ 
		foreach($plugins as $pk=>$pks){  
		 	 echo plugin($pk , $pks , $field);
		}
	}	
  	$widget = 'application\modules\content\widget\\'.$value['widget'].'\widget'; 
  	
	echo $widget::widget(array(
		'label'=>$value['name'],
		'name'=>$field,
		'value'=>$new,
		'form'=>$form,
		'model'=>$model
	));
	
	
	?> 
<?php }?>
	
<p style='clear:both;'>
	<?php echo Html::submitButton(__('save'),  array('class' => 'btn btn-info ')); ?>
</p>
</p>
<?php ActiveForm::end();
js("");
js_file(http().'js/php.js');
js_file(http().'js/jquery.form.js');

$out= "<ul class='alert alert-success flash-message'>";
$out.= '<li>'.$message.'</li>';
$out.="</ul>"; 
if(!$_GET['id']){
	$js = "$('input,textarea').val('');$('.file').remove();";
}
js("
$('#".$id."').ajaxForm(function(data) { 
	data = data.substr(strrpos(data,'##ajax-form-alert##:'));
	data = str_replace('##ajax-form-alert##:','',data);
	if(data!=1){
		$('.".$id."').html(data);
	}else{
		$('.".$id."').html(\"".$out."\"); 
	//	$('#".$id." button[type=\"submit\"]').attr('disabled','disabled');
		".$script."
	}
	$('.flash-message').delay(2500).fadeOut();
	".$js."
     
}); 
");	
?>