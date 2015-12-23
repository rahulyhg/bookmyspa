   <?php
   echo $this->Html->css('calendar/jquery-ui');
   echo $this->Html->css('calendar/demos');
   echo $this->Html->script('admin/admin_users');
   echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js');
   echo $this->Html->script('calendar/jquery.ui.datepicker');
   ?>
   <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
     <script>
      $(document).ready(function() {
	 $(function() {
	    $( "#dob" ).datepicker({
		dateFormat: 'M d, yy',
	    changeMonth: true,
	    changeYear: true,
	    yearRange: "c-60:c+5"
	    });
	 });
      });
   </script>  
      <div class="row">
        <div class="col-lg-12">  
			<div id="imageError"></div>
             <?php echo $this->Session->flash();?>   
        </div>            
    </div>
    
   <div class="row">        
      <?php echo $this->Form->create(null, array('url' => array('controller' => 'users', 'action' => 'addedit'),'id'=>'userId', 'type'=>'file'));              
            echo $this->Form->hidden('User.id',array('value'=>isset($this->data['User']['id'])?base64_encode($this->data['User']['id']):''));           
      ?>
         <div class="col-lg-5">
           <div class="col-lg-12"><h3><u>Basic Information</u></h3></div>
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>First Name<span class="required"> * </span></label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->input('first_name',array('label' => false,'div' => false, 'placeholder' => 'First Name','class' => 'form-control','maxlength' => 55));?>
                  </div>
               </div>
            </div>
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>Last Name<span class="required"> * </span></label>
                  </div>
                  <div class="col-lg-8 form-box">                
                  <?php echo $this->Form->input('last_name',array('label' => false,'div' => false, 'placeholder' => 'Last Name','class' => 'form-control','maxlength' => 55));?>
                  </div>
               </div>
            </div>
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>Login Email<span class="required"> * </span></label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->input('email',array('label' => false,'div' => false, 'placeholder' => 'Email','class' => 'form-control','maxlength' => 55,'readonly' => ''));?>
                  </div>
               </div>
            </div>
            <?php if(!isset($this->request->data['User']['id']) && empty($this->request->data['User']['id'])){ ?>
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>Password<span class="required"> * </span></label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->input('password',array('type'=>'password','label' => false,'div' => false, 'placeholder' => 'Password','class' => 'form-control','maxlength' => 55,'readonly' => ''));?>
                  </div>
               </div>
            </div>
            <?php } ?>
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>Date of Birth</label>
                  </div>
                  <div class="col-lg-8 form-box" style="margin-top:5px;">                
                     <!--input name = "dob" type="text" id="dob" class = "form-control"  maxlength = "15" readonly = "readonly" /-->
		     <?php echo $this->Form->input('dob',array('type' => 'text', 'id'=>'dob', 'label' => false,'div' => false, 'placeholder' => 'DOB','class' => 'form-control','maxlength' => 15,'readonly' => 'readonly'));?>
                  </div>
               </div>
            </div>
            <div class="col-lg-12"><h3><u>Other Information</u></h3></div>
            
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>Country<span class="required"> * </span></label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->input('country_id',array('options'=>$country,'div'=>false,'label'=>false,'class'=>'form-control','empty'=>'Select Country')); ?>
		  </div>
               </div>
            </div>
            
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>Avatar Image</label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->input('avt_img',array("data-jid"=> "avatarPreview", 'type' => 'file', 'label' => false,'div' => false, 'class' => 'PreviewImage','maxlength' => 200));?>
		     <div id="avatarPreview"><?php
		     if(isset($userid)) {
			$strDeleteAvt = '<span style="cursor:pointer; color:#00f" class="delImage" onclick="deleteImg('.$userid.', \'avatar\');">Delete</span>';
			$strDeleteCov = '<span style="cursor:pointer; color:#00f" class="delImage" onclick="deleteImg('.$userid.', \'cover\');">Delete</span>';
		     }
		     echo (!empty($this->request->data['User']['avatar_image'])) ? $this->Html->image("avatar/".$this->request->data['User']['avatar_image'], array('alt' => '', 'class'=>'profileImg', 'width'=>'90', 'height'=>'90')) .$strDeleteAvt: ''; ?></div>
		  </div>
               </div>
            </div>
	    
	    <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>Cover Image</label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->input('cov_img',array("data-jid"=> "coverPreview", 'type' => 'file', 'label' => false,'div' => false,'class' => 'PreviewImage','maxlength' => 200));?>
		     <div id="coverPreview"><?php echo (!empty($this->request->data['User']['cover_image'])) ? $this->Html->image("cover/".$this->request->data['User']['cover_image'], array('alt' => '', 'class'=>'profileImg', 'width'=>'90', 'height'=>'90')) .$strDeleteCov: ''; ?></div>
		  </div>
               </div>
            </div>
	    
	    <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>Bio</label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->input('bio',array('label' => false,'div' => false, 'placeholder' => '','class' => 'form-control','cols' => '100', 'rows' => '5'));?>
                  </div>
               </div>
            </div>

            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label"> 
                     <label>Activate</label>
                  </div>
                  <div class="col-lg-8 form-box">  
                     <label class="checkbox-inline"><?php if(isset($this->request->data['User']['status']) && $this->request->data['User']['status'] == 0){  $checked= "";}else{  $checked= "checked";} ?>
                        <?php echo $this->Form->input('status',array('label' => false,'div' => false,'type '=> 'checkbox', 'checked' => $checked));?>
                     </label>
                  </div>
               </div>
            </div>      
            <div class="col-lg-12 form-spacing">
               <div class="col-lg-4"><!--blank Div--></div>
               <div class="col-lg-8 form-box">
                 <?php echo $this->Form->button($buttonText, array('type' => 'submit','class' => 'btn btn-default'));?>
                 &nbsp;
                 <?php echo $this->Form->button('Reset', array('type' => 'reset','class' => 'btn btn-default'));?>                 
               </div>
            </div>
         </div>   
      <?php echo $this->Form->end(); ?>           
   </div><!-- /.row -->
