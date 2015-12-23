
<style>
   .username,.password{ color: #A94442;font-size: 14px !important;font-style: italic !important;}
   .well {
        margin-top:20px;
   }
   .wrapper{
	  background: #5B3671;
	  padding-top: 5%; 
   }
   html{
	  background: #5B3671;
   }
   .btn-inverse{
        background: none repeat scroll 0 0 #5b3671;
        border: medium none;
        border-radius: 3px;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        line-height: 19px;
        /*padding: 15px 0;*/
		
        text-transform: uppercase;
        width: 50%;
    }
   .btn-inverse:hover{
	  color: white;	
   }
   .btn-inverse:focus {
	  color: white;
   }
    .login-text-field{
		 border: 1px solid #cbcbcb;
		 border-radius: 3px;
        color: #b4b4b4;
        font-size: 14px;
        height: 36px;
        line-height: 36px;
        padding: 0 15px;
        width: 100%;
        
    }
    
</style>
<div class="wrapper">
	<div class="container">
    <!--main body section starts-->
    <div class="col-sm-12 business">
        <div class="alert alert-danger alert-dismissable errorDiv" style="margin-top:20px; display:none" ><div class="error help-block">Invalid username or password, try again</div></div>
    	<div class="well clearfix text-left custom_well">
	<p>Your screen has been locked. Enter your password to unlock the window.</p>
        <div class="col-sm-5"  style="border-right:1px solid">
             <div class="form-group">
                <label>
				  <br>
                        <?php
                        if(isset($user['User']['image']) && !empty($user['User']['image'])){
                            
                            echo $this->Html->Image("/images/".$user['User']['id']."/User/150/".$user['User']['image'],array('width'=>"200", 'height'=>"100"));
                        }
                        else{
                            echo $this->Html->Image('admin/user.jpg',array('width'=>"200", 'height'=>"100"));
                        }
                        ?>
						<br>
                        <?php if(isset($user['User']['first_name']) && !empty($user['User']['first_name'])){
                            $userName = ucfirst($user['User']['first_name']).' '.ucfirst($user['User']['last_name']);
                        }
                        else{
                            $userName = $user['User']['username'];
                        } ?>
                        <?php echo $this->Html->link(_('Not')." ".$userName." ?","javascript:void(0)",array('class'=>'notYou','escape'=>false))?></label>
            </div>
        </div>
        <div class="col-sm-7">
         <div class="col-sm-9">
             <div class="form-group">
                <div class="col-sm-10">
                        <label> <h2><?php echo $userName; ?></h2>
                        <span>Locked</span></label>
                <?php echo $this->Form->create('User',array('novalidate','id'=>'UserLoginLock','url'=>array('controller'=>'users','action'=>'login','admin'=>false)));?>
                <?php echo $this->Form->hidden('User.username',array('value'=>$user['User']['email'],'type'=>'text','label'=>false,'div'=>false,'class'=>' '));?>
                <?php echo $this->Form->input('User.password',array('type'=>'password','label'=>false,'div'=>false,'class'=>'login-text-field ','placeholder'=>__('Password')));?>
                        <p class="password"></p>
                </div>
                <div class="col-sm-9">
                       <?php echo $this->Form->submit('Unlock',array('class'=>'btn btn-inverse','div'=>false,'label'=>false));  ?>
                </div>
                       
        <?php echo $this->Form->end(); ?>
            </div>
             <div>
             
         </div>
        
         
        </div>
         
    </div>
    </div>
    <!--main body section ends-->
  </div>

<!--
<div class="pull-left">
        <?php
        if(isset($user['User']['image']) && !empty($user['User']['image'])){
            
            echo $this->Html->Image("/images/".$user['User']['id']."/User/150/".$user['User']['image'],array('width'=>"200", 'height'=>"200"));
        }
        else{
            echo $this->Html->Image('admin/user.jpg',array('width'=>"200", 'height'=>"200"));
        }
        ?>
        <?php if(isset($user['User']['first_name']) && !empty($user['User']['first_name'])){
            $userName = ucfirst($user['User']['first_name']).' '.ucfirst($user['User']['last_name']);
        }
        else{
            $userName = $user['User']['username'];
        } ?>
        <?php echo $this->Html->link(_('Not')." ".$userName." ?","javascript:void(0)",array('class'=>'notYou','escape'=>false))?>
</div>
<div class="right">
        <div class="upper">
                <h2><?php echo $userName; ?></h2>
                <span>Locked</span>
        </div>
        <?php echo $this->Form->create('User',array('novalidate','id'=>'UserLogin','url'=>array('controller'=>'users','action'=>'login','admin'=>false)));?>
        <?php echo $this->Form->hidden('User.username',array('value'=>$user['User']['email'],'type'=>'text','label'=>false,'div'=>false,'class'=>' '));?>
        <?php echo $this->Form->input('User.password',array('type'=>'password','label'=>false,'div'=>false,'class'=>'login-text-field ','placeholder'=>__('Password')));?>
                <p class="password"></p>
                <div>
                        <?php echo $this->Form->submit('Unlock',array('class'=>'btn btn-inverse','div'=>false,'label'=>false));  ?>
                </div>
        <?php echo $this->Form->end(); ?>
</div>-->
   <!--</div> 
   </div>
  </div>
					

					</div>
			</div>
        </div>

-->
<script type="text/javascript">
$(document).ready(function(){
   $('#UserLoginLock').off('click').on('submit',function(){
	  var ret_flg = validateLogin();
    // alert(ret_flg);   
	if (ret_flg === true) {
	  var options = { 
		    success:function(res){
			var data = jQuery.parseJSON(res);
			if(data.data == 'verify_email'){
			    $(document).find('.loader-container').hide();
			    $(".errorDiv").find(".error").html("Email is not verified");
			    return false;
			}
			if(data.data == 'varify_phone'){
			    $(document).find('.loader-container').hide();
			    $(".errorDiv").find(".error").html("Phone number is not verified");
			    return false;
			}
			
			if(data.data == 'verify_phone'){
			    $(document).find('.loader-container').hide();
			    $(".errorDiv").find(".error").html("Phone number is not verified");
			}
			if(data.data == 'admin'){
			   window.location.href = data.redirectUrl;
                                return false;
			}
			if(data.data == 'success'){
                            if(gift_check()){   
                                return false;
                            }else{    
                               	window.location.href ='<?php echo $this->Html->url(array("controller"=>"Myaccount","action"=>"appointments")); ?>';
                                return false;
                            }
			}else{
                                http://172.24.2.222:8079/admin/Users/lock
                            $(document).find('.loader-container').hide();
			    $(".errorDiv").show().find(".error").html("Invalid username or password, try again");  
                        }
		    }
		};
		$(this).ajaxSubmit(options);
		return false;
	} else {
	    return false;
	}
    });
        
        $(document).on('click','.notYou',function(){
           $(".userLoginModal").trigger('click');
        });
        
        
});

function validateLogin(){
	var flag=true;
	var obj = $("#UserLoginLock");
	if(obj.find("#UserUsername").val()==''){
		obj.find("#UserUsername").css({"border":"1px solid #A94442"});
		obj.find(".username").text("E-mail / Username is required.");
		flag= false;
	} else{
	    obj.find("#UserUsername").css({"border":"1px solid #CBCBCB"});
	    obj.find(".username").text("");
	}
	
	if(obj.find("#UserPassword").val()==''){
	  //alert('here');
		obj.find("#UserPassword").css({"border":"1px solid #A94442"});
		obj.find(".password").text("Password is required.");
		flag= false;
	} else{
	    obj.find("#UserPassword").css({"border":"1px solid #CBCBCB"});
	    obj.find(".password").text("");
	}
	return flag;
    }
</script>