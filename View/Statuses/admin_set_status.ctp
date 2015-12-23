<?php

echo $this->Html->script('jscolor/jscolor.js'); 

?>
<style>
   
</style>


<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-content col-sm-6">
                <h4 style="margin-bottom:18px"><strong>Set Status Colors</strong></h4>
                <?php echo $this->Form->create('Color',array('novalidate','class'=>'form-horizontal'));?>
                
                
                <?php echo $this->Form->hidden('id',array('value'=>$this->request->data['Color']['id']));?>
                 <?php echo $this->Form->hidden('user_id',array('value'=>$this->request->data['Color']['user_id']));?>
              
               
                <div class="form-group">
                    <label class="control-label col-sm-4">Requested</label>
                    <div class="col-sm-8">
                            <?php echo $this->Form->input('requested',array(
                                            'type'=>'text',
                                            'label'=>false,
                                            'div'=>false,                                                    
                                            'class'=>'form-control color',
                                            'maxlength'=>8,
                                            'placeholder'=>'0')); 
                            ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Accepted</label>
                    <div class="col-sm-8">
                            <?php echo $this->Form->input('accepted',array(
                                            'type'=>'text',
                                            'label'=>false,
                                            'div'=>false,                                                    
                                            'class'=>'form-control color',
                                            'maxlength'=>8,
                                            'placeholder'=>'0')); 
                            ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Awaiting Confirmation</label>
                    <div class="col-sm-8">
                            <?php echo $this->Form->input('awaiting_confirmation',array(
                                            'type'=>'text',
                                            'label'=>false,
                                            'div'=>false,                                                    
                                            'class'=>'form-control color',
                                            'maxlength'=>8,
                                            'placeholder'=>'0')); 
                            ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Confirmed</label>
                    <div class="col-sm-8">
                            <?php echo $this->Form->input('confirmed',array(
                                            'type'=>'text',
                                            'label'=>false,
                                            'div'=>false,                                                    
                                            'class'=>'form-control color',
                                            'maxlength'=>8,
                                            'placeholder'=>'0')); 
                            ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Show</label>
                    <div class="col-sm-8">
                            <?php echo $this->Form->input('show',array(
                                            'type'=>'text',
                                            'label'=>false,
                                            'div'=>false,                                                    
                                            'class'=>'form-control color',
                                            'maxlength'=>8,
                                            'placeholder'=>'0')); 
                            ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">No Show</label>
                    <div class="col-sm-8">
                            <?php echo $this->Form->input('no_show',array(
                                            'type'=>'text',
                                            'label'=>false,
                                            'div'=>false,                                                    
                                            'class'=>'form-control color',
                                            'maxlength'=>8,
                                            'placeholder'=>'0')); 
                            ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">In Progress</label>
                    <div class="col-sm-8">
                            <?php echo $this->Form->input('in_progress',array(
                                            'type'=>'text',
                                            'label'=>false,
                                            'div'=>false,                                                    
                                            'class'=>'form-control color',
                                            'maxlength'=>8,
                                            'placeholder'=>'0')); 
                            ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Complete</label>
                    <div class="col-sm-8">
                            <?php echo $this->Form->input('complete',array(
                                            'type'=>'text',
                                            'label'=>false,
                                            'div'=>false,                                                    
                                            'class'=>'form-control color',
                                            'maxlength'=>8,
                                            'placeholder'=>'0')); 
                            ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-4">Personal Task Block</label>
                    <div class="col-sm-8">
                            <?php echo $this->Form->input('personal_task_block',array(
                                            'type'=>'text',
                                            'label'=>false,
                                            'div'=>false,                                                    
                                            'class'=>'form-control color',
                                            'maxlength'=>8,
                                            'placeholder'=>'0')); 
                            ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Personal Task Unblock	</label>
                    <div class="col-sm-8">
                            <?php echo $this->Form->input('personal_task_unblock',array(
                                            'type'=>'text',
                                            'label'=>false,
                                            'div'=>false,                                                    
                                            'class'=>'form-control color',
                                            'maxlength'=>8,
                                            'placeholder'=>'0')); 
                            ?>
                    </div>
                </div>
                 <div class="form-group">
                    <label class="control-label col-sm-4">On Waiting List	</label>
                    <div class="col-sm-8">
                            <?php echo $this->Form->input('on_waiting_list',array(
                                            'type'=>'text',
                                            'label'=>false,
                                            'div'=>false,                                                    
                                            'class'=>'form-control color',
                                            'maxlength'=>8,
                                            'placeholder'=>'0')); 
                            ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-4">&nbsp;</label>
                    <div class="col-sm-8 form-actions">
                        <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary update span3','label'=>false,'div'=>false));?>                           
                    </div>
                </div>
            <?php echo $this->Form->end(); ?></div>   
        </div>
    </div>
</div>