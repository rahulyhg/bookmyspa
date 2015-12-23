<?php $lang =  Configure::read('Config.language'); ?>
<?php echo $this->element('frontend/salon_main_banner'); ?>
<!--tabs main navigation starts-->
<div class="salonData clearfix">
    <div class="main-nav clearfix">
	<?php //echo $this->element('frontend/Place/all_tabs'); ?>
	<?php echo $this->element('frontend/Place/salon_tabs'); ?>
    </div>
    <?php echo $this->element('frontend/Place/gifts'); ?>
    
    
</div>
<!--tabs main navigation ends-->

<?php echo $this->Js->writeBuffer();?>