<?php echo $this->Html->script('frontend/star-rating.js?v=1'); ?>
<?php echo $this->Html->css('frontend/star-rating.css?v=1'); ?>
<div class="wrapper">
    <div class="container">
        <?php foreach($orders as $order) { //pr($order); die;?>
	    <div class="reviewer-section">
	        <div class="lft">
	            <div class="user-img">
	                <!--<img src="img/user-img.png" alt="" title="">-->
	                <?php
	                    if(isset($order['User']['image']) && !empty($order['User']['image']) ){
	                        echo $this->Html->image("/images/".$order['User']['id']."/User/150/".$order['User']['image'],array('data-id'=>$order['User']['id'],'class'=>'img-responsive'));
	                    }else{
	                        echo $this->Html->image("admin/upload2.png",array('class'=>'','data-id'=>$order['User']['id']));
	                    }?>
	            </div>
		    <div class="name"><?php echo $order['User']['first_name'].''. $order['User']['last_name']; ?></div>
		    <div class="add"><?php echo $this->common->getCity($order['Address']['city_id']); ?></div>
		    <ul>
		        <li><strong>Reviewer</strong></li>
		        <li><a href="#"><span class="reviewer-icon"></span> <?php echo $this->common->get_total_reviews_by_service($order['Appointment']['salon_service_id']); ?> Reviews</a></li>
		        <li><a href="#"><span class="helpful-icon "></span> <?php echo $this->common->get_helpful_count($order['Review']['id']).' '.'Helpful'; ?></a></li>
		    </ul>
		</div>
		<div class="rgt bod-btm-non">
		    <h3><?php echo $order['SalonService']['eng_name']; ?>
		        <span>Reviewed <?php echo date('d F Y',strtotime($order['ReviewRating']['created'])); ?></span>	
		    </h3>
		    <div class="rating-area">
		        <section>
			    
			    
			   
			    
			    <label>Venue:
			    
			    
	    <?php
		if(round($order['ReviewRating']['venue_rating'])!=''){ ?>
		   
			<?php for($m=1;$m<=5;$m++){
			    if($m>round($order['ReviewRating']['venue_rating'])){ ?>
				<i class="fa fa-star-o"></i>
			    <?php } else{ ?>
				<i class="fa fa-star"></i> 
			    <?php }   ?>
			<?php } ?>
		    
		<?php } ?>
			    
			</label>    
			    <?php //echo $this->Form->input('', array('div'=>false,'label' => '', 'class' => 'rating fa-star','type'=>'text','data-size'=>'','data-readonly'=>'true','data-show-clear'=>'false','data-show-caption'=>'false','glyphicon'=>false,'rating-class'=>'fa fa-star','value'=>$order['ReviewRating']['venue_rating'])); ?>
			    
			</section>
			<section>
			    <div class="stylist-rating">
			        <!--<img src="img/stylist1.jpg" alt="" title="">-->
			        <?php
			        if(isset($order['Provider']['image']) && !empty($order['Provider']['image']) ){
			            echo $this->Html->image("/images/".$order['Provider']['id']."/User/150/".$order['Provider']['image'],array('data-id'=>$order['Provider']['id'],'class'=>'img-responsive'));
			        }else{
			            echo $this->Html->image("admin/upload2.png",array('class'=>'','data-id'=>$order['Provider']['id']));
			        }?>
			        <span><?php echo $order['Provider']['first_name'].''. $order['Provider']['last_name']; ?> </span>
			        
				<span>
				    <?php
		if(round($order['ReviewRating']['staff_rating'])!=''){ ?>
		   
			<?php for($m=1;$m<=5;$m++){
			    if($m>round($order['ReviewRating']['staff_rating'])){ ?>
				<i class="fa fa-star-o"></i>
			    <?php } else{ ?>
				<i class="fa fa-star"></i> 
			    <?php }   ?>
			<?php } ?>
		    
		<?php } ?>
				</span>
				
				
				<span><?php //echo $this->Form->input('', array('div'=>false,'label' => '', 'class' => 'rating','data-size'=>'','type'=>'text','data-readonly'=>'true','data-show-clear'=>'false','data-show-caption'=>'false','glyphicon'=>false,'rating-class'=>'fa-star','value'=>$order['ReviewRating']['staff_rating'])); ?></span>
			    </div>
			</section>
		    </div>
		    <p><?php echo $order['ReviewRating']['venue_review']; ?></p>
		    <?php if($order['HelpfulReview']['id']==0 && !empty($loggedIn)){ ?>
		    <p>Was this really helpful?
			<button type="button" class="book-now helpful" data-userId='<?php echo $order['User']['id'];?>' data-reviewId='<?php echo $order['Review']['id'];?>'>Yes</button>
		    </p>
		    <?php } ?>
		    <div class="like-box"><!--<i class="fa fa-heart"></i> Like: +03--></div>
		    <label class="control-label">Add Comments:</label>
		    <?php echo $this->Form->input('review_comment',array('class'=>'form-control','id'=>'commentId','div'=>false,'label'=>false,'type'=>'textarea','value'=>'','style'=>'width:622px; height:100px;'));?>
		    <?php echo $this->Form->input('review_id',array('class'=>'form-control','id'=>'commentReviewId','div'=>false,'label'=>false,'type'=>'hidden','value'=>$order['Review']['id']));?>
		    <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary purple-btn submitComment','label'=>false,'div'=>false,'data'=>'login_val','data-uid'=>'reviewcomments'));?>
		    <?php  $comments=$this->common->fetch_comments_by_review($order['Review']['id']); ?>
		    <?php $i=1; ?>
		    <?php foreach($comments as $comment){ ?>
		        <?php if($i<=3){ ?>
			    <div class="reply-sec" style="margin-top:57px;">
				<div class="img-sec">
			            <?php
			            if(isset($comment['User']['image']) && !empty($comment['User']['image']) ){
			                echo $this->Html->image("/images/".$comment['User']['id']."/User/150/".$comment['User']['image'],array('data-id'=>$comment['User']['id'],'class'=>'img-responsive'));
			            }else{
			                echo $this->Html->image("admin/upload2.png",array('class'=>'img-responsive','data-id'=>$comment['User']['id']));
			            }?>
				    <span class="txt"><?php echo $comment['User']['first_name'].' '. $comment['User']['last_name']; ?></span>
				</div>
				<div class="rgt">
				    <p><?php  echo $comment['ReviewComment']['comment_text']; ?></p>
				</div>
			    </div>
			<?php $i++;
			}
		    } if($i>3){ ?>
			<div class="showMore" data-salonId='<?php echo $salonId; ?>' data-reviewId="<?php echo $order['ReviewRating']['id']; ?>" >Show more</div>
		    <?php } ?>
		</div>
	    </div>
        <?php } ?>
    </div>
</div>
<script>
    var $myModal = $(document).find('#myModal');
    $(document).ready(function(){
	$(document).find($(".submitComment").click(function() {
	    var commentText = $("#commentId").val();
	    if (commentText=='') {
		alert("Please add comment");
		return false;
	    }
	    var reviewId=$("#commentReviewId").val();
	    $(document).find( ".userLoginModal" ).trigger( "click" );
	    if (commentText) {
	        var getCommentURL = "<?php echo $this->Html->url(array('controller' => 'Reviews', 'action' => 'add_comment', 'admin' => false)); ?>";
	        $.ajax({
	            url: getCommentURL,
		    data:{commentText:commentText,reviewId:reviewId},
		    type: 'POST',
		    success: function(response) {
		       $(document).find( ".ReviewClass" ).trigger( "click" );
		    }
		});
	    }
	}));
	$(document).find($(".showMore").click(function() {
	    var reviewId = $(this).attr('data-reviewId');
	    var salonId = $(this).attr('data-salonId');
	    var addUserURL = "<?php echo $this->Html->url(array('controller'=>'Reviews','action'=>'showcomments','admin'=>false)); ?>";
	    addUserURL=addUserURL+'/'+salonId+'/'+reviewId;
	    fetchModal($myModal,addUserURL);
        }));
	
	
	$(document).find($(".helpful").click(function() {
	    //var commentText = $("#commentId").val();
	    //if (commentText=='') {
		//alert("Please add comment");
		//return false;
	    //}
	    //var reviewId=$("#commentReviewId").val();
	    //$(document).find( ".userLoginModal" ).trigger( "click" );
	    //if (commentText) {
	    var review_id=$(this).attr('data-reviewid');
	    var user_id=$(this).attr('data-userid');
	    //alert(order_id);
	        var getHelpURL = "<?php echo $this->Html->url(array('controller' => 'Reviews', 'action' => 'is_helpful', 'admin' => false)); ?>";
	        $.ajax({
	            url: getHelpURL,
		    data:{reviewId:review_id,userId:user_id},
		    type: 'POST',
		    success: function(response) {
		       $(document).find( ".ReviewClass" ).trigger( "click" );
		    }
		});
	   // }
	}));
	
	
	
	
    });
</script>
<style>
    .submitComment{
	margin-top:11px;
	
    }
    .showMore{
	cursor: pointer;
	float: right;
    }
</style>