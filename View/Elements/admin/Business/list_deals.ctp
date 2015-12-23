<?php if(!empty($srvcDeals)){
    foreach($srvcDeals as $srvcDeal){
        
    ?>
<div class="v-deal" data-id="<?php echo $srvcDeal['Deal']['id']; ?>">
    <div class="v-deal-box">
        <div class="upper">
        <?php echo $this->Html->image((!empty($srvcDeal['Deal']['image']))?'/images/Service/350/'.$srvcDeal['Deal']['image']:'/img/admin/treat-pic.png',array('class'=>" "));  ?>
            <?php if(!$srvcDeal['Deal']['status']){?>
            <span class="status">Activate Service</span>
            <?php } ?>
        </div>
    
        <div class="bottom <?php if(!$srvcDeal['Deal']['status']){ echo 'dull'; } ?>">
            <p class="p1"><?php echo  ucfirst($srvcDeal['Deal']['eng_name']); ?></p>
            <p class="p2">
                <?php $priceArr =  $this->frontCommon->getDealPrice($srvcDeal['Deal']['id']);
                if($priceArr['from'] > 1 ){
                      echo '<span>AED'.$priceArr['sale_price'].' </span>';
                        echo '<b> from AED '.$priceArr['deal_price'].'</b>';
                }
                else{
                    
                        echo '<span>AED'.$priceArr['sale_price'].' </span>';
                        echo '<b> AED '.$priceArr['deal_price'].'</b>';
                    
                    //if($priceArr['highprice']){
                    //    echo '<span>AED'.$priceArr['lowprice'].' </span>';
                    //    echo '<b> AED '.$priceArr['highprice'].'</b>';
                    //}
                    //else{
                    //    echo 'AED'.$priceArr['lowprice'];
                    //}
                }
                ?>
            </p>
            <p class="p3">
                <button class="active-deactive-deal <?php echo ($srvcDeal['Deal']['status'])?'active':'';?>" data-id="<?php echo $srvcDeal['Deal']['id']?>" type="button">
                <?php echo ($srvcDeal['Deal']['status'])? 'Deactivate':'Activate'; ?></button>
                <a title="Delete" href="javascript:void(0);" data-id="<?php echo $srvcDeal['Deal']['id']?>" class="delete_servicedeal" ><i class="fa  fa-trash-o"></i></a>
                <a title="Edit" href="javascript:void(0);" data-serviceId="<?php echo $srvcDeal['DealServicePackage'][0]['salon_service_id']?>"  data-id="<?php echo $srvcDeal['Deal']['id']?>" class="create_servicedeal" ><i class="fa fa-pencil"></i></a>		
            </p>
        </div>
    </div>
    <?php //pr($deal); ?>
</div>
<?php
    }
}else{
    echo "There are no deals added yet.";    
} ?>
<div class="clear"></div>
<?php //pr($deals);?>