<div class="modal-dialog vendor-setting sm-wizard-info">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h2 id="myModalLabel"> SETUP BUSINESS WIZARD</h2>
        </div>
        <div class="modal-body">
                <div class="box">
                    <div class="box-content">
                        <div class="col-sm-12 pdng10">
                            <b>This Wizard will fill up below details.</b>
                        </div>
                        <div class="col-sm-12 pdng6">
                            <div class="col-sm-2">
                              <b class="pull-right">- </b>
                            </div>
                            <div class="col-sm-9">
                                Business Opening Hours
                            </div>
                        </div>
                        <div class="col-sm-12 pdng6">
                            <div class="col-sm-2">
                              <b class="pull-right">- </b>
                            </div>
                            <div class="col-sm-9">
                                Description of your Business
                            </div>
                        </div>
                        <div class="col-sm-12 pdng6">
                            <div class="col-sm-2">
                              <b class="pull-right">- </b>
                            </div>
                            <div class="col-sm-9">
                                Bank Details for Payment from Sieasta to your Business Account
                            </div>
                        </div>
			 <div class="col-sm-12 pdng6">
                            <div class="col-sm-2">
                              <b class="pull-right">- </b>
                            </div>
                            <div class="col-sm-9">
                                Pin your location on Google Maps
                            </div>
                        </div>
                        <div class="col-sm-12 pdng6">
                            <div class="col-sm-2">
                              <b class="pull-right">- </b>
                            </div>
                            <div class="col-sm-9">
                                Facilities at your Business Venue
                            </div>
                        </div>
                       
                        <!--<div class="col-sm-12 pdng6">
                            <div class="col-sm-2">
                              <b class="pull-right">- </b>
                            </div>
                            <div class="col-sm-9">
                                Verification of your Business email
                            </div>
                        </div>-->
                    </div>
                </div>
        </div>
       <div class="modal-footer pdng20">
        <?php if(!$this->Session->read("Wizard.manual")){?>
            <?php echo $this->Form->button('Remind me later',array('type'=>'submit','data-type'=>'business_setup','class'=>'btn remindLater','label'=>false,'div'=>false));?>
             <?php } ?>
	      <?php echo $this->Form->button('Continue',array(
                                        'type'=>'button','label'=>false,'div'=>false,
                                        'data-type'=>'business_setup','class'=>'btn btn-primary wizardsInfo' , 'data-dismiss'=>"modal")); ?>
                                    
			
        </div>
            
    </div>
</div>


