<div class="wrapper">
	<div class="container">

		<!--inner tabs starts-->
        <div  role="tabpanel" class="appt-tabs">

          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
	    <li role="presentation">
	        <?php echo $this->Js->link(__'My Appointments'),'/Myaccount/appointments',array('update' => '#update_ajax');?>
	    </li>            <li role="presentation">
	        <?php echo $this->Js->link(__('Past Appointments',true),'/Myaccount/appointments/past',array('update' => '#update_ajax'));?>
	    </li>
          </ul>
        
          <!-- Tab panes -->
          <div  class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="my_appointments">
	    
	    <?php if(!empty($orders)){
		foreach($orders as $order) {//pr($order); ?>
		    <div  class="info-box clearfix">
                	<div class="img-box">
			    <?php echo $this->Html->image($this->Common->serviceImage($order['SalonService']['SalonServiceImage']['0']['image'],'original'),array('class'=>" ")); ?>
			</div>
                
			<div class="txt-box">
			    <h2><?php echo $this->Common->get_salon_service_name($order['Order']['salon_service_id']); ?></h2>
			    <p class="purple"><?php echo $this->Common->get_salon_service_name($order['SalonService']['id']); ?></p>
			    <p><?php echo $order['Appointment']['User']['first_name'].' '.$order['Appointment']['User']['last_name'];?></p>
			    <p><i class="fa  fa-clock-o"></i> <?php echo $order['Order']['duration']; ?> mins</p>
			    <h2>AED <?php echo $order['Order']['amount']; ?></h2>
			</div>
			
			    <div class="timer-sec">
			    <div class="time-box">
				    <i class="fa fa-clock-o"></i>
				<?php echo  date("h:i A",$order['Appointment']['appointment_start_date']); ?>, <?php echo date('l',$order['Appointment']['appointment_start_date'])?> <?php echo date('M-d-Y',$order['Appointment']['appointment_start_date'])?> 
			    </div>
			    <!--Need Acceptance <i class="fa fa-check-circle"></i-->
			</div>
			
			<div class="btn-box">
			    <button type="button" class="gray-btn">Cancel</button>
			    <button type="button" class="book-now">Reschedule</button>
			</div>
                </div>  
		    
		<?php } ?>
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
	    <?php } ?>
            	
            </div>
          </div>
        
        </div>
        <!--inner tabs ends-->

    </div>
    
</div>
<style>
    .inner-loader{
	display: none;
    }
</style>