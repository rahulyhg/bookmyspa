<?php
$this->Paginator->options(array(
        'update' => '#update_ajax',
        'evalScripts' => true,
        'before' => $this->Js->get('#paginated-content-container')->effect('fadeIn', array('buffer' => false)),
        'success' => $this->Js->get('#paginated-content-container')->effect('fadeOut', array('buffer' => false))
    ));
    ?>
<div class="wrapper">
    <div class="container clearfix">
     <?php if(!empty($staff_service_ids)) { ?>
    <h2 class="share-head mrgnleft">
	 <?php
	 
		 echo __('Deals provided by '. $name.'');
	 ?>
	 </h2>
    <?php } ?>
    <!--feature deals starts-->
    <div class="featured-deals-box only-deals clearfix">
      <div class="deal-box-outer clearfix">
       <?php if(count($allDeals) > 0){
	   $i =1;
	    foreach($allDeals as $deal){ ?>
          <div class="big-deal">
              <div class="photo-sec">
	      <?php echo $this->Html->image('../images/Service/150/'.$deal['Deal']['image'],array('class'=>" ")); ?>
              </div>
              <div class="detail-area">
		    <div class="heading">
			   <?php
			       $lang = Configure::read('Config.language');
			       echo ucfirst($deal['Deal'][$lang.'_name']);
			   ?>
		    </div>
                  <!--<div class="add">Margarita Beauty Salon
                      <span><i class="fa fa-map-marker"></i> Karma, Outer Dubai</span>
                  </div>-->
                  <div class="clearfix">
		   <?php $btn_txt = __('book_now',true); ?>
	<?php
		 $action  = ($deal['Deal']['type']=='Package' || $deal['Deal']['type']=='Spaday')?'Packagebooking/showPackage':'bookings/showService';
		$package_service_id = ($deal['Deal']['type']=='Package' || $deal['Deal']['type']=='Spaday')?$deal['DealServicePackage']['0']['package_id']:$deal['DealServicePackage']['0']['salon_service_id'];
		if($deal['Deal']['type']!='Service'){
		    $url = '/'.$action.'/'.base64_encode($package_service_id).'-deal/'.base64_encode($deal['Deal']['id']).'/'.base64_encode($salonId);    
		}else{
		    $url = '/'.$action.'/'.base64_encode($package_service_id).'-deal/'.base64_encode($deal['Deal']['id']);    
		}
		echo $this->Js->link('<button type="button" class="book-now forDealBooking" id="dealno'.$i.'" style="display:none">'.$btn_txt.'</button>',$url,array('escape'=>false,'update' => '#update_ajax')); ?>
		<button type="button"data-deal_id='<?php echo $deal['Deal']['id']; ?>' data-id="<?php echo 'dealno'.$i; ?>" class="book-now sessionDeal" ><?php echo  __('book_now',true); ?></button>
		  <div class="dutation-time">
		  <div class="sm-time"><i class="fa fa-clock-o"></i>
		   <?php
			$priceDurationArr =  $this->frontCommon->getDealPrice($deal['Deal']['id']);
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
			     }else{
				 echo '<span>AED'.$priceDurationArr['sale_price'].' </span>';
				 echo ' AED '.$priceDurationArr['deal_price'];
			     }
			 ?>
                  </div>
                  </div>
                  </div>
              </div>
           </div> 
          
         <?php $i++; }}else{
	    
	     echo "No Deal Found";
	    
	    }?>
	</div>
    </div>
    <!--feature deals ends-->
    <div class="pdng-lft-rgt35 clearfix">
    <nav class="pagi-nation">
            <?php if($this->Paginator->param('pageCount') > 1){
                    echo $this->element('pagination-frontend');
                    echo $this->Js->writeBuffer();
            } ?>
    </nav>
    </div>
    </div>
</div>
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


