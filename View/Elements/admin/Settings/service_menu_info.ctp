<div class="modal-dialog vendor-setting sm-wizard-info">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h2 id="myModalLabel"> SET UP SERVICES MENU </h2>
        </div>
        <div class="modal-body">
                <div class="box">
                    <div class="box-content">
                        <div class="col-sm-12 pdng10">
                            <b>This Wizard will create all the services provided by you. Please have the below information with you before you start the wizards</b>
                        </div>
                        <div class="col-sm-12 pdng6">
                            <div class="col-sm-2">
                              <b class="pull-right">- </b>
                            </div>
                            <div class="col-sm-9">
                                Services Provided
                            </div>
                        </div>
                        <div class="col-sm-12 pdng6">
                            <div class="col-sm-2">
                              <b class="pull-right">- </b>
                            </div>
                            <div class="col-sm-9">
                                Services Online Price/Duration
                            </div>
                        </div>
                        <div class="col-sm-12 pdng10">
                            <strong>The Services Created will be deactivated by default, You should go to Setting-Services, Upload Picture and Activate them</strong>  
                        </div>
                    </div>
                </div>
        </div>
       <div class="modal-footer pdng20">
        <?php if(!$this->Session->read("Wizard.manual")){?>
            <?php echo $this->Form->button('Remind me later',array('type'=>'submit','class'=>'btn remindLater','data-type'=>'service_menu','label'=>false,'div'=>false));?>
               <?php } ?>
              <?php echo $this->Form->button('Continue',array(
                                        'type'=>'button','label'=>false,'div'=>false,
                                        'data-type'=>'service_menu',
                                        'class'=>'btn btn-primary wizardsInfo' , 'data-dismiss'=>"modal")); ?>
      </div>
    </div>
    </div>


