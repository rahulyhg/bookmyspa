<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
<!--main banner starts-->
<?php //echo $this->Html->script('frontend/widget'); ?>
<?php //echo $this->Html->script('frontend/date'); ?>
<?php //echo $this->Html->script('frontend/jquery.weekcalendar'); ?>
<?php $lang =  Configure::read('Config.language'); ?>
<?php echo $this->element('frontend/salon_main_banner'); ?>
<?php echo $this->Html->script('frontend/countdown'); ?>
<!--tabs main navigation starts-->
<div class="salonData clearfix">
    <div class="main-nav clearfix">
	<?php echo $this->element('frontend/Place/salon_tabs'); ?>
    </div>
     <div class="container bukingService">
	<?php echo $this->element('frontend/Place/booking_service'); ?>
     </div>
     <div class="container serviceList">
	
     </div>
</div>
<!-- ********************** Details need to login user before booking************ -->
<!--<div style="display: none" class="con_action"><?php echo $this->params['action']; ?></div>
-->
<div style="display: none" class="con_action"><?php echo $this->params['action']; ?></div>
<div style="display: none" class="dataType_val"></div>

<?php  $userDetails = (isset($auth_user))?$auth_user["User"]["id"]:'';?>
<!--************************************************************************************** -->

<!--tabs main navigation ends-->

<script>
     function getstaffforAppointment(date,serviceId,employeeId,priceLevel){
	var getStaffURL = '<?php echo $this->Html->url(array('controller'=>'bookings','action'=>'getStaff'));?>'+'/'+date+'/'+serviceId+'/'+employeeId+'/'+priceLevel;
	$(document).find('.bukingService .stylistListData div.loader-container').show();
	$(document).find(".bukingService .stylistListData .allStylistHere").load(getStaffURL, function() {
	    if($(this).find('li').length > 0){
		$(this).find('li:first a').click();
	    }
	    $(document).find('.bukingService .stylistListData div.loader-container').hide();
	    setTimeout(function(){
	    var employee = $(document).find("#selEmpId").val();
	    var date = $(document).find("#selDate").val();
	    var time = $(document).find("#selTime").val();
	    
	    if(empty(employee) || empty(date) || empty(time)){
			$(document).find('.serviceBukctnt').find('a.action').addClass('disabled');	
	    }else{
			 $(document).find('.serviceBukctnt').find('a.action').removeClass('disabled');	
		    }
		},3000);
	   
	});

    }  
    
    function toRemovePrice(){
	var theDivs = $(document).find('.Sprice').closest('div.centering-wrapper');
	//$(document).find('#priceVal , #priceDisVal').val('');
	$(document).find('.DSPrice , .Sprice').html('');
	theDivs.find('.save,.discount-type').hide();
    }
    
    function toAddPrice(){
	//alert("hi");
	//var thepObj = $(document).find('.allPriceOpt').find('a.selectedPrice');
	var theprice = $(document).find('#priceVal').val();
	var thedisprice = $(document).find('#priceDisVal').val();
	
	if($(document).find('#bookappointment').hasClass('active')){
	    var theDivs = $(document).find('#bookappointment').find('.Sprice').closest('div.centering-wrapper');
	    
	    if($(document).find('.allPriceOpt').find('a.selectedPrice').length > 0 || $(document).find('.allPriceOpt').find('a').length == 0){
		$(document).find('.Sprice').html(theprice).show();
		if(thedisprice){
		    $(document).find('.DSPrice').html(thedisprice).show();
		    $(document).find('.Sprice').closest('div.pay').removeClass('tp-space');
		    theDivs.find('.save,.discount-type').show();
		}
		else{
		    $(document).find('.Sprice').closest('div.pay').addClass('tp-space');
		    theDivs.find('.save,.discount-type').hide();
		}
	    }
	    else{
		toRemovePrice();    
	    }
	}
	
	if($(document).find('#buygift').hasClass('active')){
	    var theDivs = $(document).find('#buygift').find('.Sprice').closest('div.centering-wrapper');
	    if(theprice){
		var theQuantity = $(document).find('#selQuantity').val();
		var theGiftPrice = parseFloat(parseFloat(theQuantity)*parseFloat(theprice));
		$(document).find('.Sprice').html(theGiftPrice).show();
		if(thedisprice){
		    var theGiftDisPrice = parseFloat(parseFloat(theQuantity)*parseFloat(thedisprice));
		    $(document).find('.DSPrice').html(theGiftDisPrice).show();
		    $(document).find('.Sprice').closest('div.pay').removeClass('tp-space');
		    theDivs.find('.save,.discount-type').show();
		}
		else{
		    $(document).find('.Sprice').closest('div.pay').addClass('tp-space');
		    theDivs.find('.save,.discount-type').hide();
		}
	    }
	}
    }
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
    
    
    function enableSubmit(){
	
	if($(document).find('#bookappointment').hasClass('active')){
	    var validFields = ['serviceId','selEmpId','priceOptId','selEmpId','selDate','selTime'];
	    var theCheck = true;
	    $.each( validFields , function( i, val ) {
		if($(document).find('#'+val).val() == ''){
		    theCheck = false;    
		}
	    });
	    if(theCheck){
		$(document).find('#bookappointment').find('a.action').removeClass('disabled');
	    }else{
		$(document).find('#bookappointment').find('a.action').addClass('disabled');
	    }
	}
	if($(document).find('#buygift').hasClass('active')){
	    var validFields = ['serviceId','selQuantity','priceOptId'];
	    var theCheck = true;
	    $.each( validFields , function( i, val ) {
		if($(document).find('#'+val).val() == ''){
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
		if(parseInt(Qty) > parseInt(remainQty)){
		    alert("Please select less than "+remainQty);
		    theCheck = false;    
		}
		
	    }
	    
	    if(theCheck){
		$(document).find('#buygift').find('a.action').removeClass('disabled');
	    }else{
		$(document).find('#buygift').find('a.action').addClass('disabled');
	    }
	}
    }
    

		
    
    function bookserviceshow(serviceId,employeeId){
	 var longmonths = ['<?php echo __('January',true); ?>', '<?php echo __('February',true); ?>', '<?php echo __('March',true); ?>', '<?php echo __('April',true); ?>', '<?php echo __('May',true); ?>', '<?php echo __('June',true); ?>', '<?php echo __('July',true); ?>', '<?php echo __('August',true); ?>', '<?php echo __('September',true); ?>', '<?php echo __('October',true); ?>', '<?php echo __('November',true); ?>', '<?php echo __('December',true); ?>'];
	var shortdays = ['<?php echo __('Sun',true); ?>', '<?php echo __('Mon',true); ?>', '<?php echo __('Tue',true); ?>', '<?php echo __('Wed',true); ?>', '<?php echo __('Thu',true); ?>', '<?php echo __('Fri',true); ?>', '<?php echo __('Sat',true); ?>'];
	var forcusttitle = ['<?php echo __('next_week',true);?>', '<?php echo __('in',true); ?>', '<?php echo __('weeks',true); ?>','<?php echo __('week',true); ?>', '<?php echo __('in_a_month',true); ?>', '<?php echo __('month',true); ?>', '<?php echo __('months',true); ?>', '<?php echo __('in_a_year',true); ?>','<?php echo  __('year',true); ?>','<?php echo __('years',true); ?>'];
	
	$(document).find('div.loader-container').show();
	var d = new Date();
        var n = d.getDay();
	           //var bookSrvcURL = '<?php echo $this->Html->url(array('controller'=>'bookings','action'=>'showService'));?>'+'/'+serviceId+'/'+employeeId;
		  // $(document).find(".bukingService").load(bookSrvcURL, function() {
		 //                var slider= $(document).find('#servicelightSlider').lightSlider({
		//		    gallery: true,item: 1,loop: true,
	       //		    <?php if($lang && $lang == 'ara'){ ?>
	      //		    rtl:true,
	     //		    <?php }?>
	    //		    slideMargin: 0,thumbItem: 7
	   //		});
	       var offerOn = $(document).find('.offerOn').text();
	       var maxBookingLimit = $("#maxBookingLimit").val();
	       var leadTime = $("#leadTime").val();
	       var blackoutDate = $("#DealBlackoutDates").val();
		var arr = [];
		if(!empty(blackoutDate)){
		    var Bdates = JSON.parse(blackoutDate);
		    //alert(jQuery.type( blackoutDate ) );
		    for(var x in Bdates){
			  arr.push(Bdates[x]);
			  //arr.push(Bdates[x]);
		    }
		}
		//alert(maxBookingLimit);
		//console.log(arr);
		//console.log(arr);
	       
	      // alert()
			$(document).find('.widgetCalendar').weekCalendar({dateFormat: 'd',firstDayOfWeek:n,minDate:d,longMonths: longmonths ,shortDays: shortdays , fortitle: forcusttitle, activeDay : offerOn,customMinDate:leadTime,customDate: maxBookingLimit, blackoutDates: arr});
		$(document).find('.bxslider').bxSlider({
		    auto: true,
		    pagerCustom: '#bx-pager'
		});
		$(document).find('div.serviceList').html('');
		$(document).find('div.loader-container').hide();
		var datday = $(document).find('div.cal-sec').find('div.wc-header').find('li');
		
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
		
		//var theday = $(document).find('div.cal-sec').find('div.wc-header').find('li.ui-state-active a').attr('data-day');
		$(document).find('.cal-sec').attr('data-sday',datdayObj);
		enableSubmit();
           // });
	
    }
    
    
   $(document).ready(function(){
	var serviceID = $(document).find("#serviceId").val();
	//setTimeout(function(){
	    bookserviceshow(serviceID,0);    
	//},1000);
	
	
	
	
	
//	$('body').off('click','.forBooking').on('click','.forBooking',function(){
//	    var theObj = $(this);
//            var serviceId = theObj.attr('data-id');
//            if(serviceId){
//                bookserviceshow(serviceId,0);
//            }
//        });
	
	$(document).find(".appointmentVoucher").on('click','a.list-group-item',function(){
	   
	    var thepObj = $(this);
	    var thepriceId = thepObj.attr('data-priceid');
	    
	    if(thepObj.hasClass('selectedPrice')){
		$(document).find('#priceOptId').val('');
		$(document).find('#priceLvlId').val('');
		$(document).find('div.allPriceOpt').find('a').show();
		var mainPriceOpt = $(document).find('div.allPriceOpt').find('a[data-priceid='+thepriceId+']');
		mainPriceOpt.removeClass('selectedPrice').show();
		mainPriceOpt.find('h4 .fa').remove();
		$(document).find('div.cal-sec').addClass('disabled');
		$(document).find('input#selDate').val('');
		$(document).find('.bukingService #bookappointment .stylistListData .allStylistHere').html('');
		toRemovePrice();
	    }else{
		if(thepriceId){
		    $(document).find('#priceOptId').val(thepriceId);
		    $(document).find('#priceLvlId').val(thepObj.attr('data-pricelevel'));
		    $(document).find('div.allPriceOpt').find('a').hide();
		    var mainPriceOpt = $(document).find('div.allPriceOpt').find('a[data-priceid='+thepriceId+']');
		    mainPriceOpt.addClass('selectedPrice').show();
		    mainPriceOpt.find('h4').prepend('<i class="fa  fa-chevron-circle-down"></i>');
		    
		    $(document).find('#priceVal').val(mainPriceOpt.attr('data-price'));
		    $(document).find('#priceDisVal').val(mainPriceOpt.attr('data-disprice'));
		    $(document).find('#durationId').val(mainPriceOpt.attr('data-duration'));
		    
		    $(document).find('div.cal-sec').removeClass('disabled');
		    var datdayObj = $(document).find('div.cal-sec').find('div.wc-header').find('li.ui-state-active a');
		    var thedate = datdayObj.attr('data-date');
		    if(datdayObj.find('span').hasClass('bright')){
			var theday = datdayObj.attr('data-day');
			$(document).find('.cal-sec').attr('data-sday',theday);
			var serviceId = $(document).find('input#serviceId').val();
			var employeeId = $(document).find('input#employeeId').val();
			
			$(document).find('input#selDate').val(thedate);
			
			toAddPrice();
			getstaffforAppointment(thedate,serviceId,employeeId,thepObj.attr('data-pricelevel'));
		    }
		    else{
			getstaffforAppointment(thedate,0,0,0);
			$(document).find('input#selDate').val('');
			if($(document).find('#buygift').hasClass('active')){
			    toAddPrice();
			}else{
			    toRemovePrice();    
			}
		    }
		    
		    
		    
		}
	    }
	    $(document).find('input#selTime').val('');
	    $(document).find('input#selEmpId').val('');
	    enableSubmit();
	});
	
	/*********Reschedule Starts here**********/
	$(document).find("#reschedule,#evoucher").on('click','div.cal-sec a.theDateCal',function(){
		var dateObj = $(this);
		var thedate = dateObj.attr('data-date');
		var theday = dateObj.attr('data-day');
		if(!dateObj.closest('div.cal-sec').hasClass('disabled')){
		dateObj.closest('ul').find('li').removeClass('ui-state-active');
		if(dateObj.find('span').hasClass('bright')){
			var serviceId = $(document).find('input#serviceId').val();
			var employeeId = $(document).find('input#employeeId').val();
			var priceLvlId = 0;
			dateObj.closest('li').addClass('ui-state-active');
			$(document).find('input#selDate').val(thedate);
			getstaffforAppointment(thedate,serviceId,employeeId,priceLvlId);
			toAddPrice();
		}
		else{
		    dateObj.closest('li').addClass('ui-state-active');
		    getstaffforAppointment(thedate,0,0,0);
		    $(document).find('input#selDate').val('');
		    toRemovePrice();
		}
		$(document).find('input#selTime').val('');
		$(document).find('input#selEmpId').val('');
		$(document).find('.cal-sec').attr('data-sday',theday);
	    }
	   // enableSubmit();
		setTimeout(function(){
		    if($(document).find(".bukingService .stylistListData .allStylistHere").find(".book-stylist").length ==0){
			    
			    $(document).find('.serviceBukctnt').find('a.action').addClass('disabled');	
		    }else{

			    $(document).find('.serviceBukctnt').find('a.action').removeClass('disabled');	
		    }
		},2000);
	    
	});
	/******************End*******************/
	
	$(document).find(".appointmentVoucher div.cal-sec").on('click','a.theDateCal',function(){
	    var dateObj = $(this);
	    var thedate = dateObj.attr('data-date');
	    var theday = dateObj.attr('data-day');
	 
	    if(!dateObj.closest('div.cal-sec').hasClass('disabled')){
		dateObj.closest('ul').find('li').removeClass('ui-state-active');
		if(dateObj.find('span').hasClass('bright')){
			var serviceId = $(document).find('input#serviceId').val();
			var employeeId = $(document).find('input#employeeId').val();
			var priceLvlId = $(document).find('input#priceLvlId').val();
			dateObj.closest('li').addClass('ui-state-active');
			$(document).find('input#selDate').val(thedate);
			getstaffforAppointment(thedate,serviceId,employeeId,priceLvlId);
			toAddPrice();
		}
		else{
		    dateObj.closest('li').addClass('ui-state-active');
		    getstaffforAppointment(thedate,0,0,0);
		    $(document).find('input#selDate').val('');
		    toRemovePrice();
		}
		$(document).find('input#selTime').val('');
		$(document).find('input#selEmpId').val('');
		$(document).find('.cal-sec').attr('data-sday',theday);
	    }
	    enableSubmit();
	});
	
	
	$(document).on('click','a.getEmpSelTime',function(){
	    var getempTime = $(this);
	    $(document).find('div.allStylistHere').find('a').removeClass('active');
	    getempTime.addClass('active');
	    $(document).find('input#selTime').val(getempTime.closest('li').attr('data-time'));
	    $(document).find('input#selEmpId').val(getempTime.closest('div.book-stylist').attr('data-staffid'));
	    enableSubmit();
	});
	
	$(document).on('click','ul.ulopts li',function(){
	    toAddPrice();
	    enableSubmit();
	});
	
	$(document).on('change','#selQty',function(){
	    var theQty = $(this).val();
	    $(document).find('#selQuantity').val(theQty);
	    toAddPrice();
	    enableSubmit();
	});

      $(document).on('click','.bukingService a.action',function(e){
	//alert("dd");
		//console.log('herere');
		var theAppType = $(this).attr('data-type');
		$(document).find('.dataType_val').text(theAppType);
		if(!$(this).hasClass('disabled')){
			var user_data = '<?php echo $userDetails; ?>';
			if(user_data){
			    $(document).find('#selBukTyp').val(theAppType);
			    $(document).find('#AppointmentShowServiceForm').submit();	
			}else{
			    $(document).find('.userLoginModal').click();
			    e.preventDefault();		
			}
		}else{
		     if (isEmpty($(document).find('.bukingService').find('.allStylistHere'))) {
			   alert('Please select Pricing option.');
		     }else{
			//alert("")
		     }
		}
	});
    
    });
function isEmpty(el){
      return !$.trim(el.html())
  }
 
    
</script>
<?php if($reschedule == 'true'){?>
    <script>
    $(document).ready(function(){
	$(document).find('div.cal-sec').removeClass('disabled');
	//$(document).find("#reschedule").find('.ui-state-active a.theDateCal').trigger('click');
	$(document).find('#AppointmentShowServiceForm').append('<input type="hidden" name="data[Appointment][id]" value="<?php echo $appointmentID; ?>">');
	
	setTimeout(function(){
	    var employee = $("#selEmpId").val();
	    var date = $("#selDate").val();
	    var time = $("#selTime").val();
	    if(empty(employee) || empty(date) || empty(time)){
			$(document).find('.serviceBukctnt').find('a.action').addClass('disabled');	
	    }else{
			 $(document).find('.serviceBukctnt').find('a.action').removeClass('disabled');	
		    }
		},3000);
    });
	
	
	
    </script>

<?php }  if($eVoucher == 'true') {?>
    <script>
    
	$(document).find('div.cal-sec').removeClass('disabled');
	//$(document).find("#reschedule").find('.ui-state-active a.theDateCal').trigger('click');
	$(document).find('#AppointmentShowServiceForm').append('<input type="hidden" name="data[Appointment][id]" value="">');
	$(document).find('#AppointmentShowServiceForm').append('<input type="hidden" name="data[Evoucher][id]" value="<?php echo $evoucherID; ?>">');
	$(document).find('#AppointmentShowServiceForm').append('<input type="hidden" name="data[Order][id]" value="<?php echo $orderID; ?>">');
	$(document).find('#AppointmentShowServiceForm').append('<input type="hidden" name="data[Order][id]" value="<?php echo $orderID; ?>">');
	<?php if(isset($deal) && $deal){?>
	$(document).find('#AppointmentShowServiceForm').append('<input type="hidden" name="data[Deal][id]" value="<?php echo $dealData['Deal']['id']; ?>">');
	<?php } ?>
	
</script>
<?php }?>
<?php echo $this->Js->writeBuffer();?>