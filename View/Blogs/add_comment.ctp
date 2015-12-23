<?php if(count($comment['BlogComment'])){ ?>
<div class="row">
                    <div class="col-sm-12 pdng-bt40 brdr-btm1">
                        <div class="col-sm-2">
                           <div class="blog-image">
                                <!--<img src="/img/dummy/user-img.png"/>-->
			        <?php
					if (filter_var($comment['User']['image'], FILTER_VALIDATE_URL) === FALSE) {
		                            echo $this->Html->image('/img/avatar/' . $comment['User']['image']);
		                        }else{
                                             if(isset($comment['User']['image']) && !empty($comment['User']['image']) ){
						echo $this->Html->image("/images/".$comment['User']['id']."/User/150/".$comment['User']['image'],array('data-id'=>$comment['User']['id'],'class'=>'img-responsive'));
					    }else{
						echo $this->Html->image("admin/upload2.png",array('class'=>'','data-id'=>$comment['User']['id']));
					    }
					}
				?>
			   </div>
                        </div>
                        <div class="col-sm-10">
			    <div class="first-content pdng-bt30">
                                <span><strong><?php echo $comment['User']['first_name'].' '.$comment['User']['last_name']; ?></strong></span>
                                <p><?php echo date('d M Y,h.iA',strtotime($comment['BlogComment']['created'])); ?></p>
                                <p><?php echo $comment['BlogComment']['eng_comment']; ?> </p>
                            </div>
			</div>
		    </div>
                </div>

<?php } ?>
