<?php

/* NewCropPrescription model
 *
* PHP 5
*

* @link          http://www.drmhope.com/
* @package       Languages.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Pankaj Mankar
*/
class ReminderPatientList extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'ReminderPatientList';
	public $useTable = 'reminder_patient_lists';
	//public $actsAs = array('Auditable');


	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	*/

	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds)){
        	$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	 	}else{
	 		$this->db_name =  $ds;
	 	}
		parent::__construct($id, $table, $ds);
	}
	public function saveReminder($data=array()){

		$session = new cakeSession();
		$this->save($data);
		return true;

	}
	public function saveReminderFollowup($data=array()){
	
		$session = new cakeSession();
		$this->save($data);
		return true;
	
	}
}
?>
