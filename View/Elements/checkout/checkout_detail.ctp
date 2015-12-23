<style>
    .price_color {
        background: red;
    }
    .money-rate.number.editable{
        background: #EFEFEF;
        border: 1px solid #959494;
        border-radius: 4px 4px 4px 4px;
        
    }
    .money-rate{
        text-align: right;
        border: 1px solid #959494;
        border-radius: 4px 4px 4px 4px;
    }
    
</style>
<ul id= "checkoutCalDetail">
<?php
//echo "Testtttt";
if(isset($appointmentData)){
    //pr($appointmentData); exit;
    $salon_id = $appointmentData['Appointment']['salon_id'];
}
elseif(!empty($userAppointments)){
    $salon_id = $userAppointments[0]['Appointment']['salon_id'];
        
}
//pr($appointmentData); die;
    if(isset($allproductData) && $allproductData !=''){
        $session_product = $allproductData;
        
    }
    if(isset($allGiftCertificate) && $allGiftCertificate !=''){
        $session_gc = $allGiftCertificate;
        
    }
    //pr($session_gc); //exit;
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
    /*pr($userAppointments);
    echo "raj"; 
    
    pr($all_iou);
    //exit;
    
    pr($totalPrice);*/ //exit;
    
    $productPrice = 0;
    if(isset($productData) && $productData != ''){
        foreach($productData as $key => $product){
            $productPrice = $productPrice + ($product['count']*$product['Product']['selling_price']);
        }
    }
    $gcPrice = 0;
    if(isset($gcData) && $gcData != ''){
        foreach($gcData as $key => $gc){
            $gcPrice = $gcPrice + $gc['GiftCertificate']['amount'];
        }
    }
    else{
        $gcPrice = 0;
    }
     if(isset($tax1_amount) && isset($tax2_amount) ){
        $tax_amount=$tax1_amount+$tax2_amount;
        $total_tax_amount=$totalPrice*($tax_amount/100);
        
    }
    
    
    $total_due_amount = $totalPrice + $productPrice + $gcPrice+$total_tax_amount;
?>
    <li>
          <label>Service Charges <span>(AED)</span></label>
          <section><?php echo $this->Form->input('service_charges',array('value'=>$totalPrice,'div'=>false,'label'=>false,'class'=>"money-rate number",'id' => 'service_charges','readonly' => true)); ?></section>
    </li>
    <li>
          <label>Product Charges <span>(AED)</span></label>
          <section><?php echo $this->Form->input('product_charges',array('value'=>$productPrice,'div'=>false,'label'=>false,'class'=>"money-rate number",'id' => 'product_charges','readonly' => true)); ?></section>
    </li>
    <li>
          <label>Gift Cert. Charges <span>(AED)</span></label>
          <section><?php echo $this->Form->input('gift_charges',array('value'=>$gcPrice,'div'=>false,'label'=>false,'class'=>"money-rate number",'id' => 'gift_charges','readonly' => true)); ?></section>
    </li>
  
     <li>
          <label>Discount <span>(AED)</span></label>
          <section><?php echo $this->Form->input('ttl_discount',array('value'=>"0",'div'=>false,'label'=>false,'class'=>"money-rate number",'id' => 'ttl_discount','readonly' => true)); ?></section>
    </li>
      <li>
          <label>Tax <span>(AED)</span></label>
          <section><?php echo $this->Form->input('tax',array('value'=>$total_tax_amount,'div'=>false,'label'=>false,'class'=>"money-rate number",'id'=> 'tax','readonly' => true)); ?></section>
    </li>
      <li>
          <label>Tip <span>(AED)</span></label>
          <section><?php echo $this->Form->input('tip',array('value'=>"0",'div'=>false,'label'=>false,'class'=>"money-rate number editable",'id'=> 'tip')); ?></section>
      </li>
    <li>
          <label class="heading">Amount Due</label>
          <section class=heading>
            <?php echo $this->Form->input('due_amount',array('div'=>false,'label'=>false,'class'=>"money-rate",'value'=> $total_due_amount, 'id' => 'due_amount','readonly' => true)); ?>
            
    </li>
      <li>
          <label>Cash Amount <span>(AED)</span></label>
          <section><?php echo $this->Form->input('cash_amt',array('div'=>false,'label'=>false,'class'=>"money-rate number editable",'value'=>'0','id' => 'cash_amt')); ?></section>
      </li>
      <li>
          <label>Check Amount <span>(AED)</span></label>
          <section><?php echo $this->Form->input('chk_amt',array('div'=>false,'label'=>false,'class'=>"money-rate number editable",'value'=>'0', 'id'=> 'chk_amt')); ?></section>
      </li>
      <li>
        <?php echo $this->Form->input('Gcsalon_id',array('value'=> $salon_id,'div'=>false,'label'=>false,'class'=>"money-rate number",'type' => 'hidden', 'id'=> 'gcSalon_id')); ?>
          <label class="gift" style="cursor:pointer;text-decoration: underline;">Gift Certificate<span>(AED)</span></label>
          <section><?php echo $this->Form->input('gc_amt',array('value'=>"",'div'=>false,'label'=>false,'class'=>"money-rate number",'readonly' => true,'value'=>'0', 'id'=> 'gc_amt')); ?></section>
      </li>
      <li>
        <label>Credit Card Info <span>(AED)</span></label>
        <section>
            <?php echo $this->Form->input('cc_info',array('value'=>"0",'div'=>false,'label'=>false,'class'=>"money-rate number editable",'id' => "cc_info")); ?>
        </section>
        </li>
      
        <li style="display: none;" class="credit_card_type">
        <label>Card Type <span></span></label>
        <section>
        <?php
            $creditCardList = array('1' => 'American Express', '2' => 'Discover', '3' => 'MasterCard', '4' => 'Visa', '5'  => 'Other');    
            echo $this->Form->input('credit_card_type',array('div'=>false,'options'=>$creditCardList,'empty'=>'Select Card','label'=>false,'class'=>'select2-me userSelect nopadding mrgn-btm10 form-control bod-non','required','validationMessage'=>'Select Card','selected'=>'0'));
            ?>
        </section>
        </li>
        
        <li style="display: none;" class="credit_card_number">
          <label>Credit Card Number </label>
          <section><?php echo $this->Form->input('credit_card_number',array('div'=>false,'label'=>false,'maxlength'=>'4','class'=>"card_number number editable",'value'=>'')); ?></section>
      </li>
        
        
        <li>
        <label class="heading">Amount Paid</label>
        <section class=heading><?php echo $this->Form->input('amount_paid',array('value'=>"0",'div'=>false,'label'=>false,'class'=>"money-rate number",'id' => "amt_paid",'readonly' => true)); ?>
        </section>
        </li>
        <li>
        <label class="heading">Change Due</label>
        <section class=heading>
            <?php echo $this->Form->input('change_due',array('value'=>$total_due_amount,'div'=>false,'label'=>false,'class'=>"money-rate number",'id' => "change_due",'readonly' => true)); ?>    
        </section>
        </li>
        
</ul>


<script>
    $(document).ready(function() {
        $('.number').keyup(function(){
            var val = $(this).val();
            if(isNaN(val)){
                $(this).val('');
            }
        });
        $(function(){
            $(document).on('click','input[type=text]',function(){
                this.select();
            });
        });
        $('#cc_info').on('blur',function(){
            if ($(this).val() != 0) {
                $('.credit_card_type').show();
                 $('.credit_card_number').show();
            }
            else{
                $('.credit_card_type').hide();
                $('.credit_card_number').hide();
            }
        });
    });
</script>
