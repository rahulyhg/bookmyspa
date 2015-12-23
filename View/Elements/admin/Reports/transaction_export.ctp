<?php 
$serviceType=unserialize(SERVICE_TYPE);

$this->PhpExcel->createWorksheet();

$this->PhpExcel->setDefaultFont('Calibri', 12);

// define table cells
$table = array(
    array('label' => __('Date of purchase'), 'width' => 'auto', 'filter' =>true),
    array('label' => __('Service Title'), 'width' => 'auto', 'filter' =>true),
    array('label' => __('Service Type'), 'width' => 'auto', 'filter' =>true),
    array('label' => __('Transaction ID'), 'width' => 'auto'),
    array('label' => __('Date of Service Availed'), 'width' => 'auto', 'wrap' => true),
    array('label' => __('Purchased amount (AED)'), 'width' => 'auto', 'wrap' => true),
    array('label' => __('Sale Amount with tax (AED)'), 'width' => 'auto', 'wrap' => true),
    array('label' => __('Sieasta Commission(AED)'), 'width' => 'auto', 'wrap' => true),
    array('label' => __('Tax Deduction (AED)'), 'width' => 'auto', 'wrap' => true),
    array('label' => __('Credit card Commission (AED)'), 'width' => 'auto', 'wrap' => true),
    array('label' => __('Pay to Salon (AED)'), 'width' => 'auto', 'wrap' => true),
);
//pr($table);die;
// heading
$this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));

// data
foreach ($allOrders as $order) {
    foreach($serviceType as $k=>$value){
        if($order['Order']['service_type']==$k){
            $serviceName=$value;
        }
    } 
    $this->PhpExcel->addTableRow(array(
        date(DATE_FORMAT,strtotime($order['Order']['created'])),
        $order['Order']['eng_service_name'],
        $serviceName,
        $order['Order']['transaction_id'],
        date(DATE_FORMAT,strtotime($order['Order']['start_date'])),
        $order['Order']['orignal_amount'],
        $order['Order']['service_price_with_tax'],
        $order['Order']['sieasta_commision_amount'],
        $order['Order']['tax_amount'],
        $order['Order']['total_deductions'],
        $order['Order']['vendor_dues']       
    ));
}

$this->PhpExcel->addTableFooter();
//pr($this->PhpExcel);die;
$this->PhpExcel->output();
die;

?>