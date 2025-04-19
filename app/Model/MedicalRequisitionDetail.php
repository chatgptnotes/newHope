<?php
/**
 *  OtReplaceDetails file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       PharmacyItem Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class MedicalRequisitionDetail extends AppModel { 
	public $name = 'MedicalRequisitionDetail'; 
	public $belongsTo = array(
		'MedicalRequisition' => array(
			'className' => 'MedicalRequisition',
			'foreignKey' => 'medical_requisition_id'
			) ,
		 'PharmacyItem' => array(
			'className' => 'PharmacyItem',
			'foreignKey' => 'item_id'
			)
		);  
		
	  public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
			$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
			parent::__construct($id, $table, $ds);
      }  
	}
?>