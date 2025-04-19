<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class VentilatorCheckList extends AppModel {

	public $specific = true;
	public $name = 'VentilatorCheckList';
	var $useTable = 'ventilator_check_lists';
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
		
	function insertCheckList($data= array()){
		
		$session = new cakeSession();
		$dateFormat  = new DateFormatComponent();
		$data['VentilatorCheckList']['location_id'] = $session->read('locationid');
		if(empty($data['VentilatorCheckList']['id'])){
			$data['VentilatorCheckList']['created_by'] = $session->read('userid');
			$data['VentilatorCheckList']['create_time'] = date("Y-m-d H:i:s");
			$data['VentilatorCheckList']['created_by'] = $session->read('userid');
			$data['VentilatorCheckList']['create_time'] = date("Y-m-d H:i:s");
		}else{
			$this->id = $data['VentilatorCheckList']['id'] ;
			$data['VentilatorCheckList']['modified_by'] = $session->read('userid');
			$data['VentilatorCheckList']['modify_time'] = date("Y-m-d H:i:s");
			$data['VentilatorCheckList']['modified_by'] = $session->read('userid');
			$data['VentilatorCheckList']['modify_time'] = date("Y-m-d H:i:s");
		}
		        
		$data['VentilatorCheckList']['vent_setting']= $data['VentilatorCheckList']['vent_setting'].'-'.$data['VentilatorCheckList']['vent_setting_period'];
		$data['VentilatorCheckList']['vent_management']= $data['VentilatorCheckList']['vent_management'].'-'.$data['VentilatorCheckList']['vent_management_period'];
		$data['VentilatorCheckList']['vte_prophylaxis']= $data['VentilatorCheckList']['vte_prophylaxis'].'-'.$data['VentilatorCheckList']['vte_prophylaxis_period'];
		$data['VentilatorCheckList']['gi_proph']= $data['VentilatorCheckList']['gi_proph'].'-'.$data['VentilatorCheckList']['gi_proph_period'];
		$data['VentilatorCheckList']['oral_care']= $data['VentilatorCheckList']['oral_care'].'-'.$data['VentilatorCheckList']['oral_care_period'];
		$data['VentilatorCheckList']['hob']= $data['VentilatorCheckList']['hob'].'-'.$data['VentilatorCheckList']['hob_period'];
		
		$data['VentilatorCheckList']['ventilator_date'] = $dateFormat->formatDate2STD($data['VentilatorCheckList']['ventilator_date'],Configure::read('date_format_us'));
		$data['VentilatorCheckList']['consult_name']= implode(',',$data['VentilatorCheckList']['consult_name']);
		
		$data['VentilatorCheckList']['pud_prophaxis']= implode(',',$data['VentilatorCheckList']['pud_prophaxis']);
		$data['VentilatorCheckList']['pud_prophaxis'] = trim($data['VentilatorCheckList']['pud_prophaxis'], ",");
		if(isset($data['VentilatorCheckList']['sedation'][1])){
			$data['VentilatorCheckList']['sedation'][1] = "Midazolam ".$data['VentilatorCheckList']['sedation_vol']." mg IV q 30 min prn for agitation";
		}
		$data['VentilatorCheckList']['sedation']= implode(',',$data['VentilatorCheckList']['sedation']);
		if(isset($data['VentilatorCheckList']['analgesia'][1])){
			$data['VentilatorCheckList']['analgesia'][1] = "Morphine infusion:loading dose ".$data['VentilatorCheckList']['analgesia_dose']." mg IV then:Infusion Rate ".$data['VentilatorCheckList']['analgesia_rate']." mg/hr";
		}
		$data['VentilatorCheckList']['analgesia']= implode(',',$data['VentilatorCheckList']['analgesia']);
		$data['VentilatorCheckList']['dvt_prophaxis']= implode(',',$data['VentilatorCheckList']['dvt_prophaxis']);
		$this->save($data['VentilatorCheckList']);
		
		
	}
	
	function retrieveCheckList($patient_id,$id,$ventChkid){
		
		$dateFormat  = new DateFormatComponent();
		$User = ClassRegistry::init('User');
		if(empty($id)){
			$list_data=$this->find('all',array('conditions'=>array('patient_id'=>$patient_id,'is_deleted'=>0),'order' => array('id' => 'DESC')));
		}else{
		$list_data=$this->find('all',array('conditions'=>array('patient_id'=>$patient_id,'id'=>$ventChkid,'is_deleted'=>0)));
		}
		$list_data[0]['VentilatorCheckList']['ventilator_date'] =  $dateFormat->formatDate2Local($list_data[0]['VentilatorCheckList']['ventilator_date'],Configure::read('date_format_us'));
		$list_data[0]['VentilatorCheckList']['consult_name'] = explode(',',$list_data[0]['VentilatorCheckList']['consult_name']);
		
		$consultants = $User->getDoctorByID($list_data[0]['VentilatorCheckList']['consult_name']);
		
		for($i = 0;$i<count($consultants);$i++){
			$list_data[0]['VentilatorCheckList']['consult_name'][$i]= $consultants[$i][0]['fullname'];
			
		}
		$list_data[0]['VentilatorCheckList']['consult_name'] = implode(',',$list_data[0]['VentilatorCheckList']['consult_name']);
		$list_data[0]['VentilatorCheckList']['consult_name'] = str_replace(',',' & ',$list_data[0]['VentilatorCheckList']['consult_name']);
		
		$list_data[0]['VentilatorCheckList']['sedation'] = explode(',',$list_data[0]['VentilatorCheckList']['sedation']);
		foreach($list_data[0]['VentilatorCheckList']['sedation'] as $key=>$value){
			if($value == '0')
			{
				unset($list_data[0]['VentilatorCheckList']['sedation'][$key]);
			}
		}
		$list_data[0]['VentilatorCheckList']['sedation'] = array_values($list_data[0]['VentilatorCheckList']['sedation']);
		$list_data[0]['VentilatorCheckList']['analgesia'] = explode(',',$list_data[0]['VentilatorCheckList']['analgesia']);
		foreach($list_data[0]['VentilatorCheckList']['analgesia'] as $key=>$value){
			if($value == '0')
			{
				unset($list_data[0]['VentilatorCheckList']['analgesia'][$key]);
			}
		}
		$list_data[0]['VentilatorCheckList']['analgesia'] = array_values($list_data[0]['VentilatorCheckList']['analgesia']);
		$list_data[0]['VentilatorCheckList']['dvt_prophaxis'] = explode(',',$list_data[0]['VentilatorCheckList']['dvt_prophaxis']);
		foreach($list_data[0]['VentilatorCheckList']['dvt_prophaxis'] as $key=>$value){
			if($value == '0')
			{
				unset($list_data[0]['VentilatorCheckList']['dvt_prophaxis'][$key]);
			}
		}
		$list_data[0]['VentilatorCheckList']['dvt_prophaxis'] = array_values($list_data[0]['VentilatorCheckList']['dvt_prophaxis']);
		
		if($list_data[0]['VentilatorCheckList']['pud_prophaxis'][0] == '0'){
			
			$list_data[0]['VentilatorCheckList']['pud_prophaxis']= substr($list_data[0]['VentilatorCheckList']['pud_prophaxis'],2);
		}
		$list_data[0]['VentilatorCheckList']['pud_prophaxis'] = str_replace(',',' & ',$list_data[0]['VentilatorCheckList']['pud_prophaxis']);
		
		
		
		return $list_data[0]['VentilatorCheckList'];
	}

}
?>