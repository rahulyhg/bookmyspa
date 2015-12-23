<?php 	echo $this->Html->css('admin/plugins/gmap/gmap3-menu'); ?>
<?php 	echo $this->Html->script('admin/plugins/gmap/gmap3.min.js');
	echo $this->Html->script('admin/plugins/gmap/gmap3-menu.js'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-content">  
		    <?php echo $this->Form->create('Salon',array('type'=>'file','novalidate','class'=>'form-horizontal form-stripped'));?>
		    <?php echo $this->Form->hidden('id',array('label'=>false,'div'=>false)); ?>
		    <?php echo $this->Form->hidden('User.id',array('label'=>false,'div'=>false)); ?> 
	    <div class=" col-sm-6"> 
		<div class="form-group">
		    <label class="control-label col-sm-5">Logo:</label>
		    <div class="col-sm-7 imgH">
			<?php echo $this->Form->input('logo',array('type'=>'file','div'=>false,'label'=>false,'style'=>'display:none',"onchange"=>"readURL(this)")); ?>
			<div class="stfImg">
			    <div class="clearfix emp-blank-img emp-detail-box text-center" id="logo">
				<?php
				
				if($this->data['Salon']['logo'] && $this->data['Salon']['logo'] !=' '){ ?>
				<div class="emp-photo added">
				    <div style=" " class="img-change-option">
					<a class="changeImg add_image" href="javascript:void(0)">change</a>
					<a class="delete_image"  href="javascript:void(0)">delete</a>
				    </div>
				    <div class="middle-img-box">
					<?php echo $this->Html->image("/images/".$this->data['User']['id']."/User/150/".$this->data['Salon']['logo'],array("class"=>"imageView" ,'title'=>"change Image" ,'alt'=>"Image"));?>
				    </div>
				</div>
				<?php }else{ ?>
				<a href="javascript:void(0)" class="emp-photo add_image">
				    <img alt="" src="/img/add-usephoto.png"><span>ADD PHOTO</span>
				</a>
				<?php } ?>
			    </div>
			</div>
		    </div>
		</div>
		<div class="form-group">
		    <label class="control-label col-sm-5">Cover Image:</label>
		    <div class="col-sm-7 imgH">
			<?php echo $this->Form->input('cover_image',array('type'=>'file','div'=>false,'label'=>false,'style'=>'display:none',"onchange"=>"readURL(this)")); ?>
			<div class="stfImg">
			<div class="clearfix emp-blank-img emp-detail-box text-center" id="cover_image">
				<?php if(isset($this->data['Salon']['cover_image']) && !empty($this->data['Salon']['cover_image'])){ ?>
				<div class="emp-photo added">
				    <div style="display: " class="img-change-option">
					<a class="changeImg add_image" href="javascript:void(0)">change</a>
					<a class="delete_image" id="cover_image" href="javascript:void(0)">delete</a>
				    </div>
				    <div class="middle-img-box">
					<?php echo $this->Html->image("/images/".$this->data['User']['id']."/Salon/150/".$this->data['Salon']['cover_image'],array("class"=>"imageView" ,'title'=>"change Image" ,'alt'=>"Image"));?>
				    </div>
				</div>
				<?php }else{ ?>
				<a href="javascript:void(0)" class="emp-photo add_image">
				    <img alt="" src="/img/add-usephoto.png"><span>ADD COVER IMAGE</span>
				</a>
				<?php } ?>
			</div>
			</div>
		    </div>
		</div>
		<div class="form-group">
		    <label class="control-label col-sm-5">Business Name*:</label>
		    <?php echo $this->Form->input('eng_name',array('label'=>false,'div'=>array('class'=>'col-sm-7'),'class'=>'form-control','required','validationMessage'=>"Business Name is required.", 'minlength' => '3','data-minlength-msg'=>"Minimum 3 characters."));?>
		</div>
                <div class="form-group">
                    <label class="control-label col-sm-5">Description*:</label>
                        <?php echo $this->Form->input('eng_description',array('label'=>false,'div'=>array('class'=>'col-sm-7'),'class'=>'form-control','validationMessage'=>"Description is required.", 'minlength' => '10','data-minlength-msg'=>"Minimum 10 characters."));?>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-5">Business Email:</label>
                    <div class="col-sm-7 nopadding">
			<div class="col-sm-12 mrgn-btm10">
				<?php echo $this->Form->input('Salon.email',array('label'=>false,'div'=>false,'class'=>'form-control','validationMessage'=>"Enter valid email address."));?>
			</div>
			<div class="col-sm-12">
			    <?php echo $this->Form->input('show_contact_front',array('type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>'Show my contact information on My Page.'),'div'=>false,'class'=>''))?>
			</div>
                    </div>
                </div>
		<div class="form-group">
                    <label class="control-label col-sm-5">Business Phone:</label>
		         <?php echo $this->Form->input('cell_phone_code',array('label'=>false,'div'=>array('class'=>'col-sm-2'),'class'=>'form-control','value'=>$phone_code));?>
                        <?php echo $this->Form->input('Contact.day_phone',array('label'=>false,'div'=>array('class'=>'col-sm-5 lft-p-non'),'class'=>'form-control'));?>
                </div>
		<div class="form-group">
                    <label class="control-label col-sm-5">Business Mobile:</label>
		    <?php echo $this->Form->input('cell_phone_code',array('label'=>false,'div'=>array('class'=>'col-sm-2'),'class'=>'form-control','value'=>$phone_code));?>
                        <?php echo $this->Form->input('Contact.night_phone',array('label'=>false,'div'=>array('class'=>'col-sm-5 lft-p-non'),'class'=>'form-control'));?>
                </div>
		<div class="form-group">
                    <label class="control-label col-sm-5">Description*:</label>
                        <?php echo $this->Form->input('eng_description',array('label'=>false,'div'=>array('class'=>'col-sm-7'),'class'=>'form-control','validationMessage'=>"Description is required.", 'minlength' => '10','data-minlength-msg'=>"Minimum 10 characters."));?>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-5">Current Business Website:</label>
                      <?php $pattern = '(https?:\/\/(?:www\.|(?!www))[^\s\.]+\.[^\s]{2,}|www\.[^\s]+\.[^\s]{2,})';?>
		      <?php echo $this->Form->input('website_url',array('label'=>false,'div'=>array('class'=>'col-sm-7'),'class'=>'form-control','type'=>'text','pattern'=>$pattern,'data-pattern-msg'=>"Please enter a valid url.",));?>
                </div>
                
        </div>
                <div class=" col-sm-6">
		
		<div class="form-group">
                    <label class="control-label col-sm-5" style="padding-right: 5px;">Personal Sieasta URL*:</label>
			<div class="col-sm-7">
				<?php echo $this->Form->input('business_url',array('label'=>false,'div'=>false,'class'=>'form-control','required','validationMessage'=>"Personal Sieasta URL is required."));?>
				<dfn><?php echo Configure::read('BASE_URL'); ?>/<span id='bsnsUrl'><?php echo $businessUrl;?></span></dfn>		
			</div>
                 </div>
		<div class="form-group">
		    <label class="control-label col-sm-5">&nbsp;</label>
		    <div class="col-sm-7">
			<?php echo $this->Form->input('include_in_front',array('type'=>'checkbox','label'=>array('text'=>'Include in sieasta.com Listing','class'=>'new-chk'),'div'=>false,'class'=>''))?>
		    </div>
		 </div>
		
                <div class="form-group" style="<?php echo (isset($this->data['Address']['located_at']) && !empty($this->data['Address']['located_at']))?'display: none;':''; ?>">
		
		<label class="control-label col-sm-12">
			<?php echo $this->Html->link('Do you Operate inside a hotel,Mall etc.','javascript:void(0)', array('class'=>'locatedAt')); ?>
			<!--<a href="#" class="locatedAt">
                            Do you Operate inside a hotel,Mall etc.
                        </a> -->
		</label>
               </div>
		<div class="form-group locateHere" style="<?php echo (isset($this->data['Address']['located_at']) && empty($this->data['Address']['located_at']))?'display: none;':''; ?>">
                    <label class="control-label col-sm-4">Located at:</label>
                       <?php echo $this->Form->input('Address.located_at',array('label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control'));?>
               </div>
	       <div class="form-group">
			<label class="control-label col-sm-4">Address*:</label>
			 <?php echo $this->Form->input('Address.address',array('type'=>'text','label'=>false,'onBlur'=>'changeMap()','div'=>array('class'=>'col-sm-8'),'class'=>'form-control','required','validationMessage'=>"Address is required."));?>
		</div>
                <div class="form-group">
			<label class="control-label col-sm-4">Country*:</label>
			<?php echo $this->Form->hidden('Address.id',array('label'=>false,'div'=>false)); ?>  
                        <?php echo $this->Form->input('Address.country_id',array('options'=>$countryData,'label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control','empty'=>'Please Select','required','validationMessage'=>"Please select country."));?>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-4">Postcode*:</label>
                      <?php echo $this->Form->input('Address.po_box',array('label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control numOnly','maxlength'=>'9','maxlengthcustom'=>'8','data-maxlengthcustom-msg'=>'Maximum 8 characters.','required','validationMessage'=>"Postcode is required."));?>
                </div>
		
                <div class="form-group dynamicstate">
                    <label class="control-label col-sm-4">City*:</label>
                        <?php echo $this->Form->input('Address.state_id',array('options'=>$states,'label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control','empty'=>'Please Select','required','validationMessage'=>"Please select city."));?>
                </div>
                <div class="form-group dynamiccity">
                    <label class="control-label col-sm-4">Location/Area*:</label>
                      <?php echo $this->Form->input('Address.city_id',array('options'=>$cities,'label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control','empty'=>'Please Select','required','validationMessage'=>"Please select location/area."));?>
                </div>
		
                <div class="form-group">
                    <label class="control-label col-sm-4">Cell Phone*:</label>
                    <?php echo $this->Form->hidden('Contact.id',array('label'=>false,'div'=>false)); ?>  
                        <?php echo $this->Form->input('cell_phone_code',array('label'=>false,'div'=>array('class'=>'col-sm-2'),'class'=>'form-control','value'=>$phone_code));?>
			<?php echo $this->Form->input('Contact.cell_phone',array('label'=>false,'div'=>array('class'=>'col-sm-6 lft-p-non'),'class'=>'form-control numOnly','required','validationMessage'=>"Cell Phone is required."));?>
                </div>
		
		<div class="form-group">
                    <label class="control-label col-sm-12">Location on map:</label>
                    <div class="col-sm-12">
			<?php echo $this->Form->hidden('Address.latitude',array('label'=>false,'div'=>false));?>
			<?php echo $this->Form->hidden('Address.longitude',array('label'=>false,'div'=>false));?>
			<?php
                            $latitude    = 24.4667;
                            $longitude   = 54.3667;
                            if($auth_user['Address']['latitude']){
                               $latitude    = $auth_user['Address']['latitude'];
                            }
                            if($auth_user['Address']['longitude']){
                               $longitude   = $auth_user['Address']['longitude'];
                            }
                            if(isset($this->data['Address']['latitude']) && !empty($this->data['Address']['latitude'])){
                                $latitude    = $this->data['Address']['latitude'];
                                }
                            if(isset($this->data['Address']['longitude']) && !empty($this->data['Address']['longitude'])){
                                $longitude    = $this->data['Address']['longitude'];
                            }?>
                            <?php echo $this->Form->hidden('Address.latitude',array('value'=>$latitude,'id'=>'AddressLatitude','div'=>false,'label'=>false));?>
                            <?php echo $this->Form->hidden('Address.longitude',array('value'=>$longitude,'id'=>'AddressLongitude','div'=>false,'label'=>false));
                            ?>
			<div id="map-here" style="height: 250px">
                        
			</div>
		    </div>
                </div>
                <div class="form-group">
			<label class="control-label col-sm-4">&nbsp;</label>
                        <div class="col-sm-8 text-right pdng-tp20 form-actions">
                            <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary','label'=>false));?>
                            <?php //echo $this->Html->link('Cancel',array('controller'=>'dashboard','action'=>'index','admin'=>true),array('escape'=>false,'class'=>'btn col-sm-3')); ?>
                        </div>
                </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

<script>
	$(document).ready(function(){
		$(document).on('keyup','.numOnly' ,function(){
			var value = $(this).val();
			if(isNaN(value)){
				$(this).val('');
			}
		});
	});
    function readURL(input){
        if (input.files && input.files[0]) {
            var imgCheck = validate_image(input.files[0]);
            if(!imgCheck){
                var reader = new FileReader();
                reader.onload = function (e){
                    var theDiv = $(input).closest('div.imgH');
		    theDiv.find('.emp-blank-img.emp-detail-box').html('<div class="emp-photo added"><div style="display: " class="img-change-option"><a class="changeImg add_image" href="javascript:void(0)">change</a><a class="delete_image" href="javascript:void(0)">delete</a></div><div class="middle-img-box"><img class="imageView" title="change Image" alt="Image" src=""></div></div>');
		    theDiv.find('.emp-blank-img.emp-detail-box img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
            else{
                alert(imgCheck);
                return false;
            }
        }
    }
    function changeMap(){
        var country = $("#AddressCountryId").children("option").filter(":selected").text();
        var state = $("#AddressStateId").children("option").filter(":selected").text();
        var address = document.getElementById('AddressAddress').value;
       // console.log(country);
        var poBox =  document.getElementById('AddressPoBox').value;
       // if(address){
            showAddress = address;
             if(country !='Please Select'){
                  showAddress+= ','+country;
            }
            if(poBox !=''){
                  showAddress+= ','+poBox;
            }
            if(state !='Please Select'){
                  showAddress+= ','+state;
            }
            $('#map1').gmap3('destroy');
            $("#map1").gmap3({
                marker:{
                  address: showAddress,
                  options:{draggable:true},
                  events:{
                        dragend: function(marker){
                            updateMarker(marker);
                        },
                    },
                    callback: function(marker){
                        updateMarker(marker);
                    }
                },
                map:{
                  options:{
                    zoom: 8
                  }
                }
            });
        }
	
    function updateMarker(marker){
        var latLng = marker.getPosition();
        document.getElementById('AddressLatitude').value = latLng.lat();
        document.getElementById('AddressLongitude').value = latLng.lng();
    }
    $(document).ready(function(){
	
	var regValidator = $("#SalonAdminBusinessProfileForm").kendoValidator({
	rules:{
	    minlength: function (input) {
		return minLegthValidation(input);
	    },
	    maxlength: function (input) {
		return maxLegthValidation(input);
	    },
	    pattern: function (input) {
		return patternValidation(input);
	    }
	},
	errorTemplate: "<dfn class='text-danger'>#=message#</dfn>"}).data("kendoValidator");
	
	var phoneCode = '';
	var getStateURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getStates','admin'=>false)); ?>";
        $(document).on('change','#SalonAdminBusinessProfileForm #AddressCountryId',function() {
            var id = $(this).val();
	    $(document).find('#SalonAdminBusinessProfileForm .dynamicstate').load(getStateURL+'/'+id,function(){
		$.ajax({
                        url: "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getPhoneCode','admin'=>false))?>"+'/'+id,
                        success: function(res) {
                            phoneCode = res;
			}
                });
		
		var docstt = $(document).find('#SalonAdminBusinessProfileForm .dynamicstate');
		docstt.find('label').addClass('col-sm-4');
		docstt.find('div').addClass('col-sm-8');
		docstt.find('select').addClass('form-control');
		
    	    });
        });
       
	var getCityURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getCities','admin'=>false)); ?>";
        $(document).on('change','#SalonAdminBusinessProfileForm #AddressStateId',function() {
           var id = $(this).val();
	    $('#SalonAdminBusinessProfileForm .dynamiccity').load(getCityURL+'/'+id,function(){
		var citydemo = $('#SalonAdminBusinessProfileForm .dynamiccity');
		citydemo.find('label').addClass('col-sm-4');
		citydemo.find('div').addClass('col-sm-8');
		citydemo.find('select').addClass('form-control');
		
	    });
        });
	
	$(document).on('click','.add_image , .changeImg',function(){
	    $(this).closest('div.imgH').find('input').click();
	});
	
        $('#SalonBusinessUrl').keyup(function(){
            var theval = $(this).val();
            theval = theval.replace(/\s+/g, '-').toLowerCase()
            $('#bsnsUrl').html(theval);
        });

	$('#ContactCellPhone').focus(function(){
	    if(phoneCode){
		$(this).val(phoneCode);
	    }
	});
	
	$(document).on('click','.locatedAt',function(e){
	    e.preventDefault();
	    $(document).find('.locateHere').show();
	    $(this).closest('div').hide();
	});
	
	
	var zoomlevel = 8;
        var lat    = 0;
        var long   = 0;
        <?php if(isset($this->data['Address']) && !empty($this->data['Address'])){
            if(isset($this->data['Address']['latitude']) && !empty($this->data['Address']['latitude'])){ ?>
                lat    = <?php echo $this->data['Address']['latitude']; ?>;
                long   = <?php echo $this->data['Address']['longitude']; ?>;
            <?php 
            }
            else{ ?>
                var showAddress =  "";
                <?php
                if(isset($this->data['Address']['address']) && !empty($this->data['Address']['address'])){ ?>
                showAddress =  '<?php echo $this->data['Address']['address']; ?>';
                <?php } ?>
                <?php
                if(isset($this->data['City']['city_name']) && !empty($this->data['City']['city_name'])){ ?>
                showAddress =  showAddress+', <?php echo $this->data['City']['city_name']; ?>';
                <?php } ?>
                <?php
                if(isset($this->data['State']['name']) && !empty($this->data['State']['name'])){ ?>
                showAddress =  showAddress+', <?php echo $this->data['State']['name']; ?>';
                <?php } ?>
                <?php
                if(isset($this->data['Country']['name']) && !empty($this->data['Country']['name'])){ ?>
                showAddress =  showAddress+', <?php echo $this->data['Country']['name']; ?>';
                <?php } ?>
                
                <?php
                }
            } ?>
            $('#map-here').gmap3('destroy');
            if(lat){
                $("#map-here").gmap3({
                    map:{
                        options:{
                            center:[lat,long],
                            zoom:zoomlevel
                        }
                    },
                    marker:{
                        options:{draggable:true},
                        values:[
                            {latLng:[lat,long], data:" "},
                        ],
                        events:{
                            dragend: function(marker){
                                updateMarker(marker);
                            },
                        }
                    }
                });
            }
            else{
                $("#map-here").gmap3({
                    marker:{
                        address: showAddress,
                        options:{draggable:true},
                        events:{
                            dragend: function(marker){
                                updateMarker(marker);
                            },
                        },
                        callback: function(marker){
                            updateMarker(marker);
                        }
                    },
                    map:{
                        options:{
                            zoom: zoomlevel
                        }
                    }
                });
            }
	
	$(document).on("click",".delete_image",function(){
	    
	    var imgTyp  = $(this).closest(".emp-detail-box").attr('id');
	    var salonId = $("#SalonId").val();
	    if(confirm("Are you sure you want to remove this image?")){
		if(imgTyp=='cover_image'){
		$(this).closest(".emp-detail-box").html('<a href="javascript:void(0)" class="emp-photo add_image"><img alt="" src="/img/add-usephoto.png"><span>ADD COVER IMAGE</span></a>');
		//$("#SalonCoverImage").after($(this).clone(true)).remove();
	    }else{
		$(this).closest(".emp-detail-box").html('<a href="javascript:void(0)" class="emp-photo add_image"><img alt="" src="/img/add-usephoto.png"><span>ADD PHOTO</span></a>');
		//$("#SalonLogo").after($(this).clone(true)).remove();
	    }
	   $.ajax({
                        url: "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'removeImage','admin'=>false))?>",    type:'POST',
			data:{'type':imgTyp,'id':salonId},
                        success: function(res) {
                            if(res=='success'){
				
			    }
			}
                });
	    }
	   
	});
	
    });
    
    $(function(){
      initialize('are');
   });
    
    function initialize(iso){
	autocomplete = new google.maps.places.Autocomplete(
	     /** @type {HTMLInputElement} */(document.getElementById('AddressAddress')),
	     {types:  ['geocode'],componentRestrictions: {country:iso} });
	      google.maps.event.addListener(autocomplete, 'place_changed', function() {
	  });
	// console.log(autocomplete);
     }
    
    
</script>