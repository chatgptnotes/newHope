<?php
/**
 * Core Configurations
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Config
 * @since         CakePHP(tm) v 1.1.11.4062
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
$config['default_facility_id'] = 2;
$config['number_of_rows'] = 20;
$config['date_format']='dd/mm/yyyy';
$config['date_format_php'] = 'd/m/Y';
$config['date_format_us']='mm/dd/yyyy'; 
$config['date_format_yyyy_mm_dd']='yyyy-mm-dd';   
$config['pathologist']='Pathologist' ; //retrieve user whose role is pathologist
$config['doctor']='Primary Care Provider' ;
$config["Security.salt"]="1DYhG93b0qyJfIxfs2guVoUubWwvniR2G0FgaC8mi" ;
$config['radiologist']='Radiology Manager' ; //retrieve user whose role is radiologist
$config['medicalCoder']='Medical Coder' ; //retrieve user whose role is Medical Coder
$config['external_radiologist']='external radiologist' ; //retrieve user whose role is radiologist
$config['ambulatoryCost']='500.00' ; //retrieve user whose role is Medical Coder

//accountings
$config['account_type']= array("Asset"=>"Asset","Expense"=>"Expense","Liability"=>"Liability","Income"=>"Income");
$config['status']= array("Active"=>"Active","Inactive"=>"Inactive");
$config['gl_format']= array("Full Account"=>"Full Account","Not Available"=>"Not Available","Sub-Account"=>"Sub-Account");

//newcrop details

$config['accid']="drmhope";
$config['accname']="DrmHope Softwares";
$config['siteid']="1";

//doctor/prescriber default details

$config['prescriberDea']="OT1234567";
$config['prescriberNpi']="";

//facility details
$config['company_addr1']="51 Dhantoli Nagpur.";
$config['company_addr2']="";
$config['company_state']="19";
$config['company_city']="Nagpur";
$config['company_zip']="440012";
$config['company_primary_phone']="9923742078";
$config['company_primary_fax']="9923742078";

//for hr

$config['employee_type']=array("Trainee"=>"Trainee","Contract"=>"Contract" ,"On-roll"=>"On-roll");
//end
$config['hashKey'] = "0xb613679a0814d9ec772f95d778c35fc5ff1697c493715653c6c712144292c5ad";

$config['generated_ccda_path'] = 'files/note_xml/' ;
$config['generated_pacs_path'] = 'pacsimages/images/' ;
$config['generated_cqm_path'] = 'files/EP_CQM/' ;
$config['generated_cqm_patheh'] = 'files/EH_CQM/' ;
$config['generated_edi'] = 'files/Edi_files/' ;
$config['imoportal']='sandbox.e-imo.com';

$config['position']= array("Supine"=>"Supine","Sitting"=>"Sitting","Standing"=>"Standing",);
$config['site1']= array("Left"=>"Left","Right"=>"Right");
$config['site2']= array("Arm"=>"Arm","Thigh"=>"Thigh");
$config['site3']= array("PtandardCuff"=>"StandardCuff","PargeCuff"=>"LargeCuff","Pediatric"=>"Pediatric");
$config['maritail_status'] = array("Divorced"=>"Divorced","Living together"=>"Living together","Married"=>"Married","Single"=>"Single","Unknown"=>"Unknown","Widowed"=>"Widowed");
/*$config['maritail_status'] = array("Annulled"=>"Annulled","Common law"=>"Common law","Divorced"=>"Divorced","Domestic partner"=>"Domestic partner",
		"Interlocutory"=>"Interlocutory","Legally Separated"=>"Legally Separated","Living together"=>"Living together","Married"=>"Married",
		"Other"=>"Other","Registered domestic partner"=>"Registered domestic partner","Separated"=>"Separated","Single"=>"Single",
		"Unknown"=>"Unknown","Unmarried"=>"Unmarried","Unreported"=>"Unreported","Widowed"=>"Widowed");*/
$config['receptionistLabel'] ='Receptionist';
$config['backOfficeLabel'] ='Back Office';
$config['medicalAssistantLabel'] = 'Medical Assistant' ;
$config['doctorLabel'] = 'Primary Care Provider' ;
$config['doctorRoleId'] = '3' ;
$config['RegistrarLabel'] = 'Registrar' ;
$config['nurseLabel'] = 'Nurse' ;
$config['WardboyLabel'] = 'Wardboy' ;
$config['MaushiLabel'] = 'Maushi' ;
$config['RMOLabel'] = 'RMO'; 
$config['nurseId'] = '7' ;
$config['residentLabel']='Residents';
$config['residentId']='84';
$config['medicalAssistantLabel']= 'Medical Assistant';
$config['businessHead']='Business Head';
$config['insuranceVerifierId'] = '68' ;
$config['adminLabel']='Admin' ;
$config['superAdminLabel']='superadmin' ;
$config['frontOfficeLabel']='Front Office Executive';
$config['patientLabel']='patient' ;
$config['generalMedicine']='General Medicine' ;
$config['problemStatus']= array(""=>"Please Select","Acute"=>"Acute","Chronic"=>"Chronic","Deceased"=>"Deceased","Existing"=>"Existing","Inactive"=>"Inactive","New On Set"=>"New On Set","Recovered"=>"Recovered");
$config['heartRate']= array(''=>'Please Select','Finger tip'=>'Finger tip','Radial'=>'Radial','Carotid'=>'Carotid','Femoral'=>'Femoral','Pedal'=>'Pedal');
$config['servicecategoryid']='36' ;// 36 is id Surgeries
$config['ServiceCategoryLable']='Surgery';
//$config['labStatus']= array("Pending"=>"Pending","Confirmed with Patient"=>"Confirmed with Patient","Sample Collected"=>"Sample Collected","Appointment confirmed with patient"=>"Appointment confirmed with patient","Waiting in lobby"=>"Waiting in lobby","Patient in X-ray room"=>"Patient in X-ray room","Patient in CT Scan room"=>"Patient in CT Scan room","Patient in MRI room"=>"Patient in MRI room","Payment Collected"=>"Payment Collected","Payment Pending"=>"Payment Pending");// for lab DashBorad.
$config['labStatus']= array("Pending"=>"Pending","Confirmed with Patient"=>"Confirmed with Patient",);// for RAD DashBorad.
$config['labStatusLab']= array("Pending"=>"Pending","Appoinment for Specimen Collection"=>"Appoinment for Specimen Collection","Result and Publish"=>"Result and Publish");
$config['labStatusRad']= array("Pending"=>"Pending","Result and Publish"=>"Result and Publish");


//old Visit Options
//$config['patient_visit_type']= array("1"=>"Follow up","2"=>"New Patient","3"=>"Nursing Only","4"=>"Urgent","5"=>"Wellness Exam");
// new options gaurav
$config['patient_visit_type']=array('1'=>'Combined Visit (ov,wellness) (40)','2'=>'Follow Up no results (20)','3'=>'Follow up Procedure Results (30)','4'=>'Follow up Lab Results (20)','5'=>'Lab Visit (10)','6'=>'New Patient with problem (30)','7'=>'Physical Occupational (30)',
		'8'=>'Physical School (20)','9'=>'Physical Wellness 18-39 (30)','10'=>'Physical Wellness 40-64 (30)','11'=>'Physical Wellness 65+ (30)',
		'12'=>'Physical Wellness under 17 (20)','13'=>'Procedure Visit (30)','14'=>'Vaccines Adult (20)','15'=>'Vaccines Pediatric (20)',
		'16'=>'Wellness Procedure (30)','17'=>'Wellness Lab Visit (10)','18'=>'Post Op Visit (20)','19'=>'Surgical Clearance Visit (30)',
		'20'=>'Surgical Clearance Procedures (30)','21'=>'Consultation Visit (30)','22'=>'Phone Visit','23'=>'Video Chat');
$config['vitals_for_tracking_board']= array('Temperature Oral ','Temperature Axillary ','Temperature Rectal ','Apical Heart Rate ','Heart Rate Monitoring ',
		'Blood Pressure Source','Blood Pressure Position','Respiratory Rate ','SpO2 ','Cerebral Perfusion Pressure (CPP) ','Intracranial Pressure (ICP) ',
		'Central Venous Pressure (CVP) ','SBP/DBP Cuff ','SBP/DBP Line ','Peripheral Pulse');

$config['admit_to']=array('Labour & Delivery'=>'Labour & Delivery',
		'Gynecology'=>'Gynecology',
		'Head & Neck Surgery'=>'Head & Neck Surgery',
		'IR /Interventional Radiology'=>'IR /Interventional Radiology',
		'Endocrinology'=>'Endocrinology',
		'Gastroenterology'=>'Gastroenterology',
		'General Internal Medicine'=>'General Internal Medicine',
		'General Surgery'=>'General Surgery',
		'Head & Neck Surgery'=>'Head & Neck Surgery',
		'Hematology/Oncology'=>'Hematology/Oncology',
		'Neurology'=>'Neurology',
		'Nephrology'=>'Nephrology',
		'Vascular Surgery'=>'Vascular Surgery',
		'Urology'=>'Urology','Thoracic Surgery'=>'Thoracic Surgery','Radiation Oncology'=>'Radiation Oncology','Radiation Oncology'=>'Radiation Oncology','Rheumatology'=>'Rheumatology',
		'Pulmonary'=>'Pulmonary',
		'Psychiatry/Psychology'=>'Psychiatry/Psychology',
		'Plastics/Reconstructive Surgery'=>'Plastics/Reconstructive Surgery',
		'Orthopedics'=>'Orthopedics',
		'Ophthalmology & Optometry'=>'Ophthalmology & Optometry',
		'Obstetrics L&D'=>'Obstetrics L&D',
		'Obstetrics'=>'Obstetrics');
//$config['dose_type']= array("1"=>"0.5","1"=>"0.5/half","2"=>"1","3"=>"1-2","4"=>"1-3","5"=>"1.5","6"=>"2","7"=>"3","8"=>"4","9"=>"5","10"=>"10","11"=>"15","12"=>"20","13"=>"30","15"=>"2.5","16"=>"7.5","18"=>"2-3","19"=>"6","20"=>"7","21"=>"8","22"=>"9","23"=>"11","24"=>"12","25"=>"0.33/third","26"=>"0.5-1");
$config['dose_type']= array('1'=>"As directed","0.75"=>"0.75","2.5"=>"2.5","10"=>"10","20"=>"20","30"=>"30","40"=>"40","50"=>"50","75"=>"75","100"=>"100","125"=>"125","150"=>"150","175"=>"175","200"=>"200","400"=>"400","800"=>"800","1500"=>"1500");



/* $config['>''route_administration']= array("1"=>"as directed","2"=>"by mouth","4"=>"ears, both","32"=>"ear, left","33"=>"ear.right","5"=>"eyes.both",
		"34"=>"eyes.left","35"=>"eye.right","40"=>"eyelids.applyto","42"=>"eye.surgical","36"=>"face.apply to","37"=>"face, thin layer to","38"=>"feeding tube.via","11"=>"inhale","12"=>"inject. intramuscular","23"=>"intravenous","30"=>"lip. under the","41"=>"nail. apply to","6"=>"nostrils, in the","14"=>"penis. inject into","7"=>"rectum. in the","39"=>"scalp.apply to","13"=>"skin. inject below","15"=>"skin. inject into","25"=>"skin. apply on","26"=>"teeth. apply to","27"=>"tongue . on the","31"=>"tongue . under the","8"=>"urethra, in the","8"=>"urethra, in the","8"=>"urethra, in the","8"=>"urethra, in the","9"=>"vagina, in the","3"=>"epidural","10"=>"in vitro","16"=>"intraarterial","17"=>"intraarticular","18"=>"intraocular","19"=>"intraperitoneal","20"=>"intrapleural","21"=>"intrathecal","22"=>"intrauterine","24"=>"intravesical","28"=>"perfusion","29"=>"rinse");
 */
		$config['dose_type_name']=array("tablet"=>"tablet","application"=>"application",
"capsule"=>"capsule","drop"=>"drop","patch"=>"patch","pill"=>"pill",
"puff"=>"puff","syringe"=>"syringe","package"=>"package");
$config['continuousinfusion'] = '26';
$config['medications'] = '27';
$config['Parenteral'] = '32';
$config['route_administration']= array("1"=>"AS DIRECTED","2"=>"ORAL","4"=>"BOTH EARS","32"=>"LEFT EAR","33"=>"RIGHT EAR","5"=>"BOTH EYES",
		"34"=>"LEFT EYES","35"=>"RIGHT EYE","40"=>"APPLY TO EYELIDS","42"=>"SURGICAL EYE","36"=>"APPLY TO FACE","37"=>"THIN LAYER TO FACE","38"=>"VIA FEEDING TUBE"
		,"11"=>"INHALE","12"=>"INJECT INTRAMUSCULAR","23"=>"INTRAVENOUS","30"=>"UNDER THE LIP","41"=>"APPLY TO NAIL","6"=>"IN THE NOSTRILS","14"=>"INJECT INTO PENIS",
		"7"=>"IN THE RECTUM","39"=>"APPLY TO SCALP","13"=>"INJECT BELOW SKIN","15"=>"INJECT INTO SKIN","25"=>"APPLY ON SKIN","26"=>"APPLY TO TEETH"
		,"27"=>"ON THE TONGUE","31"=>"UNDER THE TONGUE","8"=>"IN THE URETHRA","8"=>"IN THE URETHRA","8"=>"IN THE URETHRA","8"=>"IN THE URETHRA","9"=>"IN THE VAGINA","3"=>"EPIDURAL","10"=>"IN VITRO","16"=>"INTRAARTERIAL","17"=>"INTRAARTICULAR","18"=>"INTRAOCULAR","19"=>"INTRAPERITONEAL",
		"20"=>"INTRAPLEURAL","21"=>"INTRATHECAL","22"=>"INTRAUTERINE","24"=>"INTRAVESICAL","28"=>"PERFUSION","29"=>"RINSE");

$config['selected_route_administration']= array("AS DIRECTED"=>"1","ORAL"=>"2","BOTH EARS"=>"4","LEFT EAR"=>"32","RIGHT EAR"=>"33","BOTH EYES"=>"5",
		"LEFT EYES"=>"34","RIGHT EYE"=>"35","APPLY TO EYELIDS"=>"40","SURGICAL EYE"=>"42","APPLY TO FACE"=>"36","THIN LAYER TO FACE"=>"37","VIA FEEDING TUBE"=>"38"
		,"INHALE"=>"11","INJECT INTRAMUSCULAR"=>"12","INTRAVENOUS"=>"23","UNDER THE LIP"=>"30","APPLY TO NAIL"=>"41","IN THE NOSTRILS"=>"6","INJECT INTO PENIS"=>"14",
		"IN THE RECTUM"=>"7","APPLY TO SCALP"=>"39","INJECT BELOW SKIN"=>"13",
		"INJECT INTO SKIN"=>"15","APPLY ON SKIN"=>"25","APPLY TO TEETH"=>"26","ON THE TONGUE"=>"27","UNDER THE TONGUE"=>"31","IN THE URETHRA"=>"8","IN THE VAGINA"=>"9","EPIDURAL"=>"3","IN VITRO"=>"10","INTRAOCULAR"=>"18",
		"INTRAPERITONEAL"=>"19","INTRAPLEURAL"=>"20","INTRATHECAL"=>"21","INTRAUTERINE"=>"22","INTRAVESICAL"=>"24","PERFUSION"=>"28","RINSE"=>"29");



$config['selected_route']= array("oral"=>"2","inhalation"=>"11","injection"=>"12","intravenous"=>"23","nasal"=>"6","subcutaneous"=>"13","topical"=>"25",
"base of the eyelashes"=>"40","buccal"=>"30","combination"=>"25","dental"=>"26","epidural"=>"3","feeding tube"=>"38",
"hemodialysis"=>"25","in vitro"=>"10","injectable"=>"23","intra-articular"=>"17","intracavernosal"=>"25","intradermal"=>"25","intramuscular"=>"12","intraocular"=>"18","intraperitoneal"=>"19","intrapleural"=>"20","intrathecal"=>"25","intratracheal"=>"21","intrauterine"=>"22","intravesical"=>"24","intravitreal"=>"42","oral and injectable"=>"25","oral and rectal"=>"25","oral and topical"=>"25","oral transmucosal"=>"25","otic"=>"4","percutaneous"=>"13",
"periodontal"=>"26","sublingual"=>"31","transdermal"=>"25","translingual"=>"25","urethral"=>"8","vaginal"=>"9","miscellaneous"=>"1");



$config['frequency']= array("1"=>"AS DIRECTED","2"=>"DAILY","4"=>"IN THE MORNING.BEFORE NOON","5"=>"TWICE A DAY","6"=>"THRICE A DAY","7"=>"FOUR TIMES A DAY",
		"29"=>"EVERY 2 HOURS","28"=>"EVERY 3 HOURS","8"=>"EVERY 4 HOURS","9"=>"EVERY 6 HOURS","10"=>"EVERY 8 HOURS","11"=>"EVERY 12 HOURS","26"=>"EVERY 48 HOURS","23"=>"EVERY 72 HOURS"/*,"24"=>"Every 4-6 hours","13"=>"Every 2 hours with assistance"*/
		,"14"=>"EVERY 1 WEEK","15"=>"EVERY 2 WEEKS","16"=>"EVERY 3 WEEKS","25"=>"EVERY 1 HOUR"/* with assistance"*/,"12"=>"EVERY OTHER DAY","27"=>"2 TIMES WEEKLY"
		,"20"=>"3 TIMES WEEKLY","22"=>"ONCE A MONTH","18"=>"NIGHTLY","19"=>"EVERY NIGHT AT BEDTIME","35"=>"FASTING","31"=>"STAT","32"=>"NOW","34"=>"ONCE A DAY BEFORE BREAKFAST"
,"35"=>"ONCE A DAY AFTER BREAKFAST","36"=>"TWICE A DAY BEFORE MEALS","37"=>"TWICE A DAY AFTER MEALS","38"=>"FORTNIGHTLY","39"=>"ALTERNATE DAY"
,"40"=>"ONCE A WEEK ON SUNDAY AFTER DINNER","41"=>"DAILY AFTER DINNER EXCEPT SUNDAY","42"=>"ONCE A DAY AFTER DINNER","43"=>"DAILY AST","44"=>"DAILY AFTER BREAKFAST"
);

$config['selected_frequency']= array("AS DIRECTED"=>"1","DAILY"=>"2","IN THE MORNING.BEFORE NOON"=>"4","TWICE A DAY"=>"5","THRICE A DAY"=>"6","FOUR TIMES A DAY"=>"7"
		,"EVERY 2 HOURS"=>"29","EVERY 3 HOURS"=>"28","EVERY 4 HOURS"=>"8","EVERY 6 HOURS"=>"9","EVERY 8 HOURS"=>"10","EVERY 12 HOURS"=>"11",
		"Every 48 hours"=>"26","Every 72 hours"=>"23"/*,"24"=>"Every 4-6 hours","13"=>"Every 2 hours with assistance"*/,"Every 1 week"=>"14","Every 2 weeks"=>"15"
		,"EVERY 3 WEEKS"=>"16","EVERY 1 HOUR"=>"25"/* with assistance"*/,
		"Every Other Day"=>"12","2 Times Weekly"=>"27","3 Times Weekly"=>"20","Once a Month"=>"22","Nightly"=>"18","Every night at bedtime"=>"19","Fasting"=>"35","Stat"=>"31","Now"=>"32"
		,"ONCE A DAY BEFORE BREAKFAST"=>"34","ONCE A DAY AFTER BREAKFAST"=>"35","TWICE A DAY BEFORE MEALS"=>"36","TWICE A DAY AFTER MEALS"=>"37","FORTNIGHTLY"=>"38","ALTERNATE DAY"=>"39"
		,"ONCE A WEEK ON SUNDAY AFTER DINNER"=>"40","DAILY AFTER DINNER EXCEPT SUNDAY"=>"41","ONCE A DAY AFTER DINNER"=>"42","DAILY AST"=>"43","DAILY AFTER BREAKFAST"=>"44"
);

$config['roop']= array('1'=>'TAB','2'=>'CAP','3'=>'DROP','4'=>'INJ.','5'=>'SYRUP');
$config['selected_roop']= array('TAB'=>'1','CAP'=>'2','DROP'=>'3','INJ.'=>'4','SYRUP'=>'5');
$config['frequency_value']= array("0"=>"30","1"=>"30","2"=>"30","5"=>"60","6"=>"90","7"=>"120","25"=>"480","13"=>"240","29"=>"360","28"=>"240","8"=>"180","24"=>"180","9"=>"120","10"=>"90","11"=>"60","26"=>"15","23"=>"10","18"=>"30","19"=>"30","4"=>"30","12"=>"15","27"=>"8.57","20"=>"12.86","14"=>"4","15"=>"2","16"=>"1.43","22"=>"1","17"=>"1","35"=>"30",
		"35"=>"30","36"=>"60","37"=>"60","34"=>"30","38"=>"30","39"=>"15","40"=>"4"
		,"41"=>"26","42"=>"30","43"=>"30","44"=>"30");

//$config['frequency_per_day']= array("1"=>"as directed","1"=>"Daily","1"=>"in A.M.","2"=>"BID","3"=>"TID","4"=>"QID","12"=>"Q2h","8"=>"Q3h","6"=>"Q4h","4"=>"Q6h","3"=>"Q8h","2"=>"Q12h","0.5"=>"Q48h","0.33"=>"Q72h","4"=>"Q4-6h","8"=>"Q2h WA","0.1429"=>"Q1wk","0.0714"=>"Q2wks","0.0476"=>"Q3wks","16"=>"Q1h WA","0.5"=>"Every Other Day","0.2857"=>"2 Times Weekly","0.4856"=>"3 Times Weekly","0.0333"=>"Once a Month","1"=>"Nightly","1"=>"QHS");

$config['frequency_fullform']= array("1"=>"As directed","2"=>"Daily","4"=>"In the morning, before noon","5"=>"Twice a day","6"=>"Thrice a day","7"=>"Four times a day","29"=>"Every 2 hours","28"=>"Every 3 hours","8"=>"Every 4 hours","9"=>"Every 6 hours","10"=>"Every 8 hours","11"=>"Every 12 hours","26"=>"Every 48 hours","23"=>"Every 72 hours","24"=>"Every 4-6 hours","13"=>"Every 2 hours with assistance","14"=>"Every 1 week","15"=>"Every 2 weeks","16"=>"Every 3 weeks","25"=>"Every 1 hour with assistance","12"=>"Every Other Day","27"=>"2 Times Weekly","20"=>"3 Times Weekly","22"=>"Once a Month","18"=>"Nightly","19"=>"Every night at bedtime","31"=>"Stat","32"=>"Now","35"=>"Fasting");
//$config['strength']= array("tablet"=>"tablet","Add'l sig"=>"Add'l sig","application"=>"application","capsule"=>"capsule","drop"=>"drop","gm"=>"gm","item"=>"item","lozenge"=>"lozenge","mcg"=>"mcg","mg"=>"mg","mL"=>"mL","mg/mL"=>"mg/mL","patch"=>"patch","pill"=>"pill","puff"=>"puff","squirt"=>"squirt","suppository"=>"suppository","troche"=>"troche","unit"=>"unit","unit/mL"=>"unit/mL","syringe"=>"syringe","package"=>"package"); // this is dosage form not strength

$config['strength']= array("1"=>"APPLICATION","2"=>"ITEM",/*,"2"=>"CAPSULE"*/"3"=>"DROP","4"=>"GM","5"=>"LOZENGE","6"=>"ML","7"=>"PATCH","8"=>"PILL","9"=>"PUFF",
		"10"=>"SQUIRT","11"=>"SUPPOSITORY"/*,"12"=>"TABLET"*/,"13"=>"TROCHE","14"=>"UNIT"/*,"15"=>"SYRINGE"*/,"16"=>"PACKAGE","17"=>"MCG","18"=>"MG","19"=>"%"); // this is dosage form not strength

$config['selected_strength']= array("APPLICATION"=>"1"/*,"CAPSULE"=>"2"*/,"DROP"=>"3","GM"=>"4","ITEM"=>"19","LOZENGE"=>"5","ML"=>"6","PATCH"=>"7","PILL"=>"8","PUFF"=>"9",
		"SQUIRT"=>"10","SUPPOSITORY"=>"11"/*,"TABLET"=>"12"*/,"TROCHE"=>"13","UNIT"=>"14"/*,"SYRINGE"=>"15"*/,"PACKAGE"=>"16","MCG"=>"17","MG"=>"18","%"=>"19"); // this is dosage form not strength

$config['selected_dosageform']= array("tablet"=>"12","tablet extended release"=>"12","tablet extended release 12 hr"=>"12","tablet,chewable"=>"12","tablet extended release 24hr"=>"12","tablet, effervescent"=>"12","tablet,delayed release (DR/EC)"=>"12","tablet,IR & delay rel,biphasic"=>"12","tablet, ER multiphase 24 hr"=>"12","tablet, sublingual"=>"12","tablets,ext.rel 12h sequential"=>"12","tablet,disintegrating"=>"12","tablet, effervescent"=>"12","tablet,disintegrating"=>"12","tablet,ER particles/crystals"=>"12","tablet, dispersible"=>"12","tablets,dose pack"=>"12","tablet, particles/crystals"=>"12","tablet,soluble"=>"12","tablet,extend rel osmotic push"=>"12","tablets,ext.rel 12h sequential"=>"12","tablets, sequential"=>"12",
		"tablet, ER multiphase 12 hr"=>"12","tablet,ER gast.retention 24 hr"=>"12","tablet,ext release sequential"=>"12","tablet extended rel,dose pack"=>"12","tablet,ext release multiphase"=>"12","tablets,dose pack,3 month"=>"12","tablet,IR & delay rel,biphasic"=>"12","tablet,ER dosepak biphase 24hr"=>"12","tablet and capsule, sequential"=>"12","tablet disintegrating, dose pk"=>"12","tablet,oral only,ext.rel.12 hr"=>"12","tablet (tamper resistant)"=>"12","tablet for suspension"=>"12","tab,oral only,IR & ER, biphase"=>"12","capsule"=>"2","capsule"=>"2","capsule,extended release 24hr"=>"2","capsule,ext rel. pellets 24 hr"=>"2",
"capsule,delayed release(DR/EC)"=>"2","capsule, extended release"=>"2","capsule,extended release 12 hr"=>"2","capsule,ext release degradable"=>"2","capsule,delayed rel. particles"=>"2","capsule,ext rel. pellets 24 hr"=>"2","capsule, ER multiphase 12 hr"=>"2","capsule, ER biphasic 30-70"=>"2","capsule, 24 hr ER pellet CT"=>"2","capsule, sprinkle"=>"2"
		,"powder"=>"4","recon soln"=>"6","liquid"=>"6","drops,suspension"=>"3","granules"=>"4","lozenge"=>"5","solution"=>"6","syrup"=>"6","suspension"=>"6","parenteral solution"=>"6","pad"=>"19","aerosol"=>"9","oil"=>"1"
		,"kit"=>"19","wafer"=>"","device"=>"19","needle"=>"19","aerosol,spray"=>"9","suppository"=>"11","mouthwash"=>"19","drops"=>"3","bar"=>"19","intravenous admix accessory"=>"19 "
,"syringe"=>"15","bandage"=>"19","crystals"=>"","enema"=>"11","cream"=>"1","suspension for reconstitution"=>"6","powder in packet"=>"4","gel"=>"1","packet"=>"19","adhesive patch,medicated"=>"7"
,"spray,non-aerosol"=>"9","elixir"=>"","piggyback"=>"19","blister with device"=>"","blood administration set"=>"19","ointment"=>"1","infusion set"=>"19"
,"spirit"=>"1","shampoo"=>"1","lotion"=>"1","combo pack"=>"16","pen injector kit"=>"15","tray"=>"19"
,"aerosol powder"=>"4","strip"=>"","swab"=>"19","inhaler"=>"9","paste"=>"19","spacer"=>"19","tape"=>"19","soap"=>"1","tincture"=>"6","hypodermic tablet"=>"12"
		,"lump"=>"","cleanser"=>"19","toothpaste"=>"19","injectable"=>"6","flakes"=>"","emulsion"=>"6","pads, medicated"=>"19","diaphragm"=>"19","syringe,reusable"=>"15","cake"=>"19"
,"solution for nebulization"=>"6","medicated shaving cream"=>"1","lozenge on a handle"=>"5","concentrate"=>"6","cartridge"=>"19","stick"=>"19","patch 24 hour"=>"7","patch weekly"=>"7","patch semiweekly"=>"7","mist"=>"","lubricant"=>"","intrauterine device"=>"","ring"=>"19","sponge"=>"19","gum"=>""
,"syringe kit"=>"15","suspension,extended rel 12 hr"=>"6","diagnostic test"=>"","granules effervescent"=>"6","troche"=>"13","tampon"=>"19","wax"=>"19","allergen"=>"","plaster"=>"9","foam"=>"","patch"=>"7","insulin pen"=>"15","dropperette"=>"3","patch 72 hour"=>"7","liniment"=>"1","emulsion in packet"=>"6","leaves"=>""
		,"irrigation solution"=>"6","package"=>"16","bottle"=>"19","fluid extract"=>"6","pen injector"=>"15","sheet"=>"19","aerosol solution"=>"9","unit"=>"14","susp,delayed release for recon"=>"6","suspension,microcapsule recon"=>"2","auto-injector"=>"15","cap,ext release pellets 12 hr"=>"2","implant"=>"14","tar"=>"","intraperitoneal admin. sets"=>"19","insert"=>"","gas"=>"","irrigation set"=>"19","gel forming solution"=>"1","disk"=>"","pipette"=>"19","gel in packet"=>"1"
,"pellet"=>"8","solution with applicator"=>"1","cream in packet"=>"1","syringe,Cornwall"=>"15","suspension for nebulization"=>"6","needle, reusable"=>"19","aerosol powdr breath activated"=>"9","cream,extended release"=>"1","HFA aerosol inhaler"=>"9","aerosol breath activated"=>"9","granules in packet"=>"6","drops, liquid gel"=>"1","liquid extended release"=>"6","spray,suspension"=>"9","powder effer"=>"4","gel,extended release"=>"1","pt controlled analgesia syring"=>"15","lens"=>"19","patch, TD daily, sequential"=>"7","mucoadhesive System ER 12 hr"=>"","plastic bag for injection"=>"19","beads"=>"19"
		,"gel in metered-dose pump"=>"1","drops, viscous"=>"3","lotion,extended release"=>"1" ,"prefilled pump reservoir"=>"","suspension,extended rel recon"=>"6","inhaler kit"=>"19","patient control.analgesia soln"=>"6","towelette"=>"19","tablet, ER osmotic push 12 hr"=>"12","drops, once daily"=>"3","patch, medicated self-heating"=>"7","contraceptive sponge"=>"19","combo pack,tablet & cap,DR"=>"12"
,"patch, iontophoretic"=>"7","granules DR for susp in packet"=>"6","solution, sequential"=>"6","gel,alcohol based"=>"1","patch,transdermal PCA"=>"7","combo pack, tablet 12hr & loz"=>"12","nail film suspension"=>"6","ointment in packet"=>"1","nail film susp, pen applicator"=>"1","suspension in an applicator"=>"1","ointment kit"=>"1","suspension,adhesive"=>"6","emulsion, adhesive"=>"6","combo pack,capsule 12hr&lozeng"=>"2","spray gel"=>"1"
,"combo pack, tablet & pad"=>"2","solution in packet"=>"6","patch 12 hour"=>"7","combo pack, capsule & pad"=>"2","kit,cleanser & cream ER"=>"1","lozenge,extended release"=>"5","cleanser,extended release"=>"","combo pack,ointment and lotion"=>"1","kit,cream & lotion,emollient"=>"1","kit,ointment & lotion, emolnt"=>"1","kit,cream & towelette"=>"1","kit,lotion & cream,emollient"=>"1","emulsion in metered-dose pump"=>"6","jelly in applicator"=>"1","elastomeric pump,fixed rate"=>"","elastomeric pump,hi var rate"=>"","combo pack, tab MP 24hr & cap"=>"12","dropperette,gel"=>"1","needle-free injector"=>"19","lotion in packet"=>"1","combo pack,cream & lotion"=>"1","kit,cleanser and cream"=>"1","liquid in packet"=>"6"
,"powder effervescent in packet"=>"4","muco-adhesive buccal tablet"=>"12","cleanser,gel extended release"=>"1","combo pack,cream and gel"=>"1","combo pack,ointment and cream"=>"1","aerosol, metered spray"=>"9","kit,shampoo and gel"=>"1","combo pack,ointment and foam"=>"1","dropperette,hyperviscous"=>"3","drops,hyperviscous"=>"3","solution in metered pump w/app"=>"","prefilled spoon"=>"","dropperette,viscous"=>"3","cream,ER multiphase in pump"=>"1","gel for implant in syringe"=>"","suspension,extend release 24hr"=>"6","suspension in packet"=>"6","powder in packet, sequential"=>"4","liquid, sequential"=>"6","combo pack,gel and lotion"=>"1"
,"elastomer pump,fixed rate,PCA"=>"","drops,gel"=>"1","kit,cream and gel"=>"1","kit,ointment and liquid"=>"1","oil in straw"=>"1","kit,cream & liquid"=>"1","combo packets,gel and lotion"=>"1","cream in metered-dose pump"=>"1","nail film solution"=>"6","granules, effervescent packet"=>"6","spray syringe"=>"15","elastomeric pump,lo var rate"=>"","film forming liquid w/appl"=>"6","drops with applicator"=>"3","emulsion, extended release"=>"6","kit,gel and foam"=>"1"
,"comb pack,prefill appl & cream"=>"1","suspension,ext rel 24hr,recon"=>"6","cap,sprinkle,ER 24hr dose pack"=>"","combo pack,gel and foam"=>"1","drops,suspension biphasic"=>"3","gel with pump"=>"1","tea"=>"1","combo pack,gel and liquid"=>"1","nasal spray syringe"=>"15","combo pack,tab & soft chew cap"=>"16","cream, rapid release"=>"1","capsule, delayed rel sprinkle"=>"2","tablet (tamper resistant)"=>"12","soln&soln recon,sequential"=>"","syringe, with swab cap"=>"15","bath packet"=>"19","combo pack,tab chew and tablet"=>"12","patch 4 day"=>"7","kit. syringe & tablet"=>"16","kit, liquid & tablet"=>"16"
,"combo pack, tablet & strip"=>"12","tablet, delayed & ext.release"=>"12","spray with pump"=>"19","combo pack,cleanser and lotion"=>"1","solution in metered-dose pump"=>"6","film-forming soln ER w/ appl"=>"","combo pack,cleanser and cream"=>"1","kit, cleanser & gel"=>"1","powder for reconstitution, del"=>"4","powder for injection"=>"4","dressing"=>"19","delayed release tablet"=>"12","tablet, disintegrating"=>"12","powder for reconstitution"=>"4","disintegrating strip"=>"12"
		,"delayed release capsule"=>"2","spray"=>"9","powder for reconstitution, ext"=>"4","powder for injection, extended"=>"4","film, extended release"=>"","gel with applicator"=>"1","ointment w/applicator"=>"1","cream with applicator"=>"1","suspension, extended release"=>"6");

$config['refills']= array("0"=>"0","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10","11"=>"11","12"=>"12");

$config['daysupply']= array("2 days"=>"2 days","3 days"=>"3 days","4 days"=>"4 days","5 days"=>"5 days","6 days"=>"6 days","7 days"=>"7 days","10 days"=>"10 days","14 days"=>"14 days","21 days"=>"21 days","30 days"=>"30 days","60 days"=>"60 days","90 days"=>"90 days");

$config['collection_priority']= array("ABG"=>"ABG","AM Draw"=>"AM Draw","Now"=>"Now","Op Order"=>"Op order","Routine"=>"Routine","Stat"=>"Stat","Timed Study"=>"Timed Study");

$config['duration_unit']= array("Minutes"=>"Minutes","Hours"=>"Hours","Weeks"=>"Weeks","Monthly"=>"Monthly");

$config['frequency_lr']= array("Once a day"=>"Once a day","Twice a day"=>"Twice a day","Weekly"=>"Weekly","Monthly"=>"Monthly");

$config['reason_exam']= array("Chest Pain"=>"Chest Pain","Congestion"=>"Congestion","Cough"=>"Cough","Dyspnea"=>"Dyspnea","Fever"=>"Fever","Line Placement"=>"Line Placement","Pain"=>"Pain","Post Biopsy"=>"Post Biopsy","Post OP"=>"Post OP","Pre Op"=>"Pre Op","Respiratory Distress"=>"Respiratory Distress");

$config['site'] = array(''=>'Please select','Left AC'=>'Left AC','Left Extern Jugular'=>'Left Extern Jugular','Left Foot'=>'Left Foot','Left Hand'=>'Left Hand','Left Intern Jugular'=>'Left Intern Jugular','Left Lower Forearm'=>'Left Lower Forearm','Left Mid Forearm'=>'Left Mid Forearm','Left Subclavian'=>'Left Subclavian','Left Upper Arm'=>'Left Upper Arm','Left Upper Forearm'=>'Left Upper Forearm','Right AC'=>'Right AC','Right Extern Jugular'=>'Right Extern Jugular','Right Foot'=>'Right Foot','Right Hand'=>'Right Hand','Right Intern Jugular'=>'Right Intern Jugular','Right Lower Forearm'=>'Right Lower Forearm','Right Mid Forearm'=>'Right Mid Forearm','Right Subclavian'=>'Right Subclavian','Right Upper Arm'=>'Right Upper Arm');

$config['late_reason_mar'] = array(''=>'Please select','Accommodate D/C'=>'Accommodate D/C','Blood Infusing/To Be Infused'=>'Blood Infusing/To Be Infused','Med Not Available'=>'Med Not Available','New Med Order'=>'New Med Order','No IV Access'=>'No IV Access','Nursing Judgment'=>'Nursing Judgment','Patient Emesis'=>'Patient Emesis','Patient Not Available/Off Unit'=>'Patient Not Available/Off Unit','Patient NPO for Procedure'=>'Patient NPO for Procedure','Patient Refused'=>'Patient Refused','Physician Order to Hold'=>'Physician Order to Hold','System Down'=>'System Down','Wan to Standard Admin Times'=>'Wan to Standard Admin Times');

$config['licensure_type']= array('Acupuncture/East Asian Medicine Practitioner License - AC'=>'Please select','Acupuncture/East Asian Medicine Practitioner Temporary Practice Permit - TP'=>'Acupuncture/East Asian Medicine Practitioner Temporary Practice Permit - TP','Advanced Emergency Medical Technician Certification - ES'=>'Advanced Emergency Medical Technician Certification - ES','Advanced Registered Nurse Practitioner - AP'=>'Advanced Registered Nurse Practitioner - AP','Advanced Registered Nurse Practitioner Anesthetist License - AP'=>'Advanced Registered Nurse Practitioner Anesthetist License - AP');


$config['adv_directive'] = array(''=>'Please select','Both-Copy On File'=>'Both-Copy On File','Both-Copy Not On File'=>'Both-Copy Not On File','DPA-Copy On File'=>'DPA-Copy On File','DPA-Copy Not On File'=>'DPA-Copy Not On File','Living Will-Copy On File'=>'Living Will-Copy On File','Living Will-Copy Not On File'=>'Living Will-Copy Not On File','None'=>'None','Unknown'=>'Unknown');
$config['visit_type'] = array('CLINIC'=>'CLINIC','ADMIT'=>'ADMIT','DISCHARGE'=>'DISCHARGE','PENDING DISCHARGE'=>'PENDING DISCHARGE','PRE-REG'=>'PRE-REG');

$config['source'] = array(''=>'Please select',"Clinic Referral"=>__('Clinic Referral'),"Court/Law ENF"=>__('Court/Law ENF'),"Follow-up"=>__('Follow-up'),"HMO Referral"=>__('HMO Referral'),"Non Healthcare Facility"=>__('Non Healthcare Facility'),"Transfer from a Skilled Nursing Facility"=>__('Transfer from a Skilled Nursing Facility'),"Transfer from Another Healthcare Facility"=>__('Transfer from Another Healthcare Facility'),"Transfer from Hospital"=>__('Transfer from Hospital'));

$config['arrive_by'] = array(''=>'Please select',"Ambulance"=>__('Ambulance'),"Employers Vehicle"=>__('Employers Vehicle'),"EMS"=>__('EMS'),"Fire Department"=>__('Fire Department'),"Medi Flight"=>__('Medi Flight'),"New Born"=>__('New Born'),"Police Department"=>__('Police Department'),"Private Vehicle"=>__('Private Vehicle'),"Taxi Cab"=>__('Taxi Cab'),"Unknown"=>__('Unknown'));

$config['occurrence_code'] = array(''=>'Please select',"Auto Accident"=>__('Auto Accident'),"No Fault Insurance Involved"=>__('No Fault Insurance Involved'),"Accident/Tort liability"=>__('Accident/Tort liability'),"Accident/Employment Related"=>__('Accident/Employment Related'),"Other Accident"=>__('Other Accident'),"Crime Victim"=>__('Crime Victim'),"Start Of Infertility Cycle"=>__('Start Of Infertility Cycle'),"Last Menstrual Period"=>__('Last Menstrual Period'),"Onset of Symptoms/Illness"=>__('Onset of Symptoms/Illness'));

$config['select_type'] = array(""=>'Please Select Type',"Elective"=>__('Elective'),"Emergency"=>__('Emergency'),"NewBorn"=>__('NewBorn'),"Urgent"=>__('Urgent'));

$config['physician_tab'] = array(""=>'Please Select Type',"Admitting"=>__('Admitting'),"Attending"=>__('Attending'),"Referring"=>__('Referring'));

$config['storage_status'] = array(""=>'Please Select Type',"Request receive"=>__('Request receive'),"Item delivere"=>__('Item delivere'),"Not availab"=>__('Not availab'),"Order sent to suppl"=>__('Order sent to suppl'));

$config['location'] = array(''=>'Please select','Ribs'=>'Ribs','Sternum'=>'Sternum','Upper Back'=>'Upper Back','Abdomen Lower'=>'Abdomen Lower','Abdomen Upper'=>'Abdomen Upper','Achilles'=>'Achilles','Ankle'=>'Ankle','Arm'=>'Arm','Back'=>'Back','Buttock'=>'Buttock','Calf'=>'Calf','Chest'=>'Chest','Coccyx'=>'Coccyx','Ear'=>'Ear','Elbow'=>'Elbow','Epigastric'=>'Epigastric','Eye'=>'Eye','Face'=>'Face','Finger'=>'Finger','Flank'=>'Flank','Forearm'=>'Forearm','Generalized'=>'Generalized','Groin'=>'Groin','Head'=>'Head','Heel'=>'Heel','Hip'=>'Hip');

$config['generated_fax_path'] = 'files/fax_referral/' ;
$config['fax_username'] = 'pankajm'; // Enter your Interfax username here
$config['fax_password'] = 'pass123'; // Enter your Interfax password here
$config['microbiology'] = array("Microbiology"=>"Microbiology");
$config['pathology'] = array("Pathology"=>"Pathology");
$config['imageTypesAllowed'] = array("image/jpeg", "image/gif", "image/png");
$config['continuous_infusion'] = 'Continuous Infusion' ;
$config['medications'] = 'Medications' ;
$config['oral'] = 'Oral' ;
$config['enteral'] = 'Enteral' ;
$config['gastric'] = 'Gastric' ;
$config['urine_output'] = 'Urine Output' ;
$config['gastric_tube_output'] = 'Gastric Tube Outputs' ;
$config['respiratory_rate'] = 'Respiratory Rate' ;
$config['oxygen_therapy'] = 'Oxygen Therapy' ;
$config['spo2'] = 'SpO2' ;
$config['ventilator_mode'] = 'Ventilator Mode' ;
$config['tidal_volume_set'] = 'Tidal Volume Set' ;
$config['tidal_volume_inhaled'] = 'Tidal Volume Inhaled' ;
$config['tidal_volume_exhaled'] = 'Tidal Volume Exhaled' ;
$config['rate'] = 'Rate' ;
$config['mean_airway_pressure'] = 'Mean Airway Pressure (MAwP)' ;
$config['peak_inspiratory_pressure'] = 'Peak Inspiratory Pressure (PIP)' ;
$config['positive_end'] = 'Positive End Expiratory Pressure (PEEP)' ;
$config['pressure_support'] = 'Pressure Support Ventilation (PS)' ; 
$config['temperature_oral'] = 'Temperature Oral' ;
$config['temperature_axillary'] = 'Temperature Axillary' ;
$config['temperature_rectal'] = 'Temperature Rectal' ;
$config['heart_rate_monit'] = 'Heart Rate Monitoring' ;
$config['apical_heart_rate'] = 'Apical Heart Rate' ;
$config['vital_sign_cerebral_perfusion'] = 'Cerebral Perfusion Pressure (CPP)' ;
$config['vital_sign_intracranial_pressure'] = 'Intracranial Pressure (ICP)' ;
$config['vital_sign_central_venous'] = 'Central Venous Pressure (CVP)' ;
$config['vital_sign'] = 'Vital Signs' ;
$config['ventilator_subset'] = 'Ventilator Subset' ;
$config['continuous_infu_esmolol']='esmolol';
$config['continuous_infu_Lidocaine']='Lidocaine';
$config['continuous_infu_Propranolol']='Propranolol';
$config['continuous_infu_Amiodarone']='Amiodarone';
$config['continuous_infu_Procainamide']='Procainamide';
$config['continuous_infu_Vasopressin']='Vasopressin';
$config['continuous_infu_Dopamine']='DOPamine';
$config['continuous_infu_NORepinephrine']='NORepinephrine';
$config['drain_n_chest_tubes']='Drains and Chest Tubes';
$config['chest_tube_outputs']='Chest Tube outputs';
$config['bloodPressure_SbpDbp_cuff']='SBP/DBP Cuff';
$config['bloodPressure_mean_cuff']='Mean Arterial Pressure Cuff';
$config['bloodPressure_SbpDbp_Aline']='SBP/DBP Arterial Line';
$config['bloodPressure_mean_Aline']='Mean Arterial Pressure Line';
$config['Parenteral']='Parenteral';
$config['Other_Intake_Sources']='Other Intake Sources';
$config['Emesis_Output']='Emesis Output';
$config['Stool_Output']='Stool Output';
$config['Transfusions']='Transfusions';
$config['Laboratory_Category_id']=34;
$config['Radiology_Category_id']=36;
$config['Medication_Category_id']=33;
$config['ignore_orderset_folders']= array('37','38','39');
$config['order_set_number_of_rows']=1000;
$config['patient_permission_array']=array('1'=>'Problems','2'=>'Medication','3'=>'Allergies', '4'=>'Laboratory','5'=>'Radiology' );
//For Bmi Graphs
$config['interactive_bmi']='Body Mass Index';
$config['bmi_height_measured']='Height/Length measurement';
$config['bmi_weight_measured']='Weight Measured';

$config['bmi_head_circumference']='Head Circumference';


//Payer
$config['address_type']=array(''=>'Please Select','HOME'=>'HOME','VACATION'=>'VACATION','WORK'=>'WORK');
$config['categorypayer']=array('Government programs'=>'Government programs','Commercial payer'=>'Commercial payer','Managed care plan'=>'Managed care plan');

$config['outpatientclaim']=array('CMS-1500'=>'CMS-1500','UB-92'=>'UB-92');
$config['inpatientclaim']=array('CMS-1500'=>'CMS-1500','UB-92'=>'UB-92');
$config['nonpatientclaim']=array('CMS-1500'=>'CMS-1500','UB-92'=>'UB-92');

$config['outpatientgovsub1']=array('Ambulatory payment classification(APC)'=>'Ambulatory payment classification(APC)');
$config['inpatientgovsub2']=array('Diagnosis Ralated Group(DRG)'=>'Diagnosis Ralated Group(DRG)');
$config['nonpatientgovsub3']=array('Resource-based Relative value scale(RBRVC)'=>'Resource-based Relative value scale(RBRVC)');

$config['reimbursement']=array('Traditional'=>'Traditional','Fixed Payment'=>'Fixed Payment','Prospective Payment System(PPS)'=>'Prospective Payment System(PPS)');

//reimbursement Method
$config['traditionalval']=array('Fee-for-service'=>'Fee-for-service','Fee schedule'=>'Fee schedule','Percentage of accrued charges'=>'Percentage of accrued charges','Usual,customary and reasonable(UCR)'=>'Usual,customary and reasonable(UCR)');
$config['fixedpaymentval']= array('Capitation'=>'Capitation', 'Case rate'=>'Case rate','Contact rate'=>'Contact rate','Flat rate'=>'Flat rate','Per diem'=>'Per diem','Relative value scale(RVS)'=>'Relative value scale(RVS)');
$config['prospectivepaymentsystemval']=array('Ambulatory payment classification(APC)'=>'Ambulatory payment classification(APC)','Diagnosis Ralated Group(DRG)'=>'Diagnosis Ralated Group(DRG)','Resource-based relative value scale(RBVS)'=>'Resource-based relative value scale(RBVS)');

//
$config['payer_status']=array('Enrollment Not Required'=>'Enrollment Not Required','Enrollment Required'=>'Enrollment Required');
$config['billing_npi']=array('Hospital NPI Number'=>'Hospital NPI Number','Group NPI Number'=>'Group NPI Number','Provider NPI Number'=>'Provider NPI Number');
$config['provider_name']=array('Hospital Name'=>'Hospital Name','Practice Name'=>'Practice Name','Provider Name'=>'Provider Name');

$config['tax_id']=array('Tax ID Number()'=>'Tax ID Number()');
$config['bal_billing']=array('Yes'=>'Yes','No'=>'No');

$config['bmi_head_circumference']='Head Circumference';

$config['bmi_head_circumference']='Head Circumference';
$config['report_icu_name']='Acute Care Unit';

//Payer

$config['categorypayer']=array('Government programs'=>'Government programs','Commercial payer'=>'Commercial payer','Managed care plan'=>'Managed care plan');

$config['outpatientclaim']=array('CMS-1500'=>'CMS-1500','UB-92'=>'UB-92');
$config['inpatientclaim']=array('CMS-1500'=>'CMS-1500','UB-92'=>'UB-92');
$config['nonpatientclaim']=array('CMS-1500'=>'CMS-1500','UB-92'=>'UB-92');

$config['outpatientgovsub1']=array('Ambulatory payment classification(APC)'=>'Ambulatory payment classification(APC)');
$config['inpatientgovsub2']=array('Diagnosis Ralated Group(DRG)'=>'Diagnosis Ralated Group(DRG)');
$config['nonpatientgovsub3']=array('Resource-based Relative value scale(RBRVC)'=>'Resource-based Relative value scale(RBRVC)');

$config['reimbursement']=array('Traditional'=>'Traditional','Fixed Payment'=>'Fixed Payment','Prospective Payment System(PPS)'=>'Prospective Payment System(PPS)');

//reimbursement Method
$config['traditionalval']=array('Fee-for-service'=>'Fee-for-service','Fee schedule'=>'Fee schedule','Percentage of accrued charges'=>'Percentage of accrued charges','Usual,customary and reasonable(UCR)'=>'Usual,customary and reasonable(UCR)');
$config['fixedpaymentval']= array('Capitation'=>'Capitation', 'Case rate'=>'Case rate','Contact rate'=>'Contact rate','Flat rate'=>'Flat rate','Per diem'=>'Per diem','Relative value scale(RVS)'=>'Relative value scale(RVS)');
$config['prospectivepaymentsystemval']=array('Ambulatory payment classification(APC)'=>'Ambulatory payment classification(APC)','Diagnosis Ralated Group(DRG)'=>'Diagnosis Ralated Group(DRG)','Resource-based relative value scale(RBVS)'=>'Resource-based relative value scale(RBVS)');

//

$config['payer_status']=array('Enrollment Not Required'=>'Enrollment Not Required','Enrollment Required'=>'Enrollment Required');
$config['provider_name']=array('Hospital Name'=>'Hospital Name','Practice Name'=>'Practice Name','Provider Name'=>'Provider Name');


//Zirmed configuration
$config['zirmed_mode']="T"; //P - Production Data; T - Test Data
$config['receiver_id']="ZIRMED"; //Interchange reciever id
$config['zirmed_client_accountid']="82108";
$config['zirmed_client_accountname']="DrMHope Softwares";
$config['zirmed_contact_person']="Pankaj Mankar";
$config['zirmed_contact_email']="pankajm@drmhope.com";
$config['edi_segments_header']=array('ISA'=>'16','GS'=>'8','ST'=>'3','BHT'=>'6','REF'=>'2');

$config['relationship_with_insured']=array('01'=>'Spouse','04'=>'Grandfather or Grandmother','05'=>'Grandson or Granddaughter', '07'=>'Nephew or
Niece','09'=>'Adopted child','10'=>'Foster child','15'=>'Ward', '16'=>'Stepfather or Stepmother','17'=>'Stepson or Stepdaughter','18'=>'Self','19'=>'Child where insured has financial responsibility', '20'=>'Employee','21'=>'Unknown','22'=>'Handicapped dependent','23'=>'Sponsored dependent', '24'=>'Dependent of a minor dependent','29'=>'Significant other','32'=>'Mother','33'=>'Father', '34'=>'Other adult','36'=>'Emancipated minor','39'=>'Organ donor','40'=>'Cadaver donor', '41'=>'Injured plaintiff','43'=>'Child where insured has no financial responsibility','53'=>'Life partner','G8'=>'Other');

$config['place_service_code']=array('22'=>'Clinic','03'=>'School','04'=>'Homeless Shelter','05'=>'Indian Health Service Free-standing Facility','06'=>'Indian Health Service Provider-based Facility','07'=>'Tribal 638 Free-standing Facility','08'=>'Tribal 638 Provider-based Facility','11'=>'Office','12'=>'Home','13'=>'Assisted Living Facility','14'=>'Group Home','15'=>'Mobile Unit','20'=>'Urgent Care Facility','21'=>'Inpatient Hospital','23'=>'Emergency Room-Hospital','24'=>'Ambulatory Surgical Center','25'=>'Birthing Center','26'=>'Military Treatment Facility','31'=>'Skilled Nursing Facility','32'=>'Nursing Facility','33'=>'Custodial Care Facility','34'=>'Hospice','41'=>'Ambulance-Land','42'=>'Ambulance-Air or Water','49'=>'Independent Clinic','49'=>'Federally Qualified Health Center','50'=>'Inpatient Psychiatric Facility','51'=>'Psychiatric Facility-Partial Hospitalization','52'=>'Community Mental Health Center','54'=>'Intermediate Care Facility/Mentally Retarded','55'=>'Residential Substance Abuse Treatment Facility','56'=>'Psychiatric Residential Treatment Center','57'=>'Non-residential Substance Abuse Treatment Facility','60'=>'Mass Immunization Cente','61'=>'Comprehensive Inpatient Rehabilitation Facility','62'=>'Comprehensive Outpatient Reabilitation Facility','65'=>' End-Stage Renal Disease Treatment Facility','71'=>'Public Health Clinic','72'=>'Rural Health Clinic','81'=>'Independent Laboratory','99'=>'Other Place of Service');

$config['enrollment_status']=array(''=>'Please Select','Applied'=>'Applied', 'Waiting for documents'=> 'Waiting for documents','Documents submitted to payer'=>'Documents submitted to payer','In process with payer'=>'In process with payer','Approved'=>'Approved');

//$config['edi_segments_header']=array('16'=>'ISA','8'=>'GS','2'=>'ST','6'=>'BHT','2'=>'REF');

$config['claim_status'] = array('Claim Submitted'=>'Claim Submitted','ERA Received'=>'ERA Received','In Process At Clearinghouse'=>'In Process At Clearinghouse','In Process at Payer'=>'In Process at Payer','Payer Acknowledged'=>'Payer Acknowledged','Coordination of Benefits'=>'Coordination of Benefits',
'Other'=>'Other','Rejected'=>'Rejected','ERA Denied'=>'ERA Denied','Not Submitted'=>'Not Submitted','Missing Information'=>'Missing Information');
$config['common_diagnosis_kpi'] = array('64620000','85484001','155295004','249496004','8197001','1201005');
//Add_before_claim
$config['billing_status']=array('Paid in Full'=>'Paid in Full','Balance Due'=>'Balance Due','Settled'=>'Settled','Internal Review'=>'Internal Review','Bill Insurance'=>'Bill Insurance','Bill Secondary Insurance'=>'Bill Secondary Insurance','Worker\'s Comp Claim'=>'Worker\'s Comp Claim','Auto Accident Claim'=>'Auto Accident Claim','Durable Medical Equipment Claim'=>'Durable Medical Equipment Claim','Pending'=>'Pending','To be Billed'=>'To be Billed');

//$config['common_diagnosis_kpi'] = array('64620000','85484001','155295004','249496004','8197001');

//pawan Mode of hospitals used in permission (e.g. Clinic, Hospital)
$config['hospital_mode'] = array('Clinic'=>'Clinic','Hospital'=>'Hospital');
$config['hospital_default_mode'] = 'Clinic';

// Pawan Calendar days appointment to show on big calendar
$config['calendar_days_to_show'] = '30';
$config['calendar_start_time'] = '07';
$config['calendar_end_time'] = '21';
$config['calendar_vaccation_messages'] = 'Not Available';
///Encounters Delay Reason
$config['delay_reason']=array('1'=>'1-Proof of Eligibility Unknown or Unavailable','2'=>'2-Litigation','3'=>'3-Authorization Delays','4'=>'4-Delay in Certifying Provider',
							  '5'=>'5-Delay in Supplying Billing Forms','6'=>'6-Delay in Delivery of Custom-made Appliances','7'=>'7-Third Party Processing Delay','8'=>'8-Delay in Eligibility Determination',
							  '9'=>'9-Original Claim Rejected or Denied Due to a Reason Unrelated to the Billing Limitation Rules','10'=>'10-Administration Delay in the Prior Approval Process','11'=>'11-Other',
							  '15'=>'15-Natural Disaster','16'=>'16-Lack of Information','17'=>'17-No response to initial request');
$config['claim_notes_ref_code']=array('AAA'=>'AAA-Agent Details','AAB'=>'AAB-Associated Business Areas','AAC'=>'AAC-Borrower','AAD'=>'AAD-Nationality Details',
									  'AAE'=>'AAE-Assets','AAF'=>'AAF-Liabilities','AAH'=>'AAH-Additional Facility Details','AAI'=>'AAI-Exemption Law Location Description',
									  'AAJ'=>'AAJ-Forecast Details','AAK'=>'AAK-Import and Export Details','AAL'=>'AAL-Inventory Valuation','AAM'=>'AAM-Product Brands Sold Description',
									  'AAN'=>'AAN-Purchase Territory','AAO'=>'AAO-Responsibilities','AAP'=>'AAP-Supplier Description','AAQ'=>'AAQ-Education Description',
									  'AAR'=>'AAR-Liquidity Details','AAS'=>'AAS-Former Activity Description','AAT'=>'AAT-Division Description','ABN'=>'ABN-Abbreviated Nomenclature',
									  'ACC'=>'ACC-Access InstructionsInstructions or arrangements made with the customer on how to gain access to the customer\ns premises to work on a service request',
									  'ACI'=>'ACI-Additional Claim Information','ACN'=>'ACN-Action Taken','ACS'=>'ACS-Actual Solution','ACT'=>'ACT-Action','ADD'=>'ADD-Additional Information',
									  'AES'=>'AES-Actual Evaluation Summary','AET'=>'AET-Adverse Event Terms','AFA'=>'AFA-Description','AFB'=>'AFB-Generic Chemical Name','AFC'=>'AFC-Prevention Program Description',
									  'AFD'=>'AFD-Risk Management Plan Description','AFE'=>'AFE-Safety Comments','AFF'=>'AFF-Summary','ALG'=>'ALG-Allergies','ALL'=>'ALL-All Documents','ALT'=>'ALT-Alerts',
									  'AMN'=>'AMN-Additional Manufacturer Narrative','AOO'=>'AOO-Area of Operation','APN'=>'APN-Application Notes','APS'=>'APS-Appropriation Specifications-Multiformatted data that describes government accounting classification information used to process the payment information for services provided to the Government',
									  'BBD'=>'BBD-Bank Description','BBF'=>'BBF-Business Founder','BBH'=>'BBH-Business History','BBN'=>'BBN-Banking Notes','BBO'=>'BBO-Business Origin Description','BBT'=>'BBT-Brand Names','BFD'=>'BFD-Business Financing Details','BOL'=>'BOL-Bill of Lading Note','BUR'=>'BUR-Bureau Remarks',
									  'CAA'=>'CAA-Authentication Information','CAB'=>'CAB-Line of In-State Business','CAC'=>'CAC-Relationship Information','CAD'=>'CAD-Basis for Amount Due','CAE'=>'CAE-Type of Debt','CAF'=>'CAF-Land Use Purpose',
									  'CAG'=>'CAG-Land Description','CAH'=>'CAH-Basis of Calculation','CAI'=>'CAI-General Business Description','CAJ'=>'CAJ-Type of Business','CAK'=>'CAK-Character of Business',
		 							  'CAL'=>'CAL-Representation of Value','CAM'=>'CAM-Supporting Statement, Tax, and Fee Computation','CAN'=>'CAN-Cooperative Corporation Statement','CAO'=>'CAO-Close Corporation Statement','CAP'=>'CAP-Agreement to Abide by Laws',
		 							  'CAQ'=>'CAQ-Stock Restrictions','CAR'=>'CAR-Other Related Information','CAS'=>'CAS-Prohibition Against Being an Officer','CAT'=>'CAT-Qualification of Director','CAU'=>'CAU-Nature of Charter',
		 							  'CAV'=>'CAV-Statement of Assets and Liabilities','CAW'=>'CAW-Bankruptcy Information','CAX'=>'CAX-Certificate of Disclosure','CAZ'=>'CAZ-Asset Detail','CBA'=>'CBA-Statement Related to Regulation',
		 							  'CBB'=>'CBB-Consideration to be Received','CBC'=>'CBC-Other Lawful Provisions','CBH'=>'CBH-Monetary Amount Description','CBI'=>'CBI-Description of Title','CCA'=>'CCA-Competition',
		 							  'CCB'=>'CCB-Construction Details','CCC'=>'CCC-Construction Financing','CCD'=>'CCD-Construction Line of Business','CCE'=>'CCE-Contract Details','CCF'=>'CCF-Corporate Filing Details',
		 							  'CCG'=>'CCG-Customer Description','CCH'=>'CCH-Contract Details','CCN'=>'CCN-Copyright Notice','CDD'=>'CDD-Contingent Debt Details','CER'=>'CER-Certification Narrative',
		 							  'CFP'=>'CFP-Call for Appointment','CHG'=>'CHG-Change','CIG'=>'CIG-Cigarette Information','CIR'=>'CIR-Circumstances Prior to Difficulty','CLN'=>'CLN-Classifying Information',
		 							  'CLR'=>'CLR-Security Clearance Instructions','CMP'=>'CMP-Concomitant Medical Product Description','CMT'=>'CMT-Maintenance Comment','COD'=>'COD-Corrected Data',
		 							  'COM'=>'COM-Consumer Comments','CON'=>'CON-Conviction Act Details','CRA'=>'CRA-Credit Report Alerts','CRK'=>'CRK-Closing Comment','CRN'=>'CRN-Credit Report Notes',
		 						      'CUS'=>'CUS-Customs declaration','DCP'=>'DCP-Goals, Rehabilitation Potential, or Discharge Plans','DCS'=>'DCS-Destination Control Statement','DDC'=>'DDC-Deficiency Description Changes','DEE'=>'DEE-Event Description',
									  'DEL'=>'DEL-Delivery','DEP'=>'DEP-Problem Description','DFR'=>'DFR-Dose, Frequency and Route Description','DFS'=>'DFS-Departure from Specification Comment','DGN'=>'DGN-Diagnosis Description-Verbal description of the condition involved',
		 							  'DME'=>'DME-Durable Medical Equipment (DME) and Supplies','DOD'=>'DOD-Description of Damage','DOI'=>'DOI-Outcome Description','DRV'=>'DRV-Driver Out of Service Notice','DRW'=>'DRW-Driver Out of Service Resolution',
		 							  'DSW'=>'DSW-Detailed Statement of Work','EAA'=>'EAA-Other Type of Group','EAB'=>'EAB-Ballot Measure','EAC'=>'EAC-Attachment','EAD'=>'EAD-Board','EAE'=>'EAE-Prohibited Contribution Circumstance',
		 							  'EAF'=>'EAF-Committee Activity','EAG'=>'EAG-Compensation Arrangement','EAH'=>'EAH-Country Sub-Entity','EAI'=>'EAI-Faction','EAJ'=>'EAJ-Gift','EAK'=>'EAK-In-Kind Contribution Use','EAL'=>'EAL-Industry Group',
		);
//Service provider Categories list-pooja
$config['service_provider_category']=array('blood'=>'Blood Bank','equipments/assests purchase'=>'Equipments/ Assets Purcahse','lab'=>'Laboratory','implant'=>'Implant','pharmacy'=>'Pharmacy','radiology'=>'Radiology','rent hospital/pathology/etc'=>'Rent Hospital/Pathalogy/Etc','other professional & repair & maintanence'=>'Other Professional & Repair & Maintanence','others'=>'Others');
//Karnofsky Score-Mahalaxmi
$config['karnofsky_score']=array('empty'=>__('Please Select'),'100'=>'100-Normal no complaints; no evidence of disease','90'=>'90-Able to carry on normal activity; minor signs or symptoms of disease','80'=>'80-Normal activity with effort; some signs or symptoms of disease',
								'70'=>'70-Cares for self; unable to carry on normal activity or to do active work','60'=>'60-Requires occasional assistance, but is able to care for most of his personal needs','50'=>'50-Requires considerable assistance and frequent medical care',
								'40'=>'40-Disabled; requires special care and assistance','30'=>'30-Severely disabled; hospital admission is indicated although death not imminent','20'=>'20	Very sick; hospital admission necessary; active supportive treatment necessary','10'=>'10-Moribund; fatal processes progressing rapidly');
$config['adv_directive_types']=array('empty'=>__('Please Select'),'ANTIBIOTICS'=>'Antibiotics','CPR'=>'CPR','INTUBATION'=>'Intubation','IV_FLUID_AND_SUPPORT'=>'IV Fluid And Support','LIFE_SUPPORT'=>'Life Support',
									 'NOT_APPLICABLE'=>'Not Applicable','RESUSCITATION'=>'Resuscitation','TUBE_FEEDINGS'=>'Tube Feedings');

$config['login_attempt_timezone'] = 'Asia/Kolkata' ;
$config['mailHost']='10.113.17.96';
$config['mailPort']='25';
$config['auditModel'] = array('Patient'=>'Patient', 'Person'=>'Person','Diagnosis'=>'Diagnosis','PatientNote'=>'Patient Note',
		'RadiologyTestOrder'=>'Radiology Orders' ,'Note'=>'Progress Note',
		'NewCropAllergies'=>'Allergies','NewCropPrescription'=>'Medication', 'NoteDiagnosis'=>'Problems', 
		'ClinicalSupport'=>'Patient Education','LaboratoryToken'=>'Laboratory Order') ;
		
$config['occupation'] = array('Administrative & Secretarial'=> 'Administrative & Secretarial',
								'Associate Professional & Technical'=> 'Associate Professional & Technical',
								'Disabled'=>'Disabled',
								'Elementary Occupations'=> 'Elementary Occupations',
								'Managers & Senior Officials'=> 'Managers & Senior Officials',
								'Other'=>'Other',
								'Personal Service Occupations'=> 'Personal Service Occupations',
								'Process, Plant & Machine Operatives'=> 'Process, Plant & Machine Operatives',
								'Professional Occupations'=> 'Professional Occupations',
								'Retired'=>'Retired',
								'Sales & Customer Service Occupations'=> 'Sales & Customer Service Occupations',
								'Self Employed'=>'Self Employed',
								'Skilled Trades Occupations'=> 'Skilled Trades Occupations');
//X number for unusaul reports in pcmh1 more than x report-- Pooja
$config['x_number']='2';

$config['reminders']= array("cancer"=>"Cervical cancer screening ","smoking"=>"Smoking","influenza"=>"Influenza vaccination ","diabetes"=>"Diabetes","highbp"=>"High Blood Pressure",
		"depression"=>"Depression");
//drop down options for organ systems in templates
$config['system_organ']= array(''=>'Please Select','General Multi-System Examination'=>'General Multi-System Examination','Cardiovascular'=>'Cardiovascular','Ears, Nose, Mouth, and Throat'=>'Ears, Nose, Mouth, and Throat','Eyes'=>'Eyes','Genitourinary (Female)'=>'Genitourinary (Female)','Genitourinary (Male)'=>'Genitourinary (Male)','Hematologic/Lymphatic/Immunologic'=>'Hematologic/Lymphatic/Immunologic','Musculoskeletal'=>'Musculoskeletal','Neurological'=>'Neurological','Psychiatric'=>'Psychiatric','Respiratory'=>'Respiratory','Skin'=>'Skin');

//Mail function standard settings for direct mails
$config['SMTPAuth']= 'true';
$config['Host']='directo.mdemail.md';
$config['Port']='465';
$config['SMTPSecure']='ssl';
$config['SMTPDebug']='0';
$config['Debugoutput']='html';
$config['Username']='direct@direct.drmhope.com';
$config['Password']='drm2628';


// mail finction standard for patient credentials and forgot password

$config['mailFrom']='info@drmhope.com';

$config['pharmacyPurchase']='Pharmacy' ;
$config['consultantLabel']='Consultant Fees' ;
$config['laboratoryLabel']='Laboratories Expenses' ;
$config['radiologyLabel']='Radiology Expenses' ;
$config['MRI'] = 'MRI';
$config['CT'] = 'CT';
$config['Implant'] = 'Implant';
$config['SECR']='SEC Railway';
$config['FCI']='FCI';
$config['MPKAY']='MPKAY';
$config['BHEL']='BHEL';
$config['CGHS']='CGHS';
$config['ECHS']='ECHS';
$config['BSNL']='BSNL';
$config['Raymonds']='Raymonds';
$config['Mahindra']='Mahindra & Mahindra';
$config['ServiceProvider']='ServiceProvider';
$config['Consultant']='Consultant';
$config['RGJAY']='R.G.J.A.Y'; 
$config['RGJAYToday']='RGJAY (Private as on today)';
$config['InventorySupplier']='InventorySupplier';
$config['ProductPurchase']='Product';
$config['User']='User';
$config['date_format_calender']='dd/mm/yy';
$config['storeLocations'] = array('Pharmacy'=>'Pharmacy','Central Store'=>'Central Store','OT'=>'OT','CSSD'=>'CSSD','House Keeping'=>'House Keeping',
		'Cardiology'=>'Cardiology');


/****For Lab Master******/////
$config['lab_type']=array('1'=>'Regular','2'=>'Histopathology','3'=>'Culture & sensitivity');
//$config['histopathology_data']=array('1'=>'Accession Number','2'=>'Non-Gyn Cytology Report','3'=>'Diagnosis','4'=>'Clinical History','5'=>'Specimen(s) Source','6'=>'Specimen Adequacy','7'=>'Microscopic Description');
$config['histopathology_data']=array('1'=>'Gross','2'=>'Microscopy','3'=>'Impression','4'=>'Specimen','5'=>'Clinical','6'=>'Immunohistochemical','7'=>'Note/Comment','8'=>'Lab Notes');	//added 4,5,6,7 & 8 for histology result by swapnil 20/11/14
$config['regular_data']=array('1'=>'Sodium','2'=>'Potassium','3'=>'Chloride','4'=>'Carbon Dioxide Lvl','5'=>'Creatinine','6'=>'BUN','7'=>'Glucose Lvl','8'=>'AST','9'=>'ALT','10'=>'Alkaline Phosphatase','11'=>'Total Protein','12'=>'Albumin Lvl','13'=>'Calcium Lvl','14'=>'GFR Non AfroAmerican','15'=>'GFR AfroAmerican');

/****For Lab Master******/////


//for online registration create config all database type they need by amit jain
$config['online_reg'] = array('datasource'=> 'Database/Mysql',
		'persistent'=> false, 
		'host'=> 'localhost',
		'login'=> 'root',
		'password'=>'password',
		'database'=> 'db_hope',
		'port' => '3308',); 
	 
/** array for location types */
$config['stockRule'] = array('NON'=>'No stock Allowed','NTA'=>'No Track/With Accounting','NTK'=>'No Track/No Accounting','TRK'=>'Track Stock');
$config['reStockRule'] = array('ISS'=>'Issue Replacement','NA'=>'Not Applicable','NON'=>'Never Restock','ORD'=>'Order','PAR'=>'Min/Max/Target','REQ'=>'Replacement Requisition');
$config['transientAssignmentRule'] = array('NON'=>'Disallow Transient Assignments','TRN'=>'Allow Transient Assignments');
$config['productAssignmentRule'] = array('MLT'=>'Multiple Product','SNG'=>'Single Product Assignments');
$config['inventoryType'] = array('AST'=>'Asset Inventory','CON'=>'Consignment Inventory','EXP'=>'Expensed Inventory','MIX'=>"Mixed, Surgical Cart only");
$config['consignmentType'] = array('BLO'=>'Bill Only','BNR'=>'Bill and Replace','N/A'=>'Non Consignment','NON'=>'Do Not Order');
 
///BOF-SMS Mgment-Mahalaxmi
/*$config['sender_id'] = 'DrHope';
$config['user_name'] = 'drmone';
$config['pwd'] ='747095';
$config['url'] = 'http://login.smsgatewayhub.com/smsapi/pushsms.aspx';
$config['hosp_details'] = 'Hope hospitals (Call 08412030400 for details).';*/

//$config['owner_no'] ='8087235965'; //9373111709----Dr. Murali Sir
//$config['administrator_no'] ='8087235965'; //9850341544 ---Administrator-Shrikant


///EOF-SMS Mgment

//Billing and services configuration
$config['privateTariffId'] = '7' ; //temp set to 4 as per local db configuration.
$config['privateTariffName'] = 'private' ; //temp set to 4 as per local db configuration. 

$config['rgjay_private_as_on_today'] = 'RGJAY (Private as on today)' ; //temp set to 4 as per local db configuration.
$config['rgjay'] = 'R.G.J.A.Y' ; //temp set to 4 as per local db configuration.


$config['OPCheckUpOptions'] = array('consultation'=>'consultation','followup'=>'followup','RegistrationCharges'=>'RegistrationCharges');
$config['followupDuration'] = '30' ; //in days 
//for patient controller (registration function) by amit jain
$config['RegistrationCharges']='RegistrationCharges';
$config['RegistrationChargesIPD']='RegistrationChargesIPD';
$config['mandatoryservices'] = 'mandatoryservices' ;
$config['Consultation'] = 'Consultation' ;
$config['clinicalservices'] = 'Clinical Services' ;
$config['laboratoryservices'] = 'Laboratory' ;
$config['radiologyservices'] = 'Radiology' ;
$config['surgeryservices'] = 'Surgery' ;
$config['anesthesiaservices'] = 'Anaesthesia';
$config['implantsservices'] = 'Implants' ;
$config['bloodservices'] = 'Blood' ;
$config['pharmacyservices'] = 'Pharmacy' ;
$config['wardprocedure'] = 'Ward' ;
$config['otservices'] = 'OT Services' ;
$config['otpharmacyservices'] = 'OT Pharmacy' ;
//for getting dr. and nursing charge in billing RegistrationCharges
$config['RegistrationCharges'] = 'RegistrationCharges' ;
$config['DoctorsCharges'] = 'DoctorsCharges' ;
$config['NursingCharges'] = 'NursingCharges' ;
$config['advance'] = 'advance' ;
$config['otherServices'] = 'Other Services' ;//
$config['radiotheraphyServices'] = 'Radiotheraphy' ;
$config['miscChargesGroup'] = 'misc charges' ;
$config['histopathologyGroup'] = 'Histopathology' ;
$config['roomtariffGroup'] = 'RoomTariff' ;

$config['Sponsor'] = array('cash'=>'Self Pay','Corporate'=>'Corporate','Insurance company'=>'Insurance company','TPA'=>'TPA');
$config['SponsorValue'] = array('cash'=>'Self Pay','Corporate'=>'1','Insurance company'=>'1','TPA'=>'2');

// for Pharmacy store requisition
$config['Pharmacy']='Pharmacy';
$config['otpharmacy']='OTPharmacy';
// For Kanpur 

$config['RadConfig']= array("282"=>"X - RAY LUMBO-SACRAL","286"=>"MRI OF LUMBO-SACRAL","284"=>"THORASIC","285"=>"CERVICAL SPINE AP AND LAT","287"=>"CERVICAL SPINE");

$config['LabConfig']= array('251'=>'S.URIC ACID','252'=>'CRP','20'=>'CBC','253'=>'RA FACTOR');

$config['regValidity']='6'; // 6 month validity for registration charges 
$config['mandatoryServices']='mandatoryservices';

//BOF-Mahalaxmi name of vaccination***///
$config['vaccination_data']=array('0'=>'HBV(Birth,1-2 months and 6-18 months )','1'=>'DTaP(2,4,6,15-18 months and 4-6 years)','2'=>'Hib(2,4,6 Months and 12-15 months)','3'=>'IPV(2,4,6,6-18 months and 4-6 years)','4'=>'PCV(2,4,6 Months and 12-15 months)','5'=>'Rota(2,4 and 6 Months)','6'=>'Influenza(6 months,annually and Special circumstances)','7'=>'MMR(12-15 and 4-6 years)','8'=>'Chickenpox (varicella)(12-15 months)','9'=>'HAV(12-23 months and Special circumstances)','10'=>'Varicella(4-6 years)','11'=>'HPV(11-12 years)','12'=>'Tdap(11-12 years)','13'=>'Meningococcal vaccine(11-12 years,College entrants and Special circumstances)','14'=>'Pneumococcal vaccines(Special circumstances)');
//EOF-Mahalaxmi name of vaccination***///

$config['centralStore']='Central Store';

//Amount to be added on advance billing to the balance amount to get amt to be paid today-Pooja
$config['advanceAmtAdd']='20000';

//call Patient for surgery-Mahalaxmi
$config['before_days_surgery']=' -2 days';///before 2 days 

//No of appointments for 1 day-Leena
$config['max_appointments']='30' ;

// for by default selected doctor-Atul
$config['default_doctor_selected']='0' ;

$config['prefix'] = array('u_id'=>'Unique Id','lab_id'=>'Lab Id','billing_id'=>'Billing Id');

//for accounting ledger - amit
	$config['ct_mri_Label'] = 'CT/MRI Payments';
	$config['blood_purchased_Label'] = 'Blood Purchased';
	$config['pharmacy_sale_Label'] = 'Pharmacy Sale';
	$config['surgeryPaymentLabel']='Ipd Visit Fees Payment' ;//for accounting call surgery account ledger
	$config['bankLabel'] = array('Bank Accounts');
	$config['purchaseOrderLabel']='Purchase Accounts' ;
	$config['owners_capital_account']='Owners Capital A/c';//for cashier payment adjustment(Excess amount will be credit) ledger
	$config['Account Room'] = 'Account Room';
	$config['mri_ct'] = 'MRI & CT SCAN';//radiology sub group
	$config['AccountingGroupName'] = 'Sundry Debtors';//for accounting group
	$config['sundry_debtors']='Sundry Debtors';
	$config['sundry_creditors']='Sundry Creditors';
	$config['cash']='Cash';
	$config['second_company_location_id']='19';//fixed patient location id for 2nd company in voucher entry
	//for two company, it is used for insert comany_id as a location_id in voucher entry for radiology, laboratory, service_category, and service_sub_category
	//for normal accounting change the config value by 0
	//for multiple company by amit jain
	$config['is_accounting_multiple_company']='0';
	//Voucher Type
	$config['voucher_type']=array('1'=>'Staff','2'=>'Consultant','3'=>'Service Provider','4'=>'Vendor');
	$config['cashier_role'] = 'cashier';
	$config['pharmacy_role'] = 'pharmacy';
	$config['frontOffice_role']='Frontoffice';
	$config['cashier_receipt_role'] = 'CashierReceipt';
	$config['cashier_payment_role'] = 'CashierPayment';
	$config['batch_type'] = array('Cashier Batch'=>'Cashier Batch','Payment Adjustment'=>'Payment Adjustment');
	$config['external_consultant_fees'] = '500'; //in accounting fixed amount is 500 for future it shuold be change by here.
	$config['external_consultant_fees_company'] = '150'; //in accounting fixed amount is 150 for future it shuold be change by here.
	$config['medicinesSurgicalPurchaseLabel'] = array('Medicines & Surgical Purchase','Medicines & Surgical Purchase@5%','Medicines & Surgical Purchase@12%',
			'Local Purchase','Local Purchase 5%','Local Purchase 14%','Medicines & Surgical Purchase@5.5%','Medicines & Surgical Purchase@6%','Medicines & Surgical Purchase@13.5%');
	$config['inputVATLabel'] = array('Input VAT @5%','Input VAT @12%','Input VAT 4%','Input VAT 12.5%','Input VAT @5.5%','Input VAT @6%','Input VAT @13.5%');
	$config['inputSATLabel'] = array('Input SAT 1%','Input SAT 1.5%');
	$config['DoctorChargesLabel']='Doctor Charges';
	$config['NursingChargesLabel']='Nursing Charges';
	$config['DiscountAllowedLabel']='Discount Allowed';
	$config['RefferalDoctorLabel']='Misc.hospital Expense';
	$config['SurgeonChargesLabel']='Surgeon Charges';
	$config['AnaesthesiaChargesLabel']='Anaesthesia Charges';
	$config['OTChargesLabel']='OT Charges';
	$config['OTAsstChargesLabel']='OT Assistant Charges';
	$config['OTExtraChargesLabel']='Extra OT Charges';
	$config['startFinancialYear']='-04-01'; // 04 is month and 01 is date
	$config['endFinancialYear']='-03-31'; // 03 is month and 31 is date
	$config['accountManager_role'] = 'AccountManager';
	$config['account_manager'] = 'account manager'; // for session role
	$config['account_assistant'] = 'account assistant'; // for session role
	$config['locationLable'] = 'Drm Hope Hospital Pvt. Ltd';
	$config['TDSreceivable']='TDS Receivable';
	//for kanpur only 
	$config['DoctorFeesLabel']='Professional Fees(OPD) Patients';
	$config['TDSLabel']='TDS payable (94j) 10%';
	$config['LaboratoryTestLabel']='Laboratory Expenses';
	$config['RadiologyTestLabel']='Radiology  Expenses';
	$config['PatientCardLabel']='IPDPC';
	$config['RoundOffLabel'] = 'Round Off';
	$config['IpdReceipts']='Hospital IPD Reciepts';
	$config['LabProviderLabel']='Perfect Scan - Laboratory';
	$config['RadProviderLabel']='Perfect Scan - Radiology';
	$config['DrRkLabel'] = 'Dr R.K.  Singh';
	$config['SurgeonFeesLabel']='Surgeon Fees';
	$config['RomanPharmaLabel']='Roman Pharma';
	$config['MedicineExpensesLabel']='Medicine Expenses';
	/***BOF-Mahalaxmi For Expense And Income Report*/
	$config['acc_expense_group_name']= array("direct expenses"=>"direct expenses","indirect expenses"=>"indirect expenses"); 
	$config['acc_income_group_name']= array("direct incomes"=>"direct incomes","indirect incomes"=>"indirect incomes");
	/***EOF-Mahalaxmi For Expense And Income Report*/
	$config['implantPurchaseLabel']='Implant Purchase';
	$config['allCustomLedgers']=array("Direct Pharmacy Incomes"=>"Direct Pharmacy Incomes");
//EOF accounting

//add purchase order by Swapnil G.Sharma
$config['pharmacyCode'] = "PHAR";
$config['centralStoreCode'] = "CS";
$config['apamCode'] = "APAM";
$config['otCode'] = "OT";
$config['wardCode'] = "WARD";

$config['otpharmacycode'] = "OTPHARMA";
$config['pathology_doctor_authority_name'] = "Dr. Arun Agre";
$config['pathology_doctor_authority_designation'] = "MD (Pathology)";

//$config['pathology_doctor_authority_name'] = "Dr. Naresh Gurbani";
//$config['pathology_doctor_authority_designation'] = "MBBS , MD (Pathology)";

//$config['pathology_doctor_authority_name_sec'] = "Dr. Naresh Gurbani";
//$config['pathology_doctor_authority_designation_sec'] = "MBBS , MD (Pathology)";




$config['pathology_doctor_authority_name_histo'] = "Dr. Yogesh Mistry";
$config['pathology_doctor_authority_designation_histo'] = "MD";
$config['billing_manager_role']='Billing Manager';
$config['RoomTariff']='RoomTariff';

$config['WIDAL']=array('1'=>'1:20','2'=>'1:40','3'=>'1:80','4'=>'1:160','5'=>'1:320');
$config['histo_pathology_lable'] ='histo_pathology'; 
$config['mlEnterprise']='ML Enterprise';
$config['roomtType'] = array('general'=>'General','special'=>'Special','semi_special'=>'Semi Special','delux'=>'Delux','isolation'=>'Isolation') ;
$config['AbnormalFlag']= 'red';
$config['CultureSensitivityGroup']= array('1'=>'OTHER GP','2'=>'NO GROWTH','3'=>'UTIGP','4'=>'UTIGN','5'=>'OTHER GN',
		'6'=>'FUNGAL REPORT','7'=>'UTI PSEUDO','8'=>'OTHER PSEUDO','9'=>'INTER FOCUS ENTEROCOCCUS','10'=>'GRAM STAIN','11'=>'ZN STAIN');
$config['NormalFlag']= 'green';
$config['subspecilaity']= 'blue';
$config['serologyRange']= array('1'=>'Negative','2'=>'Non Reactive'); 
$config['storemanager'] = 'storemanager' ;
$config['OtPharmacy'] = 'OT Pharmacy' ;
$config['CultureReportHeader']=array('STAING REPORT'=>'STAING REPORT','KOH EXAMINATION REPORT'=>'KOH EXAMINATION REPORT','CULTURE & SENSITIVITY REPORT'=>'CULTURE & SENSITIVITY REPORT');
$config['ServiceRecordLimit']=20 ;

$config['onBedStatus'] = array('Enrollment (Pending)'=>'Enrollment (Pending)',
								'Enrollment (Approved)'=>'Enrollment (Approved)',
								'Claim Paid'=>'Claim Paid',
								'Preauth Terminated'=>'Preauth Terminated',
								'Preauth Pending'=>'Preauth Pending', 
								'Registration (Pending)'=>'Registration (Pending)',
								'Registration (Approved)'=>'Registration (Approved)',
								'Pre-authorization (Pending)'=>'Pre-authorization (Pending)',
								'Preauth Updated'=>'Preauth Updated', 
								'Preauth Updated Cancelled'=>'Preauth Updated Cancelled',
								'Pre-authorization (Approved)'=>'Pre-authorization (Approved)',
								'Surgery (Pending)'=>'Surgery (Pending)',
								'Surgery (Done)'=>'Surgery (Done)',
								'Surgery (Update)'=>'Surgery (Update)',
								'Treatment Schedule (Pending)'=>'Treatment Schedule (Pending)',
								'Treatment Schedule (Update)'=>'Treatment Schedule (Update)',
								'Post-Operation Notes (Pending)'=>'Post-Operation Notes (Pending)',
								'Post-Operation Notes (Update)'=>'Post-Operation Notes (Update)',
								'Discharge (Pending)'=>'Discharge (Pending)',
								'Discharge (Update)'=>'Discharge (Update)',
								//'Preauth Approved'=>'Preauth Approved',
								'Sent For Preauthorization'=>'Sent For Preauthorization',
								'Society Approved'=>'Society Approved',
								'Society Cancelled'=>'Society Cancelled',
								'Society Pending'=>'Society Pending',
								'Society Rejected'=>'Society Rejected',
								'Surgery Update'=>'Surgery Update',
								'TPA Approved'=>'TPA Approved',
								'TPA Pending'=>'TPA Pending',
								'Technical Committee Rejected For Enhancement'=>'Technical Committee Rejected For Enhancement',
								'Terminated By Society'=>'Terminated By Society',
								'Terminated By TPA'=>'Terminated By TPA',
								'Treatment Schedule'=>'Treatment Schedule',
								'Cancelled By Society'=>'Cancelled By Society',
								'Cancelled By TPA'=>'Cancelled By TPA'								
							);
								
$config['onDischargeStatus'] = array('CMO Approved(Repudiated)'=>'CMO Approved(Repudiated)',
								'CMO Pending Updated(Repudiated)'=>'CMO Pending Updated(Repudiated)',
								'CMO Pending(Repudiated)'=>'CMO Pending(Repudiated)',
								'CMO Rejected(Repudiated)'=>'CMO Rejected(Repudiated)',
								'Discharged and Payment Pending',
								'Surgery (Pending)'=>'Surgery (Pending)',
								'Surgery (Update)'=>'Surgery (Update)',
								'Discharged and Payment Recevied'=>'Discharged and Payment Recevied',
								'Discharged but bill not made'=>'Discharged but bill not made',
								'Discharged and bill made but file not submitted '=>'Discharged and bill made but file not submitted ',
								'File Submitted'=>'File Submitted',
								'Discharged but bill not Open'=>'Discharged but bill not Open',
								//'Cancelled By Society'=>'Cancelled By Society',
								//'Cancelled By TPA'=>'Cancelled By TPA',
								'Claim Doctor Approved'=>'Claim Doctor Approved',
								'Claim Doctor Pending'=>'Claim Doctor Pending',
								'Claim Doctor Pending Updated'=>'Claim Doctor Pending Updated',
								'Claim Doctor Rejected'=>'Claim Doctor Rejected',
								'Claim Rejected by CMO'=>'Claim Rejected by CMO',
								'Discharge Update'=>'Discharge Update',
								'In Patient Case Registered'=>'In Patient Case Registered', 
								'In Process'=>'In Process preauth',
								//'Preauth Updated'=>'Preauth Updated', 
								'Preauth Updated'=>'Preauth Updated', 
								'Preauth Terminated'=>'Preauth Terminated',
								'Preauth Pending'=>'Preauth Pending', 								
								'Preauth Updated Cancelled'=>'Preauth Updated Cancelled',
								//'Preauth Approved'=>'Preauth Approved',
								'Pre-authorization (Approved)'=>'Pre-authorization (Approved)',
								'Repudiated Claim Appeal Initiated by CCM'=>'Repudiated Claim Appeal Initiated by CCM',
								'Bill Uploaded'=>'Bill Uploaded',
								'Claim Paid'=>'Claim Paid',
								//'Sent For Preauthorization'=>'Sent For Preauthorization',
								//'Society Approved'=>'Society Approved',
								//'Society Cancelled'=>'Society Cancelled',
								//'Society Pending'=>'Society Pending',
								//'Society Rejected'=>'Society Rejected',
								//'Surgery Update'=>'Surgery Update',
								//'TPA Approved'=>'TPA Approved',
								//'TPA Pending'=>'TPA Pending',
								//'Technical Committee Rejected For Enhancement'=>'Technical Committee Rejected For Enhancement',
								//'Terminated By Society'=>'Terminated By Society',
								//'Terminated By TPA'=>'Terminated By TPA',
								//'Treatment Schedule'=>'Treatment Schedule'
							);
$config['ServiceRecordLimit']=20 ;

$config['requisitionTariff'] = array('Private'=>'Private','CGHS'=>'CGHS');
$config['corporate_excess_service']='corporate_excess_service';
 
$config['operationTheaterCharge'] = 'OPERATION THEATER CHARGE' ;
$config['otcharge'] = 'OT CHARGE'; 

$config['WCL']='WCL';
$config['CGHS']='CGHS'; 

//service group 
$config['RGJAY Package']='RGJAY Package';

$config['SuspenseType'] = 'SuspenseAccount';
$config['kapack_image_path'] = "E:\kpacks"; 
//flag to show cghs name on invoice for cghs patients -- Pooja
$config['show_cghs_name']='1';


//BOF -Mahalaxmi For Bank Details
//find to SBI Alias name
$config['SBIAlias']='state bank of india';
$config['serviceProviderUser']='ServiceProvider'; 
$config['consultantUser']='Consultant'; 
$config['inventorySupplierUser']='InventorySupplier'; 
$config['UserType']='User'; 
$config['AccountType']='Account'; 
//EOF -Mahalaxmi For Bank Details

//BOF-Mahalaxmi for OT Assistant
$config['OTAssistantLabel']='OT Assistant'; 

$config['blood_group']= array("A+"=>"A+","A-"=>"A-","B+"=>"B+","B-"=>"B-","AB+"=>"AB+","AB-"=>"AB-","O+"=>"O+","O-"=>"O-");
$config['singlePay']='0';
/*for hub_patient from  open link only*/
$config['hub_link']=array("new_patient_hub","multiplePaymentModeIpd","discharge_summary","addNurseMedication","addNurseServices","clinicalNote");

//BOF-Mahalaxmi for TPA Type
$config['tariffstandardcredit'] = "TPA";
//EOF-Mahalaxmi for TPA Type

//BOF-Mahalaxmi for Implant
$config['implantname'] = "Implant";
//EOF-Mahalaxmi for Implant
$config['Senior_RGJAY'] = 'Senior RGJAY' ;
$config['apply_discount']='1';//flag to apply default discount -- pooja

$config['intraOpPhoto']='1';
$config['onBedPhoto']='2';
$config['onDischargePhoto']='3';
$config['clinicalPhoto']='4';
$config['dischargeOnBed']='5';
$config['scarPhoto']='6';
$config['preSurgery']='7';
$config['postSurgery']='8';
$config['aadharCard']='9';
$config['panCard']='10';
$config['rationCard']='11';
$config['treatmentSheet']='12';
$config['programNote']='13';
$config['investigation']='14';
$config['otNotes']='15';
$config['anaesthesiaNotes']='16';
$config['deathClinicalPhoto']='17';
$config['deathCertificate']='18';
$config['deathSummary']='19';
$config['formFour']='20';
$config['ayushmanCard']='21';
$config['dischargeSummary']='22';
$config['justificationLetter']='23';
$config['transportation']='24';
$config['satisfacoryLetter']='25';

$config['lab_histo_template_sub_groups'] = array('1'=>'Surgical Pathology','2'=>'FNAC','3'=>'FS','4'=>'Cytology','5'=>'PAP','6'=>'BM');
$config['corporateStatus']= array('1'=>'General','2'=>'Shared','3'=>'Special');

//BOF-Mahalaxmi for Profit/Loss Report
$config['group_type']= array('0'=>'Expense','1'=>'Income');
$config['indirect_income_label']= 'Indirect Incomes';
$config['income_label']= 'Income';
$config['indirect_expenses_label']= 'Indirect Expenses';
$config['expense_label']= 'Expense';
$config['profit_loss_statement']= 'profitLossStatement';
//EOF-Mahalaxmi for Profit/Loss Report

//PatientDocument-Mahalaxmi
$config['service_provider_hope']='Hope Hospitals';
$config['external_radiology_user_ids']= array('234','235','236','382');
$config['service_providers']= array('Hope Hospitals','Neerja Tiwari');
$config['radiologyUser']='Neerja Tiwari';
//for  hr

$config['graceLeave'] = '2';
$config['perDayDeduction'] = '1/4';
$config['salaryStatement'] = array('1'=>'Bank Statement','2'=>'Cash Statement');

$config['payrollFromDate'] = "26";
$config['payrollToDate'] = "25";

$config['medication_time'] = array('1'=>'1am','2'=>'2am','3'=>'3am','4'=>'4am','5'=>'5am','6'=>'6am','7'=>'7am','8'=>'8am','9'=>'9am','10'=>'10am','11'=>'11am','12'=>'12am','13'=>'1pm','14'=>'2pm','15'=>'3pm','16'=>'4pm','17'=>'5pm','18'=>'6pm','19'=>'7pm','20'=>'8pm','21'=>'9pm','22'=>'10pm','23'=>'11pm','24'=>'12pm');
/*$config['medication_time'] = array('1am'=>'1am','2am'=>'2am','3am'=>'3am','4am'=>'4am','5am'=>'5am','6am'=>'6am','7am'=>'7am','8am'=>'8am','9am'=>'9am','10am'=>'10am','11am'=>'11am','12am'=>'12am','1pm'=>'1pm','2pm'=>'2pm','3pm'=>'3pm','4pm'=>'4pm','5pm'=>'5pm','6pm'=>'6pm','7pm'=>'7pm','8pm'=>'8pm','9pm'=>'9pm','10pm'=>'10pm','11pm'=>'11pm','12pm'=>'12pm');*/
//$config['hrCodeFormat']="HH/HRM/";
$config['nurseAssistantLabel'] = 'Nursing Assistant' ;
$config['management_role'] = 'Management';

$config['bill_submit_status'] = 'Bill Submitted';
$config['opening_date'] = "2016-09-20 00:00:00";
$config['bill_submit_status'] = 'Bill Submitted';
$config['allVat'] = array('5'=>'5','5.5'=>'5.5','6'=>'6','12'=>'12','12.5'=>'12.5','13.5'=>'13.5',);

$config['covidpackage'] = array('4000'=>'4000','7500'=>'7500','9000'=>'9000');
$config['administration_time'] = array('BREAKFAST TIME'=>'BREAKFAST TIME','LUNCH TIME'=>'LUNCH TIME','HS'=>'HS','SOS'=>'SOS');
$config['mah_police_investigation'] = array('Haemogram'=>'Haemogram',
											'Thyroid Profile'=>'Thyroid Profile',
											'Vit. B12 Test'=>'Vit. B12 Test',
											'Vit D3 Test'=>'Vit D3 Test',
											'Urine Examination'=>'Urine Examination',
											'Stool Routine'=>'Stool Routine',
											'Blood Sugar Tests'=>'Blood Sugar Tests',
											'Lipid Profile'=>'Lipid Profile',
											'Liver Function Tests'=>'Liver Function Tests',
											'Kidney Function Tests'=>'Kidney Function Tests',
											'Cancer Screening - A) For Men 1. PSA (Prostate Specific Antigen Test) 2. LDH (Lactic Acid Dehydrogenase Test) B) For Women 1. PAP Smear (Papanicolaou Test)' =>'Cancer Screening - A) For Men 1. PSA (Prostate Specific Antigen Test) 2. LDH (Lactic Acid Dehydrogenase Test) B) For Women 1. PAP Smear (Papanicolaou Test)',
											'X-Ray - Chest PA View Report, 2D ECHO'=>'X-Ray - Chest PA View Report, 2D ECHO',
											'ECG Report'=>'ECG Report',
											'2D Echo'=>'2D Echo',
											'USG Abdomen with Pelvis'=>'USG Abdomen with Pelvis',
											'Mammography Report (Women)'=>'Mammography Report (Women)',
											'Gynecological Health Check-Up (Women)'=>'Gynecological Health Check-Up (Women)',
											'Urological Examination'=>'Urological Examination',
											'Rectal Examination'=>'Rectal Examination',
											'Systemic Examination'=>'Systemic Examination',
											'Eye Examination'=>'Eye Examination',
											'ENT Examination'=>'ENT Examination',
											'Dental Examination'=>'Dental Examination',
											'Haemoglobin Level, Blood Sugar level/HBA1C Level, Cholesterol Level, Liver Functioning, Kidney Status, Cardiac Status'=>'Haemoglobin Level, Blood Sugar level/HBA1C Level, Cholesterol Level, Liver Functioning, Kidney Status, Cardiac Status',
											'BMI (Body Mass Index)'=>'BMI (Body Mass Index)'
											);


//for balance sheet Report
$config['balancesheet_group_type']= array('0'=>'Liability','1'=>'Asset');
$config['asset_label']= 'Asset';
$config['liability_label']= 'Liability';
$config['balance_sheet_statement']= 'balanceSheet';
//for balance sheet Report