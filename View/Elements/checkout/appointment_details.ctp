<?php
    $session_userServices = $this->Session->read('userServices');
    //pr($session_userServices); die;
    $session_iou = $this->Session->read('all_iou');
    if(isset($session_product) && $session_product != ''){
        $productData = $session_product; 
    }
    if(isset($session_gc) && $session_gc != ''){
        $gcData = $session_gc; 
    }
    $totalPrice = 0;
    foreach($userAppointments as $key => $Appointments){
        $totalPrice = $totalPrice + $Appointments['Appointment']['appointment_price'];
    }
    if(isset($all_iou) && $all_iou != ''){
        foreach($all_iou as $key => $iou){
            $totalPrice = $totalPrice + $iou['Iou']['total_iou_price'];
        }
    }
    if(isset($allproductData) && $allproductData != ''){
        foreach($allproductData as $key => $productData){
            $totalPrice = $totalPrice + $productData['Product']['selling_price'];
        }
    }
    if(isset($allGiftCertificate) && $allGiftCertificate != ''){
        foreach($allGiftCertificate as $key => $giftCertificate){
            $totalPrice = $totalPrice + $giftCertificate['GiftCertificate']['amount'];
        }
    }
?>
<div id="servicedetailtbl">
    <h1>Charges Detail</h1>
    <table  class="table table-hover table-nomargin dataTable table-bordered checkoutDetails" width="100%">
        <thead>
            <tr> 
                <th></th>
                <th></th>
                <th>Code</th>
                <th>Service, Product, IOU or Package</th>
                <th>Service Provider</th>
                <th>Qty</th>
                <th>Price</th>
                <th class="dis"> Discount
                    <p>
                        <?php
                            $value_radio = array('0' => '<label style="float:left" for="OptionsDiscount0" class="new-chk">%</label>',
                                    '1' => '<label style="float:right" for="OptionsDiscount1" class="new-chk">AED</label>');
                            echo $this->Form->radio('discount_type', $value_radio, array('hiddenField'=>false,'legend'=>false,'label'=>false,'id'=>'OptionsDiscount','default'=>1,'class' => "discount_type",'name' =>'discount_type'));
                            if(isset($payeeUserId)){
                                echo $this->Form->input('Cart.payeeUserId',array('value'=>$payeeUserId,'name'=>"payeeUserId",'class'=>'payeeUserId','type'=> 'hidden'));    
                            }
                        ?>               
                    </p>
                </th>
                <th>price after Disc.</th>
                <th>Pts needed</th>
                <th>Use Pts</th>
            </tr>
        </thead>
        <?php if(!empty($userAppointments)){
                $appointmemtType = "Srvc";
                //pr($userAppointments); die;
                $s=1;
            }
        ?>
        <tbody>        
            <?php foreach($userAppointments as $apptData){
                if($apptData['Appointment']['discount_value'] == NULL){
                    $apptData['Appointment']['discount_value'] = 0.00 ;
                }
                if($apptData['Appointment']['price_after_discount'] == NULL){
                    $apptData['Appointment']['price_after_discount'] = 0.00 ;
                }
            ?>
            <tr>
                <td><a><?php //echo $this->Html->image('delete.png', array('alt' => 'Delete Appointment','value'=>$apptData['Appointment']['id'],'class'=> 'delete','type'=>'Appointment'));
 ?></a></td>
                <td><?php echo $this->Form->hidden("unique",array('value'=>base64_encode($apptData['Appointment']['id']),'name'=>"unique",'class'=>'unique')); ?></td>
                <td><?php echo $appointmemtType; ?></td>
                <td class="aTitle">
                    <?php
                        echo $this->Html->link($apptData['Appointment']['appointment_title'], array('controller' => 'checkout','action' => 'edit_service'),array('class'=> 'edit_service','salon_service_id'=> $apptData['Appointment']['salon_service_id'],'provider_id'=>$apptData['Appointment']['salon_staff_id'],'appointment_id'=>$apptData['Appointment']['id'],'user_id'=>$apptData['Appointment']['user_id'],'target'=>'_blank', 'onclick' => 'return false'));
                    ?>
                </td>
                    <td class="aName"><?php echo $apptData['ServiceProvider']['first_name'].' '.$apptData['ServiceProvider']['last_name']; ?></td>
                <td class="quantity"><?php echo "1"; ?></td>
                <td><?php echo $this->Form->input('service_price.'.$apptData['Appointment']['id'],array('value'=>$apptData['Appointment']['appointment_price'],'id'=>'apptmntPrice_'.base64_encode($apptData['Appointment']['id']),'div'=>false,'label'=>false,'class' => 'aPrice service_price service1 number price_'.$s)); ?></td>
                <td><?php echo $this->Form->input('service_discount_value.'.$apptData['Appointment']['id'],array('value'=>$apptData['Appointment']['discount_value'],'id'=>'apptmntdiscount_'.base64_encode($apptData['Appointment']['id']),'div'=>false,'label'=>false,'class' => 'aDiscount service_discount_value number dis_'.$s)); ?></td>
                <td><?php echo $this->Form->input('service_discount_price.'.$apptData['Appointment']['id'],array('value'=>$apptData['Appointment']['appointment_price'],'id'=>'aDisPrice_'.base64_encode($apptData['Appointment']['id']),'div'=>false,'label'=>false,'class' => 'aDisPrice service_discount_price number dis_price_'.$s,'readonly' => true)); ?></td>
                 
                
                 
                <!--<td><?php echo $this->Form->input('dis_price',array('value'=>$apptData['Appointment']['appointment_price'],'id'=>'dis_price','div'=>false,'label'=>false,'class' => 'aDisPrice','readonly' => true)); ?></td>-->
                
                
                <!--<td class="aDisPrice"><?php //echo $apptData['Appointment']['price_after_discount']; ?></td>-->
                <?php if($apptData['Appointment']['points_redeem'] == NULL || $apptData['Appointment']['points_redeem'] <= 0){
                    $apptData['Appointment']['points_redeem'] = 'N/A' ;
                } ?>
                
                
                <td class="aPtsN"><?php echo $apptData['Appointment']['points_redeem']; ?></td>
                <?php  //if($apptData['Appointment']['points_redeem']=='' or $apptData['Appointment']['points_redeem']=='Null') {
                         //   $apptData['Appointment']['points_redeem']=0;
                //echo $apptData['Appointment']['points_redeem']; die;
                ?>
                <td class="aPts"><?php echo $this->Form->input('service_points.'.$apptData['Appointment']['id'],array('id'=>'points_'.$s,'div'=>array('class'=>'col-sm-1 '),'class'=>'chk points','type'=>'checkbox','value'=>$apptData['Appointment']['points_redeem'],'type'=>'checkbox','user-id'=>$apptData['Appointment']['user_id'],'salon-id'=>$apptData['Appointment']['salon_id'],'points-redeem'=>$apptData['Appointment']['points_redeem'],'data-id'=>$s,'label'=>array('class'=>'new-chk control-label','text'=>''))); ?></td>
            </tr>
            
        <?php $s++; }
        
        if(!empty($all_iou)){
            $type = "Iou";
        
        foreach($all_iou as $iou){ ?>
            <tr>
                <td><a><?php echo $this->Html->image('delete.png', array('alt' => 'Delete IOU','value'=>$iou['Iou']['id'],'class'=> 'delete','type'=>'IOU'));
 ?></a></td>
                <td><?php echo $this->Form->hidden("unique",array('value'=>$iou['Iou']['id'],'name'=>"unique",'class'=>'unique')); ?></td>
                <td><?php echo $type; ?></td>
                <td class="aTitle"><?php echo $iou['Iou']['iou_comment']; ?></td>
                <td class="aName"></td>
                <td class="quantity"><?php echo "1"; ?></td>
                <td><?php echo $this->Form->input('price',array('value'=>$iou['Iou']['total_iou_price'],'div'=>false,'label'=>false,'class' => 'aPrice service_price','readonly' => true,'id'=>'apptmntPrice_'.$iou['Iou']['id'])); ?></td>
                <td><?php echo $this->Form->hidden('iou_dis_price',array('value'=>0,'div'=>false,'label'=>false,'class' => 'aDiscount service_price','readonly' => true,'id'=>'apptmntdiscount_'.$iou['Iou']['id'])); ?></td>
                <td class="aDisPrice"></td>
                <td class="aPtsN"><?php echo 'N/A'; ?></td>
                <td class="aPts"><?php echo 0; ?></td>
            </tr>
            
        <?php }}
        ?>
        
        <?php
        if(!empty($allproductData)){
                //pr($allproductData);  
        ?>
        <?php foreach($allproductData as $productData){?>
        <?php // pr($productData);?>
            <tr>
                <td><a><?php echo $this->Html->image('delete.png', array('alt' => 'Delete Product','value'=>$productData['Product']['id'],'class'=> 'delete','type'=>'Product'));
 ?></a></td>
                <td><?php echo $this->Form->hidden("unique",array('value'=>$productData['Product']['id'],'name'=>"unique",'class'=>'unique')); ?></td>
                <td><?php echo $productData['Product']['barcode']; ?></td>
                <td><?php echo $productData['Product']['eng_product_name']; ?></td>
                <td></td>
                <td>
                <?php echo $this->Form->input('quantity.'.$productData['Product']['id'],array('value'=>$productData['count'],'div'=>false,'label'=>false,'quantity'=>$productData['Product']['quantity'],'id'=>'product_quantity_'.$productData['Product']['id'],'class' => 'product_quantity','product_id' => $productData['Product']['id'])); ?>
                </td>
                <td>
                <?php echo $this->Form->input('product_price.'.$productData['Product']['id'],array('value'=>($productData['count']*$productData['Product']['selling_price']),'div'=>false,'label'=>false,'id'=>'apptmntPrice_'.$productData['Product']['id'],'class' => 'aPrice product_price service1 number')); ?>
                </td>
                <td><?php echo $this->Form->input('product_discount_value.'.$productData['Product']['id'],array('value' => 0,'div'=>false,'label'=>false,'class' => 'aDiscount product_discount_value number','id'=>'apptmntdiscount_'.$productData['Product']['id'])); ?></td>
                <td class="aDisPrice"><?php echo $this->Form->input('product_discount_price.'.$productData['Product']['id'],array('value'=>($productData['count']*$productData['Product']['selling_price']),'id'=>'aDisPrice_'.$productData['Product']['id'],'div'=>false,'label'=>false,'class' => 'aDisPrice product_discount_price number','readonly' => true)); ?>
                <?php //echo $productData['count']*$productData['Product']['selling_price']; ?>
                </td>
                <td class="aPtsN"><?php echo 0; ?></td>
                <td class="aPts"><?php echo 0; ?></td>
            </tr>
            
        <?php }}
        
        if(!empty($allGiftCertificate)){
            //echo "====="; pr($allGiftCertificate); exit;
            //echo "------------------";
            $type = "GC";
            foreach($allGiftCertificate as $key => $allGiftCertificate){
              //  pr($allGiftCertificate);
        ?>
    
            <tr>
                <td><a><?php echo $this->Html->image('delete.png', array('alt' => 'Delete GiftCertificate','value'=>$allGiftCertificate['GiftCertificate']['gift_certificate_no'],'class'=> 'delete','type'=>'GiftCertificate'));
 ?></a></td>
                <td><?php echo $this->Form->hidden("unique",array('value'=>$allGiftCertificate['GiftCertificate']['gift_certificate_no'],'name'=>"unique",'class'=>'unique')); ?></td>
                <td><?php echo $type; ?></td>
                <td><?php echo $allGiftCertificate['GiftCertificate']['gift_certificate_no']; ?></td>
                <td></td>
                <td></td>
                <td>
                <?php echo $this->Form->input('gc_price.'.$allGiftCertificate['GiftCertificate']['gift_certificate_no'],array('value'=>$allGiftCertificate['GiftCertificate']['amount'],'div'=>false,'label'=>false,'id'=>'apptmntPrice_'.$allGiftCertificate['GiftCertificate']['gift_certificate_no'],'class' => 'aPrice gc_price service1 number')); ?>
                </td>
                <td><?php echo $this->Form->input('gc_discount_value.'.$allGiftCertificate['GiftCertificate']['gift_certificate_no'],array('value' => 0,'div'=>false,'label'=>false,'class' => 'aDiscount gc_discount_value number','id'=>'apptmntdiscount_'.$allGiftCertificate['GiftCertificate']['gift_certificate_no'])); ?></td>
                <td class="aDisPrice"><?php echo $this->Form->input('gc_discount_price.'.$allGiftCertificate['GiftCertificate']['gift_certificate_no'],array('value'=>$allGiftCertificate['GiftCertificate']['amount'],'id'=>'aDisPrice_'.$allGiftCertificate['GiftCertificate']['gift_certificate_no'],'div'=>false,'label'=>false,'class' => 'aDisPrice gc_discount_price number','readonly' => true)); ?></td>
                <td class="aPtsN"><?php echo 0; ?></td>
                <td class="aPts"><?php echo 0; ?></td>
            </tr>
            
        <?php }}
        ?>
        
        
        
        <tr>
                <th></th>
                <th></th>
                <th></th>
                <th>Total</th>
                <th></th>
                <th></th>
                <th id="total_price"><?php echo $totalPrice; ?></th>
                <th> </th>
                <th> </th>
                <th>0</th>
                <th></th>

        </tr>
    </tbody>
</table>
</div>

<script>
    $('.number').keyup(function(){
        var val = $(this).val();
        if(isNaN(val)){
            $(this).val('');
        }
    });
</script>
