<style>
    .form-horizontal .col-sm-2.col-sm-2 control-label {
        text-align: right;
    }
</style>
<div class="modal-dialog vendor-setting">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel"><i class="icon-edit"></i>
    <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Featuring Plan </h3>
</div>
<div class="modal-body">
        <div class="box">
             <div class="box-content">
              <?php echo $this->Form->create('FeaturingSubscriptionPlan',array('novalidate','class'=>'form-horizontal')); ?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Title *:</label>
                                <div class="col-sm-5">
                                    <?php echo $this->Form->input('title',array('class'=>'form-control','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="inputError">Sub-Title *:</label>
                                <div class="col-sm-5">
                                    <?php echo $this->Form->input('sub_title',array('class'=>'form-control','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Salon Featuring :</label>
                                <div class="col-sm-5">
                                    <?php echo $this->Form->input('salon_featuring',array('type'=>'checkbox','class'=>'','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Deal Featuring :</label>
                                <div class="col-sm-5">
                                    <?php echo $this->Form->input('deal_featuring',array('type'=>'checkbox','class'=>'','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                            <div class="form-group NoDEAL" style="display: <?php echo (isset($this->data['FeaturingSubscriptionPlan']['deal_featuring']) && ($this->data['FeaturingSubscriptionPlan']['deal_featuring']))? 'block':'none'; ?>;" >
                                <label class="col-sm-2 control-label">No of Deals *:</label>
                                <div class="col-sm-5">
                                    <?php echo $this->Form->input('no_of_deals',array('class'=>'form-control','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Package Featuring :</label>
                                <div class="col-sm-5">
                                    <?php echo $this->Form->input('package_featuring',array('type'=>'checkbox','class'=>'','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                            <div class="form-group NoPKG" style="display: <?php echo (isset($this->data['FeaturingSubscriptionPlan']['package_featuring']) && ($this->data['FeaturingSubscriptionPlan']['package_featuring']))? 'block':'none'; ?>;">
                                <label class="col-sm-2 control-label">No of Packages *:</label>
                                <div class="col-sm-5">
                                    <?php echo $this->Form->input('no_of_package',array('class'=>'form-control','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Staff Featuring :</label>
                                <div class="col-sm-5">
                                    <?php echo $this->Form->input('staff_featuring',array('type'=>'checkbox','class'=>'','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                            <div class="form-group NoSTAFF" style="display: <?php echo (isset($this->data['FeaturingSubscriptionPlan']['staff_featuring']) && ($this->data['FeaturingSubscriptionPlan']['staff_featuring']))? 'block':'none'; ?>;" >
                                <label class="col-sm-2 control-label">No of Staff *:</label>
                                <div class="col-sm-5">
                                    <?php echo $this->Form->input('no_of staff',array('class'=>'form-control','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Price *:</label>
                                <div class="col-sm-5">
                                    <?php echo $this->Form->input('price',array('class'=>'form-control','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Plan Type *:</label>
                                <div class="col-sm-5">
                                    <?php echo $this->Form->input('plan_type',array('empty'=>' -- Please Select -- ','options'=>array('M'=>'Monthly','BA'=>'Bi Annual','A'=>'Annual'),'class'=>'form-control','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Make Featured :</label>
                                <div class="col-sm-5">
                                    <?php echo $this->Form->input('featured',array('type'=>'checkbox','class'=>'','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Status *:</label>
                                <div class="col-sm-5">
                                    <?php echo $this->Form->input('status',array('options'=>array('1'=>'Active','0'=>'Inactive'),'empty'=>' -- Please Select -- ','class'=>'form-control','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                            <div class="form-actions text-center">
                                <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary update','label'=>false,'div'=>false));?>

                                <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal',
                                                'type'=>'button','label'=>false,'div'=>false,
                                                'class'=>'btn',
                                               )); ?>
                            </div>
                    <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>    

<script>
    function showhide(funtype,theClass){
        if(funtype == 'show'){
            $('.'+theClass).show();
        }else{
            $('.'+theClass).hide();
        }
    }
    $(document).ready(function(){
        $(document).on('click','#FeaturingSubscriptionPlanDealFeaturing',function(){
            if($(this).is(':checked')){
              showhide('show','NoDEAL');
            }
            else{
              showhide('hide','NoDEAL');
            }
        })
        $(document).on('click','#FeaturingSubscriptionPlanPackageFeaturing',function(){
            if($(this).is(':checked')){
              showhide('show','NoPKG');
            }
            else{
               showhide('hide','NoPKG');
            }
        })
        $(document).on('click','#FeaturingSubscriptionPlanStaffFeaturing',function(){
            if($(this).is(':checked')){
              showhide('show','NoSTAFF');
            }
            else{
               showhide('hide','NoSTAFF');
            }
        })
    });
</script>