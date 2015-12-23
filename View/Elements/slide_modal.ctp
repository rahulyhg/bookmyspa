<div class="modal-dialog">
    <div class="modal-content">
        <section class="popup">
            <section class="modal-dialog">
                <section class="modal-content">
                    <section class="modal-header">
                        <button type="button" class="close close-btn" data-dismiss="modal">                         
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
            </button>
        <h2 class="modal-title" id="myModalLabel"><?php echo (isset($this->data['id']) ? 'Edit' : 'Make');?> a Slide Show</h2>
                   </section>
                    <?php echo $this->Form->create('Slide', array('url' => array('controller' => 'homes', 'action' => 'slide'), 'id' => 'SlideContent', 'type' => 'file')); ?>
                    <input id="slide_id" value="<?php echo $id;?>" name="data[Slide][slide_id]" type="hidden" />
                    <input type='hidden' name='content_id' id="contentId"   value="" />
                    <input class="content_type" value="slide" type="hidden" />
                    <section class="modal-body">
                        <?php  if(!empty($datasets)){
                                $numbering = 1;
                                foreach($datasets as $dataset){ 
                                    if(!empty($dataset['SlideItem'])){ 
                                    foreach($dataset['SlideItem'] as $key => $slide_items){ 
                        ?>
                        <section class="addlist-widget add_div">
                            <section class="addlisttop clearfix">
                                <span class="labelpoint"><?php echo $numbering;?></span>
                                <section class="right-field">
                                    <?php echo $this->Form->input('title', array('name' => 'data[Slide][title][]', 'label' => false,'required'=>TRUE, 'div' => false, 'placeholder' => 'Item Title', 'class' => 'form-control textfild', 'value' => $slide_items['title'])); ?>
                                </section>
                            </section>
                            <!--/ Top-->
                            <section class="addlist-middle">
   <a data-imagename = 'data[Slide][image][]' class="UploadButton" href="javascript:void(0);"><span class="fileupload">
<span class="img-pos"><i class="fa fa-file-video-o">
                            </i> Add Media </span>
<?php
if(isset($slide_items['image']) && !empty($slide_items['image'])){
list($width) = getimagesize(BASE_URL.'img/slide/original/'.$slide_items['image']);
$image_width = ($width>600)?'width=100%':'';    
echo $this->Html->image('slide/original/'.$slide_items['image'], array('class' => 'preview_image',$image_width)); 
} ?>
</span></a>
<?php echo $this->Form->input('image', array('id'=>false, 'name' => 'data[Slide][image][]', 'type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'hiddenFileUpload', 'value' => $slide_items['image'])); ?>   
                            </section>
                            <!--/ Middle-->
                            <section class="addlistbottom">
                            <?php echo $this->Form->input('caption', array('type'=>'textarea','name' => 'data[Slide][caption][]', 'label' => false, 'div' => false, 'placeholder' => 'Type your caption', 'class' => 'form-control textfild auto-text-area','rows'=>1, 'value' => $slide_items['caption'])); ?>
                            </section>
                            <!--/ Top-->
                        </section>
                        <?php $numbering++; }} ?>
                        <?php }?>
                        <?php } else{ ?>
                        <!--Add Slide Start-->
                        <section class="addlist-widget first">
                            <section class="addlisttop clearfix">
                                <span class="labelpoint">1</span>
                                <section class="right-field">
                                    <?php echo $this->Form->input('title', array('name' => 'data[Slide][title][]', 'label' => false, 'div' => false,'required'=>TRUE, 'placeholder' => 'Item Title', 'class' => 'form-control textfild')); ?>
                                </section>
                            </section>
                            <!--/ Top-->

                            <section class="addlist-middle">
                             <a data-imagename = 'data[Slide][image][]' class="UploadButton" href="javascript:void(0);"><span class="fileupload">
                                        <span class="img-pos"><i class="fa fa-file-video-o">
                                        </i> Add Media </span>          
                                    
                                    </span></a>
                                <?php echo $this->Form->input('image', array('id'=>false, 'name' => 'data[Slide][image][]', 'type' => 'hidden','class' => 'hiddenFileUpload')); ?>   
                            </section>
                            <!--/ Middle-->
                            <section class="addlistbottom">
                                <?php echo $this->Form->input('caption', array('type'=>'textarea','name' => 'data[Slide][caption][]', 'label' => false, 'div' => false, 'placeholder' => 'Type your caption', 'class' => 'form-control textfild auto-text-area','rows'=>1)); ?>
                            </section>
                            <!--/ Top-->
                        </section>
                        <!--Add Slide Closed-->

                        <!--Add Slide Start-->
                        <section class="addlist-widget add_div">
                            <section class="addlisttop clearfix">
                                <span class="labelpoint">2</span>
                                <section class="right-field">
                                 <?php echo $this->Form->input('title', array('name' => 'data[Slide][title][]', 'label' => false, 'div' => false, 'placeholder' => 'Item Title', 'class' => 'form-control textfild')); ?>
                                </section>
                            </section>
                            <!--/ Top-->
                            <section class="addlist-middle">
                                <a data-imagename = 'data[Slide][image][]' class="UploadButton" href="javascript:void(0);"><span class="fileupload">
                                <span class="img-pos"><i class="fa fa-file-video-o">
                                </i> Add Media </span>       
                                </span>
                                </a>
                               <?php echo $this->Form->input('image', array('id'=>false, 'name' => 'data[Slide][image][]', 'type' => 'hidden','class' => 'hiddenFileUpload')); ?>   
                            </section>
                            <!--/ Middle-->

                            <section class="addlistbottom">
                                <?php echo $this->Form->input('caption', array('type'=>'textarea','name' => 'data[Slide][caption][]', 'label' => false, 'div' => false, 'placeholder' => 'Type your caption', 'class' => 'form-control textfild auto-text-area','rows'=>1)); ?>
                            </section>
                            <!--/ Top-->
                        </section>
                        <!--Add List Closed-->
                        <?php } ?>
                        <p class="btngap">
                            <button type="button" id="add_slideitem" data-count="<?php echo (isset($datasets[0]['SlideItem']) ? sizeof($datasets[0]['SlideItem']) + 1 : 3)?>" class="btn button"><i class="fa fa fa-plus-circle font16"></i> Add item</button>
                        </p>
                    </section>
                    <section class="modal-footer">
                        <button id="insertList" data-loading-text="<?php echo (isset($this->data['id']) ? 'Updating...' : 'Inserting...');?>" type="submit" class="btn button"><i class="fa fa-upload font16"></i>  <span><?php echo (isset($this->data['id']) ? 'Update' : 'Insert');?></span>
                        </button>
                    </section>
                    <?php echo $this->Form->end(); ?>
                </section>
            </section>
        </section>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->