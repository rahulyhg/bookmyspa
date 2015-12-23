<?php echo $this->Html->script('bootbox.js');?>
 
<style>
.bootbox-body{
        font-size:large;
        margin:15px;
    }
    #services-accordion div.place-holder {
        border: 1px dashed #CCC; margin-top: 5px;
        min-height: 55px !important;
    }
    div.treat-holder{
        border: 1px dashed #CCC;
        min-height: 245px;
    }
</style>
<script>


$(function () {
    $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});
	deal_count = parseInt('<?php echo $dealCount ?>');
	var $packagemodal = $('#commonMediumModal');
	$(document).on('click','.addDeal',function(e){
		    if(checkDealLimit(deal_count)){
		    var id = $(this).attr('data-id');
		    if(!id){ id = 0; }
		    var theservice = '<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'add_deal','admin'=>true));?>';
		    fetchstaticModal($packagemodal,theservice);
		    packageModal = 'yes';
		}
    });
	 var $treatmentsmodal = $('#commonSmallModal');
       $(document).on('click','.forService',function(){
	//    var packageId = $packagemodal.find('input#PackageId').val();
	    var theservice = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'selectdeal_service','admin'=>true,'deals'));?>';
	    fetchstaticModal($treatmentsmodal,theservice);
		$packagemodal.modal('toggle');
       });
	   
       var packageModal = 'yes'; 
       var $packagemodal = $('#commonVendorModal');
       $(document).on('click','.forPackage',function(){
		var id = $(this).attr('data-id');
		if(!id){ id = 0; }
		var theservice = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'selectdeal_package','admin'=>true,'Package'));?>';
		fetchstaticModal($packagemodal,theservice,'DealCreateForm');
		packageModal = 'yes';
		$packagemodal.modal('toggle');
       });
	   
	   var $treatmentsmodal = $('#commonContainerModal');
       $packagemodal.on('click','.forSpaDay',function(){
	//    var packageId = $packagemodal.find('input#PackageId').val();
	    var theservice = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'selectdeal_package','admin'=>true,'Spaday'));?>';
	    fetchstaticModal($treatmentsmodal,theservice,'DealCreateForm');      
       });
	   
}); 


</script>
<div class="row" >
  <div class="box">
	<div class="box-content side-gap">
	  <div role="tabpanel" class="vendor-deal-sec">
            <?php echo $this->element('admin/Business/nav_service'); ?>
          
	  <!-- Tab panes -->
	  <div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="Deals">
		
            <div class="vendor-deal-head">
                <div class="col-sm-3 col-xs-5 nopadding">
                    <select id="forDeal" class="form-control">
                        <option value="2">All Deals</option>
                        <option value="1"> Active </option>
                        <option value="0"> Inactive </option>
                    </select>
                </div>
              <a class="rt-text addDeal" data-id=""><i class="fa fa-plus"></i> Add Deals</a>
            </div>
                
            <div class="vendor-deal-content deal-content clearfix">
		<?php echo $this->element('admin/Business/all_deals'); ?>
            </div>
		
		</div>
	  </div>
	  
	  </div>
	</div>
  </div>
</div>
<script>
    $(document).ready(function(){
		
	/*********Package Deal ********/
	var $dealmodal = $('#commonContainerModal');
	var dealsubmit = 'yes';
	$('body').on('click','.create_pkgdeal',function(){ 
	   // var pkgId = $dealmodal.find('#PackageId').val();
		var pkgId = $(this).attr('PackageId');
		var type = $(this).attr('data-type');
		
	    var pkgdeal = '<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'create_servicedeal','admin'=>true));?>'+'/'+pkgId+'/'+type+'/0';
	    fetchstaticModal($dealmodal,pkgdeal,'DealcreateForm');
	    //fetchstaticModal($dealmodal,servicedeal);
	    dealsubmit = 'yes';
	});
		
	deal_count = parseInt('<?php echo $dealCount ?>');
	$(document).on('click','.active-deactive-deal',function(){
	    var theObj = $(this);
            var theID = $(this).attr('data-id');
           
            if($(this).hasClass('active')){
                status = 0;
                msgs = "Are you sure you want to deactivate the deal ?";
            }else{
		if(checkDealLimit(deal_count)){
			var status = 1;
			var msgs = "Are you sure you want to activate the deal ?";
		}else{
			return false;
		    }     
	    }
            if(confirm(msgs)){
		$.ajax({
                    url: "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'change_deal_status','admin'=>true))?>",
                    type:'POST',
                    data: {'id':theID,'status':status}
                }).done(function(msg){
		    if(msg == 1){
                        theObj.closest('div.bottom').removeClass('dull');
                        theObj.closest('div.v-deal-box').find('span.status').remove();
                        theObj.addClass('active').text('Deactivate');
                    }else if(msg == 0){
                        theObj.removeClass('active').text('Activate');
                        theObj.closest('div.bottom').addClass('dull');
                        theObj.closest('div.v-deal-box').find('div.upper').append('<span class="status">Activate Service</span>');
                    }else{
			alert(msg);
		    }
                });
            }
        });
	
	
	$(document).on('change','#forDeal',function(){
            var treatf = $(this);
	    var theVal = treatf.val();
	    if(theVal == 0 ){
                $(document).find('.deal-content').find('.v-deal').each(function(){
		    if($(this).find('.active-deactive-deal').hasClass('active')){
			$(this).hide('slow');
		    }else{
			$(this).show('slow');
		    }
		});
            }
            else if(theVal == 1 ){
                $(document).find('.deal-content').find('.v-deal').each(function(){
		    if($(this).find('.active-deactive-deal').hasClass('active')){
			$(this).show('slow');
		    }else{
			$(this).hide('slow');
		    }
		});
            }
            else{
	        $(document).find('.deal-content').find('.v-deal').each(function(){
		    $(this).show('slow');
		});
            }
        });
    
	$(document).on('click','.delete_servicedeal',function(){
            var Obj = $(this)
            if(confirm('Are you sure you want to delete the deal?')){
                //check if Associated
                var theId = Obj.attr('data-id');
		if(theId){
		    $.ajax({
			url: "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'deletedeal','admin'=>true))?>",
			type:'POST',
			data: {'id':theId}
		    }).done(function(msg) {
		       msg = $.trim(msg);
		       if(msg == 'success'){
				Obj.closest('div.v-deal').remove();
		       }else{
			      bootbox.alert(msg);
		       }
		    });
		}
            }
        });
    
	var $dealmodal = $('#commonContainerModal');
	var dealsubmit = 'yes';
	$(document).on('click','.create_servicedeal',function(){
	    var serviceId = $(this).attr('data-serviceid');
	    var id = $(this).attr('data-id');
	    var servicedeal = '<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'create_servicedeal','admin'=>true));?>'+'/'+serviceId+'/Service/'+id;
	    fetchstaticModal($dealmodal,servicedeal,'DealcreateForm');
	    dealsubmit = 'yes';
	});
	
	$(document).on('click','.deleteTreat',function(){
            var OBJ = $(this)
            if(confirm('Are you sure you want to delete the treatment ?')){
                //check if Associated
                deleteService(OBJ,'treatment');
            }
        });
	
	$dealmodal.on('click', '.addblkdate', function(e){
	    var theBkOj = $(this);
	    var theDate = theBkOj.closest('div.mainBkD').find('input').val();
	    theBkOj.closest('div.mainBkD').find('input').val('');
	    if(theDate){
		//var theHTML = theBkOj.closest('div.mainBkD').clone();
		var tillDates = theBkOj.closest('section').find('.theDates');
		var thelenCnt = tillDates.find('.chkblkD').length;
		if(thelenCnt > 0){
		    thelenCnt = tillDates.find('.selBlkOutDates:last').attr('data-rel');
		}
		var theIdNo = parseInt(thelenCnt)+1;
		theHTML = '<div class="chkblkD"><div class="date mrgn-rgt10 w60 mrgn-btm10"><input name="data[Deal][blackout_dates]['+theIdNo+']" data-rel="'+theIdNo+'" class="form-control selBlkOutDates" id="DealBlackoutDates'+theIdNo+'" type="text"></div><div class="lft-p-non col-sm-4"><a href="javascript:void(0);" class="removeblkdate"><i class="fa fa-trash-o"></i></a></div></div>';
		tillDates.append(theHTML);
		tillDates.find('#DealBlackoutDates'+theIdNo).val(theDate);
		$dealmodal.find('#DealBlackoutDates'+theIdNo).datepicker({dateFormat: 'yy-mm-dd',minDate: 0,showOn: "button",buttonImage: "/img/calendar.png",buttonImageOnly: true});
	    }
	    else{
		theBkOj.closest('div.mainBkD').find('dfn.text-danger').css('display','inline');
	    }
	});
	$dealmodal.on('click', '.removeblkdate', function(e){
	    if(confirm('Are you sure, you want to delete this blackout date?')){
		$(this).closest('.chkblkD').remove();
	    }
	});
	
	$dealmodal.on('click', '.submitTheDeal', function(e){
	   // alert("Hello");
	    var dealbtnObj = $(this);
	    buttonLoading(dealbtnObj);
            var options = {
                success: function(res){
		    buttonSave(dealbtnObj);
		    dealsubmit = 'yes';
                    if (onResponse($dealmodal, 'DealcreateForm', res)){
			var dealsList = "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'deals','admin'=>true))?>"
			location.reload(); 
                    }
                },
             };
	    if(!dealbtnObj.hasClass('rqt_already_sent')){
		$('#DealcreateForm').submit(function() {
		    console.log($('#DealcreateForm').validate());
		    if($('#DealcreateForm').validate()){
			if(!$dealmodal.find('ul.imagesList').find('li:first').hasClass('empty')){
			    if(dealsubmit == 'yes'){
				dealbtnObj.addClass('rqt_already_sent');
				$(this).ajaxSubmit(options);
				dealsubmit = 'no';            
			    }
			}else{
			    $dealmodal.find('ul.imagesList').find('li:first').css('border','1px Solid red');
			    $dealmodal.find('ul.imagesList').find('dfn.text-danger').remove();
			    $dealmodal.find('ul.imagesList').find('li:first').after('<dfn class="text-danger " style="display: inline;">Please select atleast one image.</dfn>');
			}
		    }
		    $(this).unbind('submit');
		    $(this).bind('submit');
		    return false;
		    
		});
	    }else{
		e.preventDefault();
	    }
	      
	    if($dealmodal.find('ul.imagesList').find('li:first').hasClass('empty')){
		$dealmodal.find('ul.imagesList').find('li:first').css('border','1px Solid red');
		$dealmodal.find('ul.imagesList').find('dfn.text-danger').remove();
		$dealmodal.find('ul.imagesList').find('li:first').after('<dfn class="text-danger k-invalid-msg" style="display: inline;">Please select atleast one image.</dfn>');
	    }
	    
	    setTimeout(function(){
		if($dealmodal.find('dfn.text-danger').length > 0){
		    if($("#DealcreateForm").find('.k-invalid').length > 0){
			var errorDiv = $("#DealcreateForm").find('.k-invalid').first();
			var scrollPos = errorDiv.offset().top;
			$dealmodal.find('.scrollError').scrollTop(scrollPos);
			errorDiv.trigger('focus');
		    }
		    
		    $dealmodal.find('div.tab-pane').removeClass('active');
		    $dealmodal.find('div.tab-pane#dealfirst1').addClass('active');
		    $dealmodal.find('ul.tabs li').removeClass('active');
		    $dealmodal.find('ul.tabs a[href=#dealfirst1]').closest('li').addClass('active');
		    buttonSave(dealbtnObj);
		}
	    },500);
	    
	});
	
	
	$forDealAddingImagemodal = 	 $('#commonVendorModal'); 
	
	$(document).on('click', '.addDealImage', function(e){
	    var ServiceId = $dealmodal.find('#DealcreateForm').find('#DealServicePackage0SalonServiceId').val();
	    var theserviceImg = '<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'service_images','admin'=>true));?>'+'/'+ServiceId+'/forDeal';
	    fetchstaticModal($forDealAddingImagemodal,theserviceImg);
	});
	
	$forDealAddingImagemodal.on('click', '.addImage-to-sub',function(){
            var thObject = $(this);
            var imageName = thObject.closest('li').find('img').attr('data-img');
            if(imageName){
		var imgRgt =  $dealmodal.find('.deal-img');
		imgRgt.find('dfn').remove();
		if(imgRgt.find('li:first').find('a.theChk').length > 0){
		    imgRgt.find('li:first').find('a.theChk').replaceWith('<img alt="" class="" src="/images/Service/150/'+imageName+'" data-img="'+imageName+'"><div class="extras"><div class="extras-inner"><a href="javascript:void(0);" class="addDealImage"><i class="fa fa-pencil"></i></a></div></div>');
		}else{
		    imgRgt.find('li:first').find('img').replaceWith('<img alt="" class="" src="/images/Service/150/'+imageName+'" data-img="'+imageName+'"><div class="extras"><div class="extras-inner"><a href="javascript:void(0);" class="addDealImage"><i class="fa fa-pencil"></i></a></div></div>');
		}
                imgRgt.find('li.empty:first').find('#DealImage').val(imageName)
                $forDealAddingImagemodal.modal('toggle');
	    }
            
        });/********************End********************/   
	
	$(".datepicker").datepicker();
    
    
    
    
    
    
    /*************Create Service Deal**************/
	var $dealmodal = $('#commonContainerModal');
	var dealsubmit = 'yes';
	/*$forTreatModal*/$(document).on('change','.subCheck',function(){
	    var serviceId = $(this).val(); 
	  //  var serviceId = $forTreatModal.find('.salon_service_id').val();
	    var servicedeal = '<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'create_servicedeal','admin'=>true));?>'+'/'+serviceId+'/Service/0';
	    fetchstaticModal($dealmodal,servicedeal,'DealcreateForm');
	    //fetchstaticModal($dealmodal,servicedeal);
	    dealsubmit = 'yes';
	});
	
	
    /*********Package Deal ********/
	var $dealpmodal = $('#commonContainerModal');
	var dealsubmit = 'yes';
	$(document).on('click','.create_packagedeal',function(){
	    var pkgId = $(this).attr('data-pkgId');
	    var pkgdlId = $(this).attr('data-id');
	    var type = $(this).attr('data-type');
	    var pkgdeal = '<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'create_servicedeal','admin'=>true));?>'+'/'+pkgId+'/'+type+'/'+pkgdlId;
	    fetchstaticModal($dealpmodal,pkgdeal,'DealcreateForm');
	    //fetchstaticModal($dealpmodal,servicedeal);
	    dealsubmit = 'yes';
	});
	
	$dealpmodal.on('click', '.addblkdate', function(e){
	    var theBkOj = $(this);
	    var theDate = theBkOj.closest('div.mainBkD').find('input').val();
	    theBkOj.closest('div.mainBkD').find('input').val('');
	    if(theDate){
		//var theHTML = theBkOj.closest('div.mainBkD').clone();
		var tillDates = theBkOj.closest('section').find('.theDates');
		var thelenCnt = tillDates.find('.chkblkD').length;
		if(thelenCnt > 0){
		    thelenCnt = tillDates.find('.selBlkOutDates:last').attr('data-rel');
		}
		var theIdNo = parseInt(thelenCnt)+1;
		theHTML = '<div class="chkblkD"><div class="date mrgn-rgt10 w60 mrgn-btm10"><input name="data[Deal][blackout_dates]['+theIdNo+']" data-rel="'+theIdNo+'" class="form-control selBlkOutDates" id="DealBlackoutDates'+theIdNo+'" type="text"></div><div class="lft-p-non col-sm-4"><a href="javascript:void(0);" class="removeblkdate"><i class="fa fa-trash-o"></i></a></div></div>';
		tillDates.append(theHTML);
		tillDates.find('#DealBlackoutDates'+theIdNo).val(theDate);
		$dealpmodal.find('#DealBlackoutDates'+theIdNo).datepicker({dateFormat: 'yy-mm-dd',minDate: 0,showOn: "button",buttonImage: "/img/calendar.png",buttonImageOnly: true});
	    }
	    else{
		theBkOj.closest('div.mainBkD').find('dfn.text-danger').css('display','inline');
	    }
	});
	
	$dealpmodal.on('click', '.removeblkdate', function(e){
	    if(confirm('Are you sure, you want to delete this blackout date?')){
		$(this).closest('.chkblkD').remove();
	    }
	});
	
	$dealpmodal.on('click', '.submitThepkg', function(e){
	    var dealbtnObj = $(this);
	    buttonLoading(dealbtnObj);
            var options = {
                success: function(res){
		    buttonSave(dealbtnObj);
		    dealsubmit = 'yes';
                    if (onResponse($dealpmodal, 'Deal', res)){
			window.location.href = '<?php echo $this->Html->url(array('controller'=>'Business','action'=>'deals','admin'=>true))?>';   
                    }
                },
             };
	    if(!dealbtnObj.hasClass('rqt_already_sent')){
		$('#DealcreateForm').submit(function() {
		   // alert($('#DealcreateForm').validate());
		    if($('#DealcreateForm').validate()){
			if(dealsubmit == 'yes'){
			    dealbtnObj.addClass('rqt_already_sent');
			    $(this).ajaxSubmit(options);
			    dealsubmit = 'no';            
			}
			
		    }
		    $(this).unbind('submit');
		    $(this).bind('submit');
		    return false;
		    
		});
	    }else{
		e.preventDefault();
	    }
	    
	    
	    setTimeout(function(){
		if($dealpmodal.find('dfn.text-danger').length > 0){
		    if($("#DealcreateForm").find('.k-invalid').length > 0){
			var errorDiv = $("#DealcreateForm").find('.k-invalid').first();
			var scrollPos = errorDiv.offset().top;
			$dealpmodal.find('.scrollError').scrollTop(scrollPos);
			errorDiv.trigger('focus');
		    }
		    
		    $dealpmodal.find('div.tab-pane').removeClass('active');
		    $dealpmodal.find('div.tab-pane#dealfirst1').addClass('active');
		    $dealpmodal.find('ul.tabs li').removeClass('active');
		    $dealpmodal.find('ul.tabs a[href=#dealfirst1]').closest('li').addClass('active');
		    buttonSave(dealbtnObj);
		}
	    },500);
	    
	});
	
	
	$forDealAddingImagemodal = 	 $('#commonSmallModal'); 
	$dealpmodal.on('click', '#addDealImage', function(e){
	    var ServiceId = $dealpmodal.find('#DealcreateForm').find('#DealPackageId').val();
	    var theserviceImgs = '<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'service_images','admin'=>true));?>'+'/'+ServiceId+'/Package';
	    fetchstaticModal($forDealAddingImagemodal,theserviceImgs);
	});
	
	$forDealAddingImagemodal.on('click', '.addImage-to-sub',function(){
	    
            var thObject = $(this);
            var imageName = thObject.closest('li').find('img').attr('data-img');
            if(imageName){
		var imgRgt =  $dealpmodal.find('.deal-img');
		imgRgt.find('dfn').remove();
		if(imgRgt.find('li:first').find('a.theChk').length > 0){
		    imgRgt.find('li:first').find('a.theChk').replaceWith('<img alt="" class="" src="/images/Service/150/'+imageName+'" data-img="'+imageName+'"><div class="extras"><div class="extras-inner"><a href="javascript:void(0);" class="addDealImage"><i class="fa fa-pencil"></i></a></div></div>');
		}else{
		    imgRgt.find('li:first').find('img').replaceWith('<img alt="" class="" src="/images/Service/150/'+imageName+'" data-img="'+imageName+'"><div class="extras"><div class="extras-inner"><a href="javascript:void(0);" class="addDealImage"><i class="fa fa-pencil"></i></a></div></div>');
		}
                imgRgt.find('li.empty:first').find('#DealImage').val(imageName)
                $forDealAddingImagemodal.modal('toggle');
	    }
            
        });
	
	/*********Package Deal Ends ********/
	
	
    });
    
</script>
