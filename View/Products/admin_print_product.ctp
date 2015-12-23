<div id='print'>
        <table class="table">
                    <thead>
                        <tr style="color:#fff; background-color:purple; ">
                            <th>BarcodeID</th>
                            <th>English Brand</th>
			    <th>Arabic Brand</th>
                            <th>English Product Type</th>
		            <th>Arabic Product Type</th>
                            <th>Eng. Product Name</th>
			    <th>Ara. Product Name</th>
                            <th>Sell Price</th>
                            <th>Total Qty</th>
                            <th>Low Qty warn.</th>
                            <th>Taxation</th>
                        </tr>
                    </thead>
                    <tbody>
		    <?php  foreach($allProducts as $product){ ?>
		        <tr>
				<td><?php echo $product['Product']['barcode']; ?></td>			
				<td><?php echo $product['Brand']['eng_name']; ?></td>
				<td><?php echo $product['Brand']['ara_name']; ?></td>
				<td><?php echo $product['ProductType']['eng_name']; ?></td>
				<td><?php echo $product['ProductType']['ara_name']; ?></td>
				<td><?php echo $product['Product']['eng_product_name']; ?></td>
				<td><?php echo $product['Product']['ara_product_name']; ?></td>
				<td><?php echo $product['Product']['selling_price']; ?></td>
				<td><?php echo $product['Product']['quantity']; ?></td>
				<td><?php echo $product['Product']['low_quantity_warning']; ?></td>
				<td><?php
				if($product['Product']['tax']){
					foreach($tax['TaxCheckout'] as $k=>$v){
					  if($k==$product['Product']['tax']){
					     $product['Product']['tax'] = ($v)?$v.'%':'0.000%';	
					  }	
					}
				}
				echo ($product['Product']['tax'])?$product['Product']['tax']:'No Tax'; ?>
				</td>	
		        </tr> 
                     <?php } ?>
                    </tbody>
                </table>
</div>

<script>
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
printDiv('print');
</script>
