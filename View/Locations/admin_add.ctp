<script>
     prodValidator = $("#LocationAdminAddForm").kendoValidator({
        rules:{
            minlength: function (input) {
                return minLegthValidation(input);
            },
            maxlength: function (input) {
                return maxLegthValidation(input);
            },
            pattern: function (input) {
                return patternValidation(input);
            },maxlengthcustom: function (input) {
                return maxLegthCustomValidation(input);
            },
        },
        errorTemplate: "<dfn class='text-danger'>#=message#</dfn>"}).data("kendoValidator");
</script>
<div class="modal-dialog vendor-setting sm-vendor-setting">
    <div class="modal-content">
        <?php echo $this->Form->create('Location',array('novalidate'));?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
            <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Locations</h3>
        </div>
        <div class="modal-body clearfix ServicePopForm">
            <div class="row">
            <div class="col-sm-12">
            <div class="box">
              <div class="box-content">
                <!--<ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab">English</a></li>
                    
                </ul>-->
                <div class="tab-content pdng-btm-non padding tab-content-inline tab-content-bottom ">
                    <div class="tab-pane active" id="tab1">
                        <div class="form-group clearfix mrgn-btm0">
                            <label class="control-label col-sm-3" >Name *:</label>
                            <div class="controls col-sm-9">
                                <?php echo $this->Form->input('City.city_name',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','maxlength'=>'101','maxlengthcustom'=>'100','required','validationMessage'=>"Cityname is required.",'data-minlength-msg'=>"Minimum 3 characters.",'data-maxlengthcustom-msg'=>"Maximum 100 characters.")); ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
              <div class="tab-content pdng-btm-non padding tab-content-inline tab-content-bottom ">
                    <div class="tab-pane active" id="tab1">
                        <div class="form-group clearfix mrgn-btm0">
                            <label class="control-label col-sm-3" >Arabic Name *:</label>
                            <div class="controls col-sm-9">
                                <?php echo $this->Form->input('City.ara_name',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','maxlength'=>'101','maxlengthcustom'=>'100'    )); ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
               </div>   
            </div>
            </div>
            </div>
            </div>
        <div class="modal-footer pdng20">
            <div class="col-sm-12 ">
                <div class="col-sm-3 pull-right">
                <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal','type'=>'button','label'=>false,'div'=>false,'class'=>'btn closeModal full-w')); ?>
                </div>
                <div class="col-sm-3 pull-right">
                <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary full-w update','label'=>false,'div'=>false));?>
                </div>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>