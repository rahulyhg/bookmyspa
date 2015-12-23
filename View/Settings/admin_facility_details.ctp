<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="col-sm-6">
		<div class="box-content">
                <?php echo $this->Form->create('FacilityDetail',array('novalidate','class'=>'form-horizontal'));?>
		<?php echo $this->element('admin/Settings/facility_details');  ?>
                <div class="form-group">
                    <label class="control-label col-sm-4">&nbsp;</label>
		    <div class="col-sm-8 form-actions">
			<?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary ','label'=>false,'div'=>false));?>
			<?php //echo $this->Html->link('Cancel',array('controller'=>'dashboard','action'=>'index','admin'=>true),array('escape'=>false,'class'=>'btn ')); ?>
		    </div>
                    
                </div>
                <?php echo $this->Form->end(); ?>
             </div>
	    </div>
	    </div>
        </div>
    </div>
</div>