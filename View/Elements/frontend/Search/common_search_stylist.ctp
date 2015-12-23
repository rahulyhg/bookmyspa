<script>
var currentRequest = null;
var loc = '';//[<?php echo $loc;  ?>];
var info = '';//[<?php echo $info;  ?>];
$(document).ready(function(){
    var currentRequest = null;
    $(document).find(".scroll").mCustomScrollbar({
	advanced:{updateOnContentResize: true}
    });
    
    /*******************************************check All **************************************/
    $(document).off('click','.service-child-selectall').on('click','.service-child-selectall',function(event) {  //on click
        if(this.checked) { // check select status
            $('.service-child').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
            submit_form();
        }else{
            $('.service-child').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
             submit_form();
        }
    });
    $(document).on('click','.reset' , function(e){
	e.preventDefault();
	$(".type_of_search").val('');
	$("#key_search").val('');
	$(".service_to").prop('checked',false);
	$("input[name=select_date]").val('');
	$("input[name=select_time]").val('');
	$(".treatment").prop('checked',false);
	$("#all").val('');
	//$("#UserCountryId").val('');
	$("#category").val('');
	$(".service-child").prop('checked',false);
	//document.getElementById("UserIndexForm").reset();
	$(document).find("input[name*='loc']" ).val('');
	$(document).find('.treatment-display').hide();
	setTimeout(function(){
	submit_form(); },500);
    });
    $('.top-recmnded select').select2();
    $(document).on('change','.top-recmnded select' ,function(){
	submit_form();
    });
    $(document).on('change','.select_date' ,function(){
	var value=$(this).val();
	$('#select_date').val(value);
	submit_form();
    });
    $(document).off('change','.select_time').on('change','.select_time' ,function(){
	var value= $(this).val();
	$('#select_time').val(value);
	submit_form();
    });
   /********************************** Price range Ui Slider ************************/
   var nFlag = 'true';
    $(document).off('click','.treatment').on('click','.treatment' , function(e){
	//alert('sdf');
	//var service_id = $(this).val();
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
		     $('.treat-child').html('');
			$('.treat-child').html(data);
			$('.treat-child').find(".service-child-selectall").unbind('click').trigger("click");
			
		}else{
		    $('.treat-child').html("<span style='margin-left: 26px;'>No Treatment available</span>");
		}
	    }
	});
    });
    
    $(document).on('focus','#key_search',function(e){
	e.preventDefault();
	$(".type_of_search").val('');
	//$("#key_search").val('');
	//$(".service_to").prop('checked',false);
	//$("input[name=select_date]").val('');
	//$("input[name=select_time]").val('');
	//$(".treatment").prop('checked',false);
	//$("#all").val('');
	////$("#UserCountryId").val('');
	$("#category").val('');
	//$(".service-child").prop('checked',false);
	////document.getElementById("UserIndexForm").reset();
	//$(document).find("input[name*='loc']" ).val('');
	//$(document).find('.treatment-display').hide();
    });
    /********************************** Price range Ui Slider ************************/ 
    $( "#slider-range" ).slider({
	range: true,
	min: 5,
	max: 5000,
	values: [ 5, 5000 ],
	slide: function( event, ui ) {
	    $( "#amount" ).val( "ADE " + ui.values[ 0 ] + " - ADE " + ui.values[ 1 ] );
	},
	stop: function( event, ui ) {
	    call_price(ui.values[ 0 ] , ui.values[ 1 ])
	}
    });
    $( "#amount" ).val( "ADE " + $( "#slider-range" ).slider( "values", 0 ) +" - ADE " + $("#slider-range").slider("values", 1));
    /************************************location autocomplete****************************************************/
    $('#pac-input').keyup(function(){
	var keyword = $(this).val();
	var country_id = $('#UserCountryId').val();
	if(country_id != ''){
	    auto_complete(keyword,country_id);
	}else{
	    $('#UserCountryId').focus();
	}
    });
    $(document).off('click','.service_to').on('click','.service_to' , function(){
	submit_form();
    });
    /********************************************************************************/
    $(document).off('click','.service-child').on('click','.service-child',function(e){
	$('.filter_service').val($(this).val());
	submit_form();	
    });
   //submit_form();
})
    
function call_price(min , max){
    $('#min_price').val(min);
    $('#max_price').val(max);
    submit_form();
}
    
function auto_complete(keyword , country_id){
    if(keyword != ''){
	var getURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'autosearch','admin'=>false)); ?>";
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
    } else {
	$('#locations-left').hide('slow');	
    }
}

function set_useritem(item){
   var type = item.split(',');
   $('#pac-input').val(type[1]);
   $('#loc').val(type[0]);
   $('#locations-left').hide('slow');
    /*** Call Search **********/
    submit_form();
    /*** Call Search **********/
}

function set_searchitem(item){
	//$('.reset').trigger('click');
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

function set_searchitemNew(item){
    //$('.reset').trigger('click');
    var type = item.split('__').pop();
    var value=item.slice(0, -3);
    $('.type_of_search').val(type);
    $('.search_value').val(value);
    $('#key_search').val(value);
    $('#fullsearch').hide('slow');
}
    
function set_searchitemlocation(item){
    var split = item.split('_');
    var type = item.split('__').pop();
    var value=item.slice(0, -3);
    $('.type_of_search').val(type);
    $('.search_value').val(split[0]);
    $('#key_search').val(split[0]);
    $('#city').val(split[1]);
    $('#fullsearch').hide('slow');
}

function set_searchitemcat(item){
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
    $('#key_search').keyup(function(){
	
	var keyword = $(this).val();
	if(keyword == ''){
	    keyword = 'null';
	}
	controllerName ='<?php echo $this->params["controller"]; ?>';
	var country = $('#UserCountryId').val();
	//if(country !=''){
	    var getURL = "<?php echo $this->Html->url(array('controller'=>'Search','action'=>'getallsearch','admin'=>false)); ?>";
	    currentRequest = $.ajax({
		url: getURL+'/'+keyword+'/'+country,	
		type: 'POST',
		data:{controllerName:controllerName},
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
	//    $('#key_search').val('');
	//    $('.country').focus();
	//}
    });
    $(document).off('click', '#submit_top').on('click','#submit_top' , function(e){
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
			var type = $(document).find(".type_of_search").val();
			
			if (type==5) {
				var category = $(document).find("#category").val();
				//alert(category);
				//alert('input[value='+category+']');
				var obj = $(document).find(".treatmentTT").find('input[value='+category+']');
				obj.closest("li").removeClass("showhidden").removeClass("hidden");
				obj.trigger('click');
			}
			if (type==1) {
				var catId = $(document).find("#serviceCategoryId").val();
				var serviceId = $(document).find("#newservice").val();
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
    });
});

var $sModal = $(document).find('#mapSalonStylist');
$(document).on('click','.largeMapStylist',function(e){
    $sModal.modal('show');
    setTimeout(function(){
    map_initialize(); },500);
});

function map_initialize(){
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
	mapTypeId: 'roadmap',
	zoom: 5,
	center: new google.maps.LatLng(-33.92, 151.25),
    };
    // Display a map on the page
    map = new google.maps.Map(document.getElementById("mapAllSalon"), mapOptions);
    map.setTilt(45);
    // Multiple Markers
    var markers = loc;
    var infoWindowContent = info;
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
	var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
	bounds.extend(position);
	marker = new google.maps.Marker({
	    position: position,
	    map: map,
	    title: markers[i][0],
	});
	// Allow each marker to have an info window    
	google.maps.event.addListener(marker, 'click', (function(marker, i) {
	    return function() {
		infoWindow.setContent(infoWindowContent[i][0]);
		infoWindow.open(map, marker);
	    }
	})(marker, i));
	// Automatically center the map fitting all markers on the screen
	map.fitBounds(bounds);
    }
}
</script>
<div class="mapAllSalon"> </div>