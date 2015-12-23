
<div class="modal-dialog vendor-setting sm-vendor-setting">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h2 id="myModalLabel"><i class="icon-edit"></i>
    <?php echo $Type; ?> PRICING OPTION</h2>
        </div>
        <?php
	    echo $this->Form->create('ServicePricingOption',array('novalidate','class'=>'form-shorizontal'));
	     echo $this->Form->hidden('salon_service_id',array('label'=>false,'div'=>false));
	?>
        <div class="modal-body">
            <div class="box">
                    <div class="box-content sell_service edit-pricing-option">
                        <?php echo $this->element('admin/SalonServices/pricing_option_table'); ?>
		    </div>
                </div>
            </div>
       
        <div class="modal-footer pdng20">
	    <?php
		if( isset($salonservice['ServicePricingOption']) && !empty($salonservice['ServicePricingOption'])){
		    echo $this->Form->button('Delete',array('type'=>'button','data-id'=>'','class'=>'btn btn-danger del-option pull-left','label'=>false,'div'=>false));  
		}
	    ?>
            <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitPricingOption','label'=>false,'div'=>false));?>
            <?php echo $this->Form->button('Cancel',array( 'type'=>'button','label'=>false,'div'=>false, 'class'=>'btn' , 'data-dismiss'=>"modal")); ?>
        </div>
        <?php echo $this->Form->end();?>
    </div>
</div>

<script>
    $(document).ready(function(){
	
	/*******Validate Service Form*********/
	
	//var validator = $("#ServicePricingOptionAdminAddPricingoptionForm").kendoValidator({
	//	rules:{
	//		minlength: function (input) {
	//			return minLegthValidation(input);
	//		},
	//		maxlengthcustom: function (input) {
	//			return maxLegthCustomValidation(input);
	//		},
	//		pattern: function (input) {
	//			return patternValidation(input);
	//		},
	//		matchfullprice: function (input){
	//			return comparefullsellprice(input);
	//		}
	//	},
	//	errorTemplate: "<dfn class='text-danger'>#=message#</dfn>"}).data("kendoValidator");
	
	/***************End****************/
	
    });
</script>