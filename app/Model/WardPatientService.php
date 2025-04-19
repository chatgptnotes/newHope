<?php
/**
 * Service model
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Bed Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj  wanjari
 * @functions 	 : insertService(insert/update service data).	
 */
class WardPatientService extends AppModel {
	
	public $name = 'WardPatientService';
	public $validate = array(
	            'date' => array(
				'rule' => "notEmpty",
				'message' => "Please enter date.",
	            'on'=>'create'
				),
				 'patient_id' => array(
				'rule' => "notEmpty",
				'message' => "Please select patient."
				),				
			);
	
    public $specific = true;
    public $hospitalType = '';
	function __construct($id = false, $table = null, $ds = null) {
       if(empty($ds)){
        	$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	 	}else{
	 		$this->db_name =  $ds;
	 	}
		parent::__construct($id, $table, $ds);
    }      
 

	//function to return ward charges from ward patient service table 
	function getWardCharges($patient_id){
		//return false ;
		App::import('Component','General');
		$generalComponent = new GeneralComponent( new ComponentCollection());
		$packageDetails = $generalComponent->getPackageNameAndCost($patient_id);
		if($packageDetails)
			$endDate = strtotime(date('Y-m-d',strtotime($packageDetails['endDate'])));
		$this->bindModel(array('belongsTo'=>array(
			'TariffList'=>array('foreignKey'=>false,'conditions'=>array('WardPatientService.tariff_list_id=TariffList.id')),
			'Ward'=>array('foreignKey'=>false,'conditions'=>array('WardPatientService.ward_id=Ward.id')))));

		$patientWardUnits =$this->find('all',array('fields'=>array('Ward.name','WardPatientService.*'),
				'conditions'=>array('WardPatientService.patient_id'=>$patient_id,'WardPatientService.is_deleted'=>'0'),'order'=>array('WardPatientService.date'),
			'group'=>array('WardPatientService.id')));  
		//reset array as to match older version  of ward charing array 
		foreach($patientWardUnits as $key =>$value){	
			if(strtotime($value['WardPatientService']['date']) < $endDate && $packageDetails)
				continue;/** avoid calculating ward charges for package Days --Gaurav*/
			$newWardChargesArray[] = array('in'=>$value['WardPatientService']['date'],
				'out'=>$value['WardPatientService']['date'],
				'cost'=>$value['WardPatientService']['amount'],
				'ward'=>$value['Ward']['name'],
				'ward_id'=>$value['WardPatientService']['ward_id'],
				'paid_amount'=>$value['WardPatientService']['paid_amount'],
				'doctor_paid_amount'=>$value['WardPatientService']['doctor_paid_amount'],
				'nurse_paid_amount'=>$value['WardPatientService']['nurse_paid_amount'],
				'discount'=>$value['WardPatientService']['discount'],
				'nurse_discount'=>$value['WardPatientService']['nurse_discount'],
				'doctor_discount'=>$value['WardPatientService']['doctor_discount']); 
		}  
		return array('day'=>$newWardChargesArray) ;
	}

	//post ward charges for the time after regsitration  by pankaj w.
	function postWardCharges($patient_id=null,$tariffStandardID=null,$ward_id=null){ 
		$wardPatientObj = ClassRegistry::init('WardPatient');
		$tariffStandardObj = ClassRegistry::init('TariffStandard');
		$session= new CakeSession();
		$locationId = $session->read('locationid');
		$wardPatientObj->bindModel(array(
				'belongsTo' => array(
						'Ward' =>array('foreignKey' => 'ward_id'),
						'TariffAmount' =>array('foreignKey' => false,
								'conditions'=>array('Ward.tariff_list_id=TariffAmount.tariff_list_id',
										'TariffAmount.tariff_standard_id'=>$tariffStandardID)),
						'TariffList'=>array('foreignKey' => false,'conditions'=>array('TariffAmount.tariff_list_id=TariffList.id'))
				)),false);

		$wardData = $wardPatientObj->find('first',array('group'=>array('WardPatient.id'),
				'conditions'=>array('patient_id'=>$patient_id,'WardPatient.is_deleted'=>"0"),
				'fields'=>array('TariffList.id','TariffList.service_category_id','TariffAmount.nabh_charges','TariffAmount.non_nabh_charges',
						'WardPatient.in_date','WardPatient.out_date'))); 
		$hospitalType = $session->read('hospitaltype') ;
		$this->hospitalType = $session->read('hospitaltype');
		if($hospitalType=='NABH'){
			$wardRate=$wardData['TariffAmount']['nabh_charges'];
		}else{
			$wardRate=$wardData['TariffAmount']['non_nabh_charges'];
		} 
		if($wardData){
			/**
			 * *******************************************************
			 */
			// check if patient is corporate post their charges according to class from admission data
			$patientCorporateClassCharges = false;
			if ($tariffStandardID != 7) { // if patient is not private
				$patientCorporateClassCharges = $this->getCorporateClassWard ( $patient_id, $ward_id );
			}
			/**
			 * ******************************************************
			 */
			$insertArray = array(
								'date'=>$wardData['WardPatient']['in_date'],
								'location_id'=>$locationId,
								'tariff_standard_id'=>$tariffStandardID,//no need to add this
								'create_time'=>date('Y-m-d H:i:s'),
								'created_by'=>2,//as system user
								'patient_id'=>$patient_id,
								'tariff_list_id'=>$wardData['TariffList']['id'],
								'ward_id'=>$ward_id,
								'amount'=>($patientCorporateClassCharges)?$patientCorporateClassCharges:$wardRate,
								'service_id'=>$wardData['TariffList']['service_category_id']); //service group id
 
			$this->save($insertArray);
		} 
	}

	//function to change ward tariff and amount after changinf tariff from patient edit
	function updateWardCharges($patient_id=null,$tariffStandardID=null){
		$wardObj = ClassRegistry::init('Ward');
		$session= new CakeSession();
		$wardPatientData = $this->find('list',array('fields'=>array('id','ward_id'),'conditions'=>array('is_deleted'=>0,'patient_id'=>$patient_id)));
		$wardObj->bindModel(array(
				'belongsTo' => array( 
						'TariffAmount' =>array('foreignKey' => false,
								'conditions'=>array('Ward.tariff_list_id=TariffAmount.tariff_list_id',
										'TariffAmount.tariff_standard_id'=>$tariffStandardID)) 
				)),false);
		$wardData = $wardObj->find('all',array('group'=>array('Ward.id'),
				'conditions'=>array('Ward.id'=>$wardPatientData),
				'fields'=>array('TariffAmount.nabh_charges','TariffAmount.non_nabh_charges','Ward.id'))); 
		$hospitalType = $session->read('hospitaltype') ;
		if($hospitalType=='NABH'){
			$wardRateField = 'nabh_charges' ;
		}else{
			$wardRateField ='non_nabh_charges';
		} 
		foreach($wardData as $wardKey =>$wardValue){ 
			$wardServiceCost = ($wardValue['TariffAmount'][$wardRateField])?$wardValue['TariffAmount'][$wardRateField]:0 ;
			$this->updateAll(array('amount'=>$wardServiceCost,
				'modified_time'=>"'".date('Y-m-d H:i:s')."'",
				'modified_by'=>$session->read('userid')),array('patient_id'=>$patient_id,'ward_id'=>$wardValue['Ward']['id']));
			$this->id='';
		}  
	}//by pankaj to update ward charges after tariff change 
	
	//BOF for sum of paid amount and discount amount, return patient wise service name by amit jain
	function getServiceWiseCharges($patientId=null,$date=null){
		$session     = new cakeSession();
		if(!$patientId) return false ;
		$this->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array('foreignKey' => false,'conditions'=>array('WardPatientService.tariff_list_id=TariffList.id')),
						'ServiceCategory' =>array('foreignKey' => false,'conditions'=>array('WardPatientService.service_id=ServiceCategory.id')))),false);
		$amountDetails = $this->find(all,array('conditions'=>array('WardPatientService.is_deleted'=>'0','WardPatientService.location_id'=>$session->read('locationid'),
				'WardPatientService.patient_id'=>$patientId,'WardPatientService.paid_amount NOT'=>'0','DATE_FORMAT(WardPatientService.date,"%Y-%m-%d")'=>$date),
				'fields'=>array('WardPatientService.paid_amount','WardPatientService.discount','TariffList.name','ServiceCategory.name')));
		return $amountDetails ;
	}
	//EOF
	//BOF return doctor charges and nursing charges by amit jain
	function getMandatoryDoctorCharges($patientId=null,$date=null){
		$session     = new cakeSession();
		if(!$patientId) return false ;
		$serviceCategoryObj = ClassRegistry::init('ServiceCategory');
		$serviceId = $serviceCategoryObj->getServiceGroupId('mandatoryservices',$session->read('locationid'));
		$this->bindModel(array(
				'belongsTo' => array(
						'ServiceCategory' =>array('foreignKey' => false,'conditions'=>array('ServiceCategory.id'=>$serviceId)))),false);
		$amountDetails = $this->find(all,array('conditions'=>array('WardPatientService.is_deleted'=>'0','WardPatientService.location_id'=>$session->read('locationid'),
				'WardPatientService.patient_id'=>$patientId,'WardPatientService.doctor_paid_amount NOT'=>'0','DATE_FORMAT(WardPatientService.date,"%Y-%m-%d")'=>$date),
				'fields'=>array('SUM(WardPatientService.doctor_paid_amount) as TotalDoctorAmount','SUM(WardPatientService.doctor_discount) as TotalDoctorDiscount','ServiceCategory.name')));
		return $amountDetails ;
	}
	//EOF
	//BOF return doctor charges and nursing charges by amit jain
	function getMandatoryNurseCharges($patientId=null,$date=null){
		$session     = new cakeSession();
		if(!$patientId) return false ;
		$serviceCategoryObj = ClassRegistry::init('ServiceCategory');
		$serviceId = $serviceCategoryObj->getServiceGroupId('mandatoryservices',$session->read('locationid'));
		$this->bindModel(array(
				'belongsTo' => array(
						'ServiceCategory' =>array('foreignKey' => false,'conditions'=>array('ServiceCategory.id'=>$serviceId)))),false);
		$amountDetails = $this->find(all,array('conditions'=>array('WardPatientService.is_deleted'=>'0','WardPatientService.location_id'=>$session->read('locationid'),
				'WardPatientService.patient_id'=>$patientId,'WardPatientService.nurse_paid_amount NOT'=>'0','DATE_FORMAT(WardPatientService.date,"%Y-%m-%d")'=>$date),
				'fields'=>array('SUM(WardPatientService.nurse_paid_amount) as TotalNurseAmount','SUM(WardPatientService.nurse_discount) as TotalNurseDiscount','ServiceCategory.name')));
		return $amountDetails ;
	}
	//EOF
	
	//post first day ward charges for vadodara instance after bed allocation
	function postWardChargeForVadodara($data=array()){		
		//********************************************************************************
			$session = new cakeSession() ; 
			$wardObj = ClassRegistry::init('Ward');
			$roomObj = ClassRegistry::init('Room');
			$wardPatientServiceData = ClassRegistry::init('WardPatientService');
			$tariffListObj = ClassRegistry::init('TariffList') ;
			$serviceCategory = ClassRegistry::init('ServiceCategory') ;  
			$wardData = $wardObj->find('first',array('conditions'=>array('Ward.id'=>$data['ward_id'])));
			$roomObj  = $roomObj->find('first',array('conditions'=>array('Room.id'=>$data['room_id'])));
			 
			$tariffListObj->bindModel(array(
					'belongsTo' => array(
							'TariffAmount'=>array('foreignKey' => false,'conditions'=>array('TariffList.id=TariffAmount.tariff_list_id',
									'TariffAmount.tariff_standard_id='.$data['tariff_standard_id'])),
							'TariffAmountType'=>array('foreignKey' => false,'conditions'=>array('TariffList.id=TariffAmountType.tariff_list_id',
									'TariffAmountType.tariff_standard_id='.$data['tariff_standard_id'])),
							'ServiceCategory'=>array('foreignKey' => false,'type'=>'LEFT','conditions'=>array('TariffList.service_category_id=ServiceCategory.id'
					 ))
					)),false);
		
			$services = $tariffListObj->find('first',array('fields'=>array('TariffList.name','TariffList.service_category_id','TariffList.id','TariffAmount.nabh_charges',
					'TariffAmount.non_nabh_charges','TariffAmountType.*','ServiceCategory.name','ServiceCategory.service_type'),'conditions'=>array('TariffList.id'=>$wardData['Ward']['tariff_list_id']),
					 ));
			
			$hospitalType = $session->read('hospitaltype');
			if($hospitalType == 'NABH'){
				$nursingServiceCostType = 'nabh_charges';
			}else{
				$nursingServiceCostType = 'non_nabh_charges';
			}
			 
			$patientRoomType  = $roomObj['Room']['room_type']."_ward_charge" ; //for database field name
			 
			if($services['TariffAmountType'][$patientRoomType] != ''){
				 $charges = $services['TariffAmountType'][$patientRoomType] ;
			}else{
				$charges = $services['TariffAmount'][$nursingServiceCostType] ; 
			}
			
			$wardSplittedDate = explode(" ",DateFormatComponent::formatDate2STD($data['date'],Configure::read('date_format')));
			$isRecExistForDay = $wardPatientServiceData->find('first',array('fields'=>array('WardPatientService.id'),
					'conditions'=>array('WardPatientService.patient_id'=>$data['patient_id']
							,'DATE_FORMAT(WardPatientService.date,"%Y-%m-%d")'=>$wardSplittedDate[0])));
			
			 
			 
			$insertArray = array(
					'id'=>$isRecExistForDay['WardPatientService']['id'],
					'date'=>DateFormatComponent::formatDate2STD($data['date'],Configure::read('date_format')),
					'location_id'=>$session->read('locationid'),
					'tariff_standard_id'=>$data['tariff_standard_id'],//no need to add this
					'create_time'=>date('Y-m-d H:i:s'),
					'created_by'=>2,//as system user
					'patient_id'=>$data['patient_id'],
					'tariff_list_id'=>$wardData['Ward']['tariff_list_id'],
					'ward_id'=>$data['ward_id'],
					'room_id'=>$data['room_id'],
					'amount'=>$charges,
					'service_id'=>$serviceCategory->getServiceGroupId('roomtariffGroup')); //service group id
		 
			$wardPatientServiceData->save($insertArray);
		//**********************************************************************************
	}
	
	/**
	 * Function getWardServices
	 * All services of according to the conditions such as all services of specific patient_id
	 * @param unknown_type $superBillId
	 * @param unknown_type $tariffStandardId
	 * @return multitype:
	 * Pooja Gupta
	 */
	public function getWardServices($condition=array(),$superBillId=NULL){
	
		if($superBillId){//For Super Bill
			$this->bindModel(array(
					'belongsTo' => array(
							'Ward'=>array( 'foreignKey'=>false,'type'=>'INNER','conditions'=>array('Ward.id=WardPatientService.ward_id')),
							'TariffList' =>array( 'foreignKey'=>false,'type'=>'INNER','conditions'=>array('Ward.tariff_list_id=TariffList.id')),
							//'CorporateSuperBill'=>array('foreignKey'=>false,'type'=>'INNER','conditions'=>array('WardPatientService.corporate_super_bill_id=CorporateSuperBill.id'))
					)),false);
	
			//$condition['WardPatientService.corporate_super_bill_id']=$superBillId;
			$condition['OR']=array('WardPatientService.paid_amount <='=>'0','WardPatientService.paid_amount'=>NULL);
		}else{
			$this->bindModel(array(
					'belongsTo' => array(
							'Ward'=>array( 'foreignKey'=>false,'type'=>'INNER','conditions'=>array('Ward.id=WardPatientService.ward_id')),
							'TariffList' =>array( 'foreignKey'=>false,'type'=>'INNER','conditions'=>array('Ward.tariff_list_id=TariffList.id')),
					)),false);
		}
		
	
		$wardArray=$this->find('all',array('fields'=>array('WardPatientService.id','WardPatientService.date','WardPatientService.patient_id','WardPatientService.amount',
				'WardPatientService.paid_amount','WardPatientService.discount','WardPatientService.corporate_super_bill_id',
				'WardPatientService.create_time',
				'TariffList.id','TariffList.name','TariffList.cghs_code','Ward.name'),
				'conditions'=>array('WardPatientService.is_deleted'=>'0',$condition),
				'order'=>array('WardPatientService.date asc')));
		return $wardArray;
	
	}
	
	public function wardServicesUpdate($serviceData,$encId,$catKey,$billId,$percent,$modified){
		$session = new cakeSession();
		$modified_by=$session->read('userid');
		foreach($serviceData as $serviceKey=>$eachData){
			$singleServiceData='';
			$singleServiceData=$this->find('all',
					array('fields'=>array('WardPatientService.id','WardPatientService.amount',
							'WardPatientService.paid_amount','WardPatientService.discount'),
							'conditions'=>array('WardPatientService.patient_id'=>$encId,
									'OR'=>array(array("WardPatientService.paid_amount"=>'0'),
											array("WardPatientService.paid_amount"=>NULL)))));
	
			foreach($singleServiceData as $ward){
				$amtToPay=0;$serDiscount=0;$serpaid=0;$balAmt=0;
					
				$billTariffId[$catKey][]=$ward['WardPatientService']['id']; //tariff_list_id serialize array
	
				$balAmt=$ward['WardPatientService']['amount']-$ward['WardPatientService']['paid_amount']-$ward['WardPatientService']['discount'];
					
				$amtToPay=($balAmt*$percent)/100;
	
				$serpaid=$amtToPay+$ward['WardPatientService']['paid_amount'];
	
				$serDiscount=$ward['WardPatientService']['amount']-($serpaid);
	
				$this->updateAll(
						array('WardPatientService.paid_amount'=>"'$serpaid'",
								'WardPatientService.discount'=>"'$serDiscount'",
								'WardPatientService.billing_id'=>"'$billId'",
								'WardPatientService.modified_by'=>"'$modified_by'",
								'WardPatientService.modified_time'=>"'$modified'"),
						array('WardPatientService.id'=>$ward['WardPatientService']['id'],
								'WardPatientService.patient_id'=>$encId)
				);
			}
				
		}
		return $billTariffId;
	}
	
	public function getWardTypeCharges($wardName,$tariffStandard){
		$session = new cakeSession();
		$tariffListObj=ClassRegistry::init('TariffList');
		$tariffListObj->bindModel(array(
				'belongsTo'=>array(
						'Ward'=>array('foreignKey'=>false,'type'=>'Inner',
						'conditions'=>array('Ward.tariff_list_id=TariffList.id')),
				'TariffAmount'=>array('foreignKey'=>false,'type'=>'Inner',
						'conditions'=>array('TariffAmount.tariff_list_id=TariffList.id')),
				
				)));
		
		$wardCharge=$tariffListObj->find('first',array('fields'=>array('TariffAmount.tariff_standard_id',
				'TariffAmount.nabh_charges','TariffAmount.non_nabh_charges'),'conditions'=>array('Ward.name like'=>'%'.$wardName.'%',
				'TariffAmount.tariff_standard_id'=>$tariffStandard)));
		$hospital=$session->read('hospitaltype');
		if($hospital=='NABH'){
			$wardAmt=$wardCharge['TariffAmount']['nabh_charges'];
		}else{
			$wardAmt=$wardCharge['TariffAmount']['non_nabh_charges'];
		}
		return $wardAmt; 
		
	}
	
	
	
	//function to post corporate class wise charges 
	// function to check if patient has any class assigned or not
	function getCorporateClassWard($patient_id = null, $ward_id = null) {
		if (! $patient_id || ! $ward_id)
			return false;
			$patientModel = ClassRegistry::init('Patient');
			$wardModel = ClassRegistry::init('Ward');
			$tariffAmountModel = ClassRegistry::init('TariffAmount');
			$checkIsICU = $wardModel->find ( 'first', array (
					'fields',
					array (
							'conditions' => array (
									'Ward.id' => $ward_id
							)
					)
			) );
			if ($checkIsICU ['Ward'] ['ward_type'] == 'ICU')
				return false; // no need change for icu ward
				$patientData = $patientModel->find ( 'first', array (
						'fields' => array (
								'Patient.corporate_status',
								'Patient.tariff_standard_id'
						),
						'conditions' => array (
								'Patient.id' => $patient_id
						)
				) );
				$statusArray = Configure::read ( 'corporateStatus' );
				 
				$patientStatus = $statusArray [$patientData ['Patient'] ['corporate_status']];
				if ($patientData ['Patient'] ['corporate_status']) {
					$wardList = $wardModel->getAvailableWards();
					switch ($patientStatus) {
						case 'General' :
							$searchword = 'General';
							break;
						case 'Shared' :
							$searchword = 'Sharing';
							break;
						case 'Special' :
							$searchword = 'Special';
							break;
					}
					$classWard = '';
					foreach ( $wardList as $key => $value ) { // iterate over ward data				 
						if (strpos($value, $searchword) !== false ) {
							$classWard = $key;
							break; // that's it
						}
					}
					if (! $classWard)
						return false; // for any other case return false
						$wardModel->bindModel ( array (
								'belongsTo' => array (
										'TariffAmount' => array (
												'foreignKey' => false,
												'conditions' => array (
														'Ward.tariff_list_id=TariffAmount.tariff_list_id',
														'TariffAmount.tariff_standard_id' => $patientData ['Patient'] ['tariff_standard_id']
												)
										)
								)
						), false );
						$classCharges = $wardModel->find ('first',array('conditions'=>array('Ward.id'=>$classWard),'fields'=>array('TariffAmount.nabh_charges','TariffAmount.non_nabh_charges')));
						 
						if($this->hospitalType=='NABH'){
							return $classCharges['TariffAmount']['nabh_charges'] ;
						}else{
							return $classCharges['TariffAmount']['non_nabh_charges'] ;
						}
				} else {
					return false; // continue with basic flow
				}
	}
}
	

?>
 