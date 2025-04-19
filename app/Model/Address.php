<?php
class Address extends AppModel {

	public $name = 'Address';
        		
	public $cacheQueries = false ;
	
	
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
   
    function insertAddress($user,$data,$person_id) 
    {	
    	$address = ClassRegistry::init('Address');
    	$size = count($data['plot_no']);
    	$address->deleteAll(array('Address.address_type_id' => $person_id), false);
    	for($x=$size-1;$x>=0;$x--)
    	{
	    	if(!empty($data['plot_no'][$x])){
	    		$resetData['Address'][$x]['address_type'] = $user;
	    		$resetData['Address'][$x]['address_type_id'] =  $person_id;
	    		$resetData['Address'][$x]['plot_no'] =  $data['plot_no'][$x];
	    		$resetData['Address'][$x]['landmark']=  $data['landmark'][$x];
	    		$resetData['Address'][$x]['city']= $data['city'][$x];
	    		$resetData['Address'][$x]['state']= $data['state'][$x];
	    		$resetData['Address'][$x]['pin_code']=$data['pin_code'][$x];
	    		$resetData['Address'][$x]['country']=  $data['country'][$x];
	    		$resetData['Address'][$x]['person_local_number']= $data['person_local_number'][$x];
	    		$resetData['Address'][$x]['person_email_address']= $data['person_email_address'][$x];
	    		$resetData['Address'][$x]['person_lindline_no']=$data['person_lindline_no'][$x];
	    		$resetData['Address'][$x]['person_extension']=  $data['person_extension'][$x];
	    		$resetData['Address'][$x]['no_number']=$data['no_number'][$x];
	    		$resetData['Address'][$x]['no_email']=  $data['no_email'][$x];
	    	}
    	}
    	$address->saveAll($resetData['Address']);
    }
}
?>