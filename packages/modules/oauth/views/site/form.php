<?php
use yii\helpers\Html;
/**
 * @var yii\base\View $this
 */
$this->params['breadcrumbs'][] =  array('label'=>__('oauth'),'url'=>url('oauth/site/index')); 
$this->params['breadcrumbs'][] = $this->title;
?>

<?php echo \application\core\widget\Form::widget(array(
	'model'=>$model,
	'yaml' => "@application/modules/oauth/forms/".$name.".yaml",
));
js("
$('#oauthconfig-slug').css('width','200px');
$('#oauthconfig-slug').change(function(){
	$('#oauthconfig-name').val( $(this).val() );
});

");
?>

