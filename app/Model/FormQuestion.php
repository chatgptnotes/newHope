<?php /**
 * FormModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Form Question Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
class FormQuestion extends AppModel {
	
	public $name = 'FormQuestion';
	
	public $hasMany = array(
        'FormAnswer' => array(
            'className'  => 'FormAnswer',
            'conditions' => array('FormAnswer.is_active' => '1'),
            'order'      => 'FormAnswer.name ASC'
        )
    );
	
	      public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
}