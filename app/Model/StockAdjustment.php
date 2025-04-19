<?php
App::uses('AppModel', 'Model');

class StockAdjustment extends AppModel {
	
	public $name = 'StockAdjustment';
	
  	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
    
   public function Insert($id,$qty)
   {
   		$data = array();
   		$data['product_id'] = $id;
   		$data['adjusted_date'] = date("Y-m-d H:i:s");
   		$data['created'] = date("Y-m-d H:i:s");
   		$data['modified'] = date("Y-m-d H:i:s");
   		$data['adjusted_qty'] = $qty;
   		$data['is_surplus'] = 1;
   		$this->save($data);
   }
}
?>