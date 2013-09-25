<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm; 
/**
 * @var yii\base\View $this
 */
 
$this->title = __('image cache');
$this->params['breadcrumbs'][] =  array('label'=>__('image cache'),'url'=>url('imagecache/admin/index'));  
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
	'fields'=>array('id','slug','description')	
)); 
?> 
 