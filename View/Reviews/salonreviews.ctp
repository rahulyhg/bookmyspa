<?php echo $this->Html->script('frontend/star-rating.js?v=1'); ?>
<?php echo $this->Html->css('frontend/star-rating.css?v=1'); ?>
<?php $lang =  Configure::read('Config.language'); ?>
<?php echo $this->element('frontend/salon_main_banner'); ?>
<!--tabs main navigation starts-->
<div class="salonData clearfix">
    <div class="main-nav clearfix">
	<?php echo $this->element('frontend/Place/salon_tabs'); ?>
    </div>
    <?php echo $this->element('frontend/Review/reviews'); ?>
</div>
<!--tabs main navigation ends-->

<?php echo $this->Js->writeBuffer();?>