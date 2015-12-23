<!--main banner starts-->
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
<?php echo $this->Html->script('frontend/countdown'); ?>
<?php //echo $this->Html->script('frontend/date'); ?>
<?php //echo $this->Html->script('frontend/jquery.weekcalendar'); 
//echo $this->Html->script('fancy/jquery.fancybox.js?v=2.1.5');
//echo $this->Html->css('fancy/jquery.fancybox.css?v=2.1.5');
//echo $this->Html->script('fancy/jquery.fancybox-thumbs.js?v=1.0.7');
//echo $this->Html->css('fancy/jquery.fancybox-thumbs.css?v=1.0.7');
?>
<?php //echo $this->Html->css('jquery.bxslider'); ?>
<?php //echo $this->Html->script('jquery.bxslider'); ?>

<?php $lang =  Configure::read('Config.language'); ?>

<?php echo $this->element('frontend/salon_main_banner'); ?>
<!--tabs main navigation starts-->
<div class="salonData clearfix">
    <div class="main-nav clearfix">
	<?php //echo $this->element('frontend/Place/all_tabs'); ?>
	<?php echo $this->element('frontend/Place/salon_tabs'); ?>
    </div>
    <div class="container bukingPackage">
	<?php echo $this->element('frontend/Place/booking_package'); ?>
    </div>
    
    <div class="container packageList"></div>
</div>
<!--tabs main navigation ends-->
   
<script>

    /****************Package Booking Functions****************/
    function allpricefunc(thepObj) {
	var thepriceId = thepObj.attr('data-priceid');
	var packageObj = $(document).find('.bukingPackage');
	packageObj.find(".widgetPackageCalendar").css("display","none");
	if(thepObj.hasClass('selectedPrice')){
	    //last step
	    packageObj.find(".packgServc").find(".stylistListData").html();
	    packageObj.find(".packgServc").hide();
	    //
	
	    $(document).find('input#selDate').val('');
	    $(document).find('input#selType').val('');
	    $(document).find('input#PackagePrice').val('');
	    packageObj.find('#PackagePriceOpt').val('');
	    
	    // Selection step
	    packageObj.find('div.chooseBookingType').removeClass("selectedPrice");
	    packageObj.find('div.chooseBookingType').find("a").each(function(){
		if(!thepObj.hasClass("no-hover")){
		    thepObj.find("h4 .fa").remove();
		}
	    });
	    packageObj.find('div.chooseBookingType').find('a').show();
	    packageObj.find(".widgetPackageCalendar").css("display","none");
	    
	    // Remove Services
	    packageObj.find(".dynamicAppnt").remove();
	    packageObj.find(".packgServc").find(".badge").html("");
	    packageObj.find(".packgServc").find(".list-group-item-text").html("");
	    packageObj.find(".chooseBookingType").css('display','none');
	    
	    packageObj.find('div.allPriceOpt').find('a').show();
	    var mainPriceOpt = packageObj.find('div.allPriceOpt').find('a[data-priceid='+thepriceId+']');
	    mainPriceOpt.removeClass('selectedPrice').show();
	    mainPriceOpt.find('h4 .fa').remove();
	    packageObj.find('div.cal-sec').addClass('disabled');
	    packageObj.find('input#selDate').val('');
	    packageObj.find('.bukingService #bookappointment .stylistListData .allStylistHere').html('');
	}else{
	    
	    if(thepriceId){
		packageObj.find('#PackagePriceOpt').val(thepriceId);
		packageObj.find(".chooseBookingType").css('display','block');
		
		packageObj.find('div.allPriceOpt').find('a').hide();
		var mainPriceOpt = packageObj.find('div.allPriceOpt').find('a[data-priceid='+thepriceId+']');
		mainPriceOpt.addClass('selectedPrice').show();
		mainPriceOpt.find('h4').prepend('<i class="fa  fa-chevron-circle-down"></i>');
		
		packageObj.find('#PackagePrice').val(mainPriceOpt.attr('data-price'));
		
		if (packageObj.find('#buygift.active').length > 0) {
		    gifVoucherVal();
		}
		//alert("Hello this is testing going on")
		$(document).find(".bukingPackage .chooseBookingType").find("a.list-group-item[data-type='automatic']").removeClass("selectedPrice");
		
		var obj = $(document).find(".bukingPackage .chooseBookingType").find("a.list-group-item[data-type='automatic']");
		choosebookingtype(obj);
	    }
	    
	}
	packageObj.find('input#selTime').val('');
	packageObj.find('input#selEmpId').val('');
	enablePackageSubmit();
    }
    
    function choosebookingtype(bukTObj){
	var type = bukTObj.attr("data-type");
	
	var packageObj = $(document).find('.bukingPackage');
	if(type){
	   // alert(bukTObj.hasClass('selectedPrice'));
	    if(bukTObj.hasClass('selectedPrice')){
		    bukTObj.removeClass("selectedPrice");
		    bukTObj.find('h4 .fa').remove();
		    packageObj.find('div.chooseBookingType').find('a').show();
		    packageObj.find(".widgetPackageCalendar , .packgServc").css("display","none");
	    }else{
		bukTObj.find('h4').prepend('<i class="fa  fa-chevron-circle-down"></i>');
		packageObj.find('div.chooseBookingType').find('a').hide();
		bukTObj.addClass('selectedPrice').show();
		
		packageObj.find('input#selType').val(type);
		packageObj.find(".widgetPackageCalendar").css("display","block");
		//var datdayObj = packageObj.find('div.cal-sec').find('div.wc-header').find('li.ui-state-active a');
		var datday = packageObj.find('div.cal-sec').find('div.wc-header').find('li');
		
		var datdayObj = '';
		datday.each(function(){
		    if($(this).find("span").hasClass("bright")){
			$(this).addClass("ui-state-active");
			datdayObj = $(this).find("a");
			return false;
		    }else{
			$(this).removeClass("ui-state-active");
		    }
		});
		packageObj.find('div.cal-sec').removeClass('disabled');
		console.log(datdayObj);
		var thedate = datdayObj.attr('data-date');
		if(datdayObj.find('span').hasClass('bright')){
		    var theday = datdayObj.attr('data-day');
		    packageObj.find('.cal-sec').attr('data-sday',theday);
		    packageObj.find('input#selDate').val(thedate);
		    
		    if(packageObj.find(".allPriceOpt a.selectedPrice").length > 0){
			    var optionId = packageObj.find(".allPriceOpt a.selectedPrice").attr("data-priceid");
			    packageObj.find(".packgServc").hide();
			    packageObj.find("#option_"+optionId).show();
			    var i=0;
			    packageObj.find("#option_"+optionId).find("a").each(function(id) {
				    var serviceId = $(this).attr('id');
				    if(serviceId){
					    if(i==0){
						    getstaffforPackageAppointment(thedate,serviceId,0,optionId); i++;
					    }
				    }
			    });
		    }  
					//getstaffforAppointment(thedate,packageId,employeeId);
		}
		
	    }
	    
	}	
    }
	
    function getEmpSelTimefunc(getempTime) {
	var packageObj = $(document).find('.bukingPackage');
	
	var servcieDiv = getempTime.closest(".stylistListData").prev();
	var serviceId  = servcieDiv.attr("id");
	getempTime.closest('div.allStylistHere').find('.getEmpSelTime').removeClass('active');
	getempTime.addClass('active');
	var stylistId = getempTime.closest(".book-stylist").attr("data-staffid");
	var stylistName = getempTime.closest(".book-stylist").find(".lft span").html();
	
	getempTime.closest(".stylistListData").slideUp();
	servcieDiv.find(".badge").html(stylistName);
	servcieDiv.find(".list-group-item-text").html("<i class='fa fa-clock-o'></i><span class='text'> "+getempTime.html()+" </span>");
	servcieDiv.addClass('priceSelected');
	var duration =  getempTime.closest(".stylistListData").prev().attr("data-option-duration");
	//console.log(duration);
	var commonServiceClass = 'service-nois-'+serviceId;
	//alert(commonServiceClass);
	if(packageObj.find('.'+commonServiceClass).length > 0){
	    packageObj.find('.'+commonServiceClass).remove();
	}
	
	var $thmlService = '<input name="data[Appointment][service]['+serviceId+'][stylist]" value="'+stylistId+'" id="serviceSty_'+serviceId+'" class="forSelService '+commonServiceClass+'" type="hidden"><input name="data[Appointment][service]['+serviceId+'][time]" value="'+getempTime.text()+'" class="forSelService serviceTime '+commonServiceClass+'" id="serviceTime_'+serviceId+'" type="hidden"><input name="data[Appointment][service]['+serviceId+'][duration]" value="'+duration+'" class="forSelService serviceDur '+commonServiceClass+'" id="serviceDuration_'+serviceId+'" type="hidden">';
	//alert($thmlService);
	packageObj.find('#theHiddenForm').append($thmlService);
	
	var nextId = getempTime.closest(".stylistListData").next().attr("id");
	var optionId = packageObj.find(".allPriceOpt a.selectedPrice").attr("data-priceid");
	var slot = getempTime.closest('li').attr('data-time');
	var thedate = $(document).find('input#selDate').val();
	createCookie('service_'+serviceId,slot);
	if(nextId){
	    getstaffforPackageAppointment(thedate,nextId,0,optionId);
	}
	enablePackageSubmit();
	setTimeout(function(){
	    RemoveSlots(packageObj.find('#PackagePriceOpt').val());
	},500);
    }
    
	function bookpackageshow(serviceId,employeeId){
	
	
	    var longmonths = ['<?php echo __('January',true); ?>', '<?php echo __('February',true); ?>', '<?php echo __('March',true); ?>', '<?php echo __('April',true); ?>', '<?php echo __('May',true); ?>', '<?php echo __('June',true); ?>', '<?php echo __('July',true); ?>', '<?php echo __('August',true); ?>', '<?php echo __('September',true); ?>', '<?php echo __('October',true); ?>', '<?php echo __('November',true); ?>', '<?php echo __('December',true); ?>'];
	    var shortdays = ['<?php echo __('Sun',true); ?>', '<?php echo __('Mon',true); ?>', '<?php echo __('Tue',true); ?>', '<?php echo __('Wed',true); ?>', '<?php echo __('Thu',true); ?>', '<?php echo __('Fri',true); ?>', '<?php echo __('Sat',true); ?>'];
	    var forcusttitle = ['<?php echo __('next_week',true);?>', '<?php echo __('in',true); ?>', '<?php echo __('weeks',true); ?>','<?php echo __('week',true); ?>', '<?php echo __('in_a_month',true); ?>', '<?php echo __('month',true); ?>', '<?php echo __('months',true); ?>', '<?php echo __('in_a_year',true); ?>','<?php echo  __('year',true); ?>','<?php echo __('years',true); ?>'];
    
	    $(document).find('div.loader-container').show();
	    var d = new Date();
	    var n = d.getDay();
	    var bookPackageURL = '<?php echo $this->Html->url(array('controller'=>'Packagebooking','action'=>'showPackage'));?>'+'/'+serviceId+'/'+employeeId;
	    //$(document).find(".bukingPackage").load(bookPackageURL, function() {
		$(document).find('.bxslider').bxSlider({
			auto: true,
			pagerCustom: '#bx-pager'
		});
		var offerOn = $(document).find('.offerOn').text();
		var maxBookingLimit = $("#maxBookingLimit").val();
		var leadTime = $("#leadTime").val();
		var blackoutDate = $("#DealBlackoutDates").val();
		//alert(blackoutDate);
		var arr = [];
		if(!empty(blackoutDate)){
		    var Bdates = JSON.parse(blackoutDate);
		    for(var x in Bdates){
			  arr.push(Bdates[x]);
			  //arr.push(Bdates[x]);
		    }
		}
		$(document).find('.widgetPackageCalendar').weekCalendar({dateFormat: 'd',firstDayOfWeek:n,minDate:d,longMonths: longmonths ,shortDays: shortdays , fortitle: forcusttitle, activeDay : offerOn, customMinDate:leadTime,customDate: maxBookingLimit, blackoutDates: arr });
		$(document).find('div.packageList').html('');
		$(document).find('div.loader-container').hide();
		var theday = $(document).find('div.cal-sec').find('div.wc-header').find('li.ui-state-active a').attr('data-day');
		$(document).find('.cal-sec').attr('data-sday',theday);
			    //enableSubmit();
	    //});
	
    }
    
    function RemoveSlots(optionId){
	if(optionId){
	    var positions={};
	    var serID = '';
	    var busySlots = {};
	    $(document).find('.bukingPackage #bookappointment,.bukingPackage #evoucher,.bukingPackage #reschedule').find("#option_"+optionId).find("div.stylistListData").each(function(value){
		    var thSthOj = $(this);
		     serID = thSthOj.prev().attr('id');
		    var classTochk = 'service-nois-'+serID;
		    if($(document).find('#theHiddenForm').find('.'+classTochk).length > 0){
			    positions[serID] = {};
			    positions[serID]['time'] = $(document).find('#serviceTime_'+serID).val();
			    positions[serID]['duration'] = $(document).find('#serviceDuration_'+serID).val();
			    positions[serID]['stylist'] = $(document).find('#serviceSty_'+serID).val();
			    slot = $(document).find('#serviceTime_'+serID).val();
		            if(!empty(slot)){
				busySlots[serID] = {};
				busySlots[serID] = $.trim(slot);
				
			    }
			    
		    }
	    });
	    
	    $(document).find('.bukingPackage #bookappointment,.bukingPackage #evoucher,.bukingPackage #reschedule').find("#option_"+optionId).find("div.stylistListData").each(function(value){
		var thSlotOj = $(this);
		var servId = thSlotOj.prev().attr('id');
		if(!jQuery.isEmptyObject(positions)){
		    var d = new Date();
		    var tDate = d.getDate()+' '+d.getMonth()+" "+d.getFullYear(); 
		    thSlotOj.find('.book-stylist').each(function(){
			var echSty = $(this);
			echSty.find('li').each(function(){
			    var litheObj = $(this);
			    if(!litheObj.find('a').hasClass('active')){
				litheObj.show().removeClass('slotHid');
				var theTime = litheObj.attr('data-time');
				$.each(positions,function(itr,value){
					var startTime 	= Date.parse(tDate+" "+value.time)/1000;
					var endTime 	= startTime + (60 * value.duration);
					var chkTime 	= Date.parse(tDate+" "+theTime)/1000;
					if(itr != servId){
					    
						// updated on 07 Oct 2015
						    if(!empty(busySlots)){
							$.each(busySlots,function(servID,sltVal){
							 var slotsSelect = Date.parse(tDate+" "+sltVal)/1000;
							 var startBTime = slotsSelect-(60 * value.duration);
							 if(chkTime >= startBTime && chkTime < slotsSelect){
							    litheObj.hide().addClass('slotHid');    
							 }
							});
						    }
					       //// end
					
					    if(startTime <= chkTime && endTime > chkTime){
						litheObj.hide().addClass('slotHid');    
					    }
					}
				   
				});
			    }
			});
			echSty.find('.rgt > div.clearfix').each(function(){
			    $(this).show();
			    var slotLen = $(this).find('ul > li').length;
			    var slothidLen = $(this).find('ul > li.slotHid').length;
			    //alert(slotLen);
			    //alert(slothidLen);
			    if(slotLen == slothidLen){
				//alert('second');
				$(this).hide();
			    }
			});
			
		    });
		}
	    });
	    
	    var theTyp = $(document).find('input#thetype').val();
	    if (theTyp == 'Spaday') {
		var chkIn = $(document).find('input#thetype').attr('data-chkin');
		var chkOut = $(document).find('input#thetype').attr('data-chkout');
		$(document).find('.bukingPackage #bookappointment,.bukingPackage #evoucher,.bukingPackage #reschedule').find("#option_"+optionId).find(".allStylistHere").find(".book-stylist").each(function(value){
		    var thSlotspaOj = $(this);
		    thSlotspaOj.find('li').each(function(){
			var litheObj = $(this);
			var theTime = $(this).attr('data-time');
			var chk4Time 	= Date.parse(theTime)/1000;
			var chkInTime 	= Date.parse(chkIn)/1000;
			var chkOutTime 	= Date.parse(chkOut)/1000;
			if (chk4Time < chkInTime) {
			    litheObj.remove();   
			}
			if (chk4Time >= chkOutTime) {
			    litheObj.remove();   
			}
		 });
		    if(thSlotspaOj.find('ul li').length == 0){
			//thSlotspaOj.find
			thSlotspaOj.find('.rgt').text('No Slot available');
		    }
		 //console.log(thSlotspaOj.find('ul li').length);
		});
	    }
	    
	//    $(document).find('.bukingPackage #bookappointment').find("#option_"+optionId).find("div.stylistListData").each(function(value){
	//	var tomHd = $(this);
	//	tomHd.find('.book-stylist').each(function(){
	//	    var totheHided = $(this);
	//	    totheHided.find('.rgt').find('.noslotstf').remove();
	//	    totheHided.find('.rgt > div.clearfix').each(function(){
	//		console.log($(this).find('ul li:visible').length);
	//		//$(this).show();
	//		if ($(this).find('ul li:visible').length == 0 ) {
	//		    //$(this).hide();
	//		}
	//	    });
	//	    totheHided.find('ul').each(function(){
	//		console.log($(this).find('li:visible').length);
	//		if ($(this).find('li:visible').length == 0 ) {
	//		    console.log($(this).closest('div').html());
	//		}
	//	    });
	//	    if(totheHided.find('.rgt').find('div:visible').length == 0){
	//		totheHided.find('.rgt').append('<div class="noslotstf"><?php echo __('No slot found');?></div>')
	//	    }
	//	});
	//    });
	}
    }
    
    function getstaffforPackageAppointment(date,serviceId,employeeId,optionId){
	        var packageID = $(document).find("#PackageId").val();
		//thetype = $('#thetype').val();
		//chckout = chckin =0;
		//if(thetype=='Spaday'){
		//  chckin = $('#thetype').attr('data-chkin')
		//  chckout = $('#thetype').attr('data-chkout');
		//}
		//console.log($('#thetype').val());
		var getStaffURL = '<?php echo $this->Html->url(array("controller"=>"bookings","action"=>"getStaff"));?>'+'/'+date+'/'+serviceId+'/'+employeeId+'/'+'0'+'/'+packageID;
		$(document).find('.bukingPackage').find("#option_"+optionId).find("#stafFor_"+serviceId).show();
		$(document).find('.bukingPackage').find("#option_"+optionId).find("#stafFor_"+serviceId).prev().show();
		$(document).find('.bukingPackage').find("#option_"+optionId).find("#stafFor_"+serviceId).show().find(".allStylistHere").load(getStaffURL, function() {
			var thisObjslot = $(this);
			RemoveSlots(optionId) ;
			$(document).find('.bukingPackage a.getEmpSelTime').unbind().click(function(){
			    getEmpSelTimefunc($(this));
			});
			var chkauto = packageObj.find('.chooseBookingType a.list-group-item.selectedPrice');
			if (chkauto.length > 0) {
			    var typeSel = chkauto.attr('data-type');
			    if (typeSel == 'automatic') {
				thisObjslot.find('li:visible:first a.getEmpSelTime').click();
			    }
			}
			
		});
    }
    
    
    
    function enablePackageSubmit(){
	
	if($(document).find('.tab-content').find('#bookappointment,#evoucher,#reschedule').hasClass('active')){
	    var validFields = ['PackageId','PackagePriceOpt','selDate','PackagePrice','selBukTyp'];
	    var theCheck = true;
	    $.each( validFields , function( i, val ) {
		if(empty($(document).find('#'+val).val())){
		    theCheck = false;
		}
	    });
	   
	    var servcErr = 0;
	    if($(document).find(".allPriceOpt a").hasClass("selectedPrice")){
		var optionServices = $(document).find(".allPriceOpt a:visible").attr("data-services");
		var OptionServiceArray = optionServices.split(',');
		$.each(OptionServiceArray, function(  index, value) {
			if ($(document).find("#serviceSty_"+value).length > 0 ) {
			    var staff = $(document).find("#serviceSty_"+value).val();
			    var duration =  $(document).find("#serviceTime_"+value).val();
			    var slot = $(document).find("#serviceDuration_"+value).val();
			    if(empty(staff)){
				servcErr++;
			    }
			    if(empty(duration)){
				servcErr++;
			    }
			    if(empty(slot)){
				servcErr++;
			    }
			}
			else{
			    servcErr++;
			}
			
		    });
		}else{
		    servcErr++;
		}
	    //alert(servcErr);
	    if(theCheck && servcErr==0){
		//alert('here');
		$(document).find('#bookappointment,#evoucher,#reschedule').find('a.action').removeClass('disabled');
		var thePrc = $(document).find('input#PackagePrice').val();
		$(document).find('#bookappointment,#evoucher,#reschedule').find('.serviceBukctnt .pay').find('.Sprice').show().html(thePrc);
	    }else{
		//alert('there');
		$(document).find('#bookappointment,#evoucher,#reschedule').find('a.action').addClass('disabled');
		$(document).find('#bookappointment,#evoucher,#reschedule').find('.serviceBukctnt').find('.Sprice').hide();
	    }
	}
	
	if($(document).find('.tab-content').find('#buygift').hasClass('active')){
	    var validFields = ['PackageId','PackagePriceOpt','PackagePrice','selBukTyp'];
	    var theCheck = true;
	    $.each( validFields , function( i, val ) {
		if(empty($(document).find('#'+val).val())){
		    theCheck = false;
		}
	    });
	    if($(document).find('#clock1').hasClass('clock')){
		var maxtime = $(document).find('#clock1').data('maxtime');
		if(new Date().getTime() > new Date(maxtime).getTime()){
		    theCheck = false;
		}
	    }
	    // check for remaining deal qty   
	    if($(document).find('#AppointmentRemainQty').length > 0){
		remainQty = $(document).find('#AppointmentRemainQty').val();
		Qty = $("#selQty").val();
		if(Qty > remainQty){
		    alert("Please select less than "+remainQty);
		    theCheck = false;    
		}
		
	    }
	    if(theCheck){
		$(document).find('#buygift').find('a.action').removeClass('disabled');
		var thePrc = $(document).find('input#PackagePrice').val();
		$(document).find('#buygift').find('.serviceBukctnt .pay').find('.Sprice').show();
	    }else{
		$(document).find('#buygift').find('a.action').addClass('disabled');
		$(document).find('#buygift').find('.serviceBukctnt').find('.Sprice').hide();
	    }
	}
    }
    
    
    function gifVoucherVal() {
	var qty = $(document).find('#buygift').find('#selQty').val();
	var price = $(document).find('#PackagePrice').val();
	theCheck = true;
	// check for remaining deal qty   
	    if($(document).find('#AppointmentRemainQty').length > 0){
		remainQty = $(document).find('#AppointmentRemainQty').val();
		Qty = $("#selQty").val();
		if(parseInt(Qty) > parseInt(remainQty)){
		    alert("Please select less than "+remainQty);
		    theCheck = false;    
		}
		
	    }
	 if($(document).find('#clock1').hasClass('clock')){
		var maxtime = $(document).find('#clock1').data('maxtime');
		if(new Date().getTime() > new Date(maxtime).getTime()){
		    alert('Deal is closed');
		    theCheck = false;
		}
	    }
	if (!empty(price) && theCheck) {
	    var toTal = parseFloat(price)*parseFloat(qty);
	    $(document).find('#buygift').find('.serviceBukctnt .pay .Sprice').html(toTal).show();
	    $(document).find('#buygift').find('.serviceBukctnt a.action').removeClass('disabled');
	}
	else{
	    $(document).find('#buygift').find('.serviceBukctnt .pay .Sprice').hide();
	    $(document).find('#buygift').find('.serviceBukctnt a.action').addClass('disabled');
	}
    }
    /**************************************End***********************************/
    
    function empty(data)
    {
	    if(typeof(data) == 'number' || typeof(data) == 'boolean')
	    {
	      return false;
	    }
	    if(typeof(data) == 'undefined' || data === null)
	    {
	      return true;
	    }
	    if(typeof(data.length) != 'undefined')
	    {
	      return data.length == 0;
	    }
	    var count = 0;
	    for(var i in data)
	    {
	      if(data.hasOwnProperty(i))
	      {
		    count ++;
	      }
	    }
	    return count == 0;
    }
    function isEmpty( el ){
      return !$.trim(el.html())
  }
  $(document).ready(function(){
	$(document).on('click','.bukingPackage a.action',function(){
	    var theAppType = $(this).attr('data-type');
	    $(document).find('.dataType_val').text(theAppType);
	    if(!$(this).hasClass('disabled')){
		$(document).find('#selBukTyp').val(theAppType);
		//alert('herere');
		//return false;
		$(document).find('#AppointmentShowPackageForm').submit();
	    }else{
		if (isEmpty($(document).find('.bukingPackage').find('.allStylistHere'))) {
			   alert('Please select Pricing option.');
		     }else{
			//alert("")
		     }
	    }
	});	 

	$(document).on('submit','#AppointmentShowPackageForm',function(e){
		if(!$(this).hasClass('disabled')){
		    if($(document).find('.wel-usr-name').text() !=''){
			    $(document).find('#AppointmentShowServiceForm').submit();	
		    }else{
			    $(document).find('.userLoginModal').click();
			    e.preventDefault();		
		    }
		}
	});
	
    packageObj = $(document).find('.bukingPackage');
    packageObj.on('change','#selQty',function(){
	gifVoucherVal();
    });
    packageObj.on('click','.ulopts a[href=#buygift]',function(){
	gifVoucherVal();
    });
    
    packageObj.on('click','div.cal-sec a.theDateCal',function(){
	//e.preventDefault();
	var dateObj = $(this);
	var thedate = dateObj.attr('data-date');
	if(!dateObj.closest('div.cal-sec').hasClass('disabled')){
	    $(document).find("#selDate").val(thedate);
	    if(dateObj.find('span').hasClass('bright')){
		dateObj.closest('ul').find('li').removeClass('ui-state-active');
		dateObj.closest('li').addClass('ui-state-active');
		var optionId = packageObj.find(".allPriceOpt a.selectedPrice").attr("data-priceid");
		var price = packageObj.find(".allPriceOpt a.selectedPrice").attr("data-price");
		packageObj.find(".packgServc").hide();
		packageObj.find("#option_"+optionId).show();
		packageObj.find("#PackagePrice").val(price);
		var i=0;
		packageObj.find("#option_"+optionId).find("a").each(function(id) {
		    var serviceId = $(this).attr('id');
		    if(serviceId){
			if(i==0){
			    getstaffforPackageAppointment(thedate,serviceId,0,optionId);
			    packageObj.find(".dynamicAppnt").remove();
			    packageObj.find(".packgServc").find(".badge").html("");
			    packageObj.find(".packgServc").find(".list-group-item-text").html("");
			    i++;
			}
		    }
		});
	    }
	    else{
		//alert(thedate);
		getstaffforPackageAppointment(thedate,0,0,0);
	    }
	}
	    enablePackageSubmit();
    });
    
    
    
    // For eVoucher Booking
    
        packageObj.on('click','div.eVoucherCal a.theDateCal, div.rescheduleCal a.theDateCal',function(){
	
	//e.preventDefault();
	var dateObj = $(this);
	if(!dateObj.closest('div.cal-sec').hasClass('disabled')){
	    var thedate = dateObj.attr('data-date');
	    $(document).find("#selDate").val(thedate);
	    if(dateObj.find('span').hasClass('bright')){
		dateObj.closest('ul').find('li').removeClass('ui-state-active');
		dateObj.closest('li').addClass('ui-state-active');
	    var optionId = packageObj.find(".allPriceOpt a.selectedPrice").attr("data-priceid");
	    var price = packageObj.find(".allPriceOpt a.selectedPrice").attr("data-price");
		packageObj.find(".packgServc").hide();
		packageObj.find("#option_"+optionId).show();
		packageObj.find('#PackagePriceOpt').val(optionId);
		packageObj.find('#PackagePrice').val(price);
		packageObj.find('#selBukTyp').val("appointment");
		var i=0;
		packageObj.find("#option_"+optionId).find("a").each(function(id) {
		    var serviceId = $(this).attr('id');
		    //alert(serviceId);
		    if(serviceId){
			if(i==0){
			    getstaffforPackageAppointment(thedate,serviceId,0,optionId);
			    packageObj.find(".dynamicAppnt").remove();
			    packageObj.find(".packgServc").find(".badge").html("");
			    packageObj.find(".packgServc").find(".list-group-item-text").html("");
			    i++;
			}
		    }
		});
	    }
	    else{
		//getstaffforPackageAppointment(thedate,0,0,0);
	    }
	}
	    enablePackageSubmit();
    });
    
 
    $(document).find('.bukingPackage .packgServc a.list-group-item').unbind().click(function(){
    	//alert("Hello");
	//var selected = $(this).find("span.badge").length;
	var thepoJ = $(this);
	if(thepoJ.hasClass('priceSelected')){
		//if(selected > 0){
		thepoJ.closest('div').children('div').hide();
		thepoJ.next().show();
	}else{
		
	}
    });
	
    $(document).find('.bukingPackage #bookappointment a.getEmpSelTime').unbind().click(function(){
	getEmpSelTimefunc($(this));
    });
    
    $(document).find('.bukingPackage .allPriceOpt a.list-group-item').unbind().click(function(){
	
	//alert('HI');
	allpricefunc($(this));
    });
 
    $(document).find(".bukingPackage .chooseBookingType a.list-group-item").unbind().click(function(){
	choosebookingtype($(this));
    });
    
    bookpackageshow();
   if($(document).find('.bukingPackage .allPriceOpt a.priceOpt-here').length == 2 || $(document).find('.bukingPackage .allPriceOpt a.priceOpt-here').length == 1){
    var current = $(document).find('.bukingPackage .allPriceOpt a.priceOpt-here').eq(0).trigger('click');
      setTimeout(function(){
     choosebookingtype(current);
    },2000);
	
   }
    
 });  
</script>

<?php echo $this->Js->writeBuffer();?>