<?php /**
 * FormModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Form Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
class PatientForm extends AppModel {
	
	public $name = 'PatientForm';
	
	public $hasMany = array(
        'FormQuestion' => array(
            'className'  => 'FormQuestion',
            'conditions' => array('FormQuestion.is_active' => '1'),
            'order'      => 'FormQuestion.sort_nr ASC'
        )
    );
	
      public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  	
	   
}