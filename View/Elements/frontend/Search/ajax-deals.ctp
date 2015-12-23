<?php
    if(!isset($ser_cat_type)){
        $ser_cat_type  = null;
    }
    if(!isset($service_type)){
        $service_type = null;
    }
    if(!isset($service_id)){
        $service_id = null;
    }
    //echo $service_id; exit; 
    $deals = $this->frontCommon->getmydeals($user_id, $ser_cat_type, $service_type,$service_id);
    $deals = $deals['deals'];
    //pr($deals); exit;
    $salon_name = $this->frontCommon->thesalonName($user); 
?>
<h2 class="share-head">Deals
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
    if(!empty($deals)){
        $i = 1;
        $lowestDealPrice = array('NULL');
        foreach($deals as $deal){
           // pr($deal);
            $append_class='';
            if($i%3==0){
                $append_class = 'mrgn-rgt0';
            }?>
            <div class="deal-box col-sm-3 col-xs-12 mrgn0 <?php echo $append_class;?>">
                <?php if(!empty($deal['Deal']['image']) && ($deal['Deal']['image'] !='')) {
                    $filename = WWW_ROOT ."images/Service/150/".$deal['Deal']['image'];
                    if (file_exists($filename)) {
                        echo $this->Html->image('/images/Service/150/'.$deal['Deal']['image']);
                    } else{
                        echo '<img src="/img/admin/treat-pic.jpg" alt="" title="">';  
                    }
                } else{ ?>
                    <img src="/img/admin/treat-pic.jpg" alt="" title="">
                <?php } ?>
                
                <section class="sec">
                    <span>
                        <?php
                            $deal_name = $this->frontCommon->thedealName($deal);
                            echo substr($deal_name,0,23);   
                        ?>
                    </span>
                    <!--<span><i class="fa fa-clock-o"></i>-->
                    <div class="clearfix">
                        <div class="dutation-time">
                            <div class="sm-time"><i class="fa fa-clock-o"></i>
                    
                                <?php $priceDurationArr =  $this->frontCommon->getDealPrice($deal['Deal']['id']);
                     
                                    $maxduration = '%02d '.__('hrs',true).' %02d '.__('mins',true);
                                    $duration = '%02d '.__('hrs',true).' %02d '.__('mins',true);
                                    if($priceDurationArr['min_duration'] < 60){
                                        $duration = '%02d '.__('mins',true);
                                    }
                                    if($priceDurationArr['max_duration'] < 60){
                                        $maxduration = '%02d '.__('mins',true);
                                    }
                                  ?>
                                               <?php echo $this->Common->convertToHoursMins($priceDurationArr['min_duration'], $duration);?> <?php echo !empty($priceDurationArr['max_duration']) && $priceDurationArr['max_duration'] > $priceDurationArr['min_duration'] ? '- '.$this->Common->convertToHoursMins($priceDurationArr['max_duration'], $maxduration): '' ?>
                                              
                                </div>
                                <div class="big-price">
                                <?php
                                  if($priceDurationArr['from'] > 1 ){
                                        echo '<span>AED'.$priceDurationArr['sale_price'].' </span>';
                                        echo ' from AED '.$priceDurationArr['deal_price'];
                                  }
                                  else{
                                    echo '<span>AED'.$priceDurationArr['sale_price'].' </span>';
                                    echo ' AED '.$priceDurationArr['deal_price'];
                                  }
                                  ?>
                                   <!-- <span>AED 89</span> from AED 63-->
                                </div>
                            </div>
                    <!--    <button type="button" class="book-now"><?php echo __('book_now',true);?></button>-->
                        
                        <?php $btn_txt = __('book_now',true); ?>
                        <?php
                            $business_url = $this->frontCommon->getBusinessUrl($user_id);
                            $salon_deal_name = $this->Common->get_salon_deal_name($deal['Deal']['id']);
                            $actiontype  = ($deal['Deal']['type']=='Package' || $deal['Deal']['type']=='Spaday')?'packages':'service';
                            $package_service_id = ($deal['Deal']['type']=='Package' || $deal['Deal']['type']=='Spaday')?$deal['DealServicePackage']['0']['package_id']:$deal['DealServicePackage']['0']['salon_service_id'];
                          
                         if(!empty($business_url) && !empty($deal['Deal']['id'])){
						
                            if(!empty($salon_deal_name))
                                $deal_name_book = str_replace(' ','-',trim($salon_deal_name));
                            else
                                $deal_name_book = '';
                                $link_book = '/'.$business_url.'-'.$actiontype.'/'.@$deal_name_book.'-'.base64_encode($package_service_id).'-deal/'.base64_encode($deal['Deal']['id']);
                                if($type == 2){
                                $link_book = $link_book.'/'.base64_encode($user_id);    
                                }
                                //$link_book = $link_book.'/'.base64_encode($order['Evoucher'][$voucherToRedeem]['id']);
                            } else {
                                $link_book = '/#';
                            }
                            
                          echo $this->Js->link('<button type="button" class="book-now forDealBooking" id="dealno'.$i.'" style="display:none">'.$btn_txt.'</button>',$link_book,array('escape'=>false,'update' => '#update_ajax'));
                        ?>
                        <button type="button"data-deal_id='<?php echo $deal['Deal']['id']; ?>' data-id="<?php echo 'dealno'.$i; ?>" class="book-now sessionDeal" ><?php echo  __('book_now',true); ?></button>
                    </div>
                </section>
            </div>
            <?php $i++;
        }
        if($service_cnt > 5){ ?>
                <div style="height: 215px; padding: 80px 10px;" class="deal-box col-sm-3 col-xs-12 mrgn-rgt0"> 
                        <?php echo $this->Html->link($this->Html->image('view_more1.gif',array('style'=>"height: 60px;")),
                                                     '/'.$user['Salon']['business_url'],
                                                     array('escape'=>false)
                                                    );?>
                </div>
        <?php }
    }else{
        echo 'No deal found !!';
    }
    ?>
</div>
<?php if(!empty($services)) {?>
    <div class="nxt">
        <a id="<?php echo $user['User']['id'];?>" class="btn-nxt showmenu" href="javascript:void(0);">
            <i class="fa fa-chevron-down"></i>
        </a>
    </div>
<?php } ?>

<script>
    $(document).ready(function(e){
	$('.sessionDeal').off('click').on('click' , function(){
	   id = '#'+$(this).data('id');
	   deal_id = $(this).data('deal_id');
	    $.ajax({
		type:'POST',
		data:{deal_id:deal_id},
		url:'<?php echo $this->Html->url(array('controller'=>'Deals','action'=>'deal_package_sess')); ?>',
		    success:function(){
		     $(id).click();   
		    }
		});
	});
    });
    
    
</script>