<script>
    $(document).ready(function(){
    
    var $modal = $('#commonSmallModal');
    
    var itsId  = "";
        $(document).off('click', '.addedit_emailPlan').on('click','.addedit_emailPlan' ,function(){
            var itsId = $(this).attr('data-id');
            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'payments','action'=>'emailPlan')); ?>";
            addeditURL = addeditURL+'/'+itsId
            // function in modal_common.js
            fetchModal($modal,addeditURL,'EmailSubscriptionPlanAdminEmailPlanForm');
            var form_sub =1;
        });

    $(document).on('click','.delete_emailPlan' ,function(){
        var itsId = $(this).closest('tr').attr('data-id');
        if(confirm(' Are you sure, you want to delete this Email Plan ? ')){
            $.ajax({
            url: "<?php echo $this->Html->url(array('controller'=>'payments','action'=>'deletePlan','email')); ?>",
            type:'POST',
            data:{'id': itsId }
            }).done(function(response){
                var data = jQuery.parseJSON(response);
                if(data.data == 'success'){
                     $(".emaildataView").load("<?php echo $this->Html->url(array('controller'=>'payments','action'=>'plans','email')); ?>", 			function() {
                        var list = [5,6];
                        datetableReInt($(document).find('.emaildataView').find('table'),list);
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
                if(onResponse($modal,'EmailSubscriptionPlan',res)){
                    $(".emaildataView").load("<?php echo $this->Html->url(array('controller'=>'payments','action'=>'plans','email')); ?>", function() {
                        var list = [5,6];
                        datetableReInt($(document).find('.emaildataView').find('table'),list);
                    });    
                }
            }
        }; 
        $('#EmailSubscriptionPlanAdminEmailPlanForm').submit(function(){
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
     <div class="emaildataView">
                <?php echo $this->element('admin/Payment/list_emailplan');?>
     </div>
<script>
    $(document).ready(function(){
        $(document).on('click','.changeStatus',function(){
            var theJ = $(this);
            var theId = theJ.closest('tr').attr('data-id');
            var statusTo = theJ.attr('data-status');
            
            $.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url(array('controller'=>'Payments','action'=>'changeStatus','admin'=>true,'email'));?>",
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
        
        $(document).on('keyup','.numOnly' ,function(){
             var value = $(this).val();
                if(isNaN(value)){
                    $(this).val('');
                }
        })

    $(document).on('change','.customerType',function(){
     var val = $(this).val();
	if(val == 0){
		$("#nCustomer").css('display','block');
		$("#nEmail").css('display','none');
	}else{
		$("#nEmail").css('display','block');
		$("#nCustomer").css('display','none');
	}
    });
        
    });

</script>
