<?php echo $this->Html->script('bootbox.js'); ?>
<style>
    .bootbox-body{
        font-size:large;
        margin:15px;
    }
</style>
<?php
echo $this->Html->css('admin/plugins/tagsinput/jquery.tagsinput.css');
echo $this->Html->script('admin/plugins/tagsinput/jquery.tagsinput.min.js');
echo $this->Html->css('admin/plugins/select2/select2');
echo $this->Html->script('admin/plugins/select2/select2.min.js');
echo $this->Html->script('admin/jquery.geocomplete.js');
?>
<!-- gmap -->
<?php echo $this->Html->css('admin/plugins/gmap/gmap3-menu'); ?>
<!-- gmap -->
<?php
echo $this->Html->script('admin/plugins/gmap/gmap3.min.js');
echo $this->Html->script('admin/plugins/gmap/gmap3-menu.js');
?>
<!--<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script> -->
	<div class="col-sm-12 userdetails">
	    <?php echo $this->element('admin/users/manage_element'); ?>
	</div>
 </div>


<script>
function onSelectChange(userId){
    var userDetailURL = "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'manage')); ?>";
    userDetailURL = userDetailURL+'/'+userId;
    $(document).find(".cust-manage123").load(userDetailURL, function() {
            $(document).find("#selectUserId").select2().on("change", function(e) {
                onSelectChange(e.val);
            });
    });    
}
$(document).ready(function(){
   var form_sub = true;
    $(document).find("#selectUserId").select2().on("change", function(e) {
        onSelectChange(e.val);
    });
        
    $(document).off('click','.mobileVbtn').on('click','.mobileVbtn',function(){
        
        var userId = $(this).attr('data-id');
        var token = $(document).find('#verify_phone_code').val();
        if(token){
            $.ajax({
                url: "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'verifyPhone','admin'=>true))?>",
                type: "POST",
                data: {id:userId,token:token},
                success: function(res) {
                    var data = jQuery.parseJSON(res);
                    if(data.data == 'success'){
                        $('body').modalmanager('loading');
                        var userDetailURL = "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'manage')); ?>";
                        userDetailURL = userDetailURL+'/'+data.id
                        $(document).find(".userdetails").load(userDetailURL, function() {
                                $('body').modalmanager('loading');    
                        });
                        alert(data.message);
                    }
                    else{
                        alert(data.message);
                    }
                }
            });    
        }
        else{
            alert('Please enter verification code.');
        }
    });
    
    var $resetmodal = $('#commonSmallModal');
    var itsId ="";
    var restForm = true;
    $(document).off('click','.resetUnPwd').on('click','.resetUnPwd' ,function(){
        itsId = $(this).attr('data-id');
        var resetURL = "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'reset')); ?>";
        resetURL = resetURL+'/'+itsId
        // function in modal_common.js
        $('body').modalmanager('loading');
        fetchModal($resetmodal,resetURL,'UserAdminResetForm');
	restForm = true;
    });
    
    
    $resetmodal.off('click', '.restUserPwd').on('click', '.restUserPwd', function(e){
        var theBtn = $(this);
        buttonLoading(theBtn);
	var options = { 
            success:function(res){
                buttonSave(theBtn);
		
		// onResponse function in modal_common.js
                if(onResponse($resetmodal,'User',res)){
                    var data = jQuery.parseJSON(res);
                    if(data.id){
                        $('body').modalmanager('loading');
                            var userDetailURL = "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'manage')); ?>";
                        userDetailURL = userDetailURL+'/'+data.id
                        $(document).find(".userdetails").load(userDetailURL, function() {
                                onSelectChange(data.id);
                        });
                    }
                }else{
		    restForm = true;   
		}
            }
        }; 
        if(!theBtn.hasClass('rqt_already_sent')){
	    
	$('#UserAdminResetForm').submit(function(){
            if(restForm == true){
                   theBtn.addClass('rqt_already_sent');
                   $(this).ajaxSubmit(options);
                   form_sub = false;
            }
            $(this).unbind('submit');
            $(this).bind('submit');
            return false;
        });
	}
	setTimeout(function(){
	    if($resetmodal.find('dfn.text-danger').length > 0){
		buttonSave(theBtn);
	    }
	},500);
    });
    
    
    var $modal = $('#commonContainerModal');
    var itsId ="";
    $(document).off('click','.addedit_User').on('click','.addedit_User' ,function(){
        itsId = $(this).attr('data-id');
        var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'addUser')); ?>";
        addeditURL = addeditURL+'/'+itsId
        // function in modal_common.js
        $('body').modalmanager('loading');
        fetchModal($modal,addeditURL ,'UserAdminAddUserForm');
        form_sub = true;
    });
    
    $modal.off('click', '.submitUser').on('click', '.submitUser', function(e){
             var theBtn = $(this);
             buttonLoading(theBtn);
        var options = { 
            //beforeSubmit:  showRequest,  // pre-submit callback 
            success:function(res){
                  buttonSave(theBtn);
               // onResponse function in modal_common.js
                if(onResponse($modal,'User',res)){
                    var data = jQuery.parseJSON(res);
                    if(data.id){
                        $('body').modalmanager('loading');
                            var userDetailURL = "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'manage')); ?>";
                        userDetailURL = userDetailURL+'/'+data.id
                        $(document).find(".userdetails").load(userDetailURL, function() {
                                onSelectChange(data.id);
                        });
                    }
                }else{
                     form_sub = true;   
                    }
            }
        } 
         if(!theBtn.hasClass('rqt_already_sent')){
            $('#UserAdminAddUserForm').submit(function(){
               if(form_sub == true){
                   theBtn.addClass('rqt_already_sent');
                   $(this).ajaxSubmit(options);
                   form_sub = false;
               }
               $(this).unbind('submit');
               $(this).bind('submit');
               return false;
           });
         }
            setTimeout(function(){
                if($modal.find('dfn.text-danger').length > 0){
                    buttonSave(theBtn);
                }
            },500);
    });
    
    $modal.on('hide.bs.modal', function (e) {
        $modal.find("#map1").gmap3('destory');
    });
    
    $modal.on('blur','#UserEmail',function(){
        var userEmail = $(this).val();
        $.ajax({
            url: "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'findUserViaEmail','admin'=>true))?>",
            type: "POST",
            data: {email:userEmail},
            success: function(res) {
                
                var data = jQuery.parseJSON(res);
                if(data.data == 'success'){
                    $('body').modalmanager('loading');    
                    var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'addUser')); ?>";
                    addeditURL = addeditURL+'/'+data.id; 
                    $modal.load(addeditURL, '', function(){});    
                }
                
            }
        });
    });
        
    $modal.on('change','#UserImage',function(){
	file = this.files[0];
	var obj = $(this);
	var valReturn = validate_image(file);
	if(valReturn){
	    obj.val('');
	    bootbox.alert(valReturn);
	}
    });
    
    $(document).on('mouseover','.editDeleteImg , .imageView img',function(){
        if(!$(this).hasClass('upUImg')){
            $(document).find('.editDeleteImg').show();
        }
    });
    $(document).on('mouseout','.editDeleteImg , .imageView img',function(){
        $(document).find('.editDeleteImg').hide();
    });
    
    
    var userId = ''
    $(document).on('click','.editUImg , .upUImg',function(){
        userId = $(this).attr('data-id');
        $(document).find('#theImage').click();
    });
    
    $(document).on('click','.deleteUImg',function(){
        userId = $(this).attr('data-id');
        if(confirm('Are you sure?')){
	    $.ajax({
		url: "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'delete_image','admin'=>true))?>",
		type: "POST",
		data: {id:userId},
		success: function(res) {
		    if (res != 'f') {
			$(document).find('.imageView img').attr('src','/img/admin/upload2.png').addClass('upUImg');
			$(document).find('.deleteUImg').hide();
		    }else{
			alert('Error in Deleting Image. Please try again!');
		    }
		}
	    });
	}
    });
    
    $(document).on('change',"#theImage",function() {
        file = this.files[0];
        var obj = $(this);
        if (file == undefined) {
            var msg = 'Please select an image.'
        }
        else {
            name = file.name;
            size = file.size;
            type = file.type;
            
            if (file.name.length < 1) {
                var msg = 'Please select an image.'
                alert(msg);
            }
            else if (file.size > 1500000) {
                obj.prev().val('');
                var msg = 'File is toobig.'
                alert(msg);
            }
            else if (file.type != 'image/png' && file.type != 'image/jpg' && !file.type != 'image/gif' && file.type != 'image/jpeg') {
                obj.prev().val('');
                var msg = 'File doesnt match png, jpg or gif extension.'
                alert(msg);
            }else{
                var formdata = new FormData();
                formdata.append('image', file);
                obj.prev().val('');
                $('body').modalmanager('loading');
                $.ajax({
                    url: "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'upload_image','admin'=>true))?>"+"/"+userId,
                    type: "POST",
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res != 'f') {
                            $(document).find('.imageView img').attr('src','/images/'+userId+'/User/150/'+res).removeClass('upUImg');
                            $(document).find('.deleteUImg').show();
                        }else{
                            alert('Error in Uploading Image. Please try again!');
                        }
                        $('body').modalmanager('loading');
                    }
                });
               
            }
        } 
    });
    
        
    $(document).off('click','.resendLogin').on('click','.resendLogin',function(){
        userId = $(this).attr('data-id');
        requestype = $(this).attr('data-type');
        $('body').modalmanager('loading');
        $.ajax({
            url: "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'resend_logindetails','admin'=>true))?>",
            type: "POST",
            data: {id:userId,type:requestype},
            success: function(res) {
                $('body').modalmanager('loading');  
                if(res=='T'){
                    alert('OTP send successfully!!!');
                }else if(res=='L'){
                    alert('Login Details send successfully!!!');
                }else{
                    alert('Error in Sending!!!');
                }
            }
        });
    });
    
    $(document).on('keyup','.numOnly' ,function(){
        var value = $(this).val();
        /*** Validation for mobile number first character never be zero ***/
	//if (value.length == 1 && value == 0 ){
	  //  $(this).val('');
	//}
	
	if(isNaN(value)){
            $(this).val('');
        }
    });   

});
</script>
