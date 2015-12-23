<style>
    .gift-gallery-box {
        border-left: 1px solid #CBCBCB;
       /* float: right;*/
        padding: 0 0 0 20px;
       /* text-align: center;*/
        width: 100%;
    }
    .gift-gallery-box .massage {
        margin: 0 0 20px;
    }
    .massage {
        border-radius: 5px 5px 5px 5px;
        min-height: 115px !important;
        box-shadow: 0 1px 1px 1px rgba(0, 0, 0, 0.1);
    }
    .gift-gallery-box .massage .picture-space img {
        width: 100%;
    }
    .massage .picture-space img {
        height: 100%;
        max-width: 100%;
    }
    img {
        vertical-align: middle;
    }
    img {
        border: 0 none;
    }
   /* .col-sm-4{
        width: 100%;
    }*/
    .gift-gallery-box .massage .picture-space {
        height: 90px;
    }
    .massage .picture-space {
        border-radius: 5px 5px 0 0;
        height: 155px;
        width: 100%;
    }
    .purple-btn, .gray-btn {
        padding: 5px 15px;
    }
</style>
<script type="text/javascript">
    $(".serviceBoxDiv").hide();
    //Auto Generate String
    $('#autoGenerateString').on('click', function() {
        var getStringURL = "<?php echo $this->Html->url(array('controller' => 'GiftCertificates', 'action' => 'admin_generateString', 'admin' => true)); ?>";
        $.ajax({
            url: getStringURL,
            type: 'POST',
            success: function(response) {
                $('.gcfToUpdate').val($.trim(response));
                $('#GiftCertificateGiftCertificateNo').focus();
            }
        });
    });
    //On click of class show/Hide div
    $('input[type="radio"]').click(function() {
        if ($(this).attr("value") == "1") {
            $(".flatAmountDiv").hide();
            $("#GiftCertificateAmount").val('0');
            $(".serviceBoxDiv").show();
            
        }
        if ($(this).attr("value") == "0") {
            $("#giftCertificateAmountDiv").hide();
            $(".flatAmountDiv").show();
            $(".serviceBoxDiv").hide();
            $('#GiftCertificateServiceId').val('');
            $('.visitsDiv').hide();
        }
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

    //Select box service on change get amount
    $(document).find($("select#GiftCertificateServiceId").change(function() {
        var selectedService = $("#GiftCertificateServiceId option:selected").val();        
        if (selectedService) {
            var getServiceAmountURL = "<?php echo $this->Html->url(array('controller' => 'Homes', 'action' => 'getServicePrice', 'admin' => false)); ?>";
            $.ajax({
                url: getServiceAmountURL + '/'+selectedService,
                type: 'POST',
                success: function(response) {
                    $('#giftCertificateAmountDiv').html(response);
                    $(".flatAmountDiv").hide();
                    $('.visitsDiv').show();
                    $('#giftCertificateAmountDiv').show();
                }
            });
        }
    }
    ));
    
</script>
<div class="modal-dialog vendor-setting">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
                <?php echo (isset($this->data) && !empty($this->data)) ? 'Edit' : "Add"; ?>Gift Certificate
            </h3>
        </div>	
        <div class="modal-body clearfix">	
            <div class="box">
                <div class="box-content">
                    <?php echo $this->Form->create('GiftCertificate', array('novalidate', 'class' => 'form-horizontal'));
                    echo $this->Form->hidden('id', array('label' => false, 'div' => false));
                    ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label><?php echo __('Gift Certificate Number ', true); ?></label>
                                <?php echo $this->Form->input('GiftCertificate.gift_certificate_no', array('class' => 'required form-control gcfToUpdate', 'label' => false, 'required', 'validationMessage'=>'No is required.')); ?>    
                                <a id="autoGenerateString" href="javascript:void(0);" tabindex="0">Auto Generate</a>	
                            </div>
                        </div>
                        <?php $userType = $this->Session->read('Auth.User.type'); ?>
                        <div class="form-group flatAmountDiv">
                            <div class="col-sm-12">
                               <label><?php echo __('Flat Amount ', true); ?></label>
                               <?php echo $this->Form->input('GiftCertificate.amount', array('type'=>'text','class' => 'required form-control number', 'label' => false, 'required', 'validationMessage'=>'Amount is required.','maxlength'=>5,'data-minValue-msg'=>'Amount should be greater than or equal to 50','minValue'=>50)); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label><?php echo __('Sender Name', true); ?></label>
                                <?php echo $this->Form->input('GiftCertificate.sender_id', array('options' => $senderArr, 'empty' => '---Please select---', 'div' => 'false', 'class' => 'required form-control', 'label' => false, 'required', 'validationMessage'=>'Sender name is required.'));?>   
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="col-sm-12 nopadding">
                                 <label><?php echo __('Recipient Name ', true); ?></label>
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <?php echo $this->Form->input('GiftCertificate.recipient_first_name',
                                        array('type'=>'text',
                                            'class' => 'required form-control',
                                            'label' => false,
                                            'required',
                                            'validationMessage'=>'Recipient fisrt name is required.',
                                            'maxlength'=>255,
                                            'placeholder'=>"Recipient Frist Name")); ?>
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <?php echo $this->Form->input('GiftCertificate.recipient_last_name',
                                        array('type'=>'text',
                                            'class' => 'required form-control',
                                            'label' => false,
                                            'required',
                                            'validationMessage'=>'Recipient last name is required.',
                                            'maxlength'=>255,
                                            'placeholder'=>"Recipient Last Name")); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                                <div class="col-sm-12 col-xs-12">
                                    <?php echo $this->Form->input('GiftCertificate.recipient_email',
                                        array('type'=>'text',
                                            'class' => 'required form-control',
                                            'label' => false,
                                            'required',
                                            'validationMessage'=>'Recipient email is required.',
                                            'maxlength'=>255,
                                            'placeholder'=>"Recipient Email")); ?>
                                </div>
                                
                                <?php //echo $this->Form->input('GiftCertificate.recipient_id', array('options' => $userList, 'empty' => '---Please select---', 'div' => 'false', 'class' => 'required form-control', 'label' => false, 'required', 'validationMessage'=>'Receiver name is required.')); ?> 
                            
                        </div>			     		      		       
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label><?php echo __('Message', true); ?></label>
                                <?php echo $this->Form->input('GiftCertificate.messagetxt', array('type' => 'textarea', 'class' => 'required form-control', 'label' => false, 'required', 'validationMessage'=>'Message is required.','maxlength'=>200)); ?> 
                            </div>                                 			  
                        </div>
                        <?php
                        $validity = $this->Common->get_expiryDate($user_id);
                        echo $this->Form->inpt('GiftCertificate.expire_on', array('type'=>'hidden' ,'value'=>$validity)); ?>
                        <div class="form-group clearfix"> 
                            <div class="col-sm-12">
                                <label>How do you want to send the gift certificate?</label>
                                <?php $txt = "Send Email To <b><span id=\"customerNameToemail\"></span></b>"; ?>
                                <?php echo $this->Form->input('print_certificate_status', array('div' => false, 'class' => '', 'type' => 'checkbox', 'label' => array('class' => 'new-chk', 'text' => ' I\'ll print it, and send it myself'))); ?>
                                <?php echo $this->Form->input('send_email_status', array('div' => false, 'class' => '', 'type' => 'checkbox', 'label' => array('class' => 'new-chk', 'text' => $txt))); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="gift-gallery-box">
                            <div class="form-group">
                                <label class="col-sm-5 pdng-tp7 rgt-p-non">
                                <?php echo __('Design Category ', true); ?></label>
                                    <div class="col-sm-7">
                                        <?php
                                        $lang = Configure::read('Config.language');
                                        $defaultPrimaryKey = $this->Common->giftImagePrimaryId($user_id);
                                        $designCategorylist = $this->Common->imageDesignCategoyList($lang,$user_id);
                                        echo $this->Form->input('GiftCertificate.gift_image_category_id', array('selected' => 1, 'options' => $designCategorylist, 'class' => 'designCat full-w', 'div' => false, 'label' => false)); ?>
                                    </div>
                            </div>
                            <div class="scroll">
                                <div class="row dynamicImageAdmin">
                                    <input type="hidden" name="data[GiftCertificate][gift_image_id]" id="siestaManageGChdn" value="<?php echo $defaultPrimaryKey['GiftImage']['id']; ?>">
                                </div> 
                                <div class="col-sm-12 text-center">
                                    <div class="col-sm-4">
                                    <?php echo $this->Html->link('<button class="purple-btn siestaGCbutton">Preview</button>', 'javascript:void(0);', array('data-id' => '', 'escape' => false, 'class' => 'preview_gift_certificate')); ?>
                                    </div>
                                    <div class="col-sm-6"><?php
                                    echo $this->Form->button('Save & SEnd Email', array(
                                        'label' => false, 'div' => false,
                                        'class' => 'purple-btn savesendgift'));
                                    ?>
                                    <?php echo $this->Form->hidden('save_send',array('id'=>'save_send','type'=>'text','div'=>false));?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>   
            </div>
        </div>     
    </div>
</div>
<script type="text/javascript">
$('.number').keyup(function(){
    var val = $(this).val();
    if(isNaN(val)){
        $(this).val('');
    }
});
$('.datepicker').datepicker({
    minDate: 0,
    dateFormat: 'yy-mm-dd' 
});
$(document).ready(function() {
    //Select 2
    var $modal = $('#commonContainerModal');
    $("#GiftCertificateAdminAddCertificateForm .designCat").select2();
    //Load Image by category
    var getGiftImageURL = "<?php echo $this->Html->url(array('controller' => 'GiftCertificates', 'action' => 'admin_image_by_category', 'admin' => true)); ?>";
    $(document).on('change', '#GiftCertificateAdminAddCertificateForm .designCat', function() {
        var id = $(this).val();
        $('#GiftCertificateAdminAddCertificateForm .dynamicImageAdmin').load(getGiftImageURL + '/' + id, function() {
        });
    });
    //Load deafault Images by design category
    var gift_cate_id = $('#GiftCertificateGiftImageCategoryId').val();
    $('#GiftCertificateAdminAddCertificateForm .dynamicImageAdmin').load(getGiftImageURL + '/' + gift_cate_id, function() {
    });
    
     var prodValidator = $("#GiftCertificateAdminAddCertificateForm").kendoValidator({
    rules:{
        minlength: function (input) {
            return minLegthValidation(input);
        },
        maxlength: function (input) {
            return maxLegthValidation(input);
        },
        pattern: function (input) {
            return patternValidation(input);
        },
        minValue: function (input){
                    return minValueCustomValidation(input);
            }
    },
    errorTemplate: "<dfn class='text-danger'>#=message#</dfn>"}).data("kendoValidator");
    

    $('#GiftCertificateRecipientEmail').blur(function(){
        var recpt = $('#GiftCertificateRecipientEmail').val();
        $('#customerNameToemail').html(' '+recpt);
    });

    

    
    
});
</script>