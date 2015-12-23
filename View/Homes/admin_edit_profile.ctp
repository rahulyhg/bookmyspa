 <?php
       echo $this->Html->css('datepicker/datepicker-css');
        echo $this->Html->script('datepicker/datepicker-js');
    ?>    
<div class="row-fluid">
    <div class="span12">
        <section class="utopia-widget">
            <div class="utopia-widget-title">
                <?php echo $this->Html->image('admin/icons/window.png',array('class'=>'utopia-widget-icon' ));?>
                <span>Edit Profile</span>
                
            </div>
      
            <div class="utopia-widget-content">
                <div class="row-fluid">
                    <div class="span6 utopia-form-freeSpace">
                    
                    <?php echo $this->Form->create('User',array('novalidate','type' => 'file','class'=>'form-horizontal')); ?>
                    <div class="control-group">
                                <label class="control-label"></label>
                                <div class="controls">
                                     <h3>Profile</h3>
                                </div>
                            </div>
                   
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label">First Name *:</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('first_name',array('class'=>'input-xlarge input-block-level','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Last Name *:</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('last_name',array('class'=>'input-xlarge input-block-level','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Email*:</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('email',array('class'=>'input-xlarge input-block-level','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Username *:</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('username',array('class'=>'input-xlarge input-block-level','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Date Of Birth *:</label>
                                <div class="controls">
                                <?php echo $this->Form->hidden('UserDetail.id',array());?>
                                    <?php
                                        echo $this->Form->input('UserDetail.dob', array('type'=>'text','class'=>'input-xlarge input-block-level','id'=>'datepicker',
                                            'label' => false,
                                           // 'dateFormat' => 'DMY',
                                           // 'minYear' => date('Y') - 70,
                                           // 'maxYear' => date('Y') - 15,
                                        ));
                                        
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Gender  :</label>
                                <div class="controls">
                                 <?php
                                    $options = array('male' => 'Male', 'female' => 'Female');
                                    $attributes = array('legend' => false);
                                    echo $this->Form->radio('UserDetail.gender', $options, $attributes);
                                 ?>
                                </div>
                            </div>
                         
                           <div class="control-group">
                                    <label class="control-label" for="input01">Image : </label>
                                    <div class="controls">
                                        <?php echo $this->Form->input('image',array('type'=>'file','label'=>false,'div'=>false,'class'=>'input-fluid')); ?>
                                     <div class="preview">
                                      <?php   if(!empty($this->request->data['User']['image'])){
                                      echo $this->Html->Image('../images/User/150/'.$this->request->data['User']['image']); 
                                   }
                                   ?> 
                                </div>
                                    
                                    </div>
                                   
                                </div>
                        </fieldset>
                 
                    </div>
                    
                    
                     <div class="span5 utopia-form-freeSpace">
             <div class="control-group">
                                <label class="control-label"></label>
                                <div class="controls">
                                     <h3>Contact Information</h3>
                                </div>
                            </div>
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label">Cell Phone *:</label>
                                <div class="controls">
                                <?php echo $this->Form->hidden('Contact.id',array());?>
                                    <?php echo $this->Form->input('Contact.cell_phone',array('class'=>'input-xlarge input-block-level','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Night Phone:</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('Contact.night_phone',array('class'=>'input-xlarge input-block-level','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Day Phone:</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('Contact.day_phone',array('class'=>'input-xlarge input-block-level','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Address *:</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('Address.eng_address',array('class'=>'input-xlarge input-block-level','div'=>false,'label'=>false));?>
                                      <?php echo $this->Form->hidden('Address.id',array());?>
                                </div>
                            </div>
                             <div class="control-group">
                                <label class="control-label">Country *:</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('Address.country_id',array('class'=>'input-xlarge input-block-level','options'=>$countryData,'selected'=>224,'div'=>false,'disabled','label'=>false));?>
                                </div>
                            </div>
                              <div class="control-group">
                                <label class="control-label">Zipcode *:</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('Address.zipcode',array('class'=>'input-xlarge input-block-level','div'=>false,'label'=>false,'required'=>false));?>
                                </div>
                            </div>
                              <div class="control-group">
                                <label class="control-label">State *:</label>
                                <div class="controls">
                                <?php $bType = array('1'=>'Abu Dhabi','2'=>'Dubai','3'=>'Sharjah','4'=>'Ajman','5'=>'Umm Al Qaiwain','6'=>'Ras AL Khaimah','7'=>'Fujairah') ?>

                                    <?php echo $this->Form->input('Address.state_id',array('class'=>'input-xlarge input-block-level','options'=>$bType,'div'=>false,'label'=>false));?>
                                </div>
                            </div>
                              <div class="control-group">
                                <label class="control-label">City *:</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('Address.city',array('class'=>'input-xlarge input-block-level','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                        </fieldset>
                   
                    </div>
              
                <div class="row-fluid">
                    <div class="span12 utopia-form-freeSpace">
                        <fieldset>
                              <div class="utopia-from-action">
                            <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary span5','label'=>false,'div'=>false));?>
                                
                            <?php echo $this->Form->button('Cancel',array(
                                            'type'=>'button','label'=>false,'div'=>false,
                                            'class'=>'btn  span5',
                                            'onclick'=>"location.href = '".$this->Html->url(array('controller'=>'Dashboard','action'=>'index','admin'=>true))."';")); ?>
                        </div>
                        </fieldset>
                    </div>
                     <?php echo $this->Form->end();?>
                </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        jQuery("#UserAdminEditProfileForm").validationEngine();
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} var today = yyyy+'/'+mm+'/'+dd;
        $('#datepicker').val(today);
        
        $('#datepicker').datepicker({
            format: 'yyyy/mm/dd',
            weekStart: '0'
        });
        
        })
</script>