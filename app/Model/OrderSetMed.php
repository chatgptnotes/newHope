<?php

 /* OrderSetMed model
*
* PHP 5
*
* @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
* @link          http://www.klouddata.com/
* @package       Languages.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Mayank Jain
*/
class OrderSetMed extends AppModel {
	/**
	 * Validation rules 
	 *
	 * @var array
	 */
	public $name = 'OrderSetMed';

	

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	*/
	
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	function insertMedication($data =array()){
		 debug($data);
		 exit;
		$session = new cakeSession();
	
		if(!empty($data["DignosticStudy"]["id"])){
			$data["DignosticStudy"]["modify_time"] = date("Y-m-d H:i:s");
			$data["DignosticStudy"]["modified_by"] = $session->read('userid') ;
			$data["DignosticStudy"]["location_id"] = $session->read('locationid');
		}else{
			$data["DignosticStudy"]["create_time"] = date("Y-m-d H:i:s");
			$data["DignosticStudy"]["created_by"]  = $session->read('userid') ;
			$data["DignosticStudy"]["location_id"] = $session->read('locationid');
		}
		$this->create();
		$this->save($data);
		//$lastinsid=$this->getInsertId();
		return true;
	}
}
?>