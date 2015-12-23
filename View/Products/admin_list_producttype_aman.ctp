<script>
$(document).ready(function(){
    var $modal = $('#commonSmallModal');
    var list = [4];
    var itsId  = "";
    
    $(document).on('click','.view_producttype' ,function(){
        var itsId = $(this).closest('tr').attr('data-id');
        var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Products','action'=>'viewProducttype')); ?>";
        var $bigmodal = $('#commonContainerModal');
        addeditURL = addeditURL+'/'+itsId
        // function in modal_common.js
        fetchModal($bigmodal,addeditURL);
    });
    
    $(document).on('click','.delete_producttype' ,function(){
        var itsId = $(this).closest('tr').attr('data-id');
        if(confirm('Are you sure, you want to delete this product type?')){
            $.ajax({
            url: "<?php echo $this->Html->url(array('controller'=>'products','action'=>'deleteProducttype')); ?>",
            type:'POST',
            data:{'id': itsId }
            }).done(function(response){
                var data = jQuery.parseJSON(response);
                if(data.data == 'success'){
                     $(".productTypedataView").load("<?php echo $this->Html->url(array('controller'=>'Products','action'=>'list_producttype')); ?>", function() {
                        datetableReInt($(document).find('.productTypedataView').find('table'),list);
                    });
                }
                onResponseBoby(response);
            });
        }
    });
    var chkPtyp = true;
    $(document).on('click','.addedit_producttype' ,function(){
        var itsId = $(this).attr('data-id');
        var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Products','action'=>'addProducttype')); ?>";
        addeditURL = addeditURL+'/'+itsId
        // function in modal_common.js
        fetchModal($modal,addeditURL,'ProductTypeAdminAddProducttypeForm');
        chkPtyp = true;
    });
    $modal.on('click', '.update', function(e){
        var theBtn = $(this);
	buttonLoading(theBtn);
            
        var options = { 
            //beforeSubmit:  showRequest,  // pre-submit callback 
            success:function(res){
                buttonSave(theBtn);
                // onResponse function in modal_common.js
                if(onResponse($modal,'ProductType',res)){
                    $(".productTypedataView").load("<?php echo $this->Html->url(array('controller'=>'products','action'=>'list_producttype')); ?>", function() {
                        datetableReInt($(document).find('.productTypedataView').find('table'),list);
                    });    
                }else{
                    chkPtyp = true;
                }
            }
        };
        if(!theBtn.hasClass('rqt_already_sent')){
            $('#ProductTypeAdminAddProducttypeForm').submit(function(){
                if(tagchk){
                    theBtn.addClass('rqt_already_sent');
                    $(this).ajaxSubmit(options);
                    chkPtyp = true;
                }
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
    
    datetableReInt($(document).find('.dataTable'),list);
});

</script>


<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                     Product Types
                </h3>
                <?php 
                 echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_producttype pull-right'));?>
            </div>
            <div class="box-content">
                <div class="productTypedataView">
                    <?php echo $this->element('admin/Products/list_product_types'); ?>
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
                url: "<?php echo $this->Html->url(array('controller'=>'Products','action'=>'producttypechangeStatus','admin'=>true));?>",
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