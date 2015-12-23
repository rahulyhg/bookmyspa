<script>

$(document).ready(function(){
    var list = [2];
    var $modal = $('#commonSmallModal');
    
    var itsId  = "";
    $(document).on('click','.addedit_emailTemplate' ,function(){
        var itsId = $(this).attr('data-id');
        var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Emailtemplates','action'=>'addedit')); ?>";
        addeditURL = addeditURL+'/'+itsId
        // function in modal_common.js
        fetchModal($modal,addeditURL);
    });
    
    $modal.on('click', '.update', function(e){
        var options = { 
            //beforeSubmit:  showRequest,  // pre-submit callback 
            success:function(res){
                // onResponse function in modal_common.js
                if(onResponse($modal,'Emailtemplate',res)){
                    $(".emailTemplateView").load("<?php echo $this->Html->url(array('controller'=>'Emailtemplates','action'=>'index')); ?>", function() {
                       datetableReInt($(document).find('.emailTemplateView').find('table'),list);
                    });    
                }
            }
        }; 
        $('#emailTemplateId').submit(function(){
            $(this).ajaxSubmit(options);
            $(this).unbind('submit');
            $(this).bind('submit');
            return false;
        });
    });
  
    datetableReInt($(document).find('.dataTable'),list);
});

</script>
<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Email Templates
                </h3>
                 <?php 
                 echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_emailTemplate pull-right'));?>
             </div>
             
            <div class="box-content">
                <div class="emailTemplateView">
                    <?php echo $this->element('admin/Emailtemplates/list_email_templates');?>
                </div>
           </div>

             </div>
        </section>
    </div>
</div>
