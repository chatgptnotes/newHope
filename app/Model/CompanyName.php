<?php
App::uses('AppModel', 'Model');

class CompanyName  extends AppModel {
    public $useTable = 'company_names'; 
    public $name = 'CompanyName ';
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

