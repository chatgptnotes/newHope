<?php
$config['laboratory_machine_header_text']= 'This test is performed with ';
$config['sensitivity']= array('R'=>'R','S'=>'S','IS'=>'IS');
$config['shifts'] = 'shifts';
$config['lab_histo_template_sub_groups'] = array(
		'1'=>'Surgical Pathology',
		'2'=>'Fine Needle Aspiration Cytology',
		'3'=>'Frozen section',
		'4'=>'Cytology',
		'5'=>'PAP SMEAR',
		'6'=>'Bone Marrow Aspirate',
		'7'=>'Immunohistochemistry'
		);

$config['histopathology_data_drm']=array(
		'1'=>'Gross Description',
		'2'=>'Microscopic Findings',
		'3'=>'Impression',
		'4'=>'Specimen',
		'5'=>'Clinical Details',
		'6'=>'Immunohistochemistry',
		'7'=>'Note/Comment',
		'8'=>'Lab Notes',
		'9'=>'Comment/Recommendation',
		'10'=>'Nature of Material Received',
		'11'=>'Type of Fluid Received',
		'12'=>'Clinical Diagnosis',
		'13'=>'Site of Aspirate',
		'14'=>'Notes/Recommendations',
		'15'=>'Cytological Interpretation',
		'16'=>'Microscopic Description',
		'17'=>'Nature of Material Aspirated Received'
);

$config['lab_histo_template_sub_groups_mapping'] = array(
		'1'=>array('4','5','1','16','6','3','7','8'),
		'2'=>array('12','13','17','2','3','14','8'),
		'3'=>array('4','5','1','2','6','3','7','8'),
		'4'=>array('5','11','2','3','9','8'),
		'5'=>array('5','10','2','15','9','8'),
		'6'=>array('5','10','2','3','9','8'),
		'7'=>array('4','5','1','16','6','3','14')
);

$config['lab_type_request_no_1'] = date("y").'/';
$config['lab_type_request_no_2'] = 'F/';
$config['lab_type_request_no_3'] = 'F/';

$config['IHC']='IHC (ER, PR)' ;
$config['Her-2']='IHC (ER, PR, Her-2)' ;
$config['Immunohistochemistry']='Immunohistochemistry' ;
$config['Her-2ResultOption'] = array('Negative'=>'Negative','Equivocal'=>'Equivocal','Positive'=>'Positive');
$config['StainingPattern'] = array('No staining'=>'No staining','Staining present'=>'Staining present',
								'Faint/barely perceptive incomplete membrane staining'=>'Faint/barely perceptive incomplete membrane staining',
								'Weak to moderate complete membrane staining'=>'Weak to moderate complete membrane staining',
								'Strong complete membrane staining'=>'Strong complete membrane staining','Strong complete membrane staining');
/** Hr Configs  -- Gaurav*/
$config['shifts'] = 'shifts';
$config['leaveTypes'] = array('CL'=>'Casual Leave','SL'=>'Sick Leave','EL'=>'Privilege / Earned leave','ML'=>'Maternity leave',
		'OH'=>'Optional Holiday','SLOLOP'=>'Special Leave','A'=>'Absent');
$config['EarningDeductionCategory'] = array('Work linked payment'=>'Work linked payment','Revenue linked payment'=>'Revenue linked payment','Top up'=>'Top up');
$config['EarningDeductionType'] = array('Earning'=>'Earning','Deduction'=>'Deduction');
$config['EarningDeductionPaymentType'] = array('Team'=>'Team','Individual'=>'Individual');
$config['Coupon'] = true;
 



/** EOF */