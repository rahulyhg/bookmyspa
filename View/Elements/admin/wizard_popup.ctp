<?php 
	$userTy = $this->Common->businessModal();
	if(array_key_exists($auth_user['User']['type'],$userTy)){ ?>
		<script>
		function onsubmitAction($modal,updateURL,formID,modalName,updateVal){
				var options = { 
						success:function(res){
								if(onResponse($modal,modalName,res)){
										$.ajax({url:updateURL,type:'POST',data: {update:updateVal} });	
								}
						}
				}; 
				$modal.find(formID).submit(function(){
						$(this).ajaxSubmit(options);
						$(this).unbind('submit');
						$(this).bind('submit');
						return false;
				});
		}
		</script>
	<?php 
		
		if($auth_user['User']['type'] == 2){ ?>
			<script>
				var updateURL = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'update_popup','admin'=>true))?>';
				$(document).ready(function(){
					<?php $tokkn = $auth_user['User']['is_popup'];
					if(!$tokkn){ ?>
						var $businessModal = $(document).find('#commonVendorModal');
						$(window).load(function(){
							$(document).find('.loader-container').show();
							var theOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_bank','admin'=>true));?>';
							fetchstaticModal($businessModal,theOH);
						});
						
						var  $businessDetails =   $(document).find('#commonVendorModal'); 
						$(document).on('hidden.bs.modal', function() { 
							$(document).find('.loader-container').show();
							$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
								if(msg == 'bank_detail'){
									var thebankOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_details','admin'=>true));?>';
									fetchstaticModal($businessDetails,thebankOH);	//ok
								}
							});
							
						});
						
						//$businessModal
						$(document).on('click','.submitbankForm',function(){
							var formID = '#bankDForm';
							var modalName  = 'BankDetail';
							var updateVal = 'bank_detail';
							onsubmitAction($businessModal,updateURL,formID,modalName,updateVal);
						});
						
						//$businessDetails
						$(document).on('click','.submitContactForm',function(){
								var formID = '#opeaningContactForm';
								var modalName  = 'User';
								var updateVal = 'done';
								var options = { 
										success:function(res){
												if(onResponse($businessDetails,modalName,res)){
													$.ajax({url:updateURL,type:'POST',data: {update:'done'} }).done(function(){alert('The Profile Registered Successfully. Please add Vendors to avail the features');});
												}
										}
								}; 
								$(formID).submit(function(){
										$(this).ajaxSubmit(options);
										$(this).unbind('submit');
										$(this).bind('submit');
										return false;
								});
								
							});
							
						//$businessDetails
						$(document).on('click','.skipContactForm',function(e){
							e.preventDefault();
							$.ajax({url:updateURL,type:'POST',data: {update:'done'} }).done(function(){
								$businessDetails.modal('toggle');
								alert('The Profile Registered Successfully. Please add Vendors to avail the features');
							});	
							
						});
						
					<?php }
					elseif($tokkn == 'bank_detail'){ ?>
						var $businessDetails = $(document).find('#commonVendorModal');
						$(window).load(function(){
							$(document).find('.loader-container').show();
							var thebankOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_details','admin'=>true));?>';
							fetchstaticModal($businessDetails,thebankOH);	//ok
						});
						
						//$businessDetails
						$(document).on('click','.submitContactForm',function(){
								var formID = '#opeaningContactForm';
								var modalName  = 'User';
								var updateVal = 'done';
								var options = { 
										success:function(res){
												if(onResponse($businessDetails,modalName,res)){
													$.ajax({url:updateURL,type:'POST',data: {update:'done'} }).done(function(){alert('The Profile Registered Successfully. Please add Vendors to avail the features');});
												}
										}
								}; 
								$(formID).submit(function(){
										$(this).ajaxSubmit(options);
										$(this).unbind('submit');
										$(this).bind('submit');
										return false;
								});
								
							});
							
						//$businessDetails
						$(document).on('click','.skipContactForm',function(e){
							e.preventDefault();
							$.ajax({url:updateURL,type:'POST',data: {update:'done'} }).done(function(){
								$businessDetails.modal('toggle');
								alert('The Profile Registered Successfully. Please add Vendors to avail the features');
							});
						});
					<?php  } ?>
					
				});
			</script>
			
		<?php 
		}else{
		?>
		<script>
			var updateURL = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'update_popup','admin'=>true))?>';
			$(document).ready(function(){
		<?php $tokkn = $auth_user['User']['is_popup'];
			if(!$tokkn){ ?>
					var $serviceModal = $(document).find('#commonVendorModal');
					$(window).load(function(){
						$(document).find('.loader-container').show();
						var theOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'open_hours','admin'=>true));?>';
						fetchstaticModal($serviceModal,theOH);
					});
					
					var $publicPhoto = $publicVideo = $venueVideo = $venueImg = $userCover = $selectpriceduration = $selectService = $bookingIncharge  = $staffCreation  =  $facilityDetails =  $verifyPhone = $verifyDone = $verifyEmail =   $businessDetails =    $businessModal =   $(document).find('#commonVendorModal'); //15-16
					$(document).on('hidden.bs.modal', function() { 
						$(document).find('.loader-container').show();
						$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
							if(msg == 'opening_hours'){
								var theOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_bank','admin'=>true));?>';
								fetchstaticModal($businessModal,theOH);	//ok
							}else if(msg == 'bank_detail'){
								var thebankOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_details','admin'=>true));?>';
								fetchstaticModal($businessDetails,thebankOH);	//ok
							}else if(msg == 'verify_done'){
								var thevDONE = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_map','admin'=>true));?>';
								fetchstaticModal($verifyDone,thevDONE);		
							}else if(msg == 'verify_e'){
								var thevEmail = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_email','admin'=>true));?>';
								fetchstaticModal($verifyEmail,thevEmail);	
							}else if(msg == 'verify_e_p'){
								var thevEmail = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_email','admin'=>true));?>';
								fetchstaticModal($verifyEmail,thevEmail);	
							}else if(msg == 'verify_p'){
								var thevPhone = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_phone','admin'=>true));?>';
								fetchstaticModal($verifyPhone,thevPhone);	
							}else if(msg == 'business_map'){
								window.location.reload();
								//var thefacilityD = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'facilityDetails','admin'=>true));?>';
								//fetchstaticModal($facilityDetails,thefacilityD);
							}
						});
						
					});
					
			$(document).on('click','.submitopenHForm',function(){
				var formID = '#opeaningHoursForm';
				var modalName  = 'SalonOpeningHour';
				var updateVal = 'opening_hours';
				onsubmitAction($serviceModal,updateURL,formID,modalName,updateVal);
			});
					
			$(document).on('click','.submitbankForm',function(){
				var formID = '#bankDForm';
				var modalName  = 'BankDetail';
				var updateVal = 'bank_detail';
				onsubmitAction($businessModal,updateURL,formID,modalName,updateVal);
			});
					
			//$businessDetails
			$(document).on('click','.submitContactForm',function(){
					var formID = '#opeaningContactForm';
					var modalName  = 'User';
					var updateVal = 'business_detail';
					var options = { 
							success:function(res){
									if(onResponse($businessDetails,modalName,res)){
										
									}
							}
					}; 
					$(formID).submit(function(){
							$(this).ajaxSubmit(options);
							$(this).unbind('submit');
							$(this).bind('submit');
							return false;
					});
					
				});
				
			//$businessDetails
			$(document).on('click','.skipContactForm',function(e){
				e.preventDefault();
				$.ajax({url:updateURL,type:'POST',data: {update:'verify_done'} });	
				$businessDetails.modal('toggle');
			});		
			
			//$verifyEmail
			$(document).on('click','.vEmailForm',function(){
				var formID = '#vEmailForm';
				var modalName  = 'User';
				var options = { 
						success:function(res){
								if(onResponse($verifyEmail,modalName,res)){
									
								}
						}
				}; 
				$(formID).submit(function(){
						$(this).ajaxSubmit(options);
						$(this).unbind('submit');
						$(this).bind('submit');
						return false;
				});
				
			});
				
			//$verifyPhone
			$(document).on('click','.vPhonebtn',function(){
				var formID = '#vPhoneForm';
				var modalName  = 'User';
				var options = { 
						success:function(res){
								if(onResponse($verifyPhone,modalName,res)){
									
								}
						}
				}; 
				$(formID).submit(function(){
						$(this).ajaxSubmit(options);
						$(this).unbind('submit');
						$(this).bind('submit');
						return false;
				});
				
			});
		
			//$verifyDone
			$(document).on('click','.locationbtnForm',function(e){
				e.preventDefault();
				var locvalues = $verifyDone.find('#locationbtnForm').serialize();
				var actionURL = $verifyDone.find('#locationbtnForm').attr('action');
				$.ajax({url:actionURL,type:'POST',data: {data:JSON.stringify(locvalues)} })
				.done(function(res){
					if(onResponse($verifyDone,'Address',res)){
						$.ajax({url:updateURL,type:'POST',data: {update:'business_map'} });
						$verifyDone.modal('toggle');
					}
					
				});	
			});
			
			<?php
			}
			elseif($tokkn == 'opening_hours' ){
			?>
				var $businessModal = $(document).find('#commonSmallModal');
				$(window).load(function(){
						$(document).find('.loader-container').show();
						var theOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_bank','admin'=>true));?>';
						fetchstaticModal($businessModal,theOH);
				});
				
				
				
					var $publicPhoto = $publicVideo = $venueVideo = $venueImg = $userCover = $selectpriceduration = $selectService = $bookingIncharge  = $staffCreation  =  $facilityDetails =  $verifyPhone = $verifyDone = $verifyEmail =   $businessDetails =  $(document).find('#commonVendorModal');//14-15
					$(document).on('hidden.bs.modal', function() { 
						$(document).find('.loader-container').show();
						$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
							if(msg == 'bank_detail'){
								var thebankOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_details','admin'=>true));?>';
								fetchstaticModal($businessDetails,thebankOH);	
							}else if(msg == 'verify_done'){
								var thevDONE = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_map','admin'=>true));?>';
								fetchstaticModal($verifyDone,thevDONE);		
							}else if(msg == 'verify_e'){
								var thevEmail = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_email','admin'=>true));?>';
								fetchstaticModal($verifyEmail,thevEmail);	
							}else if(msg == 'verify_e_p'){
								var thevEmail = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_email','admin'=>true));?>';
								fetchstaticModal($verifyEmail,thevEmail);	
							}else if(msg == 'verify_p'){
								var thevPhone = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_phone','admin'=>true));?>';
								fetchstaticModal($verifyPhone,thevPhone);	
							}else if(msg == 'business_map'){
								window.location.reload();
								//var thefacilityD = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'facilityDetails','admin'=>true));?>';
								//fetchstaticModal($facilityDetails,thefacilityD);
							}
						});
						
					});
				
			$businessModal.on('click','.submitbankForm',function(){
				var formID = '#bankDForm';
				var modalName  = 'BankDetail';
				var updateVal = 'bank_detail';
				onsubmitAction($businessModal,updateURL,formID,modalName,updateVal);
			});
					
			$businessDetails.on('click','.submitContactForm',function(){
					var formID = '#opeaningContactForm';
					var modalName  = 'User';
					var updateVal = 'business_detail';
					var options = { 
							success:function(res){
									if(onResponse($businessDetails,modalName,res)){
										
									}
							}
					}; 
					$(formID).submit(function(){
							$(this).ajaxSubmit(options);
							$(this).unbind('submit');
							$(this).bind('submit');
							return false;
					});
					
				});
				
			$businessDetails.on('click','.skipContactForm',function(e){
				e.preventDefault();
				$.ajax({url:updateURL,type:'POST',data: {update:'verify_done'} });	
				$businessDetails.modal('toggle');
			});		
			
			$verifyEmail.on('click','.vEmailForm',function(){
				var formID = '#vEmailForm';
				var modalName  = 'User';
				var options = { 
						success:function(res){
								if(onResponse($verifyEmail,modalName,res)){
									
								}
						}
				}; 
				$(formID).submit(function(){
						$(this).ajaxSubmit(options);
						$(this).unbind('submit');
						$(this).bind('submit');
						return false;
				});
				
			});
				
			$verifyPhone.on('click','.vPhonebtn',function(){
				var formID = '#vPhoneForm';
				var modalName  = 'User';
				var options = { 
						success:function(res){
								if(onResponse($verifyPhone,modalName,res)){
									
								}
						}
				}; 
				$(formID).submit(function(){
						$(this).ajaxSubmit(options);
						$(this).unbind('submit');
						$(this).bind('submit');
						return false;
				});
				
			});
		
			$verifyDone.on('click','.locationbtnForm',function(e){
				e.preventDefault();
				var locvalues = $verifyDone.find('#locationbtnForm').serialize();
				var actionURL = $verifyDone.find('#locationbtnForm').attr('action');
				$.ajax({url:actionURL,type:'POST',data: {data:JSON.stringify(locvalues)} }).done(function(res){
					if(onResponse($verifyDone,'Address',res)){
						$.ajax({url:updateURL,type:'POST',data: {update:'business_map'} });
						$verifyDone.modal('toggle');
					}
					
				});	
			});
				
		
		<?php
		}
		elseif($tokkn == 'bank_detail' ){ ?>
				var $businessDetails = $(document).find('#commonSmallModal');
				$(window).load(function(){
						$(document).find('.loader-container').show();
						var theOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_details','admin'=>true));?>';
						fetchstaticModal($businessDetails,theOH);
				});
				
					var $publicPhoto = $publicVideo = $venueVideo = $venueImg = $userCover = $selectpriceduration = $selectService = $bookingIncharge  = $staffCreation  =  $facilityDetails =  $verifyPhone = $verifyDone = $verifyEmail = $(document).find('#commonVendorModal');//13-14
					$(document).on('hidden.bs.modal', function() { 
						$(document).find('.loader-container').show();
						$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
							if(msg == 'verify_done'){
								var thevDONE = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_map','admin'=>true));?>';
								fetchstaticModal($verifyDone,thevDONE);		
							}else if(msg == 'verify_e'){
								var thevEmail = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_email','admin'=>true));?>';
								fetchstaticModal($verifyEmail,thevEmail);	
							}else if(msg == 'verify_e_p'){
								var thevEmail = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_email','admin'=>true));?>';
								fetchstaticModal($verifyEmail,thevEmail);	
							}else if(msg == 'verify_p'){
								var thevPhone = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_phone','admin'=>true));?>';
								fetchstaticModal($verifyPhone,thevPhone);	
							}else if(msg == 'business_map'){
								window.location.reload();
								//var thefacilityD = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'facilityDetails','admin'=>true));?>';
								//fetchstaticModal($facilityDetails,thefacilityD);
							}
						});
						
					});
				
				
			
			$businessDetails.on('click','.submitContactForm',function(){
					var formID = '#opeaningContactForm';
					var modalName  = 'User';
					var updateVal = 'business_detail';
					var options = { 
							success:function(res){
									if(onResponse($businessDetails,modalName,res)){
										
									}
							}
					}; 
					$(formID).submit(function(){
							$(this).ajaxSubmit(options);
							$(this).unbind('submit');
							$(this).bind('submit');
							return false;
					});
					
				});
				
			$businessDetails.on('click','.skipContactForm',function(e){
				e.preventDefault();
				$.ajax({url:updateURL,type:'POST',data: {update:'verify_done'} });	
				$businessDetails.modal('toggle');
			});		
			
			$verifyEmail.on('click','.vEmailForm',function(){
				var formID = '#vEmailForm';
				var modalName  = 'User';
				var options = { 
						success:function(res){
								if(onResponse($verifyEmail,modalName,res)){
									
								}
						}
				}; 
				$(formID).submit(function(){
						$(this).ajaxSubmit(options);
						$(this).unbind('submit');
						$(this).bind('submit');
						return false;
				});
				
			});
				
			$verifyPhone.on('click','.vPhonebtn',function(){
				var formID = '#vPhoneForm';
				var modalName  = 'User';
				var options = { 
						success:function(res){
								if(onResponse($verifyPhone,modalName,res)){
									
								}
						}
				}; 
				$(formID).submit(function(){
						$(this).ajaxSubmit(options);
						$(this).unbind('submit');
						$(this).bind('submit');
						return false;
				});
				
			});
		
			$verifyDone.on('click','.locationbtnForm',function(e){
				e.preventDefault();
				var locvalues = $verifyDone.find('#locationbtnForm').serialize();
				var actionURL = $verifyDone.find('#locationbtnForm').attr('action');
				$.ajax({url:actionURL,type:'POST',data: {data:JSON.stringify(locvalues)} }).done(function(res){
					if(onResponse($verifyDone,'Address',res)){
						$.ajax({url:updateURL,type:'POST',data: {update:'business_map'} });
						$verifyDone.modal('toggle');
					}
					
				});	
			});
				
				
		<?php 	
		}
		elseif (strpos($tokkn,'verify_e') !== false) { ?>
			var $verifyEmail = $(document).find('#commonVendorModal');
			$(window).load(function(){
					$(document).find('.loader-container').show();
					var theOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_email','admin'=>true));?>';
					fetchstaticModal($verifyEmail,theOH);
			});
			
			var $publicPhoto = $publicVideo = $venueVideo = $venueImg = $userCover = $selectpriceduration = $selectService = $bookingIncharge  = $staffCreation  =  $facilityDetails =  $verifyDone =  $verifyPhone  = $(document).find('#commonVendorModal'); //12-12
			$(document).on('hidden.bs.modal', function() { 
				$(document).find('.loader-container').show();
				$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
					if(msg == 'verify_done'){
						var thevDONE = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_map','admin'=>true));?>';
						fetchstaticModal($verifyDone,thevDONE);		
					}else if(msg == 'verify_p'){
						var thevPhone = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_phone','admin'=>true));?>';
						fetchstaticModal($verifyPhone,thevPhone);	
					}else if(msg == 'business_map'){
						window.location.reload();
						//var thefacilityD = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'facilityDetails','admin'=>true));?>';
						//fetchstaticModal($facilityDetails,thefacilityD);
					}
				});
				
			});
			
			$verifyEmail.on('click','.vEmailForm',function(){
					var formID = '#vEmailForm';
					var modalName  = 'User';
					var options = { 
							success:function(res){
									if(onResponse($verifyEmail,modalName,res)){
										
									}
							}
					}; 
					$(formID).submit(function(){
							$(this).ajaxSubmit(options);
							$(this).unbind('submit');
							$(this).bind('submit');
							return false;
					});
					
				});
				
			$verifyPhone.on('click','.vPhonebtn',function(){
				var formID = '#vPhoneForm';
				var modalName  = 'User';
				var options = { 
						success:function(res){
								if(onResponse($verifyPhone,modalName,res)){
									
								}
						}
				}; 
				$(formID).submit(function(){
						$(this).ajaxSubmit(options);
						$(this).unbind('submit');
						$(this).bind('submit');
						return false;
				});
				
			});
		
			$verifyDone.on('click','.locationbtnForm',function(e){
				e.preventDefault();
				var locvalues = $verifyDone.find('#locationbtnForm').serialize();
				var actionURL = $verifyDone.find('#locationbtnForm').attr('action');
				$.ajax({url:actionURL,type:'POST',data: {data:JSON.stringify(locvalues)} }).done(function(res){
					if(onResponse($verifyDone,'Address',res)){
						$.ajax({url:updateURL,type:'POST',data: {update:'business_map'} });
						$verifyDone.modal('toggle');
					}
				});	
			});
				
			
		
		<?php
		}
		elseif (strpos($tokkn,'verify_p') !== false) { ?>
			var $verifyPhone = $(document).find('#commonVendorModal');
			$(window).load(function(){
					$(document).find('.loader-container').show();
					var theOH = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'verify_phone','admin'=>true));?>';
					fetchstaticModal($verifyPhone,theOH);
			});
			
			
				var $publicPhoto = $publicVideo = $venueVideo = $venueImg = $userCover = $selectpriceduration = $selectService = $bookingIncharge  = $staffCreation  =  $facilityDetails =  $verifyDone = $(document).find('#commonVendorModal');
					$(document).on('hidden.bs.modal', function() { 
						$(document).find('.loader-container').show();
						$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
							if(msg == 'verify_done'){
								var thevDONE = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_map','admin'=>true));?>';
								fetchstaticModal($verifyDone,thevDONE);		
							}else if(msg == 'business_map'){
								window.location.reload();
								//var thefacilityD = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'facilityDetails','admin'=>true));?>';
								//fetchstaticModal($facilityDetails,thefacilityD);
							}
						});
						
					});
			
				$verifyPhone.on('click','.vPhonebtn',function(){
					var formID = '#vPhoneForm';
					var modalName  = 'User';
					var options = { 
							success:function(res){
									if(onResponse($verifyPhone,modalName,res)){
										
									}
							}
					}; 
					$(formID).submit(function(){
							$(this).ajaxSubmit(options);
							$(this).unbind('submit');
							$(this).bind('submit');
							return false;
					});
					
				});
			
				$verifyDone.on('click','.locationbtnForm',function(e){
					e.preventDefault();
					var locvalues = $verifyDone.find('#locationbtnForm').serialize();
					var actionURL = $verifyDone.find('#locationbtnForm').attr('action');
					$.ajax({url:actionURL,type:'POST',data: {data:JSON.stringify(locvalues)} }).done(function(res){
						if(onResponse($verifyDone,'Address',res)){
							$.ajax({url:updateURL,type:'POST',data: {update:'business_map'} });
							$verifyDone.modal('toggle');
						}
						
					});	
				});
			

				
			
		
		<?php
		}
		elseif ($tokkn == 'verify_done') { ?>
			
			var $verifyDone = $(document).find('#commonVendorModal');
			$(window).load(function(){
					$(document).find('.loader-container').show();
					var mapURL = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'business_map','admin'=>true));?>';
					fetchstaticModal($verifyDone,mapURL);
			});
			
				var $publicPhoto = $publicVideo = $venueVideo = $venueImg = $userCover = $selectpriceduration = $selectService = $bookingIncharge  = $staffCreation  =  $facilityDetails = $(document).find('#commonVendorModal');
				$(document).on('hidden.bs.modal', function() { 
					$(document).find('.loader-container').show();
					$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
						if(msg == 'business_map'){
							window.location.reload();
							//var thefacilityD = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'facilityDetails','admin'=>true));?>';
							//fetchstaticModal($facilityDetails,thefacilityD);
						}
					});
					
				});
					
			//$verifyDone
			$(document).on('click','.locationbtnForm',function(e){
				e.preventDefault();
				var locvalues = $verifyDone.find('#locationbtnForm').serialize();
				var actionURL = $verifyDone.find('#locationbtnForm').attr('action');
				$.ajax({url:actionURL,type:'POST',data: {data:JSON.stringify(locvalues)} }).done(function(res){
					if(onResponse($verifyDone,'Address',res)){
						$.ajax({url:updateURL,type:'POST',data: {update:'business_map'} });
						$verifyDone.modal('toggle');
					}
					
				});	
			});
				
		
		<?php
		}
		elseif ($tokkn == 'business_map') { ?>
			var $facilityDetails  = $(document).find('#commonVendorModal');
			$(window).load(function(){
					$(document).find('.loader-container').show();
					var thefacilityD = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'facilityDetails','admin'=>true));?>';
					fetchstaticModal($facilityDetails,thefacilityD);	
			});
			
			
			var $publicPhoto = $publicVideo = $venueVideo = $venueImg = $userCover = $selectpriceduration = $selectService = $bookingIncharge  = $staffCreation  = $(document).find('#commonVendorModal');
			$(document).on('hidden.bs.modal', function() { 
				$(document).find('.loader-container').show();
				$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
					if(msg == 'facility_detail'){
						var thestaff = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'addingStaff','admin'=>true));?>';
						fetchstaticModal($staffCreation,thestaff);	
					}else if(msg == 'add_staff'){
						var theBokIncstaff = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'bookingIncharge','admin'=>true));?>';
						fetchstaticModal($bookingIncharge,theBokIncstaff);	
					}else if(msg == 'booking_incharge'){
						var theservice = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'select_service','admin'=>true));?>';
						fetchstaticModal($selectService,theservice);
					}else if(msg == 'select_service'){
						var theservice = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'set_priceduration','admin'=>true));?>';
						fetchstaticModal($selectpriceduration,theservice);
					}else if(msg == 'treatment_setting'){
						var theuPic = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'set_userphotos','admin'=>true));?>';
						fetchstaticModal($userCover,theuPic);
					}else if(msg == 'profile_images'){
						window.location.reload();
						//var venuImg = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'venue_images','admin'=>true));?>';
						//fetchstaticModal($venueImg,venuImg);
					}
				});
			});
			
			
			//$facilityDetails
			$(document).on('click','.facilityDetailForm',function(){
				var formID = '#facilityDetailForm';
				var modalName  = 'FacilityDetail';
				var updateVal = 'facility_detail';
				onsubmitAction($facilityDetails,updateURL,formID,modalName,updateVal);
			});
			//$staffCreation
			$(document).on('click','.submitStaffForm',function(){
				var listTxt = $staffCreation.find('.staffListBox').find('div').length;
				if(listTxt > 0){
					$.ajax({url:updateURL,type:'POST',data: {update:'add_staff'} });
					$staffCreation.modal('toggle');
				}
				else{
					alert("Please add Staff");
				}
			});
			
			//$bookingIncharge
			$(document).on('click','.submitbookingInchargeForm',function(){
				var formID = '#submitbookingInchargeForm';
				var modalName  = 'User';
				var updateVal = 'booking_incharge';
				onsubmitAction($bookingIncharge,updateURL,formID,modalName,updateVal);
			});
			
			//$selectService
			$(document).on('click', '.submitSelectForm', function(e){
				var formID = '#serviceSelectForm';
				var modalName  = 'Service';
				var updateVal = 'select_service';
				onsubmitAction($selectService,updateURL,formID,modalName,updateVal);
			});
			//$selectpriceduration
			$(document).on('click', '.treatmentsettingForm', function(e){
				jQuery.validator.addClassRules({
					"servicePrice": {
						required: true,
						number: true,
					},
					"serviceDuration": {
						required: true,
					}
					
				});
				if($selectpriceduration.find('#treatmentsettingForm').valid()){
					var formID = '#treatmentsettingForm';
					var modalName  = 'Service';
					var updateVal = 'treatment_setting';
					onsubmitAction($selectpriceduration,updateURL,formID,modalName,updateVal);
				}
			});
		
			//$userCover
			$(document).on('click', '.submitImgeForm', function(e){
				var theIMG = $userCover.find('#submitImgeForm').find('.logoImage').val();
				if(theIMG){
					var formID = '#submitImgeForm';
					var modalName  = 'User';
					var updateVal = 'profile_images';
					onsubmitAction($userCover,updateURL,formID,modalName,updateVal);
				}
				else{
					alert('Please Select Profile Image');
					return false;
				}
			});
			
		
		<?php }
		elseif ($tokkn == 'facility_detail') { ?>
			var $staffCreation  = $(document).find('#commonVendorModal');
			$(window).load(function(){
					$(document).find('.loader-container').show();
					var thestaff = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'addingStaff','admin'=>true));?>';
					fetchstaticModal($staffCreation,thestaff);	
			});
			
			
			var $publicPhoto = $publicVideo = $venueVideo = $venueImg = $userCover = $selectpriceduration = $selectService = $bookingIncharge  = $(document).find('#commonVendorModal');
			$(document).on('hidden.bs.modal', function() { 
				$(document).find('.loader-container').show();
				$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
					if(msg == 'add_staff'){
						var theBokIncstaff = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'bookingIncharge','admin'=>true));?>';
						fetchstaticModal($bookingIncharge,theBokIncstaff);	
					}else if(msg == 'booking_incharge'){
						var theservice = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'select_service','admin'=>true));?>';
						fetchstaticModal($selectService,theservice);
					}else if(msg == 'select_service'){
						var theservice = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'set_priceduration','admin'=>true));?>';
						fetchstaticModal($selectpriceduration,theservice);
					}else if(msg == 'treatment_setting'){
						var theuPic = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'set_userphotos','admin'=>true));?>';
						fetchstaticModal($userCover,theuPic);
					}else if(msg == 'profile_images'){
						window.location.reload();
						//var venuImg = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'venue_images','admin'=>true));?>';
						//fetchstaticModal($venueImg,venuImg);
					}
				});
			});
			
			
			//$staffCreation
			$(document).on('click','.submitStaffForm',function(){
				var listTxt = $staffCreation.find('.staffListBox').find('div').length;
				if(listTxt > 0){
					$.ajax({url:updateURL,type:'POST',data: {update:'add_staff'} });
					$staffCreation.modal('toggle');
				}
				else{
					alert("Please add Staff");
				}
			});
			
			//$bookingIncharge
			$(document).on('click','.submitbookingInchargeForm',function(){
				var formID = '#submitbookingInchargeForm';
				var modalName  = 'User';
				var updateVal = 'booking_incharge';
				onsubmitAction($bookingIncharge,updateURL,formID,modalName,updateVal);
			});
			
			//$selectService
			$(document).on('click', '.submitSelectForm', function(e){
				var formID = '#serviceSelectForm';
				var modalName  = 'Service';
				var updateVal = 'select_service';
				onsubmitAction($selectService,updateURL,formID,modalName,updateVal);
			});
			//$selectpriceduration
			$(document).on('click', '.treatmentsettingForm', function(e){
				jQuery.validator.addClassRules({
					"servicePrice": {
						required: true,
						number: true,
					},
					"serviceDuration": {
						required: true,
					}
					
				});
				if($selectpriceduration.find('#treatmentsettingForm').valid()){
					var formID = '#treatmentsettingForm';
					var modalName  = 'Service';
					var updateVal = 'treatment_setting';
					onsubmitAction($selectpriceduration,updateURL,formID,modalName,updateVal);
				}
			});
		
			//$userCover.
			$(document).on('click', '.submitImgeForm', function(e){
				var theIMG = $userCover.find('#submitImgeForm').find('.logoImage').val();
				if(theIMG){
					var formID = '#submitImgeForm';
					var modalName  = 'User';
					var updateVal = 'profile_images';
					onsubmitAction($userCover,updateURL,formID,modalName,updateVal);
				}
				else{
					alert('Please Select Profile Image');
					return false;
				}
			});
			
		
		<?php }
		elseif ($tokkn == 'add_staff') { ?>
			var $bookingIncharge  = $(document).find('#commonVendorModal');
			$(window).load(function(){
					$(document).find('.loader-container').show();
					var thestaff = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'bookingIncharge','admin'=>true));?>';
					fetchstaticModal($bookingIncharge,thestaff);	
			});
			
			var $publicPhoto = $publicVideo = $venueVideo = $venueImg = $userCover = $selectpriceduration = $selectService = $(document).find('#commonVendorModal');
			$(document).on('hidden.bs.modal', function() { 
				$(document).find('.loader-container').show();
				$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
					if(msg == 'booking_incharge'){
						var theservice = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'select_service','admin'=>true));?>';
						fetchstaticModal($selectService,theservice);
					}else if(msg == 'select_service'){
						var theservice = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'set_priceduration','admin'=>true));?>';
						fetchstaticModal($selectpriceduration,theservice);
					}else if(msg == 'treatment_setting'){
						var theuPic = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'set_userphotos','admin'=>true));?>';
						fetchstaticModal($userCover,theuPic);
					}else if(msg == 'profile_images'){
						window.location.reload();
						//var venuImg = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'venue_images','admin'=>true));?>';
						//fetchstaticModal($venueImg,venuImg);
					}
				});
			});
			
			//$bookingIncharge
			$(document).on('click','.submitbookingInchargeForm',function(){
				var formID = '#submitbookingInchargeForm';
				var modalName  = 'User';
				var updateVal = 'booking_incharge';
				onsubmitAction($bookingIncharge,updateURL,formID,modalName,updateVal);
			});
			
			//$selectService
			$(document).on('click', '.submitSelectForm', function(e){
				var formID = '#serviceSelectForm';
				var modalName  = 'Service';
				var updateVal = 'select_service';
				onsubmitAction($selectService,updateURL,formID,modalName,updateVal);
			});
			//$selectpriceduration.
			$(document).on('click', '.treatmentsettingForm', function(e){
				jQuery.validator.addClassRules({
					"servicePrice": {
						required: true,
						number: true,
					},
					"serviceDuration": {
						required: true,
					}
					
				});
				if($selectpriceduration.find('#treatmentsettingForm').valid()){
					var formID = '#treatmentsettingForm';
					var modalName  = 'Service';
					var updateVal = 'treatment_setting';
					onsubmitAction($selectpriceduration,updateURL,formID,modalName,updateVal);
				}
			});
		
			//$userCover.
			$(document).on('click', '.submitImgeForm', function(e){
				var theIMG = $userCover.find('#submitImgeForm').find('.logoImage').val();
				if(theIMG){
					var formID = '#submitImgeForm';
					var modalName  = 'User';
					var updateVal = 'profile_images';
					onsubmitAction($userCover,updateURL,formID,modalName,updateVal);
				}
				else{
					alert('Please Select Profile Image');
					return false;
				}
			});
			
			
		<?php }
		elseif ($tokkn == 'booking_incharge') { ?>
			var $selectService = $(document).find('#commonVendorModal');
			$(window).load(function(){
					$(document).find('.loader-container').show();
					var theservice = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'select_service','admin'=>true));?>';
					fetchstaticModal($selectService,theservice);	
			});
			
			var $publicPhoto = $publicVideo = $venueVideo = $venueImg = $userCover = $selectpriceduration = $(document).find('#commonVendorModal');
			$(document).on('hidden.bs.modal', function() { 
				$(document).find('.loader-container').show();
					$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
						if(msg == 'select_service'){
							var theservice = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'set_priceduration','admin'=>true));?>';
							fetchstaticModal($selectpriceduration,theservice);
						}else if(msg == 'treatment_setting'){
							var theuPic = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'set_userphotos','admin'=>true));?>';
							fetchstaticModal($userCover,theuPic);
						}else if(msg == 'profile_images'){
							window.location.reload();
							//var venuImg = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'venue_images','admin'=>true));?>';
							//fetchstaticModal($venueImg,venuImg);
						}
					});
			});
			
			
			//$selectService
			$(document).on('click', '.submitSelectForm', function(e){
				var formID = '#serviceSelectForm';
				var modalName  = 'Service';
				var updateVal = 'select_service';
				onsubmitAction($selectService,updateURL,formID,modalName,updateVal);
			});
			//$selectpriceduration.
			$(document).on('click', '.treatmentsettingForm', function(e){
				jQuery.validator.addClassRules({
					"servicePrice": {
						required: true,
						number: true,
					},
					"serviceDuration": {
						required: true,
					}
					
				});
				if($selectpriceduration.find('#treatmentsettingForm').valid()){
					var formID = '#treatmentsettingForm';
					var modalName  = 'Service';
					var updateVal = 'treatment_setting';
					onsubmitAction($selectpriceduration,updateURL,formID,modalName,updateVal);
				}
			});
		
			//$userCover.
			$(document).on('click', '.submitImgeForm', function(e){
				var theIMG = $userCover.find('#submitImgeForm').find('.logoImage').val();
				if(theIMG){
					var formID = '#submitImgeForm';
					var modalName  = 'User';
					var updateVal = 'profile_images';
					onsubmitAction($userCover,updateURL,formID,modalName,updateVal);
				}
				else{
					alert('Please Select Profile Image');
					return false;
				}
			});
			
		
		<?php }
		elseif ($tokkn == 'select_service') { ?>
			var $selectpriceduration = $(document).find('#commonVendorModal');
			$(window).load(function(){
					$(document).find('.loader-container').show();
					var thesPD = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'set_priceduration','admin'=>true));?>';
					fetchstaticModal($selectpriceduration,thesPD);	
			});
			
			
			var $publicPhoto = $publicVideo = $venueVideo = $venueImg = $userCover = $(document).find('#commonVendorModal');
			$(document).on('hidden.bs.modal', function() { 
				$(document).find('.loader-container').show();
					$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
						if(msg == 'treatment_setting'){
							var theuPic = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'set_userphotos','admin'=>true));?>';
							fetchstaticModal($userCover,theuPic);
						}else if(msg == 'profile_images'){
							window.location.reload();
							//var venuImg = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'venue_images','admin'=>true));?>';
							//fetchstaticModal($venueImg,venuImg);
						}
					});
			});
			
			
			//$selectpriceduration.
			$(document).on('click', '.treatmentsettingForm', function(e){
				jQuery.validator.addClassRules({
					"servicePrice": {
						required: true,
						number: true,
					},
					"serviceDuration": {
						required: true,
					}
					
				});
				if($selectpriceduration.find('#treatmentsettingForm').valid()){
					var formID = '#treatmentsettingForm';
					var modalName  = 'Service';
					var updateVal = 'treatment_setting';
					onsubmitAction($selectpriceduration,updateURL,formID,modalName,updateVal);
				}
			});
		
			//$userCover
			$(document).on('click', '.submitImgeForm', function(e){
				var theIMG = $userCover.find('#submitImgeForm').find('.logoImage').val();
				if(theIMG){
					var formID = '#submitImgeForm';
					var modalName  = 'User';
					var updateVal = 'profile_images';
					onsubmitAction($userCover,updateURL,formID,modalName,updateVal);
				}
				else{
					alert('Please Select Profile Image');
					return false;
				}
			});
			
			
			
		
		<?php }
		elseif ($tokkn == 'treatment_setting') { ?>
			var $userCover = $(document).find('#commonVendorModal');
			$(window).load(function(){
					$(document).find('.loader-container').show();
					var theuPic = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'set_userphotos','admin'=>true));?>';
					fetchstaticModal($userCover,theuPic);	
			});
			
			
			var $publicPhoto = $publicVideo = $venueVideo = $venueImg = $(document).find('#commonVendorModal');
			$(document).on('hidden.bs.modal', function() { 
				$(document).find('.loader-container').show();
					$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
						if(msg == 'profile_images'){
							window.location.reload();
							//var venuImg = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'venue_images','admin'=>true));?>';
							//fetchstaticModal($venueImg,venuImg);
						}
					});
			});
			
			
			$userCover.on('click', '.submitImgeForm', function(e){
				var theIMG = $userCover.find('#submitImgeForm').find('.logoImage').val();
				if(theIMG){
					var formID = '#submitImgeForm';
					var modalName  = 'User';
					var updateVal = 'profile_images';
					onsubmitAction($userCover,updateURL,formID,modalName,updateVal);
				}
				else{
					alert('Please Select Profile Image');
					return false;
				}
			});
			
		
		<?php }
		elseif ($tokkn == 'profile_images') { ?>
			var $venueImg = $(document).find('#commonVendorModal');
			$(window).load(function(){
					$(document).find('.loader-container').show();
					var venuImg = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'venue_images','admin'=>true));?>';
					fetchstaticModal($venueImg,venuImg);
			});
			
			var $publicPhoto = $publicVideo = $venueVideo = $(document).find('#commonVendorModal');
			$(document).on('hidden.bs.modal', function() { 
				$(document).find('.loader-container').show();
					$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
						if(msg == 'venue_image'){
							var venuVideo = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'venue_video','admin'=>true));?>';
							fetchstaticModal($venueVideo,venuVideo);
						}else if(msg == 'venue_video'){
							var publicPhoto = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'public_photo','admin'=>true));?>';
							fetchstaticModal($publicPhoto,publicPhoto);
						}else if(msg == 'album_image'){
							var publicVideo = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'public_video','admin'=>true));?>';
							fetchstaticModal($publicVideo,publicVideo);
						}
						
					});
			});
			
			$venueVideo.off('click').on('click','.addMore',function(){
				var theData =  $(document).find( "div.frm-grp" ).find('div.form-group:first').clone();
				theData.find('input').val('');
				theData.find('div.addremove').append('<a href="javascript:void(0);" class="removeURL"><i class="fa  fa-minus    "></i></a>');
				$(document).find('div.frm-grp').append('<div class="form-group clearfix">'+theData.html()+'</div>');
			});
			$venueVideo.on('click','.addthatURL',function(){
				var youURL = $(this).closest('div.form-group').find('input').val();
				if(youURL){
					if(parseYouTube(youURL)){
						$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'venue_video','admin'=>true));?>',type:'POST',data: {URL:youURL} })
						.done(function(res){
							if(res == 'e'){
								alert('Youtube link already Exist!');
							}
							else if(res == 'f'){
								alert('Error in saving!');
							}
							else{
								if(res != 's'){
								var appenddata = '<li><a href="#"><img src="'+res+'" > </a><div class="extras"><div class="extras-inner"><a href="'+youURL+'" class="youtube" target="_blank" rel="group-1"><i class="icon-search"></i></a></div></div></li>';
								$venueVideo.find('div.youtubeall ul').append(appenddata);
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
			
			$venueVideo.on('click','.removeURL',function(){
				if(confirm('Are you sure to Delete')){
					$(this).closest('div.form-group').remove();
				}
			});
			
			//$venueVideo.
			$(document).on('click','.submitVideoForm',function(e){
				e.preventDefault();
				$.ajax({url:updateURL,type:'POST',data: {update:'venue_video'} });	
				$venueVideo.modal('toggle');
			});
			
			
			
			
			$publicVideo.off('click').on('click','.addMore',function(){
				var theData =  $(document).find( "div.frm-grp" ).find('div.form-group:first').clone();
				theData.find('input').val('');
				theData.find('div.addremove').append('<a href="javascript:void(0);" class="removeURL"><i class="fa  fa-minus    "></i></a>');
				$(document).find('div.frm-grp').append('<div class="form-group clearfix">'+theData.html()+'</div>');
			});
			$publicVideo.on('click','.addthatURL',function(){
				var youURL = $(this).closest('div.form-group').find('input').val();
				if(youURL){
					if(parseYouTube(youURL)){
						$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'public_video','admin'=>true));?>',type:'POST',data: {URL:youURL} })
						.done(function(res){
							if(res == 'e'){
								alert('Youtube link already Exist!');
							}
							else if(res == 'f'){
								alert('Error in saving!');
							}
							else{
								if(res != 's'){
								var appenddata = '<li><a href="#"><img src="'+res+'" > </a><div class="extras"><div class="extras-inner"><a href="'+youURL+'" class="youtube" target="_blank" rel="group-1"><i class="icon-search"></i></a></div></div></li>';
								$publicVideo.find('div.youtubeall ul').append(appenddata);
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
			
			$publicVideo.on('click','.removeURL',function(){
				if(confirm('Are you sure to Delete')){
					$(this).closest('div.form-group').remove();
				}
			});
			
			//$publicVideo.
			$(document).on('click','.submitAlbVdoForm',function(e){
				e.preventDefault();
				$.ajax({url:updateURL,type:'POST',data: {update:'done'} });	
				$publicVideo.modal('toggle');
				window.location.reload();
			});
			
		
                        
		
			
		
		<?php }
		elseif ($tokkn == 'venue_image') { ?>
			var $venueVideo = $(document).find('#commonVendorModal');
			$(window).load(function(){
				$(document).find('.loader-container').show();
				var venuVideo = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'venue_video','admin'=>true));?>';
				fetchstaticModal($venueVideo,venuVideo);
			});
			
			var $publicPhoto = $publicVideo = $(document).find('#commonVendorModal');
			$(document).on('hidden.bs.modal', function() { 
				$(document).find('.loader-container').show();
					$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
						if(msg == 'venue_video'){
							var publicPhoto = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'public_photo','admin'=>true));?>';
							fetchstaticModal($publicPhoto,publicPhoto);
						}else if(msg == 'album_image'){
							var publicVideo = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'public_video','admin'=>true));?>';
							fetchstaticModal($publicVideo,publicVideo);
						}
					});
			});
			
			$venueVideo.off('click').on('click','.addMore',function(){
				var theData =  $(document).find( "div.frm-grp" ).find('div.form-group:first').clone();
				theData.find('input').val('');
				theData.find('div.addremove').append('<a href="javascript:void(0);" class="removeURL"><i class="fa  fa-minus    "></i></a>');
				$(document).find('div.frm-grp').append('<div class="form-group clearfix">'+theData.html()+'</div>');
			});
			$venueVideo.on('click','.addthatURL',function(){
				var youURL = $(this).closest('div.form-group').find('input').val();
				if(youURL){
					if(parseYouTube(youURL)){
						$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'venue_video','admin'=>true));?>',type:'POST',data: {URL:youURL} })
						.done(function(res){
							if(res == 'e'){
								alert('Youtube link already Exist!');
							}
							else if(res == 'f'){
								alert('Error in saving!');
							}
							else{
								if(res != 's'){
								var appenddata = '<li><a href="#"><img src="'+res+'" > </a><div class="extras"><div class="extras-inner"><a href="'+youURL+'" class="youtube" target="_blank" rel="group-1"><i class="icon-search"></i></a></div></div></li>';
								$venueVideo.find('div.youtubeall ul').append(appenddata);
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
			
			$venueVideo.on('click','.removeURL',function(){
				if(confirm('Are you sure to Delete')){
					$(this).closest('div.form-group').remove();
				}
			});
			
			//$venueVideo.
			$(document).on('click','.submitVideoForm',function(e){
				e.preventDefault();
				$.ajax({url:updateURL,type:'POST',data: {update:'venue_video'} });	
				$venueVideo.modal('toggle');
			});
			
			
			
			
			$publicVideo.off('click').on('click','.addMore',function(){
				var theData =  $(document).find( "div.frm-grp" ).find('div.form-group:first').clone();
				theData.find('input').val('');
				theData.find('div.addremove').append('<a href="javascript:void(0);" class="removeURL"><i class="fa  fa-minus    "></i></a>');
				$(document).find('div.frm-grp').append('<div class="form-group clearfix">'+theData.html()+'</div>');
			});
			$publicVideo.on('click','.addthatURL',function(){
				var youURL = $(this).closest('div.form-group').find('input').val();
				if(youURL){
					if(parseYouTube(youURL)){
						$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'public_video','admin'=>true));?>',type:'POST',data: {URL:youURL} })
						.done(function(res){
							if(res == 'e'){
								alert('Youtube link already Exist!');
							}
							else if(res == 'f'){
								alert('Error in saving!');
							}
							else{
								if(res != 's'){
								var appenddata = '<li><a href="#"><img src="'+res+'" > </a><div class="extras"><div class="extras-inner"><a href="'+youURL+'" class="youtube" target="_blank" rel="group-1"><i class="icon-search"></i></a></div></div></li>';
								$publicVideo.find('div.youtubeall ul').append(appenddata);
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
			
			$publicVideo.on('click','.removeURL',function(){
				if(confirm('Are you sure to Delete')){
					$(this).closest('div.form-group').remove();
				}
			});
			
			//$publicVideo.
			$(document).on('click','.submitAlbVdoForm',function(e){
				e.preventDefault();
				$.ajax({url:updateURL,type:'POST',data: {update:'done'} })
				.done(function(){
					$publicVideo.modal('toggle');
					window.location.reload();
				});
			});
			
		
                        
		
		<?php }
		elseif ($tokkn == 'venue_video') { ?>
			var $publicPhoto = $(document).find('#commonVendorModal');
			$(window).load(function(){
				$(document).find('.loader-container').show();
				var publicPhoto = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'public_photo','admin'=>true));?>';
				fetchstaticModal($publicPhoto,publicPhoto);
				
				
			});
			
			
			var $publicVideo = $(document).find('#commonVendorModal');
			$(document).on('hidden.bs.modal', function() { 
				$(document).find('.loader-container').show();
					$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'get_popup_status','admin'=>true));?>',type:'GET'}).done(function(msg){
						if(msg == 'album_image'){
							var publicVideo = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'public_video','admin'=>true));?>';
							fetchstaticModal($publicVideo,publicVideo);
						}
					});
			});
			
			$publicVideo.off('click').on('click','.addMore',function(){
				var theData =  $(document).find( "div.frm-grp" ).find('div.form-group:first').clone();
				theData.find('input').val('');
				theData.find('div.addremove').append('<a href="javascript:void(0);" class="removeURL"><i class="fa  fa-minus    "></i></a>');
				$(document).find('div.frm-grp').append('<div class="form-group clearfix">'+theData.html()+'</div>');
			});
			$publicVideo.on('click','.addthatURL',function(){
				var youURL = $(this).closest('div.form-group').find('input').val();
				if(youURL){
					if(parseYouTube(youURL)){
						$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'public_video','admin'=>true));?>',type:'POST',data: {URL:youURL} })
						.done(function(res){
							if(res == 'e'){
								alert('Youtube link already Exist!');
							}
							else if(res == 'f'){
								alert('Error in saving!');
							}
							else{
								if(res != 's'){
								var appenddata = '<li><a href="#"><img src="'+res+'" > </a><div class="extras"><div class="extras-inner"><a href="'+youURL+'" class="youtube" target="_blank" rel="group-1"><i class="icon-search"></i></a></div></div></li>';
								$publicVideo.find('div.youtubeall ul').append(appenddata);
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
			
			$publicVideo.on('click','.removeURL',function(){
				if(confirm('Are you sure to Delete')){
					$(this).closest('div.form-group').remove();
				}
			});
			
			//$publicVideo.
			$(document).on('click','.submitAlbVdoForm',function(e){
				e.preventDefault();
				$.ajax({url:updateURL,type:'POST',data: {update:'done'} })
				.done(function(){
					$publicVideo.modal('toggle');
					window.location.reload();
				});
			});
			
		
		<?php }
		elseif ($tokkn == 'album_image') { ?>
			var $publicVideo = $(document).find('#commonVendorModal');
			$(window).load(function(){
				$(document).find('.loader-container').show();
				var publicVideo = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'public_video','admin'=>true));?>';
				fetchstaticModal($publicVideo,publicVideo);
			});
			
			
			
			$publicVideo.off('click').on('click','.addMore',function(){
				var theData =  $(document).find( "div.frm-grp" ).find('div.form-group:first').clone();
				theData.find('input').val('');
				theData.find('div.addremove').append('<a href="javascript:void(0);" class="removeURL"><i class="fa  fa-minus    "></i></a>');
				$(document).find('div.frm-grp').append('<div class="form-group clearfix">'+theData.html()+'</div>');
			});
			$publicVideo.on('click','.addthatURL',function(){
				var youURL = $(this).closest('div.form-group').find('input').val();
				if(youURL){
					if(parseYouTube(youURL)){
						$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'public_video','admin'=>true));?>',type:'POST',data: {URL:youURL} })
						.done(function(res){
							if(res == 'e'){
								alert('Youtube link already Exist!');
							}
							else if(res == 'f'){
								alert('Error in saving!');
							}
							else{
								if(res != 's'){
								var appenddata = '<li><a href="#"><img src="'+res+'" > </a><div class="extras"><div class="extras-inner"><a href="'+youURL+'" class="youtube" target="_blank" rel="group-1"><i class="icon-search"></i></a></div></div></li>';
								$publicVideo.find('div.youtubeall ul').append(appenddata);
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
			
			$publicVideo.on('click','.removeURL',function(){
				if(confirm('Are you sure to Delete')){
					$(this).closest('div.form-group').remove();
				}
			});
			
			//$publicVideo
			$(document).on('click','.submitAlbVdoForm',function(e){
				e.preventDefault();
				$.ajax({url:updateURL,type:'POST',data: {update:'done'} })
				.done(function(){
					$publicVideo.modal('toggle');
					window.location.reload();
				});	
				
			});
			
		
		<?php } ?>
	});
	</script>
	<?php
		}
	}