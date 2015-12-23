<?php $this->Paginator->options(array(
    'update' => '#list-history',
    
    'before' => $this->Js->get('.loader-container')->effect(
        'fadeIn',
        array('buffer' => false)
    ),
    'complete' => $this->Js->get('.loader-container')->effect(
        'fadeOut',
        array('buffer' => false)
    ),
));?>
<div class="modal-dialog vendor-setting addUserModal" id ="list-history">
    <div class="modal-content">
		<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
		Customer Appointment History 
            </h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-content">
			    <div class="tab-content" >
				 <?php echo $this->element('admin/Customer/list_history'); ?>
			    </div>			
			</div>
		    </div>
		</div>
            </div>
        </div>
    </div>
</div>

<script>

</script>
<style>
	.ui-icon {
		background-repeat: no-repeat;
		display: block;
		overflow: hidden;
		text-indent: 0;
	}
</style><?php
echo $this->Js->writeBuffer();?>