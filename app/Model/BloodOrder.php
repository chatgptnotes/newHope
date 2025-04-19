<?php
/**
 * BloodOrder file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj Wanjari
 */
class BloodOrder extends AppModel {

	public $name = 'BloodOrder';
	public $validate = array(
                'order_date' => array(
					'rule' => "notEmpty",
					'message' => "Please enter order date."
									),
				'type_of_request' => array(
					'rule' => "notEmpty",
					'message' => "Please enter type of request."
				), 
	);     

	public $hasMany = array('BloodOrderOption' => array('className'    => 'BloodOrderOption',
                                                  'foreignKey'    => 'blood_order_id'
                                                 ), 
                                  );
       
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
 
	function insertBloodOrder($data=array()){ 
		$session = new cakeSession();
      	$bloodOrderOption	= ClassRegistry::init('BloodOrderOption'); 
      	
      	if(!empty($data["BloodOrder"]['order_date'])){ 
      		$data["BloodOrder"]['order_date'] = DateFormatComponent::formatDate2STD($data["BloodOrder"]['order_date'],Configure::read('date_format'));
      	}  
      	if(isset($data['BloodOrder']['id']) && !empty($data['BloodOrder']['id'])){
      		//remove blood order options , trick to update optnios
      		$bloodOrderOption->deleteAll(array('blood_order_id'=>$data['BloodOrder']['id'])); 
      		//set id for update d record
      		$data['BloodOrder']['modify_time']= date("Y-m-d H:i:s");
       		$data['BloodOrder']["modified_by"] =  $session->read('userid'); 
      		$bloodOrderId =$data['BloodOrder']['id'] ;      			 
      	}else{      			
      		$data['BloodOrder']['create_time'] = date("Y-m-d H:i:s");
       		$data['BloodOrder']["created_by"]  =  $session->read('userid');     			
      	}
        $data['BloodOrder']['location_id'] = $session->read('locationid');
      	//save blodd order
        if($this->save($data)){
      		foreach($data['BloodOrderOption'] as $key=>$value){	
      			//add blood_order_id in options array
      			$data['BloodOrderOption'][$key]['blood_order_id'] = $this->id  ; 
      			if(!empty($data["BloodOrderOption"][$key]['blood_transfusion_date'])){ 
		      		$data["BloodOrderOption"][$key]['blood_transfusion_date'] = DateFormatComponent::formatDate2STD($data["BloodOrderOption"][$key]['blood_transfusion_date'],Configure::read('date_format'));
		      	}
			    if( empty($data["BloodOrderOption"][$key]['tariff_list_id']) &&
			    	empty($data["BloodOrderOption"][$key]['units']) &&
			    	empty($data["BloodOrderOption"][$key]['blood_transfusion_date'])){
			     	unset($data["BloodOrderOption"][$key]); //remove empty row from post ele
			    } 
      		}
      		$bloodOrderOption->saveAll($data['BloodOrderOption']); 
      	}
      	
	}
	
	function updateBloodOrder($data=array()){
		$session = new cakeSession();
      	$bloodOrderOption	= ClassRegistry::init('BloodOrderOption'); 
	 
      	//set id for update d record
      	$data['BloodOrder']['modify_time']= date("Y-m-d H:i:s");
       	$data['BloodOrder']["modified_by"] =  $session->read('userid');
        $data['BloodOrder']['location_id'] = $session->read('locationid');
      	//save blodd order
        if($this->save($data)){
      		$bloodOrderOption->saveAll($data['BloodOrderOption']); 
      	}
	}
}