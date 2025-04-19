<?php
ob_end_clean();
  
$this->PhpExcel->createWorksheet();
//creating first sheet
$this->PhpExcel->setActiveSheetIndex(0);
$this->PhpExcel->getActiveSheet()->setTitle(__('Product Purchase List'));	//to set the worksheet title
$this->PhpExcel->getActiveSheet()->getStyle("A".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("A".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => false
		)
);
$this->PhpExcel->getActiveSheet()->mergeCells('A1:J1');
$this->PhpExcel->addTableRow(array("Product Purchase List"));


$tableHead[]=array('label' => __('Sr.no'), 'align'=>'left','filter' => true);

$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => true
		)
);
$tableHead[]=array('label' => __(' Order From '), 'align'=>'center','wrap'=>true);

$this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => true
		)
);
$tableHead[]=array('label' => __(' Supplier'), 'align'=>'right','wrap'=>true);

$this->PhpExcel->getActiveSheet()->getStyle("D".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("D".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => true
		)
);
$tableHead[]=array('label' => __(' GRN No'), 'align'=>'right','wrap'=>true);

$this->PhpExcel->getActiveSheet()->getStyle("E".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("E".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => true
		)
);
$tableHead[]=array('label' => __(' Received Date'),  'align'=>'right', 'wrap'=>true);

$this->PhpExcel->getActiveSheet()->getStyle("F".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("F".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => true
		)
);
$tableHead[]=array('label' => __(' Product'), 'align'=>'right','wrap'=>true); 

$this->PhpExcel->getActiveSheet()->getStyle("G".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("G".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => true
		)
);
$tableHead[]=array('label' => __(' Batch No'),'align'=>'right', 'wrap'=>true); 

$this->PhpExcel->getActiveSheet()->getStyle("H".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("H".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => true
		)
);
$tableHead[]=array('label' => __(' Quantity'),'align'=>'right', 'wrap'=>true); 

$this->PhpExcel->getActiveSheet()->getStyle("I".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("I".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => true
		)
);
$tableHead[]=array('label' => __(' Purchase Price'),'align'=>'right', 'wrap'=>true); 

$this->PhpExcel->getActiveSheet()->getStyle("J".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("J".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => true
		)
);
$tableHead[]=array('label' => __(' Value'),'align'=>'right', 'wrap'=>true); 

// add heading with different font and bold text
$this->PhpExcel->addTableHeader($tableHead, array('name' => 'Cambria', 'bold' => true));
$srno=1;  
$total = 0;
$row = count($results);
foreach($results as $value){
	$arr=''; 
	$arr[]=$srno; 
	$arr[]= $value['StoreLocation']['name'];  
	$arr[]=$value['InventorySupplier']['name']; 
	$arr[]= $value['PurchaseOrderItem']['grn_no'];
	$arr[]=$this->DateFormat->formatDate2Local($value['PurchaseOrderItem']['received_date'],Configure::read('date_format'),true); 
	$arr[]=$value['Product']['name']; 
	$arr[]=$value['PurchaseOrderItem']['batch_number'];  
	$arr[]=$qty = $value['PurchaseOrderItem']['quantity_received'];  
	$arr[]=$price = $value['PurchaseOrderItem']['purchase_price'];
	$total += $qty * $price;
	$arr[]=round(($qty * $price),2);

	  
	$this->PhpExcel->getActiveSheet()->getStyle("A".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
			array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
					'wrap'       => false
			)
	);
	$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
			array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
					'wrap'       => false
			)
	);
	$this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
			array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0, 
					'wrap'       => false
			)
	);
	$this->PhpExcel->getActiveSheet()->getStyle("D".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
			array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
					'wrap'       => false
			)
	);
	$this->PhpExcel->getActiveSheet()->getStyle("E".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
			array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
					'wrap'       => false
			)
	);
	$this->PhpExcel->getActiveSheet()->getStyle("F".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
			array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
					'wrap'       => false
			)
	);
	$this->PhpExcel->getActiveSheet()->getStyle("G".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
			array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
					'wrap'       => false
			)
	);
	$this->PhpExcel->getActiveSheet()->getStyle("H".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
			array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
					'wrap'       => false
			)
	);
	$this->PhpExcel->getActiveSheet()->getStyle("I".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
			array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
					'wrap'       => false
			)
	);
	$this->PhpExcel->getActiveSheet()->getStyle("J".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
			array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
					'wrap'       => false
			)
	);
	$this->PhpExcel->addTableRow($arr);
	$srno++;
} 

$this->PhpExcel->getActiveSheet()->mergeCells('A10:I10');
$this->PhpExcel->addTableRow(array("Total : "));
$this->PhpExcel->getActiveSheet()->setCellValue("J".(count($results)+3),round($total,2));

$this->PhpExcel->addTableFooter()->output("Product Purchase List");	

?>



