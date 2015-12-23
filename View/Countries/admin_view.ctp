<script>
    $(document).ready(function(){
        
        var addCountryURL = "<?php echo $this->Html->url(array('controller'=>'Countries','action'=>'addedit_State','admin'=>true,base64_encode($id))); ?>";
        var addCityURL  = "<?php echo $this->Html->url(array('controller'=>'Countries','action'=>'addedit_City','admin'=>true,base64_encode($id))); ?>";
        var countryList = "<?php echo $this->Html->url(array('controller'=>'Countries','action'=>'view','admin'=>true,base64_encode($id),$title)); ?>";
        var $modal = $('#commonSmallModal');

        var itsId  = "";
        $(document).on('click','.addedit_State' ,function(){
            var itsId = $(this).attr('data-id');
            $('body').modalmanager('loading');
            // function in modal_common.js
            fetchModal($modal,addCountryURL+'/'+itsId,'CountryAdminAddeditStateForm');
        });
        
        var cityId  = "";
        $(document).on('click','.addedit_City' ,function(){
            var stateId = $(this).attr('data-state');
            var cityId = $(this).attr('data-id');
            $('body').modalmanager('loading');
            // function in modal_common.js
            fetchModal($modal,addCityURL+'/'+stateId+'/'+cityId);
        });
    
        var citiesURL='';    
        $(document).on('click','.view_Cities' ,function(e){
            e.preventDefault();
            $('body').modalmanager('loading');
            citiesURL = $(this).attr('href');
            $(document).find(".listCities").load(citiesURL, function() {
                    var list = [0,3,4,6];
                    datetableReInt($(document).find('.listCities').find('table'),list);
                    $('body').modalmanager('loading');
                });    
        });
        
        
        $modal.on('click', '.saveCity', function(e){
            var options = { 
                //beforeSubmit:  showRequest,  // pre-submit callback 
                success:function(res){
                    // onResponse function in modal_common.js
                    if(onResponse($modal,'City',res)){
                        $(document).find(".listCities").load(citiesURL, function() {
                            var list = [4,5];
                            datetableReInt($(document).find('.listCities').find('table'),list);
                        });    
                    }
                }
            }; 
            $modal.find('#CountryAdminAddeditCityForm').submit(function(){
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
        
        $modal.on('click', '.saveState', function(e){
            var options = { 
                //beforeSubmit:  showRequest,  // pre-submit callback 
                success:function(res){
                    // onResponse function in modal_common.js
                    if(onResponse($modal,'State',res)){
                        $(".statedataView").load(countryList, function() {
                            var list = [2,3];
                            datetableReInt($(document).find('.statedataView').find('table'),list);
                        });    
                    }
                }
            }; 
            $modal.find('#CountryAdminAddeditStateForm').submit(function(){
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
    
        var list = [2,3];
        datetableReInt($(document).find('.dataTable'),list);

    });
</script>
<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    City List
                </h3>
                <?php 
                 echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New City</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_State pull-right'));?>
            </div>
            <div class="box-content">
                <div class="statedataView forCheck clearfix row-fluid">
                    <?php echo $this->element('admin/Country/list_states'); ?>
                </div>
                <div class="box box-color box-bordered clearfix  listCities">
                
                </div>
            </div>    
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        
        $(document).on('click','.changeStatus',function(){
            if($(this).closest('div.forCheck').hasClass('statedataView')){
                var theJ = $(this);
                var theId = theJ.closest('tr').attr('data-id');
                var statusTo = theJ.attr('data-status');
                
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->Html->url(array('controller'=>'Countries','action'=>'statechangeStatus','admin'=>true));?>",
                    data: { id: theId, status: statusTo }
                })
                .done(function( msg ) {
                    if(msg == 0){
                        theJ.closest('td').html('<?php echo $this->Common->theStatusImage(0); ?>')
                    }
                    else{
                        theJ.closest('td').html('<?php echo $this->Common->theStatusImage(1); ?>')
                    }
                });
            }
            
            if($(this).closest('div.forCheck').hasClass('citiesdataView')){
                var theJ = $(this);
                var theId = theJ.closest('tr').attr('data-id');
                var statusTo = theJ.attr('data-status');
                
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->Html->url(array('controller'=>'Countries','action'=>'citychangeStatus','admin'=>true));?>",
                    data: { id: theId, status: statusTo }
                })
                .done(function( msg ) {
                    if(msg == 0){
                        theJ.closest('td').html('<?php echo $this->Common->theStatusImage(0); ?>')
                    }
                    else{
                        theJ.closest('td').html('<?php echo $this->Common->theStatusImage(1); ?>')
                    }
                });
            }
        })
    });
</script>