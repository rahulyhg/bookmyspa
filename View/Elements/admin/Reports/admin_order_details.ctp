	<div class="modal-dialog vendor-setting sm-vendor-setting">
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h2 class="no-mrgn">Order Details</h2>
	    </div>
	    <div class="modal-body clearfix">
		<div class="row">
		    <div class="col-sm-12">
			<div class="box">
			<?php
			        $availed = true;
				if($Order['Order']['order_avail_status'] !=1  && ($Order['Order']['service_type'] !=6 && $Order['Order']['service_type'] !=7)){
					$availed = false;
				}
			?>
				<div class="box-content">
				    <div class="row">
					<div class="col-sm-12">
						<div class="form-group clearfix">
						      <label class="control-label col-sm-5">Sieasta Order ID  :</label>
						    
							  <?php echo  @$Order['Order']['display_order_id'];?>
						      
						</div>
						<div class="form-group clearfix">
						      <label class="control-label col-sm-5">Customer Name :</label>
						    
							  <?php echo  @$Order['Order']['first_name'].' '.@$Order['Order']['last_name'];?>
						      
						</div>
						<?php if(!is_null($Order['Order']['salon_id'])) { ?>
						<div class="form-group clearfix">
						      <label class="control-label col-sm-5">Salon Name :</label>
						    
							  <?php echo  $this->Common->get_salon_name($Order['Order']['salon_id']);?>
						      
						</div>
						<?php }?>
						<?php if(isset($Order['Order']['transaction_id']) && !empty($Order['Order']['transaction_id'])){?>
						<div class="form-group">
						    <label class="control-label col-sm-5">CC Avenue Transaction ID :</label>
						   
							 <?php echo  @$Order['Order']['transaction_id'];?>
						    
						</div>
						<?php }?>
						<div class="form-group clearfix">
							<label class="control-label col-sm-5">Service Type:</label>
							<?php
								$serviceType = $Order['Order']['service_type'];
								switch ($serviceType) {
									case 1: echo 'Service';
											 break;
									case 2: echo 'Package';
											break;
									case 3: echo 'Spaday';
											break;
									case 4: echo 'Spabreak';
											break;
									case 5: echo 'Deal';
											break;
									case 6: echo 'Gift Certificate';
											break;
									case 7: echo 'E-Voucher';
											break;
								}	
							
							?>
						</div>
						<?php if($serviceType == 1) {
							if(!is_null($Order['Order']['employee_id'])){
								?>
								<div class="form-group clearfix">
								<label class="control-label col-sm-5">Service Provider:</label>
									<?php
										if(count($Order['Appointment'])){
											echo $this->Common->get_user_name($Order['Appointment'][0]['salon_staff_id']);	
										}else{
											echo $this->Common->get_user_name($Order['Order']['employee_id']);	
										}
										
										
									?>
								</div>		
							<?php }
							if(!is_null($Order['Order']['start_date'])){
								?>
								<div class="form-group clearfix">
								<label class="control-label col-sm-5">Start Date:</label>
									<?php
										if(count($Order['Appointment'])){
											echo date(DATE_FORMAT , $Order['Appointment'][0]['appointment_start_date']);	
										}else{
											echo $Order['Order']['start_date'];
										}
									?>
								</div>		
							<?php }
							if(!is_null($Order['Order']['time'])){
								?>
								<div class="form-group clearfix">
								<label class="control-label col-sm-5">Time:</label>
									<?php
										if(count($Order['Appointment'])){
											echo date('h:i A' , $Order['Appointment']['0']['appointment_start_date']);
										}else{
											echo $Order['Order']['time'];
										}
									?>
								</div>		
							<?php } 
						 } ?>
						<?php if($serviceType == 2 || $serviceType == 3 || $serviceType == 5) {
							if(isset($Order['OrderDetail']) && !empty($Order['OrderDetail'])){
								//pr($Order['OrderDetail']);
								?>
								<div class="form-group clearfix">
								<label class="control-label col-sm-5">Services Included:</label>
									<div class="col-sm-7 pdng-lft-rgt-non">
										<?php
										  if(count($Order['Appointment'])){
											foreach($Order['Appointment'] as $details){
												echo "--------------------------------</br>";
												echo "<b>Service:</b>".$details['appointment_title']."</br>";
												echo "<b>Service Provider:</b>".$this->Common->get_user_name($details['salon_staff_id']).'</br>';
												echo "<b>Start Date:</b>".date(DATE_FORMAT , $details['appointment_start_date']).'</br>';
												echo "<b>Time:</b>".date('h:i A' , $details['appointment_start_date']).'</br>';
											}
										}else{
											foreach($Order['OrderDetail'] as $details){
												echo "--------------------------------</br>";
												echo "<b>Service:</b>".$details['eng_service_name']."</br>";
												echo "<b>Service Provider:</b>".$this->Common->get_user_name($details['employee_id']).'</br>';
												echo "<b>Start Date:</b>".$details['start_date'].'</br>';
												echo "<b>Time:</b>".$details['time'].'</br>';
											}
										}
										?>
									</div>
								</div>		
							<?php }  }
							if($serviceType == 3){ ?>
								<div class="form-group clearfix">
								<label class="control-label col-sm-5">Check In:</label>
									<?php
										echo $Order['Order']['check_in'];
									?>
								</div>
								<div class="form-group clearfix">
								<label class="control-label col-sm-5">Check Out:</label>
									<?php
										echo $Order['Order']['check_out'];
									?>
								</div>
							<?php }?>
					<?php if($serviceType == 7){ ?>
								<div class="form-group clearfix">
								<label class="control-label col-sm-5">Voucher Code:</label>
									<?php
										echo $Order['Evoucher'][0]['vocher_code'];
									?>
								</div>
					<?php } ?>
							
						<div class="form-group clearfix">
							<label class="control-label col-sm-5">Transaction Status:</label>
							<?php
								$transactionType = $Order['Order']['transaction_status'];
								switch ($transactionType) {
											case 1: echo 'Paid';
													 break;
											case 2: echo 'Aborted';
													break;
											case 3: echo 'Failed';
													break;
											case 4: echo 'Illegal';
													break;
											case 5: echo 'Payment using Points';
													break;
											case 6: echo 'Payment using Gift Certificate';
													break;
											case 7: echo 'Payment using Gift Cetrtificate and CC Avenue';
													break;
											case 8: echo 'Payment using Points and CC Avenue';
													break;
											case 9: echo 'Transaction Cancelled';
													break;
											}	
							
							?>
						</div>
						<div class="form-group clearfix">
							<label class="control-label col-sm-5">Sale Amount with tax (AED)</label>
							<?php echo $Order['Order']['service_price_with_tax'];?>
						</div>
						
						 <div class="form-group clearfix">
							<label class="control-label col-sm-5">Sieasta Commission (AED)</label>
							<?php
								if($availed){
									echo $Order['Order']['sieasta_commision_amount'];
								}else{
									echo '-';
								}
							?>
						</div>
						<div class="form-group clearfix">
							<label class="control-label col-sm-5">Tax Deduction (AED)</label>
							<?php
								if($availed){
									echo $Order['Order']['tax_amount'];
								}else{
									echo '-';
								}
							?>
						</div>
						<div class="form-group clearfix">
							<label class="control-label col-sm-5">Credit card Commission (AED)</label>
								<?php
									if($availed){
										echo $Order['Order']['total_deductions'];
									}else{
										echo '-';
									}
								?>
						</div>
						<div class="form-group clearfix">
							<label class="control-label col-sm-5">Pay to Salon (AED)</label>
							<?php
								if($availed){
									echo $Order['Order']['vendor_dues'];
								}else{
									echo '-';
								}
							?>
						</div>
						
					</div>
				   
				    </div>    
				</div>
			</div>
		    </div>
		</div>
            
	    </div>
	</div>
</div>
	
