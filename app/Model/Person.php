<?php
class Person extends AppModel {

	public $useTable = 'persons';
	public $name = 'Person';
	//public $useDbConfig = 'user_data';
	public $specific = true;
	//public $actsAs = array('Auditable');//,'Transactional'
	public $virtualFields = array(
			'full_name' => 'CONCAT(Person.first_name," ", Person.last_name)'
	);

	public $validate = array(
			'first_name' => array(
					'rule' => "notEmpty",
					'message' => "Please enter first name."
			),
			/*'dob' => array(
					'rule' => "notEmpty",
					'message' => "Please enter date of birth."
			),*/
			'sex' => array(
					'rule' => "notEmpty",
					'message' => "Please enter gender."
			),
			'last_name' => array(
					'rule' => "notEmpty",
					'message' => "Please enter last name."
			),
			'patient_uid' => array(
					'rule' => "notEmpty",
					'message' => "There is some problem while saving data,Please try again",
			),
			'patient_uid' => array(
					'rule' => "isUnique",
					'message' => "There is some problem while saving data,Please try again",
					'on'=>'create'
			),
	);

	function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds)){
			$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
		}else{
			$this->db_name =  $ds;
		}
		parent::__construct($id, $table, $ds);
	}



	public function getPersonDetailsByID($id=null){
		$this->bindModel(array(
			'belongsTo' => array(
					'Patient' =>array('foreignKey'=>false,
							'conditions'=>array('Patient.person_id=Person.id')
					),
					'DischargeSummary' =>array('foreignKey'=>false,
							'conditions'=>array('DischargeSummary.patient_id=Patient.id')
					)
			)));
		return $this->find("first",	array(/*'fields'=>array('*,Initial.name'),*/'conditions'=>array('Person.id'=>$id)));
	}

	function insertPerson($data =array(),$action,$emergency=null){
		
		$session     = new cakeSession();
		$userid 	 = $session->read('userid') ;

		if(!empty($data["Person"]['location_id'])){
			$locationId  = $data["Person"]['location_id'] ; //by pankaj
		}else{
			$locationId  = $session->read('locationid') ;		
		}
		//debug('hi');die();
		$user = ClassRegistry::init('User');
		//$guarantor = ClassRegistry::init('Guarantor');
		//$guardian = ClassRegistry::init('Guardian');
		if($emergency==emregency){
			$dep_id=$user->find('first',array('fields'=>array('department_id'),'conditions'=>array('User.id'=>$data['Person']['doctor_id'])));
			$dept=$dep_id['User']['department_id'];
		}
		if($action=='update'){
			//debug($data);
			if($_SESSION['role']=='Patient'){
				$this->bindModel(array(
						'belongsTo' => array(
								'Guarantor' =>array('foreignKey' => false,'conditions'=>array('Person.id=Guarantor.person_id')),
								'Guardian' =>array('foreignKey' => false,'conditions'=>array('Person.id=Guardian.person_id')),

						)),false);
				$patientUnEditedContent=$this->find('first',array('conditions'=>array('Person.id'=>$data['Person']['id'])));
				$patientObject = serialize($patientUnEditedContent);
				$my_file ="files".DS."note_xml".DS.person."_".editcontent."_".$data['Person']['id'].".txt";
				file_put_contents($my_file, $patientObject);
			}
			$data["Person"]["modify_time"] = date("Y-m-d H:i:s");
			$data["Person"]["modified_by"] = empty($userid)?'1':$userid;
			$data["Person"]["location_id"] = $locationId ;
			$data["Person"]["consultant_id"] = serialize($data['Person']['consultant_id']) ;
		}else{
			$data["Person"]["create_time"] = date("Y-m-d H:i:s");
			$data["Person"]["modify_time"] = date("Y-m-d H:i:s");
			$data["Person"]["created_by"]  = empty($userid)?'1':$userid;
			$data["Person"]["modified_by"] = empty($userid)?'1':$userid;
			$data["Person"]["location_id"] = $locationId ;
		}
		if(empty($locationId)){
			$data["Person"]["location_id"] = '1';
		}

		if(empty($data['Person']['patient_uid'])){
			unset($data['Person']['patient_uid']) ;
		}

		//debug($data['Person']); exit ;
		$this->create();
	//		
		$this->save($data['Person']);	
		$lastinsid=$this->getInsertId();
		return array('lastinsid'=>$lastinsid,'dept'=>$dept);
	}

	function getUIDPatientDetailsByPatientID($patient_id=null){

		$this->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>false,
								'conditions'=>array('Patient.patient_id=Person.patient_uid')
						)
				)));
		return $this->find('first',array('conditions'=>array('Patient.id'=>$patient_id)));
	}

	function getUIDPatientDetailsByPatientIDQR($patient_id=null){
		$this->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>false,
								'conditions'=>array('Patient.patient_id=Person.patient_uid')
						),
						
				)));
		return $this->find('first',array('fields'=>array('Person.language,/*Initial.name*/Person.first_name,Person.first_name,Person.last_name,Person.age,Person.sex,Person.mobile,
				Person.credit_type_id,Person.photo,Person.patient_uid,Person.plot_no,Person.taluka,Person.district,
				Person.city,Person.landmark,Person.state,Person.pin_code,Person.blood_group,Person.allergies'),'conditions'=>array('Patient.id'=>$patient_id)));
	}

	function updateSponsorDetails($requestData=array(),$id){
		if($id) $data['Person']['id'] = $id;
		$data["Person"]['name_of_ip']  = $requestData['Patient']['name_of_ip'];
		$data["Person"]['relation_to_employee']  = $requestData['Patient']['relation_to_employee'];
		//update executive_emp_id_no or non_executive_emp_id_no
		if(!empty($requestData['Patient']['executive_emp_id_no'])){
			$data["Person"]['non_executive_emp_id_no']  = '';
			$data["Person"]['emp_id_suffix']  = '';
			$data["Person"]['executive_emp_id_no']  = $requestData['Patient']['executive_emp_id_no'];
		}
		if(!empty($requestData['Patient']['non_executive_emp_id_no'])){
			$data["Person"]['executive_emp_id_no']  = '';
			$data["Person"]['non_executive_emp_id_no']  = $requestData['Patient']['non_executive_emp_id_no'];
			$data["Person"]['emp_id_suffix']  = $requestData['Patient']['emp_id_suffix'];
		}
		//EOF update
			
			
		$data["Person"]['designation']  =$requestData['Patient']['designation'];
		$data["Person"]['insurance_number']  = $requestData['Patient']['insurance_number'];
		$data["Person"]['sponsor_company']  = $requestData['Patient']['sponsor_company'];
		$data["Person"]['instruction']  = $requestData['Patient']['instructions'];

		$data["Person"]['age']  = $requestData['Patient']['age'];
		$data["Person"]['sex']  = $requestData['Patient']['sex'];
		$data["Person"]['admission_type']  = $requestData['Patient']['admission_type'];
		$data["Person"]['patient_file']  = $requestData['Patient']['patient_file'];
		$data["Person"]['case_summery_link']  = $requestData['Patient']['case_summery_link'];

		//sponsor details
		$data["Person"]['payment_category']  = $requestData['Patient']['payment_category'];
		$data["Person"]['corporate_sublocation_id']  = $requestData['Patient']['corporate_sublocation_id'];
		if($data["Person"]['payment_category']=='card'){
			if($requestData['Patient']['credit_type_id'] == 1) {
				$data["Person"]['credit_type_id']  = $requestData['Patient']['credit_type_id'];
				$data["Person"]['corporate_location_id']  = $requestData['Patient']['corporate_location_id'];
				$data["Person"]['corporate_id']  = $requestData['Patient']['corporate_id'];
				$data["Person"]['corporate_sublocation_id']  = $requestData['Patient']['corporate_sublocation_id'] ;
				$data["Person"]['corporate_otherdetails']  =$requestData['Patient']['corporate_otherdetails'];
			}else{
				$data["Person"]['credit_type_id']  = $requestData['Patient']['credit_type_id'];
				$data["Person"]['insurance_type_id']  = $requestData['Patient']['insurance_type_id'];
				$data["Person"]['insurance_company_id']  = $requestData['Patient']['insurance_company_id'];
			}
		}else if($data["Person"]['payment_category']=='cash'){
			$data["Person"]['credit_type_id']  = '';
			$data["Person"]['corporate_location_id']  = '';
			$data["Person"]['corporate_id']  = '';
			$data["Person"]['corporate_sublocation_id']  = '' ;
			$data["Person"]['corporate_otherdetails']  ='';

			$data["Person"]['credit_type_id']  = '';
			$data["Person"]['insurance_type_id']  = '';
			$data["Person"]['insurance_company_id']  = '';
		}
		if(empty($data['Person']['patient_uid'])){
			unset($data['Person']['patient_uid']) ;
		}
		$this->save($data);
	}

	/*
	 *
	* make the initial letter capital before saving.
	*
	*/
	public function beforeSave() {
		
		if (isset($this->data[$this->alias]['first_name'])) {
			$this->data[$this->alias]['first_name'] = ucfirst(trim($this->data[$this->alias]['first_name']));
		}
		if (isset($this->data[$this->alias]['last_name'])) {
			$this->data[$this->alias]['last_name'] = ucfirst(trim($this->data[$this->alias]['last_name']));
		}
		if (isset($this->data[$this->alias]['mother_first_name'])) {
			$this->data[$this->alias]['mother_first_name'] = ucfirst(trim($this->data[$this->alias]['mother_first_name']));
		}
		if (isset($this->data[$this->alias]['mother_middle_name'])) {
			$this->data[$this->alias]['mother_middle_name'] = ucfirst(trim($this->data[$this->alias]['mother_middle_name']));
		}
		if (isset($this->data[$this->alias]['mother_last_name'])) {
			$this->data[$this->alias]['mother_last_name'] = ucfirst(trim($this->data[$this->alias]['mother_last_name']));
		}
		if (isset($this->data[$this->alias]['mother_name'])) {
			$this->data[$this->alias]['mother_name'] = ucfirst(trim($this->data[$this->alias]['mother_name']));
		}
		if (isset($this->data[$this->alias]['id'])) {
			unset($this->data[$this->alias]['alternate_patient_uid']);// unique uid from paragon
		}
		return true;
	}

	/**
	 * @author Gaurav Chauriya
	 * @see Model::beforeFind()
	 */
	public function beforeFind($queryData) {
		parent::beforeFind();
		$session = new cakeSession();
		if($session->read('website.instance')=='vadodara'){
			unset($queryData['conditions']['Person.location_id']);
			unset($queryData['conditions']['location_id']);
		}
		//$this->log($queryData);
		return $queryData; //return the modified $queryData
	}

	public function getAllPatients(){
		$session = new cakeSession();
		$persons =  $this->find('all',array('conditions'=>array('location_id'=>$session->read('locationid'),'is_deleted'=>0),
				'fields'=>array('id','first_name','last_name'),'order'=>array('Person.first_name Asc'),'recursive' => 1));
		$personList = array();
		foreach($persons as $person){
			$personList[$person['Person']['id']] = $person['Person']['first_name']. ' ' .$person['Person']['last_name'];
		}
		return $personList;
	}

	public function getUserDetails($userId){
		$userName = $this->find('first',array('conditions' => array('Person.id' => $userId),'fields'=>array('patient_uid','first_name','last_name')));
		return $userName;
	}


	//BOF pankaj
	public function setDataForDashboardRegistration($person_id=null,$appointment_id = null,$primaryProvider=null){

		if(!$person_id) return null ;
		$user = ClassRegistry::init('User');
		$appointment = ClassRegistry::init('Appointment');
		$patient = ClassRegistry::init('Patient');

		$personDataForDashboardReg = $this->find('first',array('fields'=>array('first_name','last_name','patient_uid','age','sex','id',
				'email','dob'),'conditions'=>array('id'=>$person_id)));
		if($appointment_id != null){
			$appointmentData =$appointment->find('first',array('fields'=>array('appointment_with','department_id'),'conditions'=>array('id'=>$appointment_id)));
		}else{
			$appointmentData =$appointment->find('first',array('fields'=>array('appointment_with','department_id'),'conditions'=>array('person_id'=>$person_id),'order'=>array('id DESC')));
		}
		//$userData =$user->getUserDept($appointmentData['Appointment']['appointment_with']);
		
		$shuffleDataForPatient['Patient'] = array(
				'lookup_name'  	=> $personDataForDashboardReg['Person']['first_name']." ".$personDataForDashboardReg['Person']['last_name'],
				'patient_id'   	=> $personDataForDashboardReg['Person']['patient_uid'],
				'age' 		   		=> $patient->getCurrentAge($personDataForDashboardReg['Person']['dob']),
				'sex'		    	=> ucfirst($personDataForDashboardReg['Person']['sex']),
				'person_id'    	=> $personDataForDashboardReg['Person']['id'],
				'email'  	    	=> $personDataForDashboardReg['Person']['email'],
				'doctor_id'    	=> ($appointmentData['Appointment']['appointment_with'])?$appointmentData['Appointment']['appointment_with']:$primaryProvider,
				'department_id'    => $appointmentData['Appointment']['department_id']//$userData['User']['department_id'],
		);

		return $shuffleDataForPatient ;

	}
	//EOF pankaj
	/**
	 * 
	 */
	function getCurrentAge($dob){
		
		$date1 = new DateTime($dob);
		$date2 = new DateTime();
		$interval = $date1->diff($date2);
		$date1_explode = explode("-",$dob);
		$person_age_year =  $interval->y . " Year";
		$personn_age_month =  $interval->m . " Month";
		$person_age_day = $interval->d . " Day";
		if($person_age_year == 0 && $personn_age_month > 0){
			$age = $interval->m ;
			if($age==1){
				$age=$age . " Month";
			}else{
				$age=$age . " Months";
			}
		}else if($person_age_year == 0 && $personn_age_month == 0 && $person_age_day > -1){
			$age = $interval->d . " " + 1 ;
			if($age==1){
				$age=$age . " Day";
			}else{
				$age=$age . " Days";
			}
		}else{
			$age = $interval->y;
			if($age==1){
				$age=$age . " Year";
			}else{
				$age=$age . " Years";
			}
		}
		return $age;
	}
	//BOF aditya


	public function patientsinsurance($patient_id=null,$data=array()){	
		$newInsurance = ClassRegistry::init('NewInsurance');
		$TariffStandard = ClassRegistry::init('TariffStandard');
		$insuranceCompany = ClassRegistry::init('InsuranceCompany');
		$countries = ClassRegistry::init('Country');
		$States = ClassRegistry::init('State');
		$getPatients = ClassRegistry::init('Patient');
		App::import('Vendor', 'signature_to_image');
		$dateFormat = new DateFormatComponent();
		if(!empty($data['NewInsurance']['tariff_standard_name']) && $patient_id !=''){
			$data['NewInsurance']['effective_date'] = $dateFormat->formatDate2STD($data['NewInsurance']['effective_date'],Configure::read('date_format_us'));
			$data['NewInsurance']['subscriber_dob'] = $dateFormat->formatDate2STD($data['NewInsurance']['subscriber_dob'],Configure::read('date_format_us'));
		//	$data['NewInsurance']['subscriber_state'] = $data['Person']['state'];
		
			if(!empty($data['NewInsurance']['upload_card']['name'])){
				$file = $data['NewInsurance']['upload_card'];
				move_uploaded_file($file['tmp_name'], WWW_ROOT.'uploads'.DS.'patient_images'.DS.'thumbnail'.DS.$file['name']);
				$data['NewInsurance']['upload_card'] = $file['name'];
			}else if(!empty($data['Person']['web_cam_card'])){
				$im = imagecreatefrompng($data['Person']['web_cam_card']);
				if($im){
					$imagename= "insurancecard_".mktime().'.png';
					$is_uploaded = imagejpeg($im,WWW_ROOT.'/uploads/patient_images/thumbnail/'.$imagename);
					if($is_uploaded)
						$data["NewInsurance"]['upload_card']  = $imagename ;
				}else{
					unset($data["NewInsurance"]['upload_card']);
				}
			}else{
				unset($data['NewInsurance']['upload_card'] );
			}
			/*if(!empty($data['NewInsurance']['front_of_card']['name'])){
				$file = $data['NewInsurance']['front_of_card'];
				move_uploaded_file($file['tmp_name'], WWW_ROOT.'uploads'.DS.'patient_images'.DS.'thumbnail'.DS.$file['name']);
				$data['NewInsurance']['front_of_card'] = $file['name'];
			}else{
				unset($data['NewInsurance']['front_of_card'] );
			}*/
			if(!empty($data['NewInsurance']['back_of_card']['name'])){
				$file = $data['NewInsurance']['back_of_card'];
				move_uploaded_file($file['tmp_name'], WWW_ROOT.'uploads'.DS.'patient_images'.DS.'thumbnail'.DS.$file['name']);
				$data['NewInsurance']['back_of_card'] = $file['name'];
			}else{
				unset($data['NewInsurance']['back_of_card'] );
			}
		
			if(!empty($data['NewInsurance']['sign_output'])) {
				$signImage = sigJsonToImage($data['NewInsurance']['sign_output'],array('imageSize'=>array(320, 150)));
				$signpadfile = date('U').'.png';
				imagepng($signImage, WWW_ROOT.'signpad'.DS.$signpadfile);
				$data["NewInsurance"]["sign"] = $signpadfile;		
			}else{
				unset($data["NewInsurance"]["sign"]);
			}
			$data['NewInsurance']['patient_uid'] = $patient_id;
			$data['NewInsurance']['insurance_name'] = $data['NewInsurance']['tariff_standard_name'];		
			$newInsurance->save($data['NewInsurance']);
			return true;
		}
		$getDataInsuranceType=$TariffStandard->find('list',array('fields'=>array('TariffStandard.id','TariffStandard.name'),'conditions'=>array('TariffStandard.payer_id <>'=>'')));
		$getDataInsuranceCompany=$insuranceCompany->find('list',array('fields'=>array('InsuranceCompany.id','InsuranceCompany.name'),'conditions'=>array('InsuranceCompany.is_deleted'=>'0')));
		$country = $countries->find('list',array('fields'=>array('id','name'))); //debug($country);
		$State=$States->find('list',array('fields'=>array('id','name'),'conditions'=>array('State.country_id'=>'2')));
		$getPatient=$getPatients->find('first',array('fields'=>array('Patient.id'),'conditions'=>array('Patient.patient_id'=>$patient_id)));
		$getPatientid=$getPatient['Patient']['id'];
		return array('getDataInsuranceType'=>$getDataInsuranceType,'getDataInsuranceCompany'=>$getDataInsuranceCompany,'country'=>$country,'State'=>$State,'getPatientid'=>$getPatientid);
	}
	//EOF aditya
	public function getAllPatientsByKeyword($keyword=null){
		//$dateFormat = new DateFormatComponent();
		if(empty($keyword))
			return false;
		$session = new cakeSession();
		$persons =  $this->find('all',array('conditions'=>array('location_id'=>$session->read('locationid'),'is_deleted'=>0,
				'OR' => array('Person.first_name like' => '%'.$keyword.'%','Person.last_name like' => '%'.$keyword.'%')),
				'fields'=>array('id','first_name','last_name','dob'),'order'=>array('Person.first_name Asc'),'limit'=>10,'recursive' => 1));
		$personList = array();
		foreach($persons as $person){
			$splitDate=split('-',$person['Person']['dob']);
			$dob=$splitDate[2].'/'.$splitDate[1].'/'.$splitDate[0];
			//$dob=$dateFormat->formatDate2Local($person['Person']['dob'],Configure::read('date_format'));
			//DateFormatComponent::formatDate2STD($person['Person']["dob"],Configure::read('date_format')) ;
			$personList[$person['Person']['id']] = $person['Person']['first_name']. ' ' .$person['Person']['last_name']. '-('.$dob.')';
		}
		//debug($personList);
		return $personList;
	}
	
	
	//BOF amit jain
	/**
	 * afterSave function for saving data in account table--Amit jain
	 *
	 **/
	public function afterSave($created)
	{
		//For generating account code for account table
		$session = new CakeSession();
		App::import('Vendor', 'DrmhopeDB');
		if(!empty($_SESSION['db_name'])){
			$db_connection = new DrmhopeDB($_SESSION['db_name']);
		}else{
			$db_connection = new DrmhopeDB('db_hope');
		}
		$getRegistrar = Classregistry::init('Account');
		$accountingGroupObj = Classregistry::init('AccountingGroup');
		$db_connection->makeConnection($getRegistrar);
		$db_connection->makeConnection($accountingGroupObj);
		$setAccountingGroupID = $accountingGroupObj->getAccountingGroupID(Configure::read('AccountingGroupName'));
		$count = $getRegistrar->find('count',array('conditions'=>array('Account.create_time like'=> "%".date("Y-m-d")."%",'Account.location_id'=>$session->read('locationid'))));
		$count++ ; //count currrent entry also
		if($count==0){
			$count = "001" ;
		}else if($count < 10 ){
			$count = "00$count"  ;
		}else if($count >= 10 && $count <100){
			$count = "0$count"  ;
		}
		$month_array = array('A','B','C','D','E','F','G','H','I','J','K','L');
		//find the Hospital name.
		$hospital = $session->read('facility');
		//creating patient ID
		$unique_id   = 'U';
		$unique_id  .= ucfirst(substr($hospital,0,1)); //first letter of the hospital name
		$unique_id  .= strtoupper(substr($session->read('location'),0,2));//first 2 letter of d location
		$unique_id  .= date('y'); //year
		$unique_id  .= $month_array[date('n')-1];//first letter of month
		$unique_id  .= date('d');//day
		$unique_id .= $count;
		 
		$personID = ($this->data['Person']['id'])?$this->data['Person']['id']:$this->id;
		if($this->data['Person']['is_staff_register'] != '1' &&  $this->data['Person']['is_paragon'] != '1'){
		if ($created){
			$this->data['Account']['create_time']=date("Y-m-d H:i:s");
			$this->data['Account']['account_code']=$unique_id;
			$this->data['Account']['status']='Active';
			$this->data['Account']['name']=$this->data['Person']['first_name']." ".$this->data['Person']['last_name'];
			$this->data['Account']['user_type']='Patient';
			$this->data['Account']['system_user_id']=$this->data['Person']['id'];
			$this->data['Account']['location_id']=$session->read('locationid')?$session->read('locationid'):1;
			$this->data['Account']['account_type']='Asset';
			$this->data['Account']['accounting_group_id']=$setAccountingGroupID;
			$getRegistrar->save($this->data['Account']);
		}else{
			if(!empty($this->data['Person']['first_name'])){
				$var=$getRegistrar->find('first',array('fields'=>array('id','account_code'),'conditions'=>array('system_user_id'=>$personID,'user_type'=>'Patient','Account.location_id'=>$session->read('locationid')?$session->read('locationid'):1)));
				if(!empty($var)){
					if(empty($var['Account']['account_code']))
					{
						$this->data['Account']['account_code']=$unique_id;
					}
					$getRegistrar->id = $var['Account']['id'];
					$this->data['Account']['id']=$var['Account']['id'];
					$this->data['Account']['name']=$this->data['Person']['first_name']." ".$this->data['Person']['last_name'];
					$this->data['Account']['modify_time']=date("Y-m-d H:i:s");
					$this->data['Account']['accounting_group_id']=$setAccountingGroupID;
					$this->data['Account']['user_type']='Patient';
					$this->data['Account']['account_type']='Asset';
					$this->data['Account']['system_user_id']=$personID;
					$this->data['Account']['location_id'] = $session->read('locationid')?$session->read('locationid'):1;
					$getRegistrar->save($this->data['Account']);
					$getRegistrar->id = "";
				}
			}
		}
	  }// end of is staff register
	}

	function importPatients($data){
		//debug($data);exit;
		$Person = Classregistry::init('Person');
		$Patient = Classregistry::init('Patient');
		$Appointment = Classregistry::init('Appointment');
		
	
		$session = new cakeSession();
		$data->row_numbers=false;
		$data->col_letters=false;
		$data->sheet=0;
		$data->table_class='excel';
	
		try
		{
			foreach ($data as $key => $dataOfSheet){
				
				if($key=="1") continue;
				$patientName = trim($dataOfSheet['B']);
				$age = trim($dataOfSheet['C']);
				$gender = trim($dataOfSheet['D']);
				$mobile = trim($dataOfSheet['E']);
				$identity = '3';
				$relativeMobile = trim($dataOfSheet['G']);
				$doctorId = trim($dataOfSheet['A']);
				$departmentId = trim($dataOfSheet['A']);
				
				$createtime = date("Y-m-d H:i:s");
				$createdby = $session->read('userid');
				
	
			}
	
			return true;
		}catch(Exception $e){
	
			return false;
		}
	
	}
}