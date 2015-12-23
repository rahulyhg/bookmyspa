    <?php 
    	echo $this->Html->script('ckeditor/ckeditor');
		echo $this->Html->script('quiz_category/slider');
	?>
		<div class="message"></div>
	<?php
		echo $this->Form->create(null, array('url' => array('controller' => 'contents', 'action' => 'addeditslider'),'id'=>'contentFormSlider','type' => 'file'));              
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
     <div class="fields">
     <div class="row" id="content">
         <div class="col-lg-8">        
             <div class="col-lg-12">
                 <div class="form-group form-spacing">
                     <div class="col-lg-2 form-label">
                         <label>Content</label>
                     </div>
                     <div class="col-lg-10 form-box">                
                         <?php echo $this->Form->input('content',array('id'=>'editor2','label' => false,'div' => false, 'placeholder' => 'Content','class' => 'ckeditor'));?>
							<script type="text/javascript">
								CKEDITOR.replace( 'editor2' );
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
   <?php if(count($this->data['cat_slides'])){  ?>
	<input type="hidden" value="<?php echo count($this->data['cat_slides'])+1; ?>" id="image_count" >
	<div class="row Slider" id="content">
		<div class="col-lg-8">
			<div class="col-lg-12">
				<div class="form-group form-spacing">
					<div class="col-lg-2 form-label">
						<label>Slider Images</label>
					</div>
					<div class="col-lg-10 form-box">
   <?php $i=1;
   foreach($this->data['cat_slides'] as $slides){ ?>
	<style>
		#imagePreview<?php echo $i; ?>{
		background-position: center center;
		background-size: cover;
		display: inline-block;
		height: 180px;
		margin-left: 10px;
		width: 180px;
	}
	</style>
	<div style="background-image: url('<?php echo configure::read('BASE_URL'); ?>/img/Cat_Sliders/thumb/<?php echo $slides['slide_img'] ;?>')" id="imagePreview<?php echo $i; ?>">
							<div data-image="<?php echo $slides['id']; ?>" id="<?php echo $i; ?>" class="remove">
									<a href="javascript:void(0)">X</a>
							</div>
						</div>
					
    <?php 	
		$i++;	
	} 
	?>
		<div id="imagePreview<?php echo count($this->data['cat_slides'])+1; ?>">
			<div id="<?php echo count($this->data['cat_slides'])+1; ?>" style="display:none;" class="remove">
					<a href="javascript:void(0)">X</a>
			</div>
		</div>
	<?php echo $this->Form->input('CatSlide.slide_img.',array('type'=>'file','id'=>'uploadFile','label' => false,'multiple'=>true,'max-uploads'=>'10','div' => false)); ?>
	
					</div>
					<div class="col-lg-5"><!--blank div-->
					</div>
					</div>
				</div>
		</div>
	</div><!-- /.row -->
  </div>

    <?php }else{ ?>
    <div class="row Slider" id="content">
		<div class="col-lg-8">
			<div class="col-lg-12">
				<div class="form-group form-spacing">
					<div class="col-lg-2 form-label">
						<label>Slider Images</label>
					</div>
					<div class="col-lg-10 form-box">
						<div id="imagePreview1">
						<input type="hidden" value="1" id="image_count" >
							<div id="1"  data-image="none" style="display:none;" class="remove">
									<a href="javascript:void(0)">X</a>
							</div>
						</div>
						<?php echo $this->Form->input('CatSlide.slide_img.',array('type'=>'file','id'=>'uploadFile','label' => false,'multiple'=>true,'max-uploads'=>'10','div' => false)); ?>
					
					</div>
					<div class="col-lg-5"><!--blank div-->
					</div>
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
