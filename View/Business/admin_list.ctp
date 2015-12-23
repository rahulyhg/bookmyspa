<?php
    echo $this->Html->css('admin/plugins/tagsinput/jquery.tagsinput.css');
    echo $this->Html->script('admin/plugins/tagsinput/jquery.tagsinput.min.js');
    echo $this->Html->css('admin/plugins/select2/select2');
    echo $this->Html->script('admin/plugins/select2/select2.min.js');
    echo $this->Html->css('datepicker/datepicker-css');
    echo $this->Html->script('datepicker/datepicker-js');
    echo $this->Html->css('admin/plugins/multiselect/multi-select.css');
    echo $this->Html->script('admin/plugins/multiselect/jquery.multi-select.js');
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
    var addbusinessURL = "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'create','admin'=>true)); ?>";
    var businessList = "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'list','admin'=>true)); ?>";
$(document).ready(function(){
    var list = [5,6,7];
    var $modal = $('#commonContainerModal');
    var itsId  = "";
    var tagchk = true;
    $(document).on('click','.addedit_Business' ,function(){
        var itsId = $(this).attr('data-id');
        addbusinessURLNew = addbusinessURL+'/'+itsId;
        user_type = '<?php echo $_SESSION["Auth"]["User"]['type'] ?>';
        if(user_type !='1'){
            if(itsId){
                addbusinessURLNew += '/salon';
            }}
        // function in modal_common.js
        fetchModal($modal,addbusinessURLNew,'BusinessCreateForm');
        tagchk = true;
    });
    
    $modal.on('click', '.submitBusiness', function(e){
        var theBtn = $(this);
        buttonLoading(theBtn);
        if(!$('#SalonBusinessTypeId').val()){
            $(document).find('#SalonBusinessTypeId_chzn .chzn-choices').addClass('error');
            }
        var options = { 
            //beforeSubmit:  showRequest,  // pre-submit callback 
            success:function(res){
                buttonSave(theBtn);
                // onResponse function in modal_common.js
                if(onResponse($modal,'User',res)){
                    var dummy = new Date().getTime();
                    $(".businessdataView").load(businessList+'?'+dummy, function() {
                        //ar list = [8,9];
                        $(document).find(".businessdataView").find("table").each(function(){
                            datetableReInt($(this),list);    
                        });
                    });    
                }else{
                    tagchk = true;
                }
            }
        };
        if(!theBtn.hasClass('rqt_already_sent')){
            $modal.find('#BusinessCreateForm').submit(function(){
                if(tagchk == true){
                    theBtn.addClass('rqt_already_sent');
                    $(this).ajaxSubmit(options);
                    tagchk = false;
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
      $modal.on('change','#UserImage',function(){
	file = this.files[0];
	var obj = $(this);
	var valReturn = validate_image(file);
	if(valReturn){
	    obj.val('');
	    bootbox.alert(valReturn);
	}
            
    });
     $modal.on('change','#SalonCoverImage',function(){
	file = this.files[0];
	var obj = $(this);
	var valReturn = validate_image(file);
	if(valReturn){
	    obj.val('');
	    bootbox.alert(valReturn);
	}
            
    });
    
    $(document).find('.dataTable').each(function(){
        datetableReInt($(this),list);
    });
    
     $(document).on('keyup','.numOnly' ,function(){
             var value = $(this).val();
                if(isNaN(value)){
                    $(this).val('');
                }
        }); 
        
    $(document).on('blur change' ,'.default', function(event, params){
       setTimeout(function(){
        if($('#SalonBusinessTypeId').val()){
            $(document).find('#SalonBusinessTypeId_chzn .chzn-choices').removeClass('error');
            $(document).find('#SalonBusinessTypeId_chzn').next('.k-invalid-msg').fadeOut();
           }else{
            $(document).find('#SalonBusinessTypeId_chzn .chzn-choices').addClass('error');
            $(document).find('#SalonBusinessTypeId_chzn').next('.k-invalid-msg').fadeIn();
          }
           },200);
       }).change();    
        
        
});

</script>
<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                        <i class="icon-table"></i>
                        Business List
                </h3>
                <?php 
                 echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New Business</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_Business pull-right'));?>
            </div>
            <div class="businessdataView">
               <?php echo $this->element('admin/Business/list_business'); ?>   
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
                url: "<?php echo $this->Html->url(array('controller'=>'business','action'=>'changeStatus','admin'=>true));?>",
                data: { id: theId, status: statusTo }
            }).done(function( msg ) {
                 msg = $.trim(msg);
		if(msg == 0){
                    theJ.closest('td').html('<?php echo $this->Common->theStatusImage(0); ?>')
                }
                else{
                    theJ.closest('td').html('<?php echo $this->Common->theStatusImage(1); ?>')
                }
            });
        });
	
	$(document).on('click','.front_display',function(){
            var theJ = $(this);
            var theId = theJ.closest('tr').attr('data-id');
            var statusTo = theJ.attr('data-status');
            $.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url(array('controller'=>'business','action'=>'changeStatus','admin'=>true));?>",
                data: { id: theId, status: statusTo ,type:'front_display'}
            })
            .done(function( msg ) {
                 msg = $.trim(msg);
		if(msg == 0){
                    theJ.closest('td').html('<?php echo $this->Common->theStatusImage(0 ,"front_display"); ?>');
                }
                else{
                    theJ.closest('td').html('<?php echo $this->Common->theStatusImage(1,"front_display"); ?>');
                }
            });
        });
  });
     $(document).on('click','.delete',function(){
            var theJ = $(this);
            var theId = theJ.attr('data-id');
	    var type = theJ.attr('data-salon_type');
             if(confirm("This will delete :- \n a) All services booked for all customers of that salon. \n b) All Vouchers and gift certificates and IOU of all customers for that salon...\n c) Salon customer database of that salon and not from customer list of superdmin.\n d) Delete all employee for that salon  but their profile will be kept in the customer list of superdmin.\n Are you sure, you want to delete this Business ?")){
	     $.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url(array('controller'=>'users','action'=>'deleteUser','admin'=>true));?>",
                data: { id: theId,salon_type:type}
            }).done(function(msg) {
		msg = $.trim(msg);
		if(msg==1){
		    alert("Business deleted successfully.");
		    theJ.closest('tr').remove();
		}else{
		    alert(msg);
		}
             });
	    }else{
		return false;	
	    } 
	  });
</script>