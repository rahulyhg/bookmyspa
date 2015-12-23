    <?php 
		echo $this->Html->script('ckeditor/ckeditor');
		echo $this->Html->script('quiz_category/poll');
	?>	
		<div class="message"></div>
	<?php
		echo $this->Form->create(null, array('url' => array('controller' => 'contents', 'action' => 'addeditpoll'),'id'=>'contentFormPoll','type' => 'file'));              
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
    <!-- 
     <div class="row" id="content">
         <div class="col-lg-8">        
             <div class="col-lg-12">
                 <div class="form-group form-spacing">
                     <div class="col-lg-2 form-label">
                         <label>Content</label>
                     </div>
                     <div class="col-lg-10 form-box">                
                         <?php // echo $this->Form->input('content',array('id'=>'editor3','label' => false,'div' => false, 'placeholder' => 'Content','class' => 'ckeditor'));?>
							<script type="text/javascript">
								CKEDITOR.replace( 'editor3' );
								CKEDITOR.add            
							</script>	
                     </div>
                     <div class="col-lg-5">
                       <!--blank div-->
                     <!--</div>
                 </div>
             </div>
         </div>
     </div><!-- /.row -->
    
 
 <?php  if(count($this->data['cat_polls'])){ ?>
		<div id="quiz">
			<div class="row Quiz">
				<div class="col-lg-8">
					<div class="col-lg-12">
						<div class="form-group form-spacing">
							<div class="col-lg-2 form-label">
								<label>Question</label>
							</div>
							<div class="col-lg-6 form-box">
								<?php  echo $this->Form->hidden('CatPoll.id',array('value'=>$this->data['cat_polls'][0]['id']));  ?>
								<?php  echo $this->Form->input('CatPoll.question',array('label' => false,'value'=>$this->data['cat_polls'][0]['question'],'div' => false, 'placeholder' => 'Poll Question')); ?>
						<div class="col-lg-5"><!--blank div--></div>
						</div>
					</div>
				</div>
			</div> 
	<div class="row Answer1" >
<?php
$i=1;
 $count = count($answerdata); 
	foreach($answerdata as $answer){ 

?>
				<div id="answer<?php echo $i; ?>">
					<div class="col-lg-8">
						<div class="col-lg-12">
							<div class="form-group form-spacing">
								<div class="col-lg-2 form-label">
									<label>Answer</label>
								</div>
								<div class="col-lg-10 form-box">
								
								<?php 
								    echo $this->Form->hidden('PollAnswer.id.',array('value'=>$answer['PollAnswer']['id'])); 
									echo $this->Form->input('PollAnswer.answer_text.',array('type' => 'text','id'=>'text'.$i, 'value'=>$answer['PollAnswer']['answer_text'],'label' => false,'div' => false)); 
								?>
								<?php 
									if($i==$count){
										echo $this->Form->button('Add more answer', array('type' => 'button','data-id'=>$i,'class'=>'add_answer_poll')); 
									}else{
										echo $this->Form->button('Remove', array('type' => 'button','data-remove'=>$i,'id'=>$answer['PollAnswer']['id'],'class'=>'removePoll')); 
									}	
								?>
								
								</div>
							</div>
							<div class="col-lg-5"><!--blank div--></div>
						</div>
					</div>
				</div>
			<?php 
	$i++;
	} 
	?>

		
    <!--end here -->
 </div>
</div>		   
 <?php }else{ ?>  
    <!--quiz html -->
		<div id="quiz1">
			<div class="row Quiz">
				<div class="col-lg-8">
					<div class="col-lg-12">
						<div class="form-group form-spacing">
							<div class="col-lg-2 form-label">
								<label>Question</label>
							</div>
							<div class="col-lg-6 form-box">
								<?php echo $this->Form->input('CatPoll.question',array('label' => false,'div' => false,'placeholder' => 'Poll Question')); ?>
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
									<label>Answer</label>
								</div>
								<div class="col-lg-10 form-box">
								
								<?php 
									echo $this->Form->input('PollAnswer.answer_text.',array('type' => 'text','id'=>'text1','label' => false,'div' => false)); 
								?>
								<?php echo $this->Form->button('Add more answer', array('type' => 'button','data-id'=>'1','class'=>'add_answer_poll')); ?>
								
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
                     <?php echo $this->Form->button($buttonText, array('type' => 'submit','class' => 'btn btn-default submit_form','data-form'=>'contentFormPoll'));?>
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
