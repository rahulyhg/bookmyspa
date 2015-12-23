<?php
//pr($this->Session->read('Auth.User')); 
$userId = $this->Session->read('Auth.User.id');
$image = $this->Session->read('Auth.User.image');
$username = $this->Session->read('Auth.User.username');
$email = $this->Session->read('Auth.User.email');
$name = $this->Session->read('Auth.User.first_name').' '.$this->Session->read('Auth.User.last_name');
$gender = $this->Session->read('Auth.UserDetail.gender');
$bio = $this->Session->read('Auth.UserDetail.bio');
?>


<div class="row">
    <div class="col-md-3">
       <?php echo $this->Html->image($this->Common->get_image($image,$userId ,'User')); ?> 
    </div>
     <div class="col-md-9">
       <form class="form-horizontal">
    <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
    <div class="col-sm-10">
      <?php echo $name; ?>
    </div>
  </div>       
           
    <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
      <?php echo $email; ?>
    </div>
  </div>
    <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Profile Name</label>
    <div class="col-sm-10">
      <?php echo $username; ?>
    </div>
  </div>            
    <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Gender</label>
    <div class="col-sm-10">
      <?php echo ($gender)?$gender:'---'; ?>
    </div>
  </div>
     <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Bio</label>
    <div class="col-sm-10">
      <?php echo ($bio)?$bio:'---'; ?>
    </div>
  </div>        
           
  
</form>
    </div>
</div>