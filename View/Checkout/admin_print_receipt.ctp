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
        <?php echo $this->Html->css('admin/plugins/datatable/TableTools'); ?>
        <?php echo $this->Html->css('admin/plugins/pageguide/pageguide'); ?>
        <?php echo $this->Html->css('admin/plugins/chosen/chosen'); ?>
        <?php echo $this->Html->css('admin/plugins/select2/select2.css?v=1'); ?>
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
	    window.onfocus=function(){ window.close();}
	    }
	</script>
    </head>
    <body >
        <div id="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php echo $user_detail['Address']['address']; ?>
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
                                    <?php echo $user_detail['Contact']['cell_phone']; ?>
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
                                    <b>Date:</b>     <?php echo Date('Y-m-d'); ?>
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
                                    <b>Time:</b>     <?php echo Date('h:i A'); ?>
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
                                    <b>Cashier:</b>     <?php echo Date('h:i A'); ?>
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
                                    <b>Customer:</b>     <?php echo $user_detail['User']['first_name'].' '.$user_detail['User']['last_name']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php  $total_amt=$cart->cart->service_charges+$cart->cart->product_charges+$cart->cart->gift_charges-$cart->cart->ttl_discount; ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
         		    <div class="box-content">
                                <table class="table-responsive full-w   table-condensed ">
                                    <tbody>
					<tr>
					    <td><b>Total Service Price : </b><?php echo $cart->cart->service_charges; ?></td>
					</tr>
                                        <tr>
					    <td><b>Total Product Price : </b><?php echo $cart->cart->product_charges; ?></td>
					</tr>
                                        <tr>
					    <td><b>Total Gift Certificate Price : </b><?php echo $cart->cart->gift_charges; ?></td>
					</tr>
                                        <tr>
					    <td><b>Total Discount Price : </b><?php echo $cart->cart->ttl_discount; ?></td>
					</tr>
                                        <tr>
					    <td>---------------------------------</td>
					</tr>
                                        <tr>
					    <td><b>Total Amount Due :  </b><?php  echo  $total_amt; ?></td>
					</tr>
                                        <tr>
					    <td><b>Cash Amount :  </b><?php  echo  $cart->cart->cash_amt; ?></td>
					</tr>
                                        <tr>
					    <td><b>Check Amount :  </b><?php  echo  $cart->cart->chk_amt; ?></td>
					</tr>
                                        <tr>
					    <td><b>Amount Paid :  </b><?php  echo  $cart->cart->amount_paid; ?></td>
					</tr>
                                        <tr>
					    <td><b>IOU Outstanding :  </b><?php  echo  $cart->cart->change_due; ?></td>
					</tr>
                                        <tr>
					    <td><b>Thank you</td>
					</tr>
                                    </tbody>
                                </table>
                            </div>
			</div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
