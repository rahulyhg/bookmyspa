
<div id="giftcertificate_listing">
    <?php if(isset($giftData) && !empty($giftData)){  ?>
    <div class="box-content">
		<table class="table table-hover table-nomargin  table-bordered">
			<thead>
				<tr>
					<th></th>
					<th>GC No</th>
					<th>Assigned To</th>
                                        <th>Current Balance</th>
					
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($giftData)){
						$i=1;
						foreach($giftData as $giftData){  ?>
						<?php if($i==1){
							$checked='checked';}else{$checked='';} ?>
							<tr>
								<td><input type='radio' <?php echo $checked; ?> name='data[Checkout][check]' id='OptionsSelectPlan_<?php echo $i; ?>' value="<?php echo $i; ?>" >
                <label class='new-chk' for='OptionsSelectPlan_<?php echo $i; ?>'></label>
                                                                <?php echo $this->Form->input('Checkout.amount_'.$i,array( 'class'=>'form-control','type'=>'hidden','label'=>false,'value'=>$giftData['GiftCertificate']['amount'])); ?>
                                                                <?php echo $this->Form->input('Checkout.id_'.$i,array( 'class'=>'form-control','type'=>'hidden','label'=>false,'value'=>$giftData['GiftCertificate']['id'])); ?>
                                                                
                                                                </td>
								<td><?php echo $giftData['GiftCertificate']['gift_certificate_no']; ?></td>
								<td></td>
								<td> <?php echo $giftData['GiftCertificate']['amount']; ?></td>
								
							</tr>
							<?php $i++;
						} ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="modal-footer pdng20">
		<?php echo $this->Form->button('Ok',array('type'=>'submit','class'=>'btn btn-primary submitSearchGiftcertificate','label'=>false,'div'=>false));?>
        <?php echo $this->Form->button('Cancel',array(
													'type'=>'button',
													'label'=>false,'div'=>false,
													'data-dismiss'=>'modal',
													'class'=>'btn')); ?>
	</div>

<?php }else{
?> <h3 style="padding-left:20px;">No Gift Certificate Found</h3>
<?php }?>
</div>