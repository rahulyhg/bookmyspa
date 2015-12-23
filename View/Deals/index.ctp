
<?php 
    echo $this->element('frontend/Search/search-bar'); 
    echo $this->Html->script('datepicker/datepicker-js'); 
    echo $this->Html->css('datepicker/datepicker-css');
    echo $this->Html->script('admin/jquery.timepicker');
    echo $this->Html->css('admin/jquery.timepicker');
    
?>

<div class="wrapper">
<div class="container">
<!--bread-crms-->
<div class="bread-crms-drop-down clearfix">
    <ul class="bread-crms clearfix">
     <!-- <li><a href="#">Dubai</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li><a href="#">Discovery Garden</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li><a href="#">Men?s Only</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li><a href="#">Face</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li><a href="#">Facial</a></li>
      <li><i class="fa fa-angle-right"></i></li>
      <li><a href="#">24K Gold Facial</a></li>-->
    </ul>
<!--bread crms-->

    <!--sort by-->
	<div class="top-recmnded">
		<label>Sort By</label>
		<select name="sort_by" class="custom_option">
		     <!--<option>Recommended</option>
		     <option value="DESC_featured"> Newest Featured </option>
		     <option value="DESC_featured"> Oldest Featured </option>-->
		     <option value="DESC"> <?php echo __('Newest',true);?> </option>
		     <option value="ASC">  <?php echo __('Oldest',true);?></option>
		</select>
	</div>
 </div>
    <!--sort by ends-->
    <!--main body section-->
    
    <div class="v-left-side" id ="bs-example-navbar-collapse-2">
	<?php echo $this->element('frontend/Deals/left-hand-filter'); ?>
    </div>
    <div class="v-middle-add">
	<?php echo $this->element('frontend/Deals/middle-add'); ?>
    </div>
    <!--main body section-->
</div>


</div>
<?php echo $this->Form->end(); ?>   
<?php echo $this->element('frontend/Search/common_search_deal');  ?>

<script>
  $(document).ready(function(){
	$(document).on('click','.showservices' , function(e){
		$(this).html('Hide Services');
		$(this).addClass('moveUp');
		$('.showhidden').removeClass('hidden');	
		
	})
	
	$(document).on('click','.moveUp' , function(e){
		var html = $(document).find('.showservices').html();
		$(this).html('Show more');
		$(this).removeClass('moveUp');
		$('.showhidden').addClass('hidden');	
	});
	
	
   /**************************************** bradcrumb actions ***********************/
      $(document).on('click','.brad_country', function(){
            $("input[name*='loc'] ,input[name*='location']").val('');
            $(".top-recmnded .custom_option option:selected").prop("selected", false);
            $('.top-recmnded select').select2();
            $('.service_to').prop('checked', false);
            $('.treatment').prop('checked', false);
            $('.service-child').prop('checked', false);
            $('.brad_location,.brad_salon_type,.brad_treatment,.brad_treatment_type').hide();
            submit_form();
      });   
        
     $(document).on('click','.brad_location', function(){
            $(".top-recmnded .custom_option option:selected").prop("selected", false);
            $('.top-recmnded select').select2();
            $('.service_to').prop('checked', false);
            $('.treatment').prop('checked', false);
            $('.service-child').prop('checked', false);
            $('.brad_salon_type,.brad_treatment').hide();
            submit_form();
   });   
   
    $(document).on('click','.brad_salon_type', function(){
      $(".top-recmnded .custom_option option:selected").prop("selected", false);
      $('.top-recmnded select').select2();
      $('.treatment').prop('checked', false);
      $('.service-child').prop('checked', false);
      if($(".brad_treatment").is(":visible")){
         submit_form();
      }
      $('.brad_treatment,.brad_treatment_type').hide();
   });
   $(document).on('click','.brad_treatment', function(){
      $(".top-recmnded .custom_option option:selected").prop("selected", false);
      $('.top-recmnded select').select2();
      $('.treatment').prop('checked', false);
      $('.service-child').prop('checked', false);
      if($(".brad_treatment_type").is(":visible")){
         submit_form();
      }
      $('.brad_treatment_type').hide();
   });
   /*****Start Show more functionality*******
   var num_messages = <?=$countTreatment?>;
   var loaded_messages = 0;
    $(".show-more").click(function(){
	
            loaded_messages += 10;
            $.ajax({
            async:false,
            url: "Stylists/get_services/" + loaded_messages,
            success:function(loadData){
                var showCountTreatment=num_messages-10-loaded_messages;
                $('#getTreatmentType').append(loadData);
                $('#countTreatmentShow').text('('+showCountTreatment+')');

            }
        });

            if(loaded_messages >= num_messages - 10)
            {
                    $("#more_button").hide();
                    //alert('hide');
            }
    });
    if(loaded_messages >= num_messages - 10)
    {
            $("#more_button").hide();
            //alert('hide');
    }
    /*****End Show more functionality*******/
    
    $(".reset").click(function(){
        location.reload(true);
    });
    
    var d=new Date();
	var todayDate = d.getDate() + "-" + (d.getMonth() + 1) + "-" + d.getFullYear();
        $('.select_date').datepicker({
		dateFormat: 'dd-mm-yy',
		minDate:todayDate
	});
	
	//$('.select_date').val(todayDate);
        $('.timePKr').timepicker();
})  
    
function submit_form(){
   
        var options = {
                beforeSend: function(){
                   show_ajax();
                },
                success:function(res){
			$('.v-middle-add').html('');
                        $('.v-middle-add').html(res);
                        $("html, body").animate({
                            scrollTop: 0
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
$('.main-search .navbar-toggle').on('click',function(){
	               
				if(!$("#bs-example-navbar-collapse-2").hasClass('in')){
					
				   $('.big-rgt,.v-middle-side').css('margin-top','1300px');
				   $('#ajax_modal').show();
				   setTimeout(function(){
				    $('#ajax_modal').hide();
					     $('.big-rgt,.v-middle-side').css('margin-top','0px');
				   },5500);   
				}else{
				    $('#ajax_modal').hide();
				   $('.big-rgt,.v-middle-side').css('margin-top','0px');
				}
				
			});
  });	

//var $sModal = $(document).find('#mapSalonStylist');
//		$(document).on('click','.largeMapStylist',function(e){
//                $sModal.modal('show');
//                    setTimeout(function(){
//                        map_initialize(); },1000);
//                    });
//
//            function map_initialize(){
//                        var map;
//                            var bounds = new google.maps.LatLngBounds();
//                            var mapOptions = {
//                                mapTypeId: 'roadmap',
//                                    zoom: 15,
//                                    center: new google.maps.LatLng(-33.92, 151.25),
//                            };
//
//                            // Display a map on the page
//                            map = new google.maps.Map(document.getElementById("mapAllSalon"), mapOptions);
//                            map.setTilt(45);
//                            // Multiple Markers
//                            var markers = [<?php echo $loc;  ?>];
//                            var infoWindowContent = [<?php echo $info;  ?>];
//
//                            // Display multiple markers on a map
//                            var infoWindow = new google.maps.InfoWindow(), marker, i;
//
//                            // Loop through our array of markers & place each one on the map  
//                            for( i = 0; i < markers.length; i++ ) {
//                                var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
//                                bounds.extend(position);
//                                marker = new google.maps.Marker({
//                                    position: position,
//                                    map: map,
//                                    title: markers[i][0],
//                                });
//
//                                // Allow each marker to have an info window    
//                                google.maps.event.addListener(marker, 'click', (function(marker, i) {
//                                    return function() {
//                                        infoWindow.setContent(infoWindowContent[i][0]);
//                                        infoWindow.open(map, marker);
//                                    }
//                                })(marker, i));
//
//                                // Automatically center the map fitting all markers on the screen
//                                map.fitBounds(bounds);
//                            }   
//                 
//  }

</script>