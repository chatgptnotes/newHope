<?php

/*
 * AppController file

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
App::uses('AutoCompletesController', 'Controller');
class AppController extends  Controller {

	public $viewClass = 'Theme';
	public $theme = 'Black';
	public $name = 'Users';
	public $uses = array('User');
	public $helpers = array('Html','Form', 'Js','Session','Navigation','DateFormat', 'WorldTime');
	public $components = array('RequestHandler','Email','Auth','Session','Acl','DateFormat','AclFilter',"Menu",'DebugKit.Toolbar');
	public $patient_details ='';
	public $autoCompleteComponentLoader = array(
			'default'=>array('autocompleteForService','autocompleteForPatient'),
			'session'=> array(''),
			'date'=> array(''),
			'dateSession'=> array('lab_dashboard'),
			'exceptionsForAjaxMenu'=>array('loadPermissions')
	);
	public $autoCompleteHelperLoader = array(
			'default'=>array('autocompleteForService','autocompleteForPatient'),
			'session'=> array(''),
			'date'=> array(''),
			'dateSession'=> array('lab_dashboard'),
			'exceptionsForAjaxMenu'=>array('loadPermissions')
	);
	#public $exceptionForPermissions = array('Billings'=>array('multiplePaymentModeIpd'));
	
	public function afterFilter() {
		/**
		 * @author Pawan Meshram
		 */
		if ($this->request->is('ajax') && $this->Auth->user()) {
			return;
		}
		/*if(AuthComponent::user('id') && $this->Session->read('role') != "superadmin") {
			$this->uses = array('AuditLogStatus', 'AuditLogPermission','Audit' ,'Patient', 'Person');
			$getAuditLogStatus = $this->AuditLogStatus->find('first', array('conditions' => array('AuditLogStatus.location_id' => $this->Session->read('locationid'))));

			if($getAuditLogStatus['AuditLogStatus']['audit_log_status'] == 1) { //condi uncommented by pankaj w as we do not required this for indian version .


			$getAuditLogUserList = $this->AuditLogPermission->find('list', array('fields' => array('model'), 'conditions' => array('AuditLogPermission.user_id' => $this->Session->read('userid'),
					'AuditLogPermission.is_deleted' => 0, 'AuditLogPermission.status' => 0)));
			$listModule = Configure::read('auditModel');

			foreach($listModule as $listModuleVal) {
				if(in_array($listModuleVal, $getAuditLogUserList)) {
					$this->loadModel($listModuleVal);
					$this->$listModuleVal->Behaviors->disable('Auditable');
				} else {
					// for view and print functionality //
					if($this->params['controller'] == "patients" &&  $listModuleVal == "Patient" && ($this->params['action'] == "patient_information" || $this->params['action'] == "qr_card" || $this->params['action'] == "opd_patient_detail_print")) {
						if($this->params['action'] == "patient_information") {
							$this->request->data['Audit']['event'] = 'VIEW';
						}
						if($this->params['action'] == "qr_card" || $this->params['action'] == "opd_patient_detail_print") {
							$this->request->data['Audit']['event'] = 'PRINT';
						}
						$getAllPatientDetails = $this->Patient->read(null,$this->params['pass'][0]);
						$this->request->data['Audit']['model'] = 'Patient';
						$this->request->data['Audit']['entity_id'] = $this->params['pass'][0];
						$this->request->data['Audit']['json_object'] = json_encode($getAllPatientDetails);
						$this->request->data['Audit']['source_id'] = $this->Session->read('userid');
						$this->request->data['Audit']['patient_id'] = $getAllPatientDetails['Patient']['patient_id'];
						$this->Audit->save($this->request->data);
					}
					if($this->params['controller'] == "persons" &&  $listModuleVal == "Person" && ($this->params['action'] == "patient_information" || $this->params['action'] == "qr_card")) {
						if($this->params['action'] == "patient_information") {
							$this->request->data['Audit']['event'] = 'VIEW';
						}
						if($this->params['action'] == "qr_card") {
							$this->request->data['Audit']['event'] = 'PRINT';
						}
						$getAllPersonDetails = $this->Person->read(null,$this->params['pass'][0]);
						$this->request->data['Audit']['model'] = 'Person';
						$this->request->data['Audit']['entity_id'] = $this->params['pass'][0];
						$this->request->data['Audit']['json_object'] = json_encode($getAllPersonDetails);
						$this->request->data['Audit']['source_id'] = $this->Session->read('userid');
						$this->request->data['Audit']['patient_id'] = $getAllPersonDetails['Person']['patient_uid'];
						//$this->Audit->save($this->request->data);
					}
				}
			}
			}
		}*/
	}


	/**
	 * authentication login
	 *
	 */
	public function beforeFilter() {//pr(App::paths());;exit;
		$filePresent = true;
		/**
		 * @author Pawan Meshram
		 */
		 if ($this->request->is('ajax') && $this->Auth->user()) {
		 	return;
		} 
		
		//End Pawan Meshram 
		$dateFormat = $this->Session->read('dateformat')  ;
	 
		if(!empty($dateFormat)){//added by pankaj to avoid blank sesion value in date format
			Configure :: write('date_format_us', $this->Session->read('dateformat'));
			Configure :: write('date_format', $this->Session->read('dateformat'));
			$this->redirect_to_last_request();
			$timeZone = $this->DateFormat->getTimeZones($this->Session->read('timezone')) ;
			$timeZone = (!$timeZone)?'UTC':$timeZone ;
			$this->setBackUrl(); // Do not delete //Pawan
		}
		
		date_default_timezone_set("Asia/Kolkata");//user's time zone //added by pankaj as indian website we do not need any other timezone
		//date_default_timezone_set("UTC");	//SYSTEM's time 
		$current_url = explode('/',$this->request->url);
		if($this->Session->read('role') != "superadmin" && $current_url[0] == "superadmin")
		{
			$this->redirect(array("action" => $current_url[1],"controller" =>$this->request->url->params['controller'],
					"admin" => true));
		}

		//set cache false for superadmin (due to seperate database configuration)
		$currentRole = $this->Session->read('role') ;
		$userid= $this->Session->read('Auth.User.id');
			
		//BOF pankaj for linked modules
		if($userid && strtolower($currentRole) != 'superadmin'){
			$this->linkedModules();
			if($this->params->controller == 'Landings'){
				$this->Auth->allow("index");
			}
		}
		//EOF pankaj

		$this->Auth->allow('display','login','logout', 'index','changeConfig','changeHospitalMode','testcomplete');
		//$this->AclFilter->auth(); //for timeout login 5 march pankaj w/pawan m //Pawan+Pankaj (Landing action is added as patient login goes to infinite loop)
			
		if ($this->request->data['User']['logintype']=='Patient') {
			$this->Auth->userModel = 'Person';
			$this->Auth->allow("common");
		}
			
		//BOF pankaj
		/*if($this->params->controller=='Landings' && $this->params->action != 'index'){ //please do not remove 
			$hasPermission = trim($this->Session->read('hasPermissions')) ;			 
			if(!$hasPermission){ 
				$this->Session->write('hasPermissions','yes') ;  
			} 
		} */ 
		 
		//for location change
		if($this->params->action == 'changeUserLocation'){ //for location change reset permissions		
			$this->Session->delete('hasPermissions') ;  
		}
		//EOF pankaj



		//BOF pankaj M
			
		if(strtolower($this->params->controller) != 'patients' && (strtolower($this->params->controller) != 'users' && strtolower($this->params->action) != 'login' && $this->params->controller != 'Landings')){
	   
			$this->Session->write('isNewcropCalledOnce',"") ;
				
		}
		//EOF pankaj M
		
		//only valide for kanpur globus instance
		if ($this->params->action == 'add' && strtolower($this->params->controller) == 'patients' && $this->params->query['type']=='IPD' && !empty($this->params->query['patient_id']) && $this->Session->read('website.instance')=='kanpur'){
			 
			Cache::clear();
			clearCache();
			$this->disableCache();
		
			$this->Session->write('location_name',Configure :: read('location_name'));
			$this->Session->write('locationid',Configure :: read('location_id'));
		}
		//EOF pankaj M


		//BOF notification
		if(($userid && $this->Session->read('role') != "superadmin"))
			$this->notification();
		//EOF notification
		
		if($this->params->action == "purchase_receipt"){	//by swapnil 
			Cache::clear(true);
			clearCache();
			$this->disableCache();
		}
		
		
		//added by pankaj
		if(strtolower($this->params->controller)==strtolower('pharmacy') && (!$this->request->isAjax)){
			//$this->expiryProductList();
                    $this->reorderProductList();
		}
		
		 
	}


	/**
	 function :auotcomplete
	 @purpose : ajax auto fill with the available options.
	 @params : field:single searching field
	 @params : type=>date,datetime (need to convert into DB format)
	 @params : is_deleted=>any string to avoid filter of is_deleted field
	 @params : location=>any string to avoid filter on location_id
	 @params : $argConditions=>string like "admission_type=OPD&admission_id=xyz"
	 @params : $group=>array('name','id')
	 */

	function autocomplete($model=null,$field=null,$type=null,$is_deleted=null,$location=null,$argConditions=null,$group=array()){
		$location_id = $this->Session->read('locationid');
		$this->layout = "ajax";
		$this->loadModel($model);
		$conditions =array();
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
		//converting date from local to DB format.
		if($type=="date"){
			$searchKey = $this->DateFormat->formatDate2STD($this->params->query['q'],Configure::read('date_format'));
		}elseif($type=="datetime"){  //converting datetime from local to DB format.
			$searchKey = $this->DateFormat->formatDate2STD($this->params->query['q'],Configure::read('date_format'),true);
		}
		//filter deleted items
		if(empty($is_deleted) || $is_deleted=='null'):
		$conditions['is_deleted'] = 0 ;
		endif ;
		if(($model =='Drug') || ($model =='icd') || ($model =='SnomedMappingMaster') || (!empty($location) && $location != "null")){
		}else{
			$conditions['location_id'] = $location_id ;
		}
		if($model =='OtItem'){
			$conditions['OtItem.ot_item_category_id'] = $this->params->query['category'];
		}
		if($model =='Patient'){
			//$conditions['Patient.is_discharge'] = '0';
			$conditions['Patient.is_deleted'] = '0';
		}
		if($model =='PharmacyItem'){
			// $conditions["PharmacyItem.supplier_id <>"] ="";
			$conditions["PharmacyItem.is_deleted"] ='0';
			if(isset($this->params->query['supplierID'])){
				//$conditions["PharmacyItem.supplier_id"] = $this->params->query['supplierID'];
			}
		}
		if($model =='User'){
			$conditions["User.username <>"] ="admin";
			$conditions["User.username !="] ="superadmin";
		}
		/**/
		if(strpos($field,"CONCAT" ) !== false ){
			$conditions['trim('.$field." ) like"] = $searchKey."%";
			$patientArray = $this->$model->find('all', array('fields'=> array('id', $field." as value"),'conditions'=>$conditions,'group'=>$group,'order'=>array("$field ASC")));
		}else{
			if($model =='NoteTemplate'){
				$conditionsStringOR .=$model.".is_deleted !=1 AND ( ";
				$conditionsStringOR .=$model.".".$field. " LIKE \"".$searchKey."%\" OR ";
				$conditionsStringOR .=$model.".search_keywords". " LIKE \"".$searchKey."%\")";
				$conditions=$conditionsStringOR;
				$patientArray = $this->$model->find('all', array('fields'=> array('id', $field,'search_keywords'),
					'conditions'=>$conditions,'group'=>$group,'order'=>array("$field ASC")));
				/*$log = $this->$model->getDataSource()->getLog(false, false);
				debug($log);exit;*/
			}else{
				$conditions['trim('.$model.".".$field.") like"] = $searchKey."%";
				if($model =='SmartPhrase'){
					unset($conditions['location_id']);
				}
				$patientArray = $this->$model->find('list', array('fields'=> array('id', $field),'conditions'=>$conditions,'group'=>$group,'order'=>array("$field ASC")));
			}		
		}
		//debug(conditions);exit;
		foreach ($patientArray as $key=>$value) {
			//converting date from local to DB format.
			if($type=="date"){
				$value = $this->DateFormat->formatDate2Local($value,Configure::read('date_format'));
			}elseif($type=="datetime"){  //converting datetime from local to DB format.
				$value = $this->DateFormat->formatDate2Local($value,Configure::read('date_format'),true);
			}
			if($model =='NoteTemplate'){
				if(!empty($value['NoteTemplate']['search_keywords'])){
					$valueSet=$value['NoteTemplate']['template_name']." (".$value['NoteTemplate']['search_keywords'].")";
					echo "$valueSet|$key\n";
				}else{
					$valueSet=$value['NoteTemplate']['template_name'];
					echo "$valueSet|$key\n";
				}
				
			}else{
				if(strpos($field,"CONCAT" ) !== false ){
					echo $value[0]['value']."|".$value['Person']['id'] ."\n" ;
				}else{
					echo "$value|$key\n";
				}
			}
		}
		exit;//dont remove this

	}
	/**
	 * testcomplete Autocomplete Function
	 * @param string $model
	 * @param string $fieldOne
	 * @param string $fieldTwo
	 * @param string $argConditions
	 * @param string $location
	 * @return array $group default value ('null')
	 * @author Gaurav Chauriya
	 */
	public function testcomplete($model=null,$fieldOne=null,$fieldTwo=null,$argConditions=null,$group=array(),$location = null){
		$this->layout = "ajax";
		$this->loadModel($model);
		if(empty($this->Session->read('db_name'))){
			App::import('Vendor', 'DrmhopeDB');
			$db_connection = new DrmhopeDB('db_hope');
			$db_connection->makeConnection($this->$model);
		}
		$conditions =array();
		if(!empty($argConditions)){
			if(strpos($argConditions, "&")){
				$allCondition = explode('&',$argConditions);
				foreach($allCondition as $cond){
					if(!empty($cond)){
						$condPara = explode('=',$cond);
						if(!empty($condPara[0]) && (!empty($condPara[1])||$condPara[0]==0)){
							$pos = strpos($condPara[0], '<>');
							if($pos !== false){
								$condPara[0] = str_replace("<>", "", $condPara[0]);
								$str = "`$condPara[0]` <> \"$condPara[1]\"";
								array_push($conditions,$str);
							}else{
								$conditions[$condPara[0]] = $condPara[1];
							}
						}
					}
				}
			}else{
				$condPara = explode('=',$argConditions);
				$condPara[0] = str_replace('<>', ' !=', $condPara[0]);
				if(isset($condPara[0]) && isset($condPara[1])){
					$conditions["$model.$condPara[0]"] = $condPara[1];
				}
			}
		}else{
			$conditions =array();
		}
		
		if(($model != 'City') && ($model != 'State')){ 
			if(($model != 'Ucums')){
				if(empty($location) || $location == null || $location ==''){
					$conditions[$model.".location_id"] = $this->Session->read('locationid');
				}
			}
		}
		
		if($this->$model->hasField('is_deleted')){
			$conditions[$model.".is_deleted"] = 0;
		}
		
		if($this->$model->hasField('is_active')){
			$conditions[$model.".is_active"] = 1;
		}
		
		$searchKey = $this->params->query['q'] ;
		$conditions[$model.".".$fieldTwo." like "] = "%".$searchKey."%";
		
		$selectedModels = array('DoctorProfile','User','AllergyMaster');
		
		if(in_array($model,$selectedModels))
			$conditions[$model.".".$fieldTwo." like"] = $searchKey."%";
		
		/* /* if($model == 'Laboratory'){
			unset($conditions['Laboratory.location_id']); 
		} * /pr($conditions);exit; */
		if($group != 'null'){
			$testArray = $this->$model->find('list', array('fields'=> array($fieldOne, $fieldTwo),'conditions'=>$conditions,'group'=>$group,'order'=>array("$fieldTwo ASC")));
		}else{
			$testArray = $this->$model->find('list', array('fields'=> array($fieldOne, $fieldTwo),'conditions'=>$conditions,'order'=>array("$fieldTwo ASC")));
		}
		foreach ($testArray as $key=>$value) {
			echo ucwords(strtolower("$value   $key|$key\n"));
		}
		exit;
	}
	
	
	
/**
	 * testcomplete Autocomplete Function
	 * @param string $model
	 * @param string $fieldOne
	 * @param string $fieldTwo
	 * @param string $argConditions
	 * @param string $location
	 * @return array $group default value ('null')
	 * @author Gaurav Chauriya
	 */
	public function advanceTwoFieldsAutocomplete($model=null,$fieldOne=null,$fieldTwo=null,$argConditions=null,$group=array(),$location = null){
		
		$this->layout = "ajax";
		$this->loadModel($model);
		$conditions =array();
		if(!empty($argConditions)){
			if(strpos($argConditions, "&")){
				$allCondition = explode('&',$argConditions);
				foreach($allCondition as $cond){
					if(!empty($cond)){
						$condPara = explode('=',$cond);
						if(!empty($condPara[0]) && (!empty($condPara[1])||$condPara[0]==0)){
							$pos = strpos($condPara[0], '<>');
							if($pos !== false){
								$condPara[0] = str_replace("<>", "", $condPara[0]);
								$str = "`$condPara[0]` <> \"$condPara[1]\"";
								array_push($conditions,$str);
							}else{
								$conditions[$condPara[0]] = $condPara[1];
							}
						}
					}
				}
			}else{
				$condPara = explode('=',$argConditions);
				$condPara[0] = str_replace('<>', ' !=', $condPara[0]);
				if(isset($condPara[0]) && isset($condPara[1])){
					$conditions["$model.$condPara[0]"] = $condPara[1];
				}
			}
		}else{
			$conditions =array();
		}
		/* condition by Mrunal Matey for Kanpur*/
		if($this->Session->read('website.instance')=='kanpur'){ 
			$conditions[$model.".location_id"] = array(1,22);		// 1, 22 locations hanving doctors
		}else {
			
			if(($model != 'City') && ($model != 'State')){ 
				if(($model != 'Ucums')){
					if(empty($location) || $location == null || $location ==''){
						$conditions[$model.".location_id"] = $this->Session->read('locationid');
					}
				}
			}
		}
		
		if($this->$model->hasField('is_deleted')){
			$conditions[$model.".is_deleted"] = 0;
		}
		
		if($this->$model->hasField('is_active')){
			$conditions[$model.".is_active"] = 1;
		}
		
		$searchKey = $this->params->query['term'] ;
		
		$conditions[$model.".".$fieldTwo." like "] = "%".$searchKey."%";
		
		$selectedModels = array('DoctorProfile','User','AllergyMaster');
		
		if(in_array($model,$selectedModels))
			$conditions[$model.".".$fieldTwo." like"] = $searchKey."%";
		
		/* /* if($model == 'Laboratory'){
			unset($conditions['Laboratory.location_id']); 
		} * /pr($conditions);exit; */
		if($group != 'null'){
			$testArray = $this->$model->find('list', array('fields'=> array($fieldOne, $fieldTwo),'conditions'=>$conditions,'group'=>$group,'order'=>array("$fieldTwo ASC")));
		}else{
			$testArray = $this->$model->find('list', array('fields'=> array($fieldOne, $fieldTwo),'conditions'=>$conditions,'order'=>array("$fieldTwo ASC")));
		}
		foreach ($testArray as $key=>$value) {
			//echo "$value   $key|$key\n";
			$returnArray[] = array('id'=>$key,'value'=>$value) ;
		}
		
		echo json_encode($returnArray) ;
		exit;
	}
	
	

	//common function to set patient information for element "patient_infomartion"

	/* function patient_info($patient_id=null){

	$this->loadModel('Corporate');
	$this->loadModel('Ward');
	$this->loadModel('Room');
	$this->loadModel('Bed');
	$this->loadModel('InsuranceCompany');
	$this->loadModel('Diagnosis');
	$this->loadModel('Person');
	$this->loadModel('Patient');
	$this->loadModel('Consultant');
	$this->loadModel('User');

	$this->Patient->unBindModel(array( 'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));

	$this->Patient->bindModel(array(
			'belongsTo' => array(
					'Initial' =>array( 'foreignKey'=>'initial_id'),
					'Consultant' =>array('foreignKey'=>'consultant_treatment'),
					'TariffStandard' =>array('foreignKey'=>'tariff_standard_id')
			)));

	$patient_details  = $this->Patient->getPatientDetailsByIDWithTariff($patient_id);
	$this->patient_details = $patient_details  ;

	$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($patient_id);


	if($patient_details['Person']['dob'] == '0000-00-00' || $patient_details['Person']['dob'] == ''){
	$age = "";
	}else{
	$date1 = new DateTime($patient_details['Person']['dob']);
	$date2 = new DateTime();
	$interval = $date1->diff($date2);
	$date1_explode = explode("-",$patient_details['Person']['dob']);
	$person_age_year =  $interval->y . " Year(s)";
	$personn_age_month =  $interval->m . " Month(s)";
	$person_age_day = $interval->d . " Day(s)";
	if($person_age_year == 0 && $personn_age_month > 0){
	$age = $interval->m . " Month(s)";
	}
	else if($person_age_year == 0 && $personn_age_month == 0 && $person_age_day > -1){
	$age = $interval->d . " " + 1 . " Day(s)";
	}
	else{
	$age = $interval->y . " Year(s)";
	}
	}

	$this->set("age",$age);
	//$formatted_address = $this->requestAction("/patients/setAddressFormat",array('pass' => array($UIDpatient_details['Person'])));
	$formatted_address = $this->setAddressFormat($UIDpatient_details['Person']);


	if($patient_details['Patient']['admission_type'] == 'IPD'){
	$this->Ward->recursive = -1;
	$this->Room->recursive = -1;
	$ward_details = $this->Ward->find('first',array('conditions'=>array('Ward.id'=>$patient_details['Patient']['ward_id'])));
	$room_details = $this->Room->find('first',array('conditions'=>array('Room.id'=>$patient_details['Patient']['room_id'])));
	$bed_details = $this->Bed->find('first',array('conditions'=>array('Bed.id'=>$patient_details['Patient']['bed_id'])));
	$this->set(array('ward_details'=>$ward_details,'room_details'=>$room_details,'bed_details'=>$bed_details));
	}
	$diagnosis = $this->Diagnosis->find('first',array('foreignKey'=>false,'conditions'=>array('Diagnosis.patient_id'=>$patient_id),
	'fields'=>array('Diagnosis.final_diagnosis')));
	$this->set(array('diagnosis'=>$diagnosis['Diagnosis']['final_diagnosis'],'photo' => $UIDpatient_details['Person']['photo'],
	'address'=>$formatted_address,'patient'=>$patient_details,
	'patient_id'=>$patient_id,'treating_consultant'=>$this->User->getDoctorByID($patient_details['Patient']['doctor_id']),
	'sex'=>$UIDpatient_details['Person']['sex'],'blood_group'=>$UIDpatient_details['Person']['blood_group']));

	} */



	/**

	@Name		 : getStates

	@created for : To get states as per the country selected

	@created by  : ANAND

	@created on  : 3/28/2012

	@modified on :

	**/



	public function get_state_city(){

		$this->uses = array('Country','State','City');


		if($this->params['isAjax']) {

			$reference_id = $this->params->query['reference_id'];
			//debug($reference_id);
			$reference = $this->params['named']['reference'];//echo $reference;exit;

			$controllertype = $this->params['named']['controllertype'];

			if(($reference == 'State' || $reference == 'guar_state' || $reference == 'gau_state')  AND  !empty($reference_id)){
				if($reference_id == '2' || $reference_id == 'USA'){
					$reference_id = '2';
					$data = $this->State->find('list',array('fields'=>array('id','name'),'conditions'=>array('State.country_id'=>$reference_id),'order' => array('State.name')));
				}
				else{
					if(!is_numeric($reference_id)){
						$ref=$this->Country->find('first',array('fields'=>array('id'),'conditions'=>array('name'=>$reference_id)));
						$reference_id = $ref['Country']['id'];
					}
					$data = $this->State->find('list',array('fields'=>array('id','name'),'conditions'=>array('State.country_id'=>$reference_id),'order' => array('State.name')));
				}
			} elseif($reference == 'State1' AND  !empty($reference_id)) {
				if($reference_id == '2'){
					$data = $this->State->find('list',array('fields'=>array('id','name'),'conditions'=>array('State.country_id'=>$reference_id),'order' => array('State.name')));
				}
				else{
					$data = $this->State->find('list',array('fields'=>array('id','name'),'conditions'=>array('State.country_id'=>$reference_id),'order' => array('State.name')));
				}
					
			}else {

				$data = $this->City->find('list',array('conditions'=>array('City.state_id'=>$reference_id),'order' => array('City.name')));

				//pr($data);exit;

			}


			$this->set('reference_id',$reference_id);
			$this->set(compact('data'));

			$this->set('dropdown',$reference);

			$this->set('controllertype',$controllertype);

			$this->render('ajaxget_state_city');

		}

	}





	//function to set last visited url before session get expired automatically.

	function redirect_to_last_request(){

		//BOF pankaj
		//redirect to last page if the session expire .
		$this->Session->delete('Config.redirect');

		if(!$this->Session->check('Auth.User') && !$this->Session->check('Config.redirect')){

			if(!($this->request->is('ajax'))){
				//$this->Session->write('Config.redirect',$this->getCurrentUrl()); by pankaj

			}else{

				echo "Logging off....";

			}

		}else if($this->params->params['action']=='logout'){

			$this->Session->delete('Config.redirect');

		}
		if(isset($_GET['website']) && $_GET['website']=='error')
			$this->DateFormat->readDate(); //To maintain an error log
		//BOF pankaj

		if (!$this->Session->check('Auth.User') && $this->request->is('ajax')) {

			//redirect if session expired

			echo "<script>window.location.reload();</script>";

			$this->redirect('users/login') ;
			exit;

		}else if(!$this->Session->check('Auth.User') && $this->params->controller != 'users' && $this->params->action != 'login'){
			$this->redirect("/") ;
		}
		//check for config.php permission
		//To run encryption file writable file permission is required
		if (!is_writable("../Config/config.php")) {
			//echo __("Sor".""."ry , config".".php needs writable"." "."permi".""."ssion to "." "."run this appli".""."cation. ");
			//exit;
		}

	}



	function getCurrentUrl(){


		$str = env('REQUEST_URI');

		$url = $this->params->url ;

		$controller = $this->params->params['controller'] ;

		$action = $this->params->params['action'] ;

		$named = $this->params->params['named'];

		$pass = $this->params->params['pass'];

		$query = $this->params->query ;

		$arr =array();



		foreach($named as $key=>$value){

			$arr[$key] = $value ;

		}

		$arr['controller']=$controller ;

		$arr['action']=$action ;

		foreach($pass as $key=>$value){

			$arr[] = $value ;

		}

		$arr['?'] = $query;


		return  Router::url($arr, true);



	}



	//BOF print patient info header

	function print_patient_info($patient_id=null){

		$this->loadModel('Patient');

		$this->loadModel('DoctorProfile');

		$this->loadModel('Person');

		$this->loadModel('User');

		$this->Patient->bindModel(array(

				'belongsTo' => array(

						//'Initial' =>array( 'foreignKey'=>'initial_id'),

						'Consultant' =>array('foreignKey'=>'consultant_treatment'),

						'TariffStandard'=>array('foreignKey'=>'tariff_standard_id')),

				'hasOne'=>array('FinalBilling'=>array('foreignKey'=>'patient_id'))));

		$patient_details  = $this->Patient->getPatientDetailsByIDWithTariff($patient_id,'bill_number');//sent 2nd arg for bill number
		
		$treatingConsultant = $this->User->getDoctorByID($patient_details['Patient']['doctor_id']) ;
		
		$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($patient_id);
		$patientAge= $this->getAge($UIDpatient_details['Person']['dob']);
		$this->set('age',$patientAge);
		$this->set('sex',$UIDpatient_details['Person']['sex']);
		$this->set('dob',$UIDpatient_details['Person']['dob']);
		$formatted_address = $this->setAddressFormat($UIDpatient_details['Person']);

		$this->set(array('address'=>$formatted_address,'patient'=>$patient_details,'treating_consultant'=>$treatingConsultant));

	}



	//function returns formatted patient address

	public function setAddressFormat($patient_data=array()){

		$format = '';


		if(!empty($patient_data['plot_no']))

			$format .= $patient_data['plot_no']."";

		if(!empty($patient_data['plot_no']))

			$format .= ',';

		if(!empty($patient_data['landmark']))

			$format .= ucwords($patient_data['landmark']);



		if(!empty($patient_data['plot_no']) || !empty($patient_data['landmark']))

			$format .= "," ;



		if(!empty($patient_data['city']))

			$format .= ucfirst($patient_data['city']);

		if(!empty($patient_data['city']))

			$format .= ',';

		if(!empty($patient_data['taluka']))

			$format .= ucfirst($patient_data['taluka']);



		if((!empty($patient_data['city']) && !empty($patient_data['taluka'])) && (!empty($patient_data['district']) || !empty($patient_data['state'])))

			$format .= "," ;



		if(!empty($patient_data['district']))

			$format .= ucfirst($patient_data['district']);



		if(!empty($patient_data['district']) && !empty($patient_data['state']))

			$format .= "," ;



		if(!empty($patient_data['state']))

			$format .= ucfirst($patient_data['state']);



		if(!empty($patient_data['state']) && !empty($patient_data['pin_code']))

			$format .= "-" ;



		if(!empty($patient_data['pin_code']))

			$format .= $patient_data['pin_code'];



		return $format ;

	}

	public function setCurrencySession($country_id){
		if(!$country_id) return false ;
		$this->loadModel('Currency') ;
		$currArr = $this->Currency->getCurrencyByID($country_id);
		$this->Session->write('Currency',$currArr['Currency']);
	}
	public function setMedication($patient_id=null){
		$this->set('title_for_layout', __('-Select IPD code.', true));
		$this->layout = false ;

		$getdata= $this->request->query['illness'];
		$port = "42011";

		//-----------------------socket connection-----------------------------------------
		$host = "sandbox.e-imo.com";
		$timeout = 15;  //timeout in seconds
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)
		or die("Unable to create socket\n");
		$result=socket_connect($socket, $host, $port);
		if ($result === false) {
			echo "socket_connect() failed.\nReason: ($result) " .
			socket_strerror(socket_last_error($socket)) . "\n";
		}
		$msg = "search^10|||1^".$getdata."^e0695fe74f6466d0^" . "\r\n";

		if (!socket_write($socket, $msg, strlen($msg))) {
			echo socket_last_error($socket);
		}

		while ($bytes=socket_read($socket, 100000)) {
			if ($bytes === false) {
				echo socket_last_error($socket);
				break;
			}
			if (strpos($bytes, "\r\n") != false) break;
		}
		socket_close($socket);
		$xmlString=$bytes;
		$xmldata = simplexml_load_string($xmlString);
		$this->set('xmldata',$xmldata);
			
		exit;
	}

	/*
	 *
	* this function is used to show page not found error
	*
	*/
	/*function _setErrorLayout() {
		if ($this->response->statusCode() == 404) {
	$this->layout = '404';
	}

	if($this->request->url == "") {
	if(AuthComponent::user('id')) {
	$this->redirect("/users/common");
	}
	}
	}*/
	function beforeRender () {
		/*---for traversing view to last page */
		$this->set('moveBack', $this->referer());
		if(!empty($this->patient_details)){
			$patient_id = $this->patient_details['Patient']['id'] ;

			if($patient_id !="" ){
					
				//if($this->request->params['controller'] == 'patients' && $this->request->params['action'] == 'patient_information'){
				$this->loadModel('Note');
				$data = $this->paginate = array(
						'limit' => Configure::read('number_of_rows'),
						'order' => array('Note.id' => 'desc'),
						'fields'=> array('Note.id', 'Note.note', 'Note.note_type', 'Note.created_by', 'Note.note_date', 'Note.sign_note', 'Note.create_time'),
						'conditions'=>array('Note.patient_id'=>$patient_id,'Note.note_type NOT'=>array('ward','extra note')),
						'group' => 'Note.note_date'
				);
					
				$this->set('datapost',$this->paginate('Note'));
				$this->set('notePatientId',$patient_id);
				//}
			}
		}
		
		//overwrite session variable location id for sending to globus hospital
		
		if($this->params->query['type']=='IPD' && !empty($this->params->query['patient_id']) && $this->Session->read('website.instance')=='kanpur'){ //please do not remove
			$this->Session->write('real_location_name',$this->Session->read('location_name'));
			$this->Session->write('real_locationid',$this->Session->read('locationid'));
			$this->Session->write('location_name',Configure :: read('location_name'));
			$this->Session->write('locationid',Configure :: read('location_id'));
				
		}else if( $this->Session->read('real_location_name') && $this->Session->read('real_locationid') && $this->Session->read('website.instance')=='kanpur'){
				
			$this->Session->write('location_name',$this->Session->read('real_location_name'));
			$this->Session->write('locationid',$this->Session->read('real_locationid'));
			$this->Session->delete('real_location_name');
			$this->Session->delete('real_locationid');
		}
	}

	function smart_phrase() {
		$this->uses = array('SmartPhrase');

	}
	/**

	function :auotcomplete

	@purpose : ajax auto fill with the available options.

	@params : field:single searching field

	@params : type=>date,datetime (need to convert into DB format)

	@params : is_deleted=>any string to avoid filter of is_deleted field

	@params : location=>any string to avoid filter on location_id

	@params : $argConditions=>string like "admission_type=OPD&admission_id=xyz"

	@params : $group=>array('name','id')

	*/

	function two_fields_autocomplete($model=null,$conditionfield=null,$dispfield=null,$type=null,$is_deleted=null,$location=null,$argConditions=null,$group=array()){


		$location_id = $this->Session->read('locationid');

		$this->layout = "ajax";

		$this->loadModel($model);

		$conditions =array();

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

		//converting date from local to DB format.

		if($type=="date"){

			$searchKey = $this->DateFormat->formatDate2STD($this->params->query['q'],Configure::read('date_format'));

		}elseif($type=="datetime"){  //converting datetime from local to DB format.

			$searchKey = $this->DateFormat->formatDate2STD($this->params->query['q'],Configure::read('date_format'),true);

		}

		//filter deleted items



		if(empty($is_deleted) || $is_deleted=='null'):

		//$conditions['is_deleted'] = 0 ;
		unset($is_deleted);
		endif ;



		if(($model =='Drug') || ($model =='icd') || (!empty($location) && $location != "null")){

		}else{
			unset($location_id);
			//$conditions['location_id'] = $location_id ;

		}
		if($model =='OtItem'){
			$conditions['OtItem.ot_item_category_id'] = $this->params->query['category'];
		}
		if($model =='Patient'){
			//$conditions['Patient.is_discharge'] = '0';
			$conditions['Patient.is_deleted'] = '0';

		}
		if($model =='PharmacyItem'){



			// $conditions["PharmacyItem.supplier_id <>"] ="";

			$conditions["PharmacyItem.is_deleted"] ='0';

			if(isset($this->params->query['supplierID'])){

				//$conditions["PharmacyItem.supplier_id"] = $this->params->query['supplierID'];

			}



		}

		if($model =='User'){



			$conditions["User.username <>"] ="admin";

			$conditions["User.username !="] ="superadmin";





		}

		$conditions['trim('.$model.".".$conditionfield.") like"] = "%".$searchKey."%";


		$patientArray = $this->$model->find('list', array('fields'=> array($conditionfield, $dispfield),'conditions'=>$conditions,'group'=>$group));



		foreach ($patientArray as $key=>$value) {

			//converting date from local to DB format.

			if($type=="date"){

				$value = $this->DateFormat->formatDate2Local($value,Configure::read('date_format'));

			}elseif($type=="datetime"){  //converting datetime from local to DB format.

				$value = $this->DateFormat->formatDate2Local($value,Configure::read('date_format'),true);

			}

			echo "$value|$key\n";

		}

		exit;//dont remove this

	}

	function getDualAutoComplete($model,$conditionfield,$dispfield){
		$this->layout = "ajax";
		$this->loadModel($model);
		$conditions['trim('.$model.".".$conditionfield.") like"] = "%".$this->params->query['q']."%";
		$smartPhrases = $this->$model->find('all', array('fields'=> array($conditionfield, $dispfield),
				'conditions'=>$conditions));

		foreach ($smartPhrases as $key=>$smartPhrase) {
			$smartPhrase[$model][$dispfield] = $bodytag = str_replace("\n", "~~~~~", $smartPhrase[$model][$dispfield]);
			echo $smartPhrase[$model][$conditionfield]."|".$smartPhrase[$model][$dispfield]."\n";

		}
		exit;//dont remove this
	}

	//-----------------gulshan---------
	function patient_info($patient_id=null){
		$this->loadModel('Corporate');
		$this->loadModel('Ward');
		$this->loadModel('Room');
		$this->loadModel('Bed');
		//$this->loadModel('InsuranceCompany');
		//$this->loadModel('Diagnosis');
		$this->loadModel('Person');
		$this->loadModel('Patient');
		$this->loadModel('Consultant');
		$this->loadModel('User');
		//$this->loadModel('Race');
		//$this->loadModel('Language');
		$this->loadModel('PatientDocument');
		$this->loadModel('State');
		$this->loadModel('Billing');

		$this->Patient->unBindModel(array( 'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));

		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment'),
						'TariffStandard' =>array('foreignKey'=>'tariff_standard_id'),
						'Person' =>array('foreignKey'=>'person_id'),
						'User' =>array('foreignKey'=>false,array('conditions'=>array('User.id' => 'Patient.doctor_id'))),
						'Billing' =>array('foreignKey'=>false,array('conditions'=>array('Billing.patient_id' => 'Patient.id')))
				)));
		$billData= $this->Billing->find('first',array('conditions'=>array('Billing.patient_id'=>$patient_id)));
		$patient_details  = $this->Patient->getPatientDetailsForElement($patient_id);
			
		//pr($patient_details);exit;
		$this->patient_details = $patient_details  ;

		//	$UIDpatient_details  = $this->Person->getPatientDetailsByPatientID($patient_id);
		$dob=$patient_details['Person']['dob'];
		$state_location_patients = $this->State->find('first', array('fields'=> array('State.state_code','State.name'),
				'conditions'=>array('State.id'=>$patient_details['Person']['state'])));
		$patientAge= $this->getAge($dob);
		$this->set("age",$patientAge);
		$this->set("patientstate",$state_location_patients['State']['state_code']);
		$this->set("patientstatename",$state_location_patients['State']['name']);//state name  -- Pooja
			
		//$formatted_address = $this->requestAction("/patients/setAddressFormat",array('pass' => array($UIDpatient_details['Person'])));
		$formatted_address = $this->setAddressFormat($patient_details['Person']);

		 
		if($patient_details['Patient']['admission_type'] == 'IPD'){
			 
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'Ward' =>array( 'foreignKey'=>false,
									'conditions'=>array('Ward.id = Patient.ward_id')),
							'Room' =>array('foreignKey'=>false,
									'conditions'=>array('Room.id = Patient.room_id')),
							'Bed' =>array('foreignKey'=>false,
									'conditions'=>array('Bed.id = Patient.bed_id')),
							'Person' =>array('foreignKey'=>false,
									'conditions'=>array('Person.id = Patient.person_id')),

					)));

			$wardInfo = $this->Patient->find('first', array('fields'=> array('Room.bed_prefix,Bed.bedno,Ward.name,Room.name,Room.room_type,
					Person.language,Person.age,Person.ethnicity,Person.race'),'conditions'=>array('Patient.id'=>$patient_id)));
			$this->set("wardInfo",$wardInfo);


		}

		//-----------------------------------Radiology Images--------------------------------------------------------------------------
		if($this->Session->read('website.instance')!='vadodara'){
		
		$radData = $patient_details['RadiologyReport'];
		for($a=0;$a<count($radData);$a++){
			$b[]='"'.$this->webroot.'uploads/'.'radiology/'.$radData[$a][file_name].'"';
			$c[]='"'.$radData[$a]['description'].'"';
		}
		$this->set('data1',$radData);
		$this->set('b',$b);
		$this->set('c',$c);
		//-----------------------------------Radiology Images--------------------------------------------------------------------------

		//---------------------------------patient Images------------------------------//

			$ptImg = $this->PatientDocument->find('all', array('fields'=> array('PatientDocument.*'),'conditions'=>array('PatientDocument.patient_id'=>$patient_id),'order' => array('PatientDocument.id DESC')));
			for($a=0;$a<count($ptImg);$a++){
				$p[]='"'.$this->webroot.'uploads/user_images/'.$ptImg[$a][PatientDocument][filename].'"';
				//$q[]='"'.$radData[$a]['description'].'"';
			}
		}
		$this->set('data2',$ptImg);
		$this->set('p',$p);
		//$this->set('c',$c);
		//---------------------------------patient Images------------------------------//



		//$data_race=$this->Race->find('list',array('fields'=>array('Race.value_code','Race.race_name')));
		//$languages=$this->Language->find('list',array('fields'=>array('Language.code','Language.language'),'conditions'=>array('id'=>$patient_details['Person']['preferred_language'])));
		//$this->set("data_race",$data_race);
		//$this->set("languages",$languages);
		/* $diagnosis = $this->Diagnosis->find('first',array('foreignKey'=>false,'conditions'=>array('Diagnosis.patient_id'=>$patient_id),
		 'fields'=>array('Diagnosis.final_diagnosis'))); */
		$this->set(array('diagnosis'=>$patient_details['Diagnosis']['final_diagnosis'],'photo' => $patient_details['Person']['photo'],
				'address'=>$formatted_address,'patient'=>$patient_details,
				'patient_id'=>$patient_id,'treating_consultant'=>$this->User->getDoctorByID($patient_details['Patient']['doctor_id']),
				'sex'=>$patient_details['Person']['sex'],'blood_group'=>$patient_details['Person']['blood_group'],'patientDetailsForView'=>$patient_details,'billData'=>$billData));
		/*
		 * Resent Patient
		* Gaurav
		*/
		/*$this->loadModel('Audit');
			$auditList = $this->Audit->find('list',array('fields'=>array('Audit.patient_id'),'conditions'=>array('source_id'=>$this->Session->read('userid')),'order'=>array('Audit.id DESC'),'limit'=>100));
		$filteredList = array_filter(array_unique($auditList));
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patientList = $this->Patient->find('all',array('fields'=>array('Patient.id','Patient.lookup_name','Patient.patient_id'),
				'conditions'=>array('Patient.patient_id'=>$filteredList,'Patient.patient_id !='=>$patient_details['Patient']['patient_id']),
				'group'=>'Patient.patient_id'));
		$this->set('patientListArray',$patientList);*/


	}

	function getAge($dob){
			
		if($dob == '0000-00-00' || $dob == ''){
			$age = "";
			
		}else{
			
			$date1 = new DateTime($dob);
			
			$date2 = new DateTime();
			$interval = $date1->diff($date2);
			
			$date1_explode = explode("-",$dob);
			$person_age_year =  $interval->y . " Year";
			$personn_age_month =  $interval->m . " Month";
			$person_age_day = $interval->d . " Day";
			if($person_age_year == 0 && $personn_age_month > 0){
				$age = $interval->m . " Month";
				
			}
			else if($person_age_year == 0 && $personn_age_month == 0 && $person_age_day > -1){
				$age = $interval->d . " " + 1 . " Day";
				
			}
			else{
				$age = $interval->y . " Year";
				
			}
		}
		
		return $age;
			
			
	}
	public function portal_header($uid=null,$id=null){
		$patient= ClassRegistry::init('Patient');
		$patient->bindModel(array('belongsTo'=>array('Initial' => array('foreignKey' =>'initial_id')),
				'belongsTo'=>array('Person' => array('foreignKey' =>'person_id')),
				'conditions'=>array('Patient.patient_id'=>$uid)));
		$dataForPotal=$patient->find('first',array(
				'fields'=>array('Patient.id','Patient.patient_id','Patient.lookup_name','Patient.admission_type','Patient.admission_id','Person.age','Person.dob','Person.first_name','Person.middle_name','Person.last_name','Person.sex','Person.mobile'),'conditions'=>array('Patient.patient_id'=>$uid)));
		return array('dataForPotal'=>$dataForPotal,'id'=>$id);
	}

	public function setBackUrl(){
		$paramsStringNamed = $paramsString = $lastParams = $lastParamsNamed = array();
		foreach($this->params->named as $key=>$value){
			$paramsStringNamed[trim($key)] = trim($value);
		}
		foreach($this->params->pass as $key=>$value){
			$paramsString[] = trim($value);
		}
		$currUrl = $this->params->controller.'/'.$this->params->action.'/'.$paramsString.$paramsStringNamed;
		if(empty($backUrl)){
			$backUrl = $currUrl;
			$lastController = $this->params->controller;
			$lastAction = $this->params->action;
			$lastParams = $paramsString;
			$lastParamsNamed = $paramsStringNamed;
			$this->set('lastBackUrl',$backUrl);
			$this->set('lastController',$this->params->controller);
			$this->set('lastAction',$this->params->action);
			$this->set('lastParams',implode(",",$paramsString));
			$this->set('lastNamedParams',implode(",",$lastParamsNamed));
		}
		//if($backUrl != $currUrl){
		$this->set('lastBackUrl',$backUrl);
		$this->set('lastController',$lastController);
		$this->set('lastAction',$lastAction);
		$this->set('lastParams',implode(",",$paramsString));
		$this->set('lastNamedParams',$lastParamsNamed);
		$backUrl = $currUrl;
		$lastController = $this->params->controller;
		$lastAction = $this->params->action;
		$lastParams = $paramsString;
		$lastParamsNamed = $paramsStringNamed;

		//}
	}

	//Aditya
	public function saveConfiguration(){
		$this->loadModel('Configuration');
		$getData=$this->Configuration->find('first',array('fields'=>array('value'),'conditions'=>array('name'=>trim($this->request->data['searchArea']))));
		$str=$getData['Configuration']['value'];
		$unSerData = unserialize($str);
		if(!empty($this->request->data['putArea'])||($this->request->data['putArea']!='Select')){
			$unSerData[$this->request->data['putArea']] = $this->request->data['putArea'];
		}
		$saveSer=serialize($unSerData);
		$chkExist=$this->Configuration->find('first',array('conditions'=>array('name'=>$this->request->data['searchArea'])));
		if(empty($chkExist)){
			$ckhStatus=$this->Configuration->save(array('name'=>$this->request->data['searchArea'],'value'=>strip_tags($saveSer)));
		}
		else{
			$newData=strip_tags($saveSer);
			$ckhStatus=$this->Configuration->updateAll(array('value'=>"'$newData'"),array('name'=>$this->request->data['searchArea']));
		}
		echo $ckhStatus;
		exit;


	}
	public function saveConfiguration1(){
		$this->loadModel('Configuration');
		$getData=$this->Configuration->find('first',array('fields'=>array('value'),'conditions'=>array('name'=>trim($this->request->data['searchArea']))));
		$str=$getData['Configuration']['value'];
		$unSerData = unserialize($str);
		if(!empty($this->request->data['putArea']) ||($this->request->data['putArea']!='Select') ){
			$unSerData[$this->request->data['putArea']] = $this->request->data['putArea'];
		}
		$saveSer=serialize($unSerData);
		$chkExist=$this->Configuration->find('first',array('conditions'=>array('name'=>$this->request->data['searchArea'])));
		if(empty($chkExist)){
			$ckhStatus=$this->Configuration->save(array('name'=>$this->request->data['searchArea'],'value'=>strip_tags($saveSer)));
		}
		else{
			$newData=strip_tags($saveSer);
			$ckhStatus=$this->Configuration->updateAll(array('value'=>"'$newData'"),array('name'=>$this->request->data['searchArea']));
		}
		echo $ckhStatus;
		exit;


	}
	public function saveConfiguration2(){

		$this->loadModel('Configuration');
		$getData=$this->Configuration->find('first',array('fields'=>array('value'),'conditions'=>array('name'=>trim($this->request->data['searchArea']))));
		$str=$getData['Configuration']['value'];
		$unSerData = unserialize($str);
		if(!empty($this->request->data['putArea'])||($this->request->data['putArea']!='Select')){
			$unSerData[$this->request->data['putArea']] = $this->request->data['putArea'];
		}
		$saveSer=serialize($unSerData);
		$chkExist=$this->Configuration->find('first',array('conditions'=>array('name'=>$this->request->data['searchArea'])));
		if(empty($chkExist)){
			$ckhStatus=$this->Configuration->save(array('name'=>$this->request->data['searchArea'],'value'=>strip_tags($saveSer)));
		}
		else{
			$newData=strip_tags($saveSer);
			$ckhStatus=$this->Configuration->updateAll(array('value'=>"'$newData'"),array('name'=>$this->request->data['searchArea']));
		}
		echo $ckhStatus;
		exit;


	}

	/**

	function :auotcomplete

	@purpose : ajax auto fill with the available options.

	@params : field: single searching field or "&" Seperated String with find field should be in second position

	@params : type=>date,datetime (need to convert into DB format)

	@params : is_deleted=>any string to avoid filter of is_deleted field

	@params : location=>any string to avoid filter on location_id

	@params : $argConditions=>string like "admission_type=OPD&admission_id=xyz"

	@params : $group=>array('name','id')

	*/

	function advance_autocomplete($model=null,$field=null,$type=null,$is_deleted=null,$location=null,$argConditions=null,$group=array()){
 
		$location_id = $this->Session->read('locationid');
		$this->layout = "ajax";
		$this->loadModel($model);
		$conditions =array();
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
				if(!empty($condPara[0]) && (!empty($condPara[1])||$condPara[0]==0)){
					$conditions[$condPara[0]] = $condPara[1];
				}
			}
		}else{
			$conditions =array();
		}
		$searchKey = $this->params->query['term'] ;
		//converting date from local to DB format.
		if($type=="date"){
			$searchKey = $this->DateFormat->formatDate2STD($this->params->query['q'],Configure::read('date_format'));
		}elseif($type=="datetime"){  //converting datetime from local to DB format.
			$searchKey = $this->DateFormat->formatDate2STD($this->params->query['q'],Configure::read('date_format'),true);
		}
		//filter deleted items

		if(empty($is_deleted) || $is_deleted=='null'):
		$conditions['is_deleted'] = 0 ;
		endif ;

		if(($model =='Drug') || ($model =='icd') || (!empty($location) && $location != "null")){
		}else{
			$conditions['location_id'] = $location_id ;
		}
		if($model =='OtItem'){
			$conditions['OtItem.ot_item_category_id'] = $this->params->query['category'];
		}
		if($model =='Patient'){
			//$conditions['Patient.is_discharge'] = '0';
			$conditions['Patient.is_deleted'] = '0';
		}
		if($model =='PharmacyItem'){
			// $conditions["PharmacyItem.supplier_id <>"] ="";
			$conditions["PharmacyItem.is_deleted"] ='0';
			if(isset($this->params->query['supplierID'])){
				//$conditions["PharmacyItem.supplier_id"] = $this->params->query['supplierID'];
			}
		}
		if($model =='User'){
			$conditions["User.username <>"] ="admin";
			$conditions["User.username !="] ="superadmin";
		}


		if(strpos($field, "&")){
			$field = explode('&',$field);
		}else{
			$field =array('id', $field);
		}
		$conditions['trim('.$model.".".$field[1].") like"] = $searchKey."%";
		$patientArray = $this->$model->find('list', array('fields'=> $field,'conditions'=>$conditions,'group'=>$group,'limit'=>Configure::read('number_of_rows')));
		$returnArray = array();
		foreach ($patientArray as $key=>$value) {
			//converting date from local to DB format.
			if($type=="date"){
				$value = $this->DateFormat->formatDate2Local($value,Configure::read('date_format'));
			}elseif($type=="datetime"){  //converting datetime from local to DB format.
				$value = $this->DateFormat->formatDate2Local($value,Configure::read('date_format'),true);
			}

			$returnArray[] = array( 'id'=>$key,
					'value'=>$value,
			) ;

		}
		ob_clean();//Added by Pawan (Do not delete it) Its added to clean the output buffer before this
		echo json_encode($returnArray);
		exit;//dont remove this

	}

	/**
	 * autocompleteForPatientNameAndDob
	 * @param Boolean personId set integer 0 for false
	 * @param $argConditions for blank condition set $argConditions as ( 1=1 )
	 * @param $fieldOtherThanDob if other field required than dob syntax ( ModelName.fieldName )
	 * @author Gaurav Chauriya
	 * 
	 */
	public function autocompleteForPatientNameAndDob($personId = false,$argConditions = null,$fieldOtherThanDob = null){
		$this->loadModel('Person');
		$this->Person->bindModel(array('belongsTo' => array(
				'Patient' =>array('foreignKey'=>false,'conditions'=>array('Person.id = Patient.person_id'),'type'=>'INNER')
		)));
		/** conditions */
		if(!empty($argConditions)){
			if(strpos($argConditions, "&")){
				$allCondition = explode('&',$argConditions);
				foreach($allCondition as $cond){
					if(!empty($cond)){
						$condPara = explode('=',$cond);
						if(!empty($condPara[0]) && (!empty($condPara[1])||$condPara[0]==0)){
							$condition[$condPara[0]] = $condPara[1];
						}
					}
				}
			}else{
				$condPara = explode('=',$argConditions);
				if(!empty($condPara[0]) && (!empty($condPara[1])||$condPara[0]==0)){
					$condition[$condPara[0]] = $condPara[1];
				}
			}
		}else{
			$conditions =array();
		}
		if(!empty($this->params->query['q'])){
			$searchKey = trim($this->params->query['q']);
		}else{
			$searchKey = trim($this->params->query['term']);
			$returnJSON = true;
		}
		if(preg_match('/\s/',$searchKey)){
			$searchAry = explode(' ',$searchKey);
			$orCondition = "Patient.lookup_name like '%".$searchAry[1]."%' AND Patient.lookup_name like '%".$searchAry[0]."%'";
		}else{
			$condition["Patient.lookup_name like"] = "%".$searchKey."%";
		}
		

	
		/* $condition["Patient.admission_type"] = 'OPD'; */
		$condition["Person.is_deleted"] = 0;
		$condition["Patient.location_id"] = $this->Session->read('locationid');
		if($orCondition)
			$conditions = array($condition,$orCondition);
		else
			$conditions = array($condition);
		$fields= array('Patient.id','Patient.lookup_name','Patient.doctor_id','Person.dob','Person.id',$fieldOtherThanDob);
		$patientArray = $this->Person->find('all', array('fields'=> $fields,'conditions'=>$conditions,'limit'=>Configure::read('number_of_rows'),
				'group'=>array('Person.id')));
		if($returnJSON){
			$returnArray = array();
			foreach ($patientArray as $key=>$value) {
				//converting date from local to DB format.
				if($fieldOtherThanDob){
					$otherField = explode('.',$fieldOtherThanDob);
					$value['Person']['dob'] = $value[$otherField[0]][$otherField[1]];
					
				}else{
					$value['Person']['dob'] = $this->DateFormat->formatDate2Local($value['Person']['dob'],Configure::read('date_format'));
				}
				$returnArray[] = array( 'id'=>$personId ? $value['Person']['id'] : $value['Patient']['id'],
						'value'=>$value['Patient']['lookup_name'].' - '.$value['Person']['dob'],
						'dob'=>$value['Person']['dob'],'doctor_id'=>$value['Patient']['doctor_id']) ;
			}
			echo json_encode($returnArray);
		}else{
			foreach ($patientArray as $key=>$value) {
				$lookup = $value['Patient']['lookup_name'];
				if($fieldOtherThanDob){
					$otherField = explode('.',$fieldOtherThanDob);
					$dob = $value[$otherField[0]][$otherField[1]];
						
				}else{
					$dob = $this->DateFormat->formatDate2Local($value['Person']['dob'],Configure::read('date_format'));
				}
				
				$patientId = $personId ? $value['Person']['id'] : $value['Patient']['id'];
				echo "$lookup - $dob   $patientId|$patientId\n";
			}
		}
		exit;//dont remove this

	}

	//funtion to decide primary nav on top of the page for each link
	//pankaj
	function linkedModules(){
		$this->loadModel('ModulePermission') ;
		$this->loadModel('LinkedModule');
		$modules  = $this->ModulePermission->find('list',array('fields'=>array('id','module'),'order'=>array('ModulePermission.module')));
		$moduleName = ucfirst($this->params->controller) ;
		$key = array_search($moduleName, $modules); //module permission table id
		$linkedModule = $this->LinkedModule->find('list',array('fields'=>array('id','module_permission_parent_id'),'conditions'=>array('role_id'=>$this->Session->read('roleid'),
				'module_permission_id'=>$key)));
		 
		foreach($linkedModule as $linkKey => $linkValue){
			if($modules[$linkValue]=='Nursing'){
				$finalLinkedArray[$linkValue] = 'Nursings' ; //extra cond due to controller name change.
			}else{
				$finalLinkedArray[$linkValue] = $modules[$linkValue];
			}
		}
		//BOF sort order
		$linkedSortModule = $this->LinkedModule->find('list',array('fields'=>array('sort_order','module_permission_parent_id'),'conditions'=>array('role_id'=>$this->Session->read('roleid'),
				'module_permission_id'=>$key)));
		foreach($linkedSortModule as $linkKey1 => $linkValue1){

			if($modules[$linkValue]=='Nursing'){
				$finalLinkedSortArray[$linkKey1] = 'Nursings' ; //extra cond due to controller name change.
			}else{
				$finalLinkedSortArray[$linkKey1] = $modules[$linkValue1];
			}
		}
		
		//EOF sort order

		//debug($this->Session->check('landing_linked_module'));exit;
		//BOF case for landing page
		//if(!$this->Session->check('landing_linked_module')){
			$landingKey = array_search('Landings', $modules); //for landing page icons
			$landingLinkedModule = $this->LinkedModule->find('list',array('fields'=>array('id','module_permission_parent_id'),'conditions'=>array('role_id'=>$this->Session->read('roleid'),
					'module_permission_id'=>$landingKey)));
			foreach($landingLinkedModule as $linkKey => $linkValue){
				$landingLinkedArray[$linkValue] = $modules[$linkValue];
			}
			
			$this->Session->write('landing_linked_module',serialize($landingLinkedArray));
		//}
		//EOF case for landing page
 
		$this->Session->write('linked_modules',serialize($finalLinkedArray));  //write all the modules in session and read while rendering menu
		$this->Session->write('linked_modules_sorting',serialize($finalLinkedSortArray));  //write all the modules in session and read while rendering menu
	}

	/**

	function :configAutoComplete

	@purpose : ajax auto fill with the available options from config array.

	@params : string $configArrayName mandatory

	@author : Gaurav Chauriya

	*/
	function configAutoComplete($configArrayName){

		$searchArray = Configure::read($configArrayName);
		if(!empty($this->params->query['q'])){
			$searchKey = trim($this->params->query['q']);
		}else{
			$searchKey = trim($this->params->query['term']);
			$returnJSON = true;
		}
		$resultArray = array_filter($searchArray, function($var) use ($searchKey) {
			return preg_match("/^".$searchKey."/i", $var);
		});
		if($returnJSON){
			$returnArray = array();
			foreach ($resultArray as $key=>$value) {
				$returnArray[] = array( 'id'=>$key,'value'=>$value) ;

			}
			echo json_encode($returnArray);
		}else{
			foreach ($resultArray as $key=>$value) {
				echo "$value   $key|$key\n";
			}
		}
		exit;
	}

	/**
	 * Function to generate count and details for over due notification for physician
	 * Pankaj W.
	 */
	function notification(){
		//$this->loadModel('Ccda');
		$this->loadModel('Inbox');
		//overdue
		//$result  = $this->Ccda->overdue_summary_care_count();
		//$this->set('ccdaItems',$result); //set array of sent and rcvd ccda emails
		//messages,mails
		$mailResult  = $this->Inbox->mailCount();
		 
		$this->set('receivedMails',$mailResult); //set array of received mails or messages

	}

	/**   ( Lasy Loading for notification ) - gaurav **/
	function loadNotificationMessage(){
		$this->layout = false ;
		$this->loadModel('Ccda');
		$this->loadModel('Inbox');
		$recordLimit = $this->params->query['offset'];
		$this->autoRender = false ;
		//overdue
		$result  = $this->Ccda->overdue_summary_care_count($recordLimit);
		$this->set('ccdaItems',$result); //set array of sent and rcvd ccda emails

		//messages,mails
		$mailResult  = $this->Inbox->mailCount($recordLimit);
			
		$this->set('receivedMails',$mailResult); //set array of received mails or messages
		$this->render('/Messages/load_notification') ;
			
	}

	function changeUserRole($changeRole,$realRole){
		$this->layout = "ajax";
		$this->loadModel('Role');
		$this->Role->unbindModel(array('hasMany' => array('User')));
		//debug($changeRole);exit;
		$roles = $this->Role->find('first',array('conditions'=>array('name'=>$changeRole)));
		
		$this->Session->write('role',$roles['Role']['name']);
		$this->Session->write('role_code_name',$roles['Role']['code_name']);
		$this->Session->write('roleid',$roles['Role']['id']);
		
		
		$this->Session->write('Auth.User.role',$roles['Role']['name']);
		$this->Session->write('Auth.User.role_id',$roles['Role']['id']);

		if(!$this->Session->check('realRole')){
			$this->Session->write('realRole',$realRole);
		}

		$this->Session->write('skipSwapPermissions',$realRole);
		$this->Session->delete('realLocationName');
		exit;
	}

	public function labRadAutocomplete($model=null,$commonField=null,$fieldOne,$fieldTwo=null,$dhrFlag=0){ //
		$locationId = $this->Session->read('locationid');
		$this->layout = "ajax";
		$this->loadModel($model);
		$searchKey = trim($this->params->query['q']);
		$cond2 = $fieldTwo ." like \"" .$searchKey."%\"";
		$cond1 = $fieldOne ." like \"" .$searchKey."%\"";
		
		$name = $this->$model->find('list',array('fields'=>array($commonField,$fieldTwo),'conditions'=>array($cond1 ,'is_active'=>'1' /* ,'dhr_flag'=>$dhrFlag */),'group'=>array($fieldOne)));
		$dhrOrderCode = $this->$model->find('list',array('fields'=>array($commonField,$fieldTwo),'conditions'=>array($cond2,'is_active'=>'1' /* ,'dhr_flag'=>$dhrFlag ,'location_id'=>$this->Session->read('locationid')*/),'group'=>array($fieldTwo)));
		foreach ($dhrOrderCode as $key=>$value) {
			echo "$value   $key|$key\n";
		}
		foreach ($name as $key=>$value) {
			echo "$value   $key|$key\n";
		}
		exit;
	}
	public function MriAutocomplete($model=null,$commonField=null,$fieldOne,$fieldTwo=null,$dhrFlag=0){
		//debug($model);
		//debug($commonField);
	//	debug($fieldOne);
	//	debug($fieldTwo);
	//	debug($dhrFlag);
	//	debug($this->params->query['q']);exit;
	$mri=Configure::read('MRI');
		$this->loadModel('ServiceCategory');
		$id=$this->ServiceCategory->getServiceGroupId($mri);
		$locationId = $this->Session->read('locationid');
		$this->layout = "ajax";
		$this->loadModel($model);
		$searchKey = trim($this->params->query['q']);
		$cond2 = $fieldTwo ." like \"" .$searchKey."%\"";
		$cond3 = "service_group_id" ." = \"" .$id."\"";
	//	$cond1 = $fieldOne ." like \"" .$searchKey."%\"";
		$name = $this->$model->find('list',array('fields'=>array($commonField,$fieldTwo),'conditions'=>array($cond1,$cond3/* ,'dhr_flag'=>$dhrFlag */),'group'=>array($fieldOne)));
		//$dhrOrderCode = $this->$model->find('list',array('fields'=>array($commonField,$fieldTwo),'conditions'=>array($cond2/* ,'dhr_flag'=>$dhrFlag */,'location_id'=>$this->Session->read('locationid')),'group'=>array($fieldTwo)));
		//foreach ($dhrOrderCode as $key=>$value) {
		//	echo "$value   $key|$key\n";
	//	}
		foreach ($name as $key=>$value) {
		echo "$value   $key|$key\n";
		}
		exit;
	}
	public function PhysioAutocomplete($model=null,$commonField=null,$fieldOne,$fieldTwo=null,$dhrFlag=0){
	
		$physio="29";
		$this->loadModel('ServiceCategory');
		$id=$this->ServiceCategory->getServiceGroupId($physio);
		$locationId = $this->Session->read('locationid');
		$this->layout = "ajax";
		$this->loadModel($model);
		$searchKey = trim($this->params->query['q']);
		$cond2 = $fieldTwo ." like \"" .$searchKey."%\"";
		$cond3 = "service_category_id" ." = \"" .$physio."\"";
		//	$cond1 = $fieldOne ." like \"" .$searchKey."%\"";
		$name = $this->$model->find('list',array('fields'=>array($commonField,$fieldTwo),'conditions'=>array($cond2,$cond3/* ,'dhr_flag'=>$dhrFlag */)));
		
		foreach ($name as $key=>$value) {
			echo "$value   $key|$key\n";
		}
		exit;
	}
	public function googlecomplete($model=null,$fieldOne=null,$fieldTwo=null,$argConditions=null,$group=array(),$location = null){
		$this->layout = "ajax";
		$this->loadModel($model);
		$conditions =array();
		if(!empty($argConditions)){
			if(strpos($argConditions, "&")){
				$allCondition = explode('&',$argConditions);
				foreach($allCondition as $cond){
					if(!empty($cond)){
						$condPara = explode('=',$cond);
						if(!empty($condPara[0]) && (!empty($condPara[1])||$condPara[0]==0)){
							$pos = strpos($condPara[0], '<>');
							if($pos !== false){
								$condPara[0] = str_replace("<>", "", $condPara[0]);
								$str = "`$condPara[0]` <> \"$condPara[1]\"";
								array_push($conditions,$str);
							}else{
								$conditions[$condPara[0]] = $condPara[1];
							}
						}
					}
				}
			}else{
				$condPara = explode('=',$argConditions);
				if(isset($condPara[0]) && isset($condPara[1])){
					$conditions["$model.$condPara[0]"] = $condPara[1];
				}
			}
		}else{
			$conditions =array();
		}
		if($location != null){
			$conditions[$model.".location_id"] = $this->Session->read('locationid');
		}
		if($this->$model->hasField('is_deleted')){
			$conditions[$model.".is_deleted"] = 0;
		}
		$searchKey = $this->params->query['q'] ;

		$keyWordExplode=explode(' ',$searchKey);
		$conditionsString = $conditionsStringOR = '';
		foreach($keyWordExplode as $key=>$value){
			$conditionsString .=$model.".".$fieldTwo. " LIKE \"%".$value."%\" AND ";
			$conditionsStringOR .=$model.".".$fieldTwo. " LIKE \"%".$value."%\" OR ";
		}
		$conditionsString = rtrim($conditionsString," AND ");
		$conditionsStringOR = rtrim($conditionsStringOR," OR ");
		//$conditions[] = $conditionsString;
		//pr($conditions);exit;
		foreach($conditions as $key=>$value){
			$stringCond .= $key ."=$value AND ";
			$stringCondOR .= $key ."=$value AND ";
		}

		$selectedModels = array('DoctorProfile','User','AllergyMaster');
		if($group != 'null'){
			$testArray = $this->$model->find('list', array('fields'=> array($fieldOne, $fieldTwo),'conditions'=>$stringCond.$conditionsString,'group'=>$group,'order'=>array("$fieldTwo ASC")));
		}else{
			$testArray = $this->$model->find('list', array('fields'=> array($fieldOne, $fieldTwo),'conditions'=>$stringCond.$conditionsString,'order'=>array("$fieldTwo ASC")));
		}
		if(count($testArray) > 0){
			foreach ($testArray as $key=>$value) {
				echo "$value   $key|$key\n";
			}
		}else{
			if($group != 'null'){
				$testArray = $this->$model->find('list', array('fields'=> array($fieldOne, $fieldTwo),'conditions'=>$stringCondOR.$conditionsStringOR,'group'=>$group,'order'=>array("$fieldTwo ASC")));
			}else{
				$testArray = $this->$model->find('list', array('fields'=> array($fieldOne, $fieldTwo),'conditions'=>$stringCondOR.$conditionsStringOR,'order'=>array("$fieldTwo ASC")));
			}
		}
		exit;
	}
	
function advanceMultipleAutocomplete($model=null,$field=null,$type=null,$is_deleted=null,$location=null,$argConditions=null,$group=array()){
	
		$location_id = $this->Session->read('locationid');
		$this->layout = "ajax";
		$this->loadModel($model);
		$conditions =array();
		
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
				if(!empty($condPara[0]) && (!empty($condPara[1])|| $condPara[0]==0 ) && $condPara[0] != 'null'){
					$conditions[$condPara[0]] = $condPara[1];
				}
			}
		}else{
			$conditions =array();
		}
		$searchKey = $this->params->query['term'];
		//converting date from local to DB format.
		
		if($type=="date"){
			$searchKey = $this->DateFormat->formatDate2STD($this->params->query['q'],Configure::read('date_format'));
		}elseif($type=="datetime"){  //converting datetime from local to DB format.
			$searchKey = $this->DateFormat->formatDate2STD($this->params->query['q'],Configure::read('date_format'),true);
		}
		//filter deleted items
		
		if(empty($is_deleted) || $is_deleted=='null'):
		$conditions["$model.is_deleted"] = 0 ;
		endif ;
			 if(($model =='Drug') || ($model =='icd') || (!empty($location) && $location != "null")){
		}else{
			$conditions["$model.location_id"] = $location_id;
		}
		if($model =='OtItem' && $this->params->query['category']){
			$conditions['OtItem.ot_item_category_id'] = $this->params->query['category'];
		}
		if($model =='Patient'){
			//$conditions['Patient.is_discharge'] = '0';
			$conditions['Patient.is_deleted'] = '0';
		}
		if($model =='PharmacyItem'){
			$this->PharmacyItem->unbindModel(array('hasMany' => array('InventoryPurchaseItemDetail'),
					'hasOne'=>array('PharmacyItemRate')),false);
			// $conditions["PharmacyItem.supplier_id <>"] ="";
			$conditions["PharmacyItem.is_deleted"] ='0';
			if(isset($this->params->query['supplierID'])){
				//$conditions["PharmacyItem.supplier_id"] = $this->params->query['supplierID'];
			}
		}
		if($model =='User'){
			$conditions["User.username <>"] = "admin";
			$conditions["User.username !="] = "superadmin";
			//debug($field);
			if($field =='full_name'){
				$field = $this->User->getVirtualField('full_name');
				$virtual = true;
			}
		}
	
		if(strpos($field, "&")){
			$field = explode('&',$field);
			
		}else if(strpos($field, "*")){
			$strField = explode('*',$field);
			$field =array("id", $strField['0'],'*');
			
		}else{
			$field =array("id", $field);
			
		}
		$conditions["trim(".$field[1].") like"] = $searchKey."%";		
		
		$field[0] = $model.'.'.$field[0]." as id";/** for making array suitable for js array*/
		$field[1] = $field[1]." as value";
		$patientArray = $this->$model->find('all', array('fields'=> $field,'conditions'=>$conditions,'group'=>$group,'limit'=>Configure::read('number_of_rows')));
		$returnArray = array();
		/* foreach ($patientArray as $key=>$value) {
			$returnArray[] = $value[$model];
		}*/
		foreach ($patientArray as $key=>$value) {
			if($virtual){
				$returnArray[$key] = $value[$model];
				$returnArray[$key]['value'] = $value[0]['value'];
			}else{
				$returnArray[] = $value[$model];
			}
		}
		
		echo json_encode($returnArray);
		exit;//dont remove this
	
	}
	
	function changeUserLocation($changeLocation,$realLocationName){
		$this->layout = "ajax";
		$this->autoRender = false ;
		$this->loadModel('Location');
		//$this->Location->unbindModel(array('hasMany' => array('City','State','Country')));
		$locations = $this->Location->find('first',array('conditions'=>array('Location.name'=>$changeLocation)));
		$this->Session->write('location_name',$locations['Location']['name']);
		$this->Session->write('location',$locations['Location']['name']);
		$this->Session->write('locationid',$locations['Location']['id']); 
		$this->Session->write('Auth.User.location_id',$locations['Location']['id']); 
		if(!$this->Session->check('realLocationName')){
			$this->Session->write('realLocationName',$realLocationName);
		}
		//by pankaj w to maintain user location type
		$this->Session->write('hospital_permission_mode',$locations['Location']['hospital_type']);  
		$this->Session->delete('skipSwapPermissions'); 
	}
	
	public function autocompleteForConsultantFullName(){
		$this->uses = array('Consultant');
		/*$this->Person->bindModel(array('belongsTo' => array(
		 'Patient' =>array('foreignKey'=>false,'conditions'=>array('Person.id = Patient.person_id'),'type'=>'INNER')
		)));*/
		/** conditions */
		if(!empty($this->params->query['q'])){
			$searchKey = trim($this->params->query['q']);
		}else{
			$searchKey = trim($this->params->query['term']);
			$returnJSON = true;
		}
		if(preg_match('/\s/',$searchKey)){
			$searchAry = explode(' ',$searchKey);
			$orCondition = "Consultant.first_name like '%".$searchAry[1]."%' AND Consultant.first_name like '%".$searchAry[0]."%'";
		}else{
			$condition["Consultant.first_name like"] = "%".$searchKey."%";
		}
		$condition["Consultant.is_deleted"] = 0;
	
	
		/* $condition["Patient.admission_type"] = 'OPD'; */
	
		$condition["Consultant.location_id"] = $this->Session->read('locationid');	
		if($orCondition)
			$conditions = array($condition,$orCondition);
		else
			$conditions = array($condition);
		$fields= array('Consultant.id','Consultant.first_name','Consultant.last_name');
		$consultantArray = $this->Consultant->find('all', array('fields'=> $fields,'conditions'=>$conditions,'limit'=>Configure::read('number_of_rows'),'group'=>array('Consultant.id')));
		if($returnJSON){
			$returnArray = array();
			foreach ($consultantArray as $key=>$value) {
				//converting date from local to DB format.
				//	$value['Person']['dob'] = $this->DateFormat->formatDate2Local($value['Person']['dob'],Configure::read('date_format'));
			
				$returnArray[] = array( 'id'=>$value['Consultant']['id'],'value'=>$value['Consultant']['first_name'].' - '.$value['Consultant']['last_name'],
						'last_name'=>$value['Consultant']['last_name']) ;
			}
			echo json_encode($returnArray);
		}else{
			foreach ($patientArray as $key=>$value) {
				$firstName = $value['Consultant']['first_name'];
				$lastName = $value['Consultant']['last_name'];
				//$dob = $this->DateFormat->formatDate2Local($value['Person']['dob'],Configure::read('date_format'));
				$consultantId = $value['Consultant']['id'];			
				echo "$firstName - $lastName   $consultantId|$consultantId\n";
			}
		}
		exit;//dont remove this
	
	}
	public function googlecompleteproblem($model=null,$fieldOne=null,$fieldTwo=null,$argConditions=null,$group=array(),$location = null){
		$this->layout = "ajax";
		$this->loadModel($model);
		$conditions =array();
		if(!empty($argConditions)){
			if(strpos($argConditions, "&")){
				$allCondition = explode('&',$argConditions);
				foreach($allCondition as $cond){
					if(!empty($cond)){
						$condPara = explode('=',$cond);
						if(!empty($condPara[0]) && (!empty($condPara[1])||$condPara[0]==0)){
							$pos = strpos($condPara[0], '<>');
							if($pos !== false){
								$condPara[0] = str_replace("<>", "", $condPara[0]);
								$str = "`$condPara[0]` <> \"$condPara[1]\"";
								array_push($conditions,$str);
							}else{
								$conditions[$condPara[0]] = $condPara[1];
							}
						}
					}
				}
			}else{
				$condPara = explode('=',$argConditions);
				if(isset($condPara[0]) && isset($condPara[1])){
					$conditions["$model.$condPara[0]"] = $condPara[1];
				}
			}
		}else{
			$conditions =array();
		}
		if($location != null){
			$conditions[$model.".location_id"] = $this->Session->read('locationid');
		}		
			
		$conditions[$model.".active"] = '1';	
		
		if($this->$model->hasField('is_deleted')){
			$conditions[$model.".is_deleted"] = 0;
		}
		$searchKey = $this->params->query['q'] ;
	
		$keyWordExplode=explode(' ',$searchKey);
		$conditionsString = $conditionsStringOR = '';
		foreach($keyWordExplode as $key=>$value){
			$conditionsString .=$model.".".$fieldTwo. " LIKE \"%".$value."%\" AND ";
			$conditionsStringOR .=$model.".".$fieldTwo. " LIKE \"%".$value."%\" OR ";
		}
		$conditionsString = rtrim($conditionsString," AND ");
		$conditionsStringOR = rtrim($conditionsStringOR," OR ");
		//$conditions[] = $conditionsString;
		//pr($conditions);exit;
		foreach($conditions as $key=>$value){
			$stringCond .= $key ."=$value AND ";
			$stringCondOR .= $key ."=$value AND ";
		}
	
		$selectedModels = array('DoctorProfile','User','AllergyMaster');
		if($group != 'null'){
			$testArray = $this->$model->find('list', array('fields'=> array($fieldOne, $fieldTwo),'conditions'=>$stringCond.$conditionsString,'group'=>$group,'order'=>array("$fieldTwo ASC")));
		}else{
			$testArray = $this->$model->find('list', array('fields'=> array($fieldOne, $fieldTwo),'conditions'=>$stringCond.$conditionsString,'order'=>array("$fieldTwo ASC")));
		}
		if(count($testArray) > 0){
			foreach ($testArray as $key=>$value) {
				echo "$value   $key|$key\n";
			}
		}else{
		if($group != 'null'){
				$testArray = $this->$model->find('list', array('fields'=> array($fieldOne, $fieldTwo),'conditions'=>$stringCondOR.$conditionsStringOR,'group'=>$group,'order'=>array("$fieldTwo ASC")));
				}else{
				$testArray = $this->$model->find('list', array('fields'=> array($fieldOne, $fieldTwo),'conditions'=>$stringCondOR.$conditionsStringOR,'order'=>array("$fieldTwo ASC")));
				}
				}
				exit;
	}
	
	
	/*
	 * function for billing header
	 * @params patient_id, 
	 * by yashwant
	 * return patient array
	 */
	function billing_patient_header($patient_id=null,$billRecID=null){
	
		$this->loadModel('Patient');
	
		$this->loadModel('DoctorProfile');
	
		$this->loadModel('Person');
	
		$this->loadModel('User');
	
		$this->Patient->bindModel(array(
	
				'belongsTo' => array(
	
						//'Initial' =>array( 'foreignKey'=>'initial_id'),
	
						'Consultant' =>array('foreignKey'=>'consultant_treatment'),
	
						'TariffStandard'=>array('foreignKey'=>'tariff_standard_id')),
	
				'hasOne'=>array('FinalBilling'=>array('foreignKey'=>'patient_id'))));
	
		$patient_details  = $this->Patient->getPatientDetailsByIDWithTariff($patient_id,'bill_number');//sent 2nd arg for bill number
	
		$treatingConsultant = $this->User->getDoctorByID($patient_details['Patient']['doctor_id']) ;
		$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($patient_id);
		//$patientAge= $this->getAge($UIDpatient_details['Person']['age']);
		$this->set('age',$UIDpatient_details['Person']['age']);
		$this->set('sex',$UIDpatient_details['Person']['sex']);
		$this->set('dob',$UIDpatient_details['Person']['dob']);
		$formatted_address = $this->setAddressFormat($UIDpatient_details['Person']);
	
		$billNumber=$this->Billing->find('first',array('fields'=>array('Billing.bill_number'),
				'conditions'=>array('Billing.patient_id'=>$patient_id,'Billing.id'=>$billRecID)));
		$this->set(array('address'=>$formatted_address,'patient'=>$patient_details,'treating_consultant'=>$treatingConsultant,'billNumber'=>$billNumber));
	
		
	}
	
	/**
	 * PAWAN MESHRAM
	 * To allow the permissions of other controller
	 */
	function allowDRM($controller,$action=array()){
		$this->exceptionForPermissions[$controller] = $action;
	}
	
	
	/**
	 * for billing patient info header
	 * @ yashwant
	 */
	function patient_billing_info($patient_id=null){
		$this->loadModel('Corporate');
		$this->loadModel('Ward');
		$this->loadModel('Room');
		$this->loadModel('Bed');
		$this->loadModel('Person');
		$this->loadModel('Patient');
		$this->loadModel('Consultant');
		$this->loadModel('User');
		$this->loadModel('PatientDocument');
		$this->loadModel('State');
		$this->loadModel('Billing');
	
		$this->Patient->unBindModel(array( 'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
	
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						//'Initial' =>array( 'foreignKey'=>'initial_id'),
						//'Consultant' =>array('foreignKey'=>'consultant_treatment'),
						'TariffStandard' =>array('foreignKey'=>'tariff_standard_id'),
						//'Person' =>array('foreignKey'=>'person_id'),
						//'User' =>array('foreignKey'=>false,array('conditions'=>array('User.id' => 'Patient.doctor_id'))),
						//'Billing' =>array('foreignKey'=>false,array('conditions'=>array('Billing.patient_id' => 'Patient.id')))
				)));
		//$billData= $this->Billing->find('first',array('conditions'=>array('Billing.patient_id'=>$patient_id)));
		$patient_details  = $this->Patient->getPatientDetailsForElement($patient_id);
			
		//$this->patient_details = $patient_details  ;
	
		$dob=$patient_details['Person']['dob'];
		//$state_location_patients = $this->State->find('first', array('fields'=> array('State.state_code'),'conditions'=>array('State.id'=>$patient_details['Person']['state'])));
		$patientAge= $this->getAge($dob);
		$this->set("age",$patientAge);
		$this->set("patientstate",$state_location_patients['State']['state_code']);
			
		//$formatted_address = $this->setAddressFormat($patient_details['Person']);
			
		if($patient_details['Patient']['admission_type'] == 'IPD'){
	
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'Ward' =>array( 'foreignKey'=>false,
									'conditions'=>array('Ward.id = Patient.ward_id')),
							'Room' =>array('foreignKey'=>false,
									'conditions'=>array('Room.id = Patient.room_id')),
							'Bed' =>array('foreignKey'=>false,
									'conditions'=>array('Bed.id = Patient.bed_id')),
							'Person' =>array('foreignKey'=>false,
									'conditions'=>array('Person.id = Patient.person_id')),
	
					)));
	
			$wardInfo = $this->Patient->find('first', array('fields'=> array('Room.bed_prefix,Bed.bedno,Ward.name'),'conditions'=>array('Patient.id'=>$patient_id)));
			$this->set("wardInfo",$wardInfo);
	
	
		} 
	 
		$this->set(array(//'diagnosis'=>$patient_details['Diagnosis']['final_diagnosis'],'photo' => $patient_details['Person']['photo'],
				//'address'=>$formatted_address,
				'patient'=>$patient_details,
				'patient_id'=>$patient_id,
				//'treating_consultant'=>$this->User->getDoctorByID($patient_details['Patient']['doctor_id']),
				'sex'=>$patient_details['Person']['sex'],
				'blood_group'=>$patient_details['Person']['blood_group'],
				'patientDetailsForView'=>$patient_details,
				'billData'=>$billData));
		  
	}
	
	//function to  discplay expiryProductList by pankaj 
	function expiryProductList(){
		//SELECT pir.expiry_date,pi.name FROM `pharmacy_item_rates` as pir inner join pharmacy_items as pi on pir.item_id = pi.id
		// WHERE pir.expiry_date BETWEEN "2015-09-30" and "2015-11-30" group by pi.id
		//$this->layout = false;
		//$this->autoRender = false;
		$this->loadModel('PharmacyItemRate');
		$this->PharmacyItemRate->bindModel(array('belongsTo'=>array(
				'PharmacyItem'=>array(
						'foreignKey'=>false,
						'type'=>'INNER',
						'conditions'=>array(
								'PharmacyItemRate.item_id = PharmacyItem.id')))));
		$data = $this->PharmacyItemRate->find('all',array('fields'=>array('PharmacyItemRate.expiry_date, PharmacyItem.id, PharmacyItem.name'),
				'conditions'=>array('PharmacyItemRate.expiry_date BETWEEN NOW() AND DATE_ADD(NOW(),INTERVAL 2 MONTH)','PharmacyItemRate.stock > 0 || PharmacyItemRate.loose_stock > 0'),
				'group'=>array('PharmacyItemRate.item_id')));
		foreach($data as $val){
			if($val['PharmacyItemRate']['expiry_date']){
				$expiryDate = $this->DateFormat->formatDate2Local($val['PharmacyItemRate']['expiry_date'],Configure::read('date_format')) ;
			}
			$returnArray[] = $val['PharmacyItem']['name']."(".$expiryDate.")";
		}
		 
		$this->set('result',$returnArray);
	}
	
        /*
         * function to display the reorder list
         * @author : Swapnil
         * @created : 26.03.2016
         */
        function reorderProductList(){ 
            $having = "total_Stock <= PharmacyItem.reorder_level"; 
            $this->loadModel('PharmacyItemRate');
            $this->PharmacyItemRate->bindModel(array(
                    'belongsTo'=>array(
                        'PharmacyItem'=>array(
                            'foreignKey'=>'item_id'
                        )
                    )
                ),false);
                 
            $results = $this->PharmacyItemRate->find('all',array(
                'fields'=>array(
                    'PharmacyItem.name, PharmacyItem.reorder_level' ,
                    'SUM((PharmacyItemRate.stock*PharmacyItem.pack)+PharmacyItemRate.loose_stock) as total_Stock'
                ),
                'conditions'=>array(
                    'PharmacyItemRate.is_deleted'=>'0','PharmacyItem.is_deleted'=>'0','PharmacyItem.drug_id IS NOT NULL',
                    $conditions
                ),
                'group'=>array(
                    'PharmacyItemRate.item_id HAVING '.$having
                )
            )); 
            foreach($results as $key => $val){
                $reorderProductList[] = $val['PharmacyItem']['name'];
            } 
            $this->set(compact(array('reorderProductList')));   
	} 
	
	//function to return search data of lab,radiology and services
	function combineServices(){
		$this->layout = 'ajax' ;
		$this->loadModel('Laboratory');
		$this->loadModel('Radiology');
		$this->loadModel('TariffList');
		$this->loadModel('ServiceCategory');
		$LabCatId=$this->ServiceCategory->getServiceGroupIdbyName(Configure::read('laboratoryservices'));
		$radCatId=$this->ServiceCategory->getServiceGroupIdbyName(Configure::read('radiologyservices'));
		$searchKey = $this->params->query['term'] ;
		$result  = $this->Laboratory->query('SELECT "lab" as table_name,name as lab_name,id FROM laboratories where name like "%'.$searchKey.'%"
					UNION ALL  SELECT "radiology" as table_name,name as rad_name,id FROM radiologies where name like "%'.$searchKey.'%"
					UNION ALL  SELECT "tariff_list" as table_name, name as service_name,id FROM tariff_lists where name like "%'.$searchKey.'%"
					and  service_category_id <> "'.$LabCatId.'" AND service_category_id <> "'.$radCatId.'"  limit 0,20
					');
		foreach ($result as $key=>$value) {
			$returnArray[] = array('id'=>$value[0]['id'],'value'=>$value[0]['lab_name'],'table'=>$value[0]['table_name']) ;
		}
		echo json_encode($returnArray) ;
		exit;
	}

	public function sentenceComplete($type=NULL,$excondition=NULL){
		$this->layout = 'ajax';
		$this->loadModel('PackageCategory');
		$conditions =array();
		$condition=array();
		$searchKey = $this->params->query['term'] ;

		//Vadodara search will be for name and Patient UID / for other instance its Name and Patient MRN
		if($this->Session->read('website.instance')=='vadodara'){
			$conditions["PackageCategory.name like"] = $searchKey.'%';
		}else{
			$conditions["PackageCategory.name like"] = $searchKey.'%';
		}
		
		$testArray = $this->PackageCategory->find('all', array(
				'fields'=> array('id','name'),
				'conditions'=>array($conditions),
				'limit'=>Configure::read('number_of_rows')));
		if($this->Session->read('website.instance')=='vadodara'){
			foreach ($testArray as $key=>$value) {
				$returnArray[]=array('id'=>$value['PackageCategory']['id'],'name'=>$value['PackageCategory']['name'],'value'=>ucwords(strtolower($value['PackageCategory']['name'])));
				//echo "$value   $key|$key\n";
			}
		}else{
			foreach ($testArray as $key=>$value) {	
				$returnArray[]=array('id'=>$value['PackageCategory']['id'],'name'=>$value['PackageCategory']['name'],'value'=>ucwords(strtolower($value['PackageCategory']['name'])));
				//echo "$value   $key|$key\n";
			}
		}
		echo json_encode($returnArray);
		exit;
			
	}

}