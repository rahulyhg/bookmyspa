<div class="modal-dialog vendor-setting sm-wizard-info">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h2 id="myModalLabel"> ADD Photo/Video WIZARD</h2>
        </div>
        <div class="modal-body">
                <div class="box">
                    <div class="box-content nopadding">
                        <div class="col-sm-12 pdng10">
                            <b>This Wizard will upload Photos and videos. Please have the below information with you before your start the wizards</b>
                        </div>
                        <div class="col-sm-12 pdng6 ">
                            <div class="col-sm-9">
                               <b> - </b> LOGO
                            </div>
                        </div>
                        <div class="col-sm-12 pdng6">
                            
                            <div class="col-sm-9">
                                <b> - </b> Main Picture 
                            </div>
                        </div>
                        <div class="col-sm-12 pdng6">
                           
                            <div class="col-sm-9">
                               <b> - </b> Venue Photos
                            </div>
                        </div>
                        <div class="col-sm-12 pdng6">
                           
                            <div class="col-sm-9">
                               <b> - </b> You Tube Links of the Video
                            </div>
                        </div>
                    </div>
                </div>
        </div>
       <div class="modal-footer pdng20">
         <?php if(!$this->Session->read("Wizard.manual")){?>
            <?php echo $this->Form->button('Remind me later',array('type'=>'submit','class'=>'btn remindLater','data-type'=>'media_uploader','label'=>false,'div'=>false));?>
            <?php } ?>
              <?php echo $this->Form->button('Continue',array('type'=>'button','label'=>false,'div'=>false,'data-type'=>'media_uploader','class'=>'btn btn-primary wizardsInfo' , 'data-dismiss'=>"modal")); ?>
        </div>
    </div>
    </div>


