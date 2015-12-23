<!-- <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>-->
<script>
    $(window).on("scrollstop", function() {
    if($(window).scrollTop() + $(window).height() >= $(document).height()-500){
       $('.loadmore a').trigger('click');
        }
  });
    function getMoreRecords(){
        $("#count").load( "<?php echo BASE_URL.'users/ajax_profile/'.$users['User']['id']; ?>", function(sdata) {
           if($.trim(sdata)=='done'){
                var ret = false;
                clearTimeout(time_out);
                 $('.row.indicator').html('<a href="javascript:void(0)">No More Posts <i class="caret"></i></a>');
                return;
                }else{
                  $('.ajax_profile').last().after(sdata);
                  $('.home-slider').bxSlider({});
                }
            });
        
        
    
//            $.ajax({
//            url: "<?php echo BASE_URL.'users/ajax_profile/'.$users['User']['id']; ?>",
//            success: function(sdata){
//                if($.trim(sdata)=='done'){
//                var ret = false;
//                clearTimeout(time_out);
//                 $('.row.indicator').html('<a href="javascript:void(0)">No More Posts <i class="caret"></i></a>');
//                return;
//                }else{
//                  $('.ajax_profile').last().after(sdata);
//                  $('.home-slider').bxSlider({});
//                }
//                 $('.quiz-middle').last().after(sdata);
//                if (cnt > lmt) {
//                    $('#loadmore').html('<a href="javascript:void(0)" data-val='+limits+' onclick="getMoreRecords(' + cnt + ',' + lmt + ')">Load more stories <i class="caret"></i></a>');
//                } else {
//                    $('#loadmore').html('<a href="javascript:void(0)" data-val='+limits+' onclick="getMoreRecords(' + cnt + ',' + lmt + ')">No More Records <i class="caret"></i></a>');
//              }            }
//        });
    }
    
    window.fbAsyncInit = function() {
            FB.XFBML.parse();
          }
    
    
    function startime(){
            $.ajax({
            url: "<?php echo BASE_URL.'users/ajax_profile/'.$users['User']['id']; ?>",
            success: function(sdata){
                if($.trim(sdata)=='done'){
                var ret = false;
                clearTimeout(time_out);
                 $('.row.indicator').html('<a href="javascript:void(0)">No More Posts <i class="caret"></i></a>');
                return;
                }else{
                  $('.ajax_profile').last().after(sdata);
                  $('.home-slider').bxSlider({});
                }
            }
           });  
                time_out =     setTimeout(function(){
                 startime();
                 }, 5000);
    
    }
    
  $(document).ready(function(){
            $('.row.indicator').hide();
            $('.home-slider').bxSlider({});
            var id='<?php echo $content['Content']['id']; ?>';
            
//            startime();
            $('body').on('click','a.control_prev',function (){
            $(this).parent().parent().find('.bx-controls').find('a.bx-prev').trigger('click');		
	    });
            $('body').on('click','a.control_next',function (){
            $(this).parent().parent().find('.bx-controls').find('a.bx-next').trigger('click');    
	    });
            
           
    }); 
    
    
    function savepollpreview(pollID,pollqtnID,pollansID){
	    $.ajax({
            type: "POST",
            url: "/contents/ajaxpollpreviewresult/",
           data	 : { 'poll_id': pollID,'poll_questions_id': pollqtnID,'poll_answer_id': pollansID},
            success: function(sdata) { 
				$('#totalpollans'+pollansID).html(sdata);
				$('.pollpercentages'+pollID).show();
				$('.vote_btn'+pollID).hide();
				$('.transition'+pollID).removeAttr('onclick');
            }
        });
	}
	
	function showquizpreview(qtnID,quizID){
        $.ajax({
            type: "POST",
            url: "/contents/ajaxquizpreviewresult/",
           data	 : { 'quiz_id': quizID,'quiz_questions_id': qtnID},
            success: function(sdata) { 
				$('#quizpreviewdivid'+quizID).html(sdata);
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
      function embed(){
             setTimeout(function() {
            if (typeof(FB) != 'undefined') {
             window.fbAsyncInit();
             } embed();
             }, 2000)
           }  
            
         
        
        
</script>  
<div id="count" style="display: none;">
</div>
<section class="container"> 
    <!--Wrapper Start-->
    <section id="wrapper">
        <!--Content Start-->
        <section class="content">
        <section class="row">
                <!--Left Start-->
                    <!--Post Description Start-->
                       <section class="col-sm-8">
                       <section class="ajax_profile">
                                <section class="user-profile-block">
                                <section class="user-profile-row">
                                    <section class="user-profile-pic">
                                        <?php
                                        if(!empty($users['User']['avatar_image'])){
                                            $img = $users['User']['avatar_image'];
                                             if (filter_var($users['User']['avatar_image'], FILTER_VALIDATE_URL) === FALSE) {
                                                    echo $this->Html->image('avatar/'.$img ,array('height'=>'103', 'width'=>'103'));  
                                                }else{
                                                    echo '<img height="103" width="103" src='.$img.' />';
                                                }
					//echo $this->Html->image('avatar/'.$users['User']['avatar_image'],array('height'=>'103', 'width'=>'103'));
					}else{
					echo $this->Html->image('avatar/no_image.png',array('height'=>'103', 'width'=>'103'));
					}
                                        ?>
                                    </section>
                                    <section class="user-profile-text">
                                        <h1><?php echo $users['User']['first_name'] . ' ' . $users['User']['last_name']; ?></h1>
                                        <p><?php echo $users['User']['bio']; ?></p>
                                    </section>
                                </section>
                                <section class="user-profile-btn clearfix">
                                    <ul>
                                        <li>
                                            <a href="#" class="button btn disable-btn">
                                                <i class="fa fa-tags"></i>
                                                Posts <span><?php echo $allcontents; ?></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo BASE_URL.'users/profile_comments/'.$users['User']['id']; ?>" class="button btn comment-btn">
                                                <i class="fa fa-comments"></i>
                                                Comments <span><?php echo $comment_count; ?></span>
                                            </a>
                                        </li>
                                    </ul>
                                </section>
                            </section> 
                           <div class="profile-post-row clearfix">
                               <?php //echo '<pre>'; //print_r($content); ?>
                               <h3><a href="<?php echo BASE_URL.'post/'.$content['Content']['id']; ?>"><?php echo $content['Content']['title'];?></a></h3>
                                        <section class="comment-date"> <?php
										$creatd = $content['Content']['created'];
                                                                                if(!empty($creatd)){
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
                                        </section>
                                    </div>
                    <!-- Post Share Row Start-->
                    <?php echo $this->element('profile_post_element'); ?>
                    <!--Post Poll Section End Here-->
                    <!--Bottom Section Start-->
                
                    <!--Bottom Section Closed-->
                    
                </section>
                       </section>
                    <!--Post Description Closed-->

            
                <!--Left Closed-->

                <!--Right Start-->
                <section class="col-sm-4 mobile_link">
                    <!--Related Content Start-->
                    <section class="col-sm-12 relatedcon relatedcon2">
                        <!--Add-Content-Start--> 
                        	<!--div class="add-block">
                       	    	<a href="javascript:void(0)">
                                 <?php //echo $this->Html->image('add-pic1.png'); ?>   </a>
                            </div-->
                       
                    </section>
                    <!--Related Content Closed-->
					<div class="text-center">
					<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FFootyBaseCom&amp;width&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:290px;" allowTransparency="true"></iframe>
					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- footybase2 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-2247586710150023"
     data-ad-slot="5316964004"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>
                </section>
                <!--Right Closed-->
            </section>
            
            
            <section class="row indicator text-center">
            <img class="ajax-loader" src="/img/ajax-loader.GIF" />
            </section>
             <section class="more-stories-row">
                 <p class="loadmore"><a href="javascript:void(0);" onclick="getMoreRecords()">Load more stories <i class="caret"></i></a></p>
            </section>
        </section>
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


        <!--Content Closed-->
<!--    </section>-->

