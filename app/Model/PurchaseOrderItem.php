<?php
App::uses('AppModel', 'Model');

class PurchaseOrderItem extends AppModel {

	public $name = 'PurchaseOrderItem';
	
  	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
 	   
    //function to update GRN by swapnil
    public function UpdateItemStatus($data)
    {
    	if(!empty($data))
    	{ 
    		$conditions = array ('AND'=>array("PurchaseOrderItem.purchase_order_id" => $data['purchase_order_id'],"PurchaseOrderItem.product_id"=>$data['product_id'],
	    						 "PurchaseOrderItem.grn_no IS NULL" )); 
    		$this->deleteAll($conditions);  //delete item with blank GRN
	    	$this->save($data);
	    	$lastInsertedId = $this->getLastInsertId();
	    	$this->id = ''; 
	    	return($lastInsertedId);
    	}
    }
    
	/*
    	Generate GRN number
    	By Swapnil G.Sharma
    */
    function GenerateGRNno()
    {
	    $count = $this->find('count',array('fields'=>Array('COUNT(DISTINCT grn_no) as count'))); 
  		$unique_id  = 'GRN/';  
  		$unique_id .= date('y')."-"; //year
  		$unique_id .= str_pad(++$count, 4, '0', STR_PAD_LEFT);
  		return strtoupper($unique_id) ; 
    }
}
?>