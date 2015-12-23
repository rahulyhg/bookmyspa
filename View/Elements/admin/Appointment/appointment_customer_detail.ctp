
<div id="customer-detail" >
     <div class="form-group clearfix">
        <label class="control-label"><b>Customer:</b></label>
        <?php $selectedId = '';
            if(isset($user['User']['id']) && !empty($user['User']['id'])){
                $selectedId = base64_encode($user['User']['id']);
        } ?>
        <?php
            //if(isset($edit_appointment['Appointment']['user_id']) && !empty($edit_appointment['Appointment']['salon_staff_id'])){
           // $selectedId = base64_encode($edit_appointment['Appointment']['salon_staff_id']);
        //}
        ?>
        <?php echo $this->Form->input('Appointment.user_id',array('div'=>false,'options'=>$userList,'empty'=>'Please Select Customer','label'=>false,'class'=>'select2-me userSelect nopadding form-control bod-non','required','validationMessage'=>'Please Select Customer','selected'=>$selectedId));?>
    </div>
    <div class="form-group clearfix">
        <div class='col-sm-12 col-md-6 lft-p-non mrgn-btm10'>
            <?php //echo $this->Form->button('New',array('type'=>'button','class'=>'btn btn-primary form-control','label'=>false,'div'=>false));?>
            
            <?php echo $this->Form->button(__('New'),array('data-id'=>'','type'=>'button','class'=>' addeditUser btn btn-primary form-control','style'=>'float:none;'));?>
            
        </div>
        <div class='col-sm-12 col-md-6 lft-p-non'>
            <?php if(isset($user) && !empty($user)){ //echo '<pre>'; print_r($user); ?>
            <?php echo $this->Form->button(__('Edit'),array('data-id'=>base64_encode($user['User']['id']),'type'=>'button','class'=>'addeditUser btn btn-primary form-control','style'=>'float:none;'));?>
               
            <?php } ?>
        </div>
    </div>    
   
    <div class="form-group clearfix">
        <div class='col-sm-12 col-md-6'>
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
                        <?php if(isset($user) && !empty($user)){ ?>
                        <?php
                        $classforupImage = '';
                        if($editUserAuth && in_array($editUserAuth,array('admin','created'))){
                            $classforupImage = 'upUImg';
                        ?> 
                        <?php } ?>
            
                        <?php
                        if(isset($user['User']['image']) && !empty($user['User']['image']) ){
                            //$customer_image = $user['User']['image'];
                            //if(file_exists($_SERVER['HTTP_HOST']."/".$temp[1]."/images/".$user['User']['id']."/User/150/".$customer_image)){
                                echo $this->Html->image("/images/".$user['User']['id']."/User/150/".$user['User']['image'],array('data-id'=>$user['User']['id'],'width'=>'100px','height'=>'100px'));
                                
                           // }
                        }else{
                            echo $this->Html->image("admin/upload2.png",array('class'=>$classforupImage,'data-id'=>$user['User']['id'],'width'=>'100px','height'=>'100px'));
                        }?>
                    <?php
                        echo $this->Form->input('image',array('style'=>'display:none;','type'=>'file','div'=>false,'label'=>false,'id'=>'theImage'));
                    ?>
                    <?php }
                    else{
                        echo $this->Html->image("admin/upload2.png",array('class'=>' '));
                    }?>
            </div>
        </div>
        <div class='col-sm-12 col-md-6 lft-p-non'>
            <div class='col-sm-12 lft-p-non rgt-p-non mrgn-btm10'>
                 <?php
                    if(isset($user) && !empty($user)){
                        echo $this->Form->button('Note',array('user-id'=>base64_encode($user['User']['id']),'type'=>'button','class'=>'btn btn-primary form-control CustomerHistory','label'=>false,'div'=>false,'note_tab_active' => 1));
                    }
                ?>
            </div>
            <div class='col-sm-12 lft-p-non rgt-p-non mrgn-btm10' id = "history_button">
            <?php
                if(isset($user) && !empty($user)){
                    echo $this->Form->button('History',array('user-id'=>base64_encode($user['User']['id']),'type'=>'button','class'=>'btn btn-primary form-control CustomerHistory','label'=>false,'div'=>false,'note_tab_active' => 0));
                }
            ?>
            </div>
        </div>
    </div>
    <div class="form-group clearfix">
        <label class="control-label col-sm-4">Email:</label>
        <div class="col-sm-8">
            <?php
                if(isset($user['User']['email'])){
                    echo (!empty($user['User']['email']))? $user['User']['email'] : '--' ;
                }else{
                    echo '&nbsp;';
                } ?>
        
        
        <?php //if(isset($user['User']['email'])) { echo $user['User']['email']; }?>
        </div>
    </div>
    <div class="form-group clearfix">
        <label class="control-label col-sm-4">Phone:</label>
        <div class="col-sm-8"><?php if(isset($user['Contact']['cell_phone'])) { echo $user['Contact']['day_phone']; }?></div>
    </div>
    <div class="form-group clearfix">
        <label class="control-label col-sm-4">Mobile 1:</label>
        <div class="col-sm-8"><?php if(isset($user['Contact']['day_phone'])) { echo $user['Contact']['country_code'].'-'.$user['Contact']['cell_phone']; }?></div>
    </div>
    <div class="form-group clearfix">
        <label class="control-label col-sm-4">Mobile 2:</label>
        <div class="col-sm-8"><?php if(isset($user['Contact']['night_phone'])) { echo $user['Contact']['night_phone']; }?></div>
    </div>
    
    <div class="form-group clearfix">
        <div class="col-sm-6">
        <label class="control-label col-sm-6 nopadding">No Show:</label>
        <div class=" col-sm-6 ">
        <?php
            //if(isset($no_show) && !empty($no_show)){
              //  echo $no_show;
           // }
           // else{
             //   echo 0;
            //}
            if(isset($totalnoShow)){
                echo  $totalnoShow;
            }else{
                echo 0;
            }
        ?>
        </div>
        </div>
        <div class="col-sm-6 nopadding">
        <label class="control-label col-sm-6 nopadding">Cancellation:</label>
        <div class=" col-sm-6 ">
        <?php
            //if(isset($cancelled) && !empty($cancelled)){
              //  echo $cancelled;
            //}
            //else{
              //  echo 0;
            //}
            if(isset($totalcancellation)){
                echo  $totalcancellation;
            }else{
                echo 0;
            }
        ?></div>
        </div>
    </div>
</div>
  
