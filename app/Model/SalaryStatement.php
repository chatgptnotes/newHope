<?php
/**
 * @model SalaryStatement model
 * @author Swapnil
 * @created : 08.03.2016
 */

	class SalaryStatement extends AppModel {

		public $name = 'SalaryStatement';  
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
            
        /*
        * function to calculate the salary satement of all list of all bank
        * 
        */
        public function getSalaryBankStatement($salaryPayrollId,$bankId,$locationId=null ){ 
            $conditions = array();
            $this->bindModel(array(
                'belongsTo'=>array(
                    'User'=>array(
                        'foreignKey'=>'user_id',
                        'className'=>'User'
                    ),
                    'SalaryPayroll'=>array(
                        'primaryKey'=>'salary_payroll_id',
                        'className'=>'SalaryPayroll'
                    ),
                    'HrDetail'=>array(
                        'foreignKey'=>false,
                        'className'=>'HrDetail',
                        'conditions'=>'User.id = HrDetail.user_id'
                    ),
                    'Role'=>array(
                        'foreignKey'=>false,
                        'className'=>'Role',
                        'conditions'=>array(
                            'User.role_id = Role.id'
                        )
                    ),
                    'Location'=>array(
                        'foreignKey'=>false,
                        'className'=>'Location',
                        'conditions'=>array(
                            'User.location_id = Location.id'
                        )
                    ),
                    'Account'=>array(
                        'foreignKey'=>false,
                        'className'=>'Account',
                        'conditions'=>array(
                            'HrDetail.bank_id = Account.id'
                        )
                    )
                )
            ));  
            if(!empty($bankId)){
                $conditions['HrDetail.bank_id'] = $bankId;
            }
            if(!empty($locationId)){
                $conditions['User.location_id'] = $locationId;
            }
            
            $data = $this->find('all',array( 
                'fields'=>array(
                    'CONCAT(User.first_name," ",User.last_name) as full_name',
                    'Role.name', 
                    'Location.name',
                    'HrDetail.account_no, HrDetail.bank_id',
                    'Account.name',
                    'SalaryStatement.*'
                ),
                'conditions'=>array(  
                    $conditions,
                    'SalaryStatement.is_deleted'=>'0',
                    'SalaryStatement.salary_type'=>'1',
                    'SalaryPayroll.is_deleted'=>'0',
                    'SalaryStatement.salary_payroll_id'=>$salaryPayrollId
                ),
                'order'=>array(
                    'User.first_name','User.last_name'
                )
            ));   
            foreach($data as $key => $val){
                $returnArray[$val['Account']['name']][] = $val;
            } 
            return $returnArray;
        }
        
        /*
        * function to calculate the salary satement of all list of cash
        * 
        */
        public function getSalaryCashStatement($salaryPayrollId,$locationId=null){ 
            $conditions = array();
            $this->bindModel(array(
                'belongsTo'=>array(
                    'User'=>array(
                        'foreignKey'=>'user_id',
                        'className'=>'User'
                    ), 
                    'SalaryPayroll'=>array(
                        'primaryKey'=>'salary_payroll_id',
                        'className'=>'SalaryPayroll'
                    ),
                    'Location'=>array(
                        'foreignKey'=>false,
                        'className'=>'Location',
                        'conditions'=>array(
                            'User.location_id = Location.id'
                        )
                    ),
                    'Role'=>array(
                        'foreignKey'=>false,
                        'className'=>'Role',
                        'conditions'=>array(
                            'User.role_id = Role.id'
                        )
                    )
                )
            ));   
            
            if(!empty($locationId)){
                $conditions['User.location_id'] = $locationId;
            }
            
            $data = $this->find('all',array( 
                'fields'=>array(
                    'CONCAT(User.first_name," ",User.last_name) as full_name',
                    'Role.name', 
                    'Location.name',
                    'SalaryStatement.*'
                ),
                'conditions'=>array(  
                    $conditions,
                    'SalaryStatement.is_deleted'=>'0',
                    'SalaryStatement.salary_type'=>'2',
                    'SalaryPayroll.is_deleted'=>'0',
                    'SalaryStatement.salary_payroll_id'=>$salaryPayrollId
                ),
                'order'=>array(
                    'User.first_name','User.last_name'
                )
            ));   
            return $data;
        }
        
        /*
         * function to delete entry
         */
        public function deleteEntry($id){
            //Transaction begin
            $ds = $this->getdatasource(); //creating dataSource object					
            $ds->begin();
            $salaryStatementDetail = ClassRegistry::init('SalaryStatementDetail');
            if($this->updateAll(array('SalaryStatement.is_deleted'=>'1'),array('SalaryStatement.id'=>$id))){
                if($salaryStatementDetail->deleteAllEntry($id)){
                    $ds->commit(); 
                    return true ;
                }else{
                    $ds->rollback();
                    return false ;
                }
            }
            else{
                $ds->rollback();
                return false;
            }
        }
        
        /**
        * function to calculate earning head wise payment to DOCTORS
        * @param int $userId 
        * @param date $fromDate
        * @param date $toDate
        * @author Gaurav Chauriya <gauravc@drmhope.com>
        */
        public function getSalaryDetailsOfDoctor($userId,$fromDate = null,$toDate = null, $departmentId){
            $session = new CakeSession();
            $EarningDeduction = Classregistry::init('EarningDeduction');
            $Ward = Classregistry::init('Ward');
            $ExternalStatementPayment = Classregistry::init('ExternalStatementPayment');
            $wardList = $Ward->getWardList();
            #debug($earnindAndDeduction);
            $earningHeadSpread = $ExternalStatementPayment->find('all',array('fields'=>array('package_earning_head_id','ward_id','COUNT(id) as earning_head_count'),
                                    'conditions'=>array('package_earning_head_id !='=>null,'create_time BETWEEN ? AND ?' => array($fromDate, $toDate)),
                                    'group'=>array('ward_id', 'package_earning_head_id'),'order'=>array('earning_head_count DESC')));
            foreach ($earningHeadSpread as $earningHead){
                $earningSpreadList[$earningHead['ExternalStatementPayment']['package_earning_head_id']][$earningHead['ExternalStatementPayment']['ward_id']] = $earningHead[0]['earning_head_count'];
            }
            /** Calculating Revenue Linked Payment*/
            $EarningDeduction->bindModel(array(
                'hasOne' =>array('EmployeePayDetail' => array('foreignKey' => false,'type'=>"inner",
                                    'conditions'=>array('EmployeePayDetail.earning_deduction_id=EarningDeduction.id',
                                        "EmployeePayDetail.user_id" => $userId)))
            ));
            $earnindAndDeduction = $EarningDeduction->find('all',array('fields'=>array('id','type','name','service_category_id','category','payment_type','payment_mode',
                            'EmployeePayDetail.id',//'EmployeePayDetail.is_applicable',//'EmployeePayDetail.earning_deduction_id',//'EmployeePayDetail.service_category_id',
                'EmployeePayDetail.ward_charges','EmployeePayDetail.day_amount','EmployeePayDetail.night_amount'),
                            'conditions'=>array('EarningDeduction.is_doctor'=>'1','EarningDeduction.is_deleted'=>0,"EmployeePayDetail.pay_application_date <="=>date('Y-m-d'),
                                'EmployeePayDetail.is_applicable'=>'1')));
            foreach($earnindAndDeduction as $key => $val){
                $val['EarningDeduction']['category'] = $val['EarningDeduction']['category'] == '' ? 'Deduction' : $val['EarningDeduction']['category'];
                    if($val['EmployeePayDetail']['ward_charges']){
                        $wardCharges = unserialize($val['EmployeePayDetail']['ward_charges']);
                        foreach($wardCharges as $wardId => $wardPayments){
                            if($wardPayments['day_amount'] <= '0') continue;
                           $PayArray[$val['EarningDeduction']['category']][] = array('earning_id'=>$val['EarningDeduction']['id'],
                                'name'=>$val['EarningDeduction']['name'].' - '.$wardList[$wardId],
                                'payment'=>$wardPayments['day_amount'],
                                'payment_type'=>$val['EarningDeduction']['payment_type'].' payment',
                                'payment_mode'=>$val['EarningDeduction']['payment_mode'],
                                'units'=> (int) ($earningSpreadList[$val['EarningDeduction']['id']][$wardId])); 
                        }
                    }else{
                        if($val['EmployeePayDetail']['day_amount'] <= '0') continue;
                        $PayArray[$val['EarningDeduction']['category']][] = array('earning_id'=>$val['EarningDeduction']['id'],
                            'name'=>$val['EarningDeduction']['name'],
                            'payment'=>$val['EmployeePayDetail']['day_amount'],
                            'payment_type'=>$val['EarningDeduction']['payment_type'].' payment',
                            'payment_mode'=>$val['EarningDeduction']['payment_mode'],
                            'units'=>'');
                    }
            } #debug($earnindAndDeduction);
           # debug($PayArray);
            return $PayArray;
        }
        
        /**
        * function to calculate earning head wise payable for DOCTORS
        * @param int $userId 
        * @param date $fromDate
        * @param date $toDate
        * @author Gaurav Chauriya <gauravc@drmhope.com>
        */
        public function getSalaryPayableforDoctor($userId,$fromDate = null,$toDate = null, $departmentId){
            $session = new CakeSession();
            $EarningDeduction = Classregistry::init('EarningDeduction');
            $Ward = Classregistry::init('Ward');
            $Department = Classregistry::init('User');
            $User = Classregistry::init('Department');
            $ExternalStatementPayment = Classregistry::init('ExternalStatementPayment');
            $wardList = $Ward->getWardList();
            $DepartmentName = $Ward->getWardList();
            $myDepartmentDoctors = $User->find('list',array('fields'=>array('id','id'),
                'conditions'=>array('department_id'=>$departmentId,'is_doctor'=>1,'is_active'=>1,'paid_through_system'=>1,'attendance_track_system'=>1,'is_deleted'=>0)));
            
            #debug($earnindAndDeduction);
            $earningHeadSpread = $ExternalStatementPayment->find('all',array('fields'=>array('package_earning_head_id','ward_id','COUNT(id) as earning_head_count'),
                                    'conditions'=>array('package_earning_head_id !='=>null,'create_time BETWEEN ? AND ?' => array($fromDate, $toDate)),
                                    'group'=>array('ward_id', 'package_earning_head_id'),'order'=>array('earning_head_count DESC')));
            foreach ($earningHeadSpread as $earningHead){
                $earningSpreadList[$earningHead['ExternalStatementPayment']['package_earning_head_id']][$earningHead['ExternalStatementPayment']['ward_id']] = $earningHead[0]['earning_head_count'];
            }
            
        }
    }
?>