<?php
class Configuration extends AppModel {

	public $name = 'Configuration';

	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds)){
			$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
		}else{
			$this->db_name =  $ds;
		}
		parent::__construct($id, $table, $ds);
	}
	
	
	
	/**
	 *function for  pharmacy service type
	 *By Yashwant
	 *@Return array of pharmacy service configuration
	 */
	public function getPharmacyServiceType(){
		$session  =  new CakeSession();
		$pharmacyLabel = Configure::read('pharmacyservices') ;
		$pharmacy_service_type=$this->find('first',array('conditions'=>array('Configuration.name'=>$pharmacyLabel,'Configuration.location_id'=>$session->read('locationid'))));
		$pharmConfig=unserialize($pharmacy_service_type['Configuration']['value']);
		return $pharmConfig;
	}

	
	/**
	 *function for getting instance nabe
	 *By Yashwant
	 *@Return instance name
	 */
	public function getInstance(){
		$website_service_type=$this->find('first',array('conditions'=>array('Configuration.name'=>'website')));
		$websiteConfig=unserialize($website_service_type['Configuration']['value']);
		return $websiteConfig;
	}
	
	/**
	 * function to add and update shifts
	 * @author Gaurav Chauriya
	 */
	public function setDutyShift($data = array()){
		$session  =  new CakeSession();
		$data['location_id'] = $session->read('locationid');
		$data['name'] = Configure::read('shifts');
		$data['value'] = serialize($data['value']);
		$this->save($data);
	}
	
	
	/**
	 *function for  pharmacy service type
	 *By Yashwant
	 *@Return array of pharmacy service configuration
	 */
	public function getPharmacyServiceTypeHope(){
		$session  =  new CakeSession();
		$pharmacyLabel = Configure::read('pharmacyservices') ;
		$pharmacy_service_type=$this->find('first',array('conditions'=>array('Configuration.name'=>$pharmacyLabel,
				'Configuration.location_id'=>$session->read('locationid'))));
		$pharmConfig=unserialize($pharmacy_service_type['Configuration']['value']);
		//array reset yes,no
		if($pharmConfig['addChargesInInvoice']=='yes'){
		   $pharmConfig['addChargesInInvoice']='no';
		   $pharmConfig['cashCounter']='no';
		}else{
		   $pharmConfig['addChargesInInvoice']='yes';
		   $pharmConfig['cashCounter']='yes';
		}
		
		
		//serialize
		$pharmacyConfig=serialize($pharmConfig);
		//save
		$this->updateAll(array('value' => "'".$pharmacyConfig."'"),array('name'=>$pharmacyLabel));
	}

	/**
	 * function to get sms trigger as a true or false 
	 * @author Mahalaxmi
	 */
	public function getConfigSmsValue($smsType=null,$flagSessionOff){
		$session  =  new CakeSession();
		if($flagSessionOff){
			$getEnableFeatureChk=true;
		}else{
			$getEnableFeatureChk=$session->read('sms_feature_chk');
		}
		//$getEnableFeatureChk=true;
		if($getEnableFeatureChk){
			$data=$this->find('first',array('fields'=>array('value'),'conditions'=>array('category'=>2,'name'=>Configure::read('sms_configuration_name'))));
			$getUnserializeSmsData=unserialize($data['Configuration']['value']);
			$smsActive=false;
			if(in_array($smsType,$getUnserializeSmsData)){
				$smsActive=true;
			}
		}
		return $smsActive;
	}
	/**
	 * function to return leave types list
	 * @return Ambigous <multitype:, NULL, mixed> list of leave types
	 * pooja
	 */
	public function getLeaveTypeList(){
		$leaveList=$this->find('first',array('conditions'=>array('name'=>'leave type')));
		$leaves=unserialize($leaveList['Configuration']['value']);
		return $leaves;
	}
	/*
	 * function to return the public holidays of current month
	* @return (date with holiday)
	* @author : Swapnil
	* @created : 06.03.2016
	*/
	public function getPublicHolidays($year=null,$month=null,$day=null){
		$holidayData = $this->find('first',array(
				'fields'=>array('value'),
				'conditions'=>array('name'=>"Holiday")));
		$holiday = unserialize($holidayData['Configuration']['value']);
		if(!empty($year) && !empty($month) && !empty($day)){
			return $holiday[$year][$month][$day];
		}
		if(!empty($year) && !empty($month)){
			return $holiday[$year][$month];
		}
		if(!empty($year)){
			return $holiday[$year];
		}else{
			return $holiday;
		}
	}
	
}
 
?>