<!--main banner starts-->
<?php echo $this->Html->script('frontend/widget'); ?>
<?php echo $this->Html->script('frontend/date'); ?>
<?php echo $this->Html->script('frontend/jquery.weekcalendar'); 
echo $this->Html->script('fancy/jquery.fancybox.js?v=2.1.5');
echo $this->Html->css('fancy/jquery.fancybox.css?v=2.1.5');
echo $this->Html->script('fancy/jquery.fancybox-thumbs.js?v=1.0.7');
echo $this->Html->css('fancy/jquery.fancybox-thumbs.css?v=1.0.7');
?>
<?php echo $this->Html->css('jquery.bxslider'); ?>
<?php echo $this->Html->script('jquery.bxslider'); ?>

<?php $lang =  Configure::read('Config.language'); ?>
<div class="main-banner">
    <?php
	if(isset($userDetails['Salon']['cover_image']) && !empty($userDetails['Salon']['cover_image']) ){
		//$filename = WWW_ROOT ."images/".$userDetails['User']['id']."/Salon/800/".$userDetails['Salon']['cover_image'];
		$filename = WWW_ROOT ."images/".$userDetails['User']['id']."/Salon/1423/".$userDetails['Salon']['cover_image'];
		//echo $filename;
		if (file_exists($filename)) {
			echo $this->Html->image("/images/".$userDetails['User']['id']."/Salon/1423/".$userDetails['Salon']['cover_image'],array('data-id'=>$userDetails['User']['id']));

		}else{
			echo $this->Html->image("/img/cover-bckend.jpg");
		}
	}else{
			echo $this->Html->image("/img/cover-bckend.jpg");
	}
    ?>
    <div class="transi-detail-outer clearfix">
        <div class="transi-detail clearfix">
            <div class="left">
                <h3>
		    <?php echo $userDetails['Salon'][$lang.'_name']; ?>
		</h3>
                <span class="address"><i class="fa fa-map-marker"></i>
		<?php		
		  $addressNew=explode(',',$userDetails['Address']['address']);
		  echo !empty($addressNew[0]) ? $addressNew[0].',' :'';
		  echo !empty($addressNew[1]) ? $addressNew[1].',' :'';
		  echo !empty($addressNew[2]) ? $addressNew[2].',' :'';
		  echo !empty($addressNew[3]) ? $addressNew[3].' ' :' '.$userDetails['Address']['po_box'];
		?>
		<!--1660 W Lake Houston Parkway, Suite 102, KINGWOOD, Texas 77339-->
		</span>
                <span class="email"><i class="fa fa-globe"></i><a href="<?php echo $userDetails['Salon']['website_url'];?>" target="_blank"><?php echo $userDetails['Salon']['website_url'];?></a></span>
		<span class="email"><i class="fa fa-envelope"></i><a href="mailto:<?php echo $userDetails['Salon']['email'];?>" ><?php echo $userDetails['Salon']['email'];?></a></span>
                <span class="phone"><i class="fa fa-phone"></i> <?php echo $userDetails['Contact']['cell_phone'];?></span>
                <span class="like"><i class="fa fa-thumbs-o-up"></i> Like : +0 1</span>
            </div>
            <div class="rgt">
                <ul class="book-rate">
                    <li>14.9</li>
                    <li><i class="fa fa-bookmark"></i></li>                       
                </ul>
                <ul class="rationg-list">
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                </ul>
            </div>
        </div>
        <ul class="bread-crms clearfix">
            <?php
              $user_type=$userDetails['User']['type'];
	      $user_type_text='';
              if($user_type == 4){
                  $user_type_text.= __("individual_salon",true);
              }else if($user_type == 2){
                  $user_type_text.=__("frenchise",true);
              }else if($user_type == 3){
                  $user_type_text.=__("multiple_location",true);
              }else if($user_type == 5){
		 $user_type_text.=__("user",true);
	      }  ?>
            <li><?php echo  $this->Html->link(__('home',true) , '/'); ?></li>
            <li><i class="fa fa-angle-double-right"></i></li>
            <li><?php echo $this->Html->link($user_type_text.'( '.$userDetails['Salon'][$lang.'_name']. ')',array('controller'=>'place','action'=>'index','admin'=>false,$userDetails['User']['id']),array('escape'=>false));?></li>
            <li><i class="fa fa-angle-double-right"></i></li>
            <li><?php echo  $this->Html->link(__('view',true) , 'javascript:void(0)'); ?></li>
        </ul>
   </div>       
</div>
<!--main banner ends-->

<!--tabs main navigation starts-->
<div class="salonData clearfix">
    <div class="main-nav clearfix">
	<?php echo $this->element('frontend/Place/all_tabs'); ?>
    </div>
	<?php echo $this->element('frontend/Place/all_detail'); ?>
</div>
<!--tabs main navigation ends-->

<script>

    function getstaffforAppointment(date,serviceId,employeeId,priceLevel){
	var getStaffURL = '<?php echo $this->Html->url(array('controller'=>'bookings','action'=>'getStaff'));?>'+'/'+date+'/'+serviceId+'/'+employeeId+'/'+priceLevel;
	$(document).find('.bukingService #bookappointment .stylistListData div.loader-container').show();
	$(document).find(".bukingService #bookappointment .stylistListData .allStylistHere").load(getStaffURL, function() {
	    if($(this).find('li').length > 0){
		$(this).find('li:first a').click();
	    }
	    $(document).find('.bukingService #bookappointment .stylistListData div.loader-container').hide();
	});
    }  
    
    function toRemovePrice(){
	var theDivs = $(document).find('.Sprice').closest('div.centering-wrapper');
	//$(document).find('#priceVal , #priceDisVal').val('');
	$(document).find('.DSPrice , .Sprice').html('');
	theDivs.find('.save,.discount-type').hide();
    }
    
    function toAddPrice(){
	
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
        var bookSrvcURL = '<?php echo $this->Html->url(array('controller'=>'bookings','action'=>'showService'));?>'+'/'+serviceId+'/'+employeeId;
        $(document).find(".bukingService").load(bookSrvcURL, function() {
//                var slider= $(document).find('#servicelightSlider').lightSlider({
//		    gallery: true,item: 1,loop: true,
//		    <?php if($lang && $lang == 'ara'){ ?>
//		    rtl:true,
//		    <?php }?>
//		    slideMargin: 0,thumbItem: 7
//		});
		$(document).find('.bxslider').bxSlider({
		    auto: true,
		    pagerCustom: '#bx-pager'
		});

		var offerOn = $(this).find('.offerOn').text();
		$(document).find('.widgetCalendar').weekCalendar({dateFormat: 'd',firstDayOfWeek:n,minDate:d,longMonths: longmonths ,shortDays: shortdays , fortitle: forcusttitle, activeDay : offerOn });
		$(document).find('div.serviceList').html('');
		$(document).find('div.loader-container').hide();
		var theday = $(document).find('div.cal-sec').find('div.wc-header').find('li.ui-state-active a').attr('data-day');
		$(document).find('.cal-sec').attr('data-sday',theday);
		enableSubmit();
            });
	
    }
    
        
	/****************Package Booking Functions****************/
	
	
	function bookpackageshow(serviceId,employeeId){
	
	
	  var longmonths = ['<?php echo __('January',true); ?>', '<?php echo __('February',true); ?>', '<?php echo __('March',true); ?>', '<?php echo __('April',true); ?>', '<?php echo __('May',true); ?>', '<?php echo __('June',true); ?>', '<?php echo __('July',true); ?>', '<?php echo __('August',true); ?>', '<?php echo __('September',true); ?>', '<?php echo __('October',true); ?>', '<?php echo __('November',true); ?>', '<?php echo __('December',true); ?>'];
	var shortdays = ['<?php echo __('Sun',true); ?>', '<?php echo __('Mon',true); ?>', '<?php echo __('Tue',true); ?>', '<?php echo __('Wed',true); ?>', '<?php echo __('Thu',true); ?>', '<?php echo __('Fri',true); ?>', '<?php echo __('Sat',true); ?>'];
	var forcusttitle = ['<?php echo __('next_week',true);?>', '<?php echo __('in',true); ?>', '<?php echo __('weeks',true); ?>','<?php echo __('week',true); ?>', '<?php echo __('in_a_month',true); ?>', '<?php echo __('month',true); ?>', '<?php echo __('months',true); ?>', '<?php echo __('in_a_year',true); ?>','<?php echo  __('year',true); ?>','<?php echo __('years',true); ?>'];
	
	$(document).find('div.loader-container').show();
	var d = new Date();
        var n = d.getDay();
        var bookPackageURL = '<?php echo $this->Html->url(array('controller'=>'Packagebooking','action'=>'showPackage'));?>'+'/'+serviceId+'/'+employeeId;
        $(document).find(".bukingPackage").load(bookPackageURL, function() {
//                var slider= $(document).find('#servicelightSlider').lightSlider({
//		    gallery: true,item: 1,loop: true,
//		    <?php if($lang && $lang == 'ara'){ ?>
//		    rtl:true,
//		    <?php }?>
//		    slideMargin: 0,thumbItem: 7
//		});
		$(document).find('.bxslider').bxSlider({
		    auto: true,
		    pagerCustom: '#bx-pager'
		});
		//
		var offerOn = $(this).find('.offerOn').text();
	        $(document).find('.widgetPackageCalendar').weekCalendar({dateFormat: 'd',firstDayOfWeek:n,minDate:d,longMonths: longmonths ,shortDays: shortdays , fortitle: forcusttitle, activeDay : offerOn });
		$(document).find('div.packageList').html('');
		$(document).find('div.loader-container').hide();
		var theday = $(document).find('div.cal-sec').find('div.wc-header').find('li.ui-state-active a').attr('data-day');
		$(document).find('.cal-sec').attr('data-sday',theday);
		//enableSubmit();
            });
	
    }
    
    
        function getstaffforPackageAppointment(date,serviceId,employeeId,optionId){
	var getStaffURL = '<?php echo $this->Html->url(array('controller'=>'bookings','action'=>'getStaff'));?>'+'/'+date+'/'+serviceId+'/'+employeeId+'/'+'0';
	$(document).find('.bukingPackage #bookappointment').find("#"+optionId).find("#stafFor_"+serviceId).show();
	$(document).find('.bukingPackage #bookappointment').find("#option_"+optionId).find("#stafFor_"+serviceId).show().find(".allStylistHere").load(getStaffURL, function() {
	//if($(this).find('li').length > 0){
	//	$(this).find('li:first a').click();
	//}
	//    $(document).find('.bukingService #bookappointment .stylistListData div.loader-container').hide();
	    
	});
    }
    
    
    
    function enablePackageSubmit(packageObj){
	if(packageObj.find('#bookappointment').hasClass('active')){
	    var validFields = ['PackageId','selDate','PackagePrice','PackageDuration','selBukTyp'];
	    var theCheck = true;
	    $.each( validFields , function( i, val ) {
		if(empty(packageObj.find('#'+val).val())){
		    theCheck = true;    
		}
	    });
	    if(packageObj.find(".allPriceOpt a").hasClass("selectedPrice")){
		var optionServices = packageObj.find(".allPriceOpt a:visible").attr("data-services");
		var OptionServiceArray = optionServices.split(',');
		
		servcErr = 0;
		$.each(OptionServiceArray, function(  index, value) {
		    var staff = packageObj.find("input[name='data[Appointment][services]["+value+"][staff_id]']").val();
		    var duration =  packageObj.find("input[name='data[Appointment][services]["+value+"][duration]']").val();
		    var slot = packageObj.find("input[name='data[Appointment][services]["+value+"][slot]']").val();
		  
			if(empty(staff)){
			servcErr++;
		      }
		      if(empty(duration)){
			servcErr++;
		      }
		      if(empty(slot)){
			servcErr++;
		      }
		});
	    }else{
		servcErr++;
	    }
	   
	    if(theCheck && servcErr==0){
		packageObj.find('#bookappointment').find('a.action').removeClass('disabled');
	    }else{
		packageObj.find('#bookappointment').find('a.action').addClass('disabled');
	    }
	}
	
	
	//if($(document).find('#buygift').hasClass('active')){
	//    var validFields = ['serviceId','selQuantity','priceOptId'];
	//    var theCheck = true;
	//    $.each( validFields , function( i, val ) {
	//	if($(document).find('#'+val).val() == ''){
	//	    theCheck = false;    
	//	}
	//    });
	//    if(theCheck){
	//	$(document).find('#buygift').find('a.action').removeClass('disabled');
	//    }else{
	//	$(document).find('#buygift').find('a.action').addClass('disabled');
	//    }
	//}
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
    
    $(document).ready(function(){
        $(document).on('click','#bs-salonPage-navbar a',function(){
	    $(this).closest('#bs-salonPage-navbar').removeClass('in');
	    var href = $(this).attr('href');
	    
	    //console.log(href);
	    if(href == '#Services'){
		var serviceHTML = $(document).find('div'+href).find('div.serviceList').text();
		//if(serviceHTML == ''){
		    $(document).find('div.loader-container').show();
		    var soalonService = "<?php echo $this->Html->url(array('controller'=>'Place','action'=>'salonservices','admin'=>false,$userDetails['User']['id'])); ?>";
	    	    $(document).find("div.serviceList").load(soalonService,function(){
			$(document).find('div.loader-container').hide();
			$(document).find(".bukingService").html('');
		    }); 
		//}
	    }
	    
	    if(href == '#Deals'){
		var serviceHTML = $(document).find('div'+href).find('div.dealList').text();
		//if(serviceHTML == ''){
		    $(document).find('div.loader-container').show();
		    var soalonDeal = "<?php echo $this->Html->url(array('controller'=>'Place','action'=>'salondeals','admin'=>false,$userDetails['User']['id'])); ?>";
	    	    $(document).find("div.dealList").load(soalonDeal,function(){
			$(document).find('div.loader-container').hide();
			$(document).find(".bukingDeal").html('');
		    }); 
		//}
	    }
	    
	    if(href == '#Gallery'){
		var galleryHTML = $(document).find('div'+href).text();
		//if(galleryHTML == ''){
		    $(document).find('div.loader-container').show();
		    var galleryService = "<?php echo $this->Html->url(array('controller'=>'Place','action'=>'salongallery','admin'=>false,$userDetails['User']['id'])); ?>";
	    	    $(document).find('div'+href).load(galleryService,function(){
			$(document).find('div.loader-container').hide();
			//$(document).find(".bukingService").html('');
		    });
		//}
	    }
	    
	    if(href == '#Package'){
		//alert(href);
		var packageHTML = $(document).find('div'+href).find('div.packageList').text();
		//if(packageHTML == ''){
		    $(document).find('div.loader-container').show();
		    var salonPackage = "<?php echo $this->Html->url(array('controller'=>'Place','action'=>'salonpackages','admin'=>false,$userDetails['User']['id'])); ?>";
	    	    $(document).find("#Package div.packageList").load(salonPackage,function(){
			$(document).find('div.loader-container').hide();
			$(document).find(".bukingPackage").html('');
		    }); 
		//}
	    }
	    
	    if(href == '#SpaDay'){
		//alert(href);
		var packageHTML = $(document).find('div'+href).find('div.SpadayList').text();
		//if(packageHTML == ''){
		    $(document).find('div.loader-container').show();
		    var salonPackage = "<?php echo $this->Html->url(array('controller'=>'Place','action'=>'salonspaday','admin'=>false,$userDetails['User']['id'])); ?>";
	    	    $(document).find("#SpaDay div.SpadayList").load(salonPackage,function(){
			$(document).find('div.loader-container').hide();
			$(document).find(".bukingSpaday").html('');
		    }); 
		//}
	    }
	    
	    if(href == '#Staff'){
		var staffHTML = $(document).find('div'+href).text();
		//if(staffHTML == ''){
		    $(document).find('div.loader-container').show();
		    var salonPackage = "<?php echo $this->Html->url(array('controller'=>'SalonStaff','action'=>'salonStaff','admin'=>false,$userDetails['User']['id'])); ?>";
	    	    $(document).find("#Staff").load(salonPackage,function(){
			$(document).find('div.loader-container').hide();
		    }); 
		//}
	    }
	    
	    if(href == '#Gifts'){
		var giftsHTML = $(document).find('div'+href).text();
		//if(giftsHTML == ''){
		    $(document).find('div.loader-container').show();
		    var giftsPackage = "<?php echo $this->Html->url(array('controller'=>'Place','action'=>'salongiftcertificate','admin'=>false,$userDetails['User']['id'])); ?>";
	    	    $(document).find("#Gifts").load(giftsPackage,function(){
			$(document).find('div.loader-container').hide();
		    }); 
		//}
	    }
	});
	
	$(document).on('click','.bukingService a.action',function(){
	    var theAppType = $(this).attr('data-type');
	    if(!$(this).hasClass('disabled')){
		$(document).find('#selBukTyp').val(theAppType);
		$(document).find('#AppointmentShowServiceForm').submit();
	    }
	});
	
	$(document).on('click','.forBooking',function(){
            var theObj = $(this);
            var serviceId = theObj.attr('data-id');
            if(serviceId){
                bookserviceshow(serviceId,0);
            }
        });
	
	$(document).find("#Services").on('click','a.list-group-item',function(){
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
	
	
	$(document).find("#Services").on('click','div.cal-sec a.theDateCal',function(){
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
	
	
	$(document).find("#Services").on('click','a.getEmpSelTime',function(){
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

	
/*************************Package Booking*****************/	
	
    $(document).on('click','.bukingPackage a.action',function(){
	    var theAppType = $(this).attr('data-type');
	    if(!$(this).hasClass('disabled')){
		$(document).find('#selBukTyp').val(theAppType);
		$(document).find('#AppointmentShowPackageForm').submit();
	    }
    });	 
    packageObj = $(document).find("#Package");
    
   
    
    $(document).find(".packageList").on('click','.forPackageBooking',function(){
	var theObj = $(this);
	var packageId = theObj.attr('data-id');
	if(packageId){
	    bookpackageshow(packageId,0);
	}
    });
  
    
    packageObj.on('click','div.cal-sec a.theDateCal',function(){
	//e.preventDefault();
	 var dateObj = $(this);
	 if(!dateObj.closest('div.cal-sec').hasClass('disabled')){
		dateObj.closest('ul').find('li').removeClass('ui-state-active');
		if(dateObj.find('span').hasClass('bright')){
		
			dateObj.closest('li').addClass('ui-state-active');
			
		}
	     
	    var datdayObj = packageObj.find('div.cal-sec').find('div.wc-header').find('li.ui-state-active a');
	    var thedate = datdayObj.attr('data-date');
	    var optionId = packageObj.find(".allPriceOpt a.selectedPrice").attr("data-priceid");
	    packageObj.find(".packgServc").hide();
	    packageObj.find("#option_"+optionId).show();
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
	    
	
	  enablePackageSubmit(packageObj);
    });
    packageObj.on('click','.packgServc a.list-group-item:visible',function(){
	var selected = $(this).find("span.badge").length;
	if(selected > 0){
	    $(this).next().slideDown();
	}
	
    });
    packageObj.on('click','a.getEmpSelTime',function(e){
	    e.preventDefault();
	    /**********Check Local Storage********************/
	    //window.localStorage.clear();
	    console.log(localStorage["manual"]);
	    if(!empty(localStorage["manual"])){
	        var storedNames = JSON.parse(localStorage["manual"]);
		var stylist = Array();
		var slots = Array();
		 if(!empty(storedNames)){
		    $.each( storedNames, function(  index, value ) {
			stylist = value.split('~');
			slots = stylist[1].split('-');
			console.log(stylist[0]);
			console.log(slots[0]);
			console.log(slots[1]);
			
		    });
		 }
	    }
	       console.log(storedNames);
	    /****************End****************************/
	    var getempTime = $(this);
	    var serviceId = $(this).closest(".stylistListData").prev().attr("id");
	    packageObj.find("#stafFor_"+serviceId).find('div.allStylistHere').find('a').removeClass('active');
	    getempTime.addClass('active');
	    var datdayObj = packageObj.find('div.cal-sec').find('div.wc-header').find('li.ui-state-active a');
	   // alert(getempTime.closest(".book-stylist").attr("data-staffid"));
	    var stylistName = getempTime.closest(".book-stylist").find(".lft span").html();
	    var stylistId = getempTime.closest(".book-stylist").attr("data-staffid");
	    var thedate = datdayObj.attr('data-date');
	    $(this).closest(".stylistListData").slideUp("slow");
	    $(this).closest(".stylistListData").prev().find(".badge").html(stylistName);
	    $(this).closest(".stylistListData").prev().find(".list-group-item-text").html("<i class='fa fa-clock-o'></i><span class='text'> "+$(this).html()+" </span>");
	    var setpackageServices = packageObj.find(".allPriceOpt a.selectedPrice").attr("data-services");
	    var duration = packageObj.find(".allPriceOpt a.selectedPrice").attr("data-option-duration");
	   
	    var packageServicesArray = setpackageServices.split(',');
	    
	    var nextId = $(this).closest(".stylistListData").next().attr("id");
	    var optionId = packageObj.find(".allPriceOpt a.selectedPrice").attr("data-priceid");
	    var slot = getempTime.closest('li').attr('data-time');
	    //	$.each( packageServicesArray, function(  index, value ) {
	    //
	    packageObj.find(".PackageServices").append("<input  class='dynamicAppnt' type='hidden' name='data[Appointment][services]["+serviceId+"]'>");
	    packageObj.find(".PackageServices").append("<input class='dynamicAppnt' value='"+stylistId+"'  type='hidden' name='data[Appointment][services]["+serviceId+"][staff_id]'>");
	    packageObj.find(".PackageServices").append("<input class='dynamicAppnt' value='"+duration+"' type='hidden' name='data[Appointment][services]["+serviceId+"][duration]'>");
	    packageObj.find(".PackageServices").append("<input class='dynamicAppnt' value='"+slot+"' type='hidden' name='data[Appointment][services]["+serviceId+"][slot]'>");
	    
	    var staffSlot = [];
	    staffSlot[0] = stylistId+'~'+duration+'-'+slot;
	    
	    localStorage["manual"] = JSON.stringify(staffSlot);
	    
	    //...
	
	 
	    
	    //});
	    getstaffforPackageAppointment(thedate,nextId,0,optionId);
	    enablePackageSubmit(packageObj);
	});
    
    
    packageObj.on('click','.allPriceOpt a.list-group-item',function(){
	    var thepObj = $(this);
	    var thepriceId = thepObj.attr('data-priceid');
	     packageObj.find(".widgetPackageCalendar").css("display","none");
	    if(thepObj.hasClass('selectedPrice')){
	    
		//last step
		    packageObj.find(".packgServc").find(".stylistListData").html();
		    packageObj.find(".packgServc").hide();
		//
		
		// Selection step
		    packageObj.find('div.chooseBookingType').removeClass("selectedPrice");
		    packageObj.find('div.chooseBookingType').find("a").each(function(){
			if(!$(this).hasClass("no-hover")){
			    $(this).find("h4 .fa").remove();
			}
		    });
		    packageObj.find('div.chooseBookingType').find('a').show();
		    packageObj.find(".widgetPackageCalendar").css("display","none");
		//
		// Remove Services
		    packageObj.find(".dynamicAppnt").remove();
		    packageObj.find(".packgServc").find(".badge").html("");
		    packageObj.find(".packgServc").find(".list-group-item-text").html("");
		//
		packageObj.find(".chooseBookingType").css('display','none');
		packageObj.find('#priceOptId').val('');
		packageObj.find('div.allPriceOpt').find('a').show();
		var mainPriceOpt = packageObj.find('div.allPriceOpt').find('a[data-priceid='+thepriceId+']');
		mainPriceOpt.removeClass('selectedPrice').show();
		mainPriceOpt.find('h4 .fa').remove();
		packageObj.find('div.cal-sec').addClass('disabled');
		packageObj.find('input#selDate').val('');
		packageObj.find('.bukingService #bookappointment .stylistListData .allStylistHere').html('');
		toRemovePrice();
	    }else{
		if(thepriceId){
		    packageObj.find('#priceOptId').val(thepriceId);
		    packageObj.find(".chooseBookingType").css('display','block');
		    packageObj.find('div.allPriceOpt').find('a').hide();
		    var mainPriceOpt = packageObj.find('div.allPriceOpt').find('a[data-priceid='+thepriceId+']');
		    mainPriceOpt.addClass('selectedPrice').show();
		    mainPriceOpt.find('h4').prepend('<i class="fa  fa-chevron-circle-down"></i>');
		    packageObj.find('#PackagePrice').val(mainPriceOpt.attr('data-price'));
		    packageObj.find('#PackageDuration').val(mainPriceOpt.attr('data-price'));
		    packageObj.find('div.cal-sec').removeClass('disabled');
		    var datdayObj = $(document).find('div.cal-sec').find('div.wc-header').find('li.ui-state-active a');
		    var thedate = datdayObj.attr('data-date');
		    if(datdayObj.find('span').hasClass('bright')){
			//var theday = datdayObj.attr('data-day');
			//$(document).find('.cal-sec').attr('data-sday',theday);
			//var serviceId = $(document).find('input#serviceId').val();
			//var employeeId = $(document).find('input#employeeId').val();
			//$(document).find('input#selDate').val(thedate);
			//toAddPrice();
			//getstaffforAppointment(thedate,serviceId,employeeId,thepObj.attr('data-pricelevel'));
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
	    enablePackageSubmit(packageObj);
	});
 
packageObj.on('click',".chooseBookingType a.list-group-item",function(){
	var type = $(this).attr("data-type");
	if(type){
		if($(this).hasClass('selectedPrice')){
		    $(this).removeClass("selectedPrice");
		    $(this).find('h4 .fa').remove();
		    packageObj.find('div.chooseBookingType').find('a').show();
		    packageObj.find(".widgetPackageCalendar").css("display","none");
		}else{
		    $(this).find('h4').prepend('<i class="fa  fa-chevron-circle-down"></i>');
		    packageObj.find('div.chooseBookingType').find('a').hide();
		    $(this).addClass('selectedPrice').show();
		     if(type=="manual"){
			packageObj.find(".widgetPackageCalendar").css("display","block");
			 var datdayObj = packageObj.find('div.cal-sec').find('div.wc-header').find('li.ui-state-active a');
			 var thedate = datdayObj.attr('data-date');
			if(datdayObj.find('span').hasClass('bright')){
				    var theday = datdayObj.attr('data-day');
				    packageObj.find('.cal-sec').attr('data-sday',theday);
				    var packageId = $(document).find('input#PackageId').val();
				    var employeeId = $(document).find('input#employeeId').val();
				    $(document).find('input#selDate').val(thedate);
				    //alert(packageObj.find(".allPriceOpt a.selectedPrice").length);
				    if(packageObj.find(".allPriceOpt a.selectedPrice").length > 0){
					var optionId = packageObj.find(".allPriceOpt a.selectedPrice").attr("data-priceid");
					packageObj.find(".packgServc").hide();
					packageObj.find("#option_"+optionId).show();
					
					
					var i=0;
					packageObj.find("#option_"+optionId).find("a").each(function(id) {
					  var serviceId = $(this).attr('id');
		       			  if(serviceId){
					    
						if(i==0){
						    getstaffforPackageAppointment(thedate,serviceId,employeeId,optionId);	    i++;
						}
					    }
					   
					});
				    }  
				    //getstaffforAppointment(thedate,packageId,employeeId);
			}else{
			    
			    alert("evoucher");
			    
			//getstaffforAppointment(thedate,0,0,0);
			//$(document).find('input#selDate').val('');
			//if($(document).find('#buygift').hasClass('active')){
			//    toAddPrice();
			//}else{
			//    toRemovePrice();    
			//}
		    }
		    }else if(type=="automatic"){
			packageObj.find(".widgetPackageCalendar").css("display","none");
		    }
	    }
	    
	}
	
	
 });   
    
/**********************************************************/

    });
</script>
<script>
$(document).ready(function(){
    var $sModal = $(document).find('#mySmallModal');
    var itsId  = "";
    $(document).on('click','.staffBuk' ,function(){
	var itsId = $(this).attr('id');
	var dataVal = $(this).attr('data-val');
        var bTypeView = "<?php echo $this->Html->url(array('controller'=>'SalonStaff','action'=>'get_salonDetail')); ?>";
       
        bTypeView = bTypeView+'/'+itsId+'/'+dataVal
        // function in modal_common.js
        $sModal.load(bTypeView,function(){
		$sModal.modal('show'); });
        return false;
	});
    });
</script>
