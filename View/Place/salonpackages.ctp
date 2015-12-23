<!--main banner starts-->
<?php echo $this->Html->script('frontend/widget'); ?>
<?php echo $this->Html->script('frontend/jquery.weekcalendar'); 
?>
<?php echo $this->Html->css('jquery.bxslider'); ?>
<?php echo $this->Html->script('jquery.bxslider'); ?>

<?php $lang =  Configure::read('Config.language'); ?>
<?php echo $this->element('frontend/salon_main_banner'); ?>
<!--tabs main navigation starts-->

<div class="salonData clearfix">
    <div class="main-nav clearfix">
	<?php //echo $this->element('frontend/Place/all_tabs'); ?>
	<?php echo $this->element('frontend/Place/salon_tabs'); ?>
    </div>
    <div class="container bukingPackage"></div>
    <div class="container packageList">
	<?php echo $this->element('frontend/Place/packages'); ?>
	
    </div>
  
    
</div>
<!--tabs main navigation ends-->

<?php echo $this->Js->writeBuffer();?>