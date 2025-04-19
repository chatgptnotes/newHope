<?php
App::uses('AppModel', 'Model');

class Staff extends AppModel {
    public $useTable = 'staff'; 
    public $name = 'Staff';
    public $specific = true;
    public $virtualFields = array(
        
    );

    function __construct($id = false, $table = null, $ds = null) {
        if (empty($ds)) {
            $session = new CakeSession();
            $this->db_name = $session->read('db_name'); 
        } else {
            $this->db_name = $ds; 
        }
        parent::__construct($id, $table, $ds);
    }
}

