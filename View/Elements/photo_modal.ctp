<div class="photoModal">
<input class="content_type" value="photo" type="hidden" />
<input id="photo_id" value="<?php echo $id;?>" name="data[Photo][id]" type="hidden" />
<div style="display: block" id="photo_popover" class="popover popover-custom left">
<div class="arrow"></div>
<h3 class="popover-title video-title">
<i class="fa fa-file-image-o font16"></i>Select upload type
<button  class="btn btn-xs btn-primary photoClose" type="button"><i class="fa fa-times font16 text-right"></i> </button>
<button  class="btn btn-xs btn-primary photoSave" type="button"><?php echo (isset($this->data['id']) ? 'Update':'Save');?></button>
</h3>
<div class="popover-content">
<ul class="photo-upload liststyle-none">
 <li>
     <?php //pr($datasets); ?>
     
 <i class="fa fa-mail-forward font14 poslt"></i>
 <input type="url" id="photo_url" data-type="insertPhotoUrl" value="<?php echo (@$datasets['Photo']['image_type']=='url')?$datasets['Photo']['image']:''; ?>" name="textfield" class="form-control textfild url" placeholder="Paste image url" />
</li>
   <li>
   <a  id="UploadButton" class="EditUploadButton"><i class="fa  fa-download font14 poslt"></i>Browse your computer</a>
   <div id="ajax_indicator"></div>
   <div id="img_display">
       <?php $image =  (@$datasets['Photo']['image_type']=='file')?$datasets['Photo']['image']:'';;
       if($image){
       ?>
       
    <img id="imageName" data-name="<?php echo $datasets['Photo']['image']; ?>" style="max-width:100px; max-height:100px" alt="" src="/img/photos/thumb/<?php echo $datasets['Photo']['image']; ?>">    
       <?php } ?>
   </div>
 </li>
</ul>
</div>
</div>
</div>