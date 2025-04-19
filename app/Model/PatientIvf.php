<?php
/**
 * PatientIvf Model file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       PatientBloodTransfusion Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class PatientIvf extends AppModel {
	
	public $name = 'PatientIvf';
	public $specific = true;
	public $actsAs = array('Cipher' => array('autoDecypt' => true,'cipher'=>array('intake_detail')));  
	 
	 
	function __construct($id = false, $table = null, $ds = null) {
	       $session = new cakeSession();
	       $this->db_name =  $session->read('db_name');
	       parent::__construct($id, $table, $ds);
	}

	
	
}