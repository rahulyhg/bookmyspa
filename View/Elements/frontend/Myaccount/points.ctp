<!--tabs main navigation ends-->
<div class="wrapper">
	<div class="container points">
		
		<div class="clearfix bod-btm">
		<!--sort by-->
			<?php echo $this->Form->create('Points', array('url' => array('controller' => 'myaccount', 'action' => 'points') ,'type' =>'post','id'=>"UserForm")) ?>
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
	<div class="appt-tabs table-responsive table-hover">
	   <div class="tab-content">
		 <div class="tab-pane active ajax-render" id="my_appointments">
				<?php //echo $this->element('frontend/Myaccount/pointstable'); ?>
		</div>
	    </div>
	</div>
   </div>
</div>
<style>
    .inner-loader{
	display: none;
    }
</style>
<script>
  
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

