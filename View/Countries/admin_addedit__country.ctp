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
         <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Country</h3>
      </div>
      <?php echo $this->Form->create('Country',array('novalidate','id'=>'CountryAdminAddeditCountryForm'));?>
      <div class="modal-body">
            <div class="box">
                  <div class="box-content nopadding">
                        <div class="tab-content">
                              <div class="tab-pane active" id="tab1">
                               <div class="form-group clearfix">
                                    <label class="control-label col-sm-4 lft-p-non" >Country Title *:</label>
                                     <div class="col-sm-8 rgt-p-non">
                                       <?php echo $this->Form->hidden('id',array('label'=>false,'div'=>false)); ?>
                                        <?php echo $this->Form->input('title',array('label'=>false,'div'=>false,'class'=>'form-control','required','validationMessage'=>'Country title is required')); ?>
                                     </div>
                                </div>
                               <div class="form-group clearfix">
                                    <label class="control-label col-sm-4 lft-p-non" >Country Title Name :</label>
                                    <div class="col-sm-8 rgt-p-non">
                                        <?php echo $this->Form->input('ara_title',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="control-label col-sm-4 lft-p-non" >Country Name *:</label>
                                    <div class="col-sm-8 rgt-p-non">
                                        <?php echo $this->Form->input('name',array('label'=>false,'div'=>false,'class'=>'form-control','required','validationMessage'=>'Country name is required')); ?>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="control-label col-sm-4 lft-p-non" >Country Arabic Name :</label>
                                    <div class="col-sm-8 rgt-p-non">
                                        <?php echo $this->Form->input('ara_name',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="control-label col-sm-4 lft-p-non" >Capital:</label>
                                         <?php echo $this->Form->input('capital',array('label'=>false,'div'=>array('class'=>'col-sm-8 rgt-p-non'),'class'=>'form-control')); ?>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="control-label col-sm-4 lft-p-non" >Currency *:</label>
                                            <?php echo $this->Form->input('currency',array('label'=>false,'div'=>array('class'=>'col-sm-8 rgt-p-non'),'class'=>'form-control','required','validationMessage'=>'Currency value is required')); ?>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="control-label col-sm-4 lft-p-non" >Currency Code *:</label>
                                        <?php echo $this->Form->input('currency_code',array('label'=>false,'div'=>array('class'=>'col-sm-8 rgt-p-non'),'class'=>'form-control','required','validationMessage'=>'Currency code is required')); ?>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="control-label col-sm-4 lft-p-non" >Iso Code *:</label>
                                        <?php echo $this->Form->input('iso_code',array('label'=>false,'div'=>array('class'=>'col-sm-8 rgt-p-non'),'class'=>'form-control','required','validationMessage'=>'Iso code is required')); ?>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="control-label col-sm-4 lft-p-non" >Flag Icon :</label>
                                            <div class="preview">
                                            <?php
                                                if(isset($flagIcon) && !empty($flagIcon)){
                                                    echo $this->Html->Image("flags/".$flagIcon);
                                                    echo $this->Html->link(__('Change Image'),'javascript:void(0);',array('class'=>'showFile'));
                                                    $hideFile = 1;
                                                }?> 
                                            </div>
                                            <div class="previewInput" <?php if(isset($hideFile)){ echo 'style="display:none"'; } ?> >
                                            <?php echo $this->Form->input('flag_icon',array('type'=>'file','label'=>false,'div'=>array('class'=>'col-sm-8 rgt-p-non'),'class'=>'input-fluid')); ?>
                                            
                                                <?php
                                                if(isset($hideFile)){
                                                    echo $this->Html->link(__('Cancel'),'javascript:void(0);',array('class'=>'hideFile'));
                                                }
                                                ?>
                                            </div>
                                </div>
                               
                                <div class="form-group clearfix">
                                    <label class="control-label col-sm-4 lft-p-non" >Country Code *:</label>
                                       <?php echo $this->Form->input('phone_code',array('label'=>false,'div'=>array('class'=>'col-sm-8 rgt-p-non'),'class'=>'form-control validate[required]','required','validationMessage'=>'Country code is required')); ?>
                                </div>
                         </div>
                    </div>
                </div>
            </div>
      </div>
            <div class="modal-footer pdng20">
                        <div class="form-actions">
                           <?php
                        echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary saveCountry','label'=>false,'div'=>false));?>
                        
                        <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal',
                                    'type'=>'button','label'=>false,'div'=>false,
                                    'class'=>'btn',
                                    )); ?>
                        </div>
        </div>
        <?php echo $this->Form->end(); ?>
        </div>   
    </div>
<script>
    $(document).ready(function(){
            $(document).on('click','.showFile',function(){
                $(this).parent().next().show();
                $(this).parent().hide();
            });
            $(document).on('click','.hideFile',function(){
                $(this).parent().prev().show();
                $(this).parent().hide();
            });
    })
</script>