<?php
$formControl='';
  if($addClass){
    $formControl = 'form-control';
  }
?>
<label class="control-label <?php echo  (!empty($addClass) && ($addClass=='addClass')) ? 'col-sm-3' :''; ?>">City <span class="red">*</span></label>
<div class="<?php echo  (!empty($addClass) && ($addClass=='addClass')) ? 'col-sm-7' :''; ?>">
  <?php echo $this->Form->input('Address.state_id',array('class'=>$formControl,'empty'=>'Please Select','div'=>false,'options'=>$selectbox,'label'=>false,'required','validationMessage'=>"Please select city."));?>
</div>
                   
            