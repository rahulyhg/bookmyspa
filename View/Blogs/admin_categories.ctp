<script>
$(document).ready(function(){
    
    var $modal = $('#commonSmallModal');
     var form_sub = true;
    var itsId  = "";
        $(document).on('click','.addedit_blogCat' ,function(){
            var itsId = $(this).attr('data-id');
            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'blogs','action'=>'add_category')); ?>";
            addeditURL = addeditURL+'/'+itsId
            // function in modal_common.js
            fetchModal($modal,addeditURL,'BlogCategoryAdminAddCategoryForm');
             form_sub = true;
        });
    $(document).on('click','.view_blogCat' ,function(){
        var itsId = $(this).closest('tr').attr('data-id');
        var addeditURL = "<?php echo $this->Html->url(array('controller'=>'blogs','action'=>'viewPage')); ?>";
        var $bigmodal = $('#commonContainerModal');
        addeditURL = addeditURL+'/'+itsId
        // function in modal_common.js
        fetchModal($bigmodal,addeditURL);
    });
    
    $(document).on('click','.delete_blogCat' ,function(){
        var itsId = $(this).closest('tr').attr('data-id');
        if(confirm('Are you sure you want to delete blog category?')){
            $.ajax({
            url: "<?php echo $this->Html->url(array('controller'=>'blogs','action'=>'deletePage')); ?>",
            type:'POST',
            data:{'id': itsId }
            }).done(function(response){
                var data = jQuery.parseJSON(response);
                if(data.data == 'success'){
                     $(".blogcatdataView").load("<?php echo $this->Html->url(array('controller'=>'blogs','action'=>'categories')); ?>", function() {
                        var list = [2,3];
                        datetableReInt($(document).find('.blogcatdataView').find('table'),list);
                    });
                }
                onResponseBoby(response);
            });
        }
    });
    $modal.on('click', '.update', function(e){
         var theBtn = $(this);
             buttonLoading(theBtn);
        var options = { 
            //beforeSubmit:  showRequest,  // pre-submit callback 
            success:function(res){
                 buttonSave(theBtn);
                // onResponse function in modal_common.js
                if(onResponse($modal,'BlogCategory',res)){
                    $(".blogcatdataView").load("<?php echo $this->Html->url(array('controller'=>'blogs','action'=>'categories')); ?>", function() {
                        var list = [3,4];
                        datetableReInt($(document).find('.blogcatdataView').find('table'),list);
                    });    
                }else{
                     form_sub = true;   
                }
            }
        };
            if(!theBtn.hasClass('rqt_already_sent')){
                $('#BlogCategoryAdminAddCategoryForm').submit(function(e){
                         if(form_sub == true){
                            theBtn.addClass('rqt_already_sent');
                            $(this).ajaxSubmit(options);
                            form_sub = false;
                        } 
                        e.stopPropagation();
                        return false;
                });
             }
             setTimeout(function(){
              if($modal.find('dfn.text-danger').length > 0){
                  buttonSave(theBtn);
                  $('.nav-tabs a:first').tab('show')
              }
             },500);
        });
     var list = [3,4];
     datetableReInt($(document).find('.dataTable'),list);
});

</script>


<div class="row-fluid">
    <div class="span12">
     <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Blog Categories
                </h3>
                <?php 
                 echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_blogCat pull-right'));?>
            </div>
    
               
                    <?php //echo $this->Html->link('Add New',array('controller'=>'blogs','action'=>'add_category','admin'=>true),array('class'=>''));?>
             <div class="box-content">
                <div class="blogcatdataView">
                <?php echo $this->element('admin/Blog/list_blog_categories');?>
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
                url: "<?php echo $this->Html->url(array('controller'=>'blogs','action'=>'changeStatus','admin'=>true));?>",
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