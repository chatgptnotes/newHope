<?php
/**
 * Billings Controller
 *
 * PHP 5
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Billings
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
class BillingsController extends AppController {

	public $name = 'Billings';

	public $helpers = array('DateFormat','RupeesToWords','Number','General');

	public $components = array('General','DateFormat','Number','GibberishAES');

	public function beforeFilter(){
		parent::beforeFilter();
    $this->loadModel('ChatGptLog');
	}




	public function patientSearch(){
		
		$this->uses = array('Patient');
		$this->set('data','');
		$role = $this->Session->read('role');
		$search_key['Patient.is_deleted'] = 0;
			
		if(!empty($this->params->query['type'])){
			if(strtolower($this->params->query['type'])=='emergency'){
				$search_key['Patient.admission_type'] = "IPD";
				$search_key['Patient.is_emergency'] = "1";
			}else if($this->params->query['type']=='IPD'){
				$search_key['Patient.admission_type'] = $this->params->query['type'];
				$search_key['Patient.is_emergency'] = "0";
			}else{
				$search_key['Patient.admission_type'] = $this->params->query['type'];
			}
		}
			
		if($role == 'admin'){
			$search_key['Patient.location_id']=$this->Session->read('locationid');
			//$search_key['Location.facility_id']=$this->Session->read('facilityid');
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
							'TariffStandard'=>array('foreignKey'=>false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
							'Location' =>array('foreignKey' => 'location_id'),
							'DischargebyConsultant'=>array('foreignKey'=>false,'conditions'=>array('DischargebyConsultant.patient_id=Patient.id')),
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
					)),false);
		}else{
			$search_key['User.location_id']=$this->Session->read('locationid');
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
							'DischargebyConsultant'=>array('foreignKey'=>false,'conditions'=>array('DischargebyConsultant.patient_id=Patient.id')),
							'TariffStandard'=>array('foreignKey'=>false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
					)),false);
		}
		// for getting initial name //
		$this->Patient->bindModel(array(
				'hasOne' => array(
						'Initial' =>array('foreignKey' => false,'conditions'=>array('Initial.id=User.initial_id' ))
				)),false);
		if(!empty($this->params->query)){
			$search_ele = $this->params->query  ;//make it get
			if(!empty($search_ele['lookup_name'])){
				$search_key['Patient.lookup_name like '] = "%".trim($search_ele['lookup_name'])."%" ;
			}if(!empty($search_ele['patient_id'])){
				$search_key['Patient.patient_id like '] = "%".trim($search_ele['patient_id']) ;
			}if(!empty($search_ele['admission_id'])){
				$search_key['Patient.admission_id like '] = "%".trim($search_ele['admission_id']) ;
			}
			//$search_key['Patient.is_discharge '] = 0 ;
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('Patient.create_time' => 'DESC'),
					'fields'=> array('Patient.admission_type,CONCAT(PatientInitial.name," ",Patient.lookup_name) as lookup_name,Patient.is_discharge,form_received_on,DischargebyConsultant.discharge_date,TariffStandard.name,
							Patient.id,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time,Initial.name'),
					'conditions'=>array($search_key),
					'group'=>array('Patient.id')
			);

			/*$data = $this->paginate('Patient',array('conditions'=>$search_key,'fields'=>
			 array('Patient.full_name,Patient.mobile,Patient.home_phone,CONCAT(User.first_name,",",User.last_name) as full.name') ));*/
			$this->set('data',$this->paginate('Patient'));

		}else{
			//$search_key['Patient.is_discharge '] = 0 ;
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('Patient.create_time' => 'DESC'),
					'fields'=> array('Patient.admission_type,CONCAT(PatientInitial.name," ",Patient.lookup_name) as lookup_name,Patient.is_discharge,form_received_on,DischargebyConsultant.discharge_date,TariffStandard.name,
							Patient.id,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time,Initial.name'),
					'conditions'=>array($search_key)
			);
			//debug($this->paginate('Patient'));exit;
			$dat = $this->paginate('Patient');
			//debug($dat);exit;
			$this->set('data',$this->paginate('Patient'));

		}

	}

	public function dischargePatientSearch(){
		$this->uses = array('Patient');
		$this->set('data','');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Patient.create_time' => 'DESC')
		);

		$role = $this->Session->read('role');
		$search_key['Patient.is_deleted'] = 0;
		if($role == 'admin'){

			#$search_key['Location.facility_id']=$this->Session->read('facilityid');
			$this->Patient->bindModel(array(
			'belongsTo' => array(
			'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
			'Location' =>array('foreignKey' => 'location_id'),
			'FinalBilling' =>array('foreignKey' => false,'conditions'=>array('Patient.id=FinalBilling.patient_id')),
			)),false);
		}else{
			$search_key['User.location_id']=$this->Session->read('locationid');
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
							'FinalBilling' =>array('foreignKey' => false,'conditions'=>array('Patient.id=FinalBilling.patient_id')),
					)),false);
		}
			

		if(!empty($this->params->query)){
			$search_ele = $this->params->query  ;//make it get


			if(!empty($search_ele['lookup_name'])){
				$search_key['Patient.lookup_name like '] = "%".trim($search_ele['lookup_name'])."%" ;
			}if(!empty($search_ele['patient_id'])){
				$search_key['Patient.patient_id like '] = "%".trim($search_ele['patient_id']) ;
			}if(!empty($search_ele['admission_id'])){
				$search_key['Patient.admission_id like '] = "%".trim($search_ele['admission_id']) ;
			}

			$search_key['Patient.is_discharge '] = 1 ;

			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('Patient.create_time' => 'DESC'),
					'fields'=> array('FinalBilling.discharge_date,Patient.lookup_name,Patient.is_discharge,form_received_on,
							Patient.id,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time'),
					'conditions'=>array($search_key)
			);
			/*$data = $this->paginate('Patient',array('conditions'=>$search_key,'fields'=>
			 array('Patient.full_name,Patient.mobile,Patient.home_phone,CONCAT(User.first_name,",",User.last_name) as full.name') ));*/
			$this->set('data',$this->paginate('Patient'));

		}else{
			$search_key['Patient.is_discharge '] = 1 ;//pr($search_key);exit;
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('Patient.create_time' => 'DESC'),
					'fields'=> array('FinalBilling.discharge_date,Patient.lookup_name,Patient.is_discharge,form_received_on,
							Patient.id,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time'),
					'conditions'=>array($search_key)
			);
			$this->set('data',$this->paginate('Patient'));
		}
	}
	public function generate_death_summary() {
		$this->autoRender = false;
		if ($this->request->is('post')) {
			$message = $this->request->data['message'];
	
			// OpenAI API request
			$apiKey = "YOUR_OPENAI_API_KEY"; // Replace with your actual key
			$url = "https://api.openai.com/v1/completions";
	
			$postData = json_encode([
				"model" => "gpt-4",
				"prompt" => $message,
				"max_tokens" => 200
			]);
	
			$headers = [
				"Content-Type: application/json",
				"Authorization: Bearer " . $apiKey
			];
	
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	
			$response = curl_exec($ch);
			curl_close($ch);
	
			$responseData = json_decode($response, true);
			echo $responseData['choices'][0]['text'];
		}
	}
	
	public function patient_information($id=null,$viewSection='') {
		//Configure::write('debug',1);
		exit;
		set_time_limit(0);
		ini_set('memory_limit',-1); //max value for memory
			
		$this->uses = array('ServiceCategory','ServiceSubCategory','OtherService','TariffList','Bed','Room','Ward','Nursing','InsuranceCompany',
				'SubServiceDateFormat','ServiceBill','Corporate','Service','DoctorProfile','Person','Consultant','User','Patient',
				'ConsultantBilling','SubService','PharmacySalesBill','PharmacySalesBillDetail','InventoryPharmacySalesReturn',
				'InventoryPharmacySalesReturnsDetail','WardPatient','ServiceProvider');

		$service_group = $this->ServiceCategory->find("all",array(
				"conditions"=>array("ServiceCategory.is_deleted"=>0,"ServiceCategory.is_view"=>1,
						"(ServiceCategory.location_id=".$this->Session->read('locationid')." OR ServiceCategory.location_id=0)"),
				'order' => array('ServiceCategory.name' => 'asc')));
			
		$this->set("service_group",$service_group);

		if(!empty($id)){

			$patient_pharmacy_details = $this->PharmacySalesBill->getPatientSaleDetails($id);
			$pharmacy_total =0;
			if($patient_pharmacy_details){
				//$pharmacy_total = $this->PharmacySalesBill->getTotal($patient_pharmacy_details);
				$this->set('patient_pharmacy_details',$patient_pharmacy_details);
			}
			$this->Patient->unBindModel(array(
					'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'Initial' =>array( 'foreignKey'=>'initial_id'),
							'Consultant' =>array('foreignKey'=>'consultant_treatment'),
							'TariffStandard' =>array('foreignKey'=>'tariff_standard_id')
					)));
			$patient_details  = $this->Patient->getPatientDetailsByIDWithTariff($id);
			$tariffStandardId	=	$patient_details['Patient']['tariff_standard_id'];

			$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);
			$formatted_address = $this->setAddressFormat($UIDpatient_details['Person']);
			$this->set(array('photo' => $UIDpatient_details['Person']['photo'],'address'=>$formatted_address,'patient'=>$patient_details,'id'=>$id,'treating_consultant'=>$this->User->getDoctorByID($patient_details['Patient']['doctor_id'])));

			//by swapnil to fetch the applied services
			$this->ServiceBill->bindModel(array(
					'belongsTo' => array(
							'Patient' =>array('foreignKey'=>'patient_id'),
							"ServiceCategory"=>array('foreignKey'=>'service_id'),
							"ServiceSubCategory"=>array('foreignKey'=>'sub_service_id'),
	 					'TariffList'=>array('foreignKey'=>'tariff_list_id'),
	 					'TariffAmount'=>array('foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=ServiceBill.tariff_list_id','TariffAmount.tariff_standard_id'))
					)));

			$servicesData =$this->ServiceBill->find('all',array('group'=>array('ServiceBill.id'),'fields'=>array('TariffAmount.*,ServiceCategory.*,ServiceSubCategory.*,TariffList.*,ServiceBill.*,Patient.lookup_name'),'conditions'=>array('ServiceBill.patient_id'=>$id),'order'=>array('ServiceBill.date')));

			$this->set('servicesData',$servicesData);
			//debug($servicesData);


			$this->ConsultantBilling->bindModel(array(
					'belongsTo' => array(
							'TariffList' =>array('foreignKey'=>'consultant_service_id'),
							"ServiceCategory"=>array('foreignKey'=>'service_category_id'),
							"ServiceSubCategory"=>array('foreignKey'=>'service_sub_category_id')
					)));
			$consultantBillingData = $this->ConsultantBilling->find('all',array('conditions' =>array('patient_id'=>$id)));//,'date'=>date('Y-m-d')

			$this->set('consultantBillingData',$consultantBillingData);
			$allConsultantsList = $this->Consultant->getConsultantWithDeleted();

			$this->DoctorProfile->virtualFields = array(
					//'doctor_name' => 'CONCAT(Initial.name, " ", DoctorProfile.doctor_name)'
					'doctor_name' => 'DoctorProfile.doctor_name'
			);

			$allDoctorsList = $this->DoctorProfile->find('list', array('conditions' => array('DoctorProfile.location_id' => $this->Session->read('locationid')), 'fields' => array('DoctorProfile.id', 'DoctorProfile.doctor_name'), 'recursive' => 1));

			$this->set(array('allDoctorsList'=>$allDoctorsList,'allConsultantsList'=>$allConsultantsList));

			$creditTypeId = $patient_details['Patient']['credit_type_id'];

			if($creditTypeId == 1){
				$corporateId = $patient_details['Patient']['corporate_id'];
			}elseif($creditTypeId == 2){
				$corporateId = $patient_details['Patient']['insurance_company_id'];
			}else{
				$corporateId = 0;
			}

			if($UIDpatient_details['Person']['corporate_id'] != ''){
				$corporate = $this->Corporate->field('name',array('Corporate.id'=>$UIDpatient_details['Person']['corporate_id']));

			} else if($UIDpatient_details['Person']['insurance_company_id'] != ''){
				$corporate = $this->InsuranceCompany->field('name',array('InsuranceCompany.id'=>$UIDpatient_details['Person']['insurance_company_id']));
			}
			if($patient_details['Patient']['admission_type'] == 'IPD'){
				$this->Ward->recursive = -1;
				$this->Room->recursive = -1;

				$ward_details = $this->Ward->find('first',array('conditions'=>array('Ward.id'=>$patient_details['Patient']['ward_id'])));
				$room_details = $this->Room->find('first',array('conditions'=>array('Room.id'=>$patient_details['Patient']['room_id'])));
				$bed_details = $this->Bed->find('first',array('conditions'=>array('Bed.id'=>$patient_details['Patient']['bed_id'])));

				$this->set(array('ward_details'=>$ward_details,'room_details'=>$room_details,'bed_details'=>$bed_details));
			}


			$tarrifId = $patient_details['Patient']['tariff_standard_id'];

			if(isset($this->params->query['serviceDate']) && $this->params->query['serviceDate'] && !empty($this->params->query['serviceDate'])){
				$serviceDate = $this->DateFormat->formatDate2STD($this->params->query['serviceDate'],Configure::read('date_format'));
				$serviceDate = explode(" ",$serviceDate);
				$serviceDate = $serviceDate[0];
			}else{
				$serviceDate = date('Y-m-d');

			}
			$this->set('serviceDate',$this->DateFormat->formatDate2Local($serviceDate,Configure::read('date_format')));


			$searchServiceName='';
			if(isset($this->request->data) && isset($this->request->data) && $this->request->data['service_name']!=''){
				$searchServiceName = $this->request->data['service_name'];
			}

			$this->TariffList->bindModel(array(
				 'belongsTo' => array(
				 		'TariffAmount' =>array('foreignKey' => false,'conditions'=>array('TariffAmount.tariff_list_id=TariffList.id','TariffAmount.tariff_standard_id'=>$patient_details['Patient']['tariff_standard_id'])),
				 		'ServiceBill' =>array( 'foreignKey'=>false,'type'=>'left','conditions'=>array('ServiceBill.patient_id'=>$id,'ServiceBill.tariff_list_id=TariffList.id','ServiceBill.date'=>$serviceDate)),
				 		'ServiceCategory'=>array( 'foreignKey'=>'service_category_id')
				 )),false);

			if(!empty($searchServiceName)){
					
				$services = $this->TariffList->find('all',array('group'=>array('TariffList.id'),'order'=>array('TariffList.name'),
						'conditions'=>array('TariffList.name like'=>$searchServiceName.'%','TariffList.location_id'=>$this->Session->read('locationid'),
								'TariffList.is_deleted'=>0)));//'ServiceCategory.name'=>'Procedure',
						//debug($services);exit;
			}

			$this->set('services',$services);



			if($creditTypeId == 1){
				$corporates = $this->Corporate->find('list',array('fields'=>array('id','name'),'conditions'=>array('Corporate.is_deleted'=>0)));
				$corporateEmp = $corporates[$corporateId];$this->set('service',$this->Service->find('all',array('conditions'=>array('corporate_id' => $corporateId,'credit_type_id' => $creditTypeId))));

			}else if($creditTypeId == 2){
				$corporates = $this->InsuranceCompany->find('list',array('fields'=>array('id','name'),'conditions'=>array('InsuranceCompany.is_deleted'=>0)));
				$corporateEmp = $corporates[$corporateId];
			}else{
				$corporateEmp ='Private';
			}
			$this->set('corporateEmp',$corporateEmp);
			if($searchServiceName=='')
				$this->set('viewSection',$viewSection);
			else
				$this->set('viewSection','servicesSection');
			//calling lab services performed
			$labServices = $this->labDetails($id);
			$radServices = $this->radDetails($id);
			$mriServices = $this->mriDetails($id); //fetch the mri list
			$ctServices = $this->ctDetails($id);
			$implantServices = $this->implantDetails($id);

			$this->set(array('lab'=>$labServices,'rad'=>$radServices,'mri'=>$mriServices,'ct'=>$ctServices,'implant'=>$implantServices));
			

		}else{
			$this->redirect(array("controller" => "billings", "action" => "patientSearch"));
		}
			
	}

	function viewAllPatientServices($id=null){
		$this->uses = array('InsuranceCompany','SubServiceDateFormat','ServiceBill','Corporate','Service','DoctorProfile','Person','Consultant','User','Patient','ConsultantBilling','SubService');
		if(!empty($id)){
			//check for requester
			//BOF referer link
			$sessionReturnString = $this->Session->read('nursingServiceReturn') ;
			$currentReturnString = $this->params->query['return'] ;
			if(($currentReturnString!='') && ($currentReturnString != $sessionReturnString) ){
				$this->Session->write('nursingServiceReturn',$currentReturnString);
			}else{
				$this->Session->write('nursingServiceReturn','');
			}
			//EOF referer link

			$this->Patient->unBindModel(array(
					'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'Initial' =>array( 'foreignKey'=>'initial_id'),
							'Consultant' =>array('foreignKey'=>'consultant_treatment'),
							'TariffStandard' =>array('foreignKey'=>'tariff_standard_id')
					)));
			$patient_details  = $this->Patient->getPatientDetailsByIDWithTariff($id);

			$tariffStandardId	=	$patient_details['Patient']['tariff_standard_id'];

			$this->ServiceBill->bindModel(array(
					'belongsTo' => array(
							'Patient' =>array(
									'foreignKey'=>'patient_id'
							),
							'TariffList'=>array('foreignKey'=>'tariff_list_id'),
							'TariffAmount'=>array('foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=ServiceBill.tariff_list_id','TariffAmount.tariff_standard_id'=>$tariffStandardId))
					)));

			$servicesData =$this->ServiceBill->find('all',array('group'=>array('ServiceBill.id'),'fields'=>array('TariffAmount.*,TariffList.*,ServiceBill.*,Patient.lookup_name'),'conditions'=>array('ServiceBill.patient_id'=>$id),'order'=>array('ServiceBill.date')));

			$this->set('servicesData',$servicesData);

		}else{
			$this->redirect(array("controller" => "billings", "action" => "patientSearch"));
		}
		$services =$this->Service->find('all');
		$serviceArr = array();
		$subServiceArr = array();
		foreach($services as $service){
			$serviceArr[$service['Service']['id']]= $service['Service']['name'];
			foreach($service['SubService'] as $subService){#echo'<pre>';print_r($service['SubService']);exit;
				$subServiceArr[$subService['id']]['name']= $subService['service'];
				$subServiceArr[$subService['id']]['cost']= $subService['cost'];
			}
		}
		$this->set('serviceArr',$serviceArr);
		$this->set('subServiceArr',$subServiceArr);
		$this->set('patientId',$id);
			
	}

	public function setAddressFormat($patient_details=array()){
		//pr($patient_details);//exit;
		$this->loadModel('State');
		$stateList = $this->State->getStateList();

		$format = '';

		if(!empty($patient_details['plot_no']))
			$format .= $patient_details['plot_no']."";
		if(!empty($patient_details['plot_no']))
			$format .= ',';
		if(!empty($patient_details['landmark']))
			$format .= ucwords($patient_details['landmark']);

		if(!empty($patient_details['plot_no']) || !empty($patient_details['landmark']))
			$format .= "<br/>" ;

		if(!empty($patient_details['city']))
			$format .= ucfirst($patient_details['city']);
		if(!empty($patient_details['city']))
			$format .= ',';
		if(!empty($patient_details['taluka']))
			$format .= ucfirst($patient_details['taluka']);

		if((!empty($patient_details['city']) && !empty($patient_details['taluka'])) && (!empty($patient_details['district']) || !empty($patient_details['state'])))
			$format .= ",<br/>" ;

		if(!empty($patient_details['district']))
			$format .= ucfirst($patient_details['district']);

		if(!empty($patient_details['district']) && !empty($patient_details['state']))
			$format .= "," ;
			
		if(!empty($patient_details['state']))

			$format .= ucfirst($stateList[$patient_details['state']]);

		if(!empty($patient_details['state']) && !empty($patient_details['pin_code']))
			$format .= "-" ;

		if(!empty($patient_details['pin_code']))
			$format .= $patient_details['pin_code'];

		//pr($format);exit;
		return $format ;
	}

	function getDoctorList($DocType=''){
			
		$this->uses = array('User','DoctorProfile','Consultant');
		if($DocType == 0){
			$res = $this->Consultant->getExeternalConsultant();
		}else if($DocType == 1){
			$this->DoctorProfile->unbindModel(array(
					'belongsTo' => array('Department')
			));
			/*
			 $this->DoctorProfile->virtualFields = array(
			 		'doctorname' => 'CONCAT(DoctorProfile.first_name," ",DoctorProfile.last_name)'
			 );*/

			//$getAllDoctorsList = $this->DoctorProfile->getDoctors();
			/*find('list', array('conditions' => array(
			 'DoctorProfile.location_id' => $this->Session->read('locationid'),
					'DoctorProfile.is_deleted'=>0,'DoctorProfile.is_registrar != 1',
			),
					'fields' => array( 'DoctoProfile.first_name','DoctoProfile.id'), 'recursive' => 1,
					'order'=>array('DoctorProfile.doctor_name ASC'),
			)
			);*/

			$this->DoctorProfile->virtualFields = array(
					'doctorname' => 'CONCAT(DoctorProfile.first_name," ",DoctorProfile.last_name)'
			);
			$res =$this->DoctorProfile->find('list',array('fields'=>array('doctorname','DoctorProfile.id'),

					'conditions'=>array('User.is_deleted'=>0, 'DoctorProfile.is_deleted'=>0,'User.location_id'=>$this->Session->read('locationid'),
							'DoctorProfile.is_registrar'=>0,'DoctorProfile.is_active'=>1,'User.is_active'=>1),'order'=>array('DoctorProfile.doctor_name'),


					/*'contain' => array('User', 'Initial'),*/'order' => array('DoctorProfile.first_name'), 'recursive' => 1));


			//print_r($getAllDoctorsList);


		}

		/*
		  
		foreach($getAllDoctorsList as $key =>$value){
		$res[$value] = $key;
		} */
		echo json_encode($res);exit;

		//echo json_encode($getAllDoctorsList);exit;
	}

	function consultantBilling($patient_id=null){
		
		$this->uses = array('ConsultantBilling');
		$this->ConsultantBilling->saveConsultantBillingData($patient_id,$this->request->data);
		 
		if($this->request->query['Flag']=='consultaionBill'){
			exit;
		}else{
			$this->redirect(array("controller" => "billings", "action" => "patient_information",$this->request->data['ConsultantBilling']['patient_id'],'consultantSection'));
		}
		
		/* $this->uses = array('ConsultantBilling','VoucherEntry','TariffList','Consultant','Account','DoctorProfile','Patient','VoucherPayment','VoucherLog');
		$data['ConsultantBilling'] = array();
		//for($i=0; $i < count($this->request->data['ConsultantBilling']['date']); $i++){
		for($i=1; $i <= count($this->request->data['ConsultantBilling']['date']); $i++){
			$data['ConsultantBilling'][$i]['created_by']= $this->Session->read('userid');
			$data['ConsultantBilling'][$i]['create_time']= date("Y-m-d H:i:s");

			if(!empty($this->request->data['ConsultantBilling']['date'][$i])){
				$new_date = $this->request->data['ConsultantBilling']['date'][$i];
				//$splitDate = explode(" ",$this->request->data['ConsultantBilling']['date'][$i]);
				$data['ConsultantBilling'][$i]['date'] = $this->DateFormat->formatDate2STD($new_date,Configure::read('date_format'));
				//debug($data);exit;
			}

			if($this->request->data['ConsultantBilling']['category_id'][$i]==0){
				$data['ConsultantBilling'][$i]['consultant_id']=$this->request->data['ConsultantBilling']['doctor_id'][$i];
				$date['ConsultantBilling'][$i]['doctor_id']='';
			}else if($this->request->data['ConsultantBilling']['category_id'][$i]==1){
				$data['ConsultantBilling'][$i]['doctor_id'] = $this->request->data['ConsultantBilling']['doctor_id'][$i];
				$data['ConsultantBilling'][$i]['consultant_id']='';
			}
			$data['ConsultantBilling'][$i]['patient_id']=$this->request->data['ConsultantBilling']['patient_id'];
			$data['ConsultantBilling'][$i]['consultant_service_id']=$this->request->data['ConsultantBilling']['consultant_service_id'][$i];
			$data['ConsultantBilling'][$i]['service_sub_category_id']=$this->request->data['ConsultantBilling']['service_sub_category_id'][$i];
			$data['ConsultantBilling'][$i]['service_category_id']=$this->request->data['ConsultantBilling']['service_category_id'][$i];
			$data['ConsultantBilling'][$i]['amount']=$this->request->data['ConsultantBilling']['amount'][$i];
			$data['ConsultantBilling'][$i]['description']=$this->request->data['ConsultantBilling']['description'][$i];
			$data['ConsultantBilling'][$i]['not_to_pay_dr']=$this->request->data['ConsultantBilling']['not_to_pay_dr'][$i];
			$data['ConsultantBilling'][$i]['pay_to_consultant']=$this->request->data['ConsultantBilling']['pay_to_consultant'][$i];
			$data['ConsultantBilling'][$i]['location_id']=$this->Session->read('locationid');
			$data['ConsultantBilling'][$i]['category_id']=$this->request->data['ConsultantBilling']['category_id'][$i];
			$errors = $this->ConsultantBilling->save($data['ConsultantBilling'][$i]);

			
			$idVar = $this->ConsultantBilling->id;
			$this->ConsultantBilling->id = '';
		}

		/*   
		//$this->ConsultantBilling->saveAll($data['ConsultantBilling']);
		if($this->request->query['Flag']=='consultaionBill'){
			exit;
		}else{
			$this->redirect(array("controller" => "billings", "action" => "patient_information",$this->request->data['ConsultantBilling']['patient_id'],'consultantSection'));
		} */
	}

	function servicesBilling($patientId=null,$groupID=null){//debug($this->params->query);exit;
		//$this->layout  = 'ajax' ;
		$this->autoRender = false ;
		$this->uses = array('ServiceBill','Nursing','Patient','Billing','TariffStandard','CouponTransaction',/* ,'VoucherEntry','Account','TariffStandard','ServiceProvider','VoucherReference','TariffList' */);
		if (!empty($this->request->data)) {
			$this->request->data['billings']['patient_id'] = ($this->request->data['billings']['patient_id'])?$this->request->data['billings']['patient_id']:$patientId;
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'Initial' =>array( 'foreignKey'=>'initial_id'),
					)));
			$patient_details  = $this->Patient->getPatientDetailsByID($this->request->data['billings']['patient_id']);

			//debug($patient_details['Patient']);
			//$data["billings"]['date'] = $this->DateFormat->formatDate2STD($data["billings"]['date'],Configure::read('date_format'));
			//$count  =$this->ServiceBill->find('count',array('conditions'=>array('patient_id'=>$data['billings']['patient_id'],'date'=>$data["billings"]['date'])));
			//delete previous entries and then insert.
			//$this->ServiceBill->deleteAll(array('patient_id'=>$data['billings']['patient_id'],'date'=>$data["billings"]['date']),false);
			//$serviceData = array();
			/*$date = date("Y-m-d");
			 $passedDate = explode(" ",$data["billings"]['date']);
			//$oldData = $this->ServiceBill->find('all',array('fields'=>array('ServiceBill.tariff_list_id','DATE_FORMAT(ServiceBill.date,"%Y-%m-%d") as date1'),'conditions'=>array('patient_id'=>$data['billings']['patient_id']),'group'=>array("id HAVING date1 = '{$passedDate[0]}'")));
			$oldData = $this->ServiceBill->find('all',array('conditions'=>array('patient_id'=>$data['billings']['patient_id'],'date'=>$passedDate[0])));
			$tmpData = array();
			foreach($oldData as $oData){
			$tmpData[$oData['ServiceBill']['tariff_list_id']]= $oData['ServiceBill']['id'];
			}*/
			//debug($this->request->data);exit;
			$pvtTariffStd=$this->TariffStandard->getPrivateTariffID();//to get private tariff id
			foreach($this->request->data['ServiceBill'] as $key=>$value)
			{
				if(!$patient_details['Patient']['tariff_standard_id'])
					$patient_details['Patient'][$key]['tariff_standard_id'] = $this->TariffStandard->getPrivateTariffID() ; //backup with private patient
				
				if(empty($this->request->data['billings']['serviceGroupId'])){
					$this->loadModel('TariffList');
					$tariff=$this->TariffList->find('first',array('conditions'=>array('id'=>$this->request->data['ServiceBill'][$key]['tariff_list_id'])));
					$serviceGroupId=$tariff['TariffList']['service_category_id'];
				}else{
					$serviceGroupId=$this->request->data['billings']['serviceGroupId'];
				}
				
				/*********************add default discount**********************************/
				if(Configure::read('apply_discount')=='1' && empty($patient_details['Patient']['coupon_name'])){
					if($patient_details['Patient']['tariff_standard_id']==$pvtTariffStd){
						if($value['fix_discount']){
							$disAmt=$this->Billing->getCalDiscount($value['fix_discount'],$value['amount']);
							$this->request->data['ServiceBill'][$key]['amount']=$this->request->data['ServiceBill'][$key]['amount']+$disAmt;
							$this->request->data['ServiceBill'][$key]['discount']=$disAmt*$value['no_of_times'];
						}
					}
				}
				/****************************************************/
				$this->request->data['ServiceBill'][$key]['date'] = $this->DateFormat->formatDate2STD($value['date'],Configure::read('date_format'));
				$this->request->data['ServiceBill'][$key]['location_id'] = $this->Session->read('locationid');
				$this->request->data['ServiceBill'][$key]['tariff_standard_id']=$patient_details['Patient']['tariff_standard_id'];

				
				$this->request->data['ServiceBill'][$key]['create_time'] = date('Y-m-d H:i:s');
				$this->request->data['ServiceBill'][$key]['created_by']=$this->Session->read('userid');
				$this->request->data['ServiceBill'][$key]['patient_id']=$this->request->data['billings']['patient_id'];
				if($this->Session->read('website.instance')=='vadodara'){
					$this->request->data['ServiceBill'][$key]['doctor_id']=$this->params->query['doctor_id'];
				}
				if(empty($this->request->data['ServiceBill'][$key]['service_id'])){
					$this->request->data['ServiceBill'][$key]['service_id']=($this->request->data['billings']['serviceGroupId'])?$this->request->data['billings']['serviceGroupId']:$groupID;
				}
					
				/* $errors = $this->ServiceBill->saveAll($this->request->data['ServiceBill']); */

				$errors = $this->ServiceBill->save($this->request->data['ServiceBill'][$key]);
				$idVar = $this->ServiceBill->id;
				$this->ServiceBill->id = '';
				$totalPayment = $totalPayment+($this->request->data['ServiceBill'][$key]['amount']*$this->request->data['ServiceBill'][$key]['no_of_times']);
				$discount = $discount+($this->request->data['ServiceBill'][$key]['discount']);
				 if(!empty($patient_details['Patient']['coupon_name'])){ 
				    $this->CouponTransaction->ApplyCouponDiscountOnService($this->request->data['billings']['patient_id'],$this->request->data['ServiceBill'][$key]['date'],$serviceGroupId,$totalPayment,$discount,$idVar,$patient_details['Patient']['coupon_name']);
			   }
			}
				
			 if(Configure::read('apply_discount')=='1' && empty($patient_details['Patient']['coupon_name'])){
				if($patient_details['Patient']['tariff_standard_id'] == $pvtTariffStd){
					$this->Billing->saveBillingDiscount($this->request->data['billings']['patient_id'],$this->request->data['ServiceBill'][$key]['date'],$serviceGroupId,$totalPayment,$discount);
				}
			}
			
			/* if(!$errors){
				$this->Session->setFlash(__('Please try again'),'default',array('class'=>"error"));
			}else{
			$this->Session->setFlash(__('Record added successfully', true));
			} */

			//$this->redirect($this->referer());
			/*	foreach($this->request->data['Nursing'] as $key=>$service){
				if(is_array($service)){
			$serviceData['tariff_list_id']=$key;
			$serviceData['tariff_standard_id']=$patient_details['Patient']['tariff_standard_id'];
			$serviceData['location_id']=$this->Session->read('locationid');
			$serviceData['morning']=$service['morning'];
			$serviceData['evening']=$service['evening'];
			$serviceData['night']=$service['night'];
			$serviceData['no_of_times']=$service['no_of_times'];
			$serviceData['patient_id']=$patientId;
			$serviceData['date']=$data["billings"]['date'];
			if($serviceData['morning']==1 || $serviceData['evening']==1 || $serviceData['night']==1){
			if(isset($tmpData[$key])){
			$this->ServiceBill->delete($tmpData[$key]);
			}
			//$this->ServiceBill->save($serviceData);
			$this->ServiceBill->id='';
			}
			$serviceData['morning']=$serviceData['evening']=$serviceData['night']=0;
			}
			} *///end of foreach

			//$this->Session->setFlash(__('Billing activity updated successfully', true));
			//$this->redirect($this->referer());
		}
	}


	public function advancePayment($id){
		$this->uses = array('FinalBilling','TariffStandard','Ward','Room','Bed','InsuranceCompany','SubServiceDateFormat','ServiceBill','Corporate','Service','DoctorProfile','Person','Consultant','User','Patient','ConsultantBilling','SubService','PharmacySalesBill','PharmacySalesBillDetail','InventoryPharmacySalesReturn','InventoryPharmacySalesReturnsDetail');
		if(!empty($id)){
			$this->Patient->unBindModel(array(
					'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'Initial' =>array( 'foreignKey'=>'initial_id'),
							'Consultant' =>array('foreignKey'=>'consultant_treatment'),
							'TariffStandard' =>array('foreignKey'=>'tariff_standard_id')
					)));
			$patient_details  = $this->Patient->getPatientDetailsByIDWithTariff($id);
			$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);

			$patient_pharmacy_details = $this->PharmacySalesBill->getPatientSaleDetails($id);
			$pharmacy_total =0;
			$pharmacy_cash_total = 0;
			$pharmacy_credit_total =0;
			if($patient_pharmacy_details){
				$pharmacy_total = $this->PharmacySalesBill->getTotalAmount($patient_pharmacy_details);
				$pharmacy_cash_total = $this->PharmacySalesBill->getCashAmount($patient_pharmacy_details);
			}

			$formatted_address = $this->setAddressFormat($UIDpatient_details['Person']);
			$this->set(array('photo' => $UIDpatient_details['Person']['photo'],'address'=>$formatted_address,'patient'=>$patient_details,'id'=>$id,'treating_consultant'=>$this->User->getDoctorByID($patient_details['Patient']['doctor_id'])));
			$creditTypeId = $patient_details['Patient']['credit_type_id'];
			if($creditTypeId == 1){
				$corporateId = $patient_details['Patient']['corporate_id'];
			}elseif($creditTypeId == 2){
				$corporateId = $patient_details['Patient']['insurance_company_id'];
			}else{
				$corporateId = 0;
			}
			if($creditTypeId == 1){
				$corporates = $this->Corporate->find('list',array('fields'=>array('id','name'),'conditions'=>array('Corporate.is_deleted'=>0)));
				$corporateEmp = $corporates[$corporateId];
			}else if($creditTypeId == 2){
				$corporates = $this->InsuranceCompany->find('list',array('fields'=>array('id','name'),'conditions'=>array('InsuranceCompany.is_deleted'=>0)));
				$corporateEmp = $corporates[$corporateId];
			}else{
				$corporateEmp ='Private';
			}
			$this->set('corporateEmp',$corporateEmp);

			if($UIDpatient_details['Person']['corporate_id'] != ''){
				$corporate = $this->Corporate->field('name',array('Corporate.id'=>$UIDpatient_details['Person']['corporate_id']));

			} else if($UIDpatient_details['Person']['insurance_company_id'] != ''){
				$corporate = $this->InsuranceCompany->field('name',array('InsuranceCompany.id'=>$UIDpatient_details['Person']['insurance_company_id']));
			}
			if($patient_details['Patient']['admission_type'] == 'IPD'){
				//$this->Ward->recursive = -1;
				$this->Room->recursive = -1;

				$ward_details = $this->Ward->find('first',array('conditions'=>array('Ward.id'=>$patient_details['Patient']['ward_id'])));
				$room_details = $this->Room->find('first',array('conditions'=>array('Room.id'=>$patient_details['Patient']['room_id'])));
				$bed_details = $this->Bed->find('first',array('conditions'=>array('Bed.id'=>$patient_details['Patient']['bed_id'])));

				$this->set(array('ward_details'=>$ward_details,'room_details'=>$room_details,'bed_details'=>$bed_details));
			}

			$consultantCost = $this->Billing->calculateConsultantCharges($id);


			if($patient_details['Patient']['tariff_standard_id']!=''){
				$tariffStandardId=$patient_details['Patient']['tariff_standard_id'];
			}else{
				$tariffData=$this->TariffStandard->find('first',array('conditions'=>array('name'=>'Private')));
				$tariffStandardId=$tariffData['TariffStandard']['id'];
			}
			$hospitalType = $this->Session->read('hospitaltype');


			/******************* Nursing Charges Starts *****************/
			if($patient_details['Patient']['tariff_standard_id']!=''){
				$tariffStandardId=$patient_details['Patient']['tariff_standard_id'];
			}else{
				$tariffStandardId='';
			}

			$nursingServices = $this->getServiceCharges($id,$tariffStandardId);
			$hospitalType = $this->Session->read('hospitaltype');
			if($hospitalType == 'NABH'){
				$nursingServiceCostType = 'nabh_charges';
			}else{
				$nursingServiceCostType = 'non_nabh_charges';
					
			}
			foreach($nursingServices as $nursingServicesKey=>$nursingServicesCost){
				$resetNursingServices[$nursingServicesCost['TariffList']['name']]['qty'][] =
				$nursingServicesCost['ServiceBill']['no_of_times'];
					
				$resetNursingServices[$nursingServicesCost['TariffList']['name']]['cost'] = $nursingServicesCost['TariffAmount'][$nursingServiceCostType];


			}
			$totalNursingCharges=0;
			foreach($resetNursingServices as $resetNursingServicesName=>$nursingService){
				$totalUnit = array_sum($nursingService['qty']);
				if($totalUnit==0){
					$totalUnit = 1;
				}
				$totalNursingCharges = $totalNursingCharges + ($totalUnit*$nursingService['cost']);
			}

			$this->set('totalNursingCharges',$totalNursingCharges);
			/********************* Nursing Charges Ends *******************/
			 	
			/********************* Ward Charges Starts ********************/
			//$wardServicesDataNew = $this->getDay2DayWardCharges($id,$tariffStandardId);
			#$wardServicesDataNew = $this->getDay2DayCharges($id,$tariffStandardId);
			$wardServicesDataNew = $this->groupWardCharges($id);
			$totalWardNewCost=0;
			$totalWardDays=0;

			foreach($wardServicesDataNew as $uniqueSlot){
				if(isset($uniqueSlot['name'])){
					$totalWardNewCost = $totalWardNewCost + $uniqueSlot['cost'];
				}else{
					$wardNameKey = key($uniqueSlot);
					$wardCostPerWard = $uniqueSlot[$wardNameKey][0]['cost'];
					$totalWardNewCost = $totalWardNewCost + (count($uniqueSlot[$wardNameKey]) * $wardCostPerWard);
					$totalWardDays = $totalWardDays + count($uniqueSlot[$wardNameKey]);
				}
			}
			/********************* Ward Charges ends ********************/
			/***************************** Doctor, Nursing, Registration Charges Starts**************/
			$registrationCharges = $this->getRegistrationCharges($totalWardDays,$hospitalType,$tariffStandardId);
			$doctorCharges = $this->Billing->getDoctorCharges($totalWardDays,$hospitalType,$tariffStandardId);
			$nursingCharges = $this->Billing->getNursingCharges($totalWardDays,$hospitalType,$tariffStandardId);
			/***************************** Doctor, Nursing, Registration Charges ends**************/
			 	
			/************************** Lab Radiology Starts*******************/
			//BOF pankaj
			if($hospitalType=='NABH') $isNabh = 'nabh_charges';
			else $isNabh = 'non_nabh_charges';
			$testRates = $this->labRadRates($tariffStandardId,$id);//calling lab/radiology charges
			$labCost='';
			foreach($testRates['labRate'] as $labIndex){
				//if(!empty($labIndex['LaboratoryToken']['ac_id']) || !empty($labIndex['LaboratoryToken']['ac_id'])){
				$labCost += $labIndex['TariffAmount'][$isNabh];
				//}
			}
			$radCost='';
			foreach($testRates['radRate'] as $radIndex){
				$radCost += $radIndex['TariffAmount'][$isNabh];
					
			}
			//EOF pankaj
			/************************** Lab Radiology Ends*******************/
			// Lab Radiology paid amount deduction

			$labPaidAmount = $this->getLabPaidAmount($id);
			$radPaidAmount = $this->getRadPaidAmount($id);
			$this->set('labPaidAmount',$labPaidAmount);
			$this->set('radPaidAmount',$radPaidAmount);
			//Lab Radiology paid amount deduction

			// Calculate other service charges
			$oServices = $this->calculateOtherServices($id);
			if(empty($oServices))
				$oServices =0;
			//registration charges hard coded 100 Rs//$wardServiceCost+. //100+$generalChargesCost+
			$doctorRate = $this->getDoctorRate($totalWardDays,$hospitalType,$tariffStandardId,$patient_details['Patient']['admission_type'],$patient_details['Patient']['treatment_type']);

			// Anesthesia Charges Starts
			$this->OptAppointment->unbindModel(array(
					'belongsTo' => array('Initial','Patient','Location','Opt','OptTable','Surgery','SurgerySubcategory','Doctor','DoctorProfile'

					)));
			/*$this->OptAppointment->bindModel(array(
			 'belongsTo' => array(
			 		'Surgery' =>array(
			 				'foreignKey'=>'surgery_id'
			 		),
			 		'TariffAmount' =>array(
			 				'foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=Surgery.tariff_list_id','TariffAmount.tariff_standard_id'=>$tariffStandardId)
			 		),
			 )));*/
			$this->OptAppointment->bindModel(array(
					'belongsTo' => array(
							'TariffList' =>array( 'foreignKey'=>'tariff_list_id','type'=>'LEFT','conditions'=>array('TariffList.is_deleted'=>0)),
							'Surgeon' =>array('className'=>'DoctorProfile',
									'foreignKey'=>false,
									'type'=>'LEFT',
									'conditions'=>array('Surgeon.user_id=OptAppointment.doctor_id')),
							'Anaesthesist' =>array('className'=>'DoctorProfile',
									'foreignKey'=>false,
									'type'=>'LEFT',
									'conditions'=>array('Anaesthesist.user_id=OptAppointment.department_id')),
							'TariffAmount' =>array( 'foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=OptAppointment.tariff_list_id',
									'TariffAmount.tariff_standard_id'=>$tariffStandardId)),
							'Surgery'=>array('foreignKey'=>'surgery_id'),
							'AnaeTariffAmount' =>array('className'=>'TariffAmount',
									'foreignKey'=>false,
									'conditions'=>array('AnaeTariffAmount.tariff_list_id=OptAppointment.anaesthesia_tariff_list_id','AnaeTariffAmount.tariff_standard_id'=>$tariffStandardId)),

					)));
			//$AnesthesiaDetails = 	$surgeriesData = $this->OptAppointment->find('all',array('fields'=>array('Surgery.anesthesia_charges,TariffAmount.*'),
			//'conditions'=>array('OptAppointment.patient_id'=>$id,'OptAppointment.location_id'=>$this->Session->read('locationid'))));

			$AnesthesiaDetails=$surgeriesData = $this->OptAppointment->find('all',
					array('conditions'=>array('OptAppointment.location_id'=>$this->Session->read('locationid'),
							'OptAppointment.is_deleted'=>0,'OptAppointment.patient_id'=>$id),
							'fields'=>array('OptAppointment.procedure_complete','OptAppointment.anaesthesia_tariff_list_id','Surgeon.education','Surgeon.doctor_name','Anaesthesist.education','Anaesthesist.doctor_name','TariffList.*,TariffAmount.moa_sr_no,
									TariffAmount.tariff_list_id,TariffAmount.nabh_charges,TariffAmount.non_nabh_charges,
									TariffAmount.unit_days','AnaeTariffAmount.id','AnaeTariffAmount.nabh_charges','AnaeTariffAmount.non_nabh_charges',
									'OptAppointment.starttime','OptAppointment.endtime','Surgery.name',
									'OptAppointment.schedule_date','OptAppointment.department_id','TariffList.name'),
									'order'=>'OptAppointment.schedule_date Asc',
									'group'=>'OptAppointment.id',
									'recursive'=>1));



			$anaesthesiaCharges=0;
			foreach($AnesthesiaDetails as $anesthesiaDetail){
				$anaesthesiaCharges += $anesthesiaDetail['AnaeTariffAmount'][$isNabh];

				//$anaesthesiaCharges = $anaesthesiaCharges + ceil($anesthesiaDetail['TariffAmount'][$nursingServiceCostType]*$anesthesiaDetail['Surgery']['anesthesia_charges']/100);
			}

			// Anesthesia Charges Ends

			$total = $nursingCharges+$doctorCharges+$registrationCharges+$totalWardNewCost+
			$totalNursingCharges+$consultantCost+$pharmacy_total+$radCost+$labCost-$radPaidAmount-$labPaidAmount+
			$oServices-$pharmacy_cash_total+$anaesthesiaCharges;
			// debug($total);

			if($patient_details['Patient']['admission_type'] == 'OPD'){
				$total = $doctorRate+$nursingCharges+$doctorCharges+$registrationCharges+$totalWardCharges+
				$totalNursingCharges+$consultantCost+$pharmacy_total+$radCost+$labCost-$radPaidAmount-$labPaidAmount+$oServices-$pharmacy_cash_total;
				$this->set('totalCost',($total));

			}else{
				$this->set('totalCost',($total));
					
			}

			$this->set('advancePayment',$this->Billing->find('all',array('conditions'=>array('patient_id'=>$id,'is_deleted'=>'0',
					'location_id'=>$this->Session->read('locationid')))));

			$this->loadModel('FinalBilling');
			$finalBillingData = $this->FinalBilling->find('first',array('conditions'=>array('location_id'=>$this->Session->read('locationid'),'patient_id'=>$id)));
			if(!empty($finalBillingData)){
				$this->FinalBilling->id = $finalBillingData['FinalBilling']['id'];
				$this->FinalBilling->set('total_amount',$total);
				$this->FinalBilling->save();
			}else{
				$this->FinalBilling->save(array('total_amount'=>$total,'location_id'=>$this->Session->read('locationid'),
						'patient_id'=>$id));
			}
			$this->set('finalBillingData',$finalBillingData);

			//for advance billing list
			//$this->referer : request from
			/* if(fromReport)
			 $deb=$this->redirect($this->referer()) ; */

		}
	}

	public function saveAdvancePayment(){
			
		//$last_split_date_time = explode(" ",$this->request->data['Billing']['date']);
		$this->request->data['Billing']['date'] = $this->DateFormat->formatDate2STD($this->request->data['Billing']['date'],Configure::read('date_format'));
		$this->request->data['Billing']['location_id'] = $this->Session->read('locationid');
		$this->request->data['Billing']['created_by'] = $this->Session->read('userid');
		$this->request->data['Billing']['create_time'] = date('Y-m-d H:i:s');

		//For bank details
		if($this->data['Billing']['mode_of_payment']=='Cheque' || $this->data['Billing']['mode_of_payment']=='Credit Card'){
			$this->request->data['Billing']['neft_date'] = '';
			$this->request->data['Billing']['neft_number'] = '';
		}else if($this->data['Billing']['mode_of_payment']=='NEFT'){
			$this->request->data['Billing']['check_credit_card_number'] = '';
		}else if($this->data['Billing']['mode_of_payment']=='Cash'){
			$this->request->data['Billing']['neft_date'] = '';
			$this->request->data['Billing']['neft_number'] = '';
			$this->request->data['Billing']['bank_name'] = '';
			$this->request->data['Billing']['account_number'] = '';
		}

		if(!empty($this->request->data['Billing']['neft_date'])){
			$this->request->data['Billing']['neft_date'] = $this->DateFormat->formatDate2STD($this->request->data['Billing']['neft_date'],Configure::read('date_format'));
		}
		//EOF bank details
			
		$this->Billing->save($this->request->data['Billing']);
		$this->Session->setFlash(__('Payment added successfully'),true,array('class'=>'message'));
		$this->redirect(array("controller" => "billings", "action" => "advancePayment",$this->request->data['Billing']['patient_id']));
	}

	public function dischargeBill($id){
		$this->layout='advance_ajax';
		$this->uses = array('LabTestPayment','TariffStandard','Ward','Room','Bed','ServiceBill','WardPatient','FinalBilling','InsuranceCompany',
				'SubServiceDateFormat','ServiceBill','Corporate','Service','DoctorProfile','Person','Consultant','User','Patient',
				'ConsultantBilling','SubService','PharmacySalesBill','PharmacySalesBillDetail','InventoryPharmacySalesReturn',
				'InventoryPharmacySalesReturnsDetail','WardPatient');
		$this->loadModel('ServiceBill');
		if(!empty($id)){
			$this->Patient->unBindModel(array(
					'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'Initial' =>array( 'foreignKey'=>'initial_id'),
							'Consultant' =>array('foreignKey'=>'consultant_treatment'),
							'TariffStandard' =>array('foreignKey'=>'tariff_standard_id')
					)));
			$patient_details  = $this->Patient->getPatientDetailsByIDWithTariff($id);
			$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);
			
			//Function to calculate totalBill
			$totalBill=$this->Billing->getPatientTotalBill($id,$patient_details['Patient']['admission_type']);
			
			$patient_pharmacy_details = $this->PharmacySalesBill->getPatientSaleDetails($id);
			$pharmacy_total =0;
			$pharmacy_cash_total = 0;
			$pharmacy_credit_total =0;
			$this->loadModel('Configuration');
			$pharmConfig=$this->Configuration->getPharmacyServiceType();// to get pharmacy service type
			$this->set('pharmaConfig',$pharmConfig['addChargesInInvoice']);
			if($patient_pharmacy_details){
				$pharmacy_total = $this->PharmacySalesBill->getTotalAmount($patient_pharmacy_details);
				$pharmacy_cash_total = $this->PharmacySalesBill->getCashAmount($patient_pharmacy_details);
			}
			// url flag to show pharmacy charges -- Pooja
			if($this->params->query['showPhar']){
				$pharmConfig['addChargesInInvoice']='yes';
			}
			if($pharmConfig['addChargesInInvoice']=='no'){
				$totalBill=$totalBill-$pharmacy_total;
			}
			
			$formatted_address = $this->setAddressFormat($UIDpatient_details['Person']);
			$this->set(array('photo' => $UIDpatient_details['Person']['photo'],'address'=>$formatted_address,'patient'=>$patient_details,'id'=>$id,'treating_consultant'=>$this->User->getDoctorByID($patient_details['Patient']['doctor_id'])));
			$creditTypeId = $patient_details['Patient']['credit_type_id'];
			if($creditTypeId == 1){
				$corporateId = $patient_details['Patient']['corporate_id'];
			}elseif($creditTypeId == 2){
				$corporateId = $patient_details['Patient']['insurance_company_id'];
			}else{
				$corporateId = 0;
			}
			if($creditTypeId == 1){
				$corporates = $this->Corporate->find('list',array('fields'=>array('id','name'),'conditions'=>array('Corporate.is_deleted'=>0)));
				$corporateEmp = $corporates[$corporateId];
			}else if($creditTypeId == 2){
				$corporates = $this->InsuranceCompany->find('list',array('fields'=>array('id','name'),'conditions'=>array('InsuranceCompany.is_deleted'=>0)));
				$corporateEmp = $corporates[$corporateId];
			}else{
				$corporateEmp ='Private';
			}
			$this->set('corporateEmp',$corporateEmp);
			if($UIDpatient_details['Person']['corporate_id'] != ''){
				$corporate = $this->Corporate->field('name',array('Corporate.id'=>$UIDpatient_details['Person']['corporate_id']));

			} else if($UIDpatient_details['Person']['insurance_company_id'] != ''){
				$corporate = $this->InsuranceCompany->field('name',array('InsuranceCompany.id'=>$UIDpatient_details['Person']['insurance_company_id']));
			}
			if($patient_details['Patient']['admission_type'] == 'IPD'){
				//	$this->Ward->recursive = -1;
				$this->Room->recursive = -1;

				$ward_details = $this->Ward->find('first',array('conditions'=>array('Ward.id'=>$patient_details['Patient']['ward_id'])));
				$room_details = $this->Room->find('first',array('conditions'=>array('Room.id'=>$patient_details['Patient']['room_id'])));
				$bed_details = $this->Bed->find('first',array('conditions'=>array('Bed.id'=>$patient_details['Patient']['bed_id'])));

				$this->set(array('ward_details'=>$ward_details,'room_details'=>$room_details,'bed_details'=>$bed_details));
			}
			$consultantCost = $this->Billing->calculateConsultantCharges($id);
			$hospitalType = $this->Session->read('hospitaltype');


			/******************* Nursing Charges Starts *****************/
			if($patient_details['Patient']['tariff_standard_id']!=''){
				$tariffStandardId=$patient_details['Patient']['tariff_standard_id'];
			}else{
				$tariffData=$this->TariffStandard->find('first',array('conditions'=>array('name'=>'Private')));
				#pr($tariffData);exit;
				$tariffStandardId=$tariffData['TariffStandard']['id'];
			}


			$nursingServices = $this->getServiceCharges($id,$tariffStandardId);
			$hospitalType = $this->Session->read('hospitaltype');
			if($hospitalType == 'NABH'){
				$nursingServiceCostType = 'nabh_charges';
			}else{
				$nursingServiceCostType = 'non_nabh_charges';
					
			}
			foreach($nursingServices as $nursingServicesKey=>$nursingServicesCost){
				$resetNursingServices[$nursingServicesCost['TariffList']['name']]['qty'][] =$nursingServicesCost['ServiceBill']['no_of_times'];					
				$resetNursingServices[$nursingServicesCost['TariffList']['name']]['cost'] = $nursingServicesCost['TariffAmount'][$nursingServiceCostType];

			}
			$totalNursingCharges=0;
			foreach($resetNursingServices as $resetNursingServicesName=>$nursingService){
				$totalUnit = array_sum($nursingService['qty']);
				if($totalUnit==0){
					$totalUnit = 1;
				}
				$totalNursingCharges = $totalNursingCharges + $totalUnit*$nursingService['cost'];
			}

			$this->set('totalNursingCharges',$totalNursingCharges);
			/********************* Nursing Charges Ends *******************/
			 	
			/********************* Ward Charges Starts ********************/
			//$wardServicesDataNew = $this->getDay2DayWardCharges($id,$tariffStandardId);
			#$wardServicesDataNew = $this->getDay2DayCharges($id,$tariffStandardId);
			$wardServicesDataNew = $this->groupWardCharges($id);
			$totalWardNewCost=0;
			$totalWardDays=0;
			foreach($wardServicesDataNew as $uniqueSlot){
				if(isset($uniqueSlot['name'])){
					$totalWardNewCost = $totalWardNewCost + $uniqueSlot['cost'];
				}else{
					$wardNameKey = key($uniqueSlot);#echo $wardNameKey;
					$wardCostPerWard = $uniqueSlot[$wardNameKey][0]['cost'];
					$totalWardNewCost = $totalWardNewCost + (count($uniqueSlot[$wardNameKey]) * $wardCostPerWard);
					$totalWardDays = $totalWardDays + count($uniqueSlot[$wardNameKey]);
				}
			}
			/********************* Ward Charges ends ********************/

			/***************************** Doctor, Nursing, Registration Charges Starts**************/

			$registrationCharges = $this->getRegistrationCharges($totalWardDays,$hospitalType,$tariffStandardId);
			$doctorCharges = $this->Billing->getDoctorCharges($totalWardDays,$hospitalType,$tariffStandardId);
			$nursingCharges = $this->Billing->getNursingCharges($totalWardDays,$hospitalType,$tariffStandardId);
			/***************************** Doctor, Nursing, Registration Charges ends**************/
			 	$totalBill=$totalBill+$doctorCharges+$nursingCharges;
			 	$this->set('totalBill',round($totalBill));
			/************************** Lab Radiology Starts*******************/
			//BOF pankaj
			if($hospitalType=='NABH') $isNabh = 'nabh_charges';
			else $isNabh = 'non_nabh_charges';
			$testRates = $this->labRadRates($tariffStandardId,$id);//calling lab/radiology charges

			$labCost='';
			foreach($testRates['labRate'] as $labIndex){
				//if(!empty($labIndex['LaboratoryToken']['ac_id']) || !empty($labIndex['LaboratoryToken']['ac_id'])){
				$labCost += $labIndex['TariffAmount'][$isNabh];
				//}
			}
			$radCost='';
			foreach($testRates['radRate'] as $radIndex){
				$radCost += $radIndex['TariffAmount'][$isNabh];
					
			}
			//EOF pankaj
			/************************** Lab Radiology Ends*******************/

			// Lab Charges paid deduction
			$labPaidAmount = $this->getLabPaidAmount($id);
			$radPaidAmount = $this->getRadPaidAmount($id);

			// Lab Charges paid deduction

			// Calculate other service charges
			$oServices = $this->calculateOtherServices($id);
			if(empty($oServices))
				$oServices =0;

			//registration charges hard coded 100 Rs//$wardServiceCost+. //100+$generalChargesCost+
			$doctorRate = $this->getDoctorRate($totalWardDays,$hospitalType,$tariffStandardId,$patient_details['Patient']['admission_type'],$patient_details['Patient']['treatment_type']);

			/*echo $nursingCharges.'-'.$doctorCharges.'-'.$registrationCharges.'-'.$totalWardNewCost.'-'.
			 $totalNursingCharges.'-'.$consultantCost.'-'.$pharmacy_total.'-'.$radCost.'-'.$labCost.'-'.$labPaidAmount.'-'.$radPaidAmount.'-'.$oServices;
			exit;
			*/

			// Anesthesia Charges Starts
			$this->loadModel('OptAppointment');
			$this->OptAppointment->unbindModel(array(
					'belongsTo' => array('Initial','Patient','Location','Opt','OptTable','Surgery',
							'SurgerySubcategory','Doctor','DoctorProfile'
					)));
			$this->OptAppointment->bindModel(array(
					'belongsTo' => array(
							'Surgery' =>array(
									'foreignKey'=>'surgery_id'
							),
							'TariffAmount' =>array(
									'foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=Surgery.tariff_list_id','TariffAmount.tariff_standard_id'=>$tariffStandardId)
							),
							'AnaeTariffAmount' =>array('className'=>'TariffAmount',
									'foreignKey'=>false,
									'conditions'=>array('AnaeTariffAmount.tariff_list_id=OptAppointment.anaesthesia_tariff_list_id','AnaeTariffAmount.tariff_standard_id'=>$tariffStandardId)),
					)));
			$AnesthesiaDetails = 	$surgeriesData = $this->OptAppointment->find('all',array('fields'=>array('OptAppointment.procedure_complete','Surgery.anesthesia_charges','TariffAmount.*','AnaeTariffAmount.nabh_charges'
					,'AnaeTariffAmount.non_nabh_charges'), 'conditions'=>array('OptAppointment.patient_id'=>$id,'OptAppointment.is_deleted'=>0,
							'OptAppointment.location_id'=>$this->Session->read('locationid')),'group'=>array('OptAppointment.id')));
			$anaesthesiaCharges=0;
			//Commeting OLD concept anaesthesia charges
			//foreach($AnesthesiaDetails as $anesthesiaDetail){
			//$anaesthesiaCharges = $anaesthesiaCharges + ceil($anesthesiaDetail['TariffAmount'][$nursingServiceCostType]*$anesthesiaDetail['Surgery']['anesthesia_charges']/100);
			//}
			//EOD commneted
			if($hospitalType=='NABH') $isNabhCharges = 'nabh_charges';
			else $isNabhCharges = 'non_nabh_charges';
			/* echo  "<!--";
			 print_R($AnesthesiaDetails);
			echo "-->" ;*/
			foreach($AnesthesiaDetails as $anesthesiaDetail){
				$anaesthesiaCharges += $anesthesiaDetail['AnaeTariffAmount'][$isNabhCharges];
			}

			// Anesthesia Charges Ends

			if($patient_details['Patient']['admission_type'] == 'OPD'){
				$this->set('totalCost',($doctorRate+$nursingCharges+$doctorCharges+$registrationCharges+$totalWardCharges+
						$totalNursingCharges+$consultantCost+$pharmacy_total+$radCost+$labCost-$labPaidAmount-$radPaidAmount+$oServices-$pharmacy_cash_total));

			}else{
				$this->set('totalCost',($nursingCharges+$doctorCharges+$registrationCharges+$totalWardNewCost+
						$totalNursingCharges+$consultantCost+$pharmacy_total+$radCost+$labCost-$labPaidAmount-$radPaidAmount+$oServices-$pharmacy_cash_total+$anaesthesiaCharges));
					
			}

			$advancePaidData = $this->Billing->find('all',array('conditions'=>array('patient_id'=>$id,'is_deleted'=>'0',
					'location_id'=>$this->Session->read('locationid'))));



			if($patient_details['Patient']['is_discharge'] == 1){
				$lastRow  = $advancePaidData[count($advancePaidData)-1]  ;
				if(!empty($lastRow['Billing']['neft_date'])){
					$lastRow['Billing']['neft_date'] = $this->DateFormat->formatDate2Local($lastRow['Billing']['neft_date'],Configure::read('date_format'),true) ;
				}

				//$this->data = $lastRow;
			}

			$totalAdvancePaid = 0;
			foreach($advancePaidData as $advancePaid){
				$totalAdvancePaid = $totalAdvancePaid + $advancePaid['Billing']['amount'];
			}

			$totalAdvancePaid = $totalAdvancePaid;//$pharmacy_cash_total; // add pharmacy amount

			$this->set('totalAdvancePaid',$totalAdvancePaid);

			$this->loadModel('FinalBilling');
			
			$finalBillingData = $this->FinalBilling->find('first',array('conditions'=>array('location_id'=>$this->Session->read('locationid'),'patient_id'=>$id)));



			/**************final************/

			if(!empty($finalBillingData)){
				$this->FinalBilling->id = $finalBillingData['FinalBilling']['id'];
				$this->request->data['FinalBilling']['amount_pending']=$totalAdvancePaid;
				$this->FinalBilling->set('totalAdvancePaid',$totalAdvancePaid);
				$this->FinalBilling->save($this->request->data);
			}else{
				$this->FinalBilling->save(array('totalAdvancePaid'=>$totalAdvancePaid,'location_id'=>$this->Session->read('locationid'),
						'patient_id'=>$id));
			}
			//$this->set('finalBillingData',$finalBillingData);






			//BOF selecting in-date of currently ward
			$wardInDate  = $this->WardPatient->find('first',array('conditions'=>array('WardPatient.patient_id'=>$id,'WardPatient.is_deleted'=>0),
					'fields'=>array('in_date'),'order'=>'WardPatient.id'));

			//EOF ward patients

			if($patient_details['Patient']['admission_type']=='OPD'){
				$wardInDateStr = $patient_details['Patient']['form_received_on'];
			}else{
				$wardInDateStr = $wardInDate['WardPatient']['in_date'] ;
			}

			
			//EOF pankaj
			$this->set(array('finalBillingData'=>$finalBillingData,'wardInDate'=>$wardInDateStr,'settlementCount'=>$settlementCount));

		}

	}

	public function getConsultantCharges($id,$charges_type){
		$this->uses = array('Consultant');
		$allConsultantsCharges = $this->Consultant->getConsultantCharges($id);
		#pr($allConsultantsCharges);exit;
		if($charges_type == 'Consultant'){
			echo json_encode($allConsultantsCharges['Consultant']['charges']);exit;
		}else if($charges_type == 'Surgery'){
			echo json_encode($allConsultantsCharges['Consultant']['surgery_charges']);exit;
		}else if($charges_type == 'Other'){
			echo json_encode($allConsultantsCharges['Consultant']['other_charges']);exit;
		}else if($charges_type == 'Anaesthesia'){
			echo json_encode($allConsultantsCharges['Consultant']['anaesthesia_charges']);exit;
		}
		exit;
	}

	public function generateReceipt($id,$mode=''){
			
		$this->uses = array('TariffList','TariffStandard','Bed','FinalBilling','InsuranceCompany','SubServiceDateFormat','ServiceBill','OtPharmacySalesBill',
				'Corporate','Service','DoctorProfile','Person','Consultant','User','Patient','ConsultantBilling','SubService','Billing','OtPharmacySalesReturn',
				'PharmacySalesBill','PharmacySalesBillDetail','InventoryPharmacySalesReturn','InventoryPharmacySalesReturnsDetail','ServiceCategory');
		if(!empty($id)){
			$this->patient_info($id);// For element print patient info
			$this->ServiceBill->bindModel(array(
					'belongsTo' => array(
							'Patient' =>array(
									'foreignKey'=>'patient_id'
							),
					)));


			$patient_pharmacy_details = $this->PharmacySalesBill->getPatientSaleDetails($id);
                        
			//Pharmacy charges will be added to billing only if the Pharmacy Service is set to IPD
			$this->loadModel('Configuration');
			/*$pharmacy_service_type=$this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'Pharmacy')));
			 $pharmConfig=unserialize($pharmacy_service_type['Configuration']['value']);*/

			$pharmConfig=$this->Configuration->getPharmacyServiceType();// to get pharmacy service type
			$this->set('pharmConfig',$pharmConfig);
			$website_service_type=$this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website'/*,'Configuration.location_id'=>$this->Session->read('locationid')*/)));
			$websiteConfig=unserialize($website_service_type['Configuration']['value']);
			if($websiteConfig['instance']=='kanpur'){
				$this->loadModel('PharmacySalesBill');
				$isReceivedByNurse=$this->PharmacySalesBill->find('first',array('fields'=>array('PharmacySalesBill.id','PharmacySalesBill.is_received'),
						'conditions'=>array('PharmacySalesBill.patient_id'=>$id)));
				if($isReceivedByNurse['PharmacySalesBill']['is_received']=='1' /* && strtolower($tariffStdData['Patient']['admission_type'])=='ipd' */){
					// url flag to show pharmacy charges -- Pooja
					if($this->params->query['showPhar']){
						$pharmConfig['addChargesInInvoice']='yes';
					}
					if($pharmConfig['addChargesInInvoice']=='yes'){
						$pharmacy_total =0;
						$pharmacy_cash_total = 0;
						$pharmacy_credit_total =0;
                                                
						if($patient_pharmacy_details){
							//$pharmacy_total = $this->PharmacySalesBill->getTotalAmount($patient_pharmacy_details);
							$pharmacy_cash_total = $this->PharmacySalesBill->getCashAmount($patient_pharmacy_details);
							$pharmacy_credit_total = $this->PharmacySalesBill->getCreditAmount($patient_pharmacy_details);
						}

						$pharmacy_total=$this->getPharmacyFinalCharges($id);// to get totalPharmacy - pharmacyReturn
						$this->set('pharmacyPaidAmount',$pharmacy_cash_total);
					}
				}
			}else{ 
				// url flag to show pharmacy charges -- Pooja
				if($this->params->query['showPhar']){
					$pharmConfig['addChargesInInvoice']='yes';
				}
				if($pharmConfig['addChargesInInvoice']=='yes'){
					$pharmacy_total =0;
					$pharmacy_cash_total = 0;
					$pharmacy_credit_total =0;
                                        
                                        //to get the charges of either original Pharmacy sale or duplicate pharmacy by Swapnil - 15.03.2016 
                                        $this->loadModel('PharmacySalesBill');
                                        $useDuplicateSales = $this->Patient->getFlagUseDuplicateSalesCharge($id); 
							/*$finalBillingData = $this->FinalBilling->find('first',array(
								'fields'=>array('use_duplicate_sales'),
								'conditions'=>array('patient_id'=>$id,''=>'1')));*/
                                        if($useDuplicateSales=='1'){
                                            $pharmacy_total= $this->getDuplicatePharmacyFinalCharges($id);//for total pharmacy charge
                                        }else{
                                            if($patient_pharmacy_details){
                                                //$pharmacy_total = $this->PharmacySalesBill->getTotalAmount($patient_pharmacy_details);
                                                $pharmacy_cash_total = $this->PharmacySalesBill->getCashAmount($patient_pharmacy_details);
                                                $pharmacy_credit_total = $this->PharmacySalesBill->getCreditAmount($patient_pharmacy_details);
                                            }
                                            $pharmacy_total=$this->getPharmacyFinalCharges($id);// to get totalPharmacy - pharmacyReturn
                                        } 
                                        /*
					if($patient_pharmacy_details){
						//$pharmacy_total = $this->PharmacySalesBill->getTotalAmount($patient_pharmacy_details);
						$pharmacy_cash_total = $this->PharmacySalesBill->getCashAmount($patient_pharmacy_details);
						$pharmacy_credit_total = $this->PharmacySalesBill->getCreditAmount($patient_pharmacy_details);
					}
                        
					$pharmacy_total=$this->getPharmacyFinalCharges($id);// to get totalPharmacy - pharmacyReturn*/
					$this->set('pharmacyPaidAmount',$pharmacy_cash_total);
				}
			}

		}else{
			$this->redirect(array("controller" => "billings", "action" => "patientSearch"));
		}
			
		$this->ConsultantBilling->bindModel(array(
				'belongsTo' => array( 	'TariffList' =>array('foreignKey'=>'consultant_service_id'),
						'DoctorProfile' =>array('foreignKey' => 'doctor_id'),
						'Consultant' =>array('foreignKey' => 'consultant_id'),
						'User' =>array('foreignKey' => false ,'conditions'=>array('DoctorProfile.user_id=User.id')),
						'ServiceCategory'=>array('foreignKey' => 'service_category_id'),
						'Initial' =>array('foreignKey'=>false,'conditions' => array('Initial.id=User.initial_id')),
				)),false);
			
			
		$tempConDData = $this->ConsultantBilling->find('all',array('fields'=>array('TariffList.*,ServiceCategory.*,ConsultantBilling.*,DoctorProfile.*','Initial.name'),
				'conditions'=>array('ConsultantBilling.consultant_id'=>NULL,'ConsultantBilling.patient_id'=>$id),'order'=>array('ConsultantBilling.date')));

		$this->ConsultantBilling->bindModel(array(
				'belongsTo' => array( 	'TariffList' =>array('foreignKey'=>'consultant_service_id'),
						'Consultant' =>array('foreignKey' => 'consultant_id'),
						'ServiceCategory'=>array('foreignKey' => 'service_category_id'),
						'Initial' =>array('foreignKey'=>false,'conditions' => array('Consultant.initial_id=Initial.id')),
				)),false);

		$tempConCData = $this->ConsultantBilling->find('all',array('fields'=>array('TariffList.*,ServiceCategory.*,ConsultantBilling.*,Consultant.*','Initial.name'),
				'conditions'=>array('ConsultantBilling.doctor_id'=>NULL,'ConsultantBilling.patient_id'=>$id),'order'=>array('ConsultantBilling.date')));
		 
		$cDArray=array();
		$cCArray=array();
		foreach($tempConDData as $tCD){
			$tCD['ConsultantBilling']['amount'] = $this->Number->format($tCD['ConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.',
					'before'=>false,'thousands'=>false));
			$cDArray[$tCD['ConsultantBilling']['consultant_service_id']][$tCD['ConsultantBilling']['doctor_id']][$tCD['ConsultantBilling']['amount']][]=$tCD;

		}
			
		foreach($tempConCData as $tCD){
			$tCD['ConsultantBilling']['amount'] = $this->Number->format($tCD['ConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.',
					'before'=>false,'thousands'=>false));
			$cCArray[$tCD['ConsultantBilling']['consultant_service_id']][$tCD['ConsultantBilling']['consultant_id']][$tCD['ConsultantBilling']['amount']][]=$tCD;

		}
		$this->set('cCArray',$cCArray);
		$this->set('cDArray',$cDArray);
			
		/*
		 $facilityData = $this->Facility->read('',$this->Session->read('facilityid'));
		$this->set('facilityData',$facilityData);*/
		$locationFooter = $this->General->billingFooter($this->Session->read('locationid'));
		$this->set('locationFooter',$locationFooter);
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment'),
						'TariffStandard' =>array('foreignKey'=>'tariff_standard_id'),
						'TariffList' =>array('foreignKey'=>'treatment_type'),
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )))
				,'hasOne'=>array('Diagnosis'=>array('foreignKey'=>'patient_id','fields'=>array('Diagnosis.final_diagnosis')))));

		
		$patient_details  = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$id)));
		$this->set('patientd',$patient_details);
		$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);	
		$formatted_address = $this->setAddressFormat($UIDpatient_details['Person']);
		
		$this->set(array('person'=>$UIDpatient_details,'photo' => $UIDpatient_details['Person']['photo'],'address'=>$formatted_address,
				'patient'=>$patient_details,'id'=>$id,'treating_consultant'=>$this->User->getDoctorByID($patient_details['Patient']['doctor_id'])));

		$creditTypeId = $patient_details['Patient']['credit_type_id'];
		if($creditTypeId == 1){
			$corporateId = $patient_details['Patient']['corporate_id'];
		}elseif($creditTypeId == 2){
			$corporateId = $patient_details['Patient']['insurance_company_id'];
		}else{
			$corporateId = 0;
		}
		//change by pankaj now corporate will come from only tariff standard`
		$corporateEmp = $patient_details['TariffStandard']['name'];
		/*if($creditTypeId == 1){
			$corporates = $this->Corporate->find('list',array('fields'=>array('id','name'),'conditions'=>array('Corporate.is_deleted'=>0)));
			$corporateEmp = $corporates[$corporateId];
		}else if($creditTypeId == 2){
			$corporates = $this->InsuranceCompany->find('list',array('fields'=>array('id','name'),'conditions'=>array('InsuranceCompany.is_deleted'=>0)));
			$corporateEmp = $corporates[$corporateId];
		}else{
			$corporateEmp ='Private';
		}*/
		$this->set('corporateEmp',$corporateEmp);
		$this->set('primaryConsultant',$this->User->getDoctorByID($patient_details['Patient']['doctor_id']));
		$advancePaidData = $this->Billing->find('all',array('conditions'=>array('patient_id'=>$id,'is_deleted'=>'0',
				'location_id'=>$this->Session->read('locationid'))));
		$totalAdvancePaid = 0;
		$pharmacyCategoryId=$this->ServiceCategory->getPharmacyId();//in case need of pharmacy category ID

		// url flag to show pharmacy charges -- Pooja
		if($this->params->query['showPhar']){
			$pharmConfig['addChargesInInvoice']='yes';
		}
		foreach($advancePaidData as $advancePaid){
			if($advancePaid['Billing']['payment_category']==$pharmacyCategoryId && $pharmConfig['addChargesInInvoice']=='yes'){
				$pharAdvance=$pharAdvance+$advancePaid['Billing']['amount'];//for getting only pharmacy paid amount-- Pooja
				$totalAdvancePaid = $totalAdvancePaid + $advancePaid['Billing']['amount'];
			}else if($advancePaid['Billing']['payment_category']!=$pharmacyCategoryId){
				$totalAdvancePaid = $totalAdvancePaid + $advancePaid['Billing']['amount'];
			}
		}
		
		/* Ot Pharmacy Sales Bill Total Credit Amount */
		$ot_pharmacy_patient = $this->OtPharmacySalesBill->getPatientDetails($id);
		//debug($ot_pharmacy_patient);exit; 
		if($ot_pharmacy_patient){	
			$ot_pharmacy_credit_total = $this->OtPharmacySalesBill->getCreditAmount($ot_pharmacy_patient); 
		}
		
		$OtPharmacyReturnData=$this->OtPharmacySalesReturn->getOtPharmacyReturnData($id);//ot pharmacy return data
		$return_amount = 0;
		foreach($OtPharmacyReturnData as $key=>$value){
			$return_amount = $return_amount+$value['OtPharmacySalesReturn']['total'];
		}
		$this->set('return_amount',$return_amount); 
		/* END of OT Pharmacy Credit Amount*/
		
		$totalAdvancePaid = $totalAdvancePaid+$pharmacy_cash_total;
		#$totalAdvancePaid = $totalAdvancePaid + $pharmacy_cash_total;
		
		$pharmacyReturnChargesInInvoice=$this->getPharmacyReturnCharges($id);
		$this->set('pharmacyReturnChargesInInvoice',$pharmacyReturnChargesInInvoice['0']['sumTotal']);
		$this->set('totalAdvancePaid',$totalAdvancePaid);
		$this->set('pharmacy_charges',$pharmacy_total[0]['total']);
		$this->set('pharmacy_cash_charges',$pharmacy_cash_total);
		$this->set('pharmacy_credit_charges',$pharmacy_credit_total);
		$this->set('pharmacyAdv',$pharAdvance);
		$this->set('otPharmacyToatalAmount',$ot_pharmacy_credit_total); 
			
		if($patient_details['Patient']['tariff_standard_id']!=''){
			$tariffStandardId=$patient_details['Patient']['tariff_standard_id'];
		}else{
			$tariffData=$this->TariffStandard->find('first',array('conditions'=>array('name'=>'Private')));
			$tariffStandardId=$tariffData['TariffStandard']['id'];
		}
		$hospitalType = $this->Session->read('hospitaltype');
		
		//paid return amount  --yashwant
		$paidReturnForPharmacy=$this->Billing->returnPaidAmount($id);
		$this->set('paidReturnForPharmacy',$paidReturnForPharmacy);
		
		/******************* Nursing Charges Starts *****************/
			
		$nursingServices = $this->getServiceCharges($id,$tariffStandardId);

		$totalNursingCharges = 0;
			
		foreach($nursingServices as $nursingService){
			$hospitalType = $this->Session->read('hospitaltype');
			if($hospitalType == 'NABH'){
				//$totalNursingCharges = $totalNursingCharges + $nursingService[0]['count(distinct(`ServiceBill`.`id`))']*$nursingService['TariffAmount']['nabh_charges'];
				$totalNursingCharges = $totalNursingCharges + $nursingService['ServiceBill']['no_of_times']*$nursingService['ServiceBill']['amount'];
			}else{
				//$totalNursingCharges = $totalNursingCharges + $nursingService[0]['count(distinct(`ServiceBill`.`id`))']*$nursingService['TariffAmount']['non_nabh_charges'];
				$totalNursingCharges = $totalNursingCharges + $nursingService['ServiceBill']['non_nabh_charges']*$nursingService['ServiceBill']['amount'];
			}
		}
		//debug($nursingServices);
		$this->set('nursingServices',$nursingServices);
			
		/********************* Nursing Charges Ends *******************/
			
		$this->loadModel('FinalBilling');
		
		$finalBillingData = $this->FinalBilling->find('first',array('conditions'=>array('FinalBilling.location_id'=>
				$this->Session->read('locationid'),'FinalBilling.patient_id'=>$id)));

			
		// fetch diagnosis from diagnosis table
		$this->loadModel('Diagnosis');
		$diagnosisData = $this->Diagnosis->find('first',array('conditions'=>array('Diagnosis.patient_id'=>$id)));
		$this->set('diagnosisData',$diagnosisData);
			
		if(isset($finalBillingData['FinalBilling']['bill_number']) && $finalBillingData['FinalBilling']['bill_number']!=''){
			$bNumber = $finalBillingData['FinalBilling']['bill_number'];
			$this->set('billNumber',$bNumber);
		}else{
			$bNumber = $this->generateBillNo($id);
			$this->set('billNumber',$bNumber);
		}
		$this->set('finalBillingData',$finalBillingData);
		$this->set('patientId',$id);
		$this->labRadRates($tariffStandardId,$id);//calling lab/radiology charges
		
// 		debug($this->labRadRates($tariffStandardId,$id));



		/********************* Ward Charges Starts ********************/
		$wardServicesDataNew = $this->getDay2DayCharges($id,$tariffStandardId,false);
		$wardServicesDataNew = $this->groupWardCharges($id,true);
		//unset($wardServicesDataNew['0']);
		//unset($wardServicesDataNew['1']['ICU Ward']['5']);
		//unset($wardServicesDataNew['2']['Triple Sharing Ward']['0']);
		//$arr = array_values($wardServicesDataNew['2']['Triple Sharing Ward']);
		//$wardServicesDataNew['2']['Triple Sharing Ward'] = $arr;
		//unset($wardServicesDataNew['1']);
		$this->set('wardServicesDataNew',$wardServicesDataNew);
			
		/********************* Ward Charges ends ********************/

		// Lab radiology advance payment deduction
			
		$labPaidAmount = $this->getLabPaidAmount($id);
		$radPaidAmount = $this->getRadPaidAmount($id);
		if($labPaidAmount !='')
			$this->set('labPaidAmount',$labPaidAmount);
		else $this->set('labPaidAmount',0);
		if($radPaidAmount)
			$this->set('radPaidAmount',$radPaidAmount);
		else $this->set('radPaidAmount',0);
		// Lab radiology advance payment deduction
			
			

		/***************************** Doctor, Nursing, Registration Charges Starts**************/
		if($this->Session->read('website.instance')!='vadodara') {
			$registrationCharges = $this->getRegistrationCharges($totalWardDays,$hospitalType,$tariffStandardId);
			$doctorCharges = $this->Billing->getDoctorCharges($totalWardDays,$hospitalType,$tariffStandardId,$patient_details['Patient']['admission_type'],$patient_details['Patient']['treatment_type']);
			$nursingCharges = $this->Billing->getNursingCharges($totalWardDays,$hospitalType,$tariffStandardId);
				
			$registrationChargesData = $this->getRegistrationChargesWithMOA($totalWardDays,$hospitalType,$tariffStandardId);
			$doctorChargesData = $this->getDoctorChargesWithMOA($totalWardDays,$hospitalType,$tariffStandardId,$patient_details['Patient']['admission_type'],$patient_details['Patient']['treatment_type']);
			$nursingChargesData = $this->getNursingChargesWithMOA($totalWardDays,$hospitalType,$tariffStandardId);
	
				
			$doctorRate = $this->getDoctorRate($totalWardDays,$hospitalType,$tariffStandardId,$patient_details['Patient']['admission_type'],$patient_details['Patient']['treatment_type']);
			$nursingRate = $this->getNursingRate($totalWardDays,$hospitalType,$tariffStandardId);
			$this->set('registrationChargesData',$registrationChargesData);
			$this->set('doctorChargesData',$doctorChargesData);
			$this->set('nursingChargesData',$nursingChargesData);
	
			$this->set('nursingRate',$nursingRate);
			$this->set('doctorRate',$doctorRate);
		}
		//below lines are commented by pankaj w as it has been added direct to serviceBill on registration
		//$this->set('registrationRate',$registrationCharges);
		/***************************** Doctor, Nursing, Registration Charges Starts**************/
			
		$this->set('wardServicesDataNew',$wardServicesDataNew);
		$this->set('totalNewWardCharges',$totalWardCharges);
		$this->set('mode',$mode);
			
		/**********************************New Changes Surgery ends *********************/
		//Surgeries listing starts
		$this->loadModel('OptAppointment');
		$this->OptAppointment->unbindModel(array(
				'belongsTo' => array('Initial','Patient','Location','Opt','OptTable','Surgery','SurgerySubcategory','Doctor','DoctorProfile'
							
				)));
		$this->OptAppointment->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array( 'foreignKey'=>'tariff_list_id' 	),
						'Surgery'=>array('foreignKey'=>'surgery_id'),
						'DoctorProfile'=>array('foreignKey'=>'doctor_id'))));
			
		$surgeriesData = $this->OptAppointment->find('all',array('conditions'=>array('OptAppointment.patient_id'=>$id,'OptAppointment.is_deleted'=>0,
				'OptAppointment.location_id'=>$this->Session->read('locationid'))));
		$this->set('surgeriesData',$surgeriesData);
		//Surgeries listing ends

		// Anesthesia Charges Starts
		$this->OptAppointment->unbindModel(array(
				'belongsTo' => array('Initial','Patient','Location','Opt','OptTable','Surgery','SurgerySubcategory','Doctor','DoctorProfile'
							
				)));
		$this->OptAppointment->bindModel(array(
				'belongsTo' => array(
						'Surgery' =>array(
								'foreignKey'=>'surgery_id'
						),
						'TariffAmount' =>array(
								'foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=Surgery.tariff_list_id')
						),
				)));
		$AnesthesiaDetails = 	$surgeriesData = $this->OptAppointment->find('all',array('fields'=>array('OptAppointment.procedure_complete','Surgery.anesthesia_charges,TariffAmount.*'),'conditions'=>array('OptAppointment.patient_id'=>$id,'OptAppointment.location_id'=>$this->Session->read('locationid'),'TariffAmount.tariff_standard_id'=>$tariffStandardId)));
		$this->set('anesthesiaDetails',$AnesthesiaDetails);
		// Anesthesia Charges Ends

		//for refunded amount
		$discountData =$this->FinalBilling->find('first',array('conditions'=>array('FinalBilling.patient_id'=>$id)));
		$this->set('discountData',$discountData);
		//EOF of refunded amount

		//for discounted and refund amount  --yashwant
		// url flag to show pharmacy charges -- Pooja
		if($this->params->query['showPhar']){
			$pharmConfig['addChargesInInvoice']='yes';
		}
		if($pharmConfig['addChargesInInvoice']=='no'){ 
			$totalDiscountGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.discount) AS sumDiscount','Billing.payment_category' ),
					'conditions'=>array('Billing.patient_id'=>$id,'Billing.is_deleted'=>'0','Billing.payment_category !='=>$pharmacyCategoryId)));
			$this->set('totalDiscountGiven',$totalDiscountGiven);
			
			$totalRefundGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.paid_to_patient) AS sumRefund','Billing.payment_category' ),
					'conditions'=>array('Billing.patient_id'=>$id,'Billing.is_deleted'=>'0','Billing.refund'=>'1','Billing.payment_category !='=>$pharmacyCategoryId)));
			$this->set('totalRefundGiven',$totalRefundGiven);
			
		}else{ 
			$totalDiscountGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.discount) AS sumDiscount','Billing.payment_category' ),
					'conditions'=>array('Billing.patient_id'=>$id,'Billing.is_deleted'=>'0')));
			$this->set('totalDiscountGiven',$totalDiscountGiven);
			
			$totalRefundGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.paid_to_patient) AS sumRefund','Billing.payment_category' ),
					'conditions'=>array('Billing.patient_id'=>$id,'Billing.is_deleted'=>'0','Billing.refund'=>'1')));
			$this->set('totalRefundGiven',$totalRefundGiven);
		}
		
		//***code for discount to be shown in invoice***//

		//EOF discounted amount

		//****for refund amount in invoice****/yashwant/
		/* if($pharmConfig['addChargesInInvoiceaddChargesInInvoiceaddChargesInInvoiceaddChargesInInvoice']=='no'){
			$totalRefundGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.paid_to_patient) AS sumRefund',
					'Billing.payment_category' ),'conditions'=>array('Billing.patient_id'=>$id,'Billing.is_deleted'=>'0','Billing.refund'=>'1','Billing.payment_category'=>$pharmacyCategoryId)));
			$this->set('totalRefundGiven',$totalRefundGiven);
		}else{
			$totalRefundGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.paid_to_patient) AS sumRefund',
				'Billing.payment_category' ),'conditions'=>array('Billing.patient_id'=>$id,'Billing.is_deleted'=>'0','Billing.refund'=>'1')));
			$this->set('totalRefundGiven',$totalRefundGiven);
		}  */
		 
		//***EOF yashwant****//

		/**for tariff**/
		$this->loadModel('TariffStandard');
		$tariffData =$this->TariffStandard->find('list',array('fields'=>array('id','name')));
		$this->set('tariffData',$tariffData);
		/**OF tariff***/
		/**
		 * private package information
		 * gaurav
		*/
		if($this->params->query['privatePackage'] != '')
			$this->set('privatePackageData',$this->General->getPackageNameAndCost($id));
	}

	//returns cost of lab/radiology tests
	//arguments:tariff_standard_id and patient_id

	public function labRadRates($tariffStandardId,$id){
		//BOF lab billing
		$this->loadModel('LaboratoryTestOrder');
		$this->loadModel('RadiologyTestOrder');
		$this->loadModel('ServiceCategory');

		$labGroup=$this->ServiceCategory->find('first',array('conditions'=>array('ServiceCategory.name'=>'Laboratory',
				'ServiceCategory.is_view'=>'1','ServiceCategory.location_id'=>$this->Session->read('locationid'))));
		$radGroup=$this->ServiceCategory->find('first',array('conditions'=>array('ServiceCategory.name'=>'Radiology',
				'ServiceCategory.is_view'=>'1','ServiceCategory.location_id'=>$this->Session->read('locationid'))));

		if($labGroup){
			//laboratory only
			$this->LaboratoryTestOrder->bindModel(array(
					'belongsTo' => array(
							'Laboratory'=>array('type'=>'inner','foreignKey'=>'laboratory_id'),
							'TariffList'=>array('foreignKey' => false,'conditions'=>array('TariffList.id=Laboratory.tariff_list_id' )),
							'Patient'=>array('foreignKey'=>'patient_id'),
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
							'TariffAmount'=>array('foreignKey' => false,'conditions'=>
									array('TariffAmount.tariff_list_id=Laboratory.tariff_list_id' ,'TariffAmount.tariff_standard_id'=>$tariffStandardId))
					)),false);

			/*$this->LaboratoryTestOrder->bindModel(array(
			 'hasOne' => array(
			 		'LaboratoryToken'=>array('foreignKey'=>'laboratory_test_order_id','conditions'=>array('(LaboratoryToken.ac_id !="" OR LaboratoryToken.sp_id !="" )')),
			 )),false);*/
			$laboratoryTestOrderData= $this->LaboratoryTestOrder->find('all',array(
					'fields'=> array('LaboratoryTestOrder.amount','LaboratoryTestOrder.discount','LaboratoryTestOrder.id','LaboratoryTestOrder.paid_amount',
							         'LaboratoryTestOrder.create_time', 'LaboratoryTestOrder.start_date','Laboratory.name','TariffAmount.nabh_charges,TariffAmount.non_nabh_charges','TariffAmount.unit_days','TariffList.cghs_code'),
					'conditions'=>array('LaboratoryTestOrder.patient_id'=>$id,'LaboratoryTestOrder.is_deleted'=>'0',
							'LaboratoryTestOrder.from_assessment'=>0/*,$this->params->query['privatePackage']*/),
					'group'=>array('LaboratoryTestOrder.id')));
			//EOF laboratory
		}
		if($radGroup){
			//BOF radiology
			$this->RadiologyTestOrder->bindModel(array(
					'belongsTo' => array(
							'Radiology'=>array('type'=>'inner','foreignKey'=>'radiology_id'),
							'TariffList'=>array('foreignKey' => false,'conditions'=>array('TariffList.id=Radiology.tariff_list_id' )),
							'ServiceSubCategory'=>array('foreignKey' => false,'conditions'=>array('ServiceSubCategory.id=TariffList.service_sub_category_id' )),
							'Patient'=>array('foreignKey'=>'patient_id'),
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
							'TariffAmount'=>array('foreignKey' => false,'conditions'=>
									array('TariffAmount.tariff_list_id=Radiology.tariff_list_id' ,
											'TariffAmount.tariff_standard_id'=>$tariffStandardId))
					)),false);

			$radiologyTestOrderData= $this->RadiologyTestOrder->find('all',array(
					'fields'=> array('RadiologyTestOrder.create_time','RadiologyTestOrder.discount','RadiologyTestOrder.amount','RadiologyTestOrder.id','RadiologyTestOrder.paid_amount',
							'Radiology.name,TariffAmount.nabh_charges,TariffAmount.non_nabh_charges','TariffAmount.unit_days','TariffList.cghs_code','ServiceSubCategory.id','ServiceSubCategory.name'),
					'conditions'=>array('RadiologyTestOrder.patient_id'=>$id,'RadiologyTestOrder.is_deleted'=>'0',
							'RadiologyTestOrder.from_assessment'=>0/*,$this->params->query['privatePackage']*/),
					'group'=>'RadiologyTestOrder.id'));
				// 	debug($radiologyTestOrderData);
			//EOF radiology
			/*
			foreach ($radiologyTestOrderData as $key=> $radiologySubData) {
				$returnSubCategoryArray[$radiologySubData['ServiceSubCategory']['name']][]=$radiologySubData;
			}*/
		}
		$this->set(array('labRate'=>$laboratoryTestOrderData,'radRate'=>$radiologyTestOrderData));
		return  array('labRate'=>$laboratoryTestOrderData,'radRate'=>$radiologyTestOrderData) ;
		//EOF lab billing
	}
	public function saveFinalBill($patientID=null){ //debug($this->request->data);exit;
		 $this->uses = array('FinalBilling','Patient','Bed','WardPatient','DischargeDetail','DiscountByCredit','VoucherEntry','Appointment','Configuration','Person','Message',
				'Account','AccountReceipt','VoucherLog','Billing');

		/*if(!empty($this->request->data['Billing']['disPerAmount'])){
			$this->request->data['Billing']['discount']=$this->request->data['Billing']['disPerAmount'];
		}*/
// 	$contactInfo = "18002330000";
//   $mobile = $this->Person->find('first', [
//     'fields' => ['Person.mobile'],
//     'conditions' => ['Person.id' => $patientID]  // Corrected "condiation" to "conditions"
// ]);
//         $mobilenumber = $this->Patient->find('first', [
//     'fields' => ['Patient.mobile_phone', 'Patient.lookup_name', 'Patient.discharge_date', 'Patient.id', 'Patient.person_id', 'Patient.dob'],
//     'conditions' => ['Patient.id' => $patientID]  // Corrected "condiation" to "conditions"
// ]);

//   $mobilenumber = $mobile['Person']['mobile'];
//     $lookupname = $mobilenumber['Patient']['lookup_name'];
//     $dischargedate = $mobilenumber['Patient']['discharge_date'];
//     debug($mobilenumber);

$patientData = $this->Patient->find('first', [
    'fields' => ['Patient.person_id', 'Patient.lookup_name', 'Patient.discharge_date', 'Patient.dob', 'Patient.id'],
    'conditions' => ['Patient.id' => $patientID] 
]);

$personID = $patientData['Patient']['person_id'];  

$mobileData = $this->Person->find('first', [
    'fields' => ['Person.mobile', 'Person.next_visite_date'],
    'conditions' => ['Person.id' => $personID]  
]);
$mobileNumber = isset($mobileData['Person']['mobile']) ? $mobileData['Person']['mobile'] : 'No mobile found';
$lookupName = isset($patientData['Patient']['lookup_name']) ? $patientData['Patient']['lookup_name'] : 'No lookup name found';
$nextVisiteDate = isset($mobileData['Person']['next_visite_date']) ? $mobileData['Person']['next_visite_date'] : 'No next visit date found';
$dischargeDate = isset($patientData['Patient']['discharge_date']) ? $patientData['Patient']['discharge_date'] : 'No discharge date found';
$dob = isset($patientData['Patient']['dob']) ? $patientData['Patient']['dob'] : 'No date of birth found';
$patientID = isset($patientData['Patient']['id']) ? $patientData['Patient']['id'] : 'No patient ID found';


// debug([
//     'Patient ID' => $patientID,
//     'Mobile Number' => $mobileNumber,
//     'Lookup Name' => $lookupName,
//     'Discharge Date' => $dischargeDate,
//      'fallow up date'=>$nextVisiteDate,
// ]);
// exit;

        
		$lastNotesId=$this->Billing->find('first',array('fields'=>array('id'),'order'=>array('Billing.id Desc')));
		$lastNotesId=$lastNotesId['Billing']['id'];
		$billNo=$this->generateBillNoPerPay($this->request->data['Billing']['patient_id'],$lastNotesId);
		$tariffStdData=$this->Patient->find('first',array('fields'=>array('Patient.person_id','Patient.tariff_standard_id','Patient.admission_type','Patient.lookup_name'),
				'conditions'=>array('Patient.id'=>$this->request->data['Billing']['patient_id'])));
			
		if(isset($this->request->data['payOnlyAmount']) && $this->request->data['payOnlyAmount']=='payOnlyAmount'){
			$billingdDate=!empty($this->request->data['Billing']['date'])?$this->request->data['Billing']['date']:date('d/m/Y H:i:s');
			$patientId=$billingData['Billing']['patient_id'] = !empty($this->request->data['Billing']['patient_id'])?$this->request->data['Billing']['patient_id']:$this->Session->read('hub.patientid');
			if(empty($patientId)){
				$patientId=$billingData['Billing']['patient_id']=$patientID;
			}
			$billingData['Billing']['amount']= $this->request->data['Billing']['amount'];
			$billingData['Billing']['bill_number']=$billNo;
			$billingData['Billing']['total_amount']= $this->request->data['Billing']['total_amount'];
			$billingData['Billing']['amount_pending']= $this->request->data['Billing']['amount_pending'];
			$billingData['Billing']['amount_paid']= $this->request->data['Billing']['amount_paid'];
			$billingData['Billing']['remark']= $this->request->data['Billing']['remark'];
			//$billingData['Billing']['reason_of_payment']= 'Advance';
			$billingData['Billing']['payment_category']= 'Finalbill';
			$billingData['Billing']['discount_type']= $this->request->data['Billing']['discount_type'];
			$billingData['Billing']['bank_deposite']= $this->request->data['Billing']['bank_deposite'];
			$billingData['Billing']['discount']=$this->request->data['Billing']['discount_rupees'];// $this->request->data['Billing']['discount'];
			$billingData['Billing']['mode_of_payment']= $this->request->data['Billing']['mode_of_payment'];
			$billingData['Billing']['date'] = date('Y-m-d H:i:s');
			$billingData['Billing']['bank_name'] = $this->request->data['Billing']['bank_name'];
			$billingData['Billing']['account_number'] = $this->request->data['Billing']['account_number'];
			$billingData['Billing']['check_credit_card_number'] = $this->request->data['Billing']['check_credit_card_number'];
			//$billingData['Billing']['neft_number'] = $this->request->data['Billing']['neft_number'];
			//$billingData['Billing']['neft_date'] = $this->DateFormat->formatDate2STD($this->request->data['Billing']['neft_date'],Configure::read('date_format'));
			//$billingData['Billing']['cheque_date'] = $this->DateFormat->formatDate2STD($this->request->data['Billing']['cheque_date'],Configure::read('date_format'));
			$billingData['Billing']['location_id'] = $this->Session->read('locationid');
			$billingData['Billing']['created_by'] = $this->Session->read('userid');
			$billingData['Billing']['create_time'] = date('Y-m-d H:i:s');
			$billingData['Billing']['date']=$this->DateFormat->formatDate2STD($billingdDate,Configure::read('date_format'));
			
			//$billingData['Billing']['paid_to_patient'] = $this->request->data['Billing']['paid_to_patient'];
			//$billingData['Billing']['refund'] = $this->request->data['Billing']['refund'];
			

			if(isset($billingData['Billing']['refund'])&& $billingData['Billing']['refund'] ==1){		//if refund
				$billingData['Billing']['paid_to_patient'] = $this->request->data['Billing']['paid_to_patient'];
				$billingData['Billing']['refund'] = $this->request->data['Billing']['refund'];
			}

		if($this->request->data['Billing']['mode_of_payment']=='Bank Deposite'){
				$billingData['Billing']['date'] = $this->DateFormat->formatDate2STD($billingdDate,Configure::read('date_format'));
				$billingData['Billing']['bank_deposite'] = $this->request->data['Billing']['bank_deposite'];
			}
			if($this->request->data['Billing']['mode_of_payment']=='Cheque' || $this->request->data['Billing']['mode_of_payment']=='Credit Card' || $this->request->data['Billing']['mode_of_payment']=='Debit Card'){
				$billingData['Billing']['date']=$billingData['Billing']['cheque_date'] = $this->DateFormat->formatDate2STD($this->request->data['Billing']['cheque_date'],Configure::read('date_format'));
				$billingData['Billing']['bank_name'] = $this->request->data['Billing']['bank_name'];
			}
				
			
			if($this->request->data['Billing']['mode_of_payment']=='NEFT'){
				$billingData['Billing']['date']=$billingData['Billing']['neft_date'] = $this->DateFormat->formatDate2STD($this->request->data['Billing']['neft_date'],Configure::read('date_format'));
				$billingData['Billing']['bank_name_neft'] = $this->request->data['Billing']['bank_name_neft'];
			}
			$billingData['Billing']['created_by'] = $this->Session->read('userid');
			$billingData['Billing']['create_time'] = date('Y-m-d H:i:s');
			if($billingData['Billing']['amount']!='')
				$this->Billing->save($billingData['Billing']);
			$finBillData = $this->FinalBilling->find('first',array('conditions'=>array('patient_id'=>$billingData['Billing']['patient_id'])));

			$newAmountPaid = $finBillData['FinalBilling']['amount_paid'] + $this->request->data['Billing']['amount'];
			$newAmountPending = $finBillData['FinalBilling']['amount_pending'] - $this->request->data['Billing']['amount'];

			$this->FinalBilling->id = $finBillData['FinalBilling']['id'];
			$creditPeriod = $this->request->data['Billing']['credit_period'];
			$this->FinalBilling->save(array('amount_paid'=>$newAmountPaid,
					'amount_pending'=>$newAmountPending,
					'credit_period'=>$creditPeriod

			));
			//add discahrge date for op patient


			//BOF credit voucher
			if(!empty($this->request->data['Billing']['discount_by_credit'])){
				$creditVoucher['discount_by_credit'] = $this->request->data['Billing']['discount_by_credit'] ;
				$creditVoucher['reason_for_credit_voucher'] = $this->request->data['Billing']['reason_for_credit_voucher'] ;
				$creditVoucher['date'] = date("Y-m-d H:i:s");
				$creditVoucher['patient_id'] = $billingData['Billing']['patient_id'] ;
				$creditVoucher['final_billing_id'] = $finBillData['FinalBilling']['id'] ;
				$this->DiscountByCredit->save($creditVoucher);
			}
			//EOF credit voucher
			
			//for accounting by amit jain
			if($tariffStdData['Patient']['admission_type']=='IPD'){
				//if($this->params->query['singleBillPay']){
				$this->Billing->deleteRevokeJV($patientId);
				//}
				$this->Billing->receiptVoucherCreate($billingData,$patientId);
				if($tariffStdData['Patient']['tariff_standard_id']==Configure::read('privateTariffId')){
					$this->Billing->jvMandatoryService($patientId);
					$this->Billing->finalDischargeJV($patientId,$this->params->query['singleBillPay']);
					$this->Billing->addFinalVoucherLogJV($billingData,$patientId);
				}
			}else{
				$this->Billing->addPartialPaymentJV($billingData,$patientId);
			}
			//EOF for accounting
			
			//initially redirect to generateSavedReceipt
			$this->redirect(array("controller" => "billings", "action" => "multiplePaymentModeIpd",$this->request->data['Billing']['patient_id']));
			//generateSavedReceipt
		}else{ //debug($this->request->data);exit;

			/*if($this->request->data['Billing']['mode_of_payment']=='NEFT'){
				if(empty($this->request->data['Billing']['bank_name']))$this->request->data['Billing']['bank_name']=$this->request->data['Billing']['bank_name_neft'];
				if(empty($this->request->data['Billing']['account_number']))$this->request->data['Billing']['account_number']=$this->request->data['Billing']['account_number_neft'];
				$this->request->data['Billing']['neft_date']=$this->DateFormat->formatDate2STD($this->request->data['Billing']['neft_date'],Configure::read('date_format'));
			}
			if(empty($this->request->data['Billing']['date']))$this->request->data['Billing']['date']=date("Y-m-d H:i:s");
			else $this->request->data['Billing']['date']=$this->DateFormat->formatDate2STD($this->request->data['Billing']['date'],Configure::read('date_format'));

			if($this->request->data['Billing']['mode_of_payment']=='Cheque' || $this->request->data['Billing']['mode_of_payment']=='Credit Card'){
				$this->request->data['Billing']['cheque_date']=$this->DateFormat->formatDate2STD($this->request->data['Billing']['cheque_date'],Configure::read('date_format'));
			}*/
			
		

			$this->request->data['Billing']['location_id']=$this->Session->read('locationid');
			$this->request->data['Billing']['created_by']=$this->Session->read('userid');
			$this->request->data['Billing']['create_time']=date("Y-m-d H:i:s");
			$this->request->data['Billing']['remark']=$this->request->data['Billing']['remark'];

			$this->request->data['Billing']['paid_to_patient']=$this->request->data['Billing']['paid_to_patient'];
			$this->request->data['Billing']['refund']=!empty($this->request->data['Billing']['refund'])?$this->request->data['Billing']['refund']:'0';

			$this->request->data['Billing']['discount_percent']=$this->request->data['Billing']['discount_percent'];
			$this->request->data['Billing']['discount_rupees']=$this->request->data['Billing']['discount_rupees'];
			$this->request->data['Billing']['reason_for_discount']=$this->request->data['Billing']['reason_for_discount'];
			$this->request->data['Billing']['amount_pending']=$this->request->data['Billing']['amount_pending']-$this->request->data['Billing']['amount'];
			$this->request->data['Billing']['amount_paid']=$this->request->data['Billing']['amount_paid']+$this->request->data['Billing']['amount'];
			
			if(empty($this->request->data['Billing']['date']))
				$billingData['Billing']['date']=date("Y-m-d H:i:s");
			else 
				$billingData['Billing']['date']=$this->request->data['Billing']['date'];
			
			if(empty($this->request->data['billings']['payOnlyAmount'])){//for pay only amount
				if(empty($this->request->data['Billing']['discharge_date'])){
					$this->request->data['Billing']['discharge_date']=date('d/m/Y H:i:s');
				}
			}

			$data = $this->FinalBilling->find('first',array('conditions'=>array('location_id'=>$this->Session->read('locationid'),'patient_id'=>$this->request->data['Billing']['patient_id'])));
			if(count($data)>0){
				$this->FinalBilling->id = $data['FinalBilling']['id'];
				if(empty($this->request->data['Billing']['reason_of_discharge']))
					if(!empty($data['FinalBilling']['reason_of_discharge']))
						$this->request->data['Billing']['reason_of_discharge']=$data['FinalBilling']['reason_of_discharge'];
			}
			// for credit period //
			if($this->request->data['Billing']['credit_period'] != "") {
				$this->request->data['Billing']['credit_period']=$this->request->data['Billing']['credit_period'];
				$billingData['Billing']['credit_period']=$this->request->data['Billing']['credit_period'];
			}
			$patientId=$billingData['Billing']['patient_id'] = !empty($this->request->data['Billing']['patient_id'])?$this->request->data['Billing']['patient_id']:$this->Session->read('hub.patientid');
			if(empty($patientId)){
				$patientId=$billingData['Billing']['patient_id']=$patientID;
			}
			$billingData['Billing']['amount']= $this->request->data['Billing']['amount'];
			$billingData['Billing']['bill_number']=$billNo;
			$billingData['Billing']['total_amount']= $this->request->data['Billing']['total_amount'];
			$billingData['Billing']['amount_pending']= $this->request->data['Billing']['amount_pending'];
			$billingData['Billing']['amount_paid']= $this->request->data['Billing']['amount_paid'];
			$billingData['Billing']['remark']= $this->request->data['Billing']['remark'];
			$billingData['Billing']['reason_of_payment']= 'Advance';
			$billingData['Billing']['payment_category']= 'Finalbill';
			$billingData['Billing']['discount_type']= $this->request->data['Billing']['discount_type'];
			$billingData['Billing']['bank_deposite']= $this->request->data['Billing']['bank_deposite'];
			$billingData['Billing']['discount']=$this->request->data['Billing']['discount_rupees'];// $this->request->data['Billing']['discount'];
			$billingData['Billing']['mode_of_payment']= $this->request->data['Billing']['mode_of_payment'];
			$billingData['Billing']['date'] = $this->DateFormat->formatDate2STD($this->request->data['Billing']['discharge_date'],Configure::read('date_format'));
			$billingData['Billing']['bank_name'] = $this->request->data['Billing']['bank_name'];
			$billingData['Billing']['account_number'] = $this->request->data['Billing']['account_number'];
			$billingData['Billing']['check_credit_card_number'] = $this->request->data['Billing']['check_credit_card_number'];
			$billingData['Billing']['location_id'] = $this->Session->read('locationid');
			$billingData['Billing']['created_by'] = $this->Session->read('userid');
			$billingData['Billing']['create_time'] = date('Y-m-d H:i:s');
			
			$billingData['Billing']['paid_to_patient'] = $this->request->data['Billing']['paid_to_patient'];
			$billingData['Billing']['refund'] = $this->request->data['Billing']['refund'];
			
			if($this->request->data['Billing']['mode_of_payment']=='Bank Deposite'){
				$billingData['Billing']['date'] = $this->DateFormat->formatDate2STD($this->request->data['Billing']['discharge_date'],Configure::read('date_format'));
				$billingData['Billing']['bank_deposite'] = $this->request->data['Billing']['bank_deposite'];
			}
			if($this->request->data['Billing']['mode_of_payment']=='Cheque' || $this->request->data['Billing']['mode_of_payment']=='Credit Card' || $this->request->data['Billing']['mode_of_payment']=='Debit Card'){
				$billingData['Billing']['cheque_date'] = $this->DateFormat->formatDate2STD($this->request->data['Billing']['cheque_date'],Configure::read('date_format'));
				$billingData['Billing']['bank_name'] = $this->request->data['Billing']['bank_name'];
			}
			
				
			if($this->request->data['Billing']['mode_of_payment']=='NEFT'){
				$billingData['Billing']['neft_date'] = $this->DateFormat->formatDate2STD($this->request->data['Billing']['neft_date'],Configure::read('date_format'));
				$billingData['Billing']['bank_name_neft'] = $this->request->data['Billing']['bank_name_neft'];
			}
			$this->FinalBilling->save($this->request->data['Billing']);
			//by amit jain no need to convert date.
			/* if(empty($this->request->data['Billing']['date']))$billingData['Billing']['date']=date("Y-m-d");
			 else $billingData['Billing']['date']=$this->DateFormat->formatDate2STD($this->request->data['Billing']['date'],Configure::read('date_format')); */

			

			


			//debug($billingData);
			//if($billingData['Billing']['amount']!='' || $billingData['Billing']['refund']==1)	//if refund
			/*$BDate=explode(' ',$billingData['Billing']['date']);
			$BDate=$BDate[0].' '.date('H:i:s');*/
			if($this->Billing->save($billingData['Billing']))
			{
				$billId=$this->Billing->getLastInsertID();
				
				
				//debug($billingData);exit;
				//SET STATUS CLOSED FOR DISOCUNT OR REFUND WHILE FINAL PAYMENT -- BY SWAPNIL
				$this->loadModel("DiscountRequest");
				$discData = $this->DiscountRequest->find('first',array('conditions'=>array('DiscountRequest.patient_id'=>$this->request->data['Billing']['patient_id'],
								'DiscountRequest.payment_category'=>"Finalbill",'DiscountRequest.closed'=>0)));

				$this->DiscountRequest->id = $discData['DiscountRequest']['id'];
				$this->DiscountRequest->saveField('closed','1');
			}
			//debug($this->request->data['billings']);
			//debug($this->request->data['Billing']);

			if(empty($this->request->data['billings']['payOnlyAmount'])){//for pay only amount and do not discharge
				/***BOF-Mahalaxmi-For SMS Sending*******/
				$this->loadModel('Configuration');
				$smsActiveFullPay=$this->Configuration->getConfigSmsValue('Full Bill');	 		
		
				if($smsActiveFullPay){
					$this->Person->bindModel(array(
							'belongsTo' => array(
									'Patient' =>array('foreignKey' => false,'conditions'=>array('Patient.person_id=Person.id')),
									'OptAppointment' =>array('foreignKey' => false,'conditions'=>array('OptAppointment.patient_id=Patient.id')),
									'Surgery' =>array('foreignKey' => false,'conditions'=>array('OptAppointment.surgery_id=Surgery.id')),
									/*'Consultant' =>array('foreignKey' => false,'conditions'=>array('Consultant.id=Patient.consultant_id')),*/
									'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
							)));
		
					$personDataId = $this->Person->Find('first',array('fields'=>array('Patient.sex','TariffStandard.name','Surgery.name','Person.mobile'/*,'Consultant.mobile','Consultant.first_name','Consultant.last_name'*/,'Patient.corporate_sublocation_id'),'conditions'=>array('Person.id'=>$tariffStdData['Patient']['person_id'])));
						
					$getSexPatient=strtoUpper(substr($personDataId['Patient']['sex'],0,1));
					$getAgeResultSms=$this->General->convertYearsMonthsToDaysSeparate($tariffStdData['Patient']['age']);
		
					if($tariffStdData['Patient']['tariff_standard_id']==Configure::read('privateTariffId')){
						if($totalPayAmt>0){
							$getFinalSmsBal=$totalPayAmt+$totalBalAmt;
							if(empty($getFinalSmsBal) || $getFinalSmsBal=='0'){
								$showMsgPatient= sprintf(Configure::read('full_payment_msg_withoutBal'),$totalPayAmt,Configure::read('hosp_details'));
							}else{
								$showMsgPatient= sprintf(Configure::read('full_payment_msg'),$totalPayAmt,$getFinalSmsBal,Configure::read('hosp_details'));
							}
		
							$dataSmsReturn=$this->Message->sendToSms($showMsgPatient,$personDataId['Person']['mobile']);  //for send to patient
						}
					}
				}//EOF if $smsActiveFullPay
				$smsActiveDischarge=$this->Configuration->getConfigSmsValue('Discharge Patient');	
			
				if($smsActiveDischarge){
					$personDataId['Surgery']['name'] = str_replace ('&','and', $personDataId['Surgery']['name']);
					if(empty($personDataId['Surgery']['name'])){
						$showMsgOwnerFinalBill= sprintf(Configure::read('owner_final_bill_withoutSurgery'),$personDataId['TariffStandard']['name'],$tariffStdData['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms);
							
					}else{
						$showMsgOwnerFinalBill= sprintf(Configure::read('owner_final_bill_withSurgery'),$personDataId['TariffStandard']['name'],$tariffStdData['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms,$personDataId['Surgery']['name']);
					}
		
		
					$this->Message->sendToSms($showMsgOwnerFinalBill,Configure::read('owner_no')); //for discharged send Owner to patient discharged
						
					//$this->Patient->sendToSmsPatient($personDataId['Patient']['person_id'],'PayPaid');
					//$this->Patient->sendToSmsPatient($personDataId['Patient']['person_id'],'OwnerFinalBill');
					$this->loadModel('TariffStandard');
					$this->TariffStandard->bindModel(array(
							'belongsTo'=>array(
									'CorporateSublocation'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array("CorporateSublocation.tariff_standard_id=TariffStandard.id"))
							)));
						
					$dataConsultantSms=$this->TariffStandard->find('first',array('fields'=>array('CorporateSublocation.mobile','CorporateSublocation.dr_name'),'conditions'=>array('CorporateSublocation.id'=>$personDataId['Patient']['corporate_sublocation_id'],'TariffStandard.name'=>array(Configure::read('WCL'),Configure::read('CGHS')))));
					$getDoctorRefferalName = unserialize($dataConsultantSms['CorporateSublocation']['dr_name']);
					$getRefferalDocMobileNo = unserialize($dataConsultantSms['CorporateSublocation']['mobile']);
					if(!empty($dataConsultantSms)){
						if($this->request->data['Billing']['reason_of_discharge']=="Death"){								
							foreach($getDoctorRefferalName as $keyRef=>$getDoctorRefferalNames){		
								$showMsgDischargeDeath= sprintf(Configure::read('DischargeDeathReferringDoc'),$personDataId['TariffStandard']['name'],$tariffStdData['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms,Configure::read('hosp_details')); 	/******After patient discharged to  get sms alert for Reffering Doc  ***/		
								$getSmsExeResult=$this->Message->sendToSms($showMsgDischargeDeath,$getRefferalDocMobileNo[$keyRef]); //for discharged send
								//$getResultexp=explode('-', $getSmsExeResult);
								//$getResultexp1 = substr($getResultexp['0'], 2);  // returns "cde"		
								if(trim($getSmsExeResult)==Configure::read('sms_confirmation')){	
									$showMsgDischargeDeathReturntoAdmin= sprintf(Configure::read('DischargeDeathReferringDocReturn'),$getDoctorRefferalNames,$personDataId['TariffStandard']['name'],$tariffStdData['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms); 	/******After patient discharged to  get sms alert for Reffering Doc  ***/		
									$this->Message->sendToSms($showMsgDischargeDeathReturntoAdmin,Configure::read('administrator_no')); //for discharged send
									$this->Message->sendToSms($showMsgDischargeDeathReturntoAdmin,Configure::read('owner_no')); //for discharged send to owner return sms
								}	
								/*$this->Patient->sendToSmsPhysician($personDataId['Patient']['person_id'],'DischargeDeathReferringDoc');
									$this->Patient->sendToSmsPhysician($personDataId['Patient']['person_id'],'DischargeDeathReferringDocAdminReturn');
								$this->Patient->sendToSmsPhysician($personDataId['Patient']['person_id'],'DischargeDeathReferringDocOwnerReturn');*/
							}
						}else{
							foreach($getDoctorRefferalName as $keyRef=>$getDoctorRefferalNames){
								if($getSexPatient=='F'){
									$showMsgDischargeOtherReason= sprintf(Configure::read('DischargeOtherReasonReferringDocFemale'),$personDataId['TariffStandard']['name'],$tariffStdData['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms,Configure::read('hosp_details')); 
								}else{
									$showMsgDischargeOtherReason= sprintf(Configure::read('DischargeOtherReasonReferringDoc'),$personDataId['TariffStandard']['name'],$tariffStdData['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms,Configure::read('hosp_details')); 
								}		
								/******After patient discharged to  get sms alert for Reffering Doc  ***/		
								$getSmsExeResult=$this->Message->sendToSms($showMsgDischargeOtherReason,$getRefferalDocMobileNo[$keyRef]); //for discharged send									
								//$getResultexp=explode('-', $getSmsExeResult);
								//$getResultexp1 = substr($getResultexp['0'], 2);  // returns "cde"								
									
								if(trim($getSmsExeResult)==Configure::read('sms_confirmation')){	
									if($getSexPatient=='F'){	
										$showMsgDischargeOtherReturntoAdmin= sprintf(Configure::read('DischargeOtherReasonReferringDocReturnFemale'),$getDoctorRefferalNames,$personDataId['TariffStandard']['name'],$tariffStdData['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms); 	/******After patient discharged to  get sms alert for Reffering Doc  ***/
									}else{
										$showMsgDischargeOtherReturntoAdmin= sprintf(Configure::read('DischargeOtherReasonReferringDocReturn'),$getDoctorRefferalNames,$personDataId['TariffStandard']['name'],$tariffStdData['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms); 
									}
									$dataSmsre1=$this->Message->sendToSms($showMsgDischargeOtherReturntoAdmin,Configure::read('administrator_no')); //for discharged send										
									$dataSmsre2=$this->Message->sendToSms($showMsgDischargeOtherReturntoAdmin,Configure::read('owner_no')); //for discharged send to owner return sms
								}
									
								/*$this->Patient->sendToSmsPhysician($personDataId['Patient']['person_id'],'DischargeOtherReasonReferringDoc');
									$this->Patient->sendToSmsPhysician($personDataId['Patient']['person_id'],'DischargeOtherReasonReferringDocAdminReturn');
								$this->Patient->sendToSmsPhysician($personDataId['Patient']['person_id'],'DischargeOtherReasonReferringDocOwnerReturn');*/
							}//EOF $getDoctorRefferalName
						}//EOF else
					}//EOF if $dataConsultantSms
				}//EOF-if $smsActiveDischarge

			/***EOF-Mahalaxmi-For SMS Sending*******/
							
				if($this->request->data['Billing']['reason_of_discharge']!=''){
						//BOF backdated discharge recovery
					//$this->removeBackDateEntries($this->request->data); //temp commented by pankaj as we dont y we deleted entries from DB after discharge .
					//EOF back dated discharge recovery

					$patientId=$this->Patient->id = !empty($this->request->data['Billing']['patient_id'])?$this->request->data['Billing']['patient_id']:$this->Session->read('hub.patientid');
					if(empty($patientId)){
						$patientId=$this->Patient->id=$patientID;
					}
					
					$this->Patient->save(array('is_discharge'=>1,
							'discharge_status'=>$this->request->data['Patient']['discharge_status'],
							'discharge_date'=>$this->DateFormat->formatDate2STD($this->request->data['Billing']['discharge_date'],Configure::read('date_format'))));//Save Details in Patient
					$bData = $this->Bed->find('first',array('conditions'=>array('patient_id'=>$this->request->data['Billing']['patient_id'],'location_id'=>$this->Session->read('locationid'))));

					$bedData=array();
					$bedData['Bed']['id'] = $bData['Bed']['id'];
					$bedData['Bed']['patient_id'] = 0;
					$bedData['Bed']['is_released'] = 1;
					$bedData['Bed']['released_date'] = '';
					$bedData['Bed']['modify_time'] = date('Y-m-d H:i:s');
					$bedData['Bed']['modified_by'] = $this->Session->read('userid');

					$this->Bed->save($bedData);
					//update already existed record which has the empty outdate
					$lastPatient = $this->WardPatient->find('first',array('fields'=>array('WardPatient.id','WardPatient.ward_id'),
							'conditions'=>array('out_date'=>'','patient_id'=>$this->request->data['Billing']['patient_id']),'order'=>'id Desc'));
					//EOF updating wardPatient outdate
					$this->WardPatient->updateAll(array('out_date'=>"'".$this->DateFormat->formatDate2STD($this->request->data['Billing']['discharge_date'],Configure::read('date_format'))."'",'is_discharge'=>1),
							array('id'=>$lastPatient['WardPatient']['id']));

					//Call to save ditails in Discharge details table.
					if(!empty($this->request->data['Billing']['patient_id']) AND $bedData['Bed']['id'] != ''){
						$dischargeDetails['patient_id'] = $this->request->data['Billing']['patient_id'];
						$dischargeDetails['location_id'] = $this->Session->read('locationid');
						$dischargeDetails['bed_id'] =  $bedData['Bed']['id'];
						$dischargeDetails['ward_id'] =  $lastPatient['WardPatient']['ward_id'];
						$dischargeDetails['discharge_starts_on'] = $this->DateFormat->formatDate2STD($this->request->data['Billing']['discharge_date'],Configure::read('date_format'));
						$dischargeDetails['create_time'] = date('Y-m-d H:i:s');
						$this->DischargeDetail->save($dischargeDetails);
					}

				}elseif(!isset($this->request->data['Billing']['reason_of_discharge']) && !empty($this->request->data['Billing']['discharge_date'])){ //BOF pankaj for OPD discharge
			}
			$this->Session->setFlash(__('Payment added successfully', true));
			
			if ($this->Billing->save($billingData['Billing'])) {
    $billId = $this->Billing->getLastInsertID();
// $mobile= 7387737062;
    // debug($mobile);exit;
    
//     $whatsAppResponse = $this->sendWhatsAppMessageTemplateHope($mobile, $lookupName, $dischargeDate, );

//  $mobile = $mobilenumber['Patient']['mobile_phone'];
//     $lookupname = $mobilenumber['Patient']['lookup_name'];
//     $dischargedate = $mobilenumber['Patient']['discharge_date'];
// debug([
//     'Patient ID' => $patientID,
//     'Mobile Number' => $mobileNumber,
//     'Lookup Name' => $lookupName,
//     'Discharge Date' => $dischargeDate,
//     'Date of Birth' => $dob
// ]);
    //  debug($dischargeDate);exit;

     $whatsAppResponse = $this->sendWhatsAppMessageTemplateHope($nextVisiteDate,$mobileNumber,$lookupName,$dischargeDate);
 
   
    $this->Session->setFlash(__('Payment added successfully', true));


}

			
			//if  "patient card" update account->card balance, and entry in patient card-- For vadodara instance -- Pooja
			if($this->Session->read('website.instance')!='kanpur'){
				$this->loadModel('Account');
				$this->loadModel('PatientCard');
				if($this->request->data['Billing']['is_card']=='1' && !empty($this->request->data['Billing']['patient_card'])){
					$personId=$this->Patient->find('first',array('fields'=>array('Patient.person_id'),
							'conditions'=>array('Patient.id'=>$this->request->data['Billing']['patient_id'])));
					$accId=$this->Account->find('first',array('fields'=>array('Account.id','Account.card_balance'),
							'conditions'=>array('Account.system_user_id'=>$personId['Patient']['person_id'],'Account.user_type'=>'Patient')));
					$cardBalance=$accId['Account']['card_balance']-$this->request->data['Billing']['patient_card'];
					$this->Account->updateAll(array('Account.card_balance'=>$cardBalance),array('Account.id'=>$accId['Account']['id']));
					$patientCard['person_id']=$personId['Patient']['person_id'];
					$patientCard['account_id']=$accId['Account']['id'];
					$patientCard['amount']=$this->request->data['Billing']['patient_card'];
					$patientCard['type']='Payment';
					$patientCard['billing_id']=$billId;
					$patientCard['bank_id']=$this->Account->getAccountIdOnly(Configure::read('PatientCardLabel'));
					$patientCard['mode_type']='Patient Card';
					$patientCard['created_by']=$this->Session->read('userid');
					$patientCard['create_time']=date('Y-m-d H:i:s');
					$this->PatientCard->save($patientCard);
			
				}
			}
			//EOF patient card update --Pooja
			//for accounting by amit jain			
			if($tariffStdData['Patient']['admission_type']=='IPD'){
				//if($this->params->query['singleBillPay']){
					$this->Billing->deleteRevokeJV($patientId);
				//}
				$this->Billing->receiptVoucherCreate($billingData,$patientId);
				if($tariffStdData['Patient']['tariff_standard_id']==Configure::read('privateTariffId')){
					$this->Billing->jvMandatoryService($patientId);
					$this->Billing->finalDischargeJV($patientId,$this->params->query['singleBillPay']);
					$this->Billing->addFinalVoucherLogJV($billingData,$patientId);
				}
			}else{
				$this->Billing->addPartialPaymentJV($billingData,$patientId);
			}
			if (!empty($patientID)) {
				// $this->sendWhatsAppMessageForPatient($patientID);
			}
			$this->redirect(array("controller" => "billings", "action" => "multiplePaymentModeIpd",$this->request->data['Billing']['patient_id']));
			//}
		}
		
		
	}
	}
	
// 	function write by dinesh tawade 

	
	
private function sendWhatsAppMessageTemplateHope($nextVisiteDate,$mobileNumber,$lookupName,$dischargeDate) {
    // debug($mobileNumber);
    //  debug($dischargeDate);
    //   debug($lookupName);
    //   exit;
      
      
      
      
    $apiUrl = "https://public.doubletick.io/whatsapp/message/template";
    $apiKey = "key_8sc9MP6JpQ"; 
    $contactInfo="18002330000";
    $fallowDate = $nextVisiteDate;
    $name = $lookupName;
    $mobile = $mobileNumber;
    $dischargeDate = date("Y-m-d H:i:s"); 
    

    // Prepare the payload with required fields
    $payload = [
        "messages" => [
            [
                "to" => "+91" . $mobile,
                "content" => [
                    "templateName" => "hope_after_patient_discharge",
                    "language" => "en",
                    "templateData" => [
                        "body" => [
                            "placeholders" => [$name,$dischargeDate,$fallowDate,$contactInfo]
                        ]
                    ]
                ]
            ]
        ]
    ];
    // debug($payload);
    // exit;

    // Initialize cURL
    $ch = curl_init();

    // cURL configuration
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Accept: application/json",
        "Content-Type: application/json",
        "Authorization: $apiKey"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    // Execute cURL and capture response
    $response = curl_exec($ch);
    $curlError = curl_error($ch);

    // Close cURL
    curl_close($ch);

    // Check for cURL errors
    if ($curlError) {
        $this->log("WhatsApp message cURL error: $curlError", 'error');
        return "Error: Unable to send WhatsApp message due to cURL error.";
    }

    // Decode response
    $responseData = json_decode($response, true);
// debug($responseData);exit;
    // Handle API response
    if (isset($responseData['status']) && $responseData['status'] == 'success') {
        $this->log("WhatsApp message sent successfully to $phone with response: $response", 'info');
        return "Message sent successfully!";
    } else {
        $errorMessage = isset($responseData['message']) ? $responseData['message'] : "Unknown error occurred.";
        $this->log("WhatsApp message failed for $phone. API Response: $response", 'error');
        return "Error: " . $errorMessage;
    }
}

	
	
	
	
	
	
	
	
	function saveGenerateReceipt(){
		$this->uses = array('Diagnosis','FinalBillingOption','FinalBilling');
		$totalCost=0;//$stack=array();

		if(isset($this->request->data) && !empty($this->request->data)){

			foreach($this->request->data['Billing'] as $data){
				if(is_array($data)){

					$data['patient_id']=$this->request->data['Billing']['patient_id'];
					$data['location_id']=$this->Session->read('locationid');
					
					//if(isset($data['rate']) && $data['rate'] !=''){

					if($data['rate']!='' && $data['unit']!=''){
						$totalCost = $totalCost + ($data['rate']*$data['unit']);
					}
					//}
					if($data['rate']!='' && $data['unit']!='' && is_numeric($data['amount'])){
						if($data['unit'] == '--'){
							$data['unit']=1;
						}
						$data['amount']=$data['unit']*$data['rate'];
					}


					
					if(isset($data['hasChild'])){
						foreach($data['hasChild'] as $child){
							$child['patient_id']=$this->request->data['Billing']['patient_id'];
							$child['location_id']=$this->Session->read('locationid');
						//	$child['settlement_billing_id']=$this->SettlementBilling->id;
							//$this->SettlementBillingOption->id='';
							if($child['unit']=='--'){
								$child['unit']=1;
							}
							$child['amount']=$child['unit']*$child['rate'];
							

							//if(isset($child['rate']) && $child['rate'] !=''){
							$totalCost = $totalCost + ($child['rate']*$child['unit']);
							//}

						}
					}
				}
			}

			$diagnosisData = $this->Diagnosis->find('first',array('conditions'=>array('Diagnosis.patient_id'=>$this->request->data['Billing']['patient_id'])));
			if(!empty($diagnosisData)){
				$this->Diagnosis->id = $diagnosisData['Diagnosis']['id'];
			}
			$dData['Diagnosis']['final_diagnosis'] = $this->request->data['Billing']['final_diagnosis'];
			$dData['Diagnosis']['patient_id'] = $this->request->data['Billing']['patient_id'];
			$this->Diagnosis->save($dData);
		}
			

			
		#$this->request->data['Billing']['discharge_date'] = $this->DateFormat->formatDate2STD($this->request->data['Billing']['discharge_date'],Configure::read('date_format'));
		$data = $this->FinalBilling->find('first',array('conditions'=>array('location_id'=>$this->Session->read('locationid'),'patient_id'=>$this->request->data['Billing']['patient_id'])));
		if(count($data)>0){
			$this->FinalBilling->id = $data['FinalBilling']['id'];
		}
		$this->request->data['Billing']['location_id']=$this->Session->read('locationid');
		$this->request->data['Billing']['date']=date('Y-m-d');
		$this->request->data['Billing']['total_amount']=$this->request->data['Billing']['total_amount'];//$totalCost;
			
		$this->request->data['Billing']['amount_pending']=$this->request->data['Billing']['total_amount']-$this->request->data['Billing']['amount_paid'];

		$this->FinalBilling->save($this->request->data['Billing']);
		
		$this->Session->setFlash(__('Record added sucessfully' ),'default',array('class'=>'message'));
		$this->redirect(array("controller" => "billings", "action" => "generateReceipt",$this->request->data['Billing']['patient_id'],'direct'));

	}

	public function generateBillNo($id = null){
		//$this->uses=array('FinalBilling');
		$this->loadModel('FinalBilling');
		$monthArray = array('A','B','C','D','E','F','G','H','I','J','K','L');
		$count = $this->FinalBilling->find('count',array('conditions'=>array('location_id'=>$this->Session->read('locationid'),'date'=>date('Y-m-d'))));
			
		$billNo = 'BL'.date('y').'-'.$monthArray[(date('n')-1)].date('d').'/PT'.$id.'/'.($count+1); // .'/PT'.$id  --by yashwant
		return $billNo;
	}

	function printReceipt($id,$mode=''){
	$website=$this->Session->read('website.instance');
		if($website == 'kanpur')
		{
			$this->layout = 'print_with_header';
			
		}else
		 {
		    $this->layout = 'advance_ajax';
		    $this->patient_info($id);
		}
		
		$this->generateReceipt($id); //calling main function (Removed code can be found in svn backup)
	}
		function printReceiptReduce($id,$mode=''){
	$website=$this->Session->read('website.instance');
		if($website == 'kanpur')
		{
			$this->layout = 'print_with_header';
			
		}else
		 {
		    $this->layout = 'advance_ajax';
		    $this->patient_info($id);
		}
		
		$this->generateReceiptReduce($id); //calling main function (Removed code can be found in svn backup)
	}
	
	/**
	 * function to print provisional Bill with head wise services
	 * @author Gaurav Chauriya
	 */
	public function provisionalInvoice($patientId){
		$this->uses = array('Patient','FinalBilling','Diagnosis','TariffStandard','ServiceCategory','User','OptAppointment','ServiceBill','LaboratoryTestOrder','ConsultantBilling',
				'RadiologyTestOrder','WardPatientService');
		$website=$this->Session->read('website.instance');
		if($website == 'kanpur'){
			$this->layout = 'print_with_header';
		}else{
			$this->layout = false;
		}
		/** BOF Bill Header */
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'TariffStandard' =>array('foreignKey'=>'tariff_standard_id'),
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )))
				,'hasOne'=>array('Diagnosis'=>array('foreignKey'=>'patient_id','fields'=>array('Diagnosis.final_diagnosis')))));
		
		$patient = $this->Patient->find('first',array('fields'=>array('Patient.id','Patient.admission_type','Patient.lookup_name','Patient.vip_chk','PatientInitial.name',
				'Patient.date_of_referral','Patient.is_discharge','Patient.form_received_on','Patient.admission_id','Patient.tariff_standard_id','Patient.doctor_id','Patient.payment_category',
				'Patient.is_packaged','Patient.is_discharge',/*'Person.relation_to_employee',*/'Person.age','Person.sex',/*'Person.insurance_number','Person.executive_emp_id_no',
				'Person.non_executive_emp_id_no',*/'TariffStandard.name'),
				'conditions'=>array('Patient.id'=>$patientId)));
		$this->set('patient',$patient);
		$finalBillingData = $this->FinalBilling->find('first',array('conditions'=>array('FinalBilling.location_id'=>
				$this->Session->read('locationid'),'FinalBilling.patient_id'=>$patientId)));
		if(isset($finalBillingData['FinalBilling']['bill_number']) && $finalBillingData['FinalBilling']['bill_number']!=''){
			$bNumber = $finalBillingData['FinalBilling']['bill_number'];
			$this->set('billNumber',$bNumber);
		}else{
			$bNumber = $this->generateBillNo($patientId);
			$this->set('billNumber',$bNumber);
		}
		$this->set('finalBillingData',$finalBillingData);
		$this->set('diagnosisData',$this->Diagnosis->find('first',array('conditions'=>array('Diagnosis.patient_id'=>$patientId))));
		$this->set('tariffData',$this->TariffStandard->find('list',array('fields'=>array('id','name'))));
		$this->set('primaryConsultant',$this->User->getDoctorByID($patient['Patient']['doctor_id']));
		/** EOF BIll Header */
		/** BOF Surgery listing [ONLY NAMES] */
		$this->OptAppointment->unbindModel(array(
				'belongsTo' => array('Initial','Patient','Location','Opt','OptTable','Surgery','SurgerySubcategory','Doctor','DoctorProfile'
				)));
		$this->OptAppointment->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array( 'foreignKey'=>'tariff_list_id' ))));
		$this->set('surgeriesData',$this->OptAppointment->find('all',array('fields'=>array('TariffList.name'),
				'conditions'=>array('OptAppointment.patient_id'=>$patientId,'OptAppointment.is_deleted'=>0,'OptAppointment.location_id'=>$this->Session->read('locationid')))));
		/** EOF surgery Listing */
		$finalBillArray = array();
		$finalRefundAndDiscount = array();
		$isPackaged = $patient['Patient']['is_packaged'] != 0 ? true : false;
		/** BOF Billing Services */
		$serviceDetails = $this->getServicesChargeForInvoice($patientId , array() , $isPackaged);
		
		/** EOF Billing Services */
		/** BOF Consultant Bill */
		$serviceDetails = $this->getConsultantServiceChargesForInvoice($patientId , $serviceDetails , $isPackaged);
		/** EOF Consultant Bill */
		/** BOF Room tariff */
		$serviceDetails = $this->getWardServiceChargesForInvoice($patientId , $serviceDetails , $isPackaged);
		/** EOF Room*/
		/** BOF Surgery Bills*/
		$serviceDetails = $this->getSurgeryChargesForInvoice($patientId , $serviceDetails , $isPackaged);
		/** EOF Surgery Bills*/
		/** BOF Lab */
		$serviceDetails = $this->getLaboratoryServiceChargesForInvoice($patientId , $serviceDetails , $isPackaged);
		/** EOF Lab*/
		/** BOF Rad*/
		$serviceDetails = $this->getRadiologyServiceChargesForInvoice($patientId , $serviceDetails , $isPackaged);
		/** EOF Rad */

                /** BOF Advance Paid*/
                $advance = $this->Billing->find('first',array('fields'=>array('Sum(amount) as TotalPaid'),'conditions'=>array('Billing.patient_id'=>$patientId,
                    'Billing.location_id'=>$this->Session->read('locationid')/*,'Billing.payment_category'=>'advance'*/,'Billing.is_deleted'=>0)));
                $serviceDetails[1]['TotalPaid'] = $advance[0]['TotalPaid'];
                //    $serviceDetails[1]['TotalPaid'] = $serviceDetails[1]['TotalPaid'] + (int) $advance[0]['AdvancePaid'];
		/** EOF Advance Paid */
                $pharmacyCategoryId=$this->ServiceCategory->getPharmacyId();
                if($patient['Patient']['is_packaged']=='1'){
                	$totalDiscountGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.discount) AS sumDiscount','Billing.payment_category' ),
                			'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0')));
                	$this->set('totalDiscountGiven',$totalDiscountGiven);
                
                	$totalRefundGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.paid_to_patient) AS sumRefund','Billing.payment_category' ),
                			'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0','Billing.refund'=>'1')));
                	$this->set('totalRefundGiven',$totalRefundGiven);
                }else{
                		
                	$totalDiscountGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.discount) AS sumDiscount','Billing.payment_category' ),
                			'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0','Billing.payment_category !='=>$pharmacyCategoryId)));
                	$this->set('totalDiscountGiven',$totalDiscountGiven);
                
                	$totalRefundGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.paid_to_patient) AS sumRefund','Billing.payment_category' ),
                			'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0','Billing.refund'=>'1','Billing.payment_category !='=>$pharmacyCategoryId)));
                	$this->set('totalRefundGiven',$totalRefundGiven);
                }
                         
                
                
		$this->set('finalBillArray', $serviceDetails[0]);
		$this->set('finalRefundAndDiscount', $serviceDetails[1]);
	}
	/**
	 * function to get mandatory charge Array
	 * @author Gaurav Chauriya
	 */
	public function getServicesChargeForInvoice($patientId , $serviceDetails , $isPackaged){
		$finalBillArray = $serviceDetails[0];
		$finalRefundAndDiscount = $serviceDetails[1];
		$this->loadModel('ServiceBill');
		$this->ServiceBill->bindModel(array(
				'belongsTo' => array(
						"ServiceCategory"=>array('foreignKey'=>'service_id','type'=>'RIGHT'),
						'TariffList'=>array('foreignKey'=>'tariff_list_id'),
				)));
			
		$servicesData =$this->ServiceBill->find('all',array('group'=>array('ServiceBill.id'),'fields'=>array('ServiceCategory.name','ServiceCategory.alias','ServiceCategory.id',
				'TariffList.name','TariffList.code_name','ServiceBill.amount','ServiceBill.no_of_times','ServiceBill.paid_amount','ServiceBill.discount',
				'ServiceBill.is_billable','ServiceBill.billing_id'),
				'conditions'=>array('ServiceBill.patient_id'=>$patientId)));
		$this->set('servicesData',$servicesData);//dpr($servicesData);
		foreach($servicesData as $services){
			/*if($isPackaged && !$services['ServiceBill']['is_billable'])
				continue;*/
			$finalBillArray[$services['ServiceCategory']['alias']][$services['TariffList']['name']] = array('ServiceName' => $services['TariffList']['name'],
					'Rate' => $services['ServiceBill']['amount'],
					'Amount' => (int) $finalBillArray[$services['ServiceCategory']['alias']][$services['TariffList']['name']]['Amount'] + $services['ServiceBill']['amount'] * $services['ServiceBill']['no_of_times'],
					'NoOFTimes' => (int) $finalBillArray[$services['ServiceCategory']['alias']][$services['TariffList']['name']]['NoOFTimes'] + 1 * $services['ServiceBill']['no_of_times'],
					'PaidAmount' => (int) $finalBillArray[$services['ServiceCategory']['alias']][$services['TariffList']['name']]['PaidAmount'] + $services['ServiceBill']['paid_amount'],
					'IsBillable' => $services['ServiceBill']['is_billable'],
					'BillingId' =>$services['ServiceBill']['billing_id'],
			);
			$finalRefundAndDiscount['Discount'] = (int) $finalRefundAndDiscount['Discount'] + $services['ServiceBill']['discount'];
			$finalRefundAndDiscount['RefundAmt'] = ( $services['ServiceBill']['billing_id'] && $services['ServiceBill']['paid_amount'] == 0 ) ? (int) $finalRefundAndDiscount['RefundAmt'] + $services['ServiceBill']['amount'] : (int) $finalRefundAndDiscount['RefundAmt'];
			$finalRefundAndDiscount['TotalAmount'] = (int) $finalRefundAndDiscount['TotalAmount'] + $services['ServiceBill']['amount'];
			$finalRefundAndDiscount['TotalPaid'] = (int) $finalRefundAndDiscount['TotalPaid'] + $services['ServiceBill']['paid_amount'];
			
		}
		return array( $finalBillArray , $finalRefundAndDiscount );
	}
	
	/**
	 * function to get Surgery charge Array
	 * @author Gaurav Chauriya
	 */
	public function getSurgeryChargesForInvoice($patientId , $serviceDetails , $isPackaged){
		$finalBillArray = $serviceDetails[0];
		$finalRefundAndDiscount = $serviceDetails[1];
		$wardServicesDataNew = $this->Billing->getSurgeryCharges($patientId);
		$this->set('surgeryServices',$wardServicesDataNew);
		foreach($wardServicesDataNew as $services){
			$totalNewWardCharges = 0;
			/** surgery Name*/ 
			$finalBillArray[Configure::read('surgeryservices')][$services['name']."(<i>".$services['start']."</i>)"] = 
			array('ServiceName' => $services['name']."(<i>".$services['start']."</i>)",
					'id' => $services['surgery_id'],
					'Rate' => (int) $services['cost'], 
					'Amount' => (int) $finalBillArray[Configure::read('surgeryservices')][$services['name']]['Amount'] + $services['cost'],
					'NoOFTimes' => (int) $finalBillArray[Configure::read('surgeryservices')][$services['name']]['NoOFTimes'] + 1 ,
					'PaidAmount' => '--',
					'IsBillable' => null,
					'BillingId' => $services['billing_id'],
			);
			$finalRefundAndDiscount['TotalAmount'] = (int) $finalRefundAndDiscount['TotalAmount'] +  (int) $services['cost'];
			/** Surgeon Charges */
			$finalBillArray[Configure::read('surgeryservices')]['Surgeon Charges'.$services['name']."(<i>".$services['start']."</i>)"] =
			array('ServiceName' => '&nbsp;&nbsp;&nbsp;&nbsp;Surgeon Charges<i> ('.rtrim($services['doctor'].','.$services['doctor_education'],',').')</i>',
					'id' => $services['surgery_id'],
					'field_name' => 'surgeon_amt',
					'Rate' => (int) $services['surgeon_cost'],
					'Amount' => (int) $finalBillArray[Configure::read('surgeryservices')]['Surgeon Charges'.$services['name']."(<i>".$services['start']."</i>)"]['Amount'] + $services['surgeon_cost'],
					'NoOFTimes' => (int) $finalBillArray[Configure::read('surgeryservices')]['Surgeon Charges'.$services['name']."(<i>".$services['start']."</i>)"]['NoOFTimes'] + 1 ,
					'PaidAmount' => '--',
					'IsBillable' => null,
					'BillingId' => $services['billing_id'],
			);
			$finalRefundAndDiscount['TotalAmount'] = (int) $finalRefundAndDiscount['TotalAmount'] +  (int) $services['surgeon_cost'];
			/** Asst. Surgeon I Charges */
			if($services['asst_surgeon_one']){
				$finalBillArray[Configure::read('surgeryservices')]['Asst. Surgeon I Charges'.$services['name']."(<i>".$services['start']."</i>)"] =
				array('ServiceName' => '&nbsp;&nbsp;&nbsp;&nbsp;Asst. Surgeon I Charges<i> ('.rtrim($services['asst_surgeon_one'],',').')</i>',
						'id' => $services['surgery_id'],
						'field_name' => 'asst_surgeon_one_charge',
						'Rate' => (int) $services['asst_surgeon_one_charge'],
						'Amount' => (int) $finalBillArray[Configure::read('surgeryservices')]['Asst. Surgeon I Charges'.$services['name']."(<i>".$services['start']."</i>)"]['Amount'] + $services['asst_surgeon_one_charge'],
						'NoOFTimes' => (int) $finalBillArray[Configure::read('surgeryservices')]['Asst. Surgeon I Charges'.$services['name']."(<i>".$services['start']."</i>)"]['NoOFTimes'] + 1 ,
						'PaidAmount' => '--',
						'IsBillable' => null,
						'BillingId' => $services['billing_id'],
				);
				$finalRefundAndDiscount['TotalAmount'] = (int) $finalRefundAndDiscount['TotalAmount'] +  (int) $services['asst_surgeon_one_charge'];
			}
			/** Asst. Surgeon II Charges */
			if($services['asst_surgeon_two']){
				$finalBillArray[Configure::read('surgeryservices')]['Asst. Surgeon II Charges'.$services['name']."(<i>".$services['start']."</i>)"] =
				array('ServiceName' => '&nbsp;&nbsp;&nbsp;&nbsp;Asst. Surgeon II Charges<i> ('.rtrim($services['asst_surgeon_two'],',').')</i>',
						'id' => $services['surgery_id'],
						'field_name' => 'asst_surgeon_two_charge',
						'Rate' => (int) $services['asst_surgeon_two_charge'],
						'Amount' => (int) $finalBillArray[Configure::read('surgeryservices')]['Asst. Surgeon II Charges'.$services['name']."(<i>".$services['start']."</i>)"]['Amount'] + $services['asst_surgeon_two_charge'],
						'NoOFTimes' => (int) $finalBillArray[Configure::read('surgeryservices')]['Asst. Surgeon II Charges'.$services['name']."(<i>".$services['start']."</i>)"]['NoOFTimes'] + 1 ,
						'PaidAmount' => '--',
						'IsBillable' => null,
						'BillingId' => $services['billing_id'],
				);
				$finalRefundAndDiscount['TotalAmount'] = (int) $finalRefundAndDiscount['TotalAmount'] +  (int) $services['asst_surgeon_two_charge'];
			}
			/** Anaesthesia Charges */
			if($services['anaesthesist']){
				$finalBillArray[Configure::read('surgeryservices')]['Anaesthesia Charges'.$services['name']."(<i>".$services['start']."</i>)"] =
				array('ServiceName' => '&nbsp;&nbsp;&nbsp;&nbsp;Anaesthesia Charges<i> ('.rtrim($services['anaesthesist'].','.$services['anaesthesist_education'],',').')</i>',
						'id' => $services['surgery_id'],
						'field_name' => 'anaesthesia_cost',
						'Rate' => (int) $services['anaesthesist_cost'],
						'Amount' => (int) $finalBillArray[Configure::read('surgeryservices')]['Anaesthesia Charges'.$services['name']."(<i>".$services['start']."</i>)"]['Amount'] + $services['anaesthesist_cost'],
						'NoOFTimes' => (int) $finalBillArray[Configure::read('surgeryservices')]['Anaesthesia Charges'.$services['name']."(<i>".$services['start']."</i>)"]['NoOFTimes'] + 1 ,
						'PaidAmount' => '--',
						'IsBillable' => null,
						'BillingId' => $services['billing_id'],
				);
				$finalRefundAndDiscount['TotalAmount'] = (int) $finalRefundAndDiscount['TotalAmount'] +  (int) $services['anaesthesist_cost'];
			}
			/** Cardiology Charges */
			if($services['cardiologist']){
				$finalBillArray[Configure::read('surgeryservices')]['Cardiology Charges'.$services['name']."(<i>".$services['start']."</i>)"] =
				array('ServiceName' => '&nbsp;&nbsp;&nbsp;&nbsp;Cardiology Charges<i> ('.rtrim($services['cardiologist'],',').')</i>',
						'id' => $services['surgery_id'],
						'field_name' => 'cardiologist_charge',
						'Rate' => (int) $services['cardiologist_charge'],
						'Amount' => (int) $finalBillArray[Configure::read('surgeryservices')]['Cardiology Charges'.$services['name']."(<i>".$services['start']."</i>)"]['Amount'] + $services['cardiologist_charge'],
						'NoOFTimes' => (int) $finalBillArray[Configure::read('surgeryservices')]['Cardiology Charges'.$services['name']."(<i>".$services['start']."</i>)"]['NoOFTimes'] + 1 ,
						'PaidAmount' => '--',
						'IsBillable' => null,
						'BillingId' => $services['billing_id'],
				);
				$finalRefundAndDiscount['TotalAmount'] = (int) $finalRefundAndDiscount['TotalAmount'] +  (int) $services['cardiologist_charge'];
			}
			/**  OT Assistant Charges */
			if($services['ot_assistant']){
				$finalBillArray[Configure::read('surgeryservices')]['OT Assistant Charges'.$services['name']."(<i>".$services['start']."</i>)"] =
				array('ServiceName' => '&nbsp;&nbsp;&nbsp;&nbsp;OT Assistant Charges',
						'id' => $services['surgery_id'],
						'field_name' => 'ot_asst_charge',
						'Rate' => (int) $services['ot_assistant'],
						'Amount' => (int) $finalBillArray[Configure::read('surgeryservices')]['OT Assistant Charges'.$services['name']."(<i>".$services['start']."</i>)"]['Amount'] + $services['ot_assistant'],
						'NoOFTimes' => (int) $finalBillArray[Configure::read('surgeryservices')]['OT Assistant Charges'.$services['name']."(<i>".$services['start']."</i>)"]['NoOFTimes'] + 1 ,
						'PaidAmount' => '--',
						'IsBillable' => null,
						'BillingId' => $services['billing_id'],
				);
				$finalRefundAndDiscount['TotalAmount'] = (int) $finalRefundAndDiscount['TotalAmount'] +  (int) $services['ot_assistant'];
			}
			/**  OT Charges */
		
			if($services['ot_charges']){
				if( $services['extra_hour_charge']!='0'){
					$ExtraHourCharge=$services['extra_hour_charge'];
					$units = (strtolower($services['operationType']) == 'major') ? $services['extra_hour_charge']/2000 : $services['extra_hour_charge']/1000;
					$extraHourRate=(strtolower($services['operationType']) == 'major') ? '2000' : '1000';
					$extraRate=$extraHourRate*$units;
					
				}
				$finalBillArray[Configure::read('surgeryservices')]['OT Charges'.$services['name']."(<i>".$services['start']."</i>)"] =
				array('ServiceName' => '&nbsp;&nbsp;&nbsp;&nbsp;OT Charges',
						'id' => $services['surgery_id'],
						'field_name' => 'ot_charges',
						'Rate' => ((int) $services['ot_charges'])+$extraRate ,
						'Amount' => (int) $finalBillArray[Configure::read('surgeryservices')]['OT Charges'.$services['name']."(<i>".$services['start']."</i>)"]['Amount'] + $services['ot_charges']+$ExtraHourCharge,
						'NoOFTimes' => ((int) $finalBillArray[Configure::read('surgeryservices')]['OT Charges'.$services['name']."(<i>".$services['start']."</i>)"]['NoOFTimes'] + 1),
						'PaidAmount' => '--',
						'IsBillable' => null,
						'BillingId' => $services['billing_id'],
				);
				$finalRefundAndDiscount['TotalAmount'] = (int) $finalRefundAndDiscount['TotalAmount'] +  (int) $services['ot_charges'];
			}
			/**  Extra OT Charges */
			/*if($services['extra_hour_charge'] != 0){
				$units = (strtolower($services['operationType']) == 'major') ? $services['extra_hour_charge']/2000 : $services['extra_hour_charge']/1000;
				$finalBillArray[Configure::read('surgeryservices')]['Extra OT Charges'.$services['name']."(<i>".$services['start']."</i>)"] =
				array('ServiceName' => '&nbsp;&nbsp;&nbsp;&nbsp;Extra OT Charges',
						'id' => $services['surgery_id'], 
						'field_name' => '',
						'Rate' => (strtolower($services['operationType']) == 'major') ? '2000' : '1000',
						'Amount' => (int) $finalBillArray[Configure::read('surgeryservices')]['Extra OT Charges'.$services['name']."(<i>".$services['start']."</i>)"]['Amount'] + $services['extra_hour_charge'],
						'NoOFTimes' => $units,
						'PaidAmount' => '--',
						'IsBillable' => null,
						'BillingId' => $services['billing_id'],
				);
				$finalRefundAndDiscount['TotalAmount'] = (int) $finalRefundAndDiscount['TotalAmount'] +  (int) $services['extra_hour_charge'];
			}*/
			/**  OT Services Charges */
			foreach($services['ot_extra_services'] as $name => $value){
				$finalBillArray[Configure::read('surgeryservices')]['OT Services Charges'.$name."(<i>".$services['start']."</i>)"] =
				array('ServiceName' => '&nbsp;&nbsp;&nbsp;&nbsp;'.$name,
						'id' => $services['surgery_id'],
						'field_name' => 'ot_service',
						'Rate' => $value,
						'Amount' => (int) $finalBillArray[Configure::read('surgeryservices')]['OT Services Charges'.$name."(<i>".$services['start']."</i>)"]['Amount'] + $value,
						'NoOFTimes' => '1',
						'PaidAmount' => '--',
						'IsBillable' => null,
						'BillingId' => $services['billing_id'],
				);
				$totalOtServiceCharge = (int) $totalOtServiceCharge + $value;
				$finalRefundAndDiscount['TotalAmount'] = (int) $finalRefundAndDiscount['TotalAmount'] + $totalOtServiceCharge;
			}
			
			$finalRefundAndDiscount['Discount'] = (int) $finalRefundAndDiscount['Discount'] + round($services['discount']);
			$finalRefundAndDiscount['RefundAmt'] = ( $services['billing_id'] && $services['paid_amount'] == 0 ) ? (int) $finalRefundAndDiscount['RefundAmt'] + $services['amount'] : (int) $finalRefundAndDiscount['RefundAmt'];
			/* $totalNewWardCharges = $services['cost'] + $services['surgeon_cost'] + $services['asst_surgeon_one_charge'] + $services['asst_surgeon_two_charge'] + 
									$services['anaesthesist_cost'] + $services['cardiologist_charge'] + $services['ot_assistant'] + $services['ot_charges'] + 
									$services['extra_hour_charge'] + $totalOtServiceCharge; */
		//	$finalRefundAndDiscount['TotalAmount'] = (int) $finalRefundAndDiscount['TotalAmount'] + $totalNewWardCharges;
			$finalRefundAndDiscount['TotalPaid'] = (int) $finalRefundAndDiscount['TotalPaid'] + $services['paid_amount'];
		}
		
		return array( $finalBillArray , $finalRefundAndDiscount );
	}
	/**
	 * function to get laboratory charges for invoice
	 * @author Gaurav Chauriya
	 */
	public function getLaboratoryServiceChargesForInvoice($patientId , $serviceDetails , $isPackaged){
		$finalBillArray = $serviceDetails[0]; 
		$finalRefundAndDiscount = $serviceDetails[1];
		$this->loadModel('LaboratoryTestOrder');
		$this->LaboratoryTestOrder->bindModel(array(
				'belongsTo' => array(
						'Laboratory'=>array('foreignKey' => false,'conditions'=>array('Laboratory.id=LaboratoryTestOrder.laboratory_id')),
						'ServiceProvider'=>array('foreignKey' => false,'conditions'=>array('ServiceProvider.id=LaboratoryTestOrder.service_provider_id')),
				)),false);
			
		$labData = $this->LaboratoryTestOrder->find('all',array('fields'=>array('LaboratoryTestOrder.amount','LaboratoryTestOrder.paid_amount','LaboratoryTestOrder.discount',
				'LaboratoryTestOrder.is_billable','LaboratoryTestOrder.billing_id','ServiceProvider.name','Laboratory.name'),
				'conditions' =>array('LaboratoryTestOrder.patient_id'=>$patientId,'LaboratoryTestOrder.is_deleted'=>'0'),
				'group'=>array('LaboratoryTestOrder.id')));
		$this->set('labData',$labData);
		foreach($labData as $services){
			/*if($isPackaged && !$services['LaboratoryTestOrder']['is_billable'])
				continue;*/
			$finalBillArray[Configure::read('laboratoryservices')][$services['Laboratory']['name']] = array('ServiceName' => $services['Laboratory']['name'],
					'Rate' => $services['LaboratoryTestOrder']['amount'],
					'Amount' => (int) $finalBillArray[Configure::read('laboratoryservices')][$services['Laboratory']['name']]['Amount'] + $services['LaboratoryTestOrder']['amount'],
					'NoOFTimes' => (int) $finalBillArray[Configure::read('laboratoryservices')][$services['Laboratory']['name']]['NoOFTimes'] + 1 ,
					'PaidAmount' => (int) $finalBillArray[Configure::read('laboratoryservices')][$services['Laboratory']['name']]['PaidAmount'] + $services['LaboratoryTestOrder']['paid_amount'],
					'IsBillable' => $services['LaboratoryTestOrder']['is_billable'],
					'BillingId' =>$services['LaboratoryTestOrder']['billing_id']
			);
			$finalRefundAndDiscount['Discount'] = (int) $finalRefundAndDiscount['Discount'] + $services['LaboratoryTestOrder']['discount'];
			$finalRefundAndDiscount['RefundAmt'] = ( $services['LaboratoryTestOrder']['billing_id'] && $services['LaboratoryTestOrder']['paid_amount'] == 0 ) ? (int) $finalRefundAndDiscount['RefundAmt'] + $services['LaboratoryTestOrder']['amount'] : (int) $finalRefundAndDiscount['RefundAmt'];
			$finalRefundAndDiscount['TotalAmount'] = (int) $finalRefundAndDiscount['TotalAmount'] + $services['LaboratoryTestOrder']['amount'];
			$finalRefundAndDiscount['TotalPaid'] = (int) $finalRefundAndDiscount['TotalPaid'] + $services['LaboratoryTestOrder']['paid_amount'];
		}
		return array($finalBillArray , $finalRefundAndDiscount);
	}
	
	/**
	 * function to get Radiology charges for invoice
	 * @author Gaurav Chauriya
	 */
	public function getRadiologyServiceChargesForInvoice($patientId , $serviceDetails , $isPackaged){
		$finalBillArray = $serviceDetails[0];
		$finalRefundAndDiscount = $serviceDetails[1];
		$this->loadModel('RadiologyTestOrder');
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey' => false,'conditions'=>array('Radiology.id=RadiologyTestOrder.radiology_id')),
						'ServiceProvider'=>array('foreignKey' => false,'conditions'=>array('ServiceProvider.id=RadiologyTestOrder.service_provider_id')),
				)),false);
		
		$radData = $this->RadiologyTestOrder->find('all',array('fields'=>array('RadiologyTestOrder.amount','RadiologyTestOrder.paid_amount','RadiologyTestOrder.discount',
				'RadiologyTestOrder.is_billable','RadiologyTestOrder.billing_id','ServiceProvider.name','Radiology.name'),
				'conditions' =>array('RadiologyTestOrder.patient_id'=>$patientId,'RadiologyTestOrder.is_deleted'=>'0'),
				'group'=>array('RadiologyTestOrder.id')));
		$this->set('radData',$radData);
		foreach($radData as $services){
			/*if($isPackaged && !$services['RadiologyTestOrder']['is_billable'])
				continue;*/
				$finalBillArray[Configure::read('radiologyservices')][$services['Radiology']['name']] = array('ServiceName' => $services['Radiology']['name'],
						'Rate' => $services['RadiologyTestOrder']['amount'],
						'Amount' => (int) $finalBillArray[Configure::read('radiologyservices')][$services['Radiology']['name']]['Amount'] + $services['RadiologyTestOrder']['amount'],
						'NoOFTimes' => (int) $finalBillArray[Configure::read('radiologyservices')][$services['Radiology']['name']]['NoOFTimes'] + 1 ,
						'PaidAmount' => (int) $finalBillArray[Configure::read('radiologyservices')][$services['Laboratory']['name']]['PaidAmount'] + $services['RadiologyTestOrder']['paid_amount'],
						'IsBillable' => $services['RadiologyTestOrder']['is_billable'],
						'BillingId' =>$services['RadiologyTestOrder']['billing_id']
				);
				$finalRefundAndDiscount['Discount'] = (int) $finalRefundAndDiscount['Discount'] + $services['RadiologyTestOrder']['discount'];
				$finalRefundAndDiscount['RefundAmt'] = ( $services['RadiologyTestOrder']['billing_id'] && $services['RadiologyTestOrder']['paid_amount'] == 0 ) ? (int) $finalRefundAndDiscount['RefundAmt'] + $services['RadiologyTestOrder']['amount'] : (int) $finalRefundAndDiscount['RefundAmt'];
				$finalRefundAndDiscount['TotalAmount'] = (int) $finalRefundAndDiscount['TotalAmount'] + $services['RadiologyTestOrder']['amount'];
				$finalRefundAndDiscount['TotalPaid'] = (int) $finalRefundAndDiscount['TotalPaid'] + $services['RadiologyTestOrder']['paid_amount'];
			
		}
		return array($finalBillArray , $finalRefundAndDiscount);
	}
	
	/**
	 * function to get Ward charges for invoice
	 * @author Gaurav Chauriya
	 */
	public function getWardServiceChargesForInvoice($patientId , $serviceDetails , $isPackaged){
		$finalBillArray = $serviceDetails[0];
		$finalRefundAndDiscount = $serviceDetails[1];
		$this->loadModel('WardPatientService');
		$this->WardPatientService->bindModel(array(
				'belongsTo'=>array(
						'TariffList'=>array('foreignKey'=>'tariff_list_id'),
						"ServiceCategory"=>array('foreignKey'=>'service_id'),
				)),false);
		
		$allRoomService=$this->WardPatientService->find('all',array('fields'=>array('WardPatientService.amount','WardPatientService.paid_amount','WardPatientService.discount',
				'WardPatientService.billing_id','WardPatientService.date','TariffList.id','TariffList.name','ServiceCategory.alias'),
				'conditions'=>array('WardPatientService.patient_id'=>$patientId,'WardPatientService.is_deleted'=>'0')
				,'order'=>array('WardPatientService.date'),'group'=>array('WardPatientService.id')));
		$this->set('allRoomService',$allRoomService);
		foreach($allRoomService as $services){
				$finalBillArray[$services['ServiceCategory']['alias']][$services['TariffList']['name']] = array('ServiceName' => $services['TariffList']['name'],
						'Rate' => $services['WardPatientService']['amount'],
						'Amount' => (int) $finalBillArray[$services['ServiceCategory']['alias']][$services['TariffList']['name']]['Amount'] + $services['WardPatientService']['amount'],
						'NoOFTimes' => (int) $finalBillArray[$services['ServiceCategory']['alias']][$services['TariffList']['name']]['NoOFTimes'] + 1 ,
						'PaidAmount' => (int) $finalBillArray[$services['ServiceCategory']['alias']][$services['TariffList']['name']]['PaidAmount'] + $services['WardPatientService']['paid_amount'],
						'IsBillable' => $services['WardPatientService']['is_billable'],
						'BillingId' =>$services['WardPatientService']['billing_id']
				);
				$finalRefundAndDiscount['Discount'] = (int) $finalRefundAndDiscount['Discount'] + $services['WardPatientService']['discount'];
				$finalRefundAndDiscount['RefundAmt'] = ( $services['WardPatientService']['billing_id'] && $services['WardPatientService']['paid_amount'] == 0 ) ? (int) $finalRefundAndDiscount['RefundAmt'] + $services['WardPatientService']['amount'] : (int) $finalRefundAndDiscount['RefundAmt'];
				$finalRefundAndDiscount['TotalAmount'] = (int) $finalRefundAndDiscount['TotalAmount'] + $services['WardPatientService']['amount'];
				$finalRefundAndDiscount['TotalPaid'] = (int) $finalRefundAndDiscount['TotalPaid'] + $services['WardPatientService']['paid_amount'];
		}
		return array($finalBillArray , $finalRefundAndDiscount);
	}
	
	/**
	 * function to get Ward charges for invoice
	 * @author Gaurav Chauriya
	 */
	public function getConsultantServiceChargesForInvoice($patientId , $serviceDetails , $isPackaged){
		$finalBillArray = $serviceDetails[0];
		$finalRefundAndDiscount = $serviceDetails[1];
		$this->loadModel('ConsultantBilling');
		$this->ConsultantBilling->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array('foreignKey'=>'consultant_service_id'),
						"ServiceCategory"=>array('foreignKey'=>'service_category_id'),
						"DoctorProfile"=>array('foreignKey'=>'doctor_id'),
				)));
		$consultantBillingData = $this->ConsultantBilling->find('all',array('fields'=>array('ConsultantBilling.amount','ConsultantBilling.paid_amount','ConsultantBilling.discount',
				'ConsultantBilling.billing_id','ConsultantBilling.date','TariffList.id','TariffList.name','ServiceCategory.alias','DoctorProfile.doctor_name'),
				'conditions' =>array('ConsultantBilling.patient_id'=>$patientId)));
		$this->set('consultantBillingData',$consultantBillingData);
		foreach($consultantBillingData as $services){
			$serviceCategory = ($services['ServiceCategory']['alias']) ? $services['ServiceCategory']['alias'] : Configure::read('Consultant');
			$finalBillArray[$serviceCategory][$services['DoctorProfile']['doctor_name'].' (<i>'.$services['TariffList']['name'].'</i>)'] = 
			array('ServiceName' => $services['DoctorProfile']['doctor_name'].' (<i>'.$services['TariffList']['name'].'</i>)',
					'Rate' => $services['ConsultantBilling']['amount'],
					'Amount' => (int) $finalBillArray[$serviceCategory][$services['DoctorProfile']['doctor_name'].' (<i>'.$services['TariffList']['name'].'</i>)']['Amount'] + $services['ConsultantBilling']['amount'],
					'NoOFTimes' => (int) $finalBillArray[$serviceCategory][$services['DoctorProfile']['doctor_name'].' (<i>'.$services['TariffList']['name'].'</i>)']['NoOFTimes'] + 1 ,
					'PaidAmount' => (int) $finalBillArray[$serviceCategory][$services['DoctorProfile']['doctor_name'].' (<i>'.$services['TariffList']['name'].'</i>)']['PaidAmount'] + $services['ConsultantBilling']['paid_amount'],
					'IsBillable' => $services['ConsultantBilling']['is_billable'],
					'BillingId' =>$services['ConsultantBilling']['billing_id']
			);
			$finalRefundAndDiscount['Discount'] = (int) $finalRefundAndDiscount['Discount'] + $services['ConsultantBilling']['discount'];
			$finalRefundAndDiscount['RefundAmt'] = ( $services['ConsultantBilling']['billing_id'] && $services['ConsultantBilling']['paid_amount'] == 0 ) ? (int) $finalRefundAndDiscount['RefundAmt'] + $services['ConsultantBilling']['amount'] : (int) $finalRefundAndDiscount['RefundAmt'];
			$finalRefundAndDiscount['TotalAmount'] = (int) $finalRefundAndDiscount['TotalAmount'] + $services['ConsultantBilling']['amount'];
			$finalRefundAndDiscount['TotalPaid'] = (int) $finalRefundAndDiscount['TotalPaid'] + $services['ConsultantBilling']['paid_amount'];
		}
		return array($finalBillArray , $finalRefundAndDiscount);
	}
	
	//html forms
	function discharge_summary($id=null,$printInvestigation=null){
		 
	
		$this->uses = array('DiagnosisDrug','Person','Consultant','User','Patient','Diagnosis','SuggestedDrug','Note','OptAppointment','DoctorProfile'
				,'DischargeSummary','DischargeDrug','DischargeSurgery','FinalBilling', 'OperativeNote','PharmacySalesBillDetail');
		
		$currentReturnString = $this->params->query['return'];
		if($currentReturnString)
			$this->Session->write('returnToPatientInfo',$currentReturnString); //to set back button
		else{
			$this->Session->delete('returnToPatientInfo'); //to set back button
		}
		if(!empty($this->request->data)){


			$doc_id = $this->request->data['DischargeSummary']['doctor_id'];
			$ser_doc = serialize($doc_id); //save


			$ros = $this->Patient->updateotherconsultant($id,$ser_doc);

			$result = $this->DischargeSummary->insertDischargeSummary($this->request->data);

			

			if($result){
				//update some entries from diagnosis
				$diagnosisArr['patient_id'] =  $this->request->data['DischargeSummary']['patient_id'];
				$diagnosisArr['id'] =  $this->request->data['DischargeSummary']['diagnosis_id'];
				$diagnosisArr['final_diagnosis'] =  $this->request->data['DischargeSummary']['final_diagnosis'];
				$diagnosisArr['id'] =  $this->request->data['DischargeSummary']['diagnosis_id'];
				$diagnosisArr['complaints'] =  $this->request->data['DischargeSummary']['complaints'];
				$diagnosisArr['TEMP'] =  $this->request->data['DischargeSummary']['temp'];
				$diagnosisArr['PR'] =  $this->request->data['DischargeSummary']['pr'];
				$diagnosisArr['RR'] =  $this->request->data['DischargeSummary']['rr'];
				$diagnosisArr['BP'] =  $this->request->data['DischargeSummary']['bp'];
				$diagnosisArr['general_examine'] =  $this->request->data['DischargeSummary']['general_examine'];
				$diagnosisArr['spo2'] =  $this->request->data['DischargeSummary']['spo2'];
                                $diagnosisArr['is_print_investigation'] =  $this->request->data['DischargeSummary']['is_print_investigation'];


				$this->Diagnosis->updateFromDischargeSummery($diagnosisArr);
				//EOF update diagnosis
				$this->Session->setFlash(__('Discharge summary added sucessfully' ),'default',array('class'=>'message'));
				$this->redirect($this->referer());
			}else{
				$errors = $this->DischargeSummary->invalidFields();
					
				if($errors){
					$this->set("errors", $errors);
				}else{
					$this->Session->setFlash(__('Please try again', true),'default',array('class'=>'error'));
					$this->redirect($this->referer());
				}
			}
		}

		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment'),
						'TariffStandard'=>array('foreignKey'=>'tariff_standard_id')),
				'hasOne'=>array('FinalBilling'=>array('foreignKey'=>'patient_id'))));
		$patient_details  = $this->Patient->getPatientDetailsByIDWithTariff($id,'bill_number');//sent 2nd arg for bill number
		/**BOF-Geting initial name***/
		$this->User->bindModel(array('belongsTo' => array(
				'Initial' =>array('foreignKey'=>false, 'conditions' => array('Initial.id=User.initial_id')),

		)),false);
		$treatingConsultantData = $this->User->find('first',array('fields'=>array('CONCAT(User.first_name, " ", User.last_name) as fullname',
				'Initial.name as initial_name',),'conditions'=>array('User.id'=>$patient_details['Patient']['doctor_id'])));

		/**EOF-Geting initial name***/
		//retrive other consultant name
		$getOtherConsultant=unserialize($patient_details['Patient']['other_consultant']);
		$commonArr = array();
		$doctorArr = array();
		$consultantArr = array();
		foreach($getOtherConsultant as $key=>$getUnserializeDatas){
			$commonArr[$key]=explode('_',$getUnserializeDatas);
			if($commonArr[$key]['0']=='consultant'){
				$consultantArr[]=$commonArr[$key]['1'];
			}else if($commonArr[$key]['0']=='doctor'){
				$doctorArr[]=$commonArr[$key]['1'];
			}
		}
		$this->Consultant->bindModel(array(
				'belongsTo' => array(
						'ReffererDoctor' =>array('foreignKey' => false,'conditions'=>array('Consultant.refferer_doctor_id=ReffererDoctor.id')),
						'Initial' =>array('foreignKey' => false,'conditions'=>array('Consultant.initial_id=Initial.id')),
				)),false);
		$consultantData= $this->Consultant->find('all',array('fields'=>array('Initial.name as nameInitial','Consultant.id','full_name'=>'CONCAT(Consultant.first_name," ",Consultant.last_name) as name'),'conditions'=>array('Consultant.id'=>$consultantArr,'Consultant.is_deleted' => 0, 'Consultant.location_id' => $this->Session->read('locationid'), 'ReffererDoctor.is_referral' => 'N')));
		$patientDataUser =$this->User->find('all',array('fields'=>array('Initial.name as nameInitial','User.mobile','User.id','full_name'=>'CONCAT(User.first_name," ",User.last_name) as name'),'conditions'=>array('User.id'=>$doctorArr,'User.is_deleted'=>0)));
		$otherConsultantData=array_merge($consultantData,$patientDataUser);
		/*$otherConsultant = $this->User->find('all',array('fields'=>array('full_name'),'conditions'=>array('User.id'=>unserialize($patient_details['Patient']['other_consultant']))));
		 */
		$this->set('otherConsultantData',$otherConsultantData);
		//EOF other consultant

		$treatingConsultant = $this->User->getDoctorByID($patient_details['Patient']['doctor_id']) ;
		$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);
		$formatted_address = $this->setAddressFormat($UIDpatient_details['Person']);
		$noteData = $this->Note->find('all',array('fields'=>array('Note.id,Note.present_condition'),'conditions'=>array('Note.note_type'=>'general','Note.patient_id'=>$id)));
		$lastRecord  = end($noteData);
		$notesRec = $this->DischargeSummary->find('first',array('conditions'=>array('DischargeSummary.patient_id'=>$id)));
			
		if($notesRec['DischargeSummary']['id']){
			//BOF pankaj
			$splittedReviewDate = explode(" ",$notesRec['DischargeSummary']['review_on']);
			//EOF pankaj

			$notesRec['DischargeSummary']['review_on']  = $this->DateFormat->formatDate2Local($splittedReviewDate[0],Configure::read('date_format'))." ".$splittedReviewDate[1];
			$suggestedDrugRec = $this->DischargeDrug->find('all',array('fields'=>array('DischargeDrug.route,DischargeDrug.dose,DischargeDrug.quantity,DischargeDrug.frequency,DischargeDrug.remark,DischargeDrug.first,DischargeDrug.second,DischargeDrug.third,DischargeDrug.forth,PharmacyItem.name,PharmacyItem.pack','DischargeDrug.start_date','DischargeDrug.is_sms_checked'),'conditions'=>array('DischargeDrug.discharge_summaries_id'=>$notesRec['DischargeSummary']['id'])));

			$count = count($suggestedDrugRec);
			if($count){
				for($i=0;$i<$count;){
					$notesRec['PharmacyItem'][$i]  = $suggestedDrugRec[$i]['PharmacyItem']['name'];
					$notesRec['pack'][$i]  = $suggestedDrugRec[$i]['PharmacyItem']['pack'];
					$notesRec['route'][$i]  = $suggestedDrugRec[$i]['DischargeDrug']['route'];
					$notesRec['dose'][$i]  = $suggestedDrugRec[$i]['DischargeDrug']['dose'];
					$notesRec['frequency'][$i]  = $suggestedDrugRec[$i]['DischargeDrug']['frequency'];
					$notesRec['quantity'][$i]  = $suggestedDrugRec[$i]['DischargeDrug']['quantity'];
					$notesRec['remark'][$i]  = $suggestedDrugRec[$i]['DischargeDrug']['remark'];
					$notesRec['first'][$i]  = $suggestedDrugRec[$i]['DischargeDrug']['first'];
					$notesRec['second'][$i]  = $suggestedDrugRec[$i]['DischargeDrug']['second'];
					$notesRec['third'][$i]  = $suggestedDrugRec[$i]['DischargeDrug']['third'];
					$notesRec['forth'][$i]  = $suggestedDrugRec[$i]['DischargeDrug']['forth'];					
					$notesRec['start_date'][$i]  = $this->DateFormat->formatDate2Local($suggestedDrugRec[$i]['DischargeDrug']['start_date'],Configure::read('date_format'),false);					
					$notesRec['is_sms_checked'][$i]  = $suggestedDrugRec[$i]['DischargeDrug']['is_sms_checked'];
					$i++;
				}
			}
		}else{
			$suggestedDrugRec = $this->SuggestedDrug->find('all',array('fields'=>array('SuggestedDrug.route,SuggestedDrug.dose,SuggestedDrug.quantity,
					SuggestedDrug.frequency,SuggestedDrug.first,SuggestedDrug.second,SuggestedDrug.third,SuggestedDrug.forth,PharmacyItem.name,PharmacyItem.pack'),
					'conditions'=>array('SuggestedDrug.note_id'=>$lastRecord['Note']['id'],'NOT'=>array('SuggestedDrug.note_id'=>null))));

			$count = count($suggestedDrugRec);
			if($count){
				for($i=0;$i<$count;){
					$notesRec['PharmacyItem'][$i]  = $suggestedDrugRec[$i]['PharmacyItem']['name'];
					$notesRec['pack'][$i]  = $suggestedDrugRec[$i]['PharmacyItem']['pack'];
					$notesRec['route'][$i]  = $suggestedDrugRec[$i]['SuggestedDrug']['route'];
					$notesRec['dose'][$i]  = $suggestedDrugRec[$i]['SuggestedDrug']['dose'];
					$notesRec['frequency'][$i]  = $suggestedDrugRec[$i]['SuggestedDrug']['frequency'];
					$notesRec['quantity'][$i]  = $suggestedDrugRec[$i]['SuggestedDrug']['quantity'];
					$notesRec['first'][$i]  = $suggestedDrugRec[$i]['SuggestedDrug']['first'];
					$notesRec['second'][$i]  = $suggestedDrugRec[$i]['SuggestedDrug']['second'];
					$notesRec['third'][$i]  = $suggestedDrugRec[$i]['SuggestedDrug']['third'];
					$notesRec['forth'][$i]  = $suggestedDrugRec[$i]['SuggestedDrug']['forth'];
					$notesRec['start_date'][$i]  = $this->DateFormat->formatDate2Local($suggestedDrugRec[$i]['DischargeDrug']['start_date'],Configure::read('date_format'),false);					
					$notesRec['is_sms_checked'][$i]  = $suggestedDrugRec[$i]['DischargeDrug']['is_sms_checked'];
					$i++;
				}
			}
		}

		$this->SuggestedDrug->bindModel(array(
				'belongsTo' =>array(
						'Note'=>array('type'=>'inner','foreignKey'=>'note_id','conditions'=>array('Note.patient_id'=>$id)),
				)));
		//retrive complete drugs
		$completeDrugRec = $this->SuggestedDrug->find('all',array('fields'=>array('SuggestedDrug.route,SuggestedDrug.dose,SuggestedDrug.quantity,SuggestedDrug.frequency,PharmacyItem.name,PharmacyItem.pack','SuggestedDrug.id','SuggestedDrug.id','SuggestedDrug.is_deleted'),'conditions'=>array('SuggestedDrug.is_deleted'=>0)));

		$diagnosis = $this->Diagnosis->find('first',array('fields'=>array('id','final_diagnosis','complaints','TEMP','PR','RR','BP','spo2','general_examine','rectal_examine','pelvic_examine','investigation','is_print_investigation'),'conditions'=>array('patient_id'=>$id)));
		

		$diagnosis_data = $this->Patient->find('first', array(
			'conditions' => array('Patient.id' => $id),
			'fields' => array('Patient.diagnosis_txt') 
		));
		
		$diagnosis_txt = isset($diagnosis_data['Patient']['diagnosis_txt']) ? trim($diagnosis_data['Patient']['diagnosis_txt']) : '';
		
		$this->set(compact('diagnosis_txt'));
		

		$currentTreatment = $this->DiagnosisDrug->find('all',array('fields'=>array('DiagnosisDrug.id,PharmacyItem.name,PharmacyItem.pack'),'conditions'=>array('DiagnosisDrug.diagnosis_id'=>$diagnosis['Diagnosis']['id'])));
		$completeDrugArr = array();
		//$completeDrugRec=array_filter($completeDrugRec);

		foreach($completeDrugRec as $a => $b){
			$completeDrugArr[$b['SuggestedDrug']['id']] = $b['PharmacyItem']['name'];
			//$completeDrugArr[$b['PharmacyItem']['pack']] = $b['PharmacyItem']['pack'];
		}

		foreach($currentTreatment as $c=>$k){
			$completeDrugArr[$k['PharmacyItem']['name']] = $k['PharmacyItem']['name'];
			//$completeDrugArr[$b['PharmacyItem']['pack']] = $b['PharmacyItem']['pack'];
		}
		//EOD drugs data
		//$testOrdered = $this->Billing->completeTests($id);
        $testOrdered = $this->Billing->completeLabRadTests($id,$printInvestigation); 
          
		$this->set(array('noteRecord'=>$lastRecord,'note'=>$notesRec,'completeDrugArr'=>$completeDrugArr,'testOrdered'=>$testOrdered,'patient_id'=>$id,
				'treatingConsultant'=>$treatingConsultant));
		$this->data = $notesRec ;
		//doc and ansthashia list
		$otList = $this->OptAppointment->find('all',array('conditions'=>array('OptAppointment.patient_id'=>$id,'OptAppointment.is_deleted'=>0),
				'fields'=>array('patient_id','starttime','start_time','anaesthesia','schedule_date','description','id','department_id','doctor_id','discharge_desc','Surgery.name'),'order' => array ('OptAppointment.starttime'=>'ASC')));
		
		$location_id= $this->Session->read('locationid');
		/*$surgonlist = $this->DoctorProfile->find("list", array('conditions' => array('DoctorProfile.is_registrar'=>0,'Department.name NOT LIKE'=> "%Anaesthesia%",'User.location_id'=>$location_id,
		 'User.is_deleted'=>0),'fields' => array('DoctorProfile.user_id','DoctorProfile.doctor_name'), 'recursive' => 0));*/

		//$surgonlist = $this->User->getAnaesthesistAndNone(false);

		$surgonlist = $this->DoctorProfile->getSurgeon();

		$analist = $this->User->getAnaesthesistAndNone(true);

		//$this->DoctorProfile->find("list", array('conditions' => array('DoctorProfile.is_registrar'=>0,'Department.name LIKE'=> "%Anaesthesia%",'User.location_id'=>$location_id,'User.is_deleted'=>0),
		//'fields' => array('DoctorProfile.user_id','DoctorProfile.doctor_name'), 'recursive' => 0));

		//$docList = $surgonlist+$analist; //concat two arrays
		//ksort($docList);
		$docList =  $this->DoctorProfile->getRegistrar();

		//doc and ana list
		//retrive surgeries
		$dischargeOT = $this->DischargeSurgery->find('all',array('conditions'=>array('patient_id'=>$notesRec['DischargeSummary']['patient_id'])));


		$this->User->recursive = -1 ;
		$this->set(array('otList'=>$otList,'uidpatient' => $UIDpatient_details,'address'=>$formatted_address,'patient'=>$patient_details,
				'id'=>$id,'treatingConsultantData'=>$treatingConsultantData,/*'treating_consultant'=>$this->User->getDoctorByID($patient_details['Patient']['doctor_id']),*/
				'docList'=>$docList,'diagnosis'=>$diagnosis['Diagnosis'],'surgonList'=>$surgonlist,'anaList'=>$analist,'dischargeOT'=>$dischargeOT));

		//added for 'other Consultant'
		$me = $this->DoctorProfile->find('list',array('fields'=>array('id','doctor_name'),
				'conditions'=>array('User.is_deleted'=>0, 'DoctorProfile.is_deleted'=>0,'User.location_id'=>$location_id, 'DoctorProfile.is_registrar'=>0),'order'=>array('DoctorProfile.doctor_name'),'contain' => array('User', 'Initial'), 'recursive' => 1));
		//debug($me);
		//exit;
		/*$doctList=$this->DoctorProfile->getDoctors();
		 $doctors=array_filter($doctList);*/
        /** BOF for clerance of patient --- atul**/
		$this->Patient->unbindModel(array(
				'belongsTo' => array('Initial','Doctor','DoctorProfile','Person','User','TariffStandard','State','PharmacySalesBill','InventoryPharmacySalesReturn'
				)));
		$this->Patient->bindModel(array('belongsTo' => array(
				'DischargeSummary' =>array('foreignKey'=>false, 'conditions' => array('DischargeSummary.patient_id=Patient.id')),
		
		)),false);
		$clearance = $this->Patient->find('all',array('fields'=>array('Patient.id', 'Patient.admission_type','Patient.lookup_name','Patient.location_id','Patient.clearance'),
				'conditions'=>array('Patient.is_discharge'=>'0','Patient.is_deleted'=>'0','DischargeSummary.patient_id'=>$id,'Patient.admission_type'=>'IPD',
						'Patient.location_id' => $this->Session->read('locationid'),'Patient.is_doc_clearance_chk'=>1)));
		$this->set('clearance',$clearance);
		

		$oprNotes = $this->OperativeNote->find('first', array('conditions' => array('patient_id' => $id),'order'=>'id DESC'));

		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id')),
				)));

		$getBasicData=$this->Patient->find('first',array('fields'=>array('Patient.id','Patient.person_id','Person.dob','Patient.lookup_name','Patient.age','Patient.sex','Patient.admission_type', 'Patient.admission_id','Person.patient_uid','Person.ready_to_fetch','Patient.is_discharge'),
				'conditions'=>array('Patient.id'=>$id)));
		
		$this->set('otList', $otList);
		$this->set('getBasicData', $getBasicData);
		$this->set('notesRec', $notesRec);
	
		
		// End
		//*** EOF **//
		
		//*******BOF-Other Consultant ---Mahalaxmi
		$getOtherConsultant=$this->Patient->otherConsultantDoctors();
		//*******EOF-Other Consultant ---Mahalaxmi
		$this->set('doctors',$getOtherConsultant);

		$this->PharmacySalesBillDetail->bindModel(array(
				'belongsTo' => array(
						'PharmacySalesBill' =>array('foreignKey' => false,'conditions'=>array('PharmacySalesBill.id=PharmacySalesBillDetail.pharmacy_sales_bill_id')),
						'PharmacyItem' =>array('foreignKey' => false,'conditions'=>array('PharmacyItem.id=PharmacySalesBillDetail.item_id')),
				)));

		$stayMedicine = $this->PharmacySalesBillDetail->find('all',array('conditions'=>array('PharmacySalesBill.patient_id'=>$id,'PharmacySalesBill.is_deleted'=>0),'fields'=>array('PharmacyItem.name','PharmacySalesBill.create_time')));

		$this->set('stayMedicine',$stayMedicine);



	}

	function discharge_summary_print($patient_id=null){
            $printInvestigation = '';
            if(!empty($this->request->query)){ 
                $printInvestigation = $this->request->query['is_print_investigation'];  
            }
            $this->layout ='print_without_header' ;
            $p_id = $this->discharge_summary($patient_id,$printInvestigation); 
	}
        
	//BOF Mahalaxmi 20th Oct 2015
	function dischargeSummaryPrintNew($patient_id=null){
            $printInvestigation = '';
            if(!empty($this->request->query)){ 
                $printInvestigation = $this->request->query['is_print_investigation'];  
            }
            $this->layout ='print_without_header' ;
            $p_id = $this->discharge_summary($patient_id,$printInvestigation); 
	}
	//BOF pankaj 9th july
	function dama_form($patient_id=null){
		if($patient_id && empty($this->request->data['DamaConsentForm'])){
			$this->uses = array('Patient','DamaConsentForm');
			/*$this->Patient->bindModel(array(
			 'belongsTo'=>array(
			 		'Person'=>array('foreignKey'=>'person_id'),
			 		'Initial'=>array('foreignKey'=>false,'conditions'=>array('Initial.id=Person.initial_id'))
			 )));
			$patientData= $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$patient_id)));*/
			$damaForm = $this->DamaConsentForm->find('first',array('conditions'=>array('patient_id'=>$patient_id)));
			//debug($patient_id);exit;
			$this->data= $damaForm ;
			$this->print_patient_info($patient_id);
			//$this->set('patientData',$patientData);
			//$this->set('patient',$patientData);

		}else if(!empty($this->request->data['DamaConsentForm'])){

			$this->uses =array('DamaConsentForm');
			if(!empty($this->request->data['DamaConsentForm']['suffering_from'])){
				//$splitFrom = explode(" ",$this->request->data['DamaConsentForm']['suffering_from']);
				$this->request->data['DamaConsentForm']['suffering_from'] = $this->DateFormat->formatDate2STD($this->request->data['DamaConsentForm']['suffering_from'],Configure::read('date_format'));
			}
			if(!empty($this->request->data['DamaConsentForm']['date'])){
				//$splitDate = explode(" ",$this->request->data['DamaConsentForm']['date']);
				$this->request->data['DamaConsentForm']['date'] = $this->DateFormat->formatDate2STD($this->request->data['DamaConsentForm']['date'],Configure::read('date_format'));
			}
			$this->DamaConsentForm->insertData($this->request->data['DamaConsentForm']);
			$errors = $this->DamaConsentForm->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			}else {
				$this->Session->setFlash(__('Record added successfully.', true, array('class'=>'message')));
				$this->redirect($this->referer());
			}
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			$this->redirect($this->referer());
		}

	}

	function dama_form_print($patient_id){
		$this->layout ='print_with_header' ;
		$this->dama_form($patient_id);
	}


	function death_certificate($patient_id=null){
		if($patient_id && empty($this->request->data['DeathCertificate'])){
			$this->uses = array('Patient','DeathCertificate','Person','DoctorProfile');
			$this->print_patient_info($patient_id);
			$DeathCertificate = $this->DeathCertificate->find('first',array('conditions'=>array('patient_id'=>$patient_id)));
			$this->data= $DeathCertificate ;

		}else if(!empty($this->request->data['DeathCertificate'])){
			$this->uses =array('DeathCertificate');
			if(!empty($this->request->data['DeathCertificate']['expired_on'])){
				$splitFrom =  $this->request->data['DeathCertificate']['expired_on'] ;
				$this->request->data['DeathCertificate']['expired_on'] = $this->DateFormat->formatDate2STD($splitFrom,Configure::read('date_format'));
			}
			if(!empty($this->request->data['DeathCertificate']['date_of_issue'])){
				$splitDate = $this->request->data['DeathCertificate']['date_of_issue'];
				$this->request->data['DeathCertificate']['date_of_issue'] = $this->DateFormat->formatDate2STD($splitDate,Configure::read('date_format'));
			}
			$this->DeathCertificate->insertData($this->request->data['DeathCertificate']);
			$errors = $this->DeathCertificate->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			}else {
				$this->Session->setFlash(__('Record added successfully.', true, array('class'=>'message')));
				$this->redirect($this->referer());
			}
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			$this->redirect($this->referer());
		}
	}

	function death_certificate_print($patient_id){
		$this->layout = 'print_with_header' ;
		$this->death_certificate($patient_id);
	}
	//EOF pankaj
	public function getConsultantChargesAll($id,$charges_type){
		$this->uses = array('Consultant');
		$allConsultantsCharges = $this->Consultant->getConsultantCharges($id,$charges_type);
		#pr($allConsultantsCharges);exit;
		echo json_encode($allConsultantsCharges['Consultant']['charges']);exit;
	}

	//BOF disgnosis template
	public function discharge_template($updateID=null) {
		$this->layout = 'ajax';
		$this->uses = array('DischargeTemplate');
		if (!empty($this->request->data['DischargeTemplate'])) {

			$this->request->data['DischargeTemplate']['user_id'] = $this->Auth->user('id');
			$this->request->data['DischargeTemplate']['location_id'] = $this->Session->read('locationid');
			$this->request->data['DischargeTemplate']['created_by'] = $this->Auth->user('id');
			$this->request->data['DischargeTemplate']['create_time'] = date("Y-m-d H:i:s");

			$this->DischargeTemplate->save($this->request->data);
			$errors = $this->DischargeTemplate->invalidFields();
			if(!empty($errors)) {
				$this->set('emptyTemplateText',true);
				$this->set("errors", $errors);
			}else {
				$this->Session->setFlash(__('Discharge advice template have been saved', true, array('class'=>'message')));
				$this->redirect("/billings/template_add/advice/null/".$updateID);
			}
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			$this->redirect("/billings/template_add/advice");
		}
	}
	/**
	 *
	 * @param $templateType
	 * @param $template_id
	 * @return unknown_type
	 */
	public function template_add($templateType=null,$template_id=null,$updateID=null){

		$this->uses = array('DischargeTemplate');
		$this->set('title_for_layout', __('Discharge Templates', true));
		$this->set('emptyTemplateText',false);
		if (!empty($this->request->data['DischargeTemplate'])) {
			$this->request->data['DischargeTemplate']['user_id'] = $this->Auth->user('id');
			$this->request->data['DischargeTemplate']['location_id'] = $this->Session->read('locationid');
			$this->request->data['DischargeTemplate']['created_by'] = $this->Auth->user('id');
			$this->request->data['DischargeTemplate']['create_time'] = date("Y-m-d H:i:s");
			$this->DischargeTemplate->save($this->request->data);
			$errors = $this->DischargeTemplate->invalidFields();
			if(!empty($errors)) {
				$this->set('emptyTemplateText',true);
				$this->set("errors", $errors);
			}else {
				$this->Session->setFlash(__('Discharge advice template have been saved', true, array('class'=>'message')));
				$this->redirect("/billings/template_add/advice/null/".$updateID);
			}

		}

		$this->DischargeTemplate->recursive = -1;
		if(!empty($_POST['searchStr'])){
			$strKey['DischargeTemplate.template_name like '] = "%".$_POST['searchStr']."%";
		}else{
			$strKey ='';
		}
			
		$data = $this->DischargeTemplate->find('all',array('conditions' => array('template_type'=>$templateType,'DischargeTemplate.is_deleted' => 0 ,$strKey)));
			
		$this->set(array('data'=>$data,'template_type'=>$templateType,'updateID'=>"templateArea-".$templateType));
		if(!empty($template_id)){
			$this->data = $this->DischargeTemplate->read(null,$template_id);
		}
			
		$this->render('template_add');
	}

	//fucntion to delete discharge temaplate only
	public function template_delete($templateType=null,$id=null){
		$this->uses = array('DischargeTemplate');
		$this->set('title_for_layout', __('- Delete Template', true));
		if (!$id) {
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect("/billings/template_add/advice/");
		}
		$this->DischargeTemplate->id = $id ;
		if ($this->DischargeTemplate->save(array('is_deleted'=>1))) {
			$this->Session->setFlash(__('Template successfully deleted'),'default',array('class'=>'message'));
			$this->redirect("/billings/template_add/advice/");
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect("/billings/template_add/advice/");
		}
	}

	/**
	 * fucntion to search template
	 * @param $templateType
	 * @param $template_id
	 * @return unknown_type
	 */
	public function template_search($templateType=null){
		//	 $this->layout = 'ajax';
		$this->uses = array('DischargeTemplate');
			
		$this->DischargeTemplate->recursive = -1;
			
		if(!empty($_POST['searchStr'])){
			$strKey['DischargeTemplate.template_name like '] = "%".$_POST['searchStr']."%";
		}else{
			$strKey ='';
		}
			
		$data = $this->DischargeTemplate->find('all',array('conditions' => array('DischargeTemplate.template_type'=>'advice','DischargeTemplate.is_deleted' =>0 ,$strKey)));
			
		$this->set(array('data'=>$data,'template_type'=>$templateType,'updateID'=>"templateArea-".$templateType));
		if(!empty($template_id)){
			$this->data = $this->DischargeTemplate->read(null,$template_id);
		}
	}

	/**
	 * fucntion to search template
	 * @param $templateType
	 * @param $template_id
	 * @return unknown_type
	 */
	public function template_text_search($template_id=null,$templateType=null){
		$this->uses = array('DischargeTemplate','DischargeTemplateText');
		//$this->layout = 'ajax';

		if(!empty($_POST['searchStr'])){
			$strKey['DischargeTemplateText.template_text like '] =  $_POST['searchStr']."%";
		}else{
			$strKey ='';
		}
			
		$data = $this->DischargeTemplateText->find('all',array('conditions' =>array('DischargeTemplateText.is_deleted' => 0,'DischargeTemplateText.template_id'=>$template_id,$strKey)));
		//retrive template details
		// $this->DischargeTemplate->recursive = -1;
		$templateData = $this->DischargeTemplate->read(null,$template_id);
		$this->set(array('data'=>$data,'template_id'=>$template_id,'template_data'=>$templateData,
				'updateID'=>"templateArea-advice"));
			
	}
	//function to add tempalte text
	/*
	 *
	* @param $template_id
	* @param $template_text_id
	* @param $updateID : DIV ID for placing return html
	* @return rendering HTML
	*/
	function add_template_text($template_id=null,$template_text_id=null,$updateID=null){
		//$this->layout = 'ajax';
		$this->uses = array('DischargeTemplateText','DischargeTemplate');
		$this->DischargeTemplate->recursive = -1;
		$this->set('emptyText',false);
			
		if(!empty($this->request->data)){
			if(empty($this->request->data['DischargeTemplateText']['template_text'])){
				$this->Session->setFlash(__('Please enter template text', true, array('class'=>'error')));
				$this->set('emptyText',true);
				if(!$template_id)  $template_id = $this->request->data['DischargeTemplateText']['template_id'];
			}else{
				$this->request->data['DischargeTemplateText']['created_by']	= $this->Session->read('userid');
				$this->request->data['DischargeTemplateText']['user_id']		= $this->Session->read('userid');
				$this->request->data['DischargeTemplateText']['location_id']	= $this->Session->read('locationid');
				$this->request->data["DischargeTemplateText"]["create_time"]	= date("Y-m-d H:i:s");
					
				$result = $this->DischargeTemplateText->save($this->request->data);
				$errors = $this->DischargeTemplateText->invalidFields();
				if(!empty($errors)) {
					$this->set("errors", $errors);
				}else{
					$this->Session->setFlash(__('Template saved', true, array('class'=>'message')));
					$this->redirect(array('action'=>'add_template_text',$this->request->data['DischargeTemplateText']['template_id']));
				}
			}
		}
		if(!empty($template_text_id)){
			$this->set('emptyText',true);//to display edit form for template text
			$this->data = $this->DischargeTemplateText->read(null,$template_text_id);
		}
			
		$data = $this->DischargeTemplateText->find('all',array('conditions' => array('DischargeTemplateText.is_deleted' => 0,'DischargeTemplateText.template_id'=>$template_id)));
		//retrive template details
		$templateData = $this->DischargeTemplate->read(null,$template_id);
		$this->set(array('data'=>$data,'template_id'=>$template_id,'template_data'=>$templateData,
				'updateID'=>"templateArea-advice"));
	}



	public function template_edit($id=null) {
		$this->layout = 'ajax';
		$this->uses = array('DischargeTemplate');
		if (!empty($this->request->data['DischargeTemplate'])) {

			$this->request->data['DischargeTemplate']['user_id'] = $this->Auth->user('id');
			$this->request->data['DischargeTemplate']['location_id'] = $this->Session->read('locationid');
			$this->request->data['DischargeTemplate']['created_by'] = $this->Auth->user('id');
			$this->request->data['DischargeTemplate']['create_time'] = date("Y-m-d H:i:s");
			$this->DischargeTemplate->save($this->request->data);
			$this->Session->setFlash(__('Discharge Advice template have been updated', true, array('class'=>'message')));
			$this->redirect("/billings/");
		}
		$this->DischargeTemplate->recursive = -1;

		$data = $this->DischargeTemplate->find('all',array('conditions' => array('DischargeTemplate.is_deleted' => 0)));
		$this->set('data', $data);
		$this->data = $this->DischargeTemplate->read(null,$id);
	}
	//EOF diagnosis template

	//BOF investigation template


	public function investigation_discharge_template($updateID=null) {
		$this->layout = 'ajax';
		$this->uses = array('DischargeTemplate');
		if (!empty($this->request->data['DischargeTemplate'])) {

			$this->request->data['DischargeTemplate']['user_id'] = $this->Auth->user('id');
			$this->request->data['DischargeTemplate']['location_id'] = $this->Session->read('locationid');
			$this->request->data['DischargeTemplate']['created_by'] = $this->Auth->user('id');
			$this->request->data['DischargeTemplate']['create_time'] = date("Y-m-d H:i:s");
			$this->DischargeTemplate->save($this->request->data);
			$this->Session->setFlash(__('Discharge advice template have been saved', true, array('class'=>'message')));
			$this->redirect("/billings/investigation_template_add/investigation/null/".$updateID);
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			$this->redirect("/billings/investigation_template_add/investigation");
		}
	}


	/**
	 *
	 * @param $templateType
	 * @param $template_id
	 * @return unknown_type
	 */
	public function investigation_template_add($templateType=null,$template_id=null,$updateID=null){

		//	 $this->layout = 'ajax';
		$this->uses = array('DischargeTemplate');
		$this->set('title_for_layout', __('Discharge Templates', true));
		if (!empty($this->request->data['DischargeTemplate'])) {

			$this->request->data['DischargeTemplate']['user_id'] = $this->Auth->user('id');
			$this->request->data['DischargeTemplate']['location_id'] = $this->Session->read('locationid');
			$this->request->data['DischargeTemplate']['created_by'] = $this->Auth->user('id');
			$this->request->data['DischargeTemplate']['create_time'] = date("Y-m-d H:i:s");
			$this->DischargeTemplate->save($this->request->data);
			$errors = $this->DischargeTemplate->invalidFields();
			if(!empty($errors)) {
				$this->set('emptyTemplateText',true);
				$this->set("errors", $errors);
			}else {
				$this->Session->setFlash(__('Discharge investigation template have been saved', true, array('class'=>'message')));
				$this->redirect("/billings/investigation_template_add/investigation/null/".$updateID);
			}

		}
		$this->DischargeTemplate->recursive = -1;
		if(!empty($_POST['searchStr'])){
			$strKey['DischargeTemplate.template_name like '] = "%".$_POST['searchStr']."%";
		}else{
			$strKey ='';
		}

		$data = $this->DischargeTemplate->find('all',array('conditions' => array('template_type'=>$templateType,'DischargeTemplate.is_deleted' => 0 ,$strKey)));

		$this->set(array('data'=>$data,'template_type'=>$templateType,'updateID'=>"templateArea-investigation"));
		if(!empty($template_id)){
			$this->data = $this->DischargeTemplate->read(null,$template_id);

		}

		$this->render('investigation_template_add');
	}

	/**
	 * fucntion to search template
	 * @param $templateType
	 * @param $template_id
	 * @return unknown_type
	 */
	public function investigation_template_search($templateType=null){
		//	 $this->layout = 'ajax';
		$this->uses = array('DischargeTemplate');

		$this->DischargeTemplate->recursive = -1;

		if(!empty($_POST['searchStr'])){
			$strKey['DischargeTemplate.template_name like '] =  $_POST['searchStr']."%";
		}else{
			$strKey ='';
		}

		$data = $this->DischargeTemplate->find('all',array('conditions' => array('DischargeTemplate.template_type'=>'investigation', 'DischargeTemplate.is_deleted' =>0 ,$strKey)));

		$this->set(array('data'=>$data,'template_type'=>$templateType,'updateID'=>"templateArea-investigation"));
		if(!empty($template_id)){
			$this->data = $this->DischargeTemplate->read(null,$template_id);
		}
	}

	/**
	 * fucntion to search template
	 * @param $templateType
	 * @param $template_id
	 * @return unknown_type
	 */
	public function investigation_template_text_search($template_id=null,$templateType=null){
		$this->uses = array('DischargeTemplate','DischargeTemplateText');
		//$this->layout = 'ajax';
			
		if(!empty($_POST['searchStr'])){
			$strKey['DischargeTemplateText.template_text like '] =  $_POST['searchStr']."%";
		}else{
			$strKey ='';
		}

		$data = $this->DischargeTemplateText->find('all',array('conditions' =>array('DischargeTemplateText.is_deleted' => 0,'DischargeTemplateText.template_id'=>$template_id,$strKey)));
		//retrive template details
		// $this->DischargeTemplate->recursive = -1;
		$templateData = $this->DischargeTemplate->read(null,$template_id);
		$this->set(array('data'=>$data,'template_id'=>$template_id,'template_data'=>$templateData,
				'updateID'=>"templateArea-investigation"));

	}
	//function to add tempalte text
	/*
	 *
	* @param $template_id
	* @param $template_text_id
	* @param $updateID : DIV ID for placing return html
	* @return rendering HTML
	*/
	function investigation_add_template_text($template_id=null,$template_text_id=null,$updateID=null){
		//$this->layout = 'ajax';
		$this->uses = array('DischargeTemplateText','DischargeTemplate');
		$this->DischargeTemplate->recursive = -1;
		$this->set('emptyText',false);
			
		if(!empty($this->request->data)){
			if(empty($this->request->data['DischargeTemplateText']['template_text'])){
				$this->Session->setFlash(__('Please enter template text', true, array('class'=>'error')));
				$this->set('emptyText',true);
				if(!$template_id)  $template_id = $this->request->data['DischargeTemplateText']['template_id'];
			}else{
				$this->request->data['DischargeTemplateText']['created_by']	= $this->Session->read('userid');
				$this->request->data['DischargeTemplateText']['user_id']		= $this->Session->read('userid');
				$this->request->data['DischargeTemplateText']['location_id']	= $this->Session->read('locationid');
				$this->request->data["DischargeTemplateText"]["create_time"]	= date("Y-m-d H:i:s");

				$result = $this->DischargeTemplateText->save($this->request->data);
				$errors = $this->DischargeTemplateText->invalidFields();
				if(!empty($errors)) {
					$this->set("errors", $errors);
				}else{
					$this->Session->setFlash(__('Template saved', true, array('class'=>'message')));
					$this->redirect(array('action'=>'investigation_add_template_text',$this->request->data['DischargeTemplateText']['template_id']));
				}
			}
		}
		if(!empty($template_text_id)){
			$this->set('emptyText',true);//to display edit form for template text
			$this->data = $this->DischargeTemplateText->read(null,$template_text_id);
		}
			
		$data = $this->DischargeTemplateText->find('all',array('conditions' => array('DischargeTemplateText.is_deleted' => 0,'DischargeTemplateText.template_id'=>$template_id)));
		//retrive template details
		$templateData = $this->DischargeTemplate->read(null,$template_id);
		$this->set(array('data'=>$data,'template_id'=>$template_id,'template_data'=>$templateData,
				'updateID'=>"templateArea-investigation"));
	}



	public function investigation_template_edit($id=null) {
		$this->layout = 'ajax';
		$this->uses = array('DischargeTemplate');
		if (!empty($this->request->data['DischargeTemplate'])) {

			$this->request->data['DischargeTemplate']['user_id'] = $this->Auth->user('id');
			$this->request->data['DischargeTemplate']['location_id'] = $this->Session->read('locationid');
			$this->request->data['DischargeTemplate']['created_by'] = $this->Auth->user('id');
			$this->request->data['DischargeTemplate']['create_time'] = date("Y-m-d H:i:s");
			$this->DischargeTemplate->save($this->request->data);
			$this->Session->setFlash(__('Discharge investigation template have been updated', true, array('class'=>'message')));
			$this->redirect("/billings/");
		}
		$this->DischargeTemplate->recursive = -1;
			
		$data = $this->DischargeTemplate->find('all',array('conditions' => array('DischargeTemplate.is_deleted' => 0)));
		$this->set('data', $data);
		$this->data = $this->DischargeTemplate->read(null,$id);
	}
	//EOF investigation template

	//fucntion to delete discharge temaplate investigation only
	public function investigation_template_delete($templateType=null,$id=null,$updateID=null){
		$this->uses = array('DischargeTemplate');
		$this->layout = 'ajax';
		if(!empty($id)){
			$this->DischargeTemplate->id= $id ;
			$this->DischargeTemplate->save(array('is_deleted'=>1));
			$this->Session->setFlash(__('Doctor template have been deleted', true, array('class'=>'message')));
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
		}
		//$this->redirect("/doctor_templates/");
		//$this->redirect("/doctor_templates/add/".$templateType."/null/".$updateID);
		$this->redirect("/billings/investigation_template_add/investigation/null/".$updateID);
	}
	public function getAdmitDays($admitDate){
		$date = explode(" ", $admitDate);
		$datetime1 = date_create($date[0]);
		$datetime2 = date_create(date('Y-m-d'));
		$interval = date_diff($datetime1, $datetime2);
		$days = $interval->format('%a');
		return $days+1;
	}

	public function getWardDays($patientId){
		$this->uses = array('WardPatient');
		$data = $this->WardPatient->find('all',array('conditions'=>array('location_id'=>$this->Session->read('locationid'),'patient_id'=>$patientId)));
		#pr($data);exit;
		$daysArray=array();
		foreach($data as $wardDays){
			if($wardDays['WardPatient']['out_date']!=''){
				$inDate = explode(" ", $wardDays['WardPatient']['in_date']);
				$inDate=$inDate[0];
				$outDate=explode(" ", $wardDays['WardPatient']['out_date']);
				$outDate=$outDate[0];
					
				$datetime1 = date_create($inDate);
				$datetime2 = date_create($outDate);
				$interval = date_diff($datetime1, $datetime2);
					
				$days = $interval->format('%a');
				$daysArray[$wardDays['WardPatient']['ward_id']]=$days;
			}else{
				$inDate = explode(" ", $wardDays['WardPatient']['in_date']);
				$inDate=$inDate[0];
				$outDate=date("Y-m-d");
					
				$datetime1 = date_create($inDate);
				$datetime2 = date_create($outDate);
				$interval = date_diff($datetime1, $datetime2);
					
				$days = $interval->format('%a');
				$daysArray[$wardDays['WardPatient']['ward_id']]=$days+1;
			}
		}#echo'<pre>';print_r($daysArray);exit;
		return $daysArray;
	}

	public function getSurgeryAdmitDays($patientId,$surgerydate){
		$this->uses = array('WardPatient');
		$surgeryCheck=0;
		$data = $this->WardPatient->find('all',array('conditions'=>array('location_id'=>$this->Session->read('locationid'),'patient_id'=>$patientId)));
		#pr($data);exit;
		$daysArray=array();
		foreach($data as $wardDays){
			if($wardDays['WardPatient']['out_date']!=''){
				$inDate = explode(" ", $wardDays['WardPatient']['in_date']);
				$inDate=$inDate[0];
					
				if($surgerydate <= $wardDays['WardPatient']['out_date']){
					$outDate=$surgerydate;
					$surgeryCheck =1;
				}else{
					$outDate=explode(" ", $wardDays['WardPatient']['out_date']);
					$outDate=$outDate[0];
				}
					
					
				$datetime1 = date_create($inDate);
				$datetime2 = date_create($outDate);
				$interval = date_diff($datetime1, $datetime2);
					
				$days = $interval->format('%a');
				$daysArray[$wardDays['WardPatient']['ward_id']]=$days;
				if($surgeryCheck ==1){
					break;
				}
			}else{
				$inDate = explode(" ", $wardDays['WardPatient']['in_date']);
				$inDate=$inDate[0];
					
				if($surgerydate <= date("Y-m-d")){
					$outDate=$surgerydate;
					$surgeryCheck =1;
				}else{
					$outDate=date("Y-m-d");
				}
					
					
				$datetime1 = date_create($inDate);
				$datetime2 = date_create($outDate);
				$interval = date_diff($datetime1, $datetime2);
					
				$days = $interval->format('%a');
				$daysArray[$wardDays['WardPatient']['ward_id']]=$days+1;
				if($surgeryCheck ==1){
					break;
				}
			}
		}#echo'<pre>';print_r($daysArray);exit;
		return $daysArray;
	}

	//return registration charges as per configuration.
	public function getRegistrationCharges($days,$hospitalType,$tariffStandardId){

		/* $this->loadModel('TariffAmount');
		 $this->loadModel('Patient');
		//skip registration charges if the optino is selected
		$this->Patient->unBindModel(array('hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patientData = $this->Patient->find('first',array('fields'=>array('treatment_type','admission_type'),'conditions'=>array('Patient.id'=>$this->params['pass'][0])));
			

		if(($patientData['Patient']['treatment_type']===0 || empty($patientData['Patient']['treatment_type'])) && ($patientData['Patient']['admission_type']=='OPD'))
			return 0 ;

		$registrationRateData=$this->TariffAmount->find('first',array('conditions'=>array('tariff_list_id'=>1,'tariff_standard_id'=>$tariffStandardId)));

		if($hospitalType=='NABH'){
		$registrationRate=$registrationRateData['TariffAmount']['nabh_charges'];
		}else{
		$registrationRate=$registrationRateData['TariffAmount']['non_nabh_charges'];

		}

		return $registrationRate;

		} */
		$this->loadModel('Billing') ;
		return $this->Billing->getRegistrationCharges($hospitalType,$tariffStandardId);
			

	}

	public function getRegistrationChargesWithMOA($days,$hospitalType,$tariffStandardId){
		#echo $tariffStandardId;exit;
		#pr($days);exit;
		#$tariffStandardId=4;
		$this->loadModel('TariffAmount');
		$this->loadModel('TariffList');
		$tariffListId=$this->TariffList->getServiceIdByName(Configure::read('RegistrationCharges'));//get tariff list id

		$this->TariffAmount->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array('foreignKey' => 'tariff_list_id'),

				)),false);
		$registrationRateData=$this->TariffAmount->find('first',array('conditions'=>array('tariff_list_id'=>$tariffListId,'tariff_standard_id'=>$tariffStandardId)));
		#echo '<pre>';print_r($registrationRateData);exit;
		/*if($hospitalType=='NABH'){
		 $registrationRate=$registrationRateData['TariffAmount']['nabh_charges'];
		 }else{
		 $registrationRate=$registrationRateData['TariffAmount']['non_nabh_charges'];
		}*/
			
		return $registrationRateData;
	}

	public function getDoctorChargesWithMOA($days,$hospitalType,$tariffStandardId,$patientType='',$treatment_type){
		$this->loadModel('TariffAmount');
		$this->loadModel('TariffList');
		$tariffListId=$this->TariffList->getServiceIdByName(Configure::read('DoctorsCharges'));//get tariff list id

		$this->TariffAmount->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array('foreignKey' => 'tariff_list_id'),

				)),false);
		#$doctorRateData=$this->TariffAmount->find('first',array('conditions'=>array('tariff_list_id'=>2,'tariff_standard_id'=>$tariffStandardId)));
		if($patientType=='OPD'){
			$doctorRateData = $this->TariffAmount->find('first',array('fields'=>array('TariffAmount.nabh_charges','TariffAmount.non_nabh_charges'),'conditions'=>array('TariffAmount.tariff_list_id'=>$treatment_type,
					'TariffAmount.tariff_standard_id'=>$tariffStandardId,'TariffAmount.location_id'=>$this->Session->read('locationid'))));
			$days=1;

		}else{
			$doctorRateData=$this->TariffAmount->find('first',array('conditions'=>array('tariff_list_id'=>$tariffListId,'tariff_standard_id'=>$tariffStandardId)));
		}
		return $doctorRateData;
	}

	public function getNursingChargesWithMOA($days,$hospitalType,$tariffStandardId){
		$this->loadModel('TariffAmount');
		$this->loadModel('TariffList');
		$tariffListId=$this->TariffList->getServiceIdByName(Configure::read('NursingCharges'));//get tariff list id

		$this->TariffAmount->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array('foreignKey' => 'tariff_list_id'),

				)),false);
		$nursingRateData=$this->TariffAmount->find('first',array('conditions'=>array('tariff_list_id'=>$tariffListId,'tariff_standard_id'=>$tariffStandardId)));
			
		return $nursingRateData;
	}

	

	public function getNursingRate($days,$hospitalType,$tariffStandardId){
		if($this->Session->read('website.instance'=='vadodara')) return false ;
		$this->loadModel('TariffAmount');
		$this->loadModel('TariffList');
		$tariffListId=$this->TariffList->getServiceIdByName(Configure::read('NursingCharges'));//get tariff list id

		$nursingRateData=$this->TariffAmount->find('first',array('conditions'=>array('tariff_list_id'=>$tariffListId,'tariff_standard_id'=>$tariffStandardId)));
			
		if($hospitalType=='NABH'){
			$nursingRate=$nursingRateData['TariffAmount']['nabh_charges'];
		}else{
			$nursingRate=$nursingRateData['TariffAmount']['non_nabh_charges'];
		}
		return $nursingRate;
	}

	public function getDoctorRate($days,$hospitalType,$tariffStandardId,$patientType='',$treatment_type=null,$patient_id){
		/* $this->loadModel('TariffAmount');
		 $this->loadModel('TariffList');
		if($patientType=='OPD'){
		$doctorRateData = $this->TariffAmount->find('first',array('fields'=>array('TariffAmount.nabh_charges','TariffAmount.non_nabh_charges'),
				'conditions'=>array('TariffAmount.tariff_list_id'=>$treatment_type,
						'TariffAmount.tariff_standard_id'=>$tariffStandardId,'TariffAmount.location_id'=>$this->Session->read('locationid'))));
		$days=1;
		}else{ //for IPD charges change tariff_list_id as per required service
		$doctorRateData=$this->TariffAmount->find('first',array('conditions'=>array('tariff_list_id'=>2,'tariff_standard_id'=>$tariffStandardId)));
		}
		if($hospitalType=='NABH'){
		$doctorRate=$doctorRateData['TariffAmount']['nabh_charges'];
		}else{
		$doctorRate=$doctorRateData['TariffAmount']['non_nabh_charges'];
		}
		return $doctorRate; */

		$this->loadModel('Billing') ;
		return $this->Billing->getDoctorRate($days,$hospitalType,$tariffStandardId,$patientType,$treatment_type,$patient_id);


	}

	public function getSameDay($patientAdmitDate='',$patientId){
		$this->loadModel('WardPatient');
		$wardData = $this->WardPatient->find('first',array('conditions'=>array('patient_id'=>$patientId,'location_id'=>$this->Session->read('locationid'))));
		#pr($wardData);exit;
		$wardId=$wardData['WardPatient']['ward_id'];
		return $ward[$wardId]=1;
	}


	/*
	 * @name = getSurgeryCharges
	*
	* */

	public function getSurgeryCharges($surgeryArray = null){
		$surgeries=$surgeryArray;
			
		// Count Sergery Charges
		$totalSergeryCost = '';
		$packageDays[] = '';
		$lastSergeryDate = '';
		$i = 0;
		$days=0;
		$surgery=array();
		foreach($surgeryArray as $charges){
			$surgery['surgery'][$i]['amount'] = $charges['surgeryAmount'];
			$surgery['surgery'][$i]['name'] = $charges['name'];
			$nextDay[$i] = date('Y-m-d H:i:s',strtotime($charges['surgeryScheduleDate']."+".$charges['unitDays']." day")) ;
			if($i>0){
				$surgeryInt= $this->DateFormat->dateDiff($nextDay[$i-1],$charges['surgeryScheduleDate']);
				$days  += $surgeryInt->days ;
			}
			$i++;
		}
		$surgery['days'] = $days;
		$endVal = end($surgeryArray);
		$endValSplit = explode(" ",$endVal['surgeryScheduleDate']);

		//calculate diff between first n last surgery
		if(count($surgeryArray)>0){
			$firstValSplit = explode(" ",$surgeryArray[0]['surgeryScheduleDate']);

			$surgeryDiff = $this->DateFormat->dateDiff($firstValSplit[0],$endValSplit[0]);
			$extraDays = $this->is_In_Out_Before_10_AM($surgeryArray[0]['surgeryScheduleDate'],$endVal['surgeryScheduleDate']);
			$surgery['days'] = (int)$surgeryDiff->days-(int)$days+$extraDays;
		}

		if(strtotime(max($nextDay))>date('Y-m-d H:i:s')){
			$maxDate  =explode(" ",date('Y-m-d'));
		}else{
			$maxDate  =explode(" ",max($nextDay));
		}

		$validity = $this->DateFormat->dateDiff($endValSplit[0],$maxDate[0]);

		$surgery['validity'] = $validity->days;

		return $surgery;

	}



	/*Arguments:
	 * patient_id     : patients id
	* $surgeryDate   : date of surgery
	* $surgeryAmount : Amount of surgery package
	* $packageDays	  : total package days
	**/
	public function getBedCharge($patientId=null,$surgeries=array(),$tariffStandardId=null,$location_id=null){
		#echo $tariffStandardId.'here';exit;
		$this->uses = array('WardPatient');
		// $packageDays =1 ;
		# echo  $surgeryDate;
		/* $surgeries[0]=array('name'=>'Heart Surgery','surgeryScheduleDate'=>'2012-04-21 13:45:00','surgeryAmount'=>'2000','unitDays'=>'3');
		 $surgeries[1]=array('name'=>'By Pass','surgeryScheduleDate'=>'2012-04-23 14:00:00','surgeryAmount'=>'1000','unitDays'=>'1');
		 $surgeries[2]=array('name'=>'testis','surgeryScheduleDate'=>'2012-04-24 15:20:00','surgeryAmount'=>'3000','unitDays'=>'6');
		 $surgeries[3]=array('name'=>'Leg Surgery1','surgeryScheduleDate'=>'2012-04-27 16:10:00','surgeryAmount'=>'4000','unitDays'=>'1');
		 $surgeries[4]=array('name'=>'Leg Surgery2','surgeryScheduleDate'=>'2012-04-28 17:30:00','surgeryAmount'=>'4000','unitDays'=>'1');

		*/
		if(empty($location_id)){
			$location_id = $this->Session->read('locationid');
		}
		$this->WardPatient->bindModel(array(
				'belongsTo' => array(
						'Ward' =>array('foreignKey' => 'ward_id'),
						'TariffAmount' =>array('foreignKey' => false,'conditions'=>array('Ward.tariff_list_id=TariffAmount.tariff_list_id' )),

				)),false);
			
		$wardData = $this->WardPatient->find('all',array('group'=>array('WardPatient.id'),'conditions'=>array('patient_id'=>$patientId,'WardPatient.location_id'=>$location_id,'TariffAmount.tariff_standard_id'=>$tariffStandardId)));

		//BOF calculatation
		$finalremTime=array();
		$wardCost=array();
		$fourHrOutDate ='';
		//$surgeryDate = "2012-04-19 12:23:00";//surgery date
		//$surgeryAmount = 20000;

		$hasSurgery =false ;#echo'<pre>';print_r($wardData);exit;
		foreach($wardData as $wardKey =>$wardValue){
			$subArray =array();
			//if(!isset($wardCost['surgery-cost'])){
			if($this->Session->read('hospitaltype')=='NABH'){
				$charge   = 	(int)$wardValue['TariffAmount']['nabh_charges']  ;
			}else{
				$charge   = 	(int)$wardValue['TariffAmount']['non_nabh_charges']  ;
			}
			$wardCost[$wardKey]['name'] = $wardValue['Ward']['name'];
			//If block for those wards whose IN n OUT date has been saved in databse
			if(!empty($wardValue['WardPatient']['out_date'])){
				//calculating days in a ward
				$slpittedIn = explode(" ",$wardValue['WardPatient']['in_date']) ;
				$slpittedOut = explode(" ",$wardValue['WardPatient']['out_date']) ;

				//apply surgery package cost
				//compare only date
				//if surgery

					
				foreach($surgeries AS $surgeryKey){//surgery array
					$kk  = explode(" ",$surgeryKey['surgeryScheduleDate']);
					if(strtotime($kk[0])>=strtotime($slpittedIn[0]) && strtotime($kk[0]) <= strtotime($slpittedOut[0])) {
						$subArray[]  = $surgeryKey;
					}
				}
					
				//pr($subArray);
				//exit;
				if(!empty($subArray)){
					$surgeryCostArr = $this->getSurgeryCharges($subArray);

					if(!empty($surgeryCostArr)){
						$daysToReduce = $surgeryCostArr['days'];
							
						$packageDays = $surgeryCostArr['validity'];
						$wardCost[$wardKey]["surgery-cost"] = $surgeryCostArr['surgery'];
					}
				}else{
					$daysToReduce = 0;
					$packageDays = 0;
				}
					
				//EOF surgery

					
				$interval = $this->DateFormat->dateDiff($slpittedIn[0],$slpittedOut[0]);

				//checking if patient admitted or discharge before 10AM
				$extraDays = $this->is_In_Out_Before_10_AM($wardValue['WardPatient']['in_date'],$wardValue['WardPatient']['out_date']);
					
				$timeDay 	= (int)$interval->days + $extraDays ;
					
				if($timeDay==$daysToReduce && ($timeDay!=0 && $daysToReduce!=0)){
					$timeDay 	= (int)$interval->days + (int)($extraDays)-$daysToReduce;
					if($timeDay>=$packageDays){
						$timeDay = $timeDay -$packageDays;
					}else{
						$timeDay =0 ;
						$packageDays = $packageDays- $timeDay ;
					}

				}else{
					$timeDay 	= (int)$interval->days + (int)($extraDays)-$daysToReduce;
				}
					

				//	$timeHr 	= (int)$interval->h;
					
				//calculating time diff
				$timeInterval = $this->DateFormat->dateDiff($wardValue['WardPatient']['in_date'],$wardValue['WardPatient']['out_date']);
				$timeHr 	= (int)$timeInterval->h;
					
				if($timeDay > 0 && $timeInterval->days >0){

					if(strtotime($slpittedIn[0]) == strtotime($slpittedOut[0])){

						$extraDays = $this->is_In_Out_Before_10_AM($wardValue['WardPatient']['in_date'],$wardValue['WardPatient']['in_date'],$surgeryDate);
						if($extraDays==0) $calExtraDays =1; //added if extradays is 0
						$wardCost[$wardKey]['cost']   = 	$charge * (int)$extraDays ;

						//maintaing var to skip this day
						$fourHrOutDate = $wardValue['WardPatient']['out_date'] ;
							
					}else{

						if(isset($wardData[$wardKey+1]) && $packageDays<1){
							//price of previous ward
							if($this->Session->read('hospitaltype')=='NABH'){
								$nextCharge   = 	(int)$wardData[$wardKey+1]['TariffAmount']['nabh_charges']  ;
							}else{
								$nextCharge   = 	(int)$wardData[$wardKey+1]['TariffAmount']['non_nabh_charges'];
							}

							//calculating highest pricesable ward of current day.
							if($nextCharge > $charge) {
								$timeDay-- ;
							}else {
								$fourHrOutDate = $wardValue['WardPatient']['out_date'] ;
							}
							//maintaing var to skip this day
						}
							
						$wardCost[$wardKey]['cost']   = 	$charge * (int)$timeDay ;
					}
				}else{
					if($timeHr >= 4 && $wardKey>0){ //calculating the hour spend in ward
						//price of previous ward
						if($this->Session->read('hospitaltype')=='NABH'){
							$previousCharge   = 	(int)$wardData[$wardKey-1]['TariffAmount']['nabh_charges']  ;
						}else{
							$previousCharge   = 	(int)$wardData[$wardKey-1]['TariffAmount']['non_nabh_charges'];
						}

						//calculating highest pricesable ward of current day.
						if($extraDays==0) $calExtraDays =1;//added if extradays is 0
							
						if($previousCharge > $charge){
							$wardCost[$wardKey]['cost']   = 	$previousCharge ;

						}
						else{
							$wardCost[$wardKey]['cost']   = 	$charge ;
						}

						//maintaing var to skip this day
						$fourHrOutDate = $wardValue['WardPatient']['out_date'] ;
							
					}else{
						if($timeHr < 4){#echo 'here'.$wardKey;exit;
							$wardCost[$wardKey]['cost']   = 0 ;
							$timeDay = 0;
							//maintaing var to skip this day
							$fourHrOutDate = $wardValue['WardPatient']['out_date'] ;
						}else{

							if(isset($wardData[$wardKey+1])){

								//price of previous ward
								if($this->Session->read('hospitaltype')=='NABH'){
									$nextCharge   = 	(int)$wardData[$wardKey+1]['TariffAmount']['nabh_charges']  ;
								}else{
									$nextCharge   = 	(int)$wardData[$wardKey+1]['TariffAmount']['non_nabh_charges'];
								}
									
								//calculating highest pricesable ward of current day.
								if($nextCharge > $charge) {
									$wardCost[$wardKey]['cost']   = 	0 ;
									$timeDay   = 	0 ;
								}else {
									if($extraDays) {
										$wardCost[$wardKey]['cost']   = 	$charge*$extraDays ;
										$timeDay   = 	1 ;
									}else{
										$wardCost[$wardKey]['cost']   = 	$charge ;
										$timeDay   = 	1 ;
									}
									$fourHrOutDate = $wardValue['WardPatient']['out_date'] ;
								}
								//maintaing var to skip this day

							}else{

								$wardCost[$wardKey]['cost']   = 	$charge*$extraDays ; //condition for a patient admitted only for single day with IN and OUT date avalable in DB
								//maintaing var to skip this day
								$fourHrOutDate = $wardValue['WardPatient']['out_date'] ;
							}
						}

					}

				} $wardCost[$wardKey]['days'] = $timeDay ;
			}else{ //probably for last ward

				if(!empty($wardValue['WardPatient']['out_date'])){
					$outDate = $wardValue['WardPatient']['out_date'];
				}else{
					$outDate = date("Y-m-d H:i:s"); //current date
				}
				#echo $wardValue['WardPatient']['in_date'];exit;
				//BOF surgery packages
				//calculating days in a ward
				$slpittedIn = explode(" ",$wardValue['WardPatient']['in_date']) ;
				$slpittedOut = explode(" ",$outDate) ;
					
				//apply surgery package cost
				//compare only date
				//if surgery
				foreach($surgeries AS $surgeryKey){//surgery array
					$kk  = explode(" ",$surgeryKey['surgeryScheduleDate']);
					if(strtotime($kk[0])>strtotime($slpittedIn[0]) && strtotime($kk[0]) <= strtotime($slpittedOut[0])) {
						$subArray[]  = $surgeryKey;
					}
				}//eof for
				if(!empty($subArray)){
					$surgeryCostArr = $this->getSurgeryCharges($subArray);
					if(!empty($surgeryCostArr)){
						$daysToReduce = $surgeryCostArr['days'];
						$packageDays = $surgeryCostArr['validity'];
						$wardCost[$wardKey]["surgery-cost"] = $surgeryCostArr['surgery'];
					}
				}else{
					$daysToReduce = 0;
					$packageDays = 0;
				}
				//EOF surgery
				$interval = $this->DateFormat->dateDiff($slpittedIn[0],$slpittedOut[0]);
				//checking if patient admitted or discharge before 10AM
				$extraDays = $this->is_In_Out_Before_10_AM($wardValue['WardPatient']['in_date'],$outDate);
				$timeDay 	= (int)$interval->days + $extraDays ;

				/*if($timeDay==$daysToReduce){
				 continue ; //skip further calculation because of surgery package is been selected by patient.
				}else{ */
				$timeDay 	= (int)$interval->days + (int)($extraDays)-$daysToReduce;
					
				if($timeDay>=$packageDays){
					$timeDay = $timeDay -$packageDays;
				}else{
					$timeDay =0 ;
					$packageDays = $packageDays- $timeDay ;
				}
					
				//	}
					
				//EOF surgery packages
					
					
				//checking if patient admitted or discharge before 10AM
				//$extraDays = $this->is_In_Out_Before_10_AM($wardValue['WardPatient']['in_date'],$outDate);
				//$interval = $this->DateFormat->dateDiff($wardValue['WardPatient']['in_date'],$outDate);
				//EOF cal
				//$timeDay 	= (int)$interval->d  + $extraDays;
				$timeHr 	= (int)$interval->h;
				$timeMin 	= (int)$interval->i;
					
				if($timeDay > 0){
					if($fourHrOutDate == $wardValue['WardPatient']['in_date'] ){
						$timeDay = $timeDay-1 ;
					}
					$wardCost[$wardKey]['cost']   = 	$charge * (int)$timeDay ;
				}else if($timeHr > 0 || $timeMin > 0){ //for current day
					if($fourHrOutDate == $wardValue['WardPatient']['in_date']){

					}else{
						$wardCost[$wardKey]['cost']   = 	$charge + ($charge*$extraDays) ;
					}
				}
				$wardCost[$wardKey]['days'] = $timeDay ;
			}
			//}//EOF surgery-cost check

		}//EOF for loop
		#echo'<pre>';print_r($wardCost);
		#pr($wardCost);
		#exit;
		return $wardCost;
		//EOF calculate pay
	}

	//function to check whether the patient added before 10AM and
	function is_In_Out_Before_10_AM($inDate=null,$outDate=null,$surgeryDate=null){
		$days = 0;

		if(!empty($inDate)){
			if(strlen($inDate)>10){
				$entryHr = substr($inDate,-8,2);
				$days = ($entryHr >= 10)?0:1 ;
			}
		}
		if(!empty($outDate)){
			//if(empty($surgeryDate)){
			if(strlen($inDate)>10){
				$entryHr = substr($outDate,-8,2);
				$days += ($entryHr <= 10)?0:1 ;
			}
			//}
		}
		return (int)$days ;

	}

	function costWithSurgeryPackage($surgeryDate,$surgeryAmount=null,$inDate=null,$outDate=null){
		$splitSurgeryDate = explode(" ",$surgeryDate);
		$splitOutDate     = explode(" ",$outDate);
		$splitInDate     = explode(" ",$inDate);
			
		if(strtotime($splitSurgeryDate[0]) <= strtotime($splitOutDate[0])){
			if(strtotime($splitSurgeryDate[0]) == strtotime($splitOutDate[0])){
				return $this->is_In_Out_Before_10_AM($surgeryDate) ;
			}else{
				if(strtotime($splitSurgeryDate[0]) == strtotime($splitInDate[0])){
					$surgeryInt= $this->DateFormat->dateDiff($splitInDate[0],$splitOutDate[0]);
					//return $this->is_In_Out_Before_10_AM($inDate) ;
					return (int)$surgeryInt->d ;
				}else{
					$surgeryInt= $this->DateFormat->dateDiff($splitSurgeryDate[0],$splitOutDate[0]);
					return (int)$surgeryInt->d + $this->is_In_Out_Before_10_AM($surgeryDate);
				}
			}
		}
		return 0 ;
		//EOF surgery package cost
	}

	function generateSavedReceipt($id){
		$this->uses = array('Bed','FinalBilling','Facility',
				'InsuranceCompany','SubServiceDateFormat','ServiceBill','Corporate','Service','DoctorProfile','Person','Consultant','User',
				'Patient','ConsultantBilling','SubService','PharmacySalesBill','PharmacySalesBillDetail','InventoryPharmacySalesReturn',
				'InventoryPharmacySalesReturnsDetail','OptAppointment');

		$locationFooter = $this->General->billingFooter($this->Session->read('locationid'));
		$this->set('locationFooter',$locationFooter);
			
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment'),
						'TariffStandard' =>array('foreignKey'=>'tariff_standard_id'))
				,'hasOne'=>array('Diagnosis'=>array('foreignKey'=>'patient_id','fields'=>array('Diagnosis.final_diagnosis')))));
			
		$patient_details  = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$id)));
		$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);
		$formatted_address = $this->setAddressFormat($UIDpatient_details['Person']);
		$this->set(array('person'=>$UIDpatient_details,'photo' => $UIDpatient_details['Person']['photo'],'address'=>$formatted_address,
				'patient'=>$patient_details,'id'=>$id,'treating_consultant'=>$this->User->getDoctorByID($patient_details['Patient']['doctor_id'])));

		$creditTypeId = $patient_details['Patient']['credit_type_id'];
		if($creditTypeId == 1){
			$corporateId = $patient_details['Patient']['corporate_id'];
		}elseif($creditTypeId == 2){
			$corporateId = $patient_details['Patient']['insurance_company_id'];
		}else{
			$corporateId = 0;
		}
		if($creditTypeId == 1){
			$corporates = $this->Corporate->find('list',array('fields'=>array('id','name'),'conditions'=>array('Corporate.is_deleted'=>0)));
			$corporateEmp = $corporates[$corporateId];
		}else if($creditTypeId == 2){
			$corporates = $this->InsuranceCompany->find('list',array('fields'=>array('id','name'),'conditions'=>array('InsuranceCompany.is_deleted'=>0)));
			$corporateEmp = $corporates[$corporateId];
		}else{
			$corporateEmp ='Private';
		}
		$this->set('corporateEmp',$corporateEmp);
		$this->set('primaryConsultant',$this->User->getDoctorByID($patient_details['Patient']['doctor_id']));

		$this->loadModel('FinalBilling');
		$this->FinalBilling->bindModel(array('hasMany'=>array('DiscountByCredit'=>array('foreingKey'=>'final_billing_id'),
				)));

		$finalBillingData = $this->FinalBilling->find('first',array('conditions'=>array('location_id'=>$this->Session->read('locationid'),'patient_id'=>$id)));
		if(isset($finalBillingData['FinalBilling']['bill_number']) && $finalBillingData['FinalBilling']['bill_number']!=''){
			$bNumber = $finalBillingData['FinalBilling']['bill_number'];
			$this->set('billNumber',$bNumber);
		}else{
			$bNumber = $this->generateBillNo($id);
			$this->set('billNumber',$bNumber);
		}
		$this->set('finalBillingData',$finalBillingData);
		$this->set('patientId',$id);

		
			
		$this->OptAppointment->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array(
								'foreignKey'=>'tariff_list_id'
						),
				)));
		$surgeriesData = $this->OptAppointment->find('all',array('conditions'=>array('OptAppointment.patient_id'=>$id,'OptAppointment.location_id'=>$this->Session->read('locationid'))));
		$this->set('surgeriesData',$surgeriesData);
		//Surgeries listing ends
	}

	function printSavedReceipt($id){
		$this->layout = false;
		$this->generateSavedReceipt($id);

	}

	//function to return all laboratory tests done on patient
	function labDetails($patient_id=null){
		$this->uses=array('LaboratoryTestOrder');

		$labGroup=$this->ServiceCategory->find('first',array('conditions'=>array('ServiceCategory.name'=>'Laboratory',
				'ServiceCategory.is_view'=>'1')));
		if($labGroup){
			$this->LaboratoryTestOrder->bindModel(array(
					'belongsTo' => array(
							'Laboratory'=>array('type'=>'inner','foreignKey'=>'laboratory_id' ),
							'Patient'=>array('foreignKey'=>'patient_id'),
							'ServiceProvider'=>array('foreignKey'=>'service_provider_id',
									'conditions'=>array('ServiceProvider.id=LaboratoryTestOrder.service_provider_id')),
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
							'TariffAmount'=>array('foreignKey' => false,
									'conditions'=>array('TariffAmount.tariff_list_id=Laboratory.tariff_list_id'
											/*'TariffAmount.tariff_standard_id=Patient.tariff_standard_id'*/))),
					'hasOne' => array( 'LaboratoryResult'=>array('foreignKey'=>'laboratory_test_order_id'))),false);

			$this->LaboratoryTestOrder->bindModel(array('hasOne' => array('LaboratoryToken'=>array('foreignKey'=>'laboratory_test_order_id'),)),false);

			$laboratoryTestOrderData= $this->LaboratoryTestOrder->find('all',array(
					'fields'=> array('LaboratoryTestOrder.amount','LaboratoryResult.confirm_result',
					'LaboratoryTestOrder.paid_amount','LaboratoryTestOrder.id,LaboratoryTestOrder.patient_id,
					LaboratoryTestOrder.create_time,Laboratory.name,LaboratoryTestOrder.discount,
							LaboratoryToken.ac_id,LaboratoryToken.sp_id,TariffAmount.nabh_charges,TariffAmount.non_nabh_charges','ServiceProvider.name'),
					'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patient_id,'LaboratoryTestOrder.is_deleted'=>0,'LaboratoryTestOrder.from_assessment'=>0),
					'order' => array( 'LaboratoryTestOrder.id' => 'asc' ),
					'group'=>'LaboratoryTestOrder.id'));
			return $laboratoryTestOrderData ;
		}
	}



	//BOF Details Bill pankaj
	//function to return complete list of payment with daywise details
	function detail_payment($patient_id=null){
			
	$website=$this->Session->read('website.instance');
		if($website == 'kanpur')
		{	
			$this->layout = 'print_with_header';
			
		}else
		 {
		$this->layout = false;
		}
		$this->generateReceipt($patient_id);
		if($patient_id){		
			$this->uses = array('LaboratoryTestOrder','WardPatient');
			$this->patient_info($patient_id);
			$this->Patient->unBindModel(array('hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
// 			$this->Patient->bindModel(array(
// 					'belongsTo' => array('User'=>array('foreignKey'=>'doctor_id'),
// 							'finalBilling'=>array('foreignKey'=>false,'conditions'=>array('finalBilling.patient_id=Patient.id')),
// 							'TariffList' =>array('foreignKey'=>'treatment_type'))));
// 			$forPatientTariff  = $this->Patient->find('first',array('fields'=>array('Patient.form_received_on','Patient.tariff_standard_id','Patient.lookup_name as lookup_name',
// 					'finalBilling.discharge_date,finalBilling.bill_number','TariffList.name'),'conditions'=>array('Patient.id'=>$patient_id)));
// 			debug($forPatientTariff);exit;
			//debug($forPatientTariff); exit;

                    $this->Patient->bindModel(array(
                        'belongsTo' => array(
                            'User' => array(
                                'foreignKey' => 'doctor_id'
                            ),
                            'finalBilling' => array(
                                'foreignKey' => false,
                                'conditions' => array('finalBilling.patient_id = Patient.id')
                            ),
                            'TariffList' => array(
                                'foreignKey' => 'tariff_standard_id' // Link through tariff_standard_id
                            )
                        )
                    ));
                    
                  
                    // Fetch the required data
                    $forPatientTariff = $this->Patient->find('first', array(
                        'fields' => array(
                            'Patient.form_received_on',
                            'Patient.tariff_standard_id',
                            'Patient.lookup_name as lookup_name',
                            'finalBilling.discharge_date',
                            'finalBilling.bill_number',
                            'TariffList.name' // Fetch Tariff name
                          
                        ),
                        'conditions' => array('Patient.id' => $patient_id) // Condition for the Patient
                    ));

                     $tariffnameid = !empty($forPatientTariff['Patient']['tariff_standard_id'])
                    ? $forPatientTariff['Patient']['tariff_standard_id'] 
                    : null; 
                
                // Debugging (optional) TariffStandard
                // debug($tariffnameid); // Check if the value is being extracted correctly
                    
			$this->set('discharge_date',$forPatientTariff['finalBilling']['discharge_date']);
			if(empty($forPatientTariff['finalBilling']['discharge_date'])){
				$forPatientTariff['finalBilling']['discharge_date']= date("Y-m-d") ;
			}
			$splittedInDate  = explode(" ",$forPatientTariff['Patient']['form_received_on']);
			$splittedOutDate  = explode(" ",$forPatientTariff['finalBilling']['discharge_date']);
			//cal the patient's days in hospital
			$interval  = $this->DateFormat->dateDiff($splittedInDate[0],$splittedOutDate[0]);
			$extraDays = $this->is_In_Out_Before_10_AM($splittedInDate[0],$splittedOutDate[0]);
			$totalDaysInHospital = $interval->days+(int)$extraDays ;

			$tariffStandardId=$forPatientTariff['Patient']['tariff_standard_id'];
			$hospitalType = $this->Session->read('hospitaltype');
 			#desination fetch
                    $patientdesignation = $this->Patient->find('first', [
            'conditions' => ['Patient.id' => $patient_id],
            'fields' => ['Patient.designation','discharge_date','create_time','corporate_status',], // Fetch only the designation field
        ]);
        // debug($patientdesignation);exit;
        $this->set('patientdesignation', $patientdesignation); 

         $tariffname = $this->TariffStandard->find('first', [
                    'conditions' => ['TariffStandard.id' => $tariffnameid],
                    'fields' => ['TariffStandard.name'], // Fetch only the designation field
                ]);
                // debug($tariffname);exit;
                $this->set('tariffname', $tariffname); 
                
			//laboratory only
// 			$testRates = $this->labRadRates($tariffStandardId,$patientId);// for lab & rad sevices

			$laboratoryTestOrderData  = $this->labDetails($patient_id);//lab data
			$radTestOrderData  = $this->radDetails($patient_id);//radiology data

			$mriData = $this->mriDetails($patient_id);//MRI data
			$ctData = $this->ctDetails($patient_id);//CT data
			$implantData = $this->implantDetails($patient_id);//IMPLANT data

			//calculating ward Days
			App::import('Controller', 'Billings');
			$billings = new BillingsController;
			$totalWardDays 	= '';
			$doctorCharges 	= $this->getDoctorChargesForDetailBill($tariffStandardId,$patient_id);
			$serviceCharges = $this->getServiceCharges($patient_id,$tariffStandardId);

			$nursingCharges = $this->getNursingChargesForDetailBill($tariffStandardId);
			$pharmacyCharges= $this->getPharmacyCharges($patient_id);

			//BOF Bed charges
			//$bedCharges=  $this->getBedCharge($patient_id,$tariffStandardId);
			$bedCharges = $this->wardCharges($patient_id);
			


			
			$this->FinalBilling->bindModel(array(
					'belongsTo' => array(
							'Diagnosis' =>array(
									'foreignKey'=>false,'conditions'=>array('FinalBilling.patient_id=Diagnosis.patient_id')
							),
					)));
			$finalBillingData = $this->FinalBilling->find('first',array('conditions'=>array('FinalBilling.location_id'=>$this->Session->read('locationid'),'FinalBilling.patient_id'=>$patient_id)));
			$this->set('finalBillingData',$finalBillingData);
			//debug($finalBillingData);exit;
			#echo'<pre>';print_r($doctorCharges['extra_doc_charges']);exit;
			//EOF Bed charges
			$this->loadModel('CorporateSublocation');
			$this->set('subLocations',$this->CorporateSublocation->getCorporateSublocationList($tariffStandardId));

			$this->set(array('labDetail'=>$laboratoryTestOrderData,'radiology'=>$radTestOrderData,'doctorCost'=>$doctorCharges['doc_charges'],'nurse'=>$nursingCharges,
			'service'=>$serviceCharges,'doctorData'=>$forPatientTariff,'patient_days'=>$totalDaysInHospital,'extra_doctor_charges'=>$doctorCharges['extra_doc_charges']
			,'roomTariff'=>$bedCharges,'pharmacyCharges'=>$pharmacyCharges,'mri'=>$mriData,'ct'=>$ctData,'implant'=>$implantData));

			//for refunded amount
			$discountData =$this->FinalBilling->find('first',array('conditions'=>array('FinalBilling.patient_id'=>$patient_id)));
			$this->set('discountData',$discountData);
			//EOF of refunded amount
			
			if($this->params->query['type']=='excel'){
				$this->layout=false;
				$this->render('detail_payment_excel');
			}

		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
		//debug($forPatientTariff); exit;
	}



	public function getDoctorChargesForDetailBill($tariffStandardId=null,$patient_id=null){
		$this->loadModel('TariffAmount');
		$this->loadModel('ConsultantBilling');
		$doctorRateData=$this->TariffAmount->find('first',array('conditions'=>array('tariff_list_id'=>2,'tariff_standard_id'=>$tariffStandardId)));

		$this->ConsultantBilling->bindModel(array(
				'belongsTo' => array(
						'DoctorProfile' =>array('foreignKey' => 'doctor_id'),
						'Consultant' =>array('foreignKey' => 'consultant_id'),
						//'TariffList' =>array('foreignKey' => 'consultant_service_id'),
						//'TariffAmount' =>array('foreignKey' => false,'TariffAmount.tariff_list_id=ConsultantBilling.consultant_service_id'),
				)),false);
		$consultantBillingData = $this->ConsultantBilling->find('all',array('conditions' =>array('patient_id'=>$patient_id),'order'=>array('date')));//,'date'=>date('Y-m-d')//,'TariffAmount.tariff_standard_id'=>$tariffStandardId

		return array("doc_charges"=>$doctorRateData,"extra_doc_charges"=>$consultantBillingData);
	}


	public function getServiceCharges($patient_id=null,$tariffStandardId=null){
		$this->loadModel('ServiceBill');
		$this->ServiceBill->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array( 'foreignKey'=>false,'type'=>'left','conditions'=>array('ServiceBill.tariff_list_id=TariffList.id')),
						'TariffAmount' =>array('foreignKey' => false,'conditions'=>array('TariffAmount.tariff_list_id=TariffList.id','TariffAmount.tariff_standard_id'=>$tariffStandardId))
				)),false);

		$nursingServices = $this->ServiceBill->find('all',array('group'=>array('ServiceBill.id'),'fields'=>array(
				'ServiceBill.*','TariffAmount.*','TariffList.*'),'conditions'=>array('ServiceBill.patient_id'=>$patient_id,
						'ServiceBill.location_id'=>$this->Session->read('locationid')/*,$this->params->query['privatePackage']*/),'order'=>'ServiceBill.Date'));
		/** private package conditions is for private packaged patient */
		return $nursingServices;

	}

	public function getNursingChargesForDetailBill($tariffStandardId=null){
		$this->loadModel('TariffAmount');
		$nursingCharges=$this->TariffAmount->find('first',array('conditions'=>array('tariff_list_id'=>3,'tariff_standard_id'=>$tariffStandardId)));
		return $nursingCharges;

	}



	//retrun surgerical duration
	function getSurgeryArray($subArray=array(),$in_date,$out_date){
		$sergerySlot =array();
		$conservativeDays =array();
		//BOF collecting checkout hrs
		$config_hrs = $this->Location->getCheckoutTime();
		//if checkout timing is 24 hours then set time to default in time
		if($config_hrs=='24 hours'){
			$slpittedIn= explode(" ",$in_date);
			$config_hrs = $slpittedIn[1];
		}
		//EOF config check
		//EOD collecting hrs
		if(!empty($subArray)){
			foreach($subArray as $key =>$value){

				$slittedValiditiyDate = explode(" ",$value['surgeryScheduleDate']);
				//reduced 1day if time is before config hours
				if(strtotime($slittedValiditiyDate[0]." ".$config_hrs) > strtotime($value['surgeryScheduleDate']) && $value['unitDays'] > 1){
					$reducedValidity = $value['unitDays']-1 ;
				}else{
					if(strtotime($slittedValiditiyDate[0]." ".$config_hrs) > strtotime($value['surgeryScheduleDate']))
						$reducedValidity = 0 ;
					else
						$reducedValidity = $value['unitDays'] ;
				}
				//EOF config hours check
				$sergeryValidityDate = date('Y-m-d H:i:s',strtotime($slittedValiditiyDate[0].$reducedValidity." days $config_hrs"));
				if($key>0){
					$lastKey = end($sergerySlot) ;
					if(strtotime($lastKey['end']) > strtotime($sergeryValidityDate)){
						$sergerySlot[$key] = array( 'start'=>$value['surgeryScheduleDate'],
								'end'=>$lastKey['end'],
								'name'=>$value['name'],
								'cost'=>$value['surgeryAmount'],
								'validity'=>$value['unitDays'],
								'moa_sr_no'=>$value['moa_sr_no'],
								'cghs_nabh'=>$value['cghs_nabh'],
								'cghs_non_nabh'=>$value['cghs_non_nabh'],
								'cghs_code'=>$value['cghs_code'],
								'doctor'=>$value['doctor'],
								'doctor_education'=>$value['doctor_education'],
								'anaesthesist'=>$value['anaesthesist'],
								'anaesthesist_education'=>$value['anaesthesist_education'],
								'anaesthesist_cost'=>$value['anaesthesist_cost'],
								'ot_charges'=>$value['ot_charges'],
								'opt_id'=>$value['opt_id'],
								'paid_amount'=>$value['paid_amount'],
								/** gaurav */
								'surgeon_cost'=>$value['surgeon_cost'],
								'asst_surgeon_one'=>$value['asst_surgeon_one'],
								'asst_surgeon_one_charge'=>$value['asst_surgeon_one_charge'],
								'asst_surgeon_two'=>$value['asst_surgeon_two'],
								'asst_surgeon_two_charge' => $value['asst_surgeon_two_charge'],
								'cardiologist' => $value['cardiologist'],
								'cardiologist_charge' => $value['cardiologist_charge'],
								'ot_assistant' => $value['ot_assistant'],
								'extra_hour_charge' => $value['extra_hour_charge'],
								'operationType' => $value['operationType'],
								'ot_extra_services' => $value['ot_extra_services'],
								'procedure_complete'=>$value['procedure_complete']
						);
					}else{
						//BOF checking the diff between the two sergery validity
						$slpittedStart = explode(" ",$value['surgeryScheduleDate']) ;
						$slpittedEnd = explode(" ",$lastKey['end']) ;
						$interval = $this->DateFormat->dateDiff($slpittedEnd[0],$slpittedStart[0]);
						$extraDays = $this->is_In_Out_Before_10_AM($value['surgeryScheduleDate']);
						$remainingDays = $interval->days - $extraDays;
						if($remainingDays > 0){
							//include next day till 10AM in sergery package validity
							$nextDayTill10AM = date('Y-m-d H:i:s',strtotime($slpittedEnd[0]."0 days $config_hrs"));
							if(strtotime($nextDayTill10AM) <= strtotime($value['surgeryScheduleDate'])){
								for($c=1;$c<$remainingDays;$c++){
									if(strtotime($nextDayTill10AM) <= strtotime($value['surgeryScheduleDate'])){
										$conservativeDays[$key][] = array('in'=>$nextDayTill10AM,'out'=>date('Y-m-d H:i:s',strtotime($nextDayTill10AM.$c.' days')));
										$nextDayTill10AM = date('Y-m-d H:i:s',strtotime($nextDayTill10AM.'1 days'));
									}
								}
							}
						}
						//EOF validity check
						$sergerySlot[$key] = array('start'=>$value['surgeryScheduleDate'],
								'end'=>$sergeryValidityDate,
								'name'=>$value['name'],
								'cost'=>$value['surgeryAmount'],
								'validity'=>$value['unitDays'],
								'moa_sr_no'=>$value['moa_sr_no'],
								'cghs_nabh'=>$value['cghs_nabh'],
								'cghs_non_nabh'=>$value['cghs_non_nabh'],
								'cghs_code'=>$value['cghs_code'],
								'doctor'=>$value['doctor'],
								'doctor_education'=>$value['doctor_education'],
								'anaesthesist'=>$value['anaesthesist'],
								'anaesthesist_education'=>$value['anaesthesist_education'],
								'anaesthesist_cost'=>$value['anaesthesist_cost'],
								'ot_charges'=>$value['ot_charges'],
								'opt_id'=>$value['opt_id'],
								'paid_amount'=>$value['paid_amount'],
								/** gaurav */
								'surgeon_cost'=>$value['surgeon_cost'],
								'asst_surgeon_one'=>$value['asst_surgeon_one'],
								'asst_surgeon_one_charge'=>$value['asst_surgeon_one_charge'],
								'asst_surgeon_two'=>$value['asst_surgeon_two'],
								'asst_surgeon_two_charge' => $value['asst_surgeon_two_charge'],
								'cardiologist' => $value['cardiologist'],
								'cardiologist_charge' => $value['cardiologist_charge'],
								'ot_assistant' => $value['ot_assistant'],
								'extra_hour_charge' => $value['extra_hour_charge'],
								'operationType' => $value['operationType'],
								'ot_extra_services' => $value['ot_extra_services'],
								'procedure_complete'=>$value['procedure_complete']
							);
					}
				}else{
					if($value['unitDays'] > 1){//for single surgery as a package to set proper end calculated on the basis of validity period
						$sergerySlot[$key] = array('start'=>$value['surgeryScheduleDate'],
								'end'=>$sergeryValidityDate,
								'name'=>$value['name'],
								'cost'=>$value['surgeryAmount'],
								'validity'=>$value['unitDays'],
								'moa_sr_no'=>$value['moa_sr_no'],
								'cghs_nabh'=>$value['cghs_nabh'],
								'cghs_non_nabh'=>$value['cghs_non_nabh'],
								'cghs_code'=>$value['cghs_code'],
								'doctor'=>$value['doctor'],
								'doctor_education'=>$value['doctor_education'],
								'anaesthesist'=>$value['anaesthesist'],
								'anaesthesist_education'=>$value['anaesthesist_education'],
								'anaesthesist_cost'=>$value['anaesthesist_cost'],
								'ot_charges'=>$value['ot_charges'],
								'opt_id'=>$value['opt_id'],
								'paid_amount'=>$value['paid_amount'],
								/** gaurav */
								'surgeon_cost'=>$value['surgeon_cost'],
								'asst_surgeon_one'=>$value['asst_surgeon_one'],
								'asst_surgeon_one_charge'=>$value['asst_surgeon_one_charge'],
								'asst_surgeon_two'=>$value['asst_surgeon_two'],
								'asst_surgeon_two_charge' => $value['asst_surgeon_two_charge'],
								'cardiologist' => $value['cardiologist'],
								'cardiologist_charge' => $value['cardiologist_charge'],
								'ot_assistant' => $value['ot_assistant'],
								'extra_hour_charge' => $value['extra_hour_charge'],
								'operationType' => $value['operationType'],
								'ot_extra_services' => $value['ot_extra_services'],
								'procedure_complete'=>$value['procedure_complete']
							);
					}else{
						$sergerySlot[$key] = array('start'=>$value['surgeryScheduleDate'],
								// 'end'=>$sergeryValidityDate,
								'end'=>$value['surgeryScheduleEndDate'],
								'name'=>$value['name'],
								'cost'=>$value['surgeryAmount'],
								'validity'=>$value['unitDays'],
								'moa_sr_no'=>$value['moa_sr_no'],
								'cghs_nabh'=>$value['cghs_nabh'],
								'cghs_non_nabh'=>$value['cghs_non_nabh'],
								'cghs_code'=>$value['cghs_code'],
								'doctor'=>$value['doctor'],
								'doctor_education'=>$value['doctor_education'],
								'anaesthesist'=>$value['anaesthesist'],
								'anaesthesist_education'=>$value['anaesthesist_education'],
								'anaesthesist_cost'=>$value['anaesthesist_cost'],
								'ot_charges'=>$value['ot_charges'],
								'opt_id'=>$value['opt_id'],
								'paid_amount'=>$value['paid_amount'],
								/** gaurav */
								'surgeon_cost'=>$value['surgeon_cost'],
								'asst_surgeon_one'=>$value['asst_surgeon_one'],
								'asst_surgeon_one_charge'=>$value['asst_surgeon_one_charge'],
								'asst_surgeon_two'=>$value['asst_surgeon_two'],
								'asst_surgeon_two_charge' => $value['asst_surgeon_two_charge'],
								'cardiologist' => $value['cardiologist'],
								'cardiologist_charge' => $value['cardiologist_charge'],
								'ot_assistant' => $value['ot_assistant'],
								'extra_hour_charge' => $value['extra_hour_charge'],
								'operationType' => $value['operationType'],
								'ot_extra_services' => $value['ot_extra_services'],
								'procedure_complete'=>$value['procedure_complete']
								);
					}
				}
			}
		}

		return array('sugeryValidity'=>$sergerySlot,'conservativeDays'=>$conservativeDays) ;
	}

/*
Forth argument sent by pankaj w for calcualting location wise patient charges
*/
	public function getDay2DayCharges($id=null,$tariffStandardId=null,$applyPackageCondition = false,$location_id=null){
		$this->loadModel('Billing');
		$wardArray  =  $this->Billing->getDay2DayCharges($id,$tariffStandardId,$applyPackageCondition,$location_id);
		return $wardArray ;
	}

	//function to return medicines with the cost
	function getPharmacyCharges($patient_id=null){
		/*$this->uses = array('SuggestedDrug','Note');

		$this->SuggestedDrug->bindModel(array('belongsTo' => array('Note' =>array('foreignKey'=>'note_id'),
				'PharmacyItemRate' =>array('foreignKey'=>false,'conditions'=>array('PharmacyItemRate.item_id=SuggestedDrug.drug_id')),
		)),false);


		$pharmacyResult = $this->SuggestedDrug->Find('all',array('conditions'=>array('Note.patient_id'=>$patient_id),'fields'=>array('SuggestedDrug.quantity','Note.create_time',
				'PharmacyItemRate.sale_price','PharmacyItem.name')));
		return $pharmacyResult;*/
		//$this->uses = array('PharmacySalesBill','PharmacyItem');
		$this->loadModel('PharmacySalesBill');
		$this->loadModel('PharmacyItem');
		$pharmacyChargeDetails = array();
		$pharmacyResult = $this->PharmacySalesBill->find('first',array('fields'=>array('SUM(PharmacySalesBill.total) as total'),
				'conditions'=>array('PharmacySalesBill.patient_id'=>$patient_id,'PharmacySalesBill.is_deleted'=>'0')));

		/*foreach($pharmacyResult as $pharmacy){
			foreach($pharmacy['PharmacySalesBillDetail'] as $pharmacyItem){
		$pharmacyItemDetails = $this->PharmacyItem->find('first',array('conditions'=>array('PharmacyItem.id'=>$pharmacyItem['item_id'])));

		if($pharmacyItemDetails['PharmacyItemRate']['sale_price']!=0){
		$cost=$pharmacyItemDetails['PharmacyItemRate']['sale_price'];
		}else{
		$cost=$pharmacyItemDetails['PharmacyItemRate']['mrp'];
		}
		$pharmacyChargeDetails[]=array('itemName'=>$pharmacyItemDetails['PharmacyItem']['name'],'quantity'=>$pharmacyItem['qty'],'rate'=>$cost,'purchaseDate'=>$pharmacy['PharmacySalesBill']['create_time'],'tax'=>$pharmacyItem['tax'],'pharmacySalesBillTax'=>$pharmacy['PharmacySalesBill']['tax']);
		}
		}*/
		return $pharmacyResult ; //$pharmacyChargeDetails;
	}

	//function to return all laboratory tests done on patient


	//function to return all radiology tests done on patient
	function radDetails($patient_id=null){
		$this->uses =array('RadiologyTestOrder','ServiceCategory');

		$mriId = $this->ServiceCategory->getServiceGroupId("MRI");
		$ctId = $this->ServiceCategory->getServiceGroupId("CT");
		$ImplantId = $this->ServiceCategory->getServiceGroupId("Implant");

		$radGroup=$this->ServiceCategory->find('first',array('conditions'=>array('ServiceCategory.name'=>'Radiology',
				'ServiceCategory.is_view'=>'1')));
		if($radGroup){
			$this->RadiologyTestOrder->bindModel(array('belongsTo' => array(
					'Radiology'=>array('type'=>'inner','foreignKey'=>'radiology_id' ),
					'Patient'=>array('foreignKey'=>'patient_id'),
					'ServiceProvider'=>array('foreignKey'=>'service_provider_id',
							'conditions'=>array('ServiceProvider.id=RadiologyTestOrder.service_provider_id')),
					'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
					'TariffAmount'=>array('foreignKey' => false,
							'conditions'=>array('TariffAmount.tariff_list_id=Radiology.tariff_list_id','TariffAmount.tariff_standard_id=Patient.tariff_standard_id'))),
					'hasOne' => array('RadiologyResult'=>array(
							'foreignKey'=>'radiology_test_order_id'))),false);

			$radTestOrderData= $this->RadiologyTestOrder->find('all',array(
					'fields'=> array('RadiologyResult.result_publish_date','RadiologyResult.confirm_result',
					'RadiologyTestOrder.id','RadiologyTestOrder.amount',
							'RadiologyTestOrder.patient_id','RadiologyTestOrder.radiology_order_date',
							'RadiologyTestOrder.test_done','RadiologyTestOrder.discount',
							'Radiology.name','TariffAmount.nabh_charges','TariffAmount.non_nabh_charges',
							'ServiceProvider.name'),
					'conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id,'RadiologyTestOrder.is_deleted'=>0,'RadiologyTestOrder.from_assessment'=>0,
							array("Radiology.service_group_id !=$mriId AND Radiology.service_group_id !=$ctId AND Radiology.service_group_id !=$ImplantId")),
					'order' => array( 'RadiologyTestOrder.id' => 'asc' ),
					'group'=>'RadiologyTestOrder.id'));
			//debug($radTestOrderData);exit;
			return $radTestOrderData ;
		}
	}



	//function to return all MRI test name and amount of patient
	function mriDetails($patient_id=null){
		$this->uses =array('RadiologyTestOrder');

		$this->RadiologyTestOrder->bindModel(array('belongsTo' => array(
				'Radiology'=>array('type'=>'inner','foreignKey'=>'radiology_id' ),
				'Patient'=>array('foreignKey'=>'patient_id'),
				'ServiceCategory' =>array('foreignKey'=>false),
				'ServiceProvider'=>array('foreignKey'=>'service_provider_id',
						'conditions'=>array('ServiceProvider.id=RadiologyTestOrder.service_provider_id')),
				'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
				'TariffAmount'=>array('foreignKey' => false,
						'conditions'=>array('TariffAmount.tariff_list_id=Radiology.tariff_list_id','TariffAmount.tariff_standard_id=Patient.tariff_standard_id'))),
				'hasOne' => array('RadiologyResult'=>array(
						'foreignKey'=>'radiology_test_order_id'))),false);

		/* commented becoz it bind is not proper.
		 $this->RadiologyTestOrder->bindModel(array('belongsTo' => array(
		 		'Radiology'=>array('type'=>'inner','foreignKey'=>'radiology_id' ),
		 		'ServiceCategory' =>array('foreignKey'=>false),
		 		'TariffAmount'=>array('foreignKey' => false,
		 				'conditions'=>array('TariffAmount.tariff_list_id=Radiology.tariff_list_id' ,'TariffAmount.tariff_standard_id=Patient.tariff_standard_id'))),
		 		'hasOne' => array('RadiologyResult'=>array('foreignKey'=>'radiology_test_order_id'))),false);
		*/
		$mriData = $this->RadiologyTestOrder->find('all',array(
				'fields'=>array('Radiology.name','RadiologyTestOrder.id','RadiologyTestOrder.patient_id','RadiologyTestOrder.radiology_order_date','TariffAmount.nabh_charges','TariffAmount.non_nabh_charges','ServiceProvider.name'),
				'conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id,'RadiologyTestOrder.is_deleted'=>0,
						'RadiologyTestOrder.radiology_id=Radiology.id','ServiceCategory.id=Radiology.service_group_id',
						'ServiceCategory.name'=>configure::read('MRI'))));
		return $mriData;
	}




	//function to return all CT test name and amount on patient
	function ctDetails($patient_id=null){
		$this->uses =array('RadiologyTestOrder');
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
							
						'Radiology'=>array('type'=>'inner','foreignKey'=>'radiology_id' ),
						'ServiceCategory' =>array('foreignKey'=>false),
						'TariffAmount'=>array('foreignKey' => false,
								'conditions'=>array('TariffAmount.tariff_list_id=Radiology.tariff_list_id' ,'TariffAmount.tariff_standard_id=Patient.tariff_standard_id'))),
				'hasOne' => array('RadiologyResult'=>array('foreignKey'=>'radiology_test_order_id'))),false);
		$ctData = $this->RadiologyTestOrder->find('all',array(
				'fields'=>array('Radiology.service_group_id','RadiologyTestOrder.id','RadiologyTestOrder.patient_id','Radiology.name','RadiologyTestOrder.radiology_order_date','TariffAmount.nabh_charges','TariffAmount.non_nabh_charges','ServiceProvider.name'),
				'conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id,'RadiologyTestOrder.is_deleted'=>0,'RadiologyTestOrder.radiology_id=Radiology.id',
						'ServiceCategory.id=Radiology.service_group_id','ServiceCategory.name'=>configure::read('CT'))));
		//debug($ctData);exit;
		return $ctData;
	}





	//function to return all IMPLANT test name and amount on patient
	function implantDetails($patient_id=null){
		$this->uses =array('RadiologyTestOrder');
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
							
						'Radiology'=>array('type'=>'inner','foreignKey'=>'radiology_id' ),
						'ServiceCategory' =>array('foreignKey'=>false),
						'TariffAmount'=>array('foreignKey' => false,
								'conditions'=>array('TariffAmount.tariff_list_id=Radiology.tariff_list_id' ,'TariffAmount.tariff_standard_id=Patient.tariff_standard_id'))),
				'hasOne' => array('RadiologyResult'=>array('foreignKey'=>'radiology_test_order_id'))),false);
		$implantData = $this->RadiologyTestOrder->find('all',array('fields'=>array('Radiology.service_group_id','RadiologyTestOrder.id','RadiologyTestOrder.patient_id','Radiology.name','RadiologyTestOrder.radiology_order_date','TariffAmount.nabh_charges','TariffAmount.non_nabh_charges','ServiceProvider.name'),
				'conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id,'RadiologyTestOrder.is_deleted'=>0,'RadiologyTestOrder.radiology_id=Radiology.id','ServiceCategory.id=Radiology.service_group_id','ServiceCategory.name'=>configure::read('Implant'))));
		return $implantData;
	}

	/**
	 * function to calculate ward charges for private packaged patient
	 * @param int $patientId (current encounter patient Id)
	 * @param int $packagedPatientId (previous or current encounter patient Id with which package is applied)
	 * @author Gaurav Chauriya
	 */
	public function calculatePrivatePackageWardCost($patientId,$packagedPatientId){
		$this->loadModel('WardPatient');
		$this->loadModel('TariffStandard');
		$privatePackagedData = $this->General->getPackageNameAndCost($patientId);
		$locationId = $this->Session->read('locationid');
		$this->WardPatient->bindModel(array(
				'belongsTo' => array(
						'Ward' =>array('foreignKey' => 'ward_id'),
						'TariffAmount' =>array('foreignKey' => false,
								'conditions'=>array('Ward.tariff_list_id=TariffAmount.tariff_list_id',
										'TariffAmount.tariff_standard_id'=>$this->TariffStandard->getPrivateTariffID($locationId) )),
						'TariffList'=>array('foreignKey' => false,'conditions'=>array('TariffAmount.tariff_list_id=TariffList.id'))
				)),false);

		$wardData = $this->WardPatient->find('all',array('group'=>array('WardPatient.id'),
				'conditions'=>array('patient_id'=>$patientId,'WardPatient.location_id'=>$locationId,'WardPatient.is_deleted'=>"0"),
				'fields'=>array('TariffAmount.nabh_charges','TariffAmount.non_nabh_charges','TariffAmount.moa_sr_no','TariffList.cghs_code',
						'WardPatient.in_date','WardPatient.out_date','Ward.name','Ward.id')));
		foreach($wardData as $wardInfo){
			if($this->Session->read('hospitaltype')=='NABH'){
				$charge = (int)$wardInfo['TariffAmount']['nabh_charges']  ;
			}else{
				$charge = (int)$wardInfo['TariffAmount']['non_nabh_charges']  ;
			}

			$x = strtotime($wardInfo['WardPatient']['in_date']);
			$y = ($wardInfo['WardPatient']['out_date']) ? strtotime($wardInfo['WardPatient']['out_date']) : strtotime(date('Y-m-d H:i:s'));
			while($x < $y) {
				if($x <= strtotime(date('Y-m-d',strtotime($privatePackagedData['startDate']))) )
					$costArray[] = array(
							'cghs_code' => $wardInfo['TariffList']['cghs_code'],
							'moa_sr_no' => $wardInfo['TariffAmount']['moa_sr_no'],
							'in' => $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s',$x),'yyyy-mm-dd',true),
							'out' => $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s',$x),'yyyy-mm-dd',true),
							'cost' => $charge,
							'ward' => $wardInfo['Ward']['name'],
							'ward_id' => $wardInfo['Ward']['id']
					);

				if( $x > strtotime(date('Y-m-d',strtotime($privatePackagedData['endDate']))) ){
					$costArray[] = array(
							'cghs_code' => $wardInfo['TariffList']['cghs_code'],
							'moa_sr_no' => $wardInfo['TariffAmount']['moa_sr_no'],
							'in' => $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s',$x),'yyyy-mm-dd',true),
							'out' => $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s',$x),'yyyy-mm-dd',true),
							'cost' => $charge,
							'ward' => $wardInfo['Ward']['name'],
							'ward_id' => $wardInfo['Ward']['id']
					);

				}
				$x = $x+(3600*24);
			}
			if($costArray)
				$wardCostArray[] = array($wardInfo['Ward']['name']=>$costArray);
			else 
				$wardCostArray = false;
			unset($costArray,$wardCostArray[1]);

		}
		return ($wardCostArray);
	}

	/**
	 * function to calculate ward charges for private packaged patient
	 * @param int $patientId (current encounter patient Id)
	 * @param int $packagedPatientId (previous or current encounter patient Id with which package is applied)
	 * @author Gaurav Chauriya
	 */
	public function calculatePrivatePackageDay2DayWardCost($patientId,$packagedPatientId){
		$this->loadModel('WardPatient');
		$this->loadModel('TariffStandard');
		$privatePackagedData = $this->General->getPackageNameAndCost($patientId);
		$locationId = $this->Session->read('locationid');
		$this->WardPatient->bindModel(array(
				'belongsTo' => array(
						'Ward' =>array('foreignKey' => 'ward_id'),
						'TariffAmount' =>array('foreignKey' => false,
								'conditions'=>array('Ward.tariff_list_id=TariffAmount.tariff_list_id',
										'TariffAmount.tariff_standard_id'=>$this->TariffStandard->getPrivateTariffID($locationId) )),
						'TariffList'=>array('foreignKey' => false,'conditions'=>array('TariffAmount.tariff_list_id=TariffList.id'))
				)),false);

		$wardData = $this->WardPatient->find('all',array('group'=>array('WardPatient.id'),
				'conditions'=>array('patient_id'=>$patientId,'WardPatient.location_id'=>$locationId,'WardPatient.is_deleted'=>"0"),
				'fields'=>array('TariffAmount.nabh_charges','TariffAmount.non_nabh_charges','TariffAmount.moa_sr_no','TariffList.cghs_code',
						'WardPatient.in_date','WardPatient.out_date','Ward.name','Ward.id')));
		foreach($wardData as $wardInfo){
			if($this->Session->read('hospitaltype')=='NABH'){
				$charge = (int)$wardInfo['TariffAmount']['nabh_charges']  ;
			}else{
				$charge = (int)$wardInfo['TariffAmount']['non_nabh_charges']  ;
			}

			$x = strtotime($wardInfo['WardPatient']['in_date']);
			$y = ($wardInfo['WardPatient']['out_date']) ? strtotime($wardInfo['WardPatient']['out_date']) : strtotime(date('Y-m-d H:i:s'));
			while($x < $y) {
				if($x <= strtotime(date('Y-m-d',strtotime($privatePackagedData['startDate']))) )
					$costArray[] = array(
							'cghs_code' => $wardInfo['TariffList']['cghs_code'],
							'moa_sr_no' => $wardInfo['TariffAmount']['moa_sr_no'],
							'in' => $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s',$x),'yyyy-mm-dd',true),
							'out' => $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s',$x),'yyyy-mm-dd',true),
							'cost' => $charge,
							'ward' => $wardInfo['Ward']['name'],
							'ward_id' => $wardInfo['Ward']['id']
					);

				if( $x > strtotime(date('Y-m-d',strtotime($privatePackagedData['endDate']))) ){
					$costArray[] = array(
							'cghs_code' => $wardInfo['TariffList']['cghs_code'],
							'moa_sr_no' => $wardInfo['TariffAmount']['moa_sr_no'],
							'in' => $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s',$x),'yyyy-mm-dd',true),
							'out' => $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s',$x),'yyyy-mm-dd',true),
							'cost' => $charge,
							'ward' => $wardInfo['Ward']['name'],
							'ward_id' => $wardInfo['Ward']['id']
					);

				}
				$x = $x+(3600*24);
			}
			$wardCostArray['day']=$costArray;
		}
		return ($wardCostArray);


	}
	
	/**
	 * function to calculate ot charge for extra time spent in Ot room
	 * @param dateTime $otInDate
	 * @param dateTime $otOutDate
	 * @param string $optType
	 * @return number integer
	 * @author Gaurav Chauriya
	 */
	public function getExtraTimeOtCharge($otInDate,$otOutDate,$optType){
		
		$difference = $this->DateFormat->dateDiff($otInDate,$otOutDate);
		if($difference->h != 0)
		$totalExtraHalfHours = ($difference->h - 1) * 2;
		if($difference->i > 30){
			$totalExtraHalfHours = $totalExtraHalfHours + 2;
		} else if($difference->i > 0  && $difference->i <= 30){
			$totalExtraHalfHours = $totalExtraHalfHours + 1;
		}
		return $extraHourPanelty = (strtolower($optType) == 'major') ? $totalExtraHalfHours * 2000 : $totalExtraHalfHours * 1000;
	}
	//EOF billing
	//EOF details bill pankaj

	public function getDay2DayWardCharges($id=null,$tariffStandardId=null,$applyPackageCondition = false){
		$this->uses = array('WardPatient','OptAppointment','Location','Doctor');
		/** Code construct for private packaged patient  Gaurav Chauriya*/
		if($applyPackageCondition){
			$this->loadModel('Patient');
			$privatePackagedDetails = $this->Patient->find('first',array('fields'=>array('is_packaged'),'conditions'=>array('id'=>$id)));
			if($privatePackagedDetails['Patient']['is_packaged']){
				/** by pass execution with calculatePrivatePackageWardCost() if patient is private packaged */
				return $this->calculatePrivatePackageWardCost($id,$privatePackagedDetails['Patient']['is_packaged']);
			}
		}
		/** EOF private package code */
		//BOF collecting checkout hrs
		$config_hrs = $this->Location->getCheckoutTime();
		//EOD collecting hrs
			
		//making sergery array
		$this->OptAppointment->unbindModel(array(
				'belongsTo' => array('Initial','Patient','Location','Opt','OptTable','Surgery','SurgerySubcategory','Doctor','DoctorProfile'
							
				)));
		$this->OptAppointment->bindModel(array(
	 		'belongsTo' => array(
	 				'TariffList' =>array( 'foreignKey'=>'tariff_list_id','type'=>'LEFT','conditions'=>array('TariffList.is_deleted'=>0)),
	 				'Surgeon' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
	 						'conditions'=>array('Surgeon.user_id=OptAppointment.doctor_id')),
	 				'User'=>array('foreignKey'=>'doctor_id'),
	 				'Initial'=>array('foreignKey'=>false,'conditions'=>array('Initial.id=User.initial_id')),
	 				/** Anaesthesist */
	 				'Anaesthesist' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
	 						'conditions'=>array('Anaesthesist.user_id=OptAppointment.department_id')),
	 				'AnaeUser'=>array('className'=>'User','foreignKey'=>'department_id'),
	 				'AnaeInitial'=>array('className'=>'Initial','foreignKey'=>false,'conditions'=>array('AnaeInitial.id=AnaeUser.initial_id')),
	 				/** Assistant Surgeon one */
	 				'AssistantOne' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
	 						'conditions'=>array('AssistantOne.user_id=OptAppointment.asst_surgeon_one')),
	 				'AssistantOneUser'=>array('className'=>'User',
	 						'foreignKey'=>'asst_surgeon_one'),
	 				'AssistantOneInitial'=>array('className'=>'Initial','foreignKey'=>false,
	 						'conditions'=>array('AssistantOneInitial.id=AssistantOneUser.initial_id')),
	 				/** Assistant Surgeon two */
	 				'AssistantTwo' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
	 						'conditions'=>array('AssistantTwo.user_id=OptAppointment.asst_surgeon_two')),
	 				'AssistantTwoUser'=>array('className'=>'User',
	 						'foreignKey'=>'asst_surgeon_two'),
	 				'AssistantTwoInitial'=>array('className'=>'Initial','foreignKey'=>false,
	 						'conditions'=>array('AssistantTwoInitial.id=AssistantTwoUser.initial_id')),
	 				/** Cardiologist */
	 				'Cardiologist' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
	 						'conditions'=>array('Cardiologist.user_id=OptAppointment.cardiologist_id')),
	 				'CardioUser'=>array('className'=>'User',
	 						'foreignKey'=>'cardiologist_id'),
	 				'CardioInitial'=>array('className'=>'Initial','foreignKey'=>false,
	 						'conditions'=>array('CardioInitial.id=CardioUser.initial_id')),
	 				
	 				'TariffAmount' =>array( 'foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=OptAppointment.tariff_list_id',
	 						'TariffAmount.tariff_standard_id'=>$tariffStandardId)),
	 				'Surgery'=>array('foreignKey'=>'surgery_id'),
	 				'AnaeTariffAmount' =>array('className'=>'TariffAmount',
	 						'foreignKey'=>false,
	 						'conditions'=>array('AnaeTariffAmount.tariff_list_id=OptAppointment.anaesthesia_tariff_list_id',
	 								"AnaeTariffAmount.tariff_standard_id"=>$tariffStandardId)),
	 					
	 		)));
		$procedureCompleteSondition = ($this->Session->read('website.instance') == 'kanpur') ? 'OptAppointment.procedure_complete = 1' : '';
		$surgery_Data = $this->OptAppointment->find('all',
				array('conditions'=>array('OptAppointment.location_id'=>$this->Session->read('locationid'),'OptAppointment.is_false_appointment'=>0,/* false app != 0 only for privatepackaged patient */
						'OptAppointment.is_deleted'=>0,'OptAppointment.patient_id'=>$id,$procedureCompleteSondition),
						'fields'=>array('OptAppointment.procedure_complete','OptAppointment.surgery_cost','OptAppointment.ot_charges','OptAppointment.anaesthesia_cost','OptAppointment.anaesthesia_tariff_list_id',
								'Surgeon.education','Surgeon.doctor_name','Anaesthesist.education','Anaesthesist.doctor_name',
								'TariffList.*,TariffAmount.moa_sr_no,OptAppointment.id,OptAppointment.paid_amount,OptAppointment.surgeon_amt,
								TariffAmount.tariff_list_id,TariffAmount.nabh_charges,TariffAmount.non_nabh_charges,
								TariffAmount.unit_days','AnaeTariffAmount.id','AnaeTariffAmount.nabh_charges','AnaeTariffAmount.non_nabh_charges',
								'OptAppointment.starttime','OptAppointment.endtime','Surgery.name','Initial.name','AnaeInitial.name',
								'OptAppointment.schedule_date','OptAppointment.department_id','TariffList.name',
								'AssistantOneInitial.name','AssistantOne.doctor_name','AssistantOne.education','OptAppointment.asst_surgeon_one_charge',
								'AssistantTwoInitial.name','AssistantTwo.doctor_name','AssistantTwo.education','OptAppointment.asst_surgeon_two_charge',
								'CardioInitial.name','Cardiologist.doctor_name','Cardiologist.education','OptAppointment.cardiologist_charge','OptAppointment.ot_asst_charge',
								'OptAppointment.ot_in_date','OptAppointment.out_date','OptAppointment.operation_type','OptAppointment.ot_service'),
						'order'=>'OptAppointment.schedule_date Asc',
						'group'=>'OptAppointment.id',
						'recursive'=>1));
			if($this->Session->read('website.instance') == 'kanpur'){
				$this->loadModel('TariffList');
				$this->TariffList->bindModel(array(
		 			'hasOne' => array(
		 				'TariffAmount' =>array( 'foreignKey'=>'tariff_list_id','conditions'=>array('TariffList.is_deleted'=>0))
		 				)));
			}
		/********************** Surgery Data Starts ******************************/
		$hospitalType = $this->Session->read('hospitaltype');
		if($hospitalType=='NABH'){
			$chargeType='nabh_charges';
		}else{
			$chargeType='non_nabh_charges';
		}
		$surgeries = array();
			
		foreach($surgery_Data as $uniqueSurgery){
			if($this->Session->read('website.instance') == 'kanpur'){
				$otServices = explode(',',$uniqueSurgery[OptAppointment][ot_service]);
				$tariff = $this->TariffList->find('all',array('fields'=>array('TariffList.name',"TariffAmount.".$chargeType),
						'conditions'=>array("TariffList.id"=>$otServices)));
				$otChargedServices ='';
				foreach($tariff as $services){
					$otChargedServices[$services['TariffList']['name']] =  $services['TariffAmount'][$chargeType];
				}
			}
			//convert date to local format
			$sugeryDate = $this->DateFormat->formatDate2Local($uniqueSurgery['OptAppointment']['starttime'],'yyyy-mm-dd',true);
			$sugeryEndDate = $this->DateFormat->formatDate2Local($uniqueSurgery['OptAppointment']['endtime'],'yyyy-mm-dd',true);
			$otInDate = $uniqueSurgery['OptAppointment']['ot_in_date'];
			$otOutDate = $uniqueSurgery['OptAppointment']['out_date'];
			$optType = $uniqueSurgery['OptAppointment']['operation_type'];
				
			$surgeries[]=array('name'=>$uniqueSurgery['Surgery']['name'],
					'surgeryScheduleDate'=>$sugeryDate,
					'surgeryScheduleEndDate'=>$sugeryEndDate,
					/* 'surgeryAmount'=>$uniqueSurgery['TariffAmount'][$chargeType], */
					'surgeryAmount'=>$uniqueSurgery['OptAppointment']['surgery_cost'],
					'unitDays'=>$uniqueSurgery['TariffAmount']['unit_days'],
					'cghs_nabh'=>$uniqueSurgery['TariffList']['cghs_nabh'],
					'cghs_non_nabh'=>$uniqueSurgery['TariffList']['cghs_non_nabh'],
					'cghs_code'=>$uniqueSurgery['TariffList']['cghs_code'],
					'moa_sr_no'=>$uniqueSurgery['TariffAmount']['moa_sr_no'],
					'doctor'=>$uniqueSurgery['Initial']['name'].$uniqueSurgery['Surgeon']['doctor_name'],
					'doctor_education'=>$uniqueSurgery['Surgeon']['education'],
					'anaesthesist'=>$uniqueSurgery['AnaeInitial']['name'].$uniqueSurgery['Anaesthesist']['doctor_name'],
					'anaesthesist_education'=>$uniqueSurgery['Anaesthesist']['education'],
					'anaesthesist_cost'=>$uniqueSurgery['OptAppointment']['anaesthesia_cost'],
					'ot_charges'=>$uniqueSurgery['OptAppointment']['ot_charges'],
					'opt_id'=>$uniqueSurgery['OptAppointment']['id'],
					'paid_amount'=>$uniqueSurgery['OptAppointment']['paid_amount'],
					/* 'anaesthesist_cost'=>$uniqueSurgery['AnaeTariffAmount'][$chargeType] */
					/** gaurav */
					'surgeon_cost'=>$uniqueSurgery['OptAppointment']['surgeon_amt'],
					'asst_surgeon_one'=>($uniqueSurgery['AssistantOne']['doctor_name']) ? $uniqueSurgery['AssistantOneInitial']['name'].$uniqueSurgery['AssistantOne']['doctor_name'].','.$uniqueSurgery['AssistantOne']['education'] : '',
					'asst_surgeon_one_charge'=>$uniqueSurgery['OptAppointment']['asst_surgeon_one_charge'],
					'asst_surgeon_two'=>($uniqueSurgery['AssistantTwo']['doctor_name']) ? $uniqueSurgery['AssistantTwoInitial']['name'].$uniqueSurgery['AssistantTwo']['doctor_name'].','.$uniqueSurgery['AssistantTwo']['education'] : '',
					'asst_surgeon_two_charge' => $uniqueSurgery['OptAppointment']['asst_surgeon_two_charge'],
					'cardiologist' => ($uniqueSurgery['Cardiologist']['doctor_name']) ? $uniqueSurgery['CardioInitial']['name'].$uniqueSurgery['Cardiologist']['doctor_name'].','.$uniqueSurgery['Cardiologist']['education'] : '',
					'cardiologist_charge' => $uniqueSurgery['OptAppointment']['cardiologist_charge'],
					'ot_assistant' => $uniqueSurgery['OptAppointment']['ot_asst_charge'],
					'extra_hour_charge' => $this->getExtraTimeOtCharge($otInDate,$otOutDate,$optType),
					'operationType' => $optType,
					'ot_extra_services' => $otChargedServices,
					'procedure_complete'=>$uniqueSurgery['OptAppointment']['procedure_complete'],
					/**  EOF gaurav*/
			);
		}
		//EOF making serugery array
		// $packageDays =1 ;
		
		if(empty($location_id)){
			$location_id = $this->Session->read('locationid');
		}

		$this->WardPatient->bindModel(array(
				'belongsTo' => array(
						'Ward' =>array('foreignKey' => 'ward_id'),
						'TariffAmount' =>array('foreignKey' => false,'conditions'=>array('Ward.tariff_list_id=TariffAmount.tariff_list_id','TariffAmount.tariff_standard_id'=>$tariffStandardId )),
						'TariffList'=>array('foreignKey' => false,'conditions'=>array('TariffAmount.tariff_list_id=TariffList.id'))
				)),false);

		$wardData = $this->WardPatient->find('all',array('group'=>array('WardPatient.id'),
				'conditions'=>array('patient_id'=>$id,'WardPatient.location_id'=>$location_id,'WardPatient.is_deleted'=>"0"),
				'fields'=>array('TariffList.*','WardPatient.*','TariffAmount.moa_sr_no,TariffAmount.tariff_list_id,TariffAmount.nabh_charges,TariffAmount.non_nabh_charges,TariffAmount.unit_days','Ward.name','Ward.id')));
		//array walk of ward Detail
		$dayArr = array();
		//BOF day array calculation
		$wardDayCount =0 ;
			
		$calDays = $this->calculateWardDays($wardData,$surgeries,$config_hrs);
		$dayArr = $calDays['dayArr'] ;
		$surgeryDays= $calDays['surgeryData']; //EOF day array calcualtion
		$daysBeforeAfterSurgeries = array();
		$j=0 ;
		
		if(!empty($surgeryDays['sugeryValidity'])){
			foreach($dayArr['day'] as $dayArrKey =>$daySubArr){
				$last  = end($daysBeforeAfterSurgeries) ;
				$splitDaySubArr =explode(" ",$daySubArr['out']);
				foreach($surgeryDays['sugeryValidity'] as $key =>$value){
					$surgeryStartDate = explode(" ",$value['start']);
					$surgeryEndDate   = explode(" ",$value['end']);

					if($value['validity']>1){
						//for surgery package days greater than 1
						//reduce 1 days for before 10AM case
						//below code is commented because for 24 hrs checkout no need to remove d last day
						//on compare with timing .
						/*if(strtotime($splitDaySubArr[0]." ".$config_hrs) > strtotime($value['start'])){

						$reducedByOneDay = strtotime($surgeryStartDate[0].'-1 Days') ;
						$reducedByOneDay = date("Y-m-d",$reducedByOneDay);
						unset($dayArr['day'][$dayArrKey-1]);//unset first day
						}else{*/
						$reducedByOneDay = $surgeryStartDate[0] ;
						//}
							
						//loop through validity days
							

						for($v=0;$v<$value['validity'];$v++){
							if(strtotime($splitDaySubArr[1]) <= strtotime($surgeryStartDate[1])){
								$dayArrKeyIncreased = $dayArrKey+1 ;
							}else{
								$dayArrKeyIncreased = $dayArrKey;
							}
							#echo date('d/m/Y : H:i:s',strtotime($splitDaySubArr[0]))."===".date('d/m/Y : H:i:s',strtotime($reducedByOneDay."+$v Days"))."<br>" ;
							if(strtotime($splitDaySubArr[0]) == strtotime($reducedByOneDay."+$v Days")){
								if(!isset($surgeryDays['sugeryValidity'][$key]['start'])){
									$surgeryDays['sugeryValidity'][$key]['start'] = $dayArr['day'][$dayArrKey]['in'];
								}
								unset($dayArr['day'][$dayArrKeyIncreased]);
							}

						}
						//EOF loop
					}/*else if(strtotime($splitDaySubArr[0]) == strtotime($surgeryStartDate[0])){//else for single day package surgery

					if(strtotime($splitDaySubArr[0]." ".$config_hrs) > strtotime($value['start']) && $dayArrKey!=0){
					unset($dayArr['day'][$dayArrKey-1]);
					}else{
					unset($dayArr['day'][$dayArrKey]);
					}
					}*/ //no need of else past
				}
				$j++ ;
			}
		}
		//BOF conservative n surgical combination

		$f=0;
		$combo=array();
			
		if(is_array($dayArr['day']) && !empty($dayArr['day'])){
			$lastDay  = end($dayArr['day']) ;
			foreach($dayArr['day'] as $dayArrKey =>$daySubArr){

				if($f<=count($dayArr['day'])){

					//For multiple surgeries for single day(charges)
					if((count($dayArr['day'])==1) && (is_array($surgeryDays['sugeryValidity']))){
						$combo[] = $daySubArr ;
						foreach($surgeryDays['sugeryValidity'] as $surgeryKey){
							$combo[] = $surgeryKey ;
						}
					}else{
						if($f ==0)$combo[] = $daySubArr ;
						//EOF multiple surgery
						$splitDaySubArr = explode(" ",$daySubArr['out']);
						//to insert surgeries between ward days

						foreach($surgeryDays['sugeryValidity'] as $surgeryKey=> $surgeryValue){


							/* 	echo "last day out ".$lastDay['out']."=" ;
							 echo "surgery start time".$surgeryValue['start']."=" ;
							echo "day out ".$daySubArr['out']."<br>" ; */
							/* echo $config_hrs; exit;
							 echo date("d-m-Y H:i:s",strtotime($splitDaySubArr[0]." ".$config_hrs))."=" ;
							echo $surgeryValue['start']."==".strtotime($surgeryValue['start'])."<br>"; */

							if(strtotime($splitDaySubArr[0]." ".$config_hrs) > strtotime($surgeryValue['start'])
			 					|| (
			 							//(strtotime($lastDay['out']) <= strtotime($surgeryValue['start'])) && (condition change when we add surgery for the current it's not addedd in current day bill by pankaj w and yashwant)
			 							(strtotime($lastDay['out']) >= strtotime($surgeryValue['start'])) &&
			 							(strtotime(date('Y-m-d H:i:s'))>=strtotime($surgeryValue['start'])) &&
			 							($daySubArr['out'] == $lastDay['out'])
			 					) ){
									
								$combo[] = $surgeryValue ; //for single surgery
								//unset added surgery
									
								//	unset($dayArr['day'][$dayArrKey]);
								unset($surgeryDays['sugeryValidity'][$surgeryKey]);

									
								//EOF package
							}
						}

						if($f >0 && !empty($dayArr['day'][$dayArrKey])) $combo[] = $dayArr['day'][$dayArrKey] ;

							

					}
					$f++;
				}else{
					$combo[] = $daySubArr ;

				}
			}
		}else if(is_array($surgeryDays['sugeryValidity']) && !empty($surgeryDays['sugeryValidity'])){

			//$combo[] = $surgeryDays['sugeryValidity'][0] ;
			//commented above to display multiple surgeries in listing
			$combo = $surgeryDays['sugeryValidity'] ;
		}

		$g=0;
		$groupCombo=array();
			

		foreach($combo as $roomKey=>$roomCost){
			if(isset($roomCost['ward'])){
				$groupCombo[$g][$roomCost['ward']][]=$roomCost ;
				if($combo[$roomKey+1]['ward']!=$roomCost['ward']){
					$g++;
				}
			}else{
				//if($roomKey>0)$g++; comment to maintaing proper array indexing

				$groupCombo[$g]=$roomCost ;
				$g++;
			}

		}
			
		if($this->Location->getCheckoutTime() != "24 hours"){
			foreach($groupCombo as $groupKey=>$subGroupCombo){
				$wardKeyN= key($subGroupCombo);
				foreach($subGroupCombo[$wardKeyN] as $wardKey=>$perWard){
					if(!empty($perWard['in'])){
						$groupCombo[$groupKey][$wardKeyN][$wardKey]['in']=$this->DateFormat->formatDate2STD($perWard['in'],Configure::read('date_format'));
					}
					if(!empty($perWard['out'])){
						$groupCombo[$groupKey][$wardKeyN][$wardKey]['out']=$this->DateFormat->formatDate2STD($perWard['out'],Configure::read('date_format'));
					}
				}
			}
		}
		//EOF combo
		return $groupCombo;

		//EOD array walk
	}

	public function printAdvanceReceipt(){
		//pr($this->request->query);exit;
		$website=$this->Session->read('website.instance');
		if($website == 'kanpur')
		{
			if($this->request->query['flag'] == 'without_header')
			{
				$this->layout = false;
			}
			else if($this->request->query['flag'] == 'roman_header')
			{
				$this->layout = 'roman_pharma_header';
			}
			else{
				$this->layout = 'print_with_header';
			}
				
		}else
		{
			$this->layout = false;
		}
	
		$this->uses = array('Billing','Patient','TariffStandard');
		//BOF-Mahalaxmi For RGJAY Patient not display PRint Reciept
		$this->set('getTariffRgjayId',$this->TariffStandard->getTariffStandardID('RGJAY'));
		//EOF-Mahalaxmi For RGJAY Patient not display PRint Reciept
		$this->Patient->bindModel(array(
				'belongsTo' => array(   'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
						'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id =Patient.tariff_standard_id' )),
				)),false);
		
		$this->Billing->bindModel(array(
			'belongsTo' => array(
					'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Billing.created_by' )),
					'PatientCard' =>array('foreignKey' => false,'conditions'=>array('PatientCard.billing_id=Billing.id' )),
			)),false);

		if($this->request->params){
			$billingId = $this->request->params['pass'][0];
			 $this->set('billingId', $billingId);
			$billingData = $this->Billing->find('first',array('fields'=>array('Billing.*','User.username','User.first_name','User.last_name','PatientCard.amount'),
					'conditions'=>array('Billing.id'=>$billingId,'Billing.is_deleted'=>'0')));
			$patientData = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$billingData['Billing']['patient_id']), 'fields' => array('Patient.*','PatientInitial.name','TariffStandard.name')));
			$this->set(array('billingData'=>$billingData,'patientData'=>$patientData));
			$this->patient_info($billingData['Billing']['patient_id']);

		}
	}

	public function paymentReceipt(){
		$this->set('data','');
		$this->uses = array('Patient');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'Patient.id' => 'asc'
				)
		);
		$role = $this->Session->read('role');
		//$search_key['Patient.admission_type'] = "IPD";
		if(!empty($this->params->query['type'])){
			if(strtolower($this->params->query['type'])=='emergency'){
				$search_key['Patient.admission_type'] = "IPD";
				$search_key['Patient.is_emergency'] = "1";
			}else if($this->params->query['type']=='IPD'){
				$search_key['Patient.admission_type'] = $this->params->query['type'];
				$search_key['Patient.is_emergency'] = "0";
			}else{
				$search_key['Patient.admission_type'] = $this->params->query['type'];
			}
		}

		//EOF patient search as per category
		$search_key['Patient.is_deleted'] = 0;
		$search_key['Patient.is_discharge'] = 0;//display only non-discharge patient
		if($role == 'admin'){
			#$search_key['Location.facility_id']=$this->Session->read('facilityid');
			$this->Patient->bindModel(array(
			'belongsTo' => array(
			'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
			'Location' =>array('foreignKey' => 'location_id'),
			'Initial' =>array('foreignKey' => false,'conditions'=>array('User.initial_id=Initial.id' )),
			'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
			'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
			)),false);
		}else{
			$search_key['Patient.location_id']=$this->Session->read('locationid');
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
							'Initial' =>array('foreignKey' => false,'conditions'=>array('User.initial_id=Initial.id' )),
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
					)),false);
		}

		// If patient is OPD
		if(!empty($this->params->query)){
			$search_ele = $this->params->query  ;//make it get
			if(!empty($search_ele['lookup_name'])){
				$search_key['Patient.lookup_name like '] = "%".trim($search_ele['lookup_name'])."%" ;
			}if(!empty($search_ele['patient_id'])){
				$search_key['Patient.patient_id like '] = "%".trim($search_ele['patient_id']) ;
			}if(!empty($search_ele['admission_id'])){
				$search_key['Patient.admission_id like '] = "%".trim($search_ele['admission_id']) ;
			}
			// Condition is here
			$conditions = $search_key;
		}else{
			// For IPD patient
			// Condition is here
			$conditions = array($search_key,'Patient.is_discharge'=>0,'Patient.admission_type'=>'IPD');
		}
		// Paginate Data here
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Patient.id' => 'desc'),
				'fields'=> array('CONCAT(PatientInitial.name," ",Patient.lookup_name) as lookup_name,Patient.fee_status,Patient.form_received_on,
						Patient.id,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(Initial.name," ",User.first_name," ",User.last_name) as name, Patient.create_time'),
				'conditions'=>$conditions
		);

		$this->set('data',$this->paginate('Patient'));
	}

	function getLabPaidAmount($patient_id){
		$this->loadModel('LabTestPayment');
		$paidLabPayment = $this->LabTestPayment->find('all',array('fields'=>array('SUM(paid_amount) as grandTotal' ),
				'conditions'=>array('LabTestPayment.patient_id'=>$patient_id,'LabTestPayment.location_id'=>$this->Session->read('locationid'))));

		return $paidLabPayment[0][0]['grandTotal'];
	}

	function getRadPaidAmount($patient_id){
		//$this->loadModel('RadiologyTestPayment');
		//$paidRadPayment = $this->RadiologyTestPayment->find('all',array('fields'=>array('SUM(paid_amount) as grandTotal' ),'conditions'=>array('RadiologyTestPayment.patient_id'=>$patient_id,'RadiologyTestPayment.location_id'=>$this->Session->read('locationid'))));

		//return $paidRadPayment[0][0]['grandTotal'];
	}

	function saveOtherServices(){
		$this->uses = array('OtherService');
		if(!empty($this->request->data['OtherService'])){
			$this->request->data['OtherService']['created_by']=$this->Session->read('userid');
			$this->request->data['OtherService']['location_id']=$this->Session->read('locationid');
			$this->request->data['OtherService']['create_time']=date("Y-m-d H:i:s");
			$this->request->data['OtherService']['service_date']=$this->DateFormat->formatDate2STD($this->request->data['OtherService']['service_date'],Configure::read('date_format'));

			//$this->OtherService->save($this->request->data);
			$this->redirect(array("controller" => "billings", "action" => "patient_information",$this->request->data['OtherService']['patient_id'],'otherServicesSection'));
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
	}

	function calculateOtherServices($patient_id){
		$this->loadModel('OtherService');
		//$otherServices = $this->OtherService->find('all',array('fields'=>array('SUM(OtherService.service_amount) as tCost'),'conditions'=>array('patient_id'=>$patient_id,'location_id'=>$this->Session->read('locationid'),'is_deleted'=>0)));
		return $otherServices[0][0]['tCost'];
	}

	function getConsultantServices($group_id =null , $sub_group_id=null){
		$this->loadModel('TariffList');
		$this->loadModel('Patient');
		/*if($charges_type == 'Surgeon'){
		 $charges_type = 'surgery';
		}*/
		/*$this->loadModel('ServiceCategory');--do not reomove
		$groupName=$this->ServiceCategory->getServiceCategoryName($group_id);
		*/
		$patientId = $this->params->query['patient_id'] ;
		$patient_details  = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$patientId),'fields'=>array('id','coupon_name')));		
				if($sub_group_id != null && $sub_group_id != 'undefined'){
			$data['service_sub_category_id'] = $sub_group_id;
		}
		$data['TariffList.service_category_id'] = $group_id;
		$data['TariffList.location_id'] = $this->Session->read('locationid');
		$data['TariffList.is_deleted'] = '0';
		//$data['TariffList.name LIKE'] ='%'.$this->params->query['term'].'%';
		$tariffStandardID = $this->params->query['tariff_standard_id'] ;
		if(!$tariffStandardID) $tariffStandardID =  25 ;//Configure::read('privateTariffId') ; //set to private ID 
		//BOF vadodara condition for tariff charges
		if($this->Session->read('website.instance')=='vadodara'){ 
			$this->TariffList->bindModel(array(
					'belongsTo' => array(
							'TariffAmount'=>array('type'=>'INNER','foreignKey' => false,'conditions'=>array('TariffList.id=TariffAmount.tariff_list_id',
									'TariffAmount.tariff_standard_id='.$tariffStandardID)),
							'TariffAmountType'=>array('type'=>'INNER','foreignKey' => false,'conditions'=>array('TariffList.id=TariffAmountType.tariff_list_id',
									'TariffAmountType.tariff_standard_id='.$tariffStandardID))
					)),false);
			//		$this->query("SET CHARACTER SET utf8");
			$services = $this->TariffList->find('all',array('fields'=>array('TariffList.name','TariffList.id',
					'TariffAmount.nabh_charges','TariffAmount.non_nabh_charges','TariffAmount.standard_tariff',
					'TariffAmountType.*'),'conditions'=>$data,'group'=>array('TariffList.id')));
			//EOF laboratory
			$admissionType = $this->params->query['admission_type'] ;
			$patientId = $this->params->query['patient_id'] ;
			
			if($admissionType=='IPD'){
				$hospitalType = $this->Session->read('hospitaltype');
				if($hospitalType == 'NABH'){
					$nursingServiceCostType = 'nabh_charges';
				}else{
					$nursingServiceCostType = 'non_nabh_charges';
				} 
				//read config of room tyype
				$roomTypes = Configure::read('roomtType') ;
				$patientRoomType  = $this->params->query['room_type']."_ward_charge" ; //for database field name 
				//array('general'=>'General','special'=>'Special','semi_special'=>'Semi Special','Delux'=>'Delux') ; //sample
				foreach ($services as $key=>$value) {
					/****************Default discount percentage************/
					if(Configure::read('apply_discount')=='1' && empty($patient_details['Patient']['coupon_name'])){
						if(!empty($value['TariffAmount']['standard_tariff'])){
							$discount=$value['TariffAmount']['standard_tariff'];
						}else $discount=0;
					}else{
						$discount=0;
					}
					/*******************************************************/
					//check if the service has room type charges added in master
					if($value['TariffAmountType'][$patientRoomType] != ''){						
						$returnArray[] = array( 'id'=>$value['TariffList']['id'],
								'value'=>ucwords($value['TariffList']['name']),
								'charges'=>$value['TariffAmountType'][$patientRoomType],
								'fix_discount'=>$discount) ;
					}else{
						$returnArray[] = array( 'id'=>$value['TariffList']['id'],
								'value'=>ucwords($value['TariffList']['name']),
								'charges'=>$value['TariffAmount'][$nursingServiceCostType],
								'fix_discount'=>$discount) ;
					} 
				}
			}else{
				$hospitalType = $this->Session->read('hospitaltype');
				if($hospitalType == 'NABH'){
					$nursingServiceCostType = 'nabh_charges';
				}else{
					$nursingServiceCostType = 'non_nabh_charges';
				}
				$patientRoomType  = "opd_charge" ; //for database field name
				
				foreach ($services as $key=>$value) {
					/****************Default discount percentage************/
					if(Configure::read('apply_discount')=='1' && empty($patient_details['Patient']['coupon_name']) ){
						if(!empty($value['TariffAmount']['standard_tariff'])){
							$discount=$value['TariffAmount']['standard_tariff'];
						}else $discount=0;
					}else{
						$discount=0;
					}
					/*******************************************************/
					//check if the service has room type charges added in master
					if($value['TariffAmountType'][$patientRoomType] != ''){
						$returnArray[] = array( 'id'=>$value['TariffList']['id'],
								'value'=>ucwords($value['TariffList']['name']),
								'charges'=>$value['TariffAmountType'][$patientRoomType],
								'fix_discount'=>$discount) ;
					}else{
						$returnArray[] = array( 'id'=>$value['TariffList']['id'],
								'value'=>ucwords($value['TariffList']['name']),
								'charges'=>$value['TariffAmount'][$nursingServiceCostType],
								'fix_discount'=>$discount) ;
					} 
				}
			}
			
		}else{//EOF vadodara cond added by pankaj w
			$this->TariffList->bindModel(array(
					'belongsTo' => array(
							'TariffAmount'=>array('type'=>'inner','foreignKey' => false,
									'conditions'=>array('TariffList.id=TariffAmount.tariff_list_id',
											'TariffAmount.tariff_standard_id='.$tariffStandardID))
					)),false);
			//		$this->query("SET CHARACTER SET utf8");
			$services = $this->TariffList->find('all',array('fields'=>array('TariffList.name','TariffList.id',
					'TariffAmount.nabh_charges,TariffAmount.non_nabh_charges','TariffAmount.standard_tariff','TariffList.cghs_code'),
					'conditions'=>array($data,'OR'=>array('TariffList.name like'=>"%".$this->params->query['term']."%", 'TariffList.cghs_code like'=>"%".$this->params->query['term']."%")),'group'=>array('TariffList.id'),'limit'=>Configure::read('number_of_rows')));

			//EOF laboratory
			$patientId = $this->params->query['patient_id'] ;

       
			$hospitalType = $this->Session->read('hospitaltype');
			if($hospitalType == 'NABH'){
				$nursingServiceCostType = 'nabh_charges';
			}else{
				$nursingServiceCostType = 'non_nabh_charges';
			}
			
			foreach ($services as $key=>$value) { 
				/****************Default discount percentage************/
				if(Configure::read('apply_discount')=='1' && empty($patient_details['Patient']['coupon_name'])){
					if(!empty($value['TariffAmount']['standard_tariff'])){
						$discount=$value['TariffAmount']['standard_tariff'];
					}else $discount=0;
				}else{
					$discount=0;
				}
				/*******************************************************/
				$name  = preg_replace('/[^A-Za-z0-9\s\-]/', '', $value['TariffList']['name']);
				$returnArray[] = array( 'id'=>$value['TariffList']['id'],
						'value'=>$value['TariffList']['cghs_code']."-".ucwords($name),
						'charges'=>$value['TariffAmount'][$nursingServiceCostType],
						'fix_discount'=>$discount) ;
			}
		}  
		echo json_encode($returnArray);
		exit;//dont remove this
	}

	/**
	 * autocomplete for other services only for vadodara
	 * @param unknown_type $group_id
	 * @param unknown_type $sub_group_id
	 * @yashwant
	 */
	function getOtherServicesAutocomplete($group_id =null , $sub_group_id=null){//debug($this->params->query);
		$this->layout = 'ajax' ;
		$this->loadModel('TariffList');
		  
		$this->loadModel('ServiceCategory'); 
		$groupName=$this->ServiceCategory->getServiceCategoryName($group_id);
		  
		if($this->params->query['is_nurse']=='yes'){//for is group is active for billing and not for nursing then chages in nursing come in other service autocomplete
			$serviceCatCond= 'ServiceCategory.is_enable_for_nursing !=1';
		}else{
			$serviceCatCond= 'ServiceCategory.is_view =1';
		}
		//debug($serviceCatCond);
		$data['TariffList.is_deleted'] = '0';
		$data['ServiceCategory.is_deleted'] = '0';
		$data['TariffList.name LIKE'] ='%'.$this->params->query['term'].'%';
		//$data['ServiceCategory.service_type']  ; //-- comented by yashwant
		$data['ServiceCategory.name !=']=Configure::read('histopathologyGroup') ;
		$tariffStandardID = $this->params->query['tariff_standard_id'] ;
		if(!$tariffStandardID) $tariffStandardID =  Configure::read('privateTariffId') ; //set to private ID
		if($this->Session->read('website.instance')=='vadodara'){
			$this->TariffList->bindModel(array(
					'belongsTo' => array(
							'TariffAmount'=>array('type'=>'inner','foreignKey' => false,'conditions'=>array('TariffList.id=TariffAmount.tariff_list_id',
									'TariffAmount.tariff_standard_id='.$tariffStandardID)),
							'TariffAmountType'=>array('type'=>'inner','foreignKey' => false,'conditions'=>array('TariffList.id=TariffAmountType.tariff_list_id',
									'TariffAmountType.tariff_standard_id='.$tariffStandardID)),
							'ServiceCategory'=>array('type'=>'inner','foreignKey' => false ,'conditions'=>array('TariffList.service_category_id=ServiceCategory.id'
									,$serviceCatCond ))
					)),false);
			
			$services = $this->TariffList->find('all',array('fields'=>array('TariffList.name','TariffList.service_category_id','TariffList.id','TariffAmount.nabh_charges',
					'TariffAmount.non_nabh_charges','TariffAmountType.*','ServiceCategory.name','ServiceCategory.service_type'),'conditions'=>array_merge(array('ServiceCategory.service_type IS NULL'),$data),'group'=>array('TariffList.id'),'limit'=>'20'));
			$admissionType = $this->params->query['admission_type'] ;
			$patientId = $this->params->query['patient_id'] ;
				
			// to skip service except of other service group  --yashwant
			$servicesNewArr=array();
			foreach($services as $servicesKeySkip=>$servicesValueSkip){
				/*if($servicesValueSkip['ServiceCategory']['name']==$groupName['ServiceCategory']['name'] || empty($servicesValueSkip['ServiceCategory']['service_type'])){
					if($servicesValueSkip['ServiceCategory']['name']!=Configure::read('histopathologyGroup')){
						$servicesNewArr[]=$servicesValueSkip;
					}
				}else{*/
					//unset($services[$servicesKeySkip]);
				//}
				$servicesNewArr[]=$servicesValueSkip;
			}

			if($admissionType=='IPD'){
				$hospitalType = $this->Session->read('hospitaltype');
				if($hospitalType == 'NABH'){
					$nursingServiceCostType = 'nabh_charges';
				}else{
					$nursingServiceCostType = 'non_nabh_charges';
				}
				$roomTypes = Configure::read('roomtType') ;
				$patientRoomType  = $this->params->query['room_type']."_ward_charge" ; //for database field name
				foreach ($servicesNewArr as $key=>$value) {
					if($value['TariffAmountType'][$patientRoomType] != ''){
						$returnArray[] = array( 'id'=>$value['TariffList']['id'],'value'=>ucwords($value['TariffList']['name']),'charges'=>$value['TariffAmountType'][$patientRoomType],
								'group'=>$value['ServiceCategory']['name']) ;
					}else{
						$returnArray[] = array( 'id'=>$value['TariffList']['id'],'value'=>ucwords($value['TariffList']['name']),'charges'=>$value['TariffAmount'][$nursingServiceCostType],
								'group'=>$value['ServiceCategory']['name']) ;
					}
				}
			}else{
				$hospitalType = $this->Session->read('hospitaltype');
				if($hospitalType == 'NABH'){
					$nursingServiceCostType = 'nabh_charges';
				}else{
					$nursingServiceCostType = 'non_nabh_charges';
				}
				$patientRoomType  = "opd_charge" ; //for database field name
	
				foreach ($servicesNewArr as $key=>$value) {
					//check if the service has room type charges added in master
					if($value['TariffAmountType'][$patientRoomType] != ''){
						$returnArray[] = array( 'id'=>$value['TariffList']['id'],'value'=>ucwords($value['TariffList']['name']),'charges'=>$value['TariffAmountType'][$patientRoomType],
								'group'=>$value['ServiceCategory']['name']) ;
					}else{
						$returnArray[] = array( 'id'=>$value['TariffList']['id'],'value'=>ucwords($value['TariffList']['name']),'charges'=>$value['TariffAmount'][$nursingServiceCostType],
								'group'=>$value['ServiceCategory']['name']) ;
					}
				}
			}
				
		}/* else{//EOF vadodara cond added by pankaj w
			$this->TariffList->bindModel(array(
					'belongsTo' => array(
							'TariffAmount'=>array('foreignKey' => false,'conditions'=>array('TariffList.id=TariffAmount.tariff_list_id','TariffAmount.tariff_standard_id='.$tariffStandardID))
					)),false);
			//		$this->query("SET CHARACTER SET utf8");
			$services = $this->TariffList->find('all',array('fields'=>array('TariffList.name','TariffList.id','TariffAmount.nabh_charges,TariffAmount.non_nabh_charges'),
					'conditions'=>$data,'group'=>array('TariffList.id')));
			//EOF laboratory
			$hospitalType = $this->Session->read('hospitaltype');
			if($hospitalType == 'NABH'){
				$nursingServiceCostType = 'nabh_charges';
			}else{
				$nursingServiceCostType = 'non_nabh_charges';
			}
				
			foreach ($services as $key=>$value) {
				$returnArray[] = array( 'id'=>$value['TariffList']['id'],'value'=>$value['TariffList']['name'],'charges'=>$value['TariffAmount'][$nursingServiceCostType]) ;
			}
		} */
	
		echo json_encode($returnArray);
	 	exit;//dont remove this
	}
	
	
	function getConsultantCost($id,$tariff_standard_id){
		$this->uses= array('TariffAmount','TariffList');

		if(!$tariffStandardId) $tariffStandardId = Configure::read('privateTariffId') ;


		if(!$tariff_standard_id) Configure::read('privateTariffId') ; //set to private ID

		$services = $this->TariffAmount->find('first',array('fields'=>array('nabh_charges','non_nabh_charges'),
				'conditions'=>array('TariffAmount.tariff_list_id'=>$id,'TariffAmount.location_id'=>$this->Session->read('locationid'),
						'TariffAmount.tariff_standard_id'=>$tariff_standard_id)));

		$hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;

		//for private,cghs and company patients hospital charges
		$hospitalCharges =  $this->TariffList->find('first',array('conditions'=>array('TariffList.id'=>$id)));
		$combine  = array('tariff_amount'=>trim($services['TariffAmount'][$hosType]),
				'private'=>$this->Number->format($hospitalCharges['TariffList']['price_for_private'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),
				'cghs'=>$this->Number->format($hospitalCharges['TariffList']['price_for_cghs'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),
				'other'=>$this->Number->format($hospitalCharges['TariffList']['price_for_other'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false))) ;

		echo json_encode($combine);
		exit;
	}

	/**
	 * function to return service sub category and used as autocomplete for billing page
	 * @param int $serviceGroupId
	 * By yashwant
	 */
	function getListOfSubGroup($serviceGroupId = null)
	{
		$this->loadModel('ServiceSubCategory');
			
		$service_sub_group = $this->ServiceSubCategory->find('list',array(
				'fields'=>array('id','name'),
				'conditions'=>array('ServiceSubCategory.service_category_id'=>$serviceGroupId,
						'ServiceSubCategory.is_view'=>1,"ServiceSubCategory.is_deleted"=>0,'ServiceSubCategory.name like'=>'%'.$this->params->query['term'].'%'),
				'order'=>array('ServiceSubCategory.name'=>'asc')));
			
			
		foreach ($service_sub_group as $key=>$value) {

			$returnArray[] = array( 'id'=>$key,
					'value'=>ucwords(strtolower($value)),
			) ;

		}
		echo json_encode($returnArray);
		exit;//dont remove this
	}

	public function deleteOtherServices($serviceId,$patientId){
		$this->loadModel('OtherService');
		//$this->OtherService->delete($serviceId);
		$this->redirect(array("controller" => "billings", "action" => "patient_information",$patientId,'otherServicesSection'));
	}

	public function deleteServices($serviceId,$patientId){
		$this->loadModel('ServiceBill');
		$this->ServiceBill->delete($serviceId);
		$this->Session->setFlash(__('Record deleted successfully', true));
		$this->redirect(array("controller" => "billings", "action" => "viewAllPatientServices",$patientId));
	}

	public function deleteConsultantCharges($billingId,$patientId){
		$this->loadModel('ConsultantBilling');
		//$this->loadModel('VoucherEntry');
		$this->ConsultantBilling->delete($billingId);
		/* if(!empty($billingId)){
			$this->VoucherEntry->updateAll(array('VoucherEntry.is_deleted'=>1),array('VoucherEntry.billing_id'=>$billingId));
		} */
		$this->Session->setFlash(__('Record deleted successfully', true));
		if($this->request->query=='consultaionBill'){
			exit;
		}else{
			$this->redirect(array("controller" => "billings", "action" => "patient_information",$patientId,'consultantSection'));
		}
	}

	public function deleteLabTest($testId,$patientId){#echo $testId.'-'.$patientId;exit;
		if(!empty($testId)){
			$this->loadModel('LaboratoryTestOrder');
			$this->LaboratoryTestOrder->save(array('id'=>$testId,'is_deleted'=>1));
			$this->Session->setFlash(__('Record deleted successfully'),'default',array('class'=>'message'));
			$this->redirect(array("controller" => "billings", "action" => "patient_information",$patientId,'pathologySection'));
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect(array("controller" => "billings", "action" => "patient_information",$patientId,'pathologySection'));
		}
	}

	public function deleteRadTest($testId,$patientId){
		if(!empty($testId)){
			$this->loadModel('RadiologyTestOrder');
			$this->RadiologyTestOrder->save(array('id'=>$testId,'is_deleted'=>1));
			$this->Session->setFlash(__('Record deleted successfully'),'default',array('class'=>'message'));
			$this->redirect(array("controller" => "billings", "action" => "patient_information",$patientId,'radiologySection'));
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect(array("controller" => "billings", "action" => "patient_information",$patientId,'radiologySection'));
		}
	}

	//BOF  pankaj
	function notesadd($patient_id){
		$this->uses =array('ConsultantBilling','Consultant',"Note",'User','Consultant','SuggestedDrug','Patient');
		$this->layout = 'ajax' ;
		if (!empty($this->request->data['Note'])) {

			//converting date to standard format
			if(!empty($this->request->data["Note"]['note_date'])){
				$last_split_date_time =  $this->request->data['Note']['note_date'];
				$this->request->data["Note"]['note_date'] = $this->DateFormat->formatDate2STD($last_split_date_time,Configure::read('date_format')) ;
			}
			if($this->Note->insertNote($this->request->data)){
				$this->Session->setFlash(__('Patient Note Added Successfully' ),'default',array('class'=>'message'));
				// echo "<script> parent.location.reload();parent.$.fancybox.close();</script>" ;
				$this->redirect("/billings/notesadd/".$this->request->data['Note']['patient_id']);
			}else{
				$this->Session->setFlash(__('Please Try Again' ),'default',array('class'=>'error'));
			}
		}
		$this->set('is_added','no');
		// Collect the date and set it as min date in date piker
		$admissionDate = $this->Patient->field('Patient.form_received_on',array('Patient.id'=>$this->params['pass'][0],'Patient.location_id'=>$this->Session->read('locationid')));
		$this->set(compact('admissionDate'));
		$this->set('registrar',$this->User->getDoctorsByLocation($this->Session->read('locationid')));
		$this->set('consultant',$this->Consultant->getRegistrar());
		$this->set('patientid',$patient_id);
	}
// poonam
function death_summary($patient_id = null) {
    
    // Added RadiologyResult model to fetch radiology data directly.
    $this->uses = array(
        'Patient', 'User', 'Person', 'DoctorProfile', 'DeathSummary', 
        'Billing', 'LaboratoryResult', 'LaboratoryHl7Result', 'LaboratoryParameter',
        'RadiologyResult','OptAppointment', 'Surgery', 'TariffList'
    );
    
    $this->loadModel('Patient');
    
    // Fetch basic patient registration details
    $regData = $this->Patient->find('first', array(
        'conditions' => array('Patient.id' => $patient_id),
        'fields' => array(
            'Patient.age', 
            'Patient.sex', 
            'Patient.admission_id', 
            'Patient.admission_type', 
            'Patient.form_received_on'
        ),
        'order' => array(
            'Patient.admission_id' => 'desc',
            'Patient.admission_type' => 'desc',
            'Patient.form_received_on' => 'desc'
        )
    ));
    $this->set('regData', $regData);
    
    if (!empty($this->request->data['DeathSummary'])) {
        $this->DeathSummary->insertDeathSummary($this->request->data['DeathSummary']);
        $errors = $this->DeathSummary->invalidFields();
        if ($errors) {
            $this->set("errors", $errors);
        } else {
            $this->Session->setFlash(__('Record added successfully', true), 'default', array('class' => 'message'));
            $this->redirect($this->referer());
        }
    }
    
    // Fetch patient details and death summary data
    $this->print_patient_info($patient_id);
    $this->data = $this->DeathSummary->getData($patient_id);
    
    // Fetch latest death summary entry
    $deathSummary = $this->DeathSummary->find('first', array(
        'conditions' => array('DeathSummary.patient_id' => $patient_id),
        'order' => array('DeathSummary.id DESC')
    ));
    
    // Fetch laboratory results linked to the patient
    $labResults = $this->LaboratoryResult->find('all', array(
        'fields' => array(
            'LaboratoryParameter.name',   // Investigation Name
            'LaboratoryHl7Result.result'   // Observed Value
        ),
        'conditions' => array(
            'LaboratoryResult.patient_id' => $patient_id
        ),
        'joins' => array(
            array(
                'table' => 'laboratory_hl7_results',
                'alias' => 'LaboratoryHl7Result',
                'type' => 'LEFT',
                'conditions' => array('LaboratoryHl7Result.laboratory_result_id = LaboratoryResult.id')
            ),
            array(
                'table' => 'laboratory_parameters',
                'alias' => 'LaboratoryParameter',
                'type' => 'LEFT',
                'conditions' => array('LaboratoryParameter.id = LaboratoryHl7Result.laboratory_parameter_id')
            )
        ),
        'order' => array('LaboratoryResult.id' => 'DESC')
    ));
    
    // Pass lab results and death summary data to the view
    $this->set('deathSummary', $deathSummary);
    $this->set('labResults', $labResults);
    
    // ----- Fetch Radiology Results directly from RadiologyResult table -----
    $radiologyResults = $this->RadiologyResult->find('all', array(
		'fields' => array(
			 'Radiology.name',               // Radiology test name from joined table
			 'RadiologyResult.note',         // Radiology details
			 'RadiologyResult.result_publish_date'
		),
		'conditions' => array(
			 'RadiologyResult.patient_id' => $patient_id
		),
		'joins' => array(
			 array(
				  'table' => 'radiologies',
				  'alias' => 'Radiology',
				  'type' => 'LEFT',
				  'conditions' => array('RadiologyResult.radiology_id = Radiology.id')
			 )
		),
		'order' => array('RadiologyResult.id' => 'DESC')
	));
	$this->set('radiologyResults', $radiologyResults);
  // Fetch the latest OT Schedule details (schedule_date, surgeon, anaesthesia, description)
$optAppointment = $this->OptAppointment->find('first', array(
    'conditions' => array('OptAppointment.patient_id' => $patient_id),
    'fields' => array(
        'OptAppointment.schedule_date', 
        'OptAppointment.doctor_id',   
        'OptAppointment.anaesthesia', 
        'OptAppointment.description',
        'OptAppointment.surgery_id',
        'OptAppointment.department_id',
        'OptAppointment.anaesthesia_tariff_list_id',
        'TariffList.name', 
        'TariffList.id' ,
        'Users.id',
        'Users.first_name',
        'Users.last_name',
        
    ),
    'joins' => array(
        array(
            'table' => 'tariff_lists',
            'alias' => 'AnaesthesiaTariffList',  
            'type' => 'LEFT',
            'conditions' => array('AnaesthesiaTariffList.id = OptAppointment.anaesthesia_tariff_list_id')
        )
    ),
    'joins' => array(
        array(
            'table' => 'users',
            'alias' => 'Users', 
            'type' => 'LEFT',
            'conditions' => array('Users.id = OptAppointment.doctor_id')
        )
    ),
    'order' => array('OptAppointment.id' => 'DESC')  
));
$this->set('optAppointment', $optAppointment);
	// Fetch surgery name from Surgeries table using surgery_id
		$surgeryName = '';
		if (!empty($optAppointment['OptAppointment']['surgery_id'])) {
			$surgeryData = $this->Surgery->find('first', array(
				'conditions' => array('Surgery.id' => $optAppointment['OptAppointment']['surgery_id']),
				'fields' => array('Surgery.name')
			));
			if (!empty($surgeryData)) {
				$surgeryName = $surgeryData['Surgery']['name'];
			}
		}
		$this->set('surgeryName', $surgeryName);
		
		$departmentUsers = array(); // Initialize empty array

if (!empty($optAppointment['OptAppointment']['department_id'])) {
    $departmentUsersData = $this->User->find('all', array(
        'conditions' => array('User.id' => $optAppointment['OptAppointment']['department_id']),
        'fields' => array('User.first_name', 'User.last_name') // Add any required fields
    ));

    if (!empty($departmentUsersData)) {
        foreach ($departmentUsersData as $user) {
            $departmentUsers[] = $user['User']['first_name'] . ' ' . $user['User']['last_name'] . ' (' . $user['User']['role'] . ')';
        }
    }
    	$this->set('$departmentUsersData', $departmentUsersData);
}
	
	
}
	
	function death_summary_print($patient_id=null){
		$this->layout = 'print' ;
		$this->death_summary($patient_id) ;
	}
	//EOF pankaj

public function fetchLatestSummary($patient_id = null) {
    $this->autoRender = false;
    $this->loadModel('DeathSummary');

    $deathSummary = $this->DeathSummary->find('first', array(
        'conditions' => array('DeathSummary.patient_id' => $patient_id),
        'order' => array('DeathSummary.id DESC') // Get latest entry
    ));

    // Debugging - Ensure this data appears in browser console
    // debug($deathSummary);

    // Proper JSON response
    echo json_encode([
        'summary' => !empty($deathSummary['DeathSummary']['summary']) ? $deathSummary['DeathSummary']['summary'] : 'Click on "Generate Death Summary" button to generate summary!'
    ]);

    exit();
}


public function insertDeathSummary($data) {
    // debug($data); // Check incoming data before saving

    // Ensure summary is included in the save array
    if (!isset($data['DeathSummary']['summary']) || empty($data['DeathSummary']['summary'])) {
        $data['DeathSummary']['summary'] = "Default generated summary"; // Fallback to avoid empty save
    }

    $result = $this->DeathSummary->save($data);
    
    // debug($result); // Check if save was successful
    // exit(); // Stop execution to debug
}
public function generateDeathSummary($patient_id = null) {
    $this->autoRender = false;
    $this->loadModel('DeathSummary');
	$this->loadModel('Patient');
	// debug($patient_id); 
	$regData = $this->Patient->find('first', array(
		'conditions' => array('Patient.id' => $patient_id),
		'fields' => array('Patient.age', 'Patient.sex', 'Patient.admission_id', 'Patient.admission_type', 'Patient.form_received_on'),
		'order' => array(
			'Patient.admission_id' => 'desc',
			'Patient.admission_type' => 'desc',
			'Patient.form_received_on' => 'desc'
		)
	));
	
	$this->set('regData', $regData);
	
    // Retrieve the patient data passed via AJAX
    $patientData = $this->request->query;

    // Fetch latest saved Death Summary
    $deathSummary = $this->DeathSummary->find('first', [
        'conditions' => ['DeathSummary.patient_id' => $patient_id],
        'order' => ['DeathSummary.id DESC']
    ]);

    if (empty($deathSummary)) {
        // Create new entry if no previous summary is found
        $deathSummary = $this->DeathSummary->create();
        $deathSummary['DeathSummary']['patient_id'] = $patient_id;
    }

    // Construct the ChatGPT API prompt using passed data and existing summary
    $query = "Generate a detailed medical death summary for the following patient:\n\n"
		. "<strong>Registration ID:</strong> " . $regData['Patient']['admission_id'] . "\n"
		. "<strong>Addmission Type:</strong> " . $regData['Patient']['admission_type'] . "\n"
		. "<strong>Registration Date:</strong> " . $regData['Patient']['form_received_on'] . "\n"
         . "<strong>Name Of Patient:</strong> " . $patientData['name'] . "\n"  // Use patient name from AJAX
		// . "<strong>Name Of Patient:</strong> " . $patientData['age'] . "\n"
         . "<strong>Age/Sex:</strong> " . $patientData['age'] . " / " . $patientData['sex'] . "\n"  // Use age and sex from AJAX
         . "<strong>Residential Address:</strong> " . $patientData['address'] . "\n"  // Use address from AJAX
         . "<strong>Contact Number:</strong> " . $patientData['contact_number'] . "\n"  // Use contact number from AJAX
         . "<strong>Occupation: </strong>" . $deathSummary['DeathSummary']['occupation'] . "\n"
		 . "<strong>Date & Time of Admission in Identified Isolation Ward:</strong> " . $deathSummary['DeathSummary']['admission_date_iiw'] . "\n"
 		. "<strong>Date & Time of Death: </strong>" . $deathSummary['DeathSummary']['death_on'] . "\n"
        . "<strong>Date of Onset of Illness:</strong> " . $deathSummary['DeathSummary']['date_of_illness'] . "\n"
        . "<strong>Sign & Symptoms (Details):</strong> " . $deathSummary['DeathSummary']['sign_and_symptoms'] . "\n"
        . "<strong>Brief H/O Presumptive source of infection (Brief travel history or H/O contact with positive case):</strong> " . $deathSummary['DeathSummary']['brief_history'] . "\n"
		. "<strong>Associated illness / Physiological condition (if any): " . $deathSummary['DeathSummary']['associated_illness'] . "\n"
        . "<strong>Treatment Given: </strong>" . $deathSummary['DeathSummary']['treatment_given'] . "\n"
        . "<strong>Details of treatment given at: </strong>" . $deathSummary['DeathSummary']['treatment_given'] . "\n"
		. "<strong>1. By First Doctor/Hospital:</strong> " . $deathSummary['DeathSummary']['first_doctor'] . "\n"
        . "<strong>2. By Second Doctor/Hospital: </strong>" . $deathSummary['DeathSummary']['second_doctor'] . "\n"
        . "<strong>3. By IIW:</strong> " . $deathSummary['DeathSummary']['by_iiw'] . "\n"
        . "<strong>3. Name Of Referring Hospital:</strong> " . $deathSummary['DeathSummary']['refering_hospital'] . "\n"
        . "<strong>Name Of IIW:</strong> " . $deathSummary['DeathSummary']['name_of_IIW'] . "\n"
        . "<strong>Date of Throat Of Swab Taken:</strong> " . $deathSummary['DeathSummary']['swab_taken_date'] . "\n"
        . "<strong>Date of Result of Throat Swab:</strong> " . $deathSummary['DeathSummary']['swab_result_date'] . "\n"
        . "<strong>Name Of Laboratory: </strong>" . $deathSummary['DeathSummary']['name_of_laboratory'] . "\n"
        . "<strong>Other Relevant lab results:</strong> " . $deathSummary['DeathSummary']['laboratory_results'] . "\n"
        . "<strong>Special mention of various treatment modalities:</strong> " . $deathSummary['DeathSummary']['various_treatment'] . "\n"
        . "<strong>Stay Notes: </strong>" . $deathSummary['DeathSummary']['stay_notes'] . "\n"
		. "<strong>Date & Time of Admission in Identified Isolation Ward:</strong> " . $deathSummary['DeathSummary']['admission_date_iiw'] . "\n"
        . "<strong>Cause of Death: </strong>" . $deathSummary['DeathSummary']['cause_of_death'] . "\n" 

        . "Ensure the summary is structured properly for medical documentation.";

		// debug($query);
    // OpenAI API Call
    $apiKey = "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"; // Replace with a valid API key
    $bodyText = [
        "model" => "gpt-4",
        "messages" => [["role" => "user", "content" => $query]],
       "temperature" => 0.2,
        "max_tokens" => 1000
    ];

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($bodyText));
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Content-Type: application/json',
		'Authorization: Bearer ' . $apiKey
	]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode != 200) {
        echo json_encode(['summary' => "Error: API request failed with status code $httpCode."]);
        exit();
    }

	$responseData = json_decode($response, true);
    if (!isset($responseData['choices'][0]['message']['content'])) {
        echo json_encode(['summary' => "No response received from OpenAI."]);
        exit();
    }

    $generatedSummary = $responseData['choices'][0]['message']['content'];

    // Save the generated summary in the database
    $deathSummary['DeathSummary']['summary'] = $generatedSummary;  // Add the generated summary to the data
    $this->DeathSummary->save($deathSummary);  // Save the summary to the database

    // Return the generated summary to the frontend for display
    echo json_encode(['summary' => $generatedSummary]);
    exit();
}
public function updateDeathSummary($patient_id = null) {
    $this->autoRender = false;
    
    if (!empty($this->request->data['summary'])) {
        $summary = $this->request->data['summary'];

        // Debugging: check if the summary is being received
        // debug($summary); // Check if the correct summary is being passed

        // Save the updated summary
        $this->loadModel('DeathSummary');
        $deathSummary = $this->DeathSummary->find('first', [
            'conditions' => ['DeathSummary.patient_id' => $patient_id],
            'order' => ['DeathSummary.id DESC']
        ]);

        if ($deathSummary) {
            // Update the summary field
            $deathSummary['DeathSummary']['summary'] = $summary;

            // Save the updated summary into the database
            if ($this->DeathSummary->save($deathSummary)) {
                echo json_encode(['success' => true]); // Return success response
                exit();
            }
        }
    }

    // If the summary is not found or something went wrong, return failure
    echo json_encode(['success' => false]);
    exit();
}

// EOFDS

	function revokeDischarge($patientId){
		if(!empty($patientId)){
			$this->uses = array('Bed','WardPatient','Patient','FinalBilling','Billing');
			//check if bed already occupied by some other patient
			$this->Patient->id = $patientId;
			$patientData = $this->Patient->read();
			$bedData =  $this->Bed->find('first',array('conditions'=>array('Bed.id'=>$patientData['Patient']['bed_id'])));
			if(($bedData['Bed']['patient_id'] != 0) && ($bedData['Bed']['patient_id'] !=$patientId)){ //check if this patient's bed occupied by some other patient
				$this->Session->setFlash(__('Bed is already occupied,please try again.'),true,array('class'=>'error'));
				$this->redirect($this->referer());
			}
			$wardPatient = $this->WardPatient->find('first',array('conditions'=>array('WardPatient.patient_id'=>$patientId),
					'order'=>array('WardPatient.id desc')));
			$this->WardPatient->id = $wardPatient['WardPatient']['id'];
			$wardPatientData['WardPatient']['out_date'] = '';
			$this->WardPatient->save($wardPatientData);
			$this->Patient->updateAll(array('is_discharge'=>0,'discharge_date'=>'null'),array('id'=>$patientId));
			//BOF delete nursing, room and doctor charges form accounting by amit
			$this->Billing->deleteRevokeJV($patientId);
			//EOF
			$finalBilling = $this->FinalBilling->find('first',array('conditions'=>array('FinalBilling.patient_id'=>$patientId),'order'=>array('FinalBilling.id desc')));
			$this->FinalBilling->id = $finalBilling['FinalBilling']['id'];
			$this->FinalBilling->delete($finalBilling['FinalBilling']['id']);
			// Reassign Bed

			$this->Bed->id = $patientData['Patient']['bed_id'];
			$this->Bed->save(array('patient_id'=>$patientId,'is_released'=>0));

			$this->redirect(array("controller" => "billings", "action" => "multiplePaymentModeIpd",$patientId));

		}
	}

	/**
	 * function for continue visit of opd patient
	 * @param unknown_type $patientId
	 * by yashwant
	 */
	function continueVisit($patientId){
		if(!empty($patientId)){
			$this->uses = array('Bed','WardPatient','Patient','FinalBilling','Appointment');

			$this->Patient->id = $patientId;
			$this->Patient->save(array('is_discharge'=>0,'discharge_date'=>''));
			
			$this->Appointment->updateAll(array('Appointment.status'=>"'Arrived'"),array('Appointment.patient_id'=>$patientId,'Appointment.date'=>date('Y-m-d')));

			$finalBilling = $this->FinalBilling->find('first',array('conditions'=>array('FinalBilling.patient_id'=>$patientId),'order'=>array('FinalBilling.id desc')));
			$this->FinalBilling->id = $finalBilling['FinalBilling']['id'];
			$this->FinalBilling->delete($finalBilling['FinalBilling']['id']);

			
			$this->redirect(array("controller" => "billings", "action" => "multiplePaymentModeIpd",$patientId));

		}
	}

	//BOF 1053
	//@@ Funtion for billing editing
	function editAdvancePayment($id=null){
		$this->uses = array('Billing');
		$this->layout  = false ;
		$this->data = $this->Billing->getBillingByID($id);
	}

	public function deleteAdvance($id=null){
		$this->loadModel('Billing');
		if($this->Billing->delete($id)){
			$this->Session->setFlash(__('Record deleted successfully'),true,array('class'=>'message'));
			$this->redirect($this->referer());
		}else{
			$this->Session->setFlash(__('Please try again'),true,array('class'=>'error'));
			$this->redirect($this->referer());
		}
	}
	//post data of finalization of invoice
	function removeBackDateEntries($data=array()){
		$this->loadModel('ConsultantBilling');
		//$this->loadModel('OtherService');
		$this->loadModel('LaboratoryTestOrder');
		$this->loadModel('RadiologyTestOrder');
		$this->loadModel('ServiceBill');
		$this->loadModel('PharmacySalesBill');
		//convert to standard date
		$data['Billing']['discharge_date'] = $this->DateFormat->formatDate2STD($data['Billing']['discharge_date'],Configure::read('date_format'));
		//check for consultant visit
		$this->ConsultantBilling->deleteAfterDischargeRecords($data['Billing']['discharge_date'],$data['Billing']['patient_id']);
		//check for other services
		//$this->OtherService->deleteAfterDischargeRecords($data['Billing']['discharge_date'],$data['Billing']['patient_id']);
		//check for laboratory
		$this->LaboratoryTestOrder->deleteAfterDischargeRecords($data['Billing']['discharge_date'],$data['Billing']['patient_id']);
		//check for radiology
		$this->RadiologyTestOrder->deleteAfterDischargeRecords($data['Billing']['discharge_date'],$data['Billing']['patient_id']);
		//check for service
		$this->ServiceBill->deleteAfterDischargeRecords($data['Billing']['discharge_date'],$data['Billing']['patient_id']);
		//check for pharmacy
		$this->PharmacySalesBill->deleteAfterDischargeRecords($data['Billing']['discharge_date'],$data['Billing']['patient_id']);

	}
	//EOF 1053

	//function to return payment dues of non discharged patients to report controller
	function nonDischargePaymentDues (){
		ini_set('memory_limit',-1);
		$this->loadModel('Patient');
		$this->loadModel('Billing');
		$this->loadModel('Person');
		$this->loadModel('FinalBilling');
		//$this->loadModel('RadiologyTestPayment');
		$this->loadModel('LabTestPayment');
		// get final bill pending //
		$getData = $this->request->data ;

		$from = $this->DateFormat->formatDate2STDForReport($getData['from'],Configure::read('date_format'))." 00:00:00";
		$to = $this->DateFormat->formatDate2STDForReport($getData['to'],Configure::read('date_format'))." 23:59:59";
			
		if($getData['admission_type'] != "") {
			$conditions['Patient']['admission_type'] 	= $getData['admission_type'];
		}
		if($getData['skip_registration'] != "") {
			$conditions['Patient']['treatment_type'] 	= $getData['skip_registration'];
		}
		if($getData['ipd_patient_status'] != "") {
			$conditions['Patient']['is_discharge'] 		= $getData['ipd_patient_status'];
		}
		if($getData['opd_patient_status'] != "") {
			$conditions['Patient']['is_discharge'] 		= $getData['opd_patient_status'];
		}

		$conditions['Patient']['location_id'] 			= $this->Session->read('locationid');
		$conditions['Patient']['is_deleted'] 			= 0;

		//check if the discharged option is selected
		/*if($conditions['Patient']['is_discharge']==1 && (!empty($conditions['Patient']['admission_type']))){
		 return  $this->paymentDuesForDischargePatient($conditions);
			
		//exit script as the above function will return all the required rows for selected filter.
		}*/
			
			 	
		/*********************************************************Total paid within selected date range **************/

		$this->Billing->bindModel(array(
				'belongsTo'=>array( 'Patient'=>array('foreignKey'=>'patient_id'),
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )))
		));
			

		$conditions['Patient']['is_deleted'] = 0;
		$forCompleteBillPaymentCond = $conditions;
			
		$conditions['Billing'] = array('date BETWEEN ? AND ?'=> array($from,$to));
		$conditions['Billing'] = array('is_deleted'=> '0');
		$conditions = $this->postConditions($forCompleteBillPaymentCond);

		$getBillingPending = $this->Billing->find("all",array('conditions' => $conditions, 'fields' => array('Billing.date','sum(Billing.amount) as amount',
				'PatientInitial.name','Patient.form_received_on','Patient.lookup_name', 'Patient.mobile_phone','Patient.id',
				'Patient.admission_type', 'Patient.admission_id', 'Patient.address1'),'order'=>array('Billing.date asc'),'group'=>array('DATE_FORMAT(Billing.date,"%Y-%m-%d")','Billing.patient_id')));
			

			
		/* $getBillingCompletePending = $this->Billing->find("all",array('conditions' => $forCompleteBillPaymentCond, 'fields' => array('Billing.date','sum(Billing.amount) as amount',
			'PatientInitial.name','Patient.form_received_on','Patient.lookup_name', 'Patient.mobile_phone','Patient.id',
				'Patient.admission_type', 'Patient.admission_id', 'Patient.address1'),'order'=>array('Billing.date asc'),'group'=>array('DATE_FORMAT(Billing.date,"%Y-%m-%d")','Billing.patient_id')));
		*/

		$this->Patient->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array('hasOne'=>array('Billing'=>array('foreignKey'=>'patient_id'))));
		$patientList  = $this->Patient->find("all",array('conditions'=>$conditions,'fields'=>array(
				'Patient.id','Patient.tariff_standard_id','Patient.admission_type','Patient.is_discharge'),
				'order'=>array('Patient.form_received_on asc')));
			
		/**********************EOF PAID AMOUNT ****************************************/

		/********************* Ward Charges Starts ********************/
		$hospitalType = $this->Session->read('hospitaltype');
		foreach($patientList as $patientData){
			$patientCharges[$patientData['Patient']['id']]['charges']= $this->paymentDuesForNonDischargePatient($patientData);
			$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($patientData['Patient']['id']);
			$patientCharges[$patientData['Patient']['id']]['address'] = $this->setAddressFormat($UIDpatient_details['Person']);
		}
			
		return array('getBillingPending'=>$getBillingPending,'patientCharges'=>$patientCharges,'getBillingCompletePending'=>$getBillingCompletePending) ;
			
		// Lab Radiology paid amount deduction

		/*$labPaidAmount = $this->getLabPaidAmount($id);
			$radPaidAmount = $this->getRadPaidAmount($id);
		$this->set('labPaidAmount',$labPaidAmount);
		$this->set('radPaidAmount',$radPaidAmount);*/
		//Lab Radiology paid amount deduction
			
	}



	function paymentDuesForNonDischargePatient($patientData=array()){

		$this->uses = array('LabTestPayment','TariffStandard','Ward','Room','Bed','ServiceBill','WardPatient','FinalBilling','InsuranceCompany',
				'SubServiceDateFormat','ServiceBill','Corporate','Service','DoctorProfile','Person','Consultant','User','Patient',
				'ConsultantBilling','SubService','PharmacySalesBill','PharmacySalesBillDetail','InventoryPharmacySalesReturn',
				'InventoryPharmacySalesReturnsDetail','WardPatient');

		$id =$patientData['Patient']['id'];
		$tariffStandardId =$patientData['Patient']['tariff_standard_id'] ;
		$admission_type = $patientData['Patient']['admission_type'];
		$this->loadModel('ServiceBill');
		if(!empty($id)){

			$patient_pharmacy_details = $this->PharmacySalesBill->getPatientSaleDetails($id);

			$pharmacy_total =0;
			$pharmacy_cash_total = 0;
			$pharmacy_credit_total =0;
			if($patient_pharmacy_details){
				$pharmacy_total = $this->PharmacySalesBill->getTotalAmount($patient_pharmacy_details);
				$pharmacy_cash_total = $this->PharmacySalesBill->getCashAmount($patient_pharmacy_details);
			}

			$hospitalType = $this->Session->read('hospitaltype');
			/******************* Nursing Charges Starts *****************/

			$nursingServices = $this->getServiceCharges($id,$tariffStandardId);
			$hospitalType = $this->Session->read('hospitaltype');
			if($hospitalType == 'NABH'){
				$nursingServiceCostType = 'nabh_charges';
			}else{
				$nursingServiceCostType = 'non_nabh_charges';
			}
			$resetNursingServices = array();
			foreach($nursingServices as $nursingServicesKey=>$nursingServicesCost){
				$resetNursingServices[$nursingServicesCost['TariffList']['name']]['qty'][] =
				$nursingServicesCost['ServiceBill']['no_of_times'];
				$resetNursingServices[$nursingServicesCost['TariffList']['name']]['cost'] = $nursingServicesCost['TariffAmount'][$nursingServiceCostType];
			}
			$totalNursingCharges=0;
			foreach($resetNursingServices as $resetNursingServicesName=>$nursingService){
				$totalUnit = array_sum($nursingService['qty']);
				if($totalUnit==0){
					$totalUnit = 1;
				}
				$totalNursingCharges = $totalNursingCharges + $totalUnit*$nursingService['cost'];
			}

			$this->set('totalNursingCharges',$totalNursingCharges);
			/********************* Nursing Charges Ends *******************/
			 	
			/********************* Ward Charges Starts ********************/
			//$wardServicesDataNew = $this->getDay2DayWardCharges($id,$tariffStandardId);
			#$wardServicesDataNew = $this->getDay2DayCharges($id,$tariffStandardId);
			$wardServicesDataNew = $this->groupWardCharges($id);
			$totalWardNewCost=0;
			$totalWardDays=0;
			foreach($wardServicesDataNew as $uniqueSlot){
				if(isset($uniqueSlot['name'])){
					$totalWardNewCost = $totalWardNewCost + $uniqueSlot['cost'];
				}else{
					$wardNameKey = key($uniqueSlot);
					$wardCostPerWard = $uniqueSlot[$wardNameKey][0]['cost'];
					$totalWardNewCost = $totalWardNewCost + (count($uniqueSlot[$wardNameKey]) * $wardCostPerWard);
					$totalWardDays = $totalWardDays + count($uniqueSlot[$wardNameKey]);
				}
			}
			/********************* Ward Charges ends ********************/

			/***************************** Doctor, Nursing, Registration Charges Starts**************/

			$registrationCharges = $this->getRegistrationCharges($totalWardDays,$hospitalType,$tariffStandardId);
			$doctorCharges = $this->Billing->getDoctorCharges($totalWardDays,$hospitalType,$tariffStandardId,$admission_type);
			$nursingCharges = $this->Billing->getNursingCharges($totalWardDays,$hospitalType,$tariffStandardId);
			/***************************** Doctor, Nursing, Registration Charges ends**************/
			 	
			/************************** Lab Radiology Starts*******************/
			//BOF pankaj
			if($hospitalType=='NABH') $isNabh = 'nabh_charges';
			else $isNabh = 'non_nabh_charges';
			$testRates = $this->labRadRates($tariffStandardId,$id);//calling lab/radiology charges

			$labCost='';
			foreach($testRates['labRate'] as $labIndex){
				//if(!empty($labIndex['LaboratoryToken']['ac_id']) || !empty($labIndex['LaboratoryToken']['ac_id'])){
				$labCost += $labIndex['TariffAmount'][$isNabh];
				//}
			}
			$radCost='';
			foreach($testRates['radRate'] as $radIndex){
				$radCost += $radIndex['TariffAmount'][$isNabh];
					
			}
			//EOF pankaj
			/************************** Lab Radiology Ends*******************/

			// Lab Charges paid deduction
			$consultantCost = $this->Billing->calculateConsultantCharges($id);
			// Calculate other service charges
			$oServices = $this->calculateOtherServices($id);
			if(empty($oServices))
				$oServices =0;

			//registration charges hard coded 100 Rs//$wardServiceCost+. //100+$generalChargesCost+
			$doctorRate = $this->getDoctorRate($totalWardDays,$hospitalType,$tariffStandardId,$admission_type);

			if($admission_type == 'IPD') {
				// Anesthesia Charges Starts
				$this->OptAppointment->unbindModel(array(
						'belongsTo' => array('Initial','Patient','Location','Opt','OptTable','Surgery',
								'SurgerySubcategory','Doctor','DoctorProfile'
						)));
				$this->OptAppointment->bindModel(array(
						'belongsTo' => array(
								'Surgery' =>array(
										'foreignKey'=>'surgery_id'
								),
								'TariffAmount' =>array(
										'foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=Surgery.tariff_list_id','TariffAmount.tariff_standard_id'=>$tariffStandardId)
								),
								'AnaeTariffAmount' =>array('className'=>'TariffAmount',
										'foreignKey'=>false,
										'conditions'=>array('AnaeTariffAmount.tariff_list_id=OptAppointment.anaesthesia_tariff_list_id','AnaeTariffAmount.tariff_standard_id'=>$tariffStandardId)),
						)));
				$AnesthesiaDetails = 	$surgeriesData = $this->OptAppointment->find('all',array('fields'=>array('OptAppointment.procedure_complete','Surgery.anesthesia_charges','TariffAmount.*','AnaeTariffAmount.nabh_charges'
						,'AnaeTariffAmount.non_nabh_charges'), 'conditions'=>array('OptAppointment.patient_id'=>$id,'OptAppointment.is_deleted'=>0,
								'OptAppointment.location_id'=>$this->Session->read('locationid')),'group'=>array('OptAppointment.id')));

			}

			$anaesthesiaCharges=0;

			//EOD commneted
			if($hospitalType=='NABH') $isNabhCharges = 'nabh_charges';
			else $isNabhCharges = 'non_nabh_charges';

			foreach($AnesthesiaDetails as $anesthesiaDetail){
				$anaesthesiaCharges += $anesthesiaDetail['AnaeTariffAmount'][$isNabhCharges];
			}

			// Anesthesia Charges Ends


			$totalCost = $nursingCharges+$doctorCharges+$registrationCharges+$totalWardNewCost+
			$totalNursingCharges+$consultantCost+$pharmacy_total+$radCost+$labCost+$oServices-$pharmacy_cash_total+$anaesthesiaCharges;


			return $totalCost ;
		}//EOF if
	}//EOF function

	function dailyCashBook($fromLogout =false){
		$this->layout = 'advance';
		$this->uses = array('Billing','CashierBatch','User');
		$this->Billing->createBtachID();
		$this->CashierBatch->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey' => 'modified_by'),
						'UserAlias'=>array('foreignKey' => 'cashier_id','className'=>'User'),
						'Location' =>array('foreignKey' => 'location_id'),
				)),false);

		if(!empty($date)){
			$date = $this->DateFormat->formatDate2STD($date,Configure::read('date_format'));
		}else{
			$date = $this->Billing->getLastLoginDate();
		}
		$this->set('currentDate',$this->DateFormat->formatDate2Local($date,Configure::read('date_format')));
		$conditions = array('CashierBatch.location_id' => $this->Session->read('locationid'),'CashierBatch.date' => $date,'CashierBatch.type'=>'Cashier');
		$cashBookData = $this->CashierBatch->find('all',array('fields'=>array('Location.name','User.first_name','User.last_name','CashierBatch.*','UserAlias.first_name','UserAlias.last_name'),'conditions'=>$conditions));
		$this->set('cashBookData',$cashBookData);
		$this->set('fromLogout',$fromLogout);
	}

	function getLastLoginDate(){
		$session     = new cakeSession();
		$date = $session->read('last_login_billing');
		$dateFormatComponent = new DateFormatComponent();
		$date = $dateFormatComponent->formatDate2Local($date,'yyyy-mm-dd',true);
		$date = explode(" ",$date);
		$date = $date[0];
		return $date;
	}

	function createBtachID(){
		//Batch ID Date
		$session     = new cakeSession();
		$letters = range('A', 'Z');
		$cashierBatchModel = ClassRegistry::init('CashierBatch');
		$lastBatchPrefix = $cashierBatchModel->find('first',array('fields'=>array('LEFT(CashierBatch.batch_number, 1) as lastBatchPrefix','CashierBatch.id'),
				'conditions'=>array('CashierBatch.date'=>$this->getLastLoginDate()),'order' => array('CashierBatch.id' =>'DESC')));

		$generalComponent = new GeneralComponent();
		$dateFormat = $generalComponent->getCurrentStandardDateFormat();
		if(!empty($lastBatchPrefix['0']['lastBatchPrefix']))
			$currentBatchID = ++$lastBatchPrefix['0']['lastBatchPrefix'] .' '. $session->read('username'). ' '. date($dateFormat);
		else
			$currentBatchID = 'A '. $session->read('username'). ' '. date($dateFormat);
		return $currentBatchID;
	}

	public function getTotalCashDayAmount(){

		if(empty($date)){
			$date = $this->getLastLoginDate();
		}
		$billingModel = ClassRegistry::init('Billing');
		$billingModel->recursive = -1;
		$session     = new cakeSession();
		$billingConditions = array('DATE_FORMAT(Billing.date, "%Y-%m-%d")' => $date,'Billing.location_id'=>$session->read('locationid'),'Billing.mode_of_payment'=> array('Cash','Credit Card'));
		$billingData = $billingModel->find('all',array('conditions' => $billingConditions,'fields'=>array('DATE_FORMAT(LAST_DAY(Billing.date),"%d") as DAY',
				'MONTH(Billing.date) as MONTH','SUM(copay_amount) as copay_amount','SUM(primary_insurance_amount) as primary_insurance_amount',
		)
				,'group' => array('DAY')));
		$todaysCollection = (int) $billingData['0']['0']['copay_amount'] + (int) $billingData['0']['0']['primary_insurance_amount'];
		return $todaysCollection;
		//pr($todaysCollection);exit;
	}

	function getLastFiledAmountByUser(){
		$cashierBatchModel = ClassRegistry::init('CashierBatch');
		$session     = new cakeSession();
		$userCashBatches = $cashierBatchModel->find('all',array('fields'=>array('SUM(overriden_amount) as overriden_amount','CashierBatch.id'),
				'conditions'=>array('CashierBatch.modified_by' =>$session->read('userid'),'CashierBatch.date'=>$this->getLastLoginDate()),'order' => array('CashierBatch.id' =>'DESC')));
		return $userCashBatches['CashierBatch']['overriden_amount'];
	}

	function getOpeningBalanceOfCashier(){
		$cashierBatchModel = ClassRegistry::init('CashierBatch');
		$date = $this->getLastLoginDate();
		$openingBalanceDetails = $cashierBatchModel->find('all',array('fields'=>array('SUM(CashierBatch.overriden_amount) as openingBalance','SUM(CashierBatch.total_amount_overidden) as totalOpeningBalance'),'conditions'=>array('CashierBatch.date'=>$date)));
		return $openingBalanceDetails;
	}

	function fileDailyCash($mode=null){
		$this->layout = 'advance_ajax';
		$this->uses = array('Configuration','Message','Billing','CashierBatch','Location','Account','VoucherEntry','VoucherLog','AccountReceipt','VoucherPayment','User','ContraEntry');
		
		$date = $this->Billing->getLastLoginDate();
		//for location
		$this->Location->unBindModel( array('belongsTo'=> array('City','State','Country'))) ;
		$locationDetalis = $this->Location->find('first',array('fields'=>array('Location.name'),'conditions'=>array('Location.is_deleted' => '0','Location.is_active'=>'1','Location.id'=>$this->Session->read('locationid'))));
		$locations = $locationDetalis['Location']['name'];
		$this->set('locations',$locations);
		//EOF location
			
		//For accountManager list and cashier list
		$acccountManager   = $this->Billing->getUserList(Configure::read('accountManager_role')) ; 
		$management   = $this->Billing->getUserList(Configure::read('management_role')) ; 
		$this->set('agentName',array_merge($acccountManager,$management));
		$this->set('userName',$this->Billing->getUserList(Configure::read('cashier_role'),$this->Session->read('userid')));
		//EOF cashier list
			
		//For startDate
		$getStartDate = $this->CashierBatch->find('first',array('fields'=>array('start_transaction_date','id'),
				'conditions'=>array('CashierBatch.type' =>'Cashier','CashierBatch.user_id'=>$this->Session->read('userid')),
				'order' =>array('CashierBatch.id' => 'DESC')));
		
		$startDate = $getStartDate['CashierBatch']['start_transaction_date'];
		$this->set('cashierBatchId',$getStartDate['CashierBatch']['id']);
		//EOF
			
		//for opening balance
		$batchDetails = $this->CashierBatch->find('first',array('fields'=>array('CashierBatch.handover_shift_cash'),
				'conditions'=>array('CashierBatch.date NOT' =>null,'CashierBatch.cashier_id'=>$this->Session->read('userid')),
				'order' =>array('CashierBatch.id' => 'DESC')));
		$this->set('openingBalance',$batchDetails['CashierBatch']['handover_shift_cash']);

		//EOF opening
			
		//For agent balance deduct after cash handover
		$paymentDetails = $this->VoucherPayment->find('all',array('fields'=>array('SUM(VoucherPayment.paid_amount) as totalAgentAmount'),
				'conditions'=>array('VoucherPayment.type'=>'CashierAgent','VoucherPayment.is_posted_cash'=>'0','VoucherPayment.create_time >='=>$startDate)));
		$agentAmount = $paymentDetails['0']['0']['totalAgentAmount'];
		//EOF cash handover
		$this->set('currentDate',$this->DateFormat->formatDate2Local($date,Configure::read('date_format')));
		$this->set('batchId',$this->Billing->createBtachID());
		$this->set('autologout',$mode);
		
		//get agent transaction Amount for opening balance
		
		//For startDate
		$getAgentStartDate = $this->CashierBatch->find('first',array('fields'=>array('start_transaction_date','id','user_id'),
				'conditions'=>array('CashierBatch.type' =>'Agent','CashierBatch.user_id'=>$this->Session->read('userid')),
				'order' =>array('CashierBatch.id' => 'DESC')));
		$agentUserId = $getAgentStartDate['CashierBatch']['user_id'];
		$startAgentDate = $getAgentStartDate['CashierBatch']['start_transaction_date'];
		$this->set('cashierBatchAgentId',$getAgentStartDate['CashierBatch']['id']);
		//EOF
		
		$getAgentOpeningBalance = $this->CashierBatch->find('first',array('fields'=>array('CashierBatch.overriden_amount'),
				'conditions'=>array('CashierBatch.user_id' =>$this->Session->read('userid'),'DATE_FORMAT(CashierBatch.date,"%Y-%m-%d") NOT' =>date('Y-m-d')),
				'order' =>array('CashierBatch.id' => 'DESC')));

		$this->set('agentOpeningBalance',$getAgentOpeningBalance['CashierBatch']['overriden_amount']);
		//EOF opening
		$this->set('getAgentAmount',$this->Billing->getAgentDailyTransactionAmount($startAgentDate));
		//
		$getAmount=$this->Billing->getCashierDailyTransactionAmount($startDate);
		$this->set('collectionAmount',$getAmount['0']);
		$this->set('noOfTransactions',$getAmount['1']);
		$this->set('totalAmountReceived',$getAmount['2']);
		$this->set('totalAmountRefund',$getAmount['3']);
		$this->Set('agentAmount',$agentAmount);
		$totalCash=($batchDetails['CashierBatch']['handover_shift_cash'] + $getAmount['2'] - $getAmount['3'] - $agentAmount);
		$this->set('totalCash',$totalCash);
		$amount = $this->Billing->getLastReceiptAmount($startDate);
		
		if(!empty($this->request->data)){

			if($this->request->data['CashierBatch']['type']=='Agent'){
				$cashierData['CashierBatch']['id'] = $getAgentStartDate['CashierBatch']['id'];
				$cashierData['CashierBatch']['start_transaction_date'] = $startAgentDate;
				$cashierData['CashierBatch']['end_transaction_date'] = date("Y-m-d H:i:s");
				$cashierData['CashierBatch']['posting_organization'] = $this->Session->read('locationid');
				$cashierData['CashierBatch']['location_id'] = $this->Session->read('locationid');
				$cashierData['CashierBatch']['trans_posted'] = $this->request->data['CashierBatch']['trans_posted'];
				$cashierData['CashierBatch']['opening_balance'] = $this->request->data['CashierBatch']['opening_balance'];
				$cashierData['CashierBatch']['overriden_amount'] = $this->request->data['CashierBatch']['total_cash'];
				$cashierData['CashierBatch']['type'] = $this->request->data['CashierBatch']['type'];
				$cashierData['CashierBatch']['date'] = date("Y-m-d H:i:s");
				$cashierData['CashierBatch']['default_svc_date'] = date("Y-m-d H:i:s");
				$cashierData['CashierBatch']['created_by'] = $this->Session->read('userid');
				$cashierData['CashierBatch']['modified_by'] = $this->Session->read('userid');
				$cashierData['CashierBatch']['modify_time'] = date("Y-m-d H:i:s");
					
				if($this->CashierBatch->save($cashierData)){
					$this->VoucherPayment->updateAll(array('is_posted_cash'=>'1'),array('VoucherPayment.create_by'=>$this->Session->read('userid'),
							'VoucherPayment.location_id'=>$this->Session->read('locationid'),'VoucherPayment.type'=>'CashierAgent'));
					echo true;
				}else{
					echo false;
				}exit;
			}else{
				//BOF for payment voucher when cash hand over to agent
				if(!empty($this->request->data['CashierBatch']['cash_handover']) && !empty($this->request->data['CashierBatch']['agent_id'])){
					$this->getAgentPV($this->request->data);
				}
				//EOF pv
				
				//BOF Excess Amount pv to current cashier
				if($this->request->data['CashierBatch']['balance_amount'] < 0){
					$this->getExcessAmountPV($this->request->data);
				}
				//EOF pv
				
				//BOF Short Amount jv to current cashier
				if($this->request->data['CashierBatch']['balance_amount'] > 0){
					$this->getShortAmountJV($this->request->data);
				}
				//EOF jv
				//$cashierData['CashierBatch']['id'] = $getStartDate['CashierBatch']['id'];
				$cashierData['CashierBatch']['last_posting'] = $amount;
				$cashierData['CashierBatch']['end_transaction_date'] = date("Y-m-d H:i:s");
				$cashierData['CashierBatch']['batch_number'] = $this->request->data['CashierBatch']['batch_number'];
				$cashierData['CashierBatch']['posting_organization'] = $this->request->data['CashierBatch']['posting_organization'];
				$cashierData['CashierBatch']['location_id'] = $this->Session->read('locationid');
				$cashierData['CashierBatch']['trans_posted'] = $this->request->data['CashierBatch']['trans_posted'];
				$cashierData['CashierBatch']['cash_handover'] = $this->request->data['CashierBatch']['cash_handover'];
				$cashierData['CashierBatch']['agent_id'] = $this->request->data['CashierBatch']['agent_id'];
				$cashierData['CashierBatch']['handover_shift_cash'] = $this->request->data['CashierBatch']['handover_shift_cash'];
				$cashierData['CashierBatch']['cashier_id'] = $this->request->data['CashierBatch']['cashier_id'];
				$cashierData['CashierBatch']['opening_balance'] = $this->request->data['CashierBatch']['opening_balance'];
				$cashierData['CashierBatch']['overriden_amount'] = $this->request->data['CashierBatch']['handover_shift_cash'];
				$cashierData['CashierBatch']['date'] = $this->DateFormat->formatDate2STD($this->request->data['CashierBatch']['date'],Configure::read('date_format'));
				$cashierData['CashierBatch']['default_svc_date'] = $this->DateFormat->formatDate2STD($this->request->data['CashierBatch']['default_svc_date'],Configure::read('date_format'));
				$cashierData['CashierBatch']['created_by'] = $this->Session->read('userid');
				$cashierData['CashierBatch']['modified_by'] = $this->Session->read('userid');
				$cashierData['CashierBatch']['modify_time'] = date("Y-m-d H:i:s");
				
				$openingBalanceDetails = $this->Billing->getOpeningBalanceOfCashier();
				
				(int) $cashierData['CashierBatch']['total_amount_overidden'] = (int) $openingBalanceDetails['0']['0']['openingBalance'];
				$cashierBatchId = $getStartDate['CashierBatch']['id'];				
				if($this->CashierBatch->save($cashierData)){
					///BOF-Mahalaxmi-For send SMS to Owner & Cashier								
					$smsActive=$this->Configuration->getConfigSmsValue('Cashier Handover');		

					if($smsActive){							
						if(!empty($this->request->data['CashierBatch']['handover_shift_cash'])){								
								$showMsg= sprintf(Configure::read('cashHanover'),$this->request->data['CashierBatch']['collected_agent_amount_D'],$this->request->data['CashierBatch']['handover_shift_cash']);	
								$this->Message->sendToSms($showMsg,Configure::read('CahsierNo'));
						}
					}
				
				///EOF-Mahalaxmi-For send SMS to Owner & Cashier
					$this->AccountReceipt->updateAll(array('is_posted_cash'=>'1'),array('AccountReceipt.create_by'=>$this->Session->read('userid'),
							'AccountReceipt.location_id'=>$this->Session->read('locationid')));
					$this->VoucherPayment->updateAll(array('is_posted_cash'=>'1'),array('VoucherPayment.create_by'=>$this->Session->read('userid'),
							'VoucherPayment.location_id'=>$this->Session->read('locationid'),'VoucherPayment.type NOT'=>'CashierAgent'));
					echo true;
				}else{
					echo false;
				}exit;
			}
		}
	}

	 function getCashierTransactions($id){
	 $this->layout = false;
		if($id){
		$this->uses = array('AccountReceipt','VoucherPayment','CashierBatch','Account','User');
		
		$batchDetails = $this->CashierBatch->find('first',array('fields'=>array('start_transaction_date','end_transaction_date','opening_balance','user_id'),
				'conditions'=>array('id'=>$id))); 
		$startDate = $batchDetails['CashierBatch']['start_transaction_date'];
		$endDate = $batchDetails['CashierBatch']['end_transaction_date'];
		$cashierId = $batchDetails['CashierBatch']['user_id'];
		$this->set('batchDetails',$batchDetails);
		$cashId = $this->Account->getAccountIdOnly(Configure::read('cash'));//for cash id
		if($startDate && $endDate){
			$rConditions['AccountReceipt.create_time >=']=$startDate;
			$pConditions['VoucherPayment.create_time >=']=$startDate;
			
			$rConditions['AccountReceipt.create_time <=']=$endDate;
			$pConditions['VoucherPayment.create_time <=']=$endDate;
		}
		$rConditions['AccountReceipt.account_id =']=$cashId;
		$pConditions['VoucherPayment.account_id =']=$cashId;
		
		$rConditions['AccountReceipt.is_deleted =']='0';
		$pConditions['VoucherPayment.is_deleted =']='0';
		
		$rConditions['AccountReceipt.create_by =']=$cashierId;
		$pConditions['VoucherPayment.create_by =']=$cashierId;
		
		$pConditions['VoucherPayment.type']=array('Refund','CashierAgent');
		//for payment entry by amit jain
			 $this->VoucherPayment->bindModel(array(
					'belongsTo'=>array(
							'Account'=>array('foreignKey'=>'user_id','conditions'=>array('VoucherPayment.user_id=Account.id')),
							'User' =>array('foreignKey' => false,'conditions'=>array('VoucherPayment.modified_by=User.id')),
					)),false);
			$paymentDetails = $this->VoucherPayment->find('all',array('fields'=>array('User.last_name','User.first_name','VoucherPayment.id',
					'VoucherPayment.paid_amount','VoucherPayment.date','VoucherPayment.account_id','VoucherPayment.narration','Account.name'),
					'conditions'=>$pConditions,'order' =>array('VoucherPayment.date' => 'ASC'))); 
			$this->set('paymentDetails',$paymentDetails);
		
		//for receipt entry by amit jain
			$this->AccountReceipt->bindModel(array(
					'belongsTo'=>array(
							'Account'=>array('foreignKey'=>'user_id','conditions'=>array('AccountReceipt.user_id=Account.id')),
							'User' =>array('foreignKey' => false,'conditions'=>array('AccountReceipt.modified_by=User.id')),
					)),false);
			$receiptDetails = $this->AccountReceipt->find('all',array('fields'=>array('User.last_name','User.first_name','AccountReceipt.id',
					'AccountReceipt.paid_amount','AccountReceipt.date','AccountReceipt.account_id','AccountReceipt.narration','Account.name'),
					'conditions'=>$rConditions,'order' =>array('AccountReceipt.date' => 'ASC')));
			$this->set('receiptDetails',$receiptDetails);
		}
	}
	
	//amit jain
	function getAllCashierTransactions($Reporttype=null){
		$this->layout = 'advance';
		$new_type = $this->request->data['Voucher']['type'];
		$this->uses = array('VoucherPayment','Account','AccountReceipt','User','ContraEntry');
		if(!empty($this->params->query)){
			$this->request->data['Voucher']=$this->params->query;
		}
		$new_type = $this->request->data['Voucher']['type'];
		$isHide = $this->request->data['Voucher']['isHide'];
		if($this->request->data){
			//this condition for amount search by amit jain
			$amount=$this->request->data['Voucher']['amount'];
			if(!empty($this->request->data['Voucher']['amount'])){
				$Pconditions['VoucherPayment.paid_amount']=$amount;
				$Rconditions['AccountReceipt.paid_amount']=$amount;
				$Cconditions['ContraEntry.debit_amount']=$amount;
			}
			$manager_name = $this->request->data['Voucher']['manager_type'];
			if(!empty($this->request->data['Voucher']['manager_type'])){
				$Pconditions['VoucherPayment.modified_by']=$manager_name;
				$Rconditions['AccountReceipt.modified_by']=$manager_name;
				$Cconditions['ContraEntry.modified_by']=$manager_name;
			}
			$user_name = $this->request->data['Voucher']['user_type'];
			if(!empty($this->request->data['Voucher']['user_type'])){
				$Pconditions['VoucherPayment.modified_by']=$user_name;
				$Rconditions['AccountReceipt.modified_by']=$user_name;
				$Cconditions['ContraEntry.modified_by']=$user_name;
			}
			//this condition for narration search by amit jain
			$narration=$this->request->data['Voucher']['narration'];
			if(!empty($this->request->data['Voucher']['narration'])){
				$Pconditions['VoucherPayment.narration LIKE']='%'.$narration.'%';
				$Rconditions['AccountReceipt.narration LIKE']='%'.$narration.'%';
				$Cconditions['ContraEntry.narration LIKE']='%'.$narration.'%';
			}
			if(!empty($this->request->data['Voucher']['from'])){
				$fromDate = $this->DateFormat->formatDate2STDForReport($this->request->data['Voucher']['from'],Configure::read('date_format'))." 00:00:00";

				$Pconditions['VoucherPayment.date >=']=$fromDate;
				$Rconditions['AccountReceipt.date >=']=$fromDate;
				$Cconditions['ContraEntry.date >=']=$fromDate;
				$from=$this->request->data['Voucher']['from'];

				$balanceDateA['AccountReceipt.date <']=$fromDate;
				$balanceDateP['VoucherPayment.date <']=$fromDate;
				$balanceDateC['ContraEntry.date <']=$fromDate;
			}else{
				
				$dateArray = date('Y-m-d').' 00:00:00';
				$Pconditions['VoucherPayment.date >='] = $dateArray;
				$Rconditions['AccountReceipt.date >='] = $dateArray;
				$Cconditions['ContraEntry.date >='] = $dateArray;
				
				$balanceDateA['AccountReceipt.date <']=$dateArray;
				$balanceDateP['VoucherPayment.date <']=$dateArray;
				$balanceDateC['ContraEntry.date <']=$dateArray;
				$from=date('d/m/Y');
			}
			if(!empty($this->request->data['Voucher']['to'])){
				$toDate = $this->DateFormat->formatDate2STDForReport($this->request->data['Voucher']['to'],Configure::read('date_format'))." 23:59:59";
				$Pconditions['VoucherPayment.date <=']=$toDate;
				$Rconditions['AccountReceipt.date <=']=$toDate;
				$Cconditions['ContraEntry.date <=']=$toDate;
				$to=$this->request->data['Voucher']['to'];
					
			}else{
				$date = date('Y-m-d H:i:s');
				$Pconditions['VoucherPayment.date <=']=$date;
				$Rconditions['AccountReceipt.date <=']=$date;
				$Cconditions['ContraEntry.date <=']=$date;
				$to=date('d/m/Y');
			}
			$Pconditions['VoucherPayment.location_id'] =$this->Session->read('locationid');
			$Rconditions['AccountReceipt.location_id'] =$this->Session->read('locationid');
			$Cconditions['ContraEntry.location_id'] = $this->Session->read('locationid');
		}
		$Pconditions['VoucherPayment.paid_amount NOT'] = array('0','');
		$Rconditions['AccountReceipt.paid_amount NOT'] = array('0','');

		$Pconditions['VoucherPayment.is_deleted'] = 0;
		$Rconditions['AccountReceipt.is_deleted'] = 0;
		$Cconditions['ContraEntry.is_deleted'] = 0;

		$Pconditions['VoucherPayment.location_id'] =$this->Session->read('locationid');
		$Rconditions['AccountReceipt.location_id'] =$this->Session->read('locationid');
		$Cconditions['ContraEntry.location_id'] = $this->Session->read('locationid');

		if(empty($this->request->data)){
			$dateArray = date('Y-m-d').' 00:00:00';
			$Pconditions['VoucherPayment.date >='] = $dateArray;
			$Rconditions['AccountReceipt.date >='] = $dateArray;
			$Cconditions['ContraEntry.date >='] = $dateArray;

			$balanceDateA['AccountReceipt.date <']=$dateArray;
			$balanceDateP['VoucherPayment.date <']=$dateArray;
			$balanceDateC['ContraEntry.date <']=$dateArray;
			$from=date('d/m/Y');
			$to=date('d/m/Y');
		}
		$balanceDateP['VoucherPayment.type !='] ='MLCharges';
		$Pconditions['VoucherPayment.type !='] ='MLCharges';
		
		$cashId = $this->Account->getAccountIdOnly(Configure::read('cash'));//for cash id
		
		$cashBalance = $this->Account->find('first',array('fields'=>array('Account.opening_balance'),
				'conditions'=>array('Account.id'=>$cashId,'Account.is_deleted'=>0,'Account.location_id'=>$this->Session->read('locationid'))));
		
		$balanceAmountReceipt = $this->AccountReceipt->find('all',array('fields'=>array('SUM(AccountReceipt.paid_amount) as totalReceiptBalance'),
				'conditions'=>array('AccountReceipt.account_id'=>$cashId,'AccountReceipt.is_deleted'=>0,$balanceDateA,
						'AccountReceipt.location_id'=>$this->Session->read('locationid'))));
		
		$balanceAmountPayment = $this->VoucherPayment->find('all',array('fields'=>array('SUM(VoucherPayment.paid_amount) as totalPaymentBalance'),
				'conditions'=>array('VoucherPayment.account_id'=>$cashId,'VoucherPayment.is_deleted'=>0,$balanceDateP,
						'VoucherPayment.location_id'=>$this->Session->read('locationid'))));
		
		$balanceAmountContraDebit = $this->ContraEntry->find('all',array('fields'=>array('SUM(ContraEntry.debit_amount) as totalDebitBalance'),
				'conditions'=>array('ContraEntry.account_id'=>$cashId,'ContraEntry.is_deleted'=>0,$balanceDateC,
						'ContraEntry.location_id'=>$this->Session->read('locationid'))));
		
		$balanceAmountContraCredit = $this->ContraEntry->find('all',array('fields'=>array('SUM(ContraEntry.debit_amount) as totalCreditBalance'),
				'conditions'=>array('ContraEntry.user_id'=>$cashId,'ContraEntry.is_deleted'=>0,$balanceDateC,
						'ContraEntry.location_id'=>$this->Session->read('locationid'))));
		
		$debit = $balanceAmountReceipt['0']['0']['totalReceiptBalance'] + $balanceAmountContraDebit['0']['0']['totalDebitBalance'];
		$credit = $balanceAmountPayment['0']['0']['totalPaymentBalance'] + $balanceAmountContraCredit['0']['0']['totalCreditBalance'];
		$openingBalance = $cashBalance['Account']['opening_balance']+($debit - $credit);
		if($openingBalance<0){
			$type='Cr';
			$openingBalance=-($openingBalance);
		}else{
			$type='Dr';
			$openingBalance=$openingBalance;
		}

		//for payment entry by amit jain
		$this->VoucherPayment->bindModel(array(
				'belongsTo'=>array(
						'Account'=>array('foreignKey'=>'user_id','conditions'=>array('VoucherPayment.user_id=Account.id')),
						'User' =>array('foreignKey' => false,'conditions'=>array('VoucherPayment.modified_by=User.id')),
				)),false);
		$voucherPaymentDetails = $this->VoucherPayment->find('all',array('fields'=>array('User.last_name','User.first_name','VoucherPayment.id',
				'VoucherPayment.paid_amount','VoucherPayment.date','VoucherPayment.account_id','VoucherPayment.narration','VoucherPayment.type','Account.name'),
				'conditions'=>array('OR'=>array('VoucherPayment.account_id'=>$cashId,'VoucherPayment.user_id'=>$cashId),$Pconditions),
				'order' =>array('VoucherPayment.date' => 'ASC')));

		//for receipt entry by amit jain
		$this->AccountReceipt->bindModel(array(
				'belongsTo'=>array(
						'Account'=>array('foreignKey'=>'user_id','conditions'=>array('AccountReceipt.user_id=Account.id')),
						'User' =>array('foreignKey' => false,'conditions'=>array('AccountReceipt.modified_by=User.id')),
				)),false);

		$transactionPaidAccounts = $this->AccountReceipt->find('all',array('fields'=>array('User.last_name','User.first_name','AccountReceipt.id',
				'AccountReceipt.paid_amount','AccountReceipt.date','AccountReceipt.account_id','AccountReceipt.narration','Account.name'),
				'conditions'=>array('OR'=>array('AccountReceipt.account_id'=>$cashId,'AccountReceipt.user_id'=>$cashId),$Rconditions),
				'order' =>array('AccountReceipt.date' => 'ASC')));

		//for contra entry by amit jain
		$this->ContraEntry->bindModel(array(
				'belongsTo'=>array(
						'Account'=>array('foreignKey'=>'user_id','conditions'=>array('ContraEntry.user_id=Account.id')),
						"AccountAlias"=>array('className'=>'Account',"foreignKey"=>'account_id' ,'conditions'=>array('ContraEntry.account_id=AccountAlias.id')),
						'User' =>array('foreignKey' => false,'conditions'=>array('ContraEntry.created_by=User.id')),
				)),false);
		$transactionContraEntry = $this->ContraEntry->find('all',array('fields'=>array('User.last_name','User.first_name','ContraEntry.id',
				'ContraEntry.debit_amount','ContraEntry.date','ContraEntry.account_id','ContraEntry.narration','Account.name','AccountAlias.name'),
				'conditions'=>array('OR'=>array('ContraEntry.account_id'=>$cashId,'ContraEntry.user_id'=>$cashId),$Cconditions),
				'order' =>array('ContraEntry.date' => 'ASC')));
		
		$this->set('userName',$this->Billing->getUserList(Configure::read('cashier_role')));
		$this->set('accountManagerName',$this->Billing->getUserList(Configure::read('accountManager_role')));
		$this->set('transactionPaidAccounts',$transactionPaidAccounts);
		$this->set('voucherPaymentDetails',$voucherPaymentDetails);
		$this->set('transactionContraEntry',$transactionContraEntry);
		if(empty($from)){
			$from = $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'));
		}
		if(empty($to)){
			$to = $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'));
		}
		$this->set(compact('from','to','openingBalance','type','narration','amount','dateArray','new_type','isHide'));
		if($Reporttype=='excel'){
			$this->layout=false;
			$this->render('cash_book_xls',false);
		}
	}

	public function getTodayPayment($id,$val)
	{
		$this->uses = array('Patient');
		$this->autoRender = false;
		$this->Layout = 'ajax';
		if($val!=NULL && !empty($id)){
			$this->request->data['Patient']['id']=$id;
			$this->request->data['Patient']['amount_to_pay_today'] = $val;
			if($this->Patient->validates())
			$this->Patient->save($this->request->data);
		}
	}

	/*******************************************************************************************************************/


	//from admin_rgjay_report
	public function billUploadDate($id)
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->uses = array('FinalBilling') ;

		if($this->request->data)
		{
			$this->FinalBilling->id = $id;
			$dischargeDate = $this->DateFormat->formatDate2STDForReport($this->request->data['date'],Configure::read('date_format'));
			$this->request->data['FinalBilling']['bill_uploading_date'] = $dischargeDate;
			//debug($this->request->data);
			$this->FinalBilling->save($this->request->data);
		}
	}

	/*******************************************************************************************************************/

	//from admin_rgjay_report
	public function drClaimDate($id)
	{

		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->uses = array('FinalBilling') ;

		if($this->request->data)
		{
			$this->FinalBilling->id = $id;
			$dischargeDate = $this->DateFormat->formatDate2STDForReport($this->request->data['date'],Configure::read('date_format'));
			$this->request->data['FinalBilling']['dr_claim_date'] = $dischargeDate;
			$this->FinalBilling->save($this->request->data);
		}
	}

	/*******************************************************************************************************************/

	//from admin_rgjay_report
	public function CMOclaimDate($id)
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->uses = array('FinalBilling') ;

		if($this->request->data)
		{
			$this->FinalBilling->id = $id;
			$dischargeDate = $this->DateFormat->formatDate2STDForReport($this->request->data['date'],Configure::read('date_format'));
			$this->request->data['FinalBilling']['CMO_claim_date'] = $dischargeDate;
			//debug($this->request->data);
			$this->FinalBilling->save($this->request->data);
		}
	}

	/*******************************************************************************************************************/

	//from admin_rgjay_report
	public function getCMOapprove($id)
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->uses = array('FinalBilling');

		if($this->request->data)
		{
			$this->FinalBilling->id = $id;	//$id holds the patient's id
			$this->request->data['FinalBilling']['CMO_claim_pending_approval'] = $this->request->data['status'];
			//$this->request->data['Patient']['extension_status'] = $status;		//changing the extension_status to approved by 1
			//debug($this->request->data);
			$this->FinalBilling->save($this->request->data);		//update the extension_status of patient
		}


	}

	/*******************************************************************************************************************/

	//from admin_rgjay_report
	public function getDrClaimApprove($id)
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->uses = array('FinalBilling');

		if($this->request->data)
		{
			$this->FinalBilling->id = $id;	//$id holds the patient's id
			$this->request->data['FinalBilling']['dr_claim_pending_approval'] = $this->request->data['status'];
			//$this->request->data['Patient']['extension_status'] = $status;		//changing the extension_status to approved by 1
			//debug($this->request->data);
			$this->FinalBilling->save($this->request->data);		//update the extension_status of patient
		} 
	} 
	/*******************************************************************************************************************/ 

	//from admin_rgjay_report
	public function getPackageAmount($id,$amount,$patientId)
	{
            $this->autoRender = false;
            $this->layout = 'ajax';
            $this->uses = array('FinalBilling');  

            if(!empty($patientId) && !empty($amount)){ //update actual amount received from company
                $this->Billing->save(array(
                    'amount'=>$amount,
                    'payment_category'=>'Finalbill', 
                    'date'=>date("Y-m-d H:i:s"),
                    'patient_id'=>$patientId,
                    'mode_of_payment'=>'Cash', 
                    'user_id'=>$this->Session->read('userid'),
                    'location_id'=>$this->Session->read('locationid')
                ));

                $lastNotesId=$this->Billing->getLastInsertID();
                $billNo=$this->generateBillNoPerPay($patientId,$lastNotesId);
                $updateBillingArray=array('Billing.bill_number'=>"'$billNo'");
                $this->Billing->updateAll($updateBillingArray,array('Billing.patient_id'=>$patientId,'Billing.id'=>$lastNotesId)); 
                $this->Billing->id= '' ;
            }
	} 

	public function updatePackageAmount($id){
		$this->layout = "ajax";
		$this->uses = array('FinalBilling'); 
                $this->request->data['corporateClaims'] = ($this->request->data);
		if($this->request->data['corporateClaims']){ 
                    if($this->request->data['corporateClaims']['bill_uploading_date']){
                        $this->request->data['corporateClaims']['bill_uploading_date'] = $this->DateFormat->formatDate2STD($this->request->data['corporateClaims']['bill_uploading_date'],Configure::read('date_format'));
                    }

                    if($this->request->data['corporateClaims']['patient_id'] && !empty($this->request->data['corporateClaims']['cmp_amt_paid'])){ //update actual amount received from company
                        $this->Billing->save(array(
                            'amount'=>$this->request->data['corporateClaims']['cmp_amt_paid'],
                            'payment_category'=>'CorporateAdvance',
                            'remark'=>$this->request->data['corporateClaims']['remark'],
                            'bill_number'=>$this->request->data['corporateClaims']['bill_number'],
                            'date'=>$this->request->data['corporateClaims']['bill_uploading_date'],
                            'discount'=>$this->request->data['corporateClaims']['other_deduction'],
                            'discount_amount'=>$this->request->data['corporateClaims']['other_deduction'],
                            'patient_id'=>$this->request->data['corporateClaims']['patient_id'],
                            'mode_of_payment'=>'cash',
                            'discount_type'=>'amount',
                            'location_id'=>$this->Session->read('locationid')
                        ));
                        $this->Billing->id= '' ;
                    }

                    if($this->request->data['corporateClaims']['patient_id'] && !empty($this->request->data['corporateClaims']['tds'])){ //update deducted TDS 
                        $this->Billing->save(array(
                            'amount'=>$this->request->data['corporateClaims']['tds'],
                            'payment_category'=>'TDS',
                            'remark'=>$this->request->data['corporateClaims']['remark'],
                            'bill_number'=>$this->request->data['corporateClaims']['bill_number'],
                            'date'=>$this->request->data['corporateClaims']['bill_uploading_date'], 
                            'patient_id'=>$this->request->data['corporateClaims']['patient_id'],
                            'location_id'=>$this->Session->read('locationid')
                            //'mode_of_payment'=>'cash', this amount is not actully come to hospital but still to close patient legder will update TDS As a advance   
                        ));
                        $this->Billing->id= '' ;
                    }
                    
                    if($this->request->data['corporateClaims']['patient_id'] && !empty($this->request->data['corporateClaims']['package_amount'])){ 
                        $this->Billing->save(array(
                            'amount'=>$this->request->data['corporateClaims']['package_amount'],
                            'payment_category'=>'Finalbill', 
                            'date'=>date("Y-m-d H:i:s"),
                            'patient_id'=>$this->request->data['corporateClaims']['patient_id'],
                            'mode_of_payment'=>'Cash', 
                            'user_id'=>$this->Session->read('userid'),
                            'location_id'=>$this->Session->read('locationid') 
                        ));  
                        $lastNotesId=$this->Billing->getLastInsertID();
                        $billNo=$this->generateBillNoPerPay($patientId,$lastNotesId);
                        $updateBillingArray=array('Billing.bill_number'=>"'$billNo'");
                        $this->Billing->updateAll($updateBillingArray,array('Billing.patient_id'=>$this->request->data['corporateClaims']['patient_id'],'Billing.id'=>$lastNotesId)); 
                        $this->Billing->id= '' ;  
                    }
		}
		exit;
	}

	/****************************************************************************************************************/

	//for admin_mahindra_report


	public function getOtherDeduction($id,$amount)
	{

		//debug($id);

		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->uses = array('FinalBilling');

		if(!empty($id))
		{
			$this->FinalBilling->id = $id;	//$id holds the patient's id
			$this->request->data['FinalBilling']['other_deduction'] = $amount;
			$this->FinalBilling->save($this->request->data);
		}

	}

	/*******************************************************************************************************************/



	//for admin_mahindra_report

	public function getTds($id,$val)
	{

		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->uses = array('FinalBilling');
			
		if(!empty($id))
		{
			$this->FinalBilling->id = $id;	//$id holds the patient's id

			$this->request->data['FinalBilling']['tds'] = $val;
			//$this->request->data['FinalBilling']['other_deduction'] = $otherDeduct;
			$this->FinalBilling->save($this->request->data);
		}

	}

	/*******************************************************************************************************************/

	// for mahindra- other deduction with flag
	public function setDeductFlag($id,$val,$flag)
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->uses = array('FinalBilling');
		if(!empty($id))
		{
			if(!empty($flag) && $flag==1)
			{
				$this->FinalBilling->id = $id;
				$this->data['FinalBilling']['other_deduction']	= $val;
				$this->data['FinalBilling']['other_deduction_modified'] = $flag;
				$this->FinalBilling->save($this->request->data);

			}
		}
	}
	// store updated value of otherdeduction
	public function getModifiedOtherDeduction($flag,$val,$id)
	{
		$this->uses = array('FinalBilling');
		$this->autoRender=false;
		$this->Layout = 'ajax';
		// debug($id);
		if(!empty($id))
		{
			if(!empty($flag) && $flag==1)
			{
				$this->FinalBilling->id = $id;
				$this->request->data['FinalBilling']['other_deduction'] = $val; 
				$this->request->data['FinalBilling']['other_deduction_modified'] = $flag; 
				$this->FinalBilling->save($this->request->data);
			}
		}
	}

	//to delete the services from generate invoice
	//by swapnil
	public function deleteServicesCharges($billingId,$patientId,$groupId=null){//debug($billingId);debug($this->params->query['Flag']);exit;
		$this->loadModel('ServiceBill');
		$discount=$this->ServiceBill->find('first',array('fields'=>array('discount'),'conditions'=>array('id'=>$billingId)));
		$this->ServiceBill->updateAll(array('is_deleted'=>'1'),array('id'=>$billingId));
		$this->Billing->discountDeleteEntry($patientId,$groupId,$discount['ServiceBill']['discount']);//-(discount) entry--pooja
		$this->Session->setFlash(__('Record deleted successfully', true));
		if($this->params->query['Flag']=='opdBill'){
			exit;
			//$this->redirect(array("controller" => "billings", "action" => "multiplePaymentMode",$patientId ));
		}else{
			$this->redirect(array("controller" => "billings", "action" => "patient_information",$patientId,'servicesSection'));
		}
	}



	public function deleteTest($testId,$patientId,$render){
		switch($render){
			case 'mri':		$section = "MriSection"; 		break;
			case 'ct':		$section = "CTSection";			break;
			case 'implant': $section = "ImplantSection";	break;
			default: 		$section = ''; 					break;
		}
		if(!empty($testId)){
			$this->loadModel('RadiologyTestOrder');
			$this->RadiologyTestOrder->save(array('id'=>$testId,'is_deleted'=>1));
			$this->Session->setFlash(__('Record deleted successfully'),'default',array('class'=>'message'));
			$this->redirect($this->referer());
			//$this->redirect(array("controller" => "billings", "action" => "patient_information",$patientId,$section));
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			//$this->redirect(array("controller" => "billings", "action" => "patient_information",$patientId,$section));
		}
	}

	function printCashierTransaction(){
		$this->uses = array('VoucherPayment','ContraEntry','Account','AccountReceipt');
		$this->request->data['Voucher'] = $this->params->query;
		$this->getAllCashierTransactions();
		$this->layout=false;
	}


	public function multiplePaymentMode($id=null) {
		//debug($this->request->data);exit;
		$this->set('patientID',$id);
		$this->set('appoinmentID',$this->params->query['apptId']);
		$this->patient_info($id);
		$this->layout  = 'advance' ;
		$this->uses = array('ServiceCategory','TariffStandard','ServiceProvider','Service','Patient','EstimateConsultantBilling','Account','Person','Appointment',
				'InventorySupplier','Configuration');

		//Configuration for patient card button "ONLY FOR VADODARA INSTANCE" -- Pooja
		$configuration=$this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website'/*,'Configuration.location_id'=>$this->Session->read('locationid')*/)));
		$configInstance=unserialize($configuration['Configuration']['value']);
		$this->set('configInstance',$configInstance);
		//EOF Configuration

		$authPerson =$this->User->find('all',array('fields'=>array('id','CONCAT(first_name," ",last_name) as lookup_name'),
				'conditions'=>array('User.is_authorized_for_discount'=>'1','User.is_deleted'=>'0','User.is_active'=>'1'/*,'User.location_id'=>$this->Session->read('locationid')*/)));
			
		foreach($authPerson as $authPerson){
			$key=$authPerson["User"]["id"];
			$authPersonArr[$key]=$authPerson["0"]["lookup_name"];
		}
		//debug($authPersonArr);
		$this->set('authPerson',$authPersonArr);
			
		//tariffStandard ID
		$this->Patient->unBindModel(array('hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$tariffStdData = $this->Patient->find('first',array('fields'=>array('id','tariff_standard_id','is_discharge','admission_type','is_packaged','person_id'),
				'conditions'=>array('id'=>$id)));
		$this->set('tariffStandardID',$tariffStdData['Patient']['tariff_standard_id']);
		$this->set("isDischarge",$tariffStdData['Patient']['is_discharge']);
			
		//get person id for encounter
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Appointment'=>array('foreignKey' => false,'conditions'=>array('Patient.id=Appointment.patient_id')),
				)),false);
		$encounterId=$this->Patient->find('all',array('fields'=>array('Patient.id','Patient.form_received_on','Appointment.id'),'conditions'=>array('Patient.person_id'=>$tariffStdData['Patient']['person_id']),
				'group'=>array('Patient.id')));
		$this->set("encounterId",$encounterId);
		//


		if($tariffStdData['Patient']['is_packaged']){
			$packageInstallment = $this->EstimateConsultantBilling->find('first',array('fields'=>array('payment_instruction','patient_id'),
					'conditions'=>array('patient_id'=>$tariffStdData['Patient']['is_packaged'])));
			$this->set('packageInstallment' , unserialize($packageInstallment['EstimateConsultantBilling']['payment_instruction']));
			$this->set('packagedPatientId' , $packageInstallment['EstimateConsultantBilling']['patient_id']);
		}
		//get service dropdown
		$service_group = $this->ServiceCategory->find("all",array(
				"conditions"=>array("ServiceCategory.is_deleted"=>0,"ServiceCategory.is_view"=>1,
						"ServiceCategory.service_type"=>array($tariffStdData['Patient']['admission_type'],'Both'),
						"ServiceCategory.location_id"=>array($this->Session->read('locationid'),'0')),
				/*'order' => array('ServiceCategory.name' => 'asc')*/));
		$this->set("service_group",$service_group);
		//EOF get service dropdown
			
		$this->set('serviceProviders',$this->ServiceProvider->getServiceProvider('lab'));
		$this->set('radServiceProviders',$this->ServiceProvider->getServiceProvider('radiology'));
			
		$tariffData =$this->TariffStandard->find('list',array('fields'=>array('id','name')));
		$this->set('tariffData',$tariffData);
			
		$this->Account->bindModel(array(
				'belongsTo' => array(
						'AccountingGroup'=>array('foreignKey' => false,'conditions'=>array('AccountingGroup.id=Account.accounting_group_id')),
				)),false);
		$bankData =$this->Account->find('all',array('fields'=>array('id','name'),'conditions'=>array('Account.is_deleted'=>'0','AccountingGroup.name'=>Configure::read('bankLabel'))));
		$bankDataArray = array();
		foreach($bankData as $bank){
			$bankDataArray[$bank['Account']['id']] = $bank['Account']['name'];
		}
		$this->set('bankData',$bankDataArray);

		$this->set('bloodBanks',$this->ServiceProvider->getServiceProvider('blood'));
		$this->set('supliers',$this->InventorySupplier->getSuplier());

	}


	//function for partial payment
	public function savePaymentDetail($patientId=null) {//debug($this->request->data);exit;
		$this->autoRender = false;
		$this->uses = array('Billing','ServiceBill','Account','VoucherEntry','AccountReceipt','PatientCard',
				'Patient','ServiceCategory','LaboratoryTestOrder','RadiologyTestOrder','VoucherPayment','VoucherLog');
		
		
		if($this->request->data['Billing']['mode_of_payment']=='NEFT'){
			$this->request->data['Billing']['bank_name']=$this->request->data['Billing']['bank_name_neft'];
			$this->request->data['Billing']['account_number']=$this->request->data['Billing']['account_number_neft'];
			$this->request->data['Billing']['neft_date']=$this->DateFormat->formatDate2STD($this->request->data['Billing']['neft_date'],Configure::read('date_format'));
		}

		if($this->request->data['Billing']['mode_of_payment']=='Cheque' || $this->request->data['Billing']['mode_of_payment']=='Credit Card' || $this->request->data['Billing']['mode_of_payment']=='Debit Card'){
			$this->request->data['Billing']['cheque_date']=$this->DateFormat->formatDate2STD($this->request->data['Billing']['cheque_date'],Configure::read('date_format'));
		}
		$this->request->data['Billing']['date']=$this->DateFormat->formatDate2STD($this->request->data['Billing']['date'],Configure::read('date_format'));
		$this->request->data['Billing']['patient_id']=$patientId;
		$this->request->data['Billing']['location_id']=$this->Session->read('locationid');
		$this->request->data['Billing']['created_by']=$this->Session->read('userid');
		$this->request->data['Billing']['create_time']=date("Y-m-d H:i:s");
		$this->request->data['Billing']['discount_by']=$this->request->data['Billing']['discount_by'];
		$this->request->data['Billing']['discount_reason']=$this->request->data['Billing']['discountReason'];
			
		if($this->request->data['Billing']['discount_type'] == "Percentage"){
			$this->request->data['Billing']['discount_percentage'] = $this->request->data['Billing']['discount'];
		}elseif($this->request->data['Billing']['discount_type'] == "Amount"){
			$this->request->data['Billing']['discount_amount'] = $this->request->data['Billing']['discount'];
		}else{
			$this->request->data['Billing']['discount_type']=null;
		}
		//for updating is_refund  --yashwant
		if(!empty($this->request->data['Billing']['paid_to_patient']))
		$this->request->data['Billing']['refund']=$this->request->data['Billing']['hrefund'];
		
		//for serialising and saving tariff_list_id---yashwant
			$tariffListId = $this->request->data['Billing']['tariff_list_id'];
			$refundId = $this->request->data['Billing']['refundIds'];
			unset($this->request->data['Billing']['tariff_list_id']);
			$this->request->data['Billing']['tariff_list_id'][$this->request->data['Billing']['tariff_service_name']] = explode(',',$tariffListId);
			$this->request->data['Billing']['tariff_list_id'] = serialize($this->request->data['Billing']['tariff_list_id']);
	//debug($tariffListId);debug($this->request->data['Billing']['refundIds']);exit;
		//$this->request->data['Billing']['discount_type']=date("Y-m-d H:i:s");
		if($this->Session->read('website.instance')=='kanpur')
		{
			$admissionType=$this->Patient->find('first',array('fields'=>array('Patient.admission_type'),
							'conditions'=>array('Patient.id'=>$this->request->data['Billing']['patient_id'])));
			$receiptId=$this->Billing->autoGeneratedReceiptID($admissionType['Patient']['admission_type']);				
			//$this->Billing->updateAll(array('Billing.receiptNo'=>"'".$receiptId."'"),array('Billing.id'=>$billId));
			$this->request->data['Billing']['receiptNo']=$receiptId;
		}
		if($this->Billing->save($this->request->data['Billing'])){

			$pharmacyCategoryId=$this->ServiceCategory->getPharmacyId();//in case need of pharmacy category ID
			
			//BOF jv for accounting - amit jain
				$this->Billing->addPartialPaymentJV($this->request->data,$patientId);
			//EOF jv
			//status to closed the accepted request for discount/refund by Swapnil G.Sharma
			
			
			$this->loadModel("DiscountRequest");
			if($this->request->data['Billing']['is_refund_approved']==2){
				$this->DiscountRequest->SetClosedStatus($this->request->data['Billing']);
			}
			if($this->request->data['Billing']['is_approved']==2){
				$this->DiscountRequest->SetClosedStatusForDiscount($this->request->data['Billing']);
			}
			
			//for updating bill_no in billing table..yashwant
			$lastNotesId=$this->Billing->getLastInsertID();
			$billNo=$this->generateBillNoPerPay($patientId,$lastNotesId);
			$updateBillingArray=array('Billing.bill_number'=>"'$billNo'");
			$this->Billing->updateAll($updateBillingArray,array('Billing.patient_id'=>$patientId,'Billing.id'=>$lastNotesId));
			//EOF bill_no
			 
			/***************************************************************************/
			//Updating Service Bill amount with respective services	--Pooja
			$billId=$this->Billing->getLastInsertID();
			
			//EOF Service bill update
			//Payment category Id Of "laboratory" -- Pooja
			$this->ServiceCategory->unbindModel(array('hasMany'=>array('ServiceSubCategory')));
			$labPaymentCategoryId=$this->ServiceCategory->find('first',array('fields'=>array('id'),
					'conditions'=>array('ServiceCategory.name Like'=>Configure::read('laboratoryservices'),'ServiceCategory.location_id'=>$this->Session->read('locationid'),
							'ServiceCategory.is_deleted'=>'0','ServiceCategory.is_view'=>'1')));

			//Payment category Id Of "radiology"
			$radPaymentCategoryId=$this->ServiceCategory->find('first',array('fields'=>array('id'),
					'conditions'=>array('ServiceCategory.name Like'=>Configure::read('radiologyservices'),'ServiceCategory.location_id'=>$this->Session->read('locationid'),
							'ServiceCategory.is_deleted'=>'0','ServiceCategory.is_view'=>'1')));
			
			$radtheraphyPaymentCategoryId=$this->ServiceCategory->find('first',array('fields'=>array('id'),
					'conditions'=>array('ServiceCategory.name Like'=>Configure::read('radiotheraphyServices'),'ServiceCategory.location_id'=>$this->Session->read('locationid'),
							'ServiceCategory.is_deleted'=>'0','ServiceCategory.is_view'=>'1')));
			
			if($this->request->data['Billing']['payment_category']==$labPaymentCategoryId['ServiceCategory']['id'] && !$refundId){//condition of $refundId is for at a time only refund or discount  --yashwant 
				//percent discount shairing --yashwant
				if($this->request->data['Billing']['discount_type']=='Amount'){
					$perDisLab=($this->request->data['Billing']['discount']/$this->request->data['Billing']['amount_for_discount'])*100; //convert discounted amount in per.
				}else{
					$perDisLab=$this->request->data['Billing']['is_discount'];
				}
				//paid amount update in laboratory --
				$labTestId=explode(',',$tariffListId);
			//	$labCount=count($labTestId);
			//	$discountPerService=($this->request->data['Billing']['discount'])/$labCount;
				$labAmount=$this->LaboratoryTestOrder->find('all',array('fields'=>array('amount','id','discount'),'conditions'=>array('id'=>$labTestId)));
				foreach($labAmount as $amount){
					$paid=$amount['LaboratoryTestOrder']['amount'];
					$discountPerServiceLab=($paid*$perDisLab)/100; //update converted discount against each lab
					$modified_by=$this->Session->read('userid');
					$modify_time=date('Y-m-d H:i:s');
					if($this->Session->read('website.instance')=='vadodara'){
						$paid=$paid-$amount['LaboratoryTestOrder']['discount'];
						$updateArray=array('LaboratoryTestOrder.paid_amount'=>"'$paid'",'LaboratoryTestOrder.billing_id'=>"'$billId'"
								,'LaboratoryTestOrder.modified_by'=>"'$modified_by'",'LaboratoryTestOrder.modify_time'=>"'$modify_time'"
								,'LaboratoryTestOrder.modified_bill_date'=>"'$modify_time'");
					}else{
						$paid=$paid-$discountPerServiceLab;
						$updateArray=array('LaboratoryTestOrder.paid_amount'=>"'$paid'",'LaboratoryTestOrder.discount'=>"'$discountPerServiceLab'",
								'LaboratoryTestOrder.billing_id'=>"'$billId'",'LaboratoryTestOrder.modified_by'=>"'$modified_by'",
								'LaboratoryTestOrder.modified_bill_date'=>"'$modify_time'");
					}
					$this->LaboratoryTestOrder->updateAll($updateArray,array('LaboratoryTestOrder.id'=>$amount['LaboratoryTestOrder']['id']));
				}
			}elseif($this->request->data['Billing']['payment_category']==$radPaymentCategoryId['ServiceCategory']['id']  && !$refundId){
				//percent discount shairing --yashwant
				if($this->request->data['Billing']['discount_type']=='Amount'){
					$perDisRad=($this->request->data['Billing']['discount']/$this->request->data['Billing']['amount_for_discount'])*100; //convert discounted amount in per.
				}else{
					$perDisRad=$this->request->data['Billing']['is_discount'];
				}
				//paid amount update in radiology
				$radTestId=explode(',',$tariffListId);
				//$radCount=count($radTestId);
				//$discountPerService=($this->request->data['Billing']['discount'])/$radCount;
				$radAmount=$this->RadiologyTestOrder->find('all',array('fields'=>array('amount','id','discount'),'conditions'=>array('id'=>$radTestId)));
				foreach($radAmount as $amount){
					$paid=$amount['RadiologyTestOrder']['amount'];
					$discountPerServiceRad=($paid*$perDisRad)/100; //update converted discount against each rad
					$modified_by=$this->Session->read('userid');
					$modify_time=date('Y-m-d H:i:s');
					if($this->Session->read('website.instance')=='vadodara'){
						$paid=$paid-$amount['RadiologyTestOrder']['discount'];
						$updateArray=array('RadiologyTestOrder.paid_amount'=>"'$paid'",'RadiologyTestOrder.billing_id'=>"'$billId'"
								,'RadiologyTestOrder.modified_by'=>"'$modified_by'",'RadiologyTestOrder.modified_bill_date'=>"'$modify_time'");
					}else{
						$paid=$paid-$discountPerServiceRad;
						$updateArray=array('RadiologyTestOrder.paid_amount'=>"'$paid'",'RadiologyTestOrder.discount'=>"'$discountPerServiceRad'",
								'RadiologyTestOrder.billing_id'=>"'$billId'",'RadiologyTestOrder.modified_by'=>"'$modified_by'",'RadiologyTestOrder.modify_time'=>"'$modify_time'");
					} 
					$this->RadiologyTestOrder->updateAll($updateArray,array('RadiologyTestOrder.id'=>$amount['RadiologyTestOrder']['id']));
				}
			}elseif($this->request->data['Billing']['payment_category']==$radtheraphyPaymentCategoryId['ServiceCategory']['id']  && !$refundId){//for radiotheraphy --yashwant
				$prevPaidAmount=$this->ServiceBill->find('first',array('fields'=>array('ServiceBill.paid_amount'),'conditions'=>array('ServiceBill.id'=>$tariffListId)));
				if($prevPaidAmount['ServiceBill']['paid_amount']){
					$paid=$this->request->data[Billing][amount]+$prevPaidAmount['ServiceBill']['paid_amount'];
				}else{
					$paid=$this->request->data[Billing][amount];
				}
				$modified_by=$this->Session->read('userid');
				$modified_time=date('Y-m-d H:i:s');
				$updateArray=array('ServiceBill.paid_amount'=>"'$paid'",'ServiceBill.billing_id'=>"'$billId'",'ServiceBill.modified_by'=>"'$modified_by'",
						'ServiceBill.modified_time'=>"'$modified_time'");
				$this->ServiceBill->updateAll($updateArray,array('ServiceBill.id'=>$tariffListId));
				
			}elseif(!$refundId){//for updation of service in serviceBill --yashwant
				$mandatoryServiceId=$this->ServiceCategory->find('first',array('fields'=>array('id'),
						'conditions'=>array('ServiceCategory.name Like'=>Configure::read('mandatoryservices'),'ServiceCategory.is_deleted'=>'0','ServiceCategory.is_view'=>'1')));
				if($this->request->data['Billing']['payment_category']==$mandatoryServiceId['ServiceCategory']['id']){
					$mandAmount=$this->ServiceBill->find('all',array('fields'=>array('amount','id','discount','no_of_times'),'conditions'=>array('service_id'=>$mandatoryServiceId['ServiceCategory']['id'],
							'patient_id'=>$patientId,'paid_amount'=>'0')));//'paid_amount'=>'0' is for only upaid service to distribute discount
					if((!empty($this->request->data['Billing']['discount_type']) && $this->request->data['Billing']['discount_type']=='Amount') || (!empty($this->request->data['Billing']['disc_type']) && $this->request->data['Billing']['disc_type']=='Amount')){
						$perDisMand=($this->request->data['Billing']['discount']/$this->request->data['Billing']['amount_for_discount'])*100; //convert discounted amount in per.
					}else{
						$perDisMand=$this->request->data['Billing']['is_discount'];
					}
					foreach($mandAmount as $mandAmount){//to update paid amount for mandatory services --yashwant
						$discountPerServiceMand=($mandAmount['ServiceBill']['amount']*$perDisMand)/100; //update converted discount against each service
						if($this->Session->read('website.instance')!='vadodara'){
							$mandatoryData['discount']=$discountPerServiceMand;
							$mandatoryData['paid_amount']=($mandAmount['ServiceBill']['amount']*$mandAmount['ServiceBill']['no_of_times'])-$discountPerServiceMand;
						}else{
							$mandatoryData['paid_amount']=($mandAmount['ServiceBill']['amount']*$mandAmount['ServiceBill']['no_of_times'])-$mandAmount['ServiceBill']['discount'];//to maintain only paid amount in paid_amount field
						}
						$mandatoryData['billing_id']=$billId;
						$mandatoryData['id']=$mandAmount['ServiceBill']['id'];
						$mandatoryData['modified_time']=date('Y-m-d H:i:s') ;
						$mandatoryData['modified_by']=$this->Session->read('userid');
						$this->ServiceBill->save($mandatoryData);
					}
				}else{
					//percent discount shairing --yashwant
					
					if($this->request->data['Billing']['discount_type']=='Amount' ||$this->request->data['Billing']['disc_type']=='Amount'){
						$perDis=($this->request->data['Billing']['discount']/$this->request->data['Billing']['amount_for_discount'])*100; //convert discounted amount in per.
					}else{
						$perDis=$this->request->data['Billing']['is_discount'];
					}
					$serviceId=explode(',',$tariffListId);
					$serviceAmt=explode(',',$this->request->data['Billing']['service_amt']);
				 
					//$serviceCount=count($serviceId);
					//$discountPerService=($this->request->data['Billing']['discount'])/$serviceCount;
					foreach($serviceId as $serKey=>$serviceBillId){
						if(!empty($serviceAmt[$serKey])){
							$discountPerService=($serviceAmt[$serKey]*$perDis)/100; //update converted discount against each service
							$modified_by=$this->Session->read('userid');
							$modified_time=date('Y-m-d H:i:s');
							if($this->Session->read('website.instance')=='vadodara'){
								$saleBillServiceDiscount=$this->ServiceBill->find('first',array('fields'=>array('discount'),'conditions'=>array('id'=>$serviceBillId)));
								$serviceAmt[$serKey]=$serviceAmt[$serKey]-$saleBillServiceDiscount['ServiceBill']['discount'];
								$this->ServiceBill->updateAll(array('ServiceBill.paid_amount'=>$serviceAmt[$serKey],'ServiceBill.billing_id'=>$billId
										,'ServiceBill.modified_by'=>"'$modified_by'",'ServiceBill.modified_time'=>"'$modified_time'"),
										array('ServiceBill.id'=>$serviceBillId,'ServiceBill.service_id'=>$this->request->data['Billing']['payment_category']));
							}else{
								$serviceAmt[$serKey]=$serviceAmt[$serKey]-$discountPerService;
								$this->ServiceBill->updateAll(array('ServiceBill.paid_amount'=>$serviceAmt[$serKey],'ServiceBill.discount'=>$discountPerService,
										'ServiceBill.billing_id'=>$billId,'ServiceBill.modified_by'=>"'$modified_by'",'ServiceBill.modified_time'=>"'$modified_time'"),
										array('ServiceBill.id'=>$serviceBillId,'ServiceBill.service_id'=>$this->request->data['Billing']['payment_category']));
							}
						}
					}
				}
			}		
			/***************************************************************************/
			 
			/*************BOF YASHWANT for Refund****************/
			//update refunded amount with respect to service
			if($refundId){
				$refundId=explode(',',$refundId);
				if($this->request->data['Billing']['payment_category']==$labPaymentCategoryId['ServiceCategory']['id']){
					 $this->LaboratoryTestOrder->updateAll(array('LaboratoryTestOrder.paid_amount'=>'0','LaboratoryTestOrder.discount'=>'0'),array('LaboratoryTestOrder.id'=>$refundId));
					/*//for updating discount after refund
					$serviceBillingId=$this->LaboratoryTestOrder->find('first',array('fields'=>array('billing_id'),'conditions'=>array('LaboratoryTestOrder.id'=>$refundId)));
					$totalServiceDiscount=$this->LaboratoryTestOrder->find('all',array('fields'=>array('billing_id','sum(LaboratoryTestOrder.discount) AS totalServiceDiscount'),
							'conditions'=>array('LaboratoryTestOrder.billing_id'=>$serviceBillingId['LaboratoryTestOrder']['billing_id'])));
					
					foreach($totalServiceDiscount as $totalServiceDiscount){//update discount entry in billing
						$this->Billing->updateAll(array('Billing.discount'=>$totalServiceDiscount[0]['totalServiceDiscount']),array('Billing.id'=>$totalServiceDiscount['LaboratoryTestOrder']['billing_id']));
					}
					//EOF updating discount after refund */
					$manageRefDiscount=$this->request->data['Billing']['paid_to_patient']-$this->request->data['Billing']['amount_pending'];//$billId
					$this->Billing->updateAll(array('Billing.discount'=>$manageRefDiscount),array('Billing.id'=>$billId));
				}elseif($this->request->data['Billing']['payment_category']==$radPaymentCategoryId['ServiceCategory']['id']){
					$this->RadiologyTestOrder->updateAll(array('RadiologyTestOrder.paid_amount'=>'0','RadiologyTestOrder.discount'=>'0'),array('RadiologyTestOrder.id'=>$refundId));
					/* //for updating discount after refund
					$serviceBillingId=$this->RadiologyTestOrder->find('first',array('fields'=>array('billing_id'),'conditions'=>array('RadiologyTestOrder.id'=>$refundId)));
					$totalServiceDiscount=$this->RadiologyTestOrder->find('all',array('fields'=>array('billing_id','sum(RadiologyTestOrder.discount) AS totalServiceDiscount'),
							'conditions'=>array('RadiologyTestOrder.billing_id'=>$serviceBillingId['RadiologyTestOrder']['billing_id'])));
					foreach($totalServiceDiscount as $totalServiceDiscount){//update discount entry in billing
						$this->Billing->updateAll(array('Billing.discount'=>$totalServiceDiscount[0]['totalServiceDiscount']),array('Billing.id'=>$totalServiceDiscount['RadiologyTestOrder']['billing_id']));
					}
					//EOF updating discount after refund */
					
					$manageRefDiscount=$this->request->data['Billing']['paid_to_patient']-$this->request->data['Billing']['amount_pending'];//for managing refunded discount in heads
					$this->Billing->updateAll(array('Billing.discount'=>$manageRefDiscount),array('Billing.id'=>$billId));
					
				}else{
					$this->ServiceBill->updateAll(array('ServiceBill.paid_amount'=>'0','ServiceBill.discount'=>'0'),array('ServiceBill.id'=>$refundId,'ServiceBill.service_id'=>$this->request->data['Billing']['payment_category']));
					/* //for updating discount after refund
					$serviceBillingId=$this->ServiceBill->find('first',array('fields'=>array('billing_id'),'conditions'=>array('ServiceBill.id'=>$refundId)));
					$totalServiceDiscount=$this->ServiceBill->find('all',array('fields'=>array('billing_id','sum(ServiceBill.discount) AS totalServiceDiscount'),
							'conditions'=>array('ServiceBill.billing_id'=>$serviceBillingId['ServiceBill']['billing_id'])));
					foreach($totalServiceDiscount as $totalServiceDiscount){//update discount entry in billing
						$this->Billing->updateAll(array('Billing.discount'=>$totalServiceDiscount[0]['totalServiceDiscount']),array('Billing.id'=>$totalServiceDiscount['ServiceBill']['billing_id']));
					}
					//EOF updating discount after refund */
					
					$manageRefDiscount=$this->request->data['Billing']['paid_to_patient']-$this->request->data['Billing']['amount_pending'];//$billId
					$this->Billing->updateAll(array('Billing.discount'=>$manageRefDiscount),array('Billing.id'=>$billId));
				}
			} 
			/*************EOF YASHWANT****************/
			
			//if  "patient card" update account->card balance, and entry in patient card-- For vadodara instance -- Pooja
			if($this->Session->read('website.instance')!='kanpur'){
				if($this->request->data['Billing']['is_card']=='1' && !empty($this->request->data['Billing']['patient_card'])){
					$personId=$this->Patient->find('first',array('fields'=>array('Patient.person_id'),
							'conditions'=>array('Patient.id'=>$this->request->data['Billing']['patient_id'])));
					$accId=$this->Account->find('first',array('fields'=>array('Account.id','Account.card_balance'),
							'conditions'=>array('Account.system_user_id'=>$personId['Patient']['person_id'],'user_type'=>'Patient')));
					$cardBalance=$accId['Account']['card_balance']-$this->request->data['Billing']['patient_card'];
					$this->Account->updateAll(array('Account.card_balance'=>$cardBalance),array('Account.id'=>$accId['Account']['id']));
					$patientCard['person_id']=$personId['Patient']['person_id'];
					$patientCard['account_id']=$accId['Account']['id'];
					$patientCard['amount']=$this->request->data['Billing']['patient_card'];
					$patientCard['type']='Payment';
					$patientCard['billing_id']=$billId;
					$patientCard['bank_id']=$this->Account->getAccountIdOnly(Configure::read('PatientCardLabel'));
					$patientCard['mode_type']='Patient Card';
					$patientCard['created_by']=$this->Session->read('userid');
					$patientCard['create_time']=date('Y-m-d H:i:s');
					$this->PatientCard->save($patientCard);
						
				}
		}
			//EOF patient card update --Pooja
			
			
		} 
		exit;
	}


	public function ajaxServiceData($patientId=null) {
		$this->layout='ajax';
		$this->set('patientID',$patientId);
		$this->set('isNursing',($this->params->query['isNursing'])?$this->params->query['isNursing']:'');
		$this->uses = array('Patient','TariffStandard');
		//BOF-Mahalaxmi for Fetching RGJAY Tariff ID
		$this->set('getTariffRgjayId',$this->TariffStandard->getTariffStandardID('RGJAY'));
		//EOF-Mahalaxmi for Fetching RGJAY Tariff ID
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Room' =>array('foreignKey'=>false,
								'conditions'=>array('Room.id = Patient.room_id')),
				)));
		$addmissionType =$this->Patient->find('first',array('fields'=>array('Patient.admission_type','Patient.tariff_standard_id',
				'Patient.treatment_type','Patient.form_received_on','Patient.is_packaged','Room.room_type'),
				'conditions'=>array('Patient.id'=>$patientId)));
		$tariffStandardId=$addmissionType['Patient']['tariff_standard_id'];
		$this->set('addmissionType',$addmissionType);

		$tariffStanderdName=$this->TariffStandard->getTariffStandardName($tariffStandardId);
		$this->set('tariffStanderdName',$tariffStanderdName);
		
		$pvtTariffStandard = $this->TariffStandard->getPrivateTariffID() ;
		
		if(!empty($this->params->query['isMandatory']))$this->set('isMandatory',$this->params->query['isMandatory']);//check isMandatory...
			
		//Fetch service data
		$this->uses = array('ServiceBill');
		$this->ServiceBill->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>'patient_id'),
						"ServiceCategory"=>array('foreignKey'=>'service_id','type'=>'RIGHT'),
						"ServiceSubCategory"=>array('foreignKey'=>'sub_service_id'),
						'TariffList'=>array('foreignKey'=>'tariff_list_id'),
						/*'Billing'=>array('foreignKey'=>false,'conditions'=>array('TariffList.id=Billing.tariff_list_id','Patient.id=Billing.patient_id')),*/
						'TariffAmount'=>array('foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=ServiceBill.tariff_list_id','TariffAmount.tariff_standard_id'))
				)));
			
		$servicesData =$this->ServiceBill->find('all',array('group'=>array('ServiceBill.id'),'fields'=>array(/*'Billing.*',*/'TariffAmount.*,ServiceCategory.*,ServiceSubCategory.*,
				TariffList.*,ServiceBill.*,Patient.lookup_name,Patient.is_discharge,Patient.tariff_standard_id,Patient.form_received_on'),'conditions'=>array('ServiceBill.patient_id'=>$patientId,
						'ServiceBill.service_id'=>$this->params->query['groupID'])));
		$this->set('servicesData',$servicesData);
		//EOF Fetch service data
		
		$serviceCharge =$this->Billing->find('all',array('conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0',
				'Billing.payment_category'=>$this->params->query['groupID'])));
			
		$groupName=str_replace(" ", '',strtolower($servicesData['0']['ServiceCategory']['name'])) ;
		foreach($serviceCharge as $serviceIdPaid){
			$serviceTarrifId=unserialize($serviceIdPaid['Billing']['tariff_list_id']);
			/*$splitServiceTariffId=explode(',',$serviceTarrifId[$groupName]);*/
			foreach($serviceTarrifId[$groupName] as $serviceId){
				$paidService[$serviceId]=$serviceId;
				$billedServiceId[$serviceId]=$serviceIdPaid['Billing']['id'];//billing id=>tariff_list_id
			} 
		}  //debug($serviceTarrifId);debug($paidService);debug($billedServiceId);
		$this->set('paidService',$paidService);
		$this->set('billedServiceId',$billedServiceId);
		$this->set('serviceCharge',$serviceCharge);
		$this->set('groupID',$this->params->query['groupID']);
			
		 
		/*
		 * doctor and nursing charges for mandatory servises  --yashwant (shifted function fron ajaxServiceData)
		*/
		if($addmissionType['Patient']['admission_type']=='IPD'){
			$hospitalType = $this->Session->read('hospitaltype');
			//$roomTariff = $this->getDay2DayCharges($patientId,$tariffStandardId);
			$roomTariff = $this->wardCharges($patientId);
			$totalWardDays=count($roomTariff['day']); //total no of days
			$this->set('totalWardDays',$totalWardDays);
			//if($addmissionType['Patient']['tariff_standard_id']==$pvtTariffStandard){//pooja
				$doctorCharges = $this->Billing->getDoctorCharges($totalWardDays,$hospitalType,$tariffStandardId,$addmissionType['Patient']['admission_type'],
						$addmissionType['Patient']['treatment_type']);
				$nursingCharges = $this->Billing->getNursingCharges($totalWardDays,$hospitalType,$tariffStandardId);
				$this->set(array('doctorCharges'=>$doctorCharges,'nursingCharges'=>$nursingCharges));
			//}
			
		}
	}

	public function ajaxConsultationData($patientId=null) {//debug($patientId);
		$this->layout='ajax';
		$this->set('patientID',$patientId);
		$this->set('isNursing',($this->params->query['isNursing'])?$this->params->query['isNursing']:'');
		//Fetch consultaion data
		$this->uses = array('ConsultantBilling','DoctorProfile','Consultant','Patient','ServiceCategory');
		$this->ConsultantBilling->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array('foreignKey'=>'consultant_service_id'),
						"ServiceCategory"=>array('foreignKey'=>'service_category_id'),
						"ServiceSubCategory"=>array('foreignKey'=>'service_sub_category_id')
				)));
		$consultantBillingData = $this->ConsultantBilling->find('all',array('conditions' =>array('ConsultantBilling.patient_id'=>$patientId,'ConsultantBilling.is_deleted'=>'0')));//,'date'=>date('Y-m-d')
		$this->set('consultantBillingData',$consultantBillingData);
			
		$allConsultantsList = $this->Consultant->getConsultantWithDeleted();
			
		$this->DoctorProfile->virtualFields = array(
				//'doctor_name' => 'CONCAT(Initial.name, " ", DoctorProfile.doctor_name)'
				'doctor_name' => 'DoctorProfile.doctor_name'
		);
		$allDoctorsList = $this->DoctorProfile->find('list', array('conditions' => array('DoctorProfile.location_id' => $this->Session->read('locationid')),
				'fields' => array('DoctorProfile.id', 'DoctorProfile.doctor_name'), 'recursive' => 1));
		$this->set(array('allDoctorsList'=>$allDoctorsList,'allConsultantsList'=>$allConsultantsList));
		//EOF Fetch consultaion data
			
		//$consultationCharge =$this->Billing->find('all',array('conditions'=>array('Billing.patient_id'=>$patientId,'Billing.payment_category'=>'Consultant')));
		//$this->set('consultationCharge',$consultationCharge);
			
		$isDischarge=$this->Patient->find('first',array('fields'=>array('is_discharge','tariff_standard_id'),'conditions'=>array('id'=>$patientId)));
		$this->set('isDischarge',$isDischarge['Patient']);
			
		$this->ServiceCategory->bindModel(array(
				'belongsTo' => array(
						'Billing'=>array('foreignKey' => false,'conditions'=>array('ServiceCategory.id=Billing.payment_category')),
				)),false);

		$consultationCharge =$this->ServiceCategory->find('all',array('fields'=>array('Billing.*','ServiceCategory.name'),
				'conditions'=>array('Billing.patient_id'=>$patientId,'ServiceCategory.alias'=>Configure::read('Consultant'),
						'Billing.is_deleted'=>'0')));
		$this->set('consultationCharge',$consultationCharge);
		echo $this->render('ajaxConsultationData');
		exit;
	}


	public function addLab($patientId=null) {
		$this->uses = array('Patient','User','Note','Role','Billing');
		$this->layout='ajax';
		$this->set('patientID',$patientId);
		// debug($patientId);exit;
		if($this->request->data['LaboratoryTestOrder']){
			
			// debug($this->request->data['LaboratoryTestOrder']);exit;
			$this->Billing->insertLabData($this->request->data['LaboratoryTestOrder'],$patientId,$this->params->query['doctor_id']);
			if($this->Session->read('website.instance')=='kanpur'){
				$this->Role->unBindModel(array('hasMany' => array('User')));
				$roleId=$this->Role->getRoleIdByName(Configure::read('labManager'));
				$staff = $this->User->find('all', array('fields'=> array('User.id','User.first_name','User.last_name','User.username'),
						'conditions'=>array('User.role_id' =>$roleId['Role']['id'])));
				
				foreach ($staff as $key=>$staffData)
				{ 
					$userfullnameVal=$staffData["User"]["first_name"]." ".$staffData["User"]["last_name"];
					$mailData['Patient']=array("patient_id"=>$staffData["User"]["username"],"lookup_name"=>$userfullnameVal);
					$labName = $this->request->data['LaboratoryTestOrder']['lab_name'];
					$msgs.="<a href=".Router::url('/')."NewLaboratories/index/".$patientId.">Click here to view Lab</a><br/><br/>";
					$subject="Request for lab $labName[0]";
					$this->Note->sendMail($mailData,$msgs,$subject);
					$msgs = '';
				}
			}
			exit;
		}
			
	}

	public function ajaxLabData($patientId=null,$tariffStandardId=null) {
		 $this->layout='ajax';
		$this->set('patientID',$patientId);
		$this->set('isNursing',($this->params->query['isNursing'])?$this->params->query['isNursing']:'');
		$this->set('tariffStandardId',$tariffStandardId);
		$this->uses = array('LaboratoryTestOrder','Patient','ServiceCategory','ServiceProvider','Note','TariffStandard');
		//BOF-Mahalaxmi for Fetching RGJAY Tariff ID
		$this->set('getTariffRgjayId',$this->TariffStandard->getTariffStandardID('RGJAY'));
		//EOF-Mahalaxmi for Fetching RGJAY Tariff ID
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));

		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Room' =>array('foreignKey'=>false,
								'conditions'=>array('Room.id = Patient.room_id')),
				)));
		if(!$tariffStandardId){
			$patient_details  = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$patientId),'fields'=>array('Patient.id','Patient.tariff_standard_id',
					'Patient.is_discharge','Patient.is_packaged','Patient.form_received_on','Patient.admission_type','Room.room_type')));
			$tariffStandardId	=	$patient_details['Patient']['tariff_standard_id'];
			$this->set('tariffStandardId',$tariffStandardId);
		}else{
			$patient_details  = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$patientId),'fields'=>array('Patient.id','Patient.tariff_standard_id',
					'Patient.is_discharge','Patient.is_packaged','Patient.form_received_on','Patient.admission_type','Room.room_type')));
		}
		
		$tariffStanderdName=$this->TariffStandard->getTariffStandardName($tariffStandardId);
		$this->set('tariffStanderdName',$tariffStanderdName);
			
		//Payment category Id Of "laboratory" -- Pooja
		$this->ServiceCategory->unbindModel(array('hasMany'=>array('ServiceSubCategory')));
		$paymentCategoryId=$this->ServiceCategory->find('first',array('fields'=>array('id'),
				'conditions'=>array('ServiceCategory.name Like'=>Configure::read('laboratoryservices'))));

		$this->LaboratoryTestOrder->bindModel(array(
				'belongsTo' => array(
						'Laboratory'=>array('foreignKey' => false,'conditions'=>array('Laboratory.id=LaboratoryTestOrder.laboratory_id')),
						
						'ServiceProvider'=>array('foreignKey' => false,'conditions'=>array('ServiceProvider.id=LaboratoryTestOrder.service_provider_id')),
						'TariffAmount'=>array('foreignKey' => false,'conditions'=>
								array('TariffAmount.tariff_list_id=Laboratory.tariff_list_id' ,'TariffAmount.tariff_standard_id'=>$tariffStandardId)),
								/*'TariffAmountAlias'=>array('className'=>'TariffAmount','foreignKey' => false,'conditions'=>
								array('TariffAmountAlias.nabh_charges=LaboratoryTestOrder.amount' ,'TariffAmount.tariff_standard_id'=>$tariffStandardId)),
								'TariffList'=>array('foreignKey' => false,'conditions'=>array('TariffAmountAlias.tariff_list_id=TariffList.id')),*/
				)),false);
			
		$labData = $this->LaboratoryTestOrder->find('all',array('fields'=>array('LaboratoryTestOrder.*','ServiceProvider.name',
				'ServiceProvider.id','Laboratory.name',/*'TariffList.name',*/'TariffAmount.id,TariffAmount.nabh_charges,TariffAmount.non_nabh_charges' ),
				'conditions' =>array('LaboratoryTestOrder.patient_id'=>$patientId,'LaboratoryTestOrder.is_deleted'=>'0'),
				'group'=>array('LaboratoryTestOrder.id')));
		$this->set('labData',$labData);
//dpr($labData);
		/*$testRates = $this->labRadRates($tariffStandardId,$patientId);// for lab sevices
		 $this->set('labData',$testRates['labRate']);*/

		$this->ServiceCategory->bindModel(array(
				'belongsTo' => array(
						'Billing'=>array('foreignKey' => false,'conditions'=>array('ServiceCategory.id=Billing.payment_category')),
				)),false);
			
		$labCharge =$this->ServiceCategory->find('all',array('fields'=>array('Billing.*','ServiceCategory.id','ServiceCategory.name'),
				'conditions'=>array('Billing.patient_id'=>$patientId,'ServiceCategory.name'=>'laboratory','ServiceCategory.is_view'=>'1','Billing.is_deleted'=>'0')));
		 
		$groupName=str_replace(" ", '',strtolower($labCharge['0']['ServiceCategory']['name'])) ;
		foreach($labCharge as $labIdPaid){
			$splitLabTariffId=unserialize($labIdPaid['Billing']['tariff_list_id']);
			//$splitLabTariffId=explode(',',$labIdPaid['Billing']['tariff_list_id']);
			foreach($splitLabTariffId[$groupName] as $labId){
				$paidLab[$labId]=$labId;
				$billedLabId[$labId]=$labIdPaid['Billing']['id'];//billing id=>tariff_list_id
			}
		}
		//debug($paidLab);debug($billedLabId);
		$this->set('billedLabId',$billedLabId);
		$this->set('paidLab',$paidLab);
		$this->set('labCharge',$labCharge);
		$this->set('patient_details',$patient_details);
			
		$this->set('serviceProviders',$this->ServiceProvider->getServiceProvider('lab'));
		
		//$getLabData=$this->getSmartLab($patientId);
		//$this->set('getLabData',$getLabData);
			
		//echo $this->render('ajaxLabData');
		//exit;
	}

	public function deleteLabCharges($billingId,$patientId){//debug($this->params->query['isNursing']);exit;
		
		$this->loadModel('LaboratoryTestOrder');
		//$this->loadModel('VoucherEntry');
		/* if(!empty($billingId)){
			$this->VoucherEntry->updateAll(array('VoucherEntry.is_deleted'=>1),array('VoucherEntry.billing_id'=>$billingId));
		} */
		$this->loadModel('ServiceCategory');
		$this->loadModel('Billing');
		$LabGroupID = $this->ServiceCategory->getServiceGroupId('laboratoryservices');
		$discount=$this->LaboratoryTestOrder->find('first',array('fields'=>array('discount'),'conditions'=>array('id'=>$billingId)));
		$this->LaboratoryTestOrder->updateAll(array('is_deleted'=>'1'),array('id'=>$billingId));
		$this->Billing->discountDeleteEntry($patientId,$LabGroupID,$discount['LaboratoryTestOrder']['discount']);
		
		$this->Session->setFlash(__('Record deleted successfully', true));
		if($this->params->query['isNursing']=='yes'){
			$this->redirect(array("controller" => "Billings", "action" => "addNurseServices",$patientId));
		}else{
			exit;
		}
		//$this->redirect(array("controller" => "Billings", "action" => "addNurseServices",$patientId));
		
	}


	/**
	 *
	 * @param int $patient_id
	 * return json_enode array with lab amount
	 */

	public function labChargesAutocomplete($patient_id=null){
        $this->layout = 'ajax';
        $this->uses = array('Patient','LaboratoryTestOrder','Laboratory','TariffStandard');
        $this->Patient->unBindModel(array(
                'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
        $this->Patient->bindModel(array(
                'belongsTo' => array(
                        'TariffStandard'=>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
                )));
        $patient_details  = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$patient_id),'fields'=>array('id','coupon_name','tariff_standard_id','TariffStandard.name')));
        $tariffStandardId    =    $patient_details['Patient']['tariff_standard_id'];
        $tariffStandardData = $this->TariffStandard->find('list',array('fields'=>array('id','id'),'conditions'=>array('TariffStandard.name'=>$patient_details['TariffStandard']['name'])));
        //laboratory only
        
        //BOF vadodara condition for tariff charges
        //cond added by w for Senior RGJAY
       /* $skipCharge =false  ;
        if(strtolower($this->Session->read('role'))==strtolower(Configure::read('Senior_RGJAY')) ||
        	strtolower($this->Session->read('role'))==strtolower('admin')
        ){
        			$this->Laboratory->bindModel(array(
        					'belongsTo' => array('TariffAmount'=>array('foreignKey' => false,'type'=>'left',
        							'conditions'=>array('TariffAmount.tariff_list_id=Laboratory.tariff_list_id' ,'TariffAmount.tariff_standard_id'=>$tariffStandardId))
        					)),false);
        			$skipCharge =true ;
        }else{//EOF condition added by w*/
        	$this->Laboratory->bindModel(array(
        			'belongsTo' => array('TariffAmount'=>array('foreignKey' => false,'type'=>'left',
        					'conditions'=>array('TariffAmount.tariff_list_id=Laboratory.tariff_list_id' ,'TariffAmount.tariff_standard_id'=>$tariffStandardId))
        			)),false);
        //}
        
        

        $laboratoryTestData= $this->Laboratory->find('all',array(
                'fields'=> array('Laboratory.name','Laboratory.id','TariffAmount.nabh_charges,TariffAmount.non_nabh_charges',
                		'TariffAmount.standard_tariff'),
                'conditions'=>array('Laboratory.is_deleted'=>0,
                        'Laboratory.is_active'=>1,'Laboratory.name like'=>'%'.$this->params->query['term'].'%'),
                'group'=>array('Laboratory.id'),
        		'limit'=>'20'));
        //debug($laboratoryTestData);
        //EOF laboratory
        $hospitalType = $this->Session->read('hospitaltype');
        if($hospitalType == 'NABH'){
            $nursingServiceCostType = 'nabh_charges';
        }else{
            $nursingServiceCostType = 'non_nabh_charges';
        }
          
        foreach ($laboratoryTestData as $key=>$value) {
        	/****************Default discount percentage************/
        	if(Configure::read('apply_discount')=='1' && empty($patient_details['Patient']['coupon_name'])){
        		if(!empty($value['TariffAmount']['standard_tariff'])){
        			$discount=$value['TariffAmount']['standard_tariff'];
        		}else $discount=0;
        	}else{
        		$discount=0;
        	}
        	/*******************************************************/
            $returnArray[] = array( 'id'=>$value['Laboratory']['id'],
            		'value'=>ucwords($value['Laboratory']['name']),
            		'charges'=>$value['TariffAmount'][$nursingServiceCostType],
            		'fix_discount'=>$discount, 
            ) ;
        } 
        
        //debug($returnArray);exit;
        echo json_encode($returnArray);

       exit;
    }


	public function radChargesAutocomplete($patient_id=null){
		$this->layout = 'ajax';
		$this->autoRender =false;
		$this->uses = array('Patient','Radiology','ServiceSubCategory');
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patient_details  = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$patient_id),'fields'=>array('id','tariff_standard_id','coupon_name')));
		$tariffStandardId	=	$patient_details['Patient']['tariff_standard_id'];

		//BOF vadodara condition for tariff charges
		if($this->Session->read('website.instance')=='vadodara'){
			   
			//radiology only
			$this->Radiology->bindModel(array(
					'belongsTo' => array(
							'TariffAmount'=>array(/* 'type'=>'INNER', */'foreignKey' => false,'conditions'=>
									array('TariffAmount.tariff_list_id=Radiology.tariff_list_id' ,'TariffAmount.tariff_standard_id'=>$tariffStandardId)),
							'TariffList'=>array('type'=>'INNER','foreignKey' => false,'conditions'=>array('TariffAmount.tariff_list_id=TariffList.id')),
							'TariffAmountType'=>array('type'=>'INNER','foreignKey' => false,'conditions'=>array('TariffAmount.tariff_list_id=TariffAmountType.tariff_list_id',
									'TariffAmountType.tariff_standard_id='.$tariffStandardId))
					)),false);
			$this->Radiology->query("SET CHARACTER SET utf8");
			$radiologyTestOrderData= $this->Radiology->find('all',array(
					'fields'=> array('Radiology.name,Radiology.id,TariffAmount.nabh_charges,TariffAmount.non_nabh_charges','TariffAmountType.*','TariffList.service_sub_category_id'),
					'conditions'=>array('Radiology.location_id'=>$this->Session->read('locationid'),'Radiology.is_deleted'=>0,'Radiology.is_active'=>1,
							'Radiology.name like'=>$this->params->query['term'].'%'),'limit'=>'20'));
			//EOF radiology 
			$admissionType = $this->params->query['admission_type'] ;
			$patientId = $this->params->query['patient_id'] ;
			$hospitalType = $this->Session->read('hospitaltype');
			if($hospitalType == 'NABH'){
				$nursingServiceCostType = 'nabh_charges';
			}else{
				$nursingServiceCostType = 'non_nabh_charges';
			}
			
			$subGroupList=$this->ServiceSubCategory->getAllSubCategories();//list of sub groups  --yashwant
			if($admissionType=='IPD'){
				$patientRoomType  = $this->params->query['room_type']."_ward_charge" ; //for database field name
				//array('general'=>'General','special'=>'Special','semi_special'=>'Semi Special','Delux'=>'Delux') ; //sample
				#debug($laboratoryTestData);
				foreach ($radiologyTestOrderData as $key=>$value) {
					if($value['TariffList']['service_sub_category_id']){
						$subGroupName=' - ('.$subGroupList[$value['TariffList']['service_sub_category_id']].')';
					}else{
						$subGroupName=null;
					}
					/****************Default discount percentage-pooja************/
					if(Configure::read('apply_discount')=='1' && empty($patient_details['Patient']['coupon_name'])){
						if(!empty($value['TariffAmount']['standard_tariff'])){
							$discount=$value['TariffAmount']['standard_tariff'];
						}else $discount=0;
					}else{
						$discount=0;
					}
					/*******************************************************/
					if($value['TariffAmountType'][$patientRoomType] != ''){
						$returnArray[] = array( 'id'=>$value['Radiology']['id'],'value'=>ucwords($value['Radiology']['name']).' '.ucwords($subGroupName),'charges'=>$value['TariffAmountType'][$patientRoomType],'fix_discount'=>$discount) ;
					}else{
						$returnArray[] = array( 'id'=>$value['Radiology']['id'],'value'=>ucwords($value['Radiology']['name']).' '.ucwords($subGroupName),'charges'=>$value['TariffAmount'][$nursingServiceCostType],'fix_discount'=>$discount) ;
					}
				}
			}else{
				$patientRoomType  = "opd_charge" ; //for database field name
				 
				foreach ($radiologyTestOrderData as $key=>$value) {
					if($value['TariffList']['service_sub_category_id']){
						$subGroupName=' - ('.$subGroupList[$value['TariffList']['service_sub_category_id']].')';
					}else{
						$subGroupName=null;
					}
					/****************Default discount percentage-pooja************/
					if(Configure::read('apply_discount')=='1' && empty($patient_details['Patient']['coupon_name'])){
						if(!empty($value['TariffAmount']['standard_tariff'])){
							$discount=$value['TariffAmount']['standard_tariff'];
						}else $discount=0;
					} /*else{
						$discount=0;
					}*/
					/*******************************************************/
					if($value['TariffAmountType'][$patientRoomType] != ''){
						$returnArray[] = array( 'id'=>$value['Radiology']['id'],'value'=>ucwords($value['Radiology']['name']).' '.ucwords($subGroupName),'charges'=>$value['TariffAmountType'][$patientRoomType],'fix_discount'=>$discount) ;
					}else{
						$returnArray[] = array( 'id'=>$value['Radiology']['id'],'value'=>ucwords($value['Radiology']['name']).' '.ucwords($subGroupName),'charges'=>$value['TariffAmount'][$nursingServiceCostType],'fix_discount'=>$discount) ;
					}
				}
			}
		
		}else{//EOF vadodara cond added by pankaj w
			//radiology only
			$this->Radiology->bindModel(array(
					'belongsTo' => array(
							'TariffAmount'=>array('foreignKey' => false/* ,'type'=>'inner' */,'conditions'=>
									array('TariffAmount.tariff_list_id=Radiology.tariff_list_id' ,'TariffAmount.tariff_standard_id'=>$tariffStandardId))
					)),false);
			$this->Radiology->query("SET CHARACTER SET utf8");	
			$radiologyTestOrderData= $this->Radiology->find('all',array(
					'fields'=> array('Radiology.name,Radiology.id,TariffAmount.nabh_charges,TariffAmount.non_nabh_charges','TariffAmount.standard_tariff'),
					'conditions'=>array('Radiology.location_id'=>$this->Session->read('locationid'),'Radiology.is_deleted'=>0,'Radiology.is_active'=>1,'Radiology.name like'=>'%'.$this->params->query['term'].'%'),'limit'=>'20'));
			//EOF radiology
	
			$hospitalType = $this->Session->read('hospitaltype');
			if($hospitalType == 'NABH'){
				$nursingServiceCostType = 'nabh_charges';
			}else{
				$nursingServiceCostType = 'non_nabh_charges';
			}
	
			foreach ($radiologyTestOrderData as $key=>$value) {
				/****************Default discount percentage-pooja************/
				if(Configure::read('apply_discount')=='1' && empty($patient_details['Patient']['coupon_name'])){
					if(!empty($value['TariffAmount']['standard_tariff'])){
						$discount=$value['TariffAmount']['standard_tariff'];
					}else $discount=0;
				}else{
					$discount=0;
				}
				/*******************************************************/
				$returnArray[] = array( 'id'=>$value['Radiology']['id'],'value'=>ucwords($value['Radiology']['name']),'charges'=>$value['TariffAmount'][$nursingServiceCostType],'fix_discount'=>$discount) ;
			}
		}
		echo json_encode($returnArray);
		 
	}


	public function addRad($patientId=null) {
		$this->uses = array('Patient','User','Note','Role','Configuration','ServiceProvider','Message');
		//$this->layout='ajax';
		$this->set('patientID',$patientId);
		if($this->request->data['RadiologyTestOrder']){		
			$this->Billing->insertRadData($this->request->data['RadiologyTestOrder'],$patientId,$this->params->query['doctor_id']);
			
			/*if($this->Session->read('website.instance')=='kanpur'){				
				$this->Role->unBindModel(array('hasMany' => array('User')));
				$roleId=$this->Role->getRoleIdByName(Configure::read('labManager'));
				$staff = $this->User->find('all', array('fields'=> array('User.id','User.first_name','User.last_name','User.username'),
						'conditions'=>array('User.role_id' =>$roleId['Role']['id'])));
			
				foreach ($staff as $key=>$staffData)
				{
					$userfullnameVal=$staffData["User"]["first_name"]." ".$staffData["User"]["last_name"];
					$mailData['Patient']=array("patient_id"=>$staffData["User"]["username"],"lookup_name"=>$userfullnameVal);
					$radName = $this->request->data['RadiologyTestOrder']['rad_name'];
					$msgs.="<a href=".Router::url('/')."Radiologies/radiology_test_list/".$patientId.">Click here to view Radiology</a><br/><br/>";
					$subject="Request for Radiology $radName[0]";
					$this->Note->sendMail($mailData,$msgs,$subject);
					$msgs = '';
				}
			}*/			
			exit;
		}

	}

	public function ajaxRadData($patientId=null,$tariffStandardId=null) {
		//$this->layout='ajax';
		$this->set('patientID',$patientId);
		$this->set('tariffStandardId',$tariffStandardId);
		$this->set('isNursing',($this->params->query['isNursing'])?$this->params->query['isNursing']:'');
		$this->uses = array('RadiologyTestOrder','Patient','ServiceCategory','ServiceProvider','TariffStandard');
		//BOF-Mahalaxmi for Fetching RGJAY Tariff ID
		$this->set('getTariffRgjayId',$this->TariffStandard->getTariffStandardID('RGJAY'));
		//EOF-Mahalaxmi for Fetching RGJAY Tariff ID
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Room' =>array('foreignKey'=>false,
								'conditions'=>array('Room.id = Patient.room_id')),
				)));
		if(!$tariffStandardId){
			$patient_details  = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$patientId),'fields'=>array('Patient.id','Patient.tariff_standard_id',
					'Patient.is_discharge','Patient.is_packaged','Patient.form_received_on','Patient.admission_type','Room.room_type')));
			$tariffStandardId	=	$patient_details['Patient']['tariff_standard_id'];
			$this->set('tariffStandardId',$tariffStandardId);
		}else{
			$patient_details  = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$patientId),'fields'=>array('Patient.id','Patient.tariff_standard_id',
					'Patient.is_discharge','Patient.is_packaged','Patient.form_received_on','Patient.admission_type','Room.room_type')));
		}

		$tariffStanderdName=$this->TariffStandard->getTariffStandardName($tariffStandardId);
		$this->set('tariffStanderdName',$tariffStanderdName);
		
		//Payment category Id Of "radiology" -- Pooja
		$this->ServiceCategory->unbindModel(array('hasMany'=>array('ServiceSubCategory')));
		$paymentCategoryId=$this->ServiceCategory->find('first',array('fields'=>array('id'),
				'conditions'=>array('ServiceCategory.name Like'=>Configure::read('radiologyservices'))));
			
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey' => false,'conditions'=>array('Radiology.id=RadiologyTestOrder.radiology_id')),
						'ServiceProvider'=>array('foreignKey' => false,'conditions'=>array('ServiceProvider.id=RadiologyTestOrder.service_provider_id')),
						'TariffAmount'=>array('foreignKey' => false,'conditions'=>
								array('TariffAmount.tariff_list_id=Radiology.tariff_list_id' ,'TariffAmount.tariff_standard_id'=>$tariffStandardId)),
				)),false);

		$radData = $this->RadiologyTestOrder->find('all',array('fields'=>array('RadiologyTestOrder.*','ServiceProvider.name','ServiceProvider.id','Radiology.name','TariffAmount.nabh_charges,TariffAmount.non_nabh_charges'),
				'conditions' =>array('RadiologyTestOrder.patient_id'=>$patientId,'RadiologyTestOrder.is_deleted'=>'0'),
				'group'=>array('RadiologyTestOrder.id')));
		$this->set('radData',$radData);

		/*$testRates = $this->labRadRates($tariffStandardId,$patientId);// for rad sevices
		 $this->set('radData',$testRates['radRate']);*/

		$this->ServiceCategory->bindModel(array(
				'belongsTo' => array(
						'Billing'=>array('foreignKey' => false,'conditions'=>array('ServiceCategory.id=Billing.payment_category')),
				)),false);
			
		$radCharge =$this->ServiceCategory->find('all',array('fields'=>array('Billing.*','ServiceCategory.id','ServiceCategory.name'),
				'conditions'=>array('Billing.patient_id'=>$patientId,'ServiceCategory.name'=>'radiology','ServiceCategory.is_view'=>'1','Billing.is_deleted'=>'0')));

		$groupName=str_replace(" ", '',strtolower($radCharge['0']['ServiceCategory']['name'])) ;
		foreach($radCharge as $radIdPaid){
			$splitradTariffId=unserialize($radIdPaid['Billing']['tariff_list_id']);
			//$splitradTariffId=explode(',',$radIdPaid['Billing']['tariff_list_id']);
			foreach($splitradTariffId[$groupName] as $radId){ 
				$paidRad[$radId]=$radId;
				$billedRadId[$radId]=$radIdPaid['Billing']['id'];//billing id=>tariff_list_id
			}
		}
		//debug($paidRad);debug($billedRadId);
		$this->set('billedRadId',$billedRadId);
		$this->set('paidRad',$paidRad);
		$this->set('radCharge',$radCharge);
		$this->set('patient_details',$patient_details);
			
		$this->set('radServiceProviders',$this->ServiceProvider->getServiceProvider('radiology'));
	}

	public function deleteRadCharges($billingId,$patientId){
		$this->loadModel('RadiologyTestOrder');
		//$this->loadModel('VoucherEntry');
		/* if(!empty($billingId)){
			$this->VoucherEntry->updateAll(array('VoucherEntry.is_deleted'=>1),array('VoucherEntry.billing_id'=>$billingId));
		} */
		$this->loadModel('ServiceCategory');
		$this->loadModel('Billing');
		$RadGroupID = $this->ServiceCategory->getServiceGroupId('radiologyservices');
		
		$discount=$this->RadiologyTestOrder->find('first',array('fields'=>array('discount'),'conditions'=>array('id'=>$billingId)));
		
		$this->RadiologyTestOrder->updateAll(array('is_deleted'=>'1'),array('id'=>$billingId));
		$this->Billing->discountDeleteEntry($patientId,$RadGroupID,$discount['RadiologyTestOrder']['discount']);
		
		$this->Session->setFlash(__('Record deleted successfully', true));
		exit;
	}

	public function ajaxBillReceipt($patientId=null){
		$this->layout='ajax';
		 
		$this->set('patientID',$patientId);
		$hospitalType = $this->Session->read('hospitaltype');
		
		$this->uses = array('Billing','Patient','LaboratoryTestOrder','ConsultantBilling','ServiceBill','Account','RadiologyTestOrder','ServiceCategory','FinalBilling','EstimateConsultantBilling');
			
		$tariffStdData = $this->Patient->find('first',array(
				'fields'=>array('id','tariff_standard_id','admission_type','treatment_type','person_id','is_discharge','is_packaged','lookup_name','summary_invoice_discount'),
				'conditions'=>array('id'=>$patientId)));
		$patient_details = $tariffStdData;
		$tariffStandardId	=	$patient_details['Patient']['tariff_standard_id'];
		$this->set('patientData',$patient_details);
		
		//get service dropdown
		$this->ServiceCategory->unBindModel(array('hasMany' => array('ServiceSubCategory')));
		$service_group = $this->ServiceCategory->find("all",array(
				"conditions"=>array("ServiceCategory.is_deleted"=>0,"ServiceCategory.is_view"=>1,
						"ServiceCategory.service_type"=>array($tariffStdData['Patient']['admission_type'],'Both'),
						"ServiceCategory.location_id"=>array($this->Session->read('locationid'),'0')),
				/*'order' => array('ServiceCategory.name' => 'asc')*/));
		$this->set("service_group",$service_group);
		//EOF get service dropdown
			
		
		//registration charges and consultant charges
		$registrationCharges = $this->getRegistrationCharges($totalWardDays,$hospitalType,$tariffStdData['Patient']['tariff_standard_id']);
		$this->set('registrationRate',$registrationCharges);
		 
		$doctorRate  = $this->getDoctorRate(1,$hospitalType,$tariffStdData['Patient']['tariff_standard_id'],$tariffStdData['Patient']['admission_type'],$tariffStdData['Patient']['treatment_type']);
		$this->set('doctorRate',$doctorRate) ;
		//EOF  registration charges and consultant charges

		$servicesData =$this->ServiceBill->find('all',array('fields'=>array('sum(ServiceBill.amount*ServiceBill.no_of_times) AS totalService','sum(ServiceBill.paid_amount) AS totalServicePaid',
				'sum(ServiceBill.discount) AS totalServiceDiscount','ServiceBill.service_id'),
				'conditions'=>array('ServiceBill.patient_id'=>$patientId),'group'=>array('ServiceBill.service_id')));
		$this->set('servicesData',$servicesData);
		
		$servicesRefundData =$this->ServiceBill->find('all',array('fields'=>array('ServiceBill.amount','ServiceBill.service_id','ServiceBill.billing_id','sum(ServiceBill.amount) AS totalRefundService'),
				'conditions'=>array('ServiceBill.patient_id'=>$patientId,'ServiceBill.billing_id !='=>'','ServiceBill.paid_amount'=>'0'),'group'=>array('ServiceBill.service_id')));
		$this->set('servicesRefundData',$servicesRefundData);//for getting refund amount from individual table  --yashwant
		
		/*$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patient_details  = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$patientId),'fields'=>array('id','tariff_standard_id','is_discharge','is_packaged','lookup_name')));
		$patient_details=$tariffStdData;
		$tariffStandardId	=	$patient_details['Patient']['tariff_standard_id'];
		$this->set('patientData',$patient_details);*/

			
		$testRates = $this->labRadRates($tariffStandardId,$patientId);// for lab & rad sevices
		$this->set('getLabData',$testRates['labRate']);
		$this->set('getRadData',$testRates['radRate']);

		$labRefundData =$this->LaboratoryTestOrder->find('first',array('fields'=>array('LaboratoryTestOrder.amount','LaboratoryTestOrder.billing_id','sum(LaboratoryTestOrder.amount) AS totalRefundLab'),
			'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patientId,'LaboratoryTestOrder.billing_id !='=>'0','LaboratoryTestOrder.paid_amount'=>'0')));
		$this->set('labRefundData',$labRefundData);//for getting refund amount from individual table  --yashwant

		$radRefundData =$this->RadiologyTestOrder->find('first',array('fields'=>array('RadiologyTestOrder.amount','RadiologyTestOrder.billing_id','sum(RadiologyTestOrder.amount) AS totalRefundRad'),
			'conditions'=>array('RadiologyTestOrder.patient_id'=>$patientId,'RadiologyTestOrder.billing_id !='=>'0','RadiologyTestOrder.paid_amount'=>'0')));
		$this->set('radRefundData',$radRefundData);//for getting refund amount from individual table  --yashwant
		
		 
		/**
		 * BOF for Private package cost
		*/
		if($patient_details['Patient']['is_packaged']){
			$this->EstimateConsultantBilling->bindModel(array(
					'hasOne'=>array(
							'Patient'=>array('foreignKey'=>false,
							'conditions'=>array('Patient.is_packaged = EstimateConsultantBilling.patient_id'))
					)));
	
			$packageCost = $this->EstimateConsultantBilling->find('first',array('fields'=>array('EstimateConsultantBilling.discount',
					'EstimateConsultantBilling.total_amount','EstimateConsultantBilling.package_total_cost'),
					'conditions'=>array('Patient.id'=>$patientId)));
			$packageCost['EstimateConsultantBilling']['totalDiscount'] = unserialize($packageCost['EstimateConsultantBilling']['discount']);
			$this->set('packageCost' , $packageCost);
		}	
		
		$this->loadModel('Configuration');
		$pharmConfig=$this->Configuration->getPharmacyServiceType();// to get pharmacy service type
		$this->set('pharmaConfig',$pharmConfig['addChargesInInvoice']);
		$pharmacyCategoryId=$this->ServiceCategory->getPharmacyId();//in case need of pharmacy category ID
		//payment_Category is the service_id
		 
		foreach($service_group as $serviceGroupArray){
			$groupIdArray[]=$serviceGroupArray['ServiceCategory']['id'];
		}  
		
		$servicePaidData =$this->Billing->find('all',array('fields'=>array('sum(Billing.amount) AS sumService','Billing.payment_category',
			'Billing.refund','Billing.paid_to_patient','Billing.discount','sum(Billing.discount) AS sumDiscount',
			'sum(Billing.paid_to_patient) AS sumRefund'),
			'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0'),
			'group'=>array('Billing.payment_category')));
		$this->set('servicePaidData',$servicePaidData);
		 
		
		$finalBillData =$this->Billing->find('all',array('fields'=>array(/*'sum(Billing.amount) AS sumFinalBill',*/'Billing.amount',
				'Billing.id','Billing.refund','Billing.paid_to_patient'/*,'sum(Billing.discount) AS sumFinalDiscount'*/),
				'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.payment_category'=>'Finalbill','Billing.is_deleted'=>'0'),
				'order'=>array('Billing.id desc')));
		$this->set('finalBillData',$finalBillData);
		
		//--total advance payment
		$advanceBillData =$this->Billing->find('all',array('fields'=>array('Billing.amount','Billing.id'),
				'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.payment_category'=>Configure::read('advance'),'Billing.is_deleted'=>'0')));
		$advanceBillingPaid=0;
		foreach($advanceBillData as $advanceBillData){
			$advanceBillingPaid=$advanceBillingPaid+$advanceBillData['Billing']['amount'];
		}
		$this->set('advanceBillingPaid',$advanceBillingPaid);
		//--	
		
		$sumFinalDiscount=$this->Billing->find('all',array('fields'=>array('sum(Billing.discount) AS sumFinalDiscount','Billing.id'),
				'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.payment_category'=>'Finalbill','Billing.is_deleted'=>'0'),
				'order'=>array('Billing.id desc')));
		$this->set('sumFinalDiscount',$sumFinalDiscount);
		 
		$discountData =$this->Billing->find('all',array('conditions'=>array('Billing.patient_id'=>$patientId,'OR'=>array('Billing.payment_category !='=>'Finalbill','Billing.payment_category IS NULL'),'Billing.is_deleted'=>'0'),
				'order'=>array('Billing.id DESC')));
		$this->set('discountData',$discountData);
			
		$refundData =$this->Billing->find('all',array('conditions'=>array('Billing.patient_id'=>$patientId,'OR'=>array('Billing.payment_category !='=>'Finalbill','Billing.payment_category IS NULL'),'Billing.is_deleted'=>'0','Billing.refund'=>'1'),
				'order'=>array('Billing.id DESC')));
		$this->set('refundData',$refundData);
			
		$sumFinalRefund=$this->Billing->find('all',array('fields'=>array('Billing.id','Billing.paid_to_patient'),
				'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.payment_category'=>'Finalbill','Billing.is_deleted'=>'0'
						,'Billing.refund'=>'1'),'order'=>array('Billing.id desc')));
		$this->set('sumFinalRefund',$sumFinalRefund);

		/*
		 * code for pharmacy charges in heads
		*/

		$website_service_type=$this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website'/*,'Configuration.location_id'=>$this->Session->read('locationid')*/)));
		$websiteConfig=unserialize($website_service_type['Configuration']['value']);
			 
		if($websiteConfig['instance']=='kanpur'){
			$this->loadModel('PharmacySalesBill');
			  
			$pharmacyCharges= $this->getPharmacyFinalCharges($patientId);//for total pharmacy charge 
			$pharmacyReturnCharges= $this->getPharmacyReturnCharges($patientId); 
			$patient_pharmacy_details = $this->PharmacySalesBill->getPatientSaleDetails($patientId);
			$pharmacy_cash_total = $this->PharmacySalesBill->getCashAmount($patient_pharmacy_details);//for paid pharmacy charge
			$pharmacy_credit_total = $this->PharmacySalesBill->getCreditAmount($patient_pharmacy_details);//for balance pharmacy charge
			$this->set('pharmacy_charges',$pharmacyCharges);
			$this->set('pharmacyReturnCharges',$pharmacyReturnCharges);
			$this->set('pharmacy_cash_total',$pharmacy_cash_total);
			$this->set('pharmacy_credit_total',$pharmacy_credit_total);
				  
		}else{
                        $pharmacy_cash_total = $pharmacy_credit_total = 0;
                        //to get the charges of either original Pharmacy sale or duplicate pharmacy by Swapnil - 15.03.2016
                        $this->loadModel('FinalBilling');
                        $this->loadModel('PharmacySalesBill'); 
                        $useDuplicateSales = $this->Patient->getFlagUseDuplicateSalesCharge($patientId); 
							/*$finalBillingData = $this->FinalBilling->find('first',array(
								'fields'=>array('use_duplicate_sales'),
								'conditions'=>array('patient_id'=>$id,''=>'1')));*/
						if($useDuplicateSales=='1'){
                            $pharmacyCharges= $this->getDuplicatePharmacyFinalCharges($patientId);//for total pharmacy charge
                        }else{
                            $pharmacyCharges= $this->getPharmacyFinalCharges($patientId);//for total pharmacy charge
                            //$pharmacyReturnCharges= $this->getPharmacyReturnCharges($patientId);
                            $patient_pharmacy_details = $this->PharmacySalesBill->getPatientSaleDetails($patientId);
                            $pharmacy_cash_total = $this->PharmacySalesBill->getCashAmount($patient_pharmacy_details);//for paid pharmacy charge
                            $pharmacy_credit_total = $this->PharmacySalesBill->getCreditAmount($patient_pharmacy_details);//for balance pharmacy charge
                        }  
						
			$this->set('pharmacy_charges',$pharmacyCharges);
			//$this->set('pharmacyReturnCharges',$pharmacyReturnCharges);
			$this->set('pharmacy_cash_total',$pharmacy_cash_total);
			$this->set('pharmacy_credit_total',$pharmacy_credit_total);
			
			
			///for salesbill to maintain 1rs issue
			$this->loadModel('PharmacySalesBill');
			$pharmacySaleBIllData=$this->PharmacySalesBill->find('all',array('fields'=>array('PharmacySalesBill.*'),
					'conditions'=>array('PharmacySalesBill.patient_id'=>$patientId,'PharmacySalesBill.is_deleted'=>'0')));
			$this->set('pharmacySaleBIllData',$pharmacySaleBIllData);
			
			$pharmacyReturnCharges= $this->getPharmacyReturnCharges($patientId);
			$this->set('pharmacyReturnCharges',$pharmacyReturnCharges);
			
			if($websiteConfig['instance']=='vadodara'){//ot pharmacy only for vadodara  --yashwant
				$this->loadModel('OtPharmacySalesBill');
				$OtPharmacyData=$this->OtPharmacySalesBill->getOtPharmacyData($patientId);//ot pharmacy data
				$this->set('OtPharmacyData',$OtPharmacyData);
				
				$this->loadModel('OtPharmacySalesReturn');
				$OtPharmacyReturnData=$this->OtPharmacySalesReturn->getOtPharmacyReturnData($patientId);//ot pharmacy return data
				$this->set('OtPharmacyReturnData',$OtPharmacyReturnData);
				
				//paid return amount  --yashwant
				$paidReturnForPharmacy=$this->Billing->returnPaidAmount($patientId);
				$this->set('paidReturnForPharmacy',$paidReturnForPharmacy);
			}
		}
			
		$this->set('admission_type',$tariffStdData['Patient']['admission_type']);
		$this->set('by_nurse',$isReceivedByNurse['PharmacySalesBill']['by_nurse']);
		$this->set('is_received',$isReceivedByNurse['PharmacySalesBill']['is_received']);
		
		
		/*
		 * code for surgery charges in heads
		*/
		$this->loadModel('TariffStandard') ;
		$pvtTariffStandard = $this->TariffStandard->getPrivateTariffID() ;
		 
		if(!$tariffStandardId) $tariffStandardId = $pvtTariffStandard ;
		//$totalSurgeryAmount=$this->Billing->surgeryCharges($patientId,$tariffStandardId);
		#$surgeryData = $this->getDay2DayCharges($patientId,$tariffStandardId);
		$surgeryData = $this->groupWardCharges($patientId,true); 
		$this->set('surgeryData',$surgeryData);
		//EOF surgery charges
			 
		/*
		 * doctor and nursing charges for mandatory services
		*/
		if($tariffStdData['Patient']['admission_type']=='IPD'){
			$hospitalType = $this->Session->read('hospitaltype');
			//$roomTariff = $this->getDay2DayCharges($patientId,$tariffStandardId);
			$roomTariff = $this->wardCharges($patientId); //as per new changes 
			$totalRoomTariffCharge=$this->finalRoomTariffCharge($roomTariff);
			$this->set('totalRoomTariffCharge',$totalRoomTariffCharge);

			$totalWardDays=count($roomTariff['day']); //total no of days
			$this->set('totalWardDays',$totalWardDays);
			//if($tariffStdData['Patient']['tariff_standard_id']==$pvtTariffStandard){//only for pvt patients-- pooja
				$doctorCharges = $this->Billing->getDoctorCharges($totalWardDays,$hospitalType,$tariffStandardId,$tariffStdData['Patient']['admission_type'],
						$tariffStdData['Patient']['treatment_type']);
				$nursingCharges = $this->Billing->getNursingCharges($totalWardDays,$hospitalType,$tariffStandardId);
				
				$this->set(array('doctorCharges'=>$doctorCharges,'nursingCharges'=>$nursingCharges));
			//}
			
			//for discount and paidAmount of roomTariff
		} 
		
		// consultant charges
		$this->loadModel('ConsultantBilling');
		$getconsultantData = $this->ConsultantBilling->find('all',array('conditions' =>array('ConsultantBilling.patient_id'=>$patientId)));
		$this->set('getconsultantData',$getconsultantData);
			 
		if($websiteConfig['instance']=='vadodara'){//for vadodara only for tht balance issue in heads  --yashwant
			$paymentCardBal=$this->Account->getCardBalance($tariffStdData['Patient']['person_id']);
			$this->set('paymentCardBal',$paymentCardBal);
			echo $this->render('ajax_bill_receipt_copy');
		}else{
			echo $this->render('ajaxBillReceipt');
		}	
		exit;
		
	}
	
	

	public function deleteBillRecord($billingId,$patientId){
		$this->loadModel('Billing');
		$this->Billing->delete($billingId);
		$this->Session->setFlash(__('Record deleted successfully', true));
		exit;
	}


	public function singleBillPayment($patientId=null){//debug($this->params->query['totalCharge']);
		$this->set('patientID',$patientId);
		$this->layout ="advance_ajax" ;
		$this->uses = array('Billing');
		if($this->request->data){
			if($this->request->data['Billing']['mode_of_payment']=='NEFT'){
				$this->request->data['Billing']['bank_name']=$this->request->data['Billing']['bank_name_neft'];
				$this->request->data['Billing']['account_number']=$this->request->data['Billing']['account_number_neft'];
				$this->request->data['Billing']['neft_date']=$this->DateFormat->formatDate2STD($this->request->data['Billing']['neft_date'],Configure::read('date_format'));
			}
			$this->request->data['Billing']['date']=$this->DateFormat->formatDate2STD($this->request->data['Billing']['date'],Configure::read('date_format'));
			$this->request->data['Billing']['location_id']=$this->Session->read('locationid');
			$this->request->data['Billing']['created_by']=$this->Session->read('userid');
			$this->request->data['Billing']['create_time']=date("Y-m-d H:i:s");
			if($this->Billing->save($this->request->data['Billing'])){
				$saveFlag='yes';
				$this->set('saveFlag',$saveFlag);
			}

		}
			
		/*$billingData =$this->Billing->find('all',array('conditions'=>array('Billing.patient_id'=>$patientId)));
			$total=0;
		$totalpaid=0;//debug($billingData);
		//$paymentCategory=array('Services','Consultant','Pathology','Radiology');
		//debug($paymentCategory);
		foreach($billingData as $billingData){
		$total=$total+$billingData['Billing']['total_amount'];
		$totalpaid=$totalpaid+$billingData['Billing']['amount'];
		}*/
		$this->set('total_amount',$this->params->query['totalCharge']);
		$this->set('totalpaid',$this->params->query['totalPaid']);
	}

	public function billReportLab($patientId=null){
		$this->set('patientID',$patientId);
		$this->set('flag',$this->request->query['flag']);
		$website=$this->Session->read('website.instance');
		if($website == 'kanpur')
		{
			if($this->request->query['header'] == 'without')
			{
				$this->layout = false;
			}
			else{
				$this->layout = 'print_with_header';
			}
		}else{
		$this->layout = false;
		}
		$this->uses = array('Billing','ServiceBill','ConsultantBilling','Patient','LaboratoryTestOrder','RadiologyTestOrder','ServiceCategory','User');
			
		if(!empty($this->request->query['recID'])){
			$this->billing_patient_header($patientId,$this->request->query['recID']);
		}else{
			$this->patient_info($patientId);
		}
		if($this->Session->read('website.instance')=='vadodara')$this->patient_info($patientId);
		$doctorIDArr=array();
		
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patient_details  = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$patientId),'fields'=>array('id','tariff_standard_id','lookup_name',
				'admission_type')));
		$tariffStandardId	=	$patient_details['Patient']['tariff_standard_id'];
		$this->set('patient_details',$patient_details);

		if($this->request->query['flag']=='Lab'){
			if($this->request->query['labToPrint'])$labToPrint=explode(',',$this->request->query['labToPrint']);
				
			$this->LaboratoryTestOrder->bindModel(array(
					'belongsTo' => array(
							'Laboratory'=>array('foreignKey' => false,'conditions'=>array('Laboratory.id=LaboratoryTestOrder.laboratory_id')),
							'ServiceProvider'=>array('foreignKey' => false,'conditions'=>array('ServiceProvider.id=LaboratoryTestOrder.service_provider_id')),
							'TariffAmount'=>array('foreignKey' => false,'conditions'=>
									array('TariffAmount.tariff_list_id=Laboratory.tariff_list_id' ,'TariffAmount.tariff_standard_id'=>$tariffStandardId))
					)),false);
	
			if(!empty($this->request->query['recID'])){//for billing record vise receipt
				$billFlag='yes';
				$labToPrint=$this->Billing->find('first',array('fields'=>array('Billing.tariff_list_id','Billing.bill_number'),
						'conditions'=>array('Billing.id'=>$this->request->query['recID'],'Billing.is_deleted'=>'0')));
				
				$labToPrint=unserialize($labToPrint['Billing']['tariff_list_id']);
				 
				//$labToPrint=explode(',',$labToPrint['Billing']['tariff_list_id']);
				$labData = $this->LaboratoryTestOrder->find('all',array('fields'=>array('LaboratoryTestOrder.*','ServiceProvider.name','Laboratory.name','TariffAmount.nabh_charges,TariffAmount.non_nabh_charges'),
						'conditions' =>array('LaboratoryTestOrder.patient_id'=>$patientId,'LaboratoryTestOrder.is_deleted'=>'0',
								'LaboratoryTestOrder.id'=>$labToPrint['laboratory']),/*'group'=>array('Laboratory.id')*/));
			}else{
				$billFlag='no';
				$labData = $this->LaboratoryTestOrder->find('all',array('fields'=>array('LaboratoryTestOrder.*','ServiceProvider.name','Laboratory.name','TariffAmount.nabh_charges,TariffAmount.non_nabh_charges'),
						'conditions' =>array('LaboratoryTestOrder.patient_id'=>$patientId,'LaboratoryTestOrder.is_deleted'=>'0',
								'LaboratoryTestOrder.id'=>$labToPrint),/*'group'=>array('Laboratory.id')*/));
			}
			$this->set(array('labData'=>$labData,'billFlag'=>$billFlag));
	 
			$this->ServiceCategory->bindModel(array(
					'belongsTo' => array(
							'Billing'=>array('foreignKey' => false,'conditions'=>array('ServiceCategory.id=Billing.payment_category')),
					)),false);
	
			$billingData =$this->ServiceCategory->find('all',array('fields'=>array('Billing.*'),
					'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.id'=>$this->request->query['recID'],'ServiceCategory.name'=>'laboratory')));
			$this->set('billingData',$billingData);
			
			foreach($labData as $labDataKey=>$labDataValue){
				$doctorIDArr[]=$labDataValue['LaboratoryTestOrder']['doctor_id'];
			}

		}elseif($this->request->query['flag']=='Radiology'){
			if($this->request->query['radToPrint'])$radToPrint=explode(',',$this->request->query['radToPrint']);

			$this->RadiologyTestOrder->bindModel(array(
					'belongsTo' => array(
							'Radiology'=>array('foreignKey' => false,'conditions'=>array('Radiology.id=RadiologyTestOrder.radiology_id')),
							'ServiceProvider'=>array('foreignKey' => false,'conditions'=>array('ServiceProvider.id=RadiologyTestOrder.service_provider_id')),
							'TariffAmount'=>array('foreignKey' => false,'conditions'=>
									array('TariffAmount.tariff_list_id=Radiology.tariff_list_id' ,'TariffAmount.tariff_standard_id'=>$tariffStandardId))
					)),false);

			if(!empty($this->request->query['recID'])){//for billing record vise receipt
				$billFlag='yes';
				$radToPrint=$this->Billing->find('first',array('fields'=>array('Billing.tariff_list_id','Billing.bill_number'),
						'conditions'=>array('Billing.id'=>$this->request->query['recID'],'Billing.is_deleted'=>'0')));
				
				$radToPrint=unserialize($radToPrint['Billing']['tariff_list_id']);
				
				//$radToPrint=explode(',',$radToPrint['Billing']['tariff_list_id']);

				$radData = $this->RadiologyTestOrder->find('all',array('fields'=>array('RadiologyTestOrder.*','ServiceProvider.name','Radiology.name','TariffAmount.nabh_charges,TariffAmount.non_nabh_charges'),
						'conditions' =>array('RadiologyTestOrder.patient_id'=>$patientId,'RadiologyTestOrder.is_deleted'=>'0',
								'RadiologyTestOrder.id'=>$radToPrint['radiology']),'group'=>array('RadiologyTestOrder.id')));
			}else{
				$billFlag='no';
				$radData = $this->RadiologyTestOrder->find('all',array('fields'=>array('RadiologyTestOrder.*','ServiceProvider.name','Radiology.name','TariffAmount.nabh_charges,TariffAmount.non_nabh_charges'),
						'conditions' =>array('RadiologyTestOrder.patient_id'=>$patientId,'RadiologyTestOrder.is_deleted'=>'0',
								'RadiologyTestOrder.id'=>$radToPrint),'group'=>array('RadiologyTestOrder.id')));
			}
			$this->set('radData',$radData);
			$this->set('billFlag',$billFlag);

			$this->ServiceCategory->bindModel(array(
					'belongsTo' => array(
							'Billing'=>array('foreignKey' => false,'conditions'=>array('ServiceCategory.id=Billing.payment_category')),
					)),false);

			$billingData =$this->ServiceCategory->find('all',array('fields'=>array('Billing.*'),
					'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.id'=>$this->request->query['recID'],'ServiceCategory.name'=>'radiology','Billing.is_deleted'=>'0')));
			$this->set('billingData',$billingData);

			foreach($radData as $radDataKey=>$radDataValue){
				$doctorIDArr[]=$radDataValue['RadiologyTestOrder']['doctor_id'];
			}
			
		}else{

			if($this->request->query['serviceToPrint'])$serviceToPrint=explode(',',$this->request->query['serviceToPrint']);
			$this->ServiceBill->bindModel(array(
					'belongsTo' => array(
							'Patient' =>array('foreignKey'=>'patient_id'),
							"ServiceCategory"=>array('foreignKey'=>'service_id'),
							"ServiceSubCategory"=>array('foreignKey'=>'sub_service_id'),
							'TariffList'=>array('foreignKey'=>'tariff_list_id'),
							'TariffAmount'=>array('foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=ServiceBill.tariff_list_id','TariffAmount.tariff_standard_id'))
					)));

			if(!empty($this->request->query['recID'])){//for billing record vise receipt
				$billFlag='yes';
				$serviceToPrint=$this->Billing->find('first',array('fields'=>array('Billing.tariff_list_id','Billing.bill_number'),
						'conditions'=>array('Billing.id'=>$this->request->query['recID'],'Billing.is_deleted'=>'0')));
				  
				$serviceToPrint=unserialize($serviceToPrint['Billing']['tariff_list_id']);
				//$serviceToPrint=explode(',',$serviceToPrint['Billing']['tariff_list_id']);
				
				$groupName=$this->ServiceCategory->find('first',array('conditions'=>array('ServiceCategory.id'=>$this->request->query['groupID'])));
				$groupName = str_replace(" ", '',strtolower($groupName['ServiceCategory']['name'])) ;
				 
				$servicesData =$this->ServiceBill->find('all',array('group'=>array('ServiceBill.id'),'fields'=>array('TariffAmount.*,
						ServiceCategory.*,ServiceSubCategory.*,TariffList.*,ServiceBill.*,Patient.lookup_name,Patient.form_received_on','Patient.admission_type'),
						'conditions'=>array('ServiceBill.patient_id'=>$patientId,'ServiceBill.service_id'=>$this->request->query['groupID'],
								'ServiceBill.id'=>$serviceToPrint[$groupName])));
					
			}else{
				$billFlag='no';
				$servicesData =$this->ServiceBill->find('all',array('group'=>array('ServiceBill.id'),'fields'=>array('TariffAmount.*,
						ServiceCategory.*,ServiceSubCategory.*,TariffList.*,ServiceBill.*,Patient.lookup_name,Patient.form_received_on','Patient.admission_type'),
						'conditions'=>array('ServiceBill.patient_id'=>$patientId,'ServiceBill.service_id'=>$this->request->query['groupID'],
								'ServiceBill.id'=>$serviceToPrint)));
			}

			$this->set('servicesData',$servicesData);
			$this->set('flag',$servicesData[0]['ServiceCategory']['alias']);
			$this->set('billFlag',$billFlag);

			$this->ServiceCategory->bindModel(array(
					'belongsTo' => array(
							'Billing'=>array('foreignKey' => false,'conditions'=>array('ServiceCategory.id=Billing.payment_category')),
					)),false);
			$billingData =$this->ServiceCategory->find('all',array('fields'=>array('Billing.*','ServiceCategory.id','ServiceCategory.name'),
					'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.id'=>$this->request->query['recID'],'ServiceCategory.id'=>$this->request->query['groupID'])));
			$this->set('billingData',$billingData);
			
			foreach($servicesData as $servicesDataKey=>$servicesDataValue){
				$doctorIDArr[]=$servicesDataValue['ServiceBill']['doctor_id'];
			}
			
		}
		
		//for doctor name on header --yashwant
		$allDoctorList=$this->User->getAllDoctorList();
		$doctorIDArrName=array();
		foreach($doctorIDArr as $doctorIDArrKey=>$doctorIDArrValue){
			if(!in_array($allDoctorList[$doctorIDArrValue], $doctorIDArrName)){
				$doctorIDArrName[]=$allDoctorList[$doctorIDArrValue];
			}
		}
		$doctorIDArrName=implode(' , ',$doctorIDArrName);
		$this->set('doctorIDArrName',$doctorIDArrName);
	}

	public function multiplePaymentModeIpd($id=null) {
		$this->layout  = 'advance' ;
		$this->uses = array('ServiceCategory','TariffStandard','ServiceProvider','Service','Patient',
						    'EstimateConsultantBilling','Account','Person','Appointment','ServiceCategory',
				            'InventorySupplier','Configuration','FinalBilling','User','Coupon','CouponTransaction','GalleryPackageDetail','PackageCategory','PackageSubCategory','PackageSubSubCategory');
		/**********To set patient id in session for new patient hub when patiet in searched from this page- Pooja*********/
		$sessionPatientId=$this->Session->read('hub.patientid');
		if(empty($sessionPatientId) && !empty($id))
				$this->Patient->getSessionPatId($id);
		else{
			if(!empty($id)){			
			if($sessionPatientId!=$id)
				$this->Patient->getSessionPatId($id);
			}
		}
		
				
	 /* $sevicesAvailable = array(1,2,3);
	$groupId =1;
		
		debug($sevicesAvailable);
		debug(in_array($groupId, $sevicesAvailable));*/
			
		
		/*********************************************************************************************************/
		$this->set('patientID',$id);
		$this->set('appoinmentID',$this->params->query['apptId']);
		$configInstance=$this->Session->read('website.instance');
		$this->set('configInstance',$configInstance);
		$this->patient_billing_info($id);
		$tariffStdData=$this->viewVars['patient'];		 
		$privatepatientID=$this->TariffStandard->getPrivateTariffID() ;//for private patientID
		$this->set('privatepatientID',$privatepatientID);
		
		if($tariffStdData['Patient']['tariff_standard_id'] != $privatepatientID) {
			$expectedAmount = $this->FinalBilling->find('first',array('conditions'=>array('FinalBilling.patient_id'=>$id),
					'fields'=>array('FinalBilling.id, FinalBilling.use_duplicate_sales','FinalBilling.expected_amount','FinalBilling.is_bill_finalize','FinalBilling.claim_status','FinalBilling.dr_claim_date','FinalBilling.bill_uploading_date','FinalBilling.bill_prepared_by','FinalBilling.billing_link','FinalBilling.nmi','FinalBilling.nmi_date','FinalBilling.nmi_answered','FinalBilling.bill_submitted_by','FinalBilling.hospital_invoice_amount','FinalBilling.referral_letter','FinalBilling.reason_for_delay')));
			$this->set('expectedAmount',$expectedAmount);
		} //added by pankaj  for corporate patient to fetch added expected amount
		//Get Patient Card Balance
		$this->set('cardBal',$this->Account->getCardBalance($tariffStdData['Patient']['person_id']));
		
		$configPharmData=$this->Configuration->find('first',array('fields'=>array('Configuration.id','Configuration.name','Configuration.value'),
				'conditions'=>array('Configuration.name'=>'pharmacy')));//for pharmacy config detail to show pharmacy amount in heads  --yashwant
		$this->set('configPharmData',$configPharmData);
		
		//for authorise person drop down for discount
		$this->User->unBindModel(array('belongsTo' => array('City','State','Country','Role','Initial')));
		$authPerson =$this->User->find('all',array('fields'=>array('id','CONCAT(first_name," ",last_name) as lookup_name'),

				'conditions'=>array('User.is_authorized_for_discount'=>'1','User.is_deleted'=>'0','User.is_active'=>'1'/*,'User.location_id'=>$this->Session->read('locationid')*/)));
			

		foreach($authPerson as $authPerson){
			$key=$authPerson["User"]["id"];
			$authPersonArr[$key]=$authPerson["0"]["lookup_name"];
		}
		$this->set('authPerson',$authPersonArr);

	
		
		//get person id for encounter (all on patient)
		$this->Patient->bindModel(array(
				'belongsTo' => array('Appointment'=>array('foreignKey' => false,'conditions'=>array('Patient.id=Appointment.patient_id')),)),false);
		
		$encounterId=$this->Patient->find('all',array('fields'=>array('Patient.id','Patient.form_received_on','Patient.is_discharge','Appointment.id'),
				'conditions'=>array('Patient.person_id'=>$tariffStdData['Patient']['person_id'],'Patient.is_deleted'=>'0'),
				'group'=>array('Patient.id')));
		$this->set("encounterId",$encounterId);
		
		if($tariffStdData['Patient']['is_packaged']){
			$packageInstallment = $this->EstimateConsultantBilling->find('first',array('fields'=>array('payment_instruction','patient_id'),
					'conditions'=>array('patient_id'=>$tariffStdData['Patient']['is_packaged'])));
			$this->set('packageInstallment' , unserialize($packageInstallment['EstimateConsultantBilling']['payment_instruction']));
			$this->set('packagedPatientId' , $packageInstallment['EstimateConsultantBilling']['patient_id']);
		}
		
		//get service dropdown
		$this->ServiceCategory->unBindModel(array('hasMany' => array('ServiceSubCategory')));//as we dont need services sub groups  --yashwant
		$service_group = $this->ServiceCategory->find("all",array(
				"conditions"=>array("ServiceCategory.is_deleted"=>0,"ServiceCategory.is_view"=>1,
						"ServiceCategory.service_type"=>array($tariffStdData['Patient']['admission_type'],'Both'),
						"ServiceCategory.location_id"=>array($this->Session->read('locationid'),'0')),
				/*'order' => array('ServiceCategory.name' => 'asc')*/));
		$this->set("service_group",$service_group);
		//EOF get service dropdown
		
		$this->Patient->bindModel(array(
				'hasOne'=>array('Coupon'=>array('foreignKey'=>false,'conditions'=>array('Coupon.batch_name = Patient.coupon_name')))
		));
		$couponData = $this->Patient->find('first',array('fields'=>array('Patient.is_discharge','Patient.coupon_name','Patient.admission_type','Patient.use_duplicate_sales',
				'Coupon.sevices_available','Coupon.coupon_amount','Coupon.type'),
				'conditions'=>array('Patient.id'=>$id/*,'Patient.is_discharge'=>0,'Patient.admission_type'=>'OPD'*/)));
		$this->set('use_duplicate_sales',$couponData['Patient']['use_duplicate_sales']);
		$this->set('CouponPrivilageType',$couponData['Coupon']['type']);
		
		$services = $this->ServiceCategory->find('list', array('conditions'=>array('ServiceCategory.is_deleted'=>0,'ServiceCategory.is_view'=>1,'ServiceCategory.alias IS not null','ServiceCategory.location_id !='=>'23','ServiceCategory.service_type !='=>''),
				'fields'=>array('ServiceCategory.id','ServiceCategory.alias')));
		
		if(!empty($couponData['Patient']['coupon_name'])){
			$couponAMT = unserialize($couponData['Coupon']['coupon_amount']); $allServicesAmt = array();
			foreach($couponAMT as $Ckey => $Cval){
				//  $service[]  = $val['serviceId'];
				//  $serviceName[] = $services[$val['serviceId']];
				$amt = ($Cval['type']=='Percentage') ? $Cval['value'].'%' : $Cval['value'].'.00' ;
				$allServicesAmt[]  = ' '.$services[$Cval['serviceId']].' - '.$amt;
				$CouponServices = implode(', ',$allServicesAmt);
			}
		}
		#debug($couponData);
		$this->set('CouponServices',$CouponServices);
		
		$this->set('serviceProviders',$this->ServiceProvider->getServiceProvider('lab'));//for lab service provider
		$this->set('radServiceProviders',$this->ServiceProvider->getServiceProvider('radiology'));//for rad service provider
			
		$bankDataArray = array();//for bank data in payment mode  --yashwant
		$this->Account->bindModel(array(
				'belongsTo' => array('AccountingGroup'=>array('foreignKey' => false,'conditions'=>array('AccountingGroup.id=Account.accounting_group_id')),)),false);
		$bankData =$this->Account->find('all',array('fields'=>array('id','name'),
				'conditions'=>array('Account.is_deleted'=>'0','Account.location_id'=>$this->Session->read('locationid'),'AccountingGroup.name'=>Configure::read('bankLabel'))));
		foreach($bankData as $bank){
			$bankDataArray[$bank['Account']['id']] = $bank['Account']['name'];
		}
		$this->set('bankData',$bankDataArray);
		 
		if($this->Session->read('website.instance')!='vadodara'){//as blood and implant are not for vadodara
			$this->set('bloodBanks',$this->ServiceProvider->getServiceProvider('blood'));
			$this->set('supliers',$this->InventorySupplier->getSuplier());
		}

		if($this->Session->read('website.instance')=='vadodara'){
			$this->set('allDoctorList',$this->User->getAllDoctorList()); //for new dr dropdown --yashwant
		}
		 // for gallery keyword radio button
		$packageGalleryData = $this->GalleryPackageDetail->getPackageDetailsById($id);
		$this->set('packageGalleryData',$packageGalleryData);
		
		$packageCategory = $this->PackageCategory->getPackageCategoryName();
		$packageSubCategory = $this->PackageSubCategory->getSubPackageCategory();
		$packageSubSubCategory = $this->PackageSubSubCategory->getSubSubPackageCategory();

		$this->set('userList',$this->User->getUsersByRole(array('110','91'))); // only billing managerand billing executive
		
		$this->set(array('packageCategory'=>$packageCategory,'packageSubCategory'=>$packageSubCategory,'packageSubSubCategory'=>$packageSubSubCategory));
		
	}
	
	public function cardBalanceAmount($personID=null){//function for getting card balance  --yashwant
		$this->autoRender = false;
		$this->loadModel('Account');
		$cardBal=$this->Account->getCardBalance($personID);
		return $cardBal['Account']['card_balance'];
		exit;
	}


	public function ajaxDailyroomData($patientId=null,$tariffStandardId=null,$groupId=null) {//debug($tariffStandardId);
		$this->layout='ajax';
		$this->set('patientID',$patientId);
		$this->set('groupId',$groupId);
		$this->uses = array('Patient'); 
		$this->loadModel('Patient');
		$this->loadModel('TariffStandard') ;
		$this->loadModel('ServiceCategory') ;
		$this->loadModel('WardPatientService') ;
		$this->loadModel('Ward') ;
		$this->loadModel('Room') ;
		
		if(!$tariffStandardId) $tariffStandardId = $this->TariffStandard->getPrivateTariffID() ;
		//$bedCharges = $this->getDay2DayCharges($patientId,$tariffStandardId,true);		
			
		$bedCharges = $this->wardCharges($patientId);
		#debug($bedCharges);
		$this->set('roomTariff',$bedCharges);

		$isPrivate=$this->TariffStandard->find('first',array('fields'=>array('TariffStandard.id','TariffStandard.name'),
				'conditions'=>array('TariffStandard.id'=>$tariffStandardId)));
		$this->set('isPrivate',$isPrivate);
		$this->set('tariffStandardId',$tariffStandardId);
			
		$this->ServiceCategory->bindModel(array(
				'belongsTo' => array(
						'Billing'=>array('foreignKey' => false,'conditions'=>array('ServiceCategory.id=Billing.payment_category')),
				)),false);
		$dailyCharge =$this->ServiceCategory->find('all',array('fields'=>array('Billing.*'),
				'conditions'=>array('Billing.patient_id'=>$patientId,'ServiceCategory.name'=>'roomtariff','Billing.is_deleted'=>'0')));
		$this->set('dailyCharge',$dailyCharge);

		$tariffData =$this->TariffStandard->find('list',array('fields'=>array('id','name')));
		$this->set('tariffData',$tariffData);

		$this->loadModel('Patient') ;
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patient_details  = $this->Patient->find('first',array('fields'=>array('Patient.payment_category','Patient.tariff_standard_id','Patient.is_packaged','Patient.admission_type',
				'Patient.form_received_on','Patient.is_discharge'),
				'conditions'=>array('Patient.id'=>$patientId)));
		$this->set('patient',$patient_details);

		
		//for per day service  --yashwant
		$allWardList = $this->Ward->getWardList();
		$this->set('allWardList',$allWardList);
		
		$allRoomList = $this->Room->getRoomList();
		$this->set('allRoomList',$allRoomList);
		
		$this->WardPatientService->bindModel(array(
				'belongsTo'=>array(
					'TariffList'=>array('foreignKey'=>'tariff_list_id'),
					//'TariffAmount'=>array('foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=WardPatientService.tariff_list_id','TariffAmount.tariff_standard_id')),
					'Ward'=>array('foreignKey'=>false,'conditions'=>array('WardPatientService.ward_id=Ward.id'))
				)),false);
		
		$allRoomService=$this->WardPatientService->find('all',array('fields'=>array('Ward.name','WardPatientService.*','TariffList.id','TariffList.name',),
				'conditions'=>array('WardPatientService.patient_id'=>$patientId,'WardPatientService.is_deleted'=>'0')
				,'order'=>array('WardPatientService.date'),'group'=>array('WardPatientService.id')));
		$this->set('allRoomService',$allRoomService);
		//--EOF per day service
		
		
	}


	/**
	 *
	 * @param int $patientId
	 * @param int $tariffStandardId default set to 7 (private) and later it taken from standerd function.
	 */
	public function ajaxProcedureData($patientId=null,$tariffStandardId=null) {
		//$this->layout='ajax';
		//$this->loadModel('OptAppointment') ;
		//$this->loadModel('TariffStandard') ;
		$this->uses = array('ServiceCategory');
		/* if(!$tariffStandardId) $tariffStandardId = $this->TariffStandard->getPrivateTariffID() ;
			$surgery_Data=$this->Billing->surgeryChargesForBilling($patientId,$tariffStandardId);
		$this->set('surgeryData',$surgery_Data);
		*/
		$this->ServiceCategory->bindModel(array(
				'belongsTo' => array(
						'Billing'=>array('foreignKey' => false,'conditions'=>array('ServiceCategory.id=Billing.payment_category')),
				)),false);
		$surgeryCharge =$this->ServiceCategory->find('all',array('fields'=>array('Billing.*'),
				'conditions'=>array('Billing.patient_id'=>$patientId,'ServiceCategory.name'=>'surgery','Billing.is_deleted'=>'0')));
		$this->set('surgeryCharge',$surgeryCharge);
			
		//$this->layout = 'ajax' ;
		$this->loadModel('Patient') ;
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				'hasOne' => array(
						'TariffStandard'=>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
				)));
		$this->loadModel('TariffStandard');
		$patient_details  = $this->Patient->find('first',array('fields'=>array('Patient.payment_category','Patient.tariff_standard_id','TariffStandard.name'),
				'conditions'=>array('Patient.id'=>$patientId)));
			
		$tariffStandardId = $this->TariffStandard->getPrivateTariffID() ;
		$this->set('tariffStandardId',$tariffStandardId);
		$this->set('patientId',$patientId);
			
		//$wardServicesDataNew = $this->getDay2DayWardCharges($patientId,$tariffStandardId,false);
		#$wardServicesDataNew = $this->getDay2DayCharges($patientId,$tariffStandardId,false);
		$wardServicesDataNew = $this->groupWardCharges($patientId,true);//debug($wardServicesDataNew);
		//$wardServicesDataNew = $this->Billing->getSurgeryDetails($patientId,$tariffStandardId);
		$this->set(array('wardServicesDataNew'=>$wardServicesDataNew,'patient'=>$patient_details,'privateId'=>$tariffStandardId));


	}

	public function finalDischarge($patientId=null) {
		$this->layout='advance_ajax';
		$this->set('patientID',$patientId);
		$this->set('appoinmentID',$this->params->query['appoinmentID']);
		$this->set('totalPaymentFlag',$this->params->query['totalPaymentFlag']);
		$this->uses = array('Billing','User','ServiceBill','ConsultantBilling','Patient','LaboratoryTestOrder',
				'RadiologyTestOrder','ServiceCategory','FinalBilling');
		$this->loadModel('DiscountRequest');
		//pharma config
		//Pharmacy charges will be added to billing only if the Pharmacy Service is set to IPD
		$this->loadModel('Configuration');
		/*	$pharmacy_service_type=$this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'Pharmacy')));
		 $pharmConfig=unserialize($pharmacy_service_type['Configuration']['value']);*/

		$pharmConfig=$this->Configuration->getPharmacyServiceType();// to get pharmacy service type
		//$this->set('pharmConfig',$pharmConfig['addChargesInInvoice']);

		$pharmacyCategoryId=$this->ServiceCategory->getPharmacyId();//in case need of pharmacy category ID
			
		$approval = $this->DiscountRequest->find('first',array('conditions'=>array('DiscountRequest.patient_id'=>$patientId,'DiscountRequest.is_deleted'=>0,'DiscountRequest.is_approved'=>0,'DiscountRequest.payment_category'=>"Finalbill")));
		//debug($approval);
		$this->set('approval',$approval);
		//get service dropdown
		$service_group = $this->ServiceCategory->find("all",array(
				"conditions"=>array("ServiceCategory.is_deleted"=>0,"ServiceCategory.is_view"=>1,
						"ServiceCategory.service_type"=>array($tariffStdData['Patient']['admission_type'],'Both'),
						"ServiceCategory.location_id"=>array($this->Session->read('locationid'),'0')),
				/*'order' => array('ServiceCategory.name' => 'asc')*/));
		$this->set("service_group",$service_group);
		//EOF get service dropdown
			
		$servicesData =$this->ServiceBill->find('all',array('fields'=>array('sum(ServiceBill.amount*ServiceBill.no_of_times) AS totalService','ServiceBill.service_id'),
				'conditions'=>array('ServiceBill.patient_id'=>$patientId,$this->params->query['privatePackage']),'group'=>array('ServiceBill.service_id')));
		$this->set('servicesData',$servicesData);
			

		$tariffStdData = $this->Patient->find('first',array('fields'=>array('id','tariff_standard_id','admission_type','treatment_type','is_packaged'),
				'conditions'=>array('id'=>$patientId)));
		//registration charges
		$hospitalType = $this->Session->read('hospitaltype');
		$registrationCharges = $this->getRegistrationCharges($totalWardDays,$hospitalType,$tariffStdData['Patient']['tariff_standard_id']);
		//$this->set('registrationRate',$registrationCharges); //by pankaj because now registration charges has been added in serviceBill table on registration itself
		//EOF charges
		// consultation charges
		if(!$tariffStdData['Patient']['is_packaged'])
			$doctorRate  = $this->getDoctorRate(1,$hospitalType,$tariffStdData['Patient']['tariff_standard_id'],$tariffStdData['Patient']['admission_type'],$tariffStdData['Patient']['treatment_type']);
		$this->set('doctorRate',$doctorRate) ;
		//EOF  consultation charges
			
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patient_details  = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$patientId),'fields'=>array('id','tariff_standard_id','person_id')));
		$tariffStandardId	=	$patient_details['Patient']['tariff_standard_id'];

		/*$this->LaboratoryTestOrder->bindModel(array(
		 'belongsTo' => array(
		 		'Laboratory'=>array('foreignKey' => false,'conditions'=>array('Laboratory.id=LaboratoryTestOrder.laboratory_id')),
		 		'TariffAmount'=>array('foreignKey' => false,'conditions'=>
		 				array('TariffAmount.tariff_list_id=Laboratory.tariff_list_id' ,'TariffAmount.tariff_standard_id'=>$tariffStandardId))
		 )),false);
		$getLabData = $this->LaboratoryTestOrder->find('all',array('fields'=>array('Laboratory.name','LaboratoryTestOrder.amount','TariffAmount.id,TariffAmount.nabh_charges,TariffAmount.non_nabh_charges'),
				'conditions' =>array('LaboratoryTestOrder.patient_id'=>$patientId,'LaboratoryTestOrder.is_deleted'=>'0'),
				/*'group'=>array('Laboratory.id')*//*));
		$this->set('getLabData',$getLabData);*/

		$testRates = $this->labRadRates($tariffStandardId,$patientId);// for lab & rad sevices
		$this->set('getLabData',$testRates['labRate']);
		$this->set('getRadData',$testRates['radRate']);

		/*$this->RadiologyTestOrder->bindModel(array(
		 'belongsTo' => array(
		 		'Radiology'=>array('foreignKey' => false,'conditions'=>array('Radiology.id=RadiologyTestOrder.radiology_id')),
		 		'TariffAmount'=>array('foreignKey' => false,'conditions'=>
		 				array('TariffAmount.tariff_list_id=Radiology.tariff_list_id' ,'TariffAmount.tariff_standard_id'=>$tariffStandardId))
		 )),false);

		$getRadData = $this->RadiologyTestOrder->find('all',array('fields'=>array('Radiology.name','RadiologyTestOrder.amount','TariffAmount.nabh_charges,TariffAmount.non_nabh_charges'),
				'conditions' =>array('RadiologyTestOrder.patient_id'=>$patientId,'RadiologyTestOrder.is_deleted'=>'0'),
				'group'=>array('RadiologyTestOrder.id')));
		$this->set('getRadData',$getRadData);*/
		// url flag to show pharmacy charges -- Pooja
		if($this->params->query['showPhar']){
			$pharmConfig['addChargesInInvoice']='yes';
		}
		if($pharmConfig['addChargesInInvoice']=='no'){
			$finaltotalPaid =$this->Billing->find('first',array('fields'=>array('sum(Billing.amount) AS sumFinaltotalPaid'),
					'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0','Billing.payment_category !='=>$pharmacyCategoryId)));
			$this->set('finaltotalPaid',$finaltotalPaid);

			$servicePaidData =$this->Billing->find('all',array('fields'=>array('sum(Billing.amount) AS sumService','Billing.payment_category','Billing.refund','Billing.paid_to_patient'),
					'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0','Billing.payment_category !='=>$pharmacyCategoryId),'group'=>array('Billing.payment_category')));
			$this->set('servicePaidData',$servicePaidData);

		}else{
			$finaltotalPaid =$this->Billing->find('first',array('fields'=>array('sum(Billing.amount) AS sumFinaltotalPaid'),
					'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0')));
			$this->set('finaltotalPaid',$finaltotalPaid);

			$servicePaidData =$this->Billing->find('all',array('fields'=>array('sum(Billing.amount) AS sumService','Billing.payment_category','Billing.refund','Billing.paid_to_patient'),
					'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0'),'group'=>array('Billing.payment_category')));
			$this->set('servicePaidData',$servicePaidData);
			
		}
			
		$discountData =$this->FinalBilling->find('first',array('conditions'=>array('FinalBilling.patient_id'=>$patientId)));
		$this->set('discountData',$discountData);
			
			
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
			
		$this->Patient->bindModel(array(
				'belongsTo' => array('Person'=>array('foreignKey' => 'person_id')))); 
		$patient_details=$this->Patient->find('first',array('fields'=>array('Patient.*','Person.vip_indicator','Person.vip_chk','Patient.person_id'),'conditions'=>array('Patient.id'=>$patientId)));
		$this->set('patient',$patient_details);
			
		//Pharmacy charges
		//Pharmacy charges will be added to billing only if the Pharmacy Service is set to IPD
		$this->loadModel('Configuration');
		$pharmConfig=$this->Configuration->getPharmacyServiceType();// to get pharmacy service type
		$this->set('pharmaConfig',$pharmConfig['addChargesInInvoice']);
		/*$pharmacy_service_type=$this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'Pharmacy')));
		 $pharmConfig=unserialize($pharmacy_service_type['Configuration']['value']);*/
		//read from session -- Pooja
		$website=$this->Session->read('website.instance');
		if($website=='kanpur'){
			$this->loadModel('PharmacySalesBill');
			$isReceivedByNurse=$this->PharmacySalesBill->find('first',array('fields'=>array('PharmacySalesBill.id','PharmacySalesBill.is_received'),
					'conditions'=>array('PharmacySalesBill.patient_id'=>$patientId)));
			if($isReceivedByNurse['PharmacySalesBill']['is_received']=='1' /* && strtolower($tariffStdData['Patient']['admission_type'])=='ipd' */){
				// url flag to show pharmacy charges -- Pooja
				if($this->params->query['showPhar']){
					$pharmConfig['addChargesInInvoice']='yes';
				}
				if($pharmConfig['addChargesInInvoice']=='yes'){
					//$pharmacyCharges= $this->getPharmacyCharges($patientId);//for total pharmacy charge
					$pharmacyCharges= $this->getPharmacyFinalCharges($patientId);//for total pharmacy charge
					$patient_pharmacy_details = $this->PharmacySalesBill->getPatientSaleDetails($patientId);
					$pharmacy_cash_total = $this->PharmacySalesBill->getCashAmount($patient_pharmacy_details);//for paid pharmacy charge
					$pharmacy_credit_total = $this->PharmacySalesBill->getCreditAmount($patient_pharmacy_details);//for balance pharmacy charge
					$this->set('pharmacy_charges',$pharmacyCharges);
					$this->set('pharmacy_cash_total',$pharmacy_cash_total);
					$this->set('pharmacy_credit_total',$pharmacy_credit_total);

				}
			}
		}else{

			// url flag to show pharmacy charges -- Pooja
			if($this->params->query['showPhar']){
				$pharmConfig['addChargesInInvoice']='yes';
			}
			if($pharmConfig['addChargesInInvoice']=='yes'){
				//$pharmacyCharges= $this->getPharmacyCharges($patientId);//for total pharmacy charge
				$pharmacyCharges= $this->getPharmacyFinalCharges($patientId);//for total pharmacy charge
				$patient_pharmacy_details = $this->PharmacySalesBill->getPatientSaleDetails($patientId);
				$pharmacy_cash_total = $this->PharmacySalesBill->getCashAmount($patient_pharmacy_details);//for paid pharmacy charge
				$pharmacy_credit_total = $this->PharmacySalesBill->getCreditAmount($patient_pharmacy_details);//for balance pharmacy charge
				$this->set('pharmacy_charges',$pharmacyCharges);
				$this->set('pharmacy_cash_total',$pharmacy_cash_total);
				$this->set('pharmacy_credit_total',$pharmacy_credit_total);
					
			}
		}


			
		$guarantor =$this->User->find('all',array('fields'=>array('id','CONCAT(first_name," ",last_name) as lookup_name'),
				'conditions'=>array('User.is_guarantor'=>'1','User.is_deleted'=>'0','User.is_active'=>'1','User.location_id'=>$this->Session->read('locationid'))));
		foreach($guarantor as $guarantor){
			$key=$guarantor["User"]["id"];
			$guarantorArr[$key]=$guarantor["0"]["lookup_name"];
		}
		$this->set('guarantor',$guarantorArr);
			
		$authPerson =$this->User->find('all',array('fields'=>array('id','CONCAT(first_name," ",last_name) as lookup_name'),
				'conditions'=>array('User.is_authorized_for_discount'=>'1','User.is_deleted'=>'0','User.is_active'=>'1'/*,'User.location_id'=>$this->Session->read('locationid')*/)));
			
			
		foreach($authPerson as $authPerson){
			$key=$authPerson["User"]["id"];
			$authPersonArr[$key]=$authPerson["0"]["lookup_name"];
		}
		//debug($authPersonArr);
		$this->set('authPerson',$authPersonArr);

		//for pharmacy charges
		//$pharmacyCharges= $this->getPharmacyCharges($patientId);
		//$this->set('pharmacyCharges',$pharmacyCharges);
			
		//for surgery charges
		//$totalSurgeryAmount=$this->Billing->surgeryCharges($patientId,$tariffStandardId);
		
		//for daily room charges
		#$roomTariff = $this->getDay2DayCharges($patientId,$tariffStandardId,true);
		$roomTariff = $this->groupWardCharges($patientId,true);
		$this->set('surgeryData',$roomTariff);
		$totalRoomTariffCharge=$this->finalRoomTariffCharge($roomTariff);
		$this->set(array('totalRoomTariffCharge'=>$totalRoomTariffCharge,'ward_days'=>$this->getWardWiseCharges($roomTariff)));
			
		/*
		 * doctor and nursing charges for mandatory services
		*/
		if($patient_details['Patient']['admission_type']=='IPD'){
			if($patient_details['Patient']['is_packaged']){
				$this->loadModel('EstimateConsultantBilling');
				$this->EstimateConsultantBilling->bindModel(array(
						'hasOne'=>array(
								'Patient'=>array('foreignKey'=>false,
										'conditions'=>array('Patient.is_packaged = EstimateConsultantBilling.patient_id'))
						)));
				$packageCost = $this->EstimateConsultantBilling->find('first',array('fields'=>array('EstimateConsultantBilling.discount',
						'EstimateConsultantBilling.total_amount'),
						'conditions'=>array('Patient.id'=>$patientId)));
				$packageDiscounts = unserialize($packageCost['EstimateConsultantBilling']['discount']);
				$package['total_amount'] = $packageCost['EstimateConsultantBilling']['total_amount'] + $packageDiscounts['total_discount'];
				$package['discount'] = $packageDiscounts['total_discount'];
				$this->set('package' , $package);
			}
			//$hospitalType = $this->Session->read('hospitaltype');
			//$roomTariff = $this->getDay2DayCharges($patientId,$tariffStandardId);
			$totalWardDays=count($roomTariff['day']); //total no of days
			if(!$patient_details['Patient']['is_packaged']){
				$doctorCharges = $this->Billing->getDoctorCharges($totalWardDays,$hospitalType,$tariffStandardId,$patient_details['Patient']['admission_type'],
						$patient_details['Patient']['treatment_type']);
				$nursingCharges = $this->Billing->getNursingCharges($totalWardDays,$hospitalType,$tariffStandardId);
			}
			$this->set('totalWardDays',$totalWardDays);
			$this->set(array('doctorCharges'=>$doctorCharges,'nursingCharges'=>$nursingCharges));
		}
		// url flag to show pharmacy charges -- Pooja
		if($this->params->query['showPhar']){
			$pharmConfig['addChargesInInvoice']='yes';
		}
		if($pharmConfig['addChargesInInvoice']=='no'){
			//for getting head discount
			$totalHeadDiscount =$this->Billing->find('first',array('fields'=>array('sum(Billing.discount) AS sumDiscount',
					'Billing.payment_category' ),'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0','Billing.payment_category !='=>$pharmacyCategoryId)));
			$totalHeadDiscount[0]['sumDiscount'] = $totalHeadDiscount[0]['sumDiscount'] + (int) $package['discount'];
			$this->set('totalHeadDiscount',$totalHeadDiscount);

			// for getting head refund
			$totalHeadRefund =$this->Billing->find('first',array('fields'=>array('sum(Billing.paid_to_patient) AS sumRefund',
					'Billing.payment_category' ),
					'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0','Billing.refund'=>'1','Billing.payment_category !='=>$pharmacyCategoryId)));
			$this->set('totalHeadRefund',$totalHeadRefund);
			

			$totalPharmacyRefund =$this->Billing->find('first',array('fields'=>array('sum(Billing.paid_to_patient) AS sumRefund',
					'Billing.payment_category' ),
					'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0','Billing.refund'=>'1','Billing.payment_category'=>$pharmacyCategoryId)));
			$this->set('totalPharmacyRefund',$totalPharmacyRefund);
		}else{
			//for getting head discount
			$totalHeadDiscount =$this->Billing->find('first',array('fields'=>array('sum(Billing.discount) AS sumDiscount',
					'Billing.payment_category' ),'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0')));
			$totalHeadDiscount[0]['sumDiscount'] = $totalHeadDiscount[0]['sumDiscount'] + (int) $package['discount'];
			$this->set('totalHeadDiscount',$totalHeadDiscount);

			// for getting head refund
			$totalHeadRefund =$this->Billing->find('first',array('fields'=>array('sum(Billing.paid_to_patient) AS sumRefund','Billing.payment_category' ),
					'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0','Billing.refund'=>'1')));
			$this->set('totalHeadRefund',$totalHeadRefund);
		}


		// consultant charges
		$this->loadModel('ConsultantBilling');
		$getconsultantData = $this->ConsultantBilling->find('all',array('conditions' =>array('ConsultantBilling.patient_id'=>$patientId)));
		$this->set('getconsultantData',$getconsultantData);
			
		// for bank name
		$this->loadModel('Account');
		$this->Account->bindModel(array(
				'belongsTo' => array(
						'AccountingGroup'=>array('foreignKey' => false,'conditions'=>array('AccountingGroup.id=Account.accounting_group_id')),
				)),false);
		$bankData =$this->Account->find('all',array('fields'=>array('id','name'),
				'conditions'=>array('Account.is_deleted'=>'0','AccountingGroup.name'=>Configure::read('bankLabel'))));
		$bankDataArray = array();
		foreach($bankData as $bank){
			$bankDataArray[$bank['Account']['id']] = $bank['Account']['name'];
		}
		$this->set('bankData',$bankDataArray);
		
		//Patient Card Balance - Pooja Gupta
		$accId=$this->Account->find('first',array('fields'=>array('Account.id','Account.card_balance'),
				'conditions'=>array('Account.system_user_id'=>$patient_details['Patient']['person_id'],'Account.user_type'=>'Patient')));
		$this->set('patientCard',$accId['Account']['card_balance']);
			
		echo $this->render('finalDischarge');
		exit;
	}

	public function dischargeIpd($id=null) {//debug($patientId);
		$this->multiplePaymentModeIpd($id) ;
			
	}


	public function ajaxDrNursingCharges($patientId=null) {//debug($patientId);
		$this->layout='ajax';
		$this->set('patientID',$patientId);
		/*
			$serviceCharge =$this->Billing->find('all',array('conditions'=>array('Billing.patient_id'=>$patientId,'Billing.payment_category'=>'Services')));
		$this->set('serviceCharge',$serviceCharge);
		*/
		echo $this->render('ajaxDrNursingCharges');
		exit;
	}

	public function ajaxBloodData($patientId=null,$groupID=null) {//debug($patientId);
		$this->layout='ajax';
		$this->set('patientID',$patientId);
		$this->set('groupID',$groupID);
		$this->set('isNursing',($this->params->query['isNursing'])?$this->params->query['isNursing']:'');
		$this->uses = array('ServiceBill','ServiceProvider','Patient','TariffStandard');
		//BOF-Mahalaxmi for Fetching RGJAY Tariff ID
		$this->set('getTariffRgjayId',$this->TariffStandard->getTariffStandardID('RGJAY'));
		//EOF-Mahalaxmi for Fetching RGJAY Tariff ID
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Room' =>array('foreignKey'=>false,
								'conditions'=>array('Room.id = Patient.room_id')),
				)));
		$addmissionType =$this->Patient->find('first',array('fields'=>array('Patient.admission_type','Patient.tariff_standard_id',
				'Patient.treatment_type','Patient.form_received_on','Patient.is_packaged','Room.room_type'),
				'conditions'=>array('Patient.id'=>$patientId)));
		$this->set('addmissionType',$addmissionType);
		
		$this->ServiceBill->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>'patient_id'),
						"ServiceCategory"=>array('foreignKey'=>'service_id','type'=>'RIGHT'),
						"ServiceSubCategory"=>array('foreignKey'=>'sub_service_id'),
						'TariffList'=>array('foreignKey'=>'tariff_list_id'),
						/*'Billing'=>array('foreignKey'=>false,'conditions'=>array('TariffList.id=Billing.tariff_list_id','Patient.id=Billing.patient_id')),*/
						'TariffAmount'=>array('foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=ServiceBill.tariff_list_id','TariffAmount.tariff_standard_id'))
				)));
			
		$servicesData =$this->ServiceBill->find('all',array('group'=>array('ServiceBill.id'),'fields'=>array('TariffAmount.*,ServiceCategory.*,ServiceSubCategory.*,
				TariffList.*,ServiceBill.*,Patient.lookup_name,Patient.is_discharge,Patient.tariff_standard_id,Patient.form_received_on'),
				'conditions'=>array('ServiceBill.patient_id'=>$patientId,'ServiceBill.service_id'=>$groupID)));
		$this->set('servicesData',$servicesData);

		$this->set('bloodBanks',$this->ServiceProvider->getServiceProvider('blood'));

		$serviceCharge =$this->Billing->find('all',array('conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0',
				'Billing.payment_category'=>$groupID)));

		foreach($serviceCharge as $serviceIdPaid){
			$splitServiceTariffId=explode(',',$serviceIdPaid['Billing']['tariff_list_id']);
			foreach($splitServiceTariffId as $serviceId){
				$paidService[$serviceId]=$serviceId;
			}
		}
		$this->set('paidService',$paidService);
		$this->set('serviceCharge',$serviceCharge);
		
		$tariffStanderdName=$this->TariffStandard->getTariffStandardName($addmissionType['Patient']['tariff_standard_id']);
		$this->set('tariffStanderdName',$tariffStanderdName);

	}



	/*public function ajaxPackageData($patientId=null,$tariffStandardId=null) {//debug($patientId);
	 $this->layout='ajax';
	//$this->loadModel('OptAppointment') ;
	$this->loadModel('TariffStandard') ;
	$this->uses = array('ServiceCategory');
	if(!$tariffStandardId) $tariffStandardId = $this->TariffStandard->getPrivateTariffID() ;
	$wardServicesDataNew = $this->getDay2DayWardCharges($patientId,$tariffStandardId);
	//debug($wardServicesDataNew);
	$this->set('wardServicesDataNew',$wardServicesDataNew);

	/*$this->ServiceCategory->bindModel(array(
			'belongsTo' => array(
					'Billing'=>array('foreignKey' => false,'conditions'=>array('ServiceCategory.id=Billing.payment_category')),
			)),false);
	$surgeryCharge =$this->ServiceCategory->find('all',array('fields'=>array('Billing.*'),'conditions'=>array('Billing.patient_id'=>$patientId,'ServiceCategory.name'=>'surgery')));
	$this->set('surgeryCharge',$surgeryCharge);*/
	/*}*/

	public function ajaxPharmacyData($patientId=null,$tariffStandardId=null) {  //debug($patientId);
		//$this->layout='ajax';
		$this->set('patientID',$patientId);
		$this->set('tariffStandardId',$tariffStandardId);
		$this->uses = array('ServiceBill','PharmacySalesBill','Patient','ServiceCategory','TariffStandard');
		//BOF-Mahalaxmi for Fetching RGJAY Tariff ID
		$this->set('getTariffRgjayId',$this->TariffStandard->getTariffStandardID('RGJAY'));
		//EOF-Mahalaxmi for Fetching RGJAY Tariff ID
		/*$this->ServiceBill->bindModel(array(
		 'belongsTo' => array('Patient' =>array('foreignKey'=>'patient_id'),
		 )));
		$patient_pharmacy_details = $this->PharmacySalesBill->getPatientSaleDetails($patientId);
		$pharmacy_total =0;
		$pharmacy_cash_total = 0;
		$pharmacy_credit_total =0;
		if($patient_pharmacy_details){
		$pharmacy_total = $this->PharmacySalesBill->getTotalAmount($patient_pharmacy_details);
		$pharmacy_cash_total = $this->PharmacySalesBill->getCashAmount($patient_pharmacy_details);
		$pharmacy_credit_total = $this->PharmacySalesBill->getCashAmount($patient_pharmacy_details);
		}
		//debug($pharmacy_total);
		//debug($pharmacy_cash_total);
		*/
		$patient_details  = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$patientId)));
		$this->set('patient_details',$patient_details);

		$this->loadModel('Configuration'); 
		$website_service_type=$this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website'/*,'Configuration.location_id'=>$this->Session->read('locationid')*/)));
		$websiteConfig=unserialize($website_service_type['Configuration']['value']);
			
		if($websiteConfig['instance']=='kanpur'){
			$this->loadModel('PharmacySalesBill');
			$isReceivedByNurse=$this->PharmacySalesBill->find('first',array('fields'=>array('PharmacySalesBill.id','PharmacySalesBill.is_received'),
					'conditions'=>array('PharmacySalesBill.patient_id'=>$patientId)));
			if($isReceivedByNurse['PharmacySalesBill']['is_received']=='1' /* && strtolower($tariffStdData['Patient']['admission_type'])=='ipd' */){
				$pharmacyCharges= $this->getPharmacyCharges($patientId);
				$this->set('pharmacyCharges',$pharmacyCharges);

				$pharmacyReturnCharges= $this->getPharmacyReturnCharges($patientId);
				$this->set('pharmacyReturnCharges',$pharmacyReturnCharges);
			}
		}else{
			$pharmacyCharges= $this->getPharmacyCharges($patientId);
			$this->set('pharmacyCharges',$pharmacyCharges);

			$pharmacyReturnCharges= $this->getPharmacyReturnCharges($patientId);
			$this->set('pharmacyReturnCharges',$pharmacyReturnCharges);
		}
			
		//$pharmacyDataCharge =$this->ServiceCategory->find('all',array('fields'=>array('Billing.*'),'conditions'=>array('Billing.patient_id'=>$patientId,'ServiceCategory.name'=>'pharmacy')));
		//$this->set('pharmacyDataCharge',$pharmacyDataCharge);
			
		//$this->set('pharmacyPaidAmount',$pharmacy_cash_total);
		//echo $this->render('ajaxPharmacyData');
		//exit;

		$this->ServiceCategory->bindModel(array(
				'belongsTo' => array(
						'Billing'=>array('foreignKey' => false,'conditions'=>array('ServiceCategory.id=Billing.payment_category')),
				)),false);

		$pharmacyPaid =$this->ServiceCategory->find('all',array('fields'=>array('Billing.*'),
				'conditions'=>array('Billing.patient_id'=>$patientId,'ServiceCategory.name'=>'pharmacy','Billing.is_deleted'=>'0')));
		$this->set('pharmacyPaid',$pharmacyPaid);
	}
	
	
	public function ajaxOtPharmacyData($patientId=null,$tariffStandardId=null) {
		//$this->layout='ajax';
		$this->set('patientID',$patientId);
		$this->set('tariffStandardId',$tariffStandardId);
		$this->uses = array('Patient','OtPharmacySalesBill','OtPharmacySalesReturn');
	
		/* $patient_details  = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$patientId)));
		$this->set('patient_details',$patient_details);
		
		$this->loadModel('Configuration');
		$website_service_type=$this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website')));
		$websiteConfig=unserialize($website_service_type['Configuration']['value']); */
		 
		$OtPharmacyData=$this->OtPharmacySalesBill->getOtPharmacyData($patientId);//ot pharmacy data
		$this->set('OtPharmacyData',$OtPharmacyData);
		 
		$OtPharmacyReturnData=$this->OtPharmacySalesReturn->getOtPharmacyReturnData($patientId);//ot pharmacy return data
		$this->set('OtPharmacyReturnData',$OtPharmacyReturnData);
		
	}

	public function ajaxImplantData($patientId=null,$groupID=null) {//debug($patientId);
		$this->layout='ajax';
		$this->set('patientID',$patientId);
		$this->set('groupID',$groupID);
		$this->set('isNursing',($this->params->query['isNursing'])?$this->params->query['isNursing']:'');
		$this->uses = array('ServiceBill','InventorySupplier','Patient','TariffStandard');
		//BOF-Mahalaxmi for Fetching RGJAY Tariff ID
		$this->set('getTariffRgjayId',$this->TariffStandard->getTariffStandardID('RGJAY'));
		//EOF-Mahalaxmi for Fetching RGJAY Tariff ID
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Room' =>array('foreignKey'=>false,
								'conditions'=>array('Room.id = Patient.room_id')),
				)));
		$addmissionType =$this->Patient->find('first',array('fields'=>array('Patient.admission_type','Patient.tariff_standard_id',
				'Patient.treatment_type','Patient.form_received_on','Patient.is_packaged','Room.room_type'),
				'conditions'=>array('Patient.id'=>$patientId)));
		$this->set('addmissionType',$addmissionType);
		
		$this->ServiceBill->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>'patient_id'),
						"ServiceCategory"=>array('foreignKey'=>'service_id','type'=>'RIGHT'),
						"ServiceSubCategory"=>array('foreignKey'=>'sub_service_id'),
						'TariffList'=>array('foreignKey'=>'tariff_list_id'),
						'TariffAmount'=>array('foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=ServiceBill.tariff_list_id','TariffAmount.tariff_standard_id'))
				)));
			
		$servicesData =$this->ServiceBill->find('all',array('group'=>array('ServiceBill.id'),'fields'=>array('TariffAmount.*,ServiceCategory.*,
				ServiceSubCategory.*,TariffList.*,ServiceBill.*,Patient.lookup_name,Patient.is_discharge,Patient.tariff_standard_id,
				Patient.form_received_on'),
				'conditions'=>array('ServiceBill.patient_id'=>$patientId,'ServiceBill.service_id'=>$groupID)));
		$this->set('servicesData',$servicesData);

		$this->set('supliers',$this->InventorySupplier->getSuplier());

		$serviceCharge =$this->Billing->find('all',array('conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0',
				'Billing.payment_category'=>$groupID)));

		foreach($serviceCharge as $serviceIdPaid){
			$splitServiceTariffId=explode(',',$serviceIdPaid['Billing']['tariff_list_id']);
			foreach($splitServiceTariffId as $serviceId){
				$paidService[$serviceId]=$serviceId;
			}
		}

		$this->set('paidService',$paidService);
		$this->set('serviceCharge',$serviceCharge);

		$tariffStanderdName=$this->TariffStandard->getTariffStandardName($addmissionType['Patient']['tariff_standard_id']);
		$this->set('tariffStanderdName',$tariffStanderdName);
		
	}

	public function ajaxOtherServiceData($patientId=null,$groupID=null) {//debug($patientId);
		$this->layout='ajax';
		$this->set('patientID',$patientId);
		$this->set('groupID',$groupID);
		$this->set('isNursing',($this->params->query['isNursing'])?$this->params->query['isNursing']:'');
		$this->uses = array('ServiceBill','InventorySupplier','Patient','TariffStandard');
	
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Room' =>array('foreignKey'=>false,
								'conditions'=>array('Room.id = Patient.room_id')),
				)));
		$addmissionType =$this->Patient->find('first',array('fields'=>array('Patient.admission_type','Patient.tariff_standard_id',
				'Patient.treatment_type','Patient.form_received_on','Patient.is_packaged','Room.room_type'),
				'conditions'=>array('Patient.id'=>$patientId)));
		$this->set('addmissionType',$addmissionType);
	
		$this->ServiceBill->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>'patient_id'),
						"ServiceCategory"=>array('foreignKey'=>'service_id','type'=>'RIGHT'),
						"ServiceSubCategory"=>array('foreignKey'=>'sub_service_id'),
						'TariffList'=>array('foreignKey'=>'tariff_list_id'),
						'TariffAmount'=>array('foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=ServiceBill.tariff_list_id','TariffAmount.tariff_standard_id'))
				)));
			
		$servicesData =$this->ServiceBill->find('all',array('group'=>array('ServiceBill.id'),'fields'=>array('TariffAmount.*,ServiceCategory.*,
				ServiceSubCategory.*,TariffList.*,ServiceBill.*,Patient.lookup_name,Patient.is_discharge,Patient.tariff_standard_id,
				Patient.form_received_on'),
				'conditions'=>array('ServiceBill.patient_id'=>$patientId,'ServiceBill.service_id'=>$groupID)));
		$this->set('servicesData',$servicesData);
	
		$this->set('supliers',$this->InventorySupplier->getSuplier());
	
		$serviceCharge =$this->Billing->find('all',array('conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0',
				'Billing.payment_category'=>$groupID)));
	
		foreach($serviceCharge as $serviceIdPaid){
			$splitServiceTariffId=explode(',',$serviceIdPaid['Billing']['tariff_list_id']);
			foreach($splitServiceTariffId as $serviceId){
				$paidService[$serviceId]=$serviceId;
			}
		}
	
		$this->set('paidService',$paidService);
		$this->set('serviceCharge',$serviceCharge);
	
		$tariffStanderdName=$this->TariffStandard->getTariffStandardName($addmissionType['Patient']['tariff_standard_id']);
		$this->set('tariffStanderdName',$tariffStanderdName);
	}

	//radiotheraphy 
	public function ajaxRadiotheraphyData($patientId=null,$groupID=null) {//debug($patientId);
		$this->layout='ajax';
		$this->set('patientID',$patientId);
		$this->set('groupID',$groupID);
		$this->set('isNursing',($this->params->query['isNursing'])?$this->params->query['isNursing']:'');
		$this->uses = array('ServiceBill','InventorySupplier','Patient','TariffStandard');
	
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Room' =>array('foreignKey'=>false,
								'conditions'=>array('Room.id = Patient.room_id')),
				)));
		$addmissionType =$this->Patient->find('first',array('fields'=>array('Patient.admission_type','Patient.tariff_standard_id',
				'Patient.treatment_type','Patient.form_received_on','Patient.is_packaged','Room.room_type'),
				'conditions'=>array('Patient.id'=>$patientId)));
		$this->set('addmissionType',$addmissionType);
	
		$this->ServiceBill->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>'patient_id'),
						"ServiceCategory"=>array('foreignKey'=>'service_id','type'=>'RIGHT'),
						"ServiceSubCategory"=>array('foreignKey'=>'sub_service_id'),
						'TariffList'=>array('foreignKey'=>'tariff_list_id'),
						'TariffAmount'=>array('foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=ServiceBill.tariff_list_id','TariffAmount.tariff_standard_id'))
				)));
			
		$servicesData =$this->ServiceBill->find('all',array('group'=>array('ServiceBill.id'),'fields'=>array('TariffAmount.*,ServiceCategory.*,
				ServiceSubCategory.*,TariffList.*,ServiceBill.*,Patient.lookup_name,Patient.is_discharge,Patient.tariff_standard_id,
				Patient.form_received_on'),
				'conditions'=>array('ServiceBill.patient_id'=>$patientId,'ServiceBill.service_id'=>$groupID)));
		$this->set('servicesData',$servicesData);
	
		$this->set('supliers',$this->InventorySupplier->getSuplier());
	
		$serviceCharge =$this->Billing->find('all',array('conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0',
				'Billing.payment_category'=>$groupID)));
	
		foreach($serviceCharge as $serviceIdPaid){
			$splitServiceTariffId=explode(',',$serviceIdPaid['Billing']['tariff_list_id']);
			foreach($splitServiceTariffId as $serviceId){
				$paidService[$serviceId]=$serviceId;
			}
		}
	
		$this->set('paidService',$paidService);
		$this->set('serviceCharge',$serviceCharge);
	
		$tariffStanderdName=$this->TariffStandard->getTariffStandardName($addmissionType['Patient']['tariff_standard_id']);
		$this->set('tariffStanderdName',$tariffStanderdName);
	}
	
	
	public function ajaxWardProcedureData($patientId=null,$groupID=null) {//debug($patientId);
		$this->layout='ajax';
		$this->set('patientID',$patientId);
		$this->set('groupID',$groupID);
		$this->set('isNursing',($this->params->query['isNursing'])?$this->params->query['isNursing']:'');
		$this->uses = array('ServiceBill','InventorySupplier','Patient');
		
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Room' =>array('foreignKey'=>false,
								'conditions'=>array('Room.id = Patient.room_id')),
				)));
		$addmissionType =$this->Patient->find('first',array('fields'=>array('Patient.admission_type','Patient.tariff_standard_id',
				'Patient.treatment_type','Patient.form_received_on','Patient.is_packaged','Room.room_type'),
				'conditions'=>array('Patient.id'=>$patientId)));
		$this->set('addmissionType',$addmissionType);
		
		$this->ServiceBill->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>'patient_id'),
						"ServiceCategory"=>array('foreignKey'=>'service_id','type'=>'RIGHT'),
						"ServiceSubCategory"=>array('foreignKey'=>'sub_service_id'),
						'TariffList'=>array('foreignKey'=>'tariff_list_id'),
						'TariffAmount'=>array('foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=ServiceBill.tariff_list_id','TariffAmount.tariff_standard_id'))
				)));
			
		$servicesData =$this->ServiceBill->find('all',array('group'=>array('ServiceBill.id'),'fields'=>array('TariffAmount.*,ServiceCategory.*,
				ServiceSubCategory.*,TariffList.*,ServiceBill.*,Patient.lookup_name,Patient.is_discharge,Patient.tariff_standard_id,
				Patient.form_received_on'),
				'conditions'=>array('ServiceBill.patient_id'=>$patientId,'ServiceBill.service_id'=>$groupID)));
		$this->set('servicesData',$servicesData);

		$this->set('supliers',$this->InventorySupplier->getSuplier());

		$serviceCharge =$this->Billing->find('all',array('conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0',
				'Billing.payment_category'=>$groupID)));

		foreach($serviceCharge as $serviceIdPaid){
			$splitServiceTariffId=explode(',',$serviceIdPaid['Billing']['tariff_list_id']);
			foreach($splitServiceTariffId as $serviceId){
				$paidService[$serviceId]=$serviceId;
			}
		}

		$this->set('paidService',$paidService);
		$this->set('serviceCharge',$serviceCharge);

	}

	public function requestForApproval()	//to send request for approval  (both: refund or discount)
	{
		$this->autoRender = false;
		$this->layout = false;
		$this->loadModel("DiscountRequest");
		//debug($this->request->data);exit;
		if($this->DiscountRequest->SaveRequest($this->request->data))
		{
			return 1;
		}
	}

	public function Resultofrequest()
	{
		$this->autoRender = false;
		$this->layout = false;
		$this->loadModel("DiscountRequest");
		$session = new cakeSession();
			
		$request_by	 = $session->read('userid');
		$request_to = $this->request->data['request_to'];
		$type = $this->request->data['type'];
		$patient_id = $this->request->data['patient_id'];
		$payment_category = $this->request->data['payment_category'];
		$result = $this->DiscountRequest->find('first',array(
				'conditions'=>array('DiscountRequest.patient_id'=>$patient_id,
						'DiscountRequest.type'=>$type,
						'DiscountRequest.is_approved !='=>NULL,
						'DiscountRequest.request_by'=>$request_by,
						'DiscountRequest.request_to'=>$request_to,
						'DiscountRequest.is_deleted'=>0,
						'DiscountRequest.closed'=>0,
						'DiscountRequest.payment_category'=>$payment_category),
				'order'=>array('DiscountRequest.id'=>"DESC")
		));
		//debug($this->request->data);
		return $result['DiscountRequest']['is_approved'];
	}

	/*
	 * Display all the approval for final billing and/or services
	* By Swapnil G.Sharma
	*/

	public function discount_requests()
	{
		$this->layout = "advance";
	}

	/**
	 * Approve/Reject request by authenticate users
	 * By Swapnil G.Sharma
	 */

	public function ApprovalRequest()	//approved requests
	{
		$this->autoRender = false;
		$this->layout = false;
		$this->loadModel("DiscountRequest");
		$this->DiscountRequest->UpdateApprovalStatus($this->request->data);		// approved or reject the status by updating.. (1 for approved nad 2 for reject)
	}

	public function updateService($patientID=null,$recID=null)	//update service record of billing by yashwant
	{
		$this->autoRender = false;

		if($this->params->query['flag']=='Radiology'){ // for radiology
			$this->loadModel("Billing");
			$this->Billing->UpdateRadiologyRec($this->request->data,$patientID,$recID);
		}elseif($this->params->query['flag']=='Laboratory'){ // for Laboratory
			$this->loadModel("Billing");
			$this->Billing->UpdateLaboratoryRec($this->request->data,$patientID,$recID);
		}elseif($this->params->query['flag']=='Service'){ // for Service
			$this->loadModel("Billing");
			$this->Billing->UpdateServiceRec($this->request->data,$patientID,$recID,$this->params->query['groupID']);
		}elseif($this->params->query['flag']=='wardPatientService'){ // for wardpatientservice
			$this->loadModel("Billing"); 
			$error=$this->Billing->UpdateWardPatientRec($this->request->data,$patientID,$recID);
			if($error){//error massage for ward services --yashwant
				$this->Session->setFlash($error,'default',array('class'=>"error"));
				exit;
			}
		}
	}

	/**
	 * Cancelling request by billing users
	 * By Swapnil G.Sharma
	 */

	public function cancelApproval()
	{
		$this->loadModel("DiscountRequest");
		$this->autoRender = false;
		$this->layout = false;
		$this->DiscountRequest->DeleteRequest($this->request->data);
	}


	public function finalRoomTariffCharge($roomTariff=null)
	{
		$this->autoRender = false;
		$totalAmount=0;
		$totalPaidAmount=0;
		$totalDiscount=0;
		$totalDrPaidAmount=0;
		$totalNursePaidAmount=0;
		$r=1;
		$hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_rate':'non_nabh_rate' ;
		$rCost = 0 ;
		$g=0;$t=0;

		foreach($roomTariff['day'] as $roomKey=>$roomCost){
			$bedCharges[$g][$roomCost['ward']]['bedCost'][] = $roomCost['cost'] ;
			$bedCharges[$g][$roomCost['ward']]['paid_amount'][] = $roomCost['paid_amount'] ;
			$bedCharges[$g][$roomCost['ward']]['discount'][] = $roomCost['discount'] ;
			
			$bedCharges[$g][$roomCost['ward']]['doctor_paid_amount'][] = $roomCost['doctor_paid_amount'] ;
			$bedCharges[$g][$roomCost['ward']]['nurse_paid_amount'][] = $roomCost['nurse_paid_amount'] ;
			
			$bedCharges[$g][$roomCost['ward']][] = array('out'=>$roomCost['out'],
					'in'=>$roomCost['in'],
					'moa_sr_no'=>$roomCost['moa_sr_no'],
					'cghs_code'=>$roomCost['cghs_code']);
			if($roomTariff['day'][$roomKey+1]['ward']!=$roomCost['ward']){
				$g++;
			}
		} 

		foreach($bedCharges as $bedKey=>$bedCost){
			$wardNameKey = key($bedCost);
			$bedCost= $bedCost[$wardNameKey];
			$rCost += array_sum($bedCost['bedCost']) ;
			$splitDateIn = explode(" ",$bedCost[0]['in']);
			 
			$totalAmount= $totalAmount+array_sum($bedCost['bedCost']) ; 
			$totalPaidAmount =$totalPaidAmount+array_sum($bedCost['paid_amount']) ;
			$totalDiscount =$totalDiscount+array_sum($bedCost['discount']) ;
			
			$totalDrPaidAmount = $totalDrPaidAmount+array_sum($bedCost['doctor_paid_amount']) ;
			$totalNursePaidAmount =  $totalNursePaidAmount+array_sum($bedCost['nurse_paid_amount']) ;
		} 

		return array('total'=>$totalAmount,'paid_amount'=>$totalPaidAmount,'discount'=>$totalDiscount,'dr_paid_amount'=>$totalDrPaidAmount,'nurse_paid_amount'=>$totalNursePaidAmount );
	}


	//check if ther is any request for discount or refund
	public function checkDiscountApproval()
	{
		$this->autoRender = false;
		$this->layout = false;
		$this->loadModel("DiscountRequest");
		$session = new cakeSession();
			
		$request_by	 = $session->read('userid');
		$patient_id = $this->request->data['patient_id'];
		$payment_category = $this->request->data['payment_category'];
		//debug($this->request->data);
		$result = $this->DiscountRequest->find('first',array('conditions'=>array('DiscountRequest.patient_id'=>$patient_id,'DiscountRequest.is_approved !='=>NULL,
				'DiscountRequest.request_by'=>$request_by,'DiscountRequest.is_deleted'=>0,'DiscountRequest.payment_category'=>$payment_category,
				'DiscountRequest.type != "Refund"','DiscountRequest.closed'=>0),
				'order'=>array('DiscountRequest.id'=>"DESC")
		
		));
		echo json_encode($result['DiscountRequest']);
		exit;
		/*echo json_encode($contracts);
			exit;*/
	}


	public function checkRefundApproval()
	{
		$this->autoRender = false;
		$this->layout = false;
		$this->loadModel("DiscountRequest");
		$session = new cakeSession();
			
		$request_by	 = $session->read('userid');
		$patient_id = $this->request->data['patient_id'];
		$payment_category = $this->request->data['payment_category'];
		//debug($this->request->data);
		$result = $this->DiscountRequest->find('first',array('conditions'=>array('DiscountRequest.patient_id'=>$patient_id,'DiscountRequest.is_approved !='=>NULL,
				'DiscountRequest.request_by'=>$request_by,'DiscountRequest.is_deleted'=>0,'DiscountRequest.payment_category'=>$payment_category,'DiscountRequest.type = "Refund"','DiscountRequest.closed'=>0),
				'order'=>array('DiscountRequest.id'=>"DESC")
		));
		echo json_encode($result['DiscountRequest']);
		exit;
		/*echo json_encode($contracts);
			exit;*/
	}


	/*
	 *function to return package details
	*@params patient id and tariff standard id
	*By Pankaj W
	*@Return Array of ward and surgery with charges, date and other details
	*/
	function ajaxPackageData($patient_id=null,$tariffStandardId=null){
		$this->layout = 'ajax' ;
	//	$wardServicesDataNew = $this->getDay2DayWardCharges($patient_id,$tariffStandardId);
		#$wardServicesDataNew = $this->getDay2DayCharges($patient_id,$tariffStandardId);
		$wardServicesDataNew = $this->groupWardCharges($patient_id);
		$this->set('wardServicesDataNew',$wardServicesDataNew);
	}


	/**
	 * Final Payment 
	 * Services in Tree structure categorised checkboxes payment function
	 * @params patient id
	 * By Pooja Gupta
	 */	
function full_payment($patient_id=NULL){
		$this->layout ='advance_ajax';		
		//$this->set('patientID',$patientId);
		$this->set('appoinmentID',$this->params->query['appoinmentID']);
		$this->set('totalPaymentFlag',$this->params->query['totalPaymentFlag']);
		$this->uses = array('LaboratoryTestOrder','WardPatient','ServiceCategory','OtPharmacySalesBill','InventoryPharmacySalesReturn',
				'Patient','ServiceBill','OptAppointment','RadiologyTestOrder','PharmacySalesBill','OtPharmacySalesReturn','TariffStandard',
				'ConsultantBilling','Account','PatientCard','DischargeDetail','Bed','Billing','Message','TariffAmount','Configuration');
		
		$pvtTariffId=$this->TariffStandard->getPrivateTariffID();
		$this->patient_info($patient_id);
		
		$tariffStdData = $this->Patient->find('first',array('fields'=>array('id','tariff_standard_id','is_discharge','treatment_type','admission_type',
				'is_packaged','person_id','lookup_name','age','person_id','diagnosis_txt','treatment_type'),
				'conditions'=>array('id'=>$patient_id)));
		
		$this->set('tariffStdData',$tariffStdData);
		
		/**For hope instance OPD patient show pharmacy irrespective of configuration - Pooja**/		
		if('hope'=='hope' && $tariffStdData['Patient']['admission_type']=='OPD'){
			$serviceCategory = $this->ServiceCategory->find("list",array('fields'=>array('id','name'),
					"conditions"=>array("ServiceCategory.is_deleted"=>0,"ServiceCategory.is_view"=>1,
							//"ServiceCategory.service_type"=>array($tariffStdData['Patient']['admission_type'],'Both'),
							"ServiceCategory.location_id"=>array($this->Session->read('locationid'),'0')),
					/*'order' => array('ServiceCategory.name' => 'asc')*/));
			$serviceCategoryName = $this->ServiceCategory->find("list",array('fields'=>array('id','alias'),
					"conditions"=>array("ServiceCategory.is_deleted"=>0,"ServiceCategory.is_view"=>1,
							//"ServiceCategory.service_type"=>array($tariffStdData['Patient']['admission_type'],'Both'),
							"ServiceCategory.location_id"=>array($this->Session->read('locationid'),'0')),
					/*'order' => array('ServiceCategory.name' => 'asc')*/));
		}else{		
			$serviceCategory = $this->ServiceCategory->find("list",array('fields'=>array('id','name'),
											"conditions"=>array("ServiceCategory.is_deleted"=>0,/*"ServiceCategory.is_view"=>1,*/
														"ServiceCategory.service_type"=>array($tariffStdData['Patient']['admission_type'],'Both'),
														"ServiceCategory.location_id"=>array($this->Session->read('locationid'),'0')),
														/*'order' => array('ServiceCategory.name' => 'asc')*/));
			$serviceCategoryName = $this->ServiceCategory->find("list",array('fields'=>array('id','alias'),
					"conditions"=>array("ServiceCategory.is_deleted"=>0,/*"ServiceCategory.is_view"=>1,*/
							"ServiceCategory.service_type"=>array($tariffStdData['Patient']['admission_type'],'Both'),
							"ServiceCategory.location_id"=>array($this->Session->read('locationid'),'0')),
					/*'order' => array('ServiceCategory.name' => 'asc')*/));
		}
		$this->set('serviceCategoryName',$serviceCategoryName);
		$lastNotesId=$this->Billing->find('first',array('fields'=>array('id'),'order'=>array('Billing.id Desc')));		
		$lastNotesId=$lastNotesId['Billing']['id'];
		$accId=$this->Account->find('first',array('fields'=>array('Account.id','Account.card_balance'),
				                    'conditions'=>array('Account.system_user_id'=>$tariffStdData['Patient']['person_id'],
				                    		'user_type'=>'Patient')));
		
		$this->set('patientCard',$accId);
		
		//if any one entry in final bill for doctor and nursing charges considered to be paid
		/*$this->loadModel(FinalBilling);
		$entryInFinal=$this->Billing->find('first',array('fields'=>array('id','amount','tariff_list_id'),
				'conditions'=>array('patient_id'=>$patient_id,'payment_category'=>'Finalbill'),
				'order'=>array('Billing.id DESC')));		
		$this->set('entryInFinal',$entryInFinal);
		$manTariff=unserialize($entryInFinal['Billing']['tariff_list_id']);*/
		//advance amount of any patient from billing payment category type must be 'advance', 'CorporateAdvance', 'TDS'
		$advanceAmount=$this->Billing->find('first',array('fields'=>array('SUM(Billing.amount_paid) as paidAdvance', 'Sum(Billing.amount) as advance'),
					'conditions'=>array('patient_id'=>$patient_id,'payment_category'=>array('advance', 'CorporateAdvance', 'TDS')),
					'group'=>array('Billing.patient_id')));
		
		$this->set('advanceAmount',$advanceAmount);
		
		if(!empty($this->request->data)){
			foreach($this->request->data['Billing'] as $billKey=>$billValue){
				foreach($billValue as $serviceKey=> $serviceValue){
					if(!empty($serviceValue['valChk'])){						
							if(($serviceCategory[$serviceValue['service_id']]==Configure::read('laboratoryservices'))||
								($serviceCategory[$serviceValue['service_id']]==Configure::read('radiologyservices'))||
								($serviceCategory[$serviceValue['service_id']]==Configure::read('surgeryservices')) ||
								($serviceCategory[$serviceValue['service_id']]==Configure::read('Consultant')) ){						
							if($serviceCategory[$serviceValue['service_id']]==Configure::read('laboratoryservices')){
								$labKey='Laboratory';
								$model='LaboratoryTestOrder';
							}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('radiologyservices')){
								$labKey='Radiology';
								$model='RadiologyTestOrder';
							}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('surgeryservices')){
								$labKey='Surgery';
								$model='OptAppointment';
							}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('Consultant')){
								$labKey='Consultant';
								$model='ConsultantBilling';
							}
								$billTariffId[$serviceCategory[$serviceValue['service_id']]][]=$serviceValue['id'];
								$totalPayAmt=$totalPayAmt+$serviceValue['editAmt'];
								$totalDis=	$totalDis+$serviceValue['discount'];
								
							}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('mandatoryservices')){
							
							if($serviceValue['name']==Configure::read('DoctorsCharges') || $serviceValue['name']==Configure::read('NursingCharges')){
								if($serviceValue['name']==Configure::read('DoctorsCharges')){
									//if((empty($serviceValue['paid_amount']) || $serviceValue['paid_amount']<=0)){
										$servKeyArrayId=$serviceCategory[$serviceValue['service_id']];
										$billTariffId[$servKeyArrayId][]=$serviceValue['id'];
										$totalPayAmt=$totalPayAmt+$serviceValue['amount'];
										$totalDis=	$totalDis+$serviceValue['discount'];
									//}
								}else{
									if($serviceValue['name']==Configure::read('NursingCharges')){
										//if((empty($serviceValue['paid_amount']) || $serviceValue['paid_amount']<=0)){
											$servKeyArrayId=$serviceCategory[$serviceValue['service_id']];
											$billTariffId[$servKeyArrayId][]=$serviceValue['id'];
											$totalPayAmt=$totalPayAmt+$serviceValue['amount'];
											$totalDis=	$totalDis+$serviceValue['discount'];
											
										//}
									}
								}
							}else{
								//if(empty($serviceValue['paid_amount']) || $serviceValue['paid_amount']<=0){
									$servKeyArrayId=$serviceCategory[$serviceValue['service_id']];
									$billTariffId[$servKeyArrayId][]=$serviceValue['service_bill_id'];
									$totalPayAmt=$totalPayAmt+$serviceValue['amount'];
									$totalDis=	$totalDis+$serviceValue['discount'];
								//}
							}
						}else{
								$servKeyArrayId=$serviceCategory[$serviceValue['service_id']];
								$billTariffId[$servKeyArrayId][]=$serviceValue['service_bill_id'];
								$totalPayAmt=$totalPayAmt+$serviceValue['editAmt'];	
								$totalDis=	$totalDis+$serviceValue['discount'];
								
							}
						
					}
						
				}//EOF inner foreach
				
			}//EOF Outer foreach 
			$srArray=serialize($billTariffId);
			
			$totalBillAmt=ceil($this->request->data['Billing']['total_amount']);//total bill amount
			
			$totalAdvAmt=ceil($this->request->data['Billing']['amount_paid']);	//Previous paid bill amount	
					
			$totalPayAmt=$this->request->data['TotalPayBill']; //amount in selected services payable
			
			$totalBalAmt=$totalBillAmt-($totalAdvAmt+$totalPayAmt); //amount pending
			
			//discount Calculations
			if(!empty($this->request->data['Billing']['discount'])){
				$totalPayAmt=$totalPayAmt-$this->request->data['Billing']['discount'];
				$discount=$this->request->data['Billing']['discount'];
				//$totalBalAmt=$totalBalAmt-$this->request->data['Billing']['discount'];
			
			}
			
			$totalAdvAmt=$totalAdvAmt+$totalPayAmt; //for calculating the amount paid field after deducting discount amount
			
			if(!empty($this->request->data['Billing']['advance_used'])){
				$totalPayAmt=ceil($totalPayAmt-$this->request->data['Billing']['advance_used']);
			}
			
			
			if(!empty($this->request->data['Billing']['refund']) || !empty($this->request->data['Billing']['hrefund'])){	
				$totalPayAmt=0; // for refund the amount will be "0"
			}
			
			
			
			
			$billNo=$this->generateBillNoPerPay($this->request->data['Billing']['patient_id'],$lastNotesId);
			
			
			
			
			
			//Calculations for advance amount paid
			if(!empty($this->request->data['Billing']['advance_used']) || !empty($this->request->data['Billing']['advance_not_used'])){
				if($this->params->query['corporate']){
					$advanceIdArray=$this->Billing->find('all',array('fields'=>array('Billing.id','Billing.amount_paid','Billing.amount_pending','Billing.amount'),
						'conditions'=>array('patient_id'=>$patient_id,'payment_category'=>array('advance', 'CorporateAdvance', 'TDS')),
						));
				}else{
					$advanceIdArray=$this->Billing->find('all',array('fields'=>array('Billing.id','Billing.amount_paid','Billing.amount_pending','Billing.amount'),
							'conditions'=>array('patient_id'=>$patient_id,'payment_category'=>'advance'),
					));
				}
				$advaUsedAmount=$this->request->data['Billing']['advance_used'];
				foreach($advanceIdArray as $maintainData){
					if($advaUsedAmount!='0'){
						if($advaUsedAmount>= $maintainData['Billing']['amount']){
							$amount_paid=$maintainData['Billing']['amount_paid']+$maintainData['Billing']['amount'];
							$amount_pending=$maintainData['Billing']['amount_pending']+$amount_paid;
							$advaUsedAmount=$advaUsedAmount-$maintainData['Billing']['amount'];
						}else{
							$amount_paid=$maintainData['Billing']['amount_paid']+$advaUsedAmount;
							$amount_pending=$maintainData['Billing']['amount_pending']+$amount_paid;
							$advaUsedAmount='0';
						}
						$this->Billing->updateAll(array('Billing.amount_paid'=>$amount_paid,'Billing.amount_pending'=>$amount_pending),array('Billing.id'=>$maintainData['Billing']['id']));
					}
				}
				
			}
			//dpr($this->request->data);exit;
			
			//EOF Advanced amount
			
			//for hope as the field is editable
			if($this->Session->read('website.instance')=='hope'){
				$totalPayAmt=$this->request->data['Billing']['changeAmt'];
				$totalBalAmt=$totalBillAmt-($totalAdvAmt+$totalPayAmt)-$discount;
			}
			//Refund Calculations
			if(!empty($this->request->data['Billing']['refund']) || !empty($this->request->data['Billing']['hrefund']) || !empty($this->request->data['Billing']['paid_to_patient'])){
				$this->request->data['Billing']['refund']='1';
				if($this->Session->read('website.instance')=='hope'){
					$refund=$this->request->data['Billing']['refund_to_patient'];
					$totalBalAmt=$totalBalAmt+$this->request->data['Billing']['refund_to_patient'];
					$totalPayAmt='0';
				}else{
					$refund=$this->request->data['Billing']['paid_to_patient'];
					$totalBalAmt=$totalBalAmt+$this->request->data['Billing']['paid_to_patient'];
					$totalPayAmt='0';
				}
				
				$discount=-($totalDis);
				
			}else{
				$this->request->data['Billing']['refund']=0;
				//$totalPayAmt=$totalPayAmt-$advanceAmount['0']['paidAdvance'];
			}
			$this->request->data['Billing']['discharge_date']=$this->DateFormat->formatDate2STD($this->request->data['Billing']['date'],Configure::read('date_format'));
			
			$billArrayData['Billing']['patient_id']=$this->request->data['Billing']['patient_id'];
			$billArrayData['Billing']['location_id']=$this->Session->read('locationid');			
			$billArrayData['Billing']['date']=$this->DateFormat->formatDate2STD($this->request->data['Billing']['date'],Configure::read('date_format'));
			$billArrayData['Billing']['amount']=$totalPayAmt;
			$billArrayData['Billing']['payment_category']='Finalbill';
			$billArrayData['Billing']['tariff_list_id']=$srArray;
			$billArrayData['Billing']['mode_of_payment']=$this->request->data['Billing']['payment_mode'];
			$billArrayData['Billing']['total_amount']=$totalBillAmt;
			$billArrayData['Billing']['amount_pending']=$totalBalAmt;
			$billArrayData['Billing']['discount']=$discount;
			$billArrayData['Billing']['amount_paid']=($totalAdvAmt+$totalPayAmt);
			$billArrayData['Billing']['created_by']=$this->Session->read('userid');
			$billArrayData['Billing']['bill_number']=$billNo;
			$billArrayData['Billing']['remark']=$this->request->data['Billing']['remark'];
			$billArrayData['Billing']['guarantor']=$this->request->data['Billing']['guarantor'];
			$billArrayData['Billing']['reason_of_discharge']=$this->request->data['Billing']['reason_of_discharge'];			
			$billArrayData['Billing']['reason_of_balance']=$this->request->data['Billing']['reason_of_balance'];
			$billArrayData['Billing']['discount_type']= $this->request->data['Billing']['discount_type'];
			$billArrayData['Billing']['discharge_date']=$this->DateFormat->formatDate2STD($this->request->data['Billing']['date'],Configure::read('date_format'));
			if($this->request->data['Billing']['payment_mode']=='Bank Deposite'){
				$billArrayData['Billing']['date'] = $this->DateFormat->formatDate2STD($this->request->data['Billing']['date'],Configure::read('date_format'));
				$billArrayData['Billing']['bank_deposite'] = $this->request->data['Billing']['bank_deposite'];
			}
			if($this->request->data['Billing']['payment_mode']=='Cheque' || $this->request->data['Billing']['payment_mode']=='Credit Card' || $this->request->data['Billing']['payment_mode']=='Debit Card'){
				$billArrayData['Billing']['cheque_date'] = $this->DateFormat->formatDate2STD($this->request->data['Billing']['cheque_date'],Configure::read('date_format'));
				$billArrayData['Billing']['bank_name'] = $this->request->data['Billing']['bank_name'];
			}
			
				
			if($this->request->data['Billing']['payment_mode']=='NEFT'){
				$billArrayData['Billing']['neft_date'] = $this->DateFormat->formatDate2STD($this->request->data['Billing']['neft_date'],Configure::read('date_format'));
				$billArrayData['Billing']['bank_name_neft'] = $this->request->data['Billing']['bank_name_neft'];
			}
			$billArrayData['Billing']['refund']=$this->request->data['Billing']['refund'];
			$billArrayData['Billing']['paid_to_patient']=$refund;
			$billArrayData['Billing']['account_number']=$this->request->data['Billing']['account_number'];
			$billArrayData['Billing']['check_credit_card_number']=$this->request->data['Billing']['check_credit_card_number'];
			$billArrayData['Billing']['is_card']=$this->request->data['Billing']['is_card'];
			$billArrayData['Billing']['patient_card']=$this->request->data['Billing']['patient_card'];
			
			
			if($this->Session->read('website.instance')=='kanpur')
		{
			$admissionType=$this->Patient->find('first',array('fields'=>array('Patient.admission_type'),
							'conditions'=>array('Patient.id'=>$this->request->data['Billing']['patient_id'])));
			$receiptId=$this->Billing->autoGeneratedReceiptID($admissionType['Patient']['admission_type']);				
			//$this->Billing->updateAll(array('Billing.receiptNo'=>"'".$receiptId."'"),array('Billing.id'=>$billId));
			$billArrayData['Billing']['receiptNo']=$receiptId;
		}
			$this->Billing->save($billArrayData['Billing']);		
			
			$billId=$this->Billing->id;;
			$patientId=$this->request->data['Billing']['patient_id'];
			$billArrayData['Billing']['id']=$billId;//for accouting purpose
				
			//If combine payment from pateint card  and other then update patient card
			if($this->Session->read('website.instance')!='kanpur'){
				if(!empty($this->request->data['Billing']['patient_card']) && $this->request->data['Billing']['is_card']=='1'){
					$patientCard=$totalPayAmt;
					//$patientCard=$this->request->data['Billing']['patient_card'];
					if($patientCard<$accId['Account']['card_balance']){
						$cardBalance=$accId['Account']['card_balance']-$patientCard;
							
					}else {
						$cardBalance=0;
						$patientCard=$accId['Account']['card_balance'];
					}
					//$cardBalance=$accId['Account']['card_balance']-$patientCard;
					//update patient card balance
					$this->Account->updateAll(array('card_balance'=>$cardBalance),array('id'=>$accId['Account']['id']));
					//insert payment entry in patientCard table
					$this->PatientCard->save(array(
							'person_id'=>$tariffStdData['Patient']['person_id'],
							'account_id'=>$accId['Account']['id'],
							'type'=>'Payment',
							'mode_type'=>'Patient Card',
							'amount'=>$patientCard,
							'billing_id'=>$billId,
							'bank_id'=>$this->Account->getAccountIdOnly(Configure::read('PatientCardLabel')),
							'created_by'=>$this->Session->read('userid'),
							'create_time'=>date('Y-m-d H:i:s')
					));
				}
			}
			$billArrayData['Billing']['patient_card']=$patientCard;
			
			//for accounting by amit jain
			if($tariffStdData['Patient']['admission_type']=='IPD'){
				if($this->params->query['singleBillPay']){
					$this->Billing->deleteRevokeJV($patientId);
				}
				$this->Billing->receiptVoucherCreate($billArrayData,$patientId);
				if($tariffStdData['Patient']['tariff_standard_id']==Configure::read('privateTariffId')){
					$this->Billing->jvMandatoryService($patientId);
					$this->Billing->finalDischargeJV($patientId,$this->params->query['singleBillPay']);
					$this->Billing->addFinalVoucherLogJV($billArrayData,$patientId);
				}
			}else{
				$this->Billing->addPartialPaymentJV($billArrayData,$patientId);
			}
			//EOF for accounting
			
			if($this->params->query['corporate']){
				//Saving data in final billing for corporate patient
				$this->loadModel('FinalBilling');
				$totalDiscount=$this->Billing->find('first',array('fields'=>array('Sum(Billing.discount) as discount'),
						'conditions'=>array('patient_id'=>$patient_id),
						'group'=>array('Billing.patient_id')));
				if(!empty($totalDiscount)){
					$billArrayData['Billing']['discount']=$totalDiscount[0]['discount'];
				}
				$data = $this->FinalBilling->find('first',array('conditions'=>array('location_id'=>$this->Session->read('locationid'),
						'patient_id'=>$this->request->data['Billing']['patient_id'])));
				if(count($data)>0){
					$this->FinalBilling->id = $data['FinalBilling']['id'];
				}
				unset($billArrayData['Billing']['id']); //this is set for accounting purpose at above
				$this->FinalBilling->save($billArrayData['Billing']);
			}
						
			if($this->request->data['Billing']['reason_of_discharge']!='' || !empty($this->request->data['Billing']['reason_of_discharge'])){
					$this->loadModel('FinalBilling');
					$totalDiscount=$this->Billing->find('first',array('fields'=>array('Sum(Billing.discount) as discount'),
							'conditions'=>array('patient_id'=>$patient_id),
							'group'=>array('Billing.patient_id')));
					if(!empty($totalDiscount)){
						$billArrayData['Billing']['discount']=$totalDiscount[0]['discount'];
					}
					$data = $this->FinalBilling->find('first',array('conditions'=>array('location_id'=>$this->Session->read('locationid'),
							'patient_id'=>$this->request->data['Billing']['patient_id'])));
					if(count($data)>0){
						$this->FinalBilling->id = $data['FinalBilling']['id'];
					}
					unset($billArrayData['Billing']['id']); //this is set for accounting purpose at above
					$this->FinalBilling->save($billArrayData['Billing']);

					/***BOF-Mahalaxmi-For SMS Sending*******/				
					
						$smsActiveFullPay=$this->Configuration->getConfigSmsValue('Full Bill');					
		 				if($smsActiveFullPay){
							$this->Person->bindModel(array(
							'belongsTo' => array(
									'Patient' =>array('foreignKey' => false,'conditions'=>array('Patient.person_id=Person.id')),
									'OptAppointment' =>array('foreignKey' => false,'conditions'=>array('OptAppointment.patient_id=Patient.id')),
									'Surgery' =>array('foreignKey' => false,'conditions'=>array('OptAppointment.surgery_id=Surgery.id')),
									/*'Consultant' =>array('foreignKey' => false,'conditions'=>array('Consultant.id=Patient.consultant_id')),*/
									'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
							)));
							
							$personDataId = $this->Person->Find('first',array('fields'=>array('Patient.sex','TariffStandard.name','Surgery.name','Person.mobile'/*,'Consultant.mobile','Consultant.first_name','Consultant.last_name'*/,'Patient.corporate_sublocation_id'),								'conditions'=>array('Person.id'=>$tariffStdData['Patient']['person_id'])));
						
						$getSexPatient=strtoUpper(substr($personDataId['Patient']['sex'],0,1));
						$getAgeResultSms=$this->General->convertYearsMonthsToDaysSeparate($tariffStdData['Patient']['age']);
							
							if($tariffStdData['Patient']['tariff_standard_id']==Configure::read('privateTariffId')){			
								if($totalPayAmt>0){							
									$getFinalSmsBal=$totalPayAmt+$totalBalAmt;					
									if(empty($getFinalSmsBal) || $getFinalSmsBal=='0'){
										$showMsgPatient= sprintf(Configure::read('full_payment_msg_withoutBal'),$totalPayAmt,Configure::read('hosp_details'));
									}else{
										$showMsgPatient= sprintf(Configure::read('full_payment_msg'),$totalPayAmt,$getFinalSmsBal,Configure::read('hosp_details'));
									}	
								
									$dataSmsReturn=$this->Message->sendToSms($showMsgPatient,$personDataId['Person']['mobile']);  //for send to patient						
								}
							}
						}//EOF if $smsActiveFullPay
					
					$smsActiveDischarge=$this->Configuration->getConfigSmsValue('Discharge Patient');					
	 				if($smsActiveDischarge){					
						$personDataId['Surgery']['name'] = str_replace ('&','and', $personDataId['Surgery']['name']);		
						if(empty($personDataId['Surgery']['name'])){
							$showMsgOwnerFinalBill= sprintf(Configure::read('owner_final_bill_withoutSurgery'),$personDataId['TariffStandard']['name'],$tariffStdData['Patient']['lookup_name'],$getSexPatient);						
							
						}else{							
							$showMsgOwnerFinalBill= sprintf(Configure::read('owner_final_bill_withSurgery'),$personDataId['TariffStandard']['name'],$tariffStdData['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms,$personDataId['Surgery']['name']);
						}
						
						
						$this->Message->sendToSms($showMsgOwnerFinalBill,Configure::read('owner_no')); //for discharged send Owner to patient discharged
					
						//$this->Patient->sendToSmsPatient($personDataId['Patient']['person_id'],'PayPaid');
						//$this->Patient->sendToSmsPatient($personDataId['Patient']['person_id'],'OwnerFinalBill');
					
							$this->TariffStandard->bindModel(array(
								'belongsTo'=>array(
								'CorporateSublocation'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array("CorporateSublocation.tariff_standard_id=TariffStandard.id"))
							)));
							
							$dataConsultantSms=$this->TariffStandard->find('first',array('fields'=>array('CorporateSublocation.mobile','CorporateSublocation.dr_name'),'conditions'=>array('CorporateSublocation.id'=>$personDataId['Patient']['corporate_sublocation_id'],'TariffStandard.name'=>array(Configure::read('WCL'),Configure::read('CGHS')))));
							$getDoctorRefferalName = unserialize($dataConsultantSms['CorporateSublocation']['dr_name']);
							$getRefferalDocMobileNo = unserialize($dataConsultantSms['CorporateSublocation']['mobile']);
							if(!empty($dataConsultantSms)){
								if($this->request->data['Billing']['reason_of_discharge']=="Death"){
									
									foreach($getDoctorRefferalName as $keyRef=>$getDoctorRefferalNames){
										
									$showMsgDischargeDeath= sprintf(Configure::read('DischargeDeathReferringDoc'),$personDataId['TariffStandard']['name'],$tariffStdData['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms,Configure::read('hosp_details')); 	/******After patient discharged to  get sms alert for Reffering Doc  ***/

									$getSmsExeResult=$this->Message->sendToSms($showMsgDischargeDeath,$getRefferalDocMobileNo[$keyRef]); //for discharged send 
									

									//$getResultexp=explode('-', $getSmsExeResult);
									//$getResultexp1 = substr($getResultexp['0'], 2);  // returns "cde"		
				
									
								
									if(trim($getSmsExeResult)==Configure::read('sms_confirmation')){
										
									$showMsgDischargeDeathReturntoAdmin= sprintf(Configure::read('DischargeDeathReferringDocReturn'),$getDoctorRefferalNames,$personDataId['TariffStandard']['name'],$tariffStdData['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms); 	/******After patient discharged to  get sms alert for Reffering Doc  ***/

									$this->Message->sendToSms($showMsgDischargeDeathReturntoAdmin,Configure::read('administrator_no')); //for discharged send 						

									$this->Message->sendToSms($showMsgDischargeDeathReturntoAdmin,Configure::read('owner_no')); //for discharged send to owner return sms
									}
								
									/*$this->Patient->sendToSmsPhysician($personDataId['Patient']['person_id'],'DischargeDeathReferringDoc');
									$this->Patient->sendToSmsPhysician($personDataId['Patient']['person_id'],'DischargeDeathReferringDocAdminReturn');
									$this->Patient->sendToSmsPhysician($personDataId['Patient']['person_id'],'DischargeDeathReferringDocOwnerReturn');*/
									}
								}else{
									foreach($getDoctorRefferalName as $keyRef=>$getDoctorRefferalNames){
										if($getSexPatient=='F'){	
											$showMsgDischargeOtherReason= sprintf(Configure::read('DischargeOtherReasonReferringDocFemale'),$personDataId['TariffStandard']['name'],$tariffStdData['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms,Configure::read('hosp_details')); 	/******After patient discharged to  get sms alert for Reffering Doc  ***/
										}else{
											$showMsgDischargeOtherReason= sprintf(Configure::read('DischargeOtherReasonReferringDoc'),$personDataId['TariffStandard']['name'],$tariffStdData['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms,Configure::read('hosp_details')); 	/******After patient discharged to  get sms alert for Reffering Doc  ***/
										}

									$getSmsExeResult=$this->Message->sendToSms($showMsgDischargeOtherReason,$getRefferalDocMobileNo[$keyRef]); //for discharged send 
									
									//$getResultexp=explode('-', $getSmsExeResult);
									//$getResultexp1 = substr($getResultexp['0'], 2);  // returns "cde"		
				
									
									
									if(trim($getSmsExeResult)==Configure::read('sms_confirmation')){
										if($getSexPatient=='F'){
											$showMsgDischargeOtherReturntoAdmin= sprintf(Configure::read('DischargeOtherReasonReferringDocReturnFemale'),$getDoctorRefferalNames,$personDataId['TariffStandard']['name'],$tariffStdData['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms); 	/******After patient discharged to  get sms alert for Reffering Doc  ***/
										}else{
											$showMsgDischargeOtherReturntoAdmin= sprintf(Configure::read('DischargeOtherReasonReferringDocReturn'),$getDoctorRefferalNames,$personDataId['TariffStandard']['name'],$tariffStdData['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms); 	/******After patient discharged to  get sms alert for Reffering Doc  ***/
										}
									$dataSmsre1=$this->Message->sendToSms($showMsgDischargeOtherReturntoAdmin,Configure::read('administrator_no')); //for discharged send 						
									
									$dataSmsre2=$this->Message->sendToSms($showMsgDischargeOtherReturntoAdmin,Configure::read('owner_no')); //for discharged send to owner return sms
									}
									
									/*$this->Patient->sendToSmsPhysician($personDataId['Patient']['person_id'],'DischargeOtherReasonReferringDoc');
									$this->Patient->sendToSmsPhysician($personDataId['Patient']['person_id'],'DischargeOtherReasonReferringDocAdminReturn');
									$this->Patient->sendToSmsPhysician($personDataId['Patient']['person_id'],'DischargeOtherReasonReferringDocOwnerReturn');*/
									}
								}
							}//Eof If $dataConsultantSms
					}//EOF if $smsActiveDischarge
					
					/***EOF-Mahalaxmi-For SMS Sending*******/
					
					$this->Patient->id = $this->request->data['Billing']['patient_id'];
					
					$this->Patient->save(array('is_discharge'=>1,
							'discharge_status'=>$this->request->data['Patient']['discharge_status'],
							'discharge_date'=>$this->request->data['Billing']['discharge_date']));//Save Details in Patient
					$bData = $this->Bed->find('first',array('conditions'=>array('patient_id'=>$this->request->data['Billing']['patient_id'],'location_id'=>$this->Session->read('locationid'))));

					$bedData=array();
					$bedData['Bed']['id'] = $bData['Bed']['id'];
					$bedData['Bed']['patient_id'] = 0;
					$bedData['Bed']['is_released'] = 1;
					$bedData['Bed']['released_date'] = '';
					$bedData['Bed']['modify_time'] = date('Y-m-d H:i:s');
					$bedData['Bed']['modified_by'] = $this->Session->read('userid');

					$this->Bed->save($bedData);
					//update already existed record which has the empty outdate
					$lastPatient = $this->WardPatient->find('first',array('fields'=>array('WardPatient.id','WardPatient.ward_id'),
							'conditions'=>array('out_date'=>'','patient_id'=>$this->request->data['Billing']['patient_id']),'order'=>'id Desc'));
					//EOF updating wardPatient outdate
					$this->WardPatient->updateAll(array('out_date'=>"'".$this->request->data['Billing']['discharge_date']."'",'is_discharge'=>1),
							array('id'=>$lastPatient['WardPatient']['id']));

					//Call to save ditails in Discharge details table.
					if(!empty($this->request->data['Billing']['patient_id']) AND $bedData['Bed']['id'] != ''){
						$dischargeDetails['patient_id'] = $this->request->data['Billing']['patient_id'];
						$dischargeDetails['location_id'] = $this->Session->read('locationid');
						$dischargeDetails['bed_id'] =  $bedData['Bed']['id'];
						$dischargeDetails['ward_id'] =  $lastPatient['WardPatient']['ward_id'];
						$dischargeDetails['discharge_starts_on'] = $this->request->data['Billing']['discharge_date'];
						$dischargeDetails['create_time'] = date('Y-m-d H:i:s');
						$this->DischargeDetail->save($dischargeDetails);
					}
					
				}elseif(!isset($this->request->data['Billing']['reason_of_discharge']) && 
						!empty($this->request->data['Billing']['discharge_date'])){ //BOF pankaj for OPD discharge
				/*	if(!empty($this->request->data['Billing']['appoinment_id'])){
						//close status of patient appoinment after final payment  --yashwant
						$this->loadModel('Appointment');
						$this->loadModel('Patient');
						$this->Appointment->updateAll(array('status'=>"'Closed'"),array('patient_id'=>$this->request->data['Billing']['patient_id'],
								'id'=>$this->request->data['Billing']['appoinment_id']));
						
						//EOF closed status
					}
					/*$this->loadModel('FinalBilling');
					$data = $this->FinalBilling->find('first',array('conditions'=>array('location_id'=>$this->Session->read('locationid'),
							'patient_id'=>$this->request->data['Billing']['patient_id'])));
					if(count($data)>0){
						$this->FinalBilling->id = $data['FinalBilling']['id'];
					}
					$this->FinalBilling->save($billArrayData['Billing']);
					
					/*$this->Patient->id = $this->request->data['Billing']['patient_id'];
					$this->Patient->save(array('is_discharge'=>1,'discharge_date'=>$this->request->data['Billing']['discharge_date']));//Save Details in Patient
					*/
						/*$this->Patient->updateAll(array('Patient.is_discharge'=>"1",
								'Patient.discharge_date'=>"'".$this->request->data['Billing']['discharge_date']."'",),
								array('Patient.id'=>$this->request->data['Billing']['patient_id']
						));*/
				}//EOF pankaj for OPD discharge
				
						
			// for saving service head wise data with billing id in respective tables
			$remainingDiscount=0;$consBill=array();
			$modified=date('Y-m-d H:i:s');
			
			if(!empty($this->request->data['Billing']['refund']) || !empty($this->request->data['Billing']['hrefund']) || !empty($this->request->data['Billing']['paid_to_patient'])){
				foreach($this->request->data['Billing'] as $billKey=>$billValue){
					foreach($billValue as $serviceKey=> $serviceValue){
						if(!empty($serviceValue['valChk'])){				
							if(($serviceCategory[$serviceValue['service_id']]==Configure::read('laboratoryservices'))||
									($serviceCategory[$serviceValue['service_id']]==Configure::read('radiologyservices'))||
									($serviceCategory[$serviceValue['service_id']]==Configure::read('surgeryservices')) ||
									($serviceCategory[$serviceValue['service_id']]==Configure::read('Consultant')) ||
									$serviceCategory[$serviceValue['service_id']]==Configure::read('Pharmacy')
									||$serviceCategory[$serviceValue['service_id']]==Configure::read('OtPharmacy') ){
								if($serviceCategory[$serviceValue['service_id']]==Configure::read('laboratoryservices')){
									$labKey='Laboratory';
									$model='LaboratoryTestOrder';
								}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('radiologyservices')){
									$labKey='Radiology';
									$model='RadiologyTestOrder';
								}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('surgeryservices')){
									$labKey='Surgery';
									$model='OptAppointment';
								}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('Consultant')){
									$labKey='Consultant';
									$model='ConsultantBilling';
								}elseif($serviceCategory[$serviceValue['service_id']]==Configure::read('Pharmacy')){
									$model='PharmacySalesBill';
								}elseif($serviceCategory[$serviceValue['service_id']]==Configure::read('OtPharmacy')){
									$model='OtPharmacySalesBill';
								}
							if($model=='ConsultantBilling'){
								$conBill=$this->$model->find('all',array('conditions'=>array("$model.id"=>$serviceValue['id'],"$model.patient_id"=>$patient_id)));
								$paidCon=$conBill['0']['ConsultantBilling']['amount'];
								foreach($conBill as $billUpdate){
									if(!empty($billUpdate['ConsultantBilling']['discount'])){
										$consBill[$billUpdate['ConsultantBilling']['billing_id']]=$consBill[$billUpdate['ConsultantBilling']['billing_id']]+$billUpdate['ConsultantBilling']['discount'];
									}
								}
								$this->$model->updateAll(array("$model.paid_amount"=>'0',"$model.discount"=>'0',"$model.billing_id"=>$billId,
										"$model.modify_time"=>"'$modified'"),
									array("$model.id"=>$serviceValue['id'],
											"$model.patient_id"=>$patient_id));
									
							}else if($model=='PharmacySalesBill'){
								
								$PharBill=$this->$model->find('all',array('fields'=>array("$model.id","$model.total","$model.paid_amnt","$model.discount",
										"$model.billing_id"),
										'conditions'=>array("$model.patient_id"=>$patient_id,"$model.is_deleted"=>'0')));
								foreach($PharBill as $billUpdate){
									/*if(!empty($billUpdate['PharmacySalesBill']['discount'])){
										$consBill[$billUpdate['PharmacySalesBill']['billing_id']]=$consBill[$billUpdate['PharmacySalesBill']['billing_id']]+$billUpdate['PharmacySalesBill']['discount'];
									}*/
									$pharIDArray[$billUpdate['PharmacySalesBill']['id']]=$billUpdate['PharmacySalesBill']['id'];
								}
								$this->$model->updateAll(array("$model.paid_amnt"=>'0',"$model.payment_mode"=>'credit',"$model.refund"=>'1',
										/*"$model.discount"=>'0',*/"$model.billing_id"=>$billId,"$model.modified_time"=>"'$modified'"),
										array("$model.id"=>$pharIDArray,"$model.patient_id"=>$patient_id));
							}else if($model=='OtPharmacySalesBill'){
								
								$otPharBill=$this->$model->find('all',array('fields'=>array("$model.id","$model.total","$model.paid_amount",
										"$model.discount","$model.billing_id"),
										'conditions'=>array("$model.patient_id"=>$patient_id,"$model.is_deleted"=>'0')));
								
								foreach($otPharBill as $billUpdate){
									/*if(!empty($billUpdate['OtPharmacySalesBill']['discount'])){
										$consBill[$billUpdate['OtPharmacySalesBill']['billing_id']]=$consBill[$billUpdate['OtPharmacySalesBill']['billing_id']]+$billUpdate['OtPharmacySalesBill']['discount'];
									}*/
									$otpharIDArray[$billUpdate['OtPharmacySalesBill']['id']]=$billUpdate['OtPharmacySalesBill']['id'];
								}
								$this->$model->updateAll(array("$model.paid_amount"=>'0',"$model.payment_mode"=>'credit',"$model.refund"=>'1',
										/*"$model.discount"=>'0',*/"$model.billing_id"=>$billId,"$model.modified_time"=>"'$modified'"),
										array("$model.id"=>$otpharIDArray,"$model.patient_id"=>$patient_id));
							}else if($model=='LaboratoryTestOrder' || $model=='RadiologyTestOrder'){
								$seraBill=$this->$model->find('all',array('fields'=>array("$model.id","$model.paid_amount","$model.discount",
										"$model.billing_id"),
										'conditions'=>array("$model.id"=>$serviceValue['id'],"$model.patient_id"=>$patient_id)));
								
								foreach($seraBill as $billUpdate){
									if(!empty($billUpdate[$model]['discount'])){
										$consBill[$billUpdate[$model]['billing_id']]=$consBill[$billUpdate[$model]['billing_id']]+$billUpdate[$model]['discount'];
									}
										
								}
								
								$this->$model->updateAll(array("$model.paid_amount"=>'0',"$model.discount"=>'0',"$model.billing_id"=>$billId,
										"$model.modified_bill_date"=>"'$modified'"),
										array("$model.id"=>$serviceValue['id'],"$model.patient_id"=>$patient_id));
								
							}else{
								
								$seraBill=$this->$model->find('all',array('fields'=>array("$model.id","$model.paid_amount","$model.discount",
										"$model.billing_id"),
										'conditions'=>array("$model.id"=>$serviceValue['id'],"$model.patient_id"=>$patient_id)));
								
								foreach($seraBill as $billUpdate){
									if(!empty($billUpdate[$model]['discount'])){
										$consBill[$billUpdate[$model]['billing_id']]=$consBill[$billUpdate[$model]['billing_id']]+$billUpdate[$model]['discount'];
									}
									
								}
								
								$this->$model->updateAll(array("$model.paid_amount"=>'0',"$model.discount"=>'0',"$model.billing_id"=>$billId,
										"$model.modify_time"=>"'$modified'"),
										array("$model.id"=>$serviceValue['id'],"$model.patient_id"=>$patient_id));
								}
						}else{							
							if($serviceCategory[$serviceValue['service_id']]==Configure::read('RoomTariff')){
								$this->loadModel('WardPatientService');
								
								$serbBill=$this->WardPatientService->find('all',array('fields'=>array("WardPatientService.id","WardPatientService.paid_amount","WardPatientService.discount","WardPatientService.billing_id"),
										'conditions'=>array("WardPatientService.ward_id"=>$serviceValue['id'],'WardPatientService.discount NOT'=>'0',"WardPatientService.patient_id"=>$patient_id),
										'group'=>array('WardPatientService.ward_id')));
								
								foreach($serbBill as $billUpdate){
									if(!empty($billUpdate['WardPatientService']['discount'])){
										$consBill[$billUpdate['WardPatientService']['billing_id']]=$consBill[$billUpdate['WardPatientService']['billing_id']]+$billUpdate['WardPatientService']['discount'];
									}
										
								}
								$this->WardPatientService->updateAll(array('WardPatientService.paid_amount'=>'0',
										'WardPatientService.discount'=>'0',
										"WardPatientService.modified_time"=>"'$modified'"),
										array('WardPatientService.patient_id'=>$this->request->data['Billing']['patient_id'],
												'WardPatientService.ward_id'=>$serviceValue['id']));
							}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('mandatoryservices')){							
								if($serviceValue['name']==Configure::read('DoctorsCharges') ||
										 $serviceValue['name']==Configure::read('NursingCharges')){
									$this->loadModel('WardPatientService');
										if($serviceValue['name']==Configure::read('DoctorsCharges')){
											$sercBill=$this->WardPatientService->find('all',array('fields'=>array("WardPatientService.id","WardPatientService.paid_amount","WardPatientService.doctor_discount","WardPatientService.billing_id"),
													'conditions'=>array('WardPatientService.doctor_discount NOT'=>'0',
															"WardPatientService.patient_id"=>$patient_id),
													'group'=>array('WardPatientService.ward_id')));
											
											foreach($sercBill as $billUpdate){
												if(!empty($billUpdate['WardPatientService']['doctor_discount'])){
													$consBill[$billUpdate['WardPatientService']['billing_id']]=$consBill[$billUpdate['WardPatientService']['billing_id']]+$billUpdate['WardPatientService']['doctor_discount'];
												}
											
											}
											$this->WardPatientService->updateAll(array('WardPatientService.doctor_paid_amount'=>'0',
													'WardPatientService.doctor_discount'=>'0','WardPatientService.billing_id'=>$billId,
													"WardPatientService.modified_time"=>"'$modified'"),
													array('WardPatientService.patient_id'=>$this->request->data['Billing']['patient_id'],
															'WardPatientService.doctor_paid_amount !='=>'0'));
										}else if($serviceValue['name']==Configure::read('NursingCharges')){
											$sercBill=$this->WardPatientService->find('all',array('fields'=>array("WardPatientService.id","WardPatientService.paid_amount","WardPatientService.nurse_discount","WardPatientService.billing_id"),
													'conditions'=>array('WardPatientService.nurse_discount NOT'=>'0',
															"WardPatientService.patient_id"=>$patient_id),
													'group'=>array('WardPatientService.ward_id')));
												
											foreach($sercBill as $billUpdate){
												if(!empty($billUpdate['WardPatientService']['nurse_discount'])){
													$consBill[$billUpdate['WardPatientService']['billing_id']]=$consBill[$billUpdate['WardPatientService']['billing_id']]+$billUpdate['WardPatientService']['nurse_discount'];
												}
													
											}
											$this->WardPatientService->updateAll(array('WardPatientService.nurse_paid_amount'=>'0',
													'WardPatientService.nurse_discount'=>'0','WardPatientService.billing_id'=>$billId,
													"WardPatientService.modified_time"=>"'$modified'"),
													array('WardPatientService.patient_id'=>$this->request->data['Billing']['patient_id'],
															'WardPatientService.nurse_paid_amount !='=>'0'));
										}
									
								}else if(!empty($serviceValue['service_bill_id'])){
									$chkServicePaid=$this->ServiceBill->find('all',array('fields'=>array('paid_amount','discount','billing_id'),
											'conditions'=>array("ServiceBill.id"=>$serviceValue['service_bill_id'],
													"ServiceBill.patient_id"=>$patient_id)));
									
										foreach($chkServicePaid as $billUpdate){
												if(!empty($billUpdate['ServiceBill']['discount'])){
													$consBill[$billUpdate['ServiceBill']['billing_id']]=$consBill[$billUpdate['ServiceBill']['billing_id']]+$billUpdate['ServiceBill']['discount'];
												}
													
											}
									
									$this->ServiceBill->updateAll(array('ServiceBill.paid_amount'=>'0','ServiceBill.discount'=>'0',
											'ServiceBill.billing_id'=>$billId,
											"ServiceBill.modified_time"=>"'$modified'"),
											array('ServiceBill.id'=>$serviceValue['service_bill_id'],'ServiceBill.patient_id'=>$patient_id));
								}
								
							}else if(!empty($serviceValue['service_bill_id'])){
								$chkServicePaidd=$this->ServiceBill->find('first',array(
										'conditions'=>array("ServiceBill.id"=>$serviceValue['service_bill_id'],
												"ServiceBill.patient_id"=>$patient_id)));
								
									foreach($chkServicePaidd as $billUpdate){
												if(!empty($billUpdate['ServiceBill']['discount'])){
													$consBill[$billUpdate['ServiceBill']['billing_id']]=$consBill[$billUpdate['ServiceBill']['billing_id']]+$billUpdate['ServiceBill']['discount'];
												}
													
											}
								$this->ServiceBill->updateAll(array('ServiceBill.paid_amount'=>'0','ServiceBill.discount'=>'0',
											'ServiceBill.billing_id'=>$billId,
											"ServiceBill.modified_time"=>"'$modified'"),
											array('ServiceBill.id'=>$serviceValue['service_bill_id'],'ServiceBill.patient_id'=>$patient_id));
							}
							
						}
					}
				}
			}
				
		}else{
			foreach($this->request->data['Billing'] as $billKey=>$billValue){
				foreach($billValue as $serviceKey=> $serviceValue){
					if(!empty($serviceValue['valChk'])){
						if(($serviceCategory[$serviceValue['service_id']]==Configure::read('laboratoryservices'))||
							($serviceCategory[$serviceValue['service_id']]==Configure::read('radiologyservices'))||
							($serviceCategory[$serviceValue['service_id']]==Configure::read('surgeryservices')) ||
							($serviceCategory[$serviceValue['service_id']]==Configure::read('Consultant')) ||
								$serviceCategory[$serviceValue['service_id']]==Configure::read('Pharmacy') ||
								$serviceCategory[$serviceValue['service_id']]==Configure::read('OtPharmacy') ){
								if($serviceCategory[$serviceValue['service_id']]==Configure::read('laboratoryservices')){
									$labKey='Laboratory';
									$model='LaboratoryTestOrder';
								}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('radiologyservices')){
									$labKey='Radiology';
									$model='RadiologyTestOrder';
								}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('surgeryservices')){
									$labKey='Surgery';
									$model='OptAppointment';
								}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('Consultant')){
									$labKey='Consultant';
									$model='ConsultantBilling';
								}elseif($serviceCategory[$serviceValue['service_id']]==Configure::read('Pharmacy')){
									$model='PharmacySalesBill';
								}elseif($serviceCategory[$serviceValue['service_id']]==Configure::read('OtPharmacy')){
									$model='OtPharmacySalesBill';
								}
							if($model=='ConsultantBilling'){
								$dic=0;
								$conBill=$this->$model->find('all',array('conditions'=>array("$model.id"=>$serviceValue['id'],
										"$model.paid_amount"=>array('0',''),
										"$model.patient_id"=>$patient_id)));
								$paidCon=$conBill['0']['ConsultantBilling']['amount'];
								if(!empty($serviceValue['discount'])){
									$dic=$serviceValue['discount'];
									$paidCon=$paidCon-$dic;
								}else{
									$dic=0;
								}
								$this->$model->updateAll(array("$model.paid_amount"=>$paidCon,"$model.discount"=>$dic,
										"$model.billing_id"=>$billId,"$model.modify_time"=>"'$modified'"),
									array("$model.id"=>$serviceValue['id'],
											"$model.patient_id"=>$patient_id,));
									
							}else if($model=='PharmacySalesBill'){
								$PharBill=$this->$model->find('all',array('fields'=>array("$model.id","$model.total",
										"$model.paid_amnt","$model.discount"),'conditions'=>array("$model.patient_id"=>$patient_id,
												"$model.is_deleted"=>'0',"$model.payment_mode"=>"credit")));
								foreach($PharBill as $pharRow){
									$pharmaPaid=$pharRow['PharmacySalesBill']['total']-$pharRow['PharmacySalesBill']['discount'];
										$this->$model->updateAll(array("$model.paid_amnt"=>$pharmaPaid,"$model.billing_id"=>$billId,
												"$model.modified_time"=>"'$modified'"),
											array("$model.id"=>$pharRow['PharmacySalesBill']['id'],'OR'=>array(array("$model.paid_amnt"=>'0'),array("$model.paid_amnt"=>NULL)),"$model.patient_id"=>$patient_id));
										//,"$model.discount"=>trim($serviceValue['discount']),
										/*if(!empty($serviceValue['discount'])){
											$this->$model->updateAll(array("$model.discount"=>trim($serviceValue['discount'])),
													array("$model.id"=>$pharRow['PharmacySalesBill']['id'],"$model.discount"=>'0',"$model.patient_id"=>$patient_id));
										}*/
								}
								//update billing id for refund...
								$this->InventoryPharmacySalesReturn->updateAll(array('InventoryPharmacySalesReturn.billing_id'=>$billId,
										"InventoryPharmacySalesReturn.modified_time"=>"'$modified'"),										
										array('InventoryPharmacySalesReturn.patient_id'=>$patient_id,'InventoryPharmacySalesReturn.billing_id'=>NULL));
							}else if($model=='OtPharmacySalesBill'){
								$otPharBill=$this->$model->find('all',array('fields'=>array("$model.id","$model.total",
										"$model.paid_amount","$model.discount"),
										'conditions'=>array("$model.patient_id"=>$patient_id,"$model.is_deleted"=>'0')));
								foreach($otPharBill as $otpharRow){
									$otpharmaPaid=$otpharRow['OtPharmacySalesBill']['total']-$otpharRow['OtPharmacySalesBill']['discount'];
										$this->$model->updateAll(array("$model.paid_amount"=>$otpharmaPaid,
												"$model.modified_time"=>"'$modified'",
												"$model.billing_id"=>$billId),
											array("$model.id"=>$otpharRow['OtPharmacySalesBill']['id'],'OR'=>array(array("$model.paid_amount"=>'0'),array("$model.paid_amount"=>NULL)),"$model.patient_id"=>$patient_id));
									
								}
								$this->OtPharmacySalesReturn->updateAll(array('OtPharmacySalesReturn.billing_id'=>$billId,
										"OtPharmacySalesReturn.modified_time"=>"'$modified'"),
										array('OtPharmacySalesReturn.patient_id'=>$patient_id,'OtPharmacySalesReturn.billing_id'=>NULL));
							}else if($model=='LaboratoryTestOrder' || $model=='RadiologyTestOrder'){
								$dic=0;
								$chkPaid=$this->$model->find('first',array('fields'=>array('paid_amount'),
										'conditions'=>array("$model.id"=>$serviceValue['id'],"$model.patient_id"=>$patient_id)));
								$paidAmt=/*$chkPaid[$model]['paid_amount']+*/$serviceValue['amount'];
								if(!empty($serviceValue['discount'])){
									$dic=$serviceValue['discount'];
									$paidAmt=$paidAmt-$dic;
								}else{
									$dic=0;
								}
								$this->$model->updateAll(array("$model.paid_amount"=>$paidAmt,"$model.discount"=>$dic,
										"$model.billing_id"=>$billId,"$model.modified_bill_date"=>"'$modified'"),
										array("$model.id"=>$serviceValue['id'],"$model.patient_id"=>$patient_id));
								
								
							}else{
								$dic=0;
								$chkPaid=$this->$model->find('first',array('fields'=>array('paid_amount'),
										'conditions'=>array("$model.id"=>$serviceValue['id'],"$model.patient_id"=>$patient_id)));
								$paidAmt=/*$chkPaid[$model]['paid_amount']+*/$serviceValue['amount'];
								if(!empty($serviceValue['discount'])){
									$dic=$serviceValue['discount'];
									$paidAmt=$paidAmt-$dic;
								}else{
									$dic=0;
								}
								$this->$model->updateAll(array("$model.paid_amount"=>$paidAmt,"$model.discount"=>$dic,
										"$model.billing_id"=>$billId,"$model.modify_time"=>"'$modified'"),
									array("$model.id"=>$serviceValue['id'],"$model.patient_id"=>$patient_id));
									}
							$paidAmt=0;
								
						}else{
							$dic=0;						
							if($serviceCategory[$serviceValue['service_id']]==Configure::read('RoomTariff')){
								$this->loadModel('WardPatientService');
								$wardBill=$this->WardPatientService->find('all',array('fields'=>array("WardPatientService.id","WardPatientService.amount",
										"WardPatientService.paid_amount","WardPatientService.discount"),
										'conditions'=>array("WardPatientService.patient_id"=>$patient_id,
												"WardPatientService.is_deleted"=>'0')));
								foreach($wardBill as $wardRow){
									$wardPaid=$wardRow['WardPatientService']['amount']-$wardRow['WardPatientService']['discount'];
									$this->WardPatientService->updateAll(array("WardPatientService.paid_amount"=>$wardPaid,
											"WardPatientService.billing_id"=>$billId,
											"WardPatientService.modified_time"=>"'$modified'"),
											array("WardPatientService.id"=>$wardRow['WardPatientService']['id'],'OR'=>array(array("WardPatientService.paid_amount"=>'0'),array("WardPatientService.paid_amount"=>NULL)),"WardPatientService.patient_id"=>$patient_id));
								}
								/*if(!empty($serviceValue['discount'])){
									$dic=round($serviceValue['discount']);
								}else{
									$dic=0;
								}
								$this->WardPatientService->updateAll(array('WardPatientService.paid_amount'=>round($serviceValue['rate']-$dic),
										'WardPatientService.discount'=>$dic,'WardPatientService.billing_id'=>$billId),
										array('WardPatientService.patient_id'=>$this->request->data['Billing']['patient_id'],
												'WardPatientService.ward_id'=>$serviceValue['id']));*/
							}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('mandatoryservices')){
							//debug($serviceValue['name']);exit;
							if($serviceValue['name']==Configure::read('DoctorsCharges') ||
									 $serviceValue['name']==Configure::read('NursingCharges')){
								
								if($serviceValue['paid_amount']<$serviceValue['amount']){
									$this->loadModel('WardPatientService');
									if($serviceValue['name']==Configure::read('DoctorsCharges')){$dic=0;
										if(!empty($serviceValue['discount'])){
											$dic=$serviceValue['discount'];
										}else{
											$dic=0;
										}
										$this->WardPatientService->updateAll(array('WardPatientService.doctor_paid_amount'=>$serviceValue['rate']-$dic,
												'WardPatientService.doctor_discount'=>$dic,'WardPatientService.billing_id'=>$billId,
												"WardPatientService.modified_time"=>"'$modified'"),
												array('WardPatientService.patient_id'=>$this->request->data['Billing']['patient_id'],
														'WardPatientService.doctor_paid_amount'=>'0'));
									}else if($serviceValue['name']==Configure::read('NursingCharges')){
										$dic=0;
										if(!empty($serviceValue['discount'])){
											$dic=$serviceValue['discount'];
										}else{
											$dic=0;
										}
										$this->WardPatientService->updateAll(array('WardPatientService.nurse_paid_amount'=>$serviceValue['rate']-$dic,
												'WardPatientService.nurse_discount'=>$dic,'WardPatientService.billing_id'=>$billId,
												"WardPatientService.modified_time"=>"'$modified'"),
												array('WardPatientService.patient_id'=>$this->request->data['Billing']['patient_id'],
														'WardPatientService.nurse_paid_amount'=>'0'));
									}
								}
							}else{
								if(empty($serviceValue['paid_amount']) || $serviceValue['paid_amount']<=0){
									if(!empty($serviceValue['service_bill_id'])){
										$dic=0;
										if(!empty($serviceValue['discount'])){
											$dic=$serviceValue['discount'];
										}else{
											$dic=0;
										}
										$chkServicePaid=$this->ServiceBill->find('first',array('fields'=>array('paid_amount'),
												'conditions'=>array('ServiceBill.id'=>$serviceValue['service_bill_id'],
														'ServiceBill.patient_id'=>$patient_id)));
										$payManServiceAmt=/*$chkServicePaid['ServiceBill']['paid_amount']+*/$serviceValue['amount'];
										
										$this->ServiceBill->updateAll(array('ServiceBill.paid_amount'=>$payManServiceAmt-$dic,
												'ServiceBill.discount'=>$dic,'ServiceBill.billing_id'=>$billId,
												"ServiceBill.modified_time"=>"'$modified'"),
												array('ServiceBill.id'=>$serviceValue['service_bill_id'],'ServiceBill.patient_id'=>$patient_id));
									}
									$payManServiceAmt=0;//reinitialise
								}
							}
						}else if(!empty($serviceValue['service_bill_id'])){
								$chkServicePaidd=$this->ServiceBill->find('first',array('conditions'=>array(
										"ServiceBill.id"=>$serviceValue['service_bill_id'],"ServiceBill.patient_id"=>$patient_id)));
								$payServiceAmt=/*$chkServicePaidd['ServiceBill']['paid_amount']+*/$serviceValue['amount'];
								$dic=0;
								if(!empty($serviceValue['discount'])){
									$dic=$serviceValue['discount'];
								}else{
									$dic=0;
								}					
								/*$this->ServiceBill->updateAll(array('ServiceBill.paid_amount'=>$payServiceAmt,
										'ServiceBill.discount'=>$dic,
										'ServiceBill.billing_id'=>$billId),
										array('ServiceBill.tariff_list_id'=>$chkServicePaidd['ServiceBill']['tariff_list_id'],'ServiceBill.patient_id'=>$patient_id));*/
								
								$this->ServiceBill->updateAll(array('ServiceBill.paid_amount'=>$payServiceAmt-$dic,'ServiceBill.discount'=>$dic,
										'ServiceBill.billing_id'=>$billId,
										"ServiceBill.modified_time"=>"'$modified'"),
										array('ServiceBill.id'=>$serviceValue['service_bill_id'],'ServiceBill.patient_id'=>$patient_id));
							}
							$payServiceAmt=0;
					}
					
					}
				}//EOF inner foreach
			
			}//EOF outer foreach
			
			
		}// EOF else condition of not refund 
		$disData='';
		foreach($consBill as $billKey=>$billDis){
			$disData['discount']=$disData['discount']+$billDis;
			
		}
		if(!empty($disData)){
			$this->Billing->updateAll(array('Billing.discount'=>"'".-($disData['discount'])."'"),array('Billing.id'=>$billId));
		}
		
			
			if($this->Session->read('website.instance')=='vadodara'){ 
				echo $this->redirect($this->referer().'&print=print&billId='.$billId) ;
			}else{
				echo '<script> parent.location.reload(); parent.jQuery.fancybox.close(); </script>';
			} 
		}	
		//Configuration for patient card button "ONLY FOR VADODARA INSTANCE" -- Pooja
		$configInstance=$this->Session->read('website.instance');
		$this->set('configInstance',$configInstance);
		//EOF Configuration		
		$this->loadModel('Account');
		$this->Account->bindModel(array(
				'belongsTo' => array(
						'AccountingGroup'=>array('foreignKey' => false,'conditions'=>array('AccountingGroup.id=Account.accounting_group_id')),
				)),false);
		$bankData =$this->Account->find('all',array('fields'=>array('id','name'),'conditions'=>array('Account.is_deleted'=>'0',
				'AccountingGroup.name'=>Configure::read('bankLabel'))));
		$bankDataArray = array();
		foreach($bankData as $bank){
			$bankDataArray[$bank['Account']['id']] = $bank['Account']['name'];
		}
		$this->set('bankData',$bankDataArray);
		$this->generateReceipt($patient_id);
		
		$laboratoryTestOrderData  = $this->labDetails($patient_id);//lab data
		$this->set(array('labDetail'=>$laboratoryTestOrderData));
		$radTestOrderData  = $this->radDetails($patient_id);//radiology data
		$this->set(array('radiology'=>$radTestOrderData));
		$this->Patient->unBindModel(array('hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));				
		$this->set('serviceCategory',$serviceCategory);
		$this->loadModel('TariffList');
		$tariffDocListId=$this->TariffList->getServiceIdByName(Configure::read('DoctorsCharges'));//get tariff list id
		$tariffNurseListId=$this->TariffList->getServiceIdByName(Configure::read('NursingCharges'));//get tariff list id
		$this->set(array('tariffDoctorId'=>$tariffDocListId,'tariffNurseListId'=>$tariffNurseListId));	
		
		//Billing paid amount Calculations
		$this->loadModel('Billing');
		$this->loadModel('Configuration');
		$pharmConfig=$this->Configuration->getPharmacyServiceType();// to get pharmacy service type
		//$otPharmacyid=$this->ServiceCategory->getOtPharmacyId();//payment category id for ot pharmacy
		
		foreach($serviceCategory as $key=>$chkPharmcyGroup){
			$pharmacyGroupArray[$key]=$chkPharmcyGroup;
		}
		if(!in_array("Pharmacy", $pharmacyGroupArray)){
			$pharmConfig['addChargesInInvoice']='no';
		}

		// url flag to show pharmacy charges -- Pooja
		if($this->params->query['showPhar']){
			$pharmConfig['addChargesInInvoice']='yes';
		}
		
		/**For hope instance OPD patient show pharmacy irrespective of configuration - Pooja**/
		if($this->Session->read('website.instance')=='hope' && ($tariffStdData['Patient']['admission_type']=='OPD')){
			$pharmConfig['addChargesInInvoice']='yes';
		}
		/*********EOF hope Condition**************/
		if($tariffStdData['Patient']['tariff_standard_id']!=$pvtTariffId){
			$pharmConfig['addChargesInInvoice']='yes';
		}
		if($pharmConfig['addChargesInInvoice']=='yes'){
			$billDetail=$this->Billing->find('all',array('fields'=>array('Sum(Billing.discount) as discount',
					'Sum(Billing.amount) as amount','Sum(Billing.paid_to_patient) as refund'),
				'conditions'=>array('Billing.patient_id'=>$patient_id,'Billing.payment_category NOT'=>array('advance', 'CorporateAdvance', 'TDS'))));
		}else if($pharmConfig['addChargesInInvoice']=='no'){
			$this->loadModel('ServiceCategory');
					$pharmacyCategoryId=$this->ServiceCategory->getPharmacyId();//in case need of pharmacy category ID
					$billDetail=$this->Billing->find('all',array('fields'=>array('Sum(Billing.discount) as discount',
							'Sum(Billing.amount) as amount','Sum(Billing.paid_to_patient) as refund'),
				'conditions'=>array('Billing.patient_id'=>$patient_id,'AND'=>array(array('Billing.payment_category !='=>$pharmacyCategoryId),array('Billing.payment_category NOT'=>array('advance', 'CorporateAdvance', 'TDS') )))));					
		}
		$this->set('billDetail',$billDetail);
		$this->set('pharmConfig',$pharmConfig);
		//EOF Paid billing
		
		
		//echo '<pre>';print_r($billDetail);		
		$authPerson =$this->User->find('all',array('fields'=>array('id','CONCAT(first_name," ",last_name) as lookup_name'),
				'conditions'=>array('User.is_authorized_for_discount'=>'1','User.is_deleted'=>'0','User.is_active'=>'1'/*,
						'User.location_id'=>$this->Session->read('locationid')*/)));
			
		foreach($authPerson as $authPerson){
			$key=$authPerson["User"]["id"];
			$authPersonArr[$key]=$authPerson["0"]["lookup_name"];
		}
		//debug($authPersonArr);
		$this->set('authPerson',$authPersonArr);
		
		$this->loadModel('User');
		
		$guarantor =$this->User->find('all',array('fields'=>array('id','CONCAT(first_name," ",last_name) as lookup_name'),
				'conditions'=>array('User.is_guarantor'=>'1','User.is_deleted'=>'0','User.is_active'=>'1',
						'User.location_id'=>$this->Session->read('locationid'))));
		foreach($guarantor as $guarantor){
			$key=$guarantor["User"]["id"];
			$guarantorArr[$key]=$guarantor["0"]["lookup_name"];
		}
		$this->set('guarantor',$guarantorArr);
		
		/*
		 * doctor and nursing charges for mandatory servises
		*/
		
		if($tariffStdData['Patient']['admission_type']=='IPD'){
			$hospitalType = $this->Session->read('hospitaltype');
			//new ward charges
			$wardCharges=$this->wardCharges($patient_id);	//echo '<pre>';print_r($wardCharges);
			$this->set('wardNew',$wardCharges);
			//
			$totalWardDays=count($wardCharges['day']); //total no of days
			$this->set('totalWardDays',$totalWardDays);
			
			if($tariffStdData['Patient']['tariff_standard_id']==$pvtTariffId){//pooja
				$doctorCharges = $this->Billing->getDoctorCharges($totalWardDays,$hospitalType,$tariffStdData['Patient']['tariff_standard_id'],
						$tariffStdData['Patient']['admission_type'],
						$tariffStdData['Patient']['treatment_type']);
				$nursingCharges = $this->Billing->getNursingCharges($totalWardDays,$hospitalType,$tariffStdData['Patient']['tariff_standard_id']);
				foreach($wardCharges['day'] as $docNurse){
					$doctorPaidCharges=$doctorPaidCharges+$docNurse['doctor_paid_amount'];
					if(empty($doctorDiscount))
					$doctorDiscount=$docNurse['doctor_discount'];
					$nursePaidCharges=$nursePaidCharges+$docNurse['nurse_paid_amount'];
					if(empty($nurseDiscount))
					$nurseDiscount=$docNurse['nurse_discount'];
				}
				$this->set(array('doctorCharges'=>$doctorCharges,'nursingCharges'=>$nursingCharges,
						'doctorPaidCharges'=>$doctorPaidCharges,'nursePaidCharges'=>$nursePaidCharges,
						'nurseDiscount'=>$nurseDiscount,'doctorDiscount'=>$doctorDiscount));
			}			
		}
		
		$pharmacyPaidData = $this->PharmacySalesBill->find('all',array('fields'=>array('Sum(PharmacySalesBill.total) as total','Sum(PharmacySalesBill.paid_amnt) as paid_amount','sum(PharmacySalesBill.discount) as discount'),'conditions'=>array('PharmacySalesBill.patient_id'=>$patient_id,'PharmacySalesBill.is_deleted'=>'0',
				)));
		$pharmacyreturnData = $this->InventoryPharmacySalesReturn->find('all',
				array('fields'=>array('Sum(InventoryPharmacySalesReturn.total) as total',
						'Sum(InventoryPharmacySalesReturn.discount) as total_discount'),
						'conditions'=>array('InventoryPharmacySalesReturn.patient_id'=>$patient_id,
								'InventoryPharmacySalesReturn.is_deleted'=>'0',
		)));
		
		
		$this->loadModel('OtPharmacySalesBill');
		$this->loadModel('OtPharmacySalesReturn');
		
		$oTpharmacyPaidData = $this->OtPharmacySalesBill->find('all',array('fields'=>array('Sum(OtPharmacySalesBill.total) as total','Sum(OtPharmacySalesBill.paid_amount) as paid_amount','sum(OtPharmacySalesBill.discount) as discount'),'conditions'=>array('OtPharmacySalesBill.patient_id'=>$patient_id,'OtPharmacySalesBill.is_deleted'=>'0',
		)));
		$oTpharmacyReturnData = $this->OtPharmacySalesReturn->find('all',array(
				'fields'=>array('Sum(OtPharmacySalesReturn.total) as total','Sum(OtPharmacySalesReturn.discount) as total_discount'),
				'conditions'=>array('OtPharmacySalesReturn.patient_id'=>$patient_id,'OtPharmacySalesReturn.is_deleted'=>'0',
		)));
		
		$pharmacyReturnPaid=$this->Billing->returnPaidAmount($patient_id);
		$this->set('pharmacyReturnPaid',$pharmacyReturnPaid);
		
		$this->set('pharmacyPaidData',$pharmacyPaidData);
		$this->set('pharmacyreturnData',$pharmacyreturnData);
		$this->set('oTpharmacyPaidData',$oTpharmacyPaidData);
		$this->set('oTpharmacyReturnData',$oTpharmacyReturnData);

	}

	/**
	 *function for  generating bill no. for each payment
	 *@params patient_id and record_id of billing.
	 *By Yashwant
	 *@Return dynamic bill no.
	 */
	public function generateBillNoPerPay($id,$recId){
		//$this->uses=array('FinalBilling');
		$this->loadModel('Billing');
		$monthArray = array('A','B','C','D','E','F','G','H','I','J','K','L');
		$count = $this->Billing->find('count',array('conditions'=>array('location_id'=>$this->Session->read('locationid'),'is_deleted'=>'0',
				'date'=>date('Y-m-d'))));

		$billNo = 'BL'.date('y').'-'.$monthArray[(date('n')-1)].date('d').'/'.($count+1).'/'.$recId;
		return $billNo;
	}

	/**
	 * packageBill
	 * @author Gaurav Chauriya
	 * function to create invoice for package bill (private patient only)
	 */
	public function packageBill ($patientId = null){
		$this->layout = 'advance_ajax';
		$this->uses = array('Patient','EstimateConsultantBilling');
		/**
		 * header information BOF
		*/
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment'),
						'TariffStandard' =>array('foreignKey'=>'tariff_standard_id'),
						'TariffList' =>array('foreignKey'=>'treatment_type'),
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )))
				,'hasOne'=>array(
						'Diagnosis'=>array('foreignKey'=>'patient_id','fields'=>array('Diagnosis.final_diagnosis')),
						'EstimateConsultantBilling'=>array('foreignKey'=>false,'conditions'=>array('EstimateConsultantBilling.patient_id=Patient.is_packaged' ))
				)));
		$patient_details  = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$patientId)));
		$this->set(array('patient'=>$patient_details,'billNumber'=>$this->generateBillNo()));
		/** EOF Header info */
		$patient_details['EstimateConsultantBilling']['discount'] = unserialize($patient_details['EstimateConsultantBilling']['discount']);
		$packageData = $patient_details['EstimateConsultantBilling'];
		//debug($packageData);
		$chargeLabels = array('surgeon_fees','accomodation_charge','implant_charge','anaesthesist_charge','','','','','','','','');
		//$packageAmount = $this->EstimateConsultantBilling->find('first');
	}



	public function advanced_billing($patient_id=null,$type=null)
	{
	 
		$this->layout = 'advance' ;
		$this->uses = array('RadiologyTestOrder','LaboratoryTestOrder','Patient','TariffStandard','Surgery',
				'DoctorProfile','Diagnosis','Ward','Billing','FinalBilling','OptAppointment','PharmacySalesBill',
				'LabTestPayment','RadiologyTestPayment','Bed','Room','Consultant','User','ServiceBill','TariffList',
				'TariffAmount','PharmacyItem','ServiceCategory','PatientCovidPackage');

		$this->Patient->unbindModel(array('hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));

		$this->Bed->bindModel(
				array('belongsTo' => array(
						'Room'=>array('foreignKey'=>'room_id','type'=>'left'
						),
						'Ward'=>array('type'=>'inner','foreignKey'=>false,'conditions'=>array('Ward.id=Room.ward_id')),
						'Patient'=>array('foreignKey'=>false,'conditions'=>array('Bed.patient_id=Patient.id',
								'Patient.is_discharge'=>'0','Patient.is_deleted'=>'0','Patient.admission_type'=>"IPD")),
						'TariffStandard' => array('foreignKey'=>false,
								'conditions'=> array('TariffStandard.id=Patient.tariff_standard_id'),
						), //* for all the fields of patient
						'Diagnosis' => array('foreignKey'=>false,
								'conditions'=>array('Patient.id=Diagnosis.patient_id'),
						),
							
						'ServiceBill' => array('foreignKey'=>false,
						 'conditions'=>array('Patient.id=ServiceBill.patient_id'),
								'fields'=>array('ServiceBill.tariff_list_id')),
							
						/*'TariffList' => array('foreignKey'=>false,
						 'conditions'=>array('ServiceBill.tariff_list_id=TariffList.id'),
								'fields'=>array('TariffList.name','cghs_non_nabh')),*/
							
						'Person'=>array('foreignKey'=>false,'type'=>'inner',
								'conditions'=>array('Person.id=Patient.person_id'),
						),
						'User'=>array('foreignKey'=>false,'conditions'=>array('User.id=Patient.doctor_id'),
						),

						'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.Patient_id=Patient.id'),
						),
						/*'Billing'=>array('foreignKey'=>false,'conditions'=>array('Billing.Patient_id=Patient.id'),
						 ),*/
						'PharmacySalesBill'=>array('foreignKey'=>false,'conditions'=>array('PharmacySalesBill.patient_id=Patient.id'),
						),
							
				),'hasMany'=>array('ConsultantBilling'=>array('foreignKey'=>'patient_id',
						'fields'=>array('ConsultantBilling.amount')))));
		$cond = ''; 
		
		if(!empty($this->request->query['patient_id']) && !isset($this->request->query['format'])){
			$patientID[] = $this->request->query['patient_id'];
			$cond['Patient.id'] = $patientID;
		}
        		if (!empty($this->request->query['dialysis']) && $this->request->query['dialysis'] == '659') {
            $cond['User.department_id'] = '659';
            // debug($cond);exit;// Adjust 'treatment_type' to match your database field
        }
        if (!empty($this->request->query['remove_dialysis']) && $this->request->query['remove_dialysis'] == '659') {
    $cond['User.department_id !='] = '659'; // Exclude Dialysis from the results
}

		$result = $this->Bed->find('all',array('fields'=> array('Bed.*','Room.*','Ward.*','TariffStandard.name','TariffStandard.id','Patient.id', 'Patient.lookup_name','Patient.remark','Patient.sms_sent','Patient.advance_sms_sent_date_time', 'Patient.form_received_on','Patient.admission_id' ,'Patient.create_time','Patient.patient_id','Patient.is_packaged','Patient.person_id',
				'Patient.tariff_standard_id','Patient.likely_discharge_date','Patient.diagnosis_txt','Diagnosis.final_diagnosis','Diagnosis.id','Person.district','Person.package_date','ServiceBill.date',
			    'User.first_name','User.last_name','FinalBilling.total_amount','PharmacySalesBill.total','Person.mobile','Person.vip_chk','Diagnosis.family_tit_bit','Diagnosis.family_tit_bit1','Diagnosis.family_tit_bit2'),
				'conditions'=>array('Ward.is_deleted'=>0,$cond,'Ward.location_id'=>$this->Session->read('locationid')),
				'order'=>array('Ward.sort_order','Bed.id'),'group'=>array('Bed.id')));
				// debug()
		$this->set('results', $result); 
		$package_date = $this->ServiceBill->find('all', array(
            'fields' => array('ServiceBill.id', 'ServiceBill.patient_id', 'ServiceBill.date'),
            'conditions' => array('ServiceBill.service_id' => 32),
        ));
        
        $today = date('Y-m-d'); // आज की तारीख
        $dates = [];
        foreach ($package_date as $bill) {
            if (!empty($bill['ServiceBill']['patient_id'])) {
                $service_date = date('Y-m-d', strtotime($bill['ServiceBill']['date'])); // तारीख को फ़ॉर्मेट करें
                $diff = (strtotime($today) - strtotime($service_date)) / (60 * 60 * 24); // दिनों का अंतर
                $day_label = ($diff >= 0) ? ($diff + 1) . 'th Day' : 'Future Date'; // दिन का लेबल
                $dates[$bill['ServiceBill']['patient_id']][] = [
                    'date' => $bill['ServiceBill']['date'],
                    'day_label' => $day_label,
                ];
            }
        }
        $this->set('dates', $dates);

$this->set('formatted_dates', $formatted_dates);
          $this->set('dates', $dates);
		if(empty($this->request->query['patient_id'])){
			foreach ($result as $key => $value)
			{
				$patientID[] = $value['Patient']['id'];
			}
			$patientID=array_filter($patientID);
		}   

		/* foreach ($result as $key => $value)
		{
			$patientID[] = $result[$key]['Patient']['id'] ;
		}
		$patientID=array_filter($patientID); */

		$this->set('patientID',$patientID);
		$add = $this->Billing->find('all',array('conditions'=>array('patient_id'=>$patientID,'is_deleted'=>'0',
				'location_id'=>$this->Session->read('locationid'))));
		$this->set('advancePayment',$add);
		$this->loadModel('OptAppointment');
		$this->OptAppointment->unbindModel(array(
				'belongsTo' => array('Initial','Patient','Location','Opt','OptTable','Surgery','SurgerySubcategory','Doctor','DoctorProfile')));
			
		$this->OptAppointment->bindModel(array(
				'belongsTo' => array(
						'Surgery'=>array('foreignKey'=>'surgery_id'),
				)));
			
		$surgeriesData = $this->OptAppointment->find('all',array(
				'fields'=>array('OptAppointment.procedure_complete','OptAppointment.implant_description','Surgery.name','OptAppointment.patient_id', 'Surgery.charges',
						'OptAppointment.surgery_cost','OptAppointment.anaesthesia_cost','OptAppointment.ot_charges'),
				'conditions'=>array('OptAppointment.patient_id'=>$patientID,'OptAppointment.is_deleted'=>0,
						'OptAppointment.location_id'=>$this->Session->read('locationid'))));
		$this->set('surgeriesData',$surgeriesData);
// debug($surgeriesData);exit;
		/*$this->loadModel('ServiceBill');
		 $serviceId=$this->ServiceCategory->find('first',array('fields'=>array('id'),'conditions'=>array('ServiceCategory.name LIKE'=>Configure::read('mandatoryservices'))));
		$regId=$this->ServiceCategory->find('first',array('fields'=>array('id'),'conditions'=>array('ServiceCategory.name LIKE'=>Configure::read('RegistrationCharges'))));
		$clinicalId=$this->ServiceCategory->find('first',array('fields'=>array('id'),'conditions'=>array('ServiceCategory.name LIKE'=>Configure::read('clinicalservices'))));

		$this->ServiceBill->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>'patient_id'),
						"ServiceCategory"=>array('foreignKey'=>'service_id','type'=>'RIGHT'),
						"ServiceSubCategory"=>array('foreignKey'=>'sub_service_id'),
						'TariffList'=>array('foreignKey'=>'tariff_list_id'),
						'TariffAmount'=>array('foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=ServiceBill.tariff_list_id','TariffAmount.tariff_standard_id'))
				)));
			
		$servicesData =$this->ServiceBill->find('all',array('group'=>array('ServiceBill.id'),'fields'=>array('TariffAmount.*,ServiceCategory.*,ServiceSubCategory.*,
				TariffList.*,ServiceBill.*,Patient.lookup_name,Patient.is_discharge,Patient.tariff_standard_id,Patient.form_received_on'),'conditions'=>array('ServiceBill.patient_id'=>$patientID,
						/*'ServiceBill.service_id'=>array($serviceId['ServiceCategory']['id'],$regId['ServiceCategory']['id'],$clinicalId['ServiceCategory']['id']))));
			
		/*$this->set('servicesData',$servicesData);*/
		/*
		 * doctor and nursing charges for mandatory servises
		*/
		foreach($result as $tariff){
			$tariffStandardId[]	=$tariff['Patient']['tariff_standard_id'];
		}
			
		$hospitalType = $this->Session->read('hospitaltype');
		foreach($result as $tariffDays){
			#$bedCharges[$tariffDays['Patient']['id']] = $this->getDay2DayCharges($tariffDays['Patient']['id'],$tariffDays['Patient']['tariff_standard_id']);
			$bedCharges[$tariffDays['Patient']['id']] = $this->wardCharges($tariffDays['Patient']['id']);
			$totalWardDays=count($bedCharges[$tariffDays['Patient']['id']]['day']); //total no of days
			if($totalWardDays==0){
				$totalWardDays=1;
			}
			//debug($tariffDays['Patient']['id'].'--'.$tariffDays['Patient']['tariff_standard_id']);
			$doctorCharges[$tariffDays['Patient']['id']] = $this->Billing->getDoctorCharges($totalWardDays,$hospitalType,$tariffDays['Patient']['tariff_standard_id'],'IPD');
			$nursingCharges[$tariffDays['Patient']['id']] = $this->Billing->getNursingCharges($totalWardDays,$hospitalType,$tariffDays['Patient']['tariff_standard_id']);
		//	$wardServicesDataNew[$tariffDays['Patient']['id']] = $this->getDay2DayWardCharges($tariffDays['Patient']['id'],$tariffDays['Patient']['tariff_standard_id']);
			#$wardServicesDataNew[$tariffDays['Patient']['id']] = $this->getDay2DayCharges($tariffDays['Patient']['id'],$tariffDays['Patient']['tariff_standard_id']);
			$wardServicesDataNew[$tariffDays['Patient']['id']] = $this->groupWardCharges($tariffDays['Patient']['id']);
			$nursingServices[$tariffDays['Patient']['id']] = $this->getServiceCharges($tariffDays['Patient']['id'],$tariffDays['Patient']['tariff_standard_id']);
			$pharmacyChargeDetails[$tariffDays['Patient']['id']]= $this->getPharmacyFinalCharges($tariffDays['Patient']['id']);//for total pharmacy charge
			
		}
		
		foreach($nursingServices as $nursingServicesKey=>$nursingServicesCost){
			foreach($nursingServicesCost as $nursingServicesCost){
				$nursingCnt = $nursingServicesCost['TariffList']['id'] ;
				$resetNursingServices[$nursingServicesKey][$nursingCnt]['qty'] = $resetNursingServices[$nursingServicesKey][$nursingCnt]['qty']+$nursingServicesCost['ServiceBill']['no_of_times'];
				$resetNursingServices[$nursingServicesKey][$nursingCnt]['name'] = $nursingServicesCost['TariffList']['name'] ;
				//adding service bill amount to avoid different charges of same service eg:( x service = 500 , again x service = 600 then we have to add those charges ie 500+600) 
				$resetNursingServices[$nursingServicesKey][$nursingCnt]['cost'] = $resetNursingServices[$nursingServicesKey][$nursingCnt]['cost']+($nursingServicesCost['ServiceBill']['amount']*$nursingServicesCost['ServiceBill']['no_of_times']);
				$resetNursingServices[$nursingServicesKey][$nursingCnt]['moa_sr_no'] = $nursingServicesCost['TariffAmount']['moa_sr_no'];
				$resetNursingServices[$nursingServicesKey][$nursingCnt]['nabh_non_nabh'] = $nursingServicesCost['TariffList']['cghs_code'];
				//	$nursingCnt++;
			}
		}
			//debug($resetNursingServices);exit;
		$this->set('servicesData',$resetNursingServices);
		//debug($wardServicesDataNew);
		foreach($wardServicesDataNew as $key=>$wardCharges){
			foreach($wardCharges as $ward){
				foreach($ward as $charge){
					foreach($charge as $charge){
						$patientWardCharges[$key]=$patientWardCharges[$key]+$charge['cost'];
					}

				}
			}
		}
		$this->set(array('doctorCharges'=>$doctorCharges,'nursingCharges'=>$nursingCharges,'patientWardCharges'=>$patientWardCharges));
		//pr($servicesData);
		$this->set('results',$result);
// 		pr($results) ;exit;
		$this->loadModel('RadiologyTestOrder')	;
		$this->loadModel('LaboratoryTestOrder');
		$rad = $this->RadiologyTestOrder->radDetails($patientID); //array of patient ids
		$this->set('rad',$rad);
		$lab = $this->LaboratoryTestOrder->labDetails($patientID);
		$this->set('lab',$lab);


		//Pharmacy Data
		//Pharmacy charges will be added to billing only if the Pharmacy Service is set to IPD
		$this->loadModel('Configuration');
		/*$pharmacy_service_type=$this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'Pharmacy')));
		 $pharmacy_service_type=unserialize($pharmacy_service_type['Configuration']['value']);*/

		$this->loadModel('ServiceCategory');
		$pharmacyCategoryId=$this->ServiceCategory->getPharmacyId();
		
		$pharmacy_service_type=$this->Configuration->getPharmacyServiceType();
		$this->set('pharmacy_service_type',$pharmacy_service_type['addChargesInInvoice']);		
		//if(strtolower($pharmacy_service_type['addChargesInInvoice'])=='yes')
		$this->set('pharmacy_charges',$pharmacyChargeDetails);

		// consultant charges
		$this->loadModel('ConsultantBilling');
		$getconsultantData = $this->ConsultantBilling->find('all',array('conditions' =>array('ConsultantBilling.patient_id'=>$patientID)));
		$this->set('getconsultantData',$getconsultantData);

		/*$finaltotalPaid =$this->Billing->find('all',array('fields'=>array('Billing.patient_id','Billing.amount'),
				'conditions'=>array('Billing.patient_id'=>$patientID,'Billing.is_deleted'=>'0'),
		));*/
		
		// url flag to show pharmacy charges -- Pooja
		if($this->params->query['showPhar']){
			$pharmacy_service_type['addChargesInInvoice']='yes';
		}
		if($pharmacy_service_type['addChargesInInvoice']=='no'){
			$finaltotalPaid =$this->Billing->find('all',array('fields'=>array('Billing.patient_id','Billing.amount','Billing.discount'),
					'conditions'=>array('Billing.patient_id'=>$patientID,'Billing.is_deleted'=>'0','Billing.payment_category !='=>$pharmacyCategoryId),
			));	
			
			$pharPaidAmt=$this->Billing->find('all',array('fields'=>array('Billing.patient_id','Billing.amount','Billing.discount'),
					'conditions'=>array('Billing.patient_id'=>$patientID,'Billing.is_deleted'=>'0','Billing.payment_category'=>$pharmacyCategoryId),
			));	
			
			/*$totalDiscountGiven =$this->Billing->find('all',array('fields'=>array('Billing.patient_id','Billing.discount','Billing.payment_category' ),
					'conditions'=>array('Billing.patient_id'=>$patientID,'Billing.is_deleted'=>'0','Billing.payment_category !='=>$pharmacyCategoryId)));*/
			
		}else{
			$finaltotalPaid =$this->Billing->find('all',array('fields'=>array('Billing.patient_id','Billing.amount','Billing.discount'),
					'conditions'=>array('Billing.patient_id'=>$patientID,'Billing.is_deleted'=>'0')));

			$pharPaidAmt=$this->Billing->find('all',array('fields'=>array('Billing.patient_id','Billing.amount','Billing.discount'),
					'conditions'=>array('Billing.patient_id'=>$patientID,'Billing.is_deleted'=>'0','Billing.payment_category'=>$pharmacyCategoryId),
			));
			/*$totalDiscountGiven =$this->Billing->find('all',array('fields'=>array('Billing.patient_id','Billing.discount','Billing.payment_category' ),
					'conditions'=>array('Billing.patient_id'=>$patientID,'Billing.is_deleted'=>'0')));*/
		}		
		
		foreach($finaltotalPaid as $allPaid){
			$finalPaid[$allPaid['Billing']['patient_id']]=$finalPaid[$allPaid['Billing']['patient_id']]+$allPaid['Billing']['amount'];
			$totalDiscount[$allPaid['Billing']['patient_id']]=$totalDiscount[$allPaid['Billing']['patient_id']]+$allPaid['Billing']['discount'];
		}
		foreach($pharPaidAmt as $Paid){
			$pharPaid[$Paid['Billing']['patient_id']]=$pharPaid[$Paid['Billing']['patient_id']]+($Paid['Billing']['amount']-$Paid['Billing']['discount']);
		}
		/*foreach($totalDiscountGiven as $discount){
			$totalDiscount[$discount['Billing']['patient_id']]=$totalDiscount[$discount['Billing']['patient_id']]+$discount['Billing']['discount'];			
		}*/
		
		$this->set('totalDiscount',$totalDiscount);		
		$this->set('finaltotalPaid',$finalPaid);
		$this->set('pharPaid',$pharPaid);
// 		debug($surgeriesData);exit;
		
		//for refunded amount
		$this->loadModel('FinalBilling');
		$discountData =$this->FinalBilling->find('first',array('conditions'=>array('FinalBilling.patient_id'=>$id)));
		$this->set('discountData',$discountData);
		//EOF of refunded amount
		
		//for discounted amount
		// url flag to show pharmacy charges -- Pooja
		if($this->params->query['showPhar']){
			$pharmConfig['addChargesInInvoice']='yes';
		}
		if($pharmConfig['addChargesInInvoice']=='no'){
			$totalDiscountGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.discount) AS sumDiscount','Billing.payment_category' ),
					'conditions'=>array('Billing.patient_id'=>$id,'Billing.is_deleted'=>'0','Billing.payment_category !='=>$pharmacyCategoryId)));
			$this->set('totalDiscountGiven',$totalDiscountGiven);
		
		}else{
			$totalDiscountGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.discount) AS sumDiscount','Billing.payment_category' ),
					'conditions'=>array('Billing.patient_id'=>$id,'Billing.is_deleted'=>'0')));
			$this->set('totalDiscountGiven',$totalDiscountGiven);
		}
		
		//***code for discount to be shown in invoice***//
		
		//EOF discounted amount
		
		//****for refund amount in invoice****/yashwant/
		
		$totalRefundGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.paid_to_patient) AS sumRefund',
				'Billing.payment_category' ),'conditions'=>array('Billing.patient_id'=>$id,'Billing.is_deleted'=>'0','Billing.refund'=>'1')));
		$this->set('totalRefundGiven',$totalRefundGiven);
		

		$this->loadModel('Bed');
		$this->Bed->bindModel(array(
				'belongsTo' => array(
						'Room'=>array('foreignKey'=>'room_id','type'=>'inner'),
						'Ward'=>array('foreignKey'=>false,
								'conditions'=>array('Ward.id=Room.ward_id'),'type'=>'inner')
				),
				'hasMany'=>array('WardPatient'=>array('order'=>'WardPatient.id Desc','Limit'=>1,'WardPatient.is_deleted=0')),false));
		$data = $this->Bed->find('all',array('conditions'=>array('Ward.is_deleted'=>0,'Ward.location_id'=>$this->Session->read('locationid')),'order'=>array('Ward.id','Bed.id')));
		$this->set('data',$data);
		
			if(isset($this->request->query['format']) && $this->request->query['format'] == 'generate_excel'){
				$this->layout = false ;
				foreach($patientID as $patient_id){
					$diffArray[$patient_id]=$this->diffAmountDetails($patient_id);
				}
				$this->set('setDiff',$diffArray);
				$this->render('advance_bill_xls',false);
			} 
			
			$rgjayOnToday = $this->TariffStandard->getTariffStandardID('rgjay_private_as_on_today');
			$rgjayID = $this->TariffStandard->getTariffStandardID('rgjay');

			$covidPackageBill = $this->PatientCovidPackage->getTotalCovidPackageBill($patientID);
			
			$this->set(array('rgjayOnToday'=>$rgjayOnToday,'rgjayID'=>$rgjayID,'covidPackageBill'=>$covidPackageBill));
			
			
	}

	/*******************************************************************************************************************/


	//function to calculate ward days
	//by pankaj
	function calculateWardDays($wardData=array(),$surgeries=array(),$config_hrs){

			
		foreach($wardData as $wardKey =>$wardValue){

			//Date Converting to Local b4 calculation
			if(!empty($wardValue['WardPatient']['in_date'])){
				$wardValue['WardPatient']['in_date'] = $this->DateFormat->formatDate2Local($wardValue['WardPatient']['in_date'],'yyyy-mm-dd',true);
			}
			if(!empty($wardValue['WardPatient']['out_date'])){
				$wardValue['WardPatient']['out_date'] = $this->DateFormat->formatDate2Local($wardValue['WardPatient']['out_date'],'yyyy-mm-dd',true);
			}
			$currDateUTC  = $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),'yyyy-mm-dd',true)  ;
			//EOF date change

			//Bed cost
			if($this->Session->read('hospitaltype')=='NABH'){
				$charge   = 	(int)$wardValue['TariffAmount']['nabh_charges']  ;
			}else{
				$charge   = 	(int)$wardValue['TariffAmount']['non_nabh_charges']  ;
			}

			//EOF bed cost
			$surgeryDays = $this->getSurgeryArray($surgeries,$wardValue['WardPatient']['in_date'],$wardValue['WardPatient']['out_date']);
			$surgeryFirstDate  = explode(" ",$surgeryDays['sugeryValidity'][0]['start']);
			$lastKey =end($surgeryDays['sugeryValidity']) ;
			$surgeryLastDate  =  explode(" ",$lastKey['end']);

			if(!empty($wardValue['WardPatient']['out_date'])){
					

				$slpittedIn = explode(" ",$wardValue['WardPatient']['in_date']) ;
				//if checkout timing is 24 hours then set time to default in time
				if($config_hrs=='24 hours'){
					$config_hrs = $slpittedIn[1];
				}
				//EOF config check
				$slpittedOut = explode(" ",$wardValue['WardPatient']['out_date']) ;
				$interval = $this->DateFormat->dateDiff($slpittedIn[0],$slpittedOut[0]);

				$days = $interval->days ; //to match with the date_diiff fucntion result as of 24hr day diff
				$hrInterval = $this->DateFormat->dateDiff($wardValue['WardPatient']['in_date'],$wardValue['WardPatient']['out_date']); //for hr calculation 
				if($days > 0 ){
					$dayArrCount  = count($dayArr['day']);
					for($i=0;$i<=$days;$i++){
							
						$nextDate  = date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'].$i." days")) ;
						// Code to add one day before 10 AM
						$firstDate10 = date('Y-m-d H:i:s',strtotime($slpittedIn[0]." $config_hrs"));

						//check if the shift of ward is between 4 hours to avoid that ward charges
						if($i !=0 && $hrInterval->h < 4 && $hrInterval->d ==0 && $hrInterval->m ==0 && $hrInterval->y ==0){
							//$dayArr['day'][$dayArrCount-1]['out'] = $wardValue['WardPatient']['out_date'] ;
							#echo "line8474";
							continue ; //no need maintain data below 4 hours
						}

						//to avoid if diff is less than 4 hours between closing time and in time
						$closingInterval = $this->DateFormat->dateDiff($wardValue['WardPatient']['in_date'],$firstDate10); //for hr calculation

						if($i !=0 &&  $closingInterval->h < 4 && $closingInterval->d ==0 && $closingInterval->m ==0 && $closingInterval->y ==0){

							//$dayArr['day'][$dayArrCount-1]['out'] = $wardValue['WardPatient']['out_date'];
							#echo "line8482"; //commneted for raju thakare 
							//continue ; //no need maintain data below 4 hours


						}
							

						if($i==0 && strtotime($wardValue['WardPatient']['in_date']) < strtotime($firstDate10)){
							/* 	$dayArr['day'][] = array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
							 'cghs_nabh'=>$wardValue['TariffList']['cghs_nabh'],
									'cghs_non_nabh'=>$wardValue['TariffList']['cghs_non_nabh'],
									'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
									'apply_in_a_day'=>$wardValue['TariffList']['apply_in_a_day'],
									"in"=>date('Y-m-d H:i:s',strtotime($slpittedIn[0].' -1 days '.$config_hrs)),
									"out"=>$firstDate10,'cost'=>$charge,'ward'=>$wardValue['Ward']['name']) ; */
						}
							

						//checking for greater price of same day
						if(($dayArrCount>0)	&&	($i==0) && ($dayArr['day'][$dayArrCount-1]['out']==$wardValue['WardPatient']['in_date'])
								&& ($hrInterval->h >= 4 || $hrInterval->d > 0)){

							if($dayArr['day'][$dayArrCount-1]['cost']<$charge){
								#print_R($dayArr['day']);
								$dayArr['day'][$dayArrCount-1]['cost'] = $charge ;
								$dayArr['day'][$dayArrCount-1]['ward'] = $wardValue['Ward']['name'] ;
								$dayArr['day'][$dayArrCount-1]['ward_id'] = $wardValue['Ward']['id'] ;
								$dayArr['day'][$dayArrCount-1]['service_id'] = $wardValue['TariffList']['id'] ;


							}
							#echo "line8508";
							continue;
						}

						//EOF cost check

						if( (strtotime($nextDate) >= strtotime($wardValue['WardPatient']['out_date'])) || ($i==$days) ){
							if($i>0){
								$firstOutDate10 = date('Y-m-d H:i:s',strtotime($slpittedOut[0]." ".$config_hrs));
								// start of skip day if discharged b4 10 AM
								if(strtotime($wardValue['WardPatient']['out_date']) < strtotime($firstOutDate10)){								 
									continue;
								}
								// end of skip day if discharged b4 10 AM
								$tempOutDate = strtotime($slpittedIn[0].$i." days $config_hrs");

							}else{
								$tempOutDate = strtotime($wardValue['WardPatient']['in_date']);
							}

							//skip if hour diff is less than 4 hours
							//check for in n out time diff (if the diff less than 4 hours then skip this iteration)
							$inConvertedDate  =  date('Y-m-d H:i:s',$tempOutDate);
							$outConvertedDate =  $wardValue['WardPatient']['out_date'];

							$shortTimeDiff    =  $this->DateFormat->dateDiff($inConvertedDate,$outConvertedDate);

							//$i cond added for below example
							/**
							 suppose admission on 22:00 and checkout timing is 00:00 then charges should be applied for that day
							 but this is not true for ward shuffling added by pankaj
							**/

							if($i != 0 && ($shortTimeDiff->h>0 || $shortTimeDiff->i>0)&& $shortTimeDiff->h<4 && $shortTimeDiff->d==0 && $shortTimeDiff->m==0 && $shortTimeDiff->y==0){
								#echo "line8541";
								continue ;
							}
							//skip if hour diff is less than 4 hours

							$dayArr['day'][] = array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
									'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
									"in"=>date('Y-m-d H:i:s',$tempOutDate),
									"out"=>$wardValue['WardPatient']['out_date'],
									'cost'=>$charge,'ward'=>$wardValue['Ward']['name'],
									'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
						}else if((strtotime($nextDate) <= strtotime($wardValue['WardPatient']['out_date']))){

							if($i==0){
								//if($days==1)
								$tempOutDate = strtotime($slpittedIn[0]."1 days $config_hrs");
								//else
								//$tempOutDate = strtotime($slpittedIn[0].$i." days $config_hrs");
							}else{
								$tempOutDate = strtotime($wardValue['WardPatient']['in_date'].$i." days");
							}

							//check for in n out time diff (if the diff less than 4 hours then skip this iteration)
							$inConvertedDate  =date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'].$i." days")) ;
							$outConvertedDate = date('Y-m-d H:i:s',$tempOutDate);

							//echo "<br/>";
							$shortTimeDiff =   $this->DateFormat->dateDiff($inConvertedDate,$outConvertedDate);

							//$i cond added for below example
							/**
							 suppose admission on 22:00 and checkout timing is 00:00 then charges should be applied for that day
							 but this is not true for ward shuffling added by pankaj
							**/

							if($i != 0 && ($shortTimeDiff->h>0 || $shortTimeDiff->i>0)&& $shortTimeDiff->h<4 && $shortTimeDiff->d==0 && $shortTimeDiff->m==0 && $shortTimeDiff->y==0){
								#echo "line8574";
								continue ;
							}


							$dayArr['day'][] =
							array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
									'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
									"in"=>$inConvertedDate,
									"out"=>$outConvertedDate,
									'cost'=>$charge,
									'ward'=>$wardValue['Ward']['name'],
									'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
						}
					}

				}else if($hrInterval->h >= 4){
					$nextDate  = date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'])) ;
					//checking for greater price of same day
//same day ward shift and price check 
					$dayArrCountEX = count($dayArr['day']);
					if(($dayArr['day'][$dayArrCountEX-1]['out']==$wardValue['WardPatient']['in_date'])){
						if($dayArr['day'][$dayArrCountEX-1]['cost']<$charge){
							$dayArr['day'][$dayArrCountEX-1]['cost'] = $charge ;
							$dayArr['day'][$dayArrCountEX-1]['ward'] = $wardValue['Ward']['name'] ;
							$dayArr['day'][$dayArrCountEX-1]['ward_id'] = $wardValue['Ward']['id'] ;
							$dayArr['day'][$dayArrCountEX-1]['service_id'] = $wardValue['TariffList']['id'] ;

						}
						$dayArr['day'][$dayArrCountEX-1]['out'] =  $wardValue['WardPatient']['out_date'] ; //so that we can compare out and in date to skip charge for same day
						continue;
					}
					if(is_array($wardData[$wardKey+1])){
						if($this->Session->read('hospitaltype')=='NABH'){
							$nextCharge   = 	(int)$wardData[$wardKey+1]['TariffAmount']['nabh_charges']  ;
						}else{
							$nextCharge   = 	(int)$wardData[$wardKey+1]['TariffAmount']['non_nabh_charges']  ;
						}
						//check if the patient has stays more than 4hr our in next shifted ward
						$slpittedInForNext = explode(" ",$wardData[$wardKey+1]['WardPatient']['in_date']) ;
						if(!empty($wardData[$wardKey+1]['WardPatient']['out_date']))
							$slpittedOutForNext = explode(" ",$wardData[$wardKey+1]['WardPatient']['out_date']) ;
						else
							//$slpittedOutForNext = explode(" ",$currDateUTC) ;
							$slpittedOutForNext = explode(" ",$wardValue['WardPatient']['out_date']) ;

						$intervaForNext = $this->DateFormat->dateDiff($slpittedInForNext[0],$slpittedOutForNext[0]);
						if($intervaForNext->days > 0 || $intervaForNext->h >= 4)
							if($nextCharge > $charge) continue ;
						//EOF check
					} 	//EOF cost check

					if(strtotime($nextDate) > strtotime($wardValue['WardPatient']['out_date'])){
						if(is_array($wardData[$wardKey+1])){
							$dayArr['day'][] = array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
									'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
									"in"=>$wardValue['WardPatient']['in_date'],
									"out"=>$wardData[$wardKey]['WardPatient']['out_date'],
									'cost'=>$charge,
									'ward'=>$wardValue['Ward']['name'],
									'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
						}else{
							$dayArr['day'][] = array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
									'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
									"in"=>$wardValue['WardPatient']['in_date'],
									"out"=>$wardValue['WardPatient']['out_date'],
									'cost'=>$charge,'ward'=>$wardValue['Ward']['name'],'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
						}
					}else{
						$dayArr['day'][] =  array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
								'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
								"in"=>$wardValue['WardPatient']['in_date'],
								"out"=>date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['out_date'])),
								'cost'=>$charge,'ward'=>$wardValue['Ward']['name'],'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
					}


				}else{
					//if($hrInterval->h < 4) continue ; //to skip same day ward shifting charges for less than 4 hours
					//check out date should less than indate for dday 1 adminission
					$dayArrCountEX = count($dayArr['day']);
					//check if the shift of ward is between 4 hours to avoid that ward charges
					if($hrInterval->h < 4 && $hrInterval->d ==0 && $hrInterval->m ==0 && $hrInterval->y ==0 && $i!=0){ //for first $i cond 
						if($dayArrCountEX > 0)
							$dayArr['day'][$dayArrCountEX-1]['out'] = $wardValue['WardPatient']['out_date']; //to correct same day charge compare for makiing previous and currnt day n time
						//echo "test2";
						continue ; //no need maintain data below 4 hours
					}



					if(($dayArr['day'][$dayArrCountEX-1]['out']==$wardValue['WardPatient']['in_date'])){
						if($dayArr['day'][$dayArrCountEX-1]['cost']<$charge){
							$dayArr['day'][$dayArrCountEX-1]['cost'] = $charge ;
							$dayArr['day'][$dayArrCountEX-1]['ward'] = $wardValue['Ward']['name'] ;
							$dayArr['day'][$dayArrCountEX-1]['ward_id'] = $wardValue['Ward']['id'] ;
							$dayArr['day'][$dayArrCountEX-1]['service_id'] = $wardValue['TariffList']['id'] ;

						}
						$dayArr['day'][$dayArrCountEX-1]['out'] =  $wardValue['WardPatient']['out_date'] ; //so that we can compare out and in date to skip charge for same day
						continue;
					}

					$dayArr['day'][] =  array(
							'cghs_code'=>$wardValue['TariffList']['cghs_code'],
							'cghs_nabh'=>$wardValue['TariffList']['cghs_nabh'],
							'cghs_non_nabh'=>$wardValue['TariffList']['cghs_non_nabh'],
							'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
							'apply_in_a_day'=>$wardValue['TariffList']['apply_in_a_day'],
							"in"=>$wardValue['WardPatient']['in_date'], //started day from checkout hrs
							"out"=>$wardValue['WardPatient']['out_date'],
							'cost'=>$charge,'ward'=>$wardValue['Ward']['name']
							,'ward_id'=>$wardValue['Ward']['id'],
							'service_id'=>$wardValue['TariffList']['id']) ;


				}
			}else{
				$slpittedIn = explode(" ",$wardValue['WardPatient']['in_date']) ;
				//if checkout timing is 24 hours then set time to default in time
				if($config_hrs=='24 hours'){
					$config_hrs = $slpittedIn[1];
				}
				//EOF config check
				$interval = $this->DateFormat->dateDiff($slpittedIn[0],date('Y-m-d'));
				$hrInterval = $this->DateFormat->dateDiff($wardValue['WardPatient']['in_date'],$currDateUTC); //for hr calculation
				$days = $interval->days ; //to match with the date_diiff fucntion result as of 24hr day diff
				$dayArrCount  = count($dayArr['day']);
				$firstDate10 = date('Y-m-d H:i:s',strtotime($slpittedIn[0]." ".$config_hrs));

				if($days > 0){
					for($i=0;$i<=$days;$i++){
						$nextDate  = date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'].$i." days")) ;

						if($i==0 && strtotime($wardValue['WardPatient']['in_date']) < strtotime($firstDate10)){
							$dayArr['day'][] = array(
									'cghs_code'=>$wardValue['TariffList']['cghs_code'],
									'cghs_nabh'=>$wardValue['TariffList']['cghs_nabh'],
									'cghs_non_nabh'=>$wardValue['TariffList']['cghs_non_nabh'],
									'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
									'apply_in_a_day'=>$wardValue['TariffList']['apply_in_a_day'],
									"in"=>date('Y-m-d H:i:s',strtotime($slpittedIn[0].' -1 day '.$config_hrs)),
									"out"=>$firstDate10,'cost'=>$charge,'ward'=>$wardValue['Ward']['name']
									,'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
						}

							
						//checking for greater price of same day
						if(($dayArrCount>0)	&&	($i==0) && ($dayArr['day'][$dayArrCount-1]['out']==$wardValue['WardPatient']['in_date'])){

							if($dayArr['day'][$dayArrCount-1]['cost']<$charge){
								$dayArr['day'][$dayArrCount-1]['cost'] = $charge ;
								$dayArr['day'][$dayArrCount-1]['ward'] = $wardValue['Ward']['name'] ;
								$dayArr['day'][$dayArrCount-1]['ward_id'] = $wardValue['Ward']['id'] ;
								$dayArr['day'][$dayArrCount-1]['service_id'] = $wardValue['TariffList']['id'] ;
							}
							continue;
						}

						//EOF cost check
							
						if(	(strtotime($nextDate) >= strtotime($currDateUTC)) || ($i==$days)){ //change || to && for hours diff

							if($i>0){
								$tempOutDate = strtotime($slpittedIn[0].$i." days $config_hrs");
							}else{
								$tempOutDate = strtotime($wardValue['WardPatient']['in_date']);
							}

							if($tempOutDate < strtotime($currDateUTC))  {
								//if cond to handle mid hours case
								//like if the starts at 6pm then the last day count should be upto 6pm
								//and skip the count after 6pm
								$dayArr['day'][] = array(
										'cghs_code'=>$wardValue['TariffList']['cghs_code'],
										'cghs_nabh'=>$wardValue['TariffList']['cghs_nabh'],
										'cghs_non_nabh'=>$wardValue['TariffList']['cghs_non_nabh'],
										'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
										'apply_in_a_day'=>$wardValue['TariffList']['apply_in_a_day'],
										"in"=>date('Y-m-d H:i:s',$tempOutDate),"out"=>$currDateUTC,
										'cost'=>$charge,'ward'=>$wardValue['Ward']['name'],
										'ward_id'=>$wardValue['Ward']['id'],
										'service_id'=>$wardValue['TariffList']['id']) ;
							}
						}else{

							//commented below line for correcting out date for first array element
							if($i==0){
								//if($days==1)
								$tempOutDate = strtotime($slpittedIn[0]."1 days $config_hrs");
								//else
								//$tempOutDate = strtotime($slpittedIn[0].$i." days $config_hrs");
							}else{
								$g= $i + 1 ;
								$tempOutDate =   strtotime($wardValue['WardPatient']['in_date'].$g." days");
							}

							//BOF pankaj
							//check if the previous entry is of same day
							/*	$previousIn =  explode(" ",$dayArr['day'][$dayArrCount-1]['in']);
							 $currentIn = explode(" ",$wardValue['WardPatient']['in_date']);

							if($previousIn[0]==$currentIn[0]){ pr($dayArr['day']);
							$dayArr['day'][$dayArrCount-1]['cost'] = $charge ;
							$dayArr['day'][$dayArrCount-1]['ward'] = $wardValue['Ward']['name'] ;
							$dayArr['day'][$dayArrCount-1]['out']=date('Y-m-d H:i:s',$tempOutDate) ;
							continue;
							}*/

							//EOF pankaj
							$dayArr['day'][] =  array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
									'cghs_nabh'=>$wardValue['TariffList']['cghs_nabh'],
									'cghs_non_nabh'=>$wardValue['TariffList']['cghs_non_nabh'],
									'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
									'apply_in_a_day'=>$wardValue['TariffList']['apply_in_a_day'],
									"in"=>date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'].$i." days")),
									"out"=>date('Y-m-d H:i:s',$tempOutDate),'cost'=>$charge,
									'ward'=>$wardValue['Ward']['name']
									,'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
						}
					}

				}else if($hrInterval->h >= 4 || $wardDayCount == 0){
					$nextDate  = date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'])) ;
					//checking for greater price of same day
					//EOF cost check

					if(($dayArrCount>0)	 && ($dayArr['day'][$dayArrCount-1]['out']==$wardValue['WardPatient']['in_date'])){
						if($dayArr['day'][$dayArrCount-1]['cost']<$charge){
							$dayArr['day'][$dayArrCount-1]['cost'] = $charge ;
							$dayArr['day'][$dayArrCount-1]['ward'] = $wardValue['Ward']['name'] ;
							$dayArr['day'][$dayArrCount-1]['ward_id'] = $wardValue['Ward']['id'] ;
							$dayArr['day'][$dayArrCount-1]['service_id'] = $wardValue['TariffList']['id'] ;
						}
						continue;
					}
					if(strtotime($nextDate) > strtotime($currDateUTC)){
						$dayArr['day'][] = array(
								'cghs_code'=>$wardValue['TariffList']['cghs_code'],
								'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
								'in'=>date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'])),"out"=>$currDateUTC,'cost'=>$charge,
								'ward'=>$wardValue['Ward']['name'],'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
					}else{
						$dayArr['day'][] =  array('cghs_code'=>$wardValue['TariffList']['cghs_code'],'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],"in"=>date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'])),"out"=>date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'])),'cost'=>$charge,
								'ward'=>$wardValue['Ward']['name'],'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
					}
				}

			}
			$wardDayCount++ ;
		}

		return array('dayArr'=>$dayArr,'surgeryData'=>$surgeryDays) ;

	}




	/**
	 * function for deleting billing record
	 *@params $recId of billing.
	 *By Yashwant
	 */
	public function deleteBillingEntry($recId=null){
		$this->loadModel('Billing');
		//$this->loadModel('ServiceBill');
		$this->loadModel('AccountReceipt');
		//debug($recId);exit;
		//$this->Billing->find('first',array('fields'=>array('payment_category','tariff_list_id'),'conditions'=>array('id'=>$recId)));
		
		$this->Billing->updateAll(array('Billing.is_deleted'=>1),array('Billing.id'=>$recId));
		$this->AccountReceipt->updateAll(array('AccountReceipt.is_deleted'=>1),array('AccountReceipt.billing_id'=>$recId));
		
		$this->Session->setFlash(__('Record deleted successfully', true));
		$this->redirect(array("controller" => "Pharmacy", "action" => "pharmacy_details","sales","inventory"=>true));
		exit;
	}

	/**
	 *function for refund print
	 *@params $recId of billing.
	 *By Yashwant
	 */
	public function printRefundPayment($recId=null){
		$website=$this->Session->read('website.instance');
		if($website == 'kanpur')
		{
			if($this->request->query['header'] == 'without')
			{
				$this->layout = false;
			}else{
				$this->layout = 'print_with_header';
			}
		}else{
			$this->layout = false;
		}
			$this->uses = array('Billing','Patient');
			$this->Patient->bindModel(array(
					'belongsTo' => array(   'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
					)),false);
			 
			$billingData = $this->Billing->find('first',array('conditions'=>array('id'=>$recId,'is_deleted'=>'0','refund'=>'1')));
			$patientData = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$billingData['Billing']['patient_id']),
					'fields' => array('Patient.*','PatientInitial.name')));
			 
			$this->set(array('billingData'=>$billingData,'patientData'=>$patientData));
	 
	}

	/**
	 * function returns all the charges that are added to bill amount within 24 hrs i.e 8am to 8am
	 * @param unknown_type $patient_id,
	 * By Pooja
	 */
	public function diffAmountDetail($patient_id){
		$this->layout="advance_ajax";
		$diffArray=$this->diffAmountDetails($patient_id);
		$this->set('diffArray',$diffArray);
	}

	public function diffAmountDetails($patient_id){
		if(!empty($patient_id)){

			$todayDate=date('Y-m-d').' 08:00:00';
			$pastDate=date('Y-m-d', strtotime('-1 day', strtotime($todayDate)));
			$pastDate=$pastDate.' 08::00:00';

			//'NosocomialInfection.submit_date BETWEEN ? AND ?' => array($firstDate, $lastDate))
			$this->loadModel('Patient');
			$this->Patient->unbindModel(array('hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));

			$result = $this->Patient->find('first',array('fields'=>array('Patient.*'),
					'conditions'=>array('Patient.location_id'=>$this->Session->read('locationid'),'Patient.id'=>$patient_id,
							'Patient.is_discharge'=>0,'Patient.is_deleted'=>0,'Patient.admission_type'=>"IPD"),
			));

			$this->loadModel('OptAppointment');
			$this->OptAppointment->unbindModel(array(
					'belongsTo' => array('Initial','Patient','Location','Opt','OptTable','Surgery','SurgerySubcategory','Doctor','DoctorProfile')));

			$this->OptAppointment->bindModel(array(
					'belongsTo' => array(
							'Surgery'=>array('foreignKey'=>'surgery_id'),
					)));

			$surgeriesData = $this->OptAppointment->find('all',array(
					'fields'=>array('Surgery.name','OptAppointment.patient_id', 'Surgery.charges','OptAppointment.procedure_complete',
							'OptAppointment.surgery_cost','OptAppointment.anaesthesia_cost','OptAppointment.ot_charges'),
					'conditions'=>array('OptAppointment.create_time BETWEEN ? AND ?' =>array($pastDate,$todayDate),
							'OptAppointment.patient_id'=>$patient_id,'OptAppointment.is_deleted'=>0,
							'OptAppointment.location_id'=>$this->Session->read('locationid'))));

			foreach($surgeriesData as $surgery){
				$diffArray['Surgery']=$diffArray['Surgey']+$surgery['OptAppointment']['surgery_cost']+$surgery['OptAppointment']['anaesthesia_cost']+$surgery['OptAppointment']['ot_charges'];
			}

			$this->loadModel('ServiceBill');
			$this->ServiceBill->bindModel(array(
					'belongsTo' => array(
							'Patient' =>array('foreignKey'=>'patient_id'),
							"ServiceCategory"=>array('foreignKey'=>'service_id','type'=>'RIGHT'),
							"ServiceSubCategory"=>array('foreignKey'=>'sub_service_id'),
							'TariffList'=>array('foreignKey'=>'tariff_list_id'),
							'TariffAmount'=>array('foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=ServiceBill.tariff_list_id','TariffAmount.tariff_standard_id'))
					)));

			$servicesData =$this->ServiceBill->find('all',array('group'=>array('ServiceBill.id'),'fields'=>array('TariffAmount.*,ServiceCategory.*,ServiceSubCategory.*,
					TariffList.*,ServiceBill.*,Patient.lookup_name,Patient.is_discharge,Patient.tariff_standard_id,Patient.form_received_on'),
					'conditions'=>array('ServiceBill.create_time BETWEEN ? AND ?' =>array($pastDate,$todayDate),'ServiceBill.patient_id'=>$patient_id,
					)));
			foreach($servicesData as $service){
				$diffArray['Services']=$diffArray['Services']+$service['ServiceBill']['amount'];
			}



			#$bedCharges = $this->getDay2DayCharges($patient_id,$result['Patient']['tariff_standard_id']);
			$bedCharges = $this->wardCharges($patient_id);
			$totalWardDays=count($bedCharges['day']); //total no of days
			if($totalWardDays==0){
				$totalWardDays=1;
			}

			$hospitalType = $this->Session->read('hospitaltype');

			$diffArray['Doctor Charges'] = $this->Billing->getDoctorCharges(1,$hospitalType,$result['Patient']['tariff_standard_id'],'IPD');
			$diffArray['Nursing Charges'] = $this->Billing->getNursingCharges(1,$hospitalType,$result['Patient']['tariff_standard_id']);
			//$wardServicesDataNew = $this->getDay2DayWardCharges($patient_id,$result['Patient']['tariff_standard_id']);
			$wardServicesDataNew = $this->groupWardCharges($patient_id);
			foreach($wardServicesDataNew as $key=>$wardCharges){
				foreach($wardCharges as $ward){
					foreach($ward as $charge){
						$diffArray['room Tariff']=$charge['cost'];
					}
				}
			}

			$this->loadModel('RadiologyTestOrder')	;
			$this->loadModel('LaboratoryTestOrder');

			$rad = $this->RadiologyTestOrder->find('all',array('fields'=>array('patient_id','amount'),
					'conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id,
							'RadiologyTestOrder.radiology_order_date BETWEEN ? AND ?'=>array($pastDate,$todayDate),
							'RadiologyTestOrder.is_deleted'=>'0','RadiologyTestOrder.location_id'=>$this->Session->read('locationid')))); //array of patient ids
					foreach($rad as $radData){
						$diffArray['Radiology']=$diffArray['Radiology']+$radData['RadiologyTestOrder']['amount'];
					}

					$lab = $this->LaboratoryTestOrder->find('all',array('fields'=>array('patient_id','amount'),
							'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patient_id,
									'LaboratoryTestOrder.create_time BETWEEN ? AND ?'=>array($pastDate,$todayDate),
									'LaboratoryTestOrder.is_deleted'=>'0','LaboratoryTestOrder.location_id'=>$this->Session->read('locationid'))));
					foreach($lab as $labData){
						$diffArray['Laboratory']=$diffArray['Laboratory']+$labData['LaboratoryTestOrder']['amount'];
					}

		}


		$this->loadModel('PharmacySalesBill');
		$this->loadModel('PharmacyItem');
		$pharmacyResult = $this->PharmacySalesBill->find('all',array('conditions'=>array(
				'PharmacySalesBill.patient_id'=>$patient_id,
				'PharmacySalesBill.create_time BETWEEN ? AND ?'=>array($pastDate,$todayDate))));
		foreach($pharmacyResult as $pharmacy){
			foreach($pharmacy['PharmacySalesBillDetail'] as $pharmacyItem){
				$pharmacyItemDetails = $this->PharmacyItem->find('first',array('conditions'=>array('PharmacyItem.id'=>$pharmacyItem['item_id'])));

				if($pharmacyItemDetails['PharmacyItemRate']['sale_price']!=0){
					$cost=$pharmacyItem['qty']*$pharmacyItemDetails['PharmacyItemRate']['sale_price'];
				}else{
					$cost=$pharmacyItem['qty']*$pharmacyItemDetails['PharmacyItemRate']['mrp'];
				}
				$diffArray['Pharmacy']=$diffArray['Pharmacy']+$cost;
			}

		}


		$this->loadModel('ConsultantBilling');
		$getconsultantData = $this->ConsultantBilling->find('all',array('fields'=>array('patient_id','amount'),
				'conditions' =>array('ConsultantBilling.patient_id'=>$patient_id,
						'ConsultantBilling.date BETWEEN ? AND ?'=>array($pastDate,$todayDate))));
		foreach($getconsultantData as $consult){
			$diffArray['Consultant Charges']=$diffArray['Consultant Charges']+$consult['ConsultantBilling']['amount'];
		}

		foreach($diffArray as $totalDiff){
			$total=$total+$totalDiff;
		}
		$diffArray['Total Diff Amount']=$total;
		return $diffArray;

	}

	public function deleteItems($modelName,$preRecordId){
		$this->uses=array('SuggestedDrug');
		if($modelName=='med'){
			$this->SuggestedDrug->updateAll(array('SuggestedDrug.is_deleted'=>'1'),array('SuggestedDrug.id'=>$preRecordId));
			exit;
		}else{

		}

	}
	
	/**
	 * @author Mahalaxmi
	 * For Send SMS From Advance Statement
	 * @param $patientId integer
	 *
	 */
	public function getTodayPaymentForSms()
	{
		$this->uses = array('Patient');
		$this->autoRender = false;
		$this->Layout = 'ajax';
		$patientIdArrEx=explode(',',$this->request->data['chk1Array']);
		$patientIdArr=array();
		$totalBillArr=array();
		foreach ($patientIdArrEx as $key=>$patientIdArrExs){
			$patientIdArrEx2[$key]=explode('_', $patientIdArrExs);
		}
	
		foreach ($patientIdArrEx2 as $key1=>$patientIdArrEx2s){			
			if(empty($patientIdArrEx2s['0']))
				continue;
			$patientIdArr[$key1]=$patientIdArrEx2s['0'];
			$totalBillArr[$patientIdArrEx2s['0']]=$patientIdArrEx2s['1'];
		}
			
		foreach($patientIdArr as $keyPatientId=>$patientIdArrs){		
				$this->request->data['Patient']['id']=$patientIdArrs;
				$this->request->data['Patient']['amount_to_pay_today'] =$totalBillArr[$patientIdArrs];			
				$this->Patient->save($this->request->data);	
		}
		exit;
	}
	/**
	 * @author Mahalaxmi
	 * For Send SMS From Advance Statement
	 * @param $patientId integer
	 *
	 */
	public function sendToSmsMultiplePatient(){	
		$this->loadModel('Patient');
		$this->uses=array('User','Note','Configuration','Role');
		$this->autoRender = false;
		$this->Layout = 'ajax';
		$patientIdArrEx=explode(',',$this->request->data['chk1Array']);		
		foreach ($patientIdArrEx as $key=>$patientIdArrExs){			
			$patientIdArrEx2[$key]=explode('_', $patientIdArrExs);			
		}			
		/******BOF-Mahalaxmi-After patient reg to  get sms alert for Patient Relative......  ***/
		#$getEnableFeatureChk=$this->Session->read('sms_feature_chk');]
		$smsActive=$this->Configuration->getConfigSmsValue('Advance Billing');	
		if($smsActive){
		//if($getEnableFeatureChk){
			$getResult=$this->Patient->sendToSmsMultiplePatientRelative($patientIdArrEx2,'AdvBill');	
			
			/*BOF-Sending Mail- How much Patient's Relatives got SMS FOR Confirmation Purpose*/	
			/*$this->User->bindModel(array(
					'belongsTo' => array(
							'Role' =>array('foreignKey' => false,'conditions'=>array('Role.name'=>Configure::read('billing_manager_role'),'Role.is_deleted'=>'0')),				
			)),false);*/
			$getRoleId=$this->Role->getRoleIdByName(Configure::read('billing_manager_role'));
			$userfullname = $this->User->find('all', array('fields'=> array('User.first_name','User.last_name','User.username'),
					'conditions'=>array('User.is_deleted'=>'0','User.role_id'=>$getRoleId['Role']['id'])));				
			//username
			#pr($userfullname);exit;
			foreach($userfullname as $key=>$value){
				$mailData['Patient']=array("patient_id"=>$value["User"]["username"],"lookup_name"=>$value["User"]["first_name"]." ".$value["User"]["last_name"]);
				$msgs="Text sent to the following patient`s relatives today at ".date("h:i A").".<br/><br/>";
				$subject="Sent SMS to Patient`s Relative From Advance Statement";		
				$cnt=1;
				foreach($getResult as $key1=>$getPatientNameArrs){
					if(!empty($key1)){
						$updatePatientSms['Patient']['id']=$key1;
						$updatePatientSms['Patient']['sms_sent']='1';
						$updatePatientSms['Patient']['advance_sms_sent_date_time']=date('Y-m-d H:i:s');
						$this->Patient->save($updatePatientSms);
					}
					$msgsArr[$key1]=($cnt).". ".$getPatientNameArrs."</br>";					
					$cnt++;
				}	
			
				$count=count($msgsArr);				
				$msgsArrimp=implode("</br>",$msgsArr);			
				$msgs.=$msgsArrimp;	
				if($count>0)				
					$this->Note->sendMail($mailData,$msgs,$subject);
			}	
			
			/*EOF-Sending Mail- How much Patient's Relatives got SMS FOR Confirmation Purpose*/
		}
		/******EOF-Mahalaxmi-After patient reg to  get sms alert for Patient Relative......  ***/
	}


	/**
	 * @author Gaurav Chauriya
	 * for fetching Package information for private patients
	 * @param $patientId integer
	 *
	 */
	public function ajaxPrivatePackageData($packagedPatientId=null) {
		$this->layout = false;
		$this->uses=array('EstimateConsultantBilling','ServiceCategory');
		$this->EstimateConsultantBilling->bindModel(array(
				'hasOne'=>array(
						'PackageEstimate'=>array('foreignKey'=>false,
								'conditions'=>array('EstimateConsultantBilling.package_estimate_id = PackageEstimate.id')),
						'Patient'=>array('foreignKey'=>false,
								'conditions'=>array('Patient.is_packaged = EstimateConsultantBilling.patient_id'))
				)));
		$package = $this->EstimateConsultantBilling->find('first',array('fields'=>array('EstimateConsultantBilling.remark','EstimateConsultantBilling.discount',
				'EstimateConsultantBilling.no_of_days','EstimateConsultantBilling.days_in_icu','EstimateConsultantBilling.total_amount','PackageEstimate.name',
				'Patient.form_received_on','Patient.id','Patient.package_application_date'),
				'conditions'=>array('EstimateConsultantBilling.patient_id'=>$packagedPatientId)));
		
		$package['EstimateConsultantBilling']['totalDiscount'] = unserialize($package['EstimateConsultantBilling']['discount']);
		if($package['EstimateConsultantBilling']['totalDiscount']['total_discount_package'])
			$package['EstimateConsultantBilling']['totalAmount'] = $package['EstimateConsultantBilling']['totalDiscount']['total_discount_package'];
		else
			$package['EstimateConsultantBilling']['totalAmount'] = $package['EstimateConsultantBilling']['total_amount'];
		
		$totalPackageDays = (int) $package['EstimateConsultantBilling']['no_of_days'] + (int) $package['EstimateConsultantBilling']['days_in_icu'];
		$package['EstimateConsultantBilling']['endDate'] = date('Y-m-d H:i:s', strtotime("+$totalPackageDays day", strtotime($package['Patient']['package_application_date'])));
		$this->set('package' , $package);
		$this->ServiceCategory->unBindModel(array(
				'hasMany' => array('ServiceSubCategory')));
		$this->ServiceCategory->bindModel(array(
				'belongsTo' => array(
						'Billing'=>array('foreignKey' => false,'conditions'=>array('ServiceCategory.id=Billing.payment_category')),
				)),false);
		$packagePayments = $this->ServiceCategory->find('all',array('fields'=>array('Billing.id','Billing.amount','Billing.date','Billing.mode_of_payment',
				'Billing.total_amount','Billing.id','Billing.refund','Billing.paid_to_patient','Billing.discount','Billing.is_deleted'),
				'conditions'=>array('Billing.patient_id'=>$package['Patient']['id'],'ServiceCategory.name'=>'Private Package','Billing.is_deleted'=>0)));
		$this->set('packagePayments',$packagePayments);
	}

	public function get_pharmacy_bill($patient_id){
		//$this->layout = false;
		$this->loadModel('ServiceCategory');
		$this->loadModel('Billing');
		$this->loadModel('PharmacySalesBill');  
		$this->Billing->bindModel(array(
				'belongsTo'=>array(
						'Patient'=>array('foreignKey'=>'patient_id'))));
		//$pharId=$this->ServiceCategory->find('first',array('conditions'=>array('ServiceCategory.name'=>Configure::read('pharmacyservices'))));
		$payment_category = $this->ServiceCategory->getPharmacyId();
		/** We are using Pharma sals Bill to fetch collected amount not Billing - By Mrunal**/ 
		$billingArray=$this->Billing->find('all',array('fields'=>array('Patient.id','Patient.lookup_name','Billing.id','Billing.amount','Billing.discount','Billing.paid_to_patient','Billing.date','Billing.mode_of_payment'),
				'conditions'=>array('Billing.patient_id'=>$patient_id,'Billing.payment_category'=>$payment_category,'OR'=>array('Billing.paid_to_patient > 0', 'Billing.discount > 0','Billing.amount > 0')))); 
		/**/
	
		$salesBillArray = $this->PharmacySalesBill->find('all',array(
									'conditions'=>array('PharmacySalesBill.patient_id'=>$patient_id,'PharmacySalesBill.paid_amnt > 0'),
									'fields'=>array('PharmacySalesBill.*','Patient.id','Patient.lookup_name','Patient.admission_id','Patient.patient_id')));
		 
		$this->set('patientId',$patient_id);
		$this->set('billingArray',$billingArray);
		$this->set('salesBillArray',$salesBillArray);

	}


	/**
	 * function for sevices  add by nurse
	 * @author yashwant chauragade
	 * @param unknown_type $patientId
	 */
	public function addNurseServices($patientId=null){
		/* $this->layout  = 'advance' ;		do not remove ---yashwant
		 $this->loadModel('ServiceCategory');
		$this->uses=array('Patient');
		$this->set('patientId',$patientId);
		/**
		$patientData = $this->Patient->find('first',array('conditions'=>array('id'=>$patientId)));
		$this->set("patientData",$patientData);

		$service_group = $this->ServiceCategory->find('first',array('conditions'=>array('ServiceCategory.name'=>Configure::read('wardprocedure'))));
		$this->set("service_group",$service_group);*/


		$this->set('patientID',$patientId);
		$isNursing='yes';
		$this->set('isNursing',$isNursing);
		$this->set('appoinmentID',$this->params->query['apptId']);
		$this->patient_info($patientId);
		
		$this->set('configInstance',$this->Session->read('website.instance'));
		$this->layout  = 'advance' ;
		$this->uses = array('ServiceCategory','TariffStandard','ServiceProvider','Service','Patient','EstimateConsultantBilling','Account',
				'InventorySupplier','TariffList','Laboratory','Radiology');
		/**********To set patient id in session for new patient hub when patiet in searched from this page- Pooja*********/
		$sessionPatientId=$this->Session->read('hub.patientid');
		if(empty($sessionPatientId) && !empty($id))
			$this->Patient->getSessionPatId($id);
		else{
			if(!empty($id)){
				if($sessionPatientId!=$id)
					$this->Patient->getSessionPatId($id);
			}
		}
		/*********************************************************************************************************/
				
	
		//tariffStandard ID
		$this->Patient->unBindModel(array('hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$tariffStdData = $this->Patient->find('first',array('fields'=>array('id','tariff_standard_id','is_discharge','admission_type','is_packaged','person_id'),
				'conditions'=>array('id'=>$patientId)));
		$this->set('tariffStandardID',$tariffStdData['Patient']['tariff_standard_id']);
		$this->set("isDischarge",$tariffStdData['Patient']['is_discharge']);
			
		if($tariffStdData['Patient']['is_packaged']){
			$packageInstallment = $this->EstimateConsultantBilling->find('first',array('fields'=>array('payment_instruction','patient_id'),
					'conditions'=>array('patient_id'=>$tariffStdData['Patient']['is_packaged'])));
			$this->set('packageInstallment' , unserialize($packageInstallment['EstimateConsultantBilling']['payment_instruction']));
			$this->set('packagedPatientId' , $packageInstallment['EstimateConsultantBilling']['patient_id']);
		}
		//get service dropdown
		$service_group = $this->ServiceCategory->find("all",array(
				"conditions"=>array("ServiceCategory.is_deleted"=>0,"ServiceCategory.is_view"=>1,
						"ServiceCategory.is_enable_for_nursing"=>1,
						"ServiceCategory.location_id"=>$this->Session->read('locationid')),
		));
		$this->set("service_group",$service_group);
		//EOF get service dropdown
			
		$this->set('serviceProviders',$this->ServiceProvider->getServiceProvider('lab'));
		$this->set('radServiceProviders',$this->ServiceProvider->getServiceProvider('radiology'));
			
		$tariffData =$this->TariffStandard->find('list',array('fields'=>array('id','name')));
		$this->set('tariffData',$tariffData);
			
		$this->Account->bindModel(array(
				'belongsTo' => array(
						'AccountingGroup'=>array('foreignKey' => false,'conditions'=>array('AccountingGroup.id=Account.accounting_group_id')),
				)),false);
		$bankData =$this->Account->find('all',array('fields'=>array('id','name'),'conditions'=>array('Account.is_deleted'=>'0',
				'AccountingGroup.name'=>Configure::read('bankLabel'))));
		$bankDataArray = array();
		foreach($bankData as $bank){
			$bankDataArray[$bank['Account']['id']] = $bank['Account']['name'];
		}
		$this->set('bankData',$bankDataArray);

		$this->set('bloodBanks',$this->ServiceProvider->getServiceProvider('blood'));
		$this->set('supliers',$this->InventorySupplier->getSuplier());
		$this->set('cardBal',$this->Account->getCardBalance($tariffStdData['Patient']['person_id']));//for card balance  ---yashwant
		$this->set('allDoctorList',$this->User->getAllDoctorList());//doctor list for drop down in nurse page for dr.  wise revenue  --yashwant
		
		 // for frequently used services
		 
		$this->TariffList->bindModel(array(
				'belongsTo' => array(
						'Laboratory' =>array('foreignKey' => false,'conditions'=>array('Laboratory.tariff_list_id=TariffList.id')),
						'Radiology' =>array('foreignKey' => false,'conditions'=>array('Radiology.tariff_list_id=TariffList.id')),
				)),false);
		
		$result = $this->TariffList->find('all',array('fields'=>array('TariffList.id','TariffList.name','Laboratory.id','Laboratory.name','Radiology.id','Radiology.name'),
				'conditions'=>array('TariffList.enable_for_billing_activity' => '1','TariffList.is_deleted'=>'0'),'group'=>array('TariffList.id')));
		
		foreach ($result as $key => $val){
			if(!empty($val['Laboratory']['id'])){
				$mergeArr[$val['Laboratory']['id']."_LAB"]= $val['TariffList']['name'];
		
			}else if(!empty($val['Radiology']['id'])){
				$mergeArr[$val['Radiology']['id']."_RAD"]= $val['TariffList']['name'];
			}else{
				$mergeArr[$val['TariffList']['id']."_TARIFF"]= $val['TariffList']['name'];
			}
		}
		$this->set('serviceArray',$mergeArr);
	}


	//function to return pharmacy return charges  --yashwant
	function getPharmacyReturnCharges($patient_id=null){
		$this->loadModel('InventoryPharmacySalesReturn');

		
		$pharmacyReturnResult = $this->InventoryPharmacySalesReturn->find('first',array('fields'=>array('SUM(InventoryPharmacySalesReturn.total) as sumTotal',
				'SUM(InventoryPharmacySalesReturn.discount_amount) as sumReturnDiscount'),
				'conditions'=>array('InventoryPharmacySalesReturn.patient_id'=>$patient_id,'InventoryPharmacySalesReturn.is_deleted'=>'0')));
		return $pharmacyReturnResult ; //$pharmacyChargeDetails;
	}

	//function to return substracted pharmacy charges --yashwant
	function getPharmacyFinalCharges($patient_id=null){
		$this->loadModel('PharmacySalesBill');
		$this->loadModel('PharmacyItem');
		$pharmacyChargeDetails = array();
		$this->loadModel('Patient');
		$admissionType = $this->Patient->find('first',array('fields'=>array('Patient.admission_type'),
				'conditions'=>array('Patient.id'=>$patient_id)));

		if($this->Session->read('website.instance')=='kanpur' && $admissionType['Patient']['admission_type']=='IPD'){
			$is_received='1';
		}else{
			$is_received='0';//for kanpur recived by nurse
		}

		
		$pharmacyFinalResult = $this->PharmacySalesBill->find('first',array(
				'fields'=>array('SUM(PharmacySalesBill.total) as total','SUM(PharmacySalesBill.paid_amnt) as paid_amount',
				'SUM(PharmacySalesBill.discount) as discount'),
				'conditions'=>array('PharmacySalesBill.patient_id'=>$patient_id,
						'PharmacySalesBill.is_deleted'=>'0'/* ,'PharmacySalesBill.is_received'=>$is_received */))); // Commented by Mrunal To show charges on billing for Kanpur

		
		$pharmacyReturnCharges = $this->getPharmacyReturnCharges($patient_id);//get return charges to substract from pharmacy bill.
		$pharmacyFinalResult[0]['total']=round($pharmacyFinalResult[0]['total'])-round($pharmacyReturnCharges[0]['sumTotal']);
		
                //to get the the duplicate sales total by Swapnil - 22.02.2016
                $this->loadModel('PharmacyDuplicateSalesBill'); 
                $duplicateTotal = $this->PharmacyDuplicateSalesBill->getTotalAmount($patient_id);
                if(!empty($duplicateTotal)){
                    $pharmacyFinalResult[0]['total'] += $duplicateTotal;
                }
                
		return $pharmacyFinalResult ;
		
	}

	//function to return ward wise patient charges
	function getWardWiseCharges($wardData=array()){

		// pr($wardData);
		if(!$wardData) return false ;
		foreach($wardData['day'] as $key=>$value){
			$wardCost[$value['ward_id']] = $wardCost[$value['ward_id']]+ $value['cost'];
		}
		return $wardCost ;
	}

	//Doctor dashboard
	function doctor_dashboard(){

		//Doctors
		$this->loadModel('User');
		$this->layout = 'advance' ;
		$doctors = $this->User->getDoctorsByLocation($this->Session->read('locationid'));
		$this->set(array('data'=>$data,'doctors'=>$doctors,'nurses'=>$nurses));
		$this->render('doctor_dashboard') ;


	}

	//Ajax rendering for dashboard patient list
	function dashboard_patient_list(){

		//$this->layout = 'ajax' ;
		$this->uses = array('Patient','LaboratoryTestOrder','NoteDiagnosis','NewCropPrescription','EKG','RadiologyTestOrder','User',
				'LaboratoryResult','RadiologyResult','Person','ReviewSubCategoriesOption','ReviewPatientDetail','Appointment','Notes','TariffStandard');
		$this->Patient->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));

		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						'Ward'=>array('foreignKey'=>'ward_id','type'=>'inner'),
						'Room'=>array('foreignKey'=>'room_id'),
						'Bed'=>array('foreignKey'=>'bed_id'),
						'Diagnosis'=>array('foreignKey'=>false,'conditions'=>array('Diagnosis.patient_id=Patient.id','Diagnosis.is_discharge'=>0)),
						'Note'=>array('foreignKey'=>false,
								'conditions'=>array('Note.patient_id=Patient.id')),//,'order'=>array('Note.id'=>'DESC')
						'Person'=>array('foreignKey'=>false,'conditions'=>array('Patient.patient_id = Person.patient_uid')),
						'Billing'=>array('foreignKey'=>false,'conditions'=>array('Patient.id = Billing.patient_id')),
						'OptAppointment'=>array('foreignKey'=>false,
								'conditions'=>array('Patient.id = OptAppointment.patient_id'),
								'fields'=> array('OptAppointment.patient_id','Patient.*')),
						'TariffStandard' => array('primary_key'=>false,
								'conditions'=> array('TariffStandard.id=Patient.tariff_standard_id'),
								'fields'=> array('TariffStandard.name','TariffStandard.id','Patient.*')),
						'CorporateSublocation' => array('foreignKey'=>false,
								'conditions'=> array('CorporateSublocation.id=Patient.corporate_sublocation_id')),
				)),false);

		$rolename = $this->Session->read('role');
		//bof vikas
		$this->Person->bindModel(array(
				'belongsTo'=>array('Patient'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('Patient.patient_id = Person.patient_uid'))),
		));
		$this->Person->bindModel(array(
				'belongsTo'=>array('Appointment'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('Appointment.person_id = Person.id')))
		));


		//eof vikas



		if(!empty($this->request->data['Billings']['All Doctors']) || !empty($this->params->query['doctor_id']) || (strtolower($rolename) == strtolower(Configure::read('doctorLabel')))){
			if(strtolower($rolename) == strtolower(Configure::read('doctorLabel'))){
				$userId = $this->Session->read('userid');
			}else if(!empty($this->params->query['doctor_id'])){
				$userId = $this->params->query['doctor_id'];
				$this->set('paginateArg',$this->params->query['doctor_id']);
			}else{
				$userId = $this->request->data['Billings']['All Doctors'];
				$this->set('paginateArg',$this->request->data['User']['All Doctors']);
			}
			$conditions = array('Patient.location_id'=>$this->Session->read('locationid'),'Patient.doctor_id'=>$userId,'Patient.is_deleted'=>0, 'Patient.is_discharge'=>'0') ;
		}else{
			$conditions = array('Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_deleted'=>0) ;
		}




		if(!empty($this->params->query['dateFrom'])){
			$from = $this->DateFormat->formatDate2STD($this->params->query['dateFrom'],Configure::read('date_format'))." 00:00:00";

		}
		if(!empty($this->params->query['dateTo'])){
			$to = $this->DateFormat->formatDate2STD($this->params->query['dateTo'],Configure::read('date_format'))." 23:59:59";
		}

	if(!empty($this->params->query['data']['User']['Discharged']) && $this->params->query['data']['User']['Discharged']==1 ){
		//if discharge chekbox is checked condition on discharge date
			if($to)
				$conditions['Patient.discharge_date <='] = $to;
			if($from)
				$conditions['Patient.discharge_date >='] = $from;
		}else{
			if($to)
				$conditions['Patient.form_received_on <='] = $to;
			if($from)
				$conditions['Patient.form_received_on >='] = $from;
		}

		//Should not show discharged patient on patient list .. will be seen only in search...
		if(empty($this->request->data['Billings']['Patient Name']) && empty($this->params->query['doctorsId']) && empty($this->params->query['dateTo']) && empty($this->params->query['dateFrom']) && empty($this->params->query['data']['Billings']['Discharged']))
			$conditions['Patient.is_discharge']='0';


		//$flag='no'; swa
		if(!empty($this->params->query['data']['Billings']['Discharged']) && $this->params->query['data']['Billings']['Discharged']==1 ){
			$conditions['Patient.location_id']=$this->Session->read('locationid');
			$this->request->data['Patient']['is_deleted']='0';
			$this->request->data['Patient']['is_discharge']='1';
			$conditions['Patient.is_discharge']='1';
			$conditions['Patient.is_deleted']='0';
			$lookup=explode('-',$this->params->query['data']['Billings']['Patient Name']);
			$conditions['Patient.lookup_name LIKE'] =  "%".$lookup[0]."%";
			//$flag='yes';
		}

		if(isset($this->request->data['Billings']['Patient Name']) && !empty($this->request->data['Billings']['Patient Name'])){
			$lookup=explode('-',$this->request->data['Billings']['Patient Name']);
			$conditions['Patient.lookup_name LIKE'] =  "%".$lookup[0]."%";

		}
		
		if($this->params->query['doctorsId']){

			$docArray=explode('_',$this->params->query['doctorsId']);
			$docArray=implode(',',$docArray);
			if(!empty($docArray)){
				$conditions['Patient.doctor_id IN']=$docArray;
			}
			$rt='1';
			$this->set('rtSelect',$rt);
		}

		/** Soap Note lated **/
		//$conditions['Note.compelete_note'] ='0';
		/** **/
		$this->paginate = array(
				'limit' => '10',
				'fields'=> array('Patient.id','Patient.lookup_name','Patient.sex','Ward.name','Room.bed_prefix','Bed.bedno','Patient.age',

						'Patient.form_received_on','Diagnosis.id','Patient.person_id','Note.id','Note.sign_note','Billing.total_amount',
						'Billing.amount_paid','Billing.amount_pending','Billing.patient_id','Patient.is_discharge','Patient.admission_id',
						'Patient.admission_id','Patient.form_received_on','Patient.dashboard_level','Patient.dashboard_status',
						'Patient.nurse_id','Patient.doctor_id','Person.sex','Person.vip_chk','Note.id','Note.sign_note','CorporateSublocation.name',
						'OptAppointment.patient_id',/*,'Appointment.purpose'*/
						'TariffStandard.name'),
				/*'order'=>array('Ward.sort_order'),*/
				'conditions'=>array($conditions),'order' => array('Ward.sort_order' => 'ASC'/*,'Patient.form_received_on'*/),
				'group'=>('Patient.id'));
		$data = $this->paginate('Patient') ;

		if(!empty($data)){
			foreach($data as $patientKey => $patientValue){
				$ids[] = $patientValue['Patient']['id'] ;
				$customArray[$patientValue['Patient']['id']]['Patient'] = $patientValue ;
			}
			$idsStr = implode(",",$ids) ;

			/*$labOrderData = $this->LaboratoryTestOrder->find('all',array('fields'=>array('Count(*) as lab','patient_id'),
			 'conditions'=>array("LaboratoryTestOrder.patient_id IN ($idsStr)"),
					'group'=>array('LaboratoryTestOrder.patient_id')));

			$radOrderData = $this->RadiologyTestOrder->find('all',array('fields'=>array('Count(*) as rad','patient_id'),
					'conditions'=>array("RadiologyTestOrder.patient_id IN ($idsStr)"),
					'group'=>array('RadiologyTestOrder.patient_id')));

			$noteDiagnosisData = $this->NoteDiagnosis->find('all',array('fields'=>array('NoteDiagnosis.diagnoses_name','NoteDiagnosis.patient_id'),
					'conditions'=>array("NoteDiagnosis.patient_id IN ($idsStr)"),'order'=>array('NoteDiagnosis.id DESC') ));

			$medData = $this->NewCropPrescription->find('all',array('fields'=>array('Count(NewCropPrescription.drug_name) as med','patient_uniqueid'),
					'conditions'=>array('NewCropPrescription.archive'=>"N", "NewCropPrescription.patient_uniqueid IN ($idsStr)"),
					'group'=>array('NewCropPrescription.patient_id')));

			$ekgData = $this->EKG->find('all',array('fields'=>array('Count(*) as ekg','patient_id'),'conditions'=>array("EKG.patient_id IN ($idsStr)"),
					'group'=>array('EKG.patient_id')));

			$labResultData = $this->LaboratoryResult->find('all',array('fields'=>array('Count(*) as labResult','patient_id'),
					'conditions'=>array("LaboratoryResult.patient_id IN ($idsStr)"),
					'group'=>array('LaboratoryResult.patient_id')));

			$radResultData = $this->RadiologyResult->find('all',array('fields'=>array('Count(*) as radResult','patient_id'),
					'conditions'=>array("RadiologyResult.patient_id IN ($idsStr)"),
					'group'=>array('RadiologyResult.patient_id')));

			$this->ReviewPatientDetail->bindModel(array(
					'belongsTo'=>array(
							'ReviewSubCategoriesOption'=>array('foreignKey'=>false,
									'conditions'=>array('ReviewPatientDetail.review_sub_categories_options_id = ReviewSubCategoriesOption.id'),
							))),false);
			$vitalsData = $this->ReviewPatientDetail->find('all',array('fields'=>array('DISTINCT (ReviewSubCategoriesOption.name) AS name',
					'ReviewPatientDetail.patient_id','ReviewPatientDetail.values','ReviewSubCategoriesOption.unit'),
					'conditions'=>array("ReviewPatientDetail.patient_id IN ($idsStr)",//'ReviewPatientDetail.date' => date('Y-m-d'),
							'ReviewSubCategoriesOption.name' => Configure::read('vitals_for_tracking_board'),'ReviewPatientDetail.edited_on' => NULL),
					'order'=>array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC' )
			));

			foreach($labOrderData as $labKey => $labValue){
			$customArray[$labValue['LaboratoryTestOrder']['patient_id']]['LaboratoryTestOrder'] = $labValue[0] ;
			}
			foreach($radOrderData as $labKey => $labValue){
			$customArray[$labValue['RadiologyTestOrder']['patient_id']]['RadiologyTestOrder'] = $labValue[0] ;
			}
			foreach($noteDiagnosisData as $labKey => $labValue){
			$customArray[$labValue['NoteDiagnosis']['patient_id']]['NoteDiagnosis']  =  $labValue['NoteDiagnosis']  ;
			}
			foreach($medData as $labKey => $labValue){
			$customArray[$labValue['NewCropPrescription']['patient_uniqueid']]['NewCropPrescription'] = $labValue[0] ;
			}
			foreach($ekgData as $labKey => $labValue){
			$customArray[$labValue['EKG']['patient_id']]['EKG'] = $labValue[0] ;
			}
			foreach($labResultData as $labKey => $labValue){
			$customArray[$labValue['LaboratoryResult']['patient_id']]['LaboratoryResult'] = $labValue[0] ;
			}
			foreach($radResultData as $labKey => $labValue){
			$customArray[$labValue['RadiologyResult']['patient_id']]['RadiologyResult'] = $labValue[0] ;
			}
			foreach($vitalsData as $vitals){
			$customArray[$vitals['ReviewPatientDetail']['patient_id']]['vitalData'][$vitals['ReviewSubCategoriesOption']['name']] =
			$vitals['ReviewPatientDetail']['values'].' '.$vitals['ReviewSubCategoriesOption']['unit'] ;
			}*/
			$doctors = $this->User->getDoctorsByLocation($this->Session->read('locationid'));
			$nurses  = $this->User->getUsersByRoleName(Configure::read('nurseLabel')) ;
		}
		$this->set(array('data'=>$customArray,'doctors'=>$doctors,'nurses'=>$nurses));
	}

	function finalDischargeJV($patientId,$singleBill){
		$this->loadModel('Billing');
		$this->loadModel('ServiceBill');
		$this->loadModel('ConsultantBilling');
		$this->loadModel('OptAppointment');
		$this->loadModel('PharmacySalesBill');
		
		$this->Billing->JVLabData($patientId);
		$this->Billing->JVRadData($patientId);
		$this->ServiceBill->JVServiceData($patientId);
		$this->ConsultantBilling->JVConsultantData($patientId);
		$this->OptAppointment->JVSurgeryData($patientId);
		$this->PharmacySalesBill->JVSaleBillData($patientId);
		
		/* if(!$singleBill){
			$this->Billing->JVLabData($patientId);
			$this->Billing->JVRadData($patientId);
			$this->ServiceBill->JVServiceData($patientId);
			$this->ConsultantBilling->JVConsultantData($patientId);
			$this->OptAppointment->JVSurgeryData($patientId);
			$this->PharmacySalesBill->JVSaleBillData($patientId);
		} */
	}
	/**
	 * function for service wise payment, changing billing
	 * @param unknown_type $patientId
	 */
	function dummyAjaxBillReceipt($patientId=null){
		$this->layout = 'ajax';
		$this->ajaxBillReceipt($patientId);
		
	}
	
	function dummyAjaxServiceData($patientId=null){
		$this->layout = 'ajax';
		$this->ajaxServiceData($patientId);
	
	}
	
	function dummyAjaxLabData($patientId=null){
		$this->layout = 'ajax';
		$this->ajaxLabData($patientId);
	
	}
	
	function dummyAjaxRadData($patientId=null){
		$this->layout = 'ajax';
		$this->ajaxRadData($patientId);
	
	}
	
	function dummyAjaxImplantData($patientId=null,$groupID=null){
		$this->layout = 'ajax';
		$this->ajaxImplantData($patientId,$groupID);
	
	}
	
	function dummyAjaxBloodData($patientId=null,$groupID=null){
		$this->layout = 'ajax';
		$this->ajaxBloodData($patientId,$groupID);
	
	}
	
	function dummyAjaxPharmacyData($patientId=null){
		$this->layout = 'ajax';
		$this->ajaxPharmacyData($patientId);
	
	}
	
	function dummyAjaxProcedureData($patientId=null){
		$this->layout = 'ajax';
		$this->ajaxProcedureData($patientId);
	
	}
	
	function dummyAjaxDailyroomData($patientId=null){
		$this->layout = 'ajax';
		$this->ajaxDailyroomData($patientId);
	
	}
	
	function dummyAjaxConsultationData($patientId=null){
		$this->layout = 'ajax';
		$this->ajaxConsultationData($patientId);
	
	}
	
	function dummyAjaxWardProcedureData($patientId=null){
		$this->layout = 'ajax';
		$this->ajaxWardProcedureData($patientId);
	
	}
	
	
	/**
	 * function for spot implant payment
	 * @param unknown_type $patientId
	 */
	function spotImplantPayment($patientId=null,$consultantId=null,$return=false){ 
		$this->layout='advance_ajax';
		$this->set('patientID',$patientId);
		$this->uses = array('Patient','Billing','ServiceCategory','Configuration','ServiceBill','LaboratoryTestOrder','OptAppointment',
				'PharmacySalesBill','ConsultantBilling','RadiologyTestOrder','Consultant','Account');
		
		$this->Patient->unbindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array('belongsTo'=>array(
				'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id=Patient.person_id')),
				)));
		
		$patientData=$this->Patient->find('first',array('fields'=>array('Person.consultant_id','Patient.consultant_id','Patient.ethnicity_id',
		'Patient.spot_date','Patient.b_date','Patient.is_discharge','Patient.spot_amount','Patient.b_amount'),
				'conditions'=>array('Patient.id'=>$patientId)));
		$patientConsultantId=unserialize($patientData['Patient']['consultant_id']);
		$this->set('patientData',$patientData);
		//$patientConsultantId=1;
		$this->set('cashList',$this->Account->getGroupByAccountList(Configure::read('cash')));
		
	    $consultantNameArr=$this->Consultant->find('list', array('fields'=> array('id', 'full_name'),'conditions' => array('Consultant.id'=>$patientConsultantId,'Consultant.is_deleted' => 0,
	    		  'Consultant.location_id' => $this->Session->read('locationid')),'order'=>array('Consultant.first_name')));
		$this->set('consultantNameArr',$consultantNameArr);
		
		if($this->request->data){
			$spot_date=$this->DateFormat->formatDate2STD($this->request->data['Patient']['spot_date'],Configure::read('date_format'));
			$b_date=$this->DateFormat->formatDate2STD($this->request->data['Patient']['b_date'],Configure::read('date_format'));
		
			$spotAmt=$patientData['Patient']['spot_amount']+$this->request->data['Patient']['spot_amount'];
			$b_amount=$patientData['Patient']['b_amount']+$this->request->data['Patient']['b_amount'];
			$updateArray=array('Patient.spot_amount'=>"'".$spotAmt."'",'Patient.b_amount'=>"'".$b_amount."'",
					'Patient.spot_date'=>"'".$spot_date."'",'Patient.b_date'=>"'".$b_date."'");
			if($this->Patient->updateAll($updateArray,array('Patient.id'=>$this->request->data['Patient']['patient_id']))){
				$this->set('isSuccess','yes');
				$this->AutomaticPaymentVoucher($this->request->data);
			}
		
		}
		
			if(isset($consultantId) && !empty($consultantId)){
				$this->autoRender = false;
				$consultantCount=count($consultantNameArr);
				$conProPercentage=$this->Consultant->find('first',array('fields'=>array('id','profit_percentage','referal_spot_amount'),
						'conditions'=>array('Consultant.id'=>$consultantId/*$patientData['Patient']['consultant_id']*/)));
				
				//Final Bill and Billing charges calculations for profit referral
				$pharmacyCategoryId=$this->ServiceCategory->getPharmacyId();//in case need of pharmacy category ID
				$pharmConfig=$this->Configuration->getPharmacyServiceType();// to get pharmacy service type
				// url flag to show pharmacy charges -- Pooja
				if($this->params->query['showPhar']){
					$pharmConfig['addChargesInInvoice']='yes';
				}
				if($pharmConfig['addChargesInInvoice']=='yes'){
					$BillingAmt=$this->Billing->find('first',array('fields'=>array('Billing.patient_id',
							'Sum(Billing.amount) as paid','Sum(Billing.discount) as discount','Sum(Billing.paid_to_patient) as refund'),
							'conditions'=>array('Billing.patient_id'=>$patientId
									,'Billing.is_deleted'=>'0'),
							'group'=>array('Billing.patient_id')));
				}else{
					$BillingAmt=$this->Billing->find('first',array('fields'=>array('Billing.patient_id',
							'Sum(Billing.amount) as paid','Sum(Billing.discount) as discount','Sum(Billing.paid_to_patient) as refund'),
							'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.payment_category !='=>$pharmacyCategoryId
									,'Billing.is_deleted'=>'0'),
							'group'=>array('Billing.patient_id')));
				}
				//Combine charges for blood and implant
				$bloodImpAmt=$this->ServiceBill->find('first',array('fields'=>array('ServiceBill.patient_id','ServiceBill.service_id','ServiceBill.no_of_times',
						'Sum(ServiceBill.amount * ServiceBill.no_of_times) as bloodCharges',),
						'conditions'=>array('ServiceBill.patient_id'=>$patientId,
								'ServiceBill.service_id'=>array($implantId['ServiceCategory']['id'],$bloodId['ServiceCategory']['id'])
								,'ServiceBill.is_deleted'=>'0'),
						'group'=>array('ServiceBill.patient_id')));
				
				$labAmt=$this->LaboratoryTestOrder->find('first',array('fields'=>array('LaboratoryTestOrder.patient_id',
						'Sum(LaboratoryTestOrder.amount) as labCharges','Sum(LaboratoryTestOrder.paid_amount) as labPaid'),
						'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patientId
								,'LaboratoryTestOrder.is_deleted'=>'0'),
						'group'=>array('LaboratoryTestOrder.patient_id')));
				
				$surgeonAmt=$this->OptAppointment->find('first',array('fields'=>array('OptAppointment.patient_id',
						'Sum(OptAppointment.cost_to_hospital) as surgeonCharges','Sum(OptAppointment.anaesthesia_cost) as anaesthesiaCharges'),
						'conditions'=>array('OptAppointment.patient_id'=>$patientId
								,'OptAppointment.is_deleted'=>'0'),
						'group'=>array('OptAppointment.patient_id')));
				// url flag to show pharmacy charges -- Pooja
				if($this->params->query['showPhar']){
					$pharmConfig['addChargesInInvoice']='yes';
				}
				if($pharmConfig['addChargesInInvoice']=='yes'){
					$this->PharmacySalesBill->unbindModel(array('belongsTo'=>array('Patient')));
					$pharmacyAmt=$this->PharmacySalesBill->find('all',array('fields'=>array('PharmacySalesBill.patient_id',
							'Sum(PharmacySalesBill.total) as pharmacyCharges'),
							'conditions'=>array('PharmacySalesBill.patient_id'=>$patientId
									,'PharmacySalesBill.is_deleted'=>'0'),
							'group'=>array('PharmacySalesBill.patient_id')));
				}
				
				$visitAmt=$this->ConsultantBilling->find('first',array('fields'=>array('ConsultantBilling.patient_id',
						'Sum(ConsultantBilling.amount) as visitCharges'),
						'conditions'=>array('ConsultantBilling.patient_id'=>$patientId),
						'group'=>array('ConsultantBilling.patient_id')));
				
				$this->RadiologyTestOrder->bindModel(array('belongsTo'=>array(
						'Radiology'=>array('foreignKey'=>false,'conditions'=>array('Radiology.id=RadiologyTestOrder.radiology_id')))));
				
				$radAmt=$this->RadiologyTestOrder->find('first',array('fields'=>array('RadiologyTestOrder.patient_id',
						'Sum(RadiologyTestOrder.amount) as radCharges','Sum(RadiologyTestOrder.paid_amount) as radPaid'),
						'conditions'=>array('OR'=>array(array('Radiology.name LIKE'=>'CT%'),array('Radiology.name LIKE'=>'MRI%'),array('Radiology.name LIKE'=>'USG%')),'RadiologyTestOrder.patient_id'=>$patientId
								,'RadiologyTestOrder.is_deleted'=>'0'),
						'group'=>array('RadiologyTestOrder.patient_id')));
				
				$paidBill=$patientBillData['amount_paid']=$BillingAmt['0']['paid'];
				$discountBill=$patientBillData['discount']=$BillingAmt['0']['discount'];
				$refundBill=$patientBillData['refund']=$BillingAmt['0']['refund'];
				$radioBill=$patientBillData['radCharges']=$radAmt['0']['radCharges'];
				$radiopaidBill=$patientBillData['rad_amount_paid']=$radAmt['0']['radPaid'];
				$labBill=$patientBillData['labCharges']=$labAmt['0']['labCharges'];
				$labpaidBill=$patientBillData['lab_amount_paid']=$labAmt['0']['labPaid'];
				$bloodImpBill=$patientBillData['BloodImplantCharges']=$bloodImpAmt['0']['bloodCharges'];
				$pharBill=$patientBillData['pharmacyCharges']=$pharmacyAmt['0']['pharmacyCharges'];
				$visitBill=$patientBillData['visitCharges']=$visitAmt['0']['visitCharges'];
				$surgeonBill=$patientBillData['surgeonCharges']=$surgeonAmt['0']['surgeonCharges'];
				$aneasBill=$patientBillData['anaesthesiaCharges']=$surgeonAmt['0']['anaesthesiaCharges'];
					
				if(!empty($paidBill)){
					//Deducting spot amount of referal as per discussion with Murli Sir - Pooja
					/* The amount will be calculated after deducting spot amount of referal from paid bill */
					$paidBill=$paidBill-$conProPercentage['Consultant']['referal_spot_amount'];

					$excludingExpenses=$paidBill-(/*$discountBill+*/$radioBill+$labBill+$bloodImpBill+$pharBill/*+$visitBill+$surgeonBill+$aneasBill*/);
					if($consultantCount>1){
						 $profitReferal=$excludingExpenses*(20/100); // if consultant more than 1 then profit percentage is 20 as per Dr.Murli- Atul
					}else{
						$profitReferal=$excludingExpenses*($conProPercentage['Consultant']['profit_percentage']/100);
					}
					
				}
				
				$this->Patient->unbindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
				$this->Patient->bindModel(array('belongsTo'=>array(
						'VoucherPayment'=>array('foreignKey'=>false,'conditions'=>array('VoucherPayment.patient_id=Patient.id',
								'VoucherPayment.type'=>'RefferalCharges'/* ,'OR'=>array(array('VoucherPayment.narration LIKE'=>'% spot %'),array('VoucherPayment.narration LIKE'=>'% backing %')) */)),
						'SpotApproval'=>array('foreignKey'=>false,'conditions'=>array('SpotApproval.voucher_payment_id=VoucherPayment.id')),
						'Account'=>array('foreignKey'=>false,'conditions'=>array('VoucherPayment.user_id=Account.id','Account.user_type'=>'Consultant')),
				)));
				
				$sBAmt=$this->Patient->find('all',array('fields'=>array('Patient.id','SpotApproval.*','VoucherPayment.*'),
						'conditions'=>array('VoucherPayment.patient_id'=>$patientId,
								'VoucherPayment.is_deleted'=>'0','Account.system_user_id'=>$consultantId)));
				
				$advanceAmntSb=$this->Patient->find('first',array('fields'=>array('Patient.id','Patient.spot_amount','Patient.b_amount','Patient.b_date','Patient.spot_date'),
						'conditions'=>array('Patient.id'=>$patientId)));
				
				$retuData = array('profitBillData'=>$profitReferal,'sAmount'=>$conProPercentage['Consultant']['referal_spot_amount'],
						               'sBAmt'=>$sBAmt,'consultantCount'=>$consultantCount,'advanceAmntSb'=>$advanceAmntSb);
				if($return == true){
					return $retuData;
				}else{
					echo json_encode($retuData);
					exit;
				}
			}
			
	}
	
	function AutomaticPaymentVoucher($requestData){
		
		$this->loadModel('Account');
		$this->loadModel('VoucherLog');
		$this->loadModel('VoucherPayment');
		$this->loadModel('Patient');
		$this->loadModel('Consultant');
		$this->loadModel('VoucherEntry');
		
		if(!empty($requestData['Patient']['patient_id'])){
			//find person id for updation amount of services and also used some details for narration
			$getPatientDetails=$this->Patient->find('first',array('conditions'=>array('Patient.id'=>$requestData['Patient']['patient_id']),
					'fields'=>array('person_id','lookup_name','form_received_on','consultant_id')));
			//find consultant first name and last name for create accounting ledger
			$consultantDetails = $this->Consultant->find('first',array('fields'=>array('Consultant.first_name','Consultant.last_name',
					'Consultant.market_team'),'conditions'=>array('Consultant.is_deleted'=>'0',
							'Consultant.id'=>$requestData['Patient']['consultant_id'])));
			$consultantName = $consultantDetails['Consultant']['first_name']." ".$consultantDetails['Consultant']['last_name'];
			$userId = $this->Account->getUserIdOnly($requestData['Patient']['consultant_id'],'Consultant',$consultantName);
			
			$cashId = $requestData['Patient']['account_id'];//for cash id
			$patientName = $getPatientDetails['Patient']['lookup_name'];
			if(($requestData['Patient']['spot_amount']!=0) && (!empty($requestData['Patient']['spot_amount']))){
				$sname = 'Spot Charges';
				$sdoneDate  =  $requestData['Patient']['spot_date'];
				$samount = $requestData['Patient']['spot_amount'];
			}else
			if(($requestData['Patient']['b_amount']!=0) && (!empty($requestData['Patient']['b_amount']))){
				$bname = 'Backing Charges';
				$bdoneDate  =  $requestData['Patient']['b_date'];
				$bamount = $requestData['Patient']['b_amount'];
			}
			
			//for narration set
			if(!empty($userId)){
				if(!empty($sname)){
					$narration='';
					$date = $this->DateFormat->formatDate2STD($sdoneDate,Configure::read('date_format'));
					//$narration = "Being cash paid to Dr. $consultantName towards $sname pt. $patientName done on $sdoneDate";
					$narration = "Being cash paid for implant purchase against patient $patientName on $sdoneDate";
					$voucherLogDataPay=$pvData = array('date'=>$date,
							'modified_by'=>$this->Session->read('userid'),
							'create_by'=>$this->Session->read('userid'),
							'account_id'=>$cashId,
							'patient_id'=>$requestData['Patient']['patient_id'],
							'type'=>'RefferalCharges',
							'user_id'=>$userId,
							'narration'=>$narration,
							'paid_amount'=>$samount);
					if(!empty($pvData['paid_amount']) && ($pvData['paid_amount'] != 0)){
						$lastVoucherIdPayment=$this->VoucherPayment->insertPaymentEntry($pvData);
						// ***insert into Account (By) credit manage current balance
						$this->Account->setBalanceAmountByAccountId($cashId,$samount,'debit');
						$this->Account->setBalanceAmountByUserId($userId,$samount,'credit');
						//insert into voucher_logs table added by PankajM
						$voucherLogDataPay['voucher_no']=$lastVoucherIdPayment;
						$voucherLogDataPay['voucher_id']=$lastVoucherIdPayment;
						$voucherLogDataPay['voucher_type']="Payment";
						$this->VoucherLog->insertVoucherLog($voucherLogDataPay);
						$this->VoucherLog->id= '';
						$this->VoucherPayment->id= '';
					}
					
					//for dummy payment entry (Hope hopital)
					$marketName = $consultantDetails['Consultant']['market_team'];
					$narration = "$marketName $patientName done on $sdoneDate";
					$mlId = $this->Account->getAccountIdOnly(Configure::read('mlEnterprise'));//for cash id
						$dpvData = array('date'=>$date,
							'modified_by'=>$this->Session->read('userid'),
							'create_by'=>$this->Session->read('userid'),
							'account_id'=>$cashId,
							'patient_id'=>$requestData['Patient']['patient_id'],
							'batch_identifier'=>$lastVoucherIdPayment,
							'type'=>'MLCharges',
							'user_id'=>$mlId,
							'narration'=>$narration,
							'paid_amount'=>$samount);
					if(!empty($dpvData['paid_amount']) && ($dpvData['paid_amount'] != 0)){
						$this->VoucherPayment->insertPaymentEntry($dpvData);
						// ***insert into Account (By) credit manage current balance
						$this->Account->setBalanceAmountByAccountId($mlId,$samount,'debit');
						$this->VoucherPayment->id= '';
					}
					$this->loadModel('SpotApproval');
					$type='S';
					$this->SpotApproval->save(
							array(	'voucher_payment_id'=>$lastVoucherIdPayment,
									'patient_id'=>$requestData['Patient']['patient_id'],
									'amount'=>$samount,
									'type'=>$type,
									'consultant_id'=>$requestData['Patient']['consultant_id'],
									'create_time'=>date('Y-m-d H:i:s'),
							)
					);
					$this->SpotApproval->id= '';
					$lastVoucherIdPayment='';
					
					//JV Entry for spot
					$implantPurchaseId = $this->Account->getAccountIdOnly(Configure::read('implantPurchaseLabel'));//for cash id
					$jvData = array('date'=>$date,
							'account_id'=>$implantPurchaseId,
							'user_id'=>$mlId,
							'created_by'=>$this->Session->read('userid'),
							'type'=>'MLJV',
							'narration'=>$narration,
							'debit_amount'=>$samount);
					if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
						$this->VoucherEntry->insertJournalEntry($jvData);
						$this->VoucherEntry->id ='';
						// ***insert into Account (By) credit manage current balance
						$this->Account->setBalanceAmountByAccountId($implantPurchaseId,$samount,'debit');
						$this->Account->setBalanceAmountByUserId($mlId,$samount,'credit');
					}
					//EOF JV
				}//EOF sAmount
				
				if($bname){$narration='';
					$bdate = $this->DateFormat->formatDate2STD($bdoneDate,Configure::read('date_format'));
					//$narration = "Being cash paid to Dr. $consultantName towards $bname pt. $patientName done on $sdoneDate";
					$narration = "Being cash paid for implant purchase against patient $patientName on $sdoneDate";
					$voucherLogDataPay=$pvData = array('date'=>$bdate,
							'modified_by'=>$this->Session->read('userid'),
							'create_by'=>$this->Session->read('userid'),
							'account_id'=>$cashId,
							'patient_id'=>$requestData['Patient']['patient_id'],
							'type'=>'RefferalCharges',
							'user_id'=>$userId,
							'narration'=>$narration,
							'paid_amount'=>$bamount);
					if(!empty($pvData['paid_amount']) && ($pvData['paid_amount'] != 0)){
						$lastVoucherIdPayment=$this->VoucherPayment->insertPaymentEntry($pvData);
						// ***insert into Account (By) credit manage current balance
						$this->Account->setBalanceAmountByAccountId($cashId,$bamount,'debit');
						$this->Account->setBalanceAmountByUserId($userId,$bamount,'credit');
						//insert into voucher_logs table added by PankajM
						$voucherLogDataPay['voucher_no']=$lastVoucherIdPayment;
						$voucherLogDataPay['voucher_id']=$lastVoucherIdPayment;
						$voucherLogDataPay['voucher_type']="Payment";
						$this->VoucherLog->insertVoucherLog($voucherLogDataPay);
						$this->VoucherLog->id= '';
						$this->VoucherPayment->id= '';
					}
						
					//for dummy payment entry (Hope hopital)
					$marketName = $consultantDetails['Consultant']['market_team'];
					$narration = "$marketName $patientName done on $bdoneDate";
					$mlId = $this->Account->getAccountIdOnly(Configure::read('mlEnterprise'));//for cash id
					$dpvData = array('date'=>$bdate,
							'modified_by'=>$this->Session->read('userid'),
							'create_by'=>$this->Session->read('userid'),
							'account_id'=>$cashId,
							'patient_id'=>$requestData['Patient']['patient_id'],
							'batch_identifier'=>$lastVoucherIdPayment,
							'type'=>'MLCharges',
							'user_id'=>$mlId,
							'narration'=>$narration,
							'paid_amount'=>$bamount);
					if(!empty($dpvData['paid_amount']) && ($dpvData['paid_amount'] != 0)){
						$this->VoucherPayment->insertPaymentEntry($dpvData);
						// ***insert into Account (By) credit manage current balance
						$this->Account->setBalanceAmountByAccountId($mlId,$bamount,'debit');
						$this->VoucherPayment->id= '';
					}
					$this->loadModel('SpotApproval');
					$type='B';
					$this->SpotApproval->save(
							array(	'voucher_payment_id'=>$lastVoucherIdPayment,
									'patient_id'=>$requestData['Patient']['patient_id'],
									'amount'=>$bamount,
									'type'=>$type,
									'consultant_id'=>$requestData['Patient']['consultant_id'],
									'create_time'=>date('Y-m-d H:i:s'),
							)
					);
					$this->SpotApproval->id= '';
					$lastVoucherIdPayment='';
					
					//JV Entry for spot
					$implantPurchaseId = $this->Account->getAccountIdOnly(Configure::read('implantPurchaseLabel'));//for cash id
					$jvData = array('date'=>$bdate,
							'created_by'=>$this->Session->read('userid'),
							'account_id'=>$implantPurchaseId,
							'user_id'=>$mlId,
							'type'=>'MLJV',
							'narration'=>$narration,
							'debit_amount'=>$bamount);
					if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
						$this->VoucherEntry->insertJournalEntry($jvData);
						$this->VoucherEntry->id ='';
						// ***insert into Account (By) credit manage current balance
						$this->Account->setBalanceAmountByAccountId($implantPurchaseId,$bamount,'debit');
						$this->Account->setBalanceAmountByUserId($mlId,$bamount,'credit');
					}
					//EOF JV
				}//EOF b_amount
			}
		}
		return $lastVoucherIdPayment;
	}
 

	//function to post daily ward units by pankaj w
	function postWardUnits(){ 
		//for daily room charges
		$this->loadModel('Location');
		$this->loadModel('Patient');
		$this->loadModel('WardPatientService');
		$this->loadModel('ServiceCategory'); 
		$locations = $this->Location->find('list',array('fields'=>array('name'),'conditions'=>array('Location.is_active'=>1,'Location.is_deleted'=>0))); 
		$serviceCategoryId = $this->ServiceCategory->getServiceGroupId('RoomTariff');//find room tariff service category
		$this->Patient->unBindModel(array(
					'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		foreach($locations as $locationKey => $locationsVal){
			$this->Patient->recursive = 0 ;
			$patients =$this->Patient->find('all',array('fields'=>array('Patient.id','Patient.tariff_standard_id','Patient.lookup_name'),
					'conditions'=>array('Patient.admission_type'=>'IPD','Patient.is_discharge'=>0,'Patient.location_id'=>$locationKey,'Patient.is_deleted'=>0),'order'=>array('Patient.id Desc'))); 

			foreach($patients as $patientKey => $patientVal){ 
				 
				$roomTariff = $this->getDay2DayCharges($patientVal['Patient']['id'],$patientVal['Patient']['tariff_standard_id'],false,$locationKey); 
				 
				//extra element add for testinf purpose
				$roomTariff['Patient']['name']  = $patientVal['Patient']['lookup_name'];
				 
				//delete already added service for ward
				$this->WardPatientService->deleteAll(array('WardPatientService.patient_id'=>$patientVal['Patient']['id']/*,'WardPatientService.service_id'=>$serviceCategoryId*/
				,'DATE_FORMAT(WardPatientService.date,"%Y-%m-%d")'=>date('Y-m-d') ));
				if(is_array($roomTariff)){ 
					foreach($roomTariff as $key =>$value){   
						if(!$value['start']){
							if(is_array($value)){
								foreach($value[key($value)]  as $wardKey =>$wardValue){  
									//split date time
									$splittedInTime = explode(" ",$wardValue['in']);
									if(strtotime($splittedInTime[0])==strtotime(date('d-m-Y'))){ 
										if($this->Location->getCheckoutTime() != "24 hours"){
											$wardInDate = $this->DateFormat->formatDate2STD($splittedInTime[0],Configure::read('date_format'))	 ;
										}else{
											$wardInDate = $splittedInTime[0];
										}
										if(!empty($wardValue['ward_id'])){ 
											$insertArray[] = array(
													'date'=>$wardInDate,
													'location_id'=>$locationKey,
													'tariff_standard_id'=>$patientVal['Patient']['tariff_standard_id'],//no need to add this
													'create_time'=>date('Y-m-d H:i:s'),
													'created_by'=>2,//as system user
													'patient_id'=>$patientVal['Patient']['id'],
													'tariff_list_id'=>$wardValue['service_id'],
													'ward_id'=>$wardValue['ward_id'],
													'amount'=>$wardValue['cost'],
													'service_id'=>$serviceCategoryId //service group id
											); 
										}
									}
							}
							
						}
						
					 	}
					}//EOF roomtariff foreach
					
				}//EOF IF
				
				$collectAllPatientData[] = $roomTariff ;  
				$roomTariff = '';
			}//EOF patient foreach			
		}
		 
		if($insertArray){
			$this->WardPatientService->saveAll($insertArray);
			$this->WardPatientService->id= '';
		}

 
		$this->set('collectAllPatientData',$collectAllPatientData);
		$this->compareWardCost();
		$this->render('compareWardCost');
	}

	function compareWardCost(){
		$this->loadModel('Patient');
		$this->loadModel('WardPatientService');
		/*$this->Patient->unBindModel(array(
					'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));*/
		$this->WardPatientService->bindModel(array('belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
			'TariffList'=>array('foreignKey'=>false,'conditions'=>array('WardPatientService.tariff_list_id=TariffList.id')))));

		$patientWardUnits =$this->WardPatientService->find('all',array('fields'=>array('Patient.id','Patient.tariff_standard_id','Patient.lookup_name','WardPatientService.*','TariffList.name'),'conditions'=>array('Patient.admission_type'=>'IPD','Patient.is_discharge'=>0,'Patient.location_id'=>1,'Patient.is_deleted'=>0),'order'=>array('WardPatientService.patient_id','WardPatientService.date')));  
		$this->set('patientWardUnits',$patientWardUnits); 
	}

	
	//by pankaj to calculate ward charges as per new calculation  
	function wardCharges($patient_id=null){
		if(!$patient_id) return array();
		$this->loadModel('WardPatientService');   
		$newWardChargesArray = $this->WardPatientService->getWardCharges($patient_id);		 
		return $newWardChargesArray ; 
	}
	
	/**
	 * Delete Spot Or Backing Amount
	 * @param int $voucherId
	 * @param int $patientId
	 * Pooja Gupta
	 */
	
	public function spot_delete($voucherId=NULL,$patientId=NULL){
		 
		if(!empty($patientId)){
			$this->loadModel('Patient');
			$this->loadModel('VoucherPayment');
			$this->loadModel('Account');
			$spot=$this->VoucherPayment->find('first',array('fields'=>array('paid_amount'),
					'conditions'=>array('VoucherPayment.id'=>$voucherId,'VoucherPayment.is_deleted'=>0)));
			$backAmt=$this->VoucherPayment->find('first',array('fields'=>array('paid_amount'),
					'conditions'=>array('VoucherPayment.id'=>$voucherId,'VoucherPayment.is_deleted'=>0)));
			$payAmt=$this->Patient->find('first',array('fields'=>array('spot_amount','b_amount'),
					'conditions'=>array('Patient.id'=>$patientId)));
			if(!empty($spot)){
				$spotAmount=$payAmt['Patient']['spot_amount']-$spot['VoucherPayment']['paid_amount'];
				$this->Patient->updateAll(array('Patient.spot_amount'=>$spotAmount),array('Patient.id'=>$patientId));
				
				$paymentDetails = $this->VoucherPayment->find('first',array('fields'=>array('paid_amount','user_id','account_id'),
						'conditions'=>array('VoucherPayment.id'=>$voucherId)));
				$this->Account->setBalanceAmountByAccountId($paymentDetails['VoucherPayment']['user_id'],$paymentDetails['VoucherPayment']['paid_amount'],'debit');//-
				$this->Account->setBalanceAmountByUserId($paymentDetails['VoucherPayment']['account_id'],$paymentDetails['VoucherPayment']['paid_amount'],'credit');//+
				
				$updatearray=array('VoucherPayment.is_deleted'=>'1');
				if ($this->VoucherPayment->updateAll($updatearray,array('VoucherPayment.id'=>$voucherId)))
				$this->loadModel('SpotApproval');
				$this->SpotApproval->updateAll(array('SpotApproval.is_deleted'=>'1'),array('SpotApproval.voucher_payment_id'=>$voucherId));	
				$mlId = $this->Account->getAccountIdOnly(Configure::read('mlEnterprise'));
				$getByBalance=$this->Account->find('first',array('conditions'=>array('id'=>$mlId,'is_deleted'=>0,'location_id'=>$this->Session->read('locationid')),'fields'=>array('balance')));
				$total=$getByBalance['Account']['balance'] - $spot['VoucherPayment']['paid_amount'];
				
				$this->Account->updateAll(array('balance'=>$total),array('id'=>$mlId));
				
				$this->VoucherPayment->updateAll(array('VoucherPayment.is_deleted'=>'1'),
						array('VoucherPayment.batch_identifier'=>$voucherId,'VoucherPayment.type'=>'MLCharges'));
					
			}else if(!empty($backAmt)){
				$bAmount=$payAmt['Patient']['b_amount']-$backAmt['VoucherPayment']['paid_amount'];
				$this->Patient->updateAll(array('Patient.b_amount'=>$bAmount),array('Patient.id'=>$patientId));
				
				$paymentDetails = $this->VoucherPayment->find('first',array('fields'=>array('paid_amount','user_id','account_id'),
						'conditions'=>array('VoucherPayment.id'=>$voucherId)));
				
				$this->Account->setBalanceAmountByAccountId($paymentDetails['VoucherPayment']['user_id'],$paymentDetails['VoucherPayment']['paid_amount'],'debit');//-
				$this->Account->setBalanceAmountByUserId($paymentDetails['VoucherPayment']['account_id'],$paymentDetails['VoucherPayment']['paid_amount'],'credit');//+ 
				
				$updatearray=array('VoucherPayment.is_deleted'=>'1');
				if ($this->VoucherPayment->updateAll($updatearray,array('VoucherPayment.id'=>$voucherId)))
					
				$mlId = $this->Account->getAccountIdOnly(Configure::read('mlEnterprise'));//for cash id
				$getByBalance=$this->Account->find('first',array('conditions'=>array('id'=>$mlId,'is_deleted'=>0,'location_id'=>$this->Session->read('locationid')),'fields'=>array('balance')));
				$total=$getByBalance['Account']['balance'] - $spot['VoucherPayment']['paid_amount'];
				
				$this->Account->updateAll(array('balance'=>$total),array('id'=>$mlId));
				
				$this->VoucherPayment->updateAll(array('VoucherPayment.is_deleted'=>'1'),
						array('VoucherPayment.batch_identifier'=>$voucherId,'VoucherPayment.type'=>'MLCharges'));
			}	
			$this->loadModel('SpotApproval');
			$this->SpotApproval->updateAll(array('SpotApproval.is_deleted'=>'1'),
						array('SpotApproval.voucher_payment_id'=>$voucherId,'SpotApproval.patient_id'=>$patientId));
			$this->Session->setFlash(__('Implant bill Deleted', true));
			//$this->redirect($this->referer());
			exit;
		}
	}
	
	/**
	 * for advance payment from billing
	 * @uthor-yashwant
	 */
	public function advanceBillingPayment($patientId=null){
	
		$this->layout='advance_ajax';
		$this->set('patientID',$patientId);
		if($this->params->query['category']){
			$this->set('category',$this->params->query['category']);
		}
		$this->uses = array('Billing','User','ServiceBill','ConsultantBilling','Patient','LaboratoryTestOrder','RadiologyTestOrder','ServiceCategory','FinalBilling','TariffStandard');
		//BOF-Mahalaxmi for Fetching RGJAY Tariff ID
		$this->set('getTariffRgjayId',$this->TariffStandard->getTariffStandardID('RGJAY'));
		//EOF-Mahalaxmi for Fetching RGJAY Tariff ID
		if($this->request->data){//for advance entry in billing
			if($this->request->data['Billing']['mode_of_payment']=='NEFT'){
				if(empty($this->request->data['Billing']['bank_name']))$this->request->data['Billing']['bank_name']=$this->request->data['Billing']['bank_name_neft'];
				if(empty($this->request->data['Billing']['account_number']))$this->request->data['Billing']['account_number']=$this->request->data['Billing']['account_number_neft'];
				$this->request->data['Billing']['neft_date']=$this->DateFormat->formatDate2STD($this->request->data['Billing']['neft_date'],Configure::read('date_format'));
			}
			if(empty($this->request->data['Billing']['date']))$this->request->data['Billing']['date']=date("Y-m-d H:i:s");
			else $this->request->data['Billing']['date']=$this->DateFormat->formatDate2STD($this->request->data['Billing']['date'],Configure::read('date_format'));
			
			if($this->request->data['Billing']['mode_of_payment']=='Cheque' || $this->request->data['Billing']['mode_of_payment']=='Credit Card'){
				$this->request->data['Billing']['cheque_date']=$this->DateFormat->formatDate2STD($this->request->data['Billing']['cheque_date'],Configure::read('date_format'));
			}
			
			$this->request->data['Billing']['location_id']=$this->Session->read('locationid');
			$this->request->data['Billing']['created_by']=$this->Session->read('userid');
			$this->request->data['Billing']['create_time']=date("Y-m-d H:i:s");
			$this->request->data['Billing']['remark']=$this->request->data['Billing']['remark'];
			$this->request->data['Billing']['reason_of_payment']="PharmacyAdvance";
			if($this->params->query['category']=='pharmacy'){ //for pharmacy advance payment  --yashwant
				$this->request->data['Billing']['payment_category']=$this->ServiceCategory->getPharmacyId();
			}else{
				if($this->request->data['Billing']['refund']=='1'){
					$this->request->data['Billing']['payment_category']='Finalbill';
				}else{
					$this->request->data['Billing']['payment_category']='advance';
				}
			}
			
			$this->request->data['Billing']['amount_pending']=$this->request->data['Billing']['amount_pending']-$this->request->data['Billing']['amount'];
			////$this->request->data['Billing']['amount_paid']=$this->request->data['Billing']['amount_paid']+$this->request->data['Billing']['amount'];
			 
			if($this->Session->read('website.instance')=='kanpur')
		{
			
			$admissionType=$this->Patient->find('first',array('fields'=>array('Patient.admission_type'),
							'conditions'=>array('Patient.id'=>$this->request->data[Billing][patient_id])));
										$receiptId=$this->Billing->autoGeneratedReceiptID($admissionType['Patient']['admission_type']);		
			
			//$this->Billing->updateAll(array('Billing.receiptNo'=>"'".$receiptId."'"),array('Billing.id'=>$billId));
			$this->request->data['Billing']['receiptNo']=$receiptId;
			
			
		}
			
			$this->Billing->save($this->request->data['Billing']);
			

			$billId=$this->Billing->getLastInsertID();
			//BOF for accounting by amit jain
				$patientId = $this->request->data['Billing']['patient_id'];
				$this->Billing->addPartialPaymentJV($this->request->data,$patientId);
			//EOF accounting
			
			if($this->params->query['category']=='pharmacy'){ //for pharmacy advance payment  --yashwant
				$this->set('isSuccess','no');
			}else{
				$this->set('isSuccess','yes');
			}
			
			$this->set('patientID',$this->request->data['Billing']['patient_id']);
		}
		
		//for list of advance bill receipt
		if($this->params->query['category']=='pharmacy'){ //for pharmacy advance payment  --yashwant
			$this->loadModel('InventoryPharmacySalesReturn'); 
			$returnList = $this->InventoryPharmacySalesReturn->find('all',array('fields'=>array('SUM(InventoryPharmacySalesReturn.total) as total',
				'InventoryPharmacySalesReturn.patient_id'),
				'conditions'=>array('InventoryPharmacySalesReturn.is_deleted'=>'0','InventoryPharmacySalesReturn.patient_id'=>$patientId),'group'=>array('InventoryPharmacySalesReturn.patient_id')));			
			$this->set('returnAmount',$returnList[0][0]['total']);
			$advancePaymentList = $this->Billing->find('all',array('conditions'=>array('patient_id'=>$patientId,'is_deleted'=>'0','pharmacy_sales_bill_id'=>'',
					'payment_category'=>$this->ServiceCategory->getPharmacyId()),'order'=>array('Billing.id desc')));
		}else{
			$advancePaymentList = $this->Billing->find('all',array('conditions'=>array('patient_id'=>$patientId,'is_deleted'=>'0','payment_category'=>Configure::read('advance')),
				'order'=>array('Billing.id desc')));
		}
		$this->set('advancePaymentList',$advancePaymentList);
		
		$patientData = $this->Patient->find('first',array('conditions'=>array('id'=>$patientId)));
		$this->set('patient',$patientData);
		
		// consultant charges
		$this->loadModel('ConsultantBilling');
		$getconsultantData = $this->ConsultantBilling->find('all',array('conditions' =>array('ConsultantBilling.patient_id'=>$patientId)));
		$this->set('getconsultantData',$getconsultantData);
			
		// for bank name
		$this->loadModel('Account');
		$this->Account->bindModel(array(
				'belongsTo' => array(
						'AccountingGroup'=>array('foreignKey' => false,'conditions'=>array('AccountingGroup.id=Account.accounting_group_id')),
				)),false);
		$bankData =$this->Account->find('all',array('fields'=>array('id','name'),'conditions'=>array('Account.is_deleted'=>'0','Account.location_id'=>$this->Session->read('locationid'),
				'AccountingGroup.name'=>Configure::read('bankLabel'))));
		$bankDataArray = array();
		foreach($bankData as $bank){
			$bankDataArray[$bank['Account']['id']] = $bank['Account']['name'];
		}
		$this->set('bankData',$bankDataArray);
		
		//maximum refund amount  
		$advanceAmount=$this->Billing->find('first',array('fields'=>array('SUM(Billing.amount_paid) as paidAdvance', 'Sum(Billing.amount) as advance'),
				'conditions'=>array('patient_id'=>$patientId,'payment_category'=>'advance'),
				'group'=>array('Billing.patient_id')));
		
		$maxRefundAmount=$advanceAmount['0']['advance']-$advanceAmount['0']['paidAdvance'];
		$this->set('maxRefundAmount',$maxRefundAmount);
		
		
		
	}
	
	/* Gulshan (Lab For Nursing)  */
	public function getSmartLab($patientId,$noteId){
		/** Lab data **/
		$this->uses = array('LaboratoryTestOrder');
		$this->LaboratoryTestOrder->bindModel(array(
				'belongsTo' => array(
						'Laboratory'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryTestOrder.laboratory_id= Laboratory.id')),
						'LaboratoryResult'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.laboratory_test_order_id= LaboratoryTestOrder.id')),
						'LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryHl7Result.laboratory_result_id= LaboratoryResult.id')),
				)));
		$getLabData=$this->LaboratoryTestOrder->find('all',array('fields'=>array('LaboratoryTestOrder.id','LaboratoryTestOrder.create_time','Laboratory.name','Laboratory.id','LaboratoryResult.is_authenticate',
				'LaboratoryTestOrder.patient_id','LaboratoryTestOrder.batch_identifier','LaboratoryResult.id','LaboratoryHl7Result.unit','LaboratoryHl7Result.result'),
				'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patientId) ,'group'=>array('LaboratoryTestOrder.id'),'order'=>array('LaboratoryTestOrder.create_time'=>'DESC') ));
	//dpr($getLabData);
		return $getLabData;
	}
	

	//function to return grouped array with ward name as "key"
	public function groupWardCharges($patient_id=null,$getSurgery = false){
		if(!$patient_id) return array();
		$this->loadModel('WardPatientService');   
		$newWardChargesArray = $this->WardPatientService->getWardCharges($patient_id);	
		$w = 0;
		foreach($newWardChargesArray['day'] as $wardKey => $wardValue){ 
			if($currentWard != $wardValue['ward']) $w++; 
			$resetWardArray[$w][$wardValue['ward']][] = $wardValue;
			$currentWard = $wardValue['ward'];
		}
		
		/*	For vadodara instance we dont need surgery data or charges
		 * $getSurgery=false // to avoid surgery data/charges
		 *  Pooja gupta
		 */
		
		if($this->Session->read('website.instance')=='vadodara'){
			$getSurgery=false;
		}
		if($getSurgery){
			$newSurgeryChargesArray = $this->Billing->getSurgeryCharges($patient_id);
			if($resetWardArray)
				$resetWardArray = array_merge($resetWardArray,$newSurgeryChargesArray);
			else 
				$resetWardArray = $newSurgeryChargesArray;
		}
		return $resetWardArray ; 
	} 

 
	
	/**
	 * for deleting ward_patient_services
	 * @yashwant
	 */
	public function deleteRoomService($recId,$patientId){
		$this->loadModel('WardPatientService');
		$this->WardPatientService->updateAll(array('WardPatientService.is_deleted'=>1),array('WardPatientService.patient_id'=>$patientId,'WardPatientService.id'=>$recId));
		$this->Session->setFlash(__('Record deleted successfully', true));
		exit;
	}
	//EOF delete function
  	function ajax_discount_requests($type){		//by Swapnil G.Sharma for refreshing page of discount request
 		$this->autoRender = false;
 		$this->layout = "ajax";
 		
 		$this->uses = array('ServiceCategory');
		$this->loadModel("DiscountRequest");
		$this->DiscountRequest->bindModel(array('belongsTo'=>array(
				'Patient' =>array('foreignKey'=>'patient_id'),
				'User' => array('foreignKey'=>'request_to'),
				'AliasUser' => array('className'=>'User','foreignKey'=>'request_by'),
				'ServiceCategory' => array('foreignKey'=>'payment_category',
						'conditions'=>array("ServiceCategory.is_deleted"=>0,"ServiceCategory.is_view"=>1,
								"(ServiceCategory.location_id=".$this->Session->read('locationid')." OR ServiceCategory.location_id=0)"))
		)));
		
		$service_group = $this->ServiceCategory->find("all",array(
				"conditions"=>array("ServiceCategory.is_deleted"=>0,"ServiceCategory.is_view"=>1,
						"(ServiceCategory.location_id=".$this->Session->read('locationid')." OR ServiceCategory.location_id=0)"),
				'order' => array('ServiceCategory.name' => 'asc')));
			
		$conditions = array();
		if($type=="Discount"){
			$conditions['DiscountRequest.type !='] = "Refund";
		}else{
			$conditions['DiscountRequest.type'] = "Refund";
		}
		
		$date = date('Y-m-d');
		$conditions['DiscountRequest.create_time LIKE'] = $date."%";
		
		$discounts = $this->DiscountRequest->find('all',array(
				'fields'=>array('Patient.lookup_name','DiscountRequest.*','CONCAT(User.first_name," ",User.last_name) as requested_to_lookup_name' , 'CONCAT(AliasUser.first_name," ",AliasUser.last_name) as requested_by_lookup_name','ServiceCategory.name','ServiceCategory.alias'),
				'conditions'=>array($conditions),
				'order'=>array('DiscountRequest.id'=>'DESC')));
		$this->set('results',$discounts);
		if($type=="Discount"){
			$this->render("ajax_discount_requests");	
		}else{
			$this->render("ajax_refund_requests");
		}
 	}
 	
 	
 	public function getCardBalance($patient_id){
		//Patient Card//
		$this->loadModel('Account');
		$this->loadModel('Patient');
		$person_id=$this->Patient->find('first',array('fields'=>array('Patient.person_id'),
							'conditions'=>array('Patient.id'=>$patient_id)));
							//debug($person_id);
		$patientCard=$this->Account->find('first',array('fields'=>array('Account.id','Account.card_balance'),
				'conditions'=>array('Account.system_user_id'=>$person_id['Patient']['person_id'],'Account.user_type'=>'Patient')));
		echo json_encode($patientCard);
		exit;
		
	}
 	

	/**
	 * for getting ward charges
	 * @yashwant
	 */
	public function getWardCharges($roomId=null,$patient_id=null){ 
		$this->layout  = 'ajax' ;
		$this->autoRender = false ;
		$this->loadModel('Room');
		$this->loadModel('Ward');
		$this->loadModel('TariffAmountType');
		
		$roomType=$this->Room->find('first',array('fields'=>array('room_type','ward_id'),'conditions'=>array('id'=>$roomId)));
		$roomTypeText=trim($roomType['Room']['room_type'])."_ward_charge";
		$wardData=$this->Ward->find('first',array('fields'=>array('tariff_list_id'),'conditions'=>array('id'=>$roomType['Room']['ward_id'])));
		$charges=$this->TariffAmountType->find('first',array('fields'=>array($roomTypeText),'conditions'=>array('tariff_list_id'=>$wardData['Ward']['tariff_list_id'])));
		return $charges['TariffAmountType'][$roomTypeText];
		 
		/*$tariffStanderdId=$this->TariffStandard->getTariffIDByPatientId($patient_id);
		$dataCharge=$this->Ward->wardCharges($wardId,$tariffStanderdId);
		return $dataCharge;*/
	}
	
	/**
	 * for other than vadodara room tariff charge
	 * @param unknown_type $wardId
	 * @param unknown_type $patient_id
	 * @return unknown
	 * @yashwant
	 */
	public function getWardChargesExceptRoom($wardId=null,$patient_id=null){
		$this->layout  = 'ajax' ;
		$this->autoRender = false ;
		$this->loadModel('Ward');
		$this->loadModel('TariffStandard');
		$tariffStanderdId=$this->TariffStandard->getTariffIDByPatientId($patient_id);
		$dataCharge=$this->Ward->wardCharges($wardId,$tariffStanderdId);
		return $dataCharge;
	}
 
	/**
	 * for rooms mapped with ward
	 * @yashwant
	 */
	public function getRoomMapedWithWard($wardId=null){
		$this->layout  = 'ajax' ;
		$this->autoRender = false ;
		$this->loadModel('Room');
		$roomData=$this->Room->getRooms($wardId);
		echo json_encode($roomData);
		exit;
	}
	
	/**
	 * for deleting advace payment record  
	 * @yashwant
	 */
	function deleteAdvanceBillingEntry($recId=null,$patientID=null){
		$this->loadModel('Billing');
		$this->loadModel('AccountReceipt');
		$this->loadModel('VoucherLog');
		$this->loadModel('Account');
		$this->Billing->updateAll(array('Billing.is_deleted'=>1),array('Billing.id'=>$recId));
		if(!empty($recId)){
			$accountReceipt = $this->AccountReceipt->find('first',array('conditions'=>array('AccountReceipt.billing_id'=>$recId),'fields'=>array('user_id','account_id','paid_amount')));
			$this->Account->setBalanceAmountByAccountId($accountReceipt['AccountReceipt']['account_id'],$accountReceipt['AccountReceipt']['paid_amount'],'debit'); //for updating balance
			$this->Account->setBalanceAmountByUserId($accountReceipt['AccountReceipt']['user_id'],$accountReceipt['AccountReceipt']['paid_amount'],'credit'); //for updating balance
			
		}
		$this->AccountReceipt->updateAll(array('AccountReceipt.is_deleted'=>1),array('AccountReceipt.billing_id'=>$recId));
		$this->VoucherLog->updateAll(array('VoucherLog.is_deleted'=>1),array('VoucherLog.billing_id'=>$recId));
		$this->Session->setFlash(__('Record deleted successfully', true));
	//	$this->set('isSuccess','yes');
		//$this->set('patientID',$patientID);
		echo '<script> parent.location.reload(); parent.jQuery.fancybox.close(); </script>';
	}
 
	//for cashier transaction PV when cash given to agent by amit jain
	public function getAgentPV($requestData=array()){
		$this->layout = false;
		$this->autoRender = false;
		$this->loadModel('VoucherPayment');
		$this->loadModel('Account');
		$this->loadModel('VoucherLog');
		$this->loadModel('User');
			if($this->request->data['agentId']){
				$requestData['CashierBatch']['agent_id']=$this->request->data['agentId'];
			}
			if($this->request->data['amountAgent']){
				$requestData['CashierBatch']['cash_handover']=$this->request->data['amountAgent'];
			}
		//payment voucher for cash handover to agent
			$accountId = $this->Account->getAccountIdOnly(Configure::read('cash'));//for cash id
			$agentId = $requestData['CashierBatch']['agent_id'];
			$userId = $this->Account->getAccountIdOnly(Configure::read('Account Room'));//for Account Room id
			$userDetails = $this->User->find('first',array('conditions'=>array('User.id'=>$agentId,'User.is_deleted'=>'0','User.location_id'=>$this->Session->read('locationid')),'fields'=>array('first_name','last_name')));
			$name = $userDetails['User']['first_name']." ".$userDetails['User']['last_name'];
			$amount = $requestData['CashierBatch']['cash_handover'];
			$doneDate = $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
			$narration = "Being amount Rs. $amount given to $name on $doneDate";
			$voucherLogDataPay=$pvData = array('date'=>date('Y-m-d H:i:s'),
					'modified_by'=>$this->Session->read('userid'),
					'create_by'=>$this->Session->read('userid'),
					'account_id'=>$accountId,
					'type'=>'CashierAgent',
					'user_id'=>$userId,
					'narration'=>$narration,
					'paid_amount'=>$amount);
			if(!empty($pvData['paid_amount']) && ($pvData['paid_amount'] != 0)){
				$lastVoucherIdPayment=$this->VoucherPayment->insertPaymentEntry($pvData);
				// ***insert into Account (By) credit manage current balance
				$this->Account->setBalanceAmountByAccountId($accountId,$amount,'debit');
				$this->Account->setBalanceAmountByUserId($userId,$amount,'credit');
				//insert into voucher_logs table added by PankajM
				$voucherLogDataPay['voucher_no']=$lastVoucherIdPayment;
				$voucherLogDataPay['voucher_id']=$lastVoucherIdPayment;
				$voucherLogDataPay['voucher_type']="Payment";
				$this->VoucherLog->insertVoucherLog($voucherLogDataPay);
				$this->VoucherLog->id= '';
				$this->VoucherPayment->id= '';
				return $amount."~~".$lastVoucherIdPayment;
			}
		//EOF pv
	}
	
	//PV for cashier transaction when remaining amount Excess to total cash by amit jain
	public function getExcessAmountPV($requestData=array()){
	$this->layout = false;
	$this->autoRender = false;
	$this->loadModel('VoucherPayment');
	$this->loadModel('Account');
	$this->loadModel('VoucherLog');
	$this->loadModel('User');
	$this->loadModel('Patient');
	
		//payment voucher for cash handover to agent
		if(!empty($requestData['CashierBatch']['cashier_id'])){
			$accountId = $this->Account->getAccountIdOnly(Configure::read('cash'));//for cash id
			$userId = $this->Account->getAccountIdOnly(Configure::read('owners_capital_account'));
			$cashierId = $requestData['CashierBatch']['cashier_id'];
			$userDetails = $this->User->find('first',array('conditions'=>array('User.id'=>$cashierId,'User.is_deleted'=>'0','User.location_id'=>$this->Session->read('locationid')),'fields'=>array('first_name','last_name')));
			$name = $userDetails['User']['first_name']." ".$userDetails['User']['last_name'];
			$amount = abs($requestData['CashierBatch']['balance_amount']);
			$doneDate = $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
			$narration = "Being amount Rs. $amount given to $name on $doneDate";
			$voucherLogDataPay=$pvData = array('date'=>date('Y-m-d H:i:s'),
					'modified_by'=>$this->Session->read('userid'),
					'create_by'=>$this->Session->read('userid'),
					'account_id'=>$accountId,
					'type'=>'CashierExcess',
					'user_id'=>$userId,
					'narration'=>$narration,
					'paid_amount'=>$amount);
			if(!empty($pvData['paid_amount']) && ($pvData['paid_amount'] != 0)){
				$lastVoucherIdPayment=$this->VoucherPayment->insertPaymentEntry($pvData);
				// sms call 
				///BOF-Mahalaxmi-For send SMS to Owner
				$getEnableFeatureChk=$this->Session->read('sms_feature_chk');
				if($getEnableFeatureChk){
					$nameArr=array('nameUser'=>$name);
					$getCashierArr=array_merge($voucherLogDataPay,$nameArr);
					$this->Patient->sendToSmsOwner($getCashierArr,'excessAmtOwner');
				}
				
				///EOF-Mahalaxmi-For send SMS to Owner
				// ***insert into Account (By) credit manage current balance
				$this->Account->setBalanceAmountByAccountId($accountId,$amount,'debit');
				$this->Account->setBalanceAmountByUserId($userId,$amount,'credit');
				//insert into voucher_logs table added by PankajM
				$voucherLogDataPay['voucher_no']=$lastVoucherIdPayment;
				$voucherLogDataPay['voucher_id']=$lastVoucherIdPayment;
				$voucherLogDataPay['voucher_type']="Payment";
				$this->VoucherLog->insertVoucherLog($voucherLogDataPay);
				$this->VoucherLog->id= '';
				$this->VoucherPayment->id= '';
			}
		}
		//EOF pv
	}
	//JV for cashier transaction when remaining amount Short to total cash by amit jain
	public function getShortAmountJV($requestData=array()){
		$this->layout = false;
		$this->autoRender = false;
		$this->loadModel('VoucherPayment');
		$this->loadModel('Account');
		$this->loadModel('VoucherReference');
		$this->loadModel('VoucherLog');
		$this->loadModel('User');
		$this->loadModel('Patient');
	//BOF for short amount
		if($requestData['CashierBatch']['cashier_id']){
			$cashierId = $requestData['CashierBatch']['cashier_id'];
			$userDetails = $this->User->find('first',array('conditions'=>array('User.id'=>$cashierId,'User.is_deleted'=>'0',
					'User.location_id'=>$this->Session->read('locationid')),'fields'=>array('first_name','last_name')));
			$userName = $userDetails['User']['first_name']." ".$userDetails['User']['last_name'];
			$userId = $this->Account->getUserIdOnly($cashierId,'User',$userName);
			$accountId = $this->Account->getAccountIdOnly(Configure::read('cash'));//for cash id
			$amount = $requestData['CashierBatch']['balance_amount'];
			 $voucherLogData = $jvData = array('date'=>date('Y-m-d H:i:s'),
					'modified_by'=>$this->Session->read('userid'),
					'created_by'=>$this->Session->read('userid'),
					'type'=>'CashierShort',
					'account_id'=>$userId,
					'user_id'=>$accountId,
					'debit_amount'=>$amount);
			 if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
				$lastJvId = $this->VoucherEntry->insertJournalEntry($jvData);
				// sms call
				///BOF-Mahalaxmi-For send SMS to Owner
				$getEnableFeatureChk=$this->Session->read('sms_feature_chk');
				if($getEnableFeatureChk){
					$nameArr=array('nameUser'=>$userName);
					$getCashierArr=array_merge($voucherLogData,$nameArr);
					$this->Patient->sendToSmsOwner($getCashierArr,'shortAmtOwner');
				}
				
				///EOF-Mahalaxmi-For send SMS to Owner
					//insert into voucher_logs table added by PankajM
					$voucherLogData['voucher_no']=$lastJvId;
					$voucherLogData['voucher_id']=$lastJvId;
					$voucherLogData['voucher_type']="Journal";
					$this->VoucherLog->insertVoucherLog($voucherLogData);
					$this->VoucherLog->id= '';
					$this->VoucherEntry->id= '';
			
					// BOF insert into Account for maintain current balance
					$this->Account->setBalanceAmountByAccountId($accountId,$amount,'debit');
					$this->Account->setBalanceAmountByUserId($userId,$amount,'credit');
				// EOF
				
				//BOF for voucher Reference
					$vrData = array('reference_type_id'=> '2',
						'voucher_id'=> $this->VoucherEntry->getLastInsertID(),
						'voucher_type'=> 'journal',
						'location_id'=> $this->Session->read('locationid'),
						'user_id'=> $userId,
						'date' => date('Y-m-d H:i:s'),
						'amount'=>$amount,
						'credit_period'=>'45',
						'payment_type'=>'Dr',
						'reference_no'=>$this->VoucherEntry->getLastInsertID(),
						'parent_id' => '0');
					$this->VoucherReference->save($vrData);
					$this->VoucherReference->id= '';
			//EOF Short amount
			  }
		}
	}

	/**
	 * for print detail service wise invoice
	 * @yashwant
	 */
	public function printServiceInvoice($patientID=null,$tariffStandardId=null,$billNumber=null){
		$this->layout = false;
		$this->patient_info($patientID);
		$this->set('groupFlag',$this->params->query['group']);
		$this->set('billNumber',$this->params->query['billNumber']);
		$website=$this->Session->read('website.instance');
		 
		$labRadRec=$this->labRadRates($tariffStandardId,$patientID);
		if($this->params->query['group']=='laboratory'){
			foreach ($labRadRec['labRate'] as $key => $value){
				/*$qty[$value['Laboratory']['name']] += 1;
				$value['qty'] = $qty[$value['Laboratory']['name']]; // if one service assign multiple times
				$returnArr[$value['Laboratory']['name']] = $value;*/
			}
			$this->set('labRate',$labRadRec['labRate']);
			
			if($this->params->query['type']=='excel'){//for excel format
				$this->layout = false;
				$this->render('lab_excel_report');
			}elseif($this->params->query['type']=='pdf'){//for pdf format
				$this->layout=false;
				$this->render('lab_pdf_report','pdf');
			}
		}elseif($this->params->query['group']=='radiology'){
			/*foreach ($labRadRec['radRate'] as $key => $value){
				$qty[$value['Radiology']['name']] += 1;
				$value['qty'] = $qty[$value['Radiology']['name']]; // if one service assign multiple times
				$returnArr[$value['Radiology']['name']] = $value;
			} */
			$this->set('radRate',$labRadRec['radRate']);
			if($this->params->query['type']=='excel'){
				$this->layout=false;
				$this->render('lab_excel_report');
			}elseif($this->params->query['type']=='pdf'){
				$this->layout=false;
				$this->render('lab_pdf_report','pdf');
			}
		}
	}
	
	function marketingReport(){
	
		$this->uses = array('Consultant','Person','Billing','Patient','FinalBilling');
		if($this->request->data){
	
			if (! empty ( $this->request->data['Billing']['from'] )) {
				$conditions ['FinalBilling.discharge_date >='] = $this->DateFormat->formatDate2STD ( $this->request->data['Billing'] ['from'], Configure::read ( 'date_format' ) ) . " 00:00:00";
			}
			if (! empty ( $this->request->data['Billing']['to'] )) {
				$conditions ['FinalBilling.discharge_date <='] = $this->DateFormat->formatDate2STD ( $this->request->data['Billing']['to'], Configure::read ( 'date_format' ) ) . " 23:59:59";
			}
		}else{
			$conditions = 'YEAR(FinalBilling.discharge_date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND
		 										MONTH(FinalBilling.discharge_date) = MONTH( CURRENT_DATE - INTERVAL 1 MONTH )';
		}
		// debug($conditions);
		$this->Person->bindModel(array(
				'belongsTo' =>array(
						'Consultant'=>array('foreignKey'=>false,
								'conditions'=>array('Consultant.id=Person.consultant_id') ),
						'Patient'=>array('foreignKey'=>false,
								'conditions'=>array('Patient.person_id=Person.id')),
						'FinalBilling'=>array('foreignKey'=>false,
								'conditions'=>array('FinalBilling.patient_id=Patient.id'))
							
				)
		));
	
		$data = $this->Person->find('all',array('fields'=>array('Person.id','Person.consultant_id','Consultant.id','Consultant.market_team',
				'Patient.id','Patient.lookup_name','FinalBilling.id','FinalBilling.total_amount','FinalBilling.discharge_date'),
				'conditions'=>array($conditions,'Patient.is_discharge' => 1),'order'=>array('Consultant.market_team'=>'ASC')));
		//debug($data); exit;
		$this->set('data',$data);
	}
	
	public function discount_only($patient_id){
		$this->layout ='advance';
		$this->uses = array('LaboratoryTestOrder','WardPatient','ServiceCategory','OtPharmacySalesBill',
				'Patient','ServiceBill','OptAppointment','RadiologyTestOrder','PharmacySalesBill','WardPatientService',
				'ConsultantBilling','Account','PatientCard','DischargeDetail','Bed','FinalBilling');
		
		$this->set('appoinmentID',$this->params->query['appoinmentID']);		
		$this->set('totalPaymentFlag',$this->params->query['totalPaymentFlag']);		
		
		/**********To set patient id in session for new patient hub when patiet in searched from this page- Pooja*********/
		$sessionPatientId=$this->Session->read('hub.patientid');
		if(empty($sessionPatientId) && !empty($patient_id))
			$this->Patient->getSessionPatId($patient_id);
		else{
			if(!empty($patient_id)){
				if($sessionPatientId!=$patient_id)
					$this->Patient->getSessionPatId($patient_id);
			}
		}
		/*********************************************************************************************************/
		
		$this->patient_info($patient_id);
				
		$tariffStdData = $this->Patient->find('first',array('fields'=>array('id','tariff_standard_id','is_discharge','treatment_type','admission_type','is_packaged','person_id'),
				'conditions'=>array('id'=>$patient_id)));
		
		$this->set('tariffStdData',$tariffStdData);
		
		$serviceCategory = $this->ServiceCategory->find("list",array('fields'=>array('id','name'),
				"conditions"=>array("ServiceCategory.is_deleted"=>0,"ServiceCategory.is_view"=>1,
						"ServiceCategory.service_type"=>array($tariffStdData['Patient']['admission_type'],'Both'),
						"ServiceCategory.location_id"=>array($this->Session->read('locationid'),'0')),
				/*'order' => array('ServiceCategory.name' => 'asc')*/));

		$serviceCategoryName = $this->ServiceCategory->find("list",array('fields'=>array('id','alias'),
				"conditions"=>array("ServiceCategory.is_deleted"=>0,"ServiceCategory.is_view"=>1,
						"ServiceCategory.service_type"=>array($tariffStdData['Patient']['admission_type'],'Both'),
						"ServiceCategory.location_id"=>array($this->Session->read('locationid'),'0')),
				/*'order' => array('ServiceCategory.name' => 'asc')*/));
		$this->set('serviceCategoryName',$serviceCategoryName);
				
		/**************************** Post data processing***********************************************/
		if($this->request->data){//debug(debug($this->request->data['Billing']));
			//debug($this->request->data);exit;
			$totalDisAmt=0;$amountPending=0;
			foreach($this->request->data['Billing'] as $billKey=>$billValue){
				foreach($billValue as $serviceKey=> $serviceValue){
					if(!empty($serviceValue['valChk'])){
							if(($serviceCategory[$serviceValue['service_id']]==Configure::read('laboratoryservices'))||
								($serviceCategory[$serviceValue['service_id']]==Configure::read('radiologyservices'))||
								($serviceCategory[$serviceValue['service_id']]==Configure::read('surgeryservices')) ||
								($serviceCategory[$serviceValue['service_id']]==Configure::read('Consultant')) ||
									$serviceCategory[$serviceValue['service_id']]==Configure::read('Pharmacy') ||
									$serviceCategory[$serviceValue['service_id']]==Configure::read('OtPharmacy') || 
									$serviceCategory[$serviceValue['service_id']]==Configure::read('PharmacyReturn') ||
									$serviceCategory[$serviceValue['service_id']]==Configure::read('OtPharmacyReturn')){						
							
								if($serviceCategory[$serviceValue['service_id']]==Configure::read('laboratoryservices')){
								$model='LaboratoryTestOrder';
							}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('radiologyservices')){
								$model='RadiologyTestOrder';
							}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('surgeryservices')){
								$model='OptAppointment';
							}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('Consultant')){
								$model='ConsultantBilling';
							}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('Pharmacy') || $serviceCategory[$serviceValue['service_id']]==Configure::read('PharmacyReturn')){
								$model='PharmacySalesBill';
							}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('OtPharmacy') || $serviceCategory[$serviceValue['service_id']]==Configure::read('OtPharmacyReturn')){
								$model='OtPharmacySalesBill';
							}
							
							if($model=='PharmacySalesBill'){
								$billTariffId[$serviceCategory[$serviceValue['service_id']]][]=$serviceValue['id'];
								$Phardis=$this->$model->find('all',array('fields'=>array("SUM($model.discount) as discount"),
										'conditions'=>array("$model.patient_id"=>$patient_id,"$model.is_deleted"=>'0',
												"$model.billing_id"=>NULL)));
								$totalDisAmt=$totalDisAmt+$Phardis['0']['discount'];
							}else if($model=='OtPharmacySalesBill'){
								$billTariffId[$serviceCategory[$serviceValue['service_id']]][]=$serviceValue['id'];
								$otPhardis=$this->$model->find('all',array('fields'=>array("SUM($model.discount) as discount"),
										'conditions'=>array("$model.patient_id"=>$patient_id,"$model.is_deleted"=>'0',
												"$model.billing_id"=>NULL)));
								$totalDisAmt=$totalDisAmt+$otPhardis['0']['discount'];
							}else{
								$billTariffId[$serviceCategory[$serviceValue['service_id']]][]=$serviceValue['id'];
								$totalDisAmt=$totalDisAmt+$serviceValue['discount'];
							}
													
							//if($serviceCategory[$serviceValue['service_id']]!=Configure::read('Pharmacy') &&  $serviceCategory[$serviceValue['service_id']]!=Configure::read('OtPharmacy')){
								
							//}	
								
							}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('mandatoryservices')){
							
							if($serviceValue['name']==Configure::read('DoctorsCharges') || $serviceValue['name']==Configure::read('NursingCharges')){
								if($serviceValue['name']==Configure::read('DoctorsCharges')){
									//if((empty($serviceValue['paid_amount']) || $serviceValue['paid_amount']<=0)){
										$servKeyArrayId=$serviceCategory[$serviceValue['service_id']];
										$billTariffId[$servKeyArrayId][]=$serviceValue['id'];
										$totalDisAmt=$totalDisAmt+$serviceValue['discount'];										
									//}
								}else{
									if($serviceValue['name']==Configure::read('NursingCharges')){
										//if((empty($serviceValue['paid_amount']) || $serviceValue['paid_amount']<=0)){
											$servKeyArrayId=$serviceCategory[$serviceValue['service_id']];
											$billTariffId[$servKeyArrayId][]=$serviceValue['id'];
											$totalDisAmt=$totalDisAmt+$serviceValue['discount'];
											
										//}
									}
								}
							}else{
								//if(empty($serviceValue['paid_amount']) || $serviceValue['paid_amount']<=0){
									$servKeyArrayId=$serviceCategory[$serviceValue['service_id']];
									$billTariffId[$servKeyArrayId][]=$serviceValue['service_bill_id'];
									$totalDisAmt=$totalDisAmt+$serviceValue['discount'];
								//}
							}
						}else{
								$servKeyArrayId=$serviceCategory[$serviceValue['service_id']];
								$billTariffId[$servKeyArrayId][]=$serviceValue['service_bill_id'];
								$totalDisAmt=$totalDisAmt+$serviceValue['discount'];	
								
							}
					
					}//EOF if  checked Chckboxes
						
				}//EOF inner foreach
				
			}//EOF Outer foreach			
			$srArray=serialize($billTariffId);
			$totalBillAmt=ceil($this->request->data['Billing']['total_amount']);
			
			if(!empty($this->request->data['Billing']['foc'])){
				$this->request->data['Billing']['discount_type'] ='Amount';
				$this->request->data['Billing']['is_discount'] =$this->request->data['Billing']['changeAmt'];
				$this->request->data['Billing']['discount'] =$this->request->data['Billing']['changeAmt'];
				$this->request->data['Billing']['discount_per'] ='100.00';
			}
			
			
			if(!empty($this->request->data['Billing']['resetDiscount'])){
				$this->request->data['Billing']['discount_type'] ='Amount';
				$this->request->data['Billing']['discount'] =-($totalDisAmt);
			}
			
			
			if(!empty($this->request->data['Billing']['discount'])){
				$amountPending=	$totalBillAmt-$this->request->data['Billing']['discount'];
			}
			//
			//Refund Calculations
			if(!empty($this->request->data['Billing']['refund']) || !empty($this->request->data['Billing']['hrefund']) || !empty($this->request->data['Billing']['paid_to_patient'])){
				$this->request->data['Billing']['refund']='1';
				$this->request->data['Billing']['discount']=-round($totalDisAmt);
				if(empty($this->request->data['Billing']['paid_to_patient'])){
					$this->request->data['Billing']['paid_to_patient']=$this->request->data['Billing']['changeAmt'];
					if(empty($this->request->data['Billing']['paid_to_patient'])){
						$this->request->data['Billing']['paid_to_patient']=$this->request->data['Billing']['refund_to_patient'];
					}
				}
				$remark=$this->request->data['Billing']['remark'];				
			}else{
				$remark='';
			}
			//debug($this->request->data);exit;
			/*****Billing data******/
			
			$billArrayData['Billing']['patient_id']=$this->request->data['Billing']['patient_id'];
			$billArrayData['Billing']['location_id']=$this->Session->read('locationid');
			$billArrayData['Billing']['date']=$this->DateFormat->formatDate2STD($this->request->data['Billing']['date'],Configure::read('date_format'));
			$billArrayData['Billing']['amount']='0';
			$billArrayData['Billing']['payment_category']='Finalbill';
			$billArrayData['Billing']['tariff_list_id']=$srArray;
			$billArrayData['Billing']['mode_of_payment']='Cash';
			$billArrayData['Billing']['total_amount']=$totalBillAmt;
			$billArrayData['Billing']['amount_pending']=$amountPending;
			$billArrayData['Billing']['discount']=$this->request->data['Billing']['discount'];
			$billArrayData['Billing']['amount_paid']='0';
			$billArrayData['Billing']['created_by']=$this->Session->read('userid');
			$billArrayData['Billing']['refund']=$this->request->data['Billing']['refund'];
			$billArrayData['Billing']['paid_to_patient']=$this->request->data['Billing']['paid_to_patient'];
			$billArrayData['Billing']['remark']=$remark;
			$billArrayData['Billing']['guarantor']=$this->request->data['Billing']['guarantor'];
			//$billArrayData['Billing']['reason_of_discharge']=$this->request->data['Billing']['reason_of_discharge'];
			//$billArrayData['Billing']['reason_of_balance']=$this->request->data['Billing']['reason_of_balance'];
			$billArrayData['Billing']['discount_type']= $this->request->data['Billing']['discount_type'];
			//$billArrayData['Billing']['discharge_date']=$this->DateFormat->formatDate2STD($this->request->data['Billing']['date'],Configure::read('date_format'));
			//debug($billArrayData);exit;
			
			$this->Billing->save($billArrayData['Billing']);
			$billId=$this->Billing->id;
			//for accounting by amit jain
			$this->Billing->addPartialPaymentJV($billArrayData,$patient_id);
			/*****EOF Billing data******/
			
			/***For updating refund in final billing entry after discharge***/
			$finalBill=$this->FinalBilling->find('first',array('conditions'=>array('FinalBilling.Patient_id'=>$patient_id)));
			if($finalBill){
				$totalAmount=$totalBillAmt;
				if($this->request->data['Billing']['paid_to_patient']){
					$totalPaid=$finalBill['FinalBilling']['amount_paid']-$this->request->data['Billing']['paid_to_patient'];
				}else{
					$totalPaid=$finalBill['FinalBilling']['amount_paid'];
				}
				$totaldiscount=$finalBill['FinalBilling']['discount']+$this->request->data['Billing']['discount'];
				$amount_pending=$totalAmount-$totalPaid-$totaldiscount;
				$this->FinalBilling->updateAll(array('total_amount'=>"'$totalAmount'",'amount_paid'=>"'$totalPaid'",
						'amount_pending'=>"'$amount_pending'",'discount'=>"'$totaldiscount'"),
						array('FinalBilling.id'=>$finalBill['FinalBilling']['id']));
			}
		
			if(!empty($this->request->data['Billing']['refund']) && $this->request->data['Billing']['paid_to_patient']>10000){
				
				///BOF-Mahalaxmi-For send SMS to administrator after get Refund 
					$smsActive=false;
					//$getEnableFeatureChk=$this->Session->read('sms_feature_chk');
					//if($getEnableFeatureChk){	
						$smsActive=$this->Configuration->getConfigSmsValue('refund');				
						if($smsActive){
							$configurationData = $this->Configuration->getConfig('Chairman');			
							$MobNos = unserialize($configurationData['Configuration']['value']) ;//Chairman No					
							$getSmsNoArr=implode(",",$MobNos['sms_number']);
							
							$showMsg= sprintf(Configure::read('refund_msg'),$this->request->data['Billing']['paid_to_patient'],$tariffStdData['Patient']['lookup_name'],$totalBillAmt);
							
							//$mobileNo=Configure::read('administrator_no');							
							$this->Message->sendToSms($showMsg,$getSmsNoArr);	
							
						}
				//	}
				///EOF-Mahalaxmi-For send SMS to administrator after get Refund	 
			}
			$modified=$this->DateFormat->formatDate2STD($this->request->data['Billing']['date'],Configure::read('date_format'));//date('Y-m-d H:i:s');
			$modified_by=$this->Session->read('userid');
			if(!empty($this->request->data['Billing']['refund']) || !empty($this->request->data['Billing']['hrefund']) || !empty($this->request->data['Billing']['paid_to_patient'])){
				foreach($this->request->data['Billing'] as $billKey=>$billValue){
					foreach($billValue as $serviceKey=> $serviceValue){
						if(!empty($serviceValue['valChk'])){
							if(($serviceCategory[$serviceValue['service_id']]==Configure::read('laboratoryservices'))||
									($serviceCategory[$serviceValue['service_id']]==Configure::read('radiologyservices'))||
									($serviceCategory[$serviceValue['service_id']]==Configure::read('surgeryservices')) ||
									($serviceCategory[$serviceValue['service_id']]==Configure::read('Consultant')) ||
									$serviceCategory[$serviceValue['service_id']]==Configure::read('Pharmacy') ||
									$serviceCategory[$serviceValue['service_id']]==Configure::read('OtPharmacy') ||
									$serviceCategory[$serviceValue['service_id']]==Configure::read('PharmacyReturn') ||
									$serviceCategory[$serviceValue['service_id']]==Configure::read('OtPharmacyReturn')){
								if($serviceCategory[$serviceValue['service_id']]==Configure::read('laboratoryservices')){
									$labKey='Laboratory';
									$model='LaboratoryTestOrder';
								}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('radiologyservices')){
									$labKey='Radiology';
									$model='RadiologyTestOrder';
								}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('surgeryservices')){
									$labKey='Surgery';
									$model='OptAppointment';
								}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('Consultant')){
									$labKey='Consultant';
									$model='ConsultantBilling';
								}elseif($serviceCategory[$serviceValue['service_id']]==Configure::read('Pharmacy') || $serviceCategory[$serviceValue['service_id']]==Configure::read('PharmacyReturn')){
									//$model='PharmacySalesBill';
									$model='InventoryPharmacySalesReturn';
								}elseif($serviceCategory[$serviceValue['service_id']]==Configure::read('OtPharmacy') || $serviceCategory[$serviceValue['service_id']]==Configure::read('OtPharmacyReturn')){
									//$model='OtPharmacySalesBill';
									$model='OtPharmacySalesReturn';
								}
				
								if($model=='ConsultantBilling'){
									$conBill=$this->$model->find('all',array('conditions'=>array("$model.id"=>$serviceValue['id'],
											"$model.paid_amount"=>array('0',''),
											"$model.patient_id"=>$patient_id)));
									$doctId=$conBill['0']['ConsultantBilling']['doctor_id'];
									$this->$model->updateAll(array("$model.discount"=>'0',"$model.paid_amount"=>'0',
											/*"$model.billing_id"=>$billId*/
											"$model.modify_time"=>"'$modified'",
											"$model.modified_by"=>"'$modified_by'"),
											array("$model.id"=>$serviceValue['id'],
													"$model.patient_id"=>$patient_id));
				
								}else if($model=='InventoryPharmacySalesReturn'){
									/*$PharBill=$this->$model->find('all',array('fields'=>array("$model.id","$model.total",
											"$model.paid_amnt","$model.discount"),'conditions'=>array("$model.patient_id"=>$patient_id,
													"$model.is_deleted"=>'0')));
									foreach($PharBill as $pharRow){
										//if(!empty($serviceValue['discount'])){
											$this->$model->updateAll(array(/*"$model.discount"=>'0',*//*"$model.payment_mode"=>"'credit'","$model.refund"=>'1',
													"$model.paid_amnt"=>'0',"$model.modified_time"=>"'$modified'"),
													array("$model.id"=>$pharRow['PharmacySalesBill']['id'],"$model.patient_id"=>$patient_id));
										//}
									}*/
									
									/*update billing id for refund as after refund paid amount gets zero
									 * and we get the refund amount of sales return so after refund ,
									*  we will update the billing id of sales_return to NULL so that we dont get the -ve paid amount...
									* ex :
									* After Paid
									* sales bill=>100 return=>20 paid=>100-20 (paid amount - return amount with billing id)
									* after refund
									* salesBill=>100 return=>20 paid=>0-20 (paid amount - return amount with billing id)
									*
									* Pooja Gupta*/
									$this->loadModel('InventoryPharmacySalesReturn');
									$this->InventoryPharmacySalesReturn->updateAll(array('InventoryPharmacySalesReturn.billing_id'=>$billId,
											"InventoryPharmacySalesReturn.modified_time"=>"'$modified'",
											"InventoryPharmacySalesReturn.modified_by"=>"'$modified_by'"),
											array('InventoryPharmacySalesReturn.patient_id'=>$patient_id,'InventoryPharmacySalesReturn.billing_id'=>NULL));
								
								}else if($model=='OtPharmacySalesReturn'){
									/*$PharBill=$this->$model->find('all',array('fields'=>array("$model.id","$model.total","$model.paid_amount",
											"$model.discount"),
											'conditions'=>array("$model.patient_id"=>$patient_id,"$model.is_deleted"=>'0')));
									foreach($PharBill as $pharRow){
											// $this->$model->updateAll(array(/*"$model.discount"=>'0',*///	"$model.payment_mode"=>"'Credit'",
												//	"$model.paid_amount"=>'0',"$model.modified_time"=>"'$modified'"),
												//	array("$model.id"=>$pharRow['OtPharmacySalesBill']['id'],"$model.patient_id"=>$patient_id));
										
									//}*/
									/*update billing id for refund as after refund paid amount gets zero
									 * and we get the refund amount of sales return so after refund ,
									*  we will update the billing id of sales_return to NULL so that we dont get the -ve paid amount...
									* ex :
									* After Paid
									* sales bill=>100 return=>20 paid=>100-20 (paid amount - return amount with billing id)
									* after refund
									* salesBill=>100 return=>20 paid=>0-20 (paid amount - return amount with billing id)
									*
									* Pooja Gupta
									*/
									$this->loadModel('OtPharmacySalesReturn');
									$this->OtPharmacySalesReturn->updateAll(array('OtPharmacySalesReturn.billing_id'=>$billId,
											"OtPharmacySalesReturn.modified_time"=>"'$modified'",
											"OtPharmacySalesReturn.modified_by"=>"'$modified_by'"),
											array('OtPharmacySalesReturn.patient_id'=>$patient_id,'OtPharmacySalesReturn.billing_id '=>NULL));
									
								}else if($model=='LaboratoryTestOrder' || $model=='RadiologyTestOrder'){
									$chkPaid=$this->$model->find('first',array('fields'=>array('paid_amount'),
											'conditions'=>array("$model.id"=>$serviceValue['id'],"$model.patient_id"=>$patient_id)));
									$this->$model->updateAll(array("$model.discount"=>'0',"$model.paid_amount"=>'0',"$model.pay_later"=>'0',
											/*"$model.billing_id"=>$billId*/
											"$model.modified_bill_date"=>"'$modified'","$model.modified_bill_by"=>"'$modified_by'"),
											array("$model.id"=>$serviceValue['id'],"$model.patient_id"=>$patient_id));
								}
								else{
									$chkPaid=$this->$model->find('first',array('fields'=>array('paid_amount'),
											'conditions'=>array("$model.id"=>$serviceValue['id'],"$model.patient_id"=>$patient_id)));
									$this->$model->updateAll(array("$model.discount"=>'0',"$model.paid_amount"=>'0',"$model.pay_later"=>'0',
											/*"$model.billing_id"=>$billId*/
											"$model.modify_time"=>"'$modified'","$model.modified_by"=>"'$modified_by'"),
											array("$model.id"=>$serviceValue['id'],"$model.patient_id"=>$patient_id));
								}
								
									
							}else{
								$dic=0;
									
								if($serviceCategory[$serviceValue['service_id']]==Configure::read('RoomTariff')){
									$this->loadModel('WardPatientService');
									$this->WardPatientService->updateAll(array(
											'WardPatientService.discount'=>'0','WardPatientService.paid_amount'=>'0',
											/*'WardPatientService.billing_id'=>$billId*/
											"WardPatientService.modified_time"=>"'$modified'",
											"WardPatientService.modified_by"=>"'$modified_by'"),
											array('WardPatientService.patient_id'=>$this->request->data['Billing']['patient_id'],
													/*'WardPatientService.ward_id'=>$serviceValue['id']*/));
								}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('mandatoryservices')){
									if($serviceValue['name']==Configure::read('DoctorsCharges') ||
											$serviceValue['name']==Configure::read('NursingCharges')){											
											$this->loadModel('WardPatientService');
											if($serviceValue['name']==Configure::read('DoctorsCharges')){
												$this->WardPatientService->updateAll(array(
														'WardPatientService.doctor_discount'=>'0',
														'WardPatientService.doctor_paid_amount'=>'0',
														/*'WardPatientService.billing_id'=>$billId*/
														"WardPatientService.modified_time"=>"'$modified'"
														,"WardPatientService.modified_by"=>"'$modified_by'"),
														array('WardPatientService.patient_id'=>$this->request->data['Billing']['patient_id'],
																));
											}else if($serviceValue['name']==Configure::read('NursingCharges')){
												$this->WardPatientService->updateAll(array(
														'WardPatientService.nurse_discount'=>'0',
														'WardPatientService.nurse_paid_amount'=>'0',
														/*'WardPatientService.billing_id'=>$billId,*/
														"WardPatientService.modified_time"=>"'$modified'"
														,"WardPatientService.modified_by"=>"'$modified_by'"),
														array('WardPatientService.patient_id'=>$this->request->data['Billing']['patient_id'],
																));
											}
										
									}else{
											if(!empty($serviceValue['service_bill_id'])){
												$this->ServiceBill->updateAll(array(
														'ServiceBill.discount'=>'0','ServiceBill.paid_amount'=>'0',"ServiceBill.pay_later"=>'0',
														/*'ServiceBill.billing_id'=>$billId*/
														"ServiceBill.modified_time"=>"'$modified'"
														,"ServiceBill.modified_by"=>"'$modified_by'"),
														array('ServiceBill.id'=>$serviceValue['service_bill_id'],'ServiceBill.patient_id'=>$patient_id));
											
										}
									}
								}else if(!empty($serviceValue['service_bill_id'])){
									$this->ServiceBill->updateAll(array(
											'ServiceBill.discount'=>'0','ServiceBill.paid_amount'=>'0',"ServiceBill.pay_later"=>'0',
											"ServiceBill.modified_time"=>"'$modified'","ServiceBill.modified_by"=>"'$modified_by'"
											/*'ServiceBill.billing_id'=>$billId*/),
											array('ServiceBill.id'=>$serviceValue['service_bill_id'],'ServiceBill.patient_id'=>$patient_id));
								}
				
							}
								
						}
					}//EOF inner foreach
						
				}//EOF outer foreach
				
			}else if(!empty($this->request->data['Billing']['resetDiscount'])){
				
				/************************************Reset discount of selcted Services*****************************************/

				foreach($this->request->data['Billing'] as $billKey=>$billValue){
					foreach($billValue as $serviceKey=> $serviceValue){
						if(!empty($serviceValue['valChk'])){			
				
							if(($serviceCategory[$serviceValue['service_id']]==Configure::read('laboratoryservices'))||
									($serviceCategory[$serviceValue['service_id']]==Configure::read('radiologyservices'))||
									($serviceCategory[$serviceValue['service_id']]==Configure::read('surgeryservices')) ||
									($serviceCategory[$serviceValue['service_id']]==Configure::read('Consultant')) ||
									$serviceCategory[$serviceValue['service_id']]==Configure::read('Pharmacy') ||
									$serviceCategory[$serviceValue['service_id']]==Configure::read('OtPharmacy')){
								if($serviceCategory[$serviceValue['service_id']]==Configure::read('laboratoryservices')){
									$labKey='Laboratory';
									$model='LaboratoryTestOrder';
								}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('radiologyservices')){
									$labKey='Radiology';
									$model='RadiologyTestOrder';
								}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('surgeryservices')){
									$labKey='Surgery';
									$model='OptAppointment';
								}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('Consultant')){
									$labKey='Consultant';
									$model='ConsultantBilling';
								}elseif($serviceCategory[$serviceValue['service_id']]==Configure::read('Pharmacy')){
									$model='PharmacySalesBill';
								}elseif($serviceCategory[$serviceValue['service_id']]==Configure::read('OtPharmacy')){
									$model='OtPharmacySalesBill';
								}
				
								if($model=='ConsultantBilling'){
									$this->$model->updateAll(array("$model.discount"=>'0',
											/*"$model.billing_id"=>$billId*/
											"$model.modify_time"=>"'$modified'"),
											array("$model.id"=>$serviceValue['id'],
													"$model.patient_id"=>$patient_id));
				
								}else if($model=='PharmacySalesBill'){
									$PharBill=$this->$model->find('all',array('fields'=>array("$model.id","$model.total","$model.paid_amnt",
											"$model.discount"),
											'conditions'=>array("$model.patient_id"=>$patient_id,"$model.is_deleted"=>'0',
													"$model.payment_mode"=>'Credit')));
									foreach($PharBill as $pharRow){
										$this->$model->updateAll(array("$model.discount"=>'0',
													"$model.modified_time"=>"'$modified'"
												    ,"$model.modified_by"=>"'$modified_by'"),
													array("$model.id"=>$pharRow['PharmacySalesBill']['id'],"$model.patient_id"=>$patient_id,
															'PharmacySalesBill.billing_id '=>NULL));										
									}
								}else if($model=='OtPharmacySalesBill'){
									$oTPharBill=$this->$model->find('all',array('fields'=>array("$model.id","$model.total","$model.paid_amount",
											"$model.discount"),
											'conditions'=>array("$model.patient_id"=>$patient_id,"$model.is_deleted"=>'0',
													"$model.payment_mode"=>'Credit')));
									foreach($oTPharBill as $pharRow){
											$this->$model->updateAll(array("$model.discount"=>round($oTsalesDiscountAmt),
													"$model.modified_time"=>"'$modified'"
													,"$model.modified_by"=>"'$modified_by'"),
													array("$model.id"=>$pharRow['OtPharmacySalesBill']['id'],"$model.patient_id"=>$patient_id,
															'OtPharmacySalesBill.billing_id '=>NULL));										
									}
								}else if($model=='LaboratoryTestOrder' || $model=='RadiologyTestOrder'){
									
									$this->$model->updateAll(array("$model.discount"=>'0',
											/*"$model.billing_id"=>$billId*/
											"$model.modified_bill_date"=>"'$modified'"
											,"$model.modified_bill_by"=>"'$modified_by'"),
											array("$model.id"=>$serviceValue['id'],"$model.patient_id"=>$patient_id));
								}
								else{
									$this->$model->updateAll(array("$model.discount"=>'0',
											/*"$model.billing_id"=>$billId*/
											"$model.modify_time"=>"'$modified'","$model.modified_by"=>"'$modified_by'"),
											array("$model.id"=>$serviceValue['id'],"$model.patient_id"=>$patient_id));
								}
								
									
							}else{
								$dic=0;
								if($serviceCategory[$serviceValue['service_id']]==Configure::read('RoomTariff')){
									$this->loadModel('WardPatientService');									
									$wardBill=$this->WardPatientService->find('all',array('fields'=>array("WardPatientService.id","WardPatientService.amount","WardPatientService.paid_amount",
											"WardPatientService.discount"),
											'conditions'=>array("WardPatientService.patient_id"=>$patient_id,"WardPatientService.is_deleted"=>'0',"WardPatientService.paid_amount"=>'0')));
									foreach($wardBill as $wardRow){
										$this->WardPatientService->updateAll(array("WardPatientService.discount"=>'0',
													"WardPatientService.modified_time"=>"'$modified'"
												    ,"WardPatientService.modified_by"=>"'$modified_by'"),
													array("WardPatientService.id"=>$wardRow['WardPatientService']['id'],'OR'=>array(array("WardPatientService.paid_amount"=>'0'),array("WardPatientService.paid_amount"=>NULL)),
															"WardPatientService.patient_id"=>$patient_id));
										
									}				
								}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('mandatoryservices')){
									if($serviceValue['name']==Configure::read('DoctorsCharges') ||
											$serviceValue['name']==Configure::read('NursingCharges')){
											
										//if($serviceValue['paid_amount']<$serviceValue['amount']){
										if($serviceValue['name']==Configure::read('DoctorsCharges')){
											$docArr=$this->WardPatientService->find('all',array('fields'=>array("WardPatientService.id",
													"WardPatientService.doctor_paid_amount",
													"WardPatientService.doctor_discount"),
													'conditions'=>array("WardPatientService.patient_id"=>$patient_id,
															"WardPatientService.is_deleted"=>'0',
															"WardPatientService.doctor_paid_amount"=>'0')));
											foreach($docArr as $wardRow){
												$this->WardPatientService->updateAll(array("WardPatientService.doctor_discount"=>'0',
														"WardPatientService.modified_time"=>"'$modified'"
														,"WardPatientService.modified_by"=>"'$modified_by'"),
														array("WardPatientService.id"=>$wardRow['WardPatientService']['id'],
																'OR'=>array(array("WardPatientService.doctor_paid_amount"=>'0'),
																		array("WardPatientService.doctor_paid_amount"=>NULL)),
																"WardPatientService.patient_id"=>$patient_id));
											
											}
											/*$this->WardPatientService->updateAll(array(
													'WardPatientService.doctor_discount'=>'0',
													"WardPatientService.modified_time"=>"'$modified'"
													,"WardPatientService.modified_by"=>"'$modified_by'"
													/*'WardPatientService.billing_id'=>$billId*///),
													/*array('WardPatientService.patient_id'=>$this->request->data['Billing']['patient_id'],
															'WardPatientService.doctor_paid_amount'=>'0'));*/
										}else if($serviceValue['name']==Configure::read('NursingCharges')){
											/*$this->WardPatientService->updateAll(array('WardPatientService.nurse_discount'=>'0',
													"WardPatientService.modified_time"=>"'$modified'"
													,"WardPatientService.modified_by"=>"'$modified_by'"
													/*,'WardPatientService.billing_id'=>$billId*///),
													/*array('WardPatientService.patient_id'=>$this->request->data['Billing']['patient_id'],
															'WardPatientService.nurse_paid_amount'=>'0'));*/
											
											$nurseArr=$this->WardPatientService->find('all',array('fields'=>array("WardPatientService.id",
													"WardPatientService.nurse_paid_amount",
													"WardPatientService.nurse_discount"),
													'conditions'=>array("WardPatientService.patient_id"=>$patient_id,
															"WardPatientService.is_deleted"=>'0',
															"WardPatientService.nurse_paid_amount"=>'0')));
											foreach($nurseArr as $wardRow){
												$this->WardPatientService->updateAll(array("WardPatientService.nurse_discount"=>'0',
														"WardPatientService.modified_time"=>"'$modified'"
														,"WardPatientService.modified_by"=>"'$modified_by'"),
														array("WardPatientService.id"=>$wardRow['WardPatientService']['id'],
																'OR'=>array(array("WardPatientService.nurse_paid_amount"=>'0'),
																		array("WardPatientService.nurse_paid_amount"=>NULL)),
																"WardPatientService.patient_id"=>$patient_id));
													
											}
										}
										//}
									}else{
										//if(empty($serviceValue['paid_amount']) || $serviceValue['paid_amount']<=0){
										if(!empty($serviceValue['service_bill_id'])){
											$dic=0;
											$this->ServiceBill->updateAll(array(
													'ServiceBill.discount'=>'0'/*,'ServiceBill.billing_id'=>$billId*/,
													"ServiceBill.modified_time"=>"'$modified'"
													,"ServiceBill.modified_by"=>"'$modified_by'"),
													array('ServiceBill.id'=>$serviceValue['service_bill_id'],
															'ServiceBill.patient_id'=>$patient_id,'ServiceBill.paid_amount'=>'0'));
										}
											
										//}
									}
								}else if(!empty($serviceValue['service_bill_id'])){
									$this->ServiceBill->updateAll(array(
											'ServiceBill.discount'=>'0',
											"ServiceBill.modified_time"=>"'$modified'"
											,"ServiceBill.modified_by"=>"'$modified_by'"
											/*'ServiceBill.billing_id'=>$billId*/),
											array('ServiceBill.id'=>$serviceValue['service_bill_id'],
													'ServiceBill.patient_id'=>$patient_id,'ServiceBill.paid_amount'=>'0'));
								}
				
							}
								
						}
					}//EOF inner foreach
						
				}//EOF outer foreach
				/************************************EOF  Reset discount of selcted Services*****************************************/
			}else{	
				/************************************set discount of selcted Services*****************************************/
			foreach($this->request->data['Billing'] as $billKey=>$billValue){
				foreach($billValue as $serviceKey=> $serviceValue){
					if(!empty($serviceValue['valChk'])){						
						
						if(($serviceCategory[$serviceValue['service_id']]==Configure::read('laboratoryservices'))||
								($serviceCategory[$serviceValue['service_id']]==Configure::read('radiologyservices'))||
								($serviceCategory[$serviceValue['service_id']]==Configure::read('surgeryservices')) ||
								($serviceCategory[$serviceValue['service_id']]==Configure::read('Consultant')) ||
								$serviceCategory[$serviceValue['service_id']]==Configure::read('Pharmacy') ||
								$serviceCategory[$serviceValue['service_id']]==Configure::read('OtPharmacy')){
							if($serviceCategory[$serviceValue['service_id']]==Configure::read('laboratoryservices')){
								$labKey='Laboratory';
								$model='LaboratoryTestOrder';
							}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('radiologyservices')){
								$labKey='Radiology';
								$model='RadiologyTestOrder';
							}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('surgeryservices')){
								$labKey='Surgery';
								$model='OptAppointment';
							}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('Consultant')){
								$labKey='Consultant';
								$model='ConsultantBilling';
							}elseif($serviceCategory[$serviceValue['service_id']]==Configure::read('Pharmacy')){
								$model='PharmacySalesBill';
							}elseif($serviceCategory[$serviceValue['service_id']]==Configure::read('OtPharmacy')){
								$model='OtPharmacySalesBill';
							}
								
							if($model=='ConsultantBilling'){
								$dic=0;
							$conBill=$this->$model->find('all',array('conditions'=>array("$model.id"=>$serviceValue['id'],
									"$model.paid_amount"=>array('0',''),
									"$model.patient_id"=>$patient_id)));
							$doctId=$conBill['0']['ConsultantBilling']['doctor_id'];
							if(!empty($serviceValue['discount'])){
								$dic=round($serviceValue['discount']);
							}else{
								$dic=0;
							}
							if(!empty($this->request->data['Billing']['foc'])){
								$dic=$serviceValue['amount'];
							}
							$this->$model->updateAll(array("$model.discount"=>$dic,
									/*"$model.billing_id"=>$billId*/
									"$model.modify_time"=>"'$modified'","$model.modified_by"=>"'$modified_by'"),
									array("$model.id"=>$serviceValue['id'],
											"$model.patient_id"=>$patient_id));
								
							}else if($model=='PharmacySalesBill'){
								$disPercent=$this->request->data['Billing']['discount_per'];
								$PharBill=$this->$model->find('all',array('fields'=>array("$model.id","$model.total","$model.paid_amnt",
										"$model.discount"),
										'conditions'=>array("$model.patient_id"=>$patient_id,"$model.is_deleted"=>'0',
												"$model.payment_mode"=>'Credit')));
								foreach($PharBill as $pharRow){	
									$salesDiscountAmt=0;
									if(!empty($serviceValue['discount']) || !empty($this->request->data['Billing']['foc'])){
										$salesDiscountAmt=$pharRow['PharmacySalesBill']['total']*$disPercent/100;//calculate discount
										$this->$model->updateAll(array("$model.discount"=>round($salesDiscountAmt),
												"$model.modified_time"=>"'$modified'","$model.modified_by"=>"'$modified_by'"),
												array("$model.id"=>$pharRow['PharmacySalesBill']['id'],"$model.patient_id"=>$patient_id,
														'PharmacySalesBill.billing_id '=>NULL));
										
										/* FOC on individual medicine also updating discount on detail--  pooja */										
										$detailDiscount=$this->PharmacySalesBillDetail->find('all',array(
												'fields'=>array('PharmacySalesBillDetail.id','PharmacySalesBillDetail.mrp','PharmacySalesBillDetail.qty'),
												'conditions'=>array("PharmacySalesBillDetail.pharmacy_sales_bill_id"=>$pharRow['PharmacySalesBill']['id'])));
										foreach($detailDiscount as $dDis){
											$tDis=0;
											$tDis=$dDis['PharmacySalesBillDetail']['mrp']*$dDis['PharmacySalesBillDetail']['qty'];
											$this->PharmacySalesBillDetail->updateAll(
													array('PharmacySalesBillDetail.discount'=>"'$tDis'"),
													array('PharmacySalesBillDetail.id'=>$dDis['PharmacySalesBillDetail']['id']));
										}
									}
								}
							}else if($model=='OtPharmacySalesBill'){
								$oTdisPercent=$this->request->data['Billing']['discount_per'];
								$oTPharBill=$this->$model->find('all',array('fields'=>array("$model.id","$model.total","$model.paid_amount",
										"$model.discount"),
										'conditions'=>array("$model.patient_id"=>$patient_id,"$model.is_deleted"=>'0',
												"$model.payment_mode"=>'Credit')));
								foreach($oTPharBill as $pharRow){	
									$oTsalesDiscountAmt=0;
									if(!empty($serviceValue['discount']) || !empty($this->request->data['Billing']['foc'])){
										$oTsalesDiscountAmt=$pharRow['OtPharmacySalesBill']['total']*$oTdisPercent/100;//calculate discount
										$this->$model->updateAll(array("$model.discount"=>round($oTsalesDiscountAmt),
												"$model.modified_time"=>"'$modified'","$model.modified_by"=>"'$modified_by'"),
												array("$model.id"=>$pharRow['OtPharmacySalesBill']['id'],"$model.patient_id"=>$patient_id,
														'OtPharmacySalesBill.billing_id '=>NULL));
										
										/* FOC on individual medicine also updating discount on detail--  pooja */
										$detailDiscount=$this->OtPharmacySalesBillDetail->find('all',array(
												'fields'=>array('OtPharmacySalesBillDetail.id','OtPharmacySalesBillDetail.mrp','OtPharmacySalesBillDetail.qty'),
												'conditions'=>array("OtPharmacySalesBillDetail.ot_pharmacy_sales_bill_id"=>$pharRow['OtPharmacySalesBill']['id'])));
										foreach($detailDiscount as $dDis){
											$tDis=0;
											$tDis=$dDis['OtPharmacySalesBillDetail']['mrp']*$dDis['OtPharmacySalesBillDetail']['qty'];
											$this->OtPharmacySalesBillDetail->updateAll(
													array('OtPharmacySalesBillDetail.discount'=>"'$tDis'"),
													array('OtPharmacySalesBillDetail.id'=>$dDis['OtPharmacySalesBillDetail']['id']));
										}
									}
								}
							}else if($model=='LaboratoryTestOrder' || $model=='RadiologyTestOrder'){
								$dic=0;
								$chkPaid=$this->$model->find('first',array('fields'=>array('paid_amount'),
										'conditions'=>array("$model.id"=>$serviceValue['id'],"$model.patient_id"=>$patient_id)));
								if(!empty($serviceValue['discount'])){
									$dic=round($serviceValue['discount']);
								}else{
									$dic=0;
								}
								if(!empty($this->request->data['Billing']['foc'])){
									$dic=$serviceValue['amount'];
								}
								$this->$model->updateAll(array("$model.discount"=>$dic,
										/*"$model.billing_id"=>$billId*/
										"$model.modified_bill_date"=>"'$modified'","$model.modified_bill_by"=>"'$modified_by'"),
										array("$model.id"=>$serviceValue['id'],"$model.patient_id"=>$patient_id));
							}
							else{
								$dic=0;
								//debug($model);
								//debug($serviceValue['discount']); exit;
								
								$chkPaid=$this->$model->find('first',array('fields'=>array('paid_amount'),
										'conditions'=>array("$model.id"=>$serviceValue['id'],"$model.patient_id"=>$patient_id)));
								if(!empty($serviceValue['discount'])){
									$dic=round($serviceValue['discount']);
								}else{
									$dic=0;
								}
								if(!empty($this->request->data['Billing']['foc'])){
									$dic=$serviceValue['amount'];
								}
								
								$this->$model->updateAll(array("$model.discount"=>$dic,
										/*"$model.billing_id"=>$billId*/
										"$model.modify_time"=>"'$modified'","$model.modified_by"=>"'$modified_by'"),
										array("$model.id"=>$serviceValue['id'],"$model.patient_id"=>$patient_id));
							}
							$paidAmt=0;
			
						}else{
							$dic=0;
						if($serviceCategory[$serviceValue['service_id']]==Configure::read('RoomTariff')){
							$this->loadModel('WardPatientService');
								$disPercent=$this->request->data['Billing']['discount_per'];
								$wardBill=$this->WardPatientService->find('all',array('fields'=>array("WardPatientService.id",
										"WardPatientService.amount","WardPatientService.paid_amount",
										"WardPatientService.discount"),
										'conditions'=>array("WardPatientService.patient_id"=>$patient_id,
												"WardPatientService.is_deleted"=>'0',"WardPatientService.paid_amount"=>'0')));
								foreach($wardBill as $wardRow){
									$salesDiscount=0;
									if(!empty($serviceValue['discount']) || !empty($this->request->data['Billing']['foc'])){
										$salesDiscountAmt=$wardRow['WardPatientService']['amount']*$disPercent/100;//calculate discount
										$this->WardPatientService->updateAll(array("WardPatientService.discount"=>round($salesDiscountAmt),
												"WardPatientService.modified_time"=>"'$modified'","WardPatientService.modified_by"=>"'$modified_by'"),
												array("WardPatientService.id"=>$wardRow['WardPatientService']['id'],'OR'=>array(array("WardPatientService.discount"=>'0'),array("WardPatientService.discount"=>NULL))
														/*"WardPatientService.discount"=>'0'*/,"WardPatientService.patient_id"=>$patient_id));
									}
								}
								
							
							
							/*if(!empty($serviceValue['discount'])){
								$dic=round($serviceValue['discount']);
							}else{
								$dic=0;
							}
							$this->WardPatientService->updateAll(array(
									'WardPatientService.discount'=>$dic/*,'WardPatientService.billing_id'=>$billId*///),
									/*array('WardPatientService.patient_id'=>$this->request->data['Billing']['patient_id'],
											'WardPatientService.ward_id'=>$serviceValue['id'],'WardPatientService.paid_amount'=>'0'));*/
						}else if($serviceCategory[$serviceValue['service_id']]==Configure::read('mandatoryservices')){
							$this->loadModel('WardPatientService');
							if($serviceValue['name']==Configure::read('DoctorsCharges') ||
									$serviceValue['name']==Configure::read('NursingCharges')){
								$disPercent=$this->request->data['Billing']['discount_per'];
								if($serviceValue['name']==Configure::read('DoctorsCharges')){
									$sercBill=$this->WardPatientService->find('all',array('fields'=>array("WardPatientService.id",
										"WardPatientService.doctor_paid_amount",
										"WardPatientService.doctor_discount"),
										'conditions'=>array("WardPatientService.patient_id"=>$patient_id,
												"WardPatientService.is_deleted"=>'0',"WardPatientService.doctor_paid_amount"=>'0')));	
									foreach($sercBill as $wardRow){
										$salesDiscount=0;
										if(!empty($serviceValue['discount']) || !empty($this->request->data['Billing']['foc'])){
											$salesDiscountAmt=$serviceValue['rate']*$disPercent/100;//calculate discount
											$this->WardPatientService->updateAll(
													array(
													"WardPatientService.doctor_discount"=>$salesDiscountAmt,
													"WardPatientService.modified_time"=>"'$modified'",
													"WardPatientService.modified_by"=>"'$modified_by'"),
													array("WardPatientService.id"=>$wardRow['WardPatientService']['id'],
															'OR'=>array(array("WardPatientService.doctor_discount"=>'0'),
																	array("WardPatientService.doctor_discount"=>NULL))
															,"WardPatientService.patient_id"=>$patient_id));
										}
										/*if(!empty($billUpdate['WardPatientService']['doctor_discount'])){
											$consBill[$billUpdate['WardPatientService']['billing_id']]=$consBill[$billUpdate['WardPatientService']['billing_id']]+$billUpdate['WardPatientService']['doctor_discount'];
										}*/
											
									}
									/*$this->WardPatientService->updateAll(array('WardPatientService.doctor_paid_amount'=>'0',
											'WardPatientService.doctor_discount'=>'0','WardPatientService.billing_id'=>$billId,
											"WardPatientService.modified_time"=>"'$modified'"),
											array('WardPatientService.patient_id'=>$this->request->data['Billing']['patient_id'],
													'WardPatientService.doctor_paid_amount !='=>'0'));*/
								}else if($serviceValue['name']==Configure::read('NursingCharges')){
									$nurseBill=$this->WardPatientService->find('all',array('fields'=>array("WardPatientService.id",
												"WardPatientService.nurse_paid_amount",
												"WardPatientService.nurse_discount"),
												'conditions'=>array("WardPatientService.patient_id"=>$patient_id,
												"WardPatientService.is_deleted"=>'0',"WardPatientService.nurse_paid_amount"=>'0')));
								
									foreach($nurseBill as $wardRow){
										$salesDiscount=0;
										if(!empty($serviceValue['discount']) || !empty($this->request->data['Billing']['foc'])){
											$salesDiscountAmt=$serviceValue['rate']*$disPercent/100;//calculate discount
											$this->WardPatientService->updateAll(
													array("WardPatientService.nurse_discount"=>$salesDiscountAmt,
													"WardPatientService.modified_time"=>"'$modified'",
															"WardPatientService.modified_by"=>"'$modified_by'"),
													array("WardPatientService.id"=>$wardRow['WardPatientService']['id'],
															'OR'=>array(array("WardPatientService.nurse_discount"=>'0'),
																	array("WardPatientService.nurse_discount"=>NULL))
															,"WardPatientService.patient_id"=>$patient_id));
										}
										/*if(!empty($billUpdate['WardPatientService']['nurse_discount'])){
											$consBill[$billUpdate['WardPatientService']['billing_id']]=$consBill[$billUpdate['WardPatientService']['billing_id']]+$billUpdate['WardPatientService']['nurse_discount'];
										}*/
											
									}
									/*$this->WardPatientService->updateAll(array('WardPatientService.nurse_paid_amount'=>'0',
											'WardPatientService.nurse_discount'=>'0','WardPatientService.billing_id'=>$billId,
											"WardPatientService.modified_time"=>"'$modified'"),
											array('WardPatientService.patient_id'=>$this->request->data['Billing']['patient_id'],
													'WardPatientService.nurse_paid_amount !='=>'0'));*/
								}
								
			
								//if($serviceValue['paid_amount']<$serviceValue['amount']){
									/*$this->loadModel('WardPatientService');
									if($serviceValue['name']==Configure::read('DoctorsCharges')){
										$dic=0;
									if(!empty($serviceValue['discount'])){
										$dic=round($serviceValue['discount']);
									}else{
										$dic=0;
									}
									if(!empty($this->request->data['Billing']['foc'])){
										$dic=$serviceValue['amount'];
									}
									$this->WardPatientService->updateAll(array(
											'WardPatientService.doctor_discount'=>$dic,
											"WardPatientService.modified_time"=>"'$modified'","WardPatientService.modified_by"=>"'$modified_by'"
											/'WardPatientService.billing_id'=>$billId/),
											array('WardPatientService.patient_id'=>$this->request->data['Billing']['patient_id'],
													'WardPatientService.doctor_paid_amount'=>'0'));
									}else if($serviceValue['name']==Configure::read('NursingCharges')){
										$dic=0;
										if(!empty($serviceValue['discount'])){
											$dic=round($serviceValue['discount']);
										}else{
											$dic=0;
										}
										$this->WardPatientService->updateAll(array('WardPatientService.nurse_discount'=>$dic,
												"WardPatientService.modified_time"=>"'$modified'","WardPatientService.modified_by"=>"'$modified_by'"
										/,'WardPatientService.billing_id'=>$billId/),
												array('WardPatientService.patient_id'=>$this->request->data['Billing']['patient_id'],
														'WardPatientService.nurse_paid_amount'=>'0'));
									}*/
								//}
							}else{
								//if(empty($serviceValue['paid_amount']) || $serviceValue['paid_amount']<=0){
									if(!empty($serviceValue['service_bill_id'])){
										$dic=0;
										if(!empty($serviceValue['discount'])){
											$dic=round($serviceValue['discount']);
										}else{
											$dic=0;
										}
										
										if(!empty($this->request->data['Billing']['foc'])){
											$dic=$serviceValue['amount'];
										}
										$this->ServiceBill->updateAll(array(
												'ServiceBill.discount'=>$dic/*,'ServiceBill.billing_id'=>$billId*/,
												"ServiceBill.modified_time"=>"'$modified'","ServiceBill.modified_by"=>"'$modified_by'"),
												array('ServiceBill.id'=>$serviceValue['service_bill_id'],
														'ServiceBill.patient_id'=>$patient_id,'ServiceBill.paid_amount'=>'0'));
									}
									
								//}
							}
						}else if(!empty($serviceValue['service_bill_id'])){
							$dic=0;
							if(!empty($serviceValue['discount'])){
								$dic=round($serviceValue['discount']);
							}else{
								$dic=0;
							}
							
							if(!empty($this->request->data['Billing']['foc'])){
								$dic=$serviceValue['amount'];
							}
							$this->ServiceBill->updateAll(array(
									'ServiceBill.discount'=>$dic,
									"ServiceBill.modified_time"=>"'$modified'","ServiceBill.modified_by"=>"'$modified_by'"
									/*'ServiceBill.billing_id'=>$billId*/),
									array('ServiceBill.id'=>$serviceValue['service_bill_id'],
											'ServiceBill.patient_id'=>$patient_id,'ServiceBill.paid_amount'=>'0'));
						}
						
						}
							
					}
				}//EOF inner foreach
					
			}//EOF outer foreach
			/************************************EOF discount of selcted Services*****************************************/
		}//else
			$this->redirect(array('controller'=>'Billings','action'=>'multiplePaymentModeIpd',$patient_id));
			//$this->redirect(array('controller'=>'Accounting','action'=>'patient_card_list'));
		}
		/**************************** EOF Post data processing***********************************************/
		
		
		
		
		//Configuration for patient card button "ONLY FOR VADODARA INSTANCE" -- Pooja
		$configInstance=$this->Session->read('website.instance');
		
		$this->set('configInstance',$configInstance);
		
		//EOF Configuration
	
		$this->generateReceipt($patient_id);
		
		$laboratoryTestOrderData  = $this->labDetails($patient_id);//lab data
		$this->set(array('labDetail'=>$laboratoryTestOrderData));
		
		$radTestOrderData  = $this->radDetails($patient_id);//radiology data
		$this->set(array('radiology'=>$radTestOrderData));
		
		$this->Patient->unBindModel(array('hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		
		$this->set('serviceCategory',$serviceCategory);
		$this->loadModel('TariffList');
		$tariffDocListId=$this->TariffList->getServiceIdByName(Configure::read('DoctorsCharges'));//get tariff list id
		
		$tariffNurseListId=$this->TariffList->getServiceIdByName(Configure::read('NursingCharges'));//get tariff list id
		
		$this->set(array('tariffDoctorId'=>$tariffDocListId,'tariffNurseListId'=>$tariffNurseListId));
		
		//Billing paid amount Calculations
		$this->loadModel('Billing');
		
		$this->loadModel('Configuration');
		
		$pharmConfig=$this->Configuration->getPharmacyServiceType();// to get pharmacy service type
		
		foreach($serviceCategory as $key=>$chkPharmcyGroup){
			$pharmacyGroupArray[$key]=$chkPharmcyGroup['ServiceCategory']['name'];
		}
		if(!in_array("Pharmacy", $pharmacyGroupArray)){
			$pharmConfig='no';
		}
		//EOF	
		// url flag to show pharmacy charges -- Pooja
		if($this->params->query['showPhar']){
			$pharmConfig['addChargesInInvoice']='yes';
		}	
		if($pharmConfig['addChargesInInvoice']=='yes'){
			$billDetail=$this->Billing->find('all',array('fields'=>array('Sum(Billing.discount) as discount',
					'Sum(Billing.amount) as amount','Sum(Billing.paid_to_patient) as refund'),
					'conditions'=>array('Billing.patient_id'=>$patient_id,'Billing.payment_category NOT'=>'advance')));
		}else if($pharmConfig['addChargesInInvoice']=='no'){
			$this->loadModel('ServiceCategory');
			$pharmacyCategoryId=$this->ServiceCategory->getPharmacyId();//in case need of pharmacy category ID
			$billDetail=$this->Billing->find('all',array('fields'=>array('Sum(Billing.discount) as discount',
					'Sum(Billing.amount) as amount','Sum(Billing.paid_to_patient) as refund'),
					'conditions'=>array('Billing.patient_id'=>$patient_id,'AND'=>array(array('Billing.payment_category !='=>$pharmacyCategoryId),array('Billing.payment_category NOT'=>'advance' )))));
		}
		$this->set('billDetail',$billDetail);
		//EOF Paid billing		
		$authPerson =$this->User->find('all',array('fields'=>array('id','CONCAT(first_name," ",last_name) as lookup_name'),
				'conditions'=>array('User.is_authorized_for_discount'=>'1','User.is_deleted'=>'0','User.is_active'=>'1'/*,
						'User.location_id'=>$this->Session->read('locationid')*/)));
			
		foreach($authPerson as $authPerson){
			$key=$authPerson["User"]["id"];
			$authPersonArr[$key]=$authPerson["0"]["lookup_name"];
		}
		//debug($authPersonArr);
		$this->set('authPerson',$authPersonArr);
		
		$this->loadModel('User');
		
		$guarantor =$this->User->find('all',array('fields'=>array('id','CONCAT(first_name," ",last_name) as lookup_name'),
				'conditions'=>array('User.is_guarantor'=>'1','User.is_deleted'=>'0','User.is_active'=>'1',
						'User.location_id'=>$this->Session->read('locationid'))));
		foreach($guarantor as $guarantor){
			$key=$guarantor["User"]["id"];
			$guarantorArr[$key]=$guarantor["0"]["lookup_name"];
		}
		$this->set('guarantor',$guarantorArr);
		
		/*
		 * doctor and nursing charges for mandatory servises
		*/
		
		if($tariffStdData['Patient']['admission_type']=='IPD'){
			$hospitalType = $this->Session->read('hospitaltype');
			//new ward charges
			$wardCharges=$this->wardCharges($patient_id);	//echo '<pre>';print_r($wardCharges);
			$this->set('wardNew',$wardCharges);
			//
			$totalWardDays=count($wardCharges['day']); //total no of days
			$doctorCharges = $this->Billing->getDoctorCharges($totalWardDays,$hospitalType,$tariffStdData['Patient']['tariff_standard_id'],
					$tariffStdData['Patient']['admission_type'],
					$tariffStdData['Patient']['treatment_type']);
			$nursingCharges = $this->Billing->getNursingCharges($totalWardDays,$hospitalType,$tariffStdData['Patient']['tariff_standard_id']);
			$this->set('totalWardDays',$totalWardDays);
			foreach($wardCharges['day'] as $docNurse){
				$doctorPaidCharges=$doctorPaidCharges+$docNurse['doctor_paid_amount'];
				/*if(empty($doctorDiscount))
					$doctorDiscount=$docNurse['doctor_discount'];*/
				$doctorDiscount=$doctorDiscount+$docNurse['doctor_discount'];
				$nursePaidCharges=$nursePaidCharges+$docNurse['nurse_paid_amount'];
				/*if(empty($nurseDiscount))
					$nurseDiscount=$docNurse['nurse_discount'];*/
				$nurseDiscount=$nurseDiscount+$docNurse['nurse_discount'];
			}
			
			$this->set(array('doctorCharges'=>$doctorCharges,'nursingCharges'=>$nursingCharges,
					'doctorPaidCharges'=>$doctorPaidCharges,'nursePaidCharges'=>$nursePaidCharges,
					'nurseDiscount'=>$nurseDiscount,'doctorDiscount'=>$doctorDiscount));
		}
		$this->loadModel('OtPharmacySalesBill');
		$this->loadModel('OtPharmacySalesReturn');
		$this->loadModel('InventoryPharmacySalesReturn');
		$this->loadModel('PharmacySalesBill');
		
		
		$pharmacyPaidData = $this->PharmacySalesBill->find('all',array('fields'=>array('Sum(PharmacySalesBill.total) as total',
				'Sum(PharmacySalesBill.paid_amnt) as paid_amount','sum(PharmacySalesBill.discount) as discount'),
				'conditions'=>array('PharmacySalesBill.patient_id'=>$patient_id,'PharmacySalesBill.is_deleted'=>'0',
				)));
		$pharmacyreturnData = $this->InventoryPharmacySalesReturn->find('all',
				array('fields'=>array('Sum(InventoryPharmacySalesReturn.total) as total',
						'Sum(InventoryPharmacySalesReturn.discount) as total_discount'),
						'conditions'=>array('InventoryPharmacySalesReturn.patient_id'=>$patient_id,
								'InventoryPharmacySalesReturn.is_deleted'=>'0',
		)));
		$oTpharmacyPaidData = $this->OtPharmacySalesBill->find('all',array('fields'=>array(
				'Sum(OtPharmacySalesBill.total) as total','Sum(OtPharmacySalesBill.paid_amount) as paid_amount',
				'sum(OtPharmacySalesBill.discount) as discount'),
				'conditions'=>array('OtPharmacySalesBill.patient_id'=>$patient_id,
				'OtPharmacySalesBill.is_deleted'=>'0',
		)));
		$oTpharmacyReturnData = $this->OtPharmacySalesReturn->find('all',array('fields'=>array(
				'Sum(OtPharmacySalesReturn.total) as total',
				'Sum(OtPharmacySalesReturn.discount) as total_discount'),
				'conditions'=>array('OtPharmacySalesReturn.patient_id'=>$patient_id,
				'OtPharmacySalesReturn.is_deleted'=>'0',
		)));
		
		//Pharmacy return paid amount i.e that amount whose refund has been given having billing id - Pooja
		$pharmacyReturnPaid=$this->Billing->returnPaidAmount($patient_id);
		$this->set('pharmacyReturnPaid',$pharmacyReturnPaid);
		$this->set('pharmacyPaidData',$pharmacyPaidData);
		$this->set('pharmacyreturnData',$pharmacyreturnData);
		$this->set('oTpharmacyPaidData',$oTpharmacyPaidData);
		$this->set('oTpharmacyReturnData',$oTpharmacyReturnData);
		
	}
	
	/**
	 * for updating submitted billed amount
	 * @param unknown_type $patient_id
	 * @ yashwant
	 */
	public function updateBilledAmount($patient_id){
		$this->loadModel('FinalBilling');
		$this->loadModel('VoucherLog');
		//$this->Patient->updateAll(array('submitted_amount'=>$this->request->data['submited_amount']),array('id'=>$patient_id));
		$this->FinalBilling->updateAll(array('total_amount'=>$this->request->data['submited_amount']),array('patient_id'=>$patient_id));
		$this->VoucherLog->updateAll(array('debit_amount'=>$this->request->data['submited_amount']),array('patient_id'=>$patient_id,'type'=>'FinalDischarge'));//for accounting by amit jain
		exit;
	}
	

	/**
	 * for uploading submitted excel
	 * @param unknown_type $patient_id
	 * @yashwant
	 */
	public function uploadCorporateExcel($patient_id){
		
		$this->set('flag',$this->params->query['flag']);
		$this->set('tariffStdId',$this->params->query['tariffStdId']);
		$this->set('patient_id',$patient_id);
		$this->loadModel('PatientDocument');
		 
		// upload excel
		if ($this->request->data['PatientDocument'] ['file_name']['name']) {
				$imgName = explode ( '.', $this->request->data['PatientDocument'] ['file_name']['name'] );
				if (! isset ( $imgName [1] )) {
					$imagename = "billedExcel_" . $imgName [0] . mktime () . '.' . $imgName [0];
				} else {
					$imagename = "billedExcel_" . $imgName [0] . mktime () . '.' . $imgName [1];
				}
				if (! empty ( $this->request->data['PatientDocument'] ['file_name']['name'] )) {
					$path = WWW_ROOT . 'uploads/corporateExcel/' . trim($imagename);
					move_uploaded_file ($this->request->data['PatientDocument'] ['file_name']['tmp_name'], $path );
				}
				$dataVal = array ();
				$dataVal ['name'] = "Corporate Excel";
				$dataVal ['location_id'] = $this->Session->read ( "locationid" );
				$dataVal ['create_time'] = date ( 'Y-m-d H:i:s' );
				$dataVal ['created_by'] = $this->Session->read('userid');
				$dataVal ['type'] = $this->request->data['PatientDocument'] ['file_name'] ['type'];
				$dataVal ['size'] = $this->request->data['PatientDocument'] ['file_name'] ['size'];
				$dataVal ['filename'] = $imagename;
				$dataVal ['patient_id'] = $this->request->data['PatientDocument']['patient_id'];
		
				$this->PatientDocument->save ( $dataVal );
				$this->PatientDocument->id = '';
				
				$isSuccess='yes';
				$this->set('isSuccess',$isSuccess);
				
				if($this->request->data['PatientDocument']['flag']=='reportUpload'){
					$this->redirect(array("controller" => "Corporates", "action" => "other_outstanding_report",$this->request->data['PatientDocument']['tariffStdId'],'admin'=>true));
				}else{
					$this->redirect(array("controller" => "billings", "action" => "multiplePaymentModeIpd",$this->request->data['PatientDocument']['patient_id']));
				}
		}
		// EOF excel
	}
	/**
	 * function for sending apporoval request for change tariff and ward 
	 * @ Swati Newale
	 * **/
	function ajax_ward_tariff_change_request(){
	
		$this->layout = "ajax";
		$this->loadModel("ApproveRequest");
		$this->ApproveRequest->bindModel(array('belongsTo'=>array(
				'Patient' =>array('foreignKey'=>'patient_id'),
				'User' => array('foreignKey'=>'request_to'),
				'AliasUser' => array('className'=>'User','foreignKey'=>'request_by'),
		)));

		$date = date('Y-m-d');
		$conditions['ajax_ward_tariff_change_request.create_time LIKE'] = $date."%";
	
		$request = $this->ApproveRequest->find('all',array(
				'fields'=>array('Patient.lookup_name','ApproveRequest.*','CONCAT(User.first_name," ",User.last_name) as requested_to_lookup_name' , 
						'CONCAT(AliasUser.first_name," ",AliasUser.last_name) as requested_by_lookup_name'),
				'order'=>array('ApproveRequest.id'=>'DESC'),
				'conditions'=>array('ApproveRequest.location_id' => $this->Session->read('locationid'))));
		$this->set('results',$request);#	debug($request);
	}
	/**
	 * function for update apporoval request for change tariff and ward
	 * @ Swati Newale
	 * **/
	public function ApprovalRequestForWardTariff(){
		$this->autoRender = false;
		$this->loadModel("ApproveRequest");
		$this->ApproveRequest->UpdateApprovalStatus($this->request->data);// approved or reject the status by updating.. (1 for approved nad 2 for reject)
		$this->ajax_ward_tariff_change_request();
		$this->render('ajax_ward_tariff_change_request');
	} 

	
	/**
	 * Function to get the print of billed services at one time
	 * @param unknown_type $billId //Billing id
	 * Pooja Gupta
	 */
	
	
	function getBilledServicePrint($billId){
		$this->layout=false;
		$this->uses=array('Billing','Patient','LaboratoryTestOrder','RadiologyTestOrder','WardPatientService',
				'ConsultantBilling','ServiceBill','OptAppointment','PharmacySalesBill','OtPharmacySalesBill');
		$this->Billing->bindModel(array(
						'belongsTo' => array('PatientCard'=>array('foreignKey'=>false,'conditions'=>array('Billing.id=PatientCard.billing_id')),)));
		$billData=$this->Billing->find('first',array('conditions'=>array('Billing.id'=>$billId)));
		 
		$this->set('billNo',$billData['Billing']['bill_number']);
		$patient=$this->Patient->find('first',array('fields'=>array('Patient.lookup_name','Patient.id','Patient.admission_id','Patient.tariff_standard_id',
				'Patient.treatment_type','Patient.admission_type','Patient.patient_id'),
				'conditions'=>array('Patient.id'=>$billData['Billing']['patient_id'])));	
		
		$this->patient_info($patient['Patient']['id']);// for element -Atul
		$doctorIDArr = array();
		$serviceIds=unserialize($billData['Billing']['tariff_list_id']);// from billing tariff_list_id  --yashwant
		foreach($serviceIds as $serviceKey => $serviceVal){
			if(strtolower($serviceKey)=='laboratory'){//for laboratory services
				$this->LaboratoryTestOrder->bindModel(array(
						'belongsTo' => array('Laboratory'=>array('type'=>'inner','foreignKey'=>'laboratory_id'),)));
				$labBill=$this->LaboratoryTestOrder->find('all',array('fields'=>array('LaboratoryTestOrder.id','Laboratory.name','LaboratoryTestOrder.amount',
						'LaboratoryTestOrder.paid_amount','LaboratoryTestOrder.discount','LaboratoryTestOrder.billing_id','LaboratoryTestOrder.doctor_id')
						,'conditions'=>array('LaboratoryTestOrder.id'=>$serviceVal)));
				
			}else if(strtolower($serviceKey)=='radiology'){//for radiology services
				$this->RadiologyTestOrder->bindModel(array(
						'belongsTo' => array('Radiology'=>array('type'=>'inner','foreignKey'=>'radiology_id'),)));
				$radBill=$this->RadiologyTestOrder->find('all',array('fields'=>array('RadiologyTestOrder.id','Radiology.name','RadiologyTestOrder.amount',
						'RadiologyTestOrder.paid_amount','RadiologyTestOrder.discount','RadiologyTestOrder.billing_id','RadiologyTestOrder.doctor_id')
						,'conditions'=>array('RadiologyTestOrder.id'=>$serviceVal)));
				
			}else if(strtolower($serviceKey)=='consultant'){//for services belongs to consultant billing
				$this->ConsultantBilling->bindModel(array(
						'belongsTo' => array('Consultant'=>array('type'=>'inner','foreignKey'=>'consultant_id'))));
				$consBill=$this->ConsultantBilling->find('all',array('fields'=>array('ConsultantBilling.id','CONCAT (Consultant.first_name, " ",Consultant.last_name) as name','ConsultantBilling.amount',
						'ConsultantBilling.paid_amount','ConsultantBilling.discount')
						,'conditions'=>array('ConsultantBilling.id'=>$serviceVal)));
				$this->ConsultantBilling->bindModel(array(
						'belongsTo' => array('DoctorProfile'=>array('type'=>'inner','foreignKey'=>'doctor_id'))));
				$doctBill=$this->ConsultantBilling->find('all',array('fields'=>array('ConsultantBilling.id','CONCAT (DoctorProfile.first_name, " ",DoctorProfile.last_name) as name','ConsultantBilling.amount',
						'ConsultantBilling.paid_amount','ConsultantBilling.discount')
						,'conditions'=>array('ConsultantBilling.id'=>$serviceVal)));
				$consBill=array_merge($consBill,$doctBill);
				
			}else{//for all dynamic groups belongs to serviceBill
				$this->ServiceBill->bindModel(array(
						'belongsTo' => array('TariffList'=>array('type'=>'inner','foreignKey'=>'tariff_list_id'),)));
				
				$serviceBill=$this->ServiceBill->find('all',array('fields'=>array('ServiceBill.id','TariffList.name','ServiceBill.amount','ServiceBill.no_of_times',
						'ServiceBill.paid_amount','ServiceBill.discount','ServiceBill.billing_id','ServiceBill.doctor_id')
						,'conditions'=>array('ServiceBill.id'=>$serviceVal)));
				
				if(!empty($serviceBill[0]['ServiceBill']['amount'])){
					foreach($serviceBill as $service){
						$doctorIDArr[]=$service['ServiceBill']['doctor_id'];
						$billedService[$billId][$service['ServiceBill']['id']]['name']=$service['TariffList']['name'];
						$billedService[$billId][$service['ServiceBill']['id']]['qty']=$service['ServiceBill']['no_of_times'];
						$billedService[$billId][$service['ServiceBill']['id']]['rate']=$service['ServiceBill']['amount'];
						$billedService[$billId][$service['ServiceBill']['id']]['amount']=$service['ServiceBill']['amount']*$service['ServiceBill']['no_of_times'];
						$billedService[$billId][$service['ServiceBill']['id']]['paid']=$service['ServiceBill']['paid_amount'];
				
						if($billId==$service['ServiceBill']['billing_id']){//discount shold only belongs to respective payment not for all  --yashwant
							$billedService[$billId][$service['ServiceBill']['id']]['discount']=$service['ServiceBill']['discount'];
						}
						//for refunded service, showing refunded amount in the receipt  --yashwant
						if(($service['ServiceBill']['paid_amount']=='0' && $service['ServiceBill']['discount']=='0' && $billId==$service['ServiceBill']['billing_id']) || ($billId!=$service['ServiceBill']['billing_id'])){
							$billedService[$billId][$service['ServiceBill']['id']]['refund']=$service['ServiceBill']['amount'];
						}
					}
				}
			}
		}  
		 
		 
		$pharmacyBill=$this->PharmacySalesBill->find('all',array('fields'=>array('Sum(PharmacySalesBill.total) as total',
				'Sum(PharmacySalesBill.paid_amnt) as paid','Sum(PharmacySalesBill.discount) as discount')
				,'conditions'=>array('PharmacySalesBill.billing_id'=>$billId),));
		
		$this->OptAppointment->bindModel(array(
				'belongsTo' => array('Surgery'=>array('type'=>'inner','foreignKey'=>'surgery_id'),)));
		$optBill=$this->OptAppointment->find('all',array('fields'=>array('OptAppointment.id','Surgery.name',
				'(Sum(OptAppointment.surgery_cost)+Sum(OptAppointment.anaesthesia_cost)+Sum(OptAppointment.ot_charges)) as total',
				'OptAppointment.paid_amount','OptAppointment.discount')
				,'conditions'=>array('OptAppointment.billing_id'=>$billId),
				'group'=>array('OptAppointment.surgery_id')));
		
		$oTPharmacyBill=$this->OtPharmacySalesBill->find('all',array('fields'=>array('Sum(OtPharmacySalesBill.total) as total',
				'Sum(OtPharmacySalesBill.paid_amount) as paid','Sum(OtPharmacySalesBill.discount) as discount')
				,'conditions'=>array('OtPharmacySalesBill.billing_id'=>$billId)));
		
		$this->WardPatientService->bindModel(array(
				'belongsTo' => array('Ward'=>array('type'=>'inner','foreignKey'=>'ward_id'),)));
		$wardBill=$this->WardPatientService->find('all',array('fields'=>array('Count(WardPatientService.id) as days','Ward.name',
				'Sum(WardPatientService.amount) as total',
				'Sum(WardPatientService.paid_amount) as paid','Sum(WardPatientService.discount) as discount')
				,'conditions'=>array('WardPatientService.billing_id'=>$billId),
				'group'=>array('WardPatientService.ward_id')
		));		
		
		$doctorCharges = $this->Billing->getDoctorCharges(1,$hospitalType,$patient['Patient']['tariff_standard_id'],$patient['Patient']['admission_type'],$patient['Patient']['treatment_type']);
		
		$nursingCharges = $this->Billing->getNursingCharges(1,$hospitalType,$patient['Patient']['tariff_standard_id']);
		
		$docBill=$this->WardPatientService->find('all',array('fields'=>array('WardPatientService.doctor_paid_amount',
				'WardPatientService.doctor_discount')
				,'conditions'=>array('WardPatientService.billing_id'=>$billId),
		));
		
		$nurseBill=$this->WardPatientService->find('all',array('fields'=>array(
				'WardPatientService.nurse_paid_amount','WardPatientService.nurse_discount')
				,'conditions'=>array('WardPatientService.billing_id'=>$billId),
		));
		
		
		
		if(!empty($labBill[0]['LaboratoryTestOrder']['amount'])){
			foreach($labBill as $lab){
				$doctorIDArr[]=$lab['LaboratoryTestOrder']['doctor_id'];
				$billedService[$billId][$lab['LaboratoryTestOrder']['id']]['name']=$lab['Laboratory']['name'];
				$billedService[$billId][$lab['LaboratoryTestOrder']['id']]['qty']='1';
				$billedService[$billId][$lab['LaboratoryTestOrder']['id']]['rate']=$lab['LaboratoryTestOrder']['amount'];
				$billedService[$billId][$lab['LaboratoryTestOrder']['id']]['amount']=$lab['LaboratoryTestOrder']['amount'];
				$billedService[$billId][$lab['LaboratoryTestOrder']['id']]['paid']=$lab['LaboratoryTestOrder']['paid_amount'];
				
				if($billId==$lab['LaboratoryTestOrder']['billing_id']){//discount shold only belongs to respective payment not for all  --yashwant
					$billedService[$billId][$lab['LaboratoryTestOrder']['id']]['discount']=$lab['LaboratoryTestOrder']['discount'];
				}
				//for refunded service, showing refunded amount in the receipt  --yashwant
				if(($lab['LaboratoryTestOrder']['paid_amount']=='0' && $lab['LaboratoryTestOrder']['discount']=='0' && $billId==$lab['LaboratoryTestOrder']['billing_id']) || ($billId!=$lab['LaboratoryTestOrder']['billing_id'])){
					$billedService[$billId][$lab['LaboratoryTestOrder']['id']]['refund']=$lab['LaboratoryTestOrder']['amount'];
				}
			}
		}
		if(!empty($radBill[0]['RadiologyTestOrder']['amount'])){
			foreach($radBill as $rad){
				$doctorIDArr[]=$rad['RadiologyTestOrder']['doctor_id'];
				$billedService[$billId][$rad['RadiologyTestOrder']['id']]['name']=$rad['Radiology']['name'];
				$billedService[$billId][$rad['RadiologyTestOrder']['id']]['qty']='1';
				$billedService[$billId][$rad['RadiologyTestOrder']['id']]['rate']=$rad['RadiologyTestOrder']['amount'];
				$billedService[$billId][$rad['RadiologyTestOrder']['id']]['amount']=$rad['RadiologyTestOrder']['amount'];
				$billedService[$billId][$rad['RadiologyTestOrder']['id']]['paid']=$rad['RadiologyTestOrder']['paid_amount'];
				
				if($billId==$rad['RadiologyTestOrder']['billing_id']){//discount shold only belongs to respective payment not for all  --yashwant
					$billedService[$billId][$rad['RadiologyTestOrder']['id']]['discount']=$rad['RadiologyTestOrder']['discount'];
				}
				//for refunded service, showing refunded amount in the receipt  --yashwant
				if(($rad['RadiologyTestOrder']['paid_amount']=='0' && $rad['RadiologyTestOrder']['discount']=='0' && $billId==$rad['RadiologyTestOrder']['billing_id']) || ($billId!=$rad['RadiologyTestOrder']['billing_id'])){
					$billedService[$billId][$rad['RadiologyTestOrder']['id']]['refund']=$rad['RadiologyTestOrder']['amount'];
				}
			}
		}
		if(!empty($consBill[0]['ConsultantBilling']['amount'])){
			foreach($consBill as $con){
				$billedService[$billId][$con['ConsultantBilling']['id']]['name']=$con[0]['name'];
				$billedService[$billId][$con['ConsultantBilling']['id']]['qty']='1';
				$billedService[$billId][$con['ConsultantBilling']['id']]['rate']=$con['ConsultantBilling']['amount'];
				$billedService[$billId][$con['ConsultantBilling']['id']]['amount']=$con['ConsultantBilling']['amount'];
				$billedService[$billId][$con['ConsultantBilling']['id']]['discount']=$con['ConsultantBilling']['discount'];
				$billedService[$billId][$con['ConsultantBilling']['id']]['paid']=$con['ConsultantBilling']['paid_amount'];
			}
		}
		/* if(!empty($serviceBill[0]['ServiceBill']['amount'])){
			foreach($serviceBill as $service){
				$billedService[$billId][$service['ServiceBill']['id']]['name']=$service['TariffList']['name'];
				$billedService[$billId][$service['ServiceBill']['id']]['qty']=$service['ServiceBill']['no_of_times'];
				$billedService[$billId][$service['ServiceBill']['id']]['rate']=$service['ServiceBill']['amount'];
				$billedService[$billId][$service['ServiceBill']['id']]['amount']=$service['ServiceBill']['amount']*$service['ServiceBill']['no_of_times'];
				$billedService[$billId][$service['ServiceBill']['id']]['paid']=$service['ServiceBill']['paid_amount'];
				
				if($billId==$service['ServiceBill']['billing_id']){//discount shold only belongs to respective payment not for all  --yashwant
					$billedService[$billId][$service['ServiceBill']['id']]['discount']=$service['ServiceBill']['discount'];
				}
				//for refunded service, showing refunded amount in the receipt  --yashwant
				if(($service['ServiceBill']['paid_amount']=='0' && $service['ServiceBill']['discount']=='0' && $billId==$service['ServiceBill']['billing_id']) || ($billId!=$service['ServiceBill']['billing_id'])){
					$billedService[$billId][$service['ServiceBill']['id']]['refund']=$service['ServiceBill']['amount'];
				}
			}
		} */
		if(!empty($optBill[0][0]['total'])){
			foreach($optBill as $opt){//debug($opt);
				$billedService[$billId][$opt['OptAppointment']['id']]['name']=$opt['Surgery']['name'];
				$billedService[$billId][$opt['OptAppointment']['id']]['qty']='1';
				$billedService[$billId][$opt['OptAppointment']['id']]['rate']=$opt[0]['total'];
				$billedService[$billId][$opt['OptAppointment']['id']]['amount']=$opt[0]['total'];
				$billedService[$billId][$opt['OptAppointment']['id']]['discount']=$opt['OptAppointment']['discount'];
				$billedService[$billId][$opt['OptAppointment']['id']]['paid']=$opt['OptAppointment']['paid_amount'];
			}
		}
		if(!empty($pharmacyBill[0][0]['total'])){
			foreach($pharmacyBill as $phar){//debug($opt);
				$billedService[$billId]['Pharmacy']['name']='Pharmacy';
				$billedService[$billId]['Pharmacy']['qty']='1';
				$billedService[$billId]['Pharmacy']['rate']=$phar[0]['total'];
				$billedService[$billId]['Pharmacy']['amount']=$phar[0]['total'];
				$billedService[$billId]['Pharmacy']['discount']=$phar[0]['discount'];
				$billedService[$billId]['Pharmacy']['paid']=$phar[0]['paid_amount'];
			}
		}
		
		if(!empty($oTPharmacyBill[0][0]['total'])){
			foreach($oTPharmacyBill as $otphar){//debug($opt);
				$billedService[$billId]['OT Pharmacy']['name']='OT Pharmacy';
				$billedService[$billId]['OT Pharmacy']['qty']='1';
				$billedService[$billId]['OT Pharmacy']['rate']=$otphar[0]['total'];
				$billedService[$billId]['OT Pharmacy']['amount']=$otphar[0]['total'];
				$billedService[$billId]['OT Pharmacy']['discount']=$otphar[0]['discount'];
				$billedService[$billId]['OT Pharmacy']['paid']=$otphar[0]['paid_amount'];
			}
		}
		
		if(!empty($wardBill[0][0]['total'])){
			foreach($wardBill as $ward){
				$billedService[$billId][$ward['Ward']['name']]['name']=$ward['Ward']['name'];
				$billedService[$billId][$ward['Ward']['name']]['qty']=$ward[0]['days'];
				$billedService[$billId][$ward['Ward']['name']]['rate']=$ward[0]['total']/$ward[0]['days'];
				$billedService[$billId][$ward['Ward']['name']]['amount']=$ward[0]['total'];
				$billedService[$billId][$ward['Ward']['name']]['discount']=$ward[0]['discount'];
				$billedService[$billId][$ward['Ward']['name']]['paid']=$ward[0]['paid'];
			}
		}
		if(!empty($docBill[0]['WardPatientService']['doctor_paid_amount'])){
			foreach($docBill as $doc){//debug($opt);
				$billedService[$billId]['Doctor']['name']='Doctor Charges';
				$billedService[$billId]['Doctor']['qty']=$billedService[$billId]['Doctor']['qty']+1;
				$billedService[$billId]['Doctor']['rate']=$doctorCharges;
				$billedService[$billId]['Doctor']['amount']=$billedService[$billId]['Doctor']['amount']+$doc['WardPatientService']['doctor_paid_amount'];
				$billedService[$billId]['Doctor']['discount']=$doc['WardPatientService']['doctor_discount'];
				$billedService[$billId]['Doctor']['paid']=$billedService[$billId]['Doctor']['paid']+$doc['WardPatientService']['doctor_paid_amount'];
			}
		}
		if(!empty($nurseBill[0]['WardPatientService']['nurse_paid_amount'])){
			foreach($nurseBill as $nurse){//debug($opt);
				$billedService[$billId]['Nurse']['name']='Nursing Charges';
				$billedService[$billId]['Nurse']['qty']=$billedService[$billId]['Nurse']['qty']+1;
				$billedService[$billId]['Nurse']['rate']=$nursingCharges;
				$billedService[$billId]['Nurse']['amount']=$billedService[$billId]['Nurse']['amount']+$nurse['WardPatientService']['nurse_paid_amount'];
				$billedService[$billId]['Nurse']['discount']=$nurse['WardPatientService']['nurse_discount'];
				$billedService[$billId]['Nurse']['paid']=$billedService[$billId]['Nurse']['paid']+$nurse['WardPatientService']['nurse_paid_amount'];
			}
		}
		
		$allDoctorList=$this->User->getAllDoctorList();
		$doctorIDArrName=array();
		foreach($doctorIDArr as $doctorIDArrKey=>$doctorIDArrValue){
			if(!in_array($allDoctorList[$doctorIDArrValue], $doctorIDArrName)){
				$doctorIDArrName[]=$allDoctorList[$doctorIDArrValue];
			}
		}
		$doctorIDArrName=implode(' , ',$doctorIDArrName);
		$this->set('doctorIDArrName',$doctorIDArrName);
		$this->set('billID',$billId);
		$this->set('patient',$patient);
		$this->set('billData',$billData);
		$this->set('billedService',$billedService);
	}

	
	/**
	 * for parent form  for the all encaunter list
	 * @param unknown_type $uID
	 * @yashwant
	 */
	public function billingReceiptReport($uID=null){
		$this->layout = 'advance';
		$this->loadModel('Person');
		$this->set('data','');
		
		
	}
	
	/**
	 * for list of patient encounter
	 * @yashwant
	 */
	public function patientEncounterList(){
		$this->layout = false;
		$this->loadModel('Patient');
		$this->set('data','');
 
		$search_key['Patient.is_deleted'] = 0;
		/*$search_key['Person.is_deleted'] = 0;
		$this->Patient->bindModel(array(
				'belongsTo' => array('Person' =>array('foreignKey' => false,'conditions'=>'Patient.person_id=Person.id'), 
				)),false);*/
		
		if(!empty($this->params->query)){ 
			$search_key['Patient.patient_id'] = $this->params->query['person_uid'];
			$conditions = $search_key;
		}else{
			//$conditions = array($search_key);
		}
		
		$data=$this->Patient->find('all',array(
				'conditions'=>$conditions,
				'fields'=>'Patient.form_received_on,Patient.form_received_on,Patient.discharge_date,Patient.lookup_name,Patient.id,Patient.patient_id,Patient.admission_type,
							Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,Patient.create_time ',/*'Person.ssn_us', 'Person.sex','Person.dob,
							'Person.first_name','Person.last_name','Person.mobile','Person.plot_no','Person.city',*/
				));
		$this->set('data',$data);
	
	}
	
	/**
	 * for list of all billing receipts of one patient
	 * @param unknown_type $patientID
	 * @yashwant
	 */
	public function allReceiptList($patientID=null){
		$this->layout = 'advance_ajax'; 
		$this->loadModel('Billing');
		$data=$this->Billing->find('all',array('conditions'=>array('Billing.patient_id'=>$patientID,'Billing.is_deleted'=>'0','Billing.discount_type'=>null,
				'OR'=>array(array('Billing.refund'=>'0'),array('Billing.refund'=>null))),
				'fields'=>'Billing.*'));
		$this->set('data',$data);
	}
	
	/**
	 * autocomplete for uid search
	 * @yashwant
	 */
	public function allUIDAutocomplete(){
		$this->uses = array('Person');
		$personData= $this->Person->find('list',array(
			'fields'=> array('Person.id','Person.patient_uid'),
			'conditions'=>array('Person.is_deleted'=>0,'Person.patient_uid like'=>'%'.$this->params->query['term'].'%'),
			'group'=>array('Person.id'),
			'limit'=>'20'));
		echo json_encode($personData);
		exit;
	}

	//Patient outstanding by amit jain
	function patient_outstanding_report(){
		$this->layout = 'advance';
		$this->uses=array('Ward','Patient','Billing','PatientCard','DoctorProfile','Bed','Room','Account','TariffStandard');
		$this->set('wardList',$this->Ward->getWardList());
		$this->set(count,$count = $this->Patient->find('count',array('conditions'=>array('Patient.is_discharge'=>0,'Patient.is_deleted'=>0,'Patient.admission_type'=>'IPD'))));
	}
	//Patient outstanding by amit jain
	function ajax_patient_outstanding_report($Reporttype){
		$this->layout = 'advance_ajax';
		$this->uses=array('Ward','Patient','Billing','PatientCard','DoctorProfile','Bed','Room','Account','TariffStandard');
		$this->set('wardList',$this->Ward->getWardList());
		if(!empty($this->params->query)){
			$this->request->data=$this->params->query;
		}
		if($this->request->data){
			if(!empty($this->request->data['patient_id'])){
				$patientId = $this->request->data['patient_id'];
				$conditions['Patient.id']=$patientId;
			}
			if(!empty($this->request->data['ward_id'])){
				$wardId=$this->request->data['ward_id'];
				$conditions['Patient.ward_id']=$wardId;
			}
			$conditions['Patient.is_discharge']='0';
			$conditions['Patient.is_deleted']='0';
			
			$this->Patient->bindModel(array(
					'belongsTo'=>array(
							"Person"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('Patient.person_id=Person.id')),
							"Ward"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('Patient.ward_id=Ward.id')),
							"Bed"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('Patient.bed_id=Bed.id')),
							"Room"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('Patient.room_id=Room.id')),
							"TariffStandard"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('Patient.tariff_standard_id=TariffStandard.id')),
							"DoctorProfile"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('DoctorProfile.user_id=Patient.doctor_id')))
			));
			$patientDetails=$this->Patient->find('all',array('fields'=>array('Patient.id','Patient.person_id','Patient.lookup_name','Patient.patient_id',
					'Ward.name','Person.mobile','Patient.form_received_on','Patient.admission_type','Patient.admission_id','TariffStandard.name','DoctorProfile.doctor_name','Room.bed_prefix','Bed.bedno'),
					'conditions'=>$conditions,'group'=>array('Patient.id')));
			foreach ($patientDetails as $key=>$patientData){
				$patientDetails[$key]['total_amount'] = $this->Billing->getPatientTotalBill($patientData['Patient']['id'],$patientData['Patient']['admission_type']);
				
				$surgeryData[] = array_merge($this->groupWardCharges($patientData['Patient']['id'],true),array('patient_id'=>$patientData['Patient']['id']));
				
				$billingDetails = $this->Billing->find('first',array('fields'=>array('SUM(amount) as totalAmountPaid','SUM(discount) as totalDiscount'),
						'conditions'=>array('patient_id'=>$patientData['Patient']['id'],'is_deleted'=>'0',
						'location_id'=>$this->Session->read('locationid'))));
				$patientDetails[$key]['amount_paid']= $billingDetails[0]['totalAmountPaid'];
				$patientDetails[$key]['amount_discount']= $billingDetails[0]['totalDiscount'];
				
				$cardDetails = $this->Account->find('first',array('fields'=>array('card_balance'),
						'conditions'=>array('system_user_id'=>$patientData['Patient']['person_id'],'is_deleted'=>'0',
						'location_id'=>$this->Session->read('locationid'),'user_type'=>'Patient')));
				$patientDetails[$key]['card_balance'] = $cardDetails['Account']['card_balance'];
			}
			$this->set('patientDetails',$patientDetails); 
			$this->set('surgeryDetails',$surgeryData);
			$this->set('patientId',$patientId);
			$this->set('wardId',$wardId);
			if(!$this->request->data['is_print']){
				$this->render('ajax_patient_outstanding_report',false);
			}
			if($Reporttype=='pdf'){
				$this->set('patientDetails',$patientDetails); 
				$this->set('surgeryDetails',$surgeryData);
				$this->set('patientId',$patientId);
				$this->set('wardId',$wardId);
				$this->layout=false;
				$this->render('patient_outstanding_report_pdf',false);
			}
			if($Reporttype=='excel'){
				$this->layout=false;
				$this->render('patient_outstanding_report_xls',false);
			}
		}
	}
	
	//For print patient outstanding report by amit jain
	function patient_outstanding_report_print(){
		$this->uses=array('Ward','Patient','Billing','PatientCard','DoctorProfile','Bed','Room','Account','TariffStandard');
		$this->request->data = $this->params->query ;
		$this->ajax_patient_outstanding_report();
		$this->layout = false;
	}
	
	//for cashier transaction temporary logout function when he gave some reason by amit jain
	public function updateReason(){
		$this->layout = false;
		$this->autoRender = false;
		$this->loadModel('CashierBatch');
		if(!empty($this->request->data)){
			$requestData['CashierBatch']['id']=$this->request->data['id'];
			$requestData['CashierBatch']['remark']=$this->request->data['remark'];
			$this->CashierBatch->save($requestData);
			$this->CashierBatch->id='';
			echo $this->Session->destroy();
			echo true;
		}
	}
	
	public function pharmacyShow(){
		$this->layout = false;
		$this->autoRender = false;
		$this->loadModel('Configuration');
		$this->Configuration->getPharmacyServiceTypeHope();
	}
/**  function for to edit invoice - for kanpur*- Atulc*/	
	public function summaryInvoice($patientId,$print=null){
		$this->uses = array('Patient','Person','FinalBilling','Diagnosis','TariffStandard','User','OptAppointment','ServiceBill','LaboratoryTestOrder','ConsultantBilling',
				            'RadiologyTestOrder','WardPatientService','PharmacySalesBill','ServiceCategory');
		
		$website=$this->Session->read('website.instance');
	
		$this->layout = false;
		if(!empty($this->request->data)){  
			
			$patId= $this->request->data['Patient']['patientID'];
			$saveOtService = array();
			foreach ($this->request->data['SummaryInvoice']['Surgery'] as $surgeryID => $surgeryHeads){
				$surgeryPrevRate="'".serialize($this->request->data['SummaryInvoice']['Surgery'][$surgeryID])."'";// Save prev surgery charges after editing summary invoice 
				$this->OptAppointment->updateAll(array('OptAppointment.ot_charges_for_summary_invoice'=>$surgeryPrevRate),array('OptAppointment.patient_id'=>$patId,'OptAppointment.surgery_id'=>$surgeryID));
				
				foreach ($surgeryHeads as $type => $amount){ 
					if(!is_numeric($type)){
						if($type == "ot_service"){ 
							$otData = array();
							foreach ($amount as $otKey => $otVal){ 
								$otData[$otKey] = $otVal['headsTotal'];
							} 
							$serializedData = "'".serialize($otData)."'"; 
							$this->OptAppointment->updateAll(array('OptAppointment.'.$type=>$serializedData),array('OptAppointment.patient_id'=>$patId,'OptAppointment.surgery_id'=>$surgeryID));
						}else{
							foreach ($amount as $otKey => $otVal){
								
								$this->OptAppointment->updateAll(array('OptAppointment.'.$type=>$otVal['headsTotal']),array('OptAppointment.patient_id'=>$patId,'OptAppointment.surgery_id'=>$surgeryID));
							}
						}
					}
				}
			} 
			$summryDiscData= serialize($this->request->data['SummaryInvoice']);
			$requestData['Patient']['summary_invoice_discount']=$summryDiscData;
			$this->Patient->id =$patId;
			$this->Patient->save($requestData['Patient']);
			$this->Session->setFlash(__('Record Updated Successfully.'),'default',array('class'=>'message'));
			
			//Update surgery Charges
			$this->redirect(array("controller" => "Billings", "action" => "summaryInvoice",$patId));
		}
		/** BOF Bill Header */
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'TariffStandard' =>array('foreignKey'=>'tariff_standard_id'),
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'OptAppointment' =>array('foreignKey' => false,'conditions'=>array('Patient.id=OptAppointment.patient_id' )),
						'Ward' =>array( 'foreignKey'=>false,'conditions'=>array('Ward.id = Patient.ward_id')),
						'Room' =>array('foreignKey'=>false,'conditions'=>array('Room.id = Patient.room_id')),
						'Bed' =>array('foreignKey'=>false,'conditions'=>array('Bed.id = Patient.bed_id')),
						'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )))
				,'hasOne'=>array('Diagnosis'=>array('foreignKey'=>'patient_id','fields'=>array('Diagnosis.final_diagnosis')))));
		
		$patient = $this->Patient->find('first',array('fields'=>array('Patient.id','Patient.admission_type','Patient.lookup_name','Patient.vip_chk','PatientInitial.name','Patient.ward_id','Patient.room_id','Patient.bed_id',
				'Patient.date_of_referral','Patient.form_received_on','Patient.admission_id','Patient.tariff_standard_id','Patient.doctor_id','Patient.payment_category','Patient.summary_invoice_discount',
				'Patient.is_packaged','Patient.is_discharge','Person.plot_no','Person.landmark','Person.pin_code','Person.state','Person.city','Person.district','Person.age','Person.sex','Person.mobile',
				'TariffStandard.name','Room.bed_prefix,Bed.bedno,Ward.name','OptAppointment.ot_charges_for_summary_invoice'),
				'conditions'=>array('Patient.id'=>$patientId)));

		$address= $patient['Person']['plot_no']." ".$patient['Person']['landmark']." ".$patient['Person']['district']." ".$patient['Person']['city']." ".$patient['Person']['pin_code'];
		$this->set('address',$address);
		$this->set('patient',$patient);
		$finalBillingData = $this->FinalBilling->find('first',array('conditions'=>array('FinalBilling.location_id'=>
				$this->Session->read('locationid'),'FinalBilling.patient_id'=>$patientId)));
		if(isset($finalBillingData['FinalBilling']['bill_number']) && $finalBillingData['FinalBilling']['bill_number']!=''){
			$bNumber = $finalBillingData['FinalBilling']['bill_number'];
			$this->set('billNumber',$bNumber);
		}else{
			$bNumber = $this->generateBillNo($patientId);
			$this->set('billNumber',$bNumber);
			
		}
		$this->set('finalBillingData',$finalBillingData);
		$this->set('diagnosisData',$this->Diagnosis->find('first',array('conditions'=>array('Diagnosis.patient_id'=>$patientId))));
		$this->set('tariffData',$this->TariffStandard->find('list',array('fields'=>array('id','name'))));
		$this->set('primaryConsultant',$this->User->getDoctorByID($patient['Patient']['doctor_id']));
		/** EOF BIll Header */
		/** BOF Surgery listing [ONLY NAMES] */
		$this->OptAppointment->unbindModel(array(
				'belongsTo' => array('Initial','Patient','Location','Opt','OptTable','Surgery','SurgerySubcategory','Doctor','DoctorProfile'
				)));
		$this->OptAppointment->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array( 'foreignKey'=>'tariff_list_id' ))));
		$this->set('surgeriesData',$this->OptAppointment->find('all',array('fields'=>array('TariffList.name'),
				'conditions'=>array('OptAppointment.patient_id'=>$patientId,'OptAppointment.is_deleted'=>0,'OptAppointment.location_id'=>$this->Session->read('locationid')))));
		/** EOF surgery Listing */
		$finalBillArray = array();
		$finalRefundAndDiscount = array();
		$isPackaged = $patient['Patient']['is_packaged'] != 0 ? true : false;
		/** BOF Billing Services */
		$serviceDetails = $this->getServicesChargeForInvoice($patientId , array() , $isPackaged);
		/** EOF Billing Services */
		/** BOF Room tariff */
		$serviceDetails = $this->getWardServiceChargesForInvoice($patientId , $serviceDetails , $isPackaged);
		/** EOF Room*/
		/** BOF Surgery Bills*/
		$serviceDetails = $this->getSurgeryChargesForInvoice($patientId , $serviceDetails , $isPackaged);
		/** EOF Surgery Bills*/
		/** BOF Lab */
		$serviceDetails = $this->getLaboratoryServiceChargesForInvoice($patientId , $serviceDetails , $isPackaged);
		/** EOF Lab*/
		/** BOF Rad*/
		$serviceDetails = $this->getRadiologyServiceChargesForInvoice($patientId , $serviceDetails , $isPackaged);
		/** EOF Rad */
		/** BOF Consultant Bill */
		$serviceDetails = $this->getConsultantServiceChargesForInvoice($patientId , $serviceDetails , $isPackaged);
		/** EOF Consultant Bill */

        /** BOF Advance Paid*/
        $advance = $this->Billing->find('first',array('fields'=>array('Sum(amount) as TotalPaid','SUM(paid_to_patient) as totalRefund'),'conditions'=>array('Billing.patient_id'=>$patientId,
                    'Billing.location_id'=>$this->Session->read('locationid'),'Billing.is_deleted'=>0)));
                    $serviceDetails[1]['TotalPaid'] = $advance[0]['TotalPaid'];
                    $serviceDetails[1]['TotalRefund'] = $advance[0]['totalRefund'];
                   
		/** EOF Advance Paid */
                    
        /** BOF ADVANCE PAYMENT DETAILS **/
        $advancePaymentDeatils = $this->Billing->find('all',array('fields'=>array('Billing.id','Billing.amount','Billing.payment_category','Billing.mode_of_payment','Billing.create_time','Billing.receiptNo'),'conditions'=>array('Billing.patient_id'=>$patientId,
                		'Billing.location_id'=>$this->Session->read('locationid'),'Billing.payment_category'=>'advance','Billing.is_deleted'=>0),'order'=>array('Billing.create_time DESC')));
         /** EOF ADVANCE PAYMENT DETAILS **/
        /** Pharmacy Charges For packaged patient **/
        if($patient['Patient']['is_packaged']=='1'){
      	$this->PharmacySalesBill->unbindModel(array('hasMany' => array('PharmacySalesBillDetail')));      
        /*$pharmacy_total= $this->PharmacySalesBill->find('all',array(
				'fields'=>array('SUM(PharmacySalesBill.total) as pharmacyTotal','SUM(PharmacySalesBill.paid_amnt) as paid_amount',
				'SUM(PharmacySalesBill.discount) as discount'),
				'conditions'=>array('PharmacySalesBill.patient_id'=>$patientId,
						'PharmacySalesBill.is_deleted'=>'0')));*/
      	$pharmacy_total=$this->getPharmacyFinalCharges($patientId);
      	$pharmacyReturnCharges = $this->getPharmacyReturnCharges($patientId);
      	$saleMinusReturnDisc = ($pharmacy_total[0]['discount']-$pharmacyReturnCharges[0]['sumReturnDiscount']);
     	$totalPharmacyCharge = round($pharmacy_total[0]['total']-$saleMinusReturnDisc); 
        $serviceDetails[0]['Medical Services']['Amount'] = round($totalPharmacyCharge);
       }
      
       /** Pharmacy Charges For packaged patient **/
        foreach ($serviceDetails[0] as $key => $val){ 
        	foreach ($val as $subKey => $subVal){  
        		$serviceDetails[0][$key]['NoOFTimes'] += $subVal['NoOFTimes'];
        		$serviceDetails[0][$key]['Rate'] += $subVal['Rate'];
        		$serviceDetails[0][$key]['Amount'] += $subVal['Amount'];
        	} 
        }
      
        // For total advance total
        foreach ($advancePaymentDeatils as $totalAdvanceAmount):
        $totalAdvance['totalAdvanceAmount']+=$totalAdvanceAmount['Billing']['amount'];
        endforeach;
        $pharmacyCategoryId=$this->ServiceCategory->getPharmacyId();
		
			$totalDiscountGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.discount) AS sumDiscount','Billing.payment_category' ),
					'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0','Billing.payment_category !='=>$pharmacyCategoryId)));
			$this->set('totalDiscountGiven',$totalDiscountGiven);
				
			$totalRefundGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.paid_to_patient) AS sumRefund','Billing.payment_category' ),
					'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0','Billing.refund'=>'1','Billing.payment_category !='=>$pharmacyCategoryId)));
			$this->set('totalRefundGiven',$totalRefundGiven);
	
        
        
        $this->set('totalAdvance',$totalAdvance);
		$this->set('finalBillArray', $serviceDetails[0]);
		$this->set('finalRefundAndDiscount', $serviceDetails[1]);
		$this->set('advancePaymentDeatils',$advancePaymentDeatils);
		
		if($print=='print'){
			$this->layout='print_with_header';
			$this->render('summary_invoice_print');
		}
	}
	/** function for to convert patient to packaged patient from billing page- only for kanpur- Atulc;**/
	public function isPackagePatient($patientId,$val)
	{
		$this->uses = array('Patient');
		$this->autoRender = false;
		$this->Layout = 'ajax';
		if($val!=NULL && !empty($patientId)){
			$this->request->data['Patient']['id']=$patientId;
			$this->request->data['Patient']['is_packaged'] = $val;
			if($this->Patient->validates())
				$this->Patient->save($this->request->data);
		}
	}

	public function getExternalRequisitionPrint($testOrderId=null,$tariffStandardId=null){
		$this->layout = "advance_ajax";
		$this->uses = array('RadiologyTestOrder','ServiceProvider','TariffAmount','TariffStandard','ExternalRequisition','ExternalRequisitionCommission');
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey' => false,'conditions'=>array('Radiology.id=RadiologyTestOrder.radiology_id')),
						'Patient'=>array('foreignKey' => false,'conditions'=>array('Patient.id=RadiologyTestOrder.patient_id')),
						'ExternalRequisition'=>array('foreignKey' => false,'conditions'=>array('RadiologyTestOrder.id=ExternalRequisition.radiology_test_order_id')),
						'ExternalRequisitionCommission'=>array('foreignKey' => false,'conditions'=>array('RadiologyTestOrder.service_provider_id=ExternalRequisitionCommission.service_provider_id','RadiologyTestOrder.radiology_id=ExternalRequisitionCommission.service_id','ExternalRequisitionCommission.is_deleted=0')),
						'TariffStandard' => array('foreignKey'=>false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
						'Diagnosis' => array('foreignKey'=>false,'conditions'=>array('Patient.id=Diagnosis.patient_id')),
						'User'=>array('foreignKey'=>false,'conditions'=>array('Patient.doctor_id=User.id')),
						'ServiceProvider'=>array('foreignKey' => false,'conditions'=>array('ServiceProvider.id=RadiologyTestOrder.service_provider_id')),
						'TariffAmount'=>array('foreignKey' => false,'conditions'=>array('TariffAmount.tariff_list_id=Radiology.tariff_list_id' ,'TariffAmount.tariff_standard_id'=>$tariffStandardId)),
				)),false);
		
		$radData = $this->RadiologyTestOrder->find('first',array('fields'=>array('Patient.id','Patient.lookup_name','Patient.age','Patient.sex','Patient.tariff_standard_id',
					'RadiologyTestOrder.*','TariffStandard.id','ExternalRequisition.*','ExternalRequisitionCommission.*','TariffStandard.name','ServiceProvider.contact_person','ServiceProvider.location','ServiceProvider.name','ServiceProvider.id','Radiology.name','TariffAmount.nabh_charges,TariffAmount.non_nabh_charges',
					'CONCAT(User.first_name," ",User.last_name) as user_name','Diagnosis.id','Diagnosis.final_diagnosis'),
				'conditions' =>array('RadiologyTestOrder.id'=>$testOrderId,'RadiologyTestOrder.is_deleted'=>'0'),
				'group'=>array('RadiologyTestOrder.id')));
		 
		$privateId = $this->TariffStandard->getPrivateTariffID();
		if($radData['Patient']['tariff_standard_id'] == $privateId){
			$tariff = "On Cash";
		}else{
			$tariff = "On Credit";
		}
		$this->set('tariff',$tariff);
		$this->set('radData',$radData);
	}

	public function saveTestOrderDetails(){
		$this->uses = array('RadiologyTestOrder','Diagnosis','ExternalRequisition','ServiceProvider','Patient','Message','Configuration');
		$this->layout = false;
		$this->autoRender = false; 
                
                $this->loadModel('ServicePromivider');
		if(!empty($this->request->data['radiology_test_order_id'])){  
                    
                    $getHopeProviderDetails=$this->ServiceProvider->getServiceProviderDataByCateggoryAndName(Configure::read('radiologyservices'),Configure::read('service_provider_hope'));
                    //if external requisition from hope hospitals than input only tarriff amount in external requisition by Swapnil - 31.03.2016
                    if($getHopeProviderDetails['ServiceProvider']['id'] == $this->request->data['service_provider_id']){
                        $this->request->data['hospital_commission'] = $this->request->data['private_amount'];
                        $this->request->data['collected_by'] = '1';
                        $this->RadiologyTestOrder->updateAll(array('RadiologyTestOrder.amount'=>$this->request->data['tariff_amount']),array('RadiologyTestOrder.id'=>$this->request->data['radiology_test_order_id']));
                    }else{
                        if($this->request->data['requisition_tariff'] == "Private"){
                                $this->request->data['hospital_commission'] = $this->request->data['private_amount'];
                        }else{
                                $this->request->data['hospital_commission'] = '0'; 
                        }

                        if($this->request->data['collected_by_hospital'] == 1){ 
                                $this->request->data['collected_by'] = '1';
                                $this->RadiologyTestOrder->updateAll(array('RadiologyTestOrder.amount'=>$this->request->data['tariff_amount']),array('RadiologyTestOrder.id'=>$this->request->data['radiology_test_order_id']));
                        }

                        if($this->request->data['collected_by_provider'] == 1){
                                $this->request->data['collected_by'] = '2';
                                $this->RadiologyTestOrder->updateAll(array('RadiologyTestOrder.amount'=>'0.1'),array('RadiologyTestOrder.id'=>$this->request->data['radiology_test_order_id']));
                        }

                        if($this->request->data['collected_by_hospital'] == 0 && $this->request->data['collected_by_provider'] == 0){
                                $this->request->data['hospital_commission'] = $this->request->data['private_amount'];
                        }
                    }
                    
                    if(!empty($this->request->data['external_requisition_id'])){
                            $this->request->data['modified_by'] = $this->Session->read('userid');
                            $this->request->data['modified_time'] = date("Y-m-d H:i:s");
                            $this->ExternalRequisition->id = $this->request->data['external_requisition_id'];
                            $this->ExternalRequisition->save($this->request->data);
                    }else{

                            $this->request->data['created_by'] = $this->Session->read('userid');
                            $this->request->data['created_time'] = date("Y-m-d H:i:s");
                            $this->ExternalRequisition->save($this->request->data);
                            //BOF-Mahalaxmi send SMS to external Radiologist for hope only			
							$getHopeProviderDetails=$this->ServiceProvider->getServiceProviderDataByCateggoryAndName(Configure::read('radiologyservices'),Configure::read('service_provider_hope'));								
							$smsActive=$this->Configuration->getConfigSmsValue('Radiology Request');
							$retMsg='';				
							if(isset($smsActive) && $getHopeProviderDetails['ServiceProvider']['id']==$this->request->data['service_provider_id']){		
								if(empty($this->request->data['patient_id'])){			
									$radDetails=$this->RadiologyTestOrder->findRadiologyDetailsById($this->request->data['radiology_test_order_id']);
									$patientIdSms=$radDetails['RadiologyTestOrder']['patient_id'];
								}else{
									$patientIdSms=$this->request->data['patient_id'];
								}
								$getPatientDetails=$this->Patient->getFirstPatientDetails($patientIdSms);
								$getSexPatient=strtoUpper(substr($getPatientDetails['Patient']['sex'],0,1));
								$getAgeResultSms=$this->General->convertYearsMonthsToDaysSeparate($getPatientDetails['Patient']['age']);
								$showMsg= sprintf(Configure::read('radiology_request'),$getPatientDetails['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms,$getHopeProviderDetails['ServiceProvider']['contact_person'],Configure::read('hosp_details'));	
								$bothSendNos=array($getHopeProviderDetails['ServiceProvider']['contact_no'],Configure::read('radiologist_manager'));
									
									$implodeNos=implode(',',$bothSendNos);			
										
								$retMsg=$this->Message->sendToSms($showMsg,$implodeNos); //to send Hope external radiologist

								if(trim($retMsg)==Configure::read('sms_confirmation')){	
									$showMsgReturn= sprintf(Configure::read('radiology_request_return'),$getPatientDetails['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms,$getHopeProviderDetails['ServiceProvider']['contact_person']);	
									$this->Message->sendToSms($showMsgReturn,Configure::read('owner_no')); //to send return sms to owne
								}
							}//EOF if $smsActive		
							//EOF-Mahalaxmi send SMS to external Radiologist for hope only
                    } 
                    
			
		}
		if($this->request->data['final_diagnosis']){
			$this->Diagnosis->updateFinalDiagnosis($this->request->data);
		}
		$this->printTestOrder($this->request->data);
	}
	
	public function printTestOrder($data=array()){ 
		if(!empty($data)){
			$this->uses = array('RadiologyTestOrder','ServiceProvider','TariffAmount','TariffStandard','ExternalRequisition');
			$this->RadiologyTestOrder->bindModel(array(
					'belongsTo' => array(
							'Radiology'=>array('foreignKey' => false,'conditions'=>array('Radiology.id=RadiologyTestOrder.radiology_id')),
							'Patient'=>array('foreignKey' => false,'conditions'=>array('Patient.id=RadiologyTestOrder.patient_id')),
							'ExternalRequisition'=>array('foreignKey' => false,'conditions'=>array('RadiologyTestOrder.id=ExternalRequisition.radiology_test_order_id')),
							'Diagnosis' => array('foreignKey'=>false,'conditions'=>array('Patient.id=Diagnosis.patient_id')),
							'TariffStandard' => array('foreignKey'=>false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
							'User'=>array('foreignKey'=>false,'conditions'=>array('Patient.doctor_id=User.id')),
							'ServiceProvider'=>array('foreignKey' => false,'conditions'=>array('ServiceProvider.id=RadiologyTestOrder.service_provider_id')),
							'TariffAmount'=>array('foreignKey' => false,'conditions'=>array('TariffAmount.tariff_list_id=Radiology.tariff_list_id' ,'TariffAmount.tariff_standard_id'=>$data['tariff_standard_id'])),
					)),false);
			
			$radData = $this->RadiologyTestOrder->find('first',array('fields'=>array('Patient.admission_id','Patient.id','Patient.lookup_name','Patient.age','Patient.sex','Patient.tariff_standard_id',
					'RadiologyTestOrder.*','ServiceProvider.name','TariffStandard.*','ExternalRequisition.*','ServiceProvider.id','Radiology.name','TariffAmount.nabh_charges',
					'TariffAmount.non_nabh_charges','ServiceProvider.contact_person','ServiceProvider.location',
					'CONCAT(User.first_name," ",User.last_name) as user_name','Diagnosis.id','Diagnosis.final_diagnosis'),
					'conditions' =>array('RadiologyTestOrder.id'=>$data['radiology_test_order_id'],'RadiologyTestOrder.is_deleted'=>'0'),
					'group'=>array('RadiologyTestOrder.id')));

			$privateId = $this->TariffStandard->getPrivateTariffID();
			if($radData['Patient']['tariff_standard_id'] == $privateId){
				$tariff = "On Cash";
			}else{
				$tariff = "On Credit";
			}
			$this->set('tariff',$tariff);
			$this->set('radData',$radData);
			$this->render('print_test_order','print');
		}
	}
	
	
	/**
	 * function for super bill settlement
	 * @param unknown_type $superBill
	 * @param unknown_type $patientArray
	 * Insert data in billing encounterwise,
	 * Inserts data in final billing,
	 * Updating each service's paid amount
	 */
	public function superBillServices($superBill=NULL,$patientArray=array()){
		$this->layout  = 'advance' ;
		$this->uses=array('ServiceBill','LaboratoryTestOrder','RadiologyTestOrder','WardPatientService','ConsultantBilling',
				'CorporateSuperBill','Patient','ServiceCategory','Account','PharmacySalesBill','OtPharmacySalesBill','InventoryPharmacySalesReturn',
				'OtPharmacySalesReturn','CorporateSuperBillList','PatientCard','OptAppointment');
	
		$serviceCategory = $this->ServiceCategory->find("list",array('fields'=>array('id','name'),
				"conditions"=>array("ServiceCategory.is_deleted"=>0,/*"ServiceCategory.is_view"=>1,*/
						"ServiceCategory.service_type"=>array('IPD','OPD','Both'),
						"ServiceCategory.location_id"=>array($this->Session->read('locationid'),'0')),
		));
		$serviceCategoryName = $this->ServiceCategory->find("list",array('fields'=>array('id','alias'),
				"conditions"=>array("ServiceCategory.is_deleted"=>0,/*"ServiceCategory.is_view"=>1,*/
						"ServiceCategory.service_type"=>array('IPD','OPD','Both'),
						"ServiceCategory.location_id"=>array($this->Session->read('locationid'),'0')),
		));
		$this->set(array('serviceCategoryName'=>$serviceCategoryName,'serviceCategory'=>$serviceCategory));
	
		$superbillData=$this->CorporateSuperBill->find('first',array('conditions'=>array('id'=>$superBill)));
	
		$patientIds=explode('|',$superbillData['CorporateSuperBill']['patient_id']);
	
		$patientData=$this->Patient->find('all',array('fields'=>array('id','lookup_name','form_received_on','patient_id','admission_type'),'conditions'=>array('Patient.id'=>$patientIds)));
		$billingData=$this->Billing->find('all',array('fields'=>array('sum(amount) as advAmt','patient_id'),
				'conditions'=>array('patient_id'=>$patientIds),'group'=>array('patient_id')));
		foreach($billingData as $prevBill){
			$billArr[$prevBill['Billing']['patient_id']]['advAmt']=$prevBill['0']['advAmt'];
		}
	
		$accId=$this->Account->find('first',array('fields'=>array('Account.id','Account.card_balance'),
				'conditions'=>array('Account.system_user_id'=>$superbillData['CorporateSuperBill']['person_id'],
						'user_type'=>'Patient')));
	
		$this->set('patientCard',$accId);
	
		/**
		 * Advance amount collected from corporate (if any..)
		*/
		$advanceAmount=$this->CorporateSuperBillList->find('first',array('fields'=>array('SUM(CorporateSuperBillList.amount_used) as paidAdvance', 'Sum(CorporateSuperBillList.received_amount) as advance'),
				'conditions'=>array('corporate_super_bill_id'=>$superBill,'CorporateSuperBillList.is_deleted'=>'0',/*'payment_category'=>array('advance', 'CorporateAdvance', 'TDS')*/),
		));
		$this->set('advanceAmount',$advanceAmount);
	
		/***********************************************************************************************/
		if($this->request->data){//debug($this->request->data);exit;
			//debug($this->request->data['Billing']['amt_recieved']);exit;
			$encounterArray=$this->request->data['Billing']['encounter'];
			$settledAmount=	$this->request->data['Billing']['settledAmt'];
			foreach($encounterArray as $encId=>$encountShare){
				$tariffCons=array();
				$tariffLabs=array();
				$tariffRads=array();
				$tariffwards=array();
				$tariffPhars=array();
				$tariffOtPhars=array();
				$tariffServices=array();
				$tariffsurgeries=array();
				//Calculations for advance amount paid
				$advanceIdArray=$this->CorporateSuperBillList->find('all',array(
						'fields'=>array('CorporateSuperBillList.id','CorporateSuperBillList.received_amount',
								'CorporateSuperBillList.amount_used'),
						'conditions'=>array('corporate_super_bill_id'=>$superBill,'CorporateSuperBillList.is_deleted'=>'0',),
				));
				$advaUsedAmount=round($encountShare['shareAmount']);
				foreach($advanceIdArray as $maintainData){
					$amount_paid=0;
					if($settledAmount!='0'){
						//Checking for whether the advance used is greater than advce amt entry of CorporateSuperBillList
						if($advaUsedAmount >= $maintainData['CorporateSuperBillList']['received_amount']){
							$amount_paid=$maintainData['CorporateSuperBillList']['amount_used']+$maintainData['CorporateSuperBillList']['received_amount'];
							$settledAmount=$settledAmount-$maintainData['CorporateSuperBillList']['amount'];
							$advaUsedAmount=$advaUsedAmount-$maintainData['CorporateSuperBillList']['amount'];
						}else{
							$amount_paid=$maintainData['CorporateSuperBillList']['amount_used']+$advaUsedAmount;
							$settledAmount=$settledAmount-$advaUsedAmount;
							$advaUsedAmount='0';
						}
						$modified=$this->DateFormat->formatDate2STD($this->request->data['Billing']['date'],Configure::read('date_format'));;
						$modified_by=$this->Session->read('userid');
						$this->CorporateSuperBillList->updateAll(
								array('CorporateSuperBillList.amount_used'=>$amount_paid,//'CorporateSuperBillList.amount_pending'=>$amount_pending,
										"CorporateSuperBillList.modified_time"=>"'$modified'",
										"CorporateSuperBillList.modified_by"=>"'$modified_by'"),
								array('CorporateSuperBillList.id'=>$maintainData['CorporateSuperBillList']['id']));
					}
				}
	
				//If combine payment from pateint card  and other then update patient card
				if($this->Session->read('website.instance')!='kanpur'){
					$patientCardid='';
					if($settledAmount){
						$accountBalance=$this->Account->find('first',array('fields'=>array('Account.id','Account.card_balance'),
								'conditions'=>array('Account.system_user_id'=>$superbillData['CorporateSuperBill']['person_id'],
										'user_type'=>'Patient')));
						if($accountBalance['Account']['card_balance']){
							$patientCard=$settledAmount;
							if($patientCard<$accId['Account']['card_balance']){
								$cardBalance=$accId['Account']['card_balance']-$patientCard;
	
							}else {
								$cardBalance=0;
								$patientCard=$accId['Account']['card_balance'];
							}
							//update patient card balance
							$this->Account->updateAll(array('card_balance'=>$cardBalance),array('id'=>$accId['Account']['id']));
							//insert payment entry in patientCard table
							$this->PatientCard->save(array(
									'person_id'=>$superbillData['CorporateSuperBill']['person_id'],
									'account_id'=>$accId['Account']['id'],
									'type'=>'Payment',
									'mode_type'=>'Patient Card',
									'amount'=>$patientCard,
									'bank_id'=>$this->Account->getAccountIdOnly(Configure::read('PatientCardLabel')),
									'created_by'=>$this->Session->read('userid'),
									'create_time'=>date('Y-m-d H:i:s')
							));
							$patientCardid=$this->PatientCard->id;
							$this->request->data['Billing']['patient_card']=$patientCard;
						}
					}
	
				}
	
					
				//$totalBalAmt=$totalBillAmt-round($totalAdvAmt); //amount pending
				//EOF Advanced amount
				$billNo=0;$discount=0;
				$lastBillId=$this->Billing->find('first',array('fields'=>array('id'),'order'=>array('Billing.id Desc')));
				$lastBillId=$lastBillId['Billing']['id'];
				$billNo=$this->generateBillNoPerPay($encId,$lastBillId);
				$discount=$encountShare['totalAmount']-$encountShare['shareAmount'];
				$PrevPaid=$billArr[$encId]['advAmt'];
				/** Function called to insert encounter wise data in billing
				 *saveBillingData();
				 *parameters:
				 *1:patientId,
				 *2.PersonId,
				 *3.Amount,
				 *4.discount,
				 *5.Refund,
				 *6.total Amount,
				 *7.Prev paid amt (adv),
				 *8.Account id,
				 *9.Bill number,
				 *10.request->data Containg key as billing with data as date, payment mode etc..
				 */
				$billId=$this->Billing->saveBillingData($encId,$superbillData['CorporateSuperBill']['person_id'],$encountShare['shareAmount'],$discount,'0',$encountShare['totalAmount'],$PrevPaid,$accId,$billNo,$this->request->data);
					
				if($patientCardid){
					$this->PatientCard->updateAll(array('PatientCard.billing_id'=>"'$billId'"),array('PatientCard.id'=>$patientCardid));
				}
				//$count=0; $chkPayAmt=0;
				$modified=$this->DateFormat->formatDate2STD($this->request->data['Billing']['date'],Configure::read('date_format'));
				$modified_by=$this->Session->read('userid');
				foreach($this->request->data['Billing'][$encId] as $catKey=>$serviceData){
					if(strtolower($catKey)==strtolower(Configure::read('Consultant'))){							
						$tariffCons=$this->ConsultantBilling->consultantServicesUpdate($serviceData,$encId,$catKey,$billId,$this->request->data['Billing']['percent'],$modified);
						if(!$tariffCons){
							$tariffCons=array();
						}
					}else if(strtolower($catKey)==strtolower(Configure::read('laboratoryservices'))){
							
						$tariffLabs=$this->LaboratoryTestOrder->labServicesUpdate($serviceData,$encId,$catKey,$billId,$this->request->data['Billing']['percent'],$modified);
						if(!$tariffLabs){
							$tariffLabs=array();
						}
					}else if(strtolower($catKey)==strtolower(Configure::read('radiologyservices'))){
							
						$tariffRads=$this->RadiologyTestOrder->radServicesUpdate($serviceData,$encId,$catKey,$billId,$this->request->data['Billing']['percent'],$modified);
						if(!$tariffRads){
							$tariffRads=array();
						}
					}else if(strtolower($catKey)==strtolower(Configure::read('RoomTariff'))){
							
						$tariffwards=$this->WardPatientService->wardServicesUpdate($serviceData,$encId,$catKey,$billId,$this->request->data['Billing']['percent'],$modified);
						if(!$tariffwards){
							$tariffwards=array();
						}
					}else if(strtolower($catKey)==strtolower(Configure::read('surgeryservices'))){
							
						$tariffsurgeries=$this->OptAppointment->surgeryUpdate($serviceData,$encId,$catKey,$billId,$this->request->data['Billing']['percent'],$modified);
						if(!$tariffsurgeries){
							$tariffsurgeries=array();
						}
					}else if(strtolower($catKey)==strtolower(Configure::read('Pharmacy'))){
							
						$tariffPhars=$this->PharmacySalesBill->pharmacyServicesUpdate($serviceData,$encId,$catKey,$billId,$this->request->data['Billing']['percent'],$modified);
						if(!$tariffPhars){
							$tariffPhars=array();
						}
					}else if(strtolower($catKey)==strtolower(Configure::read('OtPharmacy'))){
							
						$tariffOtPhars=$this->OtPharmacySalesBill->otPharmacyServicesUpdate($serviceData,$encId,$catKey,$billId,$this->request->data['Billing']['percent'],$modified);
						if(!$tariffOtPhars){
							$tariffOtPhars=array();
						}
					}else if(strtolower($catKey)!=strtolower(Configure::read('radiologyservices')) &&
							strtolower($catKey)!=strtolower(Configure::read('laboratoryservices')) && strtolower($catKey)!=strtolower(Configure::read('RoomTariff')) &&
							strtolower($catKey)!=strtolower(Configure::read('Pharmacy')) && strtolower($catKey)!=strtolower(Configure::read('OtPharmacy')) &&
							strtolower($catKey)!=strtolower(Configure::read('Consultant')) && strtolower($catKey)!=strtolower(Configure::read('surgeryservices'))){
							
						$tariffServices[$catKey]=$this->ServiceBill->ServicesUpdate($serviceData,$encId,$catKey,$billId,$this->request->data['Billing']['percent'],$modified);
						if(!$tariffServices[$catKey]){
							$tariffServices[$catKey]=array();
						}
					}
				}//EOF Encounter selected serviceCategory Foreach
					
				//Updating Serialize array in billing tariff list id
				$billTariffId=array();
				$billTariffId=array_merge($tariffServices,$tariffsurgeries,$tariffCons,$tariffLabs,$tariffRads,$tariffwards,$tariffPhars,$tariffOtPhars);
				$serialArray=serialize($billTariffId);
				$this->Billing->updateAll(array('Billing.tariff_list_id'=>"'$serialArray'"),
						array('Billing.id'=>$billId));
				//EOF Updation in Billing
					
				//updating flag in patient table for hiding from super bill list
				$this->Patient->updateAll(array('Patient.is_hidden_from_report'=>'1'),array('Patient.id'=>$encId));
					
			}//End Of Encounter foreach
			$recAmt=$this->request->data['Billing']['totalRec']-$this->request->data['Billing']['card_balance'];//$this->request->data['Billing']['amt_recieved'];
			if(($recAmt)){
				$updateArray=array('CorporateSuperBill.bill_settled_date'=>"'$modified'",
						'CorporateSuperBill.received_amount'=>"'$recAmt'");
			}else{
				$updateArray=array('CorporateSuperBill.bill_settled_date'=>"'$modified'");
			}
			$this->CorporateSuperBill->updateAll(
					$updateArray,
					array('CorporateSuperBill.id'=>$superBill));
	
			$this->Session->setFlash(__('Bill No: '.$superbillData['CorporateSuperBill']['super_bill_no'].' has been settled successfully', true),'default',array('class'=>'stillSuccess','id'=>'stillFlashMessage'),'still');
			$this->Session->setFlash(__('Bill No: '.$superbillData['CorporateSuperBill']['super_bill_no'].' has been settled successfully',false),'default',array('class'=>'stillSuccess','id'=>'stillFlashMessage'),'still');
			$this->redirect(array('controller'=>'Corporates','action'=>'corporate_super_bill_list'));
	
		}//End Of Request data
	
		$serviceBillData=$this->ServiceBill->getServices(array('ServiceBill.patient_id'=>$patientIds),$superBill);
	
		$labData=$this->LaboratoryTestOrder->getLaboratories(array('LaboratoryTestOrder.patient_id'=>$patientIds),$superBill);
	
		$radData=$this->RadiologyTestOrder->getRadiologies(array('RadiologyTestOrder.patient_id'=>$patientIds),$superBill);
	
		$wardserviceBillData=$this->WardPatientService->getWardServices(array('WardPatientService.patient_id'=>$patientIds),$superBill);
	
		$treatingConsultantData=$this->ConsultantBilling->getDdetail($patientIds,'',$superBill);
	
		$externalConsultantData=$this->ConsultantBilling->getCdetail($patientIds,'',$superBill);
	
		$pharmacyData=$this->PharmacySalesBill->getPatientPharmacyCharges($patientIds,'',$superBill);
	
		$otPharmacyData=$this->OtPharmacySalesBill->getPatientOtPharmacyCharges($patientIds,'',$superBill);
		
		$surgeryData=$this->OptAppointment->getSurgeryServices(array('OptAppointment.patient_id'=>$patientIds),$superBill);
		
		$conservative=$this->OptAppointment->calConservative($wardserviceBillData,$patientIds);
	
		/***********************************************************************************************************************************/
		/**
		 * Each array below contains
		 * 1.table id i.e specific table id from where data has been retrived,
		 * 2.patient_id,
		 * 3.Name of service
		 * 4.tariff_list_id,
		 * 5.service amount,
		 * 6.Service discount (if any),
		 * 7.Service paid amount (if any)
		 * PatientArray Contains Encounterwise Patient id and total bill amount of selected service of specific super bill
		 *
		 *Array of treating Consultant
		 *Patient id as 1st key doctorid as 2nd key and increamental key => details
		*/
		$i=0;
		foreach ($treatingConsultantData as $Ckey=>$cBilling){
			foreach($cBilling as $CBillKey=>$consultantBillingDta){
				foreach($consultantBillingDta as $conKey=>$consultantBilling){
					foreach($consultantBilling as $singleKey=>$service){
						$patientArray[$service['ConsultantBilling']['patient_id']]['patient_id']=$service['ConsultantBilling']['patient_id'];
						$encounterAmt=($service['ConsultantBilling']['amount'])-$service['ConsultantBilling']['paid_amount']-$service['ConsultantBilling']['discount'];
						if($encounterAmt<=0){
							$encounterAmt=0;
						}
						$patientArray[$service['ConsultantBilling']['patient_id']]['totalAmount']=$patientArray[$service['ConsultantBilling']['patient_id']]['totalAmount']+$encounterAmt;
						$consultantArray[$service['ConsultantBilling']['patient_id']][$i]['table_id']=$service['ConsultantBilling']['id'];
						$consultantArray[$service['ConsultantBilling']['patient_id']][$i]['doctor_id']=$service['ConsultantBilling']['doctor_id'];
						$consultantArray[$service['ConsultantBilling']['patient_id']][$i]['name']=$service['TariffList']['name'].'('.$service['DoctorProfile']['first_name'].' '.$service['DoctorProfile']['last_name'].')';
						$consultantArray[$service['ConsultantBilling']['patient_id']][$i]['tariff_list_id']=$service['TariffList']['id'];
						$consultantArray[$service['ConsultantBilling']['patient_id']][$i]['amount']=$service['ConsultantBilling']['amount'];
						$consultantArray[$service['ConsultantBilling']['patient_id']][$i]['discount']=$service['ConsultantBilling']['discount'];
						$consultantArray[$service['ConsultantBilling']['patient_id']][$i]['paid_amount']=$service['ConsultantBilling']['paid_amount'];
						$consultantArray[$service['ConsultantBilling']['patient_id']][$i]['patient_id']=$service['ConsultantBilling']['patient_id'];
						$i++;
						$encounterAmt=0;
					}
				}
			}
		}
		/*********************************************************************************************************************************/
		/**
		 *Array of External  Consultant
		 *Patient id as 1st key consultantid as 2nd key and increamental key => details
		 */
	
		foreach ($externalConsultantData as $Ckey=>$cBilling){
			foreach($cBilling as $CBillKey=>$consultantBillingDta){
				foreach($consultantBillingDta as $conKey=>$consultantBilling){
					foreach($consultantBilling as $singleKey=>$service){
						$patientArray[$service['ConsultantBilling']['patient_id']]['patient_id']=$service['ConsultantBilling']['patient_id'];
						$encounterAmt=($service['ConsultantBilling']['amount'])-$service['ConsultantBilling']['paid_amount']-$service['ConsultantBilling']['discount'];
						if($encounterAmt<=0){
							$encounterAmt=0;
						}
						$patientArray[$service['ConsultantBilling']['patient_id']]['totalAmount']=$patientArray[$service['ConsultantBilling']['patient_id']]['totalAmount']+$encounterAmt;
						$consultantArray[$service['ConsultantBilling']['patient_id']][$i]['table_id']=$service['ConsultantBilling']['id'];
						$consultantArray[$service['ConsultantBilling']['patient_id']][$i]['doctor_id']=$service['ConsultantBilling']['consultant_id'];
						$consultantArray[$service['ConsultantBilling']['patient_id']][$i]['name']=$service['TariffList']['name'].'('.$service['Consultant']['first_name'].' '.$service['Consultant']['last_name'].')';
						$consultantArray[$service['ConsultantBilling']['patient_id']][$i]['tariff_list_id']=$service['TariffList']['id'];
						$consultantArray[$service['ConsultantBilling']['patient_id']][$i]['amount']=$service['ConsultantBilling']['amount'];
						$consultantArray[$service['ConsultantBilling']['patient_id']][$i]['discount']=$service['ConsultantBilling']['discount'];
						$consultantArray[$service['ConsultantBilling']['patient_id']][$i]['paid_amount']=$service['ConsultantBilling']['paid_amount'];
						$consultantArray[$service['ConsultantBilling']['patient_id']][$i]['patient_id']=$service['ConsultantBilling']['patient_id'];
						$i++;
						$encounterAmt=0;
					}
				}
			}
		}
		/*******************************************************************************************************************************/
		/**
		 *Array of servicebill services
		 *Patient id as 1st key service_id (radio button service category id) as 2nd key and increamental key => details
		 */
	
		foreach($serviceBillData as $service){
			$patientArray[$service['ServiceBill']['patient_id']]['patient_id']=$service['ServiceBill']['patient_id'];
			$encounterAmt=($service['ServiceBill']['amount']*$service['ServiceBill']['no_of_times'])-$service['ServiceBill']['paid_amount']-$service['ServiceBill']['discount'];
			if($encounterAmt<=0){
				$encounterAmt=0;
			}
			$patientArray[$service['ServiceBill']['patient_id']]['totalAmount']=$patientArray[$service['ServiceBill']['patient_id']]['totalAmount']+$encounterAmt;
			$serviceArray[$service['ServiceBill']['patient_id']][$i]['table_id']=$service['ServiceBill']['id'];
			$serviceArray[$service['ServiceBill']['patient_id']][$i]['service_id']=$service['ServiceBill']['service_id'];
			$serviceArray[$service['ServiceBill']['patient_id']][$i]['name']=$service['TariffList']['name'];
			$serviceArray[$service['ServiceBill']['patient_id']][$i]['tariff_list_id']=$service['TariffList']['id'];
			$serviceArray[$service['ServiceBill']['patient_id']][$i]['amount']=$service['ServiceBill']['amount'];
			$serviceArray[$service['ServiceBill']['patient_id']][$i]['no_of_times']=$service['ServiceBill']['no_of_times'];
			$serviceArray[$service['ServiceBill']['patient_id']][$i]['discount']=$service['ServiceBill']['discount'];
			$serviceArray[$service['ServiceBill']['patient_id']][$i]['paid_amount']=$service['ServiceBill']['paid_amount'];
			$serviceArray[$service['ServiceBill']['patient_id']][$i]['patient_id']=$service['ServiceBill']['patient_id'];
			$serviceCatData[$service['ServiceBill']['patient_id']][$service['ServiceBill']['service_id']]=$service['ServiceBill']['amount'];
			$i++;
			$encounterAmt=0;
		}
		$this->set('serviceCatData',$serviceCatData);
		/*****************************************************************************************************************************/
		/**
		 *Array of laboratory services
		 *Patient id as 1st key , labid as 2nd key and increamental key => details
		*/
	
		foreach($labData as $service){
			$patientArray[$service['LaboratoryTestOrder']['patient_id']]['patient_id']=$service['LaboratoryTestOrder']['patient_id'];
			$encounterAmt=($service['LaboratoryTestOrder']['amount'])-$service['LaboratoryTestOrder']['paid_amount']-$service['LaboratoryTestOrder']['discount'];
			if($encounterAmt<=0){
				$encounterAmt=0;
			}
			$patientArray[$service['LaboratoryTestOrder']['patient_id']]['totalAmount']=$patientArray[$service['LaboratoryTestOrder']['patient_id']]['totalAmount']+$encounterAmt;
			$labArray[$service['LaboratoryTestOrder']['patient_id']][$i]['table_id']=$service['LaboratoryTestOrder']['id'];
			$labArray[$service['LaboratoryTestOrder']['patient_id']][$i]['name']=$service['Laboratory']['name'];
			$labArray[$service['LaboratoryTestOrder']['patient_id']][$i]['laboratory_id']=$service['LaboratoryTestOrder']['laboratory_id'];
			$labArray[$service['LaboratoryTestOrder']['patient_id']][$i]['tariff_list_id']=$service['Laboratory']['tariff_list_id'];
			$labArray[$service['LaboratoryTestOrder']['patient_id']][$i]['amount']=$service['LaboratoryTestOrder']['amount'];
			$labArray[$service['LaboratoryTestOrder']['patient_id']][$i]['discount']=$service['LaboratoryTestOrder']['discount'];
			$labArray[$service['LaboratoryTestOrder']['patient_id']][$i]['paid_amount']=$service['LaboratoryTestOrder']['paid_amount'];
			$labArray[$service['LaboratoryTestOrder']['patient_id']][$i]['patient_id']=$service['LaboratoryTestOrder']['patient_id'];
			$i++;$encounterAmt=0;
		}
		/********************************************************************************************************************************/
		/**
		 *Array of Radiology services
		 *Patient id as 1st key,radiology_id as 2nd key and increamental key => details
		 */
	
		foreach($radData as $service){
			$patientArray[$service['RadiologyTestOrder']['patient_id']]['patient_id']=$service['RadiologyTestOrder']['patient_id'];
			$encounterAmt=($service['RadiologyTestOrder']['amount'])-$service['RadiologyTestOrder']['paid_amount']-$service['RadiologyTestOrder']['discount'];
			if($encounterAmt<=0){
				$encounterAmt=0;
			}
			$patientArray[$service['RadiologyTestOrder']['patient_id']]['totalAmount']=$patientArray[$service['RadiologyTestOrder']['patient_id']]['totalAmount']+$encounterAmt;
			$radArray[$service['RadiologyTestOrder']['patient_id']][$i]['table_id']=$service['RadiologyTestOrder']['id'];
			$radArray[$service['RadiologyTestOrder']['patient_id']][$i]['radiology_id']=$service['RadiologyTestOrder']['radiology_id'];
			$radArray[$service['RadiologyTestOrder']['patient_id']][$i]['name']=$service['Radiology']['name'];
			$radArray[$service['RadiologyTestOrder']['patient_id']][$i]['tariff_list_id']=$service['Radiology']['tariff_list_id'];
			$radArray[$service['RadiologyTestOrder']['patient_id']][$i]['amount']=$service['RadiologyTestOrder']['amount'];
			$radArray[$service['RadiologyTestOrder']['patient_id']][$i]['discount']=$service['RadiologyTestOrder']['discount'];
			$radArray[$service['RadiologyTestOrder']['patient_id']][$i]['paid_amount']=$service['RadiologyTestOrder']['paid_amount'];
			$radArray[$service['RadiologyTestOrder']['patient_id']][$i]['patient_id']=$service['RadiologyTestOrder']['patient_id'];
			$i++;$encounterAmt=0;
		}
		/********************************************************************************************************************************/
		/**
		 * Room tariff data
		 * combined room charge encounterwise
		 * PatientId as 1st key , TariffList id as 2nd key=>details
		 */
	
		foreach($wardserviceBillData as $service){
			$patientArray[$service['WardPatientService']['patient_id']]['patient_id']=$service['WardPatientService']['patient_id'];
			$encounterAmt=($service['WardPatientService']['amount'])-$service['WardPatientService']['paid_amount']-$service['WardPatientService']['discount'];
			if($encounterAmt<=0){
				$encounterAmt=0;
			}
			$patientArray[$service['WardPatientService']['patient_id']]['totalAmount']=$patientArray[$service['WardPatientService']['patient_id']]['totalAmount']+$encounterAmt;
			$wardArray[$service['WardPatientService']['patient_id']][$service['WardPatientService']['tariff_list_id']]['table_id'][]=$service['WardPatientService']['id'];
			$wardArray[$service['WardPatientService']['patient_id']][$service['WardPatientService']['tariff_list_id']]['name']=$service['TariffList']['name'];
			$wardArray[$service['WardPatientService']['patient_id']][$service['WardPatientService']['tariff_list_id']]['tariff_list_id']=$service['TariffList']['id'];
			$wardArray[$service['WardPatientService']['patient_id']][$service['WardPatientService']['tariff_list_id']]['amount']=$wardArray[$service['WardPatientService']['patient_id']][$service['WardPatientService']['tariff_list_id']]['amount']+$service['WardPatientService']['amount'];
			$wardArray[$service['WardPatientService']['patient_id']][$service['WardPatientService']['tariff_list_id']]['discount']=$wardArray[$service['WardPatientService']['patient_id']][$service['WardPatientService']['tariff_list_id']]['discount']+$service['WardPatientService']['discount'];
			$wardArray[$service['WardPatientService']['patient_id']][$service['WardPatientService']['tariff_list_id']]['paid_amount']=$wardArray[$service['WardPatientService']['patient_id']][$service['WardPatientService']['tariff_list_id']]['paid_amount']+$service['WardPatientService']['paid_amount'];
			$wardArray[$service['WardPatientService']['patient_id']][$service['WardPatientService']['tariff_list_id']]['patient_id']=$service['WardPatientService']['patient_id'];
			$encounterAmt=0;$i++;
		}
	
		foreach($pharmacyData as $patKey=>$phar){
			$patientArray[$patKey]['patient_id']=$patKey;
				
			$totalPhar=$phar['total']-$phar['return'];
			$paidPhar=$phar['paid_amount']-$phar['returnPaid'];
			$discountPhar=$phar['discount']-$phar['returnDiscount'];
			$encounterAmt=$totalPhar-$paidPhar-$discountPhar;
			if($encounterAmt<=0){
				$encounterAmt=0;
			}
			$patientArray[$patKey]['totalAmount']=$patientArray[$patKey]['totalAmount']+$encounterAmt;
			//$pharArray[$patKey]['pharmacy']['table_id'][]=$service['WardPatientService']['id'];
			$pharArray[$patKey]['pharmacy']['name']='Pharmacy';
			//$pharArray[$patKey]['pharmacy']['tariff_list_id']=$service['TariffList']['id'];
			$pharArray[$patKey]['pharmacy']['amount']=$pharArray[$patKey]['pharmacy']['amount']+$totalPhar;
			$pharArray[$patKey]['pharmacy']['discount']=$pharArray[$patKey]['pharmacy']['discount']+$discountPhar;
			$pharArray[$patKey]['pharmacy']['paid_amount']=$pharArray[$patKey]['pharmacy']['paid_amount']+$paidPhar;
			$pharArray[$patKey]['pharmacy']['patient_id']=$patKey;
			$encounterAmt=0;$i++;
		}
	
		foreach($otPharmacyData as $patKey=>$otPhar){
			$patientArray[$patKey]['patient_id']=$patKey;
	
			$totalOtPhar=$otPhar['total']-$otPhar['return'];
			$paidOtPhar=$otPhar['paid_amount']-$otPhar['returnPaid'];
			$discountOtPhar=$otPhar['discount']-$otPhar['returnDiscount'];
			$encounterAmt=$totalOtPhar-$paidOtPhar-$discountOtPhar;
			if($encounterAmt<=0){
				$encounterAmt=0;
			}
			$patientArray[$patKey]['totalAmount']=$patientArray[$patKey]['totalAmount']+$encounterAmt;
			//$pharArray[$patKey]['pharmacy']['table_id'][]=$service['WardPatientService']['id'];
			$otpharArray[$patKey]['otpharmacy']['name']='Ot Pharmacy';
			//$pharArray[$patKey]['pharmacy']['tariff_list_id']=$service['TariffList']['id'];
			$otpharArray[$patKey]['otpharmacy']['amount']=$otpharArray[$patKey]['otpharmacy']['amount']+$totalOtPhar;
			$otpharArray[$patKey]['otpharmacy']['discount']=$otpharArray[$patKey]['otpharmacy']['discount']+$discountOtPhar;
			$otpharArray[$patKey]['otpharmacy']['paid_amount']=$otpharArray[$patKey]['otpharmacy']['paid_amount']+$paidOtPhar;
			$otpharArray[$patKey]['otpharmacy']['patient_id']=$patKey;
			$encounterAmt=0;$i++;
		}
		/********************************************************************************************************************************/
		/********************************************************************************************************************************/
		/**
		 *Array of Surgery services
		 *Patient id as 1st key,surgery_id as 2nd key and increamental key => details
		 */
		
		foreach($surgeryData as $service){
			$patientArray[$service['OptAppointment']['patient_id']]['patient_id']=$service['OptAppointment']['patient_id'];
			$encounterAmt=($service['OptAppointment']['surgery_cost']+$service['OptAppointment']['anaesthesia_cost']+$service['OptAppointment']['ot_charges'])-$service['OptAppointment']['paid_amount']-$service['OptAppointment']['discount'];
			if($encounterAmt<=0){
				$encounterAmt=0;
			}
			$patientArray[$service['OptAppointment']['patient_id']]['totalAmount']=$patientArray[$service['OptAppointment']['patient_id']]['totalAmount']+$encounterAmt;
			$SurArray[$service['OptAppointment']['patient_id']][$i]['table_id']=$service['OptAppointment']['id'];
			$SurArray[$service['OptAppointment']['patient_id']][$i]['surgery_id']=$service['OptAppointment']['surgery_id'];
			$SurArray[$service['OptAppointment']['patient_id']][$i]['name']=$service['Surgery']['name'];
			$SurArray[$service['OptAppointment']['patient_id']][$i]['tariff_list_id']=$service['TariffList']['id'];
			$SurArray[$service['OptAppointment']['patient_id']][$i]['amount']=$service['OptAppointment']['surgery_cost']+$service['OptAppointment']['anaesthesia_cost']+$service['OptAppointment']['ot_charges'];
			$SurArray[$service['OptAppointment']['patient_id']][$i]['discount']=$service['OptAppointment']['discount'];
			$SurArray[$service['OptAppointment']['patient_id']][$i]['paid_amount']=$service['OptAppointment']['paid_amount'];
			$SurArray[$service['OptAppointment']['patient_id']][$i]['patient_id']=$service['OptAppointment']['patient_id'];
			$i++;$encounterAmt=0;
		}
		/********************************************************************************************************************************/
	
		$this->set(array('patientData'=>$patientData,'consultantArray'=>$consultantArray,'serviceArray'=>$serviceArray,
				'labArray'=>$labArray,'radArray'=>$radArray,'wardArray'=>$wardArray,'otpharArray'=>$otpharArray,'pharArray'=>$pharArray,
				'patientArray'=>$patientArray,'superbillData'=>$superbillData,'surgeryArray'=>$SurArray));
	
	
	}
	
	
	/**
	 * Function to add extra service against the latest encounter of selcted super bill
	 * for excess amount received from corporate
	 * Pooja Gupta
	 */
	
	public function addExtraService($superId,$excessAmt){
		$this->uses=array('CorporateSuperBill','ServiceBill','TariffList','Patient','FinalBilling');
		$superData=$this->CorporateSuperBill->find('first',array('conditions'=>array('id'=>$superId)));
		$expData=explode('|',$superData['CorporateSuperBill']['patient_id']);
		$lastEncounter=$this->Patient->find('first',array('fields'=>array('id','admission_type','discharge_date','tariff_standard_id','doctor_id'),
				'conditions'=>array('id'=>$expData),
				'order'=>array('Patient.id Desc')));
		$tariffData=$this->TariffList->find('first',array('conditions'=>array('TariffList.code_name Like'=>Configure::read('corporate_excess_service'))));
		$service['patient_id']=$lastEncounter['Patient']['id'];
		$service['service_id']=$tariffData['TariffList']['service_category_id'];
		$service['location_id']=$this->Session->read('locationid');
		$service['date']=$lastEncounter['Patient']['discharge_date'];
		$service['amount']=	$excessAmt;
		$service['no_of_times']='1';
		$service['tariff_list_id']=$tariffData['TariffList']['id'];
		$service['tariff_standard_id']=$lastEncounter['Patient']['tariff_standard_id'];
		$service['create_time']=date('Y-m-d H:i:s');
		$service['created_by']=$this->Session->read('userid');
		$service['doctor_id']=$lastEncounter['Patient']['doctor_id'];
		$serviceId=$this->ServiceBill->save($service);
		if($serviceId){
			$finalData=$this->FinalBilling->find('first',array('conditions'=>array('patient_id'=>$lastEncounter['Patient']['id'])));
			if($finalData){
				$totalAmount=$finalData['FinalBilling']['total_amount']+$excessAmt;
				$amountPending=$totalAmount-$finalData['FinalBilling']['amount_paid']-$finalData['FinalBilling']['discount'];
				$this->FinalBilling->updateAll(array('total_amount'=>"'$totalAmount'",'amount_pending'=>"'$amountPending'"),
						array('FinalBilling.id'=>$finalData['FinalBilling']['id']));
					
			}
			$superTotal=$superData['CorporateSuperBill']['total_amount']+$excessAmt;
			$this->CorporateSuperBill->updateAll(array('total_amount'=>"'$superTotal'"),
					array('CorporateSuperBill.id'=>$superId));
				
		}
			
		exit;
	}
        
        //function to update the amount collection from reports for corporate by Swapnil - 4.11.2015
        public function getAmountReceived($finalBillingId,$data=array()){
            $this->layout = false;
            $this->autoRender = false; 
            $this->uses = array('AccountReceipt','FinalBilling','Billing');
           
            if(!empty($data)){ 
            	$this->request->data = $data;
            }
               
            if(!empty($this->request->data)){
                if(!empty($this->request->data['patient_id']) && !empty($this->request->data['amount'])){ //update actual amount received from company
                    $isSaved = false;
                    $data = array();
                    $data['Billing']['amount']=$this->request->data['amount'];
                    $data['Billing']['payment_category']='Finalbill'; 
                    $data['Billing']['date']=$this->DateFormat->formatDate2STD($this->request->data['invoice_date'],Configure::read('date_format'));
                    $data['Billing']['patient_id']=$this->request->data['patient_id'];
                    $data['Billing']['mode_of_payment']='Cash'; 
                    $data['Billing']['created_by']=$this->Session->read('userid');
                    $data['Billing']['discount']=$this->request->data['other_deduction']; 
                    $data['Billing']['total_amount']=$this->request->data['total_amount']; 
                    $data['Billing']['discount_by']=!empty($this->request->data['other_deduction'])?$this->Session->read('userid'):''; 
                    $data['Billing']['location_id']=$this->Session->read('locationid'); 
                    if($this->Billing->save($data)){
                        $lastNotesId=$this->Billing->getLastInsertID();
                        $billingData['Billing'] = $this->request->data;
                        $this->AccountReceipt->corporateReceiptEntry($billingData);
                        $isSaved = true;
                    }
                    $billNo=$this->generateBillNoPerPay($this->request->data['patient_id'],$lastNotesId);
                    $updateBillingArray=array('Billing.bill_number'=>"'$billNo'");
                    $this->Billing->updateAll($updateBillingArray,array('Billing.patient_id'=>$this->request->data['patient_id'],'Billing.id'=>$lastNotesId)); 
                    $this->Billing->id= '' ;
                    if($isSaved == true){
                        $return = '1';
                        //update in finalBilling
                        if(!empty($finalBillingId)){
                            $prevData = $this->FinalBilling->read(array('amount_paid','tds','discount'),$finalBillingId); 
                            $finalData = array();
                            $this->FinalBilling->id = $finalBillingId;
                            $finalData['total_amount'] = $this->request->data['total_amount']; 
                            $finalData['amount_paid'] = $prevData['FinalBilling']['amount_paid'] + $this->request->data['amount']; 
                            $finalData['discount'] = $prevData['FinalBilling']['discount'] + $this->request->data['other_deduction']; 
                            $finalData['tds'] = $prevData['FinalBilling']['tds'] + $this->request->data['tds']; 
                            $finalData['amount_pending'] = $finalData['total_amount'] - ($finalData['amount_paid'] + $finalData['discount'] + $finalData['tds'] + $this->request->data['advance_amount']);
                            $this->FinalBilling->save($finalData);
                            $this->FinalBilling->id = '';
                        }
                        if(!empty($this->request->data['is_setteled']) && $this->request->data['is_setteled'] != 0){ 
                            $this->loadModel('Patient');
                            if($this->Patient->updateAll(array('is_hidden_from_report'=>'1'),array('Patient.id'=>$this->request->data['patient_id']))){
                                $return = '2';
                            }
                        }
                    }
                }  
            }else{
                $return = '0';
            }
            echo json_encode($return); exit;
        }
        
        function newSinglePayment($id){
        	//$this->layout=false;
        	if($id){
        		$this->loadModel('ServiceCategory');
        		$this->loadModel('Patient');
	        	$this->Patient->unBindModel(array(
	        			'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
	        	$this->Patient->bindModel(array(
	        			'belongsTo' => array(
	        					'Initial' =>array( 'foreignKey'=>'initial_id'),
	        					'Consultant' =>array('foreignKey'=>'consultant_treatment'),
	        					'TariffStandard' =>array('foreignKey'=>'tariff_standard_id')
	        			)));
	        	$patient_details  = $this->Patient->getPatientDetailsByIDWithTariff($id);
	        	$this->loadModel('Person');
	        	$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);
	        		
	        	//Function to calculate totalBill
	        	$this->loadModel('Billing');
	        	$totalBill=$this->Billing->getPatientTotalBill($id,$patient_details['Patient']['admission_type']);
	        	
	        	$this->loadModel('PharmacySalesBill');
	        	$patient_pharmacy_details = $this->PharmacySalesBill->getPatientSaleDetails($id);
	        	$this->loadModel('Configuration');
	        	$pharmConfig=$this->Configuration->getPharmacyServiceType();// to get pharmacy service type
	        	$this->set('pharmaConfig',$pharmConfig['addChargesInInvoice']);
	        	if($patient_pharmacy_details){
	        		$pharmacy_total = $this->PharmacySalesBill->getTotalAmount($patient_pharmacy_details);
	        		$pharmacy_total=round($pharmacy_total);
	        		$pharmacy_cash_total = $this->PharmacySalesBill->getCashAmount($patient_pharmacy_details);
	        	}
	        	//debug($pharmacy_total);
	        	//debug($pharmacy_cash_total);
	        	//Set tariffId
	        	$this->loadModel('TariffStandard');
	        	if($patient_details['Patient']['tariff_standard_id']!=''){
	        		$tariffStandardId=$patient_details['Patient']['tariff_standard_id'];
	        	}else{
	        		$tariffData=$this->TariffStandard->find('first',array('conditions'=>array('name'=>'Private')));
	        		#pr($tariffData);exit;
	        		$tariffStandardId=$tariffData['TariffStandard']['id'];
	        	}
	        	$totalPaid=$this->Billing->getPatientPaidAmount($id);
	        	$totalDiscount=$this->Billing->getPatientDiscountAmount($id);
	        	// url flag to show pharmacy charges -- Pooja
				if($this->params->query['showPhar']){
					$pharmConfig['addChargesInInvoice']='yes';
				}
	        	if($pharmConfig['addChargesInInvoice']=='no'){
	        		$totalBill=$totalBill - $pharmacy_total;
	        		$this->loadModel('ServiceCategory');
	        		$pharmacyCategoryId=$this->ServiceCategory->getPharmacyId();//in case need of pharmacy category ID
	        		$PharPaid =$this->Billing->find('first',array('fields'=>array('sum(Billing.amount) AS sumFinaltotalPaid'),
	        				'conditions'=>array('Billing.patient_id'=>$id,'Billing.is_deleted'=>'0',
	        						'Billing.payment_category '=>$pharmacyCategoryId)));
	        		$totalPaid = $totalPaid-$PharPaid['0']['sumFinaltotalPaid']; //deduct pharmacy paid 
	        	}
	        	/********************* Ward Charges Starts ********************/
	        	//$wardServicesDataNew = $this->getDay2DayWardCharges($id,$tariffStandardId);
	        	#$wardServicesDataNew = $this->getDay2DayCharges($id,$tariffStandardId);
	        	$wardServicesDataNew = $this->groupWardCharges($id,true);
	        	$totalWardNewCost=0;
	        	$totalWardDays=0;
	        	foreach($wardServicesDataNew as $uniqueSlot){
	        		if(isset($uniqueSlot['name'])){
	        			//Commented as surgery charges are already coming from above total bill function -- Pooja
	        			/*$totalWardNewCost = $totalWardNewCost + $uniqueSlot['cost']+$uniqueSlot['anaesthesist_cost']+$uniqueSlot['ot_charges']+
	        								$uniqueSlot['surgeon_cost']+$uniqueSlot['asst_surgeon_one_charge']+$uniqueSlot['asst_surgeon_two_charge']+
	        								$uniqueSlot['cardiologist_charge']+$uniqueSlot['extra_hour_charge']+$uniqueSlot['ot_extra_services'];*/
	        		}else{
	        			$wardNameKey = key($uniqueSlot);#echo $wardNameKey;
	        			$wardCostPerWard = $uniqueSlot[$wardNameKey][0]['cost'];
	        			//$totalWardNewCost = $totalWardNewCost + (count($uniqueSlot[$wardNameKey]) * $wardCostPerWard);
	        			$totalWardNewCosts = $totalWardNewCosts + (count($uniqueSlot[$wardNameKey]) * $wardCostPerWard);
	        			$totalWardDays = $totalWardDays + count($uniqueSlot[$wardNameKey]);
	        		}
	        	}
	        	/********************* Ward Charges ends ********************/
	        	
	        	/***************************** Doctor, Nursing, Registration Charges Starts**************/
	        	$hospitalType = $this->Session->read('hospitaltype');
	        	if($hospitalType == 'NABH'){
	        		$nursingServiceCostType = 'nabh_charges';
	        	}else{
	        		$nursingServiceCostType = 'non_nabh_charges';
	        	
	        	}
	        	$this->loadModel('Coupon');
	        	if(!empty($patient_details['Patient']['coupon_name'])){
	               $couponDetails  = $this->Coupon->find('first',array('conditions'=>array('Coupon.batch_name'=>$patient_details['Patient']['coupon_name']),'fields'=>array('sevices_available','type')));
	        	}
	        	$roomTarifId=$this->ServiceCategory->getServiceGroupId('roomtariffGroup');
	        	$ManditoryGroupId=$this->ServiceCategory->getServiceGroupId('mandatoryservices');
	        	$registrationCharges = $this->getRegistrationCharges($totalWardDays,$hospitalType,$tariffStandardId);
	        	
	        	$pvtTariffStandard = $this->TariffStandard->getPrivateTariffID();
	        	
	        	if($patient_details['Patient']['tariff_standard_id'] == $pvtTariffStandard){
		        	$doctorCharges = $this->Billing->getDoctorCharges($totalWardDays,$hospitalType,$tariffStandardId);
		        	$nursingCharges = $this->Billing->getNursingCharges($totalWardDays,$hospitalType,$tariffStandardId);	
        		  }
        		}
        		
        	    	 $sevicesAvailable = explode(',',$couponDetails['Coupon']['sevices_available']);
        		   if($patient_details['Patient']['coupon_name'] && in_array($roomTarifId,$sevicesAvailable) && in_array($ManditoryGroupId,$sevicesAvailable)){
        			$manditoryGroup = $doctorCharges+$nursingCharges;
        			$discountChargess = $this->getDiscountedManditoryRoomCharges($manditoryGroup,$totalWardNewCosts,$patient_details);
        		    $totalDiscount = $totalDiscount +$discountChargess[0] + $discountChargess[1];        		   
        		  }
        		   
	        	/***************************** Doctor, Nursing, Registration Charges ends**************/
	        	$totalBill=$totalBill+/*$doctorCharges+$nursingCharges+*/$totalWardNewCost;
	        	$this->set(array('patient'=>$patient_details,'totalBill'=>$totalBill,'totalAdvancePaid'=>$totalPaid,'manditoryAndRoomdiscountChargess'=>$discountChargess,
	        					 'totalDiscount'=>$totalDiscount,'couponDetails'=>$couponDetails,'roomTarifId'=>$roomTarifId,'ManditoryGroupId'=>$ManditoryGroupId));
	        	
	        	$this->loadModel('Account');
	        	$this->Account->bindModel(array(
	        			'belongsTo' => array(
	        					'AccountingGroup'=>array('foreignKey' => false,'conditions'=>array('AccountingGroup.id=Account.accounting_group_id')),
	        			)),false);
	        	$bankData =$this->Account->find('all',array('fields'=>array('id','name'),'conditions'=>array('Account.is_deleted'=>'0','AccountingGroup.name'=>Configure::read('bankLabel'))));
	        	$bankDataArray = array();
	        	foreach($bankData as $bank){
	        		$bankDataArray[$bank['Account']['id']] = $bank['Account']['name'];
	        	}
	        	$this->set('bankData',$bankDataArray);
        	
        }
        function getDiscountedManditoryRoomCharges($manditoruGroupCharges,$totalWardNewCost,$patient_details){
        	    $this->loadModel("Coupon");
        	    $this->loadModel("ServiceCategory");
        		$serviceCategorys = $this->ServiceCategory->find('list', array('conditions'=>array('ServiceCategory.is_deleted'=>0,'ServiceCategory.is_view'=>1,'ServiceCategory.alias IS not null','ServiceCategory.location_id !='=>'23','ServiceCategory.service_type !='=>''),
        				'fields'=>array('ServiceCategory.id','ServiceCategory.alias')));
        		//if($serviceCategorys[$groupId] != Configure::read('Consultant')){
        		
        		$manditoruGroupId = $this->ServiceCategory->getServiceGroupId('mandatoryservices');
        		$roomTariffGroupId = $this->ServiceCategory->getServiceGroupId('roomtariffGroup');
        		
        		$couponDetails  = $this->Coupon->find('first',array('conditions'=>array('Coupon.batch_name'=>$patient_details['Patient']['coupon_name']),'fields'=>array('id','batch_name','sevices_available','coupon_amount')));
        		$sevicesAvailable = explode(',',$couponDetails['Coupon']['sevices_available']);
        		$couponAMT = unserialize($couponDetails['Coupon']['coupon_amount']);
        		if(in_array($manditoruGroupId, $sevicesAvailable)){ 
        			$totalPayment = $manditoruGroupCharges;
        			$Coupontype = $couponAMT[$manditoruGroupId]['type'];
        			$CoupontypeAmount = $couponAMT[$manditoruGroupId]['value'];
        			if($Coupontype == 'Percentage'){
        				$perSentAmt = ($totalPayment/100)*$CoupontypeAmount;
        				$pending = $totalPayment - $perSentAmt;
        				$ManditorydiscAmt = $perSentAmt;
        			}else if($Coupontype == 'Amount'){
        				$pending = $totalPayment - $CoupontypeAmount;
        				$ManditorydiscAmt = $CoupontypeAmount;
        			}
        		}
        		  if(in_array($roomTariffGroupId, $sevicesAvailable) /*&& $serviceCategorys[$roomTariffGroupId] == Configure::read('roomtariffGroup')*/ ){
        			$totalPayment = $totalWardNewCost;
        			$Coupontype = $couponAMT[$roomTariffGroupId]['type'];
        			$CoupontypeAmount = $couponAMT[$roomTariffGroupId]['value'];
        			if($Coupontype == 'Percentage'){
        				$perSentAmt = ($totalPayment/100)*$CoupontypeAmount;
        				$pending = $totalPayment - $perSentAmt;
        				$roomTariffdiscAmt = $perSentAmt;
        			}else if($Coupontype == 'Amount'){
        				$pending = $totalPayment - $CoupontypeAmount;
        				$roomTariffdiscAmt = $CoupontypeAmount;
        			}
        		}
        		return array($ManditorydiscAmt,$roomTariffdiscAmt);	
        	}         
        /*
        * function to update the flag use_duplicate_sales on final billing
        *  used to use the charges of original pharmacy sales bill or duplicate sales bills on billing and invoices
        */
        public function updateUseDuplicateCharges($finalBillId,$status){
            $this->autoRender = false; 
            $this->loadModel('FinalBilling');
            $this->FinalBilling->id = $finalBillId;
            $this->FinalBilling->saveField('use_duplicate_sales',$status); 
            exit;
        }
        
        //function to return substracted pharmacy charges swapnil - 18.03.2016
	function getDuplicatePharmacyFinalCharges($patient_id=null){
            $this->loadModel('PharmacDuplicateSalesBill'); 
            $pharmacyFinalResult = array(); 
            $this->loadModel('PharmacyDuplicateSalesBill'); 
            return $this->PharmacyDuplicateSalesBill->getPharmacyTotal($patient_id);  
	}
	/**
	 * save package details for patient
	 * @param int $patientId
	 */
	public function galleryPackageDetails($patientId) {
		
		$this->loadModel('GalleryPackageDetail');
		if($this->request->data){
			$this->GalleryPackageDetail->insertPackageDetails($patientId,$this->request->data);
	    }
	    exit;
	}
	/**
	 * get package list for gallery details-Atul
	 */
	function getListOfPackage(){
		$searchKey = $this->params->query['term'];
		$this->loadModel('PackageCategory');
		$packageCategory = $this->PackageCategory->getPackageCategoryName($searchKey);
		foreach ($packageCategory as $key=>$value) {
			$returnArray[] = array( 'id'=>$key,'value'=>ucwords(strtolower($value))) ;
		}
		echo json_encode($returnArray);
		exit;//dont remove this
	}
	/**
	 * get sub package list for gallery details-Atul
	 */
	
	function getListOfSubPackage($packageCategoryId){
		$searchKey = $this->params->query['term'];
		$this->loadModel('PackageSubCategory');
		$packageSubCategory = $this->PackageSubCategory->getSubPackageCategoryName($packageCategoryId,$searchKey);
		foreach ($packageSubCategory as $key=>$value) {
			$returnArray[] = array( 'id'=>$key,'value'=>ucwords(strtolower($value))) ;
		}
		echo json_encode($returnArray);
		exit;//dont remove this
	}
	/**
	 * get sub sub package list for gallery details-Atul
	 */
	function getListOfSubSubPackage($packageCategoryId,$packageSubSubCatId){
		$searchKey = $this->params->query['term'];
		$this->loadModel('PackageSubSubCategory');
		$packageSubSubCategory = $this->PackageSubSubCategory->getSubSubPackageCategoryName($packageCategoryId,$packageSubSubCatId,$searchKey);
		foreach ($packageSubSubCategory as $key=>$value) {
			$returnArray[] = array( 'id'=>$key,'value'=>ucwords(strtolower($value))) ;
		}
		echo json_encode($returnArray);
		exit;//dont remove this
	}
	
	
	function nurseBillingActivity($patientId){
		$this->layout  = 'advance' ;
		$this->loadModel('Laboratory');
		$this->loadModel('Radiology');
		$this->loadModel('TariffList');
		$this->loadModel('TariffAmount');
		$this->loadModel('ServiceCategory');
		$this->loadModel('Patient');
        $data = $this->request->data['Billing']['serviceId'];
		
        $patientDetails = $this->Patient->find('first',array('fields'=>array('Patient.tariff_standard_id'),'conditions'=>array('Patient.id'=>$patientId)));
        $tariffStandardId = $patientDetails['Patient']['tariff_standard_id'];
	    foreach ($data as $val){
			list($id,$name) = explode('_', $val);
			$value[][$name] = $id;
			
		}
		
		foreach ($value as $key => $label ){
			
			$keyLabel = key($label);
			if($keyLabel == 'TARIFF'){
				$type = "TARIFF";
				$ids= $label[$keyLabel];
			}else if($keyLabel == 'LAB'){
				$ids = $label[$keyLabel];
				$type = "LAB";
			}else{
				$ids = $label[$keyLabel];
				$type = "RAD";
			}
			
			if(!empty($ids)){
				$this->saveBillingActivity($ids,$type,$patientId,$tariffStandardId);
			}
			
		}
	
		 exit;
	}
	
	public function saveBillingActivity($ids,$type,$patientId,$tariffStandardId){
		$this->uses = array('Laboratory','LaboratoryTestOrder','Radiology','RadiologyTestOrder','TariffAmount','ServiceBill','TariffList');
		if($type == 'LAB'){
			$rate=$this->Laboratory->getRate($ids,$tariffStandardId);
			$dataLab['LaboratoryTestOrder']['laboratory_id']=$ids;
			$dataLab['LaboratoryTestOrder']['patient_id']=$patientId;
			$dataLab['LaboratoryTestOrder']['amount']=$rate;
			$dataLab['LaboratoryTestOrder']['start_date']=date('Y-m-d H:i:s');
			$dataLab['LaboratoryTestOrder']['create_time']=date('Y-m-d H:i:s');
			$dataLab['LaboratoryTestOrder']['created_by']=$this->Session->read('userid') ;
			$dataLab['LaboratoryTestOrder']['location_id']  = $this->Session->read('locationid') ;
			$this->LaboratoryTestOrder->saveAll($dataLab);
			$this->LaboratoryTestOrder->id = '';
		}else if($type == 'RAD'){
			$rate=$this->Radiology->getRate($ids,$tariffStandardId);
			$dataRad['RadiologyTestOrder']['radiology_id']=$ids;
			$dataRad['RadiologyTestOrder']['patient_id']=$patientId;
			$dataRad['RadiologyTestOrder']['amount']=$rate;
			$dataRad['RadiologyTestOrder']['radiology_order_date']=date('Y-m-d H:i:s');
			$dataRad['RadiologyTestOrder']['create_time']=date('Y-m-d H:i:s');
			$dataRad['RadiologyTestOrder']['created_by']=$this->Session->read('userid') ;
			$dataRad['RadiologyTestOrder']['location_id']  = $this->Session->read('locationid') ;
			$this->RadiologyTestOrder->saveAll($dataRad);
			$this->RadiologyTestOrder->id = '';
			
		}else{
			$rate=$this->TariffAmount->getTariffAmount($tariffStandardId,$ids);
			$serviceCatID = $this->TariffList->getServiceCatId($ids);
			
			$dataOtherSerArr['ServiceBill']['tariff_list_id']=$ids;
			$dataOtherSerArr['ServiceBill']['amount']=$rate;
			$dataOtherSerArr['ServiceBill']['date']=date('Y-m-d H:i:s');
			$dataOtherSerArr['ServiceBill']['service_id']=$serviceCatID['TariffList']['service_category_id'];
			$dataOtherSerArr['ServiceBill']['patient_id']=$patientId;
			$dataOtherSerArr['ServiceBill']['tariff_standard_id']=$tariffStandardId;
			$dataOtherSerArr['ServiceBill']['no_of_times']='1';
			$dataOtherSerArr['ServiceBill']['create_time'] = date("Y-m-d H:i:s");
			$dataOtherSerArr['ServiceBill']['created_by']  = $this->Session->read('userid') ;
			$dataOtherSerArr['ServiceBill']['location_id']  = $this->Session->read('locationid') ;
			$this->ServiceBill->saveAll($dataOtherSerArr);
			$this->id='';
		}
	}

	function markClear($patientId){
		$this->autoRender=false;
		if($patientId){
			$this->loadModel('Patient');
			$this->Patient->save(array(
					'id'=>$patientId,
					'ethnicity_id'=>'1',
					'modified_time'=>date('Y-m-d H:i:s'),
					'modified_by'=>$this->Session->read('userid')
				));
			echo '1';
		}

	}

	function print_package_invoice($patientId){
        $this->layout = false;
        $this->uses = array('Patient','PatientCovidPackage','PharmacySalesBill','LaboratoryTestOrder','RadiologyTestOrder','FinalBilling','Diagnosis','Servicebill','Billing');

        /*$patientData=$this->Patient->find('first',array('fields'=>array('Patient.id','Patient.person_id','Patient.age','Patient.sex','Patient.dob','Patient.lookup_name','Patient.patient_id','Patient.admission_id','Patient.admission_type','Patient.form_received_on'),'conditions'=>array('Patient.id'=>$patientId)));*/

        $this->patient_info($patientId);

        $finalBillingData = $this->FinalBilling->find('first',array('conditions'=>array('FinalBilling.location_id'=>
                $this->Session->read('locationid'),'FinalBilling.patient_id'=>$patientId)));

            
        // fetch diagnosis from diagnosis table
        $this->loadModel('Diagnosis');
        $diagnosisData = $this->Diagnosis->find('first',array('fields'=>array('Diagnosis.final_diagnosis'),'conditions'=>array('Diagnosis.patient_id'=>$patientId)));
        $this->set('diagnosisData',$diagnosisData);
            
        if(isset($finalBillingData['FinalBilling']['bill_number']) && $finalBillingData['FinalBilling']['bill_number']!=''){
            $bNumber = $finalBillingData['FinalBilling']['bill_number'];
            $this->set('billNumber',$bNumber);
        }else{
            $bNumber = $this->generateBillNo($id);
            $this->set('billNumber',$bNumber);
        }

        $packageDates = $this->PatientCovidPackage->find('all',array('fields'=>array('PatientCovidPackage.*'),'conditions'=>array('PatientCovidPackage.patient_id'=>$patientId),'order'=>array('PatientCovidPackage.package_start_date'=>'ASC')));

        $firstArr= current($packageDates);
        $lastArr = end($packageDates);

        $firstDate = $firstArr['PatientCovidPackage']['package_start_date'] ;
        $lastDate = $lastArr['PatientCovidPackage']['package_end_date'] ;

        $this->PatientCovidPackage->bindModel(array(
                    'belongsTo' => array(
                            'User' =>array('foreignKey' => false,'conditions'=>array('User.id=PatientCovidPackage.doctor_id' )),
                    )),false);

        $packageList = $this->PatientCovidPackage->find('all',array('fields'=>array('PatientCovidPackage.*','User.first_name','User.last_name'),'conditions'=>array('PatientCovidPackage.patient_id'=>$patientId),'order'=>array('PatientCovidPackage.package_start_date'=>'ASC')));

        

        
        $customArray = array();
        $ppeCount = 0;

        foreach ($packageList as $key => $value) {
            //$customArray[$value['PatientCovidPackage']['package_cost']] = $value ;
            $ppeCount+= $value['PatientCovidPackage']['ppe_count'];
        }
        

        $this->PharmacySalesBill->unBindModel(array('hasMany' => array('PharmacySalesBillDetail')));
        
        $this->recursive = -1 ;
        $pharmacySaleData= $this->PharmacySalesBill->find('all',array(
                'fields'=> array('PharmacySalesBill.patient_id','PharmacySalesBill.corporate_super_bill_id','SUM(PharmacySalesBill.total) as pharmacyTotal',
                        'SUM(PharmacySalesBill.discount) as discount','SUM(PharmacySalesBill.paid_amnt) as paidAmt'),
                'conditions'=>array('PharmacySalesBill.patient_id'=>$patientId,'PharmacySalesBill.is_deleted'=>0),
                'group'=>array('PharmacySalesBill.patient_id')));


        $pharmacyReturnCharges= $this->getPharmacyReturnCharges($patientId);

    
        /*get lab details*/
        //$labTestDetails = $this->LaboratoryTestOrder->getLabDetails(array('LaboratoryTestOrder.patient_id'=>$patientId));
        $labTestDetails = $this->LaboratoryTestOrder->getPatientWiseCharges($patientId);
        
        /*//debug($labTestDetails);
        $labDataArray = array();
        foreach ($labTestDetails as $key => $value) {
            $labDataArray[$value['Laboratory']['name']]['lab_name'] = $value['Laboratory']['name'] ;
            $labDataArray[$value['Laboratory']['name']]['lab_count'] += 1 ;
            $labDataArray[$value['Laboratory']['name']]['amount'] =  $value['LaboratoryTestOrder']['amount'] ;
        }*/


        /*get rad details*/
        //$radTestDetails = $this->RadiologyTestOrder->getRadiologyDetails(array('RadiologyTestOrder.patient_id'=>$patientId));
        $radTestDetails = $this->RadiologyTestOrder->getPatientWiseCharges($patientId);
        /*$radDataArray = array();
        foreach ($radTestDetails as $key => $value) {
            $radDataArray[$value['Radiology']['name']]['rad_name'] = $value['Radiology']['name'] ;
            $radDataArray[$value['Radiology']['name']]['rad_count'] += 1 ;
            $radDataArray[$value['Radiology']['name']]['amount'] =  $value['RadiologyTestOrder']['amount'] ;
        }*/

        #debug($radTestDetails);

        $getClaimId = $this->PatientCovidPackage->find('all',array('fields'=>array('PatientCovidPackage.claim_id'),'conditions'=>array('PatientCovidPackage.patient_id'=>$patientId,'PatientCovidPackage.claim_id IS NOT NULL'),'group'=>array('PatientCovidPackage.claim_id')));


        $clinicalServices = $this->Servicebill->getPatientWiseCharges($patientId);

    	$advanceAmount =  $this->Billing->getPatientPaidAmount($patientId);

        

        $this->set(array('firstDate'=>$firstDate,'lastDate'=>$lastDate,'customArray'=>$packageList,'ppeCount'=>$ppeCount,'labDataArray'=>$labTestDetails,'pharmacySaleData'=>$pharmacySaleData,'radDataArray'=>$radTestDetails,'getClaimId'=>$getClaimId,'clinicalServices'=>$clinicalServices,'advanceAmount'=>$advanceAmount,'pharmacyReturnCharges'=>$pharmacyReturnCharges));

        if($this->params->query['type']=='excel'){
            $this->autoRender = false;
            $this->layout = false ;
            $this->render('print_package_invoice_excel',false);
        }
    }

//     function printStayNotes($patient_id=null){
        
//         //$this->layout ='print' ;
//         $this->uses = array('DischargeSummary');
//         $this->patient_info($patient_id);// For element print patient info
//         $stayNotes = $this->DischargeSummary->find('first',array('fields'=>array('DischargeSummary.present_condition','DischargeSummary.reason_of_discharge','DischargeSummary.investigation'),'conditions'=>array('DischargeSummary.patient_id'=>$patient_id)));
//         $this->layout = 'print' ;
//         $this->set(array('stayNotes'=>$stayNotes));
         
// 	}


function printStayNotes($patient_id = null) {
		$this->uses = array('DischargeSummary', 'User', 'Patient'); // Added Patient model
	
		// Fetch patient info
		$this->patient_info($patient_id);
	
		// Fetch all required discharge summary details
		$stayNotes = $this->DischargeSummary->find('first', array(
			'fields' => array(
				'DischargeSummary.present_condition',
				'DischargeSummary.reason_of_discharge',
				'DischargeSummary.advice',
				'DischargeSummary.investigation',
				'DischargeSummary.review_on',
				'DischargeSummary.resident_doctor_id' // Fetch Resident Doctor ID
			),
			'conditions' => array('DischargeSummary.patient_id' => $patient_id)
		));
	
		// Fetch Resident Doctor Name
		$residentDoctorName = '';
		if (!empty($stayNotes['DischargeSummary']['resident_doctor_id'])) {
			$residentDoctor = $this->User->find('first', array(
				'fields' => array('User.first_name', 'User.last_name'),
				'conditions' => array('User.id' => $stayNotes['DischargeSummary']['resident_doctor_id']),
				'recursive' => -1
			));
			if ($residentDoctor) {
				$residentDoctorName = $residentDoctor['User']['first_name'] . ' ' . $residentDoctor['User']['last_name'];
			}
		}
	
		// Fetch Treating Consultant
		$treatingConsultantData = $this->User->find('first', array(
			'fields' => array(
				'User.first_name',
				'User.last_name',
				'Initial.name as initial_name'
			),
			'joins' => array(
				array(
					'table' => 'initials',
					'alias' => 'Initial',
					'type' => 'LEFT',
					'conditions' => array('Initial.id = User.initial_id')
				)
			),
			'conditions' => array('User.id' => $stayNotes['DischargeSummary']['resident_doctor_id']),
			'recursive' => -1
		));
	
		// Fetch Other Consultants
		$otherConsultantData = [];
		$patientDetails = $this->Patient->find('first', array(
			'fields' => array('Patient.other_consultant'),
			'conditions' => array('Patient.id' => $patient_id)
		));
	
		if (!empty($patientDetails['Patient']['other_consultant'])) {
			$consultantIds = unserialize($patientDetails['Patient']['other_consultant']);
			$otherConsultantData = $this->User->find('all', array(
				'fields' => array(
					'User.first_name',
					'User.last_name',
					'Initial.name as initial_name'
				),
				'joins' => array(
					array(
						'table' => 'initials',
						'alias' => 'Initial',
						'type' => 'LEFT',
						'conditions' => array('Initial.id = User.initial_id')
					)
				),
				'conditions' => array('User.id' => $consultantIds),
				'recursive' => -1
			));
		}
	
		// Set layout and pass data to view
		$this->layout = 'print';
		$this->set(array(
			'stayNotes' => $stayNotes,
			'residentDoctorName' => $residentDoctorName, // Resident Doctor Name
			'treatingConsultantData' => $treatingConsultantData, // Treating Consultant
			'otherConsultantData' => $otherConsultantData // Other Consultants
		));
	}
	
// 	Reduce Rad and lab charges by @7387737062

public function generateReceiptReduce($id,$mode=''){
			
		$this->uses = array('TariffList','TariffStandard','Bed','FinalBilling','InsuranceCompany','SubServiceDateFormat','ServiceBill','OtPharmacySalesBill',
				'Corporate','Service','DoctorProfile','Person','Consultant','User','Patient','ConsultantBilling','SubService','Billing','OtPharmacySalesReturn',
				'PharmacySalesBill','PharmacySalesBillDetail','InventoryPharmacySalesReturn','InventoryPharmacySalesReturnsDetail','ServiceCategory');
		if(!empty($id)){
			$this->patient_info($id);// For element print patient info
			$this->ServiceBill->bindModel(array(
					'belongsTo' => array(
							'Patient' =>array(
									'foreignKey'=>'patient_id'
							),
					)));


			$patient_pharmacy_details = $this->PharmacySalesBill->getPatientSaleDetails($id);
                        
			//Pharmacy charges will be added to billing only if the Pharmacy Service is set to IPD
			$this->loadModel('Configuration');
			/*$pharmacy_service_type=$this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'Pharmacy')));
			 $pharmConfig=unserialize($pharmacy_service_type['Configuration']['value']);*/

			$pharmConfig=$this->Configuration->getPharmacyServiceType();// to get pharmacy service type
			$this->set('pharmConfig',$pharmConfig);
			$website_service_type=$this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website'/*,'Configuration.location_id'=>$this->Session->read('locationid')*/)));
			$websiteConfig=unserialize($website_service_type['Configuration']['value']);
			if($websiteConfig['instance']=='kanpur'){
				$this->loadModel('PharmacySalesBill');
				$isReceivedByNurse=$this->PharmacySalesBill->find('first',array('fields'=>array('PharmacySalesBill.id','PharmacySalesBill.is_received'),
						'conditions'=>array('PharmacySalesBill.patient_id'=>$id)));
				if($isReceivedByNurse['PharmacySalesBill']['is_received']=='1' /* && strtolower($tariffStdData['Patient']['admission_type'])=='ipd' */){
					// url flag to show pharmacy charges -- Pooja
					if($this->params->query['showPhar']){
						$pharmConfig['addChargesInInvoice']='yes';
					}
					if($pharmConfig['addChargesInInvoice']=='yes'){
						$pharmacy_total =0;
						$pharmacy_cash_total = 0;
						$pharmacy_credit_total =0;
                                                
						if($patient_pharmacy_details){
							//$pharmacy_total = $this->PharmacySalesBill->getTotalAmount($patient_pharmacy_details);
							$pharmacy_cash_total = $this->PharmacySalesBill->getCashAmount($patient_pharmacy_details);
							$pharmacy_credit_total = $this->PharmacySalesBill->getCreditAmount($patient_pharmacy_details);
						}

						$pharmacy_total=$this->getPharmacyFinalCharges($id);// to get totalPharmacy - pharmacyReturn
						$this->set('pharmacyPaidAmount',$pharmacy_cash_total);
					}
				}
			}else{ 
				// url flag to show pharmacy charges -- Pooja
				if($this->params->query['showPhar']){
					$pharmConfig['addChargesInInvoice']='yes';
				}
				if($pharmConfig['addChargesInInvoice']=='yes'){
					$pharmacy_total =0;
					$pharmacy_cash_total = 0;
					$pharmacy_credit_total =0;
                                        
                                        //to get the charges of either original Pharmacy sale or duplicate pharmacy by Swapnil - 15.03.2016 
                                        $this->loadModel('PharmacySalesBill');
                                        $useDuplicateSales = $this->Patient->getFlagUseDuplicateSalesCharge($id); 
							/*$finalBillingData = $this->FinalBilling->find('first',array(
								'fields'=>array('use_duplicate_sales'),
								'conditions'=>array('patient_id'=>$id,''=>'1')));*/
                                        if($useDuplicateSales=='1'){
                                            $pharmacy_total= $this->getDuplicatePharmacyFinalCharges($id);//for total pharmacy charge
                                        }else{
                                            if($patient_pharmacy_details){
                                                //$pharmacy_total = $this->PharmacySalesBill->getTotalAmount($patient_pharmacy_details);
                                                $pharmacy_cash_total = $this->PharmacySalesBill->getCashAmount($patient_pharmacy_details);
                                                $pharmacy_credit_total = $this->PharmacySalesBill->getCreditAmount($patient_pharmacy_details);
                                            }
                                            $pharmacy_total=$this->getPharmacyFinalCharges($id);// to get totalPharmacy - pharmacyReturn
                                        } 
                                        /*
					if($patient_pharmacy_details){
						//$pharmacy_total = $this->PharmacySalesBill->getTotalAmount($patient_pharmacy_details);
						$pharmacy_cash_total = $this->PharmacySalesBill->getCashAmount($patient_pharmacy_details);
						$pharmacy_credit_total = $this->PharmacySalesBill->getCreditAmount($patient_pharmacy_details);
					}
                        
					$pharmacy_total=$this->getPharmacyFinalCharges($id);// to get totalPharmacy - pharmacyReturn*/
					$this->set('pharmacyPaidAmount',$pharmacy_cash_total);
				}
			}

		}else{
			$this->redirect(array("controller" => "billings", "action" => "patientSearch"));
		}
			
		$this->ConsultantBilling->bindModel(array(
				'belongsTo' => array( 	'TariffList' =>array('foreignKey'=>'consultant_service_id'),
						'DoctorProfile' =>array('foreignKey' => 'doctor_id'),
						'Consultant' =>array('foreignKey' => 'consultant_id'),
						'User' =>array('foreignKey' => false ,'conditions'=>array('DoctorProfile.user_id=User.id')),
						'ServiceCategory'=>array('foreignKey' => 'service_category_id'),
						'Initial' =>array('foreignKey'=>false,'conditions' => array('Initial.id=User.initial_id')),
				)),false);
			
			
		$tempConDData = $this->ConsultantBilling->find('all',array('fields'=>array('TariffList.*,ServiceCategory.*,ConsultantBilling.*,DoctorProfile.*','Initial.name'),
				'conditions'=>array('ConsultantBilling.consultant_id'=>NULL,'ConsultantBilling.patient_id'=>$id),'order'=>array('ConsultantBilling.date')));

		$this->ConsultantBilling->bindModel(array(
				'belongsTo' => array( 	'TariffList' =>array('foreignKey'=>'consultant_service_id'),
						'Consultant' =>array('foreignKey' => 'consultant_id'),
						'ServiceCategory'=>array('foreignKey' => 'service_category_id'),
						'Initial' =>array('foreignKey'=>false,'conditions' => array('Consultant.initial_id=Initial.id')),
				)),false);

		$tempConCData = $this->ConsultantBilling->find('all',array('fields'=>array('TariffList.*,ServiceCategory.*,ConsultantBilling.*,Consultant.*','Initial.name'),
				'conditions'=>array('ConsultantBilling.doctor_id'=>NULL,'ConsultantBilling.patient_id'=>$id),'order'=>array('ConsultantBilling.date')));
		 
		$cDArray=array();
		$cCArray=array();
		foreach($tempConDData as $tCD){
			$tCD['ConsultantBilling']['amount'] = $this->Number->format($tCD['ConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.',
					'before'=>false,'thousands'=>false));
			$cDArray[$tCD['ConsultantBilling']['consultant_service_id']][$tCD['ConsultantBilling']['doctor_id']][$tCD['ConsultantBilling']['amount']][]=$tCD;

		}
			
		foreach($tempConCData as $tCD){
			$tCD['ConsultantBilling']['amount'] = $this->Number->format($tCD['ConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.',
					'before'=>false,'thousands'=>false));
			$cCArray[$tCD['ConsultantBilling']['consultant_service_id']][$tCD['ConsultantBilling']['consultant_id']][$tCD['ConsultantBilling']['amount']][]=$tCD;

		}
		$this->set('cCArray',$cCArray);
		$this->set('cDArray',$cDArray);
			
		/*
		 $facilityData = $this->Facility->read('',$this->Session->read('facilityid'));
		$this->set('facilityData',$facilityData);*/
		$locationFooter = $this->General->billingFooter($this->Session->read('locationid'));
		$this->set('locationFooter',$locationFooter);
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment'),
						'TariffStandard' =>array('foreignKey'=>'tariff_standard_id'),
						'TariffList' =>array('foreignKey'=>'treatment_type'),
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )))
				,'hasOne'=>array('Diagnosis'=>array('foreignKey'=>'patient_id','fields'=>array('Diagnosis.final_diagnosis')))));

		
		$patient_details  = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$id)));
		$this->set('patientd',$patient_details);
		$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);	
		$formatted_address = $this->setAddressFormat($UIDpatient_details['Person']);
		
		$this->set(array('person'=>$UIDpatient_details,'photo' => $UIDpatient_details['Person']['photo'],'address'=>$formatted_address,
				'patient'=>$patient_details,'id'=>$id,'treating_consultant'=>$this->User->getDoctorByID($patient_details['Patient']['doctor_id'])));

		$creditTypeId = $patient_details['Patient']['credit_type_id'];
		if($creditTypeId == 1){
			$corporateId = $patient_details['Patient']['corporate_id'];
		}elseif($creditTypeId == 2){
			$corporateId = $patient_details['Patient']['insurance_company_id'];
		}else{
			$corporateId = 0;
		}
		//change by pankaj now corporate will come from only tariff standard`
		$corporateEmp = $patient_details['TariffStandard']['name'];
		/*if($creditTypeId == 1){
			$corporates = $this->Corporate->find('list',array('fields'=>array('id','name'),'conditions'=>array('Corporate.is_deleted'=>0)));
			$corporateEmp = $corporates[$corporateId];
		}else if($creditTypeId == 2){
			$corporates = $this->InsuranceCompany->find('list',array('fields'=>array('id','name'),'conditions'=>array('InsuranceCompany.is_deleted'=>0)));
			$corporateEmp = $corporates[$corporateId];
		}else{
			$corporateEmp ='Private';
		}*/
		$this->set('corporateEmp',$corporateEmp);
		$this->set('primaryConsultant',$this->User->getDoctorByID($patient_details['Patient']['doctor_id']));
		$advancePaidData = $this->Billing->find('all',array('conditions'=>array('patient_id'=>$id,'is_deleted'=>'0',
				'location_id'=>$this->Session->read('locationid'))));
		$totalAdvancePaid = 0;
		$pharmacyCategoryId=$this->ServiceCategory->getPharmacyId();//in case need of pharmacy category ID

		// url flag to show pharmacy charges -- Pooja
		if($this->params->query['showPhar']){
			$pharmConfig['addChargesInInvoice']='yes';
		}
		foreach($advancePaidData as $advancePaid){
			if($advancePaid['Billing']['payment_category']==$pharmacyCategoryId && $pharmConfig['addChargesInInvoice']=='yes'){
				$pharAdvance=$pharAdvance+$advancePaid['Billing']['amount'];//for getting only pharmacy paid amount-- Pooja
				$totalAdvancePaid = $totalAdvancePaid + $advancePaid['Billing']['amount'];
			}else if($advancePaid['Billing']['payment_category']!=$pharmacyCategoryId){
				$totalAdvancePaid = $totalAdvancePaid + $advancePaid['Billing']['amount'];
			}
		}
		
		/* Ot Pharmacy Sales Bill Total Credit Amount */
		$ot_pharmacy_patient = $this->OtPharmacySalesBill->getPatientDetails($id);
		//debug($ot_pharmacy_patient);exit; 
		if($ot_pharmacy_patient){	
			$ot_pharmacy_credit_total = $this->OtPharmacySalesBill->getCreditAmount($ot_pharmacy_patient); 
		}
		
		$OtPharmacyReturnData=$this->OtPharmacySalesReturn->getOtPharmacyReturnData($id);//ot pharmacy return data
		$return_amount = 0;
		foreach($OtPharmacyReturnData as $key=>$value){
			$return_amount = $return_amount+$value['OtPharmacySalesReturn']['total'];
		}
		$this->set('return_amount',$return_amount); 
		/* END of OT Pharmacy Credit Amount*/
		
		$totalAdvancePaid = $totalAdvancePaid+$pharmacy_cash_total;
		#$totalAdvancePaid = $totalAdvancePaid + $pharmacy_cash_total;
		
		$pharmacyReturnChargesInInvoice=$this->getPharmacyReturnCharges($id);
		$this->set('pharmacyReturnChargesInInvoice',$pharmacyReturnChargesInInvoice['0']['sumTotal']);
		$this->set('totalAdvancePaid',$totalAdvancePaid);
		$this->set('pharmacy_charges',$pharmacy_total[0]['total']);
		$this->set('pharmacy_cash_charges',$pharmacy_cash_total);
		$this->set('pharmacy_credit_charges',$pharmacy_credit_total);
		$this->set('pharmacyAdv',$pharAdvance);
		$this->set('otPharmacyToatalAmount',$ot_pharmacy_credit_total); 
			
		if($patient_details['Patient']['tariff_standard_id']!=''){
			$tariffStandardId=$patient_details['Patient']['tariff_standard_id'];
		}else{
			$tariffData=$this->TariffStandard->find('first',array('conditions'=>array('name'=>'Private')));
			$tariffStandardId=$tariffData['TariffStandard']['id'];
		}
		$hospitalType = $this->Session->read('hospitaltype');
		
		//paid return amount  --yashwant
		$paidReturnForPharmacy=$this->Billing->returnPaidAmount($id);
		$this->set('paidReturnForPharmacy',$paidReturnForPharmacy);
		
		/******************* Nursing Charges Starts *****************/
			
		$nursingServices = $this->getServiceCharges($id,$tariffStandardId);

		$totalNursingCharges = 0;
			
		foreach($nursingServices as $nursingService){
			$hospitalType = $this->Session->read('hospitaltype');
			if($hospitalType == 'NABH'){
				//$totalNursingCharges = $totalNursingCharges + $nursingService[0]['count(distinct(`ServiceBill`.`id`))']*$nursingService['TariffAmount']['nabh_charges'];
				$totalNursingCharges = $totalNursingCharges + $nursingService['ServiceBill']['no_of_times']*$nursingService['ServiceBill']['amount'];
			}else{
				//$totalNursingCharges = $totalNursingCharges + $nursingService[0]['count(distinct(`ServiceBill`.`id`))']*$nursingService['TariffAmount']['non_nabh_charges'];
				$totalNursingCharges = $totalNursingCharges + $nursingService['ServiceBill']['non_nabh_charges']*$nursingService['ServiceBill']['amount'];
			}
		}
		//debug($nursingServices);
		$this->set('nursingServices',$nursingServices);
			
		/********************* Nursing Charges Ends *******************/
			
		$this->loadModel('FinalBilling');
		
		$finalBillingData = $this->FinalBilling->find('first',array('conditions'=>array('FinalBilling.location_id'=>
				$this->Session->read('locationid'),'FinalBilling.patient_id'=>$id)));

			
		// fetch diagnosis from diagnosis table
		$this->loadModel('Diagnosis');
		$diagnosisData = $this->Diagnosis->find('first',array('conditions'=>array('Diagnosis.patient_id'=>$id)));
		$this->set('diagnosisData',$diagnosisData);
			
		if(isset($finalBillingData['FinalBilling']['bill_number']) && $finalBillingData['FinalBilling']['bill_number']!=''){
			$bNumber = $finalBillingData['FinalBilling']['bill_number'];
			$this->set('billNumber',$bNumber);
		}else{
			$bNumber = $this->generateBillNo($id);
			$this->set('billNumber',$bNumber);
		}
		$this->set('finalBillingData',$finalBillingData);
		$this->set('patientId',$id);
		$this->labRadRates($tariffStandardId,$id);//calling lab/radiology charges
		
// 		debug($this->labRadRates($tariffStandardId,$id));



		/********************* Ward Charges Starts ********************/
		$wardServicesDataNew = $this->getDay2DayCharges($id,$tariffStandardId,false);
		$wardServicesDataNew = $this->groupWardCharges($id,true);
		//unset($wardServicesDataNew['0']);
		//unset($wardServicesDataNew['1']['ICU Ward']['5']);
		//unset($wardServicesDataNew['2']['Triple Sharing Ward']['0']);
		//$arr = array_values($wardServicesDataNew['2']['Triple Sharing Ward']);
		//$wardServicesDataNew['2']['Triple Sharing Ward'] = $arr;
		//unset($wardServicesDataNew['1']);
		$this->set('wardServicesDataNew',$wardServicesDataNew);
			
		/********************* Ward Charges ends ********************/

		// Lab radiology advance payment deduction
			
		$labPaidAmount = $this->getLabPaidAmount($id);
		$radPaidAmount = $this->getRadPaidAmount($id);
		if($labPaidAmount !='')
			$this->set('labPaidAmount',$labPaidAmount);
		else $this->set('labPaidAmount',0);
		if($radPaidAmount)
			$this->set('radPaidAmount',$radPaidAmount);
		else $this->set('radPaidAmount',0);
		// Lab radiology advance payment deduction
			
			

		/***************************** Doctor, Nursing, Registration Charges Starts**************/
		if($this->Session->read('website.instance')!='vadodara') {
			$registrationCharges = $this->getRegistrationCharges($totalWardDays,$hospitalType,$tariffStandardId);
			$doctorCharges = $this->Billing->getDoctorCharges($totalWardDays,$hospitalType,$tariffStandardId,$patient_details['Patient']['admission_type'],$patient_details['Patient']['treatment_type']);
			$nursingCharges = $this->Billing->getNursingCharges($totalWardDays,$hospitalType,$tariffStandardId);
				
			$registrationChargesData = $this->getRegistrationChargesWithMOA($totalWardDays,$hospitalType,$tariffStandardId);
			$doctorChargesData = $this->getDoctorChargesWithMOA($totalWardDays,$hospitalType,$tariffStandardId,$patient_details['Patient']['admission_type'],$patient_details['Patient']['treatment_type']);
			$nursingChargesData = $this->getNursingChargesWithMOA($totalWardDays,$hospitalType,$tariffStandardId);
	
				
			$doctorRate = $this->getDoctorRate($totalWardDays,$hospitalType,$tariffStandardId,$patient_details['Patient']['admission_type'],$patient_details['Patient']['treatment_type']);
			$nursingRate = $this->getNursingRate($totalWardDays,$hospitalType,$tariffStandardId);
			$this->set('registrationChargesData',$registrationChargesData);
			$this->set('doctorChargesData',$doctorChargesData);
			$this->set('nursingChargesData',$nursingChargesData);
	
			$this->set('nursingRate',$nursingRate);
			$this->set('doctorRate',$doctorRate);
		}
		//below lines are commented by pankaj w as it has been added direct to serviceBill on registration
		//$this->set('registrationRate',$registrationCharges);
		/***************************** Doctor, Nursing, Registration Charges Starts**************/
			
		$this->set('wardServicesDataNew',$wardServicesDataNew);
		$this->set('totalNewWardCharges',$totalWardCharges);
		$this->set('mode',$mode);
			
		/**********************************New Changes Surgery ends *********************/
		//Surgeries listing starts
		$this->loadModel('OptAppointment');
		$this->OptAppointment->unbindModel(array(
				'belongsTo' => array('Initial','Patient','Location','Opt','OptTable','Surgery','SurgerySubcategory','Doctor','DoctorProfile'
							
				)));
		$this->OptAppointment->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array( 'foreignKey'=>'tariff_list_id' 	),
						'Surgery'=>array('foreignKey'=>'surgery_id'),
						'DoctorProfile'=>array('foreignKey'=>'doctor_id'))));
			
		$surgeriesData = $this->OptAppointment->find('all',array('conditions'=>array('OptAppointment.patient_id'=>$id,'OptAppointment.is_deleted'=>0,
				'OptAppointment.location_id'=>$this->Session->read('locationid'))));
		$this->set('surgeriesData',$surgeriesData);
		//Surgeries listing ends

		// Anesthesia Charges Starts
		$this->OptAppointment->unbindModel(array(
				'belongsTo' => array('Initial','Patient','Location','Opt','OptTable','Surgery','SurgerySubcategory','Doctor','DoctorProfile'
							
				)));
		$this->OptAppointment->bindModel(array(
				'belongsTo' => array(
						'Surgery' =>array(
								'foreignKey'=>'surgery_id'
						),
						'TariffAmount' =>array(
								'foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=Surgery.tariff_list_id')
						),
				)));
		$AnesthesiaDetails = 	$surgeriesData = $this->OptAppointment->find('all',array('fields'=>array('OptAppointment.procedure_complete','Surgery.anesthesia_charges,TariffAmount.*'),'conditions'=>array('OptAppointment.patient_id'=>$id,'OptAppointment.location_id'=>$this->Session->read('locationid'),'TariffAmount.tariff_standard_id'=>$tariffStandardId)));
		$this->set('anesthesiaDetails',$AnesthesiaDetails);
		// Anesthesia Charges Ends

		//for refunded amount
		$discountData =$this->FinalBilling->find('first',array('conditions'=>array('FinalBilling.patient_id'=>$id)));
		$this->set('discountData',$discountData);
		//EOF of refunded amount

		//for discounted and refund amount  --yashwant
		// url flag to show pharmacy charges -- Pooja
		if($this->params->query['showPhar']){
			$pharmConfig['addChargesInInvoice']='yes';
		}
		if($pharmConfig['addChargesInInvoice']=='no'){ 
			$totalDiscountGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.discount) AS sumDiscount','Billing.payment_category' ),
					'conditions'=>array('Billing.patient_id'=>$id,'Billing.is_deleted'=>'0','Billing.payment_category !='=>$pharmacyCategoryId)));
			$this->set('totalDiscountGiven',$totalDiscountGiven);
			
			$totalRefundGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.paid_to_patient) AS sumRefund','Billing.payment_category' ),
					'conditions'=>array('Billing.patient_id'=>$id,'Billing.is_deleted'=>'0','Billing.refund'=>'1','Billing.payment_category !='=>$pharmacyCategoryId)));
			$this->set('totalRefundGiven',$totalRefundGiven);
			
		}else{ 
			$totalDiscountGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.discount) AS sumDiscount','Billing.payment_category' ),
					'conditions'=>array('Billing.patient_id'=>$id,'Billing.is_deleted'=>'0')));
			$this->set('totalDiscountGiven',$totalDiscountGiven);
			
			$totalRefundGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.paid_to_patient) AS sumRefund','Billing.payment_category' ),
					'conditions'=>array('Billing.patient_id'=>$id,'Billing.is_deleted'=>'0','Billing.refund'=>'1')));
			$this->set('totalRefundGiven',$totalRefundGiven);
		}
		
		//***code for discount to be shown in invoice***//

		//EOF discounted amount

		//****for refund amount in invoice****/yashwant/
		/* if($pharmConfig['addChargesInInvoiceaddChargesInInvoiceaddChargesInInvoiceaddChargesInInvoice']=='no'){
			$totalRefundGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.paid_to_patient) AS sumRefund',
					'Billing.payment_category' ),'conditions'=>array('Billing.patient_id'=>$id,'Billing.is_deleted'=>'0','Billing.refund'=>'1','Billing.payment_category'=>$pharmacyCategoryId)));
			$this->set('totalRefundGiven',$totalRefundGiven);
		}else{
			$totalRefundGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.paid_to_patient) AS sumRefund',
				'Billing.payment_category' ),'conditions'=>array('Billing.patient_id'=>$id,'Billing.is_deleted'=>'0','Billing.refund'=>'1')));
			$this->set('totalRefundGiven',$totalRefundGiven);
		}  */
		 
		//***EOF yashwant****//

		/**for tariff**/
		$this->loadModel('TariffStandard');
		$tariffData =$this->TariffStandard->find('list',array('fields'=>array('id','name')));
		$this->set('tariffData',$tariffData);
		/**OF tariff***/
		/**
		 * private package information
		 * gaurav
		*/
		if($this->params->query['privatePackage'] != '')
			$this->set('privatePackageData',$this->General->getPackageNameAndCost($id));
	}
	
// 	corporate bill @7387737062

function corporate_bill($patient_id=null){
			
	$website=$this->Session->read('website.instance');
		if($website == 'kanpur')
		{	
			$this->layout = 'print_with_header';
			
		}else
		 {
		$this->layout = false;
		}
		$this->generateReceipt($patient_id);
		if($patient_id){		
			$this->uses = array('LaboratoryTestOrder','WardPatient');
			$this->patient_info($patient_id);
			$this->Patient->unBindModel(array('hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
// 			$this->Patient->bindModel(array(
// 					'belongsTo' => array('User'=>array('foreignKey'=>'doctor_id'),
// 							'finalBilling'=>array('foreignKey'=>false,'conditions'=>array('finalBilling.patient_id=Patient.id')),
// 							'TariffList' =>array('foreignKey'=>'treatment_type'))));
// 			$forPatientTariff  = $this->Patient->find('first',array('fields'=>array('Patient.form_received_on','Patient.tariff_standard_id','Patient.lookup_name as lookup_name',
// 					'finalBilling.discharge_date,finalBilling.bill_number','TariffList.name'),'conditions'=>array('Patient.id'=>$patient_id)));
// 			debug($forPatientTariff);exit;
			//debug($forPatientTariff); exit;

                    $this->Patient->bindModel(array(
                        'belongsTo' => array(
                            'User' => array(
                                'foreignKey' => 'doctor_id'
                            ),
                            'finalBilling' => array(
                                'foreignKey' => false,
                                'conditions' => array('finalBilling.patient_id = Patient.id')
                            ),
                            'TariffList' => array(
                                'foreignKey' => 'tariff_standard_id' // Link through tariff_standard_id
                            )
                        )
                    ));
                    
                  
                    // Fetch the required data
                    $forPatientTariff = $this->Patient->find('first', array(
                        'fields' => array(
                            'Patient.form_received_on',
                            'Patient.tariff_standard_id',
                            'Patient.lookup_name as lookup_name',
                            'finalBilling.discharge_date',
                            'finalBilling.bill_number',
                            'TariffList.name' // Fetch Tariff name
                          
                        ),
                        'conditions' => array('Patient.id' => $patient_id) // Condition for the Patient
                    ));

                     $tariffnameid = !empty($forPatientTariff['Patient']['tariff_standard_id'])
                    ? $forPatientTariff['Patient']['tariff_standard_id'] 
                    : null; 
                
                // Debugging (optional) TariffStandard
                // debug($tariffnameid); // Check if the value is being extracted correctly
                    
			$this->set('discharge_date',$forPatientTariff['finalBilling']['discharge_date']);
			if(empty($forPatientTariff['finalBilling']['discharge_date'])){
				$forPatientTariff['finalBilling']['discharge_date']= date("Y-m-d") ;
			}
			$splittedInDate  = explode(" ",$forPatientTariff['Patient']['form_received_on']);
			$splittedOutDate  = explode(" ",$forPatientTariff['finalBilling']['discharge_date']);
			//cal the patient's days in hospital
			$interval  = $this->DateFormat->dateDiff($splittedInDate[0],$splittedOutDate[0]);
			$extraDays = $this->is_In_Out_Before_10_AM($splittedInDate[0],$splittedOutDate[0]);
			$totalDaysInHospital = $interval->days+(int)$extraDays ;

			$tariffStandardId=$forPatientTariff['Patient']['tariff_standard_id'];
			$hospitalType = $this->Session->read('hospitaltype');
 			#desination fetch
                    $patientdesignation = $this->Patient->find('first', [
            'conditions' => ['Patient.id' => $patient_id],
            'fields' => ['Patient.designation','discharge_date','create_time','corporate_status',], // Fetch only the designation field
        ]);
        // debug($patientdesignation);exit;
        $this->set('patientdesignation', $patientdesignation); 

         $tariffname = $this->TariffStandard->find('first', [
                    'conditions' => ['TariffStandard.id' => $tariffnameid],
                    'fields' => ['TariffStandard.name'], // Fetch only the designation field
                ]);
                // debug($tariffname);exit;
                $this->set('tariffname', $tariffname); 
                
			//laboratory only
// 			$testRates = $this->labRadRates($tariffStandardId,$patientId);// for lab & rad sevices

			$laboratoryTestOrderData  = $this->labDetails($patient_id);//lab data
			$radTestOrderData  = $this->radDetails($patient_id);//radiology data

			$mriData = $this->mriDetails($patient_id);//MRI data
			$ctData = $this->ctDetails($patient_id);//CT data
			$implantData = $this->implantDetails($patient_id);//IMPLANT data

			//calculating ward Days
			App::import('Controller', 'Billings');
			$billings = new BillingsController;
			$totalWardDays 	= '';
			$doctorCharges 	= $this->getDoctorChargesForDetailBill($tariffStandardId,$patient_id);
			$serviceCharges = $this->getServiceCharges($patient_id,$tariffStandardId);

			$nursingCharges = $this->getNursingChargesForDetailBill($tariffStandardId);
			$pharmacyCharges= $this->getPharmacyCharges($patient_id);

			//BOF Bed charges
			//$bedCharges=  $this->getBedCharge($patient_id,$tariffStandardId);
			$bedCharges = $this->wardCharges($patient_id);
			


			
			$this->FinalBilling->bindModel(array(
					'belongsTo' => array(
							'Diagnosis' =>array(
									'foreignKey'=>false,'conditions'=>array('FinalBilling.patient_id=Diagnosis.patient_id')
							),
					)));
			$finalBillingData = $this->FinalBilling->find('first',array('conditions'=>array('FinalBilling.location_id'=>$this->Session->read('locationid'),'FinalBilling.patient_id'=>$patient_id)));
			$this->set('finalBillingData',$finalBillingData);
			//debug($finalBillingData);exit;
			#echo'<pre>';print_r($doctorCharges['extra_doc_charges']);exit;
			//EOF Bed charges
			$this->loadModel('CorporateSublocation');
			$this->set('subLocations',$this->CorporateSublocation->getCorporateSublocationList($tariffStandardId));

			$this->set(array('labDetail'=>$laboratoryTestOrderData,'radiology'=>$radTestOrderData,'doctorCost'=>$doctorCharges['doc_charges'],'nurse'=>$nursingCharges,
			'service'=>$serviceCharges,'doctorData'=>$forPatientTariff,'patient_days'=>$totalDaysInHospital,'extra_doctor_charges'=>$doctorCharges['extra_doc_charges']
			,'roomTariff'=>$bedCharges,'pharmacyCharges'=>$pharmacyCharges,'mri'=>$mriData,'ct'=>$ctData,'implant'=>$implantData));

			//for refunded amount
			$discountData =$this->FinalBilling->find('first',array('conditions'=>array('FinalBilling.patient_id'=>$patient_id)));
			$this->set('discountData',$discountData);
			//EOF of refunded amount
			
			if($this->params->query['type']=='excel'){
				$this->layout=false;
				$this->render('detail_payment_excel');
			}

		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
		//debug($forPatientTariff); exit;
	}
	
public function start_package($patientId = null)
{
    if ($this->request->is('post')) { // Check if form is submitted
        
        // Get the Person ID and Package Date from the form
        $personId = $this->request->data['Person']['id'];
        $patientId = $this->request->data['Patient']['id'];
        if (!empty($this->request->data['Person']['package_date'])) {
            $packageDate = $this->request->data['Person']['package_date'];

            // Load the Person model
            $this->loadModel('Person');
            
            // Find the existing Person record by Person ID
            $person = $this->Person->findById($personId);

            if ($person) { // If Person record exists, update the record
                // Update the package_date field
                $person['Person']['package_date'] = $packageDate;

                // Save the updated record
                if ($this->Person->save($person)) {
                    $this->Session->setFlash(__('Package date updated successfully.'));
                    // Redirect to the same page or another page
                    return $this->redirect(['action' => 'multiplePaymentModeIpd', $patientId]);
                } else {
                   $this->Session->setFlash(__('Unable to update the package date.'));
                }
            } 
            else {
                // If Person record doesn't exist
                $this->Session->setFlash(__('Person record not found.'));
            }
        } else {
            $this->Session->setFlash(__('Please select a valid package date.'));
        }
    }
}



public function doctors_handover($patient_id=null,$type=null)
	{
		
		$this->layout = 'advance' ;
		$this->uses = array('RadiologyTestOrder','LaboratoryTestOrder','Patient','TariffStandard','Surgery',
				'DoctorProfile','Diagnosis','Ward','Billing','FinalBilling','OptAppointment','PharmacySalesBill',
				'LabTestPayment','RadiologyTestPayment','Bed','Room','Consultant','User','ServiceBill','TariffList',
				'TariffAmount','PharmacyItem','ServiceCategory','PatientCovidPackage');

		$this->Patient->unbindModel(array('hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));

		$this->Bed->bindModel(
				array('belongsTo' => array(
						'Room'=>array('foreignKey'=>'room_id','type'=>'left'
						),
						'Ward'=>array('type'=>'inner','foreignKey'=>false,'conditions'=>array('Ward.id=Room.ward_id')),
						'Patient'=>array('foreignKey'=>false,'conditions'=>array('Bed.patient_id=Patient.id',
								'Patient.is_discharge'=>'0','Patient.is_deleted'=>'0','Patient.admission_type'=>"IPD")),
						'TariffStandard' => array('foreignKey'=>false,
								'conditions'=> array('TariffStandard.id=Patient.tariff_standard_id'),
						), //* for all the fields of patient
						'Diagnosis' => array('foreignKey'=>false,
								'conditions'=>array('Patient.id=Diagnosis.patient_id'),
						),
							
						'ServiceBill' => array('foreignKey'=>false,
						 'conditions'=>array('Patient.id=ServiceBill.patient_id'),
								'fields'=>array('ServiceBill.tariff_list_id')),
							
						/*'TariffList' => array('foreignKey'=>false,
						 'conditions'=>array('ServiceBill.tariff_list_id=TariffList.id'),
								'fields'=>array('TariffList.name','cghs_non_nabh')),*/
							
						'Person'=>array('foreignKey'=>false,'type'=>'inner',
								'conditions'=>array('Person.id=Patient.person_id'),
						),
						'User'=>array('foreignKey'=>false,'conditions'=>array('User.id=Patient.doctor_id'),
						),

						'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.Patient_id=Patient.id'),
						),
						/*'Billing'=>array('foreignKey'=>false,'conditions'=>array('Billing.Patient_id=Patient.id'),
						 ),*/
						'PharmacySalesBill'=>array('foreignKey'=>false,'conditions'=>array('PharmacySalesBill.patient_id=Patient.id'),
						),
							
				),'hasMany'=>array('ConsultantBilling'=>array('foreignKey'=>'patient_id',
						'fields'=>array('ConsultantBilling.amount')))));
		$cond = ''; 
		
		if(!empty($this->request->query['patient_id']) && !isset($this->request->query['format'])){
			$patientID[] = $this->request->query['patient_id'];
			$cond['Patient.id'] = $patientID;
		}
        		if (!empty($this->request->query['dialysis']) && $this->request->query['dialysis'] == '659') {
            $cond['User.department_id'] = '659';
            // debug($cond);exit;// Adjust 'treatment_type' to match your database field
        }
        if (!empty($this->request->query['remove_dialysis']) && $this->request->query['remove_dialysis'] == '659') {
    $cond['User.department_id !='] = '659'; // Exclude Dialysis from the results
}

		$result = $this->Bed->find('all',array('fields'=> array('Bed.*','Room.*','Ward.*','TariffStandard.name','TariffStandard.id','Patient.id', 'Patient.lookup_name','Patient.remark','Patient.sms_sent','Patient.advance_sms_sent_date_time', 'Patient.form_received_on','Patient.admission_id' ,'Patient.create_time','Patient.patient_id','Patient.is_packaged','Patient.person_id',
				'Patient.tariff_standard_id','Patient.diagnosis_txt','Patient.likely_discharge_date','Patient.surgery_text','Diagnosis.final_diagnosis','Diagnosis.id','Person.district','Person.package_date','ServiceBill.date',
			    'User.first_name','User.last_name','FinalBilling.total_amount','PharmacySalesBill.total','Person.mobile','Person.vip_chk','Diagnosis.family_tit_bit','Diagnosis.family_tit_bit1','Diagnosis.family_tit_bit2'),
				'conditions'=>array('Ward.is_deleted'=>0,$cond,'Ward.location_id'=>$this->Session->read('locationid')),
				'order'=>array('Ward.sort_order','Bed.id'),'group'=>array('Bed.id')));
				//  debug($result);exit;
		$this->set('results', $result); 
		$package_date = $this->ServiceBill->find('all', array(
            'fields' => array('ServiceBill.id', 'ServiceBill.patient_id', 'ServiceBill.date'),
            'conditions' => array('ServiceBill.service_id' => 32),
        ));
        
        $today = date('Y-m-d'); 
        $dates = [];
        foreach ($package_date as $bill) {
            if (!empty($bill['ServiceBill']['patient_id'])) {
                $service_date = date('Y-m-d', strtotime($bill['ServiceBill']['date'])); // तारीख को फ़ॉर्मेट करें
                $diff = (strtotime($today) - strtotime($service_date)) / (60 * 60 * 24); // दिनों का अंतर
                $day_label = ($diff >= 0) ? ($diff + 1) . 'th Day' : 'Future Date'; // दिन का लेबल
                $dates[$bill['ServiceBill']['patient_id']][] = [
                    'date' => $bill['ServiceBill']['date'],
                    'day_label' => $day_label,
                ];
            }
        }
        $this->set('dates', $dates);

$this->set('formatted_dates', $formatted_dates);
          $this->set('dates', $dates);
		if(empty($this->request->query['patient_id'])){
			foreach ($result as $key => $value)
			{
				$patientID[] = $value['Patient']['id'];
			}
			$patientID=array_filter($patientID);
		}   

		/* foreach ($result as $key => $value)
		{
			$patientID[] = $result[$key]['Patient']['id'] ;
		}
		$patientID=array_filter($patientID); */

		$this->set('patientID',$patientID);
		$add = $this->Billing->find('all',array('conditions'=>array('patient_id'=>$patientID,'is_deleted'=>'0',
				'location_id'=>$this->Session->read('locationid'))));
		$this->set('advancePayment',$add);
		$this->loadModel('OptAppointment');
		$this->OptAppointment->unbindModel(array(
				'belongsTo' => array('Initial','Patient','Location','Opt','OptTable','Surgery','SurgerySubcategory','Doctor','DoctorProfile')));
			
		$this->OptAppointment->bindModel(array(
				'belongsTo' => array(
						'Surgery'=>array('foreignKey'=>'surgery_id'),
				)));
			
		$surgeriesData = $this->OptAppointment->find('all',array(
				'fields'=>array('OptAppointment.procedure_complete','OptAppointment.implant_description','Surgery.name','OptAppointment.patient_id', 'Surgery.charges',
						'OptAppointment.surgery_cost','OptAppointment.anaesthesia_cost','OptAppointment.ot_charges'),
				'conditions'=>array('OptAppointment.patient_id'=>$patientID,'OptAppointment.is_deleted'=>0,
						'OptAppointment.location_id'=>$this->Session->read('locationid'))));
		$this->set('surgeriesData',$surgeriesData);
// debug($surgeriesData);exit;
	
		foreach($result as $tariff){
			$tariffStandardId[]	=$tariff['Patient']['tariff_standard_id'];
		}
			
		$hospitalType = $this->Session->read('hospitaltype');
		foreach($result as $tariffDays){
			#$bedCharges[$tariffDays['Patient']['id']] = $this->getDay2DayCharges($tariffDays['Patient']['id'],$tariffDays['Patient']['tariff_standard_id']);
			$bedCharges[$tariffDays['Patient']['id']] = $this->wardCharges($tariffDays['Patient']['id']);
			$totalWardDays=count($bedCharges[$tariffDays['Patient']['id']]['day']); //total no of days
			if($totalWardDays==0){
				$totalWardDays=1;
			}
			//debug($tariffDays['Patient']['id'].'--'.$tariffDays['Patient']['tariff_standard_id']);
			$doctorCharges[$tariffDays['Patient']['id']] = $this->Billing->getDoctorCharges($totalWardDays,$hospitalType,$tariffDays['Patient']['tariff_standard_id'],'IPD');
			$nursingCharges[$tariffDays['Patient']['id']] = $this->Billing->getNursingCharges($totalWardDays,$hospitalType,$tariffDays['Patient']['tariff_standard_id']);
		//	$wardServicesDataNew[$tariffDays['Patient']['id']] = $this->getDay2DayWardCharges($tariffDays['Patient']['id'],$tariffDays['Patient']['tariff_standard_id']);
			#$wardServicesDataNew[$tariffDays['Patient']['id']] = $this->getDay2DayCharges($tariffDays['Patient']['id'],$tariffDays['Patient']['tariff_standard_id']);
			$wardServicesDataNew[$tariffDays['Patient']['id']] = $this->groupWardCharges($tariffDays['Patient']['id']);
			$nursingServices[$tariffDays['Patient']['id']] = $this->getServiceCharges($tariffDays['Patient']['id'],$tariffDays['Patient']['tariff_standard_id']);
			$pharmacyChargeDetails[$tariffDays['Patient']['id']]= $this->getPharmacyFinalCharges($tariffDays['Patient']['id']);//for total pharmacy charge
			
		}
		
		foreach($nursingServices as $nursingServicesKey=>$nursingServicesCost){
			foreach($nursingServicesCost as $nursingServicesCost){
				$nursingCnt = $nursingServicesCost['TariffList']['id'] ;
				$resetNursingServices[$nursingServicesKey][$nursingCnt]['qty'] = $resetNursingServices[$nursingServicesKey][$nursingCnt]['qty']+$nursingServicesCost['ServiceBill']['no_of_times'];
				$resetNursingServices[$nursingServicesKey][$nursingCnt]['name'] = $nursingServicesCost['TariffList']['name'] ;
				//adding service bill amount to avoid different charges of same service eg:( x service = 500 , again x service = 600 then we have to add those charges ie 500+600) 
				$resetNursingServices[$nursingServicesKey][$nursingCnt]['cost'] = $resetNursingServices[$nursingServicesKey][$nursingCnt]['cost']+($nursingServicesCost['ServiceBill']['amount']*$nursingServicesCost['ServiceBill']['no_of_times']);
				$resetNursingServices[$nursingServicesKey][$nursingCnt]['moa_sr_no'] = $nursingServicesCost['TariffAmount']['moa_sr_no'];
				$resetNursingServices[$nursingServicesKey][$nursingCnt]['nabh_non_nabh'] = $nursingServicesCost['TariffList']['cghs_code'];
				//	$nursingCnt++;
			}
		}
			//debug($resetNursingServices);exit;
		$this->set('servicesData',$resetNursingServices);
		//debug($wardServicesDataNew);
		foreach($wardServicesDataNew as $key=>$wardCharges){
			foreach($wardCharges as $ward){
				foreach($ward as $charge){
					foreach($charge as $charge){
						$patientWardCharges[$key]=$patientWardCharges[$key]+$charge['cost'];
					}

				}
			}
		}
		$this->set(array('doctorCharges'=>$doctorCharges,'nursingCharges'=>$nursingCharges,'patientWardCharges'=>$patientWardCharges));
		//pr($servicesData);
		$this->set('results',$result);
// 		pr($results) ;exit;
		$this->loadModel('RadiologyTestOrder')	;
		$this->loadModel('LaboratoryTestOrder');
		$rad = $this->RadiologyTestOrder->radDetails($patientID); //array of patient ids
		$this->set('rad',$rad);
		$lab = $this->LaboratoryTestOrder->labDetails($patientID);
		$this->set('lab',$lab);


		//Pharmacy Data
		//Pharmacy charges will be added to billing only if the Pharmacy Service is set to IPD
		$this->loadModel('Configuration');
		/*$pharmacy_service_type=$this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'Pharmacy')));
		 $pharmacy_service_type=unserialize($pharmacy_service_type['Configuration']['value']);*/

		$this->loadModel('ServiceCategory');
		$pharmacyCategoryId=$this->ServiceCategory->getPharmacyId();
		
		$pharmacy_service_type=$this->Configuration->getPharmacyServiceType();
		$this->set('pharmacy_service_type',$pharmacy_service_type['addChargesInInvoice']);		
		//if(strtolower($pharmacy_service_type['addChargesInInvoice'])=='yes')
		$this->set('pharmacy_charges',$pharmacyChargeDetails);

		// consultant charges
		$this->loadModel('ConsultantBilling');
		$getconsultantData = $this->ConsultantBilling->find('all',array('conditions' =>array('ConsultantBilling.patient_id'=>$patientID)));
		$this->set('getconsultantData',$getconsultantData);

		/*$finaltotalPaid =$this->Billing->find('all',array('fields'=>array('Billing.patient_id','Billing.amount'),
				'conditions'=>array('Billing.patient_id'=>$patientID,'Billing.is_deleted'=>'0'),
		));*/
		
		// url flag to show pharmacy charges -- Pooja
		if($this->params->query['showPhar']){
			$pharmacy_service_type['addChargesInInvoice']='yes';
		}
		if($pharmacy_service_type['addChargesInInvoice']=='no'){
			$finaltotalPaid =$this->Billing->find('all',array('fields'=>array('Billing.patient_id','Billing.amount','Billing.discount'),
					'conditions'=>array('Billing.patient_id'=>$patientID,'Billing.is_deleted'=>'0','Billing.payment_category !='=>$pharmacyCategoryId),
			));	
			
			$pharPaidAmt=$this->Billing->find('all',array('fields'=>array('Billing.patient_id','Billing.amount','Billing.discount'),
					'conditions'=>array('Billing.patient_id'=>$patientID,'Billing.is_deleted'=>'0','Billing.payment_category'=>$pharmacyCategoryId),
			));	
			
			/*$totalDiscountGiven =$this->Billing->find('all',array('fields'=>array('Billing.patient_id','Billing.discount','Billing.payment_category' ),
					'conditions'=>array('Billing.patient_id'=>$patientID,'Billing.is_deleted'=>'0','Billing.payment_category !='=>$pharmacyCategoryId)));*/
			
		}else{
			$finaltotalPaid =$this->Billing->find('all',array('fields'=>array('Billing.patient_id','Billing.amount','Billing.discount'),
					'conditions'=>array('Billing.patient_id'=>$patientID,'Billing.is_deleted'=>'0')));

			$pharPaidAmt=$this->Billing->find('all',array('fields'=>array('Billing.patient_id','Billing.amount','Billing.discount'),
					'conditions'=>array('Billing.patient_id'=>$patientID,'Billing.is_deleted'=>'0','Billing.payment_category'=>$pharmacyCategoryId),
			));
			/*$totalDiscountGiven =$this->Billing->find('all',array('fields'=>array('Billing.patient_id','Billing.discount','Billing.payment_category' ),
					'conditions'=>array('Billing.patient_id'=>$patientID,'Billing.is_deleted'=>'0')));*/
		}		
		
		foreach($finaltotalPaid as $allPaid){
			$finalPaid[$allPaid['Billing']['patient_id']]=$finalPaid[$allPaid['Billing']['patient_id']]+$allPaid['Billing']['amount'];
			$totalDiscount[$allPaid['Billing']['patient_id']]=$totalDiscount[$allPaid['Billing']['patient_id']]+$allPaid['Billing']['discount'];
		}
		foreach($pharPaidAmt as $Paid){
			$pharPaid[$Paid['Billing']['patient_id']]=$pharPaid[$Paid['Billing']['patient_id']]+($Paid['Billing']['amount']-$Paid['Billing']['discount']);
		}
		/*foreach($totalDiscountGiven as $discount){
			$totalDiscount[$discount['Billing']['patient_id']]=$totalDiscount[$discount['Billing']['patient_id']]+$discount['Billing']['discount'];			
		}*/
		
		$this->set('totalDiscount',$totalDiscount);		
		$this->set('finaltotalPaid',$finalPaid);
		$this->set('pharPaid',$pharPaid);
// 		debug($surgeriesData);exit;
		
		//for refunded amount
		$this->loadModel('FinalBilling');
		$discountData =$this->FinalBilling->find('first',array('conditions'=>array('FinalBilling.patient_id'=>$id)));
		$this->set('discountData',$discountData);
		//EOF of refunded amount
		
		//for discounted amount
		// url flag to show pharmacy charges -- Pooja
		if($this->params->query['showPhar']){
			$pharmConfig['addChargesInInvoice']='yes';
		}
		if($pharmConfig['addChargesInInvoice']=='no'){
			$totalDiscountGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.discount) AS sumDiscount','Billing.payment_category' ),
					'conditions'=>array('Billing.patient_id'=>$id,'Billing.is_deleted'=>'0','Billing.payment_category !='=>$pharmacyCategoryId)));
			$this->set('totalDiscountGiven',$totalDiscountGiven);
		
		}else{
			$totalDiscountGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.discount) AS sumDiscount','Billing.payment_category' ),
					'conditions'=>array('Billing.patient_id'=>$id,'Billing.is_deleted'=>'0')));
			$this->set('totalDiscountGiven',$totalDiscountGiven);
		}
		
		//***code for discount to be shown in invoice***//
		
		//EOF discounted amount
		
		//****for refund amount in invoice****/yashwant/
		
		$totalRefundGiven =$this->Billing->find('first',array('fields'=>array('sum(Billing.paid_to_patient) AS sumRefund',
				'Billing.payment_category' ),'conditions'=>array('Billing.patient_id'=>$id,'Billing.is_deleted'=>'0','Billing.refund'=>'1')));
		$this->set('totalRefundGiven',$totalRefundGiven);
		

		$this->loadModel('Bed');
		$this->Bed->bindModel(array(
				'belongsTo' => array(
						'Room'=>array('foreignKey'=>'room_id','type'=>'inner'),
						'Ward'=>array('foreignKey'=>false,
								'conditions'=>array('Ward.id=Room.ward_id'),'type'=>'inner')
				),
				'hasMany'=>array('WardPatient'=>array('order'=>'WardPatient.id Desc','Limit'=>1,'WardPatient.is_deleted=0')),false));
		$data = $this->Bed->find('all',array('conditions'=>array('Ward.is_deleted'=>0,'Ward.location_id'=>$this->Session->read('locationid')),'order'=>array('Ward.id','Bed.id')));
		$this->set('data',$data);
		
			if(isset($this->request->query['format']) && $this->request->query['format'] == 'generate_excel'){
				$this->layout = false ;
				foreach($patientID as $patient_id){
					$diffArray[$patient_id]=$this->diffAmountDetails($patient_id);
				}
				$this->set('setDiff',$diffArray);
				$this->render('doctors_handover_xls',false);
			} 
			
			$rgjayOnToday = $this->TariffStandard->getTariffStandardID('rgjay_private_as_on_today');
			$rgjayID = $this->TariffStandard->getTariffStandardID('rgjay');

			$covidPackageBill = $this->PatientCovidPackage->getTotalCovidPackageBill($patientID);
			
			$this->set(array('rgjayOnToday'=>$rgjayOnToday,'rgjayID'=>$rgjayID,'covidPackageBill'=>$covidPackageBill));
			
			
	}


//  $PatientId = $this->request->data['Patient']['id'];

    
	
}