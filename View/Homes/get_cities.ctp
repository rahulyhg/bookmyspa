
<?php
$formControl='';
  if($addClass){
    $formControl = 'form-control';
  }
?>
<label class="control-label <?php echo  (!empty($addClass) && ($addClass=='addClass')) ? 'col-sm-3' :''; ?>">Location/Area <span class="red">*</span></label>
<div class="<?php echo  (!empty($addClass) && ($addClass=='addClass')) ? 'col-sm-7' :''; ?>">
   <?php echo $this->Form->input('Address.city_id',array('class'=>$formControl,'empty'=>'Please Select','div'=>false,'options'=>$cities,'label'=>false,'required','validationMessage'=>"Please select Location/Area."));?>
</div>
                   
           
                   
            