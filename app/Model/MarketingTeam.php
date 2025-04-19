<?php
App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property ManufacturerCompany $ManufacturerCompany
*/
class MarketingTeam extends AppModel {

	public $specific = true; 
	public $name = 'MarketingTeam';
	function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds)){
        	$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	 	}else{
	 		$this->db_name =  $ds;
	 	}
		parent::__construct($id, $table, $ds);
	}
	
	//insert by swati
	/* public function insertMarketingTeam(){
		$this->save(); 
		//return $this->getLastInsertID();
	} */
	 /**
      * fetch list MarketingTeam data function
      * By Mahalaxmi
      * @params location_id
      * return result query list
      */
      function getMarketingTeamList($location_id=null){    
        return $this->find('list', array('fields'=> array('name', 'name'),'conditions'=>array('MarketingTeam.is_deleted'=>'0','MarketingTeam.location_id'=>$location_id),'order' => array ('MarketingTeam.name'=>'ASC')));  
      }   
}
?>