<?php
/**
 * Radiologies controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Radiology Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 * $function 	  :AEVD
 */

define('RADIOPATH',FULL_BASE_URL.Router::url("/")."uploads/radiology_data/");
class RadiologiesController extends AppController {

	public $name = 'Radiologies';
	public $uses = array('Radiology');
	public $components = array('ImageUpload');
	public $helpers = array('Html','Form', 'Js','DateFormat','RupeesToWords','Number','General');
    

	function index(){

	}

	function admin_index(){
		$this->set('title_for_layout', __('-Radiology management', true));
		$conditionsSearch['Radiology'] = array('location_id'=> $this->Session->read('locationid'));
		if(isset($this->request->data) && isset($this->request->data) && $this->request->data['rad_name']!=''){
			$conditionsSearch["Radiology"] = array("name LIKE" => "%".$this->request->data['rad_name']."%",'location_id' => $this->Session->read('locationid'));
		}
		$conditionsSearch = $this->postConditions($conditionsSearch);
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'Radiology.name' => 'asc'
				),
				'conditions' => $conditionsSearch
		);
		#$testData = $this->Radiology->find('all',array('conditions'=>array('Radiology.location_id' => $this->Session->read('locationid'))));
		$testData = $this->paginate('Radiology');
		$this->set('testData',$testData);
	}

	function admin_add($lab_id=null){
		$this->uses = array('ServiceCategory','TariffList','TestGroup') ;
		if(isset($this->request->data) && !empty($this->request->data)){
			if(($this->Radiology->insertRadioTest($this->request->data))){
				$this->Session->setFlash(__('Test has been added successfully'),'default',array('class'=>'message'));
				$this->redirect(array("action" => "index"));
			}
			$errors = $this->Radiology->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
				$this->request->data['RadiologyParameter']= "";
			}
		}
		$this->set('radServiceGroup',$this->ServiceCategory->getServiceGroup());
		$this->set('radId',$this->ServiceCategory->getServiceGroupId("radiologyservices"));
		
		if(!empty($lab_id)){
			$testQuery = $this->Radiology->read(null,$lab_id);
			$this->data = $testQuery ;
			$tariffList = $this->TariffList->getServiceByGroupId($this->data['Radiology']['service_group_id']);
		}
		//print_r($this->data);
		$this->set('tariffList',$tariffList);
		$this->set('testGroup',$this->TestGroup->getAllGroups('radiology')) ;
		//$this->uses = array('RadiologyTemplateText','RadiologyTemplate');
		//$templates = $this->Radiology

	}

	function admin_delete($id){
		if(!$id) return ;
		//for updating account legder is deleted by amit
		$this->request->data["Radiology"]["id"] = $id;
		$this->request->data["Radiology"]["is_deleted"] = '1';
		$this->Radiology->save($this->request->data);
		//EOF
		if($this->Radiology->delete($id)){
			$this->Session->setFlash(__('Test deleted successfully'),'default',array('class'=>'message'));
			$this->redirect($this->referer());
		}else{
			$this->Session->setFlash(__('There is some problem'),'default',array('class'=>'error'));
		}
	}

	function admin_change_status($test_id=null,$status=null){
		if($test_id==''){
			$this->Session->setFlash(__('There is some problem'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
		$this->Radiology->id = $test_id ;
		$this->Radiology->save(array('is_active'=>$status));
		$this->Session->setFlash(__('Status has been changed successfully'),'default',array('class'=>'message'));
		$this->redirect($this->referer());
	}

	function radiology_order($patient_id=null){
		$this->uses = array('Person','Patient','Consultant','User','RadiologyTestOrder');
		//lab tests
		$dept  =  isset($this->params->query['dept'])? $this->params->query['dept']:'';
		$testDetails = $this->RadiologyTestOrder->find('count',array('conditions'=>array('patient_id'=>$patient_id)));

		if($testDetails){

			//BOF new code
			$testArray = $testDetails['RadiologyTestOrder']['radiology_id'];
			$this->RadiologyTestOrder->bindModel(array(
					'belongsTo' => array(
							'Radiology'=>array('foreignKey'=>'radiology_id','conditions'=>array('Radiology.is_active'=>1) ),
					),
					'hasOne' => array(
							'RadiologyResult'=>array('foreignKey'=>'radiology_test_order_id')
					)),false);
	 		
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'fields'=>array('RadiologyTestOrder.batch_identifier','RadiologyResult.confirm_result','RadiologyTestOrder.id','RadiologyTestOrder.create_time','RadiologyTestOrder.order_id','Radiology.id','Radiology.name'),
					'conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id,'RadiologyTestOrder.is_deleted'=>0),
					'order' => array(
							'RadiologyTestOrder.id' => 'asc'
					),
					'group'=>array('RadiologyTestOrder.id')
			);
			$testOrdered   = $this->paginate('RadiologyTestOrder');
				
			$TestOrderedlabId = implode(',',$this->RadiologyTestOrder->find('list',array('fields'=>array('radiology_id'),'conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id,'RadiologyTestOrder.is_deleted'=>0))));

			$labTest  = $this->Radiology->find('list',array('fields'=>array('Radiology.id','Radiology.name'),'conditions'=>array('is_active'=>1,'location_id'=>$this->Session->read('locationid'))));

		 	
			//EOD new code
		}else{
			$labTest  = $this->Radiology->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_active'=>1)));
			$testOrdered ='';
		}
			
		return array('test_data'=>$labTest,'test_ordered'=>$testOrdered);
	}

	/**
	 *
	 * @param $patient_id
	 * @return function to insert test assign to patient
	 */
	function radiology_test_order($patient_id=null){

		if(empty($this->request->data['RadiologyTestOrder']['id']) && empty($this->request->data['RadiologyTestOrder']['radiology_id'])){
			$this->Session->setFlash(__('Please select test'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}else if(!empty($patient_id) && isset($this->request->data) && !empty($this->request->data) ){
			$this->uses = array('RadiologyTestOrder');
			if($this->RadiologyTestOrder->insertTestOrder($this->request->data)){ //save patient's required test
				$this->Session->setFlash(__('Submitted Successfully'),'default',array('class'=>'message'));
			}else{
				$this->Session->setFlash(__('Unable to submit , Please try again'),'default',array('class'=>'error'));
			}
			$this->redirect('/laboratories/lab_order/'.$patient_id.'?dept=radiology');
		}

	}
	function ajax_sort_test(){
		$this->layout = false ;
		$this->uses = array('RadiologyTestOrder');
			
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey'=>'Radiology_id','conditions'=>array('Radiology.is_active'=>1) ),
				)));

		$TestOrderedlabId = implode(',',$this->RadiologyTestOrder->find('list',array('fields'=>array('Radiology_id'),'conditions'=>array('RadiologyTestOrder.is_deleted'=>0))));


		if(!empty($_GET['searchParam'])){
			$cond = array('Radiology.is_active'=>1,'Radiology.location_id' => $this->Session->read('locationid'),"Radiology.name like '".$_GET['searchParam']."%'") ;
		}else{
			$cond =array('Radiology.location_id' => $this->Session->read('locationid'),'Radiology.is_active'=>1) ;
		}

		$testData = $this->Radiology->find('list',array('fields'=>array('id','name'),
				'conditions'=>$cond,'order'=>array('Radiology.name'))
		);
		$testOrdered='';

	 	
		echo json_encode($testData);
		exit;


	}

	function radiology_manager(){
		$this->uses=array('Patient','RadiologyTestOrder');
		$this->set('data','');

		$role = $this->Session->read('role');
		$search_key['Patient.is_deleted'] = 0;
		//$search_key['Patient.is_discharge'] = 0;

		$search_key['RadiologyTestOrder.location_id']=$this->Session->read('locationid');
		$search_key['Radiology.is_active']=1 ;

		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' ))
				)),false);
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey'=>'radiology_id' ),
						'Patient'=>array('foreignKey'=>'patient_id'),
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
						'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id =Patient.department_id' )),
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' ))
				)),false);
		$this->RadiologyTestOrder->bindModel(array(
				'hasOne' => array(
						'Initial' =>array('foreignKey' => false,'conditions'=>array('Initial.id=User.initial_id' ))
				)),false);
		if(!empty($this->params->query)){
			$search_ele = $this->params->query  ;//make it get

			if(!empty($search_ele['lab_test_name']) ){
				$search_key['Radiology.name'] = $search_ele['lab_test_name'] ;
			}
			if(!empty($search_ele['radiology_test_name']) ){
			}
			if(!empty($search_ele['histology_test_name']) ){
			}

			$search_ele['lookup_name'] = explode(" ",$search_ele['lookup_name']);
			if(count($search_ele['lookup_name']) > 1){
				$search_key['SOUNDEX(Person.first_name) like'] = "%".soundex(trim($search_ele['lookup_name'][0]))."%";
				$search_key['SOUNDEX(Person.last_name) like'] = "%".soundex(trim($search_ele['lookup_name'][1]))."%";
			}else if(count($search_ele['lookup_name)']) == 0){
				$search_key['OR'] = array(
						'SOUNDEX(Person.first_name)  like'  => "%".soundex(trim($search_ele['lookup_name'][0]))."%",
						'SOUNDEX(Person.last_name)   like'  => "%".soundex(trim($search_ele['lookup_name'][0]))."%");

			}if(!empty($search_ele['patient_id'])){
				$search_key['Patient.patient_id like '] = "%".trim($search_ele['patient_id']) ;
			}if(!empty($search_ele['admission_id'])){
				$search_key['Patient.admission_id like '] = "%".trim($search_ele['admission_id']) ;
			}if(!empty($search_ele['dob'])){
				$search_key['Person.dob like '] = "%".trim(substr($this->DateFormat->formatDate2STD($search_ele['dob'],Configure::read('date_format')),0,10));
			}if(!empty($search_ele['ssn_us'])){
				$search_key['Person.ssn_us like '] = "%".trim($search_ele['ssn_us'])."%" ; ;
			}

			if(!empty($search_ele['from']) && !empty($search_ele['to'])){

				$formDate = $this->DateFormat->formatDate2STD($search_ele['from']." 00:00:00",Configure::read('date_format'));
				$toDate = $this->DateFormat->formatDate2STD($search_ele['to']." 23:59:59",Configure::read('date_format'));
				$search_key['RadiologyTestOrder.create_time <='] = $toDate ;
				$search_key['RadiologyTestOrder.create_time >='] = $formDate ;

			}else if(!empty($search_ele['from'])){
				$search_key['RadiologyTestOrder.create_time >='] = $formDate;
			}
			$search_key['RadiologyTestOrder.is_deleted']=0;
			//debug($search_key);
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('Patient.id' => 'asc'),
					'fields'=> array('PatientInitial.name,Patient.lookup_name,RadiologyTestOrder.create_time,Radiology.name,RadiologyTestOrder.order_id,RadiologyTestOrder.id,RadiologyTestOrder.test_done,
							Patient.id,Patient.sex,Person.ssn_us,Department.name,Person.dob,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time, Initial.name'),
					'conditions'=>$search_key ,
					'group'=>array('RadiologyTestOrder.patient_id')
			);
			$this->set('data',$this->paginate('RadiologyTestOrder'));
		}else{
			//	$search_key['RadiologyTestOrder.create_time like'] = date("Y-m-d")."%";
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('Patient.id' => 'asc'),
					'fields'=> array('PatientInitial.name,Radiology.name,RadiologyTestOrder.create_time,RadiologyTestOrder.order_id,RadiologyTestOrder.create_time,Patient.lookup_name,RadiologyTestOrder.id,RadiologyTestOrder.test_done,
							Patient.id,Patient.sex,Patient.patient_id,Department.name,Person.ssn_us,Person.dob,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time, Initial.name'),
					'conditions'=>$search_key,
					'group'=>array('RadiologyTestOrder.patient_id')
			);
			///debug($search_key);
			$this->set('data',$this->paginate('RadiologyTestOrder'));
		}
	}

	//ajax function to display test order form with SPID and ACID
	function ajax_radiology_manager_test_order($patient_id=null,$radiology_id=null,$order_id=null,$radiology_resultid=null){ 
		$this->uses=array('Patient','RadiologyTestOrder','RadiologyReport','RadiologyResult','Radiology','User','AdverseEventTrigger');
		if($this->params->query['conditionalFlag']=='conditionalFlag'){
			$conditionalFlag='conditionalFlag';
		}
		$this->set('conditionalFlag',$conditionalFlag);
		//for rad test name
		//get patient details
		$getBasicData=$this->Patient->find('first',array('fields'=>array('id','lookup_name','patient_id','admission_id'),
				'conditions'=>array('Patient.id'=>$patient_id)));
		$this->set('getBasicData',$getBasicData);
		
		$radNameResult =  $this->Radiology->read(array('name','cpt_code','lonic_code','sct_concept_id'),$radiology_id);
		$this->set('radiologyTestName',$radNameResult['Radiology']['name']);
		$radiologyDetails = $this->RadiologyTestOrder->read(null,$this->request->data['RadiologyResult']['radiology_test_order_id']);
		
		$rad_test_ID=$radiologyDetails['RadiologyTestOrder']['id'];
		//debug($this->request->data);exit;
		//save data
		if(!empty($this->request->data['RadiologyReport'])){
			$data  = $this->request->data ;
			$result =true ;
			//insert result publish date.
			
			if(!empty($this->request->data['RadiologyResult']['result_publish_date'])){
					$this->request->data['RadiologyResult']['result_publish_date'] =
					$this->DateFormat->formatDate2STD($this->request->data['RadiologyResult']['result_publish_date'],Configure::read('date_format'));
			}else{
				$this->request->data['RadiologyResult']['result_publish_date'] =date("Y-m-d H:i:s");
			}

				
			$this->request->data['RadiologyResult']['modified_by'] = $this->Session->read('userid');
			$this->request->data['RadiologyResult']['modify_time'] = date("Y-m-d H:i:s");
			
			//EOF result date
			if(isset($this->request->data['RadiologyResult']['id']) && !empty($this->request->data['RadiologyResult']['id'])){
				//update
				$radioResult = $this->RadiologyResult->save($this->request->data['RadiologyResult']);
				$this->RadiologyResult=$this->request->data['RadiologyResult']['id'];
				$RadiologyResultID = $this->request->data['RadiologyResult']['id'];

				/*if($this->request->data['RadiologyResult']['confirm_result']!='1'){
					$status="Pending";
				}else if($this->request->data['RadiologyResult']['confirm_result']=='1'){
					$status="Completed";
				}*/
				
			}else{
				// save
				$radioResult = $this->RadiologyResult->save($this->request->data['RadiologyResult']);
				$RadiologyResultID = $this->RadiologyResult->getLastInsertID();
				if($this->request->data['RadiologyResult']['result_publish_date']==''){
					$status="Pending";
				}else if($this->request->data['RadiologyResult']['result_publish_date']!=''){
					$status="Completed";
				}
				$this->RadiologyTestOrder->updateAll(array('RadiologyTestOrder.status'=>"'$status'"),array('RadiologyTestOrder.id'=>$rad_test_ID));
			}
			
			//BOF image upload
			$showError ='';
			if(!empty($data['RadiologyReport']['file_name'][0]['name']) || is_array($data['RadiologyReport']['file_name'])){
				$cntrad=0;
				foreach($data['RadiologyReport']['file_name'] as $key=>$uploadFiles){
					if(is_array($uploadFiles)){
						if($uploadFiles['name']) {
							$original_image_extension  = explode(".",$uploadFiles['name']);
							if(!isset($original_image_extension[1])){
								$imagename= $uploadFiles['name']."__".mktime().'.'.$original_image_extension[0];
								$imagedescription[] = $data['RadiologyReport']['description'][0];
								echo $cntrad;
								echo "ttt".$data['RadiologyReport']['description'][$cntrad];
							}else{
								$imagename= $original_image_extension[0]."__".mktime().'.'.$original_image_extension[1];
							}

						  
							$requiredArray  = array('data' =>array('Radiology'=>array('file_name'=>$uploadFiles,'description'=>$data['RadiologyReport']['description'][$cntrad])));
							$showError = $this->ImageUpload->uploadFile($requiredArray,'file_name','uploads/radiology',$imagename,2048);
							
							if($showError){
							}
						}
						// file name is not null in table so here we put default value //
						if(empty($imagename)) {
							$imagename = '';
								
						}
						if(empty($data['RadiologyReport']['description'][$cntrad]))
						{
							$desc="";
						}
						else
						{
							$desc=$data['RadiologyReport']['description'][$cntrad];
						}
						$this->request->data["RadiologyReport"]['patient_id']  = $patient_id ;
						$this->request->data["RadiologyReport"]['radiology_id']  = $radiology_id ;
						$this->request->data["RadiologyReport"]['file_name']  = $imagename ;
						$this->request->data["RadiologyReport"]['description']  = $desc ;
						$this->request->data["RadiologyReport"]['create_time'] = $radiologyDetails['RadiologyTestOrder']['start_date']." 00:00:00";
						if(empty($showError)) {
							//first insert record in radiology_results table
							$result = $this->RadiologyReport->insertReports($this->request->data,$RadiologyResultID) ;
							$cntrad++;
							
							if($result){
								$this->Session->setFlash(__('Record added successfully'),true,array('class'=>'message'));
							}
						}else{
							$this->Session->setFlash(__('There is problem while uploading file/record,Please try again'),true,array('class'=>'error'));
						}
					}

				}
					
					
			}
			// atleast one entry for main table in radiologyreport //
			if(empty($data['RadiologyReport']['file_name'][0]['name']) && !is_array($data['RadiologyReport']['file_name'])){
				$this->request->data["RadiologyReport"]['file_name']  = "";
				$result = $this->RadiologyReport->insertReports($this->request->data,$RadiologyResultID) ;
			}
			if($radioResult && (empty($showError))){
				$this->Session->setFlash(__('Record added successfully'),true,array('class'=>'message'));
			}
			if(!$result)
			{
				$this->Session->setFlash(__('Please try again'),true,array('class'=>'error'));
				//$this->redirect($this->referer());
			}else{
				$this->redirect(array('action'=>'radDashBoard','?'=>array('conditionalFlag'=>$conditionalFlag)));
			}
			//EOF image upload
		}
		
		
		$this->RadiologyReport->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey'=>'radiology_id' ),
						'RadiologyResult'=>array('foreignKey'=>'radiology_result_id')
				)),false);
	
		
		$data = $this->RadiologyReport->find('all',array('fields'=>array(
								'RadiologyResult.user_id','RadiologyResult.id','RadiologyResult.note','RadiologyResult.split',
								'RadiologyResult.confirm_result','RadiologyResult.result_publish_date','RadiologyResult.img_impression','RadiologyResult.advice',
								'RadiologyReport.id','RadiologyReport.file_name','Radiology.id','Radiology.name'),
								'conditions'=>array('RadiologyReport.patient_id'=>$patient_id,'RadiologyResult.radiology_test_order_id'=>$order_id,
								'Radiology.id'=>$radiology_id,'Radiology.is_active'=>1,'RadiologyReport.is_deleted'=>0),'recursive'=>1));
			
		//$doctorList = $this->User->getRadiologist();
		//$doctorList = $this->User->getAllDoctorList();
		$pathFields = array('User.full_name') ;
		$this->set(array('data'=>$data,'patient_id'=>$patient_id,'rad_test_order_id'=>$order_id,'doctorList'=>$doctorList));
			
	}
	//function for doctor's view and note
	function radiology_doctor_view($patient_id=null,$radiology_id=null,$order_id=null){
		$this->uses=array('Patient','RadiologyTestOrder','RadiologyReport','RadiologyResult','RadiologyDoctorNote','Radiology','User');
		
		if($this->params->query['conditionalFlag']=='conditionalFlag'){
			$conditionalFlag='conditionalFlag';
		}
		$this->set('conditionalFlag',$conditionalFlag);
		$getBasicData=$this->Patient->find('first',array('fields'=>array('id','lookup_name','patient_id','admission_id'),
				'conditions'=>array('Patient.id'=>$patient_id)));
		$this->set('getBasicData',$getBasicData);
		
		if(!empty($radiology_id)){
			$this->request->data = array('Radiology'=>array('radiology_id' => $radiology_id));
		}
		//for rad test name
		$radNameResult =  $this->Radiology->read('name',$radiology_id);
		$this->set('radiologyTestName',$radNameResult['Radiology']['name']);
		//save data
		if(!empty($this->request->data['RadiologyDoctorNote'])){
			$radioResult = $this->RadiologyDoctorNote->insertDoctorsNote($this->request->data);

			if($radioResult){
				$this->Session->setFlash(__('Record added successfully'),true,array('class'=>'message'));
				$this->redirect(array('action'=>'radiology_test_list',$patient_id));
			}else{
				$this->Session->setFlash(__('Please try again'),true,array('class'=>'error'));
			}
		}
		 
		$this->RadiologyReport->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey'=>'radiology_id' ),
						'RadiologyResult'=>array('foreignKey'=>'radiology_result_id'),
				)),false);
			

		$data = $this->RadiologyReport->find('all',array('fields'=>array('RadiologyResult.id','RadiologyResult.user_id','RadiologyResult.result_publish_date','RadiologyResult.id',
				'RadiologyResult.note','RadiologyResult.split','RadiologyResult.img_impression','RadiologyResult.advice','RadiologyReport.id','RadiologyReport.file_name' ,'Radiology.id','Radiology.name'),
				'conditions'=>array('RadiologyReport.patient_id'=>$patient_id,
						'Radiology.id'=>$this->request->data['Radiology']['radiology_id'],'Radiology.is_active'=>1,'RadiologyReport.is_deleted'=>0),'recursive'=>1));

		$queryRes =$this->RadiologyDoctorNote->find('first',array('fields'=>array('id','note'),'conditions'=>array('patient_id'=>$patient_id,'radiology_id'=>$radiology_id)));
		$pathFields = array('User.full_name') ;
		$radiologist = $this->User->getUserByID($data[0]['RadiologyResult']['user_id'],$pathFields);

		$this->set(array('data'=>$data,'patient_id'=>$patient_id,'doctorNote'=>$queryRes['RadiologyDoctorNote'],'rad_test_order_id'=>$order_id,'radiologist'=>$radiologist));
		$this->render('radiology_doctor_view');
	}

	//function to dispaly list of test list
	function radiology_test_list($patient_id=null){
		$this->uses = array('Person','Patient','Consultant','User','RadioManager','RadiologyResult','RadiologyReport');
		if(!empty($patient_id)){
			$data1 = $this->RadiologyReport->find('all',array('fields'=>array('RadiologyReport.id','RadiologyReport.patient_id','RadiologyReport.file_name','RadiologyReport.description'),
					'conditions'=>array('RadiologyReport.patient_id'=>$patient_id)));
			//debug($data1);
			//echo "wewbroot".$this->webroot;
			for($a=0;$a<count($data1);$a++){
				//$b[]='"../../uploads/radiology/'.$data1[$a][RadiologyReport][file_name].'"';
				$b[]='"'.$this->webroot.'uploads/radiology/'.$data1[$a][RadiologyReport][file_name].'"';
				$c[]='"'.$data1[$a]['RadiologyReport']['description'].'"';
			}
			//debug($b);
			$this->set('data1',$data1);
			$this->set('b',$b);
			$this->set('c',$c);
			//debug($c);
			//BOF referer link
			$sessionReturnString = $this->Session->read('radResultReturn') ;
			$currentReturnString = $this->params->query['return'] ;
			if(($currentReturnString!='') && ($currentReturnString != $sessionReturnString) ){
				$this->Session->write('radResultReturn',$currentReturnString);
			}
			//EOF referer link
			$this->patient_info($patient_id);

			$this->RadioManager->bindModel(array(
					'belongsTo' => array(
							'Radiology'=>array('type'=>'inner','foreignKey'=>'radiology_id','conditions'=>array('Radiology.is_active'=>1))
					),
					'hasOne' => array(
							'RadiologyResult'=>array('foreignKey'=>'radiology_test_order_id')
					)),false);
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'fields'=>array('RadiologyResult.id', 'RadiologyResult.result_publish_date','RadiologyResult.confirm_result','RadioManager.id','RadioManager.start_date','RadioManager.patient_id','RadioManager.order_id','Radiology.id','Radiology.name','RadioManager.radiology_order_date'),
					'conditions'=>array('RadioManager.patient_id'=>$patient_id,'RadioManager.is_deleted'=>0),
					'order' => array(
							'RadioManager.id' => 'asc'
					),
					'group'=>array('Radiology.id')
			);
			$testOrdered   = $this->paginate('RadioManager');
			$this->set(array('testOrdered'=>$testOrdered));
			/*if($this->Session->read('role')=='doctor'){
			 $this->render('doctor_test_list');
			}*/ //commented by doctyor
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
	}



	function radiology_result($patient_id =null,$radiology_id=null,$order_id=null){
		$this->uses = array('Person','RadiologyResult','Patient','Consultant','User','RadiologyTestOrder','RadiologyReport','Radiology' );
		if(!empty($patient_id)){

			$data1 = $this->RadiologyReport->find('all',array('fields'=>array('RadiologyReport.id','RadiologyReport.patient_id','RadiologyReport.file_name'),
					'conditions'=>array('RadiologyReport.patient_id'=>$patient_id)));
			//debug($data1);
			//echo "wewbroot".$this->webroot;
			for($a=0;$a<count($data1);$a++){
				//$b[]='"../../uploads/radiology/'.$data1[$a][RadiologyReport][file_name].'"';
				$b[]='"'.$this->webroot.'uploads/radiology/'.$data1[$a][RadiologyReport][file_name].'"';
			}
			$this->set('data1',$data1);
			$this->set('b',$b);
			$this->patient_info($patient_id);
			//test assign to patient
			$testDetails = $this->RadiologyTestOrder->find('first',array('fields'=>array('id','patient_id','radiology_id'),'conditions'=>array('patient_id'=>$patient_id)));
	 		
			if(!empty($testDetails['RadiologyTestOrder']['radiology_id'])){

				$testArray = $testDetails['RadiologyTestOrder']['radiology_id'];
				$this->RadiologyTestOrder->bindModel(array(
						'belongsTo' => array(
								'Radiology'=>array('foreignKey'=>'radiology_id' )
						)),false);
				$testOrdered = $this->RadiologyTestOrder->find('list',array('fields'=>array('Radiology.id','Radiology.name'),'conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id,'RadiologyTestOrder.is_deleted'=>0),'recursive'=>1));
	
				if(!empty($radiology_id)){
					$this->request->data = array('Radiology'=>array('radiology_id' => $radiology_id));
					$this->Session->write('radiology_id',$radiology_id);
				}else if(isset($this->request->data['Radiology']['radiology_id'])){
					$this->Session->write('radiology_id',$this->request->data['Radiology']['radiology_id']);
				}
				//add radiology in session
				//For radiology template

				//test attributs
				if(isset($this->request->data['Radiology']['radiology_id'])){
						
					$testId = $this->data['Radiology']['radiology_id'] ;
					if(!empty($testId)){
						$labResult =  $this->RadiologyReport->find('all',array('conditions'=>array('RadiologyReport.patient_id'=>$patient_id,'radiology_id'=>$testId,'is_deleted'=>0)));
					}
				}else if(isset($this->request->data['RadiologyResult'])){
					if($this->RadiologyResult->insertLabResults($this->request->data)){
						$this->Session->setFlash(__('Lab result save successfully'),'default',array('class'=>'message'));
						$this->redirect($this->referer());
					}else{
						$this->Session->setFlash(__('There is some problem , please try again'),'default',array('class'=>'error'));
					}
				}
			}else{
				$testOrdered ='';
			}
			//check for result
			$radioResult = $this->RadiologyResult->find('first',array('conditions'=>array(
					'RadiologyResult.patient_id'=>$patient_id,'RadiologyResult.radiology_test_order_id'=>$order_id)));
				
			$pathFields = array('User.full_name') ;
			$radiologist = $this->User->getUserByID($radioResult['RadiologyResult']['user_id'],$pathFields);
			$this->set(array('testOrdered'=>$testOrdered,'rad_test_order_id'=>$order_id,'result'=>$radioResult,'radiologist'=>$radiologist));
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
	}

	function incharge_radiology_result($patient_id =null,$radiology_id=null,$order_id=null, $radiology_resultid=null){
		$this->radiology_result($patient_id ,$radiology_id,$order_id) ;
		$this->uses=array('Patient','RadiologyTestOrder','RadiologyReport','RadiologyResult','Radiology','User');
		//for rad test name
		//code added by Harshal for
		$data1 = $this->RadiologyReport->find('all',array('fields'=>array('RadiologyReport.id','RadiologyReport.patient_id','RadiologyReport.file_name','RadiologyReport.description'),
				'conditions'=>array('RadiologyReport.patient_id'=>$patient_id)));


		$radiologyDetails = $this->RadiologyTestOrder->read(null,$order_id);

		for($a=0;$a<count($data1);$a++){
			//$b[]= '"../../../../uploads/radiology/'.$data1[$a][RadiologyReport][file_name].'"';
			$b[]='"'.$this->webroot.'uploads/radiology/'.$data1[$a][RadiologyReport][file_name].'"';
			$c[]='"'.$data1[$a]['RadiologyReport']['description'].'"';
		}
		//debug($b);
		$this->set('data1',$data1);
		$this->set('b',$b);
		$this->set('c',$c);

		$radNameResult =  $this->Radiology->read(array('name'),$radiology_id);
		$this->set('radiologyTestName',$radNameResult['Radiology']['name']);
		if(!empty($radiology_id)){
			$this->request->data = array('Radiology'=>array('radiology_id' => $radiology_id));
		}
		//save data
		if(!empty($this->request->data['RadiologyReport'])){

			$data  = $this->request->data ;
			$result =true ;
			//insert result publish date.
			if($this->request->data['RadiologyResult']['confirm_result']==1){
				//set publish date
				$this->request->data['RadiologyResult']['result_publish_date'] =
				$this->DateFormat->formatDate2STD($this->request->data['RadiologyResult']['result_publish_date'],Configure::read('date_format'));
			}else{
				$this->request->data['RadiologyResult']['result_publish_date'] ='';
			}
			$this->request->data['RadiologyResult']['modified_by'] = $this->Session->read('userid');
			$this->request->data['RadiologyResult']['modify_time'] = date("Y-m-d H:i:s");
			//EOF result date
				
				
				
				
			$radioResult = $this->RadiologyResult->save($this->request->data['RadiologyResult']);
			$RadiologyResultID = $this->RadiologyResult->getLastInsertID();

			if(empty($RadiologyResultID)){
				$RadiologyResultID = $this->request->data['RadiologyResult']['id'];
			}
			
			//BOF image upload
			$showError ='';
			if(!empty($data['RadiologyReport']['file_name'][0]['name'])){
				foreach($data['RadiologyReport']['file_name'] as $uploadFiles){
					if(is_array($uploadFiles)){
						$original_image_extension  = explode(".",$uploadFiles['name']);
						if(!isset($original_image_extension[1])){
							$imagename= $uploadFiles['name']."__".mktime().'.'.$original_image_extension[0];
						}else{
							$imagename= $original_image_extension[0]."__".mktime().'.'.$original_image_extension[1];
						}
						$requiredArray  = array('data' =>array('Radiology'=>array('file_name'=>$uploadFiles)));
							
						$showError = $this->ImageUpload->uploadFile($requiredArray,'file_name','uploads/radiology',$imagename);

						$this->request->data["RadiologyReport"]['file_name']  = $imagename ;
							//debug($showError);exit;

						if(empty($showError)) {
							//first insert record in radiology_results table
							$this->request->data['RadiologyReport']['create_time']=$radiologyDetails['RadiologyTestOrder']['start_date']. ' 00:00:00';
							$result = $this->RadiologyReport->insertReports($this->request->data,$RadiologyResultID) ;
							if($result){
								$this->Session->setFlash(__('Record added successfully'),true,array('class'=>'message'));
							}
						}else{
							$this->Session->setFlash(__('There is problem while uploading file/record,Please try again'),true,array('class'=>'error'));
						}
					}
				}
			}
			
			if($radioResult && (empty($showError))){
				$this->Session->setFlash(__('Record added successfully'),true,array('class'=>'message'));
			}
			if(!$result)
			{
				$this->Session->setFlash(__('Please try again'),true,array('class'=>'error'));
				//$this->redirect($this->referer());
			}else{
				$this->redirect(array('action'=>'radiology_test_list',$patient_id,$radiology_id));
			}
			//EOF image upload
		}
		 
		$this->RadiologyReport->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey'=>'radiology_id' ),
						'RadiologyResult'=>array('foreignKey'=>'radiology_result_id')
				)),false);
			
		$data = $this->RadiologyReport->find('all',array('fields'=>array('RadiologyResult.user_id','RadiologyResult.result_publish_date','RadiologyResult.img_impression','RadiologyResult.advice','RadiologyResult.id','RadiologyResult.note','RadiologyResult.split','RadiologyResult.confirm_result','RadiologyReport.id','RadiologyReport.file_name','RadiologyReport.description','RadiologyReport.patient_id' ,'Radiology.id','Radiology.name'),
				'conditions'=>array('RadiologyReport.patient_id'=>$patient_id,'RadiologyResult.radiology_test_order_id'=>$order_id,
						'Radiology.id'=>$this->request->data['Radiology']['radiology_id'],'Radiology.is_active'=>1,'RadiologyReport.is_deleted'=>0),'recursive'=>1));

		$radiologist = $this->User->getRadiologist();

		$pathFields = array('User.full_name') ;
		$this->set(array('data'=>$data,'patient_id'=>$patient_id,'rad_test_order_id'=>$order_id,'radiologist'=>$radiologist));

			
	}

	//funtion to allow doctor to add comment aftert radiology result has been published
	function add_comment($patient_id =null,$radiology_id=null,$order_id=null){
		$this->radiology_result($patient_id,$radiology_id,$order_id);
		$this->uses=array('Patient','RadiologyTestOrder','RadiologyReport','RadiologyResult','Radiology','User');
		$data1 = $this->RadiologyReport->find('all',array('fields'=>array('RadiologyReport.id','RadiologyReport.patient_id','RadiologyReport.file_name','RadiologyReport.description'),
				'conditions'=>array('RadiologyReport.patient_id'=>$patient_id)));
		 
		for($a=0;$a<count($data1);$a++){
			//$b[]= '"../../../../uploads/radiology/'.$data1[$a][RadiologyReport][file_name].'"';
			$b[]='"'.$this->webroot.'uploads/radiology/'.$data1[$a][RadiologyReport][file_name].'"';
			$c[]='"'.$data1[$a]['RadiologyReport']['description'].'"';
		}
		//debug($b);
		$this->set('data1',$data1);
		$this->set('b',$b);
		$this->set('c',$c);
	}

	//function to delete radiology report
	function delete_report($patient_id=null,$radiology_id=null,$radiology_report_id=null,$order_id=null){

		if(!empty($patient_id) && !empty($radiology_id) && !empty($radiology_report_id)){
			$this->uses = array('RadiologyReport');
			$queryRes = $this->RadiologyReport->read(array('file_name'),$radiology_report_id);

			$this->RadiologyReport->id = $radiology_report_id ;
			//$isRename = rename("uploads/radiology/".$queryRes['RadiologyReport']['file_name'], "uploads/radiology/"."inactive_".$queryRes['RadiologyReport']['file_name']);
			$isRename = unlink("uploads/radiology/".$queryRes['RadiologyReport']['file_name']);
			if($isRename){
				//$result  = $this->RadiologyReport->save(array('is_deleted'=>1));
				$this->RadiologyReport->id = $radiology_report_id;
				$result  = $this->RadiologyReport->delete();
			}else{
				$this->Session->setFlash(__('There is some problem while deleting record, please try again'),'default',array('class'=>'error'));
				$this->redirect(array('action'=>'incharge_radiology_result',$patient_id,$radiology_id,$order_id));
			}
			if($result){
				$this->Session->setFlash(__('Record deleted successfully'),'default',array('class'=>'message'));
				$this->data = array('Radiology'=>array('radiology_id'=>$radiology_id));
				$this->redirect(array('action'=>'incharge_radiology_result',$patient_id,$radiology_id,$order_id));
			}
		}else{
			$this->Session->setFlash(__('There is some problem , please try again'),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'incharge_radiology_result',$patient_id,$radiology_id,$order_id));
				
		}
	}

	function admin_template($template_id=null){
		$this->layout= "advance";
		$this->uses = array('RadiologyTemplate');
		$this->set('title_for_layout', __('Radiology Templates', true));
		$this->RadiologyTemplate->bindModel(array(
				'belongsTo' => array(
						'Radiology' =>array( 'foreignKey'=>'radiology_id','type'=>'inner'),
				)),false);
		
		$radCondition = array();
		if(!empty($this->request->data['rad_id'])) {
			/*$result = $this->Radiology->find('all', array('fields'=> array('id'), 'conditions'=> array('id'=>$this->data['rad_id'])));
			foreach($result as $radiology_ids) {
				$rad_id[] = $radiology_ids['Radiology']['id'];
			}*/
			$radCondition['RadiologyTemplate.radiology_id'] = $this->request->data['rad_id'];
		}

		$this->paginate = array(
				'evalScripts' => true,
				'limit' => Configure::read('number_of_rows'),
				'conditions' => array('RadiologyTemplate.is_deleted' => 0,
						'RadiologyTemplate.user_id'=>0,'RadiologyTemplate.location_id'=>$this->Session->read('locationid'),$radCondition ),
				'order' => array('Radiology.name' => 'asc'),
				'fields'=>array('RadiologyTemplate.*','Radiology.name','Radiology.id')

		);



		$data = $this->paginate('RadiologyTemplate');
		if($template_id){
			$this->data  = $this->RadiologyTemplate->read(null,$template_id);
			$this->set(array('template_id'=>$template_id));
		   
		}
		//list all radiology tests
		//$testList = $this->Radiology->find('list',array('conditions'=>array('is_active'=>1,'location_id'=> $this->Session->read('locationid')),'fields'=>array('name')));
		 
		$this->set(array('data'=>$data,/* 'testList'=>$testList */));
	}

	function admin_templatelist($radiology_id=null){
		$this->uses = array('RadiologyTemplate');
		$this->set('title_for_layout', __('Radiology Templates', true));
		$this->RadiologyTemplate->bindModel(array(
				'belongsTo' => array(
						'Radiology' =>array( 'foreignKey'=>'radiology_id'),
				)),false);

		if(isset($radiology_id)) {

			$condition = array('RadiologyTemplate.radiology_id' => $radiology_id);
		}
		$this->paginate = array(
				'evalScripts' => true,
				'limit' => Configure::read('number_of_rows'),
				'conditions' => array('RadiologyTemplate.is_deleted' => 0,
						'RadiologyTemplate.user_id'=>0,'RadiologyTemplate.location_id'=>$this->Session->read('locationid'), $condition),
				'fields'=>array('RadiologyTemplate.*','Radiology.name')

		);
		$data = $this->paginate('RadiologyTemplate');
		//list all radiology tests
		//$testList = $this->Radiology->find('list',array('conditions'=>array('is_active'=>1,'location_id'=> $this->Session->read('locationid')),'fields'=>array('name')));
			
		$this->set(array('data'=>$data,'testList'=>$testList));
		$this->set('radiology_id', $radiology_id);
	}

	

	//add template from admin section
	public function admin_template_add(){
		$this->uses = array('RadiologyTemplate');
		if (!empty($this->request->data['RadiologyTemplate'])) {
			$this->RadiologyTemplate->insertGeneralTemplate($this->request->data,'insert');
			$this->Session->setFlash(__('Radiology template have been saved', true, array('class'=>'message')));
			$this->redirect(array('action'=>'template','admin'=>true));
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			$this->redirect($this->referer());
		}
	}
	 
	public function admin_template_delete($id=null,$radId){
		$this->uses = array('RadiologyTemplate','RadiologyTemplateText');

		if(!empty($id)){
			$this->RadiologyTemplate->id= $id ;
			$this->RadiologyTemplate->save(array('is_deleted'=>1));
			$this->RadiologyTemplateText->updateAll(array('is_deleted'=>1),array('template_id'=>$id));
			$this->Session->setFlash(__('Radiology template have been deleted', true, array('class'=>'message')));
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
		}
		$this->redirect("/radiologies/template_add/radiology/null/".$radId);
	}

	//add template text from admin section
	public function admin_template_index($template_id=null,$template_text_id=null){
		$this->uses = array('RadiologyTemplateText','RadiologyTemplate');
		$radiologyId = $this->params->query['radiologyId'];
		$result = $this->Radiology->find('first', array('fields'=> array('id','name'), 'conditions'=> array('Radiology.id'=>$radiologyId)));
		if(!empty($template_id)){
			
			$this->set('title_for_layout', __('Template Text ', true));
			
			$this->paginate = array(
					'evalScripts' => true,
					'limit' => Configure::read('number_of_rows'),
					'conditions' => array('RadiologyTemplateText.is_deleted' => 0,'RadiologyTemplateText.template_id'=>$template_id)
			);
			$data = $this->paginate('RadiologyTemplateText');
			if($template_text_id){
				$this->data  = $this->RadiologyTemplateText->read(null,$template_text_id);
			}
			$template_name = $this->RadiologyTemplate->read(array('template_name'),$template_id);
			$this->set(array('data'=>$data,'template_id'=>$template_id,'template_name'=>$template_name['RadiologyTemplate']['template_name'],'result'=>$result));
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			$this->redirect($this->referer());
		}
	}
	 
	//add template from admin section
	public function admin_template_text_add(){
		$this->uses = array('RadiologyTemplateText');
		 
		if (!empty($this->request->data['RadiologyTemplateText'])) {
			$this->RadiologyTemplateText->insertTemplateText($this->request->data,'insert');
			$this->Session->setFlash(__('Template text have been saved', true, array('class'=>'message')));
			//$this->redirect($this->referer());
			$this->redirect(array('action'=>'admin_template_index',$this->request->data['RadiologyTemplateText']['template_id'],'?'=>array('radiologyId'=>$this->request->data['RadiologyTemplateText']['radiology_id'])));
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			$this->redirect($this->referer());
		}
	}
	 
	//edittemplate from admin section
	public function admin_template_text_edit(){
		$this->uses = array('RadiologyTemplateText');
		if (!empty($this->request->data['RadiologyTemplate'])) {
			$this->RadiologyTemplateText->insertTemplateText($this->request->data,'insert');
			$this->Session->setFlash(__('template text have been saved', true, array('class'=>'message')));
			$this->redirect($this->referer());
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			$this->redirect($this->referer());
		}
	}
	 
	public function admin_template_text_delete($id=null){
		$this->uses = array('RadiologyTemplateText');
		if(!empty($id)){
			$this->RadiologyTemplateText->id= $id ;
			$this->RadiologyTemplateText->save(array('is_deleted'=>1));
			$this->Session->setFlash(__('Radiology template text have been deleted', true, array('class'=>'message')));
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
		}
		$this->redirect($this->referer());
	}

	//BOF radiology template

	public function radiology_template($updateID=null,$flag=null) {		
		$this->layout = 'ajax';
		$this->uses = array('RadiologyTemplate');
		//BOF-Mahalaxmi for adding radiology id
		if(is_numeric($flag)){
			$radiology_id=$this->Session->read('radiology_id');
			if(empty($radiology_id))
				$radiologyId=$flag;
			else
				$radiologyId=$radiology_id;
			
				$this->request->data['RadiologyTemplate']['radiology_id'] = $radiologyId;
		}
		//EOF-Mahalaxmi for adding radiology id
		if (!empty($this->request->data['RadiologyTemplate'])) {			
			$this->request->data['RadiologyTemplate']['user_id'] = $this->Auth->user('id');
			$this->request->data['RadiologyTemplate']['location_id'] = $this->Session->read('locationid');
			$this->request->data['RadiologyTemplate']['created_by'] = $this->Auth->user('id');
			$this->request->data['RadiologyTemplate']['create_time'] = date("Y-m-d H:i:s");			
			$this->RadiologyTemplate->save($this->request->data);
			$this->Session->setFlash(__('Radiolody template have been saved', true, array('class'=>'message')));
			$this->redirect("/radiologies/template_add/radiology/null/".$updateID."/".$flag);
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			$this->redirect("/radiologies/template_add/radiology");
		}
	}
	/**
	 *
	 * @param $templateType
	 * @param $template_id
	 * @return unknown_type
	 */
	public function template_add($templateType=null,$template_id=null,$updateID=null,$radiology_id=null){	
		//	 $this->layout = 'ajax';
		$this->uses = array('RadiologyTemplate','Location');
		$this->set('title_for_layout', __('Radiology  Templates', true));
		$this->RadiologyTemplate->recursive = -1;
		if(!empty($_POST['searchStr'])){
			$strKey['RadiologyTemplate.template_name like '] = "%".$_POST['searchStr']."%";
		}else{
			$strKey ='';
		}
		//retrive all the location of logged in user's hospital
		$locationArr = $this->Location->find('list',array('fields'=>array('id')));
		 
		/* $data = $this->RadiologyTemplate->find('all',array('conditions' => array('location_id'=>$this->Session->read('locationid'),'radiology_id'=>$this->Session->read('radiology_id'),
		 'RadiologyTemplate.is_deleted' => 0,"(RadiologyTemplate.user_id  = ".$this->Session->read('userid')." OR
		 		RadiologyTemplate.user_id  = 0) ",'RadiologyTemplate.location_id IN ('.implode(",",$locationArr).')',$strKey)));*/
			
		$conditionsRad=array('location_id'=>$this->Session->read('locationid'),'RadiologyTemplate.is_deleted' => 0,/*"(RadiologyTemplate.user_id  = ".$this->Session->read('userid')." OR
			RadiologyTemplate.user_id  = 0) ",*/$strKey);
		
		
		$conditionsRad['RadiologyTemplate.radiology_id'] = $radiology_id;
		
		$data = $this->RadiologyTemplate->find('all',array('conditions' =>$conditionsRad));
		
		$this->set(array('data'=>$data,'template_type'=>$templateType,'updateID'=>"templateArea-".$templateType,'labID'=>$radiology_id));
		if(!empty($template_id)){
			$this->data = $this->RadiologyTemplate->read(null,$template_id);
		}
		 
		$this->render('template_add');
	}

	/**
	 * fucntion to search template
	 * @param $templateType
	 * @param $template_id
	 * @return unknown_type
	 */
	public function template_search($templateType=null){
		//	 $this->layout = 'ajax';
		$this->uses = array('RadiologyTemplate');
		 
		$this->RadiologyTemplate->recursive = -1;
		 
		if(!empty($_POST['searchStr'])){
			$strKey['RadiologyTemplate.template_name like '] = "%".$_POST['searchStr']."%";
		}else{
			$strKey ='';
		}
		 
		$data = $this->RadiologyTemplate->find('all',array('conditions' => array(/*'radiology_id'=>$this->Session->read('radiology_id'),*/'RadiologyTemplate.is_deleted' => 0,
				"(RadiologyTemplate.user_id  = ".$this->Session->read('userid')." OR
				RadiologyTemplate.user_id  = 0) " ,$strKey)));
		 
		$this->set(array('data'=>$data,'template_type'=>$templateType,'updateID'=>"templateArea-".$templateType));
		if(!empty($template_id)){
			$this->data = $this->RadiologyTemplate->read(null,$template_id);
		}
	}

	/**
	 * fucntion to search template
	 * @param $templateType
	 * @param $template_id
	 * @return unknown_type
	 */
	public function template_text_search($template_id=null,$templateType=null){
		$this->uses = array('RadiologyTemplate','RadiologyTemplateText');
		//$this->layout = 'ajax';

		if(!empty($_POST['searchStr'])){
			$strKey['RadiologyTemplateText.template_text like '] = "%".$_POST['searchStr']."%";
		}else{
			$strKey ='';
		}
		 
		$data = $this->RadiologyTemplateText->find('all',array('conditions' => array('radiology_id'=>$this->Session->read('radiology_id'),'RadiologyTemplateText.is_deleted' => 0,'RadiologyTemplateText.template_id'=>$template_id,$strKey)));
		//retrive template details
		// $this->RadiologyTemplate->recursive = -1;
		$templateData = $this->RadiologyTemplate->read(null,$template_id);
		$this->set(array('data'=>$data,'template_id'=>$template_id,'template_data'=>$templateData,
				'updateID'=>"templateArea-radiology"));
		 
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
		//$this->layout = 'ajax';
		$this->uses = array('RadiologyTemplateText','RadiologyTemplate');
		$this->RadiologyTemplate->recursive = -1;
		$this->set('emptyText',false);
	  
		if(!empty($this->request->data)){		
			if(empty($this->request->data['RadiologyTemplateText']['template_text'])){
				$this->Session->setFlash(__('Please enter template text', true, array('class'=>'error')));
				$this->set('emptyText',true);
				if(!$template_id)  $template_id = $this->request->data['RadiologyTemplateText']['template_id'];
			}else{
				$result = $this->RadiologyTemplateText->insertTemplateText($this->request->data);
				$errors = $this->RadiologyTemplateText->invalidFields();
				if(!empty($errors)) {
					$this->set("errors", $errors);
				}else{
					$this->Session->setFlash(__('Template saved', true, array('class'=>'message')));
					$this->redirect(array('action'=>'add_template_text',$this->request->data['RadiologyTemplateText']['template_id']));
				}
			}
		}
		if(!empty($template_text_id)){
			$this->set('emptyText',true);//to display edit form for template text
			$this->data = $this->RadiologyTemplateText->read(null,$template_text_id);
		}
	  
		$data = $this->RadiologyTemplateText->find('all',array('conditions' => array('RadiologyTemplateText.is_deleted' => 0,'RadiologyTemplateText.template_id'=>$template_id)));
		//retrive template details
		$templateData = $this->RadiologyTemplate->read(null,$template_id);
		$this->set(array('data'=>$data,'template_id'=>$template_id,'template_data'=>$templateData,
				'updateID'=>"templateArea-radiology"));
	}



	public function template_edit($id=null) {
		$this->layout = 'ajax';
		$this->uses = array('RadiologyTemplate');
		if (!empty($this->request->data['RadiologyTemplate'])) {

			$this->request->data['RadiologyTemplate']['user_id'] = $this->Auth->user('id');
			$this->request->data['RadiologyTemplate']['location_id'] = $this->Session->read('locationid');
			$this->request->data['RadiologyTemplate']['created_by'] = $this->Auth->user('id');
			$this->request->data['RadiologyTemplate']['create_time'] = date("Y-m-d H:i:s");
			$this->RadiologyTemplate->save($this->request->data);
			$this->Session->setFlash(__('Doctor template have been updated', true, array('class'=>'message')));
			$this->redirect("/radiologies/");
		}
		$this->RadiologyTemplate->recursive = -1;

		$data = $this->RadiologyTemplate->find('all',array('conditions' => array('radiology_id'=>$this->Session->read('radiology_id'),'RadiologyTemplate.is_deleted' => 0)));
		$this->set('data', $data);
		$this->data = $this->RadiologyTemplate->read(null,$id);
	}

	//EOF radiology template

	//BOF radiology OPD billing
	function radiology_test_done($id=null,$status=null){
		$this->uses  = array('RadiologyTestOrder');
		if($id){
			$this->RadiologyTestOrder->id = $id ;
			if($this->RadiologyTestOrder->save(array('test_done'=>$status))){
				$this->Session->setFlash(__('Record updated successfully', true, array('class'=>'error')));
				$this->redirect($this->referer());
			}else{
				$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
				$this->redirect($this->referer());
			}
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			$this->redirect($this->referer());
		}
	}
	//function returns list of patient whose receipts has to be generated
	function receipts(){
		$this->uses=array('Patient','RadiologyTestOrder');
		$this->set('data','');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'Patient.id' => 'asc'));
		 
		$role = $this->Session->read('role');
		$search_key['Patient.is_deleted'] = 0;
		$search_key['Radiology.location_id']=$this->Session->read('locationid');
		$search_key['RadiologyTestOrder.patient_id']=0;
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' ))
				)),false);
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey'=>'radiology_id','conditions'=>array('Radiology.is_active'=>1) ),
						'Patient'=>array('foreignKey'=>'patient_id'),
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
						'RadiologyTestPayment'=>array('type'=>'inner','foreignKey'=>false,'conditions'=>array('RadiologyTestPayment.patient_id=RadiologyTestOrder.patient_id'))
				)),false);

		$this->RadiologyTestOrder->bindModel(array(
				'hasOne' => array(
						'Initial' =>array('foreignKey' => false,'conditions'=>array('Initial.id=User.initial_id' ))
				)),false);
		if(!empty($this->params->query)){
			$search_ele = $this->params->query  ;//make it get

			if(!empty($search_ele['lab_test_name']) ){
				$search_key['Radiology.name'] = $search_ele['lab_test_name'] ;
			}
			if(!empty($search_ele['radiology_test_name']) ){
			}
			if(!empty($search_ele['histology_test_name']) ){
			}

			if(!empty($search_ele['lookup_name'])){
				$search_key['Patient.lookup_name like '] = "%".trim($search_ele['lookup_name'])."%" ;
			}if(!empty($search_ele['patient_id'])){
				$search_key['Patient.patient_id like '] = "%".trim($search_ele['patient_id']) ;
			}if(!empty($search_ele['admission_id'])){
				$search_key['Patient.admission_id like '] = "%".trim($search_ele['admission_id']) ;
			}

			if(!empty($search_ele['from']) && !empty($search_ele['to'])){
				 
				$formDate = $this->DateFormat->formatDate2STDForReport($search_ele['from'],Configure::read('date_format'));
				$toDate = $this->DateFormat->formatDate2STDForReport($search_ele['to'],Configure::read('date_format'));
				//$search_key['RadiologyTestOrder.create_time BETWEEN ? AND ? '] = array(trim($formDate),trim($toDate)) ;
				 
				// get record between two dates. Make condition
				$search_key['RadiologyTestOrder.create_time <='] = $toDate." 23:59:59" ;
				$search_key['RadiologyTestOrder.create_time >='] = $formDate ;
				 
				 
			}else if(!empty($search_ele['from'])){
				$search_key['RadiologyTestOrder.create_time > '] = "%".trim($search_ele['from']) ;
			}

			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('Patient.id' => 'asc'),
					'fields'=> array('Radiology.name,PatientInitial.name,Patient.lookup_name,RadiologyTestOrder.order_id,RadiologyTestOrder.id,RadiologyTestOrder.create_time,
							Patient.id,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time, Initial.name'),
					'conditions'=>$search_key,
					'group'=>array('Patient.id')
			);

			$this->set('data',$this->paginate('RadiologyTestOrder'));
		}else{

			//BOF New code
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('Patient.id' => 'asc'),
					'fields'=> array('Radiology.name,PatientInitial.name,Patient.lookup_name,RadiologyTestOrder.order_id,RadiologyTestOrder.test_done,RadiologyTestOrder.id,RadiologyTestOrder.create_time,
							Patient.id,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time, Initial.name'),
					'group'=>array('Patient.id'),
					'conditions'=>array('RadiologyTestOrder.is_deleted'=>0)
			);
			$this->RadiologyTestOrder->PaginateCount();
			$this->set('data',$this->paginate('RadiologyTestOrder'));
			//EOF new code
				
		}
	}

	//function returns list of patient whose receipts has to be generated
	function payment(){
		$this->uses=array('Patient','RadiologyTestOrder');
		$this->set('data','');
		$role = $this->Session->read('role');
		$search_key['Patient.is_deleted'] = 0;
		$search_key['Radiology.location_id']=$this->Session->read('locationid');
		$search_key['RadiologyTestOrder.is_deleted'] = 0;
		$search_key['RadiologyTestOrder.from_assessment'] = 0;
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' ))
				)),false);
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey'=>'radiology_id','conditions'=>array('Radiology.is_active'=>1) ),
						'Patient'=>array('foreignKey'=>'patient_id'),
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' ))
				)),false);
		$this->RadiologyTestOrder->bindModel(array(
				'hasOne' => array(
						'Initial' =>array('foreignKey' => false,'conditions'=>array('Initial.id=User.initial_id' ))
				)),false);
		 
		if(!empty($this->params->query)){
			$search_ele = $this->params->query  ;//make it get

			if(!empty($search_ele['lab_test_name']) ){
				$search_key['Radiology.name'] = $search_ele['lab_test_name'] ;
			}
			if(!empty($search_ele['radiology_test_name']) ){
			}
			if(!empty($search_ele['histology_test_name']) ){
			}

			if(!empty($search_ele['lookup_name'])){
				$search_key['Patient.lookup_name like '] = "%".trim($search_ele['lookup_name'])."%" ;
			}if(!empty($search_ele['patient_id'])){
				$search_key['Patient.patient_id like '] = "%".trim($search_ele['patient_id']) ;
			}if(!empty($search_ele['admission_id'])){
				$search_key['Patient.admission_id like '] = "%".trim($search_ele['admission_id']) ;
			}

			if(!empty($search_ele['from']) && !empty($search_ele['to'])){

				$formDate = $this->DateFormat->formatDate2STDForReport($search_ele['from'],Configure::read('date_format'));
				$toDate = $this->DateFormat->formatDate2STDForReport($search_ele['to'],Configure::read('date_format'));
				//$search_key['RadiologyTestOrder.create_time BETWEEN ? AND ? '] = array(trim($formDate),trim($toDate)) ;

				// get record between two dates. Make condition
				$search_key['RadiologyTestOrder.create_time <='] = $toDate." 23:59:59" ;
				$search_key['RadiologyTestOrder.create_time >='] = $formDate ;


			}else if(!empty($search_ele['from'])){
				$search_key['RadiologyTestOrder.create_time > '] = "%".trim($search_ele['from']) ;
			}

			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('RadiologyTestOrder.id' => 'desc'),
					'fields'=> array('Radiology.name,PatientInitial.name,Patient.lookup_name,RadiologyTestOrder.order_id,RadiologyTestOrder.id,RadiologyTestOrder.create_time,
							Patient.id,Patient.sex,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time, Initial.name'),
					'conditions'=>$search_key,
					'group'=>array('RadiologyTestOrder.patient_id')
			);
			$this->set('data',$this->paginate('RadiologyTestOrder'));
		}else{

			//BOF New code
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('RadiologyTestOrder.id' => 'desc'),
					'fields'=> array('Radiology.name,PatientInitial.name,Patient.lookup_name,RadiologyTestOrder.order_id,RadiologyTestOrder.id,RadiologyTestOrder.create_time,
							Patient.id,Patient.sex,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time, Initial.name'),
					'conditions'=>$search_key,
					'group'=>array('RadiologyTestOrder.patient_id')
			);

			$this->set('data',$this->paginate('RadiologyTestOrder'));
			//EOF new code

		}
	}

	function radiology_test_payment($patient_id=null){
			
		$this->uses = array('RadiologyTestOrder','RadiologyTestPayment');
		$this->set('patient_id',$patient_id);

		if(!empty($this->request->data)){
			//save data
			$this->request->data['RadiologyTestPayment']['location_id'] 	= $this->Session->read('locationid');
			$this->request->data['RadiologyTestPayment']['create_time'] 	= date("Y-m-d H:i:s");
			$this->request->data['RadiologyTestPayment']['created_by'] 	= $this->Session->read('userid');
			$totalPaidAmt = $this->request->data['RadiologyTestPayment']['paid_amount']+$this->request->data['RadiologyTestPayment']['before_paid'] ;
			if($this->request->data['RadiologyTestPayment']['paid_amount'] ==0 || empty($this->request->data['RadiologyTestPayment']['paid_amount']) ||
					$totalPaidAmt > $this->request->data['RadiologyTestPayment']['total_amount']){
				$this->Session->setFlash(__('Please enter valid amount'),'default',array('class'=>'error'));
				$this->redirect($this->referer());
			}
			//checking if paid amt is equal to total amount
			$chPayment  = $this->RadiologyTestPayment->find('first',array('fields'=>array('id','sum(paid_amount) as paid_amount '),
					'conditions'=>array('RadiologyTestPayment.patient_id'=>$patient_id),'order'=>array('RadiologyTestPayment.id DESC')));
			$combine  = (int)$chPayment[0]['paid_amount'] + $this->request->data['RadiologyTestPayment']['paid_amount'] ;
			if($combine == $this->request->data['RadiologyTestPayment']['total_amount']){
				$this->request->data['RadiologyTestPayment']['status'] = 'paid';
			}
			$result = $this->RadiologyTestPayment->save($this->request->data['RadiologyTestPayment']);
			if($result){
				$this->Session->setFlash(__('Payment done successfully'),'default',array('class'=>'message'));
				$this->redirect('/radiologies/payment/?payment=done&id='.$this->RadiologyTestPayment->getLastInsertId());
			}else{
				$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
				$this->redirect($this->referer());
			}
		}
		if($patient_id){
			$this->patient_info($patient_id); //patient details
			//BOF lab billing

			//BOF radio_order
			$this->uses = array('Person','Patient','Consultant','User','RadiologyTestOrder');
			//lab tests
			$dept  =  isset($this->params->query['dept'])? $this->params->query['dept']:'';
			$testDetails = $this->RadiologyTestOrder->find('count',array('conditions'=>array('patient_id'=>$patient_id)));

			if($testDetails){

				//BOF new code
				$testArray = $testDetails['RadiologyTestOrder']['radiology_id'];
				$this->RadiologyTestOrder->bindModel(array(
						'belongsTo' => array(
								'Radiology'=>array('type'=>'inner','foreignKey'=>'radiology_id'),
						),
						'hasOne' => array(
								'RadiologyResult'=>array('foreignKey'=>'radiology_test_order_id')
						)),false);
					
				$this->paginate = array(
						'limit' => Configure::read('number_of_rows'),
						'fields'=>array('RadiologyTestOrder.batch_identifier','RadiologyResult.confirm_result','RadiologyTestOrder.id','RadiologyTestOrder.create_time','RadiologyTestOrder.order_id','Radiology.id','Radiology.name'),
						'conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id,'RadiologyTestOrder.is_deleted'=>0,'RadiologyTestOrder.from_assessment'=>0),
						'order' => array(
								'RadiologyTestOrder.id' => 'asc'
						),
						'group'=>array('RadiologyTestOrder.id')
				);
				$testOrdered   = $this->paginate('RadiologyTestOrder');
					
				$TestOrderedlabId = implode(',',$this->RadiologyTestOrder->find('list',array('fields'=>array('radiology_id'),'conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id,'RadiologyTestOrder.is_deleted'=>0))));

				$labTest  = $this->Radiology->find('list',array('fields'=>array('Radiology.id','Radiology.name'),'conditions'=>array('is_active'=>1,'location_id'=>$this->Session->read('locationid'))));

					
				//EOD new code
			}else{
				$labTest  = $this->Radiology->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_active'=>1)));
				$testOrdered ='';
			}
			$this->set('test_ordered',$testOrdered);
			//EOF radio order
			$this->loadModel('RadiologyTestPayment');
			//Radiology only
			$this->RadiologyTestOrder->bindModel(array(
					'belongsTo' => array(
							'Radiology'=>array('type'=>'inner','foreignKey'=>'radiology_id'),
							'Patient'=>array('foreignKey'=>'patient_id'),
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
							'TariffAmount'=>array('foreignKey' => false,'conditions'=>
									array('TariffAmount.tariff_list_id=Radiology.tariff_list_id' ,'TariffAmount.tariff_standard_id=Patient.tariff_standard_id'))
					)),false);
				
			$RadiologyTestOrderData= $this->RadiologyTestOrder->find('all',array(
					'fields'=> array('RadiologyTestOrder.test_done,Radiology.name,TariffAmount.nabh_charges,TariffAmount.non_nabh_charges'),
					'conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id,'RadiologyTestOrder.batch_identifier'=>$this->params->query['identifier'],'RadiologyTestOrder.is_deleted'=>0,'RadiologyTestOrder.from_assessment'=>0, 'Radiology.location_id'=>$this->Session->read('locationid')
					),'group'=>'RadiologyTestOrder.id'));
			//retrive data from lab_test_payment if has any
			$payment  = $this->RadiologyTestPayment->find('first',array('fields'=>array('id','sum(paid_amount) as paid_amount ','total_amount','patient_id','remark'),
					'conditions'=>array('RadiologyTestPayment.patient_id'=>$patient_id,'RadiologyTestPayment.batch_identifier'=>$this->params->query['identifier']),'order'=>array('RadiologyTestPayment.id DESC')));
			//$this->data =  $payment;

			$this->set(array('labRate'=>$RadiologyTestOrderData,'labPayment'=>$payment));
			//EOF Radiology
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
		$this->set('paymentDone','no');
			
		$this->set('lastEntry',$this->RadiologyTestPayment->getLastInsertId());
	}

	//function to dispaly paymetn receipt
	function radiology_test_payment_receipt($patient_id=null){
		$this->uses = array('RadiologyTestPayment');
		if(!empty($patient_id)){
			$this->patient_info($patient_id); //patient details
			//laboratory only
			$this->RadiologyTestPayment->bindModel(array(
					'belongsTo' => array('Patient'=>array('foreignKey'=>'patient_id'))));
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('RadiologyTestPayment.batch_identifier' => 'asc'),
					'fields'=> array('RadiologyTestPayment.id','RadiologyTestPayment.paid_amount ','RadiologyTestPayment.total_amount',
							'RadiologyTestPayment.batch_identifier','RadiologyTestPayment.patient_id','Patient.lookup_name','Patient.admission_id'),
					'conditions'=>array('RadiologyTestPayment.patient_id'=>$patient_id));

				
			$this->set('receiptData',$this->paginate('RadiologyTestPayment'));
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'receipts'));
		}
	}

	function radiology_test_payment_receipt_print($receipt_id=null){
		$this->layout = 'print_with_header' ;
		$this->uses = array('RadiologyTestPayment');
		if(!empty($receipt_id)){
			//laboratory only
			$this->RadiologyTestPayment->bindModel(array(
					'belongsTo' => array('Patient'=>array('foreignKey'=>'patient_id'),
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
					)));

			$data = 	$this->RadiologyTestPayment->find('first',array('fields'=> array('RadiologyTestPayment.id','RadiologyTestPayment.paid_amount ','RadiologyTestPayment.total_amount',
					'RadiologyTestPayment.patient_id','RadiologyTestPayment.remark','PatientInitial.name','Patient.lookup_name','Patient.admission_id','RadiologyTestPayment.create_time'),
					'conditions'=>array('RadiologyTestPayment.id'=>$receipt_id)));
			$this->set('receiptData',$data);
			$this->investigation_print($data['RadiologyTestPayment']['patient_id'],$this->params->query['identifier']);
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'receipts'));
		}
	}
	//EOF radiology OPD Billing

	//BOF new corporate rate list interface
	public function admin_view_tariff(){
		$this->uses = array('TariffStandard');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'TariffStandard.name' => 'desc',
							
				),'conditions'=>array('TariffStandard.is_deleted'=>0,'TariffStandard.location_id'=>$this->Session->read('locationid'))
		);
		$data = $this->paginate('TariffStandard');
		$this->set('data', $data);
	}

	public function admin_edit_tariff_amount($standardId){
		if($standardId){
			$locationid = $this->Session->read('locationid');
			//BOF adding search filter
			/*if(isset($this->params->query['rad_name']))
				$searchKey = array('Radiology.location_id'=>$locationid,'Radiology.is_active'=>1,'Radiology.name like "%'.$this->params->query['rad_name'].'%"');
			else
				$searchKey = array('Radiology.location_id'=>$locationid,'Radiology.is_active'=>1);*/
			//EOF adding search filter
			$this->uses = array('Radiology','TariffStandard');
			//BOF copy from
			if(!empty($this->request->data['TariffStandard']['standardName'])){
				$standardIdForQuery= $this->request->data['TariffStandard']['standardName'];
				$this->Radiology->bindModel(array(
						'TariffAmount'=>array('foreignKey' => false,'conditions'=>
								array('TariffAmount.tariff_list_id=Radiology.tariff_list_id' ,'TariffAmount.tariff_standard_id='.$standardIdForQuery)),
				),false);
				$copyData = $this->Radiology->Find('all',array('conditions'=>array('Radiology.location_id'=>$locationid,'Radiology.is_active'=>1)));
				$this->set('copyData',$copyData);
			}
			//EOF copy from
				
				

			$this->Radiology->bindModel(array(
					'TariffAmount'=>array('foreignKey' => false,'conditions'=>
							array('TariffAmount.tariff_list_id=Radiology.tariff_list_id' ,'TariffAmount.tariff_standard_id='.$standardId)),
			),false);
				
			$data = $this->Radiology->Find('all',array('conditions'=>array('Radiology.location_id'=>$locationid,'Radiology.is_active'=>1)));

			/*$this->paginate = array(
			 'limit' => Configure::read('number_of_rows'),
					'order' => array(
							'Radiology.name' => 'desc',

					),'conditions'=>$searchKey
			);
			$data = $this->paginate('Radiology'); */

			$this->set(array('labData'=>$data,'tariffStandardId'=>$standardId));
			$tariffStandards = $this->TariffStandard->find('list',array('conditions'=>array('is_deleted'=>0,'TariffStandard.location_id'=>$this->Session->read('locationid'))));
			$this->set('tariffStandards',$tariffStandards);
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
	}

	//BOF pankaj
	public function deleteRadTest($testId){
		if(!empty($testId)){
			$this->loadModel('RadiologyTestOrder');
			$this->RadiologyTestOrder->save(array('id'=>$testId,'is_deleted'=>1));
			$this->Session->setFlash(__('Record deleted successfully'),'default',array('class'=>'message'));
			$this->redirect($this->referer());
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
	}

	//EOF new corporate rate list interface
	//print investigation requisition slip
	function investigation_print($patient_id=null,$batch_identifier=null){
		$this->layout = 'print_without_header' ;
	//	$this->print_patient_info($patient_id);//called function will return patient info
		$this->uses = array('RadiologyTestOrder','Radiology','NewCropAllergies','Patient','User');
		/*$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey'=>'radiology_id'),
						//'ServiceProvider'=>array('foreignKey'=>'service_provider_id')
				),
				'hasOne' => array(
						//'RadiologyResult'=>array('foreignKey'=>'radiology_test_order_id')
				)),false);
		$testOrdered= $this->RadiologyTestOrder->find('all',array('fields'=>array('Radiology.name','create_time'),
				'conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id),'group'=>array('Radiology.name')));*/
		 
		/*$testOrdered= $this->RadiologyTestOrder->find('all',array('fields'=>array('RadiologyTestOrder.is_external','RadiologyResult.confirm_result',
				'RadiologyTestOrder.id','RadiologyTestOrder.create_time'
				,'RadiologyTestOrder.order_id','Radiology.id','Radiology.name','ServiceProvider.*'),
				'conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id,'RadiologyTestOrder.is_deleted'=>0,'RadiologyTestOrder.batch_identifier'=>$batch_identifier),
				'order' => array(
						'RadiologyTestOrder.id' => 'asc'
				),
				'group'=>array('RadiologyTestOrder.id')));*/
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey'=>false,'conditions'=>array('RadiologyTestOrder.radiology_id= Radiology.id')),
						'RadiologyResult'=>array('foreignKey'=>false,'conditions'=>array('RadiologyTestOrder.id= RadiologyResult.radiology_test_order_id')),
				)));
		$testOrdered=$this->RadiologyTestOrder->find('all',array('fields'=>array('Radiology.name','Radiology.id',
				'RadiologyTestOrder.id','RadiologyTestOrder.patient_id','RadiologyTestOrder.is_processed','RadiologyResult.id','RadiologyTestOrder.create_time'),
				'conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id,'RadiologyTestOrder.is_processed'=>0)/* ,'group'=>array('Radiology.name')*/));
		$this->set("test_ordered",$testOrdered);
		$getPId=$this->Patient->find('first',array('fields'=>array('Patient.*'),'conditions'=>array('Patient.id'=>$patient_id)));
	
		$this->set("getPId",$getPId);
		/**BOF-Geting initial name***/
		$this->User->bindModel(array('belongsTo' => array(
				'Initial' =>array('foreignKey'=>false, 'conditions' => array('Initial.id=User.initial_id')),
		
		)),false);
		$treatingConsultantData = $this->User->find('first',array('fields'=>array('CONCAT(User.first_name, " ", User.last_name) as fullname',
				'Initial.name as initial_name',),'conditions'=>array('User.id'=>$getPId['Patient']['doctor_id'])));
		$this->set("treatingConsultantData",$treatingConsultantData);
		$pId=$this->Patient->find('list',array('fields'=>array('Patient.id','Patient.id'),'conditions'=>array('person_id'=>$getPId['Patient']['person_id'])));
		$search_key1['NewCropAllergies.is_reconcile'] =0;
		$search_key1['NewCropAllergies.status'] ='A';
		$search_key1['NewCropAllergies.patient_uniqueid'] = $pId;
		$allergies_data=$this->NewCropAllergies->find('all',array('fields'=>array('name','reaction','AllergySeverityName','onset_date'),
				'conditions'=>$search_key1));
		$this->set("allergies_data",$allergies_data);
		 
	}

	function admin_view_groups(){
		$this->uses = array('TestGroup');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('TestGroup.name' => 'desc'),
				'conditions'=>array('type'=>'radiology') );
		$this->set('data',$this->paginate('TestGroup'));
			
	}

	function admin_add_group($id){
		$this->uses  = array('TestGroup');
		if(!empty($this->request->data['TestGroup'])){
			if($this->TestGroup->saveRecord($this->request->data,'radiology')){
				$this->Session->setFlash(__('Record added successfully'),'default',array('class'=>'message'));
				$this->redirect('view_groups');
			}else{
				$errors = $this->TestGroup->invalidFields();
				if(!empty($errors)) {
					$this->set("errors", $errors);
				}
			}
		}
		if(!empty($id)){
			$this->data = $this->TestGroup->getGroupByID($id) ;
		}
	}

	function admin_delete_group($id){
		if(!$id) return ;
		$this->uses = array('TestGroup') ;
		if($this->TestGroup->delete($id)){
			$this->Session->setFlash(__('Record added successfully'),'default',array('class'=>'message'));
			$this->redirect('view_groups');
		}else{
			$this->Session->setFlash(__('There is problem while deleting record, Plese try again'),'default',array('class'=>'error'));
		}

	}

	//function to print lab result for eachtest
	function print_preview($patient_id=null,$radiology_id=null,$order_id=null){
		$this->layout =false;
		$this->uses=array('Patient','RadiologyTestOrder','RadiologyReport','RadiologyResult','Radiology','User','RadiologyDoctorNote');

		$this->patient_info($patient_id);
		//for rad test name
		$radNameResult =  $this->Radiology->read('name',$radiology_id);
		$this->set('radiologyTestName',$radNameResult['Radiology']['name']);
		//save data
		$this->RadiologyReport->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey'=>'radiology_id' ),
						'RadiologyResult'=>array('foreignKey'=>'radiology_result_id'),
				)),false);
		$data = $this->RadiologyReport->find('all',
				array('fields'=>array('RadiologyResult.user_id','RadiologyResult.result_publish_date','RadiologyResult.id','RadiologyResult.note',
						'RadiologyResult.split','RadiologyReport.id','RadiologyReport.file_name' ,'Radiology.id','Radiology.name','RadiologyResult.img_impression','RadiologyResult.advice'),
						'conditions'=>array('RadiologyReport.patient_id'=>$patient_id,
								'Radiology.id'=>$radiology_id,'RadiologyResult.radiology_test_order_id'=>$order_id,
								'Radiology.is_active'=>1,'RadiologyReport.is_deleted'=>0),'recursive'=>1));

		$queryRes =$this->RadiologyDoctorNote->find('first',array('fields'=>array('id','note'),'conditions'=>array('patient_id'=>$patient_id,
				'radiology_id'=>$radiology_id)));
		$pathFields = array('User.full_name') ;
		$radiologist = $this->User->getUserByID($data[0]['RadiologyResult']['user_id'],$pathFields);
		$this->set(array('data'=>$data,'patient_id'=>$patient_id,'doctorNote'=>$queryRes['RadiologyDoctorNote'],
				'rad_test_order_id'=>$order_id,'radiologist'=>$radiologist));
	}
	
	/***
	 * Radiology Dashboard
	 */
	
	public function radDashBoard(){
		
		$this->uses=array('Patient','RadiologyTestOrder','Billing','ServiceCategory','TariffStandard','ServiceSubCategory','Radiology','Patient','Radiology2DEchoResult');
		$this->layout = "advance";
		
	    $this->Patient->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id'))
				)),false); 
		
		//Payment category Id Of "radiology" --  
	/*	$this->ServiceCategory->unbindModel(array('hasMany'=>array('ServiceSubCategory')));
		$paymentCategoryId=$this->ServiceCategory->find('first',array('fields'=>array('id'),
				'conditions'=>array('ServiceCategory.name Like'=>Configure::read('radiologyservices'))));
		
		$subCategory=$this->ServiceSubCategory->find('list',array('fields'=>array('id','name'),
				'conditions'=>array('ServiceSubCategory.service_category_id'=>$paymentCategoryId['ServiceCategory']['id'])));

		$this->set('subCategory',$subCategory);*/
		//tariff List "Private" Id--Pooja
		$privateID = $this->TariffStandard->getPrivateTariffID();//retrive private ID
		$this->set('privateId',$privateID);
		
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey'=>'radiology_id'),
						'Patient'=>array('type' => 'right','foreignKey' => false,'conditions'=>array('Patient.id = RadiologyTestOrder.patient_id'/*,'Patient.location_id'=>$this->Session->read('locationid')*/)),
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						//'Billing'=>array('foreignKey' => false,'conditions'=>array('Patient.id=Billing.patient_id','Billing.payment_category'=>$paymentCategoryId['ServiceCategory']['id'])),
						'RadiologyResult' =>array('foreignKey'=>false,'conditions'=>array('RadiologyResult.radiology_test_order_id=RadiologyTestOrder.id')),
						'TariffList'=>array('type' => 'INNER','foreignKey'=>false,'conditions'=>array('TariffList.id=Radiology.tariff_list_id')),
						'Radiology2DEchoResult'=>array('type'=>'left','foreignKey'=>false,'conditions'=>array('Radiology2DEchoResult.radiology_test_order_id=RadiologyTestOrder.id')),
						//'ServiceSubCategory'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('ServiceSubCategory.id=TariffList.service_sub_category_id')),
				)),false);	
		
		$this->RadiologyTestOrder->bindModel(array(
				'hasOne' => array(
						'Initial' =>array('foreignKey' => false,'conditions'=>array('Initial.id=User.initial_id' ))
				)),false);
		
		$this->request->data=$this->params->query;
		if(isset($this->request->data) && !empty($this->request->data)){
			$condition = array() ;//for patient name
			if($this->request->data['patient_id'] =='' && $this->request->data['from'] =='' && $this->request->data['to] '] =='' ){
				$condition = array('RadiologyTestOrder.radiology_order_date Like'=>date('Y-m-d')."%");
			}
			
			if(!empty($this->request->data['from'])){
				$from = $this->DateFormat->formatDate2STD($this->request->data['from'],Configure::read('date_format'))." 00:00:00";
			}
			if(!empty($this->request->data['to'])){
				$to = $this->DateFormat->formatDate2STD($this->request->data['to'],Configure::read('date_format'))." 23:59:59";
			}
				
			if(!empty($this->request->data['patient_id'])){
				$condition['RadiologyTestOrder.patient_id ']=$this->request->data['patient_id'];
			}
			if(!empty($this->request->data['status'])){
				$condition['RadiologyTestOrder.status']=$this->request->data['status'];
			}
			
			if($to)
				$condition['RadiologyTestOrder.radiology_order_date <='] = $to;
			if($from)
				$condition['RadiologyTestOrder.radiology_order_date >='] = $from;
			
		
				$condition['RadiologyTestOrder.is_deleted']='0';
			
			if($_SESSION['role']==Configure::read('doctorLabel')){
				// for redirect to search records
				if($this->request->query['conditionalFlag'] == 'conditionalFlag'){
					$condition = $this->Session->read ('radDashboardFilters');
					$this->set('conditionsFilter',serialize($condition));
				}else{
					$this->Session->write('radDashboardFilters',$condition);
					$this->set('conditionsFilter',serialize($condition));
				}
		    
		    $testOrder=$this->RadiologyTestOrder->find('all',array('fields'=>array('RadiologyTestOrder.radiology_order_date,sum(RadiologyTestOrder.amount) as totalAmount,
						        Patient.lookup_name,RadiologyTestOrder.create_time,RadiologyTestOrder.start_date,Radiology.id,Radiology.name,RadiologyTestOrder.order_id,
						        RadiologyTestOrder.patient_id,RadiologyTestOrder.id,Person.dob,Person.vip_chk,Patient.tariff_standard_id,
								RadiologyTestOrder.radDash_date,RadiologyTestOrder.order_id,RadiologyTestOrder.status,Patient.id,Patient.sex,
		    					Patient.patient_id,Patient.radiology_images,Patient.admission_id',
		    					'RadiologyTestOrder.radiology_order_date','RadiologyResult.id','RadiologyResult.confirm_result','RadiologyResult.result_publish_date',
		    					'User.first_name','User.last_name','CONCAT(User.first_name," ",User.last_name) as name',
		    		           'TariffList.name','Radiology2DEchoResult.id'),
		    		           'conditions'=>$condition,'group'=>array('RadiologyTestOrder.id'),'order' => array('Patient.id' => 'desc')));
				
			/* patient link to pasc*/
			foreach ($testOrder as $key => $value) {
						$patientAddId[]=$value['Patient']['admission_id'];
					}
						$imagesArry=$this->linkPacsImages($patientAddId);//IHH16B222
						
					/* eod*/
					$cnt=1;
					
				if(!empty($testOrder)){
					foreach ($testOrder as $keyVal => $patientData){
						
						foreach ($imagesArry as $key => $value){
							foreach ($testOrder as $keyVal => $patientData){
							if($patientData['Patient']['admission_id']==$key){
								$testOrder[$keyVal]['Patient']['studyuid'][$key]=$value;
								break;

							}else{
								$cnt++;
							}
						}
						}
					}
				
                				 
				}
				//eod..
				//print_r($testOrder);
				$this->set('data',$testOrder);
				
			}else{  
				// for redirect to search records
				if($this->request->query['conditionalFlag'] == 'conditionalFlag'){
					$condition = $this->Session->read ('radDashboardFilters');
					$this->set('conditionsFilter',serialize($condition));
				}else{
					$this->Session->write('radDashboardFilters',$condition);
					$this->set('conditionsFilter',serialize($condition));
				}
				
				
				$testOrder=$this->RadiologyTestOrder->find('all',array('fields'=>array('RadiologyTestOrder.radiology_order_date,sum(RadiologyTestOrder.amount) as totalAmount,
						        Patient.lookup_name,RadiologyTestOrder.create_time,RadiologyTestOrder.start_date,Radiology.id,Radiology.name,RadiologyTestOrder.order_id,
						        RadiologyTestOrder.patient_id,RadiologyTestOrder.id,Person.dob,Person.vip_chk,Patient.tariff_standard_id,
								RadiologyTestOrder.radDash_date,RadiologyTestOrder.order_id,RadiologyTestOrder.status,Patient.id,Patient.sex,Patient.patient_id,
								Patient.radiology_images,Patient.admission_id','RadiologyTestOrder.radiology_order_date','RadiologyResult.id','RadiologyResult.confirm_result',
								'RadiologyResult.result_publish_date','User.first_name','User.last_name','CONCAT(User.first_name," ",User.last_name) as name',
								'TariffList.name','Radiology2DEchoResult.id'),
						       'conditions'=>$condition,
								'group'=>array('RadiologyTestOrder.id'),
						         'order' => array('Patient.id' => 'desc')));
								 
			    /* patient link to pasc*/
				// to image array inside a patient array..
					foreach ($testOrder as $key => $value) {
						$patientAddId[]=$value['Patient']['admission_id'];
					}
					echo $patientAddId;
						$imagesArry=$this->linkPacsImages($patientAddId);//IHH16B222
					
					
					
					$cnt=1;
				
				if(!empty($testOrder)){
					
					
					//foreach ($testOrder as $keyVal => $patientData){
						foreach ($imagesArry as $key => $value){
							foreach ($testOrder as $keyVal => $patientData){
								
							if($patientData['Patient']['admission_id']==$key){
							
								//$testOrder[$keyVal]['Patient']['img'][$key]=$imagesArry[$key];
								//$testOrder[$keyVal]['Patient']['studyuid'][$key]=$imagesArry[$key];
								$testOrder[$keyVal]['Patient']['studyuid']=$value;
								break;

							}else{
								$cnt++;
							}
						}
						}
					//}
							
				}
				//eod..WW
				
                 //echo "<pre>";print_r($testOrder);
				$this->set('data',$testOrder);
				
				
			}
		}else{
			
			if($_SESSION['role']==Configure::read('doctorLabel')){
				
				$testOrder=$this->RadiologyTestOrder->find('all',array('fields'=>array('RadiologyTestOrder.radiology_order_date,sum(RadiologyTestOrder.amount) as totalAmount,
						        Patient.lookup_name,RadiologyTestOrder.create_time,RadiologyTestOrder.start_date,Radiology.id,Radiology.name,RadiologyTestOrder.order_id,
						        RadiologyTestOrder.patient_id,RadiologyTestOrder.id,Person.dob,Person.vip_chk,Patient.tariff_standard_id,
								RadiologyTestOrder.radDash_date,RadiologyTestOrder.order_id,RadiologyTestOrder.status,Patient.id,Patient.sex,Patient.patient_id,Patient.radiology_images,Patient.admission_id',
								'RadiologyTestOrder.radiology_order_date','RadiologyResult.id','RadiologyResult.confirm_result',
								'RadiologyResult.result_publish_date','User.first_name','User.last_name','CONCAT(User.first_name," ",User.last_name) as name',
						       'TariffList.name','Radiology2DEchoResult.id'),
						       'conditions'=> array('RadiologyTestOrder.radiology_order_date Like'=>date('Y-m-d')."%",'RadiologyTestOrder.is_deleted'=>'0'),'group'=>array('RadiologyTestOrder.id'),'order' => array('Patient.id' => 'desc')));
				
				
				 /* patient link to pasc*/
				// to image array inside a patient array..
					foreach ($testOrder as $key => $value) {
						$patientAddId[]=$value['Patient']['admission_id'];
					}
					
						$imagesArry=$this->linkPacsImages($patientAddId);//IHH16B222
					
					
					
					$cnt=1;
				
				if(!empty($testOrder)){
					
					
					//foreach ($testOrder as $keyVal => $patientData){
						foreach ($imagesArry as $key => $value){
							foreach ($testOrder as $keyVal => $patientData){
								
							if($patientData['Patient']['admission_id']==$key){
							
								//$testOrder[$keyVal]['Patient']['img'][$key]=$imagesArry[$key];
								//$testOrder[$keyVal]['Patient']['studyuid'][$key]=$imagesArry[$key];
								$testOrder[$keyVal]['Patient']['studyuid']=$value;
								break;

							}else{
								$cnt++;
							}
						}
						}
					//}
							
				}
				//eod..WW
				
				$this->set(array('data'=>$testOrder));
				
			}  
			else{
				
				$testOrder=$this->RadiologyTestOrder->find('all',array('fields'=>array('RadiologyTestOrder.radiology_order_date,sum(RadiologyTestOrder.amount) as totalAmount,
						        Patient.lookup_name,RadiologyTestOrder.create_time,RadiologyTestOrder.start_date,Radiology.id,Radiology.name,RadiologyTestOrder.order_id,
						        RadiologyTestOrder.patient_id,RadiologyTestOrder.id,Person.dob,Person.vip_chk,Patient.tariff_standard_id,
								RadiologyTestOrder.radDash_date,RadiologyTestOrder.order_id,RadiologyTestOrder.status,Patient.id,Patient.sex,Patient.patient_id,Patient.radiology_images,Patient.admission_id',
								'RadiologyTestOrder.radiology_order_date','RadiologyResult.id','RadiologyResult.confirm_result','RadiologyResult.result_publish_date','User.first_name','User.last_name','CONCAT(User.first_name," ",User.last_name) as name',
						       'TariffList.name','Radiology2DEchoResult.id'),
						        'conditions'=> array('RadiologyTestOrder.radiology_order_date Like'=>date('Y-m-d')."%",'RadiologyTestOrder.is_deleted'=>'0'),'group'=>array('RadiologyTestOrder.id'),'order' => array('Patient.id' => 'desc')));
				
				 /* patient link to pasc*/
				// to image array inside a patient array..
					foreach ($testOrder as $key => $value) {
						$patientAddId[]=$value['Patient']['admission_id'];
					}
					
						$imagesArry=$this->linkPacsImages($patientAddId);//IHH16B222
					
					
					
					$cnt=1;
				
				if(!empty($testOrder)){
					
					
					//foreach ($testOrder as $keyVal => $patientData){
						foreach ($imagesArry as $key => $value){
							foreach ($testOrder as $keyVal => $patientData){
								
							if($patientData['Patient']['admission_id']==$key){
							
								//$testOrder[$keyVal]['Patient']['img'][$key]=$imagesArry[$key];
								//$testOrder[$keyVal]['Patient']['studyuid'][$key]=$imagesArry[$key];
								$testOrder[$keyVal]['Patient']['studyuid']=$value;
								break;

							}else{
								$cnt++;
							}
						}
						}
					//}
							
				}
				//eod..WW
				$this->set('data',$testOrder); 
			}
		}//end of else
			
	}//End Of radDash
	
	//FOR dashboard slide show slide 6
	public function raddashboard_slide_three(){
		$slidesArray = array('slidesix','slideseven'); 
		$is_exist = in_array($this->params->query['type'], $slidesArray);
		$this->set('is_exist',$is_exist);
		
		$this->uses=array('Patient','RadiologyTestOrder','Billing','ServiceCategory','TariffStandard','ServiceSubCategory','Radiology','Patient');
		$this->layout = 'advance_ajax';
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id'))
				)),false);
		
		//tariff List "Private" Id--Pooja
		$privateID = $this->TariffStandard->getPrivateTariffID();//retrive private ID
		$this->set('privateId',$privateID);
		
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey'=>'radiology_id'),
						'Patient'=>array('type' => 'right','foreignKey' => false,'conditions'=>array('Patient.id = RadiologyTestOrder.patient_id'/*,'Patient.location_id'=>$this->Session->read('locationid')*/)),
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						//'Billing'=>array('foreignKey' => false,'conditions'=>array('Patient.id=Billing.patient_id','Billing.payment_category'=>$paymentCategoryId['ServiceCategory']['id'])),
						'RadiologyResult' =>array('foreignKey'=>false,'conditions'=>array('RadiologyResult.radiology_test_order_id=RadiologyTestOrder.id')),
						'TariffList'=>array('type' => 'INNER','foreignKey'=>false,'conditions'=>array('TariffList.id=Radiology.tariff_list_id')),
						//'ServiceSubCategory'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('ServiceSubCategory.id=TariffList.service_sub_category_id')),
				)),false);
		
		$this->RadiologyTestOrder->bindModel(array(
				'hasOne' => array(
						'Initial' =>array('foreignKey' => false,'conditions'=>array('Initial.id=User.initial_id' ))
				)),false);
		$conditions['RadiologyTestOrder.radiology_order_date Like']=date('Y-m-d')."%";
		$conditions['RadiologyTestOrder.is_deleted']=0;
		$conditions['RadiologyTestOrder.status']='Pending';
		if($this->params['pass'][0]=='IPD'){
			$conditions['Patient.admission_type'] = 'IPD';
		}else if($this->params['pass'][0]=='OPD'){
			$conditions['Patient.admission_type'] = 'OPD';
		}else if($this->params['pass'][0]=='RAD'){
			$conditions['Patient.admission_type'] = 'RAD';
		}
		$this->request->data=$this->params->query;
		$testOrder=$this->RadiologyTestOrder->find('all',array('fields'=>array('RadiologyTestOrder.radiology_order_date,sum(RadiologyTestOrder.amount) as totalAmount,
						        Patient.lookup_name,RadiologyTestOrder.create_time,RadiologyTestOrder.start_date,Radiology.id,Radiology.name,RadiologyTestOrder.order_id,
						        RadiologyTestOrder.patient_id,RadiologyTestOrder.id,Person.dob,Person.vip_chk,Patient.tariff_standard_id,Patient.admission_type,
								RadiologyTestOrder.radDash_date,RadiologyTestOrder.order_id,RadiologyTestOrder.status,Patient.id,Patient.sex,Patient.patient_id,Patient.radiology_images,Patient.admission_id',
						'RadiologyTestOrder.radiology_order_date','RadiologyResult.id','RadiologyResult.confirm_result','RadiologyResult.result_publish_date','User.first_name','User.last_name','CONCAT(User.first_name," ",User.last_name) as name',
						'TariffList.name'),
						'conditions'=> $conditions,
						'group'=>array('RadiologyTestOrder.id'),'order' => array('Patient.id' => 'desc')));
		$this->set('data',$testOrder);
	}//END Of Slide Three
		
	public function radDashBoardUpdate($radId,$status){
		$this->uses = array('RadiologyTestOrder');
		//	$this->DateFormat->formatDate2STDForReport($this->request->data['to'],Configure::read('date_format')));
		$radDash_date=$this->DateFormat->formatDate2STD($this->request->data['Radiology']['to'],Configure::read('date_format'));
		$checkStatus=$this->RadiologyTestOrder->updateAll(array('status'=>"'$status'",'radDash_date'=>"'$radDash_date'"),array('order_id'=>$radId));

		echo $checkStatus;
		exit;
	}
	
	function raddash($patient_id=null){
		$this->layout='advance_ajax'; 	 
	//debug($patient_id); exit;
		$this->uses=array('RadiologyTestOrder');
		 $this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey'=>'radiology_id' ),
						'Patient'=>array('foreignKey'=>'patient_id'),
				)),false); 
		$getData= $this->RadiologyTestOrder->find('all',array('fields'=>array('RadiologyTestOrder.radiology_id','Radiology.name','RadiologyTestOrder.order_id'),
				'conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id),'group'=>array('Radiology.id')));
		//debug($getData); exit;
		$this->set('data',$getData);
	
	}
	
	function radOverdueTestReport(){
		$this->layout = 'advance';
		$this->uses = array('RadiologyTestOrder');
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey'=>'radiology_id','conditions'=>array('Radiology.is_active'=>1)),
						'RadiologyResult' =>array('foreignKey'=>false,'conditions'=>array('RadiologyResult.radiology_test_order_id=RadiologyTestOrder.id')),
						'Patient' =>array('foreignKey'=>false,'conditions'=>array('Patient.id=RadiologyTestOrder.patient_id')),
				)),false);
		if(!empty($this->request->query)){
			$fromDate = $this->DateFormat->formatDate2STD($this->request->query['from_date'],Configure::read('date_format'));
			$toDate = $this->DateFormat->formatDate2STD($this->request->query['to_date'],Configure::read('date_format'));
			$conditions = array('RadiologyTestOrder.start_date >=' => $fromDate, 'RadiologyTestOrder.start_date <=' => $toDate);
			if($this->request->query['patient_id']){
				$conditions['RadiologyTestOrder.patient_id'] = $this->request->query['patient_id'];
			}
			$conditions['RadiologyTestOrder.is_deleted'] = 0;
			$conditions['RadiologyTestOrder.location_id']= $this->Session->read('locationid');
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'fields'=>array('RadiologyResult.id','Radiology.name','RadiologyTestOrder.start_date','RadiologyTestOrder.order_id',
							'RadiologyTestOrder.patient_id','Patient.lookup_name','RadiologyTestOrder.create_time'),
					'conditions'=>$conditions,
					'order' => array('RadiologyTestOrder.patient_id' => 'desc'));
			$this->set(array('testOrdered'=>$this->paginate('RadiologyTestOrder')));
		}
	
	}
	
	public function radAbnormalTestReport(){
		$this->layout = 'advance';
		$this->uses = array('RadiologyTestOrder');
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey'=>'radiology_id','conditions'=>array('Radiology.is_active'=>1)),
						'RadiologyResult' =>array('foreignKey'=>false,'conditions'=>array('RadiologyResult.radiology_test_order_id=RadiologyTestOrder.id')),
						'Patient' =>array('foreignKey'=>false,'conditions'=>array('Patient.id=RadiologyTestOrder.patient_id')),
				)),false);
		if(!empty($this->request->query)){
			$fromDate = $this->DateFormat->formatDate2STD($this->request->query['from_date']." 00:00:00",Configure::read('date_format'));
			$toDate = $this->DateFormat->formatDate2STD($this->request->query['to_date']." 23:59:59",Configure::read('date_format'));
			$conditions = array('RadiologyResult.result_publish_date >=' => $fromDate, 'RadiologyResult.result_publish_date <=' => $toDate);
			if($this->request->query['patient_id']){
				$conditions['RadiologyTestOrder.patient_id'] = $this->request->query['patient_id'];
			}
			$conditions['RadiologyTestOrder.is_deleted'] = 0;
			$conditions['RadiologyTestOrder.location_id']= $this->Session->read('locationid');
			$conditions['RadiologyResult.img_impression'] = 'Negative';
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'fields'=>array('RadiologyResult.id','Radiology.name','RadiologyTestOrder.start_date','RadiologyTestOrder.order_id',
							'RadiologyTestOrder.patient_id','Patient.lookup_name','RadiologyTestOrder.create_time',
							'RadiologyResult.result_publish_date'),
					'conditions'=>$conditions,
					'order' => array('RadiologyTestOrder.patient_id' => 'desc'));
			$this->set(array('testOrdered'=>$this->paginate('RadiologyTestOrder')));
		}
	}
	
	/**
	 * Function for Radiology test order Patients autocomplete-Atul
	 */
	function autocompleteForRadPatient(){
		$this->autoRender = false;
		$this->layout = false;
		$this->isAutocomplete = true;
		$this->uses = array ( 'RadiologyTestOrder','Patient' );
		$searchKey = $this->params->query['term'];
		
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Patient' => array(
								'foreignKey' => false,
								'conditions' => array('RadiologyTestOrder.patient_id = Patient.id')
						)
				)
		));
	
		$conditions["Patient.lookup_name LIKE"] = "%".$searchKey."%";
		$result = $this->RadiologyTestOrder->find('all',array('fields'=>array('Patient.lookup_name','Patient.id','Patient.patient_id','Patient.admission_id','Patient.form_received_on'),
				'conditions'=>$conditions,'group'=>'Patient.person_id','order'=>'Patient.lookup_name ASC','limit'=>15));
	
		foreach($result as $key => $value){
			$addDate=$this->DateFormat->formatDate2Local($value['Patient']['form_received_on'],Configure::read('date_format'));
			$returnArray[]=array('id'=>$value['Patient']['id'],'value'=>ucwords(strtolower($value['Patient']['lookup_name'])).'-'.$value['Patient']['admission_id'].' ( '.$addDate.' )','patient_id'=>$value['Patient']['patient_id']);
		}
		echo json_encode ($returnArray );
		exit;
	}
	
	// added by atul for importing radiology in master
	public function import_data(){
		$this->uses = array('TariffStandard');
		$website=$this->Session->read("website.instance");
		App::import('Vendor', 'reader');
		$this->set('title_for_layout', __('Radiology- Export Data', true));
		if ($this->request->is('post')) { //pr($this->request->data);
			if($this->request->data['importData']['import_file']['error'] !="0"){
				$this->Session->setFlash(__('Please Upload the file'), 'default', array('class' => 'error'));
				$this->redirect(array("controller" => "Radiologies", "action" => "import_data","admin"=>false));
			}
			/*if($this->request->data['importData']['import_file']['size'] > "1000000"){
			 $this->Session->setFlash(__('Size exceed Please upload 1 MB size file.'), 'default', array('class' => 'error'));
			$this->redirect(array("controller" => "Tariffs", "action" => "import_data","admin"=>true));
			}*/
			$tariff=$this->request->data['importData']['tariffId'];
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1251');
			ini_set('memory_limit',-1);
			set_time_limit(0);
			$path = WWW_ROOT.'uploads/import/'. $this->request->data['importData']['import_file']['name'];
			move_uploaded_file($this->request->data['importData']['import_file']['tmp_name'],$path );
			chmod($data->path,777);
			$data = new Spreadsheet_Excel_Reader($path);
		    $is_uploaded = $this->Radiology->importDataGlobus($data);
			if($is_uploaded == true){
				unlink( $path );
				$this->Session->setFlash(__('Data imported sucessfully'), 'default', array('class' => 'message'));
				$this->redirect(array("controller" => "Radiologies", "action" => "import_data","admin"=>false));
			}else{
				unlink( $path );
				$this->Session->setFlash(__('Error Occured Please check your Excel sheet.'), 'default', array('class' => 'error'));
				$this->redirect(array("controller" => "Radiologies", "action" => "import_data","admin"=>false));
			}
	
		}
		
		$privateID = $this->TariffStandard->getPrivateTariffID();
		$this->set('privateID',$privateID);
		$tariffStandard=$this->TariffStandard->find("list",array(array('id','name'),"conditions"=>
				array("TariffStandard.is_deleted"=>0,
						'TariffStandard.location_id'=>$this->Session->read('locationid')
				)
		));
		$this->set('tariffStandard',$tariffStandard);
	
	}
	public function testcomplete(){
		$this->layout = "ajax";
		$this->uses = array('Radiology');
		$conditions =array();
		$searchKey = $this->params->query['q'] ;
		$conditions["Radiology.name like"] = $searchKey."%";
		//$testList = $this->Radiology->find('list',array('conditions'=>array('is_active'=>1,'location_id'=> $this->Session->read('locationid')),'fields'=>array('name')));
		$testArray = $this->Radiology->find('list', array('fields'=> array('Radiology.id', 'Radiology.name'),'conditions'=>array($conditions,'is_active'=>1,'location_id'=> $this->Session->read('locationid')),'order'=>array("Radiology.name ASC")));
		foreach ($testArray as $key=>$value) {
			echo "$value   $key|$key\n";
		}
		exit;
	}
	
	public function xray_img_gallary(){
		$pid = $this->params->query['pId'];
		//$this->layout = false;
		$this->uses = array('Radiology','Patient');
		
		$patientData = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$pid),
						'fields'=>array('Patient.id','Patient.radiology_images','Patient.admission_id_qrcode','Patient.patient_name_qrcode','Patient.lookup_name',
								'Patient.admission_id')
				));
		$this->set('patientData',$patientData);
	}
	
	public function xray_images_slider_version_one(){
		$pid = $this->params->query['pId'];
		$this->layout = false;
		$this->uses = array('Radiology','Patient');
	
		$patientData = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$pid),
				'fields'=>array('Patient.id','Patient.radiology_images','Patient.admission_id_qrcode','Patient.patient_name_qrcode','Patient.lookup_name',
						'Patient.admission_id')
		));
		$this->set('patientData',$patientData);
	}

		function pacs(){
		$this->set('title_for_layout', __('DrMHope Pacs', true));
		$this->layout='advance';
		//$patient_xml=$this->generateXML_prescription($id);
		//$this->set('patient_xml', $patient_xml);
		$this->set('id',$id);
		if(!empty($noteId)){
			$this->set('noteId',$noteId);
		}
		if(!empty($apptId)){
			$this->set('apptId',$apptId);
		}
	}
	/**
	 * get the RGJAY package patient list and their results
	 * @author Atul Chandankhede
	 */
	function getRgjayPackagePatientResult(){
		$this->layout='advance';
		$this->uses = array('ServiceBill','Patient','ServiceCategory','TariffStandard','PatientDocumentType','Diagnosis','TariffList',
							'PackageCategory','PackageSubCategory','PackageSubSubCategory');
		$rgjayPackage = $this->ServiceCategory->getServiceGroupId('RGJAY Package');
		$rgjayTariffId = $this->TariffStandard->getTariffStandardID('rgjay');
		$rgjayTariffAsOnTodayId = $this->TariffStandard->getTariffStandardID('rgjay_private_as_on_today');
		$subCategory = $this->PatientDocumentType->find('list',array(
				'fields'=>array('id','name'),
				'order'=>array('PatientDocumentType.name'=>'asc')));
		
		$docType = $this->PatientDocumentType->getDocumentType();
		$pacakgeCategory = $this->PackageCategory->getPackageCategoryName();
		$pacakgeSubCategory = $this->PackageSubCategory->getSubPackageCategory();
		$pacakgeSubSubCategory = $this->PackageSubSubCategory->getSubSubPackageCategory();
		
		$this->set(array('rgjayPackage'=>$rgjayPackage,'rgjayTariffId'=>$rgjayTariffId,'subCategory'=>$subCategory,'docType'=>$docType,
				'pacakgeCategory'=>$pacakgeCategory,'rgjayTariffAsOnTodayId'=>$rgjayTariffAsOnTodayId,'pacakgeSubCategory'=>$pacakgeSubCategory,'pacakgeSubSubCategory'=>$pacakgeSubSubCategory));
		
		if($this->params->query['conditionalFlag'] == 'conditionalFlag'){
			$condition = $this->Session->read ('radDashboardFilters');
			$this->set('conditionsFilter',serialize($condition));
				
			$this->Patient->bindModel(array(
						'belongsTo' => array(
								'TariffStandard' =>array('type'=>'INNER','foreignKey'=>false, 'conditions' => array('Patient.tariff_standard_id=TariffStandard.id')),
								'PatientDocumentDetail' =>array('type'=>'left','foreignKey'=>false, 'conditions' => array('Patient.id=PatientDocumentDetail.patient_id')),
								'Diagnosis' =>array('type'=>'left','foreignKey'=>false, 'conditions' => array('Patient.id=Diagnosis.patient_id')),
								'ServiceBill' =>array('type'=>'left','foreignKey'=>false, 'conditions' => array('Patient.id=ServiceBill.patient_id','ServiceBill.service_id'=>$rgjayPackage)),
								'TariffList' =>array('type'=>'left','foreignKey'=>false, 'conditions' => array('TariffList.id=ServiceBill.tariff_list_id')),
								'GalleryPackageDetail'=>array('type'=>'left','foreignKey'=>false,'conditions'=>array('GalleryPackageDetail.patient_id=Patient.id'))
						)),false);
				$this->paginate = array(
						'fields'=>array('Patient.id','Patient.lookup_name','Patient.sex','Patient.admission_id','Patient.form_received_on','Patient.tariff_standard_id','TariffList.id','TariffList.name',
										'Diagnosis.id','Diagnosis.final_diagnosis','Diagnosis.actual_diagnosis','PatientDocumentDetail.id','PatientDocumentDetail.category_id','PatientDocumentDetail.sub_category_id',
								        'PatientDocumentDetail.intraop_sub_category_id', 'PatientDocumentDetail.package_category_id', 'PatientDocumentDetail.package_sub_category_id', 
										'PatientDocumentDetail.package_subsub_category_id','GalleryPackageDetail.*','TariffStandard.name'),
						'limit' => Configure::read('number_of_rows'),
						'order'=>array('Patient.id DESC'),
						'conditions' => $condition,
						'group'=>array('Patient.id'),
				);
					
				$servicesData =$this->paginate('Patient') ;
				$this->set('servicesData',$servicesData);
				
				
		}else  if(!empty($this->request->query)){ 
                
            $this->request->data['RgjayPackage'] = $this->request->query;
            
			if(!empty($this->request->data['RgjayPackage']['package_id'])){
				$condition['ServiceBill.tariff_list_id']=$this->request->data['RgjayPackage']['package_id'];
			}
			if(!empty($this->request->data['RgjayPackage']['patient_id'])){
				$condition['Patient.id']=$this->request->data['RgjayPackage']['patient_id'];
			}
			if(!empty($this->request->data['RgjayPackage']['category_id'])){
				$condition['PatientDocumentDetail.category_id']=$this->request->data['RgjayPackage']['category_id'];
			}
			if(!empty($this->request->data['RgjayPackage']['sub_category_id'])){
				$condition['PatientDocumentDetail.sub_category_id']=$this->request->data['RgjayPackage']['sub_category_id'];
			}
			if(!empty($this->request->data['RgjayPackage']['intraop_sub_category_id'])){
				$condition['PatientDocumentDetail.intraop_sub_category_id']=$this->request->data['RgjayPackage']['intraop_sub_category_id'];
			}
			// diagnosis keyword search
			if(!empty($this->request->data['RgjayPackage']['diagnosis_name'])){
				$condition['Diagnosis.final_diagnosis LIKE']= "%".$this->request->data['RgjayPackage']['diagnosis_name']."%";
			}
			
			// actual diagnosis keyword search
			if(!empty($this->request->data['RgjayPackage']['actual_diagnosis'])){
				$condition['Diagnosis.actual_diagnosis LIKE']= "%".$this->request->data['RgjayPackage']['actual_diagnosis']."%";
			}
				
			
			if(!empty($this->request->data['RgjayPackage']['from_date']))
			{
				$from = $this->DateFormat->formatDate2STD($this->request->data['RgjayPackage']['from_date'],Configure::read('date_format'))." 00:00:00";
				$condition['Patient.form_received_on >='] = $from;
			}
			if(!empty($this->request->data['RgjayPackage']['to_date']))
			{
				$to = $this->DateFormat->formatDate2STD($this->request->data['RgjayPackage']['to_date'],Configure::read('date_format'))." 23:59:59";
				$condition['Patient.form_received_on <='] = $to;
			}
			if(!empty($this->request->data['RgjayPackage']['package_category_id'])){
				$condition['GalleryPackageDetail.package_category_id']=$this->request->data['RgjayPackage']['package_category_id'];
			}
			if(!empty($this->request->data['RgjayPackage']['package_sub_category_id'])){
				$condition['GalleryPackageDetail.package_sub_category_id']=$this->request->data['RgjayPackage']['package_sub_category_id'];
			}
			if(!empty($this->request->data['RgjayPackage']['package_subsub_category_id'])){
				$condition['GalleryPackageDetail.package_subsub_category_id']=$this->request->data['RgjayPackage']['package_subsub_category_id'];
			}
			$this->Session->write('radDashboardFilters',$condition);
			$this->set('conditionsFilter',serialize($condition));
			
			$data =$this->request->data;
			$this->set('data',$data);
			
			//BOF display image gallery
			if($this->request->data['RgjayPackage']['display_image']){
                                $this->layout = "advance_ajax";
				$this->ServiceBill->bindModel(array(
						'belongsTo' => array(
								'Patient' =>array('type'=>'inner','foreignKey'=>'patient_id'),
								'PatientDocumentDetail' =>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('Patient.id=PatientDocumentDetail.patient_id')),
								'Diagnosis' =>array('foreignKey'=>false, 'conditions' => array('Patient.id=Diagnosis.patient_id')),
								'TariffList' =>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('TariffList.id=ServiceBill.tariff_list_id'/*,'ServiceBill.service_id'=>$rgjayPackage */)),
								'GalleryPackageDetail'=>array('type'=>'left','foreignKey'=>false,'conditions'=>array('GalleryPackageDetail.patient_id=Patient.id'))
						)),false);
				$servicesDataOnlyImages = $this->ServiceBill->find('all',array(
					'fields'=>array('Patient.id','Patient.lookup_name','Patient.sex','Patient.admission_id','Patient.form_received_on',
							'ServiceBill.id','PatientDocumentDetail.filename_report','PatientDocumentDetail.sub_category_id','PatientDocumentDetail.intraop_sub_category_id','PatientDocumentDetail.category_id','PatientDocumentDetail.document_description',
							'PatientDocumentDetail.id','PatientDocumentDetail.is_download_allow','Diagnosis.diagnosis','TariffList.name','GalleryPackageDetail.*'
					),
					'conditions'=>array($condition,'PatientDocumentDetail.filename_report IS NOT NULL'),
					'order'=>array('ServiceBill.id DESC'), 
                                        'group'=>array('PatientDocumentDetail.id')
					 ));
				
				$this->set('servicesDataOnlyImages',$servicesDataOnlyImages);
				//EOF display image gallery
			}else{
				$this->Patient->bindModel(array(
						'belongsTo' => array(
								'TariffStandard' =>array('type'=>'INNER','foreignKey'=>false, 'conditions' => array('Patient.tariff_standard_id=TariffStandard.id')),
								'PatientDocumentDetail' =>array('type'=>'left','foreignKey'=>false, 'conditions' => array('Patient.id=PatientDocumentDetail.patient_id')),
								'Diagnosis' =>array('type'=>'left','foreignKey'=>false, 'conditions' => array('Patient.id=Diagnosis.patient_id')),
								'ServiceBill' =>array('type'=>'left','foreignKey'=>false, 'conditions' => array('Patient.id=ServiceBill.patient_id','ServiceBill.service_id'=>$rgjayPackage)),
								'TariffList' =>array('type'=>'left','foreignKey'=>false, 'conditions' => array('TariffList.id=ServiceBill.tariff_list_id')),
								'GalleryPackageDetail'=>array('type'=>'left','foreignKey'=>false,'conditions'=>array('GalleryPackageDetail.patient_id=Patient.id'))
						)),false);
				$this->paginate = array(
						'fields'=>array('Patient.id','Patient.lookup_name','Patient.sex','Patient.admission_id','Patient.form_received_on','Patient.tariff_standard_id','TariffList.id','TariffList.name',
										'Diagnosis.id','Diagnosis.final_diagnosis','Diagnosis.actual_diagnosis','PatientDocumentDetail.id','PatientDocumentDetail.category_id','PatientDocumentDetail.sub_category_id',
								        'PatientDocumentDetail.intraop_sub_category_id', 'PatientDocumentDetail.package_category_id', 'PatientDocumentDetail.package_sub_category_id', 
										'PatientDocumentDetail.package_subsub_category_id','GalleryPackageDetail.*','TariffStandard.name'),
						'limit' => Configure::read('number_of_rows'),
						'order'=>array('Patient.id DESC'),
						'conditions' => $condition,
						'group'=>array('Patient.id'),
				);
			
				$servicesData =$this->paginate('Patient') ;
				$this->set('servicesData',$servicesData);
			}
			
			
		}
	}
	/**
	 * upload documents for patient 
	 * @param int $patientId 
	 * @author Atul Chandankhede
	 */
	function uploadDocument($patientId){
		
		$this->layout='advance';
		$this->uses = array('PatientDocumentDetail','Patient','PatientDocumentType','ServiceCategory','GalleryPackageDetail','PackageCategory','TariffStandard');
		$rgjayPackage = $this->ServiceCategory->getServiceGroupId('RGJAY Package');
		$packageCategory = $this->PackageCategory->getPackageCategoryName();
		$rgjayTariffId = $this->TariffStandard->getTariffStandardID('rgjay');
		$rgjayTariffAsOnTodayId = $this->TariffStandard->getTariffStandardID('rgjay_private_as_on_today');
		
		$this->set(array('rgjayTariffId'=>$rgjayTariffId,'rgjayTariffAsOnTodayId'=>$rgjayTariffAsOnTodayId,'packageCategory'=>$packageCategory));
   		if($this->params->query['conditionalFlag']=='conditionalFlag'){
   			$conditionalFlag='conditionalFlag';
   		}
   		$this->set('conditionalFlag',$conditionalFlag);
   		
   		$this->Patient->bindModel(array(
   				'belongsTo' => array(
   						'Diagnosis' =>array('type'=>'left','foreignKey'=>false, 'conditions' => array('Patient.id=Diagnosis.patient_id')),
   						'ServiceBill' =>array('type'=>'left','foreignKey'=>false, 'conditions' => array('Patient.id=ServiceBill.patient_id')),
   						'TariffList' =>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('TariffList.id=ServiceBill.tariff_list_id')),
   						'GalleryPackageDetail'=>array('type'=>'left','foreignKey'=>false,'conditions'=>array('GalleryPackageDetail.patient_id=Patient.id'))
   				)),false);
   		
   		$patientData = $this->Patient->find('first',array('fields'=>array('Patient.id','Patient.lookup_name','Patient.admission_id','Patient.tariff_standard_id','TariffList.id','TariffList.name',
										'Diagnosis.id','Diagnosis.final_diagnosis' ,'GalleryPackageDetail.package_category_id' ),'conditions'=>array('Patient.id'=>$patientId/* ,'ServiceBill.service_id'=>$rgjayPackage  */)));

   		$this->set('patientData',$patientData);
   		
   		$patientName = $this->Patient->find('first',array('fields'=>array('Patient.id','Patient.lookup_name','Patient.admission_id'),'conditions'=>array('Patient.id'=>$patientId)));
   		$this->set('patientName',$patientName);
	    if(!empty($this->request->data)){
	    	// insert patient documents 
	 		$uploadedImage  = $this->PatientDocumentDetail->insertPatientDocument($this->request->data,$patientId);
	 		
	 		$imgPath = array();
	 		//foreach ($uploadedImage[0] as $key => $value){
	 			$imgPath['fullPath'][] = RADIOPATH.$uploadedImage[0];
	 			$imgPath['thumbnail'][]=RADIOPATH.'thumbnail/'.$uploadedImage[0];
	 		//}
	 		$imgPath['description'] = $uploadedImage[1];
	 		echo json_encode($imgPath);
	 	//	echo "$imgPathThumbnail|$uploadedImage[1]|$fullImgPath" ; //return image thumbnail path,full path  and description
	 		exit;
	    }else{
	    	//get uploaded patient documents details
	    	$patientDocData = $this->PatientDocumentDetail->getPatientDocumentByPatientId($patientId);
	    	$this->set('patientDocData',$patientDocData);  
	    	
	    	$galleryPackDetails = $this->GalleryPackageDetail->getPackageDetailsById($patientId);
	    	$this->set('galleryPackDetails',$galleryPackDetails);
	    }
		
		//for fetching xray of the patient
		if($_SERVER['HTTP_HOST']=='192.168.1.5:5454')
		{
		/* Code to connect with Dicom Db */
		$servername = "192.168.1.6";
		$username = "pacsuser";
		$password = "pacsuser";
	// Create connection
	$conn = new mysqli($servername, $username, $password,'pacsdb');
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}else{
	//echo "s";
	

$sql_patient = "SELECT pk FROM patient WHERE pat_id ="."'".$patientName['Patient']['admission_id']."'";
			$result_patient = $conn->query($sql_patient);
		if ($result_patient->num_rows > 0) {
			  $this->set('isPatientexistinPacs',"1");	
			}
			else
			 $this->set('isPatientexistinPacs',"0");	
			
		
		
	}
	
	}
	
	}
	
	public function showAllStudies($id){
			
		$this->layout ='advance_ajax';
		
		$this->uses=array('Patient','PatientDocument','Radiology');

		$this->Patient->unbindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
				$this->Patient->bindModel(array(
						'belongsTo'=>array(
								'Person'=>array('foreignKey'=>false,'conditions'=>array('Patient.person_id=Person.id')),
								'Note'=>array('foreignKey'=>false,'conditions'=>array('Patient.id=Note.patient_id')),
						)));
		$patientData=$this->Patient->find('first',array('conditions'=>array('admission_id'=>$id),'fields'=>array('Patient.lookup_name','Patient.admission_id','Patient.sex','Patient.age','Person.dob','Note.subject')));
		$this->set('patientData',$patientData);
	//for fetching xray of the patient
		if($_SERVER['HTTP_HOST']=='192.168.1.5:5454')
		{
		/* Code to connect with Dicom Db */
		$servername = "192.168.1.6";
		$username = "pacsuser";
		$password = "pacsuser";
	// Create connection
	$conn = new mysqli($servername, $username, $password,'pacsdb');
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}else{
	//echo "s";

$sql_patient = "SELECT pk FROM patient WHERE pat_id ="."'".$id."'";

			$result_patient = $conn->query($sql_patient);
		$patientFkids="";
		if ($result_patient->num_rows > 0) {
				while($row_patient = $result_patient->fetch_assoc()) {
					
					$patientFkids.=$row_patient['pk'].",";
				}
			}
			$patientFkids = rtrim($patientFkids, ",");
			
		
		$sql="select * from study where patient_fk in (".$patientFkids.")";
		
		
		
		//SELECT patient.pat_id,study_iuid FROM study LEFT JOIN patient ON study.patient_fk = patient.pk where patient.pat_id ='IH16E06002' and (mods_in_study='CT' or mods_in_study='MR')
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$studyAll[]=$row;
				}
			}	
			$this->set('studyAll',$studyAll);
	}
	
	}	
		
	}
	/*  By aditya for soap notes*/
	function ajax_uploadDocument($patientId){
		$this->layout='advance_ajax';
		$this->uses = array('PatientDocumentDetail','Patient','PatientDocumentType','ServiceCategory');
		$rgjayPackage = $this->ServiceCategory->getServiceGroupId('RGJAY Package');
   		if($this->params->query['conditionalFlag']=='conditionalFlag'){
   			$conditionalFlag='conditionalFlag';
   		}
   		$this->set('conditionalFlag',$conditionalFlag);
   		
   		$this->Patient->bindModel(array(
   				'belongsTo' => array(
   						'Diagnosis' =>array('type'=>'left','foreignKey'=>false, 'conditions' => array('Patient.id=Diagnosis.patient_id')),
   						'ServiceBill' =>array('type'=>'left','foreignKey'=>false, 'conditions' => array('Patient.id=ServiceBill.patient_id')),
   						'TariffList' =>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('TariffList.id=ServiceBill.tariff_list_id')),
   				)),false);
   		
   		$patientData = $this->Patient->find('first',array('fields'=>array('Patient.id','Patient.lookup_name','Patient.admission_id','TariffList.id','TariffList.name',
										'Diagnosis.id','Diagnosis.final_diagnosis'),'conditions'=>array('Patient.id'=>$patientId,'ServiceBill.service_id'=>$rgjayPackage)));
   		
   		$this->set('patientData',$patientData);
   		
	    if(!empty($this->request->data)){
	    	// insert patient documents 
	 		$uploadedImage  = $this->PatientDocumentDetail->insertPatientDocument($this->request->data,$patientId);
	 		$imgPathThumbnail=RADIOPATH.'thumbnail/'.$uploadedImage[0];
	 		$fullImgPath = RADIOPATH.$uploadedImage[0];
	 		echo "$imgPathThumbnail|$uploadedImage[1]|$fullImgPath" ; //return image thumbnail path,full path  and description
	 		exit;
	    }else{
	    	//get uploaded patient documents details
	    	$patientDocData = $this->PatientDocumentDetail->getPatientDocumentByPatientId($patientId);
	    	$this->set('patientDocData',$patientDocData);  
	    }
	}
	
	// Following Function For Entering result of 2D ECHO radiology Service-Atul
	public function enterEchoServiceResult($patientId,$radID,$testOrderID,$radNeclearMedID=Null){
		if($this->params->query['conditionalFlag']=='conditionalFlag'){
			$conditionalFlag='conditionalFlag';
		}
		//debug($conditionalFlag);
		$this->layout="advance";
		$this->uses = array ( 'RadiologyTestOrder','Patient','Radiology2DEchoResult','Billing','User' );
	
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Patient' => array ('foreignKey' => false,'conditions' => array ('RadiologyTestOrder.patient_id = Patient.id')),
						'Billing' => array ('foreignKey' => false,'conditions' => array ('Billing.id = RadiologyTestOrder.billing_id')),
						'User' => array ('foreignKey' => false,'conditions' => array ('User.id = RadiologyTestOrder.doctor_id')),
				)),false);
	
		$patientData=$this->RadiologyTestOrder->find('first',array('fields'=>array('Billing.id','Billing.bill_number','Patient.id','Patient.patient_id','Patient.lookup_name',
				'Patient.age','Patient.sex','CONCAT(User.first_name," ",User.last_name) as user_name'),'conditions'=>array('RadiologyTestOrder.id'=>$testOrderID,'Patient.id'=>$patientId)));
	
		$this->set('patientData',$patientData);
		#debug($this->request->data);exit;
		if(!empty($this->request->data)){
			
			$resultDate=$this->DateFormat->formatDate2STD($this->request->data['Radiology2DEchoResult']['result_date'],Configure::read('date_format'));
			$this->request->data['Radiology2DEchoResult']['created_by']=$this->Session->read('userid');
			$this->request->data['Radiology2DEchoResult']['result_date']=$resultDate;
			$status=$this->request->data['Radiology2DEchoResult']['status'];
			if(isset($this->request->data['Radiology2DEchoResult']['id']) && !empty($this->request->data['Radiology2DEchoResult']['id'])){
				//update
				if($this->Radiology2DEchoResult->save($this->request->data)){
					$this->Radiology2DEchoResult->id = $this->request->data['Radiology2DEchoResult']['id'] ;
					$this->RadiologyTestOrder->updateAll(array('RadiologyTestOrder.status'=>"'$status'"),array('RadiologyTestOrder.id'=>$testOrderID));
					$this->Session->setFlash(__('Record updated successfully', true, array('class'=>'error')));
					$echoId=$this->request->data['Radiology2DEchoResult']['id'];
				}
			}else{
				//save
				$this->Radiology2DEchoResult->save($this->request->data);
				$this->RadiologyTestOrder->updateAll(array('RadiologyTestOrder.status'=>"'$status'"),array('RadiologyTestOrder.id'=>$testOrderID));
				$echoId=$this->Radiology2DEchoResult->getLastInsertID();
	
			}
				
			if($this->request->data['Radiology2DEchoResult']['status']=="Completed"){
				$this->set(array('patientId'=>$patientId,'radID'=>$radID,'testOrderID'=>$testOrderID,'echoId'=>$echoId,'action'=>'print','conditionalFlag'=>$conditionalFlag));
			}else{
				$this->redirect(array("controller" => "Radiologies", "action" => "radDashBoard" ,'?'=>array('conditionalFlag'=>$conditionalFlag)));
			}
				
		}
	
		if(!empty($radNeclearMedID)){
			$serviceDetails= $this->Radiology2DEchoResult->find('first',array('conditions'=>array('id'=>$radNeclearMedID)));
			$id=$serviceDetails['Radiology2DEchoResult']['id'];
			$this->set('serviceDetails',$serviceDetails);
		}
	}
	// Print 2D Echo Result -Atul
	function printEchoServiceResult($patient_id=null,$radiology_id=null,$order_id=null,$nuclearMedId=Null){
		$this->layout ='print_with_header';
		$this->uses=array('Patient','RadiologyTestOrder','Radiology','Radiology2DEchoResult','Billing','User');
	
		$this->Radiology2DEchoResult->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey'=>'radiology_id' ),
						'Patient' => array ('foreignKey' => false,'conditions' => array ('Radiology2DEchoResult.patient_id = Patient.id')),
						'RadiologyTestOrder' => array ('foreignKey' => false,'conditions' => array ('RadiologyTestOrder.id = Radiology2DEchoResult.radiology_test_order_id')),
						'Billing' => array ('foreignKey' => false,'conditions' => array ('Billing.id = RadiologyTestOrder.billing_id')),
						'User' => array ('foreignKey' => false,'conditions' => array ('User.id = RadiologyTestOrder.doctor_id')),
				)),false);
	
		$serviceDetails = $this->Radiology2DEchoResult->find('first',
				array('fields'=>array('Radiology2DEchoResult.*','Radiology.id','Radiology.name','Patient.id','Patient.lookup_name','Patient.age','Patient.sex',
						'Patient.patient_id','Billing.id','Billing.bill_number','CONCAT(User.first_name," ",User.last_name) as user_name','User.sign'),
						'conditions'=>array('Radiology2DEchoResult.patient_id'=>$patient_id,
								'Radiology2DEchoResult.radiology_id'=>$radiology_id,
								'Radiology2DEchoResult.id'=>$nuclearMedId
								,'Radiology2DEchoResult.is_deleted'=>0)));
	
		//debug($serviceDetails);
		$this->set('serviceDetails',$serviceDetails);
	}
	/**
	 * get the sub category list of documents
	 * @param int $categoryId
	 * @author Atul Chandankhede
	 */

	function getListOfSubCategory($categoryId = null){
		$this->loadModel('PatientDocumentType');
		$subCategoryList = $this->PatientDocumentType->find('list',array(
				'fields'=>array('id','name'),
				'conditions'=>array('PatientDocumentType.category_id'=>$categoryId),
				'order'=>array('PatientDocumentType.name'=>'asc')));
			
			
		foreach ($subCategoryList as $key=>$value) {
			$returnArray[] = array( 'id'=>$key,'value'=>ucwords(strtolower($value)));
		}
		echo json_encode($subCategoryList);
		exit;//dont remove this
	}
    public function updateDocumentDetials($documentId){
        $this->autoRender = false;
        $this->layout = false; 
        if(empty($documentId)) echo "false";
        if(!empty($this->request->data['ServiceBill'])){ 
            $this->request->data = $this->request->data['ServiceBill'];
            $this->loadModel('PatientDocumentDetail');
            $this->PatientDocumentDetail->id = $documentId;
            $this->request->data['modified_by'] = $this->Session->read('userid');
            $this->request->data['modify_time'] = date("Y-m-d H:i:s");
            if($this->PatientDocumentDetail->save($this->request->data)){
                echo "true";
            }
        }
    }
    
    public function approveImage($id,$isAllowDownload){	
    	$this->autoRender = false;
    	$this->layout = false;
    	if(empty($id)) echo "false";
    	if(!empty($id)){
    		$this->loadModel('PatientDocumentDetail');
    		$this->PatientDocumentDetail->updateAll(array('PatientDocumentDetail.is_download_allow'=>"'$isAllowDownload'"),array('PatientDocumentDetail.id'=>$id));
    	}
    }
		
/*@linking pacs images with Drm patients*/
public function linkPacsImages($addmissionID){ 
		return true;
	/* Code to connect with Dicom Db */
		$servername = "localhost";
		$username = "root";
		$password = "";
	
	// Create connection
	$conn = new mysqli($servername, $username, $password,'dicom');
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}else{
			
	}
	$keyCnt=0;
$patientUuid=array();
	foreach ($addmissionID as $key => $adId) {
		// get uuid to find study ids...
			
			$sql = "SELECT * FROM study LEFT JOIN patient ON study.patientid = patient.origid where patient.origid ='".$adId."' order by received DESC";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					
					$patientUuid[$row["patientid"]]=$row["uuid"];
					
				}
			}else{
				continue;
			}
			//echo "<pre>";print_r($patientUuid);
		// eod
		
		// to get images name and with is related to particular study...
		foreach ($patientUuid as $key => $value) {
			$sqlSeries ="select uuid from series where studyuid='$value'";
			$series = $conn->query($sqlSeries);
			if ($result->num_rows > 0) {	
				while ($seriesRow = $series->fetch_assoc()) {
					$seriesUid = $seriesRow['uuid'];
					$sqlImages ="select * from image where seriesuid='$seriesUid' ORDER BY instance ASC";
					$imageSql = $conn->query($sqlImages);
					while ($row = $imageSql->fetch_assoc()){
						$rows[$value][] = $row;
					}
				}
			}

		}

		// code to display images of patients...
		foreach ($rows as $key => $value) {
			foreach ($value as $keyVal => $image) {
				$imageArry[$adId][$keyVal]=$image['uuid'];
			}
		}$keyCnt++;
	// eod
}
return ($patientUuid);
	//return ($imageArry);
	$conn->close();
	/**/

}

	public function deleteDocument($docId){
		$this->loadModel('PatientDocumentDetail');
		if($docId){
			$queryRes = $this->PatientDocumentDetail->read ( array ('filename_report','is_link'), $docId );
			$isRename = unlink ( "uploads/radiology_data/" . $queryRes ['PatientDocumentDetail'] ['filename_report'] );
			if ($isRename && $queryRes ['PatientDocumentDetail'] ['is_link'] == 0 ) {
				$this->PatientDocumentDetail->updateAll(array('is_deleted'=>'1'),array('id'=>$docId));
			}else{
				$this->PatientDocumentDetail->updateAll(array('is_deleted'=>'1'),array('id'=>$docId));
			}
			$this->Session->setFlash(__('Record deleted successfully', true));
		}
		
		exit;
	}

}