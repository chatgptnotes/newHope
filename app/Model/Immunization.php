<?php
class Immunization extends AppModel {

	public $useTable = 'imunizations';
	public $name = 'Immunization';
	public $specific = true;
	
	function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }

    function insertImmunization($data=array()){
    	$dateFormat  = new DateFormatComponent();
    	$session = new cakeSession();
    	 
    	if(!empty($data['create_time'])){
    		$data['create_time']= $dateFormat->formatDate2STD($data['date'],Configure::read('date_format')) ;
    	}
    	$data['location_id'] = $session->read('locationid');
    	if($data['id']){
    		$data['modify_time'] = date('Y-m-d H:i:s');
    		$data['modified_by'] = $session->read('userid');
    	}else{
    		$data['create_time'] = date('Y-m-d H:i:s');
    		$data['created_by'] = $session->read('userid');
    	}
    	if($data['amount'] == 999) $data['amount'] = '';

    	$this->saveAll($data);
    }
    
    function updateImmunization($patient_id,$id,$editData){
    	//print_r($editData);//exit;
    	//print_r($id);
    	
    	if($editData['Immunization']['id']){
    		//print_r($editData);exit;
    		$this->id=$editData['Immunization']['id'] ;
    		$this->data['Immunization']['id'] =$editData['Immunization']['id'] ;
    		$this->data["Immunization"]['patient_id']  = $editData['Immunization']['patient_id'] ;
    		$this->data["Immunization"]['vaccine_type']  = $editData['Immunization']['vaccine_type'];
    		$this->data["Immunization"]['date']  = $editData['Immunization']['date'];
    		$this->data["Immunization"]['expiry_date']  = $editData['Immunization']['expiry_date'];
    		$this->data["Immunization"]['phvs_unitofmeasure_id']  = $editData['Immunization']['phvs_unitofmeasure_id'] ;
    		$this->data["Immunization"]['route']  =$editData['Immunization']['route'];
    		$this->data["Immunization"]['manufacture_name']  = $editData['Immunization']['manufacture_name'];
    		$this->data["Immunization"]['admin_site']  = $editData['Immunization']['admin_site'];
    		//sponsor details
    		$this->data["Immunization"]['admin_note']  = $editData['Immunization']['admin_note'];
    		
    		$this->data["Immunization"]['amount']  = $editData['Immunization']['amount'];
    		$this->data["Immunization"]['lot_number']  = $editData['Immunization']['lot_number'];
    		$this->data["Immunization"]['provider']  = $editData['Immunization']['provider'];
    		$this->data["Immunization"]['reason']  = $editData['Immunization']['reason'];
    		
    		$this->data["Immunization"]['registry_status']  = $editData['Immunization']['registry_status'];
    		$this->data["Immunization"]['publicity_code']  = $editData['Immunization']['publicity_code'];
    		$this->data["Immunization"]['protection_indicator']  = $editData['Immunization']['protection_indicator'];
    		$this->data["Immunization"]['indicator_date']  = $editData['Immunization']['indicator_date'];
    		$this->data["Immunization"]['publicity_date']  = $editData['Immunization']['publicity_date'];
    		
    		$this->data["Immunization"]['registry_status_date']  = $editData['Immunization']['registry_status_date'];
    		$this->data["Immunization"]['funding_category']  = $editData['Immunization']['funding_category'];
    		$this->data["Immunization"]['published_date']  = $editData['Immunization']['published_date'];
    		$this->data["Immunization"]['observation_date']  = $editData['Immunization']['observation_date'];
    		$this->data["Immunization"]['observation_method']  = $editData['Immunization']['observation_method'];
    		$this->data["Immunization"]['observation_value']  = $editData['Immunization']['observation_value'];
    		$this->data["Immunization"]['vaccin_single_code']  = $editData['Immunization']['vaccin_single_code'];
    		//debug($this->data);exit;
    		$this->save($data);
    	}//print_r($editData);exit;
    }

}