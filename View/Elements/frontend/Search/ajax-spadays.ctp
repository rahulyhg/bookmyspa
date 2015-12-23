<?php
    if(!isset($ser_cat_type)){
        $ser_cat_type  = null;
    }
    if(!isset($service_type)){
        $service_type = null;
    }
    if(!isset($type)){
        $type = null;
    }
   // echo $type; exit;
    $SalonPackages = $this->requestAction(array('controller' => 'search', 'action' => 'getSalonPackages',$user_id, $type, $ser_cat_type, $service_type));//pr($galleryImages);
    $SalonPackages = $SalonPackages['packages'];
 ?>
  <?php $lang =  Configure::read('Config.language'); ?>     
 <h2 class="share-head">Spa Day
   <a href="javascript:void(0)" id ="<?php echo $user_id;?>" class="cross close-this"><img  src="/img/cross.png" alt="" title=""></a>
            
    <!--ul class="share-icon-set">
            <li>Share</li> 
            <li><a href="#" class="msz"></a></li>
            <li><a href="#" class="fb"></a></li>
            <li><a href="#" class="tweet"></a></li>
            <li><a href="#" class="google"></a></li>
    </ul-->
</h2>
<div class="deal-box-outer col-sm-12 clearfix">
    <?php
    if(!empty($SalonPackages)){
            $i = 1;
            $lowestPrice = array('NULL');
            foreach($SalonPackages as $package){
                                    $service_name = '';
                                    $count = '';
                                    $price = '';
                                    $append_class='';
                                    
                                    if($i%3==0){
                                            $append_class = 'mrgn-rgt0';
                                    }
                                    
                                    ?>
                                    <div class="deal-box col-sm-3 col-xs-12 mrgn0 <?php echo $append_class;?>">
<?php if(!empty($package['Package']['image']) && ($package['Package']['image'] !='')) {
echo $this->Html->image('/images/Service/150/'.$package['Package']['image']);
                                            }else{ ?>
                                            <img src="/img/admin/treat-pic.jpg" alt="" title="">
                                            <?php } ?>
                                            <section class="sec">
                                            <span>
                                                    <?php
                                                        echo substr($package['Package'][$lang.'_name'],0,23); 
                                                    ?>
                                            </span>
                                            <span id="<?php echo $user_id?>" class="show-menu-price">
                                                    <?php  $priceDuration = $this->Common->getpackageDuration($package['Package']['id']);?>
                                                    <?php
                                                          $maxduration = '%02d '.__('hrs',true).' %02d '.__('mins',true);
                                                          $duration = '%02d '.__('hrs',true).' %02d '.__('mins',true);
                                                          if($priceDuration['duration'] < 60){
                                                              $duration = '%02d '.__('mins',true);
                                                          }
                                                          if($priceDuration['maxduration'] < 60){
                                                              $maxduration = '%02d '.__('mins',true);
                                                          }
                                                    ?>
                                                   <span> <b><?php echo __('AED',true); ?> <?php echo $priceDuration['price'];?> <?php echo !empty($priceDuration['maxprice']) ? '- '.__('AED ',true).$priceDuration['maxprice']: '' ?></b></span>
                                            </span>
                                            <?php 
                                                $service_name = $package['Package'][$lang.'_name'];
                                                $business_url = $this->frontCommon->getBusinessUrl($user_id);
                                                if(!empty($business_url)){
                                                        if(!empty($service_name))
                                                                $service_name_book = str_replace(' ','-',trim($service_name));
                                                        else
                                                                $service_name_book = '';
                                                        $link_book = '/'.$business_url.'-packages/'.@$service_name_book.'-'.base64_encode($package['Package']['id']);
                                                } else {
                                                        $link_book = '/#';
                                                }

                                                echo $this->Html->link('<button class="book-now" type="button">Book Online</button>',
                                                        $link_book,
                                                        array('escape'=>false,'class'=>'salon-book-now')
                                                ); 
                                            ?>
                                            <!--<button class="book-now" type="button">Book Online</button>-->
                                            </section>
                                    </div>
                                    <?php
                                    
                                
                            $i++;}
                      
                    
            if($service_cnt > 5){ ?>
                <div style="height: 215px; padding: 80px 10px;" class="deal-box col-sm-3 col-xs-12 mrgn-rgt0"> 
                    <?php echo $this->Html->link($this->Html->image('view_more1.gif',array('style'=>"height: 60px;")),
                        '/'.$user['Salon']['business_url'],
                        array('escape'=>false)
                   );?>
                </div>
            <?php }
            }else{
                    echo 'No Spa days found.';
            ?>
            <?php
            }
    ?>
    </div>

    <?php if(!empty($services)) {?>
        <div class="nxt">
                <a id="<?php echo $user_id;?>" class="btn-nxt showmenu" href="javascript:void(0);"><i class="fa fa-chevron-down"></i></a>
        </div>
    <?php } ?>
