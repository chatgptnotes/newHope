<?php
App::uses('AppModel', 'Model');

class Contract extends AppModel {
	
	public $name = 'Contract';
	public $useTable = 'contracts'; 
	
  	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
    
    public function CreateContract($data = array())
    {
    	$session = new cakeSession();
    	
		$data['Contract']['start_date'] = DateFormatComponent::formatDate2STD($data["Contract"]["start_date"],Configure::read('date_format'));
		$data['Contract']['end_date'] = DateFormatComponent::formatDate2STD($data["Contract"]["end_date"],Configure::read('date_format'));
    	$data['Contract']['created_by'] = $session->read('userid');
		$data['Contract']['modified_by'] = $session->read('userid');
    	$data['Contract']['location_id'] = $session->read('locationid');
		$data['Contract']['create_time'] = date("Y-m-d H:i:s");
    	$data['Contract']['modify_time'] = date("Y-m-d H:i:s");
		
		$contract_type = $data['Contract']['contract_type'];
		$table_fields = array('','enterprise_id','company_id','faciity_id','department_id');
		$field = $table_fields[$contract_type];
		
		$data['Contract'][$field] = 1;
		//debug($name);
		//debug($type);
		if($this->save($data))
		{
			return $this->getLastInsertId();
		}
		//debug($data);
    	
    }
    
       
}
?>