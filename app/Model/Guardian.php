<?php
/*
 * Model : guardian
 * Use : guardian
 * @created by :Aditya V. Chitmtiwar
 * @created on :09 Sept 2013
 * functions : insert Detials of guardian
 * 
 * 
 */

class Guardian extends AppModel {

	public $name = 'Guardian';

	public $cacheQueries = false ;


	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
	function insertguardian($data =array(),$action='insert',$id){
		$this->uses=array('guardian');
		$session     = new cakeSession();
		$userid 	 = $session->read('userid') ;
		$locationId  = $session->read('locationid') ;
		$dateFormat = ClassRegistry::init('DateFormatComponent');			 
		$this->create();
		$efdate = $dateFormat->formatDate2STD($data['Person']['guar_eff_date_add'],Configure::read('date_format'));
		$enddate = $dateFormat->formatDate2STD($data['Person']['guar_end_date_add'],Configure::read('date_format'));
		$this->saveAll(array('guar_initial_id'=>$data['Person']['guar_initial_id'],'guar_first_name'=>$data['Person']['guar_first_name'],
				'guar_middle_name'=>$data['Person']['guar_middle_name'],
				'guar_last_name'=>$data['Person']['guar_last_name'],
				'guar_name_type'=>$data['Person']['guar_name_type'],
				'guar_suffix'=>$data['Person']['guar_suffix'],
				'guar_sex'=>$data['Person']['guar_sex'],
				'guar_relation'=>$data['Person']['guar_relation'],
				'guar_address1'=>$data['Person']['guar_address1'],
				'guar_address2'=>$data['Person']['guar_address2'],
				'guar_address_type'=>$data['Person']['guar_address_type'],
				'guar_city'=>$data['Person']['guar_city'],
				'guar_state'=>$data['Person']['guar_state'],
				'guar_country'=>$data['Person']['guar_country'],
				'guar_address_type'=>$data['Person']['guar_address_type'],
				'guar_county'=>$data['Person']['guar_county'],
				'guar_zip'=>$data['Person']['guar_zip'],
				'guar_tele_code'=>$data['Person']['guar_tele_code'],
				'guar_equi_code'=>$data['Person']['guar_equi_code'],
				'guar_phone'=>$data['Person']['guar_phone'],
				'guar_mobile'=>$data['Person']['guar_mobile'],
				'guar_email'=>$data['Person']['guar_email'],
				'guar_country_code'=>$data['Person']['guar_country_code'],
				'guar_area_code'=>$data['Person']['guar_area_code'],
				'guar_localno'=>$data['Person']['guar_localno'],
				'guar_extension'=>$data['Person']['guar_extension'],
				'guar_text1'=>$data['Person']['guar_text1'],
				'guar_tele_code1'=>$data['Person']['guar_tele_code1'],
				'guar_equi_code1'=>$data['Person']['guar_equi_code1'],
				'guar_email1'=>$data['Person']['guar_email1'],
				'guar_text2'=>$data['Person']['guar_text2'],
				'guar_company_name'=>$data['Person']['guar_company_name'],
				'ckeckguardian_patient_portal'=>$data['Person']['ckeckguardian_patient_portal'],
				'guar_eff_date_add'=>$efdate,
				'guar_end_date_add'=>$enddate,
				
				'guar_primary_chk'=>$data['Person']['guar_primary_chk'],
				'guar_parish_code_first'=>$data['Person']['guar_parish_code_first'],
				'person_id' =>$id));
		 
		///return($latest_insert_id);
	
	}
	
}
?>