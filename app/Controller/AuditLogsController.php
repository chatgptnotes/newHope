<?php
/**
 * AuditLogsController file
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
class AuditLogsController extends AppController {

	public $name = 'AuditLogs';
	public $uses = array('AuditLog');
	public $helpers = array('Html','Form', 'Js','General');
	public $components = array('RequestHandler','Email','Auth','Session', 'Acl','Cookie');

	/*
	 *
	*  all audit log module
	*
	*/
	public function admin_audit_logs(){

	}

	/*
	 *
	*  listing audit log
	*
	*/
	public function admin_index(){
		$this->layout  = 'advance' ;
		$this->uses = array('Audit');
		$this->set('title_for_layout', __('Admin - Audit Logs', true)); 
		if(!empty($this->request->query['from']) && !empty($this->request->query['to'])) {
			 $from = $this->DateFormat->formatDate2STDForReport($this->request->query['from'],Configure::read('date_format'))." 00:00:00";
			 $to = $this->DateFormat->formatDate2STDForReport($this->request->query['to'],Configure::read('date_format'))." 23:59:59";
			 $conditions['Audit'] = array('created BETWEEN ? AND ?'=> array($from,$to));
		}
		if(!empty($this->request->query['model'])){
			$conditions['Audit']['model'] = $this->request->query['model'];
		} 
		if(!empty($this->request->query['patient'])){
			$splittedPatientName = explode(" ",$this->request->query['patient']) ; 
			if(!empty($splittedPatientName[1])){
				$conditions['Person']['first_name LIKE'] = $splittedPatientName[0]."%";
				$conditions['Person']['last_name LIKE'] = $splittedPatientName[1]."%";
			}else{
				$conditions['Person']['first_name LIKE'] = $this->request->query['patient']."%";
			}
		}
		$conditions['Audit']['is_deleted'] = 0;
		$conditions['User']['location_id'] = $this->Session->read('locationid');
		 
		/* if(strtolower($this->Session->read('role')) != strtolower(Configure::read("adminLabel"))) { 
			$conditions['Audit']['source_id'] = $this->Session->read('userid');
		} */ 
		$conditions = $this->postConditions($conditions);

		$this->Audit->bindModel(array('belongsTo' => array(
				'User' => array(
						'foreignKey'=>'source_id' ),
				'Person' => array(
						'foreignKey'=>'patient_id' ) 
		 )),false);
		
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'fields' => array('Audit.*','User.username','Person.first_name','Person.last_name'),
				'conditions' => $conditions,
				'order' => 'Audit.id DESC',
		);
		$data = $this->paginate('Audit');
		$this->set('data', $data);
		$this->set('from', $this->request->query['from']);
		$this->set('to', $this->request->query['to']);
	}


	/*
	 *
	*  view audit log
	*
	*/

	public function admin_view($id=null){
		$this->uses = array('Audit','AuditDelta','Laboratory','Radiology');
		$this->set('title_for_layout', __('View Audit Log', true));
		$this->Audit->bindModel(array(
				'belongsTo'=>array(
						'User'=>array('foreignKey'=>false,'conditions'=>array("Audit.source_id=User.id"))
				)));
		$auditdata=	$this->Audit->find('first',array('conditions'=>array('Audit.id'=> $id)));
		//$auditdata['0']['Audit']['event'] = 'VIEW';
		//unset($auditdata['0']['Audit']['created'],$auditdata['0']['Audit']['id']);
		//$this->Audit->save($auditdata['0']);
		$auditdelta = $this->AuditDelta->find('all',array('conditions'=>array('AuditDelta.audit_id'=> $id)));
		$data= json_decode($auditdata[Audit][json_object]);  
		 
		if($auditdata['Audit']['model']=='LaboratoryToken'){
			$labName = $this->Laboratory->find('first',array('conditions'=>array('Laboratory.id'=>$data->LaboratoryToken->laboratory_id),'fields'=>array('Laboratory.name'))) ;
			$this->set('labName',$labName) ;
		} 
		if($auditdata['Audit']['model']=='RadiologyTestOrder'){
			$radName = $this->Radiology->find('first',array('conditions'=>array('Radiology.id'=>$data->RadiologyTestOrder->radiology_id),'fields'=>array('Radiology.name'))) ;
			$this->set('radName',$radName) ;
		}
		
		$this->set(compact('data','auditdelta','auditdata','id'));
			
	}


	/*
	 *
	*  print audit log
	*
	*/

	public function admin_printview($id=null) {
		$this->uses = array('Audit','AuditDelta');
		$this->set('title_for_layout', __('Print Audit Log', true));
		$this->layout = 'print_with_header' ;
		$this->Audit->bindModel(array(
				'belongsTo'=>array(
						'User'=>array('foreignKey'=>false,'conditions'=>array("Audit.source_id=User.id"))
				)));
		$auditdata=	$this->Audit->find('first',array('conditions'=>array('Audit.id'=> $id)));
		//$auditdata['0']['Audit']['event'] = 'PRINT';
		//unset($auditdata['0']['Audit']['created'],$auditdata['0']['Audit']['id']);
		//$this->Audit->save($auditdata['0']);
		$auditdelta = $this->AuditDelta->find('all',array('conditions'=>array('AuditDelta.audit_id'=> $id)));
		$data= json_decode($auditdata[0][Audit][json_object]);
		$this->set(compact('data','auditdelta','auditdata','id'));
	}


	/*
	 *
	*  edit audit log
	*
	*/

	public function admin_edit($id=null){
		$this->uses = array('Audit','AuditDelta','AuditDeltaLog');
		$this->set('title_for_layout', __('Edit Audit Log', true));
		$auditdata=	$this->Audit->find('all',array('fields'=>array('json_object'),'conditions'=>array('Audit.id'=> $id)));
		$auditdelta = $this->AuditDelta->find('all',array('conditions'=>array('AuditDelta.audit_id'=> $id)));
		$data= json_decode($auditdata[0][Audit][json_object]);
		$this->set(compact('data','auditdelta'));
		if(!empty($this->request->data)){
			$this->AuditDeltaLog->saveAll($this->request->data['AuditDeltaLog']['tt']);
			$this->redirect(array('controller' => 'AuditLogs', 'action' => 'admin_index'));
		}

	}

	/*
	 *
	*  delete audit log
	*
	*/

	public function admin_delete($id=null){
		$this->uses = array('Audit','AuditDeltaLog');
		$this->Audit->id=$id;
		$this->request->data['Audit']['is_deleted'] = 1;
		$this->Audit->save($this->request->data);
		$this->AuditDeltaLog->id=$id;
		$this->request->data['AuditDeltaLog']['is_deleted'] = 1;
		$this->request->data['AuditDeltaLog']['audit_id'] = $id;
		$this->request->data['AuditDeltaLog']['created_by'] = $this->Auth->user('id');
		$this->request->data['AuditDeltaLog']['created_time'] = date('Y-m-d H:i:s');
		$this->AuditDeltaLog->save($this->request->data);
		$this->redirect(array('controller' => 'AuditLogs', 'action' => 'admin_index'));
	}

	/*
	 *
	*  enable or disable the audit log for current location
	*
	*/
	public function admin_audit_log_status($id=null) {
		$this->uses = array('AuditLogStatus');
		$this->set('title_for_layout', __('Audit Log Status', true));
		if ($this->request->is('post')  || $this->request->is('put')) {
			if($id) {
				$this->AuditLogStatus->id = $id;
				$this->request->data['AuditLogStatus']['id'] = $id;
			}
			$this->request->data['AuditLogStatus']['location_id'] = $this->Session->read("locationid");
			$this->request->data['AuditLogStatus']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['AuditLogStatus']['created_by'] = $this->Auth->user('id');
			$this->request->data['AuditLogStatus']['modify_time'] = date('Y-m-d H:i:s');
			$this->request->data['AuditLogStatus']['modified_by'] = $this->Auth->user('id');
			$this->AuditLogStatus->save($this->request->data);
			$this->Session->setFlash(__('Audit Log has been changed successfully'),'default',array('class'=>'message'));
			$this->redirect(array("action" => "audit_log_permission", "admin" => true));
		}
		$this->set('id', $this->AuditLogStatus->find('first', array('conditions' => array('AuditLogStatus.location_id' => $this->Session->read('locationid')), 'fields' => array('AuditLogStatus.id','AuditLogStatus.audit_log_status'))));
	}

	/*
	 *
	* gives audit log userwise
	*
	*/
	public function admin_audit_log_permission() {
		$this->uses = array('AuditLogPermission', 'AuditLogStatus');
		$this->set('title_for_layout', __('Audit Log Permission', true));
		$this->AuditLogPermission->bindModel(array('belongsTo' => array('User' => array('foreignKey' => 'user_id'), 'Role' => array('foreignKey' => 'role_id'))));
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'AuditLogPermission.create_time' => 'asc'
				),
				'conditions' => array('AuditLogPermission.is_deleted' => 0,'AuditLogPermission.location_id' => $this->Session->read("locationid"))
		);
		$this->OtItem->recursive = 0;
		$data = $this->paginate('AuditLogPermission');
		$this->set('data', $data);
		$this->set('checkStatus', $this->AuditLogStatus->find('first', array('conditions' => array('AuditLogStatus.audit_log_status' => 0))));
	}

	/*
	 *
	* add audit log permission userwise
	*
	*/
	public function admin_add_audit_log_permission() {
		$this->uses = array('AuditLogPermission', 'User');
		$this->set('title_for_layout', __('Add Audit Log Permission', true));
		if ($this->request->is('post')  || $this->request->is('put')) {
			$this->request->data['AuditLogPermission']['location_id'] = $this->Session->read("locationid");
			$this->request->data['AuditLogPermission']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['AuditLogPermission']['created_by'] = $this->Auth->user('id');
			$this->AuditLogPermission->save($this->request->data);
			$this->Session->setFlash(__('Audit log permission added successfully'),'default',array('class'=>'message'));
			$this->redirect(array("action" => "audit_log_permission", "admin" => true));
		}
		$this->set('users', $this->User->find('list', array('fields' => array('User.id', 'User.username'), 'recursive' => 1, 'conditions' => array('User.is_deleted' => 0, 'Role.name <>' => 'superadmin'))));
	}


	/*
	 *
	* edit audit log permission userwise
	*
	*/
	public function admin_edit_audit_log_permission($id=null) {
		$this->uses = array('AuditLogPermission','User');
		$this->set('title_for_layout', __('Edit Audit Log Permission', true));
		if ($this->request->is('post')  || $this->request->is('put')) {
			$this->AuditLogPermission->id = $this->data['AuditLogPermission']['id'];
			$this->request->data['AuditLogPermission']['modify_time'] = date('Y-m-d H:i:s');
			$this->request->data['AuditLogPermission']['modified_by'] = $this->Auth->user('id');
			$this->AuditLogPermission->save($this->request->data);
			$this->Session->setFlash(__('Audit Log permission has been updated successfully'),'default',array('class'=>'message'));
			$this->redirect(array("action" => "audit_log_permission", "admin" => true));
		}
		$this->request->data = $this->AuditLogPermission->read(null, $id) ;
		$this->set('users', $this->User->find('list', array('fields' => array('User.id', 'User.username'), 'recursive' => 1, 'conditions' => array('User.is_deleted' => 0, 'Role.name <>' => 'superadmin'))));
	}

	/*
	 *
	* view audit log permission userwise
	*
	*/
	public function admin_view_audit_log_permission($id = null) {
		$this->uses = array("AuditLogPermission");
		$this->set('title_for_layout', __('View Audit Log Permission', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Audit Log Permission', true));
			$this->redirect(array("action" => "audit_log_permission"));
		}
		$this->AuditLogPermission->bindModel(array('belongsTo' => array('User' => array('foreignKey' => 'user_id'), 'Role' => array('foreignKey' => 'role_id'))));
		$this->set('auditlogperm', $this->AuditLogPermission->read(null, $id));
	}

	/*
	 *
	* delete audit log permission
	*
	*/
	public function admin_delete_audit_log_permission($id=null) {
		$this->uses = array('AuditLogPermission');
		$this->set('title_for_layout', __('Delete Audit Log Permission', true));
		if ($id) {
			$this->AuditLogPermission->id = $id;
			$this->request->data['AuditLogPermission']['id'] = $id;
			$this->request->data['AuditLogPermission']['is_deleted'] = 1;
			$this->request->data['AuditLogPermission']['modify_time'] = date('Y-m-d H:i:s');
			$this->request->data['AuditLogPermission']['modified_by'] = $this->Auth->user('id');
			$this->AuditLogPermission->save($this->request->data);
			$this->Session->setFlash(__('Audit Log has been deleted successfully'),'default',array('class'=>'message'));
			$this->redirect(array("action" => "audit_log_permission", "admin" => true));
		} else {
			$this->Session->setFlash(__('Invalid Audit Log'),'default',array('class'=>'message'));
			$this->redirect(array("action" => "audit_log_permission", "admin" => true));

		}
			
	}
	/*
	 *
	* altered audit log details
	*
	*/
	public function admin_altered_log_details() {
		$this->uses = array('AuditDeltaLog');
		$this->set('title_for_layout', __('Admin - Audit Logs History', true));
		$this->AuditDeltaLog->bindModel( array(
				'belongsTo' => array(
						'Audit'=>array(
								'conditions'=>array('Audit.id = AuditDeltaLog.audit_id'),
								'foreignKey'=>false),
						'User'=>array(
								'conditions'=>array('Audit.source_id=User.id'),
								'foreignKey'=>false,
								'fields'=>array('username'))
				)));
		
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'fields' => array('Audit.*','User.username'),
		);
		$data = $this->paginate('AuditDeltaLog');
		$this->set('data', $data);
		
	
	}
	/*
	 *
	* view for altered log
	*
	*/
	public function admin_view_altered_log($id=null) {
		$this->uses = array('Audit','AuditDeltaLog');
		$this->set('title_for_layout', __('View Audit Log', true));
		$this->Audit->bindModel(array(
				'belongsTo'=>array(
						'User'=>array('foreignKey'=>false,'conditions'=>array("Audit.source_id=User.id"))
				)));
		$auditdata=	$this->Audit->find('first',array('conditions'=>array('Audit.id'=> $id)));
		$auditdelta = $this->AuditDeltaLog->find('all',array('conditions'=>array('AuditDeltaLog.audit_id'=> $id)));
		$this->set(compact('auditdelta','auditdata','id'));
			
	}
	
	/*
	 *
	*emergency_access
	*
	*/
	public function admin_emergency_access(){
		$this->uses = array('User');
		 $this->set('title_for_layout', __('Admin - Manage Emergency Users', true));
                $this->User->unbindModel(array('belongsTo'=>array('City','State','Country')));
                $this->User->bindModel(array('belongsTo' => array('Location' => array('foreignKey'=>'location_id'),
                                                        'Initial' => array('foreignKey'=>'initial_id')
                                 			,'Role' => array('className' => 'Role','foreignKey'    => 'role_id'))),false);
                $locationID = $this->Session->read('locationid');
			    $searchUserName='';
		    	if(isset($this->request->data) && isset($this->request->data) && $this->request->data['first_name']!=''){
		    		$searchFirstName = $this->request->data['first_name'];
		    	}
	            if(isset($this->request->data) && isset($this->request->data) && $this->request->data['last_name']!=''){
		    		$searchLastName = $this->request->data['last_name'];
		    	}
    		    
		    			    	
                if($locationID==1){
                	$condition = array('User.is_deleted' => 0, 'Role.name <>' => 'superadmin','User.is_emergency'=>1);
                }else{
                	$condition = array('User.is_deleted' => 0, 'Role.name <>' => 'superadmin','Location.id'=>$locationID,'User.is_emergency'=>1);
                } 
	            if(!empty($searchFirstName)){ 
		    		$searchConditions = array('User.first_name LIKE ' => $searchFirstName.'%');
		    		$condition = array_merge($searchConditions,$condition); 
		    	}
	            if(!empty($searchLastName)){ 
		    		$searchConditions = array('User.last_name LIKE ' => $searchLastName.'%');
		    		$condition = array_merge($searchConditions,$condition); 
		    	} 
                 
                           			
                $this->paginate = array('limit' => Configure::read('number_of_rows'),
                'fields' => array('User.*','Role.name', 'Location.name','Initial.name'),
                'conditions' => $condition );
                 $this->User->unbindModel(array('belongsTo'=>array('City','State','Country')));
				$data = $this->paginate('User');
                $this->set('data', $data);
	}
	
	public function admin_add_emergency_user(){
	    	 $this->uses = array('User');
                $this->set('title_for_layout', __('Admin - Add Emergency User', true));
                if ($this->request->is('post') || $this->request->is('put')) { 
                	        $this->User->id = $this->request->data["User"]["id"];
                	   	    $this->request->data["User"]["modify_time"] = date("Y-m-d H:i:s");
	                        $this->request->data["User"]["modified_by"] = $this->Session->read('userid');
	                        $this->request->data["User"]['expiary_date'] = $this->DateFormat->formatDate2STD($this->request->data["User"]['expiary_date'],Configure::read('date_format'));
	                        $this->User->save($this->request->data);
	                       	$this->Session->setFlash(__('The User has been saved', true));
			   				$this->redirect(array("controller" => "AuditLogs", "action" => "emergency_access", "admin" => true));
                } 
		         
			    $this->set('users', $this->User->find('list', array('order' => array('User.username'),'fields'=> array('id', 'username'), 'conditions' => array('User.location_id' => $this->Session->read('locationid'), 'User.is_deleted' => 0, 'Role.name NOT' => array('superadmin', 'Superadmin', 'admin', 'Admin'),'User.is_emergency'=>0),'recursive' => 1)));
	}
	
	public function admin_edit_emergency_user($id=null){
		$this->uses = array('User');
		$this->set('title_for_layout', __('Admin - Edit Emergency User', true));
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->User->id = $this->request->data["User"]["id"];
			$this->request->data["User"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["User"]["modified_by"] = $this->Session->read('userid');
			$this->request->data["User"]['expiary_date'] = $this->DateFormat->formatDate2STD($this->request->data["User"]['expiary_date'],Configure::read('date_format'));
			$this->User->save($this->request->data);
			$this->Session->setFlash(__('The User has been saved', true));
			$this->redirect(array("controller" => "AuditLogs", "action" => "emergency_access", "admin" => true));
		}
		$this->request->data = $this->User->read(null, $id); 
		
	}
	
	
	/*
	 * 
	 * view emergency user details
	 * 
	 */
	public function admin_view_emergency_user($id = null,$emer=null) {
		$this->set('title_for_layout', __('Admin - Emergency User Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array("action" => "emergency_access", "admin" => true));
		}
		$this->uses =array('Designation','User');
		$this->User->bindModel(array('belongsTo' => array('Designation' => array('foreignKey'=>'designation_id'),
				'Location' => array('foreignKey'=>'location_id'),
				'Role' => array('className' => 'Role','foreignKey'    => 'role_id'),
				'DoctorProfile' => array('className' => 'DoctorProfile','foreignKey'    => false, 'conditions' => array('DoctorProfile.user_id=User.id')),
				'Department' => array('className' => 'Department','foreignKey'    => false, 'conditions' => array('Department.id=DoctorProfile.department_id')),
		)),false);
		$data  =$this->User->read(null, $id);
		$this->set(array('user'=> $data));
		$fields = array('full_name');
		$this->User->recursive =-1 ;
		$this->set(array('createdBy'=>$this->User->getUserByID($data['User']['created_by'],$fields),'modifiedBy'=>$this->User->getUserByID($data['User']['modified_by'],$fields)));
	}
	
	
	public function admin_add_permission(){
		
	}
	
	
	/*
	 * 
	 *  show hashing algorithm 
	 * 
	 * 
	 */
	
	public function admin_show_hash() {
		$this->set('title_for_layout', __('Edit Audit Log Permission', true));
		if ($this->request->is('post')  || $this->request->is('put')) {
			$sha1Data = sha1($this->request->data['name']);
			$md5Data = md5($this->request->data['name']);
			$rijndaelData = Security::rijndael($this->request->data['name'], '123456789023456789012345678912356457', 'encrypt');
			$this->set(compact('sha1Data','md5Data','rijndaelData'));
		}
		
	}
	
	
	
	/*
	 *
	*  listing audit log for notes edit action
	*
	*/
	public function admin_edit_notes_log($note_id=null,$patient_id=null){
		$this->uses = array('Audit','Patient');
		$this->set('title_for_layout', __('Admin - Audit Logs', true));
		if(!empty($this->request->query['from']) && !empty($this->request->query['to'])) {
			$from = $this->DateFormat->formatDate2STDForReport($this->request->query['from'],Configure::read('date_format'))." 00:00:00";
			$to = $this->DateFormat->formatDate2STDForReport($this->request->query['to'],Configure::read('date_format'))." 23:59:59";
			$conditions['Audit'] = array('created BETWEEN ? AND ?'=> array($from,$to));
		}
		
		if($patient_id != ''){
			$this->Session->write('auditPatientID',$patient_id); 
		}
		if($note_id != '')
		$this->Session->write('auditNoteID',$note_id);
		
		
		if($this->Session->check('auditPatientID')){
			$patient_uid = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$this->Session->read('auditPatientID')),
					'fields'=>array('Patient.patient_id')));
			if(!empty($patient_uid['Patient']['patient_id'])){
				$conditions['Audit']['patient_id'] = $patient_uid['Patient']['patient_id'];
			}
		}
		
		$conditions['Audit']['is_deleted'] = 0;
		$conditions['User']['location_id'] = $this->Session->read('locationid');
		$conditions['Audit']['model'] = 'PowerNote' ; //specific log between unsign note and sign note again 
		$conditions['Audit']['event'] = 'EDIT' ;
		 
		if($this->Session->read('role') != "admin" || $this->Session->read('role') != "Admin" || $this->Session->read('role') != "superadmin" || $this->Session->read('role') != "Superadmin") {
			$conditions['Audit']['source_id'] = $this->Session->read('userid');
		}
		$conditions = $this->postConditions($conditions);
	
		$this->Audit->bindModel(array('belongsTo' => array(
				'User' => array(
						'foreignKey'=>'source_id',
						'fields' => array('username'),),
		)),false);
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'fields' => array('Audit.*','User.username'),
				'conditions' => $conditions,
				'order' => 'Audit.id DESC',
		);
		$data = $this->paginate('Audit');
		$this->set('data', $data);
		$this->set('from', $this->request->query['from']);
		$this->set('to', $this->request->query['to']);
	}
	
}

?>