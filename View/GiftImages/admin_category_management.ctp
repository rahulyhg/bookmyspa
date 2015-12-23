<script type="text/javascript">
        $(document).ready(function() {
           var $modal = $('#commonSmallModal');
            var itsId = "";
             var sub = 'true';
            //Open new pop up
    
        $(document).off('click', '.delete_category').on('click', '.delete_category', function() {
            var itsId = $(this).closest('tr').attr('data-id');
            if (confirm(' Are you sure, you want to delete this Category ?')) {
                $.ajax({
                    url: "<?php echo $this->Html->url(array('controller'=>'GiftImages','action'=>'delete_category')); ?>",
                    type: 'POST',
                    data: {'id': itsId}
                }).done(function(response) {
                    var data = jQuery.parseJSON(response);
                    if (data.data == 'success'){
                        if(data.data_done == 'success'){
                        $(".giftImagesdataView").load("<?php echo $this->Html->url(array('controller'=>'GiftImages','action'=>'category_management','admin'=>true)); ?>", function() {
                            var list = [2];
                            datetableReInt($(document).find('.giftImagesdataView').find('table'),list);
                        });
                       }else{
                        alert(data.messages_before);
                       }
                    }
                    onResponseBoby(response);
                });
            }
        });
        
        $modal.on('hidden.bs.modal', function () {
          $(document).find('.loader-container').hide();
        });
        
     var list = [2];
     datetableReInt($(document).find('.dataTable'),list);
     });
</script>
<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                     Category Listing
                </h3>
                <?php 
                 //echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> New Gift Certificate Image</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_giftImage pull-right'));?>
            </div>
            <div class="box-content">
                <div class="giftImagesdataView">
                    <?php echo $this->element('admin/GiftImages/list_categories'); ?>
                </div>
            </div>
        </div>
    </div>
</div>