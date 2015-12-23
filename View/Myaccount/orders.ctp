<style>
    .modal-body{
        padding: 4px !important;
    }
    .modal-dialog{
	width: 63% !important;
    }
</style>

<?php if(!$this->request->is('ajax')){
    echo $this->Html->script('/js/frontend/jquery-1.11.1.js'); 
    echo $this->Html->script('/js/kendo/kendo.all.min.js?v=1'); 
}?>
<?php echo $this->Html->script('admin/jquery.timepicker.js?v=1'); ?>
<?php echo $this->Html->css('admin/jquery.timepicker.css?v=1'); ?>

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
	<?php  echo $this->element('frontend/Myaccount/my_tabs'); ?>
    </div>
    <div class="wrapper">
	<div class="container my-orders">
        <div class="clearfix">
        <!--sort by-->
        <!--<div class="top-recmnded pull-left">
        <label>Show</label>
        <span class="option_wrapper"><select class="custom_option">
            <option>All</option>
             <option> Options </option>
             <option> Options </option>
        </select><span class="holder">All</span></span>
        </div>-->
        <!--sort by ends-->
        
        <!--sort by-->
     <!--   <div class="top-recmnded pull-right">
        <label>Sort By</label>
        <span class="option_wrapper"><select class="custom_option">
            <option>Expiration date</option>
             <option> Options </option>
             <option> Options </option>
        </select><span class="holder">Expiration date</span></span>
        </div>-->
        <!--sort by ends-->
       </div>
		<!--inner content starts-->
        <div class="appt-tabs">

          <!-- Tab panes -->
          <div class="tab-content">
            <div id="my_appointments" class="tab-pane active">
			<?php
				//pr($orders);
				//exit;
			    if(isset($orders) && $orders != ''){
					foreach($orders as $key => $order){
					  
					$business_url = $this->frontCommon->getBusinessUrl($order['Order']['salon_id']);
					$id = $order['Order']['salon_service_id'];
					$type = $order['Order']['service_type'];
					if($type == 6){
					   
					    ?>
					
					
					<div id="ShowCertificate_<?php echo $order['GiftCertificate']['id']; ?>"  style="display:none">
						    <div class="modal-dialog login">
							    <div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<h4 class="modal-title" id="myModalLabel"><?php echo __('View GiftCertificate', true); ?></h4>
								</div>
								<div class="modal-body clearfix PrintImage">
								  <?php echo $this->Html->image($this->Common->giftImage($order['GiftCertificate']['image'],'original'),array('class'=>"gift-image ",'width'=>'800px' )); ?>
								</div>
								<?php if(isset($order['GiftCertificate']['print_certificate_status']) && ($order['GiftCertificate']['print_certificate_status'] == 1)){?>
								<div class="modal-footer">
								    <?php echo $this->Html->link('Print','javascript:void(0)',array('type'=>'button','escape'=>false,'class'=>'gray-btn printCertificate')); ?>
								</div>
								<?php }?>
							    </div>
						    </div>
					    </div>
						
		<div class="info-box clearfix">
                	<div class="img-box">
			 <?php echo $this->Html->image($this->Common->giftImage($order['GiftCertificate']['image'],'original'),array('class'=>" ")); ?>
			</div>
                
		<div class="txt-box">
		    <h2 class="">AED <?php echo $order['GiftCertificate']['amount'];?></h2>
		     <h2 class="price">Certificate No: <?php echo $order['GiftCertificate']['gift_certificate_no'];?></h2>
		</div>
               
		<div class="timer-sec">
			<div class="time-box">
				<i class="fa fa-clock-o"></i>
				<span><strong>Expires On</strong></span>
			    <?php  if($order['GiftCertificate']['expire_on']!= '' && $order['GiftCertificate']['expire_on'] !='0000-00-00') {
				//pr($gift['GiftCertificate']['expire_on']);
				//exit;
				echo date('m-d-Y',strtotime($order['GiftCertificate']['expire_on']));
			}else{
				echo 'N.A';	
			} ?><br>
			<?php if(!empty($order['Order']['display_order_id'])) { ?>
			    <b>Order ID: </b> <?php echo $order['Order']['display_order_id']; ?><br>
			<?php } ?>
			</div>
			<!--Need Acceptance <i class="fa fa-check-circle"></i-->
		</div>
		
		<div class="btn-box">
		    <a class="book-now giftCertificateModal gift-button" href="javascript:void(0)" id = "<?php echo $order['GiftCertificate']['id']; ?>" type="button">View Gift Certificate</a>
		</div>
		
                    
		<!--div class="btn-box single">
		    <button type="button" class="book-now">View Gift CErtificate</button>
		</div-->
                </div>
					<?php }else{
					    $usedEvoucher = 0;
					    $unusedEvoucher = 0;
					    $deal = false;
					    $voucherToRedeem = '';
					    if(!empty($order['Evoucher'])){
						foreach($order['Evoucher'] as $key=>$eVoucher){
						    if($eVoucher['used'] == 0){
							if(empty($voucherToRedeem)){
							    $voucherToRedeem = $key;    
							}
							$unusedEvoucher++;
						    }else{
							$usedEvoucher++;
						    }
						}
						$voucherToRedeem = ($voucherToRedeem != '' ) ? $voucherToRedeem : 0; 
					        $evoucherType =  $order['Evoucher'][$voucherToRedeem]['evoucher_type'];
						$evoucherPrice =  $order['Evoucher'][$voucherToRedeem]['price'];
						$typeName = 'service';
						$image = '';
						switch ($evoucherType) {
							    case 1:
								//servicename
								$salon_service_name = $this->Common->get_salon_service_name($order['Order']['salon_service_id']);
								//serviceimage
								$image = $this->Common->getsalonserviceImage($order['Order']['salon_service_id'],$order['Order']['salon_id']);
								//echo $evoucherType;
								$type  = 1;
								$typeName = 'service';
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
								break;
							    case 3:
								//packagename
								$salon_service_name = $this->Common->get_salon_package_name($order['Order']['salon_service_id']);
								//packageimage
								$image = $this->Common->getpackageImage($order['Order']['salon_service_id'],$order['Order']['salon_id']);
								//echo $evoucherType;
								//code for package evoucher
								$type  = 2;
								$typeName = 'packages';
								break;
							    case 4:
								// DEal name
								$salon_service_name = $this->Common->get_salon_deal_name($order['Order']['salon_service_id']);
								//deal image
								$image = $this->Common->getDealImage($order['Order']['salon_service_id'],$order['Order']['salon_id']);
								$dealType = $this->Common->getDealType($order['Order']['salon_service_id']);
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
								//echo $evoucherType;
								//code for deal evoucher
								//$type  = 2;
								//$typeName = 'deal';
								//code for deal evoucher
								break;
							    case 5:
								//code for spabreak evoucher
								//servicename
								$salon_service_name = $this->Common->get_spabreak_name($order['Order']['salon_service_id']);
								//serviceimage
                                                                //pr($order);

								$image = $this->Common->getspabreakImage($order['Order']['salon_service_id'],null,350);
								//echo $evoucherType;
								$type  = 5;
								$typeName = 'spabreak';
                                                                break;
						    } ?>
						    <div class="info-box clearfix">
							<div class="img-box">
							    <?php
								echo $this->Html->image($image,array('class'=> ""));
							    ?>
							</div>
						    <div class="txt-box">
							<h2><?php echo $salon_service_name; ?></h2>
							<p class="purple"><?php echo $this->Common->get_my_salon_name($order['Order']['salon_id']); ?></p>
							
							<h2 class="price">AED <?php echo $evoucherPrice; ?></h2>
							<h2 class="">Type : eVoucher</h2>
							<h2>Qty  : <?php echo $unusedEvoucher; ?>  Used : <?php echo $usedEvoucher; ?></h2>
							
						    </div>
						    <div class="timer-sec">
							<div class="time-box">
								<i class="fa fa-clock-o"></i>
								<!--<span class="purple"><strong>11 days left !!</strong></span>-->
								<span><strong>Expires On</strong></span>
								<?php echo $order['Evoucher'][$voucherToRedeem]['expiry_date']; ?></br>
								<b>Order ID: </b> <?php echo $order['Order']['display_order_id'] ; ?><br>
							</div>
						</div>
						    <div class="btn-box">
							<a class="book-now viewVoucherModal gift-button" href="javascript:void(0)" type="button" data-orderID ="<?php echo $order['Order']['id'];?>">View Voucher</a>
							
							<?php if(!empty($business_url) && !empty($order['Order']['salon_service_id'])){
						
							    if(!empty($salon_service_name))
								$service_name_book = str_replace(' ','-',trim($salon_service_name));
							    else
								$service_name_book = '';
								
								$link_book = '/'.$business_url.'-'.$typeName.'/'.@$service_name_book.'-'.base64_encode($order['Order']['salon_service_id']).'/'.base64_encode(0);
								if($deal == true){
								    $link_book = '/'.$business_url.'-'.$typeName.'/'.@$service_name_book.'-'.base64_encode($prentID).'-deal/'.base64_encode($order['Order']['salon_service_id']);
								}
								
								if($type == 2){
								$link_book = $link_book.'/'.base64_encode($order['Evoucher'][$voucherToRedeem]['salon_id']);    
								}
								
								$link_book = $link_book.'/'.base64_encode($order['Evoucher'][$voucherToRedeem]['id']);
							    } else {
								$link_book = '/#';
							    }
							$todaysDate =  date('Y-m-d');
							
							//echo $order['Order']['id'];
							//$soldAs = $this->Common->get_soldAs($order['Order']['salon_service_id'],$type);
							    $soldAs = $order['Order']['sold_as'];
							    if($soldAs==0 && $order['Evoucher'][$voucherToRedeem]['expiry_date'] > $todaysDate){?>
							    <a class="book-now bkVcherApntmnt gift-button" data-orderid = "<?php echo $order['Order']['id']; ?>" data-href="<?php echo $link_book; ?>" href="javascript:void(0)" data-deal = "<?php echo $deal; ?>" data-evoucherid = "<?php echo $order['Evoucher'][$voucherToRedeem]['id']; ?>" type="button">Book Online</a>
							    <?php }else{
                                                            if($order['Evoucher'][$voucherToRedeem]['expiry_date'] > $todaysDate && $unusedEvoucher>0){?>
								 <a class="book-now requestBooking gift-button" href="javascript:void(0)" type="button" data-id="<?php echo $order['Order']['id'];?>" data-evoucherid="<?php echo $order['Evoucher'][0]['id'];?>">Request Booking</a>
							    <?php }else if($order['Evoucher'][$voucherToRedeem]['expiry_date'] < $todaysDate){
								 echo $this->Html->link('Expired','javascript:void(0)',array('type'=>'button','escape'=>false,'class'=>'gray-btn gift-button'));
								}
							    }
						    ?>
						</div>
					     </div>
						    
					  <?php   }
					}
				    }
				}else{
				        echo "No Order found";
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

<script>
    $(document).ready(function(){
	$(document).off('click','.bkVcherApntmnt').on('click','.bkVcherApntmnt',function(){
	   var orderID = $(this).attr('data-orderid');
	   var deals = $(this).attr('data-deal');
	   var href = $(this).attr('data-href');
	   var evoucherId = $(this).attr('data-evoucherid');
	   if(confirm("Are you sure you want to continue ?")){
		$.ajax({
		    url: "<?php echo $this->Html->url(array('controller'=>'Myaccount','action'=>'bookeVoucherAppnmnt','admin'=>false))?>",
		    type: "POST",
		    data: {'deal':deals,'order_id':orderID,'evoucher_id':evoucherId},
		    success: function(res) {
			res = $.trim(res);
			if(res == 'used'){
			    alert("Evoucher is already used.");
			}else if(res == 'invalid'){
			    alert("Some error occurred !!!.");
			}else if(res == 'true'){
			    window.location.href = href;
			}
		    }
		});
	   }
	});
	$(document).off('click','.giftCertificateModal').on('click','.giftCertificateModal', function(){
	    giftID = $(this).attr('id');
	   // e.preventDefault();
	   $("#myModal").html($("#ShowCertificate_"+giftID).html()).modal();
	   //fetchModal($sModal,$(this).data('href'));
	    
	});
	$(document).off('click','.printCertificate').on('click','.printCertificate',function(){
	    Popup($('.PrintImage').html());
	});
	
	$(document).off('click','.requestBooking').on('click','.requestBooking',function(){
	    //alert("In progress");
            var orderRequestID = $(this).attr('data-id');
            var orderEvoucherId = $(this).attr('data-evoucherid');
            $.ajax({
                url: "<?php echo $this->Html->url(array('controller'=>'users','action'=>'request_booking','admin'=>false))?>"+'/'+orderRequestID+'/'+orderEvoucherId,
                type: "POST",
                //data: {'order_id':orderRequestID,'evoucher_id':orderEvoucherId},
                success: function(res) {
                    $("#mySmallModal").html(res);
                    $("#mySmallModal").modal('show');
                }
            });       
	});
    });
    
  
    function Popup(data) 
    {
        var mywindow = window.open('', 'Sieasta.com', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Sieasta.com</title>');;
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }


</script>
<script type="text/javascript">
    $(document).ready(function(){
        var $sModal = $(document).find('#mySmallModal');
        $(document).off('click','.viewVoucherModal').on('click','.viewVoucherModal',function(){
	    
            var orderId = $(this).attr('data-orderID');
            var url = "<?php echo $this->Html->url(array('controller'=>'Myaccount','action'=>'view_voucher_detail','admin'=>false))?>/"+orderId;	
            $sModal.load(url,function(){
                    $sModal.modal('show'); 
             });
        });
    });
</script>

<?php echo $this->Js->writeBuffer();?>