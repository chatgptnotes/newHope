<?php
/**
 * LaboratoryResult model
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       LaboratoryParameter Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 * @functions 	 : insertLabResults(insert/update lab result data).	
 */
class LaboratoryResult extends AppModel {
	public $name = 'LaboratoryResult';
	// public $actsAs = array('Cipher' => array('autoDecypt' => true,'cipher'=>array('value','text','status')),'Containable');
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		if (empty ( $ds )) {
			$session = new cakeSession ();
			$this->db_name = $session->read ( 'db_name' );
		} else {
			$this->db_name = $ds;
		}
		parent::__construct ( $id, $table, $ds );
	}
	function insertLabResults($data = array()) {
		$session = new cakeSession ();
		// update laboratorytestorder with result page fields
		$labTestOrder = Classregistry::init ( 'LaboratoryTestOrder' );
		if (! empty ( $data ['LaboratoryTestOrder'] ['dynamic_labels'] )) {
			$data ['LaboratoryTestOrder'] ['dynamic_labels'] = serialize ( $data ['LaboratoryTestOrder'] ['dynamic_labels'] );
			$data ['LaboratoryTestOrder'] ['dynamic_values'] = serialize ( $data ['LaboratoryTestOrder'] ['dynamic_labels_values'] );
		}
		$labTestOrder->save ( $data ['LaboratoryTestOrder'] ); // update the order data with result data
		
		foreach ( $data ['LaboratoryResult'] as $key => $value ) {
			if (is_array ( $value )) {
				foreach ( $value as $treatedArr ) {
					if (isset ( $treatedArr ['range'] )) {
						$splitArr = explode ( "-", $treatedArr ['range'] );
						
						if (! empty ( $treatedArr ['value'] )) {
							if (is_numeric ( $splitArr [0] ) && (! empty ( $splitArr [0] )) && (empty ( $splitArr [1] ))) {
								if ($treatedArr ['value'] > $splitArr [0]) {
									$treatedArr ['status'] = 'NORMAL';
								} else {
									$treatedArr ['status'] = 'ABNORMAL';
								}
							} else if (is_numeric ( $splitArr [1] ) && (! empty ( $splitArr [1] )) && (empty ( $splitArr [0] ))) {
								if ($treatedArr ['value'] > $splitArr [1]) {
									$treatedArr ['status'] = 'ABNORMAL';
								} else {
									$treatedArr ['status'] = 'NORMAL';
								}
							} else {
								if ($treatedArr ['value'] < $splitArr [0] || $treatedArr ['value'] > $splitArr [1]) {
									$treatedArr ['status'] = 'ABNORMAL';
								} else {
									$treatedArr ['status'] = 'NORMAL';
								}
							}
						}
					}
					$treatedArr ['modified_by'] = $session->read ( 'userid' );
					$treatedArr ['modify_time'] = date ( "Y-m-d H:i:s" );
					$treatedArr ['user_id'] = $data ['LaboratoryResult'] ['user_id'];
					
					if (isset ( $data ['LaboratoryResult'] ['confirm_result'] ))
						$treatedArr ['confirm_result'] = (! empty ( $data ['LaboratoryResult'] ['confirm_result'] )) ? $data ['LaboratoryResult'] ['confirm_result'] : 0;
					
					if (! empty ( $data ['LaboratoryResult'] ['result_publish_date'] ))
						$treatedArr ['result_publish_date'] = $data ['LaboratoryResult'] ['result_publish_date'];
					
					$result = $this->save ( $treatedArr );
					$this->id = '';
				}
			}
		}
		return $result;
	}
}