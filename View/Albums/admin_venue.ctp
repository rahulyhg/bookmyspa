<?php
echo $this->Html->script('fancy/jquery.fancybox.js?v=2.1.5');
echo $this->Html->css('fancy/jquery.fancybox.css?v=2.1.5');
echo $this->Html->script('fancy/jquery.fancybox-thumbs.js?v=1.0.7');
echo $this->Html->css('fancy/jquery.fancybox-thumbs.css?v=1.0.7');
?>
<div class="row-fluid">
    <div class="span12">
        <div id="ajax_box">
                <?php echo $this->element('admin/Album/venue_data'); ?>
         </div>
    </div>
</div>
<?php //echo $this->Html->url(array('controller'=>'Settings','action'=>'venue_images','admin'=>true));?>    

 <script>
 var count = 0;
    $(document).ready(function(){
	 var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'venue_element','admin'=>true)); ?>";
	    $('#ajax_box').load(addeditURL,function(){
		$(document).find(".gallery-dynamic").imagesLoaded(function(){
			$(document).find(".gallery-dynamic").masonry({
			    itemSelector: 'li',
			    columnWidth: 201,
			    isAnimated: true
			});
		    });
	    });
	var $modal = $modal2 = $venueVideo =  $(document).find('#commonVendorModal');
        var itsId  = ""; 
       
	    $venueVideo.on('click', '.venueSave', function(e){
            var url = $('#VenueVideoUrl').val();
            if (validYT(url) !== false){
                var optionsImage = { 
                    success:function(res){
                        // onResponse function in modal_common.js
                        if(onResponse($venueVideo,'VenueVideo',res)){
                            var data = jQuery.parseJSON(res);
                                if(data.id){
                                    var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'album_element','admin'=>true)); ?>";
                                    addeditURL = addeditURL+'/'+data.id;
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
                $('#VenueVideoAdminVenueVideoForm').submit(function(){
                    $(this).ajaxSubmit(optionsImage);
                    $(this).unbind('submit');
                    $(this).bind('submit');
                    return false;
                 });
            }else{
                alert('Please enter a valid youtube url.');
                return false;
            }
    });
        
        
        
        $(document).on('click','.addeditImage' ,function(){
           
            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'venue_images','admin'=>true));?>";
            addeditURL = addeditURL+'/'+'gallery';
            fetchModal($modal,addeditURL);
        });
        $(document).on('click','.addeditVideo' ,function(){
            var venuVideo = '<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'venue_video','admin'=>true));?>';
	    fetchModal($venueVideo,venuVideo);
        });
        
        

        $venueVideo.off('click').on('click','.addMore',function(){
	    
        var videoUrl = $(this).parent().parent().prev().find('input').val();
			    if(videoUrl == ''){
				alert('Please fill url.');
				return false;
			    }else{
                                if(parseYouTube(videoUrl)){
                                  if (validYT(videoUrl) !== false){
                                    var theData =  $(document).find( "div.frm-grp" ).find('div.form-group:first').clone();
                                    theData.find('input').val('');
                                    theData.find('.addthatURL').parent().css('display','block');
                                    theData.find('div.addremove').append('<a href="javascript:void(0);" class="removeURL"><i class="fa  fa-minus    "></i></a>');
                                    $(document).find('div.frm-grp').append('<div class="form-group clearfix">'+theData.html()+'</div>');
                                  }else{
                                     alert('Please enter a valid youtube url.'); 
                                     return false;
                                  }  
                                }else{
                                    alert('Please enter a valid youtube url.');
                                    return false;
                                }
                                
							    }
			});
			$venueVideo.on('click','.addthatURL',function(e){
                                var this_a = $(this);
				var youURL = $(this).closest('div.form-group').find('input').val();
				if(youURL){
					if(parseYouTube(youURL)){
					      if (validYT(youURL) !== false){
						$.ajax({url:'<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'venue_video','admin'=>true));?>',type:'POST',data: {URL:youURL} })
						.done(function(res){
							if(res == 'e'){
								alert('Youtube link already Exist!');
							}
							else if(res == 'f'){
								alert('Error in saving!');
							}
							else{
								
								if(res != 's'){
								this_a.parent().hide();
								var appenddata = '<li><a href="#"><img src="'+res+'" > </a></li>';
								$venueVideo.find('div.youtubeall ul').append(appenddata);
								//https://www.youtube.com/watch?v=XV_XMM-vUPk
								}
								else{
									alert('Video Saved Successfully.');
								}
							}
						});
					    }else{
						alert('Please enter a valid youtube url');

					    }
					}
					else{
						alert('Please enter a valid youtube url');

					}
				}
				else{
					alert('Please Enter URL');
				}
			});
			
			$venueVideo.on('click','.removeURL',function(){
			    $(this).closest('div.form-group').remove();
			});
			//$venueVideo.
			$(document).on('click','.submitVideoForm',function(e){
			     var url = $('#VenueVideoUrl').val();
			    if (validYT(url) !== false){
				e.preventDefault();
					var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'venue_element','admin'=>true)); ?>";
					 $('#ajax_box').load(addeditURL,function(){
					     $(document).find(".gallery-dynamic").imagesLoaded(function(){
						 $(document).find(".gallery-dynamic").masonry({
						     itemSelector: 'li',
						     columnWidth: 201,
						     isAnimated: true
						 });
				    });
				});
			   
				//$.ajax({url:updateURL,type:'POST',data: {update:'venue_video'} });	
				$venueVideo.modal('toggle');
			    }else{
				alert('Please enter a valid youtube url');
			    }
			});
    /*********************colorbox to view  images **********************************/     
    $('body').on('click', '.youtube', function() {
	  $('.youtube').colorbox({rel: $(this).attr('rel'),iframe:true, innerWidth:640, innerHeight:390});
      });
    
    /*********************Ajax code to add add/edit  new image **********************************/  
   
        $modal.on('click', '.save', function(e){
        var optionsImage = { 
            success:function(res){
                // onResponse function in modal_common.js
                if(onResponse($modal,'VenueImage',res)){
                    var data = jQuery.parseJSON(res);
                    if(data.id){
                            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'venue_element','admin'=>true)); ?>";
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
        $('#VenueImageAdminAddVenueimageForm').submit(function(){
            $(this).ajaxSubmit(optionsImage);
            $(this).unbind('submit');
            $(this).bind('submit');
            return false;
        });
    });
    
    /*********************Ajax code to delete image/video **********************************/  
    $(document).on('click','.del-gallery-video.delete', function(){
    if(confirm('Are you sure you want to delete this video?')){
	$this =  $(this);  
	itsId = $(this).data('id');
	deleteUrl = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'deletevenueVideo','admin'=>true)); ?>";
	deleteUrl = deleteUrl+'/'+itsId;
	    $.ajax({
	        url:deleteUrl,
	        success:function(result){
		    $this.closest("li").remove();
	       },
	    });
    } 
    });

    $('#commonVendorModal').on('hidden.bs.modal', function (e) {
       var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'venue_element','admin'=>true)); ?>";
                             //$('body').modalmanager('loading');
                            // $('#ajax_box').load(addeditURL);
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
    });
})
    
    
    function deletefunc($this){
    
    $("#lightGallery").lightGallery().destroy();
    if(confirm('Are you sure you want to delete this image?')){
        //alert('ff');
        itsId = $this;
       deleteUrl = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'deletevenueImage','admin'=>true)); ?>";
        deleteUrl = deleteUrl+'/'+itsId;
       $.ajax({
        url:deleteUrl,
        success:function(result){
       // $this.closest("li").remove();
	var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'venue_element','admin'=>true)); ?>";
                             //$('body').modalmanager('loading');
                             $('#ajax_box').load(addeditURL);
        $('#lightGallery').lightGallery({
			showThumbByDefault:true,
			addClass:'showThumbByDefault',
			controls:true
		    });
        },
    });
    }
}

function validYT(url) {
  var p = /^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/;
  return (url.match(p)) ? RegExp.$1 : false;
}

</script>
