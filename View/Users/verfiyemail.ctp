
<div class="modal-dialog login">
<div class="modal-content">
    <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Login</h4>
    </div>
    <div class="modal-body clearfix">
        <?php echo $this->Form->create('User', array('novalidate','url' => array('controller' => 'users', 'action' => 'login'),'id'=>'UserLogin')); ?>
        <ul class="login-form">
        
        <?php echo $this->Form->hidden('id',array('value'=>base64_encode(base64_encode($userId)),'class'=>'userId')); ?>
          <li class="clearfix">
            <h4><?php echo __('You need to verify your email address to proceed.',true); ?></h4>
          </li>
          <li class="clearfix">
            <h5><?php echo __('Haven\'t got the verification email yet?',true); ?></h5>
          </li>
          <li>
	  <?php echo $this->Form->input('Resend Verification Email',array('type'=>'button','class'=>'action-button resendVEmail','div'=>false,'label'=>false));  ?>
	  </li>
        
        </ul>
        <?php echo $this->Form->end(); ?>
       <ul class="login-form social">
            	<li class="errorMsg">
                    <?php echo $this->Html->link(__('Login with facebook'),'#',array('id'=>'facebook','class'=>'fb-btn')); ?> 
                    <em class="MoreInfoSieasta">Recommended. And we will never post anything without your permission. </em>
                </li>
                <li>
               	  <a href="#" class="google-btn">Login with google</a>
                </li>
		<li class="or" style="margin-top: 5px;">or</li>
                <li class="clearfix">
                <button href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'register')); ?>" type="button" class="action-button black_btn userRegisterModal">sign up</button>
                </li>
       </ul> 
    </div>
    </div>
  </div>
<div id="fb-root"></div>
     <script>               
              var fbmm = {};

              window.fbAsyncInit = function() {
                FB.init({
                  appId : '<?php echo Configure::read('ExtAuth.Provider.Facebook.key'); ?>', // App ID
                  cookie: true, 
                  xfbml: true,
                  status: true,
                  oauth: true
                });
 
                $(document).ready(function(){
                    $("#facebook").click(function(){
                        var connected =false;
			FB.getLoginStatus(function(response) {
			if (response.status === 'connected') {
			    $.ajax({url: '<?php echo $this->Html->url(array("controller"=>"users","action"=>"facebook_login"))?>', success: function(result){
			       window.location.reload();
			    }});
			} else {
			    FB.login(function(response) {
				if (response.authResponse) {
				  FB.api('/me', function(response) {
				     $.ajax({url: '<?php echo $this->Html->url(array("controller"=>"users","action"=>"facebook_login"))?>', success: function(result){
				     window.location.reload();
			    }});
				  });
				} else {
				  alert('User cancelled login or did not fully authorize.');
				}
			 });
			}
		       });
			
                    });
                });

              };

          (function(d){
             var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement('script'); js.id = id; js.async = true;
             js.src = "//connect.facebook.net/en_US/all.js";
             ref.parentNode.insertBefore(js, ref);
           }(document));
	  
	  
	  $(document).ready(function(){
	    var obj =  $(this);
	    obj.find('.login-text-field').focus(function(){
	       obj.find('.alert-dismissable').hide();
	    })
	  });
	  
        </script>