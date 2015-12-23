<!--main banner starts-->
<?php //echo $this->Html->script('frontend/widget'); ?>
<?php //echo $this->Html->script('frontend/date'); ?>
<?php //echo $this->Html->script('frontend/jquery.weekcalendar'); 
echo $this->Html->script('fancy/jquery.fancybox.js?v=2.1.5');
echo $this->Html->css('fancy/jquery.fancybox.css?v=2.1.5');
echo $this->Html->script('fancy/jquery.fancybox-thumbs.js?v=1.0.7');
echo $this->Html->css('fancy/jquery.fancybox-thumbs.css?v=1.0.7');
?>
<?php //echo $this->Html->css('jquery.bxslider'); ?>
<?php //echo $this->Html->script('jquery.bxslider'); ?>

<?php $lang =  Configure::read('Config.language'); ?>

<?php echo $this->element('frontend/salon_main_banner'); ?>
<!--tabs main navigation starts-->
<div class="salonData clearfix">
    <div class="main-nav clearfix">
	<?php //echo $this->element('frontend/Place/all_tabs'); ?>
	<?php echo $this->element('frontend/Place/salon_tabs'); ?>
    </div>
    <?php echo $this->element('frontend/Place/gallery'); ?>
    
    
</div>
<!--tabs main navigation ends-->

<?php echo $this->Js->writeBuffer();?>