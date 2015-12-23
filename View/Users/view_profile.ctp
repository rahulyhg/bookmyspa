<style>
    span.error {
    float: none;
    padding-left: 126px;
}
    
   </style>
   <div class="rowsession">
            <div class="col-lg-6">                        
                <?php echo $this->Session->flash();?>   
            </div> 
            <div class="col-lg-6">                        
                <div class="addbutton">                
                        View Profile
                </div>
            </div>
    </div>
  <div class="panel-body">
    <?php echo $this->Html->link(
    'Back to profile',
    array(
        'controller' => 'users',
        'action' => 'profile',
        'full_base' => false
    )
); ?>
            <div class="team_registerform">
            <div class="form-group">
                <div class="formlabel"><label>First Name</label> </div>              
                 <div class="forminput"><b><?php echo $user['User']['first_name']; ?></b></div>
            </div>
            <div class="form-group">
                <div class="formlabel"><label>Last Name</label></div>                 
                <div class="forminput"><?php echo $user['User']['last_name']; ?></div>
            </div>
            <div class="form-group">
                <div class="formlabel"><label>Email</label></div>                 
                 <div class="forminput"><?php echo $user['User']['email']; ?></div>
            </div>
            
            <div class="form-group">
                <div class="formlabel"><label>Date of Birth</label></div>   
                <div class="forminput"><?php echo $user['User']['dob']; ?></div>
            </div>
            
            <div class="form-group">
                <div class="formlabel"><label>Country</label></div> 
                <div class="forminput">
                        <?php echo $user['Country']['name']; ?>
                       
            </div>
	    <div class="form-group">
                <div class="formlabel"><label>Avatar Image</label></div> 
                <div class="forminput">
                  <?php if($user['User']['avatar_image']!='' && $user['User']['avatar_image']!=='type_error'){ 
                   echo $this->Html->image('avatar/'.$user['User']['avatar_image'], array('width' => '150' ,'height' => '150'));} ?>    	       
                </div>
            </div>
	    <div id="avatarPreview">
	    
	     
	    </div>
	    <div class="form-group">
                <div class="formlabel"><label>Cover Image </label></div> 
                <div class="forminput">
                  <?php if($user['User']['cover_image']!='' && $user['User']['cover_image']!=='type_error'){ 
                   echo $this->Html->image('cover/'.$user['User']['cover_image'], array('width' => '150' ,'height' => '150'));} ?>   
                </div>
            </div>
	    <div id="coverpreview"></div>
	      <div class="form-group">
                <div class="formlabel"><label>Bio</label></div> 
                <div class="forminput">
		<?php echo $user['User']['bio']; ?>
                </div>
            </div>
	     
	    </div>
	    
   
        
    </div><!-- /.row -->
    <style>
        .error-message{
            color: red;
            margin-left: 126px;
        }
    </style>
    