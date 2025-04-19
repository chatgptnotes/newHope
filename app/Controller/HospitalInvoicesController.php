<?php
/**
 * HospitalInvoicesController file
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
class HospitalInvoicesController extends AppController {

	public $name = 'HospitalInvoices';
	public $uses = 'Facility';
	public $helpers = array('Html','Form', 'Js','Number','DateFormat','General');
	public $components = array('RequestHandler','Auth','Session','Acl');

	/**
	@name : admin_patient_admission_report
	@created for: Admission report
	@created on : 2/15/2012
	@created By : Santosh R. Yadav

	**/
	public function superadmin_index($id=null){
		$this->uses = array('Patient','Location','Person','Consultant','User','DoctorProfile', 'Department', 'Facility', 'HospitalRate','ReffererDoctor','Initial', 'FinalBilling');
	//	debug("hello");
		if(!empty($this->request->data['PatientAdmissionReport']['hospital'])) {
			$id = $this->request->data['PatientAdmissionReport']['hospital'];
		}
		
		if($id !=null){
		
				 
				 $facility =  $this->Facility->read(null,$id);
				 App::import('Vendor', 'DrmhopeDB');	
				 $db_name = preg_replace('/\s+/', '', $facility['FacilityDatabaseMapping']['db_name']);
				 $db_connection = new DrmhopeDB($db_name);
				 $db_connection->makeConnection($this->Patient);
				 $db_connection->makeConnection($this->Location);
				 $db_connection->makeConnection($this->Person);
				 $db_connection->makeConnection($this->Consultant);
				 $db_connection->makeConnection($this->User);
				 $db_connection->makeConnection($this->DoctorProfile);
				 $db_connection->makeConnection($this->Department);
				 $db_connection->makeConnection($this->ReffererDoctor);
				 $db_connection->makeConnection($this->Initial);
				  $db_connection->makeConnection($this->FinalBilling);
				 
		}
		$this->Patient->unbindModel(array(
			"hasMany"=>array("PharmacySalesBill","InventoryPharmacySalesReturn")
		));
		 
		$fieldsArr = array('department_id'=>'Department','previous_receivable'=>'Previous receivable','email'=>'Email','relative_name'=>'Relatives name','sponsers_auth'=>'Authorization from Sponsor','mobile_phone'=>'Relative Phone No.','relation'=>'Relationship with patient','doc_ini_assessment'=>'Form received by Patient','form_received_on'=>'Form received Date','nurse_assessment'=>'Registration Completed by patient','doc_ini_assess_on'=>'Start of assessment by Doctor','doc_ini_assess_end_on'=>'End of assessment by Doctor','nurse_assess_on'=>'Start of Nursing Assessment','nurse_assess_end_on'=>'End of Nursing Assessment','nutritional_assess_on'=>'Start of Nutritional Assessment','nutritional_assess_end_on'=>'End of Nutritional Assessment',  'discharge_date'=>'Date Of Discharge', 'name_of_ip' => 'Name of the Employee', 'executive_emp_id_no' => 'Card Number', 'bill_number' => 'Bill Number', 'total_amount' => 'Total Bill', 'amount_paid' => 'Advance Recieved', 'discount_rupees' => 'Discount Amount', 'amount_pending' => 'Balance', 'instructions' => 'Note');
		$this->set('fieldsArr',$fieldsArr);
			
		if($this->request->is('post') || $this->request->is('put')){
			// to apply filter by hospital location //
			/*if(!empty($this->request->data['PatientAdmissionReport']['location'])) {
				$locationList[] = $this->request->data['PatientAdmissionReport']['location'];
				$getLocation = $this->Location->find('first', array('conditions' => array('Location.id' => $this->request->data['PatientAdmissionReport']['location'], 'Location.is_deleted' => 0, 'Location.is_active' => 1), 'fields' => array('Location.id', 'Location.name')));
				$locationName = $getLocation['Location']['name'];
				$this->set('locationName', $locationName);
			} else { 
				$getLocation = $this->Location->find('all', array('conditions' => array('Location.is_deleted' => 0, 'Location.is_active' => 1), 'fields' => array('Location.id', 'Location.name')));
				foreach($getLocation as $getLocationVal) {
					$locationList[] = $getLocationVal['Location']['id'];
					$locationName[] = $getLocationVal['Location']['name'];
					$this->set('locationName', $locationName);
				}
			}*/
			
			$this->set('hospitalname', $this->Facility->find('first', array('conditions' => array('Facility.id' => $id))));
			$this->set('showFromDate', $this->request->data['PatientAdmissionReport']['from']);
			$this->set('showToDate', $this->request->data['PatientAdmissionReport']['to']);
			// Collect required values in variables
			$format = $this->request->data['PatientAdmissionReport']['format'];
			$from = $this->request->data['PatientAdmissionReport']['from'];
			$to =   $this->request->data['PatientAdmissionReport']['to'];
			$sex = $this->request->data['PatientAdmissionReport']['sex'];
			$age = $this->request->data['PatientAdmissionReport']['age'];
			#$patient_location = $this->request->data['PatientAdmissionReport']['patient_location'];
			$blood_group = $this->request->data['PatientAdmissionReport']['blood_group'];
			#$reference_doctor = $this->request->data['PatientAdmissionReport']['reference_doctor'];
			$patient_type = $this->request->data['PatientAdmissionReport']['type'];
			#$doctor_type = $this->request->data['doctor'];
			#$department_type = $this->request->data['PatientAdmissionReport']['department_type'];

			if(isset($this->request->data['PatientAdmissionReport']['treatment_type'])){
				$treatment_type = $this->request->data['PatientAdmissionReport']['treatment_type'];
			}
			//$sponsor = $this->request->data['PatientRegistrationReport']['sponsor'];
			$record = '';
			//BOF pankaj code

			$this->Patient->bindModel(array(
 								'belongsTo' => array( 										 
													'Person'=>array('foreignKey'=>'person_id'),
			                                        'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('DoctorProfile.user_id=Patient.doctor_id')),
			                                        'User'=>array('foreignKey'=>false,'conditions'=>array('User.id=Patient.doctor_id')),
			                                        'Initial'=>array('foreignKey'=>false,'conditions'=>array('Initial.id=User.initial_id')),
													'Consultant'=>array('foreignKey'=>'consultant_id'),	
			                                        'Department'=>array('foreignKey'=>'department_id'),
                                                    'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.patient_id=Patient.id')),
			                                        
			)),false);


			if(!empty($to) && !empty($from)){
				$from = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientAdmissionReport']['from'],Configure::read('date_format'))." 00:00:00";
				$to = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientAdmissionReport']['to'],Configure::read('date_format'))." 23:59:59";
				// get record between two dates. Make condition
				$search_key = array('Patient.form_received_on <=' => $to, 'Patient.form_received_on >=' => $from,'Patient.is_deleted'=>0);
			}else{
				//$search_key =array('Patient.location_id'=>$locationList) ;
			}
			if(!(empty($sex))){
				$search_key['Person.sex'] =  $sex;
			}
			if(!(empty($age))){
				$ageRange = explode('-',$age);
				$search_key['Person.age between ? and ?'] =  array($ageRange[0],$ageRange[1]);
			}
			if(!(empty($blood_group))){
				$search_key['Person.blood_group'] =  $blood_group;
			}
			if(!empty($patient_location)){
				$search_key['Person.city'] =  $patient_location;
			}
			if(!empty($reference_doctor)){
				$search_key['Patient.consultant_id'] =  $reference_doctor;
			}
			if(!empty($patient_type)){
				if($patient_type == 'Emergency'){
					$search_key['Patient.is_emergency'] = 1;
					$search_key['Patient.admission_type'] =  'IPD';
				} else if($patient_type == 'IPD'){
					$search_key['Patient.admission_type'] =  'IPD';
				} else if($patient_type == 'OPD'){
					if(isset($treatment_type) AND $treatment_type != ''){
						$search_key['Patient.treatment_type'] = $treatment_type;
						$search_key['Patient.admission_type'] =  'OPD';
					} else {
						$search_key['Patient.admission_type'] =  'OPD';
					}
				}
			}

			if(!empty($doctor_type)){
				$search_key['Patient.doctor_id'] =  $doctor_type;
			}
			if(!empty($department_type)){
				$search_key['Patient.department_id'] =  $department_type;
			}
			

			//$search_key['DoctorProfile.is_deleted'] =  0;
			//$search_key['DoctorProfile.location_id'] =  $this->Session->read('locationid');
			//$search_key['User.is_deleted']  = 0;
			//pr($search_key);exit;
			$selectedFields = '';
			// if you select fields of finalbilling table //
			$finalBillingFields = array('bill_number', 'total_amount', 'amount_paid', 'discount_rupees', 'amount_pending');
			if(!empty($this->request->data['PatientAdmissionReport']['field_id'])){
				foreach($this->request->data['PatientAdmissionReport']['field_id'] as $key=>$value){

					if($value=='department_id'){
						$selectedFields .= ",Department.name";
					} elseif($value=='name_of_ip'){
						$selectedFields .= ",Person.name_of_ip";
					} elseif($value=='executive_emp_id_no'){
						$selectedFields .= ",Person.executive_emp_id_no";
					} elseif(in_array($value, $finalBillingFields)) {
						$selectedFields .= ",FinalBilling.".$this->request->data['PatientAdmissionReport']['field_id'][$key];
					} else {
						$selectedFields .= ",Patient.".$this->request->data['PatientAdmissionReport']['field_id'][$key];
					}
				}
			}
			$fields =array('Patient.id,Person.initial_id,Patient.patient_id,Patient.lookup_name,Patient.is_emergency,Patient.admission_type,Patient.treatment_type,Person.city,Patient.form_received_on,
	    					Patient.admission_id,Patient.mobile_phone,Person.age,Person.sex,Person.blood_group,Department.name AS deptname, CONCAT(Initial.name," ",DoctorProfile.doctor_name) AS doctor_name,CONCAT(Consultant.first_name," ",Consultant.last_name)'.$selectedFields);

			// get initial name //
			$getInitialname = $this->Initial->find('list');
			$this->set('getInitialname', $getInitialname);
			$record = $this->Patient->find('all',array('order'=>array('Patient.form_received_on' => 'DESC'),'fields'=>$fields,'conditions'=>$search_key));
			$this->set('selctedFields',$this->request->data['PatientAdmissionReport']['field_id']);
			// get ipd, opd and emergency hospital rate //
			$getHospitalRate = $this->HospitalRate->find('first', array('conditions' => array('HospitalRate.facility_id' => $this->request->data['PatientAdmissionReport']['hospital'])));
			$this->set('getHospitalRate', $getHospitalRate);
            // get ipd rate record //
            $search_key['Patient.admission_type'] =  'IPD';
            $search_key['Patient.is_emergency'] =  0;
				$this->Patient->unbindModel(array(
			"hasMany"=>array("PharmacySalesBill","InventoryPharmacySalesReturn")
		));
            $getIpdRaterecord = $this->Patient->find('count',array('order'=>array('Patient.form_received_on' => 'DESC'),'conditions'=>$search_key));
            $this->set('getIpdRaterecord',$getIpdRaterecord);
            // get opd rate record //
            $search_key['Patient.admission_type'] =  'OPD';
				$this->Patient->unbindModel(array(
			"hasMany"=>array("PharmacySalesBill","InventoryPharmacySalesReturn")
		));
            $getOpdRaterecord = $this->Patient->find('count',array('order'=>array('Patient.form_received_on' => 'DESC'),'conditions'=>$search_key));
            $this->set('getOpdRaterecord',$getOpdRaterecord);
            // get emergency rate record //
            $search_key['Patient.admission_type'] =  'IPD';
            $search_key['Patient.is_emergency'] =  1;
				$this->Patient->unbindModel(array(
			"hasMany"=>array("PharmacySalesBill","InventoryPharmacySalesReturn")
		));
            $getEmergencyRaterecord = $this->Patient->find('count',array('order'=>array('Patient.form_received_on' => 'DESC'),'conditions'=>$search_key));
            $this->set('getEmergencyRaterecord',$getEmergencyRaterecord);

			//EOF pankaj code
			//pr($record);exit;
			if($format == 'PDF'){
				$this->set('reports',$record);
				$this->set(compact('fieldName'));
				$this->set(compact('patient_type'));
				$this->render('patient_admission_pdf','pdf');
			} else {
				$this->set('reports', $record);
				$this->set(compact('fieldName'));
				$this->set(compact('patient_type'));
				$this->render('patient_admission_excel','');
			}
		}
		// get hospital list //
		$this->set('facilities', $this->Facility->find('list', array('conditions' => array('Facility.is_active' => 1, 'Facility.is_deleted'=> 0))));
		
		//patient location
		if($id !=null){
			 $this->set('patient_location',$this->Person->find('list',array('fields'=>array('city','city'))));
			$this->set('refrences',$this->Consultant->getConsultant());
			// get department list //
			$departmentList = $this->Department->find('list',
						 array('fields' => array('Department.id', 'Department.name'), 
						 'conditions' => array('Department.location_id' => $this->Session->read('locationid'), 'Department.is_active' => 1)));
			$this->set('departmentList', $departmentList);
			$this->set('doctorList', $this->DoctorProfile->getDoctors()); 
                $this->set('locationlist',$this->Location->find('list', array('conditions' => array('Location.is_active' => 1, 'Location.is_deleted' => 0), 'fields' => array('Location.id', 'Location.name'))));
			$this->set('facility_id', $id);
 		}
	}


	/**
	@name : admin_patient_admission_report_chart
	@created for: Admission report
	@created on : 2/15/2012
	@created By : Anand
	This action get triggred when user select graph in format list on admission report.
	**/
	public function superadmin_patient_admission_report_chart(){

		$this->uses = array('Patient','Location','Person','Consultant','User','DoctorProfile');
		if($this->request->is('post') || $this->request->is('put')) {
		   // to apply filter by hospital location //
			if($this->request->data['PatientAdmissionReport']['location']) {
				$location_id[] = $this->request->data['PatientAdmissionReport']['location'];
			} else {
				$getLocation = $this->Location->find('all', array('conditions' => array('Location.facility_id' => $this->request->data['PatientAdmissionReport']['hospital'], 'Location.is_deleted' => 0, 'Location.is_active' => 1), 'fields' => array('Location.id')));
				foreach($getLocation as $getLocationVal) {
					$location_id[] = $getLocationVal['Location']['id'];
				}
			}
			$this->set('title_for_layout', __('Total Admissions Report Chart', true));
			$reportYear = $this->request->data['PatientAdmissionReport']['year'];
			$reference = $this->request->data['PatientAdmissionReport']['reference_doctor'];
			$patient_type = $this->request->data['PatientAdmissionReport']['type'];
			$doctor_type = $this->request->data['doctor'];
			$department_type = $this->request->data['PatientAdmissionReport']['department_type'];
			//$location_id = $this->Session->read('locationid');
			$consultantName = '';
			$type = 'All';
			$reportMonth = $this->request->data['PatientAdmissionReport']['month'];
			if(!empty($reportMonth)){
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear); // Days of the month selected
				$fromDate = $reportYear."-".$reportMonth."-01";
				$toDate = $reportYear."-".$reportMonth."-".$countDays;
			} else {
				$fromDate = $reportYear."-01-01"; // set first date of current year
				$toDate = $reportYear."-12-31"; // set last date of current year
			}

			// Bind Models
			$this->Patient->bindModel(array(
								'belongsTo' => array( 										 
													'Location' =>array('foreignKey' => 'location_id'),
													'Person'=>array('foreignKey'=>'person_id'),
			                                        'Consultant'=>array('foreignKey'=>'consultant_id'),														
													'Department'=>array('foreignKey'=>'department_id'),
			)),false);
			// This will not change the actual from date
			$setDate = $fromDate;
			// Create Y axix array as per month
			while($toDate > $setDate) {
				$yaxisArray[date("F-Y", strtotime($setDate))] = date("F", strtotime($setDate));
				$expfromdate = explode("-", $setDate);
				$setDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}

			if($fromDate != '' AND $toDate != ''){
				$toSearch = array('Patient.form_received_on <=' => $toDate, 'Patient.form_received_on >=' => $fromDate, 'Patient.is_deleted'=>0,'Patient.location_id'=>$location_id);
			}

			if(!empty($reference)){
				$toSearch['Patient.consultant_id'] = $reference; // Condition reference doctors
			}

			if(!empty($patient_type)){
				if($patient_type == 'Emergency'){
					$toSearch['Patient.is_emergency'] = 1;
					$toSearch['Patient.admission_type'] = 'IPD'; // Condition for year and month
					$type = $patient_type;
				} else {
					$toSearch['Patient.admission_type'] = $patient_type; // Condition for year and month
					$type = $patient_type;

				}
			}
			if(!empty($doctor_type)){
				$toSearch['Patient.doctor_id'] = $doctor_type; // Condition reference doctors
			}
			if(!empty($department_type)){
				$toSearch['Patient.department_id'] = $department_type; // Condition reference doctors
			}

			// Collect record here
			$countRecord = $this->Patient->find('all', array('fields' => array('COUNT(*) AS recordcount', 'DATE_FORMAT(form_received_on, "%M-%Y") AS month_reports',
			 'Patient.form_received_on', 'Patient.doctor_id','Patient.admission_type','Patient.is_emergency','CONCAT(Consultant.first_name," ",Consultant.last_name)'), 
			 'conditions' => $toSearch ,'group' => array('month_reports')));

			//pr($countRecord);exit;

			// Set data for view as per record counted
			foreach($countRecord as $countRecordVal) {
				$filterRecordDateArray[] = $countRecordVal[0]['month_reports'];
				$filterRecordCountArray[$countRecordVal[0]['month_reports']] = $countRecordVal[0]['recordcount'];
			}

			$this->set('filterRecordDateArray', isset($filterRecordDateArray)?$filterRecordDateArray:"");
			$this->set('filterRecordCountArray', isset($filterRecordCountArray)?$filterRecordCountArray:0);
			$this->set('yaxisArray', $yaxisArray);
			$this->set(compact('countRecord'));
			$this->set(compact('reportMonth'));
			$this->set(compact('type'));

		}
	}
	
/**
 * get location list filter with hospital requested by xmlhttprequest 
 *
 */	
	
	public function getHospitalLocationList() {
                $this->loadModel("Location");
                $this->set('locationlist',$this->Location->find('list', array('conditions' => array('Location.is_active' => 1, 'Location.is_deleted' => 0, 'Location.facility_id' => $this->params->query['hospital']), 'fields' => array('Location.id', 'Location.name'))));
                $this->layout = false;
                $this->render('/HospitalInvoices/ajaxgetlocations');
	}
	
/**
 * hospital rate list
 *
 */	
	
	public function superadmin_hospital_rate() {
		$this->uses = array('HospitalRate');
		$this->HospitalRate->bindModel(array('belongsTo' => array('Facility' => array('foreignKey' => 'facility_id'))));
		  		$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			      
			        'conditions' => array('HospitalRate.is_deleted' => 0)
   				);
                $this->set('title_for_layout', __('Hospital Rate', true));
                $this->HospitalRate->recursive = 2;
                $data = $this->paginate('HospitalRate');
                $this->set('data', $data);
	}

/**  
 * view hospital rate
 *
 */
	public function superadmin_view_hospital_rate($id = null) {
		$this->uses = array('HospitalRate');
		$this->HospitalRate->bindModel(array('belongsTo' => array('Facility' => array('foreignKey' => 'facility_id'))));
                $this->set('title_for_layout', __('View Hospital Rate', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Hospital Rate', true));
			$this->redirect(array("controller" => "hospital_invoices", "action" => "hospital_rate", "superadmin" => true));
		}
                $this->set('hospitalrate', $this->HospitalRate->read(null, $id));
        }

/**
 * add hospital rate
 *
 */
	public function superadmin_add_hospital_rate() {
		  $this->uses = array('HospitalRate', 'Facility');
          $this->set('title_for_layout', __('Add Hospital Rate', true));
                if ($this->request->is('post')) {
                        $this->request->data['HospitalRate']['create_time'] = date('Y-m-d H:i:s');
                        $this->request->data['HospitalRate']['created_by'] = $this->Auth->user('id');
                        $this->HospitalRate->create();
                        $this->HospitalRate->save($this->request->data);
                        $errors = $this->HospitalRate->invalidFields();
						if(!empty($errors)) {
			                  $this->set("errors", $errors);
			            } else {
			                  $this->Session->setFlash(__('The hospital rate has been saved', true));
						      $this->redirect(array("controller" => "hospital_invoices", "action" => "hospital_rate", "superadmin" => true));
                        }
		         } 
		     $this->set('facilities', $this->Facility->find('list', array('conditions' => array('Facility.is_active' => 1, 'Facility.is_deleted'=> 0))));
                
	}

/**
 * edit hospital rate
 *
 */
	public function superadmin_edit_hospital_rate($id = null) {
		 $this->uses = array('HospitalRate', 'Facility');
         $this->set('title_for_layout', __('Edit Hospital Rate', true));
         if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Hospital Rate', true));
            $this->redirect(array("controller" => "hospital_invoices", "action" => "hospital_rate", "superadmin" => true));
		 }
         if ($this->request->is('post') && !empty($this->request->data)) {
                        $this->request->data['HospitalRate']['modify_time'] = date('Y-m-d H:i:s');
                        $this->request->data['HospitalRate']['modified_by'] = $this->Auth->user('id');
                        $this->HospitalRate->id = $this->request->data["Opt"]['id'];
                        $this->HospitalRate->save($this->request->data);
			            $errors = $this->HospitalRate->invalidFields();
                        if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The hospital rate has been updated', true));
			               $this->redirect(array("controller" => "hospital_invoices", "action" => "hospital_rate", "superadmin" => true));
                        }
		 } else {
                        $this->request->data = $this->HospitalRate->read(null, $id);
                        $this->set('facilities', $this->Facility->find('list', array('conditions' => array('Facility.is_active' => 1, 'Facility.is_deleted'=> 0))));
         }
                
		
	}

/**
 * delete hospital rate
 *
 */
	public function superadmin_delete_hospital_rate($id = null) {
		$this->uses = array('HospitalRate');
                $this->set('title_for_layout', __('Delete Hospital Rate', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Hospital Rate', true));
			$this->redirect(array("controller" => "hospital_invoices", "action" => "hospital_rate", "superadmin" => true));
		}
		if ($id) {
            $this->OtItem->id = $id;
			$this->request->data['HospitalRate']['id'] = $id;
			$this->request->data['HospitalRate']['is_deleted'] = 1;
			$this->request->data['HospitalRate']['modified_by'] = $this->Auth->user('id');
			$this->request->data['HospitalRate']['modify_time'] = date('Y-m-d H:i:s');
			$this->HospitalRate->save($this->request->data);
            $this->Session->setFlash(__('Hospital rate deleted', true));
			$this->redirect(array("controller" => "hospital_invoices", "action" => "hospital_rate", "superadmin" => true));
		}
	}
}
?>
