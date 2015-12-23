<div class="profile-sec">
    <div class="clearfix customer-pro-img">
        <div class="profile-img mrgn-btm10 customer-pro imageView">
                        <?php
                            $editUserAuth = false;
                            if(isset($user) && !empty($user))
                            {
                                if($auth_user['User']['type'] == 1)
                                {
                                    $editUserAuth = 'admin';
                                    if($user['User']['is_email_verified'] == 1 && $user['User']['is_phone_verified'] == 1 )
                                    {
                                        $editUserAuth = false;
                                    }
                                }
                                elseif($user['User']['created_by'] != 0 && $auth_user['User']['id'] == $user['User']['created_by'])
                                {
                                    $editUserAuth = 'created';
                                    if($user['User']['is_email_verified'] == 1 && $user['User']['is_phone_verified'] == 1 )
                                    {
                                        $editUserAuth = false;
                                    }
                                }
                            }
                        ?>
                        <?php if(isset($user) && !empty($user)){ ?>
                        <?php
                        $classforupImage = '';
                        if($editUserAuth && in_array($editUserAuth,array('admin','created'))){
                            $classforupImage = 'upUImg';
                        ?> 
                            <div class="edit-icon">
                                   <a  href="javascript:void(0);" escape="false" class="editUImg" data-id="<?php echo $user['User']['id']; ?>" >
                                       <i class="fa fa-pencil"></i>
                                   </a>  
                                <?php if(isset($user['User']['image']) && !empty($user['User']['image']) ){ 
                                    $style="display:block";
                                }else{
                                    $style="display:none"; 
                                } ?>
                                 <a  href="javascript:void(0);" escape="false" style="<?php echo $style; ?>" class="deleteUImg" data-id="<?php echo $user['User']['id']; ?>" >
                                       <i class="fa fa-trash-o"></i>
                                </a>
                           </div>
                        <?php } ?>
            
                        <?php
                        if(isset($user['User']['image']) && !empty($user['User']['image']) ){
                            echo $this->Html->image("/images/".$user['User']['id']."/User/150/".$user['User']['image'],array('data-id'=>$user['User']['id']));
                        }else{
                            echo $this->Html->image("admin/upload2.png",array('class'=>$classforupImage,'data-id'=>$user['User']['id']));
                        }?>
                    <?php
                        echo $this->Form->input('image',array('style'=>'display:none;','type'=>'file','div'=>false,'label'=>false,'id'=>'theImage'));
                    ?>
                    <?php }
                    else{
                        echo $this->Html->image("admin/upload2.png",array('class'=>' '));
                    }?>
        </div>
        <?php
             $selectedId = '';
             if(isset($user['User']['id']) && !empty($user['User']['id'])){
               $selectedId = base64_encode($user['User']['id']);
             } ?>
            
            <div class="row">
                <div class="col-sm-12">
                	<div class="test-focus" style="overflow:hidden;">
			    <?php echo $this->Form->input('id',array('tabindex' => '-1','div'=>false,'id'=>'selectUserId','options'=>$userList,'empty'=>'Please Select Customer','label'=>false,'class'=>'select2-me userSelect nopadding form-control bod-non','selected'=>$selectedId));?>
                    </div>
                </div>
                <div class="col-sm-12">
                    <?php echo $this->Form->button(__('New'),array('data-id'=>'','type'=>'button','class'=>'col-sm-12 addedit_User btn ','style'=>'float:none;'));?>
            
            <?php if(isset($user) && !empty($user)){ ?>
                
                    <?php echo $this->Form->button(__('Edit'),array('data-id'=>base64_encode($user['User']['id']),'type'=>'button','class'=>'addedit_User btn col-sm-12','style'=>'float:none;'));?>
               
                    <?php if($user['User']['is_email_verified'] != 1 && $user['User']['is_phone_verified'] != 1){
                        echo $this->Form->button(__('Delete'),array('data-id'=>base64_encode($user['User']['id']),'type'=>'button','class'=>'deleteUser btn  col-sm-12','style'=>'float:none;'));
                    }?>
            <?php } ?>
                </div>
                    <?php
                        if(isset($user) && !empty($user)){
                            if($editUserAuth && in_array($editUserAuth,array('created','admin')) ){
                             if($user['User']['tmp'] == 1){ ?>
                                <div class="col-sm-12 ">
                                <div class="customer-list-outer description">
                                <ul class="customer-info">
                                    <li>
                                        <label>Temp Username</label>
                                        <section><?php echo $user['User']['username'];?></section>
                                    </li>
                                    <li>
                                        <label>Temp Password</label>
                                        <section><?php if(!empty($user['User']['tmp_pwd'])){
                                                    echo $user['User']['tmp_pwd'];
                                                }?></section>
                                    </li>
                                </ul>
                                </div>
                                </div>
                        <?php
                            } ?>
                <div class="col-sm-12">
                    <div class="col-sm-6 nopadding">
                        <?php echo $this->Form->input('verify_phone',array('id'=>'verify_phone_code','div'=>false,'label'=>false,'placeholder'=>'Mobile Token','type'=>'text','class'=>'form-control'));?>
                    </div>
                    <div class="col-sm-6">
                      <?php echo $this->Form->button(__('Submit'),array('data-id'=>base64_encode($user['User']['id']),'type'=>'button','class'=>'no-mrgn btn mobileVbtn','style'=>'float:none;'));?>
                    </div>
                </div>
                <?php } ?>
            <?php if($editUserAuth && in_array($editUserAuth,array('created','admin')) ){ ?>
                <?php if($user['User']['is_email_verified'] != 1){ ?>
                <div class="col-sm-12">
                <?php echo $this->Form->button(__('Reset Username / Password'),array('type'=>'button','class'=>'full-w resetUnPwd btn ','data-id'=>base64_encode($user['User']['id']),'style'=>'float:none;'));?>
                </div>
                <div class="col-sm-12">
                <?php echo $this->Form->button(__('Resend Login Details'),array('data-id'=>base64_encode($user['User']['id']),'data-type'=>'loginDetail','type'=>'button','class'=>'full-w btn  resendLogin','style'=>'float:none;'));?>
                </div>
                <?php } ?>
                <?php if($user['User']['is_phone_verified'] != 1){ ?>
                <div class="col-sm-12">
                    <?php
                    if(isset($user['Contact']['cell_phone']) && !empty($user['Contact']['cell_phone'])){ ?>
                        <?php echo $this->Form->button(__('Send OTP Password'),array('data-id'=>base64_encode($user['User']['id']),'data-type'=>'otp','type'=>'button','class'=>'full-w  btn resendLogin','style'=>'float:none;'));?>
                    <?php } ?>
                </div>
                <?php } ?>
            <?php } ?>
    <?php }?>
                
            </div>
            
                </div>
		
                <div class="description">
                	<h1>Customer Profile </h1>
                    <ul class="customer-info">
                        <li>
                            <label>Username </label>
                            <section>
                                <?php
                                if(isset($user['User']['username'])){
                                    echo (!empty($user['User']['username']))? $user['User']['username'] : '--' ;
                                }else{
                                    echo '&nbsp;';
                                }?>
                            </section>                    
                        </li>
                        <li>
                            <label>First Name </label>
                            <section>
                                 <?php
                                    if(isset($user['User']['first_name'])){
                                        echo (!empty($user['User']['first_name']))? ucfirst($user['User']['first_name']) : '--' ;
                                    }else{
                                        echo '&nbsp;';
                                    }
                                ?>
                            </section>                    
                        </li>
                        <li>
                            <label>Last Name </label>
                            <section>
                                <?php
                                    if(isset($user['User']['last_name'])){
                                        echo (!empty($user['User']['last_name']))? ucfirst($user['User']['last_name']) : '--' ;
                                    }else{
                                        echo '&nbsp;';
                                    }
                                ?>
                            </section>                    
                        </li>
                         <li>
                            <label>Email </label>
                            <section>
                                <?php
                                    if(isset($user['User']['email'])){
                                        echo (!empty($user['User']['email']))? $user['User']['email'] : '--' ;
                                    }else{
                                        echo '&nbsp;';
                                    }
                                ?>
                            </section>                    
                        </li>
                        <li>
                            <label>Gender </label>
                            <section>
                                <?php
                                    if(isset($user['UserDetail']['gender'])){
                                        echo (!empty($user['UserDetail']['gender']))? ucfirst($user['UserDetail']['gender']) : '--' ;
                                    }else{
                                        echo '&nbsp;';
                                    }
                                ?>
                            </section>                    
                        </li>
                        <li>
                            <label>Marital Status </label>
                            <section>
                                <?php
                                    if(isset($user['UserDetail']['marital_status']) && !empty($user['UserDetail']['marital_status'])){
                                        echo ($user['UserDetail']['marital_status'] == 'S')? 'Single' : 'Married' ;
                                    }else{
                                        echo '&nbsp;';
                                    }
                                ?>
                            </section>                    
                        </li>
                          <?php
                        if(isset($user['UserDetail']['marital_status']) && !empty($user['UserDetail']['marital_status']) && $user['UserDetail']['marital_status'] == 'M'){ ?>
                        <li>
                            <label>Anniversary </label>
                            <section>
                                <?php
                                    if(isset($user['UserDetail']['anniversary'])){
                                        echo (!empty($user['UserDetail']['anniversary']))? date('M-d-Y',strtotime($user['UserDetail']['anniversary'])) : '--' ;
                                    }else{
                                        echo '&nbsp;';
                                    }?>
                            </section>
                        </li>
                        <li>
                        <label>Spouse DOB </label>
                        <section>
                            <?php
                                if(isset($user['UserDetail']['spouse_dob'])){
                                    echo (!empty($user['UserDetail']['spouse_dob']))? date('M-d-Y',strtotime($user['UserDetail']['spouse_dob'])) : '--' ;
                                }else{
                                    echo '&nbsp;';
                                }?>
                        </section>
                        </li>
                        <?php }
                        ?>
                        <li>
                            <label>Address </label>
                            <section>
                                <?php
                                    if(isset($user['User']['id'])){
                                        echo $this->Common->printAddress($user['User']['id']);
                                    }else{
                                        echo '&nbsp;';
                                    }?>
                            </section>
                        </li>
                        <li>
                            <label>Birthdate </label>
                            <section>
                                <?php
                                    if(isset($user['UserDetail']['dob'])){
                                        echo !empty($user['UserDetail']['dob'])? date('M-d-Y',strtotime($user['UserDetail']['dob'])) : '--' ;
                                    }else{
                                        echo '&nbsp;';
                                    }
                                ?>
                            </section>
                        </li>
                        <li>
                           <label>Mobile 1</label>
                           <section>
                              <?php
                
                                $code='+971';
                                if(isset($user['Contact']['country_code']) && !empty($user['Contact']['country_code'])){
                                 $code =  $user['Contact']['country_code'];
                                }
                                
                                 if(isset($user['Address']['country_id']) && !empty($user['Address']['country_id'])){
                                     $code = $this->Common->getPhoneCode($user['Address']['country_id']);
                                     $code  = ($code)?$code:'';
                                 }
                                 if(isset($user['Contact']['cell_phone']) && !empty($user['Contact']['cell_phone'])){
                                    echo  $code.'-'.$user['Contact']['cell_phone'];
                                 }else{
                                     echo '';
                                 }
                            ?>
                           </section>
                        </li>
                        <li>
                            <label>Mobile 2 </label>
                           <section>
                            <?php
                                 if(isset($user['Contact']['day_phone']) && !empty($user['Contact']['day_phone'])){
                                    echo  $code.'-'.$user['Contact']['day_phone'];
                                  }else{
                                     echo '';
                                 }
                            ?>
                           </section>
                        </li>
                         <li>
                           <label>Mobile 3 </label>
                           <section>
                                <?php
                                 if(isset($user['Contact']['night_phone']) && !empty($user['Contact']['night_phone'])){
                                    echo  $code.'-'.$user['Contact']['night_phone'];
                                 }else{
                                     echo '';
                                 }
                            ?>
                           </section>
                        </li>
                        <li>
                           <label>CC Appointment email to </label>
                           <section>
                                <?php
                                    if(isset($user['UserDetail']['cc_to'])){
                                      echo $this->Common->getmailaddress($user['UserDetail']['cc_to']); 
                                    }else{
                                        echo '&nbsp;';
                                    }
                                ?>
                           </section>
                        </li>
                     </ul>
                 </div>   
                 <div class="description">
                    <h1>Data </h1>
                    <ul class="customer-info">
                        <li>
                            <label>Customer Since </label>
                            <section>
                                <?php
                                    if(isset($user['User']['created'])){
                                        echo (!empty($user['User']['created']))? date('d/m/Y H:i:s',strtotime($user['User']['created'])) : '--' ;
                                    }else{
                                        echo '&nbsp;';
                                    }
                                ?>
                            </section>                    
                        </li>
                        <li>
                            <label>Last Visited </label>
                            <section>
                                <?php
                                    if(isset($user['User']['last_visited'])){
                                        echo (!empty($user['User']['last_visited']))? date('d/m/Y H:i:s',strtotime($user['User']['last_visited'])) : '--' ;
                                    }else{
                                        echo '&nbsp;';
                                    }
                                ?>
                            </section>                    
                        </li>
                        <li>
                            <label>Email Verified </label>
                            <section>
                                <?php if(isset($user['User']['is_email_verified'])){
                                    echo ($user['User']['is_email_verified'])? 'Verified' : 'Unverified' ;
                                }else{
                                    echo '&nbsp;';
                                }?>
                            </section>                    
                        </li>
                        <li>
                            <label>Mobile 1 Verified </label>
                            <section>
                                <?php if(isset($user['User']['is_phone_verified'])){
                                    echo ($user['User']['is_phone_verified'])? 'Verified' : 'Unverified' ;
                                }else{
                                    echo '&nbsp;';
                                }?>
                            </section>                    
                        </li>
                        <li>
                            <label>Total No. of Booking </label>
                            <section><?php if(isset($user['User']['id'])){ //echo $this->Common->get_user_booking_count($user['User']['id']);
                                echo $totalbooking;
                            } ?></section>                    
                        </li>
                        <li>
                            <label>Total amount paid </label>
                            <section><?php if(isset($user['User']['id'])){ //echo $this->Common->get_user_total_paid_amount($user['User']['id']);
                            echo $totalbookingamount;
				} ?></section>                    
                        </li>
                        <li>
                            <label>Points Balance :</label>
                            <section><?php if(isset($totalPoints)){ echo $totalPoints; }?></section>                    
                        </li>
                        <li>
                            <label>Cancellations in last year </label>
                            <section><?php if(isset($totalcancellation) && isset($user['User']['id'])){ echo $totalcancellation; } ?></section>                    
                        </li>
                        <li>
                            <label>#No Shows in last year </label>
                            <section><?php if(isset($totalnoShow) && isset($user['User']['id'])){ echo $totalnoShow; } ?></section>                    
                        </li>
                        <li>
                            <label>Referred By </label>
                            <section>
                                <?php
                                if(isset($user['UserDetail']['refered_by'])){
                                    echo (!empty($user['UserDetail']['refered_by']))? $user['UserDetail']['refered_by'] : '' ;
                                }else{
                                    echo '&nbsp;';
                                }?>
                            </section>                    
                        </li>
                        <li>
                            <label>General Tag </label>
                            <section>
                                <?php
                                if(isset($user['UserDetail']['tags'])){
                                    echo (!empty($user['UserDetail']['tags']))? implode(', ',unserialize($user['UserDetail']['tags'])) : '' ;
                                }else{
                                    echo '&nbsp;';
                                }?>
                            </section>                    
                        </li>
                    </ul>
                </div>
             </div>
<script>
	$(document).ready(function(){
            $('#selectUserId').select2()
                .on("open", function(e) {
                    $(document).find('.select2-drop-active').addClass('purple-bod');
                    $(document).find('a.select2-choice').addClass('purple-bod');
                    
                }).on('close', function(){
                    $(document).find('.select2-drop-active').removeClass('purple-bod');
                    $(document).find('#s2id_selectUserId').removeClass('purple-bod');
                    $(document).find('.select2-choice').removeClass('purple-bod');
            });
        });
</script>
<?php  //echo $this->Js->writeBuffer(); ?>