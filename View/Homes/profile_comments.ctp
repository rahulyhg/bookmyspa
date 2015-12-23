<script>
    $(document).ready(function(){

        var currentRequest = null;
        // these are total shown first time
        var wallcount = 5;
        var release = 1;
        var redirectUrl  = '';
        
        $('.gifIndicator').hide();

        $(document).on('click','.loadmore',function(){
            if (release == 1) {
                redirectUrl = '/polls/comments_scroll/' + wallcount+'/<?php echo $userDetail['User']['id']; ?>' ;
                $('.gifIndicator').show();
                currentRequest = jQuery.ajax({
                                    type    : 'POST',
                                    url     : redirectUrl,
                                    cache   : false,
                                    beforeSend : function()    {           
                                        if(currentRequest != null) {
                                            currentRequest.abort();
                                        }
                                    },
                                    success : function(getHtml) {
                                        if (getHtml != '') {
                                            release = 1;
                                            $(document).find('.user-profle-comment ul li:last').after(getHtml);
                                            wallcount = wallcount + 2;
                                        }
                                        else{
                                            release = 0;
                                            alert('No More Result ');
                                            //$(document).find('.package-wrap').append(aHtml);        
                                        }
                                        $('.gifIndicator').hide();
                                    }
                            });
            }
            else{
               //alert('No More Result '); 
            }
        });
        $(window).on("scrollstop", function() {
            if($(window).scrollTop() + $(window).height() >= $(document).height()-500) {
               $('.loadmore').click();
            }
        });
        
    });
    
    
</script>

        <!--Wrapper Start-->
        <section id="wrapper">
            
            <!--Content Start-->
            <section class="content">
                <section class="row">
                    <!--Left Start-->
                    <section class="col-sm-8">                        
                        <!--Post Description Start-->
                        <div class="row">
                        	<section class="col-lg-12">
                            	<!--user-profile-section-start-->
                            	<section class="user-profile-block">
                                	<section class="user-profile-row">
                                    	<section class="user-profile-pic">
                                   	    	<img src="images/user-profile-pic.png" width="103" height="103" alt="">
                                                <?php if(!empty($userDetail['User']['avatar_image'])){
                                                if(filter_var($userDetail['User']['avatar_image'], FILTER_VALIDATE_URL)){
echo $this->Html->image($userDetail['User']['avatar_image'], array('alt' => '', "width"=>"103", "height"=>"103"));
                                                }else{
                                                echo $this->Html->image('/img/avatar/'.$userDetail['User']['avatar_image'], array('alt' => '', "width"=>"103", "height"=>"103"));
                                                }
                                                }else{
                                                echo $this->Html->image('/img/avatar/no_image.png', array('alt' => '', "width"=>"103" ,"height"=>"103"));
                                                } ?>
                                        </section>
                                        <section class="user-profile-text">
                                        	<h1><?php echo ucfirst($userDetail['User']['first_name']." ".$userDetail['User']['last_name']);?></h1>
                                            <p><?php echo $userDetail['User']['bio']; ?></p>
                                        </section>
                                    </section>
                                    <section class="user-profile-btn clearfix">
                                    	<ul>
                                        	<li>
                                                <a class="button btn" href="#">
                                                    <i class="fa fa-tags"></i>
 Posts <span><?php echo $postCnt; ?></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="button btn disable-btn comment-btn" href="#">
                                                <i class="fa fa-comments"></i>
 Comments <span><?php echo $commentCnt; ?></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </section>
                                </section>
                                <!--user-profile-section-end-->
                                
                                <!--user-profile-comment-start-->
                                	<section class="user-profle-comment">
                                    	<?php if(!empty($commentData)){ ?>
                                            <ul class="user-comment-row">
                                                <?php foreach($commentData as $theComment){ ?>
                                                    <li>
                                                        <section class="user-comment-head clearfix">
                                                            <section class="col-sm-9 postrow">
                                                                <span class="userpic">
                                                                <?php if(!empty($theComment['User']['avatar_image'])){
									if(filter_var($theComment['User']['avatar_image'], FILTER_VALIDATE_URL)){
    echo $this->Html->image($theComment['User']['avatar_image'], array('alt' => ''));
                                                                        }else{
                                                                        echo $this->Html->image('/img/avatar/'.$theComment['User']['avatar_image'], array('alt' => ''));
                                                                        }
									}else{
						    			echo $this->Html->image('/img/avatar/no_image.png', array('alt' => ''));
                                                                        } ?>
                                                                <img alt="" src="images/userpic1.png"></span>
                                                                <span class="post-time"><a href="javascript:void(0);"><strong><?php echo ucfirst($theComment['User']['first_name']." ".$theComment['User']['last_name']);?></strong></a> Commented on :</span>
                                                                <span class="comment-on"><strong><?php echo $theComment['Content']['title']; ?></strong> </span>
                                                            </section>
                                                            <section class="col-sm-3 postrow">
                                                                <section class="comment-date">
                                                                        <?php echo $this->Common->getTimeDifference($theComment['Content']['created']);?>
                                                                </section>
                                                            </section>
                                                        </section>
                                                        <section class="user-comment-box">
                                                                <section class="user-comment-txt">
                                                                <?php if (!empty($theComment['PostComment']['comment_image']) && ($theComment['PostComment']['image_type'] == 'File')) {
                                                                    echo '<img src="/img/comments/thumb/'.$theComment['PostComment']['comment_image'].'" onmouseover=this.src="/img/comments/original/'.$theComment['PostComment']['comment_image'].'" onmouseout=this.src="/img/comments/thumb/'.$theComment['PostComment']['comment_image'].'" />';
								} else if (!empty($theComment['PostComment']['comment_image']) && ($theComment['PostComment']['image_type'] == 'Gallery')) { 
                                                                    $image_name=$theComment['PostComment']['comment_image'];
                                                                    $filename = basename($image_name); 
									echo '<img src="'.$image_name.'"
															 onmouseover=this.src="/img/photos/original/'.$filename.'" onmouseout=this.src="'.$image_name.'" / >';
												} ?>
                                                                <?php echo $theComment['PostComment']['comments']; ?>
                                                            </section>
                                                            <section class="user-reply">
                                                                <!--<span class="reply-text">
                                                                        <a href="#">Reply</a>
                                                                </span>-->
                                                                <span class="reply-icon">
                                                                        <?php
                                                                        $cntLike = 0;
                                                                        $cntdisLike = 0;
                                                                        if(!empty($theComment['PostCommentLike'])){
                                                                            foreach($theComment['PostCommentLike'] as $pCLD){
                                                                                $cntLike = $cntLike+$pCLD['post_like'];
                                                                                $cntdisLike = $cntdisLike+$pCLD['post_dislike'];
                                                                            }    
                                                                        } ?>
                                                                        <a class="like-icn" href="javascript:void(0);"></a>(<?php echo $cntLike; ?>)
                                                                        <a class="dislike-icn" href="javascript:void(0);"></a>(<?php echo $cntdisLike; ?>)
                                                                </span>
                                                                
                                                            </section>
                                                            
                                                            <?php
                                                            $subData = array();
                                                            $subData = $this->Common->GetSubComment($theComment['PostComment']['id']);
                                                            if(!empty($subData)){
                                                                foreach($subData as $subComment){ ?>
                                                                     <section class="user-comment-box2">
                                                                     <section class="user-comment-head clearfix">
                                                                        <section class="col-sm-9 postrow">
                                                                            <span class="userpic">
                                                                            <?php if(!empty($subComment['User']['avatar_image'])){
                                                                                    if(filter_var($subComment['User']['avatar_image'], FILTER_VALIDATE_URL)){
                echo $this->Html->image($subComment['User']['avatar_image'], array('alt' => ''));
                                                                                    }else{
                                                                                    echo $this->Html->image('/img/avatar/'.$subComment['User']['avatar_image'], array('alt' => ''));
                                                                                    }
                                                                                    }else{
                                                                                    echo $this->Html->image('/img/avatar/no_image.png', array('alt' => ''));
                                                                                    } ?>
                                                                            <span class="post-time"><a href="javascript:void(0);"><strong><?php echo ucfirst($subComment['User']['first_name']." ".$subComment['User']['last_name']);?></strong></a> </span>
                                                                        </section>
                                                                        <section class="col-sm-3 postrow">
                                                                            <section class="comment-date">
                                                                                    <?php echo $this->Common->getTimeDifference($subComment['PostComment']['created']);?>
                                                                            </section>
                                                                        </section>
                                                                    </section>
                                                                    <!--<section class="user-comment-box">-->
                                                                            <section class="user-comment-txt">
                                                                            <?php if (!empty($subComment['PostComment']['comment_image']) && ($subComment['PostComment']['image_type'] == 'File')) {
                                                                                echo '<img src="/img/comments/thumb/'.$subComment['PostComment']['comment_image'].'" onmouseover=this.src="/img/comments/original/'.$subComment['PostComment']['comment_image'].'" onmouseout=this.src="/img/comments/thumb/'.$subComment['PostComment']['comment_image'].'" />';
                                                                                } else if (!empty($subComment['PostComment']['comment_image']) && ($theComment['PostComment']['image_type'] == 'Gallery')) { 
                                                                                $image_name=$subComment['PostComment']['comment_image'];
                                                                                $filename = basename($image_name); 
                                                                                    echo '<img src="'.$image_name.'"
                                                                                                                                     onmouseover=this.src="/img/photos/original/'.$filename.'" onmouseout=this.src="'.$image_name.'" / >';
                                                                                                            } ?>
                                                                            <?php echo $theComment['PostComment']['comments']; ?>
                                                                        </section>
                                                                        <section class="user-reply">
                                                                            <!--<span class="reply-text">
                                                                                    <a href="#">Reply</a>
                                                                            </span>-->
                                                                            <span class="reply-icon">
                                                                                    <?php
                                                                                    $cntLike = 0;
                                                                                    $cntdisLike = 0;
                                                                                    if(!empty($subComment['PostCommentLike'])){
                                                                                        foreach($subComment['PostCommentLike'] as $pCLD){
                                                                                            $cntLike = $cntLike+$pCLD['post_like'];
                                                                                            $cntdisLike = $cntdisLike+$pCLD['post_dislike'];
                                                                                        }    
                                                                                    } ?>
                                                                                    <a class="like-icn" href="javascript:void(0);"></a>(<?php echo $cntLike; ?>)
                                                                                    <a class="dislike-icn" href="javascript:void(0);"></a>(<?php echo $cntdisLike; ?>)
                                                                            </span>
                                                                            
                                                                        </section>
                                                                    <!--</section>-->
                                                                     </section>
                                                               <?php
                                                               //pr($subComment);
                                                               }
                                                            }
                                                            ?>
                                                            
                                                            
                                                        </section>
                                                    </li>
                                                <?php
                                                //pr($theComment);
                                                }?>
                                            </ul>
                                        <?php }?>
                                   </section>
                                    <section class="row gifIndicator text-center">
                                        <img class="ajax-loader" src="/img/ajax-loader.GIF" />
                                    </section>
                                    <section class="more-stories-row">
                                    	<p class="loadmore"><a href="javascript:void(0);">Load more stories <i class="caret"></i></a></p>
                                    </section>
                                <!--user-profile-comment-end-->
                                
                            </section>
            </div>
                        <!--Post Description Closed-->
                       
                        
                        
                  </section>
                    <!--Left Closed-->
                    
                    <!--Right Start-->
                    <section class="col-sm-4">                        
                        <!--Related Content Start-->
                        <section class="col-sm-12 relatedcon relatedcon2">
                          <div class="add-block">
                       	    	<a href="javascript:void(0)">
                                 <?php echo $this->Html->image('add-pic1.png'); ?>   </a>
                            </div>  
                            
                        </section>
                        <!--Related Content Closed-->
                    </section>
                    <!--Right Closed-->
                </section>
            </section>
            <!--Content Closed-->
               
          
        </section>
        <!--Wrapper Closed-->

    