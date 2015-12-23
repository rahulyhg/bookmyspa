<?php
    echo $this->Html->css('admin/plugins/tagsinput/jquery.tagsinput.css');
    echo $this->Html->script('admin/plugins/tagsinput/jquery.tagsinput.min.js');
    echo $this->Html->css('admin/plugins/select2/select2.css?v=6');
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
<script>
    var addUserURL = "<?php echo $this->Html->url(array('controller'=>'users','action'=>'addUser','admin'=>true)); ?>";
    var userList = "<?php echo $this->Html->url(array('controller'=>'users','action'=>'list','admin'=>true)); ?>";
    var userView = "<?php echo $this->Html->url(array('controller'=>'users','action'=>'view','admin'=>true)); ?>";
    $(document).ready(function(){
        var list = [6];
        var $modal = $('#commonContainerModal');
        var itsId  = "";
        var form_sub = true;
        $(document).on('click','.addedit_User' ,function(){
            var itsId = $(this).attr('data-id');
            // function in modal_common.js
            fetchModal($modal,addUserURL+'/'+itsId ,'UserAdminAddUserForm');
            form_sub = true;
        });
        
    $(document).on('click','.del_user' ,function(){
        var itsId = $(this).attr('data-uid');
        var salonId = $(this).attr('data-salon_id');
        var confirmed = confirm("Are you sure want to delete this user?");
        if (confirmed==true) {
            $.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'vendorDeleteCustomer','admin'=>true));?>",
                data: { id: itsId,salon_id:salonId}
            })
            .done(function( msg ) {
                msg = $.trim(msg);
                if(msg == '1'){
                  $(".userdataView").load(userList, function() {
                        datetableReInt($(document).find('.userdataView').find('table'),list);
                    });    
                }
                else{
                    alert(msg);
                }
            });
     } 
    else{
        return false;
        }
    });
        
        
    $modal.on('click', '.submitUser', function(e){
         var theBtn = $(this);
         buttonLoading(theBtn);
        var options = { 
            //beforeSubmit:  showRequest,  // pre-submit callback 
            success:function(res){
                 buttonSave(theBtn);
                // onResponse function in modal_common.js
                if(onResponse($modal,'User',res)){
                    $(".userdataView").load(userList, function() {
                        datetableReInt($(document).find('.userdataView').find('table'),list);
                    });    
                }else{
                 form_sub = true;   
                }
            }
        }; 
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
        })
        
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
                    $modal.load(addeditURL, '', function(){
                        $('body').modalmanager('loading');    
                    });    
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
    
    
    datetableReInt($(document).find('.dataTable'),list);
        
        
    $(document).on('keyup','.numOnly' ,function(){
           var value = $(this).val();
              if(isNaN(value)){
                  $(this).val('');
              }
    });   
        
    });
   
</script>
    
<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                     Customer List
                </h3>
                <?php 
                 echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New User</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_User pull-right'));?>
            </div>
            <div class="box-content">
                <div class="userdataView">
                    <?php echo $this->element('admin/users/list_customers'); ?>
                </div>
            </div>    
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(document).on('click','.changeStatus',function(){
            var theJ = $(this);
            var theId = theJ.closest('tr').attr('data-id');
            var statusTo = theJ.attr('data-status');
            
            $.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'changeStatus','admin'=>true));?>",
                data: { id: theId, status: statusTo }
            })
            .done(function( msg ) {
                if(msg == 0){
                    theJ.closest('td').html('<?php echo $this->Common->theStatusImage(0); ?>')
                }
                else{
                    theJ.closest('td').html('<?php echo $this->Common->theStatusImage(1); ?>')
                }
            });
        })
        
        $(document).on('click','.noPermission',function(){
            alert("You don't have permissions to activate or deactivate this customer.")
        });
    });
    

</script>
    