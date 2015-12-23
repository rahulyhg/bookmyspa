
<?php $lang =  Configure::read('Config.language'); ?>
<!--tabs main navigation starts-->
<?php
$this->Paginator->options(array(
        'update' => '#update_ajax',
        'evalScripts' => true,
        'before' => $this->Js->get('#paginated-content-container')->effect('fadeIn', array('buffer' => false)),
        'success' => $this->Js->get('#paginated-content-container')->effect('fadeOut', array('buffer' => false))
    ));
    ?>
<div class="salonData appot clearfix">
    <div class="main-nav clearfix">
	<?php  echo $this->element('frontend/Myaccount/my_tabs'); ?>
    </div>
     <div class="container bukingService">
	<?php echo $this->element('frontend/Myaccount/gifts'); ?>
     </div>
    
    
</div>
<!--tabs main navigation ends-->

<script>
function submit_form(){ 
		var options = {
			beforeSend: function() {
                                show_ajax();
			},
			success:function(res){
				$('.bukingService .ajax-render').html('');
				$('.bukingService .ajax-render').html(res);
				$("html, body").animate({
					scrollTop: 0
				}, 1500);  
                        hide_ajax();
			}
		};
		$('#UserForm').ajaxSubmit(options);
		$(this).unbind('submit');
		$(this).bind('submit');
		return false;
	}
</script>
<?php echo $this->Js->writeBuffer();?>
