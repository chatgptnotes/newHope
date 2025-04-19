<?php
/**
 * LaboratoryToken model
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       LaboratoryParameter Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 * @functions 	 : Add lab tokens to test (patientwise)
 */
class LaboratoryToken extends AppModel {
	
	// public $name = 'LaboratoryToken';
	public $validate = array (
			'specimen_type_id' => array (
					'rule' => "notEmpty",
					'message' => "Please enter Specimen Type." 
			),
			/*	'end_date' => array(
						'rule' => "notEmpty",
						'message' => "Please enter End date/time."
				),
				'laboratory_id' => array(
						'rule' => "notEmpty",
						'message' => "Please enter Lab Id."
				),*/
				
				'collected_date' => array (
					'rule' => "notEmpty",
					'message' => "Please enter specimen collection date." 
			) 
	);
	//public $actsAs = array ('Auditable');
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession ();
		$this->db_name = $session->read ( 'db_name' );
		parent::__construct ( $id, $table, $ds );
	}
	
	// function to insert lab token
	function insertToken($data = array()) {
		$session = new cakeSession ();
		$dateFormat = new DateFormatComponent ();
		foreach ( $data ['LaboratoryToken'] as $token ) {
			
			if (empty ( $token ['id'] )) {
				$token ['created_by'] = $session->read ( 'userid' );
				$token ['create_time'] = date ( "Y-m-d H:i:s" );
			} else {
				$this->id = $token ['id'];
				$token ['modified_by'] = $session->read ( 'userid' );
				$token ['modify_time'] = date ( "Y-m-d H:i:s" );
			}
			
			if (! empty ( $token ['collected_date'] )) {
				$token ['collected_date'] = $dateFormat->formatDate2STD ( $token ['collected_date'], Configure::read ( 'date_format' ) );
			}
			
			$result = $this->save ( $token );
			
			$this->id = '';
		}
		
		return $result;
	}
}