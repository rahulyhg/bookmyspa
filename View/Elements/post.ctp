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
<!--Post Text Start-->
					
                    <!--Post Text Closed-->
					<?php //$content_indexvalue = array_unique($indexvalue);
							//debug($CCC);
						  foreach ($CCC as $content_order_ids){
								foreach ($content_order_ids as $key=>$val){
					      //foreach($content_indexvalue as $content_data){ debug($content_data);
                                 if(ucfirst($key) == "Text"){ 
											$post_text=$this->Common->getTextofPost($val);
                                   if(!empty($post_text)) { 
											  ?>
						<div class="post-des video-add">
							<section class="col-lg-12 no-pad">
								<section class="quiz-middle post-description-info">
                           <?php 
							$text = ucfirst(($post_text['Text']['text']));
							$regex = '/https?\:\/\/[^\" ]+/i';
							//$regex =  "http|ftp|scp)(s)?:\/\/[a-zA-Z0-9.?&_/]+!";
							preg_match_all($regex, $text, $matches);
							if(count($matches)){
							foreach($matches[0] as $match){
							 $url =  parse_url($match);
							 $host =  $url['host'];
							if($host == 'www.facebook.com' ||$host =='facebook.com' ){
								$rep_link_fb = '<div class="text-center" ><div class="fb-post" data-href="'.str_replace("<br","" , $match).'" data-width="500"></div></div><br';
								$text =   str_replace(trim($match),trim($rep_link_fb),$text);
							   }elseif($host=='twitter.com' ||$host=='www.twitter.com'){
								$rep_link_twitter = '<blockquote class="twitter-tweet tw-align-center"><a href="'.$match.'" target="_blank" rel="nofollow"></a></blockquote><br';   
								$text =  str_replace($match,$rep_link_twitter,$text);
							 }
							}
							   }
							 echo $text;  ?>
								</section>
							</section>
						</div>
					<?php
					}else{
						echo '';
					}
					?>   
                                                  
                                            <?php } ?>    
						<?php 	 if(ucfirst($key) == "Slide"){ ?>
					<div class="col-xs-12 gallery-col">
                       	  <div class="home-slider-block" id="slider">
						  	<?php $slideItems=$this->Common->getAllSlideItemBySlide($content['Content']['id']); 
									if(!empty($slideItems)){?>
                          	<ul class="home-slider">
								<?php foreach($slideItems as $slideItem){?>
                            	<li>
                                	<div class="galllery-big-thumb2">
									<div class="galllery-thumb-ttl">
                            	<h2><?php if(!empty($slideItem['SlideItem']['title'])){echo $slideItem['SlideItem']['title'];}else{ echo '';} ?></h2>
                            </div>
                            	<img src="/img/slide/original/<?php echo $slideItem['SlideItem']['image'];?>" title="">
                            </div>
                          			<section class="big-thumb-strip2">
                                	
                                    	<p><?php if(!empty($slideItem['SlideItem']['caption'])){echo $slideItem['SlideItem']['caption'];}else{ echo '';}?></p>
                                   
                                </section>
                                </li>
                               <?php }  ?> 
                            </ul>
							<div class="galllery-thumb-ttl galllery-thumb-ttl-b"><a href="javascript:void(0)" class="control_prev"> Prev</a> <a href="javascript:void(0)" class="control_next">Next</a>
							</div>
							<?php }  ?>
                          </div>
                        </div>
					<?php } ?>
                    <!-- Post Share Row Closed-->
					<?php if(ucfirst($key) == "Photo"){ 
							$photos=$this->Common->getPhotofPost($val);
					        if(!empty($photos)){ ?>
                        <div class="post-des video-add">
                            <section class="col-lg-12 no-pad">
                                <section class="quiz-middle">
                                    <p>
                                        <?php
												if ($photos['Photo']['image_type'] == 'file') {
													$image_name = $photos['Photo']['image'];
                                                                                                        echo $this->HTML->image('photos/original/'.$image_name);
													//echo '<img src=/img/photos/original/'.$image_name.'>';
												} else {
													$image_name = $photos['Photo']['image'];
													echo '<img src=' . $image_name . '>';
												}
											
											//if (!empty($content['Photo'][0]['image'])) {
											//
											//	if ($content['Photo'][0]['image_type'] == 'file') {
											//		$image_name = $content['Photo'][0]['image'];
											//		echo '<img src=/img/photos/original/' . $image_name . '>';
											//	} else {
											//		$image_name = $content['Photo'][0]['image'];
											//		echo '<img src=' . $image_name . '>';
											//	}
											//} else {
											//	echo '<img src=/img/photos/original/soccer-ball-128.png>';
											//}
										?>
                                    </p>
									
                                </section>
                            </section>
                        </div>
                    <?php }else{ echo ''; } } ?>
                    <!--Post Photo Closed-->

                    <!--Post meme Start-->
					<?php 
					  if(ucfirst($key) == "Meme"){ 
					  $post_memes=$this->Common->getMemeofPost($val);
					    if(!empty($post_memes)){ ?>
                          <div class="post-des video-add">
					<?php
					$memeimage = $this->Common->getMemeImages($post_memes['Meme']['meme_image_id']);
					?>
                            <section class="col-lg-12 no-pad">
                                <section class="quiz-middle">
									<p class="list_text">
									<section class="meme-mainpic new_m-pic">
                                       <div class="col-sm-6 col-sm-offset-3">
									<?php
										if (!empty($memeimage['MemeImage']['image'])) {
											$image_name = $memeimage['MemeImage']['image'];
                                echo  $this->Html->image('meme/original/'.$image_name);         
											//echo '<img src=/img/meme/original/'.$image_name.'>';
										} else {
											echo '<img src=/img/meme/original/soccer-ball-512.png>';
										}
									?>
									<p class="uppertext"><span id="uppertext_text"><?php echo $content['Meme'][0]['header_text']; ?></span></p>

                                <p class="lowertext"><span id="lowertext_text"><?php echo $content['Meme'][0]['footer_text']; ?></span></p> </div>
								</section>
                                </section>
                            </section>
                        </div>
					<?php }else{ echo '';} } ?>
                    <!--Post meme Closed-->
                    <!--Post Lineup Start-->
                     <?php 
					  if(ucfirst($key) == "Lineup"){
                   $lineups = $this->Common->getLineupofPost($val);					  
					     if(!empty($lineups)){ ?>
                        <div class=" post-des video-add">
                            <section class="col-lg-12 no-pad">
							
                                <div class="post-list-block">
                                    <section class="lineupcontent clearfix">
                                        <section class="lineupwidget">
                                           <?php
												$lineup_class = 'lineup1';
												$lineup_items = $this->Common->getALineupItem($lineups['Lineup']['id']);
												$players = json_decode($lineup_items['LineupItem']['players']);
												$lineup_class = $lineup_items['LineupItem']['lineup_class'];
											?>
                                            <section class="ground-surface <?php echo $lineup_class; ?>">
                                             <?php
											   if(!empty($players)) {
												  $key = 0;
												  foreach ($players as $position => $player){?>
													<span data-original-title="<?php echo $player->name;?>" id="tol<?php echo $key + 1;?>" class="custom-tooltip  pos<?php echo $key + 1;?> tootltip-info">
													<div class="tooltip top fade in" role="tooltip">
													<div class="tooltip-arrow"></div>
													<div class="tooltip-inner">
													 <?php echo $player->name;?>
													</div>
													</div>
													<span class="player-pos">
												   <?php echo $player->number;?>
													</span></span>
													<?php
                                        $key++;
                                         }
                                        }else{
														 for($i = 0; $i < 11; $i++){ ?>
                                                        <span data-original-title="<?php echo $player->name;?>" id="tol<?php echo $key + 1;?>" class="custom-tooltip  pos<?php echo $key + 1;?> tootltip-info">
														<div class="tooltip top fade in" role="tooltip">
														<div class="tooltip-arrow"></div>
														<div class="tooltip-inner">
														 <?php echo $player->name;?>
														</div>
														</div>
														<span class="player-pos">
													   <?php echo $player->number;?>
														</span></span>
									<?php } } ?>
                                            </section>
                                        </section>

                                    </section>
                                </div>
                            </section>
                        </div>
                        <?php }else{ echo '';} } ?>
                    <!--Post Lineup End-->
                    <!--Post Description Start-->
				<?php if(ucfirst($key) == "ContentList"){ 
				  $contentlists=$this->Common->getContentListofPost($val);
				   if (!empty($contentlists)){ ?>
                        <div class=" post-des video-add">
				<?php
				if (!empty($content)){
					$cnt = 1;
					$listitems = $this->Common->getListsItem($contentlists['ContentList']['id']);
					foreach ($listitems as $data){ ?>
						<section class="col-lg-12 no-pad">
							<section class="quiz-middle">
								<section class="list">

									<div class="media">
										<div class="red_box_text"><?php echo $cnt; ?></div>

										<div class="media-body">
											<div class="quiz-cont">
												<p><?php echo $data['ListsItem']['title']; ?></p>
											</div>
										</div>
									</div>
								</section>
								<p>
					 <?php
							if (!empty($data['ListsItem']['image'])){
								$image_name = $data['ListsItem']['image'];
								echo '<img src=/img/lists/original/'.$image_name.'>';
							} else {
								echo '<img src=/img/photos/original/soccer-ball-512.png>';
							}
					?>
                      </p><p class="list_text"><?php
                   if(!empty($data['ListsItem']['caption'])){					  
					       echo $data['ListsItem']['caption'];
						  }
						 ?>
					  </p>
						</section>
					</section>
				    <?php $cnt++;} } ?>
					</div>
					<?php
					}else{echo '';} }
					?>
                    <!--Post Description Closed-->
                    <!--Post Video Start-->
				<?php 
				   if(ucfirst($key) == "Video"){ //echo 'Video---'.$val;
                $videos=$this->Common->getVideoofPost($val);				   
					  if(!empty($videos)){ ?>
                        <div class="post-des video-add">
                            <section class="col-lg-12 no-pad">
                                <section class="quiz-middle">
								 <?php $video_type=$this->Common->url_to_domain($videos['Video']['video_url']);
										if($video_type == 'facebook.com' || $video_type == 'www.facebook.com'){
										parse_str( parse_url($videos['Video']['video_url'], PHP_URL_QUERY ),$params);
										$facebook_video_id = $params['v']; 
										?>
                                    <div class="video-block">
										<iframe width="100%" height="315" frameborder="0" allowfullscreen src="http://www.facebook.com/video/embed?video_id=<?php echo $facebook_video_id; ?>" ></iframe>
										<!--object width="100%" height="315" ><param name="allowfullscreen" value="true" /><param name="movie" value="http://www.facebook.com/v/<?php echo $facebook_video_id; ?>" /><embed src="http://www.facebook.com/v/<?php echo $facebook_video_id; ?>" type="application/x-shockwave-flash" allowfullscreen="true" width="100%" height="315"></embed></object--> 
										
                                    </div>
									<?php } else if($video_type == 'youtube.com' || $video_type == 'www.youtube.com'){
										parse_str( parse_url($videos['Video']['video_url'], PHP_URL_QUERY ),$params);
										if(!empty($params)){$youtube_video_id = $params['v'];}else{$youtube_video_id ='';} 
									?>
									 <div class="video-block preview_videoc">
									<p><iframe width="100%" height="315" frameborder="0" allowfullscreen="" src="https://www.youtube.com/embed/<?php echo $youtube_video_id; ?>"></iframe> </div>
									
								    <?php } else if($video_type == 'dailymotion.com' || $video_type == 'www.dailymotion.com'){?>
									 <div class="video-block preview_videoc">
										<?php $url = $videos['Video']['video_url'];
									      $dvideo_id = strtok(basename($url), '_'); 
										?>
						<iframe frameborder="0" width="100%" height="315" src="//www.dailymotion.com/embed/video/<?php echo $dvideo_id;?>" allowfullscreen></iframe><br /><a href="<?php echo $url;?>" target="_blank"></a> <i>by <a href="http://www.dailymotion.com/itnnews" target="_blank">itnnews</a></i></div>
									<?php }else if($video_type == 'rutube.ru' || $video_type == 'www.rutube.ru'){?>
									 <div class="video-block preview_videoc">
										<?php $url = $videos['Video']['video_url']; 
									      $rutube_video_id = strtok(basename($url), '_'); 
										?>
						<iframe width="100%" height="315" src="//rutube.ru/play/embed/<?php echo $rutube_video_id;?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe></div>
									<?php } else if($video_type == 'instagram.com' || $video_type == 'www.instagram.com'){?>
									 <div class="video-block_instagrom preview_videoc">
										<?php
										 $url = $videos['Video']['video_url']; 
									       $instagram_video_id =basename($url);
										  //$instagram_video_id='1sVvXEV';
										?>
										<iframe width="100%" height="100%" src="http://instagram.com/p/<?php echo $instagram_video_id; ?>/embed" frameborder="0" ></iframe></div>
									<?php } else if($video_type == 'vk.com' || $video_type == 'www.vk.com'){?>
									 <div class="video-block preview_videoc">
										<?php $vk_url = $videos['Video']['video_url']; 
									      preg_match('/src="([^"]+)"/',$vk_url, $match); 
											if(!empty($vk_url)){$vk_video_url = $match[1];}else{$vk_video_url ='';} 
										?>
										<iframe width="100%" height="315" src="<?php echo $vk_video_url;?>" frameborder="0"></iframe></div>
									<?php } else if($video_type == 'vine.co' || $video_type == 'www.vine.co'){?>
									 <div class="video-block preview_videoc">
									      <?php 
									      $vine_video_id  = strtok(basename($videos['Video']['video_url']), '_'); 
										   
										?> 
										<iframe width="100%" height="315" src="https://vine.co/v/<?php echo $vine_video_id;?>/embed/simple" frameborder="0"></iframe></div>	
										<?php } ?>		
										
                                </section>
                            </section>
                        </div>
					<?php
					}else{ echo '';} 
					} 
					?>
                    <!--Post Video Closed-->
					<!--Post Quiz Section Start Here-->
					<?php 
				   if(ucfirst($key) == "Quiz"){  
				   $quizs=$this->Common->getQuizofPost($val);
					  if(!empty($quizs)){ $quizID=$quizs['Quiz']['id'];
					  $qtnId = $this->Common->getAQuizQuestion($quizID);
					  if(!empty($qtnId)){
					  $qsnID=$qtnId['QuizQuestion']['id'];
					  }else{$qsnID='';}?>
					<div class="post-des video-add" id="quizpreviewdivid">
                        <p style="margin-left:15px;"><?php echo $quizs['Quiz']['title'];?></p>
                        	<section class="col-lg-6">
							 <?php
								if (!empty($quizs['Quiz']['image'])){
									$image_name = $quizs['Quiz']['image'];
									echo '<img src=/img/quiz/original/'.$image_name.'>';
								} else {
									echo '';
								}
							 ?>
							</section>
                            <section class="col-lg-6 font16">
								<p class="des-text">
										<?php echo $quizs['Quiz']['description'];?>
								</p> 
                            <p class="m-btm0"><a class="btn btn-blue bl-element" href="javascript:void(0)" onclick="showquizpreview(<?php echo $qsnID.','.$quizID;?>)">Let's Start</a></p></section>
                       </div>
					   <?php
					}else{ echo '';} 
					} 
					?>
					<!--Post Quiz Section End Here-->
					<!--Post Poll Section Start Here-->
					<?php 
				   if(ucfirst($key) == "Poll"){ 
                $post_polls=$this->Common->getPollofPost($val);				   
					  if(!empty($post_polls)){ 
					  $poll_id=$post_polls['Poll']['id'];
					  $pollqtns=$this->Common->getAllPollQuestion($poll_id); 
					  //debug($pollqtns);
					  if(!empty($pollqtns)){ foreach($pollqtns as $pollqtn){
						$poll_question_id=$pollqtn['PollQuestion']['id'];
					  ?>
					<div class="post-des video-add post-des-custom">
                        	<section class="col-lg-12 no-pad">
                                <section class="quiz-middle">
                                	<p>
									<?php
										if (!empty($pollqtn['PollQuestion']['image'])){
											$image_name = $pollqtn['PollQuestion']['image'];
											echo '<img src=/img/polls/original/'.$image_name.'>';
										} else {
											echo '<img src=/img/polls/original/poll_no_image.png>';
										}
								  ?>
									</p>
                                    <p class="quiz-qus"><?php echo $pollqtn['PollQuestion']['question'];?></p>
                                </section>
								<?php if(!empty($pollqtn['PollAnswer'])){ foreach($pollqtn['PollAnswer'] as $poll_answer){
								$poll_answer_id=$poll_answer['id'];?>
                                <section class="quiz-ans">
									<?php if(!empty($checkguestdata)){
											  $showall='';
											  $show_button='style="display:none"';
											  $disable = "disablefnt";
											 }else{
											  $showall='style="display:none"';
											  $show_button='';
											  $disable='';
											 }
									 ?>
                                	<section class="quizans transition <?php echo $disable;?>"  onClick="savepollpreview(<?php echo $poll_id.','.$poll_question_id.','.$poll_answer_id;?>)">
                                    	
                                        <div class="media">
                                              <a href="javascript:void(0)" class="pull-left quiz-img">
											   <?php
													if (!empty($poll_answer['image'])){
														$image_name = $poll_answer['image'];
														echo '<img src=/img/polls/thumb/'.$image_name.' class="media-object">';
													}else{
														echo '';
													}
											  ?>
                                              </a>
                                              <div class="media-body">
                                              <div class="quiz-cont">
                                               <p><?php echo $poll_answer['answer'];?></p>
                                               <button class="btn button pull-right vote_btn"  <?php echo $show_button;?> type="button" onClick="savepollpreview(<?php echo $poll_id.','.$poll_question_id.','.$poll_answer_id;?>)">Vote</button>
											  
											   <p class="pollpercentages" <?php echo $showall;?> id="totalpollans<?php echo $poll_answer['id'];?>">
											   <?php $total_pollans=$this->Common->getTotallAnswersPoll($poll_id,$poll_question_id,$poll_answer_id); 
												$total_pollan = explode(',',$total_pollans);
											   echo $total_pollan[0].' '.$total_pollan[1];$total_pollan[0]='';$total_pollan[1]='';?>
											   </p>
                                               </div>
                                              </div>
                                            </div>
                                    </section>
                                </section>
								<?php } } ?>
                            </section>
						</div>
					<?php } }
						}else{ echo '';} 
						} } }
					?>
					<!--Post Poll Section End Here-->
