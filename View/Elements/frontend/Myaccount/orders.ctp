<div class="wrapper">
	<div class="container my-orders">
		
        <div class="clearfix bod-btm">
        <!--sort by-->
        <div class="top-recmnded pull-left">
        <label>Show</label>
        <select class="custom_option2">
            <option>All</option>
             <option> Options </option>
             <option> Options </option>
        </select>
        </div>
        <!--sort by ends-->
        
        <!--sort by-->
        <div class="top-recmnded pull-right">
        <label>Sort By</label>
        <select class="custom_option2">
            <option>Expiration date</option>
             <option> Options </option>
             <option> Options </option>
        </select>
        </div>
        
        <!--sort by ends-->
       </div>
       	<!--promotional banner starts-->
        <div class="pro-banner">
        	<span class="diagonal">Earn<span>AED 30</span></span>
            <span class="n-txt">Recommend Sieasta to your friends and you recieve <span>ADE</span></span>
            <span class="big-price">30</span>
            <span class="all">for every recommendation</span>
            <span class="your-account">Your Account<span>AED 00.00</span></span>
            <button type="button" class="purple-btn">Recommend Now</button>
        </div>
        <!--promotional banner ends-->
		<!--inner content starts-->
        <div class="appt-tabs">

          <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane active" id="my_appointments">
	    <?php if(!empty($services)) { 
		foreach($services as $service) { //pr($service);exit;?>
		<div class="info-box clearfix">
                	<div class="img-box">
			 <?php echo $this->Html->image($this->Common->serviceImage($service['SalonService']['SalonServiceImage']['0']['image'],'original'),array('class'=>" ")); ?>
			</div>
                
		<div class="txt-box">
		    <h2><?php echo $this->Common->get_salon_service_name($service['SalonService']['id']); ?></h2>
		    <p class="purple"><?php echo $this->Common->get_salon_service_name($service['SalonService']['parent_id']); ?></p>
		    <p>Quantity - <?php echo $service['GiftCertificate']['no_of_visit'] ; ?></p>
		    <h2 class="price">AED <?php echo $service['GiftCertificate']['amount'];?></h2>
		</div>
                    
		<div class="timer-sec">
			<div class="time-box">
				<i class="fa fa-clock-o"></i>
			    <span class="purple"><strong><?php echo $this->Common->getdate_diff(strtotime($service['GiftCertificate']['expire_on'])); ?></strong></span>
			    <span><strong>Expires On</strong></span></br>
			    <?php echo date('l',strtotime($service['GiftCertificate']['expire_on']));?> <?php echo date('M-d-Y',strtotime($service['GiftCertificate']['expire_on']));?>
			</div>
		</div>
                    
		<div class="btn-box single">
		    <?php
		    $url = $this->Html->url(array('controller'=>'myaccount','action'=>'view_voucher',$service['GiftCertificate']['id'],'admin'=>false));
		    echo $this->Html->link(__('View Voucher',true),'javascript:void(0)',array('class'=>'book-now','escape'=>false,'data-href'=>$url)); ?>
		</div>
                </div>
	   <?php   } ?>
	   <!--div class="result_pages">
            <?php $pagingArr = $this->Paginator->params();
            //pr($pagingArr);
            $start_records = $pagingArr['page'];
            if(!empty($pagingArr['pageCount'])){
                if (!empty($pagingArr['page']) && !empty($pagingArr['limit'])) {
                    $start_records = $pagingArr['limit'] * ($pagingArr['page'] - 1) + 1;
                }
            }
            $end_records = $start_records + $pagingArr['limit'] - 1;
            if($end_records > $pagingArr['count']){
                $end_records = $pagingArr['count'];
            }
            $total_entries = $pagingArr['count'];
            echo 'Showing '.$start_records.' to '.$end_records.' of '.$total_entries.' entries'; ?>
        </div-->
        <div class ="ck-paging">
            <?php
            echo $this->Paginator->first('First');
            echo $this->Paginator->prev(
                      'Previous',
                      array(),
                      null,
                      array('class' => 'prev disabled')
            );
            echo $this->Paginator->numbers(array('separator'=>' '));
            echo $this->Paginator->next(
                      'Next',
                      array(),
                      null,
                      array('class' => 'next disabled')
            );
            echo $this->Paginator->last('Last');?>
        </div>
	   
	   <?php } else{
		echo __('No Results Found');
		} ?>
            	
                
               
                
                
            </div>
          </div>
        
        </div>
        <!--inner content ends-->

    </div>
    
</div>

<?php echo $this->Js->writeBuffer();?>
<style>
    .inner-loader{
	display: none;
    }
</style>
<script>
    $(document).ready(function(){
	var $sModal = $(document).find('#mySmallModal');
	$(document).on('click','.book-now',function(e){
		$('.voucher').css('display','block');
		e.preventDefault();
		$sModal.load($(this).data('href'),function(){
		    $sModal.modal('show');
		});
	})
    });
</script>
 