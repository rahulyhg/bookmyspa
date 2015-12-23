<div class="modal-dialog vendor-setting overwrite">
    <?php echo $this->Form->create('SalonOpeningHour', array('url' => array('controller' => 'Settings', 'action' => 'open_hours','admin'=>true),'id'=>'opeaningHoursForm','novalidate'));?>  
    <div class="modal-content">
        <div class="modal-header">
            <!--<button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
            <h2>When is <?php echo ucfirst($auth_user['Salon']['eng_name']); ?> Open?</h2>
        </div>

        <div class="modal-body clearfix">
            <?php echo $this->element('admin/Settings/open_hours');  ?>
        </div>

        <div class="modal-footer pdng20">
            
            <?php //echo $this->Form->button('Cancel',array('type'=>'submit','data-type'=>'business_setup','class'=>'btn remindLater','label'=>false,'div'=>false));?>
             <?php echo $this->Form->button('Next',array('type'=>'submit','data-type'=>'business_setup','class'=>'btn btn-primary submitopenHForm','label'=>false,'div'=>false));?>
                
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
<script>
    Custom.init();
</script>
