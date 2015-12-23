<script>
    var currentRequest = null;
    //var loc = [<?php //echo $loc;  ?>];
    //var info = [<?php //echo $info;  ?>];
    $(document).ready(function(){
        //submit_form();         
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
            submit_form();
        }else{
            $('.service-child').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
             submit_form();
        }
    });
   
    $(document).on('click','.reset' , function(){
        document.getElementById("UserIndexForm").reset();
        $(document).find("input[name*='loc']" ).val('');
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
    $(document).on('click','.i_want' , function(){
     $('.brad_salon_type a').text($(this).next('label').text());
     $('.brad_salon_type').show();
        submit_form();
    });
                $(document).on('click','.service_to' , function(){
                        $('.brad_salon_type a').text($(this).next('label').text());
                        $('.brad_salon_type').show();
        submit_form();
    });

    $(document).on('click','.break_type' , function(){
        $('.brad_salon_type a').text($(this).next('label').text());
        $('.brad_salon_type').show();
        submit_form();
    });
    $(document).on('click','.sold_as' , function(){
            submit_form();
    });

/********************************************************************************/
    $(document).on('click','.service-child',function(e){
        $('.filter_service').val($(this).val());
        $('.brad_treatment_type a').text($(this).next('label').text());
        $('.brad_treatment_type').show();
        submit_form();	
    });	
 });
    
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
        }else{           
            $("#loc").val("");
            $('#locations-left').hide('slow');	
            submit_form();
        }
    }

    function set_useritem(item){
       var type = item.split(',');
       $('#pac-input').val(type[1]);
       $('#loc').val(type[0]);
       $('.brad_location a').text(type[1]);
       $('.brad_location').show();
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
		//$("#serviceId").val(ser);
		//alert(cat);
		//alert(value);
		//alert(ser);
		//$("#serviceCategoryId").val(cat);
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
    /********** Map Function ***************/

    //map_initialize();
    /********************************************************************************/
    //		var $sModal = $(document).find('#mapSalon');
    //                    $sModal.modal('show');
    //                    setTimeout(function(){
    //                    google.maps.event.trigger(map, 'resize');            
    //                    },500);

    ////                     initialize();
    /********************************top Search************************************************/            
                    
    $('#key_search').keyup(function(){
        var keyword = $(this).val();
        if(keyword == ''){
            keyword = 'null';
        }
        controllerName ='<?php echo $this->params["controller"]; ?>';
        var country = $('#UserCountryId').val();
        if(country !=''){
            var getURL = "<?php echo $this->Html->url(array('controller'=>'Spabreaks','action'=>'getallspabreaks','admin'=>false)); ?>";
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
        }else{
            $('#key_search').val('');
            $('.country').focus();

        }
    })

    $(document).on('click','#submit_top' , function(e){
        $('.type_post').val(1);
        $('.filter_service').val('');
        submit_form();

    })       

})
    /*var $sModal = $(document).find('#mapSalon');
    $(document).on('click','.largeMap',function(e){
        $sModal.modal('show');
        setTimeout(function(){
            map_initialize();
            },500);
    });

    function map_initialize(){
        var map;
        var bounds = new google.maps.LatLngBounds();
        var mapOptions = {
            mapTypeId: 'roadmap',
                zoom: 2,
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
    }*/
</script>

<div class="mapAllSalon">
    
    
    
</div>