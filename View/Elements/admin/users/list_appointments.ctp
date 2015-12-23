<?php
if(!empty($customer_id)) {
$this->Paginator->options(
    array(
	    'update' => '#user_elements',
	    'evalScripts' => true,
	    //'url' => array('controller' => 'users', 'action' =>'admin_appointments',@$customer_id),
	    'url' => array(@$customer_id,
		'search_keyword' => @$this->request->data['search_keyword'],
		'number_records' => @$this->request->data['number_records'],
		),
	//   
	//    'before' => $this->Js->get('.loader-container')->effect(
	//	'fadeIn',
	//	array('buffer' => false)
	//    ),
	//    'complete' => $this->Js->get('.loader-container')->effect(
	//	'fadeOut',
	//	array('buffer' => false)
	//    ),
	)
    );?>
<?php  echo $this->element('admin/users/nav'); ?>

<!--<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <?php //echo $this->Js->link('Appointment','#',array('escape'=>false));?>
    </li>
    <li role="presentation">
        <?php //echo $this->Js->link('IOU','#',array('escape'=>false));?>
    </li>
    <li role="presentation">
        <?php //echo $this->Js->link('GIFT CERTIFICATE','#',array('escape'=>false));?>
    </li>
    <li role="presentation">
        <?php //echo $this->Js->link('Packages','#',array('escape'=>false));?>
    </li>
</ul>-->

<div class="tab-content">
    <?php
   if(!empty($orders)){
   
        if(!empty($this->Paginator->request->paging['Appointment']['options']['order'])){
        foreach($this->Paginator->request->paging['Appointment']['options']['order'] as $field => $direction){
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
    <div class="search-class mrgn-btm20">
    <div class="pull-left col-sm-4 nopadding">
        <div class="col-sm-3 nopadding">
            <?php echo $this->Form->select('number_records',
            array('10'=>'10','25'=>'25','50'=>'50','100'=>'100'),
            array('empty'=>false,'class'=>'form-control'));?>
        </div>
        <label class="col-sm-9 pdng-tp7" >
            Entries per page
        </label>
    </div>
    <div class="pull-right">
        <label>
            <div class="search">
              <?php echo $this->Form->input('search_keyword',array('label'=>false,'div'=>false,'placeholder'=>'Search here...','type'=>'text'));?>
              <i><?php echo $this->Html->image('admin/search-icon.png', array('title'=>"",'alt'=>""));?></i>
            </div>
        </label>
    </div>
</div>
    <div class="table-responsive">
    <table class="table table-hover table-nomargin table-bordered dataTable">
        <thead>
            <tr>
	       <?php if($order_field != 'Appointment.appointment_start_date'){
                    $sort_class_eng = 'sorting';
                } else {
                    $sort_class_eng = $sort_class;
                }
		?>
                <th class="<?php echo $sort_class_eng;?>"><?php echo $this->Paginator->sort('Appointment.appointment_start_date', 'Appointment Date',array('url' => array('controller' => 'users', 'action' =>'admin_appointments',@$customer_id)));?></th>
                <th style="text-align:center">Checked out Date</th>
		<?php if($order_field != 'Appointment.by_vendor'){
                    $sort_class_eng = 'sorting';
                } else {
                    $sort_class_eng = $sort_class;
                }
		?>
		<th class="<?php echo $sort_class_eng;?>" style="text-align:center"><?php echo $this->Paginator->sort('Appointment.by_vendor', 'Online/Offline');?></th>
		
		<?php /*if($order_field != 'Order.service_type'){
                    $sort_class_eng = 'sorting';
                } else {
                    $sort_class_eng = $sort_class;
                }*/
		?>
		<th class="<?php //echo $sort_class_eng;?>"  style="text-align:center"><?php echo 'Appointment Type';//$this->Paginator->sort('Order.service_type', 'Appointment Type');?></th>
		
		<?php if($order_field != 'Order.eng_service_name'){
                    $sort_class_eng = 'sorting';
                } else {
                    $sort_class_eng = $sort_class;
                }
		?>
		<th style="text-align:center" class="<?php echo $sort_class_eng;?>"><?php echo $this->Paginator->sort('Order.eng_service_name', 'Appointment Name');?></th>
		<?php
		    if($order_field != 'Appointment.appointment_start_date'){
			$sort_class_eng = 'sorting';
		    } else {
			$sort_class_eng = $sort_class;
		    }
		?>
		<th style="text-align:center" class="<?php echo $sort_class_eng;?>"><?php echo $this->Paginator->sort('Appointment.appointment_start_date', 'Date & Time'); ?></th>
                <?php
		    if($order_field != 'Appointment.appointment_duration'){
			$sort_class_eng = 'sorting';
		    } else {
			$sort_class_eng = $sort_class;
		    }
		?>
		<th style="text-align:center" class="<?php echo $sort_class_eng;?>"><?php echo $this->Paginator->sort('Appointment.appointment_duration', 'Duration / Sitting'); ?></th>
                <?php
		    if($order_field != 'Appointment.Price'){
			$sort_class_eng = 'sorting';
		    } else {
			$sort_class_eng = $sort_class;
		    }
		?>
		<th style="text-align:center" class="<?php echo $sort_class_eng;?>"><?php echo $this->Paginator->sort('Appointment.Price', 'Price'); ?></th>
		<th style="text-align:center">Price with Tax(AED)</th>
		<th style="text-align:center">Points Given</th>
		<th style="text-align:center">Points Used</th>
                <th style="text-align:center">Status</th>
		<th style="text-align:center">Appointment ID</th>
		<th style="text-align:center">Order ID</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i=1;
            foreach($orders as $appointment){ ?>
		<tr>
                    <td>
		    <?php
			if(!empty($appointment['Appointment']['appointment_start_date'])){
                           echo date('F d, Y h:i A',@$appointment['Appointment']['appointment_start_date']);
                        } else {
                            echo '-';
                        }
		    ?>
		    </td>
		    <td style="text-align:center">-</td>
		    <td style="text-align:center">
			<?php if($appointment['Appointment']['by_vendor'] == 1){
			    echo 'Offline';
			 }else{
			   echo 'Online';    
			}?>
		    </td>
                    <td style="text-align:center">
			<?php if(!empty($appointment['Appointment']['package_id']) && !empty($appointment['Appointment']['deal_id'])){
			    echo 'Deal';
			}else if(!empty($appointment['Appointment']['package_id'])){
			    echo 'Package';
			} else if(!empty($appointment['Appointment']['deal_id'])){
			    echo 'Deal';
			} else if(!empty($appointment['Appointment']['salon_service_id'])){
			    echo 'Service';
			} else {
			    echo '--';
			} ?>
		    </td>
		    <td>
			<?php
			 if(!empty($appointment['Order']['eng_service_name'])){
                           echo $appointment['Order']['eng_service_name'];
                        } else {
                            echo '-';
                        }
		    ?>
		    </td>
                    <td style="text-align:center"><?php
                      // echo $appointment['Order']['appointment_start_date'];
		        if(!empty($appointment['Appointment']['appointment_start_date'])){
                            echo date('F d, Y h:i A',@$appointment['Appointment']['appointment_start_date']);
                        } else {
                            echo '-';
                        }?></td>
                    <td style="text-align:center"><?php
			if(!is_null($appointment['Appointment']['evoucher_id'])){
			    echo @$appointment['Appointment']['appointment_duration'];
			}else{
			    if(!empty($appointment['Appointment']['Duration'])) {
				echo @$appointment['Appointment']['Duration'];
			    } else {
				echo '-';
			    }
			}
		    ?></td>
                    <td style="text-align:center"><?php
			    if(!is_null($appointment['Appointment']['evoucher_id'])){
				echo @$appointment['Appointment']['appointment_price'];
			    }else{
				if(!empty($appointment['Appointment']['Price'])){
				    echo $appointment['Appointment']['Price'];
				} else {
				    echo '-';
				}
			    }
			?></td>
			 
		     <td style="text-align:center"><?php
			if(!is_null($appointment['Appointment']['evoucher_id'])){
				echo '-';
			    }else{
				echo $appointment['Order']['service_price_with_tax'];
			    }
		     ?></td>
                   <td style="text-align:center"><?php
		         if(!empty($appointment['Order']['points_given'])){
                            echo $appointment['Order']['points_given'];
                        } else {
                            echo '-';
                        }
			?></td>
			 <td style="text-align:center"><?php
		         if(!empty($appointment['Order']['points_used'])){
                            echo $appointment['Order']['points_used'];
                        } else {
                            echo '-';
                        }
			?></td>
		    <td style="text-align:center">
		    <?php 
		    switch ($appointment['Appointment']['status']) {
			case "1":
			    echo "Confirmed";
			    break;
			case "0":
			    echo "Waiting";
			    break;
			case "2":
			    echo "Checkin";
			    break;
			case "3":
			    echo "Checkout";
			    break;
			case "4":
			    echo "Paid";
			    break;
			case "5":
			    echo "Cancel";
			    break;
			case "6":
			    echo "In Progress";
			    break;
			case "7":
			    echo "Show";
			    break;
			case "8":
			    echo "No Show";
			    break;
			case "9":
			    echo "Denied";
			    break;
			default:
			    echo "---";
		    }
		    ?>
		</td>
		 <td style="text-align:center"> <?php
		 if(empty($appointment['Appointment']['package_id'])){
		    if(empty($appointment['Appointment']['deal_id'])){
		         echo $this->HTML->link($appointment['Appointment']['id'],'javascript:void(0)',array('escape'=>false,'data-id'=>base64_encode($appointment['Appointment']['id']),'data-type'=>'Appointment','class'=>'AppointmentIDN'));	    
		    }else{
			echo $appointment['Appointment']['id'];
		    }
		  }else{
		    echo '--';
		  }
		?></td>
		 <td style="text-align:center">
		 <?php
		 if($appointment['Appointment']['by_vendor'] == 1){
		   echo  $appointment['Order']['display_order_id'];
		 }else{
		    if(!empty($appointment['Appointment']['package_id']) || !empty($appointment['Appointment']['deal_id'])){
			echo  $appointment['Order']['display_order_id'];
		    }else{
			echo $this->HTML->link($appointment['Order']['display_order_id'],'javascript:void(0)',array('escape'=>false,'data-id'=>base64_encode($appointment['Order']['id']),'data-type'=>'Order','class'=>'AppointmentIDN'));	
		    }
		  
		 }
		 ?>
		 </td>
            </tr>    
            <?php $i++; } ?>
        </tbody>
    </table>
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
    <?php }else{
	    echo 'No record found.';	
	} ?>
</div>
<div class="clearfix"></div>
<?php }

?>
<script type="test/javascript">
$(document).ready(function(){
    var $appointmentHistorymodal = $('#commonSmallModal');
    var itsId ="";
    var OrderApnt = "";
    $(document).off('click','.AppointmentIDN').on('click','.AppointmentIDN' ,function(){
        itsId = $(this).attr('data-id');
	OrderApnt = $(this).attr('data-type');
        var appointmentHistory = "<?php echo $this->Html->url(array('controller'=>'Customers','action'=>'appointment_history')); ?>";
        resetURL = appointmentHistory+'/'+OrderApnt+'/'+itsId
        // function in modal_common.js
        $('body').modalmanager('loading');
        fetchModal($appointmentHistorymodal,resetURL);
	
    });
    
    $('#search_keyword').keyup(function(){
	var url = "/admin/users/appointments/<?php echo @$customer_id; ?>";
    
	  $.post(url,
                 {
                    search_keyword: $('#search_keyword').val(),
                    number_records: $('#number_records').val(),
                    },
                    function(data,status){
                        $('#user_elements').html(data);
                        $('#search_keyword').focus();
                        $('#search_keyword').caretToEnd();
                        //alert($('#search_keyword').val());
                        //$('#search_keyword').val($('#search_keyword').val());
                    }
          );  
	
	
});
$('#number_records').change(function(){
    var url = "/admin/users/appointments/<?php echo @$customer_id; ?>";
          $.post(url,
                    {
                              search_keyword: $('#search_keyword').val(),
                              number_records: $('#number_records').val(),
                    },
                    function(data,status){
                              $('#user_elements').html(data);
                    }
          );
});
});
</script>
<?php  echo $this->Html->script('admin/customer/appointment_history'); ?>
<?php echo $this->Js->writeBuffer();?>