<?php echo $this->Html->script('frontend/jquery.validate'); ?>
<style type="text/css">
    .modal-dialog.gift_certificate_width{
	width: 80% !important
    }
</style>
<script type="text/javascript">
$(function(){
//On click of class show/Hide div
    $('input[type="radio"]').click(function() {
        if ($(this).attr("value") == "1") {
            $(".serviceBoxDiv").removeClass('hidden');
            $(".serviceBoxDiv").show();
            $(".flatAmountDiv").hide();            
        }
        if ($(this).attr("value") == "0") {
            $(".flatAmountDiv").show();
            $(".serviceBoxDiv").hide();
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
		   // alert(response);
		    $('#giftCertificateAmountDiv').html(response);
		    $(".flatAmountDiv").remove();
		}
	    });
	}
  }));    
});    
</script>
<?php echo $this->Form->create('GiftCertificate', array('controller' => 'Place', 'action' => 'show_preview', 'novalidate', 'id' => "giftcertificateForm"), array('novalidate'));

echo $this->Form->hidden('salon_id', array('label' => false, 'div' => false,'value'=>$salonId));
echo $this->element('frontend/GiftCertificates/gift_middle'); 
echo $this->Form->end();
?>
<script type="text/javascript">
var check_for_redeemed = ' ';
    $(document).ready(function(){
	$('#GiftCertificateAmount').keyup(function(){
		var chk = $('#GiftCertificateAmount').val();
	    if(isNaN(chk)){
		$('#GiftCertificateAmount').val('');
	    }else{
		if ((new Number(chk)) < 0){
		    $('#GiftCertificateAmount').val('');
		}
	    }
	     
	});
    })
    var $modal1 = $('#myModal');
    $(document).ready(function() {
        //rules
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
			min: 50
		    }
		},
		messages: {
		    "data[GiftCertificate][first_name]": {
			required: "Please enter the recipient first name."
		    },
		    "data[GiftCertificate][last_name]": {
			required: "Please enter the last name."
		    },
			"data[GiftCertificate][amount]": {
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
				    $(document).find("#myModal").html(res).modal();
				}
			    }, "");
			}else{
			   $(document).find('.salon_gift').html('salon_gift');
                           $(document).find('.userLoginModal').click();     
                       }
		}
	    });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".designCat").select2();
        var getGiftImageURL = "<?php echo $this->Html->url(array('controller' => 'GiftCertificates', 'action' => 'image_category', 'admin' => false)); ?>";
        $(document).on('change', '#giftcertificateForm .designCat', function() {
            var id = $(this).val();
            $('#giftcertificateForm .dynamicImageFront').load(getGiftImageURL + '/' + id+'/<?php echo @$salonId;?>', function() {
            });
        });
	//Load deafault Images by design category
	
	var cate_id = $('#GiftCertificateGiftImageCategoryId').val();
        $('#giftcertificateForm .dynamicImageFront').load(getGiftImageURL + '/' + cate_id, function() { });
	var prodValidator = $("#giftcertificateForm").kendoValidator({
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
		}
	    },
	errorTemplate: "<dfn class='red-txt'>#=message#</dfn>"}).data("kendoValidator");
    });
</script>