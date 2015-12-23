<style>
      .pac-container{
            z-index:9999999 !important; 
      }
</style>
<div class="modal-dialog vendor-setting">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel"><i class="icon-edit"></i>
    <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Business Information</h3>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-content">
            <?php echo $this->Form->create('User',array('id'=>'BusinessCreateForm','novalidate','type' => 'file','class'=>'')); ?>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Business Type *:</label>
                               <?php echo $this->Form->input('Salon.business_type_id',array('empty'=>'Please Select','options'=>$bType,'class'=>'chosen-select form-control','div'=>false,'label'=>false,'multiple'=>true,'selected'=>$businessTpe));?>
                               <!-- <select name="a" id="a" multiple="multiple" class="chosen-select input-lkarge">
                                        <option value="1">Option-1</option>
                                        <option value="2">Option-2</option>
                                        <option value="3">Option-3</option>
                                        <option value="4">Option-4</option>
                                        <option value="5">Option-5</option>
                                        <option value="6">Option-6</option>
                                        <option value="7">Option-7</option>
                                </select>-->
                        </div>
                        <?php if($type=='salon'){
                                echo  $this->Form->input('User.parent_id',array('type'=>'hidden','value'=>$this->Session->read('Auth.User.id')));
                                echo  $this->Form->input('User.type',array('type'=>'hidden','value'=>4));
                                echo  $this->Form->input('User.fortype',array('type'=>'hidden','value'=>$this->Session->read('Auth.User.type')));
                             }else{ ?>
                        
                            <div class="form-group">
                            <label class="control-label">Business Modal *:</label>
                                <?php $userType = $this->Common->businessModal(); ?>
                                <?php echo $this->Form->hidden('type',array('label'=>false,'div'=>false));?>
                                 <?php
                            $tmpitsval = "";
                            if(isset($this->data['User']['fortype']) && !empty($this->data['User']['fortype'])){
                                $tmpitsval = $this->data['User']['fortype'];
                            }
                            elseif(isset($this->data) && !empty($this->data)){
                                $tmpitsval = $this->data['User']['type'];
                                if(isset($this->data['User']['type']) && isset($this->data['User']['parent_id']) && $this->data['User']['type'] == 4 && $this->data['User']['parent_id']>0){
                                    
                                    $tmpitsval = '-1';
                                }
                            }
                            ?>
                            <?php echo $this->Form->input('fortype',array('empty'=>'Please Select','options'=>$userType,'class'=>'form-control','div'=>false,'value'=>$tmpitsval,'label'=>false));?>
                            
                        </div>
                        <?php
                        $parentStyle = "display:none";
                        if((isset($this->request->data['User']['parent_id']) && !empty($this->request->data['User']['parent_id']) && ($this->request->data['User']['parent_id'] != 0))||(isset($this->request->data['User']['fortype']) && ($this->request->data['User']['fortype']=='-1'))){
                            $parentStyle = "display:block";
                        }
                        ?>
                        <div class="form-group selFrenchise" style="<?php echo $parentStyle; ?>">
                            <label class="control-label">Frenchise *:</label>
                                <?php echo $this->Form->input('parent_id',array('empty'=>'Please Select','options'=>$frenchList,'class'=>'form-control','div'=>false,'label'=>false));?>
                        </div>
                        
                        <?php } ?>
                        
                        
                        <div class="form-group">
                                <label class="control-label">Service Provided To *:</label>
                                 <?php $serviceTo = $this->Common->serviceprovidedTo(); ?>
                                <?php echo $this->Form->input('Salon.service_to',array('empty'=>'Please Select','options'=>$serviceTo,'class'=>'form-control','div'=>false,'label'=>false));?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">First Name *:</label>
                                 <?php echo $this->Form->input('first_name',array('class'=>'form-control','div'=>false,'label'=>false));?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Last Name *:</label>
                                <?php echo $this->Form->input('last_name',array('class'=>'form-control','div'=>false,'label'=>false));?>
                        </div>
                    </div>
                
                    <div class="col-sm-5">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Business Email*:</label>
                                         <?php echo $this->Form->input('email',array('class'=>'form-control','div'=>false,'label'=>false));?>
                                 </div>
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab1" data-toggle="tab">English</a></li>
                                    <li><a href="#tab2" data-toggle="tab">Arabic</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <div class="sample-form form-horizontal">
                                            <fieldset>
                                                <div class="form-group">
                                                    <label class="control-label" >English Name *:</label>
                                                      <?php echo $this->Form->hidden('Salon.id',array());?>
                                                        <?php
                                                        $readonly=false;
                                                        if(isset($userInfo['User']['type']) &&($userInfo['User']['type']==4) && $userInfo['User']['parent_id'] != 0){
                                                            $readonly=true;
                                                        }
                                                        
                                                        echo $this->Form->input('Salon.eng_name',array('label'=>false,'div'=>false,'class'=>'form-control','maxlength'=>'200','readonly'=>$readonly)); ?>
                                                  </div>
                                            </fieldset>
                                            <fieldset>
                                                <div class="form-group">
                                                    <label class="control-label" >English Description *:</label>
                                                     <?php echo $this->Form->textarea('Salon.eng_description',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                                    </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab2">
                                        <div class="sample-form form-horizontal">
                                            <fieldset>
                                                <div class="form-group">
                                                    <label class="control-label">Arabic Name *:</label>
                                                        <?php echo $this->Form->input('Salon.ara_name',array('label'=>false,'div'=>false,'class'=>'form-control','maxlength'=>'200')); ?>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <div class="control-group">
                                                    <label class="control-label" >Arabic Description *:</label>
                                                        <?php echo $this->Form->textarea('Salon.ara_description',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                                </div>
                                            </fieldset>
                                        </div>    
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Business Phone *:</label>
                             <?php echo $this->Form->hidden('Contact.id',array());?>
                                <?php echo $this->Form->input('Contact.cell_phone',array('type'=>'text','class'=>'form-control','div'=>false,'label'=>false));?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Business Mobile:</label>
                               <?php echo $this->Form->input('Contact.day_phone',array('type'=>'text','class'=>'form-control','div'=>false,'label'=>false));?>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="input01">Image :</label>
                                <div class="preview">
                                <?php
                               
                                    if(isset($userInfo['User']['image']) && !empty($userInfo['User']['image'])){
                                        echo $this->Html->Image("../images/".$userInfo['User']['id']."/User/50/".$userInfo['User']['image']);
                                        echo $this->Html->link(__('Change Image'),'javascript:void(0);',array('class'=>'showFile'));
                                        $hideFile = 1;
                                    }?> 
                                </div>
                                <div class="previewInput" <?php if(isset($hideFile)){ echo 'style="display:none"'; } ?> >
                                <?php echo $this->Form->input('image',array('type'=>'file','label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                
                                    <?php
                                    if(isset($hideFile)){
                                        echo $this->Html->link(__('Cancel'),'javascript:void(0);',array('class'=>'hideFile'));
                                    }
                                    ?>
                                </div>
                            </div>
                       <div class="form-group">
                            <label class="control-label" for="input01">Cover Image :</label>
                                <div class="preview">
                                <?php
                                
                                    if(isset($userInfo['Salon']['cover_image']) && !empty($userInfo['Salon']['cover_image'])){
                                        echo $this->Html->Image("../images/".$userInfo['User']['id']."/Salon/50/".$userInfo['Salon']['cover_image']);
                                        echo $this->Html->link(__('Change Image'),'javascript:void(0);',array('class'=>'showFile'));
                                        $hideFile = 1;
                                    }?> 
                                </div>
                                <div class="previewInput" <?php if(isset($hideFile)){ echo 'style="display:none"'; } ?> >
                                <?php echo $this->Form->input('Salon.cover_image',array('type'=>'file','label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                    <?php
                                    if(isset($hideFile)){
                                        echo $this->Html->link(__('Cancel'),'javascript:void(0);',array('class'=>'hideFile'));
                                    }
                                    ?>
                                </div>
                            
                        </div>
                    </div>
                </div>
                <hr style="margin: 0px;">    
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Address:</label>
                                <?php echo $this->Form->hidden('Address.id',array());?>
                                <?php echo $this->Form->input('Address.address',array('type'=>'text','class'=>'form-control','div'=>false,'label'=>false,'onBlur'=>'changeMap()'));?>
                                <?php
                                $latitude    = 24.4667;
                                $longitude   = 54.3667;
                                if(isset($this->data['Address']['latitude']) && !empty($this->data['Address']['latitude'])){
                                    $latitude    = $this->data['Address']['latitude'];
                                    }
                                if(isset($this->data['Address']['longitude']) && !empty($this->data['Address']['latitude'])){
                                    $longitude    = $this->data['Address']['longitude'];
                                }?>
                                <?php echo $this->Form->hidden('Address.latitude',array('value'=>$latitude,'id'=>'AddressLatitude','div'=>false,'label'=>false));?>
                                <?php echo $this->Form->hidden('Address.longitude',array('value'=>$longitude,'id'=>'AddressLongitude','div'=>false,'label'=>false));
                                ?>
                        </div>
                         <div class="form-group">
                            <label class="control-label">PO Box:</label>
                                <?php echo $this->Form->input('Address.po_box',array('class'=>'form-control','div'=>false,'label'=>false,'onBlur'=>'changeMap()'));?>
                         </div>
                         <div class="form-group dynamiccity">
                            <label class="control-label">Location/Area:</label>
                                <?php
                                $cityList=array();
                                if(isset($userInfo['Address']['state_id']) && !empty($userInfo['Address']['state_id'])){
                                   $cityList =  $this->Common->getCitiesbySid($userInfo['Address']['state_id']);
                                }
                                echo $this->Form->input('Address.city_id',array('class'=>'form-control','empty'=>'Please Select','div'=>false,'label'=>false,'options'=>$cityList));?>
                          </div>
                        
                       
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Country:</label>
                                <?php //echo $this->Form->hidden('Address.country_id',array('value'=>252,'div'=>false,'label'=>false));?>
                                <?php echo $this->Form->input('Address.country_id',array('class'=>'form-control','options'=>$countryData,'empty'=>'Please Select','div'=>false,'label'=>false));?>
                         </div>
                        <div class="form-group dynamicstate">
                            <label class="control-label">State:</label>
                               <?php
                                $stateList=array();
                                if(isset($userInfo['Address']['country_id']) && !empty($userInfo['Address']['country_id'])){
                                   $stateList =  $this->Common->getStatesbyCid($userInfo['Address']['country_id']);
                                }
                                
                                echo $this->Form->input('Address.state_id',array('class'=>'form-control','empty'=>'Please Select','div'=>false,'label'=>false,'options'=>$stateList));?>
                        </div>
                      
                     </div>
                     
                        
                     
                    <div class="col-sm-6">
                        <div class="control-group">
                            <div id="map1" style="height: 150px"></div>
                        </div>    
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-9">
                    </div>
                    <div class="col-sm-3">
                        <div class="utopia-from-action">
                            <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary col-sm-5 submitBusiness','label'=>false,'div'=>false));?>
                                
                            <?php echo $this->Form->button('Cancel',array(
                                            'type'=>'button','label'=>false,'div'=>false,
                                            'data-dismiss'=>'modal',
                                            'class'=>'btn  col-sm-5')); ?>
                        </div>
                    </div>
                         
                </div>
                    <?php echo $this->Form->end();?>
                    </div>
                </div>
        </div>
    </div>
</div>

 
<script type="text/javascript">
    function changeMap(){
        var showAddress='';
        var country = $("#AddressCountryId").children("option").filter(":selected").text();
        var state = $("#AddressStateId").children("option").filter(":selected").text();
        var address = document.getElementById('AddressAddress').value;
        var poBox =  document.getElementById('AddressPoBox').value;
      
            
            if(address !=''){
                  showAddress+= ','+address;
            }
            
            if(poBox !=''){
                  showAddress+= ','+poBox;
            }
            if(state !='Please Select'){
                  showAddress+= ','+state;
            }
            if(country !='Please Select'){
                  showAddress+= ','+country;
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
                    zoom: 14
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
        var zoomlevel = 4;
        <?php if(isset($this->data['Address']['area']) && !empty($this->data['Address']['area'])){ ?>
            zoomlevel = 14;
        <?php }?>
        var lat     = '<?php echo $latitude; ?>';
        var long    = '<?php echo $longitude;?>';
       
        if($("#map1").length > 0){
            $("#map1").gmap3({
                map:{
                    options:{
                        center:[lat,long],
                        zoom:zoomlevel
                    }
                },
                autofit:{},
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
        
        $(document).on('change','#UserFortype',function(){
            $(document).find('#UserType').val($(this).val());
            if($(this).val() == -1 ){
                $(document).find('.selFrenchise').show();
                $(document).find('#UserType').val(4);
            }else{
                $(document).find('.selFrenchise').hide();
            }
        });
        
        $(document).on('click','.showFile',function(){
            $(this).closest('div.controls').find('.previewInput').show();
            $(this).closest('div.controls').find('.preview').hide();
        });
        $(document).on('click','.hideFile',function(){
            $(this).closest('div.controls').find('.previewInput').hide();
            $(this).closest('div.controls').find('.preview').show();
        });
  
  
  
        
      var getStateURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getStates','admin'=>false)); ?>";
         $(document).on('change','#BusinessCreateForm #AddressCountryId',function() {
            var id = $(this).val();
            $('#BusinessCreateForm .dynamicstate').load(getStateURL+'/'+id,function(){
                  changeMap();
             });
         });
       
       var getCityURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getCities','admin'=>false)); ?>";
         $(document).on('change','#BusinessCreateForm #AddressStateId',function() {
           var id = $(this).val();
           $('#BusinessCreateForm .dynamiccity').load(getCityURL+'/'+id,function(){
                  changeMap();
             });
         });

    $(document).on('change','#UserParentId',function(){
            if($(this).val() != '' ){
                 var text = $(this).children("option").filter(":selected").text();
                $("#SalonEngName").val(text);
                $("#SalonAraName").val(text);  
            }
        });
   $(document).on('change','#UserType',function(){
            if($(this).val() == 4){
                 $("#SalonEngName").attr('readonly',true);
                $("#SalonAraName").attr('readonly',true);  
            }else{
                 $("#SalonEngName").attr('readonly',false);
                $("#SalonAraName").attr('readonly',false);
            }
        });
   if($('.chosen-select').length > 0)
	{
		$('.chosen-select').each(function(){
			var $el = $(this);
			var search = ($el.attr("data-nosearch") === "true") ? true : false,
			opt = {};
			if(search) opt.disable_search_threshold = 9999999;
			$el.chosen(opt);
		});
	}
        
    });

</script>
   <script>
      $(function(){
       
        $("#AddressAddress").geocomplete()
         
      });
    </script>