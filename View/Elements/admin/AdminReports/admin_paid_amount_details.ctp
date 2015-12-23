<?php echo $this->Html->script('admin/plugins/datatable/jquery.dataTables'); ?>
<div class="modal-dialog vendor-setting sm-vendor-setting">
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h2 class="no-mrgn"><?php echo $this->Common->get_salon_name(@$paid_amount_details[0]['PaymentReportPaid']['salon_id']);
		?></h2>
	    </div>
	    <div class="modal-body clearfix">
			    <table class="table table-hover table-nomargin dataTable table-bordered" id="amount_details_table">
        <thead>
            <tr>
                <?php
                    if(@$order_field != 'PaymentReportPaid.created'){
                        $sort_class_cre = 'sorting';
                    }else{
                        $sort_class_cre = $sort_class;
                    }
                ?>
               <th>Paid On</th>
               <th>Amount(AED)</th>
            </tr>
        </thead>
        <tbody>
		<?php
			if(!empty($paid_amount_details)){
				foreach($paid_amount_details as $amount_details){?>
                <tr>
                    <td>
                        <?php
						if(!empty($amount_details['PaymentReportPaid']['created'])) {
							$date = date('d/m/Y', strtotime($amount_details['PaymentReportPaid']['created']));
							$time = date('h:i A', strtotime($amount_details['PaymentReportPaid']['created']));
							echo $date.' '.$time;
							
							} else {
								echo '-';
							}
                           
                        ?>
                    </td>
                    <td>
						<?php echo  $amount_details['PaymentReportPaid']['paid_amount'] ?>
					</td>
				</tr>
            <?php }
				}?>
        </tbody>
    </table>
	        
	    </div>
	</div>
</div>

<script>
	$(document).ready(function() {
    $('#amount_details_table').DataTable( {
       bFilter: false,
	    //"paging":   false,
        ordering: false,
        //"info":     false

    } );
} );
</script>
<style>
	#amount_details_table_length{
		display: none;
	}
</style>