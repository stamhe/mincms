<?php $form = \application\core\ActiveForm::begin(array(
	'options' => array('class' => 'form-horizontal','id'=>'form_modal'),
	'fieldConfig' => array('inputOptions' => array('class' => 'input-xlarge')),
)); ?>
 


<div class="modal fade " id="modal">
    <div class="modal-dialog"> 
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">modal</h4>
        </div>
        <div class="modal-body">
          	
        </div>
        <div class="modal-footer">
          <?php echo \application\core\Html::button(__('run'),  array('class' => 'btn btn-default')); ?>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
    
<?php \application\core\ActiveForm::end(); ?>