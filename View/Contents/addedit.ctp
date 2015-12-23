<?php  		
		echo $this->Html->script('fancybox/jquery.fancybox');
		echo $this->Html->script('admin/admin_contents');
		echo $this->Html->script('ckeditor/ckeditor');
		echo  $this->Html->css('jquery-ui');
		echo $this->Html->script('jquery-ui');
		?>
<div id="tabs">
<?php 
	if(isset($this->data['Content']['id'])){
		$editid = base64_encode($this->data['Content']['id']);
	}else{
		$editid = "";
	}
?>
  <ul>
    <li><?php echo $this->Html->link('Regular', '#tabs-1', array('escape' => false)); ?> </li>
    <li><?php echo $this->Html->link('Slider', 'addeditslider/'.$editid, array('id'=>'sliderlink','escape' => false)); ?> </li>
    <li><?php echo $this->Html->link('Quiz', 'addeditquiz/'.$editid, array('id'=>'quizlink','escape' => false)); ?></li>
    <li><?php echo $this->Html->link('List', 'addeditlist/'.$editid, array('id'=>'listlink','escape' => false)); ?></li>
    <li><?php echo $this->Html->link('Poll', 'addeditpoll/'.$editid, array('id'=>'polllink','escape' => false)); ?></li>
    <li><?php echo $this->Html->link('Meme', 'addeditmeme/'.$editid, array('id'=>'memelink','escape' => false)); ?></li>
    <li><?php echo $this->Html->link('Lineup', 'addeditlineup/'.$editid, array('id'=>'lineuplink','escape' => false)); ?></li>
  </ul>
  <div id="tabs-1">
    <div id="message"></div>
    <?php 
	echo $this->Form->create(null, array('url' => array('controller' => 'contents', 'action' => 'addedit'),'id'=>'contentFormId','type' => 'file'));              
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
                         <?php
			echo $this->Form->input('categories',array('type'=>'select','options' => $category,'id'=>'category','label' => false,'div' => false,'class' => 'form-control'));?>
                     </div>
                     <div class="col-lg-5">
                       <!--blank div-->
                </div>
                 </div>
             </div>
         </div>
     </div><!-- /.row -->
     <div class="fields">
     <div class="row" id="content">
         <div class="col-lg-8">        
             <div class="col-lg-12">
                 <div class="form-group form-spacing">
                     <div class="col-lg-2 form-label">
                         <label>Content</label>
                     </div>
                     <div class="col-lg-10 form-box">                
                         <?php echo $this->Form->input('content',array('id'=>'editor1','label' => false,'div' => false, 'placeholder' => 'Content','class' => 'ckeditor'));?>
                     </div>
                     <div class="col-lg-5">
                       <!--blank div-->
                     </div>
                 </div>
             </div>
         </div>
     </div><!-- /.row -->
    
  </div>
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
                     <?php echo $this->Form->button($buttonText, array('type' => 'submit','class' => 'btn btn-default submit_form','data-form'=>'contentFormId'));?>
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
</div><!--/.tab1-->
 
