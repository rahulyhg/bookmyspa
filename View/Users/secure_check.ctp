<style>
    .newConfPassword,.newpassword{ color: #A94442;font-size: 14px !important;font-style: italic !important;}    
</style>
<div class="modal-dialog modal-sm">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <h4 class="modal-title" id="myModalLabel">Reset Password</h4>
    </div>
    <div class="modal-body clearfix">
    <?php echo $this->Form->create('User', array('id'=>'changePasswordId', 'noValidate' => true));?>
     <ul style="width:100%" class="login-form">
                <li>
                     <label><?php echo __('New Password',true); ?></label>
                    <?php echo $this->Form->input('password',array('label' => false,'div' => false, 'placeholder' => 'New Password','class' => 'login-text-field','maxlength' => 30,'type' => 'password','required','validationMessage'=>__("New_Password_is_Required",true),'data-minlength-msg'=>__("Minimum_8_characters",true),'minlength'=>'8'));?>                
                     <p class="newpassword"></p>
                 </li>
                <li>
                     <label><?php echo __('Confirm Password',true); ?></label>
                    <?php echo $this->Form->input('confirm_password',array('label' => false,'div' => false, 'placeholder' => 'Confirm Password','class' => 'login-text-field','maxlength' => 30,'type' => 'password','required','validationMessage'=>__("Con_Password_is_Required",true),'data-minlength-msg'=>__("Minimum_8_characters",true),'minlength'=>'8','confirmpassword'=>'#UserPassword','data-confirmpass-msg'=>__("These passwords don't match.",true)));?>
                     <p class="newConfPassword"></p>
                </li> 
                <li>
                    <?php echo $this->Form->submit('Submit',array('class'=>'action-button savePassword','div'=>false,'label'=>false));  ?>
                </li>
     </ul>           
    <?php echo $this->Form->end(); ?>
</div>
  </div>
</div>
<?php echo $this->Html->script('admin/jquery.form');
echo $this->Html->script('admin/modal_common');?>
<script type="text/javascript">
    
//callRequiredForm();
$(document).ready(function(){
    var $sModal = $(document).find('#mySmallModal');
    // alert($sModal);
    function checkPassword(){
        if($("#UserPassword").val()==''){
            $("#UserPassword").css({"border":"1px solid #A94442"});
            $(".newpassword").text("Password is required.");
            return false;
        }else if($("#UserPassword").val()!=""){
            if($("#UserPassword").val().length<8){
                $("#UserPassword").css({"border":"1px solid #A94442"});
                $(".newpassword").text("Minimum 8 characters.");
                return false;
            }else{
                $("#UserPassword").css({"border":"1px solid #CBCBCB"});
                $(".newpassword").text("");
            }
        }
    }
    function checkConfirmPassword(){
	if($("#UserConfirmPassword").val()==''){
		$("#UserConfirmPassword").css({"border":"1px solid #A94442"});
		$(".newConfPassword").text("Confirm password is required.");
		return false;
	}else if($("#UserPassword").val()!=$("#UserConfirmPassword").val()){
                $("#UserConfirmPassword").css({"border":"1px solid #A94442"});
		$(".newConfPassword").text("Confirm and New password should be same.");
		return false;
        }else{
	    $("#UserConfirmPassword").css({"border":"1px solid #CBCBCB"});
	    $(".newConfPassword").text("");
	}
    }
    
    function validateReset(){
	var flag=true;
	if($("#UserPassword").val()==''){
		$("#UserPassword").css({"border":"1px solid #A94442"});
		$(".newpassword").text("Password is required.");
		flag=false;
        }else if($("#UserPassword").val()!=""){
            if($("#UserPassword").val().length<8){
                $("#UserPassword").css({"border":"1px solid #A94442"});
                $(".newpassword").text("Minimum 8 characters.");
                flag=false;
            }else{
                $("#UserPassword").css({"border":"1px solid #CBCBCB"});
                $(".newpassword").text("");
            }
        }	
	if($("#UserConfirmPassword").val()==''){
		$("#UserConfirmPassword").css({"border":"1px solid #A94442"});
		$(".newConfPassword").text("Confirm password is required.");
		flag=false;
	}else if($("#UserPassword").val()!=$("#UserConfirmPassword").val()){
                $("#UserConfirmPassword").css({"border":"1px solid #A94442"});
		$(".newConfPassword").text("Confirm and New password should be same.");
		flag=false;
        }else{
	    $("#UserConfirmPassword").css({"border":"1px solid #CBCBCB"});
	    $(".newConfPassword").text("");
	}
	return flag;
    }
    
    
    $('#UserPassword').blur(function(){
	checkPassword();
    });
    
    $('#UserConfirmPassword').blur(function(){
	checkConfirmPassword();
    });
    
    $('#changePasswordId').submit(function(){
	var ret_flg = validateReset();
	if (ret_flg === true) {
		var options = { 
		    success:function(res){
                        if(onResponse($sModal,'User',res)){
                        window.location = '/';
                    }
		    }
		};
		$(this).ajaxSubmit(options);
		return false;
	} else {
	    return false;
	}
    });
});

</script>


 