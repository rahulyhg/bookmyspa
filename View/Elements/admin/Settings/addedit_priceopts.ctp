<?php echo $this->Form->create('PricingLevel',array('url'=>'/admin/Settings/pricing_level/','id'=>'pricingLevelForm','class'=>'form-horizontal','novalidate','type' => 'file')); ?>
        <?php echo $this->Form->hidden('PricingLevel.id',array('div'=>false,'label'=>false));?>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Name*:</label>
                        <div  class=" col-sm-7">
                        <?php echo $this->Form->input('eng_name',array('class'=>'form-control','div'=>false,'label'=>false));?>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Status *:</label>
                        <div  class=" col-sm-7">
                        <?php $statusOpt = array('1'=>'Active','0'=>'Inactive'); ?>
                        <?php echo $this->Form->input('status',array('options'=>$statusOpt,'class'=>'form-control','div'=>false,'label'=>false,'empty'=>'Please Select'));?>
                        </div>
                    </div>
                    
            
                    <div class="utopia-from-action">
                        <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary col-sm-5 submitpricingOpt','label'=>false,'div'=>false));?>
                            
                    </div>
    <?php echo $this->Form->end();?>