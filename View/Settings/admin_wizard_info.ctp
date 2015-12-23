<div class="modal-dialog vendor-setting sm-wizard-info">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h2 id="myModalLabel"> Wizard Info</h2>
        </div>
        <div class="modal-body">
                <div class="box">
                    <div class="box-content">
                        <div class="col-sm-12 pdng10">
                            <div class="col-sm-3">
                              <b>Step - 1</b>
                            </div>
                            <div class="col-sm-9">
                                <?php echo $this->Html->link('Business Setup', 'javascript:void(0);' , array('title'=>'Business Setup Wizard','class'=>' btn btn-primary business_setup','escape'=>false)) ?>
                            </div>
                        </div>
                        <div class="col-sm-12 pdng10">
                            <div class="col-sm-3">
                              <b>Step - 2</b>
                            </div>
                            <div class="col-sm-9">
                                <?php echo $this->Html->link('Setup your staff', 'javascript:void(0);' , array('title'=>'Business Setup Wizard','class'=>'btn btn-primary staff_setup','escape'=>false,'disabled'=>true)) ?>
                            </div>
                        </div>
                        <div class="col-sm-12 pdng10">
                            <div class="col-sm-3">
                              <b>Step - 3</b>
                            </div>
                            <div class="col-sm-9">
                                <?php echo $this->Html->link('Setup services menu', 'javascript:void(0);' , array('title'=>'Business Setup Wizard','class'=>'btn btn-primary service_menu','escape'=>false,'disabled'=>true)) ?>
                            </div>
                        </div>
                        <div class="col-sm-12 pdng10">
                            <div class="col-sm-3">
                              <b>Step - 4</b>
                            </div>
                            <div class="col-sm-9">
                                <?php echo $this->Html->link('Photos/Videos uploader', 'javascript:void(0);' , array('title'=>'Business Setup Wizard','class'=>'btn btn-primary media_uploader','escape'=>false,'disabled'=>true)) ?>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="modal-footer pdng10">
            <?php echo $this->Html->link('Continue', 'javascript:void(0);' , array('title'=>'Business Setup Wizard','class'=>' btn btn-primary business_setup','escape'=>false)) ?>
        </div>
            
    </div>
    </div>


