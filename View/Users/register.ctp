<?php echo $this->Html->script('admin/jquery.form'); ?>
<!--<link href="/css/kendo/kendo.common.min.css" rel="stylesheet">
<link href="/css/kendo/kendo.rtl.min.css" rel="stylesheet">
<link href="/css/kendo/kendo.default.min.css" rel="stylesheet">-->
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script> 
<style>
    .small_font{
        font-size: 13px;
    }
    .small_font > a {
      color: #5b3671;
  }
  .userFirst,.userLast,.userEmail,.userPassword{ color: #A94442;font-size: 14px !important;font-style: italic !important;}    
</style>
<div class="modal-dialog modal-sm">
  <div class="modal-content">
    <div class="modal-header">
      <!--<button type="button" class="back" data-dismiss="modal"><span aria-hidden="true">&lt;</span><span class="sr-only">Close</span></button>-->
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <h4 class="modal-title" id="myModalLabel"><?php echo __('SIGN UP',true); ?></h4>
    </div>
    <div class="modal-body clearfix">
      <?php  echo $this->Form->create('User', array('novalidate','url' => array('controller' => 'users', 'action' => 'register'),'id'=>'userRegister'));?>
        <ul style="width: 100%;" class="login-form no-pdng">
	  <li>
	      <label><?php echo __('first_name',true); ?>*</label>
	      <?php echo $this->Form->hidden('Address.id',array('label'=>false,'div'=>false));?>
	      <?php echo $this->Form->hidden('Address.country_id',array('label'=>false,'div'=>false));?>
	      <?php echo $this->Form->hidden('Address.state_id',array('label'=>false,'div'=>false));?>
	      <?php echo $this->Form->hidden('Address.city_id',array('label'=>false,'div'=>false));?>
	      <?php echo $this->Form->hidden('Address.longitude',array('label'=>false,'div'=>false));?>
	      <?php echo $this->Form->hidden('Address.latitude',array('label'=>false,'div'=>false));?>
	      <?php echo $this->Form->hidden('Address.address',array('label'=>false,'div'=>false));?>
	      <?php echo $this->Form->input('first_name',array('label' => false,'div' => false, 'class' => 'login-text-field ','minlength'=>'3','onblur'=>'checkFirstName();', 'required','pattern'=>'^[A-Za-z ]+$','validationMessage'=>__("First Name is Required.",true),'data-minlength-msg'=>__("Minimum 3 characters.",true),'data-pattern-msg'=>__("Please enter only alphabets.",true),'maxlengthcustom'=>'55','data-maxlengthcustom-msg'=>__("Maximum 55 characters are allowed.",true),'maxlength'=>58));?>    
              <p class="userFirst"></p>
	  </li>
	  <li>
	      <label><?php echo __('last_name',true); ?>*</label>
	      <?php echo $this->Form->input('last_name',array('label' => false,'div' => false, 'class' => 'login-text-field','minlength'=>'3','onblur'=>'checkLastName();', 'required','pattern'=>'^[A-Za-z ]+$','validationMessage'=>__("Last Name is Required.",true),'data-minlength-msg'=>__("Minimum 3 characters.",true),'data-pattern-msg'=>__("Please enter only alphabets.",true),'maxlengthcustom'=>'55','data-maxlengthcustom-msg'=>__("Maximum 55 characters are allowed.",true),'maxlength'=>58));?>    
	  <p class="userLast"></p>
          </li>
	  <li>
	      <label><?php echo __('Login_Email',true); ?>*</label>
	      <?php echo $this->Form->input('email',array('type'=>'email','label' => false,'div' => false, 'class' => 'login-text-field','minlength'=>'3','onblur'=>'checkEmail()', 'maxlength'=>'58','required','validationMessage'=>__("Email is Required.",true),'data-minlength-msg'=>__("Minimum 3 characters.",true),'data-maxlengthcustom-msg'=>__("Maximum 55 characters are allowed.",true),'data-email-msg'=>__("Please enter valid Email address.",true),'maxlengthcustom'=>'55'));?>    
              <p class="userEmail"></p>
	  </li>
	  <li>
	      <label><?php echo __('Password',true); ?>*</label>
	      <?php echo $this->Form->input('User.password',array('type'=>'password','label'=>false,'div'=>false,'class'=>'login-text-field','minlength'=>'8','onblur'=>'checkPassword();','required','validationMessage'=>__("Password is Required.",true),'data-minlength-msg'=>__("Minimum 8 characters.",true),'maxlengthcustom'=>'55','data-maxlengthcustom-msg'=>__("Maximum 55 characters are allowed.",true),'maxlength'=>58));?>
              <p class="userPassword"></p>
	  </li>
	  <li class="pos-rel">
	      <?php echo $this->Form->input('send_email_updates',array('type'=>'checkbox','div'=>false,'label'=>array('class'=>'new-chk','text'=>__('Send me occasional email updates',true),)));
	      
	 echo $this->Form->input('facebook_merge' , array('type'=>'hidden' ,'value'=>'','class'=>'facebook_merge'));
	      ?>
	      <!--<label class="light-label"><?php //echo __('Send me occasional email updates ',true); ?></label>-->
	  </li>
         <li class="pos-rel">
             <span class="small_font"> <?php   $label = __('By creating an account, you agree to Sieasta\'s ',true);
                $label = $label.$this->Html->link(__('Terms of Service',true),array('controller'=>'StaticPages','action'=>'legal',10),
			array('escape'=>false,'target'=>'_blank'));
		
		$label = $label.', '.$this->Html->link(__('Privacy Policy',true),array('controller'=>'StaticPages','action'=>'legal',12),
			array('escape'=>false,'target'=>'_blank'));
		$label = $label.' and '.$this->Html->link(__('Content Policies',true),
			array('controller'=>'StaticPages','action'=>'legal',13),array('escape'=>false,'target'=>'_blank'));
			echo $label; ?>
			<?php /*echo  $label = $label.$this->Html->link(__('Terms of Service',true),array('controller'=>'StaticPages','action'=>'legal',10),
			array('escape'=>false,'target'=>'_blank')).', '.$this->Html->link(__('Privacy Policy',true),
			array('controller'=>'StaticPages','action'=>'legal',12),
			array('escape'=>false,'target'=>'_blank')).' and '.$this->Html->link(__('Content Policies',true),
			array('controller'=>'StaticPages','action'=>'legal',13),array('escape'=>false,'target'=>'_blank')); */?>
             </span>   <?php //echo $this->Form->input('terms_n_condition',array('type'=>'checkbox','div'=>false,'label'=>array('class'=>'new-chk','text'=>$label),'required','validationMessage'=>__("Terms and conditions are required.",true)));  ?>
         </li>
        <li>
             <?php echo $this->Form->submit(__('Register',true),array('class'=>'action-button submitReg','div'=>false,'label'=>false));  ?>
        </li>
      </ul>
      <?php echo $this->Form->end(); ?>
    </div>
  </div>
</div>


<!--<script src="/js/kendo/kendo.all.min.js"></script>-->
<?php echo $this->Html->script('admin/jquery.form');
echo $this->Html->script('admin/modal_common');?>


<script type="text/javascript">
    callRequiredForm();
//Get the latitude and the longitude;
function successFunction(position) {
    var lat1 = position.coords.latitude;
    var lng1= position.coords.longitude;
    $.ajax({
            url: "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'getLocation'))?>",
            type: "POST",
            data: {lat:lat1,lng:lng1},
            success: function(res) {
                var data 	= jQuery.parseJSON(res);
		if(data !=''){
                    Country     = data[0].countries.id;
		    State       = data[0].states.id;
		    City        = data[0].cities.id;
		    Address     = data[0].countries.name+','+data[0].states.name+','+data[0].cities.city_name;
		    $("#AddressCountryId").val(Country);
		    $("#AddressStateId").val(State);
		    $("#AddressCityId").val(City);
		    $("#AddressLongitude").val(lng1);
		    $("#AddressLatitude").val(lat1);
		    $("#AddressAddress").val(Address);
		    //IsoCode     = data[0].countries.iso_code;
		}
	    }
	  });

}
function errorFunction(){}
// function initialize() {
$(document).ready(function(){
    // callRequiredForm();
    var geocoder;
    //geocoder = new google.maps.Geocoder();
    //Autofill Country State and Location/Area
    //    if (navigator.geolocation) {
    //	navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
    //    }
});
function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test(email)) {
       return false;
    }else{
       return true;
    }
}
function alphanumeric(input){
    var regx = /^[A-Za-z\'_-]+$/;
    if(!regx.test(input)){
        return false;
    }else{
        return true;
    }
}
function checkFirstName(){
    if($("#UserFirstName").val()==''){
            $("#UserFirstName").css({"border":"1px solid #A94442"});
            $(".userFirst").text("First Name is required.");
            return false;
    }else if($("#UserFirstName").val()!=""){
        if(!alphanumeric($("#UserFirstName").val())){
            $("#UserFirstName").css({"border":"1px solid #A94442"});
            $(".userFirst").text("Letters And Apostrophe Only.");
            return false;
        }else if($("#UserFirstName").val().length<3 || $("#UserFirstName").val().length>55){
            $("#UserFirstName").css({"border":"1px solid #A94442"});
            $(".userFirst").text("Minimum 3 and maximum 55 characters.");
            return false;
        }else{
            $("#UserFirstName").css({"border":"1px solid #CBCBCB"});
            $(".userFirst").text("");
        }
    }
}
function checkLastName(){
    if($("#UserLastName").val()==''){
            $("#UserLastName").css({"border":"1px solid #A94442"});
            $(".userLast").text("Last Name is required.");
            return false;
    }else if($("#UserLastName").val()!=""){
        if(!alphanumeric($("#UserLastName").val())){
            $("#UserLastName").css({"border":"1px solid #A94442"});
            $(".userLast").text("Letters And Apostrophe Only.");
            return false;
        }else if($("#UserLastName").val().length<3 || $("#UserLastName").val().length>55){
            $("#UserLastName").css({"border":"1px solid #A94442"});
            $(".userLast").text("Minimum 3 and maximum 55 characters.");
            return false;
            
        }else{
            $("#UserLastName").css({"border":"1px solid #CBCBCB"});
            $(".userLast").text("");
        }
    }
}
function checkEmail(){
    var email= $('#UserEmail').val();
    if(email==""){
        $("#UserEmail").css({"border":"1px solid #A94442"});
        $(".userEmail").text("Email is required.");
        return false;
    }else if(email!=""){
        if(!IsEmail(email)){
            $("#UserEmail").css({"border":"1px solid #A94442"});
            $(".userEmail").text("Please enter valid Email address.");
            return false;
        }else{
            $("#UserEmail").css({"border":"1px solid #CBCBCB"});
            $(".userEmail").text("");
        }
    }
}
function checkPassword(){
    if($("#UserPassword").val()==''){
            $("#UserPassword").css({"border":"1px solid #A94442"});
            $(".userPassword").text("Password is required.");
            return false;
    }else if($("#UserPassword").val()!=""){
        if($("#UserPassword").val().length<8){
            $("#UserPassword").css({"border":"1px solid #A94442"});
            $(".userPassword").text("Minimum 8 characters.");
            return false;
        }else{
            $("#UserPassword").css({"border":"1px solid #CBCBCB"});
            $(".userPassword").text("");
        }
    }
}
function validateRegister(){
    var flag=true;
    var email= $('#UserEmail').val();
    if($("#UserFirstName").val()==''){
        $("#UserFirstName").css({"border":"1px solid #A94442"});
        $(".userFirst").text("First Name is required.");
        flag= false;
    }else if($("#UserFirstName").val()!=""){
        if(!alphanumeric($("#UserFirstName").val())){
            $("#UserFirstName").css({"border":"1px solid #A94442"});
            $(".userFirst").text("Letters And Apostrophe Only.");
            flag= false;
        }else if($("#UserFirstName").val().length<3 || $("#UserFirstName").val().length>55){
            $("#UserFirstName").css({"border":"1px solid #A94442"});
            $(".userFirst").text("Minimum 3 and maximum 55 characters.");
            flag= false;
        }else{
            $("#UserFirstName").css({"border":"1px solid #CBCBCB"});
            $(".userFirst").text("");
        }
    }
    if($("#UserLastName").val()==''){
            $("#UserLastName").css({"border":"1px solid #A94442"});
            $(".userLast").text("Last Name is required.");
            flag= false;
    }else if($("#UserLastName").val().length<3 || $("#UserLastName").val().length>55){
            $("#UserLastName").css({"border":"1px solid #A94442"});
            $(".userLast").text("Minimum 3 and maximum 55 characters.");
            flag= false;
    }else{
        $("#UserLastName").css({"border":"1px solid #CBCBCB"});
        $(".userLast").text("");
    }
    if(email==""){
        $("#UserEmail").css({"border":"1px solid #A94442"});
        $(".userEmail").text("Email is required.");
        flag= false;
    }else if(email!=""){
        if(!IsEmail(email)){
            $("#UserEmail").css({"border":"1px solid #A94442"});
            $(".userEmail").text("Please enter valid Email address.");
            flag= false;
        }else{
            $("#UserEmail").css({"border":"1px solid #CBCBCB"});
            $(".userEmail").text("");
        }
    }
    if($("#UserPassword").val()==''){
            $("#UserPassword").css({"border":"1px solid #A94442"});
            $(".userPassword").text("Password is required.");
            flag= false;
    }else if($("#UserPassword").val()!=""){
        if($("#UserPassword").val().length<8){
            $("#UserPassword").css({"border":"1px solid #A94442"});
            $(".userPassword").text("Minimum 8 characters.");
            flag= false;
        }else{
            $("#UserPassword").css({"border":"1px solid #CBCBCB"});
            $(".userPassword").text("");
        }
    }
    return flag;
}

    $(document).ready(function(){
	var $sModal = $(document).find('#mySmallModal');
    	$('#userRegister').submit(function(){
            var ret_flg = validateRegister();
            if (ret_flg === true) {
            var options = { 
                    //beforeSubmit:  showRequest,  // pre-submit callback 
                    success:function(res){
                        // onResponse function in modal_common.js
                        var data = jQuery.parseJSON(res);
                        if(data.data == 'regFacebook'){
			    if(confirm("This email is already existed with us.Do you want to merge this account with facebook account.?")){
				$(document).find('.facebook_merge').val("1");
				$(document).find('.submitReg').click();
				return;
			  }else{
				message = 'This Email is already exist Please change your email.';
				$sModal.find('.modal-body').prepend('<div class="alert alert-danger alert-dismissable"><div class="error help-block">' + message +'</div></div>');
				return false;
			  }
                        }
			if(data.data == 'mergerd'){
			    var loginURL = '<?php echo $this->Html->url(array('controller'=>'users','action'=>'login','admin'=>false));?>';
                            $sModal.load(loginURL,function(){
                                $sModal.modal('show');
                                $sModal.find('.modal-body').prepend('<div class="alert alert-success alert-dismissable"><div class="error help-block">'+data.message+'</div></div>');
                            });
			    return false;
			} 
                        if(onResponse($sModal,'User',res)){
                            var res = jQuery.parseJSON(res);
                            window.location = '/users/thanks/'+res.Id;
                        }
                    }
                }; 
                //$('#userRegister').unbind('submit').submit(function(e){
                    //if(regValid.validate()){
                    $(this).ajaxSubmit(options);
                    //}
                    //e.preventDefault(); 
                   // $(this).unbind('submit');
                    //$(this).bind('submit');
                    return false;
                //});
                }
                else {
                    return false;
                }
           });
	
        });
</script>