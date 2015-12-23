<div class="wrapper">
<div class="container">
    <div class="abt-gift-voucher">
    		<h2> <?php $lang =  Configure::read('Config.language');
			 echo __($blog['Blog'][$lang.'_title']); ?></h2>
            <div class="blog_wrapper">
            	<div class="inner_blog_wrapper no_border">
                	<div class="row">
                    	<div class="col-sm-3 photo_blog">
                        	  <?php
				    if($blog['Blog']['image'] != '')
                                   {
				      $uid = $blog['Blog']['created_by'];
				      $imagePath = '../images/'.$uid.'/Blog/350/'.$blog['Blog']['image'];
				      echo $this->Html->image($imagePath);
				    }
				   ?>
                        </div>
                        <div class="col-sm-9">
                        	<!--<h3> waterlillyspa Nunc risus erat, tristique sed arcu et..</h3>-->
			    <div class="row post_by">
				<div class="col-sm-3"><i class="fa fa-calendar"></i> &nbsp;<?php echo date(DATE_FORMAT,strtotime($blog['Blog']['created'])); ?></div>
			    </div>
                    		<p>
				 <?php echo __($blog['Blog']['eng_description']); ?>
				</p>
				
				<div class="widget-area blog_div">
				  <div class="status-upload">
				     <form>
				        <?php echo $this->Form->input('comment',array('data-blog_id'=>$blog['Blog']['id'],'type'=>'textarea','required'=>true,'label' => false,'div' => false, 'placeholder' => 'Comment','class' =>'form-control','maxlength' => 500 ,'name'=>'data[BlogComment][comment]','onClick'=>'sessionCheck(this)'));?>    
				        <button type="button" class="book-now comment">Post</button>
				    </form>
				    <div style="clear:both"></div>
				  </div>
			       </div>
			      <div class='description'> 
			        <?php foreach($comments as $comment){  ?> 
			        
                            <div class="comment_snapper">
                                <div class="col-sm-2">
                                    <div class="thumbnail">
					<?php echo $this->Html->image($this->Common->get_image_stylist($comment['User']['image'],$comment['User']['id'],'User'));  ?>
					<!--<img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">-->
                                    </div>
                                </div>
			       <div class="col-sm-10">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                        	<strong><?php echo __($comment['User']['first_name'].' '.$comment['User']['last_name']); ?></strong> <span class="text-muted">commented <?php echo __($this->common->getTimeDifference($comment['BlogComment']['created']));?></span>
                                        </div>
                                        <div class="panel-body">
					     <?php  echo __($comment['BlogComment'][$lang.'_comment']); ?>
				        </div><!-- /panel-body -->
                                     </div><!-- /panel panel-default -->
                               </div>
                            </div>
		  <?php }  ?>
		  </div>
                            <div style="clear:both"></div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
</div>   
<script>
 $(document).ready(function(){
  $('.comment').on('click' , function(){
   var  comment = $('#comment').val();
    var blog_id = $('#comment').data('blog_id');
   if(comment){
      $.ajax({
      type: "POST",
      url: "<?php echo $this->Html->url(array('controller'=>'blogs','action'=>'add_comment'));?>",
      data: { comment: comment ,blog_id:blog_id},
      success:function(response){
	 if(response){
	  $('.description').append(response);
	  $('#comment').val('');
	  }else{
	   alert('problem in saving the data');
	 }
      },
      });	 
      }else{
	 alert('Comment field is required!!');
	 }
  });
 });

 function sessionCheck(){
 var sess  =  $(document).find('.wel-usr-name').text();
	 if(!sess){
	   $(document).find('.userLoginModal').trigger('click');	  
	   return false;
	 }
 }
</script>
