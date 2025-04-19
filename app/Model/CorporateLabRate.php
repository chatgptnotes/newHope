<?php
class CorporateLabRate extends AppModel {

	public $name = 'CorporateLabRate';
	 public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    } 
	function insertLabRate($data=array()){
		$session = new cakeSession();
    	   
		foreach($data['CorporateLabRate'] as $subArr){	
			 
			if(empty($subArr['non_nabh_rate'])){
				$subArr['non_nabh_rate'] = 0; 
			}
			if(empty($subArr['nabh_rate'])){
				$subArr['nabh_rate'] = 0; 
			}
			$subArr['location_id'] = $session->read('locationid');
			$subArr['created_by'] = $session->read('userid');
			$subArr['create_time'] = date("Y-m-d H:i:s");			 				 
			$result   = $this->save($subArr);
			$this->id ='';
		}				
		return $result ; 		
	}	
}
?>