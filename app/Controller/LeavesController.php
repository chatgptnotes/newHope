<?php
/**
 * Leaves Controller
 *
 * PHP 5
 * @copyright     Copyright 2016 DrmHope pvt ltd.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Leaves
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pooja Gupta
 */
class LeavesController extends AppController {
	public $name = 'Leaves';
        public $uses = NULL;
	public $helpers = array (
			'DateFormat',
			'RupeesToWords',
			'Number',
			'General'
	);
	public $components = array (
			'General',
			'DateFormat',
			'Number',
			'GibberishAES',
			'General'
	);
	public function index() {
            $this->uses = array('LeaveApproval');
            $this->layout = 'advance';
            $this->set('title_for_layout',__(' : Leave Dashboard'));
            
            $this->LeaveApproval->bindModel(array(
                'belongsTo'=>array(
                    'User'=>array(
                        'foreignKey'=>'user_id'
                    ),
                    'Role'=>array(
                        'foreignKey'=>false,
                        'conditions'=>array(
                            'User.role_id = Role.id'
                        )
                    ),
                    'Location'=>array(
                        'foreignKey'=>false,
                        'conditions'=>array(
                            'User.location_id = Location.id'
                        )
                    )
                )
            ));
            $leaveData = $this->LeaveApproval->find('all',array(
                'fields'=>array(
                    'CONCAT(User.first_name," ",User.last_name) as full_name, User.id',
                    'Location.name',
                    'Role.name',
                    'LeaveApproval.leave_from, LeaveApproval.leave_type, LeaveApproval.is_approved'
                ),
                'conditions'=>array(
                    //'LeaveApproval.is_approved'=>'1',
                    'LeaveApproval.is_deleted'=>'0'
                ),
                'order'=>array(
                    'Leaveapproval.leave_from'=>'DESC'
                )
            ));
            $this->set(compact('leaveData'));
	}

	/**
	 * function to Configure leaves of Department and roles
	 */
	public function leaveConfigure() {
		if($this->params['isAjax']){
			$this->layout ='advance_ajax';
		}else{
			$this->layout = 'advance';
		}
		$this->uses = array (
				'Configuration',
				'Department',
				'Role',
				'EmpLeaveBenefit'
		);

		if($this->request->data){
                    debug($this->request->data);exit;
		}
		$leaveType = $this->Configuration->getLeaveTypeList();
		$holidayList = $this->Configuration->getPublicHolidays( date('Y'), $location );
		$departments = $this->Department->getDepartmentByLocationID ( $this->Session->read ( 'locationid' ) );
		$roles = $this->Role->getRoles ();
		$this->set ( compact ( array (
				'leaveType',
				'holidayList',
				'departments',
				'roles'
		) ) );

	}

	/**
	 * function for assigning leaves to employees
	 */
	public function assignLeave() {
		$this->layout = 'advance';
		$leaveType = $this->Configuration->getLeaveTypeList ();
		$holidayList = $this->Configuration->getHolidayList ( $year, $location );
		$leaveRequestList = $this->LeaveTransaction->getAllLeaveRequest ();
		if ($this->request->data ['emp_id']) {
			$empLeaveDetails = $this->EmpLeaveBenefit->getEmployeeLeaveDetails ( $this->request->data ['emp_id'] );
		}
	}

	/**
	 * function for leave approval system
	 */
	public function leaveApproval() {
		$this->layout = 'advance';
		$leaveType = $this->Configuration->getLeaveTypeList ();
		$holidayList = $this->Configuration->getHolidayList ( $year );
		$leaveRequestList = $this->LeaveTransaction->getAllLeaveRequest ();
		if ($this->request->data ['emp_id']) {
			$empLeaveDetails = $this->EmpLeaveBenefit->getEmployeeLeaveDetails ( $this->request->data ['emp_id'] );
		}
	}

	/**
	 * function to get role and employee wise Leave details
	 */
	function roleLeaveDetail(){
		//$this->layout='advance_ajax';
		$this->uses = array(
				'LeaveMaster',
				'Configuration',
		);
		$leaveType = $this->Configuration->getLeaveTypeList ();
		if($this->request->data['emp_id']){
			$conditions['User.id']=$this->request->data['emp_id'];
		}
		if($this->request->data['department_id']){
			$conditions['LeaveMaster.department_id']=$this->request->data['department_id'];
		}
		if($this->request->data['role_id']){
			$conditions['Role.id']=$this->request->data['role_id'];
		}
		$getDetailList=$this->LeaveMaster->getLeaveDetails($conditions);
		//debug($getDetailList);exit;
		$this->set(compact(array('getDetailList','leaveType')));

	}

	/**
	 * function to save leave alotment details
	 */
	public function saveLeaveDetails(){
		$this->uses=array('LeaveMaster','EmpLeaveBenefit');
		if($this->params->query['type']=='role_leave'){
			$this->LeaveMaster->saveRoleLeave($this->request->data);
		}else if($this->params->query['type']=='emp_leave'){
			$this->EmpLeaveBenefit->saveEmpLeave($this->request->data);
				
		}
		exit;
	}

	/**
	 * Employee Leave requisition
	 */

	function employeeLeaveRequisition($emp){
		$this->uses=array('LeaveMaster','EmpLeaveBenefit','LeaveTransaction');

	}

	/**
	 * Employee Leave Details including total leaves alloted total leaves taken and remaining leaves
	 */
	function empLeaveDetails($emp_id){
		$this->uses=array('EmpLeaveBenefit','LeaveTransaction');
		$empLeaveDetails = $this->EmpLeaveBenefit->getEmployeeLeaveDetails ( $emp_id );
	}
    
    //function to insert or update leaves type in configuration
    function saveLeaveTypes(){ 
        $this->autoRender = false;
        $this->loadModel('Configuration');
        $isExist = $this->Configuration->find('first',array('conditions'=>array('name'=>'leave type')));
        //$leaveTypes=array('pl'=>'Personal Leave','ml'=>'Medical Leave','cl'=>'Casual Leave','mat_leave'=>'Maternity Leave');
        $leaveTypes=array('CL'=>'Casual Leave','SL'=>'Sick Leave','EL'=>'Earned Leave','ML'=>'Maternity Leave','OH'=>'Other Holiday');
        
        if(!empty($isExist)){
            $this->Configuration->id = $isExist['Configuration']['id'];
        }
        $this->Configuration->save(
          array('name'=>'leave type',
            'value'=>serialize($leaveTypes),
            'location_id'=>'1')
        ); 
    }
    
    public function getAllPaidLeaves($date){
        $this->autoRender = false;
        $this->loadModel('LeaveApproval');
        $this->loadModel('Configuration');
        $configData = $this->Configuration->getLeaveTypeList(); 
        $monthArr = $this->LeaveApproval->getAllPaidLeavesCount(date("Y"),date("m"));
        $todayArr = $this->LeaveApproval->getAllPaidLeavesCount(date("Y"),date("m"),date("d")); 
        foreach ($configData as $key => $val){
            $returnArr['monthCount'][$key] = $monthArr[$key]!=''?$monthArr[$key]:'0';
            $returnArr['todayCount'][$key] = $todayArr[$key]!=''?$todayArr[$key]:'0';
        } 
        echo json_encode($returnArr); 
        exit;
    }
    
    /*
     * function to add approval for leave
     * @author : Swapnil
     * @created : 08.03.2016
     */
    public function requestLeaveApproval($id=null){
        $this->set('title_for_layout',__(' : Leave Request'));
        $this->layout = "advance";
        $this->uses = array("LeaveApproval",'Configuration','User');
       //$leaveTypes = $this->Configuration->getLeaveTypeList();   
        $leaveTypes = array('CL'=>'Casual Leave','SL'=>'Sick Leave','EL'=>'Earned Leave','ML'=>'Maternity Leave','OH'=>'Other Holiday');
        $loginUserData = $this->User->read(array('User.full_name','User.id'),$this->Session->read('userid')); 
        $this->set(compact(array('leaveTypes','loginUserData')));
        
        if(!empty($this->request->data)){    
            if(!empty($id)){ 
                $this->LeaveApproval->updateAll(array('is_deleted'=>'1'),array('batch_identifier'=>$id));
            }
            $saveData = array();
            $saved = false;
            $ds = $this->LeaveApproval->getdatasource(); //creating dataSource object					
            $ds->begin();
            $batchIdentifier = time();
            if(!empty($this->request->data['is_multiple_day']) && $this->request->data['is_multiple_day'] == '1'){
                $dateList = $this->DateFormat->get_date_range($this->DateFormat->formatDate2STD($this->request->data['leave_from'],Configure::read('date_format')),$this->DateFormat->formatDate2STD($this->request->data['leave_to'],Configure::read('date_format')));
                foreach($dateList as $key => $val){
                    $saveData = $this->request->data;
                    $saveData['created_by'] = $this->Session->read('userid');
                    $saveData['create_time'] = date("Y-m-d H:i:s");
                    $saveData['batch_identifier'] = $batchIdentifier; 
                    $saveData['leave_type'] = $this->request->data['leave_type'];
                    $saveData['location_id'] = $this->Session->read('locationid'); 
                    $saveData['leave_from'] = $val; 
                    if($this->LeaveApproval->saveAll($saveData)){ 
                        $saved = true;
                    }
                }
            }else{ 
                $saveData = $this->request->data;
                $saveData['created_by'] = $this->Session->read('userid');
                $saveData['create_time'] = date("Y-m-d H:i:s");
                $saveData['batch_identifier'] = $batchIdentifier; 
                $saveData['leave_type'] = $this->request->data['leave_type'];
                $saveData['location_id'] = $this->Session->read('locationid'); 
                $saveData['leave_from'] = $this->DateFormat->formatDate2STD($this->request->data['leave_from'],Configure::read('date_format')); 
                if($this->LeaveApproval->save($saveData)){
                    $saved = true;
                } 
            }  
            
            if($saved == true){
                $ds->commit();
                $this->Session->setFlash(__('Request sent successfully'),'default',array('class'=>'message'));
            }else{
                $ds->rollback();
                $this->Session->setFlash(__('Could not send or update your request'),'default',array('class'=>'error'));
            } 
            $this->redirect(array('action'=>'requestLeaveApproval'));
        } 
        if(!empty($id)){
            $this->LeaveApproval->bindModel(array(
                'belongsTo'=>array(
                    'User'=>array(
                        'foreignKey'=>'user_id'
                    )
                )
            ));
            $requestData = $this->LeaveApproval->find('all',array(
                'fields'=>array(
                    'CONCAT(User.first_name," ",User.last_name) as full_name, User.id',
                    'LeaveApproval.id, LeaveApproval.leave_type, LeaveApproval.leave_from, LeaveApproval.subject, LeaveApproval.message, LeaveApproval.batch_identifier'
                ),
                'conditions'=>array(
                    'LeaveApproval.is_deleted'=>'0',
                    'LeaveApproval.batch_identifier'=>$id
                )
            ));    
            $this->set(compact(array('requestData'))); 
        }
        
        $this->LeaveApproval->bindModel(array(
            'belongsTo'=>array(
                'User'=>array(
                    'foreignKey'=>'user_id',
                    'type'=>'inner'
                ),
                'Location'=>array(
                    'foreignKey'=>'location_id'
                )
            )
        ));
        
        $requisitionList = $this->LeaveApproval->find('all',array(
            'fields'=>array(
                'CONCAT(User.first_name," ",User.last_name) as full_name',
                'LeaveApproval.leave_type, LeaveApproval.leave_from, LeaveApproval.is_approved, LeaveApproval.create_time ',
                'LeaveApproval.batch_identifier, COUNT(LeaveApproval.batch_identifier) as batch_count','SUM(LeaveApproval.is_approved) as tot',
                'Location.name'
            ),
            'conditions'=>array(
                'LeaveApproval.is_deleted'=>'0',
                'User.is_deleted'=>'0',
                'LeaveApproval.user_id'=>$this->Session->read('userid'),
            ),
            'group'=>array( 
                'LeaveApproval.batch_identifier'
            ),
            'order'=>array(
                'LeaveApproval.is_approved'=>'ASC',
                'LeaveApproval.create_time'=>'DESC'
            )
        )); 
                
        /*$requisitionList = $this->LeaveApproval->find('all',array(
            'conditions'=>array(
                'LeaveApproval.is_deleted'=>'0',
                'LeaveApproval.user_id'=>$loginUserData['User']['id'],
            ),
            'group'=>array(
                'LeaveApproval.id'
            ),
            'order'=>array(
                'LeaveApproval.id'=>'DESC'
            )
        )); */
        $this->set(compact(array('requisitionList')));
    }
    
    /*
     * function to get the list of leave request
     * @author : Swapnil
     * @created : 08.03.2016
     */
    public function leaveRequestList(){
        $this->set('title_for_layout',__(' : Leave Approval'));
        $this->layout = "advance";
        $this->uses = array("LeaveApproval",'Configuration');
        $leaveTypes = $this->Configuration->getLeaveTypeList(); 
        $this->LeaveApproval->bindModel(array(
            'belongsTo'=>array(
                'User'=>array(
                    'foreignKey'=>'user_id',
                    'type'=>'inner'
                ),
                'Location'=>array(
                    'foreignKey'=>'location_id'
                )
            )
        ));
         
        $requestData = $this->LeaveApproval->find('all',array(
            'fields'=>array(
                'CONCAT(User.first_name," ",User.last_name) as full_name',
                'LeaveApproval.leave_type, LeaveApproval.leave_from, LeaveApproval.is_approved, LeaveApproval.batch_identifier, COUNT(LeaveApproval.batch_identifier) as batch_count','SUM(LeaveApproval.is_approved) as tot',
                'Location.name'
            ),
            'conditions'=>array(
                'LeaveApproval.is_deleted'=>'0',
                'User.is_deleted'=>'0'
            ),
            'group'=>array( 
                'LeaveApproval.batch_identifier'
            ),
            'order'=>array(
                'LeaveApproval.is_approved'=>'ASC',
                'LeaveApproval.create_time'=>'DESC'
            )
        )); 
        
        $this->set(compact(array('requestData','leaveTypes')));
    }
      
    /*
     * function to delete the leave request
     * @author : Swapnil
     * @created : 08.03.2016
     */
    public function deleteLeaveRequest($batchIdentifier,$action){
        if(empty($batchIdentifier)){
            $this->Session->setFlash(__('Something went wrong, please try again!'),'default',array('class'=>'error')); 
        }else{
            $this->loadModel('LeaveApproval'); 
            if($this->LeaveApproval->updateAll(array('is_deleted'=>'1'),array('batch_identifier'=>$batchIdentifier))){ 
                $this->Session->setFlash(__('Leave request deleted successfully!'),'default',array('class'=>'message')); 
            }else{
                $this->Session->setFlash(__('Leave request could not delete!'),'default',array('class'=>'error')); 
            } 
        }
        $this->redirect(array('action'=>$action));
    }
    
    
    /*
     * function to view the leave request
     * @author : Swapnil
     * @created : 08.03.2016
     */
    public function viewLeaveRequest($batchIdentifier){
        $this->set('title_for_layout',__(' : View Leave Request'));
        $this->layout = "advance_ajax";
        $this->uses = array('Configuration','LeaveApproval');
        $leaveTypes = $this->Configuration->getLeaveTypeList(); 
         
        if(!empty($this->request->data)){   
            $ds = $this->LeaveApproval->getdatasource();
            $ds->begin();
            $isUpdated = false;
                
            foreach($this->request->data['leave_approval_id'] as $key => $val){
                $status = ($val=='0') ? '2' : $val;
                if(isset($this->request->data['cancel']) && !empty($this->request->data['cancel'])){ //to cancel all the records
                    $status = '2';
                } 
                if($this->LeaveApproval->updateAll(array('is_approved'=>$status),array('id'=>$key))){
                    $isUpdated = true;
                }
            }
            if($isUpdated == true){
                $ds->commit();
                echo "<script> parent.$.fancybox.close();  parent.window.location.reload(); </script>"; 
                //$this->redirect(array('action'=>'leaveRequestList'));
            }else{
                $ds->rollback();
            }
        }
        $this->LeaveApproval->bindModel(array(
            'belongsTo'=>array(
                'User'=>array(
                    'foreignKey'=>'user_id'
                )
            )
        ));
        $requestData = $this->LeaveApproval->find('all',array(
            'fields'=>array(
                'CONCAT(User.first_name," ",User.last_name) as full_name, User.id',
                'LeaveApproval.*'
            ),
            'conditions'=>array(
                'LeaveApproval.is_deleted'=>'0',
                'LeaveApproval.batch_identifier'=>$batchIdentifier
            )
        ));  
        $this->set(compact(array('requestData','leaveTypes')));
    } 
    
     /*
     * function to approve the leave request
     * @author : Swapnil
     * @created : 08.03.2016
     */
    public function approveRequest($id,$status){
        if(empty($id) || empty($status)){
            $this->Session->setFlash(__('Something went wrong, please try again!'),'default',array('class'=>'error')); 
        }else{
            $this->loadModel('LeaveApproval');
            $this->LeaveApproval->id = $id;
            if($this->LeaveApproval->saveField('is_approved',$status)){
                if($status == '1'){
                    $this->Session->setFlash(__('Leave request approved successfully!'),'default',array('class'=>'message')); 
                }else{
                    $this->Session->setFlash(__('Leave request cancelled successfully!'),'default',array('class'=>'message')); 
                }
            }
        }
        $this->redirect(array('action'=>'leaveRequestList'));
    }
}