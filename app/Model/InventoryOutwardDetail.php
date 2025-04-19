<?php
class InventoryOutwardDetail extends AppModel {

	 public $name = 'InventoryOutwardDetail';
     public $useTable = "inventory_outwards_details";
          public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }

}
?>