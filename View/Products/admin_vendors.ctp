<style>
    .pull-right.btn {
    margin-right: 4px;
}
</style>

<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    <?php echo __('Vendor List'); ?>
                </h3>
                <?php 
                 echo $this->Html->link('<i class="icon-plus"></i> Add Vendor','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_vendor pull-right btn'));?>
               <?php 
                 echo $this->Html->link('<i class="icon-list-alt"></i> Export',array('action'=>'export_vendor','controller'=>'products','admin'=>true),array('data-id'=>'','escape'=>false,'class'=>'pull-right btn'));?>
           <?php echo $this->Html->link(
            '<i class="glyphicon-print"></i>&nbsp;Print',
            'javascript:void(0)', array(
                'target'=>'_blank',
                'escape'=>false,
                'class'=>'pull-right btn',
                'onClick'=>"window.open('/admin/products/print_vendor', 'windowname','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=900,height=300'); return false;"
            )); ?> 
            </div>
            <div class="box-content">
                <div class="vendordataView">
                    <?php echo $this->element('admin/Products/vendors'); ?>    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
	var $modal = $('#commonSmallModal');
    var $modal1 = $('#commonContainerModal');
    var itsId  = "";
    var list = [4,5];
    datetableReInt($(document).find('.vendordataView').find('table'),list); 
    
    var chkVendor = true;
    $(document).on('click','.addedit_vendor' ,function(){
        var itsId = $(this).attr('data-id');
        var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Products','action'=>'add_vendor','admin'=>true)); ?>";
        addeditURL = addeditURL+'/'+itsId
        fetchModal($modal,addeditURL,'VendorAdminAddVendorForm');
        chkVendor = true;
    });
        
        
    $modal.on('click', '.add_update', function(e){
        var theBtn = $(this);
	buttonLoading(theBtn);
        
        var options = { 
            success:function(res){
                buttonSave(theBtn);
                if(onResponse($modal,'Vendor',res)){
                    $(".vendordataView").load("<?php echo $this->Html->url(array('controller'=>'Products','action'=>'vendors','admin'=>true)); ?>", function() {
                        datetableReInt($(document).find('.vendordataView').find('table'),list);
                    });    
                }else{
                    chkVendor = true;
                }
            }
        };
        if(!theBtn.hasClass('rqt_already_sent')){
            $('#VendorAdminAddVendorForm').submit(function(){
                if(chkVendor){
                    theBtn.addClass('rqt_already_sent');
                    $(this).ajaxSubmit(options);
                    chkVendor = false;
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
     
  
    
    $modal.on('change','#VendorCountry',function() {
       var id = $(this).val();
       var country = $(this).children("option").filter(":selected").text();
        $.ajax({url: "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getPhoneCode','admin'=>false))?>"+'/'+id,
               success: function(res) {
               $modal.find('.cPHcd').val(res);
               }
           });

    });
    

     /*********************Ajax code to delete Vendor **********************************/  
        $(document).on('click','.delete_vendor', function(){
            $this =  $(this);  
            itsId = $(this).data('id');
            deleteUrl = "<?php echo $this->Html->url(array('controller'=>'Products','action'=>'delete_vendor','admin'=>true)); ?>";
            deleteUrl = deleteUrl+'/'+itsId;
	     if(confirm(' Are you sure, you want to delete this vendor?')){
		$.ajax({
		    url:deleteUrl,
		    success:function(result){
			$(".vendordataView").load("<?php echo $this->Html->url(array('controller'=>'Products','action'=>'vendors')); ?>", function() {
                        //datetableReInt($(document).find('.productTypedataView').find('table'),list);
                    });
		    },
		});
	     }
        });
        
       // datetableReInt($(document).find('.vendordataView').find('table'),list); 
    });
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
     /*********************Validation for phone number **********************************/  
    $(document).on('keyup','.numOnly' ,function(){
        var value = $(this).val();
        if(isNaN(value)){
            $(this).val('');
        }
    });   
</script>   
