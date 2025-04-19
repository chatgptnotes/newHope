<?php

/** LocationType Model
 *
 * PHP 5
 *
 * @copyright     Copyright 2014 DrMHope.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       EarningDeduction Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gaurav Chauriya
 */
class EarningDeduction extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'EarningDeduction';
	var $useTable = 'earning_deductions';

	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
	public function saveEarningDeduction($requestData = array()){
		$session = new cakeSession();
		if($requestData['id']){
			$requestData['modify_time'] = date('Y-m-d H:i:s');
			$requestData['modified_by'] = $session->read('userid');
			$requestData['location_id'] = $session->read('locationid');
		}else{
			$requestData['create_time'] = date('Y-m-d H:i:s');
			$requestData['created_by'] = $session->read('userid');
			$requestData['location_id'] = $session->read('locationid');
		}	
		$this->save($requestData);
		return $this->id;	
	}
}
