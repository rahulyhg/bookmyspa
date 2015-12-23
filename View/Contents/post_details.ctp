<script>
         $(document).ready(function(){
         $(".UploadCommentButton").ajaxUpload({
            url: "/Contents/insertCommentPhoto/",
            name: "file",
            onSubmit: function() {
                $('#commentajax_indicator').show();
                /*$('#commentajax_indicator').html('Uploading ... ');*/
            },
            onComplete: function(result) { //alert(result);
                $('#commentajax_indicator').hide();
                /*$('#commentajax_indicator').html('File uploaded with result' + result);*/
                $('#PostCommentCommentImage').val(result);
                $('#PostCommentImageType').val('File');
		$('#commentimagedivid').html('<img src="/img/comments/thumb/'+result+'" title="">');
                 $('.popover').hide();
				$('.post-comment-block').addClass('post-comment-block82');
            }
        });

     /*  sanjeev add reply  */
	 $('body').on('click','.replace_tec',function(){
	 //$(this).attr('click')
//          var  txt = $(this).data('tec');
//          new_txt = (txt=='reply')?'hide':'reply';
//          $(this).html('data',new_txt);
//          $(this).attr('data-tec',new_txt);
//          if(txt=='hide'){
//          $(this).parent().next().find('.removereplybox').html(''); 
//          }
//          $(this).html(new_txt); 
	 });
 
		$('.commentListId').hide();
		
		$('.tpopup').click(function(event) {
				$('#myloginModal').modal('toggle');
				//$(this).colorbox({iframe:true, width:"50%", height:"80%"});
				event.preventDefault();
		  });
		/*Selecting Gallery image Start*/
       jQuery('.avtar_widget').hide();
       jQuery('#avtar').click(function(){
				jQuery('.avtar_widget').toggle();
				jQuery('.avtars li').unbind('click');
				jQuery('.avtars li').click(function(){
					jQuery('#PostCommentCommentImage').val(jQuery(this).children().attr('src'));
					jQuery('#avtar').removeClass('avtar');
					jQuery('.av').remove();
					jQuery('#avtar').append('<img  class=av src='+jQuery(this).children().attr('src')+' />');
					jQuery('.avtar_widget').hide();
					$('#PostCommentImageType').val('Gallery');
				});
		});
    
    /*setting gallery prefilled in edit profile*/
    
    var img=jQuery('#PostCommentCommentImage').val();
    jQuery('#avtar').append('<img  class=av src=/img/view_gallery.png />');  
	
		 /*Selecting Gallery image End*/
		$('.home-slider').bxSlider({});
	
	       $('.right-photo-gallery').bxSlider({
            //autoReinitialise: true,
        });
		
		//slider prev-next start
		var slideCount = $('#slider ul li').length;
	var slideWidth = $('#slider ul li').width();
	var slideHeight = $('#slider ul li').height();
	var sliderUlWidth = slideCount * slideWidth;
    $('#slider ul li:last-child').prependTo('#slider ul');
	   function moveLeft(){
			$('#slider ul').animate({
				left: + slideWidth
			}, 400, function () {
				$('#slider ul li:last-child').prependTo('#slider ul');
				$('#slider ul').css('left', '');
			});
		};

		function moveRight() {
			$('#slider ul').animate({
				left: - slideWidth
			}, 400, function () {
				$('#slider ul li:first-child').appendTo('#slider ul');
				$('#slider ul').css('left', '');
			});
		};

		  $('a.control_prev').click(function () {
                          moveRight();
			});

		  $('a.control_next').click(function () {
			 moveLeft();	
			});
		//slider prev-next end
    });
    function setimageurl(imagee) {
        $('#PostCommentCommentImage').val(imagee);
        $('#PostCommentImageType').val('URL');
    }
    function savecomment(commentid){ 
        var cnt = <?php echo $allpostcounts; ?>;
        var pct = $('#PostCommentComment').val();
        if (pct == 'Post Your Comment') {
            alert('Please Enter the Comment.');
            return false;
        }

        $.ajax({
            type: "POST",
            url: "/contents/ajaxpostcomment/",
            data: $("#PostCommentPostDetailsForm").serialize(),
            success: function(sdata) { //alert(sdata);
                cnt = cnt + 1;
				commentid = commentid + 1; 
                $('#allusercomment').html(sdata);
                $('#PostCommentComment').val('Post Your Comment');
                $('#totalcnt').html(cnt);
                $('.textfild').val('');
                $('#PostCommentCommentImage').val('');
                $('#PostCommentImageType').val('');
				 $('.popover').hide();
				 $("#PostCommentParentId").val('');
				 //$( '#commnet'+commentid).focus();
				 $('#licomment'+commentid).last();
				 //$( '#licomment'+commentid).focus();
				 $('#commentimagedivid').html(''); 
				  $('.post-comment-block').removeClass('post-comment-block82');
				 
            }
        });
    }
    function photopop(numberss) {
        if (numberss == 1) {
            $('.popover-gallery1').toggle();
        } else {
            $('.popover-gallery1').hide();
        }
    }
	function showallcoments(){
	$('.commentListId').toggle();
	}
    function fbs_click(width, height) {
    var leftPosition, topPosition;
    //Allow for borders.
    leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
    //Allow for title and status bars.
    topPosition = (window.screen.height / 2) - ((height / 2) + 50);
    var windowFeatures = "status=no,height=" + height + ",width=" + width + ",resizable=yes,left=" + leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY=" + topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no";
    u=location.href;
    t=document.title;
    window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer', windowFeatures);
    return false;
    }

	
	$(document).ready(function(){
	//function toggleDiv(divId) {
	   //alert('123');
	   //$('.toggleDiv').colorbox({href:'#avatarGallery',inline:true, width:"50%"});
	   // Called directly with HTML
		 var theSid = "";
		 $(document).on('click','.toggleDiv',function(){
			theSid = $(this).attr('rel');
			$('#mygallery').modal('toggle');
			photopop(2);commentphotopop(2);
			//$.colorbox({html:showHtml,width:'50%',height:'80%'});
			
		});
		 
		$(document).on('click','.popImage',function(){
				if(theSid == ""){
					var src = $(this).attr('src');
					$('#PostCommentCommentImage').val(src);
		            $('#PostCommentImageType').val('File');
					$('#commentimagedivid').html('<img src="'+src+'" title="">');
					//photopop(2);
					//$.colorbox.close();
					
				}
				else{
					var src = $(this).attr('src');
					$('#PostCommentCommentImage'+theSid).val(src);
                                        $('#PostCommentImageType'+theSid).val('File');
					$('#commentimagedivid'+theSid).html('<img src="'+src+'" title="">');
				}
				$('.post-comment-block').addClass('post-comment-block82');
				$('#mygallery').modal('toggle');
				
		})
	   //$("#"+divId).toggle();
	//}
	/*function replypost(pid){ 
		$("#PostCommentComment").focus();
		$("#PostCommentParentId").val(pid);
		$("#PostCommentComment").val('');
		
	}*/
	});
	function likedislikecomment(lik,dislk,cid,pcid){
		$.ajax({
            type: "POST",
            url: "/contents/ajaxcommentlikedislike/",
           data	 : { 'like': lik,'dislike': dislk,'comment_id': cid,'post_comment_id': pcid},
            success: function(sdata) { 
               var myObject = eval('(' + sdata + ')');
				  //alert(myObject[0]);
				  //alert(myObject[0]);
				  $('#likecomment'+cid).html(myObject[1]);     
				  $('#dislikecomment'+cid).html(myObject[2]); 
				    
            }
        });
	}
	function commentimageuploading(id){
		$("#UploadCommentButton"+id).ajaxUpload({
            url: "/Contents/insertCommentPhoto/",
            name: "file",
            onSubmit: function() {
                $('#commentajax_indicator').show();
                /*$('#commentajax_indicator').html('Uploading ... ');*/
            },
            onComplete: function(result) { //alert(result);
                $('#commentajax_indicator'+id).hide();
                /*$('#commentajax_indicator').html('File uploaded with result' + result);*/
                $('#PostCommentCommentImage'+id).val(result);
                $('#PostCommentImageType'+id).val('File');
				$('#commentimagedivid'+id).html('<img src="/img/comments/thumb/'+result+'" title="">');
                $('.popover').hide();
				$('.post-comment-block').addClass('post-comment-block82');
				
            }
        });
	
	}
	function savepopupcomment(id,cid) { //alert(id);
        var cnt = <?php echo $allpostcounts; ?>;
        var pct = $('#PostCommentComment'+id).val();
        if (pct == 'Post Your Comment') {
            alert('Please Enter the Comment.');
            return false;
        }

        $.ajax({
            type: "POST",
            url: "/contents/ajaxpostcomment/",
            data: $("#PostCommentPostDetailsForm"+id).serialize(),
            success: function(sdata) { //alert(sdata);
                cnt = cnt + 1;
                $('#allusercomment').html(sdata);
                $('#PostCommentComment'+id).val('Post Your Comment');
                $('#totalcnt').html(cnt);
                $('.textfild'+id).val('');
                $('#PostCommentCommentImage'+id).val('');
                $('#PostCommentImageType'+id).val('');
				 $('.cpopover'+id).hide();
				 $("#PostCommentParentId"+id).val('');
				 $("html, body").scrollTop($('#commnet'+cid).offset().top);
				 //window.location.hash = '#commnet'+cid;
				  //$('#licomment'+id).last('#commnet'+id).focus();
            }
        });
    }
	function savepollpreview(pollID,pollqtnID,pollansID){
		
            $.ajax({
            type: "POST",
            url: "/contents/ajaxpollpreviewresult/",
            data : { 'poll_id': pollID,'poll_questions_id': pollqtnID,'poll_answer_id': pollansID},
            success: function(sdata){ 
				$('#totalpollans'+pollansID).html(sdata);
				$('.pollpercentages').show();
				$('.vote_btn').hide();
				$('.transition').removeAttr('onclick');
            }
        });
	
	}
	
	function showquizpreview(qtnID,quizID){
        $.ajax({
            type: "POST",
            url: "/contents/ajaxquizpreviewresult/",
           data	 : { 'quiz_id': quizID,'quiz_questions_id': qtnID},
            success: function(sdata) { 
				$('#quizpreviewdivid').html(sdata);
				$(this).css({"background-color":"#559ebf","color":"#fff"});
            }
        });
	
	}
	function savepreviewresult(quizID,qtnID,ansID,lastqID){
		 //var qscurentCount = $("#quiz_slider ul li").last('li').find('a').text(); 
		 //alert(lastID);
        $.ajax({
            type: "POST",
            url: "/contents/ajaxquizpreviewanswer/",
           data	 : { 'quiz_id': quizID,'quiz_questions_id': qtnID,'quiz_answer_id': ansID},
            success: function(sdata) { 
			    var myObject = eval('(' + sdata + ')');
				if(myObject[0]==myObject[1]){
				 $('#quizanswer'+ myObject[0]).addClass('right-ans');
				}else{
				 $('#quizanswer'+ myObject[0]).addClass('right-ans');
				 $('#quizanswer'+ myObject[1]).addClass('wrong-ans');
				}
				if(lastqID !=qtnID){
					setTimeout(showquizpreview(myObject[2],quizID),80000);
				}
				
            }
        });
	}
	
</script>

 <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!--  <div class="fb-post" data-href="https://www.facebook.com/video.php?v=665365073583644" data-width="500"></div>-->
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>


<div class="modal fade" id="mygallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Choose from gallery</h4>
      </div>
	  <div class="panel-body login-min-height">
	  
	  <section class="avtar_widget_gallery">
		<section class="av_top"></section>
		  <section class="av_middle" >
			<ul class="avtars">
                  <?php $allgalleryphotos = $this->Common->getAllGalleryImages();
					 if(!empty($allgalleryphotos)){
					   foreach($allgalleryphotos as $datas){ 
								$image_name = $datas['GalleryPhoto']['gallery_image'];
								 echo '<li><img  class="popImage" src=/img/comments/thumb/'.$image_name.'></li>';
						}	
					 }	 
					 ?>
							 </ul>
		  
		  
		</section>
		<section class="av_bottom"></section>
	    </section>
	  </div>
	</div>			
</div>
</div>

    <!--Wrapper Start-->
    <section id="wrapper">
	<?php  $userId = $this->Session->read('UserInfo.id');?>
        <!--Content Start-->
        <section class="content">
            <section class="row">
                <!--Left Start-->
                <section class="col-sm-12 col-md-8">
                    <h2 class="heading"><?php echo $content['Content']['title'];?>
					
					<div class="heading-img-gallery">
						<ul>
						 <?php //$indexvalue = array_unique($indexvalue);
						   foreach($indexvalue as $dataa){ //debug($dataa);
						   if ($dataa == "Photo"){?>
							<li><i class="fa fa-photo ph-col mrgrtnone" style=""></i></li>
						 <?php }else if($dataa =="Video"){?>	
							<li><i class="fa fa-video-camera gr-col mrgrtnone"></i></li>
							<?php }else if($dataa == "Slide"){?>
							<li><i class="fa fa-sliders mrgrtnone"></i></li>
							<?php }else if($dataa == "Meme"){?>
							<li><img alt="" src="/img/home/icons/meme.png" title=""></li>
							<?php }else if($dataa == "ContentList"){?>
							<li><i class="fa fa-th-list mrgrtnone bl-col"></i></li>
							<?php }else if($dataa == "Quiz"){?>
							<li><i class="fa fa-question-circle orng-col mrgrtnone"></i></li>
							<?php }else if($dataa == "Poll"){?>
							<li><i class="fa fa-bar-chart-o grn-col mrgrtnone"></i></li>
							<?php }else if($dataa == "Lineup"){?>
							<li><img alt="" src="/img/home/icons/lineup.png" title=""></li>
							<?php } } ?>
						</ul>
					</div>
					</h2>
                    <!-- Post Share Row Start-->
                    <section class="col-lg-12 postrow">
                        <section class="row">
                            <section class="col-lg-4 p-t">
                                <span class="userpic">
                                    <?php   if(!empty($users['User']['avatar_image'])){
                                            $img = $users['User']['avatar_image'];
                                             if (filter_var($users['User']['avatar_image'], FILTER_VALIDATE_URL) === FALSE) {
                                                  echo $this->Html->image('/img/avatar/' . $users['User']['avatar_image']);
                                                }else{
                                                    echo '<img src='.$img.' />';
                                                }
					   }else{
					echo $this->Html->image('avatar/no_image.png');
					}     ?>   
                                </span>
                                <span class="post-time">
									<strong>
                                        <?php
											if (!empty($users)) {
												echo $users['User']['first_name'];
											}
                             ?>
									</strong> 
                                    <?php                                       if(!empty($creatd)){
										$creatd = $content['Content']['created'];
										$new_date = date('Y-m-d h:i:s');
										$date1 = new DateTime(date('Y-m-d', strtotime($creatd)));
										$date2 = new DateTime(date('Y-m-d', strtotime($new_date)));
										$num_day = $date1->diff($date2)->days;
										if ($num_day == '0') {
											echo ' Today';
										} else if ($num_day == '1') {
											echo ' ' . $num_day . ' day ago';
										} else {
											echo ' ' . $num_day . ' days ago';
                                    }}
								?>
                                </span>
                            </section><!-- / col-lg-4 -->
			    <?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
                            <section class="col-lg-8 col-sm-12">
                                     <ul class="sharetags pull-right liststyle-none mobile-left">
                                    <li><span><a href="http://www.facebook.com/share.php?u=<?php echo $actual_link;?>" onClick="return fbs_click(575, 400)" target="_blank" title="Share This on Facebook"><img src="/img/f-share.png" alt="facebook share"></a></span></li>
                                    <li><span><a class="twitter tpopup" href="http://twitter.com/share?text=<?php echo $content['Content']['title'];?>"><img src="/img/tw-share.png" alt="Twitter Share"></a></span></li>
                                    <li><span><a href="http://www.reddit.com/submit" onclick="window.open('http://www.reddit.com/submit? v=5&noui&jump=close&url='+encodeURIComponent (location.href)+'&title='+encodeURIComponent (document.title), 'delicious','toolbar=no, width=575,height=400'); return false;"> <img src="/img/rd-share.png" alt="Reddit Share"/></a></span></li>
                                    <li><i style="margin-top: 8px;" class="fa fa-eye fa-lg">&nbsp;<?php echo $count_page_view;?></i></li>
                                    <!-- <li class="total-views"><a href="javascript:void(0)"></a></li> -->
                                </ul>
                           </section><!-- / col-lg-8 -->
                        </section>          
                    </section>
					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- footybase1 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-2247586710150023"
     data-ad-slot="8549632007"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
					<!--Post Text Start-->
                              <?php echo $this->element('post'); ?>
					<!--Post Poll Section End Here-->
					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- footybase2 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-2247586710150023"
     data-ad-slot="5316964004"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

                    <!--Bottom Section Start-->
                    <section class="row">
                        <section class="col-lg-12 video-add">
						 <?php  $alltags = $this->Common->getTagByPost($tagIDs); if(!empty($alltags)){?>
                            <section class="tagswdgt tagswdgt-post">
                                <label>Tags:</label>
                                <section class="tagslst clearfix">
                                    <?php
									 foreach ($alltags as $alltag){
										$tag_name = ucfirst($alltag['Tag']['tag_name']);
										$tagId = $alltag['Tag']['id'];
										//echo $this->Html->link($tag_name, array('controller' => 'contents', 'action' => 'tag_contents', $tagId));
										?>
										<a href="<?php echo BASE_URL.'tag/'.$tag_name?>"><?php echo $tag_name;?></a>
										<?php } ?>
                                </section>
                            </section><!--/ Tags-->
							<?php } ?>
                            <div class="clearfix"></div>
                           <?php
                            $logedin_user = $this->Session->read('UserInfo.user_type');
                            
			    if($logedin_user=='1' && ($content['Content']['user_id'] != $this->Session->read('UserInfo.id'))){  ?>
                                    <section class="tagswdgt tagswdgt-post">
                                    <label style="width:65px;">Share Url:</label>
                                    <section class="tagslst clearfix">
                                    <strong> &nbsp;&nbsp; <?php
                                    $logedin_id = base64_encode($this->Session->read('UserInfo.id'));
                                    $tagurl=Router::url( $this->here.'/?uid='.$logedin_id,true); 
												echo $this->Form->textarea('textarea',array('rows'=>'1','cols'=>'58','value'=>$tagurl,'style'=>'resize:none','onclick'=>"this.focus();this.select()", 'readonly'=>"readonly"));
                                    ?></strong>
                                    </section>
                                    </section>
                            <?php } ?>
                            <section class="comments-widget">
                                <h2 class="head">Comments</h2>
                                <ul class="user-comment-row" id="allusercomment">
								<?php if (!empty($allpostcomments)){  $i=1; 
										foreach ($allpostcomments as $allpostcmnt) { 
										$usrid = $allpostcmnt['PostComment']['user_id']; 
										$parentids = $allpostcmnt['PostComment']['id'];
										$postid = $allpostcmnt['PostComment']['content_id'];
										$user = $this->Common->getauser($usrid);
										$totalpostcommentlike=$this->Common->getAlllikeDislikecomment($parentids); 
										$totalpostcommentlike=explode(',',$totalpostcommentlike);
										$like=$totalpostcommentlike[0];
										$dislike=$totalpostcommentlike[1];
										if($i == 1 || $i == 2 || $i == 3 || $i == 4 || $i == 5){ $newclass='';}
										else{$newclass='commentListId';}?> 
                                                                        <li class="<?php echo $newclass;?>">
									<section class="user-comment-head clearfix">
									<?php if(empty($allpostcmnt['PostComment']['parent_id'])){?>
										<section class="col-sm-9 postrow">
											<span class="userpic">
									  <?php
										   if(!empty($user['User']['avatar_image'])){
											   $img = $user['User']['avatar_image'];
												if (filter_var($user['User']['avatar_image'], FILTER_VALIDATE_URL) === FALSE) {
													   echo $this->Html->image('avatar/'.$img,array('url' => array('controller' => 'users', 'action' => 'profile_post',$users['User']['id'] )));  
												   }else{
													   echo $this->Html->image($img,array('url' => array('controller' => 'users', 'action' => 'profile_post',$users['User']['id'] )));  
												   }
										   //echo $this->Html->image('avatar/'.$users['User']['avatar_image'],array('height'=>'103', 'width'=>'103'));
										   }else{
										   echo $this->Html->image('avatar/no_image.png',array('url' => array('controller' => 'users', 'action' => 'profile_post',$user['User']['id'] )));
										   }
										   ?>   
											</span>
											<span class="post-time"><a href="<?php echo BASE_URL.'users/profile_post/'.$usrid?>"><strong><?php echo $user['User']['username']; ?></strong></a></span>
											<!--span class="comment-on"><strong>Quis Exercitation </strong> </span-->
										</section>
										<section class="col-sm-3 postrow">
											<section class="comment-date">
											<?php            $creatd = $allpostcmnt['PostComment']['created']; $new_date = date('Y-m-d h:i:s');
													 $date1 = new DateTime(date('Y-m-d', strtotime($creatd)));
													  $date2 = new DateTime(date('Y-m-d', strtotime($new_date)));
													  $num_day=$date1->diff($date2)->days; 
													  if($num_day == '0'){ echo 'Today';}
													  else if($num_day == '1'){ echo $num_day.' day ago';}
													  else{echo $num_day.' days ago';}
												?>
											</section>
										</section>
									
									</section>
									<section class="user-comment-box">
										<section class="user-comment-txt">
										<?php
												if (!empty($allpostcmnt['PostComment']['comment_image']) && ($allpostcmnt['PostComment']['image_type'] == 'File')) {
													echo '<img width="125" src="'.$allpostcmnt['PostComment']['comment_image'].'"
															 onmouseover=this.src="'.$allpostcmnt['PostComment']['comment_image'].'"
															 onmouseout=this.src="'.$allpostcmnt['PostComment']['comment_image'].'">
														</img>';
												} else if (!empty($allpostcmnt['PostComment']['comment_image']) && ($allpostcmnt['PostComment']['image_type'] == 'Gallery')) { 
												   $image_name=$allpostcmnt['PostComment']['comment_image'];
                                        $filename = basename($image_name); 
												   //preg_match('/src="([^"]+)"/',$image_name, $match); 
													echo '<img width="125" src="'.$image_name.'"
															 onmouseover=this.src="/img/photos/original/'.$filename.'"
															 onmouseout=this.src="'.$image_name.'">
														</img>';
												}else{
													echo '';
												}
                                ?>
											<p>
											<?php
												if (!empty($allpostcmnt['PostComment']['comments'])) {
													echo $allpostcmnt['PostComment']['comments'];
												} else {
													echo'';
												}
												?>
											</p>
										</section>
										<section class="user-reply">
											<span class="reply-text">
											<?php if(!empty($userId)){?>
												<a href="javascript:void(0)" onclick="addcommentbox(<?php echo $postid.','.$parentids.','.$parentids.','.$lastcommentid;?>),$(this).hide(); $(this).next('a').show();$('.replybox<?php echo $parentids;?>').show()">Reply</a>
												<a href="javascript:void(0)" style="display:none" onclick="$('.replybox<?php echo $parentids;?>').find('form').remove();$(this).prev('a').show();$(this).hide();">Hide</a>
												<?php }else{ ?>
												 <a class="tpopup" href="/contents/user_login">Reply</a>
												<?php } ?>
											</span>
											<span class="reply-icon">
												<a class="like-icn" href="javascript:void(0)" onclick="likedislikecomment(1,0,<?php echo $parentids.','.$postid;?>)"></a><span id="likecomment<?php echo $parentids;?>"><?php echo $like;?></span>&nbsp;&nbsp;&nbsp;&nbsp;
												<a class="dislike-icn" href="javascript:void(0)" onclick="likedislikecomment(0,1,<?php echo $parentids.','.$postid;?>)"></a><span id="dislikecomment<?php echo $parentids;?>"><?php echo $dislike;?></span>
											</span>
											<section class="removereplybox replybox<?php echo $parentids;?>"></section>
										</section>
											<?php } ?>
										<?php $childpost=$this->Common->getAllChildPost($allpostcmnt['PostComment']['id']);
										if(!empty($childpost)){ $subp = 1; 
										foreach($childpost as $child){ 
										$usrid = $child['PostComment']['user_id'];
										$parentid = $child['PostComment']['id'];
										$postid = $child['PostComment']['content_id'];
										
										$totalpostcomment=$this->Common->getAlllikeDislikecomment($parentid); 
										$totalpostcomment=explode(',',$totalpostcomment);
										$like=$totalpostcomment[0];
										$dislike=$totalpostcomment[1];
										
										$user = $this->Common->getauser($usrid);
										if($subp == 1 || $subp == 2 || $subp == 3 || $subp == 4 || $subp == 5){ $newclass='';}
										else{$newclass='commentListId';}
										?>
										
										
										
										<section class="user-comment-box2 <?php echo $newclass;?>">
											<section class="user-comment-head clearfix">
											<section class="col-lg-9 postrow">
												<span class="userpic">
                                                                                                      <?php
                                                               if(!empty($user['User']['avatar_image'])){
                                                                   $img = $user['User']['avatar_image'];
                                                                    if (filter_var($user['User']['avatar_image'], FILTER_VALIDATE_URL) === FALSE) {
                                                                           echo $this->Html->image('avatar/'.$img,array('url' => array('controller' => 'users', 'action' => 'profile_post',$user['User']['id'] )));  
                                                                       }else{
                                                                           echo $this->Html->image($img,array('url' => array('controller' => 'users', 'action' => 'profile_post',$user['User']['id'] )));  
                                                                       }
                                                               //echo $this->Html->image('avatar/'.$user['User']['avatar_image'],array('height'=>'103', 'width'=>'103'));
                                                               }else{
                                                               echo $this->Html->image('avatar/no_image.png',array('url' => array('controller' => 'users', 'action' => 'profile_post',$user['User']['id'] )));
                                                               }
                                                               ?>   
                                                                                                    
												</span>
												<span class="post-time"><a href="<?php echo BASE_URL.'users/profile_post/'.$usrid ; ?>"><strong><?php echo $user['User']['username']; ?></strong></a></span>
											</section>
											<section class="col-lg-3 postrow">
												<section class="comment-date">
											<?php $creatd = $child['PostComment']['created']; $new_date = date('Y-m-d h:i:s');
													 $date1 = new DateTime(date('Y-m-d', strtotime($creatd)));
													  $date2 = new DateTime(date('Y-m-d', strtotime($new_date)));
													  $num_day=$date1->diff($date2)->days; 
													  if($num_day == '0'){ echo 'Today';}
													  else if($num_day == '1'){ echo $num_day.' day ago';}
													  else{echo $num_day.' days ago';}
												?>
												</section>
											</section>
										</section>
											<section class="user-comment-txt">
											<?php
												if (!empty($child['PostComment']['comment_image']) && ($child['PostComment']['image_type'] == 'File')) {
													echo '<img src="'.$child['PostComment']['comment_image'].'"
															 onmouseover=this.src="'.$child['PostComment']['comment_image'].'"
															 onmouseout=this.src="'.$child['PostComment']['comment_image'].'">
														</img>';
												} else if (!empty($child['PostComment']['comment_image']) && ($child['PostComment']['image_type'] == 'Gallery')) { 
												$image_name=$child['PostComment']['comment_image'];
													  $filename = basename($image_name);  
													 echo '<img src="'.$image_name.'"
															 onmouseover=this.src="/img/photos/original/'.$filename.'"
															 onmouseout=this.src="'.$image_name.'">
														</img>';
												}else{
													echo '';
												}
                                ?>
											<p><?php
												if (!empty($child['PostComment']['comments'])) {
													echo $child['PostComment']['comments'];
												} else {
													echo'';
												}
												?></p>
										</section>
											<section class="user-reply">
											<span class="reply-text">
												<!--a href="javascript:void(0)" onclick="addcommentbox(<?php echo $postid.','.$parentids.','.$parentid;?>),$(this).hide(); $(this).next('a').show();$('.replybox<?php echo $parentid;?>').show()">Reply</a>
												<a href="javascript:void(0)" style="display:none" onclick="$('.replybox<?php echo $parentid;?>').hide();$(this).prev('a').show();$(this).hide();">Hide</a-->
											</span>
											<span class="reply-icon">
												<a class="like-icn" href="javascript:void(0)" onclick="likedislikecomment(1,0,<?php echo $parentid.','.$postid;?>)"></a><span id="likecomment<?php echo $parentid;?>"><?php echo $like;?></span>&nbsp;&nbsp;&nbsp;&nbsp;
												<a class="dislike-icn" href="javascript:void(0)" onclick="likedislikecomment(0,1,<?php echo $parentid.','.$postid;?>)"></a><span id="dislikecomment<?php echo $parentid;?>"><?php echo $dislike;?></span>
											</span>
											
										</section>
										<section class="removereplybox replybox<?php echo $parentid;?>"></section>
										</section>
										<?php $subp++; } } ?>
									<section class="clear-both"></section>
									</section>
								</li>
								<?php $i++;}  } ?>
                                </ul>
                                <p class="text-center">
								<?php
								if ($allpostcounts != '0') {
									echo '<a href="javascript:void(0)" onclick="showallcoments()">All <b id="totalcnt">' . $allpostcounts . '</b> Comments</a>';
								} else {
									echo '';
								}
								?>
                                </p>
                            </section><!--Coments-->

                            <section class="post-comments">
                                <h2 class="head">Post a Comments</h2>
<?php echo $this->Form->create('PostComment', array('type' => 'file', 'url' => array('controller' => 'contents', 'action' => 'ajaxpostcomment'))); ?>
<div class="post-comment-block">
<div class="comment-pic" id="commentimagedivid">

</div>
 <p>
<?php echo $this->Form->textarea('comment', array('rows' => '5', 'cols' => '', 'class' => 'form-control txtfld', 'placeholder'=>'Post Your Comment')); ?>

                                </p>
</div>
                               
                                <section class="bottombtns text-right">
                                    <ul class="list-inline">
                                        <li class="addphoto addphoto2"><button class="btn button" type="button" onclick="photopop(1)"><i class="fa  fa-file-picture-o"></i> Add Photo</button><div class="popover-gallery1 popover popover-custom left" style="display:none;" onblur="photopop(2)">
                                                <div class="arrow"></div>
                                                <h3 class="popover-title"><i class="fa fa-file-image-o font16"></i> Select your upload type</h3>
                                                <div class="popover-content">
                                                    <ul class="photo-upload liststyle-none">
                                                        <li>
                                                            <i class="fa fa-mail-forward font14 poslt"></i>
                                                            <!--input type="url" id="photo_url" data-type="setimageurl" name="textfield" class="form-control textfild url" value='' onblur="setimageurl(this.value);photopop(2);" placeholder="Paste image url" /-->
                                                        </li>
														
                                                        <li>
                                                            <a  class="UploadCommentButton" id="UploadCommentButton"><i class="fa  fa-download font14 poslt"></i>Browse your computer</a>
                                                            <div id="commentajax_indicator" style="display:none;"><img class="image_loader" src="/img/ajax-loader.gif" /></div>
                                                        </li>
														<li id="myContent" style="display: none;">
															 <div id="myContent" style="position:relative;">
															 
															<div class="textfield" id="avtar"></div>
													  <section class="avtar_widget">
														<section class="av_top"></section>
														  <section class="av_middle" >
															 
											<ul class="avtars">
											 <?php $allgalleryphotos = $this->Common->getAllGalleryImages();
											 if(!empty($allgalleryphotos)){
											   foreach($allgalleryphotos as $datas){ 
														$image_name = $datas['GalleryPhoto']['gallery_image'];
														 echo '<li><img  class="popImage" src=/img/comments/thumb/'.$image_name.'></li>';
												}	
											 }	 
											 ?>
											</ul>
													  </section> 
													  <section class="av_bottom"></section>
													  <!--Avtar Popup Closed-->
														  </section>
														 </div>
														 
														</li>
														<li>
                                                           <!-- <a data-target="#mygallery" data-toggle="modal" class="btn btn-primary btn-lg">	Choose from gallery</a>-->
															<a href="javascript:void(0);" class="toggleDiv" rel=""><i class="fa  fa-th font14 poslt"></i> Choose from gallery</a>
                                                        </li>
                                                       
                                                    </ul>

                                                </div>
                                            </div></li>
                                        <li>
<?php $user_id = $this->Session->read('UserInfo.id');
if (!empty($user_id)) {
    ?>
                                                <button class="btn button" type="button" onclick="savecomment(<?php echo $lastcommentid;?>)"><i class="fa fa-comment"></i> Comment</button>
<?php } else { ?>
                                                <a class="tpopup btn button" href="/contents/user_login"><i class="fa fa-comment"></i>Comment</a>
<?php } ?>
                                        </li>
                                    </ul>
                                </section>
                                <?php echo $this->Form->input('PostComment.comment_image', array('label' => false, 'type' => 'hidden', 'value' => '')); ?>
                                <?php echo $this->Form->input('PostComment.image_type', array('label' => false, 'type' => 'hidden', 'value' => '')); ?>
				<?php echo $this->Form->input('PostComment.parent_id' ,array("label" => false, 'div' => false,'type'=>'hidden','value'=>'')); ?>
				<?php echo $this->Form->input('PostComment.content_id', array('label' => false, 'type' => 'hidden', 'value' =>$content['Content']['id'])); ?>

                                    <?php echo $this->Form->end(); ?>
                            </section><!--Coments-->
                        </section>
                    </section>
                    <!--Bottom Section Closed-->

                </section>
                <!--Left Closed-->

                <!--Right Start-->
                <section class="col-sm-4 new_ipad_left">
                    <!--Trending Tags Start-->
                    <section class="module clearfix usermodule">
                        <section class="profilepic">
                            <div class="userbg">
                                            <?php  if(!empty($users['User']['cover_image'])){
                                             $img = $users['User']['cover_image'];
                                             if (filter_var($img, FILTER_VALIDATE_URL) === FALSE) {
                                                  echo $this->Html->image('/img/cover/' . $img, array('alt' => 'User BackImage'));
                                                }else{
                                                    echo $this->Html->image($img, array('alt' => 'User BackImage'));
                                                }
					//echo $this->Html->image('avatar/'.$users['User']['avatar_image'],array('height'=>'103', 'width'=>'103'));
					   }else{
                                            echo $this->Html->image('cover/user-bg.jpg');
					}     ?>                         
                                
                                <div class="profileoverlay"></div></div>                                	
                            <section class="userinfo">
                              
                                    <?php 
                                    
                                    
                                            if(!empty($users['User']['avatar_image'])){
                                            $img = $users['User']['avatar_image'];
                                             if (filter_var($users['User']['avatar_image'], FILTER_VALIDATE_URL) === FALSE) {
                                                   $round_img =  $this->Html->image('avatar/'.$img ,array('height'=>'103', 'width'=>'103','class'=>'User Avatar'));  
                                                }else{
                                                    $round_img =  $this->Html->image($img ,array('height'=>'103', 'width'=>'103','class'=>'User Avatar'));  
                                                }
					//echo $this->Html->image('avatar/'.$users['User']['avatar_image'],array('height'=>'103', 'width'=>'103'));
					}else{
					 $round_img =  $this->Html->image('avatar/no_image.png',array('height'=>'103', 'width'=>'103','class'=>'User Avatar'));
					}
                                        
                                         ?>
                                    <a class="userphoto" href="<?php echo BASE_URL.'users/profile_post/'.$users['User']['id']; ?>"><?php echo $round_img; ?><span><?php echo $users['User']['first_name'] . ' ' . $users['User']['last_name']; ?></span></a>
                            </section>
                        </section><!--/Profile pic-->
                        <section class="col-lg-12 more-bxslider">
                            <p class="profile-text"><?php
if (!empty($users['User']['bio'])) {
    echo substr($users['User']['bio'], 0, 40) . '...';
} else {
    echo '';
}
?></p>
                           
                            <?php if($users['User']['user_type']=='1'){ ?>
                            <section class="more-from">
                                <h4>More from this writer</h4>
                                <div class="right-photo-gallery">
                                    
                                    <?php
                                    $allcontentphotos = $this->Common->getAllContentsByUser($users['User']['id']);
                                    $i = 1;
                                    foreach ($allcontentphotos as $data) {
                                        $postid = $data['Content']['id'];
                                        if ($i === 1){
                                            echo '<ul class="relatedpics clearfix liststyle-none">';
                                        }
                                        if (!empty($data['Content']['title'])) {
                                            $title = substr($data['Content']['title'], 0, 15) . '...';
                                        } else {
                                            $title = '';
                                        }
                                        if (!empty($data['Photo'][0]['image'])) {

                                   if ($data['Photo'][0]['image_type'] =='file') {
                                      $image_name = $data['Photo'][0]['image'];
									  echo '<li>'.$this->Html->link($this->Html->image('/img/photos/thumb/'. $image_name),array('controller' => 'contents', 'action' => 'post',$postid), array('escape' => false)).'<span class="piclabel">'.$title.'</span></li>';
                                            } else {
                                                $image_name = $data['Photo'][0]['image'];
                                                echo '<li><a href=/post/' . $postid . '><img src=' . $image_name . '><span class="piclabel">' . $title . '</span></a></li>';
                                            }
                                        } else {
                                            $video = $this->Common->get_videothumb($data['Content']['id']); 
                                            if($video){
                                             $photoimage =   '<img src='.$video.' />'; 
                                             }else{
                                             $photoimage =  '<img src="/timthumb.php?src=/img/photos/thumb/soccer-ball-128.png&h=191&w=200&zc=1">';
                                             }
                                            echo '<li><a href=/post/'.$postid.'>'.$photoimage.'<span class="piclabel">'.$title.'</span></a></li>';
                                        }
                                        $i++;
                                        if ($i === 5) {
                                            echo '</ul>';
                                            $i = 1;
                                        }
                                    }
                                    if ($i <= 4) {
                                        echo '</ul>';
                                    }
                                    ?>

                                </div>
                            </section>
                            
                            <section class="slide-control clearfix"><a href="javascript:void(0)" class="prevs"><i class="fa  fa-angle-left"></i> Prev</a> <a href="javascript:void(0)" class="nxt">Next <i class="fa  fa-angle-right"></i></a></section>
                       <?php } ?>
                        
                        </section>

                    </section>
                    <!--Trending Tags Closed-->
					<!--Related Content Closed-->
					<div class="text-center">
					<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FFootyBaseCom&amp;width&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:290px;" allowTransparency="true"></iframe> </div>
                    <!--Related Content Start-->
                    <section class="col-sm-12 relatedcon">
                        <h2>Related Content</h2>
                        <ul class="relatedlist relatedphotos">
						
						<?php 
						if(!empty($tagIDs)){ 
							$allphotos=$this->Common->getAllVideoByContentId($tagIDs,$content['Content']['id']);
						}else{ 
							$allphotos=$this->Common->getAllVideoByContentId(null,$content['Content']['id']);	
						}
						//echo '<pre>'; print_r($allphotos);  die;
						if(!empty($allphotos)){ 
							foreach($allphotos as $popular_post){ //print_r($allphoto);
							$postidss = $popular_post['Content']['id'];
							echo '<li>';
						    if (!empty($popular_post['Photo'][0]['image'])) {
									if ($popular_post['Photo'][0]['image_type'] == 'file'){
										$image_name = $popular_post['Photo'][0]['image'];
										echo '<p>'.$this->Html->link($this->Html->image('/img/photos/original/'. $image_name),array('controller' => 'contents', 'action' => 'post',$popular_post['Content']['id']), array('escape' => false)).'</p>';
									} else {
										$image_name = $popular_post['Photo'][0]['image'];
										echo '<p>'.$this->Html->link($this->Html->image($image_name),array('controller' => 'contents', 'action' => 'post',$popular_post['Content']['id']), array('escape' => false)).'</p>';
										
									}
								}else{
									   $video = $this->Common->get_videothumb($postidss); 
									   if($video){
									   echo '<p>'.$this->Html->link($this->Html->image($video),array('controller' => 'contents', 'action' => 'post',$popular_post['Content']['id']), array('escape' => false)).'</p>';
									   }else{
										echo '<p><a href="/post/'.$popular_post['Content']['id'].'"><img src=/img/photos/original/soccer-ball-128.png></a></p>';
								}
							
						
								
							   } ?>
							   
							 <p><?php 
											$POST_Title=$this->Common->getAVideoContent($postidss);
										   if(!empty($POST_Title)){
										      echo $this->Html->link($POST_Title['Content']['title'],array('controller'=> 'contents','action'=>'post_details',$postidss));
											  } 
										  ?>
										</p></li> 
						<?php } } ?>
                        </ul>
                    </section>
					
                    
                </section>
                <!--Right Closed-->
            </section>
	  </section>		
	

    <script>
	function commentphotopop(numberss) {
        if (numberss == 1) {
            $('.popover-gallery2').toggle();
        } else {
            $('.popover-gallery2').hide();
        }
	
    }
	function setavatarimage(cid){ 
		/*Selecting Gallery image Start*/
		jQuery('.avtar_widget'+cid).hide();
		jQuery('#avtar'+cid).click(function(){
		   jQuery('.avtar_widget'+cid).toggle();
		   jQuery('.avtars'+cid+' li').unbind('click');
		   jQuery('.avtars'+cid+' li').click(function(){
			  jQuery('#PostCommentCommentImage'+cid).val(jQuery(this).children().attr('src'));
			  jQuery('#avtar'+cid).removeClass('avtar'+cid);
				jQuery('.av'+cid).remove();
				jQuery('#avtar'+cid).append('<img  class=av'+cid+' src='+jQuery(this).children().attr('src')+' />');
			  jQuery('.avtar_widget'+cid).hide();
			  $('#PostCommentImageType'+cid).val('Gallery');
		   });
		});
		
		/*setting gallery prefilled in edit profile*/
		
		var img=jQuery('#PostCommentCommentImage'+cid).val();
		jQuery('#avtar'+cid).append('<img  class=av'+cid+' src=/img/view_gallery.png />');  
	
		 /*Selecting Gallery image End*/
	}
	
	function addcommentbox(pid,cid,subcid,lastid ,ref){ //alert(subcid);
		
	    /*$('#PostCommentComment'+cid).focus();
		$('#PostCommentParentId'+cid).val(cid);
		$('#PostCommentContentId'+cid).val(pid);*/
	
	var appndHtml  = '<form accept-charset="utf-8" method="post" enctype="multipart/form-data" id="PostCommentPostDetailsForm'+subcid+'" action="/contents/ajaxpostcomment">';
	appndHtml +='<div class="post-comment-block">';
    appndHtml +='<div id="commentimagedivid'+subcid+'" class="comment-pic"></div>';
	appndHtml += '<p><textarea id="PostCommentComment'+subcid+'"  class="form-control txtfld" cols="" rows="5" name="data[PostComment][comment]" placeholder="Post Your Comment"></textarea></p></div>';
		appndHtml += '<section class="bottombtns text-right">';
			appndHtml += '<ul class="list-inline custom-popup-comment">';
				appndHtml += '<li class="addphoto addphoto2"><button onclick="commentphotopop(1)" type="button" class="btn button"><i class="fa  fa-file-picture-o"></i> Add Photo</button><div onblur="commentphotopop(2)" style="display:none;" class="popover-gallery2 popover popover-custom left">';
						appndHtml += '<div class="arrow"></div>';
						appndHtml += '<h3 class="popover-title"><i class="fa fa-file-image-o font16"></i> Select your upload type</h3>';
						appndHtml += '<div class="popover-content">';
							appndHtml += '<ul class="photo-upload liststyle-none">';
								appndHtml += '<li>';
								appndHtml += '<a id="UploadCommentButton'+subcid+'" onclick=commentimageuploading('+subcid+') class="UploadCommentButton" style="position: relative;">';
								appndHtml += '<i class="fa  fa-download font14 poslt"></i>';
								appndHtml += 'Browse your computer';
								appndHtml += '<form action="/Contents/insertCommentPhoto/" enctype="multipart/form-data" method="POST" style="margin: 0px !important; padding: 0px !important; position: absolute; top: 0px; left: 0px;" class="uploadForm"> <input type="file" name="file" style="display: block; overflow: hidden; width: 100%; height: 100%; text-align: right; opacity: 0; z-index: 999999;"></form>';
								appndHtml += '</a>'
								appndHtml += '<div style="display:none;" id="commentajax_indicator"><img src="/img/ajax-loader.gif" class="image_loader"></div>';
								appndHtml += '</li>';
								appndHtml += '<li style="display: none;" id="myContent'+subcid+'">';
									 appndHtml += '<div style="position:relative;" id="myContent'+subcid+'">';
									appndHtml += '<div id="avtar'+subcid+'" class="textfield"></div>';
							  appndHtml += '<section class="avtar_widget'+subcid+'" style="display: none;">';
								appndHtml += '<section class="av_top'+subcid+'"></section>';
								  appndHtml += '<section class="av_middle'+subcid+'">';
								 appndHtml += '<ul class="avtars'+subcid+'">';
							 <?php $allgalleryphotos = $this->Common->getAllGalleryImages();
									if(!empty($allgalleryphotos)){
										foreach($allgalleryphotos as $datas){ 
											$image_name = $datas['GalleryPhoto']['gallery_image']; ?>
									        appndHtml += '<li><img class="popImage" src=/img/comments/thumb/<?php echo $image_name;?>></li>';
									<?php 	} } ?>
							 appndHtml += '</ul>';
							  appndHtml += '</section>';
							  appndHtml += '<section class="av_bottom"></section>';
							appndHtml += '</section>';
							appndHtml += '</div>';
							appndHtml += '</li>';
								appndHtml += '<li>';
									//appndHtml += '<a class="toggleDiv" rel="'+subcid+'" onclick=toggleDiv("myContent'+subcid+'"),setavatarimage('+subcid+') href="javascript:void(0)"><i class="fa  fa-th font14 poslt"></i> Choose from gallery</a>';
									appndHtml += '<a class="toggleDiv" rel="'+subcid+'" href="javascript:void(0)"><i class="fa  fa-th font14 poslt"></i> Choose from gallery</a>';
								appndHtml += '</li>';
							appndHtml += '</ul>';
						appndHtml += '</div>';
					appndHtml += '</div>';
					appndHtml += '</li>';
					appndHtml += '<li>';
					appndHtml += '<button type="button" class="btn button" onclick="savepopupcomment('+subcid+','+lastid+')"><i class="fa fa-comment"></i> Comment</button>';
					appndHtml += '</li>';
					appndHtml += '</ul>';
					appndHtml += '<input type="hidden" id="PostCommentCommentImage'+subcid+'" value="" name="data[PostComment][comment_image]">';
		appndHtml += '<input type="hidden" id="PostCommentImageType'+subcid+'" value="" name="data[PostComment][image_type]">';appndHtml += '<input type="hidden" id="PostCommentParentId'+subcid+'" value="'+cid+'" name="data[PostComment][parent_id]">';	
		appndHtml += '<input type="hidden" id="PostCommentContentId'+subcid+'" value="'+pid+'" name="data[PostComment][content_id]">';
					appndHtml += '</section>';
		
				 appndHtml += '</form>';
			 
		 $('.replybox'+subcid).html(appndHtml);
	}			 
	</script>	
