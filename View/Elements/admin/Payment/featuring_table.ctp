<script>

$(document).ready(function(){
    
    var $modal = $('#commonSmallModal');
    var itsId  = "";
        $(document).on('click','.addedit_featuredPlan' ,function(){
            var itsId = $(this).attr('data-id');
            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'payments','action'=>'featuringPlan')); ?>";
            addeditURL = addeditURL+'/'+itsId
            // function in modal_common.js
            fetchModal($modal,addeditURL);
        });

    $(document).on('click','.delete_featuredPlan' ,function(){
        var itsId = $(this).closest('tr').attr('data-id');
        if(confirm(' Are you sure, you want to delete this Featured Plan ? ')){
            $.ajax({
            url: "<?php echo $this->Html->url(array('controller'=>'payments','action'=>'deletePlan','featuring')); ?>",
            type:'POST',
            data:{'id': itsId }
            }).done(function(response){
                var data = jQuery.parseJSON(response);
                if(data.data == 'success'){
                     $(".featureddataView").load("<?php echo $this->Html->url(array('controller'=>'payments','action'=>'plans','featuring')); ?>", function() {
                        var list = [4,5];
                        datetableReInt($(document).find('.featureddataView').find('table'),list);
                    });
                }
                onResponseBoby(response);
            });
        }
    });
    $modal.on('click', '.update', function(e){
        var options = { 
            //beforeSubmit:  showRequest,  // pre-submit callback 
            success:function(res){
                // onResponse function in modal_common.js
                if(onResponse($modal,'FeaturingSubscriptionPlan',res)){
                    $(".featureddataView").load("<?php echo $this->Html->url(array('controller'=>'payments','action'=>'plans','featuring')); ?>", function() {
                        var list = [4,5];
                        datetableReInt($(document).find('.featureddataView').find('table'),list);
                    });    
                }
            }
        }; 
        $('#FeaturingSubscriptionPlanAdminFeaturingPlanForm').submit(function(){
            $(this).ajaxSubmit(options);
            $(this).unbind('submit');
            $(this).bind('submit');
            return false;
        });
    });
    var list = [4,5];
    datetableReInt($(document).find('.dataTable'),list);
});

</script>
    <div class="featureddataView">
            <?php echo $this->element('admin/Payment/list_featuredplan');?>
    </div>

<script>
    $(document).ready(function(){
        $(document).on('click','.changeStatus',function(){
            var theJ = $(this);
            var theId = theJ.closest('tr').attr('data-id');
            var statusTo = theJ.attr('data-status');
            
            $.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url(array('controller'=>'Payments','action'=>'changeStatus','admin'=>true,'featuring'));?>",
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