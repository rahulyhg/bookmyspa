<style>
    .datepicker{z-index:1151 !important;}
</style>
<div class="modal-dialog vendor-setting sm-vendor-setting">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
                Subtract Product Quantity</h3>
        </div>
        <div class="modal-body">
            <div class="box">
                <div class="box-content">
                    <?php echo $this->Form->create('Product', array('novalidate' ,'class'=>'form-horizontal')); ?>
                    <?php echo $this->Form->hidden('id', array('name' => 'data[Product][id]', 'type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control')); ?>
                    <div class="form-group">
                        <label class="col-sm-4 control-label " for="input01">Barcode *:</label>
                        <div class="col-sm-5">
                            <?php echo $this->Form->input('barcode', array('name' => 'data[ProductHistory][barcode]', 'type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control','minlength'=>'3','maxlength'=>'25','required','validationMessage'=>"Barcode is Required.",'data-minlength-msg'=>"Minimum 3 characters.",'data-maxlength-msg'=>"Maximum 25 characters.")); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label " for="input01">Product Name *:</label>
                        <div class="col-sm-5 productName">
                            <?php echo (isset($product['Product']['eng_product_name']) && !empty($product['Product']['eng_product_name']))?$product['Product']['eng_product_name']:'---'; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label " for="input01">Date *:</label>
                        <div class="col-sm-5">
                            <?php echo $this->Form->input('date', array('name' => 'data[ProductHistory][date]', 'type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control','required','validationMessage'=>"Date is Required.")); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label " for="input01">Subtract Quantity *:</label>
                        <div class="col-sm-5">
                            <?php echo $this->Form->input('sub_quantity', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control','required','validationMessage'=>"Quantity is Required.",'pattern'=>'^[0-9]*$','data-pattern-msg'=>"Enter correct Quantity.",'lessthan'=>(isset($product['Product']['quantity']) && !empty($product['Product']['quantity']))?$product['Product']['quantity']:' ','data-lessthan-msg'=>'Subtract quantity should be less than the available quantity.')); ?>
                        </div>
                    </div>       
                    <div class="form-group">
                        <label class="col-sm-4 control-label " for="input01">Reason *:</label>
                        <div class="col-sm-7">
                            <div class="col-sm-6 nopadding">
                            <?php
                            $options = array('Business Use' => 'Business  Use', 'Damaged' => 'Damaged', 'Expired' => 'Expired', 'Lost' => 'Lost');
                            $attributes = array('default'=>'Business Use','separator'=>'</div><div class="col-sm-6 nopadding">','label'=>array('class'=>'new-chk'),'legend' => false, 'name' => 'data[ProductHistory][type]',);
                            echo $this->Form->radio('reason', $options, $attributes);
                            ?>
                            </div>
                            <div class="col-sm-12 nopadding">
                            <?php echo $this->Form->input('reason', array('name' => 'data[ProductHistory][reason]',  'row' => 4, 'type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control', 'placeholder' => 'Description','required','validationMessage'=>"Reason is Required.")); ?>
                            </div>
                            
                        </div>
                    </div>      
                    <div class="form-group">
                        <label class="col-sm-4 control-label ">&nbsp;</label>
                        <div class="col-sm-5 form-actions ">
                        <?php echo $this->Form->button('Save', array('type' => 'submit', 'class' => 'btn btn-primary subtract', 'label' => false, 'div' => false)); ?>
                        <?php
                        echo $this->Form->button('Cancel', array('data-dismiss' => 'modal',
                            'type' => 'button', 'label' => false, 'div' => false,
                            'class' => 'btn closeModal'));
                        ?>
                        </div>
                    </div>

                </div>
<?php echo $this->Form->end(); ?>
            </div>   
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    var prodValidator = $(document).find("#ProductAdminSubtractQtyForm").kendoValidator({
        rules:{
            minlength: function (input) {
                return minLegthValidation(input);
            },
            maxlength: function (input) {
                return maxLegthValidation(input);
            },
            pattern: function (input) {
                return patternValidation(input);
            },
            lessthan:function(input){
                return comparelessthan(input);   
            }
        },
        errorTemplate: "<dfn class='text-danger'>#=message#</dfn>"}).data("kendoValidator");
    
    $(document).find('#ProductDate').datepicker({dateFormat: 'yy-mm-dd', changeMonth: true,
changeYear: true});
});
</script>
