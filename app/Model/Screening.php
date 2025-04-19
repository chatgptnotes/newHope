<?php
class Screening extends AppModel {

	public $name = 'Screening';
	
 	  public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
    
    function insertdata($data=null)
    {
		$session = new CakeSession();
		if(!empty($data["Screening"]["id"]))
		{
			$this->Screening->id = $data["Screening"]["id"];
		}
			$data["Screening"]["created_time"] = date("Y-m-d H:i:s");
	        $data["Screening"]["modified_time"] = date("Y-m-d H:i:s");
	        $data["Screening"]["created_by"] =  $session->read('userid');
	        $data["Screening"]["modified_by"] = $session->read('userid'); 
	        $data["Screening"]["location_id"] = $session->read('locationid');
        $this->save($data);
	} 		
	
    
}
?>