<?php

 /* Order Sentence model
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
class OrderSentence extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'OrderSentence';

	

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
	
	public function getOrderSentence($searchCode,$doctorId=0,$departmentId=0,$type=null){
		if(!empty($searchCode)){
			$orderSentence = $this->find('all',array('conditions' => array('doctor_id' => $doctorId,'department_id' =>$departmentId,
									'code' =>$searchCode,'status' => '1')));
			return $orderSentence;
		}
		
	}
}
?>