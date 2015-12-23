<?php echo $this->Html->script('frontend/jquery.multiple.select'); ?>
<?php //echo $this->Html->script('admin/plugins/bootstrap-multiselect/bootstrap-multiselect-collapsible-groups'); ?>

<?php echo $this->Html->css('frontend/multiple-select'); ?>

<style>
    .form-horizontal .col-sm-2 control-label {
        text-align: right;
    }
    input[type="checkbox"]:not(:checked), [type="checkbox"]:checked{
        left: 0px !important;
        position: inherit !important;
    }
</style>    
<div class="modal-dialog vendor-setting">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
    <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Salon Advertisement</h3>
        </div>
        <?php $display='display:none'; ?>
        <?php if(isset($this->data['SalonAd']['type']) && $this->data['SalonAd']['type']==1){
            $display='display:block';
        }elseif(isset($this->data['SalonAd']['type']) && $this->data['SalonAd']['type']==0){
            $display='display:none';
        } ?>
        <div class="modal-body">
            <div class="box">
                
                <div class="box-content">
                    <?php //pr($this->data); die; ?>
                    <?php echo $this->Form->create('SalonAd',array('novalidate','class'=>'form-horizontal'));?> 
                    <?php 
                    echo $this->Form->hidden('id',array('label'=>false,'div'=>false)); 
                    ?>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1" data-toggle="tab">English</a></li>
                        <li><a href="#tab2" data-toggle="tab">Arabic</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="form-group">
                                <label class="col-sm-2" ></label>
                                <div class="col-sm-6">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2" >Title *:</label>
                                <div class="col-sm-6">
                                        <?php echo $this->Form->input('eng_title',array('label'=>false,'div'=>false,'class'=>'form-control','required','ValidationMessage'=>'Please select Title.')); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2" >Description *:</label>
                                <div class="col-sm-6">
                                        <?php echo $this->Form->textarea('eng_description',array('label'=>false,'div'=>false,'class'=>'form-control','required','ValidationMessage'=>'Please select Description.')); ?>
                                </div>
                            </div>
                            
                            <!--<div class="form-group">
                                <label class="col-sm-2">Specific Location :</label>
                                <div class="col-sm-6">
                                                <?php //echo $this->Form->input('eng_location',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                </div>
                            </div>-->
                        </div>
                        <div class="tab-pane" id="tab2">
                            <div class="form-group">
                                <label class="col-sm-2" ></label>
                                <div class="col-sm-6">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2">Arabic Title *:</label>
                                <div class="col-sm-6">
                                                <?php echo $this->Form->input('ara_title',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                </div>
                            </div>                            
                           <div class="form-group">
                                <label class="col-sm-2" >Arabic Description *:</label>
                                <div class="col-sm-6">
                                                <?php echo $this->Form->textarea('ara_description',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                </div>
                            </div>
                            <!--<div class="form-group">
                                <label class="col-sm-2">Specific Location :</label>
                                <div class="col-sm-6">
                                                <?php //echo $this->Form->input('ara_location',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                </div>
                            </div>-->
                       </div>
                        
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label class="col-sm-6"></label>
                                <?php $options=array('0'=>'Main Banner','1'=>'Normal');
                                    $attributes=array('label'=>array('class'=>'new-chk'),'legend'=>false ,'default'=>'0','separator'=> '</div><div class="col-sm-2">');
                                    echo $this->Form->radio('type',$options,$attributes);  ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-2" >Image *:</label>
                            <div class="col-sm-6"> 
                                <?php echo $this->Form->input('image',array('type'=>'file','label'=>false,'div'=>false,'class'=>'form-control','required','ValidationMessage'=>'Please select image.' ,'onChange'=>'readURL(this)')); ?>
                                <span class="">
                                    <br>
                                        <?php   $text = "<i style=\"font-size:11px\">You can upload image of width and height 520 x 144 only</i><br>";
                                                echo "<b><i>Note</i> : </b>&nbsp;".$text ?>
                                    <br/>
                                </span>                                       
                                <div class="preview">                                        
                                    <?php
                                        $uid = $this->Session->read('Auth.User.id');
                                        if(!empty($adDetail['SalonAd']['image'])){
                                            echo $this->Html->Image('/images/'.$uid.'/SalonAd/original/'.$adDetail['SalonAd']['image']); 
                                        }
                                    ?>                                     
                                </div>
                            </div>                                  
                        </div>
                        <div class="form-group normal" style=<?php echo $display; ?>>
                            <label class="control-label col-sm-2">Page *:</label>
                            <?php $sizes = array('0' => 'Search', '1' => 'Blog', '2' => 'Home', '3' => 'Deals','4'=>'SpaBreak','5'=>'Stylist');
                                echo $this->Form->input('page',array('options' => $sizes, 'default' => 'Please Select','label'=>false,'div'=>array('class'=>'col-sm-6'),'class'=>'form-control','required','ValidationMessage'=>'Please select page.')
                            ); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">URL *:</label>
                            <?php echo $this->Form->input('url',array('required'=>true,'type'=>'url','label'=>false,'div'=>array('class'=>'col-sm-6'),'class'=>'form-control','required','ValidationMessage'=>'Please select URL.')); ?>
                        </div>
                        
                        <div class="form-group normal" style=<?php echo $display; ?>>
                        <label class="control-label col-sm-2">Country *:</label>
                            <?php
                            $val = isset($this->data['Address']['country_id'])?$this->data['Address']['country_id']:$auth_user['Address']['country_id'];
                            echo $this->Form->input('country_id',array('class'=>'form-control','options'=>$countryData,'div'=>array('class'=>'col-sm-6'),'empty'=>'Please Select','label'=>false,'required','ValidationMessage'=>'Please select Country.','value'=>$val));?>
                      </div>
                        
                        
                        <div class="form-group dynamicstate normal" style=<?php echo $display; ?>>
                        <label class="control-label col-sm-2">City *:</label>
                            <?php
                              $state = isset($this->data['Address']['state_id'])?$this->data['Address']['state_id']:$auth_user['Address']['state_id'];

                            echo $this->Form->input('state_id',array('class'=>'form-control','empty'=>'Please Select','options'=>$stateData,'div'=>array('class'=>'col-sm-6'),'label'=>false,'required'=>'false','value'=>$state,'required','ValidationMessage'=>'Please select city.'));?>
                    </div>
                        
                        
                        <div class="form-group  dynamiccity normal" style=<?php echo $display; ?>>
                        <label class="control-label col-sm-2">Location/Area *:</label>
                        <?php //pr($cityData);  ?>
                        <?php echo $this->Form->input('Address.city_id',array('class'=>'','options'=>$cityData,'label'=>false,'div'=>array('class'=>'col-sm-6'),'multiple'=>true)); ?>
                    </div>
                        
                       <div class="">                      
                            <div class="form-actions col-sm-8 text-center">
                                <?php
                                echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary update ','label'=>false,'div'=>false));?>
                                <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal',
                                            'type'=>'button','label'=>false,'div'=>false,
                                            'class'=>'btn closeModal')); ?>
                            </div>
                        </div>
                <?php echo $this->Form->end(); ?>
            </div>   
        </div>
    </div>     
</div>
</div>
<script>
 /* function to show image before upload */
 function readURL(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.preview').html('<img src="'+e.target.result+'" style="width: 200px;"/>');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(document).ready(function(){
        $(document).on('change','#SalonAdAdminAddAdsForm #SalonAdCountryId',function() {
            //alert("tttt");
            var id = $(this).val();
             $.ajax({
                  url: "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'getIsoCode','admin'=>false))?>"+'/'+id,
                  success: function(res) {
                      initialize(res);
                  }
            });
            var country = $(this).children("option").filter(":selected").text();
            setphoneCode(id);
            $('#SalonAdAdminAddAdsForm .dynamicstate').load(getStateURL+'/'+id,function(){
                  $(document).find('#SalonAdAdminAddAdsForm .dynamicstate').find('select').addClass('form-control').attr('required',false);
                  $(document).find('#SalonAdAdminAddAdsForm .dynamicstate').find('label').html('City');
                  //changeMap();
                  $(this).unbind();
            });
            $(this).unbind();
        });
    
    var getCityURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getCities','admin'=>false)); ?>";
    $('body').off().on('change','#SalonAdAdminAddAdsForm #SalonAdStateId',function() {
        var id = $(this).val();
        var country = $(this).children("option").filter(":selected").text();
        $('#SalonAdAdminAddAdsForm .dynamiccity').load(getCityURL+'/'+id,function(){
            $(document).find('#SalonAdAdminAddAdsForm .dynamiccity').find('select').addClass('control').attr({'required':false,'multiple':'multiple','name':'data[Address][city_id][]'});
            $(document).find('#SalonAdAdminAddAdsForm .dynamiccity').find('#AddressCityId').css('width','20px');
            $('.control').parent('div').addClass('col-sm-6 multi-class');
            $("div .dynamiccity > label").addClass("col-sm-2");
            $('#AddressCityId').multipleSelect({
                width: '100%',
            });
            
        });
        $(document).find(".multi-class #AddressCityId select option[value='']").remove();
         //$(document).find("#AddressCityId").remove('option:first');
       //$(document).find("#SalonAdAdminAddAdsForm .dynamiccity option[value='Please Select']").remove();
    });
    
    
    $("#AddressCityId").removeAttr("required");
    
    $(document).on('change','#SalonAdAdminAddAdsForm #SalonAdType1',function() {
        $(document).find('#SalonAdAdminAddAdsForm .normal').css({'display':'block'});
          $("#AddressCityId").attr("required","required");
          $("#AddressCityId").attr("ValidationMessage","Select Location");
    });
    
    $(document).on('change','#SalonAdAdminAddAdsForm #SalonAdType0',function() {
        $(document).find('#SalonAdAdminAddAdsForm .normal').css({'display':'none'});
    });
    
    //$("#SalonAdCityId").multiselect(); 
     $('#AddressCityId').multipleSelect({
            width: '100%',
	    selectedText:'Please Select',
            placeholder:'Please Select'
        });
     });
     
     
</script>
<style>
    .control{width:20%;}
</style>