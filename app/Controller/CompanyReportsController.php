<?php
/**
 * Billings Controller
 *
 * PHP 5
 * @package       CompanyReports
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pooja Gupta
 */

App::import('Controller', 'Billings');
class CompanyReportsController extends BillingsController {

	public $name = 'CompanyReports';

	public $helpers = array('DateFormat','RupeesToWords','Number','General');

	public $components = array('General','DateFormat','Number','GibberishAES','PhpExcel');

	public function beforeFilter(){
			
	}
	
	public function companyExcelReport($superBillId=NULL,$corporate=NULL){
		//$this->uses=array('ServiceCategory','Patient','Billing','User');
		$this->uses=array('Patient','Billing','User','ServiceBill','LaboratoryTestOrder','RadiologyTestOrder','WardPatientService','ConsultantBilling',
				'CorporateSuperBill','Patient','ServiceCategory','Account','PharmacySalesBill','OtPharmacySalesBill','InventoryPharmacySalesReturn',
				'OtPharmacySalesReturn','CorporateSuperBillList','PatientCard','WardPatient','Person','FinalBilling','OptAppointment');	
		
		if(!empty($superBillId)){
			$superbillData=$this->CorporateSuperBill->find('first',array('conditions'=>array('id'=>$superBillId)));			
			$patientIds=explode('|',$superbillData['CorporateSuperBill']['patient_id']);
			if($superbillData['CorporateSuperBill']['patient_type']=='General'){
				$wardAmt=$this->WardPatientService->getWardTypeCharges('General Ward',$superbillData['CorporateSuperBill']['tariff_standard_id']);
			}else if($superbillData['CorporateSuperBill']['patient_type']=='Semi-Private'){
				$wardAmt=$this->WardPatientService->getWardTypeCharges('Twin-Sharing',$superbillData['CorporateSuperBill']['tariff_standard_id']);
			}else if($superbillData['CorporateSuperBill']['patient_type']=='Private'){
				$wardAmt=$this->WardPatientService->getWardTypeCharges('Special Ward',$superbillData['CorporateSuperBill']['tariff_standard_id']);
			}
			$wardcharge['amount']=$wardAmt;
			$wardcharge['wardName']=$superbillData['CorporateSuperBill']['patient_type'];
			$billBo=$superbillData['CorporateSuperBill']['patient_bill_no'];
			if(!$billBo){
				$order="(CASE Patient.admission_type
				 		WHEN 'IPD' THEN 1
						WHEN 'OPD' THEN 2
						WHEN 'LAB' THEN 3
						WHEN 'RAD' THEN 4
						ELSE 100 END) ASC";
				$this->FinalBilling->bindModel(array(
						'belongsTo'=>array('Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id=FinalBilling.patient_id')))));
				$billBo=$this->FinalBilling->find('first',array('fields'=>array('Patient.id','Patient.admission_type','FinalBilling.id',
						'FinalBilling.bill_number'),
						'conditions'=>array('FinalBilling.patient_id'=>$patientIds),
						'order'=>array($order)));
				$billBo=$billBo['FinalBilling']['bill_number'];
				$this->CorporateSuperBill->updateAll(array('CorporateSuperBill.patient_bill_no'=>"'$billBo'"),array('CorporateSuperBill.id'=>$superBillId));
			}
			
			$this->set(array('billData'=>$billBo));
			$tariffStdData = $this->Patient->find('first',array('fields'=>array('id','tariff_standard_id','is_discharge','mobile_phone',
					'treatment_type','admission_type','is_packaged','person_id','form_received_on','age','sex','lookup_name','patient_id',
					'discharge_date','admission_id','consultant_id','doctor_id','address1','relation_to_employee','name_of_ip'),
					'conditions'=>array('id'=>$patientIds),
					'order'=>array('Patient.id DESC')));
			
			$this->Person->bindModel(array(
					'belongsTo'=>array('State'=>array('foreignKey'=>false,'conditions'=>array('State.id=Person.state')))));
			$personData=$this->Person->find('first',array('conditions'=>array('Person.id'=>$superbillData['CorporateSuperBill']['person_id'])));
			
			$address='';
			if($personData['Person']['plot_no']){
				$address.=ucwords(strtolower($personData['Person']['plot_no'])).', ';
			}
			if($personData['Person']['landmark']){
				$address.=ucwords($personData['Person']['landmark']).', ';
			}
			if($personData['Person']['city']){
				$address.=ucwords($personData['Person']['city']).', ';
			}
			if($personData['Person']['district']){
				$address.=ucwords($personData['Person']['district']).', ';
			}
			if($personData['Person']['state']){
				$address.=ucwords($personData['State']['name']).'- ';
			}
			if($personData['Person']['pin_code']){
				$address.=$personData['Person']['pin_code'];
			}
			
			$mobile=$personData['Person']['mobile'];
			$this->set(array('mobile'=>$mobile,'address'=>$address));
			
			$serviceCategory = $this->ServiceCategory->find("list",array('fields'=>array('id','name'),
					"conditions"=>array("ServiceCategory.is_deleted"=>0,/*"ServiceCategory.is_view"=>1,*/
							/*"ServiceCategory.service_type"=>array($tariffStdData['Patient']['admission_type'],'Both'),*/
							"ServiceCategory.location_id"=>array($this->Session->read('locationid'),'0')),
					/*'order' => array('ServiceCategory.name' => 'asc')*/));
			$serviceCategoryName = $this->ServiceCategory->find("list",array('fields'=>array('id','alias'),
					"conditions"=>array("ServiceCategory.is_deleted"=>0,/*"ServiceCategory.is_view"=>1,*/
							/*"ServiceCategory.service_type"=>array($tariffStdData['Patient']['admission_type'],'Both'),*/
							"ServiceCategory.location_id"=>array($this->Session->read('locationid'),'0')),
					/*'order' => array('ServiceCategory.name' => 'asc')*/));
			$this->set('serviceCategoryName',$serviceCategoryName);
			if($tariffStdData['Patient']['consultant_id']){
			$consultant=$this->User->find('first',array('fields'=>array('first_name','last_name'),
					'conditions'=>array('User.id'=>$tariffStdData['Patient']['consultant_id'])));
			}else{
				$consultant=$this->User->find('first',array('fields'=>array('first_name','last_name'),
						'conditions'=>array('User.id'=>$tariffStdData['Patient']['doctor_id'])));
			}
			$this->set('consultant',$consultant);	
			
			$serviceBillData=$this->ServiceBill->getServices(array('ServiceBill.patient_id'=>$patientIds));
		
		    $labData=$this->LaboratoryTestOrder->getLaboratories(array('LaboratoryTestOrder.patient_id'=>$patientIds));
		
		    $radData=$this->RadiologyTestOrder->getRadiologies(array('RadiologyTestOrder.patient_id'=>$patientIds));
		
		    $wardserviceBillData=$this->WardPatientService->getWardServices(array('WardPatientService.patient_id'=>$patientIds),'');

		    $treatingConsultantData=$this->ConsultantBilling->getDdetail($patientIds,'');
		
		    $externalConsultantData=$this->ConsultantBilling->getCdetail($patientIds,'');
		
		    $pharmacyData=$this->PharmacySalesBill->getPatientPharmacyCharges($patientIds,'');
		
		    $otPharmacyData=$this->OtPharmacySalesBill->getPatientOtPharmacyCharges($patientIds,'');
		    
		    $surgeryData=$this->OptAppointment->getSurgeryServices(array('OptAppointment.patient_id'=>$patientIds),$superbillData['CorporateSuperBill']['tariff_standard_id']);
		    
		    $conservative=$this->OptAppointment->calConservative($wardserviceBillData,$patientIds);
		     //$this->generateFinalBill($patientIds);
		    $i=0;
		    foreach ($treatingConsultantData as $Ckey=>$cBilling){
		    	foreach($cBilling as $CBillKey=>$consultantBillingDta){
		    		foreach($consultantBillingDta as $conKey=>$consultantBilling){
		    			foreach($consultantBilling as $singleKey=>$service){
		    				$patientArray['patient_id']=$service['ConsultantBilling']['patient_id'];
		    				$encounterAmt=($service['ConsultantBilling']['amount'])-$service['ConsultantBilling']['paid_amount']-$service['ConsultantBilling']['discount'];
		    				if($encounterAmt<=0){
		    					$encounterAmt=0;
		    				}
		    				$patientArray['totalAmount']=$patientArray['totalAmount']+$encounterAmt;
		    				$consultantArray[$i]['table_id']=$service['ConsultantBilling']['id'];
		    				$consultantArray[$i]['doctor_id']=$service['ConsultantBilling']['doctor_id'];
		    				$consultantArray[$i]['name']=$service['TariffList']['name'].'('.$service['DoctorProfile']['first_name'].' '.$service['DoctorProfile']['last_name'].')';
		    				$consultantArray[$i]['tariff_list_id']=$service['TariffList']['id'];
		    				$consultantArray[$i]['no_of_times']=$service['TariffList']['apply_in_a_day'];
		    				$consultantArray[$i]['cghs']=$service['TariffList']['cghs_code'];
		    				$consultantArray[$i]['amount']=$service['ConsultantBilling']['amount'];
		    				$consultantArray[$i]['discount']=$service['ConsultantBilling']['discount'];
		    				$consultantArray[$i]['paid_amount']=$service['ConsultantBilling']['paid_amount'];
		    				$consultantArray[$i]['patient_id']=$service['ConsultantBilling']['patient_id'];
		    				$date=$this->DateFormat->formatDate2Local($service['ConsultantBilling']['date'],Configure::read('date_format'),false);
		    				$consultantArray[$i]['date']=$date;
		    				$i++;
		    				$encounterAmt=0;
		    				$total[Configure::read('Consultant')]=$total[Configure::read('Consultant')]+$service['ConsultantBilling']['amount'];
		    				$discount[Configure::read('Consultant')]=$discount[Configure::read('Consultant')]+$service['ConsultantBilling']['discount'];
		    				$paid[Configure::read('Consultant')]=$paid[Configure::read('Consultant')]+$service['ConsultantBilling']['paid_amount'];
		    			}
		    		}
		    	}
		    }
		    /*********************************************************************************************************************************/
		    /**
		     *Array of External  Consultant
		     *Patient id as 1st key consultantid as 2nd key and increamental key => details
		     */
		    
		    foreach ($externalConsultantData as $Ckey=>$cBilling){
		    	foreach($cBilling as $CBillKey=>$consultantBillingDta){
		    		foreach($consultantBillingDta as $conKey=>$consultantBilling){
		    			foreach($consultantBilling as $singleKey=>$service){
		    				$patientArray['patient_id']=$service['ConsultantBilling']['patient_id'];
		    				$encounterAmt=($service['ConsultantBilling']['amount'])-$service['ConsultantBilling']['paid_amount']-$service['ConsultantBilling']['discount'];
		    				if($encounterAmt<=0){
		    					$encounterAmt=0;
		    				}
		    				$patientArray['totalAmount']=$patientArray['totalAmount']+$encounterAmt;
		    				$consultantArray[$i]['table_id']=$service['ConsultantBilling']['id'];
		    				$consultantArray[$i]['doctor_id']=$service['ConsultantBilling']['consultant_id'];
		    				$consultantArray[$i]['name']=$service['TariffList']['name'].'('.$service['Consultant']['first_name'].' '.$service['Consultant']['last_name'].')';
		    				$consultantArray[$i]['tariff_list_id']=$service['TariffList']['id'];
		    				$consultantArray[$i]['cghs']=$service['TariffList']['cghs_code'];
		    				$consultantArray[$i]['amount']=$service['ConsultantBilling']['amount'];
		    				$consultantArray[$i]['discount']=$service['ConsultantBilling']['discount'];
		    				$consultantArray[$i]['paid_amount']=$service['ConsultantBilling']['paid_amount'];
		    				$consultantArray[$i]['patient_id']=$service['ConsultantBilling']['patient_id'];
		    				$date=$this->DateFormat->formatDate2Local($service['ConsultantBilling']['date'],Configure::read('date_format'),false);
		    				$consultantArray[$i]['date']=$date;
		    				$i++;
		    				$encounterAmt=0;
		    				$total[Configure::read('Consultant')]=$total[Configure::read('Consultant')]+$service['ConsultantBilling']['amount'];
		    				$discount[Configure::read('Consultant')]=$discount[Configure::read('Consultant')]+$service['ConsultantBilling']['discount'];
		    				$paid[Configure::read('Consultant')]=$paid[Configure::read('Consultant')]+$service['ConsultantBilling']['paid_amount'];
		    			}
		    		}
		    	}
		    }
		    /*******************************************************************************************************************************/
		    /**
		     *Array of servicebill services
		     *Patient id as 1st key service_id (radio button service category id) as 2nd key and increamental key => details
		     */
		    $i=1;
		    foreach($serviceBillData as $service){ 
		    	$patientArray['patient_id']=$service['ServiceBill']['patient_id'];
		    	$encounterAmt=($service['ServiceBill']['amount']*$service['ServiceBill']['no_of_times'])-$service['ServiceBill']['paid_amount']-$service['ServiceBill']['discount'];
		    	if($encounterAmt<=0){
		    		$encounterAmt=0;
		    	}
		    	$patientArray['totalAmount']=$patientArray['totalAmount']+$encounterAmt;
		    	if(strtolower($serviceCategory[$service['TariffList']['service_category_id']])==strtolower(Configure::read('surgeryservices'))){
		    		$service['ServiceBill']['service_id']=$service['TariffList']['service_category_id'];
		    	}else if (strtolower($serviceCategory[$service['TariffList']['service_category_id']])==strtolower('OPERATION THEATER CHARGE')){
		    		$service['ServiceBill']['service_id']=$service['TariffList']['service_category_id'];
		    	}
		    	$serviceArray[$serviceCategory[$service['ServiceBill']['service_id']]][$i]['table_id']=$service['ServiceBill']['id'];
		    	$serviceArray[$serviceCategory[$service['ServiceBill']['service_id']]][$i]['service_id']=$service['ServiceBill']['service_id'];
		    	$serviceArray[$serviceCategory[$service['ServiceBill']['service_id']]][$i]['name']=$service['TariffList']['name'];
		    	$serviceArray[$serviceCategory[$service['ServiceBill']['service_id']]][$i]['tariff_list_id']=$service['TariffList']['id'];
		    	$serviceArray[$serviceCategory[$service['ServiceBill']['service_id']]][$i]['cghs']=$service['TariffList']['cghs_code'];
		    	$serviceArray[$serviceCategory[$service['ServiceBill']['service_id']]][$i]['amount']=$service['ServiceBill']['amount'];
		    	$serviceArray[$serviceCategory[$service['ServiceBill']['service_id']]][$i]['no_of_times']=$service['ServiceBill']['no_of_times'];
		    	$serviceArray[$serviceCategory[$service['ServiceBill']['service_id']]][$i]['discount']=$service['ServiceBill']['discount'];
		    	$serviceArray[$serviceCategory[$service['ServiceBill']['service_id']]][$i]['paid_amount']=$service['ServiceBill']['paid_amount'];
		    	$serviceArray[$serviceCategory[$service['ServiceBill']['service_id']]][$i]['patient_id']=$service['ServiceBill']['patient_id'];
		    	$serviceCatData[$service['ServiceBill']['service_id']]=$service['ServiceBill']['amount'];
		    	$i++;
		    	$encounterAmt=0;
		    	$total[$serviceCategory[$service['ServiceBill']['service_id']]]=$total[$serviceCategory[$service['ServiceBill']['service_id']]]+$service['ServiceBill']['amount']*$service['ServiceBill']['no_of_times'];
		    	$discount[$serviceCategory[$service['ServiceBill']['service_id']]]=$discount[$serviceCategory[$service['ServiceBill']['service_id']]]+$service['ServiceBill']['discount'];
		    	$paid[$serviceCategory[$service['ServiceBill']['service_id']]]=$paid[$serviceCategory[$service['ServiceBill']['service_id']]]+$service['ServiceBill']['paid_amount'];
		    }
		    $this->set('serviceCatData',$serviceCatData);
		    /*****************************************************************************************************************************/
		    /**
		     *Array of laboratory services
		     *Patient id as 1st key , labid as 2nd key and increamental key => details
		    */
		    
		    foreach($labData as $service){
		    	$patientArray['patient_id']=$service['LaboratoryTestOrder']['patient_id'];
		    	$encounterAmt=($service['LaboratoryTestOrder']['amount'])-$service['LaboratoryTestOrder']['paid_amount']-$service['LaboratoryTestOrder']['discount'];
		    	if($encounterAmt<=0){
		    		$encounterAmt=0;
		    	}
		    	$patientArray['totalAmount']=$patientArray['totalAmount']+$encounterAmt;
		    	$labArray[$i]['table_id']=$service['LaboratoryTestOrder']['id'];
		    	$labArray[$i]['name']=$service['Laboratory']['name'];
		    	$labArray[$i]['laboratory_id']=$service['LaboratoryTestOrder']['laboratory_id'];
		    	$labArray[$i]['tariff_list_id']=$service['Laboratory']['tariff_list_id'];
		    	$labArray[$i]['cghs_code']=$service['TariffList']['cghs_code'];
		    	$labArray[$i]['amount']=$service['LaboratoryTestOrder']['amount'];
		    	$labArray[$i]['discount']=$service['LaboratoryTestOrder']['discount'];
		    	$labArray[$i]['paid_amount']=$service['LaboratoryTestOrder']['paid_amount'];
		    	$labArray[$i]['patient_id']=$service['LaboratoryTestOrder']['patient_id'];
		    	$i++;$encounterAmt=0;
		    	$total[Configure::read('laboratoryservices')]=$total[Configure::read('laboratoryservices')]+$service['LaboratoryTestOrder']['amount'];
		    	$discount[Configure::read('laboratoryservices')]=$discount[Configure::read('laboratoryservices')]+$service['LaboratoryTestOrder']['discount'];
		    	$paid[Configure::read('laboratoryservices')]=$paid[Configure::read('laboratoryservices')]+$service['LaboratoryTestOrder']['paid_amount'];
		    }
		    /********************************************************************************************************************************/
		    /**
		     *Array of Radiology services
		     *Patient id as 1st key,radiology_id as 2nd key and increamental key => details
		     */
		    
		    foreach($radData as $service){
		    	$patientArray['patient_id']=$service['RadiologyTestOrder']['patient_id'];
		    	$encounterAmt=($service['RadiologyTestOrder']['amount'])-$service['RadiologyTestOrder']['paid_amount']-$service['RadiologyTestOrder']['discount'];
		    	if($encounterAmt<=0){
		    		$encounterAmt=0;
		    	}
		    	$patientArray['totalAmount']=$patientArray['totalAmount']+$encounterAmt;
		    	$radArray[$i]['table_id']=$service['RadiologyTestOrder']['id'];
		    	$radArray[$i]['radiology_id']=$service['RadiologyTestOrder']['radiology_id'];
		    	$radArray[$i]['name']=$service['Radiology']['name'];
		    	$radArray[$i]['tariff_list_id']=$service['Radiology']['tariff_list_id'];
		    	$radArray[$i]['cghs_code']=$service['TariffList']['cghs_code'];
		    	$radArray[$i]['no_of_times']=$service['TariffList']['apply_in_a_day'];
		    	$radArray[$i]['amount']=$service['RadiologyTestOrder']['amount'];
		    	$radArray[$i]['discount']=$service['RadiologyTestOrder']['discount'];
		    	$radArray[$i]['paid_amount']=$service['RadiologyTestOrder']['paid_amount'];
		    	$radArray[$i]['patient_id']=$service['RadiologyTestOrder']['patient_id'];
		    	$i++;$encounterAmt=0;
		    	$total[Configure::read('radiologyservices')]=$total[Configure::read('radiologyservices')]+$service['RadiologyTestOrder']['amount'];
		    	$discount[Configure::read('radiologyservices')]=$discount[Configure::read('radiologyservices')]+$service['RadiologyTestOrder']['discount'];
		    	$paid[Configure::read('radiologyservices')]=$paid[Configure::read('radiologyservices')]+$service['RadiologyTestOrder']['paid_amount'];
		    }
		    
		    /********************************************************************************************************************************/
		    /**
		     * Room tariff data
		     * combined room charge encounterwise
		     * PatientId as 1st key , TariffList id as 2nd key=>details
		     */
		    foreach($wardserviceBillData as $service){
		    	$patientArray['patient_id']=$service['WardPatientService']['patient_id'];
		    	$encounterAmt=($service['WardPatientService']['amount'])-$service['WardPatientService']['paid_amount']-$service['WardPatientService']['discount'];
		    	if($encounterAmt<=0){
		    		$encounterAmt=0;
		    	}
		    	$patientArray['totalAmount']=$patientArray['totalAmount']+$encounterAmt;
		    	$wardArray[$service['WardPatientService']['id']]['table_id'][]=$service['WardPatientService']['id'];
		    	$wardArray[$service['WardPatientService']['id']]['name']=$service['TariffList']['name'];
		    	$wardArray[$service['WardPatientService']['id']]['tariff_list_id']=$service['TariffList']['id'];
		    	$wardArray[$service['WardPatientService']['id']]['cghs']=$service['TariffList']['cghs_code'];
		    	if(!$wardArray[$service['WardPatientService']['id']]['inTime'])
		    	$wardArray[$service['WardPatientService']['id']]['inTime']=$service['WardPatientService']['date'];
		    	$wardArray[$service['WardPatientService']['id']]['outTime']=$service['WardPatientService']['date'];		    	
		    	$wardArray[$service['WardPatientService']['id']]['amount']=$wardArray[$service['WardPatientService']['tariff_list_id']]['amount']+$service['WardPatientService']['amount'];
		    	$wardArray[$service['WardPatientService']['id']]['discount']=$wardArray[$service['WardPatientService']['tariff_list_id']]['discount']+$service['WardPatientService']['discount'];
		    	$wardArray[$service['WardPatientService']['id']]['paid_amount']=$wardArray[$service['WardPatientService']['tariff_list_id']]['paid_amount']+$service['WardPatientService']['paid_amount'];
		    	$wardArray[$service['WardPatientService']['id']]['patient_id']=$service['WardPatientService']['patient_id'];
		    	$total[Configure::read('RoomTariff')]=$total[Configure::read('RoomTariff')]+$service['WardPatientService']['amount'];
		    	$discount[Configure::read('RoomTariff')]=$discount[Configure::read('RoomTariff')]+$service['WardPatientService']['discount'];
		    	$paid[Configure::read('RoomTariff')]=$paid[Configure::read('RoomTariff')]+$service['WardPatientService']['paid_amount'];
		    	$encounterAmt=0;$i++;
		    }
		    
		   
		    
		    foreach($pharmacyData as $patKey=>$phar){
		    	$patientArray['patient_id']=$patKey;
		    		
		    	$totalPhar=$phar['total']-$phar['return'];
		    	$paidPhar=$phar['paid_amount']-$phar['returnPaid'];
		    	$discountPhar=$phar['discount']-$phar['returnDiscount'];
		    	$encounterAmt=$totalPhar-$paidPhar-$discountPhar;
		    	if($encounterAmt<=0){
		    		$encounterAmt=0;
		    	}
		    	$patientArray['totalAmount']=$patientArray['totalAmount']+$encounterAmt;
		    	//$pharArray['pharmacy']['table_id'][]=$service['WardPatientService']['id'];
		    	$pharArray['pharmacy']['name']='Pharmacy';
		    	//$pharArray['pharmacy']['tariff_list_id']=$service['TariffList']['id'];
		    	$pharArray['pharmacy']['amount']=$pharArray['pharmacy']['amount']+$totalPhar;
		    	$pharArray['pharmacy']['discount']=$pharArray['pharmacy']['discount']+$discountPhar;
		    	$pharArray['pharmacy']['paid_amount']=$pharArray['pharmacy']['paid_amount']+$paidPhar;
		    	$pharArray['pharmacy']['patient_id']=$patKey;	    	
		    	
		    	$encounterAmt=0;$i++;
		    	$total[Configure::read('Pharmacy')]=$total[Configure::read('Pharmacy')]+$totalPhar;
		    	$discount[Configure::read('Pharmacy')]=$discount[Configure::read('Pharmacy')]+$discountPhar;
		    	$paid[Configure::read('Pharmacy')]=$paid[Configure::read('Pharmacy')]+$paidPhar;
		    }
		    
		    foreach($otPharmacyData as $patKey=>$otPhar){
		    	$patientArray['patient_id']=$patKey;
		    
		    	$totalOtPhar=$otPhar['total']-$otPhar['return'];
		    	$paidOtPhar=$otPhar['paid_amount']-$otPhar['returnPaid'];
		    	$discountOtPhar=$otPhar['discount']-$otPhar['returnDiscount'];
		    	$encounterAmt=$totalOtPhar-$paidOtPhar-$discountOtPhar;
		    	if($encounterAmt<=0){
		    		$encounterAmt=0;
		    	}
		    	$patientArray['totalAmount']=$patientArray['totalAmount']+$encounterAmt;
		    	//$pharArray['pharmacy']['table_id'][]=$service['WardPatientService']['id'];
		    	$otpharArray['otpharmacy']['name']='Ot Pharmacy';
		    	//$pharArray['pharmacy']['tariff_list_id']=$service['TariffList']['id'];
		    	$otpharArray['otpharmacy']['amount']=$otpharArray['otpharmacy']['amount']+$totalOtPhar;
		    	$otpharArray['otpharmacy']['discount']=$otpharArray['otpharmacy']['discount']+$discountOtPhar;
		    	$otpharArray['otpharmacy']['paid_amount']=$otpharArray['otpharmacy']['paid_amount']+$paidOtPhar;
		    	$otpharArray['otpharmacy']['patient_id']=$patKey;
		    	$encounterAmt=0;$i++;
		    	$total[Configure::read('OtPharmacy')]=$total[Configure::read('OtPharmacy')]+$totalOtPhar;
		    	$discount[Configure::read('OtPharmacy')]=$discount[Configure::read('OtPharmacy')]+$discountOtPhar;
		    	$paid[Configure::read('OtPharmacy')]=$paid[Configure::read('OtPharmacy')]+$paidOtPhar;
		    }
		    /********************************************************************************************************************************/
		  /* $this->set(array('patientData'=>$patientData,'consultantArray'=>$consultantArray,'serviceArray'=>$serviceArray,
		    		'labArray'=>$labArray,'radArray'=>$radArray,'wardArray'=>$wardArray,'otpharArray'=>$otpharArray,'pharArray'=>$pharArray,
		    		'patientArray'=>$patientArray,'superbillData'=>$superbillData,
		    		'total'=>$total,'discount'=>$discount,'paid'=>$paid));*/
		   
		    $con= $this->ConsultClub($consultantArray);
		    
		    $surCount=1;
		   
		    foreach($surgeryData as $surgery){
		    	$surgeryArray['Surgery'][$surCount]['name']=$surgery['Surgery']['name'];
		    	$surgeryArray['Surgery'][$surCount]['cghs']=$surgery['TariffList']['cghs_code'];
		    	$surAmt=$surgery['OptAppointment']['ot_charges']+$surgery['OptAppointment']['surgery_cost']+$surgery['OptAppointment']['anaesthesia_cost'];
		    	$surgeryArray['Surgery'][$surCount]['amount']=$surAmt;
		    	if(!$surgeryArray['from'])
		    		$surgeryArray['from']=$this->DateFormat->formatDate2Local($surgery['OptAppointment']['starttime'],Configure::read('date_format'),false);
		    			$end=date('Y-m-d H:i:s',strtotime($surgery['OptAppointment']['starttime']." +".$surgery['TariffAmount']['unit_days']." days"));
		    	
		    	$surgeryArray['to']=$this->DateFormat->formatDate2Local($end,Configure::read('date_format'),false);
		    	
		    	if($superbillData['CorporateSuperBill']['patient_type']=='General'){
			    	if($surCount==1){
			    		$surgeryArray['Surgery'][$surCount]['tenPer']=$this->getPerCharge($surAmt,'10');
			    	}else{
			    		$fityAmt=$surgeryArray['Surgery'][$surCount]['fiftyPer']=$this->getPerCharge($surAmt,'50');
			    		$surgeryArray['Surgery'][$surCount]['tenPer']=$this->getPerCharge($fityAmt,'10');
			    		
			    	}
		    	}else if($superbillData['CorporateSuperBill']['patient_type']=='Semi-Special'){
			    	if($surCount==1){
			    		$surgeryArray['Surgery'][$surCount]['tenPer']=$this->getPerCharge($surAmt,'100');
			    	}else{
			    		$fityAmt=$surgeryArray['Surgery'][$surCount]['fiftyPer']=$this->getPerCharge($surAmt,'50');
			    		//$surgeryArray['Surgery'][$surCount]['tenPer']=$this->getPerCharge($fityAmt,'10');
			    		
			    	}
		    	}else if($superbillData['CorporateSuperBill']['patient_type']=='Special'){
			    	if($surCount==1){
			    		$surgeryArray['Surgery'][$surCount]['tenPer']=$this->getPerCharge($surAmt,'15');
			    	}else{
			    		$fityAmt=$surgeryArray['Surgery'][$surCount]['fiftyPer']=$this->getPerCharge($surAmt,'50');
			    		$surgeryArray['Surgery'][$surCount]['tenPer']=$this->getPerCharge($fityAmt,'15');
			    		
			    	}
		    	}	
		    	$surCount++;		    	
		    }
		   // debug($surgeryArray);exit;
   
		    $i=0;
		    foreach($conservative['Conservative'] as $key=>$cons){
		    	$date1 = new DateTime($cons['start']);
		    	$date2 = new DateTime($cons['end']);		    		
		    	$interval = $date1->diff($date2);
		    	$days[]=$interval->d+1;
		    	//$consCharges[$i]=$this->Patient->getConsCharges($patientIds,$interval->d+1);
		    	//$consCharges[$i]['start']=$this->DateFormat->formatDate2Local($cons['start'],Configure::read('date_format'),false);
		    	//$consCharges[$i]['end']=$this->DateFormat->formatDate2Local($cons['end'],Configure::read('date_format'),false);
		    	$conservative['Conservative'][$key]['days']=$interval->d+1;
		    	$i++;
		    	
		    }
		   
		  	return array('patientData'=>$patientData,'consultantArray'=>$con,'serviceArray'=>$serviceArray,'conservative'=>$conservative['Conservative'],
		    		'labArray'=>$labArray,'radArray'=>$radArray,'wardArray'=>$conservative['Ward'],'otpharArray'=>$otpharArray,'pharArray'=>$pharArray,
		    		'patientArray'=>$patientArray,'superbillData'=>$superbillData,'surgeryArray'=>$surgeryArray,'consCharges'=>$consCharges,'wardIcu'=>$conservative['wardIcu'],
		    		'total'=>$total,'discount'=>$discount,'paid'=>$paid,'tariffStdData'=>$tariffStdData,'serviceCategory'=>$serviceCategory,'billBo'=>$billBo,
		  		   	'wardAmt'=>$wardcharge,'surgeryArray'=>$surgeryArray) ;
		   
		   
			$this->set('tariffStdData',$tariffStdData);
			$this->set('serviceCategory',$serviceCategory);
		}
		
		/*if(strtolower($corporate)=='cghs'){
			$this->layout=false;
			$this->render('cghs_xls');
		}else if(strtolower($corporate)=='ongc'){
			$this->layout=false;
			$this->render('ongc_xls');			
		}else if(strtolower($corporate)=='reliance'){
			$this->layout=false;
			$this->render('ril_xls');
		}else if(strtolower($corporate)=='heavy water plant'){
			$this->layout=false;
			$this->render('heavy_water_plant_xls');
		}else if(strtolower($corporate)=='maa yojna'){
			$this->layout=false;
			$this->render('maa_yojna_xls');
		}else if(strtolower($corporate)=='iocl'){
			$this->layout=false;
			$this->render('iocl_xls');
		}else if(strtolower($corporate)=='esic'){
			$this->layout=false;
			$this->render('esic_xls');
		}else{
			$this->layout=false;
			//$this->render('cghs_xls');			
			
		}*/
		
	}
	
	public function getExcel($patientId){
		$this->autoRender = false ;
		$this->uses = array('Patient');
			
		$this->PhpExcel->createWorksheet()->setDefaultFont('Times New Roman', 12); //to set the font and size
	
		// Create a first sheet, representing Product data
		$this->PhpExcel->setActiveSheetIndex(0);
		$this->PhpExcel->getActiveSheet()->setTitle('CGHS BILL');	//to set the worksheet title
	
		//$patientId='1';


		$data=$this->companyExcelReport($patientId);
		 

		$admisionDate= $this->DateFormat->formatDate2Local($data['tariffStdData']['Patient']['form_received_on'],Configure::read('date_format'),false);
		$dischargeDate= $this->DateFormat->formatDate2Local($data['tariffStdData']['Patient']['discharge_date'],Configure::read('date_format'),false);
		
		$this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getFont()->setBold(true);
		$this->PhpExcel->addTableRow(array("","","CGHS BILL","","",""));
		$this->PhpExcel->addTableRow(array("","BILL NO",$data['billBo'],"","",""));
		$this->PhpExcel->addTableRow(array("","REGISTRATION NO",$data['tariffStdData']['Patient']['admission_id'],"","",""));
		$this->PhpExcel->addTableRow(array("","PATIENT NAME",strtoupper($data['tariffStdData']['Patient']['lookup_name']),"","",""));
		$this->PhpExcel->addTableRow(array("","AGE",$data['tariffStdData']['Patient']['age'],"","",""));
		$this->PhpExcel->addTableRow(array("","SEX",strtoupper($data['tariffStdData']['Patient']['sex']),"","",""));
		$this->PhpExcel->addTableRow(array("","NAME OF CGHS BENEFICIARY",$data['tariffStdData']['Patient']['name_of_ip'],"","",""));
		$this->PhpExcel->addTableRow(array("","RELATION WITH CGHS BENEFICIARY",$data['tariffStdData']['Patient']['relation_to_employee'],"","",""));
		$this->PhpExcel->addTableRow(array("","DATE OF ADMISSION",$admisionDate,"","",""));
		$this->PhpExcel->addTableRow(array("","DATE OF DISCHARGE",$dischargeDate,"","",""));
		$this->PhpExcel->addTableRow(array("","","","","",""));
		
	
		// define table cells
		$productsHead = array(
				array('label' => __('Sr.no'), 'filter' => true),
				array('label' => __('ITEM'), 'filter' => true,'width' => 50, 'wrap' => true),
				array('label' => __('CGHS NABH CODE No.')),
				array('label' => __('CGHS NABH RATE')),
				array('label' => __('QTY')),
				array('label' => __('AMOUNT'))
		);
	
		// add heading with different font and bold text
		$this->PhpExcel->addTableHeader($productsHead, array('name' => 'Cambria', 'bold' => true));
	
		// for align header text center
		$this->PhpExcel->getActiveSheet()->getStyle('A11:F11')->getAlignment()->applyFromArray(
				array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'rotation'   => 0,
						'wrap'       => false
				)
		);

		
		$this->PhpExcel->getActiveSheet()->getStyle("A".$this->PhpExcel->_row)->getFont()->setBold(true);
		$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getFont()->setBold(true);
		$this->PhpExcel->addTableRow(array("","Conservative Treatment","","","",""));
		foreach($data['conservative'] as $cons){
			$start=$this->DateFormat->formatDate2Local($cons['start'],Configure::read('date_format'),false);
			$end=$this->DateFormat->formatDate2Local($cons['end'],Configure::read('date_format'),false);
			$this->PhpExcel->getActiveSheet()->getStyle('B'.$this->PhpExcel->_row)->getAlignment()->applyFromArray(
					array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
							'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							'rotation'   => 0,
							'wrap'       => false
					));
			$this->PhpExcel->addTableRow(array("","(".$start." To ".$end." )","","","",""));			
		}
		
		$this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
				array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'rotation'   => 0,
						'wrap'       => false
				)
		);
		$count = 1;//debug($data);exit;
		// BOF  Consultation For Inpatient
		if($data['consultantArray']){
			$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getFont()->setBold(true);
			$this->PhpExcel->addTableRow(array($count,"Consultation for Inpatient","2","","",""));
			$count=$count+1;
			foreach($data['consultantArray'] as $consultKey =>$consultVal){
				$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getFont()->setBold(true);
				$this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
						array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
								'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
								'rotation'   => 0,
								'wrap'       => false
						)
				);
				$this->PhpExcel->addTableRow(array("","Consultation for inpatients","2","","",""));
				$this->PhpExcel->addTableRow(array("",$consultVal['name'],"","",""));
				$this->PhpExcel->getActiveSheet()->getStyle('B'.$this->PhpExcel->_row)->getAlignment()->applyFromArray(
						array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
								'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
								'rotation'   => 0,
								'wrap'       => false
						)
				);
				$this->PhpExcel->addTableRow(array("","Dt ".$consultVal['from']." to ".$consultVal['to'],"",$consultVal['rate'],$consultVal['no_of_times'],$consultVal['amount']));
	
			}
		}
		// EOF Consultation For Inpatient
		// BOF Accomodation For Ward
		if($data['wardArray']){
			$this->PhpExcel->addTableRow(array("","","","","",""));
			$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getFont()->setBold(true);
			
			foreach($data['wardArray'] as $wardKey =>$wardVal){
				if($wardVal['name']){
					$this->PhpExcel->addTableRow(array($count,"Accomodation For ".$data['wardAmt']['wardName']. " Ward" ,"","","",""));
					foreach($data['conservative'] as $conKey =>$conVal){
						$this->PhpExcel->getActiveSheet()->getStyle('B'.$this->PhpExcel->_row)->getAlignment()->applyFromArray(
								array(
										'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
										'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
										'rotation'   => 0,
										'wrap'       => false
								)
						);
						$wardAmt=$data['wardAmt']['amount']*$conVal['days'];
						$start=$this->DateFormat->formatDate2Local($conVal['start'],Configure::read('date_format'),false);
						$end=$this->DateFormat->formatDate2Local($conVal['end'],Configure::read('date_format'),false);
						$this->PhpExcel->addTableRow(array("","Dt ".$start." to ".$end,"",$data['wardAmt']['amount'],$conVal['days'],$wardAmt));
					}
				}
			}
			if($data['wardIcu'])
				$count=$count+1;
			foreach($data['wardIcu'] as $wardKey =>$wardVal){
					$this->PhpExcel->addTableRow(array($count,"Accomodation For ".$wardVal['name'],"","","",""));
						$this->PhpExcel->getActiveSheet()->getStyle('B'.$this->PhpExcel->_row)->getAlignment()->applyFromArray(
								array(
										'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
										'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
										'rotation'   => 0,
										'wrap'       => false
								)
						);
						$wardAmt=$wardVal['amount']*$wardVal['days'];
						$start=$this->DateFormat->formatDate2Local($wardVal['start'],Configure::read('date_format'),false);
						$end=$this->DateFormat->formatDate2Local($wardVal['end'],Configure::read('date_format'),false);
						$this->PhpExcel->addTableRow(array("","Dt ".$start." to ".$end,"",$wardVal['amount'],$wardVal['days'],$wardAmt));
							
			}
			$count=$count+1;
		}
		// EOF Accomodation For Ward
		if($data['consCharges']){
			foreach($data['consCharges'] as $docNurse){
				$perDayDoc=0;$perDayNurse=0;
				$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getFont()->setBold(true);
				$this->PhpExcel->addTableRow(array($count,"Doctor Charges","","","",""));
				$perDayDoc=$docNurse['Doctor']['amount']/$docNurse['days'];
				$this->PhpExcel->getActiveSheet()->getStyle('B'.$this->PhpExcel->_row)->getAlignment()->applyFromArray(
						array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
								'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
								'rotation'   => 0,
								'wrap'       => false
						)
				);
				$this->PhpExcel->addTableRow(array("","Dt ".$docNurse['start']." to ".$docNurse['end'],"",$perDayDoc,$docNurse['days'],$docNurse['Doctor']['amount']));	
				$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getFont()->setBold(true);
				$this->PhpExcel->addTableRow(array("","Nurse Charges","","","",""));
				$perDayDoc=$docNurse['Nurse']['amount']/$docNurse['days'];
				$this->PhpExcel->getActiveSheet()->getStyle('B'.$this->PhpExcel->_row)->getAlignment()->applyFromArray(
						array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
								'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
								'rotation'   => 0,
								'wrap'       => false
						)
				);
				$this->PhpExcel->addTableRow(array("","Dt ".$docNurse['start']." to ".$docNurse['end'],"",$perDayDoc,$docNurse['days'],$docNurse['Nurse']['amount']));
				$count++;
			}
		}
		
		// BOF Pathology
		if($data['total']['Laboratory']){
			$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getFont()->setBold(true);
			$this->PhpExcel->addTableRow(array($count,"Pathology","",$data['total']['Laboratory'],"1",$data['total']['Laboratory']));
			$count=$count+1;
			foreach($data['conservative'] as $cons){
				$start=$this->DateFormat->formatDate2Local($cons['start'],Configure::read('date_format'),false);
				$end=$this->DateFormat->formatDate2Local($cons['end'],Configure::read('date_format'),false);
				$this->PhpExcel->getActiveSheet()->getStyle('B'.$this->PhpExcel->_row)->getAlignment()->applyFromArray(
						array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
								'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
								'rotation'   => 0,
								'wrap'       => false
						));
				$this->PhpExcel->addTableRow(array("","Dt ".$start." To ".$end,"","","",""));
			}
			$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getFont()->setBold(true);
			$this->PhpExcel->addTableRow(array("","Note:Attached Pathology Break-up","","","",""));
		}
		// EOF Pathology
		
		//BOF Medicene
		if($data['total']['Pharmacy']){
			$this->PhpExcel->addTableRow(array("","","","","",""));
			$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getFont()->setBold(true);
			$this->PhpExcel->addTableRow(array($count,"Medicine","",$data['total']['Pharmacy'],"1",$data['total']['Pharmacy']));
			
			foreach($data['conservative'] as $cons){
				$start=$this->DateFormat->formatDate2Local($cons['start'],Configure::read('date_format'),false);
				$end=$this->DateFormat->formatDate2Local($cons['end'],Configure::read('date_format'),false);
				$this->PhpExcel->getActiveSheet()->getStyle('B'.$this->PhpExcel->_row)->getAlignment()->applyFromArray(
						array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
								'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
								'rotation'   => 0,
								'wrap'       => false
						));
				$this->PhpExcel->addTableRow(array("","Dt ".$start." To ".$end,"","","",""));
			}
			$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getFont()->setBold(true);
			$this->PhpExcel->addTableRow(array("","Note:Attached Pharmacy Statement with Bills","","","",""));
			$count=$count+1;
		}
		// EOF Medicene
		
		// BOF Services
		if($data['serviceArray']){
			foreach($data['serviceArray'] as $serClubKey=>$serClubVal){
				foreach($serClubVal as $keyName => $val){
					$resetArray[$serClubKey][$val['tariff_list_id']][] = $val ;
				}
			}
			$returnArray=array();
			foreach($resetArray[$serClubKey] as $key =>$value){
				foreach($value as $retKey=>$retVal){
			
					$returnArray[$key]['name']=$retVal['name'];
					$returnArray[$key]['rate']=$retVal['amount'];
					$returnArray[$key]['no_of_times']+= $retVal['no_of_times'];
					$returnArray[$key]['amount']+=$retVal['amount']*$retVal['no_of_times'];
					$returnArray[$key]['cghs_code']=$retVal['cghs'];
			
						
				}
			
			}
			foreach($returnArray as $serviceKey =>$serviceVal){				
				$this->PhpExcel->addTableRow(array("","","","","",""));
				$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getFont()->setBold(true);
				$this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
						array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
								'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
								'rotation'   => 0,
								'wrap'       => false
						)
				);
				$serviceTotal=$serviceVal['rate']*$serviceVal['no_of_times'];
				$this->PhpExcel->addTableRow(array($count,$serviceVal['name'],$serviceVal['cghs_code'],$serviceVal['rate'],$serviceVal['no_of_times'],$serviceTotal));
				$count++;
			}
		}
		
		//exit;
		// EOF Services
		
		// BOF Radiology 
		if($data['radArray']){
			foreach($data['radArray'] as $radKey =>$radVal){
				$this->PhpExcel->addTableRow(array("","","","","",""));
				$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getFont()->setBold(true);
				$this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getAlignment()->applyFromArray(
						array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
								'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
								'rotation'   => 0,
								'wrap'       => false
						)
				);
				$this->PhpExcel->addTableRow(array($count,$radVal['name'],$radVal['cghs_code'],$radVal['amount'],$radVal['no_of_times'],$radVal['amount']*$radVal['no_of_times']));
				$count++;
				
			}
		}
		// EOF Radiology
		
		// BOF Surgery 
		  
		if($data['surgeryArray']['from']){
			$this->PhpExcel->addTableRow(array("","","","","",""));
			$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getFont()->setBold(true);
			$this->PhpExcel->addTableRow(array(""," Surgical Treatment( ". $data['surgeryArray']['from']." To ".$data['surgeryArray'][to] .")","","","",""));
			$serialCharArray=array('a)','b)','c)','d)','e)','f)','g)','h)','i)');
			foreach($data['surgeryArray'] as $surKey =>$surVal){
				 
				foreach($surVal as $key=>$surgery){
					if($data['superbillData']['CorporateSuperBill']['patient_type']=='General'){
						if($key==1){				
							$this->PhpExcel->addTableRow(array($count,$serialCharArray[$key-1]." ".$surgery['name'],$surgery['cghs'],$surgery['amount'],"",""));
							$dedAmt=$surgery['amount']-$surgery['tenPer'];
							$this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getFont()->setBold(true);
							$this->PhpExcel->addTableRow(array("",""," 10% Less as per CGHS Guideline",$surgery['tenPer'],"1",$dedAmt));
						}else{
							$this->PhpExcel->addTableRow(array("",$serialCharArray[$key-1]." ".$surgery['name'],$surgery['cghs'],$surgery['amount'],"",""));
							$this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getFont()->setBold(true);
							$this->PhpExcel->addTableRow(array("",""," 50% Less as per CGHS Guideline",$surgery['fiftyPer'],"",""));
							$this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getFont()->setBold(true);
							$dedAmt=$surgery['amount']-$surgery['fiftyPer']-$surgery['tenPer'];
							$this->PhpExcel->addTableRow(array("",""," 10% Less as per CGHS Guideline",$surgery['tenPer'],"1",$dedAmt));
							
						}
					}else if($data['superbillData']['CorporateSuperBill']['patient_type']=='Semi-Special'){
						if($key==1){				
							$this->PhpExcel->addTableRow(array($count,$serialCharArray[$key-1]." ".$surgery['name'],$surgery['cghs'],$surgery['amount'],"",""));
						}else{
							$this->PhpExcel->addTableRow(array("",$serialCharArray[$key-1]." ".$surgery['name'],$surgery['cghs'],$surgery['amount'],"",""));
							$this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getFont()->setBold(true);
							$dedAmt=$surgery['amount']-$surgery['fiftyPer'];
							$this->PhpExcel->addTableRow(array("",""," 50% Less as per CGHS Guideline",$surgery['fiftyPer'],"1",$dedAmt));								
						}
					}else if($data['superbillData']['CorporateSuperBill']['patient_type']=='Special'){
						if($key==1){				
							$this->PhpExcel->addTableRow(array($count,$serialCharArray[$key-1]." ".$surgery['name'],$surgery['cghs'],$surgery['amount'],"",""));
							$dedAmt=$surgery['amount']+$surgery['tenPer'];
							$this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getFont()->setBold(true);
							$this->PhpExcel->addTableRow(array("",""," 15% more as per CGHS Guideline",$surgery['tenPer'],"1",$dedAmt));
						}else{
							$this->PhpExcel->addTableRow(array("",$serialCharArray[$key-1]." ".$surgery['name'],$surgery['cghs'],$surgery['amount'],"",""));
							$this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getFont()->setBold(true);
							$this->PhpExcel->addTableRow(array("",""," 50% Less as per CGHS Guideline",$surgery['fiftyPer'],"",""));
							$this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getFont()->setBold(true);
							$dedAmt=$surgery['amount']-$surgery['fiftyPer']+$surgery['tenPer'];
							$this->PhpExcel->addTableRow(array("",""," 15% Less as per CGHS Guideline",$surgery['tenPer'],"1",$dedAmt));
							
						}
					}
					$count++;
				}
			}
			
			 
	
			$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getFont()->setBold(true);
			$this->PhpExcel->addTableRow(array("","Operated On dt.".$data['surgeryArray']['from'],"","","",""));
		}
		$this->PhpExcel->addTableRow(array("","","","","",""));
		$totalAmount="=SUM(F1:F".$this->PhpExcel->_row.")";
		$countRow= $this->PhpExcel->_row+1;
		$totalCellBlock="F".$countRow;
		$totalTextBlock="B".$countRow;
		
		$this->PhpExcel->getActiveSheet()->getStyle($totalCellBlock)->getFont()->setBold(true);
		$this->PhpExcel->getActiveSheet()->getStyle($totalTextBlock)->getFont()->setBold(true);
		$this->PhpExcel->getActiveSheet()->setCellValue($totalTextBlock,"TOTAL BILL AMOUNT" );
		$this->PhpExcel->getActiveSheet()->setCellValue($totalCellBlock,$totalAmount );
		

		// close table and output
		$this->PhpExcel->addTableFooter()->output('CGHS BILL');	//Store Location List (file name)
	}
	
	/**
	 * For clubing consultant data
	 * @param unknown_type $consultArray
	 * @return unknown
	 * Pooja Gupta
	 */
	function ConsultClub($consultArray){
	
		foreach($consultArray as $ckey=>$consult){
			
			$conSult[$consult['doctor_id']]['name']=$consult['name'];
			if(!$conSult[$consult['doctor_id']]['from'])
				$conSult[$consult['doctor_id']]['from']=$consult['date'];
			$conSult[$consult['doctor_id']]['tariff_list_id']=$consult['tariff_list_id'];
			$conSult[$consult['doctor_id']]['cghs']=$consult['cghs'];
			$conSult[$consult['doctor_id']]['rate']=$consult['amount'];
			$conSult[$consult['doctor_id']]['no_of_times']=$conSult[$consult['doctor_id']]['no_of_times']+$consult['no_of_times'];
			$conSult[$consult['doctor_id']]['amount']=$conSult[$consult['doctor_id']]['amount']+$consult['amount'];
			$conSult[$consult['doctor_id']]['discount']=$conSult[$consult['doctor_id']]['discount']+$consult['discount'];
			$conSult[$consult['doctor_id']]['paid_amount']=$conSult[$consult['doctor_id']]['paid_amount']+$consult['paid_amount'];
			$conSult[$consult['doctor_id']]['patient_id']=$consult['patient_id'];
			$conSult[$consult['doctor_id']]['to']=$consult['date'];
		}
		return $conSult;
	}
	
	/**
	 * Function to calculate pecentage amount incresed or decrease for surgery
	 * @param unknown_type $amount
	 * @param unknown_type $per
	 * @param unknown_type $inc
	 * @param unknown_type $dec
	 * @return number
	 * Pooja Gupta
	 */
	public function getPerCharge($amount,$per){
		$charge=($amount*$per)/100;		
		return $charge;
	}
	
	
	
}
?>