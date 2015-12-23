<?php //echo $this->Html->css('admin/nestable')?>
<?php echo $this->Html->script('bootbox.js');?>
<style>
    #services-accordion div.place-holder {
        border: 1px dashed #CCC; margin-top: 5px;
        min-height: 55px !important;
    }
    div.treat-holder{
        border: 1px dashed #CCC;
        min-height: 245px;
    }
    
 
    .bootbox-body{
        font-size:large;
        margin:15px;
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
		<div role="tabpanel" class="tab-pane active" id="SERVICES">
		    <div class="vendor-deal-head">
                        <?php echo $this->Form->hidden('forcheckCat',array('label'=>false,'div'=>false,'id'=>'forcheckCat'))?>
                        <div class="col-sm-3 col-xs-5 nopadding">
                        
			<select id="forService" class="form-control">
                          <option value="2">All Services</option>
                          <option value="1"> Active </option>
                          <option value="0"> Inactive </option>
                        </select>
                        </div>
			<div class="pull-right col-sm-6 nopadding">
			    <div class="col-sm-5 nopadding pull-right">
				<a class="rt-text addServiceType"><i class="fa fa-plus"></i> Siesata Service</a>
			    </div>
			    <div class="col-sm-6 nopadding pull-right">
				<a class="rt-text change-name"><i class="fa fa-plus"></i> Non-Sieasta Category</a>
			    </div>
			</div>
                    </div>
                
                    <div class="vendor-service-content clearfix">
                        <?php echo $this->element('admin/Business/list_service',array('services'=>$services)); ?>
                    </div>	
		</div>
	  </div>
	  
	  </div>
	</div>
  </div>
</div>
<script>

    function callfordatarepace(){
        var activeId = $(document).find('div.in').attr('id');
        var imageList = "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'services','admin'=>true))?>"
        imageList = imageList+'/'+activeId;
        $(document).find(".vendor-service-content").load(imageList, function() { });    
    }


    function updateCat(){
        var myArray = {};
        if($(document).find('div.panel-group > div.panel').length > 0){
            $(document).find('div.panel-group > div.panel').each(function(val,obj){
                var parentObj = $(this);
                var parentid = parentObj.attr('data-id');
                myArray[val] = parentid;
            });
        }
        updateOrder(myArray);
    }
    function updatetreat(){
        var myArray = {};
        var theatr = $(document).find('div.panel-group div.panel-active div.panel-body div.treat-list > div.v-deal');
        if(theatr.length > 0){
            theatr.each(function(val,obj){
                var parentObj = $(this);
                var parentid = parentObj.attr('data-id');
                myArray[val] = parentid;
            });
        }
        updateOrder(myArray);
    }
    var currentRequest = null;
    function updateOrder(myArray){
        if(myArray){
            if (window.JSON) {
                currentRequest = $.ajax({
                    url: "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'service_order','admin'=>true))?>",
                    beforeSend: function() {
                        if(currentRequest != null) {
                            currentRequest.abort();
                        }    
                    },
                    type:'POST',
                    data: {serviceOrder:JSON.stringify(myArray)}
                }).done(function(msg) {

                });
            } else {
                output.val('JSON browser support required for this demo.');
            }
        }
    }
    function callTreatsortable(){
        $(document).find(".treat-list").sortable({
            placeholder:    'v-deal treat-holder',
            stop:function(event,ui){
                updatetreat();
            }
        });    
    }
    function callCatsortable(){
        $(document).find(".panel-group").sortable({
            placeholder:    'place-holder',
            start:function(event,ui){
                if($(this).find('div.panel-active').find('.panel-collapse').hasClass('in')){
                    $(this).find('div.panel-active').find('.panel-collapse').removeClass('in');
                    $(document).find('#forcheckCat').val(1);
                }
		$(this).find('div.panel').css('height','51px');
            },
            stop:function(event,ui){
                var chkV = $(document).find('#forcheckCat').val();
                if(chkV == 1){
                    $(this).find('div.panel-active').find('.panel-collapse').addClass('in');
                    $(document).find('#forcheckCat').val('');
                }
                $(this).find('div.panel').removeAttr('style');
		updateCat();
            }
        });    
    }
    function deleteService(Obj,type){
        var theId = Obj.attr('data-id');
        if(theId){
            $.ajax({
                url: "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'isdelete','admin'=>true))?>",
                type:'POST',
                data: {'id':theId,'type':type}
            }).done(function(msg) {
                msg = $.trim(msg);
	       if(msg == 'success'){
                    if(type == 'service'){
                        Obj.closest('div.panel').remove();
			ser_total = parseInt($('.service_count').text()-1);
                        $('.service_count').text(ser_total);
                        //callfordatarepace();
                    }
                    else{
                        Obj.closest('div.v-deal').remove();
                    }
               }else if(msg == 'appointment_exist'){
		     if(type == 'treatment'){
			bootbox.alert('Please complete/cancel the appointment for this service.');    
		     }else{
			bootbox.alert('One of the service has appointment . Please complete/cancel the appointment.');        
		     }
               }
	       else if(msg == 'package_exist'){
		      if(type == 'treatment'){
			bootbox.alert('You cannot delete this service as it is included in package.First remove it from package then delete. ');
		      }else{
			bootbox.alert('You cannot delete this treatment as one of the service is included in package.First remove it from package then delete. ');        
		      }
               } else if(msg == 'spaday_exist'){
		      if(type == 'treatment'){
			bootbox.alert('You cannot delete this service as it is included in spaday.First remove it from spaday then delete. ');
		      }else{
			bootbox.alert('You cannot delete this treatment as one of the service is included in spaday.First remove it from spaday then delete. ');        
		      }
               }else if(msg == 'deal_exist'){
		      if(type == 'treatment'){
			bootbox.alert('You cannot delete this service as it is included in deal.First remove it from deal then delete. ');
		      }else{
			bootbox.alert('You cannot delete this treatment as one of the service is included in deal.First remove it from deal then delete. ');        
		      }
               }else if(msg == 'unable_to_delete'){
		     bootbox.alert('Unable to delete!!! Try again');
	       }
            });
        }
    }
    function deletePricingOption($smallmodal,val){
        var theId = val;
	 if(theId){
            $.ajax({
                url: "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'delete_pricingoption','admin'=>true))?>",
                type:'POST',
                data: {'id':theId}
            }).done(function(res) {
	      
                if (onResponse($smallmodal, 'ServicePricingOption', res)){
				     var res = jQuery.parseJSON(res);
                                     var serviceId = $smallmodal.find('input.salon_service_id').val();
				     //alert(serviceId);
				     itsId = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'get_pricingTable' ,'admin'=>false)); ?>"; 
                                     itsId = itsId+'/'+serviceId;
                                     $("#pricingOptionValues").load(itsId);
				     	     var staffList = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'ajax_staff_list','admin'=>true))?>"+'/'+serviceId;
				   $("#commonSmallModal").find(".serviceProviderList").load(staffList); 
                             }
            });
        }
    }
    
    $(document).ready(function(){
       
       $(document).on('click','button[data-dismiss="modal"]',function(){
	  $(this).closest('.modal').html(' ');
	});
       
	$(document).on('change','#forService',function(){
            var treatf = $(this);
	   var theVal = treatf.val();
	   $(document).find('#services-accordion').find('.panel').show();
	    if(theVal == 0 ){
                $(document).find('#services-accordion').find('.panel').each(function(){
		    $(this).find('.panel-body').find('.v-deal').each(function(){
		       if($(this).find('.active-deactive').hasClass('active')){
			    $(this).hide('slow');
			    $(this).removeClass('Active');
			}else{
                        $(this).show('slow');
			$(this).addClass('Active');
		     }
		    });
                });
		  $(document).find('#services-accordion').find('.panel').each(function(){
	      //alert($(this).find('.panel-body').find('.v-deal').hasClass('Active').length);
	      var removeParent = true;
	      if($(this).find('.panel-body').find('.v-deal').hasClass('Active')){
		   removeParent = false; 	     
	      }
	      if(removeParent == true){
		   $(this).hide('slow');  
	      }
	      
	      })
            }
            else if(theVal == 1 ){
                $(document).find('#services-accordion').find('.panel').each(function(){
		    $(this).find('.panel-body').find('.v-deal').each(function(){
		       if($(this).find('.active-deactive').hasClass('active')){
			    $(this).show('slow');
			    $(this).addClass('Active');
			}else{
                        $(this).hide('slow');
			$(this).removeClass('Active');
                    }
		    });
                });
		  $(document).find('#services-accordion').find('.panel').each(function(){
	      //alert($(this).find('.panel-body').find('.v-deal').hasClass('Active').length);
	      var removeParent = true;
	      if($(this).find('.panel-body').find('.v-deal').hasClass('Active')){
		   removeParent = false; 	     
	      }
	      if(removeParent == true){
		   $(this).hide('slow');  
	      }
	      
	      })
            }
            else{
	         $(document).find('#services-accordion').find('.panel').each(function(){
		    $(this).find('.panel-body').find('.v-deal').each(function(){
		      $(this).show('slow');
		      $(this).addClass('Active');
		    });
                });
            }
	    
        });
	
       
        
        $(document).on('click','.forcheck',function(){
            var caObbj  = $(this);
            if(!caObbj.hasClass('collapsed')){
                caObbj.closest('div.panel-group').find('.panel').removeClass('panel-active');
                caObbj.closest('div.panel').addClass('panel-active');
            }
        });
        
        $(document).on('click','.active-deactive',function(){
            var theObj = $(this);
            var theID = $(this).attr('data-id');
            var status = 1;
            var msgs = "Are you sure you want to activate the treatment ?";
            if($(this).hasClass('active')){
                status = 0;
                msgs = "Are you sure you want to deactivate the treatment ?";
            }
            
            if(confirm(msgs)){
            
                $.ajax({
                    url: "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'change_status','admin'=>true))?>",
                    type:'POST',
                    data: {'id':theID,'status':status}
                }).done(function(msg) {
                    if(msg == 1){
                        theObj.closest('div.bottom').removeClass('dull');
                        theObj.closest('div.v-deal-box').find('span.status').remove();
                        theObj.addClass('active').text('Deactivate');
                    }
                    else if(msg == 'price_not_set'){
			    alert('Please set the price first.');
		    }else if(msg == 'image_not_set'){
			    alert('Please set the image first.');
		    }else if(msg == 'detail_not_set'){
			    alert('Please fill all the required fields.');
		    }else{
                        theObj.removeClass('active').text('Activate');
                        theObj.closest('div.bottom').addClass('dull');
                        theObj.closest('div.v-deal-box').find('div.upper').append('<span class="status">Activate Service</span>');
                    }
                });
            }
        });
        
        $(document).on('click','.del-service',function(){
            var OBJ = $(this)
            if(confirm('Are you sure you want to delete service ?')){
                //check if Associated
                deleteService(OBJ,'service');
            }
        });
        $(document).on('click','.deleteTreat',function(){
            var OBJ = $(this)
            if(confirm('Are you sure you want to delete the treatment ?')){
                //check if Associated
                deleteService(OBJ,'treatment');
            }
        });
        var $forThemodal = $('#commonSmallModal');
	var serviceDisplay = 'yes';
        $(document).on('click','.change-name',function(){
	    var theId = $(this).attr('data-id');
            var addServiceURL = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'edit_service','admin'=>true)); ?>";
            if(theId){
		    fetchModal($forThemodal,addServiceURL+'/'+theId,'SalonServiceNameForm');
            }else{
		if(confirm("Custom Categories are not searchable and recommended, please use Sieasta Services.Only use them if you do not find a matching service in Sieasta Services.Do you still want to continue ?")){
		    fetchModal($forThemodal,addServiceURL,'SalonServiceNameForm');    
		}
            }
	    serviceDisplay = 'yes';
        });
        
        $forThemodal.on('click', '.submitThe', function(e){
            var options = { 
                success:function(res){
                    if(onResponse($forThemodal,'SalonService',res)){
                        ser_total = parseInt($('.service_count').text());
                        ser_total = ser_total+1;
                        $('.service_count').text(ser_total);
                        var dataURL = '<?php echo $this->Html->url(array("controller"=>"SalonServices","action"=>"services","admin"=>true)); ?>';
                        var activeId = $(document).find('#services-accordion div.panel-active').attr('data-id');
                        $(document).find(".vendor-service-content").load(dataURL,function(){
                            callCatsortable();
                            callTreatsortable();
                            $(document).find('#services-accordion').find('div.panel').each(function(){
                                if($(this).attr('data-id') == activeId){
                                    $(this).addClass('panel-active');
                                    $(this).find('a.forcheck').removeClass('collapsed');
                                    $(this).find('div.panel-collapse').addClass('in');
                                }
                                else{
                                    $(this).removeClass('panel-active');
                                    $(this).find('a.forcheck').addClass('collapsed');
                                    $(this).find('div.panel-collapse').removeClass('in');
                                }
                            });
                                        //$(document).find('ul.tagBlock').find('li[data-id='+activeId+']').addClass('active');
                        });    
                    }
                }
            }; 
            $('#SalonServiceNameForm').submit(function(){
		     if(serviceDisplay == 'yes'){
		      $(this).ajaxSubmit(options);
		     }
		     serviceDisplay = 'no';
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
        
        var $forTreatModal = $('#commonSmallModal');
        $forTreatModal.on('click','.del-cat-pic',function(){
            var tObj = $(this);
            if(confirm('Are you sure you want to delete the image ?')){
                tObj.closest('ul').append('<li class="lightgrey empty"><a class="addImage" href="javascript:void(0);"><span><i class="fa fa-plus"></i></span></a><input type="hidden" id="ServiceServiceimage" class="serviceImg" name="data[Service][serviceimage][]"></li>');
                tObj.closest('li.theImgH').remove();
                
            }
        });
	
        $forAddingImagemodal = 	 $('#commonVendorModal'); 
        $forTreatModal.on('click','.addImage',function(){
             var ServiceParentId = $forTreatModal.find('#SalonService').find('#ServiceParentId').val();
	     var SalonServiceParentId = $forTreatModal.find('#SalonService').find('#SalonServiceParentId').val();
	     var SalonServiceServiceId = $forTreatModal.find('#SalonService').find('#SalonServiceServiceId').val();
             var addiURL = "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'service_gallery','admin'=>true)); ?>";
             fetchModal($forAddingImagemodal,addiURL+'/'+ServiceParentId+'/'+SalonServiceParentId+'/'+'SalonService'+'/Null/'+SalonServiceServiceId);
             
        });
        $forAddingImagemodal.on('click','.toUploadImage',function(){
            $forAddingImagemodal.find('#guploadImageForm #ServiceUpimage').click();
        });
        
        $forAddingImagemodal.on('change', '#ServiceUpimage', function(e){
            file = this.files[0];
            var obj = $(this);
            var valReturn = validate_image(file);
            if(valReturn){
                obj.val('');
                alert(valReturn);
            }
            else{
                var reader = new FileReader();
                var image = new Image();
                reader.readAsDataURL(file);  
                reader.onload = function(_file) {
                    image.src    = _file.target.result;              // url.createObjectURL(file);
                    image.onload = function() {
                        var w = this.width,
                            h = this.height,
                            t = file.type,                           // ext only: // file.type.split('/')[1],
                            n = file.name,
                            s = ~~(file.size/1024) +'KB';
			    var kbs = ~~(file.size/1024);
			    var resize = '';
			    var thecheckimage = checkimagedata(parseInt(w),parseInt(h),kbs);
			    if(thecheckimage == 'resize'){
				resize = '1';
				thecheckimage = 'success';
			    }
			    if(thecheckimage == 'success'){
                                var formdata = new FormData();
                                formdata.append('image', file);
                                obj.prev().val('');
                                var salonserviceparentId = $forAddingImagemodal.find('#ServiceId').val();
                                var serviceParentId = $forAddingImagemodal.find('#ServiceParentId').val();
                                if(!salonserviceparentId)
                                    salonserviceparentId = 0;
                                if(!serviceParentId)
                                    serviceParentId = 0;
                                formdata.append('serviceId', '');
                                formdata.append('parent_id', salonserviceparentId);
                                $.ajax({
                                    url: "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'service_gallery','admin'=>true))?>"+"/"+serviceParentId+"/"+salonserviceparentId+"/"+"SalonService"+"/"+resize,
                                    type: "POST",
                                    data: formdata,
                                    processData: false,
                                    contentType: false,
                                    success: function(res) {
					//alert(res);
                                        if (res != 'f') {
					   var pareseObj = $.parseJSON(res);
                                            var imgRgt =  $forTreatModal.find('.image-box');
                                            imgRgt.find('ul').find('li').removeAttr('style');
                                            imgRgt.find('ul').find('dfn').remove();
                                            imgRgt.find('ul').find('li.empty:first').find('a').replaceWith('<img alt="" class="" src="/images/Service/150/'+pareseObj.image+'" data-img="'+pareseObj.image+'"><div class="extras"><div class="extras-inner"><a href="javascript:void(0);" class="del-cat-pic"><i class="fa fa-times"></i></a></div></div>');
                                            imgRgt.find('ul').find('li.empty:first').find('.serviceImg').val(pareseObj.image)
					    imgRgt.find('ul').find('li.empty:first').removeClass('empty').addClass('theImgH');
                                            $forAddingImagemodal.modal('toggle');

                                        }else{
                                            alert('Error in uploading image. Please try again!');
                                        }
                                    }
                                });

                            }else{
				if(thecheckimage == 'size-error'){
				    alert('Images should be upto 100 Kb in size.In case you would like us to resize and compress image please send it support@sieasta.com');

				}else if(thecheckimage == 'limit-error'){
				    alert('Images should be landscape (wide, not tall) and minimum width of 800 pixels and height of 400 pixels are required.In case you would like us to resize and compress image please send it support@sieasta.com');

				}else if(thecheckimage == 'resize-error'){
				    alert('Images should be in the ratio of 2:1.In case you would like us to resize and compress image please send it support@sieasta.com');

				}
                            }
                        };
                    image.onerror= function() {
                        alert('Invalid file type: '+ file.type);
                    };      
                };
            }
        });
        
    
	
        $forAddingImagemodal.on('click', '.addImage-to-sub',function(){
            var thObject = $(this);
            var imageName = thObject.closest('li').find('img').attr('data-img');
	    var serviceId = $forTreatModal.find('.salon_service_id').val();
            var salonserviceparentId = $forAddingImagemodal.find('#guploadImageForm').find('#ServiceId').val();
            var serviceParentId = $forAddingImagemodal.find('#guploadImageForm').find('#ServiceParentId').val();
           // alert(serviceId);
	    if(!serviceId){
                serviceId = 0;
            }
            
            $.ajax({
                url: "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'add_image_sub','admin'=>true))?>"+"/SalonService",
                type: "POST",
                data: {id:serviceId,imageName:imageName,parent_id:serviceParentId},
                success: function(res) {
                    if(res != 'f'){
                        var imgRgt =  $forTreatModal.find('.image-box');
			imgRgt.find('ul').find('li').removeAttr('style');
			imgRgt.find('ul').find('dfn').remove();
			imgRgt.find('ul').find('li.empty:first').find('a').replaceWith('<img alt="" class="" src="/images/Service/150/'+res+'" data-img="'+res+'"><div class="extras"><div class="extras-inner"><a href="javascript:void(0);" class="del-cat-pic"><i class="fa fa-times"></i></a></div></div>');
                        imgRgt.find('ul').find('li.empty:first').find('.serviceImg').val(res)
                        imgRgt.find('ul').find('li.empty:first').removeClass('empty').addClass('theImgH');
                        $forAddingImagemodal.modal('toggle');
                    }else{
                        alert('Error in adding image. Please try again!');
                    }
                    //$('body').modalmanager('loading');
                }
            });
            
            
        });
        
	callCatsortable();
        callTreatsortable();
	
	var $smallmodal = $('#commonVendorModal');
        var priceoption = 'yes';
	var priceanotheroption = 'yes';
	$forTreatModal.on('click','.add_anotherpricing' ,function(){
           var serviceId = $forTreatModal.find('.salon_service_id:first').val();
	  if(!$forTreatModal.find('#ServicePricingOptionId').val()){
	   //alert('here');
	     // $( "#ServicePricingOptionFullPrice" ).rules( "remove" );
		     $("#ServicePricingOptionFullPrice").trigger('blur');
		     $("#ServicePricingOptionCustomTitleEng").trigger('blur');
		     $("#ServicePricingOptionDuration").trigger('blur');
		     $("#level").trigger('blur');
		     
		     if($forTreatModal.find('#pricingOptionValues').find('.k-invalid-msg').filter(":visible").length==0)
		    {
			    var pricingId =  $forTreatModal.find("#ServicePricingOptionPricingLevelId").val();
			    var duration = $forTreatModal.find("#ServicePricingOptionDuration").val();
			    var titleeng = $forTreatModal.find("#ServicePricingOptionCustomTitleEng").val();
			    var titleara = $forTreatModal.find("#ServicePricingOptionCustomTitleAra").val();
			    var fullPrice =  $forTreatModal.find("#ServicePricingOptionFullPrice").val();
			    var sellPrice =  $forTreatModal.find("#ServicePricingOptionSellPrice").val();
			    var pointGiven =  $forTreatModal.find("#ServicePricingOptionPointsGiven").val();
			    var pointRedeem= $forTreatModal.find("#ServicePricingOptionPointsRedeem").val();
			    var optionId= $forTreatModal.find("#ServicePricingOptionId").val();
			  if($forTreatModal.find("#pricingOptionValues table tbody tr").length === 0)
			  {
			  
		     $.ajax({
			      url: "<?php echo $this->Html->url(array('controller'=>'salon_services','action'=>'add_pricingoption','admin'=>true))?>"+"/"+serviceId,
			      type:'POST',
			      data:{'pricing_level_id':pricingId,'duration':duration,'custom_title_eng':titleeng,'custom_title_ara':titleara,'full_price':fullPrice,'sell_price':sellPrice,'points_given':pointGiven,'points_redeem':pointRedeem,'salon_service_id':serviceId,'id':optionId},
			      success:function(res){
				   var res = jQuery.parseJSON(res);
			       if(res.data=='success'){
				    $("#ServicePricingOptionId").val(res.id);
				     var addeditURL = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'add_pricingoption','admin'=>true)); ?>";
				      addeditURL = addeditURL+'/'+serviceId;
				      priceoption = 'yes';
				      fetchModal($smallmodal,addeditURL,'ServicePricingOptionAdminAddPricingoptionForm');
				      priceoption = 'yes';
				     
			       }else{
				      alert('Please check whether you have entered full price and title');
			       }
			      }
			     });
			  }else{
			    var addeditURL = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'add_pricingoption','admin'=>true)); ?>";
				      addeditURL = addeditURL+'/'+serviceId;
				      priceoption = 'yes';
				      fetchModal($smallmodal,addeditURL,'ServicePricingOptionAdminAddPricingoptionForm');
			  }
		    }else{
		   
		    }
		 }else{
		   
		var addeditURL = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'add_pricingoption','admin'=>true)); ?>";
				      addeditURL = addeditURL+'/'+serviceId;
				      fetchModal($smallmodal,addeditURL,'ServicePricingOptionAdminAddPricingoptionForm');
				      priceoption = 'yes';
	   }
	   
        });
        
        
	
	
        var $priceOptmodal = $('#commonVendorModal');
	$smallmodal.on('click', '.submitPricingOption', function(e){
	        var  pricingOptionBtn = $(this);
		     buttonLoading(pricingOptionBtn);
            var options = {
                     //beforeSubmit:  showRequest,  // pre-submit callback 
                     success: function(res){
			    buttonSave(pricingOptionBtn);
                         if (onResponse($smallmodal, 'ServicePricingOption', res)){
			    
				     var res = jQuery.parseJSON(res);
                                     var serviceId = $smallmodal.find('input.salon_service_id').val();
				     itsId = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'get_pricingTable' ,'admin'=>false)); ?>"; 
                                     itsId = itsId+'/'+serviceId;
                                     $("#pricingOptionValues").load(itsId);
				     var staffList = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'ajax_staff_list','admin'=>true))?>"+'/'+serviceId;
				   $forTreatModal.find(".serviceProviderList").load(staffList);    
                             }
                     }
             };
	      if(!pricingOptionBtn.hasClass('rqt_already_sent')){
		     $('#ServicePricingOptionAdminAddPricingoptionForm').submit(function() {
			   
			    if(priceoption == 'yes'){
				    console.log(priceoption); 	
				    pricingOptionBtn.addClass('rqt_already_sent');
				   $(this).ajaxSubmit(options);
				   priceoption = 'no';            
			    }
		       $(this).unbind('submit');
		       $(this).bind('submit');
		       return false;
		     });
	      }else{
		 e.preventDefault();
	      }
	      
	       setTimeout(function(){
		if($smallmodal.find('dfn.text-danger').length > 0){
		    $smallmodal.find('div.tab-pane').removeClass('active');
		    $smallmodal.find('div.tab-pane#first11').addClass('active');
		    $smallmodal.find('ul.tabs li').removeClass('active');
		    $smallmodal.find('ul.tabs a[href=#first11]').closest('li').addClass('active');
		    buttonSave(pricingOptionBtn);
		}
	    },500);
	
	     
	});
        
        $forTreatModal.on('click','#pricingOptionValues table tbody tr',function(){
              var theRowId = $(this).attr('data-id');
              var serviceId = $forTreatModal.find('.salon_service_id:first').val();
              var addeditURL = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'add_pricingoption','admin'=>true)); ?>";
              addeditURL = addeditURL+'/'+serviceId+'/'+theRowId;
              fetchModal($smallmodal,addeditURL,'ServicePricingOptionAdminAddPricingoptionForm');
	      priceoption = 'yes';
        });
        

	/***** Add Services****/
	
	
	var $newServiceType = $('#commonContainerModal');
        $(document).on('click','.addServiceS',function(){
	     var theId = $(this).attr('data-id');
	     var parentId = $(this).attr('data-parent-id');
	     var catID = $(this).attr('data-cat');
	     var theservice = '<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'select_service_type','admin'=>true));?>';
	      fetchstaticModal($newServiceType,theservice+'/'+parentId+'/'+theId+'/'+catID);
	});
	
    var $newService = $('#commonMediumModal');
	$(document).on('click','.addServiceType,.addService',function(){
	    var theservice = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'select_service','admin'=>true));?>'+'/addnew';
	    fetchModal($newService,theservice);
	});
	
   $newService.on('click','input[type=checkbox]',function(){
	    var serviceAttr =  $(this).attr("checked");
	    if(serviceAttr=="checked"){
		$(this).prop( "checked", true );
		bootbox.alert("If you want to remove this service , then delete it from service list.");
		return false;
	    }
      });
	  
	//$selectService
	      $newService.on('click', '.submitSelectForm', function(e){
			
	       var options = { 
			       success:function(res){
					       if(onResponse($newService,'Service',res)){
                                                    ser_total = parseInt($('.service_count').text());
                                                    ser_total = ser_total+1;
                                                    $('.service_count').text(ser_total);
                                                    callfordatarepace();
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
	      var pricingLevel = 'yes';
	      $(document).on('click','.add_pricing_level' ,function(){
		      var addeditURL = "<?php echo $this->Html->url(array('controller'=>'PricingLevel','action'=>'add','admin'=>TRUE)); ?>";
		      fetchModal($bigmodal,addeditURL,'PricingLevelAdminAddForm');
		      pricingLevel = 'yes';
	      });
	
	      var $bigmodal = $('#commonContainerModal');
	      $bigmodal.on('click', '.update', function(e){
		var options = {
			//beforeSubmit:  showRequest,  // pre-submit callback 
			success: function(res){
				if (onResponse($bigmodal, 'PricingLevel', res)){
					var res = jQuery.parseJSON(res);
					 var optionId= $forTreatModal.find("#ServicePricingOptionId").val();
					itsId = "<?php echo $this->Html->url(array('controller'=>'PricingLevel','action'=>'priceDropDown' ,'admin'=>TRUE)); ?>"; 
					itsId = itsId+'/'+res.price_id;
					var popuplevel = $(document).find(".price_level_drop_down").length;
					$(document).find(".price_level_drop_down").last().load(itsId,function(){
						$(document).find(".price_level_drop_down").find('select').addClass('full-w').attr('name','data[ServicePricingOption][pricing_level_id]');
					});
					var serviceId = $forTreatModal.find('.salon_service_id').val();
					if(popuplevel==1){
						 var staffList = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'ajax_staff_list','admin'=>true))?>"+'/'+serviceId+'/'+res.price_id+'/'+optionId;
		     $forTreatModal.find(".serviceProviderList").load(staffList, function() {
			
		     });  
					}
					
				}
			}
		};
		$('#PricingLevelAdminAddForm').submit(function() {
		     if(pricingLevel=='yes'){
		       $(this).ajaxSubmit(options);
		       pricingLevel = 'no';
		     }
			$(this).unbind('submit');
			$(this).bind('submit');
			return false;
		});
		
	});
	 
	/****************pricing level ends here*********************/
    
  

	
        $forTreatModal.on('click','#SalonServiceInventory',function(){
	        if($(this).is(':checked')){
                    $('.stockQuantity').show();
		}else{
                    $('.stockQuantity').hide();
		}
		
	});
        
	/*********Delete Pricng Option********/
	
	$smallmodal.on('click','.del-option',function(){
	    var val = $smallmodal.find('#ServicePricingOptionId').val();
            if(confirm('Are you sure you want to delete this pricing option ?')){
                //check if Associated
                deletePricingOption($smallmodal,val);
            }
        });
	
	/*********Delete Pricng Option********/
	
       /*********Limit Inventory********/
       $forTreatModal.on('click','#SalonServiceInventory',function(){
	    var serviceId = $("#SalonServiceId").val();
	    var inventory = 0;
	    if ( $("#SalonServiceInventory").prop( "checked" ) ){
		    inventory = 1;
	    }
	     $.ajax({
                    url: "<?php echo $this->Html->url(array('controller'=>'salon_services','action'=>'saveinventory','admin'=>true))?>",
                    type:'POST',
		    data:{'salonServiceID':serviceId,'inventoryLimit':inventory},
		    success:function(res){
		     if(res=='success'){
			    
		     }else{
			    alert('There was some error in saving Data');
		     }
		    }
		   })
       
       })
	/*********Limit Inventory Ends ********/
	
	
	/*****Submit Form*********/
        var flaosub = 'yes';
        $(document).on('click','.editTreat',function(){
            var theId = $(this).attr('data-id');
	    var parentId = $(this).attr('data-parent-id');
	    var catID = $(this).attr('data-cat');
            if(theId){
                var treatURL = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'edit_treatment','admin'=>true)); ?>";
		if(theId=='null'){
		    if(confirm("Custom Services are not searchable and recommended, please use Sieasta Services.Only use them if you do not find a matching service in Sieasta Services.Do you still want to continue ?")){
			fetchModal($forTreatModal,treatURL+'/'+parentId+'/'+theId+'/'+catID,'SalonService');
		    }
		}else{
		    fetchModal($forTreatModal,treatURL+'/'+parentId+'/'+theId+'/'+catID,'SalonService');    
		}
                flaosub = 'yes';
            }else{
                alert('Please reload the page. Try again!');
            }
        });
	
	$forTreatModal.on('hidden.bs.modal', function () {
	     $newServiceType.modal('hide');
        });
	
        $forTreatModal.on('click', '.submitSalonService', function(e){

	    var theSalonServiceBtn = $(this);
	   
	    buttonLoading(theSalonServiceBtn);
            var options = {
                success: function(res){
		     buttonSave(theSalonServiceBtn);
                    if (onResponse($forTreatModal, 'SalonService', res)){
			    callfordatarepace();
                    }
                },
             };
	    if(!theSalonServiceBtn.hasClass('rqt_already_sent')){
		$('#SalonService').submit(function() {
    
		    if($('#SalonService').validate()){
			
			if(!$forTreatModal.find('ul.imagesList').find('li:first').hasClass('empty')){
			    if(flaosub == 'yes'){
				theSalonServiceBtn.addClass('rqt_already_sent');
				$(this).ajaxSubmit(options);
				flaosub = 'no';            
			    }
			}else{
			    $forTreatModal.find('ul.imagesList').find('li:first').css('border','1px Solid red');
			    $forTreatModal.find('ul.imagesList').find('dfn.text-danger').remove();
			    $forTreatModal.find('ul.imagesList').find('li:first').after('<dfn class="text-danger " style="display: inline;">Please select atleast one image.</dfn>');
			}
		    }
		    $(this).unbind('submit');
		    $(this).bind('submit');
		    return false;
		    
		});
	    }else{
		e.preventDefault();
	    }
	      
	    if($forTreatModal.find('ul.imagesList').find('li:first').hasClass('empty')){
		$forTreatModal.find('ul.imagesList').find('li:first').css('border','1px Solid red');
		$forTreatModal.find('ul.imagesList').find('dfn.text-danger').remove();
		$forTreatModal.find('ul.imagesList').find('li:first').after('<dfn class="text-danger k-invalid-msg" style="display: inline;">Please select atleast one image.</dfn>');
	    }
	    
	    setTimeout(function(){
		if($forTreatModal.find('dfn.text-danger').length > 0){
		    if($("#SalonService").find('.k-invalid').length > 0){
			var errorDiv = $("#SalonService").find('.k-invalid').first();
			var scrollPos = errorDiv.offset().top;
			$forTreatModal.find('.scrollError').scrollTop(scrollPos);
			errorDiv.trigger('focus');
		    }
		    
		    $forTreatModal.find('div.tab-pane').removeClass('active');
		    $forTreatModal.find('div.tab-pane#first11').addClass('active');
		    $forTreatModal.find('ul.tabs li').removeClass('active');
		    $forTreatModal.find('ul.tabs a[href=#first11]').closest('li').addClass('active');
		    buttonSave(theSalonServiceBtn);
		}
	    },500);
	});
	
	
	/*********End************/
	
	/***********Pricing level Staff Lisitng**********/
       var chkempP = true;
       $forTreatModal.on('change','.pricingLevelStaff',function(){
	      var obj = $(this);
	      var serviceId = $forTreatModal.find('.salon_service_id').val();
	      var pricing_level_id = $(this).val();
	      $("#SalonServiceTotalPricingIds").attr('data-id',pricing_level_id);
	      if(pricing_level_id !=0){
	       if(chkempP == true){
	       $.ajax({
                    url: "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'staff_pricing_level_count','admin'=>true))?>"+'/'+pricing_level_id,
                    type:'GET',
                    data: '',
                }).done(function(msg) {
		     //$('.price_level_drop_down').find('#level').remove();
		     //$('.price_level_drop_down').find('dfn').remove();
                     if(msg == 'f'){
			  $forTreatModal.find('.price_level_drop_down').find('#level').val('');
			  $forTreatModal.find('dfn[data-for=pricelevel]').css('display','inline');
		     }else{
			$forTreatModal.find('.price_level_drop_down').find('#level').val(1);
			$forTreatModal.find('dfn[data-for=pricelevel]').css('display','none');
		     }
		     chkempP = true;
                });
	       chkempP = false;
	       }
	      }else{
		     $forTreatModal.find('.price_level_drop_down').find('#level').val(1);
		     $forTreatModal.find('dfn[data-for=pricelevel]').css('display','none');
	      }
	      var optionId= $forTreatModal.find("#ServicePricingOptionId").val();
	      var staffList = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'ajax_staff_list','admin'=>true))?>"+'/'+serviceId+'/'+pricing_level_id+'/'+optionId;
	      $forTreatModal.find(".serviceProviderList").load(staffList, function() {
	      
	      });
	   
	});
	/***************End***************/
	
        $smallmodal.on('change','.pricingLevelStaff',function(){
	      var obj = $(this);
	      var serviceId = $forTreatModal.find('.salon_service_id').val();
	      var pricing_level_id = $(this).val();
	      if(pricing_level_id !=0){
	       $.ajax({
                    url: "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'staff_pricing_level_count','admin'=>true))?>"+'/'+pricing_level_id,
                    type:'GET',
                    data: '',
                }).done(function(msg) {
                     if(msg == 'f'){
			  $smallmodal.find('.price_level_drop_down').find('#level').val('');
			  $smallmodal.find('dfn[data-for=pricelevel]').css('display','inline');
		     }else{
			    $smallmodal.find('.price_level_drop_down').find('#level').val(1);
			    $smallmodal.find('dfn[data-for=pricelevel]').css('display','none');
		      }
		     
                });
	      }else{
		     $smallmodal.find('.price_level_drop_down').find('#level').val(1);
		     $smallmodal.find('dfn[data-for=pricelevel]').css('display','none');
	      }
	     
	})
	
	/*************Create Service Deal**************/
	var $dealmodal = $('#commonContainerModal');
	var dealsubmit = 'yes';
	
	deal_count = parseInt('<?php echo $dealCount ?>');
	$forTreatModal.on('click','.create_servicedeal',function(){
	    if(checkDealLimit(deal_count)){
		var serviceId = $forTreatModal.find('.salon_service_id').val();
		var servicedeal = '<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'create_servicedeal','admin'=>true));?>'+'/'+serviceId+'/Service/0';
		fetchstaticModal($dealmodal,servicedeal,'DealcreateForm');
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
            
        });
	
	/********************End********************/   
	
	$(".datepicker").datepicker();
});
function validateform(formId){
    if($('#'+formId).validate()){
	return true;
    }
    return false;
}
    
 
</script>