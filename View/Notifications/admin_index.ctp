<div class="row">
    <div class="col-sm-12">
         <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Notifications
                </h3>
            </div>
             <div class="box-content" id="notify">
                 <?php echo $this->element('admin/Notification/all_notifications'); ?> 
             </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(document).on('click','.mark_as',function(){
            var theJ = $(this);
            status = theJ.data('status');
            var theId = theJ.closest('tr').attr('data-id');
            $.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url(array('controller'=>'Notifications','action'=>'changeStatus','admin'=>true));?>",
                data: {id: theId,status:status}
            }).done(function(msg){
                $loadUrl = '<?php echo $this->here; ?>';
                $('#notify').load($loadUrl);
            });
        })
    });
</script>            