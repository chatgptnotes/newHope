<?php
/**
 * Hl7Message Model file
 *
 * PHP 5.4.3
 *
 * @copyright     Copyright 2013 Drmhope Softwares  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Hope
 * @since         CakePHP(tm) v 5.4.3
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gaurav Chauriya
 * @comment		  Do Not Change Even Single Variable
 */
class Hl7Message extends AppModel {

	public $name = 'Hl7Message';
	public $useTable = 'hl7_messages';
	public $cacheQueries = false ;


	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
	public function gen_ADT_A04($data = array(),$fun){
		
		$MSH = $this->generateHL7MSH($data['ADT']['curdate'],$fun); 
		$EVN = "\n".$this->generateEVN($data['ADT']['curdate']);
		$PID = "\n".$this->generateHL7PID($data);
		$PV1 = "\n".$this->generatePV1($data['ADT']['curdate'],$data['Person']['patient_uid']);
		$OBX1 = "\n".$this->generateHL7OBX1($data['Person']['phvs_visit_id']);
		$OBX2 = "\n".$this->generateHL7OBX2($data['Person']['age']);
		$OBX3 = "\n".$this->generateHL7OBX3($data['Person']['visit_purpose']);
		if(!empty($data['Person']['phvs_icd9cm_id']))
		$DG1 = "\n".$this->generateHL7DG1($data['Person']['phvs_icd9cm_id']);
		
		return $MSH.$EVN.$PID.$PV1.$OBX1.$OBX2.$OBX3.$DG1;
	}
	
	public function gen_ADT_A03($data = array()){
		$model = ClassRegistry::init('Person');
		$personData = $model->find('first',array('fields'=>array('patient_uid','phvs_icd9cm_id','phvs_visit_id','ethnicity','age','visit_purpose','name_type','sex','race','pin_code'),'conditions'=>array('Person.id'=>$data['Patient']['person_id'])));
		$MSH = $this->generateHL7MSH($data['ADT']['curdate']); 
		$EVN = "\n".$this->generateEVN($data['ADT']['curdate']);
		$PID = "\n".$this->generateHL7PID($personData);
		$PV1 = "\n".$this->generatePV1($data['ADT']['curdate'],$personData['Person']['patient_uid']); 
		if(!empty($data['Patient']['phvs_icd9cm_id']))
		$DG1 = "\n".$this->generateHL7DG1($data['Patient']['phvs_icd9cm_id']);
		$OBX1 = $this->generateHL7OBX1($personData['Person']['phvs_visit_id']);
		$OBX2 = "\n".$this->generateHL7OBX2($personData['Person']['age']);
		$OBX3 = "\n".$this->generateHL7OBX3($personData['Person']['visit_purpose']);
		
		return $MSH.$EVN.$PID.$PV1.$DG1.$OBX1.$OBX2.$OBX3;
		
	}
	
	public function gen_immunization($data = array()){
		
		$Patient = ClassRegistry::init('Patient');
		$Imunization = ClassRegistry::init('Immunization');
		$VaccModel = ClassRegistry::init('Imunization');
		$multiRecord = $Imunization->find('all',array('conditions'=>array('parent_id'=>$data['Immunization']['parent_id'])));
		
		$Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$Patient->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'User' =>array('foreignKey' => false,'conditions'=>array('Patient.doctor_id=User.id' )),
						
				)),false);
		$patient_info = $Patient->find('first',array('fields'=>array('Patient.admission_id','Patient.doctor_id','User.first_name','User.middle_name','User.last_name','Patient.id','Patient.person_id','Patient.patient_id','Person.created_by','Person.modified_by','Person.person_email_address','Person.phvs_icd9cm_id','Person.phvs_visit_id','Person.visit_purpose','Person.first_name','Person.middle_name','Person.last_name','Person.name_type','Person.mother_name','Person.age','Person.dob','Person.sex','Person.race',
									'Person.ssn_us','Person.person_local_number','Person.multiple_birth_indicator','Person.birth_order','Person.mother_first_name','Person.mother_last_name','Person.guardian_relation','Person.plot_no','Person.landmark','Person.city','Person.pin_code','Person.state','Person.country','Person.home_phone','Person.work','Person.mobile','Person.ethnicity','Person.person_address_type_first','Person.age','Person.person_city_code','Person.person_email_address_second'),'conditions'=>array('Patient.id'=>$data['Immunization']['patient_id'])));
		
		$MSH = $this->generateImmunizationMSH($patient_info);
		$PID = "\n".$this->generateImmunizationPID($patient_info);
		if(!empty($data['Immunization']['publicity_code'])){
		$PD1 = "\n".$this->generateImmunizationPD1($data);
		}elseif(!empty($data['Immunization']['protection_indicator'])){
		$PD1 = "\n".$this->generateImmunizationPD1($data);
		}
		
	  	$NK1 = "\n".$this->generateImmunizationNK1($patient_info); 
	  	if($NK1 == "\n") $NK1 = '';
	 
	  	foreach($multiRecord as $singleRecord){
	  		$vac_name = $VaccModel->find('first',array('fields'=>array('Imunization.cpt_description'),'conditions'=>array('Imunization.id'=>$singleRecord['Immunization']['vaccine_type'])));
	  		$vac_type = explode('-',$vac_name['Imunization']['cpt_description']);
	  		$singleRecord['Immunization']['published_date'] = explode("|",$singleRecord['Immunization']['published_date']);
	  		$singleRecord['Immunization']['vaccin_single_code'] = explode("|",$singleRecord['Immunization']['vaccin_single_code']);
	  		
	  
	  	$ORC = $this->generateImmunizationORC($patient_info,$singleRecord);
	  	
	  	$RXA = "\n".$this->generateImmunizationRXA($singleRecord);
	  		  	
	  	if($singleRecord['Immunization']['admin_site'] != "" && $singleRecord['Immunization']['route'] !=""){
	  	
	  	$RXR = "\n".$this->generateImmunizationRXR($singleRecord);
		  	if(count($vac_type > 0) ){
		  		$OBX1 = "\n".$this->generateImmunizationOBX1($singleRecord);
		  		
		  		$OBXmulti = "\n".$this->generateImmunizationOBXmulti($singleRecord,$vac_type);
		  		
		  		$OBX.= $OBX1.$OBXmulti;
		  	}else{
		  		$OBX = "\n".$this->generateImmunizationOBX1($singleRecord);
		  	}
	  	}elseif($singleRecord['Immunization']['vaccine_type'] == "251"){
	  		
	  		$OBX = "\n".$this->generateImmunizationOBX1($singleRecord);
	  		
	  	}else{
	  		$RXA.="\n";
	  	}
	  	
	  	$loopmsg .= $ORC.$RXA.$RXR.$OBX;
	  	
	  	$RXR ="";
	  	$OBX = "";
	  	
	  	} 
	  	
		return $MSH.$PID.$PD1.$NK1."\n".$loopmsg;
	}
	
	
	public function gen_ADT_A01($data = array()){
		$model = ClassRegistry::init('Person');
		$personData = $model->find('first',array('fields'=>array('patient_uid','phvs_icd9cm_id','phvs_visit_id','age','visit_purpose','name_type','sex','race','pin_code','ethnicity'),'conditions'=>array('Person.id'=>$data['Patient']['person_id'])));
		$MSH = $this->generateHL7MSH($data['ADT']['curdate']);
		$EVN = "\n".$this->generateEVN($data['ADT']['curdate']);
		$PID = "\n".$this->generateHL7PID($personData);
		$PV1 = "\n".$this->generatePV1($data['ADT']['curdate'],$personData['Person']['patient_uid']);
		$PV2 = "\n".$this->generatePV2($personData['Person']['phvs_icd9cm_id']);
		$OBX1 = "\n".$this->generateHL7OBX1($personData['Person']['phvs_visit_id']);
		$OBX2 = "\n".$this->generateHL7OBX2($personData['Person']['age']);
		$OBX3 = "\n".$this->generateHL7OBX3($personData['Person']['visit_purpose']);
	
		return $MSH.$EVN.$PID.$PV1.$PV2.$OBX1.$OBX2.$OBX3;
	}
	
	
	
	public function generateHL7MSH($date=null,$fun=null){

		$session = new cakeSession();
		$id = $this->find('count')+1;
		$callers=debug_backtrace(null,2);
		
		if($callers[1]['function'] == 'gen_ADT_A04'){
			$msgCenter = 'ADT^A04^ADT_A01';
			$msh04 =  'DrMuraliAmbulatory^123456789^NPI';
			$profile = '|||||||||PH_SS-NoAck^SS Sender^2.16.840.1.114222.4.10.3^ISO';
		}elseif($callers[1]['function'] == 'gen_ADT_A03'){
			$msgCenter = 'ADT^A03^ADT_A03';
			$msh04 =  'DrMuraliAmbulatory^123456789^NPI';
			$profile = '|||||||||PH_SS-NoAck^SS Sender^2.16.840.1.114222.4.10.3^ISO';
			
		}elseif($callers[1]['function'] == 'gen_ADT_A01'){
			$msgCenter = 'ADT^A01^ADT_A01';
			$msh04 =  'DrMuraliAmbulatory^123456789^NPI';
			$profile = '|||||||||PH_SS-NoAck^SS Sender^2.16.840.1.114222.4.10.3^ISO';
			
		}else{
			$msgCenter = 'ORU^R01^ORU_R01';
			$msh04 =  'DrMuraliInPatient^123456789^NPI';
			$profile = '|AL|NE|||||LRI_Common_Component^Profile Component^2.16.840.1.113883.9.16^ISO~LRI_NG_Component^Profile Component^2.16.840.1.113883.9.13^ISO~LRI_RN_Component^Profile Component^2.16.840.1.113883.9.15^ISO';
		}
		if($fun == 'A08'){
			$msgCenter = 'ADT^A08^ADT_A01';
		}
		$date = $this->HL7date($date);
		
		$MSH ="MSH|^~\&||".$msh04."|||".$date."||".$msgCenter."|".$id."|T|2.5.1".$profile;
		
		
		return $MSH;
	}


	public function generateHL7PID($data){
		
		$session = new cakeSession();
		$model = ClassRegistry::init('Race');
		$moreData = $model->find('first',array('fields'=>array('Race.value_code','Race.race_name'),'conditions'=>array('Race.value_code'=>$data['Person']['race'])));
		$callers=debug_backtrace(null,2);
		if($callers[1]['function'] == 'gen_ADT_A04' || $callers[1]['function'] == 'gen_ADT_A03' || $callers[1]['function'] == 'gen_ADT_A01'){
			if($data['Person']['ethnicity']=='2135-2:Hispanic or Latino'){
				$ethnicity ='|||||||||||2135-2^^CDCREC';
			}elseif($data['Person']['ethnicity']=='2186-5:Not Hispanic or Latino'){
				$ethnicity ='|||||||||||2186-5^^CDCREC';
			}else{
				$ethnicity = '';
			}
			if(!empty($data['Person']['race'])){
				$race = "|".$data['Person']['race']."^^CDCREC";
			}else{
				$race = '';
			}
			if(!empty($data['Person']['pin_code'])){
				$address = "|^^^^".$data['Person']['pin_code'];
			}else{
				$address = '|';
			}
			if(!empty($data['Person']['name_type'])){
				$name_type = "^^^^^^~^^^^^^".$data['Person']['name_type'];
			}else{
				$name_type = '';
			}
			 
		}else{
			$race = "|".$data['Person']['value_code']."^".$moreData['Race']['race_name']."^HL70005";
		}
		$sex = substr(ucfirst($data['Person']['sex']),0, 1);
		$PID = "PID|1||".$data['Person']['patient_uid']."^^^^MR||".$name_type."|||".$sex."|".$race.$address.$ethnicity;
		return $PID;
			
	}
	
	public function generateHL7ORC($patient_id=null,$testid=null){

		$session = new cakeSession();
		$ORC = "ORC|NW|".substr($testid,0, 199)."^".substr($session->read('facility'),0, 15).$session->read('locationid')."^^ISO||||||||||"
				.substr($session->read('userid'), 0, 15)."^".substr($_SESSION['Auth']['User']['last_name'], 0, 194)."^".substr($_SESSION['Auth']['User']['first_name'], 0, 30)."^".substr($_SESSION['Auth']['User']['middle_name'], 0, 30)."^suffix^".substr($session->read('initial_name'), 0, 20)."^^^^^^^NPI";
		return $ORC;
	}
	
	public function generateHL7OBR($patient_id=null,$testid=null){
	
		$session = new cakeSession();
		$model = ClassRegistry::init('LaboratoryTestOrder');
		$model->bindModel(array(
				'hasOne' => array(
						'LaboratoryToken' =>array('foreignKey'=>false,
								'conditions'=>array('LaboratoryToken.laboratory_test_order_id=LaboratoryTestOrder.id' ))),
			));
		
		$obsBattId = $model->find('first',array('fields'=>array('LaboratoryTestOrder.laboratory_id','LaboratoryToken.laboratory_id','LaboratoryToken.collected_date','LaboratoryToken.end_date','LaboratoryToken.specimen_action_id'),
				'conditions'=>array('LaboratoryTestOrder.order_id' =>$testid)));
		
		$strtdate = $this->HL7date($obsBattId['LaboratoryToken']['collected_date']);
		$enddate = $this->HL7date($obsBattId['LaboratoryToken']['end_date']);
		
		if(substr($obsBattId['LaboratoryToken']['specimen_action_id'], 0, 1) == 'S'){
			$sp_actionCode = 'O';
		}else{ $sp_actionCode = substr($obsBattId['LaboratoryToken']['specimen_action_id'], 0, 1);}
		 
		$OBR = "OBR|1|".substr($testid, 0,427)."||".substr($obsBattId['LaboratoryTestOrder']['laboratory_id'], 0, 20)."^".substr($obsBattId['LaboratoryToken']['laboratory_id'], 0, 255)."|".$strtdate."|"
				.$enddate."|".$sp_actionCode;//."||";
		return $OBR;
	}
	
	/*
	 * OBX1 for ADT AO4 & A03
	 */
	public function generateHL7OBX1($phvs_visit_id){
	
		$model = ClassRegistry::init('PhvsVisit');
		$moreData = $model->find('first',array('fields'=>array('PhvsVisit.value_code','PhvsVisit.description'),'conditions'=>array('PhvsVisit.id'=>$phvs_visit_id)));
		$OBX = "OBX|1|CWE|SS003^^PHINQUESTION||".$moreData['PhvsVisit']['value_code']."^".$moreData['PhvsVisit']['description']."^NUCC||||||F";
		
		return $OBX;
	}
	
	public function generateHL7OBX2($age){
		
		if(!empty($age) || $age == '0'){
			$age = $age."|a^^UCUM";
		}else{
			$age = $age."|UNK^^NULLFL";
		}
		$OBX2 = "OBX|2|NM|21612-7^^LN||".$age."|||||F";
		return $OBX2;
	}
	
	public function generateHL7OBX3($purpose){
		
		$model = ClassRegistry::init('PhvsIcd9cm');
		$moreData = $model->find('first',array('fields'=>array('PhvsIcd9cm.value_code','PhvsIcd9cm.description','PhvsIcd9cm.code_system'),'conditions'=>array('PhvsIcd9cm.description LIKE'=>$purpose)));
		if(!empty($moreData)){
			$purpose ='';
		}
		$OBX3 = "OBX|3|CWE|8661-1^^LN||".$moreData['PhvsIcd9cm']['value_code']."^".$moreData['PhvsIcd9cm']['description']."^".$moreData['PhvsIcd9cm']['code_system']."^^^^^^".$purpose."||||||F";
		return $OBX3;
	}
	
	public function generatePV1($date,$patient_uid){
		
		$session = new cakeSession();
		$callers=debug_backtrace(null,2);
		if($callers[1]['function'] == 'gen_ADT_A03'){
			$A03 = '01';
		}
		$patient_no = substr($patient_uid, -3);
		$date = $this->HL7date($date);
		$PV1= "PV1|1||||||||||||||||||".$patient_no."^^^^VN|||||||||||||||||".$A03."||||||||".$date;
		return $PV1;
	
	}
	
	public function generatePV2($phvsicd9cm){
	
		$model = ClassRegistry::init('PhvsIcd9cm');
		$phvs = explode(",",$phvsicd9cm);
		$moreData = $model->find('first',array('fields'=>array('PhvsIcd9cm.value_code','PhvsIcd9cm.description','PhvsIcd9cm.code_system'),'conditions'=>array('PhvsIcd9cm.id'=>$phvs['0'])));
	
		$PV2 = "PV2|||".$moreData['PhvsIcd9cm']['value_code']."^".$moreData['PhvsIcd9cm']['description']."^".$moreData['PhvsIcd9cm']['code_system'];
		return $PV2;
	}
	
	public function generateHL7DG1($phvsicd9cm){
	
		$model = ClassRegistry::init('PhvsIcd9cm');
		$callers=debug_backtrace(null,2);
		if($callers[1]['function'] == 'gen_ADT_A04'){
			$diagnosisType = 'W';
			$phvs = explode(",",$phvsicd9cm);
		}elseif($callers[1]['function'] == 'gen_ADT_A03'){
			$diagnosisType = 'F';
			$phvs =$phvsicd9cm;
		}
		
		for($i=0;$i<count($phvs);$i++){
			
			$moreData[] = $model->find('all',array('fields'=>array('PhvsIcd9cm.value_code','PhvsIcd9cm.description','PhvsIcd9cm.code_system'),'conditions'=>array('PhvsIcd9cm.id'=>$phvs[$i])));
		
		}
		$cnt=1;
		for($i=0;$i<count($phvs);$i++){
		
			$DG1.= "DG1|".$cnt."||".$moreData[$i]['0']['PhvsIcd9cm']['value_code']."^".$moreData[$i]['0']['PhvsIcd9cm']['description']."^".$moreData[$i]['0']['PhvsIcd9cm']['code_system']."|||".$diagnosisType."\n";
			$cnt++;
		}
		return $DG1;
	}
	
	public function generateEVN($date=null){
	
		$session = new cakeSession();
		$date = $this->HL7date($date);
		$EVN= "EVN||".$date."|||||DrMurlisAmbulatory^123456789^NPI";
		return $EVN;
	}
	
	public function generateImmunizationMSH($patientInfo){//echo '<pre>';print_r($patientInfo);exit;
		$patientUid = $patientInfo['Patient']['patient_id'];
		$admissionId = $patientInfo['Patient']['admission_id'];
		$patientType = substr($admissionId, 0, 1);
		if($patientType == 'O'){
			$sender = "DrMHopeAmbulatory";
		}else
			if($patientType == 'I'){
			$sender = "DrMHopeInpatient";
		}
		
		$session = new cakeSession();
		$id = $this->find('count')+1;
		$MSH= "MSH|^~\&|".$sender."|X68||NIST Test Iz Reg|".date('YmdHi')."||VXU^V04^VXU_V04|NIST-IZ-".$id."|T|2.5.1|||AL|ER";
		return $MSH;
	}
	
	public function generateImmunizationPID($data){
		
		$session = new cakeSession();
		$model = ClassRegistry::init('Race');
		$country = ClassRegistry::init('Country');
		$deathsummary = ClassRegistry::init('DeathSummary');
		$cou_name = $country->find('first',array('fields'=>array('Country.name'),'conditions'=>array('Country.id'=>$data['Person']['country'])));
		$moreData = $model->find('first',array('fields'=>array('Race.race_name','Race.value_code'),'conditions'=>array('Race.value_code'=>$data['Person']['race'])));
		$deathRecord = $deathsummary->find('first',array('fields'=>array('DeathSummary.death_on','DeathSummary.event_course'),'conditions'=>array('DeathSummary.patient_id'=>$data['Patient']['id'])));

			if($data['Person']['ethnicity']=='2135-2:Hispanic or Latino'){
				$ethnicity ="2135-2^Hispanic or Latino^CDCREC";
			}elseif($data['Person']['ethnicity']=='2186-5:Not Hispanic or Latino'){
				$ethnicity ="2186-5^Not Hispanic or Latino^CDCREC";
			}else{
				$ethnicity = "";
			}
			if(!empty($data['Person']['pin_code'])){
				$address = "^^^^".$data['Person']['pin_code'];
			}else{
				$address = '';
			}
			if(!empty($data['Person']['person_local_number'])){
				$phone_no ='^PRN^PH^^^'.$data['Person']['person_city_code'].'^'.str_replace('-', '^',$data['Person']['person_local_number']);//."~^NET^^".$data['Person']['email'];
			}elseif(!empty($data['Person']['home_phone'])){
 				$phone_no ='^PRN^PH^^^'.$data['Person']['person_city_code'].'^'.str_replace('-', '^',$data['Person']['home_phone']);//."~^NET^^".$data['Person']['email'];
			}elseif(!empty($data['Person']['work'])){
				$phone_no ='^PRN^PH^^^'.$data['Person']['person_city_code'].'^'.str_replace('-', '^',$data['Person']['work']);//."~^NET^^".$data['Person']['email'];
			}elseif(!empty($data['Person']['mobile'])){
				$phone_no ='^PRN^PH^^^'.$data['Person']['person_city_code'].'^'.str_replace('-', '^',$data['Person']['mobile']);//."~^NET^^".$data['Person']['email'];
			}elseif(!empty($data['Person']['mobile'])){
				$phone_no ='^PRN^PH^^^'.$data['Person']['person_city_code'].'^'.str_replace('-', '^',$data['Person']['mobile']);//."~^NET^^".$data['Person']['email'];
			}
			//----email attached here  person_email_address_second
			if(!empty($data['Person']['person_email_address'])){
				$phone_no = $phone_no."^~^NET^^".$data['Person']['person_email_address'];
			}elseif(!empty($data['Person']['person_email_address_second'])){
				$phone_no = $phone_no."^~^NET^^".$data['Person']['person_email_address_second'];
			}
			
			if(!empty($data['Person']['birth_order']) && !empty($data['Person']['multiple_birth_indicator']))
				$birth_indicator= "||".$data['Person']['multiple_birth_indicator']."|".$data['Person']['birth_order'];
			
			if(!empty($deathRecord['DeathSummary']['death_on']))
			$death = "||||".$this->DBdateTime($deathRecord['DeathSummary']['death_on'])."|".$deathRecord['DeathSummary']['event_course'];
			
			$name = $data['Person']['last_name']."^".$data['Person']['first_name']."^".$data['Person']['middle_name']."^^^^".$data['Person']['name_type'];
			
			if(!empty($data['Person']['mother_last_name']) && !empty($data['Person']['mother_first_name']))
			$mother_name = $data['Person']['mother_last_name']."^".$data['Person']['mother_first_name'];
			             
			
		if(!empty($data['Person']['race'])){
			
			$race = $moreData['Race']['value_code']."^".$moreData['Race']['race_name']."^HL70005";
		}
		
		$sex = substr(ucfirst($data['Person']['sex']),0, 1);
		if(!empty($data['Person']['ssn_us'])){
		  $ssn =  "~".$data['Person']['ssn_us']."^^^MAA^SS";
		}
		
		$addressString='';
		if(!empty($data['Person']['plot_no'])){
			$addressString .= "|".$data['Person']['plot_no'];
		}else{
			$addressString .= "^";
		}
		if(!empty($data['Person']['landmark'])){
			$addressString .= "^".$data['Person']['landmark'];
		}else{
			$addressString .= "^";
		}
		if(!empty($data['Person']['city'])){
			$addressString .= "^".$data['Person']['city'];
		}else{
			$addressString .= "^";
		}
		if(!empty($data['Person']['state'])){
			$addressString .= "^".$data['Person']['state'];
		}else{
			$addressString .= "^";
		}
		if(!empty($data['Person']['pin_code'])){
			$addressString .= "^".$data['Person']['pin_code'];
		}else{
			$addressString .= "^";
		}
		if(!empty($cou_name['country']['name'])){
			$addressString .= "^".$cou_name['country']['name'];
		}else{
			$addressString .= "^";
		}
		if(!empty($data['Person']['person_address_type_first'])){
			$addressString .= "^".$data['Person']['person_address_type_first'];
		}else{
			$addressString = "";
		}
		if(!empty($phone_no)){
			if(empty($data['Person']['plot_no'])){
				$addressString .= "|||".$phone_no; //added 3rd pipe for test case 2
			}else{
				$addressString .= "|||".$phone_no;
			}
			
		}
		if(!empty($ethnicity)){
			$addressString .= "|||||||||".$ethnicity;
		}
		if(!empty($birth_indicator)){
			$addressString .= $birth_indicator;
		}
		if(!empty($death)){
			$addressString .= $death;
		}
		
		/*$PID = "PID|1||".substr($data['Patient']['patient_id'], 0,15)."^^^NIST MPI^MR".$ssn."||".$name."|".$mother_name."|".$this->DBdate($data['Person']['dob'])."|".$sex."||".$race."|"
				.$data['Person']['plot_no']."^".$data['Person']['landmark']."^".$data['Person']['city']."^".$data['Person']['state']."^".$data['Person']['pin_code']."^"
						.$cou_name['country']['name']."^".$data['Person']['person_address_type_first']."||".$phone_no."|||||||||".$ethnicity.$birth_indicator.$death;
						*/
		$PID = "PID|1||".substr($data['Patient']['patient_id'], 0,15)."^^^NIST MPI^MR".$ssn."||".$name."|".$mother_name."|".$this->DBdate($data['Person']['dob'])."|".$sex."||".$race.$addressString;
		return $PID;
			
	}
	
	public function generateImmunizationPD1($data){
		$session = new cakeSession();
		$PhvsPublicityCode = ClassRegistry::init('PhvsPublicityCode');
		$publicitycode = $PhvsPublicityCode->find('first',array('fields'=>array('PhvsPublicityCode.value_code','PhvsPublicityCode.description','PhvsPublicityCode.code_system'),'conditions'=>array('PhvsPublicityCode.id'=>$data['Immunization']['publicity_code'])));
		
		if(!empty($publicitycode['PhvsPublicityCode']['value_code'])){
		$publicitycode = $publicitycode['PhvsPublicityCode']['value_code']."^".$publicitycode['PhvsPublicityCode']['description']."^".$publicitycode['PhvsPublicityCode']['code_system'];
		$publicity_date = "|".$this->DBdate($data['Immunization']['publicity_date']);
		}
		
		if(empty($data['Immunization']['protection_indicator'])){
		$indicator_date = "";
		}else{
		$indicator_date	= $this->DBdate($data['Immunization']['indicator_date']);
		}
		
		if(empty($data['Immunization']['registry_status'])){
			$registry_status_date = "";
		}else{
			$registry_status_date	= $this->DBdate($data['Immunization']['registry_status_date']);
		}
		
		$PD1 = "PD1|||||||||||".$publicitycode."|".$data['Immunization']['protection_indicator']."|".$indicator_date."|||".substr(ucfirst($data['Immunization']['registry_status']),0, 1)."|".$registry_status_date.$publicity_date;
		return $PD1;
	}
	
	public function generateImmunizationNK1($patient_info){
		$session = new cakeSession();
		
		
		$Guardian = ClassRegistry::init('Guardian');
		$Guardian->bindModel(array(
				'belongsTo' => array(
						'PhvsRelationship' =>array('foreignKey' => false,
								'conditions'=>array('PhvsRelationship.value_code=Guardian.guar_relation' )),
						'Hl7_0190_address_types' =>array('foreignKey' => false,
								'conditions'=>array('Hl7_0190_address_types.value_code=Guardian.guar_address_type' )),
						'Hl7_0201_phvs_telecommunications' =>array('foreignKey' => false,
								'conditions'=>array('Hl7_0201_phvs_telecommunications.value_code=Guardian.guar_tele_code' )),
						'hl7_0202_telecommunication_equipment_types' =>array('foreignKey' => false,
								'conditions'=>array('hl7_0202_telecommunication_equipment_types.value_code=Guardian.guar_equi_code' )),
				)),false);
		
		
		$guard =  $Guardian->find('first',array('conditions'=>array('person_id'=>$patient_info['Patient']['person_id'])));  
		

		$Relationship = $guard['PhvsRelationship']['value_code']."^".$guard['PhvsRelationship']['description']."^".$guard['PhvsRelationship']['code_system'];
		
		$name = $guard['Guardian']['guar_last_name']."^".$guard['Guardian']['guar_first_name']."^".$guard['Guardian']['middle_name']."^^^^".$guard['Guardian']['guar_name_type'];
		
		//$address = $guard['Guardian']['guar_address1']."^".$guard['Guardian']['guar_address2']."^".$guard['Guardian']['guar_city']."^".$guard['Guardian']['guar_state']."^".$guard['Guardian']['guar_zip']."^".$guard['Guardian']['guar_country']."^".$guard['Guardian']['guar_address_type'];
		$address = "";
		if(!empty($guard['Guardian']['guar_address1'])){
			$address .= $guard['Guardian']['guar_address1'];
		}
		if(!empty($guard['Guardian']['guar_address2'])){
			$address .= "^".$guard['Guardian']['guar_address2'];
		}else{
			$address .="^";
		}
		if(!empty($guard['Guardian']['guar_city'])){
			$address .= "^".$guard['Guardian']['guar_city'];
		}else{
			$address .="^";
		}
		if(!empty($guard['Guardian']['guar_state'])){
			$address .= "^".$guard['Guardian']['guar_state'];
		}else{
			$address .="^";
		}
		if(!empty($guard['Guardian']['guar_zip'])){
			$address .= "^".$guard['Guardian']['guar_zip'];
		}else{
			$address .="^";
		}
		if(!empty($guard['Guardian']['guar_country'])){
			$country = array('1'=>'India','2'=>'USA','3'=>'Australia','4'=>'Singapure','6'=>'Iceland','7'=>'UK');
			$address .= "^".$country[$guard['Guardian']['guar_country']];
		}else{
			$address .="^";
		}
		if(!empty($guard['Guardian']['guar_address_type'])){
			$address .= "^".$guard['Guardian']['guar_address_type'];
		}else{
			$address .="";
		}
		
		
		$ph_no = "^".$guard['Hl7_0201_phvs_telecommunications']['value_code']."^".$guard['hl7_0202_telecommunication_equipment_types']['value_code']."^^^".$guard['Guardian']['guar_area_code']."^".$guard['Guardian']['guar_localno'];
		if(!empty($guard['Guardian']['guar_last_name']) && !empty($guard['Guardian']['guar_first_name'])){
		$NK1 = "NK1|1|".$name."|".$Relationship."|".$address."|".$ph_no;
		}else{
			$NK1='';
		}
		return $NK1;
	}
	
	public function generateImmunizationORC($patient_info,$singleRecord){
		$session = new cakeSession();
		$User = ClassRegistry::init('User');
		
		
		if(empty($patient_info['Person']['modified_by'])){
			$patient_info['Person']['modified_by'] = $patient_info['Person']['created_by'];
		}
		$entered =$User->find('first',array('fields'=>array('User.id','User.last_name','User.first_name','User.middle_name'),'conditions'=>array('User.id'=>$patient_info['Person']['modified_by'])));
		
		$parRefu = substr($entered['User']['id'], 0, 15)."^".substr($entered['User']['last_name'], 0, 194)."^".substr($entered['User']['first_name'], 0, 30)."^".substr($entered['User']['middle_name'], 0, 30)."^^^^^NIST-AA-1||".substr($patient_info['Patient']['doctor_id'], 0, 15)."^".substr($patient_info['User']['last_name'], 0, 194)."^".substr($patient_info['User']['first_name'], 0, 30)."^".substr(ucfirst($patient_info['User']['middle_name']),0, 1)."^^^^^NIST-AA-1^L";
		
		if($singleRecord['Immunization']['admin_note'] == '1'){
		
			if(!empty($singleRecord['Immunization']['reason']) || ($singleRecord['Immunization']['vaccine_type'] == '251')){
				$ORC = "ORC|RE||".$this->autoGeneratedID('IZ')."^NDA";
			}else{
				$ORC = "ORC|RE||".$this->autoGeneratedID('IZ')."^NDA|||||||".$parRefu;
			}
			
		}else{
			$ORC = "ORC|RE||".$this->autoGeneratedID('IZ')."^NDA";
			//|".substr($entered['User']['id'], 0, 15)."^".substr($entered['User']['last_name'], 0, 194)."^".substr($entered['User']['first_name'], 0, 30)."^^^^^^NIST-AA-1||".substr($patient_info['Patient']['doctor_id'], 0, 15)."^".substr($patient_info['User']['last_name'], 0, 194)."^".substr($patient_info['User']['first_name'], 0, 30)."^^^^^^NIST-AA-1";substr(ucfirst($patient_info['User']['middle_name']),0, 1);
		}
		return $ORC;
	}
	
/*	public function generateImmunizationRXA($data){ 
		$session = new cakeSession();
		$Imunization = ClassRegistry::init('Imunization');
		$PhvsMeasureOfUnit = ClassRegistry::init('PhvsMeasureOfUnit');
		$PhvsImmunization = ClassRegistry::init('PhvsImmunizationInformationSource');
		$PhvsVaccinesMvx = ClassRegistry::init('PhvsVaccinesMvx');
		$user = ClassRegistry::init('User');
		$nip = ClassRegistry::init('Hl7Nip');
		
		$Imunization = $Imunization->find('first',array('fields'=>array('Imunization.value_code','Imunization.cpt_description','Imunization.code_system'),'conditions'=>array('Imunization.id'=>$data['Immunization']['vaccine_type'])));
		$Imunization = $Imunization['Imunization']['value_code']."^".$Imunization['Imunization']['cpt_description']."^".$Imunization['Imunization']['code_system'];
		
		$PhvsMeasureOfUnit = $PhvsMeasureOfUnit->find('first',array('fields'=>array('PhvsMeasureOfUnit.value_code','PhvsMeasureOfUnit.description','PhvsMeasureOfUnit.code_system'),'conditions'=>array('PhvsMeasureOfUnit.id'=>$data['Immunization']['phvs_unitofmeasure_id'])));
		if(!empty($PhvsMeasureOfUnit))
		$PhvsMeasure = $PhvsMeasureOfUnit['PhvsMeasureOfUnit']['value_code']."^".$PhvsMeasureOfUnit['PhvsMeasureOfUnit']['description']."^".$PhvsMeasureOfUnit['PhvsMeasureOfUnit']['code_system'];
		
		$PhvsImmunization = $PhvsImmunization->find('first',array('fields'=>array('PhvsImmunizationInformationSource.value_code','PhvsImmunizationInformationSource.description','PhvsImmunizationInformationSource.code_system'),'conditions'=>array('PhvsImmunizationInformationSource.id'=>$data['Immunization']['admin_note'])));
		$PhvsImmunization = $PhvsImmunization['PhvsImmunizationInformationSource']['value_code']."^".$PhvsImmunization['PhvsImmunizationInformationSource']['description']."^".$PhvsImmunization['PhvsImmunizationInformationSource']['code_system'];
		
		$PhvsVaccinesMvx = $PhvsVaccinesMvx->find('first',array('fields'=>array('PhvsVaccinesMvx.value_code','PhvsVaccinesMvx.description','PhvsVaccinesMvx.code_system'),'conditions'=>array('PhvsVaccinesMvx.id'=>$data['Immunization']['manufacture_name'])));
		$PhvsVaccinesMvx = $PhvsVaccinesMvx['PhvsVaccinesMvx']['value_code']."^".$PhvsVaccinesMvx['PhvsVaccinesMvx']['description']."^".$PhvsVaccinesMvx['PhvsVaccinesMvx']['code_system'];
		
		$user = $user->find('first',array('fields'=>array('User.id','User.first_name','User.last_name'),'conditions'=>array('User.id'=>$data['Immunization']['provider'])));
		$user = $user['User']['id']."^".$user['User']['last_name']."^".$user['User']['first_name'];
		
		$admin_loc = "^^^".$session->read('location');
		$restData='';
		if(!empty($data['Immunization']['lot_number']))
			$restData = "|".$user."^^^^^^NIST-AA-1|".$admin_loc."||||".$data['Immunization']['lot_number']."|".$this->DBdate($data['Immunization']['expiry_date'])."|".$PhvsVaccinesMvx."|";
		
		
		if($data['Immunization']['amount'] == "999")
			$PhvsMeasure = "";
		$reasonNipCodeData = $nip->read(null,$data['Immunization']['reason']);
		
		//echo '<pre>';print_r($reasonNipCodeData);exit;
		if(!empty($reasonNipCodeData['Hl7Nip']['value_code'])){
		$nip03 = $reasonNipCodeData['Hl7Nip']['value_code']."^".$reasonNipCodeData['Hl7Nip']['description']."^".$reasonNipCodeData['Hl7Nip']['code_system']."||RE|A";
		
		if($reasonNipCodeData['Hl7Nip']['value_code'] =='00')
		$PhvsImmunization="";
		
		}else{
			$nip03 = "|||CP|A";
		}
		if($Imunization['Imunization']['value_code'] == "21"){
			$nip03 = "||||NA";
		}
		if(isset($restData))
			$restData = $restData.$nip03;
		
		if(!empty($data['Immunization']['reason'])){
			$RXA = "RXA|0|1|".date('Ymd')."||".$Imunization."|".$data['Immunization']['amount']."|".$PhvsMeasure."||".$PhvsImmunization.$restData;
		
			if($reasonNipCodeData['Hl7Nip']['value_code'] =='00'){
				$RXA = "RXA|0|1|".date('Ymd')."||".$Imunization."|999||||||||||||00^Parental Refusal^NIP002||RE";
			}
		}else{
			if($PhvsImmunization == "01^Historical information - source unspecified^NIP001"){
				$restData = "";
			}
			if($Imunization == "21^varicella^CVX"){
				$Imunization ="998^No vaccine administered^CVX";
				$PhvsImmunization = "||NA";
				$data['Immunization']['amount'] ="999|||||||||";
				$PhvsMeasure = "";
				$restData = "";
				
			}
			$RXA = "RXA|0|1|".date('Ymd')."||".$Imunization."|".$data['Immunization']['amount']."|".$PhvsMeasure."||".$PhvsImmunization.$restData;
		}
		return $RXA;
	}*/
	
	public function generateImmunizationRXR($data){
		$session = new cakeSession();
		$PhvsAdminsRoute = ClassRegistry::init('PhvsAdminsRoute');
		$PhvsAdminSite = ClassRegistry::init('PhvsAdminSite');
		
		$PhvsAdminsRoute = $PhvsAdminsRoute->find('first',array('fields'=>array('PhvsAdminsRoute.value_code','PhvsAdminsRoute.description','PhvsAdminsRoute.code_system'),'conditions'=>array('PhvsAdminsRoute.id'=>$data['Immunization']['route'])));
		$PhvsAdminsRoute = $PhvsAdminsRoute['PhvsAdminsRoute']['value_code']."^".$PhvsAdminsRoute['PhvsAdminsRoute']['description']."^".$PhvsAdminsRoute['PhvsAdminsRoute']['code_system'];
		
		$PhvsAdminSite = $PhvsAdminSite->find('first',array('fields'=>array('PhvsAdminSite.value_code','PhvsAdminSite.description','PhvsAdminSite.code_system'),'conditions'=>array('PhvsAdminSite.id'=>$data['Immunization']['admin_site'])));
		$PhvsAdminSite = $PhvsAdminSite['PhvsAdminSite']['value_code']."^".$PhvsAdminSite['PhvsAdminSite']['description']."^".$PhvsAdminSite['PhvsAdminSite']['code_system'];
		
	
		$RXR = "RXR|".$PhvsAdminsRoute."|".$PhvsAdminSite;
		return $RXR;
	}
	/*
	 * for generating OBX1
	 */
	public function generateImmunizationOBX1($data){
	
		$PhvsObservationIdentifier = ClassRegistry::init('PhvsObservationIdentifier');
		$PhvsFinancialClass = ClassRegistry::init('PhvsFinancialClass');
		
			$PhvsObservation = $PhvsObservationIdentifier->find('first',array('fields'=>array('PhvsObservationIdentifier.value_code','PhvsObservationIdentifier.description','PhvsObservationIdentifier.code_system'),'conditions'=>array('PhvsObservationIdentifier.id'=>$data['Immunization']['funding_category'])));
			$Observation = $PhvsObservation['PhvsObservationIdentifier']['value_code']."^".$PhvsObservation['PhvsObservationIdentifier']['description']."^".$PhvsObservation['PhvsObservationIdentifier']['code_system'];
	
			$obs_value = $PhvsFinancialClass->find('first',array('fields'=>array('PhvsFinancialClass.value_code','PhvsFinancialClass.description','PhvsFinancialClass.code_system'),'conditions'=>array('PhvsFinancialClass.id'=>$data['Immunization']['observation_value'])));
			if(!empty($obs_value['PhvsFinancialClass']['value_code']))
			$obs_value = $obs_value['PhvsFinancialClass']['value_code']."^".$obs_value['PhvsFinancialClass']['description']."^".$obs_value['PhvsFinancialClass']['code_system'];
				
			if($data['Immunization']['observation_method'] != "" ){
				if($data['Immunization']['observation_method'] == 'Eligibility captured at the immunization level'){
					$method = "|||VXC40^Eligibility captured at the immunization level^CDCPHINVS";
				}else{
					$method = "|||VXC41^Eligibility captured at the visit level^CDCPHINVS";
				}
			}
			if(!empty($data['Immunization']['observation_date'])){
				$obs_date = $this->DBdate($data['Immunization']['observation_date']);
			}
			
				 
		$OBX1.= "OBX|1|CE|".$Observation."|1|".$obs_value."||||||F|||".$obs_date.$method;
		
				
		return $OBX1;
	}
	/*
	 * for generating multiple OBX
	 */
	public function generateImmunizationOBXmulti($data,$vaccin){
	
		$Imunization = ClassRegistry::init('Imunization');
		$PhvsObservationIdentifier = ClassRegistry::init('PhvsObservationIdentifier');
		
		$PhvsObservation = $PhvsObservationIdentifier->find('first',array('fields'=>array('PhvsObservationIdentifier.value_code','PhvsObservationIdentifier.description','PhvsObservationIdentifier.code_system'),'conditions'=>array('PhvsObservationIdentifier.id'=>$data['Immunization']['funding_category'])));
		$Observation = $PhvsObservation['PhvsObservationIdentifier']['value_code']."^".$PhvsObservation['PhvsObservationIdentifier']['description']."^".$PhvsObservation['PhvsObservationIdentifier']['code_system'];
		
	
			$var = 2;
			$obxcntr = 2;
		for($cnt=0;$cnt<count($vaccin);$cnt++){
			
		/*	if(strlen($vaccin[$cnt]) == 3 || strlen($vaccin[$cnt]) == 4){
			$cpt_desc = $vaccin[$cnt].", unspecified formulation";
			}else{
				$cpt_desc = $vaccin[$cnt];
			}
			if($vaccin[$cnt] == 'IPV')
				$cpt_desc = "polio, unspecified formulation";
			if($vaccin[$cnt] == 'DTP')
				$cpt_desc = "DTP";
			if($vaccin[$cnt] == 'Tdap')
				$cpt_desc = "Tdap";
			if($vaccin[$cnt] == 'Hep B')
				$cpt_desc = "Hep B, unspecified formulation";
			
			if($vaccin[$cnt] == 'Influenza, seasonal, injectable, preservative free' || $vaccin[$cnt] == 'Influenza, seasonal, injectable')
				$cpt_desc = "Influenza, unspecified formulation";
			
			*/
			$obs_val = $Imunization->find('first',array('fields'=>array('Imunization.value_code','Imunization.cpt_description','Imunization.code_system'),'conditions'=>array('Imunization.id'=>$data['Immunization']['vaccin_single_code'][$cnt])));
			$obs_val = $obs_val['Imunization']['value_code']."^".$obs_val['Imunization']['cpt_description']."^".$obs_val['Imunization']['code_system'];
		/*	if($obs_val == '^^'){
				$cpt_desc = $vaccin[$cnt].", unspecified formulation";
				$obs_val = $Imunization->find('first',array('fields'=>array('Imunization.value_code','Imunization.cpt_description','Imunization.code_system'),'conditions'=>array('Imunization.cpt_description LIKE'=>$cpt_desc."%")));
				$obs_val = $obs_val['Imunization']['value_code']."^".$obs_val['Imunization']['cpt_description']."^".$obs_val['Imunization']['code_system'];
					
			}
			if($obs_val == '^^'){
				$cpt_desc = $vaccin[$cnt];
				$obs_val = $Imunization->find('first',array('fields'=>array('Imunization.value_code','Imunization.cpt_description','Imunization.code_system'),'conditions'=>array('Imunization.cpt_description LIKE'=>$cpt_desc."%")));
				$obs_val = $obs_val['Imunization']['value_code']."^".$obs_val['Imunization']['cpt_description']."^".$obs_val['Imunization']['code_system'];
					
			}*/
			//debug($data['Immunization']);
			$OBXmulti.= "OBX|".$obxcntr."|CE|30956-7^vaccine type^LN|".$var."|".$obs_val."||||||F\n";   $obxcntr++;
		//	$OBXmulti.= "OBX|".$obxcntr."|TS|".$Observation."|".$var."|".$this->FrntDateMDY($data['Immunization']['published_date'][$cnt])."||||||F\n";  $obxcntr++;
		//	$OBXmulti.= "OBX|".$obxcntr."|TS|".$Observation."|".$var."|".date('Ymd')."||||||F\n"; $obxcntr++;
			
			//-----static version for testing
			$OBXmulti.= "OBX|".$obxcntr."|TS|29768-9^Date vaccine information statement published^LN|".$var."|".$this->FrntDateMDY($data['Immunization']['published_date'][$cnt])."||||||F\n";  $obxcntr++;
			$OBXmulti.= "OBX|".$obxcntr."|TS|29769-7^Date vaccine information statement presented^LN|".$var."|".date('Ymd')."||||||F\n"; $obxcntr++;
					
			
			$var++;
		}
		
		
		return $OBXmulti;
	}
	
	public function HL7date($date =null){
		$seperation = explode(" ",$date);
		$output = $seperation[3].date("m", strtotime($seperation[1])).$seperation[2].str_replace(":", "", $seperation[4])."-".str_replace(array("GMT+",":"), "", $seperation[5]);
		return $output;
	}
	
	public function DBdateTime($date =null){
		$date =date(r ,strtotime($date));
		$seperation = explode(" ",$date);
		if($seperation[5] == "+0000")unset($seperation[5]);
		$output = $seperation[3].date("m", strtotime($seperation[2])).$seperation[1].str_replace(":", "", $seperation[4]).$seperation[5];
		
		return $output;
	}
	
	public function DBdate($date =null){
		$date =date(r ,strtotime($date));
		$seperation = explode(" ",$date);
		$output = $seperation[3].date("m", strtotime($seperation[2])).$seperation[1];
		return $output;
	}
	
	public function FrntDateMDY($date =null){
		$seperation = explode("/",$date);
		$output = str_replace(' ', '', $seperation[2].$seperation[0].$seperation[1]);//debug($output);
		return $output;
	}
	
	public function autoGeneratedID($unique_id=null){
		$Location = ClassRegistry::init('Location');
		$session = new cakeSession();
		$count = $this->find('count',array('conditions'=>array('Hl7Message.create_time like'=> "%".date("Y-m-d")."%")));
	
		if($count==0){
			$count = "001" ;
		}else if($count < 10 ){
			$count = "00$count"  ;
		}else if($count >= 10 && $count <100){
			$count = "0$count"  ;
		}
		$month_array = array('A','B','C','D','E','F','G','H','I','J','K','L');
		//find the Hospital name.
	
		$Location->unbindModel(
				array('belongsTo' => array('City','State','Country'))
		);
			
		#	$hospital = $Location->read('Facility.name,Location.name',$session->read('locationid'));
	
		//creating patient ID
		$facility = $session->read('facility');
		$location = $session->read('location');
		$unique_id  .= substr($facility,0,1); //first letter of the hospital name
		$unique_id  .= substr($location,0,2);//first 2 letter of d location
		$unique_id  .= date('y'); //year
		$unique_id  .= $month_array[date('n')-1];//first letter of month
		$unique_id  .= date('d');//day
		$unique_id .= $count;
		$unique_id .= rand(5, 15);
		return strtoupper($unique_id) ;
	
	
	}
	
	
	public function generateImmunizationRXA($data){
		$session = new cakeSession();
		$Imunization = ClassRegistry::init('Imunization');
		$PhvsMeasureOfUnit = ClassRegistry::init('PhvsMeasureOfUnit');
		$PhvsImmunization = ClassRegistry::init('PhvsImmunizationInformationSource');
		$PhvsVaccinesMvx = ClassRegistry::init('PhvsVaccinesMvx');
		$user = ClassRegistry::init('User');
	
		$Imunization = $Imunization->find('first',array('fields'=>array('Imunization.value_code','Imunization.cpt_description','Imunization.code_system'),'conditions'=>array('Imunization.id'=>$data['Immunization']['vaccine_type'])));
		$Imunization = $Imunization['Imunization']['value_code']."^".$Imunization['Imunization']['cpt_description']."^".$Imunization['Imunization']['code_system'];
	
		$PhvsMeasureOfUnit = $PhvsMeasureOfUnit->find('first',array('fields'=>array('PhvsMeasureOfUnit.value_code','PhvsMeasureOfUnit.description','PhvsMeasureOfUnit.code_system'),'conditions'=>array('PhvsMeasureOfUnit.id'=>$data['Immunization']['phvs_unitofmeasure_id'])));
		if(!empty($PhvsMeasureOfUnit))
			$PhvsMeasure = $PhvsMeasureOfUnit['PhvsMeasureOfUnit']['value_code']."^".$PhvsMeasureOfUnit['PhvsMeasureOfUnit']['description']."^".$PhvsMeasureOfUnit['PhvsMeasureOfUnit']['code_system'];
	
		$PhvsImmunization = $PhvsImmunization->find('first',array('fields'=>array('PhvsImmunizationInformationSource.value_code','PhvsImmunizationInformationSource.description','PhvsImmunizationInformationSource.code_system'),'conditions'=>array('PhvsImmunizationInformationSource.id'=>$data['Immunization']['admin_note'])));
		$PhvsImmunization = $PhvsImmunization['PhvsImmunizationInformationSource']['value_code']."^".$PhvsImmunization['PhvsImmunizationInformationSource']['description']."^".$PhvsImmunization['PhvsImmunizationInformationSource']['code_system'];
	
		$PhvsVaccinesMvx = $PhvsVaccinesMvx->find('first',array('fields'=>array('PhvsVaccinesMvx.value_code','PhvsVaccinesMvx.description','PhvsVaccinesMvx.code_system'),'conditions'=>array('PhvsVaccinesMvx.id'=>$data['Immunization']['manufacture_name'])));
		
		if(!empty($PhvsVaccinesMvx['PhvsVaccinesMvx']['code_system'])){
			$PhvsVaccinesMvx = $PhvsVaccinesMvx['PhvsVaccinesMvx']['value_code']."^".$PhvsVaccinesMvx['PhvsVaccinesMvx']['description']."^".$PhvsVaccinesMvx['PhvsVaccinesMvx']['code_system'];
		}else{
			$PhvsVaccinesMvx = "";
		}
		
	
		$user = $user->find('first',array('fields'=>array('User.id','User.first_name','User.last_name','User.middle_name'),'conditions'=>array('User.id'=>$data['Immunization']['provider'])));
		
		if(empty($user['User']['middle_name'])){
			$user = $user['User']['id']."^".$user['User']['last_name']."^".$user['User']['first_name'];
		}else{
			if(!empty($user['User']['middle_name'])){
				$user = $user['User']['id']."^".$user['User']['last_name']."^".$user['User']['first_name']."^".$user['User']['middle_name'];
			}else{
				$user = $user['User']['id']."^".$user['User']['last_name']."^".$user['User']['first_name']."^^";
			}
			
		}
		
		
		$admin_loc = "^^^".$session->read('location');
		if(!empty($data['Immunization']['lot_number'])){
			if(!empty($data['Immunization']['provider'])){
				$user= $user."^^^^^^NIST-AA-1";
			}else{
				$user= "";
			}
			$restData = "|".$user."|".$admin_loc."||||".$data['Immunization']['lot_number']."|".$this->DBdate($data['Immunization']['expiry_date'])."|".$PhvsVaccinesMvx."|||CP|A";
		}
		if($data['Immunization']['amount'] == "999")
			$PhvsMeasure = "";
		
		if($data['Immunization']['reason'] == "1"){
			$PhvsImmunization = "";
			$restData = "|||||||||00^Parental Refusal^NIP002||RE";
			
		}
		
		if($data['Immunization']['vaccine_type'] == "251"){
			$PhvsImmunization = "";
			$restData = "|||||||||||NA";
				
		}
		
		//echo '<pre>';print_r($restData);exit;
		
		$RXA = "RXA|0|1|".date('Ymd')."||".$Imunization."|".$data['Immunization']['amount']."|".$PhvsMeasure."||".$PhvsImmunization.$restData;
		
			  
		
		return $RXA;
	}

}
?>