<!--<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script> -->
<script type="text/javascript">
	var currentRequest = null;
	$(document).ready(function(){
		var currentRequest = null;
		$(document).find(".scroll").mCustomScrollbar({
		    advanced:{updateOnContentResize: true}
		});
		/*******************************************check All **************************************/
		$(document).on('click','.service-child-selectall',function(event) {  //on click
			if(this.checked) { // check select status
				$('.service-child').each(function() { //loop through each checkbox
				    this.checked = true;  //select all checkboxes with class "checkbox1"              
				});
				var form = $(this).parents('form:first');
				//alert(form);
				submit_form(form);
			}else{
				$('.service-child').each(function() { //loop through each checkbox
				    this.checked = false; //deselect all checkboxes with class "checkbox1"                      
				});
				var form = $(this).parents('form:first');
				//alert(form);
				//submit_form(form);
				//submit_form();
			}
		});
		//$(document).on('click','.reset' , function(){
		//	
		//    document.getElementById("UserIndexForm").reset();
		//    $(document).find("input[name*='loc']" ).val('');
		//    $(document).find('.treatment-display').hide();
		//});
		 $(document).on('click','.reset' , function(e){
		    e.preventDefault();
		    $(".type_of_search").val('');
		    $("#key_search").val('');
		    $(".service_to").prop('checked',false);
		    $("input[name=select_date]").val('');
		    $("input[name=select_time]").val('');
		    $(".treatment").prop('checked',false);
		    $("#all").val('');
		    $("#UserCountryId").val('');
		    $("#category").val('');
		    $(".service-child").prop('checked',false);
		    //document.getElementById("UserIndexForm").reset();
		    $(document).find("input[name*='loc']" ).val('');
		    $(document).find('.treatment-display').hide();
		    //  setTimeout(function(){
		    //	var form = $(this).parents('form:first');
		    //	submit_form(form) },500);
		    $("#submit_top").click();
		});
		$('.top-recmnded select').select2();
		$(document).on('change','.top-recmnded select' ,function(){
			var form = $(this).parents('form:first');
			//alert(form);
			submit_form(form);
			//submit_form();
		});
		/********************************** Price range Ui Slider ************************/ 
		$(document).on('click','.treatment' , function(e){
			var form = $(this).parents('form:first');
			//submit_form(form);
			
			$('.brad_treatment a').text($(this).next('label').text());
			$('.brad_treatment').show();
			//alert('sdf');
			var service_id = $(this).val();
			var serviceText = $.trim($(this).next().html());
			//alert(serviceText);
			$('.type_of_search').val(5);
			$('#category').val(service_id);
			$('#key_search').val(serviceText);
			var getURL = "<?php echo $this->Html->url(array('controller'=>'Search','action'=>'getservice','admin'=>false)); ?>";
			currentRequest = $.ajax({
				url: getURL+'/'+service_id,	
				type: 'GET',
				beforeSend: function() {
					if(currentRequest != null) {
						currentRequest.abort();
					}
				},
				success:function(data){
					$('.treatment-display').css('display','block');
					if(data != ''){
						//alert(data); 
						$('.treat-child').html(data);
						$('.treat-child').find(".service-child-selectall").trigger("click");
					} else{
						$('.treat-child').html("<span style='margin-left: 26px;'>No Treatment available</span>");
					}
				}
			});
		});
		
		$('#UserIndexForm').off().on('click','.sold_as' , function(){
			var form = $('#UserIndexForm');
			//alert(form);
			submit_form(form);
			//submit_form();
		});
		$('#UserIndexForm').on('click','.i_want', function(){
			var form = $('#UserIndexForm');
			submit_form(form);
		});
		$('#UserIndexForm').on('click','.service_to' , function(){
			var form = $('#UserIndexForm');
			submit_form(form);
		});
			/********************************************************************************/
		$(document).on('click','.service-child',function(e){
			$('.filter_service').val($(this).val());
			$('.brad_treatment_type a').text($(this).next('label').text());
			$('.brad_treatment_type').show();
			var form = $(this).parents('form:first');
			//alert(form);
			submit_form(form);
			//submit_form();	
		});
	});
    
	function call_price(min , max){
	       
		$('#min_price').val(min);
		$('#max_price').val(max);
		var form = $('#UserIndexForm');
		//alert(form);
		submit_form(form);
		//submit_form();
	}
        
	
	
	
	function auto_complete(keyword , country_id){
		if(keyword != ''){
			var getURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'autosearch','admin'=>false)); ?>";
			//var form = $(this).parents('form:first');
			//submit_form(form);
			currentRequest = $.ajax({
				url: getURL+'/'+keyword+'/'+country_id,	
				type: 'GET',
				beforeSend: function() {
					if(currentRequest != null) {
						currentRequest.abort();
					}    
				},
				success:function(data){
					$('#locations-left').css('display','block');
					$('#locations-left').slideDown('slow');
					$('#locations-left').html(data);
					$(document).find(".scroll").mCustomScrollbar({
						advanced:{updateOnContentResize: true}
					});
				}
			});
		}else{
			$('#locations-left').hide('slow');	
		}
	}
	
	function set_useritem(item){
		//$('.reset').trigger('click');
		var type = item.split(',');
		$('#pac-input').val(type[1]);
		$('#loc').val(type[0]);
		$('.brad_location a').text(type[1]);
		$('.brad_location').show();
		$('#locations-left').hide('slow');
		/*** Call Search **********/
		var form = $('#UserIndexForm');
		submit_form(form);
		//submit_form();
		/*** Call Search **********/
	}
  
	function set_searchitemNew(item){
		//$('.reset').trigger('click');
		reset_withoutsubmit();
		var type = item.split('__').pop();
		var value=item.slice(0, -3);
		$('.type_of_search').val(type);
		$('.search_value').val(value);
		$('#key_search').val(value);
                $('#fullsearch').hide('slow');
	}
	function set_searchitem(item){
		//$('.reset').trigger('click');
		reset_withoutsubmit();
		var splitN = item.split('_');
		var type = splitN[1].split('-');
		var value=splitN[0];
		var ser = type[0];
		var cat = type[1];
		//alert(cat);
		$("#serviceId").val(ser);
		$("#newservice").val(ser);
		//alert(cat);
		//alert(value);
		//alert(ser);
		$("#serviceCategoryId").val(cat);
		$('.type_of_search').val(1);
		$('.search_value').val(value);
		$('#key_search').val(value);
                $('#fullsearch').hide('slow');
	}
	
	function set_searchitemlocation(item){
		//('.reset').trigger('click');
		reset_withoutsubmit();
		var split = item.split('_');
		var type = item.split('__').pop();
		var value=item.slice(0, -3);
		//alert(type);
		$('.type_of_search').val(type);
		$('.search_value').val(split[0]);
		$('#key_search').val(split[0]);
		$('#city').val(split[1]);
                $('#fullsearch').hide('slow');
	}
	
	function set_searchitemcat(item){
		//$('.reset').trigger('click');
		reset_withoutsubmit();
		var split = item.split('_');
		var type = item.split('__').pop();
		var value=item.slice(0, -3);
		$('.type_of_search').val(type);
		$('.search_value').val(split[0]);
		$('#key_search').val(split[0]);
		$('#category').val(split[1]);
                $('#fullsearch').hide('slow');
	}
	
  
	$(function() {
		/********** Map Function ***************/
		//map_initialize();
		$('#key_search').keyup(function(){
			var keyword = $(this).val();
			if(keyword == ''){
				keyword = 'null';
			}
			controllerName ='<?php echo $this->params["controller"]; ?>';
			var country = $('#UserCountryId').val();
			
				var getURL = "<?php echo $this->Html->url(array('controller'=>'Search','action'=>'getallsearch','admin'=>false)); ?>";
				currentRequest = $.ajax({
					url: getURL+'/'+keyword+'/'+country,	
					type: 'POST',
					data:{
						controllerName:controllerName
					},
					beforeSend: function() {
						if(currentRequest != null) {
							currentRequest.abort();
						}    
					 },
					success:function(data){
						if(data != ''){
							$('#fullsearch').show('slow');
							$('#fullsearch').html(data);
							$(document).find(".scrolling").mCustomScrollbar({
								advanced:{updateOnContentResize: true}
							});
						}
					}
				});
			//} else{
			//	$('#key_search').val('');
			//	$('.country').focus();
			//}
		});
		$(document).on('focus','#key_search',function(){
			//$('.reset').trigger('click');
			$('#category').val('');
			$('.type_of_search').val('');
			//$(".type_of_search").val('');
			//$("#key_search").val('');
			//$(".service_to").prop('checked',false);
			//$("input[name=select_date]").val('');
			//$("input[name=select_time]").val('');
			//$(".treatment").prop('checked',false);
			//$("#all").val('');
			//$("#UserCountryId").val('');
			//$("#category").val('');
			//$(".service-child").prop('checked',false);
			////document.getElementById("UserIndexForm").reset();
			//$(document).find("input[name*='loc']" ).val('');
			//$(document).find('.treatment-display').hide();
		});
		$(document).on('click','#submit_top' , function(e){
			var loc = $('#UserCountryId').val();
			$('#update_ajax').find('input:text').val('');
			$('#update_ajax').find('input:radio').attr('checked',false);
			
			if(loc != ''){
			    $('#UserCountryId').val(loc);
			}
			$('.type_post').val(1);
			$('.filter_service').val('');
			var form = $(this).parents('form:first');
			//alert(form);
			submit_form(form);
			//submit_form();
			  trigger_servicecat();
			});
	});
	$(document).ready(function(){
		//trigger_servicecat();
	});
	function trigger_servicecat(){
	    setTimeout(function(){
			var type = $(document).find(".type_of_search").val();
			//alert(type);
			if (type==5) {
				var category = $(document).find("#category").val();
				//alert('input[value='+category+']');
				var obj = $(document).find(".treatmentTT").find('input[value='+category+']');
				obj.closest("li").removeClass("showhidden").removeClass("hidden");
				obj.trigger('click');
			}
			if (type==1) {
				var catId = $(document).find("#serviceCategoryId").val();
				var serviceId = $(document).find("#newservice").val();
				//alert(catId);
				//alert(serviceId);
				var obj = $(document).find(".treatmentTT").find('input[value='+catId+']');
				obj.closest("li").removeClass("showhidden").removeClass("hidden");
				obj.prop('checked',true);
				$('.type_of_search').val(5);
				$('#category').val(catId);
				$('#key_search').val('');
				var getURL = "<?php echo $this->Html->url(array('controller'=>'Search','action'=>'getservice','admin'=>false)); ?>";
				currentRequest = $.ajax({
					url: getURL+'/'+catId,	
					type: 'GET',
					beforeSend: function() {
					     if(currentRequest != null) {
						currentRequest.abort();
					     }    
					},
					success:function(data){
						$('.treatment-display').css('display','block');
						if(data != ''){
							//alert(data); 
							$('.treat-child').html(data);
							$('.treat-child').find("#service_"+serviceId).trigger("click");
						} else{
							$('.treat-child').html("<span style='margin-left: 26px;'>No Treatment available</span>");
						}
					}
			       });
			}
			//alert($(document).find("#salonName").val());
			$(document).find("#salonName").val(' ');
			},500);
	   
	}
    
	function submit_form(form){ 
		var options = {
			beforeSend: function() {
                                show_ajax();
			},
			success:function(res){
				//console.log('hererer');
				//$(document).find('.top-recmnded custom').select2();
				$('#update_ajax').html('');
				//alert(res);
				$('#update_ajax').html(res);
				$('.top-recmnded select').select2();
					$("html, body").animate({
						//scrollTop: 50
					}, 1500);  
                        hide_ajax();
			
			}
		};
		
		form.ajaxSubmit(options);
		//alert();
		form.unbind('submit');
		form.bind('submit');
		return false;
	}
	
	function reset_withoutsubmit(){
	    $('#category').val('');
	    $('.type_of_search').val('');
	    //$(".type_of_search").val('');
	    $("#key_search").val('');
	    $(".service_to").prop('checked',false);
	    $("input[name=select_date]").val('');
	    $("input[name=select_time]").val('');
	    $(".treatment").prop('checked',false);
	    $("#all").val('');
	    $("#UserCountryId").val('');
	    $("#category").val('');
	    $(".service-child").prop('checked',false);
	    document.getElementById("UserIndexForm").reset();
	    $(document).find("input[name*='loc']" ).val('');
	    $(document).find('.treatment-display').hide();
	    
	}
</script>