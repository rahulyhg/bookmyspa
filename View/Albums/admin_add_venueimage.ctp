    <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h3 id="myModalLabel"><i class="icon-edit"></i>
                <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> <?PHP ECHO $type; ?></h3>
     </div>
     <div class="modal-body">
                <div class="box">
                    <div class="box-content">
                    <?php echo $this->Form->create('VenueImage',array('novalidate','type' => 'file'));?>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1" data-toggle="tab">English</a></li>
                        <li><a href="#tab2" data-toggle="tab">Arabic</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="sample-form form-horizontal">
                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label" >English Title *:</label>
                                        <div class="controls">
                                            <?php echo $this->Form->input('eng_title',array('label'=>false,'div'=>false,'class'=>'input-xlarge input-block-level','maxlength'=>'200')); ?>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label" >English Description *:</label>
                                        <div class="controls">
                                            <?php echo $this->Form->textarea('eng_description',array('label'=>false,'div'=>false,'class'=>'input-xlarge input-block-level')); ?>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <div class="sample-form form-horizontal">
                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label">Arabic Title *:</label>
                                        <div class="controls">
                                            <?php echo $this->Form->input('ara_title',array('label'=>false,'div'=>false,'class'=>'input-xlarge input-block-level','maxlength'=>'200')); ?>
                                        </div>
                                    </div>
                                </fieldset>
                               <fieldset>
                                    <div class="control-group">
                                        <label class="control-label" >Arabic Description *:</label>
                                        <div class="controls">
                                            <?php echo $this->Form->textarea('ara_description',array('label'=>false,'div'=>false,'class'=>'input-xlarge input-block-level')); ?>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>    
                        </div>
                    </div>
                      <div class="sample-form form-horizontal">
                      <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="input01"><?php echo ucfirst($type);?> : </label>
                                
                                    <div class="controls">
                                        <?php echo $this->Form->input('image',array('type'=>'file','label'=>false,'div'=>false,'class'=>'input-xlarge input-block-level' ,'onChange'=>'readURL(this)')); ?>
                                     <div class="preview">
                                      <?php
                                      $uid = $this->Session->read('Auth.User.id');
                                      if(!empty($imageData['VenueImage']['image'])){
                                       echo $this->Html->Image('/images/'.$uid.'/VenueImage/150/'.$imageData['VenueImage']['image']); 
                                      }
                                   ?> 
                                    </div>
                                    </div>
                              
                            </div>
                        </fieldset>
                    </div>
                    <div class="sample-form form-horizontal">
                    <fieldset>
                     <div class="from-action text-center">
                             <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary save','label'=>false,'div'=>false));?>
                             <button  data-dismiss="modal" class="btn">Close</button>                       
                     </div>
                    </fieldset> 
                    </div>
                <?php echo $this->Form->end(); ?>
            </div>   
</div>
</div>     

<script>
 /* function to show image before upload */
 function readURL(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.preview').html('<img src="'+e.target.result+'" style="width: 200px;"/>');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>


