  <?php
    
    if(!empty($type)){
      if($type == 'spabreak'){
        $type = "SpabreakListedOnline"; 
      }else if($type == 'deal'){
       $type = "Deal"; 
      }else{
       $type = "SalonServiceDetail";
      }
    }else{
      $type = "SalonServiceDetail";
    }
    
   if($value == 1) {?>
    <div class="date">
         <?php echo $this->Form->input($type.'.listed_online_start', array('type' => 'text','validationmessage'=>'Valid start date is required.','data-type'=>'date', 'required'=>true,'label' => false, 'div' => false, 'class' => 'datepicker datepickerStart' ,'value'=>'')); ?>
     </div>
    <?php } else if($value == 2) {?>
        <div class="date" id="toOnline">
           <?php echo $this->Form->input($type.'.listed_online_end', array('type' => 'text','data-type'=>'date', 'label' => false, 'div' => false, 'class' => 'datepicker datepickerEnd','required'=>true,'validationmessage'=>'Valid end date is required.','data-greaterdate-field'=>"data[$type][listed_online_start]", 'data-greaterdate-msg'=>'End date should be greater than start date.','value'=>'' )); ?> 
        </div>
    <?php }else if($value== 3) {?>
     <div class="date">
         <?php echo $this->Form->input($type.'.listed_online_start', array('type' => 'text','validationmessage'=>'Valid start date is required.','data-type'=>'date','required'=>true, 'label' => false, 'div' => false, 'class' => 'datepicker datepickerStart','value'=>'')); ?>
     </div>
    <div class="to">
             &nbsp;to
    </div>
     <div class="date">
           <?php echo $this->Form->input($type.'.listed_online_end', array('type' => 'text','data-type'=>'date', 'label' => false, 'div' => false, 'class' => 'datepicker datepickerEnd','required'=>true,'validationmessage'=>'Valid end date is required.','data-greaterdate-field'=>"data[$type][listed_online_start]", 'data-greaterdate-msg'=>'End date should be greater than start date.','value'=>'' )); ?> 
        </div>
    <?php }else{?><?php }?>
    
  