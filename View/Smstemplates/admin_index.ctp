<script>

$(document).ready(function(){
    
    var $modal = $('#commonSmallModal');
    
    var itsId  = "";
    $(document).on('click','.addedit_smsTemplate' ,function(){
        var itsId = $(this).attr('data-id');
        var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Smstemplates','action'=>'addedit')); ?>";
        addeditURL = addeditURL+'/'+itsId
        // function in modal_common.js
        fetchModal($modal,addeditURL);
    });
    
    $modal.on('click', '.update', function(e){
        var options = { 
            //beforeSubmit:  showRequest,  // pre-submit callback 
            success:function(res){
                // onResponse function in modal_common.js
                if(onResponse($modal,'Smstemplate',res)){
                    $(".smsTemplateView").load("<?php echo $this->Html->url(array('controller'=>'Smstemplates','action'=>'index')); ?>", function() {
                        var list = [3];
                        datetableReInt($(document).find('.smsTemplateView').find('table'),list);
                    });    
                }
            }
        }; 
        $('#smsTemplateForm').submit(function(){
            $(this).ajaxSubmit(options);
            $(this).unbind('submit');
            $(this).bind('submit');
            return false;
        });
    });
    var list = [3];
    datetableReInt($(document).find('.dataTable'),list);
});

</script>
<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Sms Templates
                </h3>
                 <?php 
                 echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_smsTemplate pull-right'));?>
             </div>
             
            <div class="box-content">
                <div class="smsTemplateView">
                    <?php echo $this->element('admin/Smstemplates/list_sms_templates');?>
                </div>
           </div>

             </div>
        </section>
    </div>
</div>
