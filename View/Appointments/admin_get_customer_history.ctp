<script type="text/javascript">
	$(document).ready(function() {
		$("#myTab a").click(function(e){
    	e.preventDefault();
    	$(this).tab('show');
		});
		
		$("#sectionB").tab('show');
    });
	$('.example').dataTable({
		'aoColumnDefs': [{
        'bSortable': false,
		//"bPaginate": false,
        'aTargets': ['nosort']
    }]
	});
	
</script>

<style>
.bs-example{
	margin: 20px;
}
.dataTables_length{
	display: none;
}
.dataTables_filter{
	display: none;
}
.modal .modelHistory {
    max-height: 600px;
    overflow-y: auto;
}
</style>
<div class="modal-dialog vendor-setting addUserModal">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h3 id="myModalLabel"><i class="icon-edit"></i>
                    <?php echo "Customer History";  ?>
                </h3>
			<div id="myModalLabel">
                <?php echo "Customer History";  ?>
            </div>
        </div>
        <div class="modal-body modelHistory">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
						<div class="box-content">
							<div class="bs-example">
								
								<ul class="nav nav-tabs" id="myTab">
									<?php if($note_tab_active == 1){
									?>
										<li><a href="#sectionA">Appointments</a></li>
										<li class="active"><a href="#sectionD">Notes</a></li>
									<?php
									}
									else{
									?>
										<li class="active"><a href="#sectionA">Appointments</a></li>
										<li><a href="#sectionD">Notes</a></li>
									<?php
									}
									?>
									<li><a href="#sectionB">Products</a></li>
									<li><a href="#sectionC">IOU</a></li>
									<!--<li><a href="#sectionD">Notes</a></li>-->
									<li><a href="#sectionE">Gift Certificates</a></li>
									<!--<li><a href="#sectionF">Packages</a></li>-->
								</ul>
								<div class="tab-content">
									<?php if($note_tab_active == 1){?>
										<div id="sectionA" class="tab-pane fade in">
									<?php
									}
									else{
									?>
										<div id="sectionA" class="tab-pane fade in active">
									<?php
									}
									?>
									
										<h3>Appointments</h3>
										<table id="example" class="table table-striped table-bordered example" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>Appointment Date</th>
													<th class="nosort">Status</th>
													<th class="nosort">Service Provider</th>
													<th class="nosort">Service</th>
													<th class="nosort">Amt Paid</th>
													
												</tr>
											</thead>
											<tbody>
											<?php
											if(isset($appointment_history_array) && $appointment_history_array != ""){
												foreach ($appointment_history_array as $key => $appointment_history){
													//pr($appointment_history); die;
											?>
												<tr>
													<td><?php echo date('M d,Y',strtotime($appointment_history['Appointment']['created'])); ?></td>
													<td><?php switch($appointment_history['Appointment']['status']) {
												case 0: echo "Awaiting";
												break;
												case 1: echo "Confirmed";
												break;
												case 2: echo "Checkin";
												break;
												case 3: echo "Checkout";
												break;
												case 4: echo "Paid";
												break;
												case 5: echo "Cancel";
												break;
												case 6: echo "In Progress";
												break;
												case 7: echo "Show";
												break;
												case 8: echo "No Show";
												break;
												case 9: echo "Deny";
												break;
												}
												?>
													</td>
													<td><?php echo $appointment_history['User']['first_name'].' '.$appointment_history['User']['last_name']; ?></td>
													<td><?php echo $this->Common->get_salon_service_name($appointment_history['Appointment']['salon_service_id']); ?></td>
													<td><?php echo $appointment_history['Appointment']['appointment_price'];?></td>
													
												</tr>
											<?php
												}
											}
											else{
												echo "No Appointment History Found";
											}
											?>
											</tbody>
										</table>
									</div>
									<div id="sectionB" class="tab-pane fade">
										<h3>Products</h3>
										<table id="example" class="table table-striped table-bordered example" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>Created Date</th>
													<th class="nosort">Bar Code</th>
													<th class="nosort">Product Name</th>
													<th class="nosort">Selling Price</th>
													<th class="nosort">Quantity</th>
												</tr>
											</thead>
											<tbody>
											<?php
												if(isset($product_history_array) && $product_history_array != ""){
												foreach ($product_history_array as $key => $product_history){
											?>
												<tr>
													<td><?php echo date('M d,Y',strtotime($product_history['ProductHistory']['created'])); ?></td>
													<td><?php echo $product_history['Product']['barcode']; ?></td>
													<td><?php echo $product_history['Product']['eng_product_name']; ?></td>						
													<td><?php echo $product_history['Product']['selling_price']; ?></td>
													<td><?php echo $product_history['ProductHistory']['qty']; ?></td>
													
												</tr>
											<?php
												}
											}
											else{
												echo "No Products Found";
											}
											?>
											</tbody>
										</table>
									</div>
									<div id="sectionC" class="tab-pane fade">
										<h3>IOU</h3>
										<table id="example" class="table table-striped table-bordered example" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>Created Date</th>
													<th class="nosort">Closed Date</th>
													<!--<th class="nosort">Provider Name</th>-->
													<th class="nosort">comment</th>
													<th class="nosort">Status</th>
													<th class="nosort">Amount</th>
												</tr>
											</thead>
											<tbody>
											<?php
												if(isset($iou_history_array) && $iou_history_array != ""){
												foreach ($iou_history_array as $key => $iou_history){
													if($iou_history['Iou']['status']==1){
														$status='Paid';
													}else{
														$status='IOU';
													}
											?>
												<tr>
													
													<td><?php echo date('M d,Y',strtotime($iou_history['Iou']['created'])); ?></td>
													<td><?php echo '-'; ?></td>
													<!--<td><?php echo "-"; ?></td>-->						
													<td><?php echo $iou_history['Iou']['iou_comment']; ?></td>
													<td><?php echo $status; ?></td>
													<td><?php echo $iou_history['Iou']['total_iou_price']; ?></td>
													
												</tr>
											<?php
												}
											}
											else{
												echo "No Products Found";
											}
											?>
											</tbody>
										</table>
									</div>
									<?php if($note_tab_active == 1){?>
										<div id="sectionD" class="tab-pane fade in active">
									<?php
									}
									else{
									?>
										<div id="sectionD" class="tab-pane fade in">
									<?php
									}
									//pr($note_history_array); die; 
									?>
										<?php  echo $this->element('admin/Appointment/note_element'); ?>
									
									</div>
										
										
										
										
									<div id="sectionE" class="tab-pane fade">
										<h3>Gift Certificate</h3>
										<table id="example" class="table table-striped table-bordered example" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>GiftCertificate No</th>
													<!--<th class="nosort">ServiceName</th>-->
													<th class="nosort">Initial Amount</th>
													<!--<th class="nosort">Current Balance</th>-->
													<th class="nosort">Expires on</th>
													<!--<th class="nosort">Purchased At</th>-->
												</tr>
											</thead>
											<tbody>
											<?php
												if(isset($gc_history_array) && $gc_history_array != ""){
												foreach ($gc_history_array as $key => $gc_history){
													
											?>
												<tr>
													
													<td><?php echo $gc_history['GiftCertificate']['gift_certificate_no']; ?></td>
													<td><?php echo $gc_history['GiftCertificate']['total_amount']; ?></td>
													<td><?php echo $gc_history['GiftCertificate']['expire_on']; ?></td>
													
												</tr>
											<?php
												}
											}
											else{
												echo "No Products Found";
											}
											?>
											</tbody>
										</table>
									</div>
									<div id="sectionF" class="tab-pane fade">
										<h3>Packages</h3>
									</div>
								</div>
							</div>
                        </div>
						<div class="modal-footer pdng20">
                            <?php echo $this->Form->button('Cancel',array(
									'type'=>'button',
                                    'label'=>false,'div'=>false,
                                    'data-dismiss'=>'modal',
                                    'class'=>'btn')); ?>
                        </div>
						<?php //echo $this->Form->end();?>
                    </div>
			    </div>
			</div>
		  </div>
	    </div>
    </div>
</div>
	