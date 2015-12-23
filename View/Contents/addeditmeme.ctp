    <?php 
    	echo $this->Html->script('ckeditor/ckeditor');
    	echo $this->Html->script('quiz_category/meme');
    	
	?>
	<style>
	//remeber add this to main css after testing
		#canvas {
			display: block;
			margin: 1em auto;
		}
	</style>	
	
		<div class="message"></div>
	<?php
	
		echo $this->Form->create(null, array('url' => array('controller' => 'contents', 'action' => 'addeditmeme'),'id'=>'contentFormMeme','type' => 'file'));              
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
                         <?php echo $this->Form->input('categories',array('type'=>'select','options' => $category,'id'=>'category','label' => false,'div' => false,'class' => 'form-control')); ?>
                     </div>
                     <div class="col-lg-5">
                       <!--blank div-->
                     </div>
                 </div>
             </div>
         </div>
     </div><!-- /.row -->
     <?php if(count($this->data['cat_memes'])){ ?>
	<?php foreach($this->data['cat_memes'] as $meme){ ?>
		<?php echo $this->Form->hidden('CatMeme.id',array('value'=>$meme['id'])); ?>
								
	<div class="row Slider" id="content">
		<div class="col-lg-8">
			<div class="col-lg-12">
				<div class="form-group form-spacing">
					<div class="col-lg-2 form-label">
						<label>Images</label>
					</div>
					<div class="col-lg-10 form-box">
					<script>
					$.fn.ready(function() {
						var act_img = '<?php echo configure::read('BASE_URL'); ?>/img/Cat_Meme/original/<?php echo $meme['image']; ?>';
						Meme(act_img, 'canvas', $('#top-line').val(), $('#bottom-line').val() ,  $('#center-line').val());
					});
					</script>
						<canvas id="canvas"></canvas>
						<?php echo $this->Form->input('CatMeme.image',array('type'=>'file','id'=>'uploadMeme','label' => false,'multiple'=>false,'div' => false)); ?>
					</div>
					<div class="col-lg-5"><!--blank div-->
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
						<label>Header Text</label>
					</div>
					<div class="col-lg-10 form-box">
						<?php echo $this->Form->input('CatMeme.header_caption',array('label' => false,'value'=>$meme['header_caption'],'div' => false,'id'=>'top-line', 'placeholder' => 'Header Text','class' => 'form-control','maxlength' => 100)); ?>
					</div>
					<div class="col-lg-5"><!--blank div-->
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
						<label>Footer Text</label>
					</div>
					<div class="col-lg-10 form-box">
						<?php echo $this->Form->input('CatMeme.footer_caption',array('label' => false,'value'=>$meme['footer_caption'],'div' => false,'id'=>'bottom-line',  'placeholder' => 'Footer Text','class' => 'form-control','maxlength' => 100)); ?>
					</div>
					<div class="col-lg-5"><!--blank div-->
					</div>
					</div>
				</div>
		</div>
	</div><!-- /.row -->
	<!--<div class="row">
		<div class="col-lg-8">
			<div class="col-lg-12">
				<div class="form-group form-spacing">
					<div class="col-lg-2 form-label">
						<label>Center Text</label>
					</div>
					<div class="col-lg-10 form-box">
						<?php // echo $this->Form->input('CatMeme.ceneter_caption',array('label' => false,'value'=>$meme['ceneter_caption'],'div' => false,'id'=>'center-line','placeholder' => 'Center Text','class' => 'form-control','maxlength' => 100)); ?>
					</div>
					<div class="col-lg-5"><!--blank div-->
					<!--</div>
					</div>
				</div>
		</div>
	</div><!-- /.row -->
		<?php } ?>
     <?php }else{ ?>
     <div class="fields">
     <div class="row Slider" id="content">
		<div class="col-lg-8">
			<div class="col-lg-12">
				<div class="form-group form-spacing">
					<div class="col-lg-2 form-label">
						<label>Images</label>
					</div>
					<div class="col-lg-10 form-box">
						<canvas id="canvas"></canvas>
						<?php echo $this->Form->input('CatMeme.image',array('type'=>'file','id'=>'uploadMeme','label' => false,'multiple'=>false,'div' => false)); ?>
					</div>
					<div class="col-lg-5"><!--blank div-->
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
						<label>Header Text</label>
					</div>
					<div class="col-lg-10 form-box">
						<?php echo $this->Form->input('CatMeme.header_caption',array('label' => false,'div' => false,'id'=>'top-line', 'placeholder' => 'Header Text','class' => 'form-control','maxlength' => 100)); ?>
					</div>
					<div class="col-lg-5"><!--blank div-->
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
						<label>Footer Text</label>
					</div>
					<div class="col-lg-10 form-box">
						<?php echo $this->Form->input('CatMeme.footer_caption',array('label' => false,'div' => false,'id'=>'bottom-line',  'placeholder' => 'Footer Text','class' => 'form-control','maxlength' => 100)); ?>
					</div>
					<div class="col-lg-5"><!--blank div-->
					</div>
					</div>
				</div>
		</div>
	</div><!-- /.row -->
	<!--<div class="row">
		<div class="col-lg-8">
			<div class="col-lg-12">
				<div class="form-group form-spacing">
					<div class="col-lg-2 form-label">
						<label>Center Text</label>
					</div>
					<div class="col-lg-10 form-box">
						<?php //echo $this->Form->input('CatMeme.ceneter_caption',array('label' => false,'div' => false,'id'=>'center-line','placeholder' => 'Center Text','class' => 'form-control','maxlength' => 100)); ?>
					</div>
					<div class="col-lg-5"><!--blank div-->
					<!--</div>
					</div>
				</div>
		</div>
	</div><!-- /.row -->
 
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
