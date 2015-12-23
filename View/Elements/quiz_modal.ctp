<?php echo $this->Form->create('Quiz', array('url' => array('controller' => 'homes', 'action' => 'insertQuiz'), 'id' => 'quizForm', 'type' => 'file')); ?>
<input id="quiz_id" value="<?php echo @$id;?>" name="data[Quiz][quiz_id]" type="hidden" />
<input type='hidden' name='content_id' id="contentId"   value="" />
<input class="content_type" value="quiz" type="hidden" />    
<div class="modal-dialog">
        <section class="popup">
            <section class="modal-dialog">
                <section class="modal-content">
                        <section class="modal-header">
                        <button type="button" class="close close-btn" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h2 class="modal-title" id="myModalLabel">Create a new Quiz</h2>
                        </section>
                        <section class="modal-body">
                        <!--Quiz Top Start-->
                        <section class="quiz-top clearfix">
                        <section class="quiz-media">
<section class="addmedia">
<a data-imagename = 'data[Quiz][dataset][image]' class="UploadButton" data-imagetype='small' href="javascript:void(0);">
 <span class="fileupload fullimg2">
       <span class="img-pos">
       <i class="fa fa-file-image-o"></i>
       Image
     </span>
<?php if(isset($datasets['Quiz'])) { ?>
    <?php echo $this->Html->image('quiz/thumb/'.$datasets['Quiz']['image'], array('class' => 'preview_image')); ?>
  
<?php } ?></span>
</a>
<?php echo $this->Form->input('image', array('id'=>false, 'name' => 'data[Quiz][dataset][image]','type' => 'hidden', 'class' => 'hiddenFileUpload', 'value' => @$datasets['Quiz']['image'])); ?>  
</section>
</section><!--/ Col lg 4-->
<section class="quiz-des">                        	
<?php echo $this->Form->input('title', array('name' => 'data[Quiz][dataset][title]','type' => 'text', 'label' => false, 'div' => false, 'required'=>TRUE,'placeholder' => 'Quiz Title', 'class' => 'form-control m-btm', 'value' => (isset($datasets['Quiz']) ? $datasets['Quiz']['title'] : '' ))); ?>
<?php echo $this->Form->input('description', array('name' => 'data[Quiz][dataset][description]','type' => 'textarea', 'label' => false, 'required'=>TRUE, 'div' => false, 'placeholder' => 'Quiz Description', 'class' => 'form-control', 'value' => (isset($datasets['Quiz']) ? $datasets['Quiz']['description'] : ''))); ?>
</section><!--/ Col lg 8-->
                        </section>
                        <!--Quiz Top Closed-->
<?php
                                if(!empty($datasets['QuizQuestion'])){
                                foreach($datasets['QuizQuestion'] as $qKey => $QuizQuestion){
                                ?>
                                <section class="quizQuestionAnswers">
                                    <section class="addlist-widget">
                                    <section class="addlisttop clearfix"><span class="labelpoint"><?php echo $qKey + 1;?></span>
                                        <section class="right-field">
                                            <input value="<?php echo $QuizQuestion['title'];?>" type="text" name="data[Quiz][QuizQuestions][<?php echo $qKey;?>][question][title]" placeholder="Question" required="required" class="form-control textfild qus">
                                        </section>
                                        <section class="addlist-middle">
                                        <a  data-imagetype='large' data-imagename = 'data[Quiz][QuizQuestions][<?php echo $qKey;?>][question][image]' class="UploadButton" href="javascript:void(0);"><span class="fileupload">
                                        <span class="img-pos"> 
                                        <i class="fa fa-file-image-o"></i>Image</span>
 <?php
   if(isset($QuizQuestion['image']) && !empty($QuizQuestion['image'])){
     list($width) = getimagesize(BASE_URL.'img/quiz/original/'.$QuizQuestion['image']);
                $image_width = ($width>600)?'width=100%':'';
   echo $this->Html->image('quiz/original/'.$QuizQuestion['image'], array('class' => 'preview_image',$image_width));}?>   
                                   </span>

</a>
 <input type="hidden" name="data[Quiz][QuizQuestions][<?php echo $qKey;?>][question][image]" class="hiddenFileUpload" value="<?php echo $QuizQuestion['image']; ?>" >                                           
                                        </section>
                                    </section>
                                <?php
                                    if(!empty($QuizQuestion['QuizAnswer'])){
                                    ?>
                                    <section class="answer-widget">
                                            <h3>Answers:</h3>
                                            <ul class="answer-list liststyle-none">
                                    <?php
                                     foreach ($QuizQuestion['QuizAnswer'] as $aKey => $QuizAnswer){
?>
                                        
<li><a class="close-btn posrt removeQuizAnswer"><i class="fa fa-times-circle font18"></i></a>
                                                    <section class="addmedia-widget">
                                                        <section class="addmedia">
                                                            <a data-imagename = 'data[Quiz][QuizQuestions][<?php echo $qKey;?>][answers][<?php echo $aKey;?>][image]' class="UploadButton" href="javascript:void(0);">
                                                                     <span class="fileupload fullimg">
                                                                       <span class="img-pos">
                                                                           <i class="fa  fa-file-image-o"></i>Image</span>
<?php echo $this->Html->image('quiz/thumb/'.$QuizAnswer['image'], array('class' => 'preview_image')); ?>

 </span></a>
<input type="hidden" name="data[Quiz][QuizQuestions][<?php echo $qKey;?>][answers][<?php echo $aKey;?>][image]" class="hiddenFileUpload" value="<?php echo $QuizAnswer['image']; ?>">
                                                        </section>
                                                    </section>
                                                    <section class="answertextarea">
<textarea name="data[Quiz][QuizQuestions][<?php echo $qKey;?>][answers][<?php echo $aKey;?>][title]" placeholder="add answer here" class="form-control textfild" cols="30" rows="6"><?php echo $QuizAnswer['answer'];?></textarea>
                                                    </section>
</li>
<li class="crt_answers">
<input class="check<?php echo $qKey;?>" type="checkbox" name="data[Quiz][QuizQuestions][<?php echo $qKey;?>][answers][<?php echo $aKey;?>][right_answer]" value="1" <?php echo ($QuizAnswer['right_answer'])?'checked="checked"':''; ?> >
Correct Answer
</li>                                                
                                                
                                                
                                                
                                        <?php
                                    }
                                    ?>
                                            </ul>
                                    </section>
                                    <p class="btngap">
                                        <button type="button" class="quizAddAnswer btn button" data-count="<?php echo sizeof($QuizQuestion['QuizAnswer']);?>" data-question-index="<?php echo $qKey;?>"><i class="fa fa fa-plus-circle font16"></i> Add Answer</button>
                                    </p>
                                    <?php
                                }
                                ?>
                                    </section>
                                </section>
                                <?php
                            }
                        }
                    ?>
                    </section>
                    <section class="modal-footer">
                        <button id="quizAddQuestion" data-count="<?php echo (isset($datasets['QuizQuestion']) ? sizeof($datasets['QuizQuestion']) : 0)?>" type="button" class="btn button pull-left triggerClick"><i class="fa fa fa-plus-circle font16"></i> Add Question</button>
                        <button id="insertQuiz" data-loading-text="<?php echo (isset($this->data['id']) ? 'Updating...' : 'Inserting...');?>" type="submit" class="btn button"><i class="fa fa-upload font16"></i> <span><?php echo (isset($this->data['id']) ? 'Update' : 'Insert');?></span></button>
                    </section>
                </section>
            </section>
        </section>
        <!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    <?php echo $this->Form->end(); ?>  
<!-- /.modal -->
