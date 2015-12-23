<script type="text/javascript">
    $(document).ready(function() {
           var $modal = $('#commonSmallModal');
            var itsId = "";
             var sub = 'true';
            //Open new pop up
            $(document).on('click', '.addedit_giftImage', function() {
                var itsId = $(this).attr('data-id');
                var addeditURL = "<?php echo $this->Html->url(array('controller'=>'GiftImages','action'=>'addImage')); ?>";
                addeditURL = addeditURL + '/' + itsId
                // function in modal_common.js
                fetchModal($modal, addeditURL,'GiftImageAdminAddImageForm');
                 sub = 'true';
            });
           
            //add/Edit
            $modal.off('click', '.update').on('click', '.update', function(e) { 
                var options = {
                    //beforeSubmit:  showRequest,  // pre-submit callback 
                    success: function(res) {
                        // onResponse function in modal_common.js
                        if (onResponse($modal, 'GiftImage', res)) {
                            $(".giftImagesdataView").load("<?php echo $this->Html->url(array('controller'=>'GiftImages','action'=>'list')); ?>", function() {
                            //   
                            });
                        }else{
                           sub ='true'; 
                        }
                    }
                };
            $('#GiftImageAdminAddImageForm').submit(function(){
                if(sub=='true'){
                    $(this).ajaxSubmit(options);
                    sub ='false';
                }
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
            //Delete record
        });
        $(document).on('click', '.delete_giftImage', function() {
            var itsId = $(this).closest('tr').attr('data-id');
            if (confirm(' Are you sure, you want to delete this gift Image ? ')) {
                $.ajax({
                    url: "<?php echo $this->Html->url(array('controller'=>'GiftImages','action'=>'deleteRow')); ?>",
                    type: 'POST',
                    data: {'id': itsId}
                }).done(function(response) {
                    var data = jQuery.parseJSON(response);
                    if (data.data == 'success') {
                        $(".giftImagesdataView").load("<?php echo $this->Html->url(array('controller'=>'GiftImages','action'=>'list')); ?>", function() {
                            var list = [];
                            //datetableReInt($(document).find('.GiftImages').find('table'));
                        });
                    }
                    onResponseBoby(response);
                });
            }
        });
        
        $modal.on('hidden.bs.modal', function () {
          $(document).find('.loader-container').hide();
        });
     });
</script>
<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Gift Certificate Image Listing
                </h3>
                <?php 
                 echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> New Gift Certificate Image</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_giftImage pull-right'));?>
            </div>
            <div class="box-content">
                <div class="giftImagesdataView">
                    <?php echo $this->element('admin/GiftImages/list_gift_images'); ?>
                </div>
            </div>
        </div>
    </div>
</div>