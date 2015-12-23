<?php echo $this->Html->script('bootbox.js'); ?>
<style>
 .bootbox-body{
        font-size:large;
        margin:15px;
    }
    
</style>
<div class="row" >
  <div class="box">
	<div class="box-content side-gap">
	  <div role="tabpanel" class="vendor-deal-sec">
          <?php echo $this->element('admin/Business/nav_service'); ?>
	  <!-- Tab panes -->
	  <div class="tab-content">
		<div role="tabpanel" class="tab-pane " id="SERVICES"></div>
		<div role="tabpanel" class="tab-pane " id="Packages"></div>
		<div role="tabpanel" class="tab-pane active" id="SPADays">
                <div role="tabpanel" class="tab-pane active" id="SPABreak">
                <div class="vendor-deal-head">
		<div class="col-sm-3 col-xs-5 nopadding">
                        <select class="forSpabreak form-control">
                            <option value="2">All Spabreaks</option>
                            <option value="1"> Active</option>
                            <option value="0"> In Active</option>
                        </select>
                        </div>
                        <a class="rt-text addSpaBreak" data-id=""><i class="fa fa-plus"></i> Add Spa Break</a>
                </div>
                <div class="vendor-service-content clearfix spaBreak">
		<?php echo $this->element('admin/Business/list_spabreak'); ?>
		    
                </div>	
                </div>
		<div role="tabpanel" class="tab-pane" id="Deals"></div>
		<div role="tabpanel" class="tab-pane" id="LMDeals"></div>
		
            </div>
	  
	  </div>
	</div>
  </div>
</div>
<script>


function addspaBreakDay($addSpaBreakmodal,$addSpaBreakDayPricemodal,url,type){
		   $("#SpabreakOptionPerdayFullPrice").trigger('blur');
		   var optionperdayID =  $("#SpabreakOptionPerdayId").val();
		   var optionid = $("#SpabreakOptionPerdaySpabreakOptionId").val();
		   var fullPrice =  $("#SpabreakOptionPerdayFullPrice").val();
		   var sellPrice =  $("#SpabreakOptionPerdaySellPrice").val();
		   var roomId =  $("#SpabreakOptionSalonRoomId").val();
		   var maxbooking= $("#SpabreakOptionMaxBookingPerday").val();
		   var spabreakID= $("#SpabreakId").val();
		   var checkDays = $addSpaBreakmodal.find('#weekDays :checkbox').serialize();
		if($addSpaBreakmodal.find('#pricingOptionValues').find('.k-invalid-msg').filter(":visible").length==0)   {
		   $.ajax({
			     url: "<?php echo $this->Html->url(array('controller'=>'salon_services','action'=>'admin_spabreak_options','admin'=>true))?>",
			     type:'POST',
			     data:{'spabreak_option_id':optionid,'spabreak_option_perday_id':optionperdayID,'full_price':fullPrice,'sell_price':sellPrice,'salon_room_id':roomId,'max_booking_perday':maxbooking,'spabreak_id':spabreakID,'checkdays':checkDays},
			     success:function(res){
			       var res = jQuery.parseJSON(res);
			       if(res.data=='success'){
				   if(type=='perday'){
				    url = url+'/'+res.id;
				    var formId = "SpabreakOptionsprice";
				   }else{
				    var formId = "SpabreakOptions";
				   }
				   //var priceDaysId = $($addSpaBreakmodal).find('.add_pricing_day').attr('data-id');
				   fetchModal($addSpaBreakDayPricemodal,url,formId); 
				}else{
				   alert('There was some error in saving data.');
				}
			     }
			 })
		//  }  
		}
}

function deletePricingOption($smallmodal,$parentmodal,value){
        var theId = value;
	if(theId){
            $.ajax({
                url: "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'admin_delete','admin'=>true))?>"+'/'+'SpabreakOptionPerday',
                type:'POST',
                data: {'id':theId,'type':'permanent'}
            }).done(function(res) {
	        
		res = jQuery.parseJSON(res);
                if (res.data=="success"){
			itsId = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'spabreakajax' ,'admin'=>TRUE)); ?>";
			      var spabreakId = $parentmodal.find("#SpabreakId").val();
			      
			      itsId = itsId+'/'+spabreakId;
			      $("#pricingalues").load(itsId,function(){
				      
			      });
					
                             }
            });
        }
 }
function deleteSpabreak($smallmodal,value){
        var theId = value;
	if(theId){
            $.ajax({
                url: "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'admin_deleteSpaBreak','admin'=>true))?>"+'/'+'Spabreak',
                type:'POST',
                data: {'id':theId,'type':'temp'}
              }).done(function(res) {
	      var res = jQuery.parseJSON(res);
	      if(res.data=='success'){
               itsId = "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'admin_spabreak' ,'admin'=>TRUE)); ?>";
		$(".spaBreak").load(itsId,function(){
		  
		});
	      }else{
	        bootbox.alert(res.message);
	      }
            });
        }
    }
    
    function deleteSpabreakOption($smallmodal,value){
        var theId = value;
	if(theId){
            $.ajax({
                url: "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'admin_delete','admin'=>true))?>"+'/'+'SpabreakOption',
                type:'POST',
                data: {'id':theId,'type':'permanent'}
            }).done(function(res) {
	      
				     itsId = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'spabreakajax' ,'admin'=>TRUE)); ?>";
			      var spabreakId = $smallmodal.find("#SpabreakId").val();
			      itsId = itsId+'/'+spabreakId;
			      $("#pricingOptionValues").load(itsId,function(){
				      
			      });
            });
        }
    }

$(document).ready(function(){
	
	
	$(document).on('click','button[data-dismiss="modal"]',function(){
	  $(this).closest('.modal').html(' ');
	});
	$(document).on('change','.forSpabreak',function(){
            var treatf = $(this);
            var theVal = treatf.val();
	    
            if(theVal == 1 ){
                $(document).find('.vendor-service-content').find('.v-deal').each(function(){
                    if($(this).find('.dull').length > 0){
                        $(this).closest('.v-deal').hide('slow');
                    }else{
                        $(this).closest('.v-deal').show('slow');
                    }
                });
            }
            else if(theVal == 0 ){
               $(document).find('.vendor-service-content').find('.v-deal').each(function(){
                    if(!($(this).find('.dull').length > 0)){
                        $(this).closest('.v-deal').hide('slow');
                    }else{
                        $(this).closest('.v-deal').show('slow');
                    }
                });
            }
            else{
                $(document).find('.vendor-service-content').find('.v-deal').each(function(){
                        $(this).show('slow');
                });
            }
        });
	
	
	/***********SpaDay ADD/Edit********/
       var spabreakSubmit = 'yes';
       var $addSpaBreakmodal = $('#commonSmallModal');
       $(document).on('click','.addSpaBreak',function(){
	       var id = $(this).attr('data-id');
	       var spabreak = '<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'addedit_spabreak','admin'=>true));?>'+'/'+id;
	       fetchModal($addSpaBreakmodal,spabreak,'Spabreak');
	       spabreakSubmit = 'yes';
       });
       
      $addSpaBreakmodal.on('click','.submitSpaBreak',function(e){
	var theSpaBreakBtn = $(this);
	buttonLoading(theSpaBreakBtn);
	var options = {
			success:function(res){
			   buttonSave(theSpaBreakBtn);
				  if(onResponse($addSpaBreakmodal,'Spabreak',res)){
				      itsId = "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'admin_spabreak' ,'admin'=>TRUE)); ?>";
					$(".spaBreak").load(itsId,function(){
						
					});
				   };	
				}
			    
		      };
		   
	if(!theSpaBreakBtn.hasClass('rqt_already_sent')){     	    
	     $addSpaBreakmodal.find("#Spabreak").submit(function(){
	       
	       if(!$addSpaBreakmodal.find('ul.imagesList').find('li:first').hasClass('empty')){
		       if(spabreakSubmit == 'yes'){
			 theSpaBreakBtn.addClass('rqt_already_sent');
			 $(this).ajaxSubmit(options);
			 spabreakSubmit='no';
		       }
		      
		     }else{
			    
			    $addSpaBreakmodal.find('ul.imagesList').find('li:first').css('border','1px Solid red');
			    $addSpaBreakmodal.find('ul.imagesList').find('dfn.text-danger').remove();
			    $addSpaBreakmodal.find('ul.imagesList').find('li:first').after('<dfn class="text-danger " style="display: inline;">Please select atleast one image.</dfn>');
			   }
				      
				      $(this).unbind('submit');
				      $(this).bind('submit');
				      return false;
		      });
	}else{
	 e.preventDefault();
	}
	    if($addSpaBreakmodal.find('ul.imagesList').find('li:first').hasClass('empty')){
		$addSpaBreakmodal.find('ul.imagesList').find('li:first').css('border','1px Solid red');
		$addSpaBreakmodal.find('ul.imagesList').find('dfn.text-danger').remove();
		$addSpaBreakmodal.find('ul.imagesList').find('li:first').after('<dfn class="text-danger k-invalid-msg" style="display: inline;">Please select atleast one image.</dfn>');
	    }
	    
	    setTimeout(function(){
		if($addSpaBreakmodal.find('dfn.text-danger').length > 0){
		    $addSpaBreakmodal.find('div.tab-pane').removeClass('active');
		    $addSpaBreakmodal.find('div.tab-pane#first11').addClass('active');
		    $addSpaBreakmodal.find('ul.tabs li').removeClass('active');
		    $addSpaBreakmodal.find('ul.tabs a[href=#first11]').closest('li').addClass('active');
		    buttonSave(theSpaBreakBtn);
		}
	    },500);
		     
      });
      
      /*************End*************/
      
       /*********Delete Spabreak********/
	
                $parentDom = $(document);
	   	$parentDom.on('click','.deleteSpabreak',function(){
		 var value =  $(this).attr('data-id');
	  if(confirm('Are you sure you want to delete this pricing option ?')){
                //check if Associated
                deleteSpabreak($parentDom,value);
            }
	});
      /**************End**************/
      /*********Delete Spabreak Option********/
	
                
	    $addSpaBreakmodal.on('click','.deleteSpabreak-Option',function(){
		//  alert('dd');
		 var value =  $(this).attr('data-id');
	  if(confirm('Are you sure you want to delete this pricing option ?')){
                //check if Associated
                deleteSpabreakOption($addSpaBreakmodal,value);
            }
	});
      /**************End**************/
      
      /**********Delete Image*******/
      
	 $addSpaBreakmodal.on('click','.del-cat-pic',function(){
            var tObj = $(this);
            if(confirm('Are you sure you want to delete the image?')){
                tObj.closest('ul').append('<li class="lightgrey empty"><a class="addImage" href="javascript:void(0);"><span><i class="fa fa-plus"></i></span></a><input type="hidden" id="SpabreakServiceimage" class="serviceImg" name="data[Spabreak][serviceimage][]"></li>');
                tObj.closest('li.theImgH').remove();
                
            }
        });
	 
      /************End*************/
      
     
	
      /***********Pricing Option Per day********/
      var priceperDay = 'yes';
    $('#commonMediumModal').html(' ');
     var $addSpaBreakDayPricemodal =  $('#commonMediumModal');
	$addSpaBreakmodal.on('click','.add_pricing_day',function(){
	  var priceperdayid = $(this).attr('data-id');
	    if(priceperdayid == ''){
	      var spabreak = '<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'admin_spabreak_days','admin'=>true));?>'+'/null';
	      addspaBreakDay($addSpaBreakmodal,$addSpaBreakDayPricemodal,spabreak,'perday');
	      priceperDay = 'yes';
	      
	    }else if(priceperdayid=="notset"){
		var optionid = $(this).attr('data-option-id');
		var spabreak = '<?php echo
		  $this->Html->url(array('controller'=>'SalonServices','action'=>'admin_spabreak_days','admin'=>true));?>'+'/null/'+optionid;
		  fetchstaticModal($addSpaBreakDayPricemodal,spabreak,'SpabreakOptionsprice');
		  priceperDay = 'yes';
	    }else{
	       var spabreak = '<?php echo
	       $this->Html->url(array('controller'=>'SalonServices','action'=>'admin_spabreak_days','admin'=>true));?>'+'/'+priceperdayid;
		fetchstaticModal($addSpaBreakDayPricemodal,spabreak,'SpabreakOptionsprice');
		priceperDay = 'yes';
	    }
	});
	   
	   
       $addSpaBreakDayPricemodal.on('click','.update',function(){
	    var options = { 
			    success:function(res){
			     
				if(onResponse($addSpaBreakDayPricemodal,'SpaBreakService',res)){
                                    //var res = jQuery.parseJSON(res);
					itsId = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'spabreakajax' ,'admin'=>TRUE)); ?>";
					var spabreakId = $addSpaBreakmodal.find("#SpabreakId").val();
					itsId = itsId+'/'+spabreakId;
					$("#pricingOptionValues").load(itsId,function(){
						
					});
				 };	
				 }
			    
	       }; 
	       $addSpaBreakDayPricemodal.find("#SpabreakOptionsprice").submit(function(){
		 if(priceperDay =='yes'){
			       $(this).ajaxSubmit(options);
			       priceperDay = 'no';
		 }
			       $(this).unbind('submit');
			       $(this).bind('submit');
			       return false;
	       });
	})
        /***********End********/
	
	 /*********Delete Pricng Option********/
	

	$addSpaBreakDayPricemodal.on('click','.del-option',function(){
		 var value =  $addSpaBreakDayPricemodal.find('#SpabreakOptionPerdayId').val();
		
            if(confirm('Are you sure you want to delete this pricing option ?')){
                //check if Associated
                deletePricingOption($addSpaBreakDayPricemodal,$addSpaBreakmodal,value);
            }
	});
      /**************End**************/
      
      /***********Add Another Pricing Option********/
      var priceOption = 'yes';
     var $addSpaBreakDayOptionmodal = $('#commonVendorModal');
	$addSpaBreakmodal.on('click','.add_anotherpricing',function(){
	  var spabreakId = $addSpaBreakmodal.find("#SpabreakId").val();
          var spabreak = '<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'admin_spabreak_options','admin'=>true));?>'+'/'+spabreakId;
	  if($addSpaBreakmodal.find('#pricingOptionValues .box-title').length ==0)
	  {
	     addspaBreakDay($addSpaBreakmodal,$addSpaBreakDayOptionmodal,spabreak,'anotheroption');
	     priceOption = 'yes';
	  }else{
	    fetchModal($addSpaBreakDayOptionmodal,spabreak,"SpabreakOptions");
	    priceOption = 'yes';
	  }
     });
      $addSpaBreakDayOptionmodal.on('click','.update',function(){
	    var options = { 
			    success:function(res){
			     
				if(onResponse($addSpaBreakDayOptionmodal,'SpaBreakService',res)){
                                    itsId = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'spabreakajax' ,'admin'=>TRUE)); ?>";
					var spabreakId = $addSpaBreakmodal.find("#SpabreakId").val();
					itsId = itsId+'/'+spabreakId;
					$("#pricingOptionValues").load(itsId,function(){
						
					});
				 };	
				 }
			    
	       }; 
	       $addSpaBreakDayOptionmodal.find("#SpabreakOptions").submit(function(){
			      if(priceOption == 'yes'){
				$(this).ajaxSubmit(options);
				priceOption = 'no';
			      }
			       $(this).unbind('submit');
			       $(this).bind('submit');
			       return false;
			      
	       });
	})
       /***********End********/
       
       
       
       /******Add Images*****/
        $forAddingImagemodal = 	 $('#commonMediumModal'); 
        $addSpaBreakmodal.on('click','.addImage',function(){
             
             var addiURL = "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'service_gallery','admin'=>true)); ?>";
             fetchModal($forAddingImagemodal,addiURL);
             
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
		 bootbox.alert(valReturn);
	     }else{
                var reader = new FileReader();
                var image = new Image();
                reader.readAsDataURL(file);  
                reader.onload = function(_file) {
                    image.src    = _file.target.result;
		   // alert(image.src);// url.createObjectURL(file);
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
				  var serviceId = $addSpaBreakmodal.find('#ServiceId').val();
				  var serviceParentId = $addSpaBreakmodal.find('#ServiceParentId').val();
				  if(!serviceId)
				      serviceId = 0;
				  if(!serviceParentId)
				      serviceParentId = 0;
				  formdata.append('serviceId', '');
				  formdata.append('parent_id', serviceParentId);
				  
				  $.ajax({
				      url: "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'service_gallery','admin'=>true))?>"+"/"+serviceId+"/"+serviceParentId+"/"+"Spabreak",
				      type: "POST",
				      data: formdata,
				      processData: false,
				      contentType: false,
				      success: function(res) {
					  if (res != 'f') {
					     var pareseObj = $.parseJSON(res);
					      var imgRgt =  $addSpaBreakmodal.find('.image-box');
					      imgRgt.find('ul').find('li').removeAttr('style');
					      imgRgt.find('ul').find('dfn').remove();
					      imgRgt.find('ul').find('li.empty:first').find('a').replaceWith('<img alt="" class="" src="/images/Service/150/'+pareseObj.image+'" data-img="'+pareseObj.image+'"><div class="extras"><div class="extras-inner"><a href="javascript:void(0);" class="del-cat-pic"><i class="fa fa-times"></i></a></div></div>');
					      imgRgt.find('ul').find('li.empty:first').find('.serviceImg').val(pareseObj.image)
					      imgRgt.find('ul').find('li.empty:first').removeClass('empty').addClass('theImgH');
					      
					      $forAddingImagemodal.modal('toggle');
  
					  }else{
					      bootbox.alert('Error in uploading image. Please try again!');
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
		      console.log(file.type);
                        bootbox.alert('Invalid file type: '+ file.type);
                    };      
                };
            }
        });
        
       /*********End********/
       
       
    /**************Change Status****************/
    
      $(document).on('click','.active-deactive',function(){
            var theObj = $(this);
            var theID = $(this).attr('data-id');
            var status = 1;
	    var msgs = "Confirm to activate the spabreak.";
            if($(this).hasClass('active')){
                status = 0;
                msgs = "Are you sure you want to deactivate the spabreak.";
            }
            
            if(confirm(msgs)){
            
                $.ajax({
                    url: "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'change_spabreak_status','admin'=>true))?>",
                    type:'POST',
                    data: {'id':theID,'status':status}
                }).done(function(msg) {
                    if(msg == 1){
                        theObj.closest('div.bottom').removeClass('dull');
                        theObj.closest('div.v-deal-box').find('span.status').remove();
                        theObj.addClass('active').text('Deactivate');
                    }else if(msg == 0){
                        theObj.removeClass('active').text('Activate');
                        theObj.closest('div.bottom').addClass('dull');
                        //theObj.closest('div.v-deal-box').find('div.upper').append('<span class="status">Activate Service</span>');
                    }else{
		      alert('There was an error.Please try later!!!');
		    }
                });
            }
        });
    /******************End*********************/
	 
});

</script>