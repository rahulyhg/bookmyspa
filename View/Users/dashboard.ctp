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
             if (filter_var($img, FILTER_VALIDATE_URL) === FALSE) {
                 echo $this->Html->image('avatar/'.$img);  
             }else{
                 echo "<img src=$img />";
             }
            ?>  </div>
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
        <div style="font-weight: bold; font-size: 14px;" class="text-right"><strong>Total Unpaid Amount:  </strong>&nbsp;$<?php echo $unpaid; ?></div>   
        </section>
        <section class="user-table-block">
          <div class="table-responsive">
            <table class="table table-bordered user-table">
              <thead>
                <tr>
                  <th width="20%"> Post Title</th>
                  <th width="10%"> Post Status</th>
                  <th width="15%"> User Type</th>
                  <th width="15%"> Views</th>
                  <th width="15%"> Revenue</th>
				  <th width="15%"> Unpaid</th>
                  <th width="25%">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($contents as  $getData){?>  
                <tr>
                  <td><?php $title =  isset($getData['PageView']['title']) ? substr($getData['PageView']['title'] ,0,200) : "";
                  
                  echo $this->Html->link( $title ,"/post/".$getData['PageView']['id'],array('escape' =>false, 'target' => '_blank'));
                  
                  ?></td>
                  <td><?php echo ($getData['PageView']['status'] == 1) ? 'Active' : "Inactive"; ?></td>
                  <td><?php echo ($getData['PageView']['content_user_id'] == $getData['PageView']['uid']) ? "Post Owner" : "Publisher"; ?></td>
                  <td><?php echo $getData['0']['user_view_count']; ?></td>
                  <td>$<?php echo number_format($getData['0']['user_revenue'], 2, '.', ''); ?></td>
		  <td>$<?php echo number_format($getData['0']['user_revenue'], 2, '.', ''); ?></td>
                  <td class="action-col">
                  <?php
                  echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pencil-square-o')),"/users/edit_post/".base64_encode($getData['PageView']['id']),array('escape' =>false, 'class' => "edit-btn editModal", 'id' => 'editModalid', 'enc_id' => base64_encode($getData['PageView']['id']), 'event_id' => $getData['PageView']['id']));
                  //echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pencil-square-o')),"#",array('escape' =>false, 'class' => "edit-btn editModal", 'id' => 'editModalid', 'event_id' => $getData['Content']['id']));
                  echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trash-o')),"/users/delete_post/".base64_encode($getData['PageView']['id']),array('escape' =>false, 'class' => "remove-btn"), "Are you sure you want to delete this post?");
                  ?>
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
      
<script>
    $(document).ready(function() {
      //$( "#toggle-sub-modal > #togle" ).toggle();
      $('.editModal').click(function(event){
        var event_id = $(this).attr("event_id");
        $(".postthumbs").html("");
        $(".postthumbs").html('<input name="data[Content][id]" type="hidden" value="'+event_id+'" id="content_id" /><input name="data[Content][post_type]" type="hidden" value="" id="post_type" />');
        
        $("#eventId").val(event_id);
        //$("#content_id").val(event_id);
        var enc_id = $(this).attr("enc_id");
        $.ajax({
          type: "POST",
          url: "/users/edit_post/"+enc_id,
          success: function(data) {
               if(data){
                  
                  $( ".tag" ).remove();
                  $(".postthumbs").append(data);
                  var post_title = $("#hidden_content_id").val();
                  $("#content_title").val(post_title);
                  //data-default
                  var tag_html = $("#hidden_tag").html();
                   
                   //alert(tag_html);
                   
                  //$.removeData($('.tagswdgt'), 'default');
                  //$('#tags_1_tag').data('data-default', '');
                  $("#tags_1_addTag").append(tag_html);
                  $(".postthumbs").attr("tabindex",-1).focus();
               }else{
                  
               }
          }
        });
        $("#add_open").html('<i class="fa fa-plus-circle"></i>Edit Post<i class="fa fa-caret-down"></i>');
        $( "#togle" ).hide();
        $( "#togle" ).toggle();
        //$('#defaultModal').on('hide', function() {
        // $('#defaultModal').unbind();
        //});
        
        //$('#editPostModal').modal({
        //  //remote: url,
        //  show: true,
        //  backdrop: 'static',
        //  keyboard: false
        //});
        event.preventDefault();
      });
      
      $('#add_open').click(function(event){
        //$("#content_id").val();
        $("#add_open").html('<i class="fa fa-plus-circle"></i>Create Post<i class="fa fa-caret-down"></i>');
        $(".postthumbs").html('<input name="data[Content][id]" type="hidden" value="" id="content_id" /><input name="data[Content][post_type]" type="hidden" value="" id="post_type" />');
        $("#content_title").val('');
        $(".editPosttag").remove();
        //$("#tags_1_tagsinput").html('');
      });	
    });	
</script>
    
    
<style>
/*.next{ font-size:13px;height:;margin-top: 0px}*/

</style>
    
    