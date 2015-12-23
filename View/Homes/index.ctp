<div class="wrapper">
	<?php //echo $this->element('frontend/Home/admin_featured_services'); ?>
	<?php echo $this->element('frontend/Home/admin_frontend_services'); ?>
	<?php echo $this->element('frontend/Home/admin_spadaybreak_service'); ?>
	<?php //echo $this->element('frontend/Home/admin_spadays_service'); ?>
	<?php //echo $this->element('frontend/Home/admin_lastminutedeal'); ?>
</div>
<?php if(isset($secure)&& $secure=='secure_check' && isset($url) && !empty($url)) {?>
<script>
$(document).ready(function(){
var $sModal = $(document).find('#mySmallModal');
var url = "<?php echo $url;?>";
 var addServiceURL = "<?php echo $this->Html->url(array('controller'=>'users','action'=>'secure_check','admin'=>false)); ?>";
//fetchModal($sModal,addServiceURL+'/'+url);
$sModal.load(addServiceURL+'/'+url,function(){
		$sModal.modal('show');
                //regValid = registrationValidate();
	    });

});
</script>

<?php } ?>

<script type="text/javascript">

var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();

(function(){

	var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
	
	s1.async=true;
	
	s1.src='https://embed.tawk.to/55ff9b2aec060d141f446d58/default';
	
	s1.charset='UTF-8';
	
	s1.setAttribute('crossorigin','*');
	
	s0.parentNode.insertBefore(s1,s0);

})();

</script>
<script>
	$(document).ready(function(){
		 var $bannerModal = $(document).find('#myModal');
		var BannerURL = "<?php echo $this->Html->url(array('controller'=>'homes','action'=>	'banner','admin'=>false)); ?>";
		$bannerModal.load(BannerURL,function(){
		$bannerModal.modal('show');
	});
});
</script>