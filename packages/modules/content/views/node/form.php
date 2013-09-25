<?php 
use application\modules\content\models\FormBuilder;
$id = $_GET['id'];
if(!$id){ 
	$info = __('create');
}else{ 
	$info = __('update');
}
$this->title = __('content');
$this->params['breadcrumbs'][] =  array('label'=>__('content'),'url'=>url('content/node/index',array('name'=>$name)));  
$this->params['breadcrumbs'][] = $info; 	
?>
<blockquote>
 
		[<?php echo $one->name;?>] <?php if($_GET['id']){?> #<?php echo $_GET['id'];?> <?php }?>
		<small>
			<?php echo $info; ?>
		</small>
 
</blockquote>
<?php  
$form = new FormBuilder($name,$id);
echo $form->run(); 
//class="fancybox fancybox.ajax"
widget('fancyBox',array(
		'tag'=>'.file a',
		'theme'=>3,
        'options'=>array()
));
?>

