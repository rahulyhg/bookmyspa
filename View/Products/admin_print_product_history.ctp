 <div id='print'>
 <table class="table table-hover table-nomargin dataTable table-bordered dataTable-scroll-x">
                    <thead>
                        <tr style="color:#fff; background-color:purple;">
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
 </table>
 </div>
<script>

function printDiv(divName){
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
printDiv('print');
</script>
 