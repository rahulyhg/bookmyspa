    
<div class="modal fade" id="editPostModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
  <div class="modal-dialog popup">
    <div class="modal-content">
        <div class="modal-header">
          <button data-dismiss="modal" class="close close-btn" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
          <h2 id="myModalLabel" class="modal-title">Edit Post</h2>
        </div>
        
        <div class="modal-body">
        
        
        
        
<?php echo $this->Form->create('Contents', array('url' => array('controller' => 'homes', 'action' => 'save_the_content'),'id'=>'contentsForm', 'type'=>'file'));?>
  
  <input type="hidden" name="event_id" value="" id="eventId"/>
  
    <section id="togle" class="mega-dropdown-menu" role="menu" aria-labelledby="dLabel">
    <ul class="listgroup liststyle-none">
        <li>
        <input name="data[Content][title]" id="content_title" type="text" class="form-control textfild content_title_class" placeholder="Title"  required="required" />
        </li>
<li>
<section class="editor-btns">
<ul class="list-inline iconswidget">
<li class="text-tag"><a href="#" data-type="text" class="defaultModal"><i class="fa fa-texticon mrgrtnone"><?php echo $this->Html->image('home/icons/text-icon.png'); ?></i> Text</a>
                    </li>
  <li class="photo-tag mediapop" data-type="photo" id="edit_photo_toggle" ><a  href="javascript:void(0);"><i class="fa fa-photo ph-col mrgrtnone"></i> Photo</a>
 <?php //echo $this->element('photo_modal'); ?>                
</li>
<li id="video_toggle" data-type="video" class="video-tag"><a href="#"><i class="fa fa-video-camera gr-col mrgrtnone"></i> Video</a>
                        <?php //echo $this->element('video_modal'); ?>   
</li>

<li  class="slide-tag">
    <a data-type="slide" class="defaultModal" href="javascript:void(0);"><i class="fa fa-sliders mrgrtnone"></i> Slide</a>
</li>
<li class="meme-tag">
    <a href="javascript:void(0);" data-type="meme" class="defaultModal"><i class="fa fa-meme mrgrtnone"><?php echo $this->Html->image('home/icons/meme.png'); ?></i> Meme</a>
</li>
                    <li class="list-tag"><a href="javascript:void(0);" data-type="lists" class="defaultModal"><i class="fa fa-th-list mrgrtnone bl-col"></i> List</a>
                    </li>
                    <li class="quiz-tag"><a href="javascript:void(0);" data-type="quiz" class="defaultModal"><i class="fa fa-question-circle orng-col mrgrtnone"></i> Quiz</a>
                    </li>
    <li class="poll-tag"><a href="javascript:void(0);" data-type="polls" class="defaultModal"><i class="fa  fa-bar-chart-o grn-col mrgrtnone"></i> Poll</a>
                    </li>
    <li class="lineup-tag"><a href="javascript:void(0);" data-type="lineup" class="defaultModal"><i class="fa fa-lineup mrgrtnone"><?php echo $this->Html->image('home/icons/lineup.png'); ?></i> Lineup</a>
</li>
</ul>
</section>
</li>
        <li>
            <section id="draggablePanelEditList" class="postthumbs">
            </section>
            <input name="data[Content][id]" type="hidden" value="" id="content_id" />
            <input name="data[Content][post_type]" type="hidden" value="" id="post_type" />
        </li>
        <li>
            <section class="tagswdgt">
                <label>Tags:</label>
                <ul class="tags-list liststyle-none clearfix">
                    <input id="tags_edit_post" name="data[Content][tag]" type="text" class="tags" value="" />
                </ul>
            </section>
        </li>
    </ul>
    <!--/ Create Post Editor-->
        <section class="row">
        <section class="col-lg-12">
<div class="col-lg-9" >
      <div role="alert" class="alert alert-success fade in post_success" style="display: none">
      <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span>      </button>
      <strong>Post has been successfully saved!!</strong>
     </div>  
</div>
            
            <!-- Single button -->
                <div class=" btn-group text-right">
                <button id="post-content" data-sub="submit" type="button" class="post btn button"><i class="fa fa-envelope"></i> Post</button>
                <button type="button" class="btn button dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a class="post" data-sub="preview"  id="preview"  href="#">Preview</a>
                    </li>
                    <!-- 
                    <li><a href="#">Another action</a>
                    </li>
                    <li><a href="#">Something else here</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a>
                    </li>-->
                </ul>
            </div>
        </section>
        <!--/col-lg-3-->
    </section>
    <!--/ row-->
</section>
<?php echo $this->Form->end(); ?>
        
      </div>
        
        
    </div>
    <!-- /.modal-content -->
  </div>
<!-- /.modal-dialog -->
</div>      
      
      