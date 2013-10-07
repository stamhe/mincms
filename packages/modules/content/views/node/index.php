<?php
use yii\helpers\Html;
use application\modules\content\Classes;
use yii\widgets\ActiveForm; 
use application\modules\auth\Auth;
/**
 * @var yii\base\View $this
 */
 
$this->title = __('content');
if($label)
$this->params['breadcrumbs'][] = $label; 
?>
 
<blockquote> 
		 <?php echo $label;?>
</blockquote> 
 
<?php 
$fields = Classes::structure($name);
 
?>
<?php if(!$fields){?>
	<div class='alert alert-warning'><?php echo __('no fileds');?></div>
<?php return;}?>
<?php echo $this->render('search',array('slug'=>$name,'fid'=>$fid,'model'=>$model ,'filters'=>$filters));?>
<?php echo Html::a('<span class="label"><i class="glyphicon glyphicon-plus-sign "></i></span>',url('content/node/create',array('name'=>$name)));?> 
<?php $form = ActiveForm::begin(array(
	'options' => array('class' => 'form-horizontal','id'=>'sort'),
	'fieldConfig' => array('inputOptions' => array('class' => 'input-xlarge')),
)); ?>
<?php echo Html::hiddenInput('name',$name);?>
<a name="table"></a>
	 <table class="table">
	  <thead>
	    <tr> 
		<th><?php echo __('id');?></th>
		 <?php foreach($fields as $title=>$v){ 
				if($v['list']==1){?>
	      	<th><?php echo __($title);?></th>
	     <?php }}?>
	     <th><?php echo __('created');?></th>
	     <th><?php echo __('updated');?></th>
	      <th><?php echo __('user');?></th>
	      <th><?php echo __('action');?></th>
	    </tr>
	  </thead>
	  <tbody>
	    <?php if(!$models) return;foreach($models as $model){?>
	    <tr id="node_<?php echo $model->id;?>"> 
	    <td><i class="drag"></i><?php echo Html::hiddenInput('ids[]',$model->id).$model->id;?></td>
	    <?php foreach($fields as $title=>$v){ 
				if($v['list']==1){?>
	      <td><?php echo Classes::field_show_list($name,$title,$model->$title);?></td>
	   <?php }}?>
	    <td title="<?php echo date('Y-m-d H:i:s' , $model->created);?>"><?php echo date('Y-m-d' , $model->created);?> </td>
	   	<td title="<?php echo date('Y-m-d H:i:s' , $model->updated);?>"><?php echo date('Y-m-d' , $model->updated);?> </td>
	   	<td><?php 
	   	 
	   	if($model->admin == 1) {
	   		$u = Auth::user($model->uid);	
	   	?>
	   	<span title="<?php echo $u->email;?>" class='label label-info'><?php echo $u->username;?></span>
	   		
	   	<?php }?></td>
	   		
	   	
	     <td>
	      	<?php  
	      	  if(self($model->uid)){
	      	  	echo Html::a('<i class="glyphicon glyphicon-edit" title="'. __('edit').'"></i>',url('content/node/update',array('name'=>$name,'id'=>$model->id)));?> 
	      	 &nbsp;   
	        <?php if($model->display == 1){?>
	        	<a href="<?php echo url('content/node/display',array('name'=>$name,'id'=>$model->id));?> ">
	        		<img src="<?php echo http();?>comm/img/right.png" />
	        	</a>
	        <?php }else{?>
	        	<a href="<?php echo url('content/node/display',array('name'=>$name,'id'=>$model->id));?> ">
	        		<img src="<?php echo http();?>comm/img/error.png" />
	        	</a> 
	        <?php }}else{?>
	      		
		      		<?php 
		      		if( uid() == 1){
		      			echo Html::a('<i class="glyphicon glyphicon-edit" title="'. __('edit').'"></i>',url('content/node/update',array('name'=>$name,'id'=>$model->id)));?> 
		      			&nbsp;  
		      			<?php if($model->display == 1){?>
			        	<a href="<?php echo url('content/node/display',array('name'=>$name,'id'=>$model->id));?> ">
			        		<img src="<?php echo http();?>comm/img/right.png" />
			        	</a>&nbsp;  
			        	<?php }else{?>
			        	<a href="<?php echo url('content/node/display',array('name'=>$name,'id'=>$model->id));?> ">
			        		<img src="<?php echo http();?>comm/img/error.png" />
			        	</a> &nbsp;  	
		      		<?php 
		      		}}?>
		      			
	      			<i class="glyphicon glyphicon-lock" title="<?php echo __('not your create');?>"></i>
	      	<?php }?>
	      </td>
	    </tr>
	    <?php }?>
	  </tbody>
	</table> 

<?php 
\application\core\UI::sort('#sort',url('content/node/sort'));
ActiveForm::end(); 
?>
 
<?php  echo \application\core\LinkPager::widget(array(
      'pagination' => $pages,
  ));?>
	 
 