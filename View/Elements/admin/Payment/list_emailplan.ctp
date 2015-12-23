  <?php
 $plan_type = array('M'=>'One month' , 'BA' => 'Six months' , 'A' =>'One year' );
   $colors = array('red','orange','green','brown','blue','lime','teal','purple','magenta','grey','darkblue','lightred','satblue','lightgrey','satblue','satgreen');
   $colorCount = count($colors);
?>
<?php /*if(!empty($plans)){ ?>
<div class="box">
    <div class="box-title">
        <h3>
            <i class="icon-reorder"></i>
                <span>Payment Plan ( <?php echo $planType; ?> )</span>
        </h3>
    </div>
           
    <div class="box-content">
        <div class="row-fluid">
            <div class="pricing-tables">
                <?php
                $i = 0;
                foreach($plans as $k=>$plan){
                    if($i<$colorCount){
                        $class = $colors[$i];    
                    }else{
                        $i=0;
                    }
                    $bestVal='';
                    if($plan['EmailSubscriptionPlan']['featured']){ 
                        $class.=' highlighted';
                        $bestVal = '<div class="info">Best Value</div>';
                    }
                ?>   
                <ul class="pricing span3 <?php echo $class;?>">
                    <li class="head">
                        <div class="name"><?php echo ucfirst($plan['EmailSubscriptionPlan']['title']);?></div>
                        <div class="price">
                            $<?php echo $plan['EmailSubscriptionPlan']['price']?>
                            <span><?php echo $plan['EmailSubscriptionPlan']['sub_title'];?></span>
                        </div>
                        <?php echo $bestVal;?>
                    </li>
                    <li><i class="icon-ok"></i><?php echo $plan['EmailSubscriptionPlan']['no_of_emails']; ?> Emails</li>
                    <li><i class="icon-ok"></i><?php echo $plan_type[$plan['EmailSubscriptionPlan']['plan_type']]; ?></li>
                    <li class="button">
                    <?php echo $this->Html->link('<span>Assign Plan</span>','javascript:void(0);',array('div'=>false,'class'=>'btn btn-'.$class,'escape'=>false));?>
                    </li>
                </ul>
                <?php
                $i++;
                }?>
                                  
            </div>
        </div>
    </div>
</div>
 <?php } */?>  

<!--<br><br>-->

<div class="box box-color box-bordered">
    <div class="box-title">
        <h3>
            <i class="icon-table"></i>
            Email Plan Listing
	</h3>
        <?php echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New Plan </button>','javascript:void(0)',array('data-id'=>'','escape'=>false,'class'=>'pull-right addedit_emailPlan','title'=>'Add Email Plan')); ?>
    </div>
    <div class="box-content">
     <table class="table table-hover table-nomargin dataTable table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
			    <th>Customer type</th>
                            <th>No of Emails</th>
			    <th>No of Customers</th>
			    <th>Discount(%)</th>
                            <th>Price (AED)</th>
                            <th>Validity</th>
                            <th align="center" style="text-align: center;">Status</th>
                            <th align="center" style="text-align: center;">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(!empty($plans)){
                            foreach($plans as $plan){ ?>
                                <tr data-id="<?php echo $plan['EmailSubscriptionPlan']['id']; ?>" >
                                    <td><?php echo $plan['EmailSubscriptionPlan']['title']; ?></td>
                                    <td><?php echo ($plan['EmailSubscriptionPlan']['customer_type'] == 0) ? 'Own Customers' : 'Sieasta Customers' ; ?></td>
				    <td><?php echo ($plan['EmailSubscriptionPlan']['customer_type'] == 0) ? 'Unlimited':$plan['EmailSubscriptionPlan']['no_of_emails']; ?></td>
				    <td><?php echo ($plan['EmailSubscriptionPlan']['customer_type'] == 0) ? $plan['EmailSubscriptionPlan']['no_of_customers'] : '-' ; ?></td>
                                    
				    <td><?php echo ($plan['EmailSubscriptionPlan']['discount']==0) ? '-':$plan['EmailSubscriptionPlan']['discount']; ?></td><td><?php echo $plan['EmailSubscriptionPlan']['price']; ?></td>
                                    <td><?php echo $plan_type[$plan['EmailSubscriptionPlan']['plan_type']]; ?></td>
                                    <td align="center"><?php echo $this->Common->theStatusImage($plan['EmailSubscriptionPlan']['status']); ?></td>
                                    <td align="center">
                                        <?php //echo $this->Html->link($this->Html->image('admin/icons/eye.png',array('alt'=>'View')), array('controller'=>'EmailSubscriptionPlans','action'=>'viewPage','admin'=>true,base64_encode($plan['EmailSubscriptionPlan']['id']),$plan['EmailSubscriptionPlan']['alias']) , array('title'=>'View','class'=>'view','escape'=>false) ) ?>
                                        <?php echo $this->Html->link('<i class="icon-pencil"></i>', 'javascript:void(0);', array('data-id'=>$plan['EmailSubscriptionPlan']['id'],'title'=>'Edit','class'=>'addedit_emailPlan','escape'=>false) ) ?>
                                        <?php echo $this->Html->link('<i class=" icon-trash"></i>', 'javascript:void(0);', array('title'=>'Delete','class'=>'delete_emailPlan','escape'=>false)) ?>
                                    </td>
                                </tr>    
                            <?php }
                        }?>
                        
                    </tbody>

                   
                </table>

</div>
</div>
