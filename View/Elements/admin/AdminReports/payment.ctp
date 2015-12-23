<?php
    $this->Paginator->options(array(
	'update' => '#update_element',
	'evalScripts' => true,
	'url' => array(
	    'search_keyword' => @$this->request->data['search_keyword'],
	    'number_records' => @$this->request->data['number_records'],
	    'startDate' => @$this->request->data['startDate'],
	    'endDate' => @$this->request->data['endDate'],
	    'serviceType' => @$this->request->data['serviceType']
	),
	'before' => $this->Js->get('.loader-container')->effect(
	    'fadeIn',
	    array('buffer' => false)
	),
	'complete' => $this->Js->get('.loader-container')->effect(
	    'fadeOut',
	    array('buffer' => false)
	),
    ));
?>
<div class="box-content">
    <div class="productTypedataView" id="list-types">
	
	<style>
	    #s2id_staffId,#s2id_customerId{width: 20%}
	    .largeTextBox{width: 70%!important}
	    .smallTextBox{width:30%!important}
	</style>
	<div class="box-title">
	    <h3>Salon Transactions</h3>
	</div>
	<?php echo $this->Form->create('Order');?>
        <?php 
                $sessionData=$this->Session->read('Auth.User');
		
                if($sessionData['type']=='1'){
            ?>
	<div class="box-content pdng-btm-non mrgn-btm20">
	    <div class="col-sm-2">
		<div class="form-group pdng-tp7 ">
		  <strong>Salon: </strong>
		</div>
	    </div>
            <div class="col-sm-2">
		<div class="form-group">
                    <?php 
                        $sel_val='';
                        if(isset($this->request->named['serviceType'])){
                          $sel_val=$this->request->named['serviceType'];
                        }elseif(isset($this->request->data['Order']['salon'])){
                          $sel_val=$this->request->data['Order']['salon'];
                        } 
                    ?>
		  <?php echo $this->Form->select('salon',array($salon_list),array('empty'=>'- Select Salon -','value'=>$sel_val,'class'=>'form-control full-w')); ?>
		</div>
	    </div>
          
	    <div class="col-sm-3">
	      <div class="col-sm-6">
		<div class="form-group">
		  <?php
		    echo $this->Js->submit('Search', array(
			    'url' => array(
				'action' => '/payment'
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
	<div>
 	
	    <?php if(!empty($reports)) {
		?>
		<div style="width:50%;margin: 0 25%;">
		    <div class="col-sm-12" style="border: 2px solid #DDDDDD;padding: 10px;margin-bottom:20px">
			<div class="row">
			    <div style="text-align: center">
				<strong>Salon:</strong>
				<?php echo @$reports['Salon'];?></div>
			    </div>
			<div class="row">
			    <div style="text-align: center">
				<strong>Transactions Included:</strong>
				From <?php echo date("jS  F Y" , strtotime($reports['From']));?> to <?php echo date("jS  F Y" , strtotime($reports['To']));?>
			    </div>
			</div>
			<div class="row">
			    <div style="text-align: center">
				<strong>Opening Balance (AED):</strong>
				<?php echo $reports['opening_balance'];?>
			    </div>
			</div>
                        <div class="row">
			    <div style="text-align: center">
				<strong>Paid with GC (AED):</strong>
				<?php
				    if(!empty($reports['gift_amount'])){
					echo $reports['gift_amount'];    
				    }else{
					echo "--";
				    }
				?>
			    </div>
			</div>
			<div class="row">
			    <div style="text-align: center">
				<strong>Paid with Sieasta Points (AED):</strong>
				<?php
				    if(!empty($reports['sieasta_point_price'])){
					echo $reports['sieasta_point_price'];    
				    }else{
					echo "--";
				    }
				?>
			    </div>
			</div>
			<div class="row">
			    <div style="text-align: center">
				<strong>Paid with Salon Points (AED):</strong>
				<?php
				    if(!empty($reports['salon_point_price'])){
					echo $reports['salon_point_price'];    
				    }else{
					echo "--";
				    }
				?>
			    </div>
			</div>
			<div class="row">
			    <div style="text-align: center">
				<strong>Paid with Card (AED):</strong>
				<?php
				    if(!empty($reports['amount'])){
					echo $reports['amount'];    
				    }else{
					echo "--";
				    }
				?>
			    </div>
			</div>
			<div class="row">
			    <div style="text-align: center">
				<strong>Sieasta commission (AED):</strong>
				<?php echo $reports['commision'];?>
			    </div>
			</div>
                        <div class="row">
			    <div style="text-align: center">
				<strong>Credit card Commission (AED):</strong>
				<?php echo $reports['credit_card_commision'];?>
			    </div>
			</div>
			<div class="row">
			    <div style="text-align: center">
				<strong>Amount Due (AED):</strong>
				<?php //pr($reports);
                                if($reports['opening_balance']!="NIL"){
                                    echo $reports['amount_due']." + ".$reports['opening_balance'].' = '.($reports['amount_due']+$reports['opening_balance']);
                                }else{
                                    echo $reports['amount_due'];
                                }
                                ?>
			    </div>
			</div>
			<div class="row">
			    <div style="text-align: center">
				<strong>Closing Amount (AED):</strong>
				<?php 
                                if($reports['opening_balance']!="NIL"){
                                    if(isset($reports['flag'])){
                                        $closeAmount = $reports['closing_amt'];
                                    }else{
                                        $closeAmount = $reports['closing_amt'] + $reports['opening_balance'];
                                    }
                                }else{
                                    $closeAmount = $reports['closing_amt'];
                                }
				echo $closeAmount;
                                ?>
			    </div>
			</div>
			<div class="row">
			    <!--<div style="text-align: center">
				<strong>Paid till now (AED):</strong>
				<?php 
                               // echo ($reports['amount_due'] + $reports['opening_balance']) - $reports['closing_amt'];
                                ?>
			    </div>-->
			</div>
                        
			<!-- <div class="row">
			   <div style="width: 50%; float: left; text-align: right;">
				<strong>Pay (ADE):</strong>
			    </div>
			    <div class="col-sm-3">
				<?php echo $this->Form->input('pay_amount',array('label'=>false,'class'=>'form-control','div'=>false,'type'=>'textbox'));?>
			    </div>
			</div>-->
                        <?php
			if($closeAmount > 0 && ($sessionData['type']=='1')){?>
			<div class="row">
				<div style="float: left; margin: 10px; text-align: center; width: 100%;">
			    <?php echo $this->Form->button('Pay Now',array('id'=>'paynow','class'=>'btn'));?>
				</div>
			</div>
                        <?php }?>
		    </div>
		</div>
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
	    if(!empty($orders)){
		if(!empty($this->Paginator->request->paging['Order']['options']['order'])){
		    foreach($this->Paginator->request->paging['Order']['options']['order'] as $field => $direction){
			$order_field = $field;
			$ord_dir = $direction;
		    }
		}
		$sort_class = 'sorting';
		if($ord_dir == 'desc'){
			  $sort_class = 'sorting_desc';
		} else if($ord_dir == 'asc') {
			  $sort_class = 'sorting_asc';
		} ?>
		<table class="table table-hover table-nomargin dataTable table-bordered">
		    <thead>
			<tr>
			    <?php
			    if($order_field != 'Order.created'){
				$sort_class_cre = 'sorting';
			    }else{
				$sort_class_cre = $sort_class;
			    }
			    if(empty($this->request->data['Order']['salon'])){ ?>
				<th style ="text-align:center">Salon</th>
			    <?php } ?>
			    <th style ="text-align:center">Payment For</th>
			    <th style ="text-align:center">Sales Price (AED)</th>
			    <th style ="text-align:center">Tax paid by Customer(AED)</th>
			    <th style ="text-align:center">Received from Customer (AED)</th>
			    <th style ="text-align:center">Paid with GC (AED)</th>
			    <th style ="text-align:center">Paid with Sieasta Points (AED)</th>
			    <th style ="text-align:center">Paid with Salon Points (AED)</th>
			    <th style ="text-align:center">Paid with Card (AED)</th>
			    <th style ="text-align:center">Sieasta Commission (AED)</th>
			    <th style ="text-align:center">Credit card commission / Deductions (AED)</th>
			    <th style ="text-align:center">Amount Due (AED)</th>
			 </tr>
		     </thead>
		    <tbody>
			<?php foreach($orders as $order){?>
			    <tr>
				<?php if(empty($this->request->data['Order']['salon'])){ ?>
				<td>
				    <?php if(!empty($salon_list) && !empty($salon_list[$order['Order']['salon_id']])){
					echo $salon_list[$order['Order']['salon_id']];
				    } else {
					echo '-';
				    }?>
				</td>
				<?php } ?>
				<td>
				    <?php
				   /* if($order['Order']['service_type'] == '6'){
					echo 'Gift Certificates';
				    }else if($order['Order']['service_type'] == '7'){
					echo 'E-voucher';
				    }else{
					echo 'Services';
				    }*/
				    
				    if($order['Order']['service_type'] == '6'){
					echo 'Gift Certificates';
				    }else if($order['Order']['service_type'] == '7'){
					echo 'E-voucher';
				    } else if($order['Order']['service_type'] == '5'){
					echo 'Deals';
				    } else if($order['Order']['service_type'] == '4'){
					echo 'Spa Breaks';
				    } else if($order['Order']['service_type'] == '3'){
					echo 'Spa Days';
				    } else if($order['Order']['service_type'] == '2'){
					echo 'Packages';
				    }else{
					echo 'Services';
				    }
				    ?>
				</td>
				<td style ="text-align:center">
				    <?php
				    if(!empty($order['Order']['orignal_amount'])) {
					echo $order['Order']['orignal_amount'];
				    } else {
					echo '-';
				    }?>
				</td>
				<!--<td style ="text-align:center">
				    <?php
				    /*$tax_str = ''; $total_tax = '';
				    if(!empty($order['Order']['tax1']) || !empty($order['Order']['tax2'])) {
					if(!empty($order['Order']['tax1'])) {
					    $tax_str = $order['Order']['tax1'];
					}
					if(!empty($tax_str) && !empty($order['Order']['tax2'])){
					    $tax_str = $tax_str.' + '.$order['Order']['tax2'];
					} else if(empty($tax_str) && !empty($order['Order']['tax2'])){
					    $tax_str = $order['Order']['tax2'];
					}
					//echo @$order['Order']['tax1'].'% + '.@$order['Order']['tax2'].'% = <br>';
					$total_tax = @$order['Order']['tax1']+@$order['Order']['tax2'];
				    }
				    if(!empty($tax_str) && !empty($total_tax)){
					echo $tax_str.' = <br>'.$total_tax;
				    } else {
					echo '-';
				    }*/
				    ?>
				</td>-->
				<td style ="text-align:center">
				    <?php
				      echo $order['Order']['tax_amount'];
				    ?>
				</td>
				    <td style ="text-align:center">
					<?php
					  echo $order['Order']['service_price_with_tax'];
					?>
				    </td>
				    <td style ="text-align:center">
					<?php
					if(!empty($order['Order']['gift_amount'])){
					  echo $order['Order']['gift_amount'];
					}else{
					   echo '--'; 
					}
					?>
				    </td>
				    <td style ="text-align:center">
					<?php
					if(!empty($order['Order']['sieasta_point_price'])){
					  echo $order['Order']['sieasta_point_price'];
					}else{
					    echo '--';
					}
					?>
				    </td>
				    <td style ="text-align:center">
					<?php
					if(!empty($order['Order']['salon_point_price'])){
					  echo $order['Order']['salon_point_price'];
					}else{
					    echo "--";
					}
					?>
				    </td>
				    <td style ="text-align:center">
					<?php
					if(!empty($order['Order']['amount'])){
					  echo $order['Order']['amount'];
					}else{
					    echo '--';
					}
					?>
				    </td>
				    <td style ="text-align:center">
					<?php
					  echo $order['Order']['sieasta_commision_amount'];
					?>
				    </td>
				    <td style ="text-align:center">
					 <?php echo $order['Order']['total_deductions'] ;?>
				    </td>
				    <td style ="text-align:center">
					<?php echo $order['Order']['vendor_dues'];?>
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
<script>
$(document).ready(function(){
    var $sModal = $(document).find('#commonSmallModal');
	$('#reset').on('click',function(){
		location.reload();
	});
	
	// on click of paynow to submit reports 
    $('#paynow').on('click',function(){
        $.ajax({
               type:'post',
               url: "<?php echo $this->Html->url(array('controller'=>'adminReports','action'=>'paymentCycle','admin'=>true))?>",
               data:{'user_id':'<?php if(isset($reports["salon_user_id"])){ echo $reports["salon_user_id"]; }?>','from_date':'<?php if(isset($reports["From"])){ echo $reports["From"]; }?>','to_date':'<?php if(isset($reports["To"])){ echo $reports["To"]; }?>','opening_balance':'<?php if(isset($reports["opening_balance"])){ echo $reports["opening_balance"]; }?>','amount_due':'<?php if(isset($reports["amount_due"])){ echo $reports["amount_due"]; }?> ','closing_balance':'<?php if(isset($reports["amount_due"])){ echo $reports["amount_due"]; }?>','credit_card_commision':'<?php if(isset($reports["credit_card_commision"])){ echo $reports["credit_card_commision"]; }?>','sieasta_commission':'<?php if(isset($reports["commision"])){ echo $reports["commision"]; }?>'},
               beforeSend: function () {
                   $(this).html('Sending OTP...');
               },
               success: function(res) {
                    $sModal.html(res);
                    $sModal.modal('show');
               },
           });
    });
});
  
</script>
<?php echo $this->Js->writeBuffer();?>

