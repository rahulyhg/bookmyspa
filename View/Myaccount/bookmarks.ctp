<div class="salonData clearfix">
    <div class="main-nav clearfix">
	<?php  echo $this->element('frontend/Myaccount/my_tabs'); ?>
    </div>
     <div class="container bukingService">
	<?php echo $this->element('frontend/Myaccount/bookmarks'); ?>
     </div>
</div>
<?php echo $this->Js->writeBuffer();?>