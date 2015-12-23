<?php $serviceType=unserialize(SERVICE_TYPE);?>
<div class="box-title">
  <h3>Filter</h3>
</div>
<div class="box-content" style="margin-bottom:20px">
  <!--<div class="col-sm-2">
      <div class="form-group">
        <strong>Purchase Date: </strong>
      </div>
  </div>-->
  <div class="col-sm-2">
      <div class="form-group">
        <?php echo $this->Form->input('startDate',array('class'=>'form-control datepicker largeTextBox','id'=>'startDate','placeholder'=>'From','label'=>false));?>
      </div>
  </div>
  <div class="col-sm-2">
      <div class="form-group">
        <?php echo $this->Form->input('endDate',array('class'=>'form-control datepicker largeTextBox','placeholder'=>'To','id'=>'endDate','label'=>false));?>
      </div>
  </div>
  
  <div class="col-sm-2">
      <div class="form-group">
        <?php 
        $sel_val='';
        if(isset($this->request->named['serviceType'])){
          $sel_val=$this->request->named['serviceType'];
        }elseif(isset($this->request->data['serviceType'])){
          $sel_val=$this->request->data['serviceType'];
        } ?>
        <?php echo $this->Form->select('serviceType',array($serviceType),array('empty'=>'Select Services','value'=>$sel_val,'class'=>'form-control full-w'));?>
      </div>
  </div>
    <?php 
    $sessionData=$this->Session->read('Auth.User');
    if($sessionData['type']=='1'){
    ?>
    <div class="col-sm-2">
      <div class="form-group">
        <?php 
        $sel_val='';
        if(isset($this->request->named['saloon'])){
          $sel_val=$this->request->named['saloon'];
        }elseif(isset($this->request->data['saloon'])){
          $sel_val=$this->request->data['saloon'];
        } ?>
        <?php echo $this->Form->select('saloon',array($allSaloons),array('empty'=>'Select Saloon','value'=>$sel_val,'class'=>'full-w'));?>
      </div>
  </div>
    <?php }?>
    
    <div class="col-sm-2">
        <div class="form-group">
        <?php
          if(isset($display_order_id) && !empty($display_order_id)){
            $display_order_id = $display_order_id;
          }
          else{
            $display_order_id = '';
          }
          echo $this->Form->input('sieasta_order',array('class'=>'form-control largeTextBox','id'=>'sieasta_order_id','placeholder'=>'Order Id','label'=>false,'value' => $display_order_id));?>
        </div>
    </div>
    
  <div class="col-sm-2">
    <div class="row">
      <div class="form-group">
        <div class="col-sm-6">
          <?php echo $this->Form->button('Search',array('id'=>'submitTransaction','class'=>'btn'));?>
        </div>
        <div class="col-sm-6">
          <?php echo $this->Form->button('Clear', array('type'=>'reset','id'=>'reset','class'=>'btn')); ?>
        </div>
      </div>
    </div>
  </div>
</div>