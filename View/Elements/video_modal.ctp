<div class="videoModal">  
<div style="display: block" id="video_popover" class="popover popover-custom left">
<input class="content_type" value="video" type="hidden" />
<input id="video_id" value="<?php echo $id;?>" name="data[Video][id]" type="hidden" />
<div class="arrow"></div>
<h3 class="popover-title video-title">
<i class="fa fa-file-image-o font16 "></i>Paste your video url
<button  class="btn btn-xs btn-primary videoClose" type="button"><i class="fa fa-times font16 text-right"></i> </button>
<button  class="btn btn-xs btn-primary videoSave" type="button"><?php echo (isset($this->data['id']) ? 'Update' : 'Save');?></button>
</h3>
<div class="popover-content">
    <ul class="photo-upload liststyle-none">
<!--        <li>
   <i class="fa fa-mail-forward font14 poslt"></i>
   <input type="text" id="" data-type="" value="<?php echo (isset($datasets['Video']['title']))?$datasets['Video']['title']:'';  ?>"  name="title" class="form-control textfild video_title" placeholder="title" /></li>-->
  <li>
      <input type="url" value="<?php echo (isset($datasets['Video']['video_url']))?$datasets['Video']['video_url']:'';  ?>" id="photo_url" data-type="insertVideoUrl"  name="textfield" class="form-control textfild video_url" placeholder="Paste video url" />
  </li>
 </ul>
</div>
     </div>
</div>