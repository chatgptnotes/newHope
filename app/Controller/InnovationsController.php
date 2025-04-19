<?php
/**
 *  Controller : Innovation
 *  Use : AEDV
 *  @created by :Pankaj W
 *  functions : Innovations
 *  date :  18 Oct 2013
 *
 **/
class InnovationsController extends AppController {

	public $name = 'Innovations';
	public $uses = null ;
	public $helpers = array('Html','Form', 'Js','DateFormat','RupeesToWords','Number','General');
	public $components = array('RequestHandler','Email','ImageUpload','DateFormat');
	
	function index(){
		//$this->layout =false ;
		//landing page for innovation
	}
	
	function adverse_events(){ 
		
		 
		$combine_array 	= $this->lab_medication_events();
		$radiologyTest 	= $this->radiology_events();
		$patientList 	= $this->readmissionWithOneMonth();
		$patientsICU 	= $this->admissionToICU(); 
		$overSedation   = $this->over_sedation();
		$problems       = $this->problems();
		 
		$combine_array  = (!empty($radiologyTest))?array_merge($combine_array,$radiologyTest):$combine_array  ;
		$combine_array  = (!empty($patientList))?array_merge($combine_array,$patientList):$combine_array    ;
		$combine_array  = (!empty($patientsICU))?array_merge($combine_array,$patientsICU):$combine_array    ;
		$combine_array  = (!empty($overSedation))?array_merge($combine_array,$overSedation):$combine_array     ;
		$combine_array  = (!empty($problems))?array_merge($combine_array,$problems):$combine_array     ;
		
		//group patient wise adverse event
		foreach($combine_array as $key => $value){		
			if($value['AdverseEventTrigger']['condition']==1 &&
					($value['NewCropPrescription']['archive'] =='N') &&
					(stripos($value['NewCropPrescription']['drug_name'],$value['AdverseEventTrigger']['condition_values'])===0)){
				continue ; //skip if both is not satisfied
			}
			$reStructuredArray[$value['Patient']['id']]['info']  = $value['Patient'];
			if(!empty($value['AdverseEventTrigger']['class'])) //combine values of same class as a key
				$reStructuredArray[$value['Patient']['id']]['AdverseEventTrigger'][$value['AdverseEventTrigger']['class']][]  = $value['AdverseEventTrigger'];
			else
				$reStructuredArray[$value['Patient']['id']]['AdverseEventTrigger'][]  = $value['AdverseEventTrigger'];
		
		}
		  
		$this->set(array('data'=>$reStructuredArray));
	}
	
	
	function lab_medication_events(){
		$this->uses = array('Patient','AdverseEventTrigger','NewCropPrescription');
		$this->Ward->recursive =-1;
		$this->Patient->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		//BOF medication adverse events
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'NewCropPrescription' =>array('foreignKey' => false,'conditions'=>array('NewCropPrescription.patient_uniqueid=Patient.id')),
						'AdverseEventTrigger' =>array('type'=>'INNER','foreignKey' => false,
								'conditions'=>array('NewCropPrescription.drug_name LIKE CONCAT("%",AdverseEventTrigger.values,"%")')),
				)));
		$med_adverse_event_patients = $this->Patient->find('all',array('fields'=>array('Patient.id','Patient.admission_id','Patient.lookup_name','Patient.age',
				'AdverseEventTrigger.*'),'conditions'=>array('NewCropPrescription.adverse_event'=>1,'NewCropPrescription.archive '=>'N'),
				'group'=>array('NewCropPrescription.drug_name')));
		//EOF medication adverse event

		//BOF labs adverse events
		$this->Patient->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn'),
				'belongsTo'=>array('NewCropPrescription','AdverseEventTrigger')));
		$this->Patient->bindModel(array(
				'hasOne'=>array(
						'LaboratoryResult' =>array('foreignKey' => 'patient_id','type'=>'INNER'),
						'LaboratoryTestOrder'=>array('foreignKey'=>'patient_id','conditions'=>array('LaboratoryTestOrder.id=LaboratoryResult.laboratory_test_order_id')),
						'Laboratory' =>array('foreignKey' => false,'conditions'=>array('LaboratoryTestOrder.laboratory_id=Laboratory.id')),
						'AdverseEventTrigger' =>array('foreignKey' => false,'conditions'=>array('Laboratory.sct_concept_id=AdverseEventTrigger.snowmed')),
						'NewCropPrescription'=>array('foreignKey' => false,'conditions'=>array('NewCropPrescription.drug_name LIKE CONCAT("%",AdverseEventTrigger.condition_values,"%")'))
				)));

		$lab_adverse_event_patients = $this->Patient->find('all',array('fields'=>array( 'Laboratory.name','Patient.id','admission_id','lookup_name','age','AdverseEventTrigger.*',
				'NewCropPrescription.archive','NewCropPrescription.drug_name','NewCropPrescription.adverse_event'),
				'conditions'=>array('LaboratoryResult.adverse_event=1','NewCropPrescription.archive'=>'N'),
				'group'=>array('NewCropPrescription.drug_name')
				));

	 
		//EOF labs adverse events
		$combine_array = array_merge($lab_adverse_event_patients, $med_adverse_event_patients); 

		return $combine_array ;
	}
	
	function radiology_events(){
		$this->uses = array('Patient');
		$this->Patient->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn'),
				'belongsTo'=>array('NewCropPrescription','AdverseEventTrigger')));
		$this->Patient->bindModel(array( 
				'belongsTo' => array( 
						'RadiologyResult'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('Patient.id=RadiologyResult.patient_id')),
						'Radiology'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('RadiologyResult.radiology_id=Radiology.id')),
						'AdverseEventTrigger' =>array('type'=>'INNER','foreignKey' => false,'conditions'=>array('OR'=>array('Radiology.cpt_code=AdverseEventTrigger.cpt_code',
								'Radiology.sct_concept_id=AdverseEventTrigger.snowmed','Radiology.lonic_code=AdverseEventTrigger.loinc_code'))),
				)));
		$radiologyResult = $this->Patient->find('all',array('fields'=>array('Patient.id','Patient.admission_id','Patient.lookup_name','Patient.age',
													'Radiology.name','AdverseEventTrigger.*'),'conditons'=>array('RadiologyResult.adverse_event'=>1),'group'=>array('Radiology.name'))) ;
		
		 
		return $radiologyResult ;
	}
	
	function readmissionWithOneMonth(){
		$this->uses = array('Patient');
		$this->Patient->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patients = $this->Patient->Find('all',array('fields'=>array('Patient.form_received_on','Patient.patient_id','Patient.id','Patient.admission_id','Patient.lookup_name',
				'Patient.age','Patient.is_discharge'),'conditions'=>array('is_deleted'=>0),'order'=>array('Patient.patient_id')));
		 
		//$patients= $this->Patient->query('select admission_id from patients where id IN (select id from patients  group by patient_id  HAVING count(patient_id) > 1 and is_deleted =0 )');
 		//debug($patients);
		foreach($patients as $key => $value){
			//debug($value);			 
			$nextArraySet = $patients[$key+1] ;
			//debug($nextArraySet);//exit; 
			$currentAdmissionDateTime = strtotime($value['Patient']['form_received_on']);
			$nextAdmissionDateTime = strtotime($nextArraySet['Patient']['form_received_on']);
			if($value['Patient']['patient_id']==$nextArraySet['Patient']['patient_id']){				 
				$diff = $this->DateFormat->dateDiff($value['Patient']['form_received_on'],$nextArraySet['Patient']['form_received_on']);				 
				if($diff->s > 0 && $diff->m < 31 && $value['Patient']['is_discharge']==0){		 
					$value['AdverseEventTrigger']= array('values'=>'Readmission to hospital within 30 days of last discharge') ;
					$returnPatient[] = $value ; 
					next($patients); //internally set array pointer to next iteration
				}			 
			}			 
		}		 
		return $returnPatient ;
	}
	
	//admission to ICU for any case expect direct admission to ICU
	function admissionToICU(){
		$this->uses = array('Patient');
		$this->Patient->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array('belongsTo'=>array(
				'Ward'=>array('foreignKey'=>'ward_id','type'=>'INNER'),
				'WardPatient'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('Patient.id=WardPatient.patient_id','Patient.ward_id=WardPatient.ward_id')))));		
		$patientList = $this->Patient->find('all',array('fields'=>array( 'Patient.patient_id','Patient.id','Patient.admission_id','Patient.lookup_name',
				'Patient.age','WardPatient.patient_id','WardPatient.id' ),
				'conditions'=>array('Patient.is_deleted'=>0,'Patient.is_discharge'=>0,'Ward.name'=>'ICU', 'Patient.form_received_on != WardPatient.in_date'),
				'order'=>array('WardPatient.id')));
		foreach($patientList as $key => $value){
			$value['AdverseEventTrigger']= array('values'=>'Admission to Higher level') ;
			$returnPatient[] = $value ;
		}
		
		return $returnPatient ;
	}
	
	function over_sedation(){
		$this->uses = array('Patient');
		$medicines = array('amitriptyline','clomipramine','doxepin','imipramine','trimipramine','amoxapine','desipramine','nortriptyline',
							'protriptyline');   
		$this->Patient->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		
		$this->Patient->bindModel(array('belongsTo'=>array(
				'Incident'=>array('foreignKey'=>false,'type'=>'INNER','conditions'=>array('Patient.id=Incident.patient_id')),
				'NewCropPrescription'=>array('foreignKey'=>false,'type'=>'INNER','conditions'=>array('Incident.patient_id=NewCropPrescription.patient_uniqueid'))
				)));
		
		$patientList = $this->Patient->find('all',array('fields'=>array( 'Patient.patient_id','Patient.id','Patient.admission_id','Patient.lookup_name',
				'Patient.age','Incident.analysis_option','NewCropPrescription.drug_name' ),
				'conditions'=>array('Patient.is_deleted'=>0,'Patient.is_discharge'=>0,'Incident.analysis_option'=>1,'NewCropPrescription.archive'=>'N'),
				 ));
		$returnList =array();
		foreach ($patientList as $key => $value){			 
			if($this->strpos_in_array($value['NewCropPrescription']['drug_name'],$medicines)){	
				$value['AdverseEventTrigger']= array('values'=>' Over-sedation, Lethargy, Falls') ;
				$returnList[]= $value ;
			}
		} 
		 
		return $returnList ;  
	}

	function problems(){
		$this->uses = array('Patient') ;
		$this->Patient->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array('belongsTo'=>array(
				'NoteDiagnosis'=>array('foreignKey'=>false,'conditions'=>array('NoteDiagnosis.patient_id=Patient.id')),
				'AdverseEventTrigger' =>array('type'=>'INNER','foreignKey' => false,'conditions'=>array('NoteDiagnosis.snowmedid=AdverseEventTrigger.snowmed'))))) ;
		
		$problems = $this->Patient->find('all',array('fields'=>array('Patient.patient_id','Patient.id','Patient.admission_id','Patient.lookup_name',
				'Patient.age','NoteDiagnosis.diagnoses_name','NoteDiagnosis.snowmedid','AdverseEventTrigger.*'),
				'conditions'=>array('Patient.is_deleted'=>0,'NoteDiagnosis.is_deleted'=>0,'NoteDiagnosis.snowmedid != "" '),'group'=>array('NoteDiagnosis.diagnoses_name')));
		
		 
		 
		return $problems ;
	}
	
	function strpos_in_array($string,$stringArray){
		foreach($stringArray as $key => $value){			 
			if(stripos(trim($string),$value)===0){ //for first occurence only				 
				return true ;
			}
		}
		return false ;
	}
	
	
	//function to add permissions to admin users
	public function module_list(){
		$this->uses  = array('ModulePermission','Facility','AssignedModulePermission','Role') ;
		$modules ="" ;
		App::import('Vendor', 'DrmhopeDB');
		//BOF assigned permission
		$facility = $this->Session->read('facilityid');
		$moduleList  = $this->ModulePermission->find('list',array('fields'=>array('id','module'),'conditions'=>array('OR'=>array('type'=>array('OPD','BOTH'))),
				'order'=>array('ModulePermission.module')));
		$roles = $this->Role->getRolesIncludingAdmin();
		$this->set(array('moduleList'=>$moduleList,'roles'=>$roles)) ;
		//EOF
		$facility  = $this->Facility->find('list',array('fields'=>array('Facility.id','Facility.name')));
		if(!empty($this->request->data['Facility']['role_id']) && !empty($this->request->data['Facility']['module_id']) && !empty($this->request->data['Facility']['facility_id'])){ 
			$modules  = $this->ModulePermission->find('all',array('order'=>array('ModulePermission.module'),'conditions'=>array('OR'=>array('type'=>array('OPD','BOTH'))))); 
			$this->loadModel("LinkedModule");
			$facility_db = $this->Facility->find('first',
					array('conditions' => array('Facility.id' =>
					$this->request->data['Facility']['facility_id'])));
			$db_connection = new DrmhopeDB($facility_db['FacilityDatabaseMapping']['db_name']);
			$db_connection->makeConnection($this->LinkedModule);
			$linkedModule = $this->LinkedModule->find('list',array('fields'=>array('id','module_permission_parent_id'),
					'conditions'=>array('role_id'=>$this->request->data['Facility']['role_id'],
					'module_permission_id'=>$this->request->data['Facility']['module_id'])));   
			
			$sortOrder = $this->LinkedModule->find('list',array('fields'=>array('module_permission_parent_id','sort_order'),
					'conditions'=>array('role_id'=>$this->request->data['Facility']['role_id'],
							'module_permission_id'=>$this->request->data['Facility']['module_id'])));
		}
		 
		
		$this->set(array('modules'=> $modules,'hospitals'=>$facility,'linkedModule'=>$linkedModule,'sortOrder'=>$sortOrder));
	}
	
	public function assign_module_set(){
		$this->layout = 'ajax';
		$this->autoRender = false ;
		$this->uses =  array('LinkedModule','Facility') ;			
		if(!empty($this->request->data['module_permission_id']) && !empty($this->request->data['facility_id'])){
			App::import('Vendor', 'DrmhopeDB');
			$facility_db = $this->Facility->find('first',
					array('conditions' => array('Facility.id' =>
					$this->request->data['facility_id'])));
			$db_connection = new DrmhopeDB($facility_db['FacilityDatabaseMapping']['db_name']);
			$db_connection->makeConnection($this->LinkedModule);
			//search if already exit
			$isExist= $this->LinkedModule->find('first',array('conditions'=>array('module_permission_id'=>$this->request->data['module_permission_id'],
					'role_id'=>$this->request->data['role_id'],'module_permission_parent_id'=>$this->request->data['module_permission_parent_id']))) ;
			if(!empty($isExist['LinkedModule']['id'])){
				$this->request->data['id'] = $isExist['LinkedModule']['id'];
			}
			//EOD search 
			$sort_order =array();
			if(!empty($this->request->data['sort_order'])){
				$sort_order   = array('sort_order'=>$this->request->data['sort_order']); //for sort order 
			} 
			$data = array('id'=>$this->request->data['id'],
					'role_id'=>$this->request->data['role_id'],
					'module_permission_id'=>$this->request->data['module_permission_id'],
					'module_permission_parent_id'=>$this->request->data['module_permission_parent_id']); 
			
			$data = array_merge($data,$sort_order) ; 
			 
			$result = $this->LinkedModule->save($data);
			if($result){
				echo  trim($this->LinkedModule->id) ;
			}else{
				echo "Please try again" ;
			}
		} 
	}
	
	public function remove_module(){
		$this->layout = 'ajax';
		$this->autoRender = false ;
		$this->uses =  array('LinkedModule','Facility') ;
		 
		if(!empty($this->request->data['module_permission_id']) && !empty($this->request->data['id']) && !empty($this->request->data['facility_id'])){
			App::import('Vendor', 'DrmhopeDB');
			$facility_db = $this->Facility->find('first',
					array('conditions' => array('Facility.id' =>
					$this->request->data['facility_id'])));
			$db_connection = new DrmhopeDB($facility_db['FacilityDatabaseMapping']['db_name']);
			$db_connection->makeConnection($this->LinkedModule);
			$result = $this->LinkedModule->delete($this->request->data['id']);
			if($result){
				return  ;
			}else{
				echo "Please try again" ;
			}
		}
	}
	
}