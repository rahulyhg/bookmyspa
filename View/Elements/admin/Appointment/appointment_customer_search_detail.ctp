<?php
echo $this->Html->css('admin/plugins/select2/select2');
echo $this->Html->script('admin/plugins/select2/select2.min');
?>
<div id="customer-detail" >
     <div class="form-group clearfix">
        <label class="control-label"><b>Customer:</b></label>
        <?php $selectedId = '';
            if(isset($user['User']['id']) && !empty($user['User']['id'])){
                //pr($user); die;
                $selectedId = base64_encode($user['User']['id']);
        } ?>
        <?php echo $this->Form->input('Appointment.user_id',array('div'=>false,'options'=>$userList,'empty'=>'Please Select Customer','label'=>false,'class'=>'select2-me userSelect nopadding form-control bod-non','required','validationMessage'=>'Please Select Customer','selected'=>$selectedId));?>
    </div>
    <div class="form-group clearfix">
        <div class='col-sm-6 lft-p-non'>
            <?php echo $this->Form->button(__('New'),array('data-id'=>'','type'=>'button','class'=>' addeditUser btn btn-primary form-control','style'=>'float:none;'));?>
            
        </div>
        <div class='col-sm-6 lft-p-non'>
            <?php if(isset($user) && !empty($user)){ //echo '<pre>'; print_r($user); ?>
            <?php echo $this->Form->button(__('Edit'),array('data-id'=>base64_encode($user['User']['id']),'type'=>'button','class'=>'addeditUser btn btn-primary form-control','style'=>'float:none;'));?>
               
            <?php } ?>
        </div>
    </div>    
   
    <div class="form-group clearfix">
        <div class='col-sm-6'>
            <div class="profile-img mrgn-btm10 customer-pro imageView">
                        <?php
                            $editUserAuth = false;
                            if(isset($user) && !empty($user)){
                                if($auth_user['User']['type'] == 1){
                                    $editUserAuth = 'admin';
                                    if($user['User']['is_email_verified'] == 1 || $user['User']['is_phone_verified'] == 1 ){
                                        $editUserAuth = false;
                                    }
                                }
                                elseif($user['User']['created_by'] != 0 && $auth_user['User']['id'] == $user['User']['created_by']){
                                    $editUserAuth = 'created';
                                    if($user['User']['is_email_verified'] == 1 || $user['User']['is_phone_verified'] == 1 ){
                                        $editUserAuth = false;
                                    }
                                }
                            }
                        ?>
                        
            </div>
        </div>
        
    </div>
   
</div>
<script>
     var select = $('#AppointmentUserId').select2();
</script>
  
