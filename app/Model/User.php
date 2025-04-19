<?php
class User extends AppModel {

	public $name = 'User';
	public $actsAs = array(
			'Acl' => array('type' => 'requester'),
	);
	public $specific = false;
	public $cacheQueries = false ;

	public $belongsTo = array('City' => array('className'    => 'City',
			'foreignKey'    => 'city_id'
	),
			'State' => array('className'    => 'State',
					'foreignKey'    => 'state_id'
			),
			'Country' => array('className'    => 'Country',
					'foreignKey'    => 'country_id'
			),
			'Role' => array('className'    => 'Role',
					'foreignKey'    => 'role_id'
			),
			'Initial' => array('className'    => 'Initial',
					'foreignKey'    => 'initial_id'
			),
				
	);
	//public $virtualFields = array(
	//'full_name' => 'CONCAT(Initial.Name," ",User.first_name," ", User.last_name)'
	//	);
	public $virtualFields = array(
			'full_name' => 'CONCAT(User.first_name," ", User.last_name)'
	);
	public $validate = array(
			'first_name' => array(
					'rule' => "notEmpty",
					'message' => "Please enter first name."
			),
			'last_name' => array(
					'rule' => "notEmpty",
					'message' => "Please enter last name."
			),
			/*'gender' => array(
					'rule' => "notEmpty",
					'message' => "Please enter gender."
			),
			'designation' => array(
			 'rule' => "notEmpty",
					'message' => "Please select designation."
			),
	'address1' => array(
			'rule' => "notEmpty",
			'message' => "Please enter address."
	),
	'country_id' => array(
			'rule' => "notEmpty",
			'message' => "Please select country."
	),
	'state_id' => array(
			'rule' => "notEmpty",
			'message' => "Please select state."
	),
			'email' => array(
					'rule' => "email",
					'message' => "Email is already exist, please try another one."
			),*/
			/*'phone1' => array(
			 'rule' => "notEmpty",
					'message' => "Please enter phone."
			),
	'mobile' => array(
			'rule' => "notEmpty",
			'message' => "Please enter mobile."
	),*/
			/*'username' => array(
					'rule' => array('checkUnique'),
					'on' => 'create',
					'message' => "Username is already taken elsewhere in the application."
			)*/
	);

	public function checkUnique($check){
		//$check will have value: array('username' => 'some-value')
		$extraContions = array('is_deleted' => 0);
		$conditonsval = array_merge($check,$extraContions);
		$countUser = $this->find( 'count', array('conditions' => $conditonsval, 'recursive' => -1) );
		if($countUser >0) {
			return false;
		} else {
			return true;
		}
	}
	
	
		
	public function parentNode() {
		if (!$this->id && empty($this->data)) {
			return null;
		}
		$data = $this->data;
		if (empty($this->data)) {
			$data = $this->read();
		}
		if (!isset($data['User']['role_id']) || !$data['User']['role_id']) {
			return null;
		} else {
			return array('Role' => array('id' => $data['User']['role_id']));
		}
	}
	
	 

	public function afterSave($created) {
		App::import('Vendor', 'DrmhopeDB');
		//For generating account code for account table
		$session = new CakeSession();
		$facility = Classregistry::init('Facility');
		$facility_db = $facility->find('first',
		array('conditions' => array('Facility.id' =>
		$this->data['User']['facility_id'])));
		$db_connection = new DrmhopeDB($facility_db['FacilityDatabaseMapping']['db_name']);
		$getAccount = Classregistry::init('Account');
		$accountingGroup = Classregistry::init('AccountingGroup');
		$designationObj=Classregistry::init('Designation');
		$doctorprofile=Classregistry::init('DoctorProfile');
		if($this->data['User']['facility_id']){
			$db_connection->makeConnection($getAccount);
			$db_connection->makeConnection($accountingGroup);
			$db_connection->makeConnection($designationObj);
			$db_connection->makeConnection($doctorprofile);
		}
		
		
		$count = $getAccount->find('count',array('conditions'=>array('Account.create_time like'=> "%".date("Y-m-d")."%",'Account.location_id'=>$session->read('locationid'))));
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
		$unique_id   = 'ST';
		$unique_id  .= ucfirst(substr($hospital,0,1)); //first letter of the hospital name
		$unique_id  .= strtoupper(substr($session->read('location'),0,2));//first 2 letter of d location
		$unique_id  .= date('y'); //year
		$unique_id  .= $month_array[date('n')-1];//first letter of month
		$unique_id  .= date('d');//day
		$unique_id .= $count;
		//////////EOC//////////
		if ($created) {
			$rolename = Classregistry::init('Role')->find('first', array('conditions' => array('Role.id' => $this->data['User']['role_id']), 'fields' => array('Role.name'), 'recursive' => -1));
			if(strtolower($rolename['Role']['name']) == strtolower(Configure::read("doctorLabel")) || strtolower($rolename['Role']['name']) == strtolower(Configure::read('RegistrarLabel'))) {
				// set is registrar if exist //
				/*if($rolename['Role']['name'] == Configure::read('RegistrarLabel') || $rolename['Role']['name'] == Configure::read('RegistrarLabel')) {
					$this->data['DoctorProfile']['is_registrar'] = 1;
				} else {
					$this->data['DoctorProfile']['is_registrar'] = 0;
				}*/
				
				$designation_id=$designationObj->find('first',array('fields'=>array('id'),
						'conditions'=>array('name'=>'Registrar','location_id'=>$this->data['User']['location_id'])));
				if($this->data['User']['designation_id']==$designation_id['Designation']['id']){
					$this->data['DoctorProfile']['is_registrar'] = 1;
				}else{
					$this->data['DoctorProfile']['is_registrar'] = 0;
				}
				$this->data['DoctorProfile']['doctor_name'] = str_replace('  ',' ',ucfirst($this->data['User']['first_name'])." ".ucfirst($this->data['User']['middle_name'])." ".ucfirst($this->data['User']['last_name']));
				$this->data['DoctorProfile']['first_name'] = ucfirst($this->data['User']['first_name']);
				$this->data['DoctorProfile']['last_name'] = ucfirst($this->data['User']['last_name']);
				$this->data['DoctorProfile']['middle_name'] = ucfirst($this->data['User']['middle_name']);
				$this->data['DoctorProfile']['dateofbirth'] = $this->data['User']['dob'];
				$this->data['DoctorProfile']['starthours'] = Configure::read('calendar_start_time').":00";
				$this->data['DoctorProfile']['endhours'] = Configure::read('calendar_end_time').":00";
				$this->data['DoctorProfile']['is_surgeon'] = $this->data['DoctorProfile']['is_surgeon'];
				$this->data['DoctorProfile']['is_registrar'] = $this->data['DoctorProfile']['is_registrar'];
				//$this->data['DoctorProfile']['is_doctor'] = $this->data['DoctorProfile']['is_doctor'];
				$this->data['DoctorProfile']['department_id'] = $this->data['User']['department_id'];
				$this->data['DoctorProfile']['expiration_date'] = $this->data['User']['expiration_date'];
				$this->data['DoctorProfile']['location_id'] = ($this->data['User']['location_id']) ? $this->data['User']['location_id']  : AuthComponent::user('location_id');
				$this->data['DoctorProfile']['photo'] = $this->data['User']['photo'];
				$this->data['DoctorProfile']['user_id'] = $this->getLastInsertID();
				$this->data['DoctorProfile']['created_by'] = AuthComponent::user('id');
				$this->data['DoctorProfile']['create_time'] = date("Y-m-d H:i:s");
				$doctorprofile->create();
				
				$doctorprofile->save($this->data);
			}
			//// For saving the user in account table
			if($this->data['User']['is_deleted']==1){
				return ; //return if delete
			}
			$this->data['Account']['name']=$this->data['User']['first_name']." ".$this->data['User']['last_name'];
			$this->data['Account']['user_type']='User';
			$this->data['Account']['system_user_id']=$this->data['User']['id'];
			$this->data['Account']['location_id'] = $session->read('locationid');
			$this->data['Account']['accounting_group_id']=$this->data['User']['accounting_group_id'];
			$this->data['Account']['create_time']=date("Y-m-d H:i:s");
			$this->data['Account']['status']='Active';
			$this->data['Account']['account_code']=$unique_id;
			$this->data['Account']['emp_id']=$this->data['User']['hr_code'];
			$getAccount->save($this->data['Account']);
		}else {
			$sundryCreditors = $accountingGroup->getAccountingGroupID(Configure::read('sundry_creditors'));
			$var=$getAccount->find('first',array('fields'=>array('id','accounting_group_id'),'conditions'=>array('system_user_id'=>$this->data['User']['id'],'user_type'=>'User','Account.location_id'=>$session->read('locationid'))));
			//avoid delete updatation
			if($this->data['User']['is_deleted']==1){
				$getAccount->updateAll(array('is_deleted'=>1), array('Account.system_user_id' => $this->data['User']['id'],'Account.user_type'=>'User','Account.location_id'=>$session->read('locationid')));
				return ;
			}
			if(!empty($this->data['User']['first_name'])){
				if(empty($var['Account']['id']))
				{
					$this->data['Account']['account_code']=$unique_id;
					$this->data['Account']['create_time']=date("Y-m-d H:i:s");
					$this->data['Account']['status']='Active';
				}
				$this->data['Account']['accounting_group_id']=$sundryCreditors;
				$this->data['Account']['name']=$this->data['User']['first_name']." ".$this->data['User']['last_name'];
				$this->data['Account']['user_type']='User';
				$this->data['Account']['system_user_id']=($this->data['User']['id'])?$this->data['User']['id']:$this->id;
				$this->data['Account']['status']='Active';
				$this->data['Account']['id']=$var['Account']['id'];
				$this->data['Account']['modify_time']=date("Y-m-d H:i:s");
				$this->data['Account']['location_id'] = $session->read('locationid');
				$this->data['Account']['emp_id']=$this->data['User']['hr_code'];
				$getAccount->save($this->data['Account']);
			}
			// if doctor user updated then update doctor tables//
			$checkRoleType = Classregistry::init('User')->find('first', array('conditions' => array('User.id' => $this->data['User']['id']), 'fields' => array('Role.name')));
			if(strtolower($checkRoleType['Role']['name']) == strtolower(Configure::read("doctorLabel")) || (strtolower($checkRoleType['Role']['name']) == strtolower("Registrar"))) {
				if(isset($this->data['User']['first_name'])) {
					
					// set is registrar if exist //
				/*	if($checkRoleType['Role']['name'] == "Registrar" || $checkRoleType['Role']['name'] == "registrar") {
						$this->data['DoctorProfile']['is_registrar'] = "'1'";
					} else {
						$this->data['DoctorProfile']['is_registrar'] = "'0'";
					}*/
				
					
					if(!empty($this->data['DoctorProfile']['id'])){						
						$this->data['DoctorProfile']['doctor_name'] =  "'".ucfirst($this->data['User']['first_name'])." ".ucfirst($this->data['User']['middle_name'])." ".ucfirst($this->data['User']['last_name'])."'";
						$this->data['DoctorProfile']['first_name'] = "'".ucfirst($this->data['User']['first_name'])."'";
						$this->data['DoctorProfile']['last_name'] = "'".ucfirst($this->data['User']['last_name'])."'";
						$this->data['DoctorProfile']['middle_name'] = "'".ucfirst($this->data['User']['middle_name'])."'";
						$this->data['DoctorProfile']['dateofbirth'] = "'".$this->data['User']['dob']."'";
						$this->data['DoctorProfile']['department_id'] = "'".$this->data['DoctorProfile']['department_id']."'";
						$this->data['DoctorProfile']['is_registrar'] = "'".$this->data['DoctorProfile']['is_registrar']."'";
					//	$this->data['DoctorProfile']['is_doctor'] ="'".$this->data['DoctorProfile']['is_doctor']."'";
						$this->data['DoctorProfile']['photo'] = "'".$this->data['User']['photo']."'";
						$this->data['DoctorProfile']['is_active'] = "'".$this->data['User']['is_active']."'";
						$this->data['DoctorProfile']['expiration_date'] = "'".$this->data['User']['expiration_date']."'";
						$this->data['DoctorProfile']['user_id'] = "'".$this->data['User']['id']."'";
						$this->data['DoctorProfile']['modified_by'] = "'".AuthComponent::user('id')."'";
						$this->data['DoctorProfile']['modify_time'] = "'".date("Y-m-d H:i:s")."'";
						$this->data['DoctorProfile']['location_id'] = ($this->data['User']['location_id']) ? "'".$this->data['User']['location_id']."'"  : "'".AuthComponent::user('location_id')."'";
						$doctorprofile->unbindModel(array('belongsTo' => array('Department')));
						$doctorprofile->updateAll($this->data['DoctorProfile'], array('DoctorProfile.user_id' => $this->data['User']['id'],'DoctorProfile.id'=>$this->data['DoctorProfile']['id']));
					}else{
						$this->data['DoctorProfile']['doctor_name'] =  ucfirst($this->data['User']['first_name'])." ".ucfirst($this->data['User']['middle_name'])." ".ucfirst($this->data['User']['last_name']);
						$this->data['DoctorProfile']['first_name'] = ucfirst($this->data['User']['first_name']);
						$this->data['DoctorProfile']['last_name'] = ucfirst($this->data['User']['last_name']);
						$this->data['DoctorProfile']['middle_name'] = ucfirst($this->data['User']['middle_name']);
						$this->data['DoctorProfile']['dateofbirth'] = $this->data['User']['dob'];
						$this->data['DoctorProfile']['department_id'] = $this->data['DoctorProfile']['department_id'];
						$this->data['DoctorProfile']['is_registrar'] = $this->data['DoctorProfile']['is_registrar'];
					//	$this->data['DoctorProfile']['is_doctor'] =$this->data['DoctorProfile']['is_doctor'];
						$this->data['DoctorProfile']['photo'] = $this->data['User']['photo'];
						$this->data['DoctorProfile']['is_active'] =$this->data['User']['is_active'];
						$this->data['DoctorProfile']['expiration_date'] = "'".$this->data['User']['expiration_date']."'";
						$this->data['DoctorProfile']['user_id'] = $this->data['User']['id'];
						$this->data['DoctorProfile']['modified_by'] = AuthComponent::user('id');
						$this->data['DoctorProfile']['modify_time'] = date("Y-m-d H:i:s");
						$this->data['DoctorProfile']['location_id'] = ($this->data['User']['location_id']) ? $this->data['User']['location_id'] : AuthComponent::user('location_id');
						$doctorprofile->unbindModel(array('belongsTo' => array('Department')));
						$doctorprofile->save($this->data);
					}
				} else {
					// if change password action not happened //
					if($this->data["User"]["is_deleted"] == 1){
						$this->data['DoctorProfile']['is_deleted'] = "'1'";
						$this->data['DoctorProfile']['modified_by'] = "'".AuthComponent::user('id')."'";
						$this->data['DoctorProfile']['modify_time'] = "'".date("Y-m-d H:i:s")."'";
						//$doctorprofile->unbindModel(array('belongsTo' => array('User', 'Department')));
						$doctorprofile->unbindModel(array('belongsTo' => array('Department')));
						$succ = $doctorprofile->updateAll($this->data['DoctorProfile'], array('DoctorProfile.user_id' => $this->data['User']['id']));
					}
				}
			}else{
				$setRecordDeletedIfExist['is_deleted'] = '1';
				$doctorprofile->updateAll($setRecordDeletedIfExist, array('DoctorProfile.user_id' => $this->data['User']['id']));
			}
		} 
		if(/*$this->data['PlacementHistory'] || $this->data['HrDetail'] and */$this->data['User']['newUser']=="ls" ){  
			$this->saveHrDetail($this->data); 
			}		
	}
     
	/**
	 * @author:Swati Newale
	 * function to save data in hrdetail 
	 */
public function saveHrDetail($data= array()){  	
		$SerializeDataConfiguration = Classregistry::init('SerializeDataConfiguration');
		//debug($data);
		$data = $this->convertingDatetoSTD($data);
                
               $data["HrDetail"]['registration_no'] = (!empty($data["HrDetail"]['dr_registration_no'])) ? $data["HrDetail"]['dr_registration_no'] : $data["HrDetail"]['nurse_registration_no'];
               $data["HrDetail"]['is_scan_uplode'] = (!empty ($data["HrDetail"]['dr_is_scan_uplode'])) ?  $data["HrDetail"]['dr_is_scan_uplode'] : $data["HrDetail"]['nurse_is_scan_uplode'];
                
                $data["HrDetail"]['clearances_obtained_from'] = implode(',',$data["HrDetail"]['clearances_obtained_from']);
                if($data["HrDetail"]['id']){
                        $data["HrDetail"]["modify_time"] = date("Y-m-d H:i:s");
			$data["HrDetail"]["modified_by"] = "'".AuthComponent::user('id')."'";
			$data['HrDetail']['type_of_user']= Configure::read('UserType');
			$data['HrDetail']['location_id'] = ($data['User']['location_id']) ? $data['User']['location_id'] : AuthComponent::user('location_id');
                }else{
			$data["HrDetail"]["user_id"] = $data["User"]["id"];
			$data['HrDetail']['type_of_user']= Configure::read('UserType');
			$data["HrDetail"]["create_time"] = date("Y-m-d H:i:s");
			$data["HrDetail"]["created_by"] = AuthComponent::user('id');
			$data['HrDetail']['location_id'] = ($data['User']['location_id']) ? $data['User']['location_id'] : AuthComponent::user('location_id');
		}  
		Classregistry::init('HrDetail')->save($data);
		if(!empty($data['HrDocument']['qualification_detail'])){
		 $this->uploadUserDoc($data['HrDocument']['qualification_detail'],$data["User"]["id"]);
		}
		if($data['PlacementHistory']){
			//debug($data['PlacementHistory']); exit;
			foreach($data["PlacementHistory"] as $key =>$placementvalue ){
				    $data["PlacementHistory"][$key]['shifts'] = $data["PlacementHistory"][$key]['shifts'];
					$data["PlacementHistory"][$key]["user_id"] = $data["User"]["id"];
					$data["PlacementHistory"][$key]["management_approval"] = $data["PlacementHistory"][$key]['management_approval'];
					$data["PlacementHistory"][$key]["create_time"] = date("Y-m-d H:i:s");
					$data["PlacementHistory"][$key]["modify_time"] = date("Y-m-d H:i:s");
					$data["PlacementHistory"][$key]["modified_by"] = AuthComponent::user('id');
					$data["PlacementHistory"][$key]["created_by"] = AuthComponent::user('id');
					$data['PlacementHistory'][$key]['cadre_from_date'] = DateFormatComponent::formatDate2STD($placementvalue['cadre_from_date'],Configure::read('date_format'));
					$data['PlacementHistory'][$key]['cadre_to_date'] = DateFormatComponent::formatDate2STD($placementvalue['cadre_to_date'],Configure::read('date_format'));
					$data['PlacementHistory'][$key]['location_id'] = ($data['User']['location_id']) ? $data['User']['location_id'] : AuthComponent::user('location_id');
			} 
			
			Classregistry::init('PlacementHistory')->saveAll($data["PlacementHistory"]);
		}
		
		$subjectId = Classregistry::init('HrDetail')->id;
        $SerializeDataConfiguration->deleteAll(array('SerializeDataConfiguration.subject_id' => $subjectId,'SerializeDataConfiguration.subject_name' => 'HrDetail'));
        
        $SerializeDataConfiguration->saveData($subjectId,'HrDetail','qualification_detail',$data["HrDetail"]['qualification_detail']);
		$SerializeDataConfiguration->id = '';
		$SerializeDataConfiguration->saveData($subjectId,'HrDetail','company_assets',$data["HrDetail"]['company_assets']);
		$SerializeDataConfiguration->id = '';
		$SerializeDataConfiguration->saveData($subjectId,'HrDetail','appraisal_history',$data["HrDetail"]['appraisal_history']);
		$SerializeDataConfiguration->id = '';
		$SerializeDataConfiguration->saveData($subjectId,'HrDetail','family_member',$data["HrDetail"]['family_member']);
		$SerializeDataConfiguration->id = '';
		$SerializeDataConfiguration->saveData($subjectId,'HrDetail','personnel_issues',$data["HrDetail"]['personnel_issues']);
                $data["HrDetail"]['id'] = $subjectId;
                $this->saveEmployeePayDetail($data);
	}
function convertingDatetoSTD($data=array()){
			
		if(!empty($data['HrDetail']['thumb_impression_registed']))
			$data['HrDetail']['thumb_impression_registed'] = DateFormatComponent::formatDate2STD($data['HrDetail']['thumb_impression_registed'],Configure::read('date_format'));
		if(!empty($data['HrDetail']['date_of_join']))
			$data['HrDetail']['date_of_join'] = DateFormatComponent::formatDate2STD($data['HrDetail']['date_of_join'],Configure::read('date_format'));
		if(!empty($data['HrDetail']['month_year_appraisal']))
			$data['HrDetail']['month_year_appraisal'] = DateFormatComponent::formatDate2STD($data['HrDetail']['month_year_appraisal'],Configure::read('date_format'));
		if(!empty($data['HrDetail']['date_of_resignation']))
			$data['HrDetail']['date_of_resignation'] = DateFormatComponent::formatDate2STD($data['HrDetail']['date_of_resignation'],Configure::read('date_format'));
		if(!empty($data['HrDetail']['payment_date']))
			$data['HrDetail']['payment_date'] = DateFormatComponent::formatDate2STD($data['HrDetail']['payment_date'],Configure::read('date_format'));
		if(!empty($data['HrDetail']['relieving_letter_issued_date']))
			$data['HrDetail']['relieving_letter_issued_date'] = DateFormatComponent::formatDate2STD($data['HrDetail']['relieving_letter_issued_date'],Configure::read('date_format'));
		if(!empty($data['HrDetail']['date_of_relieving']))
			$data['HrDetail']['date_of_relieving'] = DateFormatComponent::formatDate2STD($data['HrDetail']['date_of_relieving'],Configure::read('date_format'));
		if(!empty($data['HrDetail']['experience_letter_issued_on']))
			$data['HrDetail']['experience_letter_issued_on'] = DateFormatComponent::formatDate2STD($data['HrDetail']['experience_letter_issued_on'],Configure::read('date_format'));
		if(!empty($data['HrDetail']['gratuily_closed_on']))
			$data['HrDetail']['gratuily_closed_on'] = DateFormatComponent::formatDate2STD($data['HrDetail']['gratuily_closed_on'],Configure::read('date_format'));
		if(!empty($data['HrDetail']['esi_closed_date']))
			$data['HrDetail']['esi_closed_date'] = DateFormatComponent::formatDate2STD($data['HrDetail']['esi_closed_date'],Configure::read('date_format'));
		if(!empty($data['HrDetail']['pf_date'])) 
			$data['HrDetail']['pf_date'] = DateFormatComponent::formatDate2STD($data['HrDetail']['pf_date'],Configure::read('date_format'));
		if(!empty($data['HrDetail']['valid_till']))
			$data['HrDetail']['valid_till'] = DateFormatComponent::formatDate2STD($data['HrDetail']['valid_till'],Configure::read('date_format'));
		if(!empty($data['HrDetail']['starts_on']))
			$data['HrDetail']['starts_on'] = DateFormatComponent::formatDate2STD($data['HrDetail']['starts_on'],Configure::read('date_format'));
		if(!empty($data['HrDetail']['ends_on']))
			$data['HrDetail']['ends_on'] = DateFormatComponent::formatDate2STD($data['HrDetail']['ends_on'],Configure::read('date_format'));
		if(!empty($data['HrDetail']['probation_complition_date']))
			$data['HrDetail']['probation_complition_date'] = DateFormatComponent::formatDate2STD($data['HrDetail']['probation_complition_date'],Configure::read('date_format'));
        if(!empty($data['HrDetail']['last_working_days']))
			$data['HrDetail']['last_working_days'] = DateFormatComponent::formatDate2STD($data['HrDetail']['last_working_days'],Configure::read('date_format'));
        if(!empty($data['HrDetail']['pay_application_date']))
        	$data['HrDetail']['pay_application_date'] = DateFormatComponent::formatDate2STD($data['HrDetail']['pay_application_date'],Configure::read('date_format'));
		if(!empty($data['EmployeePayDetail']['pay_application_date']))
			$data['EmployeePayDetail']['pay_application_date'] = DateFormatComponent::formatDate2STD($data['EmployeePayDetail']['pay_application_date'],Configure::read('date_format'));
		//debug(Configure::read('date_format'));
		//debug($data['HrDetail']['date_of_join']);exit;
		return $data;
		
	}
	public function saveEmployeePayDetail($data = array()){
		$session = new CakeSession();
		$employeePayDetail = Classregistry::init('EmployeePayDetail'); //debug($data);exit;
		foreach($data['EmployeePayDetail'] as $earningAndDeductions){
			//if($earningAndDeductions['is_applicable'] != 1) continue;
			$earningDeductionData[] = array(
					'id' => $earningAndDeductions['id'],
					'hr_detail_id' => $data['HrDetail']['id'],
					'user_id' => $data['User']['id'],
					'pay_application_date' => $data['HrDetail']['pay_application_date'],
					'user_salary' => $data['HrDetail']['user_salary'],
					'earning_deduction_id' => $earningAndDeductions['earning_deduction_id'],
					'service_category_id' => $earningAndDeductions['service_category_id'],
					'is_applicable'=> $earningAndDeductions['is_applicable'],//($earningAndDeductions['is_applicable'] != 1 and isset($data['HrDetail']['pay_application_date'])) ? 1 : 0,
					'day_amount' => $earningAndDeductions['day_amount'],
					'night_amount'=> $earningAndDeductions['night_amount'],
					'ward_charges' => (isset($earningAndDeductions['ward_charges'])) ? serialize($earningAndDeductions['ward_charges']) : null,
					'print_in_pay_slip' => $earningAndDeductions['print_in_pay_slip'] ? 1 : 0,
					'location_id' => $session->read('locationid'),
					'create_time' =>  date('Y-m-d H:i:s'),
					'created_by' => $session->read('userid'),
					'modified_by' => $earningAndDeductions['id'] ? $session->read('userid') : null,
					'modified_time' => $earningAndDeductions['id'] ? date('Y-m-d H:i:s') : null
			);
		}
		$employeePayDetail->saveAll($earningDeductionData);
	}
	public function beforeSave($options = array()) {
		
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = sha1($this->data[$this->alias]['password']);
		}
		if (isset($this->data[$this->alias]['first_name'])) {
			$this->data[$this->alias]['first_name'] = ucfirst(trim($this->data[$this->alias]['first_name']));
		}
		if (isset($this->data[$this->alias]['middle_name'])) {
			$this->data[$this->alias]['middle_name'] = ucfirst(trim($this->data[$this->alias]['middle_name']));
		}
		if (isset($this->data[$this->alias]['last_name'])) {
			$this->data[$this->alias]['last_name'] = ucfirst(trim($this->data[$this->alias]['last_name']));
		}
		return true;
	}

	/**
	 * 
	 * @param int $location_id
	 * @return list of doctors (id,name)
	 */
	public function getDoctorsByLocation($location_id=null){
		//$this->recursive = -1;
		$session = new CakeSession();
		if(!$location_id) $location_id = $session->read('locationid');
		
		$this->unbindModel(array(
				'belongsTo' => array('State','City','Country')));
		$this->bindModel(array(
				'hasOne' => array('DoctorProfile'=>array('foreignKey'=>'user_id'))));
		$details =  $this->find('all',array('fields'=>array('User.full_name','User.id'),'conditions'=>array('Role.name'=>Configure::read("doctorLabel"),
				'User.location_id'=>$location_id,'User.is_active'=>1,'DoctorProfile.is_deleted'=>0,'DoctorProfile.is_registrar'=>0, 'User.is_deleted'=>0,'User.is_doctor'=>1),
				'order'=>array('User.first_name Asc')));
		$return_arr =array();
		  
		foreach($details as $key =>$value){
			foreach($details[$key] as $lastnode){
				$return_arr[$lastnode['id']]  =  $lastnode['full_name'] ;
			}
		} 
		return $return_arr ;
	}

	function getHospitalId(){

	}

	function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds)){
			$session = new cakeSession();
			if($session->read('db_name')!="")
			{
				$this->specific = true;
				$this->db_name =  $session->read('db_name');
			}
		}else{
			$this->db_name =  $ds;
		}
		
		parent::__construct($id, $table, $ds);
	}
	function getLocationId(){
		$session = new CakeSession();
		return $session->read('locationid');
	}

	public function getDoctorByID($doctor_id=null){
		if(!empty($doctor_id)){
			$this->unbindModel(array(
					'belongsTo' => array('State','City','Country')));
			/*$this->bindModel(array(
					'belongsTo' => array(
							'Initial' =>array( 'foreignKey'=>'initial_id'))));*/
			if(is_array($doctor_id)){
				return $this->find('all',array('fields'=>array('CONCAT(User.first_name, " ", User.last_name) as fullname','mobile'),
						'conditions'=>array('User.id'=>$doctor_id),'recursive'=>1));
			}else{
				return $this->find('first',array('fields'=>array('CONCAT(User.first_name, " ", User.last_name) as fullname','mobile'),
						'conditions'=>array('User.id'=>$doctor_id),'recursive'=>1));
			}
		}
	}

	/**
	 * get all doctor ids only by locaiton
	*   
	*/
	public function getDoctorList($locationid) {
		$doctorArrayId = array(); 
		
		$getAllDoctors = $this->find('all', array('conditions' => array('User.is_deleted' => 0, 'Role.name' => Configure::read("doctorLabel"), 'User.location_id' => $locationid), 'fields' => array('User.id')));
		  
		foreach($getAllDoctors as $getAllDoctorsVal) {
			$doctorArrayId[] = $getAllDoctorsVal['User']['id'];
		}
		return $doctorArrayId;
	}
		 
	
	
	function getUserByID($id=null,$fields=array()){
		return $this->find('first', array('conditions' => array('User.id' => $id), 'fields' => $fields, 'recursive' => 1));
		//return $this->read($fields,$id);
	}
	/*
	 *
	* send auto generated password to the users
	*
	*/
	function sendUserPasswordMail($data=null, $genratepass=null) {
		App::uses('CakeEmail', 'Network/Email');
		// get hospital details of register user //
		$hospitalDetail = Classregistry::init('Facility')->find('first', array('conditions' => array('Facility.id' => $data['User']['facility_id']), 'fields' => array('Facility.name')));
		if(!empty($hospitalDetail['Facility']['name'])) {
			$hospitalName = $hospitalDetail['Facility']['name'];
		} else {
			$hospitalName = 'Hope Hospital Nagpur';
		}
		$email = new CakeEmail();
		$email->config('default');
		$email->template('usercreation','usercreation');
		$email->emailFormat('html');
		$email->viewVars(array('username' => $data['User']['username'], 'password' => $genratepass, 'hospitalName' => $hospitalName));
		$email->subject('Account Creation Mail::'.$hospitalName);
		$email->to(array($data['User']['email']));
		$email->bcc(array('pankajw@drmhope.com'));
		$email->from(array('pankajw@drmhope.com' => $hospitalName));
		$email->send();
		return true;
	}


	function getAnaesthesistAndNone($is_anaesthesist){
		$session = new CakeSession();

		$this->virtualFields = array(
				'doctor_name' => 'CONCAT(Initial.name, " ", DoctorProfile.doctor_name)'
		);
		$this->unbindModel(array( 'belongsTo' => array('City','State','Country','Role','Initial')   ));

		$this->bindModel(array('belongsTo'=>array('Initial' => array('foreignKey' =>'initial_id'),
				'DoctorProfile' => array( 'foreignKey' => false,'conditions' => array('User.id = DoctorProfile.user_id')),
				'Department' => array( 'foreignKey' => false,'conditions' => array('Department.id = DoctorProfile.department_id')),
		)
		));
		$anaesthesistArr=array();
		if($is_anaesthesist){
			$getAnaesthesistData=$this->find('all',array('fields'=>array('Initial.name as nameInitial','DoctorProfile.user_id','DoctorProfile.doctor_name'),
					'conditions'=>array('User.is_deleted'=>0, 'DoctorProfile.is_deleted'=>0,'User.location_id'=>$session->read('locationid'), 'DoctorProfile.is_registrar'=>0,'Department.name  LIKE'=> "%Anaesthesia%"),
					'contain' => array('User', 'Initial'), 'recursive' => 1));
		}else{
			$getAnaesthesistData=$this->find('all',array('fields'=>array('Initial.name as nameInitial','DoctorProfile.user_id','DoctorProfile.doctor_name'),
					'conditions'=>array('User.is_deleted'=>0, 'DoctorProfile.is_deleted'=>0,'User.location_id'=>$session->read('locationid'), 'DoctorProfile.is_registrar'=>0,'Department.name NOT LIKE'=> "%Anaesthesia%"),
					'contain' => array('User', 'Initial'), 'recursive' => 1));
		}
		
		foreach($getAnaesthesistData as $keySurgeon=>$getAnaesthesistDatas){
			$anaesthesistArr[$getAnaesthesistDatas['DoctorProfile']['user_id']] = $getAnaesthesistDatas['Initial']['nameInitial'].' '.$getAnaesthesistDatas['DoctorProfile']['doctor_name'];
		}
		return $anaesthesistArr;		 
	}
	
	function getUserByDepartmentName($departmentName){
		$session = new CakeSession();
	
		$this->virtualFields = array(
				'doctor_name' => 'CONCAT(Initial.name, " ", DoctorProfile.doctor_name)'
		);
		$this->unbindModel(array( 'belongsTo' => array('City','State','Country','Role','Initial')   ));
	
		$this->bindModel(array('belongsTo'=>array('Initial' => array('foreignKey' =>'initial_id'),
				'DoctorProfile' => array( 'foreignKey' => false,'conditions' => array('User.id = DoctorProfile.user_id')),
				'Department' => array( 'foreignKey' => false,'conditions' => array('Department.id = DoctorProfile.department_id')),
		)
		));
		$userArr=array();
		$getUserData=$this->find('all',array('fields'=>array('Initial.name as nameInitial','DoctorProfile.user_id','DoctorProfile.doctor_name'),
					'conditions'=>array('User.is_deleted'=>0, 'DoctorProfile.is_deleted'=>0,'User.location_id'=>$session->read('locationid'),
							 'DoctorProfile.is_registrar'=>0,'Department.name  LIKE'=> "%$departmentName%"),'contain' => array('User', 'Initial'), 'recursive' => 1));
		
		foreach($getUserData as $keySurgeon=>$getUserDatas){
			$userArr[$getUserDatas['DoctorProfile']['user_id']] = $getUserDatas['Initial']['nameInitial'].' '.$getUserDatas['DoctorProfile']['doctor_name'];
		}
		return $userArr;
	}
	function getUsersByRole($role_id){
		if(empty($role_id)) return ;
		$session = new cakeSession();

		$this->unbindModel(array( 'belongsTo' => array('City','State','Country','Role','Initial')   ));

		$this->bindModel(array('belongsTo'=>array('Initial' => array('foreignKey' =>'initial_id'))
		));
		return $this->find('list',array('conditions'=>array('role_id'=>$role_id,'location_id'=>$session->read('locationid'),'is_deleted'=>0),
				'fields'=>array('full_name'), 'recursive' => 1));
	}

	//return all userse for logged location
	function getUsers(){

		$session = new cakeSession();

		$this->unbindModel(array( 'belongsTo' => array('City','State','Country','Role','Initial')   ));

		$this->bindModel(array('belongsTo'=>array('Initial' => array('foreignKey' =>'initial_id'))
		));
		return $this->find('list',array('conditions'=>array('location_id'=>$session->read('locationid'),'is_deleted'=>0),
				'fields'=>array('full_name'), 'recursive' => 1));
	}
	
	function getUsersAllLocation(){

		$session = new cakeSession();

		$this->unbindModel(array( 'belongsTo' => array('City','State','Country','Role','Initial')   ));

		$this->bindModel(array('belongsTo'=>array('Initial' => array('foreignKey' =>'initial_id'))
		));
		return $this->find('list',array('conditions'=>array('is_deleted'=>0),
				'fields'=>array('full_name'), 'recursive' => 1));
	}

	function getPathologist(){
		$session = new cakeSession();
		$queryData  = $this->find('list',array('conditions'=>array('Role.name'=>Configure::read('pathologist'),
				'User.location_id '=>array($session->read('locationid'),$session->read('locationid')),'User.is_deleted'=>0),'fields'=>array('User.id','User.full_name'), 'recursive' => 1));

		return $queryData ;
	}
	 
	function getRadiologist(){
		$session = new cakeSession();
		$queryData  = $this->find('list',array('conditions'=>array('Role.name'=>Configure::read('radiologist'),
				'User.location_id '=>array($session->read('locationid'),$session->read('locationid')),'User.is_deleted'=>0),'fields'=>array('User.id','User.full_name'), 'recursive' => 1));

		return $queryData ;
	}
	 
	/**
	 * get Medical Coder
	 * @author Gaurav Chauriya
	 *
	 */
	function getMedicalCoder(){
		$session = new cakeSession();
		$queryData  = $this->find('list',array('conditions'=>array('Role.name'=>Configure::read('medicalCoder'),
				'User.location_id '=>array($session->read('locationid'),$session->read('locationid')),'User.is_deleted'=>0),'fields'=>array('User.id','User.full_name'), 'recursive' => 1));
		 
		return $queryData ;
	}
	
	function getResidentDoctor($locationId = null){
		$session = new cakeSession();
		$locationId = ($locationId) ? $locationId : $session->read('locationid');
		$roleTable = Classregistry::init('Role');
		$ResidentLabel=Configure::read('residentLabel');
		$roleIdResg=$roleTable->find('first',array('fields'=>array('id'),'conditions'=>array('name'=>$ResidentLabel)));
		$queryData  = $this->find('list',array('conditions'=>array('User.role_id'=>$roleIdResg['Role']['id'],
				'User.location_id '=>$locationId,'User.is_deleted'=>0),
				'fields'=>array('User.id','User.full_name'), 'recursive' => 1));
			
		return $queryData ;
	}
	function getResidentDoctorRegister(){
		$session = new cakeSession();
		$roleTable = Classregistry::init('Role');
		$RegistrarLabel=Configure::read('RegistrarLabel');
		$roleIdResg=$roleTable->find('first',array('fields'=>array('id'),'conditions'=>array('name'=>$RegistrarLabel)));
		$queryData  = $this->find('list',array('conditions'=>array('User.role_id'=>$roleIdResg['Role']['id'],
				'User.location_id '=>array($session->read('locationid'),$session->read('locationid')),'User.is_deleted'=>0),
				'fields'=>array('User.id','User.full_name'), 'recursive' => 1));
			
		return $queryData ;
	}
	function getResidentPCP(){
		$session = new cakeSession();
		$roleTable = Classregistry::init('Role');
		$roleName=Configure::read('doctorLabel');
		$roleId=$roleTable->find('first',array('fields'=>array('id'),'conditions'=>array('name'=>$roleName)));
		$queryData  = $this->find('list',array('conditions'=>array('User.role_id'=>$roleId['Role']['id'],
				'User.location_id '=>array($session->read('locationid'),$session->read('locationid')),'User.is_deleted'=>0),
				'fields'=>array('User.id','User.full_name'), 'recursive' => 1));
			
		return $queryData ;
	}
	 
	/**
	 *
	 *  get surgeon list
	 *
	 */
	function getSurgeonlist($locationId = null){
		$session = new CakeSession();
		$locationId = ($locationId) ? $locationId : $session->read('locationid');
		$this->virtualFields = array(
				'doctor_name' => 'CONCAT(Initial.name, " ", DoctorProfile.doctor_name)'
		);
		$this->unbindModel(array( 'belongsTo' => array('City','State','Country','Role','Initial')   ));

		$this->bindModel(array('belongsTo'=>array('Initial' => array('foreignKey' =>'initial_id'),
				'DoctorProfile' => array( 'foreignKey' => false,'conditions' => array('User.id = DoctorProfile.user_id')),
				'Department' => array( 'foreignKey' => false,'conditions' => array('Department.id = DoctorProfile.department_id')),
		)
		));
		 
		return $this->find('list',array('fields'=>array('DoctorProfile.user_id','DoctorProfile.doctor_name'),
				'conditions'=>array('User.is_deleted'=>0, 'DoctorProfile.is_deleted'=>0,'User.location_id'=>$locationId, 'DoctorProfile.is_surgeon'=>1),
				'contain' => array('User', 'Initial'), 'recursive' => 1));
		 
		 
	}

	function getUserDetails($userId){
		$userName = $this->find('first',array('conditions' => array('User.id' => $userId),'fields'=>array('username','first_name','last_name')));
		return $userName;
	}
	 
	 
	function getUsersByRoleName($role_name, $locationId = null){
		if(empty($role_name)) return ;
		$session = new cakeSession();
		$locationId = ($locationId) ? $locationId : $session->read('locationid');
		$this->unbindModel(array( 'belongsTo' => array('City','State','Country','Initial')   ));
		 
		$this->bindModel(array('belongsTo'=>array('Initial' => array('foreignKey' =>'initial_id'))
		));
		return $this->find('list',array('conditions'=>array('Role.name'=>$role_name,'User.location_id'=>$locationId,'User.is_deleted'=>0,'User.is_active'=>1),
				'fields'=>array('full_name'), 'recursive' => 1));
	}
	 
	//return doctors department id
	function getUserDept($id=null){
		if(!$id) return null ;
		$result = $this->find('first',array('fields'=>array('User.department_id','User.mobile'),'conditions'=>Array('User.id'=>$id))) ;
		return $result  ;

	}
	 
	public function userWithSign(){
		 
		$getSign=$this->find('list',array('conditions'=>array('User.sign <>'=>''),'fields'=>array('User.id','User.sign')));
		return $getSign;
	}
	
	/**
	*
	* @param int $location_id
	* @return list of doctors (id,name)
	*/
	public function getAllDoctors(){
		
	
		$this->unbindModel(array(
					'belongsTo' => array('State','City','Country')));
		$this->bindModel(array(
					'hasOne' => array('DoctorProfile'=>array('foreignKey'=>'user_id'))));
		$details =  $this->find('all',array('fields'=>array('User.full_name','User.id'),'conditions'=>array('Role.name'=>Configure::read("doctorLabel"),
					'User.is_active'=>1,'DoctorProfile.is_deleted'=>0,'DoctorProfile.is_registrar'=>0, 'User.is_deleted'=>0),
					'order'=>array('User.first_name Asc')));
		$return_arr =array();
	
		foreach($details as $key =>$value){
			foreach($details[$key] as $lastnode){
				$return_arr[$lastnode['id']]  =  $lastnode['full_name'] ;
			}
		}
		return $return_arr ;
	}
	 
	//for staff only
	function getUserStaff(){
		$session = new cakeSession();
		$this->unbindModel(array( 'belongsTo' => array('City','State','Country','Role','Initial')   ));
		$this->bindModel(array('belongsTo'=>array('Initial' => array('foreignKey' =>'initial_id'))
		));
		return $this->find('list',array('conditions'=>array('location_id'=>$session->read('locationid'),'is_deleted'=>0,'role_id !='=>'3'),
				'fields'=>array('full_name'), 'recursive' => 1));
	} 
	//function for fetching the staffs using keyword
	public function getUserStaffByKeyword($keyword=null){
		if(empty($keyword)) return false;
		$session = new cakeSession();
		$this->unbindModel(array( 'belongsTo' => array('City','State','Country','Role','Initial')   ));
		$this->bindModel(array('belongsTo'=>array('Initial' => array('foreignKey' =>'initial_id'))
		));
		$result = $this->find('list',array('conditions'=>array('location_id'=>$session->read('locationid'),'role_id !='=>'3',
				'is_deleted'=>0,'full_name like'=>'%'.$keyword.'%'),
				'fields'=>array('full_name'),'limit'=>10, 'recursive' => 1));
	
		return $result;
	}
	//finction for fetching the doctors using keyword
	public function getDoctorsByKeyword($keyword=null){
		if(empty($keyword)) return false;
		$this->unbindModel(array(
				'belongsTo' => array('State','City','Country')));
		$this->bindModel(array(
				'hasOne' => array('DoctorProfile'=>array('foreignKey'=>'user_id','type'=>'INNER'))));
		$details =  $this->find('all',array('fields'=>array('User.full_name','User.id'),
				'conditions'=>array('User.is_active'=>1,'User.is_deleted'=>0,'User.full_name like'=>'%'.$keyword.'%'),
				'limit'=>10));
		$return_arr =array();
		foreach($details as $key =>$value){
			foreach($details[$key] as $lastnode){
				$return_arr[$lastnode['id']]  =  $lastnode['full_name'] ;
			}
	
		}
		return $return_arr;
	}
	
	
	/**
	 *
	 * @param int $location_id
	 * @return list of doctors (id,name)
	 * Pooja
	 */
	public function getOpdDoctors(){
	
		$session = new CakeSession();	
		$this->unbindModel(array(
				'belongsTo' => array('State','City','Country')));
		$this->bindModel(array(
				'hasOne' => array('DoctorProfile'=>array('foreignKey'=>'user_id'))
			));
		
			//debug($this);die();
		//if($session->read('website.instance')=='vadodara'){
		//	$details =  $this->find('all',array('fields'=>array('User.full_name','User.id'),'conditions'=>array('Role.name'=>Configure::read("doctorLabel"),
			//	'User.is_active'=>1,'DoctorProfile.is_deleted'=>0/*,'DoctorProfile.is_registrar'=>0*/,'User.is_doctor'=>1,'DoctorProfile.is_opd_allow'=>'1', 'User.is_deleted'=>0),
		//		'order'=>array('User.first_name Asc'))); 
	//	}else{
			
			$details =  $this->find('all',array('fields'=>array('User.full_name','User.id'),'conditions'=>array(/*'Role.name'=>Configure::read("doctorLabel"),*/
				'User.is_active'=>1,'DoctorProfile.is_deleted'=>0/*,'DoctorProfile.is_registrar'=>0*/,'User.is_doctor'=>1,'DoctorProfile.is_opd_allow'=>'1', 'User.is_deleted'=>0,'User.location_id'=>$session->read('locationid')?$session->read('locationid'):1),
				'order'=>array('User.first_name Asc')));
		//}
		$return_arr =array();
		foreach($details as $key =>$value){
			foreach($details[$key] as $lastnode){
				$return_arr[$lastnode['id']]  =  $lastnode['full_name'] ;
			}
		}
		return $return_arr ;
	}
	
	function importDataUser(&$dataOfSheet) {
		$user = Classregistry::init ( 'User' );
		$doctor_profile = Classregistry::init ( 'DoctorProfile' );
		$roleObj = Classregistry::init ('Role' );
		$designationObj=Classregistry::init ('Designation' );
		$departmentObj=Classregistry::init ('Department' );
		$stateObj=Classregistry::init ('State' );
		$cityObj=Classregistry::init ('City' );
		$session = new cakeSession ();
		$dataOfSheet->row_numbers = false;
		$dataOfSheet->col_letters = false;
		//$dataOfSheet->sheet = 0;
		$dataOfSheet->table_class = 'excel';
		//debug($dataOfSheet->sheets);
		 
	
		for($row = 2; $row <= $dataOfSheet->sheets[0]['numRows']; $row ++) {
			 
			
			if(empty($dataOfSheet->sheets[0]['cells'][$row]['6'])){
				continue; //If role is empty no need to insert
			}else{			
				 
				$initial = trim($dataOfSheet->sheets[0]['cells'][$row]['1']);
				$this->data['User']['first_name'] = trim ($dataOfSheet->sheets[0]['cells'][$row]['2']);				
				$this->data['User']['middle_name'] = addslashes ($dataOfSheet->sheets[0]['cells'][$row]['3']);
				$this->data['User']['last_name'] = addslashes ($dataOfSheet->sheets[0]['cells'][$row]['4']);
				$username=$this->validateUsername($this->data['User']['first_name'],0); // checks for unique username
				$this->data['User']['username'] =$username ;
				$this->data['User']['password']="Vadodara@123";
				$password[0]="Vadodara@123";// for serialize
				$this->data['User']['previous_password']=serialize($password);
				$this->data['User']['first_login']='no';				
				$this->data['User']['gender'] = trim ($dataOfSheet->sheets[0]['cells'][$row]['5']);
				
				$this->data['User']['location_id']=trim($dataOfSheet->sheets[0]['cells'][$row]['7']);
				
				$role=trim($dataOfSheet->sheets[0]['cells'][$row]['6']);			
				$role_id=$roleObj->find('first',array('fields'=>array('id'),
						'conditions'=>array('name'=>ucwords($role),'location_id'=>$this->data['User']['location_id'])));
				if(empty($role_id)){
					$role=ucwords($role);
					$roleObj->save(array(
							'name'=>$role,
							'location_id'=>$this->data['User']['location_id'],
							'created_by'=>$session->read('userid'),
							'create_time'=>date('Y-m-d H:i:s')));
					$role_id=$this->data['User']['role_id']=$roleObj->id;
					$roleObj->id='';
				}else{
					$role_id=$this->data['User']['role_id']=$role_id['Role']['id'];
				}
				
				
				$designation=trim($dataOfSheet->sheets[0]['cells'][$row]['8']);						
				$designation_id=$designationObj->find('first',array('fields'=>array('id'),
						'conditions'=>array('name'=>ucwords($designation),'location_id'=>$this->data['User']['location_id'])));
				
				if(empty($designation_id)){
					$design=ucwords($designation);
					$designationObj->save(array(
							'name'=>$design,
							'location_id'=>$this->data['User']['location_id'],
							'created_by'=>$session->read('userid'),
							'create_time'=>date('Y-m-d H:i:s')));
					$this->data['User']['designation_id']=$designationObj->id;
					$designationObj->id='';
				}else{
					$this->data['User']['designation_id']=$designation_id['Designation']['id'];
				}
				
				$department=trim($dataOfSheet->sheets[0]['cells'][$row]['9']);
				$department_id=$departmentObj->find('first',array('fields'=>array('id'),
						'conditions'=>array('name'=>ucwords($department),'is_active'=>'1','location_id'=>$this->data['User']['location_id'])));
				
				if(empty($department_id)){
					$depart=ucwords($department);
					$departmentObj->save(array(
							'name'=>$depart,
							'location_id'=>$this->data['User']['location_id'],
							'created_by'=>$session->read('userid'),
							'create_time'=>date('Y-m-d H:i:s')));
					$this->data['User']['department_id']=$departmentObj->id;
					$departmentObj->id='';
				}else{
					$this->data['User']['department_id']=$department_id['Department']['id'];
				}
				
				$this->data['User']['dob']=trim($dataOfSheet->sheets[0]['cells'][$row]['10']);
				$this->data['User']['address1']=trim($dataOfSheet->sheets[0]['cells'][$row]['11']);
				
				$this->data['User']['country_id']='1';//INDIA
						
				//checking for state
				$state=trim($dataOfSheet->sheets[0]['cells'][$row]['13']);			
				$state_id=$stateObj->find('first',array('fields'=>array('id'),
						'conditions'=>array('name'=>ucwords($state),'country_id'=>'1')));
				
				
				if(empty($state_id)){
					$state=ucwords($state);
					$stateObj->save(array(
							'name'=>$state,
							'country_id'=>"1",
							'created_by'=>$session->read('userid'),
							'create_time'=>date('Y-m-d H:i:s')));
					$this->data['User']['state_id']=$stateObj->id;
					$stateObj->id='';
				}else{
					$this->data['User']['state_id']=$state_id['State']['id'];
				}
				//EOF state
				
				//Checking for city
				$city=trim($dataOfSheet->sheets[0]['cells'][$row]['12']);			
				$city_id=$cityObj->find('first',array('fields'=>array('id'),
						'conditions'=>array('name'=>ucwords($city),'state_id'=>$this->data['User']['state_id'])));
				
				if(empty($city_id)){
					$city=ucwords($city);
					if($city){
						$cityObj->save(array(
								'name'=>$city,
								'state_id'=>$this->data['User']['state_id'],
								'created_by'=>$session->read('userid'),
								'create_time'=>date('Y-m-d H:i:s')));
						$this->data['User']['city_id']=$cityObj->id;
						$cityObj->id='';
					}
				}else{
					$this->data['User']['city_id']=$city_id['City']['id'];
				}
				//EOF City
				$this->data['User']['zipcode']=trim($dataOfSheet->sheets[0]['cells'][$row]['14']);
				$this->data['User']['phone1']=trim($dataOfSheet->sheets[0]['cells'][$row]['15']);				
				$this->data['User']['mobile']=trim($dataOfSheet->sheets[0]['cells'][$row]['16']);
				$this->data['User']['email']=trim($dataOfSheet->sheets[0]['cells'][$row]['17']);
				$this->data['User']['password_expiry']=date("Y-m-d", strtotime("+2 month"));				
				$this->data['User']['create_time'] = date ( "Y-m-d H:i:s" );
				$this->data['User']['created_by'] = $session->read ( 'userid' );
			 	
				$this->id = '';
				$this->save($this->data['User']);
				//mapping to master table
				$facilityUserMapping=Classregistry::init ( 'FacilityUserMapping' );
				$facilityUserMapping->save(array(
						'role_id'=>$role_id,
						'facility_id'=>$session->read('facilityid'),
						'username'=>$username,
				));
				$facilityUserMapping->id='';
				$this->id='';
				
			}
	
		}
			
		return true ;
	}
	
	/**
	 * Function validates username "recursive function" returns username
	 * @param unknown_type $name
	 * @return number|Ambigous <multitype:, NULL, mixed>
	 * Pooja Gupta
	 */
	function validateUsername($name,$i){
		$username1 = $name;		 
		if($username1 == ''){
			return 0;
		}
		if($i==0){
			$username1 = $name;
		}else{
			$username1 = $name.$i;
		}
		 
		$count = $this->find('count',array('conditions'=>array('User.username'=>$username1,'User.is_deleted' => 0)));
		$i = $i+1;  
		if($count==0){  
		 	return $username1 ; 
		}else{
			return $this->validateUsername($name,$i);
		}
	}
	
	public function getAllDoctorList() {//$this->User->unBindModel(array('belongsTo' => array('City','State','Country','Role','Initial')));
		$session = new cakeSession ();
		$doctorArrayId = array();
		Classregistry::init('User')->unbindModel(array('belongsTo' => array('City','State','Country','Initial')));
		$getAllDoctors = $this->find('all', array(
				'conditions' => array('User.is_deleted' => 0, 'Role.name' => Configure::read("doctorLabel"), 'User.location_id' => $session->read('locationid')),
				'fields' => array('User.id','CONCAT(User.first_name, " ", User.last_name) as fullname'),'order'=>'User.first_name ASC'));
		
		foreach($getAllDoctors as $getAllDoctorsVal) {
			$doctorArrayId[$getAllDoctorsVal['User']['id']] = $getAllDoctorsVal[0]['fullname'];
		}
		return $doctorArrayId;
	}	
	
	public function getAllUserByIDs($id=array()){
		$session = new cakeSession ();
		Classregistry::init('User')->unbindModel(array('belongsTo' => array('City','State','Country','Initial')));
		return $this->find('list',array('conditions'=>array('User.id'=>$id),
				'fields'=>array('full_name'), 'recursive' => 1));
	}
	
	// temp import function for hope hospital--Atulc
	function importDataHope($dataOfSheet){
		/* pr();
		pr($dataOfSheet);exit; */
		$service_category = Classregistry::init('ServiceCategory');
		$service_sub_category = Classregistry::init('ServiceSubCategory');
		$tariff_list = Classregistry::init('TariffList');
		$tariff_amount = Classregistry::init('TariffAmount');
		$tariff_standard = Classregistry::init('TariffStandard');
	
		$session = new cakeSession();
		$dataOfSheet->row_numbers=false;
		$dataOfSheet->col_letters=false;
		$dataOfSheet->sheet=0;
		$dataOfSheet->table_class='excel';
	
		try
		{
			for($row=2;$row<=count($dataOfSheet->sheets[0]['cells']);$row++) {
				$category_id= "";
				$sub_category_id="";
				$tariff_standard_id="";
				$tariff_list_id ="";
				$serviceC = trim($dataOfSheet->sheets[0]['cells'][$row]['1']);
				$service = addslashes(trim($dataOfSheet->sheets[0]['cells'][$row]['2']));
				$cghs = trim($dataOfSheet->sheets[0]['cells'][$row]['3']);
				if(!$service) continue ;
				$createtime = date("Y-m-d H:i:s");
				$createdby = $session->read('userid');
				if(empty($validity))
					$validity = "1";
				//find service group if exist
				$category = $service_category->find("first",array("conditions" =>array("ServiceCategory.name"=>$serviceC,
						"ServiceCategory.location_id"=>$session->read('locationid'),
						"ServiceCategory.is_deleted" => '0'
				)));
	
	
				if(!empty($category)){
					$category_id = $category['ServiceCategory']['id']; //already exist
				}else{
					//or insert SC
					$service_category->create();
					$service_category->save(array("name"=>$serviceC,'location_id'=>$session->read('locationid'),"is_view"=>"1","create_time"=> $createtime,"created_by"=>$createdby));
					$category_id = $service_category->id;
				}
	
	
	
				/* for Tariff List/ For mapping lab charges have to create one service with same name as lab*/
				$tariffList = $tariff_list->find("first",array("conditions" =>array("TariffList.name"=>$service,
						"TariffList.service_category_id"=>$category_id,
						"TariffList.location_id"=>$session->read('locationid'))));
				if(!empty($tariffList)){
					$tariff_list_id = $tariffList['TariffList']['id'];
				}else{
					$tariff_list->create();
					$tariff_list->save(array(
								
							"short_name" =>  $serviceShort,
							"location_id"=>$session->read('locationid'),
							"name"=>$service,
							"cghs_code"=>$cghs,
							"service_category_id"=>$category_id,
							"apply_in_a_day" =>$validity,
							"create_time"=> $createtime,
							"created_by"=>$createdby
					));
					$tariff_list_id = $tariff_list->id;
				}
	
	
				//BOF tariff amount
				$tariff_standard_id  = '39';
	
				$hospitalType = $session->read('hospitaltype');
	
				//foreach($tariffStandardArray as $tariff_standard_id => $rowNo){
				$check_edit_amount = $tariff_amount->find("first",array("conditions"=>array(
						"tariff_list_id"=>$tariff_list_id,
						"tariff_standard_id"=>$tariff_standard_id
				)));
	
				if($hospitalType=='NABH'){
					$chargeNabh = trim($dataOfSheet->sheets[0]['cells'][$row]['4']);
					$chargeNonNabh=0;
				}else{
					$chargeNonNabh = trim($dataOfSheet->sheets[0]['cells'][$row]['4']);;
					$chargeNabh=0;
				}
				/* for Tariff Amount*/
				if(!empty($check_edit_amount)){
					$tariff_amount->save(array(
							"id"=>$check_edit_amount['TariffAmount']['id'],
							"nabh_charges"=>$chargeNabh,
							"non_nabh_charges"=>$chargeNonNabh,
							"moa_sr_no"=>$moa,
							"unit_days"=>$validity ,
							"create_time"=> $createtime,
							"created_by"=>$createdby
					));
				}else{
					$tariff_amount->create();
					$tariff_amount->save(array(
							"location_id"=>$session->read('locationid'),
							"tariff_list_id"=>$tariff_list_id,
							"tariff_standard_id"=>$tariff_standard_id,
							"nabh_charges"=>$chargeNabh,
							"non_nabh_charges"=>$chargeNonNabh,
							//"moa_sr_no"=>$moa,
							"unit_days"=>$validity ,
							"create_time"=> $createtime,
							"created_by"=>$createdby
					));
				}
				$tariff_amount->id =  '' ;
	
			}
	
			return true;
		}catch(Exception $e){
	
			return false;
		}
	
	
	
	}
	/**
	 * Function For AllSeleted Doctors
	 * @param unknown_type $id
	 * @return Ambigous <multitype:, NULL, mixed>
	 * Mahalaxmi
	 */
	public function getAllUserById($getDoctorIds) {
		$session = new cakeSession ();
		$doctorArrayId = array();
		Classregistry::init('User')->unbindModel(array('belongsTo' => array('City','State','Country','Initial')));
		$getUserMobileNo=$this->find('all',array('conditions'=>array('User.id'=>$getDoctorIds,'User.location_id'=>$session->read('locationid')),'fields'=>array('User.id','User.first_name','User.last_name','User.mobile')));
		foreach($getUserMobileNo as $getUserMobileNos){
				$getMobUser[]=$getUserMobileNos['User']['mobile'];
				$getFirstName=explode(" ",$getUserMobileNos['User']['first_name']);
				$getLastName=explode(" ",$getUserMobileNos['User']['last_name']);
				$getUserName[$getUserMobileNos['User']['id']]=$getFirstName[0]." ".$getLastName[0];
		}
		$getMobNoUser=implode(",",$getMobUser);
		$getNameUser=implode(",",$getUserName);
		return array($getMobNoUser,$getNameUser);
	}

	/**
	 * Function For OTAssistant
	 * @param unknown_type $id
	 * @return Ambigous <multitype:, NULL, mixed>
	 * Mahalaxmi
	 */
	public function getOTAssisatantUser() {
		$session = new cakeSession ();
		$doctorArrayId = array();
		Classregistry::init('User')->unbindModel(array('belongsTo' => array('City','State','Country','Initial')));
		return $this->find('all', array(
				'conditions' => array('User.sms_alert' => 1,'User.is_deleted' => 0, 'Role.name' => Configure::read("OTAssistantLabel"), 'User.location_id' => $session->read('locationid')),
				'fields' => array('User.id','User.mobile')));		
	}	
	/**
	 * Function For Restricted by user to show validated data
	 * @param unknown_type $ids array
	 * @return flag true or false
	 * Mahalaxmi
	 */
	public function getUserRestrictedById($ids=array()) {	
		$session = new cakeSession ();	
		$userid = $session->read('userid');		
		$flag=false;
		if(in_array(trim($userid), $ids)){			
			$flag=true;
		}		
		return $flag;
	}	
	public function uploadUserDoc($userDoc,$userId){ 
		$session = new CakeSession();
				foreach($userDoc as $docData){ 
					$target_dir = "uploads/Documents/";
					if(!empty($docData["name"]["file_name"])){
						$target_file = $target_dir . $userId.'_'.basename($docData["name"]["file_name"]);
						move_uploaded_file($docData["tmp_name"]["file_name"], $target_file);
						$userDocData['file_name'] = $userId.'_'.$docData["name"]["file_name"];
						$userDocData['document_type'] = $docData['document_type'];
						$userDocData['Certificate_details'] = $docData['Certificate_details'];
						$userDocData['user_id'] = $userId;
						$userDocData['location_id'] = $session->read('locationid');
						$userDocData['created_by'] = $session->read('userid');
					Classregistry::init('HrDocument')->saveAll($userDocData);
				}
				}
	}
		function getAllUsers($term){
			$conditions['User.full_name LIKE'] = "%".$term."%";
		
			$session = new cakeSession();
		
			$this->unbindModel(array( 'belongsTo' => array('City','State','Country','Role','Initial')));
			$this->bindModel(array('belongsTo'=>array('Initial' => array('foreignKey' =>'initial_id'))
			));
			$result = $this->find('list',array('conditions'=>array($conditions,'is_deleted'=>0),
					'fields'=>array('full_name'), 'recursive' => 1,'limit'=>'20'));
			foreach ($result as $key => $val){
				$returnArr[] = array('id'=>$key, 'value'=>$val, 'label'=>$val);
			}
			echo json_encode($returnArr);
			exit;
		}
		
		/**
		 * function to generate Hr Employee Code
		 * @param  text $roleName --> Role name
		 * @param  int $roleId --> Role Id;
		 * @return  HR code which is like "HH/HRM/OT-02"
		 * @author  Amit Jain
		 * @date 20-05-2016
		 */
		/* public function generateHrCode($roleName,$roleId){
			$session = new cakeSession ();
			$count = $this->find('count',array('conditions'=>array('User.role_id'=>$roleId,'User.location_id'=>$session->read('locationid'),
					'User.is_deleted'=>'0')));

			$hrCodeFormat = Configure::read('hrCodeFormat');
			$expName = explode(" ", $roleName);
			$stringCount = count($expName);
			if($stringCount >= '2'){
				foreach ($expName as $data){
					$rest .= substr($data, 0, 1);
				}
			}else{
				$rest = strtoupper(substr($expName['0'], 0, 3));
			}
			if($count < '9'){
				$count = $count+1;
				$newCount = "0$count";
			}else{
				$newCount = $count+1;
			}
			$finalHrCode = $hrCodeFormat.$rest."-".$newCount;
			return $finalHrCode;
		} */
}
?>