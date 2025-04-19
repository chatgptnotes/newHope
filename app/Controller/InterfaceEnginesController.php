<?php
/**
 * InterfaceEnginesController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       InterfaceEnginesController
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */

class InterfaceEnginesController extends AppController {
	//
	public $name = 'InterfaceEngine';
	public $uses = array('InterfaceEngine');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email', 'Session');
	public $admissionId;
	public $patientUid;
	
	
public function main() {
		$this->parseADT();
		$this->createORMMessage();
		$this->createRadORMMessage();
		$this->parseORU();
		$this->parseRADORU();
		
	}
	
	public function parseORU(){
		App::uses('ParagonMessage', 'Model');
		$paragonMessageModel = new ParagonMessage(null,null,$this->InterfaceEngine->database);
		$paragonMessages = $paragonMessageModel->find('all',array('fields'=>array('id','message'),'conditions'=>array('status'=>'0','type'=>'ORU')));///////////CHECK,'type'=>'A04'
		
		foreach($paragonMessages as $message){
			$xmlString = trim($message['ParagonMessage']['message']);
			$xml=simplexml_load_string($xmlString);
			$orc = $xml->ORC;
			$pid = $xml->PID;
			$laboratoryTestOrderId = (string) $orc->{'ORC.2'}->{'ORC.2.1'}; 
			$patientUid = (string) $pid->{'PID.2'}->{'PID.2.1'};
			//$patientId = $this->getPatientIDByUid($patientUid);
			$personId = $this->getPersonID($patientUid);
			//$patientId = $this->getPatientID($personId);
			$patientId = $this->getIDByFields(array('id'=>$laboratoryTestOrderId),'patient_id','LaboratoryTestOrder',1,0);
			$laboratoryResultId = $this->InterfaceEngine->parseOBR($xml->OBR,$patientId,$laboratoryTestOrderId,$xml->ORC);
			$laboratoryHL7Result = $this->InterfaceEngine->parseOBX($xml->OBX,$laboratoryResultId,$laboratoryTestOrderId,$patientId);
			$paragonMessageModel->updateAll(array('ParagonMessage.status' => '1'),array('ParagonMessage.id'=>$message['ParagonMessage']['id']));
			
		}
	}
	
	
	public function parseRADORU(){
		App::uses('ParagonMessage', 'Model');
		$paragonMessageModel = new ParagonMessage(null,null,$this->InterfaceEngine->database);
		$paragonMessages = $paragonMessageModel->find('all',array('fields'=>array('id','message'),'conditions'=>array('status'=>'0','type'=>'RAD_ORU')));///////////CHECK,'type'=>'A04'
	
		foreach($paragonMessages as $message){
			$xmlString = trim($message['ParagonMessage']['message']);
			$xml=simplexml_load_string($xmlString);
			$obr = $xml->OBR;
			$pid = $xml->PID;
			$radiologyTestOrderId = (string) $obr->{'OBR.2'}->{'OBR.2.1'};
			$patientUid = (string) $pid->{'PID.2'}->{'PID.2.1'};
			//$patientId = $this->getPatientIDByUid($patientUid);
			$personId = $this->getPersonID($patientUid);
			$patientId = $this->getPatientID($personId);
			$radiologyResultId = $this->InterfaceEngine->parseRADOBR($xml->OBR,$patientId,$radiologyTestOrderId,$xml->ORC,$xml->OBX);
			//$laboratoryHL7Result = $this->InterfaceEngine->parseRADOBX($xml->OBX,$laboratoryResultId,$laboratoryTestOrderId,$patientId);
			$paragonMessageModel->updateAll(array('ParagonMessage.status' => '1'),array('ParagonMessage.id'=>$message['ParagonMessage']['id']));
				
		}
	}
	
	public function createORMMessage($patientId,$labId){
		
		//$this->InterfaceEngine->createORMMessage(array('patientid'=>98,'labRequestId'=>1));
		App::uses('LaboratoryTestOrder', 'Model');
		$laboratoryTestOrderModel = new LaboratoryTestOrder(null,null,$this->InterfaceEngine->database);
		$labdata = $laboratoryTestOrderModel->find('all',array('fields'=>array('id','patient_id'),'conditions'=>array('LaboratoryTestOrder.is_processed'=>'0')));
		foreach($labdata as $lab){
			if($this->InterfaceEngine->createORMMessage(array('patientid'=>$lab['LaboratoryTestOrder']['patient_id'],'labRequestId'=>$lab['LaboratoryTestOrder']['id']))){
				$laboratoryTestOrderModel->updateAll(array('LaboratoryTestOrder.is_processed' => '1'),array('LaboratoryTestOrder.id'=>$lab['LaboratoryTestOrder']['id']));
				$laboratoryTestOrderModel->id = '';
			}
		}
	}
	
	public function createRadORMMessage($patientId,$labId){
	
		//$this->InterfaceEngine->createORMMessage(array('patientid'=>98,'labRequestId'=>1));
		App::uses('RadiologyTestOrder', 'Model');
		$radiologyTestOrder = new RadiologyTestOrder(null,null,$this->InterfaceEngine->database);
		$raddata = $radiologyTestOrder->find('all',array('fields'=>array('id','patient_id'),'conditions'=>array('RadiologyTestOrder.is_processed'=>'0')));
		foreach($raddata as $rad){
			if($this->InterfaceEngine->createRadORMMessage(array('patientid'=>$rad['RadiologyTestOrder']['patient_id'],'radRequestId'=>$rad['RadiologyTestOrder']['id']))){
				$radiologyTestOrder->updateAll(array('RadiologyTestOrder.is_processed' => '1'),array('RadiologyTestOrder.id'=>$rad['RadiologyTestOrder']['id']));
				$radiologyTestOrder->id = '';
			}
		}
	}
	
	public function parseADT(){
		App::uses('ParagonMessage', 'Model');
		$paragonMessageModel = new ParagonMessage(null,null,$this->InterfaceEngine->database);
		$paragonMessages = $paragonMessageModel->find('all',array('fields'=>array('id','message'),'conditions'=>array('status'=>'0','type'=>'A04')));
		foreach($paragonMessages as $message){
			$xmlString = trim($message['ParagonMessage']['message']);
			$xml=simplexml_load_string($xmlString);
			$eventType = $this->InterfaceEngine->parseEVN($xml->EVN);
			App::uses('Person', 'Model');
			$personModel = new Person(null,null,$this->InterfaceEngine->database);
			$diagnoses = array();
			if($eventType == 'A04' || $eventType == 'A31'){
				$personPatientData = $this->InterfaceEngine->parsePID($xml->PID);
				//$userData = $this->InterfaceEngine->parsePV1($xml->PV1);
				$additionalDetails = $this->InterfaceEngine->parsePD1($xml->PD1);
				$consultantId = $this->InterfaceEngine->parseROL($xml->ROL);
				$isInsured = count($xml->IN1);
				$userData = $this->InterfaceEngine->parsePV1($xml->PV1,$xml->PV2);
				$additionalDetails['visit_indicator'] = $userData['1']['visit_indicator'];
				$personId = $this->getPersonID($personPatientData['0']['alternate_patient_uid']);
				if($personId){
					$isExistsPerson = 1;
				}else{
					$isExistsPerson = 0;
				}
				if($isExistsPerson == 0){
					App::uses('Person', 'Model');
					$personModel = new Person(null,null,$this->InterfaceEngine->database);
					$personDataSource = $personModel->getDataSource();
					$personId = $this->setPersonData($personPatientData['0'],$additionalDetails,$personId,$personPatientData['2'],$personPatientData['3'],$isInsured,'A04',$personModel);
					if($personId){
						$personData = $personModel->read(null,$personId);
						$gaurantorData = $this->InterfaceEngine->parseGT1($xml->GT1);
						//$gaurantorId = $this->getGuarantorID($personId);
						$gaurantorId = $this->setGuarantor($gaurantorData,$personId,$gaurantorId);
						
						$nextOfKinData = $this->InterfaceEngine->parseNK1($xml->NK1);
						$nextOfKinId = $this->setGuarantor($nextOfKinData,$personId,null,1);
						
						//pr($xml->NK1);exit;
						
						
						$patientData['Patient'] = $personPatientData['1'];
						$patientData['Patient']['doctor_id'] = $userData['0'];
						$patientData['Patient']['form_received_on'] = $userData['1']['form_received_on'];
						$patientData['Patient']['is_discharge'] = '0';
						$patientData['Patient']['visit_indicator'] = $userData['1']['visit_indicator'];//Changes
						$patientData['Patient']['hl7_patient_class'] = $userData['1']['hl7_patient_class'];
						$patientData['Patient']['hl7_location_point_of_care'] = $userData['1']['hl7_location_point_of_care'];
						$patientData['Patient']['hl7_location_room'] = $userData['1']['hl7_location_room'];
						$patientData['Patient']['hl7_location_bed'] = $userData['1']['hl7_location_bed'];
						$patientData['Patient']['hl7_location_facility'] = $userData['1']['hl7_location_facility'];
						$patientData['Patient']['hl7_admission_type'] = $userData['1']['hl7_admission_type'];
						$patientData['Patient']['vip_indicator'] = $userData['1']['vip_indicator'];
						$patientData['Patient']['visit_publicity_code'] = $userData['2']['visit_publicity_code'];
						$patientData['Patient']['patient_status_code'] = $userData['2']['patient_status_code'];
						$patientData['Patient']['visit_protection_indicator'] = $userData['2']['visit_protection_indicator'];
						$patientData['Patient']['new_born_baby_indicator'] = $userData['2']['new_born_baby_indicator'];
						$patientData['Patient']['hl7_mode_of_arrival'] = $userData['2']['hl7_mode_of_arrival'];
						$patientData['Patient']['hl7_patient_handicap'] = $additionalDetails['hl7_patient_handicap'];
						$patientData['Patient']['hl7_patient_type'] = $userData['1']['hl7_patient_type'];
						$patientData['Patient']['hl7_financial_class'] = $userData['1']['hl7_financial_class'];
						$patientData['Patient']['hl7_servicing_facility'] = $userData['1']['hl7_servicing_facility'];
						$patientData['Patient']['visit_indicator'] = $userData['1']['visit_indicator'];
						$patientData['Patient']['discharge_disposition'] = $userData['1']['discharge_disposition'];
						$patientData['Patient']['discharge_to_location'] = $userData['1']['discharge_to_location'];
						$patientData['Patient']['hl7_admit_source'] = $userData['1']['hl7_admit_source'];
						$patientData['Patient']['arrive_by'] = $patientData['Patient']['hl7_mode_of_arrival'];
						$patientData['Patient']['treatment_type'] = '2';
						$patientData['Patient']['is_paragon'] = '1';
						$diagnoses['Diagnoses']['complaints'] = $userData['2']['complaints'];
						
						$patientId = $this->getPatientID($personId);
						App::uses('Patient', 'Model');
						App::uses('PharmacySalesBill', 'Model');
						App::uses('InventoryPharmacySalesReturn', 'Model');
						$patientModel = new Patient(null,null,$this->InterfaceEngine->database);
						$patientModel->unBindModel(array(
								'hasMany' => array(new PharmacySalesBill(null,null,$this->InterfaceEngine->database),
											new InventoryPharmacySalesReturn(null,null,$this->InterfaceEngine->database))));
						$patientDataSource = $patientModel->getDataSource();
						
							
						$patientId = $this->setPatientData($patientData,$personData,$consultantId,$patientId,'A04',$patientModel);
						if($patientId){
							$this->setDiagnosis($patientId,$personId,$diagnoses);
							
							$insuranceData1 = $this->InterfaceEngine->parseIN1($xml->IN1,$patientId,$this->patientUid,$xml->IN2);
							$insuranceData['InsuranceCompany'] = $insuranceData1['0'];
							$insuredData['NewInsurance'] = $insuranceData1['1'];
							$insuredId =$this->getInsuranceID($patientId);
							$insuranceCompanyId = $this->setPatientInsurance($insuranceData,$insuredData,$patientId,$insuredId);
							$personModel->updateAll(array('Person.insurance_type_id' => $insuranceCompanyId),array('Person.id'=>$personId));
							//App::uses('Appointment', 'Model');
							//$appointmentModel = new Appointment(null,null,$this->InterfaceEngine->database);
							//$appointmentDataSource = $appointmentModel->getDataSource();
							//$appt = $this->setCurrentAppointment($personId,$patientId,$userData['0'],$appointmentModel);
							
								unset($insuranceData1);
								$patientUid = $this->getIDByFields('id','patient_uid','Person',$limit=1,$offset=0);
								$allergiesArray = $this->InterfaceEngine->parseADTAL1($xml->AL1,$patientId,$personId);
								$this->setPatientAllergies($allergiesArray);
								$diagnosesArray = $this->InterfaceEngine->parseADTAL1($xml->DG1,$patientId,$personId);
								$this->setPatientDiagnoses($diagnosesArray);
								//$appointmentDataSource->commit();
								$patientDataSource->commit();
								$personDataSource->commit();
								$paragonMessageModel->updateAll(array('ParagonMessage.status' => '1'),array('ParagonMessage.id'=>$message['ParagonMessage']['id']));
								$paragonMessageModel->id = '';
								//$appointmentDataSource->rollback();
								$patientDataSource->rollback();
								$personDataSource->rollback();
						}else{
							$patientDataSource->rollback();
							$personDataSource->rollback();
						}
					}else{
						$personDataSource->rollback();
					}
				}
				
			}
			
			if($eventType == 'A03'){
				
				App::uses('Person', 'Model');
				$personModel = new Person(null,null,$this->InterfaceEngine->database);
				$personPatientData = $this->InterfaceEngine->parsePID($xml->PID);
				//$userData = $this->InterfaceEngine->parsePV1($xml->PV1);
				$additionalDetails = $this->InterfaceEngine->parsePD1($xml->PD1);
				$consultantId = $this->InterfaceEngine->parseROL($xml->ROL);
				$isInsured = count($xml->IN1);
				$userData = $this->InterfaceEngine->parsePV1($xml->PV1,$xml->PV2);
				$additionalDetails['visit_indicator'] = $userData['1']['visit_indicator'];
				$personId = $this->getPersonID($personPatientData['0']['alternate_patient_uid']);
				if($personId){
					$isExistsPerson = 1;
				}else{
					$isExistsPerson = 0;
				}
				if($isExistsPerson == 1){
					$personId = $this->setPersonData($personPatientData['0'],$additionalDetails,$personId,$personPatientData['2'],$personPatientData['3'],$isInsured,'A03');
					$personData = $personModel->read(null,$personId);
					$gaurantorData = $this->InterfaceEngine->parseGT1($xml->GT1);
					//$gaurantorId = $this->getGuarantorID($personId);
					$gaurantorId = $this->setGuarantor($gaurantorData,$personId,$gaurantorId);
					
					$nextOfKinData = $this->InterfaceEngine->parseNK1($xml->NK1);
					$nextOfKinId = $this->setGuarantor($nextOfKinData,$personId,null,1);
					
					//pr($xml->NK1);exit;
					
					
					$patientData['Patient'] = $personPatientData['1'];
					$patientData['Patient']['doctor_id'] = $userData['0'];
					$patientData['Patient']['form_received_on'] = $userData['1']['form_received_on'];
					$patientData['Patient']['discharge_date'] = $userData['1']['discharge_date'];
					//$patientData['Patient']['is_discharge'] = '1';
					$patientData['Patient']['visit_indicator'] = $userData['1']['visit_indicator'];//Changes
					$patientData['Patient']['hl7_patient_class'] = $userData['1']['hl7_patient_class'];
					$patientData['Patient']['hl7_location_point_of_care'] = $userData['1']['hl7_location_point_of_care'];
					$patientData['Patient']['hl7_location_room'] = $userData['1']['hl7_location_room'];
					$patientData['Patient']['hl7_location_bed'] = $userData['1']['hl7_location_bed'];
					$patientData['Patient']['hl7_location_facility'] = $userData['1']['hl7_location_facility'];
					$patientData['Patient']['hl7_admission_type'] = $userData['1']['hl7_admission_type'];
					$patientData['Patient']['vip_indicator'] = $userData['1']['vip_indicator'];
					$patientData['Patient']['visit_publicity_code'] = $userData['2']['visit_publicity_code'];
					$patientData['Patient']['patient_status_code'] = $userData['2']['patient_status_code'];
					$patientData['Patient']['visit_protection_indicator'] = $userData['2']['visit_protection_indicator'];
					$patientData['Patient']['new_born_baby_indicator'] = $userData['2']['new_born_baby_indicator'];
					$patientData['Patient']['hl7_mode_of_arrival'] = $userData['2']['hl7_mode_of_arrival'];
					$patientData['Patient']['hl7_patient_handicap'] = $additionalDetails['hl7_patient_handicap'];
					$patientData['Patient']['hl7_patient_type'] = $userData['1']['hl7_patient_type'];
					$patientData['Patient']['hl7_financial_class'] = $userData['1']['hl7_financial_class'];
					$patientData['Patient']['hl7_servicing_facility'] = $userData['1']['hl7_servicing_facility'];
					$patientData['Patient']['visit_indicator'] = $userData['1']['visit_indicator'];
					$patientData['Patient']['discharge_disposition'] = $userData['1']['discharge_disposition'];
					$patientData['Patient']['discharge_to_location'] = $userData['1']['discharge_to_location'];
					$patientData['Patient']['hl7_admit_source'] = $userData['1']['hl7_admit_source'];
					$patientData['Patient']['arrive_by'] = $patientData['Patient']['hl7_mode_of_arrival'];
					$patientData['Patient']['is_paragon'] = '1';
					$diagnoses['Diagnoses']['complaints'] = $userData['2']['complaints'];
					$patientData['Patient']['treatment_type'] = '2';
					$patientId = $this->getPatientID($personId);
					$patientId = $this->setPatientData($patientData,$personData,$consultantId,$patientId,'A03');
					
					$this->setDiagnosis($patientId,$personId,$diagnoses);
					
					$insuranceData1 = $this->InterfaceEngine->parseIN1($xml->IN1,$patientId,$this->patientUid,$xml->IN2);
					$insuranceData['InsuranceCompany'] = $insuranceData1['0'];
					$insuredData['NewInsurance'] = $insuranceData1['1'];
					$insuredId =$this->getInsuranceID($patientId);
					$insuranceCompanyId = $this->setPatientInsurance($insuranceData,$insuredData,$patientId,$insuredId);
					$personModel->updateAll(array('Person.insurance_type_id' => $insuranceCompanyId),array('Person.id'=>$personId));
					
					//$this->setCurrentAppointment($personId,$patientId,$userData['0']);
					$this->updatePatientAppointment($patientId,'Seen');
					unset($insuranceData1);
					$patientUid = $this->getIDByFields('id','patient_uid','Person',$limit=1,$offset=0);
					$allergiesArray = $this->InterfaceEngine->parseADTAL1($xml->AL1,$patientId,$personId);
					$this->setPatientAllergies($allergiesArray);
					$diagnosesArray = $this->InterfaceEngine->parseADTAL1($xml->DG1,$patientId,$personId);
					$this->setPatientDiagnoses($diagnosesArray);
				}
				$paragonMessageModel->updateAll(array('ParagonMessage.status' => '1'),array('ParagonMessage.id'=>$message['ParagonMessage']['id']));
				$paragonMessageModel->id = '';
				
				
			}
			
			if($eventType == 'A08'){
				
				App::uses('Person', 'Model');
				$personModel = new Person(null,null,$this->InterfaceEngine->database);
				$personPatientData = $this->InterfaceEngine->parsePID($xml->PID);
				//$userData = $this->InterfaceEngine->parsePV1($xml->PV1);
				$additionalDetails = $this->InterfaceEngine->parsePD1($xml->PD1);
				$consultantId = $this->InterfaceEngine->parseROL($xml->ROL);
				$isInsured = count($xml->IN1);
				$userData = $this->InterfaceEngine->parsePV1($xml->PV1,$xml->PV2);
				$additionalDetails['visit_indicator'] = $userData['1']['visit_indicator'];
				$personId = $this->getPersonID($personPatientData['0']['alternate_patient_uid']);
				if($personId){
					$isExistsPerson = 1;
				}else{
					$isExistsPerson = 0;
				}
				if($isExistsPerson == 1){
					$personId = $this->setPersonData($personPatientData['0'],$additionalDetails,$personId,$personPatientData['2'],$personPatientData['3'],$isInsured,'A08');
					$personData = $personModel->read(null,$personId);
					$gaurantorData = $this->InterfaceEngine->parseGT1($xml->GT1);
					//$gaurantorId = $this->getGuarantorID($personId);
					$gaurantorId = $this->setGuarantor($gaurantorData,$personId,$gaurantorId);
					
					$nextOfKinData = $this->InterfaceEngine->parseNK1($xml->NK1);
					$nextOfKinId = $this->setGuarantor($nextOfKinData,$personId,null,1);
					
					//pr($xml->NK1);exit;
					
					
					$patientData['Patient'] = $personPatientData['1'];
					$patientData['Patient']['doctor_id'] = $userData['0'];
					$patientData['Patient']['form_received_on'] = $userData['1']['form_received_on'];
					$patientData['Patient']['is_discharge'] = '0';
					$patientData['Patient']['visit_indicator'] = $userData['1']['visit_indicator'];//Changes
					$patientData['Patient']['hl7_patient_class'] = $userData['1']['hl7_patient_class'];
					$patientData['Patient']['hl7_location_point_of_care'] = $userData['1']['hl7_location_point_of_care'];
					$patientData['Patient']['hl7_location_room'] = $userData['1']['hl7_location_room'];
					$patientData['Patient']['hl7_location_bed'] = $userData['1']['hl7_location_bed'];
					$patientData['Patient']['hl7_location_facility'] = $userData['1']['hl7_location_facility'];
					$patientData['Patient']['hl7_admission_type'] = $userData['1']['hl7_admission_type'];
					$patientData['Patient']['vip_indicator'] = $userData['1']['vip_indicator'];
					$patientData['Patient']['visit_publicity_code'] = $userData['2']['visit_publicity_code'];
					$patientData['Patient']['patient_status_code'] = $userData['2']['patient_status_code'];
					$patientData['Patient']['visit_protection_indicator'] = $userData['2']['visit_protection_indicator'];
					$patientData['Patient']['new_born_baby_indicator'] = $userData['2']['new_born_baby_indicator'];
					$patientData['Patient']['hl7_mode_of_arrival'] = $userData['2']['hl7_mode_of_arrival'];
					$patientData['Patient']['hl7_patient_handicap'] = $additionalDetails['hl7_patient_handicap'];
					$patientData['Patient']['hl7_patient_type'] = $userData['1']['hl7_patient_type'];
					$patientData['Patient']['hl7_financial_class'] = $userData['1']['hl7_financial_class'];
					$patientData['Patient']['hl7_servicing_facility'] = $userData['1']['hl7_servicing_facility'];
					$patientData['Patient']['visit_indicator'] = $userData['1']['visit_indicator'];
					$patientData['Patient']['discharge_disposition'] = $userData['1']['discharge_disposition'];
					$patientData['Patient']['discharge_to_location'] = $userData['1']['discharge_to_location'];
					$patientData['Patient']['hl7_admit_source'] = $userData['1']['hl7_admit_source'];
					$patientData['Patient']['arrive_by'] = $patientData['Patient']['hl7_mode_of_arrival'];
					$patientData['Patient']['is_paragon'] = '1';
					$diagnoses['Diagnoses']['complaints'] = $userData['2']['complaints'];
					
					$patientId = $this->getPatientID($personId);
					$patientId = $this->setPatientData($patientData,$personData,$consultantId,$patientId);
					
					$this->setDiagnosis($patientId,$personId,$diagnoses);
					
					$insuranceData1 = $this->InterfaceEngine->parseIN1($xml->IN1,$patientId,$this->patientUid,$xml->IN2);
					$insuranceData['InsuranceCompany'] = $insuranceData1['0'];
					$insuredData['NewInsurance'] = $insuranceData1['1'];
					$insuredId =$this->getInsuranceID($patientId);
					$insuranceCompanyId = $this->setPatientInsurance($insuranceData,$insuredData,$patientId,$insuredId,'A08');
					$personModel->updateAll(array('Person.insurance_type_id' => $insuranceCompanyId),array('Person.id'=>$personId));
					//$this->setCurrentAppointment($personId,$patientId,$userData['0']);
					unset($insuranceData1);
					$patientUid = $this->getIDByFields('id','patient_uid','Person',$limit=1,$offset=0);
					$allergiesArray = $this->InterfaceEngine->parseADTAL1($xml->AL1,$patientId,$personId);
					$this->setPatientAllergies($allergiesArray);
					$diagnosesArray = $this->InterfaceEngine->parseADTAL1($xml->DG1,$patientId,$personId);
					$this->setPatientDiagnoses($diagnosesArray);
				}
				$paragonMessageModel->updateAll(array('ParagonMessage.status' => '1'),array('ParagonMessage.id'=>$message['ParagonMessage']['id']));
				$paragonMessageModel->id = '';
				
			}
			
			if($eventType == 'A13'){
				
				App::uses('Person', 'Model');
				$personModel = new Person(null,null,$this->InterfaceEngine->database);
				$personPatientData = $this->InterfaceEngine->parsePID($xml->PID);
				//$userData = $this->InterfaceEngine->parsePV1($xml->PV1);
				$additionalDetails = $this->InterfaceEngine->parsePD1($xml->PD1);
				$consultantId = $this->InterfaceEngine->parseROL($xml->ROL);
				$isInsured = count($xml->IN1);
				$userData = $this->InterfaceEngine->parsePV1($xml->PV1,$xml->PV2);
				$additionalDetails['visit_indicator'] = $userData['1']['visit_indicator'];
				$personId = $this->getPersonID($personPatientData['0']['alternate_patient_uid']);
				if($personId){
					$isExistsPerson = 1;
				}else{
					$isExistsPerson = 0;
				}
				if($isExistsPerson == 1){
					$personId = $this->setPersonData($personPatientData['0'],$additionalDetails,$personId,$personPatientData['2'],$personPatientData['3'],$isInsured,'A13');
					$personData = $personModel->read(null,$personId);
					$gaurantorData = $this->InterfaceEngine->parseGT1($xml->GT1);
					//$gaurantorId = $this->getGuarantorID($personId);
					$gaurantorId = $this->setGuarantor($gaurantorData,$personId,$gaurantorId);
					
					$nextOfKinData = $this->InterfaceEngine->parseNK1($xml->NK1);
					$nextOfKinId = $this->setGuarantor($nextOfKinData,$personId,null,1);
					
					//pr($xml->NK1);exit;
					
					$patientData['Patient'] = $personPatientData['1'];
					$patientData['Patient']['doctor_id'] = $userData['0'];
					$patientData['Patient']['form_received_on'] = $userData['1']['form_received_on'];
					$patientData['Patient']['discharge_date'] = '0000-00-00 00:00:00';
					$patientData['Patient']['is_discharge'] = '0';
					$patientData['Patient']['visit_indicator'] = $userData['1']['visit_indicator'];//Changes
					$patientData['Patient']['hl7_patient_class'] = $userData['1']['hl7_patient_class'];
					$patientData['Patient']['hl7_location_point_of_care'] = $userData['1']['hl7_location_point_of_care'];
					$patientData['Patient']['hl7_location_room'] = $userData['1']['hl7_location_room'];
					$patientData['Patient']['hl7_location_bed'] = $userData['1']['hl7_location_bed'];
					$patientData['Patient']['hl7_location_facility'] = $userData['1']['hl7_location_facility'];
					$patientData['Patient']['hl7_admission_type'] = $userData['1']['hl7_admission_type'];
					$patientData['Patient']['vip_indicator'] = $userData['1']['vip_indicator'];
					$patientData['Patient']['visit_publicity_code'] = $userData['2']['visit_publicity_code'];
					$patientData['Patient']['patient_status_code'] = $userData['2']['patient_status_code'];
					$patientData['Patient']['visit_protection_indicator'] = $userData['2']['visit_protection_indicator'];
					$patientData['Patient']['new_born_baby_indicator'] = $userData['2']['new_born_baby_indicator'];
					$patientData['Patient']['hl7_mode_of_arrival'] = $userData['2']['hl7_mode_of_arrival'];
					$patientData['Patient']['hl7_patient_handicap'] = $additionalDetails['hl7_patient_handicap'];
					$patientData['Patient']['hl7_patient_type'] = $userData['1']['hl7_patient_type'];
					$patientData['Patient']['hl7_financial_class'] = $userData['1']['hl7_financial_class'];
					$patientData['Patient']['hl7_servicing_facility'] = $userData['1']['hl7_servicing_facility'];
					$patientData['Patient']['vip_indicator'] = $userData['1']['vip_indicator'];
					$patientData['Patient']['discharge_disposition'] = $userData['1']['discharge_disposition'];
					$patientData['Patient']['discharge_to_location'] = $userData['1']['discharge_to_location'];
					$patientData['Patient']['hl7_admit_source'] = $userData['1']['hl7_admit_source'];
					$patientData['Patient']['arrive_by'] = $patientData['Patient']['hl7_mode_of_arrival'];
					$patientData['Patient']['is_paragon'] = '1';
					$diagnoses['Diagnoses']['complaints'] = $userData['2']['complaints'];
					
					$patientId = $this->getPatientID($personId);
					$patientId = $this->setPatientData($patientData,$personData,$consultantId,$patientId,'A13');
					
					$this->setDiagnosis($patientId,$personId,$diagnoses);
					
					$insuranceData1 = $this->InterfaceEngine->parseIN1($xml->IN1,$patientId,$this->patientUid,$xml->IN2);
					$insuranceData['InsuranceCompany'] = $insuranceData1['0'];
					$insuredData['NewInsurance'] = $insuranceData1['1'];
					$insuredId =$this->getInsuranceID($patientId);
					$insuranceCompanyId = $this->setPatientInsurance($insuranceData,$insuredData,$patientId,$insuredId);
					$personModel->updateAll(array('Person.insurance_type_id' => $insuranceCompanyId),array('Person.id'=>$personId));
					//$this->setCurrentAppointment($personId,$patientId,$userData['0']);
					unset($insuranceData1);
					$patientUid = $this->getIDByFields('id','patient_uid','Person',$limit=1,$offset=0);
					$allergiesArray = $this->InterfaceEngine->parseADTAL1($xml->AL1,$patientId,$personId);
					$this->setPatientAllergies($allergiesArray);
					$diagnosesArray = $this->InterfaceEngine->parseADTAL1($xml->DG1,$patientId,$personId);
					$this->setPatientDiagnoses($diagnosesArray);
				}
				$paragonMessageModel->updateAll(array('ParagonMessage.status' => '1'),array('ParagonMessage.id'=>$message['ParagonMessage']['id']));
				$paragonMessageModel->id = '';
			
			
			}
		}
	}
	
	public function getPersonID($patientUID){
		App::uses('Person', 'Model');
		$personModel = new Person(null,null,$this->InterfaceEngine->database);
		$personData = $personModel->find('first',array('fields'=>array('Person.id'),'conditions'=>array('Person.alternate_patient_uid'=>$patientUID)));
		return $personData['Person']['id'];
	}
	
	public function getPatientIDByUid($patientUID){
		App::uses('Patient', 'Model');
		App::uses('PharmacySalesBill', 'Model');
		App::uses('InventoryPharmacySalesReturn', 'Model');
		$patientModel = new Patient(null,null,$this->InterfaceEngine->database);
		$patientModel->unBindModel(array(
				'hasMany' => array(new PharmacySalesBill(null,null,$this->InterfaceEngine->database),
							new InventoryPharmacySalesReturn(null,null,$this->InterfaceEngine->database))));
		$patientData = $patientModel->find('first',array('fields'=>array('Patient.id'),'conditions'=>array('Patient.person_id'=>$patientUID),'order'=>array('id'=>'desc')));
		return $patientData['Patient']['id'];
	}
	
	public function getPatientID($personId){
		App::uses('Patient', 'Model');
		App::uses('PharmacySalesBill', 'Model');
		App::uses('InventoryPharmacySalesReturn', 'Model');
		$patientModel = new Patient(null,null,$this->InterfaceEngine->database);
		$patientModel->unBindModel(array(
				'hasMany' => array(new PharmacySalesBill(null,null,$this->InterfaceEngine->database),
							new InventoryPharmacySalesReturn(null,null,$this->InterfaceEngine->database))));
		$patientData = $patientModel->find('first',array('fields'=>array('Patient.id'),'conditions'=>array('Patient.person_id'=>$personId),'order'=>array('Patient.id'=>'desc')));
		return $patientData['Patient']['id'];
	}
	
	public function setGuarantor($data,$personId,$gaurantorId=null,$isNK1=false){
		
		App::uses('Guarantor', 'Model');
		App::uses('CaregiverContact', 'Model');
		App::uses('CaregiverAddress', 'Model');
		$guarantorModel = new Guarantor(null,null,$this->InterfaceEngine->database);
		$isUpdate = 0;
		foreach($data as $key=>$gua){
			if(is_array($gua) && $gua['Guarantor']['gau_last_name']){
				$gua['Guarantor']['person_id'] = $personId;
				$gua['Guarantor']['created'] = '0';
				if($isNK1){
					$guarantorId = $this->getIDByFields(array('gau_contact_role'=>$gua['Guarantor']['gau_contact_role'],'person_id'=>$personId,'gau_first_name'=>$gua['Guarantor']['gau_first_name'],'gau_last_name'=>$gua['Guarantor']['gau_last_name']), 'id', 'Guarantor');
				}else{
					$guarantorId = $this->getIDByFields(array('person_id'=>$personId,'gau_first_name'=>$gua['Guarantor']['gau_first_name'],'gau_last_name'=>$gua['Guarantor']['gau_last_name']), 'id', 'Guarantor');
				}
				
				if($guarantorId){
					$guarantorModel->set('id',$guarantorId);
					$isUpdate = 1;
				}
				$gua = Set::filter($gua);
				$guarantorModel->save($gua);
				
				$guarantorId = $guarantorModel->id;
				
				$caregiverContactModel = new CaregiverContact(null,null,$this->InterfaceEngine->database);
				$caregiverAddressModel = new CaregiverAddress(null,null,$this->InterfaceEngine->database);
				if(is_array($gua) && $gua['Address']['0']['gau_plot_no'] && $guarantorId){
					$addresses = array();
					foreach($gua['Address'] as $key=>$address){
						if(!$address){
							continue;
						}
						$address['guarantor_id'] = $guarantorId;
							$addr = $this->getIDByFields(array('guarantor_id'=>$guarantorId), 'id', 'CaregiverAddress',1,$key);
							
							if(!empty($addr)){
								$caregiverAddressModel->set('id',$addr);
							}
							$address = Set::filter($address);
							$caregiverAddressModel->save($address);
							$caregiverAddressModel->set('id',null);
						//array_push($addresses,$address);
					}
				}
				if($gua['CaregiverContact'] && $gua['CaregiverContact']['1']['gau_city_code'] && $guarantorId){
					$contacts = array();
					$count = 0;
					foreach($gua['CaregiverContact'] as $key=>$contact){
						if(!$contact){
							continue;
						}
						$contact['guarantor_id'] = $guarantorId;
						$cont = $this->getIDByFields(array('guarantor_id'=>$guarantorId), 'id', 'CaregiverContact',1,$count);
						
						if($cont){
							$caregiverContactModel->set('id',$cont);
						}
						$contact = Set::filter($contact);
						$caregiverContactModel->save($contact);
						$caregiverContactModel->set('id',null);
						//array_push($contacts,$contact);
						$count++;
					}
					
				}
			}
			$guarantorModel->set('id',null);
		}
		
		return $guarantorId;
	}
	
	public function getGuarantorID($personId){
		App::uses('Guarantor', 'Model');
		$guarantorModel = new Guarantor(null,null,$this->InterfaceEngine->database);
		$guarantorData = $guarantorModel->find('first',array('fields'=>array('Guarantor.id'),'conditions'=>array('Guarantor.person_id'=>$personId)));
		return $guarantorData['Guarantor']['id'];
	}
	
	public function getInsuranceID($patientId){
		App::uses('NewInsurance', 'Model');
		$newInsuranceModel = new NewInsurance(null,null,$this->InterfaceEngine->database);
		$insuranceData = $newInsuranceModel->find('first',array('fields'=>array('NewInsurance.id'),'conditions'=>array('NewInsurance.patient_id'=>$patientId)));
		return $insuranceData['NewInsurance']['id'];
	}
	
	public function getIDByFields($fields,$returnValue,$model,$limit=1,$offset=0){
		App::uses($model, 'Model');
		$modelObj = new $model(null,null,$this->InterfaceEngine->database);
		$modelObj->recursive = -1;
		$result = $modelObj->find('first',array('fields'=>array($returnValue),'conditions'=>$fields,'limit'=>$limit,'offset'=>$offset));
		
		$id = $result["$model"]["$returnValue"];
		
		return $id;
		
	}
	
	public function setInsuranceCompany($data){
		App::uses('InsuranceCompany', 'Model');
		$insuranceCompanyModel = new InsuranceCompany(null,null,$this->InterfaceEngine->database);
		/*$insuranceCompanyModel->unBindModel(array(
				'belongsTo' => array(
							new InsuranceType(null,null,$this->InterfaceEngine->database))));*/
		App::uses('TariffStandard', 'Model');
		$tariffStandardModel = new TariffStandard(null,null,$this->InterfaceEngine->database);
		
		$insuranceCompanyDetails = $insuranceCompanyModel->find('first',array('fields'=>array('id'),'conditions'=>array('InsuranceCompany.name'=>$data['name'])));
		$tariffStandardDetails = $tariffStandardModel->find('first',array('fields'=>array('id'),'conditions'=>array('TariffStandard.name'=>$data['name'])));
		if(($insuranceCompanyDetails) && ($tariffStandardDetails)){
			return array($insuranceCompanyDetails['InsuranceCompany']['id'],$tariffStandardDetails['TariffStandard']['id']);
		}else{
			
			$data['address'] = $data['address_one'].', '.$data['address_two'];
			$data['phone'] = trim($data['area_city_code'].$data['local_num']);
			$data['extension'] = $data['extention'];
			if(empty($data['phone'])){
				$data['phone'] = '0';
			}
			$data['location_id'] = $this->InterfaceEngine->locationId;
			$data['is_deleted'] = '0';
			$data['is_active'] = '1';
			$data['create_time'] = date("Y-m-d H:i:s");
			$data['created_by'] = '0';
			$insuranceCompanyModel->id = null;
			$tariffStandardModel->id = null;
			$data1['InsuranceCompany'] = $data;
			if(empty($insuranceCompanyDetails)){
				$insuranceCompanyModel = new InsuranceCompany(null,null,$this->InterfaceEngine->database);
				/*$insuranceCompanyModel->save(array('name'=>$data['name'],'address'=>$data['address'],'city_id'=>$data['city_id'],'state_id'=>$data['state_id'],
						'zip'=>$data['zip'],'country_id'=>$data['country_id'],'address_type'=>$data['address_type'],'country_parish_code'=>$data['country_parish_code']
						,'area_city_code'=>$data['area_city_code'],'local_num'=>$data['local_num'],'extention'=>$data['extention'],'phone_type'=>$data['phone_type']
						,'phone'=>$data['phone'],'location_id'=>$data['location_id'],'is_deleted'=>$data['is_deleted'],'is_active'=>$data['is_active']
						,'create_time'=>$data['create_time'],'created_by'=>$data['created_by']));*/
				$data = Set::filter($data);
				$insuranceCompanyModel->save($data);
				$insuranceCompanyId = $insuranceCompanyModel->getInsertId();
				
			}else{
				$insuranceCompanyId = $insuranceCompanyDetails['InsuranceCompany']['id'];
			}
			if(empty($tariffStandardDetails)){
				$data = Set::filter($data);
				$tariffStandardModel->save($data);
				$tariffStandardId = $tariffStandardModel->getInsertId();
			}else{
				$tariffStandardId = $tariffStandardDetails['TariffStandard']['id'];
			}
			$insuranceCompanyModel->id = null;
			$tariffStandardModel->id = null;
			return array($insuranceCompanyId,$tariffStandardId);
		}
	}
	
	
	public function setPatientAllergies($data){
		App::uses('NewCropAllergies', 'Model');
		$newCropAllergyModel = new NewCropAllergies(null,null,$this->InterfaceEngine->database);
		$newCropAllergyModel->saveAll($data,array('callbacks' =>false));
	}
	
	public function setPatientDiagnoses(){
		App::uses('NoteDiagnosis', 'Model');
		$noteDiagnosis = new NoteDiagnosis(null,null,$this->InterfaceEngine->database);
		$noteDiagnosis->saveAll($data,array('callbacks' =>false));
	}
	
	public function setPatientInsurance($insuranceData,$insuredData,$patientId,$insuranceId){
		App::uses('NewInsurance', 'Model');
		$newInsuranceModel = new NewInsurance(null,null,$this->InterfaceEngine->database);
		App::uses('Patient', 'Model');
		$patientModel = new Patient(null,null,$this->InterfaceEngine->database);
		$insuranceId = null;
		$cnt = 0;
		foreach($insuredData['NewInsurance'] as $key=>$value){
			$insuranceCompanyId = $this->setInsuranceCompany($insuranceData['InsuranceCompany'][$key]);
			$cond = array('patient_id'=>$patientId);
			$isExists = $newInsuranceModel->find('first',array('fields'=>array('id'),'conditions'=>$cond,'limit'=>$limit,'offset'=>$key));
			
			if($isExists){
				$insuranceId = $isExists['NewInsurance']['id'];
				$newInsuranceModel->set('id',$insuranceId);
			}
			$value['insurance_company_id'] = $insuranceCompanyId['0'];
			$value['tariff_standard_id'] = $insuranceCompanyId['1'];
			$value['priority'] = 'P';
			$value['tariff_standard_name'] = $insuranceData['InsuranceCompany'][$key]['name'];
			$value['location_id'] = $this->InterfaceEngine->locationId;
			$value['insurance_name'] = $insuranceData['InsuranceCompany'][$key]['name'];
			$value['is_active'] = '1';
			$value['is_deleted'] = '0';
			$value['created_by'] = '0';
			$value['create_time'] = date("Y-m-d H:i:s");
			$value = Set::filter($value);
			$newInsuranceModel->save($value);
			if($cnt == 0){
				$primaryInsuranceId = $insuranceCompanyId['1'];
			}
			$newInsuranceModel->id = null;
			$newInsuranceModel->set('id',null);
			$patientModel->updateAll(array('Patient.tariff_standard_id' => "'$insuranceCompanyId'"),array('Patient.id'=>$patientId));
			$patientModel->id = null;
			$cnt++;
		}
		return $primaryInsuranceId;
	}
	
	public function setPersonData($dataPerson,$additionalDetails,$personId=null,$addresss=array(),$contacts=array(),$isInsured='0',$isA04=null,$model=null){
		if(empty($model)){
			App::uses('Person', 'Model');
			$personModel = new Person(null,null,$this->InterfaceEngine->database);
		}else{
			$personModel = $model;
		}
		$data['Person'] = $dataPerson;
		$data['Person']['location_id'] = $this->InterfaceEngine->locationId;
		$data['Person']['create_time'] = date('Y-m-d H:i:s') ;
		$data['Person']['created_by'] = '0' ;
		$data['Person']['is_deleted'] = '0' ;
		$data['Person']['visit_indicator'] = $additionalDetails['visit_indicator'];
		if($isInsured > 0){
			$data['Person']['payment_category'] = 'Insurance';
		}else{
			$data['Person']['payment_category'] = 'Cash';
		}
		$data['Person']['adv_directive'] = str_replace(" - ", "-", ucwords(str_replace("-", " - ", strtolower($additionalDetails['adv_directive']))));
		$data['Person']['organ_donor'] = $additionalDetails['organ_donor'];
		$data['Person']['protection_indicator'] = $additionalDetails['protection_indicator'];
		$data['Person']['publicity_code'] = $additionalDetails['publicity_code'];
		
		if($personId){
			$personModel->id = $personId;
			$personAlreadyExists = 1;
		}else{
			$personAlreadyExists = 0;
		}
		$data = Set::filter($data);
		$personModel->save($data,array('callbacks' =>false));
		if($personId){
			$latest_id = $personId;
		}else{
			$latest_id = $personModel->getInsertId();
		}
		if($personAlreadyExists ==0){
			$patient_uid = $this->autoGeneratedPatientID($latest_id,$data,$this->InterfaceEngine->locationId,$this->InterfaceEngine->facility,$this->InterfaceEngine->location);
			$personModel->updateAll(array('Person.patient_uid' => "'$patient_uid'"),array('Person.id'=>$latest_id));
		}
		$this->InterfaceEngine->patientUid = $patient_uid;
		$this->setPersonAddress($addresss,$contacts,$latest_id);
		$personModel->set('id',null);
		$personModel->id = null;
		return $latest_id;
	}
	
	public function setPersonAddress($adrresses=array(),$contacts=array(),$personId){
		App::uses('Address', 'Model');
		$addressModel = new Address(null,null,$this->InterfaceEngine->database);
		foreach($adrresses as $key=>$address){
			if($address['plot_no']){
				$addrData = $addressModel->find('first', array('limit'=>($key+1), 'offset'=>($key),'order'=>array('id'=>'ASC'),'conditions'=>array('address_type_id'=>$personId,'address_type'=>'Person'),'fields'=>array('id')));
				if($addrData && $addrData['Address']['id']){
					$addressModel->set('id',$addrData['Address']['id']);
				}
				$address['person_local_number'] = $contacts[$key]['person_local_number'];
				$address['person_extension'] = $contacts[$key]['person_extension'];
				$address['tele_code'] = $contacts[$key]['person_tele_code_second'];
				$address['address_type'] = 'Person';
				$address['address_type_id'] = $personId;
				$address = Set::filter($address);
				$addressModel->save($address);
				$addressModel->id = null;
			}
		}
		
		$address = array();
		$cnts = count($adrresses);
		if(count($adrresses) < count($contacts)){
			foreach($contacts as $key=>$contact){
				if($cnts < ($key+2)){
					$addrData = $addressModel->find('first', array('limit'=>($key+1), 'offset'=>($key),'order'=>array('id'=>'ASC'),'conditions'=>array('address_type_id'=>$personId,'address_type'=>'Person'),'fields'=>array('id')));
					if($addrData && $addrData['Address']['id']){
						$addressModel->set('id',$addrData['Address']['id']);
					}
					$address['person_local_number'] = $contact['person_local_number'];
					$address['person_extension'] = $contact['person_extension'];
					$address['tele_code'] = $contact['person_tele_code_second'];
					$address['address_type'] = 'Person';
					$address['address_type_id'] = $personId;
					$address = Set::filter($address);
					$addressModel->save($address);
					$addressModel->id = null;
					unset($address);
				}
				
			}
		}
	}
	
	
	public function setDiagnosis($patientId,$personId,$diagnoses){
		if($diagnoses['Diagnoses']['complaints']){
			App::uses('Diagnosis', 'Model');
			$diagnosisModel = new Diagnosis(null,null,$this->InterfaceEngine->database);
			$diagnoses['Diagnoses']['patient_id'] = $patientId;
			$diagnoses['Diagnoses']['is_deleted'] = '0';
			$diagnoses['Diagnoses']['location_id'] = $this->InterfaceEngine->locationId;
			$diagnoses['Diagnoses']['is_discharge'] = '0';
			$diagnoses['Diagnoses']['created_by'] = '0';
			$diagnoses['Diagnoses']['create_time'] = date("Y-m-d H:i:s");
			$diagnoses = Set::filter($diagnoses);
			$diagnosisModel->save($diagnoses);
			$diagnosisModel->set('id',null);
		}
	}
	
	public function setPatientData($patientData,$data,$consultantId,$patientId,$isA04=null,$model=null){
		
		
		if(empty($model)){
			App::uses('Patient', 'Model');
			App::uses('PharmacySalesBill', 'Model');
			App::uses('InventoryPharmacySalesReturn', 'Model');
			$patientModel = new Patient(null,null,$this->InterfaceEngine->database);
			$patientModel->unBindModel(array(
					'hasMany' => array(new PharmacySalesBill(null,null,$this->InterfaceEngine->database),
							new InventoryPharmacySalesReturn(null,null,$this->InterfaceEngine->database))));
		}else{
			$patientModel = $model;
		}
		
		//$patientData['Patient']['form_received_on'] = date('Y-m-d H:i:s') ;
		$patientData['Patient']['location_id'] = $this->InterfaceEngine->locationId;
		$patientData['Patient']['person_id'] = $data['Person']['id'];
		$patientData['Patient']['patient_id'] =$data['Person']['patient_uid'];
		$patientData['Patient']['is_deleted'] = 0;
		$patientData['Patient']['location_id'] = $data['Person']['location_id'];
		$patientData['Patient']['admission_type'] = 'OPD';
		$patientData['Patient']['is_emergency'] = 0;
		$patientData['Patient']['lookup_name']= $data["Person"]['first_name']." ".$data["Person"]['last_name'];
		$patientData['Patient']['form_received_on']=$patientData['Patient']['form_received_on'];
		$patientData['Patient']['create_time'] = date('Y-m-d H:i:s') ;
		$patientData['Patient']['created_by'] = '0';
		$patientData['Patient']['is_deleted']= 0 ;
		$patientData['Patient']['consultant_id']=$consultantId;
		$patientData['Patient']['known_fam_physician']='2';
		$patientData['Patient']['sex']= $data['Person']['sex'];
		if($patientId){
			$isPatientAlreadyExists = 1;
			$patientModel->id = $patientId;
		}else{
			$isPatientAlreadyExists = 0;
		}
		$patientData = Set::filter($patientData);
		$patientModel->save($patientData,array('callbacks' =>false));
		if($patientId){
			$latest_id = $patientId;
		}else{
			$latest_id = $patientModel->getInsertId();
		}
		if($isPatientAlreadyExists == 0){
			$admission_id = $this->autoGeneratedAdmissionID($latest_id,$patientData,$this->InterfaceEngine->locationId,$this->InterfaceEngine->facility,$this->InterfaceEngine->location);
			$patientModel->updateAll(array('Patient.admission_id' => "'$admission_id'"),array('Patient.id'=>$latest_id));
		}
		return $latest_id;
	}
	
	
	/**
	* Called after inserting patient data
	*
	* @param id:latest patient table ID
	* @param patient_info(array): patient details as posted from patinet registration form
	* @return patient ID
	**/
	public function autoGeneratedAdmissionID($id=null,$patient_info = array(),$locationId,$hospital,$location){
		App::uses('Patient', 'Model');
		$patientModel = new Patient(null,null,$this->InterfaceEngine->database);
		$count = $patientModel->find('count',array('conditions'=>array('Patient.create_time like'=> "%".date("Y-m-d")."%")));
		$count++ ; //count currrent entry also
		if($count==0){
			$count = "001" ;
		}else if($count < 10 ){
			$count = "00$count"  ;
		}else if($count >= 10 && $count <100){
			$count = "0$count"  ;
		}
		$month_array = array('A','B','C','D','E','F','G','H','I','J','K','L');
	
		//creating patient ID
		$unique_id   = ucfirst(substr($patient_info['Patient']['admission_type'],0,1));
		$unique_id  .= ucfirst(substr($hospital,0,1)); //first letter of the hospital name
		$unique_id  .= strtoupper(substr($location,0,2));//first 2 letter of d location
		$unique_id  .= date('y'); //year
		$unique_id  .= $month_array[date('n')-1];//first letter of month
		$unique_id  .= date('d');//day
		$unique_id .= $count;
		$this->admissionId = strtoupper($unique_id);
		return strtoupper($unique_id) ;
	}
	
	/**
	 * Called after inserting patient data
	 *
	 * @param id:latest patient table ID
	 * @param patient_info(array): patient details as posted from patinet registration form
	 * @return patient ID
	 **/
	function autoGeneratedPatientID($id=null,$patient_info = array(),$locationId=null,$facility=null,$location=null){
		//$patient_info=array('Patient'=>array('first_name'=>'Pankaj','admission_type'=>'IPD','location_id'=>1));
		//$this->loadModel('Patient');
		App::uses('Person', 'Model');
		$personModel = new Person(null,null,$this->InterfaceEngine->database);
		if(empty($locationId)){
			$locationId = $this->Session->read('locationid');
		}
		$count = $personModel->find('count',array('conditions'=>array('Person.create_time like'=> "%".date("Y-m-d")."%")));
		
		if($count==0){
			$count = "001" ;
		}else if($count < 10 ){
			$count = "00$count"  ;
		}else if($count >= 10 && $count <100){
			$count = "0$count"  ;
		}
	
		$month_array = array('A','B','C','D','E','F','G','H','I','J','K','L');
		//find the Hospital name.
		
		//creating patient ID
		$unique_id   = 'U';
		$unique_id  .= substr($facility,0,1); //first letter of the hospital name
		$unique_id  .= substr($location,0,2);//first 2 letter of d location
		$unique_id  .= date('y'); //year
		$unique_id  .= $month_array[date('n')-1];//first letter of month
		$unique_id  .= date('d');//day
		$unique_id .= $count;
		$this->patientUid = strtoupper($unique_id);
		return strtoupper($unique_id) ;
	
	}

function setCurrentAppointment($personId,$patientId,$doctorId,$model=null){
		
		if(empty($model)){
			App::uses('Appointment', 'Model');
			$appointmentModel = new Appointment(array('ds' => $this->InterfaceEngine->database));
		}else{
			$appointmentModel = $model;
		}
		//swapping some of the field from appointment form
		$data['Appointment']['person_id'] = $personId;
		$data['Appointment']['patient_id'] = $patientId;
		$data['Appointment']['location_id'] = $this->InterfaceEngine->locationId;
		$data['Appointment']['department_id'] = '0';
		$data['Appointment']['doctor_id'] = $doctorId;
		$data['Appointment']['appointment_with'] = $doctorId;
		$data['Appointment']['date'] = date('Y-m-d');
		$time = explode(':',date('H:i'));//debug($time);
		if($time[1] <= 15){
			$startTime = date('Y-m-d H').":15";
			$endTime = date('Y-m-d H').":30";
		}elseif($time[1] <= 30 && $time[1] >= 15 ){
			$startTime = date('Y-m-d H').":30";
			$endTime = date('Y-m-d H').":45";
		}elseif($time[1] <= 45 && $time[1] >= 30 ){
			$startTime = date('Y-m-d H').":45";
			$endTime = date('Y-m-d H', strtotime('+1 hour')).":00";
		}else{
			$startTime = date('Y-m-d H', strtotime('+1 hour')).":00";
			$endTime = date('Y-m-d H', strtotime('+1 hour')).":15";
		} //echo ($startTime.'---'.$endTime.'--here');//gaurav
	
		$currentSlots = $appointmentModel->find('first',array('fields'=>array('id','end_time','date'),'conditions'=>array('date'=>date('Y-m-d'),'doctor_id'=>$doctorId),'order'=>array('id'=> 'DESC')));
		///echo $startTime." >= ".$currentSlots['Appointment']['date'].' '.$currentSlots['Appointment']['end_time'];
		if(strtotime($startTime) >= strtotime($currentSlots['Appointment']['date'].' '.$currentSlots['Appointment']['end_time'])){
			$startTime = $startTime;
			$endTime = $endTime; //echo 'here1';
		}
		else if(strtotime($currentSlots['Appointment']['date'].' '.$currentSlots['Appointment']['end_time']) <= strtotime($endTime)){
			$startTime = $currentSlots['Appointment']['date'].' '.$currentSlots['Appointment']['end_time'];
			$endTime = date('Y-m-d H:i',strtotime("+15 minutes", strtotime($startTime))); //echo 'here2';
		}
		else if(strtotime($currentSlots['Appointment']['date'].' '.$currentSlots['Appointment']['end_time']) >= strtotime($startTime)){
			$startTime = $currentSlots['Appointment']['date'].' '.$currentSlots['Appointment']['end_time'];
			$endTime = date('Y-m-d H:i',strtotime("+15 minutes", strtotime($currentSlots['Appointment']['date'].' '.$currentSlots['Appointment']['end_time'])));
		}
	
		//debug($currentSlots);echo ($startTime.'---'.$endTime);
		//exit;//gaurav
	
		$data['Appointment']['start_time'] = date('H:i',strtotime($startTime));
		$data['Appointment']['arrived_time']=date('H:i',strtotime($startTime));;
		$data['Appointment']['end_time'] = date('H:i',strtotime($endTime));;
		$data['Appointment']['is_future_app'] = 0;
		if($patientArray['Patient']['treatment_type'])
			$data['Appointment']['visit_type'] = '';
		else
			$data['Appointment']['visit_type'] = 6;
		$data['Appointment']['status'] = 'Arrived';
		$data['Appoinment']['arrived_time']=date('H:i');
		$data['Appointment']['created_by'] = '0';
		$data['Appointment']['create_time'] = date('Y-m-d H:i:s');
		//$this->create();
		$data = Set::filter($data);
		return $appointmentModel->save($data);
	}
	
	public function updatePatientAppointment($patientId,$status){
		App::uses('Appointment', 'Model');
		$appointmentModel = new Appointment(array('ds' => $this->InterfaceEngine->database));
		$appointmentModel->updateAll(array('Appointment.status' => "'".$status."'"),array('Appointment.patient_id'=>$patientId,'Appointment.date'=>date("Y-m-d")));
		
	}
}