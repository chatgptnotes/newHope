<?php
/**
 * PatientAccessController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Patient Access Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gulshan Trivedi
 */

class PatientAccessController extends AppController {
	//
	public $name = 'PatientAccess';
	public $helpers = array('Html','Form', 'Js','DateFormat','RupeesToWords','Number','General');
	public $components = array('RequestHandler','Email', 'Session','ImageUpload','GibberishAES');
	public $username;
	public $password;

	public function contact_lenses_index(){
		$p_id=$_SESSION['Auth']['User']['patient_uid'];
		$recivePortalData=$this->portal_header($p_id);
			
		$this->set('recivePortalData',$recivePortalData);

	}

	public function order_eyeglasses(){

	}

	public function help(){

	}

	public function medical_records(){
		$p_id=$_SESSION['Auth']['User']['patient_uid'];
		$recivePortalData=$this->portal_header($p_id);
			
		$this->set('recivePortalData',$recivePortalData);
	}

	public function getMedications(){
		$this->uses = array('PatientAccess');
		$get_medication = $this->PatientAccess->getMedications();
		//$this->set('get_medication',$get_medication);//echo '';print_r($get_medication);exit;
		return $get_medication;
	}

	public function getProblems(){
		$this->uses = array('PatientAccess');
		$problems = $this->PatientAccess->getProblems();
		return $problems;
			
	}

	public function getImmunizations(){
		$this->uses = array('PatientAccess');
		$immunization_details = $this->PatientAccess->getImmunizations();
		return $immunization_details;

	}
	public function getRadiology(){
		$this->uses = array('PatientAccess');
		$radiology_test = $this->PatientAccess->getRadiology();
		return $radiology_test;
	
	}

	public function getAllergies(){
		$this->uses = array('PatientAccess');
		$get_allergies =  $this->PatientAccess->getAllergies();
		return $get_allergies;

	}
	public function getNotes(){
		$this->uses = array('PatientAccess');
		$get_notes =  $this->PatientAccess->getNotes();
		return $get_notes;

	}

	public function getLabResults(){
		$this->layout ='ajax';
		$this->uses = array('PatientAccess');
		$labResult =  $this->PatientAccess->getLabResults();
		return $labResult;
			
	}

	public function pay_bills(){
		$p_id=$_SESSION['Auth']['User']['patient_uid'];
		$recivePortalData=$this->portal_header($p_id);
		$this->redirect(array('controller'=>'Billings','action'=>'dischargeBill',2216));
		//$this->set('recivePortalData',$recivePortalData);


	}


	public function prescription(){

	}
	public function lab_result(){

	}

	public function patient_portalmedication(){

		$medicationRecords=$this->getMedications();
		$this->set('medicationRecords',$medicationRecords);
	}

	public function patient_allergies(){
		$allergiesRecords=$this->getAllergies();
		$this->set('allergiesRecords',$allergiesRecords);

	}
	public function patient_diagnosis(){
		$problemRecords=$this->getProblems();
		$this->set('problemRecords',$problemRecords);

	}

	public function patient_labresults(){
		$labRecords=$this->getLabResults();
		$this->set('labRecords',$labRecords);

	}
	public function patient_immunization(){
		$immunizationRecords=$this->getImmunizations();
		$this->set('immunizationRecords',$immunizationRecords);

	}
	public function patient_note(){
		$noteRecords=$this->getNotes();
		//debug($noteRecords);
		$this->set('noteRecords',$noteRecords);

	}
	public function portal_home(){
		 
		//$recivePortalData=$this->portal_header($_SESSION['Auth']['User']['patient_uid']);
		$this->uses=array('Patient');
		$p_id=$_SESSION['Auth']['User']['patient_uid'];
		$this->Patient->unbindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		if($p_id == 'UHHO14B12001'){// THIS IS A JUGAD FOR DEMO NEED TO REMOVE IT FOR DAISY DUCK
			$permissions=$this->Patient->find('first',array('fields'=>array('Patient.id,Patient.patient_id,Patient.permissions'),'conditions'=>array('Patient.id'=>85),
			'order' =>array('id desc')));
		}else{
			$permissions=$this->Patient->find('first',array('fields'=>array('Patient.id,Patient.patient_id,Patient.permissions'),'conditions'=>array('Patient.patient_id'=>$p_id),
				'order' =>array('id desc')));
		}
		$recivePortalData=$this->portal_header($p_id);
		$this->set('recivePortalData',$recivePortalData);
		$permit=explode("|",$permissions['Patient']['permissions']);
		$this->set(compact('permit'));
		//----------------------------lab----------------------------
			$labResult =  $this->PatientAccess->getLabResults();
			//$lastDataLab=count($labResult)-1;
			//$this->set('recentlab',$labResult[$lastDataLab]);
			$this->set('recentlab',$labResult);
		//--------------Problem------------------------------
			$problemRecords=$this->getProblems();
			$lastDataPro=count($problemRecords)-1;
			$this->set('recentproblem',$problemRecords[$lastDataPro]['NoteDiagnosis']);
		
		//--------------Medications------------------------------
		
			$medicationRecords=$this->getMedications();
			$lastDataMed=count($medicationRecords)-1;
			$this->set('recentmed',$medicationRecords);
		//	$this->set('recentmed',$medicationRecords[$lastDataMed]['NewCropPrescription']);
		
		//--------------Allergies------------------------------
		
			$allergiesRecords=$this->getAllergies();
			$lastDataAll=count($allergiesRecords)-1;
			$this->set('recentallg',$allergiesRecords[$lastDataAll]['NewCropAllergies']);
		
		
		//--------------Immunization------------------------------
			$immunizationRecords=$this->getImmunizations();
			$lastDataImm=count($immunizationRecords)-1;
			$this->set('recentimmu',$immunizationRecords[$lastDataImm]);
			
		// ------------------Radiology----------------------------------
			$radiologyRecords=$this->getRadiology();
			$this->set('radiologyRecords',$radiologyRecords);
			
		
		//-------------------------appointments------------------------------------
			$this->uses=array('Appointment');
		/* $this->Appointment->bindModel(
		 array('belongTo'=>array('DoctorProfile' =>array('foreignKey' => false,
		 		'conditions'=>array('Appointment.doctor_id = DoctorProfile.id' )),
		 ))); */
			$this->Appointment->bindModel(array(
				'belongsTo' => array(
						'DoctorProfile' =>array('foreignKey' => false,
								'conditions'=>array('Appointment.doctor_id =DoctorProfile.user_id' )),
				)),false);
			$getAllAppointments=$this->Appointment->find('all',array('conditions'=>array('person_id'=>$_SESSION['Auth']['User']['id'])));
			$this->set('getAllAppointments',$getAllAppointments);
	}

	public function patient_blood_glucoselog(){


	}
	
	public function authorize($fileName){
		$this->layout=false;
		$this->uses=array('Person','Guardian','Guarantor');
		
		if(isset($this->request->data)&& !empty($this->request->data)){
			$fileName='files'.DS.'note_xml'.DS.'person_editcontent_'.$this->request->data['PatientAccess']['fname'];
			$unSerialData = file_get_contents($fileName);
			$data = unserialize($unSerialData);
			$showUpdate=$this->Person->save($data['Person']);
			$this->Guarantor->save($data['Guarantor']);
			$this->Guardian->save($data['Person']);
			$this->set('showUpdate',$showUpdate);
			fclose($fileName);
			//unlink(WWW_ROOT.$my_file);
			@unlink(WWW_ROOT.$fileName);

		}else{
			$this->set('fileName',$fileName.'.txt');
		}
	}
	public function confrimChange($fileId){
		$this->autoRender=false;
		$fileName='files'.DS.'note_xml'.DS.'person_editcontent_'.$this->request->data['PatientAccess']['fname'];
		//unlink(WWW_ROOT.$my_file);
		$ckeckDel=@unlink(WWW_ROOT.$fileName);
		if(!empty($ckeckDel)){
			echo "done";
		}
		else{
			echo "";
		}
		exit;

	}
	public function authorizeMRN($fileName){
		$this->layout=false;
		$this->uses=array('Patient');
		
		
		if(isset($this->request->data)&& !empty($this->request->data)){
			$fileName='files'.DS.'note_xml'.DS.'patient_editcontent_'.$this->request->data['PatientAccess']['fname'];
			$unSerialData = file_get_contents($fileName);
			$data = unserialize($unSerialData);
			$showUpdate=$this->Patient->save($data['Patient']);
			$this->set('showUpdate',$showUpdate);
			fclose($fileName);
			//unlink(WWW_ROOT.$my_file);
			@unlink(WWW_ROOT.$fileName);

		}else{
			$this->set('fileName',$fileName.'.txt');
		}


	}
	public function confrimChangeMRI($fileId=null){
		$this->autoRender=false;
		$fileName='files'.DS.'note_xml'.DS.'patient_editcontent_'.$this->request->data['PatientAccess']['fname'];
		//unlink(WWW_ROOT.$my_file);
		$ckeckDel=@unlink(WWW_ROOT.$fileName);
		if(!empty($ckeckDel)){
			echo "done";
		}
		else{
			echo "";
		}
		exit;
	
	}

	public function pcmh_report(){
		debug($this->request>data);exit;
	
	}

public function sendRefill($newcropId){
	$this->layout='ajax';
		$this->uses=array('NewCropPrescription','Outbox','Inbox');

		$this->NewCropPrescription->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>false,
						'conditions'=>array('NewCropPrescription.patient_uniqueid=Patient.id'),'fields'=>array('doctor_id','patient_id','lookup_name')),
						'User'=>array('foreignKey'=>false,
								'conditions'=>array('User.id=Patient.doctor_id'),'fields'=>array('username','first_name','last_name')),
				)));
		$getMedicationData=$this->NewCropPrescription->find('first',array('conditions'=>array('NewCropPrescription.id'=>$newcropId)));
		$this->set('getMedicationData',$getMedicationData);
		if(!empty($this->request->data)){
			$to=$this->request->data['NewCropPrescription']['to'];
			$first_name=$this->request->data['NewCropPrescription']['first_name'];
			$last_name=$this->request->data['NewCropPrescription']['last_name'];
			$From=$this->request->data['NewCropPrescription']['From'];
			$name=$first_name." ".$last_name;
			$From1=$this->request->data['NewCropPrescription']['From1'];
			$subject=$this->request->data['NewCropPrescription']['subject'];
			$message=$this->request->data['NewCropPrescription']['message'];
			$this->Outbox->save(array('from'=>"$From1",
			'to'=>"$to",
			'from_name'=>"$From",
			'to_name'=>$name,
			'subject'=>"$subject",
			'message'=>$this->GibberishAES->enc($message,Configure::read('hashKey')),
			'type'=>'Normal',
			'create_time'=>date('y-m-d H:i:s')));
			$this->Inbox->save(array('from'=>"$From1",
					'to'=>"$to",
					'from_name'=>"$From1",
					'to_name'=>$From,
					'subject'=>"$subject",
					'message'=>$this->GibberishAES->enc($message,Configure::read('hashKey')),
					'type'=>'Normal'
					,'create_time'=>date('y-m-d H:i:s')));
			$this->Session->setFlash(__('Mail Send to '.$name, true));
			$close='close';
			$this->set('close',$close);
		}
	
}

public function refillRx(){
		//$this->PatientAccess->refillRx();
	//$recivePortalData=$this->portal_header($_SESSION['Auth']['User']['patient_uid']);
	$this->uses=array('Patient');
	$p_id=$_SESSION['Auth']['User']['patient_uid'];
	$this->Patient->unbindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
	if($p_id == 'UHHO14B12001'){// THIS IS A JUGAD FOR DEMO NEED TO REMOVE IT FOR DAISY DUCK
		$permissions=$this->Patient->find('first',array('fields'=>array('Patient.id,Patient.patient_id,Patient.permissions'),'conditions'=>array('Patient.id'=>85),
				'order' =>array('id desc')));
	}else{
		$permissions=$this->Patient->find('first',array('fields'=>array('Patient.id,Patient.patient_id,Patient.permissions'),'conditions'=>array('Patient.patient_id'=>$p_id),
				'order' =>array('id desc')));
	}
	$recivePortalData=$this->portal_header($p_id);
	$this->set('recivePortalData',$recivePortalData);
	$permit=explode("|",$permissions['Patient']['permissions']);
	$this->set(compact('permit'));
	//----------------------------lab----------------------------
	$labResult =  $this->PatientAccess->getLabResults();
	//$lastDataLab=count($labResult)-1;
	//$this->set('recentlab',$labResult[$lastDataLab]);
	$this->set('recentlab',$labResult);
	//--------------Problem------------------------------
	$problemRecords=$this->getProblems();
	$lastDataPro=count($problemRecords)-1;
	$this->set('recentproblem',$problemRecords[$lastDataPro]['NoteDiagnosis']);

	//--------------Medications------------------------------

	$medicationRecords=$this->getMedications();
	$lastDataMed=count($medicationRecords)-1;
	$this->set('recentmed',$medicationRecords);
	//	$this->set('recentmed',$medicationRecords[$lastDataMed]['NewCropPrescription']);

	//--------------Allergies------------------------------

	$allergiesRecords=$this->getAllergies();
	$lastDataAll=count($allergiesRecords)-1;
	$this->set('recentallg',$allergiesRecords[$lastDataAll]['NewCropAllergies']);


	//--------------Immunization------------------------------
	$immunizationRecords=$this->getImmunizations();
	$lastDataImm=count($immunizationRecords)-1;
	$this->set('recentimmu',$immunizationRecords[$lastDataImm]);

	//-------------------------appointments------------------------------------
	$this->uses=array('Appointment');
	/* $this->Appointment->bindModel(
	 array('belongTo'=>array('DoctorProfile' =>array('foreignKey' => false,
	 		'conditions'=>array('Appointment.doctor_id = DoctorProfile.id' )),
	 ))); */
	$this->Appointment->bindModel(array(
			'belongsTo' => array(
					'DoctorProfile' =>array('foreignKey' => false,
							'conditions'=>array('Appointment.doctor_id =DoctorProfile.user_id' )),
			)),false);
	$getAllAppointments=$this->Appointment->find('all',array('conditions'=>array('person_id'=>$_SESSION['Auth']['User']['id'])));
	$this->set('getAllAppointments',$getAllAppointments);
}

public function pharmacy_renewals(){
	$this->layout = false ;
	
	$curlData.='<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
				<soap:Body>';

	$curlData.=' <GetAllRenewalRequestsSummaryV4 xmlns="https://secure.newcropaccounts.com/V7/webservices">';
	$curlData.= '<credentials>
				<partnerName>'.Configure::read('partnername').'</partnerName>
				<name>'.Configure::read('uname').'</name>
				<password>'.Configure::read('passw').'</password>
				</credentials>';
	$curlData.=' <accountRequest>
				<AccountId>DHR</AccountId>
				<SiteId>4</SiteId>
				</accountRequest>';
	$curlData.='<locationId>19</locationId>
      <licensedPrescriberId>94334</licensedPrescriberId>
	  <renewalRequestDate></renewalRequestDate>
    </GetAllRenewalRequestsSummaryV4>
  </soap:Body>
</soap:Envelope>';
	
	$url='http://secure.newcropaccounts.com//v7/WebServices/Update1.asmx';
	$curl = curl_init();
	//echo $curlData;
	curl_setopt ($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl,CURLOPT_TIMEOUT,120);
	//curl_setopt($curl,CURLOPT_ENCODING,'gzip');

	curl_setopt($curl,CURLOPT_HTTPHEADER,array (
	'SOAPAction:"https://secure.newcropaccounts.com/V7/webservices/GetAllRenewalRequestsSummaryV4"',
	'Content-Type: text/xml; charset=utf-8',
	));

	curl_setopt ($curl, CURLOPT_POST, 1);
	curl_setopt ($curl, CURLOPT_POSTFIELDS, $curlData);
	
	$result = curl_exec($curl);
	curl_close ($curl);
	debug($result);
	$xml =simplexml_load_string($result);
	//debug($xml);
	if($result!="")
	{

		$xml->registerXPathNamespace("soap", "http://schemas.xmlsoap.org/soap/envelope/");
		$finalxml=$xml->xpath('//soap:Body');
		$finalxml=$finalxml[0];
		debug($finalxml);exit;
		$staus= $finalxml->GetPatientFullMedicationHistory6Response->GetPatientFullMedicationHistory6Result->Status;
		$response= $finalxml->GetPatientFullMedicationHistory6Response->GetPatientFullMedicationHistory6Result->XmlResponse;
		$rowcount= $finalxml->GetPatientFullMedicationHistory6Response->GetPatientFullMedicationHistory6Result->RowCount;
		//for getting patient
		$get_id=$this->Patient->find('all',array('fields'=>array('patient_id'),'conditions'=>array('Patient.id'=>$id)));

		$xmlString= base64_decode($response);

		$xmldata = simplexml_load_string($xmlString);

		//echo "<pre>";print_r($xmldata); exit;
		$xmlArray= array();

		$i=0;
		foreach($xmldata as $xmlDataKey => $xmlDataValue ){
				
				
			$xmlDataValue =  (array) $xmlDataValue;
				
			$xmlArray[$i]['description']=$xmlDataValue['DrugInfo'];
			$xmlArray[$i]['drug_id']=$xmlDataValue['DrugID'];
			$xmlArray[$i]['date_of_prescription']=$xmlDataValue['PrescriptionDate'];
			$xmlArray[$i]['drm_date']=$xmlDataValue['ExternalPatientID'];
			$xmlArray[$i]['route']=$xmlDataValue['Route'];
			$xmlArray[$i]['rxnorm']=$xmlDataValue['rxcui'];
			$xmlArray[$i]['archive']=$xmlDataValue['Archive'];
			$xmlArray[$i]['frequency']=$xmlDataValue['DosageFrequencyDescription'];
			$xmlArray[$i]['dose']=$xmlDataValue['DosageNumberDescription'];
			$xmlArray[$i]['dose_unit']=$xmlDataValue['DosageForm'];
			$xmlArray[$i]['drug_name']=$xmlDataValue['DrugName'];
			$xmlArray[$i]['refills']=$xmlDataValue['Refills'];
			if($xmlDataValue['TakeAsNeeded']=='N')
				$pnr='0';
			else
				$pnr='1';
			if($xmlDataValue['DispenseAsWritten']=='N')
				$daw='0';
			else
				$daw='1';
			$xmlArray[$i]['pnr']=$pnr;
			$xmlArray[$i]['daw']=$daw;
			$xmlArray[$i]['PrescriptionGuid']=$xmlDataValue['PrescriptionGuid'];
			$i++;
		}


		return $xmlArray;


	}
}

}