<div class="modal-dialog vendor-setting addUserModal">
    <div class="modal-content">
        <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			<h3 id="myModalLabel"><i class="icon-edit"></i>
				  <?php echo  "Search GiftCertificate"; ?>
			</h3>
		</div>
        <div class="modal-body clearfix">
			<div class="row">
				<div class="col-sm-12">
					<div class="col-sm-4">
						<div class="box">
							
							<?php echo $this->Form->input('Checkout.search_value',array( 'class'=>'form-control','type'=>'text','label'=>false,'value'=>'')); ?>
						</div>
					</div>
					<div class="col-sm-4">
						<?php echo $this->Form->button('Search',array('type'=>'submit','class'=>'btn btn-primary searchGiftcertificate','label'=>false,'div'=>false,'data-user-id'=>$user_id,'data-salon-id'=>$salon_id));?>
						<?php echo $this->Form->button('Show All',array('type'=>'submit','class'=>'btn btn-primary showGiftcertificate','label'=>false,'div'=>false,'data-user-id'=>$user_id));?>
					</div>
				</div>
			</div>
		</div>
        <div class="row">
            <div class="col-sm-12">
                <div class="box">
					<?php  echo $this->Form->create('Appointment',array('novalidate','type' => 'file')); ?>
					<?php echo $this->element('checkout/giftcertificate_list'); ?>    
				    <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
</div>

