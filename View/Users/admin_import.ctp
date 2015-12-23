<div class="row-fluid">
    <div class="span12">
         <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                   <?php echo __('Import customers from CSV file'); ?>
                </h3>
            </div>     
            <div class="box-content">
                <div class="blogdataView">
               <?php
                echo $this->Form->create($modelClass, array('action' => 'import', 'type' => 'file' , 'class'=>'form-horizontal') );  ?>
                <div class="control-group">
                        <label class="control-label" for="textfield">Csv File:</label>
                        <div class="controls">
                             <?php echo $this->Form->input('CsvFile', array('label'=>'','type'=>'file') ); ?>
                             <span class="help-block">Only .csv file accepted (<?php echo $this->Html->link(__('Sample Import file') , array('action'=>'sendFile' , 'controller'=>'users' ,'admin'=>true, 'sample_users_import.csv')); ?>)</span>
                        </div>
                </div>
                 <div class="form-actions">
                     <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary','label'=>false,'div'=>false));?>
                 </div>   
                <?php 
                         echo $this->Form->end();
                ?>
                </div>
             </div>
        </div>
    </div>
</div>

