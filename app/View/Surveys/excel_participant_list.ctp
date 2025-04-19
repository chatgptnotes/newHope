<?php 
ob_end_clean();
if($camp){
	$campData=$camp['0']['CampDetail'];
}else{
	$campData=$parent['0']['CampDetail'];
}

$name=ucwords(strtolower($campData[camp_name]));
$date=$this->DateFormat->formatDate2Local($campData[camp_date],Configure::read('date_format'),false);
$venue=ucwords(strtolower($campData[camp_venue]));
$nrt=ucwords(strtolower($campData[camp_nature]));
$total=count($camp);
//debug($campData);exit;
$this->PhpExcel->createWorksheet();//->setDefaultFont('Calibri', 11); //to set the font and size

// Create a first sheet, representing Table data

$this->PhpExcel->setActiveSheetIndex(0);
$this->PhpExcel->getActiveSheet()->setTitle("Participant_list");	//to set the worksheet title
$this->PhpExcel->getActiveSheet()->getStyle("A".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("A".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => false
		)
);
$this->PhpExcel->getActiveSheet()->mergeCells('A1:G1');

$this->PhpExcel->addTableRow(array(" $name - (Participant List)"));
$this->PhpExcel->getActiveSheet()->mergeCells('A2:D2');
$this->PhpExcel->getActiveSheet()->mergeCells('E2:G2');
$this->PhpExcel->addTableRow(array(" Comp_Name"." : ".$name,'','',''," Comp Date"." : ".$date,'','',''));
$this->PhpExcel->getActiveSheet()->getStyle("A2:F2".$this->PhpExcel->_row)->getFont()->setBold(true);

$this->PhpExcel->getActiveSheet()->mergeCells('A3:D3');
$this->PhpExcel->getActiveSheet()->mergeCells('E3:G3');
$this->PhpExcel->addTableRow(array(" Comp Venue"." : ".$venue,'','',''," Nature of Comp"." : ".$nrt,'',''));
$this->PhpExcel->getActiveSheet()->getStyle("A3:F3".$this->PhpExcel->_row)->getFont()->setBold(true);

$this->PhpExcel->getActiveSheet()->mergeCells('A4:G4');
$this->PhpExcel->addTableRow(array(" Total no.of participants : ".$total,'','','','','',''));
$this->PhpExcel->getActiveSheet()->getStyle("A4:F4".$this->PhpExcel->_row)->getFont()->setBold(true);

$tableHead[]=array('label' => __('Sr.no'),'width' =>10);

$this->PhpExcel->getActiveSheet()->getStyle("A".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("A".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => true
		)
);
$tableHead[]=array('label' => __('Participant Name '),'width' => 20,'align'=>'center','wrap'=>true);

$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => true
		)
);

$tableHead[]=array('label' => __('Doctor'),'align'=>'center','wrap'=>true);

$this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => true
		)
);

$tableHead[]=array('label' => __(' Age'),'width' =>10,'wrap'=>true);

$this->PhpExcel->getActiveSheet()->getStyle("D".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("D".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => true
		)
);
$tableHead[]=array('label' => __(' Sex'),'width' => 10,'wrap'=>true);

$this->PhpExcel->getActiveSheet()->getStyle("E".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("E".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => true
		)
);
$tableHead[]=array('label' => __('Mobile No'),'width' => 20,'wrap'=>true);

$this->PhpExcel->getActiveSheet()->getStyle("F".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("F".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => true
		)
);
$tableHead[]=array('label' => __('Address'),'width' => 20,'wrap'=>true);

$this->PhpExcel->getActiveSheet()->getStyle("G".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("G".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => true
		)
);
$tableHead[]=array('label' => __('Remark'),'width' => 20,'wrap'=>true);

$this->PhpExcel->getActiveSheet()->getStyle("H".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("H".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => true
		)
);

$tableHead[]=array('label' => __('Ask for admit'),'width' => 20,'wrap'=>true);

$this->PhpExcel->getActiveSheet()->getStyle("I".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("I".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => true
		)
);


$tableHead[]=array('label' => __('Investigations'),'width' => 50,'wrap'=>true);

$this->PhpExcel->getActiveSheet()->getStyle("J".$this->PhpExcel->_row)->getFont()->setBold(true);
$this->PhpExcel->getActiveSheet()->getStyle("J".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
		array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => true
		)
);


// add heading with different font and bold text
$this->PhpExcel->addTableHeader($tableHead, array('name' => 'Cambria', 'bold' => true));
$srno=1;
foreach($camp as $partData){
	$arr='';
	$arr[]=$srno;
	$arr[]= ucwords(strtolower($partData['CampParticipantsDetail']['name']));
	$arr[]= ucwords(strtolower($partData['User']['first_name'].' '.$partData['User']['last_name']));
	$arr[]= $partData['CampParticipantsDetail']['age'];
	$arr[]= ucfirst($partData['CampParticipantsDetail']['sex']);
	$arr[]= $partData['CampParticipantsDetail']['mobile_no'];
	$arr[]= ucfirst($partData['CampParticipantsDetail']['address']);
	$arr[]= ucfirst($partData['CampParticipantsDetail']['remark']);
	if($partData['CampParticipantsDetail']['admit_chk']==1){
		$arr[]= 'Yes';
	}else{
		$arr[]= 'No';
	}
	if(!empty($partData['CampParticipantsDetail']['invt'])){
		$pos = strrpos($partData['CampParticipantsDetail']['invt'], ",");//to remove first comma
		if($pos==0)
			$arr[]= substr($partData['CampParticipantsDetail']['invt'],1);
		else $arr[]= $partData['CampParticipantsDetail']['invt'];
	}else{
		$arr[]='';
	}
	$this->PhpExcel->getActiveSheet()->getStyle("A".$this->PhpExcel->_row.":I".$this->PhpExcel->_row)->getFont()->setBold(false);
	$this->PhpExcel->getActiveSheet()->getStyle("A".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
			array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
					'wrap'       => false
			)
	);
	$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
			array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					//'vertical'   => PHPExcel_Style_Alignment::VERTICAL_LEFT,
					'rotation'   => 0,
					'wrap'       => false
			)
	);
	$this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
			array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					//'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
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
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
					'wrap'       => false
			)
	);
	$this->PhpExcel->addTableRow($arr);
	$srno++;
}
$this->PhpExcel->addTableFooter()->output("Participant_list");//output file name

?>
