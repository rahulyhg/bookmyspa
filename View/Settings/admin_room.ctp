<script>

$(document).ready(function(){
    var $modal = $('#commonSmallModal');
    var itsId  = "";
    $(document).on('click','.addedit_room' ,function(){
    var itsId = $(this).attr('data-id') ? $(this).attr('data-id') : null ;
    var type = $(this).attr('data-type');
    var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'add_room')); ?>";
        addeditURL = addeditURL+'/'+itsId+'/'+type;
        $('body').modalmanager('loading');
        // function in modal_common.js
        fetchModal($modal,addeditURL,'SalonRoomAdminAddRoomForm');
    });
   
    $(document).on('click','.delete_room' ,function(){
        var itsId = $(this).closest('tr').attr('data-id');
        room_type = "<?php echo ($type=='room')?'room':'resource'; ?>";
	if(confirm('Are you sure, you want to delete this '+ room_type + '? ')){
            $.ajax({
            url: "<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'delete_room')); ?>",
            type:'POST',
            data:{'id': itsId }
            }).done(function(response){
                var data = jQuery.parseJSON(response);
                if(data.data == 'success'){
                     var type = $(document).find(".addedit_room").attr('data-type');
                     $(".cmsdataView").load("<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'room')); ?>/"+type, function() {
                        var list = [5];
                        datetableReInt($(document).find('.cmsdataView').find('table'),list);
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
		if(onResponse($modal,'SalonRoom',res)){
		     var type = $(document).find(".addedit_room").attr('data-type');
		    $(".cmsdataView").load("<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'room')); ?>/"+type, function() {
			var list = [5];
			datetableReInt($(document).find('.cmsdataView').find('table'),list);
		    });    
		}
	    }
	};
         if(!theBtn.hasClass('rqt_already_sent')){
            $('#SalonRoomAdminAddRoomForm').submit(function(){
                theBtn.addClass('rqt_already_sent');
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
         }else{
             e.preventDefault();
         }
    });
    var list = [5];
    datetableReInt($(document).find('.dataTable'),list);
    
    
       /******Add Images*****/
        $forAddingImagemodal = 	 $('#commonMediumModal'); 
        $modal.on('click','.addImage',function(){
             
             var addiURL = "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'service_gallery','admin'=>true)); ?>";
             fetchModal($forAddingImagemodal,addiURL);
             
        });
	$forAddingImagemodal.on('click','.toUploadImage',function(){
            $forAddingImagemodal.find('#guploadImageForm #ServiceUpimage').click();
        });
	$forAddingImagemodal.on('change', '#ServiceUpimage', function(e){
            file = this.files[0];
            var obj = $(this);
            var valReturn = validate_image(file);
            if(valReturn){
                obj.val('');
                alert(valReturn);
            }
            else{
                var reader = new FileReader();
                var image = new Image();
                reader.readAsDataURL(file);  
                reader.onload = function(_file) {
                    image.src    = _file.target.result;              // url.createObjectURL(file);
                    image.onload = function() {
                        var w = this.width,
                            h = this.height,
                            t = file.type,                           // ext only: // file.type.split('/')[1],
                            n = file.name,
                            s = ~~(file.size/1024) +'KB';
			     if(parseInt(w) >= 640 && parseInt(h)>=400){
                            if(parseInt(w) > parseInt(h)){
                                var formdata = new FormData();
                                formdata.append('image', file);
                                obj.prev().val('');
                                var serviceId = $modal.find('#ServiceId').val();
                                var serviceParentId = $modal.find('#ServiceParentId').val();
                                if(!serviceId)
                                    serviceId = 0;
                                if(!serviceParentId)
                                    serviceParentId = 0;
                                formdata.append('serviceId', '');
                                formdata.append('parent_id', serviceParentId);
                                
                                $.ajax({
                                    url: "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'service_gallery','admin'=>true))?>"+"/"+serviceId+"/"+serviceParentId+"/"+"Room",
                                    type: "POST",
                                    data: formdata,
                                    processData: false,
                                    contentType: false,
                                    success: function(res) {
                                        if (res != 'f') {
					   var pareseObj = $.parseJSON(res);
                                            var imgRgt =  $modal.find('.image-box');
                                            
                                            imgRgt.find('ul').find('li.empty:first').find('a').replaceWith('<img alt="" class="" src="/images/Service/150/'+pareseObj.image+'" data-img="'+pareseObj.image+'"><div class="extras"><div class="extras-inner"><a href="javascript:void(0);" class="del-cat-pic"><i class="fa fa-times"></i></a></div></div>');
                                            imgRgt.find('ul').find('li.empty:first').find('.serviceImg').val(pareseObj.image)
                                            imgRgt.find('ul').find('li.empty:first').removeClass('empty').addClass('theImgH');
                                            
                                            $forAddingImagemodal.modal('toggle');

                                        }else{
                                            alert('Error in Uploading Image. Please try again!');
                                        }
                                    }
                                });
                                
                            }else{
                                alert('Please select Landscape Image.');
                            }
			     }else{
                                     alert('Images should be landscape (wide, not tall) and minimum width of 640 pixels and height of 400 pixels are required.');
                            }
                        };
                    image.onerror= function() {
                        alert('Invalid file type: '+ file.type);
                    };      
                };
            }
        });
        
       /*********End********/
        /**********Delete Image*******/
      
	 $modal.on('click','.del-cat-pic',function(){
            var tObj = $(this);
            if(confirm('Are you sure you want to delete the Image?')){
                tObj.closest('ul').append('<li class="lightgrey empty"><a class="addImage" href="javascript:void(0);"><span><i class="fa fa-plus"></i></span></a><input type="hidden" id="SalonRoomimage" class="serviceImg" name="data[SalonRoom][serviceimage][]"></li>');
                tObj.closest('li.theImgH').remove();
                
                
            }
        });
	 
      /************End*************/
      
      /*********Add More*********/
      $modal.on('click','.addMore',function(){
            var tObj = $(this).parent().find('ul');
            tObj.append('<li class="lightgrey empty"><a class="addImage" href="javascript:void(0);"><span><i class="fa fa-plus"></i></span></a><input type="hidden" id="SalonRoomimage" class="serviceImg" name="data[SalonRoom][serviceimage][]"></li>');
            if(tObj.find('li').length>=5){
                $(this).hide();
            }
        });
      /***********End***********/
});

</script>
<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    <?php
		    
		    echo   ($activeTMenu=='room')?'Hotel '.ucfirst($activeTMenu).'s':'Treatment Rooms'; ?>
		   Listing
                </h3>
               
          <?php echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New</button>','javascript:void(0);',array('data-id'=>'','data-type'=>$activeTMenu,'escape'=>false,'class'=>'addedit_room pull-right'));?>
            </div>
            <div class="box-content">
                <div class="cmsdataView">
                    <?php echo $this->element('admin/Settings/list_admin_rooms'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
