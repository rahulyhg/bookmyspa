<script>
$(document).ready(function(){
    var $modal = $('#commonSmallModal');
    var list = [3,4];
    var itsId  = "";
    
    $(document).on('click','.delete_location' ,function(){
        var itsId = $(this).closest('tr').attr('data-id');
        if(confirm('Are you sure, you want to delete this location?')){
            $.ajax({
            url: "<?php echo $this->Html->url(array('controller'=>'Locations','action'=>'delete')); ?>",
            type:'POST',
            data:{'id': itsId }
            }).done(function(response){ 
                var data = jQuery.parseJSON(response); 
                if(data.data == 'success'){ 
                    $(".productTypedataView").load("<?php echo $this->Html->url(array('controller'=>'Locations','action'=>'index',base64_encode($countryId),base64_encode($stateId))); ?>", function() {
                        //datetableReInt($(document).find('.productTypedataView').find('table'),list);
                    });
		    
		    //$.post("/admin/products/list_location");
                }
                //onResponseBoby(response);
            });
        }
    });
    var chkPtyp = true;
    $(document).on('click','.addedit_location' ,function(){
        var itsId = $(this).attr('data-id');
        var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Locations','action'=>'add',$countryId,$stateId)); ?>";
        addeditURL = addeditURL+'/'+itsId
        // function in modal_common.js
        fetchModal($modal,addeditURL,'LocationAdminAddProducttypeForm');
        chkPtyp = true;
    });
    $modal.on('click', '.update', function(e){
        var theBtn = $(this);
	buttonLoading(theBtn);
        var options = { 
            //beforeSubmit:  showRequest,  // pre-submit callback 
            success:function(res){
                buttonSave(theBtn);
		theBtn.addClass('rqt_already_sent');
                // onResponse function in modal_common.js
                if(onResponse($modal,'Location',res)){
                    $(".productTypedataView").load("<?php echo $this->Html->url(array('controller'=>'Locations','action'=>'index',base64_encode($countryId),base64_encode($stateId))); ?>", function() {
                        //datetableReInt($(document).find('.productTypedataView').find('table'),list);
                    });    
                }else{
                    chkPtyp = true;
                }
            }
        };
        if(!theBtn.hasClass('rqt_already_sent')){
            $('#LocationAdminAddForm').submit(function(){
		$(this).ajaxSubmit(options);
                /*if(tagchk){
                    theBtn.addClass('rqt_already_sent');
                    $(this).ajaxSubmit(options);
                    chkPtyp = true;
                }*/
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        }
        setTimeout(function(){
            if($modal.find('dfn.text-danger').length > 0){
                $modal.find('div.tab-pane').removeClass('active');
                $modal.find('div.tab-pane#tab1').addClass('active');
                $modal.find('ul.nav li').removeClass('active');
                $modal.find('ul.nav a[href=#tab1]').closest('li').addClass('active');
                buttonSave(theBtn);
            }
        },500);
        
    });
    $(document).on('click','.changeStatus',function(){
            var theJ = $(this);
            var theId = theJ.closest('tr').attr('data-id');
            var statusTo = theJ.attr('data-status');
            
            $.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url(array('controller'=>'Locations','action'=>'locationchangeStatus','admin'=>true));?>",
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
    //datetableReInt($(document).find('.productTypedataView').find('table'),list);
   //var list = [3,4];
});

</script>
<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                   Locations
                </h3>
                <?php 
                 echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_location pull-right'));?>
            </div>
            <div class="box-content">
                <div class="productTypedataView" id="list-types">
		    
                    <?php echo $this->element('admin/list_locations'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php //echo $this->element('sql_dump'); ?>