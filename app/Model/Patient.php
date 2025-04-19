<?php
class Patient extends AppModel {
	public $useTable = 'patients';
	public $name = 'Patient';
	//public $useDbConfig = 'user_data';
	public $specific = true;
	public $actsAs = array('Cipher' => array('autoDecypt' => true),/*'Auditable'*/);//,'Transactional'
	public $validate = array(

			'full_name' => array(
					'rule' => "notEmpty",
					'message' => "Please enter patient name."
			),
			'admission_type' => array(
					'rule' => "notEmpty",
					'message' => "Please select admission type"
			),
			'admission_id' => array(
					'rule' => "isUnique",
					'message' => "Please try again",
					'on'=>'create'
			),
			/*'tariff_standard_id'=> array(
			 'rule' => "notEmpty",
					'on' => 'create',
					'message' => "Please select tariff list "
			),*/
			'lookup_name'		=>array(
					'rule' => "notEmpty",
					'on' => 'create',
					'message' => "There is some problem with lookup name , Please try again"
			)

	);

	/*public $hasMany = array(
			'PharmacySalesBill' => array(
					'className' => 'PharmacySalesBill',
					'dependent' => true,
					'foreignKey' => 'patient_id',
			),
			'InventoryPharmacySalesReturn' => array(
					'className' => 'InventoryPharmacySalesReturn',
					'dependent' => true,
					'foreignKey' => 'patient_id',
			)
	);*/

	public function checkUniqueBed($check){

		$extraContions = array('is_deleted' => 0,'is_discharge'=>0);
		$conditonsval = array_merge($check,$extraContions);
		$countUser = $this->find( 'count', array('conditions' => $conditonsval, 'recursive' => -1) );
		if($countUser >0) {
			return false;
		} else {
			return true;
		}
	}
	/**
	 * @author Gaurav Chauriya
	 * @see Model::beforeFind()
	 */
	public function beforeFind($queryData) {
		parent::beforeFind();
		if(class_exists('cakeSession')){ //added by Mahalaxmi
		$session = new cakeSession();		
		if($session->read('website.instance')=='vadodara'){
			unset($queryData['conditions']['Patient.location_id']);
			unset($queryData['conditions']['location_id']);
		}

		$website=$session->read('website.instance');
		  if($website == 'kanpur')
		  {
			   if (isset($this->data[$this->alias]['location_id'])) {
					//for pharam 25
					if($session->read('locationid') == 25 ){
					 $locationOfClinic = array(1,25);
					}else if ($session->read('locationid') == 26){ //for pharma extension
					 $locationOfClinic = array(22,26);
					}
					if($locationOfClinic)
					$this->data[$this->alias]['location_id'] = $locationOfClinic;
			   } 
		  }
		//$this->log($queryData);
		return $queryData; //return the modified $queryData
		}
	}

	public function beforeSave(){ 
		if (isset($this->data[$this->alias]['full_name'])) {
			$this->data[$this->alias]['full_name'] = ucwords(trim($this->data[$this->alias]['full_name']));
		}
		if (isset($this->data[$this->alias]['last_name'])) {
			$this->data[$this->alias]['last_name'] = ucfirst(trim($this->data[$this->alias]['last_name']));
		}
		if (isset($this->data[$this->alias]['lookup_name'])) {
			$this->data[$this->alias]['lookup_name'] = ucwords(trim($this->data[$this->alias]['lookup_name']));
		}
		 
		if(isset($this->data['Patient']['bed_id']) && !empty($this->data['Patient']['bed_id'])){
			$this->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
			$countUser = $this->find( 'count', array('conditions' => array('is_discharge'=>0,'is_deleted'=>0,'bed_id'=>$this->data['Patient']['bed_id']),
					'recursive' => -1) );
			if($countUser >0) {
				return false;
			} else {
				return true;
			}
		}

		if (isset($this->data[$this->alias]['id'])) {
			unset($this->data[$this->alias]['account_number']);//unique account number from paragon
		}
		
		return true ;
	}

	public function __construct($id = false, $table = null, $ds = null) {		
		if(empty($ds)){
			$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
		}else{		
			$this->db_name =  $ds;
		}
		parent::__construct($id, $table, $ds);
	}
	public function getPatientDetailsByID($id=null){
		$this->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
						'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id' )),
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
				)),false);
		return $this->find("first",
				array('fields'=>array('is_emergency','is_discharge','form_received_on','tariff_standard_id','Patient.family_doctor_id','Patient.instructions','Patient.known_fam_physician',
						'Patient.consultant_id','Patient.family_phy_con_no',
						'Patient.relative_name','Patient.mobile_phone','Patient.create_time','Patient.dateofadmission','Patient.insurance_company_id',
						'Patient.corporate_id','Patient.credit_type_id','Patient.id','Patient.person_id','Patient.registrar_id',
						'Patient.patient_id,Patient.full_name,Patient.lookup_name,Patient.admission_id,Patient.age,Patient.coupon_name,
						Patient.emergency_contact,Patient.email,Patient.mobile_phone,Patient.blood_group,Patient.dob,Patient.sex,Patient.address1,Patient.photo,Patient.address2,Patient.city
						,Patient.state,Patient.zip_code,Patient.country_id,Patient.last_appointment,Patient.account_balance,Patient.ward_id,Patient.room_id,Patient.admission_type,Patient.bed_id,
						Patient.case_summery_link,Patient.location_id,Patient.consultant_treatment','Patient.doctor_id','TariffStandard.name','User.first_name','User.last_name','Person.dob'),'conditions'=>array('Patient.id'=>$id)));
	}


	//function to return formatted the complete address
	/* @params : array of patient details
	 *
	* */
	/*	public function setAddressFormat($patient_details=array()){
	 $format = '';

	if(!empty($patient_details['plot_no']))
		$format .= $patient_details['plot_no'].",";
	if(!empty($patient_details['house_no']))
		$format .= $patient_details['address2'].",";
	if(!empty($patient_details['landmark']))
		$format .= $patient_details['landmark'].",<br/>";
	if(!empty($patient_details['city']))
		$format .= $patient_details['city'].",";
	if(!empty($patient_details['taluka']))
		$format .= $patient_details['taluka'].",<br/>";
	if(!empty($patient_details['district']))
		$format .= $patient_details['district'].",<br/>";
	if(!empty($patient_details['pin_code']))
		$format .= "P.O.Box  ".$patient_details['pin_code'].",<br/>";


	return $format ;
	}  */

	//function to return formatted the complete address
	/* @params : array of patient details
	 *
	* */
	public function setAddressFormat($patient_details=array()){
		$format = '';
		$stateObj=ClassRegistry::init('State');
		if(!empty($patient_details['plot_no']))
			$format .= $patient_details['plot_no']."";
		if(!empty($patient_details['plot_no'])  && !empty($patient_details['landmark']))
			$format .= ', ';
		if(!empty($patient_details['landmark']))
			$format .= ucwords($patient_details['landmark']);

		if(!empty($patient_details['plot_no']) || !empty($patient_details['landmark']))
			$format .= ", <br/>" ;

		if(!empty($patient_details['city']))
			$format .= ucfirst($patient_details['city']);
		if(!empty($patient_details['city']))
			$format .= ', ';
		if(!empty($patient_details['taluka']))
			$format .= ucfirst($patient_details['taluka']);

		if((!empty($patient_details['city']) && !empty($patient_details['taluka'])) && (!empty($patient_details['district']) || !empty($patient_details['state'])))
			$format .= ", <br/>" ;

		if(!empty($patient_details['district']))
			$format .= ucfirst($patient_details['district']);

		if(!empty($patient_details['district']) && !empty($patient_details['state']))
			$format .= ", " ;

		if(!empty($patient_details['state']))
			$state=$stateObj->find('first',array('conditions'=>array('id'=>$patient_details['state'])));
			$format .= ucfirst(/*$patient_details['state']*/$state['State']['name']);

		if(!empty($patient_details['state']) && !empty($patient_details['pin_code']))
			$format .= " " ;
		else
			$format .= "<br/>" ;

		if(!empty($patient_details['pin_code']))
			$format .= $patient_details['pin_code'];

		//pr($format);exit;
		return $format ;
	}

	public function getPatientDetailsByIDWithTariff($id=null,$bill_number=null){
	
		if($bill_number !=''){
			$addBillNumber = 'FinalBilling.bill_number,FinalBilling.discharge_date,FinalBilling.reason_of_discharge';
		}else{
			$addBillNumber ='';
		}
		$this->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'DischargeSummary' =>array('foreignKey' => false,'conditions'=>array('DischargeSummary.patient_id=Patient.id' )),
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
						//'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
						'TariffStandard' =>array('foreignKey'=>false,'conditions'=>array('Patient.tariff_standard_id = TariffStandard.id')),
						//'Language' =>array('foreignKey' => false,'conditions'=>array('Language.id =Person.language' )),
						//'Race' =>array('foreignKey' => false,'conditions'=>array('Race.value_code =Person.race' )),
						'State'=>array('foreignKey'=>false,'conditions'=>array('State.id=Person.state'))
				)),false);
		return $this->find("first",
				array('fields'=>array('User.mobile','DischargeSummary.reason_of_discharge','Person.mobile','Patient.other_consultant','Person.first_name','Person.last_name','Person.P_comm','Person.race','Person.language','Person.ethnicity','Person.ssn_us',
						'Person.plot_no','Person.landmark','Person.city','Person.state','Person.country','Person.pin_code','Person.patient_uid',
						'Person.person_city_code','Person.person_local_number','State.name','Patient.discharge_date','Patient.coupon_name','TariffStandard.id',
						'TariffStandard.name','is_emergency','is_discharge','form_received_on','tariff_standard_id','Patient.family_doctor_id','Patient.instructions',
						'Patient.treatment_type','Patient.payment_category','Patient.known_fam_physician','Patient.consultant_id','Patient.family_phy_con_no',
						'Patient.relative_name','Patient.mobile_phone','Patient.create_time','Patient.dateofadmission','Patient.insurance_company_id',
						'Patient.corporate_id','Patient.credit_type_id','Patient.id','Patient.person_id',
						'Patient.patient_id,Patient.full_name,CONCAT(Patient.lookup_name) as lookup_name,Patient.admission_id,Patient.age,Patient.emergency_contact,Patient.email,Patient.mobile_phone,Patient.blood_group,
						Person.dob,Patient.sex,Patient.address1,Patient.photo,Patient.address2,Patient.city,Patient.state,Patient.zip_code,Patient.country_id,Patient.last_appointment,
						Patient.account_balance,Patient.ward_id,Patient.room_id,Patient.admission_type,Patient.bed_id,Patient.case_summery_link,
						Patient.age,Patient.location_id,Patient.age,Patient.consultant_treatment,Patient.date_of_referral','Patient.doctor_id','Patient.remark',$addBillNumber
				),'conditions'=>array('Patient.id'=>$id)));
	}

	public function getPatientDetailsByIDWithTariffForPatientInformation($id=null,$bill_number=null){
		if($bill_number !=''){
			$addBillNumber = 'FinalBilling.bill_number,FinalBilling.discharge_date,FinalBilling.reason_of_discharge';
		}else{
			$addBillNumber ='';
		}
		/* $this->bindModel(array(
		 'belongsTo' => array(
		 		'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
		 		'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
		 		//'Language' =>array('foreignKey' => false,'conditions'=>array('Language.id =Person.language' )),
		 		//'Race' =>array('foreignKey' => false,'conditions'=>array('Race.value_code =Person.race' )),
		 )),false); */
		return $this->find("first",
				array('fields'=>array('ClinicalSupport.age_e','ClinicalSupport.com_e','ClinicalSupport.dmc','Person.P_comm','Person.race','Person.language','Person.ethnicity','TariffStandard.name','is_emergency','is_discharge','form_received_on','tariff_standard_id','Patient.family_doctor_id','Patient.instructions',
						'Patient.treatment_type','Patient.payment_category','Patient.known_fam_physician','Patient.consultant_id','Patient.family_phy_con_no',
						'Patient.relative_name','Patient.mobile_phone','Patient.create_time','Patient.dateofadmission','Patient.insurance_company_id',
						'Patient.corporate_id','Patient.credit_type_id','Patient.id','Patient.person_id','Patient.newmedicationqr_flag',
						'Patient.patient_id,Patient.full_name,CONCAT(PatientInitial.name," ",Patient.lookup_name) as lookup_name,Patient.admission_id,Patient.age,Patient.emergency_contact,Patient.email,Patient.mobile_phone,Patient.blood_group,
						Person.dob,Patient.sex,Patient.address1,Patient.photo,Patient.address2,Patient.city,Patient.state,Patient.zip_code,Patient.country_id,Patient.last_appointment,
						Patient.account_balance,PatientInitial.name,Patient.ward_id,Patient.room_id,Patient.admission_type,Patient.bed_id,Patient.case_summery_link,
						Patient.age,Patient.location_id,Patient.consultant_treatment,Patient.date_of_referral','Patient.doctor_id','Patient.remark',$addBillNumber
						,'Person.language,Initial.name,Person.first_name,Person.first_name,Person.last_name,Person.age,Person.sex,Person.mobile,
						Person.credit_type_id,Person.photo,Person.patient_uid,Person.plot_no,Person.taluka,Person.district,
						Person.city,Person.landmark,Person.state,Person.pin_code,Person.blood_group,Person.allergies',
						'Person.corporate_id','Person.insurance_company_id','Corporate.name','InsuranceCompany.name','Ward.name','Room.name','Bed.bedno',
						'Diagnosis.final_diagnosis','CONCAT(Initial.name," ",User.first_name, " ", User.last_name) as fullname','User.mobile',
						'count(Appointment.id) as AppointmentCount'),'conditions'=>array('Patient.id'=>$id)));
	}


	public function doctors_details($patient_id=null){
		$this->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->bindModel(array('belongsTo'=>array(
				'User'=>array('foreignKey'=>'doctor_id'),
				'Initial'=>array('foreignKey'=>false,'conditions'=>array('User.initial_id=Initial.id'))
		)));
		$result = $this->find('first',array('conditions'=>array('Patient.id'=>$patient_id),'fields'=>array('CONCAT(Initial.name," ",User.first_name," ",User.last_name) as doctor_name','User.email','User.address1','User.phone1'))) ;
		return $result ;
	}

	/**update last patient registration details.
	 *@params:person models array
	*@params:person_id
	**/

	function updateSponsorDetails($requestData=array(),$id){
			
		if($id){
			$patientData = $this->find('first',array('fields'=>array('id'),'conditions'=>array('Patient.person_id'=>$id,'Patient.is_discharge'=>0),'order'=>'Patient.id Desc')) ;
		}else{
			return ;
		}
		if($patientData['Patient']['id']){
			$data['Patient']['id'] =$patientData['Patient']['id'] ;
			$data["Patient"]['name_of_ip']  = $requestData['Person']['name_of_ip'];
			$data["Patient"]['relation_to_employee']  = $requestData['Person']['relation_to_employee'];
			$data["Patient"]['executive_emp_id_no']  = $requestData['Person']['executive_emp_id_no'];
			$data["Patient"]['non_executive_emp_id_no']  = $requestData['Person']['non_executive_emp_id_no'] ;
			$data["Patient"]['designation']  =$requestData['Person']['designation'];
			$data["Patient"]['insurance_number']  = $requestData['Person']['insurance_number'];
			$data["Patient"]['sponsor_company']  = $requestData['Person']['sponsor_company'];
			//sponsor details
			$data["Patient"]['payment_category']  = $requestData['Person']['payment_category'];
			if($requestData["Person"]['payment_category']=='card'){
				if($data['Person']['credit_type_id'] == 1) {
					$data["Patient"]['credit_type_id']  = $requestData['Person']['credit_type_id'];
					$data["Patient"]['corporate_location_id']  = $requestData['Person']['corporate_location_id'];
					$data["Patient"]['corporate_id']  = $requestData['Person']['corporate_id'];
					$data["Patient"]['corporate_sublocation_id']  = $requestData['Person']['corporate_sublocation_id'] ;
					$data["Patient"]['corporate_otherdetails']  =$requestData['Person']['corporate_otherdetails'];
				}else{
					$data["Patient"]['credit_type_id']  = $requestData['Person']['credit_type_id'];
					$data["Patient"]['insurance_type_id']  = $requestData['Person']['insurance_type_id'];
					$data["Patient"]['insurance_company_id']  = $requestData['Person']['insurance_company_id'];
				}
			}else if($requestData["Person"]['payment_category']=='cash'){
				$data["Patient"]['credit_type_id']  = '';
				$data["Patient"]['corporate_location_id']  = '';
				$data["Patient"]['corporate_id']  = '';
				$data["Patient"]['corporate_sublocation_id']  = '' ;
				$data["Patient"]['corporate_otherdetails']  ='';

				$data["Patient"]['credit_type_id']  = '';
				$data["Patient"]['insurance_type_id']  = '';
				$data["Patient"]['insurance_company_id']  = '';
			}
			$this->save($data);
		}
	}

	//----------------------socket connection-----------------------------------------
	public function getSnomedDetails($id=null){
		$host = "sandbox.e-imo.com";
		$port = "42011";
		$timeout = 15;  //timeout in seconds
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)
		or die("Unable to create socket\n");
		//socket_set_nonblock($socket)
		// or die("Unable to set nonblock on socket\n");

		$result=socket_connect($socket, $host, $port);
		if ($result === false) {
			echo "socket_connect() failed.\nReason: ($result) " .
			socket_strerror(socket_last_error($socket)) . "\n";
		} else {
			//echo "OK.\n";
		}

		$msg_search = "detail^$id^1^e0695fe74f6466d0^" . "\r\n";
		//$msg = "search^10|||1^paracetomol^e0695fe74f6466d0^" . "\r\n";
		//echo $msg_search . "<br/>";
			
		if (!socket_write($socket, $msg_search, strlen($msg_search))) {
			echo socket_last_error($socket);
		}
		else
		{
			//echo "write";
		}
			
		while ($bytes=socket_read($socket, 100000)) {
			if ($bytes === false) {
				echo
				socket_last_error($socket);
				break;
			}
			if (strpos($bytes, "\r\n") != false) break;
		}

		socket_close($socket);
			
		$xmlString="<items>".$bytes."</items>";
		$xmldata = simplexml_load_string($xmlString);
		//print_r($xmldata);
		//print_r($xmldata->ICD9_LEXICALS_TEXT_IMO->RECORD->ICD9_LEXICALS_TEXT_IMO_CODE);
			
		//  echo"SCT_CONCEPT_ID:::"; echo $xmldata->ICD9_SNOMEDCT_IMO->RECORD->SCT_CONCEPT_ID ."<br/>";
		// echo"FULLYSPECIFIEDNAME:::";  echo $xmldata->ICD9_SNOMEDCT_IMO->RECORD->FULLYSPECIFIEDNAME ."<br/>";
		// //echo"SNOMEDID:::";  echo $xmldata->ICD9_SNOMEDCT_IMO->RECORD->SNOMEDID;
			
			
	}

	public function insertPrescription($id=null,$patient_uniqueid=null,$data =array()){

		$Prescription=ClassRegistry::init('NewCropPrescription');
		$adverseEventTrigger=ClassRegistry::init('AdverseEventTrigger');
		$this->uses=array('NewCropPrescription');
		$session     = new cakeSession();
		$userid 	 = $session->read('userid') ;
		$locationId  = $session->read('locationid') ;
		$this->create();
		//debug($data);
		//$Prescription->deleteAll(array('patient_uniqueid'=>$patient_uniqueid,'is_ccda' => 0,'is_discharge_medication' => 0,'is_reconcile'=>0,'is_assessment'=>'0'),false);
		$CountOfPrescriptionRecord=count($data);
		//BOF adverse event
		$adverseEventTriggerArray  = $adverseEventTrigger->getEventTriggers(array("values"),array("section"=>"medication"));
		//EOF adverse event

		//for($counter=0;$counter < $CountOfPrescriptionRecord;$counter++){

		foreach($data as $key =>$value){
			$expdate=explode("T",$value['date_of_prescription']);
				
			//BOF adverse event cross check
			$drug_name = $value['drug_name'] ;
			$adverse_event = 0 ;

			if($this->strpos_in_array($drug_name,$adverseEventTriggerArray)){
				$adverse_event = 1 ;
			}
			$value['adverse_event'] = $adverse_event ;
				
			$value['location_id']= $locationId ;
			$value['drm_date']= $expdate[0] ;
			$value['patient_id']= $id ;
			$value['prescribed_from']= "NewCrop" ;
			$value['created_by']= $userid ;
				
				
				
			//$prescriptionDataCount = $Prescription->find('first',array('fields'=>array('id'),'conditions' =>array('patient_uniqueid'=>$patient_uniqueid,'drug_id'=> $value['drug_id'])));
			$prescriptionDataCount = $Prescription->find('first',array('fields'=>array('id','is_posted','archive','patient_uniqueid','frequency'),'conditions' =>array('patient_id'=>$id,'drug_id'=> $value['drug_id'])));

			if($prescriptionDataCount['NewCropPrescription']['archive']=='D')
				continue; //if medication is deleted then do not do anything with this medication
				
				

			if(!empty($prescriptionDataCount['NewCropPrescription']['id'])||$allergyDataCount[0]['NewCropAllergies']['id']!='null')
			{
				if($prescriptionDataCount['NewCropPrescription']['is_posted']=='no')
					continue; // do not update further if is_posted is no
					
				$value['id']= $prescriptionDataCount['NewCropPrescription']['id'];
				$value['patient_uniqueid']= $prescriptionDataCount['NewCropPrescription']['patient_uniqueid'];
			}
			else
			{
				$value['is_posted']= "yes";
				$value['patient_uniqueid']= $patient_uniqueid;
			}

			// frequency stat, Now and fasting is not present in newcrop so do not sync and update in the newcropprescription table
				
			if($prescriptionDataCount["NewCropPrescription"]["frequency"]=='20' || $prescriptionDataCount["NewCropPrescription"]["frequency"]=='31' || $prescriptionDataCount["NewCropPrescription"]["frequency"]=='32')
				$value['frequency']=$prescriptionDataCount["NewCropPrescription"]["frequency"];
				
			//exit;
				
				
				
			//,'PrescriptionGuid'=> $value['PrescriptionGuid'],'PrescriptionGuid !='=> ""
			//,'PrescriptionGuid'=> $value['PrescriptionGuid']
			//EOF adverse event cross check
			$Prescription->save($value);
				
				
			/* $Prescription->saveAll(array('drug_id'=>$data[$counter]['1'],'description'=>$data[$counter]['0'],'date_of_prescription'=>$data[$counter]['2'],
			 'drm_date'=>$expdate['0'],'patient_id'=>$id,'route'=>$data[$counter]['4'],'rxnorm'=>$data[$counter]['5'],'frequency'=>$data[$counter]['6'],
					'dose'=>$data[$counter]['7'],'archive'=>$data[$counter]['8'],'patient_uniqueid'=>$patient_uniqueid,'location_id'=>$locationId,
					'dose_unit'=>$data[$counter]['10'],'drug_name'=>$drug_name,'adverse_event'=>$adverse_event)); */

			$Prescription->$patient_uniqueid=null;
			$Prescription->id=null;
		}
	}


	public function insertPatientPrescription($id=null,$patient_uniqueid=null,$data =array()){
		//echo "<pre>";print_r($data); exit;
		//echo "hello";exit;
		//echo "<pre>";print_r($data);exit;
		$Prescription=ClassRegistry::init('NewCropPrescription');
		$this->uses=array('NewCropPrescription');
		$session     = new cakeSession();
		$userid 	 = $session->read('userid') ;
		$locationId  = $session->read('locationid') ;



		$this->create();
		//$Prescription->deleteAll(array('patient_uniqueid'=>$patient_uniqueid,'is_ccda' => 0,'is_discharge_medication' => 2,'is_reconcile'=>0),false);
		$CountOfPrescriptionRecord=count($data);

		//echo "<pre>";print_r($data); exit;
		//debug($data);
		//debug('hree');
		//$Prescription->find('all',array('fields'=>array('is_delete_date'),'condition'))
		for($counter=0;$counter < $CountOfPrescriptionRecord;$counter++){


			$expdate=explode("T",$data['0']['2']);
			//echo $expdate['0'];
			//exit;
			$Prescription->saveAll(array('drug_id'=>$data[$counter]['1'],'description'=>$data[$counter]['0'],'date_of_prescription'=>$data[$counter]['2'],'drm_date'=>$expdate['0'],'patient_id'=>$id,'route'=>$data[$counter]['4'],'rxnorm'=>$data[$counter]['5'],'frequency'=>$data[$counter]['6'],'dose'=>$data[$counter]['7'],'archive'=>$data[$counter]['8'],'patient_uniqueid'=>$patient_uniqueid,'location_id'=>$locationId,'is_discharge_medication'=>'2' ));
			$Prescription->$patient_uniqueid=null;


		}
		//exit;fdggfdg

	}


	public function insertAllergies($patient_id=null,$id=null,$data =array()){
		$Allergies=ClassRegistry::init('NewCropAllergies');
		$this->uses=array('NewCropAllergies');
		$session     = new cakeSession();
		$userid 	 = $session->read('userid') ;
		$locationId  = $session->read('locationid') ;
		$this->create();
		$CountOfAllergiesRecord=count($data);
		$deleteAllergyArr=array();



		$allergyPresent = $Allergies->find('all',array('fields'=>array('id','CompositeAllergyID','note','onset_date'),'conditions' =>array('patient_id'=>$patient_id,'is_deleted'=>'0','is_posted'=>'yes')));
		 
		foreach($allergyPresent as $key=>$myData){
			$testDataNC[]=$myData['NewCropAllergies']['CompositeAllergyID'];
			$testDataNCnote[]=$myData['NewCropAllergies']['note'];
			$myOnSet=explode(' ',$myData['NewCropAllergies']['onset_date']);
			$testDataNConset_date[]=$myOnSet[0];
		}
		foreach($data as $dataNC){
			$testDataFromNC[]=$dataNC['0'];
		}
		 


		for($cnt=0;$cnt<=count($allergyPresent);$cnt++)
		{
			if((!(in_array($testDataNC[$cnt],$testDataFromNC))))
			{
				$deleteAllergyArrNewcrop[]=$testDataNC[$cnt];

			}
				
		}


		if(!empty($deleteAllergyArrNewcrop[0]))
		{
			$Allergies->updateAll(array('is_deleted' => 1), array('patient_id'=>$patient_id,'is_posted'=>'yes','CompositeAllergyID'=>$deleteAllergyArrNewcrop));
		}
		 

		 
		/*foreach($allergyPresent as $key =>$allergyPresentvalue){
		 	
		if($allergyPresentvalue['NewCropAllergies']['CompositeAllergyID']==)
			continue;// do not do anything when if it is not posted
	 }*/

		//  $Allergies->deleteAll(array('patient_id'=>$patient_id,'is_posted'=>'yes'),false);
		for($counter=0;$counter<$CountOfAllergiesRecord ;$counter++){
			$onset_date=substr($data[$counter]['13'],0,4)."-".substr($data[$counter]['13'],4,2)."-".substr($data[$counter]['13'],6,2);
			//M sir
			$allergyDataCount = $Allergies->find('all',array('fields'=>array('id','is_posted','is_deleted','CompositeAllergyID','status'),
					'conditions' =>array('patient_id'=>$patient_id,'CompositeAllergyID'=> $data[$counter]['0'])));

			if($allergyDataCount[0]['NewCropAllergies']['status']=='N'){
				continue;
			}

			if($allergyDataCount[0]['NewCropAllergies']['is_deleted']=='1'){
				continue;
			}

			if($allergyDataCount['NewCropAllergies']['is_posted']=='no')
				continue; // do not update further if is_posted is no
				
			if(!empty($allergyDataCount[0]['NewCropAllergies']['id']) ||$allergyDataCount[0]['NewCropAllergies']['id']!='null')
			{
					
				$value['id']= $allergyDataCount[0]['NewCropAllergies']['id'];
			}
			elseif(empty($data[$counter]['0']))
			{
				$value['id']="";
				$value['is_posted']= "yes";
				$value['patient_uniqueid']= $id;

			}
			else
			{
				$value['id']="";
				$value['is_posted']= "yes";
				$value['patient_uniqueid']= $id;

			}
			//ENd
				
			if(empty($value['id']))
				$value['patient_uniqueid']= $id;
			//ENd
			$value['is_posted']= "yes";

			$value['CompositeAllergyID'] = $data[$counter]['0'] ;
			$value['AllergySourceID']= $data[$counter]['1'];
			$value['AllergyConceptId']= $data[$counter]['3'] ;
			$value['ConceptType']= $data[$counter]['4'] ;
			$value['AllergySeverityTypeId']= $data[$counter]['7'] ;
			$value['AllergySeverityName']= $data[$counter]['8'] ;
			$value['note']= $data[$counter]['9'] ;
			$value['ConceptID']= $data[$counter]['10'] ;
			$value['ConceptTypeId']= $data[$counter]['11'] ;
			$value['name']= $data[$counter]['5'] ;
			$value['allergies_id']= $data[$counter]['2'] ;
			$value['status']= $data[$counter]['6'] ;
			$value['rxnorm']= $data[$counter]['12'] ;
			$value['patient_id']= $patient_id ;
			//$value['patient_uniqueid']= $id ;
			$value['location_id']= $locationId ;
			$value['onset_date']= $onset_date ;
			//debug($testDataNCnote);debug($testDataNConset_date); debug($value);debug($testDataNC); exit;
			/* if(!(in_array($value['CompositeAllergyID'],$testDataNC))){ */
			//if(($value['note']!=$testDataNCnote[$counter]) || $value['onset_date']!=$testDataNConset_date[$counter]){
			$Allergies->save($value);
			//}
			//else{
			//}
	 	$Allergies->id=null;
		}
	}

	public function insertPatientMedications($id=null,$patient_uniqueid=null,$data =array()){
		//echo "<pre>";print_r($data); exit;
		//echo "hello";exit;
		//echo "<pre>";print_r($data);exit;
		$Prescription=ClassRegistry::init('NewCropPrescription');
		$this->uses=array('NewCropPrescription');
		$session     = new cakeSession();
		$userid 	 = $session->read('userid') ;
		$locationId  = $session->read('locationid') ;



		$this->create();
		//$Prescription->deleteAll(array('patient_uniqueid'=>$patient_uniqueid,'is_ccda' => 0,'is_discharge_medication' => 2,'is_reconcile'=>0),false);
		$CountOfPrescriptionRecord=count($data);

		//echo "<pre>";print_r($data); exit;
		//debug($data);
		//debug('hree');
		//$Prescription->find('all',array('fields'=>array('is_delete_date'),'condition'))
		for($counter=0;$counter < $CountOfPrescriptionRecord;$counter++){


			$expdate=explode("T",$data['0']['2']);
			//echo $expdate['0'];
			//exit;
			$Prescription->saveAll(array('drug_id'=>$data[$counter]['1'],'uncheck'=>'1','description'=>$data[$counter]['0'],'date_of_prescription'=>$data[$counter]['2'],'drm_date'=>$expdate['0'],'patient_id'=>$id,'route'=>$data[$counter]['4'],'rxnorm'=>$data[$counter]['5'],'frequency'=>$data[$counter]['6'],'dose'=>$data[$counter]['7'],'archive'=>$data[$counter]['8'],'patient_uniqueid'=>$patient_uniqueid,'location_id'=>$locationId,'is_discharge_medication'=>'2' ));
			$Prescription->$patient_uniqueid=null;


		}
		//exit;fdggfdg

	}

	public function updatePatientMedications($id=null,$data=array(),$update_id=array()){
		//echo"<pre>";print_r($id);
		$Prescription=ClassRegistry::init('NewCropPrescription');
		$this->uses=array('NewCropPrescription');
		$session     = new cakeSession();
		$userid 	 = $session->read('userid') ;
		$locationId  = $session->read('locationid') ;
		$this->create();
		//echo"<pre>";print_r($data);exit;
		$CountOfPrescriptionRecord=count($data);
		//echo "<pre>";print_r($CountOfPrescriptionRecord);

		$Prescription->deleteAll(array('patient_uniqueid'=>$id,'is_ccda' => 0,'is_discharge_medication' => 2,'is_reconcile'=>0),false);
		echo"<pre>";print_r($data);exit;
		for($i=0;$i<count($data);$i++){
			$prescription_name_count = $Prescription->find('count',array('conditions'=>array('drug_id'=>$data[$i]['1'],'patient_uniqueid'=>$id,'is_discharge_medication' => 2,'archive' => 'N')));

			//echo "test";print_r($prescription_name_count);//exit;

			if($prescription_name_count=='0'){
					
					
				$expdate=explode("T",$data[$i]['2']);
				$Prescription->saveAll(array('drug_id'=>$data[$i]['1'],'description'=>$data[$i]['0'],'date_of_prescription'=>$data[$i]['2'],'drm_date'=>$expdate['0'],'route'=>$data[$i]['4'],'rxnorm'=>$data[$i]['5'],'frequency'=>$data[$i]['6'],'dose'=>$data[$i]['7'],'archive'=>$data[$i]['8'],'patient_uniqueid'=>$id,'location_id'=>$locationId,'is_discharge_medication'=>'2' ));
	 		$Prescription->$id=null;


			}
		}//debug($Prescription->getDataSource()->getLog(false, false));exit;
	}

	public function insertPatientAllergies($id=null,$data =array()){
		$Allergies=ClassRegistry::init('NewCropAllergies');
		$this->uses=array('NewCropAllergies');
		$session     = new cakeSession();
		$userid 	 = $session->read('userid') ;
		$locationId  = $session->read('locationid');
		$this->create();
		$CountOfAllergiesRecord=count($data);
		//debug($data);
		for($counter=0;$counter< $CountOfAllergiesRecord ;$counter++){
				
			//debug($data[$counter]);
			$Allergies->saveAll(array('CompositeAllergyID'=>$data[$counter]['0'],
					'AllergySourceID'=>$data[$counter]['1'],'AllergyConceptId'=>$data[$counter]['3'],
					'ConceptType'=>$data[$counter]['4'],'AllergySeverityTypeId'=>$data[$counter]['7'],
					'AllergySeverityName'=>$data[$counter]['8'],'note'=>$data[$counter]['9'],
					'created'=>date("Y/m/d"),'ConceptID'=>$data[$counter]['10'],
					'ConceptTypeId'=>$data[$counter]['11'],'name'=>$data[$counter]['5'],
					'allergies_id'=>$data[$counter]['2'],'status'=>$data[$counter]['6'],
					'rxnorm'=>$data[$counter]['12'],'patient_id'=>$patient_id,
					'patient_uniqueid'=>$id,'location_id'=>$locationId,
					'is_discharge_allergy'=>'1','allergycheck'=>'1','onset_date'=>$data[$counter]['13']));
			$Prescription->id=null;
		}
	}

	public function updatePatientAllergies($id=null,$data =array(),$update_id = array()){
		$Allergies=ClassRegistry::init('NewCropAllergies');
		$this->uses=array('NewCropAllergies');
		$session     = new cakeSession();
		$userid 	 = $session->read('userid') ;
		$locationId  = $session->read('locationid') ;
		$this->create();
		$CountOfAllergiesRecord=count($data);
		//echo"<pre>";print_r($data);exit;
		$Allergies->deleteAll(array('patient_uniqueid'=>$id,'is_ccda'=>0,'is_discharge_allergy'=>'1','is_date_flag'=>0,'is_reconcile'=>0),false);
		for($i=0;$i<count($data);$i++){
			$allergy_name_count = $Allergies->find('count',array('conditions'=>array('name'=>$data[$i]['5'],'patient_uniqueid'=>$id,'status'=>'A','is_discharge_allergy'=>'1','is_reconcile'=>0)));
			//echo "<pre>";print_r($allergy_name_count);
			if($allergy_name_count == 0){
				$Allergies->saveAll(array('CompositeAllergyID'=>$data[$i]['0'],
						'AllergySourceID'=>$data[$i]['1'],'AllergyConceptId'=>$data[$i]['3'],
						'ConceptType'=>$data[$i]['4'],'AllergySeverityTypeId'=>$data[$i]['7'],
						'AllergySeverityName'=>$data[$i]['8'],'note'=>$data[$i]['9'],'created'=>date("Y/m/d"),'ConceptID'=>$data[$i]['10'],'ConceptTypeId'=>$data[$i]['11'],'name'=>$data[$i]['5'],'allergies_id'=>$data[$i]['2'],'status'=>$data[$i]['6'],'rxnorm'=>$data[$i]['12'],'patient_id'=>$patient_id,'patient_uniqueid'=>$id,'location_id'=>$locationId,'is_discharge_allergy'=>'1'));
				$Allergies->id=null;
					
			}
		}
	}


	public function get_medication_record($id=null){
		$curlData = '';
		$curlData.='<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
				<soap:Body>';

		$curlData.='<GetPatientFullMedicationHistory6 xmlns="https://secure.newcropaccounts.com/V7/webservices">';
		$curlData.= '<credentials>
				<partnerName>'.Configure::read('partnername').'</partnerName>
						<name>'.Configure::read('uname').'</name>
								<password>'.Configure::read('passw').'</password>
										</credentials>';
		$curlData.=' <accountRequest>
				<AccountId>drmhope</AccountId>
				<SiteId>1</SiteId>
				</accountRequest>';
		$curlData.=' <patientRequest>
				<PatientId>'.$id.'</PatientId>
						</patientRequest>';
		$curlData.=' <prescriptionHistoryRequest>
				<StartHistory>2004-01-01T00:00:00.000</StartHistory>
				<EndHistory>2012-01-01T00:00:00.000</EndHistory>
				<PrescriptionStatus>C</PrescriptionStatus>
				<PrescriptionSubStatus>%</PrescriptionSubStatus>
				<PrescriptionArchiveStatus>%</PrescriptionArchiveStatus>
				</prescriptionHistoryRequest>';
		$curlData.=' <patientInformationRequester>
				<UserType>S</UserType>
				<UserId>'.$id.'</UserId>
						</patientInformationRequester>';
		$curlData.=' <patientIdType>string</patientIdType>
				<includeSchema>Y</includeSchema>
				</GetPatientFullMedicationHistory6>
				</soap:Body>
				</soap:Envelope>';
		$url='http://preproduction.newcropaccounts.com//v7/WebServices/Update1.asmx';
		$curl = curl_init();

		curl_setopt ($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl,CURLOPT_TIMEOUT,120);
		//curl_setopt($curl,CURLOPT_ENCODING,'gzip');

		curl_setopt($curl,CURLOPT_HTTPHEADER,array (
		'SOAPAction:"https://secure.newcropaccounts.com/V7/webservices/GetPatientFullMedicationHistory6"',
		'Content-Type: text/xml; charset=utf-8',
		));

		curl_setopt ($curl, CURLOPT_POST, 1);
		curl_setopt ($curl, CURLOPT_POSTFIELDS, $curlData);

		$result = curl_exec($curl);
		curl_close ($curl);
		$xml =simplexml_load_string($result);
		$xml->registerXPathNamespace("soap", "http://schemas.xmlsoap.org/soap/envelope/");
		$finalxml=$xml->xpath('//soap:Body');
		//print_r($finalxml[0]);

		//$finalxml=(array)$finalxml[0];
		//echo  echo $xmldata->ICD9_DEFINITIONS_IMO->RECORD->DEFINITION_TEXT;
		$finalxml=$finalxml[0];

		//echo $finalxml["GetPatientFullMedicationHistory6Response"]
		$staus= $finalxml->GetPatientFullMedicationHistory6Response->GetPatientFullMedicationHistory6Result->Status;
		$response= $finalxml->GetPatientFullMedicationHistory6Response->GetPatientFullMedicationHistory6Result->XmlResponse;
		$rowcount= $finalxml->GetPatientFullMedicationHistory6Response->GetPatientFullMedicationHistory6Result->RowCount;

		$xmlString= base64_decode($response);

		$xmldata = simplexml_load_string($xmlString);
		// echo '<pre>';print_r($xmldata); exit;
		if($rowcount>1){
			for($i=0;$i<$rowcount;$i++){
				$newcrop_DrugInfo= $xmldata->Table[$i]->DrugInfo;
				$newcrop_DrugID= $xmldata->Table[$i]->DrugID;
				$newcrop_Rxnorm= $xmldata->Table[$i]->rxcui;
				$newcrop_PrescriptionDate= $xmldata->Table[$i]->PrescriptionDate;
				$newcrop_ExternalPatientID= $xmldata->Table[$i]->ExternalPatientID;
				$newcrop_Route= $xmldata->Table[$i]->Route;
				$newcrop_DosageFrequencyDescription= $xmldata->Table[$i]->DosageFrequencyDescription;
				$newcrop_DosageNumberDescription= $xmldata->Table[$i]->DosageNumberDescription;
				$newcrop_Strength= $xmldata->Table[$i]->Strength;
				$newcrop_StrengthUOM= $xmldata->Table[$i]->StrengthUOM;
				$sample = $newcrop_DrugInfo .">>>>".$newcrop_DrugID.">>>>".$newcrop_Rxnorm.">>>>".$newcrop_PrescriptionDate.">>>>".$newcrop_ExternalPatientID .">>>>".$newcrop_Route.">>>>".$newcrop_DosageFrequencyDescription.">>>>".$newcrop_DosageNumberDescription.">>>>".$newcrop_Strength.">>>>".$newcrop_StrengthUOM.">>>>"."~".$sample;

			}
			//echo '<pre>';print_r($xmldata); exit;
			return $sample;
		}
		else{
			$newcrop_DrugInfo= $xmldata->Table->DrugInfo;
			$newcrop_DrugID= $xmldata->Table->DrugID;
			$newcrop_Rxnorm= $xmldata->Table[$i]->rxcui;
			$newcrop_PrescriptionDate= $xmldata->Table->PrescriptionDate;
			$newcrop_ExternalPatientID= $xmldata->Table->ExternalPatientID;
			if($newcrop_DrugID!=""){

				$sample = $newcrop_DrugInfo .">>>>".$newcrop_DrugID.">>>>".$newcrop_Rxnorm.">>>>".$newcrop_PrescriptionDate.">>>>".$newcrop_ExternalPatientID ."~".$sample;
			}
			else{
				$sample="";
			}

			return $sample;
		}

	}


	public function PatientAllergies($id=null){

		$curlData.='<?xml version="1.0" encoding="utf-8"?>';
		$curlData.='<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
				<soap:Body>';
		$curlData.='<GetPatientAllergyHistoryV3 xmlns="https://secure.newcropaccounts.com/V7/webservices">';
		$curlData.='<credentials>
				<partnerName>'.Configure::read('partnername').'</partnerName>
						<name>'.Configure::read('uname').'</name>
								<password>'.Configure::read('passw').'</password>
										</credentials>';
		$curlData.='<accountRequest>
				<AccountId>drmhope</AccountId>
				<SiteId>1</SiteId>
				</accountRequest>';
		$curlData.='<patientRequest>
				<PatientId>'.$id.'</PatientId>
						</patientRequest>';
		$curlData.='<patientInformationRequester>
				<UserType>S</UserType>
				<UserId>'.$id.'</UserId>
						</patientInformationRequester>';
		$curlData.=' </GetPatientAllergyHistoryV3>
				</soap:Body>
				</soap:Envelope>';
		$url='http://preproduction.newcropaccounts.com//v7/WebServices/Update1.asmx';
		$curl = curl_init();

		curl_setopt ($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl,CURLOPT_TIMEOUT,120);
		//curl_setopt($curl,CURLOPT_ENCODING,'gzip');

		curl_setopt($curl,CURLOPT_HTTPHEADER,array (
		'SOAPAction:"https://secure.newcropaccounts.com/V7/webservices/GetPatientAllergyHistoryV3"',
		'Content-Type: text/xml; charset=utf-8',
		));

		curl_setopt ($curl, CURLOPT_POST, 1);
		curl_setopt ($curl, CURLOPT_POSTFIELDS, $curlData);

		$result = curl_exec($curl);
		curl_close ($curl);
		$xml =simplexml_load_string($result);
		$xml->registerXPathNamespace("soap", "http://schemas.xmlsoap.org/soap/envelope/");
		$finalxml=$xml->xpath('//soap:Body');
		//print_r($finalxml[0]);

		//$finalxml=(array)$finalxml[0];
		//echo  echo $xmldata->ICD9_DEFINITIONS_IMO->RECORD->DEFINITION_TEXT;
		$finalxml=$finalxml[0];
		//	print_r($finalxml);
		//echo $finalxml["GetPatientFullMedicationHistory6Response"]
		$staus= $finalxml->GetPatientAllergyHistoryV3Response->GetPatientAllergyHistoryV3Result->Status;
		$response= $finalxml->GetPatientAllergyHistoryV3Response->GetPatientAllergyHistoryV3Result->XmlResponse;
		$rowcount= $finalxml->GetPatientAllergyHistoryV3Response->GetPatientAllergyHistoryV3Result->RowCount;
		$xmlString= base64_decode($response);
			
		$xmldata = simplexml_load_string($xmlString);//echo '<pre>';print_r($xmldata);exit;
			
		if($rowcount>1){
			for($i=0;$i<$rowcount;$i++){
				$newcrop_AllergyId= $xmldata->Table[$i]->AllergyId;
				$newcrop_rxcui= $xmldata->Table[$i]->rxcui;
				$newcrop_AllergyName= $xmldata->Table[$i]->AllergyName;
				$newcrop_AllergyStatus= $xmldata->Table[$i]->Status;
				$newcrop_AllergyReaction= $xmldata->Table[$i]->AllergyNotes;


				$collectedAllergies = $newcrop_AllergyId .">>>>".$newcrop_AllergyName.">>>>".$newcrop_rxcui.">>>>".$newcrop_AllergyStatus.">>>>".$newcrop_AllergyReaction."~".$collectedAllergies;


			}


			return $collectedAllergies;

		}
		else{
			$newcrop_AllergyId= $xmldata->Table->AllergyId;
			$newcrop_AllergyName= $xmldata->Table->AllergyName;
			$newcrop_AllergyReaction= $xmldata->Table->AllergyNotes;
			if($newcrop_AllergyName!=""){
				$collectedAllergies = $newcrop_AllergyId .">>>>".$newcrop_rxcui.">>>>".$newcrop_AllergyName.">>>>".$newcrop_AllergyReaction."~".$collectedAllergies;
			}
			else{
				return $collectedAllergies="";
			}
			//$collectedAllergies = $newcrop_AllergyId .">>>>".$newcrop_AllergyName."~".$collectedAllergies;
			return $collectedAllergies;
		}

	}

	public function getTargetPatient($patientCcdaObj){
		//$this->uses = array('Patient','Person');
		$person = ClassRegistry::init('Person');
		$race = ClassRegistry::init('Race');
		$ethicinity = ClassRegistry::init('Ethnicity');
		$language = ClassRegistry::init('Language');

		$raceData = $race->find('list',array('fields' => array('value_code','race_name')));

		$languageData = $language->find('list',array('fields' => array('id','language')));

		if($patientCcdaObj->ethnicity == 'Hispanic or Latino'){
			$ethicinity = '2135-2:Hispanic or Latino';
		}else if($patientCcdaObj->ethnicity == 'Not Hispanic or Latino'){
			$ethicinity = '2186-5:Not Hispanic or Latino';
		}else{
			$ethicinity = $patientCcdaObj->ethnicity;
		}

		$personData = $person->find('first',array('fields'=>array('Person.patient_uid','Person.id','Person.race','Person.language'),'conditions' =>array('Person.first_name' => $patientCcdaObj->name->first,'Person.last_name'=> $patientCcdaObj->name->last,
				'Person.sex'=>($patientCcdaObj->gender == 'M')?'M':'F','Person.dob'=>date('Y-m-d',strtotime($patientCcdaObj->birthdate)),
				'Person.ethnicity'=>$ethicinity)));

		$raceKey = array_search($patientCcdaObj->race, $raceData);

		$languageKey = array_search($patientCcdaObj->language, $languageData);

		foreach($personData as $person){
			$raceExplode = explode(",",$person['race']);
			$languageExplode = explode(",",$person['language']);

			foreach($raceExplode as $rexp){
				if ($rexp == $raceKey) {
					$patientStatus = true;
					$patientID = $person['id'];
					$patientUID = $person['patient_uid'];
					break;
				}
			}
			if($patientStatus == true){
				foreach($languageExplode as $lexp){
					if ($lexp == $languageKey) {
						$patientStatus = true;//@@@BUG Cant Compare Language Code
						$patientID = $person['id'];
						$patientUID = $person['patient_uid'];
						break;
					}
				}
			}


		}
		return array('person_id'=>$patientID, 'person_uid'=>$patientUID);
		//echo '<pre>';print_r($patientData);exit;
	}

	public function getCCDAObj(){
		$xml = file_get_contents('uploads/CCDA/Vinod Yaduwanshi_UHHO13C15009_single(2).xml');
		App::import('Vendor', 'Ccda', array('file' => 'Ccda.php'));
		$patient = new Ccda($xml);
		$obj = $patient->construct_json();
		$objVal = json_decode($obj);//echo'<pre>';print_r($objVal);exit;
		return $objVal;
	}

	public function updateDemographics(){
		$person = ClassRegistry::init('Person');
		$country = ClassRegistry::init('Country');
		$state = ClassRegistry::init('State');
		$patientCcdaObj = $this->getCCDAObj();
		$patientIds = $this->getTargetPatient($patientCcdaObj);
		$person->read(null, $patientIds['person_id']);

		$states = $state->find('list',array('fields'=>array('name','state_code')));
		$countries = $country->find('list');
		$maritail_status = array("A"=>"Separated","B"=>"Unmarried","C"=>"Common law","D"=>"Divorced","E"=>"Legally Separated","G"=>"Living together","I"=>"Interlocutory","M"=>"Married","N"=>"Annulled","O"=>"Other","P"=>"Domestic partner","R"=>"Registered domestic partner","S"=>"Single","T"=>"Unreported","U"=>"Widowed","W"=>"Unknown");

		$person->set(array(
				'plot_no' => $patientCcdaObj->addr->street[0],
				'landmark' => $patientCcdaObj->addr->street[1],
				'city' => $patientCcdaObj->addr->city,
				'state' => array_search($patientCcdaObj->addr->state,$states),
				'pin_code' => $patientCcdaObj->addr->postalCode,
				'country' => array_search($patientCcdaObj->addr->country,$countries),
				'home_phone' => str_replace('tel:','',$patientCcdaObj->phone->number),
				'dob' => date('Y-m-d',strtotime($patientCcdaObj->birthdate)),
				'maritail_status' => array_search($patientCcdaObj->maritalStatus,$maritail_status),

		));
		$person->save();
		//echo'<pre>';print_r($patientCcdaObj);exit;
		//$this->Person->
	}

	public function updateMedications(){
		$patientCcdaObj = $this->getCCDAObj();
		$patientIds = $this->getTargetPatient($patientCcdaObj);
		$newCropModel = ClassRegistry::init('NewCropPrescription');

		foreach($patientCcdaObj->rx as $rx){
			$newCropModel->set(array(
					'date_of_prescription' => (!empty($rx->date_range->start)) ? date('Y-m-d',strtotime($rx->date_range->start)) : '',
					'end_date' => (!empty($rx->date_range->end)) ? date('Y-m-d',strtotime($rx->date_range->end)) : '',
					'rxnorm' => $rx->translation->code,
					'route' => $rx->product_name,
					'description' => $rx->translation->name,
					'drug_id' => $rx->product_code,
					'frequency' => $rx->dose_quantity->value.', '.$rx->dose_quantity->unit,
					'patient_id' => $patientIds['person_uid'],
					'code_system' => $rx->translation->code_system,
					'is_ccda' => 1,
			));
			$newCropModel->save();
			$newCropModel->id = '';
		}
	}


	public function updateAllergy(){
		$patientCcdaObj = $this->getCCDAObj();
		$patientIds = $this->getTargetPatient($patientCcdaObj);
		$newCropAllergyModel = ClassRegistry::init('NewCropAllergies');

		foreach($patientCcdaObj->allergy as $allergy){
			$newCropAllergyModel->set(array(
					'start_date' => (!empty($allergy->date_range->start)) ? date('Y-m-d',strtotime($allergy->date_range->start)) : '',
					'end_date' => (!empty($allergy->date_range->end)) ? date('Y-m-d',strtotime($allergy->date_range->end)) : '',
					'name' => $allergy->allergen->name,
					'rxnorm' => $allergy->allergen->code,
					'code_system' => $allergy->allergen->code_system_name,
					'reaction_type' => $allergy->reaction_type->name,
					'reaction' => $allergy->reaction->name,
					'AllergySeverityName' => $allergy->severity->name,
					'patient_id' => $patientIds['person_uid'],
					'is_ccda' => 1,

			));
			$newCropAllergyModel->save();
			$newCropAllergyModel->id = '';
		}
	}

	public function updateProblems(){
		$patientCcdaObj = $this->getCCDAObj();
		$patientIds = $this->getTargetPatient($patientCcdaObj);
		$newCropProblemModel = ClassRegistry::init('NoteDiagnosis');

		foreach($patientCcdaObj->dx as $problem){
			$newCropProblemModel->set(array(
					'start_dt' => (!empty($problem->date_range->start)) ? date('Y-m-d',strtotime($problem->date_range->start)) : '',
					'end_dt' => (!empty($problem->date_range->end)) ? date('Y-m-d',strtotime($problem->date_range->end)) : '',
					'diagnoses_name' => $problem->name,
					'code' => $problem->code,
					'code_system' => $problem->translation->code_system_name,
					'status' => $problem->status,
					'u_id' => $patientIds['person_uid'],

			));
			$newCropProblemModel->save();
			$newCropProblemModel->id = '';
		}
	}

	public function updateImmunizations(){
		$patientCcdaObj = $this->getCCDAObj();
		$patientIds = $this->getTargetPatient($patientCcdaObj);
		$immunizationModel = ClassRegistry::init('Immunization');
			
		foreach($patientCcdaObj->immunizaiton as $immunization){
			$immunizationModel->set(array(
					'vaccine_type'=>$immunization->product->name,
					'product_code'=>$immunization->product->code,
					'route_code'=>$immunization->route->code,
					'product_code_system_name'=>$immunization->product->code_system_name,
					'route_code_system_name'=>$immunization->route->code_system_name,
					'u_id' => $patientIds['person_uid'],

			));
			$immunizationModel->save();
			$immunizationModel->id = '';
		}
	}

	public function updateDiagnosis(){
		$patientCcdaObj = $this->getCCDAObj();
		$patientIds = $this->getTargetPatient($patientCcdaObj);
		$diagnosisModel = ClassRegistry::init('Diagnosis');
			
		foreach($patientCcdaObj->vital as $diagnosis){
			$weight = $diagnosis->results[1]->value*2.2046;
			$height = $diagnosis->results[0]->value*0.39370;
			$bp = $diagnosis->results[2]->value;
			$diagnosisModel->set(array(
					'height'=>$height,
					'weight'=>$weight,
					'BP'=>$bp,


			));
			$diagnosisModel->save();
			$diagnosisModel->id = '';
		}
	}

	public function updateRadiologyTestOrder(){
		$patientCcdaObj = $this->getCCDAObj();
		$patientIds = $this->getTargetPatient($patientCcdaObj);
		$RadiologyTestOrderModel = ClassRegistry::init('RadiologyTestOrder');

		foreach($patientCcdaObj->proc as $rto){
			$RadiologyTestOrderModel->set(array(
					'testname'=>$rto->name,
					'sct_concept_id'=>$rto->code,
					'patient_id' => $patientIds['person_id'],


			));
			$RadiologyTestOrderModel->save();
			$RadiologyTestOrderModel->id = '';
		}
	}


	//=========end=========

	public function interacton($id=null){
	 $session     = new cakeSession();
	 $NewCropPrescription = ClassRegistry::init('NewCropPrescription');
	 $NewCropAllergies = ClassRegistry::init('NewCropAllergies');

	 $locationId  = $session->read('locationid') ;
	 $medication=$NewCropPrescription->find('all',array('fields'=>array('NewCropPrescription.drug_id'),'conditions'=>array('NewCropPrescription.patient_uniqueid'=>$id,'NewCropPrescription.archive !='=>'Y','NewCropPrescription.location_id'=>$locationId)));
	 $allergies=$NewCropAllergies->find('all',array('fields'=>array('NewCropAllergies.CompositeAllergyID'),'conditions'=>array('NewCropAllergies.patient_uniqueid'=>$id,'NewCropAllergies.location_id'=>$locationId)));
	 //echo "<pre>";print_r($allergies['0']['NewCropAllergies']['allergies_id']);
	 $curlData='<?xml version="1.0" encoding="utf-8"?>
	 		<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
	 		<soap:Body>
	 		<DrugAllergyInteraction xmlns="https://secure.newcropaccounts.com/V7/webservices">
	 		<credentials>
	 		<partnerName>'.Configure::read('partnername').'</partnerName>
	 				<name>'.Configure::read('uname').'</name>
	 						<password>'.Configure::read('passw').'</password>
	 								</credentials>
	 								<accountRequest>
	 								<AccountId>drmhope</AccountId>
	 								<SiteId>1</SiteId>
	 								</accountRequest>
	 								<patientRequest>
	 								<PatientId>'.$id.'</PatientId>
	 										</patientRequest>
	 										<patientInformationRequester>
	 										<UserType>S</UserType>
	 										<UserId>'.$id.'</UserId>
	 												</patientInformationRequester>
	 												<allergies>';
	 $alle= '';
	 foreach($allergies as $all){
	 	$alle.= '<string>'.$all['NewCropAllergies']['CompositeAllergyID'].'</string>';
	 }
	 $curlData .=$alle;
	 $curlData .='</allergies>
	 		<proposedMedications>';
	 $med='';
	 foreach($medication as $medications){
	 	$med.= '<string>'.$medications['NewCropPrescription']['drug_id'].'</string>';
	 }
	 $curlData .=$med;
	 $curlData .='</proposedMedications>
	 		<drugStandardType>F</drugStandardType>
	 		</DrugAllergyInteraction>
	 		</soap:Body>
	 		</soap:Envelope>';

	 //echo $curlData;
	 $url='http://preproduction.newcropaccounts.com/v7/WebServices/Drug.asmx';
	 $curl = curl_init();

	 curl_setopt ($curl, CURLOPT_URL, $url);
	 curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	 curl_setopt($curl,CURLOPT_TIMEOUT,120);
	 //curl_setopt($curl,CURLOPT_ENCODING,'gzip');

	 curl_setopt($curl,CURLOPT_HTTPHEADER,array (
	 'SOAPAction:"https://secure.newcropaccounts.com/V7/webservices/DrugAllergyInteraction"',
	 'Content-Type: text/xml; charset=utf-8',
	 ));

	 curl_setopt ($curl, CURLOPT_POST, 1);
	 curl_setopt ($curl, CURLOPT_POSTFIELDS, $curlData);

	 $finalxml=$finalxml[0];
	 $result = curl_exec($curl);
	 //print_r($result);
	 curl_close ($curl);
	 if($result!="")
	 {
	 	$xml =simplexml_load_string($result);
	 	$xml->registerXPathNamespace("soap", "http://schemas.xmlsoap.org/soap/envelope/");
	 	$finalxml=$xml->xpath('//soap:Body');
	 	//	echo "<pre>";print_r($finalxml);
	 	$finalxml=$finalxml[0];
	 	$rowcount= $finalxml->DrugAllergyInteractionResponse->DrugAllergyInteractionResult->result->RowCount;
	 	//	echo $rowcount;

	 	$xmldata = simplexml_load_string($xmlString);
	 }



	 return $rowcount;
	}

	public function drugdruginteracton($id=null){
		
		$session     = new cakeSession();
		$NewCropPrescription = ClassRegistry::init('NewCropPrescription');
		$NewCropAllergies = ClassRegistry::init('NewCropAllergies');

		$locationId  = $session->read('locationid') ;
		//$medication=$NewCropPrescription->find('all',array('fields'=>array('NewCropPrescription.drug_id'),'conditions'=>array('NewCropPrescription.patient_uniqueid'=>$id,'NewCropPrescription.archive !='=>'Y','NewCropPrescription.location_id'=>$locationId)));
		//$allergies=$NewCropAllergies->find('all',array('fields'=>array('NewCropAllergies.CompositeAllergyID'),'conditions'=>array('NewCropAllergies.patient_uniqueid'=>$id,'NewCropAllergies.location_id'=>$locationId)));
		//echo "<pre>";print_r($allergies['0']['NewCropAllergies']['allergies_id']);
		$curlData='<?xml version="1.0" encoding="utf-8"?>
				<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
				<soap:Body>
				<DrugDrugInteraction xmlns="https://secure.newcropaccounts.com/V7/webservices">
				<credentials>
				<partnerName>'.Configure::read('partnername').'</partnerName>
						<name>'.Configure::read('uname').'</name>
								<password>'.Configure::read('passw').'</password>
										</credentials>
										<accountRequest>
										<AccountId>drmhope</AccountId>
										<SiteId>1</SiteId>
										</accountRequest>
										<patientRequest>
										<PatientId>'.$id.'</PatientId>
												</patientRequest>
												<patientInformationRequester>
												<UserType>S</UserType>
												<UserId>'.$id.'</UserId>
														</patientInformationRequester>
														<currentMedications>
														<string>228882</string>

														 
														</currentMedications>
														<proposedMedications>

														<string>270211</string>
														</proposedMedications>
														<drugStandardType>F</drugStandardType>
														</DrugDrugInteraction>
														</soap:Body>
														</soap:Envelope>';
		//echo $curlData;

		//echo $curlData;
		$url='http://preproduction.newcropaccounts.com/v7/WebServices/Drug.asmx';
		$curl = curl_init();

		curl_setopt ($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl,CURLOPT_TIMEOUT,120);
		//curl_setopt($curl,CURLOPT_ENCODING,'gzip');

		curl_setopt($curl,CURLOPT_HTTPHEADER,array (
		'SOAPAction:"https://secure.newcropaccounts.com/V7/webservices/DrugDrugInteraction"',
		'Content-Type: text/xml; charset=utf-8',
		));

		curl_setopt ($curl, CURLOPT_POST, 1);
		curl_setopt ($curl, CURLOPT_POSTFIELDS, $curlData);

		$finalxml=$finalxml[0];
		$result = curl_exec($curl);
		//print_r($result);
		//debug($result);
		curl_close ($curl);
		if($result!="")
		{
			$xml =simplexml_load_string($result);
			$xml->registerXPathNamespace("soap", "http://schemas.xmlsoap.org/soap/envelope/");
			$finalxml=$xml->xpath('//soap:Body');
			//	echo "<pre>";print_r($finalxml);
			$finalxml=$finalxml[0];
			print_r($finalxml);
			$rowcount= $finalxml->DrugDrugInteractionResponse->DrugDrugInteractionResult->result->RowCount;
			echo "rowcnt".$rowcount;

			$xmldata = simplexml_load_string($xmlString);
		}



		return $rowcount;
	}



	function strpos_in_array($string,$stringArray){
		foreach($stringArray as $key => $value){
			if(stripos($string,$value)==0){ //for first occurence only
				return true ;
			}
		}
		return false ;
	}
	// get all patientID with person Id
	public function getPatientIDs($personID,$status){
		if(!empty($status)){
			$appointment = ClassRegistry::init('Appointment');
			$Person = ClassRegistry::init('Person');
			$data= $appointment->find('all',array('fields'=>array('Appointment.id','Appointment.patient_id','Appointment.status','Appointment.arrived_time','date'),
				'conditions'=>array('Appointment.status !='=>'Pending','Appointment.arrived_time !='=>'',
					'Appointment.date <='=>date('Y-m-d'),'Appointment.person_id'=>$personID),'order'=>array('Appointment.date')));
			foreach($data as $pData){
			$patientIdarry[]=$pData['Appointment']['patient_id'];
			}
			$this->unBindModel(array(
					'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
			return ($this->find('all',array('fields'=>array('id','form_received_on'),'conditions'=>array('id'=>$patientIdarry))));
		}else{
			$this->unBindModel(array(
					'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
			return ($this->find('all',array('fields'=>array('id','form_received_on'),'conditions'=>array('person_id'=>$personID))));
		}
		
	}
	public function getPatientDetailsForElement($id=null,$bill_number=null){
		$session     = new cakeSession();
		
		if($session->read('website.instance')!='vadodara'){
		$this->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
						'CorporateSublocation'=>array('foreignKey'=>false,'conditions'=>array(
							'Patient.corporate_sublocation_id = CorporateSublocation.id')),
						/*'Diagnosis' =>array('foreignKey' => false,'conditions'=>array('Diagnosis.patient_id =Patient.id' )),*/
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id =Patient.doctor_id' )),
						/*'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id =User.department_id' )),*/
						/*'Guardian' =>array('foreignKey' => false,'conditions'=>array('Person.id =Guardian.person_id' )),*/
						/*'AdvanceDirective' =>array('foreignKey' => false,'conditions'=>array('AdvanceDirective.patient_id =Patient.admission_id' )),*/
						//'Language' =>array('foreignKey' => false,'conditions'=>array('Language.id =Person.language' )),
						/*'Race' =>array('foreignKey' => false,'conditions'=>array('Race.value_code =Person.race' )),*/
				),
				'hasMany'=>array(
						'RadiologyReport' => array('foreignKey'=>'patient_id'),
				)));
		}else{
			$this->bindModel(array(
					'belongsTo' => array(
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
							/*'Diagnosis' =>array('foreignKey' => false,'conditions'=>array('Diagnosis.patient_id =Patient.id' )),*/
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id =Patient.doctor_id' )),
							/*'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id =User.department_id' )),*/
							/*'Guardian' =>array('foreignKey' => false,'conditions'=>array('Person.id =Guardian.person_id' )),*/
							/*'AdvanceDirective' =>array('foreignKey' => false,'conditions'=>array('AdvanceDirective.patient_id =Patient.admission_id' )),*/
							//'Language' =>array('foreignKey' => false,'conditions'=>array('Language.id =Person.language' )),
							/*'Race' =>array('foreignKey' => false,'conditions'=>array('Race.value_code =Person.race' )),*/
					)));
		}



		return ($this->find("first",
				array( 'conditions'=>array('Patient.id'=>$id))));
			
	}


	/**
	 * Called after inserting patient data
	 *
	 * @param id:latest patient table ID
	 * @param patient_info(array): patient details as posted from patinet registration form
	 * @return patient ID
	 **/
	public function autoGeneratedAdmissionID($id=null,$patient_info = array()){

		$session = new cakeSession();
		if( strtolower( $session->read('website.instance') ) == 'hope' ){
			$count = $this->find('count',array('conditions'=>array('Patient.create_time like'=> "%".date("Y-m-d")."%",
					/*'Patient.location_id'=>$session->read('locationid')*/)));// ---- for same location initial name it creates duplicate uID---gaurav @pankaj
			$count++ ; //count currrent entry also
			if($count==0){
				$count = "001" ;
			}else if($count < 10 ){
				$count = "00$count"  ;
			}else if($count >= 10 && $count <100){
				$count = "0$count"  ;
			}
			$month_array = array('A','B','C','D','E','F','G','H','I','J','K','L');
			//creating patient ID
			$unique_id   = ucfirst(substr($patient_info['Patient']['admission_type'],0,1));
			//$unique_id  .= ucfirst(substr($hospital,0,1)); //first letter of the hospital name
			$unique_id  .= strtoupper(substr($session->read('location'),0,1));//first 2 letter of d location
			$unique_id  .= date('y'); //year
			$unique_id  .= $month_array[date('n')-1];//first letter of month
			$unique_id  .= date('d');//day
			$unique_id .= $count;
			
		}else{
			App::import('Vendor', 'DrmhopeDB');
			if(empty($_SESSION['db_name'])){
				$db_connection = new DrmhopeDB('db_hope');
			}else{
				$db_connection = new DrmhopeDB($_SESSION['db_name']);
			}
			$db_connection->makeConnection($this);
			$configuration=Classregistry::init('Configuration');
			$db_connection->makeConnection($configuration);
			$prefix = $configuration->find('first',array('conditions'=>array('name'=>'Prefix')));
			$previousData = unserialize($prefix['Configuration']['value']);
			$inArray = array_key_exists('u_id',$previousData);
			
			if($inArray){
				$prefix = $previousData['u_id'];  // for reference go to configuration controller in index (); ***gulshan
			}
			//Count of Patient table ID --pooja
			//$count = $this->find('count');
			$count = $this->find('count',array('conditions'=>array('create_time > '=>'2015-03-31 23:59:59','location_id'=>$session->read('locationid')?$session->read('locationid'):1,'admission_type'=>$patient_info['Patient']['admission_type'])));
			
			$count++;
			if($count==0){
			 $count = "00001" ;
			}else if($count < 10 ){
			$count = "0000$count"  ;
			}else if($count >= 10 && $count <100){
			$count = "000$count"  ;
			}
			else if($count >= 100 && $count <1000){
			$count = "00$count"  ;
			}
			else if($count >= 1000 && $count <10000){
			$count = "0$count"  ;
			}
			else if($count >= 10000){
			$count = $count  ;
			}
			
			$month_array = array('A','B','C','D','E','F','G','H','I','J','K','L');
	
			$hospital = $session->read('facility');
	
			//by pankaj wanjari
			if($patient_info['Patient']['location_id'] != ''){
				$locationObj = Classregistry::init('Location');
				$db_connection->makeConnection($locationObj);
				$locationData = $locationObj->getLocationDetails($patient_info['Patient']['location_id']);
				$location = $locationData['Location']['name'];
			}else{
				$location = $session->read('location');
			}
			//creating patient ID
			$splitLoaction=explode(' ',$location);
			if(!empty($splitLoaction['1'])){
				$loc1=strtoupper(substr($splitLoaction['0'],0,1));
				$loc2=strtoupper(substr($splitLoaction['1'],0,1));
				$loc=$loc1.$loc2;
			}else $loc=strtoupper(substr($location,0,2));
			
			$unique_id  .= strtoupper($loc);
			$unique_id  .= '/';
			$unique_id  .= ucfirst(substr($patient_info['Patient']['admission_type'],0,1));			
			$unique_id  .= '-';
			$unique_id  .= $count;
		}
		return strtoupper($unique_id) ;
	}

	function afterSave(){
		$diagnoses = Classregistry::init('Diagnosis');
		$tariffStandardObj = Classregistry::init('TariffStandard');
		$accountObj = Classregistry::init('Account');
		$accountingGroupObj = Classregistry::init('AccountingGroup');
		$session = new cakeSession();
		
		$diagnoses->addBlankEntry($this->data['BmiResult']['patient_id']);
		
		//BOF For updating accounting sub group by amit jain
		$privateId = $tariffStandardObj->getPrivateTariffID($session->read('locationid'));
		if($this->data['Patient']['tariff_standard_id'] != $privateId){
			$tariffStandard = $this->data['Patient']['tariff_standard_id'];
			$subLocationId = $this->data['Patient']['corporate_sublocation_id'];
			
			$subGroupId = $accountingGroupObj->getGroupId($tariffStandard,'TariffStandard');
			$accountingGroupObj->id='';
			
			$subSubGroupId = $accountingGroupObj->getGroupId($subLocationId,'Sublocation');
			$accountingGroupObj->id='';
			$accountObj->updateAll(array('Account.accounting_sub_group_id'=>$subGroupId,'Account.accounting_sub_sub_group_id'=>$subSubGroupId),
					array('Account.system_user_id'=>$this->data['Patient']['person_id'],'Account.user_type'=>'Patient'));
			$accountObj->id='';
		}
		//EOF for accounting
	}
	public function getAllPatientIds($personId){
		$patientModel = ClassRegistry::init('Patient');
		$patient_ids = array();
		$patientModel->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patientData = $patientModel->find('all',array('fields'=>array('Patient.id'),'conditions'=>array('Patient.person_id'=>$personId,'Patient.is_deleted'=>0)));
		foreach ($patientData as $patient){
			array_push($patient_ids,$patient['Patient']['id']);
		}
		$patientId = $patient_ids;//array('959','960');//
		return $patientId;
	}
	/**
	 * For all SMS integrated by the following code
	 * @params person_id
	 * By Mahalaxmi
	 */
	
	public function sendToSmsPhysician($personId,$type,$data){
		$patientModel = ClassRegistry::init('Patient');
		$roomModel = ClassRegistry::init('Room');
		$bedModel = ClassRegistry::init('Bed');
		$personModel = ClassRegistry::init('Person');
		$getHospitalName=$_SESSION['location_name'];
		$getConfirmSmsReferringDoc=false;
		$this->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'Room' =>array('foreignKey' => false,'conditions'=>array('Room.id=Patient.room_id' )),
						'Bed' =>array('foreignKey' => false,'conditions'=>array('Bed.id=Patient.bed_id' )),
						'Ward' =>array('foreignKey' => false,'conditions'=>array('Ward.id=Room.ward_id' )),
						'Diagnosis' =>array('foreignKey' => false,'conditions'=>array('Diagnosis.patient_id=Patient.id')),
						'NoteDiagnosis' =>array('foreignKey' => false,'conditions'=>array('NoteDiagnosis.patient_id=Patient.id')),
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id')),
						'Consultant' =>array('foreignKey' => false,'conditions'=>array('Consultant.id=Patient.consultant_id')),
						'OptAppointment' =>array('foreignKey' => false,'conditions'=>array('OptAppointment.patient_id=Patient.id','OptAppointment.id'=>$data)),
						'Surgery' =>array('foreignKey' => false,'conditions'=>array('OptAppointment.surgery_id=Surgery.id')),
				)));
		$patientData = $patientModel->find('first',array('fields'=>array('User.phone1','User.mobile','Room.name','Patient.id','Patient.lookup_name','Person.dob','Patient.room_id','Patient.bed_id','Room.bed_prefix','Bed.bedno','Ward.name','Diagnosis.complaints','NoteDiagnosis.diagnoses_name','Consultant.mobile','Consultant.first_name','Consultant.last_name','OptAppointment.starttime','Surgery.name','Patient.diagnosis_txt','Patient.consultant_id'),'conditions'=>array('Patient.person_id'=>$personId,'Patient.is_deleted'=>0,'Patient.is_discharge'=>'0')));
		
		if(!empty($patientData['Diagnosis']['complaints'])){
			$getDiagnoses=$patientData['Diagnosis']['complaints'];
		}else{
			$getDiagnoses=$patientData['NoteDiagnosis']['diagnoses_name'];
		}

		/*if(!empty($data['Ward']['bednameforSms'])){*/
		/***BOF-This below bind used for existing details compared fields***///
		/*	$roomModel->bindModel(array(
				'belongsTo'=>array(
						'Ward' =>array('foreignKey' => false,'conditions'=>array('Ward.id=Room.ward_id' )),
						//	'Room' =>array('foreignKey' => false,'conditions'=>array('Room.id=Patient.room_id' )),
						'Bed' =>array('foreignKey' => false,'conditions'=>array('Bed.room_id=Room.id' ))
				)));
		$roomData = $roomModel->find('first',array('fields'=>array('Room.name','Bed.id','Room.bed_prefix','Bed.bedno','Ward.name'),'conditions'=>array('Bed.id'=>$data['Ward']['bednameforSms'])));

		}*/
		/***EOF-This below bind used for existing details compared fields***///
		if($type=='Reg'){
			/******After patient reg to  get sms alert for Physician  ***/
			$mobNo =$patientData['User']['mobile'];
			if(!empty($patientData['Patient']['diagnosis_txt'])){
				$getTextDiareg=' with diagnosis of '.$patientData['Patient']['diagnosis_txt'];
			}else if(!empty($getDiagnoses)){
				$getTextDiareg=' with diagnosis of '.$getDiagnoses;
			}
			$msgText='A patient named '.$patientData['Patient']['lookup_name'].' aged '.$personModel->getCurrentAge($patientData['Person']['dob']).$getTextDiareg.' has been admitted in '.$patientData['Room']['bed_prefix'].$patientData['Bed']['bedno'].' bed under you.-'.Configure::read('hosp_details');
		}else if($type=='OwnerReg'){
			/******After patient reg to  get sms alert for Owner  ***/
			$mobNo =Configure::read('owner_no');
			if(!empty($patientData['Patient']['diagnosis_txt'])){
				$getTextDiareg=' with diagnosis of '.$patientData['Patient']['diagnosis_txt'];
			}else if(!empty($getDiagnoses)){
				$getTextDiareg=' with diagnosis of '.$getDiagnoses;
			}
			$msgText='A patient named '.$patientData['Patient']['lookup_name'].' aged '.$personModel->getCurrentAge($patientData['Person']['dob']).$getTextDiareg.' has been admitted in '.$patientData['Room']['bed_prefix'].$patientData['Bed']['bedno'].' bed under you.-'.Configure::read('hosp_details');
		}else if($type=='OT'){
			/******After scheduling OT Appointment  to  get sms alert for Physician  ***/
			$getDateTime=$patientData['OptAppointment']['starttime'];
			$getExplodeData=explode(' ',$getDateTime);
			$getExplodeData[0] =DateFormatComponent::formatDate2LocalForReport($getExplodeData[0],Configure::read('date_format'));
			$mobNo =$patientData['User']['mobile'];
			$msgText=$patientData['Surgery']['name'].' for  patient named '.$patientData['Patient']['lookup_name'].' aged '.$personModel->getCurrentAge($patientData['Person']['dob']).' is scheduled on '.$getExplodeData[0].' at '.date("h:i A", strtotime($getExplodeData[1])).'.-'.Configure::read('hosp_details');
		}else if($type=='OwnerOT'){
			/******After scheduling OT Appointment  to  get sms alert for Physician  ***/
			$getDateTime=$patientData['OptAppointment']['starttime'];
			$getExplodeData=explode(' ',$getDateTime);
			$getExplodeData[0] =DateFormatComponent::formatDate2LocalForReport($getExplodeData[0],Configure::read('date_format'));
			$mobNo =Configure::read('owner_no');
			if(!empty($patientData['Patient']['diagnosis_txt'])){
				$getTextDiaOt=' with diagnosis of '.$patientData['Patient']['diagnosis_txt'];
			}else if(!empty($getDiagnoses)){
				$getTextDiaOt=' with diagnosis of '.$getDiagnoses;
			}
			$msgText='A patient named '.$patientData['Patient']['lookup_name'].' aged '.$personModel->getCurrentAge($patientData['Person']['dob']).$getTextDiaOt.' has been admitted for '.$patientData['Surgery']['name'].'.-'.Configure::read('hosp_details');
		}else if($type=='RegReferringDoc'){			
			$getFlagRegReferrinDoc=true;
			/******After patient reg to  get sms alert for Reffering Doc  ***/
			$mobNo =$patientData['Consultant']['mobile'];			
			$msgText='Your patient named '.$patientData['Patient']['lookup_name'].' aged '.$personModel->getCurrentAge($patientData['Person']['dob']).' is being admitted in Hope Hospitals under Dr.'.$patientData['Consultant']['first_name'].' '.$patientData['Consultant']['last_name'].' today.-'.Configure::read('hosp_details');
		}else if($type=='RegAdministratorReturn'){			
			/******After patient reg to  get sms alert for Reffering Doc return To Admin  ***/
			$mobNo =Configure::read('administrator_no');		
			$msgText='Sent to Dr.'.$patientData['Consultant']['first_name'].' '.$patientData['Consultant']['last_name'].' - " Your patient named '.$patientData['Patient']['lookup_name'].' aged '.$personModel->getCurrentAge($patientData['Person']['dob']).' is being admitted in Hope Hospitals under Dr.'.$patientData['Consultant']['first_name'].' '.$patientData['Consultant']['last_name'].' today.-'.Configure::read('hosp_details').'"';
		}else if($type=='RegOwnerReturn'){
			/******After patient reg to  get sms alert for Reffering Doc return To Owner  ***/
			$mobNo =Configure::read('owner_no');
			$msgText='Sent to Dr.'.$patientData['Consultant']['first_name'].' '.$patientData['Consultant']['last_name'].' - " Your patient named '.$patientData['Patient']['lookup_name'].' aged '.$personModel->getCurrentAge($patientData['Person']['dob']).' is being admitted in Hope Hospitals under Dr.'.$patientData['Consultant']['first_name'].' '.$patientData['Consultant']['last_name'].' today.-'.Configure::read('hosp_details').'"';
		}else if($type=='DischargeDeathReferringDoc'){			
			/******After patient reg to  get sms alert for Reffering Doc  ***/
			$mobNo =$patientData['Consultant']['mobile'];			
			$msgText='We regret to inform that your patient named '.$patientData['Patient']['lookup_name'].' aged '.$personModel->getCurrentAge($patientData['Person']['dob']).' expired today in Hope Hospitals.-'.Configure::read('hosp_details');
		}else if($type=='DischargeDeathReferringDocOwnerReturn'){
			if(!empty($patientData['Consultant']['mobile'])){
			/******After patient reg to  get sms alert for Reffering Doc to   ***/
			$mobNo =Configure::read('owner_no');			
			$msgText='Sent to Dr.'.$patientData['Consultant']['first_name'].' '.$patientData['Consultant']['last_name'].' - "We regret to inform that your patient named '.$patientData['Patient']['lookup_name'].' aged '.$personModel->getCurrentAge($patientData['Person']['dob']).' expired today in Hope Hospitals.-'.Configure::read('hosp_details').'"';
			}
		}else if($type=='DischargeDeathReferringDocAdminReturn'){
			if(!empty($patientData['Consultant']['mobile'])){
			/******After patient reg to  get sms alert for Reffering Doc to   ***/
			$mobNo =Configure::read('administrator_no');			
			$msgText='Sent to Dr.'.$patientData['Consultant']['first_name'].' '.$patientData['Consultant']['last_name'].' - "We regret to inform that your patient named '.$patientData['Patient']['lookup_name'].' aged '.$personModel->getCurrentAge($patientData['Person']['dob']).' expired today in Hope Hospitals.-'.Configure::read('hosp_details').'"';
			}
		}else if($type=='DischargeOtherReasonReferringDoc'){			
			/******After patient reg to  get sms alert for Reffering Doc  ***/
			$mobNo =$patientData['Consultant']['mobile'];			
			$msgText='Your patient named '.$patientData['Patient']['lookup_name'].' aged '.$personModel->getCurrentAge($patientData['Person']['dob']).' is discharged from Hope Hospitals today. He is being sent to you for review.-'.Configure::read('hosp_details');
		}else if($type=='DischargeOtherReasonReferringDocAdminReturn'){			
			if(!empty($patientData['Consultant']['mobile'])){
			/******After patient reg to  get sms alert for Reffering Doc to admin ***/
			$mobNo =Configure::read('administrator_no');				
			$msgText='Sent to Dr.'.$patientData['Consultant']['first_name'].' '.$patientData['Consultant']['last_name'].' - "Your patient named '.$patientData['Patient']['lookup_name'].' aged '.$personModel->getCurrentAge($patientData['Person']['dob']).' is discharged from Hope Hospitals today. He is being sent to you for review.-'.Configure::read('hosp_details').'"';
			}
		}else if($type=='DischargeOtherReasonReferringDocOwnerReturn'){			
			if(!empty($patientData['Consultant']['mobile'])){
			/******After patient reg to  get sms alert for Reffering Doc to Owner  ***/
			$mobNo =Configure::read('owner_no');			
			$msgText='Sent to Dr.'.$patientData['Consultant']['first_name'].' '.$patientData['Consultant']['last_name'].' - "Your patient named '.$patientData['Patient']['lookup_name'].' aged '.$personModel->getCurrentAge($patientData['Person']['dob']).' is discharged from Hope Hospitals today. He is being sent to you for review.-'.Configure::read('hosp_details').'"';
			}
		}

		/****BOF-Only Sending SMS *****/
		$sender_id=Configure::read('sender_id');           // sender id
		$mob_no = $mobNo;     //123, 456 being recepients number To-Physician no or Patient no		
		$userName=Configure::read('user_name');   ///User Name
		$pwd=Configure::read('pwd');               //your SMS gatewayhub account password
		$msg=$msgText;//'Sample Msg from DRMhope App';       //your message	
		$str = trim(str_replace(' ', '%20', $msg));
		$url=Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mob_no.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2';
		$ch = curl_init();	
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 2);
		$getResult=curl_exec($ch);
		$getResultexp=explode('-', $getResult);
		$getResultexp1 = substr($getResultexp['0'], 2);  // returns "cde"
		curl_close($ch);
	//if($getResult!="Failed#Parameter Missing" && $getResult!="Failed#Invalid Mobile Numbers" && $getFlagRegReferrinDoc=='1'){	
		if($getResultexp1==$patientData['Consultant']['mobile'] && $getFlagRegReferrinDoc=='1'){				
			$getConfirmSmsReferringDoc=true;
		}
		curl_close($ch);
		/****EOF-Only Sending SMS *****/
		
		return $getConfirmSmsReferringDoc;
	}



	public function sendToSmsPatient($personId,$type,$data){
		$patientModel = ClassRegistry::init('Patient');
		$personModel = ClassRegistry::init('Person');
		$getHospitalName=$_SESSION['location_name'];
		$getHospitalLocPhone=$_SESSION['location_phone'];

		$this->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id')),
						'Room' =>array('foreignKey' => false,'conditions'=>array('Room.id=Patient.room_id')),
						'Bed' =>array('foreignKey' => false,'conditions'=>array('Bed.id=Patient.bed_id')),
						'Ward' =>array('foreignKey' => false,'conditions'=>array('Ward.id=Room.ward_id')),
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id')),
						'Diagnosis' =>array('foreignKey' => false,'conditions'=>array('Diagnosis.patient_id=Patient.id')),
						'NoteDiagnosis' =>array('foreignKey' => false,'conditions'=>array('NoteDiagnosis.patient_id=Patient.id')),
						'OptAppointment' =>array('foreignKey' => false,'conditions'=>array('OptAppointment.patient_id=Patient.id','OptAppointment.id'=>$data)),
						'Surgery' =>array('foreignKey' => false,'conditions'=>array('OptAppointment.surgery_id=Surgery.id')),
						'FinalBilling' =>array('foreignKey' => false,'conditions'=>array('FinalBilling.patient_id=Patient.id')),
						'Appointment' =>array('foreignKey' => false,'conditions'=>array('Appointment.patient_id=Patient.id','Appointment.id'=>$data)),
						'DiscountRequest' =>array('foreignKey' => false,'conditions'=>array('DiscountRequest.patient_id=Patient.id','DiscountRequest.id'=>$data,'DiscountRequest.is_deleted'=>'0')),

				)));
		$patientData = $patientModel->find('first',array('fields'=>array('Room.bed_prefix','Bed.bedno','Room.name','full_name' => 'CONCAT(User.first_name," ", User.last_name)','Patient.lookup_name','Person.dob','Ward.name','Person.mobile','Diagnosis.complaints','NoteDiagnosis.diagnoses_name','Patient.mobile_phone','OptAppointment.starttime','FinalBilling.amount_paid','FinalBilling.amount_pending','FinalBilling.discount_type','FinalBilling.total_amount','FinalBilling.discount_type','FinalBilling.discount','Appointment.start_time','Appointment.date','Surgery.name','OptAppointment.surgery_id','DiscountRequest.discount_amount','DiscountRequest.total_amount','DiscountRequest.type','DiscountRequest.discount_percentage','DiscountRequest.refund_amount','Patient.diagnosis_txt'),'conditions'=>array('Patient.person_id'=>$personId,'Patient.is_deleted'=>0,'Patient.is_discharge'=>'0')));

		if(!empty($patientData['Diagnosis']['complaints'])){
			$getDiagnoses=$patientData['Diagnosis']['complaints'];
		}else{
			$getDiagnoses=$patientData['NoteDiagnosis']['diagnoses_name'];
		}

		if($type=='Reg'){
			/******After patient reg to  get sms alert for Patient  ***/
			$mobNo = $patientData['Person']['mobile'];
			$msgText='You have been assigned '.$patientData['Room']['bed_prefix'].$patientData['Bed']['bedno'].' bed. Your treating physician will be Dr. '.$patientData[0]['CONCAT(User.first_name," ", User.last_name)'].'.-'.Configure::read('hosp_details');
		}else if($type=='RegPatientRelative'){
			/******After patient reg to  get sms alert for Patient  ***/
			$mobNo = $patientData['Patient']['mobile_phone'];
			$msgText='A patient named '.$patientData['Patient']['lookup_name'].' have been assigned '.$patientData['Room']['bed_prefix'].$patientData['Bed']['bedno'].' bed and treating physician will be Dr. '.$patientData[0]['CONCAT(User.first_name," ", User.last_name)'].'.-'.Configure::read('hosp_details');
		}else if($type=='OT'){
			/******After patient reg to  get sms alert for Patient  ***/
			$getDateTime=$patientData['OptAppointment']['starttime'];
			$getExplodeData=explode(' ',$getDateTime);
			$getExplodeData[0] = DateFormatComponent::formatDate2LocalForReport($getExplodeData[0],Configure::read('date_format'));
			$mobNo = $patientData['Person']['mobile'];
			$msgText='Your surgery is scheduled on '.$getExplodeData[0].' at '.date("h:i A", strtotime($getExplodeData[1])).'-'.Configure::read('hosp_details');
		}else if($type=='FollowUp'){
			/******After patient  on leaving the clinic  to  get sms alert for Patient ***/
			$patientData['Appointment']['date'] = DateFormatComponent::formatDate2Local($patientData['Appointment']['date'],Configure::read('date_format'));
			$mobNo = $patientData['Person']['mobile'];
			$msgText='Your next visit is scheduled on '.$patientData['Appointment']['date'].' at '.date("h:i A", strtotime($patientData['Appointment']['start_time'])).'.-'.Configure::read('hosp_details');
		}else if($type=='PayPaid'){
			/******After patient paid the payment  to  get sms alert for Patient ***/
			$mobNo = $patientData['Person']['mobile'];
			$getBalAmt=$patientData['FinalBilling']['total_amount']-$patientData['FinalBilling']['amount_paid'];
			if($getBalAmt!='0' && !empty($patientData['FinalBilling']['discount_type'])){
				if($patientData['FinalBilling']['discount_type']=='Amount'){
					$getDiscountBal=$getBalAmt-$patientData['FinalBilling']['discount'];
				}else if($patientData['FinalBilling']['discount_type']=='Percentage'){
					$getDiscountBal=$getBalAmt-(($patientData['FinalBilling']['discount']/100)*$patientData['FinalBilling']['total_amount']);
				}
				if($getDiscountBal=='0'){
					$getBalText='.-'.Configure::read('hosp_details');
				}else{
					$getBalText='. A Balance amount of Rs.'.$getDiscountBal.' is pending in your account . Please Pay as soon as possible! -'.Configure::read('hosp_details');
				}
			}else{
				if($getBalAmt=='0'){
					$getBalText='.-'.Configure::read('hosp_details');
				}else{
					$getBalText='. A Balance amount of Rs.'.$getBalAmt.' is pending in your account . Please Pay as soon as possible! -'.Configure::read('hosp_details');
				}
			}
				
			$msgText='We have received Rs.'.$patientData['FinalBilling']['amount_paid'].' from you for availing various services in '.$getHospitalName.$getBalText;
		}else if($type=='OwnerFinalBill'){
			/******After patient paid the payment  to  get sms alert for Patient ***/
			$mobNo = Configure::read('owner_no');
			if(!empty($patientData['Patient']['diagnosis_txt'])){
				$getTextDiafinal=' with diagnosis of '.$patientData['Patient']['diagnosis_txt'];
			}else if(!empty($getDiagnoses)){
				$getTextDiafinal=' with diagnosis of '.$getDiagnoses;
			}
			if(!empty($patientData['Surgery']['name'])){
				$getsurgery='for '.$patientData['Surgery']['name'];
			}
				
			$msgText='A patient named '.$patientData['Patient']['lookup_name'].' aged '.$personModel->getCurrentAge($patientData['Person']['dob']).$getTextDiafinal.' has been discharged'.$getsurgery.'-'.Configure::read('hosp_details');
		}else if($type=='Noshow'){
			/******Appointment tracker-sending SMS to customers who have missed appointment to  get sms alert for Patient ***/
			$patientData['Appointment']['date'] = DateFormatComponent::formatDate2Local($patientData['Appointment']['date'],Configure::read('date_format'));
			$mobNo = $patientData['Person']['mobile'];
			$msgText='You have missed an appointment on '.$patientData['Appointment']['date'].' at '.date("h:i A", strtotime($patientData['Appointment']['start_time'])).' with us.Call '.$getHospitalLocPhone.' for appointment. -Dr. '.$patientData[0]['CONCAT(User.first_name," ", User.last_name)'].'.-'.Configure::read('hosp_details');
		}else if($type=='OwnerDiscountRequest'){
			/******After patient sent request for Discount or refund to  get sms alert for Owner ***/
			$mobNo = Configure::read('owner_no');
			if(trim($patientData['DiscountRequest']['type'])=='Amount'){
				$getAmount='Discount of Rs.'.$patientData['DiscountRequest']['discount_amount'];
			}else if(trim($patientData['DiscountRequest']['type'])=='Percentage'){
				$getAmountOfPercentage=($patientData['DiscountRequest']['discount_percentage']/100)*$patientData['DiscountRequest']['total_amount'];
				$getAmount='Discount of Rs.'.$getAmountOfPercentage;
			}else if(trim($patientData['DiscountRequest']['type'])=='Refund'){
				//$getAmountOfRefundPercentage=($patientData['DiscountRequest']['refund_amount']/100)*$patientData['DiscountRequest']['total_amount'];
				$getAmount='Refund of Rs. '.$patientData['DiscountRequest']['refund_amount'];
			}
				
			$msgText=$getAmount.' is requested for the patient named '.$patientData['Patient']['lookup_name'].'. The total bill amount is Rs.'.$patientData['DiscountRequest']['total_amount'].'.-'.Configure::read('hosp_details');
		}else if($type=='OwnerDiscountRequestApproval'){
			/******After patient approved request for Discount or refund  to  get sms alert for Owner  ***/
			$mobNo = Configure::read('owner_no');
			if(trim($patientData['DiscountRequest']['type'])=='Amount'){
				$getAmount='Requested discount amount of Rs.'.$patientData['DiscountRequest']['discount_amount'];
			}else if(trim($patientData['DiscountRequest']['type'])=='Percentage'){
				$getAmountOfPercentage=($patientData['DiscountRequest']['discount_percentage']/100)*$patientData['DiscountRequest']['total_amount'];
				$getAmount='Requested discount of Rs. '.$getAmountOfPercentage;
			}else if(trim($patientData['DiscountRequest']['type'])=='Refund'){
				//$getAmountOfRefundPercentage=($patientData['DiscountRequest']['refund_amount']/100)*$patientData['DiscountRequest']['total_amount'];
				$getAmount='Requested Refund of Rs. '.$patientData['DiscountRequest']['refund_amount'];
			}
			$msgText=$getAmount.' is approved for the patient named '.$patientData['Patient']['lookup_name'].'. The total bill amount is Rs.'.$patientData['DiscountRequest']['total_amount'].'.-'.Configure::read('hosp_details');
		}else if($type=='feedback'){
			/******After patient paid the payment  to  get sms alert Patient for Feedback  ***/
			$getOwnerNo=Configure::read('owner_no');
			if(!empty($getOwnerNo)){
				$putOwnerNo="09373111709";
			}
			$mobNo = $patientData['Person']['mobile'];
			$msgText='From a scale 1 to 5, How do you rate our services.Reply to '.$putOwnerNo.'-'.Configure::read('hosp_details');
				
		}

		//****BOF-Only Sending SMS *****/
		$sender_id=Configure::read('sender_id');           // sender id
		$mob_no = $mobNo;       //123, 456 being recepients number To-Physician no or Patient no
		$userName=Configure::read('user_name');   ///User Name
		$pwd=Configure::read('pwd');               //your SMS gatewayhub account password
		$msg=$msgText;//'Sample Msg from DRMhope App';       //your message
		$str = trim(str_replace(' ', '%20', $msg));
		// to replace the space in message with  �%20'
		$url=Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mob_no.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 2);
		curl_exec($ch);
		curl_close($ch);
	}

	public function sendToSmsPhysicianFromWard($personId,$type,$data){
		$patientModel = ClassRegistry::init('Patient');
		$roomModel = ClassRegistry::init('Room');
		$bedModel = ClassRegistry::init('Bed');
		$personModel = ClassRegistry::init('Person');
		$getHospitalName=$_SESSION['location_name'];

		$this->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'Room' =>array('foreignKey' => false,'conditions'=>array('Room.id=Patient.room_id' )),
						'Bed' =>array('foreignKey' => false,'conditions'=>array('Bed.id=Patient.bed_id' )),
						'Ward' =>array('foreignKey' => false,'conditions'=>array('Ward.id=Room.ward_id' )),
						'Diagnosis' =>array('foreignKey' => false,'conditions'=>array('Diagnosis.patient_id=Patient.id')),
						'NoteDiagnosis' =>array('foreignKey' => false,'conditions'=>array('NoteDiagnosis.patient_id=Patient.id')),
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id')),
				)));
		$patientData = $patientModel->find('first',array('fields'=>array('User.phone1','User.mobile','Room.name','Patient.id','Patient.lookup_name','Person.dob','Patient.room_id','Patient.bed_id','Room.bed_prefix','Bed.bedno','Ward.name','Patient.diagnosis_txt'),'conditions'=>array('Patient.person_id'=>$personId,'Patient.is_deleted'=>0,'Patient.is_discharge'=>'0')));

		if(!empty($patientData['Diagnosis']['complaints'])){
			$getDiagnoses=' for'.$patientData['Diagnosis']['complaints'];
		}else if(!empty($patientData['NoteDiagnosis']['diagnoses_name'])){
			$getDiagnoses=' for'.$patientData['NoteDiagnosis']['diagnoses_name'];
		}else{
			$getDiagnoses='';
		}

		//if(!empty($data['bednameforSms'])){
		/***BOF-This below bind used for existing details compared fields***///
		$roomModel->bindModel(array(
				'belongsTo'=>array(
						'Ward' =>array('foreignKey' => false,'conditions'=>array('Ward.id=Room.ward_id' )),
						'Bed' =>array('foreignKey' => false,'conditions'=>array('Bed.room_id=Room.id' ))
				)));
		$roomData = $roomModel->find('first',array('fields'=>array('Room.name','Bed.id','Room.bed_prefix','Bed.bedno','Ward.name'),'conditions'=>array('Bed.id'=>$data['bednameforSms'])));
		//}
		/***EOF-This below bind used for existing details compared fields***///
		if($type=='room'){
			/******After tranfering room or bed  to  get sms alert for Physician  ***/
			$mobNo =$patientData['User']['mobile'];
			$msgText='Your pt. '.$patientData['Patient']['lookup_name'].' '.$personModel->getCurrentAge($patientData['Person']['dob']).' admitted in '.$getHospitalName.' hospital'.$getDiagnoses.' is transferred from '.trim($roomData['Room']['name']).' bed no. '.$roomData['Room']['bed_prefix'].$roomData['Bed']['bedno'].' to '.trim($patientData['Room']['name']).'  bed no. '.$patientData['Room']['bed_prefix'].$patientData['Bed']['bedno'].' .-'.Configure::read('hosp_details');
		}
		/****BOF-Only Sending SMS *****/
		$sender_id=Configure::read('sender_id');           // sender id
		$mob_no = $mobNo;     //123, 456 being recepients number To-Physician no or Patient no
		$userName=Configure::read('user_name');   ///User Name
		$pwd=Configure::read('pwd');               //your SMS gatewayhub account password
		$msg=$msgText;//'Sample Msg from DRMhope App';       //your message
		$str = trim(str_replace(' ', '%20', $msg));
		// to replace the space in message with  �%20'
		$url=Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mob_no.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 2);
		curl_exec($ch);
		curl_close($ch) ;
		/****EOF-Only Sending SMS *****/
	}

	public function sendToSmsPhysicianFromOrToWard($personId,$type,$data){
		$patientModel = ClassRegistry::init('Patient');
		$roomModel = ClassRegistry::init('Room');
		$bedModel = ClassRegistry::init('Bed');
		$personModel = ClassRegistry::init('Person');
		$getHospitalName=$_SESSION['location_name'];

		$this->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'Room' =>array('foreignKey' => false,'conditions'=>array('Room.id=Patient.room_id' )),
						'Bed' =>array('foreignKey' => false,'conditions'=>array('Bed.id=Patient.bed_id' )),
						'Ward' =>array('foreignKey' => false,'conditions'=>array('Ward.id=Room.ward_id' )),
						'Diagnosis' =>array('foreignKey' => false,'conditions'=>array('Diagnosis.patient_id=Patient.id')),
						'NoteDiagnosis' =>array('foreignKey' => false,'conditions'=>array('NoteDiagnosis.patient_id=Patient.id')),
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id')),
						'Consultant' =>array('foreignKey' => false,'conditions'=>array('Consultant.id=Patient.consultant_id')),
						'OptAppointment' =>array('foreignKey' => false,'conditions'=>array('OptAppointment.patient_id=Patient.id','OptAppointment.id'=>$data)),
						'Surgery' =>array('foreignKey' => false,'conditions'=>array('OptAppointment.surgery_id=Surgery.id')),
				)));
		$patientData = $patientModel->find('first',array('fields'=>array('Patient.mobile_phone','Consultant.phone1','User.phone1','User.mobile','Room.name','Patient.id','Patient.lookup_name','Person.dob','Patient.room_id','Patient.bed_id','Room.bed_prefix','Bed.bedno','Ward.name','Patient.diagnosis_txt','Surgery.name'),'conditions'=>array('Patient.person_id'=>$personId,'Patient.is_deleted'=>0,'Patient.is_discharge'=>'0')));

		if(!empty($patientData['Diagnosis']['complaints'])){
			$getDiagnoses=' for'.$patientData['Diagnosis']['complaints'];
		}else if(!empty($patientData['NoteDiagnosis']['diagnoses_name'])){
			$getDiagnoses=' for'.$patientData['NoteDiagnosis']['diagnoses_name'];
		}else{
			$getDiagnoses='';
		}

		//if(!empty($data['bednameforSms'])){
		/***BOF-This below bind used for existing details compared fields***///
		/*$roomModel->bindModel(array(
				'belongsTo'=>array(
						'Ward' =>array('foreignKey' => false,'conditions'=>array('Ward.id=Room.ward_id' )),
						'Bed' =>array('foreignKey' => false,'conditions'=>array('Bed.room_id=Room.id' ))
				)));
		$roomData = $roomModel->find('first',array('fields'=>array('Room.name','Bed.id','Room.bed_prefix','Bed.bedno','Ward.name'),'conditions'=>array('Bed.id'=>$data['bednameforSms'])));
		*/	//}
		/***EOF-This below bind used for existing details compared fields***///
		if($type=='OR'){
			/******After tranfering room or bed  to  get sms alert for Referring Physician  ***/
			$mobNo =$patientData['Consultant']['phone1'];
			if(!empty($patientData['Patient']['diagnosis_txt'])){
				$getTextDiareg=' for '.$patientData['Patient']['diagnosis_txt'];
			}else if(!empty($getDiagnoses)){
				$getTextDiareg=' for '.$getDiagnoses;
			}else{
				$getTextDiareg='';
			}
			$msgText='Your patient named '.$patientData['Patient']['lookup_name'].' aged '.$personModel->getCurrentAge($patientData['Person']['dob']).' is admitted in '.$getHospitalName.' hospital'.$getTextDiareg.' has been operated for '.$patientData['Surgery']['name'].' and is shifted to room '.trim($patientData['Room']['name']).'.-'.Configure::read('hosp_details');
		}else if($type=='ORPatientRalative'){
			/******After patient reg to  get sms alert for Patient Relative  ***/
			$mobNo = $patientData['Patient']['mobile_phone'];
			if(!empty($patientData['Patient']['diagnosis_txt'])){
				$getTextDiaOr='for diagnosis '.$patientData['Patient']['diagnosis_txt'];
			}else if(!empty($getDiagnoses)){
				$getTextDiaOr='for diagnosis '.$getDiagnoses;
			}else{
				$getTextDiaOr='';
			}
			$msgText='Your relative named '.$patientData['Patient']['lookup_name'].' aged '.$personModel->getCurrentAge($patientData['Person']['dob']).' admitted in '.$getHospitalName.' hospital'.$getTextDiaOr.' has been operated for '.trim($patientData['Surgery']['name']).' and is shifted to '.$patientData['Room']['name'].' room.-'.Configure::read('hosp_details');
		}

		/****BOF-Only Sending SMS *****/
		$sender_id=Configure::read('sender_id');           // sender id
		$mob_no = $mobNo;     //123, 456 being recepients number To-Physician no or Patient no
		$userName=Configure::read('user_name');   ///User Name
		$pwd=Configure::read('pwd');               //your SMS gatewayhub account password
		$msg=$msgText;//'Sample Msg from DRMhope App';       //your message
		$str = trim(str_replace(' ', '%20', $msg));
		$url=Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mob_no.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 2);
		curl_exec($ch);
		curl_close($ch) ;
		/****EOF-Only Sending SMS *****/
	}

	public function sendToSmsPatientBdayWish($type){
		$personModel = ClassRegistry::init('Person');
		$patientModel = ClassRegistry::init('Patient');
		$getHospitalName=$_SESSION['location_name'];
		$this->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id')),
				)));
		$patientDataAllBday =$patientModel->find('all',array('fields'=>array('full_name' => 'CONCAT(User.first_name," ", User.last_name)','Person.dob','Person.mobile'),'conditions'=>array('DATE_FORMAT(Person.dob, "%m-%d")'=>date('m-d'),'Patient.is_deleted'=>0,'Patient.is_discharge'=>'0')));
		if($type=='Bday'){
			foreach($patientDataAllBday as $patientDataAllBdays){
				/****BOF-Only Sending SMS *****/
				$userName=Configure::read('user_name');   ///User Name
				$sender_id=Configure::read('sender_id');           // sender id
				$pwd=Configure::read('pwd');               //your SMS gatewayhub account password
				$mobNo = $patientDataAllBdays['Person']['mobile'];
				$msgText=$getHospitalName.' wishes you a very happy birthday. Wishing you good health and happiness in life - Dr.'.$patientDataAllBdays[0]['CONCAT(User.first_name," ", User.last_name)'].'.-'.Configure::read('hosp_details');
				$str = trim(str_replace(' ', '%20', $msgText));
				$url=Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mobNo.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2';
				// to replace the space in message with  �%20'
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,$url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_TIMEOUT, 2);
				curl_exec($ch);
				curl_close($ch);
				/*	$url='curl "' .Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mobNo.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2"';
				 return system($url);	*/
			}
		}
	}
	public function sendToSmsPatientVaccinationRemainder($type){
		$personModel = ClassRegistry::init('Person');
		$patientModel = ClassRegistry::init('Patient');
		$getHospitalName=$_SESSION['location_name'];
		$this->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id')),
						'VaccinationRemainder' =>array('foreignKey' => false,'conditions'=>array('VaccinationRemainder.patient_id=Patient.id')),
				)));
		$patientDataVaccination =$patientModel->find('all',array('fields'=>array('full_name' => 'CONCAT(User.first_name," ", User.last_name)','Person.dob','Person.mobile','VaccinationRemainder.date','VaccinationRemainder.id','VaccinationRemainder.status'),'conditions'=>array('Patient.is_deleted'=>0,'VaccinationRemainder.is_deleted'=>0,'Patient.is_discharge'=>'0')));

		if($type=='VaccinationRemainder'){
			foreach($patientDataVaccination as $patientDataVaccinations){
				//$getDate=explode('-',$patientDataVaccinations['VaccinationRemainder']['date']);
				/*$getDiffDate=$getDate[2]-03;
				 $getLen=strlen($getDiffDate); //Find Length becoz of length of character 1 that time show like that date 2014-10--1
				if($getLen=='1'){
				$getWithZero='0'.$getDiffDate;
				}else{
				$getWithZero=$getDiffDate;
				}
				$getDateImplode=$getDate[0].'-'.$getDate[1].'-'.$getWithZero;*/
					
				$getDiffDate=date('Y-m-d',strtotime($patientDataVaccinations['VaccinationRemainder']['date'].' -3 days'));
				if(date('Y-m-d')==$getDiffDate && $patientDataVaccinations['VaccinationRemainder']['status']=='0'){
					/****BOF-Only Sending SMS *****/
					$userName=Configure::read('user_name');   ///User Name
					$sender_id=Configure::read('sender_id');           // sender id
					$pwd=Configure::read('pwd');               //your SMS gatewayhub account password
					$mobNo = $patientDataVaccinations['Person']['mobile'];
					$getMainDate=date('Y-m-d',strtotime($getDiffDate.' +3 days'));
					$getMainDate1 = DateFormatComponent::formatDate2Local($getMainDate,Configure::read('date_format'));
					$msgText='You are due for vaccination on '.$getMainDate1.' call us for an appointment.-'.Configure::read('hosp_details');
					$str = trim(str_replace(' ', '%20', $msgText));
					$url=Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mobNo.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2';
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_TIMEOUT, 2);
					curl_exec($ch);
					curl_close($ch);
					$updateArray = array('VaccinationRemainder.status'=>"'1'") ;
					$this->VaccinationRemainder->updateAll($updateArray,array('VaccinationRemainder.date '=>$getMainDate));
					/*	$url='curl "' .Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mobNo.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2"';
					 return system($url);	*/
				}

			}
		}
	}
	///It used in EstimateController
	public function sendToSmsMultipleUser($personId,$type,$data,$appointId){
		$patientModel = ClassRegistry::init('Patient');
		$personModel = ClassRegistry::init('Person');
		$userModel = ClassRegistry::init('User');
		$getHospitalName=$_SESSION['location_name'];

		$this->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id')),
						'Consultant' =>array('foreignKey' => false,'conditions'=>array('Consultant.id=Patient.consultant_id')),
						'OptAppointment' =>array('foreignKey' => false,'conditions'=>array('OptAppointment.patient_id=Patient.id','OptAppointment.id'=>$appointId)),
						'Surgery' =>array('foreignKey' => false,'conditions'=>array('OptAppointment.surgery_id=Surgery.id')),
				)));

		$patientData = $patientModel->find('first',array('fields'=>array('User.phone1','User.mobile','Patient.id','Patient.lookup_name','Person.dob','OptAppointment.starttime','Surgery.name'),'conditions'=>array('Patient.person_id'=>$personId,'Patient.is_deleted'=>0,'Patient.is_discharge'=>'0')));
		$data=array_filter($data);
		$patientDataUser =$userModel->find('all',array('fields'=>array('User.phone1','User.mobile'),'conditions'=>array('User.id'=>$data,'User.is_deleted'=>0)));
		if($type=='Estimate'){
			foreach($patientDataUser as $getUserData){
				/****BOF-Only Sending SMS *****/
				$userName=Configure::read('user_name');   ///User Name
				$sender_id=Configure::read('sender_id');           // sender id
				$pwd=Configure::read('pwd');               //your SMS gatewayhub account password
				$getDateTime=$patientData['OptAppointment']['starttime'];
				$getExplodeData=explode(' ',$getDateTime);
				$getExplodeData[0] =DateFormatComponent::formatDate2LocalForReport($getExplodeData[0],Configure::read('date_format'));
				$mobNo =$getUserData['User']['mobile'];
				$msgText=$patientData['Surgery']['name'].' for  patient named '.$patientData['Patient']['lookup_name'].' aged '.$personModel->getCurrentAge($patientData['Person']['dob']).' is scheduled on '.$getExplodeData[0].' at '.date("h:i A", strtotime($getExplodeData[1])).'.-'.Configure::read('hosp_details');
				$str = trim(str_replace(' ', '%20', $msgText));
				$url=Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mobNo.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2';
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,$url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_TIMEOUT, 2);
				curl_exec($ch);
				curl_close($ch);
				/*	$url='curl "' .Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mobNo.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2"';
				 return system($url);	*/

			}
		}

	}
	public function sendToSmsMultipleSurgeon($personId,$type,$appointId,$userIdArr){
		$patientModel = ClassRegistry::init('Patient');
		$personModel = ClassRegistry::init('Person');
		$userModel = ClassRegistry::init('User');
		$getHospitalName=$_SESSION['location_name'];
	
		$this->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id')),
						'Consultant' =>array('foreignKey' => false,'conditions'=>array('Consultant.id=Patient.consultant_id')),
						'OptAppointment' =>array('foreignKey' => false,'conditions'=>array('OptAppointment.patient_id=Patient.id','OptAppointment.id'=>$appointId)),
						'Surgery' =>array('foreignKey' => false,'conditions'=>array('OptAppointment.surgery_id=Surgery.id')),
				)));
	
		$patientData = $patientModel->find('first',array('fields'=>array('User.phone1','User.mobile','Patient.id','Patient.lookup_name','Person.dob','OptAppointment.starttime','Surgery.name'),'conditions'=>array('Patient.person_id'=>$personId,'Patient.is_deleted'=>0,'Patient.is_discharge'=>'0')));
		$userIdArr=array_filter($userIdArr);
		$patientDataUser =$userModel->find('all',array('fields'=>array('User.phone1','User.mobile'),'conditions'=>array('User.id'=>$userIdArr,'User.is_deleted'=>0)));
		if($type=='OTMultipleSurgeon'){
			foreach($patientDataUser as $getUserData){
				/****BOF-Only Sending SMS *****/
				$userName=Configure::read('user_name');   ///User Name
				$sender_id=Configure::read('sender_id');           // sender id
				$pwd=Configure::read('pwd');               //your SMS gatewayhub account password
				$getDateTime=$patientData['OptAppointment']['starttime'];
				$getExplodeData=explode(' ',$getDateTime);
				$getExplodeData[0] =DateFormatComponent::formatDate2LocalForReport($getExplodeData[0],Configure::read('date_format'));
				$mobNo =$getUserData['User']['mobile'];
				$msgText=$patientData['Surgery']['name'].' for  patient named '.$patientData['Patient']['lookup_name'].' aged '.$personModel->getCurrentAge($patientData['Person']['dob']).' is scheduled on '.$getExplodeData[0].' at '.date("h:i A", strtotime($getExplodeData[1])).'.-'.Configure::read('hosp_details');
				$str = trim(str_replace(' ', '%20', $msgText));
				$url=Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mobNo.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2';
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,$url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_TIMEOUT, 2);
				curl_exec($ch);
				curl_close($ch);
				/*	$url='curl "' .Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mobNo.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2"';
				 return system($url);	*/
	
			}
		}
	
	}
	public function sendToSmsMultipleUserForOtherConsultant($personId,$type,$data){
		$session     = new cakeSession();
		$locationId  = $session->read('locationid') ;
		$messageModel = ClassRegistry::init('Message');
		$patientModel = ClassRegistry::init('Patient');
		$personModel = ClassRegistry::init('Person');
		$userModel = ClassRegistry::init('User');
		$consultant = ClassRegistry::init('Consultant');
		$doctorProfile = ClassRegistry::init('DoctorProfile');
		$reffererDoctor = ClassRegistry::init('ReffererDoctor');
		$general = ClassRegistry::init('General');
		$getHospitalName=$_SESSION['location_name'];

		$getUnserializeData=unserialize($data);
		$commonArr = array();
		$doctorArr = array();
		$consultantArr = array();
		foreach($getUnserializeData as $key=>$getUnserializeDatas){
			$commonArr[$key]=explode('_',$getUnserializeDatas);
			if($commonArr[$key]['0']=='consultant'){
				$consultantArr[]=$commonArr[$key]['1'];
			}else if($commonArr[$key]['0']=='doctor'){
				$doctorArr[]=$commonArr[$key]['1'];
			}
		}

		$this->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'Room' =>array('foreignKey' => false,'conditions'=>array('Room.id=Patient.room_id' )),
						'Bed' =>array('foreignKey' => false,'conditions'=>array('Bed.id=Patient.bed_id' )),
						'Ward' =>array('foreignKey' => false,'conditions'=>array('Ward.id=Room.ward_id' )),
						'Diagnosis' =>array('foreignKey' => false,'conditions'=>array('Diagnosis.patient_id=Patient.id')),
						'NoteDiagnosis' =>array('foreignKey' => false,'conditions'=>array('NoteDiagnosis.patient_id=Patient.id')),
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id')),
						'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),	
				)));

		$patientData = $patientModel->find('first',array('fields'=>array('Patient.id','Patient.lookup_name','Person.dob','Patient.diagnosis_txt','Room.bed_prefix','Bed.bedno','Patient.sex','Patient.doctor_id','TariffStandard.name'),'conditions'=>array('Patient.person_id'=>$personId,'Patient.is_deleted'=>0,'Patient.is_discharge'=>'0')));
		
		$consultantData= $consultant->find('all',array('fields'=>array('Consultant.mobile','Consultant.id','Consultant.first_name','Consultant.last_name'),'conditions'=>array('Consultant.id'=>$consultantArr,'Consultant.is_deleted' => 0, 'Consultant.location_id' => $locationId/*, 'ReffererDoctor.is_referral' => 'N'*/)));
		$patientDataUser =$userModel->find('all',array('fields'=>array('User.mobile','User.id'),'conditions'=>array('User.id'=>$doctorArr,'User.is_deleted'=>0)));

		foreach($patientDataUser as $key=>$patientDataUsers){
			if($patientData['Patient']['doctor_id']==$patientDataUsers['User']['id']){
				unset($patientDataUser[$key]);
			}
		}
		$finalArr=array_merge($consultantData,$patientDataUser);
		if(!empty($patientData['Patient']['diagnosis_txt'])){
			$getTextDiareg=' with diagnosis of '.$patientData['Patient']['diagnosis_txt'];
		}

		if($type=='OtherConsultant'){		
			foreach($finalArr as $getUserData){
				/****BOF-Only Sending SMS *****/
				$userName=Configure::read('user_name');   ///User Name
				$sender_id=Configure::read('sender_id');           // sender id
				$pwd=Configure::read('pwd');               //your SMS gatewayhub account password
				if(!empty($getUserData['User']['mobile'])){
					$mobNo =$getUserData['User']['mobile'];
				}else{
					$mobNo =$getUserData['Consultant']['mobile'];
				}
				//$getAgeValue =GeneralComponent::convertYearsMonthsToDaysSeparate($patientData['Patient']['age']);
				
				$getSexPatient=strtoUpper(substr($patientData['Patient']['sex'],0,1));
			
				//$msgText= sprintf(Configure::read('otherConsultantSms'),$patientData['TariffStandard']['name'],$patientData['Patient']['lookup_name'],$getSexPatient,$patientData['Room']['bed_prefix'].$patientData['Bed']['bedno'],Configure::read('hosp_details'));
				
						
				$msgText='('.$patientData['TariffStandard']['name'].')Pt.'.$patientData['Patient']['lookup_name'].'('.$getSexPatient.')'.$patientData['Room']['bed_prefix'].$patientData['Bed']['bedno'].' bed under you.-'.Configure::read('hosp_details');
				
				/*$str = trim(str_replace(' ', '%20', $msgText));
				$url=Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mobNo.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2';
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,$url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_TIMEOUT, 2);
				curl_exec($ch);
				curl_close($ch);*/
				$messageModel->sendToSms($msgText,$mobNo);
			}
		}

	}
	public function sendToSmsMultiplePatientRelative($patientIdWithAmt,$type){
		foreach ($patientIdWithAmt as $key=>$patientIdWithAmts){
			if(empty($patientIdWithAmts['0']) || empty($patientIdWithAmts['1']))
				continue;
			$patientIdArr[$key]=$patientIdWithAmts['0'];
			$TotalBillArr[$patientIdWithAmts['0']]=$patientIdWithAmts['1'];
		}

		$patientModel = ClassRegistry::init('Patient');
		$messageModel = ClassRegistry::init('Message');
		$personModel = ClassRegistry::init('Person');
		$userModel = ClassRegistry::init('User');
		$roleModel = ClassRegistry::init('Role');
		$getHospitalName=$_SESSION['location_name'];
		$this->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						#'Billing' =>array('foreignKey' => false,'conditions'=>array('Billing.patient_id=Patient.id')),
		)));

		$patientData = $patientModel->find('all',array('fields'=>array('Patient.id','Patient.lookup_name','Person.dob','Person.id','Person.mobile','Patient.amount_to_pay_today','Patient.mobile_phone'/*,'Billing.total_amount'*/),'conditions'=>array('Patient.id'=>$patientIdArr,'Patient.is_deleted'=>0,'Patient.is_discharge'=>'0')));		

		if($type=='AdvBill'){
			foreach($patientData as $keyFinal=>$getPatientData){
				if(!empty($getPatientData['Patient']['amount_to_pay_today'])){
					/****BOF-Only Sending SMS *****/
					$userName=Configure::read('user_name');   ///User Name
					$sender_id=Configure::read('sender_id');           // sender id
					$pwd=Configure::read('pwd');               //your SMS gatewayhub account password
					//$mobNo =$getPatientData['Patient']['mobile_phone'];
					//Send SMS To PAtient Relative
					$advDepositValue='20000';
					$msgText=sprintf(Configure::read('advance_msg_patient_ralative'),$getPatientData['Patient']['lookup_name'],$TotalBillArr[$getPatientData['Patient']['id']],$advDepositValue,$getPatientData['Patient']['amount_to_pay_today'],Configure::read('hosp_details'));
					/*$msgText=$getPatientData['Patient']['lookup_name'].' jo Hope hospitals me bharti hai, uska aaj tak ka hospital bill '.$TotalBillArr[$getPatientData['Patient']['id']].' rupay hai. Iske alawa advance deposit '.$advDepositValue.' rupay bharna hai. Aapko bakaya '.$getPatientData['Patient']['amount_to_pay_today'].' rupay aaj do ghante ke pehle bharna hai.%0a %0a'.$getPatientData['Patient']['lookup_name'].' is admitted in Hope hospitals. Hospital bill as on today is Rs.'.$TotalBillArr[$getPatientData['Patient']['id']].'. In addition you are requested to pay an advance deposit of Rs.'.$advDepositValue.'. Please pay a total of Rs.'.$getPatientData['Patient']['amount_to_pay_today'].' within two hours today.%0a-'.Configure::read('hosp_details');  */
					///Please pay Rs. '.$getPatientData['Patient']['amount_to_pay_today'].' to continue availing service in hospital.-'.Configure::read('hosp_details');
					/*$str = trim(str_replace(' ', '%20', $msgText));
					$url=Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mobNo.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2';
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_TIMEOUT, 2);
					$getResult=curl_exec($ch);	*/
					$hexMessage = str_replace('%u', '',$messageModel->utf8_to_unicode($msgText));//For Converting Hindi message into Hexa.						
					$getResult=$messageModel->sendToSms($hexMessage,$getPatientData['Patient']['mobile_phone'],"Hexa");  //for send to patient			
					
					#$getResultexp=explode('-', $getResult);
					#$getResultexp1 = substr($getResultexp['0'], 2);  // returns "cde"										
					curl_close($ch);

					//if($getResult=="Failed#Parameter Missing" || $getResult=="Failed#Invalid Mobile Numbers" || $getResult=="Service Unavailable"){
					#if($getResultexp1==$getPatientData['Patient']['mobile_phone']){	
					if($getResult=='yes'){						
						$getPatientNameArr[$getPatientData['Patient']['id']]=$getPatientData['Patient']['lookup_name'];
					}else{
						continue;
					}
				}
			}
			
		}			
		return $getPatientNameArr; ///For Patient Name which is confirmed to  Sent SMS. 

	}

	public function sendToSmsMultiplePatient($id,$type){
		
		$patientModel = ClassRegistry::init('Patient');
		$personModel = ClassRegistry::init('Person');
		$TemplateSmsModel = ClassRegistry::init('TemplateSms');
		$getHospitalName=$_SESSION['location_name'];
		
		$templateSmsData = $TemplateSmsModel->find('first',array('fields'=>array('sms','patient_id'),'conditions'=>array('TemplateSms.id'=>$id)));
		$getSmsPatientIds=unserialize($templateSmsData['TemplateSms']['patient_id']);
		
		$getPatientId=explode(',',$getSmsPatientIds);
		
		$this->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
				)));
	
		$patientData = $patientModel->find('all',array('fields'=>array('Patient.id','Patient.lookup_name','Person.dob','Person.id','Person.mobile','Patient.amount_to_pay_today','Patient.mobile_phone'),'conditions'=>array('Patient.id'=>$getPatientId,'Patient.is_deleted'=>0,'Patient.is_discharge'=>'0')));
	
		if($type=='FestivalSms'){
			$url="";
			foreach($patientData as $keyFinal=>$getPatientData){				
					/****BOF-Only Sending SMS *****/
					$userName=Configure::read('user_name');   ///User Name
					$sender_id=Configure::read('sender_id');           // sender id
					$pwd=Configure::read('pwd');               //your SMS gatewayhub account password
					$mobNo = $getPatientData['Person']['mobile'];
					//Send SMS To Patient 
					$msgText=$templateSmsData['TemplateSms']['sms'].'.-'.Configure::read('hosp_details');
					$str = trim(str_replace(' ', '%20', $msgText));
					$str = trim(str_replace("\n", ' ', $msgText));					
					$str=urlencode($str);		////For removing new line in text only
					
					$url1=Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mobNo.'&sid='.$sender_id.'&msg='.$str;
					$url=trim($url1).'&fl=0&gwid=2';					
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$url);
					
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					//curl_setopt($ch, CURLOPT_TIMEOUT, 5);
					$getResult=curl_exec($ch);							
					$getResultexp=explode('-', $getResult);
					$getResultexp1 = substr($getResultexp['0'], 2);  // returns "cde"
					curl_close($ch);					
	
					if($getResultexp1==$getPatientData['Person']['mobile']){
						$getPatientNameArr[$getPatientData['Patient']['id']]=$getPatientData['Patient']['lookup_name'];
					}else{
						continue;
					}
				
			}
			
				
		}
		
		return $getPatientNameArr; ///For Patient Name which is confirmed to  Sent SMS.
	
	}
	/**
	 * @author Mahalaxmi
	 * For Send SMS From Hope2Sms
	 * @param typed Mobile no. integer
	 *
	 */
	public function sendToSmsSinglePerson($smsId,$mobNo,$type){		
		$TemplateSmsModel = ClassRegistry::init('TemplateSms');		
		$templateSmsData = $TemplateSmsModel->find('first',array('fields'=>array('sms'),'conditions'=>array('TemplateSms.id'=>$smsId)));		
		if($type=='singleMoNo'){					
				/****BOF-Only Sending SMS *****/
				$userName=Configure::read('user_name');   ///User Name
				$sender_id=Configure::read('sender_id');           // sender id
				$pwd=Configure::read('pwd');               //your SMS gatewayhub account password
				$mobNo = $mobNo;
				//Send SMS To Patient
				$msgText=$templateSmsData['TemplateSms']['sms'].'.-'.Configure::read('hosp_details');
				$str = trim(str_replace(' ', '%20', $msgText));
				$str = trim(str_replace("\n", ' ', $msgText));
				$str=urlencode($str);		////For removing new line in text only
					
				$url1=Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mobNo.'&sid='.$sender_id.'&msg='.$str;
				$url=trim($url1).'&fl=0&gwid=2';
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,$url);
									
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				//curl_setopt($ch, CURLOPT_TIMEOUT, 5);
				$getResult=curl_exec($ch);						
				curl_close($ch);
	
		}	
	
	}
	
	public function sendToSmsOwner($recordId,$type){
		$session     = new cakeSession();
	
		$voucherPayment = ClassRegistry::init('VoucherPayment');
		$accountReceipt = ClassRegistry::init('AccountReceipt');
		$User = ClassRegistry::init('User');


		if($type=='PaymentVoucher'){
			/******After payment voucher saved send SMS to Owner  ***/
			$voucherPayment->bindModel(array(
					'belongsTo' => array(
							'Account' =>array('foreignKey' => false,'conditions'=>array('Account.id=VoucherPayment.user_id' )),
					)));
			$voucherPaymentData = $voucherPayment->find('first',array('fields'=>array('VoucherPayment.paid_amount','VoucherPayment.narration','Account.name'),'conditions'=>array('VoucherPayment.id'=>$recordId,'VoucherPayment.is_deleted'=>0)));
				
			if(!empty($voucherPaymentData['VoucherPayment']['narration'])){
				$getNaration='-'.$voucherPaymentData['VoucherPayment']['narration'].'.';
			}else{
				$getNaration='.';
			}
			$msgText='Cash payment of Rs.'.$voucherPaymentData['VoucherPayment']['paid_amount'].' made to '.$voucherPaymentData['Account']['name'].$getNaration.Configure::read('hosp_details');
		}else if($type=='recieptVoucher'){
			$accountReceipt->bindModel(array(
					'belongsTo' => array(
							'Account' =>array('foreignKey' => false,'conditions'=>array('Account.id=AccountReceipt.user_id' )),
					)));
				
			$accountReceiptData = $accountReceipt->find('first',array('fields'=>array('AccountReceipt.paid_amount','AccountReceipt.narration','Account.name'),'conditions'=>array('AccountReceipt.id'=>$recordId,'AccountReceipt.is_deleted'=>0)));
				
			/******After payment voucher saved send SMS to Owner  ***/
			if(!empty($accountReceiptData['AccountReceipt']['narration'])){
				$getNaration='-'.$accountReceiptData['AccountReceipt']['narration'].'.';
			}else{
				$getNaration='.';
			}
			$msgText='Cash receipt of Rs.'.$accountReceiptData['AccountReceipt']['paid_amount'].' was from '.$accountReceiptData['Account']['name'].$getNaration.Configure::read('hosp_details');;
		}else if($type=='excessAmtOwner'){
			$User->unBindModel( array('belongsTo'=> array('City','State','Country','Role','Initial'))) ;
			/******After payment voucher saved send SMS to Owner  ***/		
			$userfullname = $User->find('first', array('fields'=> array('User.first_name','User.last_name'),
					'conditions'=>array('User.is_deleted'=>'0','User.id'=>$session->read('userid'))));			
			$msgText='The Cashier '.$userfullname['User']['first_name'].' '.$userfullname['User']['last_name'].' has had a excess amount of Rs.'.$recordId['paid_amount'].' on handover to next Cashier '.$recordId['nameUser'].' at ' .date("h:i A").' on '.date("jS \of F Y").'.-'.Configure::read('hosp_details');
			
		}else if($type=='shortAmtOwner'){
			$User->unBindModel( array('belongsTo'=> array('City','State','Country','Role','Initial'))) ;
			/******After payment voucher saved send SMS to Owner  ***/		
			$userfullname = $User->find('first', array('fields'=> array('User.first_name','User.last_name'),
					'conditions'=>array('User.is_deleted'=>'0','User.id'=>$session->read('userid'))));			
			$msgText='The Cashier '.$userfullname['User']['first_name'].' '.$userfullname['User']['last_name'].' has had a short amount of Rs.'.$recordId['debit_amount'].' on handover to next Cashier '.$recordId['nameUser'].' at ' .date("h:i A").' on '.date("jS \of F Y").'.-'.Configure::read('hosp_details');
			
		}
		
		/****BOF-Only Sending SMS *****/
		$sender_id=Configure::read('sender_id');           // sender id
		$mob_no = Configure::read('owner_no');     //123, 456 being recepients number To-Physician no or Patient no
		$userName=Configure::read('user_name');   ///User Name
		$pwd=Configure::read('pwd');               //your SMS gatewayhub account password
		$msg=$msgText;//'Sample Msg from DRMhope App';       //your message
		$str = trim(str_replace(' ', '%20', $msg));
		$url=Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mob_no.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 2);
		curl_exec($ch);
		curl_close($ch) ;
		/****EOF-Only Sending SMS *****/
	}
	///*****EOF-Mahalaxmi--*****///


	public function flowUpcheck($personId){
		$TariffList = ClassRegistry::init('TariffList');
		$this->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$getDate=$this->find('all',array('fields'=>array('person_id','form_received_on'),
				'conditions'=>array('person_id'=>$personId)));
		$dateLast=$getDate[count($getDate)-1]['Patient']['form_received_on'];
		$currentDate=Date('Y-m-d H:i');
		$elapsed=DateFormatComponent::dateDiff($dateLast,$currentDate);
		$days=Configure::read('followupDuration');
		if(($elapsed->d) < $days){
			//return 'followup';
			$OPCheckUpOptions=$TariffList->find('first',array('fields'=>array('id','name'),
					'conditions'=>array('name'=>'Follow-Up Consultation','is_deleted'=>'0')));
			return $OPCheckUpOptions['TariffList']['id'];
		}else{
			//	$OPCheckUpOptions=$TariffList->find('list',array('fields'=>array('id','name'),'conditions'=>array('name'=>'Follow-Up Consultation')));
			//if($elapsed->d)
		}
	}

	function updateotherconsultant($id,$otherConsultantStr=array())
	{
		if(!$id) return false ;
		$this->id = $id ;
		return $this->save(array('other_consultant'=>$otherConsultantStr)) ;

	}

	//get tariff_Standard_id from patient_id
	public function getTariffStandardIDByPatient($patient_id=null){
		if(!$patient_id) return false ;
		$this->unBindModel(array('hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$result = $this->find("first",array('fields'=>array('tariff_standard_id'),"conditions"=>array("Patient.id"=>$patient_id)));
		return $result['Patient']['tariff_standard_id'];
	}
	//*******BOF-Other Consultant ---Mahalaxmi
	public function otherConsultantDoctors(){
		$session     = new cakeSession();
		$locationId  = $session->read('locationid') ;
		$consultant = ClassRegistry::init('Consultant');
		$doctorProfile = ClassRegistry::init('DoctorProfile');
		$reffererDoctor = ClassRegistry::init('ReffererDoctor');
		//BOF-For External Consultant
		$consultant->bindModel(array(
				'belongsTo' => array(
						'ReffererDoctor' =>array('foreignKey' => false,'conditions'=>array('Consultant.refferer_doctor_id=ReffererDoctor.id')),
						'Initial' =>array('foreignKey' => false,'conditions'=>array('Consultant.initial_id=Initial.id')),
				)),false);
		$consultantData= $consultant->find('all',array('fields'=>array('Consultant.id','Consultant.first_name','Consultant.last_name','Initial.name as nameInitial'),'conditions'=>array('Consultant.is_deleted' => 0, 'Consultant.location_id' => $locationId, 'ReffererDoctor.is_referral' => 'N')));
		foreach($consultantData as $keyConsultant=>$consultantDatas){
			$consultantArr['consultant_'.$consultantDatas['Consultant']['id']] = $consultantDatas['Initial']['nameInitial'].$consultantDatas['Consultant']['first_name'].' '.$consultantDatas['Consultant']['last_name'];
		}
		//EOF-For External Consultant
		//BOF-For Internal Consultant
		$doctorsList=$doctorProfile->getDoctors();
		foreach($doctorsList as $key=>$doctorsLists){
			$doctorArr['doctor_'.$key] = $doctorsLists;
		}
		//EOF-For Internal Consultant
		$getOtherConsultant=array_merge($consultantArr,$doctorArr);
		//debug($getOtherConsultant);
		//$getOtherConsultant=$consultantArr + $doctorArr;	//commnetd by  pankaj
		return $getOtherConsultant;
	}
	//*******EOF-Other Consultant ---Mahalaxmi
	/**
	 *calculating age from DOB in 0Y 0M OD syantax as in perso  */
	function getCurrentAge($dob){
	
		$date1 = new DateTime($dob);
		$date2 = new DateTime();
		$interval = $date1->diff($date2);
		$date1_explode = explode("-",$dob);
		$person_age_year =  $interval->y . "Y ";
		$personn_age_month =  $interval->m . "M ";
		$person_age_day = $interval->d . "D ";
		if($interval->y > 0)
			$age .= $person_age_year;
		if($interval->m > 0)
			$age .= $personn_age_month;
		if($interval->d > 0)
			$age .= $person_age_day;
		if(((int)$person_age_year==0) &&((int)$personn_age_month==0)&&((int)$person_age_day==0))
			$age .= "0 Day";
		return $age;
	}
	//get all opd patient by amit jain
	function getOpdPatientId($date=null){
		$session     = new cakeSession();
		$patientDetails=$this->find('list',array('fields'=>array('id'),
				'conditions'=>array('Patient.location_id'=>$session->read('locationid'),'Patient.admission_type'=>'OPD','DATE_FORMAT(create_time, "%Y-%m-%d")'=>$date),'group'=>array('Patient.id')));
		 
		return $patientDetails;
	}
	
	
	/**
	 * function to return array of all services
	 * @param array $patient_id
	 */
	function patientServices($patient_id=array()){
		$session = new cakeSession();
		$serviceBill=ClassRegistry::init('ServiceBill');
		$serviceData = $serviceBill->getServices(array('ServiceBill.patient_id'=>$patient_id,'ServiceBill.paid_amount <=0')) ;
		//reset patient array
		$patientData = array();
		foreach($serviceData as $serviceKey =>$serviceValue){//debug($serviceValue);
			if($serviceValue['ServiceBill']['paid_amount']==0 || $serviceValue['ServiceBill']['paid_amount']==NULL  ){
				$count  =  $patientData['services'][$serviceValue['ServiceBill']['patient_id']][$serviceValue['TariffList']['id']]['count'] ;
				$amount = $patientData['services'][$serviceValue['ServiceBill']['patient_id']][$serviceValue['TariffList']['id']]['amount'];
				$patientData['services'][$serviceValue['ServiceBill']['patient_id']][$serviceValue['TariffList']['id']] =
				array_merge(array('patient_id'=>$serviceValue['ServiceBill']),array('name'=>$serviceValue['TariffList']['name'])) ;
				$patientData['services'][$serviceValue['ServiceBill']['patient_id']][$serviceValue['TariffList']['id']]['count']  = $count+$serviceValue['ServiceBill']['no_of_times'] ;
				$currentAmt= $serviceValue['ServiceBill']['amount']*$serviceValue['ServiceBill']['no_of_times'];
				$patientData['services'][$serviceValue['ServiceBill']['patient_id']][$serviceValue['TariffList']['id']]['amount'] = $currentAmt+$amount ;
			}
		}
	
		//lab
		$laboratoryTestOrder = ClassRegistry::init('LaboratoryTestOrder');
		$laboratoryData = $laboratoryTestOrder->getLaboratories(array('LaboratoryTestOrder.patient_id'=>$patient_id)) ;
		foreach($laboratoryData as $labKey =>$serviceValue){
			if($serviceValue['LaboratoryTestOrder']['paid_amount']==0 || $serviceValue['LaboratoryTestOrder']['paid_amount']==NULL  ){
				$count  = $patientData['laboratory'][$serviceValue['LaboratoryTestOrder']['patient_id']][$serviceValue['LaboratoryTestOrder']['laboratory_id']]['count'] ;
				$amount = $patientData['laboratory'][$serviceValue['LaboratoryTestOrder']['patient_id']][$serviceValue['LaboratoryTestOrder']['laboratory_id']]['amount'] ;
				$patientData['laboratory'][$serviceValue['LaboratoryTestOrder']['patient_id']][$serviceValue['LaboratoryTestOrder']['laboratory_id']] =  array_merge(array('patient_id'=>$serviceValue['LaboratoryTestOrder']),array('name'=>$serviceValue['Laboratory']['name'])) ;
				$patientData['laboratory'][$serviceValue['LaboratoryTestOrder']['patient_id']][$serviceValue['LaboratoryTestOrder']['laboratory_id']]['count'] =$count+1;
				$patientData['laboratory'][$serviceValue['LaboratoryTestOrder']['patient_id']][$serviceValue['LaboratoryTestOrder']['laboratory_id']]['amount'] =
				$serviceValue['LaboratoryTestOrder']['amount']+$amount ;
			}
	
		}
	
		//rad
		$radiologyTestOrder = ClassRegistry::init('RadiologyTestOrder');
		$radiologyData = $radiologyTestOrder->getRadiologies(array('RadiologyTestOrder.patient_id'=>$patient_id)) ;
		$patientData['radiology'] =array();
		foreach($radiologyData as $radKey =>$serviceValue){
			if($serviceValue['RadiologyTestOrder']['paid_amount']==0 || $serviceValue['RadiologyTestOrder']['paid_amount']==NULL  ){
				$amount = $patientData['radiology'][$serviceValue['RadiologyTestOrder']['patient_id']][$serviceValue['RadiologyTestOrder']['radiology_id']]['amount'] ;
				$count = $patientData['radiology'][$serviceValue['RadiologyTestOrder']['patient_id']][$serviceValue['RadiologyTestOrder']['radiology_id']]['count'] ;
				$patientData['radiology'][$serviceValue['RadiologyTestOrder']['patient_id']][$serviceValue['RadiologyTestOrder']['radiology_id']] =  array_merge(array('patient_id'=>$serviceValue['RadiologyTestOrder']),array('name'=>$serviceValue['Radiology']['name'])) ;
				$patientData['radiology'][$serviceValue['RadiologyTestOrder']['patient_id']][$serviceValue['RadiologyTestOrder']['radiology_id']]['count'] = $count+1;
				$patientData['radiology'][$serviceValue['RadiologyTestOrder']['patient_id']][$serviceValue['RadiologyTestOrder']['radiology_id']]['amount'] =
				$serviceValue['RadiologyTestOrder']['amount']+$amount ;
			}
				
		}
	
		//consultantBilling
		$consultantBilling = ClassRegistry::init('ConsultantBilling');
		$dDetail = $consultantBilling->getDdetail($patient_id,$condition,$superBillId,true) ;
		$cDetail = $consultantBilling->getCdetail($patient_id,$condition,$superBillId,true) ;
	
		foreach($dDetail as $conKey =>$serviceValue){
			if($serviceValue['consultantBilling']['paid_amount']==0 || $serviceValue['consultantBilling']['paid_amount']==NULL  ){
				$amount = $patientData['consultantBilling'][$serviceValue['ConsultantBilling']['patient_id']][$serviceValue['TariffList']['id']]['amount'];
				$count =$patientData['consultantBilling'][$serviceValue['ConsultantBilling']['patient_id']][$serviceValue['TariffList']['id']]['count'] ;
				$patientData['consultantBilling'][$serviceValue['ConsultantBilling']['patient_id']][$serviceValue['TariffList']['id']] =  array_merge(array('patient_id'=>$serviceValue['ConsultantBilling']['patient_id']),array('name'=>$serviceValue['TariffList']['name'])) ;
				$patientData['consultantBilling'][$serviceValue['ConsultantBilling']['patient_id']][$serviceValue['TariffList']['id']]['amount'] =
				$serviceValue['ConsultantBilling']['amount']+$amount ;
				$patientData['consultantBilling'][$serviceValue['ConsultantBilling']['patient_id']][$serviceValue['TariffList']['id']]['count'] = $count+1 ;
			}
		}
		foreach($cDetail as $conKey =>$serviceValue){
			if($serviceValue['consultantBilling']['paid_amount']==0 || $serviceValue['consultantBilling']['paid_amount']==NULL  ){
				$amount= $patientData['consultantBilling'][$serviceValue['ConsultantBilling']['patient_id']][$serviceValue['TariffList']['id']]['amount'] ;
				$count = $patientData['consultantBilling'][$serviceValue['ConsultantBilling']['patient_id']][$serviceValue['TariffList']['id']]['count']  ;
				$patientData['consultantBilling'][$serviceValue['ConsultantBilling']['patient_id']][$serviceValue['TariffList']['id']] =  array_merge(array('patient_id'=>$serviceValue['ConsultantBilling']),array('name'=>$serviceValue['TariffList']['name'])) ;
				$patientData['consultantBilling'][$serviceValue['ConsultantBilling']['patient_id']][$serviceValue['TariffList']['id']]['count'] = $count+1;
				$patientData['consultantBilling'][$serviceValue['ConsultantBilling']['patient_id']][$serviceValue['TariffList']['id']]['amount'] =
				$serviceValue['ConsultantBilling']['amount']+$amount ;
			}
		}
	
		//ward services
		$wardPatientServices = ClassRegistry::init('WardPatientService');
		$wardServicesData = $wardPatientServices->getWardServices(array('WardPatientService.patient_id'=>$patient_id)) ;
			
		foreach($wardServicesData as $wardKey =>$serviceValue){
			if($serviceValue['WardPatientService']['paid_amount']==0 || $serviceValue['WardPatientService']['paid_amount']==NULL  ){
				$amount = $patientData['wardService'][$serviceValue['WardPatientService']['patient_id']][$serviceValue['TariffList']['id']]['amount'];
				$count = $patientData['wardService'][$serviceValue['WardPatientService']['patient_id']][$serviceValue['TariffList']['id']]['count'] ;
				$patientData['wardService'][$serviceValue['WardPatientService']['patient_id']][$serviceValue['TariffList']['id']] = array_merge(array('patient_id'=>$serviceValue['WardPatientService']),array('name'=>$serviceValue['TariffList']['name'])) ;
				$patientData['wardService'][$serviceValue['WardPatientService']['patient_id']][$serviceValue['TariffList']['id']]['count'] = $count+1;
				$patientData['wardService'][$serviceValue['WardPatientService']['patient_id']][$serviceValue['TariffList']['id']]['amount'] =
				$serviceValue['WardPatientService']['amount']+$amount ;
			}
		}
	
	
		//pharmacy
		$pharmacySaleObj = ClassRegistry::init('PharmacySalesBill');
		$pharmacyData = $pharmacySaleObj->getPatientPharmacyCharges($patient_id) ;
			
		foreach($pharmacyData as $pharKey =>$pharValue){
			$patientData['pharmacy'][$pharKey][1]['patient_id']['patient_id']  = $pharKey;
			$patientData['pharmacy'][$pharKey][1]['patient_id']['amount']  = $pharValue['total']-$pharValue['paid_amount']-$pharValue['return'] ;
			$patientData['pharmacy'][$pharKey][1]['patient_id']['corporate_super_bill_id']  = $pharValue['corporate_super_bill_id'] ;
			$patientData['pharmacy'][$pharKey][1]['patient_id']['no_of_times'] = 1;
			$patientData['pharmacy'][$pharKey][1]['amount'] = $pharValue['total']-$pharValue['discount']-$pharValue['paid_amount']-$pharValue['return']- $pharValue['returnDiscount'];
			$patientData['pharmacy'][$pharKey][1]['count']  = 1 ;
			$patientData['pharmacy'][$pharKey][1]['name']  = 'Pharmacy Charges';
		}
	
		//OT pharmacy
		$otPharmacySaleObj = ClassRegistry::init('OtPharmacySalesBill');
		$otPharmacyData = $otPharmacySaleObj->getPatientOtPharmacyCharges($patient_id) ;
		/*$patientData['otPharmacy'][$patient_id][1]['amount'] = $otPharmacyData['total']-$otPharmacyData['return'] ;
			$patientData['otPharmacy'][$patient_id][1]['count'] = 1;*/
	
		foreach($otPharmacyData as $pharKey =>$pharValue){
			$patientData['otPharmacy'][$pharKey][1]['patient_id']['patient_id'] = $pharKey;
			$patientData['otPharmacy'][$pharKey][1]['patient_id']['amount'] = $pharValue['total']-$pharValue['paid_amount']-$pharValue['return'];
			$patientData['otPharmacy'][$pharKey][1]['patient_id']['corporate_super_bill_id']  = $pharValue['corporate_super_bill_id'] ;
			$patientData['otPharmacy'][$pharKey][1]['patient_id']['no_of_times'] = 1;
			$patientData['otPharmacy'][$pharKey][1]['amount'] = $pharValue['total']-$pharValue['discount']-$pharValue['paid_amount']-$pharValue['return']-$pharValue['returnDiscount'] ;
			$patientData['otPharmacy'][$pharKey][1]['count']  = 1 ;
			$patientData['otPharmacy'][$pharKey][1]['name']  = 'OT Pharmacy Charges' ;
		}
		
		$optAppointmentObj = ClassRegistry::init('OptAppointment');
		$surgeryData = $optAppointmentObj->getSurgeryServices(array('OptAppointment.patient_id'=>$patient_id,'OptAppointment.paid_amount <=0')) ;
		$patientData['surgery'] =array();
		foreach($surgeryData as $surKey =>$serviceValue){
			//debug($serviceValue);
			if($serviceValue['OptAppointment']['paid_amount']==0 || $serviceValue['OptAppointment']['paid_amount']==NULL  ){
				$amount = $patientData['surgery'][$serviceValue['OptAppointment']['patient_id']][$serviceValue['OptAppointment']['surgery_id']]['amount'] ;
				$count = $patientData['surgery'][$serviceValue['OptAppointment']['patient_id']][$serviceValue['OptAppointment']['surgery_id']]['count'] ;
				$patientData['surgery'][$serviceValue['OptAppointment']['patient_id']][$serviceValue['OptAppointment']['surgery_id']] =  array_merge(array('patient_id'=>$serviceValue['OptAppointment']),array('name'=>$serviceValue['Surgery']['name'])) ;
				$patientData['surgery'][$serviceValue['OptAppointment']['patient_id']][$serviceValue['OptAppointment']['surgery_id']]['count'] = $count+1;
				$totalSurgery=0;
				$totalSurgery=$serviceValue['OptAppointment']['surgery_cost']+$serviceValue['OptAppointment']['anaesthesia_cost']+$serviceValue['OptAppointment']['ot_charges'];
				
				$patientData['surgery'][$serviceValue['OptAppointment']['patient_id']][$serviceValue['OptAppointment']['surgery_id']]['amount'] =
				$totalSurgery+$amount ;
			}
				
		}
		 
		//$tariffDocListId=$this->TariffList->getServiceIdByName(Configure::read('DoctorsCharges'));//get tariff list id		
		//$tariffNurseListId=$this->TariffList->getServiceIdByName(Configure::read('NursingCharges'));//get tariff list id
		
		$hospitalType = $session->read('hospitaltype');
		$tariffStandardObj=ClassRegistry::init('TariffStandard');
		$pvtTariffID=$tariffStandardObj->getPrivateTariffID();
		//new ward charges
		$patientData['Doctor']=array();
		$patientData['Nurse']=array();
		$billing=ClassRegistry::init('Billing');
		foreach($patient_id as $patient){
			$doctorDiscount=0;$doctorPaidCharges=0;$nursePaidCharges=0;$nurseDiscount=0;
			$tariffStdData = $this->find('first',array('fields'=>array('id','tariff_standard_id','is_discharge','treatment_type','admission_type','is_packaged','person_id'),
					'conditions'=>array('Patient.id'=>$patient)));
			//if($tariffStdData['Patient']['tariff_standard_id']==$pvtTariffID){
				$wardCharges=$wardPatientServices->getWardCharges($patient);	//echo '<pre>';print_r($wardCharges);
				$totalWardDays=count($wardCharges['day']); //total no of days
				$doct=$patientData['Doctor'][$patient]['1']['amount'] = $billing->getDoctorCharges($totalWardDays,$hospitalType,$tariffStdData['Patient']['tariff_standard_id'],
						$tariffStdData['Patient']['admission_type'],
						$tariffStdData['Patient']['treatment_type']);
				//debug($doct);
				$patientData['Nurse'][$patient]['1']['amount'] = $billing->getNursingCharges($totalWardDays,$hospitalType,$tariffStdData['Patient']['tariff_standard_id']);
				foreach($wardCharges['day'] as $docNurse){
					$doctorPaidCharges=$doctorPaidCharges+$docNurse['doctor_paid_amount'];
					if(empty($doctorDiscount))
						$doctorDiscount=$docNurse['doctor_discount'];
					$nursePaidCharges=$nursePaidCharges+$docNurse['nurse_paid_amount'];
					if(empty($nurseDiscount))
						$nurseDiscount=$docNurse['nurse_discount'];
				}
				$patientData['Doctor'][$patient]['1']['name']='Doctor Charges';
				$patientData['Nurse'][$patient]['1']['name']='Nurse Charges';
				$patientData['Doctor'][$patient]['1']['amount']=$patientData['Doctor'][$patient]['1']['amount']-$doctorPaidCharges-$doctorDiscount;
				$patientData['Nurse'][$patient]['1']['amount']=$patientData['Nurse'][$patient]['1']['amount']-$nursePaidCharges-$nurseDiscount;
			//}
		}
		
		//debug($patientData);
		return $patientData;
	}
	
	
	
	public function getConsCharges($patient_id,$days){
		$session=new CakeSession();
		$patientData['Doctor']=array();
		$patientData['Nurse']=array();
		$billing=ClassRegistry::init('Billing');
		$hospitalType = $session->read('hospitaltype');
		foreach($patient_id as $patient){
			$doctorDiscount=0;$doctorPaidCharges=0;$nursePaidCharges=0;$nurseDiscount=0;
			$tariffStdData = $this->find('first',array('fields'=>array('id','tariff_standard_id','is_discharge','treatment_type','admission_type','is_packaged','person_id'),
					'conditions'=>array('Patient.id'=>$patient)));
				
			if(!$days){
				$wardPatientServices=ClassRegistry::init('WardPatientServices');
				$wardCharges=$wardPatientServices->getWardCharges($patient);	//echo '<pre>';print_r($wardCharges);
				$totalWardDays=count($wardCharges['day']);;
			}else{
				$totalWardDays=$days; //total no of days
			}
			$patientData['Doctor']['amount'] += $billing->getDoctorCharges($totalWardDays,$hospitalType,$tariffStdData['Patient']['tariff_standard_id'],
					$tariffStdData['Patient']['admission_type'],
					$tariffStdData['Patient']['treatment_type']);
			//debug($doct);
			$patientData['Nurse']['amount'] += $billing->getNursingCharges($totalWardDays,$hospitalType,$tariffStdData['Patient']['tariff_standard_id']);
			if($wardCharges['day']){
				foreach($wardCharges['day'] as $docNurse){
					$doctorPaidCharges=$doctorPaidCharges+$docNurse['doctor_paid_amount'];
					if(empty($doctorDiscount))
						$doctorDiscount=$docNurse['doctor_discount'];
					$nursePaidCharges=$nursePaidCharges+$docNurse['nurse_paid_amount'];
					if(empty($nurseDiscount))
						$nurseDiscount=$docNurse['nurse_discount'];
				}
			}
			$patientData['Doctor']['name']='Doctor Charges';
			$patientData['Nurse']['name']='Nurse Charges';
			$patientData['Doctor']['amount']=$patientData['Doctor']['amount']-$doctorPaidCharges-$doctorDiscount;
			$patientData['Nurse']['amount']=$patientData['Nurse']['amount']-$nursePaidCharges-$nurseDiscount;
		
		}
		return $patientData;
	}

	/**
	* function to Patient Details
	* @param patient.id,is_deleted=0,is_discharge=0
	* @author Mahalaxmi
	*/
	public function getPatientDetails($patientId){		
		return $this->find('first',array('fields'=>array('Patient.lookup_name','Patient.sex','Patient.age'),'conditions'=>array('Patient.id'=>$patientId,'Patient.is_deleted'=>0,'Patient.is_discharge'=>0)));
		
	}
	/**
	* function to Patient Details
	* @param patient.id,is_deleted=0
	* @author Mahalaxmi
	*/
	public function getFirstPatientDetails($patientId){		
		return $this->find('first',array('fields'=>array('Patient.lookup_name','Patient.sex','Patient.age'),'conditions'=>array('Patient.id'=>$patientId,'Patient.is_deleted'=>0)));			
	}
	
	/**
	 * function to Patient Details if patient is discharge or not 
	 * @author Amit Jain
	 */
	public function getPatientAllDetails($patientId){
		return $this->find('first',array('fields'=>array('Patient.person_id','Patient.lookup_name','Patient.tariff_standard_id','Patient.admission_id',
				'Patient.form_received_on','Patient.doctor_id','Patient.admission_type','Patient.treatment_type','Patient.discharge_date','Patient.is_staff_register','is_paragon'),
				'conditions'=>array('Patient.id'=>$patientId,'Patient.is_deleted'=>0)));
	}
	
	/* Function by Mrunal
	 * convert admission_id into barcode img
	 */
	public function getPatientAdmissionIdQR($admissionId,$patientId) {
		App::uses ( 'BarcodeHelper', 'Vendor' );
		$barcode = new BarcodeHelper ();
		// Generate Barcode data
		$barcode->barcode ();
		$barcode->setType ( 'C128' );
		$barcode->setCode ( $admissionId );
		$barcode->setSize ( 100, 400);
		$file = 'uploads/patientqrcodes/' . $admissionId . '.png';
		// Generates image file on server
		$barcode->writeBarcodeFile ( $file );
		//save image to Patient
		$patientArray = array();
		if($patientId){
			$patientArray['id'] =  $patientId;
			$patientArray['admission_id_qrcode'] = $file;
			
			$this->save($patientArray);
			$this->id = '';
		}
		return true;
	} 
	
	/* Function by Mrunal
	 * convert patient_name into barcode img
	*/
	public function getPatientNameQR($patientName,$patientId) {
		App::uses ( 'BarcodeHelper', 'Vendor' );
	
		$barcode = new BarcodeHelper ();
		// Generate Barcode data
		$barcode->barcode ();
		$barcode->setType ( 'C128' );
		$barcode->setCode ( $patientName );
		$barcode->setSize ( 100, 400 );
		$file = 'uploads/patientqrcodes/' . $patientName . '.png';
		// Generates image file on server
		$barcode->writeBarcodeFile ( $file );
		//save image to Patient
		$patientArray = array();
		if($patientId){
			$patientArray['id'] =  $patientId;
			$patientArray['patient_name_qrcode'] = $file;
			
			$this->save($patientArray);
			$this->id = '';
		}
		return true;
	}
	
	/**
	 * get List of patients by passing conditions
	 * @param $conditions
	 * @author Pooja Gupta
	 */
	public function getPatientFileList($conditions){
		$patientList=$this->find('all',array('fields'=>array('Patient.id','Patient.lookup_name',
												'Patient.patient_id','Patient.file_number','Patient.form_received_on'),
				'conditions'=>array($conditions,'is_deleted'=>'0',
									'admission_type'=>'IPD')));
		return $patientList;
	}
	
	/**
	 * Ajax function to save patients's file number
	 * @param $fileNumber
	 * @param $patientId
	 * @return boolean
	 * @author Pooja Gupta
	 */
	function saveFile($fileNumber,$patientId){
		$this->updateAll(array(
				'file_number'=>"'$fileNumber'"	
				),array('Patient.id'=>$patientId));
		return true;
	}
	/*
    	Generate File number
    	By Mahalaxmi Nakade 
		return  @D-1-15---Month-Number-Year
    */
	function generatePatientFileNo(){
	  	//$count = $this->find('count',array('conditions'=>array('Month(Patient.create_time)'=> date('m'))));	
		$count = $this->find('count',array('conditions'=>array('DATE_FORMAT(create_time, "%Y-%m")'=> date('Y-m'))));		
		$count++ ; 
  		$unique_id .= substr(date('M'), 0, 1)."-";  // returns "Like DEC-D"
		$unique_id .= $count;
		$unique_id .= "-".substr(date('y'), -2, 2);  // returns "Like 2015-15"  year	
		
 		return strtoupper($unique_id) ; 
    }
    
    /**
     * Function that returns visit date and visit type other that current encounter
     * @param unknown_type $person
     * @param unknown_type $curPatientId
     * Pooja Gupta
     */
    function visitInfo($personId,$curPatientId){
    	$this->bindModel(array('belongsTo'=>array(
    			'TariffStandard'=>array('type'=>'INNER','foreignKey'=>false,
    					'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
    			'User'=>array('type'=>'INNER','foreignKey'=>false,
    					'conditions'=>array('User.id=Patient.doctor_id')),
    	)));
    	$personVist=$this->find('all',array(
    			'fields'=>array('id','form_received_on','admission_type','is_discharge',
    					'discharge_date','User.first_name','User.last_name',
    					'TariffStandard.name'),
    			'conditions'=>array('Patient.person_id'=>$personId,
    					'Patient.id !='=>$curPatientId,'Patient.is_deleted'=>'0'),
    			'order'=>array('Patient.id DESC')
    	));
    	return $personVist;
    }
    
    /**
     * Get person id of patient
     * @param unknown_type $patientId
     * @return unknown
     * Pooja gupta
     */
    function getPatientPersonId($patientId){
    	$persondata=$this->find('first',array('fields'=>array('person_id'),
    			'conditions'=>array('Patient.id'=>$patientId)));
    	$personId=$persondata['Patient']['person_id'];
    	return $personId;
    }
    
    
    /**
     * function to update patient/person data
     * @param unknown_type $data
     * @param unknown_type $personId
     * @param unknown_type $patientId
     * Pooja Gupta
     */
    function editInfo($data,$patientId,$personId){
    
    	$personModel=ClassRegistry::init('Person');
    	$billingModel=ClassRegistry::init('Billing');
    	$personArr['first_name']="'".$data['first_name']."'";
    	$personArr['middle_name']="'".$data['middle_name']."'";
    	$personArr['last_name']="'".$data['last_name']."'";
    	$personArr['dob']="'".DateFormatComponent::formatDate2STD($data['dob'],
    			Configure::read('date_format'))."'";
    	$personArr['state']="'".$data['state_id']."'";
    	$personArr['city']="'".$data['city']."'";
    	$personArr['plot_no']="'".$data['plot_no']."'";
    	$personArr['blood_group']="'".$data['blood_group']."'";
    	$personArr['pin_code']="'".$data['pin_code']."'";
    	$personArr['mobile']="'".$data['mobile_no']."'";
    	//$person['id']=$personId;
    
    	$patientArr['lookup_name']="'". $data['first_name']." ".$data['last_name']."'";
    	$patientArr['dob']="'".DateFormatComponent::formatDate2STD($data['dob'],
    			Configure::read('date_format'))."'";
    	$patientArr['doctor_id']="'".$data['doctor_id']."'";
    	$patientArr['mobile_phone']="'".$data['mobile_no']."'";
    	$patientArr['tariff_standard_id']="'".$data['tariff_standard_id']."'";
    	//$patient['id']=$patientId;
    
    	///Changing tariff , change charges according to tariff
    	if($data['prev_tariff_id']!=$data['tariff_standard_id']){//for changing tariff charges when tariff is changed.
    		$changedTariffCharges=$billingModel->changeTariff($patientId,
    				$data['tariff_standard_id'],
    				$data['prev_tariff_id']);
    	}
    
    	if($personModel->updateAll($personArr,array('Person.id'=>$personId))){
    		if($this->updateAll($patientArr,array('Patient.id'=>$patientId))){
    			return true;
    		}else{
    			return false;
    		}
    	}else{
    		return false;
    	}
    }
    
    /**
     * Function return patients latest or last encounter
     * by passing person id
     * @param unknown_type $personId
     * Pooja Gupta
     */
    function getPersonLastEncounter($personId){
    	$patient=$this->find('first',array('fields'=>array('Patient.id'),
    			'conditions'=>array('Patient.person_id'=>$personId),
    			'order'=>array('Patient.id DESC')));
    	return $patient['Patient']['id'];
    }
    /** Session */
    public function getSessionPatId($patientId){
    	$session = new cakeSession();
    	$session->write('hub.patientid',$patientId);
    		
    }
    /**
     * Function returns list of all encounters
     * @param unknown_type $patientId
     * Pooja Gupta
     */
    function getPersonAllEncounterList($patientId){
    	$patId=$this->find('first',array('fields'=>array('Patient.person_id'),
    			'conditions'=>array('Patient.id'=>$patientId)));
    	$encounterId=$this->find('all',array('fields'=>array('Patient.id','Patient.form_received_on'),
    			'conditions'=>array('Patient.person_id'=>$patId['Patient']['person_id'],'Patient.is_deleted'=>'0'),
    			'group'=>array('Patient.id')));
    	return $encounterId;
    }
     
    /*
     * function to return the boolean to use duplicate sales charges
     * @author : Swapnil
     * @created: 18.03.2016
     */
    public function getFlagUseDuplicateSalesCharge($patientId){
        $result = $this->read('use_duplicate_sales',$patientId);
        return $result['Patient']['use_duplicate_sales'];
    }
    
    public function getPateintConsultantName($allPatientID){
    	$consultantModel=ClassRegistry::init('Consultant');
    	
    	$consultantId=$this->find('all',array('fields'=>array('Patient.consultant_id'),
    			'conditions'=>array('Patient.id'=>$allPatientID,'Patient.is_discharge'=>0)));
    	
    	foreach($consultantId as $consultId){
    		$consultant_id = unserialize($consultId['Patient']['consultant_id']);
    		foreach($consultant_id as $Kkey=> $conId){
    			if($Kkey>0){ $consult = $conId.",";}else{ $consult = $conId;}
    		}
    	}
    	$ConsultanName = $consultantModel->find('all',array(
    			'conditions'=>array('Consultant.id'=>$consult),
    			'fields'=>array('Consultant.first_name','Consultant.last_name')
    	));
    	return $ConsultanName;
    }// end of Patient Consultant id
    
    public function usPatientHeader($patientId,$appointmentID){
    
    	$this->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
    	$this->bindModel(array(
    			'belongsTo' => array(
    					'Person' =>array('foreignKey' => false,'type'=>'INNER','conditions'=>array('Person.id=Patient.person_id' )),
    			)));
    
    
    	$patientData = $this->find('first',
    			array('fields'=>array(
    					'Patient.id','Patient.admission_type','Patient.lookup_name','Patient.age','Patient.admission_id',
    					'Person.dob','Person.sex','Person.patient_uid','Person.ethnicity','Person.maritail_status','Person.sex'),
    					'conditions'=>array('Patient.id'=>$patientId)));
    
    			return $patientData;
    
    }
}

?>