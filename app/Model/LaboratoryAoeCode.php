<?php
/**
 * LaboratoryAoeCode Model
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       SmartPhrase Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
class LaboratoryAoeCode extends AppModel {
	public $specific = true;
	public $name = 'LaboratoryAoeCode';
	function __construct($id = false, $table = null, $ds = null) {
		if (empty ( $ds )) {
			$session = new cakeSession ();
			$this->db_name = $session->read ( 'db_name' );
		} else {
			$this->db_name = $ds;
		}
		parent::__construct ( $id, $table, $ds );
	}
	public function getAoeCodes($laboratoryId) {
		$laboratoryModel = ClassRegistry::init ( 'Laboratory' );
		$dhrOrderCode = $laboratoryModel->find ( 'first', array (
				'fields' => array (
						'id',
						'dhr_order_code' 
				),
				'conditions' => array (
						'Laboratory.id' => $laboratoryId,
						'Laboratory.is_deleted' => '0' 
				) 
		) );
		$aoeCodes = $this->find ( 'all', array (
				'conditions' => array (
						'LaboratoryAoeCode.dhr_obr_code' => $dhrOrderCode ['Laboratory'] ['dhr_order_code'] 
				) 
		) );
		return $aoeCodes;
	}
}