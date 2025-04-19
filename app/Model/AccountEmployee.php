<?php

 /* Employees Account model
*
* PHP 5
*
* @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
* @link          http://www.klouddata.com/
* @package       Languages.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Pankaj Wanjari
*/
class AccountEmployee extends AppModel { 
	
	public $specific = true;
	 
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
	
	function savePayment($data){
		$session = new cakeSession();
		$dateFormat = new DateFormatComponent();
		$data['create_time'] = date('Y-m-d H:i:s');
		$data['created_by'] = $session->read('userid');
		$data['location_id'] = $session->read('locationid');
		if($data['paid_on']){
			$data['paid_on']= $dateFormat->formatDate2STD($data['paid_on'],Configure::read('date_format_us'));
		}
		return $this->save($data);
	}

}
?>