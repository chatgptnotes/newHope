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
class Service extends AppModel {
	
	public $name = 'Service';
	public $validate = array(
            'name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter service name."
			),
			 
		);
	  public $hasMany = array(
        'SubService' => array(
            'className'  => 'SubService'           
        )
    );
		
	      public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
	//insert and update service details		
	function insertService($data=array(),$action='insert'){
		$session = new CakeSession();
		if($action=='insert'){
			$data["City"]["create_time"] = date("Y-m-d H:i:s");
	        $data["City"]["modify_time"] = date("Y-m-d H:i:s");
	        $data["City"]["created_by"] =  $session->read('userid');
	        $data["City"]["modified_by"] = $session->read('userid');
		}else{
			 
	        $data["City"]["modify_time"] = date("Y-m-d H:i:s");	       
	        $data["City"]["modified_by"] = $session->read('userid');
		}                               
        $this->save($data);
	}
	
	
		
}