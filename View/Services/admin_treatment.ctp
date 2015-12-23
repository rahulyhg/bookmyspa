<?php //echo $this->Html->script('jquery.mjs.nestedSortable'); ?>
<?php echo $this->Html->css('admin/nestable')?>
<?php echo $this->Html->script('bootbox.js');?>
 <style>
    .bootbox-body{
        font-size:large;
        margin:15px;
    }
    
 </style>
<div class="row" >
    <div class="box">
        <div class="box-content">
            <div class="setting-wrapper">
                <div class="setting-block-rw  dataforAll">
                    <?php echo $this->element('admin/Service/nestable_list');?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function fortreatmentView(mId,tcatId){
        $(document).find('.forSearchTreat').val('').keyup();
        var treatObj = $(document).find('.treat-block .treat-box');
        treatObj.find('.treat-list').hide().removeClass('active');
        treatObj.find('.treat-div').hide().removeClass('active');
        treatObj.find('.treat-tag-'+mId).show().addClass('active');
        treatObj.find('.treat-cat-'+tcatId).show().addClass('active');
    }
    function forview(mId){
        var catObj = $(document).find('.category-item');
        catObj.find('.panel-group').hide().removeClass('active');
        catObj.find('#accordion-'+mId).show().addClass('active');
        var thecatId = catObj.find('div.panel-group.active').find('div.panel.panel-active').attr('data-id');
        fortreatmentView(mId,thecatId);
    }
    function updateCat(){
        var myArray = {};
        if($(document).find('div.panel-group.active > div.panel').length > 0){
            $(document).find('div.panel-group.active > div.panel').each(function(val,obj){
                var parentObj = $(this);
                var parentid = parentObj.attr('data-id');
                myArray[val] = parentid;
            });
        }
        updateOrder(myArray);
    }
    function callCatsortable(){
        $(document).find(".panel-group").sortable({
            placeholder:    'pholder',
	    //items: "div.ui-disabled:not",
            start:function(event,ui){
                if($(this).find('div.panel-active').find('.panel-collapse').hasClass('in')){
                    $(this).find('div.panel-active').find('.panel-collapse').removeClass('in');
                    $(document).find('#forcheckT').val(1);
                }else{
		    $(document).find('#forcheckT').val(0);
		}
		$(this).find('div.panel').css('height','51px');
            },
            stop:function(event,ui){
                var chkV = $(document).find('#forcheckT').val();
                if(chkV == 1){
                    $(this).find('div.panel-active').find('.panel-collapse').addClass('in');    
                }
                $(this).find('div.panel').removeAttr('style');
		updateCat();
            }
        });    
    }
    var currentRequest = null;
    function updateOrder(myArray){
        if(myArray){
            if (window.JSON) {
                currentRequest = $.ajax({
                    url: "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'service_order','admin'=>true))?>",
                    beforeSend: function() {
                        if(currentRequest != null) {
                            currentRequest.abort();
                        }    
                    },
                    type:'POST',
                    //dataType:'json',
                    data: {serviceOrder:JSON.stringify(myArray)}
                }).done(function(msg) {

                });
            } else {
                output.val('JSON browser support required for this demo.');
            }
        }
        
    }
    
    function updatetags(){
        var myArray = {};
        if($(document).find('ul.tagBlock > li').length > 0){
            $(document).find('ul.tagBlock > li').each(function(val,obj){
                var parentObj = $(this);
                var parentid = parentObj.attr('data-id');
                myArray[val] = parentid;
            });
        }
        updateOrder(myArray);
    }
    function updatetreat(){
        var myArray = {};
        if($(document).find('div.treat-div.active ul.treat-list > li').length > 0){
            $(document).find('div.treat-div.active ul.treat-list > li').each(function(val,obj){
                var parentObj = $(this);
                var parentid = parentObj.attr('data-id');
                myArray[val] = parentid;
            });
        }
        updateOrder(myArray);
    }
    
    
    function callTagsortable(){
        $(document).find(".tagBlock").sortable({
            placeholder:    'placeholder',
            stop:function(event,ui){
                updatetags();
            }
        });    
    }
    
    
    function callTreatsortable(){
        $(document).find(".treat-list").sortable({
            placeholder:    'treat-holder',
            stop:function(event,ui){
                updatetreat();
            }
        });    
    }
    function forscroll(){
        $(document).find(".for-scroll").mCustomScrollbar({
            advanced:{updateOnContentResize: true}
        });
    }
    
    function formakingfrontView(theId,status){
        if(theId){
            $.ajax({
                url: "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'change_frontview','admin'=>true))?>",
                type: "POST",
                data: {id:theId,status:status},
                success: function(res) {
                    
                }
            });
        }
    }
    
    $(document).ready(function(){
        
        $(document).on('click','.for-tag-toggle',function(){
            var itObbj  = $(this);
            $(document).find('ul.tagBlock li').removeClass('active');
            var tagId   = itObbj.closest('li').attr('data-id');
            itObbj.closest('li').addClass('active');
            $(document).find('.forfiltertreat').val(2);
	    forview(tagId);
        });
        
        $(document).on('click','.for-cat-toggle',function(){
            var caObbj  = $(this);
            if(!caObbj.hasClass('collapsed')){
                caObbj.closest('div.panel-group').find('.panel').removeClass('panel-active');
                caObbj.closest('div.panel').addClass('panel-active');
                var catId   = caObbj.closest('div.panel').attr('data-id');
                var mId   = caObbj.closest('div.panel-group').attr('data-id');
                $(document).find('.forfiltertreat').val(2);
		fortreatmentView(mId,catId);
            }
        });
         $(document).click(function(event) {
	    if (event.target.className === "form-control forfiltertreat") {
	    } else {
	       $(document).find('.forfiltertreat').blur();
	    }
	 });
	 
	 $('.forSearchTreat').focus(function(){
	    $(this).parent('.search').addClass('purple-bod');   
	    
	 })
	 $('.forSearchTreat').focusout(function(){
	    $(this).parent('.search').removeClass('purple-bod');   
	    
	 })
	
        var $forTagmodal = $('#commonSmallModal');
        var tagchk = true;
	$(document).on('click','.addeditTag' ,function(){
            var itsId = $(this).attr('data-id');
            var addServiceURL = "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'addedit_tag','admin'=>true)); ?>";
            fetchModal($forTagmodal,addServiceURL+'/'+itsId,'ServiceTagForm');
	    tagchk = true;
        });
        $forTagmodal.on('click', '.submitTag', function(e){
            var theBtn = $(this);
	    buttonLoading(theBtn);
	
	    var options = { 
                success:function(res){
                    buttonSave(theBtn);
		    // onResponse function in modal_common.js
                    if(onResponse($forTagmodal,'Service',res)){
                        var dataURL = '<?php echo $this->Html->url(array("controller"=>"Services","action"=>"treatment","admin"=>true)); ?>';
                        var activeId = $(document).find('.tagBlock li.active').attr('data-id');
			var ie11andabove = navigator.userAgent.indexOf('Trident') != -1 && navigator.userAgent.indexOf('MSIE') == -1;
			var ie10andbelow = navigator.userAgent.indexOf('MSIE') != -1;
			if(ie11andabove || ie10andbelow){
				window.location.reload();
				return false;
			
			}
			$(document).find(".dataforAll").load(dataURL,function(){
						    $(document).find('ul.tagBlock').find('li').removeClass('active');
						    $(document).find('ul.tagBlock').find('li[data-id='+activeId+']').addClass('active');
						    forview(activeId);
						    callTagsortable();
						    callCatsortable();
						    callTreatsortable();
						    forscroll();
						    Custom.init();
						});    
                    }else{ tagchk = true; }
                },
            };
	    if(!theBtn.hasClass('rqt_already_sent')){
		$('#ServiceTagForm').submit(function(){
		    if(tagchk){
			theBtn.addClass('rqt_already_sent');
			$(this).ajaxSubmit(options);
			tagchk = false;
		    }
		    $(this).unbind('submit');
		    $(this).bind('submit');
		    return false;
		});
	    }else{
		e.preventDefault();
	    }
	    setTimeout(function(){
		if($forTagmodal.find('dfn.text-danger').length > 0){
		    $forTagmodal.find('div.tab-pane').removeClass('active');
		    $forTagmodal.find('div.tab-pane#first11').addClass('active');
		    $forTagmodal.find('ul.nav li').removeClass('active');
		    $forTagmodal.find('ul.nav a[href=#first11]').closest('li').addClass('active');
		    buttonSave(theBtn);
		}
	    },500);
        });
        
        var $forCatmodal = $('#commonSmallModal');
        
        var catValid = true;
	$(document).on('click','.addtreatment',function(){
            var tJ = $(this);
            var thePath = $(document).find('div.treat-block .treat-box div.treat-div.active');
            if(thePath.find('ul').hasClass('active')){
                var parentId = thePath.find('ul.active').attr('data-id');
                var itsId = $(this).attr('data-id');
                if(!itsId){ itsId = 0; }
                var addServiceURL = "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'addedit_category','admin'=>true)); ?>";
                fetchModal($forCatmodal,addServiceURL+'/'+itsId+'/'+parentId+'/Treatment','ServiceCatForm');
		catValid = true;
            }
            else{
                bootbox.alert('Please create category');
            }
        });
	
	
	$(document).on('click','.addeditCategory' ,function(){
            var itsId = $(this).attr('data-id');
            if(!itsId){ itsId = 0; }
            var parentID = $(document).find('.category-item div.panel-group.active').attr('data-id');
            var addServiceURL = "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'addedit_category','admin'=>true)); ?>";
            fetchModal($forCatmodal,addServiceURL+'/'+itsId+'/'+parentID+'/Category','ServiceCatForm');
	    catValid = true;
        });
	
	$forCatmodal.on('click', '.submitCategory', function(e){
            var theBtn = $(this);
	    buttonLoading(theBtn);
	
	    var options = { 
                success:function(res){
                    buttonSave(theBtn);
		    // onResponse function in modal_common.js
                    if(onResponse($forCatmodal,'Service',res)){
			var ie11andabove = navigator.userAgent.indexOf('Trident') != -1 && navigator.userAgent.indexOf('MSIE') == -1;
			var ie10andbelow = navigator.userAgent.indexOf('MSIE') != -1;
			if(ie11andabove || ie10andbelow){
				window.location.reload();
				return false;
			
			}
                        var dataURL = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'treatment','admin'=>true)); ?>';
                        var activeId = $(document).find('.tagBlock li.active').attr('data-id');
                        var activeCatId = $(document).find('div.category-item  div.panel-group.active div.panel-active').attr('data-id');
                        $(document).find(".dataforAll").load(dataURL,function(){
                            $(document).find('ul.tagBlock').find('li').removeClass('active');
                            $(document).find('ul.tagBlock').find('li[data-id='+activeId+']').addClass('active');
                            forview(activeId);
                            callTagsortable();
                            callCatsortable();
                            callTreatsortable();
                            $(document).find('div.category-item div.panel').removeClass('panel-active');
                            $(document).find('div.category-item div.panel-collapse').removeClass('in');
                            var activePnl = $(document).find('div.category-item  div.panel-group.active  div.panel[data-id='+activeCatId+']');
                            activePnl.addClass('panel-active');
                            activePnl.find('div.panel-collapse').addClass('in');
			    fortreatmentView(activeId,activeCatId);
                            forscroll();
                            Custom.init();
                        });    
                    }
		    else{
			catValid = true;
		    }
                }
            };
	    if(!theBtn.hasClass('rqt_already_sent')){
		$('#ServiceCatForm').submit(function(){
		    if(!$forCatmodal.find('ul.imagesList').find('li:first').hasClass('empty')){
			if(catValid == true){
			    theBtn.addClass('rqt_already_sent');
			    $(this).ajaxSubmit(options);
			    catValid = false;
			}
		    }
		    else{
			$forCatmodal.find('ul.imagesList').find('li:first').css('border','1px Solid red');
			$forCatmodal.find('ul.imagesList').find('dfn.text-danger').remove();
			$forCatmodal.find('ul.imagesList').find('li:first').after('<dfn class="text-danger " style="display: inline;">Please select at least one image.</dfn>');
			e.preventDefault();
		    }
		    $(this).unbind('submit');
		    $(this).bind('submit');
		    return false;
		});
	    }else{
		e.preventDefault();
	    }
	    
	    if($forCatmodal.find('ul.imagesList').find('li:first').hasClass('empty')){
		$forCatmodal.find('ul.imagesList').find('li:first').css('border','1px Solid red');
		$forCatmodal.find('ul.imagesList').find('dfn.text-danger').remove();
		$forCatmodal.find('ul.imagesList').find('li:first').after('<dfn class="text-danger k-invalid-msg" style="display: inline;">Please select at least one image.</dfn>');
	    }
	    
	    
	    setTimeout(function(){
		if($forTagmodal.find('dfn.text-danger').length > 0){
		    $forTagmodal.find('div.tab-pane').removeClass('active');
		    $forTagmodal.find('div.tab-pane#first11').addClass('active');
		    $forTagmodal.find('ul.nav li').removeClass('active');
		    $forTagmodal.find('ul.nav a[href=#first11]').closest('li').addClass('active');
		    buttonSave(theBtn);
		}
	    },500);
	    
        });
        
        
        
        $forAddingImagemodal = $('#commonMediumModal');
        $forCatmodal.on('click','.del-cat-pic',function(){
            var tObj = $(this);
            if(confirm('Are you sure you want to delete the Image?')){
                tObj.closest('ul').append('<li class="lightgrey empty"><a class="addImage" href="javascript:void(0);"><span><i class="fa fa-plus"></i></span></a><input type="hidden" id="ServiceServiceimage" class="serviceImg" name="data[Service][serviceimage][]"></li>');
                tObj.closest('li.theImgH').remove();
                
            }
        });
        $forCatmodal.on('click','.addImage',function(){
            var parentId = $forCatmodal.find('#ServiceCatForm').find('#ServiceParentId').val();
            var addiURL = "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'service_gallery','admin'=>true)); ?>";
            fetchModal($forAddingImagemodal,addiURL+'/'+parentId);
            
        });
        
        $forAddingImagemodal.on('click','.toUploadImage',function(){
            $forAddingImagemodal.find('#guploadImageForm #ServiceUpimage').click();
        });
        
        $forAddingImagemodal.on('change', '#ServiceUpimage', function(e){
            var theupbtn = $(document).find('.toUploadImage');
	    theupbtn.html('<i class="fa fa-spinner fa-spin"></i> Uploading');
	    
	    
	    file = this.files[0];
            var obj = $(this);
            var valReturn = validate_image(file);
            if(valReturn){
                obj.val('');
		theupbtn.html('<i class="icon-upload-alt"></i> Upload');
                bootbox.alert(valReturn);
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
				    var serviceId = $forAddingImagemodal.find('#ServiceId').val();
				    var serviceParentId = $forAddingImagemodal.find('#ServiceParentId').val();
				    if(!serviceId)
					serviceId = 0;
				    if(!serviceParentId)
					serviceParentId = 0;
				    formdata.append('serviceId', serviceId);
				    formdata.append('parent_id', serviceParentId);
				    
				    $.ajax({
					url: "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'service_gallery','admin'=>true))?>"+"/"+serviceId+"/"+serviceParentId+"/"+""+"/"+resize,
					type: "POST",
					data: formdata,
					processData: false,
					contentType: false,
					success: function(res) {
					    if (res != 'f') {
						var pareseObj = $.parseJSON(res);
						var imgRgt =  $forCatmodal.find('.image-box');
						imgRgt.find('ul').find('li').removeAttr('style');
						imgRgt.find('ul').find('dfn').remove();
						imgRgt.find('ul').find('li.empty:first').find('a').replaceWith('<img alt="" class="" src="/images/Service/150/'+pareseObj.image+'" data-img="'+pareseObj.image+'"><div class="extras"><div class="extras-inner"><a href="javascript:void(0);" class="del-cat-pic"><i class="fa fa-times"></i></a></div></div>');
						imgRgt.find('ul').find('li.empty:first').find('.serviceImg').val(pareseObj.image)
						imgRgt.find('ul').find('li.empty:first').addClass('theImgH');
						 imgRgt.find('ul').find('li.empty:first').removeClass('empty'); 
						$forAddingImagemodal.modal('toggle');
						theupbtn.html('<i class="icon-upload-alt"></i> Upload');
    
					    }else{
						theupbtn.html('<i class="icon-upload-alt"></i> Upload');
						bootbox.alert('Error in Uploading Image. Please try again!');
					    }
					}
				    });
				    
				    }else{
				       if(thecheckimage == 'size-error'){
					  obj.val(''); theupbtn.html('<i class="icon-upload-alt"></i> Upload');
					  bootbox.alert('Images should be upto 100 Kb in size.In case you would like us to resize and compress image please send it support@sieasta.com');
	 
				       }else if(thecheckimage == 'limit-error'){
					  obj.val(''); theupbtn.html('<i class="icon-upload-alt"></i> Upload');
					  bootbox.alert('Images should be landscape (wide, not tall) and minimum width of 800 pixels and height of 400 pixels are required.In case you would like us to resize and compress image please send it support@sieasta.com');
	 
				       }else if(thecheckimage == 'resize-error'){
					  obj.val(''); theupbtn.html('<i class="icon-upload-alt"></i> Upload');
					  bootbox.alert('Images should be in the ratio of 2:1.In case you would like us to resize and compress image please send it support@sieasta.com');
	 
				       }
				   }
                        };
                    image.onerror= function() {
                        bootbox.alert('Invalid file type: '+ file.type);
                    };      
                };
            }
        });
        
        $forAddingImagemodal.on('click', '.addImage-to-sub',function(){
            var thObject = $(this);
            var imageName = thObject.closest('li').find('img').attr('data-img');
            var serviceId = $forAddingImagemodal.find('#guploadImageForm').find('#ServiceId').val();
            var serviceParentId = $forAddingImagemodal.find('#guploadImageForm').find('#ServiceParentId').val();
            if(!serviceId){
                serviceId = 0;
            }
            
            $.ajax({
                url: "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'add_image_sub','admin'=>true))?>",
                type: "POST",
                data: {id:serviceId,imageName:imageName,parent_id:serviceParentId},
                success: function(res) {
                    if(res != 'f'){
                        var imgRgt =  $forCatmodal.find('.image-box');
                        imgRgt.find('ul').find('li').removeAttr('style');
			imgRgt.find('ul').find('dfn').remove();
                        imgRgt.find('ul').find('li.empty:first').find('a').replaceWith('<img alt="" class="" src="/images/Service/150/'+res+'" data-img="'+res+'"><div class="extras"><div class="extras-inner"><a href="javascript:void(0);" class="del-cat-pic"><i class="fa fa-times"></i></a></div></div>');
                        imgRgt.find('ul').find('li.empty:first').find('.serviceImg').val(res)
                        imgRgt.find('ul').find('li.empty:first').removeClass('empty').addClass('theImgH');
                        $forAddingImagemodal.modal('toggle');
                    }else{
                        bootbox.alert('Error in Adding Image. Please try again!');
                    }
                    $('body').modalmanager('loading');
                }
            });
            
            
        });
        
        $(document).on('click','.deleteCategory',function(){
            var theODj = $(this);
	    var itsType = $(this).attr('data-rel');
	    var catId = $(this).attr('data-id');
            if(confirm('Are you sure you want to delete?')){
                //$(document).find('#editTable').hide();
                $.ajax({
                    url: "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'delete_service','admin'=>true))?>"+"/"+catId,
                    success: function(res) {
                        if(res == 's'){
			    bootbox.alert(itsType+' has been deleted successfully.');    
			    var dataURL = '<?php echo $this->Html->url(array('controller'=>'Services','action'=>'treatment','admin'=>true)); ?>';
			    var activeId = $(document).find('.tagBlock li.active').attr('data-id');
			    $(document).find(".dataforAll").load(dataURL,function(){
				$(document).find('ul.tagBlock').find('li').removeClass('active');
				$(document).find('ul.tagBlock').find('li[data-id='+activeId+']').addClass('active');
				forview(activeId);
				callTagsortable();
				callCatsortable();
				callTreatsortable();
				forscroll();
				Custom.init();
			    });
			}else{
			    bootbox.alert('Unable to delete!');    
			}
                    }
                });
            }
        });
        
        $(document).on('click','.activeCategory',function(){
            var thecataJ = $(this);
            var theId = thecataJ.attr('data-id');
            if(thecataJ.hasClass('active')){
                
                if(!$(document).find('input#check-'+theId).is(':checked')){
                    if(confirm('Are you sure you want to de-activate?')){
                        $.ajax({
                            url: "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'change_status','admin'=>true))?>",
                            type: "POST",
                            data: {id:theId,status:0},
                            success: function(res) {
                                thecataJ.removeClass('active').attr('title','Activate').attr('alt','Activate').html('<i class="fa fa-square-o"></i>');    
                            }
                        });
                    }
                }
                else{
                    bootbox.alert('Please remove from FrontEnd Display to Deactivate ');
                }
                
            }
            else{
                
		$.ajax({
			url: "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'change_status','admin'=>true))?>",
			type: "POST",
			data: {id:theId,status:1},
			success: function(res) {
			    thecataJ.addClass('active').attr('title','De-activate').attr('alt','De-activate').html('<i class="fa fa-check-square-o"></i>');    
			}
		    });
                
            }
            
            
        
        });
        
        $(document).find('.tagtreatcheck').closest('span.treat-check').hide();
        $(document).find('.tagtreatcheck').closest('span.treat-check.atv').show();
        
        
        $(document).on('change','.tagcheck',function(){
            var theObj = $(this);
            var theId = theObj.attr('data-id');
            var check = false;
            if($(this).is(':checked')){
	        $.ajax({
		  url: "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'chk_status','admin'=>true))?>/"+theId,
		  type: "POST",
		  success: function(res) {
		     if(res == 1){
			    var theAccord = $(document).find('#accordion-'+theId);
			   thelen = theAccord.find('div.panel').length;
			   if(thelen >= 4){
			       var forimgcount = 0;
			       theAccord.find('div.panel').each(function(){
				   if(!$(this).find('div.category-pic').hasClass('no-pic')){
				       forimgcount = forimgcount+1;
				   }
			       });
			       var foractivecount = 0;
			       theAccord.find('div.panel').each(function(){
				   if($(this).find('a.activeCategory').hasClass('active')){
				       foractivecount = foractivecount+1;
				   }
			       });
			       var fortreatcheck = false;
			       if(forimgcount >= 4 && foractivecount >= 4 ){
				   theAccord.find('div.panel').each(function(){
				       var theCatJ = $(this); 
				       var thesubI = $(this).attr('data-id');
				       var treatlen = $(document).find('.treat-tag-'+theId).find('.treat-cat-'+thesubI).find('li[data-id]').length;
				       if(treatlen >= 1){
					   fortreatcheck = true;
				       }
				       else{
					   fortreatcheck = false;
					   bootbox.alert('There should be at least one treatment in each category for frontend display.');
					   theObj.prop('checked',false);
					   return false;
				       }
				   });
				   
				   if(fortreatcheck){
				       var checkcount = 0;
				       theAccord.find('div.panel').each(function(e,i){
					   var forchk = $(this);
					   if(!$(this).find('div.category-pic').hasClass('no-pic') && $(this).find('a.activeCategory').hasClass('active')){
					       checkcount = checkcount + 1;
					       forchk.find('input.tagcatcheck').prop('checked','checked');
					       formakingfrontView(forchk.attr('data-id'),1);
					   }
					   if(checkcount == 4){ return false; }
				       });
				       check = true;
				       formakingfrontView(theId,1);   
				   }
			       }
			      else{
				  bootbox.alert('There should be at least four active categories with image for frontend display.');
				  theObj.prop('checked',false);
				  return false;
			      }
			  }
		     else{
			 bootbox.alert('There should be at least four categories for frontend display.');
			 theObj.prop('checked',false);
			 return false;
		     }
			
			
		     }else{
			bootbox.alert('Please activate the tag for frontend display.');
			theObj.prop('checked',false);
			return false;
		     }
		  }
            });
            }else{
                if(confirm('Are you sure you want to remove tag from frontend display?')){
                    var theAccord = $(document).find('#accordion-'+theId);
                    theAccord.find('div.panel').each(function(){
                            var theCatJ = $(this); 
                            var thesubI = $(this).attr('data-id');
                            $(document).find('.treat-tag-'+theId).find('.treat-cat-'+thesubI).find('li').each(function(){
                                var treId = $(this).attr('data-id');
                                $(this).find('input.tagtreatcheck').prop('checked',false);
                                formakingfrontView(treId,0);
                            });
                            theCatJ.find('input.tagcatcheck').prop('checked',false);
                            formakingfrontView(thesubI,0);
                        });
                    formakingfrontView(theId,0);
                }
		else{
		    theObj.prop('checked','checked');
		}
            }
           
        });
        
        $(document).on('click','.tagcatcheck',function(){
            var theCatJ = $(this);
            var tagId = theCatJ.closest('div.panel-group').attr('data-id');
            var thesubI = theCatJ.closest('div.panel').attr('data-id');
            if(!$(document).find('.tagBlock').find('li[data-id='+tagId+']').find('input.tagcheck').is(':checked')){
                if(theCatJ.is(':checked')){
		   $.ajax({
			url: "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'chk_status','admin'=>true))?>/"+thesubI,
			type: "POST",
			   success: function(res) {
			      if(res == 1){
				 var treatlen = $(document).find('ul.treat-cat-'+thesubI).find('li[data-id]').length;
				 if(treatlen >= 4){
				     var forcountk = 0;
				     $(document).find('.treat-cat-'+thesubI).find('li').each(function(){
					 if(!$(this).find('div.category-pic').hasClass('no-pic') && $(this).find('a.activeCategory').hasClass('active')){
					     forcountk = forcountk + 1;
					 }
				     });
				     if(forcountk >= 4){
					 $(document).find('ul.treat-cat-'+thesubI).find('.tagtreatcheck').closest('span.treat-check').show().addClass('atv');
					 var theCnt = 0;
					 $(document).find('.treat-cat-'+thesubI).find('li').each(function(){
					     var treId = $(this).attr('data-id');
					     if(!$(this).find('div.category-pic').hasClass('no-pic') && $(this).find('a.activeCategory').hasClass('active')){
						 $(this).find('input.tagtreatcheck').prop('checked','checked');
						 formakingfrontView(treId,1);
						 theCnt = theCnt + 1;
					     }
					     else{
						 $(this).find('input.tagtreatcheck').prop('checked',false);
						 formakingfrontView(treId,0);
					     }
					     if(theCnt == 4){
						 return false;
					     }
					 });
					 theCatJ.find('input.tagcatcheck').prop('checked','checked');
					 formakingfrontView(thesubI,1);
					 check = true;  
				     }
				     else{
					 bootbox.alert('There must be at least four active treatment with image in a category for frontend display');
					 theCatJ.prop('checked',false);
					 return false;
				     }
				 }
				 else{
				     bootbox.alert('There should be at least four treatments in a category for frontend display.');
				     theCatJ.prop('checked',false);
				     return false;
				 }
				 
			      }else{
				 bootbox.alert('Please activate the category for frontend display.');
				 theCatJ.prop('checked',false);
				 return false;
				 
			      }
			   }
		  });
                }
                else{
                    if(confirm('Are you sure you want to remove category from frontend display')){
                         $(document).find('ul.treat-cat-'+thesubI).find('.tagtreatcheck').closest('span.treat-check').hide().removeClass('atv');
                        $(document).find('.treat-cat-'+thesubI).find('li').each(function(){
                            var treId = $(this).attr('data-id');
                            $(this).find('input.tagtreatcheck').prop('checked',false);
                            formakingfrontView(treId,0);
                        });
                        theCatJ.find('input.tagcatcheck').prop('checked',false);
                        formakingfrontView(thesubI,0);
                    
                    }    
                }
            }
            else{
	       $.ajax({
			url: "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'chk_status','admin'=>true))?>/"+thesubI,
			type: "POST",
			   success: function(res) {
			      if(res == 1){
				 var countforpa = 0;
				 theCatJ.closest('div.panel-group').find('input.tagcatcheck').each(function(){
				     if($(this).closest('div.panel').attr('data-id') != thesubI){
					 if($(this).is(':checked')){
					     countforpa = countforpa + 1;
					 }
				     }
				     
				 });
				     
				 if(theCatJ.is(':checked')){
				     if(countforpa < 4){
					 formakingfrontView(thesubI,1);   
				     }
				     else{
					 bootbox.alert('Only four categories can be displayed in the frontend display.');
					 theCatJ.prop('checked',false);
					 return false;
				     }
				 }
				 else{
				     if(countforpa > 2){
					 formakingfrontView(thesubI,0);   
				     }
				     else{
					 bootbox.alert('Please select at least four categories for frontend display.');
					 theCatJ.prop('checked','checked');
					 return false;
				     }
				 }
				 
			      }else{
				 bootbox.alert('Please activate the category for frontend display.');
				 theCatJ.prop('checked',false);
				 return false;
			      }
			   }
			})
		     }
        });

        $(document).on('click','.tagtreatcheck',function(){
            theCatJ = $(this);
            thesubI = $(this).closest('li').attr('data-id');
            var countforpa = 0;
            theCatJ.closest('ul.treat-list').find('input.tagtreatcheck').each(function(){
                if($(this).closest('li').attr('data-id') != thesubI){
                    if($(this).is(':checked')){
                        countforpa = countforpa + 1;
                    }
                }
                
            });
                
            if(theCatJ.is(':checked')){
                if(countforpa < 4){
                    formakingfrontView(thesubI,1);   
                }
                else{
                    bootbox.alert('Only four treatment can be displayed on the frontend.');
                    return false;
                }
            }
            else{
                if(countforpa > 0){
                    formakingfrontView(thesubI,0);   
                }
                else{
                    bootbox.alert('Atlest one treatment is required for frontend.');
                    return false;
                }
            }
        });
        
        $(document).on('change','.forfiltertreat',function(){
            var treatf = $(this);
            var theVal = treatf.val();
            if(theVal == 0 ){
                $(document).find('ul.treat-list.active').find('li[data-id]').each(function(){
                    if($(this).find('a.activeCategory').hasClass('active')){
                        $(this).closest('li').hide('slow');
                    }else{
                        $(this).closest('li').show('slow');
                    }
                });
            }
            else if(theVal == 1 ){
                $(document).find('ul.treat-list.active').find('li[data-id]').each(function(){
                    if(!$(this).find('a.activeCategory').hasClass('active')){
                        $(this).closest('li').hide('slow');
                    }
                    else{
                        $(this).closest('li').show('slow');
                    }
                });
            }
            else{
                $(document).find('ul.treat-list.active').find('li[data-id]').each(function(){
                        $(this).closest('li').show('slow');
                });
            }
        });
        
        $(document).on('keyup','.forSearchTreat',function(){
            var elmt = $(this);
            var value = elmt.val().toLowerCase();
            var count = 0;
            var totalShow = 0;
            var totalhidden = 0;
            var thePath = $(document).find('div.treat-div.active').find('ul.treat-list.active');
            thePath.find("li.notr").remove();
            thePath.find("li").each(function() {
                var text = $(this).find('.treat-check-txt').text();
                if (text.toLowerCase().indexOf(value) >= 0) {
                    totalShow++;
                    $(this).show('slow');
                } else {
                    totalhidden++;
                    $(this).hide('slow');
                }
                count++;
            });
            
            if(totalShow == 0 ){
                thePath.append('<li class="notr" style="background:#E6EAEC; border-bottom:1px Solid #CBCBCB; color:#333; font-size:14px; width: 100%; text-align:center; padding:10px 0 10px 0px; " >No Treatment Found</li>')   
            }
        });
        
        
        
        var mainTagId = $(document).find('ul.tagBlock').find('li.active').attr('data-id');
        forview(mainTagId);
        callTagsortable();
        callCatsortable();
        callTreatsortable();
        forscroll();
        $(document).find( ".tagBlock , .panel-group, .treat-list" ).disableSelection();   
	
        
    });
</script>