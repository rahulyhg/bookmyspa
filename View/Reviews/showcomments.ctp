<?php echo $this->Html->script('frontend/star-rating.js?v=1'); ?>
<?php echo $this->Html->css('frontend/star-rating.css?v=1'); ?>
<style type="text/css">
    .modal-dialog.gift_certificate_width{
	width: 80% !important
    }
</style>
<div class="modal-dialog gift_certificate_width">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
                Review
            </h3>
        </div>
        <div class="modal-body clearfix">
            <div class="box">
                <div class="box-content" id="printingDiv">
                    <div class="col-sm-12">
                        <?php foreach($orders as $order) { ?>
                            <div class="reviewer-section">
                                <div class="lft">
                                    <div class="user-img">
                                        <?php
                                        if(isset($order['User']['image']) && !empty($order['User']['image']) ){
                                            echo $this->Html->image("/images/".$order['User']['id']."/User/150/".$order['User']['image'],array('data-id'=>$order['User']['id']));
                                        }else{
                                            echo $this->Html->image("admin/upload2.png",array('class'=>'','data-id'=>$order['User']['id']));
                                        }?>
                                    </div>
                                    <div class="name"><?php echo $order['User']['first_name'].''. $order['User']['last_name']; ?></div>
                                    <div class="add"><?php echo $this->common->getCity($order['Address']['city_id']); ?></div>
                                    
                                </div>
                                <div class="rgt bod-btm-non">
                                    <h3><?php echo $order['SalonService']['eng_name']; ?>
                                        <span>Reviewed <?php echo date('d F Y',strtotime($order['ReviewRating']['created'])); ?></span>	
                                    </h3>
                                    <div class="rating-area">
                                        <section>
                                            <label>Venue: </label>
                                            <?php echo $this->Form->input('', array('div'=>false,'label' => '', 'class' => 'rating fa-star','type'=>'text','data-size'=>'','data-readonly'=>'true','data-show-clear'=>'false','data-show-caption'=>'false','glyphicon'=>false,'rating-class'=>'fa fa-star','value'=>$order['ReviewRating']['venue_rating'])); ?>
                                            <label>Message: </label>
                                        </section>
                                        <section>
                                            <div class="stylist-rating">
                                                <?php
                                                if(isset($order['Provider']['image']) && !empty($order['Provider']['image']) ){
                                                    echo $this->Html->image("/images/".$order['Provider']['id']."/User/150/".$order['Provider']['image'],array('data-id'=>$order['Provider']['id']));
                                                }else{
                                                    echo $this->Html->image("admin/upload2.png",array('class'=>'','data-id'=>$order['Provider']['id']));
                                                }?>
                                                <span><?php echo $order['Provider']['first_name'].''. $order['Provider']['last_name']; ?> </span>
                                                <span><?php echo $this->Form->input('', array('div'=>false,'label' => '', 'class' => 'rating','data-size'=>'','type'=>'text','data-readonly'=>'true','data-show-clear'=>'false','data-show-caption'=>'false','glyphicon'=>false,'rating-class'=>'fa-star','value'=>$order['ReviewRating']['staff_rating'])); ?></span>
                                            </div>
                                        </section>
                                    </div>
                                    <p><?php echo $order['ReviewRating']['venue_review']; ?></p>
                                    <?php  $comments=$this->common->fetch_comments_by_review($order['Review']['id']); ?>
                                    <?php foreach($comments as $comment){ ?>
                                    <div class="reply-sec">
                                        <div class="img-sec">
                                            <?php
                                            if(isset($comment['User']['image']) && !empty($comment['User']['image']) ){
                                                echo $this->Html->image("/images/".$comment['User']['id']."/User/150/".$comment['User']['image'],array('data-id'=>$comment['User']['id'],'class'=>'img-responsive'));
                                            }else{
                                                echo $this->Html->image("admin/upload2.png",array('class'=>'img-responsive','data-id'=>$comment['User']['id']));
                                            }?>
                                            <span class="txt"><?php echo $comment['User']['first_name'].' '. $comment['User']['last_name']; ?></span>
                                        </div>
                                        <div class="rgt">
                                            <p><?php  echo $comment['ReviewComment']['comment_text']; ?></p>
                                        </div>
                                    </div>
                            <?php  } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>   
    </div>
</div>  
    <div class="modal-footer">
        <div class="form-actions text-center">                               
            <?php
                echo $this->Form->button('Close', array('data-dismiss' => 'modal',
                    'type' => 'button', 'label' => false, 'div' => false,
                    'class' => 'btn btn-primary closeModal purple-btn'));
            ?>
        </div>
    </div>
</div>
</div>
