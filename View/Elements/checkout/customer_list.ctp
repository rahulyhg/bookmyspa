
        <label class="control-label"><b>Customer:</b></label>
        <?php $selectedId = '';
            if(isset($userId) && !empty($userId)){
                $selectedId = base64_encode($userId);
				
        }?>
		<?php
		
		echo $this->Form->input('Appointment.user_id',array('div'=>false,'options'=>$userList,'empty'=>'Please Select Customer','label'=>false,'class'=>'select2-me userSelect nopadding mrgn-btm10 form-control bod-non','required','validationMessage'=>'Please Select Customer','selected'=>$selectedId));?>