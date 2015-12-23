<?php 
$this->PhpExcel->createWorksheet();
$this->PhpExcel->setDefaultFont('Calibri', 12);
// define table cells
$table = array(
    array('label' => __('Date'), 'width' => 'auto', 'filter' => true),
    array('label' => __('Type'), 'width' => 'auto', 'filter' => true),
    array('label' => __('Reason'), 'width' => 'auto'),
    array('label' => __('Vendor'), 'width' => 'auto', 'wrap' => true),
    array('label' => __('Selling Price'), 'width' => 'auto', 'wrap' => true),
    array('label' => __('Qty'), 'width' => 'auto', 'filter' => true),
    array('label' => __('Point Given'), 'width' => 'auto', 'filter' => true),
    array('label' => __('Point Redeem'), 'width' => 'auto'),
    array('label' => __('Taxation'), 'width' => 'auto', 'wrap' => true)
);
// heading
$this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));
// data
$taxe_rate = '';
foreach($products['ProductHistory'] as $product){ 
    
    $this->PhpExcel->addTableRow(array(
                                 $this->Common->getDateFormat($product['date']),		
				 $product['type'],
				 $product['reason'],
				 $product['vendor'],
				 $product['selling_price'],
                                 $product['qty'], 
				 $product['points_given'],
				 $product['points_redeem'],
				 $product['tax']
				 
    ));
}
$this->PhpExcel->addTableFooter();
$this->PhpExcel->output(); 
?>