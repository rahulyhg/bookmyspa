<?php
    echo $this->Html->css('admin/uploadfile.css');
    echo $this->Html->script('admin/jquery.uploadfile.js');
?>
<div class="modal-dialog vendor-setting">
    <div class="modal-dialog upload-img">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h2>Upload <?php echo ($type=='image') ? 'Multiple Images': 'Video'; ?></h2>
          </div>
          <?php if($type=='video'){
                echo $this->Form->create('AlbumFile',array('novalidate','type' => 'file','class'=>'form-horizontal'));
          }?>
          <div class="modal-body clearfix">
            	
                <?php if($type=='image'){?>
                <button type="button" class="purple-btn" id="mulitplefileuploader"><i class="fa  fa-upload"></i>Upload Photos</button>
            <div>
                <div class="clearfix scroll treat-multiupload">
                    <div style="display: none;" class="ajax_indicator_gallery">
                        <?php echo $this->Html->image('gif-load.GIF'); ?>
                    </div>
                    <ul class="photo-category clearfix">
                            
                     </ul>
                </div>
            </div>
            <?php } else{
                      ?>
                                <div class="form-group">
                                        <label class="control-label col-sm-3">Youtube Link:</label>
					<div class="col-sm-7">
					    <?php echo $this->Form->input('url',array('required'=>true,'type'=>'url','label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'10','maxlength'=>'200','required','pattern'=>'https?://.+','validationMessage'=>"Url is Required.",'data-minlength-msg'=>"Minimum 10 characters.",'data-maxlength-msg'=>"Maximum 200 characters.",'data-pattern-msg'=>"Please enter only Url.")); ?>
					</br>
					<i style="font-size:11px">Only youtube video url are accepted</i><br>
                                        <i style="font-size:11px">ex: https://www.youtube.com/watch?v=h2Nq0qv0K8M </i>
					</div>
				</div>
             <?php }?>
          </div>
          <div class="modal-footer">
                <div class="col-sm-3 pull-right">
                    <?php if($type=='image'){?>
                         <input type="button" style="display:none" name="next" class="btn btn-primary uploadDiv" value="Submit" id="startUpload">
                         <?php } else{
                                         echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary  save','label'=>false,'div'=>false));
                                 }?>
                </div>
	  </div>
        </div>
      </div>
      <?php if($type=='video') { echo $this->Form->end(); } ?>
</div>
<script>
$(document).ready(function()
{
    var validator = $("#AlbumFileAdminAddImageForm").kendoValidator({
	rules:{
	    minlength: function (input) {
		return minLegthValidation(input);
	    },
	    maxlength: function (input) {
		return maxLegthValidation(input);
	    },
	    pattern: function (input) {
		return patternValidation(input);
	    }
	},
	errorTemplate: "<dfn class='text-danger'>#=message#</dfn>"}).data("kendoValidator");    

   var uploadObj = $("#mulitplefileuploader").uploadFile({
	url:"<?php echo $this->Html->url( null, true ); ?>",
	autoSubmit:false,
	allowedTypes:"jpg,png,jpeg",
	fileName:"image",
	formData: '',
	maxFileSize:204800,
	maxFileCount:-1,
	dragDropStr: "<p>Drag &amp; Drop Multiple Photos</p><p class='or'>OR</p>",
	uploadButtonClass: "",
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
	     $(document).find(".scroll").css('height','200px');
	},
        onError:function(){
            
        },
        onSubmit: function (files, xhr) {
            $('.ajax_indicator_gallery').show();  
        },
	onSuccess:function(files,data,xhr)
	{
	     $('.ajax_indicator_gallery').hide(); 
                 if($.trim(data) != 'error' && $.trim(data) != 'dimension_error_300_200' && $.trim(data) != 'maxLimit'){
		    var data = jQuery.parseJSON(data);
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
                           
                      }
	    }
	    
		
	},
	
	afterUploadAll:function()
	{
	  var maxLen = $(document).find('.modal-body #maxErrorLimit').length;
	  var error = $(document).find('.modal-body .treat-multiupload ul li').length;
	  if(error==0 && maxLen==0 ){
	    $("#commonSmallModal").modal('toggle');
	  }
	  $(document).find('.uploadDiv').css('display','none');
	  
	},

});
    $("#startUpload").click(function()
    {	
	    uploadObj.startUpload();
	    
    });
    
     $(document).find(".scroll").mCustomScrollbar({
			advanced:{updateOnContentResize: true}
		});
    
    
});
</script>
<!--<div class="modal-dialog vendor-setting addUserModal">
    <div class="modal-content"> 
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
    <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> <?PHP ECHO $type; ?></h3>
        </div>
        <div class="modal-body">
            <div class="box">
                <div class="box-content">

                    <?php echo $this->Form->create('AlbumFile',array('novalidate','type' => 'file'));?>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1" data-toggle="tab">English</a></li>
                        <li><a href="#tab2" data-toggle="tab">Arabic</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="sample-form form-horizontal">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" >English Title *:</label>
                                           <?php echo $this->Form->input('eng_title',array('label'=>false,'div'=>array('class'=>'col-sm-5'),'class'=>'form-control','maxlength'=>'200')); ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" >English Description *:</label>
                                                <?php echo $this->Form->textarea('eng_description',array('label'=>false,'class'=>'form-control')); ?>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <div class="sample-form form-horizontal">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">Arabic Title *:</label>
                                            <?php echo $this->Form->input('ara_title',array('label'=>false,'div'=>array('class'=>'col-sm-5'),'class'=>'form-control','maxlength'=>'200')); ?>
                                    </div>
                                </fieldset>
                               <fieldset>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" >Arabic Description *:</label>
                                            <?php echo $this->Form->textarea('ara_description',array('label'=>false,'class'=>'form-control')); ?>
                                    </div>
                                </fieldset>
                            </div>    
                        </div>
                    </div>
                      <div class="sample-form form-horizontal">
                      <fieldset>
                            <div class="form-group">
                                <label class="control-label" for="input01"><?php echo ucfirst($type);?> : </label>
                                <?php if($type=="image"){ ?>
                                    <div class="controls">
                                        <?php echo $this->Form->input('image',array('type'=>'file','label'=>false,'div'=>false,'class'=>'form-control' ,'onChange'=>'readURL(this)')); ?>
                                     <div class="preview">
                                      <?php
                                      $uid = $this->Session->read('Auth.User.id');
                                      if(!empty($imageData['AlbumFile']['image'])){
                                       echo $this->Html->Image('/images/'.$uid.'/AlbumFile/150/'.$imageData['AlbumFile']['image']); 
                                      }
                                   ?> 
                                    </div>
                                    </div>
                                <?php }else{ ?>
                                     <?php echo $this->Form->input('url',array('required'=>true,'type'=>'url','label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                        <span><br><i style="font-size:11px">Only youtube video url are accepted</i><br>
                                        <i style="font-size:11px">ex: https://www.youtube.com/watch?v=h2Nq0qv0K8M </i>
                                        </span>
                                <?php } ?>
                            </div>
                        </fieldset>
                    </div>
                    <div class="sample-form form-horizontal">
                    <fieldset>
                     <div class="from-action text-center">
                             <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary save','label'=>false,'div'=>false));?>
                             <button  data-dismiss="modal" class="btn">Close</button>                       
                     </div>
                    </fieldset> 
                    </div>
                <?php echo $this->Form->end(); ?>
            </div>   
</div>
</div>     

--><script>
 /* function to show image before upload */
 function readURL(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.preview').html('<img src="'+e.target.result+'" style="width: 200px;"/>');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>


