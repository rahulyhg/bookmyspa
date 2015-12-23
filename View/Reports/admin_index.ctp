    <?php
		/* Calendar */		
		echo $this->Html->css('calendar/themes/base/jquery.ui.all');
		echo $this->Html->css('calendar/demos');		
		echo $this->Html->script('calendar/jquery.ui.core');
		echo $this->Html->script('calendar/jquery.ui.datepicker');   		
		/* Calendar */
		echo $this->Html->script('admin/admin_reports'); ?>
    
    <div class="row">
       <div class="col-lg-12">                        
           <div class="addbutton">                
                  &nbsp;
           </div>
       </div>
    </div>
     <?php  echo $this->Form->create('Report', array('url' => array('controller' => 'reports', 'action' => 'index'),'id'=>'reportId')); ?>
<div class="col-lg-12"><?php echo $this->Session->flash();?>   </div>
    <div class="row">
         <div class="col-lg-8">        
             <div class="col-lg-12">
                 <div class="form-group form-spacing">
					<div class="col-lg-2 form-label">
						<label>Report<span class="required"> * </span></label>
					</div>
					<div class="col-lg-4 form-box">  
					   <?php                							
						   $attributes = array('legend' => false);               							
						   echo $this->Form->input('report_id',array('type'=>'select','options'=>$getReportArray,'label' => false,'div' => false, 'empty' => 'Select Type','class' => 'form-control'));
						  ?>
					</div>                     
				
				
					<div class="col-lg-6" id="emptyContainerId"></div>
                 </div>
             </div>
         </div>
    </div>
	
	<div class="row">
         <div class="col-lg-8">        
             <div class="col-lg-12">
                 <div class="form-group form-spacing">
					<div class="col-lg-2 form-label">
						<label>Date<span class="required"> * </span></label>
					</div>
					<div class="col-lg-2 form-box">                                        
					   <?php echo $this->Form->input('start_date',array('label' => false,'div' => false, 'placeholder' => 'From','class' => 'form-control', 'id' => 'startDate'));?>
					</div>
					
					<div class="col-lg-2 form-box" style="margin-left:10px;">
					  <?php echo $this->Form->input('end_date',array('label' => false,'div' => false, 'placeholder' => 'To','class' => 'form-control', 'id' => 'endDate'));?>					   
					</div>
					<div class="col-lg-5"></div>
                 </div>
             </div>
         </div>
    </div>
	
        
        
         
	<div class="col-lg-8" style="margin-top:10px;">
		<div class="col-lg-12">
			<div class="col-lg-2">
			  <!--blank div-->
			</div>
			<div class="col-lg-10 form-box">
				<?php echo $this->Form->button('Submit', array('type' => 'submit','class' => 'btn btn-default'));?>
				 &nbsp;
				<?php echo $this->Form->button('Reset', array('type' => 'reset','class' => 'btn btn-default'));?>
				
			</div>
		</div>     
	</div>
    <div class="col-lg-12 form-spacing">&nbsp;</div>
     <?php echo $this->Form->end(); ?>
     </div>

     
     
     
     