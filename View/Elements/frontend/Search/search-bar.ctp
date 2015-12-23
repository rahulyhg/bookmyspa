<?php
	$state = $key = '';
	if(!empty($location)){
		$state = explode('~',$location);
		$new_array = array();
		$new_array = $theCity;
		array_walk($new_array, function(&$item, $key){
			$item = strip_tags($item);
		});
		$state = str_replace("-", " ", $state[1]);
		$key = array_search($state, $new_array);	
		
	}
	
	echo $this->Form->create('User', array('type' => 'post'), array(
		'url' => array('controller' => 'search', 'action' => 'index')
));
	
    

?>
<!--<input type="hidden" name="service_id" class="filter_service" value="">-->
<input type="hidden" name="type_of_search" class="type_of_search" value="">
<div class="main-search">
  <div class="search-box">
      <div class="city-search"> 
        <span class="dynamiccity">
		<?php
		
		if(empty($theCity)){
			
			$countryData = $this->Common->getCountryStates();
			$theCity = array();
			foreach($countryData as $country){
				if(!empty($country['State'])){
					foreach($country['State'] as $key=>$thecty){
							$theCity[$thecty['id']] = "<span class='ctyName' data-cntyN='".$country['Country']['title']."' data-country='".$country['Country']['id']."' >{$thecty['name']}</span>";
	
					}
				}
			}
		
			echo $this->Form->input('country_id',array('class'=>'country custom_optionCountry','options'=>@$theCity,'label'=>false,'value'=>@$stateId,'default'=>$stateCook,'empty'=>'All Cities'));
		}else {
			echo $this->Form->input('country_id',array('class'=>'country custom_optionCountry','options'=>@$theCity,'label'=>false,'value'=>@$stateId,'default'=>$stateCook,'empty'=>'All Cities'));?>
		<?php }
		
		//echo $stateId;
		//echo $key;
		//exit;
		
		
		?>
	</span>
      </div>
     <div class="key-search">
        <input id="key_search" type="search" name="search" value="" placeholder="I am looking for...">
	<input id="city" type="hidden" name="city" value="">
	<input id="category" type="hidden" name="category" value="">
	<input id="newservice" type="hidden" name="newservice" value="">
	<input id="serviceCategoryId" type="hidden" name="serviceCategoryId" value="">
        <ul style="display: none;max-height: 223px;" class="auto-search main-auto-search scrolling" id="fullsearch"></ul>
     </div>
       <input type="button" name="service" id="submit_top" value="Search">
  </div>
  
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
</button>
</div>
  <script type="text/javascript" src="/js/admin/plugins/select2/select2.min.js"></script>	
  <!-- jQuery easing plugin -->
<?php
//pr($this->params); exit;
if(($this->params['controller'] != 'search')){ ?>
		<script type="text/javascript">
			$(document).ready(function(){
				//googleDiasbaleCheck = '<?php if(isset($disableGoogle)){ echo $disableGoogle;} ?>';
				var StateCookie = '<?php echo $stateCook;?>';
				
				  if(StateCookie != 'not_set'){
					//alert('sdf');
                                        //setTimeout(function(){
                                        //    var State = StateCookie;
                                        //    $("#UserCountryId option").removeAttr("selected");
                                        //    $("#UserCountryId option[value="+State+"]").attr("selected","selected").trigger('change');
                                        //    var test = $(document).find('#UserIndexForm .dynamiccity');
                                        //                            test.find('select').select2({
                                        //                                    formatResult    : formatFlags,
                                        //                                    formatSelection : formatFlags,
                                        //                                    escapeMarkup: function(m) { return m; }
                                        //                });
                                        //            submit_form();		
                                        //},1000);
                                    }
                                    else{
					 getLocation();
				    }
			});
		</script>
	<?php } ?>
<script type="text/javascript">
	
	
	
	
	function formatFlags(state){
		if (!state.id) return state.text;
		toHTML = $( state.text );
		var countryId = toHTML.attr('data-country');
		var countryTitle = toHTML.attr('data-cntyN');
		return "<img style='padding-right:10px;' class='pos-rgt flag' src='/img/flags/" + countryId.toLowerCase() + ".gif'/><span class='state-name' >" + toHTML.html() + ", "+countryTitle+"</span>";
	}
	
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
								$("#UserCountryId option").removeAttr("selected");
								$("#UserCountryId option[value="+State+"]").attr("selected","selected").click();
								createCookie('State', State, 10);
						}
						var test = $(document).find('#UserIndexForm .dynamiccity');
						test.find('select').select2({
								formatResult    : formatFlags,
								formatSelection : formatFlags,
								escapeMarkup: function(m) { return m; }
						});
					submit_form();
					} else{
						   //createCookie('State', 0, 10);
					}
				}
		});
	} 

    $(document).ready(function(){
		
		
		$(document).find(".custom_optionCountry").select2({
			formatResult    : formatFlags,
			formatSelection : formatFlags,
			escapeMarkup: function(m) { return m; }
					
		}); 
		$(document).find(".scrolling").mCustomScrollbar({
			advanced:{updateOnContentResize: true}
		});	
	
    })
</script>
