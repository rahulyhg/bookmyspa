
<?php
$this->Paginator->options(array(
        'update' => '#update_ajax',
        'evalScripts' => true,
        'before' => $this->Js->get('#paginated-content-container')->effect('fadeIn', array('buffer' => false)),
        'success' => $this->Js->get('#paginated-content-container')->effect('fadeOut', array('buffer' => false))
    ));
    ?>
    <?php $lang =  Configure::read('Config.language'); ?>
<script type="text/javascript">
    $(document).ready(function(){
		var $sModal = $(document).find('#mySmallModal');
		$(document).on('click','.viewVoucherModal',function(){
		var url = "<?php echo $this->Html->url(array('controller'=>'Myaccount','action'=>'view_voucher_detail','admin'=>false))?>";	
		$sModal.load(url,function(){
			$sModal.modal('show');
		 });
			
	});	
		
	});
</script>


<!--tabs main navigation starts-->
<div class="salonData clearfix">
    <div class="main-nav clearfix">
	<?php  echo $this->element('frontend/Myaccount/my_tabs'); ?>
    </div>

    <div class="wrapper">
	<div class="container my-orders">
		
        <div class="clearfix bod-btm">
       
        </div>
       	
	<!--inner content starts-->
        <div class="appt-tabs">
               <ul class="nav nav-tabs" role="tablist">
                    <?php 
                        $my = '';
                        $past = '';
                        if($class == 'now') {
                            $my = 'active';
                        }if($class== 'past'){
                            $past = 'active';
                        }

                    ?>
                    <li class="<?php echo $my ;?>" role="presentation">
                        <?php echo $this->Js->link('<span><i class="fa fa-calendar-o"></i></span>My Spabreaks<span class="btm-aro"></span>','/Users/spabreaks',array('update' => '#update_ajax','escape'=>false,'class'=>'allAppointments'));?>
                    </li>
                    <li class="<?php echo $past ;?>"  role="presentation">
                        <?php echo $this->Js->link('<span><i class="fa fa-calendar"></i></span>Past Spabreaks<span class="btm-aro"></span>','/Users/spabreaks/past',array('update' => '#update_ajax','escape'=>false));?>
                    </li>
                </ul>
              <!-- Tab panes -->
          <!-- Tab panes -->
          <div class="tab-content">
            <div id="my_appointments" class="tab-pane active"> 
			<?php
                          //pr($orders);
				//exit;
			    if(isset($orders) && !empty($orders)){
                                foreach($orders as $key => $order){
                                $business_url = $this->frontCommon->getBusinessUrl($order['Order']['salon_id']);
                                $id = $order['Order']['salon_service_id'];
                                
                                $salon_service_name = $this->Common->get_salon_service_name($order['Order']['salon_service_id']);
                                $image = $this->Common->getspabreakImage($order['SalonSpabreakImage']['spabreak_id'],$order['SalonSpabreakImage']['created_by'],350);
                                $typeName = 'spabreak';
                        ?>
                                <div class="info-box clearfix">
                                    <div class="img-box">
                                        <?php
                                            echo $this->Html->image($image,array('class'=> ""));
                                        ?>
                                    </div>
                                    <div class="txt-box">
                                        <h2><?php echo $order['Order']['ara_service_name']; ?></h2>
                                        <p class="purple"><?php echo $this->Common->get_my_salon_name($order['Order']['salon_id']); ?></p>

                                        <h2 class="price">AED <?php echo $order['OrderDetail'][0]['price']; ?></h2>
                                    </div>
                                    <div class="timer-sec">
                                        <div class="time-box">
                                                <i class="fa fa-clock-o"></i>
                                                <span><strong>Valid From</strong></span></br>
                                                <?php 
                                                    $duration = $order['OrderDetail'][0]['option_duration'];
                                                    $spaDuration = explode('~',$duration);
                                                    if(isset($spaDuration[0])){
                                                        echo date('d M Y',strtotime($spaDuration[0]));
                                                        echo " to ";
                                                    }
                                                    if(isset($spaDuration[1])){
                                                        echo date('d M Y',strtotime($spaDuration[1]));                                                            
                                                    }
                                                ?>
                                                </br>
                                                <span><strong>Booking Date</strong></span></br>
                                                <?php 
                                                    $duration = $order['OrderDetail'][0]['created'];
                                                    $spaDuration = explode('~',$duration);
                                                    if(isset($order['OrderDetail'][0]['created'])  && !empty($order['OrderDetail'][0]['created'])){
                                                        echo date('d M Y',strtotime($order['OrderDetail'][0]['created']));

                                                    }
                                                ?>
                                                </br>
                                                <span><strong>Check In</strong></span></br>
                                                <?php 
                                                    if(isset($order['Spabreak']['check_in']) && !empty($order['Spabreak']['check_in'])){
                                                        echo date('h:i A',strtotime($order['Spabreak']['check_in']));
                                                    }
                                                ?>
                                                </br>
                                                <span><strong>Check Out</strong></span></br>
                                                <?php
                                                    if(isset($order['Spabreak']['check_out'])  && !empty($order['Spabreak']['check_out'])){
                                                        echo date('h:i A',strtotime($order['Spabreak']['check_out']));                                                 
                                                    }
                                                ?>
                                        </div>
                                    </div>
                                    <div class="btn-box single">
                                        <?php 
                                       
                                            if($class == 'now') {
                                                if(!empty($business_url) && !empty($order['Order']['salon_service_id'])){
                                                
                                                if(!empty($salon_service_name))
                                                    $service_name_book = str_replace(' ','-',trim($salon_service_name));
                                                else
                                                    $service_name_book = str_replace(' ','-',trim($order['Order']['ara_service_name']));
                                                    $link_book = '/'.$business_url.'-'.$typeName.'/'.@$service_name_book.'-'.base64_encode($order['Order']['salon_service_id']).'/'.base64_encode($order['Order']['id']).'/'.base64_encode($order['OrderDetail'][0]['id']);                                                
                                                } else {
                                                    $link_book = '/#';
                                                } 
                                            $todaysDate =  date('Y-m-d');
                                            if($order['Order']['spabreak_status'] == 1){
                                                echo $this->Html->link('Cancelled','javascript:void(0)',array('type'=>'button','escape'=>false,'class'=>'gray-btn'));
                                            }else{
                                                echo $this->Html->link('Cancel','javascript:void(0)',array('type'=>'button','escape'=>false,'class'=>'gray-btn','id'=>'cancelAppnt','data-order'=>$order['Order']['id'],'data-type'=>$typeName));
                                                echo $this->Html->link('Reschedule','javascript:void(0)',array('type'=>'button','escape'=>false,'class'=>'book-now','id'=>'rescheduleAppnt','data-href'=>$link_book,'data-order'=>$order['Order']['id']));
                                            ?>                                       
                                       <?php    }
                                            }
                                        ?>
                                </div>
                             </div>
                                <?php
                                
                                }
                            }else{
                                    echo '<div class="no-result-found">No Result Found</div>';
                                }

                            ?>
                            <div class="pdng-lft-rgt35 clearfix">
                                <nav class="pagi-nation">
                                        <?php if($this->Paginator->param('pageCount') > 1){
                                                echo $this->element('pagination-frontend');
                                               // echo $this->Js->writeBuffer();
                                        } ?>
                                </nav>
                            </div>
                    </div>
      </div>

    </div>
    <!--inner content ends-->

</div>

</div>

</div>
<!--tabs main navigation ends-->


<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click','#cancelAppnt',function(){
       var orderId = $(this).attr('data-order');
       var typeID = $(this).attr('data-type');
       if(confirm("You will get Gift Certificate of same amount as that of service . Are you sure you want to continue ? ")){
            $.ajax({
                url: "<?php echo $this->Html->url(array('controller'=>'users','action'=>'cancel','admin'=>false))?>",
                type: "POST",
                data: {'order_id':orderId,'type':typeID},
                success: function(res) {
                    var result = JSON.parse(res);
                    if(result.msg == 'not_allowed'){
                        alert("Cancellation is not allowed for this salon.");
                    }else if(result.msg == 'less_time'){
                        alert("Appointment can't be cancelled. As cancelation is possible "+result.cancel_time+" hrs prior to the appointment.");
                    }else if(result.msg == 'date_passed'){
                        alert("Cancellation is not possible for past appointments.");
                    }else if(result.msg == 'true'){
                        alert("Appointment cancelled successfully.Gift certificate of same amount is sent to your email id.");
                        $(".allAppointments").trigger("click");
                    }
                }
            });
       }
       return false;
    });

    $(document).on('click','#rescheduleAppnt',function(){
       var orderId = $(this).attr('data-order');
       var href = $(this).attr('data-href');
       if(confirm("Are you sure you want to continue ?")){
            $.ajax({
                url: "<?php echo $this->Html->url(array('controller'=>'users','action'=>'reschedule','admin'=>false))?>",
                type: "POST",
                data: {'order_id':orderId},
                success: function(res) {
                    //alert(res);
                    //console.log(res);
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
});
</script>


<?php echo $this->Js->writeBuffer();?>