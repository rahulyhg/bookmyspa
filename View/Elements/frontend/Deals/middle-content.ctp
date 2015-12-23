<?php echo $this->Html->script('frontend/star-rating.js?v=1'); ?>
<?php echo $this->Html->css('frontend/star-rating.css?v=1'); ?>

<?php
        $chklang = Configure::read('Config.language');
        
        echo  $this->Paginator->options(array(
        'update' => '.v-middle-side',
        'evalScripts' => true
    ));
?>   
<!--<div class="booking-section clearfix bod-btm-non">
      <div class="deal-banner-outer">
          <div class="deal-banner-left">
              <div class="deal-photo-sec">
                  <img src="img/deal-banner.jpg" alt="" title="">
              </div>
              <div class="deal-photo-detail">
                  <h2>Lorem ipsum dolor sit amet, coner piscing elit</h2>
                  <p>Sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tatiocorper suscipit lobose quaue duis dolore te feugait nulla facilisi.</p>
              </div>
          </div>
          <div class="deal-banner-rgt">
              <p><span>MRP ADE 78</span>
                 <span class="small">Selling Price</span> ADE 75
                 <span>OFFER PRICE</span></p>
                 
              <div class="price">
                  ADE 20
                  <div class="off-outer"><div class="off"></div>20% Off</div>
              </div>
              <div class="btn-box">
                  <input type="button" class="purple-btn" value="Buy Now">                  
                  <input type="button" class="gray-btn" value="Add to Wishlist">
              </div>
              <div class="duration">
                  <h5>Duration</h5>
                  <div class="time"><i class="fa fa-clock-o"></i> 45 mins - 20 mins</div>
              </div>
              <div class="share-deal">
                  <h4>Share this deal</h4>
                  <ul class="share-icon-set big">
                      <li><a href="#" class="msz"></a></li>
                      <li><a href="#" class="fb"></a></li>
                      <li><a href="#" class="tweet"></a></li>
                      <li><a href="#" class="google"></a></li>
                  </ul>
              </div>
          </div>
      </div>
  </div>-->
       <?php
            if(!empty($allDeals)){ ?>
            
  <div class="booking-section clearfix">
      <h2 class="share-head">
          Deals
          <!--<a href="#" class="cross"><img  src="img/cross.png" alt="" title=""></a>-->
         <!-- <ul class="share-icon-set">
              <li>Share</li>
              <li><a href="#" class="msz"></a></li>
              <li><a href="#" class="fb"></a></li>
              <li><a href="#" class="tweet"></a></li>
              <li><a href="#" class="google"></a></li>
          </ul>-->
      </h2>
      <div class="deal-box-outer clearfix col-sm-12">
      
      <?php
              $i=1;
                foreach($allDeals as $allDeal){
                        //pr($allDeals); exit;
        ?>
        <div class=" big-deal  <?php echo ($i%2==0)?'mrgn-rgt0':'';?>">
              <div class="photo-sec">
              <?php echo $this->Html->image("/images/Service/350/".$allDeal['Deal']['image'],array('title'=>'Deal Image','alt'=>'Deal Image')); ?>
                  
                  <!--<div class="featured">FEATURED</div>-->
              </div>
              <div class="detail-area">
                  <div class="heading">
                      <?php echo $allDeal['Deal'][$chklang.'_name'];?>
		      <?php $salon_rating=$this->common->get_rating_by_salon($allDeal['User']['id']); ?>
                      <!--<ul class="rating">-->
                         <!-- <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>-->
			 <!--</ul> -->
			  
			  
			  
					<?php
					if(round($salon_rating[0][0]['avgRating'])>0){ ?>
					    <ul class="rating">
						<?php for($m=5;$m>=1;$m--){
						    if($m>round($salon_rating[0][0]['avgRating'])){ ?>
							<li><i class="fa fa-star-o"></i></li>
						    <?php } else{ ?>
							<li><i class="fa fa-star"></i></li> 
						    <?php }   ?>
						<?php } ?>
					    </ul>
					<?php }else{ ?>
					    <ul class="rating">
						<?php for($m=1;$m<=5;$m++){ ?>
						    <li><i class="fa fa-star-o"></i></li>
						<?php } ?>
					    </ul>
					<?php } ?>
			  
			  
			  
			 
	    <span><?php //echo $this->Form->input('', array('div'=>false,'type'=>'text','label' => '', 'class' => 'rating','data-size'=>'','data-readonly'=>'true','data-show-clear'=>'false','data-show-caption'=>'false','glyphicon'=>false,'rating-class'=>'fa-star','value'=>$salon_rating[0][0]['avgRating'])); ?></span>
			  
                      
                  </div>
                  <div class="add"><?php echo ucfirst($allDeal['Salon'][$chklang.'_name']);?>
						<span><i class="fa fa-map-marker"></i>
							<?php
								if(isset($allDeal['Address']['city_id']) && $allDeal['Address']['city_id'] != ""){
									$city_name = $this->Common->getCity($allDeal['Address']['city_id']);
						  
								}
								if(isset($allDeal['Address']['state_id']) && $allDeal['Address']['state_id'] != ""){
								$state_name = $this->Common->getStatesBYid($allDeal['Address']['state_id']);
								}	
							  echo $city_name .', '. $state_name;
						 /*$addressNew=explode(',',$allDeal['Address']['address']);
						echo !empty($addressNew[0]) ? $addressNew[0].',' :'';
						echo !empty($addressNew[1]) ? $addressNew[1].',' :'';
						echo !empty($addressNew[2]) ? $addressNew[2].',' :'';
						echo !empty($addressNew[3]) ? $addressNew[3].' ' :' '.$allDeal['Address']['po_box']; */
					  ?>
					  </span>
                  </div>
                  <div class="clearfix">
                       <?php $btn_txt = __('book_now',true); ?>
                        <?php
                            $business_url = $this->frontCommon->getBusinessUrl($allDeal['Deal']['salon_id']);
                            $salon_deal_name = $this->Common->get_salon_deal_name($allDeal['Deal']['id']);
                            $actiontype  = ($allDeal['Deal']['type']=='Package' || $allDeal['Deal']['type']=='Spaday')?'packages':'service';
                            $package_service_id = ($allDeal['Deal']['type']=='Package' || $allDeal['Deal']['type']=='Spaday')?$allDeal['DealServicePackage']['0']['package_id']:$allDeal['DealServicePackage']['0']['salon_service_id'];
                          
                         if(!empty($business_url) && !empty($allDeal['Deal']['id'])){
						
                            if(!empty($salon_deal_name))
                                $deal_name_book = str_replace(' ','-',trim($salon_deal_name));
                            else
                                $deal_name_book = '';
                                $link_book = '/'.$business_url.'-'.$actiontype.'/'.@$deal_name_book.'-'.base64_encode($package_service_id).'-deal'.'/'.base64_encode($allDeal['Deal']['id']);
                                if($actiontype == 'packages'){
                                $link_book = $link_book.'/'.base64_encode($allDeal['Deal']['salon_id']);    
                                }
                                //$link_book = $link_book.'/'.base64_encode($order['Evoucher'][$voucherToRedeem]['id']);
                            } else {
                                $link_book = '/#';
                            }
                            
                          echo $this->Js->link('<button type="button" class="book-now forDealBooking" id="dealno'.$i.'" style="display:none">'.$btn_txt.'</button>',$link_book,array('escape'=>false,'update' => '#update_ajax'));
                        ?>
                        <button type="button"data-deal_id='<?php echo $allDeal['Deal']['id']; ?>' data-id="<?php echo 'dealno'.$i; ?>" class="book-now sessionDeal" ><?php echo  __('book_now',true); ?></button>
                  
                  <div class="dutation-time">
                      <div class="sm-time"><i class="fa fa-clock-o"></i>
                        <?php $priceDurationArr =  $this->frontCommon->getDealPrice($allDeal['Deal']['id']);
                     
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
                            
                            //if($priceArr['highprice']){
                            //    echo '<span>AED'.$priceArr['lowprice'].' </span>';
                            //    echo '<b> AED '.$priceArr['highprice'].'</b>';
                            //}
                            //else{
                            //    echo 'AED'.$priceArr['lowprice'];
                            //}
                        }
                        ?>
                         <!-- <span>AED 89</span> from AED 63-->
                      </div>
                  </div>
                  </div>
              </div>
          </div> 
        <?php
            $i++;}
        ?>
             
      </div>
      <!--<div class="nxt">
          <a class="btn-nxt" href="#"><i class="fa fa-chevron-down"></i></a>
      </div>-->
      
  </div>
   <?php }else{
          echo "No deal found";
        } ?>
  <nav class="pagi-nation">
        <?php if($this->Paginator->param('pageCount') > 1){
		echo $this->element('pagination-frontend');
		echo $this->Js->writeBuffer();
	} ?>
      </nav>
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
			window.location.href = $(id).closest("a").attr('href');   
		    }
		});
	});
    });
    
    
</script>