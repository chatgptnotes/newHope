<?php
/**
 * ConsultantsController file
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
class ConsultantsController extends AppController {

	public $name = 'Consultants';
	public $uses = array('Consultant');
	public $helpers = array('Html','Form', 'Js','General');
	public $components = array('RequestHandler','Email','DateFormat','Auth','Session', 'Acl','AclFilter');

	/**
	 * cosultants listing
	 *
	*/

	public function index() {
	   // debug('ashwin');exit;
		// for consultant search //
		$this->Consultant->virtualFields = array('full_name' => 'CONCAT(Consultant.first_name," ",Consultant.middle_name," ",Consultant.last_name)');
			
		if(!empty($this->request->data['first_name_search'])) {
			$searchFirstName = $this->request->data['first_name_search'];
			$conditionsFirstName = array('Consultant.first_name like ' => "$searchFirstName%");
			$conditions = array_merge($conditions, $conditionsFirstName);
		}
		if(!empty($this->request->data['last_name_search'])) {
			$searchLastName = $this->request->data['last_name_search'];
			$conditionsLastName = array('Consultant.last_name like ' => "$searchLastName%");
			$conditions = array_merge($conditions, $conditionsLastName);
		}
$conditions = array('Consultant.is_deleted' => 0,'Consultant.location_id'=>$this->Session->read('locationid'), 'ReffererDoctor.category' => 'referral doctor');		

//debug($conditions);exit;
		$this->Consultant->bindModel(array(
				'belongsTo' => array(
						'ReffererDoctor' =>array('foreignKey' => false,'conditions'=>array('Consultant.refferer_doctor_id=ReffererDoctor.id')),

				)),false);
		$this->paginate = array(
				'limit' => 200,
				'order' => array('Consultant.create_time' => 'desc'),
				'conditions' => $conditions
		);
		$this->set('title_for_layout', __('Manage Consultants', true));
		$this->Consultant->recursive = 0;
		$data = $this->paginate('Consultant');
		$this->set('data', $data);
	}

	/**
	 * cosultants view
	 *
	 */
	public function view($id = null) {
		$this->set('title_for_layout', __('Consultant Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid consultant', true, array('class'=>'error')));
			$this->redirect(array("action" => "index"));
		}
		$this->set('consultant', $this->Consultant->read(null, $id));
	}

	/**
	 * consultant add
	 *
	 */
	public function add() {
		$this->uses = array('City', 'Country', 'State', 'Initial','ReffererDoctor');
		$this->set('title_for_layout', __('Add New Consultant', true));
		if ($this->request->is('post')) {
			// check duplicate consultant on first , middle and last name //
			$countDuplConsult = $this->Consultant->find('count', array('conditions'=>array('Consultant.first_name' => $this->request->data['Consultant']['first_name'],'Consultant.middle_name' => $this->request->data['Consultant']['middle_name'],'Consultant.last_name' => $this->request->data['Consultant']['last_name'])));
			if(!($countDuplConsult > 0)) {
				$this->request->data['Consultant']['dateofbirth'] = $this->DateFormat->formatDate2STD($this->request->data["Consultant"]['dateofbirth'],Configure::read('date_format'));
				$this->request->data['Consultant']['location_id'] = $this->Session->read('locationid');
				$this->Consultant->create();
				$this->Consultant->save($this->request->data);
				$errors = $this->Consultant->invalidFields();
				if(!empty($errors)) {
					$this->set("errors", $errors);
				} else {
					$this->Session->setFlash(__('The consultant has been saved', false, array('class'=>'message')));
					
					if(strtolower($this->request->query['action']) == 'add'){
						$this->redirect(array('controller'=>'patients','action'=>'add','?'=>$this->request->query));
					}elseif(strtolower($this->request->query['action']) == 'edit'){
						$this->redirect(array('controller'=>'Patients','action'=>$this->request->query['action'],$this->request->query['patient_id'],'?'=>$this->request->query));
					}else
						$this->redirect(array("action" => "index"));
				}
			}else{
				$this->Session->setFlash(__('Consultant already exist', true, array('class'=>'message')));
			}
		}
		$this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'))));
		$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'))));
		$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'))));
		$this->set('initials', $this->Initial->find('list', array('fields'=> array('id', 'name'))));
		$this->set('referingdoctor', $this->ReffererDoctor->find('list', array('fields'=> array('id', 'name'),'conditions' => array('ReffererDoctor.is_deleted' => 0))));
	}

	/**
	 * consultant edit
	 *
	 */
	public function edit($id = null) {
		$this->uses = array('City', 'Country', 'State','Initial','ReffererDoctor');
		$this->set('title_for_layout', __('Edit Consultant Detail', true));
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Consultant', true, array('class'=>'error')));
			$this->redirect(array("action" => "index"));
		}
		if ($this->request->is('post') && !empty($this->request->data)) {
			// check duplicate consultant on first , middle and last name //
			$countDuplConsult = $this->Consultant->find('count', array('conditions'=>array('Consultant.first_name' => $this->request->data['Consultant']['first_name'],'Consultant.middle_name' => $this->request->data['Consultant']['middle_name'],'Consultant.last_name' => $this->request->data['Consultant']['last_name'])));
			if(!($countDuplConsult >1)) {
				$this->request->data['Consultant']['dateofbirth'] = $this->DateFormat->formatDate2STD($this->request->data["Consultant"]['dateofbirth'],Configure::read('date_format'));
				$this->Consultant->id = $this->request->data["Consultant"]['id'];
				$this->request->data['Consultant']['location_id'] = $this->Session->read('locationid');
				$this->Consultant->save($this->request->data);
				$errors = $this->Consultant->invalidFields();
				if(!empty($errors)) {
					$this->set("errors", $errors);
				} else {
					$this->Session->setFlash(__('The Consultant has been updated', true, array('class'=>'message')));
					$this->redirect(array("action" => "index"));
				}
			} else {
				$this->Session->setFlash(__('Consultant already exist', true, array('class'=>'message')));
				$this->redirect(array("action" => "edit",$this->request->data["Consultant"]['id']));
			}
		} else {
			$this->request->data = $this->Consultant->read(null, $id);
		}
		$this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'))));
		$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'))));
		$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'))));
		$this->set('initials', $this->Initial->find('list', array('fields'=> array('id', 'name'))));
		$this->set('referingdoctor', $this->ReffererDoctor->find('list', array('fields'=> array('id', 'name'),'conditions' => array('ReffererDoctor.is_deleted' => 0))));
	}

	/**
	 * consultant delete
	 *
	 */
	public function delete($id = null) {
		$this->set('title_for_layout', __('Delete Consultant', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Consultant', true, array('class'=>'error')));
			$this->redirect(array("action" => "index"));
		}
		if (!empty($id)) {
			$this->Consultant->id = $id;
			$this->request->data["Consultant"]["id"] = $id;
			$this->request->data["Consultant"]["is_deleted"] = '1';
			$this->request->data['Consultant']['location_id'] = $this->Session->read('locationid');
			$this->Consultant->save($this->request->data);
			$this->Session->setFlash(__('Consultant deleted', true, array('class'=>'message')));
			$this->redirect(array("action" => "index"));
		}else {
			$this->Session->setFlash(__('This consultant is associated with other details so you can not be deleted this consultant', true, array('class'=>'error')));
			$this->redirect(array("action" => "index"));
		}
	}

	/**
	 * cosultants listing by admin url
	 *
	 */

	public function admin_index($type=null) {
		$this->layout = 'advance';
		$this->uses=array('CorporateSublocation','MarketingTeam','Initial');
		//BOF-Mahalaxmi 
		$bothSponsor=array();
		$bothSponsor=$this->CorporateSublocation->getCorporateSublocationList();
		$bothSponsor=$bothSponsor+array('withoutsublocation'=>'Without Sponsors');
		$this->set('sponsor',$bothSponsor);
		$this->set('marketing_teams', $this->MarketingTeam->getMarketingTeamList($this->Session->read('locationid')));
		$this->set('initials', $this->Initial->find('list', array('fields'=> array('id', 'name'))));
	 	// for consultant search //
		
		if(!empty($this->request->query)){
			$this->request->data=$this->request->query;
		}
		$conditions=array('Consultant.is_deleted'=>0);
		if($this->request->data['consultant_id']){
			$conditions['Consultant.id'] = $this->request->data['consultant_id'];
		}
		if($this->request->data['corporate_sublocation_id']){
			if($this->request->data['corporate_sublocation_id']=="withoutsublocation"){
				$conditions['Consultant.corporate_sublocation_id'] =null;
			}else{
				$conditions['Consultant.corporate_sublocation_id'] = $this->request->data['corporate_sublocation_id'];
			}
		}
		if($this->request->data['market_team']){
			$conditions['Consultant.market_team'] = $this->request->data['market_team'];
		}		
		$data=$this->Consultant->find('all',array('fields'=>array('Consultant.*'),'conditions'=>$conditions,'order' => array('Consultant.first_name' => 'asc')));
// 			debug($data);exit;
		//EOF-Mahalaxmi 	
		$this->set('data', $data);
		if($type=='print'){
			$this->autoRender = false;
			$this->layout = 'print_without_header' ;
			$this->render('referral_doctor_print');
		}
		
		if($type=='excel'){
			$this->autoRender = false;					
			$this->layout = false ;
			$this->render('referral_doctor_excel');
		}
	}


	/**
	 * cosultants view by admin url
	 *
	 */
	public function admin_view($id = null) {
		$this->set('title_for_layout', __('Consultant Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid consultant', true, array('class'=>'error')));
			$this->redirect(array("action" => "index", 'admin'=> true));
		}
		$this->set('consultant', $this->Consultant->read(null, $id));
	}

	/**
	 * consultant add by admin url
	 *
	 */
	public function admin_add() {
		$this->uses = array('City', 'Country', 'State', 'Initial','ReffererDoctor','MarketingTeam','AccountingGroup','CorporateSublocation','HrDetail');
		$this->set('title_for_layout', __('Add New Consultant', true));
		if ($this->request->is('post')) {
			// check duplicate consultant on first , middle and last name //
			//  $countDuplConsult = $this->Consultant->find('count', array('conditions'=>array('Consultant.first_name' => $this->request->data['Consultant']['first_name'],'Consultant.middle_name' => $this->request->data['Consultant']['middle_name'],'Consultant.last_name' => $this->request->data['Consultant']['last_name'])));
			//    if(!($countDuplConsult > 0)) {
			$this->request->data['Consultant']['dateofbirth'] = $this->DateFormat->formatDate2STD($this->request->data["Consultant"]['dateofbirth'],Configure::read('date_format'));
			$this->request->data['Consultant']['camp_date'] = $this->DateFormat->formatDate2STD($this->request->data["Consultant"]['camp_date'],Configure::read('date_format'));
				
			$this->request->data['Consultant']['location_id'] = $this->Session->read('locationid');
			$this->Consultant->create();
			
			$this->Consultant->save($this->request->data);
			$last_user = $this->Consultant->getInsertId();
			if(!empty($this->request->data['HrDetail'])){
				$this->request->data['HrDetail']['user_id']=$last_user;
				$this->request->data['HrDetail']['type_of_user']=Configure::read('consultantUser');					
				$this->HrDetail->saveData($this->request->data);
			}
			
			$errors = $this->Consultant->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The consultant has been saved', true, array('class'=>'message')));
				$this->redirect(array("action" => "index", 'admin'=> true));
			}
			//} else {
			//      $this->Session->setFlash(__('Consultant already exist', true, array('class'=>'message')));
			//}
		}
		$this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'))));
		$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'))));
		$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'))));
		$this->set('initials', $this->Initial->find('list', array('fields'=> array('id', 'name'))));
		$this->set('group',$this->AccountingGroup->getAllGroup());
		$this->set('groupId',$this->AccountingGroup->getAccountingGroupID(Configure::read('sundry_creditors')));
		$this->set('marketing_teams', $this->MarketingTeam->find('list', array('fields'=> array('name', 'name'),'conditions'=>array('MarketingTeam.is_deleted'=>'0','MarketingTeam.location_id'=>$this->Session->read('locationid')))));
		$this->set('referingdoctor', $this->ReffererDoctor->find('list', array('fields'=> array('id', 'name'),'conditions' => array('ReffererDoctor.is_deleted' => 0, 'ReffererDoctor.category' => 'referral doctor'))));
		$this->set('sponsor',$this->CorporateSublocation->find('list',array('fields'=>array('id','name'),'conditions'=>array('CorporateSublocation.is_deleted'=>0))));
	//debug( $this->MarketingTeam->find('list', array('fields'=> array('name', 'name'))));exit;
	}

	/**
	 * consultant edit by admin url
	 *
	 */
	public function admin_edit($id = null) {
		$this->uses = array('City', 'Country', 'State','Initial','ReffererDoctor','MarketingTeam','AccountingGroup','CorporateSublocation','HrDetail');
		$this->set('title_for_layout', __('Edit Consultant Detail', true));
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Consultant', true, array('class'=>'error')));
			$this->redirect(array("action" => "index", 'admin'=> true));
		}
		if ($this->request->is('post') && !empty($this->request->data)) {
			// check duplicate consultant on first , middle and last name //
			// $countDuplConsult = $this->Consultant->find('count', array('conditions'=>array('Consultant.first_name' => $this->request->data['Consultant']['first_name'],'Consultant.middle_name' => $this->request->data['Consultant']['middle_name'],'Consultant.last_name' => $this->request->data['Consultant']['last_name'])));

			//if(!($countDuplConsult > 1)) {
			$this->request->data['Consultant']['dateofbirth'] = $this->DateFormat->formatDate2STD($this->request->data["Consultant"]['dateofbirth'],Configure::read('date_format'));
			$this->request->data['Consultant']['camp_date'] = $this->DateFormat->formatDate2STD($this->request->data["Consultant"]['camp_date'],Configure::read('date_format'));
			$this->request->data['Consultant']['location_id'] = $this->Session->read('locationid');
			$this->Consultant->id = $this->request->data["Consultant"]['id'];
			$this->Consultant->save($this->request->data);
		
			if(!empty($this->request->data['HrDetail']) && !empty($this->request->data["Consultant"]['id'])){				
				$this->request->data['HrDetail']['user_id']=$this->request->data["Consultant"]['id'];
				$this->request->data['HrDetail']['type_of_user']=Configure::read('consultantUser');					
				$this->HrDetail->saveData($this->request->data);
			}
			$errors = $this->Consultant->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The Consultant has been updated', true, array('class'=>'message')));
				$this->redirect(array("action" => "index", 'admin'=> true));
			}
			//} else {
			//         $this->Session->setFlash(__('Consultant already exist', true, array('class'=>'message')));
			//$this->redirect(array("action" => "edit", 'admin'=> true,$this->request->data["Consultant"]['id']));
			//         }
		} else {
			$this->request->data = $this->Consultant->read(null, $id);
			//BOF-Mahalaxmi for Fetch the hrdetails
			$this->set('hrDetails',$this->HrDetail->findFirstHrDetails($id,Configure::read('consultantUser')));
			//EOF-Mahalaxmi for Fetch the hrdetails
		}

		$this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'))));
		$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'))));
		$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'))));
		$this->set('initials', $this->Initial->find('list', array('fields'=> array('id', 'name'))));
		$this->set('group',$this->AccountingGroup->getAllGroup());
		$this->set('groupId',$this->AccountingGroup->getAccountingGroupID(Configure::read('sundry_creditors')));
		$this->set('marketing_teams', $this->MarketingTeam->find('list', array('fields'=> array('name','name'),'conditions'=>array('MarketingTeam.is_deleted'=>'0','MarketingTeam.location_id'=>$this->Session->read('locationid')))));
		$this->set('referingdoctor', $this->ReffererDoctor->find('list', array('fields'=> array('id', 'name'),'conditions' => array('ReffererDoctor.is_deleted' => 0, 'ReffererDoctor.category' => 'referral doctor'))));
		$this->set('sponsor',$this->CorporateSublocation->find('list',array('fields'=>array('id','name'),'conditions'=>array('CorporateSublocation.is_deleted'=>0))));
	}

	/**
	 * consultant delete by admin url
	 *
	 */
	public function admin_delete($id = null) {
		$this->set('title_for_layout', __('Delete Consultant', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Consultant', true, array('class'=>'error')));
			$this->redirect(array("action" => "index", 'admin'=> true));
		}
		if (!empty($id)) {
			$this->Consultant->id = $id;
			$this->request->data["Consultant"]["id"] = $id;
			$this->request->data["Consultant"]["is_deleted"] = '1';
			$this->Consultant->save($this->request->data);
			$this->Session->setFlash(__('Consultant deleted', true, array('class'=>'message')));
			$this->redirect(array("action" => "index", 'admin'=> true));
		}else {
			$this->Session->setFlash(__('This consultant is associated with other details so you can not be deleted this consultant', true, array('class'=>'error')));
			$this->redirect(array("action" => "index", 'admin'=> true));
		}
	}

	/**
	 * autocomplet consultant search value
	 *
	 */
	public function autocompelete_consultant($field=null) { 
		//$this->layout = "ajax";
		$searchKeyVal = $this->params->query['term'];			
		$this->loadModel("Consultant");
		$this->Consultant->bindModel(array(
				'belongsTo' => array(
					'ReffererDoctor' =>array('foreignKey' => false,'conditions'=>array('Consultant.refferer_doctor_id=ReffererDoctor.id')),
						'Initial' =>array('foreignKey' => false,'conditions'=>array('Initial.id=Consultant.initial_id')),

				)),false);
		/*$this->Consultant->bindModel(array(
				'belongsTo' => array(
						'ReffererDoctor' =>array('foreignKey' => false,'conditions'=>array('Consultant.refferer_doctor_id=ReffererDoctor.id')),

				)),false);
			
		if($this->params['pass'][0] == "first_name") {
			$consultant = $this->Consultant->find('list', array('fields'=> array('Consultant.id', 'first_name'),'conditions'=>array('Consultant.is_deleted' => 0,'Consultant.first_name like'=> "%$searchKeyVal%", 'ReffererDoctor.category' => 'referral doctor','Consultant.location_id' => $this->Session->read('locationid')),'limit'=>'5', 'recursive' => 1));
		} elseif($this->params['pass'][0] == "last_name") {
			$consultant = $this->Consultant->find('list', array('fields'=> array('Consultant.id', 'last_name'),'conditions'=>array('Consultant.is_deleted' => 0,'Consultant.last_name like'=> "%$searchKeyVal%", 'ReffererDoctor.category' => 'referral doctor','Consultant.location_id' => $this->Session->read('locationid')),'limit'=>'5', 'recursive' => 1));
		} else {*/
			$this->Consultant->virtualFields = array('first_name' => 'CONCAT(Initial.name,"",Consultant.first_name," ",Consultant.middle_name," ",Consultant.last_name)');
			$consultant = $this->Consultant->find('list', array('fields'=> array('Consultant.id', 'first_name'),'conditions'=>array('Consultant.is_deleted' => 0,'OR' => array('Consultant.first_name like'=> "%$searchKeyVal%", 'Consultant.last_name like'=> "%$searchKeyVal%",'Consultant.middle_name like'=> "%$searchKeyVal%"),'ReffererDoctor.category' => 'referral doctor','Consultant.location_id' => $this->Session->read('locationid')),'limit'=>'5', 'recursive' => 1));
		//}
			
		foreach ($consultant as $key=>$value) {
			$returnArray[]=array('id'=>$key,'value'=>$value);
			//echo "$value|$key\n";
		}
		echo json_encode($returnArray);
		exit;//dont remove this
			
	}
	
	public function fetch_consultatnt($field=null){
		
		$this->loadModel("Consultant");
		$this->Consultant->bindModel(array(
				'belongsTo' => array(
						'ReffererDoctor' =>array('foreignKey' => false,'conditions'=>array('Consultant.refferer_doctor_id=ReffererDoctor.id')),

				)),false);
	
		$searchKey = $this->params->query['term'];
	
		$filedOrder = array();
		if($field == "first_name"){
			$filedOrder = array('Consultant.id','Consultant.first_name','Consultant.last_name');
		}
			
		//$conditions["Consultant.first_name like"] = '%'.$searchKey.'%';
		//$conditions["Consultant.last_name like"] ='%'.$searchKey.'%';
		$conditions['OR']=array('Consultant.first_name like' => '%'.$searchKey.'%','Consultant.last_name like' => '%'.$searchKey.'%');
		$conditions["Consultant.is_deleted"] = 0;
		$conditions["ReffererDoctor.category"] = 'referral doctor';
		$conditions["Consultant.location_id"] = $this->Session->read('locationid');
	
		$consultant = $this->Consultant->find('all', 
				array('fields'=> $filedOrder,
					  'conditions'=>$conditions /* 'recursive' => 1 */,'limit'=>'20'));
	
		foreach ($consultant as $key => $value) {
			$id = $value['Consultant']['id'];
			$output = $value['Consultant']['first_name']." ".$value['Consultant']['last_name'];
		
			$returnArray[] = array('id'=>$id,'value'=>$output);	
		}
		echo json_encode($returnArray);
		exit;//dont remove this
	}


	/**
	 * list of inhouse and external doctor by non admin url
	 *
	 */

	public function inhouse_externaldoctor() {
			
		$this->loadModel('Doctor');
		// for consultant search //
		$this->Consultant->bindModel(array(
				'belongsTo' => array(
						'ReffererDoctor' =>array('foreignKey' => false,'conditions'=>array('Consultant.refferer_doctor_id=ReffererDoctor.id')),

				)),false);


			
		$conditions = array('Consultant.is_deleted' => 0,'Consultant.location_id'=>$this->Session->read('locationid'), 'ReffererDoctor.is_referral' => 'N');
		$treatingconsult_conditions = array('Doctor.is_deleted' => 0,'Role.id <>' => 1,'Role.name'=> array(Configure::read('doctorLabel'), Configure::read('RegistrarLabel')),'Doctor.location_id'=>$this->Session->read('locationid'));
			
		if($this->request->data['consultant_first_name_search']) {
			$firstName = $this->request->data['consultant_first_name_search'];
			$consultantSearchConditions = array("Consultant.first_name like" => "$firstName%");
			$treatingSearchconditions = array("Doctor.first_name like " => "$firstName%");
			$conditions = array($conditions,$consultantSearchConditions);
			$treatingconsult_conditions = array_merge($treatingconsult_conditions,$treatingSearchconditions);
		}
		if($this->request->data['consultant_last_name_search']) {
			$lastName = $this->request->data['consultant_last_name_search'];
			$consultantSearchConditions = array("Consultant.last_name like" => "$lastName%");
			$treatingSearchconditions = array("Doctor.last_name like " => "$lastName%");
			$conditions = array($conditions,$consultantSearchConditions);
			$treatingconsult_conditions = array_merge($treatingconsult_conditions,$treatingSearchconditions);
		}

		$this->paginate = array(
				'limit' => 101,
				'order' => array('Consultant.create_time' => 'desc'),
				'conditions' => $conditions
		);
		$this->set('title_for_layout', __('Manage In-House & External Doctor', true));
		$data = $this->paginate('Consultant');
		$this->set('data', $data);
		// for treating consultant //
		$this->paginate = array(
				'limit' => 101,
				'order' => array('Doctor.doctor_name' => 'asc'),
				'conditions' => $treatingconsult_conditions
		);

		$treatingconsultdata = $this->paginate('Doctor');
			
		$this->set('treatingconsultdata', $treatingconsultdata);
	}

	/**
	 * inhouse and external doctor listing by admin url
	 *
	 */

	public function admin_inhouse_externaldoctor() {
		$this->Consultant->bindModel(array(
				'belongsTo' => array(
						'ReffererDoctor' =>array('foreignKey' => false,'conditions'=>array('Consultant.refferer_doctor_id=ReffererDoctor.id')),
						'Initial' =>array('foreignKey' => false,'conditions'=>array('Consultant.initial_id=Initial.id')),

				)),false);
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'Consultant.create_time' => 'asc'
				),
				'conditions' => array('Consultant.is_deleted' => 0, 'Consultant.location_id' => $this->Session->read('locationid'), 'ReffererDoctor.is_referral' => 'N')
		);
			
		$this->set('title_for_layout', __('Manage In-House & External Doctor', true));
		$this->Consultant->recursive = 0;
		$data = $this->paginate('Consultant');
		$this->set('data', $data);
	}
	/**
	 * inhouse & external doctor view by admin url
	 *
	 */
	public function admin_inhouse_externaldoctor_view($id = null) {
		$this->set('title_for_layout', __('In-House & External Doctor Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid consultant', true, array('class'=>'error')));
			$this->redirect(array("action" => "index", 'admin'=> true));
		}
		$this->set('consultant', $this->Consultant->read(null, $id));
	}

	/**
	 * inhouse and external doctor add by admin url
	 *
	 */
	public function admin_inhouse_externaldoctor_add() {
		$this->uses = array('City', 'Country', 'State', 'Initial','ReffererDoctor','AccountingGroup');
		$this->set('title_for_layout', __('Add New In-House & External Doctor', true));
		
		//BOF for accounting external charges and hospital charges sharing for consultant jv by amit jain
		if(!empty($this->request->data['Service']['external_charges'])){
			$doctorName = $this->request->data['Consultant']['first_name']." ".$this->request->data['Consultant']['last_name'];
			$this->request->data['Service']['name']=$doctorName;
			$dataService = $this->request->data['Service'];
			$this->request->data['Consultant']['doctor_commision'] = $dataNew  = serialize($dataService);
		}
		//EOF by amit jain
		
		if ($this->request->is('post')) {
			// check duplicate consultant on first , middle and last name //
			//  $countDuplConsult = $this->Consultant->find('count', array('conditions'=>array('Consultant.first_name' => $this->request->data['Consultant']['first_name'],'Consultant.middle_name' => $this->request->data['Consultant']['middle_name'],'Consultant.last_name' => $this->request->data['Consultant']['last_name'])));
			//    if(!($countDuplConsult > 0)) {
			$this->request->data['Consultant']['dateofbirth'] = $this->DateFormat->formatDate2STD($this->request->data["Consultant"]['dateofbirth'],Configure::read('date_format'));
			$this->request->data['Consultant']['location_id'] = $this->Session->read('locationid');
			$this->request->data['Consultant']['is_active'] = 1;
			$this->Consultant->create();
			//debug($this->request->data);exit;
			$this->Consultant->save($this->request->data);
			$errors = $this->Consultant->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The consultant has been saved', true, array('class'=>'message')));
				$this->redirect(array("action" => "inhouse_externaldoctor", 'admin'=> true));
			}
			//} else {
			//      $this->Session->setFlash(__('Consultant already exist', true, array('class'=>'message')));
			//}
		}
		$this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'))));
		$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'))));
		$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'))));
		$this->set('initials', $this->Initial->find('list', array('fields'=> array('id', 'name'))));
		$this->set('group',$this->AccountingGroup->getAllGroup());
		$this->set('groupId',$this->AccountingGroup->getAccountingGroupID(Configure::read('sundry_creditors')));
		$this->set('referingdoctor', $this->ReffererDoctor->find('list', array('fields'=> array('id', 'name'),'conditions' => array('ReffererDoctor.is_deleted' => 0, 'ReffererDoctor.is_referral' => 'N'))));
	}

	/**
	 * inhouse and external doctor edit by admin url
	 *
	 */
	public function admin_inhouse_externaldoctor_edit($id = null) {
		$this->uses = array('City', 'Country', 'State','Initial','ReffererDoctor','AccountingGroup');
		$this->set('title_for_layout', __('Edit In-House & External Doctor', true));
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Consultant', true, array('class'=>'error')));
			$this->redirect(array("action" => "inhouse_externaldoctor", 'admin'=> true));
		}
		
		//BOF for accounting external charges and hospital charges sharing for consultant jv by amit jain
		if(!empty($this->request->data['Service']['external_charges'])){
			$doctorName = $this->request->data['Consultant']['first_name']." ".$this->request->data['Consultant']['last_name'];
			$this->request->data['Service']['name']=$doctorName;
			$dataService = $this->request->data['Service'];
			$this->request->data['Consultant']['doctor_commision'] = $dataNew  = serialize($dataService);
		}
		//EOF by amit jain
		
		if ($this->request->is('post') && !empty($this->request->data)) {
			// check duplicate consultant on first , middle and last name //
			// $countDuplConsult = $this->Consultant->find('count', array('conditions'=>array('Consultant.first_name' => $this->request->data['Consultant']['first_name'],'Consultant.middle_name' => $this->request->data['Consultant']['middle_name'],'Consultant.last_name' => $this->request->data['Consultant']['last_name'])));

			//if(!($countDuplConsult > 1)) {
			$this->request->data['Consultant']['dateofbirth'] = $this->DateFormat->formatDate2STD($this->request->data["Consultant"]['dateofbirth'],Configure::read('date_format'));
			$this->request->data['Consultant']['location_id'] = $this->Session->read('locationid');
			$this->request->data['Consultant']['is_active'] = 1;
			$this->Consultant->id = $this->request->data["Consultant"]['id'];
			$this->Consultant->save($this->request->data);
			$errors = $this->Consultant->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The Consultant has been updated', true, array('class'=>'message')));
				$this->redirect(array("action" => "inhouse_externaldoctor", 'admin'=> true));
			}
			//} else {
			//         $this->Session->setFlash(__('Consultant already exist', true, array('class'=>'message')));
			//$this->redirect(array("action" => "edit", 'admin'=> true,$this->request->data["Consultant"]['id']));
			//         }
		} else {
			$this->request->data = $this->Consultant->read(null, $id);
		}
		$this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'))));
		$this->set('group',$this->AccountingGroup->getAllGroup());
		//for doctor commision
		$this->set('commission',$this->Consultant->find('first',array('fields'=>array('Consultant.doctor_commision'),'conditions'=>array('Consultant.id'=>$id))));
		$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'))));
		$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'))));
		$this->set('initials', $this->Initial->find('list', array('fields'=> array('id', 'name'))));
		$this->set('referingdoctor', $this->ReffererDoctor->find('list', array('fields'=> array('id', 'name'),'conditions' => array('ReffererDoctor.is_deleted' => 0, 'ReffererDoctor.is_referral' => 'N'))));
	}

	/**
	 * inhouse and external doctor delete by admin url
	 *
	 */
	public function admin_inhouse_externaldoctor_delete($id = null) {
		$this->set('title_for_layout', __('Delete In-House & External Doctor', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid In-House & External Doctor', true, array('class'=>'error')));
			$this->redirect(array("action" => "inhouse_externaldoctor", 'admin'=> true));
		}
		if (!empty($id)) {
			$this->Consultant->id = $id;
			$this->request->data["Consultant"]["id"] = $id;
			$this->request->data["Consultant"]["is_deleted"] = '1';
			$this->Consultant->save($this->request->data);
			$this->Session->setFlash(__('In-House & External Doctor deleted', true, array('class'=>'message')));
			$this->redirect(array("action" => "inhouse_externaldoctor", 'admin'=> true));
		}else {
			$this->Session->setFlash(__('This In-House & External Doctor is associated with other details so you can not be deleted this In-House & External Doctor', true, array('class'=>'error')));
			$this->redirect(array("action" => "inhouse_externaldoctor", 'admin'=> true));
		}
	}
	/**
	 * treating cosultants view
	 *
	 */
	public function treatingconsultant_view($id = null) {
		$this->uses = array('Department','Doctor','DoctorProfile','LicensureType');
		$this->set('title_for_layout', __('Admin - Doctor Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Admin', true));
			$this->redirect(array("controller" => "doctors", "action" => "index", "admin" => true));
		}
		$doctorDetails = $this->Doctor->read(null, $id);
		$doctorDepartment = $this->Department->read(null, $doctorDetails['DoctorProfile']['department_id']);
		$licenture= $this->LicensureType->find('first', array('fields'=> array('id', 'name'),'conditions' => array('LicensureType.id' =>$doctorDetails[Doctor][licensure_type])));
		//'conditions' => array('Location.is_deleted' => 0,'Location.is_active' => 1))));
		//'Designation.location_id' => $this->Session->read('locationid'),
		//$licensure= $this->LicensureType->read(null,$doctorDetails['LicensureType']['name']);
		//debug($licenture[LicensureType][name]);exit;
		$this->set('licenture',$licenture);
		$this->set('doctor', $doctorDetails);
		$this->set('department', $doctorDepartment);
	}

	/**
	 * external cosultants view
	 *
	 */
	public function external_consultant_view($id = null) {
		$this->set('title_for_layout', __('Consultant Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid consultant', true, array('class'=>'error')));
			$this->redirect(array("action" => "index"));
		}
		$this->set('consultant', $this->Consultant->read(null, $id));
	}

	/**
	 * autocomplet In-House & External Doctor search value
	 *
	 */
	public function autocompelete_inhouseconsultant($field=null) {
		$this->layout = "ajax";
		$searchKeyVal = $this->params->query['q'];
		$this->uses = array("Consultant", "DoctorProfile");
		$this->Consultant->bindModel(array(
				'belongsTo' => array(
						'ReffererDoctor' =>array('foreignKey' => false,'conditions'=>array('Consultant.refferer_doctor_id=ReffererDoctor.id')),

				)),false);

		$consultant = $this->Consultant->find('list', array('fields'=> array('Consultant.id',$field),'conditions'=>array("Consultant.is_deleted" => 0,"Consultant.$field like"=> "%$searchKeyVal%","ReffererDoctor.category" => "inhouse and external consultant" ,"Consultant.location_id" => $this->Session->read('locationid')), "recursive" => 1));
		// get treating consultant //
		$treatingConsultant = $this->DoctorProfile->find('list',array('fields'=>array('user_id',$field),
				'conditions'=>array("DoctorProfile.$field like"=>'%'.$searchKeyVal.'%','User.is_deleted'=>0, 'DoctorProfile.is_deleted'=>0,'DoctorProfile.location_id'=>$this->Session->read('locationid')), 'recursive' => 1));
		$consultant = array_merge($consultant,$treatingConsultant);
			
		foreach ($consultant as $key=>$value) {
			echo "$value|$key\n";
		}
		exit;//dont remove this
			
	}
	/**
     * for update consultant
     * By Mahalaxmi
     * @params ID and (remark or alias)
     * return result update
     */
	public function updateConsultant(){
		$this->uses = array('Consultant');
		$this->autoRender = false;
		$this->Layout = 'ajax';	
		
		if(!empty($this->request->data['consultantIds'])){
			$this->request->data['Consultant']['id']=$this->request->data['consultantIds'];
			if($this->request->data['consultantIdtext']=='remark'){
				$this->request->data['Consultant']['remark'] = $this->request->data['textval'];	
			}
			if($this->request->data['consultantIdtext']=='alias'){
				$this->request->data['Consultant']['alias'] = $this->request->data['textval'];	
			}			
			if($this->Consultant->validates()){				
				$this->Consultant->save($this->request->data);				
			}
		}
		exit;
	}


	 public function referralDischargeReport($Reporttype =null){
	 	
    	
    	$this->uses = array('Patient','Consultant','TariffStandard');
   
    	if(empty($this->params->query)){
    		     $date = date('Y-m');
    		     $conditions['DATE_FORMAT(Patient.form_received_on,"%Y-%m")']= $date;
    	}else{
    		
    		if(!empty($this->params->query['district'])){
    			$conditions['Person.district'] = $this->params->query['district'];
    		}

    		if(!empty($this->params->query['tariff_standard_id'])){
    			$conditions['Patient.tariff_standard_id'] = $this->params->query['tariff_standard_id'];
    		}

			if(!empty($this->params->query['is_discharge'])){
				if($this->params->query['is_discharge'] == 'Non Discharged'){
					$conditions['Patient.is_discharge'] = '0';
				}else if($this->params->query['is_discharge'] == 'Discharged'){
					$conditions['Patient.is_discharge'] = '1';
				}
    			
    		}
    		if( !empty($this->params->query['year']['year'] &&  $this->params->query['month']['month'])){
    			$year = $this->params->query['year']['year'];
	    		$month = $this->params->query['month']['month'];
	    		$date = date($year."-".$month);

	    		$conditions['DATE_FORMAT(Patient.form_received_on,"%Y-%m")']= $date;
    		}

    	
    		
    		
    	}

			
    	$this->Patient->bindModel(array(
					'belongsTo' => array(
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id')),
							'FinalBilling' =>array('foreignKey' => false,'conditions'=>array('FinalBilling.patient_id=Patient.id')),
							'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id')),	
							'DischargeSummary' =>array('foreignKey' => false,'conditions'=>array('DischargeSummary.patient_id=Patient.id')),			
					)),false);

	$dischargeReferral = $this->Patient->find('all',array(
		'fields'=>array('Patient.id','Patient.lookup_name','Patient.discharge_date','Patient.consultant_id','Patient.form_received_on',
						'Patient.spot_amount','Patient.b_amount','Person.id','Person.district','Person.district','FinalBilling.id',
						'FinalBilling.amount_paid','TariffStandard.name','User.first_name','User.last_name','DischargeSummary.review_on','DischargeSummary.final_diagnosis'),
    			'conditions'=>array($conditions,'Patient.is_deleted'=>'0',
    				'Patient.consultant_id NOT'=>array('a:1:{i:0;s:4:"None";}','N;')),
    			'group'=>array('Patient.id')));

    $referralList = $this->Consultant->getReffererDoctor();
    $tariffList = $this->TariffStandard->getAllTariffStandard();

	$this->set(array('dischargeReferral'=>$dischargeReferral,'referralList'=>$referralList,'tariffList'=>$tariffList));

	if($Reporttype=='excel'){
			$this->layout=false;
			$this->render('referral_discharge_report_xls',false);
		}
    	
    }
    
    public function referral_hub(){
        $this->layout = false;
            $referalId = isset($this->request->query['referal_id']) ? $this->request->query['referal_id'] : null;
                if (!$referalId) {
                        $this->Session->setFlash(__('Referral ID not provided.'));
                        return $this->redirect($this->referer());
                    }
                    $this->loadModel('Consultant');
                    $referralData = $this->Consultant->find('first', array(
                        'conditions' => array('Consultant.id' => $referalId),
                    ));
                    if (empty($referralData)) {
                        $this->Session->setFlash(__('No data found for the provided Referral ID.'));
                        return $this->redirect($this->referer());
                    }
                    $this->set('referralData', $referralData);
                    
                    $this->loadModel('Person');
                    $referal_patient = $this->Person->find('all', array(
                        'conditions' => array('Person.agent_id' => $referalId),
                    ));
                    // debug($referal_patient);exit;$referal_patient
                    $this->set('referal_patient', $referal_patient);
                    
                     $this->loadModel('ReferralConsultant');
                    $desposition_data = $this->ReferralConsultant->find('all', array(
                        'conditions' => array('ReferralConsultant.consultant_id' => $referalId),
                    ));
                  
                    $this->set('desposition_data', $desposition_data);
                      $this->loadModel('Referal');
                    $referralData_customer = $this->Referal->find('all', array(
                        // 'conditions' => array('Referal.agent_id' => $referalId),
                    ));
                   
                    $this->set('referralData_customer', $referralData_customer);
                 if ($this->request->is('post')) {
                        $this->Consultant->id = $referalId;
  
            if ($this->Consultant->save($this->request->data)) {
               
                $this->Session->setFlash(__('Referral data updated successfully.'));
                return $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(__('Unable to update referral data.'));
            }
        }
        	 	
            }

public function initializeDatabase()
    {
        $userSession = $this->Session->read('Auth.User');
        $userDatabase = $this->Session->read('db_name');
        return $userDatabase;
    }

			public function uploadLeads() {
				$this->autoRender = false;
			
				if ($this->request->is('post')) {
					$this->loadModel('Referal');
// 			debug($this->request->is('post'));exit;
					$file = $this->request->data['Consultant']['excel_file'];
			
					// Check if file is uploaded
					if ($file['error'] !== 0) {
						$this->Session->setFlash(__('Please upload a valid file.'), 'default', array('class' => 'error'));
						return $this->redirect($this->referer());
					}
			
					// Validate file extension
					$fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
					if (!in_array($fileExtension, ['xls', 'csv'])) {
						$this->Session->setFlash(__('Only .xls and .csv files are allowed.'), 'default', array('class' => 'error'));
						return $this->redirect($this->referer());
					}
			
					// Path to save the uploaded file
					$path = WWW_ROOT . 'uploads/import/' . $file['name'];
					move_uploaded_file($file['tmp_name'], $path);
					chmod($path, 0777);
			
					$referals = [];
			
					// Process .csv file
					if ($fileExtension === 'csv') {
						if (($handle = fopen($path, 'r')) !== false) {
							$row = 0;
							while (($data = fgetcsv($handle, 1000, ',')) !== false) {
								$row++;
								if ($row === 1) {
									// Skip the header row
									continue;
								}
								$referals[] = [
									'Referal' => [
										'name' => $data[0],         // Column 1: Name
										'mobile' => $data[1],       // Column 2: Mobile
										'created_time' => $data[2], // Column 3: Created Time
										'agent_id' => $data[3],     // Column 4: Agent ID
									]
								];
							}
							fclose($handle);
						}
					}
			
					// Process .xls file
					elseif ($fileExtension === 'xls') {
						App::import('Vendor', 'reader'); // Assuming 'reader.php' is in Vendor folder
						$data = new Spreadsheet_Excel_Reader();
						$data->setOutputEncoding('CP1251');
						$data->read($path);
			
						for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
							$referals[] = [
								'Referal' => [
									'name' => $data->sheets[0]['cells'][$i][1],        // Column A: Name
									'mobile' => $data->sheets[0]['cells'][$i][2],      // Column B: Mobile
									'created_time' => $data->sheets[0]['cells'][$i][3],// Column C: Created Time
									'agent_id' => $data->sheets[0]['cells'][$i][4],    // Column D: Agent ID
								]
							];
						}
					}
			
					// Save data to database
					if ($this->Referal->saveAll($referals)) {
						unlink($path); // Delete the uploaded file
						$this->Session->setFlash(__('Leads uploaded successfully.'), 'default', array('class' => 'success'));
						return $this->redirect($this->referer());
					} else {
						unlink($path); // Delete the uploaded file
						$this->Session->setFlash(__('Error occurred while saving data. Please check your file.'), 'default', array('class' => 'error'));
						return $this->redirect($this->referer());
					}
				}
			
				$this->Session->setFlash(__('No data found to process.'), 'default', array('class' => 'error'));
				return $this->redirect($this->referer());
			}
			
				public function leads_upload() {
				$this->autoRender = false;
			
				if ($this->request->is('post')) {
					$this->uses = array('Referal');
					$database = $this->initializeDatabase();
					$this->Referal->useDbConfig = $database;
					$this->loadModel('Referal');		
					$file = $this->request->data['Consultant']['excel_file'];
					if ($file['error'] !== 0) {
						$this->Session->setFlash(__('Please upload a valid file.'), 'default', array('class' => 'error'));
						return $this->redirect($this->referer());
					}
					$fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
					if (!in_array($fileExtension, ['xls', 'csv'])) {
						$this->Session->setFlash(__('Only .xls and .csv files are allowed.'), 'default', array('class' => 'error'));
						return $this->redirect($this->referer());
					}
					$path = WWW_ROOT . 'uploads/import/' . $file['name'];
					move_uploaded_file($file['tmp_name'], $path);
					chmod($path, 0777);			
					$referals = [];
					if ($fileExtension === 'csv') {
						if (($handle = fopen($path, 'r')) !== false) {
							$row = 0;
							while (($data = fgetcsv($handle, 1000, ',')) !== false) {
								$row++;
								if ($row === 1) {
									continue;
								}
								$referals[] = [
									'Referal' => [
										'name' => $data[0],         // Column 1: Name
										'mobile' => $data[1],       // Column 2: Mobile
										'created_time' => $data[2], // Column 3: Created Time
										'marketing_agent_id' => $data[3],     // Column 4: Agent ID
									]
								];
							
							}
							fclose($handle);
						}
					
					}
					
					// Process .xls file
					elseif ($fileExtension === 'xls') {
						App::import('Vendor', 'reader'); // Assuming 'reader.php' is in Vendor folder
						$data = new Spreadsheet_Excel_Reader();
						$data->setOutputEncoding('CP1251');
						$data->read($path);
						
						for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
							$referals[] = [
								'Referal' => [
									'name' => $data->sheets[0]['cells'][$i][1],        // Column A: Name
									'mobile' => $data->sheets[0]['cells'][$i][2],      // Column B: Mobile
									'created_time' => $data->sheets[0]['cells'][$i][3],// Column C: Created Time
									'marketing_agent_id' => $data->sheets[0]['cells'][$i][4],    // Column D: Agent ID
								]
							];
						}
						
					}
					if ($this->Referal->saveAll($referals)) {
						unlink($path); // Delete the uploaded file
						$this->Session->setFlash(__('Leads uploaded successfully.'), 'default', array('class' => 'success'));
						return $this->redirect($this->referer());
					} else {
						unlink($path); // Delete the uploaded file
						$this->Session->setFlash(__('Error occurred while saving data. Please check your file.'), 'default', array('class' => 'error'));
						return $this->redirect($this->referer());
					}
				}
			
									$this->Session->setFlash(__('No data found to process.'), 'default', array('class' => 'error'));
								return $this->redirect($this->referer());
			}
		
			

}

