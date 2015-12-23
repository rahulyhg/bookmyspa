<script>
 
 var currentRequest = null;
$(function() {
	
	/* Top Search */

	//UserCountryId
	/** Treatment Types */
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
	
	 /** Treatment Types */
	// set effect from select menu value
        $(document).on('click','.toggleAll' , function(){
		$(this).closest('.mainBookSection').removeClass('mrgn-btm15');  
		var getId = $(this).closest('ul').attr('data-id');
		$(document).find('div.allInfo_'+getId).slideUp('slow');
		if($(this).hasClass('info')){
			$(document).find('div#info_'+getId).slideDown('slow');
		}
		if($(this).hasClass('gallery')){
			$('#gallery_'+getId).slideDown('slow');
			if(!$(this).attr('rel')){
				$(this).attr('rel',1)
				var slider= $('#lightSlider_'+getId).lightSlider({
					gallery: true,
					item: 1,
					loop: true,
					slideMargin: 0,
					thumbItem: 9
				});
			}
		}
		if($(this).hasClass('map')){
			$('#mapData_'+getId).css('display','block');
			var location = $(document).find("#mapData_"+getId).find('input').val();
			var getlocation = location.split(",");
			var lat     = getlocation[0];
			var long    = getlocation[1];
			var mapOptions = {
				zoom: 15,
				center: new google.maps.LatLng(lat, long)
			};
			alert(long);
			var map = new google.maps.Map(document.getElementById('map_'+getId),mapOptions);
			var marker = new google.maps.Marker({
				position: new google.maps.LatLng(lat,long),
				map: map
			});
			$("#mapData_"+getId).slideDown('slow');
		}
		if($(this).hasClass('menu')){
			$(document).find('div#menu_'+getId).slideDown('slow');
		}
		if($(this).hasClass('deals')){
			$(document).find('div#deals_'+getId).slideDown('slow');
		}
	});
	$(document).on('click','.showmenu' , function(){
		var getId = $(this).attr('id');
		if(!$(this).attr('rel')){
			$(this).attr('rel',1)
			$('.hidemenu-'+getId).show('slow');
			$(this).find('i').removeClass('fa fa-chevron-down').addClass('fa fa-chevron-up');
		}else{
			$('.hidemenu-'+getId).slideUp('slow');
			$(this).find('i').removeClass('fa fa-chevron-up').addClass('fa fa-chevron-down');
			$(this).removeAttr('rel');
			$(document).find('#menu_'+getId).hide('slow');
			var rel = $(this).closest('div.booking-section').attr('rel');
			if(rel != ''){
				if(rel == 'map'){
					$(this).closest('div.booking-section').prev().prev().addClass('mrgn-btm15');
				}else if(rel == 'gallery'){
					$(this).closest('div.booking-section').prev().prev().prev().addClass('mrgn-btm15');
				}else if(rel == 'info'){
					$(this).closest('div.booking-section').prev().addClass('mrgn-btm15');
				}else if(rel == 'menu'){
					$(this).closest('div.booking-section').prev().prev().prev().prev().addClass('mrgn-btm15');
				}
			}
		}
		
	})
	
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
	
	
         
});

        function submit_form(){ 
		var options = {
			beforeSend: function() {
                                show_ajax();
			},
			success:function(res){
				$('.ajax_search').html('');
				$('.ajax_search').html(res);
						$("html, body").animate({
										   scrollTop: 0
									   }, 1500);  
                        hide_ajax();
				
			}
		};
		$('#UserIndexForm').ajaxSubmit(options);
            $(this).unbind('submit');
			$(this).bind('submit');
		return false;
	} 
</script>

