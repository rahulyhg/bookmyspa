<!DOCTYPE html>
<html>
    <head>
	<?php echo $this->Html->charset(); ?>
        <title><?php echo 'Sieasta'?> | Print Ticket</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta name="description" content="Sieasta">
        <meta name="author" content="Sieasta">
        <!-- Apple devices fullscreen -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Apple devices fullscreen -->
        <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <?php 
        echo $this->Html->meta ( 'favicon.ico', '/img/favicon.ico', array (
                'type' => 'icon' 
            ) );
        ?>
        <?php echo $this->Html->css('admin/bootstrap3'); ?>
			<?php //echo $this->Html->css('admin/plugins/jquery-ui/smoothness/jquery-ui'); ?>
			<?php //echo $this->Html->css('admin/plugins/jquery-ui/smoothness/jquery.ui.theme'); ?>
			<?php echo $this->Html->css('admin/plugins/datatable/TableTools'); ?>
			<?php echo $this->Html->css('admin/plugins/pageguide/pageguide'); ?>
			<?php echo $this->Html->css('admin/plugins/chosen/chosen'); ?>
			<?php echo $this->Html->css('admin/plugins/select2/select2.css?v=1'); ?>
			<?php //echo $this->Html->css('admin/plugins/icheck/all'); ?>
			<?php echo $this->Html->css('admin/form'); ?>
			<?php echo $this->Html->css('admin/bootstrap-switch'); ?>
			<?php echo $this->Html->css('admin/developers'); ?>
			<?php echo $this->Html->css('admin/custom'); ?>
			<?php echo $this->Html->css('frontend/multiple-select'); ?>
			<?php echo $this->Html->css('admin/themes_not_minified'); ?>
			<?php echo $this->Html->css('admin/developer'); ?>
			
			<?php echo $this->Html->css('admin/style_not_minified.css?v=7'); ?>
			
			<?php echo $this->Html->css('admin/color/red.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/orange.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/green.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/brown.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/blue.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/lime.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/teal.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/purple.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/pink.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/magenta.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/grey.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/darkblue.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/lightred.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/lightgrey.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/satblue.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/satgreen.css?v=5'); ?>
			<script>
			window.onload = function() { window.print();
			//document.location.href = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'index','admin'=>true)); ?>";
			window.onfocus=function(){ window.close();}
			}
			</script>
    </head>
    <body  >
        <div id="main">
            <div class="container-fluid">
                <h3 class="txt-center"><?php echo "Sieasta | Print Detailed Daily Plan"; ?></h2>
                <h5>Daily Detailed Task Plan for Date : <?php echo date('M-d-Y',$appointments['Appointment']['appointment_start_date']);?></h4>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            
                                <div class="row">
                                    <div class="col-sm-12">
                                        Service Provider : <?php echo $appointments['User']['first_name'].' '.$appointments['User']['last_name']; ?>
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            
                                <div class="row">
                                    <div class="col-sm-12">
                                        Customer :  <?php echo $customer_details['User']['first_name'].' '.$customer_details['User']['last_name']; ?>
                                    </div>
                                </div>
                           
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            
			    
			    <div class="box-content">
                                <table class="table-responsive full-w   table-condensed ">
                                    
                                    <tbody>
					<tr>
					    <td>Cell :  <?php echo ($customer_details['Contact']['cell_phone']  ?  $customer_details['Contact']['cell_phone'] : '----') ?> (AirVoice) </td>
                                            <td>Total No. of Booking : <?php echo $total_bookings; ?></td>
					    <td>Customer Since : <?php echo date('M-d-Y',strtotime($customer_details['User']['created'])); ?></td>
					</tr>
					<tr>
					    <td>Day Phone : <?php echo ($customer_details['Contact']['day_phone']  ?  $customer_details['Contact']['day_phone'] : '----') ?> </td>
					    <td>Total amount Paid : <?php echo $total_price[0][0]['total_price']; ?></td>
					    <td>Night Phone : <?php echo ($customer_details['Contact']['night_phone']  ?  $customer_details['Contact']['night_phone'] : '----') ?></td>
					</tr>
					<tr>
					    <td>Email : <?php echo ($customer_details['User']['email'] ? $customer_details['User']['email']:'------') ?></td>
					    <td>BirthDate : <?php echo $customer_details['UserDetail']['dob']; ?></td>
                                           
                                        </tr>
					
                                    </tbody>
                                </table>
                            </div>
			    
			    
			    
			    
			    
			    
			    
			    
			    
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            <div class="box-content lft-p-non">
                                <div class="col-sm-12">
                                    Appointments Summary:
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            <div class="box-content">
                                <table class="table-responsive full-w  table-bordered table-striped table-condensed cf">
                                    <thead class="cf">
                                        <tr>
                                            <th>Date</th>
                                            <th>App Type</th>
                                            <th>Status</th>
                                            <th>Service</th>
                                            <th>Service Provider</th>
                                            <th>Price</th>
                                            <!--<th>Resource</th>-->
                                            <th>Comment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
					<tr>
                                            <td><?php echo date('M-d-Y H:m A',$appointments['Appointment']['appointment_start_date']);?></td>
                                            <td><?php if($appointments['Appointment']['type']=='A') echo 'Appointment'; else '----'; ?></td>
                                            <td><?php if($appointments['Appointment']['status']==1) echo 'Confirmed'; else '----'; ?></td>
                                            <td><?php echo $appointments['SalonService']['eng_name']; ?></td>
                                            <td><?php echo $appointments['User']['first_name'].' '.$appointments['User']['last_name']; ?></td>
                                            <td><?php echo $appointments['Appointment']['appointment_price']; ?></td>
                                            <!--<td>--</td>-->
                                            <td><?php if($appointments['Appointment']['appointment_comment']!='') echo $appointments['Appointment']['appointment_comment']; else '----'; ?></td>
                                        </tr>
					
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            <div class="box-content lft-p-non">
                                <div class="col-sm-12">
                                    Previous 5 Appointments :
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            <div class="box-content">
                                <table class="table-responsive full-w table-bordered table-striped table-condensed cf">
                                    <thead class="cf">
                                        <tr>
                                            <th>Date</th>
                                            <th>App Type</th>
                                            <th>Status</th>
                                            <th>Service</th>
                                            <th>Service Provider</th>
                                            <th>Price</th>
                                            <th>Resource</th>
					    <!--<th>Tip</th>-->
                                            <th>Comment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
					<?php foreach($prevoius_appointments as $prevoius_appointment){ ?>
                                        <tr>
                                             <td><?php echo date('M-d-Y H:m A',$prevoius_appointment['Appointment']['appointment_start_date']);?></td>
                                            <td><?php if($prevoius_appointment['Appointment']['type']=='A') echo 'Appointment'; else '----'; ?></td>
                                            <td><?php if($prevoius_appointment['Appointment']['status']==1) echo 'Confirmed'; else '----'; ?></td>
                                            <td><?php echo $prevoius_appointment['SalonService']['eng_name']; ?></td>
                                            <td><?php echo $appointments['User']['first_name'].' '.$appointments['User']['last_name']; ?></td>
                                            <td><?php echo $prevoius_appointment['Appointment']['appointment_price']; ?></td>
                                            <td>--</td>
					   <!-- <td>--</td>-->
                                            <td><?php if($prevoius_appointment['Appointment']['appointment_comment']!='') echo $appointments['Appointment']['appointment_comment']; else '----'; ?></td>
                                        </tr>
					<?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            <div class="box-content lft-p-non">
                                <div class="col-sm-12">
                                    Previous 5 Products :
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            <div class="box-content">
                                <table class="table-responsive full-w  table-bordered table-striped table-condensed cf">
                                    <thead class="cf">
                                        <tr>
                                            <th>Date</th>
                                            <th>Barcode Id</th>
                                            <th>Brand</th>
                                            <th>Product Type</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <!--<th>Tip</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
					<?php foreach($prevoius_products as $prevoius_product){ ?>
                                        <tr>
                                            <td><?php echo $prevoius_product['Product']['purchase_date']; ?> </td>
                                            <td><?php echo $prevoius_product['Product']['barcode']; ?> </td>
                                            <td><?php echo $prevoius_product['Brand']['eng_name']; ?></td>
                                            <td><?php echo $prevoius_product['ProductType']['eng_name']; ?> </td>
                                            <td><?php echo $prevoius_product['Product']['eng_product_name']; ?></td>
                                            <td><?php echo $prevoius_product['Product']['quantity']; ?></td>
                                            <td><?php echo $prevoius_product['Product']['selling_price']; ?></td>
                                            <!--<td>---</td>-->
                                        </tr>
					<?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            <div class="box-content lft-p-non">
                                <div class="col-sm-12">Previous 5 Notes :</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="box">
                            <div class="box-content lft-p-non">
                                <div class="col-sm-12">No Previous Notes Found !!</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            
                                <div class="col-sm-4">General :</div>
                                <div class="col-sm-8">
                                    <hr>
                                </div>
                           
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="box">
                            
                                <div class="col-sm-4">Allergy:</div>
                                <div class="col-sm-8">
                                    <hr>
                                </div>
                            
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="box">
                            
                                <div class="col-sm-4">Formula :</div>
                                <div class="col-sm-8">
                                    <hr>
                                </div>
                    
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="box">
                            
                                <div class="col-sm-4">Suggested Products and Services :</div>
                                <div class="col-sm-8">
                                    <hr>
                                </div>
                            
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="box">
                            
                                <div class="col-sm-4">Rebook Information:</div>
                                <div class="col-sm-8">
                                    <hr>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
