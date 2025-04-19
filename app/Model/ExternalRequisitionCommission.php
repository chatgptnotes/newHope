<?php 
/** Service Amount model
*
* PHP 5
*
* @copyright     Copyright 2013 DrM Hope Softwares
* @link          http://www.drmcaduceus.com/
* @package       ExternalRequisitionCommission.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Amit Jain
*/
class ExternalRequisitionCommission extends AppModel {
	
	public $name = 'ExternalRequisitionCommission';

	public $specific = true;
	
	public $validate = array(
			'account_id' => array(
					'rule' => "notEmpty",
					'message' => "Please try again."
			),
			'user_id' => array(
					'rule' => "notEmpty",
					'message' => "Please try again."
			),
			'paid_amount' => array(
					'rule' => "notEmpty",
					'message' => "Please enter amount"
			),
	);  
				
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
}
?>