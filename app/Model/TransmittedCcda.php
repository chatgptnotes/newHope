<?php
class TransmittedCcda extends AppModel {

	public $useTable = 'transmitted_ccda';
	public $name = 'TransmittedCcda';
	public $specific = true;
	//public $actsAs = array('Cipher' => array('autoDecypt' => true,'cipher'=>array('message','type')));

	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	function insertTransmittedCcda($data=array()){
		$dateFormat  = new DateFormatComponent();
		$session = new cakeSession();
		if(!empty($data['XmlNote']['referral_date'])){
			$data['XmlNote']['referral_date']= $dateFormat->formatDate2STD(trim($data['XmlNote']['referral_date']),Configure::read('date_format_us')) ;
		} 
		$data['XmlNote']['location_id'] = $session->read('locationid');
		$data['XmlNote']['created_by'] = $session->read('userid');
	 	$data['XmlNote']['address_type'] = $data['TransmittedCcda']['address_type'];
		if($data['id']){
			$data['XmlNote']['updated_on'] = date('Y-m-d H:i:s');
		}else{
			$data['XmlNote']['created_on'] = date('Y-m-d H:i:s');
		}
		$this->save($data['XmlNote']);
	}
}