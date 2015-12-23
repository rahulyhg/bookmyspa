<script>

$(document).ready(function(){
    var $modal = $('#commonSmallModal');
    var itsId  = "";
        $(document).on('click','.addedit_blog' ,function(){
            var itsId = $(this).attr('data-id');
            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'blogs','action'=>'add_blog')); ?>";
            addeditURL = addeditURL+'/'+itsId
            // function in modal_common.js
            fetchModal($modal,addeditURL);
        });
    //$(document).on('click','.view_blog' ,function(){
    //    var itsId = $(this).closest('tr').attr('data-id');
    //    var addeditURL = "<?php echo $this->Html->url(array('controller'=>'blogs','action'=>'viewPage')); ?>";
    //    var $bigmodal = $('#commonContainerModal');
    //    addeditURL = addeditURL+'/'+itsId
    //    // function in modal_common.js
    //    fetchModal($bigmodal,addeditURL);
    //});
    
    
    $(document).on('click','.view_blog' ,function(){
        var itsId = $(this).closest('tr').attr('data-id');
        var bTypeView = "<?php echo $this->Html->url(array('controller'=>'blogs','action'=>'view')); ?>";
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
        $('#BlogAdminAddBlogForm').submit(function(){
            $(this).ajaxSubmit(options);
            $(this).unbind('submit');
            $(this).bind('submit');
            return false;
        });
    });
    var list = [0,3,4,5,7];
    datetableReInt($(document).find('.dataTable'),list);
});

</script>
    
<div class="row">
    <div class="col-sm-12">
         <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Blogs
                </h3>
                <?php 
                 echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_blog pull-right'));?>
            </div>
        
            <div class="box-content">
                <div class="blogdataView">
                <?php echo $this->element('admin/Blog/list_blog');?>
                </div>
             </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(document).on('click','.changeStatus',function(){
            var theJ = $(this);
            var theId = theJ.closest('tr').attr('data-id');
            var statusTo = theJ.attr('data-status');
            $.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url(array('controller'=>'blogs','action'=>'changeStatus_blog','admin'=>true));?>",
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