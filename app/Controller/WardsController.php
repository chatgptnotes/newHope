<?php
/**
 * WardsController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Wards Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */

class WardsController extends AppController {

	public $name = 'Wards';
	public $uses = array('Ward');
	public $helpers = array('Html','Form', 'Js','DateFormat','General');
	public $components = array('RequestHandler','Email','DateFormat','General');

	//function to display ward occupancy
	function index(){
		$this->layout  =  'advance' ;
		$this->uses = array('Room','Bed','WardPatient');

		$this->Bed->bindModel(array(
				'belongsTo' => array('Room'=>array('foreignKey'=>'room_id','type'=>'inner'),'Ward'=>array('foreignKey'=>false,'conditions'=>array('Ward.id=Room.ward_id'),'type'=>'inner'),
						'Patient'=>array('foreignKey'=>'patient_id','type'=>'left','fields'=>array('Patient.id','lookup_name','patient_id','admission_id','bed_id','age',
								'sex','is_discharge'),'conditions'=>array('Patient.is_deleted=0')),
						'Diagnosis'=>array('fields'=>array('Diagnosis.final_diagnosis'),'foreignKey'=>false,'conditions'=>array('Diagnosis.patient_id=Patient.id'))),
				'hasMany'=>array('WardPatient'=>array('conditions'=>array('WardPatient.is_discharge=1','WardPatient.is_deleted=0'),'order'=>'WardPatient.id Desc','Limit'=>1))),false);
			
		$bedData = $this->Bed->Find('all',array('order'=>'Room.id Asc','conditions'=>array('Ward.location_id'=>$this->Session->read('locationid'))));
		$wardData = $this->Ward->find('all',array('fields'=>'name,id','conditions'=>array('Ward.location_id'=>$this->Session->read('locationid'))));
		$roomData = $this->Room->find('all',array('fields'=>'name,id','conditions'=>array('Room.location_id'=>$this->Session->read('locationid'))));

		$this->set(array('wardData'=>$wardData,'roomData'=>$roomData,'bedData'=>$bedData));

			
	}


	function admin_index() {
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'Ward.id' => 'desc'
				),
				'conditions' => array('Ward.location_id' => $this->Session->read('locationid'))
		);
		$this->Ward->bindModel(array(
	 		'belongsTo' => array(
	 				'User' =>array(
	 						'fields'=>'User.first_name, User.last_name',
	 						#'conditions' => array('User.id' => 'Ward.created_by'),
	 						'foreignKey'    => 'created_by'
	 				),
	 				'Location'=>array('foreignKey'=>'location_id')
	 	 )));
		$this->set('title_for_layout', __('Manage Wards', true));
		$data = $this->paginate('Ward');
		$this->set('data', $data);
	}

	function admin_add() {#echo '<pre>';print_r($_SESSION);exit;
		$this->loadModel('User');
		$this->uses = array('Location');
		$this->Ward->create();
		$this->set('title_for_layout', __('Add Ward', true));
		if (!empty($this->data)) {
			$old_data = $this->Ward->find('count',array('conditions'=>array('name'=>$this->request->data['Ward']['name'],'location_id' => $this->Session->read('locationid') ) ));
			if($old_data){
				$this->Session->setFlash(__('This Ward is already exist.'),'default',array('class'=>'error'));
				return false;
			}
				
			$this->request->data["Ward"]["create_time"] = date("Y-m-d H:i:s");
			$this->request->data["Ward"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["Ward"]["created_by"] = $this->Session->read('userid');
			$this->request->data["Ward"]["modified_by"] = $this->Session->read('userid');


			$this->Ward->save($this->request->data);
			$errors = $this->Ward->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('Ward has been added successfully'),'default',array('class'=>'message'));
				$this->redirect(array("controller" => "wards", "action" => "index", "admin" => true));
			}
		}
		$this->set('locations',$this->Location->find('list',array('fields'=>array('name'))));
	}

	function admin_edit(){
		//echo '<pre>';print_r($this->request->params['pass'][0]);exit;
		$this->uses = array('Location');
		$this->set('title_for_layout', __('Edit Ward', true));
		if (!$this->request->params['pass'][0] && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Ward'),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'index'));
		}
		$id = $this->request->params['pass'][0];
		if (!empty($this->data)) {
			$this->request->data["Ward"]["create_time"] = date("Y-m-d H:i:s");
			$this->request->data["Ward"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["Ward"]["modified_by"] = $this->Session->read('userid');
			 
			/*$old_data = $this->Ward->find('count',array('conditions'=>array('name'=>$this->request->data['Ward']['name'],'id !=' =>$this->request->data["Ward"]['id']) ));
			 if($old_data){

			$this->Session->setFlash(__('This Ward is already exist.'),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'edit',$this->request->data['Ward']['id']));
			}*/

			$this->request->data["Ward"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["Country"]["created_by"] = "5";//temp set to 5 later on change this to current logged in user's id

			if ($this->Ward->save($this->data)) {
				$this->Session->setFlash(__('Ward has been update successfully'),'default',array('class'=>'message'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Ward could not be saved. Please, try again.'),'default',array('class'=>'error'));
			}
		}

		if (empty($this->data)) {
			$this->data = $this->Ward->read(null, $id);
		}
		$this->set('id', $id);
		$this->set('locations',$this->Location->find('list',array('fields'=>array('name'))));
	}

	/*function wardOccupancy(){
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'Ward.name' => 'asc'
				)
	 );
	$this->Ward->bindModel(array(
			'belongsTo' => array(
					'User' =>array(
							'fields'=>'User.first_name, User.last_name',
							#'conditions' => array('User.id' => 'Ward.created_by'),
							'foreignKey'    => 'created_by'
					)
			)));
	$this->set('title_for_layout', __('Manage Wards', true));
	$data = $this->paginate('Ward');
	$this->set('data', $data);
	}*/

	function admin_delete($ward_id=null){
		if (!$ward_id) {
			$this->Session->setFlash(__('Invalid id for Ward'),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'index'));
		}
		$this->uses= array('Room');
		//if($rooms == 0){
		if ($this->Ward->delete($ward_id)) {
			//delete rooms
			$this->Room->deleteAll(array('Room.ward_id'=>$ward_id),true);
			$this->Session->setFlash(__('Ward successfully deleted'),'default',array('class'=>'message'));
			$this->redirect(array("controller" => "wards", "action" => "index", "admin" => true));
		}else{
			$this->Session->setFlash(__('There is patient(s) admitted in seleted ward, Please check and try again.'),'default',array('class'=>'error'));
			$this->redirect(array("controller" => "wards", "action" => "index", "admin" => true));
		}
		/*}else{
			$this->Session->setFlash(__('Please remove rooms associated with the selected ward and try again.'),'default',array('class'=>'error'));
		$this->redirect(array("controller" => "wards", "action" => "index", "admin" => true));
		}*/
			
			
	}

	public function addWard(){
		$this->uses = array('Location','ServicesWards','TariffList','TariffStandard','ServiceCategory');
		if($this->request->data){
			$old_data = $this->Ward->find('count',array('conditions'=>array('Ward.name'=>$this->request->data['Ward']['name'],/* 'Ward.wardid'=>$this->request->data['Ward']['wardid'], */'Ward.is_deleted'=>0,'Ward.location_id'=>$this->Session->read('locationid'))));
			if(empty($old_data)){

				$this->request->data['Ward']['location_id'] = $this->Session->read('locationid');
				$this->request->data['Ward']['created_by'] = $this->Session->read('userid');
				$this->request->data['Ward']['modified_by'] = $this->Session->read('userid');
				$this->request->data['Ward']['create_time'] = date('Y-m-d H:i:s');
				$this->request->data['Ward']['modify_time'] = date('Y-m-d H:i:s');
				$this->request->data['Ward']['is_active'] = 1;
				if($this->Ward->save($this->request->data['Ward'])){
					$this->Session->setFlash(__('Ward Created Successfully', true));
					$this->redirect(array("controller" => "wards", "action" => "index",'admin'=>true));
				} else {
					$this->Session->setFlash(__('Data could not be saved! Please try again.'),'default',array('class'=>'error'));
					$this->redirect(array("controller" => "wards", "action" => "addWard",'admin'=>false));
				}
			} else {
				$this->Session->setFlash(__('Ward already exists! Please try again.'), 'default',array('class'=>'error'));
				$this->redirect(array("controller" => "wards", "action" => "addWard",'admin'=>false));
			}
		}
		/*$tariffList = $this->TariffList->find('list',array('conditions'=>array('location_id'=>$this->Session->read('locationid'),'is_deleted'=>0)));
		 $this->set('tariffList',$tariffList);
		$tariffStandard = $this->TariffStandard->find('list',array('conditions'=>array('location_id'=>$this->Session->read('locationid'),'is_deleted'=>0)));
		$this->set('tariffStandard',$tariffStandard);	*/
		//retrive only service group
		$this->set('serviceGroup',$this->ServiceCategory->getServiceGroup());
	}

	public function editWard($wardId=''){
		$this->uses = array('Location','ServicesWards','Corporate','InsuranceCompany','TariffList','TariffStandard','ServiceCategory');
		if($this->request->data){
			//debug($this->request->data); exit;
			$wardData = array();
			$this->request->data['Ward']['location_id'] = $this->Session->read('locationid');
			$wardDetails = $this->Ward->read(null,$this->request->data['Ward']['id']);
			$oldNoOfWards = $wardDetails['Ward']['no_of_rooms'];
			$newNoOfWards = $this->request->data['Ward']['no_of_rooms'];
			/*
			 if($newNoOfWards < $oldNoOfWards){
			$this->Session->setFlash(__('You cannot decrease rooms from ward'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
			} */
			$this->Ward->save($this->request->data);
			$this->Session->setFlash(__('Ward Updated Successfully', true));
			$this->redirect(array('action'=>'index','admin'=>true));
		}

		$this->Ward->unbindModel(array(
				'hasMany' => array(
						'Room'
				)),false);

		$this->data = $this->Ward->read(null,$wardId);

		$this->set('serviceGroup',$this->ServiceCategory->getServiceGroup());
		$tariffList = $this->TariffList->getServiceByGroupId($this->data['Ward']['service_group_id']);
		$this->set('tariffList',$tariffList);
	}

	public function getcorporate($corporate_id){
		$this->uses = array('Corporate','InsuranceCompany');
		if($corporate_id == 1){
			$corporate_list = $this->Corporate->find('list');
			$corporate_type = 'corporate';
		} else if($corporate_id == 2){
			$corporate_list = $this->InsuranceCompany->find('list');
			$corporate_type = 'insurance';
		} else if($corporate_id == 0){
			$corporate_type = '';
		}
		echo json_encode($corporate_list);exit;
	}

	public function getWardsByLocation($location_id){
		$wards = $this->Ward->find('list',array('fields'=>array('Ward.id','Ward.name'),'conditions'=>array('location_id'=>$location_id)));
		echo json_encode($wards);exit;
	}

	public function getWardDetailsById($ward_id){
		$this->Ward->unbindModel(array(
				'hasMany' => array(
						'Room'
				)),false);
		$wardDetails = $this->Ward->read(array('id','name','wardid','no_of_rooms'),$ward_id);
		echo json_encode($wardDetails['Ward']);exit;
	}

	//BOF pankaj
	function ward_occupancy(){
		$this->uses = array('Room','Bed','Ward');
		//$this->Ward->recursive = -1 ;

		$this->set('wardName','');
		if($this->params->query){
			$this->data = $this->params->query ;
			$this->Ward->recursive = -1 ;
			$wardName = $this->Ward->read(array('name'),$this->params->query['Ward']);

			$this->Room->bindModel(array(
					'hasMany' => array(
							'Bed'=>array())),false);

			$this->Bed->bindModel(array(
					'belongsTo' => array('Room'=>array('foreignKey'=>'room_id','type'=>'inner'),'Ward'=>array('foreignKey'=>false,'conditions'=>array('Ward.id=Room.ward_id'),'type'=>'inner'),
							'Patient'=>array('foreignKey'=>'patient_id','type'=>'left','fields'=>array('Patient.id','lookup_name','patient_id','admission_id','bed_id','age',
									'sex','is_discharge'),'conditions'=>array('Patient.is_deleted=0')),
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id'), 'fields' => array('PatientInitial.name')),
							'Diagnosis'=>array('fields'=>array('Diagnosis.final_diagnosis'),'foreignKey'=>false,'conditions'=>array('Diagnosis.patient_id=Patient.id'))),
					'hasMany'=>array('WardPatient'=>array('order'=>'WardPatient.id Desc','Limit'=>1,'WardPatient.is_deleted=0'))),false);

			$bedData = $this->Bed->Find('all',array('order'=>'Room.id Asc','conditions'=>array('Bed.location_id'=>$this->Session->read('locationid'),'Room.ward_id'=>$this->params->query['Ward'],
					'Room.location_id'=>$this->Session->read('locationid'))));

			$roomData = $this->Room->Find('all',array('fields'=>array('Room.name','Room.bed_prefix'),'conditions'=>array('Room.ward_id'=>$this->params->query['Ward'])));
				
			$this->set(array('rooms'=>$roomData,'bedData'=>$bedData,'wardName'=>$wardName['Ward']['name']));
		}else{
			$this->Bed->bindModel(array(
					'belongsTo' => array('Room'=>array('foreignKey'=>'room_id','type'=>'inner'),'Ward'=>array('foreignKey'=>false,'conditions'=>array('Ward.id=Room.ward_id'),'type'=>'inner'),
							'Patient'=>array('foreignKey'=>'patient_id','type'=>'left','fields'=>array('Patient.id','lookup_name','patient_id','admission_id','bed_id','age',
									'sex','is_discharge')),
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id'), 'fields' => array('PatientInitial.name')),
							'Diagnosis'=>array('fields'=>array('Diagnosis.final_diagnosis'),'foreignKey'=>false,'conditions'=>array('Diagnosis.patient_id=Patient.id','Patient.is_deleted=0'))),
					'hasMany'=>array('WardPatient'=>array('conditions'=>array('WardPatient.is_discharge=1','WardPatient.is_deleted=0'),'order'=>'WardPatient.id Desc','Limit'=>1))),false);
				
			$bedData = $this->Bed->Find('all',array('order'=>'Room.id Asc','conditions'=>array('Ward.location_id'=>$this->Session->read('locationid')),
													'group'=>array('Bed.id')));
			$wardData = $this->Ward->find('all',array('fields'=>'name,id','conditions'=>array('Ward.location_id'=>$this->Session->read('locationid'))));
			$roomData = $this->Room->find('all',array('fields'=>'name,id','conditions'=>array('Room.location_id'=>$this->Session->read('locationid'))));  
			//debug($bedData);
			$this->set(array('wardData'=>$wardData,'roomData'=>$roomData,'bedData'=>$bedData));
		}
		//BOF ids of rgjay
		$this->loadModel('TariffStandard');
		$rgjayPrivate = $this->TariffStandard->getTariffStandardID('rgjay_private_as_on_today');
		$rgjay = $this->TariffStandard->getTariffStandardID('rgjay');
		$this->set(array('rgjayPrivate'=>$rgjayPrivate,'rgjay'=>$rgjay));
		//EOF ids rgjay by pankaj
		//$this->set('moveBack',$this->referer());
		$wards= $this->Ward->find('list',array('conditions'=>array('Ward.is_deleted'=>0)));
		$this->set('wards',$wards);	
	}

	function patient_transfer($patient_id=null,$wardOR=null,$opt_appt_id=null){
		/* if($this->request->data){
			debug($this->request->data);exit;
		} */

		$this->layout = false ;
		$this->uses = array('Configuration','Room','WardPatient','Patient','Bed','OptPatient','OptTable','OptAppointment','User','Message');
		$this->set('transfer','');

		$wardList = $this->Ward->find('list',array('fields'=>array('name'),'conditions'=>array('Ward.location_id'=>$this->Session->read('locationid'))));
		$this->set('wardOR',$wardOR);
		$this->set('opt_appt_id',$opt_appt_id);

		$this->set('authPerson',$this->User->getUsersByRoleName(Configure :: read('businessHead')));

		if($patient_id){
			 

			$this->Room->bindModel(array(
					'hasMany' => array(
							'Bed'=>array())),false);
				
			$this->Bed->bindModel(array(
					'belongsTo' => array('Room'=>array('foreignKey'=>'room_id','type'=>'inner'),
							'Patient'=>array('foreignKey'=>'patient_id','type'=>'left','fields'=>array('Patient.id','lookup_name','patient_id','admission_id','bed_id','age',
									'sex','is_discharge')),
							'Diagnosis'=>array('fields'=>array('Diagnosis.final_diagnosis'),'foreignKey'=>false,'conditions'=>array('Diagnosis.patient_id=Patient.id'))),
					'hasMany'=>array('WardPatient'=>array('order'=>'WardPatient.id Desc','Limit'=>1,'WardPatient.is_deleted=0'))),false);
				
			$bedData = $this->Bed->Find('all',array('order'=>'Room.id Asc','conditions'=>array('Room.ward_id'=>$this->request->data['Ward']['ward_id'],
					'Room.location_id'=>$this->Session->read('locationid'))));
				

			$roomData = $this->Room->Find('all',array('fields'=>array('Room.name','Room.bed_prefix'),'conditions'=>array('Room.ward_id'=>$this->request->data['Ward']['ward_id'])));
				
			$this->Patient->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));

			$personDataId = $this->Patient->Find('first',array('fields'=>array('Patient.person_id','Patient.room_id','Patient.bed_id'),
					'conditions'=>array('Patient.id'=>$patient_id)));
				
			$wardDates = $this->WardPatient->find('first',array('conditions'=>array('WardPatient.patient_id'=>$patient_id),'order'=>array('WardPatient.id Desc')));

			$getRoom=$personDataId['Patient']['room_id'];
			$getBed=$personDataId['Patient']['bed_id'];
			$this->set('getRoom',$getRoom);
			$this->set('getBed',$getBed);
			$this->set('wardDates',$wardDates);
			$this->set(array('rooms'=>$roomData,'bedData'=>$bedData));
				
				
			$this->patient_info($patient_id);
		}
		//insert data
		if($this->request->data['Ward']['selectedBed']){
			 
			$ward_data=array();
			$this->WardPatient->id='';
			// check for readmitted patient id for ICU ward and then insert readmitted flag to 1 and readmittedtimediff//
			$this->WardPatient->bindModel(array('belongsTo'=>array('Ward'=>array('foreignKey'=> 'ward_id'))));
			$getReadmittedPatient = $this->WardPatient->find('first', array('conditions' => array('WardPatient.ward_id' => $this->request->data['Ward']['ward_id'], 
					'WardPatient.patient_id' =>$this->request->data['Ward']['patient_id'], 'WardPatient.location_id' => $this->Session->read('locationid'),
					'WardPatient.is_deleted=0'), 'order' => array('WardPatient.out_date '=> 'DESC')));
			if($getReadmittedPatient['Ward']['name'] == 'ICU') {
				$timeDate1 = strtotime($getReadmittedPatient['WardPatient']['out_date']);
				$timeDate2 = strtotime(date("Y-m-d H:i:s"));
				$timeInterval = $timeDate2-$timeDate1;
				$timeHours = round( $timeInterval / 3600 );
				$ward_data['readmitted'] = 1;
				$ward_data['readmitted_timediff'] = $timeHours;

			}
			// end //
			$splitSel = explode("_",$this->request->data['Ward']['selectedBed']);
			$ward_data['location_id']=$this->Session->read('locationid');
			$ward_data['patient_id']=$this->request->data['Ward']['patient_id'];
			$ward_data['ward_id']=$this->request->data['Ward']['ward_id'];
			$ward_data['room_id']=$splitSel[0];
			$ward_data['bed_id']=$splitSel[1];

			$ward_data['in_date']=$this->request->data['Ward']['in_date'];
			if(!empty($this->request->data['Ward']['in_date'])){
				$ward_data['in_date'] = $this->DateFormat->formatDate2STD($ward_data['in_date'],Configure::read('date_format'));
			}else{
				$ward_data['in_date'] = date('Y-m-d H:i:s');
			}


			$ward_data['created_by']=$this->Session->read('userid');
			$ward_data['create_time']=date('Y-m-d H:i:s');
			 
			//update already existed record which has the empty outdate
			$lastPatient = $this->WardPatient->find('first',array('fields'=>array('WardPatient.id'),'conditions'=>array('WardPatient.is_deleted=0','out_date'=>'','WardPatient.patient_id'=>$this->request->data['Ward']['patient_id']),'order'=>'WardPatient.id Desc'));
			$this->WardPatient->updateAll(array('out_date'=>"'".$ward_data['in_date']."'"),array('WardPatient.id'=>$lastPatient['WardPatient']['id']));
			$this->WardPatient->id = '';
			//EOF updating wardPatient outdate
			$ward_data['ward_name']=$this->request->data['Ward']['ward_name'];
			$ward_data['bednameforSms']=$this->request->data['Ward']['bednameforSms'];
			$ward_data['optDashdoard']=$this->request->data['Ward']['optDashdoard'];
			$ward_data['tariff_list_id'] = $this->Ward->getTariffListID($this->request->data['Ward']['ward_id']) ;
			 
			if($this->WardPatient->save($ward_data)){ 
				//update bed table
				$this->Bed->recursive = -1;
				$this->Bed->updateAll(array('Bed.patient_id'=>0,'Bed.released_date'=>"'".date('Y-m-d H:i:s')."'",'Bed.is_released'=>1),array('Bed.patient_id'=>$this->request->data['Ward']['patient_id']));
				$this->Bed->id = $splitSel[1];
				$this->Bed->save(array('patient_id'=>$this->request->data['Ward']['patient_id'],'Bed.released_date'=>'')); // also  set released date to null if already has any date for previous patients
				//$this->Patient->id = $this->request->data['Ward']['patient_id'];
				
				//for vadodara first day charge posting
				if($this->Session->read('website.instance')=='vadodara'){
					$this->loadModel('WardPatientService');
					$personDataId = $this->Patient->Find('first',array('fields'=>array('Patient.tariff_standard_id','Patient.room_id','Patient.bed_id'),
							'conditions'=>array('Patient.id'=>$this->request->data['Ward']['patient_id'])));
					 
					if($personDataId['Patient']['room_id']=='' && $personDataId['Patient']['bed_id'] =='') { //for the first time post ward charges
						$this->WardPatientService->postWardChargeForVadodara(array(
								'date'=>$this->request->data['Ward']['in_date'],
								'location_id'=>$this->Session->read('locationid'),
								'tariff_list_id'=>$this->Ward->getTariffListID($this->request->data['Ward']['ward_id']),
								'tariff_standard_id'=>$personDataId['Patient']['tariff_standard_id'],//no need to add this
								'create_time'=>date('Y-m-d H:i:s'),
								'created_by'=>2,//as system user
								'patient_id'=>$this->request->data['Ward']['patient_id'],
								'ward_id'=>$this->request->data['Ward']['ward_id'],
								'room_id'=>$splitSel[0]
						));
					}
				}
				
				
				$this->Patient->updateAll(array('ward_id'=>$this->request->data['Ward']['ward_id'],'room_id'=>$splitSel[0],'bed_id'=>$splitSel[1]),array('Patient.id'=>$this->request->data['Ward']['patient_id']));
				//$this->Patient->save(array('id'=>$this->request->data['Ward']['patient_id'],'ward_id'=>$this->request->data['Ward']['ward_id'],'room_id'=>$splitSel[0],'bed_id'=>$splitSel[1]));
				$this->set('transfer','done');
				/***BOF-Mahalaxmi-Sending SMS to Physician***/
				$smsActive=$this->Configuration->getConfigSmsValue('Bed Transfer');	
				
	 			if($smsActive){
					$this->Patient->bindModel(array(
						'belongsTo' => array(	
							'Ward' =>array('foreignKey' => false,'conditions'=>array('Ward.id=Patient.ward_id' )),
							'Room' =>array('foreignKey' => false,'conditions'=>array('Room.id=Patient.room_id' )),
							'Bed' =>array('foreignKey' => false,'conditions'=>array('Bed.id=Patient.bed_id' )),
							'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),	
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id')),
						)));
					$getPersonIdnew=$this->Patient->find('first',array('fields'=>array('TariffStandard.name','Patient.person_id','Patient.lookup_name','Patient.sex','Patient.age','User.mobile','Room.name','Bed.id','Room.bed_prefix','Bed.bedno','Ward.name'),'conditions'=>array('Patient.id'=>$patient_id)));
					$getAgeResultSms=$this->General->convertYearsMonthsToDaysSeparate($getPersonIdnew['Patient']['age']);
					$getSexPatient=strtoUpper(substr($getPersonIdnew['Patient']['sex'],0,1));
					if($ward_data['optDashdoard']=='optDashdoard'){
						$this->Patient->sendToSmsPhysicianFromOrToWard($getPersonIdnew['Patient']['person_id'],'OR',$this->request->data['Ward']['opt_appointment_id']);
						$this->Patient->sendToSmsPhysicianFromOrToWard($getPersonIdnew['Patient']['person_id'],'ORPatientRalative',$this->request->data['Ward']['opt_appointment_id']);
					}else{						
					/***BOF-This below bind used for existing details compared fields***///
					$this->Room->bindModel(array(
						'belongsTo'=>array(
							'Ward' =>array('foreignKey' => false,'conditions'=>array('Ward.id=Room.ward_id' )),
							'Bed' =>array('foreignKey' => false,'conditions'=>array('Bed.room_id=Room.id' ))
					)));
					$roomData = $this->Room->find('first',array('fields'=>array('Room.name','Bed.id','Room.bed_prefix','Bed.bedno','Ward.name'),'conditions'=>array('Bed.id'=>$ward_data['bednameforSms'])));	
				
					/***EOF-This below bind used for existing details compared fields***///
						$showMsgRefDoc= sprintf(Configure::read('bedTransfer'),$getPersonIdnew['TariffStandard']['name'],$getPersonIdnew['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms,trim($roomData['Ward']['name']),$roomData['Room']['bed_prefix'],$roomData['Bed']['bedno'],trim($getPersonIdnew['Ward']['name']),$getPersonIdnew['Room']['bed_prefix'],$getPersonIdnew['Bed']['bedno'],Configure::read('hosp_details'));
						
						$this->Message->sendToSms($showMsgRefDoc,$getPersonIdnew['User']['mobile']); //for admit to send SMS to Physicians.	
						//$this->Patient->sendToSmsPhysicianFromWard($getPersonIdnew['Patient']['person_id'],'room',$ward_data['bednameforSms']);
					}
				}
				
				/***EOF-Mahalaxmi-Sending SMS to Physician***/
				// Following if case added for Session Message because this function used for Bed allocation and patient transfer - Atul
				if($this->params->pass[1]=='allot'){
					$this->Session->setFlash(__('Bed Alloted successfully'),'default',array('class'=>'message'));
					echo "<script> parent.location.reload();parent.$.fancybox.close();</script>" ;
					
				}else{
				     $this->Session->setFlash(__('Patient transfer successfully'),'default',array('class'=>'message'));
				    echo "<script> parent.location.reload();parent.$.fancybox.close();</script>" ;
				}
				// End  If
			}else{
				$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			}
		}
		$params = $this->params->query['from'];
		if($params == 'optDashdoard') {
			$this->set('optDashdoard',$params);
		}
		if($this->request->data['Ward']['optDashdoard']) {
			//$this->OptPatient->updateAll(array('out_time'=>"'".date('Y-m-d H:i:s')."'"),array('OptPatient.opt_appointment_id'=>$this->request->data['Ward']['opt_appointment_id']));
			$this->OptAppointment->updateAll(array('OptAppointment.out_time'=>"'".date('Y-m-d H:i:s')."'"),array('OptAppointment.id'=>$this->request->data['Ward']['opt_appointment_id']));
			$this->OptTable->updateAll(array('patient_id'=>0,'released_date'=>"'".date('Y-m-d H:i:s')."'",'OptTable.is_released'=>0,'modify_time'=>"'".date('Y-m-d H:i:s')."'"),array('OptTable.opt_appointment_id'=>$this->request->data['Ward']['opt_appointment_id']));
			$this->Patient->updateAll(array('opt_id'=>'0','ot_table_id'=>'0'),array('Patient.id'=>$this->request->data['Ward']['patient_id']));
		}

		$this->set(array('wardList'=>$wardList,'patient_id'=>$patient_id));
	}
	/**
	 * @author Swati Newale
	 * function for approval request of change word to general
	 * @return number
	 */
	public function requestForApproval()
	{
		$this->autoRender = false;
		$this->layout = false;
		$this->loadModel("ApproveRequest");
		$this->request->data['type']= 'Ward Transfer';
		$this->ApproveRequest->saveRequest($this->request->data);
		return '1';
	}
	/**
	 * Cancelling request by Bussiness head
	 * @ author : Swati Newale.
	 */
	
	public function cancelApproval()
	{  
		$this->loadModel("ApproveRequest");
		$this->autoRender = false;
		$this->layout = false;
		$this->request->data['type'] = 'Ward Transfer';
		$this->ApproveRequest->deleteRequest($this->request->data);
	}
	/**
	 * approval by Bussiness head
	 * @ author : Swati Newale.
	 */
	public function Resultofrequest()
	{
		$this->autoRender = false;
		$this->layout = false;
		$this->loadModel("ApproveRequest");
		
		$result = $this->ApproveRequest->find('first',array(
				'conditions'=>array('ApproveRequest.patient_id'=>$this->request->data['patient_id'],
						 'ApproveRequest.type'=>'Ward Transfer', 
						'ApproveRequest.is_deleted'=>0,
						),
				'order'=>array('ApproveRequest.id'=>"DESC")
		)); 
		return $result['ApproveRequest']['is_approved'];
	}
	function ward_management(){
		$this->layout='advance';
		
		$this->Ward->recursive =-1;	
		$this->uses=array('Ward','Room','Bed');
		if($this->Session->read('website.instance')!='vadodara'){
			$this->params->query['ward']='Select All';
		}
		if($this->params->query){
			$this->Bed->bindModel(array(
					'belongsTo' => array(
							'Room'=>array('foreignKey'=>'room_id','type'=>'inner'),
							'Ward'=>array('foreignKey'=>false,'conditions'=>array('Ward.id=Room.ward_id'),'type'=>'inner'),
							'Patient'=>array('foreignKey'=>'patient_id','fields'=>array('Patient.id','CONCAT(PatientInitial.name," ",Patient.lookup_name) as lookup_name','patient_id','doctor_id','admission_id','bed_id','age','credit_type_id','sex'),'conditions'=>array('Patient.is_deleted=0')),
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
							'Corporate' =>array('foreignKey' => false,'conditions'=>array('Corporate.id =Patient.corporate_id')),
							// 'InsuranceCompany' =>array('foreignKey' => false,'conditions'=>array('InsuranceCompany.id =Patient.insurance_company_id')),
							'DoctorProfile' =>array('foreignKey' => false,'conditions'=>array('DoctorProfile.user_id =Patient.doctor_id')),
							'NoteDiagnosis' =>array('foreignKey' => false,'conditions'=>array('NoteDiagnosis.patient_id =Patient.id')),
							'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id =Patient.tariff_standard_id')),
							 							
					)
					/*,'hasMany'=>array('WardPatient'=>array('order'=>'WardPatient.id Desc','Limit'=>1,'WardPatient.is_deleted=0'))*/
				),false);
			$condition=array();
			if($this->params->query['room']){
				$condition['Bed.room_id']=$this->params->query['room'];				
			}
			 
			if($this->params->query['ward']=='Select All'){
				$condition=array();
			}else{
				$condition['Ward.id']=$this->params->query['ward'];
			}
			
			//added by pankaj 
			if($this->params->query['tariff_standard_id'] != ''){
				$condition['Patient.tariff_standard_id']= $this->params->query['tariff_standard_id'] ;
			}
			$detailData = $this->Bed->find('all',array('fields'=>array('Person.id','Patient.id','Patient.lookup_name','Patient.admission_id',
					'Ward.name','Room.name','Patient.treatment_type','Ward.id','room_id','Bed.patient_id','Bed.id','Room.bed_prefix',
					'Bed.bedno','DoctorProfile.doctor_name','NoteDiagnosis.diagnoses_name','TariffStandard.name','Bed.under_maintenance',
					'Bed.is_released','Patient.patient_id','Patient.sex','Person.district','Patient.age'),
					'conditions'=>array('Ward.is_deleted'=>0,
					'Ward.location_id'=>$this->Session->read('locationid'),$condition
							),
					'order'=>array('Ward.id','Bed.id'),
					));
			 
			$this->set(array('detailData'=>$detailData));
			$this->set(array('data'=>$detailData));
			if($this->params->pass[0]=='print'){
				$this->layout = 'print_without_header';
				$this->render('ward_occupancy_print');
			}
		}
		$wardData = $this->Ward->find('list',array('fields'=>array('id','name'),'conditions'=>array('Ward.location_id'=>$this->Session->read('locationid'))));
		$this->set('wardData',$wardData);
		
		foreach($wardData as $wkey=>$wards){
			$roomData[$wards] =  $this->Room->find('list',array('fields'=>array('id','name'),
					'conditions'=>array('Room.ward_id'=>$wkey,'Room.location_id'=>$this->Session->read('locationid'))));
		
		
		}
		$rooms=$this->Room->find('list',array('fields'=>array('id','name'),
				'conditions'=>array('Room.location_id'=>$this->Session->read('locationid'))));// for selction on search
		$this->set('roomData',$roomData);
		$this->set('rooms',$rooms);
		
	}
	
	function patient_note($patient_id=null){
		$this->layout= false ;
		$this->patient_info($patient_id);
		$this->uses = array('Note');
		if(!empty($this->request->data['Note'])){

			if($this->request->data['Note']['id']){
				$this->Note->id = $this->request->data['Note']['id'] ;
			}
			$wardArray['note']  = $this->request->data['Note']['note'];
			$wardArray['patient_id']  = $this->request->data['Note']['patient_id'];
			$wardArray['note_type']  = 'ward';
			if($this->Note->save($wardArray)){
				$this->Session->setFlash(__('Note added successfully'),'default',array('class'=>'message'));
				echo "<script> parent.location.reload();parent.$.fancybox.close();</script>" ;
			}else{
				$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
				$this->redirect($this->referer());
			}
		}
		if($patient_id){
			$this->data = $this->Note->find('first',array('conditions'=>array('Note.patient_id'=>$patient_id,'Note.note_type'=>'ward'),'fields'=>array('Note.id','Note.note')));

			$this->set('patient_id',$patient_id);
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			echo "<script> parent.location.reload();parent.$.fancybox.close();</script>" ;
		}
	}

	//function to released bed after discharge
	function release_bed($bed_id=null){
		$this->uses =array('Bed');
		if($bed_id){
			$this->Bed->id = $bed_id ;
			$this->Bed->Save(array("is_released"=>0,'released_date'=>date('Y-m-d H:i:s')));
			$this->Session->setFlash(__('Bed released successfully'),true,array('class'=>'message'));
			$this->redirect($this->referer());
		}else{
			$this->Session->setFlash(__('Please try again'),true,array('class'=>'error'));
			$this->redirect($this->referer());
		}
	}
	//EOF pankaj
	/**
	@Name : generate_ward_id
	@created By : Anand
	@created On : 4/18/2012
	@Note : This function get called on ajax request
	**/
	function genrate_ward_id(){
		$this->uses =array('Location');
		$this->layout = 'ajax';
		$this->autoRender=false;
		if(!empty($this->params['pass'][0])){
			$data = $this->params['pass'][0];
			// Ward Id Will be-> Fist THree letter of Ward plus location first two letter and three random number
			// Get he hospitla to add in Id
			#$hospital = $this->Location->read('Facility.name,Location.name',$this->Session->read('locationid'));
			$facility = $this->Session->read('facility');
			$ward_id = ucfirst(substr($data, 0,3)).ucfirst(substr($facility,0,3)).substr('12345' . rand(1, 9999), -3);
			return strtoupper($ward_id);
		}
	}

	function ward_overview(){
		$this->layout = false ;
		$this->uses = array('Room','Bed','WardPatient');
		$this->Bed->bindModel(array(
				'belongsTo' => array('Room'=>array('foreignKey'=>'room_id','type'=>'inner'),'Ward'=>array('foreignKey'=>false,'conditions'=>array('Ward.id=Room.ward_id'),'type'=>'inner'),
						'Patient'=>array('foreignKey'=>'patient_id','type'=>'left','fields'=>array('Patient.id','lookup_name','patient_id','admission_id','bed_id','age',
								'sex','is_discharge'),'conditions'=>array('Patient.is_deleted=0')),
						'Diagnosis'=>array('fields'=>array('Diagnosis.final_diagnosis'),'foreignKey'=>false,'conditions'=>array('Diagnosis.patient_id=Patient.id'))),
				'hasMany'=>array('WardPatient'=>array('conditions'=>array('WardPatient.is_discharge=1','WardPatient.is_deleted=0'),'order'=>'WardPatient.id Desc','Limit'=>1))),false);
			
		$bedData = $this->Bed->Find('all',array('order'=>'Room.id Asc','conditions'=>array('Ward.location_id'=>$this->Session->read('locationid'))));
		$wardData = $this->Ward->find('all',array('fields'=>'name,id','conditions'=>array('Ward.location_id'=>$this->Session->read('locationid'))));
		$roomData = $this->Room->find('all',array('fields'=>'name,id','conditions'=>array('Room.location_id'=>$this->Session->read('locationid'))));
			

		$this->set(array('wardData'=>$wardData,'roomData'=>$roomData,'bedData'=>$bedData));
	}

	//BOF pankaj
	//also used in lab and radiology controller
	function getServiceGroup($id=null){
		$this->layout= 'ajax' ;
		$this->autoRender = false ;
		$this->uses = array('TariffList');
		$list = $this->TariffList->getServiceByGroupId($id);//dpr($list);exit;
		//debug($list);exit;
		//echo  json_encode(array_walk($list,str_replace("","",)));//exit;
		#dpr($list);
		if(count($list) > 0)
			echo json_encode($list);
		else
			return ;
		//exit;
	}

	function getCorporateInsuranceByPatientID($credit_type_id,$corporate_id){
		$this->uses = array('Corporate','InsuranceCompany');
		if($credit_type_id == 1){
			$corporate_list = $this->Corporate->getCorporateByID($corporate_id);
			$corporate = $corporate_list['Corporate']['name'] ;
		} else if($credit_type_id == 2){
			$corporate_list = $this->InsuranceCompany->getInsuranceCompanyByID($corporate_id);
			$corporate = $corporate_list['InsuranceCompany']['name'] ;
		} else if($credit_type_id == 0){
			$corporate = 'Private';
		}

	}
	//EOF pankaj
	public function optPatients($patient_id=null,$opt_appt_id=null){
		$this->layout = 'advance_ajax' ;
		$this->set('patient_id',$patient_id);
		$this->set('opt_appt_id',$opt_appt_id);

		/* if(($this->request->data)){
			debug($this->request->data);exit;
		} */
		$this->uses = array('Opt','OptTable','Surgery','OptPatient','OptAppointment');
		$this->patient_info($patient_id);
		$otRooms = $this->Opt->find('list',array('fields'=>array('id','name'),
				'conditions'=>array('Opt.is_deleted' => 0,'Opt.location_id' => $this->Session->read("locationid"))));

		$this->Opt->bindModel(array(
				'hasMany' => array(
						'OptTable'=>array())),false);

		$otTable = $this->Opt->find('all',array('fields'=>array('Opt.id','Opt.name'),
				'conditions'=>array('Opt.is_deleted' => 0,'Opt.location_id' => $this->Session->read("locationid"))));
		$this->Surgery->bindModel(array('hasOne' => array('OptAppointment' =>array('foreignKey' => 'surgery_id'))));
		$surgeries = $this->Surgery->find('list', array('conditions' => array('Surgery.location_id' => $this->Session->read('locationid'), 'Surgery.is_deleted' => 0, 'OptAppointment.patient_id' => $patient_id), 'recursive' => 1));

		$this->set(array('otRooms'=>$otRooms,'otTable'=>$otTable,'surgeries'=>$surgeries));
		//insert data
		if($this->request->data['OptPatient']){
			$optData = $this->OptPatient->find('first',array('fields'=>array('OptPatient.id','OptPatient.patient_id'),'conditions'=>array('out_time'=>'','OptPatient.patient_id'=>$this->request->data['OptPatient']['patient_id']),'order'=>'OptPatient.id Desc'));
			$optID = explode('_', $this->request->data['Ward']['selectedBed']);
			if(empty($optData['OptPatient']['patient_id'])){
				/* $this->request->data['OptPatient']['opt_id']=$optID['0'];
				 $this->request->data['OptPatient']['opt_table_id']=$optID['1'];
				$this->request->data['OptPatient']['location_id']=$this->Session->read('locationid');
				$this->request->data['OptPatient']['created_by']=$this->Session->read('userid');
				$this->request->data['OptPatient']['create_time']=date("Y-m-d H:i:s");
				$this->request->data['OptPatient']['modified_by']=$this->Session->read('userid');
				$this->request->data['OptPatient']['modify_time']=date("Y-m-d H:i:s");
				$this->request->data['OptPatient']['in_time']=$this->DateFormat->formatDate2STD($this->request->data['OptPatient']['in_time'],Configure::read('date_format')); */
				//debug($this->request->data['OptPatient']);exit;
				//$this->OptPatient->save($this->request->data['OptPatient']);

				$this->OptTable->updateAll(array('patient_id'=>"'".$this->request->data['OptPatient']['patient_id']."'",'opt_appointment_id'=>"'".$this->request->data['OptPatient']['opt_appointment_id']."'",'OptTable.is_released'=>1,'modify_time'=>"'".date('Y-m-d H:i:s')."'"),array('OptTable.id'=>$optID['1']));
				$this->Patient->updateAll(array('opt_id'=>$optID['0'],'ot_table_id'=>$optID[1]),array('Patient.id'=>$this->request->data['OptPatient']['patient_id']));
				$this->OptAppointment->updateAll(array('OptAppointment.opt_table_id'=>"'".$optID[1]."'",'OptAppointment.opt_id'=>"'".$optID['0']."'",'OptAppointment.ot_in_time'=>"'".date('Y-m-d H:i:s')."'"),array('OptAppointment.id'=>$this->request->data['OptPatient']['opt_appointment_id']));
				$var=true;
			}else{
				$this->OptAppointment->updateAll(array('OptAppointment.out_time'=>"'".date('Y-m-d H:i:s')."'"),array('OptAppointment.id'=>$this->request->data['OptPatient']['opt_appointment_id']));
				$this->OptTable->updateAll(array('OptTable.patient_id'=>'0','OptTable.released_date'=>"'".date('Y-m-d H:i:s')."'",'OptTable.is_released'=>1,'modify_time'=>"'".date('Y-m-d H:i:s')."'"),array('OptTable.opt_appointment_id'=>$this->request->data['OptPatient']['opt_appointment_id']));
				$this->Patient->updateAll(array('opt_id'=>$optID['0'],'ot_table_id'=>$optID[1]),array('Patient.id'=>$this->request->data['OptPatient']['patient_id'])); 
				$var=true;
			} 
			if($var=true){
				$this->Session->setFlash(__('Patient transfer successfully'),'default',array('class'=>'message'));
				echo "<script> parent.location.reload();parent.$.fancybox.close();</script>" ;
			}else{
				$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			}
		}
	}
	
	//display the list of all non allocated patient to nurse (Those patients are regsiterd with ward only)
	function bed_allocation(){  
		$this->layout = 'advance' ;
		$this->uses = array('Patient') ;
		$this->Patient->bindModel(array('belongsTo'=>array('Ward'=>array('foreignKey'=>'ward_id'))),false);
       
		if(isset($this->request->query['patient_name']) && !empty($this->request->query['patient_name'])){
			$patientName=explode('-',$this->request->query['patient_name']);
			$condition['Patient.lookup_name LIKE'] =  "%".$patientName[0]."%";
		}
		
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'fields'=>array('Ward.name','Patient.lookup_name','Patient.id','Patient.admission_id','Patient.patient_id'),
				'order' => array(
						'Patient.id' => 'desc'
				),
				'conditions'=>array('Patient.admission_type'=>'IPD','Patient.is_deleted'=>0,'is_discharge'=>0,'Patient.room_id IS NULL','Patient.bed_id IS NULL',$condition)
		);
		
		
		$this->set('patientData',$this->paginate('Patient'));
		 
	}

	function newWardManagement(){
		$this->layout='advance';	
		$this->uses=array('Ward','Room','Bed');
		if($this->params->query){
			$this->Bed->bindModel(array(
					'belongsTo' => array(
							'Room'=>array('foreignKey'=>'room_id','type'=>'inner'),
							'Ward'=>array('foreignKey'=>false,'conditions'=>array('Ward.id=Room.ward_id'),'type'=>'inner'),
							'Patient'=>array('foreignKey'=>'patient_id','fields'=>array('Patient.id','CONCAT(PatientInitial.name," ",Patient.lookup_name) as lookup_name','patient_id','doctor_id','admission_id','bed_id','age','credit_type_id','sex'),'conditions'=>array('Patient.is_deleted=0')),
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
							'Corporate' =>array('foreignKey' => false,'conditions'=>array('Corporate.id =Patient.corporate_id')),
							// 'InsuranceCompany' =>array('foreignKey' => false,'conditions'=>array('InsuranceCompany.id =Patient.insurance_company_id')),
							'DoctorProfile' =>array('foreignKey' => false,'conditions'=>array('DoctorProfile.user_id =Patient.doctor_id')),
							'NoteDiagnosis' =>array('foreignKey' => false,'conditions'=>array('NoteDiagnosis.patient_id =Patient.id')),
							'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id =Patient.tariff_standard_id')),
					)
					,'hasMany'=>array('WardPatient'=>array('order'=>'WardPatient.id Desc','Limit'=>1,'WardPatient.is_deleted=0'))),false);
			$condition=array();
			if($this->params->query['room']){
				$condition['Bed.room_id']=$this->params->query['room'];				
			}
			if($this->params->query['ward']=='Select All'){
				$condition=array();
			}else{
				$condition['Ward.id']=$this->params->query['ward'];
			}
			$detailData = $this->Bed->find('all',array('fields'=>array('Person.id','Patient.id','Patient.lookup_name','Patient.admission_id',
					'Ward.name','Room.name','Patient.treatment_type','Ward.id','room_id','Bed.patient_id','Bed.id','Room.bed_prefix',
					'Bed.bedno','DoctorProfile.doctor_name','NoteDiagnosis.diagnoses_name','TariffStandard.name','Bed.under_maintenance',
					'Bed.is_released','Patient.patient_id','Patient.sex','Person.district','Patient.age'),
					'conditions'=>array('Ward.is_deleted'=>0,
					'Ward.location_id'=>$this->Session->read('locationid'),$condition
							),
					'order'=>array('Ward.sort_order','Bed.id'),
					));
			$this->set(array('detailData'=>$detailData));
			$this->set(array('data'=>$detailData));
			if($this->params->pass[0]=='print'){
				$this->layout = 'print_without_header';
				$this->render('ward_occupancy_print');
			}
		}
		$wardData = $this->Ward->find('list',array('fields'=>array('id','name'),'conditions'=>array('Ward.location_id'=>$this->Session->read('locationid'))));
		$this->set('wardData',$wardData);
		
		foreach($wardData as $wkey=>$wards){
			$roomData[$wards] =  $this->Room->find('list',array('fields'=>array('id','name'),
					'conditions'=>array('Room.ward_id'=>$wkey,'Room.location_id'=>$this->Session->read('locationid'))));
		
		
		}
		$this->set('roomData',$roomData);
		
		}
		
		//function to vacant existing bed for chemo patients for vadodara only.
		function vacantBed($patient_id=null,$bed_id=null){
			if(empty($patient_id) || empty($bed_id)) {
				$this->Session->setFlash(__('There is something wrong with your request, Please try again'),'default',array('class'=>'error'));
				$this->redirect($this->referer());
			} 
			$this->uses = array('Patient','WardPatient','Bed'); 
			$this->WardPatient->updateAll(array('is_deleted'=>1),array('WardPatient.patient_id'=>$patient_id));
			$this->Patient->updateAll(array('Patient.bed_id'=>null,'Patient.room_id'=>null),array('Patient.id'=>$patient_id));
			$this->Bed->updateAll(array('Bed.patient_id'=>0,'Bed.is_released'=>0,'Bed.released_date'=>null),array('Bed.id'=>$bed_id,'Bed.patient_id'=>$patient_id));
			$this->redirect($this->referer());
		} 
function bedDashboard(){
		$this->uses = array('Room','Bed','Ward','Location');
		
		$this->set('wardName','Location');
		$location = $this->Location->find('first', array('fields'=> array('Location.id'),'conditions'=>array('Location.is_active' => 1, 'Location.is_deleted' => 0,'Location.created_by'=>0)));
		$this->params->query['Location'] = $location['Location']['id'];
		$this->set('location',$location);
		$wards= $this->Ward->find('list',array('conditions'=>array('Ward.is_deleted'=>0,'Ward.location_id'=>$this->params->query['Location'])));
		$this->set('wards',$wards);
		
			$this->data = $this->params->query ;
			$this->Room->bindModel(array(
					'belongsTo' => array(
							'Ward'=>array('foreignKey'=>false,'conditions'=>array('Ward.id=Room.ward_id')))),false);
		
			$this->Bed->bindModel(array(
					'belongsTo' => array(
							'Room'=>array('foreignKey'=>'room_id','type'=>'inner'),
							'Ward'=>array('foreignKey'=>false,'conditions'=>array('Ward.id=Room.ward_id'),'type'=>'inner'),
							'Patient'=>array('foreignKey'=>'patient_id','type'=>'left','fields'=>array('Patient.id','lookup_name','patient_id',
									'admission_id','bed_id','age','form_received_on','sex','is_discharge'),'conditions'=>array('Patient.is_deleted=0')),
							'EstimateConsultantBilling'=>array('foreignKey'=>false,'conditions'=>array('EstimateConsultantBilling.patient_id = Bed.patient_id'),
									'fields'=>array('EstimateConsultantBilling.id')),
							'PackageEstimate'=>array('foreignKey'=>false,'fields'=>array('no_of_days','days_in_icu'),
									'conditions'=>array('PackageEstimate.id = EstimateConsultantBilling.package_estimate_id')),
							'Person' =>array('foreignKey' => false,'fields'=>array('Person.id','sex','dob','initial_id','age'),
									'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id'), 
									'fields' => array('PatientInitial.name')),
							'Location' => array('foreignKey' => false,'conditions'=>array('Location.id =Person.location_id'), 
									'fields' => array('Location.name'))),
						    'hasMany'=>array('WardPatient'=>array('order'=>'WardPatient.id Desc','Limit'=>1,'WardPatient.is_deleted=0'))),false);
			$bedData = $this->Bed->Find('all',array('order'=>'Room.id Asc','conditions'=>array('Room.location_id'=>$this->params->query['Location'])));
			$roomData = $this->Room->Find('all',array('fields'=>array('Room.name','Room.bed_prefix','Room.location_id','Room.ward_id','Ward.name'),
					'conditions'=>array('Room.location_id'=>$this->params->query['Location'],'Room.ward_id'=>array_keys($wards))));
		   
			$this->set(array('rooms'=>$roomData,'bedData'=>$bedData,'wardName'=>$wardName['Ward']['name']));
		
		
	}
	
	//function to return rgjay and rgjay (as on today)
	function rgjay_patients(){
		$this->layout='advance';
		$this->Ward->recursive =-1;
		$this->uses=array('Ward','Room','Bed','ServiceCategory','Diagnosis');
		if($this->Session->read('website.instance')!='vadodara'){
			$this->params->query['ward']='Select All';
		}
		$rgjayPackage = $this->ServiceCategory->getServiceGroupIdFromAlias('RGJAY Package');
		$condition=array();
		if($this->params->query){
			
			if($this->params->query['is_discharge']==1 && isset($this->params->query['patient_name'])){
				$patientName=explode('-',$this->params->query['patient_name']);
				$condition['Patient.lookup_name LIKE'] =  "%".$patientName[0]."%";
			 	$condition['Patient.is_discharge']=1;
		
			 	
			 }else if(isset($this->params->query['patient_name'])){
			 	$patientName=explode('-',$this->params->query['patient_name']);
			 	$condition['Patient.lookup_name LIKE'] =  "%".$patientName[0]."%";
			 	$condition['Patient.is_discharge']='0';
			 	
			}else{
			 	$condition['Patient.is_discharge']='0';
			}
			
			$this->Bed->bindModel(array(
					'belongsTo' => array(
							'Room'=>array('foreignKey'=>'room_id','type'=>'inner'),
							'Ward'=>array('foreignKey'=>false,'conditions'=>array('Ward.id=Room.ward_id'),'type'=>'inner'),
							'Patient'=>array('type'=>'inner','foreignKey'=>'patient_id','fields'=>array('Patient.id','CONCAT(PatientInitial.name," ",Patient.lookup_name) as lookup_name','patient_id','doctor_id','admission_id','bed_id','age','credit_type_id','sex'),'conditions'=>array('Patient.is_deleted=0')),
							'Person' =>array('type'=>'inner','foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
  							'DoctorProfile' =>array('type'=>'inner','foreignKey' => false,'conditions'=>array('DoctorProfile.user_id =Patient.doctor_id')),
 							'TariffStandard' =>array('type'=>'inner','foreignKey' => false,'conditions'=>array('TariffStandard.id =Patient.tariff_standard_id')),
							'ServiceBill' =>array('foreignKey' => false,'conditions'=>array('ServiceBill.patient_id =Patient.id','ServiceBill.service_id='.$rgjayPackage)),
							'TariffList' =>array('foreignKey' => false,'conditions'=>array('TariffList.id =ServiceBill.tariff_list_id')),
							'Diagnosis' =>array('foreignKey' => false,'conditions'=>array('Diagnosis.patient_id =Patient.id'))
					)),false);
			
			if($this->params->query['tariff_standard_id']){
				$condition['Patient.tariff_standard_id']=$this->params->query['tariff_standard_id'];
			}
			 
			$detailData = $this->Bed->find('all',array('fields'=>array('Person.id','Patient.id','Patient.lookup_name','Patient.admission_id',
					'Ward.name','Room.name','Patient.treatment_type','Ward.id','room_id','Bed.patient_id','Bed.id','Room.bed_prefix',
					'Bed.bedno','DoctorProfile.doctor_name','TariffStandard.id','TariffStandard.name','Bed.under_maintenance',
					'Bed.is_released','Patient.patient_id','Patient.sex','Person.district','Patient.age','TariffList.name','TariffList.id','ServiceBill.amount','Diagnosis.id','Diagnosis.final_diagnosis','Diagnosis.actual_diagnosis'),
					'conditions'=>array('Ward.is_deleted'=>0,
							'Ward.location_id'=>$this->Session->read('locationid'),$condition
					),
					'group'=>array('Patient.id'),
					'order'=>array('Ward.sort_order','Bed.id'),
			));

	
			$this->set(array('detailData'=>$detailData));
			$this->set(array('data'=>$detailData));
			if($this->params->pass[0]=='print'){
				$this->layout = 'print_without_header';
				$this->render('ward_occupancy_print');
			}
		}
		$wardData = $this->Ward->find('list',array('fields'=>array('id','name'),'conditions'=>array('Ward.location_id'=>$this->Session->read('locationid'))));
		$this->set('wardData',$wardData);
	
		foreach($wardData as $wkey=>$wards){
			$roomData[$wards] =  $this->Room->find('list',array('fields'=>array('id','name'),
					'conditions'=>array('Room.ward_id'=>$wkey,'Room.location_id'=>$this->Session->read('locationid'))));	
		}
		
		//$rgjayPackage = $this->ServiceCategory->getServiceGroupIdFromAlias('RGJAY Package');
		 
		$rooms=$this->Room->find('list',array('fields'=>array('id','name'),
				'conditions'=>array('Room.location_id'=>$this->Session->read('locationid'))));// for selction on search
		$this->set('roomData',$roomData);
		$this->set('rooms',$rooms);
		$this->set('rgjayPackage',$rgjayPackage);
	}
	
	//function to save service package for RGJAY patients
	function saveServicePackage($service_id=null,$patient_id=null){
		$this->layout = 'ajax' ;
		$this->autoRender  = false ;
		if($this->request->data['tariff_list_id'] && $patient_id){
			$this->loadModel('ServiceBill');
			$this->loadModel('TariffList'); 
			$serviceData = $this->TariffList->find('first',array('conditions'=>array('TariffList.id'=>$this->request->data['tariff_list_id'])));//find group id

			//check if package already added
			if(!empty($service_id)){
				$isExist = $this->ServiceBill->find('first',array('conditions'=>array('ServiceBill.patient_id'=>$patient_id,'ServiceBill.service_id'=>$service_id)));
			}
			$result  = $this->ServiceBill->save(array(
					'id'=>$isExist['ServiceBill']['id'],
					'patient_id'=>$patient_id,
					'tariff_list_id'=>$this->request->data['tariff_list_id'],
					'tariff_standard_id'=>$this->request->data['tariff_standard_id'],
					'service_id'=>$serviceData['TariffList']['service_category_id'],
					'date'=>date('Y-m-d H:i:s'),
					'location_id'=>1,
					'amount'=>$this->request->data['amount'],
					'no_of_times'=>1,
					'create_time'=>date('Y-m-d H:i:s'),
					'created_by'=>1	));
			if($result) return true ;
		}
		return false  ;
		exit;
	}
	
	/**
	 * Patients Ward Transaction history
	 * For new patient hub
	 * @param unknown_type $patient_id
	 * Pooja Gupta
	 */
	function patientWardTransaction($patient_id){
		$this->layout='ajax';
		$this->loadModel('WardPatient');
		$wardsArray = $this->WardPatient->getWardDetails($patient_id);
		$w = 0;
		foreach($wardsArray as $wardKey => $wardValue){//debug($wardValue);exit;
			if($currentWard != $wardValue['Ward']['name']) $w++;
			$resetWardArray[$w][$wardValue['Ward']['name']][] = $wardValue;
			$currentWard = $wardValue['Ward']['name'];
		}
		$this->set('wardDetails',$resetWardArray);
		$this->set('patient_id',$patient_id);
	}

	public function showInvestigations($packageId){
		$this->layout="advance_ajax";
		$this->uses = array('TariffList');
		$packageDetails=$this->TariffList->find('first',array('fields'=>array('TariffList.id','TariffList.pre_investigation','TariffList.post_investigation'),'conditions'=>array('TariffList.id'=>$packageId,'TariffList.is_deleted'=>0)));
		$this->set('packageDetails',$packageDetails);
	}
}