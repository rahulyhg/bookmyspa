<style>
   .massage {
        border-radius: 5px 5px 5px 5px;
        min-height: 115px !important;
        box-shadow: 0 1px 1px 1px rgba(0, 0, 0, 0.1);
    }
    .massage.testt{
	border:2px solid orange !important;
    }
    
</style>

<div class='salon_gift' style='display: none' ></div>
<div class="massage-outer">
    <div class="container">
        <!--main body section starts-->
        <div class="buy-gift-voucher clearfix">
            <div class="angle-heading">
                <h4><?php echo __('Buy_Gift_Voucher', true); ?></h4>
            </div>
            <div class="form col-sm-6">
                <div class="form-group">
                    <label><?php echo __('Recipient ').__('first_name', true); ?></label>
                    <?php echo $this->Form->input('GiftCertificate.first_name', array('class' => 'form-control', 'label' => false, 'required', 'validationMessage'=>__('first_name_req'),'data-maxlengthcustom-msg'=>__("max_55"),'maxlengthcustom'=>'55','maxlength'=>'57','data-pattern-msg'=>'Please enter only alphabets.','pattern'=>'^[A-Za-z ]+$')); ?>                  
                </div>
                <div class="form-group">
                    <label><?php echo __('Recipient ').__('last_name', true); ?></label>
                    <?php echo $this->Form->input('GiftCertificate.last_name', array('class' => 'required form-control', 'label' => false, 'required', 'validationMessage'=>__('last_name_req'),'data-maxlengthcustom-msg'=>__("max_55"),'maxlengthcustom'=>'55','maxlength'=>'57','data-pattern-msg'=>'Please enter only alphabets.','pattern'=>'^[A-Za-z ]+$')); ?>                  
                </div>
                <div class="form-group">  
                    <label><?php echo __('Recipient ').__('Email', true); ?></label>
                    <?php echo $this->Form->input('GiftCertificate.email', array('type'=>'email','div' => 'false', 'class' => 'required form-control', 'label' => false, 'validationMessage'=>__('email_req'),'maxlength'=>'50','data-pattern-msg'=>'Please enter a valid email address.','pattern'=>'^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$')); ?>                                  
                    <dfn><?php echo __('Email_certifcate',true) ?></dfn>
                </div>
                <div class="form-group">
                    <label><?php echo __('Amount', true); ?></label>
		    <?php
	            $redeem_amount  = '';
		    $disabled =  false;
		    if(isset($amount_redeemed) && !empty($amount_redeemed)){
			$redeem_amount = $amount_redeemed;
			$disabled =  false;
			echo $this->Form->input('redeemed_gift',array('type'=>'hidden','value'=>'1')); 
		    } ?>
		    <?php echo $this->Form->input('GiftCertificate.amount', array('type'=>'text','class' => 'required form-control amount', 'label' => false,'autocomplete'=>'off', 'validationMessage'=>__('amount_req'),'data-maxlengthcustom-msg'=>__("max_10"),'maxlengthcustom'=>'10','maxlength'=>'11', 'data-maxValue-msg'=>'Amount should be less than or equal to '.$redeem_amount,'maxValue'=>$redeem_amount,'data-minValue-msg'=>'Amount should be greater than or equal to 50','minValue'=>50, 'value'=>$redeem_amount,'readonly'=>$disabled)); ?>
		    <dfn><?php echo __('Min amount should be greater than AED 50') ?></dfn>                                    
                </div>
                <div class="form-group">
                    <label><?php echo __('Message', true); ?></label>
                    <?php echo $this->Form->input('GiftCertificate.messagetxt', array('type' => 'textarea', 'class' => 'required form-control', 'label' => false, 'validationMessage'=>__('message_req'),'data-maxlengthcustom-msg'=>__("max_150"),'maxlengthcustom'=>'150','maxlength'=>'152')); ?>
                </div>
                <div class="form-group clearfix"> 
		    <label><?php echo __('send_gift_certificate',true) ?></label>
		    <?php $txt = __('send_email_to',true)."<b><span id=\"customerNameToemail\"></span></b>";
		    echo $this->Form->input('print_certificate_status', array('div' => false, 'class' => '', 'type' => 'checkbox', 'label' => array('class' => 'new-chk', 'text' => __('print_send_myself',true))));
		    echo $this->Form->input('send_email_status', array('div' => false, 'class' => '', 'type' => 'checkbox', 'label' => array('class' => 'new-chk', 'text' => $txt))); ?>
                </div>                                            
            </div>
	    <?php $validity = $this->Common->get_expiryDate($salonId);
	    echo $this->Form->inpt('GiftCertificate.expire_on', array('type'=>'hidden' ,'value'=>$validity));?>
            <div class="gift-gallery-box col-sm-6">
                <div class="form-group">  
                    <label><?php echo __('Design_Category', true); ?></label>
                    <?php
		    $lang = Configure::read('Config.language');
                    $defaultPrimaryKey = $this->Common->giftImagePrimaryId($salonId);
                    $designCategorylist = $this->Common->imageDesignCategoyList($lang,$salonId);
                    ?>
                    <?php echo $this->Form->input('GiftCertificate.gift_image_category_id', array('selected' => 1, 'options' => $designCategorylist, 'class' => 'custom_option designCat', 'label' => false)); ?>
                </div>
		<div class="themes-card-box">
		    <div class="scroll">
			<div class="row dynamicImageFront">
			    <input type="hidden" name="data[GiftCertificate][gift_image_id]" id="siestaManageGChdn" value="<?php echo $defaultPrimaryKey['GiftImage']['id']; ?>">
			</div>
		    </div>
		</div>
		<?php
		echo $this->Form->input('GiftCertificate.id', array('label' => false, 'div' => false));?>
		<?php echo $this->Form->hidden('type', array('label' => false, 'div' => false,'value'=>1)); ?>
                <button type="submit" class="purple-btn siestaGCbutton"><?php echo __('Preview', true); ?></button>
            </div>
        </div>
        <!--main body section ends-->
    </div>
</div>
<script type="">
    $(document).ready(function() {
	$( "input#GiftCertificateEmail" ).keyup(function() {
	    var txtvalue = $(this).val();
	    $("#customerNameToemail").text(txtvalue);
	});
	$( "input#GiftCertificateEmail" ).blur(function() {
	    var txtvalue = $(this).val();
	    $("#customerNameToemail").text(txtvalue);
	});
        
    });
    
    //On click of send email to check box 
    $("#GiftCertificateSendEmailStatus").on("click", function(e) {
        if ($(this).is(':checked')) {
            var custName = $("#customerNameToemail").html();
            var msg = "Are you sure you want to send Gift Certificate Email";
            if (custName != '') {
                msg = msg + " to " + custName;
                msg = msg + "?";
                if (confirm(msg)) {
                    $("#GiftCertificateSendEmailStatus").checked = true;
                }
                else {
                    $("#GiftCertificateSendEmailStatus").checked = false;
                }
            }
        }
    });
</script>