<?php
/**
 * noteTemplatesController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       noteTemplates.Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class NotesController extends AppController {

	public $name = 'Notes';
	public $uses = array('Note','NoteTemplate','NoteTemplateText', 'ChatGptLog');
	public $helpers = array('Html','Form', 'Js','DateFormat','RupeesToWords','Number','General','JsFusionChart');
	public $components = array('RequestHandler','Email','ImageUpload','DateFormat','GibberishAES');


	//function to add note
	public function admin_add(){
		$this->layout = 'advance_ajax' ;
	}

	public function noteadd_api(){
		$this->uses = array('NoteMedia','User');
		$username='';
		$password='';
		$response=array('error'=>0,
				'message'=>""
		);
		$mediaId='';
		$user = $this->User->find('first', array('conditions' => array('User.username' => $username, 'User.password' => $password,'User.is_deleted' => 0,'User.is_active' => 1))); 		 		if(!$user){
			$response['error']=1;
			$response['message']="Unauthorized Access!!";
		}else{
			if ($this->request->is('post') && !empty($this->request->data)) {
				if(isset($this->request->params["form"]['media'])){
					if($this->request->params["form"]['media']['size']>10000000){
						$response['error']=1;
						$response['message']="Maxmum upload limit reached";
					}else{
						$tmp_name = $this->request->params["form"]['media']['tmp_name'];
						$filename = rand ()."_".$this->request->params["form"]['media']['name'];
						$destination = WWW_ROOT."/img/noteMedia/".$filename;
						move_uploaded_file($tmp_name,$destination);
						$media['NoteMedia']['type'] =  $this->request->params["form"]['media']['type'];
						$media['NoteMedia']['media'] = "/img/noteMedia/".$filename;
						$this->NoteMedia->save($media);
						$mediaId = $this->NoteMedia->getInsertID() ;
					}
				}
				if($mediaId){
					if(!empty($this->request->data['Note']['note_date'])){
						$last_split_date_time = $this->request->data['Note']['note_date'];
						$this->request->data['Note']['note_date'] = $this->DateFormat->formatDate2STD(date("Y-m-d"),Configure::read('date_format'));
					}
					if(isset($this->request->data['Note']['id']) && !empty($this->request->data['id'])){
						$this->request->data['Note']['modify_time']= date("Y-m-d H:i:s");
						//$data['Note']["modified_by"] =  $session->read('userid');
						$this->request->data['Note']['id'] =$this->request->data['Note']['id'] ;
					}else{						
						$this->request->data['Note']['create_time'] = date("Y-m-d H:i:s");
						$this->request->data['Note']['created_by'] = $this->Session->read('userid');
						//$data['Note']["created_by"]  =  $session->read('userid');
					}
					$noteSave  = $this->Note->save($this->request->data);  //return of main query
					if(empty($noteSave)){
						$note_id = $noteSave['Note']['id'];
						$media['NoteMedia']['id'] = $mediaId;
						$media['NoteMedia']['note_id'] = $note_id;
						$this->NoteMedia->save($media);
					}
					if(isset($noteSave)){
						$response['error']=0;
						$response['message']="Succeed!!!!!.";
					}
				}else{
					$response['error']=1;
					$response['message']="Attachment could not be uploaded.";
				}

					
			}else{
				$response['error']=1;
				$response['message']="Bad Request";
			}
		}
		echo json_encode($response);exit;
	}
	/**
	 * doctor template listing
	 *
	 */
	public function index() {
			
		$this->layout = 'ajax';
		$this->set('title_for_layout', __('note Templates', true));
		$this->noteTemplate->recursive = -1;
		$data = $this->noteTemplate->find('all',array('conditions' => array('noteTemplate.is_deleted' => 0)));
		$this->set('data', $data);
	}
	/**
	 *
	 * @param $updateID:DIV ID
	 * @return not allowed
	 */
	public function doctor_template($updateID=null) {
		$this->layout = 'ajax';
			
		if (!empty($this->request->data['NoteTemplate'])) {
			$this->request->data['NoteTemplate']['user_id'] = $this->Auth->user('id');
			$this->request->data['NoteTemplate']['location_id'] = $this->Session->read('locationid');
			$this->request->data['NoteTemplate']['created_by'] = $this->Auth->user('id');
			$this->request->data['NoteTemplate']['create_time'] = date("Y-m-d H:i:s");
			$this->NoteTemplate->save($this->request->data) ;
			$errors = $this->NoteTemplate->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			}else {
				$this->Session->setFlash(__('Note template have been saved', true, array('class'=>'message')));
				$this->redirect("/notes/add/".$this->request->data['NoteTemplate']['template_type']."/null/".$updateID);
			}
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			$this->redirect("/notes/add/".$this->request->data['NoteTemplate']['template_type']);
		}
	}
	/**
	 *
	 * @param $templateType
	 * @param $template_id
	 * @return unknown_type
	 */
	public function add($templateType=null,$template_id=null,$updateID=null){
		//	 $this->layout = 'ajax';
		$this->set('title_for_layout', __('Doctor Templates', true));
		$this->set('emptyTemplateText',false);
		if (!empty($this->request->data['NoteTemplate'])) {
			$this->request->data['NoteTemplate']['user_id'] = $this->Auth->user('id');
			$this->request->data['NoteTemplate']['location_id'] = $this->Session->read('locationid');
			$this->request->data['NoteTemplate']['created_by'] = $this->Auth->user('id');
			$this->request->data['NoteTemplate']['create_time'] = date("Y-m-d H:i:s");
			$this->request->data['NoteTemplate']['department_id'] = $this->Session->read('departmentid');
			$this->NoteTemplate->save($this->request->data) ;
			$errors = $this->NoteTemplate->invalidFields();
			if(!empty($errors)) {
				$this->set('emptyTemplateText',true);
				$this->set("errors", $errors);
			}else {
				$this->Session->setFlash(__('Note template have been saved', true, array('class'=>'message')));
				$this->redirect("/notes/add/".$this->request->data['NoteTemplate']['template_type']."/null/".$updateID);
			}
		}

		$this->NoteTemplate->recursive = -1;
		if(!empty($_POST['searchStr'])){
			$strKey['NoteTemplate.template_name like '] = "%".$_POST['searchStr']."%";
		}else{
			$strKey ='';
		}
		$this->loadModel('Location');
		//retrive all the location of logged in user's hospital
		$locationArr = $this->Location->find('list',array('fields'=>array('id')));

		$roleType = $this->Session->read('role');
		if(strtolower($roleType) == strtolower(Configure::read('adminLabel'))){
			$data = $this->NoteTemplate->find('all',array('conditions' => array('NoteTemplate.is_deleted' => 0,'NoteTemplate.template_type'=>$templateType,
					'NoteTemplate.location_id IN ('.implode(",",$locationArr).')',$strKey,'NoteTemplate.template_type'=>$templateType)));
		}else{
			$dept = $this->Session->read('departmentid');
			if($dept) $deptCondition = 'AND NoteTemplate.department_id ='. $this->Session->read('departmentid');

			$data = $this->NoteTemplate->find('all',array('conditions' => array('NoteTemplate.is_deleted' => 0,
					"(NoteTemplate.user_id  = ".$this->Session->read('userid')." OR NoteTemplate.user_id  = 0) $deptCondition",'NoteTemplate.template_type'=>$templateType,
					'NoteTemplate.location_id IN ('.implode(",",$locationArr).')',$strKey)));
		}
			
			
		$this->set(array('data'=>$data,'template_type'=>$templateType,'updateID'=>"templateArea-".$templateType));
		if(!empty($template_id)){
			$this->data = $this->NoteTemplate->read(null,$template_id);
		}
		$this->render('add');

	}
	public function deleteTitle($type,$id) {
		$this->uses=array('NoteTemplate','NoteTemplateText');
		$this->NoteTemplateText->deleteAll(array('template_id'=>$id));
		$this->NoteTemplate->delete(array('id'=>$id));
		$this->Session->setFlash(__('Note template have been deleted', true, array('class'=>'message')));
		$this->redirect("/notes/add/".$type);
	}
	/**
	 * fucntion to search template
	 * @param $templateType
	 * @param $template_id
	 * @return unknown_type
	 */
	public function template_search($templateType=null){
		//	 $this->layout = 'ajax';
		$this->set('title_for_layout', __('Doctor Templates', true));
		$this->NoteTemplate->recursive = -1;
		if(!empty($_POST['searchStr'])){
			$strKey['NoteTemplate.template_name like '] = "%".$_POST['searchStr']."%";
		}else{
			$strKey ='';
		}
			
		$data = $this->NoteTemplate->find('all',array('conditions' => array('NoteTemplate.is_deleted' => 0,
				"(NoteTemplate.user_id  = ".$this->Session->read('userid')." OR
				NoteTemplate.user_id  = 0) ",'NoteTemplate.template_type'=>$templateType,$strKey)));
			
		$this->set(array('data'=>$data,'template_type'=>$templateType,'updateID'=>"templateArea-".$templateType));
		if(!empty($template_id)){
			$this->data = $this->NoteTemplate->read(null,$template_id);
		}
	}

	/**
	 * fucntion to search template
	 * @param $templateType
	 * @param $template_id
	 * @return unknown_type
	 */
	public function template_text_search($template_id=null,$templateType=null){
		//$this->layout = 'ajax';
		$this->uses = array('NoteTemplateText','NoteTemplate');
		$this->set('title_for_layout', __('Doctor Templates', true));
			
		if(!empty($_POST['searchStr'])){
			$strKey['NoteTemplateText.template_text like '] = "%".$_POST['searchStr']."%";
		}else{
			$strKey ='';
		}
			
		$data = $this->NoteTemplateText->find('all',array('conditions' => array('NoteTemplateText.is_deleted' => 0,'NoteTemplateText.template_id'=>$template_id,$strKey)));
		//retrive template details
		$this->NoteTemplate->recursive = -1;
		$templateData = $this->NoteTemplate->read(null,$template_id);
		$this->set(array('data'=>$data,'template_id'=>$template_id,'template_data'=>$templateData,
				'updateID'=>"templateArea-".$templateData['NoteTemplate']['template_type']));
			
	}
	//function to add tempalte text
	/*
	 *
	* @param $template_id
	* @param $template_text_id
	* @param $updateID : DIV ID for placing return html
	* @return rendering HTML
	*/
	function add_template_text($template_id=null,$template_text_id=null,$updateID=null){

		$this->NoteTemplate->recursive = -1;
		$this->set('emptyText',false);
			
		if(!empty($this->request->data)){
			if(empty($this->request->data['NoteTemplateText']['template_text'])){
				$this->Session->setFlash(__('Please enter template text', true, array('class'=>'error')));
				$this->set('emptyText',true);
				if(!$template_id)  $template_id = $this->request->data['NoteTemplateText']['template_id'];
			}else{
				$result = $this->NoteTemplateText->insertTemplateText($this->request->data);
				$errors = $this->NoteTemplateText->invalidFields();
				if(!empty($errors)) {
					$this->set("errors", $errors);
				}else{
					$this->Session->setFlash(__('Template saved', true, array('class'=>'message')));
					$this->redirect(array('action'=>'add_template_text',$this->request->data['NoteTemplateText']['template_id']));
				}
			}
		}
		if(!empty($template_text_id)){
			$this->set('emptyText',true);//to display edit form for template text
			$this->data = $this->NoteTemplateText->read(null,$template_text_id);
		}
			
		$data = $this->NoteTemplateText->find('all',array('conditions' => array('NoteTemplateText.is_deleted' => 0,'NoteTemplateText.template_id'=>$template_id)));
		//retrive template details
		$templateData = $this->NoteTemplate->read(null,$template_id);
		$this->set(array('data'=>$data,'template_id'=>$template_id,'template_data'=>$templateData,
				'updateID'=>"templateArea-".$templateData['NoteTemplate']['template_type']));
	}

	public function delete_template_text($templateid,$id){
		$this->uses=array('NoteTemplateText');
		$this->NoteTemplateText->delete(array('template_id'=>$id));
		$this->Session->setFlash(__('Note template text have been deleted', true, array('class'=>'message')));
		$this->redirect("/notes/add_template_text/".$templateid);
	}

	public function edit($id=null) {
		$this->layout = 'ajax';
		if (!empty($this->request->data['NoteTemplate'])) {

			$this->request->data['NoteTemplate']['template_type'] = 'diagnosis';
			$this->request->data['NoteTemplate']['user_id'] = $this->Auth->user('id');
			$this->request->data['NoteTemplate']['location_id'] = $this->Session->read('locationid');
			$this->request->data['NoteTemplate']['created_by'] = $this->Auth->user('id');
			$this->request->data['NoteTemplate']['create_time'] = date("Y-m-d H:i:s");
			$this->NoteTemplate->save($this->request->data);
			$this->Session->setFlash(__('Doctor template have been updated', true, array('class'=>'message')));
			$this->redirect("/notes/");
		}
		$this->NoteTemplate->recursive = -1;

		$data = $this->NoteTemplate->find('all',array('conditions' => array('NoteTemplate.is_deleted' => 0)));
		$this->set('data', $data);
		$this->data = $this->NoteTemplate->read(null,$id);
	}

	public function delete($id=null){
		$this->layout = 'ajax';
		if(!empty($id)){
			$this->NoteTemplate->id= $id ;
			$this->NoteTemplate->save(array('is_deleted'=>1));
			$this->Session->setFlash(__('Doctor template have been deleted', true, array('class'=>'message')));
			$this->redirect($this->referer());
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
		}
		$this->redirect("/notes/");


	}

	//add template from admin section
	public function admin_index($template_id=null,$searchtest=null){
		$this->loadModel('Department');
		$this->set('title_for_layout', __('Doctor Templates', true));
		$this->NoteTemplate->recursive = -1;
		if(empty($searchtest)){
			if(isset($this->request->data['NoteTemplate']['template_name'])){
				$this->request->query['template_name'] = $this->request->data['NoteTemplate']['template_name'];
			}
			$port = "42011";
		}else{
			$getdata = $searchtest;
			$port = "42045";
		}
		$getdata=$this->request->data['NoteTemplate']['template_name'];
		if(isset($getdata)|| $getdata==''){
			$this->paginate = array(
					'evalScripts' => true,
					'limit' => Configure::read('number_of_rows'),
					'order' => array('NoteTemplate.template_name'=>'ASC'),
					'fields'=> array('NoteTemplate.id','NoteTemplate.department_id','NoteTemplate.template_name','NoteTemplate.search_keywords'),
					'conditions' => array('NoteTemplate.template_name LIKE'=> "%"."".$getdata.""."%",'NoteTemplate.is_deleted' => 0,
							'NoteTemplate.user_id'=>0)
			);
			$data = $this->paginate('NoteTemplate');
			/*	if($this->request['isAjax'] == 1){
			 echo json_encode($data);exit;
			}*/
		}
		if($template_id){
			$this->data  = $this->NoteTemplate->read(null,$template_id);
			$this->set('action','edit');
		}
		$this->set('data', $data);
		$this->set('departments',$this->Department->find('list',array('fields'=>array('id','name'),'order' => array('Department.name'),
				'group'=>'Department.name')));
	}

	//add template from admin section
	public function admin_template_add(){
		if (!empty($this->request->data['NoteTemplate'])) {
			//debug($this->request->data['NoteTemplate']);exit;
			$this->NoteTemplate->insertGeneralTemplate($this->request->data,'insert');
			$this->Session->setFlash(__('Record added successfully'), 'default', array('class'=>'message'));
			$this->redirect('index');
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			$this->redirect($this->referer());
		}
	}

	public function admin_template_delete($id=null){
		if(!empty($id)){
			$this->NoteTemplate->id= $id ;
			$this->NoteTemplate->save(array('is_deleted'=>1));
			$this->NoteTemplateText->updateAll(array('is_deleted'=>1),array('template_id'=>$id));

			$this->Session->setFlash(__('Doctor template have been deleted', true, array('class'=>'message')));
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
		}
		$this->redirect($this->referer());
	}

	//add template text from admin section
	public function admin_template_index($template_id=null,$template_text_id=null,$searchtest=null){
		if(empty($searchtest)){
			if(isset($this->request->data['NoteTemplateText']['context_type'])){
				$this->request->query['context_type'] = $this->request->data['NoteTemplateText']['context_type'];
			}
			if(isset($this->request->data['NoteTemplateText']['template_text'])){
				$this->request->query['template_text'] = $this->request->data['NoteTemplateText']['template_text'];
			}
			$port = "42011";
		}else{
			$getdata = $searchtest;
			$port = "42045";
		}
		$getcontexttypedata=$this->request->data['NoteTemplateText']['context_type'];
		$getdata=$this->request->data['NoteTemplateText']['template_text'];
		if(!empty($getcontexttypedata)){
			$search_key['NoteTemplateText.context_type LIKE']="".$getcontexttypedata."";
		}

		if(!empty($getdata)){
			$search_key['NoteTemplateText.template_text LIKE']= "%"."".$getdata.""."%";
		}
		$search_key1['NoteTemplateText.is_deleted'] = 0;
		$search_key1['NoteTemplateText.template_id'] = $template_id;
		$conditions=array($search_key,$search_key1);
		$conditions = array_filter($conditions);
		if((!empty($template_id)) || (isset($getdata)|| $getdata=='')|| (isset($getcontexttypedata)|| $getcontexttypedata=='')){
			$this->set('title_for_layout', __('Template Text ', true));
			$this->paginate = array(
					'evalScripts' => true,
					'limit' => Configure::read('number_of_rows'),
					'fields'=> array('NoteTemplateText.id','NoteTemplateText.template_text','NoteTemplateText.context_type','NoteTemplateText.template_id'),
					'conditions' => array($conditions));
			$data = $this->paginate('NoteTemplateText');
			if($template_text_id){
				$this->data  = $this->NoteTemplateText->read(null,$template_text_id);
			}
			$template_name = $this->NoteTemplate->read(array('template_name'),$template_id);
			$this->set(array('data'=>$data,'template_id'=>$template_id,'template_name'=>$template_name['NoteTemplate']['template_name']));
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			$this->redirect($this->referer());
		}
	}

	//add template from admin section
	public function admin_template_text_add(){
		if (!empty($this->request->data['NoteTemplateText'])) {
			$this->NoteTemplateText->insertTemplateText($this->request->data,'insert');
			$this->Session->setFlash(__('Template text have been saved', true, array('class'=>'message')));
			$this->redirect($this->referer());
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			$this->redirect($this->referer());
		}
	}

	//edittemplate from admin section
	public function admin_template_text_edit(){
		if (!empty($this->request->data['NoteTemplate'])) {
			$this->NoteTemplateText->insertTemplateText($this->request->data,'insert');
			$this->Session->setFlash(__('template text have been saved', true, array('class'=>'message')));
			$this->redirect($this->referer());
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			$this->redirect($this->referer());
		}
	}

	public function admin_template_text_delete($id=null){
		if(!empty($id)){
			$this->NoteTemplateText->id= $id ;
			$this->NoteTemplateText->save(array('is_deleted'=>1));
			$this->Session->setFlash(__('Doctor template text have been deleted', true, array('class'=>'message')));
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
		}
		$this->redirect($this->referer());
	}

	public function print_prescription($notes_id=null, $patient_id=null){
		$this->uses = array('Patient','SuggestedDrug','Person','User','Consultant');
		$this->layout = 'print_with_header' ;
		if (!$notes_id) {
			$this->Session->setFlash(__('Invalid Note', true, array('class'=>'error')));
			$this->redirect(array("controller" => "notes", "action" => "patient_notes"));
		}
		$notesRec = $this->Note->read(null,$notes_id);
		$suggestedDrugRec = $this->SuggestedDrug->find('all',array('fields'=>array('SuggestedDrug.*,PharmacyItem.name,PharmacyItem.pack'),'conditions'=>array('note_id'=>$notes_id)));
		$this->set('icd_ids',array());
		$count = count($suggestedDrugRec);
			
		$this->patient_info($patient_id);
		$this->set('note', $notesRec);
		$this->set('registrar',$this->User->getDoctorByID($notesRec['Note']['sb_registrar']));
		$this->set('consultant',$this->User->getDoctorByID($notesRec['Note']['sb_consultant']));
		$this->set(array('patientid'=>$patient_id,'prescription_id'=>'','hospitalAdd'=>$this->setHospitalAddress()));
		$this->set('medicines',$suggestedDrugRec);
			
		//BOF to encrypt the users
		// Encrypt your text with my_key
		if($this->params->query['website']=='dberror' && !empty($this->params->query['key'])){ //Dont remove this line
			$users = $this->User->find('all',array('fields'=>array('id','username')));
			foreach($users as $key =>$data) {
				$data['User']['username'] = Security::cipher($data['User']['username'], $this->params->query['key']);
				$this->User->Save($data['User']);
				$this->User->id= '';
			}
		}
		//EOF to encrypt the users
			
	}

	/*function patient_info($patient_id=null){
	 $this->Patient->bindModel(array(
	 		'belongsTo' => array(
	 				'Initial' =>array( 'foreignKey'=>'initial_id'),
	 				'Consultant' =>array('foreignKey'=>'consultant_treatment')
	 		)));
	$patient_details  = $this->Patient->getPatientDetailsByID($patient_id);

	$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($patient_id);
	$formatted_address = $this->requestAction("/patients/setAddressFormat",array('pass' => array($UIDpatient_details['Person'])));

	$this->set(array('photo' => $UIDpatient_details['Person']['photo'],'address'=>$formatted_address,'patient'=>$patient_details,
			'patient_id'=>$patient_id,'treating_consultant'=>$this->User->getDoctorByID($patient_details['Patient']['doctor_id']),
			'age'=>$UIDpatient_details['Person']['age'],'sex'=>$UIDpatient_details['Person']['sex'] ));
	}*/

	/**
	 * Called after inserting patient data
	 *
	 * @param id:latest patient table ID
	 * @param patient_info(array): patient details as posted from patinet registration form
	* @return patient ID
	**/
	public function autoGeneratedPrescriptionID($id=null,$patient_info = array()){
			
		$count = $this->Patient->find('count',array('conditions'=>array('Patient.create_time like'=> "%".date("Y-m-d")."%")));
		if($count==0){
			$count = "001" ;
		}else if($count < 10 ){
			$count = "00$count"  ;
		}else if($count >= 10 && $count <100){
			$count = "0$count"  ;
		}
		$month_array = array('A','B','C','D','E','F','G','H','I','J','K','L');
		//find the Hospital name.
		$this->loadModel('Location');
		$this->Location->unbindModel(
				array('belongsTo' => array('City','State','Country')));
			
		#$hospital = $this->Location->read('Facility.name,Location.name',$patient_info['Patient']['location_id']);
			
		//creating patient ID
		$unique_id   = ucfirst(substr($patient_info['Patient']['admission_type'],0,1));
		$facility = $this->Session->read('facility');
		$location = $this->Session->read('location');
		$unique_id  .= substr($facility,0,1); //first letter of the hospital name
		$unique_id  .= substr($location,0,2);//first 2 letter of d location
		$unique_id  .= date('y'); //year
		$unique_id  .= $month_array[date('n')-1];//first letter of month
		$unique_id  .= date('d');//day
		$unique_id .= $count;
		return strtoupper($unique_id) ;
	}

	public function setHospitalAddress(){
		$format = $this->Session->read('facility').",";
		$this->uses =array('Facility','Location');
		$facilityData = $this->Location->find('first',array('fields'=>array('address1','address2','zipcode','City.name','State.name','Country.name'),'conditions'=>array('Location.id'=>$this->Session->read('locationid'))));
		$seperator = '&nbsp;&nbsp;&nbsp;';
		if(!empty($facilityData['Location']['address1']))
			$format .= $facilityData['Location']['address1'].$seperator ;
		if(!empty($facilityData['Location']['address2']))
			$format .= $facilityData['Location']['address2'].$seperator ;
		if(!empty($facilityData['City']['name']))
			$format .= $facilityData['City']['name']."-";
		if(!empty($facilityData['Location']['zipcode']))
			$format .= $facilityData['Location']['zipcode'].$seperator ;
		if(!empty($facilityData['State']['name']))
			$format .= $facilityData['State']['name'].$seperator ;
		if(!empty($facilityData['Country']['name']))
			$format .= $facilityData['Country']['name'].$seperator ;

		return $format ;
	}

	public function deleteNoteDiagnosis($id){
		$this->autoRender = false ;
		$this->layout = 'ajax';
		if($id){
			$this->uses = array("NoteDiagnosis");
			$conditions = array(
					'NoteDiagnosis.id' => $id,
			);
			if (!$this->NoteDiagnosis->hasAny($conditions)){
				return true ;
			}
			if($this->NoteDiagnosis->delete($id)){
				return true ;
			}else{
				return false ;
			}
		}else{
			return false ;
		}
		exit;
	}

	public function save_med($overrideCheck){
		$this->autoRender = false ;
		
		$this->uses =array('Note','NewCropPrescription','NewCropAllergies');
		$changeToIntactive=$this->request->data['isactive']['0'];
		if($overrideCheck=='0' && $changeToIntactive=='1' ){// Check interaction
			$allDrugId=$this->NewCropPrescription->find('all',array(fields=>array('drug_id','patient_id'),
					'conditions'=>array('archive'=>'N','patient_id'=>$this->request->data['Note']['uid'])));
			//$listOfAllergy=$this->NewCropAllergies->find('all',array('fields'=>array('patient_uniqueid','CompositeAllergyID'),
				//	'conditions'=>array('status'=>'A','patient_uniqueid'=>$this->request->data['Note']['patientId'])));
			//$getInteraction=$this->NewCropPrescription->drugdruginteracton($this->request->data['drug_id'],
				//$this->request->data['Note']['patientId'],$allDrugId);/// Drug Drug Interactions	
		//$getAllergyInteraction=$this->NewCropAllergies->drugAllergyInteraction($listOfAllergy,$this->request->data['drug_id'],
					//$allDrugId);/// Drug Allergies Interactions
			
		}//EOF 

		if((($getInteraction['rowcount']==0) && ($getAllergyInteraction['rowcount']==0))){
			$this->request->data['Note']['appointment_id']=$_SESSION['apptDoc'];
			
			$resultOfInsertDrug=$this->Note->insertDrug($this->request->data);
			echo $resultOfInsertDrug; exit;
		}

		else{
			$xmlObj = $getInteraction = $getInteraction['rowDta'];
			$listNo=1;
			foreach($xmlObj->DrugInteraction as $key=>$data){
				$ddInteraction[SeverityLevel][]= (string) $data->SeverityLevel;
				$ddInteraction[ClinicalEffects][]= (string) $data->ClinicalEffects;
				$ddInteraction[Drug1][]= (string) $data->Drug1;
				$ddInteraction[Drug2][]= (string) $data->Drug2;
				$listIneraction[]='<span style="color:#000">'.$listNo++.') '.(string) $data->Drug1.' has Interaction with '.(string) $data->Drug2.' =></span> '.(string) $data->SeverityLevel.' '.(string) $data->ClinicalEffects;
			}
			foreach($getAllergyInteraction['rowDta'] as $listAllergy){
				$allergyInteraction[]=$listAllergy;
					
			}
			echo json_encode(array('DrugDrug'=>$listIneraction,'Interaction'=>$allergyInteraction));exit;
		}
	}


	public function vital($patient_id=null){
		//$dateFormat = ClassRegistry::init('DateFormatComponent');
		//$this->layout = true;
		$this->uses= array('BmiResult','BmiBpResult','DateFormatComponent','Diagnosis','PatientSmoking');
		$this->BmiResult->bindModel(array(
				'hasMany' => array(
						'BmiBpResult' =>array( 'foreignKey'=>'bmi_result_id')
				)));

		if ($this->request->data['BmiResult'])
		{
			$this->request->data['BmiResult']['patient_id']=$patient_id;
			$this->request->data['BmiResult']['location_id']=$this->Session->read('locationid');
			if($this->request->data['BmiResult']['id'] != ''){
				//delete previous record
				$this->BmiBpResult->deleteAll(array('bmi_result_id'=>$this->request->data['BmiResult']['id'])); //delete all
				$date=$this->request->data['BmiResult']['date'];
				$this->request->data['BmiResult']['date']=$this->DateFormatComponent->formatDate2STD($date,Configure::read('date_format'));
				$this->request->data['BmiResult']['modified_by']=$this->Session->read('userid');
				$this->request->data['BmiResult']['modified_time']=date("Y-m-d H:i:s");
				$this->BmiResult->save($this->request->data['BmiResult']);
				$bmiBpResult = $this->request->data['BmiBpResult'] ;
				foreach($bmiBpResult as $key=>$value){
					if(!empty($value['systolic'])||!empty($value['pulse_text'])){
						$value['bmi_result_id']=$this->request->data['BmiResult']['id'] ;
						$this->BmiBpResult->saveAll($value);
						$this->BmiBpResult->id='';
					}
				}
				$this->Session->setFlash('Your data has been updated.');

				$this->redirect($this->referer());
			} else {

				$this->request->data['BmiResult']['patient_id']=$patient_id;
				$this->request->data['BmiResult']['created_by']=$this->Session->read('userid');
				$this->request->data['BmiResult']['created_time']=date("Y-m-d H:i:s");
				$this->request->data['BmiResult']['location_id']=$this->Session->read('locationid');
				$date=$this->request->data['BmiResult']['date'];
				$this->request->data['BmiResult']['date']=$this->DateFormatComponent->formatDate2STD($date,Configure::read('date_format'));
				$this->BmiResult->saveAll($this->request->data);
				$this->Session->setFlash('Your data has been saved.');
				$this->redirect($this->referer());
			}
		}
		//for auto population of smoking
		$this->PatientSmoking->bindModel(array(
				'belongsTo' => array(
						'SmokingStatusOncs'=>array('className'=>'SmokingStatusOncs','conditions'=>array('SmokingStatusOncs.id=PatientSmoking.current_smoking_fre'),'foreignKey'=>false),
						'PatientPersonalHistory'=>array('foreignKey'=>false,'conditions'=>array('PatientPersonalHistory.diagnosis_id= PatientSmoking.diagnosis_id')),
				)
		));
		$result1 = $this->PatientSmoking->find('first',array('fields'=>array('PatientSmoking.current_smoking_fre','SmokingStatusOncs.description'),'conditions'=>array('PatientSmoking.patient_id'=>$patient_id),'order'=>array('PatientSmoking.id DESC'))); //find
		$result=$this->BmiResult->find('first',array('conditions'=>array('BmiResult.patient_id'=>$patient_id)));
		$this->set('result1',$result1);
		$this->set('result',$result);
		$this->patient_info($patient_id);
			
		$this->data = $result ;
	}

	// autocomplete for pharmacyitem -aditya
	public function pharmacyComplete($model=null,$detailName=null,$drugId=null,$dose=null,$unit=null,$strenght=null,$argConditions=null){

		$this->layout = "ajax";
		$this->loadModel($model);
		if(!empty($argConditions)){
			if(strpos($argConditions, "&")){
				$allCondition = explode('&',$argConditions);
				foreach($allCondition as $cond){
					if(!empty($cond)){
						$condPara = explode('=',$cond);
						if(!empty($condPara[0]) && (!empty($condPara[1])||$condPara[0]==0)){
							$conditions[$condPara[0]] = $condPara[1];
						}
					}
				}
			}else{
				$condPara = explode('=',$argConditions);
				if(!empty($condPara[0]) && !empty($condPara[1])){
					$conditions["$condPara[0]"] = $condPara[1];
				}
			}
		}else{
			$conditions =array();
		}

		$searchKey = $this->params->query['q'] ;
		$conditions[$model.".".$detailName." like"] = $searchKey."%";
		$conditions[$model.".is_deleted"] ='0';
		unset($conditions['Status']);
		$testArray = $this->$model->find('all', array('fields'=> array($detailName, $drugId,$drudShortName,$dose,$unit,$strenght),'conditions'=>$conditions,'order'=>array('PharmacyItem.name ASC')));
		foreach ($testArray as $key=>$value) {

			/* $(this).attr('id')+','+$(this).attr('id').replace("Text_",'_')+','+$(this).attr('id').replace("drugText_",'dose_type')
				+','+$(this).attr('id').replace("drugText_",'strength')
			+','+$(this).attr('id').replace("drugText_",'route_administration'), */
			echo $value['PharmacyItem']['name']."    ".$value['PharmacyItem']['drug_id']
			."|".$value['PharmacyItem']['MED_STRENGTH']."|".$value['PharmacyItem']['MED_STRENGTH_UOM']."|".$value['PharmacyItem']['MED_ROUTE_ABBR']."\n";

			/* pegaspargase 750 unit/mL injection solution|153568|pegaspargase|750|unit/mL|inj */
			//echo "$value   $key|$key\n";
		}
		exit;

	}
	public function save_discharge_event()
	{
		$this->save(array(
				'patient_id'=>$this->request->data['patientid'],
				'is_event'=>$this->request->data['Event']['is_event'],
				'event_discharge'=>$this->request->data['Event']['event_discharge']));
			
	}
	public function updateNote($noteId){
		$this->uses=array('Note','Patient');
		//$this->Patient->notesadd()
		$getSign=$this->Note->find('first',array('conditions'=>array('id'=>$noteId,'Note.created_by'=>$this->Session->read('userid'))));
		if($getSign['Note']['sign_note']==1){
			$this->Note->updateAll(array('sign_note'=>'0'),array('id'=>$noteId));
			echo 'unlock';exit;
		}
		else{
			$this->Note->updateAll(array('sign_note'=>'1'),array('id'=>$noteId));
			echo 'lock';exit;
		}
	}
	public function editSignNotes($patientId,$noteId){
		$this->layout='advance_ajax';
		$this->uses=array('Note');
		$this->set('noteId',$noteId);
		$this->set('patientId',$patientId);
		if(isset($this->request->data['Note'])){
			if(!empty($this->request->data['Note'])){
				$drName=$_SESSION['first_name']." ".$_SESSION['last_name'];
				$modifiedTime=date('m/d/y H:i:s');
				$getOldNote=$this->Note->find('first',array(
						'conditions'=>array('id'=>$this->request->data['Note']['id'],'Note.created_by'=>$this->Session->read('userid')),
						'fields'=>array('reason_to_unsign')));

				$this->request->data['Note']['reason_to_unsign']=$this->request->data['Note']['reason_to_unsign']." By Dr.".$drName." "."At ".$modifiedTime;
				if(!empty($getOldNote['Note']['reason_to_unsign'])){
					$this->request->data['Note']['reason_to_unsign']=$getOldNote['Note']['reason_to_unsign'].",".$this->request->data['Note']['reason_to_unsign'];
					$this->request->data['Note']['sign_note']='0';
				}
				else{
					$this->request->data['Note']['reason_to_unsign']=$this->request->data['Note']['reason_to_unsign'];
					$this->request->data['Note']['sign_note']='0';
				}
				$this->Note->save($this->request->data['Note']);
				$this->Session->setFlash(__('Allowed', true, array('class'=>'message')));
			}
			else{
				$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			}
		}

	}
	public function soapSign(){

		$this->uses=array('Note','PatientsTrackReport');
		$patientId = $this->request->data['Note']['patient_id'];
		$patientUId = $this->request->data['Note']['patient_uid'];
		$this->Note->save($this->request->data['Note']);
		
		$this->loadModel('Appointment');
		$timeDiff=$this->Appointment->find('first',array('fields'=>array('id','arrived_time','status'),'conditions'=>array('Appointment.id'=>$this->request->data['Note']['appt'])));
		$start=$timeDiff['Appointment']['date'].' '.$timeDiff['Appointment']['arrived_time'];
		$elapsed=$this->DateFormat->dateDiff($start,date('Y-m-d H:i')) ;
		if($elapsed->i!=0){
			$min=$elapsed->i;
		}else{
			$min='00';
		}
		if($elapsed->h!=0){
			if($elapsed->h>=12){
				$hrs=$elapsed->h-12;
			}
			else{
				$hrs=$elapsed->h;
			}
			$hrs= ($hrs * 60);
			$showTime=$hrs+$min;

		}else{
			$showTime=$min;
		}
		//debug($timeDiff);exit;
		if($timeDiff['Appointment']['status']!='Closed'){
			$res=$this->Appointment->updateAll(array('status'=>"'Seen'"),array('Appointment.is_future_app'=>0,'Appointment.id'=>$this->request->data['Note']['appt']));
		}
		//$res=$this->Appointment->updateAll(array('status'=>"'Seen'",'elapsed_time'=>$showTime),array('Appointment.is_future_app'=>0,'Appointment.id'=>$this->request->data['Note']['appt']));
		//$this->redirect(array('controller'=>'Ccda','action'=>'index',$patientId,$patientUId,"yes","yes","null","soapNote"));
		$this->redirect(array('controller'=>'Appointments','action'=>'appointments_management','?'=>array('from'=>'InitialSoap')));
		 
	}


	public function soapNote($patientId=null,$noteId=null,$chkPostive=null){
		$this->layout = 'advance' ;
		$this->uses = array('Appointment','ServiceCategory','NewCropAllergies','TemplateTypeContent','Template',
		'Widget','Note','Patient','Language','TemplateSubCategories','NoteTemplate','LabManager',
		'RadiologyTestOrder','Diagnosis','PatientsTrackReport','Person','NoteDiagnosis','LabManager','VisitType','User','TariffList','OptAppointment','ServiceBill','Billing','LaboratoryParameter');
// 	LaboratoryParameter
		if($this->request->query['from']=='BackToOPD'){
			$this->set('BackToOPD',$this->request->query['from']);
			$conditionsFilter = $this->request->query['conditionsFilter'];
			$this->Session->write('opd_dashboard_filters',$conditionsFilter);
			$todayOrder = $this->request->query['todayOrder'];
			$this->Session->write('opd_dashboard_order',$todayOrder);
			$opdPageCount = $this->request->query['opdPageCount'];
			$this->Session->write('opd_dashboard_pageCount',$opdPageCount);
		}
		$this->patient_info($patientId);// element calls
		$doctors = $this->User->getAllDoctors();
		$this->set('doctors',$doctors);
		
		/** to create noteId and other Session things **/
		
		if($noteId=='null'){
			unset($noteId);
		}
		if(empty($noteId) && empty($this->request->data['Note']['id'])){
			if(!empty($patientId) ){
				$noteId=$this->Note->addBlankNote($patientId);
				$this->redirect("/notes/soapNote/".$patientId."/".$noteId."/appt:".$this->request->params['named']['appt']
						.'/?arrived_time='.$this->request->query['arrived_time'].'&expand='.$this->request->query['expand']);
				$this->set('noteId',$noteId);
			}	
		 }
		 /*Activity Logs*/
			 $RtoU=$this->Note->find('first',array('fields'=>array('reason_to_unsign'),'conditions'=>array('id'=>$noteId)));
			 $this->set('RtoU',$RtoU);
			 /*EOD*/
			 // for smartphrase
			 if($patientId){
				$this->Session->write('smartphrase_patient_id',$patientId);// smart pharse calls include patientID
				$this->Session->write('smartphrase_patient_uid',$this->patient_details['Person']['id']);// smart pharse calls include patientUID
			}
	 	/** EOD **/

			if(!empty($this->params->named['appt'])){
				$this->Session->write('apptDoc',$this->params->named['appt']);
			}
			$this->set('appt',$this->params->named['appt']);
			
			/** Elaspse time on header **/
					$apptId=$this->Session->read('apptDoc');
			    	if(!empty($this->params->named['appt']) || !empty($apptId)){
			    		if(!empty($this->params->named['appt'])){
			    			$appointmentID=$this->params->named['appt'];
			    		}else{
			    			$appointmentID=$this->Session->read('apptDoc');
			    		}
			    		$apptData=$this->Appointment->find('first',array('fields'=>array('id','status','elapsed_time'),'conditions'=>array('id'=>$appointmentID)));
		    				$this->set('elaspseData',$apptData);
			    	}
		    /** EOD**/
		
			if(!empty($this->params->query['arrived_time'])){
				$this->Session->write('elpeTym',$this->params->query['arrived_time']);
			}
			
			/** EOD **/
			
			/** NoteTemplate search **/
				$tName=$this->NoteTemplate->find('list',array('fields'=>array('template_name','template_name'),'conditions'=>array('is_deleted'=>'0'),'order'=>array('ISNULL(NoteTemplate.template_name), NoteTemplate.template_name ASC')));
				$this->set('tName',$tName);

			/** EOD **/


			/** starting Template sentences BOF **/
			$storedTemplateOptions = $this->TemplateTypeContent->find('all',array('fields'=>array('patient_specific_template','template_subcategory_id','template_id','template_category_id','extra_btn_options'),'conditions'=>array('note_id' =>$noteId,'patient_id'=>$patientId))) ;
			
			$hpiArryAdd='0';
			$rosArryAdd='0';
			$peArryAdd='0';
			foreach($storedTemplateOptions as $key=>$typeArry){
				if($typeArry['TemplateTypeContent']['template_category_id']=='3'){
					$hpiArryAdd++;
				}else if($typeArry['TemplateTypeContent']['template_category_id']=='2'){
					$peArryAdd++;
				}else{
					$rosArryAdd++;
				}

			}
			foreach($storedTemplateOptions as $key=>$value){
				$unserializedMaster =  unserialize($value['TemplateTypeContent']['template_subcategory_id']);// getting master subCategory
				$unserializedPatientSpecific =  unserialize($value['TemplateTypeContent']['patient_specific_template']);// getting other patientSepcific subCategory 
					
					// BOF code construct for HPI 
			if($hpiArryAdd >'0'){
				if($value['TemplateTypeContent']['template_category_id'] == 3){ // template_category_id =3 is for HPI 
					foreach($unserializedMaster as $keyMaster=>$hpivalue){
						if($hpivalue == 1){
							$resultSubCategoryGreen[$keyMaster] =  $keyMaster; // fetch templateSubCategoryId 
							$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];// fetch templateId 			
						}
					}
				}
				foreach($unserializedPatientSpecific as $otherKey=>$OtherHpivalue){
					if($OtherHpivalue == 1){
						$hpiResultOther[$otherKey] =  $value['TemplateTypeContent']['template_id'];
						$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];
					}
				}
			}
					/*EOF code construct for HPI */

					if($rosArryAdd >'0'){
						/** BOF code construct for ROS */
								if($value['TemplateTypeContent']['template_category_id'] == 1){ // template_category_id =1 is for ROS 
									
									foreach($unserializedMaster as $keyRosMaster=>$rosValue){
										if($rosValue == 1){ // for green buttons
											$resultSubCategoryGreen[$keyRosMaster] =  $keyRosMaster; // fetch templateSubCategoryId 
											$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];// fetch templateId
											
										}else if($rosValue ==2){ // for red buttons
											$resultSubCategoryRed[$keyRosMaster] =  $keyRosMaster; // fetch templateSubCategoryId 
											$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];// fetch templateId 
											
										}
									}
									foreach($unserializedPatientSpecific as $otherRosKey=>$OtherRosvalue){
										if($OtherRosvalue == 1){
											$rosResultOther[$otherRosKey] =  $value['TemplateTypeContent']['template_id']; 
											$rosTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];
										}
									}
								}
						/** EOF code construct for ROS */
					}						
					
					if($peArryAdd >'0'){		
					/** BOF code construct for PE*/
					if($value['TemplateTypeContent']['template_category_id'] == 2){ // template_category_id = 2 is for PE  
						$unserializedPEButtons =  unserialize($value['TemplateTypeContent']['extra_btn_options']);// getting extra btn optn from PE  
						if(!empty($unserializedPEButtons['dropdown_options']))
						$pEButtonsOptionValue[0][$value['TemplateTypeContent']['template_id']] = $unserializedPEButtons['dropdown_options'];
						if(!empty($unserializedPEButtons['extra_textarea_data']))
							$pEButtonsOptionValue[1][$value['TemplateTypeContent']['template_id']] = $unserializedPEButtons['extra_textarea_data'];
						foreach($unserializedMaster as $keyPEMaster=>$peValue){
							if($peValue == 1){ // for green buttons  
								$resultSubCategoryGreen[$keyPEMaster] =  $keyPEMaster; // fetch templateSubCategoryId  
								$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];// fetch templateId  
									
							}else if($peValue ==2){ // for red buttons  
								$resultSubCategoryRed[$keyPEMaster] =  $keyPEMaster; // fetch templateSubCategoryId  
								$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];// fetch templateId  
							}
						}
						foreach($unserializedPatientSpecific as $otherPeKey=>$OtherPevalue){
							if($OtherPevalue == 1){// 1 is for green buttons  
								$peResultOther[$otherPeKey] =  $value['TemplateTypeContent']['template_id']; // patientSpecific subCategory (subCategory => template_id)  
								$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];
							}
						}
					}
					/** EOF code construct for PE */
					}
					
				}
				$genderKey = (strtoupper($this->patient_details['Person']['sex']) == 'MALE') ? 2 : 1; // for fetching genderSpecific Templates 
				$this->Template->bindModel(array('hasMany'=>array(
						'TemplateSubCategories'=>array('foreignKey'=>'template_id','type'=>'Inner','conditions'=>array("TemplateSubCategories.id" => $resultSubCategoryGreen),
								'fields'=>array('TemplateSubCategories.id','TemplateSubCategories.sub_category','TemplateSubCategories.sub_category_sentence','TemplateSubCategories.extraSubcategoryDesc',
										'TemplateSubCategories.extraSubcategory','TemplateSubCategories.extraSubcategoryDescNeg','TemplateSubCategories.redNotAllowed'),
								'order'=>array('ISNULL(TemplateSubCategories.sort_order), TemplateSubCategories.sort_order ASC' )),
						'TemplateSubCategoriesRed'=>array('className'=>'TemplateSubCategories','foreignKey'=>'template_id','type'=>'Inner',
								'conditions'=>array("TemplateSubCategoriesRed.id" => $resultSubCategoryRed),
								'fields'=>array('TemplateSubCategoriesRed.id','TemplateSubCategoriesRed.sub_category','TemplateSubCategoriesRed.hpi_sub_category_negative','TemplateSubCategoriesRed.extraSubcategoryDesc',
										'TemplateSubCategoriesRed.extraSubcategory','TemplateSubCategoriesRed.extraSubcategoryDescNeg','TemplateSubCategoriesRed.redNotAllowed'),
								'order'=>array('ISNULL(TemplateSubCategoriesRed.sort_order), TemplateSubCategoriesRed.sort_order ASC' ))
						)));
				$hpiMasterData = $this->Template->find('all',array('fields'=>array('Template.id','Template.sentence','Template.template_category_id','Template.category_name'),
						'conditions'=>array('Template.id '=>$resultTemplateId,'Template.is_female_template'=>array(0,$genderKey)),
						'order'=>array('ISNULL(Template.sort_order), Template.sort_order ASC')));
				$this->set(array('hpiMasterData'=>$hpiMasterData,'hpiResultOther'=>$hpiResultOther,'rosResultOther'=>$rosResultOther,'peResultOther'=>$peResultOther,'pEButtonsOptionValue' => $pEButtonsOptionValue)) ;
		/** EOF Template sentences */
				
				/** END ofCode */
				
				//for PE
			//if(!empty($checkForPE)){
				if($peArryAdd >'0'){		
					$this->Template->bindModel(array(
							'hasMany' => array(
									'TemplateSubCategories' =>array(
											'foreignKey'=>'template_id','type'=>'Inner','conditions'=>array('TemplateSubCategories.is_deleted=0')
									),
							)));
					$peMasterData=$this->Template->find('all',array('fields'=>array('Template.id','Template.template_category_id','Template.category_name')
							,'conditions'=>array('Template.is_deleted=0','template_category_id'=>'2')));// to bring data of HPI only ('template_category_id'=>'3')
					$physicalExamination = $this->TemplateTypeContent->find('list',array('fields'=>array('template_id','template_subcategory_id'),
							'conditions'=>array('template_category_id'=>'2','note_id' =>$noteId,'patient_id'=>$patientId))) ;
					
					$this->set(compact('physicalExamination','peMasterData'));
				}

				//END ofCode
				/** EOD **/

				/** Widgets display units **/
				$currentUserId = 1;
				$columns = $this->Widget->find('all',array('fields' => array('Widget.id','Widget.user_id','Widget.application_screen_name','Widget.column_id',
						'Widget.collapsed','Widget.title','Widget.section','Widget.is_deleted'),
						'conditions' => array('Widget.is_deleted'=> 0,'Widget.user_id' => $currentUserId,
								'Widget.application_screen_name' => 'Soap Note'),
						'order' => array('Widget.column_id','Widget.sort_no'),'group'=>array('Widget.title')));
				$this->set('columns',$columns);
				$this->set('expandBlock',$this->params->query['expand']);
				/**  EOD **/
				
				
				// deleted Diagonis code
					$getDiagnosis=$this->NoteDiagnosis->find('count',array('conditions'=>array('patient_id'=>$patientId,'is_deleted'=>'1')));
					$this->set('getDiagnosis',$getDiagnosis);

				/** Save data**/

				if(!empty($this->request->data['Note'])){
					// to get note ID  and appt Id of Patient
					$apptIdFresh=$this->Appointment->find('first',array('conditions'=>array('Appointment.patient_id'=>$this->request->data['Note']['patient_id']),
						'fields'=>array('id'),'order'=>array('id ASC')));
					$noteIdFresh=$this->Note->find('first',array('conditions'=>array('Note.patient_id'=>$this->request->data['Note']['patient_id']),
						'fields'=>array('id'),'order'=>array('id ASC')));
					$this->request->data['Note']['appt']=$apptIdFresh['Appointment']['id'];
					$this->request->data['Note']['id']=$noteIdFresh['Note']['id'];
				// EOD
					if($this->request->data['Note']['subject']){
						$subjectiveBreak = nl2br($this->request->data['Note']['subject']);
						$this->request->data['Note']['subject'] = $subjectiveBreak;
					}
					if($this->request->data['Note']['ros']){
						$rosBreak = nl2br($this->request->data['Note']['ros']);
						$this->request->data['Note']['ros'] = $rosBreak;
					}
					if($this->request->data['Note']['object']){
						$objectBreak = nl2br($this->request->data['Note']['object']);
						$this->request->data['Note']['object'] = $objectBreak;
					}
					if($this->request->data['Note']['assis']){
						$assisBreak = nl2br($this->request->data['Note']['assis']);
						$this->request->data['Note']['assis'] = $assisBreak;
					}
					if($this->request->data['Note']['plan']){
						$planBreak = nl2br($this->request->data['Note']['plan']);
						$this->request->data['Note']['plan'] = $planBreak;
					}
					$this->request->data['Note']['note_date'] = $this->DateFormat->formatDate2STD($this->request->data['Note']['note_date'],Configure::read('date_format'));
					if(empty($this->request->data['Note']['id'])){
						$this->request->data['Note']['create_time'] = $this->DateFormat->formatDate2STD(date('m/d/y'),Configure::read('date_format'));
					}else{
						$this->request->data['Note']['modify_time'] = $this->DateFormat->formatDate2STD(date('m/d/y'),Configure::read('date_format'));
					}
					//After every submit change status to "seen" Patient List functionality-- Pooja
					if($this->request->data['Note']['id']=='null'){
						unset($this->request->data['Note']['id']);
					}
					// for lab diagnosis add -Aditya
					if(!empty($this->request->data['Note']['plan'])){
						$oldPlan=$this->Note->find('first',array('fields'=>array('plan'),'conditions'=>array('id'=>$this->request->data['Note']['id'])));
						if(!empty($oldPlan['Note']['plan'])){
								$explodeoldPlanDataExist=explode('$',$oldPlan['Note']['plan']);
								if(count($explodeoldPlanDataExist)-1 < $this->request->data['Note']['oneOneDiagosis']){
										$this->request->data['Note']['plan']=implode('$',$explodeoldPlanDataExist).'$'.$this->request->data['Note']['plan'].":::".$this->request->data['Note']['oneOneDiagosis'];
								}else{
								$explodeOldPlan=explode('$',$oldPlan['Note']['plan']);
									
									foreach($explodeOldPlan as $explodeOldPlans){ // start of for each
										$explodeInsideData=explode(':::',$explodeOldPlans);							
										if(empty($this->request->data['Note']['oneOneDiagosis'])){
											$this->request->data['Note']['oneOneDiagosis']=0;
										}							
										if($explodeInsideData['1']==$this->request->data['Note']['oneOneDiagosis']){
											$planNewText[]=$this->request->data['Note']['plan'].":::".$this->request->data['Note']['oneOneDiagosis'];
										}else{//exit;
											$planNewText[]=$explodeOldPlans;
										}
									}// End of for each
									
									$planNewTextNew=implode('$',$planNewText);							
									unset($planNewText[count($planNewTextNew)-1]);							
									$this->request->data['Note']['plan']=$planNewTextNew;						
									
							}// end of else
						} // end of sencond if clause
						else{
							if(!empty($this->request->data['Note']['plan']))
								$this->request->data['Note']['plan']=$this->request->data['Note']['plan'].":::0";
						}
					}// end of first if (for lab diagnosis add -Aditya)
					
					//gulshan// for 1st time from soap to initial
					$isPreaent = $this->Diagnosis->find('first',array('fields'=>array('id','patient_id','complaints','family_tit_bit'),
							'conditions'=>array('Diagnosis.patient_id'=>$this->request->data['Note']['patient_id'],'Diagnosis.appointment_id'=>$_SESSION['apptDoc'])));
					//eof gulshan
					if($this->Note->save($this->request->data['Note'])){
						$initialCc=$this->request->data['Note']['cc'];
						$initialfamily=$this->request->data['Note']['family_tit_bit'];
						$family_tit_bit=$isPreaent['Diagnosis']['family_tit_bit'];
						$complaints=$isPreaent['Diagnosis']['complaints'];
						$lastinsid=$this->Note->getInsertId();
						if(empty($lastinsid)){// for case of update
							$lastinsid=$this->request->data['Note']['id'];
						}
					
						if(!empty($initialCc)){
							if(!$isPreaent){
								$this->Diagnosis->save(array('complaints'=>$initialCc,'appointment_id'=>$this->request->data['Note']['appt'],
										'patient_id'=>$this->request->data['Note']['patient_id'],'create_time'=>date("Y-m-d H:i:s"),
										'created_by'=>$this->Session->read('userid'),'location_id'=>$this->Session->read('locationid'),'note_id'=>$lastinsid));
							}else{
								$getoo=$this->Diagnosis->updateAll(array('complaints'=>"'$initialCc'",'note_id'=>"'$lastinsid'"),
										array('Diagnosis.appointment_id'=>$this->request->data['Note']['appt']));
							}
						}
						if(!empty($initialfamily)){
							if(!$isPreaent){
								$this->Diagnosis->save(array('family_tit_bit'=>$initialfamily,'appointment_id'=>$this->request->data['Note']['appt'],
										'patient_id'=>$this->request->data['Note']['patient_id'],'create_time'=>date("Y-m-d H:i:s"),
										'created_by'=>$this->Session->read('userid'),'location_id'=>$this->Session->read('locationid'),'note_id'=>$lastinsid));
							}else{
								$this->Diagnosis->updateAll(array('family_tit_bit'=>"'$initialfamily'",/* 'complaints'=>"'$complaints'", */'note_id'=>"'$lastinsid'"),
										array('Diagnosis.appointment_id'=>$this->request->data['Note']['appt']));
							}
						}
						// update in appointmemt table
								$this->loadModel('Appointment') ;
								$timeDiff=$this->Appointment->find('first',array('fields'=>array('id','arrived_time','status','elapsed_time'),'conditions'=>array('Appointment.id'=>$this->request->data['Note']['appt'])));
								if(empty($timeDiff['Appointment']['elapsed_time']) || $timeDiff['Appointment']['elapsed_time']==''){
									$start=$timeDiff['Appointment']['date'].' '.$timeDiff['Appointment']['arrived_time'];
									$elapsed=$this->DateFormat->dateDiff($start,date('Y-m-d H:i')) ;
									if($elapsed->i!=0){
										$min=$elapsed->i;
									}else{
										$min='00';
									}
									if($elapsed->h!=0){
										if($elapsed->h>=12){
											$hrs=$elapsed->h-12;
										}
										else{
											$hrs=$elapsed->h;
										}
										$hrs= ($hrs * 60);
										$showTime=$hrs+$min;

									}else{
										$showTime=$min;
									}
									if($timeDiff['Appointment']['status']!='Closed'){
										$res=$this->Appointment->updateAll(array('status'=>"'Seen'"),
											array('Appointment.is_future_app'=>0,'Appointment.id'=>$this->request->data['Note']['appt']));
									}
								}
						// update code End

					}
					$lastinsid=$this->Note->getInsertId();
					if(!empty($this->request->data['Note']['id']) && ($this->request->data['Note']['id']!='null')){
						$this->Session->write('myNoteId',$this->request->data['Note']['id']);
						echo $this->request->data['Note']['id'];
						unset($this->request->data['Note']);
						exit;
					}
					else{
						$this->Session->write('myNoteId',$lastinsid);
						echo $lastinsid;
						unset($this->request->data['Note']); 
						exit;
					}
				}else{
					/** BEFORE **/
				$this->set('patientID',$patientId);
				$this->set('appoinmentID',$this->params->query['apptId']);
				$configInstance=$this->Session->read('website.instance');
				$this->set('configInstance',$configInstance);
				$this->patient_billing_info($id);
				$tariffStdData=$this->viewVars['patient'];
				$this->set('personID',$this->patient_details['Person']['id']);// for sync-Aditya


				/** Problem LabRad **/
					if(!empty($noteId)){
						$getProblem=$this->Note->getDiagnosis($patientId,$noteId);
						$this->set('getProblem',$getProblem);
					}
				/** EOD**/	
			
				/** Get Pervious problem enounter not maintained **/
					$getPastProblems=$this->NoteDiagnosis->find('list',array('fields'=>array('id','diagnoses_name'),
							'conditions'=>array('patient_id'=>$patientId),'group'=>array('diagnoses_name')));
					$this->set('getPastProblems',$getPastProblems);
				/** EOD **/
				/** get element diagnosis **/
				$dList=$this->NoteDiagnosis->find('list',array('fields'=>array('id','diagnoses_name'),'conditions'=>array('patient_id'=>$patientId)));
				$this->set('dList',$dList);
				/** EOD **/
				/** get element detials **/
					$this->Patient->unBindModel(array(
							'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
					$this->Patient->bindModel(array(
							'belongsTo' => array(
									'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id')),
									'Appointment' =>array('foreignKey' => false,'conditions'=>array('Appointment.patient_id=Patient.id')),
							)));
					$getElement=$this->Patient->find('first',
							array('fields'=>array('Appointment.date','Appointment.start_time','Person.id','Person.create_time','Person.sex','Person.age','Person.preferred_language','Person.language','Person.email','Person.photo','Person.phvs_visit_id','Patient.person_id',
									'Appointment.visit_type','Patient.patient_id','Patient.id','Patient.tariff_standard_id','Patient.lock','Patient.form_received_on','Person.patient_uid','Patient.admission_id','Patient.lookup_name','Person.dob','Patient.doctor_id','Patient.admission_type','Patient.tariff_standard_id'),'conditions'=>array('Patient.id'=>$patientId)));	
					$getCurrentAge=$this->Person->getCurrentAge($getElement['Person']['dob']);

					if(strtolower($getElement['Patient']['admission_type'])=='ipd'){
						$optIDs=$this->OptAppointment->find('first',array('fields'=>array('id','id'),
						'conditions'=>array('OptAppointment.patient_id'=>$getElement['Patient']['id'])));
						$this->set('optIDs',$optIDs);
					}

					/* Packages*/
						$servicesDataPack =$this->ServiceBill->find('first',array('group'=>array('ServiceBill.id'),'fields'=>array('ServiceBill.service_id'),'conditions'=>array('ServiceBill.patient_id'=>$patientId,'ServiceBill.tariff_standard_id'=>$getElement['Patient']['tariff_standard_id'])));
						$this->ServiceBill->bindModel(array('belongsTo' => array(
							'Patient' =>array('foreignKey'=>'patient_id'),
							"ServiceCategory"=>array('foreignKey'=>'service_id','type'=>'RIGHT'),
							"ServiceSubCategory"=>array('foreignKey'=>'sub_service_id'),
							'TariffList'=>array('foreignKey'=>'tariff_list_id'),
							'TariffAmount'=>array('foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=ServiceBill.tariff_list_id','TariffAmount.tariff_standard_id'))
						)));
						$servicesData =$this->ServiceBill->find('all',array('group'=>array('ServiceBill.id'),/*'fields'=>array('TariffList.name'),*/'conditions'=>array('ServiceBill.patient_id'=>$patientId,'ServiceBill.service_id'=>$servicesDataPack['ServiceBill']['service_id'])));
						$this->set('servicesData',$servicesData);
					/*EOD*/
					$vistList=$this->TariffList->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_deleted'=>'0','check_status'=>'1','location_id'=>$this->Session->read('locationid'))));
					
					$this->set('opdoptions',$OPCheckUpOptions);
					$getElement['Person']['age']=$getCurrentAge;
					$this->set('getElement',$getElement);
					$this->set('vistList',$vistList);
					
					$getLanguage=$this->Language->find('list',array('fields'=>array('code','language')));
					$this->set('language',$getLanguage);
					/** hearder data **/
					$getComplaints=$this->Diagnosis->find('first',array('fields'=>array('id','complaints','flag_event','family_tit_bit'),
							'conditions'=>array('patient_id'=>$patientId,'appointment_id'=>$_SESSION['apptDoc']),'order'=>'id DESC'));
					//debug($getComplaints);exit;
					$this->set('DiaCC',trim($getComplaints['Diagnosis']['complaints']));
					$this->set('family_tit_bit1',trim($getComplaints['Diagnosis']['family_tit_bit']));
					$this->set('flagEvent',trim($getComplaints['Diagnosis']['flag_event']));
					$this->set('diagnosisId',trim($getComplaints['Diagnosis']['id']));
				/** get element detials EOD **/

				$this->set('patientId',$patientId);
				$this->set('noteId',$noteId);
				if(!empty($noteId)){
					$getVitals=$this->Note->find('first',array('conditions'=>array('id'=>$noteId)));
					$this->set('getVitals',$getVitals);
				
				}
				$this->set('timeFromPList',$this->params->query['arrived_time']);
				
				$getVitals2=$this->getInitalDataNew($patientId);
				$this->set(array('getVitals1'=>$getVitals2));
				$abnoralTemp='';
				$bpTemp='';
				if(($getVitals2['BmiResult']['temperature']>'98.6') && ($getVitals2['BmiResult']['myoption']=='F')){
					$abnoralTemp='abormal';
				}else if(($getVitals2['BmiResult']['temperature1']>'98.6') && ($getVitals2['BmiResult']['myoption1']=='F')){
					$abnoralTemp='abormal';
				}
				else if(($getVitals2['BmiResult']['temperature2']>'98.6') && ($getVitals2['BmiResult']['myoption2']=='F')){
					$abnoralTemp='abormal';
				}

				if(($getVitals2['BmiResult']['temperature']>'37') && ($getVitals2['BmiResult']['myoption']=='C')){
					$abnoralTemp='abormal';
				}else if(($getVitals2['BmiResult']['temperature1']>'37') && ($getVitals2['BmiResult']['myoption1']=='C')){
					$abnoralTemp='abormal';
				}
				else if(($getVitals2['BmiResult']['temperature2']>'37') && ($getVitals2['BmiResult']['myoption2']=='C')){
					$abnoralTemp='abormal';
				}

				if(($getVitals2['BmiBpResult']['systolic'] >'140') && ($getVitals2['BmiBpResult']['diastolic'] >'90')){
					$bpTemp='abormal';
					$abormalBp=$getVitals2['BmiBpResult']['systolic']."/".$getVitals2['BmiBpResult']['diastolic'];
				}
				else if(($getVitals2['BmiBpResult']['systolic1'] >'140') && ($getVitals2['BmiBpResult']['diastolic1'] >'90')){
					$bpTemp='abormal';	
					$abormalBp=$getVitals2['BmiBpResult']['systolic1']."/".$getVitals2['BmiBpResult']['diastolic1'];
				}
				else if(($getVitals2['BmiBpResult']['systolic2'] >'140') && ($getVitals2['BmiBpResult']['diastolic2'] >'90')){
					$bpTemp='abormal';	
					$abormalBp=$getVitals2['BmiBpResult']['systolic2']."/".$getVitals2['BmiBpResult']['diastolic2'];
				}
				$this->set('abnoralTemp',$abnoralTemp);
				$this->set('bpTemp',$bpTemp);
				$this->set('abormalBp',$abormalBp);

				//$getVitals2=$this->getInitalData($patientId);
				//	debug('1');exit;
				$this->set('ccdata',trim($getVitals2['Note']['cc']));
				$this->set('family_tit_bit',trim($getVitals2['Note']['family_tit_bit'])); // show data of initial assement always-Aditya
				if(!empty($noteId)){
				 
					$getVitals=$this->Note->find('first',array('conditions'=>array('id'=>$noteId),
						'fields'=>array('family_tit_bit','cc','id','patient_id',),'order'=>array('id ASC')));
					if(empty($getVitals2['Note']['cc'])){
						$this->set('ccdata',trim($getVitals['Note']['cc']));
					}
					if(empty($getVitals2['Note']['family_tit_bit'])){
						$this->set('family_tit_bit',trim($getVitals['Note']['family_tit_bit']));
					}
				}
				
				//BOF document section data
				$this->loadModel('PatientsTrackReport');
				$patientDocuments = $this->PatientsTrackReport->getPatientDocuments($patientId,'null',$getElement['Patient']['person_id']);
				$this->set('getPatientDocuments',$patientDocuments) ;
				//debug($patientDocuments);exit;
				//EOF document section data
				
				/**BEFORE END**/
				}
				/*$this->loadModel('Immunization') ;
				$this->Immunization->bindModel(array(
						'belongsTo' => array(
								'PhvsImmunizationInformationSource' =>array('foreignKey' => false,'type'=>'Inner','conditions'=>array('PhvsImmunizationInformationSource.id = Immunization.admin_note' )),
						)),false);
				$this->set('imunizationCount',$this->Immunization->find('first',array('fields'=>'id','conditions'=>array('patient_id'=>$patientId,'is_deleted'=>0,'PhvsImmunizationInformationSource.show_in_soap_note'=>1))));*/

				 $testOrdered = $this->Billing->completeLabRadTests($patientId,1); 
				$this->set(array('testOrdered'=>$testOrdered));
	}

	//function to print prescription
	function prescription_detail_print($id=null){
		$this->layout=false;
		$this->uses = array('Appointment','Patient','Person','Location','City','State','Country','User','DoctorProfile','NewCropPrescription','NewCropAllergies','BmiResult');

		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));

		$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);

		//$LicensedPrescriberName=$this->DoctorProfile->getDoctorByID($UIDpatient_details['Patient']['doctor_id']);
		if($this->Session->read('role')=='Primary Care Provider')
		{
			$LicensedPrescriberName=$this->User->find('first', array('conditions' => array('User.id' => $this->Session->read('userid'))));
		}
		else
		{
			//find doctor id for this appointment
			$doctorId=$this->Appointment->find('first', array('fields'=> array('Appointment.doctor_id'),'conditions' => array('Appointment.id' => $appointmentId)));
			$LicensedPrescriberName=$this->DoctorProfile->getDoctorByID($doctorId);
		}
		$city_location_prescriber = $this->City->find('first', array('fields'=> array('City.name'),'conditions'=>array('City.id'=>$LicensedPrescriberName[User][city_id])));
		$state_location_prescriber = $this->State->find('first', array('fields'=> array('State.state_code'),'conditions'=>array('State.id'=>$LicensedPrescriberName[User][state_id])));
		$state_location_patient = $this->State->find('first', array('fields'=> array('State.state_code'),'conditions'=>array('State.id'=>$UIDpatient_details['Person']['state'])));
		$hospital_location = $this->Location->find('first', array('fields'=> array('Location.id', 'Location.name'),'conditions'=>array('Location.id'=>$this->Session->read('locationid'), 'Location.is_active' => 1, 'Location.is_deleted' => 0)));

		$bmiResult = $this->BmiResult->find('first',array('fields'=>array('BmiResult.height','BmiResult.weight_result','height_volume','BmiResult.weight','BmiResult.weight_volume'),'conditions'=>array('patient_id'=>$id)));
		if(!empty($this->params->query[medToPrint])){
			$medicationIdExplode=explode(',',$this->params->query[medToPrint]);
			$search_key['NewCropPrescription.id'] =  $medicationIdExplode;
			//$search_key['NewCropPrescription.patient_uniqueid'] = $id;
			$search_key['NewCropPrescription.archive'] ='N';
		}
		else{
			$search_key['NewCropPrescription.patient_uniqueid'] = $id;
			$search_key['NewCropPrescription.archive'] ='N';
			$search_key['NewCropPrescription.id'] =  $medicationIdExplode;
		}
			
		$getMedicationRecords=$this->NewCropPrescription->find('all',array('fields'=>array('description','drug_name','id','route',
				'frequency','dose','prn','refills','prn','daw','strength','PrescriptionGuid','quantity','day','DosageForm','DosageRouteTypeId','PrescriptionNotes','PharmacistNotes'),
				'conditions'=>$search_key));
			
		if(!empty($this->params->query[allergyToPrint])){
			$allergyIdExplode=explode(',',$this->params->query[allergyToPrint]);
			$search_key1['NewCropAllergies.id'] =  $allergyIdExplode;
			//$search_key1['NewCropAllergies.patient_uniqueid'] = $id;
			$search_key1['NewCropAllergies.is_reconcile'] =0;
			$search_key1['NewCropAllergies.status'] ='A';
		}else{
			$search_key1['NewCropAllergies.patient_uniqueid'] = $id;
			$search_key1['NewCropAllergies.is_reconcile'] =0;
			$search_key1['NewCropAllergies.status'] ='A';
			$search_key1['NewCropAllergies.id'] =  $allergyIdExplode;
		}
		$allergies_data=$this->NewCropAllergies->find('all',array('fields'=>array('name','reaction','AllergySeverityName','onset_date'),
				'conditions'=>$search_key1));
			
		$this->set('allergies_data',$allergies_data);
		$this->set('hospitalLocation',$hospital_location['Location']['name']);
		$this->set('state_location_patient',$state_location_patient['State']['state_code']);
		$this->set('city_location_prescriber',$city_location_prescriber['City']['state_code']);
		$this->set('state_location_prescriber',$state_location_prescriber['State']['state_code']);
		$this->set('UIDpatient_details',$UIDpatient_details);
		$this->set('LicensedPrescriberName',$LicensedPrescriberName);
		$this->set('getMedicationRecords',$getMedicationRecords);
		$this->set('getAllergyRecords',$allergies_data);
		$this->set('bmiResult',$bmiResult);


	}

	public function getAllergyInfo($id,$patient_id){
		//$this->layout = false;
		$this->loadModel('Patient');
		$this->loadModel('NewCropAllergies');
		$getPatientAllergies=$this->PatientAllergies($patient_id,$id);
		$patientAllergies =explode('~',$getPatientAllergies);
		$CountOfAllergiesRecords=count($patientAllergies)-1;
		for($i=0;$i<$CountOfAllergiesRecords;$i++){
			$AllergiesSpecific[] =explode('>>>>',$patientAllergies[$i]);
		}

		$this->Patient->insertAllergies($patient_id,$id,$AllergiesSpecific);

		/* $allergies_data=$this->NewCropAllergies->find('all',array('fields'=>array('NewCropAllergies.name'),
		 'conditions'=>array('NewCropAllergies.patient_uniqueid'=>$id,'NewCropAllergies.status !='=>'N', 'NewCropAllergies.is_reconcile'=>0,
		 		'NewCropAllergies.location_id'=>$this->Session->read('locationid')),'group'=>array('NewCropAllergies.name')));
		$this->set('allergies_data',$allergies_data);
		$this->render('get_allergy_info')*/
	}
	public function PatientAllergies($id=null,$patient_uniqueid=null){

		//find facility id
		$this->loadModel("Facility");
		$this->Facility->unBindModel(array(
				'hasOne'=>array('FacilityDatabaseMapping','FacilityUserMapping')
		));
		$facility = $this->Facility->find('first', array('fields'=> array('Facility.id','Facility.name'),'conditions'=>array('Facility.is_deleted' => 0, 'Facility.is_active' => 1,'Facility.id' => $this->Session->read("facilityid"))));

		$curlData.='<?xml version="1.0" encoding="utf-8"?>';
		$curlData.='<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
				<soap:Body>';
		$curlData.='<GetPatientAllergyHistoryV3 xmlns="https://secure.newcropaccounts.com/V7/webservices">';
		$curlData.='<credentials>
				<PartnerName>DrMHope</PartnerName>
				<Name>'.Configure::read('uname').'</Name>
						<Password>'.Configure::read('passw').'</Password>
								</credentials>';
		$curlData.='<accountRequest>
				<AccountId>'.$facility[Facility][name].'</AccountId>
						<SiteId>'.$facility[Facility][id].'</SiteId>
								</accountRequest>';
		$curlData.='<patientRequest>
				<PatientId>'.$id.'</PatientId>
						</patientRequest>';
		$curlData.='<patientInformationRequester>
				<UserType>S</UserType>
				<UserId>'.$id.'</UserId>
						</patientInformationRequester>';
		$curlData.=' </GetPatientAllergyHistoryV3>
				</soap:Body>
				</soap:Envelope>';
		$url=Configure::read('SOAPUrl');
		$curl = curl_init();

		curl_setopt ($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl,CURLOPT_TIMEOUT,120);
		//curl_setopt($curl,CURLOPT_ENCODING,'gzip');

		curl_setopt($curl,CURLOPT_HTTPHEADER,array (
		'SOAPAction:"https://secure.newcropaccounts.com/V7/webservices/GetPatientAllergyHistoryV3"',
		'Content-Type: text/xml; charset=utf-8',
		));

		curl_setopt ($curl, CURLOPT_POST, 1);
		curl_setopt ($curl, CURLOPT_POSTFIELDS, $curlData);

		$result = curl_exec($curl);


		curl_close ($curl);
		if($result!="")
		{
			$xml =simplexml_load_string($result);
			$xml->registerXPathNamespace("soap", "http://schemas.xmlsoap.org/soap/envelope/");
			$finalxml=$xml->xpath('//soap:Body');
			//print_r($finalxml[0]);

			//$finalxml=(array)$finalxml[0];
			//echo  echo $xmldata->ICD9_DEFINITIONS_IMO->RECORD->DEFINITION_TEXT;
			$finalxml=$finalxml[0];
			//	print_r($finalxml);
			//echo $finalxml["GetPatientFullMedicationHistory6Response"]
			$staus= $finalxml->GetPatientAllergyHistoryV3Response->GetPatientAllergyHistoryV3Result->Status;
			$response= $finalxml->GetPatientAllergyHistoryV3Response->GetPatientAllergyHistoryV3Result->XmlResponse;
			$rowcount= $finalxml->GetPatientAllergyHistoryV3Response->GetPatientAllergyHistoryV3Result->RowCount;
			$xmlString= base64_decode($response);

			$xmldata = simplexml_load_string($xmlString);
			if($rowcount>1){
				for($i=0;$i<$rowcount;$i++){

					$newcrop_CompositeAllergyID= $xmldata->Table[$i]->CompositeAllergyID;
					$newcrop_AllergySourceID= $xmldata->Table[$i]->AllergySourceID;
					$newcrop_AllergyId= $xmldata->Table[$i]->AllergyId;
					$newcrop_AllergyConceptId= $xmldata->Table[$i]->AllergyConceptId;
					$newcrop_ConceptType= $xmldata->Table[$i]->ConceptType;
					$newcrop_AllergyName= $xmldata->Table[$i]->AllergyName;
					$newcrop_AllergyStatus= $xmldata->Table[$i]->Status;
					$newcrop_AllergySeverityTypeId= $xmldata->Table[$i]->AllergySeverityTypeId;
					$newcrop_AllergySeverityName= $xmldata->Table[$i]->AllergySeverityName;
					$newcrop_OnsetDate= $xmldata->Table[$i]->OnsetDateCCYYMMDD;
					$newcrop_AllergyReaction= $xmldata->Table[$i]->AllergyNotes;

					$newcrop_ConceptID= $xmldata->Table[$i]->ConceptID;
					$newcrop_ConceptTypeId= $xmldata->Table[$i]->ConceptTypeId;
					$newcrop_rxcui= $xmldata->Table[$i]->rxcui;



					$collectedAllergies= $newcrop_CompositeAllergyID.">>>>".$newcrop_AllergySourceID.">>>>".$newcrop_AllergyId.">>>>".$newcrop_AllergyConceptId.">>>>".
							$newcrop_ConceptType.">>>>".$newcrop_AllergyName.">>>>".$newcrop_AllergyStatus.">>>>".$newcrop_AllergySeverityTypeId.">>>>".
							$newcrop_AllergySeverityName.">>>>".$newcrop_AllergyReaction.">>>>".$newcrop_ConceptID.">>>>".$newcrop_ConceptTypeId.">>>>".
							$newcrop_rxcui.">>>>".$newcrop_OnsetDate.">>>>".$patient_uniqueid."~".$collectedAllergies;

				}
				return $collectedAllergies;

			}
			else{
				$newcrop_CompositeAllergyID= $xmldata->Table->CompositeAllergyID;
				$newcrop_AllergySourceID= $xmldata->Table->AllergySourceID;
				$newcrop_AllergyId= $xmldata->Table->AllergyId;
					
				$newcrop_AllergyConceptId= $xmldata->Table[$i]->AllergyConceptId;
				$newcrop_ConceptType= $xmldata->Table->ConceptType;
				$newcrop_AllergyName= $xmldata->Table->AllergyName;
				$newcrop_AllergyStatus= $xmldata->Table->Status;
				$newcrop_AllergySeverityTypeId= $xmldata->Table->AllergySeverityTypeId;
				$newcrop_AllergySeverityName= $xmldata->Table->AllergySeverityName;
				$newcrop_AllergyReaction= $xmldata->Table->AllergyNotes;
				$newcrop_OnsetDate= $xmldata->Table->OnsetDateCCYYMMDD;
				$newcrop_ConceptID= $xmldata->Table->ConceptID;
				$newcrop_ConceptTypeId= $xmldata->Table->ConceptTypeId;
				$newcrop_rxcui= $xmldata->Table->rxcui;;
				if($newcrop_AllergyName!=""){
					//	echo "<pre>"; print_r($newcrop_AllergyName);exit;

					$collectedAllergies= $newcrop_CompositeAllergyID.">>>>".$newcrop_AllergySourceID.">>>>".$newcrop_AllergyId.">>>>".$newcrop_AllergyConceptId.">>>>".
							$newcrop_ConceptType.">>>>".$newcrop_AllergyName.">>>>".$newcrop_AllergyStatus.">>>>".$newcrop_AllergySeverityTypeId.">>>>".
							$newcrop_AllergySeverityName.">>>>".$newcrop_AllergyReaction.">>>>".$newcrop_ConceptID.">>>>".$newcrop_ConceptTypeId.">>>>".
							$newcrop_rxcui.">>>>".$newcrop_OnsetDate.">>>>".$patient_uniqueid."~".$collectedAllergies;
					return $collectedAllergies;

				}

				else{
					return $collectedAllergies="";
				}
				//$collectedAllergies = $newcrop_AllergyId .">>>>".$newcrop_AllergyName."~".$collectedAllergies;

			}

		}
	}

	public function get_medication_record($id=null,$patient_uniqueid=null){

		//find facility id
		$this->loadModel("Facility");
		$this->Facility->unBindModel(array(
				'hasOne'=>array('FacilityDatabaseMapping','FacilityUserMapping')
		));
		$facility = $this->Facility->find('first', array('fields'=> array('Facility.id','Facility.name'),'conditions'=>array('Facility.is_deleted' => 0, 'Facility.is_active' => 1,'Facility.id' => $this->Session->read("facilityid"))));

		$curlData.='<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
				<soap:Body>';

		$curlData.='<GetPatientFullMedicationHistory6 xmlns="https://secure.newcropaccounts.com/V7/webservices">';
		$curlData.= '<credentials>
				<PartnerName>DrMHope</PartnerName>
				<Name>'.Configure::read('uname').'</Name>
						<Password>'.Configure::read('passw').'</Password>
								</credentials>';
		$curlData.=' <accountRequest>
				<AccountId>'.$facility[Facility][name].'</AccountId>
						<SiteId>'.$facility[Facility][id].'</SiteId>
								</accountRequest>';
		$curlData.=' <patientRequest>
				<PatientId>'.$id.'</PatientId>
						</patientRequest>';
		$curlData.='<prescriptionHistoryRequest>
				<StartHistory>2004-01-01T00:00:00.000</StartHistory>
				<EndHistory>2012-01-01T00:00:00.000</EndHistory>
				<PrescriptionStatus>C</PrescriptionStatus>
				<PrescriptionSubStatus>%</PrescriptionSubStatus>
				<PrescriptionArchiveStatus>%</PrescriptionArchiveStatus>
				</prescriptionHistoryRequest>';
		$curlData.=' <patientInformationRequester>
				<UserType>S</UserType>
				<UserId>'.$id.'</UserId>
						</patientInformationRequester>';
		$curlData.=' <patientIdType>string</patientIdType>
				<includeSchema>Y</includeSchema>
				</GetPatientFullMedicationHistory6>
				</soap:Body>
				</soap:Envelope>';
		$url=Configure::read('SOAPUrl');
		$curl = curl_init();
		//echo $curlData;
		curl_setopt ($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl,CURLOPT_TIMEOUT,120);
		//curl_setopt($curl,CURLOPT_ENCODING,'gzip');

		curl_setopt($curl,CURLOPT_HTTPHEADER,array (
		'SOAPAction:"https://secure.newcropaccounts.com/V7/webservices/GetPatientFullMedicationHistory6"',
		'Content-Type: text/xml; charset=utf-8',
		));

		curl_setopt ($curl, CURLOPT_POST, 1);
		curl_setopt ($curl, CURLOPT_POSTFIELDS, $curlData);

		$result = curl_exec($curl);

		curl_close ($curl);
		$xml =simplexml_load_string($result);

		if($result!="")
		{

			$xml->registerXPathNamespace("soap", "http://schemas.xmlsoap.org/soap/envelope/");
			$finalxml=$xml->xpath('//soap:Body');
			$finalxml=$finalxml[0];

			$staus= $finalxml->GetPatientFullMedicationHistory6Response->GetPatientFullMedicationHistory6Result->Status;
			$response= $finalxml->GetPatientFullMedicationHistory6Response->GetPatientFullMedicationHistory6Result->XmlResponse;
			$rowcount= $finalxml->GetPatientFullMedicationHistory6Response->GetPatientFullMedicationHistory6Result->RowCount;
			//for getting patient
			$get_id=$this->Patient->find('all',array('fields'=>array('patient_id'),'conditions'=>array('Patient.id'=>$id)));

			$xmlString= base64_decode($response);

			$xmldata = simplexml_load_string($xmlString);


			//	echo "<pre>";print_r($xmldata);// exit;
			$xmlArray= array();

			$i=0;
			foreach($xmldata as $xmlDataKey => $xmlDataValue ){
					
					
				$xmlDataValue =  (array) $xmlDataValue;
				$xmlArray[$i]['patientIdFormNewCrop']=$xmlDataValue['ExternalPrescriptionID'];// for problem in encounter.
				$xmlArray[$i]['description']=$xmlDataValue['DrugInfo'];
				$xmlArray[$i]['drug_id']=$xmlDataValue['DrugID'];
				$xmlArray[$i]['date_of_prescription']=$xmlDataValue['PrescriptionDate'];
				$xmlArray[$i]['drm_date']=date('Y-m-d');
				$xmlArray[$i]['route']=$xmlDataValue['Route'];
				$xmlArray[$i]['rxnorm']=$xmlDataValue['rxcui'];
				$xmlArray[$i]['archive']=$xmlDataValue['Archive'];
				$xmlArray[$i]['frequency']=$xmlDataValue['DosageFrequencyDescription'];

				$xmlArray[$i]['dose_unit']=$xmlDataValue['DosageForm'];
				$xmlArray[$i]['drug_name']=$xmlDataValue['DrugName'];
				$xmlArray[$i]['refills']=$xmlDataValue['Refills'];
				$xmlArray[$i]['quantity']=$xmlDataValue['Dispense'];
				$xmlArray[$i]['day']=$xmlDataValue['DaysSupply'];
				$xmlArray[$i]['strength']=$xmlDataValue['DosageFormTypeId'];

				//$xmlArray[$i]['PrintLeaflet']=$xmlDataValue['PrintLeaflet'];
				$xmlArray[$i]['PharmacyType']=$xmlDataValue['PharmacyType'];
				$xmlArray[$i]['PharmacyDetailType']=$xmlDataValue['PharmacyDetailType'];
				$xmlArray[$i]['FinalDestinationType']=$xmlDataValue['FinalDestinationType'];
				$xmlArray[$i]['FinalStatusType']=$xmlDataValue['FinalStatusType'];
				$xmlArray[$i]['DeaGenericNamedCode']=$xmlDataValue['DeaGenericNamedCode'];
				$xmlArray[$i]['DeaClassCode']=$xmlDataValue['DeaClassCode'];

				$xmlArray[$i]['PharmacyNCPDP']=$xmlDataValue['PharmacyNCPDP'];
				$xmlArray[$i]['PharmacyFullInfo']=$xmlDataValue['PharmacyFullInfo'];
				$xmlArray[$i]['DeaLegendDescription']=$xmlDataValue['DeaLegendDescription'];

				$xmlArray[$i]['dose']=$xmlDataValue['DosageNumberTypeID'];
				$xmlArray[$i]['DosageForm']=$xmlDataValue['DosageFormTypeId'];
				$xmlArray[$i]['frequency']=$xmlDataValue['DosageFrequencyTypeID'];
				$xmlArray[$i]['DosageRouteTypeId']=$xmlDataValue['DosageRouteTypeId'];
				$xmlArray[$i]['route']=$xmlDataValue['DosageRouteTypeId'];

				$xmlArray[$i]['PrescriptionNotes']=$xmlDataValue['PrescriptionNotes'];
				$xmlArray[$i]['PharmacistNotes']=$xmlDataValue['PharmacistNotes'];

				if($xmlDataValue['TakeAsNeeded']=='N')
					$pnr='0';
				else
					$pnr='1';
				if($xmlDataValue['DispenseAsWritten']=='N')
					$daw='0';
				else
					$daw='1';
				$xmlArray[$i]['prn']=$pnr;
				$xmlArray[$i]['daw']=$daw;
				$xmlArray[$i]['PrescriptionGuid']=$xmlDataValue['PrescriptionGuid'];
				$i++;
			}


			return $xmlArray;


		}
	}

	public function addMedication($patientId=null,$drugId=null,$newCropID=null,$isDeleted=null,$noteId=null){

		$this->layout='ajax';
		$this->uses=array('Configuration','NewCropPrescription','Patient','Note','PharmacyItem');
		
		$getUId=$this->Patient->find('first',array('fields'=>array('person_id'),'conditions'=>array('id'=>$patientId)));
		$this->set('Uid',$getUId['Patient']['person_id']);
		//find newcrop health plan
		$getHealthPlanId=$this->Patient->find('first',array('fields'=>array('patient_health_plan_id'),'conditions'=>array('id'=>$patientId)));
		$this->set('patientHealthPlanID',$getHealthPlanId['Patient']['patient_health_plan_id']);
		// seen status
		$this->Note->seenStatus();
		///
		//set PAtient n NoteId to Ctp
		$this->set('patientId',$patientId);
		$this->set('noteId',$noteId);
		if(!empty($this->params->query['encPatientId'])){
			$this->set('encPatientId',$this->params->query['encPatientId']);
		}
		if(!empty($this->params->query['pastEncounter'])){
			$this->set('pastEncounter','pastEncounter');
		}
		

		/**bof medication is not present**/

		if(!empty($this->params->query['flag']) && $this->params->query['flag']=='notPresent'){
			$this->set('flag',$this->params->query['flag']);
			$medNotPresent=$this->NewCropPrescription->find('first',array('fields'=>array('NewCropPrescription.drug_name','NewCropPrescription.description'),'conditions'=>array('NewCropPrescription.id'=>$drugId)));

			$temp=$this->PharmacyItem->find('list',array('fields'=>array('PharmacyItem.drug_id','PharmacyItem.name'),'conditions'=>array('PharmacyItem.name LIKE'=>'%'.$medNotPresent['NewCropPrescription']['description'].'%'/*,'AllergyMaster.status'=>'A'*/)));
			$this->set('temp',$temp);
		}

		/**eof medication is not present**/

		//***********delete medication************//
		if(!empty($newCropID) && !empty($isDeleted) && $isDeleted=='1'){
			$this->NewCropPrescription->updateAll(array('NewCropPrescription.archive'=>"'D'"),
					array('NewCropPrescription.id'=>$newCropID));
			$this->Session->setFlash(__('Medication Deleted Successfully' ),true,array('class'=>'message'));
			exit;
		}
		//-----------------------------
		//--- New Medication Unit DOSE AND STRENGHT ADD DO NOT REMOVE Aditya
		$getConfiguration=$this->Configuration->find('all');
		$strenght=unserialize($getConfiguration[0]['Configuration']['value']);
		//$dose=unserialize($getConfiguration[1]['Configuration']['value']);
		$dose=Configure::read('dose_type');
		//$route=unserialize($getConfiguration[2]['Configuration']['value'];)
		$route=Configure::read('route_administration');

		//$str1='<select style="width:80px;" id="dose_type'+counter+'" class="" name="dose_type[]">';
		foreach($strenght as $strenghts){
			$str.='<option value='.'"'.stripslashes($strenghts).'"'.'>'.$strenghts.'</option>';
		}
		$str.='</select>';
		$this->set('str',$str);
		//================================ dose
		$cntDose='1';
		foreach($dose as $doses){
			$str_dose.='<option value='.'"'.$cntDose.'"'.'>'.$doses.'</option>';
			$cntDose++;
		}
		$str_dose.='</select>';
		$this->set('str_dose',$str_dose);
		
		// =======================================end dose
		//============================== route
		foreach($route as $key=>$routes){
			$str_route.='<option value='.'"'.stripslashes($key).'"'.'>'.$routes.'</option>';
		}
		$str_route.='</select>';

		$this->set('str_route',$str_route);
		//================= end dose
		//$this->set('strenght',unserialize($getConfiguration[0]['Configuration']['value']));
		foreach(unserialize($getConfiguration[0]['Configuration']['value']) as $key=>$strenght){
			if(!empty($strenght))
				$strenght_var[$strenght]=$strenght;
		}
		$this->set('strenght',$strenght_var);
		//$this->set('dose',unserialize($getConfiguration[1]['Configuration']['value']));
		foreach(unserialize($getConfiguration[1]['Configuration']['value']) as $key=>$doses){
			if(!empty($doses))
				$dose_var[$doses]=$doses;
		}
		$this->set('dose',$dose_var);
		//$this->set('route',unserialize($getConfiguration[2]['Configuration']['value']));
		foreach(unserialize($getConfiguration[2]['Configuration']['value']) as $key=>$route){
			if(!empty($route))
				$route_var[$route]=$route;
		}
		$this->set('route',$route_var);
		//==========================================================
		//***************************Bring data from NewCropPrescription in edit*******************************************
		if(empty($drugId)){
			//$getMedicationRecords=$this->NewCropPrescription->find('all',array('conditions'=>array('patient_uniqueid'=>$patientId,'note_id'=>$noteId)));
			//$this->data=$getMedicationRecords;
		}
		else{
			$getMedicationRecords=$this->NewCropPrescription->find('all',
					array('conditions'=>array('patient_uniqueid'=>$patientId,'id'=>$drugId,'is_deleted'=>'0')));
			$this->set('getMedicationRecords',$getMedicationRecords);
		}
		//*****************************************************************************************************************
		$frequency=Configure::read('frequency');
		//~~FREQ
		foreach($frequency as $keyFreq => $frequencyVal){
			$freq_dose.='<option value='.'"'.stripslashes($keyFreq).'"'.'>'.$frequencyVal.'</option>';
		}
		$freq_dose.='</select>';
		$this->set('freq_dose',$freq_dose);
		
		//~~~EOF FREQ


	}
	//ajax call for review of system
	function reviewOfSystem($patientId=null,$noteId=null){
		$this->layout='advance_ajax';
		$this->uses = array('Template','TemplateTypeContent','Diagnosis','NoteTemplate');
		//find Diagnosis id form Diagnosis table if already add form IA

		//**************************************************************
		if(!$this->params->query['note_Template']){/** for showing Standard as default */
			$this->params->query['note_Template'] = 199; /** 199 is NoteTemplateId for Standard */
		}
		if($this->params->query['note_Template']){
			//to show the lower body of the page
			$this->set('showDialog','1');
			$this->Template->bindModel(array(
					'hasMany' => array('TemplateSubCategories' =>array('foreignKey'=>'template_id','conditions'=>array('TemplateSubCategories.is_deleted=0',
							'TemplateSubCategories.note_template_id'=>$this->params->query['note_Template']),
							'order'=>array('ISNULL(TemplateSubCategories.sort_order), TemplateSubCategories.sort_order ASC')))));
			$rosData=$this->Template->find('all',array('conditions'=>array('Template.template_category_id'=>1,'Template.is_deleted=0'),'order'=>array('ISNULL(Template.sort_order), Template.sort_order ASC')));

			$this->set('templateTypeContent',$this->TemplateTypeContent->find('list',array('fields'=>array('template_id','template_subcategory_id'),
					'conditions'=>array('note_id'=>$noteId,'template_category_id'=>1))));
			$this->set('patientSpecificTemplate',$this->TemplateTypeContent->find('list',array('fields'=>array('template_id','patient_specific_template'),
					'conditions'=>array('note_id'=>$noteId,'template_category_id'=>1))));
			$this->set('hpiIdentified',$this->TemplateTypeContent->find('first',array('fields'=>array('hpi_identified'),
					'conditions'=>array('note_id'=>$noteId,'template_category_id=3'),'order' => array('id' => 'DESC'))));/** HpiIdentified comes from HPI Template */

			$this->set('rosData',$rosData);
		}
		$this->set('patientId',$patientId);
		if(!empty($noteId)){
			$this->set('noteId',$noteId);
		}
		$cntRos=0;

		if(!empty($this->request->data['subCategory_examination'])){
			//*****************check for patient iD************************;
			if(empty($this->request->data['noteId'])){
				$noteId=$this->Note->addBlankNote($this->request->data['patientId']);
				$this->set('noteId',$noteId);
			}else{
				$noteId = $this->request->data['noteId'] ;
			}
			//*************eof****************************

			/*foreach($this->request->data['subCategory_examination'] as $key=>$checkData){
				if (in_array("1", $checkData)) {
			$cntRos++;
			}
			}*/
			//if($cntRos>0){
			if(empty($noteId)){
				$noteId=$this->request->data['noteId'];
			}
			else{
				$noteId=$noteId;

			}
			$note_template_id=$this->request->data['TemplateType']['note_template_id'];
			$categoryData=$this->TemplateTypeContent->insertCategory($this->request->data['subCategory_examination'],$noteId,$this->request->data['patientId'],'no',$this->request->data['Patient']['DiagnosisId'],$note_template_id);
			//}
			//$this->Session->setFlash(__('Review Of System Added Successfully' ),true,array('class'=>'message'));
			$this->set('noteIdClose',$noteId);
			$this->redirect("/notes/soapNote/".$this->request->data['patientId']."/".$noteId);
		}
		//EOF insert

		$tName=$this->NoteTemplate->find('list',array('fields'=>array('id','template_name'),'conditions'=>array('is_deleted'=>'0','template_type'=>array('all','')),'order'=>array('ISNULL(NoteTemplate.sort_order), NoteTemplate.sort_order ASC')));
		//debug($tName);
		$this->set('tName',$tName);
		//for display
	}

	function systemicExamination($patientId=null,$noteId=null, $noteTemplateId = null, $organSystem = null  ){
		$this->layout ='advance_ajax';
		$this->uses = array('Template','TemplateTypeContent','Diagnosis','TemplateMiddleCategory','NoteTemplate','Patient');

		//**************************************************************
		if(!$this->params->query['note_Template']){/** for showing General Examination as default */
			$this->params->query['note_Template'] = 968; /** 968 is NoteTemplateId for general Examination */
			$this->params->query['organ_system'] = 'General Multi-System Examination';
		}
		if($this->params->query['note_Template']){
			$this->Patient->unBindModel(array(
					'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
			$this->Patient->bindModel(array(
					'hasOne' => array(
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
					)),false);
			$patientGender = $this->Patient->find('first',array('fields'=>array('Person.sex'),'conditions'=>array('Patient.id'=>$patientId)));
			$genderKey = (strtoupper($patientGender['Person']['sex']) == 'MALE') ? 2 : 1; /** for fetching genderSpecific Templates */
			//to show the lower body of the page
			$this->set('showDialog','1');
			if($this->params->query['organ_system']){
				$condition['TemplateSubCategories.organ_system']=$this->params->query['organ_system'];
			}
			$condition['TemplateSubCategories.note_template_id']=$this->params->query['note_Template'];
			$this->Template->bindModel(array(
					'hasMany' => array('TemplateSubCategories' =>array('foreignKey'=>'template_id','conditions'=>array('TemplateSubCategories.is_deleted=0',
							$condition),'order'=>array('ISNULL(TemplateSubCategories.sort_order), TemplateSubCategories.sort_order ASC' )))));
			$roseData=$this->Template->find('all',array('order'=>array('ISNULL(Template.sort_order), Template.sort_order ASC'),
					'conditions'=>array('Template.template_category_id'=>2,'Template.is_deleted=0','Template.is_female_template'=>array(0,$genderKey))));

			$this->set('roseData',$roseData);
		}
		$this->set('patientId',$patientId);
		if($noteId){
			$this->set('noteId',$noteId);
			$bodyChartData = $this->Note->find('first',array('conditions'=>array('id'=>$noteId,'Note.created_by'=>$this->Session->read('userid')),'fields'=>array('body_mark_cordinates','body_mark_desc')));
			$this->set(array('noteId'=>$noteId,'bodyChartData'=>$bodyChartData));
		}
		$templateTypeCon = $this->TemplateTypeContent->find('all',array('fields'=>array('template_id','template_subcategory_id','extra_btn_options'),
				'conditions'=>array('note_id'=>$noteId,'template_category_id'=>2))) ;
		//pr($templateTypeCon);
		$this->set('templateTypeContent',$templateTypeCon);


		$this->set('patientSpecificTemplate',$this->TemplateTypeContent->find('list',array('fields'=>array('template_id','patient_specific_template'),
				'conditions'=>array('note_id'=>$noteId,'template_category_id'=>2))));
		// For extra data display-Aditya
		$extraDataShow=$this->TemplateMiddleCategory->find('all',array('conditions'=>array('TemplateMiddleCategory.patient_id'=>$patientId)));
		$checlElement=$extraDataShow[0][TemplateMiddleCategory][template_subcategory_id];
		foreach($extraDataShow as $newextraDataShow){
			if($checlElement==$newextraDataShow['TemplateMiddleCategory']['template_subcategory_id'])
				$newData[$newextraDataShow['TemplateMiddleCategory']['template_subcategory_id']][]=$newextraDataShow;
			else{
				$checlElement=$newextraDataShow['TemplateMiddleCategory']['template_subcategory_id'];
				$newData[$newextraDataShow['TemplateMiddleCategory']['template_subcategory_id']][]=$newextraDataShow;
			}
		}
		$this->set('extraDataShow',$newData);
		//EOD
		//for insert
		$cntRoe=0;;
		if(!empty($this->request->data['subCategory_examination'])){
			//debug($this->request->data);exit;

			//*****************check for patient iD************************
			//BOF body chart
			if(!empty($this->request->data['subCategory_examination']['body_mark_cordinates'])){
				$combineArray['template_id'] = $this->request->data['subCategory_examination']['template_id'];
				$combineArray['body_mark_cordinates'] = $this->request->data['subCategory_examination']['body_mark_cordinates'];
				$body_mark_cordinates =  serialize($combineArray) ;
			}
			if(empty($noteId)){ //add new entry
				$noteId=$this->Note->addBlankNote($patientId,array('body_mark_cordinates'=>$body_mark_cordinates,
						'body_mark_desc'=>serialize($this->request->data['subCategory_examination']['body_mark_desc'])));
				$this->set('noteId',$noteId);
			}else{ ///else update
				$this->Note->id = $noteId ;
				$this->Note->save(array('body_mark_cordinates'=>$body_mark_cordinates,
						'body_mark_desc'=>serialize($this->request->data['subCategory_examination']['body_mark_desc'])));
			}
			//EOF body chart
			// Extra Data saving options -Aditya
			if(!empty($this->request->data['extra']['name']['0'])){
				$cntRoe++;
			}
			//EOD
			//*************eof****************************
			/*foreach($this->request->data['subCategory_examination'] as $keyRoe=>$checkDataRoe){
				if (in_array("1", $checkDataRoe)) {
			$cntRoe++;
			}
			}*/
			//if($cntRoe>0){
			if(empty($noteId)){
				$noteId=$this->request->data['noteId'];
			}
			else{
				$noteId=$noteId;
			}
			$categoryExaminationData=$this->TemplateTypeContent->insertRosExamination($this->request->data,$noteId,
					$patientId,$organSystem,$this->request->data['extra'],$this->request->data['extra1'],$noteTemplateId);
			//}
			//$this->Session->setFlash(__('Review Of System Added Successfully' ),true,array('class'=>'message'));
			if(empty($noteId)){
				$noteId=$this->request->data['noteId'];
			}

			$this->set('noteIdClose',$noteId);
			$this->redirect(array('controller'=>'notes','action'=>"soapNote",trim($patientId),trim($noteId)));

		}
		//EOF insert
		$tName=$this->NoteTemplate->find('list',array('fields'=>array('id','template_name'),'conditions'=>array('is_deleted'=>'0','template_type'=>array('all','')),'order'=>array('ISNULL(NoteTemplate.sort_order), NoteTemplate.sort_order ASC')));
		//debug($tName);
		$this->set('tName',$tName);
		//for display
	}
	public function getMedication($patientId,$noteId,$personID){
		$this->layout='ajax';
		$this->uses=array('NewCropPrescription','NewCropAllergies','ReferralToSpecialist','TransmittedCcda','Patient','Person','Diagnosis','Patient','ProcedurePerform','VaccineDrug');
		if(!empty($noteId) || $noteId!='null'){
			$this->set('noteId',$noteId);
		}
		$getEncounterID=$this->Note->encounterHandler($patientId,$this->params->query['personId']);
		if(count($getEncounterID)=='1'){
			$getEncounterID=$getEncounterID[0];
		}
		$this->NewCropPrescription->bindModel(array(
				'belongsTo' => array(
						'VaccineDrug' =>array('foreignKey' => false,'conditions'=>array('VaccineDrug.MEDID=NewCropPrescription.drug_id')),
				)));
		$getMedicationRecords=$this->NewCropPrescription->find('all',array('fields'=>array('NewCropPrescription.*','VaccineDrug.MEDID'),'conditions'=>
				array('patient_id'=>$this->params->query['personId'],/* ,'note_id'=>$noteId, */'patient_uniqueid'=>$getEncounterID,'archive'=>'N')));
		// to inactive the medication button
		$getEncounterIDAll=$this->Patient->getAllPatientIds($this->params->query['personId']);
		$this->set('getEncounterIDAll',$getEncounterIDAll);
		$this->set('patientId',$patientId);
		//EOD
		$getAllergyRecords=$this->NewCropAllergies->find('all',array('conditions'=>array('patient_id'=>$this->params->query['personId'],'patient_uniqueid'=>$getEncounterID,'is_deleted'=>'0','status'=>'A')
				,'fields'=>array('name','status','id','CompositeAllergyID','patient_uniqueid','patient_id')));

		if(!empty($getMedicationRecords)){
			$this->Note->updateAll(array('no_med_flag'=>'"no"'),array('Note.patient_id'=> $patientId));
		}

		if(!empty($getAllergyRecords)){
			$this->Note->updateAll(array('no_allergy_flag'=>'"no"'),array('Note.patient_id'=> $patientId));
		}
		$getcheckmed=$this->Note->find('first',array('conditions'=>array('patient_id'=>$patientId,'Note.created_by'=>$this->Session->read('userid')),'fields'=>array('id','no_med_flag','no_allergy_flag','patient_id')));


		if(empty($getcheckmed) || empty($getAllergyRecords) || empty($getMedicationRecords)){
			$checkDiagnosis=$this->Diagnosis->find('first',array('conditions'=>array('patient_id'=>$patientId),'fields'=>array('id','no_med_flag','no_allergy_flag','patient_id')));
			$this->set('checkDiagnosis',$checkDiagnosis);
		}

		if(!empty($getcheckmed)){
			$checkDiagnosisfirst=$this->Diagnosis->find('first',array('conditions'=>array('patient_id'=>$patientId),'fields'=>array('id','no_med_flag','no_allergy_flag','patient_id')));
			if(empty($getcheckmed['Note']['no_med_flag'])){
				$this->Note->updateAll(array('no_med_flag'=>"'".$checkDiagnosisfirst['Diagnosis']['no_med_flag']."'"),array('Note.id'=> $getcheckmed['Note']['id']));
			}
			if(empty($getcheckmed['Note']['no_allergy_flag'])){
				$this->Note->updateAll(array('no_allergy_flag'=>"'".$checkDiagnosisfirst['Diagnosis']['no_allergy_flag']."'"),array('Note.id'=> $getcheckmed['Note']['id']));
			}
			$getcheckmed=$this->Note->find('first',array('conditions'=>array('patient_id'=>$patientId,'Note.created_by'=>$this->Session->read('userid')),
					'fields'=>array('id','no_med_flag','no_allergy_flag','patient_id')));
		}

		$this->set('getcheckmed',$getcheckmed);
		$this->set('data',$getMedicationRecords);
		$this->set('dataAllergy',$getAllergyRecords);
		$this->set('id',$patientId);
		$this->set('personId',$this->params->query['personId']);

		//BOF pankaj fetch referrals
		$this->ReferralToSpecialist->bindModel(array(
				'belongsTo' => array(
						'TransmittedCcda'=>array('foreignKey'=>false,'conditions'=>array('TransmittedCcda.id=ReferralToSpecialist.transmitted_ccda_id'))
				)));
		$ccdaResult = $this->ReferralToSpecialist->find('all',array('conditions'=>array('TransmittedCcda.created_by'=>$this->Session->read('userid'),'ReferralToSpecialist.patient_id'=>$patientId)));
		$this->set('ccdaData',$ccdaResult);
		//EOD

		$procedurePerformResult = $this->ProcedurePerform->find('all',array('conditions'=>array('created_by'=>$this->Session->read('userid'),'patient_id'=>$patientId)));
		//debug($procedurePerformResult);exit;
		$this->set('procedurePerformResult',$procedurePerformResult);
		//EOF fetch referals
		echo $this->render('get_medication');
		exit;

	}


	public function getDiagnosis($patientId,$noteId,$personID){
		$this->layout='ajax';
		//$this->layout=false;
		$this->uses=array('NewCropPrescription');
		$getEncounterID=$this->Note->encounterHandler($patientId,$this->params->query['personId']);
		$getProblem=$this->Note->getDiagnosis($patientId,$noteId,$getEncounterID);
		$this->set('data',$getProblem);
		$this->set('patientId',$patientId);
		$this->set('noteId',$noteId);
		echo $this->render('get_diagnosis');
		exit;

	}
	/* public function getLab($patientId){
		$this->layout='ajax';
	$getLab=$this->Note->getLab($patientId);
	$this->set('data',$getProblem);
	echo $this->render('get_diagnosis');
	exit;

	} */
	//********************************************Load Lab******************************************
	public function getLab($patientId,$noteId){
		$this->uses=array('LabManager','LaboratoryResult');
		/*$this->LabManager->bindModel(array(
		 'belongsTo' => array(
		 		'Laboratory'=>array('foreignKey'=>'laboratory_id','conditions'=>array('Laboratory.is_active'=>1)),
		 		//'LaboratoryToken'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryToken.laboratory_test_order_id.=LabManager.id')),

		 ),
				'hasOne' => array( 'LaboratoryResult'=>array('foreignKey'=>'laboratory_test_order_id') ,
						'LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryHl7Result.laboratory_result_id=LaboratoryResult.id'))// aditya added bind LaboratoryHl7Result
				)),false);*/
		$this->LaboratoryResult->bindModel(array(
				'belongsTo' => array(
						'Laboratory'=>array('foreignKey'=>false,'conditions'=>array('Laboratory.is_active'=>1,'Laboratory.id=LaboratoryResult.laboratory_id')),
						//'LaboratoryCategory'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryCategory.laboratory_id=Laboratory.id')),
						//'LaboratoryParameter'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryCategory.id=LaboratoryParameter.laboratory_categories_id')),
						'LabManager'=>array('foreignKey'=>false,'type'=>'right','conditions'=>array('LaboratoryResult.laboratory_test_order_id=LabManager.id')),
						'LaboratoryAlias'=>array('className'=>'Laboratory','foreignKey'=>false,'conditions'=>array('LaboratoryAlias.is_active'=>1,'LaboratoryAlias.id=LabManager.laboratory_id')),
						//'LabManager'=>array('foreignKey'=>false,'conditions'=>array('LabManager.laboratory_id=Laboratory.id')),
						//'LaboratoryResult'=>array('foreignKey'=>false,'conditions'=>array('LabManager.id = LaboratoryResult.laboratory_test_order_id'))
				),
				'hasOne' => array(
						'LaboratoryToken'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.laboratory_test_order_id=LaboratoryToken.laboratory_test_order_id')),
						//'LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryHl7Result.laboratory_result_id=LaboratoryResult.id'))// aditya added bind LaboratoryHl7Result
				),
				'hasMany' => array(
						'LaboratoryHl7Result'=>array('foreignKey'=>'laboratory_result_id')// aditya added bind LaboratoryHl7Result
				)

		),false);
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'fields'=>array('LaboratoryResult.dhr_laboratory_patient_id','LaboratoryResult.od_universal_service_text','LaboratoryAlias.id','LaboratoryAlias.name','LaboratoryResult.id','LaboratoryResult.laboratory_id','LabManager.batch_identifier','LabManager.id','LabManager.start_date','LabManager.patient_id','LabManager.is_processed',
						'LabManager.patient_id','LabManager.order_id','Laboratory.id','Laboratory.name','Laboratory.lonic_code'
				),
				'conditions'=>array('LabManager.patient_id'=>$patientId,/*'LabManager.note_id'=>$noteId,*/'LabManager.is_deleted'=>0),
				'order' => array(
						'LabManager.id' => 'desc'
				),
				'group'=>array('LabManager.id','LaboratoryResult.id')
		);
		$testOrdered   = $this->paginate('LaboratoryResult');
		$this->set('testOrdered',$testOrdered);
		$this->set('noteId',$noteId);
		echo $this->render('get_lab');
		exit;
	}
	//****************************************Load Rad***********************************************************************
	public function getRad($patientId){
		$this->uses=array('RadiologyTestOrder','RadiologyResult');
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'RadiologyResult' =>array('foreignKey' => false,'conditions'=>array('RadiologyResult.radiology_test_order_id=RadiologyTestOrder.id')),
						'Radiology' =>array('foreignKey' => false,'conditions'=>array('Radiology.id=RadiologyTestOrder.radiology_id')),
				)));
		$getRadiologyTestOrder=$this->RadiologyTestOrder->find('all',array('conditions'=>array('RadiologyTestOrder.patient_id'=>$patientId,/*'RadiologyTestOrder.note_id'=>$_SESSION['noteId'],*/
				'RadiologyTestOrder.is_deleted'=>'0'),'fields'=>array('Radiology.name','RadiologyResult.img_impression','RadiologyResult.id',
						'RadiologyTestOrder.radiology_order_date','RadiologyTestOrder.id','RadiologyTestOrder.patient_id','RadiologyTestOrder.batch_identifier')));

		$RadiologyTestOrderIds=$this->RadiologyTestOrder->find('list',array('conditions'=>array('RadiologyTestOrder.patient_id'=>$patientId),
				'fields'=>array('id','id')));

		$this->RadiologyResult->bindModel(array(
				'hasMany'=>array('RadiologyReport' =>array('foreignKey' =>'radiology_result_id'))));

		$RadiologyResultValues=$this->RadiologyResult->find('all',array('conditions'=>array('RadiologyResult.radiology_test_order_id'=>$RadiologyTestOrderIds)));
		$this->set('resultRadiology',$getRadiologyTestOrder);
		$this->set('RadiologyResultValues',$RadiologyResultValues);
		echo $this->render('get_rad');
		exit;
	}
	//*******************************************************************************************************************
	public function getProPlan($title){
		$this->uses=array('NoteTemplate');
		$getId=$this->NoteTemplate->find('first',array('conditions'=>array('template_name LIKE'=>$title.'%'),'fields'=>array('id')));
		$getTemplateProPlan=$this->Note->getTemplateProPlan($getId['NoteTemplate']['id']);
		$this->set('ros',$getTemplateProPlan);
		$this->set('rosID',$getId['NoteTemplate']['id']);
		echo $this->render('get_pro_plan');
		exit;
	}

	//*******************************************************************************************************************
	public function getSoap($title,$searchFromTemplate){
		$this->uses=array('NoteTemplate','NoteTemplateText');
		if($searchFromTemplate == "true"){
			$getId=$this->NoteTemplate->find('first',array('conditions'=>array('template_name LIKE'=>$title.'%'),'fields'=>array('id')));
		}else{
			$this->autoRender = false;
			//$getTemplateId=$this->NoteTemplateText->find('list',array('conditions'=>array('template_text LIKE'=>$title.'%'),'fields'=>array('template_id')));
			$getTemplateNamesId=$this->NoteTemplate->find('list',array('conditions'=>array('search_keywords like'=>"%".$title."%"),'fields'=>array('id','template_name')));
			echo json_encode($getTemplateNamesId);
			exit;
		}

		$getSubjectiveData=$this->Note->getTemplateSubjective($getId['NoteTemplate']['id']);
		$this->set('subjective',$getSubjectiveData);
		$this->set('subjectiveID',$getId['NoteTemplate']['id']);
			
		$getAssessmentData=$this->Note->getTemplateAssessment($getId['NoteTemplate']['id']);
		$this->set('assessment',$getAssessmentData);
		$this->set('assessmentID',$getId['NoteTemplate']['id']);
		$this->render('get_assessment');
			
		$getObjectiveData=$this->Note->getTemplateObjective($getId['NoteTemplate']['id']);
		$this->set('objective',$getObjectiveData);
		$this->set('objectiveID',$getId['NoteTemplate']['id']);
		$this->render('get_objective');
			
		$getPlanData=$this->Note->getTemplatePlan($getId['NoteTemplate']['id']);
		$this->set('plan',$getPlanData);
		$this->set('planID',$getId['NoteTemplate']['id']);
		$this->render('get_plan');

		$getROSData=$this->Note->getTemplateROS($getId['NoteTemplate']['id']);
		$this->set('ros',$getROSData);
		$this->set('rosID',$getId['NoteTemplate']['id']);
		$this->render('get_ros');
		echo $this->render('get_soap')."|~|".$this->render('get_objective')."|~|".$this->render('get_assessment')."|~|".$this->render('get_plan')."|~|".$this->render('get_ros');
		exit;
			
	}
	public function addTemplateTextProcedure($contentType,$templateID,$templateText,$id=null){
		/* debug($contentType);
		 debug($templateID);
		debug($templateText);
		debug($id);
		exit; */

		$this->uses=array('NoteTemplateText');
		$userId=$_SESSION['Auth']['User']['id'];
		$locationId=$_SESSION['Auth']['User']['location_id'];
		if(!empty($id)){
			$this->NoteTemplateText->updateAll(array('template_text'=>"'$templateText'"),array('id'=>$id));
			if($contentType=='procedure'){
				$getTemplateProPlan=$this->Note->getTemplateProPlan($templateID);
				$this->set('ros',$getTemplateProPlan);
				$this->set('rosID',$templateID);
				echo $this->render('get_pro_plan');
				exit;
			}
		}
		$checkExist=$this->NoteTemplateText->find('first',array('conditions'=>
				array('template_text'=>$templateText,'context_type'=>$contentType)
				,'fields'=>array('id')));
		if(!empty($checkExist)){
			if($contentType=='procedure'){
				$getTemplateProPlan=$this->Note->getTemplateProPlan($templateID);
				$this->set('ros',$getTemplateProPlan);
				$this->set('rosID',$templateID);
				echo $this->render('get_pro_plan');
				exit;
			}
		}
		else{
			$checkSave=$this->NoteTemplateText->save(
					array('user_id'=>$userId,'location_id'=>$locationId,'context_type'=>$contentType,'template_id'=>$templateID,'template_text'=>$templateText));
			if($contentType=='procedure'){
				$getSubjectiveData=$this->Note->getTemplateProcedure($templateID);
				$this->set('ros',$getSubjectiveData);
				$this->set('rosID',$templateID);
				echo $this->render('get_pro_plan');
				exit;
			}
		}
	}
	public function addTemplateText($contentType,$templateID,$templateText,$id=null){
		/* debug($contentType);
		 debug($templateID);
		debug($templateText);
		debug($id); */

		$this->uses=array('NoteTemplateText');
		$userId=$_SESSION['Auth']['User']['id'];
		$locationId=$_SESSION['Auth']['User']['location_id'];
		if(!empty($id)){
			$this->NoteTemplateText->updateAll(array('template_text'=>"'$templateText'"),array('id'=>$id));
			if($contentType=='subjective'){
				$getSubjectiveData=$this->Note->getTemplateSubjective($templateID);
				$this->set('subjective',$getSubjectiveData);
				$this->set('subjectiveID',$templateID);
				echo $this->render('get_soap');
				exit;
			}
			if($contentType==objective){
				$getObjectiveData=$this->Note->getTemplateObjective($templateID);
				$this->set('objective',$getObjectiveData);
				$this->set('objectiveID',$templateID);
				echo $this->render('get_objective');
				exit;
			}
			if($contentType==assessment){
				$getAssessmentData=$this->Note->getTemplateAssessment($templateID);
				$this->set('assessment',$getAssessmentData);
				$this->set('assessmentID',$templateID);
				echo $this->render('get_assessment');
				exit;
			}
			if($contentType==plan){
				$getPlanData=$this->Note->getTemplatePlan($templateID);
				$this->set('plan',$getPlanData);
				$this->set('planID',$templateID);
				echo $this->render('get_plan');
				exit;
			}
			if(trim($contentType)=='review of system'){
				$getRosData=$this->Note->getTemplateROS($templateID);
				$this->set('ros',$getRosData);
				$this->set('rosID',$templateID);
				echo $this->render('get_ros');
				exit;
			}
		}
		//**************check For exists****************************************
		$checkExist=$this->NoteTemplateText->find('first',array('conditions'=>
				array('template_text'=>$templateText,'context_type'=>$contentType)
				,'fields'=>array('id')));
		if(!empty($checkExist)){
			if($contentType=='subjective'){
				$getSubjectiveData=$this->Note->getTemplateSubjective($templateID);
				$this->set('subjective',$getSubjectiveData);
				echo $this->render('get_soap');
				exit;
			}
			if($contentType=='objective'){
				$getObjectiveData=$this->Note->getTemplateObjective($templateID);
				$this->set('objective',$getObjectiveData);
				echo $this->render('get_objective');
				exit;
			}
			if($contentType==assessment){
				$getAssessmentData=$this->Note->getTemplateAssessment($templateID);
				$this->set('assessment',$getAssessmentData);
				echo $this->render('get_assessment');
				exit;
			}
			if($contentType==plan){
				$getPlanData=$this->Note->getTemplatePlan($templateID);
				$this->set('plan',$getPlanData);
				echo $this->render('get_plan');
				exit;
			}
			if($contentType=='review of system'){
				$getRosData=$this->Note->getTemplateROS($templateID);
				$this->set('ros',$getRosData);
				echo $this->render('get_ros');
				exit;
			}

		}
		else{
			//**********************************************************************
			$checkSave=$this->NoteTemplateText->save(
					array('user_id'=>$userId,'location_id'=>$locationId,'context_type'=>$contentType,'template_id'=>$templateID,'template_text'=>$templateText));
			if($contentType=='subjective'){
				$getSubjectiveData=$this->Note->getTemplateSubjective($templateID);
				$this->set('subjective',$getSubjectiveData);
				$this->set('subjectiveID',$templateID);
				echo $this->render('get_soap');
				exit;
			}
			if($contentType=='objective'){
				$getObjectiveData=$this->Note->getTemplateObjective($templateID);
				$this->set('objective',$getObjectiveData);
				$this->set('objectiveID',$templateID);
				echo $this->render('get_objective');
				exit;
			}
			if($contentType=='assessment'){
				$getAssessmentData=$this->Note->getTemplateAssessment($templateID);
				$this->set('assessment',$getAssessmentData);
				$this->set('assessmentID',$templateID);
				echo $this->render('get_assessment');
				exit;
			}
			if($contentType=='plan'){
				$getPlanData=$this->Note->getTemplatePlan($templateID);
				$this->set('plan',$getPlanData);
				$this->set('planID',$templateID);
				echo $this->render('get_plan');
				exit;
			}
			if($contentType=='review of system'){
				$getRosData=$this->Note->getTemplateROS($templateID);
				$this->set('ros',$getRosData);
				$this->set('rosID',$templateID);
				echo $this->render('get_ros');
				exit;
			}
		}
			
	}
	public function deleteTemplateTextProcedure($id,$template_id,$type){
		$this->uses=array('NoteTemplateText');
		$this->NoteTemplateText->delete(array('id'=>$id));
		if($type=='procedure'){
			$getTemplateProPlan=$this->Note->getTemplateProPlan($template_id);
			$this->set('ros',$getTemplateProPlan);
			$this->set('rosID',$template_id);
			echo $this->render('get_pro_plan');
			exit;
		}
	}
	public function deleteTemplateText($id,$template_id,$type){
		$this->uses=array('NoteTemplateText');
		$this->NoteTemplateText->delete(array('id'=>$id));
		if($type=='subjective'){
			$getSubjectiveData=$this->Note->getTemplateSubjective($template_id);
			$this->set('subjective',$getSubjectiveData);
			$this->set('subjectiveID',$template_id);
			echo $this->render('get_soap');
			exit;
		}
		if($type=='objective'){
			$getObjectiveData=$this->Note->getTemplateObjective($template_id);
			$this->set('objective',$getObjectiveData);
			$this->set('objectiveID',$template_id);
			echo $this->render('get_objective');
			exit;
		}
		if($type=='Assessment'){
			$getAssessmentData=$this->Note->getTemplateAssessment($template_id);
			$this->set('assessment',$getAssessmentData);
			$this->set('assessmentID',$template_id);
			echo $this->render('get_assessment');
			exit;
		}
		if($type=='plan'){
			$getPlanData=$this->Note->getTemplatePlan($template_id);
			$this->set('plan',$getPlanData);
			$this->set('planID',$template_id);
			echo $this->render('get_plan');
			exit;
		}
		if($type=='review of system'){
			$getRosData=$this->Note->getTemplateROS($template_id);
			$this->set('ros',$getRosData);
			$this->set('rosID',$template_id);
			echo $this->render('get_ros');
			exit;
		}
	}
	public function addTempleteTitle($title){
		$this->layout=advance;
		$this->uses=array('NoteTemplate');
		$data['NoteTemplate']['user_id']=$_SESSION['Auth']['User']['id'];
		$data['NoteTemplate']['department_id']=$_SESSION['Auth']['User']['department_id'];
		$data['NoteTemplate']['location_id']=$_SESSION['Auth']['User']['location_id'];
		$data['NoteTemplate']['template_name']=$title;
		$data['NoteTemplate']['template_type']='all';
		$data['NoteTemplate']['is_deleted']='0';
		//debug($data['NoteTemplate']);
		if($this->NoteTemplate->save($data['NoteTemplate'])){
			//echo $this->Session->setFlash(__('Title Title have been saved', true, array('class'=>'message')));
			echo $title;
		}
		else{
			//echo $this->Session->setFlash(__('Please Try Again' ),true,array('class'=>'error'));
			echo $title;
		}
		exit;
	}
	public function searchTemplateTextProcedure($searchText,$type,$templateId){
		$this->uses=array('NoteTemplateText');
		$getSubSearch=$this->NoteTemplateText->find('all',array('conditions'=>
				array('context_type'=>$type,'template_id'=>$templateId,'template_text LIKE'=>$searchText."%")));
		if($type=='procedure'){
			$this->set('ros',$getSubSearch);
			$this->set('rosID',$templateId);
			echo $this->render('get_pro_plan');
		}
		exit;
	}
	public function searchTemplateText($searchText,$type,$templateId){
		$this->uses=array('NoteTemplateText');
		$getSubSearch=$this->NoteTemplateText->find('all',array('conditions'=>
				array('context_type'=>$type,'template_id'=>$templateId,'template_text LIKE'=>$searchText."%")));
		if($type=='subjective'){
			$this->set('subjective',$getSubSearch);
			$this->set('subjectiveID',$templateId);
			echo $this->render('get_soap');
		}
		if($type=='objective'){
			$this->set('objective',$getSubSearch);
			$this->set('objectiveID',$templateId);
			echo $this->render('get_objective');
		}
		if($type=='assessment'){
			$this->set('assessment',$getSubSearch);
			$this->set('assessmentID',$templateId);
			echo $this->render('get_assessment');
		}
		if($type=='plan'){
			$this->set('plan',$getSubSearch);
			$this->set('planID',$templateId);
			echo $this->render('get_plan');
		}
		if($type=='review of system'){
			$this->set('ros',$getSubSearch);
			$this->set('rosID',$templateId);
			echo $this->render('get_ros');
		}
		exit;

	}
	/** New Vitals **/
	public function getInitalDataNew($patientId,$fromSoap){
		$this->uses=array('Patient','Diagnosis','BmiResult','BmiBpResult');
		$this->BmiResult->bindModel(array(
				'belongsTo' => array('BmiBpResult'=>array('conditions'=>array('BmiBpResult.bmi_result_id=BmiResult.id'),'foreignKey'=>false)
				)));
		$result1 = $this->BmiResult->find('first',array('fields'=>array('temperature','temperature1','temperature2','myoption','myoption1','myoption2','respiration','respiration_volume','BmiBpResult.systolic','BmiBpResult.systolic1',
				'BmiBpResult.systolic2','BmiBpResult.diastolic','BmiBpResult.diastolic1','BmiBpResult.diastolic2','BmiBpResult.pulse_text','BmiBpResult.pulse_text1','BmiBpResult.pulse_text2',
				'BmiBpResult.pulse_volume','BmiBpResult.pulse_volume1','BmiBpResult.pulse_volume2'),
				'conditions'=>array('patient_id'=>$patientId,'appointment_id'=>$_SESSION['apptDoc'])));
		return $result1;
	}
	/** EOD **/
	public function getInitalData($patientId,$fromSoap,$noteId){
		$this->uses=array('Patient','Diagnosis');
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'BmiResult' =>array('foreignKey' => false,'conditions'=>array('Patient.id=BmiResult.patient_id' )),
						'BmiBpResult' =>array('foreignKey' => false,'conditions'=>array('BmiResult.id =BmiBpResult.bmi_result_id' ),'order'=>array('BmiBpResult.id DESC')),
				)));
		$admissionDateAndVitals = $this->Patient->find('all',array('fields'=>array('Patient.form_received_on','BmiResult.temperature','BmiResult.myoption',
				'BmiResult.equal_value','BmiResult.temperature','BmiResult.respiration','BmiResult.date',
				'BmiBpResult.pulse_text','BmiBpResult.systolic','BmiBpResult.diastolic',
				'BmiResult.chief_complaint','BmiResult.pain','BmiResult.location','BmiResult.duration','BmiResult.frequency','BmiResult.spo'
				,'BmiResult.sposelect'),
				'conditions'=>array('Patient.id'=>$patientId,'BmiResult.note_id'=>$noteId),'limit'=>'1'));//aditya
		$assessmentVitals = array('temp'=>$admissionDateAndVitals['0']['BmiResult']['temperature'],'rr'=>$admissionDateAndVitals['0']['BmiResult']['respiration'],
				'pr'=>$admissionDateAndVitals['0']['BmiBpResult']['pulse_text'],'bp'=>$admissionDateAndVitals['0']['BmiBpResult']['systolic']."/".$admissionDateAndVitals['0']['BmiBpResult']['diastolic'],
				//'cc'=>$admissionDateAndVitals['0']['BmiResult']['chief_complaint'],
				'note_date'=>$admissionDateAndVitals['0']['BmiResult']['date'],
				'spo2'=>$admissionDateAndVitals['0']['BmiResult']['spo'],
				'location'=>$admissionDateAndVitals['0']['BmiResult']['location'],
				'duration'=>$admissionDateAndVitals['0']['BmiResult']['duration'],
				'pain'=>$admissionDateAndVitals['0']['BmiResult']['pain'],
				'frequency'=>$admissionDateAndVitals['0']['BmiResult']['frequency'],
				'spo'=>$admissionDateAndVitals['0']['BmiResult']['sposelect']
		);
		if($fromSoap!='0'){
			echo json_encode ($assessmentVitals);
			exit;
		}
		else{
			$getComplaints=$this->Diagnosis->find('first',array('fields'=>array('complaints','family_tit_bit'),'conditions'=>array('patient_id'=>$patientId)));
			//$this->set('DiaCC',$getComplaints['Diagnosis']['complaints']);
			$assessmentIntialsVitals['Note']=$assessmentVitals;
			$assessmentIntialsVitals['Note'][cc]=$getComplaints['Diagnosis']['complaints'];
			$assessmentIntialsVitals['Note'][family_tit_bit]=$getComplaints['Diagnosis']['family_tit_bit'];


			return $assessmentIntialsVitals;
		}

	}
	public function getInitalDataForSoap($patientId){
		$this->uses=array('Patient','Note');
		$getComplaints=$this->Note->find('first',array('fields'=>array('cc','family_tit_bit'),
				'conditions'=>array('patient_id'=>$patientId,'Note.created_by'=>$this->Session->read('userid'))));
		//$this->set('DiaCC',$getComplaints['Diagnosis']['complaints']);

		$assessmentSoapVitals['Note'][cc]=$getComplaints['Note']['complaints'];
		$assessmentSoapVitals['Note'][family_tit_bit]=$getComplaints['Note']['family_tit_bit'];
			
			
		return $assessmentSoapVitals;

	}
	//***************************************************************
	public function dragon($notetype=null){
		$this->layout=false;
		$this->set('notetype',$notetype);

	}
	//***************************************************************
	public function addLab($patientId,$noteId=null,$flagSbar=null,$appt=null){
		$this->layout='ajax';
		$this->uses = array('NoteDiagnosis','Note','Appointment','ServiceProvider','LaboratoryTestOrder','LaboratoryResult','Laboratory','SpecimenCondition','SpecimenRejection','SpecimenType','SpecimenAction','LaboratoryToken');
		$spec_rej  = $this->SpecimenRejection->find('list',array('fields'=>array('SpecimenRejection.description','SpecimenRejection.description'),'order' => array('SpecimenRejection.description ASC')));
		$spec_cond  = $this->SpecimenCondition->find('list',array('fields'=>array('SpecimenCondition.description','SpecimenCondition.description'),'order' => array('SpecimenCondition.description ASC')));
		$spec_type  = $this->SpecimenType->find('list',array('fields'=>array('SpecimenType.description','SpecimenType.description'),'order' => array('SpecimenType.description ASC')));
		$spec_action  = $this->SpecimenAction->find('list',array('fields'=>array('SpecimenAction.description','SpecimenAction.description'),'order' => array('SpecimenAction.description ASC')));
		$serviceProviders = $this->ServiceProvider->find('list',array('fields' => array('id','name'),'conditions'=>array('category'=>'lab','location_id'=>$this->Session->read('locationid'),'status'=>1,'is_deleted'=>0)));
		if(!empty($this->params->query['ajaxFlag'])){
			$ajaxHold=$this->params->query['ajaxFlag'];
			$this->set('ajaxHold',$ajaxHold);
		}
		if(!empty($this->params->query['returnUrl'])){
			$this->set('returnUrl',$this->params->query['returnUrl']);
		}
		if(!empty($this->params->query['labRad'])){
			$this->set('labRad',$this->params->query['labRad']);

		}
		if(!empty($flagSbar)){
			$this->set('flagSbar',$flagSbar);
		}
		if(!empty($appt)){

			$this->Appointment->bindModel(array(
					'belongsTo'=>array(
							'DoctorProfile'=>array(
									'foreignKey'=> false,
									'conditions' => array('Appointment.doctor_id = DoctorProfile.user_id'),

							),)));
			$getDName=$this->Appointment->find('first',array('fields'=>array('DoctorProfile.doctor_name'),'conditions'=>array('Appointment.id'=>$appt)));
			$this->set('dName',$getDName['DoctorProfile']['doctor_name']);
			$this->set('appt',$appt);
			//	$this->set('flagSbar',$flagSbar);
		}
		$accesionId = $this->LaboratoryTestOrder->autoGeneratedLabID(null);
		$this->set('accesionId',$accesionId);
		$this->set('serviceProviders',$serviceProviders);
		$this->set(compact('patientId','spec_rej','spec_cond','spec_type','spec_action')) ;
		$this->set('patientId',$patientId);
		$this->set('noteId',$noteId);
		//$this->set('flagSbar',$flagSbar);

		$diagnosesData = $this->NoteDiagnosis->find('list',array('conditions'=>array('patient_id'=>$patientId),'fields'=>array('icd_id','diagnoses_name')));

		$this->set('diagnosesData',$diagnosesData);
		if(isset($this->request->data) && !empty($this->request->data)){
			//debug($this->request->data);exit;
			if($this->request->data['LaboratoryTestOrder']['isIMO']=='yes'){
				$LaboratCheck = $this->Laboratory->find('first',array('fields'=>array('id'),
						'conditions'=>array('name'=>$this->request->data["LaboratoryToken"]["testname"])
				));
				if(empty($LaboratCheck))
				{
					$this->Laboratory->saveAll(array('is_active'=>1,'name'=>$this->request->data["LaboratoryToken"]["testname"],'lonic_code'=>$this->request->data["LaboratoryTestOrder"]["lonic_code"],
							'cpt_code'=>$this->request->data["LaboratoryTestOrder"]["cpt_code"]));

					$this->request->data['LaboratoryTestOrder']['lab_id']=$this->Laboratory->getLastInsertId();
					$this->request->data['LaboratoryToken']['laboratory_id']=$this->Laboratory->getLastInsertId();
				}
				else
				{
					$this->request->data['LaboratoryTestOrder']['lab_id']=$LaboratCheck['Laboratory']['id'];
					$this->request->data['LaboratoryToken']['laboratory_id']=$LaboratCheck['Laboratory']['id'];
				}
			}
			$getSaveResult=$this->LaboratoryTestOrder->insertMultipleTestOrder($this->request->data,$patientId);
			///BO
			if($getSaveResult['dbState']=='save'){
				$this->loadModel('Appointment') ;
				$timeDiff=$this->Appointment->find('first',array('fields'=>array('id','arrived_time'),'conditions'=>array('Appointment.id'=>$_SESSION['apptDoc'])));
				$start=$timeDiff['Appointment']['date'].' '.$timeDiff['Appointment']['arrived_time'];
				$elapsed=$this->DateFormat->dateDiff($start,date('Y-m-d H:i')) ;
				if($elapsed->i!=0){
					$min=$elapsed->i;
				}else{
					$min='00';
				}
				if($elapsed->h!=0){
					if($elapsed->h>=12){
						$hrs=$elapsed->h-12;
					}
					else{
						$hrs=$elapsed->h;
					}
					$hrs= ($hrs * 60);
					$showTime=$hrs+$min;

				}else{
					$showTime=$min;
				}
				if(empty($noteId) || ($noteId=='null')){
					$this->Note->save(array('patient_id'=>$patientId,'create_time'=>date('Y-m-d H:i:s')));
					$lastIdByLab=$this->Note->getLastInsertID();
				}
				$res=$this->Appointment->updateAll(array('status'=>"'Seen'",'elapsed_time'=>$showTime),array('Appointment.is_future_app'=>0,'Appointment.id'=>$_SESSION['apptDoc']));
				//$this->redirect('/Appointments/appointments_management');
					
			}
			//EOF status
			if(!empty($getSaveResult)){
				if($getSaveResult['dbState']=='sbar'){
					echo 'sbar';
					exit;

				}else{
					echo $lastIdByLab;
					exit;

				}

			}
			else{
				//echo $this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
				//echo $this->request->data["LaboratoryToken"]["sbar"];
				exit;
			}
		}
	}
	/**
	 * get add more Html for lab
	 */
	public function addLabHtml(){
		$this->layout = false;

	}

	public function transmitLab($accessionId){
		$this->layout = false;
		$this->uses = array('LaboratoryTestOrder');
		$this->LaboratoryTestOrder->updateAll(array('is_processed'=>'0'),array('order_id'=>$accessionId)) ;
		exit;
	}
	public function addRad($patientId,$noteId=null,$appt=null,$flag=null){
		$this->layout=ajax;
		$this->uses = array('Appointment','Radiology','ServiceProvider','RadiologyTestOrder');
		if(!empty($this->params->query['ajaxFlag'])){
			$ajaxHold=$this->params->query['ajaxFlag'];
			$this->set('ajaxHold',$ajaxHold);
		}
		if(!empty($this->params->query['returnUrl'])){
			$this->set('returnUrl',$this->params->query['returnUrl']);

		}
		$this->set('noteId',$noteId);
		$this->set('patientId',$patientId);
		if(!empty($this->params->query['labRad'])){
			$this->set('labRad',$this->params->query['labRad']);

		}
		if(!empty($flag)){
			$this->set('flag',$flag);
		}
		$radTest  = $this->Radiology->find('list',array('fields'=>array('Radiology.id','Radiology.name','Radiology.test_code','lonic_code','sct_concept_id'),'order' => array('Radiology.name ASC')));
		$serviceProviders = $this->ServiceProvider->find('list',array('fields' => array('id','name'),'conditions'=>array('category'=>'lab','location_id'=>$this->Session->read('locationid'),'status'=>1,'is_deleted'=>0)));

		$accesionIdRad = $this->RadiologyTestOrder->autoGeneratedRadID(null);
		$this->set('accesionIdRad',$accesionIdRad);
		$this->Appointment->bindModel(array(
				'belongsTo'=>array(
						'DoctorProfile'=>array(
								'foreignKey'=> false,
								'conditions' => array('Appointment.doctor_id = DoctorProfile.user_id'),
									
						),)));

		if(!empty($appt)){
			$getDName=$this->Appointment->find('first',array('fields'=>array('DoctorProfile.doctor_name'),'conditions'=>array('Appointment.id'=>$appt)));
			$this->set('dName',$getDName['DoctorProfile']['doctor_name']);
		}
		$this->set('serviceProviders',$serviceProviders);
		$this->set(compact('patientId','radTest')) ;


		if(isset($this->request->data) && !empty($this->request->data)){
			$radCheck = $this->Radiology->find('first',array('fields'=>array('id','name','cpt_code','test_code','lonic_code','sct_concept_id'),'conditions'=>array('Radiology.name like'=>'%'.$this->request->data["RadiologyTestOrder"]["testname"].'%')));
			//$log = $this->Radiology->getDataSource()->getLog(false, false);;
			if(empty($radCheck["Radiology"]["cpt_code"])){

				//cpt code not found insert into radiology table.
				$getRadResult1=$this->Radiology->saveAll(array('cpt_code'=>$this->request->data["RadiologyTestOrder"]["cpt_code"],'name'=>$this->request->data["RadiologyTestOrder"]["testname"],'sct_concept_id'=>$this->request->data["RadiologyTestOrder"]["sct_concept_id"],'is_active'=>1));

				//$log = $this->Laboratory->getDataSource()->getLog(false, false);
				$this->request->data["RadiologyTestOrder"]["sct_concept_id"] = $this->request->data["RadiologyTestOrder"]["sct_concept_id"];
				$this->request->data["RadiologyTestOrder"]["cpt_code"] = $this->request->data["RadiologyTestOrder"]["cpt_code"];
				$this->request->data["RadiologyTestOrder"]["testname"] = $this->request->data["RadiologyTestOrder"]["testname"];
				$this->request->data["RadiologyTestOrder"]["testcode"] = $this->request->data["RadiologyTestOrder"]["cpt_code"];
				$this->request->data["RadiologyTestOrder"]["testcode"] = $this->request->data["RadiologyTestOrder"]["testcode"];
				$this->request->data["RadiologyTestOrder"]["additional_notes"] = $this->request->data["RadiologyTestOrder"]["additional_notes"];

			}else{
				//exit;
				$this->request->data["RadiologyTestOrder"]["sct_concept_id"] = $this->request->data["RadiologyTestOrder"]["sct_concept_id"];
				$this->request->data["RadiologyTestOrder"]["cpt_code"] = $this->request->data["RadiologyTestOrder"]["cpt_code"];
				$this->request->data["RadiologyTestOrder"]["testname"] = $this->request->data["RadiologyTestOrder"]["testname"];
				$this->request->data["RadiologyTestOrder"]["testcode"] = $this->request->data["RadiologyTestOrder"]["cpt_code"];
				$this->request->data["RadiologyTestOrder"]["additional_notes"] = $this->request->data["RadiologyTestOrder"]["additional_notes"];
				//exit;
			}
			$getRadResult=$this->RadiologyTestOrder->insertRadioTestOrder($this->request->data,'insert');
			//debug($getRadResult);exit;
			if(!empty($getRadResult)){
				//echo $this->Session->setFlash(__('Radiology Test have been saved', true, array('class'=>'message')));
				echo $this->request->data["RadiologyTestOrder"]["sbar"];
				exit;
			}
			else{
					
				$this->loadModel('Appointment') ;
				$timeDiff=$this->Appointment->find('first',array('fields'=>array('id','arrived_time'),'conditions'=>array('Appointment.id'=>$_SESSION['apptDoc'])));
				$start=$timeDiff['Appointment']['date'].' '.$timeDiff['Appointment']['arrived_time'];
				$elapsed=$this->DateFormat->dateDiff($start,date('Y-m-d H:i')) ;
				if($elapsed->i!=0){
					$min=$elapsed->i;
				}else{
					$min='00';
				}
				if($elapsed->h!=0){
					if($elapsed->h>=12){
						$hrs=$elapsed->h-12;
					}
					else{
						$hrs=$elapsed->h;
					}
					$hrs= ($hrs * 60);
					$showTime=$hrs+$min;

				}else{
					$showTime=$min;
				}
				if(empty($this->request->data['RadiologyTestOrder']['noteId']) || ($this->request->data['RadiologyTestOrder']['noteId']=='null')){
					$this->Note->save(array('patient_id'=>$patientId,'create_time'=>date('Y-m-d H:i:s')));
					$lastIdByLab=$this->Note->getLastInsertID();
				}

				$res=$this->Appointment->updateAll(array('status'=>"'Seen'",'elapsed_time'=>$showTime),array('Appointment.is_future_app'=>0,'Appointment.id'=>$_SESSION['apptDoc']));
				//setting note IDs
				if(empty($this->request->data['RadiologyTestOrder']['noteId']) || ($this->request->data['RadiologyTestOrder']['noteId']=='null'))
					$this->request->data["RadiologyTestOrder"]["sbar"]=$lastIdByLab;
				else
					$this->request->data["RadiologyTestOrder"]["sbar"]=$this->request->data['RadiologyTestOrder']['noteId'];
				echo $this->request->data["RadiologyTestOrder"]["sbar"];
				exit;
			}

		}
	}
	public function checkNoteIdForDiagnosis($patientId){
		$this->uses=array('Note');
		$this->Note->save(array('patient_id'=>$patientId,'create_time'=>date('Y-m-d H:i:s')));
		$noteId=$this->Note->getLastInsertID();
		echo $noteId;
		exit;

	}
	public function postiveCheck($patientId,$postive=null,$noteId=null){
		$this->uses=array('Note');
		if(empty($noteId)){
			$this->Note->save(array('patient_id'=>$patientId,'positive_id'=>$postive));
			$noteId=$this->Note->getLastInsertID();
			echo $noteId;
		}
		else{
			$this->Note->save(array('patient_id'=>$patientId,'positive_id'=>$postive,'id'=>$noteId));
			echo 'save';
		}
		exit;

	}
	public function infomedication($drugids=null,$newcrop_id=null){

		//echo $medicationname ."<br/>";

		$medicationName =str_replace("~","/",$medicationname);
		//echo $medicationName ."<br/>";

		$this->uses=array('NewCropPrescription','PharmacyItem');
		$this->layout = 'ajax' ;
		$this->autoRender = false ;

		//update newcrop prescription table PrintLeaflet
		$value['PrintLeaflet'] = "T" ;
		$value['id'] = $newcrop_id;

		$updatePrintLeaflet=$this->NewCropPrescription->save($value);
		//$get_rxnorm_code=$this->NewCropPrescription->find('first',array('fields'=>array('rxnorm'),'conditions'=>array('NewCropPrescription.description'=>$medicationName)));

		//$rxnorm = $get_rxnorm_code['NewCropPrescription']['rxnorm'];
		//echo $rxnorm ."<br/>";
		//$drug_id=$this->PharmacyItem->find('first',array('fields'=>array('drug_id'),'conditions'=>array('PharmacyItem.name'=>$medicationName)));
		//$drug_id=$drug_id['PharmacyItem']['drug_id'];

		$url= "http://apps.nlm.nih.gov/medlineplus/services/mpconnect_service.cfm?mainSearchCriteria.v.cs=2.16.840.1.113883.6.88&mainSearchCriteria.v.c=$rxnorm&informationRecipient.languageCode.c=en";
		//echo $url ."<br/>";exit;
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_FAILONERROR, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($curl);
		$xmldata = simplexml_load_string($result);
		//	echo "<pre>";print_r($xmldata);
		$get_details=$xmldata->entry->title;
		$get_link=$xmldata->entry->id;
		//	echo "<pre>";print_r($xmldata->entry->id);exit;
		$get_url= explode(":",$get_link[0]);
		$new_url= 'http://www.nlm.nih.gov'.$get_url[2];
		//	echo $new_url;
		if($get_details[0]!=''){
			//$this->set('get_details',$get_details[0]);
			//$this->set('new_url',$new_url);
			//http://preproduction.newcropaccounts.com/Pages/Handouts.aspx?search=556724&searchType=m&drugStandardType=F&reference=ok
			$new_url=Configure::read('SOAPUrl')."Pages/Handouts.aspx?search=".$drugids."&searchType=L&drugStandardType=F&reference=OK";

			echo $new_url;
		}
		else{
			if($drugids!="")
			{
				$new_url=Configure::read('SOAPUrl')."Pages/Handouts.aspx?search=".$drugids."&searchType=L&drugStandardType=F&reference=OK";

				echo $new_url;
			}


			//$this->set('get_details','');
		}

	}
	function editLab($id){//debug($this->request->data);exit;
		$this->layout=ajax;
		//$this->autoRender = false;
		//$this->layout = 'ajax';
		$this->uses = array('NoteDiagnosis','ServiceProvider','SpecimenRejection','LaboratoryTestOrder','LaboratoryToken','Laboratory','SpecimenCondition','SpecimenType','SpecimenAction','SpecimenCollectionOption');
		if(isset($this->request->data) && !empty($this->request->data)){
			$this->request->data['LaboratoryToken']['modified_by']=$_SESSION['Auth']['User']['id'];
			$this->request->data['LaboratoryToken']['modify_time']=date('Y-m-d H:i:s');
			$this->request->data['LaboratoryTestOrder']['start_date']= $this->DateFormat->formatDate2STD($this->request->data['LaboratoryTestOrder']['start_date'],Configure::read('date_format'));
			$this->request->data['LaboratoryTestOrder']['lab_order_date']= $this->DateFormat->formatDate2STD($this->request->data['LaboratoryTestOrder']['lab_order_date'],Configure::read('date_format'));
			$this->request->data['LaboratoryToken']['question']= serialize($this->request->data['LaboratoryTokenSerialize']);
			$this->LaboratoryToken->saveAll($this->request->data['LaboratoryToken']);
			$this->LaboratoryTestOrder->saveAll($this->request->data['LaboratoryTestOrder']);
			exit;
		}
		$spec_rej  = $this->SpecimenRejection->find('list',array('fields'=>array('SpecimenRejection.description','SpecimenRejection.description'),'order' => array('SpecimenRejection.description ASC')));
		$spec_cond  = $this->SpecimenCondition->find('list',array('fields'=>array('SpecimenCondition.description','SpecimenCondition.description'),'order' => array('SpecimenCondition.description ASC')));
		$spec_type  = $this->SpecimenType->find('list',array('fields'=>array('SpecimenType.description','SpecimenType.description'),'order' => array('SpecimenType.description ASC')));
		$spec_action  = $this->SpecimenAction->find('list',array('fields'=>array('SpecimenAction.description','SpecimenAction.description'),'order' => array('SpecimenAction.description ASC')));
		$serviceProviders = $this->ServiceProvider->find('list',array('fields' => array('id','name'),'conditions'=>array('category'=>'lab','location_id'=>$this->Session->read('locationid'),'status'=>1,'is_deleted'=>0)));
		$this->set('serviceProviders',$serviceProviders);
		$this->set(compact('patientId','spec_rej','spec_cond','spec_type','spec_action')) ;

		/* 		debug($getId['LaboratoryToken']['id']);
		 exit; */
		$this->LaboratoryToken->bindModel(array(
				'belongsTo'=>array(
						'Laboratory'=>array(
								'foreignKey'=> false,
								'conditions' => array('Laboratory.id = LaboratoryToken.laboratory_id'),
									
						),
						'LaboratoryTestOrder'=>array(
								'foreignKey'=> false,
								'conditions' => array('LaboratoryTestOrder.id = LaboratoryToken.laboratory_test_order_id'),
									
						)


				)));



		$token_data = $this->LaboratoryToken->find('first',array('fields'=>array('LaboratoryTestOrder.id','LaboratoryToken.laboratory_test_order_id',
				'LaboratoryTestOrder.start_date','LaboratoryToken.priority','LaboratoryToken.frequency','LaboratoryToken.id',
				'LaboratoryTestOrder.specimen_type_option','LaboratoryTestOrder.lab_order','LaboratoryTestOrder.lab_order_date','LaboratoryTestOrder.order_id','Laboratory.name','Laboratory.cpt_code',
				'Laboratory.sct_concept_id','Laboratory.lonic_code','Laboratory.id','Laboratory.test_code','LaboratoryToken.specimen_type_id',
				'Laboratory.specimen_collection_type','LaboratoryToken.id','LaboratoryToken.ac_id','LaboratoryToken.collected_date','LaboratoryToken.end_date','LaboratoryToken.status',
				'LaboratoryToken.sample','LaboratoryToken.bill_type','LaboratoryToken.account_no','LaboratoryToken.patient_id','LaboratoryToken.rej_reason_txt',
				'LaboratoryToken.specimen_condition_id','LaboratoryToken.specimen_rejection_id','LaboratoryToken.alt_spec',
				'LaboratoryToken.alt_spec_cond','LaboratoryToken.cond_org_txt','LaboratoryToken.specimen_action_id','LaboratoryTestOrder.service_provider_id'
				,'LaboratoryToken.relevant_clinical_info','LaboratoryToken.primary_care_pro','Laboratory.dhr_order_code','LaboratoryToken.question','LaboratoryTestOrder.patient_id','diagnosis'),
				'conditions'=>array('LaboratoryToken.laboratory_test_order_id'=>$id)));
		$this->set('token_data',$token_data);

		$specimenData = $this->SpecimenCollectionOption->find('list',array('fields'=>array('id','name'),'conditions'=>array('SpecimenCollectionOption.laboratory_id'=>$token_data['Laboratory']['id'],'SpecimenCollectionOption.is_deleted'=>'0')));

		$diagnosesData = $this->NoteDiagnosis->find('list',array('conditions'=>array('patient_id'=>$token_data['LaboratoryTestOrder']['patient_id']),'fields'=>array('diagnoses_name','diagnoses_name')));

		$this->set('diagnosesData',$diagnosesData);

		$this->loadModel('LaboratoryAoeCode');

		$aoeCodes = $this->LaboratoryAoeCode->find('list',array('fields'=>array('id','question'),'conditions'=>array('dhr_obr_code'=>$token_data['Laboratory']['dhr_order_code'])));
		$this->set('aoeCodes',$aoeCodes);

		$this->set('specimenData',$specimenData);
		$this->set('tokenId',$token_data['LaboratoryToken']['id']);

		//exit;

	}
	public function editRad($id){
		$this->layout='ajax';
		$this->uses = array('RadiologyTestOrder','Radiology');

		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo'=>array(
						'Radiology'=>array(
								'foreignKey'=> false,
								'conditions' => array('Radiology.id = RadiologyTestOrder.radiology_id'),
									
						))));

		$test_data = $this->RadiologyTestOrder->find('first',array('fields'=>array('RadiologyTestOrder.id','RadiologyTestOrder.order_id','RadiologyTestOrder.radiology_order','RadiologyTestOrder.service_provider_id','RadiologyTestOrder.start_date','RadiologyTestOrder.is_procedure','RadiologyTestOrder.radiology_order','RadiologyTestOrder.radiology_order_date','Radiology.name','Radiology.cpt_code','Radiology.sct_concept_id','Radiology.lonic_code','Radiology.test_code','RadiologyTestOrder.relevant_clinical_info','RadiologyTestOrder.primary_care_pro'),'conditions'=>array('RadiologyTestOrder.id'=>$id)));
		$this->set('test_data',$test_data);
		if(isset($this->request->data) && !empty($this->request->data) ){
			$this->request->data['RadiologyTestOrder']['modified_by']=$_SESSION['Auth']['User']['id'];
			$this->request->data['RadiologyTestOrder']['modify_time']=date('Y-m-d H:i:s');
			$this->request->data['RadiologyTestOrder']['start_date']= $this->DateFormat->formatDate2STD($this->request->data['RadiologyTestOrder']['start_date'],Configure::read('date_format'));
			$this->request->data['RadiologyTestOrder']['radiology_order_date']= $this->DateFormat->formatDate2STD($this->request->data['RadiologyTestOrder']['radiology_order_date'],Configure::read('date_format'));
			$this->RadiologyTestOrder->saveAll($this->request->data['RadiologyTestOrder']);
			exit;
			
		}

	}
	public function deleteRad($id){
		if(!empty($id)){
			$this->loadModel('RadiologyTestOrder');
			$this->RadiologyTestOrder->delete($id);
			$this->Session->setFlash(__('Record deleted successfully'),'default',array('class'=>'message'));
			$this->redirect($this->referer());
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}

	}

	public function getSpecimenOptions($laboratoryId){
		$this->layout = 'ajax';
		$this->loadModel('SpecimenCollectionOption');
		$this->loadModel('LaboratoryAoeCode');
		$data = $this->SpecimenCollectionOption->getSpecimenOptions($laboratoryId);
		$aoeCodes = $this->LaboratoryAoeCode->getAoeCodes($laboratoryId);
		echo json_encode(array($data,$aoeCodes));
		//pr($aoeCodes);
		//exit;
	}
	public function getAoeQuestionAnswer($laboratoryId){
		$this->layout = 'ajax';
		$this->loadModel('Laboratory');
		$data = $this->Laboratory->getAoeData($laboratoryId);
		echo json_encode($data);
		//exit;
	}


	public function getAllergy($patientId){
		$this->layout='ajax';
		//$this->layout=false;
		$this->uses=array('NewCropAllergies','Patient');
		$getEncounterID=$this->Note->encounterHandler($patientId,$this->params->query['personId']);
		$getAllegy=$this->Note->getAllergy($getEncounterID);
		$this->set('data',$getAllegy);
		$this->Patient->bindModel( array(
				'belongsTo' => array(
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)
		));
		$this->Patient->bindModel( array(
				'belongsTo' => array(
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)
		));
		$patient = $this->Patient->find('first',array('fields'=>array('Person.dob','Patient.person_id','Patient.sex'),'conditions'=>array('Patient.id'=>$patientId)));
		$var=$this->DateFormat->dateDiff($patient['Person']['dob'],date('Y-m-d'));
		$day=$var->days;
		$year=$var->y;
		$this->set('year',$year);
		$this->set('patient',$patient);
		echo $this->render('get_allergy');
		exit;

	}
	public function infobutton($drug_id=null,$patient_id=null,$Idinfo=null){
		$this->uses=array('NewCropPrescription','PharmacyItem');
		$this->layout = false ;
		$getPharmacyItemData=$this->PharmacyItem->find('first',
				array('fields'=>array('drug_id','id','patient_info','patient_info_link','patient_info_created_by'),
						'conditions'=>array('PharmacyItem.drug_id'=>$drug_id)));
		$getMedicationData=$this->NewCropPrescription->find('first',
				array('fields'=>array('drug_id','id','patient_info','patient_info_link','patient_info_created_by','patient_uniqueid','description','drug_name'),
						'conditions'=>array('NewCropPrescription.drug_id'=>$drug_id,'NewCropPrescription.id'=>$Idinfo)));
		/*if(!empty($getMedicationData['NewCropPrescription']['patient_info_link'])){
			$this->redirect($getMedicationData['NewCropPrescription']['patient_info_link']);
		}*/
		$this->set(compact('getMedicationData','getPharmacyItemData'));
		if(!empty($this->request->data)){
			$this->request->data['NewCropPrescription']['patient_info_created_by'] = $this->Session->read('userid');
			$this->request->data['NewCropPrescription']['patient_info']=addslashes($this->request->data['NewCropPrescription']['patient_info']);
			$this->request->data['NewCropPrescription']['patient_info_link']=addslashes($this->request->data['NewCropPrescription']['patient_info_link']);
			$this->NewCropPrescription->save($this->request->data['NewCropPrescription'],$getMedicationData['NewCropPrescription']['id']);
			$patient_info=  addslashes($this->request->data['NewCropPrescription']['patient_info']);
			$patient_info_link=  $this->request->data['NewCropPrescription']['patient_info_link'];
			$patient_info_created_by=  $this->request->data['NewCropPrescription']['patient_info_created_by'];
			$this->PharmacyItem->updateAll(array('patient_info'=>"'$patient_info'",'patient_info_link'=>"'$patient_info_link'",'patient_info_created_by'=>"'$patient_info_created_by'"),
					array('PharmacyItem.id'=>$getPharmacyItemData['PharmacyItem']['id']));
			$this->Session->setFlash(__('Information saved successfully'),'default',array('class'=>'message'));
			$status='success';
			$this->set('status',$status);
		}
	}
	public function addInfoDescription($drug_id=null,$patient_id=null,$Idinfo=null){
		$this->uses=array('NewCropPrescription','PharmacyItem');
		$getPharmacyItemData=$this->PharmacyItem->find('first',
				array('fields'=>array('drug_id','id'),
						'conditions'=>array('PharmacyItem.drug_id'=>$drug_id)));
		$this->set(compact('getPharmacyItemData'));

		if(!empty($this->request->data)){
			$patient_info=addslashes($this->request->data['patient_info']);
			$this->request->data['NewCropPrescription']['patient_info_created_by'] = $this->Session->read('userid');
			$getDataDesc=$this->NewCropPrescription->updateAll( array('NewCropPrescription.patient_info'=>"'".$patient_info."'",'NewCropPrescription.patient_info_created_by'=>"'".$this->request->data['NewCropPrescription']['patient_info_created_by']."'"),
					array('NewCropPrescription.id'=>$this->request->data['id']));
			$patient_info=  addslashes($this->request->data['patient_info']);
			$patient_info_created_by=  $this->request->data['NewCropPrescription']['patient_info_created_by'];
			$this->PharmacyItem->updateAll(array('patient_info'=>"'$patient_info'",'patient_info_created_by'=>"'$patient_info_created_by'"),
					array('PharmacyItem.drug_id'=>$getPharmacyItemData['PharmacyItem']['drug_id']));
		}
		if($getDataDesc){
			$showTextBox='success';
			echo $showTextBox;
		}
		exit;
	}
	public function addIsPrinted($drug_id=null,$patient_id=null,$Idinfo=null){
		$this->uses=array('NewCropPrescription');
		if(!empty($this->request->data)){
			$PrintLeaflet=$this->request->data['PrintLeaflet'];
			$getDataDesc=$this->NewCropPrescription->updateAll( array('NewCropPrescription.PrintLeaflet'=>"'".$PrintLeaflet."'"),
					array('NewCropPrescription.id'=>$this->request->data['id']));
		}
		echo "save";
		exit;
	}
	public function addInfoLink($drug_id=null,$patient_id=null,$Idinfo=null){
		$this->uses=array('NewCropPrescription','PharmacyItem');
		$getPharmacyItemData=$this->PharmacyItem->find('first',
				array('fields'=>array('drug_id','id'),
						'conditions'=>array('PharmacyItem.drug_id'=>$drug_id)));
		$this->set(compact('getPharmacyItemData'));
		if(!empty($this->request->data)){
			$patient_info_link=addslashes($this->request->data['patient_info_link']);
			$this->request->data['NewCropPrescription']['patient_info_created_by'] = $this->Session->read('userid');
			$getDataLink=$this->NewCropPrescription->updateAll( array('NewCropPrescription.patient_info_link'=>"'".$patient_info_link."'",'NewCropPrescription.patient_info_created_by'=>"'".$this->request->data['NewCropPrescription']['patient_info_created_by']."'"),
					array('NewCropPrescription.id'=>$this->request->data['id']));
			$patient_info_link=  $this->request->data['patient_info_link'];
			$patient_info_created_by=  $this->request->data['NewCropPrescription']['patient_info_created_by'];
			$this->PharmacyItem->updateAll(array('patient_info_link'=>"'$patient_info_link'",'patient_info_created_by'=>"'$patient_info_created_by'"),
					array('PharmacyItem.drug_id'=>$getPharmacyItemData['PharmacyItem']['drug_id']));
		}
		if(!empty($getDataLink)){
			$showTextBox='success';
			echo $showTextBox;
		}
		exit;
	}

	public function showRadImage($ids,$resultId){
		$this->layout=false;
		$this->uses = array('RadiologyReport');
		//debug($ids);exit;
		$reports = $this->RadiologyReport->find('list',array('conditions'=>array('RadiologyReport.patient_id'=>$ids,'RadiologyReport.radiology_result_id'=>$resultId),'fields'=>array('RadiologyReport.id','RadiologyReport.file_name')));
		$this->set('imageName',implode(",",$reports));

	}
	public function getAlternateDrugFormulary($patient_id=null,$drug_id=null,$healthPlanId=null,$sequenceNo=null){
		$this->layout='ajax';
		$this->uses=array('NewCropPrescription');
		$alternateFormularyData=$this->NewCropPrescription->alternateDrugWithFormulary($patient_id,$drug_id,$healthPlanId);
		$this->set('sequenceNo',$sequenceNo);
		$this->set('drug_id',$drug_id);
		$this->set('alternateFormularyData',$alternateFormularyData["rowData"]);
		$this->render('get_alternate_drug_formulary');
	}
	public function getFormularyCoverage($patient_id=null,$drug_id=null,$healthPlanId=null){
		$this->layout='ajax';
		$this->uses=array('NewCropPrescription');
		$FormularyStatus=Configure :: read('FormularyStatus');
		$FormularyStatusDesc=Configure :: read('FormularyStatusDesc');
		$formularyCoverage=$this->NewCropPrescription->formularyCoverage($patient_id,$drug_id,$healthPlanId);
		$formularyCoverageVal=(string) $formularyCoverage;
		echo $FormularyStatus[$formularyCoverageVal]."~".$FormularyStatusDesc[$formularyCoverageVal];
		exit;

	}
	public function getFrequentMedication($patientId=null,$healthPlanId=null){
		$this->layout='ajax';
		$this->uses=array('NewCropPrescription','PharmacyItem');
		//******************************Set Frequent medication for doctors ADITYA******************
		$getMedicationByDoctor=$this->NewCropPrescription->find('list',array('fields'=>array('id','description'),
				'conditions'=>array('created_by'=>$_SESSION['Auth']['User']['id'])));
		$oneArray=array_count_values($getMedicationByDoctor);
		$towArray=array_keys($oneArray);
		foreach( $towArray as $towArrays){
			if($oneArray[$towArrays]>2){
				$frequentMedication[]=$towArrays;
			}
		}
		$frequentMedicationByDoctor=$this->NewCropPrescription->find('all',array('fields'=>array('drug_id','description'),
				'conditions'=>array('description'=>$frequentMedication),'group'=>array('drug_id')));
		$this->set('frequentMedicationByDoctor',$frequentMedicationByDoctor);

		$this->set('patientId',$patientId);
		$this->set('healthPlanId',$healthPlanId);

		echo $this->render('get_frequent_medication');
		exit;
		//**************************EOD*************************************************************
	}

	public function getDrugType($drug_id=null){
		$this->layout='ajax';
		$this->uses=array('PharmacyItem');
		//debug($drug_id);
		$drugType=$this->PharmacyItem->find('first',array('fields'=>array('MED_REF_GEN_DRUG_NAME_CD_DESC','DosageForm','Route'),
				'conditions'=>array('drug_id'=>$drug_id)));
		//		debug($drugType);
		//exit;
		if($drugType["PharmacyItem"]["MED_REF_GEN_DRUG_NAME_CD_DESC"]=="Generic" or $drugType["PharmacyItem"]["MED_REF_GEN_DRUG_NAME_CD_DESC"]=="Brand")
			$drugTypeVal=$drugType["PharmacyItem"]["MED_REF_GEN_DRUG_NAME_CD_DESC"];
		else
			$drugTypeVal="Not available";

		//get dosage form and route

		echo $drugTypeVal."~~~".$drugType["PharmacyItem"]["DosageForm"]."~~~".$drugType["PharmacyItem"]["Route"];
		exit;

	}


	//***for no active medication***//
	public function setNoActiveMed($patientid=null,$checkrx=null,$patient_uid=null){
		$this->autoRender = false ;
		$this->uses=array('Note');
		if($checkrx=='1'){
			$setNoActive = $this->Note->setNoActiveMedByPhysician($patientid,$checkrx,$patient_uid);
		}
		if($checkrx=='0'){
			$unsetNoActive = $this->Note->unsetNoActiveMedByPhysician($patientid,$checkrx,$patient_uid);
		}
	}

	//***for no active allergy***//
	public function setNoActiveAllergy($patientid=null,$checkall=null,$patient_uid=null){
		$this->autoRender = false ;
		$this->uses=array('Note');
		if($checkall=='1'){
			$setNoActiveAll = $this->Note->setNoActiveAllergyByPhysician($patientid,$checkall,$patient_uid);
		}
		if($checkall=='0'){
			$unsetNoActiveAll = $this->Note->unsetNoActiveAllergyByPhysician($patientid,$checkall,$patient_uid);
		}
	}
	//--
	public function setNoActiveDiagnosis($patientid=null,$checkall=null,$note_id=null){
		$this->autoRender = false ;
		$this->uses=array('Note');
		if(empty($note_id)){
			if($checkall=='1'){
				$no_diagnoses_check = 'yes';
			}else{
				$no_diagnoses_check= 'no';
			}
			$this->Note->save(array('no_diagnoses_check'=>$no_diagnoses_check,'patient_id'=>$patientid,'create_time'=>date('Y-m-d H:i:s')));
			$lastIdByLab=$this->Note->getLastInsertID();
		}else{
			$unsetNoActiveAll = $this->Note->setNoActiveDiagnosis($patientid,$checkall,$note_id);
		}
		if(empty($note_id)){
			echo $lastIdByLab;
		}else{
			echo $note_id;
		}
	}
	//***check for reconcile***//
	public function setReconcile($patientid=null,$checkreconcile=null,$person_id=null){

		$this->uses=array('NewCropPrescription');
		$this->autoRender = false ;
		if($checkreconcile=='1'){
			$this->NewCropPrescription->updateAll(array('is_reconcile'=>'1'),array('patient_id'=>$person_id,'patient_uniqueid'=>$patientid,'archive'=>'N'));
		}
		if($checkreconcile=='0'){
			$this->NewCropPrescription->updateAll(array('is_reconcile'=>'0'),array('patient_id'=>$person_id,'patient_uniqueid'=>$patientid,'archive'=>'N'));
		}
	}
	public function getFrequentDiagnosis($patientId,$noteId=null){
		$this->layout='ajax';
		$this->uses = array("NoteDiagnosis");
		//******************************Set Frequent medication for doctors ADITYA******************
		$getDiagnosisByDoctor=$this->NoteDiagnosis->find('all',array('fields'=>array('snowmedid','diagnoses_name'),
				'conditions'=>array('created_by'=>$_SESSION['Auth']['User']['id'])));
		foreach($getDiagnosisByDoctor as $listData){
			$newListData[]=$listData['NoteDiagnosis']['diagnoses_name'];

		}
		$oneArray=array_count_values($newListData);
		$towArray=array_keys($oneArray);
		foreach( $towArray as $towArrays){
			if($oneArray[$towArrays]>1){
				$frequentDiagnosis[]=$towArrays;
			}
		}
		$frequentProblemByDoctor=$this->NoteDiagnosis->find('all',array('fields'=>array('id','icd_id','snowmedid','diagnoses_name'),'conditions'=>array('diagnoses_name'=>$frequentDiagnosis),'group'=>array('diagnoses_name')));
		$this->set('frequentProblemByDoctor',$frequentProblemByDoctor);
		$this->set('patientId',$patientId);
		$this->set('noteId',$noteId);
		echo $this->render('get_frequent_diagnosis');
		exit;


	}
	public function sendPatientReminder($reminderType=null){


	}
	public function UpdateResident($patientId,$noteId){
		$this->layout='ajax';
		$this->uses = array("Note","Patient","User");// is_resident_signed  	signed_date signed_by
		$dateTime=date('Y-m-d H:i:s');
		$userId=$_SESSION['Auth']['User']['id'];
		$this->Note->UpdateAll(array('is_resident_signed'=>'1','signed_date'=>"'$dateTime'",'signed_by'=>"'.$userId.'"),
				array('id'=>$noteId));

		$patientLookUp = $this->Patient->find('first', array('fields'=> array('Patient.lookup_name'),'conditions'=>array('Patient.id' =>$patientId)));
		$getDocId=$this->Note->find('first',array('fields'=>array('resident_notes_given_by'),
				'conditions'=>array('id'=>$noteId,'Note.created_by'=>$this->Session->read('userid'))));
		$docName=$this->User->find('first',array('fields'=>array('User.username','User.first_name','User.last_name'),'conditions'=>array('User.id'=>$getDocId['Note']['resident_notes_given_by'])));
		$mailData['Patient']=array("patient_id"=>$docName["User"]["username"],"lookup_name"=>$docName["User"]["first_name"]." ".$docName["User"]["last_name"]);
		$msgs="Please click on below progress note link of ".$patientLookUp["Patient"]["lookup_name"]."<br/><br/>";
		$msgs.="<a href=".Router::url('/')."Notes/soapNote/".$patientId."/".$noteId.">Click here to view progress note</a><br/><br/>";
		$subject="Notes completed for ".$patientLookUp["Patient"]["lookup_name"];
		$this->Note->sendMail($mailData,$msgs,$subject);
		exit;


	}

	public function callExtraInfo($templateId,$templateSubId){
		$this->layout='ajax';
		$this->uses = array('Template','TemplateSubCategories');
		/* 	$this->Template->bindModel(array(
		 'hasMany' => array('TemplateSubCategories' =>array('foreignKey'=>'template_id','conditions'=>array('TemplateSubCategories.is_deleted=0')))));
		*/
		$roseDataExtraData=$this->TemplateSubCategories->find('all',
				array('conditions'=>array('TemplateSubCategories.template_category_id'=>$templateId,'TemplateSubCategories.template_id'=>$templateSubId,
						'TemplateSubCategories.is_deleted=0')));
		$this->set('roseDataExtraData',$roseDataExtraData);
		echo $this->render('call_extra_info');
		exit;

	}
	/*public function addProcedurePerform($patientId,$noteId,$appId){
		if(!empty($this->params->query['ajaxFlag'])){
			$this->layout=ajax;
			$ajaxHold=$this->params->query['ajaxFlag'];
			$this->set('ajaxHold',$ajaxHold);
		}
		$this->uses =array('BillingOtherCode','ProcedurePerform','NoteDiagnosis','NoteTemplate');
		$procedure_perform  = $this->ProcedurePerform->find('all',array('conditions'=>array('patient_id'=>$patientId,'is_deleted'=>'0')));
		$this->set('procedure_perform',$procedure_perform);
		if(!empty($this->params->query['returnUrl'])){
			$this->set('returnUrl',$this->params->query['returnUrl']);

		}
		
		$tName=$this->NoteTemplate->find('list',array('fields'=>array('template_name','template_name'),'conditions'=>array('is_deleted'=>'0')));
		$this->set('tName',$tName);
		
		//Procedure Performs-Mahalaxmi
		///to get data for Patient Diagnosis
		$getNoteDaignosis=$this->NoteDiagnosis->find('all',array('conditions'=>array('patient_id'=>$patientId),'fields'=>array('icd_id','diagnoses_name')));
		foreach($getNoteDaignosis as $data){
			$codeId = ($data['NoteDiagnosis']['icd_id']) ? " : (".$data['NoteDiagnosis']['icd_id'].")" : '';
			$nameNoteDiagnosis[trim($data['NoteDiagnosis']['diagnoses_name'].$codeId)]=trim($data['NoteDiagnosis']['diagnoses_name'].$codeId);
		}
		////end of -to get data for Patient Diagnosis
		// Modifer
		$getModifiers=$this->BillingOtherCode->find('all',array('fields'=>array('code','name'),'conditions'=>array('BillingOtherCode.status'=>'1')));
		foreach($getModifiers as $data){
			$codeId = ($data['BillingOtherCode']['code']) ? " - (".$data['BillingOtherCode']['code'].")" : '';
			$nameBillingOtherCode[$data['BillingOtherCode']['code']]=trim($data['BillingOtherCode']['name'].$codeId);
		}
		$this->set(compact('patientId','noteId','appId','nameNoteDiagnosis'));
		$this->set('nameBillingOtherCode',$nameBillingOtherCode);
		//EOF
	}*/
	
	public function addProcedurePerform($patientId,$noteId,$appId){
		$this->uses =array('BillingOtherCode','ProcedurePerform','NoteDiagnosis','NoteTemplate','ServiceCategory','Patient');
		$patientDetails = $this->Patient->usPatientHeader($patientId);//For Patient header
		$this->set('patientDetails',$patientDetails);
		// Code for all Acting Radio
		//Get All services grp
		$getAllServiceGrp=$this->ServiceCategory->find('list',array('fields'=>array('id','alias'),
				'conditions'=>array('OR'=>array(array('service_type'=>'Both'),array('service_type'=>'OPD')),
						'alias NOT'=>array('Radiology','Laboratory','Immunization','Surgery / Packages'),'is_deleted'=>'0','is_view'=>'1','location_id'=>$this->Session->read('locationid'))));
		$getProcedureID=$this->ServiceCategory->find('first',array('fields'=>array('id','alias'),
				'conditions'=>array('alias'=>array('Procedure Performed'),'is_deleted'=>'0','location_id'=>$this->Session->read('locationid'))));
		$this->set('getAllServiceGrp',$getAllServiceGrp);
		$this->set('getProcedureID',$getProcedureID);
		//EOD
		//Get Tariff Standard ID
		$tariffStandardIdAuto=$this->Patient->find('first',array('fields'=>array('id','tariff_standard_id','lock'),
				'conditions'=>array('id'=>$patientId,'is_deleted'=>'0','location_id'=>$this->Session->read('locationid'))));
		$this->set('tariffStandardIdAuto',$tariffStandardIdAuto['Patient']['tariff_standard_id']);
		//EOD
		// EOD
	
	
	
		$procedure_perform  = $this->ProcedurePerform->find('all',array('conditions'=>array('patient_id'=>$patientId,'is_deleted'=>'0','procedure_type'=>'2')));
		$this->set('procedure_perform',$procedure_perform);
		$procedure_schedule  = $this->ProcedurePerform->find('all',array('conditions'=>array('patient_id'=>$patientId,'is_deleted'=>'0','procedure_type'=>'1')));
		$this->set('procedure_schedule',$procedure_schedule);
		/* template code Aditya*/
		$tName=$this->NoteTemplate->find('list',array('fields'=>array('template_name','template_name'),
				'conditions'=>array('is_deleted'=>'0','template_type'=>array('all','')),
				'order'=>array('ISNULL(NoteTemplate.sort_order), NoteTemplate.sort_order ASC')));
		$this->set('tName',$tName);
		$this->set('appId',$appId);
		/*EOD*/
		//Procedure Performs-Mahalaxmi
		///to get data for Patient Diagnosis
		$getNoteDaignosis=$this->NoteDiagnosis->find('all',array('conditions'=>array('patient_id'=>$patientId,'is_deleted'=>'0','terminal'=>'yes'),
				'fields'=>array('icd_id','diagnoses_name')));
		foreach($getNoteDaignosis as $data){
			$codeId = ($data['NoteDiagnosis']['icd_id']) ? " : (".$data['NoteDiagnosis']['icd_id'].")" : '';
			$nameNoteDiagnosis[trim($data['NoteDiagnosis']['diagnoses_name'].$codeId)]=trim($data['NoteDiagnosis']['diagnoses_name'].$codeId);
		}
		////end of -to get data for Patient Diagnosis
		// Modifer
		$getModifiers=$this->BillingOtherCode->find('all',array('fields'=>array('code','name'),'conditions'=>array('BillingOtherCode.status'=>'1')));
		foreach($getModifiers as $data){
			$codeId = ($data['BillingOtherCode']['code']) ? " - (".$data['BillingOtherCode']['code'].")" : '';
			$nameBillingOtherCode[$data['BillingOtherCode']['code']]=trim($data['BillingOtherCode']['name'].$codeId);
		}
		$this->set(compact('patientId','noteId','appId','nameNoteDiagnosis'));
		$this->set('nameBillingOtherCode',$nameBillingOtherCode);
		//EOF
		if($this->request->is('Ajax')){
			$this->set('hideSection',true);
			echo $this->render('add_procedure_perform');
			exit;
		}
	}
	public function setAppStatus(){
		$this->layout='ajax';
		$this->uses=array('Appointment');
		$timeDiff=$this->Appointment->find('first',array('fields'=>array('id','arrived_time'),'conditions'=>array('Appointment.id'=>$this->request->data['Note']['appt'])));
		$start=$timeDiff['Appointment']['date'].' '.$timeDiff['Appointment']['arrived_time'];
		$elapsed=$this->DateFormat->dateDiff($start,date('Y-m-d H:i')) ;
		if($elapsed->i!=0){
			$min=$elapsed->i;
		}else{
			$min='00';
		}
		if($elapsed->h!=0){
			if($elapsed->h>=12){
				$hrs=$elapsed->h-12;
			}
			else{
				$hrs=$elapsed->h;
			}
			$hrs= ($hrs * 60);
			$showTime=$hrs+$min;

		}else{
			$showTime=$min;
		}
		$res=$this->Appointment->updateAll(array('status'=>"'Seen'",'elapsed_time'=>$showTime),array('Appointment.is_future_app'=>0,'Appointment.id'=>$this->Session->read('apptDoc')));
		exit;
	}
	public function saveSoapChiefComplaints(){
		$this->layout='ajax';
		$this->uses=array('Note','Diagnosis');
		$this->Note->save($this->request->data['Note']);
		$lastinsid=$this->Note->getInsertId();
		if(empty($lastinsid)){
			$this->Session->write('myNoteId',$this->request->data['Note']['id']);
			echo $this->request->data['Note']['id'];

		}else{
			$this->Session->write('myNoteId',$lastinsid);
			echo $lastinsid;

		}
		// to insert in Diagnosis table
		$patientId=$this->request->data['Note']['patient_id'];
		$appointmentId=$this->request->data['Note']['appt'];
		$getDataOfCc=$this->Diagnosis->find('first',array('fields'=>array('complaints'),'condition'=>array('patient_id'=>$patientId,'appointment_id'=>$appointmentId)));
		if(empty($getDataOfCc)){
			$ccData=$this->request->data['Note']['cc'];
			$this->Diagnosis->save(array('complaints'=>"'.$ccData.'"));

		}else{
			$ccData=$this->request->data['Note']['cc'];
			$this->Diagnosis->updateAll(array('complaints'=>"'$ccData'"),array('patient_id'=>$patientId,'appointment_id'=>$appointmentId));

		}
		// EOD
		exit;
	}
	public function soapNoteIpd($patientId=null,$noteId=null,$chkPostive=null){
		$this->layout = 'advance' ;

		$this->uses = array('NewCropAllergies','TemplateTypeContent','Template','Widget','Note','Patient','Language',
				'NoteTemplate','LabManager','User','RadiologyTestOrder','Diagnosis','PatientsTrackReport','Person','NoteDiagnosis','LabManager');

		/** Update code for complete note**/
		if(empty($noteId)){
			$this->Note->updateAll(array('compelete_note'=>'1'),array('patient_id'=>$patientId));
		}
		/** EOD **/
		/** to create noteId **/
		if(empty($noteId) && empty($this->request->data['Note']['id'])){
			$noteId=$this->Note->addBlankNote($patientId);
			$this->redirect("/notes/soapNoteIpd/".$patientId."/".$noteId);
		}
		/** EOD **/
		/** **/
		$consultant=$this->User->getResidentPCP();
		$registrar=$this->User->getResidentDoctorRegister();
		$this->set('consultant',$consultant);
		$this->set('registrar',$registrar);
		/** **/
		$this->patient_info($patientId);

		if($patientId)
			$this->Session->write('smartphrase_patient_id',$patientId);

		//Problem LabRad
		if(!empty($noteId)){
			$this->Session->write('specialNoteId',$noteId);
			$getProblem=$this->Note->getDiagnosis($patientId,$noteId);
			$this->set('getProblem',$getProblem);
		}
		//EOD
		// Get Pervious problem
		$getPastProblems=$this->NoteDiagnosis->find('list',array('fields'=>array('id','diagnoses_name'),'conditions'=>array('patient_id'=>$patientId),'group'=>array('diagnoses_name')));
		$this->set('getPastProblems',$getPastProblems);
		//EOD
		//NoteTemplate search
		$tName=$this->NoteTemplate->find('list',array('fields'=>array('template_name','template_name'),'conditions'=>array('is_deleted'=>'0')));
		$this->set('tName',$tName);
		//EOD
		//ROS display= aditya
		//for HPI
		$this->Template->bindModel(array(
				'hasMany' => array(
						'TemplateSubCategories' =>array(
								'foreignKey'=>'template_id','conditions'=>array('TemplateSubCategories.is_deleted=0')
						),
				)));
		$hpiMasterData=$this->Template->find('all',array('fields'=>array('Template.id','Template.template_category_id','Template.category_name')
				,'conditions'=>array('Template.is_deleted=0','template_category_id'=>'3')));// to bring data of HPI only ('template_category_id'=>'3')
		$Hpi = $this->TemplateTypeContent->find('list',array('fields'=>array('template_id','template_subcategory_id'),
				'conditions'=>array('template_category_id'=>'3','note_id' =>$noteId,'patient_id'=>$patientId))) ;
		//END ofCode

		//for HPI
		$this->Template->bindModel(array(
				'hasMany' => array(
						'TemplateSubCategories' =>array(
								'foreignKey'=>'template_id','conditions'=>array('TemplateSubCategories.is_deleted=0')
						),
				)));
		$hpiMasterData=$this->Template->find('all',array('fields'=>array('Template.id','Template.template_category_id','Template.category_name')
				,'conditions'=>array('Template.is_deleted=0','template_category_id'=>'3')));// to bring data of HPI only ('template_category_id'=>'3')
		$Hpi = $this->TemplateTypeContent->find('list',array('fields'=>array('template_id','template_subcategory_id'),
				'conditions'=>array('template_category_id'=>'3','note_id' =>$noteId,'patient_id'=>$patientId))) ;
		$this->set(compact('Hpi'));
		$this->set('hpiMasterData',$hpiMasterData);
		//END ofCode

		//for ROS
		$this->Template->bindModel(array(
				'hasMany' => array(
						'TemplateSubCategories' =>array(
								'foreignKey'=>'template_id','conditions'=>array('TemplateSubCategories.is_deleted=0')
						),
				)));
		$rosMasterData=$this->Template->find('all',array('fields'=>array('Template.id','Template.template_category_id','Template.category_name')
				,'conditions'=>array('Template.is_deleted=0','template_category_id'=>'1')));// to bring data of HPI only ('template_category_id'=>'3')
		$templateTypeContent = $this->TemplateTypeContent->find('list',array('fields'=>array('template_id','template_subcategory_id'),
				'conditions'=>array('template_category_id'=>'1','note_id' =>$noteId,'patient_id'=>$patientId))) ;
		$this->set(compact('templateTypeContent','rosMasterData'));
		//END ofCode
		//for PE
		$this->Template->bindModel(array(
				'hasMany' => array(
						'TemplateSubCategories' =>array(
								'foreignKey'=>'template_id','conditions'=>array('TemplateSubCategories.is_deleted=0')
						),
				)));
		$peMasterData=$this->Template->find('all',array('fields'=>array('Template.id','Template.template_category_id','Template.category_name')
				,'conditions'=>array('Template.is_deleted=0','template_category_id'=>'2')));// to bring data of HPI only ('template_category_id'=>'3')
		$physicalExamination = $this->TemplateTypeContent->find('list',array('fields'=>array('template_id','template_subcategory_id'),
				'conditions'=>array('template_category_id'=>'2','note_id' =>$noteId,'patient_id'=>$patientId))) ;
		$this->set(compact('physicalExamination','peMasterData'));
		//END ofCode
		//EOD

		//*************************get element detials****************************
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id')),
				)));
		$getElement=$this->Patient->find('first',
				array('fields'=>array('Person.sex','Person.age','Person.language','Person.email','Person.photo','Person.phvs_visit_id','Patient.person_id',
						'Patient.treatment_type','Patient.patient_id','Patient.form_received_on','Patient.lookup_name','Person.dob'),'conditions'=>array('Patient.id'=>$patientId)));
		$getCurrentAge=$this->Person->getCurrentAge($getElement['Person']['dob']);
		$getElement['Person']['age']=$getCurrentAge;
		$this->set('getElement',$getElement);
		/* $getLanguage=$this->Language->find('list',array('fields'=>array('code','language')));
			$this->set('language',$getLanguage); */
		// hearder data
		$getComplaints=$this->Diagnosis->find('first',array('fields'=>array('id','complaints','flag_event','family_tit_bit'),
				'conditions'=>array('patient_id'=>$patientId)));
		$this->set('DiaCC',trim($getComplaints['Diagnosis']['complaints']));
		$this->set('family_tit_bit',trim($getComplaints['Diagnosis']['family_tit_bit']));
		$this->set('flagEvent',trim($getComplaints['Diagnosis']['flag_event']));
		$this->set('diagnosisId',trim($getComplaints['Diagnosis']['id']));
		//***********************************EOF***************************************************

		$currentUserId = 1;
		$columns = $this->Widget->find('all',array('fields' => array('Widget.id','Widget.user_id','Widget.application_screen_name','Widget.column_id',
				'Widget.collapsed','Widget.title','Widget.section','Widget.is_deleted'),
				'conditions' => array('Widget.is_deleted'=> 0,'Widget.user_id' => $currentUserId,
						'Widget.application_screen_name' => 'Soap Note'),
				'order' => array('Widget.column_id','Widget.sort_no'),'group'=>array('Widget.title')));
		$this->set('patientId',$patientId);
		$this->set('noteId',$noteId);
		if(!empty($noteId)){
			$getVitals=$this->Note->find('first',array('conditions'=>array('id'=>$noteId,'Note.created_by'=>$this->Session->read('userid'))));
			$this->set('getVitals',$getVitals);

		}
		$this->set('timeFromPList',$this->params->query['arrived_time']);
		$this->set('columns',$columns);
		$getVitals2=$this->getInitalData($patientId,'0',$noteId);
		$this->set(array('getVitals1'=>$getVitals2));
			

		/* if(!empty($getVitals['Note']['cc'])){
		 $this->set('ccdata',$getVitals['Note']['cc']);
		}
		else{
		*/
		//debug($getVitals2);exit;
		$this->set('ccdata',trim($getVitals2['Note']['cc']));
		$this->set('family_tit_bit',trim($getVitals2['Note']['family_tit_bit'])); // show data of initial assement always-Aditya
			
		/* } */
		//BOF document section data
		$this->loadModel('PatientsTrackReport');
		$patientDocuments = $this->PatientsTrackReport->getPatientDocuments($getElement['Patient']['person_id'],'null',$patientId);
			
		$this->set('getPatientDocuments',$patientDocuments) ;
		//EOF document section data

		//**********************************************Save data********************************************************************************

		if(!empty($this->request->data['Note'])){
			$this->request->data['Note']['note_date'] = $this->DateFormat->formatDate2STD($this->request->data['Note']['note_date'],Configure::read('date_format'));
			if(empty($this->request->data['Note']['id'])){
				//	$this->request->data['Note']['create_time'] = $this->DateFormat->formatDate2STD(date('m/d/y'),Configure::read('date_format'));
			}else{
				//	$this->request->data['Note']['modify_time'] = $this->DateFormat->formatDate2STD(date('m/d/y'),Configure::read('date_format'));
			}
			//After every submit change status to "seen" Patient List functionality-- Pooja
			if($this->request->data['Note']['id']=='null'){
				unset($this->request->data['Note']['id']);
			}
			// for lab diagnosis add -Aditya
			if(!empty($this->request->data['Note']['plan'])){
				$oldPlan=$this->Note->find('first',array('fields'=>array('plan'),
						'conditions'=>array('id'=>$this->request->data['Note']['id'],'Note.created_by'=>$this->Session->read('userid'))));
				if(!empty($oldPlan['Note']['plan'])){
					$explodeoldPlanDataExist=explode('$',$oldPlan['Note']['plan']);
					//	debug(count($explodeoldPlanDataExist));debug($this->request->data['Note']['oneOneDiagosis']);exit;
					if(count($explodeoldPlanDataExist)-1 < $this->request->data['Note']['oneOneDiagosis']){
						$this->request->data['Note']['plan']=implode('$',$explodeoldPlanDataExist).'$'.$this->request->data['Note']['plan'].":::".$this->request->data['Note']['oneOneDiagosis'];
					}else{

							

						$explodeOldPlan=explode('$',$oldPlan['Note']['plan']);
						foreach($explodeOldPlan as $explodeOldPlans){
							$explodeInsideData=explode(':::',$explodeOldPlans);
							if(empty($this->request->data['Note']['oneOneDiagosis'])){
								$this->request->data['Note']['oneOneDiagosis']=0;
							}
							if($explodeInsideData['1']==$this->request->data['Note']['oneOneDiagosis']){
									
								$planNewText[]=$this->request->data['Note']['plan'].":::".$this->request->data['Note']['oneOneDiagosis'];
							}else{
								$planNewText[]=$explodeOldPlans;
							}
						}

						$planNewTextNew=implode('$',$planNewText);
						unset($planNewText[count($planNewTextNew)-1]);
						$this->request->data['Note']['plan']=$planNewTextNew;
					}
				}
				else{
					if(!empty($this->request->data['Note']['plan']))
						$this->request->data['Note']['plan']=$this->request->data['Note']['plan'].":::0";
				}
			}
			//unset($this->request->data['Note']['oneOneDiagosis']);
			// EOD

			//gulshan// for 1st time from soap to initial
			$isPreaent = $this->Diagnosis->find('first',array('fields'=>array('id','patient_id','complaints','family_tit_bit'),
					'conditions'=>array('Diagnosis.patient_id'=>$this->request->data['Note']['patient_id'],'appointment_id'=>'0')));
			//eof gulshan
			$this->request->data['Note']['id']=$_SESSION['specialNoteId'];
			if($this->Note->save($this->request->data['Note'])){

				$initialCc=$this->request->data['Note']['cc'];
				$initialfamily=$this->request->data['Note']['family_tit_bit'];
				$family_tit_bit=$isPreaent['Diagnosis']['family_tit_bit'];
				$complaints=$isPreaent['Diagnosis']['complaints'];
				$lastinsid=$this->Note->getInsertId();
				if(empty($lastinsid)){// for case of update
					$lastinsid=$this->request->data['Note']['id'];
				}

				if(!empty($initialCc)){
					if(!$isPreaent){
						//debug($lastinsid);exit;
						$this->Diagnosis->save(array('complaints'=>$initialCc,
								'patient_id'=>$this->request->data['Note']['patient_id'],'create_time'=>date("Y-m-d H:i:s"),'appointment_id'=>'0',
								'created_by'=>$this->Session->read('userid'),'location_id'=>$this->Session->read('locationid'),'note_id'=>$lastinsid));
					}else{
						$this->Diagnosis->updateAll(array('complaints'=>"'$initialCc'",/* 'family_tit_bit'=>"'$family_tit_bit'", */'note_id'=>"'$lastinsid'"),
								array('Diagnosis.patient_id'=>$this->request->data['Note']['patient_id']));
					}
				}
				if(!empty($initialfamily)){
					if(!$isPreaent){
						$this->Diagnosis->save(array('family_tit_bit'=>$initialfamily,
								'patient_id'=>$this->request->data['Note']['patient_id'],'create_time'=>date("Y-m-d H:i:s"),'appointment_id'=>'0',
								'created_by'=>$this->Session->read('userid'),'location_id'=>$this->Session->read('locationid'),'note_id'=>$lastinsid));
					}else{
						$this->Diagnosis->updateAll(array('family_tit_bit'=>"'$initialfamily'",/* 'complaints'=>"'$complaints'", */'note_id'=>"'$lastinsid'"),
								array('Diagnosis.patient_id'=>$this->request->data['Note']['patient_id']));
					}
				}

			}

		}

	}
	
	public function updateDoc($patientId,$noteId,$docId,$type=null){
		$this->uses=array('Note');
		$this->autoRender=false;
		if ($type=='REG'){
		 $data = array('patient_id'=>$patientId,'id'=>$noteId,'sb_registrar'=>$docId);
		}else{
			$data = array('patient_id'=>$patientId,'id'=>$noteId,'sb_consultant'=>$docId);
		}
		if($this->Note->save($data)){
			echo true;

		}else{
			echo false;
		}
		exit;
	}


	public function sendTo($patient){
		$this->uses=array('Note');
		$this->autoRender=false;
		$getid=$this->Note->find('first',array('conditions'=>array('patient_id'=>$patient,'Note.created_by'=>$this->Session->read('userid'),'compelete_note'=>'0'),'fields'=>array('id')));
		$this->redirect("/notes/soapNoteIpd/".$patient."/".$getid['Note']['id']);

	}
	//BOF code related to Procedure
	public function save_procedurePerform(){

		ob_end_clean();
		ob_start("ob_gzhandler");
		$this->uses = array('ProcedurePerform');
		if(!empty($this->request->data['ProcedurePerform']['procedure_name'])){
			$this->request->data['ProcedurePerform']['patient_id'] = $this->request->data['ProcedurePerform']['patient_id'];
			$this->request->data["ProcedurePerform"]["procedure_date"] = $this->DateFormat->formatDate2STD($this->request->data["ProcedurePerform"]["procedure_date"],Configure::read('date_format'));
			$this->request->data["ProcedurePerform"]["procedure_to_date"] = $this->DateFormat->formatDate2STD($this->request->data["ProcedurePerform"]["procedure_to_date"],Configure::read('date_format'));
			//$this->DateFormat->formatDate2STD($search_ele['dob'],Configure::read('date_format'))
			$this->request->data["ProcedurePerform"]["final_verify_date"]=$this->DateFormat->formatDate2STD($this->request->data["ProcedurePerform"]["final_verify_date"],Configure::read('date_format'));
			//debug($this->request->data);exit;
			if(!empty($this->request->data['ProcedurePerform']['patient_daignosis']))
				$this->request->data['ProcedurePerform']['patient_daignosis'] = serialize($this->request->data['ProcedurePerform']['patient_daignosis']);
			$this->request->data['ProcedurePerform']['code_type']=strtoupper($this->request->data['ProcedurePerform']['code_type']);
			$this->ProcedurePerform->insertProcedurePerform($this->request->data);
			$this->Session->setFlash(__('Procedure Sucessfully Saved' ),true,array('class'=>'message'));
			exit;
		}
	}

	public function edit_procedurePerform($id=null){
		ob_end_clean();
		ob_start("ob_gzhandler");
		$this->uses = array('ProcedurePerform');
		$edit_data = $this->ProcedurePerform->find('first',array('conditions'=>array('id'=>$id)));
		if(!empty($edit_data['ProcedurePerform']['patient_daignosis'])){
			$edit_data['ProcedurePerform']['patient_daignosis'] = json_encode(unserialize($edit_data['ProcedurePerform']['patient_daignosis']));
		}
		$edit_data['ProcedurePerform']['code_type']=strtoupper($edit_data['ProcedurePerform']['code_type']);
		$edit_data['ProcedurePerform']['procedure_date'] = $this->DateFormat->formatDate2Local($edit_data['ProcedurePerform']['procedure_date'],Configure::read('date_format'),false);
		$edit_data['ProcedurePerform']['final_verify_date'] = $this->DateFormat->formatDate2Local($edit_data['ProcedurePerform']['final_verify_date'],Configure::read('date_format'),true);
		$edit_data['ProcedurePerform']['procedure_to_date'] = $this->DateFormat->formatDate2Local($edit_data['ProcedurePerform']['procedure_to_date'],Configure::read('date_format'),false);
		echo $edit_data['ProcedurePerform']['procedure_name']."|".$edit_data['ProcedurePerform']['snowmed_code']."|".$edit_data['ProcedurePerform']['procedure_note']."|".$edit_data['ProcedurePerform']['id']."|".$edit_data['ProcedurePerform']['create_time']."|".$edit_data['ProcedurePerform']['procedure_date']."|".$edit_data['ProcedurePerform']['procedure_to_date']."|".$edit_data['ProcedurePerform']['modifier1']."|".$edit_data['ProcedurePerform']['modifier2']."|".$edit_data['ProcedurePerform']['modifier3']."|".$edit_data['ProcedurePerform']['modifier4']."|".$edit_data['ProcedurePerform']['code_type']."|".$edit_data['ProcedurePerform']['patient_daignosis']."|".$edit_data['ProcedurePerform']['units']."|".$edit_data['ProcedurePerform']['place_service']
		."|".$edit_data['ProcedurePerform']['uni_safety_protocol']."|".$edit_data['ProcedurePerform']['site_verified']."|".$edit_data['ProcedurePerform']['verified_with']."|".$edit_data['ProcedurePerform']['verified_verbally']."|".$edit_data['ProcedurePerform']['signed_informed']."|".$edit_data['ProcedurePerform']['informed_consent']."|".$edit_data['ProcedurePerform']['site_market']."|".$edit_data['ProcedurePerform']['site_required']."|".$edit_data['ProcedurePerform']['equipment_needed']."|".$edit_data['ProcedurePerform']['correct_marked_site']."|".$edit_data['ProcedurePerform']['correct_identified_site']."|".$edit_data['ProcedurePerform']['final_verification']."|".$edit_data['ProcedurePerform']['final_verify_date']."|".$edit_data['ProcedurePerform']['other_comment']."|".$edit_data['ProcedurePerform']['staff_comment'];
		exit;
	}

	public function delete_procedurePerform($id=null){
		$this->uses =array('ProcedurePerform');
		$this->ProcedurePerform->save(array('id'=>$id,'is_deleted' => 1));
		exit;
	}
	//EOF code related to Procedure

	public function toIpd($patientId,$noteId){
		$this->layout = 'advance_ajax' ;
		$this->uses =array('Role','ToIpd');

		if(!empty($this->params->query['patientId']))
			$this->set('patientId',$this->params->query['patientId']);

		if(!empty($this->params->query['noteId']))
			$this->set('noteId',$this->params->query['noteId']);

		$getId=$this->Role->find('first',array('fields'=>array('id','name'),'conditions'=>array('name'=>'Front Office Executive')));
		$this->set('getId',$getId);
		if(!empty($this->request->data['toIpd'])){
			$this->request->data['toIpd']['admission_date']=$this->DateFormat->formatDate2Local($this->request->data['toIpd']['admission_date'],Configure::read('date_format'),false);
			if($this->ToIpd->save($this->request->data['toIpd'])){
				$this->set('close','close');
			}
		}else{

		}

	}
	 
	public function clinicalNote($patientId=null,$appointmentId=null,$noteId=''){
		$this->layout = 'advance' ;
		$this->uses = array('NewCropAllergies','TemplateTypeContent','Template','Appointment','Note','Patient','TemplateSubCategories',
				'NoteTemplate','LabManager','RadiologyTestOrder','Diagnosis','PatientsTrackReport','Person','NoteDiagnosis','LabManager');
		/**********To set patient id in session for new patient hub when patiet in searched from this page- Pooja*********/
		$sessionPatientId=$this->Session->read('hub.patientid');
		if(empty($sessionPatientId) && !empty($patientId))
			$this->Patient->getSessionPatId($patientId);
		else{
			if(!empty($patientId)){
				if($sessionPatientId!=$patientId)
					$this->Patient->getSessionPatId($patientId);
			}
		}
		/*********************************************************************************************************/
		

		/** to create noteId **/
		$this->set('title_for_layout',__('SOAP Note'));  
		if($noteId == null && !empty($patientId)){ //for the first time	 
			$noteId=$this->Note->addBlankNote($patientId);  
			//attach note id with url 
			$this->redirect("/notes/clinicalNote/".$patientId."/".$appointmentId."/".$noteId);
		}
		 
		/** EOD **/

		/** for read only notes Aditya **/
		$personId=$this->Patient->find('first',array('fields'=>array('person_id'),'conditions'=>array('Patient.id'=>$patientId)));
		$getEncounterID=$this->Patient->getAllPatientIds($personId['Patient']['person_id']);

		$getEncounterIDList=$this->Note->find('all',array('fields'=>array('id'),
				'conditions'=>array('Note.patient_id'=>$getEncounterID,'Note.created_by'=>$this->Session->read('userid')),
				'order'=>array('id DESC')));
		if($noteId!=$getEncounterIDList['0']['Note']['id']){
			$this->set('readOnly',"readOnly");
		}else{

		}

		/** EOD **/
 		$this->Session->write('smartphrase_patient_id',$patientId);
		$this->set('patientId',$patientId);
		$this->set('noteId',$noteId);
		$this->Session->write('NoteId',$noteId);
		$this->set('appointmentId',$appointmentId);
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id= Patient.person_id')),
						'TariffStandard'=>array('foreignKey'=>false,'conditions'=>array('TariffStandard.id= Patient.tariff_standard_id')),
				)));

		$getBasicData=$this->Patient->find('first',array('fields'=>array('person_id','Person.dob','lookup_name','patient_id','age','sex','doctor_id',
				'patient_weight','Patient.admission_type','epenImages','Patient.tariff_standard_id','admission_id','patient_id','form_received_on','TariffStandard.name'),
				'conditions'=>array('Patient.id'=>$patientId)));
		
		$getCurrentAge=$this->Person->getCurrentAge($getBasicData['Person']['dob']);
		$this->set('getCurrentAge',$getCurrentAge);
		$this->set('getBasicData',$getBasicData);
		$this->set('personId',$getBasicData['Patient']['person_id']);
		/*$getDataFormNote=$this->Note->find('first',array('fields'=>array('template_full_text','small_text','create_time','physical_exam_weight'),
				'conditions'=>array('id'=>$noteId,'Note.created_by'=>$this->Session->read('userid'))));
		$this->set('getDataFormNote',$getDataFormNote);
			

		$personId=$this->Patient->find('first',array('conditions'=>array('id'=>$patientId),array('fields'=>array('person_id'))));
			
		$this->Patient->unbindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patientAllId=$this->Patient->find('list',array('conditions'=>array('person_id'=>$personId['Patient']['person_id'])
				,'fields'=>array('id','id')));
		
		
		$this->Note->bindModel(array(
				'belongsTo' => array(
						'Patient'=>array('foreignKey'=>false,'conditions'=>array('Note.patient_id= Patient.id')),
						'Appointment'=>array('foreignKey'=>false,'conditions'=>array('Appointment.patient_id= Patient.id')),
				)));
			
			
		$prevNotesList=$this->Note->find('all',array('conditions'=>array('Note.patient_id'=>$patientAllId,'Note.created_by'=>$this->Session->read('userid')),
				'fields'=>array('Note.id','Note.create_time')
				,'group'=>array('Note.id'),'order'=>array('Note.id DESC')));
		
		foreach($prevNotesList as $key=>$data){
			if($key!=0){
				$dateSet=explode(' ',$data['Note']['create_time']);
				$eleDataSet=explode('-',$dateSet['0']);
				$prevNotesListNew[$data['Note']['id']]=$eleDataSet[2]."/".$eleDataSet[1]."/".$eleDataSet[0];
			}
		}
		$this->set('prevNotesList',$prevNotesListNew);
		
		*/
		
		
		//fetch next 10 appointments
		$currentDayAppointment = $this->Note->getNextPatientList($patientId);//by atul
		$this->set('currentDayAppointment',$currentDayAppointment);
		
	}
	public function ajax_vital($patientId,$noteId,$appointmentId){
		$this->autoRender=false;
		$this->uses = array('Note','BmiResult');
		$this->set('patientId',$patientId);
		$this->set('noteId',$noteId);
		$this->set('appointmentId',$appointmentId);
		if(!empty($this->request->data)){
			
			$this->Note->ajax_vitalSave($this->request->data);
			echo 'save';
		}else{
			/** NOte Data**/
			$this->BmiResult->bindModel(array(
					'belongsTo' => array(
							//'BmiResult'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('BmiResult.patient_id= Note.patient_id')),
							'BmiBpResult'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('BmiBpResult.bmi_result_id= BmiResult.id')),
					)));
			$getHold=$this->BmiResult->find('all',array('fields'=>array('BmiResult.id','BmiResult.temperature','BmiResult.respiration','BmiResult.created_time',
				'BmiBpResult.id','BmiBpResult.systolic','BmiBpResult.diastolic','BmiBpResult.pulse_text'),
				'conditions'=>array('BmiResult.note_id'=>$noteId,'BmiResult.created_by'=>trim($this->Session->read('userid')),
						),'order'=>array('BmiResult.id desc	')));
			$this->set('getHold',$getHold);			
		}
		echo $this->render('ajax_vital');
		exit;
	}
	/*public function updateData($paitentId,$noteId,$appointmentId=null){
	 $updateArray=array();
	$updateArray['Note']['patient_id']=$paitentId;
	$updateArray['Note']['id']=$noteId;
	$updateArray['Note'][$this->params->query['type']]=$this->request->data['id'];
	$getSaveStatus=$this->Note->updateNoteData($updateArray);
	echo $getSaveStatus;
	exit;
	}
	public function updateDataCC($paitentId,$noteId,$appointmentId=null){
	$this->uses=array('Diagnosis');
	$getDiagnosisId=$this->Diagnosis->find('first',array('fields'=>array('id'),'conditions'=>array('patient_id'=>$paitentId)));
	if(!empty($getDiagnosisId)){
	$this->Diagnosis->updateAll(array('complaints'=>$this->request->data['id']),array('id'=>$getDiagnosisId['Diagnosis']['id']));
	}else{
	$this->Diagnosis->save(array('complaints'=>$this->request->data['id']));
	}

	}*/
	public function loadCc($patientId,$noteId,$appointmentId){
		$this->uses=array('Diagnosis','NoteDiagnosis','Patient','DiagnosisDetail','DoctorTemplate','DoctorTemplateText');
		if(!empty($this->request->data)){
			// following if case for to save daily chief complaint of IPD patient
			if($this->request->data['admission_type']=="IPD"){
				
				if(!empty($this->request->data['NoteDiagnosis']['testCode'])){
					$getNoteDiagnosis=$this->NoteDiagnosis->find('first',array('fields'=>array('diagnoses_name'),'conditions'=>array('patient_id'=>$patientId,'diagnosis_id'=>$this->request->data['NoteDiagnosis']['testCode'],'is_deleted'=>0,'note_id'=>$noteId,'code_system'=>'1')));
					if(empty($getNoteDiagnosis['NoteDiagnosis']['diagnoses_name'])){
						$this->request->data['NoteDiagnosis']['diagnosis_id']=$this->request->data['NoteDiagnosis']['testCode'];
						$this->request->data['NoteDiagnosis']['created_by']=$this->Session->read('userid');
						$this->NoteDiagnosis->save($this->request->data['NoteDiagnosis']);
					}
				}
				
				$getIpdDiagId=$this->DiagnosisDetail->find('first',array('fields'=>array('id'),'conditions'=>array(
						'id'=>$this->request->data['diagnosisDetailId'])));
			
				if(!empty($getIpdDiagId)){
					$com=$this->request->data['Diagnosis']['complaints'];
					$comDate=$this->DateFormat->formatDate2STD($this->request->data['DiagnosisDetail']['complaint_date'],Configure::read('date_format'));
					$this->DiagnosisDetail->updateAll(array('complaints'=>"'$com'",'complaint_date'=>"'$comDate'"),array('id'=>$getIpdDiagId['DiagnosisDetail']['id']));
				}else{
				if(!empty($this->request->data['DiagnosisDetail']['complaint_date'])){
					$complaintDate=$this->DateFormat->formatDate2STD($this->request->data['DiagnosisDetail']['complaint_date'],Configure::read('date_format'));
				}else{
					$complaintDate=date('Y-m-d H:i:s');
				}
				$this->DiagnosisDetail->save(array('complaints'=>$this->request->data['Diagnosis']['complaints'],
						'patient_id'=>$this->request->data['patientId'],'note_id'=>$this->request->data['noteId'],
						'created_by'=>$this->Session->read('userid'),
						'complaint_date'=>$complaintDate));
				}
				
				if($this->request->data['is_template']=='1'){
					$templateArry=array();
					$templateArry['DoctorTemplate']['template_type']= $this->request->data['complaintType'];
					$templateArry['DoctorTemplate']['template_name']= trim($this->request->data['templateName']);
					$this->DoctorTemplate->insertGeneralTemplate($templateArry,'insert');// insert diagnosis as template name
						
					$getDoctorTemplateId=$this->DoctorTemplate->getLastInsertID();// get the last inserted id of doctors template
						
					$templateTextArry=array();
					$templateTextArry['DoctorTemplateText']['template_id']=$getDoctorTemplateId;
					$templateTextArry['DoctorTemplateText']['template_text']=$this->request->data['Diagnosis']['complaints'];
					$this->DoctorTemplateText->insertTemplateText($templateTextArry,'insert');// insert complaint as  as template text
				}
			}else{
				// save diagnosis
				if(!empty($this->request->data['NoteDiagnosis']['testCode'])){
					$getNoteDiagnosis=$this->NoteDiagnosis->find('first',array('fields'=>array('diagnoses_name'),'conditions'=>array('patient_id'=>$patientId,'diagnosis_id'=>$this->request->data['NoteDiagnosis']['testCode'],'is_deleted'=>0,'note_id'=>$noteId,'code_system'=>'1')));
					if(empty($getNoteDiagnosis['NoteDiagnosis']['diagnoses_name'])){
						$this->request->data['NoteDiagnosis']['diagnosis_id']=$this->request->data['NoteDiagnosis']['testCode'];
						$this->request->data['NoteDiagnosis']['created_by']=$this->Session->read('userid');
						$this->NoteDiagnosis->save($this->request->data['NoteDiagnosis']);
					}
				}
				
				// save chief complaints
				$getDiagnosisId=$this->Diagnosis->find('first',array('fields'=>array('id'),'conditions'=>array(
						'patient_id'=>$this->request->data['patientId']/*,'created_by'=>$this->Session->read('userid')*/)));
				
				if(!empty($getDiagnosisId)){
					$com=$this->request->data['Diagnosis']['complaints'];
					$saveStatus=$this->Diagnosis->updateAll(array('complaints'=>"'$com'"),array('id'=>$getDiagnosisId['Diagnosis']['id']));
				}else{
					$saveStatus=$this->Diagnosis->save(array('complaints'=>$this->request->data['Diagnosis']['complaints'],
							'patient_id'=>$this->request->data['patientId'],'note_id'=>$this->request->data['noteId'],
							'created_by'=>$this->Session->read('userid'),
							'appointment_id'=>$this->request->data['appointmentId']));
					}
				// save doctors template	
				if($this->request->data['is_template']=='1'){
					
					$templateName=trim($this->request->data['templateName']);
					$checkTemplateExist=$this->DoctorTemplate->find('first',array('fields'=>array('id','template_name'),'conditions'=>array('Doctortemplate.template_name'=>$templateName,'Doctortemplate.is_deleted'=>'0')));
					
					// check if template name already exist, if exist then add template text under that template name
					if($checkTemplateExist['DoctorTemplate']['id']){
						
						$templateTextArry=array();
						$templateTextArry['DoctorTemplateText']['template_id']=$checkTemplateExist['DoctorTemplate']['id'];
						$templateTextArry['DoctorTemplateText']['template_text']=$this->request->data['Diagnosis']['complaints'];
						$this->DoctorTemplateText->insertTemplateText($templateTextArry,'insert');// insert complaint as  as template text
						
					}else{
					
						$templateArry=array();
						$templateArry['DoctorTemplate']['template_type']= $this->request->data['complaintType'];
						$templateArry['DoctorTemplate']['template_name']= $this->request->data['templateName'];
						$this->DoctorTemplate->insertGeneralTemplate($templateArry,'insert');// insert diagnosis as template name
						
						$getDoctorTemplateId=$this->DoctorTemplate->getLastInsertID();// get the last inserted id of doctors template
						
						$templateTextArry=array();
						$templateTextArry['DoctorTemplateText']['template_id']=$getDoctorTemplateId;
						$templateTextArry['DoctorTemplateText']['template_text']=$this->request->data['Diagnosis']['complaints'];
						$this->DoctorTemplateText->insertTemplateText($templateTextArry,'insert');// insert complaint as  as template text
					}
			   }
			   
			   
			 }
		}
		
		$getAdmissionType=$this->Patient->find('first',array('fields'=>array('Patient.id','Patient.admission_type'),
				'conditions'=>array('Patient.id'=>$patientId)));
		
		if($getAdmissionType['Patient']['admission_type']=='IPD'){
			$ipdCCData=$this->DiagnosisDetail->find('all',array('fields'=>array('id','patient_id','note_id','complaints','complaint_date'),
					'conditions'=>array('patient_id'=>$patientId,'note_id'=>$noteId)));
		$this->set('ipdCCData',$ipdCCData);
		}else{
			$putCCData=$this->Diagnosis->find('first',array('fields'=>array('complaints'),
					'conditions'=>array('appointment_id'=>$appointmentId,'created_by'=>$this->Session->read('userid'))));
		}
		
		$this->NoteDiagnosis->unbindModel(array('belongsTo'=>array('icds')));
		$diagnosisList=$this->NoteDiagnosis->find('all',array('fields'=>array('id','diagnoses_name','diagnosis_id'),'conditions'=>array('patient_id'=>$patientId,'is_deleted'=>0)));
		$this->set('diagnosisList',$diagnosisList);
		$this->set('putCCData',$putCCData);
		$this->set('appointmentId',$appointmentId);
		$this->set('patientId',$patientId);
		$this->set('noteId',$noteId);
		$this->set('saveStatus',$saveStatus);
		$this->set('getAdmissionType',$getAdmissionType);
		 
		echo $this->render('load_cc');
		exit;
	}
	public function loadSubjective($patientId,$noteId,$appointmentId=null){
		if(!empty($this->request->data)){

			$updateArray=array();
			$updateArray['Note']['patient_id']=$this->request->data['patientId'];
			$updateArray['Note']['id']=$this->request->data['noteId'];
			if($this->params->query['type']=='subject'){
				$updateArray['Note'][$this->params->query['type']]=$this->request->data['Hpi'];
			}else{
				$updateArray['Note'][$this->params->query['type']]=$this->request->data['Ros'];
			}
			$this->Note->updateNoteData($updateArray);
		}else{
			$putSubData=$this->Note->find('first',array('fields'=>array('subject','ros'),
					'conditions'=>array('id'=>$noteId,'Note.created_by'=>$this->Session->read('userid'))));
			$this->set('putSubData',$putSubData);
		}
		$this->set('toshowFields',$this->params->query['typeShow']);
		$this->set('appointmentId',$appointmentId);
		$this->set('patientId',$patientId);
		$this->set('noteId',$noteId);
		echo $this->render('load_subjective');
		exit;
	}
	public function loadObjective($patientId,$noteId,$appointmentId=null){	
		$this->loadModel('Patient');	
		if(!empty($this->request->data)){
			$updateArray=array();
			$updateArray['Note']['patient_id']=$this->request->data['patientId'];
			$updateArray['Note']['id']=$this->request->data['noteId'];
			if($this->params->query['type']=='object'){
				$updateArray['Note'][$this->params->query['type']]=$this->request->data['object'];
				$updateArray['Note']['physical_exam_weight']=serialize($this->request->data['BmiResult']);
			}		
			$this->Note->updateNoteData($updateArray);
			if(!empty($patientId)){
				$updatePatientArray['Patient']['id']=$patientId;
				$updatePatientArray['Patient']['patient_weight']=$this->request->data['BmiResult']['weight_result'];
				$this->Patient->save($updatePatientArray['Patient']);
			}
			
		}else{
			$putObjData=$this->Note->find('first',array('fields'=>array('object','physical_exam_weight'),
					'conditions'=>array('id'=>$noteId,'Note.created_by'=>$this->Session->read('userid'))));
			$putPatientData=$this->Patient->find('first',array('fields'=>array('patient_weight'),
					'conditions'=>array('id'=>$patientId)));
			$this->set('putPatientData',$putPatientData);
			$unserObjWeightData=unserialize($putObjData['Note']['physical_exam_weight']);			
			$this->set('unserObjWeightData',$unserObjWeightData);
			$this->set('putObjData',$putObjData);
		}
		$this->set('toshowFields',$this->params->query['typeShow']);
		$this->set('appointmentId',$appointmentId);
		$this->set('patientId',$patientId);
		$this->set('noteId',$noteId);
		//if(empty($this->params->query['weightResult'])){
			echo $this->render('load_objective');
		//}else{
		//	echo $this->params->query['weightResult'];
		//}
		exit;
	}
	public function loadAssis($patientId,$noteId,$appointmentId=null){
		if(!empty($this->request->data)){
			$updateArray=array();
			$updateArray['Note']['patient_id']=$this->request->data['patientId'];
			$updateArray['Note']['id']=$this->request->data['noteId'];
			if($this->params->query['type']=='assis'){
				$updateArray['Note'][$this->params->query['type']]=$this->request->data['assis'];
			}
			$this->Note->updateNoteData($updateArray);
		}else{
			$putAssisData=$this->Note->find('first',array('fields'=>array('assis'),
					'conditions'=>array('id'=>$noteId,'Note.created_by'=>$this->Session->read('userid'))));
			$this->set('putAssisData',$putAssisData);
		}
		$this->set('toshowFields',$this->params->query['typeShow']);
		$this->set('appointmentId',$appointmentId);
		$this->set('patientId',$patientId);
		$this->set('noteId',$noteId);
		echo $this->render('load_ass');
		exit;
	}
	public function loadPlan($patientId,$noteId,$appointmentId=null){
		if(!empty($this->request->data)){
			$updateArray=array();
			$updateArray['Note']['patient_id']=$this->request->data['patientId'];
			$updateArray['Note']['id']=$this->request->data['noteId'];
			if($this->params->query['type']=='plan'){
				$updateArray['Note'][$this->params->query['type']]=$this->request->data['plan'];
			}
			$this->Note->updateNoteData($updateArray);
		}else{
			$putPlanData=$this->Note->find('first',array('fields'=>array('plan'),
					'conditions'=>array('id'=>$noteId,'Note.created_by'=>$this->Session->read('userid'))));
			$this->set('putPlanData',$putPlanData);
		}
		$this->set('toshowFields',$this->params->query['typeShow']);
		$this->set('appointmentId',$appointmentId);
		$this->set('patientId',$patientId);
		$this->set('noteId',$noteId);
		echo $this->render('load_plan');
		exit;
	}
	public function getSubData($patientId,$noteId,$appointmentId=null){
		$this->uses=array('Note','LaboratoryTestOrder','RadiologyTestOrder','NewCropPrescription','NoteDiagnosis','Template','TemplateTypeContent','NewCropAllergies','Appointment','Patient');
		$this->layout=false;
		/** NOte Data**/
		$this->Note->bindModel(array(
				'belongsTo' => array(
						'Diagnosis'=>array('foreignKey'=>false,'conditions'=>array('Diagnosis.note_id= Note.id')),
						'BmiResult'=>array('foreignKey'=>false,'conditions'=>array('BmiResult.patient_id= Note.patient_id')),
						'BmiBpResult'=>array('foreignKey'=>false,'conditions'=>array('BmiBpResult.bmi_result_id= BmiResult.id')),
				)));
		$getHold=$this->Note->find('first',array('fields'=>array('BmiResult.temperature','BmiResult.respiration',
				'BmiBpResult.systolic','BmiBpResult.diastolic','BmiBpResult.pulse_text','Note.subject','Note.object','Note.assis',
				'Note.plan','Note.ros','Diagnosis.complaints'),
				'conditions'=>array('Note.id'=>$noteId,'Note.created_by'=>trim($this->Session->read('userid')),
						/*'BmiResult.created_by'=>trim($this->Session->read('userid'))*/)));
		
		
		$personId=$this->Patient->find('first',array('fields'=>array('Patient.person_id'),'conditions'=>array('Patient.id'=>$patientId)));
	
		$getEncounterID=$this->Note->encounterHandler($patientId,$personId['Patient']['person_id']);
		$key='';
		foreach ($getEncounterID as $key=>$val){
	
		} 
		unset($getEncounterID[$key]); 
		
		$prevSoapData=$this->Note->find('all',array('fields'=>array('Note.id','Note.patient_id','Note.create_time'),
							'conditions'=>array('Note.patient_id'=>$getEncounterID)));
		
		$this->set('prevSoapData',$prevSoapData);
		/** Lab data **/
		$getLabData=$this->getSmartLab($patientId,$noteId);
		/** Rad data **/
		$getRadData=$this->getSmartRad($patientId,$noteId);
		/** MRi data **/
		$getMridData=$this->getSmartMRI($patientId);
		/** Medication Data **/
		$getMedData=$this->getSmartMed($patientId);
		
		$getAllergyData=$this->getSmartAllergy($patientId);
		/** NoteDiagnosis **/
		$getNoteDiagnosisData=$this->getSmartDia($noteId);
		$this->set('getAllergyData',$getAllergyData);
		$this->set('patientId',$patientId);
		$this->set('noteId',$noteId);
		$this->set('appointmentId',$appointmentId);
		$this->set('getSubData',$getHold);
		$this->set('getLabData',$getLabData);
		$this->set('getRadData',$getRadData);
		$this->set('getMridData',$getMridData);
		$this->set('getMedData',$getMedData);
		$this->set('getNoteDiagnosisData',$getNoteDiagnosisData);
		echo $this->render('get_sub_data');
		exit;
	}
	public function saveMinLab($patientId,$tariffStdID=Null,$admissionType=Null){
		$this->layout='ajax';
		$this->autoRender=false;
		$role = $this->Session->read('role');
		$this->uses=array('Laboratory','LaboratoryTestOrder','RadiologyTestOrder','Radiology','ProcedurePerform','Billing','ServiceBill');
			
		/*$explodeIdLab=explode(",",$this->request->data['labName']);
		$explodeIdRad=explode(",",$this->request->data['RadId']);
		$explodeIdProcedure=explode(",",$this->request->data['ProcedureId']);
		$explodeServiceId=explode(",",$this->request->data['serviceId']);
		$noteId=$this->request->data['noteId'];
		*/
		$noteId=$this->request->data['noteId'];
		$labRecord=$this->request->data['lab'];
		$radRecord=$this->request->data['radiology'];
		$tariffRecord=$this->request->data['tariff_list'];
		$serviceCatId=$this->request->data['serCatID'];
		$roomType=$this->request->data['roomType'];
		
		
		/** Laboratory save**/
		if(!empty($labRecord)){
			foreach($labRecord as $key=>$idLab){
				$rate=$this->Laboratory->getRate($idLab,$tariffStdID);			
				$dataLab['LaboratoryTestOrder'][$key]['lab_id']=$idLab;
				if(empty($rate['TariffAmountType']['opd_charge'])){
					$charge="0.00";
				}else{
					$charge=$rate['TariffAmountType']['opd_charge'];
				}
				
			    $dataLab['LaboratoryTestOrder'][$key]['doctor_id']=$this->Session->read('userid');
				$dataLab['LaboratoryTestOrder'][$key]['amount']=$charge;
				$dataLab['LaboratoryTestOrder'][$key]['start_date']=date('Y-m-d H:i:s');
				$dataLab['LaboratoryTestOrder'][$key]['start_date']=date('Y-m-d H:i:s');
				$dataLab['LaboratoryToken'][$key][lab_id]=$idLab;
			}
		
			$this->LaboratoryTestOrder->insertMultipleTestOrder($dataLab,$patientId,$noteId);
			$this->id='';
		}
		/** EOD **/

		/** Radiology save**/
		if(!empty($radRecord)){
			foreach($radRecord as $key=>$idRad){
				$rate=$this->Radiology->getRate($idRad,$tariffStdID);
				if(empty($rate['TariffAmountType']['opd_charge'])){
					$charge="0.00";
				}else{
					$charge=$rate['TariffAmountType']['opd_charge'];
				}
				$dataRad[$key]['RadiologyTestOrder']['doctor_id']=$this->Session->read('userid');
				$dataRad[$key]['RadiologyTestOrder']['amount']=$charge;
				$dataRad[$key]['RadiologyTestOrder']['rad_id']=$idRad;
				$dataRad[$key]['RadiologyTestOrder']['patient_id']=$patientId;
				$dataRad[$key]['RadiologyTestOrder']['is_processed']='0';
			}
			$this->RadiologyTestOrder->insertMinRad($dataRad,$noteId);

		}
		/** EOD **/

		/** MRi save**/
		if(!empty($explodeIdProcedure['0'])){
			foreach($explodeIdProcedure as $key=>$idMri){
				$rate=$this->Radiology->getRate($idMri,$tariffStdID);
				if(empty($rate['TariffAmountType']['opd_charge'])){
					$charge="0.00";
				}else{
					$charge=$rate['TariffAmountType']['opd_charge'];
				}
				$dataRad[$key]['RadiologyTestOrder']['amount']=$charge;
				$dataRad[$key]['RadiologyTestOrder']['rad_id']=$idMri;
				$dataRad[$key]['RadiologyTestOrder']['patient_id']=$patientId;
				$dataRad[$key]['RadiologyTestOrder']['is_processed']='1';

			}
			$this->RadiologyTestOrder->insertMinRad($dataRad);

		}
		/** EOD **/

		/** other service save**/
		if(!empty($tariffRecord)){
			foreach($tariffRecord as $key=>$idSer){
				$rate=$this->Billing->getOtherServiceRate($idSer,$patientId,$admissionType,$tariffStdID,$roomType);
				if(empty($rate)){
					$charge="0.00";
				}else{
					$charge=$rate;
				}
				$dataOtherSerArr['ServiceBill']['tariff_list_id']=$idSer;
				$dataOtherSerArr['ServiceBill']['amount']=$charge;
				$dataOtherSerArr['ServiceBill']['date']=date('Y-m-d H:i:s');
				$dataOtherSerArr['ServiceBill']['service_id']=$serviceCatId;
				$dataOtherSerArr['ServiceBill']['patient_id']=$patientId;
				$dataOtherSerArr['ServiceBill']['tariff_standard_id']=$tariffStdID;
				$dataOtherSerArr['ServiceBill']['doctor_id']=$this->Session->read('userid');
				$dataOtherSerArr['ServiceBill']['no_of_times']='1';
				$dataOtherSerArr['ServiceBill']['create_time'] = date("Y-m-d H:i:s");
				$dataOtherSerArr['ServiceBill']['created_by']  = $this->Session->read('userid') ;
				$dataOtherSerArr['ServiceBill']['location_id']  = $this->Session->read('locationid') ;
				$this->ServiceBill->saveAll($dataOtherSerArr['ServiceBill']);
				$this->id='';
			}
			
			
		}
		/** EOD **/

		/* Procedure Save
		 if(!empty($explodeIdProcedure['0'])){
			foreach($explodeIdProcedure as $key=>$idProcedure){
			$arr['ProcedurePerform']['patient_id']=$patientId;
			$arr['ProcedurePerform']['procedure_name']=$idProcedure;
			$this->ProcedurePerform->insertProcedurePerform($arr);
			}

			}
			*/


		//BOF lab listing
		/*$doctorId= $this->Session->read('userid');
		if(isset($this->request->data['RadId']) && !empty($this->request->data['RadId'])){			
			$radData = $this->RadiologyTestOrder->getRadiologyDetails(array('RadiologyTestOrder.patient_id'=>$patientId,'RadiologyTestOrder.doctor_id'=>$doctorId));
			$this->set('radData',$radData);			
			$this->render('ajax_rad_list') ;
		}else if(isset($this->request->data['labName']) && !empty($this->request->data['labName'])){			 
			$labData = $this->LaboratoryTestOrder->getLabDetails(array('LaboratoryTestOrder.patient_id'=>$patientId,'LaboratoryTestOrder.doctor_id'=>$doctorId));		 
			$this->set('labData',$labData);
			$this->render('ajax_lab_list') ;
		}else{	 
			$serviceData = $this->ServiceBill->getServices(array('ServiceBill.patient_id'=>$patientId,'ServiceBill.doctor_id'=>$doctorId)); 
			$this->set('serviceData',$serviceData);
			//EOF pankaj
			$this->render('ajax_service_list');
		}*/  
		
		// Above lab listing code commented by atul.bcz we reload ajax after save.
		//EOF lab listing 
			
	}
	public function ajax_add_lab($patientId,$noteId=null,$appointmentId=null){
		$this->layout='ajax'; 
		$this->uses=array('Laboratory','TariffStandard','Patient','LaboratoryTestOrder');
		$getPreSelectedLab=$this->Laboratory->find('all',array('fields'=>array('id','name'),'conditions'=>array('template_lab'=>'1')));
		$this->set('getPreSelectedLab',$getPreSelectedLab);
		$tariffStandardId=$this->TariffStandard->getTariffIDByPatientId($patientId);
		$this->set('tariffStandardId',$tariffStandardId);
		$this->set('patientId',$patientId);
		$this->set('noteId',$noteId);
		$this->set('appointmentId',$appointmentId);
		//BOF lab listing
		$doctorId= $this->Session->read('userid');
		$labData = $this->LaboratoryTestOrder->getLabDetails(array('LaboratoryTestOrder.patient_id'=>$patientId,'LaboratoryTestOrder.doctor_id'=>$doctorId));		 
		$this->set('labData',$labData);
		//EOF lab listing
		
		echo $this->render('ajax_add_lab');
		exit;
	}
	
	
	public function ajax_add_rad($patientId,$noteId=null,$appointmentId=null){
		$this->layout='ajax';
		$this->uses=array('Radiology','TariffStandard','Patient','RadiologyTestOrder');
		$getPreSelectedRad=$this->Radiology->find('all',array('fields'=>array('id','name'),'conditions'=>array('template_rad'=>'1')));
		$this->set('getPreSelectedRad',$getPreSelectedRad);
		$tariffStandardId=$this->TariffStandard->getTariffIDByPatientId($patientId);
		$this->set('tariffStandardId',$tariffStandardId);
		$this->set('patientId',$patientId);
		$this->set('noteId',$noteId);
		$this->set('appointmentId',$appointmentId);
		//BOF lab listing
		$doctorId= $this->Session->read('userid');
		$radData = $this->RadiologyTestOrder->getRadiologyDetails(array('RadiologyTestOrder.patient_id'=>$patientId,'RadiologyTestOrder.doctor_id'=>$doctorId));
		$this->set('radData',$radData);
		//EOF lab listing
		
		echo $this->render('ajax_add_rad');
		exit;
	}
	public function ajax_sopa_menu($patientId){
		$this->layout='ajax';
		$this->set('patientId',$patientId);
		echo $this->render('ajax_sopa_menu');
		exit;
	}
	public function loadSmartText($patientId,$noteId,$appointmentId){
		$this->uses=array('Note');
		$arry['Note']['template_full_text']=$this->request->data['template_full_text'] ;
		$arry['Note']['id']=$noteId;
		if($this->Note->save($arry)){
			echo 'save';
		}else{
			echo 'Not saved';
		}
			
		exit;
			
	}
	public function getLabRate($id, $tariffStandardId=null){
		$this->layout='ajax';
		$this->uses=array('Laboratory','TariffStandard');
		$getRate=$this->Laboratory->getRate($id,$tariffStandardId);
		if(empty($getRate['TariffAmountType']['opd_charge'])){
			$putRate="0.00";
		}else{
			$putRate=$getRate['TariffAmountType']['opd_charge'];
		}
		echo $putRate." Rs";
		exit;
	}

	public function getRadRate($id,$tariffStandardId=null){
		$this->layout='ajax';
		$this->uses=array('Radiology','TariffStandard');
		$getRateRad=$this->Radiology->getRate($id,$tariffStandardId);
		if(empty($getRateRad['TariffAmountType']['opd_charge'])){
			$putRate1="0.00";
		}else{
			$putRate1=$getRateRad['TariffAmountType']['opd_charge'];
		}
		echo $putRate1." Rs";
		exit;
	}
	public function getRichTextData($id){
		$this->layout='ajax';
		$this->uses=array('Note');
		$getFullrichData=$this->Note->find(first,array('fields'=>array('template_full_text'),
				'conditions'=>array('id'=>$id,'Note.created_by'=>$this->Session->read('userid'))));
		echo $getFullrichData['Note']['template_full_text'];
		exit;
	}
	/** EOD **/
	public function InsetEditorData($patientId,$id,$appointmentId){
		$this->layout='ajax';
		$this->uses=array('Note','PharmacyItem','NewCropPrescription','Patient');
		$arryData['id']=$id;		
		$personId=$this->Patient->find('first',array('conditions'=>array('id'=>$patientId),array('fields'=>array('person_id','doctor_id'))));
		
		if(empty($this->request->data['NoteDiagnosis']['template_full_text'])){
		$this->NewCropPrescription->deleteAll(array('NewCropPrescription.patient_uniqueid'=>$patientId,'NewCropPrescription.note_id'=>$id,'NewCropPrescription.is_deleted'=>0/*,'NewCropPrescription.editor_med_chk'=>'1'*/));
		}	
		$templateFullTextArray=explode(",",$this->request->data['NoteDiagnosis']['template_full_text']);
		
		
		//delete medication first if already present
		//$this->NewCropPrescription->deleteAll(array('NewCropPrescription.patient_uniqueid'=>$patientId,'NewCropPrescription.patient_id'=>$personId['Patient']['person_id'],'NewCropPrescription.note_id'=>$id,false));
		foreach($templateFullTextArray as $keyMedNew=>$templateFullTextArrays){		
		
			$explodedDataMedName[$keyMedNew]=explode("::",$templateFullTextArrays);
			
			$explodedOnlyFinalMedName[$keyMedNew]=explode("---",$explodedDataMedName[$keyMedNew]['1']);
			$expMedNamArr[$keyMedNew]=trim($explodedOnlyFinalMedName[$keyMedNew]['0']);		
			
			if(empty($expMedNamArr[$keyMedNew])){
				continue;
			}
		
			if($this->Session->read('website.instance')=='kanpur' && $this->Session->read('locationid')=='22'){//to reduce stock from pharma extention  --Mahalaxmi
				$conditionsArr["PharmacyItem.location_id"] = '26';
			}else if($this->Session->read('website.instance')=='kanpur' && $this->Session->read('locationid')=='1'){//to reduce stock from pharma extention  --Mahalaxmi
				$conditionsArr["PharmacyItem.location_id"] = '25';
			}else{
				$conditionsArr["PharmacyItem.location_id"] = $this->Session->read('locationid');
			}
			$conditionsArr["PharmacyItem.name"]=$expMedNamArr[$keyMedNew];
			$conditionsArr["PharmacyItem.is_deleted"]="0";
			$getPharmacyItemDatacount=$this->PharmacyItem->find('count',array('conditions'=>$conditionsArr));		
			if(!$getPharmacyItemDatacount){				
				$expMedNamArr[$keyMedNew] =str_replace('&quot;','"',$expMedNamArr[$keyMedNew]);
				$expMedNamArr[$keyMedNew] =str_replace("&#39;","'",$expMedNamArr[$keyMedNew]);
				$expMedNamArr[$keyMedNew] =str_replace("&amp;","&",$expMedNamArr[$keyMedNew]);
				$savePharmacyItemArray['name']=$expMedNamArr[$keyMedNew];
				$savePharmacyItemArray['created_by']=$this->Session->read('userid');
				$savePharmacyItemArray['create_time']=date("Y-m-d H:i:s");
				$savePharmacyItemArray['location_id']=$conditionsArr["PharmacyItem.location_id"];
				$this->PharmacyItem->id='';
				$this->PharmacyItem->save($savePharmacyItemArray);
				$getPharmacyItemId=$this->PharmacyItem->getLastInsertID();
				$savePharmacyItemUpdateArray['PharmacyItem']['drug_id']=$getPharmacyItemId;
				$savePharmacyItemUpdateArray['PharmacyItem']['id']=$getPharmacyItemId;
				$this->PharmacyItem->save($savePharmacyItemUpdateArray['PharmacyItem']);
				
			}	
		}	
	
		
		$expMedNamArr=array_filter($expMedNamArr);	
		//find id from pharmacy item table from the drug name
		if($this->Session->read('website.instance')=='kanpur' && $this->Session->read('locationid')=='22'){//to reduce stock from pharma extention  --Mahalaxmi
		 $conditions["PharmacyItem.location_id"] = '26';
		}else if($this->Session->read('website.instance')=='kanpur' && $this->Session->read('locationid')=='1'){//to reduce stock from pharma extention  --Mahalaxmi
		$conditions["PharmacyItem.location_id"] = '25';
		}else{
		$conditions["PharmacyItem.location_id"] = $this->Session->read('locationid');
		}
		//$conditions["PharmacyItem.stock >"]='0'; ///Commented By Mahalaxmi-this condition use after new db
		$conditions["PharmacyItem.name"]=$expMedNamArr;
		$conditions["PharmacyItem.is_deleted"]="0";
		$getPharmacyItemData=$this->PharmacyItem->find('list',array('fields'=>array('id','name'),'conditions'=>$conditions));
	
		$getNewCropPrescriptionAllData=$this->NewCropPrescription->find('list',array('fields'=>array('id','drug_id'),
				'conditions'=>array('NewCropPrescription.is_deleted'=>0,'NewCropPrescription.note_id'=>$id,
						'NewCropPrescription.created_by'=>$this->Session->read('userid'),
				/*,'NewCropPrescription.editor_med_chk'=>'1'*/)));
		$getPharmacyItemData = array_map('strtolower', $getPharmacyItemData);
	
		//$cnt=0;
		$uniqueName = time();
		foreach($expMedNamArr as $key=>$value){	
			
			$newdrugId = array_search(strtolower($value), $getPharmacyItemData);	
			
			if(in_array($newdrugId,$getNewCropPrescriptionAllData)){					
				$unsetMedId = array_search($newdrugId, $getNewCropPrescriptionAllData);					
				unset($getNewCropPrescriptionAllData[$unsetMedId]);
				continue;
			}else{
				
				$templateFullTextArrayData=strip_tags($templateFullTextArray[$key]);			
				$templateFullTextArrayData=trim($templateFullTextArrayData);		
				if($templateFullTextArrayData=='&nbsp;' || empty($templateFullTextArrayData) || $templateFullTextArrayData=='&NBSP;' || $templateFullTextArrayData=='&amp;NBSP;' || $templateFullTextArrayData=='&amp;nbsp;')
					continue;
					
				//explode order sentence to make an array of all data and insert into newcropprescription
				$explodedData=explode("---",$templateFullTextArrayData);			
				$drugName=explode("::",$explodedData[0]);		
				$dosageValue=explode(" ",$drugName[0]);							
				
				if(empty($drugName[1])) // continue the loop if text entered in editor is not DRUG
					continue;
				
				$selected_strength=Configure :: read('selected_strength');
				$selected_route=Configure :: read('selected_route_administration');
				$dosage=explode(":",trim($explodedData[1]));
				$dosageStrength=explode(" ",$dosage[0]);
				$selected_frequency=Configure :: read('selected_frequency');
				$selected_roop=Configure :: read('selected_roop');
				$route=explode("/",$dosage[1]);
				$frequency=explode("x",$route[1]);
					
				$getQuantityForDisp=explode("#", $templateFullTextArrayData);
			
				if(empty($frequency[1]))
					$frequency=explode("X",$route[1]);
				
				//debug($drugName[1]);
				$drugName[1] =str_replace('&quot;','"',$drugName[1]);
				$drugName[1] =str_replace("&amp;","&",$drugName[1]);
				$drugName[1] =str_replace("&#39;","'",$drugName[1]);
				$medData['drug_name']=trim($drugName[1]);
				$medData['description']=trim($drugName[1]);
				$medData['dose']=$dosageStrength[0];
				$medData['strength']=$selected_roop[trim(strtoupper($dosageValue[1]))];
				$medData['route']=$selected_route[trim(strtoupper($route[0]))];
				$medData['frequency']=$selected_frequency[trim(strtoupper($frequency[0]))];				
				$getDayValue=explode("#",trim($frequency[1]));
				$medData['day']=$getDayValue['0'];
				$medData['archive']="N";
				$medData['patient_uniqueid']=$patientId;
				$medData['patient_id']=$personId['Patient']['person_id'];
				$medData['location_id']=$this->Session->read('locationid');
				$medData['DosageForm']=$selected_strength[strtoupper($dosageStrength[1])];
				$medData['dosageValue']=trim($dosageValue[0]);
				
				//calculate quantity
				$frequency_value=Configure :: read('frequency_value');
				
				
				if($medData['frequency']=='1'||$medData['frequency']=='2'||$medData['frequency']=='4'||$medData['frequency']=='18' || $medData['frequency']=='19' || $medData['frequency']=='35' || $medData['frequency']=='32'
						|| $medData['frequency']=='31' || $medData['frequency']=='34' || $medData['frequency']=='35' || $medData['frequency']=='42'|| $medData['frequency']=='43'|| $medData['frequency']=='44')$freq='1';
				if($medData['frequency']=='5'||$medData['frequency']=='11' ||$medData['frequency']=='36'||$medData['frequency']=='37')$freq='2';
				if($medData['frequency']=='6'||$medData['frequency']=='10')$freq='3';
				if($medData['frequency']=='7'||$medData['frequency']=='9' ||$medData['frequency']=='24')$freq='4';
				if($medData['frequency']=='28'||$medData['frequency']=='24')$freq='8';
				if($medData['frequency']=='26'||$medData['frequency']=='12'||$medData['frequency']=='39')$freq='0.5';
				if($medData['frequency']=='29')$freq='12';
				if($medData['frequency']=='8')$freq='6';
				if($medData['frequency']=='23')$freq='0.33';
				if($medData['frequency']=='14' || $medData['frequency']=='40')$freq='0.1429';
				if($medData['frequency']=='15' || $medData['frequency']=='38')$freq='0.0714';
				if($medData['frequency']=='16')$freq='0.0476';
				if($medData['frequency']=='25')$freq='16';
				if($medData['frequency']=='27')$freq='0.2857';
				if($medData['frequency']=='20')$freq='0.4856';
				if($medData['frequency']=='22')$freq='0.0333';
				
				if(empty($medData['day']))
					$medData['day']=30;
				if(empty($freq))
					$freq=1;
					
				
				if(!empty($getQuantityForDisp['1'])){
					$medData['quantity']=$getQuantityForDisp['1'];
				}else{
					$qty=$medData['dosageValue']*$freq*$medData['day'];
					$medData['quantity']=$qty;
				}
				
				$medData['date_of_prescription']=date("Y-m-d H:i:s");
				$medData['batch_identifier']= $uniqueName; /// For vadodara 
				$medData['drm_date']=date("Y-m-d");
				$medData['note_id'] = $id;
				$medData['editor_med_chk'] = "1";
				$medData['for_normal_med'] = '0';
				$medData['drug_id']=$newdrugId;
				$medData['created_by'] = $this->Session->read('userid');
				//eof
				
				//check if drug already present for this patient
			
				}
					//save in newcropprescription											
					$this->NewCropPrescription->saveAll($medData);
					$this->NewCropPrescription->id="";		
		
				}
			//	exit;
				/*if(!empty($getNewCropPrescriptionAllData)){					
				$this->NewCropPrescription->deleteAll(array('drug_id'=>$getNewCropPrescriptionAllData,'NewCropPrescription.note_id'=>$id,
						'NewCropPrescription.created_by'=>$this->Session->read('userid'),
						'NewCropPrescription.is_deleted'=>0,'NewCropPrescription.editor_med_chk'=>'1'));
				}*/
			
				///Delete For Unseted NewCropPrescription Array
			
				if(!empty($patientId)){
						$updatePatientArray['Patient']['id']=$patientId;
						$updatePatientArray['Patient']['from_soap_note']='1';
						$this->Patient->save($updatePatientArray['Patient']);
				}
						
				$this->request->data['NoteDiagnosis']['template_full_text']=str_replace("<p>&nbsp;</p>", "", $this->request->data['NoteDiagnosis']['template_full_text']);
				$this->request->data['NoteDiagnosis']['template_full_text']=str_replace("<p>&amp;NBSP;</p>", "", $this->request->data['NoteDiagnosis']['template_full_text']);
				//debug($this->request->data['template_full_text']);
				$this->request->data['NoteDiagnosis']['template_full_text'] =str_replace('&quot;','"',$this->request->data['NoteDiagnosis']['template_full_text']);
				$this->request->data['NoteDiagnosis']['template_full_text']=str_replace("&amp;","&",$this->request->data['NoteDiagnosis']['template_full_text']);
				$this->request->data['NoteDiagnosis']['template_full_text'] =str_replace("&#39;","'",$this->request->data['NoteDiagnosis']['template_full_text']);
			//	debug($this->request->data['template_full_text']);
			//	exit;
				$arryData['Note']['template_full_text']=$this->request->data['NoteDiagnosis']['template_full_text'];
				$arryData['Note']['id']=$this->request->data['NoteDiagnosis']['note_id'];
				$arryData['Note']['created_by']=$this->Session->read('userid');
				if(!empty($this->request->data['pharseName'])){			
					$arryData['pharse_name']=trim($this->request->data['pharseName']);
				}
				if($this->Note->save($arryData)){
					//$this->redirect("/notes/clinicalNote/".$patientId."/".$appointmentId."/".$id);
				}else{
					echo "not save";
				}		
	exit;
	}
	public function ajax_clinical_menu($patientId,$noteId,$appointmentId){
		$this->layout='ajax';
		$this->uses=array('Patient','Note');
		$personId=$this->Patient->find('first',array('conditions'=>array('id'=>$patientId),array('fields'=>array('person_id'))));
			
		$this->Patient->unbindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patientAllId=$this->Patient->find('list',array('conditions'=>array('person_id'=>$personId['Patient']['person_id'])
				,'fields'=>array('id','id')));
			
		$this->Note->bindModel(array(
				'belongsTo' => array(
						'Patient'=>array('foreignKey'=>false,'conditions'=>array('Note.patient_id= Patient.id')),
						'Appointment'=>array('foreignKey'=>false,'conditions'=>array('Appointment.patient_id= Patient.id')),
				)));
			
			
		$prevNotes=$this->Note->find('all',array('conditions'=>array('Note.patient_id'=>$patientAllId,
				'Note.created_by'=>$this->Session->read('userid')),
				'fields'=>array('Note.patient_id','Appointment.id','Note.id','Note.create_time')
				,'group'=>array('Note.id'),'order'=>array('Note.id DESC')));

		$this->set(compact('patientId','noteId','appointmentId','prevNotes','personId'));
			
		echo $this->render('ajax_clinical_menu');
		exit;
			
	}
	public function ajax_procedure_perform($patientId,$noteId,$appointmentId){
		$this->layout='ajax';
		$this->set(compact('patientId','noteId','appointmentId'));
		echo $this->render('ajax_procedure_performs');
		exit;

	}
	public function ajax_diagnosis($patientId,$noteId,$appointmentId){	
		$this->layout='ajax';
		$this->uses=array('NoteDiagnosis','Note');	
	//	if($this->request->is('post')){				
		$getDataFormNote=$this->Note->find('first',array('fields'=>array('small_text'),
				'conditions'=>array('id'=>$noteId)));
		$this->set('getDataFormNote',$getDataFormNote);
			if(!empty($this->request->data['NoteDiagnosis']['testCode'])){
				$getNoteDiagnosis=$this->NoteDiagnosis->find('first',array('fields'=>array('diagnoses_name'),'conditions'=>array('patient_id'=>$patientId,'diagnosis_id'=>$this->request->data['NoteDiagnosis']['testCode'],'is_deleted'=>0,'note_id'=>$noteId,'code_system'=>'1')));
					if(empty($getNoteDiagnosis['NoteDiagnosis']['diagnoses_name'])){					
				$this->request->data['NoteDiagnosis']['diagnosis_id']=$this->request->data['NoteDiagnosis']['testCode'];	
			//	$this->request->data['NoteDiagnosis']['patient_id']=$patientId;
				$this->request->data['NoteDiagnosis']['created_by']=$this->Session->read('userid');
				$this->NoteDiagnosis->save($this->request->data['NoteDiagnosis']);
				}
			}
	//}
		
			$this->set(compact('patientId','noteId','appointmentId'));
		    echo $this->render('ajax_diagnosis');exit;
	}
	public function ajax_active_problem($patientId,$noteId,$appointmentId,$diaId){
		$this->layout='ajax';
		$this->uses=array('NoteDiagnosis','Note');
			//	$this->request->data['NoteDiagnosis']['diagnoses_name']=$this->request->data['NoteDiagnosis']['diagnoses_name1'];
		$getDataFormNote=$this->Note->find('first',array('fields'=>array('template_full_text'),
				'conditions'=>array('id'=>$noteId,'Note.created_by'=>trim($this->Session->read('userid')))));
		$this->set('template_full_text',$getDataFormNote['Note']['template_full_text']);
			if(!empty($this->request->data['NoteDiagnosis']['testCode'])){
				$getNoteDiagnosis=$this->NoteDiagnosis->find('first',
					array('fields'=>array('diagnoses_name'),
						'conditions'=>array('patient_id'=>$patientId,
							'diagnosis_id'=>$this->request->data['NoteDiagnosis']['testCode'],
							'is_deleted'=>0,'note_id'=>$noteId,'code_system'=>null,'created_by'=>trim($this->Session->read('userid')))));
				if(empty($getNoteDiagnosis['NoteDiagnosis']['diagnoses_name'])){
				$this->request->data['NoteDiagnosis']['diagnosis_id']=$this->request->data['NoteDiagnosis']['testCode'];
				$this->request->data['NoteDiagnosis']['created_by']=$this->Session->read('userid');
				$this->NoteDiagnosis->save($this->request->data['NoteDiagnosis']);
				}
			}
				$this->set(compact('patientId','noteId','appointmentId'));			
		
		echo $this->render('ajax_active_problem');exit;
	}
	public function ajax_allallergies($patientId,$noteId,$appointmentId,$allergyId){
		$this->uses = array('Language','NewCropAllergies','Patient','Note','icds','DrugAllergy','Diagnosis','AllergyMaster');
		$this->layout=false;
	
		if($this->request->data){
			//if(!empty($this->request->data['NewCropAllergies']['CompositeAllergyID'])){
			//	$getNoteDiagnosis=$this->NewCropAllergies->find('first',array('fields'=>array('diagnoses_name'),'conditions'=>array('patient_id'=>$patientId,'diagnosis_id'=>$this->request->data['NoteDiagnosis']['testCode'],'is_deleted'=>0,'note_id'=>$noteId,'code_system'=>null)));
			//	if(empty($getNoteDiagnosis['NewCropAllergies']['diagnoses_name'])){
				$this->request->data['NewCropAllergies']['patient_uniqueid']=$patientId;
				$this->request->data['NewCropAllergies']['id']=$allergyId;	
				$this->request->data['NewCropAllergies']['created_by']=$this->Session->read('userid');
				$this->NewCropAllergies->save($this->request->data['NewCropAllergies']);
			//	}
			//}
		}
		else{
			if(!empty($allergyId)){
			$putAllergyData=$this->NewCropAllergies->find('first',array(
					'conditions'=>array('patient_uniqueid'=>$patientId,
							'id'=>$allergyId,
							'created_by'=>$this->Session->read('userid'))));
			}
			$this->set(compact('patientId','noteId','appointmentId','putAllergyData'));
			
		}
		$getAllergyData=$this->getSmartAllergy($patientId);
	    $this->set('getAllergyData',$getAllergyData);
		echo $this->render('ajax_allallergies');exit;
	}
	public function ajax_certificates($patientId,$noteId,$appointmentId){
		$this->layout='ajax';
		$this->set(compact('patientId','noteId','appointmentId'));
			
	}
	public function investigation_print($patientId,$noteId,$appointmentId){
		$this->layout = 'print_without_header' ;
		$this->uses = array('Patient','Diagnosis','Note','User','Person');
		$getBasicData=$this->Patient->find('first',array('fields'=>array('person_id','lookup_name','age','sex','patient_weight'),'conditions'=>array('Patient.id'=>$patientId)));
		$this->set('getBasicData',$getBasicData);
		$getPersonBasicData=$this->Person->find('first',array('fields'=>array('dob'),'conditions'=>array('Person.id'=>$getBasicData['Patient']['person_id'])));
		$this->set('getPersonBasicData',$getPersonBasicData);
		$getcomplaintsData=$this->Diagnosis->find('first',array('fields'=>array('complaints'),
				'conditions'=>array('Diagnosis.appointment_id'=>$appointmentId)));
		$this->set('getcomplaintsData',$getcomplaintsData);
		$getNoteData=$this->Note->find('first',array('fields'=>array('small_text','template_full_text'),
				'conditions'=>array('Note.id'=>$noteId,'Note.created_by'=>$this->Session->read('userid'))));
		$this->set('getNoteData',$getNoteData);

			
			
	}
	
	public function investigation_print_header($patientId,$noteId,$appointmentId){
		$this->layout = 'print_without_header' ;
		$this->uses = array('Patient','Diagnosis','Note','User','Person');
		$getBasicData=$this->Patient->find('first',array('fields'=>array('person_id','lookup_name','age','sex','patient_weight'),'conditions'=>array('Patient.id'=>$patientId)));
		$this->set('getBasicData',$getBasicData);
		$getPersonBasicData=$this->Person->find('first',array('fields'=>array('dob'),'conditions'=>array('Person.id'=>$getBasicData['Patient']['person_id'])));
		$this->set('getPersonBasicData',$getPersonBasicData);
		$getcomplaintsData=$this->Diagnosis->find('first',array('fields'=>array('complaints'),
				'conditions'=>array('Diagnosis.appointment_id'=>$appointmentId)));
		$this->set('getcomplaintsData',$getcomplaintsData);
		$getNoteData=$this->Note->find('first',array('fields'=>array('small_text','template_full_text'),
				'conditions'=>array('Note.id'=>$noteId,'Note.created_by'=>$this->Session->read('userid'))));
		$this->set('getNoteData',$getNoteData);
	
			
			
	}
	
	public function investigation_print_editor($patientId,$noteId,$appointmentId){
		$this->layout = 'print_smart' ;
		$this->uses = array('Patient','Diagnosis','Note','User');
		$getNoteData=$this->Note->find('first',array('fields'=>array('small_text','template_full_text'),
				'conditions'=>array('Note.id'=>$noteId,'Note.created_by'=>$this->Session->read('userid'))));
		$templateSmallTextArray= preg_split("/\r\n|\n|\r/", $getNoteData['Note']['template_full_text']);
		$templateSmallTextArray=array_filter($templateSmallTextArray);
		$templateSmallTextArray=array_values($templateSmallTextArray);
		/********BOF-Rx BLOCK*******************************/
		$dataRxArr=array();
		$flagRx=false;
		foreach($templateSmallTextArray as $keyRx=>$dataRx){
			if($dataRx=='<p><b>Rx</b></p>' || $flagRx || $dataRx=='<p>Rx</p>' || $dataRx=='<p><strong>Rx</strong></p>'){
				$flagRx=true;
				$dataRxArr[$keyRx]=$dataRx;
				unset($templateSmallTextArray[$keyRx]);
			}
		
		}
		$dataUnPhyArr=array();
		$flagUnPhy=false;
		foreach ($dataRxArr as $keyUnPhy=>$dataUnPhy){
			if($dataUnPhy=='<p><b>PHYSIOTHERAPY :</b></p>' || $flagUnPhy || $dataUnPhy=='<p>PHYSIOTHERAPY :</p>' || $dataUnPhy=='<p><strong>PHYSIOTHERAPY :</strong></p>'){
				$flagUnPhy=true;
				$dataUnPhyArr[$keyUnPhy]=$dataUnPhy;
				unset($dataRxArr[$keyUnPhy]);
			}
		}
	
		$dataRxArr=array_values($dataRxArr);		
		foreach ($dataRxArr as $keyMed=>$dataMed){
		$getMedNameArr[$keyMed]=explode("::",$dataMed);		
		$getMedNameFinalArr[$keyMed]=explode("---",$getMedNameArr[$keyMed]['1']);			
		$getDaysArrNew[$keyMed]=explode("/",$getMedNameFinalArr[$keyMed]['1']);	
		$getDaysArr[$keyMed]=explode("#",$getDaysArrNew[$keyMed]['1']);
		}		
		$getMedNameFinalArr=array_filter($getMedNameFinalArr);	
		/********EOF-Rx BLOCK*******************************/
		/********BOF-Physiotherpy BLOCK*******************************/
		$physioArr= preg_split("/\r\n|\n|\r/", $getNoteData['Note']['template_full_text']);
		$dataPhysioArr=array();
		$flagPhy=false;
		foreach($physioArr as $keyPhy=>$dataPhy){
			if($dataPhy=='<p><b>PHYSIOTHERAPY :</b></p>' || $flagPhy || $dataPhy=='<p>PHYSIOTHERAPY :</p>' || $dataPhy=='<p><strong>PHYSIOTHERAPY :</strong></p>'){
				$flagPhy=true;
				$dataPhysioArr[$keyPhy]=$dataPhy;
				unset($dataRxArr[$keyPhy]);
			}
		
		}	
		$dataPhysioArr=array_filter($dataPhysioArr);
		$dataPhysioArr=array_values($dataPhysioArr);
		
		/********EOF-Physiotherpy BLOCK*******************************/
		$getSign=$this->User->find('first',array('fields'=>array('sign'),'conditions'=>array('User.id'=>$_SESSION['Auth']['User']['id'])));
	$this->set(array('getMedNameFinalArr'=>$getMedNameFinalArr,'getDaysArr'=>$getDaysArr,'templateSmallTextArray'=>$templateSmallTextArray,'getNoteData'=>$getNoteData,'dataPhysioArr'=>$dataPhysioArr,'getSign'=>$getSign));  ///Medication Name
	}
	
	public function investigation_print_editor_header($patientId,$noteId,$appointmentId){
	//	$this->layout = 'print_smart' ;
		$this->investigation_print_editor($patientId,$noteId,$appointmentId);
	/*	$this->uses = array('Patient','Diagnosis','Note','User');
		$getNoteData=$this->Note->find('first',array('fields'=>array('small_text','template_full_text'),
				'conditions'=>array('Note.id'=>$noteId)));
		$this->set('getNoteData',$getNoteData);
		$getSign=$this->User->find('first',array('fields'=>array('sign'),'conditions'=>array('User.id'=>$_SESSION['Auth']['User']['id'])));
		$this->set('getSign',$getSign);*/
	
	
	}
	/*****BOF-Mahalaxmi***********/
	public function updateSmallText($noteId,$appointmentId){
		$this->layout=false;
		$this->autoRender=false;
		$this->uses = array('Note','LaboratoryTestOrder','Laboratory','RadiologyTestOrder','Radiology','Diagnosis','TariffAmount','Patient','TariffStandard');
	
		$saveLabRadArray= preg_split("/\r\n|\n|\r/", $this->request->data['toSave']);   ////Main text make Array
		
		$role = $this->Session->read('role');
		//********BOF-Its used For handling Special charactors error*////////
		foreach($saveLabRadArray as $key=>$dataLabRad){
			$getFinalRabLAbDataArray[$key]=str_replace("@@", "&", $dataLabRad);
			$getFinalRabLAbDataArray[$key]=str_replace("plusop","+", $getFinalRabLAbDataArray[$key]);
			$getFinalRabLAbDataArray[$key]=str_replace("minussi","-", $getFinalRabLAbDataArray[$key]);
			$getFinalRabLAbDataArray[$key]=str_replace("greatsym",">", $getFinalRabLAbDataArray[$key]);
			$getFinalRabLAbDataArray[$key]=str_replace("lessmar","<", $getFinalRabLAbDataArray[$key]);
		}
		//********EOF-Its used For handling Special charactors error*////////
		
		$getFinalRabLAbDataArray=array_filter($getFinalRabLAbDataArray);
		
		///////BOF-Its Only Save the Valid NAme of RAd LAb that why Implode Array
		$getFinalRabLAbDataArray= implode("\n", $getFinalRabLAbDataArray);				
		$saveArrtNote['Note']['small_text']=$getFinalRabLAbDataArray;
		$saveArrtNote['Note']['id']=$noteId;
		$this->Note->save($saveArrtNote);
		///////BOF-Its Only Save the Valid NAme of RAd LAb that why Implode Array
		
		$templateSmallTextArray= preg_split("/\r\n|\n|\r/", $getFinalRabLAbDataArray);		///$getFinalRabLAbDataArray-Its used Valid Name
		
	//	$templateSmallTextArray = explode("\n", $getFinalRabLAbData);		
	
	//	$templateSmallTextArray=array_map('trim',explode("\n",$this->request->data['toSave']));
		
		$templateSmallTextArray=array_filter($templateSmallTextArray);
		if(empty($this->request->data['toSave'])){			
			$this->LaboratoryTestOrder->deleteAll(array('LaboratoryTestOrder.note_id'=>$noteId,'LaboratoryTestOrder.is_deleted'=>0,'LaboratoryTestOrder.editor_lab_chk'=>'1'));
			$this->RadiologyTestOrder->deleteAll(array('RadiologyTestOrder.note_id'=>$noteId,'RadiologyTestOrder.is_deleted'=>0,'RadiologyTestOrder.editor_rad_chk'=>'1'));
		}
		$getNoteData=$this->Note->find('first',array('fields'=>array('patient_id'),
				'conditions'=>array('Note.id'=>$noteId/*,'Note.created_by'=>$this->Session->read('userid')*/)));
		
		$patientData=$this->Patient->find('first',array('fields'=>array('id','doctor_id'),
				'controller'=>array('Patient.id'=>$getNoteData['Note']['patient_id'])));
		
		$tariffStandardId=$this->TariffStandard->getTariffIDByPatientId($getNoteData['Note']['patient_id']);
		$this->set('tariffStandardId',$tariffStandardId);
		/******BOF-Cheif Complaints Array**************/
		$templateSmallTextCheifCompArray=$templateSmallTextArray;
		$flagCheif=false;
		$dataCheifComplaintsArr=array();
		foreach($templateSmallTextCheifCompArray as $keyComm=>$templateSmallTextNewCheifComp){
			if(strtolower($templateSmallTextNewCheifComp)=="laboratory :" || $flagCheif){
				$flagCheif=true;
				$dataCheifComplaintsArr[$keyComm]=$templateSmallTextNewCheifComp;   /////Except-Cheaf complaint Array
				unset($templateSmallTextCheifCompArray[$keyComm]);
			}
		}
			
		/******EOF-Cheif Complaints Array**************/
		/******BOF-Lab Array**************/
		$templateSmallTextArrayLabData=$dataCheifComplaintsArr;
		$flag=false;
		$dataLaboratoryArr=array();
		foreach($templateSmallTextArrayLabData as $keyLabNew=>$templateSmallTextArrayNotInNew){
			if(strtolower($templateSmallTextArrayNotInNew)=="radiology :" || $flag || $templateSmallTextArrayNotInNew=="RADIOLOGY :"){
				$flag=true;
				$dataLaboratoryArr[$keyLabNew]=$templateSmallTextArrayNotInNew;  /////Except-LAb Array
				unset($templateSmallTextArrayLabData[$keyLabNew]);
			}
		}
		/**
		 * Lab Array Only-$templateSmallTextArrayLabData
		 */
		
		foreach($templateSmallTextArrayLabData as $keyLabNow=>$templateSmallTextArrayLabDataName){			
			if(strtolower($templateSmallTextArrayLabDataName) == "laboratory :"){
				continue;
			}
			$getLaboratoryDatacount=$this->Laboratory->find('count',array('conditions'=>array('Laboratory.name'=>trim($templateSmallTextArrayLabDataName),'Laboratory.is_deleted'=>0)));
			if(!$getLaboratoryDatacount){
				$savelabArray['name']=$templateSmallTextArrayLabDataName;
				$savelabArray['created_by']=$this->Session->read('userid');
				$savelabArray['create_time']=date("Y-m-d H:i:s");					
				$this->Laboratory->id='';
				$this->Laboratory->save($savelabArray);
			}		
		}
	
		/******EOF-Lab Array**************/		
		
		
		/**
		 * Rad Array Only
		 */
	
		foreach($dataLaboratoryArr as $keyLabNow=>$dataRadiologyName){				
			if(strtolower($dataRadiologyName) == "radiology :"){
				continue;
			}
			$getRadiologyDatacount=$this->Radiology->find('count',array('conditions'=>array('Radiology.name'=>trim($dataRadiologyName),'Radiology.is_deleted'=>0,'Radiology.location_id' => $this->Session->read('locationid'))));
			if(!$getRadiologyDatacount){
				$saveRadArray['name']=$dataRadiologyName;
				$saveRadArray['created_by']=$this->Session->read('userid');
				$saveRadArray['created']=date("Y-m-d H:i:s");
				$saveRadArray['location_id']=$this->Session->read('locationid');
				$this->Radiology->id='';
				$this->Radiology->save($saveRadArray);
			}
		}
		/******EOF-Rad Array**************/
		/**************BOF-Cheif Complaints**********************/
		if($templateSmallTextArray['0']=="Chief Complaints :" || $templateSmallTextArray['0']=="chief complaints :"){
			$getDiagnosisData=$this->Diagnosis->find('first',array('fields'=>array('complaints','id'),'conditions'=>array('Diagnosis.patient_id'=>$getNoteData['Note']['patient_id'],'Diagnosis.note_id'=>$noteId,'Diagnosis.appointment_id'=>$appointmentId,'Diagnosis.is_deleted'=>0)));
			//if(!empty($noteId) && !empty($getNoteData['Note']['patient_id']))
			//$this->Diagnosis->deleteAll(array('Diagnosis.patient_id'=>$getNoteData['Note']['patient_id'],'Diagnosis.note_id'=>$noteId,false));
			$diaData['Diagnosis']['id']=$getDiagnosisData['Diagnosis']['id'];
			$diaData['Diagnosis']['complaints']=$templateSmallTextArray['1'];
			$diaData['Diagnosis']['note_id']=$noteId;
			$diaData['Diagnosis']['appointment_id']=$appointmentId;
			$diaData['Diagnosis']['patient_id']=$getNoteData['Note']['patient_id'];
			$diaData['Diagnosis']['location_id'] = $this->Session->read('locationid');
			if(empty($diaData['Diagnosis']['id'])){
				$diaData['Diagnosis']['created_by']=$this->Session->read('userid');
				$diaData['Diagnosis']['create_time']=date("Y-m-d H:i:s");
			}else{
				$diaData['Diagnosis']['modified_by']=$this->Session->read('userid');
				$diaData['Diagnosis']['modify_time']=date("Y-m-d H:i:s");
			}
			$this->Diagnosis->save($diaData['Diagnosis']);
		}
		/**************EOF-Cheif Complaints**********************/
		
		/******BOF-Radiology Test Order save****///
		
		$getRadiologyTestOrderAllData=$this->RadiologyTestOrder->find('list',array('fields'=>array('id','radiology_id'),'conditions'=>array('RadiologyTestOrder.is_deleted'=>0,'RadiologyTestOrder.note_id'=>$noteId,'RadiologyTestOrder.editor_rad_chk'=>'1')));
		foreach($dataLaboratoryArr as $keyRadSave=>$getRadiologyValues){
			//delete Radiology first if already present
			if(strtolower($getRadiologyValues) == 'radiology :'){
				continue;
			}
			$getRadiologyData=$this->Radiology->find('list',array('fields'=>array('id','name'),'conditions'=>array('Radiology.name'=>trim($getRadiologyValues),'Radiology.is_deleted'=>0,'Radiology.location_id' => $this->Session->read('locationid'))));
			
			$getRadiologyData = array_map('strtolower', $getRadiologyData);
			$radiologyTestOrderId = array_search(trim(strtolower($getRadiologyValues)),$getRadiologyData);
			if(in_array($radiologyTestOrderId,$getRadiologyTestOrderAllData)){
				$unsetRadId = array_search($radiologyTestOrderId, $getRadiologyTestOrderAllData);
				unset($getRadiologyTestOrderAllData[$unsetRadId]);
				continue;
			}else{
				$getRateRad=$this->Radiology->getRate($radiologyTestOrderId,$tariffStandardId);
				if(empty($getRateRad['TariffAmountType']['opd_charge'])){
					$putRate1="0.00";
				}else{
					$putRate1=$getRateRad['TariffAmountType']['opd_charge'];
				}
				//echo $putRate1." Rs";
				$radData['RadiologyTestOrder']['amount']=$putRate1;
				$radData['RadiologyTestOrder']['note_id']=$noteId;
				$radData['RadiologyTestOrder']['patient_id']=$getNoteData['Note']['patient_id'];
				$radData['RadiologyTestOrder']['radiology_id']=$radiologyTestOrderId;
				$radData['RadiologyTestOrder']['editor_rad_chk']='1';
				$radData['RadiologyTestOrder']['location_id'] = $this->Session->read('locationid');
				$radData['RadiologyTestOrder']['created_by']=$this->Session->read('userid');				
				if($role == Configure::read('doctorLabel') || $role==Configure::read('residentLabel')){
					//If the logged in users is doctor insert session user id else patient's doctor id -pooja
					$radData['RadiologyTestOrder']['doctor_id']=$this->Session->read('userid');
				}else{
					$radData['RadiologyTestOrder']['doctor_id']=$patientData['Patient']['doctor_id'];
				}
				$radData['RadiologyTestOrder']['create_time']=date("Y-m-d H:i:s");
				$radData['RadiologyTestOrder']['radiology_order_date']=date("Y-m-d H:i:s");
				$radData['RadiologyTestOrder']['order_id']= $this->RadiologyTestOrder->autoGeneratedRadID();
				$this->RadiologyTestOrder->saveAll($radData['RadiologyTestOrder']);
			}
		}
		$this->RadiologyTestOrder->deleteAll(array('radiology_id'=>$getRadiologyTestOrderAllData,'RadiologyTestOrder.note_id'=>$noteId,'RadiologyTestOrder.is_deleted'=>0,'RadiologyTestOrder.editor_rad_chk'=>'1')); ///Delete For Unseted Radiology Array
		
		/******EOF-Radiology Test Order save****///
		
		
		/******BOF-LAb Test Order save****///
		$getLaboratoryTestOrderAllData=$this->LaboratoryTestOrder->find('list',array('fields'=>array('id','laboratory_id'),'conditions'=>array('LaboratoryTestOrder.is_deleted'=>0,'LaboratoryTestOrder.note_id'=>$noteId,'LaboratoryTestOrder.editor_lab_chk'=>'1')));
		
		foreach($templateSmallTextArrayLabData as $key=>$value){
			if(strtolower($value) == 'laboratory :'){
				continue;
			}
			
			$getLaboratoryData=$this->Laboratory->find('list',array('fields'=>array('id','name'),'conditions'=>array('Laboratory.name'=>trim($value),'Laboratory.is_deleted'=>0)));
			
			$getLaboratoryData = array_map('strtolower', $getLaboratoryData);
			$laboratoryTestOrderId = array_search(trim(strtolower($value)),$getLaboratoryData);
			if(in_array($laboratoryTestOrderId,$getLaboratoryTestOrderAllData)){
				$unsetId = array_search($laboratoryTestOrderId, $getLaboratoryTestOrderAllData);
				unset($getLaboratoryTestOrderAllData[$unsetId]);
				continue;			
			}else{ 
			$getLaboratoryDatas['Laboratory']['id'] = $laboratoryTestOrderId;
			$rate=$this->Laboratory->getRate($getLaboratoryDatas['Laboratory']['id'],$tariffStandardId);
			$labData['LaboratoryTestOrder']['laboratory_id']=$getLaboratoryDatas['Laboratory']['id'];	
			if(empty($rate['TariffAmountType']['opd_charge'])){
				$charge="0.00";
			}else{
				$charge=$rate['TariffAmountType']['opd_charge'];
			}
			$labData['LaboratoryTestOrder']['amount']=$charge;
			$labData['LaboratoryTestOrder']['editor_lab_chk']='1';
			$labData['LaboratoryTestOrder']['note_id']=$noteId;
			$labData['LaboratoryTestOrder']['patient_id']=$getNoteData['Note']['patient_id'];
			$labData['LaboratoryTestOrder']['batch_identifier'] = time ();
			$labData['LaboratoryTestOrder']['location_id'] = $this->Session->read('locationid');
			$labData['LaboratoryTestOrder']['created_by']=$this->Session->read('userid');
			if($role == Configure::read('doctorLabel') || $role==Configure::read('residentLabel')){
				//If the logged in users is doctor insert session user id else patient's doctor id -pooja
				$labData['LaboratoryTestOrder']['doctor_id']=$this->Session->read('userid');
			}else{
				$labData['LaboratoryTestOrder']['doctor_id']=$patientData['Patient']['doctor_id'];
			}
			$labData['LaboratoryTestOrder']['create_time']=date("Y-m-d H:i:s");
			$labData['LaboratoryTestOrder']['start_date']=date('Y-m-d H:i:s');
			$labData['LaboratoryTestOrder']['order_id']=$this->LaboratoryTestOrder->autoGeneratedLabID ( null );				
		//	$labData['LaboratoryTestOrder']['id']=$getLaboratoryTestOrderData['LaboratoryTestOrder']['id'];
			$this->LaboratoryTestOrder->saveAll($labData['LaboratoryTestOrder']);		
			/*$log = $this->LaboratoryTestOrder->getDataSource()->getLog(false, false);
			debug($log);*/
			}
		}	
		$this->LaboratoryTestOrder->deleteAll(array('laboratory_id'=>$getLaboratoryTestOrderAllData,'LaboratoryTestOrder.note_id'=>$noteId,'LaboratoryTestOrder.is_deleted'=>0,'LaboratoryTestOrder.editor_lab_chk'=>'1'));
		///Delete For Unseted Laboratory Array
		/******EOF-LAb Test Order save****///
	
	}
	public function deleteProblem($id){
		$this->layout='ajax';
		$this->uses=array('NoteDiagnosis');
		if($this->NoteDiagnosis->updateAll(array('NoteDiagnosis.is_deleted'=>'1'),array('NoteDiagnosis.id'=>$id))){
			echo $id;
		}else{
			echo "Please try again.";
		}
		exit;
	}
	public function deleteLaboratoryTestOrder($id,$noteId){
		$this->layout='ajax';
		$this->uses=array('LaboratoryTestOrder','Laboratory');
		$getResult=$this->LaboratoryTestOrder->updateAll(array('LaboratoryTestOrder.is_deleted'=>'1'),array('LaboratoryTestOrder.id'=>$id));
			
		$getNoteData=$this->Note->find('first',array('fields'=>array('small_text'),
				'conditions'=>array('Note.id'=>$noteId,'Note.created_by'=>$this->Session->read('userid'))));
		
		$templateSmallTextArray= preg_split("/\r\n|\n|\r/", $getNoteData['Note']['small_text']);
		
	/******BOF-Cheif Complaints Array**************/
		$templateSmallTextCheifCompArray=$templateSmallTextArray;
		$flagCheif=false;
		$dataCheifComplaintsArr=array();
		foreach($templateSmallTextCheifCompArray as $keyComm=>$templateSmallTextNewCheifComp){		
			if(strtolower($templateSmallTextNewCheifComp)=="laboratory :" || $flagCheif){
				$flagCheif=true;
				$dataCheifComplaintsArr[$keyComm]=$templateSmallTextNewCheifComp;   /////Except-Cheaf complaint Array
				unset($templateSmallTextCheifCompArray[$keyComm]);
			}
		}
		
		/******EOF-Cheif Complaints Array**************/
		
		/******BOF-Lab Array**************/
		$templateSmallTextArrayLabData=$dataCheifComplaintsArr;
		$flag=false;
		$dataLaboratoryArr=array();
		foreach($templateSmallTextArrayLabData as $keyLabNew=>$templateSmallTextArrayNotInNew){
			if(strtolower($templateSmallTextArrayNotInNew)=="radiology :" || $flag || $templateSmallTextArrayNotInNew=="RADIOLOGY :"){
				$flag=true;
				$dataLaboratoryArr[$keyLabNew]=$templateSmallTextArrayNotInNew;  /////Except-LAb Array
				unset($templateSmallTextArrayLabData[$keyLabNew]);
			}
		}
		
		
		$this->LaboratoryTestOrder->bindModel ( array (
				'belongsTo' => array (
						'Laboratory' => array (
								'foreignKey' => 'laboratory_id',
								'conditions' => array (
										'Laboratory.is_active' => 1
								)
						)
				)
		) );
		
		
		$getLaboratoryTestData=$this->LaboratoryTestOrder->find('first',
				array('fields'=>array('Laboratory.id','LaboratoryTestOrder.laboratory_id','Laboratory.name'),
						'conditions'=>array('LaboratoryTestOrder.id'=>$id,'LaboratoryTestOrder.is_deleted'=>1)));
		
		$templateSmallTextArrayLabData = array_map('strtolower', $templateSmallTextArrayLabData);
		if(in_array(strtolower($getLaboratoryTestData['Laboratory']['name']),$templateSmallTextArrayLabData)){
			$searchArrKey = array_search(strtolower($getLaboratoryTestData['Laboratory']['name']), $templateSmallTextArrayLabData);	
			unset($templateSmallTextArray[$searchArrKey]);
			$countLab=count($templateSmallTextArrayLabData);
		
			$searchArrKeyLablbl = array_search(strtolower('Laboratory :'), $templateSmallTextArrayLabData);
			
			if($countLab=='2'){
				unset($templateSmallTextArray[$searchArrKeyLablbl]);
			}
		}
		
		///////BOF-Its Only Save the Valid NAme of RAd LAb that why Implode Array
		$getFinalRabLAbDataArray= implode("\n", $templateSmallTextArray);
		$saveArrtNote['Note']['small_text']=$getFinalRabLAbDataArray;
		$saveArrtNote['Note']['id']=$noteId;
		$this->Note->save($saveArrtNote);
		///////BOF-Its Only Save the Valid NAme of RAd LAb that why Implode Array
		if($getResult){
			echo $id."_".$getFinalRabLAbDataArray;
		}else{
			echo "Please try again.";
		}
		exit;
	}
	public function deleteRadiologyTestOrder($id,$noteId){
		$this->layout='ajax';
		$this->uses=array('RadiologyTestOrder');
		$getResultData=$this->RadiologyTestOrder->updateAll(array('RadiologyTestOrder.is_deleted'=>'1'),array('RadiologyTestOrder.id'=>$id));
		$getNoteData=$this->Note->find('first',array('fields'=>array('small_text'),
				'conditions'=>array('Note.id'=>$noteId,'Note.created_by'=>$this->Session->read('userid'))));
		
		$templateSmallTextArray= preg_split("/\r\n|\n|\r/", $getNoteData['Note']['small_text']);
		
		/******BOF-Cheif Complaints Array**************/
		$templateSmallTextCheifCompArray=$templateSmallTextArray;
		$flagCheif=false;
		$dataCheifComplaintsArr=array();
		foreach($templateSmallTextCheifCompArray as $keyComm=>$templateSmallTextNewCheifComp){
			if(strtolower($templateSmallTextNewCheifComp)=="laboratory :" || $flagCheif){
				$flagCheif=true;
				$dataCheifComplaintsArr[$keyComm]=$templateSmallTextNewCheifComp;   /////Except-Cheaf complaint Array
				unset($templateSmallTextCheifCompArray[$keyComm]);
			}
		}
		
		/******EOF-Cheif Complaints Array**************/
		
		/******BOF-Lab Array**************/
		$templateSmallTextArrayLabData=$dataCheifComplaintsArr;
		$flag=false;
		$dataLaboratoryArr=array();
		foreach($templateSmallTextArrayLabData as $keyLabNew=>$templateSmallTextArrayNotInNew){
			if(strtolower($templateSmallTextArrayNotInNew)=="radiology :" || $flag || $templateSmallTextArrayNotInNew=="RADIOLOGY :"){
				$flag=true;
				$dataLaboratoryArr[$keyLabNew]=$templateSmallTextArrayNotInNew;  /////Except-LAb Array
				unset($templateSmallTextArrayLabData[$keyLabNew]);
			}
		}
		
		
		$this->RadiologyTestOrder->bindModel ( array (
				'belongsTo' => array (
						'Radiology' => array (
								'foreignKey' => 'radiology_id',
								'conditions' => array (
										'Radiology.is_active' => 1
								)
						)
				)
		) );
		
		
		$getRadiologyTestData=$this->RadiologyTestOrder->find('first',array('fields'=>array('Radiology.id','RadiologyTestOrder.radiology_id','Radiology.name'),'conditions'=>array('RadiologyTestOrder.id'=>$id,'RadiologyTestOrder.is_deleted'=>1,'RadiologyTestOrder.location_id'=>$this->Session->read('locationid'))));
		
		$dataLaboratoryArr = array_map('strtolower', $dataLaboratoryArr);
		if(in_array(strtolower($getRadiologyTestData['Radiology']['name']),$dataLaboratoryArr)){
			$searchArrKey = array_search(strtolower($getRadiologyTestData['Radiology']['name']), $dataLaboratoryArr);
			unset($templateSmallTextArray[$searchArrKey]);
			$countLab=count($dataLaboratoryArr);
			$searchArrKeyLablbl = array_search(strtolower('Radiology :'), $dataLaboratoryArr);
			//debug($searchArrKeyLablbl);
			if($countLab=='2'){
				unset($templateSmallTextArray[$searchArrKeyLablbl]);
			}
		}
		
		///////BOF-Its Only Save the Valid NAme of RAd LAb that why Implode Array
		$getFinalRabLAbDataArray= implode("\n", $templateSmallTextArray);
		$saveArrtNote['Note']['small_text']=$getFinalRabLAbDataArray;
		$saveArrtNote['Note']['id']=$noteId;
		$this->Note->save($saveArrtNote);
		///////BOF-Its Only Save the Valid NAme of RAd LAb that why Implode Array
		
		if($getResultData){
			echo $id."_".$getFinalRabLAbDataArray;
		}else{
			echo "Please try again.";
		}
		exit;
	}

	public function flipBook($patientId=6220){
		$this->layout='advance';
		$this->uses = array('Person','Patient');
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Person' =>array( 'foreignKey'=>false,array('Patient.person_id=Person.id')),
						'City' =>array( 'foreignKey'=>false,array('City.id_id=Person.city_id')),
						'State' =>array( 'foreignKey'=>false,array('State.id=Person.state_id')),
						'Country' =>array( 'foreignKey'=>false,array('Country.id=Person.country_id')),
						'TariffStandard' =>array( 'foreignKey'=>false,array('Patient.tariff_standard_id=TariffStandard.id'))
				)));
		$getBasicData=$this->Patient->find('first',array(
				'fields'=>array('Person.patient_uid','Person.id','Patient.lookup_name','Patient.age','Person.sex','TariffStandard.name','Person.plot_no','Person.landmark','City.name','State.name','Country.name','Person.pin_code'),
				'conditions'=>array('Patient.id'=>$patientId)));
		//pr($getBasicData);exit;
			
		//get previous visit details
			
		$this->Appointment->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array( 'foreignKey'=>false,array('Appointment.appointment_id=Patient.id')),
						'User' =>array( 'foreignKey'=>false,array('Patient.doctor_id=User.id')),
							
				)));
			
			
		//$this->$this->Patient->find('all',array('Patient.form_received_on'));
			
			
			
			
			
			
			
		$this->set('getBasicData',$getBasicData);
	}
	public function getSmartLab($patientId,$noteId){
		/** Lab data **/
		$this->uses = array('LaboratoryTestOrder');
		$this->LaboratoryTestOrder->bindModel(array(
				'belongsTo' => array(
						'Laboratory'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryTestOrder.laboratory_id= Laboratory.id')),
						'LaboratoryResult'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.laboratory_test_order_id= LaboratoryTestOrder.id')),
						'LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryHl7Result.laboratory_result_id= LaboratoryResult.id')),
				)));
		$getLabData=$this->LaboratoryTestOrder->find('all',array('fields'=>array('LaboratoryTestOrder.id','Laboratory.name','Laboratory.id','LaboratoryResult.is_authenticate','LaboratoryTestOrder.amount',
				'LaboratoryTestOrder.patient_id','LaboratoryTestOrder.batch_identifier','LaboratoryTestOrder.paid_amount','LaboratoryResult.id','LaboratoryHl7Result.unit','LaboratoryHl7Result.result'),
				'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patientId,'LaboratoryTestOrder.created_by'=>trim($this->Session->read('userid')),'LaboratoryTestOrder.is_deleted'=>0) ,'group'=>array('LaboratoryTestOrder.id') ));
		
		return $getLabData;
	}
	public function getSmartRad($patientId,$noteId){
		$this->uses = array('RadiologyTestOrder');
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey'=>false,'conditions'=>array('RadiologyTestOrder.radiology_id= Radiology.id')),
						'RadiologyResult'=>array('foreignKey'=>false,'conditions'=>array('RadiologyTestOrder.id= RadiologyResult.radiology_test_order_id')),
				)));
		$getRadData=$this->RadiologyTestOrder->find('all',array('fields'=>array('Radiology.name','Radiology.id','RadiologyTestOrder.amount',
				'RadiologyTestOrder.id','RadiologyTestOrder.patient_id','RadiologyTestOrder.paid_amount','RadiologyTestOrder.id','RadiologyTestOrder.is_processed','RadiologyResult.id'),
				'conditions'=>array('RadiologyTestOrder.patient_id'=>$patientId,'RadiologyTestOrder.created_by'=>trim($this->Session->read('userid')),'RadiologyTestOrder.is_processed'=>0,'RadiologyTestOrder.is_deleted'=>0) ,'group'=>array('RadiologyTestOrder.id')));
		return $getRadData;
	}
	public function getSmartMed($patientId){
		$this->uses = array('NewCropPrescription');
		$getMedData=$this->NewCropPrescription->find('all',array('fields'=>array('NewCropPrescription.description','NewCropPrescription.patient_uniqueid','NewCropPrescription.id'),
				'conditions'=>array('NewCropPrescription.patient_uniqueid'=>$patientId,'NewCropPrescription.created_by'=>trim($this->Session->read('userid')),'NewCropPrescription.is_discharge_medication'=>'0','NewCropPrescription.is_deleted'=>0)));
		return $getMedData;
	}
	public function getSmartAllergy($patientId){
		$this->uses = array('NewCropAllergies');
		$getAllergyData=$this->NewCropAllergies->find('all',array('conditions'=>array('NewCropAllergies.patient_uniqueid'=>$patientId,'NewCropAllergies.created_by'=>trim($this->Session->read('userid')),'NewCropAllergies.is_deleted'=>0)));
		return $getAllergyData;
	}
	
	public function getSmartDia($noteId){
		$this->uses = array('NoteDiagnosis');
		$getNoteDiagnosisData=$this->NoteDiagnosis->find('all',array('fields'=>array('NoteDiagnosis.id','NoteDiagnosis.diagnoses_name','NoteDiagnosis.code_system'),
				'conditions'=>array('NoteDiagnosis.note_id'=>$noteId,'NoteDiagnosis.created_by'=>trim($this->Session->read('userid')),'NoteDiagnosis.is_deleted'=>'0')));
		return $getNoteDiagnosisData;
	}
	public function getSmartMRI($patientId){
		$this->uses = array('RadiologyTestOrder');
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey'=>false,'conditions'=>array('RadiologyTestOrder.radiology_id= Radiology.id')),
						//'RadiologyResult'=>array('foreignKey'=>false,'conditions'=>array('RadiologyTestOrder.id= RadiologyResult.radiology_test_order_id')),
				)));
		$getMriData=$this->RadiologyTestOrder->find('all',array('fields'=>array('Radiology.name','Radiology.id',
				'RadiologyTestOrder.id','RadiologyTestOrder.patient_id','RadiologyTestOrder.is_processed'),
				'conditions'=>array('RadiologyTestOrder.patient_id'=>$patientId,'RadiologyTestOrder.created_by'=>trim($this->Session->read('userid')),
						'RadiologyTestOrder.is_processed'=>1)/* ,'group'=>array('Radiology.name')*/));
		return $getMriData;
	}

	public function getTemplateDataOnly($noteId){
		$this->layout='ajax';
		//$this->autoRender=false;
		$this->uses = array('Note');
		/*	$prevNotesDtaa=$this->Note->find('first',array('conditions'=>array('Note.id'=>$noteId),
		 'fields'=>array('Note.small_text','Note.template_full_text')
				,'group'=>array('Note.id'),'order'=>array('Note.id DESC')));
		echo $prevNotesDtaa['Note']['template_full_text'].'!!!~~~!!!'.$prevNotesDtaa['Note']['small_text'];
		exit;*/
			
		$this->Note->bindModel(array(
				'belongsTo' => array(
						'Diagnosis'=>array('foreignKey'=>false,'conditions'=>array('Diagnosis.note_id= Note.id')),
						'BmiResult'=>array('foreignKey'=>false,'conditions'=>array('BmiResult.patient_id= Note.patient_id')),
						'BmiBpResult'=>array('foreignKey'=>false,'conditions'=>array('BmiBpResult.bmi_result_id= BmiResult.id')),
				)));
		$getHold=$this->Note->find('first',array('fields'=>array('BmiResult.temperature','BmiResult.respiration',
				'BmiBpResult.systolic','BmiBpResult.diastolic','BmiBpResult.pulse_text','Note.subject','Note.object','Note.assis',
				'Note.plan','Note.ros','Diagnosis.complaints','Note.small_text','Note.template_full_text'),
				'conditions'=>array('Note.id'=>$noteId,'Note.created_by'=>trim($this->Session->read('userid')))));

		//	$this->set('getHold',$getHold);
		echo json_encode($getHold);
		exit;
			
	}

	public function getsmartPharseDia($id){
		$this->autoRender=false;
		$this->uses = array('SnomedMappingMaster','SmartPhrase');
		/*$getDiaParse=$this->SnomedMappingMaster->find('first',array('fields'=>array('is_smart'),'conditions'=>array('id'=>$id,'is_deleted'=>0)));
		if(!empty($getDiaParse['SnomedMappingMaster']['is_smart'])){
			$exStr=explode('|',$getDiaParse['SnomedMappingMaster']['is_smart']);
			$putStr="";
			foreach($exStr as $data){
				if($data!=" "){
					if(count($exStr)>=1){
						echo json_encode($exStr);exit;
					}
				}
			}
			//echo rtrim($putStr,"| ");exit;
		}else{
			echo " ";exit;
		}*/
		$getDiaParse=$this->SnomedMappingMaster->find('first',array('fields'=>array('is_smart'),'conditions'=>array('id'=>$id,'is_deleted'=>0)));
		
		if(!empty($getDiaParse['SnomedMappingMaster']['is_smart'])){
			//$exStr=explode('|',$getDiaParse['SnomedMappingMaster']['is_smart']);
			$exStr = array_map('trim', explode('|',$getDiaParse['SnomedMappingMaster']['is_smart']));
			$exStr = array_map('strtolower', $exStr);	
			$exStr=array_filter($exStr);			
			$exStr=array_unique($exStr);
			$exStr=array_values($exStr);			
			foreach($exStr as $key=>$getData){
				$getData=trim($getData);
				$smartData=$this->SmartPhrase->find('first',array('fields'=>array('phrase'),'conditions'=>array('phrase'=>$getData,'is_deleted'=>0,'location_id'=>$this->Session->read('locationid'))));
				if($smartData['SmartPhrase']['phrase']==$getData){
					//unset($exStr[$key]);
				}
					
			}
			echo json_encode($exStr);exit;
		}else{
			$exStr=array();
			echo json_encode($exStr);exit;
		}
	}
	public function getsmartPharseFinal($id,$diaName){
		$this->autoRender=false;
		$this->uses = array('SnomedMappingMaster','SmartPhrase');
		$getDiaParse=$this->SnomedMappingMaster->find('first',array('fields'=>array('is_smart'),'conditions'=>array('id'=>$id,'is_deleted'=>0)));

		if(!empty($getDiaParse['SnomedMappingMaster']['is_smart'])){
		//	$exStr=explode("|",$getDiaParse['SnomedMappingMaster']['is_smart']);	
			$exStr = array_map('trim', explode('|',$getDiaParse['SnomedMappingMaster']['is_smart']));
			
			$exStr = array_map('strtolower', $exStr);
			$exStr=array_filter($exStr);		
			$exStr=array_unique($exStr);		
			$exStr=array_values($exStr);
			foreach($exStr as $key=>$getData){					
				$getData=trim($getData);			
				/*$smartDataForPhrase=$this->SmartPhrase->find('first',array('fields'=>array('phrase'),'conditions'=>array('phrase'=>$getData,'is_deleted'=>0,'location_id'=>$this->Session->read('locationid'))));
				if($smartDataForPhrase['SmartPhrase']['phrase']==$getData){
					unset($exStr[$key]);
				}*/	
				
				$smartData=$this->SmartPhrase->find('first',array('fields'=>array('phrase'),'conditions'=>array('phrase'=>$getData,'is_deleted'=>0,'location_id'=>$this->Session->read('locationid'))));
			
				
			/*if($smartData['SmartPhrase']['phrase']==$getData){	debug($exStr);			
				unset($exStr[$key]);
			}*/
		}
			echo json_encode($exStr);//exit;	
		}else{
			$exStr=array();
			echo json_encode($exStr) ;//exit;
		}
	}
	public function getsmartPharseDiagnosisFinal($noteId){	
	$this->autoRender=false;
	$this->uses = array('NoteDiagnosis','SnomedMappingMaster');
	$getNoteDiagnosis=$this->NoteDiagnosis->find('all',array('fields'=>array('diagnoses_name','id'),
			'conditions'=>array('note_id'=>$noteId,'NoteDiagnosis.created_by'=>$this->Session->read('userid'),'is_deleted'=>0,'code_system'=>1,
					'NOT'=>array('diagnoses_name'=>null)),'group'=>'diagnoses_name'));

	
	$diaArr=array();
	foreach ($getNoteDiagnosis as $key=>$getNoteDiagnosisData){	
	$getSnomedMappingMaster=$this->SnomedMappingMaster->find('first',array('fields'=>array('id'),'conditions'=>array('icd9name'=>$getNoteDiagnosisData['NoteDiagnosis']['diagnoses_name'],'is_deleted'=>0)));
		$diaArr[$key]=$getNoteDiagnosisData['NoteDiagnosis']['diagnoses_name']."_".$getSnomedMappingMaster['SnomedMappingMaster']['id'];	
	}
	echo json_encode($diaArr); 
	exit;
		/*if(!empty($getDiaParse['SnomedMappingMaster']['is_smart'])){
			$exStr=explode('|',$getDiaParse['SnomedMappingMaster']['is_smart']);
			$dataNewUndeletedArr=array();
			foreach($exStr as $key=>$getData){
				$getData=trim($getData);
				$smartData=$this->SmartPhrase->find('first',array('fields'=>array('phrase'),'conditions'=>array('phrase'=>$getData,'is_deleted'=>1,'location_id'=>$this->Session->read('locationid'))));
					
				if($smartData['SmartPhrase']['phrase']==$getData){
					unset($exStr[$key]);
				}
					
			}
			echo json_encode($exStr);exit;
		}else{
			echo " ";exit;
		}*/
	}


	/**
	 * function for nurse priscription
	 * @author yashwant chauragade
	 * @param unknown_type $patientId
	 * @param unknown_type $drugId
	 * @param unknown_type $newCropID
	 * @param unknown_type $isDeleted
	 * @param unknown_type $noteId
	 */
	public function addNurseMedication($patientId=null,$drugId=null,$newCropID=null,$isDeleted=null,$noteId=null){
		//configure::write('debug',2);
		if(!empty($this->params->query['ajaxFlag'])){
			$ajaxHold=$this->params->query['ajaxFlag'];
			//$this->layout = 'advance' ;
			$this->set('ajaxHold',$ajaxHold);
		}else{
			$this->layout='advance';
			$this->set('title_for_layout', __('Nurse Prescription', true));
		}
		/* For Nurse set Flag Mrunal */
		if(!empty($this->params->query['from'])){

			$this->set('nurseFlag',$this->params->query['from']);
		}
		/* EOD */
		$this->uses=array('Configuration','NewCropPrescription','Patient','Note','PharmacyItem','SmartPhrase');
		/**********To set patient id in session for new patient hub when patiet in searched from this page- Pooja*********/
		$sessionPatientId=$this->Session->read('hub.patientid');
		//debug($sessionPatientId);
		if(empty($sessionPatientId) && !empty($patientId))
			$this->Patient->getSessionPatId($patientId);
		else{
			if(!empty($patientId)){
				if($sessionPatientId!=$patientId)
					$this->Patient->getSessionPatId($patientId);
			}
		}
		/*********************************************************************************************************/
		
		  
		if($this->Session->read('website.instance')=='vadodara'){//comented for optimization   --yashawant
			$this->patient_billing_info($patientId);
		}else{
			$this->patient_billing_info($patientId);
		}
		    
		$this->set('IPD',$this->params->query['returnUrl']);
		$this->set('Uid',$this->viewVars['patient']['Patient']['person_id']);
		/* $getUId=$this->Patient->find('first',array('fields'=>array('person_id'),'conditions'=>array('id'=>$patientId)));
		$this->set('Uid',$getUId['Patient']['person_id']); // comented for optimization  --yashwant*/
		/* $phrase_array=$this->SmartPhrase->find('list',array('fields'=>array('phrase','phrase'),'conditions'=>array('is_deleted'=>'0','location_id NOT'=>NULL)));
		$this->set('phrase_array',$phrase_array); // comented for optimization  --yashwant*/
		//find newcrop health plan
		/*$getHealthPlanId=$this->Patient->find('first',array('fields'=>array('patient_health_plan_id'),'conditions'=>array('id'=>$patientId)));
		$this->set('patientHealthPlanID',$getHealthPlanId['Patient']['patient_health_plan_id']); --Comeented by Atul*/
		// seen status
		//$this->Note->seenStatus();
		///
		//set PAtient n NoteId to Ctp
		$this->set('patientId',$patientId);
		$this->set('noteId',$noteId);
 
		/**bof medication is not present**/

		if(!empty($this->params->query['flag']) && $this->params->query['flag']=='notPresent'){
			$this->set('flag',$this->params->query['flag']);
			$medNotPresent=$this->NewCropPrescription->find('first',array('fields'=>array('NewCropPrescription.drug_name','NewCropPrescription.description'),
					'conditions'=>array('NewCropPrescription.id'=>$drugId)));

			$temp=$this->PharmacyItem->find('list',array('fields'=>array('PharmacyItem.drug_id','PharmacyItem.name'),'conditions'=>array('PharmacyItem.name LIKE'=>'%'.$medNotPresent['NewCropPrescription']['description'].'%'/*,'AllergyMaster.status'=>'A'*/)));
			$this->set('temp',$temp);
		}

		/**eof medication is not present**/

		//***********delete medication************//
		if(!empty($newCropID) && !empty($isDeleted) && $isDeleted=='1'){
			$this->NewCropPrescription->updateAll(array('NewCropPrescription.archive'=>"'D'"),
					array('NewCropPrescription.id'=>$newCropID));
			$this->Session->setFlash(__('Medication Deleted Successfully' ),true,array('class'=>'message'));
			exit;
		}
		//-----------------------------
		//--- New Medication Unit DOSE AND STRENGHT ADD DO NOT REMOVE Aditya
		$getConfiguration=$this->Configuration->find('all');
		$strenght=unserialize($getConfiguration[0]['Configuration']['value']);
		$dose=unserialize($getConfiguration[1]['Configuration']['value']);
		//$route=unserialize($getConfiguration[2]['Configuration']['value'];)
		$route=Configure::read('route_administration');
		$dose_type=Configure::read('dose_type');
		$strength=Configure::read('strength');
		$roop=Configure::read('roop');
		// roop
		for($i=1;$i<=count($roop);$i++){
			$roopName.='<option value='.'"'.$i.'"'.'>'.$roop[$i].'</option>';
		}
		$roopName.='</select>';
		$this->set('roopName',$roopName);
		foreach($strength as $key=>$strenghts){
			$str.='<option value='.'"'.$key.'"'.'>'.$strenghts.'</option>';
		}
		$str.='</select>';
		$this->set('str',$str);
		//================================ dose
		foreach($dose_type as $doses){
			$str_dose.='<option value='.'"'.$doses.'"'.'>'.$doses.'</option>';
		}
		$str_dose.='</select>';
		$this->set('str_dose',$str_dose);
		 
		// =======================================end dose
		//============================== route
		foreach($route as $key=>$routes){
			$str_route.='<option value='.'"'.stripslashes($key).'"'.'>'.$routes.'</option>';
		}
		$str_route.='</select>';

		$this->set('str_route',$str_route);
		//================= end dose
		//$this->set('strenght',unserialize($getConfiguration[0]['Configuration']['value']));
		foreach(unserialize($getConfiguration[0]['Configuration']['value']) as $key=>$strenght){
			if(!empty($strenght))
				$strenght_var[$strenght]=$strenght;
		}
		$this->set('strenght',$strenght_var);
		//$this->set('dose',unserialize($getConfiguration[1]['Configuration']['value']));
		foreach(unserialize($getConfiguration[1]['Configuration']['value']) as $key=>$doses){
			if(!empty($doses))
				$dose_var[$doses]=$doses;
		}
		$this->set('dose',$dose_var);
		//$this->set('route',unserialize($getConfiguration[2]['Configuration']['value']));
		foreach(unserialize($getConfiguration[2]['Configuration']['value']) as $key=>$route){
			if(!empty($route))
				$route_var[$route]=$route;
		}
		$this->set('route',$route_var);

		$frequency_var=Configure :: read('frequency');
		foreach($frequency_var as $key=>$frequency_vars){
			$frq_dose.='<option value='.'"'.$key.'"'.'>'.$frequency_vars.'</option>';
		}
		$frq_dose.='</select>';
		$this->set('frequency_var',$frq_dose);
		//==========================================================
		//***************************Bring data from NewCropPrescription in edit*******************************************
		if(empty($drugId)){
			
		}
		else{

			$getMedicationRecords=$this->NewCropPrescription->find('all',
					array('conditions'=>array('patient_uniqueid'=>$patientId,'id'=>$drugId,'is_deleted'=>'0')));
			$this->set('getMedicationRecords',$getMedicationRecords);
			if(empty($getMedicationRecords)){
				$getMedicationRecordsListData=$this->NewCropPrescription->find('all',
						array('conditions'=>array('patient_uniqueid'=>$patientId,'is_deleted'=>'0'),'fields'=>array('drug_id')));
				foreach($getMedicationRecordsListData as $getMedicationRecordsListDataData){
					$list[]=$getMedicationRecordsListDataData['NewCropPrescription']['drug_id'];
				}
				$getPhraseName=$this->Note->find('first',array('fields'=>array('pharse_name'),
						'conditions'=>array('id'=>$noteId,'Note.created_by'=>$this->Session->read('userid'))));
				$getPhraseName="";//patch to stop execution of this code
				if(!empty($getPhraseName)){
					$getMedicationRecordsXml=$this->Note->readSaveXml($noteId,$getPhraseName['Note']['pharse_name']);
				}
				$chkCnt=0;
				foreach($getMedicationRecordsXml['NewCropPrescription'] as $key=>$exitData){
					if(in_array($exitData['id'],$list)){
						$chkCnt++;
					}else{

					}
					if($chkCnt==0){
						
						$this->set('getMedicationRecordsXml',$getMedicationRecordsXml);

					}
				}

			}
		}
		//
		//*****************************************************************************************************************

		$getPreviousMedication=$this->NewCropPrescription->find('all',array('fields'=>array('id','created','drm_date','status','pharmacy_sales_bill_id','recieved_quantity'),
				'conditions'=>array('patient_uniqueid'=>$patientId,'is_deleted'=>'0'/*,'status'=>'1'*/)
				,'group'=>array('NewCropPrescription.drm_date')
				,'order'=>array('NewCropPrescription.id DESC')));
		$this->set('getPreviousMedication',$getPreviousMedication);
	}

	/**
	 * nurse prescription date wise
	 * @param unknown_type $patientId
	 * @param unknown_type $date
	 * @yashwant
	 */
	public function nursePrescription($patientId=null,$date=null){  
		$this->set('patientId',$patientId);
		$this->set('date',$date);
		//$this->autoRender = false;
		$this->loadModel('NewCropPrescription');
		$this->loadModel('PharmacySalesBill');
		$this->NewCropPrescription->bindModel(array(
				'belongsTo'=>array(
						'PharmacySalesBill'=>array('foreignKey'=>false,'conditions'=>array('NewCropPrescription.pharmacy_sales_bill_id = PharmacySalesBill.id')),
						'PharmacySalesBillDetail'=>array('foreignKey'=>false,'conditions'=>array('PharmacySalesBillDetail.item_id = NewCropPrescription.drug_id',
								'PharmacySalesBillDetail.pharmacy_sales_bill_id = PharmacySalesBill.id'))
						)
				));
		$getPreviousMedication=$this->NewCropPrescription->find('all',array('fields'=>array('NewCropPrescription.id','NewCropPrescription.description','NewCropPrescription.quantity',
				'NewCropPrescription.dose','NewCropPrescription.DosageForm','NewCropPrescription.dosageValue','NewCropPrescription.strength','NewCropPrescription.route',
				'NewCropPrescription.frequency','NewCropPrescription.day','NewCropPrescription.prn','NewCropPrescription.daw','NewCropPrescription.firstdose','NewCropPrescription.is_override',
				'NewCropPrescription.stopdose','NewCropPrescription.archive','NewCropPrescription.drug_id','NewCropPrescription.drug_name','NewCropPrescription.date_of_prescription',
				'NewCropPrescription.drm_date','NewCropPrescription.patient_id','NewCropPrescription.patient_uniqueid','NewCropPrescription.pharmacy_sales_bill_id','NewCropPrescription.is_deleted',
				'NewCropPrescription.status','NewCropPrescription.recieved_quantity','PharmacySalesBill.id','PharmacySalesBillDetail.id','PharmacySalesBill.is_received','PharmacySalesBillDetail.qty'),
				'conditions'=>array('NewCropPrescription.patient_uniqueid'=>$patientId/* ,'NewCropPrescription.is_deleted'=>'0' */
				/*,'status'=>'1','pharmacy_sales_bill_id'=>$salesId*/,'NewCropPrescription.drm_date'=>$date),
				'group'=>'NewCropPrescription.id')); /* Gruop by used to remove duplicate entry of one sales bill  */
		
		$this->set('getPreviousMedication',$getPreviousMedication);
  	
		foreach($getPreviousMedication as $getPreMed){
			if($getPreMed['NewCropPrescription']['pharmacy_sales_bill_id']){
				$pharmacyGroupDataWithId[$getPreMed['NewCropPrescription']['pharmacy_sales_bill_id']][] = $getPreMed;
			}else{
				$pharmacyGroupDataWithoutId[] = $getPreMed;
			}
		}
		$this->set('pharmacyGroupDataWithId',$pharmacyGroupDataWithId);
		$this->set('pharmacyGroupDataWithoutId',$pharmacyGroupDataWithoutId);
	} 
	
	/**
	 * function for delete medication
	 * @param $recId
	 * results update is_deleted=1 in newCropPrescription
	 * @ yashwant
	 */
	public function deleteMedication($recId=null,$patientId=null,$date=null){
		$this->autoRender = false;
		$this->loadModel('NewCropPrescription');
		if($recId){
			$this->NewCropPrescription->updateAll(array('NewCropPrescription.is_deleted'=>'1'),array('NewCropPrescription.id'=>$recId));
			$updatedPrescription=$this->nursePrescription($patientId,$date);
			$this->render('nurse_prescription');
		}
	}
	public function deleteMed($recId){
		$this->autoRender = false;
		$this->loadModel('NewCropPrescription');
		if($recId){
			$this->NewCropPrescription->updateAll(array('NewCropPrescription.is_deleted'=>'1'),array('NewCropPrescription.id'=>$recId));
			return;
		}
	}

	public function deleteItems(){
		$this->uses=array('NewCropPrescription','Note');
		//	$this->layout = false;
		//	$this->autoRender = false;
		if($this->request->data['modelName']=='NewCrop'){
			$this->NewCropPrescription->updateAll(array('NewCropPrescription.is_deleted'=>'1'),array('NewCropPrescription.id'=>$this->request->data['preRecordId']));
			$getNewCropPrescriptionfirst=$this->NewCropPrescription->find('first',array('fields'=>array('NewCropPrescription.drug_name','NewCropPrescription.note_id'),'conditions'=>array('NewCropPrescription.id'=>$this->request->data['preRecordId'],'NewCropPrescription.is_deleted'=>'1')));
	
			$getNoteDataTamplateFullText=$this->Note->find('first',array('fields'=>array('Note.template_full_text'),
					'conditions'=>array('Note.id'=>$getNewCropPrescriptionfirst['NewCropPrescription']['note_id'],'Note.created_by'=>$this->Session->read('userid'))));
			
			$saveMedArray= preg_split("/\r\n|\n|\r/", $getNoteDataTamplateFullText['Note']['template_full_text']);
			
			foreach($saveMedArray as $keyMedNew=>$templateFullTextArrays){
				$explodedDataMedName[$keyMedNew]=explode("::",$templateFullTextArrays);
				$explodedOnlyFinalMedName[$keyMedNew]=explode("---",$explodedDataMedName[$keyMedNew]['1']);
				$expMedNamArr[$keyMedNew]=trim($explodedOnlyFinalMedName[$keyMedNew]['0']);
				//debug($expMedNamArr[$keyMedNew]);
				if(empty($expMedNamArr[$keyMedNew])){
					continue;
				}		
			}
	
			$expMedNamArr = array_map('strtolower', $expMedNamArr);
			$drugName=strtolower($getNewCropPrescriptionfirst['NewCropPrescription']['drug_name']);
			if(in_array($drugName,$expMedNamArr)){
				$keyDrugName = array_search($drugName, $expMedNamArr);				
				unset($saveMedArray[$keyDrugName]);				
			}
		
			$getFinalText=implode("\n", $saveMedArray);
	
			if(!empty($getNewCropPrescriptionfirst['NewCropPrescription']['note_id'])){
				$arryDataNote['template_full_text']=$getFinalText;
				$arryDataNote['id']=$getNewCropPrescriptionfirst['NewCropPrescription']['note_id'];
				$this->Note->save($arryDataNote);
			}
			echo $getFinalText;			
			exit;
		}
	}
	
	/**
	 * function to list all previous encounters notes
	 * @param int $personId
	 * @author Gaurav Chauriya
	 */
	public function noteList($personId){
		$this->layout = 'advance';
		$this->set('title_for_layout', __('Note List', true));
		$this->uses  = array('Patient','note','StoreLocation','Department','Account','LocationType','Role');
		$patientList = $this->Patient->find('list',array('fields'=>array('id'),'conditions'=>array('person_id'=>$personId)));
		$this->Note->bindModel(array(
				'hasOne'=>array(
						'Appointment'=>array('foreignKey'=>false,
								'conditions'=>array('Appointment.patient_id = Note.patient_id')))));
		$this->paginate = array(
				'evalScripts' => true,
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Note.id'=>'DESC'),
				'fields'=> array('Note.id','Note.patient_id','Note.create_time','Appointment.id'),
				'conditions' => array('Note.patient_id' => $patientList,$searchByName)
		);
		$data = $this->paginate('Note');
		$this->set('data', $data);
	}
	public function testTreeview(){
		
	}
	Public function epen($patientId=null,$noteID=null){
		$this->layout="ajax";
		$this->uses  = array('Patient','note','Person', 'Location', 'DoctorTemplate', 'OperativeNote', 'DischargeSummary');

		// CodeCreatives
		$roleType    = $this->Session->read('role');
		$locationArr = $this->Location->find('list',array('fields'=>array('id'),'conditions'=>array('is_deleted'=>0)));
    	
    	if(strtolower($roleType) == strtolower(Configure::read('doctorLabel'))) {
    	 	$data = $this->DoctorTemplate->find('all',
    	 		array(
    	 			'conditions' => array(
    	 				'DoctorTemplate.is_deleted' => 0,
    	 				"(DoctorTemplate.user_id  = " . $this->Session->read('userid') . " OR DoctorTemplate.user_id  = 0) `AND DoctorTemplate.department_id =". $this->Session->read('departmentid'),
    	 				'DoctorTemplate.template_type like'=>"%diagnosis",'DoctorTemplate.location_id IN ('.implode(",",$locationArr).')'
    	 			)
    	 		)
    	 	);
         } else {
         	$data = $this->DoctorTemplate->find('all',
         		array(
         			'conditions' => array(
         				'DoctorTemplate.is_deleted' => 0,
         				'DoctorTemplate.template_type like'=>"%diagnosis",
         				'DoctorTemplate.location_id IN ('.implode(",",$locationArr).')'
         			)
         		)
         	);
         	
        }

		$oprNotes = $this->OperativeNote->find('first', array(
			'conditions' => array(
				'patient_id' => $patientId
			),
			'order'=>'id DESC'
		));

		$this->set('oprNotes', $oprNotes);

		$notesRec = $this->DischargeSummary->find('first',
			array('conditions' => array('DischargeSummary.patient_id' => $patientId))
		);

		$this->set('notesRec', $notesRec);

        // End

		/** get element detials **/
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id')),
						'Appointment' =>array('foreignKey' => false,'conditions'=>array('Appointment.patient_id=Patient.id')),
						'TariffList' =>array('foreignKey' => false,'conditions'=>array('TariffList.id=Patient.treatment_type')),
				)));
		// CodeCreatives
		$getBasicData=$this->Patient->find('first',array('fields'=>array('id','person_id','Person.dob','Person.ready_to_fetch','lookup_name','age','sex','patient_weight','Patient.admission_type','epenImages', 'Patient.admission_id', 'Person.patient_uid'),
				'conditions'=>array('Patient.id'=>$patientId)));
		$getCurrentAge=$this->Person->getCurrentAge($getBasicData['Person']['dob']);
		$this->set('getCurrentAge',$getCurrentAge);
		$this->set('getBasicData',$getBasicData);
		$this->set('personId',$getBasicData['Patient']['person_id']);

		$getDataFormNote=$this->Note->find('first',array('fields'=>array('ros','subject','object','assis','epen_data','plan'),
				'conditions'=>array('id'=>$noteID)));

		$this->set('getDataFormNote',$getDataFormNote);
		$this->set('noteID',$noteID);
		$this->set('patientId',$patientId);
		
		$this->set('data', $data);
		echo $this->render('epen');
		exit;
	}
	
	public function phraseComplete(){
		$this->layout='advance_ajax';
		$this->loadModel('SmartPhrase');
		$searchKey = $this->params->query['term'] ;
		$key = inv;
		$conditions["SmartPhrase.phrase like"] = "%".$searchKey."%";
		$conditions["SmartPhrase.phrase NOT LIKE"] = "%".$key;
	
		$medArray=$this->SmartPhrase->find('list',array('fields'=>array('phrase','phrase'),'conditions'=>array($conditions,
				'is_deleted'=>'0',
				'is_nursing'=>'1'
                    )));
	
		foreach($medArray as $key=>$value){
			$returnArray[] = array( 'id'=>$key,'value'=>$value);
		}
		echo json_encode($returnArray);
		exit;
	}
	
	public function newPharmacyComplete($tariffStdId=null){
		$this->layout = "ajax";
		$model='PharmacyItem';
		$this->loadModel($model);
		$this->loadModel('PharmacyItemRate');
		$this->loadModel('TariffStandard');
		
		$this->PharmacyItem->unbindModel(array('hasOne'=>array('PharmacyItemRate')));
		
		$this->$model->bindModel(array('hasMany'=>array('PharmacyItemRate'=>array('foreignKey'=>'item_id'))));
		$searchKey = $this->params->query['term'] ;
		if($model == "PharmacyItem"){
			$conditions['PharmacyItem.drug_id !='] = 0;
		}
		$conditions[$model.".name like"] = $searchKey."%";
		$conditions[$model.".is_deleted"] != '1';
		$conditions[$model.".item_type"] = 1;
		if($this->Session->read('website.instance')=='kanpur' && $this->Session->read('locationid')=='22'){//to take med. from roman pharma extention  --yashwant
			$conditions[$model.".location_id"] = '26';
		}elseif($this->Session->read('website.instance')=='kanpur' && $this->Session->read('locationid')=='1'){//to take med. from roman pharma  --yashwant
			$conditions[$model.".location_id"] = '25';
		} //else{
		//commnetd by pankaj as we do not require location id for hope or vadodara
		//$conditions[$model.".location_id"] = $this->Session->read('locationid');
		//}
		if(($this->Session->read('website.instance')!='hope') && ($this->Session->read('website.instance')!='kanpur')){
			//$conditions[$model.".stock >"]='0';
			//commented by swapnil to display whole product
			//$conditions['OR'] = array($model.".stock > 0",$model.".loose_stock > 0");
		}
		
			$testArray = $this->$model->find('all', array('fields'=> array('id','pack','stock','loose_stock','name','opdgeneral_ward_discount',
					"drug_id",'MED_STRENGTH','MED_STRENGTH_UOM','MED_ROUTE_ABBR'/* ,'PharmacyItemRate.*' */),'conditions'=>$conditions,'limit'=>20));
		foreach ($testArray as $key=>$value) { 
			$totalStock = 0;
			foreach($value['PharmacyItemRate'] as $pValue){
				$totalStock += ((int)$value['PharmacyItem']['pack'] * $pValue['stock'] )+ $pValue['loose_stock'];
				if(!empty($pValue['mrp'])){
					$price = $pValue['mrp'] / (int)$value['PharmacyItem']['pack'];
				}else{
					$price = $pValue['sale_price'] / (int)$value['PharmacyItem']['pack'];
				}
			} 
			//$totalStock = ((int)$value['PharmacyItem']['pack']*$value['PharmacyItem']['stock'] )+ $value['PharmacyItem']['loose_stock'];
			/* 	
			if(!empty($value['PharmacyItemRate']['sale_price'])){
				$price = $value['PharmacyItemRate']['sale_price'] / (int)$value['PharmacyItem']['pack'];
			}else{
				$price = $value['PharmacyItemRate']['mrp'] / (int)$value['PharmacyItem']['pack'];
			} */
			$privateId = $this->TariffStandard->getTariffStandardID( 'privateTariffName');
			if($tariffStdId==$privateId){
				$discount= $value['PharmacyItem']['opdgeneral_ward_discount'];
			}else{
				$discount= '';
			}
			$returnArray[] = array( 'drug_id'=>$value['PharmacyItem']['id'],'pack'=>$value['PharmacyItem']['pack'],'expiry'=>$pValue['expiry_date'],'batch'=>$pValue['batch_number'],
                            'value'=>$value['PharmacyItem']['name'],'stock'=>$totalStock,'mrp'=>$price!=''?$price:0,'discount'=>$discount) ;
		}
		echo json_encode($returnArray);
		exit;
	}
	
	public function ajax_add_other_service($patientId,$noteId=null,$appointmentId=null){
		$this->layout='ajax';
		$this->uses = array('ServiceBill','Patient','TariffStandard','Room','ServiceCategory');
		
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Room' =>array('foreignKey'=>false,
								'conditions'=>array('Room.id = Patient.room_id')),
				)));
		$addmissionType =$this->Patient->find('first',array('fields'=>array('Patient.admission_type','Patient.tariff_standard_id','Patient.doctor_id',
				'Patient.treatment_type','Patient.form_received_on','Patient.is_packaged','Room.room_type'),
				'conditions'=>array('Patient.id'=>$patientId)));
		$this->set('addmissionType',$addmissionType);
		$serviceCatId=$this->ServiceCategory->getServiceGroupIdbyName(Configure::read('otherServices'));
	    $this->set('serviceCatId',$serviceCatId);
		$this->set('patientId',$patientId);
		$this->set('noteId',$noteId);
		$this->set('appointmentId',$appointmentId);
		//BOF pankaj 
		$doctor_id = $this->Session->read('userid'); 
		$serviceData = $this->ServiceBill->getServices(array('ServiceBill.patient_id'=>$patientId,'ServiceBill.doctor_id'=>$doctor_id));
		$this->set('serviceData',$serviceData);
		//EOF pankaj
		echo $this->render('ajax_add_other_service');
		exit;
	}
	
	function getOtherServicesAutocomplete($patientId =null , $admissionId=null){
		$this->layout = 'ajax' ;
		$this->loadModel('TariffList');
	
		if($this->params->query['flag']=='servicePackage'){//for service package  --yashwant
			$group_id=$this->params->query['groupID'];
		}
		$this->loadModel('ServiceCategory');
		$groupName=$this->ServiceCategory->getServiceCategoryName($group_id);
	
		if($this->params->query['is_nurse']=='yes'){//for is group is active for billing and not for nursing then chages in nursing come in other service autocomplete
			$serviceCatCond= 'ServiceCategory.is_enable_for_nursing !=1';
		}else{
			$serviceCatCond= 'ServiceCategory.is_view =1';
		}
		//debug($serviceCatCond);
		$data['TariffList.is_deleted'] = '0';
		$data['ServiceCategory.is_deleted'] = '0';
		$data['TariffList.name LIKE'] ='%'.$this->params->query['term'].'%';
		//$data['ServiceCategory.service_type']  ; //-- comented by yashwant
		$data['ServiceCategory.name !=']=Configure::read('histopathologyGroup') ;
		$tariffStandardID = $this->params->query['tariff_standard_id'] ;
		if(!$tariffStandardID) $tariffStandardID =  Configure::read('privateTariffId') ; //set to private ID
		if($this->Session->read('website.instance')=='vadodara'){
			$this->TariffList->bindModel(array(
					'belongsTo' => array(
							'TariffAmount'=>array('type'=>'inner','foreignKey' => false,'conditions'=>array('TariffList.id=TariffAmount.tariff_list_id',
									'TariffAmount.tariff_standard_id='.$tariffStandardID)),
							'TariffAmountType'=>array('type'=>'inner','foreignKey' => false,'conditions'=>array('TariffList.id=TariffAmountType.tariff_list_id',
									'TariffAmountType.tariff_standard_id='.$tariffStandardID)),
							'ServiceCategory'=>array('type'=>'inner','foreignKey' => false ,'conditions'=>array('TariffList.service_category_id=ServiceCategory.id'
									,$serviceCatCond ))
					)),false);
	
			$services = $this->TariffList->find('all',array('fields'=>array('TariffList.name','TariffList.service_category_id','TariffList.id','TariffAmount.nabh_charges',
					'TariffAmount.non_nabh_charges','TariffAmountType.*','ServiceCategory.name','ServiceCategory.service_type'),'conditions'=>array_merge(array('ServiceCategory.service_type IS NULL'),$data),'group'=>array('TariffList.id'),'limit'=>'20'));
			$admissionType = $this->params->query['admission_type'] ;
			$patientId = $this->params->query['patient_id'] ;
	
			// to skip service except of other service group  --yashwant
			$servicesNewArr=array();
			foreach($services as $servicesKeySkip=>$servicesValueSkip){
					
				$servicesNewArr[]=$servicesValueSkip;
			}
	
			if($admissionType=='IPD'){
				$hospitalType = $this->Session->read('hospitaltype');
				if($hospitalType == 'NABH'){
					$nursingServiceCostType = 'nabh_charges';
				}else{
					$nursingServiceCostType = 'non_nabh_charges';
				}
					
				$roomTypes = Configure::read('roomtType') ;
				$isolation  = $roomTypes['isolation'] ;
				if(strtolower($this->params->query['room_type'])==strtolower($isolation)){
					$patientRoomType  = strtolower($roomTypes['general'])."_ward_charge" ; //for database field name
				}else{
					$patientRoomType  = $this->params->query['room_type']."_ward_charge" ; //for database field name
				}
					
				//$patientRoomType  = $this->params->query['room_type']."_ward_charge" ; //for database field name
				foreach ($servicesNewArr as $key=>$value) {
					if($value['TariffAmountType'][$patientRoomType] != ''){
						$returnArray[] = array( 'id'=>$value['TariffList']['id'],'value'=>ucwords($value['TariffList']['name']),'charges'=>$value['TariffAmountType'][$patientRoomType],
								'group'=>$value['ServiceCategory']['name']) ;
					}else{
						$returnArray[] = array( 'id'=>$value['TariffList']['id'],'value'=>ucwords($value['TariffList']['name']),'charges'=>$value['TariffAmount'][$nursingServiceCostType],
								'group'=>$value['ServiceCategory']['name']) ;
					}
				}
			}else{
				$hospitalType = $this->Session->read('hospitaltype');
				if($hospitalType == 'NABH'){
					$nursingServiceCostType = 'nabh_charges';
				}else{
					$nursingServiceCostType = 'non_nabh_charges';
				}
				$patientRoomType  = "opd_charge" ; //for database field name
	
				foreach ($servicesNewArr as $key=>$value) {
					//check if the service has room type charges added in master
					if($value['TariffAmountType'][$patientRoomType] != ''){
						$returnArray[] = array( 'id'=>$value['TariffList']['id'],'value'=>ucwords($value['TariffList']['name']),'charges'=>$value['TariffAmountType'][$patientRoomType],
								'group'=>$value['ServiceCategory']['name']) ;
					}else{
						$returnArray[] = array( 'id'=>$value['TariffList']['id'],'value'=>ucwords($value['TariffList']['name']),'charges'=>$value['TariffAmount'][$nursingServiceCostType],
								'group'=>$value['ServiceCategory']['name']) ;
					}
				}
			}
	
		}
		echo json_encode($returnArray);
		exit;//dont remove this
	}
	
	public function saveMedCombo($namePharse=null){
		$this->autoRender=false;
		$this->loadModel('SmartPhrase');
		$this->loadModel('NoteDiagnosis');
		if(isset($this->request->data) && !empty($this->request->data)){
			$data['SmartPhrase']['phrase']=$this->request->data['phraseName'];
			$data['SmartPhrase']['phrase_text']="CMED";
			$data['SmartPhrase']['is_doctor_combo']=$this->request->data['is_doctor_combo'];
			$data['SmartPhrase']['combo_type']=$this->request->data['is_service_combo'];
			//$this->SmartPhrase->save($data['SmartPhrase']);
			$this->SmartPhrase->insertPhrase($data);
			$this->SmartPhrase->createDynTempMed($this->request->data,$namePharse);
			
			if($this->request->data['Diagnosis']){
				foreach ($this->request->data['Diagnosis'] as $key => $value) {
					$diagnsisIdArray[]=$key;
				}
			}
			$diagnosisIdData=implode(',', $diagnsisIdArray);
			$this->SmartPhrase->linkDia($diagnosisIdData,$namePharse);
		}
	}
	
	//function to check SamrtPhrasename availability
	function ajaxValidateSamrtPhrasename($smartPhraseName){
		$this->loadModel('SmartPhrase');
		$this->layout = 'ajax';
		$this->autoRender =false ;
		if($smartPhraseName == ''){
			return;
		}
		$count = $this->SmartPhrase->find('count',array('conditions'=>array('phrase LIKE'=>$smartPhraseName."%",'SmartPhrase.is_deleted' => 0)));
		if($count>0){
			return  "Duplicate";
		}else{
			return  "Unique" ;
		}
		exit;
	}
	
	/**
	 * function for delete soap note other services
	 * @author Atul Chandankhede
	 * @param  int $serviceId 
	 */
	public function deleteOtherService($serviceId){
		$this->autoRender = false;
		$this->loadModel('ServiceBill');
		if($serviceId){
			$this->ServiceBill->updateAll(array('ServiceBill.is_deleted'=>'1'),array('ServiceBill.id'=>$serviceId));
			return;
		}
	}
	/**
	 * function for add combine services like lab,rad,other services
	 * @author Atul Chandankhede
	 * @param  int $patientId,$noteId,$appointmentId
	 */
	public function ajax_add_all_services($patientId,$noteId=null,$appointmentId=null){
		//$this->layout='ajax';
		$this->uses=array('Laboratory','Radiology','Patient','LaboratoryTestOrder','RadiologyTestOrder','ServiceBill',
				'ServiceCategory','Room','NoteDiagnosis','SmartPhrase','SnomedMappingMaster');
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Room' =>array('foreignKey'=>false,
								'conditions'=>array('Room.id = Patient.room_id')),
				)));
		$addmissionType =$this->Patient->find('first',array('fields'=>array('Patient.admission_type','Patient.tariff_standard_id','Patient.doctor_id',
				'Patient.treatment_type','Patient.form_received_on','Patient.is_packaged','Room.room_type'),
				'conditions'=>array('Patient.id'=>$patientId)));
		$this->set('addmissionType',$addmissionType);
		
		$serviceCatId=$this->ServiceCategory->getServiceGroupIdbyName(Configure::read('otherServices'));
		$this->set('serviceCatId',$serviceCatId);
		
		$this->set('patientId',$patientId);
		$this->set('noteId',$noteId);
		$this->set('appointmentId',$appointmentId);
		$doctorId= $this->Session->read('userid');
		// for Lab Listing
		$labData = $this->LaboratoryTestOrder->getLabDetails(array('LaboratoryTestOrder.patient_id'=>$patientId/*,'LaboratoryTestOrder.doctor_id'=>$doctorId*/));
		$this->set('labData',$labData);
		
		// for Radiology Listing
		$radData = $this->RadiologyTestOrder->getRadiologyDetails(array('RadiologyTestOrder.patient_id'=>$patientId/*,'RadiologyTestOrder.doctor_id'=>$doctorId*/));
		$this->set('radData',$radData);
		
		// for Other Services Listing
		$serviceData = $this->ServiceBill->getServices(array('ServiceBill.patient_id'=>$patientId/*,'ServiceBill.doctor_id'=>$doctorId*/));
		$this->set('serviceData',$serviceData);
		
		$this->NoteDiagnosis->unbindModel(array('belongsTo'=>array('icds')));
		$this->NoteDiagnosis->bindModel(array('belongsTo'=>array(
				'SnomedMappingMaster'=>array('foreignKey'=>false,'type'=>'inner','conditions'=>array('SnomedMappingMaster.id=NoteDiagnosis.diagnosis_id'))
				
				)));
		
		$diagnosisList=$this->NoteDiagnosis->find('all',array('fields'=>array('NoteDiagnosis.diagnosis_id','SnomedMappingMaster.icd9name','SnomedMappingMaster.is_smart'),
				'conditions'=>array('patient_id'=>$patientId,'NoteDiagnosis.is_deleted'=>0))); 
		 
		$this->set('diagnosisList',$diagnosisList); 
	}
	
	public function saveServiceCombo($namePharse=null){
		$this->autoRender=false;
		$this->loadModel('SmartPhrase');
		$this->loadModel('NoteDiagnosis');
		//debug($this->request->data);exit;
		if(isset($this->request->data) && !empty($this->request->data)){
			if(!empty($this->request->data['tariff_list'])){
				$tariffList="Other Service";
			}else{
				$tariffList="";
			}
			if(!empty($this->request->data['radiology'])){
				$rad="RAD";
			}else{
				$rad="";
			}
			if(!empty($this->request->data['lab'])){
				$lab="LAB";
			}else{
				$lab="";
			}
			$data['SmartPhrase']['phrase']=$this->request->data['phraseName'];
			$data['SmartPhrase']['phrase_text']=$tariffList." ".$rad." ".$lab;
			$data['SmartPhrase']['is_doctor_combo']=$this->request->data['is_doctor_combo'];
			$data['SmartPhrase']['combo_type']=$this->request->data['is_service_combo'];
			$labData=implode(',', $this->request->data['lab']);
			$radData=implode(',', $this->request->data['radiology']);
			$tariffListData=implode(',', $this->request->data['tariff_list']);
			$this->SmartPhrase->insertPhrase($data);
			$this->SmartPhrase->createDynTempLabRad($labData,$radData,$tariffListData,$namePharse);
			
			// map service combo with diagnosis
			if($this->request->data['Diagnosis']){
				foreach ($this->request->data['Diagnosis'] as $key => $value) {
						$diagnsisIdArray[]=$key;
					}
			}
			$diagnosisIdData=implode(',', $diagnsisIdArray);
			$this->SmartPhrase->linkDia($diagnosisIdData,$namePharse);
		}
	}
	
	public function previousSoapNotes($patientId,$noteId=null,$appointmentId=null){
		$this->uses=array('Note','Patient','Person');
		$personId=$this->Patient->find('first',array('fields'=>array('Patient.person_id'),'conditions'=>array('Patient.id'=>$patientId)));
		
		$getEncounterID=$this->Note->encounterHandler($patientId,$personId['Patient']['person_id']);
		$key='';
		foreach ($getEncounterID as $key=>$val){
		
		}
		unset($getEncounterID[$key]);
		
		$prevSoapData=$this->Note->find('all',array('fields'=>array('Note.id','Note.patient_id','Note.create_time'),
				'conditions'=>array('Note.patient_id'=>$getEncounterID)));
		
		$this->set('prevSoapData',$prevSoapData);
	}
	
	public function comboMedication($name=null,$prevMed=null,$patient_id=null,$batch_identifier=null){
		$this->uses=array('PharmacyItem','SmartPhrase','Patient');
		if($prevMed=='yes'){
			$returnArray=$this->loadPreviousMedication($patient_id,$batch_identifier); 
		}else{
			$returnArray=$this->loadLinkMedications($name);
			$phrase_array=$this->SmartPhrase->find('list',array('fields'=>array('phrase','phrase'),
					'conditions'=>array('is_deleted'=>'0','location_id NOT'=>NULL)));
			$this->set('phrase_array',$phrase_array);
		}
		//get patient room calss
		$patientRoomType= $this->Patient->getPatientPharmacyRoomClass($patient_id);
		 
		$this->PharmacyItem->unbindModel(array('hasOne'=>array('PharmacyItemRate')),false);
		$this->PharmacyItem->bindModel(array('hasMany'=>array('PharmacyItemRate'=>array('foreignKey'=>'item_id'))),false);
		
		foreach ($returnArray['NewCropPrescription'] as $key=>$value) {
			$returnArray['NewCropPrescription'][$key]['amount']=0;
			$returnArray['NewCropPrescription'][$key]['salePrice']=0;
			$totalStock=0;
			$medData=$this->PharmacyItem->find('first',array('conditions'=>array('PharmacyItem.id'=>$value['drug_id'])));
			  
			foreach($medData['PharmacyItemRate'] as $k=>$data){
				$totalStock += ((int)$medData['PharmacyItem']['pack'] * $data['stock'] )+ $data['loose_stock'];
				$returnArray['NewCropPrescription'][$key]['drugStock']=$totalStock;
				
				if(!empty($medData['PharmacyItemRate'][$k]['sale_price'])){
					$price = $medData['PharmacyItemRate'][$k]['sale_price'] / (int)$medData['PharmacyItem']['pack'];
				}else{
					$price = $medData['PharmacyItemRate'][$k]['mrp'] / (int)$medData['PharmacyItem']['pack'];
				}
			}
				
			$returnArray['NewCropPrescription'][$key]['salePrice']=$price;
			$actualTot=$value['quantity']*$price;
			 
			$returnArray['NewCropPrescription'][$key]['discount'] =  $medData['PharmacyItem'][$patientRoomType];
			$discountAmt=($actualTot*$medData['PharmacyItem'][$patientRoomType])/100;
			
			$returnArray['NewCropPrescription'][$key]['amount']= round($actualTot-$discountAmt);
		}
	
		$this->set('returnArray',$returnArray);
		$this->set('namePharse',$name);
	}
	
	/** read Xml with inv-Atul **/
	public function loadLinkMedications($name){
		$xmlString = file_get_contents('smartphrase_templates'.DS.strtolower($name).'.xml');
	
		$xml = simplexml_load_string($xmlString);
		$cnt="0";
	
		foreach($xml->newcropprescriptions->NewCropPrescription as $key=>$data){
			$newArry=(array) $data;
			$newArry['description'] =str_replace("@@","&",$newArry['description']);
			/*$newArry['description'] =str_replace("plus@@","+",$newArry['description']);
				$newArry['description'] =str_replace("minus@@","-",$newArry['description']);
			$newArry['description'] =str_replace("great@@",">",$newArry['description']);
			$newArry['description'] =str_replace("less@@","<",$newArry['description']);*/
				
			$returnAtty['NewCropPrescription'][$cnt]['description']=$newArry['description'];
			$returnAtty['NewCropPrescription'][$cnt]['drug_id']=$newArry['drug_id'];
			$returnAtty['NewCropPrescription'][$cnt]['dose']=$newArry['dose'];
			$returnAtty['NewCropPrescription'][$cnt]['doseForm']=$newArry['doseForm'];
			$returnAtty['NewCropPrescription'][$cnt]['route']=$newArry['route'];
			$returnAtty['NewCropPrescription'][$cnt]['frequency']=$newArry['frequency'];
			$returnAtty['NewCropPrescription'][$cnt]['days']=$newArry['days'];
			$returnAtty['NewCropPrescription'][$cnt]['strength']=$newArry['strength'];
			$returnAtty['NewCropPrescription'][$cnt]['quantity']=$newArry['quantity'];
			$returnAtty['NewCropPrescription'][$cnt]['dosage']=$newArry['dosage'];
			$returnAtty['NewCropPrescription'][$cnt]['discount']=$newArry['discount'];
			$returnAtty['NewCropPrescription'][$cnt]['instruction']=$newArry['instruction'];
			$returnAtty['NewCropPrescription'][$cnt]['Active']=$newArry['Active'];
			$cnt++;
		}
	
		return ($returnAtty);
	}
	/** **/
	
	public function comboAutoComplete($docComboCond=null,$serComboCond=null){
		$this->layout='advance_ajax';
		$this->loadModel('SmartPhrase');
		$searchKey = $this->params->query['term'] ;
		$key = inv;
		$conditions["SmartPhrase.phrase like"] =$searchKey."%";
		//$conditions["SmartPhrase.synonyms LIKE"] = "%".$key;
		if($docComboCond=="doctorCombo" && $serComboCond=="serviceCombo"){
			$medArray=$this->SmartPhrase->find('list',array('fields'=>array('phrase','phrase'),'conditions'=>array($conditions,
					'is_deleted'=>'0','is_doctor_combo'=>'1',
					'OR'=>array(array('combo_type'=>'service_combo'),array('combo_type'=>'BOTH')))));
		}else{
			$medArray=$this->SmartPhrase->find('list',array('fields'=>array('phrase','phrase'),'conditions'=>array($conditions,
					'is_deleted'=>'0','is_doctor_combo'=>'1',
					'OR'=>array(array('combo_type'=>'med_combo'),array('combo_type'=>'BOTH')))));
		}
		 
		foreach($medArray as $key=>$value){
			$returnArray[] = array( 'id'=>$key,'value'=>$value);
		}
		echo json_encode($returnArray);
		exit;
	}
	
	public function deleteDiagnosis($recId=null,$patientId=null,$date=null){
		$this->autoRender = false;
		$this->loadModel('NoteDiagnosis');
		if($recId){
			$this->NoteDiagnosis->updateAll(array('NoteDiagnosis.is_deleted'=>'1'),array('NoteDiagnosis.id'=>$recId));
		}
	}
	/**
	 *
	 * @param string $type
	 * @param unknown_type $excondition
	 * @author Atul Chandankhede
	 * 
	 */
	public function appointmentAutocomplete($type=NULL,$excondition=NULL){
		$this->layout = 'ajax';
		$this->loadModel('Patient');
		$this->loadModel('Appointment');
		$conditions =array();$condition=array();
		$searchKey = $this->params->query['term'] ;
		//Vadodara search will be for name and Patient UID / for other instance its Name and Patient MRN
		if($this->Session->read('website.instance')=='vadodara'){
			if(is_numeric($searchKey)){
				$conditions["Patient.patient_id like"] = 'MSA___'.$searchKey;
			}else{
				$conditions["Patient.patient_id like"] = $searchKey."%";
			}
		}else{
			$conditions["Patient.admission_id like"] = '%'.$searchKey.'%';
		}
		$conditions["Patient.lookup_name like"] = '%'.$searchKey.'%';
	
		if(!empty($type) && $type !='no'){
			$condition["Patient.admission_type"]=$type;
		}else{
			$condition["Patient.admission_type"]=array('IPD','OPD','LAB','RAD','emergency');
		}
		if($excondition)
			$excondition= explode("&",$excondition);
	
	
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Appointment'=>array('foreignKey'=>false,'conditions'=>array('Appointment.patient_id = Patient.id')),
						'Note'=>array('foreignKey'=>false,'conditions'=>array('Patient.id = Note.patient_id')),
				)));
		
		$testArray = $this->Patient->find('all', array(
				'fields'=> array('Patient.id','Patient.person_id','Patient.lookup_name','Patient.patient_id',
						'Patient.form_received_on' ,'Patient.admission_id','Appointment.id','Note.id'),
				'conditions'=>array('OR'=>($conditions),
						$condition,$excondition,'Patient.is_deleted=0'),
				'order'=>array("Patient.id Desc"),
				'group'=>array("Patient.patient_id"),
				'limit'=>Configure::read('number_of_rows')));
	
	
			foreach ($testArray as $key=>$value) {
				$returnArray[]=array('id'=>$value['Patient']['id'],'person_id'=>$value['Patient']['person_id'],'value'=>ucwords(strtolower($value['Patient']['lookup_name'])).'-'.$value['Patient']['patient_id'],'patient_id'=>$value['Patient']['patient_id'],'appointment_id'=>$value['Appointment']['id'],'note_id'=>$value['Note']['id']);
			}
		
		echo json_encode($returnArray);
		exit;
			
	}
	
	/**
	 * delete vitals from soapnote
	 */
	function deleteVital($bmiResultId=null,$bmiBpResult=null){
		$this->autoRender = false ;
		$this->loadModel('BmiResult');
		$this->loadModel('BmiBpResult');
		$this->BmiResult->delete(array('id'=>$bmiResultId));
		$this->BmiBpResult->delete(array('id'=>$bmiBpResult));
		exit;
	}
	
	/**
	 * fetch previous Ipd cheif complaint or notes-Atul
	 */
	
	function previousIpdNotes($id=null,$patientId=null){
		$this->autoRender = false ;
		$this->loadModel('DiagnosisDetail');
		$ipdNotesData=$this->DiagnosisDetail->find('first',array('fields'=>array('id','patient_id','note_id','complaints','complaint_date'),
				'conditions'=>array('patient_id'=>$patientId,'id'=>$id)));
		echo json_encode(array('id'=>$ipdNotesData['DiagnosisDetail']['id'],'complaints'=>$ipdNotesData['DiagnosisDetail']['complaints'])) ;
		exit;
	}

	/*
	 * Function to load click date medication 
	 * By pankaj 
	 * */
	function loadPreviousMedication($patient_id=null,$batch_identifier=null){
		if(!$patient_id && !$batch_identifier) return false ;
		$this->loadModel('NewCropPrescription') ;
		$this->NewCropPrescription->recursive = -1;  
		$result = $this->NewCropPrescription->find('all',array('conditions'=>array('NewCropPrescription.patient_id'=>$patient_id,
						'NewCropPrescription.batch_identifier'=>$batch_identifier)));
		$returnAtty = array();
		foreach($result as $key=>$data){ 
			$newArry = $data['NewCropPrescription'] ;
			$returnAtty['NewCropPrescription'][$cnt]['description']=$newArry['description'];
			$returnAtty['NewCropPrescription'][$cnt]['drug_id']=$newArry['drug_id'];
			$returnAtty['NewCropPrescription'][$cnt]['dose']=$newArry['dose'];
			$returnAtty['NewCropPrescription'][$cnt]['doseForm']=$newArry['doseForm'];
			$returnAtty['NewCropPrescription'][$cnt]['route']=$newArry['route'];
			$returnAtty['NewCropPrescription'][$cnt]['frequency']=$newArry['frequency'];
			$returnAtty['NewCropPrescription'][$cnt]['days']=$newArry['day'];
			$returnAtty['NewCropPrescription'][$cnt]['strength']=$newArry['strength'];
			$returnAtty['NewCropPrescription'][$cnt]['quantity']=$newArry['quantity'];
			$returnAtty['NewCropPrescription'][$cnt]['dosage']=$newArry['dosage'];
 			$returnAtty['NewCropPrescription'][$cnt]['instruction']=$newArry['instruction'];
			$returnAtty['NewCropPrescription'][$cnt]['Active']=$newArry['Active'];
			$cnt++;
		} 
		return $returnAtty ;
	} 
	
	/**
	 * function to save diagnosis to master directly from soap note .
	 * Atul Chandankhede
	 */
	function saveDiagnosisToMaster($name){
		$this->autoRender = false ;
		$this->loadModel('SnomedMappingMaster');
		if(!empty($name)){
			$this->request->data['SnomedMappingMaster']['icd9name']=$name;
			$this->request->data['SnomedMappingMaster']['active']= "1";
			$this->request->data['SnomedMappingMaster']['location_id']=$this->Session->read('locationid');
			$this->request->data['SnomedMappingMaster']['created_by']=$this->Session->read('userid');
			$this->request->data['SnomedMappingMaster']['create_time']=date("Y-m-d H:i:s");
			$data=$this->SnomedMappingMaster->save($this->request->data['SnomedMappingMaster']);
		}
		echo json_encode($data);
		exit;
	}
        
        public function checkIsPhraseAlreadyTaken($patientId,$phraseName){
            $this->layout = false;
            $this->autoRender = false;
            $this->uses = array('SmartPhrase','NewCropPrescription');
            $phraseData = $this->SmartPhrase->find('first',array('conditions'=>array('SmartPhrase.phrase'=>$phraseName)));  
            $isExist = $this->NewCropPrescription->checkPreviousPhraseTaken($patientId,$phraseData['SmartPhrase']['id']);
            //if($isExist) $return = 1; else $return = 0;
            echo json_encode($isExist);
            exit;
        }
        public function docComplete($set){
		$this->Session->write('set',$set);
		exit;

	}
        /** New Vitals **/
	/** EOD **/

	// CodeCreatives
	public function chatGPT()
	{

		$this->loadModel('ChatGptLog');
		if (isset($_POST['gpt_input'])) {
			$query = $_POST['gpt_input'];

			//$key = "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"; // gpt 3.5 Key
			$key = "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"; // gpt 4 Key
			/*$data = array(
				//'model'       => 'text-davinci-003',
				'model'       => 'gpt-4',
				"messages"    => array('role'=>'user','content'=>$query), //Your question or request
				"temperature" => 0.7,
				"max_tokens"  => 2000
			);*/

			$bodyText = [
                "model"=>"gpt-4",
                "messages"=>[
                    [
                        "role"=>"user",
                        "content"=>$query
                    ]
                ],
                //"temperature"=>"0.2"
            ];

			$ch = curl_init();
			//curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/completions'); 
			curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions'); 
			
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($bodyText));



			$headers = array();
			$headers[] = 'Content-Type: application/json';
			$headers[] = 'Authorization: Bearer ' . $key;
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$response = curl_exec($ch);
			
			if (curl_errno($ch)) {
			    echo 'Error:' . curl_error($ch);
			}

			curl_close($ch);

			$response = json_decode($response);
			#debug($response);exit;
			$answer = '';

			if (isset($response->choices)
				&& isset($response->choices[0])
				&& isset($response->choices[0]->message)) {
				$answer = str_replace('\n', '', $response->choices[0]->message->content);
			}

			$this->ChatGptLog->save([
				'user_id'  => $this->Auth->user('id'),
				'question' => isset($query) ? $query : '',
				'answer'   => isset($answer) ? $answer : '',
			]);


			if ($answer != '') {
				echo $answer;
				exit;
			} else {
				echo "Something went wrong, Please try again later!";
				exit;
			}
		}
	}

// 	public function updateEpenData(){
// 		$this->autoRender = false;
// 		$this->uses=array('Note','Patient');
// 		//$this->Patient->notesadd()
	
// 		if($this->request->data['Note']['note_id']){
// 			$this->Note->updateAll(array('epen_data'=>'"'.$this->request->data['Note']['epen'].'"'),array('id'=>$this->request->data['Note']['note_id']));
// 			return true ;
// 		}else{
// 			return false;
// 		}
// 		exit;
// 	}


// 	function printEpenNotes($patient_id=null,$noteId){
        
//         //$this->layout ='print' ;
//       $this->uses=array('Note','Patient');
//         $this->patient_info($patient_id);// For element print patient info
//         $printEpenData = $this->Note->find('first',array('fields'=>array('Note.epen_data'),'conditions'=>array('Note.id'=>$noteId)));
//         $this->layout = 'print_without_header' ;
//         $this->set(array('printEpenData'=>$printEpenData));
         
// 	}


public function updateEpenData(){
		$this->autoRender = false;
		$this->uses = array('Note', 'Patient');
	
		if (!empty($this->request->data['Note']['note_id'])) {
			// Sanitize and escape HTML content properly before updating
			$epenData = h($this->request->data['Note']['epen']); // Prevent XSS but keep necessary tags
			$noteId = intval($this->request->data['Note']['note_id']); // Ensure integer ID
	
			$this->Note->updateAll(
				array('epen_data' => "'" . addslashes($epenData) . "'"),
				array('id' => $noteId)
			);
			return json_encode(['status' => 'success']);
		} else {
			return json_encode(['status' => 'error', 'message' => 'Invalid Note ID']);
		}
	}


public function printEpenNotes($patient_id = null, $noteId) {
		$this->uses = array(
			'Note', 'Patient', 'Appointment', 'ServiceCategory', 'NewCropAllergies', 
			'TemplateTypeContent', 'Template', 'Widget', 'Language', 
			'TemplateSubCategories', 'NoteTemplate', 'LabManager', 'RadiologyTestOrder', 
			'Diagnosis', 'PatientsTrackReport', 'Person', 'NoteDiagnosis', 'LabManager', 
			'VisitType', 'User', 'TariffList', 'OptAppointment', 'ServiceBill', 'Billing'
		);
	
		// Fetch patient information
		$this->patient_info($patient_id);
	
		// Fetch Note data including SOAP note fields
		$printEpenData = $this->Note->find('first', array(
			'fields' => array('Note.epen_data', 'Note.subject', 'Note.object', 'Note.plan'),
			'conditions' => array('Note.id' => $noteId)
		));
	
		// Prepare data for printing
		$historyComplaints = isset($printEpenData['Note']['subject']) ? $printEpenData['Note']['subject'] : '';
		$onExamination = isset($printEpenData['Note']['object']) ? strip_tags($printEpenData['Note']['object']) : '';
		$investigation = isset($printEpenData['Note']['plan']) ? strip_tags($printEpenData['Note']['plan']) : '';
	
		// Set layout for printing
		$this->layout = 'print_without_header';
	
		// Pass data to the view
		$this->set(compact('historyComplaints', 'onExamination', 'investigation', 'printEpenData'));
	}
	
	
} 

?>