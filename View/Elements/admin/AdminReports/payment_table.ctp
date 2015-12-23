<?php if(!empty($reports)) { ?>
<div style="width:50%;margin: 0 25%;">
 <div class="col-sm-12" style="border: 2px solid #DDDDDD;padding: 10px">
  <div class="row">
   <div style="text-align: center">
    <strong>Salon:</strong>
    <?php echo @$reports['salon_name'];?></div>
  </div>
  <div class="row">
   <div style="text-align: center">
    <strong>Transactions Included:</strong>
    From <?php echo date("jS  F Y" , strtotime($reports['start']));?> to <?php echo date("jS  F Y" , strtotime($reports['end']));?></div>
  </div>
  <div class="row">
   <div style="text-align: center">
    <strong>Opening Balance (AED):</strong>
    <?php echo $reports['opening_balance'];?></div>
  </div>
  <div class="row">
   <div style="text-align: center">
    <strong>Amount Due (AED):</strong>
    <?php echo $reports['amount_due'];?></div>
  </div>
  <div class="row">
   <div style="text-align: center">
    <strong>Closing Amount (AED):</strong>
    <?php echo $reports['amount_due'];?></div>
  </div>
  <div class="row">
   <div style="float:left">
    <strong>Pay (AED):</strong>
   </div>
   <div class="col-sm-3">
     <?php echo $this->Form->input('pay_amount',array('label'=>false,'class'=>'form-control','div'=>false,'type'=>'textbox'));?>
   </div>
  </div>
  <div class="row">
   <?php echo $this->Form->button('Pay Now',array('id'=>'paynow','class'=>'btn'));?>
  </div>
 </div>
</div>
<?php } ?>


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
 
 
 <?php if(!empty($orders)){
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
    }
    ?>
 <table class="table table-hover table-nomargin dataTable table-bordered">
        <thead>
            <tr>
                <?php
                if($order_field != 'Order.created'){
                    $sort_class_cre = 'sorting';
                }else{
                    $sort_class_cre = $sort_class;
                }
                ?>
               <th style ="text-align:center">Payment For</th>
               <th style ="text-align:center">Sales Price (AED)</th>
               <th style ="text-align:center">Received from Customer (AED)</th>
               <th style ="text-align:center">Tax paid by Customer(AED)</th>
               <th style ="text-align:center">Sieasta Commission (AED)</th>
               <th style ="text-align:center">Credit card commission / Deductions (AED)</th>
               <th style ="text-align:center">Amount Due (AED)</th>
            </tr>
        </thead>
        <tbody>
            
            <?php foreach($orders as $order){?>
                <tr data-id = "<?php echo $order['Order']['id'];?>">
                    <td>
                    <?php //echo $order['Order']['service_type'];
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
                     echo $order['Order']['orignal_amount'];
                     
                    ?></td>
                    <td style ="text-align:center">
                        <?php
                          echo $order['Order']['service_price_with_tax'];
                        ?>
                    </td>
                     <td style ="text-align:center">
                        <?php
                          echo $order['Order']['tax_amount'];
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
