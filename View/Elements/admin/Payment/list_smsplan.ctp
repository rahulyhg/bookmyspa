   <?php $plan_type = array('A'=>'One Year' , 'BA' => 'Six Months' , 'M' =>'One Month' );
      $colors = array('red','orange','green','brown','blue','lime','teal','purple','magenta','grey','darkblue','lightred','satblue','lightgrey','satblue','satgreen');
      $colorCount = count($colors);
?>


<div class="row-fluid">
    <div class="span12">
         <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                     SMS Plan Listing
                </h3>
                <?php 
                 echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_smsPlan pull-right'));?>
            </div>
        
            <div class="box-content">
               <table class="table table-hover table-nomargin dataTable table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Customer type</th>
                            <th>No of SMS</th>
                            <th>Price (AED)</th>
                            <th>Discount (%)</th>
                            <th>Validity</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(!empty($plans)){
                            foreach($plans as $plan){ ?>
                                <tr data-id="<?php echo $plan['SmsSubscriptionPlan']['id']; ?>" >
                                <td><?php echo $plan['SmsSubscriptionPlan']['title']; ?></td>
                                  <td><?php echo ($plan['SmsSubscriptionPlan']['customer_type'] == 0) ? 'Own Customers' : 'Sieasta Customers' ; ?></td>
                                    <td><?php echo $plan['SmsSubscriptionPlan']['no_of_sms']; ?></td>
                                    <td><?php echo $plan['SmsSubscriptionPlan']['price']; ?></td>
                                    <td><?php echo ($plan['SmsSubscriptionPlan']['discount']==0) ? '-':$plan['SmsSubscriptionPlan']['discount']; ?></td>
                                    <td><?php echo $plan_type[$plan['SmsSubscriptionPlan']['plan_type']]; ?></td>
                                    <td><?php echo $this->Common->theStatusImage($plan['SmsSubscriptionPlan']['status']); ?></td>
                                    <td>
                                        <?php //echo $this->Html->link($this->Html->image('admin/icons/eye.png',array('alt'=>'View')), array('controller'=>'SmsSubscriptionPlans','action'=>'viewPage','admin'=>true,base64_encode($plan['SmsSubscriptionPlan']['id']),$plan['SmsSubscriptionPlan']['alias']) , array('title'=>'View','class'=>'view','escape'=>false) ) ?>
                                        <?php echo $this->Html->link('<i class="icon-pencil"></i>', 'javascript:void(0)' , array('data-id'=>$plan['SmsSubscriptionPlan']['id'],'title'=>'Edit','class'=>'addedit_smsPlan','escape'=>false) ) ?>
                                       &nbsp;&nbsp; <?php echo $this->Html->link('<i class=" icon-trash"></i>','javascript:void(0)', array('title'=>'Delete','class'=>'delete_smsPlan','escape'=>false)); ?>
                                    </td>
                                </tr>    
                            <?php }
                        }?>
                        
                    </tbody>

                </table>
               
             </div>
        </div>
    </div>
</div>

