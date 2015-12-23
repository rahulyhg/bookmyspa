<div class="modal-dialog vendor-setting overwrite">
    <?php echo $this->Form->create('FacilityDetail', array('url' => array('controller' => 'Settings', 'action' => 'facilityDetails','admin'=>true),'id'=>'facilityDetailForm','novalidate'));?>  
    <div class="modal-content">
        <div class="modal-header">
            <!--<button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
            <h2>Facility Details</h2>
        </div>
        <div class="modal-body clearfix">
            <div class="col-sm-12 nopadding">
                <div class="box">
                    <div class="box-content form-horizontal nopadding">
                        <?php echo $this->element('admin/Settings/facility_details');  ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer pdng20">
            <div class="col-sm-3 pull-right">
                <input type="submit" name="next" class="facilityDetailForm btn btn-primary" value="Next" />
            </div>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
<script>
    Custom.init();
</script>
