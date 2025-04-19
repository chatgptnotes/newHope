<?php
/**
 * Estimates Controller
 *
 * PHP 5
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Estimates
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
class EstimatesController extends AppController {

	public $name = 'Estimates';

	public $helpers = array('DateFormat','RupeesToWords','Number','General');

	public $components = array('General','DateFormat','Number','GibberishAES');

	public function index(){

		if(!empty($this->params->query['first_name']) && empty($this->params->query['last_name'])){
			$conditions['EstimatePatient.first_name like'] = trim($this->params->query['first_name']).'%';
			$conditions['EstimatePatient.location_id'] = $this->Session->read('locationid');
		}else if(empty($this->params->query['first_name']) && !empty($this->params->query['last_name'])){
			$conditions['EstimatePatient.last_name like'] = trim($this->params->query['last_name']).'%';
			$conditions['EstimatePatient.location_id'] = $this->Session->read('locationid');
		}else if(!empty($this->params->query['first_name']) && !empty($this->params->query['last_name'])){
			$conditions['EstimatePatient.first_name like'] = trim($this->params->query['first_name']).'%';
			$conditions['EstimatePatient.last_name like'] = trim($this->params->query['last_name']).'%';
			$conditions['EstimatePatient.location_id'] = $this->Session->read('locationid');
		}else{
			$conditions['EstimatePatient.location_id'] = $this->Session->read('locationid');
		}


		$this->uses = array('EstimatePatient');
		$this->EstimatePatient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array('foreignKey' => 'initial_id'),

				)),false);
		$this->paginate = array(
				'fields'=>array('EstimatePatient.*', 'Initial.name'),
				'limit' => Configure::read('number_of_rows'),
				'order' => array('EstimatePatient.create_time' => 'DESC'),
				'conditions'=>array($conditions)
		);
		$patients = $this->paginate('EstimatePatient');
		$this->set('data',$patients);
		#echo '<pre>';print_r($patients);exit;
	}

	public function add(){
		$this->uses = array('TariffStandard','Initial','EstimatePatient');
		if(!empty($this->request->data)){
			$this->request->data['Person']['location_id']=$this->Session->read('locationid');
			$this->request->data['Person']['dob']=$this->DateFormat->formatDate2STD($this->request->data['Person']['dob'],Configure::read('date_format'));
			$this->request->data['Person']['created_by']= $this->Session->read('userid');
			$this->request->data['Person']['create_time']= date("Y-m-d H:i:s");

			$dumpArr  = $this->request->data['Person'] ;

			$this->EstimatePatient->save($dumpArr);

			$errors = $this->EstimatePatient->invalidFields();

			if($errors){
				$this->set("errors", $errors);
			}else{
				$this->Session->setFlash(__('Record added successfully', true),'default');
				$this->redirect(array("controller" => "estimates", "action" => "estimateTypes",$this->EstimatePatient->id));
			}
		}
		$tariffStandard = $this->TariffStandard->find('list',array('conditions'=>array('is_deleted'=>0,'TariffStandard.location_id'=>$this->Session->read('locationid'))));
		$this->set('tariffStandard',$tariffStandard);
		$this->set('initials',$this->Initial->find('list',array('fields'=>array('name'))));

	}
	public function edit($id=null){
		if($id==null){
			$this->Session->setFlash(__('Invalid Id'),'default',array('class'=>'error'));
			$this->redirect(array("controller" => "estimates", "action" => "index"));
		}
		$this->uses = array('TariffStandard','Initial','EstimatePatient');
		if(!empty($this->request->data)){
			$this->request->data['EstimatePatient']['dob']=$this->DateFormat->formatDate2STD($this->request->data['EstimatePatient']['dob'],Configure::read('date_format'));
			$this->request->data['EstimatePatient']['modified_by']= $this->Session->read('userid');
			$this->request->data['EstimatePatient']['modify_time']= date("Y-m-d H:i:s");
			$this->EstimatePatient->id = $id;
			$this->EstimatePatient->save($this->request->data['EstimatePatient']);
			$this->Session->setFlash(__('Information has been saved.'),'default',array('class'=>'message'));
			$this->redirect(array("controller" => "estimates", "action" => "estimateTypes",$id));
		}
		$tariffStandard = $this->TariffStandard->find('list',array('conditions'=>array('is_deleted'=>0,'TariffStandard.location_id'=>$this->Session->read('locationid'))));
		$this->set('tariffStandard',$tariffStandard);
		$this->set('initials',$this->Initial->find('list',array('fields'=>array('name'))));
		$patientData = $this->EstimatePatient->read(null,$id);
		$patientData['EstimatePatient']['dob'] = $this->DateFormat->formatDate2Local($patientData['EstimatePatient']['dob'],Configure::read('date_format'),false);
		$this->request->data  = $patientData;

	}
	public function estimateTypes($id=null,$viewSection=''){
			
		$this->uses = array('EstimatePatient','ServiceCategory','EstimateConsultantBilling','Consultant','DoctorProfile');
		$this->EstimatePatient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'TariffStandard' =>array( 'foreignKey'=>'tariff_standard_id'),
				)));

		$patientData = $this->EstimatePatient->read(null,$id);
		$this->set('patientData',$patientData);

		$formatted_address = $this->setAddressFormat($patientData['EstimatePatient']);
		$this->set('formatted_address',$formatted_address);


		$searchServiceName='';
		if(isset($this->request->data) && isset($this->request->data) && $this->request->data['service_name']!=''){
			$searchServiceName = $this->request->data['service_name'];
		}

		if(isset($this->params->query['serviceDate']) && $this->params->query['serviceDate'] && !empty($this->params->query['serviceDate'])){
			$serviceDate = $this->DateFormat->formatDate2STDForReport($this->params->query['serviceDate'],Configure::read('date_format'));
		}else{
			$serviceDate = date('Y-m-d');

		}
		$this->set('serviceDate',$this->DateFormat->formatDate2Local($serviceDate,Configure::read('date_format')));
			
		$this->getServices($id,$patientData['TariffStandard']['id'],$searchServiceName,$serviceDate);
			
		$this->getOtherServices($id);
			
		$this->loadModel('ServiceCategory');
		$service_group = $this->ServiceCategory->find("all",array("conditions"=>
				array("ServiceCategory.is_deleted"=>0,
						"ServiceCategory.is_view"=>1,
						"(ServiceCategory.location_id=".$this->Session->read('locationid')." OR ServiceCategory.location_id=0)"
				)
		));
		$this->set("service_group",$service_group);
			
		/** Consultant Billing Start*/
		$this->loadModel('EstimateConsultantBilling');
		$this->EstimateConsultantBilling->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array('foreignKey'=>'consultant_service_id'),
						"ServiceCategory"=>array('foreignKey'=>'service_category_id'),
						"ServiceSubCategory"=>array('foreignKey'=>'service_sub_category_id')
				)));
		$consultantBillingData = $this->EstimateConsultantBilling->find('all',array('conditions' =>array('patient_id'=>$id)));//,'date'=>date('Y-m-d')
		$this->set('consultantBillingData',$consultantBillingData);

		$this->loadModel('DoctorProfile');
		$this->loadModel('Consultant');
		$allConsultantsList = $this->Consultant->getConsultantWithDeleted();
		$allDoctorsList = $this->DoctorProfile->find('list', array('conditions' => array('DoctorProfile.location_id' => $this->Session->read('locationid')), 'fields' => array('DoctorProfile.id', 'DoctorProfile.doctor_name')));
		$this->set(array('allDoctorsList'=>$allDoctorsList,'allConsultantsList'=>$allConsultantsList));
		/** Consultant Billing End*/

		/** Laboratory Billing Start*/
		$this->lab_order($id);
		$labServices = $this->labDetails($id);
		$this->set('lab',$labServices);
		/** Laboratory Billing End*/


		/** Radiology Billing Start*/
		$this->radiology_order($id);
		$radServices = $this->radDetails($id);
		$this->set('rad',$radServices);
		#echo '<pre>';print_r($labServices);exit;
		/** Radiology Billing End*/
			
			

		if($searchServiceName==''){
			$this->set('viewSection',$viewSection);
		}else{
			$this->set('viewSection','servicesSection');
		}
	}


	public function generateEstimateInvoice($id){
		$this->uses = array('EstimatePatient');
		$this->EstimatePatient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'TariffStandard' =>array( 'foreignKey'=>'tariff_standard_id'),
				)));
		$patientData = $this->EstimatePatient->read(null,$id);
		$this->set('patientData',$patientData);

		// get services
		$nursingServices = $this->getServiceCharges($id,$patientData['EstimatePatient']['tariff_standard_id']);
		$this->set('nursingServices',$nursingServices);

		// get Cosnultant Charges
		$this->getConsultantCharges($id);

		// calculate lab charges
		$this->calculateLabCharges($id);

		// calculate Radiology charges
		$this->calculateRadCharges($id);

		//get other service charges
		$this->getOtherServicesCharges($id);
	}

	public function printEstimateInvoice($id){
		$this->layout = 'print';
		$this->uses = array('EstimatePatient');
		$this->EstimatePatient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'TariffStandard' =>array( 'foreignKey'=>'tariff_standard_id'),
				)));
		$patientData = $this->EstimatePatient->read(null,$id);
		$this->set('patientData',$patientData);

		// get services
		$nursingServices = $this->getServiceCharges($id,$patientData['EstimatePatient']['tariff_standard_id']);
		$this->set('nursingServices',$nursingServices);

		// get Cosnultant Charges
		$this->getConsultantCharges($id);

		// calculate lab charges
		$this->calculateLabCharges($id);

		// calculate Radiology charges
		$this->calculateRadCharges($id);

		//get other service charges
		$this->getOtherServicesCharges($id);
	}

	public function getOtherServicesCharges($id){
		$this->loadModel('EstimateOtherService');
		$otherServicesData = $this->EstimateOtherService->find('all',array('conditions'=>array('EstimateOtherService.is_deleted'=>0,'EstimateOtherService.patient_id'=>$id,'location_id'=>$this->Session->read('locationid'))));
		$this->set('otherServicesData',$otherServicesData);
	}


	public function calculateRadCharges($id){
		$hospitalType = $this->Session->read('hospitaltype');
		if($hospitalType == 'NABH'){
			$rateType = 'nabh_rate';
		}else{
			$rateType = 'non_nabh_rate';
		}
		$radServices = $this->radDetails($id);
		#echo'<pre>';print_r($radServices);exit;
		$totalRadCharges=0;
		foreach($radServices as $rad){
			$totalRadCharges = $totalRadCharges + $rad['CorporateLabRate'][$rateType];
		}
		$this->set('radCharges',$totalRadCharges);
	}

	public function calculateLabCharges($id){
		$hospitalType = $this->Session->read('hospitaltype');
		if($hospitalType == 'NABH'){
			$rateType = 'nabh_rate';
		}else{
			$rateType = 'non_nabh_rate';
		}
		$labServices = $this->labDetails($id);

		$totalLabCharges=0;
		foreach($labServices as $lab){
			$totalLabCharges = $totalLabCharges + $lab['CorporateLabRate'][$rateType];
		}
		$this->set('labCharges',$totalLabCharges);
	}

	public function getConsultantCharges($id){
		$this->uses = array('EstimateConsultantBilling');
		$this->EstimateConsultantBilling->bindModel(array(
				'belongsTo' => array( 	'TariffList' =>array('foreignKey'=>'consultant_service_id'),
						'DoctorProfile' =>array('foreignKey' => 'doctor_id'),
						'Consultant' =>array('foreignKey' => 'consultant_id'),
						'ServiceCategory'=>array('foreignKey' => 'service_category_id')
				)),false);

		$tempConDData = $this->EstimateConsultantBilling->find('all',array('fields'=>array('TariffList.*,ServiceCategory.*,EstimateConsultantBilling.*,DoctorProfile.*'),'conditions'=>array('EstimateConsultantBilling.consultant_id'=>NULL,'EstimateConsultantBilling.patient_id'=>$id),'order'=>array('EstimateConsultantBilling.date')));
			
		$tempConCData = $this->EstimateConsultantBilling->find('all',array('fields'=>array('TariffList.*,ServiceCategory.*,EstimateConsultantBilling.*,Consultant.*'),'conditions'=>array('EstimateConsultantBilling.doctor_id'=>NULL,'EstimateConsultantBilling.patient_id'=>$id),'order'=>array('EstimateConsultantBilling.date')));

		$cDArray=array();
		$cCArray=array();

		foreach($tempConDData as $tCD){
			$tCD['EstimateConsultantBilling']['amount'] = $this->Number->format($tCD['EstimateConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
			$cDArray[$tCD['EstimateConsultantBilling']['consultant_service_id']][$tCD['EstimateConsultantBilling']['doctor_id']][$tCD['EstimateConsultantBilling']['amount']][]=$tCD;

		}
			
		foreach($tempConCData as $tCD){
			$tCD['EstimateConsultantBilling']['amount'] = $this->Number->format($tCD['EstimateConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
			$cCArray[$tCD['EstimateConsultantBilling']['consultant_service_id']][$tCD['EstimateConsultantBilling']['consultant_id']][$tCD['EstimateConsultantBilling']['amount']][]=$tCD;

		}
		#echo '<pre>';print_r($cDArray);exit;
		$this->set('cCArray',$cCArray);
		$this->set('cDArray',$cDArray);

	}

	public function getServiceCharges($patient_id=null,$tariffStandardId=null){
		$this->loadModel('EstimateServiceBill');
		$this->EstimateServiceBill->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array( 'foreignKey'=>false,'type'=>'left','conditions'=>array('EstimateServiceBill.tariff_list_id=TariffList.id')),
						'TariffAmount' =>array('foreignKey' => false,'conditions'=>array('TariffAmount.tariff_list_id=TariffList.id','TariffAmount.tariff_standard_id='.$tariffStandardId))
				)),false);

		$nursingServices = $this->EstimateServiceBill->find('all',array('group'=>array('EstimateServiceBill.id'),'fields'=>array(
				'EstimateServiceBill.*','TariffAmount.*','TariffList.*'),'conditions'=>array('EstimateServiceBill.patient_id'=>$patient_id,
						'EstimateServiceBill.location_id'=>$this->Session->read('locationid')),'order'=>'EstimateServiceBill.Date'));
		return $nursingServices;

	}

	/**
	 *
	 * @param $patient_id
	 * @return function to insert test assign to patient
	 */
	function radiology_test_order($patient_id=null){
		#echo'<pre>';print_r($this->request->data);exit;
		if(!empty($patient_id) && isset($this->request->data) && !empty($this->request->data) ){
			$this->uses = array('EstimateRadiologyTestOrder');
			$session = new cakeSession();
			$data = $this->request->data;
			if(is_array($data['RadiologyTestOrder']['radiology_id'])){
				foreach($data['RadiologyTestOrder']['radiology_id'] as $labID){

					if(empty($data['RadiologyTestOrder']['id'])){
						$orderArr['created_by'] = $session->read('userid');
						$orderArr['create_time'] = date("Y-m-d H:i:s");
					}else{
						$this->id = $data['RadiologyTestOrder']['id'] ;
						$orderArr['modified_by'] = $session->read('userid');
						$orderArr['modify_time'] = date("Y-m-d H:i:s");
					}
					$orderArr['patient_id'] = $data['RadiologyTestOrder']['patient_id'];
					$orderArr['radiology_id'] = $labID;

					$result =  $this->EstimateRadiologyTestOrder->save($orderArr);
					$this->EstimateRadiologyTestOrder->id  ='';
				}
			}
			$this->redirect(array("controller" => "estimates", "action" => "estimateTypes",$this->request->data['RadiologyTestOrder']['patient_id'],'radiologySection'));
		}

	}

	function radiology_order($patient_id=null){
		$this->uses = array('Radiology','Person','Patient','Consultant','User','EstimateRadiologyTestOrder');
		//lab tests
		$dept  =  isset($this->params->query['dept'])? $this->params->query['dept']:'';
		$testDetails = $this->EstimateRadiologyTestOrder->find('count',array('conditions'=>array('patient_id'=>$patient_id)));

		if($testDetails){

			//BOF new code
			$testArray = $testDetails['EstimateRadiologyTestOrder']['radiology_id'];
			$this->EstimateRadiologyTestOrder->bindModel(array(
					'belongsTo' => array(
							'Radiology'=>array('foreignKey'=>'radiology_id','conditions'=>array('Radiology.is_active'=>1) ),
					),
			),false);

			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'fields'=>array('EstimateRadiologyTestOrder.id','EstimateRadiologyTestOrder.create_time','EstimateRadiologyTestOrder.order_id','Radiology.id','Radiology.name'),
					'conditions'=>array('EstimateRadiologyTestOrder.patient_id'=>$patient_id),
					'order' => array(
							'EstimateRadiologyTestOrder.id' => 'asc'
					),
					'group'=>array('EstimateRadiologyTestOrder.order_id')
			);
			$testOrdered   = $this->paginate('EstimateRadiologyTestOrder');

			$TestOrderedlabId = implode(',',$this->EstimateRadiologyTestOrder->find('list',array('fields'=>array('radiology_id'),'conditions'=>array('EstimateRadiologyTestOrder.patient_id'=>$patient_id))));

			$labTest  = $this->Radiology->find('list',array('fields'=>array('Radiology.id','Radiology.name'),'conditions'=>array('is_active'=>1,'location_id'=>$this->Session->read('locationid'))));


			//EOD new code
		}else{
			$labTest  = $this->Radiology->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_active'=>1)));
			$testOrdered ='';
		}
		$this->set(array('rad_test_data'=>$labTest,'rad_test_ordered'=>$testOrdered));
		return array('rad_test_data'=>$labTest,'test_ordered'=>$testOrdered);
	}


	function radDetails($patient_id=null){
		$this->uses =array('EstimateRadiologyTestOrder');
		$this->EstimateRadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						/*'LaboratoryTestOrder' =>array('foreignKey' => false,'conditions'=>array('Patient.id'=>'LaboratoryTestOrder.patient_id')),*/
						'Radiology'=>array('foreignKey'=>'radiology_id','conditions'=>array('Radiology.is_active'=>1) ),
						'EstimatePatient'=>array('foreignKey'=>'patient_id'),
						'CorporateLabRate'=>array('foreignKey' => false,'conditions'=>
								array('CorporateLabRate.laboratory_id=EstimateRadiologyTestOrder.radiology_id',
										'CorporateLabRate.tariff_standard_id=EstimatePatient.tariff_standard_id','CorporateLabRate.department="radiology"'))
				)),false);
			
		$radTestOrderData= $this->EstimateRadiologyTestOrder->find('all',array(
				'fields'=> array('Radiology.name,EstimateRadiologyTestOrder.id,EstimateRadiologyTestOrder.patient_id,EstimateRadiologyTestOrder.create_time,EstimateRadiologyTestOrder.test_done,CorporateLabRate.nabh_rate,CorporateLabRate.non_nabh_rate'),
				'conditions'=>array('EstimateRadiologyTestOrder.patient_id'=>$patient_id,'Radiology.location_id'=>$this->Session->read('locationid'))));
			
		return $radTestOrderData ;
	}


	function labDetails($patient_id=null){
		$this->uses=array('EstimateLaboratoryTestOrder');
		$this->EstimateLaboratoryTestOrder->bindModel(array(
				'belongsTo' => array(
						'Laboratory'=>array('foreignKey'=>'laboratory_id','conditions'=>array('Laboratory.is_active'=>1) ),
						'EstimatePatient'=>array('foreignKey'=>'patient_id'),
						'CorporateLabRate'=>array('foreignKey' => false,'conditions'=>
								array('CorporateLabRate.laboratory_id=EstimateLaboratoryTestOrder.laboratory_id',
										'CorporateLabRate.tariff_standard_id=EstimatePatient.tariff_standard_id','CorporateLabRate.department="lab"'))
				)),false);
		$laboratoryTestOrderData= $this->EstimateLaboratoryTestOrder->find('all',array(
				'fields'=> array('Laboratory.name,EstimateLaboratoryTestOrder.id,EstimateLaboratoryTestOrder.patient_id,EstimateLaboratoryTestOrder.create_time,CorporateLabRate.nabh_rate,CorporateLabRate.non_nabh_rate'),
				'conditions'=>array('EstimateLaboratoryTestOrder.patient_id'=>$patient_id,'Laboratory.location_id'=>$this->Session->read('locationid'))));

		return $laboratoryTestOrderData ;
	}

	public function deleteLabTest($testId,$patientId){#echo $testId.'-'.$patientId;exit;
		$this->loadModel('EstimateLaboratoryTestOrder');
		$this->EstimateLaboratoryTestOrder->delete($testId);
		$this->redirect(array("controller" => "estimates", "action" => "estimateTypes",$patientId,'pathologySection'));
	}


	public function deleteRadTest($testId,$patientId){
		$this->loadModel('EstimateRadiologyTestOrder');
		$this->EstimateRadiologyTestOrder->delete($testId);
		$this->redirect(array("controller" => "estimates", "action" => "estimateTypes",$patientId,'radiologySection'));
	}

	/**
	 * Funtion for lab order
	 * @param $patient_id :patient id
	 * @return unknown_type
	 */
	function lab_order($patient_id=null){

		$this->uses = array('Laboratory','Person','Patient','Consultant','User','EstimateLaboratoryTestOrder','LaboratoryResult','EstimateRadiologyTestOrder','Radiology');
		if(!empty($patient_id)){
			$this->patient_info($patient_id); //patient details
			//BOF referer link
			$sessionReturnString = $this->Session->read('labReturn') ;
			$currentReturnString = $this->params->query['return'] ;
			if(($currentReturnString!='') && ($currentReturnString != $sessionReturnString) ){
				$this->Session->write('labReturn',$currentReturnString);
			}
			//EOF referer link
			//lab tests
			$dept  =  !empty($this->params->query['dept'])? $this->params->query['dept']:'';
			if($dept=='radiology'){
				//$this->set($this->requestAction('radiologies/radiology_order/'.$patient_id));
				//BOF code from radiology controller
				$dept  =  isset($this->params->query['dept'])? $this->params->query['dept']:'';
				$testDetails = $this->EstimateRadiologyTestOrder->find('count',array('conditions'=>array('patient_id'=>$patient_id)));

				if($testDetails){
					//BOF new code
					$testArray = $testDetails['EstimateRadiologyTestOrder']['radiology_id'];
					$this->EstimateRadiologyTestOrder->bindModel(array(
							'belongsTo' => array(
									'Radiology'=>array('foreignKey'=>'radiology_id','conditions'=>array('Radiology.is_active'=>1) ),
							),
							'hasOne' => array(
									'RadiologyResult'=>array('foreignKey'=>'radiology_test_order_id')
							)),false);

					$this->paginate = array(
							'limit' => Configure::read('number_of_rows'),
							'fields'=>array('RadiologyResult.confirm_result','EstimateRadiologyTestOrder.id','EstimateRadiologyTestOrder.create_time','EstimateRadiologyTestOrder.order_id','Radiology.id','Radiology.name'),
							'conditions'=>array('EstimateRadiologyTestOrder.patient_id'=>$patient_id),
							'order' => array(
									'EstimateRadiologyTestOrder.id' => 'asc'
							),
							'group'=>array('EstimateRadiologyTestOrder.order_id')
					);
					$testOrdered   = $this->paginate('EstimateRadiologyTestOrder');

					$TestOrderedlabId = implode(',',$this->EstimateRadiologyTestOrder->find('list',array('fields'=>array('radiology_id'),'conditions'=>array('EstimateRadiologyTestOrder.patient_id'=>$patient_id))));

					$labTest  = $this->Radiology->find('list',array('fields'=>array('Radiology.id','Radiology.name'),'conditions'=>array('is_active'=>1,'Radiology.location_id'=>$this->Session->read('locationid'))));


					//EOD new code
				}else{
					$labTest  = $this->Radiology->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_active'=>1,'Radiology.location_id'=>$this->Session->read('locationid'))));
					$testOrdered ='';
				}
				$this->set(array('test_data'=>$labTest,'test_ordered'=>$testOrdered));
				//EOF code form radiology controller
			}else if($dept=='radiology'){
				$this->set($this->requestAction('histologies/histology_order/'.$patient_id));
			}else{
				$testDetails = $this->EstimateLaboratoryTestOrder->find('count',array('conditions'=>array('patient_id'=>$patient_id)));

				if($testDetails){

					$testArray = $testDetails['EstimateLaboratoryTestOrder']['laboratory_id'];
					$this->EstimateLaboratoryTestOrder->bindModel(array(
							'belongsTo' => array(
									'Laboratory'=>array('foreignKey'=>'laboratory_id','conditions'=>array('Laboratory.is_active'=>1,'Laboratory.location_id'=>$this->Session->read('locationid')))
							),
							'hasOne' => array(
									'LaboratoryResult'=>array('foreignKey'=>'laboratory_test_order_id')
							)),false);
					/*$testOrdered = $this->LaboratoryTestOrder->find('list',array('fields'=>array('Laboratory.id','Laboratory.name'),'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patient_id),"recursive" => 1 ));*/

					$this->paginate = array(
							'limit' => Configure::read('number_of_rows'),
							'fields'=>array('LaboratoryResult.confirm_result','EstimateLaboratoryTestOrder.id','EstimateLaboratoryTestOrder.create_time','EstimateLaboratoryTestOrder.order_id','Laboratory.id','Laboratory.name'),
							'conditions'=>array('EstimateLaboratoryTestOrder.patient_id'=>$patient_id),
							'order' => array(
									'EstimateLaboratoryTestOrder.id' => 'asc'
							),
							'group'=>array('EstimateLaboratoryTestOrder.order_id')
					);
					$testOrdered   = $this->paginate('EstimateLaboratoryTestOrder');

					$TestOrderedlabId = implode(',',$this->EstimateLaboratoryTestOrder->find('list',array('fields'=>array('laboratory_id'),'conditions'=>array('EstimateLaboratoryTestOrder.patient_id'=>$patient_id))));

					$labTest  = $this->Laboratory->find('list',array('fields'=>array('Laboratory.id','Laboratory.name'),'conditions'=>array('is_active'=>1,'Laboratory.location_id'=>$this->Session->read('locationid'))));


					/*$labTest  = $this->Laboratory->find('list',array('fields'=>array('Laboratory.id','Laboratory.name'),'conditions'=>array("id not in ($TestOrderedlabId)",'is_active'=>1))); 		*/

				}else{
					$labTest  = $this->Laboratory->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_active'=>1,'Laboratory.location_id'=>$this->Session->read('locationid'))));
					$testOrdered ='';
				}
				$this->set(array('test_data'=>$labTest,'test_ordered'=>$testOrdered));
			}

		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}

	}

	public function lab_test_order($patientId){

		$this->uses = array('EstimateLaboratoryTestOrder');
		$data = $this->request->data;
		$session = new cakeSession();
		foreach($data['LaboratoryTestOrder']['laboratory_id'] as $labID){

			if(empty($data['LaboratoryTestOrder']['id'])){
				$orderArr['created_by'] = $session->read('userid');
				$orderArr['create_time'] = date("Y-m-d H:i:s");
			}else{
				$this->id = $data['LaboratoryTestOrder']['id'] ;
				$orderArr['modified_by'] = $session->read('userid');
				$orderArr['modify_time'] = date("Y-m-d H:i:s");
			}
			$orderArr['patient_id'] = $data['LaboratoryTestOrder']['patient_id'];
			$orderArr['laboratory_id'] = $labID;

			$result =  $this->EstimateLaboratoryTestOrder->save($orderArr);
			$this->EstimateLaboratoryTestOrder->id  ='';

		}
		$this->redirect(array("controller" => "estimates", "action" => "estimateTypes",$this->request->data['LaboratoryTestOrder']['patient_id'],'pathologySection'));
	}


	function consultantBilling(){
		$this->uses = array('EstimateConsultantBilling');
		$this->request->data['EstimateConsultantBilling']['created_by']= $this->Session->read('userid');
		$this->request->data['EstimateConsultantBilling']['create_time']= date("Y-m-d H:i:s");
		#$date = strtotime($this->request->data['ConsultantBilling']['date']);
		//$splitFrom = explode(" ",$this->request->data['ConsultantBilling']['date']);
		if(!empty($this->request->data['EstimateConsultantBilling']['date'])){
			$splitDate = explode(" ",$this->request->data['EstimateConsultantBilling']['date']);
			$this->request->data['EstimateConsultantBilling']['date'] = $this->DateFormat->formatDate2STD($this->request->data['EstimateConsultantBilling']['date'],Configure::read('date_format'));
		}
		//$this->request->data['ConsultantBilling']['date']= date("Y-m-d H:i:s");

		if($this->request->data['EstimateConsultantBilling']['category_id']==0){
			$this->request->data['EstimateConsultantBilling']['consultant_id']=$this->request->data['EstimateConsultantBilling']['doctor_id'];
			$this->request->data['EstimateConsultantBilling']['doctor_id']='';
		}else if($this->request->data['EstimateConsultantBilling']['category_id']==1){
			$this->request->data['EstimateConsultantBilling']['consultant_id']='';
		}
			
		$this->EstimateConsultantBilling->save($this->request->data);
		$this->redirect(array("controller" => "estimates", "action" => "estimateTypes",$this->request->data['EstimateConsultantBilling']['patient_id'],'consultantSection'));
	}

	public function getOtherServices($id){

		if(!empty($id)) {
			$this->loadModel('EstimateOtherService');
			$otherServices = $this->EstimateOtherService->find('all',array('conditions'=>array('patient_id'=>$id)));
			$this->set('otherServices',$otherServices);
		}
	}

	public function getServices($patientId,$tariffStandardId,$searchServiceName='',$serviceDate=''){
		$this->uses = array('TariffList');

		$this->TariffList->bindModel(array(
				'belongsTo' => array(
						'TariffAmount' =>array('foreignKey' => false,'conditions'=>array('TariffAmount.tariff_list_id=TariffList.id','TariffAmount.tariff_standard_id'=>$tariffStandardId)),
						'EstimateServiceBill' =>array( 'foreignKey'=>false,'type'=>'left','conditions'=>array('EstimateServiceBill.patient_id'=>$patientId,
								'EstimateServiceBill.tariff_list_id=TariffList.id','EstimateServiceBill.date'=>$serviceDate)),
						'ServiceCategory'=>array( 'foreignKey'=>'service_category_id')
				)),false);
			
		/* if($searchServiceName==''){
		 $arr = array(

		 		'order' => array('TariffList.id' => 'asc'),
		 		'group'=>array('TariffList.id'),
		 		'conditions'=>array('TariffList.location_id'=>$this->Session->read('locationid'),'TariffList.is_deleted'=>0,'TariffAmount.tariff_standard_id'=>$tariffStandardId)
		 );
		$services = $this->TariffList->find('all',$arr);//'ServiceCategory.name'=>'Procedure',
		}*/
		if(!empty($searchServiceName)){
			$arr = array(

					'order' => array('TariffList.id' => 'asc'),
					'group'=>array('TariffList.id'),
					'conditions'=>array('TariffList.name like'=>$searchServiceName.'%',
							'TariffList.location_id'=>$this->Session->read('locationid'),'TariffList.is_deleted'=>0)
			);
			$services = $this->TariffList->find('all',	$arr);//'ServiceCategory.name'=>'Procedure',

		}

		//$services=$this->paginate('TariffList');
		#echo '<pre>';print_r($services);exit;
		$this->set('services',$services);
	}



	public function deleteServices($serviceId,$patientId){
		$this->loadModel('EstimateServiceBill');
		$this->EstimateServiceBill->delete($serviceId);
		$this->Session->setFlash(__('Record deleted successfully', true));
		$this->redirect(array("controller" => "estimates", "action" => "viewAllPatientServices",$patientId));
	}

	public function deleteOtherServices($serviceId,$patientId){
		$this->loadModel('EstimateOtherService');
		$this->EstimateOtherService->delete($serviceId);
		$this->Session->setFlash(__('Record deleted successfully', true));
		$this->redirect(array("controller" => "estimates", "action" => "estimateTypes",$patientId,'otherServicesSection'));
	}

	function saveOtherServices(){
		$this->uses = array('EstimateOtherService');
		$this->request->data['EstimateOtherService']['created_by']=$this->Session->read('userid');
		$this->request->data['EstimateOtherService']['location_id']=$this->Session->read('locationid');
		$this->request->data['EstimateOtherService']['create_time']=date("Y-m-d H:i:s");
		$this->request->data['EstimateOtherService']['service_date']=$this->DateFormat->formatDate2STD($this->request->data['EstimateOtherService']['service_date'],Configure::read('date_format'));
		$this->Session->setFlash(__('Record saved successfully', true));
		$this->EstimateOtherService->save($this->request->data['EstimateOtherService']);
		$this->redirect(array("controller" => "estimates", "action" => "estimateTypes",$this->request->data['EstimateOtherService']['patient_id'],'otherServicesSection'));
	}

	function servicesBilling(){
		$this->uses = array('EstimatePatient','EstimateServiceBill');
		if (!empty($this->request->data)) {
			$data = $this->request->data ;
			#echo '<pre>';print_r($data);exit;
			$patientId = $data['Estimates']['patient_id'];
			$this->EstimatePatient->bindModel(array(
					'belongsTo' => array(
							'Initial' =>array( 'foreignKey'=>'initial_id'),
					)));
			$patient_details  = $this->EstimatePatient->read(null,$patientId);

			$data["Estimates"]['date'] = $this->DateFormat->formatDate2STD($data["Estimates"]['date'],Configure::read('date_format'));
			$serviceData = array();

			$date = date("Y-m-d");
			$passedDate = explode(" ",$data["Estimates"]['date']);
			$oldData = $this->EstimateServiceBill->find('all',array('conditions'=>array('patient_id'=>$data['Estimates']['patient_id'],'date'=>$passedDate[0])));
			$tmpData = array();
			foreach($oldData as $oData){
				$tmpData[$oData['EstimateServiceBill']['tariff_list_id']]= $oData['EstimateServiceBill']['id'];
			}

			foreach($this->request->data['Nursing'] as $key=>$service){
				if(is_array($service)){
					$serviceData['tariff_list_id']=$key;
					$serviceData['tariff_standard_id']=$patient_details['EstimatePatient']['tariff_standard_id'];
					$serviceData['location_id']=$this->Session->read('locationid');
					$serviceData['morning']=$service['morning'];
					$serviceData['evening']=$service['evening'];
					$serviceData['night']=$service['night'];
					$serviceData['no_of_times']=$service['no_of_times'];
					$serviceData['patient_id']=$patientId;
					$serviceData['date']=$data["Estimates"]['date'];
					if($serviceData['morning']==1 || $serviceData['evening']==1 || $serviceData['night']==1){
						if(isset($tmpData[$key])){
							$this->EstimateServiceBill->delete($tmpData[$key]);
						}
						$this->EstimateServiceBill->save($serviceData);
						$this->EstimateServiceBill->id='';
					}
					$serviceData['morning']=$serviceData['evening']=$serviceData['night']=0;
				}
					
			}
			$this->Session->setFlash(__('Estimate Billing activity updated successfully', true));
			$this->redirect($this->referer());
		}
	}


	function viewAllPatientServices($id=null){
		$this->uses = array('EstimatePatient','EstimateServiceBill','Service');
		if(!empty($id)){


			$this->EstimatePatient->unBindModel(array(
					'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
			$this->EstimatePatient->bindModel(array(
					'belongsTo' => array(
							'Initial' =>array( 'foreignKey'=>'initial_id'),
							'TariffStandard' =>array('foreignKey'=>'tariff_standard_id')
					)));
			$patient_details  = $this->EstimatePatient->read(null,$id);
			#echo'<pre>';print_r($patient_details);exit;

			$tariffStandardId	=	$patient_details['EstimatePatient']['tariff_standard_id'];



			$this->EstimateServiceBill->bindModel(array(
					'belongsTo' => array(
							'Patient' =>array(
									'foreignKey'=>'patient_id'
							),
							'TariffList'=>array('foreignKey'=>'tariff_list_id'),
							'TariffAmount'=>array('foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=EstimateServiceBill.tariff_list_id','TariffAmount.tariff_standard_id='.$tariffStandardId))
					)));

			$servicesData =$this->EstimateServiceBill->find('all',array('group'=>array('EstimateServiceBill.id'),'fields'=>array('TariffAmount.*,TariffList.*,EstimateServiceBill.*,Patient.lookup_name'),'conditions'=>array('EstimateServiceBill.patient_id'=>$id),'order'=>array('EstimateServiceBill.date')));
			#pr($servicesData);exit;


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
		#pr($servicesData);exit;
	}


	public function setAddressFormat($patient_details=array()){#pr($patient_details);//exit;
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
			$format .= ucfirst($patient_details['state']);

		if(!empty($patient_details['state']) && !empty($patient_details['pin_code']))
			$format .= "-" ;

		if(!empty($patient_details['pin_code']))
			$format .= $patient_details['pin_code'];

		//pr($format);exit;
		return $format ;
	}


	//BOF pankaj
	function deleteEstimateConsultantCharges($id){
		$this->uses = array('EstimateConsultantBilling');
		if(!$id) return ;

		if($this->EstimateConsultantBilling->delete($id)){
			$this->Session->setFlash(__('Record deleted successfully'));
			$this->redirect($this->referer());
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
	}
	//EOF pankaj
	
	
	/**
	 * packageMaster
	 * master to add edit packages
	 * @author Gaurav Chauriya
	 */
	public function packageMaster($tariffStandardId,$packageEstimateId = null){
		if(!$tariffStandardId){
			$this->Session->setFlash(__('Please select payer','default',array('class'=>'error')));
			$this->redirect(array('controller'=>'Tariffs','action'=>'viewTariffAmount','?'=>array('fromPackage'=>1)));
		}
		$this->layout = 'advance';
		$this->uses  = array('PackageEstimate','Ward','SurgeryCategory','Surgery','SurgerySubcategory','OtItemCategory');
		$this->set(array('title_for_layout'=> __('Packages', true),'tariffStandardId'=>$tariffStandardId));
		if($this->request->data['PackageEstimate']){
			$this->PackageEstimate->savePackage($this->request->data['PackageEstimate']);
			$message = ($this->request->data['PackageEstimate']['id']) ? 'Updated Successfully' : 'Added Successfully';
			$this->Session->setFlash(__($message, true, array('class'=>'message')));
			if($this->params->query['0']['action'] == 'add'){
				$this->redirect(array('action'=>'packageEstimate',$this->params->query['0']['estimateId']));
			}
		}
		if($this->params->query['name']){
			$searchByName['PackageEstimate.name Like'] = $this->params->query['name'].'%';
		}
		$this->paginate = array(
				'evalScripts' => true,
				'limit' => Configure::read('number_of_rows'),
				'order' => array('PackageEstimate.id'=>'DESC'),
				//'fields'=> array('PackageEstimate.*'),
				'conditions' => array('PackageEstimate.tariff_standard_id'=>$tariffStandardId,'PackageEstimate.is_deleted' => 0,
						'PackageEstimate.location_id'=>$this->Session->read('locationid'),$searchByName)
		);
		$data = $this->paginate('PackageEstimate');
		if($packageEstimateId){
			$this->PackageEstimate->bindModel(array(
					'hasOne'=>array(
							'OtItem'=>array('foreignKey'=>false,
									'conditions'=>array('PackageEstimate.ot_item_id = OtItem.id'))
					)));
			$packageData  = $this->PackageEstimate->find('first',array('fields'=>array('PackageEstimate.*','OtItem.name','OtItem.manufacturer'),
					'conditions'=>array('PackageEstimate.id'=>$packageEstimateId)));

			$surgerysubcategories = $this->SurgerySubcategory->find('list', array('fields'=>array('id','name'),
					'conditions' => array('SurgerySubcategory.is_deleted' => 0,
							'SurgerySubcategory.surgery_category_id' => $packageData['PackageEstimate']['surgery_category_id']),'order'=>'name ASC'));
			$surgery = $this->Surgery->find('list', array('fields'=>array('id','name'),
					'conditions' => array('Surgery.is_deleted' => 0,'Surgery.surgery_category_id' => $packageData['PackageEstimate']['surgery_category_id'],
							'Surgery.location_id' => $this->Session->read('locationid')),'order'=>'name ASC'));
			$packageData['PackageEstimate']['misc_breakup'] = unserialize($packageData['PackageEstimate']['misc_breakup']);
			$this->data  = $packageData;
			$this->set(array('subCategory'=>$surgerysubcategories,'surgery'=>$surgery));
			$this->set('action','edit');
		}
		$this->set('surgeryCategories', $this->SurgeryCategory->find('list',array('fields'=>array('id','name'),
				'conditions'=>array('location_id'=>$this->Session->read('locationid'),'is_deleted'=>0))));
		$wardData = $this->getWardListAndCost($tariffStandardId);
		$this->set(array('ward'=>$wardData['ward'],'data'=>$data,'wardCost'=>$wardData['wardCost'],'wardService'=>$wardData['wardService'],'icuWardId'=>$wardData['icuId']));
		$this->set('categoryIdForImplant',$this->OtItemCategory->find('first',array('fields'=>'id','conditions'=>array('code_name'=>'Implant'))));
	}

	/**
	 * delete private package from master
	 * @author Gaurav Chauriya
	 */
	public function deletePackage($packageEstimateId){
		$this->uses  = array('PackageEstimate');
		$deleteArray['id'] = $packageEstimateId;
		$deleteArray['is_deleted'] = 1;
		$this->PackageEstimate->savePackage($deleteArray);
		$this->Session->setFlash(__('Deleted Successfully', true, array('class'=>'message')));
		//$this->redirect(array('action'=>'packageMaster'));
		$this->redirect($this->referer());
	}
	/**
	 * getWardListAndCost
	 * @author Gaurav Chauriya
	 * @return array
	 */
	function getWardListAndCost($tariffStandardId,$locationId = null){
		$this->loadModel('Ward');
		$this->loadModel('TariffStandard');
		$locationId = ($locationId) ? $locationId : $this->Session->read('locationid');
		$this->Ward->unbindModel(array('hasMany' => array('Room','ServicesWard')));
		$this->Ward->bindModel(array(
				'hasOne'=>array(
						'TariffAmount'=>array('foreignKey'=>false,
								'conditions'=>array('Ward.tariff_list_id = TariffAmount.tariff_list_id',
										'TariffAmount.tariff_standard_id'=>$tariffStandardId)),
						'TariffList'=>array('foreignKey'=>false,
								'conditions'=>array('Ward.tariff_list_id = TariffList.id'))
				)));
		$hospitalType = (strtoupper($this->Session->read('hospitaltype')) == 'NABH') ? 'nabh_charges' : 'non_nabh_charges';
		$wardTariff = $this->Ward->find('all',array('fields'=>array("Ward.id","Ward.name","Ward.ward_type","TariffAmount.$hospitalType as wardCost",'TariffList.i_assist','TariffList.psi'),
				'conditions'=>array('Ward.location_id'=>$locationId,'Ward.is_deleted'=>0,'Ward.is_active'=>1),'order'=>'id DESC'));

		foreach($wardTariff as $filterCharg){
			$ward[$filterCharg['Ward']['id']] = $filterCharg['Ward']['name'];
			$wardCost[$filterCharg['Ward']['id']] = trim($filterCharg['TariffAmount']['wardCost']);
			$wardService[$filterCharg['Ward']['id']]['i_assist'] = $filterCharg['TariffList']['i_assist'];
			$wardService[$filterCharg['Ward']['id']]['psi'] = $filterCharg['TariffList']['psi'];
			if($filterCharg['Ward']['ward_type'] == 'ICU')
				$icuId = $filterCharg['Ward']['id'];
		}
		return array('ward'=>$ward,'wardCost'=>json_encode($wardCost),'wardService'=>$wardService,'icuId'=>$icuId);
	}

	/**
	 * get all Surgery Category and Subcategory listing by xmlhttprequest
	 * @author Gaurav Chauriya
	 *
	 */

	public function getSurgeryAndSubcategoryList() {
		$this->loadModel("SurgerySubcategory");
		$this->loadModel("Surgery");
		$surgerysubcategories = $this->SurgerySubcategory->find('list', array('fields'=>array('id','name'),
				'conditions' => array('SurgerySubcategory.is_deleted' => 0,
						'SurgerySubcategory.surgery_category_id' => $this->params->query['surgery_category']),'order'=>'name ASC'));
		$surgery = $this->Surgery->find('list', array('fields'=>array('id','name'),
				'conditions' => array('Surgery.is_deleted' => 0,'Surgery.surgery_category_id' => $this->params->query['surgery_category'],
						'Surgery.location_id' => $this->Session->read('locationid')),'order'=>'name ASC'));
		echo Json_encode(array('subCategory'=>$surgerysubcategories,'surgery'=>$surgery));
		exit;
	}

	/**
	 * packageEstimate
	 * resident form to apply packages to patient
	 * @author Gaurav Chauriya
	 */
	public function packageEstimate($estimateConsultantBillingId = null, $personId = null){
		$this->layout = 'advance_ajax';//
		$this->uses = array('User','Ward','EstimateConsultantBilling','Patient','Person','OtItemCategory','PackageEstimate','Location','TariffStandard');
		$this->set('title_for_layout','Estimate');
		$hospitalCondition = (strtolower($this->Session->read('website.instance')) == 'hope') ? '' : "hospital_type = 'hospital'";
		if(  $estimateConsultantBillingId and $estimateConsultantBillingId != 'null' ){
			$this->EstimateConsultantBilling->bindModel(array(
					'hasOne'=>array(
							'Person'=>array('foreignKey'=>false,'fields'=>array('Person.full_name','Person.id','Person.sex','Person.dob'),
									'conditions'=>array('EstimateConsultantBilling.person_id = Person.id')),
							'User'=>array('foreignKey'=>false,'fields'=>array('User.full_name'),
									'conditions'=>array('EstimateConsultantBilling.doctor_id = User.id')),
							'Surgery'=>array('foreignKey'=>false,'fields'=>array('Surgery.name','Surgery.surgery_info_file_name'),
									'conditions'=>array('EstimateConsultantBilling.surgery_id = Surgery.id')),
							'PackageEstimate'=>array('foreignKey'=>false,'fields'=>array('PackageEstimate.name','PackageEstimate.package_price'),
									'conditions'=>array('EstimateConsultantBilling.package_estimate_id = PackageEstimate.id')),
							'OtItem'=>array('foreignKey'=>false,'fields'=>array('OtItem.name','OtItem.manufacturer','OtItem.pharmacy_item_id'),
									'conditions'=>array('EstimateConsultantBilling.ot_item_id = OtItem.id'))
					)));
			$estimateData = $this->EstimateConsultantBilling->find('first',
					array('conditions'=>array('EstimateConsultantBilling.id'=>$estimateConsultantBillingId)));
			/** catch for single hospital */
			$hospLocationId = $this->Location->find('first',array('fields'=>array('id'),
					'conditions'=>array($hospitalCondition,'is_deleted'=>0,'is_active'=>1)));
				
			$estimateData['EstimateConsultantBilling']['location_id'] = $hospLocationId['Location']['id'];
			/** */
			$this->data = $this->filterDataForRequest($estimateData);
		}else if($personId and $personId != 'null' /* and $this->request->query['patientId'] */){
			$this->Patient->bindModel(array(
					'hasOne'=>array(
							'Person'=>array('foreignKey'=>false,'type'=>'Right',
									'conditions'=>array('Person.id = Patient.person_id')),
							'EstimateConsultantBilling'=>array('foreignKey'=>false,
									'conditions'=>array('EstimateConsultantBilling.patient_id = Patient.id')),
							'User'=>array('foreignKey'=>false,
									'conditions'=>array('EstimateConsultantBilling.doctor_id = User.id')),
							'Surgery'=>array('foreignKey'=>false,
									'conditions'=>array('EstimateConsultantBilling.surgery_id = Surgery.id')),
							'PackageEstimate'=>array('foreignKey'=>false,
									'conditions'=>array('EstimateConsultantBilling.package_estimate_id = PackageEstimate.id')),
							'OtItem'=>array('foreignKey'=>false,
									'conditions'=>array('EstimateConsultantBilling.ot_item_id = OtItem.id')),
					)));

			$estimateData = $this->Patient->find('first',array(  'fields'=>array('Patient.id','Patient.lookup_name','Person.id','Person.sex','Person.dob',
					'EstimateConsultantBilling.*','CONCAT(User.first_name," ", User.last_name) as full_name','Surgery.name','Surgery.surgery_info_file_name',
					'PackageEstimate.name','PackageEstimate.package_price','OtItem.name','OtItem.manufacturer','OtItem.pharmacy_item_id'),
					'conditions'=>array(/* 'Patient.id'=>$this->request->query['patientId'] */'Patient.person_id'=>$personId)));
			if(empty($estimateData))
				$estimateData = $this->Person->find('first',array(  'fields'=>array('Person.id','Person.full_name','Person.sex','Person.dob'),
						'conditions'=>array('Person.id'=>$personId)));
			/** catch for single hospital */
			$hospLocationId = $this->Location->find('first',array('fields'=>array('id'),
					'conditions'=>array($hospitalCondition,'is_deleted'=>0,'is_active'=>1)));
				
			$estimateData['EstimateConsultantBilling']['location_id'] = $hospLocationId['Location']['id'];
			/** */
			$this->data = $this->filterDataForRequest($estimateData);
		}
		
		
		if($this->Session->read('role') != Configure::read('residentLabel')){
			$this->set('locations',$this->Location->find('list',array('fields'=>array('id','name'),
					'conditions'=>array($hospitalCondition,'is_deleted'=>0,'is_active'=>1))));
			
			$Residentlist=$this->User->getResidentDoctor($estimateData['EstimateConsultantBilling']['location_id']);
			$this->set('Residentlist',$Residentlist);
		}
		$wardData = $this->getWardListAndCost($this->TariffStandard->getPrivateTariffID(),$estimateData['EstimateConsultantBilling']['location_id']);
		$this->set(array('ward'=>$wardData['ward'],'wardCost'=>$wardData['wardCost'],'wardService'=>$wardData['wardService'],'icuWardId'=>$wardData['icuId']));
		$this->set('categoryIdForImplant',$this->OtItemCategory->find('first',array('fields'=>'id','conditions'=>array('code_name'=>'Implant'))));

		if($this->Session->read('role') == Configure::read('residentLabel') && ! $this->data['EstimateConsultantBilling']['approved']){
			$availablePackages = $this->PackageEstimate->find('all',array('className'=>'item','conditions'=>array('is_deleted'=>0,
					'surgery_id'=>$this->data['EstimateConsultantBilling']['surgery_id'])));//locationid removed because surgery table has it
			$this->set('availablePackages',$availablePackages);
		}
		$nurse = $this->User->getUsersByRoleName(Configure::read('medicalAssistantLabel'),$estimateData['EstimateConsultantBilling']['location_id']);
		$surgeon = $this->User->getSurgeonlist($estimateData['EstimateConsultantBilling']['location_id']);
		$this->set('surgeonlist',($surgeon + $nurse));
	}
	/**
	 * filterDataForRequest
	 * function to set data for $this->data
	 * @param array $estimateData
	 * @return array
	 * @author Gaurav Chauriya
	 */
	private function filterDataForRequest($estimateData){
		$this->loadModel('Person');
		$estimateData['EstimateConsultantBilling']['patient_name'] = ($estimateData['Patient']['lookup_name']) ? $estimateData['Patient']['lookup_name'] : $estimateData['Person']['full_name'];
		$estimateData['Person']['sex'] = ucfirst(strtolower($estimateData['Person']['sex']));
		$estimateData['Person']['age'] = $this->Person->getCurrentAge($estimateData['Person']['dob']);
		$estimateData['EstimateConsultantBilling']['person_id'] = $estimateData['Person']['id'];
		$estimateData['EstimateConsultantBilling']['doctor_name'] = ($estimateData['0']['full_name']) ? $estimateData['0']['full_name'] : $estimateData['User']['full_name'];
		$estimateData['EstimateConsultantBilling']['date'] = $this->DateFormat->formatDate2Local($estimateData['EstimateConsultantBilling']['date'],Configure::read('date_format'),true);
		$estimateData['EstimateConsultantBilling']['admission_date'] = $this->DateFormat->formatDate2Local($estimateData['EstimateConsultantBilling']['admission_date'],Configure::read('date_format'),false);
		$surgeryDate =  $this->DateFormat->formatDate2Local($estimateData['EstimateConsultantBilling']['surgery_date'],Configure::read('date_format'),false);
		$surgeryDate = ($surgeryDate != '00/00/0000') ? $surgeryDate : '';
		$estimateData['EstimateConsultantBilling']['surgery_date'] = $surgeryDate;
		$estimateData['EstimateConsultantBilling']['package_name'] = $estimateData['PackageEstimate']['name'];
		$estimateData['EstimateConsultantBilling']['surgery_name'] = $estimateData['Surgery']['name'];
		$estimateData['EstimateConsultantBilling']['surgery_info_file_name'] = $estimateData['Surgery']['surgery_info_file_name'];
		$estimateData['EstimateConsultantBilling']['other_doctor_staff'] = unserialize($estimateData['EstimateConsultantBilling']['other_doctor_staff']);
		$estimateData['EstimateConsultantBilling']['payment_instruction'] = unserialize($estimateData['EstimateConsultantBilling']['payment_instruction']);
		$estimateData['EstimateConsultantBilling']['discount'] = unserialize($estimateData['EstimateConsultantBilling']['discount']);
		$estimateData['EstimateConsultantBilling']['package_price'] = $estimateData['PackageEstimate']['package_price'];
		return $estimateData;
	}

	/**
	 * getLocationConsultant
	 * fetches consultant on bassis of locationId
	 * @author Gaurav Chauriya
	 */
	public function getLocationConsultant($locationId){
		$this->autoRender = false;
		$this->loadModel('User');
		$consultant = $this->User->getResidentDoctor($locationId);
		$nurse = $this->User->getUsersByRoleName(Configure::read('medicalAssistantLabel'),$locationId);
		$surgeon = $this->User->getSurgeonlist($locationId);
		$surgeonAndNurse = ($surgeon + $nurse);
		return json_encode(array('consultant'=>$consultant,'surgeonAndNurse'=>$surgeonAndNurse));
	}
	/**
	 * getPackageDetails
	 * fetch surgery name and implants details
	 * @param int $surgeryId
	 * @param int $otItemId
	 * @author Gaurav Chauriya
	 */
	public function getPackageDetails($surgeryId = null,$otItemId = null){
		$this->loadModel("Surgery");
		$this->loadModel("OtItem");
		$surgery = $this->Surgery->find('first', array('fields'=>array('name','surgery_info_file_name'),'conditions' => array('Surgery.id' => $surgeryId)));
		$this->OtItem->bindModel(array(
				'hasOne'=>array(
						'PharmacyItemRate'=>array('foreignKey'=>false,
								'conditions'=>array('PharmacyItemRate.item_id = OtItem.pharmacy_item_id'))
				)));
		$otItem = $this->OtItem->find('first', array('fields'=>array('name','manufacturer','pharmacy_item_id','PharmacyItemRate.sale_price'),
				'conditions' => array('OtItem.id' => $otItemId)));
		echo json_encode(array('surgery'=>$surgery['Surgery']['name'],'surgeryFileName'=>$surgery['Surgery']['surgery_info_file_name'],'implant'=>$otItem['OtItem'],
				'implantRate'=>$otItem['PharmacyItemRate']['sale_price']));
		exit;
	}
	
	/**
	 * getPackagePrice
	 * fetch package price and discount on hospital cost
	 */
	public function getPackagePrice(){
		
		$this->autoRender = false;
		$this->loadModel('PackageEstimate');
		$packageData  = $this->PackageEstimate->find('first',array('fields'=>array('PackageEstimate.misc_breakup','PackageEstimate.package_price','PackageEstimate.misc_charge'),
				'conditions'=>array($this->request->query)));
		$packageData['PackageEstimate']['misc_breakup'] = unserialize($packageData['PackageEstimate']['misc_breakup']);
		$packageData['PackageEstimate']['miscDiscountValue'] = $packageData['PackageEstimate']['misc_breakup']['misc_charge_discount'];
		$packageData['PackageEstimate']['miscDiscount'] = (int) $packageData['PackageEstimate']['misc_charge'] -  (int) $packageData['PackageEstimate']['miscDiscountValue'] ;
		$packageData['PackageEstimate']['miscDiscountType'] = 'inAmount';
		echo json_encode($packageData);
		exit;
	}

	/**
	 * estimateConsultantBill
	 * ajax function to save patient package and send mail
	 * @param int $personId
	 * @author Gaurav Chauriya
	 */
	public function estimateConsultantBill($personId = null){
		$this->layout = false;
		$this->uses=array('User','EstimateConsultantBilling','Note','Patient');
		$estimateData = $this->EstimateConsultantBilling->assignPackage($this->request->data['EstimateConsultantBilling']);
		///BOF-Mahalaxmi-For send SMS to Physician
		if($this->request->data['EstimateConsultantBilling']['approved']){
			$getEnableFeatureChk = $this->Session->read('sms_feature_chk');
			if($getEnableFeatureChk =='1'){
				$this->Patient->sendToSmsMultipleUser($this->request->data['EstimateConsultantBilling']['person_id'],'Estimate',$this->request->data['EstimateConsultantBilling']['other_doctor_staff'],$estimateData['opt_appointment_id']);
			}
		}
		///EOF-Mahalaxmi-For send SMS to Physician
		$userfullname = $this->User->find('first', array('fields'=> array('User.first_name','User.last_name','User.username'),
				'conditions'=>array('User.id' => $this->request->data['EstimateConsultantBilling']['sendMailTo'])));
		$userfullnameVal=$userfullname["User"]["first_name"]." ".$userfullname["User"]["last_name"];
		$mailData['Patient']=array("patient_id"=>$userfullname["User"]["username"],"lookup_name"=>$userfullnameVal);
		$msgs="Please click on below estimate link of ".$this->request->data["EstimateConsultantBilling"]["patient_name"]."<br/><br/>";
		$estimateId = $estimateData['id'];
		$msgs.="<a href=".Router::url('/')."Estimates/packageEstimate/".$estimateId.">Click here to view estimate</a><br/><br/>";
			
		if(!empty($this->request->data['EstimateConsultantBilling']["resident_msg"]))
			$msgs.="<strong>Physician Message:</strong> ".$this->request->data['EstimateConsultantBilling']["resident_msg"]."<br/><br/>";

		$msgs.="<strong>Assigned Date:</strong> ".$this->request->data['EstimateConsultantBilling']['date']."<br/><br/>";
		$subject="Request for estimate for ".$this->request->data["EstimateConsultantBilling"]["patient_name"];
		$this->Note->sendMail($mailData,$msgs,$subject);
		exit;
	}
	/**
	 * function residentDashboard()
	 * private package Dashboard
	 * @author swati Newale
	 *
	 */
	public function residentDashboard(){
		$this->layout = 'advance';
		$this->uses=array('EstimateConsultantBilling','Patient');
		$this->EstimateConsultantBilling->bindModel(array(
				'hasOne'=>array(
						'Person'=>array('foreignKey'=>false,
								'conditions'=>array('EstimateConsultantBilling.person_id = Person.id')),
						'Patient'=>array('foreignKey' => false,
								'conditions'=>array('Patient.id = EstimateConsultantBilling.patient_id')),
						'User'=>array('foreignKey'=>false,
								'conditions'=>array('EstimateConsultantBilling.doctor_id = User.id')),
						'PackageEstimate'=>array('foreignKey'=>false,
								'conditions'=>array('EstimateConsultantBilling.package_estimate_id = PackageEstimate.id')),
				)));
		/** -----------------problem condition */
		/*$conditions['OR']['EstimateConsultantBilling.location_id'] = $this->Session->read('locationid');
		 $conditions['OR']['Patient.location_id'] = $this->Session->read('locationid');*/
		if(!empty($this->request->query)){
			/*if(!empty($this->request->query['lookup_name'])){
				$conditions['Patient.lookup_name'] = $this->request->query['lookup_name']."%";
			}*/
			if(!empty($this->request->query['from'])){
				$conditions['EstimateConsultantBilling.date >='] = $this->DateFormat->formatDate2STD($this->request->query['from'],Configure::read('date_format'))." 00:00:00";
			}
			if(!empty($this->request->query['to'])){
				$conditions['EstimateConsultantBilling.date <='] = $this->DateFormat->formatDate2STD($this->request->query['to'],Configure::read('date_format'))." 23:59:59";
			}
		}
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Patient.id' => 'desc'),
				'fields'=>array('Patient.lookup_name','EstimateConsultantBilling.id','EstimateConsultantBilling.date','EstimateConsultantBilling.patient_id',
						'EstimateConsultantBilling.package_estimate_id','EstimateConsultantBilling.approved','EstimateConsultantBilling.surgery_date',
						'EstimateConsultantBilling.package_estimate_id','PackageEstimate.name','Person.sex','Person.dob','CONCAT(User.first_name," ",User.last_name) as name'),
				'conditions'=>$conditions);
		$this->set('results',$this->paginate('EstimateConsultantBilling'));
		$this->set('admittedPatients' , $this->Patient->find('list',array('fields'=>array('id','is_packaged'),
				'conditions'=>array('is_discharge'=>0,'is_packaged !='=> 0,'admission_type' => 'IPD' ))));
	}
	
	
	/**
	 * function for Generation of Coupon Numbers
	 * @author Swati Newale
	 */
	public function couponBatchGeneration($couponId = null){
		$this->uses = array('ServiceCategory','Location','Coupon');
		$this->layout="advance";
		if(!empty($this->request->data)){ 
			//debug($this->request->data);exit;
			$this->Coupon->saveCouponData($this->request->data['Coupon']);
			$message = ($this->request->data['Coupon']['id']) ?  'Coupon Updated Successfully' : 'Coupon Submitted Successfully';
			$this->Session->setFlash(__($message, true ,array('class'=>'message')));
			$this->redirect(array('action'=>'couponBatchGeneration'));
		}
		$this->ServiceCategory->unbindModel(array(
				'hasMany' => array('SurgerySubcategory')));
		$services = $this->ServiceCategory->find('list', array('conditions'=>array('ServiceCategory.is_deleted'=>0,'ServiceCategory.is_view'=>1,'ServiceCategory.alias IS not null','ServiceCategory.location_id !='=>'23','ServiceCategory.service_type !='=>''),
				'fields'=>array('ServiceCategory.id','ServiceCategory.alias')));
		
		$branches= $this->Location->find('list', array('conditions'=>array('Location.is_deleted'=>0,'Location.is_active'=>'1'),
				'fields'=>array('Location.id','Location.name')));
		$this->set(compact(array('services','branches')));
		
		if($couponId){
			$couponData = $this->Coupon->find('first',array('conditions'=>array('Coupon.id'=>$couponId ) ,'fields'=>array('Coupon.*')));
			$couponData['Coupon']['valid_date_from'] = $this->DateFormat->formatDate2Local($couponData['Coupon']['valid_date_from'],Configure::read('date_format'));
			$couponData['Coupon']['valid_date_to'] = $this->DateFormat->formatDate2Local($couponData['Coupon']['valid_date_to'],Configure::read('date_format'));
			$couponData['Coupon']['coupon_amount'] = unserialize($couponData['Coupon']['coupon_amount']);
			$this->request->data = $couponData;
		
			$this->set('action','edit');
		}else{
			/*$this->set('couponData',$this->Coupon->find('all',array('fields'=>array('Coupon.id','Coupon.type','Coupon.batch_name','Coupon.valid_date_from','Coupon.valid_date_to'),
					'conditions'=>array('Coupon.is_deleted'=>0,'Coupon.location_id'=>$this->Session->read('locationid'),'Coupon.parent_id'=>0),
					'order'=>array('Coupon.id'=>'desc'))));*/
			$this->request->data['Coupon']['batch_name'] = $this->autoGeneratedCouponBatchID();
                        $locationContidition = $this->Session->read('location_created_by') ? "Coupon.branch = ".$this->Session->read('locationid') : "";
                        $this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Coupon.id'=>'desc'),
				'fields'=>array('Coupon.id','Coupon.type','Coupon.batch_name','Coupon.branch','Coupon.valid_date_from','Coupon.valid_date_to'),
				'conditions'=>array('Coupon.is_deleted'=>0,$locationContidition,'Coupon.parent_id'=>0));
			$this->set('couponData',$this->paginate('Coupon'));
		}
	}
	/**
	 * function to create Coupon id
	 * @author Swati Newale
	 * @return string
	 */
	public function autoGeneratedCouponBatchID(){
		$count = $this->Coupon->find('count');
		if($count < 10 ){
			$count = "0000$count" ;
		}else if($count >= 10 && $count < 100){
			$count = "000$count"  ;
		}else if($count >= 100 && $count < 1000){
			$count = "00$count"  ;
		}else if($count >= 1000 && $count < 10000){
			$count = "0$count"  ;
		}
		$facility = $this->Session->read('location');
		$unique_id .= $count;
		$unique_id1 .= substr($facility,0,1); //first letter of the hospital name
		$unique_id2 = $unique_id1.$count;
		return ($unique_id2);
	}
	
	/**
	 * view coupon details
	 * @author Swati Newale
	 */
	public function viewCoupon($couponId){
		$this->layout = 'advance';
		$this->uses = array('ServiceCategory','Coupon');
		$data = $this->Coupon->find('all',array('conditions'=>array('OR'=>array('Coupon.id' => $couponId, 'Coupon.parent_id' => $couponId)),'order'=>'id ASC'));
		$services = $this->ServiceCategory->find('list', array('conditions'=>array('ServiceCategory.is_deleted'=>0,'is_view'=>1,'alias IS not null'/*,'ServiceCategory.location_id'=>$this->Session->read('locationid')*/),
				'fields'=>array('ServiceCategory.id','ServiceCategory.alias')));
		$this->set(compact(array('services','data')));
	}
	/**
	 * view coupon details
	 * @author Swati Newale
	 */
	public function stickers($offset){
		$this->layout = false;
		$this->uses = array('ServiceCategory','Coupon');
		$data = $this->Coupon->find('list',array('fields'=>array('Coupon.batch_name'),
				'conditions'=>array('Coupon.type' => 'Privilege Card','Coupon.parent_id !=' =>0,'Coupon.status !=' =>2)));
		
		
		$this->set(compact(array('services','data')));
		$this->render('stickers');
	} 
        /**
         * print coupons
         * @author Swati Newale
         */
        public function printCoupon($couponId){
           $this->layout = false;
            $this->uses = array('ServiceCategory','Coupon','Location');
            $branches= $this->Location->find('list', array('conditions'=>array('Location.is_deleted'=>0,'Location.is_active'=>'1'),
            		'fields'=>array('Location.id','Location.name')));
            
            $data = $this->Coupon->find('all',array('fields'=>array('type','parent_id','batch_name','valid_date_to','valid_date_from','sevices_available','coupon_amount','branch'),
                'conditions'=>array('status'=>0,'branch' =>$this->Session->read('locationid'), 'OR' =>array('Coupon.parent_id'=>$couponId,'Coupon.id'=>$couponId)),'order'=>'id ASC'));

           // $services = explode(',',$data['0']['Coupon']['sevices_available']);
          $services = $this->ServiceCategory->find('list', array('conditions'=>array('ServiceCategory.is_deleted'=>0,'ServiceCategory.is_view'=>1,'ServiceCategory.alias IS not null','ServiceCategory.location_id !='=>'23','ServiceCategory.service_type !='=>''),
				'fields'=>array('ServiceCategory.id','ServiceCategory.alias')));
            $this->set(compact(array('services','data','branches','parentbatch')));
        }
        /**
         * function to update coupon status
         * @author Swati Newale  <swatin@drmhope.com>
         */
        
        public function updateCouponStatus($id,$status){
        	$this->uses = array('Coupon');
        	$this->request->data['Coupon']['status']=$status;
        	$this->request->data['Coupon']['id']=$id;
        	$this->Coupon->id= $id;
        	$this->Coupon->save($this->request->data['Coupon']);
        	exit;
        
        }  
	/**
	 * delete Coupon for Generate Coupon
	 * @author Swati Newale
	 */
	public function deleteCoupon($couponId){
		$this->uses  = array('Coupon');
		$deleteArray['id'] = $couponId;
		$deleteArray['is_deleted'] = 1;
		$this->Coupon->saveCouponData($deleteArray);
		$this->Session->setFlash(__('Coupon Deleted Successfully', true, array('class'=>'message')));
		$this->redirect($this->referer());
	}
	/*public function stickers(){
		$this->layout = false;
		$this->uses = array('ServiceCategory','Coupon');
		$data = $this->Coupon->find('list',array('fields'=>array('Coupon.batch_name'),'conditions'=>array('Coupon.type' => 'Privilege Card','Coupon.parent_id !=' =>0))); //,'limit'=>'24'
		
		
		$this->set(compact(array('services','data')));
		$this->render('stickers');
	} */
}