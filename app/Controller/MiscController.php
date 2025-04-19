<?php
/**
 * MiscController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2015 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       MiscController
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        
 */

class MiscController extends AppController {
	//
	public $name = 'Misc';
	public $components = array('RequestHandler','Email','DateFormat','Number','General');
	public $helpers = array('Html','Form', 'Js','DateFormat','RupeesToWords','Number','General','Cache');
	
	function index(){
		
	}
	
	
	function helpDesk(){
	
		$this->uses=array('Ward','Patient','Billing','PatientCard','DoctorProfile','Bed','Room','Account','TariffStandard','Person',
				'OtPharmacySalesReturn','InventoryPharmacySalesReturn');
		$this->layout = 'advance';
		$this->Patient->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
	
	
		$this->Person->bindModel(array(
				'belongsTo'=>array(
						"Patient"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('Patient.person_id=Person.id')),
						"Ward"=>array("foreignKey"=>false,'conditions'=>array('Patient.ward_id=Ward.id')),
						"Bed"=>array("foreignKey"=>false,'conditions'=>array('Patient.bed_id=Bed.id')),
						"Room"=>array("foreignKey"=>false,'conditions'=>array('Patient.room_id=Room.id')),
						"TariffStandard"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('Patient.tariff_standard_id=TariffStandard.id')),
						"DoctorProfile"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('DoctorProfile.user_id=Patient.doctor_id')))
		));
		
		if(!empty($this->params->query)){
		
		if(!empty($this->params->query['patient_name'])){
			$patientname=explode('-', $this->params->query['patient_name']);
			$patientID=explode('(', $patientname[1]);
			$conditions['Patient.patient_id']=$patientID[0];
		}
		if(!empty($this->params->query['mobile_no'])){
			$conditions['Person.mobile']=$this->params->query['mobile_no'];
		}
		if(!empty($this->params->query['city'])){
			$conditions['Person.city LIKE']="%".$this->params->query['city']."%";
		}
	
		$patientData=$this->Person->find('all',array('fields'=>array('Patient.id','Patient.patient_id','Patient.lookup_name','Patient.admission_type',
				'Patient.sex','Patient.age','Patient.form_received_on','Patient.person_id','Patient.is_discharge','Patient.admission_id',
				'Patient.admission_id','Patient.form_received_on','Patient.clearance','Patient.dashboard_status','Patient.nurse_id','Patient.doctor_id',
				'Person.first_name','Person.last_name','Person.sex','Person.dob','Person.mobile','Person.city',
				'Person.patient_credentials_created_date','Patient.discharge_date','TariffStandard.name','Ward.name','Room.bed_prefix','Bed.bedno'),
				'conditions'=>array($conditions),
				'group'=>array('Patient.id'),
				'order'=>'Patient.id ASC'));
		$patientDetails[] = end($patientData);
		
		foreach ($patientDetails as $key=>$patientData){
			$patientDetails[$key]['total_amount'] = $this->Billing->getPatientTotalBill($patientData['Patient']['id'],$patientData['Patient']['admission_type']);
	
			//$surgeryData[] = array_merge($this->groupWardCharges($patientData['Patient']['id'],true),array('patient_id'=>$patientData['Patient']['id']));
	
			$otPharmacyReturn = $this->OtPharmacySalesReturn->find('first',array('fields'=>array('SUM(OtPharmacySalesReturn.discount) as totalOtPharmaDiscount'),
					'conditions'=>array('OtPharmacySalesReturn.patient_id'=>$patientData['Patient']['id'],'OtPharmacySalesReturn.is_deleted'=>'0')));
	
			$pharmacyReturn = $this->InventoryPharmacySalesReturn->find('first',array('fields'=>array('SUM(InventoryPharmacySalesReturn.discount) as totalPharmaDiscount'),
					'conditions'=>array('InventoryPharmacySalesReturn.patient_id'=>$patientData['Patient']['id'],'InventoryPharmacySalesReturn.is_deleted'=>'0')));
	
			$billingRefund = $this->Billing->find('first',array('fields'=>array('SUM(Billing.paid_to_patient) as totalAmountRefund'),
					'conditions'=>array('Billing.patient_id'=>$patientData['Patient']['id'],'Billing.is_deleted'=>'0',
							'Billing.location_id'=>$this->Session->read('locationid'))));
	
			$billingDetails = $this->Billing->find('first',array('fields'=>array('SUM(amount) as totalAmountPaid','SUM(discount) as totalDiscount'),
					'conditions'=>array('patient_id'=>$patientData['Patient']['id'],'is_deleted'=>'0',
							'location_id'=>$this->Session->read('locationid'))));
	
			$patientDetails[$key]['amount_paid']= $billingDetails['0']['totalAmountPaid']-$billingRefund['0']['totalAmountRefund'];
			$patientDetails[$key]['amount_discount']= $billingDetails['0']['totalDiscount']-$otPharmacyReturn['0']['totalOtPharmaDiscount']-$pharmacyReturn['0']['totalPharmaDiscount'];
	
			$cardDetails = $this->Account->find('first',array('fields'=>array('card_balance'),
					'conditions'=>array('system_user_id'=>$patientData['Patient']['person_id'],'is_deleted'=>'0',
							'location_id'=>$this->Session->read('locationid'),'user_type'=>'Patient')));
			$patientDetails[$key]['card_balance'] = $cardDetails['Account']['card_balance'];
		}
	//debug($patientDetails);
		$this->set('patientDetails',$patientDetails);
		}
	}
	
}