<!--tabs main navigation ends-->
<div class="wrapper">
	<div class="container points">
		
        <div class="clearfix bod-btm">
        <!--sort by-->
        <?php echo $this->Form->create('Bookmarks', array('url' => array('controller' => 'myaccount', 'action' => 'bookmarks') ,'type' =>'post','id'=>"UserForm")) ?>
        <div class="top-recmnded pull-left">
        <label>Show</label>
        <select name="filter_list" id="filter_points" class="custom_option">
            <option>All</option>
             <option value="1"> Newest </option>
             <option value="0"> Oldest </option>
        </select>
        </div>
        </div>

		<!--inner content starts-->
    <div class="appt-tabs">
	
		<?php echo $this->element('frontend/Myaccount/bookmarktable'); ?>
	   
    </div>
<style>
    .inner-loader{
	display: none;
    }
</style>
<script>
	function submit_form(){ 
		var options = {
			beforeSend: function() {
                                show_ajax();
			},
			success:function(res){
				$('.bukingService .appt-tabs').html('');
				$('.bukingService .appt-tabs').html(res);
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
  
	$(".custom_option").each(function(){
        $(this).wrap("<span class='option_wrapper'></span>");
        $(this).after("<span class='holder'></span>");
        });
	
        $(".custom_option").change(function(){
            var selectedOption = $(this).find(":selected").text();
            $(this).next(".holder").text(selectedOption);
        }).trigger('change');
	
	$('#filter_points').change(function(){
		 var selectedOption = $(this).find(":selected").val();
		 submit_form();
	});
	
	
</script>	

