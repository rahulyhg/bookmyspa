<div class="modal-dialog">
        <section class="popup">
            <section class="modal-dialog">
                <section class="modal-content">
                        <section class="modal-header">
                        <button type="button" class="close close-btn" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h2 class="modal-title" id="myModalLabel">Post Preview</h2>
                        </section>              
                        <section class="modal-body">
                        <section class="">
                        <h2 class="heading">Post 
					
					<div class="heading-img-gallery">
						<ul>
						 <?php $indexvalue = array_unique($indexvalue);
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
              
                    
                    
					<!--Post Text Start-->
					<?php if (!empty($content['Text'])) { ?>
						<div class="row post-des">
							<section class="col-lg-12">
								<section class="quiz-middle">
									<p class="list_text"><?php echo $content['Text'][0]['text']; ?> </p>
								</section>
							</section>
						</div>
					<?php
					} else {
						echo '';
					}
					?>
                    <!--Post Text Closed-->
					<?php $content_indexvalue = array_unique($indexvalue);
					      foreach($content_indexvalue as $content_data){ //debug($dataa);
							 if($content_data == "Slide"){ ?>
					<div class="col-xs-12 gallery-col">
                       	  <div class="home-slider-block">
						  	<?php $slideItems=$this->Common->getAllSlideItemBySlide($content['Content']['id']); 
									if(!empty($slideItems)){?>
                          	<ul class="home-slider">
								<?php foreach($slideItems as $slideItem){?>
                            	<li>
                                	<div class="galllery-big-thumb">
									<div class="galllery-thumb-ttl">
                            	<h2><?php if(!empty($slideItem['SlideItem']['title'])){echo $slideItem['SlideItem']['title'];}else{ echo '';} ?></h2>
                            </div>
                            	<img src="/img/slide/original/<?php echo $slideItem['SlideItem']['image'];?>" title="">
                            </div>
                          			<section class="big-thumb-strip">
                                	<section class="big-thumb-rw">
                                    	<p><?php if(!empty($slideItem['SlideItem']['caption'])){echo substr($slideItem['SlideItem']['caption'],0,100).'...';}else{ echo '';}?></p>
                                    </section>
                                </section>
                                </li>
                               <?php }  ?> 
                            </ul>
							<?php }  ?>
                          </div>
                        </div>
					<?php } ?>
                    <!-- Post Share Row Closed-->
					<?php if($content_data == "Photo"){ 
					        if(!empty($content['Photo'])){ ?>
                        <div class="row post-des">
                            <section class="col-lg-12">
                                <section class="quiz-middle">
                                    <p>
                                        <?php
											if (!empty($content['Photo'][0]['image'])) {

												if ($content['Photo'][0]['image_type'] == 'file') {
													$image_name = $content['Photo'][0]['image'];
													echo '<img src=/img/photos/original/' . $image_name . '>';
												} else {
													$image_name = $content['Photo'][0]['image'];
													echo '<img src=' . $image_name . '>';
												}
											} else {
												echo '<img src=/img/photos/original/soccer-ball-128.png>';
											}
										?>
                                    </p>
                                </section>
                            </section>
                        </div>
                    <?php }else{ echo ''; } } ?>
                    <!--Post Photo Closed-->

                    <!--Post meme Start-->
					<?php 
					  if($content_data == "Meme"){ 
					    if(!empty($content['Meme'])){ ?>
                          <div class="row post-des">
					<?php
					$memeimage = $this->Common->getMemeImages($content['Meme'][0]['meme_image_id']);
					?>
                            <section class="col-lg-12">
                                <section class="quiz-middle">
									<p class="list_text">
									<section class="meme-mainpic">
									<?php
										if (!empty($memeimage['MemeImage']['image'])) {
											$image_name = $memeimage['MemeImage']['image'];
											echo '<img src=/img/meme/original/' . $image_name . ' style=padding-left:200px;>';
										} else {
											echo '<img src=/img/meme/original/soccer-ball-128.png style="padding-left:200px;">';
										}
									?>
									<p class="uppertext"><span id="uppertext_text" class="meme_image_text"><?php echo $content['Meme'][0]['footer_text']; ?></span></p>

                                <p class="lowertext"><span id="lowertext_text" class="meme_image_text"><?php echo $content['Meme'][0]['footer_text']; ?></span></p>
								</section>
                                </section>
                            </section>
                        </div>
					<?php }else{ echo '';} } ?>
                    <!--Post meme Closed-->
                    <!--Post Lineup Start-->
                     <?php 
					  if($content_data == "Lineup"){ 
					     if(!empty($content['Lineup'])){ ?>
                        <div class="row post-des">
                            <section class="col-lg-12">
                                <div class="post-list-block">
                                    <section class="lineupcontent clearfix">
                                        <section class="lineupwidget">
                                           <?php
												$lineup_class = 'lineup1';
												$lineup_items = $this->Common->getALineupItem($content['Lineup'][0]['id']);
												$players = json_decode($lineup_items['LineupItem']['players']);
												$lineup_class = $lineup_items['LineupItem']['lineup_class'];
											?>
                                            <section class="ground-surface <?php echo $lineup_class; ?>">
                                             <?php
											   if(!empty($players)) {
												  $key = 0;
												  foreach ($players as $position => $player){?>
													<span data-original-title="<?php echo $player->name; ?>" class="player-pos pos<?php echo $key + 1; ?> tootltip-info"><?php echo $player->number; ?></span>
													<?php
                                        $key++;
                                         }
                                        }else{
														 for($i = 0; $i < 11; $i++){ ?>
                                                        <span data-original-title="Player Name" class="player-pos pos<?php echo $i + 1; ?> tootltip-info"><?php echo $i + 1; ?></span>
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
				<?php if($content_data == "ContentList"){ 
				   if (!empty($content['ContentList'])) { ?>
                        <div class="row post-des">
				<?php
				if (!empty($content)){
					$cnt = 1;
					$listitems = $this->Common->getListsItem($content['ContentList'][0]['id']);
					foreach ($listitems as $data){ ?>
						<section class="col-lg-12">
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
								echo '<img src=/img/photos/original/soccer-ball-128.png>';
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
				   if($content_data == "Video"){  
					  if(!empty($content['Video'])){ ?>
                        <div class="row post-des">
                            <section class="col-lg-12">
                                <section class="quiz-middle">
                                    <div class="video-block">
                                        <?php foreach($content['Video'] as $data){
										echo $data['video_url'].'<br>';
										}?>
                                    </div>
                                </section><!--/ Quiz List-->
                            </section>
                        </div>
					<?php
					}else{ echo '';} 
					} 
					?>
                    <!--Post Video Closed-->
					<!--Post Quiz Section Start Here-->
					<?php 
				   if($content_data == "Quiz"){  
					  if(!empty($content['Quiz'])){ ?>
					<div class="row post-des">
                        <p style="margin-left:15px;"><?php echo $content['Quiz'][0]['title'];?></p>
                        	<section class="col-lg-6">
							 <?php
								if (!empty($content['Quiz'][0]['image'])){
									$image_name = $content['Quiz'][0]['image'];
									echo '<img src=/img/quiz/original/'.$image_name.'>';
								} else {
									echo '';
								}
							 ?>
							</section>
                            <section class="col-lg-6 font16">
								<p class="des-text">
										<?php echo $content['Quiz'][0]['description'];?>
								</p> 
                            <p class="m-btm0"><a class="btn btn-blue bl-element" href="/contents/quizpreview/759">Let's Start</a></p></section>
                       </div>
					   <?php
					}else{ echo '';} 
					} 
					?>
					<!--Post Quiz Section End Here-->
					<!--Post Poll Section Start Here-->
					<?php 
				   if($content_data == "Poll"){  
					  if(!empty($content['Poll'])){ 
					  $poll_id=$content['Poll'][0]['id'];
					  $pollqtns=$this->Common->getAllPollQuestion($poll_id); 
					  if(!empty($pollqtns)){ foreach($pollqtns as $pollqtn){
						$poll_question_id=$pollqtn['PollQuestion']['id'];
					  ?>
					<div class="row post-des">
                        	<section class="col-lg-12">
                                <section class="quiz-middle">
                                	<p>
									<?php
										if (!empty($pollqtn['PollQuestion']['image'])){
											$image_name = $pollqtn['PollQuestion']['image'];
											echo '<img src=/img/polls/original/'.$image_name.'>';
										} else {
											echo '';
										}
								  ?>
									</p>
                                    <p class="quiz-qus"><?php echo $pollqtn['PollQuestion']['question'];?></p>
                                </section>
								<?php if(!empty($pollqtn['PollAnswer'])){ foreach($pollqtn['PollAnswer'] as $poll_answer){
								$poll_answer_id=$poll_answer['id'];?>
                                <section class="quiz-ans">
                                	<section class="quizans transition">
                                    	
                                        <div class="media">
                                              <a href="javascript:void(0)" class="pull-left quiz-img">
                                                <?php
													if (!empty($poll_answer['image'])){
														$image_name = $poll_answer['image'];
														echo '<img src=/img/polls/thumb/'.$image_name.' class="media-object">';
													} else {
														echo '';
													}
											  ?>
                                              </a>
                                              <div class="media-body">
                                              <div class="quiz-cont">
                                               <p><?php echo $poll_answer['answer'];?></p>
                                               <button class="btn button pull-right vote_btn" type="button" onClick="savepollpreview(<?php echo $poll_id.','.$poll_question_id.','.$poll_answer_id;?>)">Vote</button>
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
						} }
					?>
               </section>
                    <section class="modal-footer">
                        <button id="preview_post" class="btn button"><i class="fa fa-upload font16"></i> <span>Post</span></button>
                    </section>
                </section>
            </section>
        </section>
        <!-- /.modal-content -->
    </div>     