<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;  
use application\modules\content\Classes;
use application\modules\content\models\FieldView; 
$cols = Classes::structure($slug); 
if(YII_DEBUG === false) return;
if(!$cols) return;
foreach($cols as $k => $v){
	$content_type[] = $k;
} 
?>

<?php if(uid()==1){ 
	$view = FieldView::find()->where(array('fid'=>$fid))->one();  
 
 	$columns = $content_type;  
	if($view){
		$list_db = $view->list;
		$filter_db = $view->search;  
	}
?>	
<blockquote id='set_field' class='hander'>
	<?php echo __('set field');?>
</blockquote>
<div id='field'  style="display:none" >   
	<ul id='set_list' >
		<blockquote>
			<?php echo __('set display filed in list');?>
		</blockquote>	
		<?php 
		 
		foreach($columns as $col){
		?>
		<li class="label <?php if($list_db && in_array($col,$list_db)){?> label-info <?php }?>">
			<?php echo Html::a($col,url('content/site/search',array('slug'=>$slug,'name'=>$col,'type'=>'list')));?>
		</li>
		<?php }?>
	</ul>	
		
	<ul id='set_search'>
		<blockquote>
			<?php echo __('set search filed');?>
		</blockquote>
		<?php  
		foreach($columns as $col){
		?>
		<li class="label <?php if($filter_db && in_array($col,$filter_db)){?> label-info <?php }?>">
				<?php echo Html::a($col,url('content/site/search',array('slug'=>$slug,'name'=>$col)));?>
		</li>
		<?php }?>
	</ul>

</div>
<div style='clear:both;'></div>
<blockquote id='search' class="hander ">
	<span class="<?php if($filters){?> label label-important<?php }?>"><?php echo __('filter');?></span>
</blockquote>
<?php }?>

<div id='filter'  style="display:none"  class='well'>
	
 <?php $form = ActiveForm::begin(array(
	'options' => array('class' => 'form-horizontal' ,'id'=>'form_search'),
	'fieldConfig' => array('inputOptions' => array('class' => 'input-xlarge')),
)); ?> 
 	<?php  
 	/**
 	* show filter columns
 	*/
 	if($filters){
	 	foreach($filters as $k=>$f){
	 		if(is_array($f)){
	 			$out[$f[0]] = $f[2];
	 		}else{
	 			$out[$k] = $f;
	 		}
	 	}
	 	$filters  = $out;
 	} 
 	if($columns){
		foreach($columns as $col){ 
			if($filter_db && in_array($col,$filter_db)){
				$value = $cols[$col]; 
				if($value){
					$form_value = $filters[$col]; 
					$widget = 'application\modules\content\widget\\'.$value['widget'].'\widget'; 
					if(!$value['relate']){
						echo Html::hiddenInput("hidden[$col]",1);
					}
					echo "<label>".__($col)."</label>";
					echo $widget::widget(array(
						'label'=>$value['label'],
						'name'=>$col,
						'value'=>$form_value,
						'form'=>$form, 
					));
				} 
		 }}
	}
	 if($filter_db && $filter_db['created']){
		$widget = 'application\modules\content\widget\datepicker\widget'; 
		echo $widget::widget(array(
					'label'=>__('created'),
					'name'=>'created',
					'value'=>$filters['created'],
					'form'=>$form, 
				));
	 
	}
	 ?>
<div class="controls margin-top">
	<?php echo Html::submitButton(__('filter'), array('class' => 'btn btn-default ')); ?>
	&nbsp;&nbsp;
	<a href="<?php echo url('content/node/index',array('name'=>$slug,'rest'=>1));?>" class='btn btn-default'>
		<?php echo __('reset filter'); ?>
	</a>
</div>
<?php ActiveForm::end(); ?>

</div>

<?php 
js("
 
	 display('#search','#filter');
	 display('#set_field','#field');
	 function display(a,b){
	 	$(a).click(function(){  
		 	if($(b).css('display')=='block'){
		 		$(b).hide();
		 	}else{
		 		$(b).show();
		 	}
		 });
	 }
	 

");	
css("
#set_search li,#set_list li{
float:left; 
margin-right:5px;
display:block;
}
#set_search{
clear:both;display:block;margin-top:20px;
}
#set_list{margin-bottom:20px; min-height:50px;}
#search,#set_field{margin-left:20px;}
#field{margin-left:20px;margin-bottom:20px;min-height:126px;}
");
?>