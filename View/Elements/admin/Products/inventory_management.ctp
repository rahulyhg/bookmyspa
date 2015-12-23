
  <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    <?php echo __('Inventory Management'); ?>
                </h3>
                <?php 
		    echo $this->Html->link('<i class="icon-minus"></i> Subtract Product Quantity','javascript:void(0);' ,array('data-id'=>'','escape'=>false,'class'=>'sub_qty pull-right btn'));
		    echo $this->Html->link('<i class="icon-plus"></i> Add Product',array('controller'=>'Products','action'=>'add_product', 'admin'=>true),array('data-id'=>'','escape'=>false,'class'=>'addedit_product pull-right btn'));
		    echo $this->Html->link('<i class="icon-list-alt"></i> Export',array('action'=>'inventory_management','controller'=>'products','admin'=>true , 'excel'),array('data-id'=>'','escape'=>false,'class'=>'pull-right btn'));
		    echo $this->Html->link(
		     '<i class="glyphicon-print"></i>&nbsp;Print',
		     'javascript:void(0)', array(
			 'target'=>'_blank',
			 'escape'=>false,
			 'class'=>'pull-right btn',
			 'onClick'=>"window.open('/admin/products/inventory_management/print', 'windowname','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=900,height=300'); return false;"
		     ));
	   ?> 
            </div>
	    </div>
            <div class="box-content">
		    <table class="table table-hover table-nomargin dataTable table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>BarcodeID</th>
                            <th>Brand</th>
			    <th>Product Type</th>
		            <th>Product Name</th>
                            <th>Avg. Busi Cost</th>
                            <th>Last. Busi Cost</th>
                            <th>Sell Price</th>
                            <th>Total Qty</th>
                            <th>Low Qty warn.</th>
                            <th>Taxation</th>
			    <th>Deduction</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
		    <?php  foreach($allProducts as $product){ ?>
		        <tr>
				<td><?php echo $product['Product']['barcode']; ?></td>			
				<td><?php echo $product['Brand']['eng_name']; ?></td>
				<td><?php echo $product['ProductType']['eng_name']; ?></td>
				<td><?php echo $product['Product']['eng_product_name']; ?></td>
				<td><?php echo $product['Product']['cost_business']; ?></td>
				<td><?php echo $product['Product']['cost_business']; ?></td>
				<td><?php echo $product['Product']['selling_price']; ?></td>
				<td><?php echo $product['Product']['quantity']; ?></td>
				<td><?php echo $product['Product']['low_quantity_warning']; ?></td>
				<td><?php
				if($product['Product']['tax']){
					foreach($tax['TaxCheckout'] as $k=>$v){
					  if($k==$product['Product']['tax']){
					     $product['Product']['tax'] = ($v)?$v:'0.000';	
					  }	
					}
				}
				echo ($product['Product']['tax'])?$product['Product']['tax'].' %':'No Tax'; ?></td>
				<td><?php
				if($product['Product']['deduction']){
					foreach($tax['TaxCheckout'] as $k=>$v){
					  if($k==$product['Product']['deduction']){
					     $product['Product']['deduction'] = ($v)?$v:'0.000';	
					  }	
					}
				}
				echo ($product['Product']['deduction'])?$product['Product']['deduction'].' %':'No Deduction'; ?></td>	
				 <td>
		                 <?php echo $this->Html->link('<i class="icon-pencil"></i>', array('controller'=>'products','action'=>'add_product','admin'=>true,base64_encode($product['Product']['id'])), array('title'=>'Edit','class'=>'addedit_product','escape'=>false) ) ?>&nbsp;&nbsp;
		                 <?php echo $this->Html->link('<i class="glyphicon-circle_plus"></i>','javascript:void(0);' , array('data-id'=>$product['Product']['id'],'title'=>'Add','class'=>'add_qty','escape'=>false) ) ?>&nbsp;&nbsp;
		                 <?php echo $this->Html->link('<i class="glyphicon-circle_minus"></i>','javascript:void(0);' , array('data-id'=>$product['Product']['id'],'title'=>'Subtract','class'=>'sub_qty','escape'=>false) ); ?>&nbsp;&nbsp;
				 <?php echo $this->Html->link('<i class="icon-trash"></i>', 'javascript:void(0);' ,array('data-id'=>$product['Product']['id'],'title'=>'Delete','class'=>'delete_product','escape'=>false)) ?>	&nbsp;&nbsp;
				 <?php echo $this->Html->link('<i class="glyphicon-history"></i>', array('controller'=>'Products','action'=>'product_history', 'admin'=>true,base64_encode($product['Product']['id'])) ,array('data-id'=>$product['Product']['id'],'title'=>'History','class'=>'history_product','escape'=>false)); ?>	
				</td>
		        </tr> 
                     <?php } ?>
                    </tbody>
                   
                </table>
		 </div>
            </div>
  
