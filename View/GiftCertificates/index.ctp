<!--voucher banner starts-->
<style>
/*    div.error{
        display: none;
        visibility: hidden;
    }*/
</style>
<script src="/js/kendo/kendo.all.min.js"></script>
<div class="voucher-banner">
    <div class="container">
        <div class="left-txt">
            <h1 class="heading"><?php echo __('gift_head',true); ?></h1>
            <p><?php echo __('gift_head_static',true); ?></p>
            <input type="button" name="next" class="action-button buynow" value="<?php echo __('Buy_Now',true); ?>" />
            <input type="button" name="next" class="action-button findout" value="<?php echo __('Find_Out_More',true); ?>" />
        </div>
        <div class="card-img">
            <img src="/img/frontend/gift-card.png" alt="Gift Card" title="Gift Card">
        </div>
    </div>
</div>
<!--voucher banner ends-->
<div class="wrapper">
    <div class="container">
        <!--main body section starts-->
        <div class="voucher-box">
            <div class="icon-box">
                <div class="beauty"></div>
            </div>
            <h2><?php echo __('gift_img_1',true); ?></h2>
            <p><?php echo __('gift_img_1_text',true); ?></p>
        </div>
        <div class="voucher-box">
            <div class="icon-box">
                <div class="inspiration"></div>
            </div>
            <h2><?php echo __('gift_img_2',true); ?> </h2>
            <p><?php echo __('gift_img_2_text',true); ?></p>
        </div>
        <div class="voucher-box mrgn-rgt0">
            <div class="icon-box">
                <div class="choice"></div>
            </div>
            <h2><?php echo __('gift_img_3',true); ?> </h2>
            <p><?php echo __('gift_img_3_text',true); ?></p>
        </div>
        <!--main body section ends-->
    </div>
</div>
<?php echo $this->Form->create('GiftCertificate', array('controller' => 'GiftCertificates', 'action' => 'show_preview', 'novalidate', 'id' => "giftcertificateForm"));
echo $this->element('frontend/GiftCertificates/gift_middle');
echo $this->Form->end(); ?>
<div class="wrapper">
    <div class="container">
        <!--main body section starts-->
        <div class="abt-gift-voucher clearfix">
            <h2><?php echo __('About_Voucher', true); ?></h2>
            <div class="sec-txt">
                <div class="clearfix">
                    <h3><?php echo __('about_q1',true) ; ?></h3>
                    <p><?php echo __('about_q1_desc',true) ; ?></p>
                </div>
                <div class="clearfix">
                    <h3><?php echo __('about_q2',true) ; ?></h3>
                    <p><?php echo __('about_q21_desc',true) ; ?></p>
                    <p><?php echo __('about_q22_desc',true) ; ?></p>
                    <p><?php echo __('about_q23_desc',true) ; ?></p>
                </div>
                <div class="clearfix">
                    <h3><?php echo __('about_q3',true) ; ?></h3>
                    <p><?php echo __('about_q3_desc',true) ; ?></p>
                </div>
                <div class="clearfix">
                    <h3><?php echo __('about_q4',true) ; ?></h3>
                    <p><?php echo __('about_q41_desc',true) ; ?></p>
                    <p><?php //echo __('about_q42_desc',true) ; ?></p>
		</div>

            </div>

            <div class="sec-txt last">
                <div class="clearfix">
                    <h3><?php echo __('about_q5',true) ; ?></h3>
                    <p><?php echo __('about_q5_desc',true) ; ?></p>
                </div>
                <div class="clearfix">
                    <h3><?php echo __('about_q6',true) ; ?></h3>
                    <p><?php echo __('about_q61_desc',true) ; ?></p>
                    <p><?php echo __('about_q62_desc',true) ; ?></p>
                    <p><?php echo __('about_q63_desc',true) ; ?></p>
		</div>
                <div class="clearfix">
                    <h3><?php echo __('about_q7',true) ; ?></h3>
                    <p><?php echo __('about_q7_desc',true) ; ?></p>
                </div>
                <div class="clearfix">
                    <h3><?php echo __('about_q8',true) ; ?></h3>
                    <p><?php echo __('about_q81_desc',true) ; ?></p>
                    <p><?php //echo __('about_q82_desc',true) ; ?></p>
                </div>

            </div>
        </div>
        <!--main body section ends-->
    </div>
</div>
<script>
    var $modal1 = $('#mySmallModal');
    $(document).ready(function() {
     giftvalidator  =    $("#giftcertificateForm").kendoValidator({
        rules:{
            minlength: function (input) {
                return minLegthValidation(input);
            },
            maxlength: function (input) {
                return maxLegthValidation(input);
            },
	    maxValue: function (input){
                    return maxValueCustomValidation(input);
            },
	    minValue: function (input){
                    return minValueCustomValidation(input);
            },
            pattern: function (input) {
                return patternValidation(input);
            },maxlengthcustom: function (input) {
                return maxLegthCustomValidation(input);
            },
        },
        errorTemplate: "<dfn class='text-danger'>#=message#</dfn>"}).data("kendoValidator");
    

      
//        rules
            $("#giftcertificateForm").validate({
                errorElement: "div",
                rules: {
                    "data[GiftCertificate][first_name]": {
                        required: true
                    },
                    "data[GiftCertificate][last_name]": {
                        required: true,
                    },
					"data[GiftCertificate][amount]": {
						required: true,
						min: 50
					}
                },
                messages: {
                    "data[GiftCertificate][first_name]": {
                        required: "Please enter the first name."
                    },
                    "data[GiftCertificate][last_name]": {
                        required: "Please enter the last name."
                    },
					"data[GiftCertificate][amount]": {
						required: "Please enter the amount",
						min: "Minimum amount is greater than AED 50."
					}
                },errorPlacement: function(){
                         return false;
                 },
                //perform an AJAX post show_preview function
                submitHandler: function() {
                            if($(document).find('.wel-usr-name').text() !=''){
                            $.post("<?php echo $this->Html->url(array('controller' => 'GiftCertificates', 'action' => 'show_preview', 'admin' => false)); ?>",
                            $('form#giftcertificateForm').serialize(),
                            function(res) {
				if(res == 'unauthorized'){
				    $(document).find('.userLoginModal').trigger('click');
				}else{
				    //alert(res);
				    $(document).find("#myModal").html(res).modal();
				}
			    }, "");
                         }else{
                           $(document).find('.userLoginModal').click();     
                       }
                }
            });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
	$('#GiftCertificateAmount').keyup(function(){
	    var chk = $('#GiftCertificateAmount').val();
	    if(isNaN(chk)){
		$('#GiftCertificateAmount').val('');
	    } else {
		if ((new Number(chk)) < 0){
		    $('#GiftCertificateAmount').val('');
		}
	    }
          if($(this).val().indexOf('.')!=-1){         
		if($(this).val().split(".")[1].length > 2){                
		    if( isNaN( parseFloat( this.value ) ) ) return;
		    this.value = parseFloat(this.value).toFixed(2);
		    return this;
		}  
	     }            
       });
       
       
        $('#GiftCertificateMessagetxt').on('keypress', function(e){
            if(e.which=='13'){
                $(this).value += "\n- ";
                console.log($(this).value);
            }
        });
        $(".designCat").select2();
        //Load Image by category
        var getGiftImageURL = "<?php echo $this->Html->url(array('controller' => 'GiftCertificates', 'action' => 'image_category', 'admin' => false)); ?>";
        $(document).on('change', '#giftcertificateForm .designCat', function() {
            var id = $(this).val();
            $('#giftcertificateForm .dynamicImageFront').load(getGiftImageURL + '/' + id, function() {
            });
        });
        //Load deafault Images by design category
	var cate_id = $('#GiftCertificateGiftImageCategoryId').val();
        $('#giftcertificateForm .dynamicImageFront').load(getGiftImageURL + '/' + cate_id, function() { });
        
         
      });
    $( "input#GiftCertificateEmail" )
      .keyup(function() {
      var txtvalue = $(this).val();
      $("#customerNameToemail").text(txtvalue);
      }).keyup();
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
