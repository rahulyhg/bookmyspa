<script>
    $(document).ready(function(){
        
        var addCountryURL = "<?php echo $this->Html->url(array('controller'=>'Countries','action'=>'addedit_Country','admin'=>true)); ?>";
        var countryList = "<?php echo $this->Html->url(array('controller'=>'Countries','action'=>'index','admin'=>true)); ?>";
        var $modal = $('#commonSmallModal');
        var list = [0,7,8,9];
        var itsId  = "";
        $(document).on('click','.addedit_Country' ,function(){
            var itsId = $(this).attr('data-id');
            $('body').modalmanager('loading');
            // function in modal_common.js
            fetchModal($modal,addCountryURL+'/'+itsId,'CountryAdminAddeditCountryForm');
        });
    
    
        $modal.on('click', '.saveCountry', function(e){
            var options = { 
                //beforeSubmit:  showRequest,  // pre-submit callback 
                success:function(res){
                    // onResponse function in modal_common.js
                    if(onResponse($modal,'Country',res)){
                        $(".countrydataView").load(countryList, function() {
                            datetableReInt($(document).find('.countrydataView').find('table'),list);
                        });    
                    }
                }
            }; 
            $modal.find('#CountryAdminAddeditCountryForm').submit(function(){
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
    
        
        datetableReInt($(document).find('.dataTable'),list);

    });
</script>
<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Country
                </h3>
                <?php 
                 //echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_Country pull-right'));?>
            </div>
            <div class="box-content">
                <div class="countrydataView">
                    <?php echo $this->element('admin/Country/list_country'); ?>
                </div>
            </div>    
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(document).on('click','.changeStatus',function(){
            var theJ = $(this);
            var theId = theJ.closest('tr').attr('data-id');
            var statusTo = theJ.attr('data-status');
            
            $.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url(array('controller'=>'Countries','action'=>'changeStatus','admin'=>true));?>",
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
        })
    });
</script>