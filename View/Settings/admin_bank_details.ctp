<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-title">
                <!--<h3><i class="glyphicon-settings"></i>
                   <span> Bank Information </span>
		</h3>-->
	    </div>
	    </br>
            <div class="col-sm-6">  
                <?php echo $this->Form->create('BankDetail',array('class'=>'form-horizontal'));?>
                <?php echo $this->element('admin/Settings/bank_details');  ?>
		<div class="form-group	">
		<label class="control-label  col-sm-4">&nbsp;</label>
                        <div class="form-actions col-sm-8">
                            <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary ','label'=>false,'div'=>false));?>
                            <?php //echo $this->Html->link('Cancel',array('controller'=>'dashboard','action'=>'index','admin'=>true),array('escape'=>false,'class'=>'btn ')); ?>
                        </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>