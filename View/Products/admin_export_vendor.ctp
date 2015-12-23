<?php 
$this->PhpExcel->createWorksheet();

$this->PhpExcel->setDefaultFont('Calibri', 12);


// define table cells
$table = array(
    array('label' => __('English Business Name'), 'width' => 'auto', 'filter' =>true),
    array('label' => __('Arabic Business Name'), 'width' => 'auto', 'filter' =>true),
    array('label' => __('Website'), 'width' => 'auto'),
    array('label' => __('Primary Phone'), 'width' => 'auto'),
    array('label' => __('Secondry Phone'), 'width' => 'auto'),
    array('label' => __('Primary Email'), 'width' => 'auto', 'wrap' => true),
    array('label' => __('Secondry Email'), 'width' => 'auto', 'wrap' => true),
    array('label' => __('English Address'), 'width' => 'auto'),
    array('label' => __('Arabic Address'), 'width' => 'auto'),
    array('label' => __('Created'), 'width' => 'auto'),
    array('label' => __('Modified'), 'width' => 'auto'),
);
    

// heading
$this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));

// data
foreach ($all_vendors as $vendor) {
    $this->PhpExcel->addTableRow(array(
        $vendor['Vendor']['eng_business_name'],
        $vendor['Vendor']['ara_business_name'],
        $vendor['Vendor']['website'],
        $vendor['Vendor']['phone'],
        $vendor['Vendor']['secondary_phone'],
        $vendor['Vendor']['email'],
        $vendor['Vendor']['secondary_email'],
        $vendor['Vendor']['eng_address'],
        $vendor['Vendor']['ara_address'],
        $vendor['Vendor']['created'],
        $vendor['Vendor']['modified']
    ));
}

$this->PhpExcel->addTableFooter();
$this->PhpExcel->output(); 

?>