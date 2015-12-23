<?php   header("Content-type: application/pdf"); 
        $base_path=$_SERVER['DOCUMENT_ROOT'];
        App::import('Vendor','xtcpdf');
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->SetMargins('10', '0', '10');
        $pdf->AddPage();
        $html= "<div id='main'><div class='container-fluid'><div class='contact'><div class='col-sm-12'>".$user_detail['Address']['address']."</div><div class='col-sm-12'>".$user_detail['Contact']['cell_phone']."</div><div class='col-sm-12'><b>Date:</b>".Date('Y-m-d')."</div><div class='col-sm-12'><b>Time:</b>   ".Date('h:i A')."</div><div class='col-sm-12'><b>Cashier:</b>".Date('h:i A')."</div><div class='col-sm-12'><b>Customer:</b>".$user_detail['User']['first_name'].' '.$user_detail['User']['last_name']."</div></div>";

        $total_amt=$checkoutData['cart']['service_charges']+$checkoutData['cart']['product_charges']+$checkoutData['cart']['gift_charges']-$checkoutData['cart']['ttl_discount'];

        $html.="<div class='detail'><table class='table-responsive full-w   table-condensed '><tbody><tr><td><b>Total Service Price : </b>".$checkoutData['cart']['service_charges']."</td></tr><tr><td><b>Total Product Price : </b>".$checkoutData['cart']['product_charges']."</td></tr><tr><td><b>Total Gift Certificate Price : </b>". $checkoutData['cart']['gift_charges']."</td></tr><tr><td><b>Total Discount Price : </b>".$checkoutData['cart']['ttl_discount']."</td></tr><tr><td>---------------------------------</td></tr><tr><td><b>Total Amount Due :  </b>".$total_amt."</td></tr><tr><td><b>Cash Amount :  </b>".$checkoutData['cart']['cash_amt']."</td></tr><tr><td><b>Check Amount :  </b>".$checkoutData['cart']['chk_amt']."</td></tr><tr><td><b>Amount Paid :  </b>".$checkoutData['cart']['amount_paid']."</td></tr><tr><td><b>IOU Outstanding :  </b>".$checkoutData['cart']['change_due']."</td></tr><tr><td><b>Thank you</b></td></tr></tbody></table></div></div></div>";
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();
        echo $pdf->Output(WWW_ROOT . 'files/pdf' . DS . 'invoice-'.base64_decode($checkoutData['Appointment']['user_id']).'.pdf', 'F');
         $this->common->admin_mail_pdf('',base64_decode($checkoutData['Appointment']['user_id']),'','','','mail_order_pdf','');
?>






    
