    <?php
      $plan_type = array('A'=>'Annual' , 'BA' => 'Bi Annual' , 'M' =>'Monthly' );
      $colors = array('red','orange','green','brown','blue','lime','teal','purple','magenta','grey','darkblue','lightred','satblue','lightgrey','satblue','satgreen');
      $colorCount = count($colors);
?>
<?php if(!empty($plans)){ ?>
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
                    if($plan['FeaturingSubscriptionPlan']['featured']){ 
                        $class.=' highlighted';
                        $bestVal = '<div class="info">Best Value</div>';
                    }
                ?>
                <ul class="pricing span3 <?php echo $class;?>">
                    <li class="head">
                        <div class="name"><?php echo ucfirst($plan['FeaturingSubscriptionPlan']['title']);?></div>
                        <div class="price">
                            $<?php echo $plan['FeaturingSubscriptionPlan']['price']?>
                            <span><?php echo $plan['FeaturingSubscriptionPlan']['sub_title'];?></span>
                        </div>
                        <?php echo $bestVal;?>
                    </li>
                     <?php if($plan['FeaturingSubscriptionPlan']['salon_featuring']){ ?>
                                <li>Salon Featuring</li>
                            <?php }?>
                            <?php if($plan['FeaturingSubscriptionPlan']['deal_featuring']){ ?>
                                <li>Deal Featuring</li>
                                <li><?php echo $plan['FeaturingSubscriptionPlan']['no_of_deals'];?> Deals</li>
                            <?php }?>
                            <?php if($plan['FeaturingSubscriptionPlan']['package_featuring']){ ?>
                                <li>Package Featuring</li>
                                <li><?php echo $plan['FeaturingSubscriptionPlan']['no_of_package'];?> Packages</li>
                            <?php }?>
                            <?php if($plan['FeaturingSubscriptionPlan']['staff_featuring']){ ?>
                                <li>Staff Featuring</li>
                                <li><?php echo $plan['FeaturingSubscriptionPlan']['no_of staff'];?> Staffs</li>
                            <?php }?>
                            <li><?php echo $plan_type[$plan['FeaturingSubscriptionPlan']['plan_type']]; ?></li>
                            <li class="button">
                            <?php echo $this->Html->link('<span>Assign Plan</span>','javascript:void(0);',array('div'=>false,'class'=>'btn btn-'.$class,'escape'=>false));?>
 </li>
                </ul>
                <?php $i++; }?>
            </div>
        </div>
   </div>
</div>
<?php } ?>
<br><br>

<div class="box box-color box-bordered">
    <div class="box-title">
        <h3>
            <i class="icon-table"></i>
            Featured Plan Listing
	</h3>
        <?php echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New Plan </button>','javascript:void(0)',array('escape'=>false,'class'=>'pull-right addedit_featuredPlan','title'=>'Add Featuring Plan')); ?>
    </div>
    <div class="box-content">
    <table class="table table-hover table-nomargin dataTable table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Price $</th>
                            <th>Plan Type</th>
                            <th>Is Featured ?</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(!empty($plans)){
                            foreach($plans as $plan){ ?>
                                <tr data-id="<?php echo $plan['FeaturingSubscriptionPlan']['id']; ?>" >
                                    <td><?php echo $plan['FeaturingSubscriptionPlan']['title']; ?></td>
                                    <td>$<?php echo $plan['FeaturingSubscriptionPlan']['price']; ?></td>
                                    <td><?php echo $plan_type[$plan['FeaturingSubscriptionPlan']['plan_type']]; ?></td>
                                    <td><?php echo ($plan['FeaturingSubscriptionPlan']['featured'])? 'True':'False' ; ?></td>
                                    <td><?php echo $this->Common->theStatusImage($plan['FeaturingSubscriptionPlan']['status']); ?></td>
                                    <td>
                                        <?php //echo $this->Html->link($this->Html->image('admin/icons/eye.png',array('alt'=>'View')), array('controller'=>'FeaturingSubscriptionPlans','action'=>'viewPage','admin'=>true,base64_encode($plan['FeaturingSubscriptionPlan']['id']),$plan['FeaturingSubscriptionPlan']['alias']) , array('title'=>'View','class'=>'view','escape'=>false) ) ?>
                                        <?php echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0)' , array('data-id'=>$plan['FeaturingSubscriptionPlan']['id'],'title'=>'Edit','class'=>'addedit_featuredPlan','escape'=>false) ) ?> &nbsp;&nbsp;
                                        <?php echo $this->Html->link('<i class=" icon-trash"></i>','javascript:void(0)', array('title'=>'Delete','class'=>'delete_featuredPlan','escape'=>false)) ?>
                                    </td>
                                </tr>    
                            <?php }
                        }?>
                        
                    </tbody>

                   
                </table>

        
</div>
</div>

