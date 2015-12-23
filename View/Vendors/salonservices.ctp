<?php $lang =  Configure::read('Config.language'); ?>
<!--tabs main navigation starts-->
<div class="salonData clearfix">
    <div class="main-nav clearfix">
	<?php echo $this->element('frontend/Place/salon_tabs'); ?>
    </div>
    <?php echo $this->element('frontend/Vendors/services'); ?>
</div>
<!--tabs main navigation ends-->
<?php echo $this->Js->writeBuffer();?>