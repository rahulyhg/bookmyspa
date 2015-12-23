<script>
$(document).ready(function(){
    var $modal = $('#commonSmallModal');
    var itsId  = "";
    $(document).on('click','.view_enquiry' ,function(){
        var itsId = $(this).closest('tr').attr('data-id');
        var bTypeView = "<?php echo $this->Html->url(array('controller'=>'StaticPages','action'=>'viewEnqueryDetail')); ?>";
        var $bigmodal = $('#commonContainerModal');
        bTypeView = bTypeView+'/'+itsId
        // function in modal_common.js
        fetchModal($bigmodal,bTypeView);
        return false;
    });
    
    $(document).on('click','.delete_blog' ,function(){
        var itsId = $(this).closest('tr').attr('data-id');
        if(confirm('Are you sure you want to delete blog?')){
            $.ajax({
            url: "<?php echo $this->Html->url(array('controller'=>'blogs','action'=>'deleteBlog')); ?>",
            type:'POST',
            data:{'id': itsId }
            }).done(function(response){
                var data = jQuery.parseJSON(response);
                if(data.data == 'success'){
                        $(".blogdataView").load("<?php echo $this->Html->url(array('controller'=>'blogs','action'=>'all_blogs')); ?>", function() {
                        var list = [5,6,7];
                        datetableReInt($(document).find('.blogdataView').find('table'),list);
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
                if(onResponse($modal,'Blog',res)){
                    $(".blogdataView").load("<?php echo $this->Html->url(array('controller'=>'blogs','action'=>'all_blogs')); ?>", function() {
                        var list = [5,6,7];
                        datetableReInt($(document).find('.blogdataView').find('table'),list);
                    });    
                }
            }
        }; 
       
    });
    var list = [2,3,4,5,6,7];
    datetableReInt($(document).find('.dataTable'),list);
});

</script>
    
<div class="row">
    <div class="col-sm-12">
         <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Business Enquiries
                </h3>
            </div>
        
            <div class="box-content">
                <div class="blogdataView">
                <?php echo $this->element('admin/StaticPages/enquiryList');?>
                </div>
             </div>
        </div>
    </div>
</div>