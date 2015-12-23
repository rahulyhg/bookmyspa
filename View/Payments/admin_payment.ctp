<?php   echo $this->Html->script('admin/admin_users');


?>
    
      <div class="row">
        <div class="col-lg-12">  
	<div id="imageError"></div>
             <?php echo $this->Session->flash();?>   
        </div>            
    </div>
    
   <div class="row">        
      <?php echo $this->Form->create(Null, array('id'=>'RevenuePayment'));                     
      echo $this->Form->hidden('user_id' , array('value' => base64_encode($user_id)));
      echo $this->Form->hidden('content_id' , array('value' => base64_encode($content_id)));
      ?>
         <div class="col-lg-5">
           <div class="col-lg-12"><h3><u>Payment</u></h3></div>
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label> Post Title:</label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $user_revenue_arr[0]['PageView']['title']; ?>
                  </div>
               </div>
            </div>
	    <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label> Total Amount:</label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     $<?php echo number_format($total_amount, 2, '.', '');?>
                  </div>
               </div>
            </div>
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label> Paid Amount:</label>
                  </div>
                  <div class="col-lg-8 form-box">                
                      $<?php echo number_format($paid_amount, 2, '.', '');?>
                  </div>
               </div>
            </div>
	    <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label> Amount to be Paid:</label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     $<?php echo number_format($remainig_balance, 2, '.', '');?>
                  </div>
               </div>
            </div>   
            <div class="col-lg-12 form-spacing">
               <div class="col-lg-4"><!--blank Div--></div>
               <div class="col-lg-8 form-box">
                 <?php
		 if(!empty($remainig_balance)){
		    echo $this->Form->button('Confirm', array('type' => 'submit','class' => 'btn btn-default'));
		 } ?>
                 &nbsp;
                 <?php echo $this->Html->link('Back','/admin/payments/user_post/'.base64_encode($user_id), array('escape' =>false));?>                 
               </div>
            </div>
         </div>   
      <?php echo $this->Form->end(); ?>           
   </div><!-- /.row -->
