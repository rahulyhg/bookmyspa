<style>
    .form-horizontal .col-sm-2.control-label {
        text-align: right;
    }
</style>  
<div class="modal-dialog vendor-setting addUserModal sm-vendor-setting">
<div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
          <h3 id="myModalLabel"><i class="icon-edit"></i>
         <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> City</h3>
      </div>
       <?php echo $this->Form->create('State',array('novalidate','id'=>'CountryAdminAddeditStateForm'));?>
      <div class="modal-body">
            <div class="box">
                  <div class="box-content nopadding">
                        <div class="tab-content">
                              <div class="tab-pane active" id="tab1">
                                    <div class="form-group clearfix">
                                    <label class="control-label col-sm-4 lft-p-non" >City Name *:</label>
                                       <?php echo $this->Form->hidden('id',array('label'=>false,'div'=>false)); ?>
                                        <?php echo $this->Form->hidden('country_id',array('value'=>$countryId,'label'=>false,'div'=>false)); ?>
                                        <?php echo $this->Form->input('name',array('label'=>false,'div'=>array('class'=>'col-sm-8 rgt-p-non'),'class'=>'form-control','required','validationMessage'=>'State name is required.')); ?>
                                     </div>
                                     <div class="form-group clearfix">
                                    <label class="control-label col-sm-4 lft-p-non" >City Arabic Name :</label>
                                       
                                        <?php echo $this->Form->input('ara_name',array('label'=>false,'div'=>array('class'=>'col-sm-8 rgt-p-non'),'class'=>'form-control')); ?>
                                     </div>
                                    <div class="form-group clearfix">
                                        <label class="control-label col-sm-4 lft-p-non" >Code *:</label>
                                           <?php echo $this->Form->input('code',array('label'=>false,'div'=>array('class'=>'col-sm-8 rgt-p-non'),'class'=>'form-control','required','validationMessage'=>'State code is required.')); ?>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
      <div class="modal-footer pdng20">
            <div class="form-actions">
              <?php
            echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary saveState ','label'=>false,'div'=>false));?>
            
            <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal',
                        'type'=>'button','label'=>false,'div'=>false,
                        'class'=>'btn',
                        )); ?>
            </div>
      </div>
        <?php echo $this->Form->end(); ?>
        </div>   
</div>