<?php
/**
 * PreOperativeChecklistModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       PreOperativeChecklist.Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class PreOperativeChecklist extends AppModel {

	public $name = 'PreOperativeChecklist';
	public $actsAs = array('Cipher' => array('autoDecypt' => true,'cipher'=>array('identification_band','temp'
	 ,'pulse','resp','blood_pressure','name_plate')));
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }	
}
?>