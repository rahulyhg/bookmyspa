<script>
  $('document').ready(function(){            
        
	$(function() {
	$('#tags_edit_post').tagsInput({width:'auto',
        height:'auto' ,
        'interactive':true,
        autocomplete_url:'/homes/tags_json',
        autocomplete:{selectFirst:true,width:'100px',autoFill:true},
       });
        
        
  });});
</script>   
   
   
   
    <section class="container container-common edit-Post-popup">
    <!--Wrapper Start-->
    <section id="wrapper">
    <!--Content Start-->
    <section class="content">
      <!--dashboard Start-->
      <section class="dashboard-block">
        <section class="dashboard-head clearfix">
          <section class="user-dashboard-box">
            <div class="user-dashboard"><?php 
            $img = $this->Session->read('UserInfo.avatar_image');
            $name = $this->Session->read('UserInfo.first_name');
            $email = $this->Session->read('UserInfo.email');
	    $userType = $this->Session->read('UserInfo.user_type');
           // pr($this->Session->read('UserInfo'));
            echo $this->Html->image('avatar/'.$img); ?>  </div>
            <div class="user-title dropdown"> <a href="#" class="user-text dropdown-toggle" data-toggle="dropdown"> Hello <?php echo $name; ?>! <span class="caret"></span> </a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo BASE_URL.'users/profile_post'; ?>">Profile</a></li>
                <li><a href="mailto:<?php echo $email; ?>">Contact</a></li>
              </ul>
            </div>
          </section>
<section class="user-logout"> <a class="logout-link" href="<?php echo BASE_URL.'users/logout'; ?>"><i class="fa fa-sign-out"></i>
 logout</a> </section>
        </section>
        <section class="dashboard-nav clearfix">
          <ul>
            <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
			<li><a href="<?php echo BASE_URL.'users/profile_post'; ?>">Profile Post</a></li>
			<li><a href="<?php echo BASE_URL.'users/edit_profile'; ?>">Edit Profile</a></li>
			<li><a href="<?php echo BASE_URL.'users/transaction_history'; ?>">View Transactions</a></li>
			<?php if($userType !=1){
			  if (count(@$sent_req) && @$sent_req['Publisher']['status'] ==0) { ?>
			  <li><a href="javascript:void(0);">Pending request to become publisher</a></li>
			  <?php }else{ ?>
			  <li><a href="<?php echo BASE_URL.'users/sent_request_publisher'; ?>">Sent Request To Become Publisher</a></li>
			<?php }
			}?>
          </ul>
        </section>
        <section class="user-table-block">
          <div class="table-responsive">
            <table class="table table-bordered user-table">
              <thead>
                <tr>
                  <th width="10%"> Post Title</th>
                  <th width="30%"> User Type</th>
                  <th width="15%"> Transaction Amount</th>
                  <th width="25%">Date</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($transactions as  $getData){ ?>  
                <tr>
                  <td><?php echo isset($getData['Content']['title']) ? substr($getData['Content']['title'] ,0,200) : ""; ?></td>
                  <td><?php echo ($getData['Payment']['user_id'] == $getData['Content']['user_id']) ? "Post Owner" : "Publisher"; ?></td>
                  <td>$<?php echo number_format($getData['Payment']['amount'], 2, '.', ''); ?></td>
                  <td class="action-col">
                  <?php echo date('M j, Y', strtotime($getData['Payment']['created'])); ?>
                  </td>
                </tr>
                <?php } ?>
            </tbody>
            </table>
             <ul class="pagination">                
             <li class="disabled"><?php echo $this->Paginator->prev(' << ' . __(''),array(),null,array('class' => 'prev disabled'));?></li>
            <li><?php   echo $this->Paginator->numbers(array('separator' => ''));?></li>
            <li><?php   echo $this->Paginator->next(' >> ' . __(''),array(),null,array('class' => 'nxt disabled'));?></li>
</ul>
          </div>
        </section>
      </section>
      <!--dashboard Closed-->
    </section>
    <!--Content Closed-->
    
<?php //echo $this->element('edit_content_modal'); ?>

    