<style>
.blog-arrow i.fa{
   font-size: 22px;
}
.massage1 .picture-space {
    border-radius: 5px 5px 0 0;
    height: 175px;
    width: 100%;
}
.p-l15 span {
    background: #5b3671 none repeat scroll 0 0;
    padding-left: 9px;
    padding-right: 3px;
}

.p-l15 > p {
    border-bottom: 2px solid #5b3671 !important;
    color: #fff;
    padding-bottom: 5px;
    margin-bottom: 22px;
    width: 98.7%;
}
</style>
<div class="big-rgt">
    <div class="blog-left-side">
   <?php //foreach($post_ids as $post_id){
   if(!empty($mainBlog)){
      $comments=$this->common->findCommentsByBlogID($mainBlog['Blog']['id']);
   ?>
    <h3 class="text-center m-bot10"><?php echo strtoupper($mainBlog['Blog']['eng_title']); ?></h3>
    	<div class="row">
        	<div class="col-sm-12">
            	<?php echo $this->Html->image('/../images/'.$mainBlog['Blog']['created_by'].'/Blog/original/'.$mainBlog['Blog']['image'],array('class'=>" ")); ?>
            </div>
        </div>
        <div class="row">
        	<div class="col-sm-12">
            	<div class="col-sm-4 blog-tab-1 border-r">
                	<span><i class="fa fa-clock-o"></i><?php echo date('d M Y',strtotime($mainBlog['Blog']['created'])); ?></span>
                </div>
                <div class="col-sm-4 blog-tab-1 border-r-l border-c">
                	<span><i class="fa fa-user"></i>Sieasta</span>
                </div>
                <div class="col-sm-4 blog-tab-1 border-l">
                	<span><i class="fa fa-comments-o"></i><?php echo count($comments); ?>  comments</span>
                </div>
            </div>
        </div>
        <div class="row">
        	<div class="col-sm-12">
		  <div class="pdng-tp20 pdng-bt40 brdr-btm1">
		  <?php echo $mainBlog['Blog']['eng_description']; ?>
		  </div>
		</div>
        </div>
        <div class="row">
        	<div class="col-sm-12">
            	<div class="blog-arrow">
                	<a href="javascript:void(0)"> <i class="fa fa-angle-double-down"> View and write comments</i></a>
                </div>
            </div>
        </div>
        
   <?php } ?>
   <div class="commentSection" style="display:none">
	
	<div class="row">
            <div class="col-sm-12">
            	<h3 class="text-center">COMMENTS</h3>
            </div>
        </div>
	<div class = 'blogComnt' >
	 <?php
	 
	 if(!empty($comments)){
	    foreach($comments as $comment) { ?>
                <div class="row">
                    <div class="col-sm-12 pdng-bt40 brdr-btm1">
                        <div class="col-sm-2">
                           <div class="blog-image">
                                <!--<img src="/img/dummy/user-img.png"/>-->
			        <?php
					if (filter_var($comment['User']['image'], FILTER_VALIDATE_URL) === FALSE) {
if(isset($comment['User']['image']) && !empty($comment['User']['image']) ){ 
						echo $this->Html->image("/images/".$comment['User']['id']."/User/150/".$comment['User']['image'],array('data-id'=>$comment['User']['id'],'class'=>'img-responsive'));
					    }else{
						echo $this->Html->image("admin/upload2.png",array('class'=>'','data-id'=>$comment['User']['id']));
					    }
		                            
		                        }else{
                                             echo $this->Html->image($comment['User']['image']);
					}
				?>
			   </div>
                        </div>
                        <div class="col-sm-10">
			    <div class="first-content pdng-bt30">
                                <span><strong><?php echo $comment['User']['first_name'].' '.$comment['User']['last_name']; ?></strong></span>
                                <p><?php echo date('d M Y,h.iA',strtotime($comment['BlogComment']['created'])); ?></p>
                                <p><?php echo $comment['BlogComment']['eng_comment']; ?> </p>
                            </div>
			</div>
		    </div>
                </div>
	    <?php } 
	 }else{
	    echo "<p class='noCmnt'>No comments added yet</p>.";
	    
	    } ?>
	 
         </div>
        <div class="row">
        	<div class="col-sm-12">
            	<h3 class="text-center">WRITE COMMENT</h3>
                <div class="col-sm-12 business">
    	<div class="well clearfix text-left">
			<div class="form-group">  
                <label>Write Comment</label>

               				<?php echo $this->Form->create('comment'); ?>
									<?php echo $this->Form->input('blog_comment',array('class'=>'form-control mrgn-btm15','id'=>'commentId','div'=>false,'label'=>false,'type'=>'textarea','value'=>'','style'=>''));?>
		    <?php echo $this->Form->input('blog_id',array('class'=>'form-control','id'=>'commentBlogId','div'=>false,'label'=>false,'type'=>'hidden','value'=>$mainBlog['Blog']['id']));?>
		    <?php echo $this->Form->button('POST',array('type'=>'button','class'=>'purple-btn pull-right submitComment','label'=>false,'div'=>false,'data'=>'login_val','data-uid'=>'reviewcomments','onClick'=>'sessionCheck(this)'));?>
									<?php echo $this->Form->end(); ?>
				
             </div>
        </div>
         
    </div>
            </div>
        </div>
       
 		
    </div>
   </div> 
    <div class="v-right-side">
    	<div class="add-heading">ADVERTISEMENTS</div>
		<?php if(count($banner_list)>0){ ?>
		<?php foreach($banner_list as $banner_list){ ?>
			<div class="advertisement"><?php echo $this->Html->Image('/images/'.$banner_list['SalonAd']['user_id'].'/SalonAd/800/'.$banner_list['SalonAd']['image']); ?></div>
		<?php } }else{
			echo "No Add Found"; }?>
	</div>
    
    
		<?php if(!empty($similarPosts)){ ?>
		 <div class="row">
        <div class="col-sm-12">
        	<!--<span style="float:right;"><a href="#">View all >></a></span>-->
            <h4 class="p-l15"><p><span>SIMILAR ARTICLES</span></p></h4>
            </div>
        </div>
		   <div class="row">
        	<div class="col-sm-12">
		<?php    foreach($similarPosts as $singlePost){
		  
		     $commentsSingle=$this->common->findCommentsByBlogID($singlePost['Blog']['id']);
		    
		  ?>
			<!--<div class="col-sm-3">
                            <div class="massage">
                                <div><?php echo $this->Html->image('/../images/'.$singlePost['Blog']['created_by'].'/Blog/50/'.$singlePost['Blog']['image'],array('class'=>" ")); ?>
                                </div>
                                <p class="p-text"><?php echo $singlePost['Blog']['eng_title']; ?>.</p>
                            </div>
                        </div>-->
                        
			
            	<div class="col-sm-4">
                	<div class="massage1">
                        <div class="picture-space">
                            <?php echo $this->Html->image('/../images/'.$singlePost['Blog']['created_by'].'/Blog/350/'.$singlePost['Blog']['image'],array('class'=>" ")); ?>
                        </div>
			
                        <p class="p-text1"><?php
			
			echo $this->Js->link($singlePost['Blog']['eng_title'],'/blogs/category/'.$category_id.'/'.$singlePost['Blog']['id'],array('update' => '#update_ajax','complete' => '$("html, body").animate({ scrollTop:75 }, "slow");'));?>.</p>
                        <div class="clearfix p-text1"><span class="text-l"><i class="fa fa-clock-o"></i>
<?php echo isset($singlePost['Blog']['created']) ? date('d M Y',strtotime($singlePost['Blog']['created'])) : '-'; ?></span><span class="text-r"><i class="fa fa-comments-o"></i>
<?php echo count($commentsSingle); ?> Comments</span></div>
            		</div>
                </div>
			
		  <?php } ?>
		  
		 
		  </div>
		   <nav class="pagi-nation col-sm-12 pull-right">
		  <?php if($this->Paginator->param('pageCount') > 1){
						    echo $this->element('pagination-blog');
						   // echo $this->Js->writeBuffer();
					    } ?>
		     </nav>
        </div>
	       <?php } ?> 	
		
          
</div>

   <script>
      $(document).ready(function(){
		 $(document).off('click','.submitComment').on('click','.submitComment',function() {
			var commentText = $("#commentId").val();
			if (commentText=='') {
			   alert("Please add comment");
			   return false;
			}
			var blogId=$("#commentBlogId").val();
			$(document).find( ".userLoginModal" ).trigger( "click" );
			if (commentText) {
			   var getCommentURL = "<?php echo $this->Html->url(array('controller' => 'blogs', 'action' => 'add_comment', 'admin' => false)); ?>";
	        $.ajax({
	           url: getCommentURL,
			   data:{comment:commentText,blog_id:blogId},
			   type: 'POST',
			   success: function(response) {
			     // alert(response);
			      if(response){
				 $('.blogComnt').append(response);
				 $('.noCmnt').remove();
				 $('#commentId').val('');
			      }else{
			       alert('Problem in saving the data');
			     }
			      //$(document).find( ".ReviewClass" ).trigger( "click" );
			   }
			});
		 }
	  });
		  $(document).off('click','.blog-arrow i').on('click','.blog-arrow i',function(e) {
		     e.preventDefault();
		     e.stopPropagation();
		    if($(this).hasClass('fa-angle-double-down')){
			$(".commentSection").fadeIn();
			$(this).removeClass("fa-angle-double-down");
			$(this).addClass("fa-angle-double-up");
		     }else if($(this).hasClass('fa-angle-double-up')){
			$(".commentSection").fadeOut();
			$(this).removeClass("fa-angle-double-up").addClass("fa-angle-double-down");
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
