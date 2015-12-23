<?php
echo $this->Html->css('admin/plugins/select2/select2');
echo $this->Html->script('admin/plugins/select2/select2.min');
echo $this->Html->script('checkout/checkout'); ?>
<?php //pr($userList); die; ?>
<?php  $userList1= $this->Session->read('userList');
if(isset($userList1) && !empty($userList1)){
     $userList=$userList1;
     
}
?>
<div id="customer-detail" >
    <div class="form-group clearfix"></div>
		<div class="col-sm-8">
			<label class="control-label"><b>Customer:</b></label>
			<?php
			$selected_user_id = $this->Session->read('selected_user_id');
			$allproductData = $this->Session->read('allproductData');
			$selectedId = '';
			if(!empty($selected_user_id) && (!empty($allproductData) || !empty($allGiftCertificate) || !empty($serviceData))){
				$selectedId = base64_encode($selected_user_id);
			}elseif(isset($userId) && !empty($userId)){
				$selectedId = base64_encode($userId);
			}
		    echo $this->Form->input('Appointment.user_id',array('div'=>false,'options'=>$userList,'empty'=>'Please Select Customer','label'=>false,'class'=>'select2-me userSelect nopadding mrgn-btm10 form-control bod-non','required','validationMessage'=>'Please Select Customer','selected'=>$selectedId));
			$salon_id = '';
			if(isset($userAppointments[0]['Appointment']['salon_id']) && !empty($userAppointments[0]['Appointment']['salon_id'])){
				$salon_id = $userAppointments[0]['Appointment']['salon_id'];
			}
			echo $this->Form->input("Appointment.salon_id",array('value'=>$salon_id,'class'=>'salon_id','type'=> 'hidden'));
			?>
			<div class='col-xs-5 cst_event'>
                <?php
                $editUserAuth = false;
                if(isset($user) && !empty($user)){
                    if($auth_user['User']['type'] == 1){
                        $editUserAuth = 'admin';
                        if($user['User']['is_email_verified'] == 1 || $user['User']['is_phone_verified'] == 1 ){
                            $editUserAuth = false;
                        }
                    }elseif($user['User']['created_by'] != 0 && $auth_user['User']['id'] == $user['User']['created_by']){
                        $editUserAuth = 'created';
                        if($user['User']['is_email_verified'] == 1 || $user['User']['is_phone_verified'] == 1 ){
                            $editUserAuth = false;
                        }
                    }
                }
                ?>
                <?php if(isset($user) && !empty($user)){ 
                $classforupImage = '';
                if($editUserAuth && in_array($editUserAuth,array('admin','created'))){
                    $classforupImage = 'upUImg';
                } 
                if(isset($user['User']['image']) && !empty($user['User']['image']) ){
                    echo $this->Html->image("/images/".$user['User']['id']."/User/150/".$user['User']['image'],array('data-id'=>$user['User']['id'],'width'=>'100px','height'=>'100px'));
                }else{
                    echo $this->Html->image("admin/upload2.png",array('class'=>$classforupImage,'data-id'=>$user['User']['id'],'width'=>'100px','height'=>'100px'));
                }?>
				<?php
                    echo $this->Form->input('image',array('style'=>'display:none;','type'=>'file','div'=>false,'label'=>false,'id'=>'theImage'));
                }else{
					echo $this->Html->image("admin/upload2.png",array('class'=>' '));
                } ?>
            </div>
			<div class='col-xs-7 lft-p-non'>
				<label class="control-label col-xs-12 nopadding">Email -
					<?php
					if(isset($user['User']['email'])){
					    echo (!empty($user['User']['email']))? $user['User']['email'] : '--' ;
					}else{
					    echo '&nbsp;';
					} ?>
				</label>
				<label class="control-label col-xs-12 nopadding">Phone - <?php if(isset($user['Contact']['cell_phone'])) { echo $user['Contact']['day_phone']; }?></label>
				<label class="control-label col-xs-12 nopadding">Mobile 1 - <?php if(isset($user['Contact']['day_phone'])) { echo $user['Contact']['country_code'].'-'.$user['Contact']['cell_phone']; }?></label>
				<label class="control-label col-xs-12 nopadding">Mobile 2 - <?php if(isset($user['Contact']['night_phone'])) { echo $user['Contact']['night_phone']; }?></label>
				<label class="control-label col-xs-12 nopadding">Customer Since - <?php if(isset($user['User']['created'])) { echo date('d M,Y',strtotime($user['User']['created'])); }?></label>
				<label class="control-label col-xs-12 nopadding">Last visited - <?php if(isset($user['User']['last_visited'])) { echo date('d M,Y',strtotime($user['User']['last_visited'])); }?></label>
				<label class="control-label col-xs-12 nopadding">Current point balance - <?php if(isset($user['User']['last_visited'])) { echo $totalPoints;
				   }?></label>
				<label class="control-label col-xs-12 nopadding">No Show - <?php echo $totalnoShow; ?></label>
			    <label class="control-label col-xs-12 nopadding">Cancelation - <?php echo $totalcancellation; ?></label>
			</div>  
		</div>
		<?php $user = $this->Common->get_customer_details($userId); ?>
		<div class="col-sm-4 top26">
			<div class='col-sm-12 lft-p-non mrgn-btm10'>
				<?php echo $this->Form->button(__('New'),array('data-id'=>'','type'=>'button','class'=>' addeditUser btn btn-primary form-control','style'=>'float:none;'));?>
			</div>
			<div class='col-sm-12 lft-p-non mrgn-btm10'>
			    <?php //if(isset($user) && !empty($user)){ //echo '<pre>';
			    if(isset($user) && !empty($user)){
				   $userId=base64_encode($user['User']['id']);
			    }
			    
			    //print_r($userId); die; ?>
			    <?php echo $this->Form->button(__('Edit'),array('data-id'=>base64_encode($userId),'type'=>'button','class'=>'addeditUser btn btn-primary form-control','style'=>'float:none;'));?>
				<?php //} ?>
			</div>
			<div class='col-sm-12 lft-p-non mrgn-btm10'>
                <?php
                //if(isset($user) && !empty($user)){
                    echo $this->Form->button('Note',array('user-id'=>base64_encode($userId),'type'=>'button','class'=>'btn btn-primary form-control CustomerHistory','label'=>false,'div'=>false));
                //}
                ?>
            </div>
            <div class='col-sm-12 lft-p-non mrgn-btm10' id = "history_button">
            <?php
               // if(isset($user) && !empty($user)){
                    echo $this->Form->button('History',array('user-id'=>base64_encode($userId),'type'=>'button','class'=>'btn btn-primary form-control CustomerHistory','label'=>false,'div'=>false));
                //}
            ?>
            </div>
		</div>  
    </div>
<style>
     .top26{margin-top:26px !important;}
     .apptmtDetail [type="radio"]:not(:checked) + label.new-chk, .apptmtDetail [type="radio"]:checked + label.new-chk{padding-left: 21px;}
</style>
<script>
	 $(document).ready(function() {
	 $("#AppointmentUserId").select2();
	 });
</script>