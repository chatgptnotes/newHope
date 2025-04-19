<?php
class OptAppointment extends AppModel {

	public $name = 'OptAppointment';
	public $belongsTo = array('Patient' => array('className'    => 'Patient',
                                                  'foreignKey'    => 'patient_id'
                                                 ),
                                  'Location' => array('className'    => 'Location',
                                                   'foreignKey'    => 'location_id'
                                                 ),
                                  'Opt' => array('className'    => 'Opt',
                                                     'foreignKey'    => 'opt_id'
                                                 ),
                                  'OptTable' => array('className'    => 'OptTable',
                                                     'foreignKey'    => 'opt_table_id'
                                                 ),
                                  'Surgery' => array('className'    => 'Surgery',
                                                     'foreignKey'    => 'surgery_id'
                                                 ),
                                  'TariffList' => array('className'    => 'TariffList',
                                                     'foreignKey'    => 'internal_surgery_id'
                                                 ),
                                  'SurgerySubcategory' => array('className'    => 'SurgerySubcategory',
                                                     'foreignKey'    => 'surgery_subcategory_id'
                                                 ),
                                   // for doctor with department (department_id is actually store id of users table)//
                                  'Doctor' => array('className'    => 'Doctor',
                                                     'foreignKey'    => 'department_id'
                                                 ),
                                  // doctor_id is actually store id of users table //
                                  'DoctorProfile' => array('className' => 'DoctorProfile',
                                                           'foreignKey'    => false,
                                                           'conditions'=>array('DoctorProfile.user_id=OptAppointment.doctor_id','DoctorProfile.is_active=1')
                                                 ),
                                  'Initial' => array('className' => 'Initial',
                                                           'foreignKey'    => false,
                                                           'conditions'=>array('Initial.id=Doctor.initial_id')
                                                 )
                                  );
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        if(empty($ds)){
			$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
		}else{
			$this->db_name =  $ds;
		}
		parent::__construct($id, $table, $ds);
    }
    
    public function JVSurgeryData($patient_id){
    	$session = new cakeSession();
    	$patientObj = ClassRegistry::init('Patient');
    	$accountObj = ClassRegistry::init('Account');
    	$voucherEntry = ClassRegistry::init('VoucherEntry');
    	$doctorProfile = ClassRegistry::init('DoctorProfile');
    	$consultantObj = ClassRegistry::init('Consultant');
    	$userObj = ClassRegistry::init('User');
    	$tariffAmountObj = ClassRegistry::init('TariffAmount');
    	$billingObj = ClassRegistry::init('Billing');
    	$tariffListObj = ClassRegistry::init('TariffList');
    	$surgeryDetails =$this->find('all',array('fields'=>array('OptAppointment.*'),
    			'conditions'=>array( 'OptAppointment.location_id'=>$session->read('locationid'),'OptAppointment.patient_id'=>$patient_id,
    					'OptAppointment.is_deleted'=>0)));
    	//find person id for updation amount of services and also used some details for narration
    	$getPatientDetails = $patientObj->getPatientAllDetails($patient_id);
 
    	$personId = $getPatientDetails['Patient']['person_id'];
         if($getPatientDetails['Patient']['is_paragon'] != '1'){ // if temporary registration then restrict entries -Atul Chandankhede
            if($getPatientDetails['Patient']['is_staff_register'] == '1'){
                $accId = $accountObj->find('first',array('conditions'=>array('Account.user_type'=>'User',
                                'Account.name'=>trim($getPatientDetails['Patient']['lookup_name']),
                              'Account.location_id'=>$session->read('locationid')),
                              'fields'=>array('Account.id','Account.name')));
            }else{
                $accId = $accountObj->getAccountID($personId,'Patient');//for account id
            }

    	 
    	 foreach($surgeryDetails as $key=> $surgeryData){
	    	 $accountId = $accountObj->getAccountIdOnly(Configure::read('surgeryPaymentLabel'));
	    	 $regDate  =  DateFormatComponent::formatDate2Local($getPatientDetails['Patient']['form_received_on'],Configure::read('date_format'),true);
	    	 $doneDate  =  DateFormatComponent::formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
	    	 if(!empty($surgeryData['OptAppointment']['doctor_id'])){
	    	 	//find doctor first name and last name for create accounting ledger
	    	 	$doctorDetails = $userObj->find('first',array('fields'=>array('User.first_name','User.last_name'),
	    	 			'conditions'=>array('User.is_deleted'=>'0','User.id'=>$surgeryData['OptAppointment']['doctor_id'])));
	    	 	$doctorName = $doctorDetails['User']['first_name']." ".$doctorDetails['User']['last_name'];
	    	 	$doctorId = $accountObj->getUserIdOnly($surgeryData['OptAppointment']['doctor_id'],'User',$doctorName);
	    	 	$narration = 'Being Surgery charged to patient '.$getPatientDetails['Patient']['lookup_name']." (Date of Registration :".$regDate.")".'done on '.$doneDate;
		    	 $jvData = array('date'=>date('Y-m-d H:i:s'),
		    	 		'location_id'=>$session->read('locationid'),
		    	 		'account_id'=>$accountId,
		    	 		'user_id'=>$doctorId,
		    	 		'patient_id'=>$patient_id,
		    	 		'type'=>'SurgeryCharges',
		    	 		'narration'=>$narration,
		    	 		'debit_amount'=>$surgeryData['OptAppointment']['cost_to_hospital']);
		    	 if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
		    	 	$voucherEntry->insertJournalEntry($jvData);
		    	 	$voucherEntry->id= '';
		    	 	// ***insert into Account (By) credit manage current balance
		    	 	$accountObj->setBalanceAmountByAccountId($doctorId,$surgeryData['OptAppointment']['cost_to_hospital'],'debit');
		    	 	$accountObj->setBalanceAmountByUserId($accountId,$surgeryData['OptAppointment']['cost_to_hospital'],'credit');
		    	 }
		    	 //EOF jv
		    	 
		    	 //BOF for hospital surgery charges jv
		    	 $userId = $accountObj->getAccountIdOnly(Configure::read('SurgeonChargesLabel'));
		    	 $narration = 'Being Surgery charged to patient '.$getPatientDetails['Patient']['lookup_name']." (Date of Registration :".$regDate.")".'done on '.$doneDate;
		    	 $jvData = array('date'=>date('Y-m-d H:i:s'),
		    	 		'location_id'=>$session->read('locationid'),
		    	 		'account_id'=>$accId['Account']['id'],
		    	 		'user_id'=>$userId,
		    	 		'patient_id'=>$patient_id,
		    	 		'type'=>'SurgeryChargesHospital',
		    	 		'narration'=>$narration,
		    	 		'debit_amount'=>$surgeryData['OptAppointment']['surgery_cost']);
		    	 if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
		    	 	$voucherEntry->insertJournalEntry($jvData);
		    	 	$voucherEntry->id= '';
		    	 	// ***insert into Account (By) credit manage current balance
		    	 	$accountObj->setBalanceAmountByAccountId($userId,$surgeryData['OptAppointment']['surgery_cost'],'debit');
		    	 	$accountObj->setBalanceAmountByUserId($accId['Account']['id'],$surgeryData['OptAppointment']['surgery_cost'],'credit');
		    	 }
		    	 //EOF jv
	    	 	}
	    //For anaesthesia jv by amit jain
	    	 if(!empty($surgeryData['OptAppointment']['department_id'])){
	    	 	/* $getTariffStandardId = $patientObj->getTariffStandardIDByPatient($patient_id) ;
	    	 	$anaestCost = $tariffAmountObj->find('first',array('fields'=>array('nabh_charges'),'conditions'=>array('TariffAmount.tariff_list_id'=>$surgeryData['OptAppointment']['anaesthesia_tariff_list_id'],'TariffAmount.tariff_standard_id'=>$getTariffStandardId)));
	    	 	$departmentDetails = $userObj->find('first',array('fields'=>array('User.first_name','User.last_name'),'conditions'=>array('User.is_deleted'=>'0','User.id'=>$surgeryData['OptAppointment']['department_id'])));
	    	 	$docName = $departmentDetails['User']['first_name']." ".$departmentDetails['User']['last_name'];
	    	 	$docoId = $accountObj->getUserIdOnly($surgeryData['OptAppointment']['department_id'],'User',$docName);
	    	 	$narrationdetails = 'Being Anaesthesia charged to patient '.$getPatientDetails['Patient']['lookup_name']." (Date of Registration :".$regDate.")".'done on '.$doneDate;
	    	 	$jvData = array('date'=>date('Y-m-d H:i:s'),
	    	 			'location_id'=>$session->read('locationid'),
	    	 			'account_id'=>$accountId,
	    	 			'user_id'=>$docoId,
	    	 			'patient_id'=>$patient_id,
	    	 			'type'=>'Anaesthesia',
	    	 			'narration'=>$narrationdetails,
	    	 			'debit_amount'=>$anaestCost['TariffAmount']['nabh_charges']);
	    	 	if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
	    	 		$voucherEntry->insertJournalEntry($jvData);
	    	 		$voucherEntry->id= '';
	    	 		// ***insert into Account (By) credit manage current balance
	    	 		$accountObj->setBalanceAmountByAccountId($accountId,$anaestCost['TariffAmount']['nabh_charges'],'debit');
	    	 		$accountObj->setBalanceAmountByUserId($docoId,$anaestCost['TariffAmount']['nabh_charges'],'credit');
	    	 	} */
	    	 	//EOF JV
	    	 	
	    	 	//BOF for anaesthesia hospital charges jv
	    	 	$userIdAN = $accountObj->getAccountIdOnly(Configure::read('AnaesthesiaChargesLabel'));
	    	 	$narrationdetails = 'Being Anaesthesia charged to patient '.$getPatientDetails['Patient']['lookup_name']." (Date of Registration :".$regDate.")".'done on '.$doneDate;
	    	 	$jvData = array('date'=>date('Y-m-d H:i:s'),
	    	 			'location_id'=>$session->read('locationid'),
	    	 			'account_id'=>$accId['Account']['id'],
	    	 			'user_id'=>$userIdAN,
	    	 			'patient_id'=>$patient_id,
	    	 			'type'=>'AnaesthesiaChargesHospital',
	    	 			'narration'=>$narrationdetails,
	    	 			'debit_amount'=>$surgeryData['OptAppointment']['anaesthesia_cost']);
	    	 	if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
	    	 		$voucherEntry->insertJournalEntry($jvData);
	    	 		$voucherEntry->id= '';
	    	 		// ***insert into Account (By) credit manage current balance
	    	 		$accountObj->setBalanceAmountByAccountId($userIdAN,$surgeryData['OptAppointment']['anaesthesia_cost'],'debit');
	    	 		$accountObj->setBalanceAmountByUserId($accId['Account']['id'],$surgeryData['OptAppointment']['anaesthesia_cost'],'credit');
	    	 		}
	    	 	//EOF JV
	    	 	}
	    	 	
	    	 	//BOF for OT charges jv
	    	 	if(!empty($surgeryData['OptAppointment']['ot_charges'])){
		    	 	$userOTId = $accountObj->getAccountIdOnly(Configure::read('OTChargesLabel'));
		    	 	$narrationOT = 'Being OT charged to patient '.$getPatientDetails['Patient']['lookup_name']." (Date of Registration :".$regDate.")".'done on '.$doneDate;
		    	 	$jvData = array('date'=>date('Y-m-d H:i:s'),
		    	 			'location_id'=>$session->read('locationid'),
		    	 			'account_id'=>$accId['Account']['id'],
		    	 			'user_id'=>$userOTId,
		    	 			'patient_id'=>$patient_id,
		    	 			'type'=>'OTChargesHospital',
		    	 			'narration'=>$narrationOT,
		    	 			'debit_amount'=>$surgeryData['OptAppointment']['ot_charges']);
		    	 	if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
		    	 		$voucherEntry->insertJournalEntry($jvData);
		    	 		$voucherEntry->id= '';
		    	 		// ***insert into Account (By) credit manage current balance
		    	 		$accountObj->setBalanceAmountByAccountId($userOTId,$surgeryData['OptAppointment']['ot_charges'],'debit');
		    	 		$accountObj->setBalanceAmountByUserId($accId['Account']['id'],$surgeryData['OptAppointment']['ot_charges'],'credit');
		    	 	}
	    	 	//EOF JV
	    	 	}
    		}
           }
    	}
    	
    	/**
    	 * Function getServices
    	 * All services of according to the conditions such as all services of specific patient_id
    	 * @param unknown_type $superBillId
    	 * @param unknown_type $tariffStandardId
    	 * @return multitype:
    	 *  returns Array with patient_id(encounter identifier) as encounterwise and serviceCategory id as key and details of individual services
    	 *  Pooja Gupta
    	 */
    	public function getSurgeryServices($condition=array(),$tariffStandardId,$superBillId=NULL){
    	
    		if($superBillId){
    			//If Superbill id is present then bind model with corporateSuperbill with inner join
    			$this->bindModel(array(
    					'belongsTo' => array(
    							'Surgery'=>array('foreignKey'=>false,'type'=>'INNER',
    									'conditions'=>array('OptAppointment.surgery_id=Surgery.id')),
    							'TariffList' =>array( 'foreignKey'=>false,'type'=>'INNER','conditions'=>array('OptAppointment.tariff_list_id=TariffList.id')),
    							/*'CorporateSuperBill'=>array('foreignKey'=>false,'type'=>'INNER','conditions'=>array('ServiceBill.corporate_super_bill_id=CorporateSuperBill.id'))*/
    					)),false);
    			$condition['OR']=array('OptAppointment.paid_amount <='=>'0','OptAppointment.paid_amount'=>NULL);
    			//$condition['ServiceBill.corporate_super_bill_id']=$superBillId;
    		}else{
    			$this->bindModel(array(
    					'belongsTo' => array(
    							'Surgery'=>array('foreignKey'=>false,'type'=>'INNER',
    									'conditions'=>array('OptAppointment.surgery_id=Surgery.id')),
    							'Patient'=>array('foreignKey'=>false,'type'=>'INNER',
    									'conditions'=>array('OptAppointment.patient_id=Patient.id')),
    							'TariffList' =>array('foreignKey'=>false,'type'=>'INNER',
    									'conditions'=>array('OptAppointment.tariff_list_id=TariffList.id')),
    							'TariffAmount' =>array('foreignKey'=>false,'type'=>'INNER',
    									'conditions'=>array('TariffAmount.tariff_list_id=TariffList.id'))
    					)),false);
    		}
    	
    		$serviceArray=$this->find('all',array('fields'=>array('OptAppointment.id','OptAppointment.patient_id','Surgery.id','Surgery.name',
    				'OptAppointment.surgery_cost','OptAppointment.anaesthesia_cost','OptAppointment.ot_charges','OptAppointment.paid_amount',
    				'OptAppointment.discount','OptAppointment.billing_id','OptAppointment.schedule_date','OptAppointment.surgery_id',
    				'OptAppointment.starttime','OptAppointment.endtime','TariffAmount.unit_days','Patient.id','Patient.corporate_status',
    				'TariffList.id','TariffList.name','TariffList.service_category_id',
    				'TariffList.cghs_code'),
    				'conditions'=>array('OptAppointment.is_deleted'=>'0',$condition,'TariffAmount.tariff_standard_id'=>$tariffStandardId),
    				'group'=>array('OptAppointment.id')));
    		
    		return $serviceArray;
    	
    	}
    	
    	function surgeryUpdate($serviceData,$encId,$catKey,$billId,$percent,$modified){
    		$session = new cakeSession();
    		$modified_by=$session->read('userid');
    		foreach($serviceData as $serviceKey=>$eachData){
    			$singleServiceData='';$amtToPay=0;$serDiscount=0;$serpaid=0;
    			$singleServiceData=$this->find('first',
    					array('fields'=>array('OptAppointment.id','OptAppointment.patient_id','Surgery.id','Surgery.name',
			    				'OptAppointment.surgery_cost','OptAppointment.anaesthesia_cost','OptAppointment.ot_charges','OptAppointment.paid_amount',
			    				'OptAppointment.discount','OptAppointment.billing_id','OptAppointment.schedule_date','OptAppointment.surgery_id',
			    				'OptAppointment.starttime','OptAppointment.endtime',),
    							'conditions'=>array('OptAppointment.id'=>$serviceKey,'OptAppointment.patient_id'=>$encId,
    							)));
    			$billTariffId[$catKey]=$serviceKey; //tariff_list_id serialize array
    			$amtToPay=($eachData['balAmt']*$percent)/100;
    			$serpaid=$amtToPay+$singleServiceData['OptAppointment']['paid_amount'];
    			$surAmt=$singleServiceData['OptAppointment']['surgery_cost']+$singleServiceData['OptAppointment']['anaesthesia_cost']+$singleServiceData['OptAppointment']['ot_charges'];
    			$serDiscount=($surAmt)-($serpaid);
    			
    			
    			$this->updateAll(
    					array('OptAppointment.paid_amount'=>"'$serpaid'",
    							'OptAppointment.discount'=>"'$serDiscount'",
    							'OptAppointment.billing_id'=>"'$billId'",
    							'OptAppointment.modified_by'=>"'$modified_by'",
    							'OptAppointment.modify_time'=>"'$modified'"),
    					array('OptAppointment.id'=>$serviceKey,'OptAppointment.patient_id'=>$encId));
    		}
    		return $billTariffId;
    	}
    	
    	/**
    	 * calculate ward days and icu days 
    	 * @param unknown_type $wardArray
    	 * @param unknown_type $patientId
    	 * @return multitype:number unknown
    	 */
    	public function calConservative($wardArray,$patientId){
    		$patientObj = ClassRegistry::init('Patient');
    		$allPatient=$patientObj->find('all',array('fields'=>array('Patient.form_received_on','Patient.discharge_date'),
    				'conditions'=>array('Patient.id'=>$patientId)));
    		//debug($wardArray);
    		foreach($allPatient as $rangeDate){
    			if(!$start){
	    			 $splitStart=explode(' ',$rangeDate['Patient']['form_received_on']);
	    			 //$splitStart=$splitStart['0'].' 00:00:00';
	    			 //$start=$splitStart;
	    			 $start = $splitStart['0'] ;
    			}
    			$splitEnd=explode(' ',$rangeDate['Patient']['discharge_date']);
    			$splitEnd=$splitEnd['0'].' 00:00:00';
    			$end=$splitEnd;    			
    		}
    		 
    		//debug($start);debug($end);exit;
    		$i=0;$j=0;
    		$ConvArry=array();
    		$firstWardDaySplit = explode(" ",$wardArray[0]['WardPatientService']['date']) ;
    		//$ConvArry[0][start]=$firstWardDaySplit[0];//For setting first data;
    		$c=0;
    		  
    		foreach($wardArray as $key =>$data){
    			if (strpos($data['Ward']['name'],'ICU') !== false) {
    				$wardIcu[$c]['name']=$data['TariffList']['name'];
    				$wardIcu[$c]['amount']=$data['WardPatientService']['amount'];
    				$wardIcu[$c]['cghs']=$data['TariffList']['cghs_code'];
    				$wardIcu[$c]['days']='1';
    				$wardIcu[$c]['start']=$data['WardPatientService']['date'];
    				$wardIcu[$c]['end']=$data['WardPatientService']['date'];
    				$c++;
    			}else{
	    			$wardClub[$data['TariffList']['id']]['name']=$data['TariffList']['name'];
	    			$wardClub[$data['TariffList']['id']]['amount']=$data['WardPatientService']['amount'];
	    			$wardClub[$data['TariffList']['id']]['cghs']=$data['TariffList']['cghs_code'];
	    			$wardClub[$data['TariffList']['id']]['days']=$wardClub[$data['TariffList']['id']]['days']+1;
    			}
    			
    			$splitAndReset = explode(" ",$data['WardPatientService']['date']);
    			$data['WardPatientService']['date'] = $splitAndReset[0];
    			 
    			if($j!=$i){
    				$j=$i;
    				$start=$data['WardPatientService']['date']; // initial startdate to the iteration next date where loop breaks
    			}	
	    		 			  
	    			if($start==$data['WardPatientService']['date'] && $data['TariffList']['id']==$wardArray[$key-1]['TariffList']['id']){	    				 
	    				if(!$wardClub[$data['TariffList']['id']]['start']){
	    					$wardClub[$data['TariffList']['id']]['start']=$data['WardPatientService']['date'];
	    				}	    				
	    				$wardClub[$data['TariffList']['id']]['end']=$data['WardPatientService']['date'];	    				
	    				$ConvArry[$i][end]=$data['WardPatientService']['date'];
	    				//$start=date('Y-m-d H:i:s', strtotime($start . ' +1 day'));//setting end date	 
	    				$start=date('Y-m-d', strtotime($start . ' +1 day'));//setting end date
	    			}else{
	    				$i++;
	    				$ConvArry[$i][start]=$data['WardPatientService']['date']; //settinr the start date in next key 
	    				if(!$wardClub[$data['TariffList']['id']]['start'])
	    				{
	    					$wardClub[$data['TariffList']['id']]['start']=$data['WardPatientService']['date'];	    					
    					}	    				
	    			}     
    		} 
    		 
    		return array('Conservative'=>$ConvArry,'Ward'=>$wardClub,'wardIcu'=>$wardIcu);
    		
    	}
    	
    	/**
    	 * Function to get list of patient surgery
    	 * @param unknown_type $patient_id
    	 * Pooja Gupta
    	 */
    	function getSurgeryDetails($patient_id){
    		$this->unbindModel(array(
    				'belongsTo'=>array('Patient','Location','Opt','OptTable','Surgery','SurgerySubcategory','Doctor','DoctorProfile','Initial')));
    	
    		/*$this->bindModel(array(
    		 'belongsTo'=>array(
    		 		'OptAppointmentDetail'=>array('type'=>'INNER',
    		 				'foreignKey'=>false,'conditions'=>array('OptAppointmentDetail.opt_appointment_id=OptAppointment.id')),
    		 		'Surgery'=>array('type'=>'INNER','foreignKey'=>false,
    		 				'conditions'=>array('OptAppointmentDetail.surgery_id=Surgery.id')),
    		 		'User'=>array('type'=>'INNER','foreignKey'=>false,
    		 				'conditions'=>array('OptAppointmentDetail.doctor_id=User.id','OptAppointmentDetail.user_type'=>'Surgeon'))
    		 )));*/
    	
    		$this->bindModel(array(
    				'belongsTo'=>array(
    						/*'OptAppointmentDetail'=>array('type'=>'INNER',
    						 'foreignKey'=>false,'conditions'=>array('OptAppointmentDetail.opt_appointment_id=OptAppointment.id')),*/
    						'Surgery'=>array('type'=>'INNER','foreignKey'=>false,
    								'conditions'=>array('OptAppointment.surgery_id=Surgery.id')),
    						'User'=>array('type'=>'INNER','foreignKey'=>false,
    								'conditions'=>array('OptAppointment.doctor_id=User.id'/*'OptAppointmentDetail.user_type'=>'Surgeon'*/))
    				)
    		));
    		$apptDetail=$this->find('all',array(
    				'fields'=>array('DISTINCT(OptAppointment.id)','OptAppointment.schedule_date','OptAppointment.start_time','OptAppointment.procedure_complete',
    						'OptAppointment.end_time','OptAppointment.opt_status','Surgery.name','User.first_name','User.last_name'),
    				'conditions'=>array('OptAppointment.patient_id'=>$patient_id)));
    		return $apptDetail;
    	}
    	
    	function getSurgeryDetailsByID($surgery_id){
    		$this->unbindModel(array(
    				'belongsTo'=>array('Patient','Location','Opt','OptTable','Surgery','SurgerySubcategory','Doctor','DoctorProfile','Initial')));
    		$this->bindModel(array(
    				'belongsTo'=>array(
    							
    						'Surgery'=>array('type'=>'INNER','foreignKey'=>false,
    								'conditions'=>array('OptAppointment.surgery_id=Surgery.id')),
    						'User'=>array('type'=>'INNER','foreignKey'=>false,
    								'conditions'=>array('OptAppointment.doctor_id=User.id')),
    						'AnaeUser'=>array('type'=>'left','foreignKey'=>false,'className'=>'User',
    								'conditions'=>array('OptAppointment.department_id=AnaeUser.id'))
    				)
    		));
    		$apptDetail=$this->find('first',array(
    				'fields'=>array('DISTINCT(OptAppointment.id)','OptAppointment.schedule_date','OptAppointment.start_time','OptAppointment.procedure_complete','OptAppointment.opt_id',
    						'OptAppointment.end_time','OptAppointment.opt_status','Surgery.name','User.first_name','User.last_name','AnaeUser.first_name','AnaeUser.last_name'),
    				'conditions'=>array('OptAppointment.id'=>$surgery_id),'order'=>'id DESC'));
    		return $apptDetail;
    	}
        
}
?>