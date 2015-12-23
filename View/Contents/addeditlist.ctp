    <?php 
		echo $this->Html->script('quiz_category/list');
	?>	
		<div class="message"></div>
	<?php
		echo $this->Form->create(null, array('url' => array('controller' => 'contents', 'action' => 'addeditlist'),'id'=>'contentFormList','type' => 'file'));              
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
<?php 
$count = count($this->data['cat_lists']);
if(count($this->data['cat_lists'])){ ?>
	 <div class="fields">
	 	<div class="row List" >
			
	 <?php echo $this->Form->hidden('CatList',array('value'=>$count,'id'=>'listcount')); ?>
	 
<?php $i=1; ?>	 
		<?php foreach($this->data['cat_lists'] as $catlist){ ?>
	<div id="list<?php echo $i; ?>" class="col-lg-8">
				<div class="col-lg-12">
					<div class="form-group form-spacing">
						<div class="col-lg-2 form-label">
							<label>Title Images</label>
						</div>
						<div class="col-lg-10 form-box">
							<div id="separater">
							<?php echo $this->Form->hidden('CatList.id.',array('value'=>$catlist['id'])); ?>
								 <?php echo $this->Form->input('CatList.img_title.',array('label' => false,'value'=>$catlist['img_title'], 'div' => false, 'placeholder' => 'Image Title'));?> &nbsp;	
								 <?php if($i == $count){ ?>
									<?php echo $this->Form->button('Add More', array('type' => 'button','id'=>"add_more" ,'class' => 'btn btn-default'));?> 
								 <?php	}else{ ?> 
									<?php echo $this->Form->button('Remove', array('type' => 'button','id'=>$catlist['id'],'class'=>"remove_list" ,'data-list'=>$i));?> 
									<?php } ?>	
							</div>
							<div class="col-lg-5"><!--blank div--></div>
							</div>
						</div>
					</div>
				</div> 
			<div class="row list<?php echo $i; ?>" id="content">
				<div class="col-lg-8">
					<div class="col-lg-12">
						<div class="form-group form-spacing">
							<div class="col-lg-2 form-label">
							<label><!--Blank Lable --></label>
						</div>
						<div class="col-lg-10 form-box">
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
							<div  style="background-image: url('<?php echo configure::read('BASE_URL'); ?>/img/Cat_List/thumb/<?php echo $catlist['image'] ;?>')" id="imagePreview<?php echo $i; ?>"></div>
								<?php echo $this->Form->input('CatList.image.',array('data-id'=>$i,'type'=>'file','label' => false,'class'=>'uploadFileList img','div' => false)); ?>
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
		</div>
	 </div>
<?php }else{ ?>
	 <div class="fields">
		<div class="row List" >
			<div id="list1" class="col-lg-8">
				<div class="col-lg-12">
					<div class="form-group form-spacing">
						<div class="col-lg-2 form-label">
							<label>Title Images</label>
						</div>
						<div class="col-lg-10 form-box">
							<div id="separater">
								<?php echo $this->Form->hidden('CatList',array('value'=>1,'id'=>'listcount')); ?>
								 <?php echo $this->Form->input('CatList.img_title.',array('label' => false,'div' => false, 'placeholder' => 'Image Title'));?> &nbsp; <?php echo $this->Form->button('Add More', array('type' => 'button','id'=>"add_more" ,'class' => 'btn btn-default'));?>
							</div>
							<div class="col-lg-5"><!--blank div--></div>
							</div>
						</div>
					</div>
				</div> 
			<div class="row list1" id="content">
				<div class="col-lg-8">
					<div class="col-lg-12">
						<div class="form-group form-spacing">
							<div class="col-lg-2 form-label">
							<label><!--Blank Lable --></label>
						</div>
						<div class="col-lg-10 form-box">
							<div id="imagePreview1"></div>
								<?php echo $this->Form->input('CatList.image.',array('data-id'=>'1','type'=>'file','label' => false,'class'=>'uploadFileList img','div' => false, 'placeholder' => 'Image Title')); ?>
							</div>
						</div>
					<div class="col-lg-5"><!--blank div--></div>
				</div>
			</div>
		</div>
		</div> 
	</div>
<?php }?>     
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
