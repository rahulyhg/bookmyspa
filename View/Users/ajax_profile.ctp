                        <section class="ajax_profile">
                        <div class="profile-post-row clearfix">
                               <h3><a href="<?php echo BASE_URL.'post/'.$content['Content']['id']; ?>"><?php echo $content['Content']['title'];?></a></h3>
                                        <section class="comment-date"> <?php
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
										}
								?>
                                        </section>
                                    </div>  
                    					<!--Post Text Start-->
                    <?php echo $this->element('profile_post'); ?>
		    <!--Post Poll Section End Here-->
                    <!--Bottom Section Start-->
                    <!--Bottom Section Closed-->
                </section>