<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;  

if($p){ $this->title = $p->slug;} 
/**
 * @var yii\base\View $this
 */
$this->params['breadcrumbs'][] =  array('label'=>__('content type'),'url'=>url('content/site/index')); 
$this->params['breadcrumbs'][] = $this->title;
?>
<blockquote>
	<h3>
		<?php echo $this->title; ?> 
	</h3>
</blockquote>

	
<?php
$pid = $_GET['pid']?:0;
if($_GET['id']){
	$pid = $model->pid;
}
if($pid>0){
	echo $this->render('field' , array('model'=>$model , 'widget'=>$widget ,'id'=>$id));
}else{
	echo $this->render('type', array('model'=>$model));
}?>
 
