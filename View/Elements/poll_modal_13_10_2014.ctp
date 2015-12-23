<!--Create a List Popup Start--><section class="modal-dialog">
    <section class="modal-content">
        <section class="modal-header">
            <button type="button" class="close close-btn" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h2 class="modal-title" id="myModalLabel"><?php echo (isset($this->data['id']) ? 'Edit' : 'Create a new');?>  Poll</h2>
        </section>
<?php  echo $this->Form->create('Home', array('url' => array('controller' => 'homes', 'action' => 'insertPoll'), 'id' => 'pollContent', 'type' => 'file'));
                        ?>
              <input id="poll_id" value="<?php echo $id;?>" name="data[Poll][poll_id]" type="hidden" />      
              <input type='hidden' name='content_id' id="contentId"   value="" />
              <input class="content_type" value="polls" type="hidden" />
<section class="modal-body">
    <?php  if(!empty($datasets['PollQuestion'])){  ?>
            <!--Add Question Start-->
            <section class="addlist-widget first">
                <section class="addlisttop clearfix">
                    <span class="labelpoint"><i class="fa fa-question-circle"></i></span>
                    <section class="right-field">
                     <?php echo $this->Form->input('title', array('name' => 'data[Poll][question][title]', 'label' => false, 'div' => false,'placeholder' => 'Question', 'class' => 'form-control textfild ', 'value' => $datasets['PollQuestion']['question'] ,'required'=>'required')); ?>
                    </section>
                </section><!--/ Top-->

                <section class="addlist-middle">
    <a data-imagename = 'data[Poll][question][image]' class="UploadButton" href="javascript:void(0);">
                        <span class="fileupload">
                                <span class="img-pos">
                                <i class="fa  fa-file-image-o">
                        </i>Image</span>
      <?php 
      if(isset($datasets['PollQuestion']['image']) && !empty($datasets['PollQuestion']['image'])){
      list($width) = getimagesize(BASE_URL.'img/polls/original/'.$datasets['PollQuestion']['image']);
      $image_width = ($width>600)?'width=100%':'';
       echo $this->Html->image('polls/original/'.$datasets['PollQuestion']['image'], array('class' => 'preview_image' ,$image_width)); }?>
      </span></a>
 <?php echo $this->Form->input('image', array('id'=>false, 'name' => 'data[Poll][question][image]', 'type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'hiddenFileUpload', 'value' => $datasets['PollQuestion']['image'])); ?>   
 </section><!--/ Middle-->

            </section>
            <!--Add Question Closed-->

            <!--Add List Start-->
            <section class="answer-widget">
                <h3>Answers:</h3>
                <ul class="answer-list liststyle-none">
                <?php foreach($datasets['PollQuestion']['PollAnswer'] as $key=>$poll_answers){ 
                    
                    ?>
                    <li>
<!--                        <a class="close-btn posrt removePollAnswer"><i class="fa fa-times-circle font18"></i></a>                            	-->

                              <section class="addmedia-widget">
                                  
                    <section class="addmedia"><a data-imagename = "data[Poll][answers][<?php echo $key; ?>][image]" class="UploadButton" href="javascript:void(0);"><span class="fileupload fullimg"><span class="img-pos"><i class="fa  fa-file-image-o"></i>
                   Image</span>
                <?php echo $this->Html->image('polls/thumb/'.$poll_answers['image'], array('class' => 'preview_image')); ?>
               </span></a>
               <?php echo $this->Form->input('image', array('id'=>false, 'name' => 'data[Poll][answers]['.$key.'][image]', 'type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'hiddenFileUpload', 'value' => $poll_answers['image'])); ?>
               </section>
                        </section>
                        <section class="answertextarea">
                             <?php echo $this->Form->textarea('answer_title', array('required' => false, 'name' => 'data[Poll][answers]['.$key.'][title]','required'=>TRUE, 'placeholder'=> 'add answer here', 'label' => false, 'div' => false, 'class' => 'form-control textfild', 'value' => $poll_answers['answer'])); ?>  </section>
                     </li>
                    <?php } ?>
                </ul>
            </section>
            <?php  } else { ?>
                 <section class="addlist-widget first">
                <section class="addlisttop clearfix">
                    <span class="labelpoint"><i class="fa fa-question-circle"></i></span>
                    <section class="right-field">
                     <?php echo $this->Form->input('title', array('name' => 'data[Poll][question][title]', 'label' => false, 'div' => false, 'placeholder' => 'Question', 'class' => 'form-control textfild ' ,'required'=>TRUE)); ?>
                    
                    </section>
                </section><!--/ Top-->
                <section class="addlist-middle">
                    <a data-imagename = 'data[Poll][question][image]' class="UploadButton" href="javascript:void(0);">
                        <span class="fileupload"><span class="img-pos"><i class="fa  fa-file-image-o"></i>
                    Image</span>
                    <?php echo $this->Form->input('image', array('id'=>false, 'name' => 'data[Poll][question][image]', 'type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'hiddenFileUpload')); ?> </span></a>  
                </section><!--/ Middle-->

            </section>
            <!--Add Question Closed-->

            <!--Add List Start-->
            <section class="answer-widget">
                <h3>Answers:</h3>
                <ul class="answer-list liststyle-none">
                    <li>
<!--                        <a class="close-btn posrt removePollAnswer"><i class="fa fa-times-circle font18"></i></a>                                       -->
                            <section class="addmedia-widget">
                            <section class="addmedia"><a data-imagename = "data[Poll][answers][0][image]" class="UploadButton" href="javascript:void(0);"><span class="fileupload fullimg"><span class="img-pos"><i class="fa  fa-file-image-o"></i>
                                            Image  </span></span></a>
<?php echo $this->Form->input('image', array('id'=>false, 'name' => 'data[Poll][answers][0][image]', 'type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'hiddenFileUpload')); ?>
</section> </section>
<section class="answertextarea">
                             <?php echo $this->Form->textarea('answer_title', array('required' => TRUE, 'name' => 'data[Poll][answers][0][title]', 'placeholder'=> 'add answer here', 'label' => false, 'div' => false, 'class' => 'form-control textfild')); ?></section>
                    </li>
                    <li>
<!--  <a class="close-btn posrt removePollAnswer"><i class="fa fa-times-circle font18"></i></a> -->
                            <section class="addmedia-widget">
 <section class="addmedia"><a data-imagename = "data[Poll][answers][1][image]" class="UploadButton" href="javascript:void(0);"><span class="fileupload fullimg"><span class="img-pos"><i class="fa  fa-file-image-o"></i>
                                            Image  </span></span></a>
<?php echo $this->Form->input('image', array('id'=>false, 'name' => 'data[Poll][answers][1][image]', 'type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'hiddenFileUpload')); ?>
                </section>
</section>
            <section class="answertextarea">
             <?php echo $this->Form->textarea('answer_title', array('required' => TRUE, 'name' => 'data[Poll][answers][1][title]', 'placeholder'=> 'add answer here', 'label' => false, 'div' => false, 'class' => 'form-control textfild')); ?></section>
                    </li>
                    
                </ul>
            </section>
                
                
            <?php } ?>
            <!--Add List Closed-->
            <p class="btngap"><button data-count="<?php echo (isset($datasets['PollQuestion']['PollAnswer']) ? sizeof($datasets['PollQuestion']['PollAnswer']) : 2 );?>" type="button" class="pollAddAnswer btn button"><i class="fa fa fa-plus-circle font16"></i> Add Answer</button></p>
 </section>
        <section class="modal-footer">
            <button id="insertPoll" data-loading-text="<?php echo (isset($this->data['id']) ? 'Updating...' : 'Inserting...');?>" type="submit" class="btn button"><i class="fa fa-upload font16"></i> <span><?php echo (isset($this->data['id']) ? 'Update' : 'Insert');?></span></button>
        </section>
         <?php echo $this->Form->end(); ?>  
        
    </section>
</section>
