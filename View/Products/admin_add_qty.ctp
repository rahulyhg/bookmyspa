<div class="modal-dialog vendor-setting sm-vendor-setting">
        <div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel"><i class="icon-edit"></i>
    Add Product Quantity </h3>
</div>
<div class="modal-body">
        <div class="box">
            <div class="box-content">
                <?php echo $this->Form->create('Product',array('novalidate','class'=>'form-horizontal'));?>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="input01">Add Quantity *:</label>
                                  <div class="col-sm-7">
                                    <?php echo $this->Form->input('quantity',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'1','maxlength'=>'11','maxlengthcustom'=>'10','required','validationMessage'=>"Quantity is Required.",'pattern'=>'^[0-9]*$','data-pattern-msg'=>"Enter correct Quantity.",'data-minlength-msg'=>"Enter minimum 1 digit.",'data-maxlengthcustom-msg'=>"Maximum 10 digits are allowed.")); ?>
                                  </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4" >&nbsp</label>
                                <div class="col-sm-7 form-actions">
                                <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary updateQty','label'=>false,'div'=>false));?>
                                <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal',
                                            'type'=>'button','label'=>false,'div'=>false,
                                            'class'=>'btn closeModal')); ?>
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
                var prodValidator = $("#ProductAdminAddQtyForm").kendoValidator({
                rules:{
                    pattern: function (input) {
                        return patternValidation(input);
                    }
                },
                errorTemplate: "<dfn class='text-danger'>#=message#</dfn>"}).data("kendoValidator");
        });
</script>