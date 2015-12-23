    <?php 
		echo $this->Html->script('ckeditor/ckeditor');
		echo $this->Html->script('quiz_category/quiz');
	?>	
		<div class="message"></div>
	<?php
		echo $this->Form->create(null, array('url' => array('controller' => 'contents', 'action' => 'addeditquiz'),'id'=>'contentFormQuiz','type' => 'file'));              
        echo $this->Form->hidden('id',array('value'=>base64_encode($this->data['Content']['id']))); 
	?>
     <div class="row">
         <div class="col-lg-8">        
             <div class="col-lg-12">
                 <div class="form-group form-spacing">
                     <div class="col-lg-2 form-label">
                         <label>Title<span class="required"> * </span></label>
                     </div>
                     <div class="col-lg-5 form-box">                
                         <?php echo $this->Form->input('title',array('label' => false,'div' => false, 'placeholder' => 'Title','class' => 'form-control','maxlength' => 100));?>
                     </div>
                     <div class="col-lg-5">
                       <!--blank div-->
                     </div>
                 </div>
             </div>
         </div>
     </div><!-- /.row -->
     <div class="row">
         <div class="col-lg-8">        
             <div class="col-lg-12">
                 <div class="form-group form-spacing">
                     <div class="col-lg-2 form-label">
                         <label>Type</label>
                     </div>
                     <div class="col-lg-5 form-box">  
                         <?php echo $this->Form->input('categories',array('type'=>'select','options' => $category,'id'=>'category','label' => false,'div' => false,'class' => 'form-control'));?>
                     </div>
                     <div class="col-lg-5">
                       <!--blank div-->
                     </div>
                 </div>
             </div>
         </div>
     </div><!-- /.row -->
     <div class="fields_quiz">
     <div class="row" id="content">
         <div class="col-lg-8">        
             <div class="col-lg-12">
                 <div class="form-group form-spacing">
                     <div class="col-lg-2 form-label">
                         <label>Content</label>
                     </div>
                     <div class="col-lg-10 form-box">                
                         <?php echo $this->Form->input('content',array('id'=>'editor3','label' => false,'div' => false, 'placeholder' => 'Content','class' => 'ckeditor'));?>
							<script type="text/javascript">
								CKEDITOR.replace( 'editor3' );
								CKEDITOR.add            
							</script>	
                     </div>
                     <div class="col-lg-5">
                       <!--blank div-->
                     </div>
                 </div>
             </div>
         </div>
     </div><!-- /.row -->
    
 
 <?php  if(count($this->data['cat_quizzes'])){ ?>
	<?php 
		$i = 1;
		$quizcount = count($quiz_data);
		foreach($quiz_data as $quiz){	
	 ?>	
		<div id="quiz<?php echo $i; ?>">
			<div class="row Quiz">
				<div class="col-lg-8">
					<div class="col-lg-12">
						<div class="form-group form-spacing">
							<div class="col-lg-2 form-label">
								<label>Question : <?php echo $i; ?></label>
							</div>
							<div class="col-lg-10 form-box">
								<?php echo $this->Form->hidden('Question',array('value'=>$quizcount,'id'=>'quiz_count')); ?> 
								<?php echo $this->Form->hidden('Question.id.'.$i,array('value'=>$quiz['Question']['id'])); ?> 
								<?php echo $this->Form->input('Question.question_text.'.$i,array('label' => false,'value'=>$quiz['Question']['question_text'],'div' => false, 'placeholder' => 'Image Title')); ?>
								<?php 
								if($i == $quizcount){
									echo $this->Form->button('Add More Question', array('type' => 'button','data-id'=>$i ,'class' => 'add_question')); 	
								}else{
									echo $this->Form->button('Remove', array('type' => 'button','id'=>$i ,'data-questionId'=>$quiz['Question']['id'],'class' => 'remove_q')); 
								}
								?> <br/><br/>
<style>
		#questionPreview<?php echo $i; ?>{
		background-position: center center;
		background-size: cover;
		display: inline-block;
		height: 180px;
		margin-left: 10px;
		width: 180px;
	}
</style>								
								<div  style="background-image: url('<?php echo configure::read('BASE_URL'); ?>/img/Cat_Quiz/thumb/<?php echo $quiz['Question']['question_image']; ?>')"  id="questionPreview<?php echo $i; ?>"></div>
								<?php echo $this->Form->input('Question.question_image.'.$i,array('data-id'=>$i,'type'=>'file','label' => false,'data-jid'=>"questionPreview",'class'=>'PreviewImage img','div' => false)); ?>
								<!--	<input class="PreviewImage" data-jid="questionPreview" data-id="1" type="file" name="data[Question][question_image][1]" class="img" />  -->
							</div>
						<div class="col-lg-5"><!--blank div--></div>
						</div>
					</div>
				</div>
			</div> 
<?php 
$j = 1;
$count_ans = count($quiz['answers']);
foreach($quiz['answers'] as $answer){ ?>
			<div class="row Answer<?php echo $j; ?>" >
				<div id="answer<?php echo $j; ?>">
					<div class="col-lg-8">
						<div class="col-lg-12">
							<div class="form-group form-spacing">
								<div class="col-lg-2 form-label">
									<label>Answer Type:</label>
								</div>
								<div class="col-lg-10 form-box">
									<?php echo $this->Form->hidden('Answer.type.'.$i.'.',array('value'=>$answer['id'])); ?> 
									
								<?php 
									$option = array('R'=>'Text','I'=>'Image');
									echo $this->Form->input('Answer.type.'.$i.'.',array('type'=>'select','options' => $option,'selected' =>$answer['type'],'data-id'=>$j,'label' => false,'div' => false,'class' => 'type')); 
									echo "<br/>";
									echo "<br/>";
									if($answer['right_answer']==1){
										$right = true;	
									}else{
										$right = false;
									}
									if($answer['type']=='R'){
										$style = "";	
									}else{
										$style = "display:none;";	
									}
									echo $this->Form->input('Answer.right_answer.'.$i.'.',array('type' => 'radio','options'=>array('1'=>''),'checked'=>$right,'label' => false,'div' => false)); 
									echo "&nbsp;";
									echo $this->Form->input('Answer.answer_text.'.$i.'.',array('type' => 'text','style'=>$style,'id'=>'text'.$j, 'value'=>$answer['answer_text'],'label' => false,'div' => false)); 
								?>
<?php if($answer['type']=='I'){ ?>								
<style>
		#answerPreview<?php echo $j; ?>{
		background-position: center center;
		background-size: cover;
		display: inline-block;
		height: 180px;
		margin-left: 10px;
		width: 180px;
	}
</style>

<?php 

$style1 = "";
}else{
	$style1 = "display:none;";
	
} ?>									
									<div style="background-image: url('<?php echo configure::read('BASE_URL'); ?>/img/Cat_Quiz_Answer/thumb/<?php echo $answer['answer_image']; ?>')"   id="answerPreview<?php echo $j; ?>"></div>
										<?php echo $this->Form->input('Answer.answer_image.'.$i.'.',array('data-jid'=>'answerPreview','data-quiz'=>$i,'style'=>$style1,'id'=>'image'.$j,'data-id'=>$j,'type'=>'file','label' => false,'class'=>'PreviewImage img','div' => false)); ?>
										<br/>
									<?php 
									$answer_array[] = $j;
									if($j==$count_ans){ ?>
									<?php echo $this->Form->button('Add Answer', array('type' => 'button','data-quiz'=>$i,'data-id'=>$j,'class' => 'add_answer')); ?>
									<?php }else{ ?>
									<?php echo $this->Form->button('Remove', array('type' => 'button','id'=>$i ,'data-answerId'=>$answer['id'],'class' => 'remove_a')); ?>
									<?php } ?>
								</div>
							</div>
							<div class="col-lg-5"><!--blank div--></div>
						</div>
					</div>
				</div>
			</div> 
<?php 
		$j++;
		}
 ?>		
		</div>
	<?php 
	$i++;
	} 
	
	echo $this->Form->hidden('Answer',array('value'=> count($answer_array),'id'=>'answer_count')); 
									
	?>
				
	<!--end here -->
 </div>			   
 <?php }else{ ?>  
    <!--quiz html -->
		<div id="quiz1">
			<div class="row Quiz">
				<div class="col-lg-8">
					<div class="col-lg-12">
						<div class="form-group form-spacing">
							<div class="col-lg-2 form-label">
								<label>Question : 1</label>
							</div>
							<div class="col-lg-10 form-box">
								<?php echo $this->Form->hidden('Question',array('value'=>'1','id'=>'quiz_count')); ?> 
								<?php echo $this->Form->input('Question.question_text.1',array('label' => false,'div' => false, 'placeholder' => 'Image Title')); ?>
								<?php echo $this->Form->button('Add More Question', array('type' => 'button','data-id'=>1 ,'class' => 'add_question')); 	 ?>
								<div id="questionPreview1"></div>
								<?php echo $this->Form->input('Question.question_image.1',array('data-id'=>1,'type'=>'file','label' => false,'data-jid'=>"questionPreview",'class'=>'PreviewImage img','div' => false)); ?>
							</div>
						<div class="col-lg-5"><!--blank div--></div>
						</div>
					</div>
				</div>
			</div> 
			<div class="row Answer1" >
				<div id="answer1">
					<div class="col-lg-8">
						<div class="col-lg-12">
							<div class="form-group form-spacing">
								<div class="col-lg-2 form-label">
									<label>Answer Type:</label>
								</div>
								<div class="col-lg-10 form-box">
								
								<?php 
									 echo $this->Form->hidden('Answer',array('value'=>'1','id'=>'answer_count')); 
									$option = array('R'=>'Text','I'=>'Image');
									echo $this->Form->input('Answer.type.1.',array('type'=>'select','options' => $option,'data-id'=>'1','label' => false,'div' => false,'class' => 'type')); 
									echo "<br/>";
									echo "<br/>";
									echo $this->Form->input('Answer.right_answer.1.',array('type' => 'radio','options'=>array('1'=>''),'label' => false,'div' => false)); 
									echo "&nbsp;";
									echo $this->Form->input('Answer.answer_text.1.',array('type' => 'text','id'=>'text1','label' => false,'div' => false)); 
								?>
									<div id="answerPreview1"></div>
										<?php echo $this->Form->input('Answer.answer_image.1.',array('data-jid'=>'answerPreview','data-quiz'=>'1','style'=>'display:none;','id'=>'image1','data-id'=>'1','type'=>'file','label' => false,'class'=>'PreviewImage img','div' => false)); ?>
										<br/>
										<?php echo $this->Form->button('Add more answer', array('type' => 'button','data-quiz'=>'1','data-id'=>'1','class'=>'add_answer')); ?>
								
								</div>
							</div>
							<div class="col-lg-5"><!--blank div--></div>
						</div>
					</div>
				</div>
			</div> 
		</div>
    <!--end here -->
 </div>
 <?php } ?>
  
   <div class="row">        
        <div class="col-lg-8 form-spacing">
            <div class="col-lg-12"> 
                <div class="form-group">
                    <div class="col-lg-2 form-label">
                        <label>Verified</label>  
                    </div> 
                    <div class="col-lg-10 form-box">  <?php if(isset($this->request->data['Content']['status']) && $this->request->data['Content']['status'] == 0){  $checked= "";}else{  $checked= "checked";} ?>      
                        <?php  echo $this->Form->input('status',array('label' => false,'div' => false,'type '=> 'checkbox', 'checked' => $checked));?>
                    </div>
                </div>
            </div>
        </div>
     </div>
         <div class="row">   
        <div class="col-lg-12 form-spacing">&nbsp;</div>
         
         <div class="col-lg-8">
             <div class="col-lg-12">
                 <div class="col-lg-2">
                   <!--blank div-->
                 </div>
                 <div class="col-lg-10 form-box">
                     <?php echo $this->Form->button($buttonText, array('type' => 'submit','class' => 'btn btn-default','data-form'=>'contentFormSlider'));?>
                      &nbsp;
                     <?php echo $this->Form->button('Reset', array('type' => 'reset','class' => 'btn btn-default'));?>
                      &nbsp;
                     <?php echo $this->Html->link($this->Form->button('Back' ,array('type' => 'button','class' => 'btn btn-default')),'/contents/', array('escape'=>false,'title' => "Click back to list")); ?>
                    
                 </div>
             </div>     
         </div>
         <div class="col-lg-12 form-spacing">&nbsp;</div>
     </div><!-- /.row -->
     <?php echo $this->Form->end(); ?>
