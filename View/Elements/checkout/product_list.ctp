<?php if(isset($productData) && !empty($productData)){  ?>
<div id="product_listing">
    <div class="box-content">
	<div class="col-xs-12">
	    <div class="table-responsive">
		<table class="table table-hover table-nomargin  table-bordered responsive">
			<thead>
				<tr>
					<th></th>
					<th>BarcodeID</th>
					<th>Brand</th>
					<th>ProductType</th>
					<th>Product Name</th>
					<th>Business Cost</th>
					<th>Selling Price</th>
					<th>Available Quantity</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($productData)){
						$i=1;
						foreach($productData as $productData){ ?>
							<tr>
								<td><?php echo $this->Form->input('Product.id'.$i,array('div'=>array('class'=>'col-sm-1 setNewMarginC'),'class'=>'chk prdct_list','value'=>$productData['Product']['id'],'type'=>'checkbox','quantity'=>$productData['Product']['quantity'],'product_id'=>$productData['Product']['id'],'label'=>array('class'=>'new-chk control-label','text'=>''))); ?></td>
								<td><?php echo $productData['Product']['barcode']; ?></td>
								<td><?php echo $productData['Brand']['eng_name']; ?></td>
								<td> <?php echo $productData['ProductType']['eng_name']; ?></td>
								<td> <?php echo $productData['Product']['eng_product_name']; ?></td>
								<td> <?php echo $productData['Product']['cost_business']; ?></td>
								<td> <?php echo $productData['Product']['selling_price']; ?></td>
								<td> <?php echo $productData['Product']['quantity']; ?></td>
							</tr>
							<?php $i++;
						} ?>
				<?php } ?>
			</tbody>
		</table>
	</div></div></div>
	<div class="modal-footer pdng20">
		<?php echo $this->Form->button('Ok',array('type'=>'submit','class'=>'btn btn-primary submitAddProduct','label'=>false,'div'=>false));?>
        <?php echo $this->Form->button('Cancel',array(
													'type'=>'button',
													'label'=>false,'div'=>false,
													'data-dismiss'=>'modal',
													'class'=>'btn')); ?>
	</div>
</div>
<?php }else{
?> <h3 style="padding-left:20px;">No data Found</h3>
<?php }?>
