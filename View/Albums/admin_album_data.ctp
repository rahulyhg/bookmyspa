<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Album:  <?php $lang = Configure::read('Config.language');
                                echo ucfirst($album_datas['Album'][$lang.'_name']); ?>
                </h3>
                        <?php echo ($total_images <20)?  $this->Html->link(__('Add Image') ,'javascript:void(0)',array('data-type'=>'image','data-album_id'=>base64_encode($album_datas['Album']['id']),'class'=>'btn  pull-right addeditImage')) :''; ?>&nbsp;
                        <?php echo ($total_videos <=10)?  $this->Html->link(__('Add Video') ,'javascript:void(0)',array('data-type'=>'video','data-album_id'=>base64_encode($album_datas['Album']['id']),'class'=>'btn   pull-right addeditImage')) :''; ?>
                </div>
            <div class="box" id="ajax_box">
                <?php echo $this->element('admin/Album/album_data'); ?>
            </div>
     </div>
    </div>
    
    <script>
    $(document).ready(function(){
        var $modal = $('#commonSmallModal');
        var $modal2 = $('#commonContainerModal');
        var itsId  = "";   
        $(document).on('click','.addeditImage' ,function(){
            var albumId = $(this).data('album_id');
            var type  = $(this).attr('data-type');
            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'add_image','admin'=>true)); ?>";
            addeditURL = addeditURL+'/'+albumId+'/'+type+'/'+itsId;
            // function in modal_common.js
            $('body').modalmanager('loading');
            fetchModal($modal,addeditURL);
        });   
        
    /*********************colorbox to view  images/videos **********************************/     
    $(".colorbox-image").colorbox({rel:'group-1', slideshow:true});
    $(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
    
    /*********************Ajax code to add add/edit  new image/video **********************************/  
   
        $modal.on('click', '.save', function(e){
        var optionsImage = { 
            success:function(res){
                // onResponse function in modal_common.js
                if(onResponse($modal,'AlbumFile',res)){
                    var data = jQuery.parseJSON(res);
                        if(data.id){
                            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'album_element','admin'=>true)); ?>";
                            addeditURL = addeditURL+'/'+data.id
                             //$('body').modalmanager('loading');
                             $('#ajax_box').load(addeditURL,function(){
                                $(document).find(".gallery-dynamic").imagesLoaded(function(){
                                        $(document).find(".gallery-dynamic").masonry({
                                            itemSelector: 'li',
                                            columnWidth: 201,
                                            isAnimated: true
                                        });
                                });
                            });
                             return false;
                        }
                     }else{
                        return false;   
                        }
               }
        }
        $('#AlbumFileAdminAddImageForm').submit(function(){
            $(this).ajaxSubmit(optionsImage);
            $(this).unbind('submit');
            $(this).bind('submit');
            return false;
        });
    });
    
    /*********************Ajax code to delete image/video **********************************/  
    $(document).on('click','.del-gallery-pic.delete', function(){
      $this =  $(this);  
     itsId = $(this).data('id');
     deleteUrl = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'deleteImage','admin'=>true)); ?>";
     deleteUrl = deleteUrl+'/'+itsId;
     $.ajax({
        url:deleteUrl,
        success:function(result){
        $this.closest("li").remove();
        },
     });
     
    });

    })
    </script>