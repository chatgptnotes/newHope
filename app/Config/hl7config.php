<?php
$config['hl7_admission_type']= array('A'=>'Accident','C'=>'Elective','E'=>'Emergency','L'=>'Labor and Delivery','N'=>'Newborn','R'=>'Routine','U'=>'Urgent');
$config['hl7_new_order'] = 'NW';
$config['ADM_OUTBOUND'] = 'ADM';
/*** HL7 Fields */
$config['sending_application_name'] = 'DHR';
$config['sending_facility_name'] = 'DHR';
$config['sending_application_oid_number'] = '2.16.840.1.113883.9.152';
$config['sending_facility_oid_number'] = '2.16.840.1.113883.9.152';
$config['sending_application_universal_id_type'] = 'ISO';
$config['sending_facility_name_type_code'] = 'L';
$config['assigning_authority_namespace_id'] = 'DHR';
$config['assigning_authority_universal_id'] = '2.16.840.1.113883.3.987.1';
$config['sft_identifier_type_code'] = 'XX';
$config['sft_organization_identifier'] = 'DHR';
$config['sft_version_id'] = '1.0';
$config['sft_product_name'] = 'DHR Lab Systems';
$config['sft_product_binary_id'] = 'DHR-1.0';
$config['sft_product_install_date'] = '20140430';
$config['hl7_inbound_adt_identifier'] = 'GFM';
$config['pid_assigning_authority_namespace_id'] = 'DHR';
$config['pid_assigning_authority_universal_id'] = '2.16.840.1.113883.3.72.5.30.2';
$config['pid_assigning_facility_namespace_id'] = 'DHR';
$config['pid_assigning_facility_universal_id'] = '2.16.840.1.113883.3.72.5.30.2';
$config['ethinicity']=array('2135-2:Hispanic or Latino'=>'Hispanic or Latino','2186-5:Not Hispanic or Latino'=>'Not Hispanic or Latino','UnKnown'=>'UnKnown','Denied to Specific'=>'Declined to specify');
$config['hl7_outbound_orm_patient_class'] = 'O';
$config['relationship_with_insured_index'] = array('18'=>'01','01'=>'02','19'=>'03','43'=>'04','17'=>'05','10'=>'06','15'=>'07','20'=>'08','21'=>'09','22'=>'10','39'=>'11','40'=>'12','05'=>'13','07'=>14,'41'=>'15','23'=>'16','24'=>'17','04'=>'19','53'=>'20','29'=>'29','32'=>'32','33'=>'33','36'=>'36','G8'=>'55');
/*** HL7 Fields */

//Newcrop fields

$config['partnername']="DrMHope";
$config['uname']="demo";//8bd78b65-22c9-4dc3-9cb6-408f160827fb  - --- For live/production environment || demo --- For test
$config['passw']="demo";//e91c2923-8242-49df-8aaf-d864c9b90d46  - --- For live/production environment || demo --- For test
$config['SOAPUrl']="http://preproduction.newcropaccounts.com/v7/WebServices/Update1.asmx";//http://secure.newcropaccounts.com//v7/WebServices/Update1.asmx  --- For live/production environment ||http://preproduction.newcropaccounts.com/v7/WebServices/Update1.asmx -  For test
$config['hitUrl']="https://preproduction.newcropaccounts.com/InterfaceV7/RxEntry.aspx";//https://secure.newcropaccounts.com/InterfaceV7/RxEntry.aspx  ---  For live/production environment ||https://preproduction.newcropaccounts.com/InterfaceV7/RxEntry.aspx -  For test
$config['newCropUrl']="http://preproduction.newcropaccounts.com/";//http://secure.newcropaccounts.com/  ---  For live/production environment ||http://preproduction.newcropaccounts.com/ -  For test
$config['newCropDrugUrl']="http://preproduction.newcropaccounts.com/v7/WebServices/Drug.asmx";//http://secure.newcropaccounts.com/v7/WebServices/Drug.asmx  ---  For live/production environment ||http://preproduction.newcropaccounts.com/v7/WebServices/Drug.asmx -  For test
$config['formularyUrl']="http://preproduction.newcropaccounts.com/v7/WebServices/Formulary.asmx";//http://secure.newcropaccounts.com/v7/WebServices/Formulary.asmx  ---  For live/production environment ||http://preproduction.newcropaccounts.com/v7/WebServices/Formulary.asmx -  For test

$config['FormularyStatus']= array("10"=>"Unlisted Drug","15"=>"Not Reimbursed","20"=>"Non Formulary","30"=>"Prior Authorization ","50"=>"On Formulary","51"=>"Preferred Level 1","52"=>"Preferred Level 2","53"=>"Preferred Level 3","54"=>"Preferred Level 4","55"=>"Preferred Level 5","56"=>"Preferred Level 6","57"=>"Preferred Level 7","58"=>"Preferred Level 8","59"=>"Preferred Level 9","60"=>"Preferred Level 10","61"=>"Preferred Level 11","62"=>"Preferred Level 12","63"=>"Preferred Level 13","64"=>"Preferred Level 14",
		"65"=>"Preferred Level 15","66"=>"Preferred Level 16","67"=>"Preferred Level 17","68"=>"Preferred Level 18","69"=>"Preferred Level 19","70"=>"Preferred Level 20","71"=>"Preferred Level 21","72"=>"Preferred Level 22","73"=>"Preferred Level 23","74"=>"Preferred Level 24","75"=>"Preferred Level 25","76"=>"Preferred Level 26","77"=>"Preferred Level 27","78"=>"Preferred Level 28","79"=>"Preferred Level 29","80"=>"Preferred Level 30","81"=>"Preferred Level 31","82"=>"Preferred Level 32","83"=>"Preferred Level 33","84"=>"Preferred Level 34","85"=>"Preferred Level 35","86"=>"Preferred Level 36","87"=>"Preferred Level 37","88"=>"Preferred Level 38","89"=>"Preferred Level 39","90"=>"Preferred Level 40","91"=>"Preferred Level 41",
		"92"=>"Preferred Level 42","93"=>"Preferred Level 43","94"=>"Preferred Level 44","95"=>"Preferred Level 45","96"=>"Preferred Level 46","97"=>"Preferred Level 47","98"=>"Preferred Level 48","99"=>"Preferred Level 49"); // this is dosage form not strength


$config['FormularyStatusDesc']= array("10"=>"","15"=>"The plan does not pay for this drug. The individual will need to pay for it if desired.","20"=>"Specified by the plan as not on the formulary or on the formulary at a higher co-pay level. This may or may not be reimbursable.","30"=>"Reimbursement will be allowed only when the claim has been submitted to plan officials by a physician for review prior to the issuance of a prescription.","50"=>"Authorized for reimbursement","51"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","52"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","53"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","54"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","55"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","56"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","57"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","58"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","59"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","60"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","61"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","62"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","63"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.",
"64"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","65"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","66"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","67"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","68"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","69"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","70"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","71"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","72"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","73"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","74"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","75"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","76"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","77"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","78"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","79"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","80"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","81"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","82"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","83"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","84"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","85"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","86"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","87"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","88"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","89"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","90"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","91"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.",
		"92"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","93"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","94"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","95"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","96"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","97"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","98"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug.","99"=>"Favored over all other drugs in the same therapeutic category. The higher the Level, the more preferred the drug."); // this is dosage form not strength




########################################################################################################################
/***************************************** DRM HOPE INDIAN VERSION CHANGES START **************************************/
########################################################################################################################

$config['lab_machine_list'] = array("SYSMEX"=>'SYSMEX','EM200'=>'EM200');
//for tally url by amit jain

//$config['tally_url']="http://117.247.82.227:9002"; //for server
//$config['tally_url']="http://localhost:9002";//for local 

$config['tally_url']="http://192.168.1.159:9002";

$config['appletUrl']="http://192.168.1.5:5454/hope";


//doctor/prescriber default details
$config['primaryPhoneNumber']="9923555053";
$config['primaryFaxNumber']="9563972140";
$config['doctor_addr1']="51 Dhantoli Nagpur.";
$config['doctor_addr2']="";
$config['doctor_state']="19";
$config['doctor_city']="Nagpur";
$config['doctor_zip']="440012";
$config['doctor_primary_phone']="0712-2420869";
$config['doctor_primary_fax']="9923742078";

// added for to send  clearance notification to following roles-Atul
$config['staff'] = array('Pharmacy Manager'=>'Pharmacy Manager','Lab Manager'=>'Lab Manager','Radiology Manager'=>'Radiology Manager','Front Office Executive'=>'Front Office Executive','Nurse'=>'Nurse');
// roles config variable-Atul
$config['pharmacyManager']="Pharmacy Manager";
$config['labManager']="Lab Manager";
$config['radManager']="Radiology Manager";

// for radiotherapy visit type-kanpur instance--by atul
$config['radiotherapy']="1956";
$config['radiotherapyOpd']="1969";

//OPD to IPD change location-Leena
$config['location_id']="22";
$config['location_name']="Globus Hospital";

//for pacs one login
$config['pacsusername']="radiologistone";
$config['pacspassword']="Hope123@!";



//for kanpur only
$config['otExtraServices'] = array('C-ARM Charge'=>'carm_charge','Cautery Charges'=>'cautery_charge','Monitoring Charges'=>'monitoring_charge','Nitrous Gas Charges'=>'nitrous_charge','Oxyzen Charges'=>'oxygen_charge');











