<?php
/**
 * MedicalRepSurgicalItemModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       MedicalRepSurgicalItem.Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class MedicalRepSurgicalItem extends AppModel {

	public $name = 'MedicalRepSurgicalItem';
/**
 * MedicalRepSurgicalItem table binding with patient 
 *
 */	
         public $belongsTo = array('Patient' => array('className'    => 'Patient',
                                                      'foreignKey'    => 'patient_id'
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