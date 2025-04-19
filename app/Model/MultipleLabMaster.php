<?php
class MultipleLabMaster extends AppModel {

	public $name = 'MultipleLabMaster';
	
	
	/* public $validate = array(
	
			'title' => array(
					'isUnique' => array (
							'rule' => array('checkUniqueTitle'),
							'on' => 'create',
							'message' => 'Tilte name must be unique.'
					)
			)
	);
	
	function checkUniqueTitle() {
		$session = new cakeSession();
		return ($this->find('count', array('conditions' => array('MultipleLabMaster.title' => $this->data['MultipleLabMaster']['title'],"MultipleLabMaster.location_id" => $session->read('locationid')))) ==0);
	} */
	
 	  public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
    
    function insertdata($data=null)
    {
		$session = new CakeSession();
		//debug($data);
		if(!empty($data["MultipleLabMaster"]["id"]))
		{
			$this->MultipleLabMaster->id = $data["MultipleLabMaster"]["id"];
		}
			$data["MultipleLabMaster"]["created_time"] = date("Y-m-d H:i:s");
	        $data["MultipleLabMaster"]["modified_time"] = date("Y-m-d H:i:s");
	        $data["MultipleLabMaster"]["created_by"] =  $session->read('userid');
	        $data["MultipleLabMaster"]["modified_by"] = $session->read('userid'); 
	        $data["MultipleLabMaster"]["location_id"] = $session->read('locationid');
        $this->save($data);
	} 		
}
?>