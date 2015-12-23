<?php echo $this->Html->script('frontend/star-rating.js?v=1'); ?>
<?php echo $this->Html->css('frontend/star-rating.css?v=1'); ?>
<?php
    $this->Paginator->options(array(
		    'update' => '#update_ajax',
		    'evalScripts' => true,
		    'before' => $this->Js->get('#paginated-content-container')->effect('fadeIn', array('buffer' => false)),
                    'success' => $this->Js->get('#paginated-content-container')->effect('fadeOut', array('buffer' => false))
                ));
?>
<?php $lang =  Configure::read('Config.language'); ?>
    <!--tabs main navigation starts-->
    <div class="salonData appot clearfix">
	<div class="main-nav clearfix">
	    <?php echo $this->element('frontend/User/all_tabs'); ?>
	</div>
	<div class="container bukingService">
	    <div class="wrapper">
		<div class="container my-orders">
		    <!--inner tabs starts-->
		    <div  role="tabpanel" class="appt-tabs">
			<ul class="nav nav-tabs" role="tablist">
			    <?php   $my = '';   $past = '';
				    if($class == 'now') {
					$my = 'active';
				    }
				    if($class== 'past'){
					$past = 'active';
				    }
			    ?>
			    <li class="<?php echo $my ;?>" role="presentation">
				<?php echo $this->Js->link('<span><i class="fa fa-calendar-o"></i></span>Outstanding Reviews<span class="btm-aro"></span>','/Myaccount/reviews',array('update' => '#update_ajax','escape'=>false,'class'=>'allAppointments'));?>
			    </li>
			    <li class="<?php echo $past ;?>"  role="presentation">
				<?php echo $this->Js->link('<span><i class="fa fa-calendar"></i></span>Submitted Reviews<span class="btm-aro"></span>','/Myaccount/reviews/past',array('update' => '#update_ajax','escape'=>false,'id'=>'rev'));?>
			    </li>
			</ul>
			<!-- Tab panes -->
			<div  class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="my_appointments">
				<?php if(!empty($orders)){ ?>
				<!-- Nav tabs -->
				    <?php foreach($orders as $order) {
					$business_url = $this->frontCommon->getBusinessUrl($order['Appointment']['salon_id']);
					$orderType = $order['Appointment']['package_id'] == 0 ? 1 : 2;
					if(!empty($order['Appointment']['deal_id'])){
					    $orderType = 3;
					}
					$display = '';
					switch ($orderType) {
					    case 1:
					    //servicename
						$salon_service_name = $this->Common->get_salon_service_name($order['Appointment']['salon_service_id']);
					    //serviceimage
						$image = $this->Common->getsalonserviceImage($order['Order']['salon_service_id'],$order['Appointment']['salon_id']);
						$type  = 1;
						$typeName = 'service';
						$display = 'Service';
						break;
					    case 2:
					    //packagename
						$salon_service_name = $this->Common->get_salon_package_name($order['Order']['salon_service_id']);
					    //packageimage
						$image = $this->Common->getpackageImage($order['Order']['salon_service_id'],$order['Order']['salon_id']);
					    //code for package evoucher
						$type  = 2;
						$typeName = 'packages';
						$display =  'Package';
						break;
					    case 3:
						$salon_service_name = $this->Common->get_salon_deal_name($order['Appointment']['deal_id']);
						//deal image
						$image = $this->Common->getDealImage($order['Appointment']['deal_id'],$order['Appointment']['salon_id']);
						if($order['Appointment']['package_id'] == 0){
						    $type  = 1;
						    $typeName = 'service'; 
						}else{
						    $type  = 2;
						    $typeName = 'packages';
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
						<p><i class="fa  fa-clock-o"></i> <?php echo $order[0]['Duration']; ?> mins</p>
						<h2>AED <?php echo $order[0]['Price']; ?></h2>
						<p class="purple"><h2>Type:<?php echo $display; ?></h2></p>
					    </div>
					    <div class="timer-sec">
						<div class="time-box">
						    <i class="fa fa-clock-o"></i>
						    <?php echo  date("h:i A",$order['Appointment']['appointment_start_date']); ?>, <?php echo date('l',$order['Appointment']['appointment_start_date'])?> <?php echo date('M-d-Y',$order['Appointment']['appointment_start_date'])?> 
						</div>
					    <!--Need Acceptance <i class="fa fa-check-circle"></i-->
					    </div>
					    <div class="btn-box">
						<?php
						    if($class=='now'){
							if(!empty($business_url) && !empty($order['Appointment']['salon_service_id'])){
							    if(!empty($salon_service_name))
								$service_name_book = str_replace(' ','-',trim($salon_service_name));
							    else
								$service_name_book = '';
								$link_book = '/'.$business_url.'-'.$typeName.'/'.@$service_name_book.'-'.base64_encode($order['Order']['salon_service_id']).'/'.base64_encode(0);
								if($type == 2){
                                                                    $link_book = $link_book.'/'.base64_encode($order['Appointment']['salon_id']);    
								}
								$link_book = $link_book.'/'.base64_encode($order['Order']['id']);
								} else {
								$link_book = '/#';
							    }
                                                        echo $this->Html->link('Review','javascript:void(0)',array('type'=>'button','escape'=>false,'class'=>'book-now','id'=>'review','data-order'=>$order['Order']['id'],'data-type'=>$typeName,'data-salonId'=>$order['Order']['salon_id']));
							echo $this->Html->link('Skip','javascript:void(0)',array('type'=>'button','escape'=>false,'class'=>'gray-btn','id'=>'skip','data-href'=>'#','data-order'=>$order['Order']['id'])); ?>
			<!--<button type="button" class="gray-btn">Cancel</button>-->
			<!--<button type="button" class="book-now">Reschedule</button>-->
<?php	}else{
				    if(isset($order['Review']['review_rating_id'])){
					$reviewRating=$this->common->get_appointment_reviews($order['Review']['review_rating_id']);
					
				    ?>
				    <label style="display:flex;">Venue
					<?php
					if(round($reviewRating[0]['ReviewRating']['venue_rating'])>0){ ?>
					    <ul class="rationg-list">
						
						<?php for($m=5;$m>=1;$m--){
						    if($m>round($reviewRating[0]['ReviewRating']['venue_rating'])){ ?>
							<li><i class="fa fa-star-o"></i></li>
						    <?php } else{ ?>
							<li><i class="fa fa-star"></i></li> 
						    <?php }   ?>
						<?php } ?>
					    </ul>
					<?php } ?>
				    </label> 
				    
				    <?php //echo $this->Form->input('', array('type'=>'text','div'=>false,'label' => 'Venue', 'class' => 'rating','min'=>0,'max'=>5,'step'=>0.1,'data-size'=>'xs','data-readonly'=>'true','data-show-clear'=>'false','data-show-caption'=>'false','value'=>$reviewRating[0]['ReviewRating']['venue_rating'])); ?>
				    <?php if($reviewRating[0]['ReviewRating']['package_id']!=0){ 
					$package=$this->common->get_appointment_reviews_packageId($reviewRating[0]['ReviewRating']['package_id']);
					$i=1;
					foreach($package as $package){
					//echo $this->Form->input('', array('type'=>'text','div'=>false,'label' => 'Staff-'.$i, 'class' => 'rating','min'=>0,'max'=>5,'step'=>0.1,'data-size'=>'xs','data-readonly'=>'true','data-show-clear'=>'false','data-show-caption'=>'false','value'=>$package['ReviewRating']['staff_rating']));  ?>
					<label style="display:flex;">Staff<?php echo $i; ?>
					    <ul class="rationg-list">
						<?php for($m=5;$m>=1;$m--){
						    if($m>round($package['ReviewRating']['staff_rating'])){ ?>
							<li><i class="fa fa-star-o"></i></li>
						    <?php } else{ ?>
							<li><i class="fa fa-star"></i></li> 
						    <?php }  ?>
						<?php }  ?>
					    </ul>
					</label>
					<?php $i++;		}
					
					
				    //pr($package); die;?>
				    <?php } else{?>
				   <?php
				   //echo "test"; die;
				if(round($reviewRating[0]['ReviewRating']['staff_rating'])>0){ ?>
				    <label style="display:flex;">Staff
					<ul class="rationg-list">
					    <?php for($m=5;$m>=1;$m--){ ?>
						<?php if($m>round($reviewRating[0]['ReviewRating']['staff_rating'])){ ?>
						    <li><i class="fa fa-star-o"></i></li>
						<?php } else{ ?>
						    <li><i class="fa fa-star"></i></li>
						<?php } ?>
					    <?php } ?>
					</ul>
				    </label>
				<?php }  ?>
		<?php		    
				    
				    
				    
				    //echo $this->Form->input('', array('type'=>'text','div'=>false,'label' => 'Staff', 'class' => 'rating','min'=>0,'max'=>5,'step'=>0.1,'data-size'=>'xs','data-readonly'=>'true','data-show-clear'=>'false','data-show-caption'=>'false','value'=>$reviewRating[0]['ReviewRating']['staff_rating'])); ?>
				    <?php } ?>
				    <?php //echo $this->Form->input('', array('type'=>'text','div'=>false,'label' => 'Service', 'class' => 'rating','min'=>0,'max'=>5,'step'=>0.1,'data-size'=>'xs','data-readonly'=>'true','data-show-clear'=>'false','data-show-caption'=>'false','value'=>$reviewRating[0]['ReviewRating']['service_rating'])); ?>
				    <?php } } ?>
			    </div>
			</div>  
		    <?php } ?>
				<?php }else{ ?>
					<div class="no-result-found"><?php echo __('No Result Found'); ?></div>
				<?php  } ?>
				<div class="pdng-lft-rgt35 clearfix">
				    <nav class="pagi-nation">
					<?php if($this->Paginator->param('pageCount') > 1){
					        echo $this->element('pagination-frontend');
					    }
		                        ?>
		                    </nav>
		                </div>
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
	var $sModal = $(document).find('#myModal');
        $(document).ready(function(){
	    $(document).off('click','#review').on('click','#review',function(){
		
	        var orderId = $(this).attr('data-order');
	        var typeID = $(this).attr('data-type');
	        var salonID = $(this).attr('data-salonId');
	        var addReviewURL = "<?php echo $this->Html->url(array('controller'=>'Reviews','action'=>'addReview')); ?>";
	        addReviewURL  = addReviewURL +'/'+orderId+'/'+typeID+'/'+salonID; 
	        fetchModal($sModal,addReviewURL,'ReviewAddReviewForm');
	    });
	    
	    
	    
	    $sModal.on('click', '.submitPricingOption', function(e){
		var options = { 
		    success:function(res){
			if(onResponse($sModal,'Review',res)){
			    var data = jQuery.parseJSON(res);
			    $(document).find("#rev").trigger( "click" );
			}
		    }
		}; 
		$('#ReviewRatingAddReviewForm').submit(function(){
		    $(this).ajaxSubmit(options);
		    $(this).unbind('submit');
		    $(this).bind('submit');
		    return false;
		});
	    });
	    
	    
	    $(document).on('click','#rescheduleAppnt',function(){
		var orderId = $(this).attr('data-order');
		var href = $(this).attr('data-href');
		if(confirm("Are you sure you want to continue ?")){
		    $.ajax({
			url: "<?php echo $this->Html->url(array('controller'=>'Myaccount','action'=>'reschedule','admin'=>false))?>",
			type: "POST",
			data: {'order_id':orderId},
			success: function(res) {
			    var result = JSON.parse(res);
			    if(result.msg == 'not_allowed'){
				alert("Reschedule is not allowed for this salon.");
			    }else if(result.msg == 'less_time'){
				alert("Appointment can't be rescheduled. As reschedule is possible "+result.reschedule_time+" hrs prior to the appointment.");
			    }else if(result.msg == 'date_passed'){
				alert("Reschedule is not possible for past appointments.");
			    }else if(result.msg == 'true'){
				window.location.href = href;
			    }
			}
		    });
		}
	    });
	    
	    
	    
	    
	    $(document).on('click','#skip',function(){
		var orderId = $(this).attr('data-order');
		//var href = $(this).attr('data-href');
		if(confirm("Are you sure you want to continue ?")){
		    $.ajax({
			url: "<?php echo $this->Html->url(array('controller'=>'Reviews','action'=>'skipreview','admin'=>false))?>",
			type: "POST",
			data: {'order_id':orderId},
			success: function(res) {
			    if (res==1) {
				$(document).find( ".ReviewClass" ).trigger( "click" );
			    }
			    //var result = JSON.parse(res);
			   /* if(result.msg == 'not_allowed'){
				alert("Reschedule is not allowed for this salon.");
			    }else if(result.msg == 'less_time'){
				alert("Appointment can't be rescheduled. As reschedule is possible "+result.reschedule_time+" hrs prior to the appointment.");
			    }else if(result.msg == 'date_passed'){
				alert("Reschedule is not possible for past appointments.");
			    }else if(result.msg == 'true'){
				window.location.href = href;
			    }*/
			}
		    });
		}
	    });
	    
	    
	    
	    
	    
	});
    </script>
    <?php echo $this->Js->writeBuffer();?>
    