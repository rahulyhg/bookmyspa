<style>
.pull-right.btn {
    margin-right: 4px;
}
</style>
<div class="row-fluid">
    <div class="span12">
        <div class="branddataView">
        <?php echo $this->element('admin/Products/inventory_management'); ?>
        </div>
    </div>
</div>
<script>


 $(document).ready(function(){
   var $modal = $('#commonSmallModal');
   var $modal1 = $('#commonContainerModal');
   var itsId  = "";
   var list = [11];
  /******************************  add quantity to product******************/ 
   
    $(document).on('click','.add_qty',function(){
            var itsId = $(this).attr('data-id');
            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Products','action'=>'add_qty','admin'=>true)); ?>";
            addeditURL = addeditURL+'/'+itsId;
            // function in modal_common.js
            fetchModal($modal,addeditURL,"ProductAdminAddQtyForm");
    });
  
    $modal.on('click', '.updateQty', function(e){
        var options = { 
            //beforeSubmit:  showRequest,  // pre-submit callback 
            success:function(res){
                // onResponse function in modal_common.js
                if(onResponse($modal,'Product',res)){
                    
                    $("div.branddataView").load("<?php echo $this->Html->url(array('controller'=>'products','action'=>'inventory_management','admin'=>true)); ?>", function() {
                        datetableReInt($(document).find('.branddataView').find('table'),list);
                    });    
                }
            }
        }; 
        $('#ProductAdminAddQtyForm').submit(function(){
            if($('#ProductAdminAddQtyForm').validate()){
                $(this).ajaxSubmit(options);
            }
            $(this).unbind('submit');
            $(this).bind('submit');
            return false;
        });
    });
  
  /******************************  subtract quantity to product******************/ 
  
    $(document).on('click','.sub_qty',function(){
            var itsId = $(this).attr('data-id');
            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Products','action'=>'subtract_qty','admin'=>true)); ?>";
            addeditURL = addeditURL+'/'+itsId;
            // function in modal_common.js
            fetchModal($modal1,addeditURL);
    });
    $modal1.on('click', '.subtract', function(e){
        var options = { 
            //beforeSubmit:  showRequest,  // pre-submit callback 
            success:function(res){
                // onResponse function in modal_common.js
                if(onResponse($modal,'ProductHistory',res)){
                    $(".branddataView").load("<?php echo $this->Html->url(array('controller'=>'products','action'=>'inventory_management','admin'=>true)); ?>", function() {
                        datetableReInt($(document).find('.branddataView').find('table'),list);
                        $modal1.modal('toggle');
                        $('#commonSmallModal').modal('toggle');
                    });    
                }
            }
        }; 
        $('#ProductAdminSubtractQtyForm').submit(function(){
            if($('#ProductAdminSubtractQtyForm').validate()){
                $(this).ajaxSubmit(options);
            }
            $(this).unbind('submit');
            $(this).bind('submit');
            return false;
        });
    });
    
    $modal1.on('focus','#ProductAdminSubtractQtyForm input',function(){
        $modal1.find('div.alert').remove();
    });
    $modal1.on('blur','#ProductAdminSubtractQtyForm #ProductBarcode',function(){
        var theBarcode = $(this).val();
        if(theBarcode){
            $.ajax({
                url:"<?php echo $this->Html->url(array('controller'=>'Products','action'=>'getProduct','admin'=>true));?>",
                type:'POST',data: {'barcode':theBarcode},
            }).done(function (result) {
                var data = jQuery.parseJSON(result);
                if(data.message == 'success'){
                    $modal1.find('#ProductAdminSubtractQtyForm input#ProductId').val(data.data.Product.id);
                    $modal1.find('#ProductAdminSubtractQtyForm input#ProductSubQuantity').attr('lessthan',data.data.Product.quantity);
                    $modal1.find('#ProductAdminSubtractQtyForm div.productName').html(data.data.Product.eng_product_name);
                }
                else{
                    onResponse($modal1,'Product',result)
                    $modal1.find('#ProductAdminSubtractQtyForm').find('input').val('');
                    $modal1.find('#ProductAdminSubtractQtyForm div.productName').html('---');
                }
                
            });
        }
        else{
            $modal1.find('#ProductAdminSubtractQtyForm').find('input').val('');
            $modal1.find('#ProductAdminSubtractQtyForm div.productName').html('---');
        }
    });
    
     /*********************Ajax code to delete Product **********************************/  
     $(document).on('click','.delete_product', function(){
     $this =  $(this);  
     itsId = $(this).data('id');
     if(confirm('Are you sure,you wants to delete this product?')){
        deleteUrl = "<?php echo $this->Html->url(array('controller'=>'Products','action'=>'product_delete','admin'=>true)); ?>";
        deleteUrl = deleteUrl+'/'+itsId;
        $.ajax({
           url:deleteUrl,
           success:function(result){
                if(result){
                   // datetableReInt($(document).find('.branddataView').find('table'),list);
                    
                    $(".branddataView").load("<?php echo $this->Html->url(array('controller'=>'Products','action'=>'inventory_management')); ?>", function() {
                    
                    
              });  }else{
                    alert('Problem in deleting data');
                }
           },
        });
     }
   });
         var list = [11];
        datetableReInt($(document).find('.branddataView').find('table'), list);
        
});
  
</script>    
    
