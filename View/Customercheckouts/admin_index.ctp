

<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Customer Details
                </h3>
            </div>
            <div class="box-content">
                <div class="row-fluid selectDiv">
                    <?php
                    $selectedId = '';
                    if(isset($user['User']['id']) && !empty($user['User']['id'])){
                        $selectedId = $user['User']['id'];
                    }
                    echo $this->Form->input('id',array('id'=>'selectUserId','options'=>$userList,'empty'=>'Please Select Customer','label'=>false,'class'=>'select2-me userSelect input-xlarge input-block-level','selected'=>$selectedId));
                    ?>
                </div>
                <br>
                <div class="row-fluid userdetails">
                   <div class="span3">
    <div class="span4">
            <p>
                <?php echo $this->Form->button(__('New'),array('data-id'=>'','type'=>'button','class'=>'span12 addedit_User btn ','style'=>'float:none;'));?>
            </p>
            <?php if(isset($user) && !empty($user)){ ?>
                <p>
                    <?php echo $this->Form->button(__('Edit'),array('data-id'=>base64_encode($user['User']['id']),'type'=>'button','class'=>'addedit_User btn span12','style'=>'float:none;'));?>
                </p>
                <p>
                    <?php if($user['User']['is_email_verified'] != 1 && $user['User']['is_phone_verified'] != 1){
                        echo $this->Form->button(__('Delete'),array('data-id'=>base64_encode($user['User']['id']),'type'=>'button','class'=>'deleteUser btn  span12','style'=>'float:none;'));
                    }?>
                </p>
            <?php } ?>
    </div> 
    
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
    
    
    <div class="span8" style="text-align: center; position: relative;">
        <?php if(isset($user) && !empty($user)){ ?>
            <?php
            $classforupImage = '';
            if($editUserAuth && in_array($editUserAuth,array('admin','created'))){
                $classforupImage = 'upUImg';
            ?> 
            <div class="editDeleteImg" style="background: none repeat scroll 0 0 #000000;left: 0;opacity: 0.5;position: absolute;top: 0;width: 100%; display: none;">
                <?php echo  $this->Html->link(__('Edit'),'javascript:void(0);',array('data-id'=>$user['User']['id'],'class'=>'editUImg','style'=>'float:left;width:50%')); ?>
                <?php echo  $this->Html->link(__('Delete'),'javascript:void(0);',array('data-id'=>$user['User']['id'],'class'=>'deleteUImg','style'=>'float:left;width:50%')); ?>
            </div>
            <?php } ?>
            <div class="imageView">
            <?php
            if(isset($user['User']['image']) && !empty($user['User']['image']) ){
                echo $this->Html->image("/images/".$user['User']['id']."/User/150/".$user['User']['image'],array('data-id'=>$user['User']['id']));
            }else{
                echo $this->Html->image("admin/upload2.png",array('class'=>$classforupImage,'data-id'=>$user['User']['id']));
            }?>
        <?php
            echo $this->Form->input('image',array('style'=>'display:none;','type'=>'file','div'=>false,'label'=>false,'id'=>'theImage'));
        ?>
        </div>
        <?php }
        else{
            echo $this->Html->image("admin/upload2.png",array('class'=>' '));
        }?>
    </div>
</div>
<div class="span3">
    <h4>
        Customer Profile
    </h4>
    <dl class="dl-horizontal">
        <dt>Username :</dt>
        <dd>
            <?php
                if(isset($user['User']['username'])){
                    echo (!empty($user['User']['username']))? $user['User']['username'] : '--' ;
                }else{
                    echo '&nbsp;';
                }?>
        </dd>
        <dt>First Name :</dt>
        <dd>
            <?php
                if(isset($user['User']['first_name'])){
                    echo (!empty($user['User']['first_name']))? ucfirst($user['User']['first_name']) : '--' ;
                }else{
                    echo '&nbsp;';
                }?>
        </dd>
        <dt>Last Name : </dt>
        <dd>
            <?php
                if(isset($user['User']['last_name'])){
                    echo (!empty($user['User']['last_name']))? ucfirst($user['User']['last_name']) : '--' ;
                }else{
                    echo '&nbsp;';
                }?>
        </dd>
        <dt>Email :</dt>
        <dd>
            <?php
                if(isset($user['User']['email'])){
                    echo (!empty($user['User']['email']))? $user['User']['email'] : '--' ;
                }else{
                    echo '&nbsp;';
                }?>
        </dd>
        <dt>Gender :</dt>
        <dd>
            <?php
                if(isset($user['UserDetail']['gender'])){
                    echo (!empty($user['UserDetail']['gender']))? ucfirst($user['UserDetail']['gender']) : '--' ;
                }else{
                    echo '&nbsp;';
                }?>
        </dd>
        <dt>Maritial Status :</dt>
        <dd>
            <?php
                if(isset($user['UserDetail']['marital_status']) && !empty($user['UserDetail']['marital_status'])){
                    echo ($user['UserDetail']['marital_status'] == 'S')? 'Single' : 'Married' ;
                }else{
                    echo '&nbsp;';
                }?>
        </dd>
        <?php
        if(isset($user['UserDetail']['marital_status']) && !empty($user['UserDetail']['marital_status']) && $user['UserDetail']['marital_status'] == 'M'){ ?>
        <dt>Anniversary:</dt>
        <dd>
            <?php
                if(isset($user['UserDetail']['anniversary'])){
                    echo (!empty($user['UserDetail']['anniversary']))? date('M-d-Y',strtotime($user['UserDetail']['anniversary'])) : '--' ;
                }else{
                    echo '&nbsp;';
                }?>
        </dd>
        <dt>Spouse DOB :</dt>
        <dd>
            <?php
                if(isset($user['UserDetail']['spouse_dob'])){
                    echo (!empty($user['UserDetail']['spouse_dob']))? date('M-d-Y',strtotime($user['UserDetail']['spouse_dob'])) : '--' ;
                }else{
                    echo '&nbsp;';
                }?>
        </dd>
        <?php }
        ?>
        <dt>Address :</dt>
        <dd>
            <?php
                if(isset($user['User']['id'])){
                    echo $this->Common->printAddress($user['User']['id']);
                }else{
                    echo '&nbsp;';
                }?>
        </dd>
        <dt>Birthdate :</dt>
        <dd>
            <?php
                if(isset($user['UserDetail']['dob'])){
                    echo !empty($user['UserDetail']['dob'])? date('M-d-Y',strtotime($user['UserDetail']['dob'])) : '--' ;
                }else{
                    echo '&nbsp;';
                }?>
                </dd>
        <dt>Mobile :</dt>
        <dd>
            <?php
                if(isset($user['Contact']['cell_phone'])){
                    echo (!empty($user['Contact']['cell_phone']))? $user['Contact']['cell_phone'] : '--' ;
                }else{
                    echo '&nbsp;';
                }?>
        </dd>
        <dt>Phone 1 :</dt>
        <dd>
            <?php
                if(isset($user['Contact']['day_phone'])){
                    echo (!empty($user['Contact']['day_phone']))? $user['Contact']['day_phone'] : '--' ;
                }else{
                    echo '&nbsp;';
                }?>
        </dd>
        <dt>Phone 2 :</dt>
        <dd><?php
                if(isset($user['Contact']['night_phone'])){
                    echo (!empty($user['Contact']['night_phone']))? $user['Contact']['night_phone'] : '--' ;
                }else{
                    echo '&nbsp;';
                }?>
        </dd>
        <dt>CC emails to :</dt>
        <dd><?php
                if(isset($user['UserDetail']['cc_to'])){
                    echo (!empty($user['UserDetail']['cc_to']))? $this->Common->printEmailId($user['UserDetail']['cc_to']) : '--' ;
                }else{
                    echo '&nbsp;';
                }?>
        </dd>
    </dl>
</div>
<div class="span3">
    <h4>
        Data
    </h4>
    <style>
        .hh dt{ white-space:pre-wrap; }
    </style>
    <dl class="dl-horizontal hh" >
        <dt>Customer Since :</dt>
        <dd>
            <?php
                if(isset($user['User']['created'])){
                    echo (!empty($user['User']['created']))? $user['User']['created'] : '--' ;
                }else{
                    echo '&nbsp;';
                }?>
                </dd>
        <dt>Last Visted :</dt>
        <dd><?php
                if(isset($user['User']['last_visited'])){
                    echo (!empty($user['User']['last_visited']))? $user['User']['last_visited'] : '--' ;
                }else{
                    echo '&nbsp;';
                }?>
        </dd>
        <dt>Email Verfied :</dt>
        <dd><?php if(isset($user['User']['is_email_verified'])){
                    echo ($user['User']['is_email_verified'])? 'Verified' : 'Unverified' ;
                }else{
                    echo '&nbsp;';
                }?>
        </dd>
        <dt>Phone Verified :</dt>
        <dd><?php if(isset($user['User']['is_phone_verified'])){
                    echo ($user['User']['is_phone_verified'])? 'Verified' : 'Unverified' ;
                }else{
                    echo '&nbsp;';
                }?>
        </dd>
        <dt>Total No. of Booking :</dt>
        <dd>&nbsp;</dd>
        <dt>Total amount paid :</dt>
        <dd>&nbsp;</dd>
        <dt>Points Balance :</dt>
        <dd>&nbsp;</dd>
        <dt>Cancellations last yr :</dt>
        <dd>&nbsp;</dd>
        <dt>#No Shows in last yr :</dt>
        <dd>&nbsp;</dd>
        <dt>Referred By :</dt>
        <dd>
            <?php
                if(isset($user['UserDetail']['refered_by'])){
                    echo (!empty($user['UserDetail']['refered_by']))? $user['UserDetail']['refered_by'] : '--' ;
                }else{
                    echo '&nbsp;';
                }?>
        </dd>
        <dt>General Tag :</dt>
        <dd>
            <?php
                if(isset($user['UserDetail']['tags'])){
                    echo (!empty($user['UserDetail']['tags']))? implode(', ',unserialize($user['UserDetail']['tags'])) : '--' ;
                }else{
                    echo '&nbsp;';
                }?>
        </dd>
    </dl>
</div>
<div class="span3">
    <?php
    if(isset($user) && !empty($user)){
       
        if($editUserAuth && in_array($editUserAuth,array('created','admin')) ){
         if($user['User']['tmp'] == 1){ ?>
            <dl class="dl-horizontal">
                <dt>Temp Username</dt>
                <dd><?php echo $user['User']['username'];?></dd>
                <dt>Temp Password</dt>
                <dd>
                    <?php if(!empty($user['User']['tmp_pwd'])){
                                echo $user['User']['tmp_pwd'];
                            }?>
                </dd>
            </dl>
    <?php
        } ?>
            <div class="span12 row-fluid">
                <div class="span8">
                    <?php echo $this->Form->input('verify_phone',array('id'=>'verify_phone_code','label'=>false,'placeholder'=>'Mobile Token','type'=>'text','class'=>'input-xlarge input-block-level'));?>
                </div>
                <div class="span4">
                    <?php echo $this->Form->button(__('Submit'),array('data-id'=>base64_encode($user['User']['id']),'type'=>'button','class'=>'btn mobileVbtn span12','style'=>'float:none;'));?>
                </div>
                
            </div> 
        <?php } ?>
        <div class="span12">
            <?php if($editUserAuth && in_array($editUserAuth,array('created','admin')) ){ ?>
            <p>
                <?php echo $this->Form->button(__('Reset Username / Password'),array('type'=>'button','class'=>'span12 resetUnPwd btn ','data-id'=>base64_encode($user['User']['id']),'style'=>'float:none;'));?>
            </p>
            <p>
                <?php echo $this->Form->button(__('Resend Login Details'),array('data-id'=>base64_encode($user['User']['id']),'data-type'=>'loginDetail','type'=>'button','class'=>'span12  btn  resendLogin','style'=>'float:none;'));?>
            </p>
            <p>
                <?php echo $this->Form->button(__('Send OTP Password'),array('data-id'=>base64_encode($user['User']['id']),'data-type'=>'otp','type'=>'button','class'=>'span12  btn resendLogin','style'=>'float:none;'));?>
            </p>
            <?php } ?>
        </div>
    <?php }?>
</div>

                </div>
                
            </div>
        </div>
    </div>
</div>
