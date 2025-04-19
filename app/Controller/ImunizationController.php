<?php
/**
 * Immunization Controller file
 *
 * PHP 5.4.3
 *
 * @copyright     Copyright 2013 Drmhope Softwares  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Hope
 * @since         CakePHP(tm) v 2.3
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gaurav Chauriya
 */

class ImunizationController extends AppController {

	public $name = 'Imunization';
	public $uses = array('Imunization');
	public $helpers = array('Html','Form', 'Js','DateFormat','General');
	public $components = array('RequestHandler','Email', 'Session','DateFormat');

	public function index($patient_id=null,$initialFlag,$appointmentID){
		if($initialFlag == 'InitialAssessment' || $this->params->query['pageView'] == 'ajax'){
			$this->layout='advance_ajax';
			$this->set('initial','initial');
		}else{
			$this->layout='advance';
			$this->set('sbar','sbar');
		}

		//print_r($patient_id);
		$this->uses = array('Imunization','Immunization','PhvsMeasureOfUnit','PhvsVaccinesMvx');
		$this->Immunization->bindModel(array(
				'belongsTo' => array(
						'PhvsMeasureOfUnit' =>array('foreignKey' => false,'conditions'=>array('PhvsMeasureOfUnit.id=Immunization.phvs_unitofmeasure_id' )),
						'Imunization' =>array('foreignKey' => false,'conditions'=>array('Imunization.id = Immunization.vaccine_type' )),
						'PhvsVaccinesMvx' =>array('foreignKey' => false,'conditions'=>array('PhvsVaccinesMvx.id = Immunization.manufacture_name' ))
				)),false);
		//$diagnosisRec = $this->Immunization->find('all',array('fields'=>array('id','patient_id','vaccine_type','amount','PhvsVaccinesMvx.description','Imunization.cpt_description','PhvsMeasureOfUnit.value_code','phvs_unitofmeasure_id','lot_number','manufacture_name','date','expiry_date'),'conditions'=>array('parent_id=Immunization.id','patient_id'=>$patient_id)));
		$diagnosisRec = $this->Immunization->find('all',array('fields'=>array('id','patient_id','parent_id','vaccine_type','amount','PhvsVaccinesMvx.description','Imunization.cpt_description','PhvsMeasureOfUnit.value_code','phvs_unitofmeasure_id','lot_number','manufacture_name','date','expiry_date'),'conditions'=>array('patient_id'=>$patient_id,'Immunization.is_deleted'=>0)));
		//$parent_id = $this->Immunization->find('all',array('fields'=>array('parent_id'),'conditions'=>array('patient_id'=>$patient_id)));
		//echo "<pre>";print_r($diagnosisRec);exit;
		$this->set(array('immunization'=>$diagnosisRec,'patient_id'=>$patient_id,'initialFlag'=>$initialFlag));

		/* if(empty($diagnosisRec)){
			$this->redirect(array('controller'=>'imunization','action' => 'add',$patient_id,'?'=>array('pageView'=>"ajax")));
		} */
	}


	//-- Function for imunization
	public function add($patient_id=null,$parent_id=null,$initialFlag=null,$appointmentID=null){
		/* if($this->request->data){
				debug($this->request->data);exit;
		} */
		
		if($initialFlag == 'InitialAssessment' || $this->params->query['pageView'] == 'ajax'){
			$this->layout='advance_ajax';
			$this->set('initialAssessment','initialAssessment');
		}else{
			$this->layout='advance';
			$this->set('sbarFlag','sbar') ;
		}
		$this->set(compact('patient_id','parent_id'));
		$this->set('appointment_id',$appointmentID);

		/*echo "<pre>";print_r($this->request->data);
		 $dates = implode("|",$this->request->data['Published']);
		echo "<pre>";print_r($dates);
		exit;*/

		//echo "<pre>";print_r($this->request->data);exit;
		//-------HL7--IMMUNIZATION----
		/*	$model = ClassRegistry::init('Hl7Message');
		 $msg =$model->gen_immunization($this->request->data);
		$model->saveAll(array('message'=>$msg,'message_from'=>'IMMUNIZATION','create_time' => date('Y-m-d H:i:s')));*/

		$this->uses = array('Hl7Nip','Patient','User','Person','DoctorProfile','DeathSummary','DoctorProfile','Imunization','Immunization',
				'PhvsPublicityCode','PhvsImmunizationRegistryStatus','PhvsMeasureOfUnit','PhvsImmunizationInformationSource',
				'PhvsVaccinesMvx','PhvsAdminSite','PhvsAdminsRoute','PhvsObservationIdentifier','PhvsFinancialClass','Imunization','NewCropPrescription','VaccinationRemainder');
		//$vaccinationRemainderData = $this->VaccinationRemainder->find('first',array('fields'=>array('id','patient_id'),'conditions'=>array('VaccinationRemainder.patient_id'=>$patient_id)));
		$ImmunizationRegistryStatus = $this->PhvsImmunizationRegistryStatus->find('list',array('fields'=>array('value_code','description')));
		$publicitycode = $this->PhvsPublicityCode->find('list',array('fields'=>array('id','description')));
		$phvsMeasureOfUnit = $this->PhvsMeasureOfUnit->find('list',array('fields'=>array('id','value_code')));
		$PhvsImmunizationInfo = $this->PhvsImmunizationInformationSource->find('list',array('fields'=>array('id','description')));
		$PhvsVaccinesMvx = $this->PhvsVaccinesMvx->find('list',array('fields'=>array('id','description')));
		$PhvsAdminSite = $this->PhvsAdminSite->find('list',array('fields'=>array('id','description')));
		$PhvsAdminsRoute = $this->PhvsAdminsRoute->find('list',array('fields'=>array('id','description')));
		$PhvsObservationIdentifier = $this->PhvsObservationIdentifier->find('list',array('fields'=>array('id','description')));
		$PhvsFinancialClass = $this->PhvsFinancialClass->find('list',array('fields'=>array('id','description')));
		$Imunization = $this->Imunization->find('all',array('fields'=>array('id','CONCAT(Imunization.cpt_description, "(", Imunization.value_code,")") as cpt_description')));
		$nipCode003 = $this->Hl7Nip->find('list',array('fields'=>array('id','description')));
		foreach($Imunization as $ImunizationVal) {
			$Imunization[$ImunizationVal['Imunization']['id']] = $ImunizationVal[0]['cpt_description'];
		}
		unset($Imunization[0]);

		$this->User->unbindModel(
				array('belongsTo' => array('City','State','Country','Initial')));
		$users = $this->User->find("all",array("conditions"=>
				array("(User.is_deleted = '0' and User.location_id = '".$this->Session->read('locationid')."') and (Role.name !='superadmin' and
						Role.name !='admin')"),"group"=>"User.id"));

		$this->set(compact('nipCode003','publicitycode','ImmunizationRegistryStatus','phvsMeasureOfUnit','PhvsImmunizationInfo',
				'PhvsVaccinesMvx','users','PhvsAdminSite','PhvsAdminsRoute','PhvsObservationIdentifier','PhvsFinancialClass','Imunization','vaccinationRemainderData'));

		/*	if(isset($this->request->data)){
			for($cnt=0;$cnt<=count($this->request->data['Published']);$cnt++){
		$data['date']= $dateFormat->formatDate2STD($this->request->data['Published'],Configure::read('date_format')) ;
		}

		}*/
		if(!empty($this->request->data["Immunization"]['date'])){
			$this->request->data["Immunization"]['date'] = $this->DateFormat->formatDate2STD($this->request->data["Immunization"]['date'],Configure::read('date_format'));
			//calculate age on the basis of entered DOB
			//$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;

		}

		if(!empty($this->request->data["Immunization"]['expiry_date'])){
			$this->request->data["Immunization"]['expiry_date'] = $this->DateFormat->formatDate2STD($this->request->data["Immunization"]['expiry_date'],Configure::read('date_format'));
			//calculate age on the basis of entered DOB
			//$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;

		}
		if(!empty($this->request->data["Immunization"]['indicator_date'])){
			$this->request->data["Immunization"]['indicator_date'] = $this->DateFormat->formatDate2STD($this->request->data["Immunization"]['indicator_date'],Configure::read('date_format'));
			//calculate age on the basis of entered DOB
			//$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;

		}

		if(!empty($this->request->data["Immunization"]['publicity_date'])){
			$this->request->data["Immunization"]['publicity_date'] = $this->DateFormat->formatDate2STD($this->request->data["Immunization"]['publicity_date'],Configure::read('date_format'));
			//calculate age on the basis of entered DOB
			//$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;

		}

		if(!empty($this->request->data["Immunization"]['registry_status_date'])){
			$this->request->data["Immunization"]['registry_status_date'] = $this->DateFormat->formatDate2STD($this->request->data["Immunization"]['registry_status_date'],Configure::read('date_format'));
			//calculate age on the basis of entered DOB
			//$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;

		}

		if(!empty($this->request->data["Immunization"]['observation_date'])){
			$this->request->data["Immunization"]['observation_date'] = $this->DateFormat->formatDate2STD($this->request->data["Immunization"]['observation_date'],Configure::read('date_format'));
			//calculate age on the basis of entered DOB
			//$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;

		}


		if(!empty($this->request->data["Immunization"]['presented_date'])){
			$this->request->data["Immunization"]['presented_date'] = $this->DateFormat->formatDate2STD($this->request->data["Immunization"]['presented_date'],Configure::read('date_format'));
			//calculate age on the basis of entered DOB
			//$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;

		}



		if(!empty($this->request->data['Immunization']) && !isset($this->request->data['submitandaddmore'])){


			$this->request->data['Immunization']['published_date'] = implode("|",$this->request->data['Published']);
			//$this->request->data['Immunization']['vaccin_single_code'] = implode("|",$this->request->data['expString']);
			$this->request->data['Immunization']['vaccin_single_code'] = $this->request->data['expString'];
			$this->Immunization->insertImmunization($this->request->data['Immunization']);
			$lastid= $this->Immunization->getLastInsertID();
			if(!empty($this->request->data['Immunization']['parent_id'])){
				$parent= $this->request->data['Immunization']['parent_id'];
			}else{
				$parent = $lastid;
				$this->request->data['Immunization']['parent_id'] = $lastid;
			}
			$this->Immunization->saveAll(array('id'=>$lastid,'parent_id'=>$parent));
			//-------HL7--IMMUNIZATION----
			$model = ClassRegistry::init('Hl7Message');
			$msg =$model->gen_immunization($this->request->data);
			$model->saveAll(array('message'=>$msg,'message_from'=>'IMMUNIZATION','source_id'=>$lastid,
					'patient_id'=>$this->request->data['Immunization']['patient_id'],'create_time' => date('Y-m-d H:i:s')));

			$personDt = $this->Patient->read(null,$this->request->data['Immunization']['patient_id']);

			$outboxModel = ClassRegistry::init('AmbulatoryResultOutbox');
			$myHl7Exp = explode("\n",$msg);
			$myHl7Exp = explode("|",$myHl7Exp[0]);
			$outboxModel->save(array('message'=>$msg,'uid'=>$personDt['Patient']['patient_id'],'to'=>$myHl7Exp[5],'create_time'=>date('Y-m-d H:i:s')));
			//-------EOF---IMMU--------
			$errors = $this->Immunization->invalidFields();

			if($errors){
				$this->set("errors", $errors);
			}else{

				$this->Session->setFlash(__('Record added successfully', true),'default',array('class'=>'message'));

				/** to enter Data in NewCropPrescription 
				$newCropArray= Array();
				$newCropArray['vaxId']=$this->request->data['vaxId'];
				$newCropArray['patient_id']=$this->request->data['Immunization']['patient_id'];
				$newCropArray['vaccine_type']=$this->request->data['Immunization']['vaccine_type'];
				$newCropArray['is_administered']=$this->request->data['Immunization']['is_administered'];
				$this->NewCropPrescription->saveImmunization($newCropArray);
				debug('hi');
				exit;
				 EOD **/
				if($this->request->data['Immunization']['sbar']== 'sbar'){
					$this->redirect(array('controller'=>'imunization','action' => 'index',$this->request->data['Immunization']['patient_id']));
				}else{
					$this->redirect(array('controller'=>'imunization','action' => 'index',$this->request->data['Immunization']['patient_id'],'?'=>array('pageView'=>"ajax")));
				}
			}
		}elseif(isset($this->request->data['submitandaddmore'])){
			if(empty($this->request->data['Immunization']['parent_id'])){
				$this->request->data['Immunization']['published_date'] = implode("|",$this->request->data['Published']);
				//$this->request->data['Immunization']['vaccin_single_code'] = implode("|",$this->request->data['expString']);
				$this->request->data['Immunization']['vaccin_single_code'] = $this->request->data['expString'];
				$this->Immunization->insertImmunization($this->request->data['Immunization']);
				//--generating new parent_id
				$parent_id= $this->Immunization->getLastInsertID();
				$this->Immunization->saveAll(array('id'=>$parent_id,'parent_id'=>$parent_id));

			}else{
				$this->request->data['Immunization']['published_date'] = implode("|",$this->request->data['Published']);

				$this->Immunization->insertImmunization($this->request->data['Immunization']);
				$parent_id=$this->request->data['Immunization']['parent_id'];
			}
			//-------HL7--IMMUNIZATION----
			/*$model = ClassRegistry::init('Hl7Message');
			$msg =$model->gen_immunization($this->request->data);
			$model->saveAll(array('message'=>$msg,'message_from'=>'IMMUNIZATION','source_id'=>$this->Immunization->id,
					'patient_id'=>$this->request->data['Immunization']['patient_id'],'create_time' => date('Y-m-d H:i:s')));*/
			//-------EOF---IMMU--------

			$this->Session->setFlash(__('Record added successfully', true),'default',array('class'=>'message'));
			$patient_id = $this->request->data['Immunization']['patient_id'];		
			
			/** to enter Data in NewCropPrescription 
			$newCropArray= Array();
			$newCropArray['vaxId']=$this->request->data['vaxId'];
			$newCropArray['patient_id']=$this->request->data['Immunization']['patient_id'];
			$newCropArray['vaccine_type']=$this->request->data['Immunization']['vaccine_type'];
			$newCropArray['is_administered']=$this->request->data['Immunization']['is_administered'];
			$this->NewCropPrescription->saveImmunization($newCropArray);
			exit;
			 EOD **/
			
			if($this->request->data['Immunization']['initialAssessment']=='initialAssessment'){
				$this->redirect(array('controller'=>'imunization','action' => 'add',$patient_id,$parent_id,'?'=>array('pageView'=>"ajax")));
			}else{
				$this->redirect(array('controller'=>'imunization','action' => 'add',$patient_id,$parent_id));
			}
		}
		$this->patient_info($patient_id);

	}

	public function edit($patient_id=null,$id=null){
		$this->patient_info($patient_id);
		if($this->params->query['pageView'] == 'ajax'){

			$this->layout='advance_ajax';
			$this->set('initialAssessment','initialAssessment');
		}else{
			$this->set('sbarFlag','sbar') ;

			$this->layout='advance';
		}
		//print_r($id);
		$this->set(compact('patient_id','parent_id'));
		$this->set(compact('id','id'));


		$this->uses = array('Hl7Nip','Patient','User','Person','DoctorProfile','DeathSummary','DoctorProfile','Imunization','Immunization',
				'PhvsPublicityCode','PhvsImmunizationRegistryStatus','PhvsMeasureOfUnit','PhvsImmunizationInformationSource',
				'PhvsVaccinesMvx','PhvsAdminSite','PhvsAdminsRoute','PhvsObservationIdentifier','PhvsFinancialClass','Imunization');


		if($this->request->data){
			if(!empty($this->request->data["Immunization"]['date'])){
				$this->request->data["Immunization"]['date'] = $this->DateFormat->formatDate2STD($this->request->data["Immunization"]['date'],Configure::read('date_format'));
				//calculate age on the basis of entered DOB
				//$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;

			}

			if(!empty($this->request->data["Immunization"]['expiry_date'])){
				$this->request->data["Immunization"]['expiry_date'] = $this->DateFormat->formatDate2STD($this->request->data["Immunization"]['expiry_date'],Configure::read('date_format'));
				//calculate age on the basis of entered DOB
				//$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;

			}
			if(!empty($this->request->data["Immunization"]['indicator_date'])){
				$this->request->data["Immunization"]['indicator_date'] = $this->DateFormat->formatDate2STD($this->request->data["Immunization"]['indicator_date'],Configure::read('date_format'));
				//calculate age on the basis of entered DOB
				//$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;

			}

			if(!empty($this->request->data["Immunization"]['publicity_date'])){
				$this->request->data["Immunization"]['publicity_date'] = $this->DateFormat->formatDate2STD($this->request->data["Immunization"]['publicity_date'],Configure::read('date_format'));
				//calculate age on the basis of entered DOB
				//$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;

			}

			if(!empty($this->request->data["Immunization"]['registry_status_date'])){
				$this->request->data["Immunization"]['registry_status_date'] = $this->DateFormat->formatDate2STD($this->request->data["Immunization"]['registry_status_date'],Configure::read('date_format'));
				//calculate age on the basis of entered DOB
				//$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;

			}

			if(!empty($this->request->data["Immunization"]['observation_date'])){
				$this->request->data["Immunization"]['observation_date'] = $this->DateFormat->formatDate2STD($this->request->data["Immunization"]['observation_date'],Configure::read('date_format'));
				//calculate age on the basis of entered DOB
				//$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;

			}

			if(!empty($this->request->data["Immunization"]['due_date'])){
				$this->request->data["Immunization"]['due_date'] = $this->DateFormat->formatDate2STD($this->request->data["Immunization"]['due_date'],Configure::read('date_format'));
				//calculate age on the basis of entered DOB
				//$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;

			}

			if(!empty($this->request->data["Immunization"]['presented_date'])){
				$this->request->data["Immunization"]['presented_date'] = $this->DateFormat->formatDate2STD($this->request->data["Immunization"]['presented_date'],Configure::read('date_format'));
				//calculate age on the basis of entered DOB
				//$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;

			}
			$this->request->data["Immunization"]['presented_date'] = explode(" ",$this->request->data["Immunization"]['presented_date']);
			$this->request->data["Immunization"]['presented_date'] = $this->request->data["Immunization"]['presented_date'] [0];
			$this->request->data['Immunization']['published_date'] = implode("|",$this->request->data['Published']);
			$this->request->data['Immunization']['vaccin_single_code'] = $this->request->data['expString'];
			
			if(!empty($this->request->data['Immunization']) && !isset($this->request->data['submitandaddmore'])){
					

				$this->Immunization->updateImmunization($patient_id,$id,$this->request->data);
				$parent= $this->Immunization->getLastInsertID();
				//print_r($parent);exit;
					
				//-------HL7--IMMUNIZATION----
				$model = ClassRegistry::init('Hl7Message');
				$msg =$model->gen_immunization($this->request->data);
				$model->saveAll(array('message'=>$msg,'message_from'=>'IMMUNIZATION','source_id'=>$id,
						'patient_id'=>$this->request->data['Immunization']['patient_id'],'create_time' => date('Y-m-d H:i:s')));
				//-------EOF---IMMU--------
				$errors = $this->Immunization->invalidFields();

				if($errors){
					$this->set("errors", $errors);
				}else{
					$this->Session->setFlash(__('Record updated successfully', true),'default',array('class'=>'message'));
					if($this->request->data['Immunization']['sbar']== 'sbar'){
						$this->redirect(array('controller'=>'imunization','action' => 'index',$patient_id));
					}else{
						$this->redirect(array('controller'=>'imunization','action' => 'index',$patient_id,'?'=>array('pageView'=>"ajax")));
					}
				}
			}elseif(isset($this->request->data['submitandaddmore'])){
				if(empty($this->request->data['Immunization']['id'])){
					$this->Immunization->updateImmunization($patient_id,$id,$this->request->data);
					//--generating new parent_id
					//$parent_id= $this->Immunization->getLastInsertID();
					//$this->Immunization->saveAll(array('id'=>$parent_id,'parent_id'=>$parent_id));

				}else{
					$this->Immunization->updateImmunization($patient_id,$id,$this->request->data);
					$parent_id=$this->request->data['Immunization']['id'];
				}

				$this->Session->setFlash(__('Record Edited successfully', true),'default',array('class'=>'message'));
				$patient_id = $this->request->data['Immunization']['patient_id'];
				$this->redirect(array('controller'=>'imunization','action' => 'edit',$patient_id,$parent_id));
			}
			//$this->print_patient_info($patient_id);
			
		}
		
		$ImmunizationRegistryStatus = $this->PhvsImmunizationRegistryStatus->find('list',array('fields'=>array('value_code','description')));
		$publicitycode = $this->PhvsPublicityCode->find('list',array('fields'=>array('id','description')));
		$phvsMeasureOfUnit = $this->PhvsMeasureOfUnit->find('list',array('fields'=>array('id','value_code')));
		$PhvsImmunizationInfo = $this->PhvsImmunizationInformationSource->find('list',array('fields'=>array('id','description')));
		$PhvsVaccinesMvx = $this->PhvsVaccinesMvx->find('list',array('fields'=>array('id','description')));
		$PhvsAdminSite = $this->PhvsAdminSite->find('list',array('fields'=>array('id','description')));
		$PhvsAdminsRoute = $this->PhvsAdminsRoute->find('list',array('fields'=>array('id','description')));
		$PhvsObservationIdentifier = $this->PhvsObservationIdentifier->find('list',array('fields'=>array('id','description')));
		$PhvsFinancialClass = $this->PhvsFinancialClass->find('list',array('fields'=>array('id','description')));
		$Imunization = $this->Imunization->find('all',array('fields'=>array('id','CONCAT(Imunization.cpt_description, "(", Imunization.value_code,")") as cpt_description')));
		$nipCode003 = $this->Hl7Nip->find('list',array('fields'=>array('id','description')));
		foreach($Imunization as $ImunizationVal) {
			$Imunization[$ImunizationVal['Imunization']['id']] = $ImunizationVal[0]['cpt_description'];
		}
		unset($Imunization[0]);

		$this->User->unbindModel(
				array('belongsTo' => array('City','State','Country','Initial')));
		$users = $this->User->find("all",array("conditions"=>
				array("(User.is_deleted = '0' and User.location_id = '".$this->Session->read('locationid')."') and (Role.name !='superadmin' and
						Role.name !='admin')"),"group"=>"User.id"));

		$editData = $this->Immunization->find('first',array('conditions'=>array('id'=>$id)));
		//debug($editData);exit;
		//echo"<pre>";print_r($editData);exit;
		/* $editData['Immunization']['date'] = $this->DateFormat->formatDate2Local($editData['Immunization']['date'],Configure::read('date_format_us'),true);
		 $editData['Immunization']['expiry_date'] = $this->DateFormat->formatDate2Local($editData['Immunization']['expiry_date'],Configure::read('date_format_us'),false);
		$editData['Immunization']['indicator_date'] = $this->DateFormat->formatDate2Local($editData['Immunization']['indicator_date'],Configure::read('date_format_us'),false);
		$editData['Immunization']['publicity_date'] = $this->DateFormat->formatDate2Local($editData['Immunization']['publicity_date'],Configure::read('date_format_us'),false);
		$editData['Immunization']['registry_status_date'] = $this->DateFormat->formatDate2Local($editData['Immunization']['registry_status_date'],Configure::read('date_format_us'),false);
		//$editData['Immunization']['published_date'] = $this->DateFormat->formatDate2Local($editData['Immunization']['published_date'],Configure::read('date_format_us'),false);
		$editData['Immunization']['presented_date'] = $this->DateFormat->formatDate2Local($editData['Immunization']['presented_date'],Configure::read('date_format_us'),false);
		$editData['Immunization']['observation_date'] = $this->DateFormat->formatDate2Local($editData['Immunization']['observation_date'],Configure::read('date_format_us'),false);
		$editData['Immunization']['due_date'] = $this->DateFormat->formatDate2Local($editData['Immunization']['due_date'],Configure::read('date_format_us'),true); */

		//echo"<pre>";print_r($editData);exit;

		$this->set(compact('nipCode003','publicitycode','ImmunizationRegistryStatus','phvsMeasureOfUnit','PhvsImmunizationInfo',
		'PhvsVaccinesMvx','users','PhvsAdminSite','PhvsAdminsRoute','PhvsObservationIdentifier','PhvsFinancialClass','Imunization','editData'));

		/*	if(isset($this->request->data)){
		 for($cnt=0;$cnt<=count($this->request->data['Published']);$cnt++){
		$data['date']= $dateFormat->formatDate2STD($this->request->data['Published'],Configure::read('date_format')) ;
		}

		}*/
	}


	//--Function to add and edit lab order
	/*
	 public function edit($patient_id=null, $id=null){
	$this->set('id',$id);
	$this->set('patient_id',$patient_id);
	$this->uses = array('Imunization','Immunization');
	$detail = $this->Immunization->find('all',array('fields'=>array('id','patient_id','vaccine_type','date','amount','provider','lot_number','expiry_date','manufacture_name','route','admin_site','admin_note','reason'),'conditions'=>array('patient_id'=>$patient_id,'id'=>$id)));

	//echo"<pre>";print_r($detail);//exit;
	$this->set('detail',$detail);
	$this->Immunization->insertImmunization($this->request->data['Immunization'],$patient_id,$id);
	print_r($this->requst->data['Immunization']);//exit;


	if($patient_id && !empty($id)){
	if(isset($this->request->data) && !empty($this->request->data)){
	$this->uses = array('Imunization','Immunization');

	$getvaccine_type = $this->request->data["Immunization"]["vaccine_type"];
	$getDate = $this->request->data["Immunization"]["date"];
	$getAmount = $this->request->data["Immunization"]["amount"];
	$getProvider = $this->request->data["Immunization"]["provider"];
	$getLotNumber = $this->request->data["Immunization"]["lot_number"];
	$getExpiryDate = $this->request->data["Immunization"]["expiry_date"];
	$getManufactureName = $this->request->data["Immunization"]["manufacture_name"];
	$getRoute = $this->request->data["Immunization"]["route"];
	$getAdminSite = $this->request->data["Immunization"]["admin_site"];
	$getAdminNote = $this->request->data["Immunization"]["admin_note"];
	$getReason = $this->request->data["Immunization"]["reason"];
	$this->Immunization->save($this->request->data);
	$this->Immunization->updateAll(array('vaccine_type'=>"'$getvaccine_type'",'date'=>"'$getDate'",'amount'=>"'$getAmount'",'provider'=>"'$getProvider'",'lot_number'=>"'$getLotNumber'",'expiry_date'=>"'$getExpiryDate'",'manufacture_name'=>"'$getManufactureName'",'route'=>"'$getRoute'",'admin_site'=>"'$getAdminSite'",'admin_note'=>"'$getAdminNote'",'reason'=>"'$getReason'"),array('Immunization.id'=>$id));
	$this->Session->setFlash(__('Record Updated successfully', true),'default',array('class'=>'message'));
	//$this->redirect($this->referer());
	$this->redirect(array('controller'=>'imunization','action' => 'view',$patient_id,$id));

	}

	}
	}
	*/
	public function view($patient_id=null, $id=null){

		if($this->params->query['pageView'] == 'ajax'){
			$this->layout='advance_ajax';
			$this->set('initialAssessment','initialAssessment');
		}else{
			$this->layout='advance';
		}
		$this->set('patient_id',$patient_id);
		$this->set('id',$id);
		$this->uses = array('PhvsFinancialClass','PhvsObservationIdentifier','PhvsPublicityCode','PhvsImmunizationRegistryStatus','Hl7Nip','Hl70322Completionstatuses','Imunization','Immunization','PhvsMeasureOfUnit','PhvsVaccinesMvx','User','Role','PhvsAdminsRoute','PhvsAdminSite','PhvsImmunizationInformationSource');
		$this->Immunization->bindModel(array(
				'belongsTo' => array(
						'PhvsMeasureOfUnit' =>array('foreignKey' => false,'conditions'=>array('PhvsMeasureOfUnit.id=Immunization.phvs_unitofmeasure_id' )),
						'Imunization' =>array('foreignKey' => false,'conditions'=>array('Imunization.id = Immunization.vaccine_type' )),
						'PhvsVaccinesMvx' =>array('foreignKey' => false,'conditions'=>array('PhvsVaccinesMvx.id = Immunization.manufacture_name' )),
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id = Immunization.provider' )),
						'Role' =>array('foreignKey' => false,'conditions'=>array('Role.id = User.role_id' )),
						'PhvsAdminsRoute' =>array('foreignKey' => false,'conditions'=>array('PhvsAdminsRoute.id = Immunization.route' )),
						'PhvsAdminSite' =>array('foreignKey' => false,'conditions'=>array('PhvsAdminSite.id = Immunization.admin_site' )),
						'PhvsImmunizationInformationSource' =>array('foreignKey' => false,'conditions'=>array('PhvsImmunizationInformationSource.id = Immunization.admin_note' ))
				)),false);
		$imu_detail = $this->Immunization->find('first',array('fields'=>array('id','patient_id','vaccine_type','reason','amount','PhvsImmunizationInformationSource.description','PhvsAdminSite.description','PhvsAdminsRoute.description',
				'Role.name','User.first_name','User.last_name','PhvsVaccinesMvx.description','Imunization.cpt_description','PhvsMeasureOfUnit.value_code','phvs_unitofmeasure_id','lot_number','manufacture_name',
				'date','expiry_date','error_status','registry_status','publicity_code','protection_indicator','indicator_date','publicity_date','registry_status_date','funding_category','presented_date','observation_date','observation_method','observation_value','admin_note'),'conditions'=>array('patient_id'=>$patient_id,'Immunization.id'=>$id)));
		$nipCode003 = $this->Hl7Nip->find('list',array('fields'=>array('id','description')));
		$ImmunizationRegistryStatus = $this->PhvsImmunizationRegistryStatus->find('list',array('fields'=>array('value_code','description')));
		$completetionOptions = $this->Hl70322Completionstatuses->find('list',array('fields'=>array('code_value','description',)));
		$publicitycode = $this->PhvsPublicityCode->find('list',array('fields'=>array('id','description')));
		$PhvsObservationIdentifier = $this->PhvsObservationIdentifier->find('list',array('fields'=>array('id','description')));
		$PhvsFinancialClass = $this->PhvsFinancialClass->find('list',array('fields'=>array('id','description')));

		$this->set('completetionOptions',$completetionOptions);
		//echo"<pre>";print_r($imu_detail);//exit; //Hl70322Completionstatuses
		$this->set('imu_detail',$imu_detail);
		$this->set('nipCode003',$nipCode003);
		$this->set('ImmunizationRegistryStatus',$ImmunizationRegistryStatus);
		$this->set('publicitycode',$publicitycode);
		$this->set('PhvsObservationIdentifier',$PhvsObservationIdentifier);
		$this->set('PhvsFinancialClass',$PhvsFinancialClass);

	}

	public function delete($patient_id=null, $id=null, $parent_id=null){
		$this->uses = array('Immunization');
		
		

		if($this->params->query['pageView'] == 'ajax'){
			$this->layout='advance_ajax';
		}else{
			$this->layout='advance';
		}
		//$this->autoRender = false;
		$this->set('title_for_layout', __('Immunization - Delete Immunization', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Immunization'),'default',array('class'=>'error'));
			if($this->params->query['pageView'] == 'ajax'){
				$this->redirect(array('action'=>'index',$patient_id,'?'=>array('pageView'=>"ajax")));
			}else{
				$this->redirect(array('action'=>'index',$patient_id));
			}
		}

		
		if($id && $patient_id && "'".$parent_id."'"){
			$result  = $this->Immunization->save(array('id'=>$id,'patient_id'=>$patient_id,'parent_id'=>$parent_id,'is_deleted'=>'1'));
			$this->Session->setFlash(__('Immunization deleted successfully'),'default',array('class'=>'message'));
			$imunizationCount = $this->Immunization->find('first',array('fields'=>'id','conditions'=>array('patient_id'=>$patient_id,'is_deleted'=>0)));
			
			if($this->params->query['pageView'] == 'ajax'){
				if($imunizationCount >'0'){
					$this->redirect(array('action'=>'index',$patient_id,'?'=>array('pageView'=>"ajax")));
				}else{
					$this->redirect(array('controller'=>'Diagnoses','action'=>'initialAssessment',$patient_id, $this->Session->read('diagnosesID'), $this->Session->read('initialAppointmentID')));
				}
			}else{
				$this->redirect(array('action'=>'index',$patient_id));
			}
		}

	}

	public function marked_as_error($patient_id=null, $id=null){

		$this->uses = array('Immunization');


		$this->set('title_for_layout', __('Immunization - Delete Immunization', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Immunization'),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'index',$patient_id));
		}

		if(!empty($this->request->data["Immunization"]['due_date'])){
			$this->request->data["Immunization"]['due_date'] = $this->DateFormat->formatDate2STD($this->request->data["Immunization"]['due_date'],Configure::read('date_format_us'));
		}

		if(!empty($this->request->data)){//echo '<pre>';print_r($this->request->data);exit;
			//print_r($this->request->data['Immunization']['error_status']);//exit;
			$this->Immunization->id = $id;
			$result  = $this->Immunization->save(array('patient_id'=>$patient_id,'id'=>$id,'error_status'=>$this->request->data['Immunization']['error_status']
					,'completion_status'=>$this->request->data['Immunization']['completion_status'],'due_date'=>$this->request->data['Immunization']['due_date']));
			$this->Session->setFlash(__('Immunization Altered successfully'),'default',array('class'=>'message'));
			//print_r($result);exit;
			$this->redirect(array('action'=>'index',$patient_id));
		}
		/*if ($this->Immunization->delete(array('id'=>$id,'parent_id'=>$parent_id,'Immunization.is_deleted'=>'1'))) {
		 $this->Session->setFlash(__('Immunization deleted successfully'),'default',array('class'=>'message'));
		$this->redirect(array('action'=>'index',$patient_id));
		}*/

	}

	public function send_registry($id=null,$imunization_id=null){
		$this->layout=false;

		$this->uses = array('Imunization','Patient','Person','Location','City','State','Country','User','DoctorProfile','NewCropPrescription','Hl7Message');

		//set immunization xml
		$immunization_xml=$this->generateXML_immunization($id);
		
		$immunization_xml=base64_encode($immunization_xml);
		
		//$immunization_xml
		$this->loadModel("Facility");
		$this->Facility->unBindModel(array(
				'hasOne'=>array('FacilityDatabaseMapping','FacilityUserMapping')
		));
		$facility = $this->Facility->find('first', array('fields'=> array('Facility.id','Facility.name'),'conditions'=>array('Facility.is_deleted' => 0, 'Facility.is_active' => 1,'Facility.id' => $this->Session->read("facilityid"))));

		/*$curlData.='<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
				<soap:Body>';

		$curlData.='<SendToRegistry xmlns="https://secure.newcropaccounts.com/V7/webservices">';
		$curlData.= '<credentials>
				<partnerName>DrMHope</partnerName>
				<name>demo</name>
				<password>demo</password>
				</credentials>';
		$curlData.='<accountRequest>
				<AccountId>'.$facility[Facility][name].'</AccountId>
						<SiteId>'.$facility[Facility][id].'</SiteId>
								</accountRequest>';

		$curlData.='<xmlIn>base64:PD94bWwgdmVyc2lvbj0iMS4wIj8+DQo8TkNTY3JpcHQgeG1sbnM6eHNkPSJodHRwOi8vd3d3LnczLm9yZy8yMDAxL1hNTFNjaGVtYSINCiAgICAgICAgICB4bWxuczp4c2k9Imh0dHA6Ly93d3cudzMub3JnLzIwMDEvWE1MU2NoZW1hLWluc3RhbmNlIg0KICAgICAgICAgIHhtbG5zPSJodHRwOi8vc2VjdXJlLm5ld2Nyb3BhY2NvdW50cy5jb20vaW50ZXJmYWNlVjciPg0KICA8Q3JlZGVudGlhbHM+DQogICAgPHBhcnRuZXJOYW1lPmRlbW88L3BhcnRuZXJOYW1lPg0KICAgIDxuYW1lPmRlbW88L25hbWU+DQogICAgPHBhc3N3b3JkPmRlbW88L3Bhc3N3b3JkPg0KICAgIDxwcm9kdWN0TmFtZT5TdXBlckR1cGVyU29mdHdhcmU8L3Byb2R1Y3ROYW1lPg0KICAgIDxwcm9kdWN0VmVyc2lvbj5WNS4zPC9wcm9kdWN0VmVyc2lvbj4NCiAgPC9DcmVkZW50aWFscz4NCiAgPFVzZXJSb2xlPg0KICAgIDx1c2VyPkxpY2Vuc2VkUHJlc2NyaWJlcjwvdXNlcj4NCiAgICA8cm9sZT5kb2N0b3I8L3JvbGU+DQogIDwvVXNlclJvbGU+DQogIDxEZXN0aW5hdGlvbj4NCiAgICA8cmVxdWVzdGVkUGFnZT53cy1yZWdpc3RyeS1zZW5kPC9yZXF1ZXN0ZWRQYWdlPg0KICA8L0Rlc3RpbmF0aW9uPg0KICA8QWNjb3VudCBJRD0iZGVtbyI+DQogICAgPGFjY291bnROYW1lPllvdXIgQ3VzdG9tZXIncyBBY2NvdW50IE5hbWU8L2FjY291bnROYW1lPg0KICAgIDxzaXRlSUQ+ZGVtbzwvc2l0ZUlEPg0KICAgIDxBY2NvdW50QWRkcmVzcz4NCiAgICAgIDxhZGRyZXNzMT4yMzIzMjMgVGVzdDwvYWRkcmVzczE+DQogICAgICA8YWRkcmVzczI+U3VpdGUgMjQwPC9hZGRyZXNzMj4NCiAgICAgIDxjaXR5PkJvc3RvbjwvY2l0eT4NCiAgICAgIDxzdGF0ZT5NQTwvc3RhdGU+DQogICAgICA8emlwPjEwNDA5PC96aXA+DQogICAgICA8emlwND4xMjM0PC96aXA0Pg0KICAgICAgPGNvdW50cnk+VVM8L2NvdW50cnk+DQogICAgPC9BY2NvdW50QWRkcmVzcz4NCiAgICA8YWNjb3VudFByaW1hcnlQaG9uZU51bWJlcj41NTU1NTUxMjEyPC9hY2NvdW50UHJpbWFyeVBob25lTnVtYmVyPg0KICAgIDxhY2NvdW50UHJpbWFyeUZheE51bWJlcj41NTU1NTUxMzEzPC9hY2NvdW50UHJpbWFyeUZheE51bWJlcj4NCiAgPC9BY2NvdW50Pg0KICA8TG9jYXRpb24gSUQ9IkRFTU9MT0MxIj4NCiAgICA8bG9jYXRpb25OYW1lPllvdXIgQ3VzdG9tZXIncyBMb2NhdGlvbiBOYW1lPC9sb2NhdGlvbk5hbWU+DQogICAgPExvY2F0aW9uQWRkcmVzcz4NCiAgICAgIDxhZGRyZXNzMT4yMzIzMjMgVGVzdDwvYWRkcmVzczE+DQogICAgICA8YWRkcmVzczI+U3VpdGUgMjQwPC9hZGRyZXNzMj4NCiAgICAgIDxjaXR5PkJvc3RvbjwvY2l0eT4NCiAgICAgIDxzdGF0ZT5NQTwvc3RhdGU+DQogICAgICA8emlwPjEwNDA5PC96aXA+DQogICAgICA8emlwND4xMjM0PC96aXA0Pg0KICAgICAgPGNvdW50cnk+VVM8L2NvdW50cnk+DQogICAgPC9Mb2NhdGlvbkFkZHJlc3M+DQogICAgPHByaW1hcnlQaG9uZU51bWJlcj41NTU1NTUxMjEyPC9wcmltYXJ5UGhvbmVOdW1iZXI+DQogICAgPHByaW1hcnlGYXhOdW1iZXI+NTU1NTU1MTIxMzwvcHJpbWFyeUZheE51bWJlcj4NCiAgICA8cGhhcm1hY3lDb250YWN0TnVtYmVyPjU1NTU1NTEyMTI8L3BoYXJtYWN5Q29udGFjdE51bWJlcj4NCiAgPC9Mb2NhdGlvbj4NCiAgPExpY2Vuc2VkUHJlc2NyaWJlciBJRD0iREVNT0xQMSI+DQogICAgPExpY2Vuc2VkUHJlc2NyaWJlck5hbWU+DQogICAgICA8bGFzdD5TbWl0aDwvbGFzdD4NCiAgICAgIDxmaXJzdD5Eb2N0b3I8L2ZpcnN0Pg0KICAgICAgPG1pZGRsZT5KPC9taWRkbGU+DQogICAgPC9MaWNlbnNlZFByZXNjcmliZXJOYW1lPg0KICAgIDxkZWE+QVMxMTExMTExPC9kZWE+DQogICAgPHVwaW4+MTIzNDU2Nzg8L3VwaW4+DQogICAgPGxpY2Vuc2VTdGF0ZT5UWDwvbGljZW5zZVN0YXRlPg0KICAgIDxsaWNlbnNlTnVtYmVyPjEyMzQ1Njc4PC9saWNlbnNlTnVtYmVyPg0KICAgIDxucGk+PC9ucGk+DQogIDwvTGljZW5zZWRQcmVzY3JpYmVyPg0KICA8UGF0aWVudCBJRD0iREVNT1BUMSI+DQogICAgPFBhdGllbnROYW1lPg0KICAgICAgPGxhc3Q+V2lsc29uPC9sYXN0Pg0KICAgICAgPGZpcnN0PlBhdGllbnQ8L2ZpcnN0Pg0KICAgICAgPG1pZGRsZT5KPC9taWRkbGU+DQogICAgPC9QYXRpZW50TmFtZT4NCiAgICA8bWVkaWNhbFJlY29yZE51bWJlcj4xMjM0NTY8L21lZGljYWxSZWNvcmROdW1iZXI+DQogICAgPFBhdGllbnRBZGRyZXNzPg0KICAgICAgPGFkZHJlc3MxPjIzMjIzIFRlc3Q8L2FkZHJlc3MxPg0KICAgICAgPGFkZHJlc3MyPlN1aXRlIDI0MDwvYWRkcmVzczI+DQogICAgICA8Y2l0eT5Cb3N0b248L2NpdHk+DQogICAgICA8c3RhdGU+TUE8L3N0YXRlPg0KICAgICAgPHppcD4xMDQ1NTwvemlwPg0KICAgICAgPGNvdW50cnk+VVM8L2NvdW50cnk+DQogICAgPC9QYXRpZW50QWRkcmVzcz4NCiAgICA8UGF0aWVudENvbnRhY3Q+DQogICAgICA8aG9tZVRlbGVwaG9uZT4xMjM0NTY3ODkwPC9ob21lVGVsZXBob25lPg0KICAgIDwvUGF0aWVudENvbnRhY3Q+DQogICAgPFBhdGllbnRDaGFyYWN0ZXJpc3RpY3M+DQogICAgICA8ZG9iPjE5ODAwMTE1PC9kb2I+DQogICAgICA8Z2VuZGVyPk08L2dlbmRlcj4NCiAgICA8L1BhdGllbnRDaGFyYWN0ZXJpc3RpY3M+DQogIDwvUGF0aWVudD4NCiAgPFJlZ2lzdHJ5TWVzc2FnZT4NCiAgPHJlZ2lzdHJ5SUQ+MDwvcmVnaXN0cnlJRD4NCiAgPHJlZ2lzdHJ5TWVzc2FnZT5YQ1o4VG1WM1EzSnZjQ0JEYjNKbElERXpMakExZkZnMk9IeDhUa2xUVkNCVVpYTjBJRWw2SUZKbFozd3lNREV6TURnd01URTROREY4ZkZaWVZWNVdNRFJlVmxoVlgxWXdOSHd6TWpFelltWTNPVEJsTlRnNE5EaGpOREUxTVh4UWZESXVOUzR4Zkh4OFFVeDhSVklOQ2xCSlJId3hmSHhFTWpZek56WXlOek5lWGw1T1NWTlVJRTFRU1Y1TlVueDhVMjV2ZDE1TllXUmxiSGx1Ymw1QmFXNXpiR1Y1WGw1ZVhreDhUR0Z0WGsxdmNtZGhibnd5TURFd01EY3dObnhHZkh3eU1EYzJMVGhlVG1GMGFYWmxJRWhoZDJGcGFXRnVJRzl5SUU5MGFHVnlJRkJoWTJsbWFXTWdTWE5zWVc1a1pYSmVTRXczTURBd05Yd3pNaUJRY21WelkyOTBkQ0JUZEhKbFpYUWdRWFpsWGw1WFlYSjNhV05yWGsxQlhqQXlORFV5WGxWVFFWNU1mSHhlVUZKT1hsQklYbDVlTmpVM1hqVTFOVGcxTmpOOGZIeDhmSHg4Zkh3eU1UZzJMVFZlVG05MElFaHBjM0JoYm1saklHOXlJRXhoZEdsdWIxNURSRU5TUlVNTkNsQkVNWHg4Zkh4OGZIeDhmSHg4TURKZVVtVnRhVzVrWlhJdmNtVmpZV3hzSUMwZ1lXNTVJRzFsZEdodlpGNUlURGN3TWpFMWZIeDhmSHhCZkRJd01USXdOekF4ZkRJd01USXdOekF4RFFwT1N6RjhNWHhNWVcxZVRXOXlaMkZ1WGw1ZVhsNU1mRTFVU0Y1TmIzUm9aWEplU0V3M01EQTJNM3d6TWlCUWNtVnpZMjkwZENCVGRISmxaWFFnUVhabFhsNVhZWEozYVdOclhrMUJYakF5TkRVeVhsVlRRVjVNZkY1UVVrNWVVRWhlWGw0Mk5UZGVOVFUxT0RVMk13MEtUMUpEZkZKRmZIeEpXaTAzT0RNeU56UmVUa1JCZkh4OGZIeDhmRWxOVFVReFhrNXBZMmh2YkdGelhsSmhibVJ2Ymw1QlhsNWVYbDVPU1ZOVUxVRkJMVEY4ZkRVM05ESXlYbEpoWkc5dVhrNXBZMmh2YkdGelhsNWVYbDVlVGtsVFZDMUJRUzB4WGt3TkNsSllRWHd3ZkRGOE1qQXhNakE0TVRSOGZERTBNRjVKYm1ac2RXVnVlbUVzSUhObFlYTnZibUZzTENCcGJtcGxZM1JoWW14bExDQndjbVZ6WlhKMllYUnBkbVVnWm5KbFpWNURWbGg4TUM0MWZHMU1YazFwYkd4cFRHbDBaWElnVzFOSklGWnZiSFZ0WlNCVmJtbDBjMTFlVlVOVlRYeDhNREJlVG1WM0lHbHRiWFZ1YVhwaGRHbHZiaUJ5WldOdmNtUmVUa2xRTURBeGZEYzRNekl0TVY1TVpXMXZibDVOYVd0bFhrRmVYbDVlWGs1SlUxUXRRVUV0TVh4ZVhsNVlOamg4Zkh4OFdqQTROakJDUW53eU1ERXlNVEV3Tkh4RFUweGVRMU5NSUVKbGFISnBibWNzSUVsdVkxNU5WbGg4Zkh4RFVIeEJEUXBTV0ZKOFNVMWVTVzUwY21GdGRYTmpkV3hoY2w1SVREY3dNVFl5ZkV4QlhreGxablFnUVhKdFhraE1OekF4TmpNTkNrOUNXSHd4ZkVORmZEWTBPVGswTFRkZVZtRmpZMmx1WlNCbWRXNWtJSEJuYlNCbGJHbG5JR05oZEY1TVRud3hmRll3TlY1V1JrTWdaV3hwWjJsaWJHVXRSbVZrWlhKaGJHeDVJRkYxWVd4cFptbGxaQ0JJWldGc2RHZ2dRMlZ1ZEdWeUlGQmhkR2xsYm5RZ0tIVnVaR1Z5TFdsdWMzVnlaV1FwWGtoTU56QXdOalI4Zkh4OGZIeEdmSHg4TWpBeE1qQTNNREY4Zkh4V1dFTTBNRjVGYkdsbmFXSnBiR2wwZVNCallYQjBkWEpsWkNCaGRDQjBhR1VnYVcxdGRXNXBlbUYwYVc5dUlHeGxkbVZzWGtORVExQklTVTVXVXcwS1QwSllmREo4UTBWOE16QTVOVFl0TjE1VWVYQmxPa2xFT2xCME9sWmhZMk5wYm1VNlRtOXRPbDVNVG53eWZEZzRYbWx1Wm14MVpXNTZZU0IyYVhKMWN5QjJZV05qYVc1bExDQjFibk53WldOcFptbGxaQ0JtYjNKdGRXeGhkR2x2Ymw1RFZsaDhmSHg4Zkh4R0RRcFBRbGg4TTN4VVUzd3lPVGMyT0MwNVhrUmhkR1VnZG1GalkybHVaU0JwYm1admNtMWhkR2x2YmlCemRHRjBaVzFsYm5RZ2NIVmliR2x6YUdWa09sUnRVM1J3T2xCME9sQmhkR2xsYm5RNlVXNDZYa3hPZkRKOE1qQXhNakEzTURKOGZIeDhmSHhHRFFwUFFsaDhOSHhVVTN3eU9UYzJPUzAzWGtSaGRHVWdkbUZqWTJsdVpTQnBibVp2Y20xaGRHbHZiaUJ6ZEdGMFpXMWxiblFnY0hKbGMyVnVkR1ZrT2xSdFUzUndPbEIwT2xCaGRHbGxiblE2VVc0NlhreE9mREo4TWpBeE1qQTRNVFI4Zkh4OGZIeEc8L3JlZ2lzdHJ5TWVzc2FnZT4NCiAgPHJlZ2lzdHJ5TWVzc2FnZUNvbXByZXNzaW9uVHlwZT5OT05FPC9yZWdpc3RyeU1lc3NhZ2VDb21wcmVzc2lvblR5cGU+DQogIDxyZWdpc3RyeU1lc3NhZ2VTaXplPjIwMDA8L3JlZ2lzdHJ5TWVzc2FnZVNpemU+DQogIDxyZWdpc3RyeUJhdGNoSUQ+MTU4ODEwMzg0ODwvcmVnaXN0cnlCYXRjaElEPg0KICA8UmVnaXN0cnlJbW11bml6YXRpb24+DQogICAgPEFkbWluaXN0ZXJpbmdQcm92aWRlcj4NCiAgICAgIDxMaWNlbnNlZFByZXNjcmliZXIgSUQ9IkRFTU9MUDEiPg0KICAgICAgICA8TGljZW5zZWRQcmVzY3JpYmVyTmFtZT4NCiAgICAgICAgICA8bGFzdD5TbWl0aDwvbGFzdD4NCiAgICAgICAgICA8Zmlyc3Q+RG9jdG9yPC9maXJzdD4NCiAgICAgICAgICA8bWlkZGxlPko8L21pZGRsZT4NCiAgICAgICAgPC9MaWNlbnNlZFByZXNjcmliZXJOYW1lPg0KICAgICAgICA8ZGVhPkFTMTExMTExMTwvZGVhPg0KICAgICAgICA8dXBpbj4xMjM0NTY3ODwvdXBpbj4NCiAgICAgICAgPGxpY2Vuc2VTdGF0ZT5UWDwvbGljZW5zZVN0YXRlPg0KICAgICAgICA8bGljZW5zZU51bWJlcj4xMjM0NTY3ODwvbGljZW5zZU51bWJlcj4NCiAgICAgICAgPG5waT48L25waT4NCiAgICAgIDwvTGljZW5zZWRQcmVzY3JpYmVyPg0KICAgIDwvQWRtaW5pc3RlcmluZ1Byb3ZpZGVyPg0KICAgIDxFbnRlcmVkQnk+DQogICAgICA8U3RhZmYgSUQ9IkRFTU9TVDEiPg0KICAgICAgICA8U3RhZmZOYW1lPg0KICAgICAgICAgIDxsYXN0PkphY2tzb248L2xhc3Q+DQogICAgICAgICAgPGZpcnN0Pk51cnNlPC9maXJzdD4NCiAgICAgICAgICA8bWlkZGxlPko8L21pZGRsZT4NCiAgICAgICAgICA8cHJlZml4Pk1yLjwvcHJlZml4Pg0KICAgICAgICAgIDxzdWZmaXg+SnI8L3N1ZmZpeD4NCiAgICAgICAgPC9TdGFmZk5hbWU+DQogICAgICAgIDxsaWNlbnNlPlN0TGljMTIzNDwvbGljZW5zZT4NCiAgICAgIDwvU3RhZmY+ICAgIA0KICAgICA8L0VudGVyZWRCeT4NCiAgPC9SZWdpc3RyeUltbXVuaXphdGlvbj4NCiA8L1JlZ2lzdHJ5TWVzc2FnZT4NCjwvTkNTY3JpcHQ+</xmlIn>';
		$curlData.='</SendToRegistry>
				</soap:Body>
				</soap:Envelope>';*/
		
		$curlData='<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <SendToRegistry xmlns="https://secure.newcropaccounts.com/V7/webservices">
      <credentials>
        <PartnerName>DrMHope</PartnerName>
        <Name>'.Configure::read('uname').'</Name>
        <Password>'.Configure::read('passw').'</Password>
      </credentials>
      <accountRequest>
        <AccountId>'.$facility[Facility][name].'</AccountId>
        <SiteId>'.$facility[Facility][id].'</SiteId>
      </accountRequest>
      <xmlIn>base64:'.$immunization_xml.'</xmlIn>
    </SendToRegistry>
  </soap:Body>
</soap:Envelope>';
		$url=Configure::read('SOAPUrl');
		$curl = curl_init();
		curl_setopt ($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl,CURLOPT_TIMEOUT,120);
		//curl_setopt($curl,CURLOPT_ENCODING,'gzip');

		curl_setopt($curl,CURLOPT_HTTPHEADER,array (
		'SOAPAction:"https://secure.newcropaccounts.com/V7/webservices/SendToRegistry"',
		'Content-Type: text/xml; charset=utf-8',
		));
		curl_setopt ($curl, CURLOPT_POST, 1);
		curl_setopt ($curl, CURLOPT_POSTFIELDS, $curlData);
		$result = curl_exec($curl);
		curl_close ($curl);
		$xml =simplexml_load_string($result);
		debug($result);
        exit;
		if($result!="")
		{
			$xml->registerXPathNamespace("soap", "http://schemas.xmlsoap.org/soap/envelope/");
			$finalxml=$xml->xpath('//soap:Body');
			$finalxml=$finalxml[0];

			$status= $finalxml->SendToRegistryResponse->SendToRegistryResult->result->Status;


			if($status=='OK')
			{


				$this->Session->setFlash(__('Message sent succesfully'),'default',array('class'=>'message'));
				$this->redirect(array('action'=>'index',$id));
			}
			else
			{
				$this->Session->setFlash(__('There is error sending message. Please try again.'),'default',array('class'=>'error'));
				$this->redirect(array('action'=>'index',$id));

			}

		}
	}

	function generateXML_immunization($id=null,$imuId=null)
	{

		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));

		$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);

		$LicensedPrescriberName=$this->DoctorProfile->getDoctorByID($UIDpatient_details['Patient']['doctor_id']);


		//$LicensedPrescriberName=explode(" ",$LicensedPrescriberName[0][fullname]);

		$gender=$UIDpatient_details['Person']['sex'];
		if($gender=='Male' or $gender=='M')
			$gendervalue="M";
		else
			$gendervalue="F";


		$dob=str_replace("-", "", $UIDpatient_details['Person']['dob']);

		//find facility id
		$this->loadModel("Facility");
		$this->Facility->unBindModel(array(
				'hasOne'=>array('FacilityDatabaseMapping','FacilityUserMapping')
		));
		$facility = $this->Facility->find('first', array('fields'=> array('Facility.id','Facility.name','Facility.alias','Facility.address1','Facility.address2','Facility.zipcode','Facility.phone1','Facility.phone2','Facility.fax','Facility.city_id','Facility.state_id','Facility.country_id'),'conditions'=>array('Facility.is_deleted' => 0, 'Facility.is_active' => 1,'Facility.id' => $this->Session->read("facilityid"))));

		//find hospital location
		$hospital_location = $this->Location->find('all', array('fields'=> array('Location.id', 'Location.name','Location.address1','Location.address2','Location.zipcode','Location.city_id','Location.state_id','Location.country_id','Location.phone1','Location.mobile','Location.fax'),'conditions'=>array('Location.id'=>$this->Session->read('locationid'), 'Location.is_active' => 1, 'Location.is_deleted' => 0)));

		//find city and state and country

		$city_location = $this->City->find('all', array('fields'=> array('City.name'),'conditions'=>array('City.id'=>$hospital_location['0']['Location']['city_id'])));
		$state_location = $this->State->find('all', array('fields'=> array('State.name'),'conditions'=>array('State.id'=>$hospital_location['0']['Location']['state_id'])));

		$state_location_prescriber = $this->State->find('all', array('fields'=> array('State.state_code'),'conditions'=>array('State.id'=>$LicensedPrescriberName[User][state_id])));

		$city_location_prescriber = $this->City->find('all', array('fields'=> array('City.name'),'conditions'=>array('City.id'=>$LicensedPrescriberName[User][city_id])));


		$country_location = $this->Country->find('all', array('fields'=> array('Country.name'),'conditions'=>array('Country.id'=>$hospital_location['0']['Location']['country_id'])));

		//find insurance / health plan of patient
		$hl7Message = $this->Hl7Message->find('first', array('fields'=> array('Hl7Message.message','Hl7Message.id'),'conditions'=>array('Hl7Message.patient_id' => $id,'Hl7Message.message_from' => 'IMMUNIZATION','Hl7Message.source_id' => $imuId)));

		
		/*$hl7msg='MSH|^~\&|NewCrop Core 13.05|X68||NIST Test Iz Reg|201308011841||VXU^V04^VXU_V04|3213bf790e58848c4151|P|2.5.1|||AL|ER
		PID|1||D26376273^^^NIST MPI^MR||Snow^Madelynn^Ainsley^^^^L|Lam^Morgan|20100706|F||2076-8^Native Hawaiian or Other Pacific Islander^HL70005|32 Prescott Street Ave^^Warwick^MA^02452^USA^L||^PRN^PH^^^657^5558563|||||||||2186-5^Not Hispanic or Latino^CDCREC
		PD1|||||||||||02^Reminder/recall - any method^HL70215|||||A|20120701|20120701
		NK1|1|Lam^Morgan^^^^^L|MTH^Mother^HL70063|32 Prescott Street Ave^^Warwick^MA^02452^USA^L|^PRN^PH^^^657^5558563
		ORC|RE||IZ-783274^NDA|||||||IMMD1^Nicholas^Randon^A^^^^^NIST-AA-1||57422^Radon^Nicholas^^^^^^NIST-AA-1^L
		RXA|0|1|20120814||140^Influenza, seasonal, injectable, preservative free^CVX|0.5|mL^MilliLiter [SI Volume Units]^UCUM||00^New immunization record^NIP001|7832-1^Lemon^Mike^A^^^^^NIST-AA-1|^^^X68||||Z0860BB|20121104|CSL^CSL Behring, Inc^MVX|||CP|A
		RXR|IM^Intramuscular^HL70162|LA^Left Arm^HL70163
		OBX|1|CE|64994-7^Vaccine fund pgm elig cat^LN|1|V05^VFC eligible-Federally Qualified Health Center Patient (under-insured)^HL70064||||||F|||20120701|||VXC40^Eligibility captured at the immunization level^CDCPHINVS
		OBX|2|CE|30956-7^Type:ID:Pt:Vaccine:Nom:^LN|2|88^influenza virus vaccine, unspecified formulation^CVX||||||F
		OBX|3|TS|29768-9^Date vaccine information statement published:TmStp:Pt:Patient:Qn:^LN|2|20120702||||||F
		OBX|4|TS|29769-7^Date vaccine information statement presented:TmStp:Pt:Patient:Qn:^LN|2|20120814||||||F';*/
		$hl7Message_base64=base64_encode($hl7Message["Hl7Message"]["message"]);
		
		
		//$hl7Message_base64=$hl7Message["Hl7Message"]["message"];



		//find patient state code

		$state_location_patient = $this->State->find('all', array('fields'=> array('State.state_code'),'conditions'=>array('State.id'=>$UIDpatient_details['Person']['state'])));
		//find treating consultant


		$strxml='<?xml version="1.0"?>';

		$strxml.='<NCScript xmlns="http://secure.newcropaccounts.com/interfaceV7" xmlns:NCStandard="http://secure.newcropaccounts.com/interfaceV7:NCStandard" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">';
		//Account Credentials
		$strxml.='<Credentials>
				<partnerName>'.Configure::read('partnername').'</partnerName>
						<name>'.Configure::read('uname').'</name>
								<password>'.Configure::read('passw').'</password>
										<productName>SuperDuperSoftware</productName>
										<productVersion>V5.3</productVersion>
										</Credentials>';
		//User type
		$strxml.='<UserRole>
				<user>LicensedPrescriber</user>
				<role>doctor</role>
				</UserRole>';

		//Newcrop page name
		$strxml.='<Destination>
				<requestedPage>ws-registry-send</requestedPage>
				</Destination>';
		//Account id can hospital id and location
		$strxml.='<Account ID="'.$facility['Facility']['name'].'">
					<accountName>'.$facility['Facility']['alias'].'</accountName>
							<siteID>'.$facility['Facility']['id'].'</siteID>
									<AccountAddress>
									<address1>'.$facility['Facility']['address1'].'</address1>
											<address2>'.$facility['Facility']['address2'].'</address2>
													<city>'.$facility['City']['name'].'</city>
															<state>'.$facility['State']['state_code'].'</state>
																	<zip>'.$facility['Facility']['zipcode'].'</zip>
																			<country>US</country>
																			</AccountAddress>
																			<accountPrimaryPhoneNumber>'.$facility['Facility']['phone1'].'</accountPrimaryPhoneNumber>
																					<accountPrimaryFaxNumber>'.$facility['Facility']['fax'].'</accountPrimaryFaxNumber>
																							</Account>';

		//Diffrent hospital location
		$strxml.='<Location ID="'.$hospital_location['0']['Location']['id'].'">
					<locationName>'.$hospital_location['0']['Location']['name'].'</locationName>
							<LocationAddress>
							<address1>'.$LicensedPrescriberName['User']['address1'].'</address1>
									<address2>'.$LicensedPrescriberName['User']['address2'].'</address2>
											<city>'.$city_location_prescriber['0']['City']['name'].'</city>
													<state>'.$state_location_prescriber['0']['State']['state_code'].'</state>
															<zip>'.$LicensedPrescriberName['User']['zipcode'].'</zip>
																	<country>US</country>
																	</LocationAddress>
																	<primaryPhoneNumber>'.str_replace("-", "", $LicensedPrescriberName['User']['phone1']).'</primaryPhoneNumber>
																			<primaryFaxNumber>'.str_replace("-", "", $LicensedPrescriberName['User']['fax']).'</primaryFaxNumber>
																					<pharmacyContactNumber>'.str_replace("-", "", $LicensedPrescriberName['User']['phone1']).'</pharmacyContactNumber>
																							</Location>';

		//Prescribing doctor information
		$strxml.='<LicensedPrescriber ID="'.$LicensedPrescriberName[User][id].'">
					<LicensedPrescriberName>
					<last>'.$LicensedPrescriberName[User][last_name].'</last>
							<first>'.$LicensedPrescriberName[User][first_name].'</first>
									<middle>'.$LicensedPrescriberName[User][middle_name].'</middle>
											</LicensedPrescriberName>';
		// Staff



		$strxml.='<dea>'.$LicensedPrescriberName[User][dea].'</dea>';
			$strxml.='<upin></upin>';
			$strxml.='<licenseState>'.$state_location_prescriber[0][State][state_code].'</licenseState>';
			//$strxml.='<licenseNumber>'.$LicensedPrescriberName[User][licensure_no].'</licenseNumber>';
			$strxml.='<npi>'.$LicensedPrescriberName[User][npi].'</npi>';
			$strxml.='</LicensedPrescriber>';
		

		//patient information
		$strxml.='<Patient ID="'.$UIDpatient_details['Patient']['id'].'">
				<PatientName>
				<last>'.trim($UIDpatient_details['Person']['last_name']).'</last>
						<first>'.trim($UIDpatient_details['Person']['first_name']).'</first>
								<middle>'.trim($UIDpatient_details['Person']['middle_name']).'</middle>
										</PatientName>
										<medicalRecordNumber>'.$UIDpatient_details['Patient']['id'].'</medicalRecordNumber>
												<memo></memo>
												<PatientAddress>
												<address1>'.$UIDpatient_details['Person']['plot_no'].'</address1>
														<address2>'.$UIDpatient_details['Person']['landmark'].'</address2>
																<city>'.$UIDpatient_details['Person']['city'].'</city>
																		<state>'.$state_location_patient['0']['State']['state_code'].'</state>
																				<zip>'.$UIDpatient_details['Person']['pin_code'].'</zip>
																						<country>US</country>
																						</PatientAddress>
																						<PatientContact>
																						<homeTelephone>'.$UIDpatient_details['Person']['home_phone'].'</homeTelephone>
																								</PatientContact>
																								<PatientCharacteristics>
																								<dob>'.$dob.'</dob>
																										<gender>'.$gendervalue.'</gender>
																												</PatientCharacteristics>';
			

			
		$strxml.= '</Patient>';

		$strxml.= '<RegistryMessage>';
		$strxml.= '<registryID>0</registryID>';
		$strxml.= '<registryMessage>'.$hl7Message_base64.'</registryMessage>';
		$strxml.= '<registryMessageCompressionType>NONE</registryMessageCompressionType>';
		$strxml.= '<registryMessageSize>2000</registryMessageSize>';
		$strxml.= '<registryBatchID>1588103848</registryBatchID>';
		$strxml.= '<RegistryImmunization>';

		$strxml.='<AdministeringProvider>
				<LicensedPrescriber ID="'.$LicensedPrescriberName[User][id].'">
						<LicensedPrescriberName>
						<last>'.$LicensedPrescriberName[DoctorProfile][last_name].'</last>
								<first>'.$LicensedPrescriberName[DoctorProfile][first_name].'</first>
										<middle>'.$LicensedPrescriberName[DoctorProfile][middle_name].'</middle>
												</LicensedPrescriberName>
												<dea>'.$LicensedPrescriberName[User][dea].'</dea>
														<upin></upin>
														<licenseState>'.$state_location_prescriber[0][State][state_code].'</licenseState>
																<licenseNumber>'.$LicensedPrescriberName[User][licensure_no].'</licenseNumber>
																		<npi>'.$LicensedPrescriberName[User][npi].'</npi>
																				</LicensedPrescriber>
																				</AdministeringProvider>';

		$strxml.='<EnteredBy>
				<Staff ID="'.$_SESSION['userid'].'">
						<StaffName>
						<last>'.$_SESSION[last_name].'</last>
								<first>'.$_SESSION[first_name].'</first>
									</StaffName>
												</Staff>
												</EnteredBy>';

		$strxml.='</RegistryImmunization>';
		$strxml.='</RegistryMessage>';
		$strxml.='</NCScript>';

		//create xml file here
		$ourFileName = "uploads/patient_xml/Immunization_".$UIDpatient_details['Person']['first_name']."_".$UIDpatient_details['Person']['last_name']."_".$UIDpatient_details['Patient']['id'].".xml";
		//	$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
		$ourFileHandle = fopen($ourFileName, 'w')  ;
		fwrite($ourFileHandle, $strxml);
		fclose($ourFileHandle);
		return $strxml;


	}

	public function reportImmunization(){
		$this->uses = array('Immunization','User');
		$this->Immunization->bindModel(array(
				'belongsTo' => array(
						'Imunization' =>array('foreignKey' => false,'conditions'=>array('Imunization.id = Immunization.vaccine_type' )),
						'Patient' =>array('foreignKey' => false,'conditions'=>array('Patient.id = Immunization.patient_id' )),
						'Person' =>array('foreignKey' => false,'conditions'=>array('Patient.person_id = Person.id' )),
						'Race' =>array('foreignKey' => false,'conditions'=>array('Race.value_code = Person.race' )),
						'Language' =>array('foreignKey' => false,'conditions'=>array('Language.code = Person.preferred_language' )),
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id = Patient.doctor_id' )),
				)),false);
		$reportData = $this->Immunization->find('all',array('fields'=>array('Imunization.cpt_description','Immunization.date','Immunization.id',
				'Patient.id','Patient.lookup_name','Patient.patient_id','Patient.admission_id','Patient.doctor_id','Person.id','Person.sex','Person.dob','Person.sex','Race.race_name','Language.language','CONCAT(User.first_name," ", User.last_name) as dr_full_name'),
				'order' => array('Immunization.date DESC')));
			
		$this->set('reportData',$reportData);
		//pr($reportData);exit;
			
	}
	public function vaccinationfuturesave($patientId=null){
		$this->uses = array('VaccinationRemainder');	
		$this->set('patientId',$patientId);
		if($this->request->data){		
		foreach($this->request->data['VaccinationRemainder'] as $key=>$getData){	
			foreach($getData['date'] as $key => $getDateData){			
				$getDateData =$this->DateFormat->formatDate2STD($getDateData,Configure::read('date_format')); 				
				$data['VaccinationRemainder']['date']=$getDateData;
				$data['VaccinationRemainder']['patient_id']=$patientId;	
				$data['VaccinationRemainder']['vaccination_name']=$getData['vaccination_name'];
				$data['VaccinationRemainder']['vaccination_id']=$getData['vaccination_id']['0'];
				$data['VaccinationRemainder']['id']=$getData['id'][$key];	
					
				if(!empty($data['VaccinationRemainder']['date'])){	
					if(!empty($data['VaccinationRemainder']['id'])){
						$data['VaccinationRemainder']["modified_by"] = $this->Session->read('userid') ;
						$data['VaccinationRemainder']["modified_time"] = date("Y-m-d H:i:s");
						$data['VaccinationRemainder']["location_id"] = $this->Session->read('locationid');
					}else{
						$data['VaccinationRemainder']["created_by"]  = $this->Session->read('userid') ;
						$data['VaccinationRemainder']["create_time"] = date("Y-m-d H:i:s");
						$data['VaccinationRemainder']["location_id"] = $this->Session->read('locationid');
					}			
				$this->VaccinationRemainder->saveAll($data['VaccinationRemainder']);
				unset($this->request->data['VaccinationRemainder']);
				//$this->id='';
				}		
			}		
		}
		}			
		$this->redirect(array("action" => "vaccinationfuture",$patientId));
		
	}
	
	function vaccinationfuture($patientId=null){
		$this->layout='advance';
		$this->uses = array('VaccinationRemainder');
		$this->set('patientId',$patientId);		  
		$vaccinationRemainderData = $this->VaccinationRemainder->find('all',array('order'=>array('vaccination_id'=>'ASC'),'fields'=>array('vaccination_name','id','patient_id','vaccination_id','date','is_deleted'),'conditions'=>array('VaccinationRemainder.patient_id'=>$patientId,'VaccinationRemainder.is_deleted'=>'0')));
		$configElement = Configure::read('vaccination_data');	
		$vaccineDataArray = array();
		$lastVaccineName = '';		
	
		for($i=0;;$i++){
			$flag = true;
			if($i >= count($configElement) && empty($vaccinationRemainderData)) break;
				$dateArray = array();
			foreach($vaccinationRemainderData as $subKey=>$subValue){
				if($i == $subValue['VaccinationRemainder']['vaccination_id']){
					$dateArray[] = $subValue['VaccinationRemainder']['date'].'_'.$subValue['VaccinationRemainder']['id']; 
					$flag = false; 
					unset($vaccinationRemainderData[$subKey]);
					$lastVaccineName = $subValue['VaccinationRemainder']['vaccination_name'];
				}
			}
			if($flag){
				$vaccineDataArray[]['VaccinationRemainder'][$configElement[$i]] = array();
			}else{
				$vaccineDataArray[]['VaccinationRemainder'][$lastVaccineName] = $dateArray;				
				if(count($vaccinationRemainderData) < 0) unset($vaccinationRemainderData);
			}
			$dateArray = array();$lastVaccineName='';
		}
		
		$this->set('vaccineDataArray',$vaccineDataArray);		
		$this->set('vaccinationRemainderData',$vaccinationRemainderData);
	}
	
	
	
	public function ajax_add_vaccination(){
		$this->layout = false ;		
		$this->set(array('counter'=>$_GET['counter']));
	}
	public function deleteVaccination($modelName,$vacRecordId){
		$this->uses=array('VaccinationRemainder');		
		if($modelName=='Vaccination'){			
			$this->VaccinationRemainder->updateAll(array('is_deleted'=>'1'),array('id'=>$vacRecordId));
			exit;
		}
		else{

		}

	}
	public function sendToPatientVaccination(){
		$this->loadModel('Patient');
	
		/******BOF-Mahalaxmi-After patient reg to  get sms alert for Patient Vaccination......  ***/
		$getEnableFeatureChk=$this->Session->read('sms_feature_chk');		
		if($getEnableFeatureChk=='1'){			
			$this->Patient->sendToSmsPatientVaccinationRemainder('VaccinationRemainder');
		}
		$this->redirect(array("controller" => "Landings", "action" => "index"));
		/******EOF-Mahalaxmi-After patient reg to  get sms alert for Patient Vaccination......  ***/
	}
	
	

}///EOF class