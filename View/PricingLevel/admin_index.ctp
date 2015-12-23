<script>
    $(document).ready(function() {
        var $modal = $('#commonSmallModal');
        var itsId = "";
        $(document).on('click', '.addedit_pricingLevel', function() {
            var itsId = $(this).attr('data-id');
            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'PricingLevel','action'=>'add')); ?>";
            addeditURL = addeditURL + '/' + itsId
            // function in modal_common.js
            fetchModal($modal, addeditURL);
        });

        $(document).on('click', '.view_pricingLevel', function() {
            var itsId = $(this).closest('tr').attr('data-id');
            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'PricingLevel','action'=>'view')); ?>";
            var $bigmodal = $('#commonContainerModal');
            addeditURL = addeditURL + '/' + itsId
            // function in modal_common.js
            fetchModal($bigmodal, addeditURL);
        });

        $(document).on('click', '.delete_pricingLevel', function() {
            var staffCount =  $(this).closest('tr').attr('data-count');
            var itsId = $(this).closest('tr').attr('data-id');
            if(staffCount == 0){
                if (confirm('Are you sure you want to delete this pricing level? ')) {
                    $.ajax({
                        url: "<?php echo $this->Html->url(array('controller'=>'PricingLevel','action'=>'deletePricing')); ?>",
                        type: 'POST',
                        data: {'id': itsId}
                        }).done(function(response) {
                        var data = jQuery.parseJSON(response);
                        if (data.data == 'success') {
                            $(".pricingDataView").load("<?php echo $this->Html->url(array('controller'=>'PricingLevel','action'=>'index')); ?>", function() {
                                var list = [1,2];
                                datetableReInt($(document).find('.pricingDataView').find('table'), list);
                            });
                        }
                        onResponseBoby(response);
                    });
                }
            }else{
                alert("This Pricing level is associated with "+staffCount+" service providers. You cannot delete this pricing level.");
            }
        });


        $modal.on('click', '.update', function(e) {
            var options = {
                //beforeSubmit:  showRequest,  // pre-submit callback 
                success: function(res) {
                    // onResponse function in modal_common.js
                    if (onResponse($modal, 'PricingLevel', res)) {
                        $(".pricingDataView").load("<?php echo $this->Html->url(array('controller'=>'PricingLevel','action'=>'index')); ?>", function() {
                            var list = [1,2];
                            datetableReInt($(document).find('.pricingDataView').find('table'), list);
                        });
                    }
                }
            };
            $('#PricingLevelAdminAddForm').submit(function() {
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
        var list = [1,2];
        datetableReInt($(document).find('.dataTable'), list);
    });

</script>
<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Pricing level listing
                </h3>
                <?php 
                 echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_pricingLevel pull-right'));
                ?>
            </div>


            <div class="box-content">
                <div class="pricingDataView">
            <?php echo $this->element('admin/PricingLevel/list_pricinglevel_page'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
 $(document).ready(function() {
        $(document).on('click', '.changeStatus', function() {
            var theJ = $(this);
            var theId = theJ.closest('tr').attr('data-id');
            var staffCount = theJ.closest('tr').attr('data-count');
            var statusTo = theJ.attr('data-status');
        if(staffCount == 0){
           if(confirm("Are you sure you want to change the status of Pricing level?")){
            $.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url(array('controller'=>'PricingLevel','action'=>'changePricingStatus','admin'=>true));?>",
                data: {id: theId, status: statusTo}
            }) .done(function(msg) {
                        if (msg == 0) {
                            theJ.closest('td').html('<?php echo $this->Common->theStatusImage(0); ?>')
                        }
                        else {
                            theJ.closest('td').html('<?php echo $this->Common->theStatusImage(1); ?>')
                        }
                    });
           }
        }else{
            alert("This Pricing level is associated with "+staffCount+" service providers. You cannot deactivate this pricing level.");
        }
        })
    });
</script>