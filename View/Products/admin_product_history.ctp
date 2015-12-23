<style>
    .pull-right.btn {
    margin-right: 4px;
}
</style>
<div class="row-fluid">
    <div class="span12">
        <div class="historybranddataView">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    <?php echo __('Product History of ').$products['Product']['eng_product_name'];
		    ?>
                </h3>
                
		<?php
		$prodcut_id = base64_encode($products['Product']['id']);
                 //echo $this->Html->link('<i class="icon-plus"></i> Add Product',array('controller'=>'Products','action'=>'add_product', 'admin'=>true),array('data-id'=>'','escape'=>false,'class'=>'addedit_product pull-right btn'));
                echo $this->Html->link('<i class="icon-list-alt"></i> Export',array('action'=>'product_history','controller'=>'products','admin'=>true ,$prodcut_id , 'excel'),array('data-id'=>'','escape'=>false,'class'=>'pull-right btn'));
		echo $this->Html->link(
		   '<i class="glyphicon-print"></i>&nbsp;Print',
		   'javascript:void(0)', array(
		       'target'=>'_blank',
		       'escape'=>false,
		       'class'=>'pull-right btn',
		       'onClick'=>"window.open('/admin/products/product_history/$prodcut_id/print', 'windowname','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=900,height=300'); return false;"
		   )); ?> 
           
	    </div>
            <div class="box-content">
                    <?php //echo $this->element('admin/Products/inventory_management'); ?>    
		    <table class="table table-hover table-nomargin dataTable table-bordered">
		    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
			    <th>Reason</th>
                            <th>Vendor</th>
                            <th>Selling Price</th>
                            <!--<th>Amt Refunded</th>-->
                            <th>Qty</th>
                            <th>Point Given</th>
                            <th>Point Redeem</th>
                            <th>Taxation</th>
                        </tr>
                    </thead>
                    <tbody>
		    <?php  foreach($products['ProductHistory'] as $product){ ?>
			<tr>
			<td><?php echo $this->Common->getDateFormat($product['date']); ?></td>	
		        <td><?php echo $product['type']; ?></td>
			<td><?php echo $product['reason']; ?></td>
			<td><?php echo $product['vendor']; ?></td>
			<td><?php echo $product['selling_price']; ?></td>
			<td><?php echo $product['qty']; ?></td>
			<td><?php echo $product['points_given']; ?></td>
			<td><?php echo $product['points_redeem']; ?></td>
			<td><?php echo $product['tax']; ?></td>
			</tr> 
                     <?php } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                             <th>Date</th>
                            <th>Type</th>
			    <th>Reason</th>
                            <th>Vendor</th>
                            <th>Selling Price</th>
                            <th>Qty</th>
                            <th>Point Given</th>
                            <th>Point Redeem</th>
                            <th>Taxation</th>
                    </tr>
                    </tfoot>
                </table>
		 </div>
            </div>

        </div>
    </div>
</div>
<script>
$(document).ready(function(){
var list = [2];
        datetableReInt($(document).find('.historybranddataView').find('table'), list);
});
</script>