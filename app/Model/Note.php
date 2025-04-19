<?php
class Note extends AppModel {

	public $name = 'Note';

	/**
	 * add/update note
	 *
	 * @param data : note details
	 * @param action  : "insert/update" action to be done
	 * @return latest insert id
	 **/
	 
	 public $specific = true;
	 
	 public $actsAs = array('Cipher' => array('autoDecypt' => true,'cipher'=>array('present_condition','investigation','pre_opt','post_opt','surgery'
	 ,'implants','event_note','note','anaesthesia_note','surgery'))/*, 'Auditable'*/);  
	 
	 function __construct($id = false, $table = null, $ds = null) {
        if(empty($ds)){
        	$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	 	}else{
	 		$this->db_name =  $ds;
	 	}
		parent::__construct($id, $table, $ds);
     }
      
public function insertNote($data=array()){
              $session = new cakeSession();
              $drug            = ClassRegistry::init('PharmacyItem');          
              $suggestedDrug    = ClassRegistry::init('SuggestedDrug');            
              
              if(isset($data['Note']['id']) && !empty($data['Note']['id'])){
                  //set id for update d record
                  $data['Note']['modify_time']= date("Y-m-d H:i:s");
                   $data['Note']["modified_by"] =  $session->read('userid');
               
                  $note_id =$data['Note']['id'] ;                   
              }else{                  
                  $data['Note']['create_time'] = date("Y-m-d H:i:s");
                   $data['Note']["created_by"]  =  $session->read('userid');                 
              }
               
              $noteSave  = $this->save($data);  //return of main query
              if(empty($note_id)){
                  $note_id = $this->getInsertID();
              }
              //EOF check and insert diagnosis of patient
              $suggestedDrug->deleteAll(array('SuggestedDrug.note_id' => $note_id), false);
           
              //BOF check and insert drugs
              foreach($data['drug'] as $key =>$value){   
                  if(!empty($value)){               
                      $drugResult= $drug->find('first',array('fields'=>array('id','name'),'conditions'=>array('PharmacyItem.name'=>$value,"PharmacyItem.pack"=>$data['Pack'][$key],"PharmacyItem.location_id"=> $session->read('locationid'))));                   
                      $drug->id ='';
                      $suggestedDrug->id = '';
                      if($drugResult){
                          $data['SuggestedDrug']['drug_id'] = $drugResult['PharmacyItem']['id'];
                      }else{
                          $drug->save(array('name'=>$value,'pack'=>$data['Pack'][$key],'location_id'=> $session->read('locationid')));                       
                          $data['SuggestedDrug']['drug_id']= $drug->getInsertID();
                      }
                      //BOF check and insert diagnosis drugs of patient
                      
                      $data['SuggestedDrug']['note_id']=$note_id;
                      $data['SuggestedDrug']['route']=  $data['route'][$key];
                      $data['SuggestedDrug']['dose']= $data['dose'][$key]; 
                      $data['SuggestedDrug']['frequency']= $data['frequency'][$key];
                      $data['SuggestedDrug']['quantity']= $data['quantity'][$key];
                      
                      if(is_array($data['drugTime'][$key])){                          
                              $data['SuggestedDrug']['first']=  isset($data['drugTime'][$key][0])?$data['drugTime'][$key][0]:'';
                              $data['SuggestedDrug']['second']= isset($data['drugTime'][$key][1])?$data['drugTime'][$key][1]:''; 
                              $data['SuggestedDrug']['third']= isset($data['drugTime'][$key][2])?$data['drugTime'][$key][2]:'';
                              $data['SuggestedDrug']['forth']= isset($data['drugTime'][$key][3])?$data['drugTime'][$key][3]:'';                          
                      }
                      
                      $suggestedDrug->save($data['SuggestedDrug']);
                      unset($data['SuggestedDrug']);
                      //EOF check and insert diagnosis drugs of patient                   
                  }
              }
              
              return $noteSave  ;
              //EOF check and insert drugs                         
      }

      
     public function insertDrug($data=array()){
     	
      	$session = new cakeSession();
      	$drug= ClassRegistry::init('PharmacyItem');
      	$suggestedDrug	= ClassRegistry::init('SuggestedDrug');
      	$pharmacyItem	= ClassRegistry::init('PharmacyItemDetail');
      	$newcropprescription= ClassRegistry::init('NewCropPrescription');
      	$patient = ClassRegistry::init('Patient'); 
      	if(isset($data['Note']['id']) && !empty($data['Note']['id'])){
      		//set id for update d record
      		$checkFieldsVal = $this->read(null,$data['Note']['id']);
      		if($checkFieldsVal['Note']['ht'] !="" && $data['Note']['ht'] == "") {
      			$data['Note']['ht'] = "0";
      		}
      		if($checkFieldsVal['Note']['wt'] !="" && $data['Note']['wt'] == "") {
      			$data['Note']['wt'] = "0";
      		}
      		if($checkFieldsVal['Note']['bp'] !="" && $data['Note']['bp'] == "") {
      			$data['Note']['bp'] = "0";
      		}
      		$data['Note']['modify_time']= date("Y-m-d H:i:s");
      		$data['Note']["modified_by"] =  $session->read('userid');
      		 
      		$note_id =$data['Note']['id'] ;
      	}else{
      		$data['Note']['create_time'] = date("Y-m-d H:i:s");
      		$data['Note']["created_by"]  =  $session->read('userid');
      	}
      	
      	//$noteSave  = $this->save($data);  //return of main query
      	/*if(empty($note_id)){
      		$note_id = $this->getInsertID();
      	}*/
      	//EOF check and insert diagnosis of patient
      	if(!(empty($data['drug_id']['0'])))
      	{
      	    $suggestedDrug->deleteAll(array('SuggestedDrug.patient_id'=>$data['Note']['patientId']), false); 
      	  //$newcropprescription->deleteAll(array('NewCropPrescription.patient_uniqueid'=>$data['Note']['patientId'],'NewCropPrescription.id'=>$data['newCrop']['0']), false); 
      	}
      	//BOF check and insert drugs
      	
      	$commonTimEachMedication = time();  // Added by Mrunal for new Crop Table (NursePrescription)
      	foreach($data['drugText'] as $key =>$value){ 
      		/*$value=str_replace("&","@@", $value);
      		$value=str_replace("+","plusop",$value);
			$value =str_replace("-","minussi",$value);
			$value =str_replace(">","greatsym",$value);
			$value =str_replace("<","lessmar",$value);*/
      		if(!empty($data['drug_id'][$key])){
      			 
      		if(!empty($value)){
      			//$drugResult= $drug->find('first',array('fields'=>array('id','name'),'conditions'=>array('PharmacyItem.name'=>$value,"PharmacyItem.pack"=>$data['Pack'][$key],"PharmacyItem.location_id"=> $session->read('locationid'))));
      			/* Loaction Id for APAM in vadodara by MRUNAL*/
      			if($session->read('website.instance')=='vadodara'){
      				$drugResult= $drug->find('first',array('fields'=>array('id','name','code','location_id'),'conditions'=>array('PharmacyItem.name'=>$value/* ,"PharmacyItem.location_id"=> $session->read('locationid') */)));
      				$locationID = $drugResult['PharmacyItem']['location_id'];
      			}else{
      				$drugResult= $drug->find('first',array('fields'=>array('id','name','code'),'conditions'=>array('PharmacyItem.name'=>$value,"PharmacyItem.location_id"=> $session->read('locationid'))));
      			}
      			
      			$drug->id ='';
      			$suggestedDrug->id = '';
      			
      			if($drugResult){
      				$data['SuggestedDrug']['drug_id'] = $drugResult['PharmacyItem']['id'];
      				$data['NewCropPrescription']['drug_id'] = $drugResult['PharmacyItem']['id'];
      			}else{
      				//$drug->save(array('name'=>$value,'location_id'=> $session->read('locationid')));
      				//$data['SuggestedDrug']['drug_id']= $drug->getInsertID();
      				//$data['NewCropPrescription']['drug_id'] = $drug->getInsertID();;
      			}
      			//BOF check and insert diagnosis drugs of patient
      			
      		//explode drug name
      		$drug_name=explode(" ",$value);
				$data['SuggestedDrug']['note_id']=$data['Note']['noteId'];
      			$data['SuggestedDrug']['route']=  $data['route_administration'][$key];
      			 if(empty($data['dose_type'][$key])){
      				$data['dose_type'][$key]='0';
      			} 
      			$data['SuggestedDrug']['dose']= $data['dose_type'][$key];
      			 /* if(empty($data['frequency'][$key])){
      				$data['frequency'][$key]='2';
      			} */ 
      			$data['SuggestedDrug']['frequency']= $data['frequency'][$key];
      			$data['SuggestedDrug']['strength']= $data['DosageForm'][$key];
      			$data['SuggestedDrug']['dosageValue']= $data['dosageValue'][$key];
      			$data['SuggestedDrug']['refills']= $data['refills'][$key];
      			$data['SuggestedDrug']['quantity']= $data['quantity'][$key];				
      			$data['SuggestedDrug']['prn']= $data['prn'][$key];
      			$data['SuggestedDrug']['daw']= $data['daw'][$key];
      			$data['SuggestedDrug']['day']= $data['day'][$key];
      			$data['SuggestedDrug']['isactive']= $data['isactive'][$key];
      			$data['SuggestedDrug']['special_instruction']= $data['special_instruction'][$key];
      			$data['SuggestedDrug']['batch_identifier'] = time(); //maintaining for grouping medication those at once .	
      			$data['SuggestedDrug']['start_date']=DateFormatComponent::formatDate2STD($data['start_date'][$key],Configure::read('date_format')) ;
      			$data['SuggestedDrug']['end_date']= DateFormatComponent::formatDate2STD($data['end_date'][$key],Configure::read('date_format')) ;
      			$data['SuggestedDrug']['rxnorm_code']= $drugResult['PharmacyItem']['code'];
      			$data['SuggestedDrug']['patient_id'] = $data['Note']['patientId'];
                       
      			
      			//set session value here for updating note_id 
      			$session->write('med_batch_identifier',$data['SuggestedDrug']['batch_identifier'] );
      			
      			$pharmacyDetail= $pharmacyItem->find('first',array('fields'=>array('id','MEDID','MED_REF_GEN_DRUG_NAME_CD','MED_REF_FED_LEGEND_IND_DESC'),'conditions'=>array('PharmacyItemDetail.MEDID'=>$data['drug_id'][$key])));
      			//insert same medication in Newcropprescription table
      			$data['NewCropPrescription']['note_id']=$data['Note']['noteId'];
      			$data['NewCropPrescription']['id']=$data['newCrop'][$key];
      		
      			if(empty($data['NewCropPrescription']['id'])){
      				$data['NewCropPrescription']['created_by']=$session->read('userid');
      				$data['NewCropPrescription']['created']=date('Y-m-d H:i:s');
      				$data['NewCropPrescription']['date_of_prescription'] = date("Y-m-d H:i:s");
      				$data['NewCropPrescription']['drm_date'] = date("Y-m-d");
      				$data['NewCropPrescription']['modified']="";
      				  
      			}else{
      				$data['NewCropPrescription']['modified_by']=$session->read('userid');
      				$data['NewCropPrescription']['modified']=date('Y-m-d H:i:s');
      			}
      			$data['NewCropPrescription']['drm_date']=date('Y-m-d');
      			$data['NewCropPrescription']['override']=$data['override_inst'][$key];
      			$data['NewCropPrescription']['inactive_log']=$data['inactive_log'][$key];
      			/* Location For APAM - by MRUNAL  */
      			if($session->read('website.instance')=='vadodara'){
      				$data['NewCropPrescription']['location_id'] = $locationID;
      			}else{
      				$data['NewCropPrescription']['location_id']=$session->read('locationid');
      			}
      			
      			/* if(empty($data['route_administration'][$key])){
      				$data['route_administration'][$key]='2';
      			} */
      			
      			$data['NewCropPrescription']['route']=  $data['route_administration'][$key];
      			$data['NewCropPrescription']['DosageRouteTypeId']=  $data['route_administration'][$key];
      			/* if(empty($data['dose_type'][$key])){
      				$data['dose_type'][$key]='0';
      			} */
      			$data['NewCropPrescription']['dose']= $data['dose_type'][$key];
      			/* if(empty($data['frequency'][$key])){
      				$data['frequency'][$key]='2';
      			} */
      			$data['NewCropPrescription']['frequency']= $data['frequency'][$key];
      			/* if(empty($data['strength'][$key])){
      				$data['strength'][$key]='1';
      			} */
      			$data['NewCropPrescription']['strength']= $data['strength'][$key];
      			/* if(empty($data['DosageForm'][$key])){
      				$data['DosageForm'][$key]='1';
      			} */
      			$data['NewCropPrescription']['DosageForm']= $data['DosageForm'][$key];
      			$data['NewCropPrescription']['dosageValue']= $data['dosageValue'][$key];
      			$data['NewCropPrescription']['refills']= $data['refills'][$key];
      			$data['NewCropPrescription']['quantity']= $data['quantity'][$key];
      			$data['NewCropPrescription']['prn']= $data['prn'][$key];
      			$data['NewCropPrescription']['daw']= $data['daw'][$key];
      			$data['NewCropPrescription']['day']= $data['day'][$key];
      			$data['NewCropPrescription']['special_instruction']= $data['special_instruction'][$key];
      			//$data['NewCropPrescription']['batch_identifier'] = time(); //maintaining for grouping medication those at once .
      			$data['NewCropPrescription']['firstdose']=DateFormatComponent::formatDate2STD($data['start_date'][$key],Configure::read('date_format')) ;
      			$data['NewCropPrescription']['stopdose']= DateFormatComponent::formatDate2STD($data['end_date'][$key],Configure::read('date_format')) ;
      			$data['NewCropPrescription']['rxnorm']= $drugResult['PharmacyItem']['code'];
      			$data['NewCropPrescription']['patient_uniqueid'] = $data['Note']['patientId'];
      			$data['NewCropPrescription']['patient_id'] = $data['Note']['uid'];
      			$data['NewCropPrescription']['by_nurse'] = $data['by_nurse'];
      			$data['NewCropPrescription']['for_normal_med'] = '0';
      			$data['NewCropPrescription']['status'] = '0';
      			$data['NewCropPrescription']['batch_identifier'] = $commonTimEachMedication;
                        $data['NewCropPrescription']['smart_pharse_id'] = $data['smart_pharse_id'];
      			/* $data['NewCropPrescription']['patients_completed_sales_bill_id']= $lastId; */
      			
      			if(empty($data['NewCropPrescription']['patient_id'])){
      				$data['NewCropPrescription']['is_discharge_medication'] ='1';
      			}
      			$data['NewCropPrescription']['drug_name'] = $value;
      			$data['NewCropPrescription']['description'] = $value;
      			$data['NewCropPrescription']['drug_id'] = $data['drug_id'][$key];
      			$data['NewCropPrescription']['is_posted'] = 'no';
      			$data['NewCropPrescription']['DeaGenericNamedCode'] = $pharmacyDetail['PharmacyItemDetail']['MED_REF_GEN_DRUG_NAME_CD'];
      			$data['NewCropPrescription']['DeaLegendDescription'] = $pharmacyDetail['PharmacyItemDetail']['MED_REF_FED_LEGEND_IND_DESC'];
      			
      			
      			$data['NewCropPrescription']['is_ccda'] = '1';
      			$data['NewCropPrescription']['is_med_administered'] = $data['isadv'][$key];
      			if($data['isactive'][$key]==1)
      			  $data['NewCropPrescription']['archive'] = "N";
      			else 
      			  $data['NewCropPrescription']['archive'] = "N";
      			//$data['NewCropPrescription']['archive'] = "Y"; //no need of active column,comented by yashwant
      			
      			$patId= $patient->find('first',array(
      								'fields'=>array('id'),
      								'conditions'=>array('Patient.id'=>$data['Note']['patientId'])));
      			if($patId['Patient']['id']){
					$patData = array();
					$patData['id'] = $patId['Patient']['id'];
					$patData['from_soap_note'] = '1';
					
					$patient->save($patData);
					$patient->id = '';
				}
      				
      				/* debug($data['NewCropPrescription']);
      				exit; */
      			/*if(is_array($data['drugTime'][$key])){
      			$data['SuggestedDrug']['first']=  isset($data['drugTime'][$key][0])?$data['drugTime'][$key][0]:'';
      			$data['SuggestedDrug']['second']= isset($data['drugTime'][$key][1])?$data['drugTime'][$key][1]:'';
      			$data['SuggestedDrug']['third']= isset($data['drugTime'][$key][2])?$data['drugTime'][$key][2]:'';
      			$data['SuggestedDrug']['forth']= isset($data['drugTime'][$key][3])?$data['drugTime'][$key][3]:'';
      			}*/
      			$suggestedDrug->save($data['SuggestedDrug']);
      			$newcropprescription->saveAll(array($data['NewCropPrescription']));
      			unset($data['SuggestedDrug']);
      			unset($data['NewCropPrescription']);
      			$suggestedDrug->id="";
      			$newcropprescription->id="";
      			//EOF check and insert diagnosis drugs of patient
      		}
      	  }
      	}
      	//exit;
      		return true  ;
      				//EOF check and insert drugs
     }
     public function getVitals($patientId,$noteId){
     	$session = new cakeSession();
     	$getVitalDetails=$this->find('first',array('conditions'=>array('patient_id'=>$patientId,'id'=>$noteId)));
   		return $getVitalDetails;
     	
     }
     public function getDiagnosis($patientId,$noteId,$encouterID){
     	$session=new cakeSession();
     	$NoteDiagnosis	= ClassRegistry::init('NoteDiagnosis');
     	$Patient= ClassRegistry::init('Patient');
     	$getDiagnosis=$NoteDiagnosis->find('all',array('conditions'=>array('patient_id'=>$patientId),
     			'fields'=>array('id','diagnoses_name','diagnosis_type','comment','patient_id','icd_id','snowmedid','no_diagnoses_check')));
     	return $getDiagnosis;
     
     } 
     public function getAllergy($patientId){
     	$session=new cakeSession();
     	$NewCropAllergies= ClassRegistry::init('NewCropAllergies');
     	$Patient= ClassRegistry::init('Patient');
     	$getUid=$Patient->find('first',array('fields'=>array('person_id'),'conditions'=>array('id'=>$patientId)));

		$allergies_data=$NewCropAllergies->find('all',array('fields'=>array('name'),
				'conditions'=>array('NewCropAllergies.patient_id'=>trim($getUid['Patient']['person_id']),'NewCropAllergies.is_reconcile'=>0,
						'NewCropAllergies.location_id'=>$session->read('locationid'),
						'NewCropAllergies.is_deleted'=>'0','NewCropAllergies.status'=>'A','NewCropAllergies.patient_uniqueid'=>$patientId)
				,'order' => array('NewCropAllergies.patient_id DESC')));
     	return $allergies_data;
     	 
     }  
     public function getTemplateProPlan($templateId){
     	$NoteTemplateText	= ClassRegistry::init('NoteTemplateText');
     	$getText=$NoteTemplateText->find('all',array('conditions'=>array('template_id'=>$templateId,'context_type'=>procedure),
     			'fields'=>array('template_text','template_id','id'),'order'=>array('id DESC')));
     	return $getText;
     
     
     }
     
     public function getTemplateSubjective($templateId){
     	$NoteTemplateText	= ClassRegistry::init('NoteTemplateText');
     	$getText=$NoteTemplateText->find('all',array('conditions'=>array('template_id'=>$templateId,'context_type'=>subjective),
     			'fields'=>array('template_text','template_id','id'),'order'=>array('id DESC')));
     	return $getText;
     	
     	
     }
     public function getTemplateAssessment($templateId){
     	$NoteTemplateText	= ClassRegistry::init('NoteTemplateText');
     	$getText=$NoteTemplateText->find('all',array('conditions'=>array('template_id'=>$templateId,'context_type'=>assessment),
     			'fields'=>array('template_text','template_id','id'),'order'=>array('id DESC')));
     	return $getText;
     	
     
     }
     public function getTemplateObjective($templateId){
     	$NoteTemplateText	= ClassRegistry::init('NoteTemplateText');
     	$getText=$NoteTemplateText->find('all',array('conditions'=>array('template_id'=>$templateId,'context_type'=>objective),
     			'fields'=>array('template_text','template_id','id'),'order'=>array('id DESC')));
     	return $getText;
     }
     public function getTemplatePlan($templateId){
     	$NoteTemplateText	= ClassRegistry::init('NoteTemplateText');
     	$getText=$NoteTemplateText->find('all',array('conditions'=>array('template_id'=>$templateId,'context_type'=>plan),
     			'fields'=>array('template_text','template_id','id'),'order'=>array('id DESC')));
     	return $getText;
     }
     public function getTemplateROS($templateId){
     	$NoteTemplateText	= ClassRegistry::init('NoteTemplateText');
     	$getText=$NoteTemplateText->find('all',array('conditions'=>array('template_id'=>$templateId,'context_type'=>'review of system'),
     			'fields'=>array('template_text','template_id','id')));
     	return $getText;
     }
	public function getTemplateProcedure($templateId){
     	$NoteTemplateText	= ClassRegistry::init('NoteTemplateText');
     	$getText=$NoteTemplateText->find('all',array('conditions'=>array('template_id'=>$templateId,'context_type'=>'procedure'),
     			'fields'=>array('template_text','template_id','id')));
     	return $getText;
     }
     
     //extraData  = extra data to insert into note table by pankaj
     public function addBlankNote($patientId,$extraData=array()){
    
     	$data = array('subject'=>'','ros'=>'','patient_id'=>$patientId,'create_time'=>date('Y-m-d H:i:s')) ;
     	if(!empty($extraData)) $data = array_merge($data,$extraData) ;
     	$getCheckExist=$this->find('first',array('fields'=>array('id','patient_id'),'conditions'=>array('patient_id'=>$patientId)));
     	if(empty($getCheckExist)){     	
     	$this->save($data);
     	$noteId=$this->getLastInsertID();
     	return $noteId;
     	}else{
     		return $getCheckExist['Note']['id'];
     	}
     	
     }
     
     
     public function encounterHandler($patientId,$personID){
     	 $Patient= ClassRegistry::init('Patient');
     	 $encounterArray=$Patient->find('all',array('fields'=>array('id','id'),'conditions'=>array('person_id'=>$personID)));
     	for($i=0;$i<count($encounterArray);$i++){
     		if($patientId>=$encounterArray[$i]['Patient']['id']){
     			$sendEnounterIds[]=$encounterArray[$i]['Patient']['id'];
     		}
     	}
     	
     	return $sendEnounterIds;
     	
     }
     
     public function seenStatus(){
    // 	$this->loadModel('Appointment') ;
     	$Appointment	= ClassRegistry::init('Appointment');
     	$dateFormat = new DateFormatComponent();
     	$timeDiff=$Appointment->find('first',array('fields'=>array('id','arrived_time'),'conditions'=>array('Appointment.id'=>$this->Session['apptDoc'])));
     	$start=$timeDiff['Appointment']['date'].' '.$timeDiff['Appointment']['arrived_time'];
     	$elapsed=$dateFormat->dateDiff($start,date('Y-m-d H:i')) ;
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
     	$res=$Appointment->updateAll(array('status'=>"'Seen'",'elapsed_time'=>$showTime),array('Appointment.is_future_app'=>0,'Appointment.id'=>$this->Session['apptDoc']));
     		
     }

     
     
     //checkbox action for active/inactive medication--------------
     public function setNoActiveMedByPhysician($patientid=null,$checkrx=null,$patient_uid=null){//debug($patientid);debug($checkrx);exit;
     	$session = new cakeSession();
     	$Note	= ClassRegistry::init('Note');
     	$Diagnosis	= ClassRegistry::init('Diagnosis');
     	$rec=$Note->find('first',array('fields'=>array('id','no_med_flag','patient_id'),'conditions'=>array('Note.patient_id'=> $patientid)));
     	if(empty($rec)){
     		$ChecktTest= array();
     		$ChecktTest['Note']['no_med_flag'] = 'yes';
     		$ChecktTest['Note']['location_id'] = $session->read('locationid');
     		$ChecktTest['Note']['patient_id'] = $patientid;
     		$ChecktTest['Note']['create_time'] = date("Y-m-d H:i:s");
     		$ChecktTest['Note']["created_by"]  = $session->read('userid');
     		$Note->save($ChecktTest);
     	}else{
     		$Note->updateAll(array('no_med_flag'=>'"yes"','modify_time'=>"'".date("Y-m-d H:i:s")."'"),array('Note.patient_id'=> $patientid));
     		$diagnosisRec=$Diagnosis->find('first',array('fields'=>array('id','no_med_flag','patient_id'),'conditions'=>array('Diagnosis.patient_id'=> $patientid)));
     		if(!empty($diagnosisRec)){
     			$Diagnosis->updateAll(array('no_med_flag'=>'"yes"','modify_time'=>"'".date("Y-m-d H:i:s")."'"),array('Diagnosis.patient_id'=> $patientid));
     		}
     		
     	}
     }
     
     //checkbox action for active/inactive medication--------------
     public function unsetNoActiveMedByPhysician($patientid=null,$checkrx=null,$patient_uid=null){
     	$session = new cakeSession();
     	$Note	= ClassRegistry::init('Note');
     	$Diagnosis	= ClassRegistry::init('Diagnosis');
     	$rec=$Note->find('first',array('fields'=>array('id','no_med_flag','patient_id'),'conditions'=>array('Note.patient_id'=> $patientid)));
     	if(empty($rec)){
     		$ChecktTest= array();
     		$ChecktTest['Note']['no_med_flag'] = 'no';
     		$ChecktTest['Note']['location_id'] = $session->read('locationid');
     		$ChecktTest['Note']['patient_id'] = $patientid;
     		$ChecktTest['Note']['create_time'] = date("Y-m-d H:i:s");
     		$ChecktTest['Note']["created_by"]  = $session->read('userid');
     		$Note->save($ChecktTest);
     	}else{
	     	$Note->updateAll(array('no_med_flag'=>'"no"','modify_time'=>"'".date("Y-m-d H:i:s")."'"),array('Note.patient_id'=> $patientid));
     	}
     	$diagnosisRec=$Diagnosis->find('first',array('fields'=>array('id','no_med_flag','patient_id'),'conditions'=>array('Diagnosis.patient_id'=> $patientid)));
     	if(!empty($diagnosisRec['Diagnosis'])){
     		$Diagnosis->updateAll(array('no_med_flag'=>'"no"','modify_time'=>"'".date("Y-m-d H:i:s")."'"),array('Diagnosis.patient_id'=> $patientid));
     	}
     }
     
     
     
     //checkbox action for active/inactive allergy--------------
     public function setNoActiveAllergyByPhysician($patientid=null,$checkall=null,$patient_uid=null){
     	$session = new cakeSession();
     	$Note	= ClassRegistry::init('Note');
     	$Diagnosis	= ClassRegistry::init('Diagnosis');
     	$rec=$Note->find('first',array('fields'=>array('id','no_allergy_flag','patient_id'),'conditions'=>array('Note.patient_id'=> $patientid)));
     	if(empty($rec)){
     		$ChecktTest= array();
     		$ChecktTest['Note']['no_allergy_flag'] = 'yes';
     		$ChecktTest['Note']['location_id'] = $session->read('locationid');
     		$ChecktTest['Note']['patient_id'] = $patientid;
     		$ChecktTest['Note']['create_time'] = date("Y-m-d H:i:s");
     		$ChecktTest['Note']["created_by"]  = $session->read('userid');
     		$Note->save($ChecktTest);
     	}else{
     		$Note->updateAll(array('no_allergy_flag'=>'"yes"','modify_time'=>"'".date("Y-m-d H:i:s")."'"),array('Note.patient_id'=> $patientid));
     		$diagnosisRec=$Diagnosis->find('first',array('fields'=>array('id','no_allergy_flag','patient_id'),'conditions'=>array('Diagnosis.patient_id'=> $patientid)));
     		if(!empty($diagnosisRec)){
     			$Diagnosis->updateAll(array('no_allergy_flag'=>'"yes"','modify_time'=>"'".date("Y-m-d H:i:s")."'"),array('Diagnosis.patient_id'=> $patientid));
     		}
     		 
     	}
     }
      
     //checkbox action for active/inactive allergy--------------
     public function unsetNoActiveAllergyByPhysician($patientid=null,$checkrx=null,$patient_uid=null){
     	$session = new cakeSession();
     	$Note	= ClassRegistry::init('Note');
     	$Diagnosis	= ClassRegistry::init('Diagnosis');
     	$rec=$Note->find('first',array('fields'=>array('id','no_allergy_flag','patient_id'),'conditions'=>array('Note.patient_id'=> $patientid)));
     	if(empty($rec)){
     		$ChecktTest= array();
     		$ChecktTest['Note']['no_allergy_flag'] = 'no';
     		$ChecktTest['Note']['location_id'] = $session->read('locationid');
     		$ChecktTest['Note']['patient_id'] = $patientid;
     		$ChecktTest['Note']['create_time'] = date("Y-m-d H:i:s");
     		$ChecktTest['Note']["created_by"]  = $session->read('userid');
     		$Note->save($ChecktTest);
     	}else{
     		$Note->updateAll(array('no_allergy_flag'=>'"no"','modify_time'=>"'".date("Y-m-d H:i:s")."'"),array('Note.patient_id'=> $patientid));
     	}
     	$diagnosisRec=$Diagnosis->find('first',array('fields'=>array('id','no_allergy_flag','patient_id'),'conditions'=>array('Diagnosis.patient_id'=> $patientid)));
     	if(!empty($diagnosisRec['Diagnosis'])){
     		$Diagnosis->updateAll(array('no_allergy_flag'=>'"no"','modify_time'=>"'".date("Y-m-d H:i:s")."'"),array('Diagnosis.patient_id'=> $patientid));
     	}
     }

     public function sendMail($email,$msgs,$subject=null){
     	$session = new cakeSession();
     	$Inbox	= ClassRegistry::init('Inbox');
     	$Outbox	= ClassRegistry::init('Outbox');
     	$GibberishAESComponent = new GibberishAESComponent();
     	$dataArray=array();
     	$sendReminders=array();
     	$dataArray['Inbox']['from']=$_SESSION['Auth']['User']['username'];
     	$dataArray['Inbox']['to']=$email['Patient']['patient_id'];
     	$dataArray['Inbox']['from_name']=$_SESSION['Auth']['User']['first_name']." ".$_SESSION['Auth']['User']['last_name'];
     	$dataArray['Inbox']['to_name']=$email['Patient']['lookup_name'];
     	$dataArray['Inbox']['create_time'] = date("Y-m-d H:i:s");
     	$dataArray['Inbox']['created_by'] = $session->read('userid');
     	
     	$dataArray1['Outbox']['from']=$_SESSION['Auth']['User']['username'];
     	$dataArray1['Outbox']['to']=$email['Patient']['patient_id'];
     	$dataArray1['Outbox']['from_name']=$_SESSION['Auth']['User']['first_name']." ".$_SESSION['Auth']['User']['last_name'];
     	$dataArray1['Outbox']['to_name']=$email['Patient']['lookup_name'];
     	$dataArray1['Outbox']['create_time'] = date("Y-m-d H:i:s");
     	$dataArray1['Outbox']['created_by'] = $session->read('userid');
     	if(empty($subject)){
	     	$dataArray['Inbox']['subject']='Clinical reminders';
	     	$dataArray['Inbox']['action']=$msgs;
	     	
	     	$dataArray1['Outbox']['subject']='Clinical reminders';
	     	$dataArray1['Outbox']['action']=$msgs;
     	}else{
     		$dataArray['Inbox']['subject']=$subject;
     		$dataArray1['Outbox']['subject']=$subject;
     	}
     	$dataArray['Inbox']['message']= $GibberishAESComponent->enc($msgs,Configure::read('hashKey')) ;
     	$dataArray['Inbox']['type']="Normal";
     	
     	$dataArray1['Outbox']['message']= GibberishAESComponent::enc($msgs,Configure::read('hashKey')) ;
     	$dataArray1['Outbox']['type']="Normal";
     	$checkExit=$Inbox->find('first',array('conditions'=>array('to'=>$email['Patient']['patient_id'],'action'=>$msgs)));
     	$sendReminders[]=$msgs;
     	if(empty($checkExit)){
     	$Inbox->save($dataArray);
     	$Inbox->id=null;
     	$Outbox->save($dataArray1);
     	$Outbox->id=null;
     	}else{
     		return $sendReminders;
     	}
     	unset($dataArray);
     }
     
     public function sendMail_reminder($email,$msgs,$subject){
     	$session = new cakeSession();
     	$Inbox	= ClassRegistry::init('Inbox');
     	$GibberishAESComponent = new GibberishAESComponent();
     	$dataArray=array();
     	$sendReminders=array();
     	$dataArray['Inbox']['from']=$_SESSION['Auth']['User']['username'];
     	$dataArray['Inbox']['to']=$email['Patient']['patient_id'];
     	$dataArray['Inbox']['from_name']=$_SESSION['Auth']['User']['first_name']." ".$_SESSION['Auth']['User']['last_name'];
     	$dataArray['Inbox']['to_name']=$email['Patient']['lookup_name'];
     	$dataArray['Inbox']['subject']='Clinical reminders -'.$subject;
     	$dataArray['Inbox']['action']=$msgs;
     	$dataArray['Inbox']['message']=GibberishAESComponent::enc($msgs,Configure::read('hashKey')) ;
     	$dataArray['Inbox']['type']="Normal";
     	$dataArray['Inbox']['create_time'] = date("Y-m-d H:i:s");
     	$dataArray['Inbox']['created_by'] = $session->read('userid');
     	$checkExit=$Inbox->find('first',array('conditions'=>array('to'=>$email['Patient']['patient_id'],'action'=>$msgs)));
     	$sendReminders[]=$msgs;
     	if(empty($checkExit)){
     		$Inbox->save($dataArray);
     		$Inbox->id=null;
     	}else{
     		return $sendReminders;
     	}
     	unset($dataArray);
     }
     //checkbox action for active/inactive Diagnosis--------------
     public function setNoActiveDiagnosis($patientid=null,$checkall,$note_id=null){
     	$session = new cakeSession();
     	$rec=$this->find('first',array('fields'=>array('id','no_diagnoses_check','patient_id'),'conditions'=>array('Note.id'=> $note_id)));
     	if(empty($rec)){
     		$ChecktTest= array();
     		if($checkall=='1'){
     			$ChecktTest['Note']['no_diagnoses_check'] = 'yes';
     		}else{
     			$ChecktTest['Note']['no_diagnoses_check'] = 'no';
     		}
     		$ChecktTest['Note']['patient_id'] = $patientid;
     		$ChecktTest['Note']['create_time'] = date("Y-m-d H:i:s");
     		$ChecktTest['Note']["created_by"]  = $session->read('userid');
     		$this->save($ChecktTest);
     	}else{
     		if($checkall=='1'){
     			$ChecktTest['Note']['id'] = $note_id;
     			$ChecktTest['Note']['no_diagnoses_check'] = 'yes';
     			$ChecktTest['Note']['patient_id'] = $patientid;
     			$ChecktTest['Note']['modify_time'] = date("Y-m-d H:i:s");
     			$ChecktTest['Note']["modified_by"]  = $session->read('userid');
     			$this->save($ChecktTest);
     		}else{
     			$ChecktTest['Note']['id'] = $note_id;
     			$ChecktTest['Note']['no_diagnoses_check'] = 'no';
     			$ChecktTest['Note']['patient_id'] = $patientid;
     			$ChecktTest['Note']['modify_time'] = date("Y-m-d H:i:s");
     			$ChecktTest['Note']["modified_by"]  = $session->read('userid');
     			$this->save($ChecktTest);
     		}
     			
     	}
     }
     /** Kanpur BOF **/
     public function updateNoteData($requestArray=array()){
     	if($this->save($requestArray)){
     		return true;
     	}else{
     		return false;
     	}
     
     }
     public function ajax_vitalSave($data=array()){
     	
     	
     	$BmiResult	= ClassRegistry::init('BmiResult');
     	$BmiBpResult	= ClassRegistry::init('BmiBpResult');
     	$getId=$BmiResult->find('first',array('fields'=>array('id','appointment_id'),
     			'conditions'=>array('appointment_id'=>$data['BmiResult']['appointment_id'])));
     	if(empty($getId)){
     		$BmiResult->save($data);
     		$lastResultId=$BmiResult->getLastInsertID();
     		$data['BmiBpResult']['bmi_result_id']=$lastResultId;
     		$BmiBpResult->save($data);
     	}else{
     		$data['BmiResult']['id']=$getId['BmiResult']['id'];
     		$BmiResult->save($data);
     		$getIdBP=$BmiBpResult->find('first',array('fields'=>array('id','bmi_result_id'),
     				'conditions'=>array('bmi_result_id'=>$getId['BmiResult']['id'])));
     		$data['BmiBpResult']['id']=$getIdBP['BmiBpResult']['id'];
     		$BmiBpResult->save($data);
     	}
  		return true;  
     }
     /** find xml and insert data according in NewCropP- Aditya **/
     public function readSaveXml($id,$namePhrase){
     	$newcropprescription= ClassRegistry::init('NewCropPrescription');
     	$url = FULL_BASE_URL.Router::url('/')."smartphrase_templates/".trim($namePhrase).".xml";
		$myfile=file_get_contents($url);
		fclose($myfile);
		$xml = simplexml_load_string($myfile);
		if ($xml === false) {
			echo " ";
			foreach(libxml_get_errors() as $error) {
				echo "<br>", $error->message;
			}
		} else {
			//echo "<pre>".pr($xml->newcropprescriptions);
		}
		foreach($xml->newcropprescriptions->NewCropPrescription as $key=>$data){
			$newArry=(array) $data;
			if($newArry['drug_id']!="0"){
			$returnAtty['NewCropPrescription'][]=$newArry;
			}
		}
     	return $returnAtty;
     }   

     //function to fetch next appointments-Atul
     public function getNextPatientList(){
     	$session = new cakeSession();
     	$appointment= ClassRegistry::init('Appointment');
     	$note= ClassRegistry::init('Note');
     	$notePatientId= $note->find('all',array('fields'=>array('Note.id','Note.patient_id'),
     			'conditions'=>array('DATE_FORMAT(Note.create_time, "%Y-%m-%d")'=>date('Y-m-d'))));
     	$patientIdArr = array();
     	foreach ($notePatientId as $key=>$patId){
     		$patientIdArr[$key] = $patId['Note']['patient_id'];
     	}
     	 
     	if(($patientIdArr)){
     		$conditions['NOT'] = array("Appointment.patient_id"=>$patientIdArr);
     	}
     	$appointment->bindModel(array(
     			'belongsTo' => array(
     					'Patient'=>array('foreignKey'=>false,'conditions'=>array('Appointment.patient_id = Patient.id')),
     					'Note'=>array('foreignKey'=>false,'conditions'=>array('Patient.id = Note.patient_id')),
     			)));
     	 
     	/* $currentDayAppointment=$appointment->find('all',array('fields'=>array('Patient.id','Patient.lookup_name','Patient.form_received_on','Appointment.id','Appointment.date') ,'conditions'=>array('Appointment.date '=> date("Y-m-d"),
     		"Appointment.patient_id NOT IN (".implode(',',$patientIdArr).")",'Patient.is_discharge'=>'0','Patient.is_deleted'=>'0','Patient.doctor_id'=>$session->read('userid')),'order'=>array('Patient.form_received_on DESC'),'limit'=>10));
     	*/
     	$currentDayAppointment=$appointment->find('all',array('fields'=>array('Patient.id','Patient.lookup_name','Patient.patient_id','Patient.form_received_on','Appointment.id','Appointment.date') ,'conditions'=>array('Appointment.date '=> date("Y-m-d"),
     			$conditions,'Patient.is_discharge'=>'0','Patient.is_deleted'=>'0','Patient.doctor_id'=>$session->read('userid')),'order'=>array('Patient.form_received_on DESC'),'limit'=>10));
     
     	return $currentDayAppointment ;
     }

}


?>