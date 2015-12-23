<div class="modal-dialog">
        <section class="popup">
            <section class="modal-dialog">
                <section class="modal-content">
                        <section class="modal-header">
                        <button type="button" class="close close-btn" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h2 class="modal-title" id="myModalLabel">
                        <?php echo $content['Content']['title']; ?> </h2>
                        </section>              
                        <section class="modal-body">
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
                                 <span class="post-time"><strong><?php if(!empty($users)) {echo $users['User']['first_name'];}
				?></strong></span>
                             </section><!-- / col-lg-4 -->
			                                <section class="col-lg-8 col-sm-12">
                                    <h2 class="heading"> 
					<section>
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
                                         
                                        </section>
					</h2>
                           </section><!-- / col-lg-8 -->
                        </section>
                               
                                 <?php echo $this->element('post'); ?>  
                                
                    </section>
                            
                            
                              
                    <section class="modal-footer">
                        <button id="preview_post" class="btn button"><i class="fa fa-upload font16"></i> <span>Post</span></button>
                    </section>
                </section>
            </section>
        </section>
        <!-- /.modal-content -->
    </div>     