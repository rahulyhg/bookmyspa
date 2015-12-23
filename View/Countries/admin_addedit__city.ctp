<div class="modal-dialog vendor-setting addUserModal sm-vendor-setting">
<div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
          <h3 id="myModalLabel"><i class="icon-edit"></i>
         <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Location/Area</h3>
      </div>
      <div class="modal-body">
      <div class="row">
            <div class="col-sm-12">
            <div class="box">
            <div class="box-content">
            <?php echo $this->Form->create('City',array('novalidate','id'=>'CountryAdminAddeditCityForm','class'=>'form-horizontal'));?>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="sample-form">
                             <div class="form-group">
                                    <label class="control-label col-sm-4" >Location/Area Name *:</label>
                                    <!--<div class="controls">-->
                                        <?php echo $this->Form->hidden('id',array('label'=>false,'div'=>false)); ?>
                                        <?php echo $this->Form->hidden('country_id',array('value'=>$countryId,'label'=>false,'div'=>false)); ?>
                                        <?php echo $this->Form->hidden('state_id',array('value'=>$stateId,'label'=>false,'div'=>false)); ?>
                                        <?php echo $this->Form->input('city_name',array('label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control')); ?>
                                    <!--</div>-->
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4" >Location/Area Code *:</label>
                                        <?php echo $this->Form->input('county',array('label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control')); ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4" >latitude *:</label>
                                        <?php echo $this->Form->input('latitude',array('label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control','type'=>'text')); ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4" >longitude *:</label>
                                        <?php echo $this->Form->input('longitude',array('label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control','type'=>'text')); ?>
                                </div>
                           </div>
                    </div>
                </div>
                <!--<div class="sample-form form-horizontal">
                   <div class="form-actions">-->
                   <div class="modal-footer pdng20">
                        <div class="form-actions">
                        <?php
                        echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary saveCity ','label'=>false,'div'=>false));?>
                        
                        <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal',
                                    'type'=>'button','label'=>false,'div'=>false,
                                    'class'=>'btn',
                                    )); ?>
                  </div>
                </div>
                        
                    <!--</div>
                </div>-->
                
            <?php echo $this->Form->end(); ?>
        </div>   
    </div>
</div>