
<div class="modal-dialog vendor-setting overwrite">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
    <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Pricing Options</h3>
        </div>
        <?php
	    echo $this->Form->create('PackagePricingOption',array('novalidate','class'=>'form-shorizontal'));
	     //echo $this->Form->hidden('salon_service_id',array('label'=>false,'div'=>false));
	?>
        <div class="modal-body SalonEditpop">
            <div class="box">
                    <div class="box-content sell_service edit-pricing-option">
                        <?php echo $this->element('admin/SalonServices/package_pricing_option_table'); ?>
			
                    </div>
                </div>
            </div>
       
        <div class="modal-footer">
	    <?php
		if( isset($package['PackagePricingOption']) && !empty($package['PackagePricingOption'])){
		    echo $this->Form->button('Delete',array('type'=>'button','data-id'=>'','class'=>'btn btn-danger del-option pull-left','label'=>false,'div'=>false));  
		}
	    ?>
            <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitPricingOption','label'=>false,'div'=>false));?>
            <?php echo $this->Form->button('Cancel',array( 'type'=>'button','label'=>false,'div'=>false, 'class'=>'btn' , 'data-dismiss'=>"modal")); ?>
        </div>
        <?php echo $this->Form->end();?>
    </div>
</div>

