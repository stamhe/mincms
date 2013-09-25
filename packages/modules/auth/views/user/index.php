<?php
use yii\helpers\Html;
/**
 * @var yii\base\View $this
 */
 
$this->title = __('user');
$this->params['breadcrumbs'][] =  array('label'=>__('user'),'url'=>url('auth/user/index'));  
$this->params['breadcrumbs'][] = __('list'); 
?>
<blockquote>
	<h3>
		<?php echo $this->title; ?> 
	</h3>
</blockquote>
<?php echo application\core\widget\Table::widget(array(
	'models'=>$models,
	'pages'=>$pages,
	'modal'=>true,
	'fields'=>array('id','username','email','bindgroup')	
));?>

