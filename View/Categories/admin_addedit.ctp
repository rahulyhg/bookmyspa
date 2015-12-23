   <?php  echo $this->Html->script('admin/admin_category');?>    
   
   <div class="row">        
      <?php echo $this->Form->create(null, array('url' => array('controller' => 'categories', 'action' => 'addedit'),'id'=>'categoryId'));              
            echo $this->Form->hidden('Category.id',array('value'=>base64_encode($this->data['Category']['id']))); 
      ?>
      <div class="col-lg-5">           
      
         <div class="col-lg-12">
            <div class="form-group form-spacing">
               <div class="col-lg-4 form-label">
                  <label>Category Name<span class="required"> * </span></label>
               </div>
               <div class="col-lg-8 form-box">                
                  <?php echo $this->Form->input('category',array('type'=>'text','label' => false,'div' => false, 'placeholder' => 'Category Name','class' => 'form-control','maxlength' => 55));?>
               </div>
            </div>
         </div>
         <div class="col-lg-12">
            <div class="form-group form-spacing">
               <div class="col-lg-4 form-label">
                  <label>Parent Category</label>
               </div>
               <div class="col-lg-8 form-box">                
                  <?php echo $this->Form->input('parent_id',array('type'=>'select','options'=>$categories,'label' => false,'div' => false, 'empty' => 'Root','class' => 'form-control','value'=>$parentId));?>
               </div>
            </div>
         </div> 
         <div class="col-lg-12">
            <div class="form-group form-spacing">
               <div class="col-lg-4 form-label"> 
                  <label>Activate</label>
               </div>
               <div class="col-lg-8 form-box">  
                  <label class="checkbox-inline"><?php if(isset($this->request->data['Category']['status']) && $this->request->data['Category']['status'] == 0){  $checked= "";}else{  $checked= "checked";} ?>
                     <?php echo $this->Form->input('status',array('label' => false,'div' => false,'type '=> 'checkbox', 'checked' => $checked));?>
                  </label>
               </div>
            </div>
         </div>
         <div class="col-lg-12 form-spacing">
            <div class="col-lg-4">
               <!--blank Div-->
            </div>
            <div class="col-lg-8 form-box">
               <?php echo $this->Form->button($buttonText, array('type' => 'submit','class' => 'btn btn-default'));?>
               &nbsp;
               <?php echo $this->Form->button('Reset', array('type' => 'reset','class' => 'btn btn-default'));?>            
            </div>
         </div>
      </div>
      <?php echo $this->Form->end(); ?>
   </div><!-- /.row -->