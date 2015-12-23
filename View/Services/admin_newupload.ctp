<?php
    echo $this->Html->css('admin/uploadfile.css');
    echo $this->Html->script('admin/jquery.uploadfile.js');
?>
<div class="modal-dialog vendor-setting">
    <div class="modal-dialog upload-img">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h2>Upload Multiple ImageS</h2>
          </div>
          <div class="modal-body clearfix">
            	 <div style='position: relative; float:left; width:40%; display:none;' id='dynamicSubService'><select name='dynamicTtype[]'  id='dynamicTtype' multiple>
			    <?php foreach($subServices as $key=>$subserviceId){
				$subservicename = empty($subserviceId['SalonService']['eng_name']) ? $subserviceId['Service']['eng_name'] : $subserviceId['SalonService']['eng_name'];
				$subserviceid = $subserviceId['SalonService']['id'];
				?>
				 <option value="<?php echo $subserviceid?>"><?php echo $subservicename;?> </option>
			     <?php }?>
			    </select>
			    </div>
                <button type="button" class="purple-btn" id="mulitplefileuploader"><i class="fa  fa-upload"></i>Upload Photos</button>
            
            <div class="clearfix scroll treat-multiupload">
            	<ul class="photo-category clearfix">
                	
                 </ul>
            </div>
            
          </div>
          
          <div class="modal-footer">
	  <div class="col-sm-3 pull-right">
	     <input type="button" style="display:none" name="next" class="btn btn-primary uploadDiv" value="Submit" id="startUpload">
		
          </div>
        </div>
      </div>
</div>
<script>
$(document).ready(function()
{
      var uploadObj = $("#mulitplefileuploader").uploadFile({
	url:"<?php echo $this->Html->url(array('controller'=>'Services','action'=>'newupload','admin'=>true)); ?>",
	autoSubmit:false,
	allowedTypes:"jpg,png,jpeg",
	fileName:"image",
	formData: {"serviceId":<?php echo $serviceID;?>},
	dynamicFormData: function (randId) {
	       var data ={ associatedImg:$("#"+randId).find("#dynamicTtype").val()}
	       return data;
        },
	maxFileSize:1024*100,
	dragDropStr: "<p>Drag &amp; Drop Multiple Photos</p><p class='or'>OR</p>",
	uploadButtonClass: "",
	maxFileCount: 1,
	showDelete:true,
	multiDragErrorStr: "Drag n Drop error.",
	extErrorStr:"Not a valid extension. Allowed extension:",
	sizeErrorStr:"Error while uploading Max:",
	uploadErrorStr:"Upload error",
	maxFileCountErrorStr: " is not allowed. Maximum allowed files are:",
	onSelect:function(files)
	{
	   $(document).find('.errorServer').closest('li').remove();
	   return true;
	},
	testFunc:function(s){
	    $(document).find(".scroll").css('height','250px');
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
	    data = $.trim(data);
	    
	    if(data != 'error' && data != 'dimension_error_800_400' && data != 'resize-error'){
		var data = JSON.parse(data);
		var appendData = ''; 
		appendData+='<li data-img="'+data.image+'" data-id="" data-src="/images/Service/original/'+data.image+'" class="single-picture">';
		appendData+='<img src="/images/Service/150/'+data.image+'" class=" " data-img="'+data.image+'" alt="">';
		appendData+='<div class="extras">';
		appendData+='<div class="dropdown pull-right"><button class="dropdown-toggle" type="button"data-toggle="dropdown"><span class="icon-edit"></span></button>';
		appendData+='<ul class="dropdown-menu">';
		appendData+=' <li data-img="'+data.image+'">';
		appendData+='<a rel="group-1" class="lightGal" href="/images/Service/original/'+data.image+'"><i class="icon-search">View</i></a></li>';
		appendData+=' <li data-img="'+data.image+'">';
		appendData+='<a class="crop-tpic" data-image="'+data.image+'" data-id="<?php echo $serviceID;?>" href="javascript:void(0);"><i class="icon-edit">Crop</i></a></li>';
		appendData+=' <li data-img="'+data.image+'">';
		appendData+='<a class="del-tpic" data-id="<?php echo $serviceID;?>" href="javascript:void(0);"><i class="icon-trash">Delete</i></a>';
		appendData+='</li></ul>';
		appendData+='</div>';
		appendData+='</div>';
		servicesSub = new Array();
		
		for (i = 0; i < data.iDs.length; i++) {
		     servicesSub[i]=   $("#dynamicTtype").find("option[value='"+data.iDs[i]+"']").text();
		 }
		var tag = servicesSub.join(',');
		if(tag !=''){
		    appendData+= '<div class="tags"><i class="icon-tag"></i>&nbsp;'+servicesSub.join(',')+'</div>';
		}
		appendData+='</li>'
	      // console.log(servicesSub.join(','));
		$("#Service_<?php echo $serviceID;?>").find(".gallery").append(appendData);
                $(document).find('.sectionAuto').css("height", "108px");
		$('#gallery_<?php echo $serviceID ?>').lightGallery().destroy();
				$(document).find('#gallery_<?php echo $serviceID?>').find('.extras ul.dropdown-menu li').on('click',function(){
				    $('#gallery_<?php echo $serviceID?>').lightGallery().destroy();	
				    if($(this).find('a').hasClass('lightGal')){
					$('#gallery_<?php echo $serviceID?>').lightGallery({
					    showThumbByDefault:true,
					    addClass:'showThumbByDefault',
					    controls:true,
					    onCloseAfter  : function(el) {
					    $('#gallery_<?php echo $serviceID?>').lightGallery().destroy();
					    },
					});
				    }
				});
	    }
		
	},
	
	afterUploadAll:function()
	{
	  if($(document).find('.modal-body .treat-multiupload ul li').length==0){
	    $("#commonSmallModal").modal('toggle');
	  }
	  $(document).find('.uploadDiv').css('display','none');
	},

});
    $("#startUpload").click(function()
    {	
            $(document).find('.sectionAuto').css("height", "130px");
	    uploadObj.startUpload();
    });
    
     
    $(document).find(".scroll").mCustomScrollbar({
	    advanced:{updateOnContentResize: true,
	     autoScrollOnFocus: false,
	    }
    });
    
});
</script>
	