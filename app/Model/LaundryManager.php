<?php
class LaundryManager extends AppModel {

	public $name = 'LaundryManager';
        		
	public $validate = array(
		
		'date' => array(
			'rule' => "notEmpty",
			'message' => "Please Select Category."
			),
		'quantity' => array(
			'rule' => "notEmpty",
			'message' => "Please Select Category."
			)
		

           );
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
 /*var $belongsTo = array(
	 'InventoryCategory' => array(
	 'className' => 'InventoryCategory',
	 'foreignKey' => 'invetory_category_id'
	 )
); */
        
	
}