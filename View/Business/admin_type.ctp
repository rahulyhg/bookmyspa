<script>
    var addbTypeURL = "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'addbusinessType','admin'=>true)); ?>";
    var bTypeList = "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'type','admin'=>true)); ?>";
$(document).ready(function(){
    var $modal = $('#commonSmallModal');
    var form_sub = true;
    var itsId  = "";
    $(document).on('click','.addedit_bType' ,function(){
        var itsId = $(this).attr('data-id');
        $('body').modalmanager('loading');
         // function in modal_common.js
        fetchModal($modal,addbTypeURL+'/'+itsId,"BusinessTypeAdminAddbusinessTypeForm");
        form_sub = true;
    });
    
    
    $(document).on('click','.view_bType' ,function(){
        var itsId = $(this).closest('tr').attr('data-id');
        var bTypeView = "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'businesstypeView')); ?>";
        var $bigmodal = $('#commonContainerModal');
        bTypeView = bTypeView+'/'+itsId
        // function in modal_common.js
        fetchModal($modal,bTypeView);
        form_sub = true;
    });
    
    
    $modal.on('click', '.submitBType', function(e){
         var theBtn = $(this);
             buttonLoading(theBtn);
        var options = { 
            //beforeSubmit:  showRequest,  // pre-submit callback 
            success:function(res){
                buttonSave(theBtn);
                if(onResponse($modal,'BusinessType',res)){
                    $(".bTypelistView").load(bTypeList, function() {
                        var list = [4,5];
                        datetableReInt($(document).find('.bTypelistView').find('table'),list);
                    });    
                }else{
                     form_sub = true;   
                    }
            }
        };
        if(!theBtn.hasClass('rqt_already_sent')){
        $modal.find('#BusinessTypeAdminAddbusinessTypeForm').submit(function(){
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
    
    $(document).on('click','.delete_bType' ,function(){
        var itsId = $(this).closest('tr').attr('data-id');
        if(confirm(' Are you sure, you want to delete this Business Type ? ')){
            $.ajax({
            url: "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'deletebusinesstype')); ?>",
            type:'POST',
            data:{'id': itsId }
            }).done(function(response){
                var data = jQuery.parseJSON(response);
                if(data.data == 'success'){
                    $(".bTypelistView").load(bTypeList, function() {
                        var list = [4,5];
                        datetableReInt($(document).find('.bTypelistView').find('table'),list);
                    }); 
                }
                onResponseBoby(response);
            });
        }
    });
    
    var list = [4,5];
    datetableReInt($(document).find('.dataTable'),list);
});
</script>
<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Business Type
                </h3>
                <?php 
                 echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New Business Type</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_bType pull-right'));?>
            </div>
            <div class="box-content">
                <div class="bTypelistView">
                    <?php echo $this->element('admin/Business/business_type'); ?>
                    <?php //echo $this->element('admin/business/list_business'); ?>
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
                url: "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'btypechangeStatus','admin'=>true));?>",
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
    });
</script>