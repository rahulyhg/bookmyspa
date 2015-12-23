<style type="text/css">
  .col-sm-3 {
  width: 25% !important;
}

</style>
<?php $this->Paginator->options(array(
    'update' => '#mySmallModal',
    'evalScripts' => true,
    'before' => $this->Js->get('.loader-container')->effect(
        'fadeIn',
        array('buffer' => false)
    ),
    'complete' => $this->Js->get('.loader-container')->effect(
        'fadeOut',
        array('buffer' => false)
    ),
));?>
<div class="modal-dialog pointModal">
<div class="modal-content">
    <div class="modal-header clearfix">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">
	      <?php if(!empty($salon_details)) {?>
		<div class="top-recmnded pull-left">
		  <?php echo @$salon_details['Salon']['eng_name'];?> <?php echo __('points_details ', true); ?>
		</div>
	      <?php } else {
		echo __('points_details ', true);
	      }?>
	    </h4>
    </div>
    <div class="modal-body clearfix">
      <div class="bukingService">
	    <!--inner content starts-->
	    <?php if(!empty($salon_data)) { ?>
	      <div class="appt-tabs table-responsive table-hover">
		<div class="tab-content">
		  <div class="tab-pane active ajax-render" id="my_appointments">
		<!--<table width="100%" class="table-bordered table-striped points-detail-tbl">
		  <tr>
		    <th width="35%" class="first">Name</th>
		    <th width="35%" class="sec" style="text-align:center">Points</th>
		    <th width="30%" class="fourth" style="text-align:center">Transaction On</th>
		  </tr>-->
		  <?php foreach($salon_data as $points_details){ ?>
		    <div  class="info-box  clearfix">
			<div class="img-box">
			<?php
			  $image = '';
			  if($points_details['Order']['service_type'] == 1){
			    $image = $this->Common->getsalonserviceImage($points_details['Order']['salon_service_id']);
			  } else if($points_details['Order']['service_type'] == 2 || $points_details['Order']['service_type'] == 3){
			    $image = $this->Common->getpackageImage($points_details['Order']['salon_service_id']);
			  } else if($points_details['Order']['service_type'] == 4){
			    $image = $this->Common->getsalonserviceImage($points_details['Order']['salon_service_id']);
			  } else if($points_details['Order']['service_type'] == 5){
			    //$image = $this->Common->getsalonserviceImage($points_details['Order']['salon_service_id']);
			    $image = '';
			  } else if($points_details['Order']['service_type'] == 6){
			  
			    $image = $this->Common->gifcertificateImage($points_details['Order']['id']);
			    //$image = $this->Common->getsalonserviceImage($points_details['Order']['salon_service_id']);
			  } else if($points_details['Order']['service_type'] == 7){
			    $image = $this->Common->getsalonserviceImage($points_details['Order']['salon_service_id']);
			  }
			  
			  ?>
			  
			    <?php echo $this->Html->image($image,array('title' => @$points_details['Order']['eng_service_name']));?>
			</div>
			<div class="txt-box">
			<h2> <?php
			    if($points_details['Order']['service_type'] != 6){
			      echo @$points_details['Order']['eng_service_name'];
			    } else {
			      echo 'Gift Certificate';
			    }?> </h2>
			</div>
			 <div class="timer-sec">
				 <div class="time-box">
					 
					 <span><strong>Points: </strong> <?php if(@$points_details['UserPoint']['type'] == 1 && !empty($points_details['UserPoint']['points_deducted'])){
			    echo @$points_details['UserPoint']['points_deducted'].' (Debited)';
			  } else {
			    echo @$points_details['UserPoint']['point_given'].' (Credited)';
			  }?></span>
				
				 </div>
				 <!--Need Acceptance <i class="fa fa-check-circle"></i-->
			 </div>
			 <div class="btn-box">
			 <strong>Transaction On: </strong>
			 <?php if(!empty($points_details['UserPoint']['created']) && ($points_details['UserPoint']['type'] != '0000-00-00 00:00:00')){
			    echo date('d F, Y',strtotime($points_details['UserPoint']['created']));
			  } else {
			    echo '-';
			  }?>
			 </div>
		    </div>
			  
		  <?php }?>
		
		<div class="pdng-lft-rgt35 clearfix">
		    <nav class="pagi-nation">
			    <?php if($this->Paginator->param('pageCount') > 1){
				    echo $this->element('pagination-frontend');
				   // echo $this->Js->writeBuffer();
			    } ?>
		    </nav>
		</div>
	      </div>
	    <?php } else { ?>
	      <div class="no-result-found"><?php echo __('No Result Found'); ?></div>
	    <?php } ?>
      </div>
    </div>
</div>
</div>
<!--tabs main navigation ends-->
<?php echo $this->Js->writeBuffer();?>
