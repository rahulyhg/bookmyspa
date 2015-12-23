<script>
$(document).ready(function(){
    var $modal = $('#commonSmallModal');
    var itsId  = "";
    var list = [2,3];
    var chkBrand = true;
    $(document).on('click','.addedit_brand' ,function(){
        var itsId = $(this).attr('data-id');
        var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Products','action'=>'add_brand')); ?>";
        addeditURL = addeditURL+'/'+itsId
        fetchModal($modal,addeditURL,'BrandAdminAddBrandForm');
        chkBrand = true;
    });
    $(document).on('click','.view_brand' ,function(){
        var itsId = $(this).closest('tr').attr('data-id');
        var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Products','action'=>'view_brand')); ?>";
        var $bigmodal = $('#commonContainerModal');
        addeditURL = addeditURL+'/'+itsId
        fetchModal($bigmodal,addeditURL);
    });
    
    $(document).on('click','.delete_brand' ,function(){
        var itsId = $(this).closest('tr').attr('data-id');
        if(confirm(' Are you sure, you want to delete this brand?')){
            $.ajax({
            url: "<?php echo $this->Html->url(array('controller'=>'products','action'=>'deleteBrand')); ?>",
            type:'POST',
            data:{'id': itsId }
            }).done(function(response){
                var data = jQuery.parseJSON(response);
                if(data.data == 'success'){
                     $(".branddataView").load("<?php echo $this->Html->url(array('controller'=>'Products','action'=>'list_brands')); ?>", function() {
                        datetableReInt($(document).find('.branddataView').find('table'),list);
                    });
                }
                onResponseBoby(response);
            });
        }
    });
    $modal.on('click', '.update', function(e){
	var theBtn = $(this);
	//count='';
	//count=$('input.check-count:checked').length;
	//eng_name=$('#BrandEngName').val();
	//status=$('#BrandStatus').val();
	//alert(status);
	//if (count==0 && eng_name!='' && status!='') {
	  //  $(".test-error").html("Error");
	   // return false;
//	}
//	else{
//	   $(".test-error").html(""); 
//	}
	buttonLoading(theBtn);
	
        //alert(count);
        var options = { 
            //beforeSubmit:  showRequest,  // pre-submit callback 
            success:function(res){
                buttonSave(theBtn);
                // onResponse function in modal_common.js
                if(onResponse($modal,'Brand',res)){
                    $(".branddataView").load("<?php echo $this->Html->url(array('controller'=>'products','action'=>'list_brands')); ?>", function() {
                        
                        datetableReInt($(document).find('.branddataView').find('table'),list);
                    });    
                }
            }
        };
        if(!theBtn.hasClass('rqt_already_sent')){
            $('#BrandAdminAddBrandForm').submit(function(){
                if(chkBrand){
                    theBtn.addClass('rqt_already_sent');
                    $(this).ajaxSubmit(options);
                    chkBrand = false;
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
                     Brands
                </h3>
                <?php 
                 echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_brand pull-right'));?>
            </div>
            <div class="box-content">
                <div class="branddataView">
                    <?php echo $this->element('admin/Products/list_brands'); ?>
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
                url: "<?php echo $this->Html->url(array('controller'=>'Products','action'=>'brandchangeStatus','admin'=>true));?>",
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

