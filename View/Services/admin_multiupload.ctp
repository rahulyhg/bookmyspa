<?php
    
    echo $this->Html->css('admin/uploadfile.css');
    echo $this->Html->script('admin/jquery.uploadfile.js');
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel"><i class="icon-edit"></i>
    Upload Image</h3>
</div>

<div class="modal-body">
        <div class="box">
          <div class="box-content"><div style='position: relative; float:left; width:40%; display:none;' id='dynamicSubService'><select name='dynamicTtype[]' id='dynamicTtype' multiple>
		 <?php foreach($subServices as $key=>$subserviceId){?>
		      <option value="<?php echo $key?>"><?php echo $subserviceId?> </option>
		  <?php }?>
		 </select>
		 </div>
		<div class="span5">
		    <div id="mulitplefileuploader">Upload</div>
		</div>
		
		 <div class="span2">
		 
		    <div id="status"></div>
		 </div>
		 <div class="ajax-file-upload-green" id="startUpload">Start Upload</div>
	    </div>   
    </div>
</div>
<script>
$(document).ready(function()
{
    var uploadObj = $("#mulitplefileuploader").uploadFile({
	url:"<?php echo $this->Html->url(array('controller'=>'Services','action'=>'multiupload','admin'=>true)); ?>",
	multiple:true,
	autoSubmit:false,
	allowedTypes:"jpg,png,jpeg",
	fileName:"image",
	formData: {"serviceId":<?php echo $serviceID;?>},
	dynamicFormData: function (randId) {
	       var data ={ associatedImg:$("#"+randId).find("#dynamicTtype").val()}
	       return data;
        },
	maxFileSize:2848*2848,
	minFileSize:60*60,
	maxFileCount:5,
	showError: false,
	showStatusAfterSuccess:false,
	dragDropStr: "<span><b>Drag n Drop images here</b></span></br>or</br>",
	abortStr:"Abort",
	cancelStr:"Cancel",
	doneStr:"Done",
	multiDragErrorStr: "Drag n Drop error.",
	extErrorStr:"Not a valid extension Allowed extension:",
	sizeErrorStr:"Error while uploading Max:",
	uploadErrorStr:"Upload n'est pas autorisé",
	onSelect:function(files)
	{
	   return true;
	   // console.log(files);
	//    var reader = new FileReader();
	//    var image = new Image();
	//    var file = files[0];
	//    reader.readAsDataURL(file);  
	//    reader.onload = function(_file) {
	//    image.src    = _file.target.result;   
	//    image.onload = function() {
	//	var width  = this.width;
	//	var height = this.height;
	//	if(width < height){
	//	    return false;
	//	}else{
	//	    return true;
	//	}
	//       
	//      }
	//    }
	 
	   //return true;
	    
//	    for (i = 0; i < files.length; i++) {
//		var file = files[i];
//		var reader = new FileReader();
//                var image = new Image();
//                reader.readAsDataURL(file);  
//                reader.onload = function(_file) {
//		image.src    = _file.target.result;   
//		image.onload = function() {
//		    var width  = this.width;
//		    var height = this.height;
//		  
//		     if(width != height){
//			alert('not same');
//			return false;
//		    }else{
//			return true;
//		    }
//		   
//		  }
//	      }
//	      
//	      
//	    }
	      
	   
	},
	getVal:function(){
	   // alert('hi');
	},
	testFunc:function(s){
	   
	    var treatment = $("#dynamicSubService").html();
	    $('.ajax-file-upload-statusbar'+'#'+s).append(treatment);
	   
	},
	
	onSubmit:function(files,xhr){
	 
	    // alert('Hi');    
	},
	onSuccess:function(files,data,xhr)
	{
	    if(data != 'error'){
		var data = JSON.parse(data);
		var appendData = ''; 
		appendData+='<li data-img="'+data.image+'" data-id="" class="single-picture">'
		appendData+='<img src="/images/Service/150/'+data.image+'" class=" " data-img="'+data.image+'" alt="">'
		appendData+='<div class="extras">'
		appendData+='<div class="dropdown pull-right"><button class="dropdown-toggle" type="button"data-toggle="dropdown"><span class="icon-edit"></span></button>'
		appendData+='<ul class="dropdown-menu">'
		appendData+=' <li data-img="'+data.image+'">'
		appendData+='<a rel="group-1" class="colorbox-image cboxElement" href="/images/Service/800/'+data.image+'"><i class="icon-search">View</i></a></li>'
		appendData+=' <li data-img="'+data.image+'">'
		appendData+='<a class="edit-tpic" data-id="<?php echo $serviceID;?>" href="javascript:void(0);"><i class="icon-edit">Crop</i></a></li>'
		appendData+=' <li data-img="'+data.image+'">'
		appendData+='<a class="del-tpic" data-id="<?php echo $serviceID;?>" href="javascript:void(0);"><i class="icon-trash">Delete</i></a>'
		appendData+='</li></ul>'
		appendData+='</div>'
		appendData+='</div>'
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
	    }
		
	},
	
	afterUploadAll:function()
	{
		//$(document).find('.close').trigger('click');
	},

});
    $("#startUpload").click(function()
    {
	    uploadObj.startUpload();
    });

});
</script>
	