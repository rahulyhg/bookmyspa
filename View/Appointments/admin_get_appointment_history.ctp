<div class="modal-dialog vendor-setting addUserModal">
      <div class="modal-content">
            <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                  <h3 id="myModalLabel"><i class="icon-edit"></i>
                        <?php echo "Appointment History";  ?>
                  </h3>
		  <div id="myModalLabel">
                        <?php echo "Appointment History";  ?>
                  </div>
            </div>
            <div class="modal-body modelHistory">
                  <div class="row">
                        <div class="col-sm-12">
                              <div class="box">
                                    <div class="box-content">
					  <?php echo $this->element('admin/Customer/list_history'); ?>
                                    </div>
				    <div class="modal-footer pdng20">
                                                      
                              <?php //echo $this->Form->button('Cancel',array(
                                                                    //'type'=>'button',
                                                                    //'label'=>false,'div'=>false,
                                                                    //'data-dismiss'=>'modal',
                                                                    //	'class'=>'btn')); ?>
						                  </div>
                                                <?php //echo $this->Form->end();?>
                                    </div>
			      </div>
			</div>
		  </div>
	    </div>
      </div>
</div>
<style>
.modal .modelHistory {
    max-height: 600px;
    overflow-y: auto;
}
</style>