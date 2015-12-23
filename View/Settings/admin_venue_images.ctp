<style>
    .ajax-file-upload-progress{
        margin: 0;
    }
</style>
<?php
    echo $this->Html->css('admin/uploadfile.css');
    echo $this->Html->script('admin/jquery.uploadfile.js');
?>
<div class="modal-dialog vendor-setting overwrite">
    <div class="modal-dialog upload-img">
        <div class="modal-content">
          <div class="modal-header">
          <?php if(isset($type) &&($type=="gallery")){?>
	    <button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	    <?php } ?>
            <h2><?php echo (isset($img_type))? 'Public':'Venue';?> Image</h2>
          </div>
          <div class="modal-body clearfix">
            	<div style='position: relative; float:left; width:40%; display:none;' id='dynamicSubService'>
		</div>
                <button type="button" class="purple-btn" id="mulitplefileuploader"><i class="fa  fa-upload"></i>Upload Photos</button>
            
            <div class="clearfix scroll treat-multiupload">
            	<ul class="photo-category clearfix">
                	
                </ul>
            </div>
            
          </div>
           
          <div class="modal-footer pdng20">
		<div class="col-sm-5 pull-right">
		<?php if(isset($type) &&($type=="gallery")){?>
		    <input type="button" style="display:none" name="submit" class=" btn btn-primary uploadDiv" value="Submit" id="startUpload">
		<?php }else{ ?>
		
		    <?php echo $this->Form->button('Next/Skip',array('data-dismiss'=>'modal',
		      'type'=>'button','label'=>false,'id'=>'skipUpload','div'=>false,
		      'class'=>'btn btn-primary')); ?>
		      <button type="button" style="display:none" name="next" class="btn btn-primary uploadDiv"  id="startUpload">Save</button>
		    <?php } ?>
		    
		</div>
		
          </div>
        </div>
      </div>
</div>
<script>
$(document).ready(function()
{
   
    
    var uploadObj = $("#mulitplefileuploader").uploadFile({
	url:"<?php echo (isset($img_type))? $this->Html->url(array('controller'=>'Settings','action'=>'public_photo','admin'=>true)) : $this->Html->url(array('controller'=>'Settings','action'=>'venue_images','admin'=>true)); ?>",
	autoSubmit:false,
	allowedTypes:"jpg,png,jpeg",
	fileName:"image",
	formData: {"userId":<?php echo $auth_user['User']['id'];?>},
	maxFileSize:204800,
	dragDropStr: "<p>Drag &amp; Drop Multiple Photos</p><p class='or'>OR</p>",
	uploadButtonClass: "",
	multiDragErrorStr: "Drag n Drop error.",
	extErrorStr:"Not a valid extension. Allowed extension:",
	sizeErrorStr:"Error while uploading Max:",
	uploadErrorStr:"Upload error",
	onSelect:function(files)
	{
	  $(document).find('.errorServer').closest('li').remove();
	   return true;
	},
	testFunc:function(s){
	    $(document).find(".scroll").css('height','200px');
	    var treatment = $("#dynamicSubService").html();
	    $(document).find('.ajax-file-upload-select'+'#'+s).append(treatment);
	    $('#'+s).find('#dynamicTtype').addClass('dynamicTtype');
	    $('#'+s).find('.dynamicTtype').multipleSelect({
		width: '100%',
		selectedText:'Please Select',
		placeholder:'Please Select'
	      });
	},
	onSuccess:function(files,data,xhr)
	{
	    if(data.trim() != 'error' && data.trim() != 'dimension_error_300_200'){
                var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'venue_element','admin'=>true)); ?>";
		$('body').modalmanager('loading');
		$('#ajax_box').load(addeditURL,function(){
		    $(document).find(".gallery-dynamic").imagesLoaded(function(){
			    $(document).find(".gallery-dynamic").masonry({
				itemSelector: 'li',
				columnWidth: 201,
				isAnimated: true
			    });
		    });
                });
		    //$('body').modalmanager('loading');
		//    $('#ajax_box').load(addeditURL);
		//    $('#lightGallery').lightGallery({
		//	showThumbByDefault:true,
		//	addClass:'showThumbByDefault',
		//	controls:true
		//    });
	    }
	    
	},
	
	afterUploadAll:function()
	{
	    <?php
	    if(strtolower($auth_user['User']['is_popup']) != 'done'){
		if(isset($img_type)){ ?>
		    $.ajax({url:updateURL,type:'POST',data: {update:'album_image'} });
		<?php 
		}
		else{ ?>
		    //$.ajax({url:updateURL,type:'POST',data: {update:'venue_image'} });
		<?php } ?>
		
            <?php } ?>
	    if($(document).find('.modal-body .treat-multiupload ul li').length==0){
		$(document).find('#commonVendorModal').modal('hide');
		$(document).find(".treat-multiupload").css("height","0px");
		//$(document).find('#commonSmallModal').modal('hide');
	    }
	  $(document).find('.uploadDiv').css('display','none');
	},

});
    $("#startUpload").click(function()
    {	
	    uploadObj.startUpload();
    });
    
    $(document).find("#skipUpload").on("click",function(){
	$.ajax({url:updateURL,type:'POST',data: {update:'venue_image'} });
	$(document).find('#commonSmallModal').modal('hide');
	
    });
     
    $(document).find(".scroll").mCustomScrollbar({
	    advanced:{updateOnContentResize: true}
    });
    
});
</script>
	