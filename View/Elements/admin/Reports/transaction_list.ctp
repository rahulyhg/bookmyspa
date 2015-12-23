<?php 
if(isset($this->request->named) && !empty($this->request->named)){
    $this->request->data=$this->request->named;
}
$this->Paginator->options(array(
    'update' => '#list-types',
    'evalScripts' => true,
    'url' => array(
        'search_keyword' => @$this->request->data['search_keyword'],
        'number_records' => @$this->request->data['number_records'],
        'startDate' => @$this->request->data['startDate'],
        'endDate' => @$this->request->data['endDate'],
        'serviceType' => @$this->request->data['serviceType'],
        'sieasta_order_id' => @$display_order_id,
        'salon_id'=>@$this->request->data['saloon'],
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
/*Unserialize service type to use in filter and get the value*/
$serviceType = unserialize(SERVICE_TYPE); ?>
<style>
    #s2id_saloon{width: 20%}
</style>
<?php echo $this->element('admin/Reports/transaction_filter');?>
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
    <div class="pull-right">
         <label>
            <div class="search">
              <?php //echo $this->Form->input('search_keyword',array('label'=>false,'div'=>false,'placeholder'=>'Search here...','type'=>'text'));?>
              <i><?php //echo $this->Html->image('admin/search-icon.png', array('title'=>"",'alt'=>""));?></i>
            </div>
        </label>
    </div>
</div>
<?php
    if(!empty($allOrders)){
       if(isset($this->Paginator->request->paging['Order']['options']['order']) && !empty($this->Paginator->request->paging['Order']['options']['order'])){
            foreach($this->Paginator->request->paging['Order']['options']['order'] as $field => $direction){
                $order_field = $field;
                $ord_dir = $direction;
            }
        }else{
                $order_field = 'Order.id';
                $ord_dir = 'desc';
        }
    $sort_class = 'sorting';
    if($ord_dir == 'desc'){
        $sort_class = 'sorting_desc';
    } else if($ord_dir == 'asc') {
        $sort_class = 'sorting_asc';
    }
    ?>
    <div class='table-responsive'>
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
               <th class="<?php echo $sort_class_cre;?>" style ="text-align:center"><?php echo $this->Paginator->sort('Order.created','Date of purchase');?></th>
               <th style ="text-align:center">Sieasta Order ID</th>
               <th style ="text-align:center">Transaction ID<br>(<i>CC Avenue transaction id</i>)</th>
               <th style ="text-align:center">Service Title</th>
               <th style ="text-align:center">Service Type</th>
                <?php
                    if($order_field != 'Order.start_date'){
                        $sort_class_cre = 'sorting';
                    }else{
                        $sort_class_cre = $sort_class;
                    }
                ?>
               <th class="<?php echo $sort_class_cre;?>" style ="text-align:center"><?php echo $this->Paginator->sort('Order.start_date','Availed Date');?></th>
               <th style ="text-align:center">Purchased amount (AED)</th>
               <th style ="text-align:center">Sale Amount with tax (AED)</th>
               <th style ="text-align:center">Paid with GC</th>
               <th style ="text-align:center">Paid with points</th>
               <th style ="text-align:center">Paid with Sieasta points</th>
               <th style ="text-align:center">Paid with Card</th>
               <th style ="text-align:center">Sieasta Commission(AED)</th>
               <th style ="text-align:center">Tax Deduction (AED)</th>
               <th style ="text-align:center">Credit card Commission(AED)</th>
               <th style ="text-align:center">Pay to Salon (AED)</th>
               <th style ="text-align:center">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($allOrders as $order){
                //pr($order);
                ?>
                <tr data-id = "<?php echo $order['Order']['id'];?>">
                    <td>
                        <?php
                            echo date(DATE_FORMAT,strtotime($order['Order']['created']));
                        ?>
                    </td>
                    <td>
                       <?php echo  $this->Html->link(__($order['Order']['display_order_id'],true) , 'javascript:void(0)',array('class'=>'orderID','id'=>$order['Order']['display_order_id'])); ?>
                        <?php
                            //echo  $order['Order']['display_order_id'];
                        ?>
                    </td>
                    <td style ="text-align:center">
                        <?php
                        if(!empty($order['Order']['transaction_id'])){
                            echo $order['Order']['transaction_id'];  
                        }
                        ?>
                    </td>
                  
                    <td style ="text-align:center">
                        <?php
                          echo $order['Order']['eng_service_name'];
                        ?>
                    </td>
                    <td style ="text-align:center"><?php
                        foreach($serviceType as $k=>$value){
                            if($order['Order']['service_type']==$k){
                                echo $value;
                            }
                        }     
                    ?>
                    
                    </td>
                    <?php
                        $availed = true;
                        if($order['Order']['order_avail_status'] !=1  && ($order['Order']['service_type'] !=6 && $order['Order']['service_type'] !=7)){
                        $availed = false;
                        } 
                        if($availed){ ?>
                             <td style ="text-align:center">
                                <?php
                                    if(!empty($order['Order']['start_date'])){
                                        echo date(DATE_FORMAT,strtotime($order['Order']['start_date'])); 
                                    } ?>
                            </td>
                            
                       <?php  }else{  ?>
                     <td></td>
                      <?php } ?>
                    <td style ="text-align:center">
                        <?php
                          echo $order['Order']['orignal_amount'];
                        ?>
                    </td>
                    <td style ="text-align:center">
                        <?php echo $order['Order']['service_price_with_tax'];?>
                    </td>
                    <td style ="text-align:center">
                        <?php
                            if(in_array($order['Order']['transaction_status'],array(1,5,6,7,8))){
                                 echo $order['Order']['gift_amount'];
                            }else{
                                 echo '-';
                            }
                        
                        ?>
                    </td>
                     <td style ="text-align:center">
                        <?php
                            if(in_array($order['Order']['transaction_status'],array(1,5,6,7,8))){
                                 echo $order['Order']['salon_point_price'];
                            }else{
                                 echo '-';
                            }
                        ?>
                    </td>
                     <td style ="text-align:center">
                        <?php
                            if(in_array($order['Order']['transaction_status'],array(1,5,6,7,8))){
                                 echo $order['Order']['sieasta_point_price'];
                            }else{
                                 echo '-';
                            }
                        ?>
                    </td>
                    <td style ="text-align:center">
                        <?php
                            if(in_array($order['Order']['transaction_status'],array(1,5,6,7,8))){
                                 echo $order['Order']['amount'];
                            }else{
                                 echo '-';
                            }
                        ?>
                    </td>
                    <?php if($availed){?>
                    <td style ="text-align:center">
                        <?php echo $order['Order']['sieasta_commision_amount'];?>
                    </td>
                    <td style ="text-align:center">
                        <?php echo $order['Order']['tax_amount'];?>
                    </td>
                    <td style ="text-align:center">
                        <?php echo $order['Order']['total_deductions'];?>
                    </td>
                    <td style ="text-align:center">
                        <?php echo $order['Order']['vendor_dues'];?>
                    </td>
                    <?php }else{ ?>
                    <td></td><td></td><td></td><td></td>
                    <?php }?>
                    <td style ="text-align:center">
                        <?php
                               $first_day =   date('Y-m-01');
                               $middle_day =  date('Y-m-d' , strtotime('+14 days', strtotime($first_day)));
                               //$middle_time =  strtotime(date('Y-m-d' , strtotime('+14 days',$first_day)));
                               $current = date('Y-m-d');
                                 $middle = false;
                               if($current>$middle_day){
                                 $middle = true;
                               }
                               
                                $booking_status = '';
                                if($order['Order']['service_type'] == 6){
                                 $booking_status  ='Gift certificate Issued';
                                }elseif($order['Order']['service_type'] == 7){
                                           if(in_array($order['Order']['transaction_status'],array(1,5,6,7,8))){
                                               $avail_date = date('Y-m-d' , strtotime($order['Order']['start_date']));    
                                               if($middle && ($avail_date <= $middle_day)){
                                                $booking_status = 'Payment Released';      
                                               }else if(!$middle && ($avail_date < $first_day)){
                                                 $booking_status = 'Payment Released';     
                                               }else{
                                                 $booking_status = 'Availed';   
                                               }
                                           }else{
                                            $booking_status = 'Cancelled'; 
                                           }
                                 // $booking_status  ='Payment Released';
                                }else{
                                        if($order['Order']['order_avail_status']==0 && in_array($order['Order']['transaction_status'],array(1,5,6,7,8))){
                                            $booking_status = 'Booked';
                                        }elseif($order['Order']['order_avail_status']==1){
                                                $avail_date = date('Y-m-d' , strtotime($order['Order']['start_date']));    
                                               if($middle && ($avail_date <= $middle_day)){
                                                $booking_status = 'Payment Released';      
                                               }else if(!$middle && ($avail_date < $first_day)){
                                                 $booking_status = 'Payment Released';     
                                               }else{
                                                 $booking_status = 'Availed';   
                                               }
                                        } else{
                                            $booking_status = 'Cancelled';
                                        }
                                } 
                                echo $booking_status;
                        ?>
                    </td>
                </tr>
            <?php }?>
        </tbody>
    </table>
    
    
    </div>
    <div>
        <div class="result_pages">
            <?php 
            $pagingArr = $this->Paginator->params();
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
echo $this->Html->script('admin/reports/transaction_list');
?>
<script type="text/javascript">
    $(document).ready(function(){
        // enable datepicker
        //maxDate= new Date();
        
        $("#startDate").datepicker({
            dateFormat: 'dd-mm-yy',
            numberOfMonths: 1,
            maxDate: '0',
            onClose: function( selectedDate ) {
                $( "#endDate" ).datepicker( "option", "minDate", selectedDate );
            }
        });
        $("#endDate").datepicker({
            dateFormat: 'dd-mm-yy',
            numberOfMonths: 1,
            maxDate: '0',
            onClose: function( selectedDate ) {
                $( "#endDate" ).datepicker( "option", "maxDate", selectedDate );
            }
        });
        $(document).find("#saloon").select2();
    });
        $(document).find('#submitTransaction').click(function(){
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            var serviceType = $('#serviceType').val();
            var saloon = $('#saloon').val();
            console.log(saloon);
            var sieasta_order_id = $('#sieasta_order_id').val();
            if(startDate!='' || endDate!=''){
                if(startDate==''){
                   alert('Please enter start date.');
                   return false;
                }else if(endDate==''){
                   alert('Please enter end date.'); 
                   return false;
                }
            }
            $(".loader-container").show();
            $.ajax({
                url: "<?php echo $this->Html->url(array('controller'=>'reports','action'=>'transactionReport' , 'admin'=>true)) ; ?>",
                type: "POST",
                data: {startDate:startDate,endDate:endDate,serviceType:serviceType,saloon:saloon,sieasta_order_id:sieasta_order_id},
                success: function(res) {
                    $('#list-types').html(res);
                    $(".loader-container").hide();
                }
            });
        });
        $("#reset").click(function(){
            $('#startDate').val('');
            $('#endDate').val('');
            $('#serviceType').val('');
            $('#saloon').val('');
            $(".loader-container").show();
            $.ajax({
                    url: "<?php echo $this->Html->url(array('controller'=>'reports','action'=>'transactionReport' , 'admin'=>true)) ; ?>",
                    type: "POST",
                    data: {startDate:'',endDate:'',serviceType:'',saloon:''},
                    success: function(res) {
                            $('#list-types').html(res);
                            $(".loader-container").hide();
                    }
            });
        });
        $(document).find('#exportTransaction').click(function(){
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            var serviceType = $('#serviceType').val();
            var saloon = $('#saloon').val();
             if(startDate!='' || endDate!=''){
                if(startDate==''){
                   alert('Please enter start date.');
                   return false;
                }else if(endDate==''){
                   alert('Please enter end date.'); 
                   return false;
                }
                window.location="<?php echo $this->Html->url(array('controller'=>'reports','action'=>'transactionReport' , 'admin'=>true)) ; ?>/startDate:"+startDate+'/endDate:'+startDate+'/serviceType:'+serviceType+'/saloon:'+saloon+'/type:'+'export'
            }
            else{
                window.location="<?php echo $this->Html->url(array('controller'=>'reports','action'=>'transactionReport' , 'admin'=>true)) ; ?>/startDate:"+startDate+'/endDate:'+startDate+'/serviceType:'+serviceType+'/saloon:'+saloon+'/type:'+'export'
            }
            
        });
        $forOrderDetailmodal =  $('#commonVendorModal'); 
        $(document).off('.orderID').on('click','.orderID',function(){
               var orderID = $(this).attr('id');
               var Detailurl = '<?php echo $this->Html->url(array('controller'=>'Reports','action'=>'order_details','admin'=>true));?>'+'/'+orderID;
               fetchstaticModal($forOrderDetailmodal,Detailurl);
        });
</script>
<?php echo $this->Js->writeBuffer();?>