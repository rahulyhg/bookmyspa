<?php if(!empty($serviceDetail)) {  ?>
<div class="dynamicServicePrice">
<label><?php echo __('Amount',true); ?></label>
<?php
if($serviceListCount >1){ ?>
   <div class="checkbox-gift hgt-box">
   <?php $selected = array_keys($array)[0];?>
        <?php echo $this->Form->input('GiftCertificate.service_amount',array('class'=>'change_service','default'=>$selected,'type'=>'radio','options'=>$array,'legend' => false));?>

   </div>
<?php
}else{ ?>
   <?php
   if(!empty($serviceDetail)){ ?>
        <input type="hidden" name="data[GiftCertificate][service_amount]" value="<?php echo $serviceDetail[0]['ServicePricingOption']['full_price'] ;?>">
        <div class="single-check">
            <?php echo '<span id="'.$serviceDetail[0]['ServicePricingOption']['duration'].'" class="getduration">'.$serviceDetail[0]['ServicePricingOption']['duration'].'</span> minutes - <strong>ADE '.$serviceDetail[0]['ServicePricingOption']['full_price'].'</strong><div class="pricing-option" style="hidden" id="'.$serviceDetail[0]['ServicePricingOption']['id'].'"></div>'; ?>
        </div>
  <?php }
   //echo $this->Form->input('GiftCertificate.amount',array('value'=>!empty($inputBoxPrice['ServicePricingOption']['full_price']) ? $inputBoxPrice['ServicePricingOption']['full_price']:'0','class'=>'form-control','div'=>false,'label'=>false));?>
  <?php
}
?>
</div>
<?php } ?>
<script>
    
    $(".change_service").click(function () {
        duration =   $(this).next().find('.getduration').attr('id');
        pricing_id = $(this).next().find('.pricing-option').attr('id');
        setValues(duration ,pricing_id);   
        
    })
    $(document).find('.checkbox-gift label').addClass('new-chk');
</script>
                   
            