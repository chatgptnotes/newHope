<?php

/* AmbulatoryResultOutbox Model
 *
* PHP 5
*
* @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
* @link          http://www.klouddata.com/
* @package       AmbulatoryResultOutbox0.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Pawan Meshram
*/
class AmbulatoryResultOutbox extends AppModel {
	
	public $name = 'AmbulatoryResultOutbox';
	public $useTable = 'ambulatory_result_outboxes'; 

public $specific = true;


function __construct($id = false, $table = null, $ds = null) {
	$session = new cakeSession();
	$this->db_name = $session->read('db_name');
	parent::__construct($id, $table, $ds);
}
}
