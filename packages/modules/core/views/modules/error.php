
	
<div class="container bs-docs-container"  >

   	 <div class='alert alert-warning'><?php echo __('@app some module name is the same as @application');?></div> 
		
 	<?php foreach($rows as $k=>$v){?>
 		<p><span class='label label-danger'><?php echo \Yii::getAlias("@app/modules/".$k);?></span></p>
 	<?php }?>
</div>