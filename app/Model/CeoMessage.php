<?php
/**
 * Complaint  file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Consultant.Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pranali Shambarkar
 */
class CeoMessage extends AppModel {

	public $name = 'CeoMessage';
	public $useDbConfig = 'test';
	  function __construct($id = false, $table = null, $ds = null) {
        if(empty($ds)){
        	$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	 	}else{
	 		$this->db_name =  $ds;
	 	}
		
		parent::__construct($id, $table, $ds);
    } 

}
?>