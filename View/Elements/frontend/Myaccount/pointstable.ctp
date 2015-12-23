    <!--   <table width="100%">-->
		<?php if(!empty($getpoints)) {
			if(!isset($this->request->data['filter_list'])){
				foreach($getpoints as $key=>$points) {
					if($points['User']['type'] == '1') {
						$newValue = $getpoints[0];
						$getpoints[0] = $points;
						$getpoints[$key] = $newValue;
					}
				}
			}
		?>
            	<!--<tr>
                   <th width="25%" class="first">Name</th>
                    <th width="20%" class="sec">Balance</th>
                    <th width="30%" class="fourth">&nbsp;</th>
                </tr>-->
			<?php foreach($getpoints as $key=>$points) {
				$class="";
			?>
		<!-- <tr>-->
			<?php if($points['User']['type'] == '1') {
				$class="sieasta-line";
				?>
				<div  class="info-box clearfix">
				    <div class="img-box sieasta-line purple">
			
				<img src="/img/sieasta-name.png" alt="Sieasta" title="Sieasta"><?php echo __('Sieasta'); ?>
			<?php }else{ ?>
			<div  class="info-box clearfix">
				    <div class="img-box purple">
			 <?php echo $this->Common->get_my_salon_name($points['User']['id']);
			}
			?>
			</div>
			 <div class="timer-sec">
			    <div class="time-box <?php echo $class ; ?>">
				    <i class="fa fa-clock-o"></i>
				    <span></span>
			    <?php echo $points['UserCount']['user_count'] ;?> Points
			    </div>
			</div>
			<div class="btn-box <?php echo $class ; ?>">
			   <?php
				    if($points['UserCount']['salon_id']==1){
					    $gift_type = 'admin';	
				    }else{
					    $gift_type = 'salon';
				    }
				    
				    $businessUrl = $this->Common->getSalon($points['UserCount']['salon_id']);
				    if(!$businessUrl){
				     $businessUrl = 'Place/salongiftcertificate/'.$points['UserCount']['salon_id'];
				    }
				    ?>
				    
				    <button data-point = "<?php echo $points['UserCount']['user_count']; ?>" data-type ="<?php echo $gift_type; ?>" class="book-now redeem_certificate" id="<?php echo $businessUrl ; ?>" type="button" class="book-now">Redeem a gift certificate</button>
				    <?php $url = $this->Html->url(array('controller'=>'myaccount','action'=>'view_points',$points['User']['id'],$points['User']['type'],'admin'=>false));
				    echo $this->Html->link(__('View Details',true),$url,array('style'=>'text-align:center;text-decoration:none;','class'=>'book-now','escape'=>false)); ?>
			       <!-- </td>
			    </tr>-->
			    <?php } ?>	    
		       </div>
			<!--Need Acceptance <i class="fa fa-check-circle"></i-->
		
	</div>

        
	   <?php } else{ ?>
		<div class="no-result-found"><?php echo __('No Result Found'); ?></div>
		<?php } ?>
	    <div class="pdng-tp-11"></div>
        <!--inner content ends-->
        <?php 
	if(!empty($getpoints)){
		if(count($getpoints) >= 10){
	?>	
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
	<?php }} ?>
	   

