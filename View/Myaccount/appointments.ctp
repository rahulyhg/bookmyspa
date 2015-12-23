						<style>
						    a{
							text-decoration: none !important;
						    }
						</style>
						
						<?php $lang =  Configure::read('Config.language'); ?>
						<?php
						    $this->Paginator->options(array(
							    'update' => '#update_ajax',
							    'evalScripts' => true,
							    'before' => $this->Js->get('#paginated-content-container')->effect('fadeIn', array('buffer' => false)),
							    'success' => $this->Js->get('#paginated-content-container')->effect('fadeOut', array('buffer' => false))
							));
						?>
						<!--tabs main navigation starts-->
						<div class="salonData appot clearfix">
						<div class="main-nav clearfix">
						    <?php echo $this->element('frontend/Myaccount/my_tabs'); ?>
						    <?php //echo $this->element('frontend/User/all_tabs'); ?>
						</div>
						 <div class="container bukingService">
						    
						    <div class="wrapper">
						    <div class="container my-orders">
							    <!--inner tabs starts-->
						    <div  role="tabpanel" class="appt-tabs">
							<ul class="nav nav-tabs" role="tablist">
							
						    <?php     $my = '';   $past = '';
							      if($class == 'now') {
								   $my = 'active';
							       }
							       if($class== 'past'){
								   $past = 'active';
							       }
						      ?>
							    <li class="<?php echo $my ;?>" role="presentation">
								<?php echo $this->Js->link('<span><i class="fa fa-calendar-o"></i></span>My Appointments<span class="btm-aro"></span>','/Myaccount/appointments',array('update' => '#update_ajax','escape'=>false,'class'=>'allAppointments'));?>
							    </li>
							    <li class="<?php echo $past ;?>"  role="presentation">
								<?php echo $this->Js->link('<span><i class="fa fa-calendar"></i></span>Past Appointments<span class="btm-aro"></span>','/Myaccount/appointments/past',array('update' => '#update_ajax','escape'=>false));?>
							    </li>
							</ul>
						      <!-- Tab panes -->
						      <div  class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="my_appointments">
							 
							<?php if(!empty($orders)){ ?>
							      <!-- Nav tabs -->
						       
							    <?php foreach($orders as $order) {
								$business_url = $this->frontCommon->getBusinessUrl($order['Appointment']['salon_id']);
								//pr($order);
							$orderType = $order['Appointment']['package_id'] == 0 ? 1 : 2;
							if(!empty($order['Appointment']['deal_id'])){
							    $orderType = 3;
							}
					//echo $orderType;
								$display = '';
								switch ($orderType) {
											case 1:
											    //servicename
											    $salon_service_name = $this->Common->get_salon_service_name($order['Appointment']['salon_service_id']);
											    //serviceimage
											    $image = $this->Common->getsalonserviceImage($order['Order']['salon_service_id'],$order['Appointment']['salon_id']);
											    //echo $evoucherType;
											    $type  = 1;
											    $typeName = 'service';
											    $display = 'Service';
											    break;
											case 2:
											    //packagename
											  
											    $salon_service_name = $this->Common->get_salon_package_name($order['Order']['salon_service_id']);
											    //packageimage
											    $image = $this->Common->getpackageImage($order['Order']['salon_service_id'],$order['Order']['salon_id']);
											    //echo $evoucherType;
											    //code for package evoucher
											    $type  = 2;
											    $typeName = 'packages';
											    if($order['Order']['service_type']==3){
												$display =  'Spaday';
											    }else{
											    $display =  'Package';
											    }
											    break;
											case 3:
										            $salon_service_name = $this->Common->get_salon_deal_name($order['Appointment']['deal_id']);
															//deal image
											    $image = $this->Common->getDealImage($order['Appointment']['deal_id'],$order['Appointment']['salon_id']);
											    $dealType = $this->Common->getDealType($order['Order']['salon_service_id']);
											    //    if($order['Appointment']['package_id'] == 0){
											    //	$type  = 1;
											    //	$typeName = 'service'; 
											    //    }else{
											    //	$type  = 2;
											    //	$typeName = 'packages';
											    //    }
											    if(isset($dealType['Deal']) && !empty($dealType['Deal']) && isset($dealType['DealServicePackage']) && !empty($dealType['DealServicePackage'])){
												$dealtype = $dealType['Deal']['type'];
												if($dealtype == 'Service'){
												    $type  = 1;
												    $typeName = 'service';
												    $deal = true;
												    $prentID = $dealType['DealServicePackage']['salon_service_id'];
												}else{
												    $type  = 2;
												    $typeName = 'packages';
												    $deal = true;
												    $prentID = $dealType['DealServicePackage']['package_id'];
												}
											    }
											    $display = 'Deal';
											    break;
										}
								 
								 
								?>
								<div  class="info-box clearfix">
								    <div class="img-box">
									<?php echo $this->Html->image($image,array('class'=>" ")); ?>
								    </div>
							    
								<div class="txt-box">
								    <h2><?php echo $salon_service_name; ?></h2>
								    <p class="purple"><?php echo $this->Common->get_my_salon_name($order['Order']['salon_id']); ?></p>
					<p><i class="fa  fa-clock-o"></i> <?php if(!is_null($order['Appointment']['evoucher_id'])){
				echo @$order['Appointment']['appointment_duration'];
			    }else{
				if(!empty($order[0]['Duration'])){
				    echo $order[0]['Duration'];
				} else {
				    echo '-';
				}
			    } ?> mins</p>
								    <?php if(isset($order['Evoucher']['price']) && !empty($order['Evoucher']['price'])) {
									echo " <h2>AED ".$order['Evoucher']['price']."</h2>";
									}else{?>
								    <h2>AED <?php echo $order[0]['Price']; ?></h2>
								    <?php } ?>
								    <p class="purple"><h2>Type:<?php
								      echo $display;
								    ?></h2></p>
								</div>
								
								<div class="timer-sec">
								    <div class="time-box">
									    <i class="fa fa-clock-o"></i>
									<?php echo  date("h:i A",$order['Appointment']['appoitment_start_date']); ?>, <?php echo date('l',$order['Appointment']['appoitment_start_date'])?> <?php echo date('M-d-Y',$order['Appointment']['appoitment_start_date'])?> 
								    <br>
								  <b>Order ID: </b> <?php echo $order['Order']['display_order_id'] ; ?><br>
								  <?php   if($order['Order']['service_type']==3){ ?>
								  <b>Check In Time: </b><?php echo  $order['Order']['check_in']; ?><br>
								  <b>Check Out Time: </b><?php echo  $order['Order']['check_out']; ?> 
								  <?php } ?>
								    </div>
								    <!--Need Acceptance <i class="fa fa-check-circle"></i-->
								</div>
								
						    <div class="btn-box">
							<?php
							    if(!empty($business_url) && !empty($order['Appointment']['salon_service_id'])){
								//echo  $order['Appointment']['status']; die;
								//die("test");
								if(!empty($salon_service_name))
									    $service_name_book = str_replace(' ','-',trim($salon_service_name));
									else

									    $service_name_book = '';
									    $link_book = '/'.$business_url.'-'.$typeName.'/'.@$service_name_book.'-'.base64_encode($order['Order']['salon_service_id']).'/'.base64_encode(0);
									    if(isset($deal) && $deal == true){
										$link_book = '/'.$business_url.'-'.$typeName.'/'.@$service_name_book.'-'.base64_encode($prentID).'-deal/'.base64_encode($order['Order']['salon_service_id']);
									    }
									    //echo $type; die;
									    if($type == 2){
									    $link_book = $link_book.'/'.base64_encode($order['Appointment']['salon_id']);    
									    }
									$link_book = $link_book.'/'.base64_encode($order['Order']['id']);
										    
								    } else {
									//die("test");
									$link_book = '/#';
								    }
								    //echo $link_book;
								   
								  
								   
								   
								    if($order['Appointment']['status'] == 3){ ?>
								     <button class="gray-btn"> Checkout </button>
								    
								    <?php }else{ 
								    if(is_null($order['Appointment']['evoucher_id']))
								    {
									if($order['Appointment']['status'] == 5){ ?>
								    <button class="gray-btn"> Cancelled</button>
									 
								   <?php }else{
								    
								    //if($orderType != 3){
									echo $this->Html->link('Cancel','javascript:void(0)',array('type'=>'button','escape'=>false,'class'=>'gray-btn ','id'=>'cancelAppnt','data-order'=>$order['Order']['id'],'data-type'=>$typeName ,'data-class'=>$class));
									echo $this->Html->link('Reschedule','javascript:void(0)',array('type'=>'button','escape'=>false,'class'=>'book-now','id'=>'rescheduleAppnt','data-href'=>$link_book,'data-order'=>$order['Order']['id'],'data-class'=>$class));
								   // }
								     ?>
								    <!--<button type="button" class="gray-btn">Cancel</button>-->
								    <!--<button type="button" class="book-now">Reschedule</button>-->
								<?php }
								    }else{ 
							    echo $this->Html->link('Reschedule','javascript:void(0)',array('type'=>'button','escape'=>false,'class'=>'book-now','id'=>'rescheduleAppnt','data-href'=>$link_book,'data-order'=>$order['Order']['id'],'data-class'=>$class)); 	
							}
							}    
								    
							       ?>
								</div>
							    </div>  
								
							    <?php } ?>
							    
							<?php }else{ ?>
							    <div class="no-result-found"><?php echo __('No Appointment Found'); ?></div>
							
						       <?php  } ?>
						       
							  <div class="pdng-lft-rgt35 clearfix">
							    <nav class="pagi-nation">
								    <?php if($this->Paginator->param('pageCount') > 1){
									    echo $this->element('pagination-frontend');
									   // echo $this->Js->writeBuffer();
								    } ?>
							    </nav>
							</div>
							   
							   
							    <!--<div class ="ck-paging">
								     <?php
								     /*echo $this->Paginator->first('First');
								     echo $this->Paginator->prev(
									       'Previous',
									       array(),
									       null,
									       array('class' => 'prev disabled')
								     );
								     echo $this->Paginator->numbers(array('separator'=>' '));
								     echo $this->Paginator->next(
									       'Next',
									       array(),
									       null,
									       array('class' => 'next disabled')
								     );
								     echo $this->Paginator->last('Last');*/?>
							    </div>-->
							
							</div>
						       
						      </div>
						    
						    </div>
						    <!--inner tabs ends-->
						
						</div>
						
						</div>
						    
						    
						    
						 </div>
						    
						</div>
						
						
						<!--tabs main navigation ends-->
						
						
						<style>
						.inner-loader{
						    display: none;
						}
						</style>
						
						<script type="text/javascript">
						$(document).ready(function(){
						    $(document).off('click','#cancelAppnt').on('click','#cancelAppnt',function(e){
						        if(apnt_class=='past'){
							     alert('Cancellation is not possible for past appointments.');
							    return false;
							}
						       var orderId = $(this).attr('data-order');
						       var typeID = $(this).attr('data-type');
						       var apnt_class = $(this).attr('data-class');
						       chck_setting = 'true';
						      
							var request_url  ='<?php echo $this->Html->url(array('controller'=>'Myaccount','action'=>'cancel','admin'=>false))?>';
						        //if(confirm("You will get Gift Certificate of same amount as that of service . Are you sure you want to continue ? ")){
							    $.ajax({
								url: request_url,
								type: "POST",
								data: {'order_id':orderId,'type':typeID ,'chck_setting':chck_setting},
								success: function(res) {
								    var result = JSON.parse(res);
								    if(result.msg == 'not_allowed'){
							 alert("Cancellation is not allowed for this salon.");
								    }else if(result.msg == 'less_time'){
									alert("Appointment can't be cancelled. As cancelation is possible "+result.cancel_time+" hrs prior to the appointment.");
								    }else if(result.msg == 'date_passed'){
									alert("Cancellation is not possible for past appointments.");
								    }else if(result.msg == 'true'){
									if(confirm("You will get Gift Certificate of same amount as that of service . Are you sure you want to continue ? ")){
										chck_setting = 'false';
										$.ajax({
											url: request_url,
											type: "POST",
											data: {'order_id':orderId,'type':typeID ,'chck_setting':chck_setting},
											success: function(res) {
											   var result = JSON.parse(res);
											   if(result.msg == 'true'){
												alert("Appointment cancelled successfully.Gift certificate of same amount is sent to your email id.");
												$(document).find(".allAppointments").trigger("click");							    
											   }
											 }	
										});
									}else{
									    return false;
									}
								    }
								}
							    });
						       //}
						    });
						    
						    $(document).off('click','#rescheduleAppnt').on('click','#rescheduleAppnt',function(){
						       var apnt_class = $(this).attr('data-class');
						       if(apnt_class=='past'){
							     alert('Reschedule is not possible for past appointments.');
							     return false;
							}
						       var orderId = $(this).attr('data-order');
						       var href = $(this).attr('data-href');
						       var   chck_setting = 'true';
							var request_url  = '<?php echo $this->Html->url(array('controller'=>'Myaccount','action'=>'reschedule','admin'=>false))?>';
							
							    $.ajax({
								url: request_url,
								type: "POST",
								data: {'order_id':orderId,'chck_setting':chck_setting},
								success: function(res) {
								    var result = JSON.parse(res);
								    if(result.msg == 'not_allowed'){
									alert("Reschedule is not allowed for this salon.");
								    }else if(result.msg == 'less_time'){
									alert("Appointment can't be rescheduled. As reschedule is possible "+result.reschedule_time+" hrs prior to the appointment.");
								    }else if(result.msg == 'date_passed'){
									alert("Reschedule is not possible for past appointments.");
								    }else if(result.msg == 'true'){
								     if(confirm("Are you sure you want to continue ?")){  
								       chck_setting = 'false';
										$.ajax({
											url: request_url,
											type: "POST",
											data: {'order_id':orderId,'chck_setting':chck_setting},
											success: function(res) {
											   var result = JSON.parse(res);
											 if(result.msg == 'true'){
												 window.location.href = href;						    
											   }
											 }	
										});
								      
								      }else{
									return false;
								      }
								    }
								}
							    });
						       //}
						    });
						});
						</script>
						<?php echo $this->Js->writeBuffer();?>