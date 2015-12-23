<?php $lang =  Configure::read('Config.language'); ?>
<!--tabs main navigation starts-->
<div class="salonData clearfix">
    <div class="main-nav clearfix">
	<?php  echo $this->element('frontend/Myaccount/my_tabs'); ?>
    </div>
     <div class="container bukingService">
	 <div class="contact">
    	
		<p class="coming-soon">Coming Soon...</p>
                
	</div>
</div>
</div>
<style>
    .inner-loader{
	display: none;
    }
</style>
<!--tabs main navigation ends-->
<?php echo $this->Js->writeBuffer();?>
