<!--main banner starts-->
<?php //echo $this->Html->script('frontend/widget'); ?>
<?php //echo $this->Html->script('frontend/date'); ?>
<?php //echo $this->Html->script('frontend/jquery.weekcalendar'); ?>
<?php //echo $this->Html->css('lightslider/lightGallery'); ?>
<?php //echo $this->Html->script('lightslider/lightGallery'); ?>
<?php //echo $this->Html->script('admin/plugins/imagesLoaded/jquery.imagesloaded.min'); ?>
<?php //echo $this->Html->script('admin/plugins/masonry/jquery.masonry.min'); ?>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script> 
<?php $lang =  Configure::read('Config.language'); ?>
<!--tabs main navigation starts-->
<div class="salonData clearfix">
    <div class="main-nav clearfix">
	<?php echo $this->element('frontend/Place/salon_tabs'); ?>
    </div>
    <?php echo $this->element('frontend/Place/all_detail'); ?>
</div>
<!--tabs main navigation ends-->
<?php echo $this->Js->writeBuffer();?>