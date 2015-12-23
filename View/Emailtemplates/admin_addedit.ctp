<div class="modal-dialog vendor-setting">
<div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
          <h3 id="myModalLabel"><i class="icon-edit"></i>
         <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Email Template </h3>
      </div>
      <div class="modal-body clearfix SalonEditpop">
            <div class="box">
            <div class="box-content">
             <?php echo $this->Form->create(null, array('url' => array('controller' => 'emailtemplates', 'action' => 'addedit'),'id'=>'emailTemplateId','novalidate'));              
                       echo $this->Form->hidden('Emailtemplate.id',array('value'=>$this->data['Emailtemplate']['id']));  ?> 
            <div class="tab-content bd-tp-non">
                            <div class="tab-pane active" id="tab1">
                                <div class="sample-form form-horizontal">
                                   <div class="form-group">
                                      <label class="control-label col-sm-3" >Name *:</label>
                                              <?php echo $this->Form->input('name',array('label' => false,'div' => array('class'=>'col-sm-6'), 'placeholder' => 'Name','class' => 'form-control','maxlength' => 55));?>
                                               <?php echo $this->Form->input('template_code',array('id'=>'template_code','type'=>'hidden','label' => false,'div' => array('class'=>'col-sm-6'), 'placeholder' => 'Name','class' => 'form-control','maxlength' => 55));?>
                                    </div>
                                    <div class="form-group">
                                            <label class="control-label col-sm-3" >Dynamic Fields *:</label>
                                            <?php $fields = array('{FirstName}'=>'First Name','{LastName}'=>'Last Name','{Email}'=>'Email Address'); ?>               
                                            <?php echo $this->Form->input('dynamic_text',array('type'=>'select','options'=>$fields,'label' => false,'div' => array('class'=>'col-sm-6'), 'empty' => 'Select Field','class' => 'form-control','onchange'=>'SetDynamicText()'));?>
                                    </div>
                                    <div class="form-group">
                                            <label class="control-label col-sm-3" >Template Description *:</label>
                                            <div class="col-sm-9">
                                             <?php echo $this->Form->textarea('template',array('id'=>'Emailtemplatetemplate','label'=>false,'class'=>'ckeditor form-control')); ?>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                            <label class="control-label col-sm-3" >Template Description(Text Format):</label>
                                            <div class="col-sm-9">
                                             <?php echo $this->Form->textarea('text_template',array('rows'=>7,'label'=>false)); ?>
                                      </div>
                                    </div>
                               </div>
                            </div>
                   <div class="sample-form form-horizontal">
                    <div class="form-group">
                                <label class="control-label col-sm-3" ></label>
                                <div class="col-sm-8">
                                    <i>{FirstName} for First Name,{LastName} for Last Name,{EMail} for Email</i>
                                </div>
                      </div>
                       <div class="col-sm-3"></div>
                         <div class="modal-footer pdng20">
                              <div class="col-sm-12 pull-right">
                                <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary update','label'=>false,'div'=>false));?>
                                <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal',
                                            'type'=>'button','label'=>false,'div'=>false,
                                            'class'=>'btn',
                                            )); ?>
                                
                              </div>
                         </div>
                    </div>
                                       </div>

                    <?php echo $this->Form->end(); ?>
               
           </div>
        </div>
    </div>
    </div>
    </div>
       <script type= "text/javascript">
       
       $(document).ready(function(){
             
             //$("#StaticPageAdminAddPageForm").validationEngine();
             
             $('#EmailtemplateName').keyup(function(){
                 var theval = $(this).val();
                 theval = theval.replace(/\s+/g, '_').toLowerCase()
                 $('#template_code').val(theval);
             });
             
             
         });
            var editor = CKEDITOR.instances['data[Emailtemplate][template]'];
            if (editor) {
               editor.destroy(true);
            }
            CKEDITOR.replace('data[Emailtemplate][template]');
            CKEDITOR.instances['Emailtemplatetemplate'].on('change', function() {
                var eng_val = CKEDITOR.instances['Emailtemplatetemplate'].getData();
                $(document).find('textarea[id=Emailtemplatetemplate]').html(eng_val)
            });
              function SetDynamicText()
              {
                     
                  var DynamicText = document.getElementById('EmailtemplateDynamicText').value ;
                  if(DynamicText==""){
                     return false;
                  }
                 // tinyMCE.execInstanceCommand('content',"mceInsertContent",false,DynamicText);
                 
                  var editor_data = CKEDITOR.instances['Emailtemplatetemplate'].getData();
                  var fulldata = DynamicText+editor_data;
                  CKEDITOR.instances['Emailtemplatetemplate'].setData(fulldata);
                  //var oEditor = CKEDITOR.instances.ckfinder;
                  //oEditor.insertHtml( DynamicText );
                  //CKEDITOR.instances[**ckeditorname**].setData(DynamicText)
                  //var getvalues = tinyMCE.getContent() + DynamicText;
                  //tinyMCE.setContent(getvalues);
              } 
       </script>
       