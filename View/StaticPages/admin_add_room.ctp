<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel"><i class="icon-edit"></i>
    <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Room</h3>
</div>
<div class="modal-body">
        <div class="box">
            
            <div class="box-content">
                    <?php echo $this->Form->create('SalonRoom',array('novalidate'));?>
                       <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1" data-toggle="tab">English</a></li>
                            <li><a href="#tab2" data-toggle="tab">Arabic</a></li>
                            <?php   echo $this->Form->hidden('id',array('label'=>false,'div'=>false)); ?>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="sample-form form-horizontal">
                                    <fieldset>
                                        <div class="control-group">
                                            <label class="control-label" > Room type *:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('eng_room_type',array('label'=>false,'div'=>false,'class'=>'input-xlarge input-block-level')); ?>
                                            </div>
                                        </div>
                                     </fieldset>
                                    <fieldset>
                                        <div class="control-group">
                                            <label class="control-label" > Description *:</label>
                                            <div class="controls">
                                               <?php echo $this->Form->textarea('eng_description',array('label'=>false,'div'=>false,'class'=>'input-xlarge input-block-level')); ?>
                                            </div>
                                        </div>
                                    </fieldset>
                                    
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2">
                                <div class="sample-form form-horizontal">
                                     <div class="control-group">
                                            <label class="control-label" > Room type *:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('ara_room_type',array('label'=>false,'div'=>false,'class'=>'input-xlarge input-block-level')); ?>
                                            </div>
                                        </div>
                                    <fieldset>
                                        <div class="control-group">
                                            <label class="control-label" > Description *:</label>
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
                                <label class="control-label" for="input01">Room Class *:</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('room_class',array('options'=>array('DB'=>'Double','DD'=>'Double Double','SN'=>'Single','TR'=>'Triple','TW'=>'Twin'),'empty'=>' Not Set','label'=>false,'div'=>false,'class'=>'input-small')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="input01">Minimum Guests *:</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('min_guest',array('label'=>false,'div'=>false,'class'=>'input-small')); ?>
                                </div>
                            </div>
                             <div class="control-group">
                                <label class="control-label" for="input01">Maximum Guests *:</label>
                                <div class="controls">
                                   <?php echo $this->Form->input('max_guest',array('label'=>false,'div'=>false,'class'=>'input-small')); ?>
                                </div>
                            </div>
                            <div class="form-actions">
                                <?php
                                echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary update ','label'=>false,'div'=>false));?>
                                
                                <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal',
                                            'type'=>'button','label'=>false,'div'=>false,
                                            'class'=>'btn closeModal')); ?>
                                
                            </div>
                        </fieldset> 
                        </div>
                        
                    <?php echo $this->Form->end(); ?>
                </div>   
            </div>
</div>     

