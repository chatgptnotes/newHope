<?php
/**
 * InterfaceEngine Model
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       InterfaceEngine Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
class InterfaceEngine extends AppModel {

	public $specific = true;
	public $name = 'InterfaceEngine';
	public $useTable = false;
	public $locationId = 1;
	public $facility = 'DHR';
	public $location = 'DHR';
	//public $database = 'db_HopeHospital_04_03_2014';
	//public $database = 'drm_clinic';
	//public $database = 'drm_staging';
	public $database = 'drm_production';

	public $persondata;
	public $personAddressdata;
	public $patientdata;
	public $userdata;
	public $labdata;
	public $labChildData;
	public $radData;
	public $insurancedata;
	public $guarantordata;
	public $diagnosisdata;
	public $allergiesdata;
	public $personAlldata;
	public $chiefComplaintdata;
	public $insuranceAlldata;
	public $guarantorAlldata;
	public $patientUid;
	public $LABORUNODES = array();
	public $NTESEG;
	public $nteCounter = 1;
	public $obxSegments;
	public $obxSegmentParserFlag = 0;
	
	
	const SENDTO = 'Paragon';
	const FIELDSEPARATOR = '|';
	const SUBFIELDSEPARATOR = '^';
	const REPETITIONSEPARATOR = '~';
	const ESCAPECHARACTER = '\\';
	const SUBSUBFIELDSEPARATOR = '&';
	const OML_MESSAGE_TYPE = 'ORM';
	const OML_MESSAGE_EVENT_TYPE = 'O01';
	const OML_MESSAGE_STRUCTURE = 'ORM_O01';
	const MESSAGE_PROCESSING_ID = 'P';
	const HL7_VERSION_ID = '2.3.1';
	const HL7_ACkNOWLEDGEMENT_REQUEST_TYPE = 'AL';
	const HL7_SENDING_FACILITY_ID = '8227';
	const HL7_LAB_NAME = 'RENLABS';

	function __construct($id = false, $table = null, $ds = null) {
		//$session = new cakeSession();
		$this->db_name =  $this->database;
		parent::__construct($id, $table, $ds);
	}

	public function __call($method, $arguments=array()) {
		if($arguments){
			return implode(self::FIELDSEPARATOR, $arguments[0]);
		}
	}

	public function createORMMessage($requestData=array()){
		if($requestData){
			$this->getPersonDetailFromPatient($requestData['patientid']);
			$this->personAddressdata = $this->getAddresses($this->persondata['Person']['id'],'Person','Address');
			$this->getLaboratoryDetails($requestData['patientid'],$requestData['labRequestId']);
			$this->getLaboratoryChildDetails($requestData['patientid'],$requestData['labRequestId']);
			$aoeData = unserialize($this->labData['LaboratoryToken']['question']);
			$this->getInsuranceDetails($requestData['patientid']);
			$this->getGuarantorDetails($this->persondata['Person']['id']);
			$this->getDiagnosisDetails($requestData['patientid']);
			$this->getAllergiesDetails($requestData['patientid']);
			$this->getChiefComplaintDetails($requestData['patientid']);
			if($this->patientdata['Patient']['consultant_id'])
				$consultantData = $this->getConsultantDetails($this->patientdata['Patient']['consultant_id']);
			if(!empty($this->labData['LaboratoryToken']['primary_care_pro'])){
				$extData = $this->getIDByValue('user_id','DoctorProfile','doctor_name',trim($this->labData['LaboratoryToken']['primary_care_pro']),'%');
				$extraData = $this->getUserDoctorData($extData);
			}
			
			$msh = array('MSH',
					self::SUBFIELDSEPARATOR.self::REPETITIONSEPARATOR.self::ESCAPECHARACTER.self::SUBSUBFIELDSEPARATOR,
					Configure::read('msh_copia'),
					self::HL7_SENDING_FACILITY_ID,
					$this->getReceivingApplicationName($name),
					$this->getReceivingApplicationName($name),
					$this->getDateTimeOfMessage(),
					'',
					$this->createSubFields(array(self::OML_MESSAGE_TYPE,self::OML_MESSAGE_EVENT_TYPE)),
					$this->messageMSHIdentifier(),
					self::MESSAGE_PROCESSING_ID,
					self::HL7_VERSION_ID
			);
			$mshString = $this->createMSH($msh);
				
			$sft = array('SFT',
					$this->createSubFields(array(Configure::read('sending_facility_name').' Lab',Configure::read('sending_facility_name_type_code'),'','','',
							$this->createFieldSeparators(array(Configure::read('assigning_authority_namespace_id'),Configure::read('assigning_authority_universal_id'),Configure::read('sending_application_universal_id_type'))),
							Configure::read('sft_identifier_type_code'),'','',
							Configure::read('sft_organization_identifier'))),
					Configure::read('sft_version_id'),
					Configure::read('sft_product_name'),
					Configure::read('sft_product_binary_id'),'',
					Configure::read('sft_product_install_date'),
			);
			$pid = array('PID',
					'1',
					$this->createSubFields(array(($this->persondata['Person']['alternate_patient_uid'])?$this->persondata['Person']['alternate_patient_uid']:$this->persondata['Person']['id'],'','',self::HL7_SENDING_FACILITY_ID)),
					$this->createSubFields(array(($this->persondata['Person']['alternate_patient_uid']) ? $this->persondata['Person']['alternate_patient_uid']:$this->persondata['Person']['id'],'','',self::HL7_SENDING_FACILITY_ID,'MRN')),
					'',
					$this->createMultipleSubfields(array($this->createSubFields(array($this->persondata['Person']['last_name'],$this->persondata['Person']['first_name'],$this->persondata['Person']['middle_name'],$this->persondata['Person']['suffix1'],strtoupper(str_replace(".","",$this->getIDByValue('name','Initial','id',$this->persondata['Person']['initial_id']))),'',$this->persondata['Person']['name_type'])),
					$this->createSubFields(array($this->persondata['Person']['alternate_last_name'],$this->persondata['Person']['alternate_first_name'],$this->persondata['Person']['alternate_middle_name'],$this->persondata['Person']['suffix1'],strtoupper(str_replace(".","",$this->getIDByValue('name','Initial','id',$this->persondata['Person']['initial_id']))),'',$this->persondata['Person']['alternate_name_type'])))),
					$this->persondata['Person']['mother_name'],		
					$this->getDateOfBirth($this->persondata['Person']['dob'],true),
					$this->getGenderFromArray($this->persondata['Person']['sex']),
					'',
					$this->createMultipleSubfields($this->getRepetitionSectionFromSystem($this->persondata['Person']['race'], 'value_code' ,array('value_code','alternate_identifier','name_of_coding_system'),'Race')),
					$this->createMultipleSubfields($this->createAdresses(array($this->createSubFields(array($this->persondata['Person']['plot_no'],$this->persondata['Person']['landmark'],$this->persondata['Person']['city'],$this->personAlldata['State']['state_code'],$this->persondata['Person']['pin_code'],$this->personAlldata['Country']['code'],$this->persondata['Person']['person_address_type_first'],'',$this->persondata['Person']['person_parish_code_first']))),$this->personAddressdata)),
					'',
					$this->createMultipleSubfields($this->createPhoneNumbers($this->parsePhoneFromSystem($this->persondata['Person']['person_city_code'].$this->persondata['Person']['person_local_number'],$this->persondata['Person']['person_extension'],'HOME'),$this->personAddressdata,'HOME')),
					$this->createMultipleSubfields($this->createPhoneNumbers(array(),$this->personAddressdata,'WORK',true)),
					strtoupper($this->persondata['Person']['preferred_language']),
					$this->getMarritalStatusFromSystem($this->persondata['Person']['maritail_status']),
					$this->getIDByValue('code','Religion','name',$this->persondata['Person']['religion']),
					$this->createSubFields(array($this->patientdata['Patient']['account_number'],'','',$this->persondata['Person']['assigning_authority'])),
					str_replace("-","",str_replace("-","",str_replace(" ","",str_replace(" ","",$this->persondata['Person']['ssn_us'])))),
					$this->createSubFields(array($this->persondata['Person']['driver2'],$this->getIDByValue('state_code','State','id',$this->persondata['Person']['person_state'],false))),
					'',
					$this->getEthinicityFromSystem($this->persondata['Person']['ethnicity']),
					'',
					'',
					'',
					'',
					'',
					$this->persondata['Person']['nationality'],
					$this->getParsedDate($this->patientdata['Patient']['death_recorded_date']),
					($this->patientdata['Patient']['patientdied'] == '2')?'Y':'N'
			);
			
			$pd1 = array('PD1',
					'1',
					'',
					'',
					$this->createSubFields(array(($extraData['User']['alternate_id'])?$extraData['User']['alternate_id']:$extraData['User']['id'],$extraData['User']['last_name'],$extraData['User']['first_name'],$extraData['User']['middle_name'],$extraData['User']['suffix'])),
					//($consultantData['Consultant']['last_name '])?$this->createSubFields(array($consultantData['Consultant']['id'],$consultantData['Consultant']['last_name'],$consultantData['Consultant']['first_name'],$consultantData['Consultant']['middle_name'],$consultantData['Consultant']['suffix'])):'',
					'',
					$this->patientdata['Patient']['hl7_patient_handicap'],
					'',
					($this->persondata['Person']['organ_donor'] == '1')?'Y':'N',
					'',
					'',
					$this->persondata['Person']['publicity_code'],
					$this->persondata['Person']['protection_indicator'],
					'',
					'',
					$this->persondata['Person']['adv_directive']
			);
			
			$pv1 = array('PV1',
					'1',
					Configure::read('hl7_outbound_orm_patient_class'),
					$this->createSubFields(array(Configure::read('hl7_inbound_adt_identifier'),'','',self::HL7_SENDING_FACILITY_ID)),
					$this->patientdata['Patient']['hl7_admission_type'],
					'',
					'',
					$this->createSubFields(array(($this->userdata['User']['alternate_id'])?$this->userdata['User']['alternate_id']:$this->userdata['User']['id'],$this->userdata['User']['last_name'],$this->userdata['User']['first_name'],$this->userdata['User']['middle_name'],$this->userdata['User']['suffix'],strtoupper(str_replace(".","",$this->getIDByValue('name','Initial','id',$this->userdata['User']['initial_id']))))),
					$this->createSubFields(array(($this->userdata['User']['alternate_id'])?$this->userdata['User']['alternate_id']:$this->userdata['User']['id'],$this->userdata['User']['last_name'],$this->userdata['User']['first_name'],$this->userdata['User']['middle_name'],$this->userdata['User']['suffix'],strtoupper(str_replace(".","",$this->getIDByValue('name','Initial','id',$this->userdata['User']['initial_id']))))),
					$this->createSubFields(array(($this->userdata['User']['alternate_id'])?$this->userdata['User']['alternate_id']:$this->userdata['User']['id'],$this->userdata['User']['last_name'],$this->userdata['User']['first_name'],$this->userdata['User']['middle_name'],$this->userdata['User']['suffix'],strtoupper(str_replace(".","",$this->getIDByValue('name','Initial','id',$this->userdata['User']['initial_id']))))),
					'GFM',
					'',
					'',
					'',
					$this->patientdata['Patient']['hl7_admit_source'],
					'',
					$this->persondata['Person']['vip_indicator'],
					$this->createSubFields(array(($this->userdata['User']['alternate_id'])?$this->userdata['User']['alternate_id']:$this->userdata['User']['id'],$this->userdata['User']['last_name'],$this->userdata['User']['first_name'],$this->userdata['User']['middle_name'],$this->userdata['User']['suffix'],strtoupper(str_replace(".","",$this->getIDByValue('name','Initial','id',$this->userdata['User']['initial_id']))))),
					$this->patientdata['Patient']['hl7_patient_type'],
					'',
					$this->patientdata['Patient']['hl7_financial_class'],
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					$this->patientdata['Patient']['discharge_disposition'],
					$this->patientdata['Patient']['discharge_to_location'],
					'',
					$this->patientdata['Patient']['hl7_servicing_facility'],
					'',
					'',
					'',
					'',
					$this->getParsedDate($this->patientdata['Patient']['form_received_on'],true),
					$this->getParsedDate($this->patientdata['Patient']['discharge_date'],true),
					'',
					'',
					'',
					'',
					'',
					$this->patientdata['Patient']['visit_indicator'],
					
					
			);
			
			$pv2 = array('PV2',
					'',
					'',
					$this->createSubFields(array('',preg_replace('/(\r\n|\r|\n)+/', " ", $this->chiefComplaintdata['Diagnosis']['complaints']))),
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					$this->patientdata['Patient']['visit_publicity_code'],
					$this->patientdata['Patient']['visit_protection_indicator'],
					'',
					$this->patientdata['Patient']['patient_status_code'],
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					$this->patientdata['Patient']['new_born_baby_indicator'],
					'',
					$this->patientdata['Patient']['hl7_mode_of_arrival']
			);
			
			
			$orc = array('ORC',
					Configure::read('hl7_new_order'),
					$this->labData['LaboratoryTestOrder']['order_id'],
					'',
					'',
					'',
					'',
					'',
					'',
					date("YmdHis"),
					$this->labData['LaboratoryTestOrder']['created_by'],
					'',
					$this->createSubFields(array(($extraData['User']['alternate_id'])?$extraData['User']['alternate_id']:$extraData['User']['id'],$extraData['User']['last_name'],$extraData['User']['first_name'],$extraData['User']['middle_name'],$extraData['User']['suffix'])),
					''
					);
			
			$orcString = $this->createORC($orc)."\r";
			
			$obr = array('OBR',
					'1',
					$this->labData['LaboratoryTestOrder']['order_id'],
					'',
					$this->createSubFields(array($this->labData['Laboratory']['dhr_order_code'],$this->labData['Laboratory']['name'])),
					'',
					'',
					date("YmdHis"),
					'',
					'',
					'',
					'',
					'',
					'',
					'',//$this->getParsedDate($this->labData['LaboratoryTestOrder']['collected_date']),
					$this->labData['SpecimenCollectionOption']['name'],
					$this->createSubFields(array(($extraData['User']['alternate_id'])?$extraData['User']['alternate_id']:$extraData['User']['id'],$extraData['User']['last_name'],$extraData['User']['first_name'],$extraData['User']['middle_name'],$extraData['User']['suffix'])),
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					$this->createSubFields(array('',$this->labData['LaboratoryToken']['relevant_clinical_info']))
			);
			$obrString = $this->createOBR($obr)."\r";
			if($this->labData['LaboratoryToken']['relevant_clinical_info']){
				$nte = array('NTE',1,'',$this->labData['LaboratoryToken']['relevant_clinical_info']);
				$obrString = $obrString.$this->createNTE($nte)."\r";
			}
			
			$obrString = $orcString.$obrString;
			$dg1String = '';
			$dg1 = array('DG1',
						'1',
						'ICD9',
						$this->createSubFields(array($this->labData['LaboratoryToken']['icd9_code'],$this->labData['LaboratoryToken']['diagnosis'],'I9C')),
						($this->labData['LaboratoryToken']['diagnosis'])?$this->labData['LaboratoryToken']['diagnosis']:$this->labData['LaboratoryToken']['diagnosis'],
						'',
						'',
						'','','','','','','','',
						''
				);
			$dg1String .= trim($this->createDG1($dg1))."\r";
			$obrString = $obrString.$dg1String;
			
			$obxString = '';
			$cnt = 0;
			foreach($aoeData as $key=>$value){
				$pos = strpos($key, 'drop_down_question_');
				if($pos === false){
					$pos = strpos($key, 'free_text_question_');
					if($pos === false){
						$pos = strpos($key, 'radio_question_');
						$optionIdentifier = explode("radio_question_",$key);
						$dataType = 'CE';
						if($value == 1) $value = 'YES';else $value = 'NO';
					}else{
						$optionIdentifier = explode("free_text_question_",$key);
						$dataType = 'ST';
					}
				}else{
					$optionIdentifier = explode("drop_down_question_",$key);
					$dataType = 'CE';
				}
				App::uses('LaboratoryAoeCode', 'Model');
				$laboratoryAoeCodeModel = new LaboratoryAoeCode(null,null,$this->database);
				$questionData = $laboratoryAoeCodeModel->find('first',array('conditions'=>array('LaboratoryAoeCode.id'=>$optionIdentifier)));
			
				$isDate = stripos($questionData['LaboratoryAoeCode']['question'], 'Date');
				if($isDate === false){
				}else{
					$temps = explode(" ",$value);
					$temp = explode("/",$temps[0]);
					$value = $this->getParsedDate($temp[2].'-'.$temp[0].'-'.$temp[1],false);
					//$dataType = 'ST';
				}
			
				$obx = array('OBX',
						++$cnt,
						$dataType,
						$this->createSubFields(array(strtoupper($questionData['LaboratoryAoeCode']['dhr_obx_code']),strtoupper($questionData['LaboratoryAoeCode']['question']),self::HL7_LAB_NAME)),
						($value)?'':null,
						($value)?$value:null
				);
				$obxString .= trim($this->createOBX($obx))."\r";
			}
			
			$obrString = $obrString.$obxString;
			
			foreach($this->labChildData as $key=>$value){
				$obr = array('OBR',
						(int) ($key+=2),
						$this->labData['LaboratoryTestOrder']['order_id'],
						'',
						$this->createSubFields(array($value['Laboratory']['dhr_order_code'],$value['Laboratory']['name'])),
						'',
						'',
						date("YmdHis"),
						'',
						'',
						'',
						'',
						'',
						'',
						'',//$this->getParsedDate($this->labData['LaboratoryTestOrder']['collected_date']),
						$value['SpecimenCollectionOption']['name'],
						$this->createSubFields(array(($extraData['User']['alternate_id'])?$extraData['User']['alternate_id']:$extraData['User']['id'],$extraData['User']['last_name'],$extraData['User']['first_name'],$extraData['User']['middle_name'],$extraData['User']['suffix'])),
						'',
						'',
						'',
						'',
						'',
						'',
						'',
						'',
						'',
						'',
						'',
						'',
						'',
						'',
						$this->createSubFields(array('',$value['LaboratoryToken']['relevant_clinical_info']))
				);
				$obrString .= $orcString.$this->createOBR($obr)."\r";
				if($value['LaboratoryToken']['relevant_clinical_info']){
					$obrString = $obrString.$this->createNTE($nte)."\r";
				}
				
				
				$dg1String = '';
				$dg1 = array('DG1',
						'1',
						'ICD9',
						$this->createSubFields(array($value['LaboratoryToken']['icd9_code'],$value['LaboratoryToken']['diagnosis'],'I9C')),
						($value['LaboratoryToken']['diagnosis'])?$value['LaboratoryToken']['diagnosis']:$value['LaboratoryToken']['diagnosis'],
						'',
						'',
						'','','','','','','','',
						''
				);
				$dg1String .= trim($this->createDG1($dg1))."\r";
				$obrString = $obrString.$dg1String;
				
				$aoeData = unserialize($value['LaboratoryToken']['question']);
				
				$cnt = 0;
				$obxString='';
				foreach($aoeData as $key=>$aoeValue){
					$pos = strpos($key, 'drop_down_question_');
					if($pos === false){
						$pos = strpos($key, 'free_text_question_');
						if($pos === false){
							$pos = strpos($key, 'radio_question_');
							$optionIdentifier = explode("radio_question_",$key);
							$dataType = 'CE';
							if($aoeValue == 1) $aoeValue = 'YES';else $aoeValue = 'NO';
						}else{
							$optionIdentifier = explode("free_text_question_",$key);
							$dataType = 'ST';
						}
					}else{
						$optionIdentifier = explode("drop_down_question_",$key);
						$dataType = 'CE';
					}
					App::uses('LaboratoryAoeCode', 'Model');
					$laboratoryAoeCodeModel = new LaboratoryAoeCode(null,null,$this->database);
					$questionData = $laboratoryAoeCodeModel->find('first',array('conditions'=>array('LaboratoryAoeCode.id'=>$optionIdentifier)));
						
					$isDate = stripos($questionData['LaboratoryAoeCode']['question'], 'Date');
					if($isDate === false){
					}else{
						$temps = explode(" ",$aoeValue);
						$temp = explode("/",$temps[0]);
						$aoeValue = $this->getParsedDate($temp[2].'-'.$temp[0].'-'.$temp[1],false);
						//$dataType = 'ST';
					}
						
					$obx = array('OBX',
							++$cnt,
							$dataType,
							$this->createSubFields(array(strtoupper($questionData['LaboratoryAoeCode']['dhr_obx_code']),strtoupper($questionData['LaboratoryAoeCode']['question']),self::HL7_LAB_NAME)),
							($aoeValue)?'':null,
							($aoeValue)?$aoeValue:null
					);
					$obxString .= trim($this->createOBX($obx))."\r";
				}
				$obrString = $obrString.$obxString;
				
				
			}
			
			
			//pr($this->insuranceAlldata);exit;
			$in1String = '';
			if(!empty($this->insuranceAlldata)){
				$cnt = 1;
				$insRel = Configure::read('relationship_with_insured');
				$insRelIndex = Configure::read('relationship_with_insured_index');
				foreach($this->insuranceAlldata as $key=>$value){
					$empAddress = explode(",",$value['NewInsurance']['emp_address']);
					$insComAddress = explode(",",$value['InsuranceCompany']['address']);
					$in1 = array('IN1',
							$cnt,
							$value['NewInsurance']['insurance_plan_id'],
							$value['TariffStandard']['payer_id'],
							$value['InsuranceCompany']['name'],
							$this->createSubFields(array(trim($insComAddress['0']),trim($insComAddress['1']),$value['InsuranceCompany']['city_id'],$value['State']['state_code'],$value['InsuranceCompany']['zip'],$value['Country']['code'],$value['InsuranceCompany']['address_type'],'',$value['InsuranceCompany']['country_parish_code'])),
							'',
							$this->parsePhoneFromSystem($value['InsuranceCompany']['phone'],$value['InsuranceCompany']['extension'],$value['InsuranceCompany']['phone_type'],true),
							$value['NewInsurance']['group_number'],
							$value['NewInsurance']['group_name'],
							'',
							'',
							$this->getParsedDate($value['NewInsurance']['effective_date']),
							'',
							$value['NewInsurance']['authorization_information'].$value['NewInsurance']['authorization_number'],
							'',
							$this->createSubFields(array($value['NewInsurance']['subscriber_last_name'],$value['NewInsurance']['subscriber_name'])),
							$this->createSubFields(array($insRelIndex[$value['NewInsurance']['relation']].'/'.$value['NewInsurance']['relation'],$insRel[$value['NewInsurance']['relation']])),
							$this->getParsedDate($value['NewInsurance']['subscriber_dob']),
							$this->createSubFields(array($value['NewInsurance']['subscriber_address1'],$value['NewInsurance']['subscriber_address2'],$value['NewInsurance']['subscriber_city'],$value['InsuredState']['state_code'],$value['NewInsurance']['subscriber_zip'],$value['InsuredCountry']['code'],$value['NewInsurance']['address_type'],'',$value['NewInsurance']['country_parish_code'])),
							$value['NewInsurance']['assignment_of_benefits'],
							$value['NewInsurance']['coordination_of_benefits'],
							$value['NewInsurance']['coordination_of_benefits_priority'],
							'',
							'',
							'',
							'',
							$value['NewInsurance']['realease_information_code'],
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							$value['NewInsurance']['policy_number'],
							'',
							'',
							'',
							'',
							'',
							$this->createSubFields(array($value['NewInsurance']['insured_employment_status'],$value['NewInsurance']['insured_employment_description'])),
							strtoupper($this->getGenderFromArray($value['NewInsurance']['subscriber_gender'])),
							($empAddress['0'])?$this->createSubFields(array($empAddress['0'],trim($empAddress['1']),$value['NewInsurance']['emp_city'],$value['EmployerState']['state_code'],$value['NewInsurance']['emp_zip_code'],$value['EmployerCountry']['code'],$value['NewInsurance']['emp_address_type'],'',$value['NewInsurance']['emp_county_parish_code'])):''
					);
					$in1String .= trim($this->createIN1($in1))."\r".$this->generateIN2($value)."\r";
					$cnt++;
				}
			}
			
			
			$gt1String = $nk1String = '';
			if(!empty($this->guarantorAlldata))	{
				$cnt = $nk1Cnt = 1 ;
				foreach($this->guarantorAlldata as $key=>$value){
					
					if($value['Guarantor']['relation'] == 'CGV'){
						$gurantorAdd = $this->getCaregiverAddresses($value['Guarantor']['id']);
						$guarantorCont = $this->getCaregiverPhones($value['Guarantor']['id']);
						$gt1 = array('GT1',
								$cnt,
								$value['Guarantor']['guarantor_id'],
								$this->createSubFields(array($value['Guarantor']['gau_last_name'],$value['Guarantor']['gau_first_name'],$value['Guarantor']['gau_middle_name'],$value['Guarantor']['gau_suffix'],strtoupper(str_replace(".","",$this->getIDByValue('name','Initial','id',$value['Guarantor']['gau_initial_id']))),'',$value['Guarantor']['gau_name_type'])),
								'',
								$this->createMultipleSubfields($this->createCaregiverAdresses(array($this->createSubFields(array($value['Guarantor']['gau_plot_no'],$value['Guarantor']['gau_landmark'],$value['Guarantor']['gau_city'],$value['State']['state_code'],$value['Guarantor']['gau_zip'],$value['Country']['code'],$value['Guarantor']['gau_address_type'],'',$value['Guarantor']['gau_county']))),$gurantorAdd)),
								$this->createMultipleSubfields($this->createCaregiverPhoneNumbers($this->parsePhoneFromSystem($value['Guarantor']['gau_city_code'].$value['Guarantor']['gau_local_number'],$value['Guarantor']['gau_extension'],'HOME'),$guarantorCont,'HOME',true,'ONLYHOME')),
								$this->createMultipleSubfields($this->createCaregiverPhoneNumbers(array(),$guarantorCont,'WORK','null','ONLYWORK',$cnt)),
								$this->getDateOfBirth($value['Guarantor']['dobg']),
								$this->getGenderFromArray($value['Guarantor']['gau_sex']),
								//$this->createMultipleSubfields($this->createPhoneNumbers($this->parsePhoneFromSystem(
								$value['Guarantor']['gau_gaurantor_type'],
								'',
								str_replace("-","",str_replace("-","",str_replace(" ","",str_replace(" ","",$value['Guarantor']['gau_ssn'])))),	
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								$value['Guarantor']['gau_marital_status'],
								'',
								'',
								'',
								'',
								'',
								strtoupper($this->getIDByValue('language','Language','code',$value['Guarantor']['gau_preferred_language'])),
								'',
								'',
								'',
								'',
								(is_numeric($value['Guarantor']['gau_religion']))?$this->getIDByValue('code','Religion','id',$value['Guarantor']['gau_religion']):$value['Guarantor']['gau_religion'],
								'',
								$value['Guarantor']['gau_nationality']
						);
						$gt1String .= trim($this->createGT1($gt1))."\r";
						$cnt++;
					}else{//if($flag){pr($addessStringArray);exit;}
						
						$gurantorAdd = $this->getCaregiverAddresses($value['Guarantor']['id']);
						$guarantorCont = $this->getCaregiverPhones($value['Guarantor']['id']);
						$nk1 = array('NK1',
								$nk1Cnt,
								$this->createSubFields(array($value['Guarantor']['gau_last_name'],$value['Guarantor']['gau_first_name'],$value['Guarantor']['gau_middle_name'],$value['Guarantor']['gau_suffix'],strtoupper(str_replace(".","",$this->getIDByValue('name','Initial','id',$value['Guarantor']['gau_initial_id']))))),
								$this->getIDByValue('description','PhvsRelationship','value_code',$value['Guarantor']['gau_relation'],false),
								$this->createMultipleSubfields($this->createCaregiverAdresses(array($this->createSubFields(array($value['Guarantor']['gau_plot_no'],$value['Guarantor']['gau_landmark'],$value['Guarantor']['gau_city'],$value['State']['state_code'],$value['Guarantor']['gau_zip'],$value['Country']['code'],$value['Guarantor']['gau_address_type'],'',$value['Guarantor']['gau_county']))),$gurantorAdd,true)),
								$this->createMultipleSubfields($this->createCaregiverPhoneNumbers($this->parsePhoneFromSystem($value['Guarantor']['gau_city_code'].$value['Guarantor']['gau_local_number'],$value['Guarantor']['gau_extension'],'HOME'),$guarantorCont,'HOME',true,'ONLYHOME')),
								$this->createMultipleSubfields($this->createCaregiverPhoneNumbers(array(),$guarantorCont,'WORK','null','ONLYWORK')),
								$this->createSubFields(array($value['Guarantor']['gau_contact_role_identifier'],$value['Guarantor']['gau_contact_role'])),
								$this->getParsedDate($value['Guarantor']['gau_eff_date_add']),
								'',
								'',
								'',
								'',
								'',
								$value['Guarantor']['gau_marital_status'],
								$this->getGenderFromArray($value['Guarantor']['gau_sex']),
								$this->getDateOfBirth($value['Guarantor']['dobg']),
								'',
								'',
								'',
								strtoupper($this->getIDByValue('language','Language','code',$value['Guarantor']['gau_preferred_language'])),
								'',
								'',
								'',
								'',
								(is_numeric($value['Guarantor']['gau_religion']))?$this->getIDByValue('code','Religion','id',$value['Guarantor']['gau_religion']):$value['Guarantor']['gau_religion'],
								'',
								$value['Guarantor']['gau_nationality']
						);
						$nk1String .= trim($this->createNK1($nk1))."\r";
						$nk1Cnt++;
					}
					
				}
			}
			
			
			
			$dg1String = '';
			
			/*foreach($this->diagnosisdata as $key=>$diagnosisData){
				if($diagnosisData['NoteDiagnosis']['diagnosis_type'] && $diagnosisData['NoteDiagnosis']['diagnosis_type'] == 'PD'){
					$priority = '1';
				}else if($diagnosisData['NoteDiagnosis']['diagnosis_type']){
					$priority = '0';
				}
				$dg1 = array('DG1',
					++$key,
					'ICD9',
					$this->createSubFields(array($diagnosisData['NoteDiagnosis']['icd_id'],$diagnosisData['NoteDiagnosis']['diagnoses_name'],'I9C')),
					($diagnosisData['NoteDiagnosis']['diagnosis_description'])?$diagnosisData['NoteDiagnosis']['diagnosis_description']:$diagnosisData['NoteDiagnosis']['diagnoses_name'],
					$this->getParsedDate($diagnosisData['NoteDiagnosis']['start_dt']),
					($diagnosisData['NoteDiagnosis']['hl7_diagnosis_type'])?$diagnosisData['NoteDiagnosis']['hl7_diagnosis_type']:'',
					'','','','','','','','',
					$priority
				);
				$dg1String .= trim($this->createDG1($dg1))."\r";
			}*/
			
			
			$al1String = '';
				
			foreach($this->allergiesdata as $key=>$allergyData){
				$serverity = $allergyData['NewCropAllergies']['AllergySeverityName'];
				
				$al1 = array('AL1',
						++$key,
						'',
						$this->createSubFields(array($allergyData['NewCropAllergies']['CompositeAllergyID'],$allergyData['NewCropAllergies']['name'])),
						$serverity,
						$allergyData['NewCropAllergies']['reaction'],
						$this->getParsedDate($allergyData['NewCropAllergies']['onset_date'])
				);
				$al1String .= trim($this->createAL1($al1))."\r";
			}
			//pr($aoeData);exit;
			
			
			
			$pd1String = $this->createPD1($pd1);
			$dg1String = rtrim($dg1String, " \r");
			$sftString = $this->createSFT($sft);
			$pidString = $this->createPID($pid);
			$pv1String = $this->createPV1($pv1);
			$pv2String = $this->createPV2($pv2);
			
			
			//$in1String = $this->createIN1($in1);
			//$gt1String = $this->createGT1($gt1);
			$pd1String = $this->createPD1($pd1);
			
			
			$message = trim($mshString)."\r".trim($pidString)."\r";
			
				
			if($pd1String){
				$message .= trim($pd1String)."\r";
			}
			if($nk1String){
				$message .= trim($nk1String)."\r";
			}
			if($pv1String){
				$message .= trim($pv1String)."\r";
			}
			//if($pv2String){
				//$message .= trim($pv2String)."\r";
			//}
			if($in1String){
				$message .= trim($in1String)."\r";
			}
			if($gt1String){
				$message .= trim($gt1String)."\r";
			}
			if($al1String){
				$message .= trim($al1String)."\r";
			}
			if($orcString){
				//$message .= trim($orcString)."\r";
			}
			if($obrString){
				$message .= trim($obrString)."\r";
			}
			if($obxString){
				//$message .= trim($obxString)."\r";
			}
			if($dg1String){
				$message .= trim($dg1String)."\r";
			}
			//$message = substr($message,0,(strlen($message) - 4));
			$message = rtrim($message, " \r");
			echo (trim($message));//exit;
			$flag = $this->saveMessage($message, 'ORM', 'OUTBOUND');
			return $flag;
		}

	}
		
	public function createRadORMMessage($requestData=array()){
	if($requestData){
		$this->getPersonDetailFromPatient($requestData['patientid']);
		$this->personAddressdata = $this->getAddresses($this->persondata['Person']['id'],'Person','Address');
		$this->getRadiologyDetails($requestData['patientid'],$requestData['radRequestId']);
		$this->getInsuranceDetails($requestData['patientid']);
		$this->getGuarantorDetails($this->persondata['Person']['id']);
		$this->getAllergiesDetails($requestData['patientid']);
		$this->getChiefComplaintDetails($requestData['patientid']);
		if($this->patientdata['Patient']['consultant_id'])
			$consultantData = $this->getConsultantDetails($this->patientdata['Patient']['consultant_id']);
		if(!empty($this->radData['RadiologyTestOrder']['primary_care_pro'])){
			$extData = $this->getIDByValue('user_id','DoctorProfile','doctor_name',trim($this->radData['RadiologyTestOrder']['primary_care_pro']),'%');
			$extraData = $this->getUserDoctorData($extData);
		}

		$msh = array('MSH',
				self::SUBFIELDSEPARATOR.self::REPETITIONSEPARATOR.self::ESCAPECHARACTER.self::SUBSUBFIELDSEPARATOR,
				Configure::read('msh_paragon'),
				self::HL7_SENDING_FACILITY_ID,
				$this->getReceivingApplicationName($name),
				$this->getReceivingApplicationName($name),
				$this->getDateTimeOfMessage(),
				'',
				$this->createSubFields(array(self::OML_MESSAGE_TYPE,self::OML_MESSAGE_EVENT_TYPE)),
				$this->messageMSHIdentifier(),
				self::MESSAGE_PROCESSING_ID,
				self::HL7_VERSION_ID
		);
		$mshString = $this->createMSH($msh);

		$sft = array('SFT',
				$this->createSubFields(array(Configure::read('sending_facility_name').' Lab',Configure::read('sending_facility_name_type_code'),'','','',
						$this->createFieldSeparators(array(Configure::read('assigning_authority_namespace_id'),Configure::read('assigning_authority_universal_id'),Configure::read('sending_application_universal_id_type'))),
						Configure::read('sft_identifier_type_code'),'','',
						Configure::read('sft_organization_identifier'))),
				Configure::read('sft_version_id'),
				Configure::read('sft_product_name'),
				Configure::read('sft_product_binary_id'),'',
				Configure::read('sft_product_install_date'),
		);
		$pid = array('PID',
				'1',
				$this->createSubFields(array(($this->persondata['Person']['alternate_patient_uid'])?$this->persondata['Person']['alternate_patient_uid']:$this->persondata['Person']['id'],'','',self::HL7_SENDING_FACILITY_ID)),
				$this->createSubFields(array(($this->persondata['Person']['alternate_patient_uid']) ? $this->persondata['Person']['alternate_patient_uid']:$this->persondata['Person']['id'],'','',self::HL7_SENDING_FACILITY_ID,'MRN')),
				'',
				$this->createMultipleSubfields(array($this->createSubFields(array($this->persondata['Person']['last_name'],$this->persondata['Person']['first_name'],$this->persondata['Person']['middle_name'],$this->persondata['Person']['suffix1'],strtoupper(str_replace(".","",$this->getIDByValue('name','Initial','id',$this->persondata['Person']['initial_id']))),'',$this->persondata['Person']['name_type'])),
				$this->createSubFields(array($this->persondata['Person']['alternate_last_name'],$this->persondata['Person']['alternate_first_name'],$this->persondata['Person']['alternate_middle_name'],$this->persondata['Person']['suffix1'],strtoupper(str_replace(".","",$this->getIDByValue('name','Initial','id',$this->persondata['Person']['initial_id']))),'',$this->persondata['Person']['alternate_name_type'])))),
				$this->persondata['Person']['mother_name'],
				$this->getDateOfBirth($this->persondata['Person']['dob'],true),
				$this->getGenderFromArray($this->persondata['Person']['sex']),
				'',
				$this->createMultipleSubfields($this->getRepetitionSectionFromSystem($this->persondata['Person']['race'], 'value_code' ,array('value_code','alternate_identifier','name_of_coding_system'),'Race')),
				$this->createMultipleSubfields($this->createAdresses(array($this->createSubFields(array($this->persondata['Person']['plot_no'],$this->persondata['Person']['landmark'],$this->persondata['Person']['city'],$this->personAlldata['State']['state_code'],$this->persondata['Person']['pin_code'],$this->personAlldata['Country']['code'],$this->persondata['Person']['person_address_type_first'],'',$this->persondata['Person']['person_parish_code_first']))),$this->personAddressdata)),
				'',
				$this->createMultipleSubfields($this->createPhoneNumbers($this->parsePhoneFromSystem($this->persondata['Person']['person_city_code'].$this->persondata['Person']['person_local_number'],$this->persondata['Person']['person_extension'],'HOME'),$this->personAddressdata,'HOME')),
				$this->createMultipleSubfields($this->createPhoneNumbers(array(),$this->personAddressdata,'WORK',true)),
				strtoupper($this->persondata['Person']['preferred_language']),
				$this->getMarritalStatusFromSystem($this->persondata['Person']['maritail_status']),
				$this->getIDByValue('code','Religion','name',$this->persondata['Person']['religion']),
				$this->createSubFields(array($this->patientdata['Patient']['account_number'],'','',$this->persondata['Person']['assigning_authority'])),
				str_replace("-","",str_replace("-","",str_replace(" ","",str_replace(" ","",$this->persondata['Person']['ssn_us'])))),
				$this->createSubFields(array($this->persondata['Person']['driver2'],$this->getIDByValue('state_code','State','id',$this->persondata['Person']['person_state'],false))),
				'',
				$this->getEthinicityFromSystem($this->persondata['Person']['ethnicity']),
				'',
				'',
				'',
				'',
				'',
				$this->persondata['Person']['nationality'],
				$this->getParsedDate($this->patientdata['Patient']['death_recorded_date']),
				($this->patientdata['Patient']['patientdied'] == '2')?'Y':'N'
		);

		$pd1 = array('PD1',
				'1',
				'',
				'',
				$this->createSubFields(array(($extraData['User']['alternate_id'])?$extraData['User']['alternate_id']:$extraData['User']['id'],$extraData['User']['last_name'],$extraData['User']['first_name'],$extraData['User']['middle_name'],$extraData['User']['suffix'])),
				//($consultantData['Consultant']['last_name '])?$this->createSubFields(array($consultantData['Consultant']['id'],$consultantData['Consultant']['last_name'],$consultantData['Consultant']['first_name'],$consultantData['Consultant']['middle_name'],$consultantData['Consultant']['suffix'])):'',
				'',
				$this->patientdata['Patient']['hl7_patient_handicap'],
				'',
				($this->persondata['Person']['organ_donor'] == '1')?'Y':'N',
				'',
				'',
				$this->persondata['Person']['publicity_code'],
				$this->persondata['Person']['protection_indicator'],
				'',
				'',
				$this->persondata['Person']['adv_directive']
		);

		$pv1 = array('PV1',
				'1',
				Configure::read('hl7_outbound_orm_patient_class'),
				$this->createSubFields(array(Configure::read('hl7_inbound_adt_identifier'),'','',self::HL7_SENDING_FACILITY_ID)),
				$this->patientdata['Patient']['hl7_admission_type'],
				'',
				'',
				$this->createSubFields(array(($this->userdata['User']['alternate_id'])?$this->userdata['User']['alternate_id']:$this->userdata['User']['id'],$this->userdata['User']['last_name'],$this->userdata['User']['first_name'],$this->userdata['User']['middle_name'],$this->userdata['User']['suffix'],strtoupper(str_replace(".","",$this->getIDByValue('name','Initial','id',$this->userdata['User']['initial_id']))))),
				$this->createSubFields(array(($this->userdata['User']['alternate_id'])?$this->userdata['User']['alternate_id']:$this->userdata['User']['id'],$this->userdata['User']['last_name'],$this->userdata['User']['first_name'],$this->userdata['User']['middle_name'],$this->userdata['User']['suffix'],strtoupper(str_replace(".","",$this->getIDByValue('name','Initial','id',$this->userdata['User']['initial_id']))))),
				$this->createSubFields(array(($this->userdata['User']['alternate_id'])?$this->userdata['User']['alternate_id']:$this->userdata['User']['id'],$this->userdata['User']['last_name'],$this->userdata['User']['first_name'],$this->userdata['User']['middle_name'],$this->userdata['User']['suffix'],strtoupper(str_replace(".","",$this->getIDByValue('name','Initial','id',$this->userdata['User']['initial_id']))))),
				'GFM',
				'',
				'',
				'',
				$this->patientdata['Patient']['hl7_admit_source'],
				'',
				$this->persondata['Person']['vip_indicator'],
				$this->createSubFields(array(($this->userdata['User']['alternate_id'])?$this->userdata['User']['alternate_id']:$this->userdata['User']['id'],$this->userdata['User']['last_name'],$this->userdata['User']['first_name'],$this->userdata['User']['middle_name'],$this->userdata['User']['suffix'],strtoupper(str_replace(".","",$this->getIDByValue('name','Initial','id',$this->userdata['User']['initial_id']))))),
				$this->patientdata['Patient']['hl7_patient_type'],
				'',
				$this->patientdata['Patient']['hl7_financial_class'],
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				$this->patientdata['Patient']['discharge_disposition'],
				$this->patientdata['Patient']['discharge_to_location'],
				'',
				$this->patientdata['Patient']['hl7_servicing_facility'],
				'',
				'',
				'',
				'',
				$this->getParsedDate($this->patientdata['Patient']['form_received_on'],true),
				$this->getParsedDate($this->patientdata['Patient']['discharge_date'],true),
				'',
				'',
				'',
				'',
				'',
				$this->patientdata['Patient']['visit_indicator'],


		);

		$pv2 = array('PV2',
				'',
				'',
				$this->createSubFields(array('',$this->chiefComplaintdata['Diagnosis']['complaints'])),
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				$this->patientdata['Patient']['visit_publicity_code'],
				$this->patientdata['Patient']['visit_protection_indicator'],
				'',
				$this->patientdata['Patient']['patient_status_code'],
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				$this->patientdata['Patient']['new_born_baby_indicator'],
				'',
				$this->patientdata['Patient']['hl7_mode_of_arrival']
		);

		;
		$orc = array('ORC',
				Configure::read('hl7_new_order'),
				$this->radData['RadiologyTestOrder']['id'],
				'',
				'',
				'',
				'',
				'',
				'',
				date("YmdHis"),
				$this->radData['RadiologyTestOrder']['created_by'],
				'',
				$this->createSubFields(array(($extraData['User']['alternate_id'])?$extraData['User']['alternate_id']:$extraData['User']['id'],$extraData['User']['last_name'],$extraData['User']['first_name'],$extraData['User']['middle_name'],$extraData['User']['suffix'])),
				''
		);

		$obr = array('OBR',
				'1',
				$this->radData['RadiologyTestOrder']['id'],
				'',
				$this->createSubFields(array($this->radData['Radiology']['dhr_order_code'],$this->radData['Radiology']['name'])),
				'',
				'',
				date("YmdHis"),
				'',
				'',
				'',
				'',
				'',
				'',
				'',//$this->getParsedDate($this->radData['RadiologyTestOrder']['radiology_order_date']),
				'',
				$this->createSubFields(array(($extraData['User']['alternate_id'])?$extraData['User']['alternate_id']:$extraData['User']['id'],$extraData['User']['last_name'],$extraData['User']['first_name'],$extraData['User']['middle_name'],$extraData['User']['suffix'])),
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				$this->createSubFields(array('',$this->radData['RadiologyTestOrder']['relevant_clinical_info']))
		);

		//pr($this->insuranceAlldata);exit;
		$in1String = '';
		if(!empty($this->insuranceAlldata)){
			$cnt = 1;
			$insRel = Configure::read('relationship_with_insured');
			$insRelIndex = Configure::read('relationship_with_insured_index');
			foreach($this->insuranceAlldata as $key=>$value){
				$empAddress = explode(",",$value['NewInsurance']['emp_address']);
				$insComAddress = explode(",",$value['InsuranceCompany']['address']);
				$in1 = array('IN1',
						$cnt,
						$value['NewInsurance']['insurance_plan_id'],
						$value['TariffStandard']['payer_id'],
						$value['InsuranceCompany']['name'],
						$this->createSubFields(array(trim($insComAddress['0']),trim($insComAddress['1']),$value['InsuranceCompany']['city_id'],$value['State']['state_code'],$value['InsuranceCompany']['zip'],$value['Country']['code'],$value['InsuranceCompany']['address_type'],'',$value['InsuranceCompany']['country_parish_code'])),
						'',
						$this->parsePhoneFromSystem($value['InsuranceCompany']['phone'],$value['InsuranceCompany']['extension'],$value['InsuranceCompany']['phone_type'],true),
						$value['NewInsurance']['group_number'],
						$value['NewInsurance']['group_name'],
						'',
						'',
						$this->getParsedDate($value['NewInsurance']['effective_date']),
						'',
						$value['NewInsurance']['authorization_information'].$value['NewInsurance']['authorization_number'],
						'',
						$this->createSubFields(array($value['NewInsurance']['subscriber_last_name'],$value['NewInsurance']['subscriber_name'])),
						$this->createSubFields(array($insRelIndex[$value['NewInsurance']['relation']].'/'.$value['NewInsurance']['relation'],$insRel[$value['NewInsurance']['relation']])),
						$this->getParsedDate($value['NewInsurance']['subscriber_dob']),
						$this->createSubFields(array($value['NewInsurance']['subscriber_address1'],$value['NewInsurance']['subscriber_address2'],$value['NewInsurance']['subscriber_city'],$value['InsuredState']['state_code'],$value['NewInsurance']['subscriber_zip'],$value['InsuredCountry']['code'],$value['NewInsurance']['address_type'],'',$value['NewInsurance']['country_parish_code'])),
						$value['NewInsurance']['assignment_of_benefits'],
						$value['NewInsurance']['coordination_of_benefits'],
						$value['NewInsurance']['coordination_of_benefits_priority'],
						'',
						'',
						'',
						'',
						$value['NewInsurance']['realease_information_code'],
						'',
						'',
						'',
						'',
						'',
						'',
						'',
						'',
						$value['NewInsurance']['policy_number'],
						'',
						'',
						'',
						'',
						'',
						$this->createSubFields(array($value['NewInsurance']['insured_employment_status'],$value['NewInsurance']['insured_employment_description'])),
						strtoupper($this->getGenderFromArray($value['NewInsurance']['subscriber_gender'])),
						($empAddress['0'])?$this->createSubFields(array($empAddress['0'],trim($empAddress['1']),$value['NewInsurance']['emp_city'],$value['EmployerState']['state_code'],$value['NewInsurance']['emp_zip_code'],$value['EmployerCountry']['code'],$value['NewInsurance']['emp_address_type'],'',$value['NewInsurance']['emp_county_parish_code'])):''
				);
				$in1String .= trim($this->createIN1($in1))."\r".$this->generateIN2($value)."\r";
				$cnt++;
			}
		}


		$gt1String = $nk1String = '';
		if(!empty($this->guarantorAlldata))	{
			$cnt = $nk1Cnt = 1 ;
			foreach($this->guarantorAlldata as $key=>$value){

				if($value['Guarantor']['relation'] == 'CGV'){
					$gurantorAdd = $this->getCaregiverAddresses($value['Guarantor']['id']);
					$guarantorCont = $this->getCaregiverPhones($value['Guarantor']['id']);
					$gt1 = array('GT1',
							$cnt,
							$value['Guarantor']['guarantor_id'],
							$this->createSubFields(array($value['Guarantor']['gau_last_name'],$value['Guarantor']['gau_first_name'],$value['Guarantor']['gau_middle_name'],$value['Guarantor']['gau_suffix'],strtoupper(str_replace(".","",$this->getIDByValue('name','Initial','id',$value['Guarantor']['gau_initial_id']))),'',$value['Guarantor']['gau_name_type'])),
							'',
							$this->createMultipleSubfields($this->createCaregiverAdresses(array($this->createSubFields(array($value['Guarantor']['gau_plot_no'],$value['Guarantor']['gau_landmark'],$value['Guarantor']['gau_city'],$value['State']['state_code'],$value['Guarantor']['gau_zip'],$value['Country']['code'],$value['Guarantor']['gau_address_type'],'',$value['Guarantor']['gau_county']))),$gurantorAdd)),
							$this->createMultipleSubfields($this->createCaregiverPhoneNumbers($this->parsePhoneFromSystem($value['Guarantor']['gau_city_code'].$value['Guarantor']['gau_local_number'],$value['Guarantor']['gau_extension'],'HOME'),$guarantorCont,'HOME',true,'ONLYHOME')),
							$this->createMultipleSubfields($this->createCaregiverPhoneNumbers(array(),$guarantorCont,'WORK','null','ONLYWORK',$cnt)),
							$this->getDateOfBirth($value['Guarantor']['dobg']),
							$this->getGenderFromArray($value['Guarantor']['gau_sex']),
							//$this->createMultipleSubfields($this->createPhoneNumbers($this->parsePhoneFromSystem(
							$value['Guarantor']['gau_gaurantor_type'],
							'',
							str_replace("-","",str_replace("-","",str_replace(" ","",str_replace(" ","",$value['Guarantor']['gau_ssn'])))),
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							$value['Guarantor']['gau_marital_status'],
							'',
							'',
							'',
							'',
							'',
							strtoupper($this->getIDByValue('language','Language','code',$value['Guarantor']['gau_preferred_language'])),
							'',
							'',
							'',
							'',
							(is_numeric($value['Guarantor']['gau_religion']))?$this->getIDByValue('code','Religion','id',$value['Guarantor']['gau_religion']):$value['Guarantor']['gau_religion'],
							'',
							$value['Guarantor']['gau_nationality']
					);
					$gt1String .= trim($this->createGT1($gt1))."\r";
					$cnt++;
				}else{//if($flag){pr($addessStringArray);exit;}

					$gurantorAdd = $this->getCaregiverAddresses($value['Guarantor']['id']);
					$guarantorCont = $this->getCaregiverPhones($value['Guarantor']['id']);
					$nk1 = array('NK1',
							$nk1Cnt,
							$this->createSubFields(array($value['Guarantor']['gau_last_name'],$value['Guarantor']['gau_first_name'],$value['Guarantor']['gau_middle_name'],$value['Guarantor']['gau_suffix'],strtoupper(str_replace(".","",$this->getIDByValue('name','Initial','id',$value['Guarantor']['gau_initial_id']))))),
							$this->getIDByValue('description','PhvsRelationship','value_code',$value['Guarantor']['gau_relation'],false),
							$this->createMultipleSubfields($this->createCaregiverAdresses(array($this->createSubFields(array($value['Guarantor']['gau_plot_no'],$value['Guarantor']['gau_landmark'],$value['Guarantor']['gau_city'],$value['State']['state_code'],$value['Guarantor']['gau_zip'],$value['Country']['code'],$value['Guarantor']['gau_address_type'],'',$value['Guarantor']['gau_county']))),$gurantorAdd,true)),
							$this->createMultipleSubfields($this->createCaregiverPhoneNumbers($this->parsePhoneFromSystem($value['Guarantor']['gau_city_code'].$value['Guarantor']['gau_local_number'],$value['Guarantor']['gau_extension'],'HOME'),$guarantorCont,'HOME',true,'ONLYHOME')),
							$this->createMultipleSubfields($this->createCaregiverPhoneNumbers(array(),$guarantorCont,'WORK','null','ONLYWORK')),
							$this->createSubFields(array($value['Guarantor']['gau_contact_role_identifier'],$value['Guarantor']['gau_contact_role'])),
							$this->getParsedDate($value['Guarantor']['gau_eff_date_add']),
							'',
							'',
							'',
							'',
							'',
							$value['Guarantor']['gau_marital_status'],
							$this->getGenderFromArray($value['Guarantor']['gau_sex']),
							$this->getDateOfBirth($value['Guarantor']['dobg']),
							'',
							'',
							'',
							strtoupper($this->getIDByValue('language','Language','code',$value['Guarantor']['gau_preferred_language'])),
							'',
							'',
							'',
							'',
							(is_numeric($value['Guarantor']['gau_religion']))?$this->getIDByValue('code','Religion','id',$value['Guarantor']['gau_religion']):$value['Guarantor']['gau_religion'],
							'',
							$value['Guarantor']['gau_nationality']
					);
					$nk1String .= trim($this->createNK1($nk1))."\r";
					$nk1Cnt++;
				}

			}
		}



		$dg1String = '';

		foreach($this->diagnosisdata as $key=>$diagnosisData){
			if($diagnosisData['NoteDiagnosis']['diagnosis_type'] && $diagnosisData['NoteDiagnosis']['diagnosis_type'] == 'PD'){
				$priority = '1';
			}else if($diagnosisData['NoteDiagnosis']['diagnosis_type']){
				$priority = '0';
			}
			$dg1 = array('DG1',
					++$key,
					'ICD9',
					$this->createSubFields(array($diagnosisData['NoteDiagnosis']['preffered_icd9cm'],$diagnosisData['NoteDiagnosis']['diagnoses_name'],'I9C')),
					($diagnosisData['NoteDiagnosis']['diagnosis_description'])?$diagnosisData['NoteDiagnosis']['diagnosis_description']:$diagnosisData['NoteDiagnosis']['diagnoses_name'],
					$this->getParsedDate($diagnosisData['NoteDiagnosis']['start_dt']),
					($diagnosisData['NoteDiagnosis']['hl7_diagnosis_type'])?$diagnosisData['NoteDiagnosis']['hl7_diagnosis_type']:'',
					'','','','','','','','',
					$priority
			);
			$dg1String .= trim($this->createDG1($dg1))."\r";
		}


		$al1String = '';

		foreach($this->allergiesdata as $key=>$allergyData){
			$serverity = $allergyData['NewCropAllergies']['AllergySeverityName'];

			$al1 = array('AL1',
					++$key,
					'',
					$this->createSubFields(array($allergyData['NewCropAllergies']['CompositeAllergyID'],$allergyData['NewCropAllergies']['name'])),
					$serverity,
					$allergyData['NewCropAllergies']['reaction'],
					$this->getParsedDate($allergyData['NewCropAllergies']['onset_date'])
			);
			$al1String .= trim($this->createAL1($al1))."\r";
		}
			
		$nteString = '';
		$nte = array('NTE',1,'',$this->radData['RadiologyTestOrder']['additional_notes']);

		$dg1String = rtrim($dg1String, " \n");
		$sftString = $this->createSFT($sft);
		$pidString = $this->createPID($pid);
		$pv1String = $this->createPV1($pv1);
		$pv2String = $this->createPV2($pv2);
		$orcString = $this->createORC($orc);
		$obrString = $this->createOBR($obr);
		//$in1String = $this->createIN1($in1);
		//$gt1String = $this->createGT1($gt1);
		$pd1String = $this->createPD1($pd1);
		$nteString = $this->createNTE($nte);
			
		$message = trim($mshString)."\r".trim($pidString)."\r";


		if($pd1String){
			$message .= trim($pd1String)."\r";
		}
		if($nk1String){
			$message .= trim($nk1String)."\r";
		}
		if($pv1String){
			$message .= trim($pv1String)."\r";
		}
		if($pv2String){
			$message .= trim($pv2String)."\r";
		}
		if($in1String){
			$message .= trim($in1String)."\r";
		}
		if($gt1String){
			$message .= trim($gt1String)."\r";
		}
		if($al1String){
			$message .= trim($al1String)."\r";
		}
		if($orcString){
			$message .= trim($orcString)."\r";
		}
		if($obrString){
			$message .= trim($obrString)."\r";
		}
		if($nteString){
			$message .= trim($nteString)."\r";
		}
		if($dg1String){
			$message .= trim($dg1String)."\r";
		}
		//$message = substr($message,0,(strlen($message) - 4));
		//$message = rtrim($message, " \n");
		//$message = str_replace("\r","",$message);
		$message = $message."\n";
		//echo (trim($message));exit;
		$flag = $this->saveMessage($message, 'ORM_RAD', 'OUTBOUND');
		return $flag;
	}

}
	
	##############################################################
	
	public function saveMessage($message,$messageType,$type){
		App::uses('ParagonMessage', 'Model');
		$paragonMessageModel = new ParagonMessage(null,null,$this->database);
		$paragonMessageModel->set('facility',self::SENDTO);
		$paragonMessageModel->set('message',$message);
		$paragonMessageModel->set('status','0');
		$paragonMessageModel->set('type',$messageType);
		$paragonMessageModel->set('date',date("Y-m-d"));
		$paragonMessageModel->set('inbound_outbound',$type);
		if($paragonMessageModel->save()){
			return true;
		}else{
			return false;
		}
	}
	
	public function getRepetitionSectionFromSystem($value,$targetField,$returnFields,$model){
		$returnData = array();
		$values = explode(",",$value);
		App::uses($model, 'Model');
		$objModel = new $model(null,null,$this->database);
		$result = $objModel->find('all',array('fields'=>$returnFields,'conditions'=>array("$targetField"=>$values)));
		foreach($result as $key=>$value){
			$returnData[$key] = $this->createSubFields($value[$model]);
		}
		return $returnData;
	}
	
	public function parsePhoneFromSystem($phone,$extn=null,$teleCode=null,$test=false,$flag=null){
		$phone = str_replace("(", "", $phone);
		$phone = str_replace(")", "", $phone);
		$phone = str_replace(" ", "", $phone);
		$phone = str_replace("-", "", $phone);
		$phone = str_replace("(", "", $phone);
		$phone = str_replace(")", "", $phone);
		$phone = str_replace(" ", "", $phone);
		$phone = str_replace("-", "", $phone);
		$phoneArray = array();
		if($teleCode == 'PRN')
			$teleCode = 'HOME';
		else if($teleCode == 'PP')
			$teleCode = 'MOBILE';
		else if($teleCode == 'WPN')
			$teleCode = 'WORK';
		if(!empty($extn) && !empty($phone)){
			array_push($phoneArray,$phone);
			array_push($phoneArray,$teleCode);
		}else if(!empty($phone)){
			  array_push($phoneArray,$phone);
			  array_push($phoneArray,$teleCode);
		}
		if($test === true){
			return $this->createSubFields($phoneArray);
		}else if($test === false){
			return array($this->createSubFields($phoneArray));
		}
		
	}
	
	public function createPhoneNumbers($phonesArray,$data,$type=null,$flag=false){
		$phoneArray=array();
		if($data){
			foreach($data as $key=>$value){
				if($value['Address']['tele_code'] == 'PRN')
					$teleCode = 'HOME';
				else if($value['Address']['tele_code'] == 'PP')
					$teleCode = 'MOBILE';
				else if($value['Address']['tele_code'] == 'WPN')
					$teleCode = 'WORK';
				$value['Address']['person_lindline_no'] = str_replace(")","",$value['Address']['person_lindline_no']);
				$value['Address']['person_lindline_no'] = str_replace("(","",$value['Address']['person_lindline_no']);
				$value['Address']['person_lindline_no'] = str_replace("-","",$value['Address']['person_lindline_no']);
				$value['Address']['person_lindline_no'] = str_replace(" ","",$value['Address']['person_lindline_no']);
				$value['Address']['person_local_number'] = str_replace(")","",$value['Address']['person_local_number']);
				$value['Address']['person_local_number'] = str_replace("(","",$value['Address']['person_local_number']);
				$value['Address']['person_local_number'] = str_replace("-","",$value['Address']['person_local_number']);
				$value['Address']['person_local_number'] = str_replace(" ","",$value['Address']['person_local_number']);
				if(empty($value['Address']['person_local_number'])){
					$value['Address']['person_local_number'] = $value['Address']['person_lindline_no'];
				}
				if(empty($value['Address']['person_lindline_no'])){
					$value['Address']['person_lindline_no'] = $value['Address']['person_local_number'];
				}
					if(!empty($value['Address']['person_extension']) && (!empty($value['Address']['person_lindline_no']) || $value['Address']['person_local_number'])){
						if('WORK' == $teleCode && $type == 'WORK'){
							array_push($phoneArray, $value['Address']['person_lindline_no']);//.'X'.$value['Address']['person_extension']);
						}
						if('MOBILE' == $teleCode)
							array_push($phoneArray,  $value['Address']['person_local_number']);
						if('HOME' == $teleCode && $type == 'HOME'){
							if(empty($value['Address']['person_lindline_no'])) $value['Address']['person_lindline_no'] = $value['Address']['person_local_number'];
							array_push($phoneArray, $value['Address']['person_lindline_no']);//.'X'.$value['Address']['person_extension']);
						}
						if($phoneArray)
							array_push($phoneArray,$teleCode);
					}else if((!empty($value['Address']['person_lindline_no']) || $value['Address']['person_local_number'])){
						if('WORK' == $teleCode && $type == 'WORK')
							array_push($phoneArray,  $value['Address']['person_lindline_no']);
							
						if('MOBILE' == $teleCode)
							array_push($phoneArray,  $value['Address']['person_local_number']);
						if('HOME' == $teleCode && $type == 'HOME')
							array_push($phoneArray,  $value['Address']['person_lindline_no']);
						if($phoneArray)
							array_push($phoneArray,$teleCode);
					}
					if($phoneArray)
						array_push($phonesArray,$this->createSubFields($phoneArray));
						$phoneArray = array();
					
			}//if($flag){pr($phonesArray);exit;}
		}
		
		return $phonesArray;
	}
	
	//$this->parsePhoneFromSystem($value['InsuranceCompany']['phone'],$value['InsuranceCompany']['extension'],$value['InsuranceCompany']['phone_type'],true)
	public function generateIN2($data){
		$in2 = array('IN2',
				'',
				str_replace("-","",str_replace("-","",str_replace(" ","",str_replace(" ","",$data['NewInsurance']['subscriber_ssn'])))),
				'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',
				$data['NewInsurance']['subscriber_primary_phone'],
				$data['NewInsurance']['emp_phone'],
				'','','','','',
				$data['NewInsurance']['employer']
		);
		$in2String = trim($this->createIN2($in2));
		return $in2String;
	}
	
	public function getCaregiverPhones($guarantorId){
		App::uses('CaregiverContact', 'Model');
		App::uses('Country', 'Model');
		App::uses('State', 'Model');
		$countryModel = new Country(null,null,$this->database);
		$state = new State(null,null,$this->database);
		$objModel = new CaregiverContact(null,null,$this->database);
		$phones = $objModel->find('all',array('conditions'=>array('guarantor_id'=>$guarantorId)));
		return $phones;
	}
	
	public function createCaregiverPhoneNumbers($phonesArray=array(),$data=array(),$type=null,$flag=null,$strictType=null,$gCount=null){
		if($gCount == '2'){
			//pr($phonesArray);pr($data);echo $strictType;exit;
		}
		$phoneArray=array();
		foreach($data as $key=>$value){
					/*if($strictType =='ONLYWORK'){
						echo'---'.$teleCode;pr($value);//exit;
					}*/
			if($value['CaregiverContact']['gau_tele_code'] == 'PRN')
				$teleCode = 'HOME';
			else if($value['CaregiverContact']['gau_tele_code'] == 'PP')
				$teleCode = 'MOBILE';
			else if($value['CaregiverContact']['gau_tele_code'] == 'WPN')
				$teleCode = 'WORK';
			$value['CaregiverContact']['person_lindline_no'] = $value['CaregiverContact']['gau_city_code'].$value['CaregiverContact']['gau_local_number'].$value['CaregiverContact']['gau_extension'];
			$value['CaregiverContact']['person_lindline_no'] = str_replace(")","",$value['CaregiverContact']['person_lindline_no']);
			$value['CaregiverContact']['person_lindline_no'] = str_replace("(","",$value['CaregiverContact']['person_lindline_no']);
			$value['CaregiverContact']['person_lindline_no'] = str_replace("-","",$value['CaregiverContact']['person_lindline_no']);
			$value['CaregiverContact']['person_lindline_no'] = str_replace(" ","",$value['CaregiverContact']['person_lindline_no']);
			$value['CaregiverContact']['person_local_number'] = $value['CaregiverContact']['person_lindline_no'];
				
			if(!empty($value['CaregiverContact']['gau_extension'])){
				if('WORK' == $teleCode && $strictType === 'ONLYWORK'){
					array_push($phoneArray, "(".substr($value['CaregiverContact']['person_lindline_no'], 0, 3).")".substr($value['CaregiverContact']['person_lindline_no'], 3, 3)."-".substr($value['CaregiverContact']['person_lindline_no'], 6, 4).'X'.$value['CaregiverContact']['gau_extension']);
				}else if($strictType === 'ONLYHOME'){ 
					if('MOBILE' == $teleCode)
						array_push($phoneArray,  "(".substr($value['CaregiverContact']['person_local_number'], 0, 3).")".substr($value['CaregiverContact']['person_local_number'], 3, 3)."-".substr($value['CaregiverContact']['person_local_number'], 6, 4));
					if('HOME' == $teleCode && $type == 'HOME')
						array_push($phoneArray, "(".substr($value['CaregiverContact']['person_lindline_no'], 0, 3).")".substr($value['CaregiverContact']['person_lindline_no'], 3, 3)."-".substr($value['CaregiverContact']['person_lindline_no'], 6, 4).'X'.$value['CaregiverContact']['gau_extension']);
				}
				if($phoneArray)
					array_push($phoneArray,$teleCode);
			}else{
				if('WORK' == $teleCode && ($strictType == 'ONLYWORK')){
					if(empty($value['CaregiverContact']['person_lindline_no'])){
						$value['CaregiverContact']['person_lindline_no'] = $value['CaregiverContact']['person_local_number'];
					}
					array_push($phoneArray,  "(".substr($value['CaregiverContact']['person_lindline_no'], 0, 3).")".substr($value['CaregiverContact']['person_lindline_no'], 3, 3)."-".substr($value['CaregiverContact']['person_lindline_no'], 6, 4));
					if($phoneArray){
						array_push($phoneArray,$teleCode);
					}
					
				}else if($strictType === 'ONLYHOME'){ 
					if('MOBILE' == $teleCode)
						array_push($phoneArray,  "(".substr($value['CaregiverContact']['person_local_number'], 0, 3).")".substr($value['CaregiverContact']['person_local_number'], 3, 3)."-".substr($value['CaregiverContact']['person_local_number'], 6, 4));
					if('HOME' == $teleCode && $type == 'HOME')
						array_push($phoneArray, "(".substr($value['CaregiverContact']['person_lindline_no'], 0, 3).")".substr($value['CaregiverContact']['person_lindline_no'], 3, 3)."-".substr($value['CaregiverContact']['person_lindline_no'], 6, 4).'X'.$value['CaregiverContact']['gau_extension']);
					if($phoneArray)
						array_push($phoneArray,$teleCode);
				}
				
				
		}
			if($phoneArray)
				array_push($phonesArray,$this->createSubFields($phoneArray));
			$phoneArray = array();
	
		}
		
		return $phonesArray;
	}
	
	public function getMarritalStatusFromSystem($marritalStatus){
		$marritalStatus = (string) $marritalStatus;
		$marritalStatuses = array('S'=>'Single','M'=>'Married','D'=>'Divorced','W'=>'Widowed','G'=>'Living together','U'=>'Unknown');
		return array_search($marritalStatus, $marritalStatuses);
	}
	
	public function getEthinicityFromSystem($ethinic){
		$ethinicities = array('H'=>'2135-2:Hispanic or Latino','N'=>'2186-5:Not Hispanic or Latino','U'=>'UnKnown','D'=>'Denied to Specific');
		return array_search($ethinic,$ethinicities);
	}
	
	public function getAddresses($addressTypeId,$addressType,$model){
		App::uses($model, 'Model');
		App::uses('Country', 'Model');
		App::uses('State', 'Model');
		$countryModel = new Country(null,null,$this->database);
		$state = new State(null,null,$this->database);
		$objModel = new $model(null,null,$this->database);
		$objModel->bindModel(array(
				'belongsTo' => array(
						'State' =>array('foreignKey' => false,'conditions' =>array("$model.state=State.id")),
						'Country' =>array('foreignKey' => false,'conditions' =>array("$model.country=Country.id")),
				)),false);
		
		$addresses = $objModel->find('all',array('conditions'=>array('address_type'=>$addressType,'address_type_id'=>$addressTypeId)));
		return $addresses;
	}
	
	public function createAdresses($addessStringArray,$addresses){
		foreach($addresses as $address){
			if(!empty($address['Address']['plot_no']))
				array_push($addessStringArray,$this->createSubFields(array($address['Address']['plot_no'],$address['Address']['landmark'],$address['Address']['city'],$address['State']['state_code'],$address['Address']['pin_code'],$address['Country']['code'],$address['Address']['person_address_type'],'',$address['Address']['country_parish_code'])));
		}
		return $addessStringArray;
	}
	
	public function getCaregiverAddresses($guarantorId){
		App::uses('CaregiverAddress', 'Model');
		App::uses('Country', 'Model');
		App::uses('State', 'Model');
		$countryModel = new Country(null,null,$this->database);
		$state = new State(null,null,$this->database);
		$objModel = new CaregiverAddress(null,null,$this->database);
		$objModel->bindModel(array(
				'belongsTo' => array(
						'State' =>array('foreignKey' => false,'conditions' =>array("CaregiverAddress.gau_state=State.id")),
						'Country' =>array('foreignKey' => false,'conditions' =>array("CaregiverAddress.gau_country=Country.id")),
				)),false);
		
		$addresses = $objModel->find('all',array('conditions'=>array('guarantor_id'=>$guarantorId)));//if($guarantorId == 3){pr($addresses);exit;}
		return $addresses;
	}
	
	public function createCaregiverAdresses($addessStringArray,$addresses,$flag=false){//if($flag){pr($addessStringArray);exit;}
		foreach($addresses as $address){
			array_push($addessStringArray,$this->createSubFields(array($address['CaregiverAddress']['gau_plot_no'],$address['CaregiverAddress']['gau_landmark'],$address['CaregiverAddress']['gau_city'],$address['State']['state_code'],$address['CaregiverAddress']['gau_zip'],$address['Country']['code'],$address['CaregiverAddress']['gau_address_type'],'',$address['CaregiverAddress']['gau_county'])));
		}
		return $addessStringArray;
	}
	##############################################################
	
	public function createMultipleSubfields($dataFields = array()){
		if($dataFields){
			return implode(self::REPETITIONSEPARATOR, $dataFields);
		}
	}
	
	public function formatSubFields($dataFields=array()){if($dataFields['0']=='6654'){exit;}
		if(count($dataFields) > 0 ){
			$last = end($dataFields);
			if(empty($last)){
				array_pop($dataFields);
				$this->formatSubFields($dataFields);
			}
			}
		return $dataFields;
	}
	
	public function createSubFields($dataFields = array()){
		if($dataFields){
			$dataFields = $this->formatSubFields($dataFields);
			return implode(self::SUBFIELDSEPARATOR, $dataFields);
		}
	}

	public function createFieldSeparators($dataFields = array()){
		if($dataFields){
			return implode(self::SUBSUBFIELDSEPARATOR, $dataFields);
		}
	}

	public function getReceivingApplicationName($name=null){
		return Configure::read('sending_application_name');
	}

	public function getReceivingApplicationOIDNumber($name=null){
		return Configure::read('sending_application_oid_number');
	}

	public function getReceivingApplicationUniversalIDType($name=null){
		return Configure::read('sending_application_universal_id_type');
	}

	public function getReceivingFacilityName($name=null){
		return Configure::read('sending_facility_name');
	}

	public function getReceivingFacilityOIDNumber($name=null){
		return Configure::read('sending_facility_oid_number');
	}

	public function getReceivingFacilityUniversalIDType($name=null){
		return Configure::read('sending_facility_universal_id_type');
	}

	public function getDateTimeOfMessage(){
		//$key = array_search($zone,DateFormatComponent::$timezones);
		return date('YmdHis');
	}

	public function getDateOfBirth($birthDate,$flag=true){
		if($flag)
			return str_replace('-', '', $birthDate).'0000';
		else return str_replace('-', '', $birthDate);
	}
	
	public function getParsedDate($date){
		$date = str_replace('-', '', $date);
		$date = str_replace(' ', '', $date);
		$date = str_replace(':', '', $date);
		return $date;
	} 

	public function getRaceByCode($raceCode){
		App::uses('Race', 'Model');
		if($race){
			$raceModel = new Race(null,null,$this->database);
			$raceData = $raceModel->find('first',array('conditions'=>array('Race.value_code'=>$raceCode)));
			return $raceData['Race']['name'];
		}
	}

	public function getMesssageType($messageTypePrefix='OML'){

	}

	public function messageMSHIdentifier($name='MSG',$tc='TC'){//autogeneratedNumber
		return Configure::read('sending_application_name').'-'.$name.'-'.$tc.date('dm-H.is');
	}

	public function getPersonDetailFromPatient($patientId){
		if($patientId){
			App::uses('Patient', 'Model');
			App::uses('Person', 'Model');
			App::uses('User', 'Model');
			App::uses('Country', 'Model');
			App::uses('State', 'Model');
			App::uses('PharmacySalesBill', 'Model');
			App::uses('InventoryPharmacySalesReturn', 'Model');
			$patientModel = new Patient(null,null,$this->database);
			$personModel = new Person(null,null,$this->database);
			$userModel = new User(null,null,$this->database);
			$countryModel = new Country(null,null,$this->database);
			$state = new State(null,null,$this->database);
			$patientModel->unBindModel(array(
							'hasMany' => array(new PharmacySalesBill(null,null,$this->database),
			new InventoryPharmacySalesReturn(null,null,$this->database))));
			$patientModel->bindModel(array(
					'belongsTo' => array(
							'Person' =>array('foreignKey' => false,'conditions' =>array('Patient.person_id=Person.id')),
							'User' =>array('foreignKey' => false,'conditions' =>array('Patient.doctor_id=User.id')),
							'State' =>array('foreignKey' => false,'conditions' =>array('Person.state=State.id')),
							'Country' =>array('foreignKey' => false,'conditions' =>array('Person.country=Country.id')),
					)),false);
			$patientData = $patientModel->find('first',array('conditions'=>array('Patient.id'=>$patientId)));
			$this->persondata['Person'] = $patientData['Person'];
			$this->personAlldata = $patientData;
			$this->patientdata['Patient'] = $patientData['Patient'];
			$this->userdata['User'] = $patientData['User'];
			//$this->userdata = json_encode($patientData['User']);
			//$this->userdata = json_decode($this->userdata);
			if($this->patientdata['Patient']['patientdied'] == 'Deceased'){
				$this->patientdata['Patient']['patientdied'] = '1';
			}else{
				$this->patientdata['Patient']['patientdied'] = '0';
			}
				
		}

	}
	
	public function getLaboratoryDetails($patientId,$labOrderId){
		App::uses('LaboratoryTestOrder', 'Model');
		App::uses('Laboratory', 'Model');
		App::uses('SpecimenCollectionOption', 'Model');
		App::uses('LaboratoryToken', 'Model');
		$laboratoryTestOrderModel = ClassRegistry::init('LaboratoryTestOrder');
		$laboratoryModel = new Laboratory(null,null,$this->database);
		$laboratoryTokenModel = new LaboratoryToken(null,null,$this->database);
		$specimenCollectionOptionModel = new SpecimenCollectionOption(null,null,$this->database);
		$laboratoryTestOrderModel->bindModel(array(
					'belongsTo' => array(
						'Laboratory' =>array('foreignKey' => false,'conditions' =>array('LaboratoryTestOrder.laboratory_id=Laboratory.id')),
						'SpecimenCollectionOption' =>array('foreignKey' => false,'conditions' =>array('Laboratory.id=SpecimenCollectionOption.laboratory_id','LaboratoryTestOrder.specimen_type_option=SpecimenCollectionOption.id')),
						'LaboratoryToken' =>array('foreignKey' => false,'conditions' =>array('LaboratoryToken.laboratory_test_order_id=LaboratoryTestOrder.id')),
		)),false);
		$this->labData = $laboratoryTestOrderModel->find('first',array('conditions'=>array('LaboratoryTestOrder.patient_id'=>$patientId,'LaboratoryTestOrder.id'=>$labOrderId)));
	}
	
	public function getLaboratoryChildDetails($patientId,$labOrderId){
		App::uses('LaboratoryTestOrder', 'Model');
		App::uses('Laboratory', 'Model');
		App::uses('SpecimenCollectionOption', 'Model');
		App::uses('LaboratoryToken', 'Model');
		$laboratoryTestOrderModel = ClassRegistry::init('LaboratoryTestOrder');
		$laboratoryModel = new Laboratory(null,null,$this->database);
		$laboratoryTokenModel = new LaboratoryToken(null,null,$this->database);
		$specimenCollectionOptionModel = new SpecimenCollectionOption(null,null,$this->database);
		$laboratoryTestOrderModel->bindModel(array(
				'belongsTo' => array(
						'Laboratory' =>array('foreignKey' => false,'conditions' =>array('LaboratoryTestOrder.laboratory_id=Laboratory.id')),
						'SpecimenCollectionOption' =>array('foreignKey' => false,'conditions' =>array('Laboratory.id=SpecimenCollectionOption.laboratory_id','LaboratoryTestOrder.specimen_type_option=SpecimenCollectionOption.id')),
						'LaboratoryToken' =>array('foreignKey' => false,'conditions' =>array('LaboratoryToken.laboratory_test_order_id=LaboratoryTestOrder.id')),
				)),false);
		$this->labChildData = $laboratoryTestOrderModel->find('all',array('conditions'=>array('LaboratoryTestOrder.patient_id'=>$patientId,'LaboratoryTestOrder.parent_id'=>$labOrderId)));
	}
	
	public function getRadiologyDetails($patientId,$radOrderId){//echo $patientId.'---'.$radOrderId;exit;
		App::uses('RadiologyTestOrder', 'Model');
		App::uses('Radiology', 'Model');
		$radiologyTestOrderModel = ClassRegistry::init('RadiologyTestOrder');
		$radiologyModel = new Radiology(null,null,$this->database);
		$radiologyTestOrderModel->bindModel(array(
				'belongsTo' => array(
						'Radiology' =>array('foreignKey' => false,'conditions' =>array('RadiologyTestOrder.radiology_id=Radiology.id')),
						)),false);
		$this->radData = $radiologyTestOrderModel->find('first',array('conditions'=>array('RadiologyTestOrder.patient_id'=>$patientId,'RadiologyTestOrder.id'=>$radOrderId)));
	
	}
	
	public function getInsuranceDetails($patientId){
		App::uses('NewInsurance', 'Model');
		App::uses('InsuranceCompany', 'Model');
		App::uses('TariffStandard', 'Model');
		App::uses('Country', 'Model');
		App::uses('State', 'Model');
		App::uses('InsuredState', 'Model');
		App::uses('InsuredCountry', 'Model');
		App::uses('EmployerState', 'Model');
		App::uses('EmployerCountry', 'Model');
		$newInsuranceModel = new NewInsurance(null,null,$this->database);
		$insuranceCompanyModel = new InsuranceCompany(null,null,$this->database);
		$tariffStandardModel = new TariffStandard(null,null,$this->database);
		$countryModel = new Country(null,null,$this->database);
		$stateModel = new State(null,null,$this->database);
		$newInsuranceModel->bindModel(array(
							'belongsTo' => array(
								'InsuranceCompany' =>array('foreignKey' => false,'conditions' =>array('InsuranceCompany.id=NewInsurance.insurance_company_id')),
								'TariffStandard'=>array('foreignKey' => false,'conditions' => array('TariffStandard.id=NewInsurance.tariff_standard_id')),
								'State' =>array('foreignKey' => false,'conditions' =>array('InsuranceCompany.state_id=State.id')),
								'Country' =>array('foreignKey' => false,'conditions' =>array('Country.id=InsuranceCompany.country_id')),
								'InsuredState' => array('className' => 'State','foreignKey' => false,'conditions' => array('InsuredState.id=NewInsurance.subscriber_state')),
								'InsuredCountry' => array('className' => 'Country','foreignKey' => false,'conditions' => array('InsuredCountry.id=NewInsurance.subscriber_country')),
								'EmployerState' => array('className' => 'State','foreignKey' => false,'conditions' => array('EmployerState.id=NewInsurance.emp_state')),
								'EmployerCountry' => array('className' => 'Country','foreignKey' => false,'conditions' => array('EmployerCountry.id=NewInsurance.emp_country')),
		)),false);
		$this->insuranceAlldata = $newInsuranceModel->find('all',array('conditions'=>array('NewInsurance.patient_id'=>$patientId,'NewInsurance.priority'=>'P','NewInsurance.is_active'=>'1')));
		/*$address = explode(",",$this->insurancedata['InsuranceCompany']['address']);
		if(!empty($address['0'])){
			$this->insurancedata['InsuranceCompany']['address1'] = $address['0'];
			$this->insurancedata['InsuranceCompany']['address2'] = $address['1'];
		}
		$address = explode(",",$this->insurancedata['NewInsurance']['emp_address']);
		if(!empty($address['0'])){
			$this->insurancedata['NewInsurance']['emp_address1'] = $address['0'];
			$this->insurancedata['NewInsurance']['emp_address2'] = $address['1'];
		}*/
	}
	
	public function getGuarantorDetails($personId){
		App::uses('Guarantor', 'Model');
		App::uses('State', 'Model');
		App::uses('Country', 'Model');
		$guarantorModel = new Guarantor(null,null,$this->database);
		$guarantorModel->bindModel(array(
									'belongsTo' => array(
										'State' =>array('foreignKey' => false,'conditions' =>array('Guarantor.gau_state=State.id')),
										'Country' =>array('foreignKey' => false,'conditions' =>array('Guarantor.gau_country=Country.id')),
		)),false);
		$this->guarantorAlldata = $guarantorModel->find('all',array('conditions'=>array('Guarantor.person_id'=>$personId)));
	}
	
	public function getDiagnosisDetails($patientId){
		App::uses('NoteDiagnosis', 'Model');
		$noteDiagnosisModel = new NoteDiagnosis(null,null,$this->database);
		$this->diagnosisdata = $noteDiagnosisModel->find('all',array('conditions'=>array('NoteDiagnosis.patient_id'=>$patientId)));
	}
	
	public function getAllergiesDetails($patientId){
		App::uses('NewCropAllergies', 'Model');
		$newCropAllergyModel = new NewCropAllergies(null,null,$this->database);
		$this->allergiesdata = $newCropAllergyModel->find('all',array('conditions'=>array('NewCropAllergies.patient_uniqueid'=>$patientId)));
	}
	
	public function getChiefComplaintDetails($patientId){
		App::uses('Diagnosis', 'Model');
		$diagnosisModel = new Diagnosis(null,null,$this->database);
		$this->chiefComplaintdata = $diagnosisModel->find('first',array('conditions'=>array('Diagnosis.patient_id'=>$patientId)));
	}
	
	public function getConsultantDetails($consultantId){
		App::uses('Consultant', 'Model');
		App::uses('City', 'Model');
		App::uses('State', 'Model');
		App::uses('Country', 'Model');
		App::uses('Initial', 'Model');
		$consultantModel = new Consultant(null,null,$this->database);
		$consultantModel->unBindModel(array(
				'belongsTo' => array(new City(null,null,$this->database),
						new State(null,null,$this->database),
						new Country(null,null,$this->database),
						new Initial(null,null,$this->database),
				)));
		
		$consultantDetails = $consultantModel->find('first',array('conditions'=>array('Consultant.id'=>$consultantId,'Consultant.location_id'=>$this->locationId)));
		return $consultantDetails;
	}
	
	public function getPatientDetailFromPerson($personId){
		if($personId){
			$personModel = ClassRegistry::init('Person');
			$personModel->bindModel(array(
					'belongsTo' => array(
							'Patient' =>array('foreignKey' => false,'conditions' =>array('Patient.person_id=Person.id')),
					)),false);
			$personData = $patientModel->find('first',array('conditions'=>array('Person.id'=>$personId)));
			$this->persondata['Person'] = $personData['Person'];
			$this->patientdata['Patient'] = $personData['Patient'];
			if($this->patientdata['Patient']['patientdied'] == 'Deceased'){
				$this->patientdata['Patient']['patientdied'] = '1';
			}else{
				$this->patientdata['Patient']['patientdied'] = '0';
			}

		}

	}

	public function parsePID($data){
		$personModel = ClassRegistry::init('Person');
		$person = array();
		$patient = array();
		$address = $addresses = array();
		$contact = $contacts = array();
		$person['assigning_authority'] = (string) $data->{'PID.2'}->{'PID.2.4'};
		$person['alternate_patient_uid'] = (string) $data->{'PID.3'}->{'PID.3.1'};
		// 2.4,2.6
		if(count($data->{'PID.5'}) > 1){
			$cnt = 0;
			foreach($data->{'PID.5'} as $key=>$name){
				if($cnt == 0){
					$person['last_name'] = (string) $name->{'PID.5.1'};
					$person['first_name'] = (string) $name->{'PID.5.2'};
					$person['middle_name'] = (string) $name->{'PID.5.3'};
					$person['suffix1'] = (string) $name->{'PID.5.4'};
					$person['initial_id'] = (string) $this->getIDByValue('id','Initial','name',$name->{'PID.5.5'},'%');
					$person['name_type'] = (string) $name->{'PID.5.7'};
				}else{
					$person['alternate_last_name'] = (string) $name->{'PID.5.1'};
					$person['alternate_first_name'] = (string) $name->{'PID.5.2'};
					$person['alternate_middle_name'] = (string) $name->{'PID.5.3'};
					$person['alternate_name_type'] = (string) $name->{'PID.5.7'};
				}
				$cnt++;
			}
				
		}else{
			$person['last_name'] = (string) $data->{'PID.5'}->{'PID.5.1'};
			$person['first_name'] = (string) $data->{'PID.5'}->{'PID.5.2'};
			$person['middle_name'] = (string) $data->{'PID.5'}->{'PID.5.3'};
			$person['suffix1'] = (string) $data->{'PID.5'}->{'PID.5.4'};
			$person['initial_id'] = (string) $this->getIDByValue('id','Initial','name',$data->{'PID.5'}->{'PID.5.5'},'%');
			$person['name_type'] = (string) $data->{'PID.5'}->{'PID.5.7'};
		}

		$person['mother_name'] = (string) $data->{'PID.6'}->{'PID.6.1'};
		$person['dob'] = (string) $this->parseDate($data->{'PID.7'}->{'PID.7.1'});
		$person['sex'] = (string) $this->getGender($data->{'PID.8'}->{'PID.8.1'});//Need to check
		$person['race'] = (string) $this->getIDByValue('value_code','Race','alternate_identifier',$data->{'PID.10'}->{'PID.10.1'},false);// Need to check
		$cnt = 0;
		if(count($data->{'PID.11'}) > 1){
			foreach($data->{'PID.11'} as $key=>$address){
				if($cnt == 0){
					$person['plot_no'] = (string) $address->{'PID.11.1'};
					$person['landmark'] = (string) $address->{'PID.11.2'};
					$person['city'] = (string) $address->{'PID.11.3'};
					$person['state'] = (string) $this->getIDByValue('id','State','state_code',$address->{'PID.11.4'},false);
					$person['pin_code'] = (string) $address->{'PID.11.5'};
					$person['country'] = (string) $this->getIDByValue('id','Country','name',$address->{'PID.11.6'},false);
					$person['person_address_type_first'] = (string) $address->{'PID.11.7'};
					$person['person_parish_code_first'] = (string) $address->{'PID.11.9'};
				}else{
					$addr['plot_no'] = (string) $address->{'PID.11.1'};
					$addr['landmark'] = (string) $address->{'PID.11.2'};
					$addr['city'] = (string) $address->{'PID.11.3'};
					$addr['state'] = (string) $this->getIDByValue('id','State','state_code',$address->{'PID.11.4'},false);
					$addr['pin_code'] = (string) $address->{'PID.11.5'};
					$addr['country'] = (string) $this->getIDByValue('id','Country','name',$address->{'PID.11.6'},false);
					$addr['person_address_type'] = (string) $address->{'PID.11.7'};
					$addr['country_parish_code'] = (string) $address->{'PID.11.9'};
					array_push($addresses, $addr);
				}
				$cnt++;
			}
		}else{
			$person['plot_no'] = (string) $data->{'PID.11'}->{'PID.11.1'};
			$person['landmark'] = (string) $data->{'PID.11'}->{'PID.11.2'};
			$person['city'] = (string) $data->{'PID.11'}->{'PID.11.3'};
			$person['state'] = (string) $this->getIDByValue('id','State','state_code',$data->{'PID.11'}->{'PID.11.4'},false);
			$person['pin_code'] = (string) $data->{'PID.11'}->{'PID.11.5'};
			$person['country'] = (string) $this->getIDByValue('id','Country','name',$data->{'PID.11'}->{'PID.11.6'},false);
			$person['person_address_type_first'] = (string) $data->{'PID.11'}->{'PID.11.7'};
			$person['person_parish_code_first'] = (string) $data->{'PID.11'}->{'PID.11.9'};
		}
		$cnt = 0;
		if(count($data->{'PID.13'}) > 1){
			foreach($data->{'PID.13'} as $key=>$phone){
				$phoneType = (string) $phone->{'PID.13.2'};
				if(strtoupper($phoneType) == 'WORK'){
					$phoneType = 'WPN';
				}else if(strtoupper($phoneType) == 'HOME'){
					$phoneType = 'PRN';
				}
				else if(strtoupper($phoneType) == 'MOBIL'){
					$phoneType = 'PP';
				}
				if($cnt == 0){
					$person['person_tele_code'] = (string) $phoneType;
					$person['person_city_code'] = substr($phone->{'PID.13.1'}, 1, 3);
					$person['person_local_number'] = substr($phone->{'PID.13.1'}, 5, 3).substr($phone->{'PID.13.1'}, 9, 4);
					$person['person_extension'] = substr($phone->{'PID.13.1'}, 14, 7);
				}else{
					$contact['person_tele_code_second'] = (string) $phoneType;
					$contact['person_local_number'] = substr($phone->{'PID.13.1'}, 1, 3).substr($phone->{'PID.13.1'}, 5, 3).substr($phone->{'PID.13.1'}, 9, 4);
					$contact['person_extension'] = substr($phone->{'PID.13.1'}, 14, 7);
					array_push($contacts, $contact);
				}
				$cnt++;
			}
				
		}else{
			$phoneType = (string) $data->{'PID.13'}->{'PID.13.2'};
		if(strtoupper($phoneType) == 'WORK'){
					$phoneType = 'WPN';
				}else if(strtoupper($phoneType) == 'HOME'){
					$phoneType = 'PRN';
				}
				else if(strtoupper($phoneType) == 'MOBIL'){
					$phoneType = 'PP';
				}
			if($phoneType){
				$person['person_tele_code'] = (string) $phoneType;
				$person['person_city_code'] = substr($data->{'PID.13'}->{'PID.13.1'}, 1, 3);
				$person['person_local_number'] = substr($data->{'PID.13'}->{'PID.13.1'}, 5, 3).substr($data->{'PID.13'}->{'PID.13.1'}, 9, 4);
				$person['person_extension'] = substr($data->{'PID.13'}->{'PID.13.1'}, 14, 7);
			}
		}
		$cnt = 0;
		if(count($data->{'PID.14'}) > 1){
			foreach($data->{'PID.14'} as $key=>$phone){
				$phoneType = (string) $phone->{'PID.14.2'};
			if(strtoupper($phoneType) == 'WORK'){
					$phoneType = 'WPN';
				}else if(strtoupper($phoneType) == 'HOME'){
					$phoneType = 'PRN';
				}
				else if(strtoupper($phoneType) == 'MOBIL'){
					$phoneType = 'PP';
				}
					$contact['person_tele_code_second'] = (string) $phoneType;
					$contact['person_local_number'] = substr($phone->{'PID.14.1'}, 1, 3).substr($phone->{'PID.14.1'}, 5, 3).substr($phone->{'PID.14.1'}, 9, 4);
					$contact['person_extension'] = substr($phone->{'PID.14.1'}, 14, 7);
					array_push($contacts, $contact);
				$cnt++;
			}
				
		}else {
			$phoneType = (string) $data->{'PID.14'}->{'PID.14.2'};
		if(strtoupper($phoneType) == 'WORK'){
					$phoneType = 'WPN';
				}else if(strtoupper($phoneType) == 'HOME'){
					$phoneType = 'PRN';
				}
				else if(strtoupper($phoneType) == 'MOBIL'){
					$phoneType = 'PP';
				}
			if($phoneType){
				$contact['person_tele_code_second'] = (string) $phoneType;
				$contact['person_local_number'] = substr($data->{'PID.14'}->{'PID.14.1'}, 1, 3).substr($data->{'PID.14'}->{'PID.14.1'}, 5, 3).substr($data->{'PID.14'}->{'PID.14.1'}, 9, 4);
				$contact['person_extension'] = substr($data->{'PID.14'}->{'PID.14.1'}, 14, 7);
				array_push($contacts, $contact);
			}
		}
		
		$lang1 = (string) $data->{'PID.15'}->{'PID.15.1'};
		$lang2 = (string) $data->{'PID.15'}->{'PID.15.2'};
		if(empty($lang2)){
			$lang2 = $lang1;
		}
		
		$person['preferred_language'] = (string) $this->getIDByValue('code','Language','language',$lang2);
		$person['language'] = $person['preferred_language'];
		$person['maritail_status'] = (string) $this->getMarritalStatus($data->{'PID.16'}->{'PID.16.1'});
		
		$rel = (string) $data->{'PID.17'}->{'PID.17.1'};
		if(is_numeric($rel)){
			$religi = $this->getIDByValue('name','Religion','id',$rel,false);
		}else{
			$religi = $this->getIDByValue('name','Religion','code',$rel,false);
		}
		
		$person['religion'] = $religi;
		$patient['account_number'] = (string) $data->{'PID.18'}->{'PID.18.1'};
		$person['account_number_assigning_authority'] = (string) $data->{'PID.18'}->{'PID.18.4'};
		$person['ssn_us'] = (string) $data->{'PID.19'}->{'PID.19.1'};
		$person['driver2'] = (string) $data->{'PID.20'}->{'PID.20.1'};
		$person['person_state'] = (string) $this->getIDByValue('id','State','state_code',$data->{'PID.20'}->{'PID.20.2'},false);;
		$person['driver2'] = (string) $data->{'PID.20'}->{'PID.20.1'};
		$person['mother_identifier'] = (string) $data->{'PID.21'}->{'PID.21.1'};
		
		$eth = (string) $data->{'PID.22'}->{'PID.22.1'};
		$eth1 = (string) $data->{'PID.22'}->{'PID.22.2'};
		if(empty($eth1)){
			$eth1 = $eth;
		}
		
		$person['ethnicity'] = (string) $this->getEthinicity($eth1);
		
		$person['venteran'] = (string) $data->{'PID.27'}->{'PID.27.1'};
		if(trim($person['venteran']) == 'Y'){
			$person['venteran'] = '1';
		}else{
			$person['venteran'] = '0';
		}
		
		$person['nationality'] = (string) $data->{'PID.28'}->{'PID.28.1'};
		$patient['death_recorded_date'] = (string) $this->parseDate($data->{'PID.29'}->{'PID.29.1'},true);
		$isPatientDead = (string) $data->{'PID.30'}->{'PID.30.1'};
		if(strtoupper($isPatientDead) == 'Y'){
			$patient['patientdied'] = '1';
		}else{
			$patient['patientdied'] = '0';
		}
		return array($person,$patient,$addresses,$contacts);
	}

	function parseDate($date,$time=false){
		$date = $date1 = (string) $date;
		if($date && $time){
			$date = substr($date, 0, 4) .'-'. substr($date, 4, 2) .'-'. substr($date, 6, 2)  .' '. substr($date, 8, 2)  .':'. substr($date, 10, 2) . ':00';
		}else if($date){
			$date = substr($date, 0, 4) .'-'. substr($date, 4, 2) .'-'. substr($date, 6, 2);
		}
		return $date;
	}

	function getIDByValue($returnValue,$model,$field,$value,$like=null){
		App::uses($model, 'Model');
		$modelObj = new $model(null,null,$this->database);
		$modelObj->recursive = -1;
		$value = (string) $value;
		if($like){
			$like1 = "like '$like'";
		}
		$result = $modelObj->find('first',array('fields'=>array($returnValue),'conditions'=>array("$field $like1"=>$value."$like")));
		return $result[$model][$returnValue];

	}
	
	function getUserDoctorData($userId){
		App::uses('User', 'Model');
		$userModel = new User(null,null,$this->database);
		$userData = $userModel->find('first',array('conditions'=>array('User.id'=>$userId,'User.location_id'=>$this->locationId,'User.role_id'=>Configure::read('doctorRoleId'))));
		return $userData;
	}
	
	function getDataByMatchingFields($fields,$model,$limit=1,$offset=0){
		App::uses($model, 'Model');
		$modelObj = new $model(null,null,$this->InterfaceEngine->database);
		$modelObj->recursive = -1;
		$result = $modelObj->find('first',array('conditions'=>$fields,'limit'=>$limit,'offset'=>$offset));
		return $result;
	}

	function parseInsurance($data=array()){
		$newInsurance = ClassRegistry::init('NewInsurance');
		$newInsuranceArray = array();
		//for($i=0;$i<count($data->IN1);$i++){
		//	debug($data->IN1);
		foreach($data->IN1 as $key=>$name){
			if(!empty($name->{'IN1.4'})){
				$insuranceCompanyName=$name->{'IN1.4'}->{'IN1.4.1'};
				//$getTariffStandard=$this->getIDByValue('TariffStandard','name',$name->{'IN1.4'}->{'IN1.4.1'},'%');
				debug($getTariffStandard);
			}
			//debug($data->IN1[$i]->{'IN1.4'});
			//$newInsuranceArray['NewInsurance']['']<<<<<<< .mine
			//$result = $model->find('first',array('fields'=>array($id),'conditions'=>array("$field $like"=>$value." $like")));
			return $result[$model][$id];

			/* Insurance Plan ID   			tariff_standard_id,
			 Insurance Company ID   			tariff_standard_name,insurance_number
			Insurance Company Name  		insurance_name
			Insurance Company Address
			Group Number  					group_number
			Group Name     					group_name
			Plan Effective Date				effective_date
			Policy Number
			Employment Status
			Employer Address */
				
		}

	}

	function getGender($genderInitial){
		$genderInitial = (string) $genderInitial;
		$gender = array('M'=>'Male','F'=>'Female','A'=>'Ambiguous','N'=>'Not Applicable','U'=>'Unknown','O'=>'Other');
		return $gender[$genderInitial];
	}
	
	function getGenderFromArray($genderInitial){
		$genderInitial = (string) $genderInitial;
		$gender = array('M'=>'Male','F'=>'Female','A'=>'Ambiguous','N'=>'Not Applicable','U'=>'Unknown','O'=>'Other');
		return array_search($genderInitial, $gender);
	}

	function getMarritalStatus($marritalStatus){//Need to check
		$marritalStatus = (string) $marritalStatus;
		$marritalStatuses = array('S'=>'Single','M'=>'Married','D'=>'Divorced','W'=>'Widowed','G'=>'Living together','U'=>'Unknown');
		if(!$marritalStatuses[$marritalStatus]){
			$marritalStatuses = Configure::read('maritail_status');
			$marritalStatus = $marritalStatuses[$marritalStatus];
		}else{
			$marritalStatus = $marritalStatuses[$marritalStatus];
		}
		return $marritalStatus;
	}

	public function parseNK1($dataArray){
		
		$gt1CompleteArray =array();
		if(!empty($dataArray)){
			
			foreach($dataArray as $key=>$data){
				$gt1 = array();
				$gt1Addresses = array();
				$gt1Address = array();
				$gt1Phone = array();
				$gt1Phones = array();
				$gt1Array =array();
					//<  BOF [NK1.4] Address>
				$type = $data->{'NK1.7'}->{'NK1.7.1'};
				$gt1['gau_last_name'] = (string) $data->{'NK1.2'}->{'NK1.2.1'};
				$gt1['gau_first_name'] = (string) $data->{'NK1.2'}->{'NK1.2.2'};
				$gt1['gau_middle_name'] = (string) $data->{'NK1.2'}->{'NK1.2.3'};
				$gt1['gau_suffix'] = (string) $data->{'NK1.2'}->{'NK1.2.4'};
				$gt1['gau_initial_id'] = (string) $this->getIDByValue('id','Initial','name',$data->{'NK1.2'}->{'NK1.2.5'},'%');
				$gt1['gau_relation'] = (string) $this->getIDByValue('value_code','PhvsRelationship','description',$data->{'NK1.3'}->{'NK1.3.2'},'%');
					
				$cnt = 0;
				if(count($data->{'NK1.4'}) > 1){
				foreach($data->{'NK1.4'} as $key=>$address){
					
					if($cnt == 0){
							
						$gt1['gau_plot_no'] = (string) $address->{'NK1.4.1'};
						$gt1['gau_landmark'] = (string) $address->{'NK1.4.2'};
						$gt1['gau_city'] = (string) $address->{'NK1.4.3'};
						$gt1['gau_state'] = (string) $this->getIDByValue('id','State','state_code',$address->{'NK1.4.4'},false);
						$gt1['gau_zip'] = (string) $address->{'NK1.4.5'};
						$gt1['gau_country'] = (string) $this->getIDByValue('id','Country','name',$address->{'NK1.4.6'},false);
						$gt1['gau_address_type'] = (string) $address->{'NK1.4.7'};
						$gt1['gau_county'] = (string) $address->{'NK1.4.9'};
					}else{
						$gt1Address['gau_plot_no'] = (string) $address->{'NK1.4.1'};
						$gt1Address['gau_landmark'] = (string) $address->{'NK1.4.2'};
						$gt1Address['gau_city'] = (string) $address->{'NK1.4.3'};
						$gt1Address['gau_state'] = (string) $this->getIDByValue('id','State','state_code',$address->{'NK1.4.4'},false);
						$gt1Address['gau_zip'] = (string) $address->{'NK1.4.5'};
						$gt1Address['gau_country'] = (string) $this->getIDByValue('id','Country','name',$address->{'NK1.4.6'},false);
						$gt1Address['gau_address_type'] = (string) $address->{'NK1.4.7'};
						$gt1Address['gau_address_type'] = (string) $address->{'NK1.4.7'};
						$gt1Address['gau_county'] = (string) $address->{'NK1.4.9'};
						array_push($gt1Addresses, $gt1Address);
					}
					$cnt++;
				}
				}else{
					$gt1['gau_plot_no'] = (string) $data->{'NK1.4'}->{'NK1.4.1'};
					$gt1['gau_landmark'] = (string) $data->{'NK1.4'}->{'NK1.4.2'};
					$gt1['gau_city'] = (string) $data->{'NK1.4'}->{'NK1.4.3'};
					$gt1['gau_state'] = (string) $this->getIDByValue('id','State','state_code',$data->{'NK1.4'}->{'NK1.4.4'},false);
					$gt1['gau_zip'] = (string) $data->{'NK1.4'}->{'NK1.4.5'};
					$gt1['gau_country'] = (string) $this->getIDByValue('id','Country','name',$data->{'NK1.4'}->{'NK1.4.6'},false);
					$gt1['gau_address_type'] = (string) $data->{'NK1.4'}->{'NK1.4.7'};//(need to check)
					$gt1['gau_county'] = (string) $data->{'NK1.4'}->{'NK1.4.9'};
					
				}
				
				
				$cnt = 0;
				if(count($data->{'NK1.5'}) > 1){
					foreach($data->{'NK1.5'} as $key=>$phone){
						$phoneType = (string) $phone->{'NK1.5.2'};
						if(strtoupper($phoneType) == 'WORK'){
							$phoneType = 'WPN';
						}else if(strtoupper($phoneType) == 'HOME'){
							$phoneType = 'PRN';
						}else if(strtoupper($phoneType) == 'MOBILE' || strtoupper($phoneType) == 'MOBIL'){
							$phoneType = 'PP';
						}
							
						if($cnt == 0){
							if($phoneType){
								$gt1['gau_tele_code'] = (string) $phoneType;
								$gt1['gau_city_code'] = substr($phone->{'NK1.5.1'}, 1, 3);
								$gt1['gau_local_number'] = substr($phone->{'NK1.5.1'}, 5, 3).substr($phone->{'NK1.5.1'}, 9, 4);
								$gt1['gau_extension'] = substr($phone->{'NK1.5.1'}, 14, 7);
							}
						}else{
							if($phoneType){
								$gt1Phone['gau_tele_code'] = (string) $phoneType;
								$gt1Phone['gau_city_code'] = substr($phone->{'NK1.5.1'}, 1, 3);
								$gt1Phone['gau_local_number'] = substr($phone->{'NK1.5.1'}, 5, 3).substr($phone->{'NK1.5.1'}, 9, 4);
								$gt1Phone['gau_extension'] = substr($phone->{'NK1.5.1'}, 14, 7);
							}
								
							
						}
						array_push($gt1Phones, $gt1Phone);
						$cnt++;
					}
						
				}else {
					if($phoneType){
						$gt1['gau_tele_code'] = (string) $phoneType;
						$gt1['gau_city_code'] = substr($data->{'NK1.5'}->{'NK1.5.1'}, 1, 3);
						$gt1['gau_local_number'] = substr($data->{'NK1.5'}->{'NK1.5.1'}, 5, 3).substr($data->{'NK1.5'}->{'NK1.5.1'}, 9, 4);
						$gt1['gau_extension'] = substr($data->{'NK1.5'}->{'NK1.5.1'}, 14, 7);
					}
				}
				
				$cnt = 0;
				if(count($data->{'NK1.6'}) > 1){
					foreach($data->{'NK1.6'} as $key=>$phone){
						$phoneType = (string) $phone->{'NK1.6.2'};
						if(strtoupper($phoneType) == 'WORK'){
							$phoneType = 'WPN';
						}else if(strtoupper($phoneType) == 'HOME'){
							$phoneType = 'PRN';
						}else if(strtoupper($phoneType) == 'MOBILE' || strtoupper($phoneType) == 'MOBIL'){
							$phoneType = 'PP';
						}
							
						if($cnt == 0){
							if($phoneType){
								$gt1Phone['gau_tele_code'] = (string) $phoneType;
								$gt1Phone['gau_city_code'] = substr($phone->{'NK1.6.1'}, 1, 3);
								$gt1Phone['gau_local_number'] = substr($phone->{'NK1.6.1'}, 5, 3).substr($phone->{'NK1.6.1'}, 9, 4);
								$gt1Phone['gau_extension'] = substr($phone->{'NK1.6.1'}, 14, 7);
							}
						}else{
							if($phoneType){
								$gt1Phone['gau_tele_code'] = (string) $phoneType;
								$gt1Phone['gau_city_code'] = substr($phone->{'NK1.6.1'}, 1, 3);
								$gt1Phone['gau_local_number'] = substr($phone->{'NK1.6.1'}, 5, 3).substr($phone->{'NK1.6.1'}, 9, 4);
								$gt1Phone['gau_extension'] = substr($phone->{'NK1.6.1'}, 14, 7);
							}
								
							
						}
						array_push($gt1Phones, $gt1Phone);
						$cnt++;
					}
					
				}else {
				$phoneType = (string) $data->{'NK1.6'}->{'NK1.6.2'};
				if(strtoupper($phoneType) == 'WORK'){
					$phoneType = 'WPN';
				}else if(strtoupper($phoneType) == 'HOME'){
					$phoneType = 'PRN';
				}else if(strtoupper($phoneType) == 'MOBILE' || strtoupper($phoneType) == 'MOBIL'){
					$phoneType = 'PP';
				}
					if($phoneType){
						$gt1Phone['gau_tele_code'] = (string) $phoneType;
						$gt1Phone['gau_city_code'] = substr($data->{'NK1.6'}->{'NK1.6.1'}, 1, 3);
						$gt1Phone['gau_local_number'] = substr($data->{'NK1.6'}->{'NK1.6.1'}, 5, 3).substr($data->{'NK1.6'}->{'NK1.6.1'}, 9, 4);
						$gt1Phone['gau_extension'] = substr($data->{'NK1.6'}->{'NK1.6.1'}, 14, 7);
					}
					array_push($gt1Phones, $gt1Phone);
				}
				
				$gt1['gau_contact_role_identifier'] = (string) $data->{'NK1.7'}->{'NK1.7.1'};//NEED TO DISCUSS
				$gt1['gau_contact_role'] = (string) $data->{'NK1.7'}->{'NK1.7.2'};
				$gt1['gau_eff_date_add'] = (string) $data->{'NK1.8'}->{'NK1.8.1'};
				$gt1['gau_marital_status'] = (string) $data->{'NK1.14'}->{'NK1.14.1'};
				$gt1['gau_sex'] = (string) $this->getGender($data->{'NK1.15'}->{'NK1.15.1'});;
				$gt1['dobg'] = (string) $this->parseDate($data->{'NK1.16'}->{'NK1.16.1'});
				
				$lang1 = (string) $data->{'NK1.20'}->{'NK1.20.1'};
				$lang2 = (string) $data->{'NK1.20'}->{'NK1.20.2'};
				if(empty($lang2)){
					$lang2 = $lang1;
				}
				
				$gt1['gau_preferred_language'] = (string) $this->getIDByValue('code','Language','language',$lang2);;
				$gt1['gau_religion'] = (string) $data->{'NK1.25'}->{'NK1.25.1'};
				$gt1['gau_nationality'] = (string) $data->{'NK1.27'}->{'NK1.27.1'}; 
				
				
				$gt1Array['Guarantor'] = $gt1;
				$gt1Array['CaregiverContact'] = $gt1Phones;
				$gt1Array['Address'] = $gt1Addresses;
				array_push($gt1CompleteArray,$gt1Array);
				unset($gt1Phones);unset($gt1Addresses);unset($gt1Address);unset($gt1Phone);unset($gt1);unset($gt1Array);
			}
		}	
		return $gt1CompleteArray;
	}
	
	public function parseIN1($data,$patientId,$patientUid,$IN2){
		$insurance = $insured = $insuranceData = $insuredData = array();
		$cnt=0;
		$count = count($data);
		foreach($data as $key=> $value){
			if($count > 1){
				if($cnt == $count){
					break;
				}
			}
			$insured['insurance_plan_id'] = (string) $value->{'IN1.2'}->{'IN1.2.1'};
			$insurance['payer_id'] = (string) $value->{'IN1.3'}->{'IN1.3.1'};
			$insurance['name'] = (string) $value->{'IN1.4'}->{'IN1.4.1'};
				
			$insurance['address_one'] = (string) $value->{'IN1.5'}->{'IN1.5.1'};
			$insurance['address_two'] = (string) $value->{'IN1.5'}->{'IN1.5.2'};
			$insurance['city_id'] = (string) $value->{'IN1.5'}->{'IN1.5.3'};
			if(empty($insurance['city_id'])){
				$insurance['city_id'] = '0';
			}
			$insurance['state_id'] = (string) $this->getIDByValue('id','State','state_code',$value->{'IN1.5'}->{'IN1.5.4'},false);
			if(empty($insurance['state_id'])){
				$insurance['state_id'] = '0';
			}
			$insurance['zip'] = (string) $value->{'IN1.5'}->{'IN1.5.5'};
			$insurance['country_id'] = (string) $this->getIDByValue('id','Country','name',$value->{'IN1.5'}->{'IN1.5.6'},false);
			if(empty($insurance['country_id'])){
				$insurance['country_id'] = '0';
			}
			$insurance['address_type'] = (string) $value->{'IN1.5'}->{'IN1.5.7'};
			$insurance['country_parish_code'] = (string) $value->{'IN1.5'}->{'IN1.5.9'};
			
			$insurance['area_city_code'] = substr($value->{'IN1.7'}->{'IN1.7.1'}, 1, 3);
			$insurance['local_num'] = substr($value->{'IN1.7'}->{'IN1.7.1'}, 5, 3).substr($value->{'IN1.7'}->{'IN1.7.1'}, 9, 4);
			$insurance['extention'] = substr($value->{'IN1.7'}->{'IN1.7.1'}, 14, 7);
			$insurance['phone_type'] = (string) $value->{'IN1.7'}->{'IN1.7.2'};
			
			$insured['group_number'] = (string) $value->{'IN1.8'}->{'IN1.8.1'};
			$insured['group_name'] = (string) $value->{'IN1.9'}->{'IN1.9.1'};
			$insured['effective_date'] = (string) $this->parseDate($data->{'IN1.12'}->{'IN1.12.1'});
			$relationShips = Configure::read('relationship_with_insured');
			$insured['authorization_information'] = (string) $this->parseDate($data->{'IN1.14'}->{'IN1.14.1'});
			$insured['authorization_number'] = (string) $this->parseDate($data->{'IN1.14'}->{'IN1.14.2'});
			$rel = (string) $value->{'IN1.17'}->{'IN1.17.1'};
			$rel = explode("/", $rel);
			if(!$rel[1]){
				$rel[1] = $rel[0];
			}
			$insured['relation'] = $rel[1];
			$insured['subscriber_dob'] = (string) $this->parseDate($value->{'IN1.18'}->{'IN1.18.1'});
			
			$insured['subscriber_address1'] = (string) $value->{'IN1.19'}->{'IN1.19.1'};
			$insured['subscriber_address2'] = (string) $value->{'IN1.19'}->{'IN1.19.2'};
			$insured['subscriber_city'] = (string) $value->{'IN1.19'}->{'IN1.19.3'};
			$insured['subscriber_state'] = (string) $this->getIDByValue('id','State','state_code',$value->{'IN1.19'}->{'IN1.19.4'},false);
			$insured['subscriber_zip'] = (string) $value->{'IN1.19'}->{'IN1.19.5'};
			$country = (string) $value->{'IN1.19'}->{'IN1.19.6'};
			if($country == 'US')
				$country = 'USA';
 			$insured['subscriber_country'] = (string) $this->getIDByValue('id','Country','name',$country,false);
			$insured['address_type'] = (string) $value->{'IN1.19'}->{'IN1.19.7'};
			$insured['country_parish_code'] = (string) $value->{'IN1.19'}->{'IN1.19.9'};
			$insured['assignment_of_benefits'] = (string) $value->{'IN1.20'}->{'IN1.20.1'};
			$insured['coordination_of_benefits'] = (string) $value->{'IN1.21'}->{'IN1.21.1'};
			$insured['coordination_of_benefits_priority'] = (string) $value->{'IN1.22'}->{'IN1.22.1'};
			$insured['realease_information_code'] = (string) $value->{'IN1.27'}->{'IN1.27.1'};
			$insured['policy_number'] = (string) $value->{'IN1.36'}->{'IN1.36.1'};
			//pawan
			$insured['patient_uid'] = $patientUid;
			$insured['patient_id'] = $patientId;
			
			$insured['subscriber_name'] = (string) $value->{'IN1.16'}->{'IN1.16.2'};
			$insured['subscriber_last_name'] = (string) $value->{'IN1.16'}->{'IN1.16.1'};
			
			$insured['insured_employment_status'] = (string) $value->{'IN1.42'}->{'IN1.42.1'};
			$insured['insured_employment_description'] = (string) $value->{'IN1.42'}->{'IN1.42.2'};
			
			$insured['subscriber_gender'] = (string) $this->getGender($value->{'IN1.43'}->{'IN1.43.1'});
			
			$insured['emp_address'] = (string) $value->{'IN1.44'}->{'IN1.44.1'}.', '.(string) $value->{'IN1.44'}->{'IN1.44.2'};
			$insured['emp_address'] = rtrim($insured['emp_address'],", ");
			$insured['emp_city'] = (string) $value->{'IN1.44'}->{'IN1.44.3'};
			$insured['emp_state'] = (string) $this->getIDByValue('id','State','state_code',$value->{'IN1.44'}->{'IN1.44.4'},false);
			$country = (string) $value->{'IN1.44'}->{'IN1.44.6'};
			$country = '';
			if($country == 'US')
				$country = 'USA';
			$insured['emp_country'] = (string) $this->getIDByValue('id','Country','name',$country,false);
			$insured['emp_zip_code'] = (string) $value->{'IN1.44'}->{'IN1.44.5'};
			$insured['emp_address_type'] = (string) $value->{'IN1.44'}->{'IN1.44.7'};
			$insured['emp_county_parish_code'] = (string) $value->{'IN1.44'}->{'IN1.44.9'};
			$insured = $this->parseIN2($IN2[$cnt],$insured);
			array_push($insuranceData, $insurance);
			array_push($insuredData, $insured);
			$cnt++;
			
			//pawan end
		}
		return array($insuranceData,$insuredData);
	}

	public function parseIN2($data,$insured2){
		$insured2['subscriber_primary_phone'] = (string) $data->{'IN2.63'}->{'IN2.63.1'};
		$insured2['subscriber_ssn'] = (string) $data->{'IN2.2'}->{'IN2.2.1'};
		$insured2['subscriber_primary_phone'] = (string) $data->{'IN2.63'}->{'IN2.63.1'};
		$insured2['emp_phone'] = (string) $data->{'IN2.64'}->{'IN2.64.1'};
		$insured2['employer'] = (string) $data->{'IN2.70'}->{'IN2.70.1'};
		return $insured2;
		
	}
	
	public function parseGT1($dataArray){
		
		$gt1CompleteArray =array();
		$mainCount = 0;
		foreach($dataArray as $data){
			$gt1 = array();
			$gt1Addresses = array();
			$gt1Address = array();
			$gt1Phone = array();
			$gt1Phones = array();
			$gt1Array =array();
			$gt1['guarantor_id'] = (string) $data->{'GT1.2'}->{'GT1.2.1'};
			$gt1['gau_last_name'] = (string) $data->{'GT1.3'}->{'GT1.3.1'};
			$gt1['gau_first_name'] = (string) $data->{'GT1.3'}->{'GT1.3.2'};
			$gt1['gau_middle_name'] = (string) $data->{'GT1.3'}->{'GT1.3.3'};
			$gt1['gau_suffix'] = (string) $data->{'GT1.3'}->{'GT1.3.4'};
			$gt1['gau_name_type'] = (string) $data->{'GT1.3'}->{'GT1.3.7'};
			$gt1['gau_initial_id'] = (string) $this->getIDByValue('id','Initial','name',$data->{'GT1.3'}->{'GT1.3.5'},'%');
			
			$cnt = 0;
			if(count($data->{'GT1.5'}) > 1){
				foreach($data->{'GT1.5'} as $key=>$address){
					
					if($cnt == 0){
							
						$gt1['gau_plot_no'] = (string) $address->{'GT1.5.1'};
						$gt1['gau_landmark'] = (string) $address->{'GT1.5.2'};
						$gt1['gau_city'] = (string) $address->{'GT1.5.3'};
						$gt1['gau_state'] = (string) $this->getIDByValue('id','State','state_code',$address->{'GT1.5.4'},false);
						$gt1['gau_zip'] = (string) $address->{'GT1.5.5'};
						$gt1['gau_country'] = (string) $this->getIDByValue('id','Country','name',$address->{'GT1.5.6'},false);
						$gt1['gau_address_type'] = (string) $address->{'GT1.5.7'};
						$gt1['gau_county'] = (string) $address->{'GT1.5.9'};
					}else{
						$gt1Address['gau_plot_no'] = (string) $address->{'GT1.5.1'};
						$gt1Address['gau_landmark'] = (string) $address->{'GT1.5.2'};
						$gt1Address['gau_city'] = (string) $address->{'GT1.5.3'};
						$gt1Address['gau_state'] = (string) $this->getIDByValue('id','State','state_code',$address->{'GT1.5.4'},false);
						$gt1Address['gau_zip'] = (string) $address->{'GT1.5.5'};
						$gt1Address['gau_country'] = (string) $this->getIDByValue('id','Country','name',$address->{'GT1.5.6'},false);
						$gt1Address['gau_address_type'] = (string) $address->{'GT1.5.7'};
						$gt1Address['gau_address_type'] = (string) $address->{'GT1.5.7'};
						$gt1Address['gau_county'] = (string) $address->{'GT1.5.9'};
						array_push($gt1Addresses, $gt1Address);
					}
					$cnt++;
				}
					
			}else{
				$gt1['gau_plot_no'] = (string) $data->{'GT1.5'}->{'GT1.5.1'};
				$gt1['gau_landmark'] = (string) $data->{'GT1.5'}->{'GT1.5.2'};
				$gt1['gau_city'] = (string) $data->{'GT1.5'}->{'GT1.5.3'};
				$gt1['gau_state'] = (string) $this->getIDByValue('id','State','state_code',$data->{'GT1.5'}->{'GT1.5.4'},false);
				$gt1['gau_zip'] = (string) $data->{'GT1.5'}->{'GT1.5.5'};
				$gt1['gau_country'] = (string) $this->getIDByValue('id','Country','name',$data->{'GT1.5'}->{'GT1.5.6'},false);
				$gt1['gau_address_type'] = (string) $data->{'GT1.5'}->{'GT1.5.7'};//(need to check)
				$gt1['gau_county'] = (string) $data->{'GT1.5'}->{'GT1.5.9'};
				
			}
			$gt1['relation'] = 'CGV';
		$cnt = 0;
				if(count($data->{'GT1.6'}) > 1){
					foreach($data->{'GT1.6'} as $key=>$phone){
						$phoneType = (string) $phone->{'GT1.6.2'};
						if(strtoupper($phoneType) == 'WORK'){
							$phoneType = 'WPN';
						}else if(strtoupper($phoneType) == 'HOME'){
							$phoneType = 'PRN';
						}else if(strtoupper($phoneType) == 'MOBILE' || strtoupper($phoneType) == 'MOBIL'){
							$phoneType = 'PP';
						}
							
						if($cnt == 0){
							if($phoneType){
								$gt1['gau_tele_code'] = (string) $phoneType;
								$gt1['gau_city_code'] = substr($phone->{'GT1.6.1'}, 1, 3);
								$gt1['gau_local_number'] = substr($phone->{'GT1.6.1'}, 5, 3).substr($phone->{'GT1.6.1'}, 9, 4);
								$gt1['gau_extension'] = substr($phone->{'GT1.6.1'}, 14, 7);
							}
						}else{
							if($phoneType){
								$gt1Phone['gau_tele_code'] = (string) $phoneType;
								$gt1Phone['gau_city_code'] = substr($phone->{'GT1.6.1'}, 1, 3);
								$gt1Phone['gau_local_number'] = substr($phone->{'GT1.6.1'}, 5, 3).substr($phone->{'GT1.6.1'}, 9, 4);
								$gt1Phone['gau_extension'] = substr($phone->{'GT1.6.1'}, 14, 7);
							}
								
							
						}
						array_push($gt1Phones, $gt1Phone);
						$cnt++;
					}
						
				}else {
					if($phoneType){
						$gt1['gau_tele_code'] = (string) $phoneType;
						$gt1['gau_city_code'] = substr($data->{'GT1.6'}->{'GT1.6.1'}, 1, 3);
						$gt1['gau_local_number'] = substr($data->{'GT1.6'}->{'GT1.6.1'}, 5, 3).substr($data->{'GT1.6'}->{'GT1.6.1'}, 9, 4);
						$gt1['gau_extension'] = substr($data->{'GT1.6'}->{'GT1.6.1'}, 14, 7);
					}
				}
			
		$cnt = 0;
				if(count($data->{'GT1.7'}) > 1){
					foreach($data->{'GT1.7'} as $key=>$phone){
						$phoneType = (string) $phone->{'GT1.7.2'};
						if(strtoupper($phoneType) == 'WORK'){
							$phoneType = 'WPN';
						}else if(strtoupper($phoneType) == 'HOME'){
							$phoneType = 'PRN';
						}else if(strtoupper($phoneType) == 'MOBILE' || strtoupper($phoneType) == 'MOBIL'){
							$phoneType = 'PP';
						}
							
						if($cnt == 0){
							if($phoneType){
								$gt1Phone['gau_tele_code'] = (string) $phoneType;
								$gt1Phone['gau_city_code'] = substr($phone->{'GT1.7.1'}, 1, 3);
								$gt1Phone['gau_local_number'] = substr($phone->{'GT1.7.1'}, 5, 3).substr($phone->{'GT1.7.1'}, 9, 4);
								$gt1Phone['gau_extension'] = substr($phone->{'GT1.7.1'}, 14, 7);
							}
						}else{
							if($phoneType){
								$gt1Phone['gau_tele_code'] = (string) $phoneType;
								$gt1Phone['gau_city_code'] = substr($phone->{'GT1.7.1'}, 1, 3);
								$gt1Phone['gau_local_number'] = substr($phone->{'GT1.7.1'}, 5, 3).substr($phone->{'GT1.7.1'}, 9, 4);
								$gt1Phone['gau_extension'] = substr($phone->{'GT1.7.1'}, 14, 7);
							}
								
							
						}
						array_push($gt1Phones, $gt1Phone);
						$cnt++;
					}
					
				}else {
				$phoneType = (string) $data->{'GT1.7'}->{'GT1.7.2'};
				if(strtoupper($phoneType) == 'WORK'){
					$phoneType = 'WPN';
				}else if(strtoupper($phoneType) == 'HOME'){
					$phoneType = 'PRN';
				}else if(strtoupper($phoneType) == 'MOBILE' || strtoupper($phoneType) == 'MOBIL'){
					$phoneType = 'PP';
				}
					if($phoneType){
						$gt1Phone['gau_tele_code'] = (string) $phoneType;
						$gt1Phone['gau_city_code'] = substr($data->{'GT1.7'}->{'GT1.7.1'}, 1, 3);
						$gt1Phone['gau_local_number'] = substr($data->{'GT1.7'}->{'GT1.7.1'}, 5, 3).substr($data->{'GT1.7'}->{'GT1.7.1'}, 9, 4);
						$gt1Phone['gau_extension'] = substr($data->{'GT1.7'}->{'GT1.7.1'}, 14, 7);
					}
					array_push($gt1Phones, $gt1Phone);
				}
			
			
			
			$gt1['dobg'] = (string) $this->parseDate($data->{'GT1.8'}->{'GT1.8.1'});
			$gt1['gau_sex'] = (string) $this->getGender($data->{'GT1.9'}->{'GT1.9.1'});
			$gt1['gau_gaurantor_type'] = (string) $data->{'GT1.10'}->{'GT1.10.1'};
			$gt1['gau_ssn'] = (string) $data->{'GT1.12'}->{'GT1.12.1'};
			$gt1['gau_marital_status'] = (string) $data->{'GT1.30'}->{'GT1.30.1'};
			$gt1['gau_nationality'] = (string) $data->{'GT1.43'}->{'GT1.43.1'};
			
			$lang1 = (string) $data->{'GT1.36'}->{'GT1.36.1'};
			$lang2 = (string) $data->{'GT1.36'}->{'GT1.36.2'};
			if(empty($lang2)){
				$lang2 = $lang1;
			}
			
			$gt1['gau_preferred_language'] = (string) $this->getIDByValue('code','Language','language',$lang2);
			$gt1['gau_religion'] = (string) $data->{'GT1.41'}->{'GT1.41.1'};
			//array_push($gt1Array,$gt1);
			$gt1Array['Guarantor'] = $gt1;
			$gt1Array['CaregiverContact'] = $gt1Phones;
			$gt1Array['Address'] = $gt1Addresses;
			array_push($gt1CompleteArray,$gt1Array);
			unset($gt1Phones);unset($gt1Addresses);unset($gt1Address);unset($gt1Phone);unset($gt1);unset($gt1Array);
			$mainCount++;
		}
		return $gt1CompleteArray;
	}
	
	function parseEVN($data){
		return (string) $data->{'EVN.1'}->{'EVN.1.1'};
	}
	
	function parsePV1($value,$pv2){
		$discharge = $doctor = array();
		$doctor['alternate_id'] = (string) $value->{'PV1.7'}->{'PV1.7.1'};
		$doctor['last_name'] = (string) $value->{'PV1.7'}->{'PV1.7.2'};
		$doctor['first_name'] = (string) $value->{'PV1.7'}->{'PV1.7.3'};
		$doctor['middle_name'] = (string) $value->{'PV1.7'}->{'PV1.7.4'};
		$doctor['suffix'] = (string) $value->{'PV1.7'}->{'PV1.7.5'};
		$doctor['initial_id'] = (string) (string) $this->getIDByValue('id','Initial','name',$value->{'PV1.7'}->{'PV1.7.6'},'%');
		$doctor['is_deleted'] = '0';
		$doctor['is_active'] = '1';
		$doctor['location_id'] = $this->locationId;
		$doctor['location_id'] = '0';
		$doctor['created_time'] = date('Y-m-d H:i:s');
		$doctor['created_by'] = '0';
		
		//Discharge Deatails
		$discharge['discharge_disposition'] = (string) $value->{'PV1.36'}->{'PV1.36.1'};
		$discharge['discharge_to_location'] = (string) $value->{'PV1.37'}->{'PV1.37.1'};
		$discharge['hl7_servicing_facility'] = (string) $value->{'PV1.39'}->{'PV1.39.1'};
		$discharge['form_received_on'] = (string) $this->parseDate($value->{'PV1.44'}->{'PV1.44.1'});
		$discharge['discharge_date'] = (string) $this->parseDate($value->{'PV1.45'}->{'PV1.45.1'});
		$discharge['visit_indicator'] = (string) $value->{'PV1.51'}->{'PV1.51.1'};
		$discharge['hl7_patient_class'] = (string) $value->{'PV1.2'}->{'PV1.2.1'};
		$discharge['hl7_location_point_of_care'] = (string) $value->{'PV1.3'}->{'PV1.3.1'};
		$discharge['hl7_location_room'] = (string) $value->{'PV1.3'}->{'PV1.3.2'};
		$discharge['hl7_location_bed'] = (string) $value->{'PV1.3'}->{'PV1.3.3'};
		$discharge['hl7_location_facility'] = (string) $value->{'PV1.3'}->{'PV1.3.4'};
		$discharge['hl7_admission_type'] = (string) $value->{'PV1.4'}->{'PV1.4.1'};
		$discharge['vip_indicator'] = (string) $value->{'PV1.16'}->{'PV1.16.1'};
		$discharge['hl7_patient_type'] = (string) $value->{'PV1.18'}->{'PV1.18.1'};
		$discharge['hl7_financial_class'] = (string) $value->{'PV1.20'}->{'PV1.20.1'};
		$discharge['hl7_admit_source'] = (string) $value->{'PV1.14'}->{'PV1.14.1'};
		
		$pv2data = $this->parsePV2($pv2);
		
		//$doctorId = $this->checkDoctorExists($doctor);
		$doctorId = $this->getIDByValue('id','User','alternate_id',Configure::read('dhr_clinic_doctor_id'),false);
		return array($doctorId,$discharge,$pv2data);
	}
	
	public function checkDoctorExists($doctorData){
		App::uses('User', 'Model');
		$userModel = new User(null,null,$this->database);
		$userData = $userModel->find('first',array('fields'=>array('User.id'),'conditions'=>array('User.alternate_id'=>$doctorData['alternate_id'],'User.location_id'=>$this->locationId,'User.role_id'=>Configure::read('doctorRoleId'))));
		$doctorData['location_id'] = $this->locationId;
		$doctorData['is_deleted'] = '0';
		$doctorData['doctor_name'] = $doctorData['first_name'].' '.$doctorData['last_name'];
		$doctorData['created_by'] = '0';
		$doctorData['modified_by'] = '0';
		$doctorData['create_time'] = date('Y-m-d H:i:s');
		$doctorData['created_by'] = date('Y-m-d H:i:s');;
		
		
		if(!empty($userData)){
			$userId =  $userData['User']['id'];
		}else{
			//$doctorData['User'] = $doctorData;
			App::uses('Role', 'Model');
			$roleModel = new Role(null,null,$this->database);
			$roleData = $roleModel->find('first',array('fields'=>array('id'),'conditions'=>array('Role.name'=>Configure::read('doctorLabel'))));
			$doctorData['role_id'] = $roleData['Role']['id'];
			$doctorData['is_registrar'] = '0';
			$doctorData = Set::filter($doctorData);
			if($userModel->save($doctorData,array('callbacks' =>false))){
				$doctorData['user_id'] = $userModel->getInsertId();
				App::uses('DoctorProfile', 'Model');
				$doctorModel = new DoctorProfile(null,null,$this->database);
				$doctorData = Set::filter($doctorData);
				$doctorModel->save($doctorData,array('callbacks' =>false));
				$userId = $doctorData['user_id'];
			}
		}
		return $userId;
	}
	
	public function parsePD1($data){
		$additionalData = array();
		$advDir = (string) $data->{'PD1.15'}->{'PD1.15.2'};
		if(empty($advDir)){
			$advDir = (string) $data->{'PD1.15'}->{'PD1.15.1'};
		}
		$additionalData['adv_directive'] = $advDir;
		$additionalData['hl7_patient_handicap'] = (string) $data->{'PD1.6'}->{'PD1.6.1'};
		$additionalData['organ_donor'] = (string) $data->{'PD1.8'}->{'PD1.8.1'};
		if($additionalData['organ_donor'] == 'Y' || $additionalData['organ_donor'] == 'F'){
			$additionalData['organ_donor'] = '1';
		}else{
			$additionalData['organ_donor'] = '0';
		}  
		$additionalData['protection_indicator'] = (string) $data->{'PD1.12'}->{'PD1.12.1'};
		$additionalData['publicity_code'] = (string) $data->{'PD1.11'}->{'PD1.11.1'};
		
		
		return $additionalData;
	}
	
	public function parseADTAL1($data,$patientId,$patientUid){
		$allergyArray= $allergiesArray = array();
		foreach($data as $key=>$value){
			$allergyArray['name'] = (string) $value->{'AL1.3'}->{'AL1.3.2'};
			$allergyArray['status'] = 'A';
			$severity = (string) $value->{'AL1.4'}->{'AL1.4.1'};
			if(strtoupper($severity) == 'MODERATE'){
				$allergyArray['AllergySeverityName'] = 'Moderate';
			}else if(strtoupper($severity) == 'SEVERE'){
				$allergyArray['AllergySeverityName'] = 'Severe';
			}else{
				$allergyArray['AllergySeverityName'] = 'Mild';
			}
			$allergyArray['reaction'] = (string) $value->{'AL1.5'}->{'AL1.5.1'};
			$allergyArray['onset_date'] = (string) $this->parseDate($value->{'AL1.6'}->{'AL1.6.1'});
			$allergyArray['patient_uniqueid'] = $patientId;
			$allergyArray['CompositeAllergyID'] = (string) $this->getIDByValue('id','AllergyMaster','name',$allergyArray['name']);
			$allergyArray['location_id'] = $this->locationId;
			$allergyArray['patient_id'] = $patientUid;
			
			array_push($allergiesArray,$allergyArray);
		}
		return $allergiesArray;
	}
	
	public function parseADTDG1($data,$patientId,$patientUid){
		$diagnosisArray= $diagnosesArray = array();
		foreach($data as $key=>$value){
			$diagnosisArray['preffered_icd9cm'] = (string) $value->{'DG1.3'}->{'DG1.3.1'};
			$diagnosisArray['diagnoses_name'] = (string) $value->{'DG1.3'}->{'DG1.3.2'};
			$diagnosisArray['diagnosis_description'] = (string) $value->{'DG1.4'}->{'DG1.4.1'};
			$diagnosisArray['start_date'] = (string) $this->parseDate($value->{'DG1.5'}->{'DG1.5.1'},false);
			$diagnosisArray['hl7_diagnosis_type'] = (string) $value->{'DG1.6'}->{'DG1.6.1'};
			$diagnosisArray['location_id'] = $this->locationId;
			$priority = (string) $value->{'DG1.15'}->{'DG1.15.1'};
			if($priority == '1'){
				$diagnosisArray['diagnosis_type']  = 'PD';
			}else{
				$diagnosisArray['diagnosis_type']  = 'O';
			}
			$diagnosisArray['u_id'] = $patientUid;
			$allergyArray['patient_id'] = $patientId;
			array_push($diagnosesArray,$diagnosisArray);
		}
		return $diagnosesArray;
	}
	
	public function getEthinicity($ethinic){
		$ethinicities = array('H'=>'2135-2:Hispanic or Latino','N'=>'2186-5:Not Hispanic or Latino','U'=>'UnKnown','D'=>'Denied to Specific','3'=>'2135-2:Hispanic or Latino',);
		return $ethinicities["$ethinic"];
	}

	public function parseROL($data){
		$familyPhysician = array();
		$familyPhysician['last_name'] = (string) $data->{'ROL.4'}->{'ROL.4.2'};
		$familyPhysician['first_name'] = (string) $data->{'ROL.4'}->{'ROL.4.3'};
		$familyPhysician['initial_id'] = (string) $this->getIDByValue('id','Initial','name',$name->{'PID.4.4'},'%');
		$familyPhysician['refferer_doctor_id'] = '2';
		$familyPhysician['is_deleted'] = '0';
		$familyPhysician['is_active'] = '1';
		$familyPhysician['created_by'] = '0';
		$familyPhysician['modified_by'] = '0';
		$familyPhysician['create_time'] = '0';
		$familyPhysician['modify_time'] = '0';
		$familyPhysician['is_registrar'] = '1';
		
		$familyPhysician['hospital_name'] = (string) $data->{'ROL.10'}->{'ROL.10.2'};
		$familyPhysician['location_id'] = $this->locationId;
		
		App::uses('Consultant', 'Model');
		App::uses('City', 'Model');
		App::uses('State', 'Model');
		App::uses('Country', 'Model');
		App::uses('Initial', 'Model');
		$consultantModel = new Consultant(null,null,$this->database);
		$consultantModel->unBindModel(array(
							'belongsTo' => array(new City(null,null,$this->database),
						new State(null,null,$this->database),
						new Country(null,null,$this->database),
						new Initial(null,null,$this->database),	
		)));
		
		$consultantDetails = $consultantModel->find('first',array('fields'=>array('Consultant.id'),'conditions'=>array('Consultant.first_name'=>$familyPhysician['first_name'],'Consultant.last_name'=>$familyPhysician['last_name'],'Consultant.location_id'=>$this->locationId)));
		
		if(!empty($consultantDetails)){
			return $consultantDetails['Consultant']['id'];
		}else{
			$familyPhysician = Set::filter($familyPhysician);
			$consultantDetails = $consultantModel->save($familyPhysician,array('callbacks' =>false));
			$consultantId = $consultantModel->getInsertId();
			return $consultantId;
		}
	}
	
	public function parsePV2($data){
		$pv2 = array();
		$pv2['patient_status_code'] = $data->{'PV2.24'}->{'PV2.24.1'};
		$pv2['visit_publicity_code'] = $data->{'PV2.21'}->{'PV2.21.1'};
		$pv2['visit_protection_indicator'] = $data->{'PV2.22'}->{'PV2.22.1'};
		$pv2['new_born_baby_indicator'] = $data->{'PV2.36'}->{'PV2.36.1'};
		$pv2['complaints'] = $data->{'PV2.3'}->{'PV2.3.2'};
		$pv2['hl7_mode_of_arrival'] = $data->{'PV2.38'}->{'PV2.38.2'};
		
		return $pv2;
	}
	
	public function parseORC($data){
		
	}
	
	public function parseOBR($data,$patientId,$laboratoryId,$orc,$msh,$pv1,$pid){
		$laboratoryResult = array();
		$laboratoryResult['LaboratoryResult']['patient_id'] = $patientId;
		$laboratoryResult['LaboratoryResult']['laboratory_test_order_id'] = $laboratoryId;
		$laboratoryResult['LaboratoryResult']['dhr_laboratory_patient_id'] = $pid->{'PID.3'}->{'PID.3.1'};
		$laboratoryResult['LaboratoryResult']['laboratory_id'] = $this->getIDByValue('id','Laboratory','dhr_order_code',$data->{'OBR.4'}->{'OBR.4.1'});
		$laboratoryResult['LaboratoryResult']['user_id'] = (string) $orc->{'ORC.10'}->{'ORC.10.1'};
		$laboratoryResult['LaboratoryResult']['confirm_result'] = '1';
		$laboratoryResult['LaboratoryResult']['op_name'] = (string) $orc->{'ORC.10'}->{'ORC.10.3'}. ' ' .(string) $orc->{'ORC.10'}->{'ORC.10.2'};
		$laboratoryResult['LaboratoryResult']['ogi_filler_order_number'] = (string) $data->{'OBR.3'}->{'OBR.3.1'};
		$laboratoryResult['LaboratoryResult']['ogi_placer_group_number'] = (string) $pv1->{'PV1.50'}->{'PV1.50.1'};
		$laboratoryResult['LaboratoryResult']['od_universal_service_identifier'] = (string) $data->{'OBR.4'}->{'OBR.4.1'};
		$laboratoryResult['LaboratoryResult']['create_time'] = date("Y-m-d H:i:s");
		$laboratoryResult['LaboratoryResult']['location_id'] = $this->locationId;
		$laboratoryResult['LaboratoryResult']['is_deleted'] = '0';
		$laboratoryResult['LaboratoryResult']['created_by'] = '0';
		$laboratoryResult['LaboratoryResult']['od_observation_date_time'] = $this->parseDate((string) $msh->{'MSH.7'}->{'MSH.7.1'},true);
		$laboratoryResult['LaboratoryResult']['od_observation_start_date_time'] = $this->parseDate((string) $data->{'OBR.22'}->{'OBR.22.1'},true);
		App::uses('LaboratoryResult', 'Model');
		$laboratoryResultModel = new LaboratoryResult(null,null,$this->database);
		$laboratoryResult = Set::filter($laboratoryResult);
		$laboratoryResultDetails = $laboratoryResultModel->save($laboratoryResult);
		return $laboratoryResultModel->getInsertId();
	}
	
	public function parseOBX($data,$laboratoryResultId,$laboratoryTestOrderId,$patientId,$nte,$isSensitivity){
		$cnt = 0;$isOneOBXCount = 0;
		foreach($data as $key=>$value){
			$laboratoryHl7Result = array();
			$laboratoryHl7Result['LaboratoryHl7Result']['laboratory_result_id'] = $laboratoryResultId;
			$laboratoryHl7Result['LaboratoryHl7Result']['laboratory_id'] = trim($this->getIDByValue('id','Laboratory','dhr_result_code',str_replace("CD:","",$value->{'OBX.3'}->{'OBX.3.1'})));
			$laboratoryHl7Result['LaboratoryHl7Result']['location_id'] = $this->locationId;
			$laboratoryHl7Result['LaboratoryHl7Result']['observations'] = (string) $value->{'OBX.3'}->{'OBX.3.1'};
			$mResults = '';
			foreach($value->{'OBX.5'} as $mKey=>$mRes){
				$mResults .= (string) $mRes->{'OBX.5.1'}." {{break}}";
			}
			$mResults = rtrim($mResults,"{{break}}");
			$mResults = trim($mResults);//echo $mResults;exit;
			$laboratoryHl7Result['LaboratoryHl7Result']['result'] = (string) $mResults;
			$laboratoryHl7Result['LaboratoryHl7Result']['uom'] = (string) $value->{'OBX.6'}->{'OBX.6.1'};
			$laboratoryHl7Result['LaboratoryHl7Result']['range'] = (string) $value->{'OBX.7'}->{'OBX.7.1'};
			$laboratoryHl7Result['LaboratoryHl7Result']['abnormal_flag'] = (string) $value->{'OBX.8'}->{'OBX.8.1'};
			$laboratoryHl7Result['LaboratoryHl7Result']['status'] = (string) $value->{'OBX.11'}->{'OBX.11.1'};
			$laboratoryHl7Result['LaboratoryHl7Result']['date_time_of_observation'] = $this->parseDate((string) $value->{'OBX.14'}->{'OBX.14.1'},true);
			$laboratoryHl7Result['LaboratoryHl7Result']['rpl_director_name'] = (string) $value->{'OBX.16'}->{'OBX.16.3'};
			$laboratoryHl7Result['LaboratoryHl7Result']['rpl_director_last_name'] = (string) $value->{'OBX.16'}->{'OBX.16.2'};
			$laboratoryHl7Result['LaboratoryHl7Result']['unit'] = (string) $value->{'OBX.2'}->{'OBX.2.1'};
			$laboratoryHl7Result['LaboratoryHl7Result']['rct_last_name'] = (string) $value->{'OBX.16'}->{'OBX.16.2'};
			$laboratoryHl7Result['LaboratoryHl7Result']['rct_name'] = (string) $value->{'OBX.16'}->{'OBX.16.3'};
			$laboratoryHl7Result['LaboratoryHl7Result']['is_sensitivity'] = $isSensitivity;
			$laboratoryHl7Result['LaboratoryHl7Result']['is_electronically_recorded'] = '1';
			
			$check = array_search('OBX', $this->LABORUNODES); 
			//echo $check;exit;
			$netSubSting = '';
			if($this->LABORUNODES[($check + 1)] == 'NTE'){
				$nteSeg = $nte[$this->nteCounter -1];
				foreach($nteSeg as $nteKey=>$nteValue){
					$netSubSting .= (string) $nteValue->{'NTE.3'}->{'NTE.3.1'}."{{break}}";
				}
				$laboratoryHl7Result['LaboratoryHl7Result']['notes'] = $netSubSting;
				unset($this->LABORUNODES[$check]);unset($this->LABORUNODES[($check + 1)]);
				$this->nteCounter++;
			}
			unset($this->LABORUNODES[$check]);
			//pr($this->LABORUNODES);pr($nte);exit;
			App::uses('LaboratoryHl7Result', 'Model');
			App::uses('LaboratoryResult', 'Model');
			$laboratoryResultModel = new LaboratoryResult(null,null,$this->database);
			$laboratoryResultModel->updateAll(array('LaboratoryResult.rct_name' => '"'.$laboratoryHl7Result['LaboratoryHl7Result']['rct_name'].'"','LaboratoryResult.rct_last_name' => '"'.$laboratoryHl7Result['LaboratoryHl7Result']['rct_last_name'].'"'),array('LaboratoryResult.id'=>$laboratoryResultId));
			$laboratoryResultModel->id = '';
			
			App::uses('LaboratoryHl7Result', 'Model');
			$laboratoryHl7ResultModel = new LaboratoryHl7Result(null,null,$this->database);
			$laboratoryHl7Result = Set::filter($laboratoryHl7Result);
			$laboratoryHl7ResultDetails = $laboratoryHl7ResultModel->save($laboratoryHl7Result);
			$laboratoryHl7ResultModel->id = '';
			//unset($this->obxSegments[(int) $cnt]);//echo count($this->obxSegments);
			$cnt++;
			
		}
	}
	
	public function parseRADOBR($data,$patientId,$radiologyId,$orc,$obx){
		$radiologyResult = $radiologyReports = array();
		App::uses('RadiologyResult', 'Model');
		App::uses('RadiologyReport', 'Model');
		$radiologyResultModel = new RadiologyResult(null,null,$this->database);
		$radiologyReportModel = new RadiologyReport(null,null,$this->database);
		$radiologyResult['RadiologyResult']['patient_id'] = $patientId;
		$radiologyResult['RadiologyResult']['radiology_test_order_id'] = $radiologyId;
		$radiologyResult['RadiologyResult']['radiology_id'] = $this->getIDByValue('id','Radiology','dhr_order_code',$data->{'OBR.4'}->{'OBR.4.1'});
		$radiologyResult['RadiologyResult']['user_id'] = (string) $orc->{'ORC.10'}->{'ORC.10.1'};
		$radiologyResult['RadiologyResult']['confirm_result'] = '1';
		$radiologyResult['RadiologyResult']['filler_order_number'] = (string) $data->{'OBR.3'}->{'OBR.3.1'};
		$radiologyResult['RadiologyResult']['create_time'] = date("Y-m-d H:i:s");
		$radiologyResult['RadiologyResult']['location_id'] = $this->locationId;
		$radiologyResult['RadiologyResult']['is_deleted'] = '0';
		$radiologyResult['RadiologyResult']['created_by'] = '0';
		$cnt = 0;
		
		
		foreach($obx as $key=>$value){
			$isFileExists = $this->getIDByValue('id','RadiologyResult','radiology_test_order_id',$radiologyId);
			$validate = (string) $value->{'OBX.5'}->{'OBX.5.1'};
			$isURL = strpos($validate, "tp://fujisyntestsrv");//echo $isURL.'???'.$value;pr($value);exit;
			if($isURL){
				$radiologyResult['RadiologyResult']['file_name'] = (string) $value->{'OBX.5'}->{'OBX.5.1'};
			}else{
				
				$radiologyResult['RadiologyResult']['img_impression'] .= (string) $value->{'OBX.5'}->{'OBX.5.1'};
				
				foreach($value->{'OBX.5'} as $textKey=>$textValue){
					$temp = preg_replace('/\s+/', ' ',$textValue->{'OBX.5.1'});
					$temp = trim($temp);
					$subText .= $temp."<br>";
					
				}
				$radiologyResult['RadiologyResult']['img_impression'] = $subText;
			}
			$radiologyResult = Set::filter($radiologyResult);
			$radiologyResultModel->id = $isFileExists;
			$radiologyResultModel->set("id",$isFileExists);
			$radiologyResultDetails = $radiologyResultModel->save($radiologyResult);
			if(!$isFileExists)
				$isFileExists = $radiologyResultModel->getInsertID();
			$radiologyResult['RadiologyResult']['radiology_result_id'] = $isFileExists;
			$radiologyResult['RadiologyResult']['note'] = $subText;
			$radiologyResult = Set::filter($radiologyResult);
			$isReportFileExists = $this->getIDByValue('id','RadiologyReport','radiology_result_id',$isFileExists);
			$radiologyReportModel->set('id',$isReportFileExists);
			$radiologyReportModel->id = $isReportFileExists;
			$radiologyReportModel->save($radiologyResult['RadiologyResult']);
			$cnt++;
		}
		
		
		
		return $radiologyResultModel->getInsertId();
	}
	
	
	
}