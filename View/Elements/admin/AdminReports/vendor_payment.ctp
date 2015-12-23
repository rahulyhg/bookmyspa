<?php
$this->Paginator->options(array(
    'update' => '#update_element',
    'evalScripts' => true,
    'url' => array(
        'salon' => @$salon_id,
        'number_records' => @$this->request->data['number_records'],
    ),
    'before' => $this->Js->get('.loader-container')->effect(
        'fadeIn',
        array('buffer' => false)
    ),
    'complete' => $this->Js->get('.loader-container')->effect(
        'fadeOut',
        array('buffer' => false)
    ),
));?>
<div class="box-content">
    <div class="productTypedataView" id="list-types">
	<?php if($this->Session->read('Auth.User.type') == 1) {?>
	<div class="box-title">
	    <h3>Search Payments</h3>
	</div>
	<?php echo $this->Form->create('PaymentReport');?>
	<div class="box-content pdng-btm-non mrgn-btm20">
	    <div class="col-sm-2">
		<div class="form-group pdng-tp7 ">
		  <strong>Salon: </strong>
		</div>
	    </div>
	    <div class="col-sm-2">
		<div class="form-group">
		<?php
			if(isset($salon_id)){
				$selectedSalonId = $salon_id;
			}
			else{
				$selectedSalonId = '';
			}
		  
			echo $this->Form->select('salon',array($salon_list),array('empty'=>'- Select Salon -','value'=>$selectedSalonId,'class'=>'form-control full-w')); ?>
		</div>
	    </div>
	    
	    <!--div class="col-sm-2">
		<div class="form-group">
		  <?php //echo $this->Form->input('startDate',array('class'=>'form-control datepicker','id'=>'startDate','div'=>false,'placeholder'=>'From','label'=>false));?>
		</div>
	    </div>
	    
	    <div class="col-sm-2">
		<div class="form-group">
		  <?php echo $this->Form->input('endDate1',array('class'=>'form-control datepicker','id'=>'endDate1','div'=>false,'placeholder'=>'To','label'=>false));?>
		</div>
	    </div-->
	    
	    
	    <div class="col-sm-3">
	      <div class="col-sm-6">
		<div class="form-group">
		  <?php
		    echo $this->Js->submit('Search', array(
			    'url' => array(
				'action' => '/vendor_payments'
			    ),
			    'class'=>'btn full-w ',
			    'update' => '#update_element'
			)
		    );?>
		</div>
	      </div>
	      <div class="col-sm-6">
		<div class="form-group">
		  <?php echo $this->Form->button('Clear', array('type'=>'reset','id'=>'reset','class'=>'btn full-w')); ?>
		</div>
	      </div>
	    </div>
	</div>
	<?php echo $this->Form->end();?>
	<?php }?>
	
	
	<div class="search-class">
	    <div class="pull-left col-sm-4 nopadding">
		<div class="col-sm-3 nopadding">
		    <?php echo $this->Form->select('number_records',
		    array('5'=>'5','10'=>'10','25'=>'25','50'=>'50','100'=>'100'),
		    array('empty'=>false,'class'=>'form-control'));?>
		</div>
		<label class="col-sm-9 pdng-tp7" >
		    Entries per page 
		</label>
	    </div>
	</div>
	    <?php
	    
	    //pr($payment_rpts);
	    if(!empty($payment_rpts)){
			//pr($this->Paginator->request->paging); exit;
		if(!empty($this->Paginator->request->paging['PaymentReport']['order']) || !empty($this->Paginator->request->paging['PaymentReport']['options'])){
		    if(!empty($this->Paginator->request->paging['PaymentReport']['order'])){
			$array_srt = $this->Paginator->request->paging['PaymentReport']['order'];
		    }
		    if(empty($array_srt) && !empty($this->Paginator->request->paging['PaymentReport']['options']['order'])){
			$array_srt = $this->Paginator->request->paging['PaymentReport']['options']['order'];
		    }
			//pr($array_srt); exit;
		    if(!empty($array_srt)){
				
			foreach($array_srt as $field => $direction){
			    $order_field = $field;
			    $ord_dir = $direction;
			
			}
		    }
			elseif(!empty($this->Paginator->request->paging['PaymentReport']['options'])){
				$order_field = $this->Paginator->request->paging['PaymentReport']['options']['sort'];
			    $ord_dir = $this->Paginator->request->paging['PaymentReport']['options']['direction'];
			}
			
		}
		//echo $order_field;
		$sort_class = 'sorting';
		if($ord_dir == 'desc'){
		    $sort_class = 'sorting_desc';
		} else if($ord_dir == 'asc') {
		    $sort_class = 'sorting_asc';
		}
		?>
		<table class="table table-hover table-nomargin dataTable table-bordered">
		    <thead>
			<tr>
			    <?php
			    if($order_field != 'Salon.eng_name'){
				$sort_class_eng = 'sorting';
			    } else {
				$sort_class_eng = $sort_class;
			    }
			    ?>
			    <th class="<?php echo $sort_class_eng;?>">
				<?php echo $this->Paginator->sort('Salon.eng_name', 'Salon');?>
			    </th>
			    <?php
			    if($order_field != 'PaymentReport.report_title'){
				$sort_class_eng = 'sorting';
			    } else {
				$sort_class_eng = $sort_class;
			    }
			    ?>
			    <!--th class="<?php echo $sort_class_eng;?>">
				<?php //echo $this->Paginator->sort('PaymentReport.report_title', 'Title');?>
			    </th-->
			    <?php
			    if($order_field != 'PaymentReport.from_date'){
				$sort_class_eng = 'sorting';
			    } else {
				$sort_class_eng = $sort_class;
			    }
			    ?>
			    <th style="text-align: center" class="<?php echo $sort_class_eng;?>">
				<?php echo $this->Paginator->sort('PaymentReport.from_date', 'From');?>
			    </th>
			    <?php
			    if($order_field != 'PaymentReport.to_date'){
				$sort_class_eng = 'sorting';
			    } else {
				$sort_class_eng = $sort_class;
			    }
			    ?>
			    <th style="text-align: center" class="<?php echo $sort_class_eng;?>">
				<?php echo $this->Paginator->sort('PaymentReport.to_date', 'To');?>
			    </th>
			    <?php
			    if($order_field != 'PaymentReport.opening_balance'){
				$sort_class_eng = 'sorting';
			    } else {
				$sort_class_eng = $sort_class;
			    }
			    ?>
			    <th style="text-align: right" class="<?php echo $sort_class_eng;?>">
				<?php echo $this->Paginator->sort('PaymentReport.opening_balance', 'Opening Balance');?> AED
			    </th>
			    <?php
			    if($order_field != 'PaymentReport.amount_due'){
				$sort_class_eng = 'sorting';
			    } else {
				$sort_class_eng = $sort_class;
			    }
			    ?>
			    <th style="text-align: right" class="<?php echo $sort_class_eng;?>">
				<?php echo $this->Paginator->sort('PaymentReport.amount_due', 'Amount Due');?> AED
			    </th>
			    <th style="text-align: right">
				Total Paid AED
			    </th>
			    <?php
			    if($order_field != 'PaymentReport.amount_due'){
				$sort_class_eng = 'sorting';
			    } else {
				$sort_class_eng = $sort_class;
			    }
			    ?>
			    <th style="text-align: right" class="<?php echo $sort_class_eng;?>">
				<?php echo $this->Paginator->sort('PaymentReport.closing_balance', 'Closing Balance');?> AED
			    </th>
			    <?php
			    if($order_field != 'PaymentReport.created'){
				$sort_class_eng = 'sorting';
			    } else {
				$sort_class_eng = $sort_class;
			    }
			    ?>
			    <th style="text-align: center"  class="<?php echo $sort_class_eng;?>">
				<?php echo $this->Paginator->sort('PaymentReport.created', 'Created');?>
			    </th>
			 </tr>
		     </thead>
		    <tbody>
			<?php
			foreach($payment_rpts as $payment_rpt){?>
			    <tr>
				
				<td>
				    <?php if(!empty($payment_rpt['Salon']['eng_name'])){
					echo $payment_rpt['Salon']['eng_name'];
				    } else {
					echo '-';
				    }?>
				</td>
				<!--td>
				    <?php
				    /*if(!empty($payment_rpt['PaymentReport']['report_title'])) {
					echo $payment_rpt['PaymentReport']['report_title'];
				    } else {
					echo '-';
				    }*/?>
				</td-->
				<td style ="text-align:center">
				    <?php
				    if(!empty($payment_rpt['PaymentReport']['from_date'])) {
					echo date('d/m/Y', strtotime($payment_rpt['PaymentReport']['from_date']));
				    } else {
					echo '-';
				    }?>
				</td>
				<td style ="text-align:center">
				    <?php
				    if(!empty($payment_rpt['PaymentReport']['to_date'])) {
					echo date('d/m/Y', strtotime($payment_rpt['PaymentReport']['to_date']));
				    } else {
					echo '-';
				    }?>
				</td>
				<td style ="text-align:right">
				    <?php
				    if(!empty($payment_rpt['PaymentReport']['opening_balance'])) {
					echo $payment_rpt['PaymentReport']['opening_balance'];
				    } else {
					echo '-';
				    }?>
				</td>
				<td style ="text-align:right">
				    <?php
				    if(!empty($payment_rpt['PaymentReport']['amount_due'])) {
					echo $payment_rpt['PaymentReport']['amount_due'];
				    } else {
					echo '-';
				    }?>
				</td>
				<td style ="text-align:right">
					<?php
					$total_paid = @$payment_rpt['PaymentReport']['opening_balance'] + @$payment_rpt['PaymentReport']['amount_due'] - @$payment_rpt['PaymentReport']['closing_balance'];
					echo  $this->Html->link(__($total_paid,true) , 'javascript:void(0)',array('class'=>'total_paid','salon_id'=> $payment_rpt['PaymentReport']['salon_id'],'payment_report_id' => $payment_rpt['PaymentReport']['id']));
				     
					 ?>
				</td>
				<td style ="text-align:right">
				    <?php
				    if(!empty($payment_rpt['PaymentReport']['closing_balance'])) {
					echo $payment_rpt['PaymentReport']['closing_balance'];
				    } else {
					echo '-';
				    }?>
				</td>
				<td style ="text-align:center">
				    <?php
				    if(!empty($payment_rpt['PaymentReport']['created'])) {
					echo date('d/m/Y', strtotime($payment_rpt['PaymentReport']['created']));
					
				    } else {
					echo '-';
				    }?>
				</td>
				</tr>
			    <?php }?>
			</tbody>
		    </table>
		    <div>
			<div class="result_pages">
			    <?php 
			    $pagingArr = $this->Paginator->params();
			    //pr($pagingArr);
			    $start_records = $pagingArr['page'];
			    if(!empty($pagingArr['pageCount'])){
				if (!empty($pagingArr['page']) && !empty($pagingArr['limit'])) {
				    $start_records = $pagingArr['limit'] * ($pagingArr['page'] - 1) + 1;
				}
			    }
			    $end_records = $start_records + $pagingArr['limit'] - 1;
			    if($end_records > $pagingArr['count']){
				$end_records = $pagingArr['count'];
			    }
			    $total_entries = $pagingArr['count'];
			    //echo $this->Paginator->counter();
			    echo 'Showing '.$start_records.' to '.$end_records.' of '.$total_entries.' entries'; ?>
			</div>
			<div class ="ck-paging">
			    <?php
			    echo $this->Paginator->first('First');
			    echo $this->Paginator->prev(
				      'Previous',
				      array(),
				      null,
				      array('class' => 'prev disabled')
			    );
			    echo $this->Paginator->numbers(array('separator'=>' '));
			    echo $this->Paginator->next(
				      'Next',
				      array(),
				      null,
				      array('class' => 'next disabled')
			    );
			    echo $this->Paginator->last('Last');?>
			</div>
		    </div>
		<?php  } else {?>
		    <table class="table table-hover table-nomargin dataTable table-bordered">
			<tr>
			    <td>No record found.</td>
			</tr>
		    </table>
		<?php }
		?>
	</div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#reset').on('click',function(){
		location.reload();
	});
	$forOrderDetailmodal =  $('#commonVendorModal'); 
    $(document).on('click','.total_paid',function(){
	var salon_id = $(this).attr('salon_id');
	var payment_report_id = $(this).attr('payment_report_id');
	var amountDetailUrl = '<?php echo $this->Html->url(array('controller'=>'adminReports','action'=>'paid_amount_details','admin'=>true));?>'+'/'+salon_id+'/'+payment_report_id;
	fetchstaticModal($forOrderDetailmodal,amountDetailUrl);
	});
        // enable datepicker
        //maxDate= new Date();
        
        /*$("#startDate").datepicker({
            dateFormat: 'dd/mm/yy',
            numberOfMonths: 1,
            maxDate: '0',
            onClose: function( selectedDate ) {
                $( "#endDate" ).datepicker( "option", "minDate", selectedDate );
            }
        });
        $("#endDate1").datepicker({
            dateFormat: 'dd/mm/yy',
            numberOfMonths: 1,
            maxDate: '0',
            onClose: function( selectedDate ) {
                $( "#endDate1" ).datepicker( "option", "maxDate", selectedDate );
            }
        });*/
        //$(document).find("#saloon").select2();
    });
  
</script>
<?php echo $this->Js->writeBuffer();?>
