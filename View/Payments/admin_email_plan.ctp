<style>
    .form-horizontal .col-sm-2.control-label {
        text-align: right;
    }
</style>    
<div class="modal-dialog vendor-setting sm-vendor-setting">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel"><i class="icon-edit"></i>
    <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Email Plan </h3>
</div>
     <?php echo $this->Form->create('EmailSubscriptionPlan',array('novalidate','class'=>'form-horizontal')); ?>
<div class="modal-body">
        <div class="box">
             <div class="box-content">
             
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Plan title *:</label>
                                <div class="col-sm-8">
                                    <?php echo $this->Form->input('title',array('class'=>'form-control','div'=>false,'label'=>false,'required' ,'validationMessage'=>'Title is required.','maxlength'=>100,'data-minlength-msg'=>"Minimum 3 characters.",'minlength'=>'3'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Customer type *:</label>
                                <div class="col-sm-8">
                                    <?php
				    $value = isset($this->request->data['EmailSubscriptionPlan']['customer_type']) ? $this->request->data['EmailSubscriptionPlan']['customer_type'] : 0 ;
				    $nCustomer = 'display:block';
				    $nEmail = 'display:block';
				    if($value==0)
				       $nEmail = 'display:none';
				    else
				       $nCustomer = 'display:none';
				    $options = array(0 => 'Own Customers', 1=> 'Sieasta Customers');
                                    $attributes = array('legend' => false,'label'=>array('class'=>'new-chk'),'separator'=> '</div><div class="col-sm-8">','required'=>true,'id'=>'customerType','class'=>'customerType','validationMessage'=>"Please select customer type.",'default'=>0,'value'=>$value);
                                    	    
				    echo $this->Form->radio('customer_type', $options, $attributes);
				    
				    //echo $this->Form->input('customer_type',array('class'=>'form-control','div'=>false,'label'=>false,'required' ,'validationMessage'=>'Sub-Title is required.','maxlength'=>100,'data-minlength-msg'=>"Minimum 3 characters.",'minlength'=>'3'));?>
                                </div>
                            </div>
                            <div class="form-group" style ="<?php echo $nCustomer; ?>" id="nCustomer">
                                <label class="col-sm-4 control-label">No of Customers *</br>(<i>unlimited emails</i>):</label>
                                <div class="col-sm-8">
                                    <?php //echo $this->Form->input('no_of_emails',array('class'=>'form-control','div'=>false,'label'=>false));?>
                                    <?php echo $this->Form->input('no_of_customers',array('class'=>'form-control numOnly','div'=>false,'label'=>false,'type'=>'text','maxlength'=>5,'required'=>false));?>
                                </div>
                            </div>
			    <div class="form-group" style ="<?php echo $nEmail; ?>" id="nEmail">
                                <label class="col-sm-4 control-label">No of Emails *:</label>
                                <div class="col-sm-8">
                                    <?php //echo $this->Form->input('no_of_emails',array('class'=>'form-control','div'=>false,'label'=>false));?>
                                    <?php echo $this->Form->input('no_of_emails',array('class'=>'form-control numOnly','div'=>false,'label'=>false,'type'=>'text','maxlength'=>5,'required'=>false));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Price(AED)*:</label>
                                <div class="col-sm-8">
                                         <?php echo $this->Form->input('price',array('class'=>'form-control numOnly','div'=>false,'label'=>false,'type'=>'text','required' ,'validationMessage'=>'Price(AED) is required.','maxlength'=>5));?>
                                    <?php //echo $this->Form->input('price',array('class'=>'input-fluid validate[required]','div'=>false,'label'=>false));?>
                                </div>
                            </div>
			    <div class="form-group">
                                <label class="col-sm-4 control-label">Discount(%):</label>
                                <div class="col-sm-8">
                                         <?php echo $this->Form->input('discount',array('class'=>'form-control numOnly','div'=>false,'label'=>false,'type'=>'text','required'=>false ,'maxlength'=>2));?>
                                    <?php //echo $this->Form->input('price',array('class'=>'input-fluid validate[required]','div'=>false,'label'=>false));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Validity *:</label>
                                <div class="col-sm-8">
                                    <?php echo $this->Form->input('plan_type',array('empty'=>' -- Please Select -- ','options'=>array('M'=>'1 Month','BA'=>'Six Month','A'=>'1 Year'),'class'=>'form-control','div'=>false,'label'=>false,'required' ,'validationMessage'=>'Plan type is required.'));?>
                                </div>
                            </div>
                            <!--<div class="form-group">
				  <label class="col-sm-4 pdng-tp7"> </label>
				   <?php echo $this->Form->input('featured',array('div'=>array('class'=>'col-sm-8 setNewMarginC'),'class'=>'','type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>'Make Featured'))); ?>
                            </div>-->
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Status *:</label>
                                <div class="col-sm-8">
                                    <?php echo $this->Form->input('status',array('options'=>array('1'=>'Active','0'=>'Inactive'),'empty'=>' -- Please Select -- ','class'=>'form-control','div'=>false,'label'=>false,'required' ,'validationMessage'=>'Status is required.'));?>
                                </div>
                            </div>
                           
              </div>
        </div>
</div>
    <div class="modal-footer pdng20">
		 <div class="form-actions">
                                <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary update','label'=>false,'div'=>false));?>
                                <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal',
                                                'type'=>'button','label'=>false,'div'=>false,
                                                'class'=>'btn',
                                              )); ?>
                            </div>
                   
		</div>
 <?php echo $this->Form->end();?>	
</div>
</div>
