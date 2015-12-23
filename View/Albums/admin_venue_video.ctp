<div class="modal-dialog vendor-setting">
    <div class="modal-dialog upload-img">
          <?php   echo $this->Form->create('VenueVideo',array('novalidate','class'=>'form-horizontal'));  ?>
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h2>Upload Video</h2>
          </div>
        
          <div class="modal-body clearfix">
            <div class="form-group">
                    <label class="control-label col-sm-3">Youtube Link:</label>
                    <div class="col-sm-7">
                        <?php echo $this->Form->input('url',array('required'=>true,'type'=>'url','label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'10','maxlength'=>'200','required','pattern'=>'https?://.+','validationMessage'=>"Url is Required.",'data-minlength-msg'=>"Minimum 10 characters.",'data-maxlength-msg'=>"Maximum 200 characters.",'data-pattern-msg'=>"Please enter only Url.")); ?>
                    </br>
                    <i style="font-size:11px">Only youtube video url are accepted</i><br>
                    <i style="font-size:11px">ex: https://www.youtube.com/watch?v=h2Nq0qv0K8M </i>
                    </div>
            </div>
          </div>
          <div class="modal-footer">
                <div class="col-sm-3 pull-right">
                    <?php  echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary venue_save','label'=>false,'div'=>false));  ?>
                </div>
	  </div>
         
        </div>
      </div>
      <?php  echo $this->Form->end();  ?>   
</div>

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
	https://www.youtube.com/watch?v=KQQ9MjKo-qc
	var submitVid ='yes';
        var $modal = $modal2 = $venueVideo =  $(document).find('#commonVendorModal');
        var itsId  = ""; 
	    $venueVideo.on('click', '.venue_save', function(e){
            var url = $('#VenueVideoUrl').val();
                var optionsImage = { 
                    success:function(res){
                        // onResponse function in modal_common.js
                        if(onResponse($venueVideo,'VenueVideo',res)){
			    submitVid='no';
                            var data = jQuery.parseJSON(res);
                                    var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'venue_element','admin'=>true)); ?>";
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
                             }else{
                                return false;   
                                }
                       }
                }
                $('#VenueVideoAdminVenueVideoForm').submit(function(){
		    if(submitVid=='yes'){
			$(this).ajaxSubmit(optionsImage);
			
		    }
                    
                    $(this).unbind('submit');
                    $(this).bind('submit');
                    return false;
                 });
           
    });
})
</script>