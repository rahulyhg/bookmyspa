<?php //echo $this->Html->css('datepicker/datepicker-css');
$salon_data = $this->Common->serviceprovidedTo();
?>
<div class="jumbotron">
    <div class="container">
        <div class="col-sm-5">
            <div role="tabpanel" class="tabs">
                <h3><?php echo __('search_book',true); ?><span> <?php echo __('salon_and_spas',true); ?></span></h3>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
				<?php /*echo $this->Html->link(__('book_treatment',true).' / '.__('Spadays',true),'#treatment',
				    array(
					    'aria-controls'=>"home",'role'=>"tab",'data-toggle'=>"tab"
				    )
				);*/?>
			<?php echo $this->Html->link(__('book_treatment',true),'#treatment',
			       array(
				       'aria-controls'=>"home",'role'=>"tab",'data-toggle'=>"tab"
			       )
			   ); ?>
                    </li>
                    <li role="presentation" >
                        <?php echo $this->Html->link(__('Book',true).' '.__('getaways',true),'#spadaystab',
                            array(
                                    'aria-controls'=>"profile",'role'=>"tab",'data-toggle'=>"tab"
                            )
                        );?>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content clearfix">
                    <div role="tabpanel" class="tab-pane active" id="treatment">
                        <?php echo $this->Form->create('Search', array('url' => array('controller' => 'search', 'action' => 'index') ,'type' =>'get','id'=>"sform")) ?>
                            <input type="hidden" name="state_id" id="state_id" value="">
                            <input type="hidden" name="city_id" id="city_id" value="">
                            <input type="hidden" name="service_id" id="service_id" value="">
                            <ul class="clearfix">
                                <li>
                                    <section class="col-sm-5 lft-pdng0 customv">
                                        <label><?php echo __('City',true); ?></label>
                                        <div class="dynamiccity">
                                            <?php
						
					    echo $this->Form->input('country_id',array('class'=>'custom_optionCountry defaultCntr','options'=>$theCity,'label'=>false,'default'=>$stateCook,'empty'=>"<span class='ctyName' data-cntyN='UAE' data-country=' ' >All Cities</span>"));
					    
					    ?>
                                        </div>
                                        <div class="con error"></div>
                                    </section>
                                    <section class="col-sm-7 rgt-pdng0 lft-pdng0 ">
                                        <section class="form-group  location mrgn-btm-non">  
                                            <label><?php echo __('Location_Area',true); ?></label>
                                            <?php //echo $this->Form->input('area',array('label'=>false,'type'=>'text','class'=>'form-control custom_optionLoc textbox','editable'=>false,'placeholder'=>__('Location'),'onkeyup'=>'auto_complete()','id'=>'search_auto','autocomplete'=>'off'));?>
                                            <?php echo $this->Form->input('location',
                                                    array('label'=>false,
                                                          'type'=>'text',
                                                          'class'=>'form-control custom_optionLoc textbox',
                                                          'editable'=>false,
                                                          'placeholder'=>__('Location'),
                                                          'onkeyup'=>'auto_complete()',
                                                          'id'=>'search_auto',
                                                          'autocomplete'=>'off'));?>
                                            <i class='fa  fa-map-marker'></i>
                                            <ul class="auto-search" id="area_list_id"></ul>
                                            <div class="city_err"></div>
                                        </section>
                                    </section>
                                </li>
                                <li>
                                    <section class="form-group search clearfix"> 
                                        <span class="glyphicon glyphicon-search"></span> 
                                        <?php echo $this->Form->input('service',array('label'=>false,'type'=>'text','class'=>'form-control textbox','placeholder'=>__('what_would_like_to_book'),'onkeyup'=>'auto_complete_service()','id'=>'search_auto_service'));?>
                                        <ul class="auto-search" id="service_list_id"></ul>
                                    </section>
                                </li>
                                <li>
                                    <section class="col-sm-7 lft-pdng0 salon-typ">
                                        <section class="form-group mrgn-btm-non">
                                            <?php
                                            echo $this->Form->input('service_to',array('class'=>'custom_optionType','options'=>$salon_data,'label'=>false,'empty'=>__('Service Provided To')));?>
                                        </section>
                                    </section>
                                    <section class="col-sm-5 rgt-pdng0 lft-pdng0">
                                        <section class="form-group mrgn-btm-non date">
                                            <?php echo $this->Form->input("date", array('label' => false, 'type' => 'text', 'class' => 'form-control select_date')); ?>
                                            <span  style="cursor: pointer" class="glyphicon glyphicon-calendar selectdate"></span>
                                        </section>
                                    </section>
                                </li>
                                <li>
                                    <section class="form-group">
                                        <?php echo $this->Form->input("salon_name", array('label' => false, 'type' => 'text', 'class' => 'form-control','placeholder'=>__('salon_name_opt'),'onkeyup'=>'auto_complete_salon()'));
					echo $this->Form->hidden('salon_id');
					?>
					
					<ul class="auto-search" id="salon_list_id"></ul>
				    </section>
                                </li>
                                <li class="text-center">
                                    <?php echo $this->Form->button( __('Search_Business',true), array('type' => 'button','class' => 'nextt tabs-btn'));?>
                                </li>
                        </ul>
                    <?php echo $this->Form->end() ; ?>
                </div>
                <!--- Spa Day / Break --------------------------->
                <div role="tabpanel" class="tab-pane" id="spadaystab">
                        <?php echo $this->Form->create('Search', array('url' => array('controller' => 'spabreaks', 'action' => 'index') ,'type' =>'get')) ?>
                        <input type="hidden" name="state_id_spa" id="state_id_spa" value="">
                        <input type="hidden" name="city_id_spa" id="city_id_spa" value="">
                        <input type="hidden" name="type_of_service" id="type_of_service" value="">
                        <ul class="clearfix">
                                <li>
                                    <section class="col-sm-5 lft-pdng0 customv">
                                        <label><?php echo __('City',true); ?></label>
                                        <div class="">
                                                <?php echo $this->Form->input('country_id_spa',array('class'=>'custom_optionCountry','options'=>$theCity,'label'=>false,'default'=>$stateCook,'id'=>'SearchCountryIdSpa'));?>
                                        </div>
                                        <div class="con error"></div>
                                    </section>
                                    <section class="col-sm-7 rgt-pdng0 lft-pdng0 ">
                                        <section class="form-group  location mrgn-btm-non">
                                            <label><?php echo __('Location_Area',true); ?></label>
                                            <?php echo $this->Form->input('area_spa',array('label'=>false,'type'=>'text','class'=>'form-control custom_optionLoc','editable'=>false,'placeholder'=>__('Location'),'onkeyup'=>'auto_complete_spa()','id'=>'search_auto_spa','autocomplete'=>'off'));?>
                                            <i class='fa  fa-map-marker'></i>
                                            <ul class="auto-search" id="area_list_id_spa"></ul>
                                            <div class="city_err_spa"></div>
                                        </section>
                                    </section>
                                </li>
                                <li>
                                    <section class="form-group search clearfix"> 
                                        <span class="glyphicon glyphicon-search"></span> 
                                        <?php echo $this->Form->input('service',array('label'=>false,'type'=>'text','class'=>'form-control textbox','placeholder'=>__('what_would_like_to_book'),'onkeyup'=>'auto_complete_service_break()','id'=>'search_auto_service_break'));?>
                                        <ul class="auto-search" id="service_break_list_id"></ul>
                                    </section>
                                </li>
                                <li>
                                    <section class="col-sm-7 lft-pdng0 salon-typ">
                                        <section class="form-group mrgn-btm-non">
                                            <?php
                                                //$salon_data = $this->Common->serviceprovidedTo();
                                                echo $this->Form->input('service_to_spa',array('class'=>'custom_optionType','options'=>$salon_data,'label'=>false,'empty'=>__('Service Provided To'),'id'=>'SearchServiceToSpa'));?>
                                        </section>
                                    </section>
                                    <section class="col-sm-5 rgt-pdng0 lft-pdng0">
                                        <section class="form-group mrgn-btm-non date">
                                            <?php echo $this->Form->input("date_spa", array('label' => false, 'type' => 'text', 'class' => 'form-control select_date','id'=>'SearchDateSpa')); ?>
                                            <span  style="cursor: pointer" class="glyphicon glyphicon-calendar selectdate"></span>
                                        </section>
                                    </section>
                                </li>
                                <li>
                                    <section class="form-group">
                                        <?php echo $this->Form->input("salon_name_spa", array('label' => false, 'type' => 'text', 'class' => 'form-control','placeholder'=>__('salon_name_opt'),'id'=>'SearchSalonNameSpa','onkeyup'=>'auto_complete_spabreaks()')); ?>
                                        <ul class="auto-search" id="service_list_id_spabreaks"></ul>
                                    </section>
                                </li>
                                <li class="text-center">
                                    <?php echo $this->Form->button( __('Search_Business',true), array('id'=>'search_spabreaks','type' => 'button','class' => 'next-spa tabs-btn'));?> 
                                </li>
                            </ul>
                            <?php echo $this->Form->end() ; ?>
                        </div>
                        <!--- Spa Day / Break --------------------------->  
                </div>
            </div>
        </div>
        <div class="col-sm-7 iphon-hide">
                <?php echo $this->Html->image('frontend/banner1.png',array('class'=>'banner-img'));?>
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/admin/plugins/select2/select2.min.js"></script>	<!-- jQuery easing plugin -->

<script type="text/javascript">
    $(document).ready(function(){
	var d=new Date();
	var today = d.getDate() + "/" + (d.getMonth() + 1) + "/" + d.getFullYear();
	$('.select_date').datepicker({'dateFormat': 'd/m/yy',minDate:today});
	$('.select_date').val(today);
	
	$(document).on('click','.auto_salon',function(){
		var salon_id = $(this).data('id');
		$(document).find('#SearchSalonName').val($(this).text());
		$(document).find('#salon_list_id').hide();
		$(document).find('#SearchSalonId').val(salon_id);
	});
	
	
	$('#search_spabreaks').click(function(){
		
		var forVal = $(this).closest('form');
		var chk_state = forVal.find('#search_auto_spa').val();
                var service_type_id = forVal.find('#type_of_service').val();
		var chk_country = forVal.find('#SearchCountryIdSpa').val();
		var href = '<?php echo Configure::read('BASE_URL') ; ?>';
		var country = '';
		var location = '';
                var service_type = '';
		//var treatment = '';
		var salon_type = '';
		var salon_name = '';
                var break_name_spa ='';
		var country_text = forVal.find('#SearchCountryIdSpa option:selected').text();
		theHTM = $(country_text);
		country1 = theHTM.attr('data-cntyN')+'~'+theHTM.text();
		location = chk_state;
		//treatment = forVal.find('#search_auto_service').val();
		salon_type = forVal.find('#SearchServiceToSpa').val();
		salon_name_spa = forVal.find('#SearchSalonNameSpa').val(); 
                break_name_spa = forVal.find('#search_auto_service_break').val();
		var date = forVal.find('#SearchDateSpa').val();
		var from = date.split("/");
		var f = new Date(from[2], from[1], from[0]);
		var date_string = f.getFullYear() + "-" + f.getMonth() + "-" + f.getDate();
		href += '/spabreaks/index/'+country1;
		if(location != ''){
			href += '~'+location+'/';
		}else{
			href += '/';
		}
		if(salon_type != ''){
			href += salon_type+'/';
		}else{
			href += 'serviceTo/';
		}
		if(date_string!=''){
			href += date_string+'/';
		}else{
                    href += 'date/';
                }
                if(salon_name_spa != ''){
			href += salon_name_spa+'/';
		}else{
			href += 'salon_name/';
		}       
                if(break_name_spa != ''){
			href += break_name_spa+'/';
		}else{
			href += 'spabreak_name/';
		}
		href = href.trim();
		href = href.replace(/\s/g,"-");
		window.location.href = href;
		
	});
	
	
	
	$('.nextt').click(function(){
		var forVal = $(this).closest('form');
		var chk_state = forVal.find('#search_auto').val();
		var chk_country = forVal.find('#SearchCountryId').val();
		var href = '<?php echo Configure::read('BASE_URL') ; ?>';
		var country = '';
		var location = '';
		var treatment = '';
		var salon_type = '';
		var salon_name = '';
		var country_text = forVal.find('#SearchCountryId option:selected').text();
		theHTM = $(country_text);
		country = theHTM.attr('data-cntyN')+'~'+theHTM.text();
		location = chk_state;
		treatment = forVal.find('#search_auto_service').val();
		salon_type = forVal.find('#SearchServiceTo').val();
		salon_name = forVal.find('#SearchSalonName').val();
		var date = forVal.find('#SearchDate').val();
		var from = date.split("/");
		var f = new Date(from[2], from[1], from[0]);
		var date_string = f.getFullYear() + "-" + f.getMonth() + "-" + f.getDate();
		href += '/search/index/'+country;
		if(location != ''){
			href += '~'+location+'/';
		}else{
			href += '/';
		}
		if(salon_type != ''){
			href += salon_type+'/';
		}else{
			href += 'serviceTo/';
		}
		if(date_string){
			href += date_string+'/';
		}
		if(treatment != ''){
			href += treatment;
		}
		if(salon_name != ''){
			href += '~'+salon_name;
		}
		href = href.trim();
		href = href.replace(/\s/g,"-");
		window.location.href = href;
		
		});
	});
	/* Search Salon */
	$('#search_auto').focusout(function() {
		var isHovered = $('#area_list_id').is(":hover");
		if(!isHovered){
		       $('#area_list_id').css('display','none');
		}
		
	});
/* End Search Salon */
/* Search Spa */
$('#search_auto_spa').focusout(function() {
	var isHovered = $('#area_list_id_spa').is(":hover");
	if(!isHovered){
	       $('#area_list_id_spa').css('display','none');
	}
});
/* End Search Spa */

$('#search_auto_service').focusout(function() {
	var isHovered = $('#service_list_id').is(":hover");
	if(!isHovered){
	       $('#service_list_id').css('display','none');
	}
});

$('#SearchSalonName').focusout(function() {
	var isHovered = $('#salon_list_id').is(":hover");
	if(!isHovered){
	       $('#salon_list_id').css('display','none');
	}
});

/*** Hide Autocomplete ******/
 $('#search_auto_service').click(function(){
	$('#area_list_id').html('');
});
 
$('#search_auto').click(function(){
	$('#service_list_id').html('');
});
$('#search_auto_spa').click(function(){
	$('#service_list_id_spa').html('');
});

/*** Hide Autocomplete ******/
$('.custom_optionCountry').change(function(){
	$('#area_list_id').html('');
	$('#area_list_id').css('display','none');
});
/*** Hide Autocomplete SPA ******/
$('.custom_optionCountry').change(function(){
	$('#area_list_id_spa').html('');
	$('#area_list_id_spa').css('display','none');
});
/*************SPA DAY AND BREAK *******************/

// auto_complete : this function will be executed every time we change the text
function auto_complete_spa(){
        $('#area_list_id_spa').hide();
        $('#area_list_id_spa').html();
        var response = true;
        var keyword = $('#search_auto_spa').val();
        if(keyword == ''){
                keyword = 'null';
        }
        var getCountry = $('#SearchCountryIdSpa').val();
        if(getCountry != ''){
                $('.con').html('');
                var getURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'autosearch','admin'=>false)); ?>";
                $.ajax({
                        url: getURL+'/'+keyword+'/'+getCountry+'/1',	
                        type: 'GET',
                        beforeSend: function() {
                        },
                        success:function(data){
                                $('#area_list_id_spa').hide();
                                if(data == ''){
                                        $('#area_list_id_spa').hide();
                                        $('#area_list_id_spa').html('');
                                }else{
                                        $('#area_list_id_spa').show();
                                        $('#area_list_id_spa').html(data);

                                }
                        }
                });
        } else{
                $('.con').html('Please Select Country');
                $('#search_auto_spa').val('');
        }
        if(response = false){
                $('#area_list_id_spa').hide();
        }
}



function auto_complete(){
        $('#area_list_id').hide();
        $('#area_list_id').html();
        var response = true;
        var keyword = $('#search_auto').val();
        if(keyword == ''){
                keyword = 'null';
        }
        var getCountry = $('#SearchCountryId').val();
        if(getCountry != ''){
                $('.con').html('');
                var getURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'autosearch','admin'=>false)); ?>";
                $.ajax({
                        url: getURL+'/'+keyword+'/'+getCountry,	
                        type: 'GET',
                        beforeSend: function() {
                        },
                        success:function(data){
                                $('#area_list_id').hide();
                                if(data == ''){
                                        $('#area_list_id').hide();
                                        $('#area_list_id').html('');
                                }else{
                                        $('#area_list_id').show();
                                        $('#area_list_id').html(data);

                                }
                        }
                });
        } else{
                $('.con').html('Please Select Country');
                $('#search_auto').val('');
        }
        if(response = false){
                $('#area_list_id').hide();
        }
}

// function to get list of all saloon and spa break
function auto_complete_spabreaks(){
    $('#service_list_id_spabreaks').hide();
    var stateID = $(document).find('#SearchCountryIdSpa option:selected').val();
    var keyword = $('#SearchSalonNameSpa').val();
    var getURL = "<?php echo $this->Html->url(array('controller'=>'spabreaks','action'=>'getallsaloons','admin'=>false)); ?>";
            $.ajax({
               url: getURL+'/'+keyword+'/'+stateID,	
               type: 'GET',
               beforeSend: function() {
            },
            success:function(data){
                $('#service_list_id_spabreaks').show();
                $('#service_list_id_spabreaks').html(data);

            }
    });
}

function auto_complete_service(){
        $('#service_list_id').hide();
        $('#service_list_id').html();
        var keyword = $('#search_auto_service').val();
        var getURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'autosearchservice','admin'=>false)); ?>";
                $.ajax({
                   url: getURL+'/'+keyword,	
                   type: 'GET',
                   beforeSend: function() {
                },
                success:function(data){
                        $('#service_list_id').hide();
                        if(data == ''){
                                $('#service_list_id').hide();
                                $('#service_list_id').html('');
                        }else{
                                $('#service_list_id').show();
                                $('#service_list_id').html(data);
                        }
                }
        });
}

function auto_complete_salon(){
        $('#salon_list_id').hide();
        $('#salon_list_id').html();
        var keyword = $('#SearchSalonName').val();
	var country = $('#SearchCountryId').val();
	var cityId = $('#city_id').val();
	//alert(country);
	if(country=='' || country==null){
	 country='null';	
	}
        var getURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'autosearchsalon','admin'=>false)); ?>";
                $.ajax({
                   url: getURL+'/'+country+'/'+keyword+'/'+cityId,	
                   type: 'GET',
                   beforeSend: function() {
                },
                success:function(data){
                        $('#salon_list_id').hide();
                        if(data == ''){
                                $('#salon_list_id').hide();
                                $('#salon_list_id').html('');
                        }else{
                                $('#salon_list_id').show();
                                $('#salon_list_id').html(data);
                        }
                }
	 });
}



function auto_complete_service_break(){
    $('#service_break_list_id').hide();
    var stateID = $(document).find('#SearchCountryIdSpa option:selected').val();
    var keyword = $('#search_auto_service_break').val();
    var getURL = "<?php echo $this->Html->url(array('controller'=>'spabreaks','action'=>'getallbreaks','admin'=>false)); ?>";
            $.ajax({
               url: getURL+'/'+keyword+'/'+stateID,	
               type: 'GET',
               beforeSend: function() {
            },
            success:function(data){
                $('#service_break_list_id').show();
                $('#service_break_list_id').html(data);

            }
    });
}
function set_userservice(item){
   vals = item.split(",");
   $("#search_auto_service").val(vals[1]);
   $("#service_id").val(vals[0]);
   $('#service_list_id').hide();
}

function set_useritem(item){
   vals = item.split(",");
   $('#city_id').val(vals[0]);
   $("#search_auto").val(vals[1]);
   $('#area_list_id').hide();
}


function set_useritem_spa(item){
   vals = item.split(",");
   $('#city_id_spa').val(vals[0]);
   $("#search_auto_spa").val(vals[1]);
   $('#area_list_id_spa').hide();
}

function set_searchitem(item){
    var type = item.split('__').pop();
    var value=item.slice(0, -3);
    $('#type_of_service').val(type);
    $('#SearchSalonNameSpa').val(value);
    $('#service_list_id_spabreaks').hide('slow');
}

function set_searchitem_break(item){
    var type = item.split('__').pop();
    var value=item.slice(0, -3);
    $('#type_of_service').val(type);
    $('#search_auto_service_break').val(value);
    $('#service_break_list_id').hide('slow');
}

$(function() {
    $( ".select_date" ).datepicker();
});
function formatFlags(state){
	//console.log(state);
        if (!state.id) return state.text;
        toHTML = $( state.text );
	//console.log(toHTML);
        var countryId = toHTML.attr('data-country');
        var countryTitle = toHTML.attr('data-cntyN');
        return "<img style='padding-right:10px;' class='pos-rgt flag' src='/img/flags/" + countryId.toLowerCase() + ".gif'/><span class='state-name' >" + toHTML.html() + ", "+countryTitle+"</span>";
}

$(document).find(".custom_optionCountry").select2({
        formatResult    : formatFlags,
        formatSelection : formatFlags,
        escapeMarkup: function(m) { return m; }
}).on('open', function(){
        $(document).find('.customv .input.select').addClass('purple-bod');
}).on('close',function(){
        $(document).find('.customv .input.select').removeClass('purple-bod');
});
$(document).find(".custom_optionType").select2({}).on('open', function(){
        $(document).find('.salon-typ .input.select').addClass('purple-bod');

}).on('close',function(){
   $(document).find('.salon-typ .input.select').removeClass('purple-bod');
});
$(".custom-select").each(function(){
    $(this).wrap("<span class='select-wrapper pull-right'></span>");
    $(this).after("<span class='holder'></span>");
});
$(".custom_option").each(function(){
        $(this).wrap("<span class='option_wrapper'></span>");
        $(this).after("<span class='holder'></span>");
});
$(".custom_option").change(function(){
    var selectedOption = $(this).find(":selected").text();
    $(this).next(".holder").text(selectedOption);
}).trigger('change');
$(document).on('blur , focus','#search_auto_service', function(e){
        if((e.type=='focusin')){
                $('.search').addClass('purple-bod');
        }else{ 
                $('.search').removeClass('purple-bod')
        }  
});
$(document).on('blur , focus','#SearchDate', function(e){
        if((e.type=='focusin')){
                $(this).parent().parent('.date').addClass('purple-bod');
        }else{ 
                $(this).parent().parent('.date').removeClass('purple-bod');
        }  
})

function getLocation() {
        navigator.geolocation.getCurrentPosition(showPosition);
}




function showPosition(position) {
        var lat = position.coords.latitude;
        var lon = position.coords.longitude;
      
        $.ajax({
                url: "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'getLocation'))?>",
                type: "POST",
                data: {lat:lat,lng: lon},// Ajman state coordinates
                success: function(res) {
                        var data 	= jQuery.parseJSON(res);
                        if(data !=''){
				Country     = data[0].countries.id;
                                State       = data[0].states.id;
                                City        = data[0].cities.id;
                                IsoCode     = data[0].countries.iso_code;
				if (State) {
                                        $("#SearchCountryId option").removeAttr("selected");
                                        $("#SearchCountryId option[value="+State+"]").attr("selected","selected").trigger('change');
					createCookie('State', State, 10);
				 }
				
                                //setTimeout(function(){
					var test = $(document).find('#sform .dynamiccity');
					$("#SearchCountryId").select2({
						formatResult    : formatFlags,
						formatSelection : formatFlags,
						escapeMarkup: function(m) { return m; }
					});	
				//},1000)
				

                        } else{
//				 $("#SearchCountryId option").removeAttr("selected");
//                                 $("#SearchCountryId option[value="+5002+"]").attr("selected","selected").trigger('change');
//				 createCookie('State',5002, 10);
//                               var test = $(document).find('#sform .dynamiccity');
//				$("#SearchCountryId").select2({
//					formatResult    : formatFlags,
//					formatSelection : formatFlags,
//					escapeMarkup: function(m) { return m; }
//				});
                        }
                }
        });
}
$(document).ready(function(){
	//alert(readCookie('State'));
	var StateCookie = '<?php echo $stateCook;?>';
	
	  if(StateCookie != 'not_set'){
		
	}
	else{
		getLocation();
	}
        //getLocation();/****** Uncomment this for live site ****/
        //showPosition(); /****** COMMENT THIS FOR LIVE SITE *******/
})
</script>
<style type="text/css">
.auto-search {padding: 0;max-height: 10.5em; overflow-y: auto;border: 1px solid #eaeaea;background: #f3f3f3;list-style: none;}
.auto-search li {padding: 2px;cursor: pointer}
.auto-search li:hover{background: #ddd;}
#service_list_id {padding: 0;max-height: 10.5em; overflow-y: auto;border: 1px solid #eaeaea;background: #f3f3f3;list-style: none;}
#service_list_id li {padding: 2px;cursor: pointer}
#service_list_id li:hover{background: #bababa;}
.con{font-size:11px;color:red;}
.city_err{font-size:11px;color:red;}
.select2-container .select2-choice span {
	display: inline;
}
</style>