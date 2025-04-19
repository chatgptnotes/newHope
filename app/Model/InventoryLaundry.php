<?php
class InventoryLaundry extends AppModel {

	public $name = 'InventoryLaundry';
        		
	public $validate = array(
		'name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter name."
			),

		'date' => array(
			'rule' => "notEmpty",
			'message' => "Please Select Category."
			),
		'quantity' => array(
			'rule' => "notEmpty",
			'message' => "Please Select Category."
			)/*,
		'item_code' => array(
			'rule' => "isUnique",
			'message' => "Item code alreay exists!"
			)*/
		

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