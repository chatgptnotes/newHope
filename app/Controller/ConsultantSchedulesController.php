<?php
/**
 * ConsultantSchedulesController file
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
class ConsultantSchedulesController extends AppController {

	public $name = 'ConsultantSchedules';
	public $uses = array('Consultant');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email','DateFormat');
	
/**
 * consultant listing
 *
 */	
	
	public function index() {
                
				$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'Consultant.first_name' => 'asc'
			        ),
			        'conditions' => array('Consultant.is_deleted' => 0, 'Consultant.location_id' => $this->Session->read('locationid'))
   				);
                $this->set('title_for_layout', __('Consultant Schedule', true));
                $data = $this->paginate('Consultant');
                $this->set('data', $data);
	}

/**
 * add consultant schedules
 *
 */
        public function consultant_schedule() {
                $this->loadModel("ConsultantSchedule");
                $this->set('title_for_layout', __('Add Consultant Schedule', true));
                if ($this->request->is('post')) {
                        $checkIsStart = 0;
                        $checkIsEnd = 0;
                        foreach($this->request->data['schedule'] as $keyindex => $valindex) {
                          foreach($valindex as $key => $val) {
                             foreach($val as $keyactual => $valactual) {
                            	if(!empty($this->request->data['schedule'][$keyindex]['startdate'][$keyactual])) {
                                	$checkIsStart++;
                                }
                                if(!empty($this->request->data['schedule'][$keyindex]['enddate'][$keyactual])) {
                                	$checkIsEnd++;
                                }
                             }
                          }
                        }
                                                
                        if($checkIsStart >  0 && $checkIsEnd >0) {
                        	$this->ConsultantSchedule->saveConsultantSchedule($this->request->data);
                                $this->Session->setFlash(__('The consultant schedule time has been saved', true, array('class'=>'message')));
                                $this->redirect(array("action" => "scheduled_consultant"));
                        } else {
                                $this->Session->setFlash(__('Please select atleast one time', true, array('class'=>'error')));
			        $this->redirect(array("action" => "consultant_schedule", $this->request->data['consultantid']));
                        }
                }
                if($this->params['isAjax']) {
                   $numofdays = cal_days_in_month(CAL_GREGORIAN, $this->params->query['monthidval'], $this->params->query['yearidval']);
                   $this->set('numofdays', $numofdays);
                   $this->set('monthval', date("M", mktime(0, 0, 0, $this->params->query['monthidval']+1, 0)));
                   $this->set('yearval', $this->params->query['yearidval']);
                   $this->set('consultantid', $this->params->query['consultantidval']);
                   $this->render('/ConsultantSchedules/appointmentform');
                   $this->layout = 'ajax';
                }  else {
                   $numofdays = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                   $this->set('consultantid', $this->request->params['pass'][0]);
                   $this->set('numofdays', $numofdays);
                   $this->set('monthval', date('M'));
                   $this->set('yearval', date('Y'));
                }
                
	}

/**
 * scheduled consultant listing
 *
 */	
	
	public function scheduled_consultant() {
                $this->loadModel("ConsultantSchedule");
                $this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'ConsultantSchedule.schedule_date' => 'DESC'
			        ),
			        'conditions' => array('ConsultantSchedule.is_deleted' => 0,'Consultant.availability' => 1)
   				);
		$this->set('title_for_layout', __('Scheduled Consultant Listing', true));
                $data = $this->paginate('ConsultantSchedule');
                $this->set('data', $data);
               
                
	}

/**
 * view details of scheduled consultant
 *
 */	
	
	public function scheduled_view($id = null) {
                $this->loadModel("ConsultantSchedule");
		$this->set('title_for_layout', __('Consultant schedule Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Consultant Schedule', true, array('class'=>'error')));
			$this->redirect(array("action" => "index"));
		}
		$this->set('consultantschedule', $this->ConsultantSchedule->read(null, $id));
	}
        
/**
 * edit consultant schedule
 *
 */
	public function scheduled_edit($id = null) {
                $this->loadModel("ConsultantSchedule");
                $this->set('title_for_layout', __('Edit Scheduled Consultant Detail', true));
                
                if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Scheduled Consultant', true));
                        $this->redirect(array("action" => "scheduled_consultant"));
		}
                if ($this->request->is('post') && !empty($this->request->data)) {
                        if(empty($this->request->data["ConsultantSchedule"]['schedule_date']) || empty($this->request->data["ConsultantSchedule"]['schedule_time'])) {
                        	$this->Session->setFlash(__('Please enter schedule date and time', true));
				$this->redirect(array("action" => "scheduled_edit", $this->request->data["ConsultantSchedule"]['id']));
                        } else {
                        	$this->ConsultantSchedule->id = $this->request->data["ConsultantSchedule"]['id'];
                            $this->request->data['ConsultantSchedule']['schedule_date'] = $this->DateFormat->formatDate2STD($this->request->data["ConsultantSchedule"]['schedule_date'],Configure::read('date_format'));
                        	$this->ConsultantSchedule->save($this->request->data);
                        	$this->Session->setFlash(__('The Consultant schedule has been updated', true));
				$this->redirect(array("action" => "scheduled_consultant"));
                        }
		} else {
                        $this->request->data = $this->ConsultantSchedule->read(null, $id);
                        
		}
		
	}

/**
 * deleted consultant scheduled
 *
 */
	public function scheduled_delete($id = null) {
                $this->loadModel("ConsultantSchedule");
                $this->set('title_for_layout', __('Delete Scheduled Consultant', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Scheduled Consultant', true));
			$this->redirect(array("action" => "scheduled_consultant"));
		}
		if (!empty($id)) {
                        $this->ConsultantSchedule->id = $id;
                        $this->request->data['ConsultantSchedule']['is_deleted'] = 1;
                        $this->ConsultantSchedule->save($this->request->data);
                        $this->Session->setFlash(__('Scheduled Consultant deleted', true));
			$this->redirect(array("action" => "scheduled_consultant"));
		} else {
                        $this->Session->setFlash(__('This consultant is associated with other details so you can not be deleted this consultant', true));
			$this->redirect(array("action" => "scheduled_consultant"));
                }
	}

/**
 * consultant schedule event
 *
 */
	public function consultant_event($id=null,$showCalendarDay=1) {
                $this->uses = array('ConsultantSchedule', 'Consultant', 'Department', 'Patient');
                $this->loadModel("ConsultantSchedule");
                $this->set('title_for_layout', __('Add Consultant Schedule', true));
                $this->ConsultantSchedule->bindModel(array('belongsTo' => array('Patient' => array('className'    => 'Patient', 'foreignKey'    => 'patient_id')))); 
                if (!$id) {
			$this->Session->setFlash(__('Invalid id for Scheduled Consultant', true));
			$this->redirect(array("action" => "index"));
		}
                if($id) {
		 $allEvent = $this->ConsultantSchedule->find("all", array('conditions' => array('ConsultantSchedule.consultant_id'=> $id,'ConsultantSchedule.is_deleted '=> 0)));
                 $consultantData = $this->Consultant->find("first", array('conditions' => array('Consultant.id'=> $id,'Consultant.is_deleted '=> 0), 'recursive' => -1));
                 $departmentList = $this->Department->find('all', array('conditions' => array('Department.is_active' => 1)));
                 
                 $this->set('allEvent', $allEvent);
                 $this->set('consultantData', $consultantData);
                 $this->set('departmentList', $departmentList);
                 $this->set('showCalendarDay', $showCalendarDay);
                }
		
	}

/**
 * consultant schedule event save by xmlhttprequest
 *
 */
	public function saveConsultantEvent() {
                $this->loadModel("ConsultantSchedule");
                $this->loadModel("Patient");
                if($this->params['isAjax']) {
                      if(!($this->params->query['admissionid'])) {
                         $this->Session->setFlash(__('Please enter admission id', true));
                         exit;
                      }
                      $countAdmissionId = $this->Patient->find('count', array('conditions' => array('Patient.admission_id' => $this->params->query['admissionid'])));
                      if($countAdmissionId > 0) {
                        $getPatientId = $this->Patient->find('first', array('conditions' => array('Patient.admission_id' => $this->params->query['admissionid']), 'fields' => array('Patient.id')));
                        if(date("Y-m-d", strtotime($this->params->query['scheduledate'])) >= date("Y-m-d")) {
				$this->request->data['ConsultantSchedule']['patient_id'] = $getPatientId['Patient']['id'];
                                $this->request->data['ConsultantSchedule']['location_id'] = $this->Session->read("locationid");
				$this->request->data['ConsultantSchedule']['consultant_id'] = $this->params->query['consultantid'];
                                $this->request->data['ConsultantSchedule']['department_id'] = $this->params->query['department'];
                                $this->request->data['ConsultantSchedule']['schedule_date'] = $this->params->query['scheduledate'];
				$this->request->data['ConsultantSchedule']['start_time'] = $this->params->query['schedule_starttime'];
				$this->request->data['ConsultantSchedule']['end_time'] = $this->params->query['schedule_endtime'];
				$this->request->data['ConsultantSchedule']['purpose'] = $this->params->query['purpose'];
				$this->request->data['ConsultantSchedule']['visit_type'] = $this->params->query['visit_type'];
				$this->request->data['ConsultantSchedule']['created_by'] = $this->Auth->user('id');
				$this->request->data['ConsultantSchedule']['create_time'] = date("Y-m-d H:i:s");
				$this->ConsultantSchedule->save($this->request->data);
				$this->Session->setFlash(__('Schedule time has been saved', true));
				exit;
                        } else {
                                $this->Session->setFlash(__('You can not be save past schedule time', true));
                                exit;
                        }
                      } else {
                         $this->Session->setFlash(__('Your admission id is wrong so please try again.', true));
                         exit;
                      }
                    
                }
		
	}


/**
 *  update consultant schedule event by xmlhttprequest
 *
 */
	public function updateScheduleEvent() {
                $this->loadModel("ConsultantSchedule");
                $this->loadModel("Patient");
                if($this->params['isAjax']) {
                      if(!($this->params->query['admissionid'])) {
                         $this->Session->setFlash(__('Please enter admission id', true));
                         exit;
                      }
                      $countAdmissionId = $this->Patient->find('count', array('conditions' => array('Patient.admission_id' => $this->params->query['admissionid'])));
                      if($countAdmissionId > 0) {
                        $getPatientId = $this->Patient->find('first', array('conditions' => array('Patient.admission_id' => $this->params->query['admissionid']), 'fields' => array('Patient.id')));
                        if(date("Y-m-d", strtotime($this->params->query['scheduledate'])) >= date("Y-m-d")) {
                                $this->ConsultantSchedule->id = $this->params->query['id'];
                                $this->request->data['ConsultantSchedule']['id'] = $this->params->query['id'];
				$this->request->data['ConsultantSchedule']['patient_id'] = $getPatientId['Patient']['id'];
                                $this->request->data['ConsultantSchedule']['location_id'] = $this->Session->read("locationid");
				$this->request->data['ConsultantSchedule']['department_id'] = $this->params->query['department'];
                                $this->request->data['ConsultantSchedule']['schedule_date'] = $this->params->query['scheduledate'];
				$this->request->data['ConsultantSchedule']['start_time'] = $this->params->query['schedule_starttime'];
				$this->request->data['ConsultantSchedule']['end_time'] = $this->params->query['schedule_endtime'];
				$this->request->data['ConsultantSchedule']['purpose'] = $this->params->query['purpose'];
				$this->request->data['ConsultantSchedule']['visit_type'] = $this->params->query['visit_type'];
				$this->request->data['ConsultantSchedule']['modified_by'] = $this->Auth->user('id');
				$this->request->data['ConsultantSchedule']['modify_time'] = date("Y-m-d H:i:s");
				$this->ConsultantSchedule->save($this->request->data);
				$this->Session->setFlash(__('Schedule time has been updated', true));
				exit;
                        } else {
                                $this->Session->setFlash(__('You can not be save past schedule time', true));
                                exit;
                        }
                      } else {
                         $this->Session->setFlash(__('Your admission id is wrong so please try again.', true));
                         exit;
                      }
                    
                }
		
	}

/**
 * delete consultant schedule event by xmlhttprequest
 *
 */
	public function deleteScheduleEvent() {
                $this->loadModel("ConsultantSchedule");
                if($this->params['isAjax']) {
			$this->ConsultantSchedule->id = $this->params->query['id'];
			$this->request->data['ConsultantSchedule']['id'] = $this->params->query['id'];
			$this->request->data['ConsultantSchedule']['is_deleted'] = 1;
			$this->request->data['ConsultantSchedule']['modified_by'] = $this->Auth->user('id');
			$this->request->data['ConsultantSchedule']['modify_time '] = date("Y-m-d H:i:s");
                        $this->ConsultantSchedule->save($this->data);
                        $this->Session->setFlash(__('Schedule time deleted', true));
                        exit;
                }
		
	}
}
?>