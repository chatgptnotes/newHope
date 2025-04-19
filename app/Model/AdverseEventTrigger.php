<?php

/**
 * Adverse Event Trigger file
 *
 * PHP 5
 *
 *  
 * @link          http://www.drmhope.com/
 * @package       AdverseEventTrigger Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj Wanajri
 */
class AdverseEventTrigger extends AppModel {
	public $useTable = 'adverse_event_triggers';
	public $name = 'AdverseEventTrigger';
	public $specific = true;
	public function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
	/**
	 * 
	 * @param array $fields : table column name like rxnorm,smowmed
	 * @param array of conditions
	 * @return boolean
	 */
	public function getEventTriggers($fields=array(),$conditions=array()){
		if(empty($fields)) return false ;  
		$adverseEventTriggerArray  = $this->find('list',array('fields'=>$fields,'conditions'=>$conditions));
		return $adverseEventTriggerArray ;		 
	}
}
