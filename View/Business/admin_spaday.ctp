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
});

</script>
<div class="row" >
  <div class="box">
	<div class="box-content side-gap">
	  <div role="tabpanel" class="vendor-deal-sec">
          <?php echo $this->element('admin/Business/nav_service'); ?>

	  <!-- Tab panes -->
	  <div class="tab-content">
		<div role="tabpanel" class="tab-pane " id="SERVICES"></div>
		<div role="tabpanel" class="tab-pane active" id="Packages">
                    <div class="vendor-deal-head">
		    <div class="col-sm-3 col-xs-5 nopadding">
                        <select class="package_filter form-control">
                          <option value="2">All Spa Day</option>
                          <option value="1"> Active </option>
                          <option value="0"> In Active </option>
                        </select>
			</div>
                        <a class="rt-text addPackage" data-id="" title="Add Spaday"><i class="fa fa-plus"></i> Add Spa day</a>
                    </div>
                        
                    <div class="vendor-service-content clearfix">
                     <?php echo $this->element('admin/Business/list_packages',array('packages'=>$packages)); ?>
                    </div>	
                
                </div>
		<div role="tabpanel" class="tab-pane" id="SPADays">...</div>
		<div role="tabpanel" class="tab-pane" id="Deals"></div>
		<div role="tabpanel" class="tab-pane" id="LMDeals"></div>
            </div>
	  
	  </div>
	</div>
  </div>
</div>
<script>function callfordatarepace(){
        var activeId = $(document).find('div.in').attr('id');
        var imageList = "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'spaday','admin'=>true))?>"
        $(document).find(".vendor-service-content").load(imageList, function() {
            
        });    
        
    }

 function deletePricingOption($smallmodal,val){
        var theId = val;
	if(confirm("Are you sure you want to delete this pricing option?")){
	    if(theId){
		$.ajax({
		    url: "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'delete_pricingoption','admin'=>true))?>"+'/'+'PackagePricingOption',
		    type:'POST',
		    data: {'id':theId}
		}).done(function(res) {
		  
		    if (onResponse($smallmodal, 'PackagePricingOption', res)){
					var res = jQuery.parseJSON(res);
					var packageId = $smallmodal.find('input#PackagePricingOptionPackageId').val();
					 //alert(packageId);
					 itsId = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'get_packagePricingTable' ,'admin'=>false)); ?>"; 
					 itsId = itsId+'/'+packageId;
					 $("#pricingOptionValues").load(itsId,function(){
					     //$("document").find('.add_pricingoption').bind('click');
					 });
				 }
		});
	    }
	}
    }
    function deleteCommon($modal,val,table,deleteType,del_type){
        var theId = val;
	
        if(theId){
            $.ajax({
                url: "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'delete','admin'=>true))?>"+"/"+table+"/"+del_type,
                type:'POST',
                data: {'id':theId,'type':deleteType}
            }).done(function(res) {
	        var res = jQuery.parseJSON(res);
		if(res.data=="success"){
		 callfordatarepace();   
		}else{
		     bootbox.alert(res.message);
		}
	    });
        }
    }
   
   $(document).ready(function(){
	
	$(document).on('click','button[data-dismiss="modal"]',function(){
	  $(this).closest('.modal').html(' ');
	});
	
	/***********Packages********/
       var packageModal = 'yes'; 
       var $packagemodal = $('#commonMediumModal');
       $(document).on('click','.addPackage',function(){
		var id = $(this).attr('data-id');
		if(!id){ id = 0; }
		var theservice = '<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'addedit_package','admin'=>true));?>'+'/'+id+'/Spaday';
		fetchstaticModal($packagemodal,theservice,'Package');
		packageModal = 'yes';
       });
       
	var $imagesmodal = $('#commonVendorModal');
	$packagemodal.on('click', '.addPkgImage', function(e){
	     if($packagemodal.find('.showServicesList').find('.col-sm-3').length >0){
		$packageId = $packagemodal.find('#PackageId').val();
		var theserviceIng = '<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'service_images','admin'=>true));?>'+'/'+$packageId+'/Package';
		fetchstaticModal($imagesmodal,theserviceIng);
	     }else{
		alert("Please add the treatments before selecting primary image");
	    }
	});
       
	$imagesmodal.on('click', '.addImage-to-sub',function(){
            var thObject = $(this);
            var imageName = thObject.closest('li').find('img').attr('data-img');
            if(imageName){
		var imgRgt =  $packagemodal.find('.pkg-img');
		imgRgt.find('dfn').remove();
		if(imgRgt.find('li:first').find('a.theChk').length > 0){
		    imgRgt.find('li:first').find('a.theChk').replaceWith('<img alt="" class="" src="/images/Service/150/'+imageName+'" data-img="'+imageName+'"><div class="extras"><div class="extras-inner"><a href="javascript:void(0);" class="addPkgImage"><i class="fa fa-pencil"></i></a></div></div>');
		}else{
		    imgRgt.find('li:first').find('img').replaceWith('<img alt="" class="" src="/images/Service/150/'+imageName+'" data-img="'+imageName+'"><div class="extras"><div class="extras-inner"><a href="javascript:void(0);" class="addPkgImage"><i class="fa fa-pencil"></i></a></div></div>');
		}
                imgRgt.find('li.empty:first').find('#PackageImage').val(imageName)
                $imagesmodal.modal('toggle');
	    }
            
        });
	
       	/*****Submit Form*********/
	$packagemodal.on('click', '.submitPackage', function(e){
	    var validatable = $("#Package").kendoValidator({ rules:{
					  minlength: function (input) {
						  return minLegthValidation(input);
					  },
					  maxlengthcustom: function (input) {
						  return maxLegthCustomValidation(input);
					  },
					  pattern: function (input) {
						  return patternValidation(input);
					  },
					  matchfullprice: function (input){
						  return comparefullsellprice(input,"SalonService");
					  },
					  greaterdate: function (input){
					      if (input.is("[data-greaterdate-msg]") && $.trim(input.val()) !== "") {                                    
						      var date = kendo.parseDate(input.val()),
							  otherDate = kendo.parseDate($("[name='" + input.data("greaterdateField") + "']").val());
						      return otherDate == null || otherDate.getTime() <= date.getTime();
						  }
						      return true;
					  }
				  },
				  errorTemplate: "<dfn class='text-danger'>#=message#</dfn>"}).data("kendoValidator");
	      var theSalonServiceBtn = $(this);
	      if(validatable.validate() == false){
		     var errorDiv = $("#Package").find('.k-invalid').first();
		     var scrollPos = errorDiv.offset().top;
		     $packagemodal.find('.scrollError').scrollTop(scrollPos);
		     errorDiv.trigger('focus');
		     //console.log(scrollPos);
	      }else{
	   
	    var options = {
                    success: function(res){
			if (onResponse($packagemodal, 'Package', res)){
			    callfordatarepace();
			}
                     }
             };
             $('#Package').submit(function() {
		    if(packageModal == 'yes'){
			  $(this).ajaxSubmit(options);
			  packageModal = 'no';
		    }
                     $(this).unbind('submit');
                     $(this).bind('submit');
                     return false;
             });
	      }
	});
	/********End***********/
			

	/*************Change Status********/
	$(document).on('click','.changestatus-package',function(){
	    var theObj = $(this);
            var theID = $(this).attr('data-id');
            var status = 1;
            var msgs = "Are you sure you want to activate the package ?";
            if($(this).hasClass('active')){
                status = 0;
                msgs = "Are you sure you want to deactivate the package ?";
            }
            
            if(confirm(msgs)){
            
                $.ajax({
                    url: "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'change_package_status','admin'=>true))?>",
                    type:'POST',
                    data: {'id':theID,'status':status}
                }).done(function(msg) {
                    if(msg == 1){
                        theObj.addClass('active').html('<i class="fa fa-check-square-o"></i>');
                    }else{
                        theObj.removeClass('active').html('<i class="fa fa-square-o"></i>');
                    }
                });
            } 
	});
	/********************End**********/
	
	/*************Filter***************/
	$(document).on('change','.package_filter',function(){
	    var obj = $(this);
	    var value = obj.val();
	    if(value == 1){
		 $(document).find('#accordion').find('.panel').each(function(){
		    if($(this).find(".changestatus-package").hasClass('active')){
			$(this).show();
		    }else{
			$(this).hide();
		    }
		 });
	    }else if(value == 0){
		$(document).find('#accordion').find('.panel').each(function(){
		    if(!$(this).find(".changestatus-package").hasClass('active')){
			$(this).show();
		    }else{
			$(this).hide();
		    }
		 });
	    }else{
		$(document).find('#accordion').find('.panel').each(function(){
		    $(this).show();
		});
	    }
	});
	/***************End****************/
	
	/**************Add Option**********/
	$packagemodal.on('click','.add_packagepricing',function(){
	    var packageId = $packagemodal.find('input#PackageId').val();
	    var optionCount = parseInt($(this).attr('data-id')) + 1;
	     var Data = $('#Package').find("input,select").serialize();
	        $.ajax({
			    url: "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'ajax_packageoption','admin'=>true))?>"+"/"+packageId,
			    type:'POST',
			    data:{'NewData':Data,'countOpt':optionCount},
			    success:function(res){
				   //console.log(res);
				   $("#pricingOptionTablePackage").html(res);
				 }
			    
		       });
	   // alert(optionCount);
	    //var pricingOptionUrl = '<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'ajax_packageoption','admin'=>true));?>'+'/'+packageId+'/'+optionCount;
	    //$("#pricingOptionTablePackage").load(pricingOptionUrl,function(){
	    //
	    //});
	})
	
	/****************End***************/
	
	/*****Delete Package******/
	    $(document).on('click','.delete-package',function(){
		var value = $(this).attr('data-id');
		var modal = "$(document)";
		if(confirm('Are you sure you want to delete this package ?')){
		    deleteCommon(modal,value,'Package','temp','Spaday');
		}
	    });
	    $(document).on('click','.delete-package-service',function(){
		var value = $(this).attr('data-id');
		var modal = "$(document)";
		if(confirm('Are you sure you want to delete this package?')){
		    deleteCommon(modal,value,'PackageService','permanent','service');
		}
	    });
	    
	/********End********/
	
       var $treatmentsmodal = $('#commonVendorModal');
       $packagemodal.on('click','.addTreatments',function(){
	    var packageId = $packagemodal.find('input#PackageId').val();
	    var theservice = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'selectpackage_service','admin'=>true));?>'+'/'+packageId;
	    fetchstaticModal($treatmentsmodal,theservice);      
       })

      $treatmentsmodal.on('click','.packageService',function(){
	
	  var options = { 
			    success:function(res){
			     
				if(onResponse($treatmentsmodal,'PackageService',res)){
				var selected = [];
				var content ='';
				    $treatmentsmodal.find('input:checked').each(function() {
					var text = $(this).next().html();
					 content+= '<div class="col-sm-3 lft-p-non"><i class="fa fa-check"></i>'+text+'</div>';
					
				    });
				    $packagemodal.find('.addTreatmentLink').hide();
				    $packagemodal.find('.editTreatmentsLink').show();
				    $packagemodal.find('.showServicesList').show().children().html(content);
				    var packageId = $packagemodal.find('input#PackageId').val();
				    var count = $packagemodal.find('.add_packagepricing').attr('data-id');
				    var optionCount = 1;
				    if(count){
					optionCount = parseInt(count);
				    }
				    var pricingOptionUrl = '<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'ajax_packageoption','admin'=>true));?>'+'/'+packageId+'/'+optionCount+'/'+'service';
				    $("#pricingOptionTablePackage").load(pricingOptionUrl,function(){
						
					});	
				 }
			    }
	       }; 
	       $treatmentsmodal.find("#packageserviceSelectForm").submit(function(){
			       $(this).ajaxSubmit(options);
			       $(this).unbind('submit');
			       $(this).bind('submit');
			       return false;
	       });
      })
	/**********End************/
	/**************Delete Package Option*********/
	$packagemodal.on('click',".delete-package-option",function(){
	    var optionId = $(this).attr('data-id');
	    var packageId = $packagemodal.find('input#PackageId').val();
	    
	    if(confirm("Are you sure you want to delete this pricing option?")){
	        $.ajax({
			    url: "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'delete_packagepricingoption','admin'=>true))?>"+"/"+packageId,
			    type:'POST',
			    data:{'option_id':optionId},
			    success:function(res){
				    //var res = jQuery.parseJSON(res);
				    //console.log(res);
				    if(res=='success'){
				    var pricingOptionUrl = '<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'ajax_packageoption','admin'=>true));?>'+'/'+packageId+'/'+'null'+'/option';
					$("#pricingOptionTablePackage").load(pricingOptionUrl,function(){
						
					});
				    }else{
					  alert('There was some error in deleting.');
				    }
				 }
			    
		       });
	    }
	});
	
	/***********************End*****************/
	
	var $smallmodal = $('#commonVendorModal');
	$packagemodal.on('click','.add_anotherpricing' ,function(){
	   var packageId = $packagemodal.find('input#PackageId').val();
	  alert($packagemodal.find('#pricingOptionValues').find('table tbody tr').length);
	   if($packagemodal.find('#pricingOptionValues').find('table tbody tr').length == 0){
	     // $( "#ServicePricingOptionFullPrice" ).rules( "remove" );
	  
	    $packagemodal.find("#Package").validate(	
            {
	     // $("#ServicePricingOptionFullPrice").rules("remove");
                onkeyup: function (element, event)
                    {
                        this.element(element);
                    },
                errorElement: "span",
                rules: {
                            "data[ServicePricingOption][sell_price]":{
                                required: true
                            },
			    "data[ServicePricingOption][custom_title]":{
                                required: true
                            },
                        },
                messages: {
                        "data[ServicePricingOption][sell_price]": {
                        required: "<?php echo __('Price field is required!'); ?>",                   
                    },
		    "data[ServicePricingOption][custom_title]": {
                        required: "<?php echo __('Custom Title field is required!'); ?>",                   
                    },
                }
            });
	   
	    if($packagemodal.find('#Package').valid()){
	
			   
			    var pricingId =  $("#PackagePricingOptionPricingLevelId").val();
			    var duration = $("#PackagePricingOptionDuration").val();
			    var title = $("#PackagePricingOptionCustomTitle").val();
			    var fullPrice =  $("#PackagePricingOptionFullPrice").val();
			    var sellPrice =  $("#PackagePricingOptionSellPrice").val();
			    var pointGiven =  $("#PackagePricingOptionPointsGiven").val();
			    var pointRedeem= $("#PackagePricingOptionPointsRedeem").val();
			    var optionId= $("#PackagePricingOptionId").val();
			   
			     $.ajax({
			      url: "<?php echo $this->Html->url(array('controller'=>'salon_services','action'=>'add_packagepricingoption','admin'=>true))?>"+"/"+packageId,
			      type:'POST',
			      data:{'pricing_level_id':pricingId,'duration':duration,'custom_title':title,'full_price':fullPrice,'sell_price':sellPrice,'points_given':pointGiven,'points_redeem':pointRedeem,'package_id':packageId,'id':optionId},
			      success:function(res){
				   var res = jQuery.parseJSON(res);
			       if(res.data=='success'){
				     $("#PackagePricingOptionId").val(res.id);
				     var addeditURL = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'add_packagepricingoption','admin'=>true)); ?>";
				      addeditURL = addeditURL+'/'+packageId;
				      fetchModal($smallmodal,addeditURL);
			       }else{
				      alert('There was some error in saving data.');
			       }
			      }
			     })
		
                
            }
	    
	    
	   }else{
		var addeditURL = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'add_packagepricingoption','admin'=>true)); ?>";
				      addeditURL = addeditURL+'/'+packageId;
				      fetchModal($smallmodal,addeditURL);
	   }
        });
        
        
	/***** Add Services****/
	
	
	
	var $newServiceType = $('#commonContainerModal');
        $(document).find('.addServiceType').on('click',function(){
	     var theservice = '<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'select_service_type','admin'=>true));?>';
	      fetchstaticModal($newServiceType,theservice);
	});
	
	var $newService = $('#commonContainerModal');
	$newServiceType.on('click','.addService',function(){
        var theservice = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'select_service','admin'=>true));?>'+'/addnew';
	fetchstaticModal($newService,theservice);
	});
	
	
	
	//$selectService
			$newService.on('click', '.submitSelectForm', function(e){
			
	       var options = { 
			       success:function(res){
					       if(onResponse($newService,'Service',res)){
						// callfordatarepace();
							       //$.ajax({url:updateURL,type:'POST',data: {update:updateVal} });	
					       }
			       }
	       }; 
	       $newService.find("#serviceSelectForm").submit(function(){
			       $(this).ajaxSubmit(options);
			       $(this).unbind('submit');
			       $(this).bind('submit');
			       return false;
	       });
});
	
	
	/************End******/
	
	
        
        
    /****************pricing level *********************/
	var $bigmodal = $('#commonContainerModal');
	$(document).on('click','.add_pricing_level' ,function(){
		var addeditURL = "<?php echo $this->Html->url(array('controller'=>'PricingLevel','action'=>'add','admin'=>TRUE)); ?>";
		fetchModal($bigmodal,addeditURL);
	});
	
	 var $bigmodal = $('#commonContainerModal');
	 $bigmodal.on('click', '.update', function(e){
		var options = {
			//beforeSubmit:  showRequest,  // pre-submit callback 
			success: function(res){
				if (onResponse($bigmodal, 'PricingLevel', res)){
					var res = jQuery.parseJSON(res);
					itsId = "<?php echo $this->Html->url(array('controller'=>'PricingLevel','action'=>'priceDropDown' ,'admin'=>TRUE)); ?>"; 
					itsId = itsId+'/'+res.price_id;
					$(".price_level_drop_down").load(itsId,function(){
						
					});
				}
			}
		};
		$('#PricingLevelAdminAddForm').submit(function() {
			$(this).ajaxSubmit(options);
			$(this).unbind('submit');
			$(this).bind('submit');
			return false;
		});
		
	});
	 
	/****************pricing level ends here*********************/
	
	// var $priceOptmodal = $('#commonVendorModal');
	$smallmodal.on('click', '.submitPricingOption', function(e){
            var options = {
                     //beforeSubmit:  showRequest,  // pre-submit callback 
                     success: function(res){
			    
                         if (onResponse($smallmodal, 'PackagePricingOption', res)){
				     var res = jQuery.parseJSON(res);
                                     var packageId = $packagemodal.find('input#PackageId').val();
				    
				     itsId = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'get_packagePricingTable' ,'admin'=>false)); ?>"; 
                                     itsId = itsId+'/'+packageId;
                                     $("#pricingOptionValues").load(itsId,function(){
                                         //$("document").find('.add_pricingoption').bind('click');
                                     });
                             }
                     }
             };
             $('#PackagePricingOptionAdminAddPackagepricingoptionForm').submit(function() {
                     $(this).ajaxSubmit(options);
                     $(this).unbind('submit');
                     $(this).bind('submit');
                     return false;
             });
		
	});
        
        $packagemodal.on('click','#pricingOptionValues table tr',function(){
              var theRowId = $(this).attr('data-id');
              var packageId = $packagemodal.find('input#PackageId').val();
              var addeditURL = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'add_packagepricingoption','admin'=>true)); ?>";
              addeditURL = addeditURL+'/'+packageId+'/'+theRowId;
              fetchModal($smallmodal,addeditURL);
        });
        
	
        $packagemodal.on('click','#PackageInventory',function(){
	        if($(this).is(':checked')){
                    $('.stockQuantity').show();
		}else{
                    $('.stockQuantity').hide();
		}
		
	});
        
	/*********Delete Pricng Option********/
	
	$smallmodal.on('click','.del-option',function(){
	    var val = $smallmodal.find('#PackagePricingOptionId').val();
            if(confirm('Are you sure you want to delete this pricing option ?')){
                //check if Associated
                deletePricingOption($smallmodal,val);
            }
        });
	
	/*********Delete Pricng Option********/
	
	
	/*********Package Deal ********/
	var $dealmodal = $('#commonContainerModal');
	var dealsubmit = 'yes';
	deal_count = parseInt('<?php echo $dealCount ?>');
	$packagemodal.on('click','.create_pkgdeal',function(){
	      if(checkDealLimit(deal_count)){
		var pkgId = $packagemodal.find('#PackageId').val();
		var pkgdeal = '<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'create_servicedeal','admin'=>true));?>'+'/'+pkgId+'/Spaday/0';
		fetchstaticModal($dealmodal,pkgdeal,'DealcreateForm');
		//fetchstaticModal($dealmodal,servicedeal);
		dealsubmit = 'yes';
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
		theHTML = '<div class="chkblkD"><div class="date mrgn-rgt10 w60 mrgn-btm10"><input name="data[DealDetail][blackout_dates]['+theIdNo+']" data-rel="'+theIdNo+'" class="form-control selBlkOutDates" id="DealBlackoutDates'+theIdNo+'" type="text"></div><div class="lft-p-non col-sm-4"><a href="javascript:void(0);" class="removeblkdate"><i class="fa fa-trash-o"></i></a></div></div>';
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
	
	$dealmodal.on('click', '.submitThepkg', function(e){
	    var dealbtnObj = $(this);
	    buttonLoading(dealbtnObj);
            var options = {
                success: function(res){
		    buttonSave(dealbtnObj);
		    dealsubmit = 'yes';
                    if (onResponse($dealmodal, 'Deal', res)){
			window.location.href = '<?php echo $this->Html->url(array('controller'=>'Business','action'=>'deals','admin'=>true))?>';   
                    }
                },
             };
	    if(!dealbtnObj.hasClass('rqt_already_sent')){
		$('#DealcreateForm').submit(function() {
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
	$dealmodal.on('click', '.addDealImage', function(e){
	    var ServiceId = $dealmodal.find('#DealcreateForm').find('#DealPackageId').val();
	    var theserviceImgs = '<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'service_images','admin'=>true));?>'+'/'+ServiceId+'/Package';
	    fetchstaticModal($forDealAddingImagemodal,theserviceImgs);
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
            
        });
	
	/*********Package Deal Ends ********/
	
	
	
	/**************Custom Title Edit**********/
	
	$packagemodal.on('click','.customTitle',function(){
	    var title = $(this).html();
	    var uniqueId = $(this).attr('id');
	    var addeditURL = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'ajax_customtitle','admin'=>true)); ?>";
		addeditURL = addeditURL+'/'+uniqueId;
		fetchModal($smallmodal,addeditURL);
	})
	
	$smallmodal.on('click','.submitCustomTitle',function(){
	     var engTitle = $("#editTitleEng").val();
	     var araTitle = $("#editTitleAra").val();
	     var id = $smallmodal.find('#customId').val();
	      $('#Package').find('#'+id).html(engTitle);
	      $('#Package').find('.customTitleEng'+id).val(engTitle);
	      $('#Package').find('.customTitleAra'+id).val(araTitle);
	      $smallmodal.modal('toggle')
	})
	
	/********************End*****************/

      	
	
	$(".datepicker").datepicker();
	
	
    });
</script>