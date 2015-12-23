<?php $lang =  Configure::read('Config.language'); ?>

<?php echo $this->element('frontend/salon_main_banner'); ?>
<!--tabs main navigation starts-->
<div class="salonData clearfix">
    <?php if(!empty($userDetails))  {?>
    <div class="main-nav clearfix">
	<?php //echo $this->element('frontend/Place/all_tabs'); ?>
	<?php echo $this->element('frontend/Place/salon_tabs'); ?>
    </div>
     <div class="container bukingService">
	
     </div>
     <div class="container serviceList">
		<?php echo $this->element('frontend/Place/all_detail'); ?>
	 </div>
    <?php } else {
	echo '<div style="width:100%;padding:10px; font-weight:bold;text-align:center;min-height:300px">Salon not avialable.</div>';
    }?>
</div>
<!--tabs main navigation ends-->

<?php echo $this->Js->writeBuffer();?>