<?php
/**
 * OptAppointmentsController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class NewOptAppointmentsController extends AppController {

	public $name = 'NewOptAppointments';
	public $uses = array('NewOptAppointment');
	public $helpers = array('Html','Form', 'Js','General');
	public $components = array('RequestHandler','Email','DateFormat', 'ScheduleTime','General');

	/**
	 * appointment indexing
	 *
	*/ 
	public function index() {
		$this->loadModel("Opt");
		$this->set('opts',$this->Opt->find('list', array('conditions' => array('Opt.is_deleted' => 0, 'Opt.location_id' => $this->Session->read("locationid"),'order'=>'name ASC'))));

	}

	/**
	 * get all OT table listing by xmlhttprequest
	 *
	 */

	public function getOptTableList() {
		$this->loadModel("OptTable");
		$this->set('opttables',$this->OptTable->find('list', array('conditions' => array('OptTable.is_deleted' => 0, 'OptTable.opt_id' => $this->params->query['opt_id']),'order'=>'name ASC')));
		$this->layout = false;
		$this->render('/OptAppointments/ajaxgetopttables');
	}

   	public function manage_records(){
		$this->layout = 'ajax';
// 		$this->loadModel('Staff');
// 		$this->loadModel('CompanyDetails');

// 		if ($this->request->is('post')) {
// 			$action = $this->request->data['action'];
// 			if ($action == 'staff') {
// 				if (!empty($this->request->data['delete_id'])) {
// 					$this->Staff->delete($this->request->data['delete_id']);
// 				} else {
// 					$this->Staff->save($this->request->data);
// 				}
// 			} elseif ($action == 'CompanyDetails') {
// 				if (!empty($this->request->data['delete_id'])) {
// 					$this->Company->delete($this->request->data['delete_id']);
// 				} else {
// 					$this->Company->save($this->request->data);
// 				}
// 			}
// 		}

// 		$staffList = $this->Staff->find('all');
// 		$companyList = $this->CompanyDetails->find('all');
// 		$this->set(compact('staffList', 'companyList'));
	}
	
	/**
	 * get all Surgery Subcategory listing by xmlhttprequest
	 *
	 */

	public function getSurgerySubcategoryList() {
		$this->loadModel("SurgerySubcategory");
		$surgerysubcategories = $this->SurgerySubcategory->find('list', array('conditions' => array('SurgerySubcategory.is_deleted' => 0, 'SurgerySubcategory.surgery_category_id' => $this->params->query['surgery_category']),'order'=>'name ASC'));
		$this->set('surgerysubcategories', $surgerysubcategories);
		$this->layout = false;
		if(count($surgerysubcategories) > 0) {
			$this->render('/OptAppointments/ajaxgetsurgerysubcategories');
		} else {
			echo "norecord";
			exit;
		}
	}

	/**
	 * get all Anesthesia Subcategory listing by xmlhttprequest
	 *
	 */


	/**
	 * get all Surgery listing by xmlhttprequest
	 *
	 */

	public function getSurgeryList() {
		$this->loadModel("Surgery");
		$surgery = $this->Surgery->find('list', array('conditions' => array('Surgery.is_deleted' => 0,
				'Surgery.surgery_category_id' => $this->params->query['surgery_category'],
				'Surgery.location_id' => $this->Session->read('locationid')
		),'order'=>'name ASC'));
		$this->set('surgery', $surgery);
		$this->layout = false;
		if(count($surgery) > 0) {
			$this->render('/OptAppointments/ajaxgetsurgery');
		} else {
			$this->render('/OptAppointments/ajaxgetsurgery');
		}
	}

	/**
	 * get all Anesthesia listing by xmlhttprequest
	 *
	 */

	public function getAnesthesiaList() {
		$this->loadModel("Anesthesia");
		$anesthesia = $this->Anesthesia->find('list', array('conditions' => array('Anesthesia.is_deleted' => 0,
				'Anesthesia.anesthesia_category_id' => $this->params->query['anesthesia_category'],
				'Anesthesia.location_id' => $this->Session->read('locationid')
		)));
		$this->set('anesthesia', $anesthesia);
		$this->layout = false;
		if(count($anesthesia) > 0) {
			$this->render('/OptAppointments/ajaxgetanesthesia');
		} else {
			$this->render('/OptAppointments/ajaxgetanesthesia');
		}
	}
	/**
	 * get  Surgery Subcategory for edit by xmlhttprequest
	 *
	 */

	public function getSurgerySubcategory() {
		$this->loadModel("SurgerySubcategory");
		$this->loadModel("OptAppointment");
		$this->set('surgerysubcategories',$this->SurgerySubcategory->find('list', array('conditions' => array('SurgerySubcategory.is_deleted' => 0, 'SurgerySubcategory.surgery_id' => $this->params->query['surgery_id']),'order'=>'name ASC')));
		$this->set('surgerysubcategoryid',$this->OptAppointment->find('first', array('conditions' => array('OptAppointment.id' => $this->params->query['id']), 'fields' => array('OptAppointment.surgery_subcategory_id'))));
		$this->layout = 'ajax';
		$this->render('/OptAppointments/ajaxgetsurgerysubcategory');
	}


	/**
	 * get  Anesthesia Subcategory for edit by xmlhttprequest
	 *
	 */



	/**
	 * ot schedule event
	 *
	 */
	public function optevent($opt_id=null, $opt_table_id=null, $showCalendarDay=1) {
		$this->uses = array('DoctorProfile', 'Department', 'Patient', 'Surgery', 'OptTable', 'User','Anesthesia');
		$this->set('title_for_layout', __('Add OPT Schedule', true));
		$opt_id = (isset($this->params['data']['opt_id'])) ? $this->params['data']['opt_id'] : $opt_id;
		$opt_table_id = (isset($this->params['data']['opt_table_id'])) ? $this->params['data']['opt_table_id'] : $opt_table_id;
		if(!($opt_id) && !($opt_table_id)) {
			$this->Session->setFlash(__('Please select OT', true));
			$this->redirect(array("action" => "index"));
		}
		if(!($opt_table_id)) {
			$this->Session->setFlash(__('Please select OT Table', true));
			$this->redirect(array("action" => "index"));
		}


		if(($opt_id) && ($opt_table_id)) {
			$allEvent = $this->OptAppointment->find("all", array('conditions' => array('OptAppointment.opt_table_id'=> $opt_table_id, 'OptAppointment.opt_id'=> $opt_id,'OptAppointment.is_deleted'=> 0, 'OptAppointment.schedule_date BETWEEN ? AND ?' => array(date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-50, date("y"))), date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+50, date("y"))))), 'fields' => array('OptAppointment.*', 'Opt.id', 'OptTable.id', 'DoctorProfile.present_event_color', 'DoctorProfile.past_event_color', 'DoctorProfile.future_event_color', 'DoctorProfile.doctor_name', 'Patient.admission_id', 'Patient.lookup_name')));
			$getAllDoctorList = $this->User->getDoctorList($this->Session->read('locationid'));
			$doctorlist = $this->DoctorProfile->find("list", array('conditions' => array('DoctorProfile.user_id'=> $getAllDoctorList, 'Department.name NOT LIKE'=> "%Anaesthesia%"),'order'=>'doctor_name ASC','fields' => array('DoctorProfile.user_id','DoctorProfile.doctor_name'), 'recursive' => 0,'order'=>'doctor_name ASC'));

			$departmentlist = $this->DoctorProfile->find("list", array('conditions' => array('DoctorProfile.user_id'=> $getAllDoctorList, 'Department.name LIKE'=> "%Anaesthesia%"),'fields' => array('DoctorProfile.user_id','DoctorProfile.doctor_name'), 'recursive' => 0));
			//$surgerylist = $this->Surgery->find("list", array('conditions' => array('Surgery.is_deleted '=> 0, 'Surgery.location_id'=> $this->Session->read('locationid')), 'recursive' => -1));
			$optData = $this->OptTable->find("first", array('conditions' => array('OptTable.id'=> $opt_table_id, 'Opt.is_deleted'=> 0),'order'=>'name ASC'));

			$this->set('allEvent', $allEvent);
			$this->set('showCalendarDay', $showCalendarDay);
			$this->set('doctorlist', $doctorlist);
			$this->set('departmentlist', $departmentlist);
			//$this->set('surgerylist', $surgerylist);
			$this->set('optData', $optData);
		}

	}

	/**
	 * autosearch admission id
	 *
	 */
	public function autoSearchAdmissionId() {
		$this->loadModel("Patient");
		$patientArray = $this->Patient->find('list', array('fields'=> array('id', 'admission_id'), 'conditions'=> array('Patient.is_deleted' => 0, 'Patient.location_id'=> $this->Session->read('locationid'))));

		foreach ($patientArray as $key=>$value) {
			echo "$value|$key\n";
		}
		exit; //dont remove this
	}


	/**
	 * OPT schedule event save by xmlhttprequest
	 *
	 */
	public function saveOptEvent() {
		//debug('hello');exit;
		$this->uses = array('OptAppointment', 'Patient', 'Surgery','Anesthesia');

		if($this->params['isAjax']) {
			if(!($this->params->query['admissionid'])) {
				$this->Session->setFlash(__('Please enter admission id'));
				exit;
			}
			if(!($this->params->query['doctor_id'])) {
				$this->Session->setFlash(__('Please select surgeon'));
				exit;
			}
			if(!($this->params->query['service_group'])) {
				$this->Session->setFlash(__('Please select service group'));
				exit;
			}
			if(!($this->params->query['surgery_id'])) {
				$this->Session->setFlash(__('Please select surgery'));
				exit;
			}



			$countAdmissionId = $this->Patient->find('count', array('conditions' => array('Patient.admission_id' => $this->params->query['admissionid'])));
			if($countAdmissionId > 0) {
				$getPatientId = $this->Patient->find('first', array('conditions' => array('Patient.admission_id' => $this->params->query['admissionid']), 'fields' => array('Patient.id')));
				// block past date entry //
				if(date("Y-m-d", strtotime($this->params->query['scheduledate'])) >= date("Y-m-d")) {
					$this->ScheduleTime = $this->Components->load('ScheduleTime');
					$checkSchedulePlan = $this->ScheduleTime->checkDoctorScheduleForOT($this->params->query);
					if($checkSchedulePlan['surgeon'] > 0 && $checkSchedulePlan['anaesthesia'] > 0 && $checkSchedulePlan['optappointment'] > 0) {
						$getTariffListId = $this->Surgery->read('tariff_list_id', $this->params->query['surgery_id']) ;
							
						$this->request->data['OptAppointment']['patient_id'] = $getPatientId['Patient']['id'];
						$this->request->data['OptAppointment']['location_id'] = $this->Session->read("locationid");
						$this->request->data['OptAppointment']['opt_id'] = $this->params->query['opt_id'];
						$this->request->data['OptAppointment']['opt_table_id'] = $this->params->query['opt_table_id'];
						$this->request->data['OptAppointment']['schedule_date'] = $this->params->query['scheduledate'];
						$this->request->data['OptAppointment']['start_time'] = $this->params->query['schedule_starttime'];
						$this->request->data['OptAppointment']['end_time'] = $this->params->query['schedule_endtime'];
						$this->request->data['OptAppointment']['diagnosis'] = $this->params->query['diagnosis'];
						$this->request->data['OptAppointment']['surgery_id'] = $this->params->query['surgery_id'];
							
						$this->request->data['OptAppointment']['service_group'] = $this->params->query['service_group'];
						$this->request->data['OptAppointment']['tariff_list_id'] = $getTariffListId['Surgery']['tariff_list_id'];
						$this->request->data['OptAppointment']['tariff_list_id'] = $getAnesthesiaTariffListId['Anesthesia']['tariff_list_id'];

						$this->request->data['OptAppointment']['surgery_subcategory_id'] = $this->params->query['surgery_subcategory_id'];

						$this->request->data['OptAppointment']['operation_type'] = $this->params->query['operation_type'];
						$this->request->data['OptAppointment']['doctor_id'] = $this->params->query['doctor_id'];
						$this->request->data['OptAppointment']['department_id'] = $this->params->query['department_id'];
						$this->request->data['OptAppointment']['anaesthesia'] = $this->params->query['anaesthesia'];
						$this->request->data['OptAppointment']['procedure_complete'] = $this->params->query['procedurecomplete'];
						$this->request->data['OptAppointment']['ot_in_time'] = $this->params->query['otintime'];
						$this->request->data['OptAppointment']['incision_time'] = $this->params->query['incisiontime'];
						$this->request->data['OptAppointment']['skin_closure'] = $this->params->query['skinclosure'];
						$this->request->data['OptAppointment']['out_time'] = $this->params->query['outtime'];
						$this->request->data['OptAppointment']['description'] = $this->params->query['description'];
						$this->request->data['OptAppointment']['created_by'] = $this->Auth->user('id');
						$this->request->data['OptAppointment']['create_time'] = date("Y-m-d H:i:s");



						if($this->OptAppointment->save($this->request->data)) {

							$this->Session->setFlash(__('OT Schedule time has been saved', true));
						} else {
							$this->Session->setFlash(__('Please fill all fields for saving OT schedule time.', true));
						}
						exit;
					} else {
						if($checkSchedulePlan['optappointment'] == 0)
							$this->Session->setFlash(__('You can not select this time.', true));
						if($checkSchedulePlan['surgeon'] == 0 && !($checkSchedulePlan['anaesthesia'] == 0))
							$this->Session->setFlash(__('Surgeon is not available for selected time.', true));
						if($checkSchedulePlan['anaesthesia'] == 0 && !($checkSchedulePlan['surgeon'] == 0))
							$this->Session->setFlash(__('Anaesthetist is not available for selected time.', true));
						if($checkSchedulePlan['surgeon'] == 0 && $checkSchedulePlan['anaesthesia'] == 0)
							$this->Session->setFlash(__('Both surgeon & anaesthetist is not available for selected time.', true));
						exit;
					}
				} else {
					$this->Session->setFlash(__('You can not be save past OT schedule time', true));
					exit;
				}
			} else {
				$this->Session->setFlash(__('Your admission id is wrong so please try again.', true));
				exit;
			}

		}

	}

	/**
	 *  update OT schedule event by xmlhttprequest
	 *
	 */
	public function updateOptScheduleEvent() {
		$this->uses = array('OptAppointment', 'Patient', 'Surgery','Anesthesia');

		if($this->params['isAjax']) {
			if(!($this->params->query['admissionid'])) {
				$this->Session->setFlash(__('Please enter admission id', true));
				exit;
			}
			if(!($this->params->query['doctor_id'])) {
				$this->Session->setFlash(__('Please select surgeon', true));
				exit;
			}
			if(!($this->params->query['service_group'])) {
				$this->Session->setFlash(__('Please select service group'));
				exit;
			}
			if(!($this->params->query['surgery_id'])) {
				$this->Session->setFlash(__('Please select surgery'));
				exit;
			}

			$countAdmissionId = $this->Patient->find('count', array('conditions' => array('Patient.admission_id' => $this->params->query['admissionid'])));
			if($countAdmissionId > 0) {
				$getPatientId = $this->Patient->find('first', array('conditions' => array('Patient.admission_id' => $this->params->query['admissionid']), 'fields' => array('Patient.id')));
				if(date("Y-m-d", strtotime($this->params->query['scheduledate'])) >= date("Y-m-d")) {
					$this->ScheduleTime = $this->Components->load('ScheduleTime');
					$checkSchedulePlan = $this->ScheduleTime->checkDoctorScheduleForOT($this->params->query);
					if($checkSchedulePlan['surgeon'] > 0 && $checkSchedulePlan['anaesthesia'] > 0 && $checkSchedulePlan['optappointment'] > 0) {
						$getTariffListId = $this->Surgery->read('tariff_list_id', $this->params->query['surgery_id']) ;
							
						$this->OptAppointment->id = $this->params->query['id'];
						$this->request->data['OptAppointment']['id'] = $this->params->query['id'];
						$this->request->data['OptAppointment']['patient_id'] = $getPatientId['Patient']['id'];
						$this->request->data['OptAppointment']['location_id'] = $this->Session->read("locationid");
						$this->request->data['OptAppointment']['opt_id'] = $this->params->query['opt_id'];
						$this->request->data['OptAppointment']['opt_table_id'] = $this->params->query['opt_table_id'];
						$this->request->data['OptAppointment']['schedule_date'] = $this->params->query['scheduledate'];
						$this->request->data['OptAppointment']['start_time'] = $this->params->query['schedule_starttime'];
						$this->request->data['OptAppointment']['end_time'] = $this->params->query['schedule_endtime'];
						$this->request->data['OptAppointment']['diagnosis'] = $this->params->query['diagnosis'];
						$this->request->data['OptAppointment']['surgery_id'] = $this->params->query['surgery_id'];
						$this->request->data['OptAppointment']['service_group'] = $this->params->query['service_group'];
						$this->request->data['OptAppointment']['tariff_list_id'] = $getTariffListId['Surgery']['tariff_list_id'];
						$this->request->data['OptAppointment']['tariff_list_id'] = $getAnesthesiaTariffListId['Anesthesia']['tariff_list_id'];
						$this->request->data['OptAppointment']['surgery_subcategory_id'] = $this->params->query['surgery_subcategory_id'];
							
						$this->request->data['OptAppointment']['operation_type'] = $this->params->query['operation_type'];
						$this->request->data['OptAppointment']['doctor_id'] = $this->params->query['doctor_id'];
						$this->request->data['OptAppointment']['department_id'] = $this->params->query['department_id'];
						$this->request->data['OptAppointment']['anaesthesia'] = $this->params->query['anaesthesia'];
						$this->request->data['OptAppointment']['procedure_complete'] = $this->params->query['procedurecomplete'];
						$this->request->data['OptAppointment']['ot_in_time'] = $this->params->query['otintime'];
						$this->request->data['OptAppointment']['incision_time'] = $this->params->query['incisiontime'];
						$this->request->data['OptAppointment']['skin_closure'] = $this->params->query['skinclosure'];
						$this->request->data['OptAppointment']['out_time'] = $this->params->query['outtime'];
						$this->request->data['OptAppointment']['description'] = $this->params->query['description'];
						$this->request->data['OptAppointment']['modified_by'] = $this->Auth->user('id');
						$this->request->data['OptAppointment']['modify_time'] = date("Y-m-d H:i:s");

						if($this->OptAppointment->save($this->request->data)) {
							$this->Session->setFlash(__('OT Schedule time has been updated', true));
						} else {
							$this->Session->setFlash(__('Please fill all fields for saving OT schedule time.', true));
						}
						exit;
					} else {
						if($checkSchedulePlan['optappointment'] == 0)
							$this->Session->setFlash(__('You can not select this time.', true));
						if($checkSchedulePlan['surgeon'] == 0 && !($checkSchedulePlan['anaesthesia'] == 0))
							$this->Session->setFlash(__('Surgeon is not available for selected time.', true));
						if($checkSchedulePlan['anaesthesia'] == 0 && !($checkSchedulePlan['surgeon'] == 0))
							$this->Session->setFlash(__('Anaesthetist is not available for selected time.', true));
						if($checkSchedulePlan['surgeon'] == 0 && $checkSchedulePlan['anaesthesia'] == 0)
							$this->Session->setFlash(__('Both surgeon & anaesthetist is not available for selected time.', true));
						exit;
					}
				} else {
					$this->Session->setFlash(__('You can not be save past OT schedule time', true));
					exit;
				}
			} else {
				$this->Session->setFlash(__('Your admission id is wrong so please try again.', true));
				exit;
			}

		}

	}

	/**
	 * delete OPT schedule event by xmlhttprequest
	 *
	 */
	public function deleteOptScheduleEvent() {
		$this->loadModel("OptAppointment");
		if($this->params['isAjax']) {
			$this->OptAppointment->id = $this->params->query['id'];
			$this->request->data['OptAppointment']['id'] = $this->params->query['id'];
			$this->request->data['OptAppointment']['is_deleted'] = 1;
			$this->request->data['OptAppointment']['modified_by'] = $this->Auth->user('id');
			$this->request->data['OptAppointment']['modify_time '] = date("Y-m-d H:i:s");
			$this->OptAppointment->save($this->data);
			$this->Session->setFlash(__('OT Schedule time deleted', true));
			exit;
		}

	}



	/**
	 * ot pre operative checklist
	 *
	 */
	public function add_ot_pre_operative_checklist($patientid=null) {
		//$this->layout = "ajax";
		$this->uses = array('PreOperativeChecklist', 'Surgery','Anesthesia');
		$this->patient_info($patientid);
		if(isset($this->params['named']['otpcid'])) {
			$this->set('title_for_layout', __('OT Operative Check List', true));
			$patientPOCheckListDetails = $this->PreOperativeChecklist->find('first', array('conditions' => array('PreOperativeChecklist.id' => $this->params['named']['otpcid'], 'PreOperativeChecklist.location_id' => $this->Session->read('locationid'), 'PreOperativeChecklist.is_deleted' => 0)));
			$this->set('patientPOCheckListDetails', isset($patientPOCheckListDetails)?$patientPOCheckListDetails:'');
		}
		$this->Surgery->bindModel(array('hasOne' => array('OptAppointment' =>array('foreignKey' => 'surgery_id'))));

		$this->set('surgeries', $this->Surgery->find('list', array('conditions' => array('Surgery.location_id' => $this->Session->read('locationid'), 'Surgery.is_deleted' => 0, 'OptAppointment.patient_id' => $patientid), 'recursive' => 1)));

	}


	/**
	 * ot pre operative checklist print
	 *
	 */
	public function print_ot_pre_operative_checklist($id=null) {
		$this->loadModel('PreOperativeChecklist');
		$this->PreOperativeChecklist->bindModel(array('belongsTo' => array('Patient' =>array('foreignKey' => 'patient_id'),
				'Surgery' =>array('foreignKey' => false, 'conditions' => array('Surgery.id=PreOperativeChecklist.surgery_id')),
				'Person' =>array('foreignKey' => false, 'conditions' => array('Person.id = Patient.person_id')),
				'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
		)));
		$patientPOCheckListDetails = $this->PreOperativeChecklist->find('first', array('conditions' => array('PreOperativeChecklist.id' => $id, 'PreOperativeChecklist.location_id' => $this->Session->read('locationid'), 'PreOperativeChecklist.is_deleted' => 0) , 'recursive' => 1));
		$this->set('patientPOCheckListDetails', $patientPOCheckListDetails);
		$this->layout = 'print_with_header';
	}

	/**
	 * save pre operative checklist
	 *
	 */
	public function savePreOperativeChecklist() {
		//	debug($this->request->data);
		//exit;
		$this->uses = array("PreOperativeChecklist");
		if ($this->request->is('post') || $this->request->is('put')) {
			if(!empty($this->request->data["PreOperativeChecklist"]['pre_date'])){
				$last_split_date_time =  $this->request->data['PreOperativeChecklist']['pre_date'];
				$this->request->data["PreOperativeChecklist"]['pre_date'] = $this->DateFormat->formatDate2STD($last_split_date_time,Configure::read('date_format'));
			}
			// for update functionality //
			if($this->request->data['PreOperativeChecklist']['id']) {
				$this->PreOperativeChecklist->id = $this->request->data['PreOperativeChecklist']['id'];
			}
			$this->request->data["PreOperativeChecklist"]["create_time"] = date("Y-m-d H:i:s");
			$this->request->data["PreOperativeChecklist"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["PreOperativeChecklist"]["created_by"] = $this->Session->read('userid');
			$this->request->data["PreOperativeChecklist"]["modified_by"] = $this->Session->read('userid');
			$this->request->data["PreOperativeChecklist"]["location_id"] = $this->Session->read('locationid');
			$this->PreOperativeChecklist->save($this->request->data);
			$this->Session->setFlash(__('Pre Operative Check List Saved.', true));
		}

		$this->redirect(array("action" => "ot_pre_operative_checklist", $this->request->data["PreOperativeChecklist"]["patient_id"]));
		exit;
	}

	/**
	 * add anaesthesia consent form
	 *
	 */
	public function add_anaesthesia_consent($patientid=null) {
		//$this->layout = "ajax";
		$this->uses = array('AnaesthesiaConsentForm', 'User', 'Surgery','Anesthesia');
		$this->set('title_for_layout', __('Anaesthesia Consent Form', true));
		$this->patient_info($patientid);
		$patientConsentDetails = $this->AnaesthesiaConsentForm->find('first', array('conditions' => array('AnaesthesiaConsentForm.id' => $this->params['named']['anaid'], 'AnaesthesiaConsentForm.location_id' => $this->Session->read('locationid'), 'AnaesthesiaConsentForm.is_deleted' => 0)));
		$this->set('patientConsentDetails', isset($patientConsentDetails)?$patientConsentDetails:'');
		$this->set('anaesthesialist',$this->User->getAnaesthesistAndNone(true));
		$this->Surgery->bindModel(array('hasOne' => array('OptAppointment' =>array('foreignKey' => 'surgery_id'))));
		$this->set('surgeries', $this->Surgery->find('list', array('conditions' => array('Surgery.location_id' => $this->Session->read('locationid'), 'Surgery.is_deleted' => 0, 'OptAppointment.patient_id' => $patientid), 'recursive' => 1)));
	}

	/**
	 * anaesthesia consent page for print
	 *
	 */
	public function print_anaesthesia_consent($id=null) {
        $this->loadModel('AnaesthesiaConsentForm');
        $this->AnaesthesiaConsentForm->bindModel(array('belongsTo' => array('Patient' =>array('foreignKey' => 'patient_id'),
                                                                            'Person' =>array('foreignKey' => false, 'conditions' => array('Person.id=  Patient.person_id')),
                                                                            'Surgery' =>array('foreignKey' => false, 'conditions' => array('Surgery.id=  AnaesthesiaConsentForm.surgery_id')),
                                                                            'User' =>array('foreignKey' => false, 'conditions' => array('User.id=  AnaesthesiaConsentForm.anaesthesiologist_name')),
                                                                            'Initial' =>array('foreignKey' => false, 'conditions' => array('Initial.id=  User.initial_id')),
                                                                            'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
                                                                            'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
        )));
        $patientConsentDetails = $this->AnaesthesiaConsentForm->find('first', array('conditions' => array('AnaesthesiaConsentForm.id' => $id, 'AnaesthesiaConsentForm.location_id' => $this->Session->read('locationid'), 'AnaesthesiaConsentForm.is_deleted' => 0) , 'recursive' => 1));
        $this->set('patientConsentDetails', $patientConsentDetails);
        $this->layout = 'print_with_header';
    }

	/**
	 * save anaesthesia consent form
	 *
	 */
	public function saveAnaesthesiaConsent() {
		$this->uses = array("AnaesthesiaConsentForm");
		if(!empty($this->request->data["AnaesthesiaConsentForm"]['anaesthesia_time']) || !empty($this->request->data["AnaesthesiaConsentForm"]['relationship_to_date'])){
			$last_split_date_time = explode(" ",$this->request->data['AnaesthesiaConsentForm']['anaesthesia_time']);
			$this->request->data["AnaesthesiaConsentForm"]['anaesthesia_time'] = $this->DateFormat->formatDate2STD($this->request->data['AnaesthesiaConsentForm']['anaesthesia_time'],Configure::read('date_format')) ;
			$last_split_date_time = explode(" ",$this->request->data['AnaesthesiaConsentForm']['relationship_to_date']);
			$this->request->data["AnaesthesiaConsentForm"]['relationship_to_date'] = $this->DateFormat->formatDate2STD($this->request->data['AnaesthesiaConsentForm']['relationship_to_date'],Configure::read('date_format')) ;
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data["AnaesthesiaConsentForm"]["general_anaesthesia"] = isset($this->request->data["AnaesthesiaConsentForm"]["general_anaesthesia"])?$this->request->data["AnaesthesiaConsentForm"]["general_anaesthesia"]:0;
			$this->request->data["AnaesthesiaConsentForm"]["regional_anaesthesia"] = isset($this->request->data["AnaesthesiaConsentForm"]["regional_anaesthesia"])?$this->request->data["AnaesthesiaConsentForm"]["regional_anaesthesia"]:0;
			$this->request->data["AnaesthesiaConsentForm"]["nerve_block"] = isset($this->request->data["AnaesthesiaConsentForm"]["nerve_block"])?$this->request->data["AnaesthesiaConsentForm"]["nerve_block"]:0;
			$this->request->data["AnaesthesiaConsentForm"]["anaesthesia_procedure"] = isset($this->request->data["AnaesthesiaConsentForm"]["anaesthesia_procedure"])?$this->request->data["AnaesthesiaConsentForm"]["anaesthesia_procedure"]:0;
			$this->request->data["AnaesthesiaConsentForm"]["anaesthesia_risks"] = isset($this->request->data["AnaesthesiaConsentForm"]["anaesthesia_risks"])?$this->request->data["AnaesthesiaConsentForm"]["anaesthesia_risks"]:0;
			$this->request->data["AnaesthesiaConsentForm"]["anaesthesia_symptoms"] = isset($this->request->data["AnaesthesiaConsentForm"]["anaesthesia_symptoms"])?$this->request->data["AnaesthesiaConsentForm"]["anaesthesia_symptoms"]:0;
			$this->request->data["AnaesthesiaConsentForm"]["anaesthesia_suppliment"] = isset($this->request->data["AnaesthesiaConsentForm"]["anaesthesia_suppliment"])?$this->request->data["AnaesthesiaConsentForm"]["anaesthesia_suppliment"]:0;
			// update if anaesthesia id found //
			if($this->request->data["AnaesthesiaConsentForm"]['id']) {
				$this->AnaesthesiaConsentForm->id = $this->request->data["AnaesthesiaConsentForm"]['id'];
			}
			$this->request->data["AnaesthesiaConsentForm"]["create_time"] = date("Y-m-d H:i:s");
			$this->request->data["AnaesthesiaConsentForm"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["AnaesthesiaConsentForm"]["created_by"] = $this->Session->read('userid');
			$this->request->data["AnaesthesiaConsentForm"]["modified_by"] = $this->Session->read('userid');
			$this->request->data["AnaesthesiaConsentForm"]["location_id"] = $this->Session->read('locationid');
			//print_r($this->request->data);exit;
			if($this->AnaesthesiaConsentForm->save($this->request->data)) {
				$this->Session->setFlash(__('Anaesthesia Consent Form Saved.', true));
			}
		}
		$this->redirect(array("action" => "anaesthesia_consent", $this->request->data["AnaesthesiaConsentForm"]['patient_id']));
		exit;
	}

	/**
	 * medical replacement slip form
	 *
	 */
	public function medical_replacement_slip() {
		$this->set('title_for_layout', __('Medical Replacement Slip  Form', true));
	}

	/**
	 * print medical replacement slip1 for surgical items
	 *
	 */
	public function print_medical_replacement_slip1($patientid=null) {
		$this->loadModel('MedicalRepSurgicalItem');
		$patientMRIDetails = $this->MedicalRepSurgicalItem->find('first', array('conditions' => array('MedicalRepSurgicalItem.patient_id' => $patientid, 'MedicalRepSurgicalItem.location_id' => $this->Session->read('locationid'), 'MedicalRepSurgicalItem.is_deleted' => 0)));
		$this->set('patientMRIDetails', $patientMRIDetails);
		$this->layout = false;
	}

	/**
	 * print medical replacement slip2 for antibiotics, injectables and sutures.
	 *
	 */
	public function print_medical_replacement_slip2($patientid=null) {
		$this->uses = array('MedicalRepAntibiotic', 'MedicalRepInjectable', 'MedicalRepSuture');
		// get details of antibiotics //
		$patientAntiDetails = $this->MedicalRepAntibiotic->find('first', array('conditions' => array('MedicalRepAntibiotic.patient_id' => $patientid, 'MedicalRepAntibiotic.location_id' => $this->Session->read('locationid'), 'MedicalRepAntibiotic.is_deleted' => 0)));
		$this->set('patientAntiDetails', $patientAntiDetails);
		// get details of injectables //
		$patientInjectDetails = $this->MedicalRepInjectable->find('first', array('conditions' => array('MedicalRepInjectable.patient_id' => $patientid, 'MedicalRepInjectable.location_id' => $this->Session->read('locationid'), 'MedicalRepInjectable.is_deleted' => 0)));
		$this->set('patientInjectDetails', $patientInjectDetails);
		// get details of sutures //
		$patientSutDetails = $this->MedicalRepSuture->find('first', array('conditions' => array('MedicalRepSuture.patient_id' => $patientid, 'MedicalRepSuture.location_id' => $this->Session->read('locationid'), 'MedicalRepSuture.is_deleted' => 0)));
		$this->set('patientSutDetails', $patientSutDetails);
		$this->layout = false;
	}


	/**
	 * save medical replacement slip form
	 *
	 */
	public function saveMedicalReplacementSlip() {
		$this->uses = array("MedicalRepAntibiotic", "MedicalRepInjectable", "MedicalRepSurgicalItem", "MedicalRepSuture");
		if ($this->request->is('post') || $this->request->is('put')) {
			// save to medical_rep_antibiotics table //
			$this->request->data["MedicalRepAntibiotic"]["create_time"] = date("Y-m-d H:i:s");
			$this->request->data["MedicalRepAntibiotic"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["MedicalRepAntibiotic"]["created_by"] = $this->Session->read('userid');
			$this->request->data["MedicalRepAntibiotic"]["modified_by"] = $this->Session->read('userid');
			$this->request->data["MedicalRepAntibiotic"]["location_id"] = $this->Session->read('locationid');
			$this->MedicalRepAntibiotic->create();
			$this->MedicalRepAntibiotic->save($this->request->data["MedicalRepAntibiotic"]);
			// save to medical_rep_injectables table //
			$this->request->data["MedicalRepInjectable"]["create_time"] = date("Y-m-d H:i:s");
			$this->request->data["MedicalRepInjectable"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["MedicalRepInjectable"]["created_by"] = $this->Session->read('userid');
			$this->request->data["MedicalRepInjectable"]["modified_by"] = $this->Session->read('userid');
			$this->request->data["MedicalRepInjectable"]["location_id"] = $this->Session->read('locationid');
			$this->MedicalRepInjectable->create();
			$this->MedicalRepInjectable->save($this->request->data["MedicalRepInjectable"]);
			// save to medical_rep_surgical_items table //
			$this->request->data["MedicalRepSurgicalItem"]["create_time"] = date("Y-m-d H:i:s");
			$this->request->data["MedicalRepSurgicalItem"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["MedicalRepSurgicalItem"]["created_by"] = $this->Session->read('userid');
			$this->request->data["MedicalRepSurgicalItem"]["modified_by"] = $this->Session->read('userid');
			$this->request->data["MedicalRepSurgicalItem"]["location_id"] = $this->Session->read('locationid');
			$this->MedicalRepSurgicalItem->create();
			$this->MedicalRepSurgicalItem->save($this->request->data["MedicalRepSurgicalItem"]);
			// save to medical_rep_suture table //
			$this->request->data["MedicalRepSuture"]["create_time"] = date("Y-m-d H:i:s");
			$this->request->data["MedicalRepSuture"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["MedicalRepSuture"]["created_by"] = $this->Session->read('userid');
			$this->request->data["MedicalRepSuture"]["modified_by"] = $this->Session->read('userid');
			$this->request->data["MedicalRepSuture"]["location_id"] = $this->Session->read('locationid');
			$this->MedicalRepSuture->create();
			$this->MedicalRepSuture->save($this->request->data["MedicalRepSuture"]);
			$this->Session->setFlash(__('Medical Replacement Slip Form Saved.', true));
		}
		$this->redirect(array("action" => "medical_replacement_slip"));
		exit;
	}



	/**
	 * frontdesk ot appointment
	 *
	 */

	public function frontdesk_ot_appointment() {

	}

	/**
	 * patient search for mulitple forms submition
	 *
	 */
	function patient_search(){
		$this->uses = array("Patient", 'Person');
		$this->layout =false ;
		$this->set('title_for_layout', __('-Search Patient', true));
		$this->set('data','');

		$role = $this->Session->read('role');
		$this->Person->recursive = 0;
		$search_key['Person.is_deleted'] = 0;
		//select all inpatient's UID
		$this->uses  =array('Patient');
		$search_key = array("Patient.admission_type" => 'IPD', "Patient.is_discharge" => 0, "Patient.is_deleted" => 0, "Patient.location_id" => $this->Session->read('locationid'));

		$this->Person->bindModel(array('belongsTo' => array('Patient' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
				'Room' =>array('foreignKey' => false,'conditions'=>array('Room.id=Patient.room_id' )),
				'Bed' =>array('foreignKey' => false,'conditions'=>array('Bed.id=Patient.bed_id' )))),false);
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'Person.id' => 'Desc'
				),
				'group'=>'Person.id',
				'fields'=>array('Person.*', 'Patient.admission_id', 'Patient.patient_id', 'Patient.lookup_name', 'Patient.create_time', 'Room.bed_prefix', 'Bed.bedno')
		);

		if(!empty($this->request->query)){
			$search_ele = $this->request->query ;

			if(!empty($search_ele['lookup_name'])){
				$search_key['Patient.lookup_name like '] = "%".$search_ele['lookup_name']."%" ;
			}if(!empty($search_ele['patient_id'])){
				$search_key['Patient.patient_id like '] = "%".$search_ele['patient_id'] ;
			}if(!empty($search_ele['admission_id'])){
				$search_key['Patient.admission_id like '] = "%".$search_ele['admission_id'] ;
			}
			$data = $this->paginate('Person',$search_key);
			$this->set('data', $data);
			$this->data =array('Person'=>$search_ele);
		}else{
			$data = $this->paginate('Person',array($search_key));
			$this->set('data', $data);
		}

	}

	/**
	 * get all Surgery Category listing by xmlhttprequest
	 *
	 */

	public function getSurgeryCategoryList() {
		$this->loadModel("Surgery");
		$surgerycategories = $this->Surgery->find('list', array('conditions' => array('Surgery.is_deleted' => 0, 'Surgery.service_group' => $this->params->query['service_group'], 'Surgery.location_id' => $this->Session->read('locationid'))));
		$this->set('surgerycategories', $surgerycategories);
		$this->layout = false;
		if(count($surgerycategories) > 0) {
			$this->render('/OptAppointments/ajaxgetsurgerycategories');
		} else {
			echo "norecord";
			exit;
		}
	}
	/**
	 * get all Anesthesia Category listing by xmlhttprequest
	 *
	 */

	public function getAnesthesiaCategoryList() {
		$this->loadModel("Anesthesia");
		$anesthesiacategories = $this->Anesthesia->find('list', array('conditions' => array('Anesthesia.is_deleted' => 0, 'Anesthesia.service_group' => $this->params->query['service_group'], 'Anesthesia.location_id' => $this->Session->read('locationid'))));
		$this->set('anesthesiacategories', $anesthesiacategories);
		$this->layout = false;
		if(count($anesthesiacategories) > 0) {
			$this->render('/OptAppointments/ajaxgetanesthesiacategories');
		} else {
			echo "norecord";
			exit;
		}
	}


	/**
	 * ot appointment event
	 *
	 */
	public function otevent($patientid=null) {
		$this->layout = 'advance';
		$this->patient_info($patientid);
	}

	/**
	 * edit ot appointment event
	 *
	 */
	public function ot_editevent() { 
		$this->layout = 'ajax' ;
		$this->uses = array('SurgicalImplant','TariffList','ServiceCategory','Preferencecard','User','DoctorProfile', 'OptAppointment','Opt', 'OptTable', 'Surgery','SurgerySubcategory', 'Patient', 'SurgeryCategory','OptAppointmentDetail','ServiceBill');
		$this->set('opts',$this->Opt->find('list', array('conditions' => array('Opt.is_deleted' => 0, 'Opt.location_id' => $this->Session->read("locationid")))));
		$getAllDoctorList = $this->User->getDoctorList($this->Session->read('locationid'));
		// $this->set('doctorlist', $this->DoctorProfile->find("list", array('conditions' => array('DoctorProfile.user_id'=> $getAllDoctorList,
		//'Department.name NOT LIKE'=> "%Anaesthesia%"),'fields' => array('DoctorProfile.user_id','DoctorProfile.doctor_name'), 'recursive' => 0)));
		// $this->set('departmentlist', $this->DoctorProfile->find("list", array('conditions' => array('DoctorProfile.user_id'=> $getAllDoctorList,
		//'Department.name LIKE'=> "%Anaesthesia%"),'fields' => array('DoctorProfile.user_id','DoctorProfile.doctor_name'), 'recursive' => 0)));
		
		$this->set('doctorlist',$this->User->getSurgeonlist());		
		$this->set('departmentlist',$this->User->getAnaesthesistAndNone(true));
		$this->set('cardiologist',$this->User->getUserByDepartmentName('%Cardiology%'));
		//$this->set('implantServiceCatId',$this->ServiceCategory->getServiceGroupId('implantname',$this->Session->read('locationid')));	
		
		// get opt details //
		$this->OptAppointmentDetail->bindModel(array(
				'belongsTo'=>array(												
					'Surgery'=>array( 
						'foreignKey'=>false,
						'conditions'=>array('Surgery.id = OptAppointmentDetail.surgery_id')),
					'SurgicalImplant'=>array( 
						'foreignKey'=>false,
						'conditions'=>array('SurgicalImplant.id = OptAppointmentDetail.implant_id')),
					'DoctorProfile'=>array(
						'type'=>'inner',
						'foreignKey'=>false,
						'conditions'=>array('DoctorProfile.user_id = OptAppointmentDetail.doctor_id')),
					'ServiceBill'=>array(
						'foreignKey'=>false,
						'conditions'=>array('OptAppointmentDetail.service_bill_id = ServiceBill.id')),
		),));
		
		$getSurgeryDetails =  $this->OptAppointmentDetail->find('all', array(
				'fields'=>array('SurgicalImplant.name,OptAppointmentDetail.id, OptAppointmentDetail.opt_appointment_id, OptAppointmentDetail.implant_id, OptAppointmentDetail.implant_description, OptAppointmentDetail.surgery_id, OptAppointmentDetail.user_type, OptAppointmentDetail.doctor_id, OptAppointmentDetail.service_bill_id','Surgery.id','Surgery.name','Surgery.tariff_list_id','ServiceBill.id, ServiceBill.patient_id, ServiceBill.service_id, ServiceBill.amount, ServiceBill.paid_amount','DoctorProfile.user_id, DoctorProfile.doctor_name'),
				'conditions' => array('OptAppointmentDetail.opt_appointment_id' => $_GET["id"],'OptAppointmentDetail.is_deleted'=>0),
				'order'=>array('OptAppointmentDetail.id'=>"ASC")));
	
		foreach($getSurgeryDetails as $key => $data){
			$returnSurgeryArray[$data['OptAppointmentDetail']['surgery_id']][] = $data;
		} 
		$this->set('getSurgeryDetails',$returnSurgeryArray);
		
		$getOptDetails =  $this->OptAppointment->find('first', array('conditions' => array('OptAppointment.id' => $_GET["id"])));
		//BOF-Mahalaxmi For Surgical Implant
		$this->set('getTarrifData',$this->SurgicalImplant->findSurgicalImplantFirst($getOptDetails['OptAppointment']['implant_id']));
		//EOF-Mahalaxmi For Surgical Implant
		$this->set('optTables',$this->OptTable->find('list', array('conditions' => array('OptTable.is_deleted' => 0,
				'OptTable.opt_id' => $getOptDetails['OptAppointment']['opt_id']))));
		$this->set('surgery_categories',$this->SurgeryCategory->find('list', array('conditions' => array('SurgeryCategory.is_deleted' => 0,
				'SurgeryCategory.location_id' => $this->Session->read('locationid')),'order'=>'name ASC')));
		$this->set('surgery_subcategories',$this->SurgerySubcategory->find('list', array('conditions' => array('SurgeryCategory.is_deleted' => 0,
				'SurgerySubcategory.surgery_category_id' => $getOptDetails['OptAppointment']['surgery_category_id']),'order'=>'name ASC',
				'fields' => array('SurgerySubcategory.id', 'SurgerySubcategory.name'), 'recursive' => 1)));

		// if both category and subcategories are chosen then filter by both //
		if($getOptDetails['OptAppointment']['surgery_category_id'] && $getOptDetails['OptAppointment']['surgery_subcategory_id']) {
			$surgeriesArr = $this->Surgery->find('list', array('conditions' => array('Surgery.surgery_category_id' =>
					$getOptDetails['OptAppointment']['surgery_category_id'],'Surgery.is_deleted' => 0,
					'Surgery.location_id' => $this->Session->read('locationid')),'order'=>'name ASC')) ;

			$this->set('surgeries',$surgeriesArr);
		}


		// if both category and subcategory are chosen then filter by category to show only that subcategory//
		if($getOptDetails['OptAppointment']['surgery_category_id'])
			$this->set('surgeries',$this->Surgery->find('list', array('conditions' => array('Surgery.surgery_category_id' =>$getOptDetails['OptAppointment']['surgery_category_id'],
					'Surgery.is_deleted' => 0, 'Surgery.location_id' => $this->Session->read('locationid')),'order'=>'name ASC')));
		$prefCard = $this->Preferencecard->find('list',array('condititons'=>array('Preferencecard.procedure_id'=>$getOptDetails['OptAppointment']['surgery_id'],'Preferencecard.is_deleted'=>0),
				'fields'=>array('Preferencecard.card_title'), 'order'=>'card_title ASC'
		));
		$prefCard=array_filter($prefCard);		
		$this->set('prefCard',$prefCard);
		 
		//$sarr1 = explode(" ", $this->php2JsTime($this->mySql2PhpTime($this->DateFormat->formatDate2Local($getOptDetails['OptAppointment']['starttime'],'yyyy-mm-dd', true))));
		//$earr1 = explode(" ", $this->php2JsTime($this->mySql2PhpTime($this->DateFormat->formatDate2Local($getOptDetails['OptAppointment']['endtime'],'yyyy-mm-dd', true))));
		
		//$sarr1 = explode(" ", $this->php2JsTime($this->mySql2PhpTime($this->DateFormat->formatDate2Local($getOptDetails['OptAppointment']['starttime'],'yyyy-dd-mm', true))));
		//$earr1 = explode(" ", $this->php2JsTime($this->mySql2PhpTime($this->DateFormat->formatDate2Local($getOptDetails['OptAppointment']['endtime'],'yyyy-dd-mm', true))));
		
		$sarr1 = explode(" ", $this->DateFormat->formatDate2Local($getOptDetails['OptAppointment']['starttime'],Configure::read('date_format'),true));
		$earr1 = explode(" ", $this->DateFormat->formatDate2Local($getOptDetails['OptAppointment']['endtime'],Configure::read('date_format'),true));
		
		$this->set('sarr1', $sarr1);
		$this->set('earr1', $earr1);
		$this->set('getOptDetails', $getOptDetails);
		$servicegroup = $this->ServiceCategory->find('list',array('conditions'=>array('ServiceCategory.is_deleted'=>0,
				'ServiceCategory.location_id'=>$this->Session->read('locationid')),'order'=>'name ASC'));
		$this->set('servicegroup', $servicegroup);
		$anaesServiceGroup = $this->ServiceCategory->find('list',array('conditions'=>array('ServiceCategory.is_deleted'=>0,
				'ServiceCategory.location_id'=>$this->Session->read('locationid')),
				'order'=>'name ASC'));
		$this->set('anaesServiceGroup', $anaesServiceGroup);

		//service category id for aneasthesia -- Pooja
		$anesthesiaCategoryId=$this->ServiceCategory->find('first',array('fields'=>array('id'),
				'conditions'=>array('ServiceCategory.name LIKE'=>Configure::read('anesthesiaservices'),'ServiceCategory.location_id'=>$this->Session->read('locationid'))));

		$serviceData=$this->TariffList->find('list', array('fields'=> array('id', 'name'),
				'conditions' => array('TariffList.is_deleted' => 0, 'TariffList.service_category_id' =>$anesthesiaCategoryId['ServiceCategory']['id'],
						'TariffList.location_id' => $this->Session->read('locationid')),
				'order'=>array('TariffList.name'=>'ASC')));
		$this->set('services', $serviceData);//anesthesia service list
		$this->set('anesthesiaCategoryId',$anesthesiaCategoryId);

		$anaesthesiaService=$this->TariffList->find('list', array('conditions' => array(
				'TariffList.service_category_id' => $getOptDetails['OptAppointment']['anaesthesia_service_group_id'],
				'TariffList.is_deleted' => 0, 'TariffList.location_id' => $this->Session->read('locationid')),
				'order'=>'TariffList.name ASC'));
		$this->set('anaesthesiaService',$anaesthesiaService);
		$this->set('surgeon_services',$this->TariffList->find('list', array('conditions' => array('TariffList.is_deleted'=> 0,
				'TariffList.location_id'=>$this->Session->read('locationid'),'TariffList.service_category_id' =>$getOptDetails['OptAppointment']['surgen_service_group_id']),
				'order'=>'TariffList.name ASC')));
		$getPatientDetaiils = $this->Patient->find('first', array('conditions' => array('Patient.id' => $this->params->query['patient_id']),
				'fields' => array('Patient.admission_id','Patient.tariff_standard_id')));
 
		if(isset($getOptDetails['OptAppointment']['starttime'])){
			//$this->set('startDate',$this->DateFormat->formatDate2Local($getOptDetails['OptAppointment']['starttime'],Configure::read('date_format'),true));
		}
		
		if(isset($getOptDetails['OptAppointment']['endtime'])){
			//$this->set('endDate',$this->DateFormat->formatDate2Local($getOptDetails['OptAppointment']['endtime'],Configure::read('date_format'),true));
		}
		
		if(isset($this->params->query['start'])){
			$this->set('startDate', $this->params->query['start']);
		}
		if(isset($this->params->query['start'])){
			$this->set('endDate', $this->params->query['end']);
		}
		$this->set('getPatientDetaiils', $getPatientDetaiils);
		
		$otServiceId = $this->ServiceCategory->find('first',array('fields'=>array('id'),'conditions'=>array('ServiceCategory.name'=>Configure::read('otservices'),
				'ServiceCategory.location_id'=>$this->Session->read('locationid'))));
                $chargeType = ( $this->Session->read('hospitaltype') == 'NABH' ) ? 'nabh_charges' : 'non_nabh_charges';
		$this->TariffList->bindModel(array(
					'hasOne' => array(
							'TariffAmount' =>array( 'foreignKey'=>'tariff_list_id',
									'conditions'=>array('TariffList.is_deleted'=>0,'TariffAmount.tariff_standard_id'=>$getPatientDetaiils['Patient']['tariff_standard_id']))
					)));
		$otServiceData=$this->TariffList->find('all', array('fields'=> array('TariffList.id','TariffList.name',"TariffAmount.id","TariffAmount.".$chargeType),
				'conditions' => array('TariffList.is_deleted'=> 0,'TariffList.service_category_id' =>$otServiceId['ServiceCategory']['id'],'TariffList.service_category_id !=' =>'',
						'TariffList.location_id' => $this->Session->read('locationid')),
				'order'=>array('TariffList.name'=>'ASC')));
		$this->set('otServiceData',$otServiceData);
		//$this->layout = false;
	}

	/**
	 * getOtServiceCharges
	 * charges for ot services
	 * @author gaurav chauriya
	 */
	public function getOtServiceCharges(){
		$this->loadModel('Patient');
		$this->loadModel('ServiceCategory');
		$this->loadModel('TariffList');
		$getPatientDetaiils = $this->Patient->find('first', array('conditions' => array('Patient.id' => $this->params->query['patientId']),
				'fields' => array('Patient.tariff_standard_id')));

		$otServiceId = $this->ServiceCategory->find('first',array('fields'=>array('id'),'conditions'=>array('ServiceCategory.name'=>Configure::read('otservices'),
				'ServiceCategory.location_id'=>$this->Session->read('locationid'))));
                $chargeType = ( $this->Session->read('hospitaltype') == 'NABH' ) ? 'nabh_charges' : 'non_nabh_charges';
		$this->TariffList->bindModel(array(
					'hasOne' => array(
							'TariffAmount' =>array( 'foreignKey'=>'tariff_list_id',
									'conditions'=>array('TariffList.is_deleted'=>0,'TariffAmount.tariff_standard_id'=>$getPatientDetaiils['Patient']['tariff_standard_id']))
					)));
		$otServiceData = $this->TariffList->find('all', array('fields'=> array('TariffList.name',"TariffAmount.".$chargeType),
				'conditions' => array('TariffList.is_deleted'=> 0,'TariffList.service_category_id' =>$otServiceId['ServiceCategory']['id'],'TariffList.service_category_id !=' =>'',
						'TariffList.location_id' => $this->Session->read('locationid')),
				'order'=>array('TariffList.name'=>'ASC')));
		ob_clean();
		echo json_encode($otServiceData);
		exit;
	}
	
	/**
	 * getOtRuleList
	 * list of package as per surgery
	 * @author gaurav chauriya
	 */
	public function getOtRuleList(){
		$this->loadModel('PackageEstimate');
		$this->loadModel('ServiceCategory');
		$this->loadModel('TariffList');
		$this->layout = false;
		if($this->params->query['patientId']){
			$this->loadModel('Patient');
			$tariffStandardId = $this->Patient->find('first', array('conditions' => array('Patient.id' => $this->params->query['patientId']),
					'fields' => array('Patient.tariff_standard_id')));
			unset($this->params->query['patientId']);
			$this->params->query['tariff_standard_id'] = $tariffStandardId['Patient']['tariff_standard_id'];
		}
		$otCharges = $this->PackageEstimate->find('first',array('fields'=>array('PackageEstimate.id','PackageEstimate.surgeon_fees','PackageEstimate.anaesthesist_charge',
				'PackageEstimate.cardiologist','PackageEstimate.misc_breakup'),
				'conditions'=>array('PackageEstimate.location_id'=>$this->Session->read('locationid'),'PackageEstimate.is_deleted'=>0,$this->params->query)));
		$assistantAndOtherCharges = unserialize($otCharges['PackageEstimate']['misc_breakup']);
			$this->set('charges',array('surgeon'=>$otCharges['PackageEstimate']['surgeon_fees'],'anaesthesist'=>$otCharges['PackageEstimate']['anaesthesist_charge'],
                                'cardiologist'=>$otCharges['PackageEstimate']['cardiologist'],'assistantOne'=>$assistantAndOtherCharges['assistant_surgeon_one'],
				'assistantTwo'=>$assistantAndOtherCharges['assistant_surgeon_two'],'otAssistant'=>$assistantAndOtherCharges['ot_assistant'],
				'otCharge'=>$assistantAndOtherCharges['ot_charge']));
		$this->set('doctorlist',$this->User->getSurgeonlist());
		$this->set('departmentlist',$this->User->getAnaesthesistAndNone(true));
		$this->set('cardiologist',$this->User->getUserByDepartmentName('%Cardiology%'));
		$anesthesiaCategoryId=$this->ServiceCategory->find('first',array('fields'=>array('id'),
				'conditions'=>array('ServiceCategory.name LIKE'=>Configure::read('anesthesiaservices'),'ServiceCategory.location_id'=>$this->Session->read('locationid'))));
		
		$serviceData=$this->TariffList->find('list', array('fields'=> array('id', 'name'),
				'conditions' => array('TariffList.is_deleted' => 0, 'TariffList.service_category_id' =>$anesthesiaCategoryId['ServiceCategory']['id'],
						'TariffList.location_id' => $this->Session->read('locationid')),
				'order'=>array('TariffList.name'=>'ASC')));
		$this->set('services', $serviceData);//anesthesia service list
		$this->render('/OptAppointments/ajax_get_ot_rule');
	}
	
	/**
	 * internal url for calender event
	 *
	 */
	public function datafeed() {
		header('Content-type:text/javascript;charset=UTF-8');
		$method = $_GET["method"];
		$this->layout = false;
		switch ($method) {
			case "add":
				$ret = $this->addCalendar($_POST["CalendarStartTime"], $_POST["CalendarEndTime"], $_POST["CalendarTitle"], $_POST["IsAllDayEvent"]);
				break;
			case "list":
				$ret = $this->listCalendar($_POST["showdate"], $_POST["viewtype"]);
				break;
			case "update":
				// convert date format to dd-mm-yyyy format //
				$getStartTime = explode(" ", $_POST["CalendarStartTime"]);
				$expStartDate = explode("/", $getStartTime[0]);
				$startTime = $expStartDate[0]."-".$expStartDate[1]."-".$expStartDate[2]." ".$getStartTime[1];
				$getEndTime = explode(" ", $_POST["CalendarEndTime"]);
				$expEndDate = explode("/", $getEndTime[0]);
				$endTime = $expEndDate[0]."-".$expEndDate[1]."-".$expEndDate[2]." ".$getEndTime[1];
				$ret = $this->updateCalendar($_POST["calendarId"], $this->DateFormat->formatDate2STD($startTime,'mm/dd/yyyy'), $this->DateFormat->formatDate2STD($endTime, 'mm/dd/yyyy'));
				break;
			case "remove":
				$ret = $this->removeCalendar( $_POST["calendarId"]);
				break;
			case "adddetails":
				//$st = $_POST["stpartdate"] . " " . $_POST["stparttime"];
				//$et = $_POST["etpartdate"] . " " . $_POST["etparttime"]; 
				$stdst = $_POST["stpartdate"] . " " . $_POST["stparttime"];
				$stdet = $_POST["etpartdate"] . " " . $_POST["etparttime"];
				$st =  $this->DateFormat->formatDate2STD($stdst,'dd/mm/yyyy');
				$et =  $this->DateFormat->formatDate2STD($stdet,'dd/mm/yyyy');
				if(isset($_GET["id"])){
					$ret = $this->updateDetailedCalendar($_GET["id"], $st, $et,
							$_POST["subject"], isset($_POST["is_all_day_event"])?1:0, $_POST["note"],
							$_POST["colorvalue"], $_POST["timezone"], $_POST);
				}else{
					$ret = $this->addDetailedCalendar($st, $et,
							$_POST["subject"], isset($_POST["is_all_day_event"])?1:0, $_POST["note"],
							$_POST["colorvalue"], $_POST["timezone"],$_POST);
		  }
		  break;
		}
		echo json_encode($ret);   exit;

	}

	/**
	 * add new event calendar
	 *
	 */
	public function addCalendar($st, $et, $sub, $ade){
		$this->loadModel('OptAppointment');
		$ret = array();
		try{
			$scheduleDateStart = explode(" ", $this->php2MySqlTime($this->js2PhpTime($st)));
			$scheduleDateEnd = explode(" ", $this->php2MySqlTime($this->js2PhpTime($et)));
			$this->request->data['OptAppointment']['location_id'] = $this->Session->read('locationid');
			$this->request->data['OptAppointment']['schedule_date'] = $scheduleDateStart[0];
			$this->request->data['OptAppointment']['start_time'] = $scheduleDateStart[1];
			$this->request->data['OptAppointment']['end_time'] = $scheduleDateEnd[1];
			$this->request->data['OptAppointment']['created_by'] = $this->Session->read('userid');
			$this->request->data['OptAppointment']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['OptAppointment']['subject'] = $sub;
			$this->request->data['OptAppointment']['starttime'] = $this->php2MySqlTime($this->js2PhpTime($st));
			$this->request->data['OptAppointment']['endtime'] = $this->php2MySqlTime($this->js2PhpTime($et));
			$this->request->data['OptAppointment']['is_all_day_event'] = $ade;
			$checkSave = $this->OptAppointment->save($this->request->data);
			if(!$checkSave){
				$ret['IsSuccess'] = false;
				$ret['Msg'] = "Unable to add this OT Appointment";
			}else{
				$ret['IsSuccess'] = true;
				$ret['Msg'] = 'OT Appointment Added';
				$ret['Data'] = $this->OptAppointment->getLastInsertID();
			}
		}catch(Exception $e){
			$ret['IsSuccess'] = false;
			$ret['Msg'] = $e->getMessage();
		}
		return $ret;
	}

	/**
	 * add new event with details
	 *
	 */
	public function addDetailedCalendar($st, $et, $sub, $ade, $dscr, $color, $tz, $allvar){
		$this->uses = array('OptAppointment','Surgery', 'Patient','Anesthesia','ServiceBill','TariffList',
				'TariffAmount','TariffStandard','VoucherEntry','Account','User','ServiceCategory','Message','Configuration');
		$surgeryCatId=$this->ServiceCategory->getServiceGroupId('surgeryservices');
		$otherService=$this->ServiceCategory->getServiceGroupId('otherServices');
		$ret = array();
	 try{	 	
	 	if($st > $et) {
	 		$ret['IsSuccess'] = false;
	 		$ret['Msg'] = "Start Date & Time Should Not Be Greater Than End Time";
	 		echo "<script>jQuery('#gridcontainer').reload();</script>";
	 	} else { 
	 		// check overlap time 	 		
	 		$this->ScheduleTime = $this->Components->load('ScheduleTime');
	 		$checkOverlapTime = $this->ScheduleTime->checkOverlapForOT("", $st,$et, $allvar); 
	 		$otTime = $this->ScheduleTime->getInvalidateOtTime($allvar);/** checking Ot in out time*/
	 		if( $checkOverlapTime['optappointment'] == 2 || $checkOverlapTime['surgeon'] == 2 || 
	 			$checkOverlapTime['anaesthesia'] == 2 || $checkOverlapTime['surgeonoverlap'] == 2 || 
	 			$checkOverlapTime['anaesthesiaoverlap'] == 2 || $checkOverlapTime['surgeon_appointment'] == 2 || 
	 			$checkOverlapTime['anaesthesia_appointment'] == 2) {
	 			
	 			/*if($checkOverlapTime['optappointment'] == 2) {
	 				$ret['IsSuccess'] = false;
	 				$ret['Msg'] = "This OT Table Is Not Available For This Time Span";
	 			}
	 			if($checkOverlapTime['surgeon'] == 2) {
	 				$ret['IsSuccess'] = false;
	 				$ret['Msg'] = "Surgeon Is Not Available";
	 			}
	 			if($checkOverlapTime['anaesthesia'] == 2) {
	 				$ret['IsSuccess'] = false;
	 				$ret['Msg'] = "Surgeon Is Not Available";
	 			}
	 			if($checkOverlapTime['surgeon_appointment'] == 2 || $checkOverlapTime['surgeonoverlap'] == 2) {
	 				$ret['IsSuccess'] = false;
	 				$ret['Msg'] = "Doctor Is Already Set For Other OT Appointment";
	 			}
	 			
	 			if($checkOverlapTime['anaesthesiaoverlap'] == 2 || $checkOverlapTime['anaesthesia_appointment'] == 2) {
	 				$ret['IsSuccess'] = false;
	 				$ret['Msg'] = "Anaesthetist Is Already Set For Other OT Appointment";
	 			}*/

	 			$ret['IsSuccess'] = true;
 				$ret['Msg'] = 'Ot appointment has been scheduled'; 
	 			
	 		}  else if($otTime['isInvalidate']){
						$ret['IsSuccess'] = false;
						$ret['Msg'] = $otTime['Msg'];
			}else { 
				//$args = func_get_args();
	 			if($ade == 1) {
	 				//$end_time = date("Y-m-d H:i:s", strtotime($this->php2MySqlTime($this->js2PhpTime($et)) . ' + 23 hours 59 minutes'));
	 				$end_time = date("Y-m-d H:i:s", strtotime($et . ' + 23 hours 59 minutes'));
	 			} else {
	 				//$end_time = $this->php2MySqlTime($this->js2PhpTime($et));
	 				$end_time = $et;
	 			}
	 				
	 			//tariff List Private Id
	 			$privateID = $this->TariffStandard->getPrivateTariffID();//retrive private ID
	 			$raymondId=$this->TariffStandard->find('first',array('fields'=>array('id'),'conditions'=>array('name'=>'Raymonds','location_id'=>$this->Session->read('locationid'))));
                                $tpaId=$this->TariffStandard->find('list',array('fields'=>array('id','id'),'conditions'=>array('tariff_standard_type'=> 'TPA','is_deleted'=>'0','location_id'=>$this->Session->read('locationid'))));
	 			$this->set('privateId',$privateID);

	 			$getTariffStandardId = $this->Patient->getTariffStandardIDByPatient($allvar['patient_name_value']) ;	// patient_name_value is nothing but patient id
	 			$allSurgeryData = $allvar['data']['surgery'];
	 			
	 			$scheduleDateStart = explode(" ", $st);
	 			$scheduleDateEnd = explode(" ", $et); 
 
	 			$saveData = array();
	 			$saveData['patient_id'] = $allvar['patient_name_value'];
	 			$saveData['location_id'] = $this->Session->read('locationid');
	 			$saveData['subject'] = $sub;
	 			$saveData['schedule_date'] = $scheduleDateStart[0];
	 			$saveData['start_time'] = $scheduleDateStart[1];
	 			$saveData['end_time'] = $scheduleDateEnd[1];
	 			$saveData['starttime'] = $st;
	 			$saveData['endtime'] = $end_time;
	 			$saveData['is_all_day_event'] = $ade;
	 			$saveData['description'] = $dscr;
	 			$saveData['color'] = $color;
	 			$saveData['cost_to_hospital'] = $allvar['cost_to_hospital'];
	 			$saveData['opt_id'] = $allvar['opt_id'];
	 			$saveData['opt_table_id'] = $allvar['opt_table_id'];
	 			$saveData['diagnosis'] = $allvar['diagnosis'];
	 			$saveData['preferencecard_id'] = $allvar['preferencecard_id'];				
	 			$saveData['operation_type'] = $allvar['operation_type'];
	 			$saveData['anaesthesia_service_group_id'] = $allvar['anaesthesia_service_group_id'];
	 			$saveData['anaesthesia_tariff_list_id'] = $allvar['anaesthesia_tariff_list_id'];
	 			$saveData['procedurecomplete'] = $allvar['procedurecomplete']; 
	 			$saveData['batch_identifier'] = time();
	 			$saveData['internal_surgery_id'] = $allvar['internal_surgery_id'];
	 			
	 			if($allvar['ot_in_date']) {
	 				$allvar['ot_in_date'] =  $this->DateFormat->formatDate2STD($allvar['ot_in_date'],'mm/dd/yyyy');
	 				$allvar['ot_in_date'] = explode(" ", $allvar['ot_in_date']);
	 				$saveData['ot_in_date'] = trim($allvar['ot_in_date'][0])." ".trim($allvar['otintime']);
	 			}
	 			if($allvar['incision_date']) {
	 				$allvar['incision_date'] =  $this->DateFormat->formatDate2STD($allvar['incision_date'],'mm/dd/yyyy');
	 				$allvar['incision_date'] = explode(" ", $allvar['incision_date']);
	 				$saveData['incision_date'] = trim($allvar['incision_date'][0])." ".trim($allvar['incisiontime']);
	 			}
	 			if($allvar['skin_closure_date']) {
	 				$allvar['skin_closure_date'] =  $this->DateFormat->formatDate2STD($allvar['skin_closure_date'],'mm/dd/yyyy');
	 				$allvar['skin_closure_date'] = explode(" ", $allvar['skin_closure_date']);
	 				$saveData['skin_closure_date'] = trim($allvar['skin_closure_date'][0])." ".trim($allvar['skinclosure']);
	 			}
	 			if($allvar['out_date']) {
	 				$allvar['out_date'] =  $this->DateFormat->formatDate2STD($allvar['out_date'],'mm/dd/yyyy');
	 				$allvar['out_date'] = explode(" ", $allvar['out_date']);
	 				$saveData['out_date'] = trim($allvar['out_date'][0])." ".trim($allvar['outtime']);
	 			}
	 			$saveData['created_by'] = $this->Session->read('userid');
	 			$saveData['create_time'] =  date('Y-m-d H:i:s');
	 			$lastInsertedId = '';
	 			
	 			//debug($allSurgeryData); exit;
	 			//to save multiple surgery in multiple row of OPT Appointment table by swapnil on 12.09.2015
	 			foreach($allSurgeryData['surgery_id'] as $key => $data){ 
	 				$saveOptData = array();
	 				$saveOptData['OptAppointment'] = $saveData; 
	 				$getTariffListId = $this->Surgery->find('first', array('fields' => array('Surgery.tariff_list_id', 'Surgery.anaesthesia_tariff_list_id'), 'conditions' => array('Surgery.id' => $data))) ;
	 				$doctorID = $allSurgeryData['doctor_id'][$key][1];
	 				
	 				if(!empty($doctorID)){  
	 					$tariffListID = $allSurgeryData['surgen_tariff_list_id'][$key];
	 					$surCost[] = $surgeryCost = $this->TariffAmount->getTariffAmount($getTariffStandardId,$tariffListID); 
	 					//$saveOptData['OptAppointment']['surgery_cost'] = $surgeryCost ;
	 					$saveOptData['OptAppointment']['implant_id'] = $allSurgeryData['implant_id'][$key];
						$saveOptData['OptAppointment']['implant_description'] = $allSurgeryData['implant_description'][$key];
	 					$saveOptData['OptAppointment']['surgery_id'] = $data ;
	 					$saveOptData['OptAppointment']['tariff_list_id'] = $tariffListID;
		 				$saveOptData['OptAppointment']['doctor_id'] = $doctorID;
		 				$saveOptData['OptAppointment']['department_id'] = $allvar['department_id']; 
	 					if(($getTariffStandardId==$privateID) || ($getTariffStandardId==$raymondId['TariffStandard']['id'] || in_array($getTariffStandardId, $tpaId))){
	 						$otCost=($surgeryCost*30)/100; 
	 						//$saveOptData['OptAppointment']['ot_charges'] = $otCost ; 
	 					}
	 					$anaesthesiaCost=0;
	 					if(($getTariffStandardId==$privateID || $getTariffStandardId==$raymondId['TariffStandard']['id'] || in_array($getTariffStandardId, $tpaId)) && !empty($allvar['anaesthesia_tariff_list_id'])){
	 						$anaesthesiaCost=($surgeryCost*30)/100;
	 					}else if(!empty($allvar['anaesthesia_tariff_list_id'])){
	 						$anaesthesiaCost = $this->TariffAmount->getTariffAmount($getTariffStandardId,$allvar['anaesthesia_tariff_list_id']);
	 					}
	 					//$saveOptData['OptAppointment']['anaesthesia_cost'] = $anaesthesiaCost ; 
	 				}else{
	 					$saveOptData['OptAppointment']['surgen_service_group_id'] = NULL;
	 					$saveOptData['OptAppointment']['tariff_list_id'] = NULL;
	 				}
	 				$checkSave = $this->OptAppointment->saveAll($saveOptData);
	 				if($lastInsertedId == ''){
	 					$lastInsertedId = $this->OptAppointment->getLastInsertID();
	 				}
	 				$surgArr[$this->OptAppointment->getLastInsertID()] = $surgeryCost;
	 			}   
	 			//get id to update to max surgery cost
	 			$updateId = array_keys($surgArr, max($surgArr)); 
	 			$otCost = $anastCost = (max($surCost)*30)/100;
	 			$this->OptAppointment->updateAll(array('surgery_cost'=>$surgeryCost,'ot_charges'=>$otCost,'anaesthesia_cost'=>$anastCost),array('OptAppointment.id'=>$updateId));
	 			//$getTariffListId = $this->Surgery->find('first', array('fields' => array('Surgery.tariff_list_id', 'Surgery.anaesthesia_tariff_list_id'), 'conditions' => array('Surgery.id' => $allvar['surgery_id']))) ;
	 			//$getTariffStandardId = $this->Patient->getTariffStandardIDByPatient($allvar['patient_name_value']) ;	// patient_name_value is nothing but patient id
				 
	 				
	 			/*$scheduleDateStart = explode(" ", $st);
	 			$scheduleDateEnd = explode(" ", $et);
	 			$this->request->data['OptAppointment']['patient_id'] = $allvar['patient_name_value'];
	 			$this->request->data['OptAppointment']['location_id'] = $this->Session->read('locationid');
	 			$this->request->data['OptAppointment']['subject'] = $sub;
	 			$this->request->data['OptAppointment']['schedule_date'] = $scheduleDateStart[0];
	 			$this->request->data['OptAppointment']['start_time'] = $scheduleDateStart[1];
	 			$this->request->data['OptAppointment']['end_time'] = $scheduleDateEnd[1];
	 			$this->request->data['OptAppointment']['starttime'] = $st;
	 			$this->request->data['OptAppointment']['endtime'] = $end_time;
	 			$this->request->data['OptAppointment']['is_all_day_event'] = $ade;
	 			$this->request->data['OptAppointment']['description'] = $dscr;
	 			$this->request->data['OptAppointment']['color'] = $color;
	 			$this->request->data['OptAppointment']['cost_to_hospital'] = $allvar['cost_to_hospital'];
	 			$this->request->data['OptAppointment']['dummy_surgery_name']=$allvar['dummy_surgery_name'];//Dummy surgery for vadodara instance - Pooja
	 			$this->request->data['OptAppointment']['opt_id'] = $allvar['opt_id'];
	 			$this->request->data['OptAppointment']['opt_table_id'] = $allvar['opt_table_id'];
	 			$this->request->data['OptAppointment']['diagnosis'] = $allvar['diagnosis'];
	 			//$this->request->data['OptAppointment']['surgery_category_id'] = $allvar['surgery_category_id'];
	 			//$this->request->data['OptAppointment']['surgery_subcategory_id'] = $allvar['surgery_subcategory_id'];
	 			//$this->request->data['OptAppointment']['surgery_id'] = $allvar['surgery_id'];
	 			$this->request->data['OptAppointment']['preferencecard_id'] = $allvar['preferencecard_id'];
	 			$this->request->data['OptAppointment']['operation_type'] = $allvar['operation_type'];*/
	 			 
	 			//$this->request->data['OptAppointment']['tariff_list_id'] = $getTariffListId['Surgery']['tariff_list_id'];
	 			/* if($allvar['doctor_id']) {
	 				$this->request->data['OptAppointment']['surgen_service_group_id'] = $allvar['surgen_service_group_id'];
	 				$this->request->data['OptAppointment']['tariff_list_id'] = $allvar['surgen_tariff_list_id'];
	 				//by gulshan to fetch surgery cost 
	 				
	 				$surgeryCost = $this->TariffAmount->getTariffAmount($getTariffStandardId,$allvar['surgen_tariff_list_id']);
	 				$this->request->data['OptAppointment']['surgery_cost'] = $surgeryCost ;
	 				//EOF surgery cost
					if($allvar['ot_charges'] != ''){
						$this->request->data['OptAppointment']['ot_charges'] = $allvar['ot_charges'] ;
					}else if(($getTariffStandardId==$privateID) || ($getTariffStandardId==$raymondId['TariffStandard']['id'])){
	 					//if  patient is private add ot cost as 30% surgery cost -Pooja
	 					$otCost=($surgeryCost*30)/100;
	 					$this->request->data['OptAppointment']['ot_charges'] = $otCost ;
	 				} */

	 				//BOF jv for accounting by amit jain
	 				/* $accountId = $this->Account->getAccountIdOnly(Configure::read('surgeryPaymentLabel'));
	 				 //find person id for updation amount of services and also used some details for narration
	 				$getPatientDetails=$this->Patient->find('first',array('conditions'=>array('Patient.id'=>$allvar['patient_name_value']),'fields'=>array('person_id','lookup_name','form_received_on')));
	 				//find doctor first name and last name for create accounting ledger
	 				$doctorDetails = $this->User->find('first',array('fields'=>array('User.first_name','User.last_name'),'conditions'=>array('User.is_deleted'=>'0','User.id'=>$allvar['doctor_id'])));
	 				$doctorName = $doctorDetails['User']['first_name']." ".$doctorDetails['User']['last_name'];
	 				$doctorId = $this->Account->getUserIdOnly($allvar['doctor_id'],'User',$doctorName);
	 					
	 				$regDate  =  $this->DateFormat->formatDate2Local($getPatientDetails['Patient']['form_received_on'],Configure::read('date_format'),true);
	 				$doneDate  =  $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
	 					
	 				$narration = 'Being Surgery charged to patient '.$getPatientDetails['Patient']['lookup_name']." (Date of Registration :".$regDate.")".'done on '.$doneDate;
	 				$jvData = array('date'=>date('Y-m-d H:i:s'),
	 				'location_id'=>$this->Session->read('locationid'),
	 				'account_id'=>$accountId,
	 				'user_id'=>$doctorId,
	 				'patient_id'=>$allvar['patient_name_value'],
	 				'type'=>'SurgeryCharges',
	 				'narration'=>$narration,
	 				'debit_amount'=>$allvar['cost_to_hospital']);
	 				if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
	 				$this->VoucherEntry->insertJournalEntry($jvData);
	 				$this->VoucherEntry->id= '';
	 				}
	 				// ***insert into Account (By) credit manage current balance
	 				$this->Account->setBalanceAmountByAccountId($accountId,$allvar['cost_to_hospital'],'debit');
	 				$this->Account->setBalanceAmountByUserId($doctorId,$allvar['cost_to_hospital'],'credit'); */
	 				//EOF jv
	 					
	 			/* }else{
	 				$this->request->data['OptAppointment']['surgen_service_group_id'] = NULL;
	 				$this->request->data['OptAppointment']['tariff_list_id'] = NULL;
	 			} */
	 				
	 			//$this->request->data['OptAppointment']['service_group'] = $allvar['service_group'];
	 			/* if($allvar['department_id']) {
	 				$this->request->data['OptAppointment']['anaesthesia_service_group_id'] = $allvar['anaesthesia_service_group_id'];
	 				$this->request->data['OptAppointment']['anaesthesia_tariff_list_id'] = $allvar['anaesthesia_tariff_list_id'];
	 				//by gulshan to fetch surgery cost
	 				
	 					$instance= $this->Session->read('website.instance');
		 				//if  patient is private then  anaesthesia charges is 30% of surgery cost. -Pooja
		 				$anaesthesiaCost=0;
		 				if(($getTariffStandardId==$privateID || $getTariffStandardId==$raymondId['TariffStandard']['id']) && !empty($allvar['anaesthesia_tariff_list_id']) && $instance != 'kanpur'){
		 					$surgeryCost = $this->TariffAmount->getTariffAmount($getTariffStandardId,$allvar['surgen_tariff_list_id']);
		 					$anaesthesiaCost=($surgeryCost*30)/100;

		 				}else if(!empty($allvar['anaesthesia_tariff_list_id'])){
		 					$anaesthesiaCost = $this->TariffAmount->getTariffAmount($getTariffStandardId,$allvar['anaesthesia_tariff_list_id']);
		 				}
		 				$this->request->data['OptAppointment']['anaesthesia_cost'] = $anaesthesiaCost ;
		 				if(!empty($allvar['anaesthesia_cost'])){
		 					$this->request->data['OptAppointment']['anaesthesia_cost'] = $allvar['anaesthesia_cost'] ;
		 				} */
		 				// EOF anaesthesia cost
	 				//For anaesthesia jv by amit jain
	 				/* $anaestCost = $this->TariffAmount->find('first',array('fields'=>array('nabh_charges'),'conditions'=>array('TariffAmount.tariff_list_id'=>$allvar['anaesthesia_tariff_list_id'],'TariffAmount.tariff_standard_id'=>$getTariffStandardId)));
		 				$departmentDetails = $this->User->find('first',array('fields'=>array('User.first_name','User.last_name'),'conditions'=>array('User.is_deleted'=>'0','User.id'=>$allvar['department_id'])));
	 				$docName = $departmentDetails['User']['first_name']." ".$departmentDetails['User']['last_name'];
	 				$docoId = $this->Account->getUserIdOnly($allvar['department_id'],'User',$docName);
	 				$narrationdetails = 'Being Anaesthesia charged to patient '.$getPatientDetails['Patient']['lookup_name']." (Date of Registration :".$regDate.")".'done on '.$doneDate;
	 				$jvData = array('date'=>date('Y-m-d H:i:s'),
	 						'location_id'=>$this->Session->read('locationid'),
	 						'account_id'=>$accountId,
	 				'user_id'=>$docoId,
	 				'patient_id'=>$allvar['patient_name_value'],
	 				'type'=>'SurgeryCharges',
	 				'narration'=>$narrationdetails,
	 				'create_time'=>date('Y-m-d H:i:s', strtotime("now +1 sec")),
	 				'debit_amount'=>$anaestCost['TariffAmount']['nabh_charges']);
	 				if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
	 				$this->VoucherEntry->insertJournalEntry($jvData);
	 				}
	 				// ***insert into Account (By) credit manage current balance
	 				$this->Account->setBalanceAmountByAccountId($accountId,$anaestCost['TariffAmount']['nabh_charges'],'debit');
	 				$this->Account->setBalanceAmountByUserId($docoId,$anaestCost['TariffAmount']['nabh_charges'],'credit'); */
		 			//EOF JV
	 				//EOF surgery cost
	 			/* }else{
                     $this->request->data['OptAppointment']['anaesthesia_service_group_id'] = NULL;
	 				$this->request->data['OptAppointment']['anaesthesia_tariff_list_id'] = NULL;
	 			}
	 			// Garuav for kanpur 
	 			$this->request->data['OptAppointment']['surgeon_amt'] = $allvar['surgeon_amt'];
	 			$this->request->data['OptAppointment']['asst_surgeon_one'] = $allvar['asst_surgeon_one'];
	 			$this->request->data['OptAppointment']['asst_surgeon_one_charge'] = $allvar['asst_surgeon_one_charge'];
	 			$this->request->data['OptAppointment']['asst_surgeon_two'] = $allvar['asst_surgeon_two'];
	 			$this->request->data['OptAppointment']['asst_surgeon_two_charge'] = $allvar['asst_surgeon_two_charge'];
	 			$this->request->data['OptAppointment']['cardiologist_id'] = $allvar['cardiologist_id'];
	 			$this->request->data['OptAppointment']['cardiologist_charge'] = $allvar['cardiologist_charge'];
	 			$this->request->data['OptAppointment']['ot_asst_charge'] = $allvar['ot_asst_charge'];
	 			foreach($allvar['ot_service'] as $serviceName => $otser){
                	if($otser != 0)
               		$otService[$serviceName] = $otser;
				}
				$this->request->data['OptAppointment']['ot_service'] = serialize($otService); 
	 			$this->request->data['OptAppointment']['operation_type'] = $allvar['operation_type'];
	 			$this->request->data['OptAppointment']['doctor_id'] = $allvar['doctor_id'];
	 			$this->request->data['OptAppointment']['department_id'] = $allvar['department_id'];
	 			$this->request->data['OptAppointment']['anaesthesia'] = $allvar['anaesthesia'];
	 			$this->request->data['OptAppointment']['procedure_complete'] = $allvar['procedurecomplete'];
	 			if($allvar['ot_in_date']) {
						$allvar['ot_in_date'] =  $this->DateFormat->formatDate2STD($allvar['ot_in_date'],'mm/dd/yyyy');
						$allvar['ot_in_date'] = explode(" ", $allvar['ot_in_date']);
						$this->request->data['OptAppointment']['ot_in_date'] = trim($allvar['ot_in_date'][0])." ".trim($allvar['otintime']);
					}
				if($allvar['incision_date']) {
						$allvar['incision_date'] =  $this->DateFormat->formatDate2STD($allvar['incision_date'],'mm/dd/yyyy');
						$allvar['incision_date'] = explode(" ", $allvar['incision_date']);
						$this->request->data['OptAppointment']['incision_date'] = trim($allvar['incision_date'][0])." ".trim($allvar['incisiontime']);
					}
				if($allvar['skin_closure_date']) {
						$allvar['skin_closure_date'] =  $this->DateFormat->formatDate2STD($allvar['skin_closure_date'],'mm/dd/yyyy');
						$allvar['skin_closure_date'] = explode(" ", $allvar['skin_closure_date']);
						$this->request->data['OptAppointment']['skin_closure_date'] = trim($allvar['skin_closure_date'][0])." ".trim($allvar['skinclosure']);
					}
				if($allvar['out_date']) {
						$allvar['out_date'] =  $this->DateFormat->formatDate2STD($allvar['out_date'],'mm/dd/yyyy');
						$allvar['out_date'] = explode(" ", $allvar['out_date']);
						$this->request->data['OptAppointment']['out_date'] = trim($allvar['out_date'][0])." ".trim($allvar['outtime']);
					}
	 			$this->request->data['OptAppointment']['created_by'] = $this->Session->read('userid');
	 			$this->request->data['OptAppointment']['create_time'] =  date('Y-m-d H:i:s');
	 			//debug($this->request->data);exit;
	 			$date=$st; 
	 			$checkSave = $this->OptAppointment->save($this->request->data);*/
				//$lastInsertedId = $this->OptAppointment->getLastInsertID();
	 			$checkSave = '1';
	 			if(!$checkSave){
	 				$ret['IsSuccess'] = false;
	 				$ret['Msg'] = "Unable to add this OT Appointment";
	 			}else{
	 				//BOF-Mahalaxmi-After OptAppointment to  get sms alert for Patient as well as Physician...... 
	 				/*$personDataId = $this->Patient->Find('first',array('fields'=>array('Patient.person_id'),'conditions'=>array('Patient.id'=>$this->request->data['OptAppointment']['patient_id'])));
	 				$getEnableFeatureChk=$this->Session->read('sms_feature_chk');
	 				if($getEnableFeatureChk=='1'){
	 					$getLastOptId = $this->OptAppointment->getLastInsertID();
	 					$this->Patient->sendToSmsPhysician($personDataId['Patient']['person_id'],'OT',$getLastOptId);
	 					$this->Patient->sendToSmsPhysician($personDataId['Patient']['person_id'],'OwnerOT',$getLastOptId);
	 					$this->Patient->sendToSmsPatient($personDataId['Patient']['person_id'],'OT',$getLastOptId);
	 					$userIdArr=array();
	 					$userIdArr['doctor_id'] = $allvar['doctor_id'];
	 					$userIdArr['asst_surgeon_one'] = $allvar['asst_surgeon_one'];
	 					$userIdArr['asst_surgeon_two'] = $allvar['asst_surgeon_two'];
	 					$userIdArr['department_id'] = $allvar['department_id'];
	 					$userIdArr['cardiologist_id'] = $allvar['cardiologist_id'];
	 					$this->Patient->sendToSmsMultipleSurgeon($personDataId['Patient']['person_id'],'OTMultipleSurgeon',$getLastOptId,$userIdArr);
	 				}*/
	 				/******EOF-Mahalaxmi-After OptAppointment to  get sms alert for Patient as well as Physician......  ***/
	 				$ret['Data'] = $lastInsertedId;
	 				
	 				$this->loadModel('OptAppointmentDetail');
	 				//by swapnil
	 				//debug($allvar); exit;  
	 				$saveData = array();
	 				$allSurgeryData = $allvar['data']['surgery']; 
	 				foreach($allSurgeryData['surgery_id'] as $key => $data){
	 					$service=array();
	 					$saveData['opt_appointment_id'] = $lastInsertedId;
	 					$saveData['surgery_id'] = $data;
	 					$service['service_id']=$otherService;
	 					$surgeryTariffListId = $allSurgeryData['surgen_tariff_list_id'][$key];
	 					$service['tariff_list_id']=$surgeryTariffListId;
	 					foreach($allSurgeryData['doctor_id'][$key] as $docKey => $val){
	 						if(!empty($val)){	//if not empty doctor_id
	 							$saveData['cost'] = ''; $service['amount']='';$is_save=0;
	 							if($allSurgeryData['user_type'][$key][$docKey] == "Surgeon" && $docKey == 1){
		 							$surgeryCost = $this->TariffAmount->getTariffAmount($getTariffStandardId,$surgeryTariffListId);
		 							$surgCostData[] = $saveData['cost'] = $surgeryCost ;
		 							$service['amount']=$surgeryCost;
		 							$is_save=1;		 							
	 							}
	 							$saveData['implant_id'] = $allSurgeryData['implant_id'][$key];
	 							$saveData['implant_description'] = $allSurgeryData['implant_description'][$key];
	 							$saveData['tariff_list_id'] = $allSurgeryData['surgen_tariff_list_id'][$key];
		 						$saveData['user_type'] = $allSurgeryData['user_type'][$key][$docKey];
		 						$saveData['doctor_id'] = $allSurgeryData['doctor_id'][$key][$docKey]; 
		 						$service['doctor_id']=$saveData['doctor_id'];
		 						$service['patient_id']=$this->request->data['OptAppointment']['patient_id'];
		 						$service['location_id']=$this->Session->read('locationid');
		 						$service['no_of_times']='1';
		 						$service['tariff_standard_id']=$getTariffStandardId;
		 						$service['date']=$date;
		 						if(!$date){
		 							$service['date']=date('Y-m-d H:i:s');
		 						}else{
		 							$service['date']=$date;
		 						}
		 						$service['create_time']=date('Y-m-d H:i:s');
		 						$service['created_by']=$this->Session->read('userid');
		 						$this->OptAppointmentDetail->saveAll($saveData);
		 						$otDetailId=$this->OptAppointmentDetail->getLastInsertID();		 						 						
		 						if(!$service['amount']){
		 							$service['amount']='0';
		 						}
		 						if($is_save){
	 							//by swapnil to save service bill if procedure is set true
		 						if($allvar['procedurecomplete'] == 1){
			 						/* $this->ServiceBill->save($service);//saving Service in Service bill table
			 						$serviceId=$this->ServiceBill->getLastInsertID();
			 						$this->OptAppointmentDetail->updateAll(array('OptAppointmentDetail.service_bill_id'=>"'$serviceId'"),
			 								array('OptAppointmentDetail.id'=>$otDetailId)); */
			 						}
			 						$this->ServiceBill->id=''; 
		 						}
		 						$this->OptAppointmentDetail->id='';
		 						
	 						}
	 					}
	 				}
	 				//to insert anaesthesia cost
	 				if($allvar['department_id']) {
	 					$saveData = array();$service=array();
	 					$saveData[0]['opt_appointment_id'] = $lastInsertedId;
	 					$saveData[0]['user_type'] = "Anaesthetist";
	 					$saveData[0]['tariff_list_id'] = $allvar['anaesthesia_tariff_list_id'];
	 					$saveData[0]['doctor_id'] = $allvar['department_id'];	 					
	 					$instance= $this->Session->read('website.instance');
		 				$anaesthesiaCost=0;  
		 				if(($getTariffStandardId==$privateID || $getTariffStandardId==$raymondId['TariffStandard']['id'] || in_array($getTariffStandardId, $tpaId)) && !empty($allvar['anaesthesia_tariff_list_id'])){
		 					//$surgeryCost = $this->TariffAmount->getTariffAmount($getTariffStandardId,$allvar['anaesthesia_tariff_list_id']);
		 					//$anaesthesiaCost=($surgeryCost*30)/100;
		 					$anaesthesiaCost = $otChargesCost = (max($surgCostData)*30)/100;
		 				}else if(!empty($allvar['anaesthesia_tariff_list_id'])){
		 					//$anaesthesiaCost = $this->TariffAmount->getTariffAmount($getTariffStandardId,$allvar['anaesthesia_tariff_list_id']);
		 					$anaesthesiaCost = $otChargesCost = 0;
		 				}
		 				$saveData[0]['cost'] = $anaesthesiaCost ; 
		 				if(!empty($allvar['anaesthesia_cost'])){
		 					$saveData[0]['cost'] = $allvar['anaesthesia_cost'] ;
		 				}
		 				$service['service_id']=$otherService;
		 				$service['tariff_list_id']=$allvar['anaesthesia_tariff_list_id'];
		 				$service['amount']=$anaesthesiaCost;
		 				$service['doctor_id']=$saveData[0]['doctor_id'];
		 				$service['patient_id']=$this->request->data['OptAppointment']['patient_id'];
		 				$service['location_id']=$this->Session->read('locationid');
		 				$service['no_of_times']='1';
		 				$service['tariff_standard_id']=$getTariffStandardId;
		 				$service['date']=$date;
		 				$service['create_time']=date('Y-m-d H:i:s');
		 				$service['created_by']=$this->Session->read('userid');
		 				
		 				//to update OT charges directly for hope
		 				$saveData[1]['opt_appointment_id'] = $lastInsertedId;
		 				$saveData[1]['user_type'] = "OT Charges";
		 				$saveData[1]['tariff_list_id'] = $this->TariffList->getServiceIdByServiceName(Configure::read('otcharge')); 
		 				$saveData[1]['cost'] = $otChargesCost ;
		 				
		 				$this->OptAppointmentDetail->saveAll($saveData);
		 				//$this->OptAppointment->updateAll(array('anaesthesia_cost'=>$anaesthesiaCost,'ot_charges'=>$otChargesCost),array('id'=>$lastInsertedId));
		 				if($allvar['procedurecomplete'] == 1){
		 					/* $this->ServiceBill->save($service);
		 					$serviceId=$this->ServiceBill->id; */
		 				}
		 				$otDetailId=$this->OptAppointmentDetail->id;
		 				$this->OptAppointmentDetail->updateAll(array('OptAppointmentDetail.service_bill_id'=>"'$serviceId'"),
		 						array('OptAppointmentDetail.id'=>$otDetailId));
		 				$this->ServiceBill->id='';
		 				$this->OptAppointmentDetail->id='';
		 				
		 				//when OT added update dashboard status in patient table-Atul
		 				$this->Patient->updateAll(array('Patient.dashboard_status'=>"'Posted For Surgery'"),array('Patient.id'=>$allvar['patient_name_value']));
	 				}   
	 				
	 				/* // Update Opt_appointment_id is services of ot charges  //
	 				  $this->OptAppointmentDetail->bindModel(array(
	 						'belongsTo'=>array(
					 					'ServiceBill'=>array('type'=>'INNER','foreignKey'=>false,
					 							'conditions'=>array('ServiceBill.id=OptAppointmentDetail.service_bill_id')))));
				 	//$lastInsertedId
				 	$arrayData=$this->OptAppointmentDetail->find('first',array(
						 			'fields'=>array('OptAppointmentDetail.id','OptAppointmentDetail.id'),
						 			'conditions'=>array('OptAppointmentDetail.opt_appointment_id'=>'0',
				 					'ServiceBill.patient_id'=>$this->request->data['OptAppointment']['patient_id'])));
				 	foreach($arrayData as $sur){
				 		$arr[]=$sur['OptAppointmentDetail']['id'];
				 	}
	 				$this->OptAppointmentDetail->updateAll(array('OptAppointmentDetail.opt_appointment_id'=>"'$lastInsertedId'"),
	 						array('OptAppointmentDetail.id'=>$arr,
	 							  'OptAppointmentDetail.opt_appointment_id'=>'0'));  */
	 				
	 				//***********************************************************************************************************//
	 				//EOF anaesthesia cost
	 				
	 				$ret['IsSuccess'] = true;
	 				$ret['Msg'] = 'Ot appointment has been scheduled'; 

				//BOF-Mahalaxmi-After OptAppointment to  get sms alert for Patient as well as Physician					
					$smsActive=$this->Configuration->getConfigSmsValue('OT Appointment');	
				
	 				if($smsActive){
						$this->Surgery->bindModel(array(
						'belongsTo' => array(
								'Patient' =>array(/*'type'=>'INNER',*/'foreignKey' => false,'conditions'=>array('Patient.id'=>$allvar['patient_name_value'])),					
								'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id')),	
								'User' =>array('foreignKey' => false,'conditions'=>array('User.id'=>$allvar['department_id'])),
								'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
								'Ward' =>array('foreignKey' => false,'conditions'=>array('Ward.id=Patient.ward_id')),	
								'Opt' =>array('foreignKey' => false,'conditions'=>array('Opt.id'=>$allvar['opt_id'])),		
						)));
						$personDataId = $this->Surgery->Find('all',array('fields'=>array('Ward.name','Opt.name','User.first_name','User.last_name','TariffStandard.name','Person.mobile','Surgery.name','Patient.lookup_name','Patient.age','Patient.sex','Patient.diagnosis_txt','User.mobile','Patient.person_id'),'conditions'=>array('Surgery.id'=>$allSurgeryData['surgery_id'])));	
				
							if(!empty($personDataId[0]['User']['first_name']) || !empty($personDataId[0]['User']['last_name'])){
								$getFullUserNameAnasthestist=$personDataId[0]['User']['first_name']." ".$personDataId[0]['User']['last_name'];
							}
							$userOTAssistantData = $this->User->getOTAssisatantUser();
							foreach ($userOTAssistantData as $key => $value) {
								$getOTAssistantMobNo[]=$value['User']['mobile'];
							}	
							#$getOTASSistantMobileNO[0]=$userOTAssistantData[0]['User']['mobile'];					
							$getAnasthesistIdArr[0]=$personDataId[0]['User']['mobile'];				
							
							$getMergeArrFinalDoctor=array_merge($getOTAssistantMobNo,$getAnasthesistIdArr);
							$getMergeArrFinalDoctor=array_filter($getMergeArrFinalDoctor);
							$getOTAssAnasthNo=implode(',',$getMergeArrFinalDoctor);
							
							//User
							foreach($personDataId as $keyPersonId=>$personDataIds){
								$personDataIds['Surgery']['name'] = str_replace ('&','and', $personDataIds['Surgery']['name']);	
								$surgeryNameArr[$keyPersonId]=trim($personDataIds['Surgery']['name']);
							}
							$getSexPatient=strtoUpper(substr($personDataId['0']['Patient']['sex'],0,1));
							$getsurgeryNameArr=implode(",",$surgeryNameArr);		
							$getAgeResultSms=$this->General->convertYearsMonthsToDaysSeparate($personDataId['0']['Patient']['age']);
							$getDateTime=$st;
							$getExplodeData=explode(' ',$getDateTime);
							$getExplodeDate=DateFormatComponent::formatDate2LocalForReport($getExplodeData[0],Configure::read('date_format'));
							$getExplodeData2=date("h:i A", strtotime($getExplodeData[1]));
					
					//if(!empty($getsurgeryNameArr)){					
					if(!empty($getsurgeryNameArr) && strtotime($st) > strtotime(date('Y-m-d H:i:s'))){	
					//BOF -For Send Sms to Physician only	
					
								$getDocIDs=array();
								
								foreach($allSurgeryData['surgery_id'] as $key => $data){				
									$surgeryName= $this->Surgery->Find('first',array('fields'=>array('Surgery.name'),'conditions'=>array('Surgery.id'=>$allSurgeryData['surgery_id'][$key])));		
									$surgeryName['Surgery']['name'] = str_replace ('&','and', $surgeryName['Surgery']['name']);
									$showPhysicianNo= sprintf(Configure::read('OTPhysicianNO'),$surgeryName['Surgery']['name'],$personDataId[0]['TariffStandard']['name'],$personDataId[0]['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms,$getExplodeDate,$getExplodeData2,$personDataId[0]['Opt']['name'],Configure::read('hosp_details'));
									
									foreach($allSurgeryData['doctor_id'][$key] as $docKey => $val){								
										$getDocIDs[]=$val;
									}
									$userDocMobnoData = $this->User->getAllUserById($getDocIDs);						
									$this->Message->sendToSms($showPhysicianNo,$userDocMobnoData[0]); //for Surgery allot for patient to send sms Physician No.			
								}
					
								$showOTAssAnasthesiaNo= sprintf(Configure::read('OTAnasthestistOTAssistantNO'),$getsurgeryNameArr,$personDataId[0]['TariffStandard']['name'],$personDataId[0]['Patient']['lookup_name'],$getSexPatient,$personDataId[0]['Ward']['name'],$getAgeResultSms,$getExplodeDate,$getExplodeData2,$userDocMobnoData[1],$personDataId[0]['Opt']['name']);
								
								$this->Message->sendToSms($showOTAssAnasthesiaNo,$getOTAssAnasthNo); //for Surgery allot for patient to send sms Physician No.
						//EOF -For Send Sms to Physician only	
						//BOF -For Send Sms to Owner only		
				
							if(!empty($personDataId[0]['Patient']['diagnosis_txt'])){
								
								if(empty($getFullUserNameAnasthestist)){
									$showOwnerOt= sprintf(Configure::read('OwnerOTWithoutAnas'),$personDataId[0]['TariffStandard']['name'],$personDataId[0]['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms,$personDataId[0]['Patient']['diagnosis_txt'],$getExplodeDate,$getExplodeData2,$userDocMobnoData[1],$getsurgeryNameArr,$personDataId[0]['Opt']['name']);
								}else{
			 						$showOwnerOt= sprintf(Configure::read('OwnerOT'),$personDataId[0]['TariffStandard']['name'],$personDataId[0]['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms,$personDataId[0]['Patient']['diagnosis_txt'],$getExplodeDate,$getExplodeData2,$userDocMobnoData[1],$getFullUserNameAnasthestist,$getsurgeryNameArr,$personDataId[0]['Opt']['name']);
								}
			 				}else{
								if(!empty($getFullUserNameAnasthestist)){						
									$showOwnerOt= sprintf(Configure::read('OwnerOTWithoutdia'),$personDataId[0]['TariffStandard']['name'],$personDataId[0]['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms,$getExplodeDate,$getExplodeData2,$userDocMobnoData[1],$getFullUserNameAnasthestist,$getsurgeryNameArr,$personDataId[0]['Opt']['name']);
								}else{
									$showOwnerOt= sprintf(Configure::read('OwnerOTWithoutdiaAnas'),$personDataId[0]['TariffStandard']['name'],$personDataId[0]['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms,$getExplodeDate,$getExplodeData2,$userDocMobnoData[1],$getsurgeryNameArr,$personDataId[0]['Opt']['name']);
									
								}
			 				}
				
					$this->Message->sendToSms($showOwnerOt,Configure::read('owner_no')); //for Surgery allot for patient to send sms owner
					//EOF -For Send Sms to Owner only	


					//BOF -For Send Sms to Patient only/	
					$showPatientNo= sprintf(Configure::read('OTPatientNO'),$getExplodeDate,$getExplodeData2,$personDataId[0]['Opt']['name'],Configure::read('hosp_details'));	 				
					$this->Message->sendToSms($showPatientNo,$personDataId[0]['Person']['mobile']); //for Surgery allot for patient to send sms Patient Mobile No.
					
					//EOF -For Send Sms to Patient only/	
					} //EOF FlagSession SMS feature
						
				//EOF-Mahalaxmi-After OptAppointment to  get sms alert for Patient as well as Physician
	 				
	 				}
	 			}
	 		}
	 	}
	 }catch(Exception $e){
	 	$ret['IsSuccess'] = false;
	 	$ret['Msg'] = $e->getMessage();
	 }

	 return $ret;
	}

	/**
	 * list event calendar by range.
	 *
	 */
	public function listCalendarByRange($sd, $ed){
		$this->layout = "false";
		$this->loadModel('OptAppointment'); 
		$ret = array();
		$ret['events'] = array();
		$ret["issort"] =true;
		$ret["start"] = $this->php2JsTime($sd);
		$ret["end"] = $this->php2JsTime($ed);

		$ret['error'] = null;
		$sd1 = $this->DateFormat->formatDate2STD($this->php2MySqlTime($sd),Configure::read('date_format_yyyy_mm_dd'));
		$sd = $this->php2MySqlTime($sd);
		$ed = $this->php2MySqlTime($ed);
		//$sd = $this->DateFormat->formatDate2STD($this->php2MySqlTime($sd),Configure::read('date_format'), true);
		//$ed = $this->DateFormat->formatDate2STD($this->php2MySqlTime($ed),Configure::read('date_format'), true);

		try{
			$this->OptAppointment->bindModel(array(
					'belongsTo' => array( 'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
 
					)),false);

			$conditions['OptAppointment'] = array('starttime BETWEEN ? AND ?'=> array($sd1, $ed));
			$conditions['OptAppointment']['location_id'] = $this->Session->read('locationid');
			$conditions['OptAppointment']['is_deleted'] = 0;
			if(!empty($this->request->params['named']['opt_id'])){
				$conditions['OptAppointment']['opt_id'] = $this->request->params['named']['opt_id'];
			}
			if(!empty($this->request->params['named']['opt_table_id'])){
				$conditions['OptAppointment']['opt_table_id'] = $this->request->params['named']['opt_table_id'];
			}
			$conditions = $this->postConditions($conditions);
				
			//$getList = $this->OptAppointment->find('all', array('conditions' => $conditions,'group'=>array(/* 'OptAppointment.id', */'OptAppointment.batch_identifier')/* ,'order'=>array('OptAppointment.id'=>'DESC') */));

			$getList = $this->OptAppointment->find('all', array('fields'=>array('*','min(OptAppointment.id) as firstAppt'),'conditions' => $conditions,
				'group'=>array(  'OptAppointment.schedule_date','OptAppointment.patient_id')/* ,'order'=>array('OptAppointment.id'=>'DESC') */
				));
		    
			foreach($getList as $getListVal) {
				$realstartDate = $this->DateFormat->formatDate2STD($getListVal['OptAppointment']['starttime'],Configure::read('date_format_yyyy_mm_dd'));
				$realendate = $this->DateFormat->formatDate2STD($getListVal['OptAppointment']['endtime'],Configure::read('date_format_yyyy_mm_dd'));

				//$startDate = strtotime(date("Y-m-d",strtotime($getListVal['OptAppointment']['starttime'])));
				//$endDate = strtotime(date("Y-m-d",strtotime($getListVal['OptAppointment']['endtime'])));
				$startDate = strtotime(date("Y-m-d",strtotime($this->DateFormat->formatDate2Local($getListVal['OptAppointment']['starttime'],Configure::read('date_format_yyyy_mm_dd'), true))));;
				$endDate = strtotime(date("Y-m-d",strtotime($this->DateFormat->formatDate2Local($getListVal['OptAppointment']['endtime'],Configure::read('date_format_yyyy_mm_dd'), true))));;
				$datediff = $endDate - $startDate;
				$totaldaysDiff = floor(abs($endDate - $startDate) / 86400);
				//echo $totaldaysDiff;
				$moreThanDay=0;
				if($totaldaysDiff>0){
					$moreThanDay = 1;
				}
				if(empty($this->request->params['named']['opt_id']) || empty($this->request->params['named']['opt_table_id'])){
					if($getListVal['OptAppointment']['patient_id'] == $_GET['patient_id']) {
						$patientColor = $getListVal['OptAppointment']['color'];
					} else {
						$patientColor = 22;
					}
				}
				$ret['events'][] = array(
						$getListVal['0']['firstAppt'],//$getListVal['OptAppointment']['id'],
						$getListVal['OptAppointment']['subject']." (".$getListVal['PatientInitial']['name']." ".$getListVal['Patient']['lookup_name'].")",
						$this->php2JsTime($this->mySql2PhpTime($this->DateFormat->formatDate2Local($getListVal['OptAppointment']['starttime'],Configure::read('date_format_yyyy_mm_dd'), true))),
						$this->php2JsTime($this->mySql2PhpTime($this->DateFormat->formatDate2Local($getListVal['OptAppointment']['endtime'],Configure::read('date_format_yyyy_mm_dd'), true))),
						$getListVal['OptAppointment']['IsAllDayEvent'],
						$moreThanDay, //more than one day event
						//$row->InstanceType,
						0,//Recurring event,
						$patientColor,
						1,//editable
						date("m/d/Y H:i",strtotime($this->DateFormat->formatDate2Local($getListVal['OptAppointment']['starttime'],Configure::read('date_format_yyyy_mm_dd'), true))),
						date("m/d/Y H:i",strtotime($this->DateFormat->formatDate2Local($getListVal['OptAppointment']['endtime'],Configure::read('date_format_yyyy_mm_dd'), true))),
						$getListVal['OptAppointment']['patient_id']


				);

			}
		}catch(Exception $e){
			$ret['error'] = $e->getMessage();
		} 
		return $ret;
	}

	/**
	 * list event calendar.
	 *
	 */
	public function listCalendar($day, $type){
		$phpTime = $this->js2PhpTime($day);
		//print($day);
		//echo $phpTime . "+" . $type;
		switch($type){
			case "month":
				$st = mktime(0, 0, 0, date("m", $phpTime), 1, date("Y", $phpTime));
				$et = mktime(0, 0, -1, date("m", $phpTime)+1, 1, date("Y", $phpTime));
				break;
			case "week":
				//suppose first day of a week is monday
				$monday  =  date("d", $phpTime) - date('N', $phpTime) + 1;
				//echo date('N', $phpTime);
				$st = mktime(0,0,0,date("m", $phpTime), $monday, date("Y", $phpTime));
				$et = mktime(0,0,-1,date("m", $phpTime), $monday+7, date("Y", $phpTime));
				break;
			case "day":
				$st = mktime(0, 0, 0, date("m", $phpTime), date("d", $phpTime), date("Y", $phpTime));
				$et = mktime(0, 0, -1, date("m", $phpTime), date("d", $phpTime)+1, date("Y", $phpTime));
				break;
		}
		//echo $st . "--" . $et;
		//echo $day;

		return $this->listCalendarByRange($st, $et);
	}

	/**
	 * update event calendar.
	 *
	 */
	public function updateCalendar($id, $st, $et){
		$this->loadModel('OptAppointment');
		$ret = array();
		try{
			// check overlap time //
			$getAllVar = $this->OptAppointment->find('first', array('conditions' => array('OptAppointment.id' => $id)));
			$allvar = array('doctor_id' => $getAllVar['OptAppointment']['doctor_id'], 'opt_id' => $getAllVar['OptAppointment']['opt_id'],'opt_table_id' => $getAllVar['OptAppointment']['opt_table_id'],'department_id' => $getAllVar['OptAppointment']['department_id']);
			$this->ScheduleTime = $this->Components->load('ScheduleTime');
			$checkOverlapTime = $this->ScheduleTime->checkOverlapForOT($id, $st, $et, $allvar);
			if($checkOverlapTime['optappointment'] == 2 || $checkOverlapTime['surgeon'] == 2 || $checkOverlapTime['anaesthesia'] == 2 || $checkOverlapTime['surgeonoverlap'] == 2 || $checkOverlapTime['anaesthesiaoverlap'] == 2 || $checkOverlapTime['surgeon_appointment'] == 2 || $checkOverlapTime['anaesthesia_appointment'] == 2) {
				if($checkOverlapTime['optappointment'] == 2) {
					$ret['IsSuccess'] = false;
					$this->Session->setFlash(__('This OT Table Is Not Available For This Time Span', true),true,array('class'=>'message'));
				}
				if($checkOverlapTime['surgeon'] == 2) {
					$ret['IsSuccess'] = false;
					$this->Session->setFlash(__('Surgeon Is Not Available', true),true,array('class'=>'message'));
				}
				if($checkOverlapTime['anaesthesia'] == 2) {
					$ret['IsSuccess'] = false;
					$this->Session->setFlash(__('Surgeon Is Not Available', true),true,array('class'=>'message'));
				}
				if($checkOverlapTime['anaesthesiaoverlap'] == 2 || $checkOverlapTime['surgeonoverlap'] == 2) {
					$ret['IsSuccess'] = false;
					$this->Session->setFlash(__('Doctor Is Already Set For OT Appointment', true),true,array('class'=>'message'));
				}
				if($checkOverlapTime['surgeon_appointment'] == 2 || $checkOverlapTime['anaesthesia_appointment'] == 2) {
					$ret['IsSuccess'] = false;
					$ret['Msg'] = "Doctor Is Already Set For Other Appointment";
				}
			} else {
				if($ade == 1) {
					//$end_time = date("Y-m-d H:i:s", strtotime($this->php2MySqlTime($this->js2PhpTime($et)) . ' + 23 hours 59 minutes'));
					$end_time = date("Y-m-d H:i:s", strtotime($et . ' + 23 hours 59 minutes'));
				} else {
					//$end_time = $this->php2MySqlTime($this->js2PhpTime($et));
					$end_time = $et;
				}

				$this->OptAppointment->id = $id;
				//$scheduleDateStart = explode(" ", $this->php2MySqlTime($this->js2PhpTime($st)));
				//$scheduleDateEnd = explode(" ", $this->php2MySqlTime($this->js2PhpTime($et)));
				$scheduleDateStart = explode(" ", $st);
				$scheduleDateEnd = explode(" ", $et);
				$this->request->data['OptAppointment']['id'] = $id;
				$this->request->data['OptAppointment']['location_id'] = $this->Session->read('locationid');
				$this->request->data['OptAppointment']['schedule_date'] = $scheduleDateStart[0];
				$this->request->data['OptAppointment']['start_time'] = $scheduleDateStart[1];
				$this->request->data['OptAppointment']['end_time'] = $scheduleDateEnd[1];
				$this->request->data['OptAppointment']['modified_by'] = $this->Session->read('userid');
				$this->request->data['OptAppointment']['modify_time'] = date('Y-m-d H:i:s');
				$this->request->data['OptAppointment']['starttime'] = $st;
				$this->request->data['OptAppointment']['endtime'] =$end_time;

				$checkSave = $this->OptAppointment->save($this->request->data);
				if(!$checkSave){
					$ret['IsSuccess'] = false;
					$ret['Msg'] = "Unable to update this OT Appointment";
				}else{
					$ret['IsSuccess'] = true;
					$ret['Msg'] = 'OT Appointment Updated';

				}

			}
		}catch(Exception $e){
			$ret['IsSuccess'] = false;
			$ret['Msg'] = $e->getMessage();
		}
		return $ret;
	}

	/**
	 * update detailed event calendar.
	 *
	 */
	public function updateDetailedCalendar($id, $st, $et, $sub, $ade, $dscr, $color, $tz,$allvar){
		
		$this->uses = array('OptAppointment','Surgery','Patient','Anesthesia','TariffAmount','TariffList','TariffStandard','ServiceCategory','Message','User','Configuration');
		$surgeryCatId=$this->ServiceCategory->getServiceGroupId('surgeryservices');
		$otherService=$this->ServiceCategory->getServiceGroupId('otherServices');
		try{
			if($st > $et) {
				$ret['IsSuccess'] = false;
				$ret['Msg'] = "Start Date & Time Should Not Be Greater Than End Time";
			} else {  
				$OptAppointmentIdData = $this->OptAppointment->find('first',array('fields'=>array('OptAppointment.*'),'conditions'=>array('OptAppointment.id'=>$id)));
				$batchIdentifier = ($OptAppointmentIdData['OptAppointment']['batch_identifier']);  
				$this->OptAppointment->updateAll(array('OptAppointment.is_deleted'=>'1'),array('OptAppointment.batch_identifier'=>$batchIdentifier));
				 
				// check overlap time //
				//$checkOverlapTime = $this->ScheduleTime->checkOverlapForOT($id, $this->php2MySqlTime($this->js2PhpTime($st)), $this->php2MySqlTime($this->js2PhpTime($et)), $allvar);
				$this->ScheduleTime = $this->Components->load('ScheduleTime');
				$checkOverlapTime = $this->ScheduleTime->checkOverlapForOT($id, $st, $et, $allvar);
				$otTime = $this->ScheduleTime->getInvalidateOtTime($allvar);/** checking Ot in out time*/ 
				if($checkOverlapTime['optappointment'] == 2 || $checkOverlapTime['surgeon'] == 2 || $checkOverlapTime['anaesthesia'] == 2 || $checkOverlapTime['surgeonoverlap'] == 2 || $checkOverlapTime['anaesthesiaoverlap'] == 2 || $checkOverlapTime['surgeon_appointment'] == 2 || $checkOverlapTime['anaesthesia_appointment'] == 2) {
					if($checkOverlapTime['optappointment'] == 2) {
						$ret['IsSuccess'] = false;
						$ret['Msg'] = "This OT Table Is Not Available For This Time Span";
					}
					if($checkOverlapTime['surgeon'] == 2) {
						$ret['IsSuccess'] = false;
						$ret['Msg'] = "Surgeon Is Not Available";
					}
					if($checkOverlapTime['anaesthesia'] == 2) {
						$ret['IsSuccess'] = false;
						$ret['Msg'] = "Surgeon Is Not Available";
					}
					if($checkOverlapTime['anaesthesiaoverlap'] == 2 || $checkOverlapTime['surgeonoverlap'] == 2) {
						$ret['IsSuccess'] = false;
						$ret['Msg'] = "Doctor Is Already Set For OT Appointment";
					}
					if($checkOverlapTime['surgeon_appointment'] == 2 || $checkOverlapTime['anaesthesia_appointment'] == 2) {
						$ret['IsSuccess'] = false;
						$ret['Msg'] = "Doctor Is Already Set For Other Appointment";
					}
					
				} else if($otTime['isInvalidate']){
						$ret['IsSuccess'] = false;
						$ret['Msg'] = $otTime['Msg'];
				} else {
						
					//tariff List Private Id
					$privateID = $this->TariffStandard->getPrivateTariffID();//retrive private ID
					$raymondId=$this->TariffStandard->find('first',array('fields'=>array('id'),'conditions'=>array('name'=>'Raymonds','location_id'=>$this->Session->read('locationid'))));
					$this->set('privateId',$privateID);
						
					if($ade == 1) {
						//$end_time = date("Y-m-d H:i:s", strtotime($this->php2MySqlTime($this->js2PhpTime($et)) . ' + 23 hours 59 minutes'));
						$end_time = date("Y-m-d H:i:s", strtotime($et . ' + 23 hours 59 minutes'));
					} else {
						//$end_time = $this->php2MySqlTime($this->js2PhpTime($et));
						$end_time = $et;
					}
					
					
					//tariff List Private Id
					$privateID = $this->TariffStandard->getPrivateTariffID();//retrive private ID
					$raymondId=$this->TariffStandard->find('first',array('fields'=>array('id'),'conditions'=>array('name'=>'Raymonds','location_id'=>$this->Session->read('locationid'))));
					$tpaId=$this->TariffStandard->find('list',array('fields'=>array('id','id'),'conditions'=>array('tariff_standard_type'=> 'TPA','is_deleted'=>'0','location_id'=>$this->Session->read('locationid'))));
                                        $this->set('privateId',$privateID);
					
					$getTariffStandardId = $this->Patient->getTariffStandardIDByPatient($allvar['patient_name_value']) ;	// patient_name_value is nothing but patient id
					$allSurgeryData = $allvar['data']['surgery'];
						
					$scheduleDateStart = explode(" ", $st);
					$scheduleDateEnd = explode(" ", $et);
					
					$saveData = array();
					$saveData['patient_id'] = $allvar['patient_name_value'];
					$saveData['location_id'] = $this->Session->read('locationid');
					$saveData['subject'] = $sub;
					$saveData['schedule_date'] = $scheduleDateStart[0];
					$saveData['start_time'] = $scheduleDateStart[1];
					$saveData['end_time'] = $scheduleDateEnd[1];
					$saveData['starttime'] = $st;
					$saveData['endtime'] = $end_time;
					$saveData['is_all_day_event'] = $ade;
					$saveData['description'] = $dscr;
					$saveData['color'] = $color;
					$saveData['cost_to_hospital'] = $allvar['cost_to_hospital'];
					$saveData['opt_id'] = $allvar['opt_id'];
					$saveData['opt_table_id'] = $allvar['opt_table_id'];
					//$saveData['procedure_complete'] = $allvar['procedureComplete'];
					$saveData['diagnosis'] = $allvar['diagnosis'];
					$saveData['preferencecard_id'] = $allvar['preferencecard_id'];					
					$saveData['operation_type'] = $allvar['operation_type'];
					$saveData['anaesthesia_service_group_id'] = $allvar['anaesthesia_service_group_id'];
					$saveData['anaesthesia_tariff_list_id'] = $allvar['anaesthesia_tariff_list_id'];
					$saveData['procedure_complete'] = $allvar['procedurecomplete'];
					$saveData['batch_identifier'] = time();
					
					if($OptAppointmentIdData['OptAppointment']['ot_in_date']){
						$saveData['ot_in_date']=$OptAppointmentIdData['OptAppointment']['ot_in_date'];
					}else if($allvar['ot_in_date']) {
						$allvar['ot_in_date'] =  $this->DateFormat->formatDate2STD($allvar['ot_in_date'],Configure::read('date_format'));
						$allvar['ot_in_date'] = explode(" ", $allvar['ot_in_date']);
						$saveData['ot_in_date'] = trim($allvar['ot_in_date'][0])." ".trim($allvar['otintime']);
					}
					if($OptAppointmentIdData['OptAppointment']['incision_date']){
						$saveData['incision_date']=$OptAppointmentIdData['OptAppointment']['incision_date'];
					}else if($allvar['incision_date']) {
						$allvar['incision_date'] =  $this->DateFormat->formatDate2STD($allvar['incision_date'],Configure::read('date_format'));
						$allvar['incision_date'] = explode(" ", $allvar['incision_date']);
						$saveData['incision_date'] = trim($allvar['incision_date'][0])." ".trim($allvar['incisiontime']);
					}
					if($OptAppointmentIdData['OptAppointment']['skin_closure_date']){
						$saveData['skin_closure_date']=$OptAppointmentIdData['OptAppointment']['skin_closure_date'];
					}else if($allvar['skin_closure_date']) {
						$allvar['skin_closure_date'] =  $this->DateFormat->formatDate2STD($allvar['skin_closure_date'],Configure::read('date_format'));
						$allvar['skin_closure_date'] = explode(" ", $allvar['skin_closure_date']);
						$saveData['skin_closure_date'] = trim($allvar['skin_closure_date'][0])." ".trim($allvar['skinclosure']);
					}
					if($OptAppointmentIdData['OptAppointment']['out_date']){
						$saveData['out_date']=$OptAppointmentIdData['OptAppointment']['out_date'];
					}else if($allvar['out_date']) {
						$allvar['out_date'] =  $this->DateFormat->formatDate2STD($allvar['out_date'],Configure::read('date_format'));
						$allvar['out_date'] = explode(" ", $allvar['out_date']);
						$saveData['out_date'] = trim($allvar['out_date'][0])." ".trim($allvar['outtime']);
					}
					$saveData['created_by'] = $this->Session->read('userid');
					$saveData['create_time'] =  date('Y-m-d H:i:s');
					$lastInsertedId = '';
					//to save multiple surgery in multiple row of OPT Appointment table by swapnil on 12.09.2015
					foreach($allSurgeryData['surgery_id'] as $key => $data){
						$saveOptData = array();
						$saveOptData['OptAppointment'] = $saveData;
						//debug($saveOptData);
						$getTariffListId = $this->Surgery->find('first', array('fields' => array('Surgery.tariff_list_id', 'Surgery.anaesthesia_tariff_list_id'), 'conditions' => array('Surgery.id' => $data))) ;
						$doctorID = $allSurgeryData['doctor_id'][$key][1];
					
						if(!empty($doctorID)){
							$tariffListID = $allSurgeryData['surgen_tariff_list_id'][$key];
							$surgeryCost = $this->TariffAmount->getTariffAmount($getTariffStandardId,$tariffListID);
							$saveOptData['OptAppointment']['implant_id'] = $allSurgeryData['implant_id'][$key];
							$saveOptData['OptAppointment']['implant_description'] = $allSurgeryData['implant_description'][$key];
							$saveOptData['OptAppointment']['surgery_cost'] = $surgeryCost ;
							$saveOptData['OptAppointment']['surgery_id'] = $data ;
							$saveOptData['OptAppointment']['tariff_list_id'] = $tariffListID;
							$saveOptData['OptAppointment']['doctor_id'] = $doctorID;
							$saveOptData['OptAppointment']['department_id'] = $allvar['department_id'];
								
							if(($getTariffStandardId==$privateID) || ($getTariffStandardId==$raymondId['TariffStandard']['id']) || in_array($getTariffStandardId, $tpaId)){
								$otCost=($surgeryCost*30)/100;
								$saveOptData['OptAppointment']['ot_charges'] = $otCost ;
							}
							$anaesthesiaCost=0;
							if(($getTariffStandardId==$privateID || $getTariffStandardId==$raymondId['TariffStandard']['id'] || in_array($getTariffStandardId, $tpaId)) && !empty($allvar['anaesthesia_tariff_list_id'])){
								$anaesthesiaCost=($surgeryCost*30)/100;
							}else if(!empty($allvar['anaesthesia_tariff_list_id'])){
								$anaesthesiaCost = $this->TariffAmount->getTariffAmount($getTariffStandardId,$allvar['anaesthesia_tariff_list_id']);
							}
							$saveOptData['OptAppointment']['anaesthesia_cost'] = $anaesthesiaCost ;
								
						}else{
							$saveOptData['OptAppointment']['surgen_service_group_id'] = NULL;
							$saveOptData['OptAppointment']['tariff_list_id'] = NULL;
						}
						$checkSave = $this->OptAppointment->saveAll($saveOptData);
						if($lastInsertedId == ''){
							$lastInsertedId = $this->OptAppointment->getLastInsertID();
						}
						$lastInsertedIDS[] = $this->OptAppointment->getLastInsertID();
					}
					
					/* $getTariffListId = $this->Surgery->find('first', array('fields' => array('Surgery.tariff_list_id', 'Surgery.anaesthesia_tariff_list_id'), 'conditions' => array('Surgery.id' => $allvar['surgery_id']))) ;
					$getTariffStandardId = $this->Patient->getTariffStandardIDByPatient($allvar['patient_name_value']) ;
					$getPatientId = $this->Patient->find('first', array('conditions' => array('Patient.admission_id' => $allvar['admissionid']))) ;
					//$scheduleDateStart = explode(" ", $this->php2MySqlTime($this->js2PhpTime($st)));
					//$scheduleDateEnd = explode(" ", $this->php2MySqlTime($this->js2PhpTime($et)));
					$scheduleDateStart = explode(" ", $st);
					$scheduleDateEnd = explode(" ", $et);
					$this->OptAppointment->id = $id;
					// if patient is not current patient //
					if(!empty($allvar['patient_name_value'])) {
						$this->request->data['OptAppointment']['patient_id'] = $allvar['patient_name_value'];
					} else {
						$this->request->data['OptAppointment']['patient_id'] = $getPatientId['Patient']['id'];
					}
					
					$this->request->data['OptAppointment']['id'] = $id;
					$this->request->data['OptAppointment']['location_id'] = $this->Session->read('locationid');
					$this->request->data['OptAppointment']['subject'] = $sub;
					$this->request->data['OptAppointment']['schedule_date'] = $scheduleDateStart[0];
					$this->request->data['OptAppointment']['start_time'] = $scheduleDateStart[1];
					$this->request->data['OptAppointment']['end_time'] = $scheduleDateEnd[1];
					$this->request->data['OptAppointment']['starttime'] = $st;
					$this->request->data['OptAppointment']['endtime'] = $end_time;
					$this->request->data['OptAppointment']['is_all_day_event'] = $ade;
					$this->request->data['OptAppointment']['description'] = $dscr;
					$this->request->data['OptAppointment']['color'] = $color;
					//Cost To hospital field added - Pooja
					$this->request->data['OptAppointment']['cost_to_hospital'] = $allvar['cost_to_hospital'];
					$this->request->data['OptAppointment']['dummy_surgery_name']=$allvar['dummy_surgery_name'];//Dummy surgery for vadodara instance - Pooja
					$this->request->data['OptAppointment']['opt_id'] = $allvar['opt_id'];
					$this->request->data['OptAppointment']['opt_table_id'] = $allvar['opt_table_id'];
					$this->request->data['OptAppointment']['diagnosis'] = $allvar['diagnosis'];
					$this->request->data['OptAppointment']['surgery_category_id'] = $allvar['surgery_category_id'];
					$this->request->data['OptAppointment']['surgery_subcategory_id'] = $allvar['surgery_subcategory_id'];
					$this->request->data['OptAppointment']['surgery_id'] = $allvar['surgery_id'];
					$this->request->data['OptAppointment']['preferencecard_id'] = $allvar['preferencecard_id'];
					$this->request->data['OptAppointment']['operation_type'] = $allvar['operation_type'];
					if($allvar['doctor_id']) {
						$this->request->data['OptAppointment']['surgen_service_group_id'] = $allvar['surgen_service_group_id'];
						$this->request->data['OptAppointment']['tariff_list_id'] = $allvar['surgen_tariff_list_id'];
						//by gulshan to fetch surgery cost
						$surgeryCost = $this->TariffAmount->getTariffAmount($getTariffStandardId,$allvar['surgen_tariff_list_id']);
						$this->request->data['OptAppointment']['surgery_cost'] = $surgeryCost ;

						//EOF surgery cost
						if($allvar['ot_charges'] != ''){
							$this->request->data['OptAppointment']['ot_charges'] = $allvar['ot_charges'] ;
						}else if(($getTariffStandardId==$privateID) || ($getTariffStandardId==$raymondId['TariffStandard']['id'])){
							//if  patient is private add ot cost as 30% surgery cost -Pooja
							$otCost=($surgeryCost*30)/100;
							$this->request->data['OptAppointment']['ot_charges'] = $otCost ;
						}

					}else{
						$this->request->data['OptAppointment']['surgen_service_group_id'] = NULL;
						$this->request->data['OptAppointment']['tariff_list_id'] = NULL;
					}
						
					//$this->request->data['OptAppointment']['service_group'] = $allvar['service_group'];
					//$this->request->data['OptAppointment']['tariff_list_id'] = $getTariffListId['Surgery']['tariff_list_id'];
					if($allvar['department_id']) {
					 $this->request->data['OptAppointment']['anaesthesia_service_group_id'] = $allvar['anaesthesia_service_group_id'];
					 $this->request->data['OptAppointment']['anaesthesia_tariff_list_id'] = $allvar['anaesthesia_tariff_list_id'];
					 //by gulshan to fetch surgery cost
					$instance= $this->Session->read('website.instance');
					 	//if  patient is private then  anaesthesia charges is 30% of surgery cost.
					 	if(($getTariffStandardId==$privateID || $getTariffStandardId==$raymondId['TariffStandard']['id']) && !empty($allvar['anaesthesia_tariff_list_id']) && $instance != 'kanpur'){
					 		$surgeryCost = $this->TariffAmount->getTariffAmount($getTariffStandardId,$allvar['surgen_tariff_list_id']);
					 		$anaesthesiaCost=($surgeryCost*30)/100;

					 	}else if(!empty($allvar['anaesthesia_tariff_list_id'])){
					 		$anaesthesiaCost = $this->TariffAmount->getTariffAmount($getTariffStandardId,$allvar['anaesthesia_tariff_list_id']);
					 	}
						$this->request->data['OptAppointment']['anaesthesia_cost'] = $anaesthesiaCost ;
		 				if(!empty($allvar['anaesthesia_cost'])){
		 					$this->request->data['OptAppointment']['anaesthesia_cost'] = $allvar['anaesthesia_cost'] ;
		 				}
					 
					 //EOF surgery cost
					} else {
					 $this->request->data['OptAppointment']['anaesthesia_service_group_id'] = NULL;
					 $this->request->data['OptAppointment']['anaesthesia_tariff_list_id'] = NULL;
					}
					// Garuav  
					if($allvar['anaesthesia_cost'] != '')
						$this->request->data['OptAppointment']['anaesthesia_cost'] = $allvar['anaesthesia_cost'] ;
					$this->request->data['OptAppointment']['surgeon_amt'] = $allvar['surgeon_amt'];
					$this->request->data['OptAppointment']['asst_surgeon_one_charge'] = $allvar['asst_surgeon_one_charge'];
					$this->request->data['OptAppointment']['asst_surgeon_one'] = $allvar['asst_surgeon_one'];
					$this->request->data['OptAppointment']['asst_surgeon_two_charge'] = $allvar['asst_surgeon_two_charge'];
					$this->request->data['OptAppointment']['asst_surgeon_two'] = $allvar['asst_surgeon_two'];
					$this->request->data['OptAppointment']['cardiologist_charge'] = $allvar['cardiologist_charge'];
					$this->request->data['OptAppointment']['cardiologist_id'] = $allvar['cardiologist_id'];
					$this->request->data['OptAppointment']['ot_asst_charge'] = $allvar['ot_asst_charge'];
					foreach($allvar['ot_service'] as $serviceName => $otser){
						if($otser != 0)
							$otService[$serviceName] = $otser;
					}
					$this->request->data['OptAppointment']['ot_service'] = serialize($otService);
					 
					$this->request->data['OptAppointment']['surgery_subcategory_id'] = $allvar['surgery_subcategory_id'];
					$this->request->data['OptAppointment']['doctor_id'] = $allvar['doctor_id'];
					$this->request->data['OptAppointment']['department_id'] = $allvar['department_id'];
					$this->request->data['OptAppointment']['anaesthesia'] = $allvar['anaesthesia'];
					if($allvar['editOnly']){
						//unset($this->request->data);
						$this->request->data = '';
						$this->OptAppointment->id = $id;
						$this->request->data['OptAppointment']['id'] = $id;
					}
					$this->request->data['OptAppointment']['procedure_complete'] = $allvar['procedurecomplete'];
					if($allvar['ot_in_date']) {
						$allvar['ot_in_date'] =  $this->DateFormat->formatDate2STD($allvar['ot_in_date'],'mm/dd/yyyy');
						$allvar['ot_in_date'] = explode(" ", $allvar['ot_in_date']);
						$this->request->data['OptAppointment']['ot_in_date'] = trim($allvar['ot_in_date'][0])." ".trim($allvar['otintime']);
					}
					if($allvar['incision_date']) {
						$allvar['incision_date'] =  $this->DateFormat->formatDate2STD($allvar['incision_date'],'mm/dd/yyyy');
						$allvar['incision_date'] = explode(" ", $allvar['incision_date']);
						$this->request->data['OptAppointment']['incision_date'] = trim($allvar['incision_date'][0])." ".trim($allvar['incisiontime']);
					}
					if($allvar['skin_closure_date']) {
						$allvar['skin_closure_date'] =  $this->DateFormat->formatDate2STD($allvar['skin_closure_date'],'mm/dd/yyyy');
						$allvar['skin_closure_date'] = explode(" ", $allvar['skin_closure_date']);
						$this->request->data['OptAppointment']['skin_closure_date'] = trim($allvar['skin_closure_date'][0])." ".trim($allvar['skinclosure']);
					}
					if($allvar['out_date']) {
						$allvar['out_date'] =  $this->DateFormat->formatDate2STD($allvar['out_date'],'mm/dd/yyyy');
						$allvar['out_date'] = explode(" ", $allvar['out_date']);
						$this->request->data['OptAppointment']['out_date'] = trim($allvar['out_date'][0])." ".trim($allvar['outtime']);
					}
					$this->request->data['OptAppointment']['modified_by'] = $this->Session->read('userid');
					$this->request->data['OptAppointment']['modify_time'] = date('Y-m-d H:i:s'); */
					//debug($this->request->data);exit;
					//$checkSave = $this->OptAppointment->save($this->request->data['OptAppointment']);
						
		   if(!$checkSave){
	     		$ret['IsSuccess'] = false;
	     		$ret['Msg'] = "Unable to update this OT Appointment";
		   }else{

	     /******BOF-Mahalaxmi-After OptAppointment to  get sms alert for Patient as well as Physician......  ***/
	   /*  $this->Patient->bindModel(array(
	     		'belongsTo' => array(
	     				'EstimateConsultantBilling'=>array('foreignKey' => false,'conditions'=>array('EstimateConsultantBilling.person_id=Patient.person_id')),
	     		)),false);
	     $personDataId = $this->Patient->Find('first',array('fields'=>array('Patient.person_id','EstimateConsultantBilling.other_doctor_staff','EstimateConsultantBilling.id'),'conditions'=>array('Patient.id'=>$this->request->data['OptAppointment']['patient_id'])));
	     $getUnserUsers=unserialize($personDataId['EstimateConsultantBilling']['other_doctor_staff']);
	     $getEnableFeatureChk=$this->Session->read('sms_feature_chk');
	     if($getEnableFeatureChk=='1'){
	     	$getLastOptId = $this->OptAppointment->getLastInsertID();
	     	if(!empty($getLastOptId)){
	     		$this->request->data['OptAppointment']['id']=$getLastOptId;
	     	}
	     	 
	     	$this->Patient->sendToSmsPhysician($personDataId['Patient']['person_id'],'OwnerOT',$this->request->data['OptAppointment']['id']);
	     	$this->Patient->sendToSmsPatient($personDataId['Patient']['person_id'],'OT',$this->request->data['OptAppointment']['id']);
	     	if(!empty($personDataId['EstimateConsultantBilling']['id'])){
	     		$this->Patient->sendToSmsMultipleUser($personDataId['Patient']['person_id'],'Estimate',$getUnserUsers,$this->request->data['OptAppointment']['id']);
	     	}else{
	     		$this->Patient->sendToSmsPhysician($personDataId['Patient']['person_id'],'OT',$this->request->data['OptAppointment']['id']);
	     	}
	     }*/
	     /******EOF-Mahalaxmi-After OptAppointment to  get sms alert for Patient as well as Physician......  ***/
	     $ret['Data'] = $this->OptAppointment->getLastInsertID();
	     
	     
	     $this->loadModel('OptAppointmentDetail');
	     $this->loadModel('ServiceBill');
	     $optDetailData = $this->OptAppointmentDetail->find('list',array('fields'=>array('OptAppointmentDetail.id','OptAppointmentDetail.service_bill_id'),'conditions'=>array('opt_appointment_id'=>$id)));
	     if($this->ServiceBill->updateAll(array('ServiceBill.is_deleted'=>'1'),array('ServiceBill.id'=>array_filter($optDetailData))) && 
	     		$this->OptAppointmentDetail->updateAll(array('OptAppointmentDetail.is_deleted'=>'1'),array('OptAppointmentDetail.opt_appointment_id'=>$id))){
		     //if deleted
	     	//by swapnil  
	 				//debug($allvar); exit;  
 				$saveData = array();
 				$allSurgeryData = $allvar['data']['surgery']; 
 				foreach($allSurgeryData['surgery_id'] as $key => $data){
 					$service=array();
 					$saveData['opt_appointment_id'] = $lastInsertedId;
 					$saveData['surgery_id'] = $data;
 					$service['service_id']=$otherService;
 					$surgeryTariffListId = $allSurgeryData['surgen_tariff_list_id'][$key];
 					$service['tariff_list_id']=$surgeryTariffListId;
 					foreach($allSurgeryData['doctor_id'][$key] as $docKey => $val){
 						if(!empty($val)){	//if not empty doctor_id
 							$saveData['cost'] = ''; $service['amount']='';$is_save=0;
 							if($allSurgeryData['user_type'][$key][$docKey] == "Surgeon" && $docKey == 1){
	 							$surgeryCost = $this->TariffAmount->getTariffAmount($getTariffStandardId,$surgeryTariffListId);
	 							$surgCostData[] = $saveData['cost'] = $surgeryCost ;
	 							$service['amount']=$surgeryCost;
	 							$is_save=1;		 							
 							}
 							$saveData['implant_id'] = $allSurgeryData['implant_id'][$key];
	 						$saveData['implant_description'] = $allSurgeryData['implant_description'][$key];
 							$saveData['tariff_list_id'] = $allSurgeryData['surgen_tariff_list_id'][$key];
	 						$saveData['user_type'] = $allSurgeryData['user_type'][$key][$docKey];
	 						$saveData['doctor_id'] = $allSurgeryData['doctor_id'][$key][$docKey]; 
	 						$service['doctor_id']=$saveData['doctor_id'];
	 						$service['patient_id']=$this->request->data['OptAppointment']['patient_id'];
	 						$service['location_id']=$this->Session->read('locationid');
	 						$service['no_of_times']='1';
	 						$service['tariff_standard_id']=$getTariffStandardId;
	 						$service['date']=$date;
	 						if(!$date){
	 							$service['date']=date('Y-m-d H:i:s');
	 						}else{
	 							$service['date']=$date;
	 						}
	 						$service['create_time']=date('Y-m-d H:i:s');
	 						$service['created_by']=$this->Session->read('userid');
	 						$this->OptAppointmentDetail->saveAll($saveData);
	 						$otDetailId=$this->OptAppointmentDetail->getLastInsertID();		 						 						
	 						if(!$service['amount']){
	 							$service['amount']='0';
	 						}
	 						if($is_save){
 							//by swapnil to save service bill if procedure is set true
	 						if($allvar['procedurecomplete'] == 1){
		 						/* $this->ServiceBill->save($service);//saving Service in Service bill table
		 						$serviceId=$this->ServiceBill->getLastInsertID();
		 						$this->OptAppointmentDetail->updateAll(array('OptAppointmentDetail.service_bill_id'=>"'$serviceId'"),
		 								array('OptAppointmentDetail.id'=>$otDetailId)); */
		 						}
		 						$this->ServiceBill->id=''; 
	 						}
	 						$this->OptAppointmentDetail->id='';
	 						
 						}
 					}
 				}
 				//to insert anaesthesia cost
 				if($allvar['department_id']) {
 					$saveData = array();$service=array();
 					$saveData[0]['opt_appointment_id'] = $lastInsertedId;
 					$saveData[0]['user_type'] = "Anaesthetist";
 					$saveData[0]['tariff_list_id'] = $allvar['anaesthesia_tariff_list_id'];
 					$saveData[0]['doctor_id'] = $allvar['department_id'];	 					
 					$instance= $this->Session->read('website.instance');
	 				$anaesthesiaCost=0;  
	 				if(($getTariffStandardId==$privateID || $getTariffStandardId==$raymondId['TariffStandard']['id'] || in_array($getTariffStandardId, $tpaId)) && !empty($allvar['anaesthesia_tariff_list_id'])){
	 					//$surgeryCost = $this->TariffAmount->getTariffAmount($getTariffStandardId,$allvar['anaesthesia_tariff_list_id']);
	 					//$anaesthesiaCost=($surgeryCost*30)/100;
	 					$anaesthesiaCost = $otChargesCost = (max($surgCostData)*30)/100;
	 				}else if(!empty($allvar['anaesthesia_tariff_list_id'])){
	 					//$anaesthesiaCost = $this->TariffAmount->getTariffAmount($getTariffStandardId,$allvar['anaesthesia_tariff_list_id']);
	 					$anaesthesiaCost = $otChargesCost = 0;
	 				}
	 				$saveData[0]['cost'] = $anaesthesiaCost ; 
	 				if(!empty($allvar['anaesthesia_cost'])){
	 					$saveData[0]['cost'] = $allvar['anaesthesia_cost'] ;
	 				}
	 				$service['service_id']=$otherService;
	 				$service['tariff_list_id']=$allvar['anaesthesia_tariff_list_id'];
	 				$service['amount']=$anaesthesiaCost;
	 				$service['doctor_id']=$saveData[0]['doctor_id'];
	 				$service['patient_id']=$this->request->data['OptAppointment']['patient_id'];
	 				$service['location_id']=$this->Session->read('locationid');
	 				$service['no_of_times']='1';
	 				$service['tariff_standard_id']=$getTariffStandardId;
	 				$service['date']=$date;
	 				$service['create_time']=date('Y-m-d H:i:s');
	 				$service['created_by']=$this->Session->read('userid');
	 				
	 				//to update OT charges directly for hope
	 				$saveData[1]['opt_appointment_id'] = $lastInsertedId;
	 				$saveData[1]['user_type'] = "OT Charges";
	 				$saveData[1]['tariff_list_id'] = $this->TariffList->getServiceIdByServiceName(Configure::read('otcharge')); 
	 				$saveData[1]['cost'] = $otChargesCost ;
	 				
	 				$this->OptAppointmentDetail->saveAll($saveData);
	 				//$this->OptAppointment->updateAll(array('anaesthesia_cost'=>$anaesthesiaCost,'ot_charges'=>$otChargesCost),array('id'=>$lastInsertedId));
	 				if($allvar['procedurecomplete'] == 1){
	 					/* $this->ServiceBill->save($service);
	 					$serviceId=$this->ServiceBill->id; */
	 				}
	 				$otDetailId=$this->OptAppointmentDetail->id;
	 				$this->OptAppointmentDetail->updateAll(array('OptAppointmentDetail.service_bill_id'=>"'$serviceId'"),
	 						array('OptAppointmentDetail.id'=>$otDetailId));
	 				$this->ServiceBill->id='';
	 				$this->OptAppointmentDetail->id='';
 				}   
	     	//EOF anaesthesia cost 
	     	$ret['IsSuccess'] = true;
	     	
	     	$ret['Msg'] = 'OT Appointment Updated.';
			
				//BOF-Mahalaxmi-After OptAppointment to  get sms alert for Patient as well as Physician//
				
				$smsActive=$this->Configuration->getConfigSmsValue('OT Appointment');	
				//$getEnableFeatureChk=true;
				if($smsActive){
	 				//if($getEnableFeatureChk){
						$this->Surgery->bindModel(array(
							'belongsTo' => array(
								'Patient' =>array(/*'type'=>'INNER',*/'foreignKey' => false,'conditions'=>array('Patient.id'=>$allvar['patient_name_value'])),					
								'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id')),	
								'User' =>array('foreignKey' => false,'conditions'=>array('User.id'=>$allvar['department_id'])),
								'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
								'Ward' =>array('foreignKey' => false,'conditions'=>array('Ward.id=Patient.ward_id')),	
								'Opt' =>array('foreignKey' => false,'conditions'=>array('Opt.id'=>$allvar['opt_id'])),		
						)));
						$personDataId = $this->Surgery->Find('all',array('fields'=>array('Ward.name','Opt.name','User.first_name','User.last_name','TariffStandard.name','Person.mobile','Surgery.name','Patient.lookup_name','Patient.age','Patient.sex','Patient.diagnosis_txt','User.mobile','Patient.person_id'),'conditions'=>array('Surgery.id'=>$allSurgeryData['surgery_id'])));	
						
						if(!empty($personDataId[0]['User']['first_name']) || !empty($personDataId[0]['User']['last_name'])){
							$getFullUserNameAnasthestist=$personDataId[0]['User']['first_name']." ".$personDataId[0]['User']['last_name'];
						}
						$userOTAssistantData = $this->User->getOTAssisatantUser();	
						
						foreach ($userOTAssistantData as $key => $value) {
							$getOTAssistantMobNo[]=$value['User']['mobile'];
						}		
						
						#$getOTASSistantMobileNO[0]=$userOTAssistantData[0]['User']['mobile'];					
						$getAnasthesistIdArr[0]=$personDataId[0]['User']['mobile'];		
									
						$getMergeArrFinalDoctor=array_merge($getOTAssistantMobNo,$getAnasthesistIdArr);
						$getMergeArrFinalDoctor=array_filter($getMergeArrFinalDoctor);
						$getOTAssAnasthNo=implode(',',$getMergeArrFinalDoctor);
					
					//User
						foreach($personDataId as $keyPersonId=>$personDataIds){
							$personDataIds['Surgery']['name'] = str_replace ('&','and', $personDataIds['Surgery']['name']);	
							$surgeryNameArr[$keyPersonId]=trim($personDataIds['Surgery']['name']);
						}
						$getSexPatient=strtoUpper(substr($personDataId['0']['Patient']['sex'],0,1));
						$getsurgeryNameArr=implode(",",$surgeryNameArr);		
						$getAgeResultSms=$this->General->convertYearsMonthsToDaysSeparate($personDataId['0']['Patient']['age']);
						$getDateTime=$st;
						$getExplodeData=explode(' ',$getDateTime);
						$getExplodeDate =DateFormatComponent::formatDate2LocalForReport($getExplodeData[0],Configure::read('date_format'));
						$getExplodeData2=date("h:i A", strtotime($getExplodeData[1]));					
						if(!empty($getsurgeryNameArr) && strtotime($st) > strtotime(date('Y-m-d H:i:s'))){				
						//BOF -For Send Sms to Physician only					
							$getDocIDs=array();					
							foreach($allSurgeryData['surgery_id'] as $key => $data){				
								$surgeryName= $this->Surgery->Find('first',array('fields'=>array('Surgery.name'),'conditions'=>array('Surgery.id'=>$allSurgeryData['surgery_id'][$key])));		
								$surgeryName['Surgery']['name'] = str_replace ('&','and', $surgeryName['Surgery']['name']);
								$showPhysicianNo= sprintf(Configure::read('OTPhysicianNO'),$surgeryName['Surgery']['name'],$personDataId[0]['TariffStandard']['name'],$personDataId[0]['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms,$getExplodeDate,$getExplodeData2,$personDataId[0]['Opt']['name'],Configure::read('hosp_details'));								
								foreach($allSurgeryData['doctor_id'][$key] as $docKey => $val){								
									$getDocIDs[]=$val;
								}
								$userDocMobnoData = $this->User->getAllUserById($getDocIDs);										
								$this->Message->sendToSms($showPhysicianNo,$userDocMobnoData[0]); //for Surgery allot for patient to send sms Physician No.									
							}					
							$showOTAssAnasthesiaNo= sprintf(Configure::read('OTAnasthestistOTAssistantNO'),$getsurgeryNameArr,$personDataId[0]['TariffStandard']['name'],$personDataId[0]['Patient']['lookup_name'],$getSexPatient,$personDataId[0]['Ward']['name'],$getAgeResultSms,$getExplodeDate,$getExplodeData2,$userDocMobnoData[1],$personDataId[0]['Opt']['name']);
										
							$getSmsResultFlag=$this->Message->sendToSms($showOTAssAnasthesiaNo,$getOTAssAnasthNo); //for Surgery allot for patient to send sms Physician No.
						
							//EOF -For Send Sms to Physician only/	
							//BOF -For Send Sms to Owner only/		
				
							if(!empty($personDataId[0]['Patient']['diagnosis_txt'])){								
								if(empty($getFullUserNameAnasthestist)){
									$showOwnerOt= sprintf(Configure::read('OwnerOTWithoutAnas'),$personDataId[0]['TariffStandard']['name'],$personDataId[0]['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms,$personDataId[0]['Patient']['diagnosis_txt'],$getExplodeDate,$getExplodeData2,$userDocMobnoData[1],$getsurgeryNameArr,$personDataId[0]['Opt']['name']);
								}else{
			 						$showOwnerOt= sprintf(Configure::read('OwnerOT'),$personDataId[0]['TariffStandard']['name'],$personDataId[0]['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms,$personDataId[0]['Patient']['diagnosis_txt'],$getExplodeDate,$getExplodeData2,$userDocMobnoData[1],$getFullUserNameAnasthestist,$getsurgeryNameArr,$personDataId[0]['Opt']['name']);
								}
			 				}else{
								if(!empty($getFullUserNameAnasthestist)){						
									$showOwnerOt= sprintf(Configure::read('OwnerOTWithoutdia'),$personDataId[0]['TariffStandard']['name'],$personDataId[0]['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms,$getExplodeDate,$getExplodeData2,$userDocMobnoData[1],$getFullUserNameAnasthestist,$getsurgeryNameArr,$personDataId[0]['Opt']['name']);
								}else{
									$showOwnerOt= sprintf(Configure::read('OwnerOTWithoutdiaAnas'),$personDataId[0]['TariffStandard']['name'],$personDataId[0]['Patient']['lookup_name'],$getSexPatient,$getAgeResultSms,$getExplodeDate,$getExplodeData2,$userDocMobnoData[1],$getsurgeryNameArr,$personDataId[0]['Opt']['name']);
									
								}
			 				}					
							$this->Message->sendToSms($showOwnerOt,Configure::read('owner_no')); //for Surgery allot for patient to send sms owner					
							//EOF -For Send Sms to Owner only/	
							///BOF -For Send Sms to Patient only/	
							$showPatientNo= sprintf(Configure::read('OTPatientNO'),$getExplodeDate,$getExplodeData2,$personDataId[0]['Opt']['name'],Configure::read('hosp_details'));					 				
							$this->Message->sendToSms($showPatientNo,$personDataId[0]['Person']['mobile']); //for Surgery allot for patient to send sms Patient Mobile No.
							//EOF -For Send Sms to Patient only//	
					
					}//EOF-Back dated	
					
				//EOF-Mahalaxmi-After OptAppointment to  get sms alert for Patient as well as Physician//	 				
	 				} //EOF-Sms_feature
	
	     }else{
	     	 $ret['IsSuccess'] = false;
	    	 $ret['Msg'] = "Unable to update this OT Appointment";
	     } 
	     $this->OptAppointment->deleteAll(array('OptAppointment.batch_identifier'=>$batchIdentifier));
	     $this->OptAppointmentDetail->deleteAll(array('OptAppointmentDetail.opt_appointment_id'=>$id));
		   }
			}
			}
		}catch(Exception $e){
			$ret['IsSuccess'] = false;
			//unset previous record
			$this->OptAppointment->updateAll(array('OptAppointment.is_deleted'=>'0'),array('OptAppointment.batch_identifier'=>$batchIdentifier));
			//delete new record
			$this->OptAppointment->deleteAll(array('OptAppointment.id'=>$lastInsertedIDS));
			$ret['Msg'] = $e->getMessage();
		}
		return $ret;
	}


	/**
	 * remove event calendar.
	 *
	 */
	/* public function removeCalendar($id){
		$this->loadModel('OptAppointment');
		$ret = array();
		try{
			$this->request->data['OptAppointment']['id'] = $id;
			$this->request->data['OptAppointment']['is_deleted'] = 1;
			$checkSave = $this->OptAppointment->save($this->request->data);
			if(!$checkSave){
				$ret['IsSuccess'] = false;
				$ret['Msg'] = "Unable to delete this OT Appointment";
			}else{
				$ret['IsSuccess'] = true;
				$ret['Msg'] = 'OT Appointment Deleted';
			}
		}catch(Exception $e){
			$ret['IsSuccess'] = false;
			$ret['Msg'] = $e->getMessage();
		}
		return $ret;
	} */
	
	
	/**
	 * remove event calendar. by swapnil on 21.09.2015
	 *
	 */
	public function removeCalendar($id){
		$this->loadModel('OptAppointment');
		$this->loadModel('OptAppointmentDetail');
		$ret = array();
		try{ 
			$optAppData = $this->OptAppointment->find('first',array('conditions'=>array('OptAppointment.id'=>$id)));
			$batchIdentifier = $optAppData['OptAppointment']['batch_identifier']; 
			$checkSave = $this->OptAppointment->updateAll(array('OptAppointment.is_deleted'=>'1'),array('OptAppointment.batch_identifier IS NOT NULL','OptAppointment.batch_identifier'=>$batchIdentifier));
			if(!$checkSave){
				$this->OptAppointmentDetail->updateAll(array('OptAppointmentDetail.is_deleted'=>'1'),array('OptAppointmentDetail.opt_appointment_id'=>$id));
				$ret['IsSuccess'] = false;
				$ret['Msg'] = "Unable to delete this OT Appointment";
			}else{
				$ret['IsSuccess'] = true;
				$ret['Msg'] = 'OT Appointment Deleted';
			}
		}catch(Exception $e){
			$ret['IsSuccess'] = false;
			$ret['Msg'] = $e->getMessage();
		}
		return $ret;
	}

	/**
	 * internal url for for converting js to php time
	 *
	 */
	public function js2PhpTime($jsdate){

		if(preg_match('@(\d+)/(\d+)/(\d+)\s+(\d+):(\d+)@', $jsdate, $matches)==1){
			$ret = mktime($matches[4], $matches[5], 0,$matches[1], $matches[2],  $matches[3]);
			//echo $matches[4] ."-". $matches[5] ."-". 0  ."-". $matches[1] ."-". $matches[2] ."-". $matches[3];
		}else if(preg_match('@(\d+)/(\d+)/(\d+)@', $jsdate, $matches)==1){
			$ret = mktime(0, 0, 0, $matches[1], $matches[2],  $matches[3]);
			//echo 0 ."-". 0 ."-". 0 ."-". $matches[1] ."-". $matches[2] ."-". $matches[3];
		}

		return $ret;
	}

	/**
	 * internal url for for converting php to js time
	 *
	 */
	public function php2JsTime($phpDate){
		//echo $phpDate;
		//return "/Date(" . $phpDate*1000 . ")/";
		//$convertPhpDate = $this->DateFormat->formatDate2STD($phpDate,Configure::read('date_format'));
		return date("m/d/Y H:i", $phpDate);
		//return date("m/d/Y H:i", $convertPhpDate);
	}

	/**
	 * internal url for for converting php to mysql time
	 *
	 */
	public function php2MySqlTime($phpDate){
		//$convertPhpDate = $this->DateFormat->formatDate2STD($phpDate,Configure::read('date_format'));
		return date("Y-m-d H:i:s", $phpDate);
		//return date("Y-m-d H:i:s", $convertPhpDate);
	}

	/**
	 * internal url for for converting php to mysql time
	 *
	 */
	public function mySql2PhpTime($sqlDate){
		$arr = date_parse($sqlDate);
		return mktime($arr["hour"],$arr["minute"],$arr["second"],$arr["month"],$arr["day"],$arr["year"]);
	}
	/**
	 *
	 * ot home page
	 *
	 **/
	public function search(){
		$this->uses = array('Patient');
		$this->set('data','');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'Patient.create_time' => 'DESC'
				)
		);
		#pr($this->params);
		$role = $this->Session->read('role');
		$search_key['Patient.is_deleted'] = 0;
		if($role == 'admin'){
			#	$search_key['Location.facility_id']=$this->Session->read('facilityid');
			$this->Patient->bindModel(array(
			'belongsTo' => array(

			'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
			'Location' =>array('foreignKey' => 'location_id'),
			'Initial' =>array('foreignKey' => false,'conditions'=>array('User.initial_id=Initial.id' )),
			'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
			'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
			'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id =Patient.department_id' )),
			)),false);
		}else{
			$search_key['Patient.location_id']=$this->Session->read('locationid');
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
							'Initial' =>array('foreignKey' => false,'conditions'=>array('User.initial_id=Initial.id' )),
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
							'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id =Patient.department_id' )),
					)),false);
		}


		if(!empty($this->params->query)){
			$search_ele = $this->params->query  ;//make it get


			$search_ele['lookup_name'] = explode(" ",$search_ele['lookup_name']);
			if(count($search_ele['lookup_name']) > 1){
				$search_key['SOUNDEX(Person.first_name) like'] = "%".soundex(trim($search_ele['lookup_name'][0]))."%";
				$search_key['SOUNDEX(Person.last_name) like'] = "%".soundex(trim($search_ele['lookup_name'][1]))."%";
			}else if(count($search_ele['lookup_name)']) == 0){
				$search_key['OR'] = array(
						'SOUNDEX(Person.first_name)  like'  => "%".soundex(trim($search_ele['lookup_name'][0]))."%",
						'SOUNDEX(Person.last_name)   like'  => "%".soundex(trim($search_ele['lookup_name'][0]))."%");
			}if(!empty($search_ele['patient_id'])){
				$search_key['Patient.patient_id like '] = "%".trim($search_ele['patient_id']) ;
			}if(!empty($search_ele['admission_id'])){
				$search_key['Patient.admission_id like '] = "%".trim($search_ele['admission_id']) ;
			}if(!empty($search_ele['dob'])){
				$search_key['Person.dob like '] = "%".trim(substr($this->DateFormat->formatDate2STD($search_ele['dob'],Configure::read('date_format')),0,10));
			}if(!empty($search_ele['ssn_us'])){
				$search_key['Person.ssn_us like '] = "%".trim($search_ele['ssn_us'])."%" ; ;
			}
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('Patient.create_time' => 'DESC'),
					'fields'=> array('Patient.form_received_on, CONCAT(PatientInitial.name," ",Patient.lookup_name) as lookup_name,
							Patient.id,Department.name,Patient.sex,Patient.patient_id,Person.ssn_us,Person.dob,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(Initial.name," ",User.first_name," ",User.last_name) as name, Patient.create_time'),
					'conditions'=>array($search_key,'Patient.is_discharge'=>0,'Patient.admission_type'=>'IPD')
			);
			/*$data = $this->paginate('Patient',array('conditions'=>$search_key,'fields'=>
			 array('Patient.full_name,Patient.mobile,Patient.home_phone,CONCAT(User.first_name,",",User.last_name) as full.name') ));*/
			$this->set('data',$this->paginate('Patient'));

		}else{

			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('Patient.create_time' => 'DESC'),
					'fields'=> array('Patient.form_received_on, CONCAT(PatientInitial.name," ",Patient.lookup_name) as lookup_name,
							Patient.id,Patient.sex,Department.name,Patient.patient_id,Person.ssn_us,Person.dob,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(Initial.name," ",User.first_name," ",User.last_name) as name, Patient.create_time'),
					'conditions'=>array($search_key,'Patient.is_discharge'=>0,'Patient.admission_type'=>'IPD')
			);
			//pr($this->paginate('Patient'));exit;
			$this->set('data',$this->paginate('Patient'));

		}
	}

	/**
	 *
	 * ot patient dashboard
	 *
	 **/
	public function patient_information($id=null) {
		if(!empty($id)){
			$this->patient_info($id);
		}else{
			$this->redirect(array("controller" => "patients", "action" => "index"));
		}
	}

	/**
	 * anaesthesia consent
	 *
	 */
	public function anaesthesia_consent($patientid=null) {
		//$this->layout = "ajax";
		$this->loadModel('AnaesthesiaConsentForm');
		$this->set('title_for_layout', __('Anaesthesia Consent Form', true));
		$this->patient_info($patientid);
		$this->AnaesthesiaConsentForm->bindModel(array('belongsTo' => array('User' =>array('foreignKey' => false, 'conditions' => array('User.id=  AnaesthesiaConsentForm.anaesthesiologist_name')),'Initial' =>array('foreignKey' => false, 'conditions' => array('Initial.id=  User.initial_id')))));
		$this->paginate = array('limit' => Configure::read('number_of_rows'),
				'conditions' => array('AnaesthesiaConsentForm.patient_id' => $patientid, 'AnaesthesiaConsentForm.is_deleted' => 0,
						'AnaesthesiaConsentForm.location_id'=>$this->Session->read('locationid')));
		$data = $this->paginate('AnaesthesiaConsentForm');
		if(empty($data)){
				$this->redirect(array('action'=>'add_anaesthesia_consent',$patientid));			
		}else{
			$this->set('data', isset($data)?$data:'');
		}
		
	}

	/**
	 * view anaesthesia consent forms
	 *
	 */
	public function view_anaesthesia_consent($patientid = null) {
		$this->loadModel("AnaesthesiaConsentForm");
		$this->set('title_for_layout', __('Anaesthesia Consent Form', true));
		$this->patient_info($patientid);
		$this->AnaesthesiaConsentForm->bindModel(array('belongsTo' => array('User' =>array('foreignKey' => false, 'conditions' => array('User.id=  AnaesthesiaConsentForm.anaesthesiologist_name')),'Surgery' =>array('foreignKey' => false, 'conditions' => array('Surgery.id=  AnaesthesiaConsentForm.surgery_id')),'Initial' =>array('foreignKey' => false, 'conditions' => array('Initial.id=  User.initial_id')))));
		if (!$this->params['named']['anaid']) {
			$this->Session->setFlash(__('Invalid Anaesthesia Consent Form', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "anaesthesia_consent",$patientid));
		}
		$data  =$this->AnaesthesiaConsentForm->read(null, $this->params['named']['anaid']) ;
		$this->set('patientConsentDetails', $data);
	}


	/**
	 * delete function of anaesthesia consent form
	 *
	 */
	public function delete_anaesthesia_consent($patientid = null) {
		$this->loadModel("AnaesthesiaConsentForm");
		if (empty($this->params['named']['anaid'])) {
			$this->Session->setFlash(__('Invalid Id For Anaesthesia Consent Form', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "anaesthesia_consent",$patientid));
		}
		if (!empty($this->params['named']['anaid'])) {
			$this->AnaesthesiaConsentForm->id = $this->params['named']['anaid'];
			$this->request->data["AnaesthesiaConsentForm"]["id"] = $this->params['named']['anaid'];
			$this->request->data["AnaesthesiaConsentForm"]["is_deleted"] = "1";
			$this->AnaesthesiaConsentForm->save($this->request->data);
			$this->Session->setFlash(__('Anaesthesia Consent Form deleted', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "anaesthesia_consent", $patientid));
		}else {
			$this->Session->setFlash(__('This anaesthesia consent form  is associated with other details so you can not be delete this anaesthesia consent form', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "anaesthesia_consent", $patientid));
		}
	}

	/**
	 * ot pre preoperative checklist
	 *
	 */
	public function ot_pre_operative_checklist($patientid=null) {
		//$this->layout = "ajax";
		$this->loadModel('PreOperativeChecklist');
		$this->set('title_for_layout', __('Pre Operative CheckList', true));
		$this->patient_info($patientid);
		$this->paginate = array('limit' => Configure::read('number_of_rows'),
				'conditions' => array('PreOperativeChecklist.patient_id' => $patientid, 'PreOperativeChecklist.is_deleted' => 0,
						'PreOperativeChecklist.location_id'=>$this->Session->read('locationid')));
		$data = $this->paginate('PreOperativeChecklist');
		if(empty($data)){
			$this->redirect(array('action'=>'add_ot_pre_operative_checklist',$patientid));
		}else{
			$this->set('data', isset($data)?$data:'');
		}
		
	}

	/**
	 * view anaesthesia consent forms
	 *
	 */
	public function view_ot_pre_operative_checklist($patientid = null) {
		$this->loadModel("PreOperativeChecklist");
		$this->set('title_for_layout', __('OT Pre Operative Checklist Form', true));
		$this->patient_info($patientid);
		$this->PreOperativeChecklist->bindModel(array('belongsTo' => array('Surgery' =>array('foreignKey' => false, 'conditions' => array('Surgery.id=PreOperativeChecklist.surgery_id')))));
		if (!$this->params['named']['otpcid']) {
			$this->Session->setFlash(__('Invalid OT Pre Operative Checklist Form', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "ot_pre_operative_checklist",$patientid));
		}
		$data  =$this->PreOperativeChecklist->read(null, $this->params['named']['otpcid']) ;
		$this->set('patientPOCheckListDetails', $data);
	}


	/**
	 * delete function of ot pre operative checklist form
	 *
	 */
	public function delete_ot_pre_operative_checklist($patientid = null) {
		$this->loadModel("PreOperativeChecklist");
		if (empty($this->params['named']['otpcid'])) {
			$this->Session->setFlash(__('Invalid OT Pre Operative Checklist Form', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "ot_pre_operative_checklist",$patientid));
		}
		if (!empty($this->params['named']['otpcid'])) {
			$this->PreOperativeChecklist->id = $this->params['named']['otpcid'];
			$this->request->data["PreOperativeChecklist"]["id"] = $this->params['named']['otpcid'];
			$this->request->data["PreOperativeChecklist"]["is_deleted"] = "1";
			$this->PreOperativeChecklist->save($this->request->data);
			$this->Session->setFlash(__('OT Pre Operative Checklist Form deleted', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "ot_pre_operative_checklist", $patientid));
		}else {
			$this->Session->setFlash(__('This OT Pre Operative Checklist is associated with other details so you can not be delete this OT Pre Operative Checklist Form', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "ot_pre_operative_checklist", $patientid));
		}
	}

	/**
	 * ot post operative checklist
	 *
	 */
	public function add_ot_post_operative_checklist($patientid=null) {
		//$this->layout = "ajax";
		$this->uses = array('User', 'Consultant', 'Note', 'Surgery');
		$this->set('title_for_layout', __('OT Post Operative Check List', true));
		if(empty($patientid)) {
			$this->redirect(array("controller" => "opt_appointments", "action" => "search"));
			exit;
		}
		if($this->params['named']['otpcid']) {
			$this->data = $this->Note->read(null, $this->params['named']['otpcid']);
		}
		$this->set('registrar',$this->User->getDoctorsByLocation($this->Session->read('locationid')));
		$this->set('consultant',$this->Consultant->getRegistrar());
		$this->patient_info($patientid);
		$this->Surgery->bindModel(array('hasOne' => array('OptAppointment' =>array('foreignKey' => 'surgery_id'))));
		$this->set('surgeries', $this->Surgery->find('list', array('conditions' => array('Surgery.location_id' => $this->Session->read('locationid'), 'Surgery.is_deleted' => 0, 'OptAppointment.patient_id' => $patientid), 'recursive' => 1)));
	}

	/**
	 * save ot post operative checklist
	 *
	 */
	public function save_ot_post_operative_checklist() {
		$this->uses =array("Note");
		if ($this->request->is('post') || $this->request->is('put')) {
			if(empty($this->request->data['Note']['patient_id'])) {
				$this->redirect(array("controller" => "opt_appointments", "action" => "search"));
				exit;
			}
			// for update //
			if($this->request->data['Note']['id']) {
				$this->Note->id = $this->request->data['Note']['id'];
			}
			//converting date to standard format
			if(!empty($this->request->data["Note"]['note_date'])){
				$last_split_date_time =  $this->request->data['Note']['note_date'];
				$this->request->data["Note"]['note_date'] = $this->DateFormat->formatDate2STD($last_split_date_time,Configure::read('date_format'));
			}
			if($this->Note->save($this->request->data)){
				$this->Session->setFlash(__('Patient Note Added Successfully' ),true,array('class'=>'message'));
				$this->redirect("/opt_appointments/ot_post_operative_checklist/".$this->request->data['Note']['patient_id']);
			}else{
				$this->Session->setFlash(__('Please Try Again' ),true,array('class'=>'error'));
			}
		}
	}

	/**
	 * ot post operative checklist
	 *
	 */
	public function ot_post_operative_checklist($patientid=null) {
		//$this->layout = "ajax";
		$this->loadModel('Note');
		$this->set('title_for_layout', __('Post Operative CheckList', true));
		if(empty($patientid)) {
			$this->redirect(array("controller" => "opt_appointments", "action" => "search"));
			exit;
		}
		$this->patient_info($patientid);
		$this->Note->bindModel(array('belongsTo' => array(
				'Patient' =>array('foreignKey'=>'patient_id'),
				'User' =>array('foreignKey'=>'sb_registrar'),
				'Doctor' =>array('foreignKey'=>'sb_consultant'),
				'Surgery' =>array('foreignKey'=>false, 'conditions'=> array('Surgery.id=Note.surgery_id')),
				'Initial' =>array('foreignKey'=>false, 'conditions'=> array('Initial.id=User.initial_id')),
				'PatientInitial' =>array('foreignKey'=>false, 'conditions'=> array('PatientInitial.id=Doctor.initial_id')), // PatientInitial is alias for doctor initial name
		)),false);
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Note.id' => 'desc'),
				'fields'=> array('Initial.name','PatientInitial.name','Note.id', 'Note.note', 'Note.note_type', 'Note.created_by', 'Note.note_date', 'Note.create_time', 'Surgery.name', 'CONCAT(User.first_name, " ", User.last_name) as doctor_name','CONCAT(Doctor.first_name, " ", Doctor.last_name) as registrar'),
				'conditions'=>array('Note.patient_id'=>$patientid,'Note.note_type ='=>'post-operative')
		);
		$data = $this->paginate('Note');
		if(empty($data)){
			$this->redirect(array('action'=>'add_ot_post_operative_checklist',$patientid));
		}else{
			$this->set('data',$data);
		}
		
		
	}

	/**
	 * view post operative checklist
	 *
	 */
	public function view_ot_post_operative_checklist($patientid = null) {
		$this->loadModel("Note");
		$this->set('title_for_layout', __('Post Operative Checklist Form', true));
		if(empty($patientid)) {
			$this->redirect(array("controller" => "opt_appointments", "action" => "search"));
			exit;
		}
		$this->patient_info($patientid);
		$this->Note->bindModel(array('belongsTo' => array(
				'Patient' =>array('foreignKey'=>'patient_id'),
				'User' =>array('foreignKey'=>'sb_registrar'),
				'Doctor' =>array('foreignKey'=>'sb_consultant'),
				'Surgery' =>array('foreignKey'=>false, 'conditions' => array('Surgery.id=Note.surgery_id')),
				'Initial' =>array('foreignKey'=>false, 'conditions'=> array('Initial.id=User.initial_id')),
				'PatientInitial' =>array('foreignKey'=>false, 'conditions'=> array('PatientInitial.id=Doctor.initial_id')), // PatientInitial is alias for doctor initial name
		)),false);
		if (!$this->params['named']['otpcid']) {
			$this->Session->setFlash(__('Invalid Post Operative Checklist Form', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "ot_post_operative_checklist",$patientid));
		}
		$data = $this->Note->find('first', array('conditions' => array('Note.id' => $this->params['named']['otpcid']), 'fields' => array('Initial.name','PatientInitial.name','Note.id', 'Note.post_opt', 'Note.note_type', 'Surgery.name', 'Note.created_by', 'Note.note_date', 'Note.create_time','CONCAT(User.first_name, " ", User.last_name) as doctor_name','CONCAT(Doctor.first_name, " ", Doctor.last_name) as registrar'), 'recursive' => 1)) ;
		$this->set('patientPOCheckListDetails', $data);
	}


	/**
	 * delete function of ot post operative checklist form
	 *
	 */
	public function delete_ot_post_operative_checklist($patientid = null) {
		$this->loadModel("Note");
		if(empty($patientid)) {
			$this->redirect(array("controller" => "opt_appointments", "action" => "search"));
			exit;
		}
		if (empty($this->params['named']['otpcid'])) {
			$this->Session->setFlash(__('Invalid Post Operative Checklist Form', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "ot_post_operative_checklist",$patientid));
		}
		if (!empty($this->params['named']['otpcid'])) {
			//$this->Note->id = $this->params['named']['otpcid'];
			//$this->request->data["Note"]["id"] = $this->params['named']['otpcid'];
			//$this->request->data["Note"]["is_deleted"] = "1";
			$this->Note->delete($this->Note->id = $this->params['named']['otpcid']);
			$this->Session->setFlash(__('Post Operative Checklist Form Deleted', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "ot_post_operative_checklist", $patientid));
		}else {
			$this->Session->setFlash(__('This Post Operative Checklist is associated with other details so you can not be delete this Post Operative Checklist Form', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "ot_post_operative_checklist", $patientid));
		}
	}

	/**
	 * ot surgical safety checklist
	 *
	 */
	public function surgical_safety_checklist($patientid=null) {
		//$this->layout = "ajax";
		$this->loadModel('SurgicalSafetyChecklist');
		$this->set('title_for_layout', __('Surgical Safety Checklist', true));
		$this->patient_info($patientid);
		$this->SurgicalSafetyChecklist->bindModel(array('belongsTo' => array(
				'Surgery' =>array('foreignKey'=>false, 'conditions' => array('Surgery.id=SurgicalSafetyChecklist.surgery_id')),
		)),false);
		$this->paginate = array('limit' => Configure::read('number_of_rows'),
				'conditions' => array('SurgicalSafetyChecklist.patient_id' => $patientid, 'SurgicalSafetyChecklist.is_deleted' => 0,
						'SurgicalSafetyChecklist.location_id'=>$this->Session->read('locationid')), 'fields' => array('Surgery.name','SurgicalSafetyChecklist.signin_confirmed','SurgicalSafetyChecklist.create_time', 'SurgicalSafetyChecklist.id'));
		$data = $this->paginate('SurgicalSafetyChecklist');
		
		if(empty($data)){
			$this->redirect(array('action'=>'add_surgical_safety_checklist',$patientid));
		}else{
			$this->set('data', isset($data)?$data:'');
		}
		
	}

	/**
	 * add surgical safety checklist
	 *
	 */
	public function add_surgical_safety_checklist($patientid=null) {
		//$this->layout = "ajax";
		$this->uses = array('SurgicalSafetyChecklist','Surgery');
		$this->patient_info($patientid);
		if(isset($this->params['named']['sscid'])) {
			$this->set('title_for_layout', __('Surgical Safety Checklist', true));
			$patientSSCheckListDetails = $this->SurgicalSafetyChecklist->find('first', array('conditions' => array('SurgicalSafetyChecklist.id' => $this->params['named']['sscid'], 'SurgicalSafetyChecklist.location_id' => $this->Session->read('locationid'), 'SurgicalSafetyChecklist.is_deleted' => 0)));
			$this->set('patientSSCheckListDetails', isset($patientSSCheckListDetails)?$patientSSCheckListDetails:'');
		}
		$this->Surgery->bindModel(array('hasOne' => array('OptAppointment' =>array('foreignKey' => 'surgery_id'))));
		$this->set('surgeries', $this->Surgery->find('list', array('conditions' => array('Surgery.location_id' => $this->Session->read('locationid'), 'Surgery.is_deleted' => 0, 'OptAppointment.patient_id' => $patientid), 'recursive' => 1)));
	}


	/**
	 * print surgical safety checklist
	 *
	 */
	public function print_surgical_safety_checklist($id=null, $patientid=null) {
		$this->loadModel('SurgicalSafetyChecklist');
		$this->patient_info($patientid);
		$this->SurgicalSafetyChecklist->bindModel(array('belongsTo' => array(
				'Surgery' =>array('foreignKey'=>false, 'conditions' => array('Surgery.id=SurgicalSafetyChecklist.surgery_id')),
		)),false);
		$patientSSCheckListDetails = $this->SurgicalSafetyChecklist->find('first', array('conditions' => array('SurgicalSafetyChecklist.id' => $id, 'SurgicalSafetyChecklist.location_id' => $this->Session->read('locationid'), 'SurgicalSafetyChecklist.is_deleted' => 0) , 'recursive' => 1));
		$this->Patient->bindModel(array(
				'belongsTo' => array(						
						'Room' =>array('foreignKey' => false,'conditions'=>array('Room.id=Patient.room_id' )),
						'Bed' =>array('foreignKey' => false,'conditions'=>array('Bed.id=Patient.bed_id' )),
						)));
		$patientData=$this->Patient->find('first',array('fields'=>array('Room.bed_prefix','Bed.bedno'),'conditions'=>array('Patient.id'=>$patientid,'Patient.is_deleted'=>0)));
		$this->set('patientData', $patientData);
		$this->set('patientSSCheckListDetails', $patientSSCheckListDetails);
		$this->layout = 'print_with_header';
	}

	/**
	 * save surgical safety checklist
	 *
	 */
	public function saveSurgicalSafetyChecklist() {
		$this->uses = array("SurgicalSafetyChecklist");
		if ($this->request->is('post') || $this->request->is('put')) {
			if(!empty($this->request->data["SurgicalSafetyChecklist"]['pre_date'])){
				$last_split_date_time =  $this->request->data['SurgicalSafetyChecklist']['pre_date'];
				$this->request->data["SurgicalSafetyChecklist"]['pre_date'] = $this->DateFormat->formatDate2STD($last_split_date_time,Configure::read('date_format'));
			}
			// for update functionality //
			if($this->request->data['SurgicalSafetyChecklist']['id']) {
				$this->SurgicalSafetyChecklist->id = $this->request->data['SurgicalSafetyChecklist']['id'];
			}
			$this->request->data["SurgicalSafetyChecklist"]["create_time"] = date("Y-m-d H:i:s");
			$this->request->data["SurgicalSafetyChecklist"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["SurgicalSafetyChecklist"]["created_by"] = $this->Session->read('userid');
			$this->request->data["SurgicalSafetyChecklist"]["modified_by"] = $this->Session->read('userid');
			$this->request->data["SurgicalSafetyChecklist"]["location_id"] = $this->Session->read('locationid');
			$this->SurgicalSafetyChecklist->save($this->request->data);
			$this->Session->setFlash(__('Surgical Safety Checklist Saved.', true));
		}

		$this->redirect(array("action" => "surgical_safety_checklist", $this->request->data["SurgicalSafetyChecklist"]["patient_id"]));
		exit;
	}


	/**
	 * view surgical safety checklist
	 *
	 */
	public function view_surgical_safety_checklist($patientid = null) {
		$this->loadModel("SurgicalSafetyChecklist");
		$this->set('title_for_layout', __('Surgical Safety Checklist', true));
		$this->patient_info($patientid);
		$this->SurgicalSafetyChecklist->bindModel(array('belongsTo' => array(
				'Surgery' =>array('foreignKey'=>false, 'conditions' => array('Surgery.id=SurgicalSafetyChecklist.surgery_id')),
		)),false);
		if (!$this->params['named']['sscid']) {
			$this->Session->setFlash(__('Invalid Surgical Safety Checklist', true));
			$this->redirect(array("action" => "surgical_safety_checklist",$patientid));
		}
		$data  =$this->SurgicalSafetyChecklist->read(null, $this->params['named']['sscid']) ;
		$this->set('patientSSCheckListDetails', $data);
	}


	/**
	 * delete surgical safety checklist
	 *
	 */
	public function delete_surgical_safety_checklist($patientid = null) {
		$this->loadModel("SurgicalSafetyChecklist");
		if (empty($this->params['named']['sscid'])) {
			$this->Session->setFlash(__('Invalid Surgical Safety Checklist', true));
			$this->redirect(array("action" => "surgical_safety_checklist",$patientid));
		}
		if (!empty($this->params['named']['sscid'])) {
			$this->SurgicalSafetyChecklist->id = $this->params['named']['sscid'];
			$this->request->data["SurgicalSafetyChecklist"]["id"] = $this->params['named']['sscid'];
			$this->request->data["SurgicalSafetyChecklist"]["is_deleted"] = "1";
			$this->SurgicalSafetyChecklist->save($this->request->data);
			$this->Session->setFlash(__('Surgical Safety Checklist Deleted', true));
			$this->redirect(array("action" => "surgical_safety_checklist", $patientid));
		}else {
			$this->Session->setFlash(__('This Surgical Safety Checklist is associated with other details so you can not be delete this Surgical Safety Checklist', true));
			$this->redirect(array("action" => "surgical_safety_checklist", $patientid));
		}
	}

	/**
	 * add surgery notes
	 *
	 */
	public function add_surgery_notes($patientid=null) {
		//$this->layout = "ajax";
		$this->uses = array('User', 'Consultant', 'Note', 'Surgery');
		$this->set('title_for_layout', __('Add Surgery Note', true));
		if(empty($patientid)) {
			$this->redirect(array("controller" => "opt_appointments", "action" => "search"));
			exit;
		}
		if($this->params['named']['snid']) {
			$this->data = $this->Note->read(null, $this->params['named']['snid']);
		}
		$this->set('registrar',$this->User->getDoctorsByLocation($this->Session->read('locationid')));
		$this->set('consultant',$this->Consultant->getRegistrar());
		$this->patient_info($patientid);
		$this->Surgery->bindModel(array('hasOne' => array('OptAppointment' =>array('foreignKey' => 'surgery_id'))));
		$this->set('surgeries', $this->Surgery->find('list', array('conditions' => array('Surgery.location_id' => $this->Session->read('locationid'), 'Surgery.is_deleted' => 0, 'OptAppointment.patient_id' => $patientid), 'recursive' => 1)));
	}

	/**
	 * save surgery notes
	 *
	 */
	public function save_surgery_notes() {
		$this->uses =array("Note");
		if ($this->request->is('post') || $this->request->is('put')) {
			if(empty($this->request->data['Note']['patient_id'])) {
				$this->redirect(array("controller" => "opt_appointments", "action" => "search"));
				exit;
			}
			// for update //
			if($this->request->data['Note']['id']) {
				$this->Note->id = $this->request->data['Note']['id'];
			}
			//converting date to standard format
			if(!empty($this->request->data["Note"]['note_date'])){
				$last_split_date_time =  $this->request->data['Note']['note_date'];
				$this->request->data["Note"]['note_date'] = $this->DateFormat->formatDate2STD($last_split_date_time,Configure::read('date_format'));
			}
			if($this->Note->save($this->request->data)){
				$this->Session->setFlash(__('Surgery Note Added Successfully' ),true,array('class'=>'message'));
				$this->redirect("/opt_appointments/surgery_notes/".$this->request->data['Note']['patient_id']);
			}else{
				$this->Session->setFlash(__('Please Try Again' ),true,array('class'=>'error'));
			}
		}
	}

	/**
	 * surgery notes
	 *
	 */
	public function surgery_notes($patientid=null) {
		//$this->layout = "ajax";
		$this->loadModel('Note');
		$this->set('title_for_layout', __('Surgery Notes', true));
		if(empty($patientid)) {
			$this->redirect(array("controller" => "opt_appointments", "action" => "search"));
			exit;
		}
		$this->patient_info($patientid);
		$this->Note->bindModel(array('belongsTo' => array(
				'Patient' =>array('foreignKey'=>'patient_id'),
				'User' =>array('foreignKey'=>'sb_registrar'),
				'Doctor' =>array('foreignKey'=>'sb_consultant'),
				'Surgery' =>array('foreignKey'=>false, 'conditions' => array('Surgery.id=Note.surgery_id')),
				'Initial' =>array('foreignKey'=>false, 'conditions'=> array('Initial.id=User.initial_id')),
				'PatientInitial' =>array('foreignKey'=>false, 'conditions'=> array('PatientInitial.id=Doctor.initial_id')), // PatientInitial is alias for doctor initial name
		)),false);
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Note.id' => 'desc'),
				'fields'=> array('Initial.name', 'PatientInitial.name', 'Note.id', 'Note.note', 'Note.note_type', 'Note.created_by', 'Note.note_date', 'Note.create_time', 'Surgery.name', 'CONCAT(User.first_name, " ", User.last_name) as doctor_name','CONCAT(Doctor.first_name, " ", Doctor.last_name) as registrar'),
				'conditions'=>array('Note.patient_id'=>$patientid,'Note.note_type ='=>'OT')
		);
		$data =$this->paginate('Note');
		
		if(empty($data)){
			$this->redirect(array('action'=>'add_surgery_notes',$patientid));
		}else{
			$this->set('data', isset($data)?$data:'');
		}
	}

	/**
	 * view surgery notes
	 *
	 */
	public function view_surgery_notes($patientid = null) {
		$this->loadModel("Note");
		$this->set('title_for_layout', __('View Surgery Note', true));
		if(empty($patientid)) {
			$this->redirect(array("controller" => "opt_appointments", "action" => "search"));
			exit;
		}
		$this->patient_info($patientid);
		$this->Note->bindModel(array('belongsTo' => array(
				'Patient' =>array('foreignKey'=>'patient_id'),
				'User' =>array('foreignKey'=>'sb_registrar'),
				'Doctor' =>array('foreignKey'=>'sb_consultant'),
				'Surgery' =>array('foreignKey'=>false, 'conditions' => array('Surgery.id=Note.surgery_id')),
				'Initial' =>array('foreignKey'=>false, 'conditions'=> array('Initial.id=User.initial_id')),
				'PatientInitial' =>array('foreignKey'=>false, 'conditions'=> array('PatientInitial.id=Doctor.initial_id')), // PatientInitial is alias for doctor initial name
		)),false);
		if (!$this->params['named']['snid']) {
			$this->Session->setFlash(__('Invalid Surgery Note', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "surgery_notes",$patientid));
		}
		$data = $this->Note->find('first', array('conditions' => array('Note.id' => $this->params['named']['snid']), 'fields' => array('Initial.name', 'PatientInitial.name', 'Note.id', 'Note.surgery','Note.surgery_note_type', 'Note.note_type', 'Note.created_by', 'Note.note_date', 'Note.create_time','Surgery.name', 'CONCAT(User.first_name, " ", User.last_name) as doctor_name','CONCAT(Doctor.first_name, " ", Doctor.last_name) as registrar'), 'recursive' => 1)) ;
		$this->set('patientSurgeryNotes', $data);
	}


	/**
	 * delete surgery notes
	 *
	 */
	public function delete_surgery_notes($patientid = null) {
		$this->loadModel("Note");
		if(empty($patientid)) {
			$this->redirect(array("controller" => "opt_appointments", "action" => "search"));
			exit;
		}
		if (empty($this->params['named']['snid'])) {
			$this->Session->setFlash(__('Invalid Surgery Note', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "surgery_notes",$patientid));
		}
		if (!empty($this->params['named']['snid'])) {
			//$this->Note->id = $this->params['named']['otpcid'];
			//$this->request->data["Note"]["id"] = $this->params['named']['otpcid'];
			//$this->request->data["Note"]["is_deleted"] = "1";
			$this->Note->delete($this->Note->id = $this->params['named']['snid']);
			$this->Session->setFlash(__('Surgery Note Deleted', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "surgery_notes", $patientid));
		}else {
			$this->Session->setFlash(__('This Surgery Note is associated with other details so you can not be delete this Surgery Note', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "surgery_notes", $patientid));
		}
	}

	/**
	 * add anaesthesia notes
	 *
	 */
	public function add_anaesthesia_notes($patientid=null) {
		//$this->layout = "ajax";
		$this->uses = array('User', 'Consultant', 'Note', 'Surgery');
		$this->set('title_for_layout', __('Add Anaesthesia Note', true));

		if(empty($patientid)) {
			$this->redirect(array("controller" => "opt_appointments", "action" => "search"));
			exit;
		}
		if($this->params['named']['anid']) {
			$this->data = $this->Note->read(null, $this->params['named']['anid']);
		}
		$this->set('registrar',$this->User->getDoctorsByLocation($this->Session->read('locationid')));
		$this->set('consultant',$this->Consultant->getRegistrar());
		$this->Surgery->bindModel(array('hasOne' => array('OptAppointment' =>array('foreignKey' => 'surgery_id'))));
		$this->set('surgeries', $this->Surgery->find('list', array('conditions' => array('Surgery.location_id' => $this->Session->read('locationid'), 'Surgery.is_deleted' => 0, 'OptAppointment.patient_id' => $patientid), 'recursive' => 1)));

		$this->patient_info($patientid);
	}

	/**
	 * save anaesthesia notes
	 *
	 */
	public function save_anaesthesia_notes() {
		$this->uses =array("Note");
		if ($this->request->is('post') || $this->request->is('put')) {
			if(empty($this->request->data['Note']['patient_id'])) {
				$this->redirect(array("controller" => "opt_appointments", "action" => "search"));
				exit;
			}
			// for update //
			if($this->request->data['Note']['id']) {
				$this->Note->id = $this->request->data['Note']['id'];
			}
			//converting date to standard format
			if(!empty($this->request->data["Note"]['note_date'])){
				$last_split_date_time =  $this->request->data['Note']['note_date'];
				$this->request->data["Note"]['note_date'] = $this->DateFormat->formatDate2STD($last_split_date_time,Configure::read('date_format'));
			}
			if($this->Note->save($this->request->data)){
				$this->Session->setFlash(__('Anaesthesia Note Added Successfully' ),true,array('class'=>'message'));
				$this->redirect("/opt_appointments/anaesthesia_notes/".$this->request->data['Note']['patient_id']);
			}else{
				$this->Session->setFlash(__('Please Try Again' ),true,array('class'=>'error'));
			}
		}
	}

	/**
	 * anaesthesia notes
	 *
	 */
	public function anaesthesia_notes($patientid=null) {
		//$this->layout = "ajax";
		$this->loadModel('Note');
		$this->set('title_for_layout', __('Anaesthesia Notes', true));
		if(empty($patientid)) {
			$this->redirect(array("controller" => "opt_appointments", "action" => "search"));
			exit;
		}

		$this->patient_info($patientid);
		$this->Note->bindModel(array('belongsTo' => array(
				'Patient' =>array('foreignKey'=>'patient_id'),
				'User' =>array('foreignKey'=>'sb_registrar'),
				'Doctor' =>array('foreignKey'=>'sb_consultant'),
				'Surgery' =>array('foreignKey'=>false, 'conditions' => array('Surgery.id=Note.surgery_id')),
				'Initial' =>array('foreignKey'=>false, 'conditions'=> array('Initial.id=User.initial_id')),
				'PatientInitial' =>array('foreignKey'=>false, 'conditions'=> array('PatientInitial.id=Doctor.initial_id')), // PatientInitial is alias for doctor initial name
		)),false);
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Note.id' => 'desc'),
				'fields'=> array('Initial.name', 'PatientInitial.name', 'Note.id', 'Note.note','Surgery.name', 'Note.note_type', 'Note.created_by', 'Note.note_date', 'Note.create_time','CONCAT(User.first_name, " ", User.last_name) as doctor_name','CONCAT(Doctor.first_name, " ", Doctor.last_name) as registrar'),
				'conditions'=>array('Note.patient_id'=>$patientid,'Note.note_type ='=>'anaesthesia')
		);
		
		$data =$this->paginate('Note');
		
		if(empty($data)){
			$this->redirect(array('action'=>'add_anaesthesia_notes',$patientid));
		}else{
			$this->set('data', isset($data)?$data:'');
		}
	}

	/**
	 * view anaesthesia notes
	 *
	 */
	public function view_anaesthesia_notes($patientid = null) {
		$this->loadModel("Note");
		$this->set('title_for_layout', __('View Anaesthesia Note', true));
		if(empty($patientid)) {
			$this->redirect(array("controller" => "opt_appointments", "action" => "search"));
			exit;
		}
		$this->patient_info($patientid);
		$this->Note->bindModel(array('belongsTo' => array(
				'Patient' =>array('foreignKey'=>'patient_id'),
				'User' =>array('foreignKey'=>'sb_registrar'),
				'Doctor' =>array('foreignKey'=>'sb_consultant'),
				'Surgery' =>array('foreignKey'=>false, 'conditions' => array('Surgery.id=Note.surgery_id')),
				'Initial' =>array('foreignKey'=>false, 'conditions'=> array('Initial.id=User.initial_id')),
				'PatientInitial' =>array('foreignKey'=>false, 'conditions'=> array('PatientInitial.id=Doctor.initial_id')), // PatientInitial is alias for doctor initial name
		)),false);
		if (!$this->params['named']['anid']) {
			$this->Session->setFlash(__('Invalid Anaesthesia Note', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "anaestheisa_notes",$patientid));
		}
		$data = $this->Note->find('first', array('conditions' => array('Note.id' => $this->params['named']['anid']), 'fields' => array('Initial.name', 'PatientInitial.name', 'Note.id', 'Note.anaesthesia_note','Note.anaesthesia_note_type', 'Note.note_type', 'Note.created_by', 'Note.note_date', 'Note.create_time', 'Surgery.name', 'CONCAT(User.first_name, " ", User.last_name) as doctor_name','CONCAT(Doctor.first_name, " ", Doctor.last_name) as registrar'), 'recursive' => 1)) ;
		$this->set('patientAnaesthesiaNotes', $data);
	}


	/**
	 * delete anaesthesia notes
	 *
	 */
	public function delete_anaesthesia_notes($patientid = null) {
		$this->loadModel("Note");
		if(empty($patientid)) {
			$this->redirect(array("controller" => "opt_appointments", "action" => "search"));
			exit;
		}
		if (empty($this->params['named']['anid'])) {
			$this->Session->setFlash(__('Invalid Anaesthesia Note', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "anaesthesia_notes",$patientid));
		}
		if (!empty($this->params['named']['anid'])) {
			//$this->Note->id = $this->params['named']['otpcid'];
			//$this->request->data["Note"]["id"] = $this->params['named']['otpcid'];
			//$this->request->data["Note"]["is_deleted"] = "1";
			$this->Note->delete($this->Note->id = $this->params['named']['anid']);
			$this->Session->setFlash(__('Anaesthesia Note Deleted', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "anaesthesia_notes", $patientid));
		}else {
			$this->Session->setFlash(__('This Anaesthesia Note is associated with other details so you can not be delete this Anaesthesia Note', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "anaesthesia_notes", $patientid));
		}
	}

	/**
	 * add surgery consent form
	 *
	 */
	public function add_surgery_consent($patientid=null) {
		$this->uses = array('SurgeryConsentForm', 'Surgery');
		$this->set('title_for_layout', __('Surgery Consent Form', true));
		$this->patient_info($patientid);
		$patientConsentDetails = $this->SurgeryConsentForm->find('first', array('conditions' => array('SurgeryConsentForm.id' => $this->params['named']['scfid'], 'SurgeryConsentForm.location_id' => $this->Session->read('locationid'), 'SurgeryConsentForm.is_deleted' => 0)));
		$this->set('patientConsentDetails', isset($patientConsentDetails)?$patientConsentDetails:'');
		$this->Surgery->bindModel(array('hasOne' => array('OptAppointment' =>array('foreignKey' => 'surgery_id'))));
		$this->set('surgeries', $this->Surgery->find('list', array('conditions' => array('Surgery.location_id' => $this->Session->read('locationid'), 'Surgery.is_deleted' => 0, 'OptAppointment.patient_id' => $patientid), 'recursive' => 1)));
	}

	/**
	 * surgery consent page for print
	 *
	 */
	public function print_surgery_consent($id=null) {
		$this->loadModel('SurgeryConsentForm');
		$this->SurgeryConsentForm->bindModel(array('belongsTo' => array('Patient' =>array('foreignKey' => false, 'conditions' => array('Patient.id=SurgeryConsentForm.patient_id')),
				'Surgery' =>array('foreignKey' => false, 'conditions' => array('Surgery.id=  SurgeryConsentForm.surgery_id')),
				'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
				'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
		)));
		$patientConsentDetails = $this->SurgeryConsentForm->find('first', array('conditions' => array('SurgeryConsentForm.id' => $id, 'SurgeryConsentForm.location_id' => $this->Session->read('locationid'), 'SurgeryConsentForm.is_deleted' => 0) , 'recursive' => 1));
		$this->set('patientConsentDetails', $patientConsentDetails);
		$this->layout = 'print_with_header';
	}

	/**
	 * save surgery consent form
	 *
	 */
	public function saveSurgeryConsent() {
		$this->uses = array("SurgeryConsentForm");
		if ($this->request->is('post') || $this->request->is('put')) {
			// update if surgery consent id found //
			if($this->request->data["SurgeryConsentForm"]['id']) {
				$this->SurgeryConsentForm->id = $this->request->data["SurgeryConsentForm"]['id'];
			}
			$this->request->data["SurgeryConsentForm"]["create_time"] = date("Y-m-d H:i:s");
			$this->request->data["SurgeryConsentForm"]["modify_time"] = date("Y-m-d H:i:s") ;
			$this->request->data["SurgeryConsentForm"]["created_by"] = $this->Session->read('userid');
			$this->request->data["SurgeryConsentForm"]["modified_by"] = $this->Session->read('userid');
			$this->request->data["SurgeryConsentForm"]["location_id"] = $this->Session->read('locationid');
			if($this->SurgeryConsentForm->save($this->request->data)) {
				$this->Session->setFlash(__('Surgery Consent Form Saved.', true));
			} else {
				$this->set('errors', $this->SurgeryConsentForm->invalidFields());
			}
		}
		$this->redirect(array("action" => "surgery_consent", $this->request->data["SurgeryConsentForm"]['patient_id']));
		exit;
	}

	/**
	 * surgery consent
	 *
	 */
	public function surgery_consent($patientid=null) {
		$this->loadModel('SurgeryConsentForm');
		$this->set('title_for_layout', __('Surgery Consent Form', true));
		$this->patient_info($patientid);
		$this->SurgeryConsentForm->bindModel(array('belongsTo' => array('Patient' =>array('foreignKey' => false, 'conditions' => array('Patient.id=SurgeryConsentForm.patient_id')),'Surgery' =>array('foreignKey' => false, 'conditions' => array('Surgery.id=  SurgeryConsentForm.surgery_id')))));
		$this->paginate = array('limit' => Configure::read('number_of_rows'),
				'conditions' => array('SurgeryConsentForm.patient_id' => $patientid, 'SurgeryConsentForm.is_deleted' => 0,
						'SurgeryConsentForm.location_id'=>$this->Session->read('locationid')));
		$data = $this->paginate('SurgeryConsentForm');
		
		if(empty($data)){
			$this->redirect(array('action'=>'add_surgery_consent',$patientid));
		}else{
			$this->set('data', isset($data)?$data:'');
		}
	}

	/**
	 * view surgery consent forms
	 *
	 */
	public function view_surgery_consent($patientid = null) {
		$this->loadModel("SurgeryConsentForm");
		$this->set('title_for_layout', __('Surgery Consent Form', true));
		$this->patient_info($patientid);
		$this->SurgeryConsentForm->bindModel(array('belongsTo' => array('Patient' =>array('foreignKey' => false, 'conditions' => array('Patient.id=SurgeryConsentForm.patient_id')),'Surgery' =>array('foreignKey' => false, 'conditions' => array('Surgery.id=  SurgeryConsentForm.surgery_id')))));
		if (!$this->params['named']['scfid']) {
			$this->Session->setFlash(__('Invalid Surgery Consent Form', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "surgery_consent",$patientid));
		}
		$data  =$this->SurgeryConsentForm->read(null, $this->params['named']['scfid']) ;
		$this->set('patientConsentDetails', $data);
	}


	/**
	 * delete function of surgery consent form
	 *
	 */
	public function delete_surgery_consent($patientid = null) {
		$this->loadModel("SurgeryConsentForm");
		if (empty($this->params['named']['scfid'])) {
			$this->Session->setFlash(__('Invalid Id For Surgery Consent Form', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "surgery_consent",$patientid));
		}
		if (!empty($this->params['named']['scfid'])) {
			$this->SurgeryConsentForm->id = $this->params['named']['scfid'];
			$this->request->data["SurgeryConsentForm"]["id"] = $this->params['named']['scfid'];
			$this->request->data["SurgeryConsentForm"]["is_deleted"] = "1";
			$this->SurgeryConsentForm->save($this->request->data);
			$this->Session->setFlash(__('Surgery Consent Form deleted', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "surgery_consent", $patientid));
		}else {
			$this->Session->setFlash(__('This surgery consent form  is associated with other details so you can not be delete this surgery consent form', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "surgery_consent", $patientid));
		}
	}

	/**
	 * add surgery consentform
	 *
	 */
	public function add_surgery_consentform($patientid=null) {
		//$this->layout = "ajax";
		$this->uses = array('ConsentForm', 'Surgery', 'DoctorProfile');
		$this->set('title_for_layout', __('Surgery Consent Form', true));
		$this->patient_info($patientid);
		if ($this->request->is('post') || $this->request->is('put')) {
			$consentDateTime = $this->DateFormat->formatDate2STD($this->request->data["ConsentForm"]['date_time'],Configure::read('date_format'));
			$this->request->data["ConsentForm"]['date_time'] = $consentDateTime;
			$this->request->data["ConsentForm"]["create_time"] = date("Y-m-d H:i:s");
			$this->request->data["ConsentForm"]["created_by"] = $this->Session->read('userid');
			$this->request->data["ConsentForm"]["location_id"] = $this->Session->read('locationid');
			if($this->ConsentForm->save($this->request->data)) {
				$this->Session->setFlash(__('Consent Form Saved.', true));
				$this->redirect(array("action" => "surgery_consentform", $this->request->data["ConsentForm"]['patient_id']));
			} else {
				$this->set('errors', $this->ConsentForm->invalidFields());
			}

		}

		$this->Surgery->bindModel(array('hasOne' => array('OptAppointment' =>array('foreignKey' => 'surgery_id'))));
		$this->set('surgeries', $this->Surgery->find('list', array('conditions' => array('Surgery.location_id' => $this->Session->read('locationid'), 'Surgery.is_deleted' => 0, 'OptAppointment.patient_id' => $patientid), 'recursive' => 1)));
		$this->set('doctors', $this->DoctorProfile->getDoctors());
	}

	/**
	 * edit surgery consentform
	 *
	 */
	public function edit_surgery_consentform($patientid=null, $id=null) {
		$this->uses = array('ConsentForm', 'Surgery', 'DoctorProfile');
		$this->set('title_for_layout', __('Surgery Consent Form', true));
		$this->patient_info($patientid);
		if ($this->request->is('post') || $this->request->is('put')) {
			$consentDateTime = $this->DateFormat->formatDate2STD($this->request->data["ConsentForm"]['date_time'],Configure::read('date_format'));
			$this->request->data["ConsentForm"]['date_time'] = $consentDateTime;
			$this->request->data["ConsentForm"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["ConsentForm"]["modified_by"] = $this->Session->read('userid');
			$this->request->data["ConsentForm"]["location_id"] = $this->Session->read('locationid');
			if($this->ConsentForm->save($this->request->data)) {
				$this->Session->setFlash(__('Consent Form Updated.', true));
				$this->redirect(array("action" => "surgery_consentform", $this->request->data["ConsentForm"]['patient_id']));
			} else {
				$this->set('errors', $this->ConsentForm->invalidFields());
			}

		}

		$this->request->data = $this->ConsentForm->read(null, $id);
		$this->Surgery->bindModel(array('hasOne' => array('OptAppointment' =>array('foreignKey' => 'surgery_id'))));
		$this->set('surgeries', $this->Surgery->find('list', array('conditions' => array('Surgery.location_id' => $this->Session->read('locationid'), 'Surgery.is_deleted' => 0, 'OptAppointment.patient_id' => $patientid), 'recursive' => 1)));
		$this->set('doctors', $this->DoctorProfile->getDoctors());
	}

	/**
	 * surgery consent page for print
	 *
	 */
	public function print_surgery_consentform($id=null) {
		$this->loadModel('ConsentForm');
		$this->ConsentForm->bindModel(array('belongsTo' => array('Patient' =>array('foreignKey' => false, 'conditions' => array('Patient.id=ConsentForm.patient_id')),
				'Surgery' =>array('foreignKey' => false, 'conditions' => array('Surgery.id=ConsentForm.surgery_id')),
				'DoctorProfile' =>array('foreignKey' => false, 'conditions' => array('DoctorProfile.user_id=ConsentForm.user_id')),
				'User' =>array('foreignKey' => false, 'conditions' => array('User.id=ConsentForm.user_id')),
				'Initial' =>array('foreignKey' => false, 'conditions' => array('Initial.id=User.initial_id')),
		)));
		$patientConsentDetails = $this->ConsentForm->find('first', array('conditions' => array('ConsentForm.id' => $id, 'ConsentForm.location_id' => $this->Session->read('locationid'), 'ConsentForm.is_deleted' => 0) , 'recursive' => 1));
		$this->set('patientConsentDetails', $patientConsentDetails);
		$this->layout = 'print_with_header';
	}


	/**
	 * surgery consent
	 *
	 */
	public function surgery_consentform($patientid=null) {
		//$this->layout = "ajax";
		$this->loadModel('ConsentForm');
		$this->set('title_for_layout', __('Consent Form', true));
		$this->patient_info($patientid);
		$this->ConsentForm->bindModel(array('belongsTo' => array('Patient' =>array('foreignKey' => false, 'conditions' => array('Patient.id=ConsentForm.patient_id')),
				'Surgery' =>array('foreignKey' => false, 'conditions' => array('Surgery.id=ConsentForm.surgery_id')),
				'DoctorProfile' =>array('foreignKey' => false, 'conditions' => array('DoctorProfile.user_id=ConsentForm.user_id')),
				'User' =>array('foreignKey' => false, 'conditions' => array('User.id=ConsentForm.user_id')),
				'Initial' =>array('foreignKey' => false, 'conditions' => array('Initial.id=User.initial_id')),
		)));
		$this->paginate = array('limit' => Configure::read('number_of_rows'),
				'conditions' => array('ConsentForm.patient_id' => $patientid, 'ConsentForm.is_deleted' => 0,
						'ConsentForm.location_id'=>$this->Session->read('locationid')));
		$data = $this->paginate('ConsentForm');
		
		if(empty($data)){
			$this->redirect(array('action'=>'add_surgery_consentform',$patientid));
		}else{
			$this->set('data', isset($data)?$data:'');
		}
	}


	/**
	 * delete function of surgery consent form
	 *
	 */
	public function delete_surgery_consentform($patientid = null, $id=null) {
		$this->loadModel("ConsentForm");
		if (empty($id)) {
			$this->Session->setFlash(__('Invalid Id For Surgery Consent Form', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "surgery_consentform",$patientid));
		}
		if (!empty($id)) {
			$this->SurgeryConsentForm->id = $id;
			$this->request->data["ConsentForm"]["id"] = $id;
			$this->request->data["ConsentForm"]["is_deleted"] = "1";
			$this->request->data["ConsentForm"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["ConsentForm"]["modified_by"] = $this->Session->read('userid');
			$this->ConsentForm->save($this->request->data);
			$this->Session->setFlash(__('Surgery Consent Form deleted', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "surgery_consentform", $patientid));
		}else {
			$this->Session->setFlash(__('This surgery consent form  is associated with other details so you can not be delete this surgery consent form', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "surgery_consent", $patientid));
		}
	}

	/**
	 * add interpreter statement form
	 *
	 */
	public function add_interpreter_statement($patientid=null) {
		//$this->layout = "ajax";
		$this->uses = array('InterpreterStatement', 'Surgery');
		$this->set('title_for_layout', __('Add Interpreter Statement', true));
		$this->patient_info($patientid);
		if ($this->request->is('post') || $this->request->is('put')) {
			$dateTime = $this->DateFormat->formatDate2STD($this->request->data["InterpreterStatement"]['date_time'],Configure::read('date_format'));
			$physicianDateTime = $this->DateFormat->formatDate2STD($this->request->data["InterpreterStatement"]['physician_date_time'],Configure::read('date_format'));
			$this->request->data["InterpreterStatement"]['date_time'] = $dateTime;
			$this->request->data["InterpreterStatement"]['physician_date_time'] = $physicianDateTime;
			$this->request->data["InterpreterStatement"]["create_time"] = date("Y-m-d H:i:s");
			$this->request->data["InterpreterStatement"]["created_by"] = $this->Session->read('userid');
			$this->request->data["InterpreterStatement"]["location_id"] = $this->Session->read('locationid');
			if($this->InterpreterStatement->save($this->request->data)) {
				$this->Session->setFlash(__('Interpreter Statement Form Saved.', true));
				$this->redirect(array("action" => "interpreter_statement", $this->request->data["InterpreterStatement"]['patient_id']));
			} else {
				$this->set('errors', $this->InterpreterStatement->invalidFields());
			}

		}

		$this->Surgery->bindModel(array('hasOne' => array('OptAppointment' =>array('foreignKey' => 'surgery_id'))));
		$this->set('surgeries', $this->Surgery->find('list', array('conditions' => array('Surgery.location_id' => $this->Session->read('locationid'), 'Surgery.is_deleted' => 0, 'OptAppointment.patient_id' => $patientid), 'recursive' => 1)));
	}

	/**
	 * edit interpreter statement form
	 *
	 */
	public function edit_interpreter_statement($patientid=null, $id) {
		$this->uses = array('InterpreterStatement', 'Surgery');
		$this->set('title_for_layout', __('Edit Interpreter Statement Form', true));
		$this->patient_info($patientid);
		if ($this->request->is('post') || $this->request->is('put')) {
			$dateTime = $this->DateFormat->formatDate2STD($this->request->data["InterpreterStatement"]['date_time'],Configure::read('date_format'));
			$physicianDateTime = $this->DateFormat->formatDate2STD($this->request->data["InterpreterStatement"]['physician_date_time'],Configure::read('date_format'));
			$this->request->data["InterpreterStatement"]['date_time'] = $dateTime;
			$this->request->data["InterpreterStatement"]['physician_date_time'] = $physicianDateTime;
			$this->request->data["InterpreterStatement"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["InterpreterStatement"]["modified_by"] = $this->Session->read('userid');
			$this->request->data["InterpreterStatement"]["location_id"] = $this->Session->read('locationid');
			if($this->InterpreterStatement->save($this->request->data)) {
				$this->Session->setFlash(__('Interpreter Statement Form Updated.', true));
				$this->redirect(array("action" => "interpreter_statement", $this->request->data["InterpreterStatement"]['patient_id']));
			} else {
				$this->set('errors', $this->InterpreterStatement->invalidFields());
			}

		}
		$this->request->data = $this->InterpreterStatement->read(null, $id);
		$this->Surgery->bindModel(array('hasOne' => array('OptAppointment' =>array('foreignKey' => 'surgery_id'))));
		$this->set('surgeries', $this->Surgery->find('list', array('conditions' => array('Surgery.location_id' => $this->Session->read('locationid'), 'Surgery.is_deleted' => 0, 'OptAppointment.patient_id' => $patientid), 'recursive' => 1)));
	}

	/**
	 * print interpreter statement form
	 *
	 */
	public function print_interpreter_statement($patientid=null, $id=null) {
		$this->loadModel('InterpreterStatement');
		if (empty($id)) {
			$this->Session->setFlash(__('Invalid Id For Interpreter Statement Form', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "interpreter_statement",$patientid));
		}
		$this->InterpreterStatement->bindModel(array('belongsTo' => array('Patient' =>array('foreignKey' => false, 'conditions' => array('Patient.id=InterpreterStatement.patient_id')),'Surgery' =>array('foreignKey' => false, 'conditions' => array('Surgery.id=InterpreterStatement.surgery_id')))));
		$patientISDetails = $this->InterpreterStatement->find('first', array('conditions' => array('InterpreterStatement.id' => $id, 'InterpreterStatement.location_id' => $this->Session->read('locationid'), 'InterpreterStatement.is_deleted' => 0) , 'recursive' => 1));
		$this->set('patientISDetails', $patientISDetails);
		$this->layout = 'print_with_header';
	}


	/**
	 * interpreter statement listing
	 *
	 */
	public function interpreter_statement($patientid=null) {
		//$this->layout = "ajax";
		$this->loadModel('InterpreterStatement');
		$this->set('title_for_layout', __('Interpreter Statement', true));
		$this->patient_info($patientid);
		$this->InterpreterStatement->bindModel(array('belongsTo' => array('Patient' =>array('foreignKey' => false, 'conditions' => array('Patient.id=InterpreterStatement.patient_id')),'Surgery' =>array('foreignKey' => false, 'conditions' => array('Surgery.id=InterpreterStatement.surgery_id')))));
		$this->paginate = array('limit' => Configure::read('number_of_rows'),
				'conditions' => array('InterpreterStatement.patient_id' => $patientid, 'InterpreterStatement.is_deleted' => 0,
						'InterpreterStatement.location_id'=>$this->Session->read('locationid')));
		$data = $this->paginate('InterpreterStatement');
		if(empty($data)){
			$this->redirect(array('action'=>'add_interpreter_statement',$patientid));
		}else{
			$this->set('data', isset($data)?$data:'');
		}
		
	}


	/**
	 * delete function of interpreter statement form
	 *
	 */
	public function delete_interpreter_statement($patientid = null, $id=null) {
		$this->loadModel("InterpreterStatement");
		if (empty($id)) {
			$this->Session->setFlash(__('Invalid Id For Interpreter Statement Form', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "interpreter_statement",$patientid));
		}
		if (!empty($id)) {
			$this->InterpreterStatement->id = $id;
			$this->request->data["InterpreterStatement"]["id"] = $id;
			$this->request->data["InterpreterStatement"]["is_deleted"] = "1";
			$this->request->data["InterpreterStatement"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["InterpreterStatement"]["modified_by"] = $this->Session->read('userid');
			$this->InterpreterStatement->save($this->request->data);
			$this->Session->setFlash(__('Interpreter Statement Form deleted', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "interpreter_statement", $patientid));
		}else {
			$this->Session->setFlash(__('This interpreter statement form  is associated with other details so you can not be delete this interpreter statement form', true));
			$this->redirect(array("controller" => "opt_appointments", "action" => "interpreter_statement", $patientid));
		}
	}

	/**
	 * get anaesthesia services by xmlhttprequest
	 *
	 */
	public function getAnaesthesiaServices() {
		$this->loadModel('TariffList');
		if($this->params['isAjax']) {
			if($this->params->query['anaesthesia_service_group_id']) {
				$serviceData=$this->TariffList->find('list', array('fields'=> array('id', 'name'),
						'conditions' => array('TariffList.is_deleted' => 0, 'TariffList.service_category_id' => $this->params->query['anaesthesia_service_group_id'], 'TariffList.location_id' => $this->Session->read('locationid')),
						'order'=>array('TariffList.name'=>'ASC')));
				$this->set('services', $serviceData);
			} else {
				$this->set('services', "");
			}
			if($this->params->query['surgeon']) {
				$this->set('surgeon', true);
			}else{
				$this->set('surgeon', false);
			}
			$this->layout = 'ajax';
			$this->render('/OptAppointments/ajaxget_anaesthesia_services');
		}
	}

	/**
	 * search ot appointment event
	 *
	 */
	public function search_otevent() {
		$this->uses = array('Opt', 'OptTable');
		$this->set('opts',$this->Opt->find('list', array('conditions' => array('Opt.is_deleted' => 0, 'Opt.location_id' => $this->Session->read("locationid")),'order'=>'name ASC')));
		if($this->params['isAjax']) {
			$this->set('opttables', $this->OptTable->find('list', array('conditions' => array('OptTable.is_deleted' => 0, 'OptTable.opt_id' => $this->params->query['opt_id']))));
			$this->layout = 'ajax';
			$this->render('/OptAppointments/ajaxsearch_opttables');
		} else {
			$this->set('opttables',$this->OptTable->find('list', array('conditions' => array('OptTable.is_deleted' => 0))));
		}
		// search parameter set into OT appointment after search //
		if ($this->request->is('post')) {
			$this->set(array('opt_id' => $this->request->data['opt_id'], 'opt_table_id' => $this->request->data['opt_table_id']));
		}
	}


	/**
	 * OT Dashboard
	 */
	function dashboard_index(){
	if($this->params->query['type'] == "dashboard"){
			$this->layout = 'advance_ajax';
		}else{
			$this->layout = 'advance';
		}
		$this->uses = array('User') ;
		$this->set('doctorlist',$this->User->getSurgeonlist());
			
	}

	public function dashboard($typeExcel=null){	 
		$this->layout = false;
		$this->uses = array('User','Preferencecard','OptTable','OptAppointment','OptAppointmentDetail') ;
		
		$flag='no';
		
		
				//BOF-Mahalaxmi
		if($typeExcel=='excel'){
			$procedureComplete = ($this->request->data['OptAppointment']['Seen']) ? 1 : 0 ;
			$conditionSeen = array('OptAppointment.is_deleted'=>'0','OptAppointment.procedure_complete'=>$procedureComplete,
					'OptAppointment.is_deleted'=> 0);
		

		if (!empty($this->request->data['OptAppointment']['surgeons'])) {
			$conditionsDoc = array('OptAppointmentDetail.doctor_id'=>$this->request->data['OptAppointment']['surgeons']);
			$flag='yes1';
		}

		$role = $this->Session->read('role');
		if($role == Configure::read('doctorLabel')){
			$conditionsDR = array('OptAppointmentDetail.doctor_id'=>$this->Session->read('userid'));
			$flag='yes2';
		}

		
		if(!empty($this->request->data['OptAppointment']['patient_id'])){
			$conditionPat = array('OptAppointment.patient_id'=>$this->request->data['OptAppointment']['patient_id']);
			$flag='yes4';
		}

		if(!empty($this->request->data['dateFrom']) && !empty($this->request->data['dateTo'])){
			$dateFrom=explode(' ',$this->DateFormat->formatDate2STD($this->request->data['dateFrom'],Configure::read('date_format')));
			$dateTo=explode(' ',$this->DateFormat->formatDate2STD($this->request->data['dateTo'],Configure::read('date_format')));
			$bothTime = array($dateFrom[0], $dateTo[0]);
			$conditionsBetwn = array('DATE_FORMAT(OptAppointment.schedule_date, "%Y-%m-%d")  BETWEEN ? AND ? ' =>$bothTime);
			$flag='yes5';
		}elseif(!empty($this->request->data['dateFrom']) && empty($this->request->data['dateTo'])){
			$dateFrom=explode(' ',$this->DateFormat->formatDate2STD($this->request->data['dateFrom'],Configure::read('date_format')));
			$dateTo=date('Y-m-d');
			$bothTime = array($dateFrom[0], $dateTo);
			$conditionsBet = array('DATE_FORMAT(OptAppointment.schedule_date, "%Y-%m-%d")  BETWEEN ? AND ? ' =>$bothTime);
			$flag='yes6';
		}elseif(!empty($this->request->data['OptAppointment']['future']) && $this->request->data['OptAppointment']['future']==1){
			$conditionsFuture = array('OR'=>array('OptAppointment.schedule_date >'=>date('Y-m-d')));
			$futureApp = true;
			$flag='yes3';
		}else{
			if(empty($this->request->data['OptAppointment']['patient_id'])){
				$conditionsBetwn = array('OptAppointment.schedule_date' => date("Y-m-d"));
			}
		}

		$conditions=array($conditionSeen,$conditionsDoc,$conditionsDR,$conditionsFuture,$conditionPat,$conditionsBet,$conditionsBetwn);
		$doctors = $this->User->getDoctorsByLocation($this->Session->read('locationid'));
		$this->set('doctorlist',$this->User->getSurgeonlist());
		$this->set('departmentlist',$this->User->getAnaesthesistAndNone(true));

		$this->loadModel('OptAppointmentDetail');
	
		$this->OptAppointment->belongsTo = array();
		$this->OptAppointmentDetail->bindModel(array(
				'belongsTo' => array(
						'OptAppointment' =>array('foreignKey' => 'opt_appointment_id'),
						'Patient' =>array('foreignKey' => false,'conditions'=>array('Patient.id=OptAppointment.patient_id')),
						'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
						'Surgery' =>array('foreignKey' => false,'conditions'=>array('Surgery.id=OptAppointmentDetail.surgery_id')),
						'Opt' =>array('foreignKey' => false,'conditions'=>array('Opt.id=OptAppointment.opt_id')),
						'OptTable' =>array('foreignKey' => false,'conditions'=>array('OptTable.id=OptAppointment.opt_table_id')),
						'Preferencecard' =>array('foreignKey' => false,'conditions'=>array('Preferencecard.id=OptAppointment.preferencecard_id')),
						'SurgicalImplant' =>array('foreignKey' => false,'conditions'=>array('SurgicalImplant.id=OptAppointmentDetail.implant_id')),
						'AnaesthesiaConsentForm'=>array('foreignKey'=>false,'conditions'=>array('AnaesthesiaConsentForm.patient_id=OptAppointment.patient_id')),
						'SurgeryConsentForm'=>array('foreignKey'=>false,'conditions'=>array('SurgeryConsentForm.patient_id=OptAppointment.patient_id')),						
						'ConsentForm'=>array('foreignKey'=>false,'conditions'=>array('ConsentForm.patient_id=OptAppointment.patient_id')),
						'Consent'=>array('foreignKey'=>false,'conditions'=>array('Consent.patient_id=OptAppointment.patient_id')),
						'PreOperativeChecklist'=>array('foreignKey'=>false,'conditions'=>array('PreOperativeChecklist.patient_id=OptAppointment.patient_id')),
						'Note'=>array('foreignKey'=>false,'conditions'=>array('Note.patient_id=OptAppointment.patient_id')),
						'SurgicalSafetyChecklist'=>array('foreignKey'=>false,'conditions'=>array('SurgicalSafetyChecklist.patient_id=OptAppointment.patient_id')),	
						'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('DoctorProfile.user_id=OptAppointmentDetail.doctor_id')),
						
				)),false);

			$data = $this->OptAppointmentDetail->find('all',array('fields'=> array('SurgicalImplant.id','SurgicalImplant.name','TariffStandard.name','OptAppointmentDetail.*','OptAppointment.*','Patient.lookup_name','Patient.id','Patient.patient_id','Patient.admission_id','Patient.doctor_id',
								 'Surgery.id','Surgery.name', 'Opt.id','Opt.name','OptTable.id','OptTable.name','DoctorProfile.doctor_name','DoctorProfile.user_id','DoctorProfile.id',
								 'Preferencecard.card_title','AnaesthesiaConsentForm.id','SurgeryConsentForm.id','ConsentForm.id','Consent.id','PreOperativeChecklist.id',
						         'Note.post_opt','SurgicalSafetyChecklist.id','Note.anaesthesia_note','Note.surgery'),'conditions'=>$conditions,'group'=>'OptAppointmentDetail.id')); 
		

		
		foreach ($data as $surKey=>$serVal){
			
			$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['id']= $serVal['OptAppointment']['id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['patient_id']= $serVal['OptAppointment']['patient_id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['schedule_date']= $serVal['OptAppointment']['schedule_date'];
			$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['dummy_surgery_name']= $serVal['OptAppointment']['dummy_surgery_name'];
			$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['preferencecard_id']= $serVal['OptAppointment']['preferencecard_id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['ot_in_date']= $serVal['OptAppointment']['ot_in_date'];
			$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['out_date']= $serVal['OptAppointment']['out_date'];
			$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['starttime']= $serVal['OptAppointment']['starttime'];
			$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['endtime']= $serVal['OptAppointment']['endtime'];
			$surgeryArray[$serVal['OptAppointment']['id']]['Patient']['id']=$serVal['Patient']['id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['Patient']['lookup_name']=$serVal['Patient']['lookup_name'];
			$surgeryArray[$serVal['OptAppointment']['id']]['TariffStandard']['name']=$serVal['TariffStandard']['name'];
			$surgeryArray[$serVal['OptAppointment']['id']]['Patient']['patient_id']=$serVal['Patient']['patient_id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['OptTable']['name']=$serVal['OptTable']['name'];
			$surgeryArray[$serVal['OptAppointment']['id']]['Opt']['name']=$serVal['Opt']['name'];
			$surgeryArray[$serVal['OptAppointment']['id']]['DoctorProfile'][$serVal['DoctorProfile']['id']]['doctor_name']=$serVal['DoctorProfile']['doctor_name'];
			$surgeryArray[$serVal['OptAppointment']['id']]['Surgery'][$serVal['Surgery']['id']]['name']=$serVal['Surgery']['name'];
			$surgeryArray[$serVal['OptAppointment']['id']]['SurgicalImplant'][$serVal['Surgery']['id']]['name']=$serVal['SurgicalImplant']['name'];
			
			$surgeryArray[$serVal['OptAppointment']['id']]['AnaesthesiaConsentForm']['id']= $serVal['AnaesthesiaConsentForm']['id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['SurgeryConsentForm']['id']= $serVal['SurgeryConsentForm']['id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['ConsentForm']['id']= $serVal['ConsentForm']['id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['Consent']['id']= $serVal['Consent']['id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['PreOperativeChecklist']['id']= $serVal['PreOperativeChecklist']['id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['SurgicalSafetyChecklist']['id']= $serVal['SurgicalSafetyChecklist']['id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['Note']['surgery']= $serVal['Note']['surgery'];
			$surgeryArray[$serVal['OptAppointment']['id']]['Note']['post_opt']= $serVal['Note']['post_opt'];
			$surgeryArray[$serVal['OptAppointment']['id']]['Note']['anaesthesia_note']= $serVal['Note']['anaesthesia_note'];
			$surgeryArray[$serVal['OptAppointment']['id']]['Preferencecard']['card_title']= $serVal['Preferencecard']['card_title'];
			$surgeryArray[$serVal['OptAppointment']['id']]['SurgicalImplant']['name']= $serVal['SurgicalImplant']['name'];
		}
		$this->set(array('data'=>$surgeryArray,'doctors'=>$doctors,'futureApp'=>$futureApp));		
			$this->autoRender = false;			
			$this->layout = false ;
			$this->render('dashboard_excel',false);
		}else{
			$this->paginate = array(
				'update' => '#list_content',
				'evalScripts' => true
		);
			$procedureComplete = ($this->request->query['data']['OptAppointment']['Seen']) ? 1 : 0 ;
			$conditionSeen = array('OptAppointment.is_deleted'=>'0','OptAppointment.procedure_complete'=>$procedureComplete,
					'OptAppointment.is_deleted'=> 0);
		

		if (!empty($this->request->query['data']['OptAppointment']['surgeons'])) {
			$conditionsDoc = array('OptAppointmentDetail.doctor_id'=>$this->request->query['data']['OptAppointment']['surgeons']);
			$flag='yes1';
		}
		

		$role = $this->Session->read('role');
		if($role == Configure::read('doctorLabel')){
			$conditionsDR = array('OptAppointmentDetail.doctor_id'=>$this->Session->read('userid'));
			$flag='yes2';
		}
		if(!empty($this->request->query['data']['OptAppointment']['patient_id'])){
			$conditionPat = array('OptAppointment.patient_id'=>$this->request->query['data']['OptAppointment']['patient_id']);
			$flag='yes4';
		}
	

		if(!empty($this->request->query['dateFrom']) && !empty($this->request->query['dateTo'])){
			$dateFrom=explode(' ',$this->DateFormat->formatDate2STD($this->request->query['dateFrom'],Configure::read('date_format')));
			$dateTo=explode(' ',$this->DateFormat->formatDate2STD($this->request->query['dateTo'],Configure::read('date_format')));
			$bothTime = array($dateFrom[0], $dateTo[0]);
			$conditionsBetwn = array('DATE_FORMAT(OptAppointment.schedule_date, "%Y-%m-%d")  BETWEEN ? AND ? ' =>$bothTime);
			$flag='yes5';
		}elseif(!empty($this->request->query['dateFrom']) && empty($this->request->query['dateTo'])){
			$dateFrom=explode(' ',$this->DateFormat->formatDate2STD($this->request->query['dateFrom'],Configure::read('date_format')));
			$dateTo=date('Y-m-d');
			$bothTime = array($dateFrom[0], $dateTo);
			$conditionsBet = array('DATE_FORMAT(OptAppointment.schedule_date, "%Y-%m-%d")  BETWEEN ? AND ? ' =>$bothTime);
			$flag='yes6';
		}elseif(!empty($this->request->query['data']['OptAppointment']['future']) && $this->request->query['data']['OptAppointment']['future']==1){
			$conditionsFuture = array('OR'=>array('OptAppointment.schedule_date >'=>date('Y-m-d')));
			$futureApp = true;
			$flag='yes3';
		}else{
			if(empty($this->request->query['data']['OptAppointment']['patient_id'])){
				$conditionsBetwn = array('OptAppointment.schedule_date' => date("Y-m-d"));
			}
		}

		$conditions=array($conditionSeen,$conditionsDoc,$conditionsDR,$conditionsFuture,$conditionPat,$conditionsBet,$conditionsBetwn);
		$doctors = $this->User->getDoctorsByLocation($this->Session->read('locationid'));
		$this->set('doctorlist',$this->User->getSurgeonlist());
		$this->set('departmentlist',$this->User->getAnaesthesistAndNone(true));

		$this->loadModel('OptAppointmentDetail');
	
		$this->OptAppointment->belongsTo = array();
		$this->OptAppointmentDetail->bindModel(array(
				'belongsTo' => array(
						'OptAppointment' =>array('foreignKey' => 'opt_appointment_id'),
						'Patient' =>array('foreignKey' => false,'conditions'=>array('Patient.id=OptAppointment.patient_id')),
						'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
						'Surgery' =>array('foreignKey' => false,'conditions'=>array('Surgery.id=OptAppointmentDetail.surgery_id')),
						'Opt' =>array('foreignKey' => false,'conditions'=>array('Opt.id=OptAppointment.opt_id')),
						'OptTable' =>array('foreignKey' => false,'conditions'=>array('OptTable.id=OptAppointment.opt_table_id')),
						'Preferencecard' =>array('foreignKey' => false,'conditions'=>array('Preferencecard.id=OptAppointment.preferencecard_id')),
						'SurgicalImplant' =>array('foreignKey' => false,'conditions'=>array('SurgicalImplant.id=OptAppointmentDetail.implant_id')),
						'AnaesthesiaConsentForm'=>array('foreignKey'=>false,'conditions'=>array('AnaesthesiaConsentForm.opt_appointment_id=OptAppointmentDetail.opt_appointment_id','AnaesthesiaConsentForm.is_deleted'=>0)),
						'SurgeryConsentForm'=>array('foreignKey'=>false,'conditions'=>array('SurgeryConsentForm.opt_appointment_id=OptAppointmentDetail.opt_appointment_id','SurgeryConsentForm.is_deleted'=>0)),					
						'ConsentForm'=>array('foreignKey'=>false,'conditions'=>array('ConsentForm.opt_appointment_id=OptAppointmentDetail.opt_appointment_id','ConsentForm.is_deleted'=>0)),
						'InterpreterStatement'=>array('foreignKey'=>false,'conditions'=>array('InterpreterStatement.opt_appointment_id=OptAppointmentDetail.opt_appointment_id','InterpreterStatement.is_deleted'=>0)),
						'Consent'=>array('foreignKey'=>false,'conditions'=>array('Consent.opt_appointment_id=OptAppointmentDetail.opt_appointment_id','Consent.is_deleted'=>0)),			
						'PreOperativeChecklist'=>array('foreignKey'=>false,'conditions'=>array('PreOperativeChecklist.opt_appointment_id=OptAppointmentDetail.opt_appointment_id','PreOperativeChecklist.is_deleted'=>0)),
						'Note'=>array('foreignKey'=>false,'conditions'=>array('Note.patient_id=OptAppointment.patient_id')),
						'SurgicalSafetyChecklist'=>array('foreignKey'=>false,'conditions'=>array('SurgicalSafetyChecklist.opt_appointment_id=OptAppointmentDetail.opt_appointment_id','SurgicalSafetyChecklist.is_deleted'=>0)),	
						'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('DoctorProfile.user_id=OptAppointmentDetail.doctor_id')),
						
				)),false);

		
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('OptAppointment.schedule_date' => 'desc'),
				'fields'=> array('SurgicalImplant.id','SurgicalImplant.name','TariffStandard.name','OptAppointmentDetail.*','OptAppointment.*','Patient.lookup_name','Patient.id','Patient.patient_id','Patient.admission_id','Patient.doctor_id',
								 'Surgery.id','Surgery.name', 'Opt.id','Opt.name','OptTable.id','OptTable.name','DoctorProfile.doctor_name','DoctorProfile.user_id','DoctorProfile.id',
								 'Preferencecard.card_title','SurgicalSafetyChecklist.opt_appointment_id','PreOperativeChecklist.opt_appointment_id','Consent.opt_appointment_id','ConsentForm.opt_appointment_id','AnaesthesiaConsentForm.opt_appointment_id','SurgeryConsentForm.opt_appointment_id','AnaesthesiaConsentForm.id','SurgeryConsentForm.id','ConsentForm.id','Consent.id','PreOperativeChecklist.id',
						         'Note.post_opt','SurgicalSafetyChecklist.id','Note.anaesthesia_note','Note.surgery'),
				'group'=>'OptAppointmentDetail.id',
				'conditions'=>$conditions,
		);
		
		$data = $this->paginate('OptAppointmentDetail');
		
		foreach ($data as $surKey=>$serVal){			
			$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['id']= $serVal['OptAppointment']['id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['patient_id']= $serVal['OptAppointment']['patient_id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['TariffStandard']['name']= $serVal['TariffStandard']['name'];
			$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['schedule_date']= $serVal['OptAppointment']['schedule_date'];
			$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['dummy_surgery_name']= $serVal['OptAppointment']['dummy_surgery_name'];
			$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['preferencecard_id']= $serVal['OptAppointment']['preferencecard_id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['ot_in_date']= $serVal['OptAppointment']['ot_in_date'];
			$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['out_date']= $serVal['OptAppointment']['out_date'];
			$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['starttime']= $serVal['OptAppointment']['starttime'];
			$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['endtime']= $serVal['OptAppointment']['endtime'];
			$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['procedure_complete']= $serVal['OptAppointment']['procedure_complete'];
			$surgeryArray[$serVal['OptAppointment']['id']]['Patient']['id']=$serVal['Patient']['id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['Patient']['lookup_name']=$serVal['Patient']['lookup_name'];
			$surgeryArray[$serVal['OptAppointment']['id']]['Patient']['patient_id']=$serVal['Patient']['patient_id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['OptTable']['name']=$serVal['OptTable']['name'];
			$surgeryArray[$serVal['OptAppointment']['id']]['Opt']['name']=$serVal['Opt']['name'];
			$surgeryArray[$serVal['OptAppointment']['id']]['DoctorProfile'][$serVal['DoctorProfile']['id']]['doctor_name']=$serVal['DoctorProfile']['doctor_name'];
			$surgeryArray[$serVal['OptAppointment']['id']]['Surgery'][$serVal['Surgery']['id']]['name']=$serVal['Surgery']['name'];
			$surgeryArray[$serVal['OptAppointment']['id']]['SurgicalImplant'][$serVal['Surgery']['id']]['name']=$serVal['SurgicalImplant']['name'];
			$surgeryArray[$serVal['OptAppointment']['id']]['AnaesthesiaConsentForm']['id']= $serVal['AnaesthesiaConsentForm']['id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['SurgeryConsentForm']['id']= $serVal['SurgeryConsentForm']['id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['ConsentForm']['id']= $serVal['ConsentForm']['id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['Consent']['id']= $serVal['Consent']['id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['PreOperativeChecklist']['id']= $serVal['PreOperativeChecklist']['id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['SurgicalSafetyChecklist']['id']= $serVal['SurgicalSafetyChecklist']['id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['Note']['surgery']= $serVal['Note']['surgery'];
			$surgeryArray[$serVal['OptAppointment']['id']]['Note']['post_opt']= $serVal['Note']['post_opt'];
			$surgeryArray[$serVal['OptAppointment']['id']]['Note']['anaesthesia_note']= $serVal['Note']['anaesthesia_note'];
			$surgeryArray[$serVal['OptAppointment']['id']]['Preferencecard']['card_title']= $serVal['Preferencecard']['card_title'];	

			$surgeryArray[$serVal['OptAppointment']['id']]['AnaesthesiaConsentForm']['opt_appointment_id']= $serVal['AnaesthesiaConsentForm']['opt_appointment_id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['SurgeryConsentForm']['opt_appointment_id']= $serVal['SurgeryConsentForm']['opt_appointment_id'];	
			$surgeryArray[$serVal['OptAppointment']['id']]['ConsentForm']['opt_appointment_id']= $serVal['ConsentForm']['opt_appointment_id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['InterpreterStatement']['opt_appointment_id']= $serVal['InterpreterStatement']['opt_appointment_id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['Consent']['opt_appointment_id']= $serVal['Consent']['opt_appointment_id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['PreOperativeChecklist']['opt_appointment_id']= $serVal['PreOperativeChecklist']['opt_appointment_id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['SurgicalSafetyChecklist']['opt_appointment_id']= $serVal['SurgicalSafetyChecklist']['opt_appointment_id'];
			$surgeryArray[$serVal['OptAppointment']['id']]['SurgicalImplant']['name']= $serVal['SurgicalImplant']['name'];

		}
		#debug($surgeryArray);
		
		$this->set(array('data'=>$surgeryArray,'doctors'=>$doctors,'futureApp'=>$futureApp)); 
		}
		
	}
	
	//for dashboard slide show
	public function dashboard_index_page_four(){

		$this->layout = false;
		$this->uses = array('User','Preferencecard','OptTable','OptAppointment','OptAppointmentDetail') ;
		
		$flag='no';
		
		
		//BOF-Mahalaxmi
		if($typeExcel=='excel'){
			$procedureComplete = ($this->request->data['OptAppointment']['Seen']) ? 1 : 0 ;
			$conditionSeen = array('OptAppointment.is_deleted'=>'0','OptAppointment.procedure_complete'=>$procedureComplete,
					'OptAppointment.is_deleted'=> 0);
		
		
			if (!empty($this->request->data['OptAppointment']['surgeons'])) {
				$conditionsDoc = array('OptAppointmentDetail.doctor_id'=>$this->request->data['OptAppointment']['surgeons']);
				$flag='yes1';
			}
		
			$role = $this->Session->read('role');
			if($role == Configure::read('doctorLabel')){
				$conditionsDR = array('OptAppointmentDetail.doctor_id'=>$this->Session->read('userid'));
				$flag='yes2';
			}
		
		
			if(!empty($this->request->data['OptAppointment']['patient_id'])){
				$conditionPat = array('OptAppointment.patient_id'=>$this->request->data['OptAppointment']['patient_id']);
				$flag='yes4';
			}
		
			if(!empty($this->request->data['dateFrom']) && !empty($this->request->data['dateTo'])){
				$dateFrom=explode(' ',$this->DateFormat->formatDate2STD($this->request->data['dateFrom'],Configure::read('date_format')));
				$dateTo=explode(' ',$this->DateFormat->formatDate2STD($this->request->data['dateTo'],Configure::read('date_format')));
				$bothTime = array($dateFrom[0], $dateTo[0]);
				$conditionsBetwn = array('DATE_FORMAT(OptAppointment.schedule_date, "%Y-%m-%d")  BETWEEN ? AND ? ' =>$bothTime);
				$flag='yes5';
			}elseif(!empty($this->request->data['dateFrom']) && empty($this->request->data['dateTo'])){
				$dateFrom=explode(' ',$this->DateFormat->formatDate2STD($this->request->data['dateFrom'],Configure::read('date_format')));
				$dateTo=date('Y-m-d');
				$bothTime = array($dateFrom[0], $dateTo);
				$conditionsBet = array('DATE_FORMAT(OptAppointment.schedule_date, "%Y-%m-%d")  BETWEEN ? AND ? ' =>$bothTime);
				$flag='yes6';
			}elseif(!empty($this->request->data['OptAppointment']['future']) && $this->request->data['OptAppointment']['future']==1){
				$conditionsFuture = array('OR'=>array('OptAppointment.schedule_date >'=>date('Y-m-d')));
				$futureApp = true;
				$flag='yes3';
			}else{
				if(empty($this->request->data['OptAppointment']['patient_id'])){
					$conditionsBetwn = array('OptAppointment.schedule_date' => date("Y-m-d"));
				}
			}
		
			$conditions=array($conditionSeen,$conditionsDoc,$conditionsDR,$conditionsFuture,$conditionPat,$conditionsBet,$conditionsBetwn);
			$doctors = $this->User->getDoctorsByLocation($this->Session->read('locationid'));
			$this->set('doctorlist',$this->User->getSurgeonlist());
			$this->set('departmentlist',$this->User->getAnaesthesistAndNone(true));
		
			$this->loadModel('OptAppointmentDetail');
			/*	$this->OptAppointmentDetail->bindModel(array(
			 'hasOne' => array(
			 		'OptPatient' =>array('foreignKey' => 'opt_appointment_id'),
			 		'Preferencecard' =>array('foreignKey' => false,'conditions'=>array('Preferencecard.id=OptAppointment.preferencecard_id')),
			 		'AnaesthesiaConsentForm'=>array('foreignKey'=>false,'conditions'=>array('AnaesthesiaConsentForm.patient_id=OptAppointment.patient_id')),
			 		'SurgeryConsentForm'=>array('foreignKey'=>false,'conditions'=>array('SurgeryConsentForm.patient_id=OptAppointment.patient_id')),
			 		'ConsentForm'=>array('foreignKey'=>false,'conditions'=>array('ConsentForm.patient_id=OptAppointment.patient_id')),
			 		//'InterpreterStatement'=>array('foreignKey'=>false,'conditions'=>array('InterpreterStatement.patient_id=OptAppointment.patient_id')),
			 		'Consent'=>array('foreignKey'=>false,'conditions'=>array('Consent.patient_id=OptAppointment.patient_id')),
			 		'PreOperativeChecklist'=>array('foreignKey'=>false,'conditions'=>array('PreOperativeChecklist.patient_id=OptAppointment.patient_id')),
			 		'Note'=>array('foreignKey'=>false,'conditions'=>array('Note.patient_id=OptAppointment.patient_id')),
			 		'SurgicalSafetyChecklist'=>array('foreignKey'=>false,'conditions'=>array('SurgicalSafetyChecklist.patient_id=OptAppointment.patient_id')),
			 )));
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('OptAppointment.schedule_date' => 'desc'),
					'fields'=> array('OptAppointment.*', 'Opt.id','Opt.name', 'OptTable.id','OptTable.name', 'DoctorProfile.present_event_color',
							'DoctorProfile.past_event_color', 'DoctorProfile.future_event_color', 'DoctorProfile.doctor_name','DoctorProfile.user_id','DoctorProfile.id',
							'Patient.admission_id', 'Patient.lookup_name','Patient.id','Patient.doctor_id','Patient.patient_id','Surgery.name','Preferencecard.card_title','OptTable.id',
							'OptPatient.id','OptPatient.out_time','AnaesthesiaConsentForm.id','SurgeryConsentForm.id','ConsentForm.id','Consent.id','PreOperativeChecklist.id','Note.post_opt','SurgicalSafetyChecklist.id','Note.anaesthesia_note','Note.surgery'),
					'group'=>'OptAppointment.id',
					'conditions'=>$conditions,
			);*/
			$this->OptAppointment->belongsTo = array();
			$this->OptAppointmentDetail->bindModel(array(
					'belongsTo' => array(
							'OptAppointment' =>array('foreignKey' => 'opt_appointment_id'),
							'Patient' =>array('foreignKey' => false,'conditions'=>array('Patient.id=OptAppointment.patient_id')),
							'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
							'Surgery' =>array('foreignKey' => false,'conditions'=>array('Surgery.id=OptAppointmentDetail.surgery_id')),
							'Opt' =>array('foreignKey' => false,'conditions'=>array('Opt.id=OptAppointment.opt_id')),
							'OptTable' =>array('foreignKey' => false,'conditions'=>array('OptTable.id=OptAppointment.opt_table_id')),
							'Preferencecard' =>array('foreignKey' => false,'conditions'=>array('Preferencecard.id=OptAppointment.preferencecard_id')),
							'SurgicalImplant' =>array('foreignKey' => false,'conditions'=>array('SurgicalImplant.id=OptAppointment.implant_id')),
							'AnaesthesiaConsentForm'=>array('foreignKey'=>false,'conditions'=>array('AnaesthesiaConsentForm.patient_id=OptAppointment.patient_id')),
							'SurgeryConsentForm'=>array('foreignKey'=>false,'conditions'=>array('SurgeryConsentForm.patient_id=OptAppointment.patient_id')),
							'ConsentForm'=>array('foreignKey'=>false,'conditions'=>array('ConsentForm.patient_id=OptAppointment.patient_id')),
							'Consent'=>array('foreignKey'=>false,'conditions'=>array('Consent.patient_id=OptAppointment.patient_id')),
							'PreOperativeChecklist'=>array('foreignKey'=>false,'conditions'=>array('PreOperativeChecklist.patient_id=OptAppointment.patient_id')),
							'Note'=>array('foreignKey'=>false,'conditions'=>array('Note.patient_id=OptAppointment.patient_id')),
							'SurgicalSafetyChecklist'=>array('foreignKey'=>false,'conditions'=>array('SurgicalSafetyChecklist.patient_id=OptAppointment.patient_id')),
							'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('DoctorProfile.user_id=OptAppointmentDetail.doctor_id')),
		
					)),false);
		
			$data = $this->OptAppointmentDetail->find('all',array('fields'=> array('SurgicalImplant.name','TariffStandard.name','OptAppointmentDetail.*','OptAppointment.*','Patient.lookup_name','Patient.id','Patient.patient_id','Patient.admission_id','Patient.doctor_id',
					'Surgery.id','Surgery.name', 'Opt.id','Opt.name','OptTable.id','OptTable.name','DoctorProfile.doctor_name','DoctorProfile.user_id','DoctorProfile.id',
					'Preferencecard.card_title','AnaesthesiaConsentForm.id','SurgeryConsentForm.id','ConsentForm.id','Consent.id','PreOperativeChecklist.id',
					'Note.post_opt','SurgicalSafetyChecklist.id','Note.anaesthesia_note','Note.surgery'),'conditions'=>$conditions,'group'=>'OptAppointmentDetail.id'));
		
		
		
			foreach ($data as $surKey=>$serVal){
					
				$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['id']= $serVal['OptAppointment']['id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['patient_id']= $serVal['OptAppointment']['patient_id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['schedule_date']= $serVal['OptAppointment']['schedule_date'];
				$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['dummy_surgery_name']= $serVal['OptAppointment']['dummy_surgery_name'];
				$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['preferencecard_id']= $serVal['OptAppointment']['preferencecard_id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['ot_in_date']= $serVal['OptAppointment']['ot_in_date'];
				$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['out_date']= $serVal['OptAppointment']['out_date'];
				$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['starttime']= $serVal['OptAppointment']['starttime'];
				$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['endtime']= $serVal['OptAppointment']['endtime'];
				$surgeryArray[$serVal['OptAppointment']['id']]['Patient']['id']=$serVal['Patient']['id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['Patient']['lookup_name']=$serVal['Patient']['lookup_name'];
				$surgeryArray[$serVal['OptAppointment']['id']]['TariffStandard']['name']=$serVal['TariffStandard']['name'];
				$surgeryArray[$serVal['OptAppointment']['id']]['Patient']['patient_id']=$serVal['Patient']['patient_id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['OptTable']['name']=$serVal['OptTable']['name'];
				$surgeryArray[$serVal['OptAppointment']['id']]['Opt']['name']=$serVal['Opt']['name'];
				$surgeryArray[$serVal['OptAppointment']['id']]['DoctorProfile'][$serVal['DoctorProfile']['id']]['doctor_name']=$serVal['DoctorProfile']['doctor_name'];
				$surgeryArray[$serVal['OptAppointment']['id']]['Surgery'][$serVal['Surgery']['id']]['name']=$serVal['Surgery']['name'];
					
				$surgeryArray[$serVal['OptAppointment']['id']]['AnaesthesiaConsentForm']['id']= $serVal['AnaesthesiaConsentForm']['id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['SurgeryConsentForm']['id']= $serVal['SurgeryConsentForm']['id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['ConsentForm']['id']= $serVal['ConsentForm']['id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['Consent']['id']= $serVal['Consent']['id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['PreOperativeChecklist']['id']= $serVal['PreOperativeChecklist']['id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['SurgicalSafetyChecklist']['id']= $serVal['SurgicalSafetyChecklist']['id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['Note']['surgery']= $serVal['Note']['surgery'];
				$surgeryArray[$serVal['OptAppointment']['id']]['Note']['post_opt']= $serVal['Note']['post_opt'];
				$surgeryArray[$serVal['OptAppointment']['id']]['Note']['anaesthesia_note']= $serVal['Note']['anaesthesia_note'];
				$surgeryArray[$serVal['OptAppointment']['id']]['Preferencecard']['card_title']= $serVal['Preferencecard']['card_title'];
				$surgeryArray[$serVal['OptAppointment']['id']]['SurgicalImplant']['name']= $serVal['SurgicalImplant']['name'];
			}
			$this->set(array('data'=>$surgeryArray,'doctors'=>$doctors,'futureApp'=>$futureApp));
			$this->autoRender = false;
			$this->layout = false ;
			$this->render('dashboard_excel',false);
		}else{
			$this->paginate = array(
					'update' => '#list_content',
					'evalScripts' => true
			);
			$procedureComplete = ($this->request->query['data']['OptAppointment']['Seen']) ? 1 : 0 ;
			$conditionSeen = array('OptAppointment.is_deleted'=>'0','OptAppointment.procedure_complete'=>$procedureComplete,
					'OptAppointment.is_deleted'=> 0);
		
		
			if (!empty($this->request->query['data']['OptAppointment']['surgeons'])) {
				$conditionsDoc = array('OptAppointmentDetail.doctor_id'=>$this->request->query['data']['OptAppointment']['surgeons']);
				$flag='yes1';
			}
		
		
			$role = $this->Session->read('role');
			if($role == Configure::read('doctorLabel')){
				$conditionsDR = array('OptAppointmentDetail.doctor_id'=>$this->Session->read('userid'));
				$flag='yes2';
			}
			if(!empty($this->request->query['data']['OptAppointment']['patient_id'])){
				$conditionPat = array('OptAppointment.patient_id'=>$this->request->query['data']['OptAppointment']['patient_id']);
				$flag='yes4';
			}
		
		
			if(!empty($this->request->query['dateFrom']) && !empty($this->request->query['dateTo'])){
				$dateFrom=explode(' ',$this->DateFormat->formatDate2STD($this->request->query['dateFrom'],Configure::read('date_format')));
				$dateTo=explode(' ',$this->DateFormat->formatDate2STD($this->request->query['dateTo'],Configure::read('date_format')));
				$bothTime = array($dateFrom[0], $dateTo[0]);
				$conditionsBetwn = array('DATE_FORMAT(OptAppointment.schedule_date, "%Y-%m-%d")  BETWEEN ? AND ? ' =>$bothTime);
				$flag='yes5';
			}elseif(!empty($this->request->query['dateFrom']) && empty($this->request->query['dateTo'])){
				$dateFrom=explode(' ',$this->DateFormat->formatDate2STD($this->request->query['dateFrom'],Configure::read('date_format')));
				$dateTo=date('Y-m-d');
				$bothTime = array($dateFrom[0], $dateTo);
				$conditionsBet = array('DATE_FORMAT(OptAppointment.schedule_date, "%Y-%m-%d")  BETWEEN ? AND ? ' =>$bothTime);
				$flag='yes6';
			}elseif(!empty($this->request->query['data']['OptAppointment']['future']) && $this->request->query['data']['OptAppointment']['future']==1){
				$conditionsFuture = array('OR'=>array('OptAppointment.schedule_date >'=>date('Y-m-d')));
				$futureApp = true;
				$flag='yes3';
			}else{
				if(empty($this->request->query['data']['OptAppointment']['patient_id'])){
					$conditionsBetwn = array('OptAppointment.schedule_date' => date("Y-m-d"));
				}
			}
		
			$conditions=array($conditionSeen,$conditionsDoc,$conditionsDR,$conditionsFuture,$conditionPat,$conditionsBet,$conditionsBetwn);
			$doctors = $this->User->getDoctorsByLocation($this->Session->read('locationid'));
			$this->set('doctorlist',$this->User->getSurgeonlist());
			$this->set('departmentlist',$this->User->getAnaesthesistAndNone(true));
		
			$this->loadModel('OptAppointmentDetail');
		
			$this->OptAppointment->belongsTo = array();
			$this->OptAppointmentDetail->bindModel(array(
					'belongsTo' => array(
							'OptAppointment' =>array('foreignKey' => 'opt_appointment_id'),
							'Patient' =>array('foreignKey' => false,'conditions'=>array('Patient.id=OptAppointment.patient_id')),
							'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
							'Surgery' =>array('foreignKey' => false,'conditions'=>array('Surgery.id=OptAppointmentDetail.surgery_id')),
							'Opt' =>array('foreignKey' => false,'conditions'=>array('Opt.id=OptAppointment.opt_id')),
							'OptTable' =>array('foreignKey' => false,'conditions'=>array('OptTable.id=OptAppointment.opt_table_id')),
							'Preferencecard' =>array('foreignKey' => false,'conditions'=>array('Preferencecard.id=OptAppointment.preferencecard_id')),
							'SurgicalImplant' =>array('foreignKey' => false,'conditions'=>array('SurgicalImplant.id=OptAppointment.implant_id')),
							'AnaesthesiaConsentForm'=>array('foreignKey'=>false,'conditions'=>array('AnaesthesiaConsentForm.opt_appointment_id=OptAppointmentDetail.opt_appointment_id','AnaesthesiaConsentForm.is_deleted'=>0)),
							'SurgeryConsentForm'=>array('foreignKey'=>false,'conditions'=>array('SurgeryConsentForm.opt_appointment_id=OptAppointmentDetail.opt_appointment_id','SurgeryConsentForm.is_deleted'=>0)),
							'ConsentForm'=>array('foreignKey'=>false,'conditions'=>array('ConsentForm.opt_appointment_id=OptAppointmentDetail.opt_appointment_id','ConsentForm.is_deleted'=>0)),
							'InterpreterStatement'=>array('foreignKey'=>false,'conditions'=>array('InterpreterStatement.opt_appointment_id=OptAppointmentDetail.opt_appointment_id','InterpreterStatement.is_deleted'=>0)),
							'Consent'=>array('foreignKey'=>false,'conditions'=>array('Consent.opt_appointment_id=OptAppointmentDetail.opt_appointment_id','Consent.is_deleted'=>0)),
							'PreOperativeChecklist'=>array('foreignKey'=>false,'conditions'=>array('PreOperativeChecklist.opt_appointment_id=OptAppointmentDetail.opt_appointment_id','PreOperativeChecklist.is_deleted'=>0)),
							'Note'=>array('foreignKey'=>false,'conditions'=>array('Note.patient_id=OptAppointment.patient_id')),
							'SurgicalSafetyChecklist'=>array('foreignKey'=>false,'conditions'=>array('SurgicalSafetyChecklist.opt_appointment_id=OptAppointmentDetail.opt_appointment_id','SurgicalSafetyChecklist.is_deleted'=>0)),
							'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('DoctorProfile.user_id=OptAppointmentDetail.doctor_id')),
		
					)),false);
		
		
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('OptAppointment.schedule_date' => 'desc'),
					'fields'=> array('SurgicalImplant.name','TariffStandard.name','OptAppointmentDetail.*','OptAppointment.*','Patient.lookup_name','Patient.id','Patient.patient_id','Patient.admission_id','Patient.doctor_id',
							'Surgery.id','Surgery.name', 'Opt.id','Opt.name','OptTable.id','OptTable.name','DoctorProfile.doctor_name','DoctorProfile.user_id','DoctorProfile.id',
							'Preferencecard.card_title','SurgicalSafetyChecklist.opt_appointment_id','PreOperativeChecklist.opt_appointment_id','Consent.opt_appointment_id','ConsentForm.opt_appointment_id','AnaesthesiaConsentForm.opt_appointment_id','SurgeryConsentForm.opt_appointment_id','AnaesthesiaConsentForm.id','SurgeryConsentForm.id','ConsentForm.id','Consent.id','PreOperativeChecklist.id',
							'Note.post_opt','SurgicalSafetyChecklist.id','Note.anaesthesia_note','Note.surgery'),
					'group'=>'OptAppointmentDetail.id',
					'conditions'=>'',
			);
		
			$data = $this->paginate('OptAppointmentDetail');
		
			foreach ($data as $surKey=>$serVal){
				$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['id']= $serVal['OptAppointment']['id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['patient_id']= $serVal['OptAppointment']['patient_id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['TariffStandard']['name']= $serVal['TariffStandard']['name'];
				$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['schedule_date']= $serVal['OptAppointment']['schedule_date'];
				$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['dummy_surgery_name']= $serVal['OptAppointment']['dummy_surgery_name'];
				$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['preferencecard_id']= $serVal['OptAppointment']['preferencecard_id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['ot_in_date']= $serVal['OptAppointment']['ot_in_date'];
				$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['out_date']= $serVal['OptAppointment']['out_date'];
				$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['starttime']= $serVal['OptAppointment']['starttime'];
				$surgeryArray[$serVal['OptAppointment']['id']]['OptAppointment']['endtime']= $serVal['OptAppointment']['endtime'];
				$surgeryArray[$serVal['OptAppointment']['id']]['Patient']['id']=$serVal['Patient']['id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['Patient']['lookup_name']=$serVal['Patient']['lookup_name'];
				$surgeryArray[$serVal['OptAppointment']['id']]['Patient']['patient_id']=$serVal['Patient']['patient_id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['OptTable']['name']=$serVal['OptTable']['name'];
				$surgeryArray[$serVal['OptAppointment']['id']]['Opt']['name']=$serVal['Opt']['name'];
				$surgeryArray[$serVal['OptAppointment']['id']]['DoctorProfile'][$serVal['DoctorProfile']['id']]['doctor_name']=$serVal['DoctorProfile']['doctor_name'];
				$surgeryArray[$serVal['OptAppointment']['id']]['Surgery'][$serVal['Surgery']['id']]['name']=$serVal['Surgery']['name'];
					
				$surgeryArray[$serVal['OptAppointment']['id']]['AnaesthesiaConsentForm']['id']= $serVal['AnaesthesiaConsentForm']['id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['SurgeryConsentForm']['id']= $serVal['SurgeryConsentForm']['id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['ConsentForm']['id']= $serVal['ConsentForm']['id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['Consent']['id']= $serVal['Consent']['id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['PreOperativeChecklist']['id']= $serVal['PreOperativeChecklist']['id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['SurgicalSafetyChecklist']['id']= $serVal['SurgicalSafetyChecklist']['id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['Note']['surgery']= $serVal['Note']['surgery'];
				$surgeryArray[$serVal['OptAppointment']['id']]['Note']['post_opt']= $serVal['Note']['post_opt'];
				$surgeryArray[$serVal['OptAppointment']['id']]['Note']['anaesthesia_note']= $serVal['Note']['anaesthesia_note'];
				$surgeryArray[$serVal['OptAppointment']['id']]['Preferencecard']['card_title']= $serVal['Preferencecard']['card_title'];
		
				$surgeryArray[$serVal['OptAppointment']['id']]['AnaesthesiaConsentForm']['opt_appointment_id']= $serVal['AnaesthesiaConsentForm']['opt_appointment_id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['SurgeryConsentForm']['opt_appointment_id']= $serVal['SurgeryConsentForm']['opt_appointment_id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['ConsentForm']['opt_appointment_id']= $serVal['ConsentForm']['opt_appointment_id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['InterpreterStatement']['opt_appointment_id']= $serVal['InterpreterStatement']['opt_appointment_id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['Consent']['opt_appointment_id']= $serVal['Consent']['opt_appointment_id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['PreOperativeChecklist']['opt_appointment_id']= $serVal['PreOperativeChecklist']['opt_appointment_id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['SurgicalSafetyChecklist']['opt_appointment_id']= $serVal['SurgicalSafetyChecklist']['opt_appointment_id'];
				$surgeryArray[$serVal['OptAppointment']['id']]['SurgicalImplant']['name']= $serVal['SurgicalImplant']['name'];
		
			}
			//debug($surgeryArray);
		
			$this->set(array('data'=>$surgeryArray,'doctors'=>$doctors,'futureApp'=>$futureApp));
		}
		
		
		
	}
	function dashboard_update($field=null,$optId = null){
		if(!$optId || !$field) echo "Unable to process your request" ;
		$this->uses = array('OptAppointment');
			
		if($field == 'doctor'){
			$patientArray['doctor_id'] = "'".$this->request->data['value']."'";
		}else if($field == 'procedure'){
			$patientArray['procedure_complete'] = "'".$this->request->data['value']."'";
		}else if($field == 'anaesthetist'){
			$patientArray['department_id'] = "'".$this->request->data['value']."'";
		}
		$result = $this->OptAppointment->updateAll($patientArray,array('OptAppointment.id'=>$optId));
		if(!$result) echo "Please try again" ;
		exit;
	}
	function note_dashboard($id=null,$patientID = null){
		$this->layout = false ;
		$this->uses = array('OptAppointment');
		$this->set('note_data',$this->OptAppointment->find('first',array('fields'=>'description','conditions'=>array('OptAppointment.id'=>$id,'OptAppointment.patient_id'=>$patientID))));
		$this->set('id',$id);
		$this->OptAppointment->id = $id;
		if (!empty($this->request->data)) {
			$this->request->data['OptAppointment']['id'] = $this->request->data['OptAppointment']['id'];
			$this->request->data['OptAppointment']['description'] = $this->request->data['OptAppointment']['description'];
			if ($this->OptAppointment->save($this->request->data)) {
				$this->Session->setFlash(__('The Ot Appointment has been updated.'));
			} else {

				$this->Session->setFlash(__('The Recipient could not be saved. Please, try again.'));
			}
		} else {
		}
	}


	function opt_autocomplete(){
		$location_id = $this->Session->read('locationid');
		$this->layout = "ajax";
		$this->uses = array('OptAppointment');
		$this->OptAppointment->bindModel(array('belongsTo' => array('Patient' =>array('foreignKey' => 'patient_id'))));

		$autocompleteRes=$this->OptAppointment->find('all',array('fields'=>array('Patient.id','Patient.lookup_name'),
				'conditions'=>array('Patient.lookup_name like'=>'%'.$this->params->query['term'].'%')));

		$returnArray = array();
		foreach ($autocompleteRes as $key=>$value) {
			$returnArray[] = array( 'id'=>$value['Patient']['id'],'value'=>$value['Patient']['lookup_name']) ;
		}
		echo json_encode($returnArray);
		exit;
	}

	/* for to display preference card data into requisition card */
	function surgeryRequisitionCard($patientid=null){
		//debug($patientid);
		$this->layout = false;
		$this->uses = array('Surgery','Preferencecard','OptAppointments','Surgery','SurgerySubcategory', 'Patient', 'SurgeryCategory');
		$role = $this->Session->read('role');

		$this->OptAppointment->bindModel(array(
				'belongsTo' => array('Preferencecard' =>array('foreignKey' => 'preferencecard_id'))
		));

		$this->set('surgery_categories',$this->SurgeryCategory->find('list', array('conditions' => array('SurgeryCategory.is_deleted' => 0, 'SurgeryCategory.location_id' => $this->Session->read('locationid')))));

		$this->set('surgery_subcategories',$this->SurgerySubcategory->find('list', array(
				'conditions' => array('SurgeryCategory.is_deleted' => 0, 'SurgerySubcategory.surgery_category_id' => $getOptDetails['OptAppointment']['surgery_category_id']),
				'order'=>'name ASC','fields' => array('SurgerySubcategory.id', 'SurgerySubcategory.name'), 'recursive' => 1)
		));
		//debug($surgery_categories);

		/* //debug($this->request->data);exit;
		 if($role=='Admin'){
		$this->patient_info($patientid);
		$this->Preferencecard->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey' => false,'fields'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id=Preferencecard.doctor_id')),
						'Surgery'=>array('foreignKey'=>false,'fields'=>array('Surgery.name'),'conditions'=>array('Surgery.id=Preferencecard.procedure_id'))
				)),false);
		$getData=$this->Preferencecard->find('all',array('conditions'=>array('Preferencecard.is_deleted'=>0,'Preferencecard.type'=>$type, 'Preferencecard.patient_id' => $patientid )
		));
		//debug($getData);//exit;
		$this->set("getData",$getData);

		$this->set("patientid",$patientid);
		}
		if($role=='Primary Care Provider'){
		$this->patient_info($patientid);
		$this->Preferencecard->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey' => false,'fields'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id=Preferencecard.doctor_id')),
						'Surgery'=>array('foreignKey'=>false,'fields'=>array('Surgery.name'),'conditions'=>array('Surgery.id=Preferencecard.procedure_id'))
				)),false);
		$getData=$this->Preferencecard->find('all',array('conditions'=>array( 'Preferencecard.patient_id'=>$patientid, 'Preferencecard.doctor_id'=> $this->Session->read('userid'),'Preferencecard.type'=>$type)));
		//debug($getData);
		$this->set("getData",$getData);

		$this->set("patientid",$patientid);
		}

		$this->set('procedure', $this->Surgery->find('list', array('fields'=> array('id', 'name'),'order' => array('Surgery.name'))));//debug($procedure);

		}

		public function savesurgeryRequisitionCard(){
		ob_end_clean();
		ob_start("ob_gzhandler");
		$this->uses = array('Preferencecard');
			
		if(!empty($this->request->data['Preferencecard']['is_checked_'])){
		//debug($this->request->data['Preferencecard']['is_checked_']);exit;
		$this->Preferencecard->updateAll(array('Preferencecard.is_checked'=>'1'),array('Preferencecard.id'=>$this->request->data['Preferencecard']['is_checked_']));
		exit;
		}
		*/

	}


	/**
	 * function returns tariff_list_id of the selected surgery
	 * By:Pooja Gupta
	 *
	 */

	function getSurgeryTariff(){
		$this->loadModel('Surgery');
		if($this->request->data){
			$surgeryTariffId=$this->Surgery->find('first',array('fields'=>array('id','tariff_list_id'),'conditions'=>array('id'=>$this->request->data['id'])));
		}
		echo $surgeryTariffId['Surgery']['tariff_list_id'];
		exit;

	}
	public function sterileProcessingChecklist($lastOptAppointmentId){
		$this->layout = 'advance';
		$this->uses = array('OptAppointment');
		if(!empty($lastOptAppointmentId)){
			$optAppointmentData = $this->OptAppointment->find("first",array('fields'=>array('OptAppointment.sterile_processing_checklist','OptAppointment.id'),'conditions'=>array('OptAppointment.id'=>$lastOptAppointmentId)));
		}
			
		$this->set(array('optAppointmentData'=>$optAppointmentData));
	
	}
	public function saveSterileProcessingChecklist(){
		$this->layout = 'ajax';
		$this->uses = array('OptAppointment');
	
		$getAllData=serialize($this->request->data['OptAppointment']);
		$saveData["sterile_processing_checklist"]=$getAllData;
		$saveData["id"]=$this->request->data['OptAppointments']['id'];
		$this->OptAppointment->save($saveData);
		$this->OptAppointment->id="";
		$lastOptAppointmentId=$this->OptAppointment->getLastInsertID();
		//if(empty($this->request->data['OptAppointments']['id'])){
			$this->Session->setFlash(__('Sterile Processing Checklist Saved.', true));
	/*	}else{
			$this->Session->setFlash(__('Sterile Processing Checklist Updated.', true));
		}*/
		if(empty($lastOptAppointmentId)){
			$lastOptAppointmentId=$this->request->data['OptAppointments']['id'];
		}
		
		$this->redirect(array("controller" => "OptAppointments", "action" => "sterileProcessingChecklist",$lastOptAppointmentId));
	
		exit;
	
	}
	
	//to get surgery name and id
	public function getSurgeryAutocomplete() {
		$this->loadModel("Surgery");
		$this->layout = false;
		$searchKey = $this->params->query['term'] ;
		$surgery = $this->Surgery->find('all', array('fields'=>array('Surgery.id','Surgery.name','Surgery.tariff_list_id'),'conditions' => array('Surgery.is_deleted' => 0,
						'Surgery.name LIKE' => "%".$searchKey."%",
						'Surgery.location_id' => $this->Session->read('locationid')
					),'limit'=>10,'order'=>'name ASC'));
		foreach ($surgery as $key => $val){
			$returnArray[] = array('id'=>$val['Surgery']['id'],'value'=>$val['Surgery']['name'],'tariff_list_id'=>$val['Surgery']['tariff_list_id']);
		}  
		echo json_encode($returnArray);
		exit;
	}

//to get surgery name and id
	public function getDoctors() {
		$this->loadModel("User","DoctorProfile"); 
		$this->layout = false;
		$searchKey = "%".$this->params->query['term']."%" ;
		
		$this->virtualFields = array(
				'doctor_name' => 'CONCAT(Initial.name, " ", DoctorProfile.doctor_name)'
		);
		$this->User->unbindModel(array( 'belongsTo' => array('City','State','Country','Role','Initial')   ));
		$this->User->bindModel(array('belongsTo'=>array('Initial' => array('foreignKey' =>'initial_id'),
				'DoctorProfile' => array( 'foreignKey' => false,'conditions' => array('User.id = DoctorProfile.user_id')),
				'Department' => array( 'foreignKey' => false,'conditions' => array('Department.id = DoctorProfile.department_id')),
		)
		));
		
		$conditions['OR'] = array("User.first_name like"=>$searchKey,"User.last_name like"=>$searchKey); 
		$data = $this->User->find('list',array('fields'=>array('DoctorProfile.user_id','DoctorProfile.doctor_name'),
				'conditions'=>array('User.is_deleted'=>0, 'DoctorProfile.is_deleted'=>0, 'DoctorProfile.is_surgeon'=>1,$conditions),'order'=>array('DoctorProfile.doctor_name'),'limit'=>10,
				'contain' => array('User', 'Initial'), 'recursive' => 1));
		 
		foreach($data as $key => $value) {
			$returnArray[] = array('id'=>$key,'value'=>$value);
		    //if (stripos($value,$searchKey) !== false) {
		      //echo "$value|$key\n";
		    //}
		}
		echo json_encode($returnArray);
		exit;
	}
	
	//function to get all doctor by swapnil - 13.08.2015
	function getAllDoctors(){ 
		$this->loadModel("User","DoctorProfile");
		$this->virtualFields = array(
				'doctor_name' => 'CONCAT(Initial.name, " ", DoctorProfile.doctor_name)'
		);
		$this->User->unbindModel(array( 'belongsTo' => array('City','State','Country','Role','Initial')   ));
		$this->User->bindModel(array('belongsTo'=>array('Initial' => array('foreignKey' =>'initial_id'),
				'DoctorProfile' => array( 'foreignKey' => false,'conditions' => array('User.id = DoctorProfile.user_id')),
				'Department' => array( 'foreignKey' => false,'conditions' => array('Department.id = DoctorProfile.department_id')),
		)
		));
	 
		$data = $this->User->find('list',array('fields'=>array('DoctorProfile.user_id','DoctorProfile.doctor_name'),
				'conditions'=>array('User.is_deleted'=>0, 'DoctorProfile.is_deleted'=>0 ),'order'=>array('DoctorProfile.doctor_name'),
				'contain' => array('User', 'Initial'), 'recursive' => 1));
		return $data;
	}

	
	/** function for to update OT charge 
	 * Atul Chandankhede**/
	
	public function updateOtCharge($patientId,$optId,$proceComplete=null){
		
		$this->uses=array('ServiceBill','ServiceCategory','TariffList','OptAppointmentDetail','OptAppointment','Patient','User');
		$this->layout = 'advance_ajax';
		$serviceCatId=$this->ServiceCategory->getServiceGroupIdbyName(Configure::read('otherServices'));
		$surgeryId=$this->ServiceCategory->getServiceGroupIdbyName(Configure::read('surgeryservices'));
		$otId=$this->ServiceCategory->getServiceGroupIdbyName(Configure::read('operationTheaterCharge'));
		
		$optData = $this->OptAppointment->find('first',array('fields'=>array('OptAppointment.batch_identifier'),'conditions'=>array('OptAppointment.id'=>$optId)));
		 $batchIdentifier = $optData['OptAppointment']['batch_identifier'] ;
		
		$this->OptAppointment->bindModel(array(
				'belongsTo'=>array(
						'DoctorProfile'=>array(
								'foreignKey'=>false,
								'conditions'=>array('DoctorProfile.user_id = OptAppointment.doctor_id')),
						'Surgery'=>array(
								'foreignKey'=>false,
								'conditions'=>array('Surgery.id = OptAppointment.surgery_id')),
						/* 'ServiceBill'=>array(
								'foreignKey'=>false,
								'conditions'=>array('ServiceBill.id = OptAppointment.service_bill_id')), */
						'TariffList'=>array(
								'foreignKey'=>false,
								'conditions'=>array('TariffList.id = OptAppointment.tariff_list_id')),
						'ServiceCategory'=>array(
								'foreignKey'=>false,
								'conditions'=>array('ServiceCategory.id = TariffList.service_category_id')),
						'Anaesthesist' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
								'conditions'=>array('Anaesthesist.user_id=OptAppointment.department_id')),
						'AnaeTariffList' =>array('className'=>'TariffList',
								'foreignKey'=>false,
								'conditions'=>array('AnaeTariffList.id=OptAppointment.anaesthesia_tariff_list_id' )),
						'AnaesthesiaServiceCategory' =>array('className'=>'ServiceCategory','foreignKey'=>false ,'type'=>'LEFT',
								'conditions'=>array('ServiceCategory.id = OptAppointment.anaesthesia_service_group_id')),
						)
				));
		
		$optAppDetail = $this->OptAppointment->find('all',array(
							'fields'=>array('OptAppointment.id,OptAppointment.patient_id, OptAppointment.surgery_cost, OptAppointment.anaesthesia_cost, OptAppointment.ot_charges, 
									OptAppointment.anaesthesia_service_group_id, OptAppointment.anaesthesia_tariff_list_id, OptAppointment.doctor_id, OptAppointment.department_id,
									Surgery.id, Surgery.name, Anaesthesist.id, Anaesthesist.doctor_name,AnaesthesiaServiceCategory.*, AnaeTariffList.id, AnaeTariffList.name',  /* ServiceBill.id, ServiceBill.no_of_times, */ 'DoctorProfile.doctor_name','ServiceCategory.id','ServiceCategory.name','TariffList.id','TariffList.name'),
						'conditions'=>array('OptAppointment.batch_identifier'=>$batchIdentifier)));

		//debug($optAppDetail);
		foreach($optAppDetail as $aKey => $aVal){ 
			if(!empty($aVal['OptAppointment']['anaesthesia_cost'])|| !empty($aVal['OptAppointment']['ot_charges'])){
				$retuArr = $aVal;
			}
			/* debug($aVal);
			$checkMaxArr[$aKey] = $aVal['OptAppointment']['surgery_cost']; */
		} 
		$maxId = array_search(max($checkMaxArr), $checkMaxArr);  
		$this->set('surgService',$optAppDetail);
		//$this->Set('anaesthesiaService',$retuArr[$maxId]);
		$this->Set('anaesthesiaService',$retuArr);
		
		if(!empty($this->request->data)){  
			foreach($this->request->data['OptAppointment'] as $rKey => $opVal){
				$this->OptAppointment->id = $opVal['id'];
				if($this->OptAppointment->save($opVal)){
					$saved = true;
				}else{
					$saved = false;
				}
			}

			if($saved==true && $this->OptAppointment->updateAll(array('OptAppointment.procedure_complete'=>$proceComplete),array('OptAppointment.id'=>$optId))){
				//when procedure complete update dashboard status in patient table-Atul
				$this->Patient->updateAll(array('Patient.dashboard_status'=>"'Operated'"),array('Patient.id'=>$patientId));
				$this->Session->setFlash(__('Procedure completed successfully.', true));
			}else{ 
				$this->Session->setFlash(__('Procedure could not be saved.' ),array('class'=>'error'));
			}
			echo "<script> parent.$.fancybox.close(); </script>";
		}
	}
	
	
	public function otExtraService($patientId){
		$this->layout='advance_ajax';
		
		$this->set('patient_id',$patientId);
		
	}
	
	public function saveExtraService($patientId){
		//if(!$patientId) {return; exit;}
		if($this->request->data){
			$this->loadModel('ServiceCategory');
			$otherCatId=$this->ServiceCategory->getServiceGroupId('otherServices');
			$this->loadModel('Patient');
			$patientData=$this->Patient->find('first',array('fields'=>array('Patient.id','Patient.tariff_standard_id','Patient.doctor_id'),
					'conditions'=>array('Patient.id'=>$patientId)));
			$this->loadModel('ServiceBill');
			$this->loadModel('OptAppointmentDetail');
			foreach($this->request->data['ServiceBill'] as $services){
				$serviceArray=array();$optArray=array();
				$serviceArray['patient_id']=$patientId;
				$serviceArray['location_id']=$this->Session->read('locationid');
				$serviceArray['service_id']=$otherCatId;
				$serviceArray['date']=$this->DateFormat->formatDate2STD($services['date'],Configure::read('date_format'));
				$serviceArray['amount']=$services['amount'];
				$serviceArray['no_of_times']=$services['no_of_times'];
				$serviceArray['tariff_list_id']=$services['tariff_list_id'];
				$serviceArray['tariff_standard_id']=$patientData['Patient']['tariff_standard_id'];
				$serviceArray['create_time']=date('Y-m-d H:i:s');
				$serviceArray['created_by']=$this->Session->read('userid');
				$serviceArray['doctor_id']=$patientData['Patient']['doctor_id'];
				$this->ServiceBill->save($serviceArray);
				$serId[]=$this->ServiceBill->id;
				$optArray['service_bill_id']=$this->ServiceBill->id;
				$this->ServiceBill->id='';
				$optArray['doctor_id']=$patientData['Patient']['doctor_id'];
				$optArray['cost']=$serviceArray['amount']*$serviceArray['no_of_times'];
				$optArray['created']=date('Y-m-d H:i:s');
				$this->OptAppointmentDetail->save($optArray);
				$this->OptAppointmentDetail->id='';
			}
			
		}
		//return $serId;
		exit;
	}

	public function cancelProcedure($optId){
		$this->uses = array('OptAppointment','OptAppointmentDetail','ServiceBill');
		$this->autoRender = false;
		if(!empty($optId)){
			$data = $this->OptAppointmentDetail->find('all',array('conditions'=>array('opt_appointment_id'=>$optId)));
			foreach($data as $key => $ser){
				$serviceBillIDs[] = $ser['OptAppointmentDetail']['service_bill_id'];
			}
			if($this->ServiceBill->updateAll(array('ServiceBill.is_deleted'=>'1'),array('ServiceBill.id'=>$serviceBillIDs))){
				if($this->OptAppointmentDetail->updateAll(array('OptAppointmentDetail.service_bill_id'=>"NULL"),array('opt_appointment_id'=>$optId))){
					if($this->OptAppointment->updateAll(array('OptAppointment.procedure_complete'=>'0'),array('OptAppointment.id'=>$optId))){
						$mess = "true";
					}else{
						$mess = "false";
					}
				}else{
					$mess = "false";
				}
			}else{
				$mess = "false";
			}
			echo json_encode($mess);
		}
	}
	
	/**
	 * Function to get list of ot appointments for patient
	 * @param unknown_type $patient_id
	 * Pooja Gupta
	 */
	function patientOtAppointments($patient_id){
		$this->layout='ajax';
		$this->loadModel('OptAppointment');
		$optAppt=$this->OptAppointment->getSurgeryDetails($patient_id);
		$this->set('otAppt',$optAppt);
	}

/**
 * index method
 *
 * @return void
 */
	public function implantIndex() {
		$this->layout='advance';
		$this->uses = array('SurgicalImplant');
		$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'SurgicalImplant.name' => 'asc'
			        ),
                                'conditions' => array('SurgicalImplant.is_deleted' => 0, 'SurgicalImplant.location_id' => $this->Session->read('locationid'))
			    );
		$this->set('surgicalImplants', $this->paginate('SurgicalImplant'));
	}

	/**
 * add method
 *
 * @return void
 */
	public function implantAdd() {
		$this->layout='advance';
		$this->uses = array('SurgicalImplant');
		if ($this->request->is('post')) {
			$this->SurgicalImplant->create();
                        $this->request->data['SurgicalImplant']['location_id'] = $this->Session->read('locationid');
                        $this->request->data['SurgicalImplant']['created_time'] = date('Y-m-d H:i:s');
                        $this->request->data['SurgicalImplant']['created_by'] = $this->Auth->user('id');
			if ($this->SurgicalImplant->save($this->request->data)) {
				$this->Session->setFlash(__('The Surgical Implant has been saved'));
				$this->redirect(array('action' => 'implantIndex'));
			} else {
				if($this->SurgicalImplant->validationErrors){
					$this->set('errors', $this->SurgicalImplant->validationErrors);
				}else{
					$this->Session->setFlash(__('The Surgical Implant could not be saved. Please, try again.'));
				}
			}
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function implantEdit($id = null) {
		$this->layout='advance';
		$this->uses = array('SurgicalImplant');
                $this->SurgicalImplant->id = $id;
		if ($this->request->is('post') || $this->request->is('put')) {
                        $this->request->data['SurgicalImplant']['modified_time'] = date('Y-m-d H:i:s');
                        $this->request->data['SurgicalImplant']['modified_by'] = $this->Auth->user('id');
                        $errors = $this->SurgicalImplant->invalidFields();
			if ($this->SurgicalImplant->save($this->request->data)) {
				$this->Session->setFlash(__('The Surgical Implant has been updated.'));
				$this->redirect(array('action' => 'implantIndex'));
			} else {
			$this->set('errors', $this->SurgicalImplant->validationErrors);

				$this->Session->setFlash(__('The Surgical Implant could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->SurgicalImplant->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function implantDelete($id = null) {
		$this->layout='advance';
		$this->uses = array('SurgicalImplant');
		$this->SurgicalImplant->id = $id;
		if (!$this->SurgicalImplant->exists()) {
			throw new NotFoundException(__('Invalid Surgical Implant'));
		}
		if ($this->SurgicalImplant->save(array('is_deleted' => 1))) {
			$this->Session->setFlash(__('Surgical Implant deleted'));
			$this->redirect(array('action'=>'implantIndex'));
		}
		$this->Session->setFlash(__('Surgical Implant was not deleted'));
		$this->redirect(array('action' => 'implantIndex'));
	}
	 /**
	 * @author Mahalaxmi
	 * For Change Status as acitve or inactive
	 * @param Null
	 *
	 */
	function changeStatus($test_id=null,$status=null){		
		$this->uses = array('SurgicalImplant');
		if($test_id==''){
			$this->Session->setFlash(__('There is some problem'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
		$this->SurgicalImplant->id = $test_id ;
		$this->SurgicalImplant->save(array('is_active'=>$status));		
		$this->Session->setFlash(__('Status has been changed successfully'),'default',array('class'=>'message'));
		$this->redirect($this->referer());
	}

	 /**
	 * @author Mahalaxmi
	 * For View Group
	 * @param Null
	 *
	 */
	public function implantView($id = null) {
		$this->uses=array('SurgicalImplant');		
		$getSurgicalImplant=$this->SurgicalImplant->find('first',array('fields'=>array('SurgicalImplant.*'),'conditions'=>array('SurgicalImplant.id'=>$id)));		
        $this->set('title_for_layout', __('View Group', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Group', true));
			$this->redirect(array("controller" => "NewOptAppointments", "action" => "implantIndex"));
		}
        $this->set('getSurgicalImplant', $getSurgicalImplant);
     }

	public function getPatientSurgeryId($patientId,$surgeryId){
		$this->uses = array('OptAppointment');
		$this->autoRender = false;
		$condition['OptAppointment.patient_id'] = $patientId;
		$condition['OptAppointment.is_deleted'] = 0;
		$flag = false;
		$allSurgery = $this->OptAppointment->find('all',array(
					'conditions'=>$condition,
					'fields'=>array('OptAppointment.patient_id','OptAppointment.surgery_id')
				));
		
		foreach($allSurgery as $surgery){
			$surgeryArray[] = $surgery['OptAppointment']['surgery_id'];
		}
		$flag = in_array($surgeryId, $surgeryArray);
		$returnFlag = array('flag'=>$flag) ;
		
		ob_clean();
		echo json_encode($returnFlag);
		exit;
	}//end of getPatientSurgeryId

	public function staff_company() {
		$this->layout = false;
		$this->loadModel("Staff");
	
		if ($this->request->is('post')) {
			$data = $this->request->data;
	
			$staffData = [
				'create_by' => isset($data['create_by']) ? $data['create_by'] : null,
				'staff_name' => isset($data['staff_name']) ? $data['staff_name'] : null,
			];
	
			if ($this->Staff->save($staffData)) {
				$this->Session->setFlash(__('Staff data saved successfully.'));
			} else {
				$this->Session->setFlash(__('Unable to save staff data.'));
			}
		}
	}
	
// 	function by dinesh tawade
	public function save_company() {
		$this->layout = false;
		$this->loadModel("CompanyName");
	
		if ($this->request->is('post')) {
			$data = $this->request->data;
	
			$companyData = [
				'company_name' => isset($data['company_name']) ? $data['company_name'] : null,
				'address' => isset($data['address']) ? $data['address'] : null,
				'email' => isset($data['email']) ? $data['email'] : null,
				'phone' => isset($data['phone']) ? $data['phone'] : null,
			];
	// debug($companyData);exit;
			if ($this->CompanyName->save($companyData)) {
				$this->Session->setFlash(__('Company data saved successfully.'));
			} else {
				$this->Session->setFlash(__('Unable to save company data.'));
			}
		}
	}
// end by dinesh tawade

	//to get surgery name and id
	public function getPackageSurgeryAutocomplete() {
		$this->loadModel("TariffList");
		$this->layout = false;
		$searchKey = $this->params->query['term'] ;
		
		$services = $this->TariffList->find('all',array('fields'=>array('TariffList.name','TariffList.id','TariffList.cghs_code'),
					'conditions'=>array('TariffList.is_deleted'=>'0','TariffList.service_category_id'=>'32','OR'=>array('TariffList.name like'=>"%".$searchKey."%", 'TariffList.cghs_code like'=>"%".$searchKey."%")),'group'=>array('TariffList.id'),'limit'=>Configure::read('number_of_rows')));

		foreach ($services as $key => $val){
			$returnArray[] = array('id'=>$val['TariffList']['id'],'value'=>$val['TariffList']['cghs_code']."-".$val['TariffList']['name']);
		}  
		echo json_encode($returnArray);
		exit;
	}
}

?>
