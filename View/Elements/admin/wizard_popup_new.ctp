<script>
    var popStatus = 'no';
	var updateURL = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'update_popup','admin'=>true))?>';
	$(document).ready(function(){
<?php

  if($auth_user['User']['type'] == 4){
	
	$businessRemindlater = $staffRemindlater = $serviceRemindlater = $uploaderRemindlater = false;
	
	
	if($this->Session->read("Remindlater.business_setup")){
		$businessRemindlater = true;
	}
	if($this->Session->read("Remindlater.staff_setup")){
		$staffRemindlater  = true;
	}
	if($this->Session->read("Remindlater.service_menu")){
		$serviceRemindlater = true;
	}
	if($this->Session->read("Remindlater.media_uploader")){
		$uploaderRemindlater =true;
	}
	
	$runmanuLBusiness = $runmanuLStaff = $runmanuLService = $runmanuLMedia = false;
	
	if($this->Session->read("Wizard.manual") && ($this->Session->read("Wizard.manual")=="business_setup")){
		$runmanuLBusiness = true;
	}
	if($this->Session->read("Wizard.manual") && ($this->Session->read("Wizard.manual")=="staff_setup")){
		$runmanuLStaff = true;
	}
	if($this->Session->read("Wizard.manual") && ($this->Session->read("Wizard.manual")=="service_menu")){
		$runmanuLService = true;
	}
	if($this->Session->read("Wizard.manual") && ($this->Session->read("Wizard.manual")=="media_uploader")){
		$runmanuLMedia = true;
	}
	$tokkn = $auth_user['User']['is_popup'];
	$remindLater = $auth_user['User']['remind_later'];
	$completedWizard = $auth_user['User']['completed_popup'];
	
	//get remind later status for wizard.
	$remindArr = array();
	if($remindLater){
	 $remindArr = explode(',',$remindLater);	
	}
	
	//get completed wizard status.
	$completedArr = array();
	if($completedWizard){
	 $completedArr = explode(',',$completedWizard);	
	}
	
	if((($businessRemindlater==false) && !in_array('business_setup',$completedArr))|| ($runmanuLBusiness== true)){ ?>
	    var $wizardinfoModal = $(document).find('#commonVendorModal');
		var $wizardTypeModal = $(document).find('#commonMediumModal');
		var $wizardModal = $(document).find('#commonSmallModal');
	   
		// First time call
		
			<?php  if(!$tokkn){
				
				if($runmanuLBusiness){ 
				?>
				
				 var wizzard_type = "business_setup";
				var wType = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'wizard_type','admin'=>true));?>'+'/'+wizzard_type;
				fetchstaticModal($wizardTypeModal,wType);
				$wizardinfoModal.modal('toggle');
				
				<?php }else{ ?>
						$(document).find('.loader-container').show();
						var theOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'wizard_info','admin'=>true));?>';
						fetchstaticModal($wizardinfoModal,theOH);
						var wizzard_type = '';
						$wizardinfoModal.on("click",".business_setup",function(){
							wizzard_type = "business_setup";
							var wType = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'wizard_type','admin'=>true));?>'+'/'+wizzard_type;
							fetchstaticModal($wizardTypeModal,wType);
							$wizardinfoModal.modal('toggle');
						});
			 	<?php } ?>
			$wizardTypeModal.on("click",".wizardsInfo",function(){
				var type = $(this).attr("data-type");
				if(type == 'business_setup'){
				var theOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'open_hours','admin'=>true));?>';
					fetchstaticModal($wizardModal,theOH);    
				}else if(type == 'staff_setup'){
				var thestaff = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'addingStaff','admin'=>true));?>';
					fetchstaticModal($wizardModal,thestaff);	
				}else if(type == 'service_menu'){
				var theservice = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'select_service','admin'=>true));?>';
					fetchstaticModal($wizardModal,theservice);		
				}else if(type == 'media_uploader'){
				var theuPic = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'set_userphotos','admin'=>true));?>';
					fetchstaticModal($wizardModal,theuPic);	
				}
			});
			
			
			// Remind later
	        var remindLaterUrl = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'remind_later','admin'=>true));?>';
	        $wizardTypeModal.on("click",".remindLater",function(){
			var remindType = $(this).attr('data-type');
			$.ajax({url:remindLaterUrl,type:'POST',data: {update:remindType} }).done(function(){
									$wizardTypeModal.modal('toggle');
									window.location.reload();
								});
			
			});
			
			
			
			// End
			$(document).on('hidden.bs.modal', function() { 
					$(document).find('.loader-container').show();
					$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
						msg = $.trim(msg);
						if(msg=="opening_hours"){
							var theOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_bank','admin'=>true));?>';
							popStatus = "no";
							fetchstaticModal($wizardModal,theOH,"bankDForm");
						}else if(msg == 'bank_detail'){
							var thebankOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_details','admin'=>true));?>';
							popStatus = "no";
							fetchstaticModal($wizardModal,thebankOH,"opeaningContactForm");
						}else if(msg == 'verify_done'){
							var thevDONE = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_map','admin'=>true));?>';
							fetchstaticModal($wizardModal,thevDONE);		
						}else if(msg == 'verify_e'){
							var thevEmail = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_email','admin'=>true));?>';
							fetchstaticModal($wizardModal,thevEmail);	
						}else if(msg == 'verify_e_p'){
							var thevEmail = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_email','admin'=>true));?>';
							fetchstaticModal($wizardModal,thevEmail);	
						}else if(msg == 'verify_p'){
							var thevPhone = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_phone','admin'=>true));?>';
							fetchstaticModal($wizardModal,thevPhone);	
						}else if(msg == 'business_map'){
							window.location.reload();
							var thefacilityD = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'facilityDetails','admin'=>true));?>';
							fetchstaticModal($wizardModal,thefacilityD);
						}else if(msg =='facility_detail'){
							var remindLaterUrl = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'completed_popup','admin'=>true));?>';
							var remindType = 'business_setup';
							$.ajax({url:remindLaterUrl,type:'POST',data: {update:remindType} }).done(function(){
													$wizardModal.modal('toggle');
													window.location.reload();
												});
						}
					});
					
				});
		<?php }elseif($tokkn=="opening_hours"){?>
	
				$(window).load(function(){
						$(document).find('.loader-container').show();
						var theOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_bank','admin'=>true));?>';
						fetchstaticModal($wizardModal,theOH,"bankDForm");
				});
				//var $publicPhoto = $publicVideo = $venueVideo = $venueImg = $userCover = $selectpriceduration = $selectService = $bookingIncharge  = $staffCreation  =  $facilityDetails =  $verifyPhone = $verifyDone = $verifyEmail =   $businessDetails =  $(document).find('#commonVendorModal');//14-15
				$(document).on('hidden.bs.modal', function() { 
					$(document).find('.loader-container').show();
					$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
						msg = $.trim(msg);
						if(msg == 'bank_detail'){
							var thebankOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_details','admin'=>true));?>';
							popStatus = "no";
							fetchstaticModal($wizardModal,thebankOH,'opeaningContactForm');
						}else if(msg == 'verify_done'){
							var thevDONE = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_map','admin'=>true));?>';
							fetchstaticModal($wizardModal,thevDONE);		
						}else if(msg == 'verify_e'){
							var thevEmail = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_email','admin'=>true));?>';
							fetchstaticModal($wizardModal,thevEmail);	
						}else if(msg == 'verify_e_p'){
							var thevEmail = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_email','admin'=>true));?>';
							fetchstaticModal($wizardModal,thevEmail);	
						}else if(msg == 'verify_p'){
							var thevPhone = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_phone','admin'=>true));?>';
							fetchstaticModal($wizardModal,thevPhone);	
						}else if(msg == 'business_map'){
							window.location.reload();
							var thefacilityD = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'facilityDetails','admin'=>true));?>';
							fetchstaticModal($wizardModal,thefacilityD);
						}else if(msg =='facility_detail'){
							var remindLaterUrl = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'completed_popup','admin'=>true));?>';
							var remindType = 'business_setup';
							$.ajax({url:remindLaterUrl,type:'POST',data: {update:remindType} }).done(function(){
													$wizardModal.modal('toggle');
													window.location.reload();
												});
						}
					});
					
				});
	    <?php }elseif($tokkn == "bank_detail"){ ?>
				$(window).load(function(){
							$(document).find('.loader-container').show();
							var theOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_details','admin'=>true));?>';
							fetchstaticModal($wizardModal,theOH,'opeaningContactForm');
					});
					$(document).on('hidden.bs.modal', function() { 
						$(document).find('.loader-container').show();
						$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
							msg = $.trim(msg);
							if(msg == 'verify_done'){
								var thevDONE = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_map','admin'=>true));?>';
								fetchstaticModal($wizardModal,thevDONE);		
							}else if(msg == 'verify_e'){
								var thevEmail = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_email','admin'=>true));?>';
								fetchstaticModal($wizardModal,thevEmail);	
							}else if(msg == 'verify_e_p'){
								var thevEmail = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_email','admin'=>true));?>';
								fetchstaticModal($wizardModal,thevEmail);	
							}else if(msg == 'verify_p'){
								var thevPhone = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_phone','admin'=>true));?>';
								fetchstaticModal($wizardModal,thevPhone);	
							}else if(msg == 'business_map'){
								window.location.reload();
								var thefacilityD = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'facilityDetails','admin'=>true));?>';
								fetchstaticModal($wizardModal,thefacilityD);
							}else if(msg =='facility_detail'){
							
								var remindLaterUrl = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'completed_popup','admin'=>true));?>';
								var remindType = 'business_setup';
								$.ajax({url:remindLaterUrl,type:'POST',data: {update:remindType} }).done(function(){
														$wizardModal.modal('toggle');
														window.location.reload();
													});
							}
						});
					});
		<?php }else if(strpos($tokkn,'verify_e') !== false){?>
			//var $verifyEmail = $(document).find('#commonVendorModal');
			$(window).load(function(){
					$(document).find('.loader-container').show();
					var theOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_email','admin'=>true));?>';
					fetchstaticModal($wizardModal,theOH);
			});
			
			//var $publicPhoto = $publicVideo = $venueVideo = $venueImg = $userCover = $selectpriceduration = $selectService = $bookingIncharge  = $staffCreation  =  $facilityDetails =  $verifyDone =  $verifyPhone  = $(document).find('#commonVendorModal'); //12-12
			$(document).on('hidden.bs.modal', function() { 
				$(document).find('.loader-container').show();
				$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
					msg = $.trim(msg);
					if(msg == 'verify_done'){
						var thevDONE = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_map','admin'=>true));?>';
						fetchstaticModal($wizardModal,thevDONE);		
					}else if(msg == 'verify_p'){
						var thevPhone = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_phone','admin'=>true));?>';
						fetchstaticModal($wizardModal,thevPhone);	
					}else if(msg == 'business_map'){
						window.location.reload();
						var thefacilityD = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'facilityDetails','admin'=>true));?>';
						fetchstaticModal($wizardModal,thefacilityD);
					}
					else if(msg =='facility_detail'){
							var remindLaterUrl = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'completed_popup','admin'=>true));?>';
							var remindType = 'business_setup';
							$.ajax({url:remindLaterUrl,type:'POST',data: {update:remindType} }).done(function(){
													$wizardModal.modal('toggle');
													window.location.reload();
												});
						}
				});
				
			});
		
		<?php }elseif (strpos($tokkn,'verify_p') !== false) { ?>
			$(window).load(function(){
					$(document).find('.loader-container').show();
					var theOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_phone','admin'=>true));?>';
					fetchstaticModal($wizardModal,theOH);
			});
			
			
				//var $publicPhoto = $publicVideo = $venueVideo = $venueImg = $userCover = $selectpriceduration = $selectService = $bookingIncharge  = $staffCreation  =  $facilityDetails =  $verifyDone = $(document).find('#commonVendorModal');
					$(document).on('hidden.bs.modal', function() { 
						$(document).find('.loader-container').show();
						$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
							msg = $.trim(msg);
							if(msg == 'verify_done'){
								var thevDONE = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_map','admin'=>true));?>';
								fetchstaticModal($wizardModal,thevDONE);		
							}else if(msg == 'business_map'){
								window.location.reload();
								var thefacilityD = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'facilityDetails','admin'=>true));?>';
								fetchstaticModal($wizardModal,thefacilityD);
							}else if(msg =='facility_detail'){
							var remindLaterUrl = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'completed_popup','admin'=>true));?>';
							var remindType = 'business_setup';
							$.ajax({url:remindLaterUrl,type:'POST',data: {update:remindType} }).done(function(){
													$wizardModal.modal('toggle');
													window.location.reload();
												});
						}
						});
						
					});
		
		<?php }elseif ($tokkn == 'verify_done') {  ?>
		 
		 //var $verifyDone = $(document).find('#commonVendorModal');
				$(window).load(function(){
						$(document).find('.loader-container').show();
						var mapURL = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_map','admin'=>true));?>';
						fetchstaticModal($wizardModal,mapURL);
				});
			
				$(document).on('hidden.bs.modal', function() { 
					$(document).find('.loader-container').show();
					$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
						msg = $.trim(msg);
						if(msg == 'business_map'){
							window.location.reload();
							var thefacilityD = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'facilityDetails','admin'=>true));?>';
							fetchstaticModal($wizardModal,thefacilityD);
						}
						else if(msg =='facility_detail'){
							var remindLaterUrl = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'completed_popup','admin'=>true));?>';
							var remindType = 'business_setup';
							$.ajax({url:remindLaterUrl,type:'POST',data: {update:remindType} }).done(function(){
													$wizardModal.modal('toggle');
													window.location.reload();
												});
						}
					});
					
				});
		 
		
		<?php }elseif ($tokkn == 'business_map') {  ?>
			
			//$(window).load(function(){
					$(document).find('.loader-container').show();
					var thefacilityD = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'facilityDetails','admin'=>true));?>';
					fetchstaticModal($wizardModal,thefacilityD);	
			//});
			$(document).on('hidden.bs.modal', function() { 
					$(document).find('.loader-container').show();
					$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
						 msg = $.trim(msg);
						 if(msg =='facility_detail'){
							var remindLaterUrl = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'completed_popup','admin'=>true));?>';
							var remindType = 'business_setup';
							$.ajax({url:remindLaterUrl,type:'POST',data: {update:remindType} }).done(function(){
													$wizardModal.modal('toggle');
													window.location.reload();
												});
						}
					});
					
				});
		
		
		<?php } ?>
		
		//$(document).on('hidden.bs.modal', function() { 
		//				$(document).find('.loader-container').show();
		//				$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
		//					if(msg == 'opening_hours'){
		//						var theOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_bank','admin'=>true));?>';
		//						fetchstaticModal($wizardModal,theOH);	//ok
		//					}else if(msg == 'bank_detail'){
		//						var thebankOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_details','admin'=>true));?>';
		//						fetchstaticModal($wizardModal,thebankOH);	//ok
		//					}else if(msg == 'verify_done'){
		//						var thevDONE = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_map','admin'=>true));?>';
		//						fetchstaticModal($wizardModal,thevDONE);		
		//					}else if(msg == 'verify_e'){
		//						var thevEmail = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_email','admin'=>true));?>';
		//						fetchstaticModal($wizardModal,thevEmail);	
		//					}else if(msg == 'verify_e_p'){
		//						var thevEmail = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_email','admin'=>true));?>';
		//						fetchstaticModal($wizardModal,thevEmail);	
		//					}else if(msg == 'verify_p'){
		//						var thevPhone = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_phone','admin'=>true));?>';
		//						fetchstaticModal($wizardModal,thevPhone);	
		//					}else if(msg == 'business_map'){
		//						window.location.reload();
		//						var thefacilityD = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'facilityDetails','admin'=>true));?>';
		//						fetchstaticModal($wizardModal,thefacilityD);
		//					}
		//				});
		//				
		//			});
			$wizardModal.on('click','.submitopenHForm',function(){
				var formID = '#opeaningHoursForm';
				var modalName  = 'SalonOpeningHour';
				var updateVal = 'opening_hours';
				onsubmitAction($wizardModal,updateURL,formID,modalName,updateVal);
			});
			 remindLaterUrl = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'remind_later','admin'=>true));?>';
		 $wizardModal.on("click",".remindLater",function(e){
			e.preventDefault(); 
			var remindType = $(this).attr('data-type');
			$.ajax({url:remindLaterUrl,type:'POST',data: {update:remindType} }).done(function(){
									$wizardModal.modal('toggle');
									window.location.reload();
								});
			
			});
				
			$wizardModal.on('click','.submitbankForm',function(){
				var formID = '#bankDForm';
				var modalName  = 'BankDetail';
				var updateVal = 'bank_detail';
				onsubmitAction($wizardModal,updateURL,formID,modalName,updateVal);
			});
			
			//$businessDetails
			$wizardModal.on('click','.submitContactForm',function(){
					var formID = '#opeaningContactForm';
					var modalName  = 'User';
					var updateVal = 'business_detail';
					var options = { 
							success:function(res){
									if(onResponse($wizardModal,modalName,res)){
										
									}
							}
					}; 
					$(formID).submit(function(){
							if(popStatus=="no"){
								$(this).ajaxSubmit(options);
								popStatus = "yes";
							}
							$(this).unbind('submit');
							$(this).bind('submit');
							return false;
					});
					
				});
					
			//$verifyDone
			$wizardModal.on('click','.locationbtnForm',function(e){
				e.preventDefault();
				var locvalues = $wizardModal.find('#locationbtnForm').serialize();
				var actionURL = $wizardModal.find('#locationbtnForm').attr('action');
				$.ajax({url:actionURL,type:'POST',data: {data:JSON.stringify(locvalues)} })
				.done(function(res){
					if(onResponse($wizardModal,'Address',res)){
						$.ajax({url:updateURL,type:'POST',data: {update:'business_map'} });
						$wizardModal.modal('toggle');
					}
					
				});	
			});
			
			//Facility details
			$wizardModal.on('click','.facilityDetailForm',function(){
				var formID = '#facilityDetailForm';
				var modalName  = 'FacilityDetail';
				var updateVal = 'facility_detail';
				onsubmitAction($wizardModal,updateURL,formID,modalName,updateVal);
			});
		
	<?php   }elseif((($staffRemindlater==false) && !in_array('staff_setup',$completedArr))||($runmanuLStaff==true)){ ?>
	       
		    var $wizardinfoModal = $(document).find('#commonVendorModal');
			var $wizardTypeModal = $(document).find('#commonMediumModal');
			var $wizardModal = $(document).find('#commonSmallModal');
			
			<?php if($tokkn == 'facility_detail' || empty($tokkn)){ ?>
			wizzard_type = "staff_setup";
			var wType = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'wizard_type','admin'=>true));?>'+'/'+wizzard_type;
			fetchstaticModal($wizardTypeModal,wType);
			
			$wizardTypeModal.on("click",".wizardsInfo",function(){
				//var thestaff = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'addingStaff','admin'=>true));?>';
					//fetchstaticModal($wizardModal,thestaff);
				$wizardTypeModal.toggle();
			});
			
			$(document).on('hidden.bs.modal', function() { 
				$(document).find('.loader-container').show();
				$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
					msg = $.trim(msg);
					if(msg == 'facility_detail'|| empty(msg)){
						var thestaff = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'addingStaff','admin'=>true));?>';
					 	 popStatus = "no";
						 fetchstaticModal($wizardModal,thestaff,"staffCreationForm");	
					}else if(msg == 'add_staff'){
						var theBokIncstaff = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'bookingIncharge','admin'=>true));?>';
						fetchstaticModal($wizardModal,theBokIncstaff);	
					}else if(msg == 'booking_incharge'){
							var remindLaterUrl = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'completed_popup','admin'=>true));?>';
							var remindType = 'staff_setup';
							$.ajax({url:remindLaterUrl,type:'POST',data: {update:remindType} }).done(function(){
													$wizardModal.modal('toggle');
													window.location.reload();
												});
					}
				});
			});
			
			
			// Remind later
	        var remindLaterUrl = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'remind_later','admin'=>true));?>';
	        $wizardTypeModal.on("click",".remindLater",function(){
			var remindType = $(this).attr('data-type');
			$.ajax({url:remindLaterUrl,type:'POST',data: {update:remindType} }).done(function(){
									$wizardTypeModal.modal('toggle');
									window.location.reload();
								});
			
			});
			// End
			
			<?php }elseif($tokkn == 'add_staff') { ?>
				
				$(window).load(function(){
						$(document).find('.loader-container').show();
						var theBokIncstaff = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'bookingIncharge','admin'=>true));?>';
						fetchstaticModal($wizardModal,theBokIncstaff);	
				});
				
				$(document).on('hidden.bs.modal', function() { 
				$(document).find('.loader-container').show();
				$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
					 msg = $.trim(msg);
					 if(msg == 'add_staff'){
						var theBokIncstaff = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'bookingIncharge','admin'=>true));?>';
						fetchstaticModal($wizardModal,theBokIncstaff);	
					}else if(msg == 'booking_incharge'){
							var remindLaterUrl = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'completed_popup','admin'=>true));?>';
							var remindType = 'staff_setup';
							$.ajax({url:remindLaterUrl,type:'POST',data: {update:remindType} }).done(function(){
													$wizardModal.modal('toggle');
													window.location.reload();
												});
					}
				});
			});
				
			
			<?php } ?>
			//$staffCreation
			$wizardModal.on('click','.submitStaffForm',function(){
				var listTxt = $wizardModal.find('.staffListBox').find('div').length;
				if(listTxt > 0){
					$.ajax({url:updateURL,type:'POST',data: {update:'add_staff'} });
					$wizardModal.modal('toggle');
				}
				else{
					alert("Please add Staff");
				}
			});
		//$bookingIncharge
			$wizardModal.on('click','.submitbookingInchargeForm',function(){
				var formID = '#submitbookingInchargeForm';
				var modalName  = 'User';
				var updateVal = 'booking_incharge';
				onsubmitAction($wizardModal,updateURL,formID,modalName,updateVal);
			});
			
	
		
	<?php }elseif((($serviceRemindlater==false) && !in_array('service_menu',$completedArr)) || ($runmanuLService==true)){ ?>
			
			var $wizardinfoModal = $(document).find('#commonVendorModal');
			var $wizardTypeModal = $(document).find('#commonMediumModal');
			var $wizardModal     = $(document).find('#commonSmallModal');
			
			<?php if($tokkn == 'booking_incharge' || empty($tokkn)){ ?>
			
					wizzard_type = "service_menu";
					var wType = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'wizard_type','admin'=>true));?>'+'/'+wizzard_type;
					fetchstaticModal($wizardTypeModal,wType);
					
					$wizardTypeModal.on("click",".wizardsInfo",function(){
						//var thestaff = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'addingStaff','admin'=>true));?>';
							//fetchstaticModal($wizardModal,thestaff);
						$wizardTypeModal.toggle();
					});
			
					$(document).on('hidden.bs.modal', function() { 
						$(document).find('.loader-container').show();
						$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
							  msg = $.trim(msg);
							 if(msg == 'booking_incharge' || empty(msg)){
									//$(document).find('.loader-container').show();
									var theservice = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'select_service','admin'=>true));?>';
									fetchstaticModal($wizardModal,theservice);	
							}else if(msg == 'select_service'){
									//$(document).find('.loader-container').show();
									var theservice = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'set_priceduration','admin'=>true));?>';
									popStatus = "no";
									fetchstaticModal($wizardModal,theservice,"treatmentsettingForm");	
							}else if(msg == 'treatment_setting'){
									var remindLaterUrl = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'completed_popup','admin'=>true));?>';
									var remindType = 'service_menu';
									$.ajax({url:remindLaterUrl,type:'POST',data: {update:remindType} }).done(function(){
											$wizardModal.modal('toggle');
											window.location.reload();
										});
							}
						});
					});
			
					// Remind later
					var remindLaterUrl = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'remind_later','admin'=>true));?>';
					$wizardTypeModal.on("click",".remindLater",function(){
					var remindType = $(this).attr('data-type');
					alert(remindType);
					$.ajax({url:remindLaterUrl,type:'POST',data: {update:remindType} }).done(function(){
											$wizardTypeModal.modal('toggle');
											window.location.reload();
										});
					
					});
		
			<?php }elseif($tokkn == 'select_service'){  ?>
			
					$(document).find('.loader-container').show();
					var theservice = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'set_priceduration','admin'=>true));?>';
					fetchstaticModal($wizardModal,theservice);
					$(document).on('hidden.bs.modal', function() { 
						$(document).find('.loader-container').show();
						$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
							 msg = $.trim(msg);
							if(msg == 'select_service'){
									//$(document).find('.loader-container').show();
									var theservice = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'set_priceduration','admin'=>true));?>';
									popStatus = "no";
									fetchstaticModal($wizardModal,theservice,"treatmentsettingForm");	
							}else if(msg == 'treatment_setting'){
									var remindLaterUrl = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'completed_popup','admin'=>true));?>';
									var remindType = 'service_menu';
									$.ajax({url:remindLaterUrl,type:'POST',data: {update:remindType} }).done(function(){
											$wizardModal.modal('toggle');
											window.location.reload();
										});
							}
						});
					});
					
			
			<?php }elseif($tokkn == 'treatment_setting'){?>
			
			var remindLaterUrl = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'completed_popup','admin'=>true));?>';
									var remindType = 'service_menu';
									$.ajax({url:remindLaterUrl,type:'POST',data: {update:remindType} }).done(function(){
											$wizardModal.modal('toggle');
											window.location.reload();
										});
			
			<?php } ?>
			
				//$selectService
			$wizardModal.on('click', '.submitSelectForm', function(e){
				var formID = '#serviceSelectForm';
				var modalName  = 'Service';
				var updateVal = 'select_service';
				onsubmitAction($wizardModal,updateURL,formID,modalName,updateVal);
			});
			//$selectpriceduration
			$wizardModal.on('click', '.treatmentsettingForm', function(e){
				
					var formID = '#treatmentsettingForm';
					var modalName  = 'Service';
					var updateVal = 'treatment_setting';
					onsubmitAction($wizardModal,updateURL,formID,modalName,updateVal);
				
			});
		
		
		
<?php	}elseif((($uploaderRemindlater==false) && !in_array('media_uploader',$completedArr))||($runmanuLMedia==true)){ ?>
			
			var $wizardinfoModal = $(document).find('#commonVendorModal');
			var $wizardTypeModal = $(document).find('#commonMediumModal');
			var $wizardModal = $(document).find('#commonSmallModal');
			
			<?php if($tokkn == 'treatment_setting' || empty($tokkn)){ ?>
			
					wizzard_type = "media_uploader";
					var wType = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'wizard_type','admin'=>true));?>'+'/'+wizzard_type;
					fetchstaticModal($wizardTypeModal,wType);
					
					$wizardTypeModal.on("click",".wizardsInfo",function(){
						//var thestaff = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'addingStaff','admin'=>true));?>';
							//fetchstaticModal($wizardModal,thestaff);
						$wizardTypeModal.toggle();
					});
			
					$(document).on('hidden.bs.modal', function() { 
						$(document).find('.loader-container').show();
						$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
							msg = $.trim(msg);
							if(msg == 'treatment_setting' || empty(msg)){
									var theuPic = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'set_userphotos','admin'=>true));?>';
									fetchstaticModal($wizardModal,theuPic);
							}else if(msg == 'profile_images'){
									var venuImg = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'venue_images','admin'=>true));?>';
									fetchstaticModal($wizardModal,venuImg);
							}else if(msg == 'venue_image'){
								var venuVideo = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'venue_video','admin'=>true));?>';
								fetchstaticModal($wizardModal,venuVideo);
							}else if(msg == 'venue_video'){
								var remindLaterUrl = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'completed_popup','admin'=>true));?>';
									var remindType = 'media_uploader';
									$.ajax({url:remindLaterUrl,type:'POST',data: {update:remindType} }).done(function(){
											$wizardModal.modal('toggle');
											window.location.reload();
										});
							}
						});
					});
			
					// Remind later
					var remindLaterUrl = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'remind_later','admin'=>true));?>';
					$wizardTypeModal.on("click",".remindLater",function(){
					var remindType = $(this).attr('data-type');
					$.ajax({url:remindLaterUrl,type:'POST',data: {update:remindType} }).done(function(){
											$wizardTypeModal.modal('toggle');
											window.location.reload();
										});
					
					});
		
			<?php }elseif($tokkn == 'profile_images'){ ?>
					var venuImg = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'venue_images','admin'=>true));?>';
					fetchstaticModal($wizardModal,venuImg);
					
					$(document).on('hidden.bs.modal', function() { 
						$(document).find('.loader-container').show();
						$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
							msg = $.trim(msg);
							if(msg == 'venue_image'){
								var venuVideo = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'venue_video','admin'=>true));?>';
								fetchstaticModal($wizardModal,venuVideo);
							}else if(msg == 'venue_video'){
								var remindLaterUrl = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'completed_popup','admin'=>true));?>';
									var remindType = 'media_uploader';
									$.ajax({url:remindLaterUrl,type:'POST',data: {update:remindType} }).done(function(){
											$wizardModal.modal('toggle');
											window.location.reload();
										});
							}
						});
					});
			<?php }elseif($tokkn == 'venue_image'){?>
			var venuVideo = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'venue_video','admin'=>true));?>';
								fetchstaticModal($wizardModal,venuVideo);
					
					$(document).on('hidden.bs.modal', function() { 
						$(document).find('.loader-container').show();
						$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
							  msg = $.trim(msg);
							 if(msg == 'venue_video'){
								var remindLaterUrl = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'completed_popup','admin'=>true));?>';
									var remindType = 'media_uploader';
									$.ajax({url:remindLaterUrl,type:'POST',data: {update:remindType} }).done(function(){
											$wizardModal.modal('toggle');
											window.location.reload();
										});
							}
						});
					});
			<?php }elseif($tokkn == 'venue_video'){?>
			var remindLaterUrl = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'completed_popup','admin'=>true));?>';
									var remindType = 'media_uploader';
									$.ajax({url:remindLaterUrl,type:'POST',data: {update:remindType} }).done(function(){
											$wizardModal.modal('toggle');
											window.location.reload();
										});
							}
						});
					});
		  	<?php }?>
			
			
			
			
			//$userCover
			$wizardModal.on('click', '.submitImgeForm', function(e){
				
				var theIMG = $wizardModal.find('#submitImgeForm').find('.logoImage').val();
				//console.log($wizardModal.find('#submitImgeForm').find('.logoImage').closest("img"));
				if($wizardModal.find('#submitImgeForm').find('.logoImage').prev().hasClass("imageView"))
					{
						
						theIMG = true;
					}
					
				if(theIMG){
					var formID = '#submitImgeForm';
					var modalName  = 'User';
					var updateVal = 'profile_images';
					onsubmitAction($wizardModal,updateURL,formID,modalName,updateVal);
				}
				else{
					alert('Please Select Profile Image');
					return false;
				}
			});
			
		
		$wizardModal.on('click','.addMore',function(){
			var theData =  $wizardModal.find( "div.frm-grp" ).find('div.form-group:first').clone();
			//theData.find('input').val('');
			theData.find('div.addremove').append('<a href="javascript:void(0);" class="removeURL"><input class="btn btn-primary" type="button" value="Remove" name="Remove"></a>');
			$(document).find('div.frm-grp').append('<div class="form-group clearfix">'+theData.html()+'</div>');
		});
		
		
		$wizardModal.on('click','.addthatURL',function(){
			var youURL = $(this).closest('div.form-group').find('input').val();
			if(youURL){
				if(parseYouTube(youURL)){
					$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'venue_video','admin'=>true));?>',type:'POST',data: {URL:youURL} })
					.done(function(res){
					        res = $.trim(res);
						if(res == 'e'){
							alert('Youtube link already Exist!');
						}
						else if(res == 'f'){
							alert('Error in saving!');
						}
						else{
							if(res != 's'){
							var appenddata = '<li><a href="#"><img src="'+res+'" > </a><div class="extras"><div class="extras-inner"><a href="'+youURL+'" class="youtube" target="_blank" rel="group-1"><i class="icon-search"></i></a></div></div></li>';
							$wizardModal.find('div.youtubeall ul').append(appenddata);
							//https://www.youtube.com/watch?v=XV_XMM-vUPk
							}
							else{
								alert('Video Saved Successfully.');
							}
						}
					})
					;
				}
				else{
					alert('Please enter Correct Youtube URL');
				}
			}
			else{
				alert('Please Enter URL');
			}
		});
		
		$wizardModal.on('click','.removeURL',function(){
			if(confirm('Are you sure to Delete')){
				$(this).closest('div.form-group').remove();
			}
		});
		
			////$venueVideo.
		$wizardModal.on('click','.submitVideoForm',function(e){
			e.preventDefault();
			$.ajax({url:updateURL,type:'POST',data: {update:'venue_video'} });	
			$wizardModal.modal('toggle');
		});
		
		
		//$wizardModal.off('click').on('click','.addMore',function(){
		//	var theData =  $(document).find( "div.frm-grp" ).find('div.form-group:first').clone();
		//	theData.find('input').val('');
		//	theData.find('div.addremove').append('<a href="javascript:void(0);" class="removeURL"><i class="fa  fa-minus    "></i></a>');
		//	$(document).find('div.frm-grp').append('<div class="form-group clearfix">'+theData.html()+'</div>');
		//});
		//$wizardModal.on('click','.addthatURL',function(){
		//	var youURL = $(this).closest('div.form-group').find('input').val();
		//	if(youURL){
		//		if(parseYouTube(youURL)){
		//			$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'public_video','admin'=>true));?>',type:'POST',data: {URL:youURL} })
		//			.done(function(res){
		//				if(res == 'e'){
		//					alert('Youtube link already Exist!');
		//				}
		//				else if(res == 'f'){
		//					alert('Error in saving!');
		//				}
		//				else{
		//					if(res != 's'){
		//					var appenddata = '<li><a href="#"><img src="'+res+'" > </a><div class="extras"><div class="extras-inner"><a href="'+youURL+'" class="youtube" target="_blank" rel="group-1"><i class="icon-search"></i></a></div></div></li>';
		//					$wizardModal.find('div.youtubeall ul').append(appenddata);
		//					//https://www.youtube.com/watch?v=XV_XMM-vUPk
		//					}
		//					else{
		//						alert('Video Saved Successfully.');
		//					}
		//				}
		//			})
		//			;
		//		}
		//		else{
		//			alert('Please enter Correct Youtube URL');
		//		}
		//	}
		//	else{
		//		alert('Please Enter URL');
		//	}
		//});
			//
			//$wizardModal.on('click','.removeURL',function(){
			//	if(confirm('Are you sure to Delete')){
			//		$(this).closest('div.form-group').remove();
			//	}
			//});
			//
			////$publicVideo.
			//$wizardModal.on('click','.submitAlbVdoForm',function(e){
			//	e.preventDefault();
			//	$.ajax({url:updateURL,type:'POST',data: {update:'done'} });	
			//	$wizardModal.modal('toggle');
			//	window.location.reload();
			//});
			//
			
		
<?php	}} ?>	
		
	});
	
	
	function onsubmitAction($modal,updateURL,formID,modalName,updateVal){
		
		var options = { 
				success:function(res){
						if(onResponse($modal,modalName,res)){
								$.ajax({url:updateURL,type:'POST',data: {update:updateVal} });	
						}
				}
		}; 
		$modal.find(formID).submit(function(){
				if(popStatus == 'no'){
				  $(this).ajaxSubmit(options);
				   popStatus = 'yes';
				}
				$(this).unbind('submit');
				$(this).bind('submit');
				return false;
		});
	}
	
	
	function empty(data)
	{
	        data = $.trim(data);
		if(typeof(data) == 'number' || typeof(data) == 'boolean')
		{
		  return false;
		}
		if(typeof(data) == 'undefined' || data === null)
		{
		  return true;
		}
		if(typeof(data.length) != 'undefined')
		{
		  return data.length == 0;
		}
		var count = 0;
		for(var i in data)
		{
		  if(data.hasOwnProperty(i))
		  {
			count ++;
		  }
		}
		return count == 0;
	}
	
	
</script>            
                            
                            

                        
                        
                     