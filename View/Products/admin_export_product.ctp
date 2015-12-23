<?php 
$this->PhpExcel->createWorksheet();
$this->PhpExcel->setDefaultFont('Calibri', 12);
// define table cells
$table = array(
    array('label' => __('BarcodeID'), 'width' => 'auto', 'filter' => true),
    array('label' => __('Eng. Brand'), 'width' => 'auto', 'filter' => true),
    array('label' => __('Ara. Brand'), 'width' => 'auto'),
    array('label' => __('Eng. Product Type'), 'width' => 'auto', 'wrap' => true),
    array('label' => __('Ara. Product Type'), 'width' => 'auto', 'wrap' => true),
    array('label' => __('Eng. Product Name'), 'width' => 'auto', 'filter' => true),
    array('label' => __('Ara. Product Name'), 'width' => 'auto', 'filter' => true),
    array('label' => __('Sell Price'), 'width' => 'auto'),
    array('label' => __('Total Qty'), 'width' => 'auto', 'wrap' => true),
    array('label' => __('Low Qty Warn.'), 'width' => 'auto', 'wrap' => true),
    array('label' => __('Taxation'), 'width' => 'auto', 'wrap' => true)
);
// heading
$this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));
// data
$taxe_rate = '';
foreach ($allProducts as $product) {
    if($product['Product']['tax']){
					foreach($tax['TaxCheckout'] as $k=>$v){
					  if($k==$product['Product']['tax']){
                                            if($v){
                                                $taxe_rate = $v.'%'; 
                                             }else{
                                                 $taxe_rate = '0.000%';
                                                }	
					  }
                                          $v ='';
					}
				}else{
                                 $taxe_rate = 'No Tax';   
                                }
    $this->PhpExcel->addTableRow(array(
                                 $product['Product']['barcode'],		
				 $product['Brand']['eng_name'],
				 $product['Brand']['ara_name'],
				 $product['ProductType']['eng_name'],
				 $product['ProductType']['ara_name'],
				 $product['Product']['eng_product_name'],
                                 $product['Product']['ara_product_name'], 
				 $product['Product']['selling_price'],
				 $product['Product']['quantity'],
				 $product['Product']['low_quantity_warning'],
                                 $taxe_rate
				 
    ));
}
$this->PhpExcel->addTableFooter();
$this->PhpExcel->output(); 
?>