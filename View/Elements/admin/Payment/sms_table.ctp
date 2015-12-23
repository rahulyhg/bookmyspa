<script>

$(document).ready(function(){
    
    var $modal = $('#commonSmallModal');
    
    var itsId  = "";
        $(document).off('click','.addedit_smsPlan').on('click','.addedit_smsPlan' ,function(){
            var itsId = $(this).attr('data-id');
            
            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'payments','action'=>'smsPlan')); ?>";
            addeditURL = addeditURL+'/'+itsId
            // function in modal_common.js
            fetchModal($modal,addeditURL,'SmsSubscriptionPlanAdminSmsPlanForm');
        });

    $(document).on('click','.delete_smsPlan' ,function(){
        var itsId = $(this).closest('tr').attr('data-id');
        if(confirm(' Are you sure, you want to delete this SMS Plan ? ')){
            $.ajax({
            url: "<?php echo $this->Html->url(array('controller'=>'payments','action'=>'deletePlan','sms')); ?>",
            type:'POST',
            data:{'id': itsId }
            }).done(function(response){
                var data = jQuery.parseJSON(response);
                if(data.data == 'success'){
                     $(".smsdataView").load("<?php echo $this->Html->url(array('controller'=>'payments','action'=>'plans','sms')); ?>", function() {
                        var list = [5,6];
                        datetableReInt($(document).find('.smsdataView').find('table'),list);
                    });
                }
                onResponseBoby(response);
            });
        }
    });
    $modal.off('click','.update').on('click', '.update', function(e){
        var options = { 
            //beforeSubmit:  showRequest,  // pre-submit callback 
            success:function(res){
                // onResponse function in modal_common.js
                if(onResponse($modal,'SmsSubscriptionPlan',res)){
                    $(".smsdataView").load("<?php echo $this->Html->url(array('controller'=>'payments','action'=>'plans','sms')); ?>", function() {
                        var list = [5,6];
                        datetableReInt($(document).find('.smsdataView').find('table'),list);
                    });    
                }
            }
        }; 
        $('#SmsSubscriptionPlanAdminSmsPlanForm').submit(function(){
            $(this).ajaxSubmit(options);
            $(this).unbind('submit');
            $(this).bind('submit');
            return false;
        });
    });
    var list = [5,6];
    datetableReInt($(document).find('.dataTable'),list);
});

</script>
    <div class="smsdataView">
         <?php echo $this->element('admin/Payment/list_smsplan');?>
    </div>
<script>
    $(document).ready(function(){
        $(document).on('click','.changeStatus',function(){
            var theJ = $(this);
            var theId = theJ.closest('tr').attr('data-id');
            var statusTo = theJ.attr('data-status');
            
            $.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url(array('controller'=>'Payments','action'=>'changeStatus','admin'=>true,'sms'));?>",
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
        });
	   
        
    });
</script>
