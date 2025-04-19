<?php
/**
 * Ccda parser
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       PharmacyItem Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj Wanjari
 */

class CcdaParser extends AppModel {
		public $ccdaData =null ;
		public $location_id  =null ;
		public $diagnosis = null ;
		public $error = false ;
		public $patient_id = null ;
		public $person_id = null ;
		public $patient_uid = null ;
		public $user_id = null ;
		public $note_id =null ;
		function __construct($xml=null){ 
			$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
			parent::__construct($id, $table, $ds);			
			$xml = file_get_contents($xml['id']);
			App::import('Vendor', 'Ccdas', array('file' => 'Ccda.php'));
			$patient = new Ccdas($xml);
			
			$obj = $patient->construct_json();		
			 
			$this->ccdaData = json_decode($obj);  			 
			$session = new cakeSession();
			$this->location_id = $session->read('locationid') ; 
			$this->user_id = $session->read('userid') ;
			//insert blank record if not exist
			$ids = Router::getRequest()->data(); //post vars from import page
			$patientIds  =$ids['ccda'] ;
			if($patientIds['patient_id'] != ''){
				$this->insertBlankDiagnosis();
			}
		}
		
		function insertBlankDiagnosis(){
			$patientCcdaObj = $this->ccdaData;
			 
			$ids = Router::getRequest()->data(); //post vars from import page
			$patientIds  =$ids['ccda'] ;
			 
			$diagnosisModel = ClassRegistry::init('Diagnosis');
			$noteModel = ClassRegistry::init('Note');
			$result = $diagnosisModel->find('first',array('conditions'=>array('patient_id'=>$patientIds['patient_id']),'fields'=>array('id')));
			if($result['Diagnosis']['id']==''){
				$tempArray = array(
						'id'=>$result['Diagnosis']['id'], 
						'patient_id'=>$patientIds['patient_id'],
						'create_time'=>date('Y-m-d'),
						'modify_time'=>date('Y-m-d'),
						'location_id'=>$this->location_id);  
				$diagnosisModel->set($tempArray);
				$this->diagosis = $diagnosisModel->getLastInsertID();
			}else{
				$this->diagnosis = $result['Diagnosis']['id'] ;
			}
			 
			$noteResult = $noteModel->find('first',array('conditions'=>array('patient_id'=>$patientIds['patient_id']),'fields'=>array('id'),'order'=>array('Note.id Desc')));
			if($noteResult['Note']['id'] == ''){
				$noteModel->save(array('patient_id'=>$patientIds['patient_id'],'note_type'=>'general','note_date'=>date('Y-m-d H:i:s'),'create_time'=>date('Y-m-d H:i:s'))) ;
				$notesID = $noteModel->getLastInsertID();
				$this->note_id = $notesID ;
			}else{
				$this->note_id = $noteResult['Note']['id'];
			}
			 
		}
		
		/* public function getCCDAObj(){
			$xml = file_get_contents('uploads/CCDA/Myra  Jones_UDHO13I03017.xml');
			App::import('Vendor', 'Ccda', array('file' => 'Ccda.php'));
			$patient = new Ccda($xml);
			$obj = $patient->construct_json();
			$objVal = json_decode($obj);echo'<pre>';print_r($objVal);exit;
			return $objVal;
		} */
		
		
		public function setTargetPatient($patientArray){
			 $this->patient_id = $patientArray['patient_id'];
			 $this->person_id = $patientArray['person_id'] ;
			 $this->patient_uid = $patientArray['patient_uid'];
		}
		
		public function getTargetPatient(){ 
			return array('patient_id'=>$this->patient_id,'person_id'=>$this->person_id,'patient_uid'=>$this->patient_uid);  
		}
		
		//person
		public function updateDemographics(){
			$person = ClassRegistry::init('Person');
			$country = ClassRegistry::init('Country');
			$state = ClassRegistry::init('State');
			$patientCcdaObj = $this->ccdaData;
			$patientIds = $this->getTargetPatient($patientCcdaObj);
			
			//$patientIds['person_id'] = 1387 ; //temp person id for myra jones
			$person->read(null, $patientIds['person_id']);
		
			$states = $state->find('list',array('fields'=>array('name','state_code')));
			$countries = $country->find('list');
			$maritail_status = array("A"=>"Separated","B"=>"Unmarried","C"=>"Common law","D"=>"Divorced","E"=>"Legally Separated","G"=>"Living together",
									 "I"=>"Interlocutory","M"=>"Married","N"=>"Annulled","O"=>"Other","P"=>"Domestic partner","R"=>"Registered domestic partner","S"=>"Single",
									 "T"=>"Unreported","U"=>"Widowed","W"=>"Unknown");
	 
			$personArray = array(
										'plot_no' => $patientCcdaObj->addr->street[0],
										'landmark' => $patientCcdaObj->addr->street[1],
										'city' => $patientCcdaObj->addr->city,
										'state' => array_search($patientCcdaObj->addr->state,$states),
										'pin_code' => $patientCcdaObj->addr->postalCode,
										'country' => array_search($patientCcdaObj->addr->country,$countries),
										'home_phone' => str_replace('tel:','',$patientCcdaObj->phone->number),
										'dob' => date('Y-m-d',strtotime($patientCcdaObj->birthdate)),
										'maritail_status' => array_search($patientCcdaObj->maritalStatus,$maritail_status), 
								);
			 
			$person->set($personArray);
		 
			echo "<pre>" ;
			if($person->save()){
				echo "Person entries updated successfully" ;
			}else{
				$this->error = true ;
				echo "Please try again with Person";
			}  
			 
		}
		
		//new_crop_medication table
		public function updateMedications(){
			$patientCcdaObj = $this->ccdaData;
			$patientIds = $this->getTargetPatient($patientCcdaObj);
			$newCropModel = ClassRegistry::init('NewCropPrescription');  
			if(empty($patientCcdaObj->rx)){
				return ;
			}
			foreach($patientCcdaObj->rx as $rx){
				$tempArray  = array(
						'date_of_prescription' => (!empty($rx->date_range->start)) ? date('Y-m-d',strtotime($rx->date_range->start)) : '',
						'end_date' => (!empty($rx->date_range->end)) ? date('Y-m-d',strtotime($rx->date_range->end)) : '',
						'rxnorm' => $rx->translation->code,
						'route' =>  $rx->route,
						'description' => $rx->product_name_desc,
						'drug_id' => $rx->product_code,
						'dose' => $rx->dose_quantity->value.', '.$rx->dose_quantity->unit,
						'frequency' => $rx->dose_frequency,
						'patient_id' => $patientIds['patient_uid'],
						'patient_uniqueid'=>$patientIds['patient_id'],
						'code_system' => $rx->translation->code_system,
						'location_id'=>$this->location_id,
						'archive'=>"N",
						'is_ccda' => 1,
						'created'=>date('Y-m-d H:i:s'),
						'modified'=>date('Y-m-d H:i:s'),
				) ;
			 
				
				 
				echo "<pre>" ;
				if($newCropModel->save($tempArray)){
					echo "Medication added successfully" ;
					$newCropModel->id = '';
				}else{
					echo "Please try again Medication";
					$this->error = true ;
				} 
			} 
		} 
		
		//new_crop_allergies
		public function updateAllergy(){
			$patientCcdaObj = $this->ccdaData;
			$patientIds = $this->getTargetPatient($patientCcdaObj);
			$newCropAllergyModel = ClassRegistry::init('NewCropAllergies');
			if(empty($patientCcdaObj->allergy)){
				return ;
			}
			foreach($patientCcdaObj->allergy as $allergy){
				$tempArray = array(
						'start_date' => (!empty($allergy->date_range->start)) ? date('Y-m-d',strtotime($allergy->date_range->start)) : '',
						'end_date' => (!empty($allergy->date_range->end)) ? date('Y-m-d',strtotime($allergy->date_range->end)) : '',
						'name' => $allergy->allergen->name,
						'rxnorm' => $allergy->allergen->code,
						'code_system' => $allergy->allergen->code_system_name,
						'reaction_type' => $allergy->reaction_type->name,
						'reaction' => $allergy->reaction->name,
						'AllergySeverityName' => $allergy->severity->name,
						'patient_id' => $patientIds['patient_uid'],
						'status'=>strtoupper(substr($allergy->status->name,0,1)),
						'allergies_id'=>$allergy->reaction->code,
						'is_ccda' => 1,
						'location_id'=>$this->location_id,
						'patient_uniqueid'=>$patientIds['patient_id'],
						'created'=>date('Y-m-d H:i:s'),
						'modified'=>date('Y-m-d H:i:s'),
		
				) ;
			   
				 
				echo "<pre>" ;
				if($newCropAllergyModel->save($tempArray)){
					echo "Allergies added successfully added successfully" ;
					$newCropAllergyModel->id = '';
				}else{
					echo "Please try again with Allergies";
					$this->error = true ;
				} 
			} 
		}
		
		//note_diagnosis
		public function updateProblems(){
			$patientCcdaObj = $this->ccdaData;
			$patientIds = $this->getTargetPatient($patientCcdaObj);
			$newCropProblemModel = ClassRegistry::init('NoteDiagnosis');
			if(empty($patientCcdaObj->dx)){
				return ;
			}
			 
			foreach($patientCcdaObj->dx as $problem){
				$tempArray = array(
						'note_id'=>$this->note_id,
						'start_dt' => (!empty($problem->date_range->start)) ? date('Y-m-d',strtotime($problem->date_range->start)) : '',
						'end_dt' => (!empty($problem->date_range->end)) ? date('Y-m-d',strtotime($problem->date_range->end)) : '',
						'diagnoses_name' => $problem->name,
						'snowmedid' => $problem->code,
						'code_system' => $problem->translation->code_system_name,
						'status' => $problem->status,
						'disease_status'=>'cronic',
						'u_id' => $patientIds['patient_uid'],
						'patient_id'=>$patientIds['patient_id'],
						'is_ccda'=>1
						) ;
				 
				//$newCropProblemModel->set($tempArray); 
				
				echo "<pre>" ;
				if($newCropProblemModel->save($tempArray)){  
					$newCropProblemModel->id = '';
					echo "Problems added successfully  " ;
				}else{
					echo "Please try again Problems";
					$this->error = true ;
				} 
			} 
		}
		
		//immunization
		public function updateImmunizations(){
			$patientCcdaObj = $this->ccdaData ;
			$patientIds = $this->getTargetPatient($patientCcdaObj);
			$immunizationModel = ClassRegistry::init('Immunization');
			$imunizationModel = ClassRegistry::init('Imunization');
			$routes = ClassRegistry::init("PhvsAdminsRoute"); 
			//search route id  
			if(empty($patientCcdaObj->immunizaiton)){
				return ;
			}
			foreach($patientCcdaObj->immunizaiton as $immunization){
				$result  = $routes->find('first',array('conditions'=>array('value_code'=>$immunization->route->code)));
				 
				$isVaccineExist  = $imunizationModel->find('first',array('conditions'=>array('value_code'=>$immunization->product->code,'code_system'=>$immunization->product->code_system_name)));
				 
				if(!$isVaccineExist){
					$saveMasterEntry = array('value_code'=>$immunization->product->code,
											'cpt_description'=>$immunization->product->name,
											'code_system'=>$immunization->product->code_system_name,
											) ;
					$imunizationModel->save($saveMasterEntry);
					$vaccineId = $imunizationModel->id ;
				}else{
					$vaccineId  = $isVaccineExist['Imunization']['id'];
				}
			 	$tempArray = array( 'vaccine_type'=>$vaccineId,
									'product_code'=>$immunization->product->code,
									'route'=>$result['PhvsAdminsRoute']['id'],
									'product_code_system_name'=>$immunization->product->code_system_name,
								//	'route_code_system_name'=>$immunization->route->code_system_name,
									'patient_id' => $patientIds['patient_id'],
			 						'presented_date'=>date('Y-m-d',strtotime($immunization->date)),
			 						'create_time'=>date('Y-m-d H:i:s'),
			 						'modify_time'=>date('Y-m-d H:i:s'),
			 						); 
			 	$immunizationModel->set($tempArray);
			 	echo "<pre>" ;
			 	if($immunizationModel->save()){ 
			 		$immunizationModel->id = ''; 
			 		echo "Immunization added successfully  " ;
			 	}else{
			 		echo "Please try again Immunization";
			 		$this->error = true ;
			 	} 
			} 
		}
		
		//Diagnosis 
		public function updateVitals(){
			$patientCcdaObj = $this->ccdaData;
			$patientIds = $this->getTargetPatient($patientCcdaObj);
			$diagnosisModel = ClassRegistry::init('Diagnosis');
			if(empty($patientCcdaObj->vital)){
				return ;
			}
			$result = $diagnosisModel->find('first',array('conditions'=>array('patient_id'=>$patientIds['patient_id']),'fields'=>array('id')));
			 
			foreach($patientCcdaObj->vital as $diagnosis){
				foreach ($diagnosis->results as $vitals){
					if($vitals->code == '8302-2'){
						$height = $vitals->value;
					}
					if($vitals->code == '3141-9'){
						$weight = $vitals->value;
					}
					if($vitals->code == '8480-6'){
						$systolic = $vitals->value;
					}
					if($vitals->code == '8462-4'){
						$distolic = $vitals->value;
					}
					if($vitals->code == '41909-3'){
						$bmi = $vitals->value;
					}
				}  
				$tempArray = array(
						'id'=>$result['Diagnosis']['id'],
						'height'=>$height,
						'weight'=>$weight,
						'BP'=>$systolic."/".$distolic,
						'bmi'=>$bmi,
						'patient_id'=>$patientIds['patient_id'],
						'create_time'=>date('Y-m-d'),
						'modify_time'=>date('Y-m-d'),
						'location_id'=>$this->location_id);

				 
				//$diagnosisModel->set($tempArray);
				echo "<pre>" ;
				if($diagnosisModel->save($tempArray)){
					$diagnosisModel->id = '';
					echo "Vital signs added successfully  " ;
				}else{
					echo "Please try again Vital";
					$this->error = true ;
				} 
			} 
		}
		
		//labresult
		public function updateLabResults(){
			$patientCcdaObj = $this->ccdaData;
			$patientIds = $this->getTargetPatient($patientCcdaObj);
			$labOrder = ClassRegistry::init('LaboratoryTestOrder');
			$lab = ClassRegistry::init('Laboratory');
			$labRes = ClassRegistry::init('LaboratoryResult');
			$labResHl7 = ClassRegistry::init('LaboratoryHl7Result');
			 
			if(empty($patientCcdaObj->lab)){
				return ;
			}
			foreach($patientCcdaObj->lab as $rto){
				foreach ($rto->results as $result){
					$labResult = $lab->find('first',array('conditions'=>array('name'=>$result->name)));
					 
					if($labResult['Laboratory']['id'] == ''){
						//insert new taste
						$lab->save(array(
								'name'=>$result->name,
								'location_id'=>$this->location_id,
								'lonic_code'=>$result->code,
								'create_time'=>date('Y-m-d'),
								'modify_time'=>date('Y-m-d'))) ;
						$lab_id = $lab->getLastInsertID();
					}else{
						$lab_id =$labResult['Laboratory']['id'] ;
					}
					$tempArray = array(	'laboratory_id'=>$lab_id, 
										'patient_id' => $patientIds['patient_id'],
										'batch_identifier'=>strtotime(date('Y/m/d')),
										'create_time'=>date('Y-m-d H:i:s'),
										'modify_time'=>date('Y-m-d H:i:s')) ;
					
					$labOrder->set($tempArray);
					$labOrder->save();
				 	$labOrderId =  $labOrder->autoGeneratedLabID($labOrder->id); 
					$labOrder->save(array('order_id'=>$labOrderId));
					$labOrderId= $labOrder->getLastInsertID();
					$labResTemp = array('laboratory_test_order_id'=>$labOrderId,
										'patient_id'=>$patientIds['patient_id'],
										'laboratory_id'=>$lab_id,
										);
					//$labRes->set($labResTemp);
					$labRes->save($labResTemp); 
					//hl7labresult
					$labResHl7Temp = array('laboratory_result_id'=>$labRes->id,
										'location_id'=>$this->location_id,
										'result'=>$result->value,
										'date_time_of_observation'=>date("Y-m-d",strtotime($result->date)),
										'range'=>$result->range,
										'uom'=>$result->unit,
										'create_time'=>date('Y-m-d H:i:s'),
										'modify_time'=>date('Y-m-d H:i:s')) ;
					$labResHl7->set($labResHl7Temp);
					$labResHl7->save(); 
					//make refressh
					$labResHl7->id = '' ;
					$labRes->id = '' ;
					$labOrder->id='';
					$lab->id='';
				} 
			} 
			echo "<pre>" ;
			echo "Lab result added successfully"; 
			
		}
		
		function updateSmoking(){
			$patientCcdaObj = $this->ccdaData ;
			$patientIds = $this->getTargetPatient($patientCcdaObj);
			$patientSmoke = ClassRegistry::init('PatientSmoking');
			$patientHistory = ClassRegistry::init('PatientPersonalHistory');
			$smokeStatus = ClassRegistry::init('SmokingStatusOncs');
			if(empty($patientCcdaObj->smoke)){
				return ;
			} 
			$isSmokeExist  = $patientHistory->find('first',array('conditions'=>array('diagnosis_id'=>$this->diagnosis))); 
			if(!$isSmokeExist){ 
				$patientHistory->save(array('diagnosis_id'=>$this->diagnosis,
						'smoking'=>1  //set smoke to yes in personal history
				)); 
				$patientHistoryID = $patientHistory->getLastInsertID();
			}else{
				$patientHistoryID = $isSmokeExist['PatientPersonalHistory']['id'];
			}  
			
			$smokeStatusCount = count($patientCcdaObj->smoke) ;
			$i = 0 ;
			echo "<pre>";
			
			//search route id
			foreach($patientCcdaObj->smoke as $smokeArray){
				 
				$i++ ;
				if($smokeArray->code=='160573003'){ //for alcohol
					 
					$patientHistory->save(array(
							'id'=>$patientHistoryID,
							'diagnosis_id'=>$this->diagnosis,
							'alcohol'=>1 , //set smoke to yes in personal history
							'alcohol_desc'=>date('Y-m-d',strtotime($smokeArray->low))
					)); 
					echo "<pre>" ;
					echo "Alcohol status updated" ;
					continue ;
				}
				$isStatusExist  = $smokeStatus->find('first',array('conditions'=>array('snomed_id'=>$smokeArray->snowmed_code)));
				if(!$isStatusExist){ 
					$smokeStatus->save(array('snomed_id'=>$smokeArray->snowmed_code,
							'description'=>$smokeArray->value,
							'created'=>date('Y-m-d H:i:s'),
							'modified'=>date('Y-m-d H:i:s'),
							));
					$smokeStatusId= $smokeStatus->getLastInsertID();
				}else{
					$smokeStatusId = $isStatusExist['SmokingStatusOncs']['id'] ; 
				}
				if($smokeStatusCount == $i && $i >1 ){
					$patientSmokeArray1 = array( 
							'smoking_fre'=>$smokeStatusId);
				}else{
					$patientSmokeArray = array( 'patient_id'=>$patientIds['patient_id'],
												'diagnosis_id'=>$this->diagnosis,
												'current_smoking_fre'=>$smokeStatusId,
												'from'=>date('Y-m-d',strtotime($smokeArray->low)),
												'to'=>date('Y-m-d',strtotime($smokeArray->high)),
												'created_date'=>date('Y-m-d H:i:s')) ;
				} 
			} 
			if(is_array($patientSmokeArray1)){
				$patientSmokeArray = array_merge($patientSmokeArray,$patientSmokeArray1) ; 
			} 
			//$patientSmoke->set($patientSmokeArray) ; 
			if($patientSmoke->save($patientSmokeArray)){
				$patientSmoke->id = '';
				echo "Smoking status added successfully  " ;
			}else{ 
				echo "Please try again smoking";
				$this->error = true ;
			}
		}
		
		function updateProcedures(){
			$patientCcdaObj = $this->ccdaData ;
			$patientIds = $this->getTargetPatient($patientCcdaObj);
			$radOrder = ClassRegistry::init('RadiologyTestOrder'); 
			$radiology = ClassRegistry::init("Radiology"); 
			if(empty($patientCcdaObj->proc)){
				return ;
			}
			 
			//search route id
			foreach($patientCcdaObj->proc as $radioOrder){ 
				 
				$radResult = $radiology->find('first',array('conditions'=>array('OR'=>array('sct_concept_id'=>$radioOrder->code,'name'=>$radioOrder->name)))); 
				 
				if($radResult['Radiology']['id'] == ''){
					//insert new record
					$radiology->id= "" ;
					$radiology->save(array(
							'name'=>$radioOrder->name,
							'sct_concept_id'=>$radioOrder->code,
							'location_id'=>$this->location_id, 
							'create_time'=>date('Y-m-d'),
							'modify_time'=>date('Y-m-d'))) ;
					$lab_id = $radiology->getLastInsertID();
					 
				}else{
					 
					$lab_id =$radResult['Radiology']['id'] ;
				}
				 
				$tempArray = array(	'radiology_id'=>$lab_id,
						'patient_id' => $patientIds['patient_id'], 
						'create_time'=>date('Y-m-d H:i:s'),
						'batch_identifier'=>strtotime(date('Y/m/d')),
						'modify_time'=>date('Y-m-d H:i:s'),
						'from_assessment'=>1,
						'start_date'=>($radioOrder->date)?date('Y-m-s',strtotime($radioOrder->date)):"", ) ;

				//$radOrder->set($tempArray); 
				echo "<pre>" ;
				if($radOrder->save($tempArray)){
					//$radOrder->save();
					$radOrderId =  $radOrder->autoGeneratedRadID($radOrder->id);
					$radOrder->save(array('id'=>$radioOrder->id,'order_id'=>$radOrderId));
					$radOrder->id= '';
					$radiology->id='';
					 
					echo "Procedures added successfully  " ;
				}else{
					echo "Please try again Procedures";
					$this->error = true ;
				}
			}
		}
		
		public function updateEncounters(){
			//from last problem
			/* $patientCcdaObj = $this->ccdaData ;
			$patientIds = $this->getTargetPatient($patientCcdaObj);
			$noteDiagnosis = ClassRegistry::init('NoteDiagnosis');
			$notes = ClassRegistry::init("Note");
			//search route id
			if(empty($patientCcdaObj->enc)){
				return ;
			} 
			$notesID = $this->note_id;
			foreach($patientCcdaObj->enc as $problems){
				
				$tempArray = array('note_id'=>$notesID,
						'patient_id'=>$patientIds['patient_id'],
						'u_id'=>$patientIds['patient_uid'],
						'diagnoses_name'=>$problems->finding->name, 
						'start_dt' => date('Y-m-d',strtotime($problems->finding->low)),
						'end_dt' => ($problems->finding->high)?date('Y-m-s',strtotime($problems->finding->high)):"",
						'snowmedid'=>$problems->finding->code, 
						'status'=>($problems->finding->high)?'Resolved':'Active',
						'created'=>date('Y-m-d H:i:s'),
						'modified'=>date('Y-m-d H:i:s'),
				);
				 
			 
				echo "<pre>" ;
				if($noteDiagnosis->save($tempArray)){
					$noteDiagnosis->id = '';
					echo "Encounter added successfully  " ;
				}else{
					echo "Please try again Encounter";
					$this->error = true ;
				}
			} */
		}
		
		public function updateFunctionalStatus(){
			$patientCcdaObj = $this->ccdaData ;
			$patientIds = $this->getTargetPatient($patientCcdaObj);
			$cognitiveFunction = ClassRegistry::init('CognitiveFunction');
			$notes = ClassRegistry::init('Note');
			$notesID = $this->note_id ;
			if(empty($patientCcdaObj->functionalStatus)){
				return ;
			} 
			foreach($patientCcdaObj->functionalStatus as $cognitive){
			
				if(strtolower($cognitive->name)=='complaints'){
					$isCognitive = 0;
				}else{
					$isCognitive = 1;
				}
				$tempArray = array(
						'note_id'=>$notesID , 
						'location_id'=>$this->location_id,
						'patient_id'=>$patientIds['patient_id'],
						'is_cognitive'=>$isCognitive,
						'cog_name'=>$cognitive->value,
						'cog_date'=>date('Y-m-d H:i:s',strtotime($cognitive->low)), 
						'cog_snomed_code'=>$cognitive->code,
						'status'=>($problems->finding->high)?'Resolved':'Active',
						'create_time'=>date('Y-m-d H:i:s'),
						'modify_time'=>date('Y-m-d H:i:s'),
				);
					
				 
				echo "<pre>" ;
				if($cognitiveFunction->save($tempArray)){
					$cognitiveFunction->id = '';
					echo "Fuctional/Cognitive status added successfully  " ;
				}else{
					echo "Please try again Fuctional/Cognitive";
					$this->error = true ;
				}
			}
		}
		
		function updatePlanCare(){
			$patientCcdaObj = $this->ccdaData ;
			$patientIds = $this->getTargetPatient($patientCcdaObj);
			$plannedProblem = ClassRegistry::init('PlannedProblem');
			if(empty($patientCcdaObj->care_plan)){
				return ;
			}
			foreach($patientCcdaObj->care_plan as $problems){ 
				$tempArray = array( 'patient_id'=>$patientIds['patient_id'],
						'snomed_description'=>$problems->name,
						'sct_concept_id'=>$problems->code,
						'instruction' => $problems->text,
						'plan_date' => ($problems->date)?date('Y-m-s',strtotime($problems->date)):"", 
						'location_id'=>$this->location_id,
						'created_by'=>$this->user_id,
						'create_time'=>date('Y-m-d H:i:s'),
						'modify_time'=>date('Y-m-d H:i:s'),
				); 
			 
				echo "<pre>" ;
				if($plannedProblem->save($tempArray)){
					$plannedProblem->id = '';
					echo "Care plan added successfully  " ;
				}else{
					echo "Please try again for care plan";
					$this->error = true ;
				}
			}
		}
}

//=========end=========