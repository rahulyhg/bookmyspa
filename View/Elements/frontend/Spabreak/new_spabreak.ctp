<?php 
    if(!empty($newSpabreak)){
        foreach($newSpabreak as $newBreak){ ?> 
            <div class="deal-box">
                <?php 
                    if(!empty($newBreak['SalonSpabreakImage'])){
                        echo $this->Html->image($this->Common->getspabreakImage($newBreak['SalonSpabreakImage'][0]['spabreak_id'],$newBreak['SalonSpabreakImage'][0]['created_by'],350),array('class'=>" ")); 
                    }else{
                        echo $this->Html->image('admin/treat-pic.png', array('alt' => 'image'));
                    }
                ?>

                <section class="sec clearfix">
                    <span>
                        <?php echo (!empty($newBreak['Spabreak'][$lang.'_name']))?$newBreak['Spabreak'][$lang.'_name']:$newBreak['Spabreak']['eng_name']; ?>
                    </span>
                    <span><?php echo ucfirst($newBreak['User']['first_name']).' '.$newBreak['User']['last_name']; ?></span>
                    <span class="location-name">
                        <?php echo (!empty($newBreak['Salon'][$lang.'_name']))?$newBreak['Salon'][$lang.'_name']:$newBreak['Salon']['eng_name']; ?>
                        <span><i class="fa fa-map-marker"></i>  &nbsp;<?php echo $this->Common->get_SalonAddress($newBreak['User']['id']);?></span>                    
                    </span>
                    <button type="button" class="book-now"><?php echo __('Book Now',true);?></button>
                </section>
            </div>
        <?php
        }
    }
?>
     
