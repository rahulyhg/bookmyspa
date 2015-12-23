<?php $country_name = '';
$location = '';
$business_type = '';
$salon_name = ''; //pr($this->params); //pr($this->request->data);

     if(isset($this->request->data['Search'])){
      
	if(isset($this->request->data['Search']['country_id'])){
		$get_name = $this->requestAction(array('controller' => 'search', 'action' => 'getCountryName',$this->request->data['Search']['country_id']));
		$country_name = $get_name['Country']['name']; 
	}if(isset($this->request->data['Search']['area'])){
		$location = $this->request->data['Search']['area'];
	}if(isset($this->request->data['Search']['business_type'])){
		$name = $this->requestAction(array('controller' => 'search', 'action' => 'getBusinessName',$this->request->data['Search']['business_type']));
		if(!empty($name)){
			$business_type = $name['BusinessType']['eng_name'];
		}
	}if(isset($this->request->data['Search']['salon_name'])){
		$salon_name = $this->request->data['Search']['salon_name'];
	}
}

?>
<!-- gmap -->
<div class="wrapper">
	<div class="container">
		<!--bread-crms-->
		<div class="bread-crms-drop-down clearfix">
			<ul class="bread-crms clearfix">
				<?php if($country_name != '') { ?>
					<li><a href="#"><?php echo $country_name; ?></a></li>
				<?php } ?>
				<?php if($location != '') { ?>
					<li><i class="fa fa-angle-right"></i></li>
					<li><a href="#"><?php echo $location; ?></a></li>
				<?php } ?>
				<?php if($business_type != '') { ?>
					<li><i class="fa fa-angle-right"></i></li>
					<li><a href="#"><?php echo $business_type; ?></a></li>
				<?php } ?>
				<?php if($salon_name != '') { ?>
					<li><i class="fa fa-angle-right"></i></li>
					<li><a href="#"><?php echo $salon_name; ?></a></li>
				<?php } ?>
			</ul>
			<!--sort by-->
			<div class="top-recmnded">
				<label>Sort By</label>
				<?php //pr($this->data); ?>
				<select name="sort_by" class="custom">
				     <!--<option>Recommended</option>
				     <option value="DESC_featured"> Newest Featured </option>
				     <option value="DESC_featured"> Oldest Featured </option>-->
				     <option value="DESC" <?php if(isset($this->data['sort_by']) && $this->data['sort_by']=='DESC'){ echo "selected=selected"; } ?> > <?php echo __('Newest',true);?> </option>
				     <option value="ASC" <?php if(isset($this->data['sort_by']) && $this->data['sort_by']=='ASC'){ echo "selected=selected"; } ?>  >  <?php echo __('Oldest',true);?></option>
				     <option value="RatingASC" <?php if(isset($this->data['sort_by']) && $this->data['sort_by']=='RatingASC'){ echo "selected=selected"; } ?>  >  <?php echo __('Rating Ascending',true);?></option>
				     <option value="RatingDESC" <?php if(isset($this->data['sort_by']) && $this->data['sort_by']=='RatingDESC'){ echo "selected=selected"; } ?>  >  <?php echo __('Rating Descending',true);?></option>
				</select>
			</div>
			
		<!--sort by ends-->
		</div>
		<!--bread crms-->
		<!----- Area ------------->
		<?php echo $this->element('frontend/Search/left-hand-search'); ?>
		<div class="big-rgt">
			<div class="ajax_search">
			    <?php echo $this->element('frontend/Search/middle-search'); ?>
			</div>
			<?php echo $this->element('frontend/Search/right-hand-search'); ?>
		</div>
	<!--- Area --------------->
	</div>
</div>

<?php 
   // $loc = '["Al Quoz Dubai - Al Quoz - Dubai - United Arab Emirates",25.1526,55.2582],["Al Karama - Dubai - United Arab Emirates",25.2514,55.2917]';
    
    
?>
<!--- Jquery Starts ------------------>
 <script>
 
 var currentRequest = null;
$(function() {
	var min_price = "<?php echo @$this->request->data['min_price'];?>";
	var max_price = "<?php echo @$this->request->data['max_price'];?>";
	if (min_price == '') {
		min_price = 5;
	}
	if (max_price == '') {
		max_price = 5000;
	}
	
	/* Top Search */
	//UserCountryId
	/** Treatment Types */
	$(document).on('click','.showservices' , function(e){
		$(this).html('Hide Services');
		$(this).addClass('moveUp');
		$('.showhidden').removeClass('hidden');	
		
	});
	$(document).on('click','.moveUp' , function(e){
		var html = $(document).find('.showservices').html();
		$(this).html('Show more');
		$(this).removeClass('moveUp');
		$('.showhidden').addClass('hidden');	
	});
	/** Treatment Types */
	
	$(document).on('click','.close-this' , function(){
		var tostrThis = $(this);
		var rel = $(this).closest('div.booking-section').attr('rel');
		$(this).closest('div.booking-section').slideUp('slow',function() { 

			if(rel != ''){
				if(rel == 'map'){
					tostrThis.closest('div.booking-section').prev().prev().addClass('mrgn-btm15');
				}else if(rel == 'gallery'){
					tostrThis.closest('div.booking-section').prev().prev().prev().addClass('mrgn-btm15');
				}else if(rel == 'info'){
					tostrThis.closest('div.booking-section').prev().addClass('mrgn-btm15');
				}else if(rel == 'menu'){
					tostrThis.closest('div.booking-section').prev().prev().prev().prev().addClass('mrgn-btm15');
				}
			}
		});
	});
	
	/********************************** Price range Ui Slider ************************/ 
		$( "#slider-range" ).slider({
			range: true,
			min: 1,
			max: 5000,
			values: [ min_price, max_price ],
			slide: function( event, ui ) {
				//alert(ui.values);
				$( "#amount" ).val( "AED " + ui.values[ 0 ] + " - AED " + ui.values[ 1 ] );
				//  if ( ( ui.values[ 0 ] + 50 ) >= ui.values[ 1 ] ) {
				//	return false;
				//    }
			},
			stop: function( event, ui ) {
				call_price(ui.values[ 0 ] , ui.values[ 1 ])
			}
		});
		$( "#amount" ).val( "AED " + $( "#slider-range" ).slider( "values", 0 ) +" - AED " + $("#slider-range").slider("values", 1));
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
	 var $sModal = $(document).find('#mapSalon');
	$(document).on('click','.largeMap',function(e){
	        loadAPI();
		$sModal.modal('show');
		
	});
	
	    //setTimeout(function(){
	    //   loadAPI();
	    //},2500);
	
});
       function loadNewM(){
	 setTimeout(function(){
			map_initialize();
		},300);
	}

	
	function loadAPI()
	{
	    var script = document.createElement("script");
	    script.type = "text/javascript";
	    script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places;&callback=loadNewM";
	    document.getElementsByTagName('body')[0].appendChild(script);
	}
        function map_initialize(){
		var map;
		var bounds = new google.maps.LatLngBounds();
		var mapOptions = {
			mapTypeId: 'roadmap',
			zoom: 15,
			center: new google.maps.LatLng(-33.92, 151.25),
		};
		// Display a map on the page
		map = new google.maps.Map(document.getElementById("mapAllSalon"), mapOptions);
		map.setTilt(45);
		// Multiple Markers
		var markers = [<?php echo $loc;?>];
		var infoWindowContent = [<?php echo $info;  ?>];
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
	
$(document).ready(function(){	
	var d=new Date();
	var todayDate = d.getDate() + "-" + (d.getMonth() + 1) + "-" + d.getFullYear();
        $('.select_date').datepicker({
		dateFormat: 'dd-mm-yy',
		minDate:todayDate
	});
	
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
		submit_form(form);
	});
});
	
	
</script>
<?php echo $this->Js->writeBuffer();?>