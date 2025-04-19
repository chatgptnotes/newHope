<?php
class LaundryItem extends AppModel {

	public $name = 'LaundryItem';
        		
	public $validate = array(
		'name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter name."
			),

		
		'item_code' => array(
			'rule' => "isUnique",
			'message' => "Item code alreay exists!"
			)
		

           );

 /*var $belongsTo = array(
	 'InventoryCategory' => array(
	 'className' => 'InventoryCategory',
	 'foreignKey' => 'invetory_category_id'
	 )
); */
    public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }      
	
}