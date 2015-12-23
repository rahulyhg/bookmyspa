   <?php
   echo $this->Html->script('admin/admin_users');
   echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js');
   echo $this->Html->script('calendar/jquery.ui.datepicker');
   ?>
   <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
    
      <div class="row">
        <div class="col-lg-12">  
	<div id="imageError"></div>
             <?php echo $this->Session->flash();?>   
        </div>            
    </div>
    
   <div class="row">        
      <?php echo $this->Form->create('RevenueSetting', array('id'=>'userId'));                     
      ?>
         <div class="col-lg-5">
           <div class="col-lg-12"><h3><u>Revenue For Upcoming Users</u></h3></div>
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label> Revennue Percent<span class="required"> * </span></label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->input('revenue_percent',array('type' => 'text', 'label' => false,'div' => false, 'placeholder' => '0.00','class' => 'form-control','maxlength' => 55));?>
                  </div>
               </div>
            </div>
                 
            <div class="col-lg-12 form-spacing">
               <div class="col-lg-4"><!--blank Div--></div>
               <div class="col-lg-8 form-box">
                 <?php echo $this->Form->button('Submit', array('type' => 'submit','class' => 'btn btn-default'));?>
                 &nbsp;
                 <?php echo $this->Form->button('Reset', array('type' => 'reset','class' => 'btn btn-default'));?>                 
               </div>
            </div>
         </div>   
      <?php echo $this->Form->end(); ?>           
   </div><!-- /.row -->
