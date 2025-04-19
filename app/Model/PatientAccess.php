<?php
/**
 * PatientAccess Model
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       PatientAccess Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
class PatientAccess extends AppModel {
	public $specific = true;
	public $name = 'PatientAccess';
	public $useTable = false;
	public $patienttUid;
	public $patienttId;
	
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		$this->patienttUid = $session->read('username');
		$this->patienttId = $this->getPatientId();
		$this->patienttUid = $this->patienttId;
		parent::__construct($id, $table, $ds);
	}
	
	public function getPatientId(){
		$patientModel = ClassRegistry::init('Patient');
		$patientId = $patientModel->find('first',array('conditions'=>array('Patient.patient_id'=>$this->patienttUid),'order'=>array('Patient.id'=>'DESC')));
		return $patientId['Patient']['id'];
	}
	
	public function getLabResults(){
            $laboratoryTestOrder = ClassRegistry::init('LaboratoryTestOrder');
		
			$laboratoryTestOrder->bindModel(array(
					'belongsTo' => array(
							'Laboratory'=>array('foreignKey'=>'laboratory_id')
					),
					'hasOne' => array('LaboratoryResult'=>array('foreignKey'=>'laboratory_test_order_id','type'=>'inner'),
							'LaboratoryHl7Result'=>array('foreignKey'=>false,
									'conditions'=>array('LaboratoryResult.id =LaboratoryHl7Result.laboratory_result_id')
									))));
		
				
			$labResult= $laboratoryTestOrder->find('first',array('fields'=>array('LaboratoryTestOrder.id','Laboratory.name','LaboratoryHl7Result.observations'
					,'LaboratoryHl7Result.id','LaboratoryHl7Result.result','LaboratoryHl7Result.uom','LaboratoryHl7Result.range','LaboratoryHl7Result.abnormal_flag','LaboratoryHl7Result.unit')
					,'conditions'=>array('LaboratoryTestOrder.patient_id'=>$this->patienttId,
					'LaboratoryTestOrder.is_deleted'=>0),'order'=>array('LaboratoryHl7Result.id DESC'))); 
			return $labResult;
			
	}
	
	public function getProblems(){
		$noteDiagnosis = ClassRegistry::init('NoteDiagnosis');
		$noteDiagnosis->bindModel(array(
				'belongsTo' => array(
						'Patient'=>array('foreignKey'=>false,'conditions'=>array('NoteDiagnosis.patient_id'=>'Patient.id')),
						'User'=>array('foreignKey'=>false,'conditions'=>array('Patient.doctor_id'=>'User.id'))//,'User.id'=>100
				),
				));
		$noteDiagnosis->unBindModel(array('belongsTo'=>array('icds')));
		
			$problems=$noteDiagnosis->find('all',array('fields'=>array('NoteDiagnosis.icd_id','NoteDiagnosis.diagnoses_name','NoteDiagnosis.start_dt','NoteDiagnosis.end_dt',
					'NoteDiagnosis.disease_status','NoteDiagnosis.snowmedid','User.first_name','User.last_name'),
					'conditions'=>array('NoteDiagnosis.patient_id'=>$this->patienttUid,'NoteDiagnosis.is_deleted'=>0),'group'=>array('NoteDiagnosis.diagnoses_name')));
			return $problems;
	}
	
	public function getMedications(){
		$NewCropPrescription = ClassRegistry::init('NewCropPrescription');
		/*$NewCropPrescription->bindModel(array(
				'belongsTo' => array(
						'Patient'=>array('foreignKey'=>false,'conditions'=>array('NewCropPrescription.patient_id'=>'Patient.id')),
						'User'=>array('foreignKey'=>false,'conditions'=>array('Patient.doctor_id'=>'User.id'))
				),
		));*/
		$get_medication=$NewCropPrescription->find('all',array('conditions'=>array('NewCropPrescription.patient_uniqueid'=>$this->patienttUid,
				'NewCropPrescription.is_discharge_medication'=>0,'NewCropPrescription.is_deleted'=>0,'NewCropPrescription.archive'=>'N')));
		return $get_medication;
	}
	
	public function getImmunizations(){
		$immunization = ClassRegistry::init('Immunization');
		$immunization->bindModel(array(
				'belongsTo' => array(
						'PhvsVaccinesMvx' =>array('foreignKey'=>false,
								'conditions'=>array('PhvsVaccinesMvx.id = Immunization.manufacture_name')),
						'PhvsMeasureOfUnit' =>array('foreignKey'=>false,
								'conditions'=>array('PhvsMeasureOfUnit.id = Immunization.phvs_unitofmeasure_id')),
						'PhvsAdminsRoute' =>array('foreignKey'=>false,
								'conditions'=>array('PhvsAdminsRoute.id = Immunization.route')),
						'Imunization' =>array('foreignKey'=>false,
								'conditions'=>array('Imunization.id = Immunization.vaccine_type'))) ,
				'hasOne'=>array(
						'Patient' =>array('foreignKey'=>false,
								'conditions'=>array('Patient.id = Immunization.patient_id'))
				)));
		
		$immunization_details=$immunization->find('all',array('fields'=>array('Imunization.cpt_description','presented_date','PhvsVaccinesMvx.description','amount',
				'PhvsMeasureOfUnit.value_code','PhvsAdminsRoute.description','PhvsAdminsRoute.code_system','Imunization.value_code','Imunization.code_system'),
				'conditions'=>array( 'Immunization.is_deleted'=>0,'Patient.patient_id'=>$this->patienttUid)));
		return $immunization_details;
	}
	
	public function getAllergies(){
		$NewCropAllergies = ClassRegistry::init('NewCropAllergies');
		$get_allergies=$NewCropAllergies->find('all',array('conditions'=>array('NewCropAllergies.patient_uniqueid'=>$this->patienttUid,'NewCropAllergies.is_deleted'=>0)));
		return $get_allergies;
	}
	public function getRadiology(){
		$RadiologyTestOrder = ClassRegistry::init('RadiologyTestOrder');
		$RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Radiology' =>array('foreignKey'=>false,
								'conditions'=>array('Radiology.id = RadiologyTestOrder.radiology_id')),)));
		$get_radiology=$RadiologyTestOrder->find('all',array('conditions'=>array('RadiologyTestOrder.patient_id'=>$this->patienttUid),
				 'fields'=>array('Radiology.name','RadiologyTestOrder.order_id','RadiologyTestOrder.radiology_order_date'),'order'=>array('RadiologyTestOrder.id DESC'),'limit'=>'5'));
		return $get_radiology;
	}
	public function getNotes(){
		$Note = ClassRegistry::init('Note');
		$Note->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>false,
								'conditions'=>array('Patient.id = Note.patient_id')),
				)));
		$get_notes=$Note->find('all',array('fields'=>array('Note.id','Note.note_type','Note.note'),'conditions'=>array('Patient.patient_id'=>$this->patienttUid)));
		return $get_notes;
	}
	public function refillRx(){
		$Facility = ClassRegistry::init('Facility');
		 $Facility->unBindModel(array(
				'hasOne'=>array('FacilityDatabaseMapping','FacilityUserMapping')
		));  
		$facility = $Facility->find('first', array('fields'=> array('Facility.id','Facility.name'),'conditions'=>array('Facility.is_deleted' => 0, 'Facility.is_active' => 1,'Facility.id' =>$_SESSION['facilityid'])));
		$patient_uniqueid=12;
		$curlData.='<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
				<soap:Body>';
		
		$curlData.='<GetRenewalResponseStatus xmlns="https://secure.newcropaccounts.com/V7/webservices">';
		$curlData.= '<credentials>
				<PartnerName>DrMHope</PartnerName>
				<Name>demo</Name>
				<Password>demo</Password>
				</credentials>';
		$curlData.=' <accountRequest>
				<AccountId>'.$facility[Facility][name].'</AccountId>
				<SiteId>'.$facility[Facility][id].'</SiteId>
				</accountRequest>';
		$curlData.=' <renewalRequestIdentifier>string</renewalRequestIdentifier>
      <includeSchema>string</includeSchema>
    </GetRenewalResponseStatus>
  </soap:Body>
</soap:Envelope>';
		debug($curlData);
		$url='https://secure.newcropaccounts.com/V7/webservices';
		$curl = curl_init();
		//echo $curlData;
		curl_setopt ($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl,CURLOPT_TIMEOUT,120);
		//curl_setopt($curl,CURLOPT_ENCODING,'gzip');
		
		curl_setopt($curl,CURLOPT_HTTPHEADER,array (
		'SOAPAction:"https://secure.newcropaccounts.com/V7/webservices/GetRenewalResponseStatus"',
		'Content-Type: text/xml; charset=utf-8',
		));
		
		curl_setopt ($curl, CURLOPT_POST, 1);
		curl_setopt ($curl, CURLOPT_POSTFIELDS, $curlData);
		debug($curl);
		$result = curl_exec($curl);
		curl_close ($curl);
		$xml =simplexml_load_string($result);
		debug($xml);
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
				$xmlArray[$i]['daw']=$xmlDataValue['DispenseAsWritten'];
				$xmlArray[$i]['PrescriptionGuid']=$xmlDataValue['PrescriptionGuid'];
				$i++;
			}
		
		
			return $xmlArray;
		
		
		}
	}
}