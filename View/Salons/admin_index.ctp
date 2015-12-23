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
<div class="row">
    <div class="col-sm-12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Salon/Business Listing
                </h3>
               <?php  echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New Business</button>','javascript:void(0);',array('data-id'=>'0','data-type'=>'salon','escape'=>false,'class'=>'addedit_Business pull-right'));?>
            </div>
            <div class="businessdataView">
                <?php echo $this->element('admin/Salon/salon_list'); ?>
            </div>    
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
         var list = [4,7,8];
        $(document).find('.dataTable').each(function(){
            datetableReInt($(this),list);
        });
        var submitForm = 'yes';
        var tagchk = true;
        var logged_in_user_type = "<?php echo $this->Session->read('Auth.User.type'); ?>";
        var addbusinessURL = "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'create','admin'=>true)); ?>";
        if (logged_in_user_type == '1') {
            var businessList = "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'list','admin'=>true)); ?>";
        } else {
            var businessList = "<?php echo $this->Html->url(array('controller'=>'Salons','action'=>'index','admin'=>true)); ?>";
        }
        $businessPage = "<?php echo $this->Html->url(array('controller'=>'Salons','action'=>'index','admin'=>true)); ?>";
        var $modal = $('#commonContainerModal');
        var itsId = "";
        $(document).on('click', '.addedit_Business', function(){
            var itsId = $(this).attr('data-id');
            var theId = 0;
            if (itsId) {
                theId = itsId;
            }
            var type = $(this).attr('data-type');
            // function in modal_common.js
            fetchModal($modal, addbusinessURL + '/' + theId + '/' + type,'BusinessCreateForm');
            submitForm = 'yes';
        });
        
        
        $modal.on('click', '.submitBusiness', function(e){
              var theBtn = $(this);
              buttonLoading(theBtn);
                if(!$('#SalonBusinessTypeId').val()){
                    console.log('hererer');
                    $(document).find('#SalonBusinessTypeId_chzn .chzn-choices').addClass('error');
                }
              
            var options = {
                //beforeSubmit:  showRequest,  // pre-submit callback 
                success: function(res) {
                    buttonSave(theBtn);
                    // onResponse function in modal_common.js
                    if (onResponse($modal, 'User', res)){
                        obj = jQuery.parseJSON(res);
                        $(".businessdataView").load(businessList,function() {
                            var list = [7, 8];
                            $(document).find('.businessdataView').find('table').each(function() {
                                datetableReInt($(this), list);
                            })
                        });
                    }else{
                        tagchk = true;
                    }
                }
            };
            if(!theBtn.hasClass('rqt_already_sent')){
                    $modal.find('#BusinessCreateForm').submit(function() {
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
        /*****************************status**************************/
        $(document).on('click', '.changeStatus', function(){
            var theJ = $(this);
            var theId = theJ.closest('tr').attr('data-id');
            var statusTo = theJ.attr('data-status');

            $.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url(array('controller'=>'business','action'=>'changeStatus','admin'=>true));?>",
                data: {id: theId, status: statusTo}
            }).done(function(msg) {
                if (msg == 0) {
                    theJ.closest('td').html('<?php echo $this->Common->theStatusImage(0); ?>')
                }
                else {
                    theJ.closest('td').html('<?php echo $this->Common->theStatusImage(1); ?>')
                }
            });
        });
        /*****************************status**************************/
        $(document).on('click', '.delete_user', function(e) {
            e.preventDefault();
            var theJ = $(this);
            theId = theJ.data('id');
            if (confirm('Are you sure?')) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->Html->url(array('controller'=>'Salons','action'=>'deleteUser','admin'=>true));?>",
                    data: {id: theId},
                    success: function(response) {
                        if ($.trim(response) == '1') {
                            theJ.closest('tr').remove();
                        } else {
                            alert('Some Error occured!!');
                        }
                    }
                })
            }
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
                if(msg == 0){
                    theJ.closest('td').html('<?php echo $this->Common->theStatusImage(0 ,"front_display"); ?>');
                }
                else{
                    theJ.closest('td').html('<?php echo $this->Common->theStatusImage(1,"front_display"); ?>');
                }
            });
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