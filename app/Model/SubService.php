<?php
/**
 * Service model
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Bed Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj  wanjari
 * @functions 	 : insertService(insert/update service data).	
 */
class SubService extends AppModel {
	
	public $name = 'SubService';
	 public $validate = array(
	            'name' => array(
				'rule' => "notEmpty",
				'message' => "Please enter sub service name."
				),
				'cost' => array(
				'rule' => "notEmpty",
				'message' => "Please enter sub service cost."
				),
			);
	public $belongsTo = array('Service' => array('className'    => 'Service',
                                                    'foreignKey'    => 'service_id'
                                                 ),
                                 
                                  );	

      public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }                              
	//insert and update service details		
	function insertSubService($data=array(),$serviceId=null){        	       
        $data["SubService"]["service_id"] = $serviceId;		                               
        $this->save($data);
	}
		
}