<?php

/* Hl7_results model
 *
* PHP 5
*
* @copyright     Copyright 2013 DrM Hope Software.  (http://www.drmhope.com/)
* @link          http://www.drmhope.com/
* @package       Hl7message Generation
* @since         CakePHP(tm) v 5.4.3
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Gaurav Chauriya
*/
class Hl7Result extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'Hl7Result';
	public $counter;



	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	 */

	public $specific = true;
	public $obxCounter=0;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	public function genratelabResultIPDtoOPD($data1 = array(),$curdate){


		
		$PID = "\n".$this->generateHL7PID($data1);

		$cnt=0;
		foreach($data1 as $data){
			if($cnt == 0){
				$prevData = $data;
			}
			$firstDate = $data['LaboratoryResult']['create_time'];
			$ORC .= "\n".$this->generateHL7ORC($data,$cnt,$prevData);
			$OBR .= "\n".$this->generateHL7OBR($data,$curdate,$cnt,$prevData);
			if(!empty($data['LaboratoryResult']['on_notes_comments'])){
				$NTE1 .= "\n".$this->generateHL7NTE($data['LaboratoryResult']['on_notes_comments']);
			}else{
				$NTE1 ="";
			}

			if(!empty($data['LaboratoryResult']['tqi_start_date_time']) && !empty($data['LaboratoryResult']['tqi_end_date_time']))
				$TQ1 .= "\n".$this->generateHL7TQ1($data);
			if(empty($data['LaboratoryResult']['si_specimen_reject_reason'])){
				$OBX .= "\n".$this->generateIPDtoOPDOBX($data,$data['LaboratoryResult']['od_observation_start_date_time']);
			}else{
				$OBX = "";
				$rejected = true;
			}

			if(!empty($data['LaboratoryResult']['re_notes_comments'])){
				$NTE2 .= $this->generateHL7OBXNTE($data['LaboratoryResult']['re_notes_comments']);
				$ntTrue = true;
			}else{
				$NTE2 = "";
			}
			if($ntTrue == true){
				if(!empty($data['LaboratoryResult']['si_specimen_type']))
					if($this->obxCounter > 1)
					$SPM .= "\n".$this->generateHL7SPM($data);
				else 
					$SPM .= $this->generateHL7SPM($data);
			}
			else{
				if(!empty($data['LaboratoryResult']['si_specimen_type'])){
					if($this->obxCounter > 1)
						$SPM .= $this->generateHL7SPM($data);
					else{
						if($rejected == true)
							$SPM .= "\n".$this->generateHL7SPM($data);
						else
							$SPM .= $this->generateHL7SPM($data);
					}
				}
			}
			$ntTrue = false;
			if(empty($NTE2) && empty($SPM) && $cnt > 0){//echo $OBX;exit;
				$newLine = substr($OBX, (strlen($OBX) - 2), (strlen($OBX)));
				if($newLine == "\n")
					$OBX = substr($OBX, 0, (strlen($OBX) - 2));
			}
			$loopmsg .= $ORC.$OBR.$NTE1.$TQ1.$OBX.$NTE2.$SPM;

			$ORC= $OBR = $NTE1 = $TQ1 = $OBX = $SPM = $NTE2='';
			$cnt++;
		}
		$MSH = $this->generateHL7MSH($firstDate,$data1[0]['LaboratoryResult']['ehr_facility'],end($data1));
		$MSG = $MSH.$PID.$loopmsg;

		return $MSG;

	}



	public function genrateHL7ELR($data = array(),$requestdata){

		$Patient = ClassRegistry::init('Patient');
		$Guardian = ClassRegistry::init('Guardian');
		
		$Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));

		$patient_info = $Patient->find('first',array('fields'=>array('Person.notes_comment','Person.id','Person.age','Person.dob'),'conditions'=>array('Patient.id'=>$data['0']['LaboratoryResult']['patient_id'])));


		$MSH = $this->generateELRMSH($data[0]['LaboratoryResult']['create_time']);
		$SFT = "\n".$this->generateHL7SFT();
		$PID = "\n".$this->generateELRPID($data);

		if(!empty($patient_info['Person']['notes_comment']))
			$NTE = "\n".$this->generateHL7NTE($patient_info['Person']['notes_comment']);
		
		$guardian_details = $Guardian->find('first',array('conditions'=>array('person_id'=>$patient_info['Person']['id'])));
		
		if(!empty($guardian_details['Guardian']['guar_last_name']))
			$NK1 = "\n".$this->generateELRNK1($patient_info['Person']['id']);
		
		if(!empty($data[0]['LaboratoryResult']['patient_class']) && !empty($data[0]['LaboratoryResult']['admission_type']))
			$PV1 = "\n".$this->generateELRPV1($data);
		
		$ORC .= "\n".$this->generateELRORC($data);
		$OBXString = '';
		$OBRString = '';
		$cnt=0;
		foreach($data as $data){
			if($cnt == 0){
				$prevData = $data;
			}
			if(!empty($data['LaboratoryResult']['od_universal_service_identifier'])){
				$OBR .= "\n".$this->generateELROBR($data,$requestdata['labHl7Result']['curdate'],$cnt,$prevData);
			}
			
			if(!empty($data['LaboratoryResult']['on_notes_comments']))
				$OBXNTE = "\n".$this->generateHL7OBXNTE($data['LaboratoryResult']['on_notes_comments']);
			
			$OBX .= "\n".$this->generateELROBX($data,$prevData);
			
			//echo '<pre>';print_r($data['LaboratoryResult']['si_specimen_type']);exit;
			if(!empty($data['LaboratoryResult']['si_specimen_type'])){
				if($OBXNTE == '')
					$SPM = $this->generateELRSPM($data);
				else
					$SPM = "\n".$this->generateELRSPM($data);
				}
			
			if(!empty($data['LaboratoryResult']['si_specimen_role'])){
				$specialOBX = "\n".$this->generateELRSpecialOBX($patient_info,$data);
			}else{
				$specialOBX = "";
			}
			
			$multipleData .= $OBR.$OBXNTE.$OBX.$SPM.$specialOBX;
			
			$OBR =$OBXNTE = $OBX = $SPM = $specialOBX = '';
			$cnt++;
		}
		
		
		
		return $MSH.$SFT.$PID.$NTE.$NK1.$PV1.$ORC.$multipleData;

	}
	
	public function generateELRSpecialOBX($patient_info,$data){
		//echo ''; print_r($data);exit;
		$age = $this->calculateAge($patient_info['Person']['dob']);
		$startTime = $this->DBdateTime($data['LaboratoryResult']['od_observation_start_date_time']);
		$endTime =  $this->DBdateTime($data['LaboratoryHl7Result'][0]['date_time_of_observation']);
		$OBX = "OBX|1|SN|35659-2^Age at Specimen Collection^LN^AGE^AGE^L^2.40^V1||=^".$age."|a^Year^UCUM^Y^Years^L^1.1^V1|||||F|||".$startTime."|||||".$endTime."||||University Hospital Chem Lab^L^^^^CLIA&2.16.840.1.113883.4.7&ISO^XX^^^01D1111111|Firstcare Way^Building 2^Harrisburg^PA^17111^USA^L^^42043|1790019875^House^Gregory^F^III^Dr^^^NPI&2.16.840.1.113883.4.6&ISO^L^^^NPI^NPI_Facility&2.16.840.1.113883.3.72.5.26&ISO^^^^^^^MD";
		return $OBX;
	}

	public function calculateAge($bithdayDate){
		$date = new DateTime($bithdayDate);
		$now = new DateTime();
		$interval = $now->diff($date);
		return $interval->y;
	}

	public function generateHL7SFT(){

		$session = new cakeSession();

		$SFT = "SFT|NIST Lab, Inc.^L^^^^NIST&2.16.840.1.113883.3.987.1&ISO^XX^^^123544|3.6.23|A-1 Lab System|6742873-12||20100617";
		return $SFT;
	}

	public function generateHL7MSH($curdate,$ehr_fac,$lastArr){

		$session = new cakeSession();
		//$id = $this->find('count')+1;
		$id = $this->getCount();
		
			$msgCenter = 'ORU^R01^ORU_R01';
			$msh04 =  'DrMuraliInPatient^123456789^NPI';
			$profile = '|AL|NE|||||LRI_Common_Component^Profile Component^2.16.840.1.113883.9.16^ISO~LRI_NG_Component^Profile Component^2.16.840.1.113883.9.13^ISO~LRI_RU_Component^Profile Component^2.16.840.1.113883.9.14^ISO';

			$curdate = $this->DBdateTime($curdate);
				$MSH = "MSH|^~\&#|DrMHope Test Lab APP|DrMHope Lab Facility||".$lastArr['LaboratoryResult']['send_result_to_facility']."|".$curdate."||".$msgCenter."|NIST-LRI-NG-".$id."|T|2.5.1||".$profile;
		
				
		
		
		return $MSH;
	}
	
	public function generateELRMSH($date){
	
		$session = new cakeSession();
		$id = $this->getCount();
	
		$msgCenter = 'ORU^R01^ORU_R01';
		if(!empty($date))
		$curdate = $this->DBdateTime($date);
		
		
			$MSH = "MSH|^~\&#|DrMHope Lab APP^2.16.840.1.113883.3.72.5.20^ISO|NIST^2.16.840.1.113883.3.72.5.21^ISO|NIST^2.16.840.1.113883.3.72.5.22^ISO|NIST^2.16.840.1.113883.3.72.5.23^ISO|".$curdate."||".$msgCenter."|NIST-ELR-".$id."|T|2.5.1|||NE|NE|||||PHLabReport-NoAck^HL7^2.16.840.1.113883.9.11^ISO";
		
	
		return $MSH;
	}

	public function generateHL7PID($data){


		$session = new cakeSession();
		$patient = ClassRegistry::init('Patient');
		$person = ClassRegistry::init('Person');
		$model = ClassRegistry::init('Race');
		$country = ClassRegistry::init('country');
		$initialModel = ClassRegistry::init('Initial');
		$initialModel = $initialModel->find('list',array('fields'=>array('id','name')));
		
		$patientData = $patient->find('first',array('fields'=>array('patient_id'),'conditions'=>array('Patient.id'=>$data[0]['LaboratoryResult']['patient_id'])));
		
		$personData = $person->find('first',array('fields'=>array('Person.initial_id','patient_uid','race','alt_race','ethnicity','alt_ethinicity','sex','name_type','last_name','first_name','dob','middle_name','mother_name',
				'suffix1','ssn_us','plot_no','landmark','city','state','pin_code','country','person_address_type_first','person_parish_code_first',
				'address_line_1_second','address_line_2_second','person_address_type_second','city_second','state_second','person_parish_code_second','country_second','pin_code_second',
				'person_tele_code','person_tele_equip_type','person_country_code','person_city_code','person_local_number','person_extension','person_any_text',
				'person_tele_code_second','person_tele_equip_type_second','person_email_address_second','person_any_text_second',
				'person_tele_code_business','person_tele_equip_type_business','person_country_code_business','person_city_code_business','person_local_number_business','person_extension_business','person_any_text_business'),
				'conditions'=>array('Person.patient_uid'=>$patientData['Patient']['patient_id'])));
		
		$cou_name = $country->find('first',array('fields'=>array('Country.name'),'conditions'=>array('Country.id'=>$personData['Person']['country'])));
		$cou_name_second = $country->find('first',array('fields'=>array('Country.name'),'conditions'=>array('Country.id'=>$personData['Person']['country_second'])));
		
		$moreData = $model->find('first',array('fields'=>array('Race.race_name'),'conditions'=>array('Race.value_code'=>$personData['Person']['race'])));
		
		if(!empty($personData['Person']['race'])){
			
			$race = $personData['Person']['race']."^".$moreData['Race']['race_name']."^HL70005^".$personData['Person']['race']."^".$moreData['Race']['race_name']."^99USI";
		}

		
		
		if(!empty($personData['Person']['sex']))
		$sex = substr(ucfirst($personData['Person']['sex']),0, 1);
		
		if(!empty($personData['Person']['dob']))
			$person_dob = $this->DBdate($personData['Person']['dob']);
		
		$name_type = $personData['Person']['last_name']."^".$personData['Person']['first_name']."^".substr(ucfirst($personData['Person']['middle_name']),0, 1)."^".strtoupper($personData['Person']['suffix1'])."^".$initialModel[$personData['Person']['Initial_id']]."^^".$personData['Person']['name_type'];

		
		$PID = "PID|1||".$personData['Person']['patient_uid']."^^^MPI^MR||".$name_type."||".$person_dob."|".$sex."||".$race;

		

		return $PID;
			
	}
	
	public function generateELRPID($data){
	
	
		$session = new cakeSession();
		$patient = ClassRegistry::init('Patient');
		$person = ClassRegistry::init('Person');
		$model = ClassRegistry::init('Race');
		$country = ClassRegistry::init('country');
		$initialModel = ClassRegistry::init('Initial');
		
		$initialModel = $initialModel->find('list',array('fields'=>array('id','name')));
		
		$patientData = $patient->find('first',array('fields'=>array('patient_id','patientdied','death_recorded_date','modify_time','create_time'),'conditions'=>array('Patient.id'=>$data[0]['LaboratoryResult']['patient_id'])));
		//echo '<pre>';print_r($patientData);exit;
		$personData = $person->find('first',array('fields'=>array('patient_uid','race','alt_race','ethnicity','alt_ethinicity','sex','name_type','last_name','first_name','dob','middle_name','mother_name',
				'suffix1','ssn_us','plot_no','landmark','city','state','pin_code','country','person_address_type_first','person_parish_code_first',
				'address_line_1_second','address_line_2_second','person_address_type_second','city_second','state_second','person_parish_code_second','country_second','pin_code_second',
				'person_tele_code','person_tele_equip_type','person_country_code','person_city_code','person_local_number','person_extension','person_any_text',
				'person_tele_code_second','person_tele_equip_type_second','person_email_address_second','person_any_text_second',
				'person_tele_code_business','person_tele_equip_type_business','person_country_code_business','person_city_code_business','person_local_number_business','person_extension_business','person_any_text_business',
				'Person.alt_first_name','Person.alt_last_name','Person.alt_initial_id','Person.alt_middle_name','Person.alt_name_type','Person.alt_suffix',
				'Person.mother_first_name','Person.mother_last_name','Person.mother_middle_name','Person.mother_initial_id','Person.mother_name_type',
				'Person.mother_suffix','Person.mother_prof_suffix','Person.professional_suffix','Person.initial_id','Person.person_city_code_second','Person.person_local_number_second'
				,'person_extension_second','person_any_text_second','person_local_number_second','person_city_code_second','person_country_code_second'),
				
				'conditions'=>array('Person.patient_uid'=>$patientData['Patient']['patient_id'])));
		
		if(!empty($personData['Person']['mother_first_name']) && !empty($personData['Person']['mother_last_name'])){
			$motNameString = $personData['Person']['mother_last_name']."^".$personData['Person']['mother_first_name']."^".$personData['Person']['mother_middle_name']."^".$personData['Person']['mother_suffix']."^".$initialModel[$personData['Person']['mother_initial_id']]."^^".$personData['Person']['mother_name_type']."^^^^^^^".$personData['Person']['mother_prof_suffix'];
		}else{
			$motNameString = "";
		}
		
		if(!empty($patientData['Patient']['patientdied']) && !empty($patientData['Patient']['death_recorded_date'])){
			$deadString = str_replace("-","",$patientData['Patient']['death_recorded_date'])."|Y";
		}else{
			$deadString = "|N";
		}
		
		$cou_name = $country->find('first',array('fields'=>array('Country.name'),'conditions'=>array('Country.id'=>$personData['Person']['country'])));
		$cou_name_second = $country->find('first',array('fields'=>array('Country.name'),'conditions'=>array('Country.id'=>$personData['Person']['country_second'])));
	
		$moreData = $model->find('first',array('fields'=>array('Race.race_name'),'conditions'=>array('Race.value_code'=>$personData['Person']['race'])));
	
		if(!empty($personData['Person']['race'])){
	
			$race = $personData['Person']['race']."^".$moreData['Race']['race_name']."^HL70005";
		}
		if(!empty($personData['Person']['alt_race']) && $personData['Person']['alt_race'] == "CAUC"){
			$alt_race = "^CAUC^Caucasian^L";
			$race .=$alt_race;
		}elseif(!empty($personData['Person']['alt_race']) && $personData['Person']['alt_race'] == "wh"){
			$alt_race = "^wh^white^L";
			$race .=$alt_race;
		}elseif(!empty($personData['Person']['alt_race']) && $personData['Person']['alt_race'] == "BLAF"){
			$alt_race = "^BLAF^Black or African American^L";
			$race .=$alt_race;
		}
	//echo '<pre>';print_r($personData);exit;
		if(!empty($personData['Person']['sex']))
			$sex = substr(ucfirst($personData['Person']['sex']),0, 1);
	
		if(!empty($personData['Person']['dob']))
			$person_dob = $this->DBdate($personData['Person']['dob']);
		
		if(!empty($personData['Person']['patient_alt_prof_suffix'])){
			$altProfessionalSuffix = "^^^^^^^".$personData['Person']['patient_alt_prof_suffix'];
		}else{
			$altProfessionalSuffix= "";
		}
		
		if(!empty($personData['Person']['alt_last_name']) && !empty($personData['Person']['alt_first_name']))
			$altNameString = "~".$personData['Person']['alt_last_name']."^".$personData['Person']['alt_first_name']."^".$personData['Person']['alt_middle_name']."^".$personData['Person']['alt_suffix']."^".$initialModel[$personData['Person']['alt_initial_id']]."^^".$personData['Person']['alt_name_type'].$altProfessionalSuffix;	
		else
			$altNameString = "";
		
		if(!empty($personData['Person']['professional_suffix'])){
			$professionalSuffix = "^^^^^^^".$personData['Person']['professional_suffix'];
		}else{
			$professionalSuffix= "";
		}
		$name_type = $personData['Person']['last_name']."^".$personData['Person']['first_name']."^".substr(ucfirst($personData['Person']['middle_name']),0, 1)."^".strtoupper($personData['Person']['suffix1'])."^".$initialModel[$personData['Person']['initial_id']]."^^".$personData['Person']['name_type'].$professionalSuffix.$altNameString;
								
	
	//$personData['Person']['alt_last_name']
		
			if(!empty($personData['Person']['alt_race']))
				$alt_race .= "^1.1^4";
			$race = $personData['Person']['race']."^".$moreData['Race']['race_name']."^CDCREC^".$personData['Person']['race']."^".$moreData['Race']['race_name']."^99USI^RV1^RAV1^".$moreData['Race']['race_name'];
			if(!empty($personData['Person']['ssn_us']))
				$ssn = "~".$personData['Person']['ssn_us']."^^^SSN&2.16.840.1.113883.4.1&ISO^SS^SSA&2.16.840.1.113883.3.184&ISO";
	
			$pat_dtls = $personData['Person']['patient_uid']."^^^MPI&2.16.840.1.113883.3.0.0.0.3&ISO^MR^Princeton Hospital&2.16.840.1.113883.3.0&ISO".$ssn;
	
			$altaddress = "~".$personData['Person']['address_line_1_second']."^".$personData['Person']['address_line_2_second']."^".$personData['Person']['city_second'].
			"^".$personData['Person']['state_second']."^".$personData['Person']['pin_code_second']."^".$cou_name_second['Country']['name']."^".$personData['Person']['person_address_type_second']."^^".$personData['Person']['person_parish_code_second'];
	
			$address = "|".$personData['Person']['plot_no']."^".$personData['Person']['landmark']."^".$personData['Person']['city']."^".$personData['Person']['state'].
			"^".$personData['Person']['pin_code']."^".$cou_name['Country']['name']."^".$personData['Person']['person_address_type_first'].
			"^^".$personData['Person']['person_parish_code_first'].$altaddress;
	//if($personData['Person']['person_tele_equip_type_second'] ==  "Internet"){
			//if(!empty($personData['Person']['person_email_address_second']) || !empty($personData['Person']['person_local_number_second']))
				$email_dtls = "~^".$personData['Person']['person_tele_code_second']."^".$personData['Person']['person_tele_equip_type_second'].
				"^".$personData['Person']['person_email_address_second']."^".$personData['Person']['person_country_code_second']."^".$personData['Person']['person_city_code_second']."^".$personData['Person']['person_local_number_second']."^".$personData['Person']['person_extension_second']."^".$personData['Person']['person_any_text_second'];
	//}else{
				//if(!empty($personData['Person']['person_tele_code_second']) && (!empty($personData['Person']['person_tele_equip_type_second']) || !empty($personData['Person']['person_city_code_second']) || !empty($personData['Person']['person_local_number_second']))){
//$pid132 = "~^".$personData['Person']['person_tele_code_second']."^".$personData['Person']['person_tele_equip_type_second']."^^^".$personData['Person']['person_city_code_second']."^".$personData['Person']['person_local_number_second'];
//}
	//}//echo $pid132.'here';exit;
//----new var
$contact_dtls="^".$personData['Person']['person_tele_code']."^".$personData['Person']['person_tele_equip_type']."^^".$personData['Person']['person_country_code']."^".$personData['Person']['person_city_code']."^".$personData['Person']['person_local_number']."^".$personData['Person']['person_extension']."^".$personData['Person']['person_any_text'].$pid132.$email_dtls;
				
	//----old var
			/*$contact_dtls = "^".$personData['Person']['person_tele_code']."^".$personData['Person']['person_tele_equip_type']."^^".$personData['Person']['person_country_code'].
			"^".$personData['Person']['person_city_code']."^".$personData['Person']['person_local_number']."^".$personData['Person']['person_extension']."^".$personData['Person']['person_any_text'].$email_dtls;*/
	//-------
			$business_contact = "|^".$personData['Person']['person_tele_code_business']."^".$personData['Person']['person_tele_equip_type_business']."^^".$personData['Person']['person_country_code_business'].
			"^".$personData['Person']['person_city_code_business']."^".$personData['Person']['person_local_number_business']."^".$personData['Person']['person_extension_business']."^".$personData['Person']['person_any_text_business'];
	
			if($personData['Person']['ethnicity']=='2135-2:Hispanic or Latino'){
				$ethnicity ='||||||||2135-2^Hispanic or Latino^CDCREC^2135-2^Hispanic or Latino^99USI^EV1^EV2^Hispanic or Latino';
			}elseif($personData['Person']['ethnicity']=='2186-5:Not Hispanic or Latino'){
				$ethnicity ='||||||||2186-5^Not Hispanic or Latino^CDCREC^2186-5^Not Hispanic or Latino^99USI^EV1^EV2^Not Hispanic or Latino';
			}
			elseif($personData['Person']['ethnicity']=='H:Hispanic or Latino'){
				$ethnicity ='||||||||H^Hispanic or Latino^HL70189^H^Hispanic or Latino^99USI^EV1^EV2^Hispanic or Latino';
			}
			elseif($personData['Person']['ethnicity']=='N:Not Hispanic or Latino'){
				$ethnicity ='||||||||N^Not Hispanic or Latino^HL70189^N^Not Hispanic or Latino^99USI^EV1^EV2^Not Hispanic or Latino';
			}
			elseif($personData['Person']['ethnicity']=='U:Unknown'){
				$ethnicity ='||||||||U^Unknown^HL70189^U^Unknown^99USI^EV1^EV2^Unknown';
			}
			elseif($personData['Person']['ethnicity']=='UNK:Unknown'){
				$ethnicity ='||||||||UNK^Unknown^NULLFL^UNK^Unknown^99USI^EV1^EV2^Unknown';
			}
	
			if($personData['Person']['alt_ethinicity']=='NH'){
				$ethnicity .= '^NH^Non hispanic^L^2.5.1^4';
			}elseif($personData['Person']['alt_ethinicity']=='NL'){
				$ethnicity .= '^NL^Not Latino^L^2.5.1^4';
			}elseif($personData['Person']['alt_ethinicity']=='L'){
				$ethnicity .= '^L^Latino^L^2.5.1^4';
			}
			if(!empty($patientData['Patient']['modify_time'])){
				$modTime = $this->DBdateTime($patientData['Patient']['modify_time']);
			}else if(!empty($patientData['Patient']['create_time'])){
				$modTime = $this->DBdateTime($patientData['Patient']['create_time']);
			}else{
				$modTime = "201206170000+0530";
			}
	
			$PID = "PID|1||".$pat_dtls."||".$name_type."|".$motNameString."|".$person_dob."|".$sex."||".$race.$address."||".$contact_dtls.$business_contact.$ethnicity."|||||||".$deadString."|||".$modTime."|University H^2.16.840.1.113883.3.0^ISO|337915000^Homo sapiens (organism)^SCT^human^human^L^07/31/2012^4";
		
	
		return $PID;
			
	}

	public function generateHL7ORC($data,$cnt,$prevData){

		$session = new cakeSession();
		$user = ClassRegistry::init('User');
		$userData = $user->find('first',array('fields'=>array('first_name','last_name','middle_name','Initial.name','suffix','name_type'),'conditions'=>array('User.id'=>$data['LaboratoryResult']['op_identifier_number'])));

		$name  = "||||||||".$data['LaboratoryResult']['op_identifier_number']."^".$userData['User']['last_name']."^".$userData['User']['first_name']."^".$userData['User']['middle_name']."^".$userData['User']['suffix']."^".strtoupper($userData['Initial']['name'])."^^^DrMhope Lab^".$userData['User']['name_type']."^^^NPI";
		if($cnt > 0){
			$labOrderString = "";
		}else{
			$labOrderString = $prevData['LaboratoryResult']['ogi_placer_order_number']."^DrMHopeEHR";
		}
		if(!empty($data['LaboratoryResult']['ogi_placer_group_number'])){
			$data['LaboratoryResult']['ogi_placer_group_number'] = $data['LaboratoryResult']['ogi_placer_group_number']."^DrMHopeEHR";
		}
			$ORC = "ORC|RE|".$labOrderString."|".$data['LaboratoryResult']['ogi_filler_order_number']."^DrMHope Lab Filler|".$data['LaboratoryResult']['ogi_placer_group_number'].$name;

		
		
		return $ORC;
	}
	
	public function generateELRORC($data){
		$data=$data[0];
		$session = new cakeSession();
		$user = ClassRegistry::init('User');
		$userData = $user->find('first',array('fields'=>array('first_name','last_name','middle_name','Initial.name','suffix','name_type'),'conditions'=>array('User.id'=>$data['LaboratoryResult']['op_identifier_number'])));
		if(!empty($data['LaboratoryResult']['ogi_placer_group_number'])){
			$data['LaboratoryResult']['ogi_placer_group_number'] = $data['LaboratoryResult']['ogi_placer_group_number']."^NIST_Sending_App^2.16.840.1.113883.3.72.5.24^ISO";
		}else{
			$data['LaboratoryResult']['ogi_placer_group_number'] = "";
		}
		
			$extrProfile = "||||||||111111111^Bloodraw^Leonard^T^JR^DR^^^NPI&2.16.840.1.113883.4.6&ISO^L^^^NPI^NPI_Facility&2.16.840.1.113883.3.72.5.26&ISO^^^^^^^MD||^WPN^PH^^1^555^7771234^11^Hospital Line~^WPN^PH^^1^555^2271234^4^Office Phone|||||||University Hospital^L^^^^NIST sending app&2.16.840.1.113883.3.72.5.21&ISO^XX^^^111|Firstcare Way^Building 1^Harrisburg^PA^17111^USA^L^^42043|^WPN^PH^^1^555^7771234^11^Call  9AM  to 5PM|Firstcare Way^Building 1^Harrisburg^PA^17111^USA^B^^42043";
			$ORC = "ORC|RE|".$data['LaboratoryResult']['ogi_placer_order_number']."^NIST_Placer _App^2.16.840.1.113883.3.72.5.24^ISO|".$data['LaboratoryResult']['ogi_filler_order_number']."^NIST_Sending_App^2.16.840.1.113883.3.72.5.24^ISO|".$data['LaboratoryResult']['ogi_placer_group_number'].$extrProfile;
		
		return $ORC;
	}

	public function generateHL7OBR($data,$curdt,$cnt,$prevData){

	$session = new cakeSession();
		$user = ClassRegistry::init('User');
		$laboratory = ClassRegistry::init('Laboratory');
		$loinc = ClassRegistry::init('LoincLnHl7');
		$labToken = ClassRegistry::init('LaboratoryToken');
		$userData = $user->find('first',array('fields'=>array('first_name','last_name','middle_name','Initial.name','suffix','name_type'),'conditions'=>array('User.id'=>$data['LaboratoryResult']['op_identifier_number'])));
		$ServiceData = $loinc->find('first',array('fields'=>array('code','display_name','alternate_identifier'),'conditions'=>array('LoincLnHl7.code'=>$data['LaboratoryResult']['od_universal_service_identifier'])));
		$LabTokenData = $labToken->find('first',array('fields'=>array('patient_id','create_time'),'conditions'=>array('LaboratoryToken.patient_id'=>$data['LaboratoryResult']['patient_id'])));
		
		$SnomedSctHl7 = ClassRegistry::init('SnomedSctHl7');
		$SnomedSctHl7 = $SnomedSctHl7->find('first',array('fields'=>array('SnomedSctHl7.code','SnomedSctHl7.display_name','SnomedSctHl7.alternate_identifier'),'conditions'=>array('SnomedSctHl7.code'=>$data['LaboratoryResult']['od_relevant_clinical_information'])));
		$SnomedSctHl7Data = $SnomedSctHl7;
		if(!empty($SnomedSctHl7['SnomedSctHl7']['code']) && !empty($SnomedSctHl7['SnomedSctHl7']['display_name'])){
			if($SnomedSctHl7['SnomedSctHl7']['code'] == '787.91')
				$SnomedSctHl7= $SnomedSctHl7['SnomedSctHl7']['code']."^".$SnomedSctHl7['SnomedSctHl7']['display_name']."^I9CDX^".$SnomedSctHl7['SnomedSctHl7']['code']."^".$SnomedSctHl7['SnomedSctHl7']['display_name']."^99USI^^^".$data['LaboratoryResult']['od_relevent_clinical_information_original_text'];
			else
				$SnomedSctHl7= $SnomedSctHl7['SnomedSctHl7']['code']."^".$SnomedSctHl7['SnomedSctHl7']['display_name']."^SCT^".$SnomedSctHl7['SnomedSctHl7']['code']."^".$SnomedSctHl7['SnomedSctHl7']['display_name']."^99USI^^^".$data['LaboratoryResult']['od_relevent_clinical_information_original_text'];
		}
		else
			$SnomedSctHl7 = "";

		$order_number = $data['LaboratoryResult']['ogi_placer_order_number'];
		$filler_number = $prevData['LaboratoryResult']['ogi_filler_order_number'];
		$service_identifier = $data['LaboratoryResult']['od_universal_service_identifier'];
		$service_identifier_name = $ServiceData['LoincLnHl7']['display_name'];
		$order_date = $ServiceData['LaboratoryToken']['create_time'];
		$action_code = $data['LaboratoryResult']['od_specimen_action_code'];
		if(!empty($SnomedSctHl7Data['SnomedSctHl7']['code'])){
		if($SnomedSctHl7Data['SnomedSctHl7']['code'] == '787.91')
			$clinical_information = $SnomedSctHl7Data['SnomedSctHl7']['code']."^".$SnomedSctHl7Data['SnomedSctHl7']['display_name']."^I9CDX^".$SnomedSctHl7Data['SnomedSctHl7']['code']."^".$SnomedSctHl7Data['SnomedSctHl7']['display_name']."^99USI^^^".$SnomedSctHl7Data['SnomedSctHl7']['display_name'];
		else 
			$clinical_information = $SnomedSctHl7Data['SnomedSctHl7']['code']."^".$SnomedSctHl7Data['SnomedSctHl7']['display_name']."^SCT^".$SnomedSctHl7Data['SnomedSctHl7']['code']."^".$SnomedSctHl7Data['SnomedSctHl7']['display_name']."^99USI^^^".$SnomedSctHl7Data['SnomedSctHl7']['display_name'];
		}else{
			$clinical_information = "";
		}
		$id_number = $data['LaboratoryResult']['op_identifier_number'];
		$result_date = $data['LaboratoryResult']['ori_result_report_status_date_time'];
		$result_status = $data['LaboratoryResult']['ori_result_status'];
		$identifier_number = $data['LaboratoryResult']['rct_identifier'];
		$rctlast_name = $data['LaboratoryResult']['rct_last_name'];
		$rct_middle_name= $data['LaboratoryResult']['rct_middle_name'];
		$name = $data['LaboratoryResult']['rct_name'];
		$rct_suffix = $data['LaboratoryResult']['rct_suffix'];
		$rct_prefix = $data['LaboratoryResult']['rct_prefix'];
		$first_name = $userData['User']['first_name'];
		$last_name = $userData['User']['last_name'];
		$user_suffix = $userData['User']['suffix'];
		$user_prefix = $userData['Initial']['name'];
		$user_name_type = $userData['User']['name_type'];

		$pusi_alt_identifier = $data['LaboratoryResult']['pusi_alt_identifier'];
		$pusi_alt_text = $data['LaboratoryResult']['pusi_alt_text'];
		$pusi_original_text = $data['LaboratoryResult']['pusi_original_text'];
		$od_observation_end_date_time = $data['LaboratoryResult']['od_observation_end_date_time'];//
		$od_observation_start_date_time = $data['LaboratoryResult']['od_observation_start_date_time'];
		
		$middle_name = $userData['User']['middle_name'];
		$suffix = $userData['User']['suffix'];
		$prefix = $userData['User']['prefix'];
		$name_type = $data['LaboratoryResult']['op_name_type'];
		$identifier_type_code = $data['LaboratoryResult']['op_identifier_type_code'];
		$proffessional_suffix = $data['LaboratoryResult']['op_proffessional_suffix'];

		$tele_code = $data['LaboratoryResult']['op_tele_code'];
		$tele_equip_type = $data['LaboratoryResult']['op_tele_equip_type'];
		$email_address = $data['LaboratoryResult']['op_email_address'];
		$country_code = $data['LaboratoryResult']['op_country_code'];
		$city_code = $data['LaboratoryResult']['op_country_code'];
		$local_number = $data['LaboratoryResult']['op_local_number'];
		$extension = $data['LaboratoryResult']['op_extension'];
		$any_text = $data['LaboratoryResult']['op_any_text'];

		$tele_code_second = $data['LaboratoryResult']['op_tele_code_second'];
		$tele_equip_type_second = $data['LaboratoryResult']['op_tele_equip_type_second'];
		$email_address_second = $data['LaboratoryResult']['op_email_address_second'];
		$country_code_second = $data['LaboratoryResult']['op_country_code_second'];
		$city_code_second = $data['LaboratoryResult']['op_city_code_second'];
		$local_number_second = $data['LaboratoryResult']['op_local_number_second'];
		$extension_second = $data['LaboratoryResult']['op_extension_second'];
		$reason_for_study_identifier = $data['LaboratoryResult']['reason_for_study_identifier'];

		$any_text_second = $data['LaboratoryResult']['op_any_text_second'];
		$reason_for_study_text = $data['LaboratoryResult']['reason_for_study_text'];
		$reason_for_study_coding_system = $data['LaboratoryResult']['reason_for_study_coding_system'];
		$reason_for_study_alt_identifier = $data['LaboratoryResult']['reason_for_study_alt_identifier'];
		$reason_for_study_alt_text = $data['LaboratoryResult']['reason_for_study_alt_text'];
		$reason_for_study_alt_coding_system = $data['LaboratoryResult']['reason_for_study_alt_coding_system'];
		$reason_for_study_coding_system_id = $data['LaboratoryResult']['reason_for_study_coding_system_id'];
		$reason_for_study_alt_coding_system_id = $data['LaboratoryResult']['reason_for_study_alt_coding_system_id'];

		$principal_id = $data['LaboratoryResult']['principal_id'];
		$principal_last_name = $data['LaboratoryResult']['principal_last_name'];
		$principal_first_name = $data['LaboratoryResult']['principal_first_name'];
		$principal_middle_name = $data['LaboratoryResult']['principal_middle_name'];
		$principal_suffix = $data['LaboratoryResult']['principal_suffix'];
		$principal_prefix = $data['LaboratoryResult']['principal_prefix'];
		$principal_edu = $data['LaboratoryResult']['principal_edu'];
		
		if(!empty($od_observation_end_date_time)){
			$od_observation_end_date_time = $this->DBdateTime($od_observation_end_date_time);
		}else{
			$od_observation_end_date_time = "";
		}
		
		if(!empty($data['LaboratoryResult']['od_observation_end_date_time'])){
			$orderend_dateTime = $this->DBdateTime($data['LaboratoryResult']['od_observation_end_date_time']);
		}else{
			$orderend_dateTime='';
		}
		if(!empty($data['LaboratoryResult']['od_observation_start_date_time'])){
			$orderstart_dateTime = $this->DBdateTime($data['LaboratoryResult']['od_observation_start_date_time']);
		}else{
			$orderstart_dateTime='';
		}
		
		if(!empty($rctlast_name) && !empty($name)){
			if(!empty($data['LaboratoryResult']['rh_standard']) && !empty($data['LaboratoryResult']['rh_local'])){
				$copy = "|||||||||||||||||||||CC^Carbon Copy^HL70507^C^Send Copy^L^^^Copied Requested";
			}elseif(!empty($data['LaboratoryResult']['rh_standard']) && empty($data['LaboratoryResult']['rh_local'])){
			
				$copy = "|||||||||||||||||||||CC^Carbon Copy^HL70507";
			}elseif(empty($data['LaboratoryResult']['rh_standard']) && empty($data['LaboratoryResult']['rh_local'])){
				$copy = '';
			}
			$middleString ="|||".$identifier_number."^".$rctlast_name."^".$name."^".$rct_middle_name."^".$rct_suffix."^".$rct_prefix."^^^DrMhope Lab^L^^^NPI";
		}else{
			$middleString="";
		}
		if($cnt > 0){
			$labOrderString = "";
		}else{
			$labOrderString = $order_number."^DrMHopeEHR";
		}
		//$OBR = "OBR|1|".$order_number."^DrMHopeEHR"."|".$filler_number."^DrMHope Lab Filler"."|".$service_identifier."^".$service_identifier_name."^"."LN"."^".$service_identifier_name."^".$service_identifier_name."^99USI^^^".$service_identifier_name."|||".$this->DBdateTime($od_observation_start_date_time)."|".$od_observation_end_date_time."|||".$action_code."||".$clinical_information."|||".$id_number."^".
		//$last_name."^".$first_name."^".$middle_name."^".$suffix."^".$user_prefix."^^^DrMhope Lab^".$userData['User']['name_type']."^^^NPI||||||".
		//$this->DBdateTime($data['LaboratoryResult']['create_time'])."|||".$result_status.$middleString.$copy;
				

		
		
		

		$callers=debug_backtrace(null,2);
		if($callers[1]['function'] == 'genratelabResultIPDtoOPD'){
			
			$first_name = $userData['User']['first_name'];
			$last_name = $userData['User']['last_name'];
			$middle_name = $userData['User']['middle_name'];
			$Initial_name = $userData['Initial']['name'];
			
			
			$rct_name = $data['LaboratoryResult']['rct_name'];
			
			$cnt++;//od_universal_service_identifier
			if($data['LaboratoryResult']['od_specimen_action_code'] == 'G'){
				if($data['LaboratoryResult']['od_universal_service_identifier'] == '11011-4'){
					$specialCase26 = "16128-1&Hepatitis C virus Ab [Presence] in Serum&LN&16128&Hepatitis C antibody screen  (anti-HCV)&L|||".$prevData['LaboratoryResult']['ogi_placer_order_number']."&DrMHopeEHR^".$prevData['LaboratoryResult']['ogi_filler_order_number']."&DrMHope Lab Filler";
				}else{
					$specialCase26 = "625-4&Bacteria identified in Stool by Culture&LN&&&&&&Stool Culture^".$cnt-(1)."|||".$prevData['LaboratoryResult']['ogi_placer_order_number']."&DrMHopeEHR^".$prevData['LaboratoryResult']['ogi_filler_order_number']."&DrM Hope Lab Filler";
				}
				
			}else{
				$specialCase26 = '';
			}
			
			
			
			if(!empty($curdt))
			$curdt=$this->HL7date($curdt);
			
			
			if(empty($rctlast_name)){
				if(!empty($specialCase26)){
					$OBR = "OBR|".$cnt."|".$labOrderString."|".$data['LaboratoryResult']['ogi_filler_order_number']."^DrMHope Lab Filler|".$data['LaboratoryResult']['od_universal_service_identifier']."^".$ServiceData['LoincLnHl7']['display_name']."^LN^".$ServiceData['LoincLnHl7']['code']."^".$ServiceData['LoincLnHl7']['display_name']."^99USI^^^".$ServiceData['LoincLnHl7']['display_name']."|||".$orderstart_dateTime."|".$od_observation_end_date_time."|||".$data['LaboratoryResult']['od_specimen_action_code']."||".$SnomedSctHl7."|||".$data['LaboratoryResult']['op_identifier_number']."^".$last_name."^".$first_name."^".ucfirst($middle_name)."^".$userData['User']['suffix']."^".strtoupper($Initial_name)."^^^DrMhope Lab^".$userData['User']['name_type']."^^^NPI||||||".$curdt."|||".$data['LaboratoryResult']['ori_result_status']."|".$specialCase26;
				}else{
					$OBR = "OBR|".$cnt."|".$labOrderString."|".$data['LaboratoryResult']['ogi_filler_order_number']."^DrMHope Lab Filler|".$data['LaboratoryResult']['od_universal_service_identifier']."^".$ServiceData['LoincLnHl7']['display_name']."^LN^".$ServiceData['LoincLnHl7']['code']."^".$ServiceData['LoincLnHl7']['display_name']."^99USI^^^".$ServiceData['LoincLnHl7']['display_name']."|||".$orderstart_dateTime."|".$od_observation_end_date_time."|||".$data['LaboratoryResult']['od_specimen_action_code']."||".$SnomedSctHl7."|||".$data['LaboratoryResult']['op_identifier_number']."^".$last_name."^".$first_name."^".ucfirst($middle_name)."^".$userData['User']['suffix']."^".strtoupper($Initial_name)."^^^DrMhope Lab^".$userData['User']['name_type']."^^^NPI||||||".$curdt."|||".$data['LaboratoryResult']['ori_result_status']."|".$specialCase26;
				}
				
			}else{
				$OBR = "OBR|".$cnt."|".$labOrderString."|".$data['LaboratoryResult']['ogi_filler_order_number']."^DrMHope Lab Filler|".$data['LaboratoryResult']['od_universal_service_identifier']."^".$ServiceData['LoincLnHl7']['display_name']."^LN^".$ServiceData['LoincLnHl7']['code']."^".$ServiceData['LoincLnHl7']['display_name']."^99USI^^^".$ServiceData['LoincLnHl7']['display_name']."|||".$orderstart_dateTime."|".$od_observation_end_date_time."|||".$data['LaboratoryResult']['od_specimen_action_code']."||".$SnomedSctHl7."|||".$data['LaboratoryResult']['op_identifier_number']."^".$last_name."^".$first_name."^".ucfirst($middle_name)."^".$userData['User']['suffix']."^".strtoupper($Initial_name)."^^^DrMhope Lab^".$userData['User']['name_type']."^^^NPI||||||".$curdt."|||".$data['LaboratoryResult']['ori_result_status']."|".$specialCase26."||".$data['LaboratoryResult']['rct_identifier']."^".$data['LaboratoryResult']['rct_last_name']."^".$rct_name."^".substr(ucfirst($rct_middle_name),0,1)."^".$data['LaboratoryResult']['rct_suffix']."^".strtoupper($rct_prefix)."^^^DrMhope Lab^L^^^NPI".$copy;
			}
			

		}

			

			return $OBR;
		
	}
	
	public function generateELROBR($data,$curdt,$cnt,$prevData){
	
		$session = new cakeSession();
		$user = ClassRegistry::init('User');
		$laboratory = ClassRegistry::init('Laboratory');
		$loinc = ClassRegistry::init('LoincLnHl7');
		$labToken = ClassRegistry::init('LaboratoryToken');
		$userData = $user->find('first',array('fields'=>array('first_name','last_name','middle_name','Initial.name','suffix','name_type'),'conditions'=>array('User.id'=>$data['LaboratoryResult']['op_identifier_number'])));
		$ServiceData = $loinc->find('first',array('fields'=>array('code','display_name','alternate_identifier'),'conditions'=>array('LoincLnHl7.code'=>$data['LaboratoryResult']['od_universal_service_identifier'])));
		$LabTokenData = $labToken->find('first',array('fields'=>array('patient_id','create_time'),'conditions'=>array('LaboratoryToken.patient_id'=>$data['LaboratoryResult']['patient_id'])));
	
		$SnomedSctHl7 = ClassRegistry::init('SnomedSctHl7');
		$SnomedSctHl7 = $SnomedSctHl7->find('first',array('fields'=>array('SnomedSctHl7.code','SnomedSctHl7.display_name','SnomedSctHl7.alternate_identifier'),'conditions'=>array('SnomedSctHl7.id'=>$data['LaboratoryResult']['od_relevant_clinical_information'])));
		$SnomedSctHl7= $SnomedSctHl7['SnomedSctHl7']['code']."^".$SnomedSctHl7['SnomedSctHl7']['display_name']."^SCT^".$SnomedSctHl7['SnomedSctHl7']['alternate_identifier']."^".$SnomedSctHl7['SnomedSctHl7']['display_name']."^99USI^^^".$data['LaboratoryResult']['od_relevent_clinical_information_original_text'];
	
		
		if(!empty($od_observation_end_date_time)){
			$od_observation_end_date_time = $this->DBdateTime($od_observation_end_date_time);
		}else{
			$od_observation_end_date_time = "";
	
	
	
			if(!empty($data['LaboratoryResult']['od_observation_end_date_time'])){
				$orderend_dateTime = $this->DBdateTime($data['LaboratoryResult']['od_observation_end_date_time']);
			}else{
				$orderend_dateTime='';
			}
			if(!empty($data['LaboratoryResult']['od_observation_start_date_time'])){
				$orderstart_dateTime = $this->DBdateTime($data['LaboratoryResult']['od_observation_start_date_time']);
			}else{
				$orderstart_dateTime='';
			}
			
			if($cnt > 0){
				foreach($prevData[LaboratoryHl7Result] as $prevDataObx){
					$prevDataObx = $prevDataObx;
					break;
				}
				$loinc26 = ClassRegistry::init('LoincLnHl7');
				$ServiceData26 = $loinc26->find('first',array('fields'=>array('code','display_name','alternate_identifier'),'conditions'=>array('LoincLnHl7.code'=>$prevData['LaboratoryResult']['od_universal_service_identifier'])));
				
				$Hl7LaboratoryCodedObservation = ClassRegistry::init('Hl7LaboratoryCodedObservation');
				$hl7_coded_observation_option = $Hl7LaboratoryCodedObservation->find('first',array('fields'=>array('value_code','description'),'conditions' => array('value_code'=>$prevDataObx['result'])));
				
				$obx26 = "|".$prevData['LaboratoryResult']['od_universal_service_identifier']."&".$ServiceData26['LoincLnHl7']['display_name']."&LN&".$prevData['LaboratoryResult']['od_universal_service_identifier']."&".$ServiceData26['LoincLnHl7']['display_name']."&99USI^^".$hl7_coded_observation_option['Hl7LaboratoryCodedObservation']['description']."|||^".$prevData['LaboratoryResult']['ogi_filler_order_number']."&LIS&2.16.840.1.113883.3.72.5.25&ISO";
				
			}else{
				if(!empty($data['LaboratoryResult']['od_relevant_clinical_information'])){
					$obx26 = "|";
				}else{
					$obx26 = "";
				}
			}
			
				if(!empty($data['LaboratoryResult']['od_relevant_clinical_information'])){
					$static= $obx26."|||||V1586^HX-contact/exposure lead^I9CDX^LEAD^Lead exposure^L^29^V1|111&Varma&Raja&Rami&JR&DR&PHD&&NIST_Sending_App&2.16.840.1.113883.3.72.5.21&ISO";
				}else{
					$static = $obx26;
				}
				
				$obrCnt = $cnt + 1;
				if($cnt > 0){
					$obr2="";
				}else{	
					if(!empty($data['LaboratoryResult']['ogi_placer_order_number']))
					$obr2 = $data['LaboratoryResult']['ogi_placer_order_number']."^NIST_Placer _App^2.16.840.1.113883.3.72.5.24^ISO";
				}
				$obr3 = $data['LaboratoryResult']['ogi_filler_order_number']."^NIST_Sending_App^2.16.840.1.113883.3.72.5.24^ISO";
				if($data['LaboratoryResult']['od_universal_service_identifier'] == 'AHEPR')
					$obr4 = $data['LaboratoryResult']['od_universal_service_identifier']."^".$ServiceData['LoincLnHl7']['display_name']."^99USI";
				else 
					$obr4 = $data['LaboratoryResult']['od_universal_service_identifier']."^".$ServiceData['LoincLnHl7']['display_name']."^LN^".$data['LaboratoryResult']['od_universal_service_identifier']."^".$ServiceData['LoincLnHl7']['display_name']."^99USI^2.40^1.2";
				$obr16 = "111111111^Bloodraw^Leonard^T^JR^DR^^^NPI&2.16.840.1.113883.4.6&ISO^L^^^NPI^NPI_Facility&2.16.840.1.113883.3.72.5.26&ISO^^^^^^^MD";
				$obr17 = "^WPN^PH^^1^555^7771234^11^Hospital Line~^WPN^PH^^1^555^2271234^4^Office Phone";
				$obr22 = $this->DBdateTime($data['LaboratoryResult']['create_time']);
				$OBR = "OBR|".$obrCnt."|".$obr2."|".$obr3."|".$obr4."|||".$orderstart_dateTime."|".$orderend_dateTime."|||||".$data['LaboratoryResult']['od_relevant_clinical_information']."|||".$obr16."|".$obr17."|||||".$obr22."|||".$data['LaboratoryResult']['ori_result_status'].$static;
			
			
			return $OBR;
		}
	}

		public function generateIPDtoOPDOBX($data,$newDate){

			$session = new cakeSession();
		$loinc = ClassRegistry::init('LoincLnHl7');
		$Ucums = ClassRegistry::init('Ucums');
		$data1=$data;
		

			$cntr = 1;
		foreach($data[LaboratoryHl7Result] as $data){
			$this->obxCounter++;
			$ServiceData = $loinc->find('first',array('fields'=>array('code','display_name','alternate_identifier'),'conditions'=>array('LoincLnHl7.code'=>$data['observations'])));
			$ucum = $Ucums->find('first',array('fields'=>array('code','display_name'),'conditions'=>array('Ucums.code'=>$data['uom'])));

			if(!empty($ServiceData['LoincLnHl7']['code'])){
				if(empty($ServiceData['LoincLnHl7']['alternate_identifier'])){
					if(!empty($ServiceData['LoincLnHl7']['code']))
					$obx4 = $ServiceData['LoincLnHl7']['code']."^".$ServiceData['LoincLnHl7']['display_name']."^LN^^^^^^".$ServiceData['LoincLnHl7']['display_name'];
					else 
						$obx4='';
				}else{
					$obx4 = $ServiceData['LoincLnHl7']['code']."^".$ServiceData['LoincLnHl7']['display_name']."^LN^".$ServiceData['LoincLnHl7']['code']."^".$ServiceData['LoincLnHl7']['display_name']."^99USI^^^".$ServiceData['LoincLnHl7']['display_name'];
				}
				
			}
			if(!empty($ucum['Ucums']['code']) && !empty($ucum['Ucums']['display_name']))
				$obx6 = $ucum['Ucums']['code']."^".$ucum['Ucums']['display_name']."^UCUM";
			else 
				$obx6="";
			
			if(!empty($newDate)){
				$date_time_of_observation = $this->DBdateTime($newDate);
			}else{
				$date_time_of_observation = '';
			}
			if(!empty($data['create_time'])){
				$create_time = $this->DBdateTime($data['create_time']);
			}else{
				$create_time = '';
			}
			$snVal='';
			if(!empty($data['sn_value'])){
				$snVal = $data['sn_value'];//."^";
			}
			if(!empty($data['unit']) && ($data['unit'] =='CWE')){
				$SnomedSctHl7 = ClassRegistry::init('SnomedSctHl7');
				$SnomedSctHl7 = $SnomedSctHl7->find('first',array('fields'=>array('SnomedSctHl7.code','SnomedSctHl7.display_name','SnomedSctHl7.alternate_identifier'),'conditions'=>array('SnomedSctHl7.code'=>$data['result'])));
				$obx5= $SnomedSctHl7['SnomedSctHl7']['code']."^".$SnomedSctHl7['SnomedSctHl7']['display_name']."^SCT^".$SnomedSctHl7['SnomedSctHl7']['code']."^".$SnomedSctHl7['SnomedSctHl7']['display_name']."^99USI^^^".$SnomedSctHl7['SnomedSctHl7']['display_name'];
			}else if(!empty($data['unit']) && ($data['unit'] =='SN')){
				$obx5 = $snVal."^".$data['result'];
			}else{
				$obx5 =$data['result'];
			}
			if(($cntr == 8) && ($ServiceData['LoincLnHl7']['code'] == '16128-1')){
				$OBX .= "OBX|8|CWE|16128-1^Hepatitis C virus Ab [Presence] in Serum^LN^16128^Hepatitis C antibody screen  (anti-HCV)^L||10828004^Positive (qualifier value)^SCT^POS^POSITIVE^L^^^Positive (qualifier value)||Negative|A|||F|||".$date_time_of_observation."|||||".$create_time."||||Hope Hospital^^^^^DrmHope Lab^XX^^^5595|2070 Test Park^^Los Angeles^CA^90067^USA^B^^06037|2343242^Knowsalot^Phil^J.^III^Dr.^^^DrMHope Lab^L^^^DN\n";
			}else{
				$OBX .= "OBX|".$cntr."|".$data['unit']."|".$obx4."|".$cntr."|".$obx5."|".$obx6."|".$data['range']."|".$data['abnormal_flag']."|||".$data['status']."|||".$date_time_of_observation."|||||".$create_time."||||Hope Hospital^^^^^DrMHope Lab^XX^^^5595|2070 Test Park^^Los Angeles^CA^90067^USA^B^^06037|2343242^Knowsalot^Phil^J.^III^Dr.^^^DrMHope Lab^L^^^DN\n";
			}
						
			$cntr++;
		}

		return $OBX;


		}


		public function generateELROBX($data,$prevData){
			
			$session = new cakeSession();
			$loinc = ClassRegistry::init('LoincLnHl7');
			$Ucums = ClassRegistry::init('Ucums');
			$Hl7Result = ClassRegistry::init('Hl7LaboratoryCodedObservation');
			$Observation = ClassRegistry::init('ObservationInterpretation0078');
			$Hl7Observation = ClassRegistry::init('Hl7ObservationMethod');

			$static  = "||||University Hospital Chem Lab^L^^^^CLIA&2.16.840.1.113883.4.7&ISO^XX^^^01D1111111|Firstcare Way^Building 2^Harrisburg^PA^17111^USA^L^^42043|1790019875^House^Gregory^F^III^Dr^^^NPI&2.16.840.1.113883.4.6&ISO^L^^^NPI^NPI_Facility&2.16.840.1.113883.3.72.5.26&ISO^^^^^^^MD";
			$cntr = 1;
			$labdata = $data['LaboratoryResult'];
			foreach($data[LaboratoryHl7Result] as $data){
				
				
				$ServiceData = $loinc->find('first',array('fields'=>array('code','display_name','alternate_identifier'),'conditions'=>array('LoincLnHl7.code'=>$data['observations'])));
				$ucum = $Ucums->find('first',array('fields'=>array('code','display_name'),'conditions'=>array('Ucums.code'=>$data['uom'])));
					
				$ObservationData = $Observation->find('first',array('fields'=>array('code','display_name'),'conditions'=>array('ObservationInterpretation0078.code'=>$data['abnormal_flag'])));
				$Hl7ObsData = $Hl7Observation->find('first',array('fields'=>array('value_code','description','code_system'),'conditions'=>array('Hl7ObservationMethod.value_code'=>$data['observation_method'])));

				if(!empty($ServiceData['LoincLnHl7']['code']))
					$obx3 = $ServiceData['LoincLnHl7']['code']."^".$ServiceData['LoincLnHl7']['display_name']."^LN^".$ServiceData['LoincLnHl7']['code']."^".$ServiceData['LoincLnHl7']['display_name']."^99USI^2.40^1.2";
					
				if(!empty($data['uom']))
					$obx6 = $ucum['Ucums']['code']."^".$ucum['Ucums']['display_name']."^UCUM^".$ucum['Ucums']['code']."^".$ucum['Ucums']['display_name']."^99USI^1.1^V1^".$ucum['Ucums']['display_name'];

				if($data['unit']=='SN'){
					$obx5 = $data['sn_value']."^".$data['result']."^".$data['sn_separator']."^".$data['sn_result2'];
					
					if(!empty($data['observation_method']))
						$obx17 = $Hl7ObsData['Hl7ObservationMethod']['value_code']."^".$Hl7ObsData['Hl7ObservationMethod']['description']."^OBSMETHOD^".$Hl7ObsData['Hl7ObservationMethod']['value_code']."^".$Hl7ObsData['Hl7ObservationMethod']['description']."^99USI^20090501^V1^".$Hl7ObsData['Hl7ObservationMethod']['description'];
					else 	
						$obx17 = '';
				}else{
					$Hl7ResultData = $Hl7Result->find('first',array('fields'=>array('value_code','description','code_system'),'conditions'=>array('Hl7LaboratoryCodedObservation.value_code'=>$data['result'])));
					$obx5 = $Hl7ResultData['Hl7LaboratoryCodedObservation']['value_code']."^".$Hl7ResultData['Hl7LaboratoryCodedObservation']['description']."^SCT^".$Hl7ResultData['Hl7LaboratoryCodedObservation']['value_code']."^".$Hl7ResultData['Hl7LaboratoryCodedObservation']['description']."^99USI^TestV1^TestV2^".$Hl7ResultData['Hl7LaboratoryCodedObservation']['description'];
				}
				if(!empty($data['abnormal_flag']))
					$obx8 = $ObservationData['ObservationInterpretation0078']['code']."^".$ObservationData['ObservationInterpretation0078']['display_name']."^HL70078^".$ObservationData['ObservationInterpretation0078']['code']."^".$ObservationData['ObservationInterpretation0078']['display_name']."^99USI^2.7^V1^".$ObservationData['ObservationInterpretation0078']['display_name'];
					
				if(!empty($labdata['od_observation_start_date_time']))
					$obx14 = $this->DBdateTime($prevData['LaboratoryResult']['od_observation_start_date_time']);
				
				$this->counter = $cntr;
				if(empty($labdata['od_universal_service_identifier'])){
					$cntr = 6;
				}
					
				$OBX .= "OBX|".$cntr."|".$data['unit']."|".$obx3."|".$cntr."|".$obx5."|".$obx6."|".$data['range']."|".$obx8."|||".$data['status']."|||".$obx14."|||".$obx17."||".$this->DBdateTime($data['date_time_of_observation']).$static."\n";
				
				if(!empty($data['notes'])){
					$ObxNte = $this->generateELROBXNTE1($data);
					$OBX .= $ObxNte."";
				}
				
				$cntr++;
			}
			return $OBX;
		}
		
		public function generateELROBXNTE1($data){
			$obxNte = "NTE|1|L|".$data['notes']."|RE^Remark^HL70364^^^^2.5.1";
			return $obxNte;
		}

		public function generateHL7NTE($data){

			$session = new cakeSession();
			$NTE = "NTE|1|P|".$data."|RE^Remark^HL70364^C^Comment^L^2.5.1^V1";

			return $NTE;
		}

		public function generateHL7OBXNTE($data){

			$session = new cakeSession();
			$NTE = "NTE|1|L|".$data."|RE^Remark^HL70364";
			
			return $NTE;
		}
		
		public function generateELROBXNTE($data){
		
			$session = new cakeSession();
				$NTE = "NTE|1|L|".$data."|RE^Remark^HL70364";
			
			return $NTE;
		}

		public function generateHL7TQ1($data){
			$session = new cakeSession();
			$start_date = $data['LaboratoryResult']['tqi_start_date_time'];
			$end_date = $data['LaboratoryResult']['tqi_end_date_time'];
			$TQ1 = "TQ1|1||||||".$this->DBdateTime($start_date)."|".$this->DBdateTime($end_date);

			return $TQ1;
		}

		public function generateELRSPM($data){

			$session = new cakeSession();

			$SnomedSctHl7 = ClassRegistry::init('SnomedSctHl7');
			$SnomedSctHl7 = $SnomedSctHl7->find('first',array('fields'=>array('SnomedSctHl7.code','SnomedSctHl7.display_name','SnomedSctHl7.alternate_identifier'),'conditions'=>array('SnomedSctHl7.code'=>$data['LaboratoryResult']['si_specimen_type'])));
			$SnomedSct= $SnomedSctHl7['SnomedSctHl7']['code']."^".$SnomedSctHl7['SnomedSctHl7']['display_name']."^SCT^".$SnomedSctHl7['SnomedSctHl7']['alternate_identifier']."^".$SnomedSctHl7['SnomedSctHl7']['display_name']."^99USI^^^".$data['LaboratoryResult']['si_specimen_original_text'];
			//$SnomedSctHl7New = ClassRegistry::init('SnomedSctHl7');
			//$SnomedSctHl7Spm6 = $SnomedSctHl7New->find('first',array('fields'=>array('SnomedSctHl7.code','SnomedSctHl7.display_name','SnomedSctHl7.alternate_identifier'),'conditions'=>array('SnomedSctHl7.code'=>$data['LaboratoryResult']['si_specimen_col_method'])));
			
			//$SpecimenRejection = ClassRegistry::init('SpecimenRejection');
			//$SpecimenRejection = $SpecimenRejection->find('first',array('fields'=>array('SpecimenRejection.value_code','SpecimenRejection.description'),'conditions'=>array('SpecimenRejection.value_code'=>$data['LaboratoryResult']['si_specimen_reject_reason'])));
		//	if(!empty($data['LaboratoryResult']['si_specimen_reject_reason']))
			//	$SpecimenRejection =  $SpecimenRejection['SpecimenRejection']['value_code']."^".$SpecimenRejection['SpecimenRejection']['description']."^HL70490^".$SpecimenRejection['SpecimenRejection']['alternate_identifier']."^".$SpecimenRejection['SpecimenRejection']['description']."^99USI^^^".$data['LaboratoryResult']['si_alt_specimen_reject_reason'];

			$SpecimenCondition = ClassRegistry::init('SpecimenCondition');
			$SpecimenCondition = $SpecimenCondition->find('first',array('fields'=>array('SpecimenCondition.value_code','SpecimenCondition.description'),'conditions'=>array('SpecimenCondition.value_code'=>$data['LaboratoryResult']['si_specimen_condition'])));
			$SpecimenCondition = $SpecimenCondition['SpecimenCondition']['value_code']."^".$SpecimenCondition['SpecimenCondition']['description']."^HL70493^".$SpecimenCondition['SpecimenCondition']['value_code']."^".$SpecimenCondition['SpecimenCondition']['description']."^99USI^^^".$data['LaboratoryResult']['si_condition_original_text'];
			if(empty($data['LaboratoryResult']['si_start_date_time'])){
				$SPM = "SPM|1|||".$SnomedSct."|||||||||||||||||".$SpecimenRejection."|||".$SpecimenCondition;
			}else{
				$SPM = "SPM|1|||".$SnomedSct."|||||||||||||".$this->DBdateTime($data['LaboratoryResult']['si_start_date_time'])."||||".$SpecimenRejection."|||".$SpecimenCondition;
			}
			$Specimen_role = ClassRegistry::init('Specimen_role');
			$Specimen_role = $Specimen_role->find('first',array('fields'=>array('Specimen_role.value_code','Specimen_role.description','Specimen_role.code_system'),'conditions'=>array('Specimen_role.value_code'=>$data['LaboratoryResult']['si_specimen_role'])));
			$ModifierOrQualifier = ClassRegistry::init('PHVS_ModifierOrQualifier_CDC');

			$body_site_options = ClassRegistry::init('Body_site_value_set');
			$body_site_options = $body_site_options->find('first',array('fields' => array('value_code','description'),'conditions'=>array('value_code'=>$data['LaboratoryResult']['si_specimen_source'])));
			$specimenType = ClassRegistry::init('SnomedSctHl7');
			$specimenType= $specimenType->find('first',array('fields' => array('code','display_name'),'conditions'=>array('code'=>$data['LaboratoryResult']['si_specimen_col_method'])));
			$specimen_acti = ClassRegistry::init('Specimen_activities');
			$specimen_acti = $specimen_acti->find('first',array('fields' => array('value_code','description'),'conditions'=>array('value_code'=>$data['LaboratoryResult']['si_specimen_type_activities'])));

			$callers=debug_backtrace(null,2);
			if($callers[1]['function'] == 'genrateHL7ELR'){
					
				$spm2 =  "^".$data['LaboratoryResult']['si_entity_identifier']."&Filler_LIS&2.16.840.1.113883.3.72.5.21&ISO";
				if(!empty($data['LaboratoryResult']['si_specimen_type']))
					$spm4 =  $SnomedSctHl7['SnomedSctHl7']['code']."^".$SnomedSctHl7['SnomedSctHl7']['display_name']."^SCT^".$SnomedSctHl7['SnomedSctHl7']['code']."^".$SnomedSctHl7['SnomedSctHl7']['display_name']."^99USI^STV1^STAV1^".$SnomedSctHl7['SnomedSctHl7']['display_name'];
					
				if(!empty($data['LaboratoryResult']['si_specimen_type_modifier'])){
					$ModifierOrQualifier = $ModifierOrQualifier->find('first',array('fields'=>array('PHVS_ModifierOrQualifier_CDC.value_code','PHVS_ModifierOrQualifier_CDC.description'),'conditions'=>array('PHVS_ModifierOrQualifier_CDC.value_code'=>$data['LaboratoryResult']['si_specimen_type_modifier'])));
					$spm5 =  $ModifierOrQualifier['PHVS_ModifierOrQualifier_CDC']['value_code']."^".$ModifierOrQualifier['PHVS_ModifierOrQualifier_CDC']['description']."^SCT^".$ModifierOrQualifier['PHVS_ModifierOrQualifier_CDC']['value_code']."^".$ModifierOrQualifier['PHVS_ModifierOrQualifier_CDC']['description']."^99USI^STMV1^STMAV1^".$ModifierOrQualifier['PHVS_ModifierOrQualifier_CDC']['description'];
				}
					
				if(!empty($data['LaboratoryResult']['si_specimen_type_activities']))
					$spm6 =  $specimen_acti['Specimen_activities']['value_code']."^".$specimen_acti['Specimen_activities']['description']."^HL70371^".$specimen_acti['Specimen_activities']['value_code']."^".$specimen_acti['Specimen_activities']['description']."^99USI^SAV1^SAAV1^".$specimen_acti['Specimen_activities']['description'];
					
				if(!empty($data['LaboratoryResult']['si_specimen_col_method'])){
					if($data['LaboratoryResult']['si_specimen_col_method'] == 'VENIP')
						$spm7 =  $specimenType['SnomedSctHl7']['code']."^".$specimenType['SnomedSctHl7']['display_name']."^HL70488^".$specimenType['SnomedSctHl7']['code']."^".$specimenType['SnomedSctHl7']['display_name']."^99USI^SCMV1^SCMAV1^".$specimenType['SnomedSctHl7']['display_name'];
					else 
						$spm7 =  $specimenType['SnomedSctHl7']['code']."^".$specimenType['SnomedSctHl7']['display_name']."^SCT^".$specimenType['SnomedSctHl7']['code']."^".$specimenType['SnomedSctHl7']['display_name']."^99USI^SCMV1^SCMAV1^".$specimenType['SnomedSctHl7']['display_name'];
				}	
				if(!empty($data['LaboratoryResult']['si_specimen_source']))
					$spm8 =  $body_site_options['Body_site_value_set']['value_code']."^".$body_site_options['Body_site_value_set']['description']."^SCT^".$body_site_options['Body_site_value_set']['value_code']."^".$body_site_options['Body_site_value_set']['description']."^99USI^SSSV1^SSSAV1^".$body_site_options['Body_site_value_set']['description'];
					
				if(!empty($data['LaboratoryResult']['si_specimen_source_modifier'])){
					$ModifierOrQualifier = ClassRegistry::init('PHVS_ModifierOrQualifier_CDC');
					$ModifierOrQualifier = $ModifierOrQualifier->find('first',array('fields'=>array('PHVS_ModifierOrQualifier_CDC.value_code','PHVS_ModifierOrQualifier_CDC.description'),'conditions'=>array('PHVS_ModifierOrQualifier_CDC.value_code'=>$data['LaboratoryResult']['si_specimen_source_modifier'])));
					$spm9 =  $ModifierOrQualifier['PHVS_ModifierOrQualifier_CDC']['value_code']."^".$ModifierOrQualifier['PHVS_ModifierOrQualifier_CDC']['description']."^SCT^".$ModifierOrQualifier['PHVS_ModifierOrQualifier_CDC']['value_code']."^".$ModifierOrQualifier['PHVS_ModifierOrQualifier_CDC']['description']."^99USI^SSSMV1^SSSMAV1^".$ModifierOrQualifier['PHVS_ModifierOrQualifier_CDC']['description'];
				}
					
				if(!empty($data['LaboratoryResult']['si_specimen_role']))
					$spm11 = $Specimen_role['Specimen_role']['value_code']."^".$Specimen_role['Specimen_role']['description']."^HL70369^".$Specimen_role['Specimen_role']['value_code']."^".$Specimen_role['Specimen_role']['description']."^99USI^SRV1^SRAV1^".$Specimen_role['Specimen_role']['description'];
					
				if(!empty($data['LaboratoryResult']['si_specimen_col_quantity']))
					$spm12 = $data['LaboratoryResult']['si_specimen_col_quantity']."^{#}&Number&UCUM&unit&unit&L&1.1&V1";
				
				if(!empty($data['LaboratoryResult']['si_start_date_time'])){
					$spm17 = $this->DBdateTime($data['LaboratoryResult']['si_start_date_time']);
				}	
				
				if(!empty($data['LaboratoryResult']['si_end_date_time'])){
					$spm17 .= "^".$this->DBdateTime($data['LaboratoryResult']['si_end_date_time']);
				}
			
				if(!empty($data['LaboratoryResult']['si_received_date_time']))
					$lastDate = "|".$this->DBdateTime($data['LaboratoryResult']['si_received_date_time']);
				else
					$lastDate = "";
				$SPM = "SPM|1|".$spm2."||".$spm4."|".$spm5."|".$spm6."|".$spm7."|".$spm8."|".$spm9."||".$spm11."|".$spm12."|||||".$spm17.$lastDate;
			}

			return $SPM;
		}

		public function generateHL7OBX($data){

			$session = new cakeSession();
			$laboratory = ClassRegistry::init('Laboratory');
			$labToken = ClassRegistry::init('LaboratoryToken');


			$ServiceData = $laboratory->find('first',array('fields'=>array('name','lonic_code'),'conditions'=>array('Laboratory.lonic_code'=>$data['LaboratoryResult']['od_universal_service_identifier'])));
			$LabTokenData = $labToken->find('first',array('fields'=>array('patient_id','create_time'),'conditions'=>array('LaboratoryToken.patient_id'=>$data['LaboratoryResult']['patient_id'])));


			$obx_data=array();
			foreach($data as $dt1){
					
				$observation = $dt1['observations'];
				$labLoinc = ClassRegistry::init('LoincLnHl7');
				$labUcum = ClassRegistry::init('Ucums');
				$labResult = ClassRegistry::init('LaboratoryResult');
				$labTestOrder = ClassRegistry::init('LaboratoryTestOrder');
				$Observation = ClassRegistry::init('ObservationInterpretation0078');
				$Hl7Observation = ClassRegistry::init('Hl7ObservationMethod');
				$Hl7Result = ClassRegistry::init('Hl7LaboratoryCodedObservation');
				$LoincData = $labLoinc->find('first',array('fields'=>array('code','display_name'),'conditions'=>array('LoincLnHl7.code'=>$observation)));
				$loinc_name = $LoincData['LoincLnHl7']['display_name'];
				$result = $dt1['result'];

				$uom = $dt1['uom'];
				$UcumData = $labUcum->find('first',array('fields'=>array('code','display_name'),'conditions'=>array('Ucums.code'=>$uom)));
				//print_r($UcumData);
				$ucum_name = $UcumData['Ucums']['display_name'];
				$range = $dt1['range'];
				$flag = $dt1['abnormal_flag'];
				$status = $dt1['status'];

				$LabResultData = $labResult->find('first',array('fields'=>array('*'),'conditions'=>array('LaboratoryResult.id'=>$dt1['laboratory_result_id'])));
				//print_r($LabResultData);
				$lab_obsDate = $LabResultData['LaboratoryResult']['tqi_start_date_time'];
				$lab_result_id = $LabResultData['LaboratoryResult']['laboratory_test_order_id'];
				$lab_name = $LabResultData['LaboratoryResult']['rpl_laboratory_name'];
				$lab_address = $LabResultData['LaboratoryResult']['rpl_address'];
				$LabTestOrderData = $labTestOrder->find('first',array('fields'=>array('order_id','create_time'),'conditions'=>array('LaboratoryTestOrder.id'=>$lab_result_id)));
				$ObservationData = $Observation->find('first',array('fields'=>array('code','display_name'),'conditions'=>array('ObservationInterpretation0078.code'=>$flag)));
				//print_r($ObservationData);
				$flag_name = $ObservationData['ObservationInterpretation0078']['display_name'];
				$labTestOrderTime = $LabTestOrderData['LaboratoryTestOrder']['create_time'];
				$sn_value = $dt1['sn_value'];
				$city = $LabResultData['LaboratoryResult']['rpl_city'];
				$state = $LabResultData['LaboratoryResult']['rpl_state'];
				$zip = $LabResultData['LaboratoryResult']['rpl_zip'];
				$country = $LabResultData['LaboratoryResult']['rpl_country'];
				$director_id = $LabResultData['LaboratoryResult']['rpl_director_identifier'];
				$director_first_name = $LabResultData['LaboratoryResult']['rpl_director_name'];
				$director_middle_name = $LabResultData['LaboratoryResult']['rpl_director_middle_name'];
				$director_last_name = $LabResultData['LaboratoryResult']['rpl_director_last_name'];
				$director_initial = $LabResultData['LaboratoryResult']['rpl_initial'];
				$director_legal_name = $LabResultData['LaboratoryResult']['rpl_legal_name'];
				$director_education = $LabResultData['LaboratoryResult']['rpl_director_edu'];
				$director_suffix = $LabResultData['LaboratoryResult']['rpl_director_suffix'];
				$organisation_identifier = $LabResultData['LaboratoryResult']['rpl_organization_identifier'];
				$obs_method = $dt1['observation_mehtod'];
				$Hl7ObsData = $Hl7Observation->find('all',array('fields'=>array('value_code','description','code_system'),'conditions'=>array('Hl7ObservationMethod.value_code'=>$obs_method)));

				$obs_method_description = $Hl7ObsData[0]['Hl7ObservationMethod']['description'];
				$obs_method_code = $Hl7ObsData[0]['Hl7ObservationMethod']['code_system'];
				$alt_identifier = $dt1['alt_identifier'];
				$alt_text = $dt1['alt_text'];
				$alt_coding_name = $dt1['alt_coding_name'];
				$code_system_id = $dt1['code_system_id'];
				$alt_code_system_id = $dt1['alt_code_system_id'];
				$original_text = $dt1['original_text'];
				$lab_name_type = $LabResultData['LaboratoryResult']['rpl_laboratory_legal_name'];
				$lab_identifier_type = $LabResultData['LaboratoryResult']['rpl_laboratory_identifier_type'];
				$address_type = $LabResultData['LaboratoryResult']['rpl_laboratory_address_type'];
				$parish_code = $LabResultData['LaboratoryResult']['rpl_parish_code'];
				$observation_identifier = $dt1['observation_alt_identifier'];
				$observation_alternate_text = $dt1['observation_alt_text'];
				$observation_alternate_name_codesystem = $dt1['observation_alt_coding_name'];
				$observation_code_system_versionid = $dt1['observation_code_system_id'];
				$observation_alt_code_system_versionid = $dt1['observation_alt_code_system_id'];
				$observation_original_text = $dt1['observation_original_text'];
				$Hl7ResultData = $Hl7Result->find('first',array('fields'=>array('value_code','description','code_system'),'conditions'=>array('Hl7LaboratoryCodedObservation.value_code'=>$result)));

				$hl7ResultDescription = $Hl7ResultData['Hl7LaboratoryCodedObservation']['description'];
				$hl7ResultCodeSystem = $Hl7ResultData['Hl7LaboratoryCodedObservation']['code_system'];
				$result_alt_identifier = $dt1['result_alt_identifier'];
				$result_alt_text = $dt1['result_alt_text'];
				$result_alt_coding_name = $dt1['result_alt_coding_name'];
				$result_code_system_id = $dt1['result_code_system_id'];
				$result_alt_code_system_id = $dt1['result_alt_code_system_id'];
				$result_original_text = $dt1['result_original_text'];
				$ucum_alt_identifier = $dt1['ucum_alt_identifier'];
				$ucum_alt_text = $dt1['ucum_alt_text'];
				$ucum_alt_coding_name = $dt1['ucum_alt_coding_name'];
				$ucum_code_system_id = $dt1['ucum_code_system_id'];
				$ucum_alt_code_system_id = $dt1['ucum_alt_code_system_id'];
				$ucum_original_text = $dt1['ucum_original_text'];
				$abnormal_flag_alt_identifier = $dt1['abnormal_flag_alt_identifier'];
				$abnormal_flag_alt_text = $dt1['abnormal_flag_alt_text'];
				$abnormal_flag_alt_coding_name = $dt1['abnormal_flag_alt_coding_name'];
				$abnormal_flag_code_system_id = $dt1['abnormal_flag_code_system_id'];
				$abnormal_flag_alt_code_system_id = $dt1['abnormal_flag_alt_code_system_id'];
				$abnormal_flag_original_text = $dt1['abnormal_flag_original_text'];
				$od_observation_end_date_time = $LabResultData['LaboratoryResult']['od_observation_end_date_time'];
				$lab_address_line_2 = $LabResultData['LaboratoryResult']['rpl_address_line_2'];


					

				if($dt1['unit']=='SN'){
					$OBX .= "<br> OBX|1|".$dt1['unit']."|".$observation."^".$loinc_name."^"."LN^".$observation_identifier."^".$observation_alternate_text."^".$observation_alternate_name_codesystem."^".$observation_code_system_versionid."^".$observation_alt_code_system_versionid."^".$observation_original_text."||".$sn_value."^".$result."|".$uom."^".$ucum_name."^"."UCUM"."^".$ucum_alt_identifier."^".$ucum_alt_text."^".$ucum_alt_coding_name."^".$ucum_code_system_id."^".$ucum_alt_code_system_id."^".$ucum_original_text."|".$range."|".$flag."^".$flag_name."^"."HL70078"."^".$abnormal_flag_alt_identifier."^".$abnormal_flag_alt_text."^".$abnormal_flag_alt_coding_name."^".$abnormal_flag_code_system_id."^".$abnormal_flag_alt_code_system_id."^".$abnormal_flag_original_text."|||".$status."|||".$this->DBdateTime($labTestOrderTime)."|||".$obs_method."^".$obs_method_description."^".$obs_method_code."^".$alt_identifier."^".$alt_text."^".$alt_coding_name."^".$code_system_id."^".$alt_code_system_id."^".$original_text."||".$this->DBdateTime($lab_obsDate)."||||".$lab_name."^".$lab_name_type."^^^^CLIA&2.16.840.1.113883.4.7&ISO^".$lab_identifier_type."^^^".$organisation_identifier."|".$lab_address."^".$lab_address_line_2."^".$city."^".$state."^".$zip."^".$country."^".$address_type."^^".$parish_code."|".$director_id."^".$director_last_name."^".$director_first_name."^".$director_middle_name."^".$director_suffix."^".$director_initial."^^^NPI&2.16.840.1.113883.4.6&ISO"."^".$director_legal_name."^^^NPI^NPI_Facility&2.16.840.1.113883.3.72.5.26&ISO^^^^^^^".$director_education;
				}

				if($dt1['unit']=='CWE'){
					$OBX .= "<br> OBX|1|".$dt1['unit']."|".$observation."^".$loinc_name."^"."LN^".$observation_identifier."^".$observation_alternate_text."^".$observation_alternate_name_codesystem."^".$observation_code_system_versionid."^".$observation_alt_code_system_versionid."^".$observation_original_text."||".$result."^".$hl7ResultDescription."^".$hl7ResultCodeSystem."^".$result_alt_identifier."^".$result_alt_text."^".$result_alt_coding_name."^".$result_code_system_id."^".$result_alt_code_system_id."^".$result_original_text."||".$uom."^".$ucum_name."^".$ucum_alt_identifier."^".$ucum_alt_text."^".$ucum_alt_coding_name."^".$ucum_code_system_id."^".$ucum_alt_code_system_id."^".$ucum_original_text."|".$range."|".$flag."^".$flag_name."^"."^".$abnormal_flag_alt_identifier."^".$abnormal_flag_alt_text."^".$abnormal_flag_alt_coding_name."^".$abnormal_flag_code_system_id."^".$abnormal_flag_alt_code_system_id."^".$abnormal_flag_original_text."|".$status."|||".$this->DBdateTime($labTestOrderTime)."|||".$obs_method."^".$obs_method_description."^".$obs_method_code."^".$alt_identifier."^".$alt_text."^".$alt_coding_name."^".$code_system_id."^".$alt_code_system_id."^".$original_text."||".$od_observation_end_date_time."||||".$lab_name."^".$lab_name_type."^"."CLIA&2.16.840.1.113883.4.7&ISO"."^".$lab_identifier_type."^".$organisation_identifier."|".$lab_address."^".$lab_address_line_2."^^".$city."^".$state."^".$zip."^".$country."^".$address_type."^".$parish_code."|".$director_id."^".$director_last_name."^".$director_first_name."^".$director_middle_name."^".$director_suffix."^".$director_initial."^^^"."NPI&2.16.840.1.113883.4.6&ISO"."^".$director_legal_name."^^^NPI^NPI&2.16.840.1.113883.4.6&ISO^^^^^^^".$director_suffix;
				}
					
			}




			return $OBX;
		}



		public function generateELRPV1($data){
			$data=$data[0];
			$session = new cakeSession();
			if(!empty($data['LaboratoryResult']['admit_date_time']))
				$admitdata = $this->DBdate($data['LaboratoryResult']['admit_date_time']);

			if(!empty($data['LaboratoryResult']['discharge_date_time']))
				$dischargedata = "|".$this->DBdate($data['LaboratoryResult']['discharge_date_time']);
			
			$PV1 ="PV1|1|".$data['LaboratoryResult']['patient_class']."||".$data['LaboratoryResult']['admission_type']."||||||||||||||||||||||||||||||||||||||||".$admitdata.$dischargedata;
			

			return $PV1;

		}

		public function generateELRNK1($person_id){

			$session = new cakeSession();
			$Guardian = ClassRegistry::init('Guardian');
			$Guardian->bindModel(array(
					'belongsTo' => array(
							'Initial' =>array('foreignKey' => false,
									'conditions'=>array('Initial.id=Guardian.guar_initial_id' )),
							'PhvsRelationship' =>array('foreignKey' => false,
									'conditions'=>array('PhvsRelationship.value_code=Guardian.guar_relation' )),

					)),false);
			$guardian_details = $Guardian->find('first',array('conditions'=>array('person_id'=>$person_id)));
			$callers=debug_backtrace(null,2);
			if($callers[1]['function'] == 'genrateHL7ELR'){
				if(empty($guardian_details['Guardian']['guar_company_name'])){
					$nk2 = $guardian_details['Guardian']['guar_last_name']."^".$guardian_details['Guardian']['guar_first_name']."^".substr(ucfirst($guardian_details['Guardian']['guar_middle_name']),0, 1)."^".$guardian_details['Guardian']['guar_suffix']."^".$guardian_details['Initial']['name']."^^".$guardian_details['Guardian']['guar_name_type']."^^^^^^^".$guardian_details['Guardian']['guar_prof_suffix'];
					$nk3 = $guardian_details['PhvsRelationship']['value_code']."^".$guardian_details['PhvsRelationship']['description']."^HL70063^RL^".$guardian_details['PhvsRelationship']['description']."^L^2.5.1^3";

					$nk4 = $guardian_details['Guardian']['guar_address1']."^".$guardian_details['Guardian']['guar_address2']."^".$guardian_details['Guardian']['guar_city']."^".$guardian_details['Guardian']['guar_state']."^".$guardian_details['Guardian']['guar_zip']."^".$guardian_details['Guardian']['guar_country']."^".$guardian_details['Guardian']['guar_address_type']."^^".$guardian_details['Guardian']['guar_parish_code_first'];
					$nk5 = "^".$guardian_details['Guardian']['guar_tele_code']."^".$guardian_details['Guardian']['guar_equi_code']."^".$guardian_details['Guardian']['guar_email']."^".$guardian_details['Guardian']['guar_country_code']."^".$guardian_details['Guardian']['guar_area_code']."^".$guardian_details['Guardian']['guar_localno']."^".$guardian_details['Guardian']['guar_extension']."^".$guardian_details['Guardian']['guar_text']."~^".$guardian_details['Guardian']['guar_tele_code1']."^".$guardian_details['Guardian']['guar_equi_code1']."^".$guardian_details['Guardian']['guar_email1']."^".$guardian_details['Guardian']['guar_contry_code1']."^".$guardian_details['Guardian']['guar_area_code1']."^".$guardian_details['Guardian']['guar_localno1']."^".$guardian_details['Guardian']['guar_extension1']."^".$guardian_details['Guardian']['guar_text1'];
				}else{
					$nk13 = $guardian_details['Guardian']['guar_company_name']."^L^^^^TEST_MPI&2.16.840.1.114222.4.10.3&ISO^XX^^^OID";
					$nk30 = $guardian_details['Guardian']['guar_last_name']."^".$guardian_details['Guardian']['guar_first_name']."^".substr(ucfirst($guardian_details['Guardian']['guar_middle_name']),0, 1)."^".$guardian_details['Guardian']['guar_suffix']."^".$guardian_details['Initial']['name']."^^".$guardian_details['Guardian']['guar_name_type']."^^^^^^^".$guardian_details['Guardian']['guar_prof_suffix'];
					$nk31 = "^".$guardian_details['Guardian']['guar_tele_code']."^".$guardian_details['Guardian']['guar_equi_code']."^".$guardian_details['Guardian']['guar_email']."^".$guardian_details['Guardian']['guar_country_code']."^".$guardian_details['Guardian']['guar_area_code']."^".$guardian_details['Guardian']['guar_localno']."^".$guardian_details['Guardian']['guar_extension']."^".$guardian_details['Guardian']['guar_text'];
					$nk32 = $guardian_details['Guardian']['guar_address1']."^".$guardian_details['Guardian']['guar_address2']."^".$guardian_details['Guardian']['guar_city']."^".$guardian_details['Guardian']['guar_state']."^".$guardian_details['Guardian']['guar_zip']."^".$guardian_details['Guardian']['guar_country']."^".$guardian_details['Guardian']['guar_address_type']."^^".$guardian_details['Guardian']['guar_parish_code_first'];;
				/*if(!empty($guardian_details['Guardian']['guar_company_name'])){
					$compString = "||||||||".$nk13."|||||||||||||||||".$nk30."|".$nk31."|".$nk32;
				}else{
					$compString ="";
				}*/
				}
				
				if(!empty($guardian_details['Guardian']['guar_company_name'])){
					$NK1 ="NK1|1||||||||||||".$nk13."|||||||||||||||||".$nk30."|".$nk31."|".$nk32;
				}else{
					$NK1 ="NK1|1|".$nk2."|".$nk3."|".$nk4."|".$nk5.$compString;
				}
				
			}

			return $NK1;

		}



		public function HL7date($date =null){

			$seperation = explode(" ",$date);

			$output = $seperation[3].date("m", strtotime($seperation[1])).$seperation[2].str_replace(":", "", $seperation[4]).str_replace(array("GMT",":"), "", $seperation[5]);
			return $output;
		}

		public function DBdate($date =null){
			$date =date(r ,strtotime($date));
			$seperation = explode(" ",$date);
			$output = $seperation[3].date("m", strtotime($seperation[2])).$seperation[1];
			return $output;
		}

		public function DBdateTime($date =null){
			$date =date(r ,strtotime($date));
			$seperation = explode(" ",$date); //debug($seperation);
			if($seperation[5] == "+0000") $seperation[5] = "+0530";
			$output = $seperation[3].date("m", strtotime($seperation[2])).$seperation[1].str_replace(":", "", $seperation[4]). $seperation[5];
			return $output;
		}
		
	public function generateHL7SPM($data){
		
			$session = new cakeSession();
		
			$SnomedSctHl7 = ClassRegistry::init('SnomedSctHl7');
			$SnomedSctHl7 = $SnomedSctHl7->find('first',array('fields'=>array('SnomedSctHl7.code','SnomedSctHl7.display_name','SnomedSctHl7.alternate_identifier'),'conditions'=>array('SnomedSctHl7.code'=>$data['LaboratoryResult']['si_specimen_type'])));
			if(!empty($data['LaboratoryResult']['si_specimen_type']) && ($data['LaboratoryResult']['si_specimen_type']=='122554006'))
				$SnomedSct= $SnomedSctHl7['SnomedSctHl7']['code']."^".$SnomedSctHl7['SnomedSctHl7']['display_name']."^SCT";
			if(!empty($data['LaboratoryResult']['si_specimen_type']) && ($data['LaboratoryResult']['si_specimen_type']=='119339001'))
				$SnomedSct= $SnomedSctHl7['SnomedSctHl7']['code']."^".$SnomedSctHl7['SnomedSctHl7']['display_name']."^SCT^^^^^^Stool";	
			else
				$SnomedSct= $SnomedSctHl7['SnomedSctHl7']['code']."^".$SnomedSctHl7['SnomedSctHl7']['display_name']."^SCT^".$SnomedSctHl7['SnomedSctHl7']['alternate_identifier']."^".$SnomedSctHl7['SnomedSctHl7']['display_name']."^99USI^^^".$data['LaboratoryResult']['si_specimen_original_text'];
		
			$SpecimenRejection = ClassRegistry::init('SpecimenRejection');
			$SpecimenRejection = $SpecimenRejection->find('first',array('fields'=>array('SpecimenRejection.value_code','SpecimenRejection.description','SpecimenRejection.alternate_identifier'),'conditions'=>array('SpecimenRejection.value_code'=>$data['LaboratoryResult']['si_specimen_reject_reason'])));
			
			if(!empty($data['LaboratoryResult']['si_specimen_reject_reason']))
				$SpecimenRejection =  $SpecimenRejection['SpecimenRejection']['value_code']."^".$SpecimenRejection['SpecimenRejection']['description']."^HL70490^".$SpecimenRejection['SpecimenRejection']['alternate_identifier']."^".$SpecimenRejection['SpecimenRejection']['description']."^99USI^^^".$data['LaboratoryResult']['si_reject_reason_original_text'];
			else 
				$SpecimenRejection="";
			$SpecimenCondition = ClassRegistry::init('SpecimenCondition');
			$SpecimenCondition = $SpecimenCondition->find('first',array('fields'=>array('SpecimenCondition.value_code','SpecimenCondition.description','SpecimenCondition.alternate_identifier'),'conditions'=>array('SpecimenCondition.value_code'=>$data['LaboratoryResult']['si_specimen_condition'])));
			if(!empty($SpecimenCondition['SpecimenCondition']['value_code']) && !empty($SpecimenCondition['SpecimenCondition']['description']))
				$SpecimenCondition = $SpecimenCondition['SpecimenCondition']['value_code']."^".$SpecimenCondition['SpecimenCondition']['description']."^HL70493^".$SpecimenCondition['SpecimenCondition']['alternate_identifier']."^".$SpecimenCondition['SpecimenCondition']['description']."^99USI^^^".$data['LaboratoryResult']['si_condition_original_text'];
			else 
				$SpecimenCondition = "";
			if($SpecimenCondition !="" && $SpecimenRejection !=""){
				$jointConRej = "||||".$SpecimenRejection."|||".$SpecimenCondition;
			}else if ($SpecimenRejection !='' && $SpecimenCondition == ''){
				$jointConRej = "||||".$SpecimenRejection;
			}else if ($SpecimenRejection =='' && $SpecimenCondition != ''){
				$jointConRej = "||||".$SpecimenRejection."|||".$SpecimenCondition;
			}
			
			if(empty($data['LaboratoryResult']['si_start_date_time'])){
				$SPM = "SPM|1|||".$SnomedSct."|||||||||||||".$jointConRej;
			}else{
				$SPM = "SPM|1|||".$SnomedSct."|||||||||||||".$this->DBdateTime($data['LaboratoryResult']['si_start_date_time']).$jointConRej;
			}
			$Specimen_role = ClassRegistry::init('Specimen_role');
			$Specimen_role = $Specimen_role->find('first',array('fields'=>array('Specimen_role.value_code','Specimen_role.description','Specimen_role.code_system'),'conditions'=>array('Specimen_role.value_code'=>$data['LaboratoryResult']['si_specimen_role'])));
			$ModifierOrQualifier = ClassRegistry::init('PHVS_ModifierOrQualifier_CDC');
		
			$body_site_options = ClassRegistry::init('Body_site_value_set');
			$body_site_options = $body_site_options->find('first',array('fields' => array('value_code','description'),'conditions'=>array('value_code'=>$data['LaboratoryResult']['si_specimen_source'])));
			$specimenType = ClassRegistry::init('SnomedSctHl7');
			$specimenType= $specimenType->find('first',array('fields' => array('code','display_name'),'conditions'=>array('code'=>$data['LaboratoryResult']['si_specimen_col_method'])));
			$specimen_acti = ClassRegistry::init('Specimen_activities');
			$specimen_acti = $specimen_acti->find('first',array('fields' => array('value_code','description'),'conditions'=>array('value_code'=>$data['LaboratoryResult']['si_specimen_type_activities'])));
		
		
			return $SPM;
		}
		
		public function getCount(){
			$hl7Message = ClassRegistry::init('Hl7Message');
			$count = $hl7Message->find('count');
			$count++;
			return $count;
		}
	}
	?>
