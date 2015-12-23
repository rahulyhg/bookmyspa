<!--main banner starts-->
<?php echo $this->Html->script('frontend/widget'); ?>
<?php echo $this->Html->script('frontend/date'); ?>
<?php echo $this->Html->script('frontend/jquery.weekcalendar'); ?>
<?php echo $this->Html->css('lightslider/lightGallery'); ?>
<?php echo $this->Html->script('lightslider/lightGallery'); ?>
<?php echo $this->Html->script('admin/plugins/imagesLoaded/jquery.imagesloaded.min'); ?>
<?php echo $this->Html->script('admin/plugins/masonry/jquery.masonry.min'); ?>
<?php $lang =  Configure::read('Config.language'); ?>
<div class="main-banner">
    <?php
	if(isset($userDetails['Salon']['cover_image']) && !empty($userDetails['Salon']['cover_image'])) {
	    echo $this->Html->image("/images/".$userDetails['User']['id']."/Salon/800/".$userDetails['Salon']['cover_image'],array('data-id'=>$userDetails['User']['id']));
	} else {
	    echo $this->Html->image('cover-bckend.jpg',array('alt'=>"",'title'=>""));
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
                <span class="email">
		    <i class="fa fa-globe"></i>
		    <?php echo $this->Html->link($userDetails['Salon']['website_url'],$userDetails['Salon']['website_url'],array('target'=>'_blank','escape'=>false));?>
		</span>
		<span class="email">
		    <i class="fa fa-envelope"></i>
		    <?php echo $this->Html->link($userDetails['Salon']['email'],'mailto:'.$userDetails['Salon']['email'],array('target'=>'_blank','escape'=>false));?>
		</span>
                <span class="phone">
		    <i class="fa fa-phone"></i>
		    <?php echo $userDetails['Contact']['cell_phone'];?>
		</span>
                <span class="like">
		    <i class="fa fa-thumbs-o-up"></i> Like : +0 1
		</span>
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
            <li>
		<?php echo  $this->Html->link(__('home',true) , '/'); ?>
	    </li>
            <li>
		<i class="fa fa-angle-double-right"></i>
	    </li>
            <li>
		<?php echo $this->Html->link($user_type_text.'( '.$userDetails['Salon'][$lang.'_name']. ')',array('controller'=>'place','action'=>'index','admin'=>false,$userDetails['User']['id']),array('escape'=>false));?>
	    </li>
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
<?php echo $this->Js->writeBuffer();?>
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
	    ////selEmpId
	}
	if($(document).find('#buygift').hasClass('active')){
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
                var slider= $(document).find('#servicelightSlider').lightSlider({
		    gallery: true,item: 1,loop: true,
		    <?php if($lang && $lang == 'ara'){ ?>
		    rtl:true,
		    <?php }?>
		    slideMargin: 0,thumbItem: 7
		});
		var offerOn = $(this).find('.offerOn').text();
		$(document).find('.widgetCalendar').weekCalendar({dateFormat: 'd',firstDayOfWeek:n,minDate:d,longMonths: longmonths ,shortDays: shortdays , fortitle: forcusttitle, activeDay : offerOn });
		$(document).find('div.serviceList').html('');
		$(document).find('div.loader-container').hide();
		var theday = $(document).find('div.cal-sec').find('div.wc-header').find('li.ui-state-active a').attr('data-day');
		$(document).find('.cal-sec').attr('data-sday',theday);
            });
	
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
	    
	    if(href == '#Gallery'){
		var galleryHTML = $(document).find('div'+href).text();
		if(galleryHTML == ''){
		    $(document).find('div.loader-container').show();
		    var galleryService = "<?php echo $this->Html->url(array('controller'=>'Place','action'=>'salongallery','admin'=>false,$userDetails['User']['id'])); ?>";
	    	    $(document).find('div'+href).load(galleryService,function(){
			$(document).find('div.loader-container').hide();
			//$(document).find(".bukingService").html('');
		    });
		}
	    }
	    
	    if(href == '#Package'){
		var packageHTML = $(document).find('div'+href).find('div.packageList').text();
		if(packageHTML == ''){
		    $(document).find('div.loader-container').show();
		    var salonPackage = "<?php echo $this->Html->url(array('controller'=>'Place','action'=>'salonpackages','admin'=>false,$userDetails['User']['id'])); ?>";
	    	    $(document).find("#Package div.packageList").load(salonPackage,function(){
			$(document).find('div.loader-container').hide();
			$(document).find(".bukingPackage").html('');
		    }); 
		}
	    }
	    
	    if(href == '#Staff'){
		var staffHTML = $(document).find('div'+href).text();
		if(staffHTML == ''){
		    $(document).find('div.loader-container').show();
		    var salonPackage = "<?php echo $this->Html->url(array('controller'=>'SalonStaff','action'=>'salonStaff','admin'=>false,$userDetails['User']['id'])); ?>";
	    	    $(document).find("#Staff").load(salonPackage,function(){
			$(document).find('div.loader-container').hide();
		    }); 
		}
	    }
	    
	});
	
	
	
	
	
	
	
	
	$(document).on('click','.forBooking',function(){
            var theObj = $(this);
            var serviceId = theObj.attr('data-id');
            if(serviceId){
                bookserviceshow(serviceId,0);
            }
        });
	
	$(document).on('click','a.list-group-item',function(){
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
	});
	
	
	$(document).on('click','div.cal-sec a.theDateCal',function(){
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
	});
	
	
	$(document).on('click','a.getEmpSelTime',function(){
	    var getempTime = $(this);
	    $(document).find('div.allStylistHere').find('a').removeClass('active');
	    getempTime.addClass('active');
	    $(document).find('input#selTime').val(getempTime.closest('li').attr('data-time'));
	    $(document).find('input#selEmpId').val(getempTime.closest('div.book-stylist').attr('data-staffid'));
	    
	});
	
	$(document).on('click','ul.ulopts li',function(){
	    toAddPrice();
	});
	
	$(document).on('change','#selQty',function(){
	    var theQty = $(this).val();
	    $(document).find('#selQuantity').val(theQty);
	    toAddPrice();
	});
	
    });
</script>
