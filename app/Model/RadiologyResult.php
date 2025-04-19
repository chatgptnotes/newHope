<?php
/**
 * RadiologyResult model
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       LaboratoryParameter Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj wanjari
 * @functions 	 : insertReport(insert/update radiology lab result data).	
 */
class RadiologyResult extends AppModel {
	
	 public $name = 'RadiologyResult'; 
	// public $actsAs = array('Cipher' => array('autoDecypt' => true,'cipher'=>array('note')));   	
	 public $specific = true;
	 function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
     } 
    
}