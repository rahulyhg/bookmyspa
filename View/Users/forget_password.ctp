<?php echo $this->Html->script('admin/jquery.form'); ?>
<!--<link href="/css/kendo/kendo.common.min.css" rel="stylesheet">
<link href="/css/kendo/kendo.rtl.min.css" rel="stylesheet">
<link href="/css/kendo/kendo.default.min.css" rel="stylesheet">-->
 <style>
   .userEmail{ color: #A94442;font-size: 14px !important;font-style: italic !important;}    
</style>
 </style> 
<div class="modal-dialog modal-sm">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <h4 class="modal-title" id="myModalLabel">Forgot Password</h4>
    </div>
            <div class="modal-body clearfix">
            <?php echo $this->Form->create('User',array('novalidate'));  ?>
             <ul style="width:100%" class="login-form">
                        <li>
                            <label><?php echo __('E-mail',true); ?><span style='color:red'>*</span></label>
                            <?php echo $this->Form->input('User.forget_email',array('type'=>'email','label'=>false,'div'=>false,'class'=>'login-text-field','minlength'=>'3','maxlength'=>'55','required','validationMessage'=>__("Email is Required.",true),'data-minlength-msg'=>__("Minimum 3 characters.",true),'data-maxlength-msg'=>__("Maximum 55 characters.",true),'data-email-msg'=>__("Please enter valid Email address.",true)));?>
                        <p class="userEmail"></p>
                        </li>
                        <li>
                            <?php echo $this->Form->submit('Submit',array('class'=>'action-button submitForgot','div'=>false,'label'=>false));  ?>
                        </li>
             </ul>           
            <?php echo $this->Form->end(); ?>
        </div>
  </div>
</div>

<script type="text/javascript">
  callRequiredForm();
  $(document).ready(function(){
      var $sModal = $(document).find('#myModal');
        function validateForget(){
           var flag=true;
           if($("#UserForgetEmail").val()==''){
                   $("#UserForgetEmail").css({"border":"1px solid #A94442"});
                   $(".userEmail").text("E-mail is required.");
                   flag= false;
           } else{
               $("#UserForgetEmail").css({"border":"1px solid #CBCBCB"});
               $(".userEmail").text("");
           }
           return flag;
        }
       $('#UserForgetPasswordForm').submit(function(){
           var ret_flg = validateForget();
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

<!--<script src="/js/kendo/kendo.all.min.js"></script>-->

<?php echo $this->Html->script('admin/jquery.form'); ?>
<?php echo $this->Html->script('admin/modal_common'); ?>