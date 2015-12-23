<style>
    .txt-box h2 {
    color: #666666;
    font-size: 14px;
    font-weight: bold;
    margin: 3px 0;
    text-transform: uppercase;
}

.viewVoucher p {
    margin: 0.5%;
    /*padding: 2%;*/
}
</style>

<div style="width:740px;" class="modal-dialog voucher">
    <div class="modal-content">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo __('Voucher Details', true); ?></h4>
        </div>
        <div class="modal-body clearfix viewVoucher">
            
            <!--<h2 class="evoucherTitle"></h2>-->
            
            <?php
                $usedEvoucher = 0;
                $unusedEvoucher = 0;
                $deal = false;
                $voucherToRedeem = '';
                if(!empty($order['Evoucher'])){
                    foreach($order['Evoucher'] as $key => $eVoucher){
                       // pr($order); exit;
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
                    
                    
                    //pr($order);
                    $evoucherType =  $order['Evoucher'][0]['evoucher_type'];
                    $evoucherPrice =  $order['Evoucher'][0]['price'];
                    $typeName = 'service';
                    $image = '';
                    switch ($evoucherType) {
                        case 1:
                            //servicename
                            $salon_service_name = $this->Common->get_salon_service_name($order['Order']['salon_service_id']);
                            //serviceimage
                            $image = $this->Common->getsalonserviceImage($order['Order']['salon_service_id'],$order['Order']['salon_id'],500);
                            //echo $evoucherType;
			    $duration =  $order['Order']['duration'];
                            $type  = 1;
                            $typeName = 'service';
                            break;
                        case 2:
                            //packagename
                            $salon_service_name = $this->Common->get_salon_package_name($order['Order']['salon_service_id']);
                            //packageimage
                            $image = $this->Common->getpackageImage($order['Order']['salon_service_id'],$order['Order']['salon_id'],500);
                            //echo $evoucherType;
                            //code for package evoucher;
			     $duration = $order['OrderDetail'][0]['option_duration'];
                            $type  = 2;
                            $typeName = 'packages';
                            break;
                        case 3:
                            //packagename
                            $salon_service_name = $this->Common->get_salon_package_name($order['Order']['salon_service_id']);
                            //packageimage
                            $image = $this->Common->getpackageImage($order['Order']['salon_service_id'],$order['Order']['salon_id'],500);
                            
			    $duration = $order['OrderDetail'][0]['option_duration'];
			    //echo $evoucherType;
                            //code for package evoucher
                            $type  = 2;
                            $typeName = 'packages';
                            break;
                        case 4:
                            // DEal name
                            $salon_service_name = $this->Common->get_salon_deal_name($order['Order']['salon_service_id']);
                            //deal image
                            $image = $this->Common->getDealImage($order['Order']['salon_service_id'],$order['Order']['salon_id'],500);
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
			    $duration = $order['OrderDetail'][0]['option_duration'];

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

                            $image = $this->Common->getspabreakImage($order['Order']['salon_service_id'],null,500);
                            //echo $evoucherType;
			    $duration = $order['Order']['duration'];

                            $type  = 5;
                            $typeName = 'spabreak';
                            break;
                    } 
                    ?>
                    <div class="info-box clearfix">
                        <div class="img-box">
                            <?php
                                echo $this->Html->image($image,array('class'=> ""));
                            ?>
                        </div>
                        <div class="txt-box">
                             <!--<h2></h2>-->
                            <h2><?php echo $salon_service_name; ?></h2>
                            <p class="purple"><?php echo $this->Common->get_my_salon_name($order['Order']['salon_id']); ?></p>

                            <p><strong>AED </strong><?php echo $evoucherPrice; ?></p>
                            <p><strong>Type: </strong>eVoucher</p>
                            <p><strong>Qty: </strong><?php echo $unusedEvoucher; ?> <strong>Used: </strong> <?php echo $usedEvoucher; ?></p>
                            <p><strong>Duration: </strong><?php echo$duration; ?></p>
                            <p><strong>Order Id: </strong><?php echo $order['Order']['display_order_id']; ?></p>
                            <p><strong>Vocher Code: </strong><?php echo $order['Evoucher'][0]['vocher_code']; ?></p>
 <!--<span class="purple"><strong>11 days left !!</strong></span>-->
                                    <p><strong>Purchased Date: </strong><?php echo date('Y-m-d',strtotime($order['Order']['created']));?> </p>
                                
                                    <p><strong>Expires On: </strong><?php echo $order['Evoucher'][0]['expiry_date']; ?></p>
                                    
                        </div>
                       
                    </div>
                <?php
                }
            ?>
        </div>
    </div>
</div>

