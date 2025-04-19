<?php
ob_end_clean();
  
$this->PhpExcel->createWorksheet();
//creating first sheet
$this->PhpExcel->setActiveSheetIndex(0);
$this->PhpExcel->getActiveSheet()->setTitle(__('Opening Closing Stock List'));	//to set the worksheet title
$this->PhpExcel->getActiveSheet()->getStyle("A".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("A".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => false
		)
);
$this->PhpExcel->getActiveSheet()->mergeCells('A1:D1');
$this->PhpExcel->addTableRow(array("Opening Closing Stock List". "(". $setFromDate." - ".$setToDate .")"));


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
$tableHead[]=array('label' => __(' Item Name '),'width' => 20,'align'=>'center','wrap'=>true);

$this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => true
		)
);
$tableHead[]=array('label' => __(' Opening Stock'),'width' => 20,'align'=>'right','wrap'=>true);

$this->PhpExcel->getActiveSheet()->getStyle("D".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("D".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => true
		)
);
$tableHead[]=array('label' => __(' Closing Stock'),'width' => 20,'align'=>'right','wrap'=>true); 

// add heading with different font and bold text
$this->PhpExcel->addTableHeader($tableHead, array('name' => 'Cambria', 'bold' => true));
$srno=1; 
 
foreach($results as $value){
	$arr   = ''; 
	$arr[] = $srno; 
	$arr[] = ucfirst($value['PharmacyItem']['name']);  
	$arr[] = $value['opening'];  
	$arr[] = $value['closing'];  
	  
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
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
					'wrap'       => false
			)
	);
	$this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
			array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0, 
					'wrap'       => false
			)
	);
	$this->PhpExcel->getActiveSheet()->getStyle("D".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
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
$this->PhpExcel->addTableFooter()->output("Opening Closing Stock List");	

?>


