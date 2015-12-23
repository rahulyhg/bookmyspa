<?php
   echo $this->Html->script('admin/admin_photoupload');

?>
   
     <?php  echo $this->Form->create('GalleryPhoto', array('url' => array('controller' => 'settings', 'action' => 'photoupload'),'id'=>'galleryitemsAdd','type' => 'file')); 
          if(!empty($this->request->data)){	 
            echo $this->Form->hidden('GalleryPhoto.id',array('value'=>base64_encode($this->request->data['GalleryPhoto']['id'])));
            echo $this->Form->hidden('old_pic',array('value'=>$this->request->data['GalleryPhoto']['gallery_image']));
			}	
        ?>
           <div class="row">
        <div class="col-lg-12">                        
             <?php echo $this->Session->flash();?>   
        </div>            
    </div>
    
     <div class="row">
         <div class="col-lg-12">        
             <div class="col-lg-12">
                 <div class="form-group form-spacing">
                     <div class="col-lg-2 form-label">
                         <label>Image Name<span class="required"> * </span></label>
                     </div>
                     <div class="col-lg-5 form-box">                
                         <?php echo $this->Form->input('image_name',array('label' => false,'div' => false, 'placeholder' => 'Enter Image Name','class' => 'form-control','maxlength' => 55));?>
                     </div>
                     <div class="col-lg-5">
                       <!--blank div-->
                     </div>
                 </div>
             </div>
         </div>
     </div>
    
      <div class="row">
         <div class="col-lg-12">        
             <div class="col-lg-12" id="mainimgcontainer">
                 <div class="form-group form-spacing">
                     <div class="col-lg-2 form-label">
                         <label>Upload Image <span class="required"> * </span></label>
                     </div>
                     <div class="col-lg-4 form-label">
                        <?php if(isset($this->data['GalleryPhoto']['id']) && $this->data['GalleryPhoto']['id'] != ""){ $class= "";}else{ $class= "required"; }?>
                              <?php echo $this->Form->input('gallery_image',array('label' => false,'div' => false, 'type' => 'file','style' => 'display:inline-block !important','class'=>"upload $class" ));?>

                     </div>
                     <div class="col-lg-6" style="padding-bottom: 2px;">
                       <sub class="blue">1) Allowed file types: png, jpg, jpeg, gif <br/> 2) Minimum image upload size should be 137 x 110</sub>
                     </div>
                 </div>
             </div>
         </div>
     </div>

      <div class="row">
         <div class="col-lg-12">        
             <div class="col-lg-12">   
               <div class="form-group clearfix">
                  
                  <div class="col-lg-2 form-label">
                         <label>&nbsp;</label>
                     </div>
                  <div class="col-lg-10 form-box" style="padding-top:10px;">
                   <?php $imgC = 0;
                     if(!empty($this->data['GalleryPhoto'])) {
                       
                           $imageName = 'comments/thumb/'.$this->data['GalleryPhoto']['gallery_image'];                
                           if(file_exists(WWW_ROOT.'/img/'.$imageName) && !empty($this->data['GalleryPhoto']['gallery_image']))
                           {
                              echo "<div class='col-lg-3 padding_btm_20' >". $this->Html->image($imageName, array('class'=>'deldivimg'))."</div>";
                           }
                        
                       
                     }
                   ?>
                  </div>
               </div>            
            </div>
             <div class="col-lg-3"></div>
         </div>
     </div>
     
      <div class="col-lg-12 form-spacing">&nbsp;</div>
       
       <div class="col-lg-12">
           <div class="col-lg-12">
               <div class="col-lg-2">
                 <!--blank div-->
               </div>
               <div class="col-lg-10 form-box">
                   <?php echo $this->Form->button("Save", array('type' => 'submit','class' => 'btn btn-default'));?>
                    &nbsp;
                   <?php echo $this->Form->button('Reset', array('type' => 'reset','class' => 'btn btn-default'));?>
                   
               </div>
           </div>     
       </div>
      <div class="col-lg-12 form-spacing">&nbsp;</div>
     <?php echo $this->Form->end(); ?>
     </div>

     
     
     
     
