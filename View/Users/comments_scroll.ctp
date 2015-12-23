<?php if(!empty($commentData)){ ?>
                                                <?php foreach($commentData as $theComment){ ?>
                                                    <li>
                                                        <section class="user-comment-head clearfix">
                                                            <section class="col-sm-9 postrow">
                                                                <span class="userpic">
                                                                <?php if(!empty($theComment['User']['avatar_image'])){
									if(filter_var($theComment['User']['avatar_image'], FILTER_VALIDATE_URL)){
                                                                        echo $this->Html->image($theComment['User']['avatar_image'], array('alt' => '', 'url' => array('controller' => 'users', 'action' => 'profile_post',$theComment['User']['id'] )));
                                                                        }else{
                                                                        echo $this->Html->image('/img/avatar/'.$theComment['User']['avatar_image'], array('alt' => '', 'url' => array('controller' => 'users', 'action' => 'profile_post',$theComment['User']['id'] )));
                                                                        }
									}else{
						    			echo $this->Html->image('/img/avatar/no_image.png', array('alt' => '', 'url' => array('controller' => 'users', 'action' => 'profile_post',$theComment['User']['id'] )));
                                                                        } ?>
                                                               
                                                                <span class="post-time"><a href="<?php echo $this->Html->url(array("controller" => "users","action" => "profile_post",$theComment['User']['id'])); ?>"><strong><?php echo ucfirst($theComment['User']['first_name']." ".$theComment['User']['last_name']);?></strong></a> Commented on :</span>
                                                                <span class="comment-on"><a href="<?php echo BASE_URL.'post/'.$theComment['Content']['id']; ?>" ><strong><?php echo $theComment['Content']['title']; ?></strong></a> </span>
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
<!--                                                            <section class="user-reply">
                                                                <span class="reply-text">
                                                                        <a href="#">Reply</a>
                                                                </span>
                                                                <span class="reply-icon">
                                                                        <?php
//                                                                        $cntLike = 0;
//                                                                        $cntdisLike = 0;
//                                                                        if(!empty($theComment['PostCommentLike'])){
//                                                                            foreach($theComment['PostCommentLike'] as $pCLD){
//                                                                                $cntLike = $cntLike+$pCLD['post_like'];
//                                                                                $cntdisLike = $cntdisLike+$pCLD['post_dislike'];
//                                                                            }    
//                                                                        } ?>
                                                                        <a class="like-icn" href="javascript:void(0);"></a>(<?php echo $cntLike; ?>)
                                                                        <a class="dislike-icn" href="javascript:void(0);"></a>(<?php echo $cntdisLike; ?>)
                                                                </span>
                                                                
                                                            </section>-->
                                                            
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
                                                                                      echo $this->Html->image($subComment['User']['avatar_image'], array('alt' => '', 'url' => array('controller' => 'users', 'action' => 'profile_post',$subComment['User']['id'] )));
                                                                                    }else{
                                                                                    echo $this->Html->image('/img/avatar/'.$subComment['User']['avatar_image'], array('alt' => '', 'url' => array('controller' => 'users', 'action' => 'profile_post',$subComment['User']['id'] )));
                                                                                    }
                                                                                    }else{
                                                                                    echo  $this->Html->image('/img/avatar/no_image.png', array('alt' => '', 'url' => array('controller' => 'users', 'action' => 'profile_post',$subComment['User']['id'] )));
                                                                                    } ?>
                                                                            <span class="post-time"><a href="<?php echo $this->Html->url(array("controller" => "users","action" => "profile_post",$subComment['User']['id'])); ?>"><strong><?php echo ucfirst($subComment['User']['first_name']." ".$subComment['User']['last_name']);?></strong></a> </span>
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
<!--                                                                        <section class="user-reply">
                                                                            <span class="reply-text">
                                                                                    <a href="#">Reply</a>
                                                                            </span>
                                                                            <span class="reply-icon">
                                                                                    <?php
//                                                                                    $cntLike = 0;
//                                                                                    $cntdisLike = 0;
//                                                                                    if(!empty($subComment['PostCommentLike'])){
//                                                                                        foreach($subComment['PostCommentLike'] as $pCLD){
//                                                                                            $cntLike = $cntLike+$pCLD['post_like'];
//                                                                                            $cntdisLike = $cntdisLike+$pCLD['post_dislike'];
//                                                                                        }    
//                                                                                    } ?>
                                                                                    <a class="like-icn" href="javascript:void(0);"></a>(<?php echo $cntLike; ?>)
                                                                                    <a class="dislike-icn" href="javascript:void(0);"></a>(<?php echo $cntdisLike; ?>)
                                                                            </span>
                                                                            
                                                                        </section>-->
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
                                        <?php }?>