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
    );
echo $this->element('admin/users/nav'); ?>
<div class="tab-content">

<?php
			       if(!empty($evouchers)){  
                                    if(!empty($this->Paginator->request->paging['Evoucher']['options']['order'])){
                                    foreach($this->Paginator->request->paging['Evoucher']['options']['order'] as $field => $direction){
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
                                          <?php echo $this->Form->input('search_keyword',array('label'=>false,'div'=>false,'placeholder'=>'Search Voucher Code','type'=>'text'));?>
                                          <i><?php echo $this->Html->image('admin/search-icon.png', array('title'=>"",'alt'=>""));?></i>
                                        </div>
                                    </label>
                                </div>
                            </div>
				<table class="table table-hover table-nomargin table-bordered">
				    <thead>
					<tr>
                                         <?php
                                         
                                         if($auth_user['User']['id'] == 1) { ?>
					    <th style="text-align:center">Salon Name</th>
                                            <?php } ?>
					    <th style="text-align:center">Voucher Type</th>
                                            <th style="text-align:center">Name</th>
                                            <th style="text-align:center">Voucher Code</th>
                                            <th style="text-align:center">Expiry Date</th>
					    <th style="text-align:center">Quantity</th>
					    <th style="text-align:center">Used</th>
					    <th style="text-align:center">Remaining</th>
                                             <?php if($auth_user['User']['id'] != 1) { ?>
                                                <th style="text-align:center">Action</th>
                                            <?php } ?>
					</tr>
				    </thead>
				    <tbody>
					<?php
					$i=1;
		    foreach($evouchers as $singleRecord){ ?>
					    <tr>
                                             <?php if($auth_user['User']['id'] == 1) { ?>
						<td style="text-align:center"><?php
                                                    if(isset($singleRecord['Evoucher']['salon_id']) && !empty($singleRecord['Evoucher']['salon_id'])){
                                                        echo  $this->Common->get_salon_name($singleRecord['Evoucher']['salon_id']);
                                                    } else {
							echo '--';
						    }
                                             }    
						?></td>
                                                <td style="text-align:center">
                                                <?php
                                                $evoucherType = $singleRecord['Evoucher']['evoucher_type'];
                                                switch ($evoucherType) {
							    case 1:
								//servicename
								$salon_service_name = $this->Common->get_salon_service_name($singleRecord['Order']['salon_service_id']);
								//serviceimage
								//$image = $this->Common->getsalonserviceImage($order['Order']['salon_service_id'],$order['Order']['salon_id']);
								//echo $evoucherType;
								$type  = 1;
								$typeName = 'Service';
								break;
							    case 2:
								//packagename
								$salon_service_name = $this->Common->get_salon_package_name($singleRecord['Order']['salon_service_id']);
								//packageimage
								//$image = $this->Common->getpackageImage($order['Order']['salon_service_id'],$order['Order']['salon_id']);
								//echo $evoucherType;
								//code for package evoucher
								$type  = 2;
								$typeName = 'Package';
								break;
							    case 3:
								//packagename
								$salon_service_name = $this->Common->get_salon_package_name($singleRecord['Order']['salon_service_id']);
								//packageimage
								//$image = $this->Common->getpackageImage($order['Order']['salon_service_id'],$order['Order']['salon_id']);
								//echo $evoucherType;
								//code for package evoucher
								$type  = 2;
								$typeName = 'Spaday';
								break;
							    case 4:
								// DEal name
								$salon_service_name = $this->Common->get_salon_deal_name($singleRecord['Order']['salon_service_id']);
								//deal image
								//$image = $this->Common->getDealImage($order['Order']['salon_service_id'],$order['Order']['salon_id']);
								$dealType = $this->Common->getDealType($singleRecord['Order']['salon_service_id']);
								if(isset($dealType['Deal']) && !empty($dealType['Deal']) && isset($dealType['DealServicePackage']) && !empty($dealType['DealServicePackage'])){
								    $dealtype = $dealType['Deal']['type'];
								    if($dealtype == 'Service'){
									$type  = 1;
									$typeName = 'Service Deal';
									
								    }else{
									$type  = 2;
									$typeName = 'Package Deal';
									
								    }
								}
								//echo $evoucherType;
								//code for deal evoucher
								//$type  = 2;
								//$typeName = 'deal';
								//code for deal evoucher
								break;
							    case 5:
								//code for spabreak evoucher
								//servicename
								$salon_service_name = $this->Common->get_spabreak_name($singleRecord['Order']['salon_service_id']);
								//serviceimage
                                                                //pr($order);

								//$image = $this->Common->getspabreakImage($order['Order']['salon_service_id'],null,350);
								//echo $evoucherType;
								$type  = 5;
								$typeName = 'SpaBreak';
                                                                break;
						    }
                                                    
                                                    echo $typeName;
                                                    
                                                    ?>
                                                    
                                                </td>
                                                <td style="text-align:center"><?php echo $salon_service_name; ?></td>
						
                                                <td style="text-align:center"><?php
                                                    if(isset($singleRecord['Evoucher']['vocher_code']) && !empty($singleRecord['Evoucher']['vocher_code'])){
                                                        echo $singleRecord['Evoucher']['vocher_code'];
                                                    } else {
							echo '--';
						    }
						?></td>
						<td style="text-align:center"><?php
                                                        if(isset($singleRecord['Evoucher']['expiry_date']) && !empty($singleRecord['Evoucher']['expiry_date'])){
                                                           echo  date('F d, Y',strtotime($singleRecord['Evoucher']['expiry_date']));
                                                        } else {
                                                            echo '--';
                                                        }
                                                    
                                                ?></td>
						<td style="text-align:center">
                                                <?php
                                                        if(isset($singleRecord['Evoucher']['quantity']) && !empty($singleRecord['Evoucher']['quantity'])){
                                                            echo $singleRecord['Evoucher']['quantity'];
                                                        } else {
                                                            echo '--';
                                                        }
                                                ?></td>
                                                <td style="text-align:center">
						    <?php
                                                        if(isset($singleRecord['Evoucher']['evoucherused']) && !empty($singleRecord['Evoucher']['evoucherused'])){
                                                            echo $singleRecord['Evoucher']['evoucherused'];
                                                        } else {
                                                            echo '--';
                                                        }
                                                    ?>
						</td>
                                                 <td style="text-align:center">
						    <?php
                                                        if(isset($singleRecord['Evoucher']['evoucherused'])  && isset($singleRecord['Evoucher']['quantity'])){
                                                        $remainingQTy = $singleRecord['Evoucher']['quantity']-$singleRecord['Evoucher']['evoucherused'];
                                                        echo $remainingQTy == 0 ? '--' : $remainingQTy;
                                                        } else {
                                                            echo '--';
                                                        }
                                                    ?>
						</td>
                                            <?php if($auth_user['User']['id'] != 1) { ?>
                                                <td style="text-align:center">
                                                  <?php echo $this->HTML->link('<i class="glyphicon-circle_minus"></i>','javascript:void(0)',array('escape'=>false,'title'=>'Subtract','class'=>'sub_qty','data-code'=>$singleRecord['Evoucher']['vocher_code'])); ?>	    
                                                </td>
					    <?php } ?>
					</tr>    
					<?php $i++; } ?>
				    </tbody>
				</table>
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
<?php }?>
<script>
$(document).ready(function(){
    $('.sub_qty').on('click',function(){
     if(confirm('Are you sure you want to continue?')){
            var code = $(this).data('code');
            var url = "/admin/Customers/evoucher_verify/";
            $.post(url,
                     {
                        voucher_code:code,
                        },
                        function(data,status){
                           if(data == 'success'){
                                $("#eVoucherTab a").trigger('click');
                                alert('Evoucher used successfully.');
                           }else if(data == 'error'){
                                alert('There was some error.');
                           }else if(data == 'used'){
                                alert('Evoucher is already used.');
                           }else if(data == 'expired'){
                                alert('Evoucher is expired.');
                           }
                        }
              ); 
        }
    
    });
    
    
    
    $('#search_keyword').keyup(function(){
            var url = "/admin/Customers/evoucher_redeem/<?php echo @$customer_id; ?>";
        
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
        var url = "/admin/Customers/evoucher_redeem/<?php echo @$customer_id; ?>";
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