<div id="paginatePkgData">
<?php
$this->Paginator->options(array( 'update' => '#update_ajax', 'evalScripts' => true,
        'before' => $this->Js->get('#paginated-content-container')->effect('fadeIn', array('buffer' => false)),
        'success' => $this->Js->get('#paginated-content-container')->effect('fadeOut', array('buffer' => false))
    ));
    ?>
<div class="wrapper">
    <div class="container clearfix">
    <?php if(!empty($staff_service_ids)) { ?>
    <h2 class="share-head mrgnleft">
	 <?php
	 $pS = isset($theType) && $theType=='spaday' ? 'Spaday ' :'Packages';
		 echo __($pS.' provided by '. $name.'');
	 ?>
	 </h2>
    <?php } ?>
    <!--feature deals starts-->
    <div class="featured-deals-box only-deals clearfix">
      <div class="deal-box-outer clearfix">
       <?php if(count($packages) > 0){
	    foreach($packages as $package){ ?>
          <div class="big-deal">
	   
            <div class="photo-sec">
	      <?php
	      $package_image = (!empty($package['Package']['image']))?'/images/Service/350/'.$package['Package']['image']:'/img/admin/treat-pic.png';
	      echo $this->Html->image($package_image,array('class'=>" "));  
	      //echo $this->Html->image($this->Common->getsalonserviceImage($package["PackageService"][0]["salon_service_id"],$package['Package']['user_id'],150),array('class'=>" ")); ?>
              </div>
              <div class="detail-area">
                  <div class="heading">
		   <?php
			$lang = Configure::read('Config.language');
			echo $package['Package'][$lang.'_name'];
		    ?>
			    <!--<ul class="rating">
				<li><i class="fa fa-star"></i></li>
				<li><i class="fa fa-star"></i></li>
				<li><i class="fa fa-star"></i></li>
				<li><i class="fa fa-star"></i></li>
				<li><i class="fa fa-star"></i></li>
			    </ul>-->
                  </div>
                  <!--<div class="add">Margarita Beauty Salon
                      <span><i class="fa fa-map-marker"></i> Karma, Outer Dubai</span>
                  </div>-->
                  <div class="clearfix">
		  <!--<button type="button" data-id="<?php //echo $package['Package']['id']; ?>" class="book-now forPackageBooking" ><?php //echo ($package['SalonServiceDetail']['sold_as'] == 2)? __('buy_voucher',true) : __('book_now',true); ?></button>-->
		  
		  <?php
		   if($package['SalonServiceDetail']['sold_as'] == 2){
		      $btn_txt = __('buy_voucher',true);
		    }else {
			$btn_txt = __('book_now',true);
		    }
		  ?>
		  <?php echo $this->Js->link('<button type="button" class="book-now forPackageBooking" >'.$btn_txt.'</button>','/packagebooking/showPackage/'.$package['Package']['id'].'/0/'.$salonId,array('escape'=>false,'update' => '#update_ajax'));?>
		  <?php  $priceDuration = $this->Common->getpackageDuration($package['Package']['id']);?>
                  <div class="dutation-time">
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
                  	  <div class="sm-time"><i class="fa fa-clock-o"></i> <?php echo $this->Common->convertToHoursMins($priceDuration['duration'], $duration);?> <?php echo !empty($priceDuration['maxduration']) ? '- '.$this->Common->convertToHoursMins($priceDuration['maxduration'], $maxduration): '' ?></div>
                      <div class="big-price">
		       <?php echo __('AED',true); ?> <?php echo $priceDuration['price'];?> <?php echo !empty($priceDuration['maxprice']) ? '-'.__('AED',true).$priceDuration['maxprice']: '' ?>
                      </div>
                  </div>
                  </div>
              </div>
          </div> 
         <?php }}else{?>
	   <div class="not_found">Current the business is not running any <?php echo (isset($theType))?'Spaday':'Package'; ?></div>
	 <?php } ?>
	</div>
    </div>
    <!--feature deals ends-->
    <div class="pdng-lft-rgt35 clearfix">
	<nav class="pagi-nation">
		<?php if($this->Paginator->param('pageCount') > 1){
			echo $this->element('pagination-frontend');
		} ?>
	</nav>
    </div>
    </div>
</div>   
</div>

 <!--<div class=""></div>-->
<?php  $userDetails = (isset($auth_user))?$auth_user["User"]["id"]:'';?>
<script>
    $(document).ready(function(){
	
    });
    
</script>
