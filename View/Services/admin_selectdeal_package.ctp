   <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header special-header">
            <button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Make Deal Using</h4>
          </div>
          <div class="modal-body DealPackage clearfix">  
	<div class="">
    <div class="clearfix">
	
	<div class="vendor-deal-content deal-content clearfix">
        <?php if(!empty($salonPackage)){
    foreach($salonPackage as $package){
    ?>
<div class="v-deal" data-id="<?php echo $package['Package']['id']; ?>">
    <div class="v-deal-box">
        <div class="upper">
        <?php echo $this->Html->image('../images/Service/350/'.$package["Package"]["image"],array('class'=>" ")); ?>

        </div>
    
        <div class="bottom">
            <p class="p1"><?php echo  ucfirst($package['Package']['eng_name']); ?></p>
            
            <p class="p3 clearfix">
				  <?php echo $this->Html->link('Make A Deal', 'javascript:void(0)',array('class'=>' ButtonColor  purple-btn create_pkgdeal','data-type'=>$type,'PackageId'=> $package['Package']['id']));?>
               
            </p>
        </div>
    </div>
    <?php //pr($package); ?>
</div>
<?php
    }
}else{
    echo "There are no packages added yet.";    
} ?>
<div class="clear"></div>
<?php //pr($salonPackage);?>        
    </div>
   </div>   </div>	
	</div>
		  </div>
		</div>	
	