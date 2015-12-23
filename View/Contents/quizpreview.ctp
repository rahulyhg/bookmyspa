<script>
     $(document).ready(function() {
        $('.home-slider').bxSlider({});
	
	    $('.right-photo-gallery').bxSlider({
            //autoReinitialise: true,
        }); 

		$('.tpopup').click(function(event) {
			var width  = 575,
				height = 400,
				left   = ($(window).width()  - width)  / 2,
				top    = ($(window).height() - height) / 2,
				url    = this.href,
				opts   = 'status=1' +
						 ',width='  + width  +
						 ',height=' + height +
						 ',top='    + top    +
						 ',left='   + left;
			
			window.open(url, 'twitter', opts);
		 
			return false;
		  });
		
    });
    
    
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

	function focusoncurrentsilde(id) { 
	  $("html, body").scrollTop($('#slide'+id).offset().top);
    }
	function savepreviewresult(qtnID,ansID){
		 var quizID = <?php echo $content['Quiz'][0]['id']; ?>;
        $.ajax({
            type: "POST",
            url: "/contents/ajaxquizpreviewresult/",
           data	 : { 'quiz_id': quizID,'quiz_questions_id': qtnID,'quiz_answer_id': ansID},
            success: function(sdata) { 
				alert(sdata);
            }
        });
	
	}
</script> 
    <!--Wrapper Start-->
    <section id="wrapper">
        <!--Content Start-->
        <section class="content">
            <section class="row">
                <!--Left Start-->
                <section class="col-sm-8">
                    <h2 class="heading">Quiz Preview
					
					<div class="heading-img-gallery">
						<ul>
							<li><i class="fa fa-question-circle orng-col mrgrtnone"></i></li>
						</ul>
					</div>
					</h2>
                    <!-- Post Share Row Start-->
                    <section class="col-lg-12 postrow">
                        <section class="row">
                            <section class="col-lg-4 p-t">
                                <span class="userpic">
                                    <?php
										if(!empty($users['User']['avatar_image'])){
												echo $this->Html->image('/img/avatar/'.$users['User']['avatar_image'], array('alt' => ''));
										}else{
												echo $this->Html->image('/img/avatar/no_image.png', array('alt' => ''));
										}
                            ?>
                                </span>
                                <span class="post-time">
									<strong>
                                        <?php
											if (!empty($users)) {
												echo $users['User']['first_name'];
											}
                             ?>
									</strong> 
                                    <?php
										$creatd = $content['Content']['created'];
										$new_date = date('Y-m-d h:i:s');
										$date1 = new DateTime(date('Y-m-d', strtotime($creatd)));
										$date2 = new DateTime(date('Y-m-d', strtotime($new_date)));
										$num_day = $date1->diff($date2)->days;
										if ($num_day == '0') {
											echo '- Today';
										} else if ($num_day == '1') {
											echo ' -' . $num_day . ' day ago';
										} else {
											echo ' -' . $num_day . ' days ago';
										}
								?>
                                </span>
                            </section><!-- / col-lg-4 -->
			    <?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
                            <section class="col-lg-8 col-sm-12">
                                <ul class="sharetags pull-right liststyle-none mobile-left">
                                    <li><span><a href="http://www.facebook.com/share.php?u=<?php echo $actual_link;?>" onClick="return fbs_click(575, 400)" target="_blank" title="Share This on Facebook"><img src="/img/f-share.png" alt="facebook share"></a></span></li>
                                    <li><span><a class="twitter tpopup" href="http://twitter.com/share"><img src="/img/tw-share.png" alt="Twitter Share"></a></span></li>
                                    <li><span><a href="http://www.reddit.com/submit" onclick="window.open('http://www.reddit.com/submit? v=5&noui&jump=close&url='+encodeURIComponent (location.href)+'&title='+encodeURIComponent (document.title), 'delicious','toolbar=no, width=575,height=400'); return false;"> <img src="/img/rd-share.png" alt="Reddit Share"/></a></span></li>
                                    <li class="total-views"><a href="javascript:void(0)"><i class="fa fa-view"></i>&nbsp;</a></li>
                                </ul>
                           </section>
                        </section>          
                    </section>
					<!--Post Quiz Section Start Here-->
					<?php 
					  if(!empty($content['Quiz'])){ ?>
					<div class="row post-des">
                        	<section class="col-lg-12">
								 <p><?php echo $content['Quiz'][0]['title'];?> </p>
								<section class="quiz-page">
                                	<a class="pre-slide" href="#"><i class="fa fa-angle-left"></i></a>
                                    <a class="nxt-slide" href="#"><i class="fa fa-angle-right "></i></a>
                                    <ul class="pagination page-diff">
									   <?php for($i=1;$i <= $quiz_qstn_count; $i++){?>
                                    	<li><a href="javascript:void(0)" onclick="focusoncurrentsilde(<?php echo $i;?>)"><?php echo $i;?></a></li>
                                        <?php } ?>
                                    </ul>
                                </section>
								<?php if(!empty($quiz_qstns)){ $count_s=1;
								     foreach($quiz_qstns as $quiz_qstn){?>
                                <section class="quiz-middle" id="slide<?php echo $count_s;?>">
                                	<p>
									 <?php
											if (!empty($quiz_qstn['QuizQuestion']['image'])){
												$image_name = $quiz_qstn['QuizQuestion']['image'];
												echo '<img src=/img/quiz/original/'.$image_name.'>';
											} else {
												echo '';
											}
									?>
										<!--img alt="" src="/images/quiz-pic.jpg" title=""-->
									</p>
                                    <p class="quiz-qus"><?php echo $quiz_qstn['QuizQuestion']['title'];?></p>
                                </section><!--/ Quiz Question-->
								
                                <section class="quiz-ans">
									<?php if(!empty($quiz_qstn['QuizAnswer'])){ foreach($quiz_qstn['QuizAnswer'] as $quiz_answer){?>
                                    <section class="quizans transition" onclick="savepreviewresult(<?php echo $quiz_answer['quiz_questions_id'].','.$quiz_answer['id'];?>)">
                                        <div class="media">
                                              <a href="javascript:void(0)" class="pull-left quiz-img">
                                               <?php
													if (!empty($quiz_answer['image'])){
														$image_name = $quiz_answer['image'];
														echo '<img src=/img/quiz/thumb/'.$image_name.' class="media-object">';
													} else {
														echo '';
													}
											  ?>
                                              </a>
                                              <div class="media-body">
                                               <div class="quiz-cont">
                                               <p><?php echo $quiz_answer['answer'];?></p>
                                               </div>
                                              </div>
                                            </div>
                                    </section>
									<?php } } ?>
                                </section>
								<?php $count_s++; } } ?>
                            </section>
                       </div>
					   <div><p class="m-btm0"><a class="btn btn-blue bl-element" href="/contents/quizpreviewresult/759">Get Your Result ></a></p></div>
					   <?php
					}else{ echo '';} 
					
					?>
					<!--Post Quiz Section End Here-->
					
                   
                </section>
                <!--Left Closed-->

                <!--Right Start-->
                <section class="col-sm-4">
                    <!--Trending Tags Start-->
                    <section class="module clearfix usermodule">
                        <section class="profilepic">
                            <div class="userbg">
<?php echo $this->Html->image('/img/cover/' . $users['User']['cover_image'], array('alt' => 'User BackImage')); ?>
                                <div class="profileoverlay"></div></div>                                	
                            <section class="userinfo">
                                <a href="#" class="userphoto">
<?php echo $this->Html->image('/img/avatar/' . $users['User']['avatar_image'], array('alt' => 'User Avatar')); ?>
                                    <span><?php echo $users['User']['first_name'] . ' ' . $users['User']['last_name']; ?></span></a>
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
                            <section class="more-from">
                                <h4>More from this writer</h4>
                                <div class="right-photo-gallery">
                                    
                                    <?php
                                    $allcontentphotos = $this->Common->getAllContentsByUser($users['User']['id']);
                                    $i = 1;

                                    foreach ($allcontentphotos as $data) {
                                        $postid = $data['Content']['id'];
                                        if ($i === 1) {
                                            echo '<ul class="relatedpics clearfix liststyle-none">';
                                        }
                                        if (!empty($data['Content']['title'])) {
                                            $title = substr($data['Content']['title'], 0, 15) . '...';
                                        } else {
                                            $title = '';
                                        }
                                        if (!empty($data['Photo'][0]['image'])) {

                                            if ($data['Photo'][0]['image_type'] == 'file') {
                                                $image_name = $data['Photo'][0]['image'];
                                                echo '<li><a href=/contents/post_details/' . $postid . '><img src=/img/photos/thumb/' . $image_name . '><span class="piclabel">' . $title . '</span></a></li>';
                                            } else {
                                                $image_name = $data['Photo'][0]['image'];
                                                echo '<li><a href=/contents/post_details/' . $postid . '><img src=' . $image_name . '><span class="piclabel">' . $title . '</span></a></li>';
                                            }
                                        } else {
                                            echo '<li><a href=/contents/post_details/' . $postid . '><img src=/img/photos/thumb/soccer-ball-128.png><span class="piclabel">' . $title . '</span></a></li>';
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
                        </section>

                    </section>
                    <!--Trending Tags Closed-->

                    <!--Related Content Start-->
                    <section class="col-sm-12 relatedcon">
                        <h2>Related Content</h2>
                        <ul class="relatedlist">
						<?php $allvideos=$this->Common->getAllVideoByContentId($content['Content']['id']); if(!empty($allvideos)){
							foreach($allvideos as $allvideo){
							$string=$allvideo['Video']['video_url'];
							$doc = new DOMDocument();
							@$doc->loadHTML($string);
							$tags = $doc->getElementsByTagName('iframe');
							foreach ($tags as $tag) {  $src= $tag->getAttribute('src'); ?>
								<li>
									<p><iframe width="320" height="315" frameborder="0" allowfullscreen="" src="<?php echo $src;?>"></iframe></p>
									 <!--p><a href="#">Conviction without the court: Why Social Media Should not be...</a></p-->
								</li>
							<?php }?>
							   
							<?php } } ?>
                        </ul>
                        <p class="text-right"><a href="javascript:void(0)" class="bl-link">More on FooTab <i class="fa  fa-arrow-circle-right"></i></a></p>
                    </section>
                    <!--Related Content Closed-->
                </section>
                <!--Right Closed-->
            </section>
    