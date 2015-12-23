<div class="wrapper">
    <div class="container"> 
	<!--bread-crms-->
	<div class="bread-crms-drop-down clearfix">
	    <ul class="bread-crms clearfix"></ul>
	    <div class="top-recmnded">
		<label>Sort By</label>
		<select name="sort_by" class="custom_option">
		    <option value="DESC"> <?php echo __('Newest',true);?> </option>
		    <option value="ASC">  <?php echo __('Oldest',true);?></option>
		</select>
	    </div>
	</div>
	<!--sort by ends-->
	<!--main body section-->
	<div class="v-left-side collapse" id="bs-example-navbar-collapse-2">
	    <?php echo $this->element('frontend/Stylist/left_search'); ?>
	</div>
	<div class="big-rgt">
	    <?php echo $this->element('frontend/Stylist/middle-add'); ?>
	</div>
	<!--main body section-->
    </div>
</div>
<?php echo $this->element('frontend/Search/common_search_stylist');  ?>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
<?php echo $this->Html->script('datepicker/datepicker-js'); ?>
<script type="text/javascript">
    
    function submit_form(){
	
	//$(this).unbind('submit');
	var options = {
	    beforeSend: function(){
	       show_ajax();
	    },
	    success:function(res){
		$('.big-rgt').html('');
                $('.big-rgt').html(res);
		//$('#update_ajax').html('');
		//$('#update_ajax').html(res);
		$("html, body").animate({
		    //scrollTop: 0
		}, 1500);  
		hide_ajax(true);
	    }
	};
	$('#UserIndexForm').ajaxSubmit(options);
	$(this).unbind('submit');
	$(this).bind('submit');
	return false;
    } 
$(document).ready(function(){	
	var d=new Date();
	var today = d.getDate() + "/" + (d.getMonth() + 1) + "/" + d.getFullYear();
	$('.select_date').datepicker({'dateFormat': 'd/m/yy',minDate:today});
	$('.select_date').val(today);
	
	//$('.select_date').val(todayDate);
        $('.timePKr').timepicker();
	
	
	$('.select_date').blur(function(){
		var form = $('#UserIndexForm');
		setTimeout(function(){
			submit_form(form);
		},1000);
		
	});
	$('.select_time').blur(function(){
		var form = $('#UserIndexForm');
		setTimeout(function(){
			submit_form(form);
		},1000);
	});
});
	
</script>
