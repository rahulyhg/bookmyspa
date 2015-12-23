<?php
if(!empty($pkgDeals)){
    foreach($pkgDeals as $thedeal){
        //pr($thedeal);
       // pr($thedeal['DealServicePackage'][0]['DealServicePackagePriceOption']);
    ?>
<div class="v-deal" data-id="<?php echo $thedeal['Deal']['id']; ?>">
    <div class="v-deal-box">
        <div class="upper">
        <?php echo $this->Html->image((!empty($thedeal['Deal']['image']))?'/images/Service/350/'.$thedeal['Deal']['image']:'/img/admin/treat-pic.png',array('class'=>" "));  ?>
            <?php if(!$thedeal['Deal']['status']){?>
            <span class="status">Activate Service</span>
            <?php } ?>
        </div>
    
        <div class="bottom <?php if(!$thedeal['Deal']['status']){ echo 'dull'; } ?>">
            <p class="p1"><?php echo  ucfirst($thedeal['Deal']['eng_name']); ?></p>
            <p class="p2">
                <?php $priceArr =  $this->frontCommon->getDealPrice($thedeal['Deal']['id']);
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
                <button class="active-deactive-deal <?php echo ($thedeal['Deal']['status'])?'active':'';?>" data-id="<?php echo $thedeal['Deal']['id']?>" type="button">
                <?php echo ($thedeal['Deal']['status'])? 'Deactivate':'Activate'; ?></button>
                <a title="Delete" href="javascript:void(0);" data-id="<?php echo $thedeal['Deal']['id']?>" class="delete_servicedeal" ><i class="fa  fa-trash-o"></i></a>
                <a title="Edit" href="javascript:void(0);" data-pkgId="<?php echo $thedeal['DealServicePackage'][0]['package_id'];?>"  data-id="<?php echo $thedeal['Deal']['id']?>" data-type="<?php echo $type ;?>" class="create_packagedeal" ><i class="fa fa-pencil"></i></a>		
            </p>
        </div>
    </div>
    <?php //pr($thedeal); ?>
</div>
<?php
    }
}else{
    echo "There are no deals added yet.";    
} ?>
<div class="clear"></div>
<?php //pr($thedeals);?>