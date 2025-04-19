<?php
/**
 * TimeSlot file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj Wanjari
 */
class TimeSlot extends AppModel {

	public $name = 'TimeSlot'; 
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
 
    public $belongsTo = array(
    		'User' => array('className'    => 'User',
    				'foreignKey'    => 'user_id'
    		),
    		
    		'Initial' => array('className'    => 'Initial',
    				'foreignKey'    => false,
    				'conditions' => array('Initial.id=User.initial_id')
    		),
    		'Role' => array('className'    => 'Role',
    				'foreignKey'    => false,
    				'conditions' => array('Role.id=User.role_id')
    		),
    		
    		'Ward' => array('className'    => 'Ward',
    				'foreignKey'    => 'ward_id'
    		),
    			
    );
    public $virtualFields = array(
    		'full_name' => 'CONCAT(Initial.Name," ",User.first_name," ", User.last_name)'
    );
}