<?php
/**
 * DumpNote Model file
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 DrM Hope Softwares.
 * @package       DumpNote Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gaurav Chauriya
 */
class DumpNote extends AppModel {
	
	public $name = 'DumpNote';
	public $specific = true;
		
	function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    } 
	
	
}