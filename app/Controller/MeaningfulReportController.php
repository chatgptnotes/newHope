<?php
/**
 * MeaningfulReportController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class MeaningfulReportController extends AppController {

	public $name = 'MeaningfulReport';
	public $uses = null;
	public $helpers = array('Html','Form', 'Js','Number','DateFormat','General','JsFusionChart');
	public $components = array('RequestHandler','Auth','Session','Acl');
	
	
	/**
	 * list of all link required for reports modules
	 *
	 */
	public function admin_all_report(){
	
	}

	/*
	 *
	* measure calculation which is based on patient diagnosis
	*
	*/
	public function admin_auto_measure_calculation() {
		$this->uses = array('DoctorProfile', 'Patient', 'Note');
		$this->set('title_for_layout', __('Measure Calculation', true));
		$this->DoctorProfile->bindModel(array('belongsTo' => array('User' => array('foreignKey'=>'user_id'),
				'Initial' => array('foreignKey'=>false, conditions => array('Initial.id=User.initial_id')),
				'Role' => array('foreignKey'=>false, conditions => array('Role.id=User.role_id'))
		)),false);
		$searchUserName='';
		if($this->request->query['first_name']!=''){
			$searchFirstName = $this->request->query['first_name'];
		}
		if($this->request->query['last_name']!=''){
			$searchLastName = $this->request->query['last_name'];
		}

		$condition = array('User.is_deleted' => 0, 'Role.name' => Configure::read('doctor'),'User.is_emergency' => 0, 'User.location_id' => $this->Session->read('locationid'));

		if(!empty($searchFirstName)){
			$searchConditions = array('User.first_name LIKE ' => $searchFirstName.'%');
			$condition = array_merge($searchConditions,$condition);
		}
		if(!empty($searchLastName)){
			$searchConditions = array('User.last_name LIKE ' => $searchLastName.'%');
			$condition = array_merge($searchConditions,$condition);
		}

		if($this->Session->read('role') == Configure::read('doctor')) {
			$searchConditions = array('User.id' => $this->Session->read('userid'));
			$condition = array_merge($searchConditions,$condition);
		}
		
		$this->paginate = array('limit' => Configure::read('number_of_rows'),
				'fields' => array('User.*','DoctorProfile.doctor_name', 'Initial.name'),
				'conditions' => $condition );
		$data = $this->paginate('DoctorProfile');
		$this->set('data', $data);

		// total patient count //
		$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id')

		)),false);
		
        if($this->request->query['from'] !="" && $this->request->query['to'] !="") {
		    $bothTime = array($this->DateFormat->formatDate2STDForReport($this->request->query['from'],Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport($this->request->query['to'],Configure::read('date_format'))." 23:59:59");
        } else {
        	$bothTime = array($this->DateFormat->formatDate2STDForReport("01-01-".date('Y'),Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport("31-12-".date('Y'),Configure::read('date_format'))." 23:59:59");
        }
		//$withinTime = array($this->DateFormat->formatDate2STDForReport("01-02-".date('Y'),Configure::read('date_format'))." 00:00:00",$this->DateFormat->formatDate2STDForReport("31-12-".date('Y'),Configure::read('date_format'))." 23:59:59");
		//$outsideTime = array($this->DateFormat->formatDate2STDForReport("01-01".date('Y'),Configure::read('date_format'))." 00:00:00",$this->DateFormat->formatDate2STDForReport("31-01".date('Y'),Configure::read('date_format'))." 23:59:59");

		// first test data crieteria //
		$firstStageDenominatorCount =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count', 'Patient.doctor_id'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0), 'group' => array('Patient.doctor_id')));
		foreach($firstStageDenominatorCount as $firstStageDenominatorCountVal) {
			$firstStageDenominatorCountArray[$firstStageDenominatorCountVal['Patient']['doctor_id']] = $firstStageDenominatorCountVal[0]['count'];
		}

		$firstStageNumeratorCount = $this->Note->find('all', array('fields' => array('COUNT(Patient.patient_id) as count', 'Patient.doctor_id'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'OR' => array(array('Note.icd <>' => "",'Note.icd_record' => 0), array('Note.icd' => "",'Note.icd_record' => 1)), 'Note.patient_id NOT' => array('', 0)), 'group' => array('Patient.doctor_id')));
		foreach($firstStageNumeratorCount as $firstStageNumeratorCountVal) {
			$firstStageNumeratorCountArray[$firstStageNumeratorCountVal['Patient']['doctor_id']] = $firstStageNumeratorCountVal[0]['count'];
		}

		$this->set('firstStageDenominatorCountArray', $firstStageDenominatorCountArray);
		$this->set('firstStageNumeratorCountArray', $firstStageNumeratorCountArray);
		$this->set('from', $this->request->query['from']);
		$this->set('to', $this->request->query['to']);
		$this->set('first_name', $this->request->query['first_name']);
		$this->set('last_name', $this->request->query['last_name']);
	}

	/*
	 *
	* get doctor individual report based on patient diagnosis
	*.
	*/
	public function admin_doctor_measure_calculation($doctorid) {
		$this->uses = array('Note', 'Patient', 'DoctorProfile');
		// total patient count //
		$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
				                                          'Person' => array('foreignKey'=>false, 'conditions' => array('Person.id=Patient.person_id'))

		)),false);
       
	    if($this->request->query['from'] !="" && $this->request->query['to'] !="") {
		    $bothTime = array($this->DateFormat->formatDate2STDForReport($this->request->query['from'],Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport($this->request->query['to'],Configure::read('date_format'))." 23:59:59");
        } else {
        	$bothTime = array($this->DateFormat->formatDate2STDForReport("01-01-".date('Y'),Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport("31-12-".date('Y'),Configure::read('date_format'))." 23:59:59");
        }
        $this->Patient->unbindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));
		$doctorTotalCount =  $this->Patient->find('all', array('fields' => array('COUNT(Patient.patient_id) as count', 'Patient.doctor_id'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $doctorid), 'group' => array('Patient.patient_id')));
		$doctorPatientList = $this->Note->find('all', array('fields' => array('Patient.patient_id', 'Patient.doctor_id','Patient.lookup_name','Patient.sex','Person.email','Person.mobile'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $doctorid,'OR' => array(array('Note.icd <>' => "",'Note.icd_record' => 0), array('Note.icd' => "",'Note.icd_record' => 1)),'Note.patient_id NOT' => array('', 0))));
		//print_r($doctorPatientList);exit;
		$doctorDetails = $this->DoctorProfile->find('first', array('conditions' => array('DoctorProfile.user_id' => $doctorid)));
		$this->set('doctorDetails', $doctorDetails);
		$this->set('doctorTotalCount', $doctorTotalCount);
		$this->set('doctorPatientList', $doctorPatientList);

	}
	
	
	/*
	 *
	* medication calculation which is based on new crop prescription
	*
	*/
	public function admin_medication_calculation() {
		$this->uses = array('DoctorProfile', 'Patient', 'NewCropPrescription');
		$this->set('title_for_layout', __('Measure Calculation', true));
		$this->DoctorProfile->bindModel(array('belongsTo' => array('User' => array('foreignKey'=>'user_id'),
				'Initial' => array('foreignKey'=>false, conditions => array('Initial.id=User.initial_id')),
				'Role' => array('foreignKey'=>false, conditions => array('Role.id=User.role_id'))
		)),false);
		$searchUserName='';
		if($this->request->query['first_name']!=''){
			$searchFirstName = $this->request->query['first_name'];
		}
		if($this->request->query['last_name']!=''){
			$searchLastName = $this->request->query['last_name'];
		}
	
		$condition = array('User.is_deleted' => 0, 'Role.name' => Configure::read('doctor'),'User.is_emergency' => 0, 'User.location_id' => $this->Session->read('locationid'));
	
		if(!empty($searchFirstName)){
			$searchConditions = array('User.first_name LIKE ' => $searchFirstName.'%');
			$condition = array_merge($searchConditions,$condition);
		}
		if(!empty($searchLastName)){
			$searchConditions = array('User.last_name LIKE ' => $searchLastName.'%');
			$condition = array_merge($searchConditions,$condition);
		}
		if($this->Session->read('role') == Configure::read('doctor')) {
			$searchConditions = array('User.id' => $this->Session->read('userid'));
			$condition = array_merge($searchConditions,$condition);
		}
		
		$this->paginate = array('limit' => Configure::read('number_of_rows'),
				'fields' => array('User.*','DoctorProfile.doctor_name', 'Initial.name'),
				'conditions' => $condition );
		$data = $this->paginate('DoctorProfile');
		$this->set('data', $data);
	
		// total patient count //
		$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
				 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))),false);
	
		if($this->request->query['from'] !="" && $this->request->query['to'] !="") {
			$bothTime = array($this->DateFormat->formatDate2STDForReport($this->request->query['from'],Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport($this->request->query['to'],Configure::read('date_format'))." 23:59:59");
		} else {
			$bothTime = array($this->DateFormat->formatDate2STDForReport("01-01-".date('Y'),Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport("31-12-".date('Y'),Configure::read('date_format'))." 23:59:59");
		}
		//$withinTime = array($this->DateFormat->formatDate2STDForReport("01-02-".date('Y'),Configure::read('date_format'))." 00:00:00",$this->DateFormat->formatDate2STDForReport("31-12-".date('Y'),Configure::read('date_format'))." 23:59:59");
		//$outsideTime = array($this->DateFormat->formatDate2STDForReport("01-01".date('Y'),Configure::read('date_format'))." 00:00:00",$this->DateFormat->formatDate2STDForReport("31-01".date('Y'),Configure::read('date_format'))." 23:59:59");
	
		// first test data crieteria //
		$firstStageDenominatorCount =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count', 'Patient.doctor_id'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0), 'group' => array('Patient.doctor_id')));
		foreach($firstStageDenominatorCount as $firstStageDenominatorCountVal) {
			$firstStageDenominatorCountArray[$firstStageDenominatorCountVal['Patient']['doctor_id']] = $firstStageDenominatorCountVal[0]['count'];
		}
	
		$firstStageNumeratorCount = $this->NewCropPrescription->find('all', array('fields' => array('COUNT(Patient.patient_id) as count',
				 'Patient.doctor_id'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime,
				 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
				 		'NewCropPrescription.patient_id NOT' => array('', 0)), 'group' => array('Patient.doctor_id')));
		foreach($firstStageNumeratorCount as $firstStageNumeratorCountVal) {
			$firstStageNumeratorCountArray[$firstStageNumeratorCountVal['Patient']['doctor_id']] = $firstStageNumeratorCountVal[0]['count'];
		}
	
		$this->set('firstStageDenominatorCountArray', $firstStageDenominatorCountArray);
		$this->set('firstStageNumeratorCountArray', $firstStageNumeratorCountArray);
		$this->set('from', $this->request->query['from']);
		$this->set('to', $this->request->query['to']);
		$this->set('first_name', $this->request->query['first_name']);
		$this->set('last_name', $this->request->query['last_name']);
	}
	
	/*
	 *
	* get doctor individual report based on new crop medication
	*
	*/
	public function admin_doctor_medication_calculation($doctorid) {
		$this->uses = array('NewCropPrescription', 'Patient', 'DoctorProfile');
		// total patient count //
		$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
				 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))),false);
	
	    if($this->request->query['from'] !="" && $this->request->query['to'] !="") {
		    $bothTime = array($this->DateFormat->formatDate2STDForReport($this->request->query['from'],Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport($this->request->query['to'],Configure::read('date_format'))." 23:59:59");
        } else {
        	$bothTime = array($this->DateFormat->formatDate2STDForReport("01-01-".date('Y'),Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport("31-12-".date('Y'),Configure::read('date_format'))." 23:59:59");
        }
	
		$doctorTotalCount =  $this->Patient->find('all', array('fields' => array('COUNT(Patient.patient_id) as count', 'Patient.doctor_id'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $doctorid), 'group' => array('Patient.patient_id')));
		$doctorPatientList = $this->NewCropPrescription->find('all', array('fields' => array('Patient.patient_id',
				 'Patient.doctor_id','Patient.lookup_name','Patient.sex','Patient.email','Patient.mobile_phone'),
				 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime,
				 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
				 		 'Patient.doctor_id' => $doctorid, 'NewCropPrescription.patient_id NOT' => array('', 0))));
		//print_r($doctorPatientList);exit;
		$doctorDetails = $this->DoctorProfile->find('first', array('conditions' => array('DoctorProfile.user_id' => $doctorid)));
		$this->set('doctorDetails', $doctorDetails);
		$this->set('doctorTotalCount', $doctorTotalCount);
		$this->set('doctorPatientList', $doctorPatientList);
	
	}
	
	
	/*
	 *
	* allergy calculation which is based on new crop allergy
	*
	*/
	public function admin_allergies_calculation() {
		$this->uses = array('DoctorProfile', 'Patient', 'NewCropAllergies');
		$this->set('title_for_layout', __('Measure Calculation', true));
		$this->DoctorProfile->bindModel(array('belongsTo' => array('User' => array('foreignKey'=>'user_id'),
				'Initial' => array('foreignKey'=>false, conditions => array('Initial.id=User.initial_id')),
				'Role' => array('foreignKey'=>false, conditions => array('Role.id=User.role_id'))
		)),false);
		$searchUserName='';
		if($this->request->query['first_name']!=''){
			$searchFirstName = $this->request->query['first_name'];
		}
		if($this->request->query['last_name']!=''){
			$searchLastName = $this->request->query['last_name'];
		}
	
		$condition = array('User.is_deleted' => 0, 'Role.name' => Configure::read('doctor'),'User.is_emergency' => 0, 'User.location_id' => $this->Session->read('locationid'));
	
		if(!empty($searchFirstName)){
			$searchConditions = array('User.first_name LIKE ' => $searchFirstName.'%');
			$condition = array_merge($searchConditions,$condition);
		}
		if(!empty($searchLastName)){
			$searchConditions = array('User.last_name LIKE ' => $searchLastName.'%');
			$condition = array_merge($searchConditions,$condition);
		}
		if($this->Session->read('role') == Configure::read('doctor')) {
			$searchConditions = array('User.id' => $this->Session->read('userid'));
			$condition = array_merge($searchConditions,$condition);
		}
		
		$this->paginate = array('limit' => Configure::read('number_of_rows'),
				'fields' => array('User.*','DoctorProfile.doctor_name', 'Initial.name'),
				'conditions' => $condition );
		$data = $this->paginate('DoctorProfile');
		$this->set('data', $data);
	
		// total patient count //
		$this->NewCropAllergies->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))),false);
	
		if($this->request->query['from'] !="" && $this->request->query['to'] !="") {
			$bothTime = array($this->DateFormat->formatDate2STDForReport($this->request->query['from'],Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport($this->request->query['to'],Configure::read('date_format'))." 23:59:59");
		} else {
			$bothTime = array($this->DateFormat->formatDate2STDForReport("01-01-".date('Y'),Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport("31-12-".date('Y'),Configure::read('date_format'))." 23:59:59");
		}
			
		// first test data crieteria //
		$firstStageDenominatorCount =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count', 'Patient.doctor_id'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0), 'group' => array('Patient.doctor_id')));
		foreach($firstStageDenominatorCount as $firstStageDenominatorCountVal) {
			$firstStageDenominatorCountArray[$firstStageDenominatorCountVal['Patient']['doctor_id']] = $firstStageDenominatorCountVal[0]['count'];
		}
	
		$firstStageNumeratorCount = $this->NewCropAllergies->find('all', array('fields' => array('COUNT(Patient.patient_id) as count', 'Patient.doctor_id'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'NewCropAllergies.patient_id NOT' => array('', 0)), 'group' => array('Patient.doctor_id')));
		foreach($firstStageNumeratorCount as $firstStageNumeratorCountVal) {
			$firstStageNumeratorCountArray[$firstStageNumeratorCountVal['Patient']['doctor_id']] = $firstStageNumeratorCountVal[0]['count'];
		}
	
		$this->set('firstStageDenominatorCountArray', $firstStageDenominatorCountArray);
		$this->set('firstStageNumeratorCountArray', $firstStageNumeratorCountArray);
		$this->set('from', $this->request->query['from']);
		$this->set('to', $this->request->query['to']);
		$this->set('first_name', $this->request->query['first_name']);
		$this->set('last_name', $this->request->query['last_name']);
	}
	
	/*
	 *
	* get doctor individual report based on new crop medication
	*
	*/
	public function admin_doctor_allergies_calculation($doctorid) {
		$this->uses = array('NewCropAllergies', 'Patient', 'DoctorProfile');
		// total patient count //
		$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id')
	
		)),false);
	
		if($this->request->data['from'] !="" && $this->request->data['to'] !="") {
			$bothTime = array($this->DateFormat->formatDate2STDForReport($this->request->data['from'],Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport($this->request->data['to'],Configure::read('date_format'))." 23:59:59");
		} else {
			$bothTime = array($this->DateFormat->formatDate2STDForReport("01-01-".date('Y'),Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport("31-12-".date('Y'),Configure::read('date_format'))." 23:59:59");
		}
	
		$doctorTotalCount =  $this->Patient->find('all', array('fields' => array('COUNT(Patient.patient_id) as count', 'Patient.doctor_id'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $doctorid), 'group' => array('Patient.patient_id')));
		$doctorPatientList = $this->NewCropAllergies->find('all', array('fields' => array('Patient.patient_id', 'Patient.doctor_id','Patient.lookup_name','Patient.sex','Patient.email','Patient.mobile_phone'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $doctorid, 'NewCropAllergies.patient_id NOT' => array('', 0))));
		
		$doctorDetails = $this->DoctorProfile->find('first', array('conditions' => array('DoctorProfile.user_id' => $doctorid)));
		$this->set('doctorDetails', $doctorDetails);
		$this->set('doctorTotalCount', $doctorTotalCount);
		$this->set('doctorPatientList', $doctorPatientList);
	
	}
	
	
	/*
	 *
	* demographic calculation which is based on demographic
	*
	*/
	public function admin_demographic_calculation() {
		$this->uses = array('DoctorProfile', 'Patient');
		$this->set('title_for_layout', __('Demographic', true));
		$this->DoctorProfile->bindModel(array('belongsTo' => array('User' => array('foreignKey'=>'user_id'),
				'Initial' => array('foreignKey'=>false, conditions => array('Initial.id=User.initial_id')),
				'Role' => array('foreignKey'=>false, conditions => array('Role.id=User.role_id'))
		)),false);
		$searchUserName='';
		if($this->request->query['first_name']!=''){
			$searchFirstName = $this->request->query['first_name'];
		}
		if($this->request->query['last_name']!=''){
			$searchLastName = $this->request->query['last_name'];
		}
	
		$condition = array('User.is_deleted' => 0, 'Role.name' => Configure::read('doctor'),'User.is_emergency' => 0, 'User.location_id' => $this->Session->read('locationid'));
	
		if(!empty($searchFirstName)){
			$searchConditions = array('User.first_name LIKE ' => $searchFirstName.'%');
			$condition = array_merge($searchConditions,$condition);
		}
		if(!empty($searchLastName)){
			$searchConditions = array('User.last_name LIKE ' => $searchLastName.'%');
			$condition = array_merge($searchConditions,$condition);
		}
		if($this->Session->read('role') == Configure::read('doctor')) {
			$searchConditions = array('User.id' => $this->Session->read('userid'));
			$condition = array_merge($searchConditions,$condition);
		}
	
		$this->paginate = array('limit' => Configure::read('number_of_rows'),
				'fields' => array('User.*','DoctorProfile.doctor_name', 'Initial.name'),
				'conditions' => $condition );
		$data = $this->paginate('DoctorProfile');
		$this->set('data', $data);
		
		if($this->request->query['from'] !="" && $this->request->query['to'] !="") {
			$bothTime = array($this->DateFormat->formatDate2STDForReport($this->request->query['from'],Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport($this->request->query['to'],Configure::read('date_format'))." 23:59:59");
		} else {
			$bothTime = array($this->DateFormat->formatDate2STDForReport("01-01-".date('Y'),Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport("31-12-".date('Y'),Configure::read('date_format'))." 23:59:59");
		}
		
		$this->Patient->unbindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));
		// first test data crieteria //
		$firstStageDenominatorCount =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count', 'Patient.doctor_id'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0), 'group' => array('Patient.doctor_id')));
		foreach($firstStageDenominatorCount as $firstStageDenominatorCountVal) {
			$firstStageDenominatorCountArray[$firstStageDenominatorCountVal['Patient']['doctor_id']] = $firstStageDenominatorCountVal[0]['count'];
		}
	
		$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'), 'DeathSummary' => array('foreignKey'=>false, 'conditions' => array('DeathSummary.patient_id=Patient.id')))),false);
		
		$firstStageNumeratorCount = $this->Patient->find('all', array('fields' => array('COUNT(Patient.patient_id) as count', 'Patient.doctor_id'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Person.ethnicity <>' => "", 'Person.race <>' => "", 'Person.language <>' => ""), 'group' => array('Patient.doctor_id')));
		//print_r($firstStageNumeratorCount);exit;
		foreach($firstStageNumeratorCount as $firstStageNumeratorCountVal) {
			$firstStageNumeratorCountArray[$firstStageNumeratorCountVal['Patient']['doctor_id']] = $firstStageNumeratorCountVal[0]['count'];
		}
	   
		
		$this->set('firstStageDenominatorCountArray', $firstStageDenominatorCountArray);
		$this->set('firstStageNumeratorCountArray', $firstStageNumeratorCountArray);
		$this->set('from', $this->request->query['from']);
		$this->set('to', $this->request->query['to']);
		$this->set('first_name', $this->request->query['first_name']);
		$this->set('last_name', $this->request->query['last_name']);
	}
	
	/*
	 *
	* get doctor individual report based on demographic
	*
	*/
	public function admin_doctor_demographic_calculation($doctorid) {
		$this->set('title_for_layout', __('Doctor Demographic', true));
		$this->uses = array('Patient', 'DoctorProfile');
		$this->Patient->unbindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));
			
		if($this->request->query['from'] !="" && $this->request->query['to'] !="") {
			$bothTime = array($this->DateFormat->formatDate2STDForReport($this->request->query['from'],Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport($this->request->query['to'],Configure::read('date_format'))." 23:59:59");
		} else {
			$bothTime = array($this->DateFormat->formatDate2STDForReport("01-01-".date('Y'),Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport("31-12-".date('Y'),Configure::read('date_format'))." 23:59:59");
		}
	
		$doctorTotalCount =  $this->Patient->find('all', array('fields' => array('COUNT(Patient.patient_id) as count', 'Patient.doctor_id'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $doctorid), 'group' => array('Patient.patient_id')));
		$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'), 'DeathSummary' => array('foreignKey'=>false, 'conditions' => array('DeathSummary.patient_id=Patient.id')))),false);
		$doctorPatientList = $this->Patient->find('all', array('fields' => array('Patient.doctor_id', 'Patient.patient_id', 'Patient.doctor_id','Patient.lookup_name','Patient.sex','Patient.email','Patient.mobile_phone'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'),'Patient.doctor_id' => $doctorid, 'Patient.is_deleted' => 0, 'Person.ethnicity <>' => "", 'Person.race <>' => "", 'Person.language <>' => "")));
		$doctorDetails = $this->DoctorProfile->find('first', array('conditions' => array('DoctorProfile.user_id' => $doctorid)));
		$this->set('doctorDetails', $doctorDetails);
		$this->set('doctorTotalCount', $doctorTotalCount);
		$this->set('doctorPatientList', $doctorPatientList);
	
	}
	
	
	/*
	 *
	* smoking status calculation which is based on smoking status
	*
	*/
	public function admin_smoking_status_calculation() {
		$this->uses = array('DoctorProfile', 'Patient', 'PatientSmoking');
		$this->set('title_for_layout', __('Measure Calculation', true));
		$this->DoctorProfile->bindModel(array('belongsTo' => array('User' => array('foreignKey'=>'user_id'),
				'Initial' => array('foreignKey'=>false, conditions => array('Initial.id=User.initial_id')),
				'Role' => array('foreignKey'=>false, conditions => array('Role.id=User.role_id'))
		)),false);
		$searchUserName='';
		if($this->request->query['first_name']!=''){
			$searchFirstName = $this->request->query['first_name'];
		}
		if($this->request->query['last_name']!=''){
			$searchLastName = $this->request->query['last_name'];
		}
	
		$condition = array('User.is_deleted' => 0, 'Role.name' => Configure::read('doctor'),'User.is_emergency' => 0, 'User.location_id' => $this->Session->read('locationid'));
	
		if(!empty($searchFirstName)){
			$searchConditions = array('User.first_name LIKE ' => $searchFirstName.'%');
			$condition = array_merge($searchConditions,$condition);
		}
		if(!empty($searchLastName)){
			$searchConditions = array('User.last_name LIKE ' => $searchLastName.'%');
			$condition = array_merge($searchConditions,$condition);
		}
		if($this->Session->read('role') == Configure::read('doctor')) {
			$searchConditions = array('User.id' => $this->Session->read('userid'));
			$condition = array_merge($searchConditions,$condition);
		}
	
		$this->paginate = array('limit' => Configure::read('number_of_rows'),
				'fields' => array('User.*','DoctorProfile.doctor_name', 'Initial.name'),
				'conditions' => $condition );
		$data = $this->paginate('DoctorProfile');
		$this->set('data', $data);
	
		$this->PatientSmoking->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),'SmokingStatusOnc' => array('foreignKey'=>'current_smoking_fre'))),false);
	
		if($this->request->query['from'] !="" && $this->request->query['to'] !="") {
			$bothTime = array($this->DateFormat->formatDate2STDForReport($this->request->query['from'],Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport($this->request->query['to'],Configure::read('date_format'))." 23:59:59");
		} else {
			$bothTime = array($this->DateFormat->formatDate2STDForReport("01-01-".date('Y'),Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport("31-12-".date('Y'),Configure::read('date_format'))." 23:59:59");
		}
		//$withinTime = array($this->DateFormat->formatDate2STDForReport("01-02-".date('Y'),Configure::read('date_format'))." 00:00:00",$this->DateFormat->formatDate2STDForReport("31-12-".date('Y'),Configure::read('date_format'))." 23:59:59");
		//$outsideTime = array($this->DateFormat->formatDate2STDForReport("01-01".date('Y'),Configure::read('date_format'))." 00:00:00",$this->DateFormat->formatDate2STDForReport("31-01".date('Y'),Configure::read('date_format'))." 23:59:59");
	
		// first test data crieteria //
		$firstStageDenominatorCount =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count', 'Patient.doctor_id'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0), 'group' => array('Patient.doctor_id')));
		foreach($firstStageDenominatorCount as $firstStageDenominatorCountVal) {
			$firstStageDenominatorCountArray[$firstStageDenominatorCountVal['Patient']['doctor_id']] = $firstStageDenominatorCountVal[0]['count'];
		}
	
		$firstStageNumeratorCount = $this->PatientSmoking->find('all', array('fields' => array('COUNT(Patient.patient_id) as count', 'Patient.doctor_id'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,'PatientSmoking.patient_id NOT' => array('', 0) , 'PatientSmoking.current_smoking_fre <>' => ""), 'group' => array('Patient.doctor_id')));
		foreach($firstStageNumeratorCount as $firstStageNumeratorCountVal) {
			$firstStageNumeratorCountArray[$firstStageNumeratorCountVal['Patient']['doctor_id']] = $firstStageNumeratorCountVal[0]['count'];
		}
	
		$this->set('firstStageDenominatorCountArray', $firstStageDenominatorCountArray);
		$this->set('firstStageNumeratorCountArray', $firstStageNumeratorCountArray);
		$this->set('from', $this->request->query['from']);
		$this->set('to', $this->request->query['to']);
		$this->set('first_name', $this->request->query['first_name']);
		$this->set('last_name', $this->request->query['last_name']);
	}
	
	/*
	 *
	* get doctor individual report based on smoking status
	*
	*/
	public function admin_doctor_smoking_status_calculation($doctorid) {
		$this->uses = array('PatientSmoking', 'Patient', 'DoctorProfile');
		// total patient count //
		$this->PatientSmoking->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),'SmokingStatusOnc' => array('foreignKey'=>'current_smoking_fre'))),false);
	
		if($this->request->query['from'] !="" && $this->request->query['to'] !="") {
			$bothTime = array($this->DateFormat->formatDate2STDForReport($this->request->query['from'],Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport($this->request->query['to'],Configure::read('date_format'))." 23:59:59");
		} else {
			$bothTime = array($this->DateFormat->formatDate2STDForReport("01-01-".date('Y'),Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport("31-12-".date('Y'),Configure::read('date_format'))." 23:59:59");
		}
	
		$doctorTotalCount =  $this->Patient->find('all', array('fields' => array('COUNT(Patient.patient_id) as count', 'Patient.doctor_id'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $doctorid), 'group' => array('Patient.patient_id')));
		$doctorPatientList = $this->PatientSmoking->find('all', array('fields' => array('Patient.patient_id', 'Patient.doctor_id','Patient.lookup_name','Patient.sex','Patient.email','Patient.mobile_phone'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $doctorid, 'PatientSmoking.patient_id NOT' => array('', 0), 'PatientSmoking.current_smoking_fre <>' => "")));
		
		$doctorDetails = $this->DoctorProfile->find('first', array('conditions' => array('DoctorProfile.user_id' => $doctorid)));
		$this->set('doctorDetails', $doctorDetails);
		$this->set('doctorTotalCount', $doctorTotalCount);
		$this->set('doctorPatientList', $doctorPatientList);
	
	}
	
	/*
	 *
	 * vital sign calculation which is based on smoking status
	 *
	 */
	public function admin_vital_signs_calculation() {
		$this->uses = array('DoctorProfile', 'Patient', 'PatientSmoking');
		$this->set('title_for_layout', __('Measure Calculation', true));
		$this->DoctorProfile->bindModel(array('belongsTo' => array('User' => array('foreignKey'=>'user_id'),
				'Initial' => array('foreignKey'=>false, conditions => array('Initial.id=User.initial_id')),
				'Role' => array('foreignKey'=>false, conditions => array('Role.id=User.role_id'))
		)),false);
		$searchUserName='';
		if($this->request->query['first_name']!=''){
			$searchFirstName = $this->request->query['first_name'];
		}
		if($this->request->query['last_name']!=''){
			$searchLastName = $this->request->query['last_name'];
		}
	
		$condition = array('User.is_deleted' => 0, 'Role.name' => Configure::read('doctor'),'User.is_emergency' => 0, 'User.location_id' => $this->Session->read('locationid'));
	
		if(!empty($searchFirstName)){
			$searchConditions = array('User.first_name LIKE ' => $searchFirstName.'%');
			$condition = array_merge($searchConditions,$condition);
		}
		if(!empty($searchLastName)){
			$searchConditions = array('User.last_name LIKE ' => $searchLastName.'%');
			$condition = array_merge($searchConditions,$condition);
		}
		if($this->Session->read('role') == Configure::read('doctor')) {
			$searchConditions = array('User.id' => $this->Session->read('userid'));
			$condition = array_merge($searchConditions,$condition);
		}
	
		$this->paginate = array('limit' => Configure::read('number_of_rows'),
				'fields' => array('User.*','DoctorProfile.doctor_name', 'Initial.name'),
				'conditions' => $condition );
		$data = $this->paginate('DoctorProfile');
		$this->set('data', $data);
	
		$this->PatientSmoking->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),'SmokingStatusOnc' => array('foreignKey'=>'current_smoking_fre'))),false);
	
		if($this->request->query['from'] !="" && $this->request->query['to'] !="") {
			$bothTime = array($this->DateFormat->formatDate2STDForReport($this->request->query['from'],Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport($this->request->query['to'],Configure::read('date_format'))." 23:59:59");
		} else {
			$bothTime = array($this->DateFormat->formatDate2STDForReport("01-01-".date('Y'),Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport("31-12-".date('Y'),Configure::read('date_format'))." 23:59:59");
		}
		//$withinTime = array($this->DateFormat->formatDate2STDForReport("01-02-".date('Y'),Configure::read('date_format'))." 00:00:00",$this->DateFormat->formatDate2STDForReport("31-12-".date('Y'),Configure::read('date_format'))." 23:59:59");
		//$outsideTime = array($this->DateFormat->formatDate2STDForReport("01-01".date('Y'),Configure::read('date_format'))." 00:00:00",$this->DateFormat->formatDate2STDForReport("31-01".date('Y'),Configure::read('date_format'))." 23:59:59");
	
		// first test data crieteria //
		$firstStageDenominatorCount =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count', 'Patient.doctor_id'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0), 'group' => array('Patient.doctor_id')));
		foreach($firstStageDenominatorCount as $firstStageDenominatorCountVal) {
			$firstStageDenominatorCountArray[$firstStageDenominatorCountVal['Patient']['doctor_id']] = $firstStageDenominatorCountVal[0]['count'];
		}
	
		$firstStageNumeratorCount = $this->PatientSmoking->find('all', array('fields' => array('COUNT(Patient.patient_id) as count', 'Patient.doctor_id'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,'PatientSmoking.patient_id NOT' => array('', 0) , 'PatientSmoking.current_smoking_fre <>' => ""), 'group' => array('Patient.doctor_id')));
		foreach($firstStageNumeratorCount as $firstStageNumeratorCountVal) {
			$firstStageNumeratorCountArray[$firstStageNumeratorCountVal['Patient']['doctor_id']] = $firstStageNumeratorCountVal[0]['count'];
		}
	
		$this->set('firstStageDenominatorCountArray', $firstStageDenominatorCountArray);
		$this->set('firstStageNumeratorCountArray', $firstStageNumeratorCountArray);
		$this->set('from', $this->request->query['from']);
		$this->set('to', $this->request->query['to']);
		$this->set('first_name', $this->request->query['first_name']);
		$this->set('last_name', $this->request->query['last_name']);
	}
	
	/*
	 *
	* get doctor individual report based on vital signs
	*
	*/
	public function admin_doctor_vital_signs_calculation($doctorid) {
		$this->uses = array('PatientSmoking', 'Patient', 'DoctorProfile');
		// total patient count //
		$this->PatientSmoking->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),'SmokingStatusOnc' => array('foreignKey'=>'current_smoking_fre'))),false);
	
		if($this->request->query['from'] !="" && $this->request->query['to'] !="") {
			$bothTime = array($this->DateFormat->formatDate2STDForReport($this->request->query['from'],Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport($this->request->query['to'],Configure::read('date_format'))." 23:59:59");
		} else {
			$bothTime = array($this->DateFormat->formatDate2STDForReport("01-01-".date('Y'),Configure::read('date_format'))." 00:00:00", $this->DateFormat->formatDate2STDForReport("31-12-".date('Y'),Configure::read('date_format'))." 23:59:59");
		}
	
		$doctorTotalCount =  $this->Patient->find('all', array('fields' => array('COUNT(Patient.patient_id) as count', 'Patient.doctor_id'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $doctorid), 'group' => array('Patient.patient_id')));
		$doctorPatientList = $this->PatientSmoking->find('all', array('fields' => array('Patient.patient_id', 'Patient.doctor_id','Patient.lookup_name','Patient.sex','Patient.email','Patient.mobile_phone'), 'conditions' => array('Patient.form_received_on BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $doctorid, 'PatientSmoking.patient_id NOT' => array('', 0), 'PatientSmoking.current_smoking_fre <>' => "")));
	
		$doctorDetails = $this->DoctorProfile->find('first', array('conditions' => array('DoctorProfile.user_id' => $doctorid)));
		$this->set('doctorDetails', $doctorDetails);
		$this->set('doctorTotalCount', $doctorTotalCount);
		$this->set('doctorPatientList', $doctorPatientList);
	
	}
	
	/*
	 * 
	 *  automated measure calculation PHR
	 * 
	 */
     public function admin_automated_measure_calculation() {
		$this->uses = array('DoctorProfile', 'BmiResult','Patient', 'PatientSmoking','Note','NewCropPrescription', 'NewCropAllergies','PrescriptionRecord','LaboratoryTestOrder','LaboratoryResult','Outbox','RadiologyTestOrder','RadiologyReport','FamilyHistory','AdvanceDirective', 'Note', 'Inbox', 'PatientReferral', 'TransmittedCcda', 'XmlNote', 'LaboratoryManualEntry', 'RadiologyManualEntry', 'IncorporatedPatient');
		$this->set('title_for_layout', __('Measure Calculation', true));
				
		if($this->request->is('post')) { 
			$this->Patient->unbindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn', 'PrescriptionRecord', 'LaboratoryResult', 'LaboratoryTestOrder')));
			if($this->request->data['provider'] !=''){
				$searchProvider = $this->request->data['provider'];
			}
			if($this->request->data['stage_type'] !=''){
				$stage_type = $this->request->data['stage_type'];
			}
			
				$patient_type = 'OPD';
						
			if($this->request->data['startdate'] !="" && $this->request->data['duration'] !="") {
				$expStartDate = explode("/", $this->request->data['startdate']);
				$startDate = $expStartDate[2]."-".$expStartDate[0]."-".$expStartDate[1];
				$addDays = $this->request->data['duration'];
				$endDate = date("Y-m-d", strtotime("+$addDays days", strtotime($startDate)));
				$bothTime = array($startDate, $endDate);
								
			}
			if($this->request->data['year'] !="" && $this->request->data['duration'] !="") {
				$expTwoDate = explode("_", $this->request->data['duration']);
				$startDate = $this->request->data['year']."-".$expTwoDate[0];
				$endDate = $this->request->data['year']."-".$expTwoDate[1];
				$bothTime = array($startDate, $endDate);
				} 
				
			$this->Patient->unbindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));
			$withinPatientList =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
					 		'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			// demographic calculation //
			$demographicDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
							'Patient.doctor_id' => $searchProvider,'Patient.admission_type' => $patient_type)));
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$demographicNumeratorVal = $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'),
					 'conditions' => array('Patient.id' =>$withinPatientList, 'Patient.location_id'=>$this->Session->read('locationid'),
					 		 'Patient.is_deleted' => 0, 'Person.ethnicity <>' => "", 'Person.race <>' => "", 'Person.language <>' => "", 
					 		'Patient.doctor_id' => $searchProvider,'Patient.admission_type' => $patient_type)));
			
			// smoking status calculation //
			$smokingstatusDenominatorVal =  $this->Patient->find('all', array(
					'fields' => array('COUNT(DISTINCT Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.doctor_id' => $searchProvider,'Patient.admission_type' => $patient_type)));
			$this->PatientSmoking->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
			                                                            'Person' => array('foreignKey'=>false, 'conditions' => array('Person.id=Patient.person_id'))
			                                                            )));
			$smokingstatusNumeratorVal = $this->PatientSmoking->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'),
					 'conditions' => array('Patient.id' =>$withinPatientList, 'Patient.location_id'=>$this->Session->read('locationid'),
					 		 'Patient.is_deleted' => 0,'PatientSmoking.patient_id NOT' => array('', 0) , 
					 		'PatientSmoking.current_smoking_fre <>' => "", 'Patient.doctor_id' => $searchProvider,
					 		'Patient.admission_type' => $patient_type,
					 		/*'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" )+0 >' => 13*/
					 		'DATEDIFF(CURDATE(),Person.dob)/365 >'=>'13')));
			
			// problem list calculation //
			$problemlistDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$this->Note->bindModel(array('belongsTo' => array(
					'Patient' => array('foreignKey'=>'patient_id'),
					'NoteDiagnosis'=>array('foreignKey'=>false,'conditions'=>array('NoteDiagnosis.patient_id=Patient.id'))
					)));
			$problemlistNumeratorVal = $this->Note->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => '0',
					 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,'NoteDiagnosis.is_deleted'=>'0'
					 		 /*'OR' => array('Note.icd <>' => "", array('NOT' => array('Note.icd_record' => NULL))),
					 		 'Note.patient_id NOT' => array('', 0)*/)));//edited by--Pooja(NO need of the commented condition as we are not using them)
			
			// medication list calculation //
			$medicationlistDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			// patient list //
			$mlpatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'), 
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));//NewCropPrescription.patient_uniqueid is  patient id
			
			$medicationlistNumeratorVal = $this->NewCropPrescription->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'),
					 'conditions' => array('Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
					 		 'NewCropPrescription.patient_uniqueid' => $mlpatientlist, 'NewCropPrescription.uncheck' => array(0,1))));
			
			// medication allergy calculation //
			$medicationAllergyDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$mapatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
					 		'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
					 		'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$this->NewCropAllergies->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false, 
					'conditions' => array('Patient.id=NewCropAllergies.patient_uniqueid')))));
			$medicationAllergyNumeratorVal = $this->NewCropAllergies->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'),
					 'conditions' => array('Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.doctor_id' => $searchProvider, 'NewCropAllergies.patient_uniqueid' => $mapatientlist,
					 		 'Patient.admission_type' => $patient_type, 'NewCropAllergies.allergycheck' => array(0,1),'NewCropAllergies.status'=>'A')));
			
			// emar calculation //
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$emarDenominatorVal = $this->NewCropPrescription->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
					 		 'NewCropPrescription.description <>' => "")));
			$this->PrescriptionRecord->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.patient_id=PrescriptionRecord.patient_uid')))));
			$emarNumeratorVal =  $this->PrescriptionRecord->find('all', array('fields' => array('COUNT(DISTINCT PrescriptionRecord.patient_uid) as count'),
					 'conditions' => array('DATE_FORMAT(PrescriptionRecord.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.doctor_id' => $searchProvider,'Patient.admission_type' => $patient_type,
					 		 'PrescriptionRecord.medication <>' => "")));
			
			// erx calculation for stage1 //
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			//date_of_prescription_1 was previuosly used now it is not used also SUM(NewCropPrescription.no_of_prescription_not_controlled) as count ---Pooja
			$erxstage1DenominatorVal = $this->NewCropPrescription->find('all', array('fields' => array('COUNT(Patient.Patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.admission_type' => $patient_type)));
			
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			
			
			//Previuosly SUM(NewCropPrescription.no_of_transmitted_prescription_not_controlled)
			$erxstage1NumeratorVal = $this->NewCropPrescription->find('all', array('fields' => array('COUNT(Patient.Patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.admission_type' => $patient_type)));
			
			// erx calculation for stage2 //
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$erxstage2DenominatorCVal = $this->NewCropPrescription->find('all', array(
					'fields' => array('SUM(NewCropPrescription.no_of_prescription_controlled) as count'),
					 'conditions' => array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
					 		'Patient.admission_type' => $patient_type)));
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$erxstage2NumeratorCVal = $this->NewCropPrescription->find('all', array(
					'fields' => array('SUM(NewCropPrescription.no_of_transmitted_prescription_controlled) as count'),
					 'conditions' => array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.admission_type' => $patient_type)));
			
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$erxstage2DenominatorNVal = $this->NewCropPrescription->find('all', array(
					'fields' => array('SUM(NewCropPrescription.no_of_prescription_not_controlled) as count'),
					 'conditions' => array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.admission_type' => $patient_type)));
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$erxstage2NumeratorNVal = $this->NewCropPrescription->find('all', array(
					'fields' => array('SUM(NewCropPrescription.no_of_transmitted_prescription_not_controlled) as count'),
					 'conditions' => array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
					 		'Patient.admission_type' => $patient_type)));
			
			$erxstage2DenominatorVal = $erxstage2DenominatorCVal[0][0]['count'] + $erxstage2DenominatorNVal[0][0]['count'];
			$erxstage2NumeratorVal = $erxstage2NumeratorCVal[0][0]['count'] + $erxstage2NumeratorNVal[0][0]['count'];
			
			// lab results calculation //
			$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$labresultsDenominatorVal = $this->LaboratoryTestOrder->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(LaboratoryTestOrder.start_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'LaboratoryTestOrder.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
					 		 'Patient.admission_type' => $patient_type, 'LaboratoryTestOrder.order_id <>' => "")));
			$this->LaboratoryResult->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$labresultsNumeratorVal = $this->LaboratoryResult->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(LaboratoryResult.result_publish_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
					 		 'LaboratoryResult.laboratory_test_order_id <>' => "")));
			
			// patient reminder calculation //
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$patientreminderDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type, 'OR' => array('DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >=' => 65, 'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 <=' => 5))));
			$this->Outbox->bindModel(array('belongsTo' => array('User' => array('foreignKey'=>false, 'conditions' => array('User.username=Outbox.from')))));
			$patientreminderNumeratorVal = $this->Outbox->find('all', array('fields' => array('COUNT(Outbox.to) as count'), 'conditions' => array('DATE_FORMAT(Outbox.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'User.id' => $searchProvider, 'Outbox.is_patient' => 1, 'Outbox.subject' => 'Reminder')));
			
			// view, download and transmit calculation //
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$viewdownloadDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			
			$ccdaViewNumeratorVal=$this->XmlNote->find('all',array('fields'=>array('COUNT(XmlNote.id) as count'),
					'conditions'=>array('DATE_FORMAT(XmlNote.created, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'XmlNote.is_viewed=1')
			));
			$ccdaDownloadNumeratorVal=$this->XmlNote->find('all',array('fields'=>array('COUNT(XmlNote.id) as count'),
					'conditions'=>array('DATE_FORMAT(XmlNote.created, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'XmlNote.is_viewed=1','XmlNote.is_downloaded=1')
			));
			
			$this->TransmittedCcda->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$ccdaTransmittedNumeratorVal = $this->TransmittedCcda->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'),
					'conditions' => array('DATE_FORMAT(TransmittedCcda.referral_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'TransmittedCcda.location_id' => $this->Session->read('locationid'), 'Patient.doctor_id' => $searchProvider,
							'Patient.admission_type' => $patient_type)));
			$viewdownloadNumeratorVal= $ccdaViewNumeratorVal[0][0]['count']+$ccdaDownloadNumeratorVal[0][0]['count']+$ccdaTransmittedNumeratorVal[0][0]['count'];
			
			/*$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$viewdownloadNumeratorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
					 		 'Person.is_first_login' => 1)));*/
			
			// clinical summary calculation // 
			$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$clinicalsummaryDenominatorVal = $this->Note->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type, )));
			//$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			//$clinicalsummaryDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$this->XmlNote->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$clinicalsummaryNumeratorVal =  $this->XmlNote->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(XmlNote.clinical_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'),'DATE_FORMAT(XmlNote.clinical_date, "%Y-%m-%d") <= DATE_ADD(Patient.form_received_on,INTERVAL +2 DAY)', 'XmlNote.option !='=>'None', 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			
			// patient education calculation //
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$patienteducationDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$patienteducationNumeratorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('Patient.id' =>$withinPatientList, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,'Person.password <>' => '')));
			
			// imaging calculation // 
			$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$imagingDenominatorVal1 =  $this->LaboratoryTestOrder->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(LaboratoryTestOrder.start_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$this->RadiologyTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$imagingDenominatorVal2 =  $this->RadiologyTestOrder->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(RadiologyTestOrder.start_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$imagingDenominatorVal = $imagingDenominatorVal1[0][0]['count']+$imagingDenominatorVal2[0][0]['count'];
			$this->RadiologyReport->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$imagingNumeratorVal =  $this->RadiologyReport->find('all', array('fields' => array('COUNT(RadiologyReport.patient_id) as count'), 'conditions' => array('DATE_FORMAT(RadiologyReport.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'RadiologyReport.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			
			// family history calculation //
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$familyhistoryDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$this->FamilyHistory->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$familyhistoryNumeratorVal =  $this->FamilyHistory->find('all', array('fields' => array('COUNT(FamilyHistory.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			
			// e-notes calculation //
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$enotesDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$enotesNumeratorVal =  $this->Note->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Note.note_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			
			// advance directive calculation //
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$advdirectiveDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >=' => 65, 'Patient.is_emergency <>'=> 1, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$this->AdvanceDirective->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false, '' => array('AdvanceDirective.patient_id=Patient.admission_id')))));
			$advdirectiveNumeratorVal =  $this->AdvanceDirective->find('all', array('fields' => array('COUNT(DISTINCT AdvanceDirective.patient_id) as count'), 'conditions' => array('DATE_FORMAT(AdvanceDirective.patient_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			
			// secure message calculation(not included ammendment, lab report, lab requisition, reminder, refferal summary) //
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$securemsgDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider)));
			$this->Inbox->bindModel(array('belongsTo' => array('User' => array('foreignKey'=>false, 'conditions' => array('User.username=Inbox.to')))));
			$securemsgNumeratorVal = $this->Inbox->find('all', array('fields' => array('COUNT(DISTINCT Inbox.from) as count'), 'conditions' => array('DATE_FORMAT(Inbox.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'User.id' => $searchProvider,'User.location_id' => $this->Session->read('locationid'), 'Inbox.is_patient' => 0)));
			
			// cpoe calculation include three section ie for medication, laboratory and radiology//
			$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false, 'conditions' => array('Patient.id=Note.patient_id')))));
			$cpoeMedicationDenominatorMVal = $this->Note->find('all', array('fields' => array('SUM(Note.medication_order) as count'),
					 'conditions' => array('DATE_FORMAT(Note.medication_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			
			//Currently we are not using the NOTE table fields Note.medication_order_date--- Pooja
			
			/*$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=Note.patient_id')))));
			
			$cpoempatientlist = $this->Note->find('list', array('fields' => array('Note.patient_id', 'Note.patient_id'),
					 'conditions' => array('DATE_FORMAT(Note.medication_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
					 		'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type), 'recursive' => 1));*/
			
			$cpoempatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$cpoeMedicationNumeratorVal = $this->NewCropPrescription->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'),
					 'conditions' => array('NewCropPrescription.patient_uniqueid' =>$cpoempatientlist, 
					 		'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		  'Patient.doctor_id' => $searchProvider, 'NewCropPrescription.archive' => "N",
					 		 'Patient.admission_type' => $patient_type)));
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$cpoeMedicationDenominatorCVal = $this->NewCropPrescription->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'),
					 'conditions' => array('NewCropPrescription.patient_uniqueid' =>$cpoempatientlist, 
					 		'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		  'Patient.doctor_id' => $searchProvider, 'NewCropPrescription.archive' => "N", 
					 		'Patient.admission_type' => $patient_type)));
			$cpoeMedicationDenominatorVal = $cpoeMedicationDenominatorCVal[0][0]['count'] + $cpoeMedicationDenominatorMVal[0][0]['count'];
			
			$this->LaboratoryManualEntry->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoeLabDenominatorMVal = $this->LaboratoryManualEntry->find('all', array('fields' => array('SUM(LaboratoryManualEntry.lab_count) as count'), 'conditions' => array('DATE_FORMAT(LaboratoryManualEntry.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoelpatientlist = $this->LaboratoryTestOrder->find('list', array('fields' => array('Patient.id', 'Patient.id'), 'conditions' => array('DATE_FORMAT(LaboratoryTestOrder.lab_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'LaboratoryTestOrder.is_deleted' => 0, 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type), 'recursive' => 1));
			$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoeLabNumeratorVal = $this->LaboratoryTestOrder->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'), 'conditions' => array('LaboratoryTestOrder.patient_id' =>$cpoelpatientlist, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'LaboratoryTestOrder.order_id <>' => "", 'Patient.admission_type' => $patient_type)));
			$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoeLabDenominatorCVal = $this->LaboratoryTestOrder->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'), 'conditions' => array('LaboratoryTestOrder.patient_id' =>$cpoelpatientlist, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'LaboratoryTestOrder.order_id <>' => "", 'Patient.admission_type' => $patient_type)));
			$cpoeLabDenominatorVal = $cpoeLabDenominatorMVal[0][0]['count'] + $cpoeLabDenominatorCVal[0][0]['count'];
						
			$this->RadiologyManualEntry->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoeRadDenominatorMVal = $this->RadiologyManualEntry->find('all', array('fields' => array('SUM(RadiologyManualEntry.rad_count) as count'), 'conditions' => array('DATE_FORMAT(RadiologyManualEntry.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$this->RadiologyTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoerpatientlist = $this->RadiologyTestOrder->find('list', array('fields' => array('Patient.id', 'Patient.id'), 'conditions' => array('DATE_FORMAT(RadiologyTestOrder.radiology_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type), 'recursive' => 1));
			$this->RadiologyTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoeRadNumeratorVal = $this->RadiologyTestOrder->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'), 'conditions' => array('RadiologyTestOrder.patient_id' =>$cpoerpatientlist, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'RadiologyTestOrder.order_id <>' => "", 'Patient.admission_type' => $patient_type)));
			$this->RadiologyTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoeRadDenominatorCVal = $this->RadiologyTestOrder->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'), 'conditions' => array('RadiologyTestOrder.patient_id' =>$cpoerpatientlist, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'RadiologyTestOrder.order_id <>' => "", 'Patient.admission_type' => $patient_type)));
			$cpoeRadDenominatorVal = $cpoeRadDenominatorCVal[0][0]['count'] + $cpoeRadDenominatorMVal[0][0]['count'];
			
			// lab EH to EP calculation // 
			$this->Outbox->bindModel(array('belongsTo' => array('User' => array('foreignKey'=>false, 'conditions' => array('User.username=Outbox.to')))));
			$labehtoeaNumeratorVal = $this->Outbox->find('all', array('fields' => array('COUNT(Outbox.from) as count'), 'conditions' => array('DATE_FORMAT(Outbox.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'User.id' => $searchProvider,'User.location_id' => $this->Session->read('locationid'), 'Outbox.subject' => 'Lab Report')));
			$this->Inbox->bindModel(array('belongsTo' => array('User' => array('foreignKey'=>false, 'conditions' => array('User.username=Inbox.to')))));
			$labehtoeaDenominatorVal = $this->Inbox->find('all', array('fields' => array('COUNT(Inbox.to) as count'), 'conditions' => array('DATE_FORMAT(Inbox.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'User.location_id' => $this->Session->read('locationid'), 'Inbox.subject' => 'Lab Requisition')));
			
			// medication reconcilation calculation // 
			//BOF 1054
            //medical reconcile
            $this->IncorporatedPatient->bindModel(array('belongsTo' =>
                    array('Patient' => array('foreignKey'=>'patient_id'),
                            'NewCropPrescription'=>array('foreignKey'=>false,
                            		'conditions'=>array('NewCropPrescription.patient_uniqueid=IncorporatedPatient.patient_id')))));
           
            $medicationreconDenominatorVal = $this->IncorporatedPatient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'),
                    'conditions' => array('DATE_FORMAT(IncorporatedPatient.date_imported_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
                            'Patient.doctor_id' => $searchProvider,  'Patient.admission_type' => $patient_type)));
           
            $this->IncorporatedPatient->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
                    'NewCropPrescription'=>array('foreignKey'=>false,
                    		'conditions'=>array('NewCropPrescription.patient_uniqueid=IncorporatedPatient.patient_id')))));
           
            $medicationreconNumeratorVal = $this->IncorporatedPatient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'),
                    'conditions' => array('DATE_FORMAT(IncorporatedPatient.date_imported_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.doctor_id' => $searchProvider
                            , 'Patient.admission_type' => $patient_type,'NewCropPrescription.date_of_prescription  BETWEEN ? AND ? ' =>$bothTime,'NewCropPrescription.is_reconcile'=>1,'IncorporatedPatient.summary_provide'=>1)));
             //EOF 1054 
			
			
			// care of summary calculation // 
			$this->TransmittedCcda->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$summarycareDenominatorVal = $this->TransmittedCcda->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(TransmittedCcda.referral_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'TransmittedCcda.location_id' => $this->Session->read('locationid'), 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$this->TransmittedCcda->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$summarycareNumeratorVal = $this->TransmittedCcda->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(TransmittedCcda.referral_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'TransmittedCcda.location_id' => $this->Session->read('locationid'), 'Patient.doctor_id' => $searchProvider, 'TransmittedCcda.type' => array('other', 'ccda'), 'Patient.admission_type' => $patient_type)));
						
			// vital sign calculation //
			$doctorPreference = $this->DoctorProfile->find('first', array('fields' => array('DoctorProfile.height_weight','DoctorProfile.bp'),
					 'conditions' => array( 'DoctorProfile.user_id' => $searchProvider,
					 		 'DoctorProfile.location_id'=>$this->Session->read('locationid'),
					 		 'DoctorProfile.is_deleted' => 0,)));
			/*if($doctorPreference['DoctorProfile']['bp'] == 1 && $doctorPreference['DoctorProfile']['height_weight'] == 0){
				$condition['DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >'] = '3';
			} else {*/
				$condition['DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >='] = '0';
			//}
			
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$vitalsignDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		'Patient.admission_type' => $patient_type, 'Patient.doctor_id' => $searchProvider,$condition)));
			
			// when patient is within time and vital sign is recorded then it should come in numerator //
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$patientlist = $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		'Patient.admission_type' => $patient_type, 'Patient.doctor_id' => $searchProvider,$condition),
							 'recursive' => 1));
			
			/*if($doctorPreference['DoctorProfile']['bp'] == 1 && $doctorPreference['DoctorProfile']['height_weight'] == 0){
				$conditions['BmiBpResult']['systolic !='] = NULL;
                $conditions['BmiBpResult']['diastolic !='] = NULL;
			} else {*/
				$conditions['BmiResult']['height_result NOT'] = NULL;
                $conditions['BmiResult']['weight_result NOT'] = NULL;
                $conditions['BmiBpResult']['systolic !='] = NULL;
                $conditions['BmiBpResult']['diastolic !='] = NULL;
			//}
			$conditions = $this->postConditions($conditions);
			$this->BmiResult->bindModel(array('belongsTo' => array(
										'Patient' => array('foreignKey'=>'patient_id'),
										'Person' =>array('foreignKey' => false
												,'conditions'=>array('Person.id=Patient.person_id' )),
										'BmiBpResult'=>array('foreignKey' => false,'conditions'=>array('BmiBpResult.bmi_result_id=BmiResult.id'))
										)));
			$vitalsignNumeratorVal = $this->BmiResult->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('BmiResult.patient_id' => $patientlist, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,'Patient.admission_type' => $patient_type, 'Patient.doctor_id' => $searchProvider,$conditions,$condition)));// 'OR' => array(array('Note.icd <>' => "",'Note.icd_record' => 0), array('Note.icd' => "",'Note.icd_record' => 1)), 'Note.patient_id NOT' => array('', 0))));
			$this->set('ispost', $this->request->is('post'));
			$this->set('stage_type', $stage_type);
			$this->set(array('startdate' => $this->request->data['startdate'], 'provider' => $this->request->data['provider'], 'duration' => $this->request->data['duration'], 'stage_type' => $stage_type, 'patient_type' => $patient_type, 'year' => $this->request->data['year'])); 
			$this->set(array('demographicDenominatorVal' => $demographicDenominatorVal[0][0]['count'], 'demographicNumeratorVal' => $demographicNumeratorVal[0][0]['count'],'smokingstatusDenominatorVal' => $smokingstatusDenominatorVal[0][0]['count'], 'smokingstatusNumeratorVal' => $smokingstatusNumeratorVal[0][0]['count'], 'problemlistDenominatorVal' => $problemlistDenominatorVal[0][0]['count'], 'problemlistNumeratorVal' => $problemlistNumeratorVal[0][0]['count'], 'medicationlistDenominatorVal' => $medicationlistDenominatorVal[0][0]['count'], 'medicationlistNumeratorVal' => $medicationlistNumeratorVal[0][0]['count'], 'medicationAllergyDenominatorVal' => $medicationAllergyDenominatorVal[0][0]['count'], 'medicationAllergyNumeratorVal' => $medicationAllergyNumeratorVal[0][0]['count'], 'emarDenominatorVal' => $emarDenominatorVal[0][0]['count'], 'emarNumeratorVal' => $emarNumeratorVal[0][0]['count'], 'erxstage1DenominatorVal' => $erxstage1DenominatorVal[0][0]['count'], 'erxstage1NumeratorVal' => $erxstage1NumeratorVal[0][0]['count'], 'erxstage2DenominatorVal' => $erxstage2DenominatorVal, 'erxstage2NumeratorVal' => $erxstage2NumeratorVal));
			$this->set(array('labresultsDenominatorVal' => $labresultsDenominatorVal[0][0]['count'], 'labresultsNumeratorVal' => $labresultsNumeratorVal[0][0]['count'],'patientreminderDenominatorVal' => $patientreminderDenominatorVal[0][0]['count'], 'patientreminderNumeratorVal' => $patientreminderNumeratorVal[0][0]['count'],'viewdownloadDenominatorVal' => $viewdownloadDenominatorVal[0][0]['count'], 'viewdownloadNumeratorVal' => $viewdownloadNumeratorVal,'clinicalsummaryDenominatorVal' => $clinicalsummaryDenominatorVal[0][0]['count'], 'clinicalsummaryNumeratorVal' => $clinicalsummaryNumeratorVal[0][0]['count'],'patienteducationDenominatorVal' => $patienteducationDenominatorVal[0][0]['count'], 'patienteducationNumeratorVal' => $patienteducationNumeratorVal[0][0]['count'],'imagingDenominatorVal' => $imagingDenominatorVal, 'imagingNumeratorVal' => $imagingNumeratorVal[0][0]['count'],'familyhistoryDenominatorVal' => $familyhistoryDenominatorVal[0][0]['count'], 'familyhistoryNumeratorVal' => $familyhistoryNumeratorVal[0][0]['count']));
			$this->set(array('enotesDenominatorVal' => $enotesDenominatorVal[0][0]['count'], 'enotesNumeratorVal' => $enotesNumeratorVal[0][0]['count'],'advdirectiveDenominatorVal' => $advdirectiveDenominatorVal[0][0]['count'], 'advdirectiveNumeratorVal' => $advdirectiveNumeratorVal[0][0]['count'],'securemsgDenominatorVal' => $securemsgDenominatorVal[0][0]['count'], 'securemsgNumeratorVal' => $securemsgNumeratorVal[0][0]['count'],'viewdownloadDenominatorVal' => $viewdownloadDenominatorVal[0][0]['count'], 'viewdownloadNumeratorVal' => $viewdownloadNumeratorVal,'clinicalsummaryDenominatorVal' => $clinicalsummaryDenominatorVal[0][0]['count'], 'clinicalsummaryNumeratorVal' => $clinicalsummaryNumeratorVal[0][0]['count'],'patienteducationDenominatorVal' => $patienteducationDenominatorVal[0][0]['count'], 'patienteducationNumeratorVal' => $patienteducationNumeratorVal[0][0]['count'],'imagingDenominatorVal' => $imagingDenominatorVal, 'imagingNumeratorVal' => $imagingNumeratorVal[0][0]['count'],'medicationreconDenominatorVal' => $medicationreconDenominatorVal[0][0]['count'], 'medicationreconNumeratorVal' => $medicationreconNumeratorVal[0][0]['count']));
			$this->set(array('vitalsignDenominatorVal' => $vitalsignDenominatorVal[0][0]['count'],'vitalsignNumeratorVal' => $vitalsignNumeratorVal[0][0]['count'], 'summarycareDenominatorVal' => $summarycareDenominatorVal[0][0]['count'],'summarycareNumeratorVal' => $summarycareNumeratorVal[0][0]['count'], 'cpoeMedicationDenominatorVal' => $cpoeMedicationDenominatorVal,'cpoeMedicationNumeratorVal' => $cpoeMedicationNumeratorVal[0][0]['count'], 'cpoeLabDenominatorVal' => $cpoeLabDenominatorVal,'cpoeLabNumeratorVal' => $cpoeLabNumeratorVal[0][0]['count'], 'cpoeRadDenominatorVal' => $cpoeRadDenominatorVal,'cpoeRadNumeratorVal' => $cpoeRadNumeratorVal[0][0]['count'])); 
			
			
			
		}
		$this->set('doctorlist', $this->DoctorProfile->getDoctors());
		//$this->set(compact('reportStartDate','reportYear','reportDuration','searchProvider','patient_type'));
	}
	
	
    /*
	 * 
	 *  hospital automated measure calculation
	 * 
	 */
     public function admin_hospital_automated_measure_calculation() {
		$this->uses = array('DoctorProfile', 'Patient', 'PatientSmoking','Note','NewCropPrescription', 'NewCropAllergies','PrescriptionRecord','LaboratoryTestOrder','LaboratoryResult','Outbox','RadiologyTestOrder','RadiologyReport','FamilyHistory','AdvanceDirective', 'Note', 'Inbox', 'PatientReferral','TransmittedCcda', 'OutsideLabOrder');
		$this->set('title_for_layout', __('Measure Calculation', true));
				
		if($this->request->is('post')) { 
			$this->Patient->unbindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn', 'PrescriptionRecord', 'LaboratoryResult', 'LaboratoryTestOrder')));
			if($this->request->data['stage_type'] !=''){
				$stage_type = $this->request->data['stage_type'];
			}
			
			$patient_type = 'IPD';
			if($this->request->data['startdate'] !="" && $this->request->data['duration'] !="") {
				$expStartDate = explode("/", $this->request->data['startdate']);
				$startDate = $expStartDate[2]."-".$expStartDate[0]."-".$expStartDate[1];
				$addDays = $this->request->data['duration'];
				$endDate = date("Y-m-d", strtotime("+$addDays days", strtotime($startDate)));
				$bothTime = array($startDate, $endDate);
								
			}
			if($this->request->data['year'] !="" && $this->request->data['duration'] !="") {
				$expTwoDate = explode("_", $this->request->data['duration']);
				$startDate = $this->request->data['year']."-".$expTwoDate[0];
				$endDate = ($this->request->data['year']+1)."-".$expTwoDate[1];
				$bothTime = array($startDate, $endDate);
			} 
			
			$this->Patient->unbindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));
			$withinPatientList =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			// demographic calculation //
			$demographicDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'), 'DeathSummary' => array('foreignKey'=> false, 'conditions' => array('Patient.id=DeathSummary.patient_id')))));
			$demographicNumeratorVal = $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('Patient.id' =>$withinPatientList, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'OR' => array(array('Person.ethnicity <>' => "", 'Person.race <>' => "", 'Person.language <>' => ""), 'DeathSummary.death_cause <>' => '' , 'DeathSummary.death_on <>' => ''), 'Patient.admission_type' => $patient_type)));
			
			// smoking status calculation //
			$smokingstatusDenominatorVal =  $this->Patient->find('all', array(
					'fields' => array('COUNT(DISTINCT Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
					 		'Patient.admission_type' => $patient_type)));
			$this->PatientSmoking->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
			                                                            'Person' => array('foreignKey'=>false, 'conditions' => array('Person.id=Patient.person_id'))
			                                                            )));
			$smokingstatusNumeratorVal = $this->PatientSmoking->find('all', array(
					'fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 
					'conditions' => array('Patient.id' =>$withinPatientList, 
							'Patient.location_id'=>$this->Session->read('locationid'),
							 'Patient.is_deleted' => 0,'PatientSmoking.patient_id NOT' => array('', 0) , 
							'PatientSmoking.current_smoking_fre <>' => "", 'Patient.admission_type' => $patient_type,
							/*'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >' => 13*/
							'DATEDIFF(CURDATE(),Person.dob)/365 >'=>'13')));
			
			// problem list calculation //
			$problemlistDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$problemlistNumeratorVal = $this->Note->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type, 'OR' => array('Note.icd <>' => "", array('NOT' => array('Note.icd_record' => NULL))), 'Note.patient_id NOT' => array('', 0))));
		 
			
			// medication list calculation //
			$medicationlistDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			// patient list //
			$mlpatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$medicationlistNumeratorVal = $this->NewCropPrescription->find('all', array(
					'fields' => array('COUNT(DISTINCT Patient.patient_id) as count'),
					 'conditions' => array('Patient.location_id'=>$this->Session->read('locationid'),
					 		 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type, 
					 		'NewCropPrescription.patient_uniqueid' => $mlpatientlist, 'NewCropPrescription.uncheck' => array(0,1))));
			
			// medication allergy calculation //
			$medicationAllergyDenominatorVal =  $this->Patient->find('all', array(
					'fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,  'Patient.admission_type' => $patient_type)));
			$mapatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			$this->NewCropAllergies->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.patient_id=NewCropAllergies.patient_id')))));
			$medicationAllergyNumeratorVal = $this->NewCropAllergies->find('all', array(
					'fields' => array('COUNT(DISTINCT Patient.patient_id) as count'),
					 'conditions' => array('Patient.location_id'=>$this->Session->read('locationid'),
					 		 'Patient.is_deleted' => 0, 'NewCropAllergies.patient_uniqueid' => $mapatientlist,
					 		 'Patient.admission_type' => $patient_type, 'NewCropAllergies.allergycheck' => array(0,1),
					 		'NewCropAllergies.status'=>'A')));
						
			// emar calculation //
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$emarDenominatorVal = $this->NewCropPrescription->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type, 'NewCropPrescription.description <>' => "")));
			$this->PrescriptionRecord->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false, 'conditions' => array('Patient.patient_id=PrescriptionRecord.patient_uid')))));
			$emarNumeratorVal =  $this->PrescriptionRecord->find('all', array('fields' => array('COUNT(DISTINCT PrescriptionRecord.patient_uid) as count'), 'conditions' => array('DATE_FORMAT(PrescriptionRecord.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type, 'PrescriptionRecord.medication <>' => "")));
			
			// erx calculation for stage1 //
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$erxstage1DenominatorVal = $this->NewCropPrescription->find('all', array('fields' => array('SUM(NewCropPrescription.no_of_prescription_controlled) as count'), 'conditions' => array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$erxstage1NumeratorVal = $this->NewCropPrescription->find('all', array('fields' => array('SUM(NewCropPrescription.no_of_transmitted_prescription_controlled) as count'), 'conditions' => array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			// erx calculation for stage2 //
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$erxstage2DenominatorVal = $this->NewCropPrescription->find('all', array('fields' => array('SUM(NewCropPrescription.no_of_prescription_controlled) as count'), 'conditions' => array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$erxstage2NumeratorVal = $this->NewCropPrescription->find('all', array('fields' => array('SUM(NewCropPrescription.no_of_transmitted_prescription_controlled) as count'), 'conditions' => array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$erxstage2DenominatorVal = $this->NewCropPrescription->find('all', array('fields' => array('SUM(NewCropPrescription.no_of_prescription_not_controlled) as count'), 'conditions' => array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$erxstage2NumeratorVal = $this->NewCropPrescription->find('all', array(
					'fields' => array('SUM(NewCropPrescription.no_of_transmitted_prescription_not_controlled) as count'), 
					'conditions' => array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			
			// lab results calculation //
			$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$labresultsDenominatorVal = $this->LaboratoryTestOrder->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(LaboratoryTestOrder.start_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type, 'LaboratoryTestOrder.order_id <>' => "")));
			$this->LaboratoryResult->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$labresultsNumeratorVal = $this->LaboratoryResult->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(LaboratoryResult.result_publish_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type, 'LaboratoryResult.laboratory_test_order_id <>' => "")));
			
			// patient reminder calculation //
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$patientreminderDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,  'Patient.admission_type' => $patient_type, 'OR' => array('DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >=' => 65, 'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 <=' => 5))));
			$this->Outbox->bindModel(array('belongsTo' => array('User' => array('foreignKey'=>false, 'conditions' => array('User.username=Outbox.from')))));
			$patientreminderNumeratorVal = $this->Outbox->find('all', array('fields' => array('COUNT(DISTINCT Outbox.to) as count'), 'conditions' => array('DATE_FORMAT(Outbox.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Outbox.is_patient' => 0, 'Outbox.subject' => 'Reminder')));
			
			// view, download and transmit calculation //
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$viewdownloadDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$viewdownloadNumeratorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.discharge_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type, 'Person.is_first_login' => 1)));
			
			// clinical summary calculation //
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$clinicalsummaryDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$clinicalsummaryNumeratorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type, 'Person.is_first_login' => 1)));
			
			// patient education calculation //
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$patienteducationDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$patienteducationNumeratorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('Patient.id' =>$withinPatientList, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type, 'Person.password <>' => '')));
			
			// imaging calculation //
			$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$imagingDenominatorVal1 =  $this->LaboratoryTestOrder->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(LaboratoryTestOrder.start_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			$this->RadiologyTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$imagingDenominatorVal2 =  $this->RadiologyTestOrder->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(RadiologyTestOrder.start_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			$imagingDenominatorVal = $imagingDenominatorVal1[0][0]['count']+$imagingDenominatorVal2[0][0]['count'];
			$this->RadiologyReport->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$imagingNumeratorVal =  $this->RadiologyReport->find('all', array('fields' => array('COUNT(RadiologyReport.patient_id) as count'), 'conditions' => array('DATE_FORMAT(RadiologyReport.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'RadiologyReport.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			
			// family history calculation //
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$familyhistoryDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			$this->FamilyHistory->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$familyhistoryNumeratorVal =  $this->FamilyHistory->find('all', array('fields' => array('COUNT(DISTINCT FamilyHistory.patient_id) as count'), 'conditions' => array('DATE_FORMAT(FamilyHistory.created, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			
			// e-notes calculation //
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$enotesDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$enotesNumeratorVal =  $this->Note->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Note.note_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			
			// advance directive calculation //
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$advdirectiveDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS(Person.dob ) ) , "%Y" ) +0 >=' => 65, 'Patient.is_emergency <>'=> 1, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$advdirectivePatientList =  $this->Patient->find('list', array('fields' => array('Patient.id', 'Patient.id'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >=' => 65, 'Patient.is_emergency <>'=> 1, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type), 'recursive' => 1));
			$this->AdvanceDirective->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false, '' => array('AdvanceDirective.patient_id=Patient.admission_id')))));
			$advdirectiveNumeratorVal =  $this->AdvanceDirective->find('all', array('fields' => array('COUNT(DISTINCT AdvanceDirective.patient_id) as count'), 'conditions' => array('Patient.id' => $advdirectivePatientList, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			
			// secure message calculation(not included ammendment, lab report, lab requisition, reminder, refferal summary) //
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$securemsgDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0)));
			$this->Inbox->bindModel(array('belongsTo' => array('User' => array('foreignKey'=>false, 'conditions' => array('User.username=Inbox.to')))));
			$securemsgNumeratorVal = $this->Inbox->find('all', array('fields' => array('COUNT(DISTINCT Inbox.from) as count'), 'conditions' => array('DATE_FORMAT(Inbox.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'User.location_id' => $this->Session->read('locationid'), 'Inbox.is_patient' => 1)));
			
			// cpoe calculation include three section ie for medication, laboratory and radiology//
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$cpoeMedicationDenominatorVal = $this->NewCropPrescription->find('all', array('fields' => array('SUM(NewCropPrescription.medication_order) as count'), 'conditions' => array('DATE_FORMAT(NewCropPrescription.medication_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$cpoempatientlist = $this->NewCropPrescription->find('list', array('fields' => array('Patient.id', 'Patient.id'), 'conditions' => array('DATE_FORMAT(NewCropPrescription.medication_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type), 'recursive' => 1));
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$cpoeMedicationNumeratorVal = $this->NewCropPrescription->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('NewCropPrescription.patient_uniqueid' =>$cpoempatientlist, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'NewCropPrescription.archive' => "N", 'Patient.admission_type' => $patient_type)));
			
			$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoeLabDenominatorVal = $this->LaboratoryTestOrder->find('all', array('fields' => array('SUM(LaboratoryTestOrder.lab_order) as count'), 'conditions' => array('DATE_FORMAT(LaboratoryTestOrder.lab_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoelpatientlist = $this->LaboratoryTestOrder->find('list', array('fields' => array('Patient.id', 'Patient.id'), 'conditions' => array('DATE_FORMAT(LaboratoryTestOrder.lab_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type), 'recursive' => 1));
			$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoeLabNumeratorVal = $this->LaboratoryTestOrder->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('LaboratoryTestOrder.patient_id' =>$cpoelpatientlist, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'LaboratoryTestOrder.order_id <>' => "", 'Patient.admission_type' => $patient_type)));
			
			$this->RadiologyTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoeRadDenominatorVal = $this->RadiologyTestOrder->find('all', array('fields' => array('SUM(RadiologyTestOrder.radiology_order) as count'), 'conditions' => array('DATE_FORMAT(RadiologyTestOrder.radiology_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type)));
			$this->RadiologyTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoerpatientlist = $this->RadiologyTestOrder->find('list', array('fields' => array('Patient.id', 'Patient.id'), 'conditions' => array('DATE_FORMAT(RadiologyTestOrder.radiology_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => $patient_type), 'recursive' => 1));
			$this->RadiologyTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoeLabNumeratorVal = $this->RadiologyTestOrder->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('RadiologyTestOrder.patient_id' =>$cpoerpatientlist, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'RadiologyTestOrder.order_id <>' => "", 'Patient.admission_type' => $patient_type)));
			
			// lab EH to EP calculation // 
			//$this->OutsideLabOrder->bindModel(array('belongsTo' => array('User' => array('foreignKey'=>false, 'conditions' => array('User.username=Outbox.to')))));
			$labehtoeaDenominatorVal = $this->OutsideLabOrder->find('all', array('fields' => array('SUM(OutsideLabOrder.no_of_orders) as count'), 'conditions' => array('DATE_FORMAT(OutsideLabOrder.date_of_requisition, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'OutsideLabOrder.received_from' => 'Ambulatory Setting')));
			$labehtoeaNumeratorVal = $this->OutsideLabOrder->find('all', array('fields' => array('SUM(OutsideLabOrder.clinical_lab_result) as count'), 'conditions' => array('DATE_FORMAT(OutsideLabOrder.date_of_requisition, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime , 'OutsideLabOrder.confirm_result'=> '1', 'OutsideLabOrder.received_from' => 'Ambulatory Setting')));
			//$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			//$labehtoeaDenominatorVal =  $this->LaboratoryTestOrder->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(LaboratoryTestOrder.start_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => 'OPD')));
			//$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			//$labOrderPatientList =  $this->LaboratoryTestOrder->find('list', array('fields' => array('LaboratoryTestOrder.patient_id','LaboratoryTestOrder.patient_id'), 'conditions' => array('DATE_FORMAT(LaboratoryTestOrder.start_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => 'OPD')));
			//$this->LaboratoryResult->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			//$labehtoeaNumeratorVal =  $this->LaboratoryResult->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'), 'conditions' => array('Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => 'OPD', 'Patient.id' => $labOrderPatientList)));
			
			// medication reconcilation calculation // 
			$this->PatientReferral->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$medicationreconDenominatorVal = $this->PatientReferral->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(PatientReferral.date_of_issue, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'PatientReferral.location_id' => $this->Session->read('locationid'), 'Patient.admission_type' => $patient_type)));
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$medicationreconNumeratorVal = $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id' => $this->Session->read('locationid'), 'Patient.admission_type' => $patient_type)));
			
			// care of summary calculation // 
			$this->TransmittedCcda->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$summarycareDenominatorVal = $this->TransmittedCcda->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(TransmittedCcda.referral_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'TransmittedCcda.location_id' => $this->Session->read('locationid'), 'Patient.admission_type' => $patient_type)));
			$this->TransmittedCcda->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$summarycareNumeratorVal = $this->TransmittedCcda->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(TransmittedCcda.referral_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'TransmittedCcda.location_id' => $this->Session->read('locationid'), 'TransmittedCcda.type' => array('other', 'ccda'), 'Patient.admission_type' => $patient_type)));
						
			// vital sign calculation //
			$doctorPreference = $this->DoctorProfile->find('first', array('fields' => array('DoctorProfile.height_weight','DoctorProfile.bp'), 'conditions' => array( 'DoctorProfile.user_id' => $searchProvider, 'DoctorProfile.location_id'=>$this->Session->read('locationid'), 'DoctorProfile.is_deleted' => 0,)));
		/*	if($doctorPreference['DoctorProfile']['height_weight']!='' && $doctorPreference['DoctorProfile']['bp']==''){

				$conditions['DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 <='] = '3';
			}*/

			if($doctorPreference['DoctorProfile']['bp']!='' && $doctorPreference['DoctorProfile']['height_weight']==''){

				$conditions['DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >='] = '3';
			}
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$vitalsignDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,'Patient.admission_type' => $patient_type, 'Patient.doctor_id' => $searchProvider,$conditions)));
			if($doctorPreference['DoctorProfile']['height_weight']!=''){

				$conditions['Note']['ht !='] = '';

				$conditions['Note']['wt !='] = '';

			}

			if($doctorPreference['DoctorProfile']['bp']!='' ){
				$conditions['Note']['bp !='] = '';
			}
			$conditions = $this->postConditions($conditions);
			$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			if($doctorPreference['DoctorProfile']['bp']!='' )
			$vitalsignNumeratorBP = $this->Note->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Note.vital_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,$conditions)));
			if($doctorPreference['DoctorProfile']['height_weight']!='')
			$vitalsignNumeratorHT_WT = $this->Note->find('all', array('fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Note.finalization_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,$conditions)));
			
			$vitalsignNumeratorVal[0][0]['count'] = $vitalsignNumeratorHT_WT[0][0]['count'] + $vitalsignNumeratorBP[0][0]['count'];
			
			$this->set('ispost', $this->request->is('post'));
			$this->set('stage_type', $stage_type);
			$this->set(array('startdate' => $this->request->data['startdate'], 'provider' => $this->request->data['provider'], 'duration' => $this->request->data['duration'], 'stage_type' => $stage_type, 'year' => $this->request->data['year']));
			$this->set(array('demographicDenominatorVal' => $demographicDenominatorVal[0][0]['count'], 'demographicNumeratorVal' => $demographicNumeratorVal[0][0]['count'],'smokingstatusDenominatorVal' => $smokingstatusDenominatorVal[0][0]['count'], 'smokingstatusNumeratorVal' => $smokingstatusNumeratorVal[0][0]['count'], 'problemlistDenominatorVal' => $problemlistDenominatorVal[0][0]['count'], 'problemlistNumeratorVal' => $problemlistNumeratorVal[0][0]['count'], 'medicationlistDenominatorVal' => $medicationlistDenominatorVal[0][0]['count'], 'medicationlistNumeratorVal' => $medicationlistNumeratorVal[0][0]['count'], 'medicationAllergyDenominatorVal' => $medicationAllergyDenominatorVal[0][0]['count'], 'medicationAllergyNumeratorVal' => $medicationAllergyNumeratorVal[0][0]['count'], 'emarDenominatorVal' => $emarDenominatorVal[0][0]['count'], 'emarNumeratorVal' => $emarNumeratorVal[0][0]['count'], 'erxDenominatorVal' => $erxDenominatorVal[0][0]['count'], 'erxNumeratorVal' => $erxNumeratorVal[0][0]['count']));
			$this->set(array('labresultsDenominatorVal' => $labresultsDenominatorVal[0][0]['count'], 'labresultsNumeratorVal' => $labresultsNumeratorVal[0][0]['count'],'patientreminderDenominatorVal' => $patientreminderDenominatorVal[0][0]['count'], 'patientreminderNumeratorVal' => $patientreminderNumeratorVal[0][0]['count'],'viewdownloadDenominatorVal' => $viewdownloadDenominatorVal[0][0]['count'], 'viewdownloadNumeratorVal' => $viewdownloadNumeratorVal[0][0]['count'],'clinicalsummaryDenominatorVal' => $clinicalsummaryDenominatorVal[0][0]['count'], 'clinicalsummaryNumeratorVal' => $clinicalsummaryNumeratorVal[0][0]['count'],'patienteducationDenominatorVal' => $patienteducationDenominatorVal[0][0]['count'], 'patienteducationNumeratorVal' => $patienteducationNumeratorVal[0][0]['count'],'imagingDenominatorVal' => $imagingDenominatorVal, 'imagingNumeratorVal' => $imagingNumeratorVal[0][0]['count'],'familyhistoryDenominatorVal' => $familyhistoryDenominatorVal[0][0]['count'], 'familyhistoryNumeratorVal' => $familyhistoryNumeratorVal[0][0]['count']));
			$this->set(array('enotesDenominatorVal' => $enotesDenominatorVal[0][0]['count'], 'enotesNumeratorVal' => $enotesNumeratorVal[0][0]['count'],'advdirectiveDenominatorVal' => $advdirectiveDenominatorVal[0][0]['count'], 'advdirectiveNumeratorVal' => $advdirectiveNumeratorVal[0][0]['count'],'securemsgDenominatorVal' => $securemsgDenominatorVal[0][0]['count'], 'securemsgNumeratorVal' => $securemsgNumeratorVal[0][0]['count'],'viewdownloadDenominatorVal' => $viewdownloadDenominatorVal[0][0]['count'], 'viewdownloadNumeratorVal' => $viewdownloadNumeratorVal[0][0]['count'],'clinicalsummaryDenominatorVal' => $clinicalsummaryDenominatorVal[0][0]['count'], 'clinicalsummaryNumeratorVal' => $clinicalsummaryNumeratorVal[0][0]['count'],'patienteducationDenominatorVal' => $patienteducationDenominatorVal[0][0]['count'], 'patienteducationNumeratorVal' => $patienteducationNumeratorVal[0][0]['count'],'imagingDenominatorVal' => $imagingDenominatorVal, 'imagingNumeratorVal' => $imagingNumeratorVal[0][0]['count'],'medicationreconDenominatorVal' => $medicationreconDenominatorVal[0][0]['count'], 'medicationreconNumeratorVal' => $medicationreconNumeratorVal[0][0]['count']));
			$this->set(array('vitalsignDenominatorVal' => $vitalsignDenominatorVal[0][0]['count'],'vitalsignNumeratorVal' => $vitalsignNumeratorVal[0][0]['count'], 'summarycareDenominatorVal' => $summarycareDenominatorVal[0][0]['count'],'summarycareNumeratorVal' => $summarycareNumeratorVal[0][0]['count'], 'cpoeMedicationDenominatorVal' => $cpoeMedicationDenominatorVal[0][0]['count'],'cpoeMedicationNumeratorVal' => $cpoeMedicationNumeratorVal[0][0]['count'], 'cpoeLabDenominatorVal' => $cpoeLabDenominatorVal[0][0]['count'],'cpoeLabNumeratorVal' => $cpoeLabNumeratorVal[0][0]['count'], 'cpoeRadDenominatorVal' => $cpoeRadDenominatorVal[0][0]['count'],'cpoeRadNumeratorVal' => $cpoeRadNumeratorVal[0][0]['count'],'labehtoeaDenominatorVal' => $labehtoeaDenominatorVal[0][0]['count'],'labehtoeaNumeratorVal' => $labehtoeaNumeratorVal[0][0]['count']));
			
			
			
			
		}
		
		
	}

	
	/*
	 * Function minimum_denominator_automated_measure
	 * Pooja Gupta
	 * 
	   */
	public function minimum_denominator_automated_measure(){
		$this->uses = array('DoctorProfile', 'Patient', 'PatientSmoking','Note','NewCropPrescription', 'NewCropAllergies',
				'PrescriptionRecord','LaboratoryTestOrder','LaboratoryResult','Outbox','RadiologyTestOrder',
				'RadiologyReport','FamilyHistory','AdvanceDirective', 'Note', 'Inbox', 'PatientReferral', 
				'TransmittedCcda', 'XmlNote', 'LaboratoryManualEntry', 'RadiologyManualEntry', 'IncorporatedPatient');
		$report=$this->request->params['named']['report'];
		$startdate=$this->request->params['named']['sd'];
		$year=$this->request->params['named']['year'];
		$duration=$this->request->params['named']['duration'];
		$patient_type=$this->request->params['named']['patient_type'];
		$searchProvider=$this->request->params['named']['provider'];
		$stage_type=$this->request->params['named']['stage_type'];
		//$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
		if($startdate!="" && $duration !="") {
			$startdate=date('Y-m-d',strtotime($startdate));
			$addDays = $duration;
			$endDate = date("Y-m-d", strtotime("+$addDays days", strtotime($startdate)));
			$bothTime = array($startdate, $endDate);
			}
		
		if($year !="" && $duration !="") {
			$expTwoDate = explode("_", $duration);
			$startDate = $year."-".$expTwoDate[0];
			$endDate = $year."-".$expTwoDate[1];
			$bothTime = array($startDate, $endDate);
		}
		if($report=='problemlist'){
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
			$problemlistDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'),
							 'Patient.is_deleted' => 0,'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type),
					'group'=>array('Patient.patient_id')));
			$this->set('denominatorVal',$problemlistDenominatorVal);
		}
		elseif($report=='medicationlist'){
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
			$medicationlistDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
							'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->set('denominatorVal',$medicationlistDenominatorVal);
		}
		elseif($report=='medicationAllergy'){
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
			$medicationAllergyDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
							'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->set('denominatorVal',$medicationAllergyDenominatorVal);
		}
		elseif($report=='cpoeMedication'){
			$this->Note->bindModel(array('belongsTo' => array(
					'Patient' => array('foreignKey'=>false, 'conditions' => array('Patient.id=Note.patient_id')),
					'Person'=>array('foreignKey'=>false,'conditions' => array('Person.id=Patient.person_id')))));
			$cpoeMedicationDenominatorMVal = $this->Note->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(Note.medication_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
							'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			
			$cpoempatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			
			$this->Patient->bindModel(array('belongsTo' => array('NewCropPrescription' => array('foreignKey'=>false,
					'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')),
					'Person'=>array('Patient.person_id=Person.id'))));
			
			$cpoeMedicationDenominatorCVal = $this->Patient->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number','Person.dob'),
					'conditions' => array('NewCropPrescription.patient_uniqueid' =>$cpoempatientlist,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.doctor_id' => $searchProvider, 'NewCropPrescription.archive' => "N",
							'Patient.admission_type' => $patient_type)));
			
			$cpoeMedicationDenominator=array_merge($cpoeMedicationDenominatorMVal,$cpoeMedicationDenominatorCVal);
			
			$this->set('denominatorVal',$cpoeMedicationDenominator);
		}
		elseif($report=='cpoeLab'){
			$this->LaboratoryManualEntry->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
					'Person'=>array('foreignKey'=>false,'conditions' => array('Person.id=Patient.person_id')))));
			$cpoeLabDenominatorMVal = $this->LaboratoryManualEntry->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(LaboratoryManualEntry.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
							'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoelpatientlist = $this->LaboratoryTestOrder->find('list', array('fields' => array('Patient.id', 'Patient.id'), 
					'conditions' => array('DATE_FORMAT(LaboratoryTestOrder.lab_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'LaboratoryTestOrder.is_deleted' => 0, 
							'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type), 
							'recursive' => 1));
			$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
					'Person'=>array('foreignKey'=>false,'conditions' => array('Person.id=Patient.person_id')))));
			$cpoeLabDenominatorCVal = $this->LaboratoryTestOrder->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('LaboratoryTestOrder.patient_id' =>$cpoelpatientlist, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
							'Patient.doctor_id' => $searchProvider, 'LaboratoryTestOrder.order_id <>' => "",
							 'Patient.admission_type' => $patient_type)));
			$cpoeLabDenominatorVal=array_merge($cpoeLabDenominatorMVal,$cpoeLabDenominatorCVal);
			$this->set('denominatorVal',$cpoeLabDenominatorVal);
		}
		elseif($report=='cpoeRad'){
			$this->RadiologyManualEntry->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
					'Person'=>array('foreignKey'=>false,'conditions' => array('Person.id=Patient.person_id')))));
			$cpoeRadDenominatorMVal = $this->RadiologyManualEntry->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(RadiologyManualEntry.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
							'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			
			$this->RadiologyTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoerpatientlist = $this->RadiologyTestOrder->find('list', array('fields' => array('Patient.id', 'Patient.id'), 'conditions' => array('DATE_FORMAT(RadiologyTestOrder.radiology_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type), 'recursive' => 1));
				
			$this->RadiologyTestOrder->bindModel(array('belongsTo' => array(
					'Patient' => array('foreignKey'=>false,'conditions'=>array('RadiologyTestOrder.patient_id=Patient.id')),
					'Person'=>array('foreignKey'=>false,'conditions' => array('Person.id=Patient.person_id')))));
			
			$cpoeRadDenominatorCVal = $this->RadiologyTestOrder->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'),
					 'conditions' => array('RadiologyTestOrder.patient_id' =>$cpoerpatientlist, 
					 		'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
					 		'Patient.doctor_id' => $searchProvider, 'RadiologyTestOrder.order_id <>' => "",
					 		 'Patient.admission_type' => $patient_type)));
			$cpoeRadDenominator=array_merge($cpoeRadDenominatorMVal,$cpoeRadDenominatorCVal);
				
			$this->set('denominatorVal',$cpoeRadDenominator);
		}
		elseif($report=='erxstage2'){
			$this->NewCropPrescription->bindModel(array('belongsTo' => array(
					'Patient' => array('foreignKey'=>false, 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')),
					'Person'=>array('foreignKey'=>false,'conditions' => array('Person.id=Patient.person_id')))));
			$erxstage2DenominatorCVal = $this->NewCropPrescription->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
							'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->set('denominatorVal',$erxstage2DenominatorCVal);
		}
		elseif($report=='erxstage1'){
			$this->NewCropPrescription->bindModel(array('belongsTo' => array(
					'Patient' => array('foreignKey'=>false, 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')),
					'Person'=>array('foreignKey'=>false,'conditions' => array('Person.id=Patient.person_id')))));
			$erxstage1DenominatorVal = $this->NewCropPrescription->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
							'Patient.admission_type' => $patient_type)));
			$this->set('denominatorVal',$erxstage1DenominatorVal);
		}
		elseif($report=='demographic'){
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
			$demographicDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
							'Patient.doctor_id' => $searchProvider,'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->set('denominatorVal',$demographicDenominatorVal);
		}
		elseif($report=='vitalsign'){
			
			$doctorPreference = $this->DoctorProfile->find('first', array('fields' => array('DoctorProfile.height_weight','DoctorProfile.bp'), 'conditions' => array( 'DoctorProfile.user_id' => $searchProvider, 'DoctorProfile.location_id'=>$this->Session->read('locationid'), 'DoctorProfile.is_deleted' => 0,)));
			if($doctorPreference['DoctorProfile']['bp'] == 1 && $doctorPreference['DoctorProfile']['height_weight'] == 0){
				$condition['DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >'] = '3';
			} else {
				$condition['DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >='] = '0';
			}
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$vitalsignDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.admission_type' => $patient_type, 'Patient.doctor_id' => $searchProvider,$condition),'group'=>array('Patient.patient_id')));
			$this->set('denominatorVal',$vitalsignDenominatorVal);
		}
		elseif($report=='smokingstatus'){
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
			$smokingstatusDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
					 		'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
					 		'Patient.doctor_id' => $searchProvider,'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->set('denominatorVal',$smokingstatusDenominatorVal);
		}
		elseif($report=='labresults'){
			$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
					'Person'=>array('foreignKey'=>false,'conditions' => array('Person.id=Patient.person_id')))));
			$labresultsDenominatorVal = $this->LaboratoryTestOrder->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(LaboratoryTestOrder.start_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'LaboratoryTestOrder.is_deleted' => 0, 
							'Patient.doctor_id' => $searchProvider,'Patient.admission_type' => $patient_type, 'LaboratoryTestOrder.order_id <>' => "")));
			$this->set('denominatorVal',$labresultsDenominatorVal);
		}
		elseif($report=='patientreminder'){
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$patientreminderDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
							'Patient.admission_type' => $patient_type, 
							'OR' => array('DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >=' => 65, 
							'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 <=' => 5)),'group'=>array('Patient.patient_id')));
			$this->set('denominatorVal',$patientreminderDenominatorVal);
		}
		elseif($report=='viewdownload'){
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$viewdownloadDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->set('denominatorVal',$viewdownloadDenominatorVal);
		}
		elseif($report=='clinicalsummary'){
			$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
				'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id'=>'Patient.person_id')))));
			$clinicalsummaryDenominatorVal = $this->Note->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
							'Patient.admission_type' => $patient_type )));
			$this->set('denominatorVal',$clinicalsummaryDenominatorVal);
		}
		elseif($report=='patienteducation'){
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$patienteducationDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
							'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->set('denominatorVal',$patienteducationDenominatorVal);
		}
		elseif($report=='medicationrecon'){
			$this->IncorporatedPatient->bindModel(array('belongsTo' =>
					array('Patient' => array('foreignKey'=>'patient_id'),
							'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id'=>'Patient.person_id')),
							'NewCropPrescription'=>array('foreignKey'=>false,'conditions'=>array('NewCropPrescription.patient_uniqueid=IncorporatedPatient.patient_id')))));
			 
			$medicationreconDenominatorVal = $this->IncorporatedPatient->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'),
					'conditions' => array('DATE_FORMAT(IncorporatedPatient.date_imported_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.doctor_id' => $searchProvider,  'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->set('denominatorVal',$medicationreconDenominatorVal);
		}
		elseif($report=='summarycare'){
			$this->TransmittedCcda->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
					'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id'=>'Patient.person_id')))));
			$summarycareDenominatorVal = $this->TransmittedCcda->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(TransmittedCcda.referral_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'TransmittedCcda.location_id' => $this->Session->read('locationid'), 'Patient.doctor_id' => $searchProvider, 
							'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->set('denominatorVal',$summarycareDenominatorVal);
		}
		elseif($report=='securemsg'){
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$securemsgDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							 'Patient.doctor_id' => $searchProvider),'group'=>array('Patient.patient_id')));
			$this->set('denominatorVal',$securemsgDenominatorVal);
		}
		elseif($report=='imaging'){
			$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
					'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id'=>'Patient.person_id')))));
			$imagingDenominatorVal1 =  $this->LaboratoryTestOrder->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(LaboratoryTestOrder.start_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
							'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->RadiologyTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
					'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id'=>'Patient.person_id')))));
			$imagingDenominatorVal2 =  $this->RadiologyTestOrder->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'),
					 'conditions' => array('DATE_FORMAT(RadiologyTestOrder.start_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
					 		'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
					 		'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$imagingDenominatorVal=array_merge($imagingDenominatorVal1,$imagingDenominatorVal2);
			$this->set('denominatorVal',$imagingDenominatorVal);
		}
		elseif($report=='familyhistory'){
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$familyhistoryDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
							'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->set('denominatorVal',$familyhistoryDenominatorVal);
		}
		elseif($report=='enotes'){
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$enotesDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->set('denominatorVal',$enotesDenominatorVal);
		}
		elseif($report=='advdirective'){
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$advdirectiveDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >=' => 65, 
							'Patient.is_emergency <>'=> 1, 'Patient.location_id'=>$this->Session->read('locationid'), 
							'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->set('denominatorVal',$advdirectiveDenominatorVal);
		}
		elseif($report=='labehtoea'){
			$this->Inbox->bindModel(array('belongsTo' => array('User' => array('foreignKey'=>false, 
					'conditions' => array('User.username=Inbox.to')))));
			$labehtoeaDenominatorVal = $this->Inbox->find('all', array('fields' => array('COUNT(Inbox.to) as count'), 
					'conditions' => array('DATE_FORMAT(Inbox.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'User.location_id' => $this->Session->read('locationid'), 'Inbox.subject' => 'Lab Requisition')));
			$this->set('denominatorVal',$labehtoeaDenominatorVal);
		}
		elseif($report=='emar'){
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false, 
					'conditions' => array('Patient.patient_id=NewCropPrescription.patient_id')),
					'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id'=>'Patient.person_id')))));
			$emarDenominatorVal = $this->NewCropPrescription->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
							 'NewCropPrescription.description <>' => ""),'group'=>array('Patient.patient_id')));
			$this->set('denominatorVal',$emarDenominatorVal);
		}
		$this->set('date',$bothTime);
		$providerName=$this->DoctorProfile->find('first',array('fields'=>array('doctor_name'),'conditions'=>array('DoctorProfile.user_id'=>$searchProvider)));
		$this->set('provider',$providerName);
	}
	
	public function minimum_numerator_automated_measure(){
		$this->uses = array('DoctorProfile', 'Patient', 'PatientSmoking','Note','NewCropPrescription', 'NewCropAllergies',
				'PrescriptionRecord','LaboratoryTestOrder','LaboratoryResult','Outbox','RadiologyTestOrder','BmiResult',
				'RadiologyReport','FamilyHistory','AdvanceDirective', 'Note', 'Inbox', 'PatientReferral',
				'TransmittedCcda', 'XmlNote', 'LaboratoryManualEntry', 'RadiologyManualEntry', 'IncorporatedPatient');
		$report=$this->request->params['named']['report'];
		$startdate=$this->request->params['named']['sd'];
		$year=$this->request->params['named']['year'];
		$duration=$this->request->params['named']['duration'];
		$patient_type=$this->request->params['named']['patient_type'];
		$searchProvider=$this->request->params['named']['provider'];
		$stage_type=$this->request->params['named']['stage_type'];
		if($startdate!="" && $duration !="") {
			$addDays = $duration;
			$endDate = date("Y-m-d", strtotime("+$addDays days", strtotime($startdate)));
			$bothTime = array($startdate, $endDate);		
		}
				
		if($year !="" && $duration !="") {
			$expTwoDate = explode("_", $duration);
			$startDate = $year."-".$expTwoDate[0];
			$endDate = $year."-".$expTwoDate[1];
			$bothTime = array($startDate, $endDate);
		}
		
		
		if($report=='problemlist'){
			$this->Note->bindModel(array('belongsTo' => array(
					'Patient' => array('foreignKey'=>'patient_id'),
					'NoteDiagnosis'=>array('foreignKey'=>false,'conditions'=>array('NoteDiagnosis.patient_id=Patient.id')),
					'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id'=>'Patient.person_id'))
			)));
			$problemlistNumeratorVal = $this->Note->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => '0',
					 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,'NoteDiagnosis.is_deleted'=>'0'
					 		 /*'OR' => array('Note.icd <>' => "", array('NOT' => array('Note.icd_record' => NULL))),
					 		 'Note.patient_id NOT' => array('', 0)*/),'group'=>array('Patient.patient_id')));//edited by--Pooja(NO need of the commented condition as we are not using them)
			
			$this->set('numeratorVal',$problemlistNumeratorVal);
							
		}
		elseif($report=='medicationlist'){
			
			$mlpatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')),
					'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id'=>'Patient.person_id')))));
			
			$medicationlistNumeratorVal = $this->NewCropPrescription->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'),
					 'conditions' => array('Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
					 		'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type, 
					 		'NewCropPrescription.patient_uniqueid' => $mlpatientlist, 
					 		'NewCropPrescription.uncheck' => array(0,1)),'group'=>array('Patient.patient_id')));
			$this->set('numeratorVal',$medicationlistNumeratorVal);
				
		}
		elseif($report=='medicationAllergy'){
			
			$mapatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$this->NewCropAllergies->bindModel(array('belongsTo' => array(
					'Patient' => array('foreignKey'=>false, 'conditions' => array('Patient.id=NewCropAllergies.patient_uniqueid')),
					'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id'=>'Patient.person_id')))));
			
			$medicationAllergyNumeratorVal = $this->NewCropAllergies->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
							'Patient.doctor_id' => $searchProvider, 'NewCropAllergies.patient_uniqueid' => $mapatientlist, 
							'Patient.admission_type' => $patient_type, 'NewCropAllergies.allergycheck' => array(0,1)),
							'NewCropAllergies.status'=>'A','group'=>array('Patient.patient_id')));
			$this->set('numeratorVal',$medicationAllergyNumeratorVal);
							
		}
		elseif($report=='cpoeMedication'){
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$cpoempatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			
			$this->NewCropPrescription->bindModel(array('belongsTo' => array(
					'Patient' => array('foreignKey'=>false,'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')),
					'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id'=>'Patient.person_id')))));
			
			$cpoeMedicationNumeratorVal = $this->NewCropPrescription->find('all', array(
					'fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'),
					 'conditions' => array('NewCropPrescription.patient_uniqueid' =>$cpoempatientlist, 
					 		'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,  
					 		'Patient.doctor_id' => $searchProvider, 'NewCropPrescription.archive' => "N", 
					 		'Patient.admission_type' => $patient_type)));
			$this->set('numeratorVal',$cpoeMedicationNumeratorVal);
				
		}
		elseif($report=='cpoeLab'){
			$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoelpatientlist = $this->LaboratoryTestOrder->find('list', array('fields' => array('Patient.id', 'Patient.id'), 
					'conditions' => array('DATE_FORMAT(LaboratoryTestOrder.lab_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'LaboratoryTestOrder.is_deleted' => 0, 
							'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type), 
					'recursive' => 1));
			$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
					'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id'=>'Patient.person_id')))));
			$cpoeLabNumeratorVal = $this->LaboratoryTestOrder->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('LaboratoryTestOrder.patient_id' =>$cpoelpatientlist, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
							'Patient.doctor_id' => $searchProvider, 'LaboratoryTestOrder.order_id <>' => "", 
							'Patient.admission_type' => $patient_type)));
			$this->set('numeratorVal',$cpoeLabNumeratorVal);
				
		}
		elseif($report=='cpoeRad'){
			$this->RadiologyTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoerpatientlist = $this->RadiologyTestOrder->find('list', array('fields' => array('Patient.id', 'Patient.id'), 
					'conditions' => array('DATE_FORMAT(RadiologyTestOrder.radiology_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type), 'recursive' => 1));
			$this->RadiologyTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
					'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id'=>'Patient.person_id')))));
			$cpoeRadNumeratorVal = $this->RadiologyTestOrder->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('RadiologyTestOrder.patient_id' =>$cpoerpatientlist, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
							'Patient.doctor_id' => $searchProvider, 'RadiologyTestOrder.order_id <>' => "", 
							'Patient.admission_type' => $patient_type)));
			$this->set('numeratorVal',$cpoeRadNumeratorVal);
		}
		elseif($report=='erxstage2'){
			$this->NewCropPrescription->bindModel(array('belongsTo' => array(
					'Patient' => array('foreignKey'=>false, 'conditions' => array('Patient.patient_id=NewCropPrescription.patient_id')),
					'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id'=>'Patient.person_id')))));
			$erxstage2NumeratorCVal = $this->NewCropPrescription->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
							'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->NewCropPrescription->bindModel(array('belongsTo' => array(
					'Patient' => array('foreignKey'=>false, 'conditions' => array('Patient.patient_id=NewCropPrescription.patient_id')),
					'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id'=>'Patient.person_id')))));
			$erxstage2NumeratorNVal = $this->NewCropPrescription->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
							'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$erxstage2NumeratorVal=array_merge($erxstage2NumeratorCVal,$erxstage2NumeratorNVal);
			$this->set('numeratorVal',$erxstage2NumeratorVal);
				
		}
		elseif($report=='erxstage1'){
			$this->NewCropPrescription->bindModel(array('belongsTo' => array(
					'Patient' => array('foreignKey'=>false, 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')),
					'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id'=>'Patient.person_id')))));
			$erxstage1NumeratorVal = $this->NewCropPrescription->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'),
					 'conditions' => array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
					 		'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
					 		'Patient.admission_type' => $patient_type)));
			$this->set('numeratorVal',$erxstage1NumeratorVal);
		}
		elseif($report=='demographic'){
			$this->Patient->unbindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));
			$withinPatientList =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
							'Patient.admission_type' => $patient_type)));
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$demographicNumeratorVal = $this->Patient->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('Patient.id' =>$withinPatientList, 'Patient.location_id'=>$this->Session->read('locationid'), 
							'Patient.is_deleted' => 0, 'Person.ethnicity <>' => "", 'Person.race <>' => "", 'Person.language <>' => "", 
							'Patient.doctor_id' => $searchProvider,'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->set('numeratorVal',$demographicNumeratorVal);
		}
		elseif($report=='vitalsign'){
			
		/*	$doctorPreference = $this->DoctorProfile->find('first', array('fields' => array('DoctorProfile.height_weight','DoctorProfile.bp'), 
					'conditions' => array( 'DoctorProfile.user_id' => $searchProvider, 'DoctorProfile.location_id'=>$this->Session->read('locationid'), 
							'DoctorProfile.is_deleted' => 0,)));
			if($doctorPreference['DoctorProfile']['bp'] == 1 && $doctorPreference['DoctorProfile']['height_weight'] == 0){
				$condition['DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >'] = '3';
			} else {
				$condition['DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >='] = '0';
			}
			
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$patientlist = $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'), 
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.admission_type' => $patient_type, 'Patient.doctor_id' => $searchProvider,$condition), 
							'recursive' => 1));
				
			if($doctorPreference['DoctorProfile']['bp'] == 1 && $doctorPreference['DoctorProfile']['height_weight'] == 0){
				$conditions['Note']['bp !='] = array('', 0.00);
			} else {
				$conditions['Note']['ht NOT'] = array('', 0.00);
				$conditions['Note']['bp NOT'] = array('', 0.00);
				$conditions['Note']['wt NOT'] = array('', 0.00);
			}
			$conditions = $this->postConditions($conditions);
			$this->Note->bindModel(array('belongsTo' => array(
					'Patient' => array('foreignKey'=>'patient_id'),
					'Person' =>array('foreignKey' => false
							,'conditions'=>array('Person.id=Patient.person_id' )),
			)));
				
			$vitalsignNumeratorVal = $this->Note->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Patient.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('Note.patient_id' => $patientlist, 'Patient.location_id'=>$this->Session->read('locationid'), 
							'Patient.is_deleted' => 0,'Patient.admission_type' => $patient_type, 'Patient.doctor_id' => $searchProvider,
							$conditions,$condition),'group'=>array('Patient.patient_id')));*/
			
			$condition['DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >='] = '0';
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$patientlist = $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.admission_type' => $patient_type, 'Patient.doctor_id' => $searchProvider,$condition),
					'recursive' => 1));
				
			/*if($doctorPreference['DoctorProfile']['bp'] == 1 && $doctorPreference['DoctorProfile']['height_weight'] == 0){
			 $conditions['BmiBpResult']['systolic !='] = NULL;
			$conditions['BmiBpResult']['diastolic !='] = NULL;
			} else {*/
			$conditions['BmiResult']['height_result NOT'] = NULL;
			$conditions['BmiResult']['weight_result NOT'] = NULL;
			$conditions['BmiBpResult']['systolic !='] = NULL;
			$conditions['BmiBpResult']['diastolic !='] = NULL;
			//}
			$conditions = $this->postConditions($conditions);
			$this->BmiResult->bindModel(array('belongsTo' => array(
					'Patient' => array('foreignKey'=>'patient_id'),
					'Person' =>array('foreignKey' => false
							,'conditions'=>array('Person.id=Patient.person_id' )),
					'BmiBpResult'=>array('foreignKey' => false,'conditions'=>array('BmiBpResult.bmi_result_id=BmiResult.id'))
			)));
			$vitalsignNumeratorVal = $this->BmiResult->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 'conditions' => array('BmiResult.patient_id' => $patientlist, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.admission_type' => $patient_type, 'Patient.doctor_id' => $searchProvider,$conditions,$condition),'group'=>array('Patient.patient_id')));// 'OR' => array(array('Note.icd <>' => "",'Note.icd_record' => 0), array('Note.icd' => "",'Note.icd_record' => 1)), 'Note.patient_id NOT' => array('', 0))));
			$this->set('numeratorVal',$vitalsignNumeratorVal);
		}
		elseif($report=='smokingstatus'){
			$this->Patient->unbindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));
			$withinPatientList =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'), 
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
							'Patient.admission_type' => $patient_type)));
			$this->PatientSmoking->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
					'Person' => array('foreignKey'=>false, 'conditions' => array('Person.id=Patient.person_id'))
			)));
			$smokingstatusNumeratorVal = $this->PatientSmoking->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'),
					 'conditions' => array('Patient.id' =>$withinPatientList, 'Patient.location_id'=>$this->Session->read('locationid'), 
					 		'Patient.is_deleted' => 0,'PatientSmoking.patient_id NOT' => array('', 0) , 
					 		'PatientSmoking.current_smoking_fre <>' => "", 'Patient.doctor_id' => $searchProvider,
					 		'Patient.admission_type' => $patient_type,
					 		/*'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >' => 13*/
					 		'DATEDIFF(CURDATE(),Person.dob)/365 >'=>'13'),
							'group'=>array('Patient.patient_id')));
			$this->set('numeratorVal',$smokingstatusNumeratorVal);
				
		}
		elseif($report=='labresults'){
			$this->LaboratoryResult->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
					'Person' => array('foreignKey'=>false, 'conditions' => array('Person.id=Patient.person_id')))));
			$labresultsNumeratorVal = $this->LaboratoryResult->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(LaboratoryResult.result_publish_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
							 'Patient.admission_type' => $patient_type, 'LaboratoryResult.laboratory_test_order_id <>' => ""),'group'=>array('Patient.patient_id')));
			$this->set('numeratorVal',$labresultsNumeratorVal);
		}
		elseif($report=='patientreminder'){
			$this->Outbox->bindModel(array('belongsTo' => array('User' => array('foreignKey'=>false, 
					'conditions' => array('User.username=Outbox.from')))));
			$patientreminderNumeratorVal = $this->Outbox->find('all', array('fields' => array('COUNT(Outbox.to) as count'), 
					'conditions' => array('DATE_FORMAT(Outbox.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'User.id' => $searchProvider, 'Outbox.is_patient' => 1, 'Outbox.subject' => 'Reminder')));
			$this->set('numeratorVal',$patientreminderNumeratorVal);
				
		}
		elseif($report=='viewdownload'){
				/*$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			
			$viewdownloadNumeratorVal =  $this->Patient->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Patient.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
					 		'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
					 		'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
					 		 'Person.is_first_login' => 1),'group'=>array('Patient.patient_id')));*/
			
			$ccdaViewNumeratorVal=$this->XmlNote->find('all',array('fields'=>array('XmlNote.patient_id'),
					'conditions'=>array('DATE_FORMAT(XmlNote.created, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'XmlNote.is_viewed=1')
			));
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			foreach($ccdaViewNumeratorVal as $data){
				$viewList[]=$this->Patient->find('all',array('fields'=>array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'),'conditions'=>array('Patient.id'=>$data['XmlNote']['patient_id'])));
			}
			
			$ccdaDownloadNumeratorVal=$this->XmlNote->find('all',array('fields'=>array('XmlNote.patient_id'),
					'conditions'=>array('DATE_FORMAT(XmlNote.created, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'XmlNote.is_viewed=1','XmlNote.is_downloaded=1')
			));
			
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			foreach($ccdaDownloadNumeratorVal as $data){
				$downloadList[]=$this->Patient->find('all',array('fields'=>array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
						'Person.person_email_address','Person.person_local_number'),'conditions'=>array('Patient.id'=>$data['XmlNote']['patient_id'])));
			}
			
			
			$this->TransmittedCcda->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$ccdaTransmittedNumeratorVal = $this->TransmittedCcda->find('all', array('fields' => array('Patient.id'),
					'conditions' => array('DATE_FORMAT(TransmittedCcda.referral_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'TransmittedCcda.location_id' => $this->Session->read('locationid'), 'Patient.doctor_id' => $searchProvider,
							'Patient.admission_type' => $patient_type)));
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
			foreach($ccdaTransmittedNumeratorVal as $data){
				$transmitList[]=$this->Patient->find('all',array('fields'=>array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
						'Person.person_email_address','Person.person_local_number'),'conditions'=>array('Patient.id'=>$data['Patient']['id'])));
			}
			//debug($transmitList);
			$viewdownloadNumeratorVal=array_merge($viewList,$downloadList);
			$viewdownloadNumeratorVal=array_merge($viewdownloadNumeratorVal,$transmitList);
			foreach($viewdownloadNumeratorVal as $data){
				$finalList[]=$data[0];
			}	
			$this->set('numeratorVal',$finalList);
				
		}
		elseif($report=='clinicalsummary'){
			$this->XmlNote->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
					'Person' => array('foreignKey'=>false, 'conditions' => array('Person.id=Patient.person_id')))));
			$clinicalsummaryNumeratorVal =  $this->XmlNote->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(XmlNote.clinical_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'),
							'DATE_FORMAT(XmlNote.clinical_date, "%Y-%m-%d") <= DATE_ADD(Patient.form_received_on,INTERVAL +2 DAY)',
							'XmlNote.option !='=>'None', 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
							'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->set('numeratorVal',$clinicalsummaryNumeratorVal);
				
		}
		elseif($report=='patienteducation'){
			$this->Patient->unbindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));
			$withinPatientList =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
							'Patient.admission_type' => $patient_type)));
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$patienteducationNumeratorVal =  $this->Patient->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'),
					 'conditions' => array('Patient.id' =>$withinPatientList, 'Patient.location_id'=>$this->Session->read('locationid'), 
					 		'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
					 		'Person.password <>' => ''),'group'=>array('Patient.patient_id')));
			$this->set('numeratorVal',$patienteducationNumeratorVal);
		}
		elseif($report=='medicationrecon'){
			$this->IncorporatedPatient->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
					'Person' => array('foreignKey'=>false, 'conditions' => array('Person.id=Patient.person_id')),
					'NewCropPrescription'=>array('foreignKey'=>false,'conditions'=>array('NewCropPrescription.patient_uniqueid=IncorporatedPatient.patient_id')))));
			 
			$medicationreconNumeratorVal = $this->IncorporatedPatient->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'),
					'conditions' => array('DATE_FORMAT(IncorporatedPatient.date_imported_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.doctor_id' => $searchProvider
							, 'Patient.admission_type' => $patient_type,'NewCropPrescription.date_of_prescription  BETWEEN ? AND ? ' =>$bothTime,'NewCropPrescription.is_reconcile'=>1,
							  'IncorporatedPatient.summary_provide'=>1),'group'=>array('Patient.patient_id')));
			$this->set('numeratorVal',$medicationreconNumeratorVal);
		}
		elseif($report=='summarycare'){
			$this->TransmittedCcda->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
					'Person' => array('foreignKey'=>false, 'conditions' => array('Person.id=Patient.person_id')))));
			$summarycareNumeratorVal = $this->TransmittedCcda->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(TransmittedCcda.referral_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'TransmittedCcda.location_id' => $this->Session->read('locationid'), 'Patient.doctor_id' => $searchProvider,
							 'TransmittedCcda.type' => array('other', 'ccda'), 'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->set('numeratorVal',$summarycareNumeratorVal);
		}
		elseif($report=='securemsg'){
			$this->Inbox->bindModel(array('belongsTo' => array('User' => array('foreignKey'=>false, 
					'conditions' => array('User.username=Inbox.to')))));
			$securemsgNumeratorVal = $this->Inbox->find('all', array('fields' => array('COUNT(DISTINCT Inbox.from) as count'), 
					'conditions' => array('DATE_FORMAT(Inbox.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'User.id' => $searchProvider,'User.location_id' => $this->Session->read('locationid'), 
							'Inbox.is_patient' => 0)));
			$this->set('numeratorVal',$securemsgNumeratorVal);
				
		}
		elseif($report=='imaging'){
			$this->RadiologyReport->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
					'Person' => array('foreignKey'=>false, 'conditions' => array('Person.id=Patient.person_id')))));
			$imagingNumeratorVal =  $this->RadiologyReport->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(RadiologyReport.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
							'RadiologyReport.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
							'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->set('numeratorVal',$imagingNumeratorVal);
		}
		elseif($report=='familyhistory'){
			$this->FamilyHistory->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
					'Person' => array('foreignKey'=>false, 'conditions' => array('Person.id=Patient.person_id')))));
			$familyhistoryNumeratorVal =  $this->FamilyHistory->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->set('numeratorVal',familyhistory);
		}
		elseif($report=='enotes'){
			$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
					'Person' => array('foreignKey'=>false, 'conditions' => array('Person.id=Patient.person_id')))));
			$enotesNumeratorVal =  $this->Note->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'),
					 'conditions' => array('DATE_FORMAT(Note.note_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
					 		'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
					 		'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->set('numeratorVal',$enotesNumeratorVal);
		}
		elseif($report=='advdirective'){
			$this->AdvanceDirective->bindModel(array('belongsTo' => array(
					'Patient' => array('foreignKey'=>false, 'conditions' => array('AdvanceDirective.patient_id=Patient.admission_id')),
					'Person' => array('foreignKey'=>false, 'conditions' => array('Person.id=Patient.person_id')))));
			$advdirectiveNumeratorVal =  $this->AdvanceDirective->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(AdvanceDirective.patient_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
			$this->set('numeratorVal',$advdirectiveNumeratorVal);
		}
		elseif($report=='labehtoea'){
			$this->Outbox->bindModel(array('belongsTo' => array('User' => array('foreignKey'=>false, 'conditions' => array('User.username=Outbox.to')))));
			$labehtoeaNumeratorVal = $this->Outbox->find('all', array('fields' => array('COUNT(Outbox.from) as count'),
					 'conditions' => array('DATE_FORMAT(Outbox.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'User.id' => $searchProvider,'User.location_id' => $this->Session->read('locationid'), 
					 		'Outbox.subject' => 'Lab Report'),'group'=>array('Patient.patient_id')));
			$this->set('numeratorVal',$labehtoeaNumeratorVal);
		}
		elseif($report=='emar'){
			$this->PrescriptionRecord->bindModel(array('belongsTo' => array(
					'Patient' => array('foreignKey'=>false, 'conditions' => array('Patient.patient_id=PrescriptionRecord.patient_uid')),
					'Person' => array('foreignKey'=>false, 'conditions' => array('Person.id=Patient.person_id')))));
			$emarNumeratorVal =  $this->PrescriptionRecord->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob','Patient.city',
					'Person.person_email_address','Person.person_local_number'), 
					'conditions' => array('DATE_FORMAT(PrescriptionRecord.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
							 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							 'Patient.doctor_id' => $searchProvider,'Patient.admission_type' => $patient_type, 
							 'PrescriptionRecord.medication <>' => ""),'group'=>array('Patient.patient_id')));
			$this->set('numeratorVal',$emarNumeratorVal);
		}
		$this->set('date',$bothTime);
		$providerName=$this->DoctorProfile->find('first',array('fields'=>array('doctor_name'),'conditions'=>array('DoctorProfile.user_id'=>$searchProvider)));
		$this->set('provider',$providerName);
		
	}
	

	
/*
 * 
 *   pcmh automated measure calculation
 *    
 */
     public function admin_pcmh_automated_measure() {
		$this->uses = array('DoctorProfile', 'Patient','PatientPersonalHistory','PastMedicalHistory','Diagnosis', 'PatientSmoking','Note','NewCropPrescription', 
				'NewCropAllergies','PrescriptionRecord','LaboratoryTestOrder','LaboratoryResult','Inbox',
				'Outbox','RadiologyTestOrder','RadiologyReport','FamilyHistory','AdvanceDirective', 'Note', 'Inbox',
				 'PatientReferral', 'TransmittedCcda', 'XmlNote', 'LaboratoryManualEntry', 'RadiologyManualEntry', 'IncorporatedPatient', 
				'BmiResult', 'Person','LaboratoryHl7Result','PatientDocument','Guardian','Appointment','NoteDiagnosis');
		$this->set('title_for_layout', __('Measure Calculation', true));
				
		if($this->request->is('post')) { 
			$this->set('search','search');
			if($this->request->data['provider'] !=''){
				$searchProvider = $this->request->data['provider'];
				$this->set('provider',$searchProvider);
			}
			if($this->request->data['stage_type'] !=''){
				$stage_type = $this->request->data['stage_type'];
				$this->set('stage_type',$stage_type);
			}
			
				$patient_type = 'OPD';
			
			if($this->request->data['startdate'] !="" && $this->request->data['duration'] !="") {
				$expStartDate = explode("/", $this->request->data['startdate']);
				$startDate = $expStartDate[2]."-".$expStartDate[0]."-".$expStartDate[1];
				$addDays = $this->request->data['duration'];
				$endDate = date("Y-m-d", strtotime("+$addDays days", strtotime($startDate)));
				$bothTime = array($startDate, $endDate);
				$this->set('startDate',$startDate);
				$this->set('duration',$addDays);
								
			}
			if($this->request->data['year'] !="" && $this->request->data['duration'] !="") {
				$expTwoDate = explode("_", $this->request->data['duration']);
				$startDate = $this->request->data['year']."-".$expTwoDate[0];
				$endDate = $this->request->data['year']."-".$expTwoDate[1];
				$bothTime = array($startDate, $endDate);
								
			} 
			$this->set('startDate',$startDate);
			$this->set('endDate',$endDate);
			$this->set('patient_type',$patient_type);
			
			$this->Patient->unbindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));
						
			//Patient specific education report.-Aditya
			$specificeducationDemo =$this->NewCropPrescription->find('all', array('fields' => array('COUNT(*) as count'),
					'conditions' => array('DATE_FORMAT(NewCropPrescription.created, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'NewCropPrescription.archive' =>'N',
							'NewCropPrescription.created_by' => $searchProvider)));
			$specificeducationNum =$this->NewCropPrescription->find('all', array('fields' => array('COUNT(*) as count'),
					'conditions' => array('DATE_FORMAT(NewCropPrescription.created, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'NewCropPrescription.archive' =>'N',
							'NewCropPrescription.created_by' => $searchProvider,'patient_info !='=>'')));
		$this->set('specificeducationDemo',$specificeducationDemo);
		$this->set('specificeducationNum',$specificeducationNum);
		// sugar report- Aditya
		//$this->Patient->unbindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));
		$this->NoteDiagnosis->bindModel(array('belongsTo' => array(
				'Patient' => array('foreignKey'=> false,'conditions' => array('NoteDiagnosis.patient_id=Patient.id')))));
		$demoninatorSugar=$this->NoteDiagnosis->find('all',array('fields'=>('Patient.patient_id'),'conditions'=>array('Patient.age >'=> 45,'diagnoses_name LIKE'=>'%diabetes%'),
				'gruop'=>array('Patient.patient_id')));
		foreach($demoninatorSugar1 as $allPatientId){
			$patientId[]=$allPatientId['Patient']['patient_id'];
		}
		$numaratorSugar=$this->Inbox->find('all',array('fields'=>array('to'),'conditions'=>array('message'=>'sugar Test','from'=>$patientId)));
		/* foreach($demoninatorSugar as $demoninatorSugar){
			$uid[]=$demoninatorSugar['Inbox']['to'];
		} */
		/* $allPatientId=$this->Patient->find('all',array('fields'=>array('id'),'conditions'=>array('patient_id'=>$uid)));
		foreach($allPatientId as $allPatientId){
			$patientId[]=$allPatientId['Patient']['id'];
		} */
		/* $numaratorSugar=$this->LaboratoryTestOrder->find('count',array('conditions'=>array('patient_id'=>$patientId,'laboratory_id'=>'49988')));  */
		$this->set('demoSuagr',count($demoninatorSugar));
		$this->set('numaSuagr',count($numaratorSugar));
			// Electronic Access //
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))), false);
			$accessVisitDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(Distinct Patient.patient_id) as count'), 
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							 'Patient.doctor_id' => $searchProvider,'Patient.admission_type' => $patient_type)));
			
			/*$accessVisitNumeratorVal =  $this->Patient->find('all', array('fields' => array('COUNT(*) as count'),
					 'conditions' => array('DATE_FORMAT(Person.patient_credentials_created_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Person.location_id'=>$this->Session->read('locationid'), 'Person.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
					 		'Patient.admission_type' => $patient_type, 'Person.is_first_login' => 1,
					 		 '( TO_DAYS( Person.first_login_date ) - TO_DAYS( Person.patient_credentials_created_date ))<=4')));//for calculating days difference <=4 */
			
			$accessVisitNumeratorVal=$this->Patient->find('all', array('fields' => array('COUNT(Distinct Patient.patient_id) as count'), 
					'conditions' => array('DATE_FORMAT(Person.patient_credentials_created_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							 'Patient.doctor_id' => $searchProvider,'Patient.admission_type' => $patient_type)));
			// clinical summary calculation // 
			/*$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$clinicalsummaryDenominatorVal = $this->Note->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type, )));*/
			
			$clinicalsummaryDenominatorVal = $this->Patient->find('all', array('fields' => array('COUNT(Distinct Patient.patient_id) as count'), 
					'conditions' => array('DATE_FORMAT(Person.patient_credentials_created_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							 'Patient.doctor_id' => $searchProvider,'Patient.admission_type' => $patient_type)));
			
			/*$this->XmlNote->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$clinicalsummaryNumeratorVal =  $this->XmlNote->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(XmlNote.clinical_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'),
					 		//For condition of 1 business day difference between registration and clinical summary generation
					 		'(TO_DAYS(XmlNote.clinical_date ) - TO_DAYS( Patient.form_received_on))>=0 AND (TO_DAYS(XmlNote.clinical_date ) - TO_DAYS( Patient.form_received_on))<=1 ', 
					 		 'XmlNote.option !='=>'None', 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
					 		'Patient.admission_type' => $patient_type)));*/
			
			$clinicalsummaryNumeratorVal = $this->Patient->find('all', array('fields' => array('COUNT(Distinct Patient.patient_id) as count'), 
					'conditions' => array('DATE_FORMAT(Person.patient_credentials_created_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							 'Patient.doctor_id' => $searchProvider,'Patient.admission_type' => $patient_type)));
			
			// problem list calculation //
			$problemlistDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(Distinct Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			
			$this->NoteDiagnosis->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			
			$problemlistNumeratorVal1 = $this->NoteDiagnosis->find('all', array('fields' => array('COUNT(Distinct Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(NoteDiagnosis.start_dt, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
					 		'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type ,
					 		 'NoteDiagnosis.patient_id NOT' => array('', 0))));
			$this->PastMedicalHistory->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			
			$problemlistNumeratorVal2 = $this->PastMedicalHistory->find('all', array('fields' => array('COUNT(Distinct Patient.patient_id) as count'),
					'conditions' => array('DATE_FORMAT(PastMedicalHistory.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type ,
							'PastMedicalHistory.patient_id NOT' => array('', 0),'PastMedicalHistory.no_known_problems=1')));
			 $problemlistNumeratorVal=$problemlistNumeratorVal1[0][0]['count']+$problemlistNumeratorVal2[0][0]['count'];
			
			// medication allergy calculation //
			$medicationAllergyDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(Distinct Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			
			$mapatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
					 'conditions' => array(/*'DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,*/
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$this->NewCropAllergies->bindModel(array('belongsTo' => array(
					'Patient' => array('foreignKey'=>false,
							'conditions' => array('Patient.id=NewCropAllergies.patient_uniqueid')))));
			
			$medicationAllergyNumeratorVal1 = $this->NewCropAllergies->find('all', array('fields' => array('COUNT(Distinct Patient.patient_id) as count'),
					 'conditions' => array( 'NewCropAllergies.patient_uniqueid' => $mapatientlist,
					 		'DATE_FORMAT(NewCropAllergies.created, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		'NewCropAllergies.allergycheck' => array(0,1),
					 		'NewCropAllergies.status'=>'A')));
			$this->Patient->bindModel(array('belongsTo'=>array(
					'Diagnosis'=>array('foreignKey'=>false,'conditions'=>array('Patient.id=Diagnosis.patient_id')),
					'Note'=>array('foreignKey'=>false,'conditions'=>array('Patient.id=Note.patient_id'))					
					)));
			$medicationAllergyNumeratorVal2=$this->Patient->find('all',array('fields'=>array('COUNT(Distinct Patient.patient_id) as count'),
					'conditions'=>array('Patient.id'=>$mapatientlist,'OR'=>array('DATE_FORMAT(Diagnosis.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'DATE_FORMAT(Diagnosis.modify_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime),'OR'=>array('Diagnosis.no_allergy_flag '=>array('yes'),
							'Note.no_allergy_flag'=>array('yes')))));
			$medicationAllergyNumeratorVal=$medicationAllergyNumeratorVal1[0][0]['count']+$medicationAllergyNumeratorVal2[0][0]['count'];
			
			// blood pressure calculation //
			$bloodPressureDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(Distinct Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
					 		 'DATEDIFF( CURDATE( ) , Person.dob ) /365 >'=>'3')));//counts also if the age is greater than 3 years by 1 day ie:3yrs1day;
					 		 /*'TIMESTAMPDIFF(YEAR,Person.dob,CURDATE()) >' => '3'*/
			
			$this->BmiResult->bindModel(array('belongsTo' => array('BmiBpResult' => array('foreignKey'=> false, 'conditions' => array('BmiBpResult.bmi_result_id=BmiResult.id')),
			                                                       'Patient' => array('foreignKey'=> false, 'conditions' => array('BmiResult.patient_id=Patient.id')),
																   'Person' => array('foreignKey'=>false,'conditions'=>array('Patient.person_id=Person.id')),
																	)));
			$bloodPressureNumeratorVal = $this->BmiResult->find('all', array('fields' => array('COUNT(Distinct Patient.patient_id) as count'),
					 'conditions' => array('Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
					 		 /*'TIMESTAMPDIFF(YEAR,Person.dob,CURDATE()) >' => '3'*/'DATEDIFF( CURDATE( ) , Person.dob ) /365 >'=>'3',
					 		 'OR' => array('NOT' => array('BmiBpResult.systolic' => "", 'BmiBpResult.diastolic' => "")))));
			
			// height/length calculation //
			$heightDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(Distinct Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$this->BmiResult->bindModel(array('belongsTo' => array('BmiBpResult' => array('foreignKey'=> false, 
					'conditions' => array('BmiBpResult.bmi_result_id=BmiResult.id')),
			         'Patient' => array('foreignKey'=> false, 'conditions' => array('BmiResult.patient_id=Patient.id')))));
			
			$heightNumeratorVal = $this->BmiResult->find('all', array('fields' => array('COUNT(DISTINCT BmiResult.patient_id) as count'),
					 'conditions' => array('Patient.location_id'=>$this->Session->read('locationid'),
					 		 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
					 		 'BmiResult.height <>' => "")));
			
			// weight calculation //
			$weightDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(Distinct Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
					 		'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$this->BmiResult->bindModel(array('belongsTo' => array('BmiBpResult' => array('foreignKey'=> false,
					 'conditions' => array('BmiBpResult.bmi_result_id=BmiResult.id')),
			                        'Patient' => array('foreignKey'=> false,
			                        'conditions' => array('BmiResult.patient_id=Patient.id')))));
			
			$weightNumeratorVal = $this->BmiResult->find('all', array('fields' => array('COUNT(Distinct BmiResult.patient_id) as count'),
					 'conditions' => array('Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
					 		'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type, 'BmiResult.weight <>' => "")));
			
			// smoking status calculation //
			$smokingstatusDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(Distinct Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
					 		'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type, 
					 		/*'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >' => '13'*/
					 		'DATEDIFF(CURDATE(),Person.dob)/365 >'=>'13')));
			$this->Diagnosis->bindModel(array('belongsTo' => array(
					'Patient' => array('foreignKey'=>'patient_id'),
					'Person' => array('foreignKey'=>false, 'conditions' => array('Person.id=Patient.person_id')),
			        'PatientPersonalHistory'=>array('foreignKey'=>false,'conditions'=>array('PatientPersonalHistory.diagnosis_id=Diagnosis.id')))));
			
			$smokingstatusNumeratorVal = $this->Diagnosis->find('all', array('fields' => array('COUNT(Distinct Patient.patient_id) as count'),
					 'conditions' => array('Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		'PatientPersonalHistory.diagnosis_id NOT' => array('', 0) , 'PatientPersonalHistory.smoking' =>array('0','1'), 'PatientPersonalHistory.tobacco' =>array('0','1'), 
					 		'Patient.doctor_id' => $searchProvider,'Patient.admission_type' => $patient_type,
					 		 /*'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >' => '13'*/
					 		'DATEDIFF(CURDATE(),Person.dob)/365 >'=>'13')));
			
			// medication list calculation //
			$medicationlistDenominatorVal =  $this->Patient->find('all', array(
					'fields' => array('COUNT( DISTINCT Patient.patient_id) as count'), 
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			 $mlpatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
					 'conditions' => array(/*'DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,*/
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
					 		'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type))); 
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$medicationlistNumeratorVal = $this->NewCropPrescription->find('all', array('fields' => array('COUNT(Distinct Patient.patient_id) as count'),
					 'conditions' => array('Patient.location_id'=>$this->Session->read('locationid'),
					 		 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
					 		/*'DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime*/ 
					 		'Patient.admission_type' => $patient_type,'NewCropPrescription.patient_uniqueid' => $mlpatientlist,
					 		'OR'=>array('DATE_FORMAT(NewCropPrescription.modified, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 				'DATE_FORMAT(NewCropPrescription.created, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,'DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime),
					 		 'NewCropPrescription.uncheck' => array(0,1))));
			//debug($medicationlistNumeratorVal);
			
			// family history calculation //
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$familyhistoryDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(Distinct Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$this->FamilyHistory->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			
			$familyhistoryNumeratorVal =  $this->FamilyHistory->find('all', array('fields' => array('COUNT(FamilyHistory.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(FamilyHistory.created, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
					 		'OR'=>array('FamilyHistory.is_positive_family=1','FamilyHistory.is_positive_family=0'/*,'FamilyHistory.is_positive_family'=>NULL*/))));
			/*************Pooja************************/
			// e-notes calculation //
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$enotesDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT( Patient.id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			
			$enotesNumeratorVal =  $this->Note->find('all', array('fields' => array('COUNT(Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(Note.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 
					 		'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
					 		 'Patient.admission_type' => $patient_type)));
			
			//lab orders calculation
			$this->LaboratoryResult->bindModel(array('belongsTo' => array(
					'Patient' => array('foreignKey'=>false,'conditions'=>array('Patient.id=LaboratoryResult.patient_id')),
					'LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryHl7Result.laboratory_result_id')))));
			
			$cpoeLabDenominatorMVal = $this->LaboratoryResult->find('all', array('fields' => array('COUNT(Distinct Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(LaboratoryHl7Result.date_time_of_observation, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'LaboratoryHl7Result.location_id'=>$this->Session->read('locationid'),
					 		'LaboratoryHl7Result.is_electronically_recorded=0', 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type),
							));//------------Pooja	
			$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoelpatientlist = $this->LaboratoryTestOrder->find('list', array('fields' => array('Patient.id', 'Patient.id'),
					 'conditions' => array('DATE_FORMAT(LaboratoryTestOrder.lab_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'LaboratoryTestOrder.is_deleted' => 0,
					 		 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
					 		'Patient.admission_type' => $patient_type), 'recursive' => 1));
			$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoeLabNumeratorVal = $this->LaboratoryTestOrder->find('all', array(
					'fields' => array('COUNT(Distinct Patient.patient_id) as count'),
					 'conditions' => array('LaboratoryTestOrder.patient_id' =>$cpoelpatientlist,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 
					 		'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
					 		'LaboratoryTestOrder.order_id <>' => "", 'Patient.admission_type' => $patient_type)));
			$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoeLabDenominatorCVal = $this->LaboratoryTestOrder->find('all', array(
					'fields' => array('COUNT(Distinct Patient.patient_id) as count'),
					 'conditions' => array('LaboratoryTestOrder.patient_id' =>$cpoelpatientlist,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.doctor_id' => $searchProvider, 'LaboratoryTestOrder.order_id NOT' =>NULL, 
					 		'Patient.admission_type' => $patient_type)));
			$cpoeLabDenominatorVal = $cpoeLabDenominatorMVal[0][0]['count'] + $cpoeLabDenominatorCVal[0][0]['count'];
			
			//Radiology Calculation
			$this->RadiologyManualEntry->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoeRadDenominatorMVal = $this->RadiologyManualEntry->find('all', array('fields' => array('SUM(RadiologyManualEntry.rad_count) as count'), 'conditions' => array('DATE_FORMAT(RadiologyManualEntry.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$this->RadiologyTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoerpatientlist = $this->RadiologyTestOrder->find('list', array('fields' => array('Patient.id', 'Patient.id'), 'conditions' => array('DATE_FORMAT(RadiologyTestOrder.radiology_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type), 'recursive' => 1));
			$this->RadiologyTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoeRadNumeratorVal = $this->RadiologyTestOrder->find('all', array('fields' => array('COUNT(Distinct Patient.patient_id) as count'), 'conditions' => array('RadiologyTestOrder.patient_id' =>$cpoerpatientlist, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'RadiologyTestOrder.order_id <>' => "", 'Patient.admission_type' => $patient_type)));
			$this->RadiologyTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$cpoeRadDenominatorCVal = $this->RadiologyTestOrder->find('all', array(
					'fields' => array('COUNT(Distinct Patient.patient_id) as count'), 
					'conditions' => array('RadiologyTestOrder.patient_id' =>$cpoerpatientlist,
							 'Patient.location_id'=>$this->Session->read('locationid'), 
							 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
							 'RadiologyTestOrder.order_id <>' => "", 'Patient.admission_type' => $patient_type)));
			$cpoeRadDenominatorVal = $cpoeRadDenominatorCVal[0][0]['count'] + $cpoeRadDenominatorMVal[0][0]['count'];
 
			//Imaging Calculation
			$this->RadiologyTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
			$imagingDenominatorVal2 =  $this->RadiologyTestOrder->find('all', array('fields' => array('COUNT(Distinct Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(RadiologyTestOrder.start_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$imagingDenominatorVal = $imagingDenominatorVal2[0][0]['count'];
			$this->RadiologyReport->bindModel(array('belongsTo' => array(
					'Patient' => array('foreignKey'=>'patient_id'),
					'RadiologyResult'=>array('foreignKey'=>false,'conditions'=>array('RadiologyReport.radiology_result_id=RadiologyResult.id')),
					'RadiologyTestOrder'=>array('foreignKey'=>false,'conditions'=>array('RadiologyTestOrder.id=RadiologyResult.radiology_test_order_id')))));
			$imagingNumeratorVal =  $this->RadiologyReport->find('all', array('fields' => array('COUNT(Distinct Patient.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(RadiologyReport.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'RadiologyReport.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
					 		'Patient.admission_type' => $patient_type)));
			/*$imagingNumeratorVal =  $this->PatientDocument->find('all', array(
					'fields' => array('COUNT(PatientDocument.patient_id) as count'),
					 'conditions' => array('DATE_FORMAT(PatientDocument.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'PatientDocument.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
					 		 'Patient.admission_type' => $patient_type,'PatientDocument.document_id IN("1","13")')));//document id 1 and 13 for lab and radiology--- Pooja
				*/
			//Reconciles medication calculations			
			$this->IncorporatedPatient->bindModel(array('belongsTo' =>
					array('Patient' => array('foreignKey'=>'patient_id'),
							'NewCropPrescription'=>array('foreignKey'=>false,'conditions'=>array('NewCropPrescription.patient_uniqueid=IncorporatedPatient.patient_id')))));
			 
			$medicationreconDenominatorVal = $this->IncorporatedPatient->find('all', array('fields' => array('COUNT(DISTINCT Patient.id) as count'),
					'conditions' => array('DATE_FORMAT(IncorporatedPatient.date_imported_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.doctor_id' => $searchProvider,  'Patient.admission_type' => $patient_type)));
			 
			$this->IncorporatedPatient->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
					'NewCropPrescription'=>array('foreignKey'=>false,
							'conditions'=>array('NewCropPrescription.patient_uniqueid=IncorporatedPatient.patient_id')))));
			 
			$medicationreconNumeratorVal = $this->IncorporatedPatient->find('all', array('fields' => array('COUNT(DISTINCT Patient.id) as count'),
					'conditions' => array('DATE_FORMAT(IncorporatedPatient.date_imported_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.doctor_id' => $searchProvider
							, 'Patient.admission_type' => $patient_type,'NewCropPrescription.date_of_prescription  BETWEEN ? AND ? ' =>$bothTime,'NewCropPrescription.is_reconcile'=>1,'IncorporatedPatient.summary_provide'=>1)));
			
			
			
			//Medication Management //
			$medicationDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT( Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$mapatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
					 'conditions' => array(/*'DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,*/'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false, 
					'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			
			//had difficulty
			$medicationDifficultyNumeratorVal = $this->NewCropPrescription->find('all', array('fields' => array('COUNT(DISTINCT Patient.id) as count'), 
					'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
							'DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type,
							 'NewCropPrescription.had_difficulty' => 1)));
			
			//is a herbal therapy
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$medicationIsherbalNumeratorVal = $this->NewCropPrescription->find('all', array('fields' => array('COUNT(DISTINCT Patient.id) as count'),
					 'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
					 		'DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type,
					 		 "OR"=>array('NewCropPrescription.is_a_herbal_therapy' => 1,'NewCropPrescription.DeaLegendDescription' => 'OTC'))));
			
			//is a supplement
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$medicationIssupplementNumeratorVal = $this->NewCropPrescription->find('all', array('fields' => array('COUNT(DISTINCT Patient.id) as count'),
					 'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
					 		 'NewCropPrescription.patient_uniqueid' => $mapatientlist,
					 		'DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.admission_type' => $patient_type,
					 		 "OR"=>array('NewCropPrescription.is_a_supplement' => 1,'NewCropPrescription.DeaLegendDescription' => 'OTC'))));
			
			//had side effect
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$medicationHassideeffectNumeratorVal = $this->NewCropPrescription->find('all', array(
					'fields' => array('COUNT(DISTINCT Patient.patient_id) as count'), 
					'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
							 'NewCropPrescription.patient_uniqueid' => $mapatientlist,
							'DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.admission_type' => $patient_type, 
							'NewCropPrescription.side_effects' => 1)));
			
			//Reported interaction on taking medication
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$medicationReportedInteractionNumeratorVal = $this->NewCropPrescription->find('all', array('fields' => array('COUNT(DISTINCT Patient.id) as count'),
					 'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
					 		'DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type, 
					 		'NewCropPrescription.taking_medication' => 1)));
			
			//Patient is taking medication a prescribed
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$medicationMedicationPrescribedNumeratorVal = $this->NewCropPrescription->find('all', array(
					'fields' => array('COUNT(DISTINCT Patient.id) as count'), 
					'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
							'DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type, 
							'NewCropPrescription.took_medication' => 1)));
			
			//Medication Information is Explained to the Patient considering their Health Literacy and Date Stamps
			//(The Count is only of the Patient to whom medication is given or no active medication checkbox is checked )
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))),false);
			$medicationExplainedHealthDenominatorVal1 = $this->NewCropPrescription->find('all', array(
					'fields' => array('COUNT(Patient.id) as count'),
					'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
							'DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type,
					)));
			$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					'conditions' => array('Patient.id=Note.patient_id')))),false);
			$medicationExplainedHealthDenominatorVal2 = $this->Note->find('all', array(
					'fields' => array('COUNT(Patient.id) as count'),
					'conditions' => array(
							'DATE_FORMAT(Note.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Note.patient_id' => $mapatientlist,'Note.no_med_flag'=>array('no','yes'))));
			$medicationExplainedHealthDenominatorVal=$medicationExplainedHealthDenominatorVal1[0][0]['count']+$medicationExplainedHealthDenominatorVal2[0][0]['count'];
			$this->set(array('medicationExplainedHealthDenominatorVal'=>$medicationExplainedHealthDenominatorVal));
			
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$medicationExplainedHealthNumeratorVal1 = $this->NewCropPrescription->find('all', array(
					'fields' => array('COUNT(Patient.id) as count'),
					 'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
					 		'DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type,
					 		 'OR'=>array('NewCropPrescription.health_literacy' => 1,'NewCropPrescription.PrintLeaflet' => 'T'))));
			$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					'conditions' => array('Patient.id=Note.patient_id')))),false);
			$medicationExplainedHealthNumeratorVal2 = $this->Note->find('all', array(
					'fields' => array('COUNT(Patient.id) as count'),
					'DATE_FORMAT(Note.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					'conditions' => array('Note.patient_id' => $mapatientlist,'Note.no_med_flag'=>array('yes'))));
			$medicationExplainedHealthNumeratorVal=$medicationExplainedHealthNumeratorVal1[0][0]['count']+$medicationExplainedHealthNumeratorVal2[0][0]['count'];
			$this->set(array('medicationExplainedHealthNumeratorVal'=>$medicationExplainedHealthNumeratorVal));
			//EMR Logs when New Medication information is printed and given to Patient/Familieis/CareGiver.
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
			$medicationPrintedNumeratorVal = $this->NewCropPrescription->find('all', array(
					'fields' => array('COUNT(DISTINCT Patient.id) as count'),
					 'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
					 		 'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type,
					 		 'NewCropPrescription.PrintLeaflet' => 'T')));
			
			//Clinic Generates Report that >50% of Eligible Prescriptions are sent Electronically
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))),false);
			$medicationEligibleSentDenominatorVal1 = $this->NewCropPrescription->find('all', array(
					'fields' => array('COUNT(Patient.id) as count'),
					'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
							'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type,
							)));
			$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
					 'conditions' => array('Patient.id=Note.patient_id')))),false);
			$medicationEligibleSentDenominatorVal2 = $this->Note->find('all', array(
					'fields' => array('COUNT(Patient.id) as count'),
					'conditions' => array('Note.patient_id' => $mapatientlist,'Note.no_med_flag'=>array('no','yes'))));
			$medicationEligibleSentDenominatorVal=$medicationEligibleSentDenominatorVal1[0][0]['count']+$medicationEligibleSentDenominatorVal2[0][0]['count'];
			$this->set(array('medicationEligibleSentDenominatorVal'=>$medicationEligibleSentDenominatorVal));
			
			$medicationEligibleSentNumeratorVal = $this->NewCropPrescription->find('all', array(
					'fields' => array('COUNT(DISTINCT Patient.id) as count'), 
					'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
							'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type,
							 'NewCropPrescription.FinalDestinationType' =>array('3','4'))));
			
			//Clinic has Assessed Interactions of Medications against OTC Medications, Supplemements, and Herbal Therapies is done for >50% Patients Annually
			$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false, 
					'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))),false);
			$medicationOtcAssesedInteractionDenominatorVal = $this->NewCropPrescription->find('all', array(
					'fields' => array('COUNT(Patient.id) as count'),
					'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
							'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type,
							'NewCropPrescription.DeaLegendDescription' => 'OTC')));
			$this->set(array('medicationOtcAssesedInteractionDenominatorVal'=>$medicationOtcAssesedInteractionDenominatorVal[0][0]['count']));
			$medicationOtcAssesedInteractionNumeratorVal = $this->NewCropPrescription->find('all', array(
					'fields' => array('COUNT(DISTINCT Patient.id) as count'), 
					'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
							'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type, 
							'NewCropPrescription.taking_medication' => 1,'NewCropPrescription.DeaLegendDescription' => 'OTC')));
			
			//CCDA //
			//Transitions of Care that are Documented in EMRs with Electronic Discharge Summaries from Hospitals and Other Facilities
			$electronicManualVal =  $this->PatientReferral->find('all', array(
					'fields' => array('COUNT(*) as count'),
					 'conditions' => array('DATE_FORMAT(PatientReferral.date_of_issue, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'PatientReferral.location_id'=>$this->Session->read('locationid'), 
					 		 'PatientReferral.created_by' => $searchProvider)));
			$electronicVal =  $this->TransmittedCcda->find('all', array('fields' => array('COUNT(*) as count'),
					 'conditions' => array('DATE_FORMAT(TransmittedCcda.referral_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'TransmittedCcda.location_id'=>$this->Session->read('locationid'),
					 		 'TransmittedCcda.created_by' => $searchProvider)));
			$electronicDenominatorVal=$electronicManualVal[0][0]['count']+$electronicVal[0][0]['count'];
			
			//Patient Hospitalizations during which Clinic Exchanged Patient Information with Hospital
			$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false, 'conditions' => array('Patient.id=Note.patient_id')))));
			$patientIdArray =  $this->Note->find('all', array('fields' => array('Note.id'), 
					'conditions' => array('DATE_FORMAT(Note.note_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'),'Note.sb_registrar' => $searchProvider,
							'Note.refer_to_hospital'=>'1')));
			foreach($patientIdArray as $ids){
				$patientArray[$ids['Note']['id']]=$ids['Note']['id'];
			}
			$patientInfoDenominatorVal=count($patientIdArray);
			$patientInfoNumeratorVal= $this->TransmittedCcda->find('all',array('fields'=>array('COUNT(*) as count'),'conditions' => array('DATE_FORMAT(TransmittedCcda.referral_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'TransmittedCcda.location_id'=>$this->Session->read('locationid'), 'TransmittedCcda.created_by' => $searchProvider,'TransmittedCcda.patient_id '=>$patientArray)));
			
			//End Of CCDA
			
			//searchable structured data-- Pooja			
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
			$searchableDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT(Patient.id) as count'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
					 		'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
			
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'),
															'Guardian'=>array('foreignKey'=>false,'conditions'=>array('Guardian.person_id=Person.id')),
														    'AdvanceDirective'=>array('foreignKey'=>'patient_id'))));
				
			$searchableNumeratorVal =  $this->Patient->find('all', array('fields' => array('COUNT(Patient.id) as count'),
					 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
					 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
					 		'OR'=>array('Person.dob NOT'=>NULL,'Person.sex NOT'=>NULL,'Person.race NOT'=>NULL,'Person.ethnicity NOT'=>NULL,
					 				'Person.person_local_number NOT'=>NULL,'Person.person_local_number_second NOT'=>NULL,
					 				'Person.person_email_address NOT'=>NULL,'Person.occupation NOT'=>NULL,'Guardian.guar_first_name NOT'=>NULL,
					 				'Patient.doctor_id NOT'=>NULL,'AdvanceDirective.patient_name NOT'=>NULL))));
			//EOf searchable
			//Summary of care Report--- Pooja
			$ManualVal =  $this->PatientReferral->find('all', array('fields' => array('COUNT(*) as count'), 'conditions' => array('DATE_FORMAT(PatientReferral.date_of_issue, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'PatientReferral.location_id'=>$this->Session->read('locationid'), 'PatientReferral.created_by' => $searchProvider)));
			$electronicVal =  $this->TransmittedCcda->find('all', array('fields' => array('COUNT(*) as count'), 'conditions' => array('DATE_FORMAT(TransmittedCcda.referral_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'TransmittedCcda.location_id'=>$this->Session->read('locationid'),'TransmittedCcda.referral_to'=>'Specialist','TransmittedCcda.created_by' => $searchProvider)));
			$summaryDenominatorVal=$ManualVal[0][0]['count']+$electronicVal[0][0]['count'];
			//EOf Summary of care Report
			
			//Abnormal Lab result report --- Pooja
			$this->LaboratoryTestOrder->bindModel(array(
					'belongsTo' => array(
							'LaboratoryResult' =>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.laboratory_test_order_id=LaboratoryTestOrder.id')),
							'LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryHl7Result.laboratory_result_id=LaboratoryResult.id')),
					)),false);
			$labDenominatorVal = $this->LaboratoryTestOrder->find('all',array('fields'=>array('COUNT(LaboratoryTestOrder.id) as count'),
					'conditions'=>array('DATE_FORMAT(LaboratoryTestOrder.lab_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'LaboratoryTestOrder.location_id'=>$this->Session->read('locationid'),
							'LaboratoryTestOrder.is_deleted=0','LaboratoryTestOrder.created_by'=>$searchProvider)));
			$labNumeratorVal = $this->LaboratoryTestOrder->find('all',array('fields'=>array('COUNT(LaboratoryTestOrder.id) as count'),
					'conditions'=>array('DATE_FORMAT(LaboratoryTestOrder.lab_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'LaboratoryTestOrder.location_id'=>$this->Session->read('locationid'),
							'LaboratoryTestOrder.is_deleted=0','LaboratoryTestOrder.created_by'=>$searchProvider,'LaboratoryHl7Result.abnormal_flag'=>'A')));
				
			//End Of Abnormal Lab result report
			//overdue Lab result report --- Pooja
			$this->LaboratoryTestOrder->bindModel(array(
					'belongsTo' => array(
							'LaboratoryResult' =>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.laboratory_test_order_id=LaboratoryTestOrder.id')),
							'LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryHl7Result.laboratory_result_id=LaboratoryResult.id')),
					)),false);
			$overduelabDenominatorVal = $this->LaboratoryTestOrder->find('all',array('fields'=>array('COUNT(LaboratoryTestOrder.id) as count'),
					'conditions'=>array('DATE_FORMAT(LaboratoryTestOrder.lab_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'LaboratoryTestOrder.location_id'=>$this->Session->read('locationid'),
							'LaboratoryTestOrder.is_deleted=0','LaboratoryTestOrder.created_by'=>$searchProvider)));
			$overduelabNumeratorVal = $this->LaboratoryTestOrder->find('all',array('fields'=>array('COUNT(LaboratoryTestOrder.id) as count'),
					'conditions'=>array('DATE_FORMAT(LaboratoryTestOrder.lab_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'LaboratoryTestOrder.location_id'=>$this->Session->read('locationid'),
							'LaboratoryTestOrder.is_deleted=0','LaboratoryTestOrder.created_by'=>$searchProvider,'LaboratoryHl7Result.abnormal_flag'=>'A','DATE_FORMAT(LaboratoryTestOrder.lab_order_date, "%Y-%m-%d")<DATE_FORMAT(LaboratoryHl7Result.date_time_of_observation, "%Y-%m-%d")')));
			//Eof  overdue Lab result report
			
			//overdue Rad result report --- Pooja
			$this->RadiologyTestOrder->bindModel(array(
					'belongsTo' => array(
							'RadiologyResult' =>array('foreignKey'=>false,'conditions'=>array('RadiologyResult.radiology_test_order_id=RadiologyTestOrder.id')),
					)),false);
			$overdueRadDenominatorVal = $this->RadiologyTestOrder->find('all',array('fields'=>array('COUNT(RadiologyTestOrder.id) as count'),
					'conditions'=>array('DATE_FORMAT(RadiologyTestOrder.radiology_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'RadiologyTestOrder.location_id'=>$this->Session->read('locationid'),'RadiologyTestOrder.is_deleted=0',
							'RadiologyTestOrder.created_by'=>$searchProvider)));
			$overdueRadNumeratoVal = $this->RadiologyTestOrder->find('all',array('fields'=>array('COUNT(RadiologyTestOrder.id) as count'),
					'conditions'=>array('DATE_FORMAT(RadiologyTestOrder.radiology_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'RadiologyTestOrder.location_id'=>$this->Session->read('locationid'),'RadiologyTestOrder.is_deleted=0',
							'RadiologyTestOrder.created_by'=>$searchProvider,'DATE_FORMAT(RadiologyTestOrder.radiology_order_date, "%Y-%m-%d")<DATE_FORMAT(RadiologyResult.result_publish_date, "%Y-%m-%d")')));
			//Eof  overdue Rad result report
			
			//searchable by dob,sex, race etc....----------Pooja
			$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
			$searchableDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT( Patient.id) as count'),
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
				
			$searchableDobNumeratorVal =  $this->Patient->find('all', array('fields' => array('COUNT(Patient.id) as count'),
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
							'Person.dob NOT'=>NULL)));
			$searchableSexNumeratorVal =  $this->Patient->find('all', array('fields' => array('COUNT( Patient.id) as count'),
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
							'Person.sex NOT'=>NULL)));
			$searchableRaceNumeratorVal =  $this->Patient->find('all', array('fields' => array('COUNT( Patient.id) as count'),
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
							'Person.race NOT'=>NULL)));
			$searchableEthnicityNumeratorVal =  $this->Patient->find('all', array('fields' => array('COUNT( Patient.id) as count'),
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
							'Person.ethnicity NOT'=>NULL)));
			$searchableTelePrimaryNumeratorVal =  $this->Patient->find('all', array('fields' => array('COUNT( Patient.id) as count'),
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
							'Person.person_local_number NOT'=>NULL)));
			$searchableAlterTeleNumeratorVal =  $this->Patient->find('all', array('fields' => array('COUNT( Patient.id) as count'),
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
							'Person.person_local_number_second NOT'=>NULL)));
			$searchableEmailNumeratorVal =  $this->Patient->find('all', array('fields' => array('COUNT( Patient.id) as count'),
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
							'Person.person_email_address NOT'=>NULL)));
			$searchablePreferredLanguageNumeratorVal =  $this->Patient->find('all', array('fields' => array('COUNT( Patient.id) as count'),
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
							'Person.preferred_language NOT'=>NULL)));
			$searchableOccupationNumeratorVal =  $this->Patient->find('all', array('fields' => array('COUNT( Patient.id) as count'),
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
							'Person.occupation NOT'=>NULL)));
			$searchablePrimaryCareGiverNumeratorVal =  $this->Patient->find('all', array('fields' => array('COUNT( Patient.id) as count'),
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
							'Patient.relation'=>'CGV')));
			$searchableAdvanceDirectiveNumeratorVal =  $this->Patient->find('all', array('fields' => array('COUNT( Patient.id) as count'),
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
							'Person.adv_directive NOT'=>NULL)));
			$searchableInsuranceInfoNumeratorVal =  $this->Patient->find('all', array('fields' => array('COUNT( Patient.id) as count'),
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
							'Person.insurance_company_id NOT'=>NULL)));
			$searchablePhysicianNumeratorVal =  $this->Patient->find('all', array('fields' => array('COUNT( Patient.id) as count'),
					'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
							'Patient.doctor_id NOT'=>NULL)));
			
			//No-Show and Arrivals report---------Pooja
			
			$noShowDenominatorVal=$this->Appointment->find('all',array('fields'=>array('COUNT(Appointment.id) as count'),
					'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
							'Appointment.doctor_id' => $searchProvider,
							)));
		    $noShowNumeratorVal=$this->Appointment->find('all',array('fields'=>array('COUNT(Appointment.id) as count'),
					'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
							'Appointment.doctor_id' => $searchProvider,'Appointment.status'=>'No-Show'
							)));
		    $arrivalsNumeratorVal=$this->Appointment->find('all',array('fields'=>array('COUNT(Appointment.id) as count'),
		    		'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
		    				'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
		    				'Appointment.doctor_id' => $searchProvider,'Appointment.status NOT'=>array('Scheduled','Pending','No-Show','Cancelled')
		    		)));
		    //View, download and transmit report -  Rate report-------------Pooja
		    
		    $ccdaViewNumeratorVal=$this->XmlNote->find('all',array('fields'=>array('COUNT(XmlNote.id) as count'),
		    		'conditions'=>array('DATE_FORMAT(XmlNote.created, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
		    				'XmlNote.is_viewed=1')
		    		));
		    $ccdaDownloadNumeratorVal=$this->XmlNote->find('all',array('fields'=>array('COUNT(XmlNote.id) as count'),
		    		'conditions'=>array('DATE_FORMAT(XmlNote.created, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
		    				'XmlNote.is_viewed=1','XmlNote.is_downloaded=1')
		   			 ));
		    
		    $this->TransmittedCcda->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
		    $ccdaTransmittedNumeratorVal = $this->TransmittedCcda->find('all', array('fields' => array('COUNT(Patient.id) as count'),
		    		 'conditions' => array('DATE_FORMAT(TransmittedCcda.referral_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
		    		 		 'TransmittedCcda.location_id' => $this->Session->read('locationid'), 'Patient.doctor_id' => $searchProvider,
		    		 		 'Patient.admission_type' => $patient_type)));
		    $ccdaNumerator= $ccdaViewNumeratorVal[0][0]['count']+$ccdaDownloadNumeratorVal[0][0]['count']+$ccdaTransmittedNumeratorVal[0][0]['count'];
		    
		    $ccdaArrivalsdenominatorVal=$this->Appointment->find('all',array('fields'=>array('COUNT(Appointment.id) as count'),
		    		'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
		    				'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
		    				'Appointment.doctor_id' => $searchProvider,'Appointment.status NOT'=>array('Scheduled','Pending','No-Show','Cancelled')
		    		)));
		    
		    
		    $this->set('ispost', $this->request->is('post'));
			$this->set('stage_type', $stage_type);
			
			$this->set(array('startdate' => $this->request->data['startdate'], 'provider' => $this->request->data['provider'], 'duration' => $this->request->data['duration'], 'stage_type' => $stage_type, 'patient_type' => $patient_type, 'year' => $this->request->data['year'])); 
			$this->set(array('accessVisitDenominatorVal' => $accessVisitDenominatorVal[0][0]['count'], 'accessVisitNumeratorVal' => $accessVisitNumeratorVal[0][0]['count']));
			$this->set(array('clinicalsummaryDenominatorVal' => $clinicalsummaryDenominatorVal[0][0]['count'], 'clinicalsummaryNumeratorVal' => $clinicalsummaryNumeratorVal[0][0]['count']));
			$this->set(array('problemlistDenominatorVal' => $problemlistDenominatorVal[0][0]['count'], 'problemlistNumeratorVal' => $problemlistNumeratorVal));
			$this->set(array('medicationAllergyDenominatorVal' => $medicationAllergyDenominatorVal[0][0]['count'], 'medicationAllergyNumeratorVal' => $medicationAllergyNumeratorVal));
			$this->set(array('bloodPressureDenominatorVal' => $bloodPressureDenominatorVal[0][0]['count'], 'bloodPressureNumeratorVal' => $bloodPressureNumeratorVal[0][0]['count']));
			$this->set(array('heightDenominatorVal' => $heightDenominatorVal[0][0]['count'], 'heightNumeratorVal' => $heightNumeratorVal[0][0]['count']));
			$this->set(array('searchableNumeratorVal' => $searchableNumeratorVal[0][0]['count'], 'searchableDenominatorVal' => $searchableDenominatorVal[0][0]['count']));
			$this->set(array('enotesDenominatorVal' => $enotesDenominatorVal[0][0]['count'], 'enotesNumeratorVal' => $enotesNumeratorVal[0][0]['count']));
			$this->set(array('weightDenominatorVal' => $weightDenominatorVal[0][0]['count'], 'weightNumeratorVal' => $weightNumeratorVal[0][0]['count']));
			$this->set(array('smokingstatusDenominatorVal' => $smokingstatusDenominatorVal[0][0]['count'], 'smokingstatusNumeratorVal' => $smokingstatusNumeratorVal[0][0]['count']));
			$this->set(array('medicationlistDenominatorVal' => $medicationlistDenominatorVal[0][0]['count'], 'medicationlistNumeratorVal' => $medicationlistNumeratorVal[0][0]['count']));
			$this->set(array('familyhistoryDenominatorVal' => $familyhistoryDenominatorVal[0][0]['count'], 'familyhistoryNumeratorVal' => $familyhistoryNumeratorVal[0][0]['count']));
			$this->set(array('familyhistoryDenominatorVal' => $familyhistoryDenominatorVal[0][0]['count'], 'familyhistoryNumeratorVal' => $familyhistoryNumeratorVal[0][0]['count']));
			$this->set(array('familyhistoryDenominatorVal' => $familyhistoryDenominatorVal[0][0]['count'], 'familyhistoryNumeratorVal' => $familyhistoryNumeratorVal[0][0]['count']));
			$this->set(array('cpoeLabDenominatorVal'=>$cpoeLabDenominatorVal,'labresultsNumeratorVal'=>$cpoeLabNumeratorVal[0][0]['count']));
			$this->set(array('cpoeRadDenominatorVal'=>$cpoeRadDenominatorVal,'cpoeRadNumeratorVal'=>$cpoeRadNumeratorVal[0][0]['count']));
			$this->set(array('imagingDenominatorVal'=>$imagingDenominatorVal,'imagingNumeratorVal'=>$imagingNumeratorVal[0][0]['count']));
			$this->set(array('medicationreconDenominatorVal'=>$medicationreconDenominatorVal[0][0]['count'],'medicationreconNumeratorVal'=>$medicationreconNumeratorVal[0][0]['count']));
			$this->set(array('medicationDenominatorVal'=>$medicationDenominatorVal[0][0]['count'],'medicationDifficultyNumeratorVal'=>$medicationDifficultyNumeratorVal[0][0]['count']));
			$this->set(array('medicationDenominatorVal'=>$medicationDenominatorVal[0][0]['count'],'medicationIsherbalNumeratorVal'=>$medicationIsherbalNumeratorVal[0][0]['count']));
			$this->set(array('medicationDenominatorVal'=>$medicationDenominatorVal[0][0]['count'],'medicationIssupplementNumeratorVal'=>$medicationIssupplementNumeratorVal[0][0]['count']));
			$this->set(array('medicationDenominatorVal'=>$medicationDenominatorVal[0][0]['count'],'medicationHassideeffectNumeratorVal'=>$medicationHassideeffectNumeratorVal[0][0]['count']));
			$this->set(array('medicationDenominatorVal'=>$medicationDenominatorVal[0][0]['count'],'medicationReportedInteractionNumeratorVal'=>$medicationReportedInteractionNumeratorVal[0][0]['count']));
			$this->set(array('medicationDenominatorVal'=>$medicationDenominatorVal[0][0]['count'],'medicationMedicationPrescribedNumeratorVal'=>$medicationMedicationPrescribedNumeratorVal[0][0]['count']));
			$this->set(array('medicationDenominatorVal'=>$medicationDenominatorVal[0][0]['count']));
			$this->set(array('medicationDenominatorVal'=>$medicationDenominatorVal[0][0]['count'],'medicationPrintedNumeratorVal'=>$medicationPrintedNumeratorVal[0][0]['count'],'medicationEligibleSentNumeratorVal'=>$medicationEligibleSentNumeratorVal[0][0]['count']));
			$this->set(array('electronicDenominatorVal'=>$electronicDenominatorVal,'electronicNumeratorVal'=>$electronicVal[0][0]['count']));
			$this->set(array('patientInfoDenominatorVal'=>$patientInfoDenominatorVal,'patientInfoNumeratorVal'=>$patientInfoNumeratorVal[0][0]['count']));
			$this->set(array('summaryDenominatorVal'=>$summaryDenominatorVal,'summaryNumeratorVal'=>$electronicVal[0][0]['count']));
			$this->set(array('labDenominatorVal'=>$labDenominatorVal[0][0]['count'],'labNumeratorVal'=>$labNumeratorVal[0][0]['count']));
			$this->set(array('overdueDenominatorVal'=>$overduelabDenominatorVal[0][0]['count'],'overdueNumeratorVal'=>$overduelabNumeratorVal[0][0]['count']));
			$this->set(array('overdueRadDenominatorVal'=>$overdueRadDenominatorVal[0][0]['count'],'overdueRadNumeratorVal'=>$overdueRadNumeratoVal[0][0]['count']));
			$this->set(array('searchableDobNumeratorVal'=>$searchableDobNumeratorVal[0][0]['count'],'searchableRaceNumeratorVal'=>$searchableRaceNumeratorVal[0][0]['count'],
					'searchableSexNumeratorVal'=>$searchableSexNumeratorVal[0][0]['count'],'searchableEthnicityNumeratorVal'=>$searchableEthnicityNumeratorVal[0][0]['count'],
					'searchableTelePrimaryNumeratorVal'=>$searchableTelePrimaryNumeratorVal[0][0]['count'],'searchableEmailNumeratorVal'=>$searchableEmailNumeratorVal[0][0]['count'],
					'searchableAlterTeleNumeratorVal'=>$searchableAlterTeleNumeratorVal[0][0]['count'],'searchablePreferredLanguageNumeratorVal'=>$searchablePreferredLanguageNumeratorVal[0][0]['count'],
					'searchableOccupationNumeratorVal'=>$searchableOccupationNumeratorVal[0][0]['count'],'searchableInsuranceInfoNumeratorVal'=>$searchableInsuranceInfoNumeratorVal[0][0]['count'],
					'searchablePrimaryCareGiverNumeratorVal'=>$searchablePrimaryCareGiverNumeratorVal[0][0]['count'],'searchableAdvanceDirectiveNumeratorVal'=>$searchableAdvanceDirectiveNumeratorVal[0][0]['count'],
					'medicationOtcAssesedInteractionNumeratorVal'=>$medicationOtcAssesedInteractionNumeratorVal[0][0]['count'],
					'searchablePhysicianNumeratorVal'=>$searchablePhysicianNumeratorVal[0][0]['count']));
		}
		$this->set(array('ccdaNumerator'=>$ccdaNumerator,'ccdaArrivalsdenominatorVal'=>$ccdaArrivalsdenominatorVal[0][0]['count']));
		$this->set(array('noShowDenominatorVal'=>$noShowDenominatorVal[0][0]['count'],'noShowNumeratorVal'=>$noShowNumeratorVal[0][0]['count'],'arrivalsNumeratorVal'=>$arrivalsNumeratorVal[0][0]['count']));
			
		$this->set('doctorlist', $this->DoctorProfile->getDoctors());
		
		if($this->request->data['report_type']=='excel'){
			$this->layout = false ;
			$this->render('pcmh_automated_measure_excel') ;
		}
		
	}
	
	//Patients Communications with Physician
	public function patient_communication($type=NULL){
		$this->uses=array('Inbox','Patient');
		if($this->params->query){
			if(!empty($this->params->query['dateFrom'])){
				$dateFrom=date('Y-m-d',strtotime($this->params->query['dateFrom']));
				$dateFrom=$dateFrom/*.' 00:00:00'*/;
			}
			else{
				$dateFrom=date('Y-m-d');
				$dateFrom=$dateFrom/*.' 00:00:00'*/;
			}
			if(!empty($this->params->query['dateTo'])){
				$dateTo=date('Y-m-d ',strtotime($this->params->query['dateTo']));
				$dateTo=$dateTo/*.' 23:59:59'*/;
				
			}else{
				$dateTo=date('Y-m-d');
				$dateTo=$dateTo/*.' 23:59:59'*/;
			}
			$bothTime = array($dateFrom, $dateTo);
			$patientList=$this->Patient->find('all',array('fields'=>array('Patient.lookup_name','Patient.form_received_on'),
					'conditions'=>array('Patient.mode_communication NOT'=>NULL,
							'DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Patient.location_id'=>$this->Session->read('locationid'))));
			$physicianList=$this->Inbox->find('all',array('fields'=>array('Inbox.created_by','Inbox.from_name','Inbox.create_time'),
					'conditions'=>array('Inbox.is_patient'=>'0',
							'DATE_FORMAT(Inbox.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime )));
			foreach($patientList as $list){
				$finalList[$list['Patient']['form_received_on']]=$list['Patient']['lookup_name'];
			}	
			
			foreach($physicianList as $final){
				$finalList[$final['Inbox']['create_time']]=$final['Inbox']['from_name'];
			}
		}
		ksort($finalList);
		$this->set('patientList',$finalList);
		if($type=='excel'){
			$this->layout=false;
			$this->render('patient_communication_excel');
		}
	}
	
	
	//checklist 2
	public function admin_pcmh_report(){
		$this->uses=array('PcmhServices');
		if($this->request->data){
			$this->request->data['PcmhServices']['user_id']=$this->Session->read('userid');
			$this->request->data['PcmhServices']['location_id']=$this->Session->read('locationid');
			if($this->request->data['PcmhServices']['id'] != ''){
				$this->request->data['PcmhServices']['modified_time']=date("Y-m-d H:i:s");
				$this->request->data['PcmhServices']['service_report']=serialize($this->request->data['PcmhServices']['options']);
				$this->PcmhServices->save($this->request->data['PcmhServices']);
			}else{
				$this->request->data['PcmhServices']['created_time']=date("Y-m-d H:i:s");
				$this->request->data['PcmhServices']['service_report']=serialize($this->request->data['PcmhServices']['options']);
				$this->PcmhServices->save($this->request->data['PcmhServices']);
			}
		}
		$result = $this->PcmhServices->find('first',array('conditions'=>array('user_id'=>$this->Session->read('userid'))));
		$result['PcmhServices']['options']=unserialize($result['PcmhServices']['service_report']);
		$this->set('result',$result);
	}
	
	
	
	public function appointment_log($type=NULL){
		$this->uses=array('Appointment','Patient');
		if($this->params->query){
			if(!empty($this->params->query['dateFrom'])){
				$dateFrom=date('Y-d-m',strtotime($this->params->query['dateFrom']));
				
			}
			else{
				$dateFrom=date('Y-m-d');
				
			}
			if(!empty($this->params->query['dateTo'])){
				$dateTo=date('Y-d-m ',strtotime($this->params->query['dateTo']));
				
			}else{
				$dateTo=date('Y-m-d');
				
			}
			$bothTime = array($dateFrom, $dateTo);
			$this->Appointment->bindmodel(array('belongsTo'=>array(
					'Patient'=>array('foreignKey'=>false,'conditions'=>array('Appointment.patient_id = Patient.id')))));
			$patientList=$this->Appointment->find('all',array('fields'=>array('Patient.lookup_name','Appointment.status','Appointment.date'),
					'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Appointment.location_id'=>$this->Session->read('locationid'),'Appointment.is_deleted'=>'0','Appointment.status'=>'No-Show')));
			
		ksort($patientList);
		$this->set('patientList',$patientList);
		if($type=='excel'){
			$this->layout=false;
			$this->render('no_show_report_excel');
		}
		
	}
	}
	
	public function appointment_arrived_report($type=null){
		$this->uses=array('Appointment','Patient','User');
		$doctors = $this->User->getAllDoctors();
		$this->set('doctors',$doctors);
		if($this->params->query['pie']){
			$this->Appointment->bindmodel(array('belongsTo'=>array(
					'Patient'=>array('foreignKey'=>false,'conditions'=>array('Appointment.patient_id = Patient.id')))),false);
			if(!empty($this->params->query['startDate']) && !empty($this->params->query['endDate'])){
				$bothTime=array($this->params->query['startDate'],$this->params->query['endDate']);
				foreach($doctors as $key=>$value){
					$patientCount=$this->Appointment->find('all',array('fields'=>array('COUNT(Appointment.id) as count'),
							'conditions'=>array('DATE_FORMAT(Appointment.date,"%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
									'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
									'Appointment.doctor_id' =>$key,'Appointment.status NOT'=>array('Scheduled','Pending','No-Show','Cancelled')
							)));
					$pieDataArrived[$key]['name']=$value;
					$pieDataArrived[$key]['count']=$patientCount[0][0]['count'];
					$doctorArrived[$key]=$key;
			
				}
			
				foreach($doctors as $key=>$value){
					$patientCount=$this->Appointment->find('all',array('fields'=>array('COUNT(Appointment.id) as count'),
							'conditions'=>array('DATE_FORMAT(Appointment.date,"%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
									'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
									'Appointment.doctor_id' =>$key,'Appointment.status NOT'=>NULL
							)));
					$pieDataScheduled[$key]['name']=$value;
					$pieDataScheduled[$key]['count']=$patientCount[0][0]['count'];
					$doctorScheduled[$key]=$key;
			
				}
				//debug($pieDataScheduled);
				$this->set('pieDataScheduled',$pieDataScheduled);
				$this->set('pieDataArrived',$pieDataArrived);
				$this->set('startDate',$this->params->query['startDate']);
				$this->set('endDate',$this->params->query['endDate']);
				
			}
		}else{
		if($this->params->query['dateFrom']){
			if(!empty($this->params->query['dateFrom'])){
				$dateFrom=date('Y-m-d',strtotime($this->params->query['dateFrom']));
				$dateFrom=$dateFrom/*.' 00:00:00'*/;
			}
			else{
				$dateFrom=date('Y-m-d');
				$dateFrom=$dateFrom/*.' 00:00:00'*/;
			}
			if(!empty($this->params->query['dateTo'])){
				$dateTo=date('Y-m-d ',strtotime($this->params->query['dateTo']));
				$dateTo=$dateTo/*.' 23:59:59'*/;
	
			}else{
				$dateTo=date('Y-m-d');
				$dateTo=$dateTo/*.' 23:59:59'*/;
			}
			$bothTime = array($dateFrom, $dateTo);
			$this->Appointment->bindmodel(array('belongsTo'=>array(
					'Patient'=>array('foreignKey'=>false,'conditions'=>array('Appointment.patient_id = Patient.id')))),false);		
			
			if(!empty($this->params->query['doctor'])){
				$this->paginate = array('limit' => Configure::read('number_of_rows'),
						'fields' => array('Patient.lookup_name','Appointment.status','Appointment.date'),
						'conditions' => array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
								'Appointment.doctor_id'=>$this->params->query['doctor'],'Appointment.status NOT'=>array('Scheduled','Pending','No-Show','Cancelled'))
				);
				$scheduleCount=$this->Appointment->find('all',array('fields'=>array('COUNT(Appointment.id) as count'),
						'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
								'Appointment.doctor_id'=>$this->params->query['doctor'],'Appointment.status NOT'=>NULL/*'Appointment.status NOT'=>array('No-Show','Cancelled')*/)))	;
					
				$arrivedCount=$this->Appointment->find('all',array('fields'=>array('COUNT(Appointment.id) as count'),
						'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
								'Appointment.doctor_id'=>$this->params->query['doctor'],'Appointment.status NOT'=>array('Scheduled','Pending','No-Show','Cancelled'))))	;
			}else{
			$this->paginate = array('limit' => Configure::read('number_of_rows'),
					'fields' => array('Patient.lookup_name','Appointment.status','Appointment.date'),
					'conditions' => array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
		    				'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
		    				'Appointment.status NOT'=>array('Scheduled','Pending','No-Show','Cancelled'))
					);
			$scheduleCount=$this->Appointment->find('all',array('fields'=>array('COUNT(Appointment.id) as count'),
					'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
		    				'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
		    				/*'Appointment.status '=>array('Scheduled','Pending')*/'Appointment.status NOT'=>NULL )))	;
			$arrivedCount=$this->Appointment->find('all',array('fields'=>array('COUNT(Appointment.id) as count'),
					'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
							'Appointment.status NOT'=>array('Scheduled','Pending','No-Show','Cancelled'))))	;
			}	
			
			$patientList=$this->paginate('Appointment');
			$this->set('scheduleCount',$scheduleCount);
			$this->set('arriveCount',$arrivedCount);
			$this->set('patientList',$patientList);
			$this->set('dateFrom',$dateFrom);
			$this->set('dateTo',$dateTo);
			$this->set('doctor',$this->params->query['doctor']);
			if($type=='excel'){
				$this->layout=false;
				if(!empty($this->params->query['doctor'])){
					$patientList = $this->Appointment->find('all',array(
							'fields' => array('Patient.lookup_name','Appointment.status','Appointment.date'),
							'conditions' => array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
									'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
									'Appointment.doctor_id'=>$this->params->query['doctor'],'Appointment.status NOT'=>array('Scheduled','Pending','No-Show','Cancelled'))
					));
				}else{
					$patientList = $this->Appointment->find('all',array(
							'fields' => array('Patient.lookup_name','Appointment.status','Appointment.date'),
							'conditions' => array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
									'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0
									,'Appointment.status NOT'=>array('Scheduled','Pending','No-Show','Cancelled'))
					));
				}
				$this->set('patientList',$patientList);
				$this->render('arrived_report_excel');
			}
	
		}
		}
	}
	
	//Patient wise physician list
	
	public function patient_wise_list($type=NULL){
		$this->uses=array('Appointment','Patient','User');
		if($this->params->query){
			if(!empty($this->params->query['dateFrom'])){
				$dateFrom=date('Y-m-d',strtotime($this->params->query['dateFrom']));
				$dateFrom=$dateFrom/*.' 00:00:00'*/;
			}
			else{
				$dateFrom=date('Y-m-d');
				$dateFrom=$dateFrom/*.' 00:00:00'*/;
			}
			if(!empty($this->params->query['dateTo'])){
				$dateTo=date('Y-m-d ',strtotime($this->params->query['dateTo']));
				$dateTo=$dateTo/*.' 23:59:59'*/;
	
			}else{
				$dateTo=date('Y-m-d');
				$dateTo=$dateTo/*.' 23:59:59'*/;
			}
			$bothTime = array($dateFrom, $dateTo);
			$this->Appointment->bindmodel(array('belongsTo'=>array(
					'Patient'=>array('foreignKey'=>false,'conditions'=>array('Appointment.patient_id = Patient.id')),
					'User'=>array('foreignKey'=>false,'conditions'=>array('Appointment.doctor_id = User.id')))));
			if($type=='excel'){
				$patientList=$this->Appointment->find('all',array(
					'fields'=> array('Patient.lookup_name','Appointment.status','Appointment.date','User.first_name','User.last_name'),
					'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Appointment.location_id'=>$this->Session->read('locationid'),'Appointment.is_deleted'=>'0'),
						'order' => array('Appointment.date' => 'ASC')));
				$this->set('patientList',$patientList);
				$this->set('date',$bothTime);
				$this->layout = false ;
				$this->render('patient_wise_list_excel') ;
			}else{			
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('Appointment.date' => 'ASC'),
					'fields'=> array('Patient.lookup_name','Appointment.status','Appointment.date','User.first_name','User.last_name'),
					'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'Appointment.location_id'=>$this->Session->read('locationid'),'Appointment.is_deleted'=>'0'));	
			}				
			$this->set('date',$bothTime);
			$this->set('patientList',$this->paginate('Appointment'));	
			
		 }
		
	}
	
	//Physician wise patient list --- Pooja
	
	public function physician_wise_list($type=NULL){
		$this->uses=array('Appointment','Patient','User');
		$doctors = $this->User->getAllDoctors();
		$this->set('doctors',$doctors);//debug($this->params->query);		
		if($type=='excel'){
			if($this->params->query){
				if(!empty($this->params->query['dateFrom'])){
					$dateFrom=date('Y-m-d',strtotime($this->params->query['dateFrom']));					
				}
				else{
					$dateFrom=date('Y-m-d');					
				}
				if(!empty($this->params->query['dateTo'])){
					$dateTo=date('Y-m-d ',strtotime($this->params->query['dateTo']));
					
			
				}else{
					$dateTo=date('Y-m-d');					
				}
				$bothTime = array($dateFrom, $dateTo);
				$this->set('date',$bothTime);
				if(!empty($this->params->query['doctor'])){
					$this->Appointment->bindmodel(array('belongsTo'=>array(
							'Patient'=>array('foreignKey'=>false,'conditions'=>array('Appointment.patient_id = Patient.id')),
							'User'=>array('foreignKey'=>false,'conditions'=>array('Appointment.doctor_id = User.id')))));
					
					if(!empty($this->params->query['multiple'])){
						// PAtients having mulitple Appoinments
					$patientList=$this->Appointment->find('all',array('fields'=>array('Patient.lookup_name','Appointment.status','Appointment.date','User.first_name','User.last_name'),
					 'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,'Appointment.doctor_id'=>$this->params->query['doctor'],
					 		'Appointment.location_id'=>$this->Session->read('locationid'),'Appointment.is_deleted'=>'0'),
							'group'=>array('Appointment.person_id having COUNT(Appointment.person_id)>1')));	
					}else{
						$patientList=$this->Appointment->find('all',array('fields'=>array('Patient.lookup_name','Appointment.status','Appointment.date','User.first_name','User.last_name'),
								'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,'Appointment.doctor_id'=>$this->params->query['doctor'],
										'Appointment.location_id'=>$this->Session->read('locationid'),'Appointment.is_deleted'=>'0')));
					}				
					
				}else{
					$this->Appointment->bindmodel(array('belongsTo'=>array(
							'Patient'=>array('foreignKey'=>false,'conditions'=>array('Appointment.patient_id = Patient.id')),
							'User'=>array('foreignKey'=>false,'conditions'=>array('Appointment.doctor_id = User.id')))));

					if(!empty($this->params->query['multiple'])){
						// PAtients having mulitple Appoinments
						$patientList=$this->Appointment->find('all',array('fields'=>array('Patient.lookup_name','Appointment.status','Appointment.date','User.first_name','User.last_name'),
								'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
										'Appointment.location_id'=>$this->Session->read('locationid'),'Appointment.is_deleted'=>'0'),
								'group'=>array('Appointment.person_id having COUNT(Appointment.person_id)>1')));
					}else{
				$patientList=$this->Appointment->find('all',array('fields'=>array('Patient.lookup_name','Appointment.status','Appointment.date','User.first_name','User.last_name'),
					 'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 		'Appointment.location_id'=>$this->Session->read('locationid'),'Appointment.is_deleted'=>'0')));
					}
				}
				
		}
		$this->set('patientList',$patientList);
		$this->layout = false ;
		$this->render('physician_wise_list_excel') ;
		}else{
			if($this->params->query){
				if(!empty($this->params->query['dateFrom'])){
					$dateFrom=date('Y-m-d',strtotime($this->params->query['dateFrom']));					
				}
				else{
					$dateFrom=date('Y-m-d');					
				}
				if(!empty($this->params->query['dateTo'])){
					$dateTo=date('Y-m-d ',strtotime($this->params->query['dateTo']));					
				}else{
					$dateTo=date('Y-m-d');					
				}
				$bothTime = array($dateFrom, $dateTo);
				if(!empty($this->params->query['doctor'])){
					$this->Appointment->bindmodel(array('belongsTo'=>array(
							'Patient'=>array('foreignKey'=>false,'conditions'=>array('Appointment.patient_id = Patient.id')),
							'User'=>array('foreignKey'=>false,'conditions'=>array('Appointment.doctor_id = User.id')))));
					
					if(!empty($this->params->query['multiple'])){
						// PAtients having mulitple Appoinments
						$this->paginate = array(
								'limit' => Configure::read('number_of_rows'),
								'order' => array('Appointment.date' => 'ASC'),
								'fields'=> array('Patient.lookup_name','Appointment.status','Appointment.date','User.first_name','User.last_name'),
								'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,'Appointment.doctor_id'=>$this->params->query['doctor'],
										'Appointment.location_id'=>$this->Session->read('locationid'),'Appointment.is_deleted'=>'0'),
								'group'=>array('Appointment.person_id having COUNT(Appointment.person_id)>1'));
					}else{
					$this->paginate = array(
							'limit' => Configure::read('number_of_rows'),
							'order' => array('Appointment.date' => 'ASC'),
							'fields'=> array('Patient.lookup_name','Appointment.status','Appointment.date','User.first_name','User.last_name'),
							'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,'Appointment.doctor_id'=>$this->params->query['doctor'],
									'Appointment.location_id'=>$this->Session->read('locationid'),'Appointment.is_deleted'=>'0'));
					}
				}else{
					$this->Appointment->bindmodel(array('belongsTo'=>array(
							'Patient'=>array('foreignKey'=>false,'conditions'=>array('Appointment.patient_id = Patient.id')),
							'User'=>array('foreignKey'=>false,'conditions'=>array('Appointment.doctor_id = User.id')))));
					
					if(!empty($this->params->query['multiple'])){
						// PAtients having mulitple Appoinments
						$this->paginate = array(
							'limit' => Configure::read('number_of_rows'),
							'order' => array('Appointment.date' => 'ASC'),
							'fields'=> array('Patient.lookup_name','Appointment.status','Appointment.date','User.first_name','User.last_name'),
							'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
									'Appointment.location_id'=>$this->Session->read('locationid'),'Appointment.is_deleted'=>'0'),
								'group'=>array('Appointment.person_id having COUNT(Appointment.person_id)>1'));
					}else{
			
					$this->paginate = array(
							'limit' => Configure::read('number_of_rows'),
							'order' => array('Appointment.date' => 'ASC'),
							'fields'=> array('Patient.lookup_name','Appointment.status','Appointment.date','User.first_name','User.last_name'),
							'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
									'Appointment.location_id'=>$this->Session->read('locationid'),'Appointment.is_deleted'=>'0'));
					}
			
				}
				$this->set('patientList',$this->paginate('Appointment'));
				//$this->data=$this->params->query;
				$this->set('data',$this->params->query);
			
			}
		}
	
	}
	
	//Response time report---Pooja
	public function response_time_report($type=NULL){
		$this->uses=array('Appointment','Patient','Note','DoctorChamber');
		if($this->params->query){
			if(!empty($this->params->query['dateFrom'])){
				$dateFrom=date('Y-m-d',strtotime($this->params->query['dateFrom']));
				$dateFrom=$dateFrom/*.' 00:00:00'*/;
			}
			else{
				$dateFrom=date('Y-m-d');
				$dateFrom=$dateFrom/*.' 00:00:00'*/;
			}
			if(!empty($this->params->query['dateTo'])){
				$dateTo=date('Y-m-d ',strtotime($this->params->query['dateTo']));
				$dateTo=$dateTo/*.' 23:59:59'*/;
	
			}else{
				$dateTo=date('Y-m-d');
				$dateTo=$dateTo/*.' 23:59:59'*/;
			}
			$bothTime = array($dateFrom, $dateTo);
			
				$this->Patient->bindmodel(array('belongsTo'=>array(
						'Note'=>array('foreignKey'=>false,'conditions'=>array('Note.patient_id = Patient.id')))));
				if($type=='excel'){
					
					$patientList=$this->Patient->find('all',array('fields'=>array('Patient.id','Patient.lookup_name','Patient.doctor_id','Patient.mode_communication','Patient.form_received_on','Note.create_time'),
						'conditions'=>array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_deleted'=>'0','Patient.mode_communication'=>array('Secure Email','Phone','SMS'))));					
					
				}else{				
				$this->paginate = array(
						'limit' => Configure::read('number_of_rows'),
						'order' => array('Appointment.date' => 'ASC'),
						'fields'=> array('Patient.id','Patient.lookup_name','Patient.doctor_id','Patient.mode_communication','Patient.form_received_on','Note.create_time'),
						'conditions'=>array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_deleted'=>'0','Patient.mode_communication'=>array('Secure Email','Phone','SMS')));
				
				/*$patientList=$this->Patient->find('all',array('fields'=>array('Patient.id','Patient.lookup_name','Patient.doctor_id','Patient.mode_communication','Patient.form_received_on','Note.create_time'),
						'conditions'=>array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_deleted'=>'0','Patient.mode_communication'=>array('Secure Email','Phone','SMS'))));*/
			$patientList=$this->paginate('Patient');
				}
			foreach($patientList as $patient){
				$getDocChambersDetails = $this->DoctorChamber->Find('first',array('conditions'=>array('doctor_id'=>$patient['Patient']['doctor_id']),
						'fields'=>array('starttime','endtime')));
				$startTime = strtotime($this->DateFormat->formatDate2Local($getDocChambersDetails['DoctorChamber']['starttime'],'yyyy-mm-dd',true));
				$endTime   = strtotime($this->DateFormat->formatDate2Local($getDocChambersDetails['DoctorChamber']['endtime'],'yyyy-mm-dd',true));
				$patientRequestTime = strtotime($this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],'yyyy-mm-dd',true));
				//debug($getDocChambersDetails['DoctorChamber']);
				if(empty($getDocChambersDetails['DoctorChamber']) || ($patientRequestTime >= $startTime && $patientRequestTime <= $endTime)){
					$contact[$patient['Patient']['id']]['contact']='No';
					
				}
				else
					$contact[$patient['Patient']['id']]['contact']='yes';
				
						
			}
			ksort($patientList);
			$this->set('patientList',$patientList);
			$this->set('contactTime',$contact);
			if($type=='excel'){
				$this->layout = false ;
				$this->render('response_time_report_excel') ;
			}
	
		}
	}
		
		/*
		 * Function link to denominator list of patient 
		 * Pooja Gupta
		 */
		
		public function pcmh_denominator_automated_measure($type=NULL){
			$this->uses = array('DoctorProfile', 'Patient', 'PatientSmoking','Note','NewCropPrescription', 'NewCropAllergies',
					'PrescriptionRecord','LaboratoryTestOrder','LaboratoryResult','Outbox','RadiologyTestOrder',
					'RadiologyReport','FamilyHistory','AdvanceDirective', 'Note', 'Inbox', 'PatientReferral','Appointment',
					'TransmittedCcda', 'XmlNote', 'LaboratoryManualEntry', 'RadiologyManualEntry', 'IncorporatedPatient','LaboratoryHl7Result');
			$report=$this->params->query['report'];
			$startdate=$this->params->query['sd'];
			$year=$this->params->query['year'];
			$duration=$this->params->query['duration'];
			$patient_type=$this->params->query['patient_type'];
			$searchProvider=$this->params->query['provider'];
			//$stage_type=$this->request->params['named']['stage_type'];
			//debug($searchProvider);
			//$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
			if($startdate!="" && $duration !="") {
				$startdate=date('Y-m-d',strtotime($startdate));
				$addDays = $duration;
				$endDate = date("Y-m-d", strtotime("+$addDays days", strtotime($startdate)));
				$bothTime = array($startdate, $endDate);
			}
			
			if($report=='accessVisit'){
				
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))), false);
				$accessVisitDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider,'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
				$this->set('denominatorVal',$accessVisitDenominatorVal);
				
			}else if($report=='clinicalsummary'){
				
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))), false);
				$clinicalsummaryDenominatorVal = $this->Patient->find('all', array('fields' => array('COUNT(*) as count'), 
					'conditions' => array('DATE_FORMAT(Person.patient_credentials_created_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							 'Patient.doctor_id' => $searchProvider,'Patient.admission_type' => $patient_type)));
				
			/*	$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
				$clinicalsummaryDenominatorVal = $this->Note->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type, )));*/
				$this->set('denominatorVal',$clinicalsummaryDenominatorVal);
				
			}else if($report=='problemList'){
				$problemlistDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
				$this->set('denominatorVal',$problemlistDenominatorVal);
			}else if($report=='medicationAllergy'){
				$medicationAllergyDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
				$this->set('denominatorVal',$medicationAllergyDenominatorVal);
			}else if($report=='bloodPressure'){
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))), false);
				$bloodPressureDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
								'DATEDIFF( CURDATE( ) , Person.dob ) /365 >'=>'3'
								/*'TIMESTAMPDIFF(YEAR,Person.dob,CURDATE()) >' => 3)*/),'group'=>array('Patient.patient_id')));
				$this->set('denominatorVal',$bloodPressureDenominatorVal);
			}else if($report=='height'){
				$heightDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
						 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
				$this->set('denominatorVal',$heightDenominatorVal);
			}else if($report=='weight'){
				$weightDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
						 		'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
				$this->set('denominatorVal',$weightDenominatorVal);
			}else if($report=='smokingstatus'){
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))), false);
				$smokingstatusDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
								/*'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >' => 13),'group'=>array('Patient.patient_id')*/ 
								'DATEDIFF(CURDATE(),Person.dob)/365 >'=>'13'),'group'=>array('Patient.patient_id')));
				$this->set('denominatorVal',$smokingstatusDenominatorVal);
			}else if($report=='medicationEligibleSent' || $report=='medicationExplainedHealth'){
				$mapatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'), 
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
				$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
						'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
				$medicationEligibleSentDenominatorVal1 = $this->NewCropPrescription->find('all', array(
						'fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('NewCropPrescription.patient_uniqueid' => $mapatientlist,
						)));
				$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
						'conditions' => array('Patient.id=Note.patient_id')))),false);
				$medicationEligibleSentDenominatorVal2 = $this->Note->find('all', array(
						'fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('Note.patient_id' => $mapatientlist,'Note.no_med_flag'=>array('no','yes'))));
				$medicationEligibleSentDenominatorVal=array_merge($medicationEligibleSentDenominatorVal1,$medicationEligibleSentDenominatorVal2);
				$this->set('denominatorVal',$medicationEligibleSentDenominatorVal);
				
			}else if($report=='medicationlist'){
				$medicationlistDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
						 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
				$this->set('denominatorVal',$medicationlistDenominatorVal);
			}else if($report=='familyhistory'){
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
				$familyhistoryDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
						 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
				$this->set('denominatorVal',$familyhistoryDenominatorVal);
			}else if($report=='enotes'){
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))));
				$enotesDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
						 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)/*,'group'=>array('Patient.patient_id')*/));
				$this->set('denominatorVal',$enotesDenominatorVal);
			}else if($report=='cpoeLab'){
				/*$this->LaboratoryTestOrder->bindModel(array(
						'belongsTo' => array(
								'LaboratoryResult' =>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.laboratory_test_order_id=LaboratoryTestOrder.id')),
								'LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryHl7Result.laboratory_result_id=LaboratoryResult.id')),
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id'=>'LaboratoryResult.patient_id'))
						)),false);*/
				$this->LaboratoryResult->bindModel(array('belongsTo' => array(
						'Patient' => array('foreignKey'=>false,'conditions'=>array('Patient.id=LaboratoryResult.patient_id')),
						'LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryHl7Result.laboratory_result_id')))));
				$cpoeLabDenominatorMVal = $this->LaboratoryResult->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('DATE_FORMAT(LaboratoryHl7Result.date_time_of_observation, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		 'LaboratoryHl7Result.location_id'=>$this->Session->read('locationid'),
						 		'LaboratoryHl7Result.is_electronically_recorded=0',
						 		'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
						 		  'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
				$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
				$cpoelpatientlist = $this->LaboratoryTestOrder->find('list', array('fields' => array('Patient.id', 'Patient.id'), 
						'conditions' => array('DATE_FORMAT(LaboratoryTestOrder.lab_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								 'Patient.location_id'=>$this->Session->read('locationid'), 'LaboratoryTestOrder.is_deleted' => 0,
								 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
								 'Patient.admission_type' => $patient_type), 'recursive' => 1));
				$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
				$cpoeLabDenominatorCVal = $this->LaboratoryTestOrder->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('LaboratoryTestOrder.patient_id' =>$cpoelpatientlist,
						 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
						 		'Patient.doctor_id' => $searchProvider, 'LaboratoryTestOrder.order_id <>' => "", 
						 		'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
				$cpoeLabDenominatorVal=array_merge($cpoeLabDenominatorMVal,$cpoeLabDenominatorCVal);
				$this->set('denominatorVal',$cpoeLabDenominatorVal);
				
			}else if($report=='cpoeRad'){
				$this->RadiologyManualEntry->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
				$cpoeRadDenominatorMVal = $this->RadiologyManualEntry->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'), 
						'conditions' => array('DATE_FORMAT(RadiologyManualEntry.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
				$this->RadiologyTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))),false);
				$cpoerpatientlist = $this->RadiologyTestOrder->find('list', array('fields' => array('Patient.id', 'Patient.id'),
						 'conditions' => array('DATE_FORMAT(RadiologyTestOrder.radiology_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
						 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type),
						         'recursive' => 1));
				$cpoeRadDenominatorCVal = $this->RadiologyTestOrder->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('RadiologyTestOrder.patient_id' =>$cpoerpatientlist,
						 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
						 		 'Patient.doctor_id' => $searchProvider, 'RadiologyTestOrder.order_id <>' => "",
						 		 'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
				$cpoeRadDenominatorVal=array_merge($cpoeRadDenominatorMVal,$cpoeRadDenominatorCVal);
				$this->set('denominatorVal',$cpoeRadDenominatorVal);
			}else if($report=='imaging'){
				/*$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
				$imagingDenominatorVal1 =  $this->LaboratoryTestOrder->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('DATE_FORMAT(LaboratoryTestOrder.start_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
						 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));*/
				$this->RadiologyTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
				$imagingDenominatorVal2 =  $this->RadiologyTestOrder->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('DATE_FORMAT(RadiologyTestOrder.start_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
						 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')
						         ));
				$imagingDenominatorVal=$imagingDenominatorVal2;
				$this->set('denominatorVal',$imagingDenominatorVal);
				
			}else if($report=='searchable'){
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'),
															'Guardian'=>array('foreignKey'=>false,'conditions'=>array('Guardian.person_id=Person.id')),
														    'AdvanceDirective'=>array('foreignKey'=>'patient_id'),
															'User'=>array('foreignKey'=>false,'conditions'=>array('Patient.doctor_id=User.id')))));
				
				$searchableDenominatorVal =  $this->Patient->find('all', array('fields' => array('Person.dob','Patient.lookup_name',
						'Patient.patient_id','Person.race','Patient.insurance_company_name','Person.ethnicity','Person.person_local_number','Person.person_local_number_second','User.first_name',
						'User.last_name','Person.person_email_address','Person.occupation','Guardian.guar_first_name','AdvanceDirective.patient_name'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)/*,'group'=>array('Patient.id')*/));
				$this->set('denominatorVal',$searchableDenominatorVal);
			}else if($report=='medication'){
				$medicationDenominatorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
						 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)/*,'group'=>array('Patient.id')*/));
				$this->set('denominatorVal',$medicationDenominatorVal);
			}else if($report=='medicationOtcAssesed'){
				//$medicationDenominatorVal =  $this->Patient->find('all', array('fields' => array('COUNT( Patient.patient_id) as count'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
				$mapatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
				$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
						'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))),false);
				$medicationOtcAssesedInteractionDenominatorVal = $this->NewCropPrescription->find('all', array(
						'fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
								'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type,
								'NewCropPrescription.DeaLegendDescription' => 'OTC')));
				$this->set('denominatorVal',$medicationOtcAssesedInteractionDenominatorVal);
			}else if($report=='medicationrecon'){
				$this->IncorporatedPatient->bindModel(array('belongsTo' =>
						array('Patient' => array('foreignKey'=>'patient_id'),
								'NewCropPrescription'=>array('foreignKey'=>false,'conditions'=>array('NewCropPrescription.patient_uniqueid=IncorporatedPatient.patient_id')))));
				
				$medicationreconDenominatorVal = $this->IncorporatedPatient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(IncorporatedPatient.date_imported_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.doctor_id' => $searchProvider,  'Patient.admission_type' => $patient_type),'group'=>array('Patient.id')));
				$this->set('denominatorVal',$medicationreconDenominatorVal);
			}else if($report=='lab'){
				$this->LaboratoryTestOrder->bindModel(array(
						'belongsTo' => array(
								'LaboratoryResult' =>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.laboratory_test_order_id=LaboratoryTestOrder.id')),
								'LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryHl7Result.laboratory_result_id=LaboratoryResult.id')),
								'Patient'=>array('foreignKey'=>false,'fields'=>array('Patient.patient_id','Patient.lookup_name'),'conditions'=>array('Patient.id'=>'LaboratoryResult.patient_id'))
						)),false);
				$labDenominatorVal = $this->LaboratoryTestOrder->find('all',array('fields'=>array('LaboratoryResult.id'),
						'conditions'=>array('DATE_FORMAT(LaboratoryTestOrder.lab_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'LaboratoryTestOrder.location_id'=>$this->Session->read('locationid'),
								'LaboratoryTestOrder.is_deleted=0','LaboratoryTestOrder.created_by'=>$searchProvider)));
				foreach($labDenominatorVal as $ids){
					$labRes[$ids['LaboratoryResult']['id']]=$ids['LaboratoryResult']['id'];
				}				
				$this->Patient->bindModel(array('belongsTo'=>array(
						'LaboratoryResult'=>array('foreignKey'=>false,'conditions'=>array('Patient.id = LaboratoryResult.patient_id')))));
				$res=$this->Patient->find('all',array('fields'=>array('Patient.patient_id','Patient.lookup_name'),'conditions'=>array('LaboratoryResult.id'=>$labRes)));
				$this->set('denominatorVal',$res);
			}else if($report=='overdue'){
				$this->LaboratoryTestOrder->bindModel(array(
						'belongsTo' => array(
								'LaboratoryResult' =>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.laboratory_test_order_id=LaboratoryTestOrder.id')),
								'LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryHl7Result.laboratory_result_id=LaboratoryResult.id')),
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id = LaboratoryResult.patient_id')),
						)),
						false);
				$overduelabDenominatorVal = $this->LaboratoryTestOrder->find('all',array('fields'=>array('Patient.lookup_name','Patient.patient_id'),
						'conditions'=>array('DATE_FORMAT(LaboratoryTestOrder.lab_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'LaboratoryTestOrder.location_id'=>$this->Session->read('locationid'),
								'LaboratoryTestOrder.is_deleted=0','LaboratoryTestOrder.created_by'=>$searchProvider)));
				
				$this->set('denominatorVal',$overduelabDenominatorVal);
			}else if($report=='overdueRad'){
				$this->RadiologyTestOrder->bindModel(array(
						'belongsTo' => array(
								'RadiologyResult' =>array('foreignKey'=>false,'conditions'=>array('RadiologyResult.radiology_test_order_id=RadiologyTestOrder.id')),
								'Patient'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('Patient.id =RadiologyResult.patient_id')),
						)),false);
				$overdueRadDenominatorVal = $this->RadiologyTestOrder->find('all',array('fields'=>array('Patient.lookup_name','Patient.patient_id','RadiologyResult.id'),
						'conditions'=>array('DATE_FORMAT(RadiologyTestOrder.radiology_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'RadiologyTestOrder.location_id'=>$this->Session->read('locationid'),'RadiologyTestOrder.is_deleted=0',
								'RadiologyTestOrder.created_by'=>$searchProvider)));
				$this->set('denominatorVal',$overdueRadDenominatorVal);
			}else if($report=='specificEducation'){
				$this->NewCropPrescription->bindModel(array(
						'belongsTo' => array(
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id =NewCropPrescription.patient_id')),
						)),false);
				$specificeducationDemo =$this->NewCropPrescription->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(NewCropPrescription.created, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'NewCropPrescription.archive' =>'N',
								'NewCropPrescription.created_by' => $searchProvider)));
				$this->set('denominatorVal',$specificeducationDemo);
				
			}else if($report=='electronic'){
				$this->PatientReferral->bindModel(array(
						'belongsTo' => array(
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id =PatientReferral.patient_id')),
						)),false);
				$electronicManualVal =  $this->PatientReferral->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('DATE_FORMAT(PatientReferral.date_of_issue, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		 'PatientReferral.location_id'=>$this->Session->read('locationid'),
						 		 'PatientReferral.created_by' => $searchProvider)));
				$this->TransmittedCcda->bindModel(array(
						'belongsTo' => array(
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id =TransmittedCcda.patient_id')),
						)),false);
				$electronicVal =  $this->TransmittedCcda->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('DATE_FORMAT(TransmittedCcda.referral_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		 'TransmittedCcda.location_id'=>$this->Session->read('locationid'),
						 		 'TransmittedCcda.created_by' => $searchProvider)));
				$electronicDeno=array_merge($electronicManualVal,$electronicVal);
				$this->set('denominatorVal',$electronicDeno);
			}else if($report=='patientInfo'){
				$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
						 'conditions' => array('Patient.id=Note.patient_id')))));
				$patientIdArray =  $this->Note->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('DATE_FORMAT(Note.note_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		'Patient.location_id'=>$this->Session->read('locationid'),'Note.sb_registrar' => $searchProvider,
						 		'Note.refer_to_hospital'=>'1')));
				$this->set('denominatorVal',$patientIdArray);
			}else if($report=='summary'){
				$this->PatientReferral->bindModel(array(
						'belongsTo' => array(
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id =PatientReferral.patient_id')),
						)),false);
				$ManualVal =  $this->PatientReferral->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('DATE_FORMAT(PatientReferral.date_of_issue, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		 'PatientReferral.location_id'=>$this->Session->read('locationid'),
						 		 'PatientReferral.created_by' => $searchProvider)));
				$this->TransmittedCcda->bindModel(array(
						'belongsTo' => array(
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id =TransmittedCcda.patient_id')),
						)),false);
				$electronicVal =  $this->TransmittedCcda->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('DATE_FORMAT(TransmittedCcda.referral_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		 'TransmittedCcda.location_id'=>$this->Session->read('locationid'),
						 		 'TransmittedCcda.referral_to'=>'Specialist','TransmittedCcda.created_by' => $searchProvider),
								 'group'=>array('Patient.id')));
				$summaryVal=array_merge($ManualVal,$electronicVal);
				$this->set('denominatorVal',$summaryVal);
					
			}else if($report=='ccdaArrivals'){
				$this->Appointment->bindModel(array(
						'belongsTo' => array(
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id =Appointment.patient_id')),
						)),false);
				
				$ccdaArrivalsdenominatorVal=$this->Appointment->find('all',array('fields'=>array('Patient.lookup_name','Patient.patient_id'),
						'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
								'Appointment.doctor_id' => $searchProvider,'Appointment.status NOT'=>array('Scheduled','Pending','No-Show','Cancelled')
						)));
					
				$this->set('denominatorVal',$ccdaArrivalsdenominatorVal);
			}else if($report=='noShow'){
				$this->Appointment->bindModel(array(
						'belongsTo' => array(
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id =Appointment.patient_id')),
						)),false);
				$noShowDenominatorVal=$this->Appointment->find('all',array('fields'=>array('Patient.lookup_name','Patient.patient_id'),
						'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
								'Appointment.doctor_id' => $searchProvider,
						)));
				$this->set('denominatorVal',$noShowDenominatorVal);
			}
			$this->set('date',$bothTime);
			$providerName=$this->DoctorProfile->find('first',array('fields'=>array('doctor_name'),'conditions'=>array('DoctorProfile.user_id'=>$searchProvider)));
			$this->set('provider',$providerName);
			if($type=='excel'){
				$this->layout = false ;
				$this->render('pcmh_patients_list_excel') ;
			}
			
		}
		
		public function pcmh_numerator_automated_measure($type=NULL){
			$this->uses = array('DoctorProfile', 'Patient', 'PatientSmoking','Note','NewCropPrescription', 'NewCropAllergies',
					'PrescriptionRecord','LaboratoryTestOrder','LaboratoryResult','Outbox','RadiologyTestOrder','BmiResult','PatientDocument',
					'RadiologyReport','FamilyHistory','AdvanceDirective', 'Note', 'Inbox', 'PatientReferral','Appointment','PastMedicalHistory',
					'TransmittedCcda', 'XmlNote', 'LaboratoryManualEntry','Diagnosis', 'RadiologyManualEntry', 'IncorporatedPatient','LaboratoryHl7Result','NoteDiagnosis');
			$report=$this->params->query['report'];
			$startdate=$this->params->query['sd'];
			$year=$this->params->query['year'];
			$duration=$this->params->query['duration'];
			$patient_type=$this->params->query['patient_type'];
			$searchProvider=$this->params->query['provider'];
			//$stage_type=$this->request->params['named']['stage_type'];
			//debug($searchProvider);
			//$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
			if($startdate!="" && $duration !="") {
				$startdate=date('Y-m-d',strtotime($startdate));
				$addDays = $duration;
				$endDate = date("Y-m-d", strtotime("+$addDays days", strtotime($startdate)));
				$bothTime = array($startdate, $endDate);
			}
			if($report=='accessVisit'){
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
				$accessVisitNumeratorVal=$this->Patient->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						'conditions' => array('DATE_FORMAT(Person.patient_credentials_created_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider,'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
				
				$this->set('numeratorVal',$accessVisitNumeratorVal);
			}else if($report=='clinicalsummary'){
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
				
				$clinicalsummaryNumeratorVal = $this->Patient->find('all', array('fields' => array('COUNT(*) as count'), 
					'conditions' => array('DATE_FORMAT(Person.patient_credentials_created_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
							 'Patient.doctor_id' => $searchProvider,'Patient.admission_type' => $patient_type)));
				
				
				/*$this->XmlNote->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
				$clinicalsummaryNumeratorVal =  $this->XmlNote->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						'conditions' => array('DATE_FORMAT(XmlNote.clinical_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'),
								//For condition of 1 business day difference between registration and clinical summary generation
								'(TO_DAYS(XmlNote.clinical_date ) - TO_DAYS( Patient.form_received_on))>=0 AND (TO_DAYS(XmlNote.clinical_date ) - TO_DAYS( Patient.form_received_on))<=1 ',
								'XmlNote.option !='=>'None', 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
								'Patient.admission_type' => $patient_type)));*/
				$this->set('numeratorVal',$clinicalsummaryNumeratorVal);
			}else if($report=='problemList'){
				
				/*$this->NoteDiagnosis->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
				$problemlistNumeratorVal1 = $this->NoteDiagnosis->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type),
						'NoteDiagnosis.patient_id NOT' => array('', 0),'group'=>array('NoteDiagnosis.patient_id')));*/
				
				$this->NoteDiagnosis->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
				$problemlistNumeratorVal1 = $this->NoteDiagnosis->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						'conditions' => array('DATE_FORMAT(NoteDiagnosis.start_dt, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type ,
								'NoteDiagnosis.patient_id NOT' => array('', 0)),'group'=>array('Patient.patient_id')));
				$this->PastMedicalHistory->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
				$problemlistNumeratorVal2 = $this->PastMedicalHistory->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						'conditions' => array('DATE_FORMAT(PastMedicalHistory.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type ,
								'PastMedicalHistory.patient_id NOT' => array('', 0),'PastMedicalHistory.no_known_problems=1'),'group'=>array('Patient.patient_id')));
				
				$problemlistNumeratorVal=array_merge($problemlistNumeratorVal1,$problemlistNumeratorVal2);
				
				/*$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
				$problemlistNumeratorVal = $this->Note->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
								'OR' => array('Note.icd <>' => "", array('NOT' => array('Note.icd_record' => NULL))),
								'Note.patient_id NOT' => array('', 0))));*/
				$this->set('numeratorVal',$problemlistNumeratorVal);
			}else if($report=='medicationAllergy'){
				$mapatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
						'conditions' => array(/*'DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,*/
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
				$this->NewCropAllergies->bindModel(array('belongsTo' => array(
						'Patient' => array('foreignKey'=>false,'conditions' => array('Patient.id=NewCropAllergies.patient_uniqueid')))));
				$medicationAllergyNumeratorVal1 = $this->NewCropAllergies->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						'conditions' => array( 'NewCropAllergies.patient_uniqueid' => $mapatientlist,
								'DATE_FORMAT(NewCropAllergies.created, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'NewCropAllergies.allergycheck' => array(0,1),
								'NewCropAllergies.status'=>'A'),'group'=>array('Patient.patient_id')));
					
				$this->Patient->bindModel(array('belongsTo'=>array(
						'Diagnosis'=>array('foreignKey'=>false,'conditions'=>array('Patient.id=Diagnosis.patient_id')),
						'Note'=>array('foreignKey'=>false,'conditions'=>array('Patient.id=Note.patient_id'))
				)));
				$medicationAllergyNumeratorVal2=$this->Patient->find('all',array('fields'=>array('Patient.patient_id','Patient.lookup_name'),
						'conditions'=>array('Patient.id'=>$mapatientlist,
								'OR'=>array('DATE_FORMAT(Diagnosis.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
							'DATE_FORMAT(Diagnosis.modify_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime),'OR'=>array('Diagnosis.no_allergy_flag '=>array('yes'),'Note.no_allergy_flag'=>array('yes'))),'group'=>array('Patient.patient_id')));				
				
				
				$medicationAllergyNumeratorVal=array_merge($medicationAllergyNumeratorVal1,$medicationAllergyNumeratorVal2);
				/*$mapatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'), 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
				$this->NewCropAllergies->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
						'conditions' => array('Patient.id=NewCropAllergies.patient_uniqueid')))));
				$medicationAllergyNumeratorVal = $this->NewCropAllergies->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						'conditions' => array('Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'NewCropAllergies.patient_uniqueid' => $mapatientlist,
								'Patient.admission_type' => $patient_type, 'NewCropAllergies.allergycheck' => array(0,1)),'group'=>array('Patient.id')));*/
				$this->set('numeratorVal',$medicationAllergyNumeratorVal);
			}else if($report=='bloodPressure'){
				$this->BmiResult->bindModel(array('belongsTo' => array('BmiBpResult' => array('foreignKey'=> false, 'conditions' => array('BmiBpResult.bmi_result_id=BmiResult.id')),
						'Patient' => array('foreignKey'=> false, 'conditions' => array('BmiResult.patient_id=Patient.id')),
						'Person' => array('foreignKey'=>false,'conditions'=>array('Patient.person_id=Person.id')),
				)));
				$bloodPressureNumeratorVal = $this->BmiResult->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						'conditions' => array('Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
								/*'TIMESTAMPDIFF(YEAR,Person.dob,CURDATE()) >' => '3'*/'DATEDIFF( CURDATE( ) , Person.dob ) /365 >'=>'3',
								'OR' => array('NOT' => array('BmiBpResult.systolic' => "", 'BmiBpResult.diastolic' => ""))),'group'=>array('Patient.patient_id')));
				$this->set('numeratorVal',$bloodPressureNumeratorVal);
			}else if($report=='height'){
				$this->BmiResult->bindModel(array('belongsTo' => array('BmiBpResult' => array('foreignKey'=> false, 
						'conditions' => array('BmiBpResult.bmi_result_id=BmiResult.id')),
						'Patient' => array('foreignKey'=> false, 'conditions' => array('BmiResult.patient_id=Patient.id')))));
				
				$heightNumeratorVal = $this->BmiResult->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						 'conditions' => array('Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
						 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
						 		 'BmiResult.height <>' => ""),'group'=>array('BmiResult.patient_id')));
				$this->set('numeratorVal',$heightNumeratorVal);
			}else if($report=='weight'){
				$this->BmiResult->bindModel(array('belongsTo' => array('BmiBpResult' => array('foreignKey'=> false, 'conditions' => array('BmiBpResult.bmi_result_id=BmiResult.id')),
						'Patient' => array('foreignKey'=> false, 'conditions' => array('BmiResult.patient_id=Patient.id')))));
				$weightNumeratorVal = $this->BmiResult->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						 'conditions' => array('Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
						 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
						 		 'BmiResult.weight <>' => ""),'group'=>array('BmiResult.patient_id')));
				$this->set('numeratorVal',$weightNumeratorVal);
			}else if($report=='smokingstatus'){
				$this->Diagnosis->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
						'Person' => array('foreignKey'=>false, 'conditions' => array('Person.id=Patient.person_id')),
						'PatientPersonalHistory'=>array('foreignKey'=>false,'conditions'=>array('PatientPersonalHistory.diagnosis_id=Diagnosis.id')))));
				$smokingstatusNumeratorVal = $this->Diagnosis->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						'conditions' => array('Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'PatientPersonalHistory.diagnosis_id NOT' => array('', 0) , 'PatientPersonalHistory.smoking' =>array('0','1'), 'PatientPersonalHistory.tobacco' =>array('0','1'),
								'Patient.doctor_id' => $searchProvider,'Patient.admission_type' => $patient_type,
								/*'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >' => '13'*/
								'DATEDIFF(CURDATE(),Person.dob)/365 >'=>'13'),'group'=>array('Patient.patient_id')));
					
				/*$this->PatientSmoking->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
						'Person' => array('foreignKey'=>false, 'conditions' => array('Person.id=Patient.person_id'))
				)));
				$smokingstatusNumeratorVal = $this->PatientSmoking->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						'conditions' => array('Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'PatientSmoking.patient_id NOT' => array('', 0) , 'PatientSmoking.current_smoking_fre <>' => "",
								'Patient.doctor_id' => $searchProvider,'Patient.admission_type' => $patient_type,
								'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >' => '13'),'group'=>array('Patient.id')));*/
				$this->set('numeratorVal',$smokingstatusNumeratorVal);
			}else if($report=='medicationlist'){
				$mlpatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
						'conditions' => array(/*'DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,*/
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
				$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
						'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
				$medicationlistNumeratorVal = $this->NewCropPrescription->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						'conditions' => array('Patient.location_id'=>$this->Session->read('locationid'),
					 		 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
					 		'Patient.admission_type' => $patient_type,'NewCropPrescription.patient_uniqueid' => $mlpatientlist,
					 		'OR'=>array('DATE_FORMAT(NewCropPrescription.modified, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
					 				'DATE_FORMAT(NewCropPrescription.created, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,'DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime),
					 		 'NewCropPrescription.uncheck' => array(0,1)),'group'=>array('Patient.patient_id')));
				
			/*	$mlpatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
						 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
						 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type)));
				$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
						 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
				$medicationlistNumeratorVal = $this->NewCropPrescription->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						 'conditions' => array('Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
						 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
						 		 'NewCropPrescription.patient_uniqueid' => $mlpatientlist, 'NewCropPrescription.uncheck' => array(0,1))));*/
				$this->set('numeratorVal',$medicationlistNumeratorVal);
			}else if($report=='familyhistory'){
				$this->FamilyHistory->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
					
				$familyhistoryNumeratorVal =  $this->FamilyHistory->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						'conditions' => array('DATE_FORMAT(FamilyHistory.created, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
								'OR'=>array('FamilyHistory.is_positive_family=1','FamilyHistory.is_positive_family=0'/*,'FamilyHistory.is_positive_family'=>NULL*/))));
				
				
				/*$this->FamilyHistory->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
				$familyhistoryNumeratorVal =  $this->FamilyHistory->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 
						 		'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
						 		'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
						 		'FamilyHistory.is_positive_family=1')));*/
				$this->set('numeratorVal',$familyhistoryNumeratorVal);
			}else if($report=='enotes'){
				$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
				$enotesNumeratorVal =  $this->Note->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						'conditions' => array('DATE_FORMAT(Note.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'),
								'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
								'Patient.admission_type' => $patient_type)));
				
				
				/*$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
				$enotesNumeratorVal =  $this->Note->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						 'conditions' => array('DATE_FORMAT(Note.note_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
						 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type),'group'=>array('Patient.id')));*/
				$this->set('numeratorVal',$enotesNumeratorVal);
			}else if($report=='cpoeLab'){
				$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
				$cpoelpatientlist = $this->LaboratoryTestOrder->find('list', array('fields' => array('Patient.id', 'Patient.id'),
						 'conditions' => array('DATE_FORMAT(LaboratoryTestOrder.lab_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		 'Patient.location_id'=>$this->Session->read('locationid'), 'LaboratoryTestOrder.is_deleted' => 0,
						 		 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type), 'recursive' => 1));
				$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
				$cpoeLabNumeratorVal = $this->LaboratoryTestOrder->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						 'conditions' => array('LaboratoryTestOrder.patient_id' =>$cpoelpatientlist,
						 		 'Patient.location_id'=>$this->Session->read('locationid'),
						 		 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
						 		'LaboratoryTestOrder.order_id <>' => "", 'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
				$this->set('numeratorVal',$cpoeLabNumeratorVal);
			}else if($report=='cpoeRad'){
				$this->RadiologyTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
				$cpoerpatientlist = $this->RadiologyTestOrder->find('list', array('fields' => array('Patient.id', 'Patient.id'),
						 'conditions' => array('DATE_FORMAT(RadiologyTestOrder.radiology_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
						 		 'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type),
								 'recursive' => 1));
				$this->RadiologyTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
				$cpoeRadNumeratorVal = $this->RadiologyTestOrder->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						 'conditions' => array('RadiologyTestOrder.patient_id' =>$cpoerpatientlist,
						 		 'Patient.location_id'=>$this->Session->read('locationid'),
						 		 'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
						 		 'RadiologyTestOrder.order_id <>' => "", 'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
				$this->set('numeratorVal',$cpoeRadNumeratorVal);
			}else if($report=='imaging'){
				
				$this->RadiologyReport->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
				$imagingNumeratorVal =  $this->RadiologyReport->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						 'conditions' => array('DATE_FORMAT(RadiologyReport.create_time, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
						 		 'RadiologyReport.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
						 		'Patient.admission_type' => $patient_type),'group'=>array('Patient.patient_id')));
					
				/*$this->PatientDocument->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
				$imagingNumeratorVal =  $this->PatientDocument->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						 'conditions' => array('DATE_FORMAT(PatientDocument.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		 'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0, 
						 		'PatientDocument.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
						 		'Patient.admission_type' => $patient_type,'PatientDocument.document_id IN("1","13")')));*///document id 1 and 13 for lab and radiology--- Pooja
				$this->set('numeratorVal',$imagingNumeratorVal);
			}else if($report=='searchable'){
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'),
						'Guardian'=>array('foreignKey'=>false,'conditions'=>array('Guardian.person_id=Person.id')),
						'AdvanceDirective'=>array('foreignKey'=>'patient_id'))));
				$searchableNumeratorVal =  $this->Patient->find('all', array('fields' => array('Person.dob','Patient.lookup_name',
						'Patient.patient_id','Person.race','Person.ethnicity','Person.person_local_number','Person.guar_first_name','Person.person_local_number_second'/*,'User.first_name',
						'User.last_name'*/,'Person.person_email_address','Person.preferred_language','Person.occupation','Guardian.guar_first_name','AdvanceDirective.patient_name'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
								'OR'=>array('Person.dob NOT'=>NULL,'Person.sex NOT'=>NULL,'Person.race NOT'=>NULL,'Person.ethnicity NOT'=>NULL,
										'Person.person_local_number NOT'=>NULL,'Person.person_local_number_second NOT'=>NULL,
										'Person.person_email_address NOT'=>NULL,'Person.occupation NOT'=>NULL,'Guardian.guar_first_name NOT'=>NULL,
										'Patient.doctor_id NOT'=>NULL,'AdvanceDirective.patient_name NOT'=>NULL))/*,'group'=>array('Patient.id')*/));
				$this->set('numeratorVal',$searchableNumeratorVal);
			}else if($report=='medicationrecon'){
				$this->IncorporatedPatient->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'),
						'NewCropPrescription'=>array('foreignKey'=>false,'conditions'=>array('NewCropPrescription.patient_uniqueid=IncorporatedPatient.patient_id')))));
				
				$medicationreconNumeratorVal = $this->IncorporatedPatient->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						'conditions' => array('DATE_FORMAT(IncorporatedPatient.date_imported_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime, 'Patient.doctor_id' => $searchProvider
								, 'Patient.admission_type' => $patient_type,'NewCropPrescription.date_of_prescription  BETWEEN ? AND ? ' =>$bothTime,'NewCropPrescription.is_reconcile'=>1,'IncorporatedPatient.summary_provide'=>1)));
				$this->set('numeratorVal',$medicationreconNumeratorVal);
			}else if($report=='lab'){
				$this->LaboratoryTestOrder->bindModel(array(
						'belongsTo' => array(
								'LaboratoryResult' =>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.laboratory_test_order_id=LaboratoryTestOrder.id')),
								'LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryHl7Result.laboratory_result_id=LaboratoryResult.id')),
								'Patient'=>array('foreignKey'=>false,'fields'=>array('Patient.patient_id','Patient.lookup_name'),'conditions'=>array('Patient.id'=>'LaboratoryResult.patient_id'))
						)),false);	
				
				$labNumeratorVal = $this->LaboratoryTestOrder->find('all',array('fields'=>array('LaboratoryResult.id'),
						'conditions'=>array('DATE_FORMAT(LaboratoryTestOrder.lab_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'LaboratoryTestOrder.location_id'=>$this->Session->read('locationid'),
								'LaboratoryTestOrder.is_deleted=0','LaboratoryTestOrder.created_by'=>$searchProvider,'LaboratoryHl7Result.abnormal_flag'=>'A')));
				foreach($labNumeratorVal as $ids){
					$labRes[$ids['LaboratoryResult']['id']]=$ids['LaboratoryResult']['id'];
				}
				$this->Patient->bindModel(array('belongsTo'=>array(
						'LaboratoryResult'=>array('foreignKey'=>false,'conditions'=>array('Patient.id = LaboratoryResult.patient_id')))));
				$res=$this->Patient->find('all',array('fields'=>array('Patient.patient_id','Patient.lookup_name'),'conditions'=>array('LaboratoryResult.id'=>$labRes)));
				$this->set('numeratorVal',$res);
			}else if($report=='overdueLab'){
				$this->LaboratoryTestOrder->bindModel(array(
						'belongsTo' => array(
								'LaboratoryResult' =>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.laboratory_test_order_id=LaboratoryTestOrder.id')),
								'LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryHl7Result.laboratory_result_id=LaboratoryResult.id')),
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id = LaboratoryResult.patient_id')),
						)),
						false);
				$overduelabNumeratorVal = $this->LaboratoryTestOrder->find('all',array('fields'=>array('Patient.patient_id','Patient.lookup_name'),
						'conditions'=>array('DATE_FORMAT(LaboratoryTestOrder.lab_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'LaboratoryTestOrder.location_id'=>$this->Session->read('locationid'),'LaboratoryTestOrder.is_deleted=0',
								'LaboratoryTestOrder.created_by'=>$searchProvider,'LaboratoryHl7Result.abnormal_flag'=>'A',
								'DATE_FORMAT(LaboratoryTestOrder.lab_order_date, "%Y-%m-%d")<DATE_FORMAT(LaboratoryHl7Result.date_time_of_observation, "%Y-%m-%d")')));
				$this->set('numeratorVal',$overduelabNumeratorVal);
			}else if($report=='overdueRad'){
				$this->RadiologyTestOrder->bindModel(array(
						'belongsTo' => array(
								'RadiologyResult' =>array('foreignKey'=>false,'conditions'=>array('RadiologyResult.radiology_test_order_id=RadiologyTestOrder.id')),
								'Patient'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('Patient.id =RadiologyResult.patient_id')),
						)),false);
				$overdueRadNumeratoVal = $this->RadiologyTestOrder->find('all',array('fields'=>array('Patient.patient_id','Patient.lookup_name'),
						'conditions'=>array('DATE_FORMAT(RadiologyTestOrder.radiology_order_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'RadiologyTestOrder.location_id'=>$this->Session->read('locationid'),'RadiologyTestOrder.is_deleted=0',
								'RadiologyTestOrder.created_by'=>$searchProvider,
								'DATE_FORMAT(RadiologyTestOrder.radiology_order_date, "%Y-%m-%d")<DATE_FORMAT(RadiologyResult.result_publish_date, "%Y-%m-%d")')));
				$this->set('numeratorVal',$overdueRadNumeratoVal);
			}else if($report=='specificEducation'){
				$this->NewCropPrescription->bindModel(array(
						'belongsTo' => array(
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id =NewCropPrescription.patient_uniqueid')),
						)),false);
				$specificeducationNum =$this->NewCropPrescription->find('all', array('fields' => array('Patient.patient_id','Patient.lookup_name'),
						'conditions' => array('DATE_FORMAT(NewCropPrescription.created, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'NewCropPrescription.archive' =>'N',
								'NewCropPrescription.created_by' => $searchProvider,'patient_info !='=>'')));
				$this->set('numeratorVal',$specificeducationNum);
			}else if($report=='electronic'){
				$this->TransmittedCcda->bindModel(array(
						'belongsTo' => array(
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id =TransmittedCcda.patient_id')),
						)),false);
				$electronicVal =  $this->TransmittedCcda->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(TransmittedCcda.referral_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'TransmittedCcda.location_id'=>$this->Session->read('locationid'),
								'TransmittedCcda.referral_to'=>'Specialist','TransmittedCcda.created_by' => $searchProvider),
						'group'=>array('Patient.id')));	
				$this->set('numeratorVal',$electronicVal);
			}else if($report=='patientInfo'){
				$this->Note->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false, 'conditions' => array('Patient.id=Note.patient_id')))));
				$patientIdArray =  $this->Note->find('all', array('fields' => array('Note.id'),
						 'conditions' => array('DATE_FORMAT(Note.note_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		'Patient.location_id'=>$this->Session->read('locationid'),'Note.sb_registrar' => $searchProvider,
						 		'Note.refer_to_hospital'=>'1')));
				foreach($patientIdArray as $ids){
					$patientArray[$ids['Note']['id']]=$ids['Note']['id'];
				}
				$this->TransmittedCcda->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false, 'conditions' => array('Patient.id=TransmittedCcda.patient_id')))));
				$patientInfoNumeratorVal= $this->TransmittedCcda->find('all',array('fields'=>array('Patient.patient_id','Patient.lookup_name'),
						'conditions' => array('DATE_FORMAT(TransmittedCcda.referral_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								 'TransmittedCcda.location_id'=>$this->Session->read('locationid'),
								 'TransmittedCcda.created_by' => $searchProvider,
								 'TransmittedCcda.patient_id '=>$patientArray)));
				$this->set('numeratorVal',$patientInfoNumeratorVal);
			}else if($report=='summary'){
				$this->TransmittedCcda->bindModel(array(
						'belongsTo' => array(
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id =TransmittedCcda.patient_id')),
						)),false);
				$electronicVal =  $this->TransmittedCcda->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(TransmittedCcda.referral_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'TransmittedCcda.location_id'=>$this->Session->read('locationid'),
								'TransmittedCcda.referral_to'=>'Specialist','TransmittedCcda.created_by' => $searchProvider),
						'group'=>array('Patient.id')));	
				$this->set('numeratorVal',$electronicVal);
			}else if($report=='arrivals'){
				$this->Appointment->bindModel(array(
						'belongsTo'=>array(
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id =Appointment.patient_id')))));
				$arrivalsNumeratorVal=$this->Appointment->find('all',array('fields'=>array('Patient.lookup_name','Patient.patient_id'),
						'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
								'Appointment.doctor_id' => $searchProvider,'Appointment.status NOT'=>array('Scheduled','Pending','No-Show','Cancelled')
						)));
				$this->set('numeratorVal',$arrivalsNumeratorVal);
			}else if($report=='noShow'){
				$this->Appointment->bindModel(array(
						'belongsTo'=>array(
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id =Appointment.patient_id')))));
				$noShowNumeratorVal=$this->Appointment->find('all',array('fields'=>array('Patient.lookup_name','Patient.patient_id'),
						'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
								'Appointment.doctor_id' => $searchProvider,'Appointment.status'=>'No-Show')));	
				$this->set('numeratorVal',$noShowNumeratorVal);
			}else if($report=='medicationPrinted'){
				$mapatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
						 'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
						 		'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
						 		 'Patient.admission_type' => $patient_type)));
				$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
						 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
				$medicationPrintedNumeratorVal = $this->NewCropPrescription->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
						 		 'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type,
						 		 'NewCropPrescription.PrintLeaflet' => 'T')));
				$this->set('numeratorVal',$medicationPrintedNumeratorVal);
			}else if($report=='medicationExplainedHealth'){
				$mapatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
								'Patient.admission_type' => $patient_type)));
				$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
						 'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
				$medicationExplainedHealthNumeratorVal = $this->NewCropPrescription->find('all', array(
						'fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
						 		 'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type,
						 		 'OR'=>array('NewCropPrescription.health_literacy' => 1,'NewCropPrescription.PrintLeaflet' => 'T'))));
				$this->set('numeratorVal',$medicationExplainedHealthNumeratorVal);
			}else if($report=='medicationDifficulty'){
				$mapatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
								'Patient.admission_type' => $patient_type)));
				$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
						'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
				$medicationDifficultyNumeratorVal = $this->NewCropPrescription->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
						 		 'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type,
						 		 'NewCropPrescription.had_difficulty' => 1)));
				$this->set('numeratorVal',$medicationDifficultyNumeratorVal);
			}else if($report=='medicationHassideeffect'){
				$mapatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
								'Patient.admission_type' => $patient_type)));
				$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
						'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
				$medicationHassideeffectNumeratorVal = $this->NewCropPrescription->find('all', array(
						'fields' => array('Patient.lookup_name','Patient.patient_id'), 
						'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
								 'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type,
								 'NewCropPrescription.side_effects' => 1)));
				$this->set('numeratorVal',$medicationHassideeffectNumeratorVal);
			}else if($report=='medicationMedicationPrescribed'){
				$mapatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
								'Patient.admission_type' => $patient_type)));
				$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
						'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
				$medicationPrescribedNumeratorVal = $this->NewCropPrescription->find('all', array(
						'fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
						 		 'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type,
						 		 'NewCropPrescription.took_medication' => 1)));
				$this->set('numeratorVal',$medicationPrescribedNumeratorVal);
			}else if($report=='medicationIssupplement'){
				$mapatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
								'Patient.admission_type' => $patient_type)));
				$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
						'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
				$medicationIssupplementNumeratorVal = $this->NewCropPrescription->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
						 		 'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type,
						 		 "OR"=>array('NewCropPrescription.is_a_supplement' => 1,'NewCropPrescription.DeaLegendDescription' => 'OTC'))));
				$this->set('numeratorVal',$medicationIssupplementNumeratorVal);
			}else if($report=='medicationIsherbal'){
				$mapatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
								'Patient.admission_type' => $patient_type)));
				$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
						'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
				$medicationIsherbalNumeratorVal = $this->NewCropPrescription->find('all', array(
						'fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
						 		 'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type,
						 		 "OR"=>array('NewCropPrescription.is_a_herbal_therapy' => 1,'NewCropPrescription.DeaLegendDescription' => 'OTC'))));
				$this->set('numeratorVal',$medicationIsherbalNumeratorVal);
			}else if($report=='medicationReportedInteraction'){
				$mapatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
								'Patient.admission_type' => $patient_type)));
				$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
						'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
				$medicationReportedInteractionNumeratorVal = $this->NewCropPrescription->find('all', array(
						'fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
						 		 'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type,
						 		 'NewCropPrescription.taking_medication' => 1)));				
				$this->set('numeratorVal',$medicationReportedInteractionNumeratorVal);
			}else if($report=='medicationEligibleSent'){
				$mapatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
								'Patient.admission_type' => $patient_type)));
				$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
						'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
				$medicationEligibleSentNumeratorVal = $this->NewCropPrescription->find('all', array(
						'fields' => array('Patient.lookup_name','Patient.patient_id'), 
						'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
								 'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type,
								 'NewCropPrescription.FinalDestinationType' =>array(3,4))));				
				$this->set('numeratorVal',$medicationEligibleSentNumeratorVal);
			}else if($report=='medicationOtcAssesedInteraction'){
				$mapatientlist =  $this->Patient->find('list', array('fields' => array('Patient.id','Patient.id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider,
								'Patient.admission_type' => $patient_type)));
				$this->NewCropPrescription->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>false,
						'conditions' => array('Patient.id=NewCropPrescription.patient_uniqueid')))));
				$medicationOtcAssesedInteractionNumeratorVal = $this->NewCropPrescription->find('all', array(
						'fields' => array('Patient.lookup_name','Patient.patient_id'),
						 'conditions' => array('Patient.is_deleted' => 0, 'Patient.doctor_id' => $searchProvider, 
						 		'NewCropPrescription.patient_uniqueid' => $mapatientlist, 'Patient.admission_type' => $patient_type,
						 		'NewCropPrescription.taking_medication' => 1,'NewCropPrescription.DeaLegendDescription' => 'OTC')));
				$this->set('numeratorVal',$medicationOtcAssesedInteractionNumeratorVal);
			}else if($report=='ccda'){
				$this->XmlNote->bindModel(array('belongsTo'=>array(
						'Patient'=>array('foreignKey'=>'patient_id'))),false);				
				$ccdaViewNumeratorVal=$this->XmlNote->find('all',array('fields'=>array('Patient.lookup_name','Patient.patient_id'),
						'conditions'=>array('DATE_FORMAT(XmlNote.created, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'XmlNote.is_viewed=1')
				));
				$ccdaDownloadNumeratorVal=$this->XmlNote->find('all',array('fields'=>array('Patient.lookup_name','Patient.patient_id'),
						'conditions'=>array('DATE_FORMAT(XmlNote.created, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'XmlNote.is_viewed=1','XmlNote.is_downloaded=1')
				));
				
				$this->TransmittedCcda->bindModel(array('belongsTo' => array('Patient' => array('foreignKey'=>'patient_id'))));
				$ccdaTransmittedNumeratorVal = $this->TransmittedCcda->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(TransmittedCcda.referral_date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'TransmittedCcda.location_id' => $this->Session->read('locationid'), 'Patient.doctor_id' => $searchProvider,
								'Patient.admission_type' => $patient_type)));				
				$ccdaNumerator=array_merge($ccdaViewNumeratorVal,$ccdaDownloadNumeratorVal);
				$ccdaNumerator=array_merge($ccdaNumerator,$ccdaTransmittedNumeratorVal);
				$this->set('numeratorVal',$ccdaNumerator);
			}else if($report=='searchableDob'){
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
				$searchableDobNumeratorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
								'Person.dob NOT'=>NULL),'group'=>array('Patient.id')));
				$this->set('numeratorVal',$searchableDobNumeratorVal);
			}else if($report=='searchableSex'){
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
				$searchableSexNumeratorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
								'Person.sex NOT'=>NULL),'group'=>array('Patient.id')));
				$this->set('numeratorVal',$searchableSexNumeratorVal);
			}else if($report=='searchableRace'){
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
				$searchableRaceNumeratorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
								'Person.race NOT'=>NULL),'group'=>array('Patient.id')));
				$this->set('numeratorVal',$searchableRaceNumeratorVal);
			}else if($report=='searchableEthnicity'){
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
				$searchableEthnicityNumeratorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
								'Person.ethnicity NOT'=>NULL),'group'=>array('Patient.id')));
				$this->set('numeratorVal',$searchableEthnicityNumeratorVal);
			}else if($report=='searchableTelePrimary'){
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
				$searchableTelePrimaryNumeratorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
								'Person.person_local_number NOT'=>NULL),'group'=>array('Patient.id')));
				$this->set('numeratorVal',$searchableTelePrimaryNumeratorVal);
			}else if($report=='searchableAlterTele'){
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
				$searchableAlterTeleNumeratorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
								'Person.person_local_number_second NOT'=>NULL),'group'=>array('Patient.id')));
				$this->set('numeratorVal',$searchableAlterTeleNumeratorVal);
			}else if($report=='searchableEmail'){
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
				$searchableEmailNumeratorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
								'Person.person_email_address NOT'=>NULL),'group'=>array('Patient.patient_id')));
				$this->set('numeratorVal',$searchableEmailNumeratorVal);
			}else if($report=='searchablePreferredLanguage'){
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
				$searchablePreferredLanguageNumeratorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
								'Person.preferred_language NOT'=>NULL),'group'=>array('Patient.id')));
				$this->set('numeratorVal',$searchablePreferredLanguageNumeratorVal);
			}else if($report=='searchableOccupation'){
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
				$searchableOccupationNumeratorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
								'Person.occupation NOT'=>NULL),'group'=>array('Patient.id')));
				$this->set('numeratorVal',$searchableOccupationNumeratorVal);
			}else if($report=='searchablePrimaryCareGiver'){
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
				$searchablePrimaryCareGiverNumeratorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
								'Patient.relation'=>'CGV'),'group'=>array('Patient.id')));
				$this->set('numeratorVal',$searchablePrimaryCareGiverNumeratorVal);
			}else if($report=='searchableAdvanceDirective'){
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
				$searchableAdvanceDirectiveNumeratorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
								'Person.adv_directive NOT'=>NULL),'group'=>array('Patient.id')));
				$this->set('numeratorVal',$searchableAdvanceDirectiveNumeratorVal);
			}else if($report=='searchableInsuranceInfo'){
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
				$searchableInsuranceInfoNumeratorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
								'Person.insurance_company_id NOT'=>NULL),'group'=>array('Patient.id')));
				$this->set('numeratorVal',$searchableInsuranceInfoNumeratorVal);
			}else if($report=='searchablePhysician'){
				$this->Patient->bindModel(array('belongsTo' => array('Person' => array('foreignKey'=>'person_id'))),false);
				$searchablePhysicianNumeratorVal =  $this->Patient->find('all', array('fields' => array('Patient.lookup_name','Patient.patient_id'),
						'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'), 'Patient.is_deleted' => 0,
								'Patient.doctor_id' => $searchProvider, 'Patient.admission_type' => $patient_type,
								'Patient.doctor_id NOT'=>NULL),'group'=>array('Patient.id')));
				$this->set('numeratorVal',$searchablePhysicianNumeratorVal);
			}
				
			$this->set('date',$bothTime);
			$providerName=$this->DoctorProfile->find('first',array('fields'=>array('doctor_name'),'conditions'=>array('DoctorProfile.user_id'=>$searchProvider)));
			$this->set('provider',$providerName);
			if($type=='excel'){
				$this->layout = false ;
				$this->render('pcmh_patients_list_excel') ;
			}
			
		}
		
		public function doctor_wise_report($type=NULL,$doctor_id=NULL){
			$this->uses=array('User','Appointment');
			$this->layout='advance';
			$doctors=$this->User->getAllDoctors();
			$this->Appointment->bindModel(array(
					'belongsTo'=>array(
							'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id =Appointment.patient_id')),
							'User'=>array('foreignKey'=>false,'conditions'=>array('Appointment.doctor_id=User.id')))),false);			
			if($this->params->query){
				if(!empty($this->params->query['dateFrom'])){
					$Fromdate = str_replace('/', '-', $this->params->query['dateFrom']);
					$dateFrom=date('Y-m-d',strtotime($Fromdate));				
			}
			else{
				$dateFrom=date('Y-m-d');				
			}
			if(!empty($this->params->query['dateTo'])){
				$Todate = str_replace('/', '-', $this->params->query['dateTo']);
				$dateTo=date('Y-m-d ',strtotime($Todate));
				
			}else{
				$dateTo=date('Y-m-d');
			}
			$bothTime = array($dateFrom, $dateTo);
			$this->set('date',$bothTime);
			//Specific doctor's Patient List
			if(!empty($doctor_id)){
				$this->paginate = array(
						'limit' => Configure::read('number_of_rows'),
						'order' => array('Appointment.date' => 'ASC'),
						'fields'=> array('Patient.lookup_name','Appointment.status','Appointment.date','User.first_name','User.last_name'),
						'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Appointment.status NOT'=>array('Scheduled','Pending','No-Show','Cancelled'),
								'Appointment.doctor_id' =>$doctor_id,
								'Appointment.location_id'=>$this->Session->read('locationid'),'Appointment.is_deleted'=>'0'));
				$this->set('doctor_id',$doctor_id);
				$this->set('patientList',$this->paginate('Appointment'));
				if($type=='excel'&&!empty($doctor_id)){
					$this->layout = false ;
					$this->render('physician_wise_list_excel') ;
				}else{
					$this->render('pie_chart_patientlist');
				}
			}
			
				foreach($doctors as $key=>$value){					
					$patientCount=$this->Appointment->find('all',array('fields'=>array('COUNT(Appointment.id) as count'),
							'conditions'=>array('DATE_FORMAT(Appointment.date,"%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
									'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
									'Appointment.doctor_id' =>$key,'Appointment.status NOT'=>array('Scheduled','Pending','No-Show','Cancelled')
							)));
					$pieData[$key]['name']=$value;
					$pieData[$key]['count']=$patientCount[0][0]['count'];
					$doctorArray[$key]=$key;
				
				}
				$totalPatient=$this->Appointment->find('all',array('fields'=>array('COUNT(Appointment.id) as count'),
						'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
								'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
								'Appointment.doctor_id'=>$doctorArray,'Appointment.status NOT'=>array('Scheduled','Pending','No-Show','Cancelled')
						)));
				
			}else{
				//Specific doctor's Patient List
				if(!empty($doctor_id)){
					$this->paginate = array(
							'limit' => Configure::read('number_of_rows'),
							'order' => array('Appointment.date' => 'ASC'),
							'fields'=> array('Patient.lookup_name','Appointment.status','Appointment.date','User.first_name','User.last_name'),
							'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y") LIKE 2014',
									'Appointment.status NOT'=>array('Scheduled','Pending','No-Show','Cancelled'),
									'Appointment.doctor_id' =>$doctor_id,
									'Appointment.location_id'=>$this->Session->read('locationid'),'Appointment.is_deleted'=>'0'));
					$this->set('doctor_id',$doctor_id);
					$this->set('patientList',$this->paginate('Appointment'));				
					if($type=='excel'&&!empty($doctor_id)){
						$this->layout = false ;
						$this->render('physician_wise_list_excel') ;
					}else{
						$this->render('pie_chart_patientlist');
					}
				
						
				}
			foreach($doctors as $key=>$value){
				
				$patientCount=$this->Appointment->find('all',array('fields'=>array('COUNT(Appointment.id) as count'),
						'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y") LIKE 2014',
								'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
								'Appointment.doctor_id' =>$key,'Appointment.status NOT'=>array('Scheduled','Pending','No-Show','Cancelled')							
						)));
				$pieData[$key]['name']=$value;
				$pieData[$key]['count']=$patientCount[0][0]['count'];
				$doctorArray[$key]=$key;
				
			}
			$totalPatient=$this->Appointment->find('all',array('fields'=>array('COUNT(Appointment.id) as count'),
					'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y") LIKE '=>date('Y'),
							'Appointment.location_id'=>$this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
							'Appointment.doctor_id'=>$doctorArray,'Appointment.status NOT'=>array('Scheduled','Pending','No-Show','Cancelled')
					)));
			}
			
			$this->set('pieData',$pieData);
			$this->set('totalPatient',$totalPatient);			
			if($type=='excel' && empty($doctor_id)){
				$this->layout = false ;
				$this->render('doctorwise_report_excel') ;
			}

			
			
		}

	/*******Bof reminder report*********/	
		
		public function patient_reminder($flag=null,$type=null){
			$this->uses=array('Patient','Appointment','Person','ReminderPatientList','State');
			$this->layout='advance';
			$this->Person->bindModel(array(
					'belongsTo' => array('Patient' => array('foreignKey'=>false, conditions => array('Person.id=Patient.person_id')),
							'ReminderPatientList' => array('foreignKey'=>false, conditions => array('Person.id=ReminderPatientList.person_id',"ReminderPatientList.reminder_sent_for"=>$this->params->query[flag])),
							
			)),false);
			
			$newState=$this->State->find('list',array('fields'=>array('id','name'),'conditions'=>array('State.country_id'=>'2')));
			$this->set('newState',$newState);
			/*debug($this->params->query);
			exit;*/
			if(!empty($this->params->query)){
				
				if(!empty($this->params->query['first_name'])){
					$search_key['Person.first_name like '] = trim($this->params->query['first_name'])."%" ;
				}
				
				if(!empty($this->params->query['last_name'])){
					$search_key['Person.last_name like '] = trim($this->params->query['last_name'])."%" ;
				}
				
				if(!empty($this->params->query['gender'])){
					$search_key['Patient.sex like '] = trim($this->params->query['gender'])."%" ;
				}
				
				if(!empty($this->params->query['zip_code'])){
					$search_key['Person.pin_code like '] = trim($this->params->query['zip_code'])."%" ;
				}
				
				if(!empty($this->params->query['city'])){
					$search_key['Person.city like '] = trim($this->params->query['city'])."%" ;
				}
				
				if(!empty($this->params->query['state'])){
					$search_key['Person.state like '] = trim($this->params->query['state'])."%" ;
				}
				
				if(!empty($this->params->query['agefrom'])){
					$bothTime = array($this->params->query['agefrom'], $this->params->query['ageto']);
					$search_key['Patient.age BETWEEN ? AND ? '] =$bothTime;
				}
				
				if($this->params->query['flag']=='cancer'){
					$bothage = array('21','65');
					$search_key['Patient.age BETWEEN ? AND ? '] =$bothage;
					$search_key['Patient.sex like '] =trim('female')."%" ;
				}
				
				if($this->params->query['flag']=='smoking'){
					$search_key['Patient.age >=']  = 18 ;
				}
				
				if($this->params->query['flag']=='highbp'){
					$search_key['Patient.age >=']  = 18 ;
				}
				
				//debug($search_key);exit;
				$conditions=array($search_key);
				$conditions = array_filter($conditions);

				if(!empty($this->params->query['type']) && $this->params->query['type']=='excel'){
					
					$data=$this->Person->find('all',array('fields'=> array('Person.first_name','Person.last_name','Patient.sex','Patient.age','Person.dob','Person.id','Person.person_local_number','ReminderPatientList.id',
									'ReminderPatientList.reminder_followup_taken','ReminderPatientList.phone_reminder_script'),'conditions'=>$conditions,'group'=>array('Person.id'),
							'order' => array('Person.id' => 'DESC')));
					$this->set('data',$data);
					$this->render('patient_reminder_excel','');
				}else{
					
					$this->paginate = array(
							'limit' => Configure::read('number_of_rows'),
							'group' => array('Person.id'),
							'order' => array('Person.id' => 'DESC'),
							'fields'=> array('Person.first_name','Person.last_name','Patient.sex','Patient.age','Person.dob','Person.id','Person.person_local_number','ReminderPatientList.id',
									'ReminderPatientList.reminder_followup_taken','ReminderPatientList.phone_reminder_script'),
							'conditions'=>$conditions);
					$data = $this->paginate('Person');
					$this->set('data',$data);

				
				}
				
			}
			
		}

		function savePatientReminder($personId=null,$flag=null)
		{
			$this->autoRender = false ;
			$this->layout='ajax';
			$this->uses = array('ReminderPatientList');
			$reminderData="";
			$currentDate= date('Y-m-d h:i:s');
			//$reminder=array('person_id'=>$personId,'reminder_sent_for'=>$flag,'reminder_sent_date'=>$currentDate,'reminder_followup_taken'=>'No');
			
			$remRec=$this->ReminderPatientList->find('first',array('conditions'=>array('ReminderPatientList.person_id'=>$personId,'ReminderPatientList.reminder_sent_for'=>$flag)));
			
			if(empty($remRec)){
				$patients = $this->ReminderPatientList->save($reminder);
			}else{
				$updateArray=array('ReminderPatientList.person_id'=>"'$personId'",'ReminderPatientList.reminder_sent_for'=>"'$flag'",
						'ReminderPatientList.reminder_sent_date'=>"'$currentDate'",'ReminderPatientList.reminder_followup_taken'=>"'No'");
				$res = $this->ReminderPatientList->updateAll($updateArray,array('ReminderPatientList.person_id'=>$personId,'ReminderPatientList.reminder_sent_for'=>$flag));
			}
			
		}
		function savePatientReminderFollowup($personId=null,$flag=null)
		{
			$this->autoRender = false ;
			$this->layout='ajax';
			$this->uses = array('ReminderPatientList');
			$reminderData="";
			$currentDate= date('Y-m-d h:i:s');
			$updateArray=array('ReminderPatientList.reminder_followup_taken'=>"'Yes'");
			$res = $this->ReminderPatientList->updateAll($updateArray,array('ReminderPatientList.person_id'=>$personId,'ReminderPatientList.reminder_sent_for'=>$flag));
			
		}
		
		function savePatientScript($personId=null,$flag=null,$comment=null)
		{
			$this->autoRender = false ;
			$this->layout='ajax';
			$this->uses = array('ReminderPatientList');
			$reminderData="";
			$currentDate= date('Y-m-d h:i:s');
			$reminder=array('person_id'=>$personId,'reminder_sent_for'=>$flag,'reminder_sent_date'=>$currentDate,'reminder_followup_taken'=>'No','phone_reminder_script'=>$comment);
			
			$remScript=$this->ReminderPatientList->find('first',array('conditions'=>array('ReminderPatientList.person_id'=>$personId,'ReminderPatientList.reminder_sent_for'=>$flag)));
			//debug($remScript);exit;
			if(empty($remScript)){
				$patients = $this->ReminderPatientList->save($reminder);
			}else{
				$updateArray=array('ReminderPatientList.phone_reminder_script'=>"'$comment'");
				$res = $this->ReminderPatientList->updateAll($updateArray,array('ReminderPatientList.person_id'=>$personId,'ReminderPatientList.reminder_sent_for'=>$flag));
			}
			
		
		}
		
		
		/***********Eof reminder report*************/
		
		
		
		
		
		public function patient_not_visited(){
			$this->uses=array('DoctorProfile','Appointment','Patient','Person');
			$this->set('doctorlist', $this->DoctorProfile->getDoctors());
			
			if($this->params->query) {
				if($this->params->query['provider'] !=''){
					$searchProvider = $this->params->query['provider'];
					$this->set('provider',$searchProvider);
				}
				if($this->params->query['stage_type'] !=''){
					$stage_type = $this->params->query['stage_type'];
					$this->set('stage_type',$stage_type);
				}
					
				$patient_type = 'OPD';
					
				if(/*$this->request->data['startdate'] !="" && */ $this->params->query['duration'] !="") {
					$expStartDate = explode("/", $this->params->query['startdate']);
					//$startDate = $expStartDate[2]."-".$expStartDate[0]."-".$expStartDate[1];
					$startDate=date('Y-m-d');
					$addDays = $this->params->query['duration'];
					$endDate = date("Y-m-d", strtotime("-$addDays days", strtotime($startDate)));
					$bothTime = array($endDate,$startDate );
					$this->set('startDate',$startDate);
					$this->set('duration',$addDays);
			
				}
				/*if($this->request->data['year'] !="" && $this->request->data['duration'] !="") {
					$expTwoDate = explode("_", $this->request->data['duration']);
					$startDate = $this->request->data['year']."-".$expTwoDate[0];
					$endDate = $this->request->data['year']."-".$expTwoDate[1];
					$bothTime = array($startDate, $endDate);
			
				}*/
				$this->Patient->unbindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));
				$this->Patient->bindModel(array('belongsTo'=>array(
						'Appointment'=>array('foreignKey'=>false,'conditions'=>array('Appointment.patient_id=Patient.id')),
						'Person'=>array('foreignKey'=>'person_id'))),false);
				
				$patientList=$this->Patient->find('all',array('fields'=>array('Patient.person_id','Appointment.id'),
						'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") NOT BETWEEN ? AND ? ' =>$bothTime,
								'Patient.doctor_id'=>$searchProvider,'Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_deleted=0' ),'order'=>('Appointment.date ASC')));
				foreach($patientList as $list){
					//$patient[$list['Patient']['person_id']]=$list['Patient']['person_id'];
					$patient[$list['Appointment']['id']]=$list['Appointment']['id'];
				}
				$this->Patient->unbindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));
				$this->paginate = array('limit' => Configure::read('number_of_rows'),
						'fields' => array('Patient.lookup_name','Appointment.purpose','Person.dob','Appointment.date'),
						'conditions' =>array('Appointment.id'=>$patient));
				$this->set('patientList',$this->paginate('Patient'));
				if($this->params->query['report_type']=='excel'){
					$patientList = $this->Patient->find('all',array(
							'fields' => array('Patient.lookup_name','Appointment.purpose','Person.dob','Patient.form_received_on'),
							'conditions' =>array('Patient.person_id'=>$patient)));
					$this->set('patientList',$patientList);
					$this->layout=false;
					$this->render('no_visit_excel_report');
				}
			}
		
		}
		
		public function unusual_reports($report=NULL,$type=null){
			$this->uses=array('NewCropPrescription','LaboratoryTestOrder','RadiologyTestOrder','Patient');
			$this->set('report',$report);
			if($this->params->query){
				if(!empty($this->params->query['dateFrom'])){					
					$dateFrom=date('Y-m-d',strtotime($this->params->query['dateFrom']));					
				}
				else{					
					$dateFrom=date('Y-m-d');					
				}
				if(!empty($this->params->query['dateTo'])){
					
					$dateTo=date('Y-m-d ',strtotime($this->params->query['dateTo']));					
			
				}else{
					
					$dateTo=date('Y-m-d');
					
				}
				$bothTime = array($dateFrom, $dateTo);
			if($report=='prescriptions'){
				$this->NewCropPrescription->bindModel(array(
						'belongsTo'=>array(
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id=NewCropPrescription.patient_uniqueid')))),false);
				
				$this->paginate = array(
						'limit' => Configure::read('number_of_rows'),
						'fields'=> array('Patient.patient_id','Patient.lookup_name'),
						'conditions'=>array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d")  BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_deleted'=>'0'),
						'group'=>array('NewCropPrescription.patient_uniqueid having COUNT(NewCropPrescription.patient_uniqueid)>='.Configure::read('x_number')));
				
				/*$patientList=$this->NewCropPrescription->find('all',array('fields'=>array('Patient.patient_id','Patient.lookup_name'),
						'conditions'=>array('DATE_FORMAT(NewCropPrescription.date_of_prescription, "%Y-%m-%d")  BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_deleted'=>'0'),'group'=>array('NewCropPrescription.patient_uniqueid having COUNT(NewCropPrescription.patient_uniqueid)>='.Configure::read('x_number'))));*/
				$patientList=$this->paginate('NewCropPrescription')	;			
				
			}else if($report=='lab'){
				$this->LaboratoryTestOrder->bindModel(array(
						'belongsTo'=>array(
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id=LaboratoryTestOrder.patient_id')))),false);
				$this->paginate = array(
						'limit' => Configure::read('number_of_rows'),
						'fields'=> array('Patient.patient_id','Patient.lookup_name'),
						'conditions'=>array('DATE_FORMAT(LaboratoryTestOrder.lab_order_date, "%Y-%m-%d")  BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_deleted'=>'0'),
						'group'=>array('LaboratoryTestOrder.patient_id having COUNT(LaboratoryTestOrder.patient_id)>='.Configure::read('x_number')));
				
				
				/*$patientList=$this->LaboratoryTestOrder->find('all',array('fields'=>array('Patient.patient_id','Patient.lookup_name'),
						'conditions'=>array('DATE_FORMAT(LaboratoryTestOrder.lab_order_date, "%Y-%m-%d")  BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_deleted'=>'0'),
						'group'=>array('LaboratoryTestOrder.patient_id having COUNT(LaboratoryTestOrder.patient_id)>='.Configure::read('x_number'))));*/
				
				$patientList=$this->paginate('LaboratoryTestOrder')	;
			}else if($report=='rad'){
				$this->RadiologyTestOrder->bindModel(array(
						'belongsTo'=>array(
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id=RadiologyTestOrder.patient_id')))),false);
				$radioCondition = array('DATE_FORMAT(RadiologyTestOrder.radiology_order_date, "%Y-%m-%d")  BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_deleted'=>'0') ;
				$radioGroup = array('RadiologyTestOrder.patient_id having COUNT(RadiologyTestOrder.patient_id)>='.Configure::read('x_number'));
				$this->paginate = array(
						'limit' => Configure::read('number_of_rows'),
						'fields'=> array('Patient.patient_id','Patient.lookup_name'),
						'conditions'=>$radioCondition,
								'group'=>$radioGroup);
				
				/*$patientList=$this->RadiologyTestOrder->find('all',array('fields'=>array('Patient.patient_id','Patient.lookup_name'),
						'conditions'=>array('DATE_FORMAT(RadiologyTestOrder.radiology_order_date, "%Y-%m-%d")  BETWEEN ? AND ? ' =>$bothTime,
								'Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_deleted'=>'0'),
								'group'=>array('RadiologyTestOrder.patient_id having COUNT(RadiologyTestOrder.patient_id)>='.Configure::read('x_number'))));*/
				 
				//$count=$this->RadiologyTestOrder->paginateCount($radioCondition,0,array(),$radioGroup);//overwrite paginator count
				$patientList=$this->paginate('RadiologyTestOrder');
			}
			
			$this->set('patientList',$patientList);	
			if($type=='excel'){
				$this->layout=false;
					$this->render('unusual_reports_excel');
			}
			
		}
		
	}

	
	
	public function resident_overdue_report($flag=null,$type=null){
		$this->uses=array('Patient','Appointment','Person','ReminderPatientList','Note','User');
			$this->layout='advance';
			$this->Patient->unBindModel(array(
					'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
			$this->Patient->bindModel(array(
					'belongsTo' => array('Note' => array('foreignKey'=>false, conditions => array('Patient.id=Note.patient_id')),
							'Appointment' => array('foreignKey'=>false, conditions => array('Patient.id=Appointment.patient_id')),
							'Person' => array('foreignKey'=>false, conditions => array('Person.id=Appointment.person_id')),
							'Note' => array('foreignKey'=>false, conditions => array('Patient.id=Note.patient_id')),
							
							
							
			)),false);
			
					
			
			if(!empty($this->params->query)){
				$default=array('Note.resident_notes !='=>'');
				if(!empty($this->params->query['assigned_name'])){
					$search_key['Note.resident_user_id'] = trim($this->params->query['assigned_name']);
				}
				
				if(!empty($this->params->query['from_date'])){
					$dateFrom=date('Y-m-d',strtotime($this->params->query['from_date']));
					$dateFrom=$dateFrom/*.' 00:00:00'*/;
				}
				
				if(!empty($this->params->query['to_date'])){
					$dateTo=date('Y-m-d',strtotime($this->params->query['to_date']));
					$dateTo=$dateTo/*.' 23:59:59'*/;
					
				}
				
				if(!empty($this->params->query['from_date'])){	
				   $bothTime = array($dateFrom, $dateTo);
				   $bothTime=array('Note.resident_assigned_date BETWEEN ? AND ?'=> $bothTime);
				}
				
			
				$conditions=array($search_key,$default,$bothTime);
				$conditions = array_filter($conditions);
								
				$this->paginate = array(
						'limit' => Configure::read('number_of_rows'),
						'fields'=> array('Patient.id','Patient.lookup_name','Appointment.arrived_time','Appointment.elapsed_time','Appointment.date','Patient.sex','Person.dob','Person.first_name','Person.last_name','Note.signed_date','Note.resident_notes','Note.resident_assigned_date'),
						'conditions'=>$conditions);
			
			}
			else
			{
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'fields'=> array('Patient.id','Patient.lookup_name','Appointment.arrived_time','Appointment.elapsed_time','Appointment.date','Patient.sex','Person.dob','Person.first_name','Person.last_name','Note.signed_date','Note.resident_notes','Note.resident_assigned_date'),
					'conditions'=>array('Note.resident_notes !='=>''));
			}
			$residentOverdueData = $this->paginate('Patient');
			$this->set("residentOverdueData",$residentOverdueData);
			
			$Residentlist=$this->User->getResidentDoctor();
			$this->set('Residentlist',$Residentlist);
	}
	public function resident_overall_milestone($flag=null,$type=null){
		$this->uses=array('Patient','Appointment','Person','ReminderPatientList');
		$this->layout='advance';
			
	}
	
	

	
	public function readmission_report($type=NULL){
		$this->uses=array('Patient','Person');
		$startDate=date('Y-m-d');
		$endDate = date("Y-m-d", strtotime("-30 days", strtotime($startDate)));
		$bothTime = array($endDate,$startDate );
		$this->set('startDate',$startDate);
		$this->Patient->bindModel(array('belongsTo'=>array(
				'Person'=>array('foreignKey'=>'person_id'))
				),false);
		
		$this->paginate = array('limit' => Configure::read('number_of_rows'),
				'fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob'),
				'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d")  BETWEEN ? AND ? ' =>$bothTime,
						'Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_deleted'=>'0'),
				'group'=>array('Patient.person_id having COUNT(Patient.person_id)>=2'));
		
	$this->set('patientList',$this->paginate('Patient'));
	if($type=='excel'){
		$this->layout=false;
		$patientList=$this->Patient->find('all',array('fields' => array('Patient.patient_id','Patient.lookup_name','Person.dob'),
				'conditions' => array('DATE_FORMAT(Patient.form_received_on, "%Y-%m-%d")  BETWEEN ? AND ? ' =>$bothTime,
						'Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_deleted'=>'0'),
				'group'=>array('Patient.person_id having COUNT(Patient.person_id)>=2')));
		$this->set('patientList',$patientList);
		$this->render('readmission_report_excel');
	}
	}
	
	
}

?>