<?php
class InventoryCategory extends AppModel {

	public $name = 'InventoryCategory';
        		
	public $validate = array(
		'name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter name."
			),

		'category_code' => array(
			'rule' => "notEmpty",
			'message' => "Please enter name."
			)
           );
	
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }

	 /*var $hasMany = array(
		 'InventoryItem' => array(
		 'className' => 'InventoryItem',
		 'foreignKey' => 'invetory_category_id',
		 'conditions' => array('Comment.status' => '1'),
		 'order' => 'Comment.created DESC',
		 'limit' => '5',
		 'dependent'=> true
		 )
	);*/
        
	    function findRequisitionCodeName($requisitionForName){
	    	
	    	$storeLocation =  ClassRegistry::init('StoreLocation');
	    	
	    	$codeName = $storeLocation->find('first',array(
	    						'fields'=>array('id','name','code_name'),
	    						'conditions'=>array('StoreLocation.name'=>$requisitionForName)
	    	));
	    	
	    	return $codeName;
	    }
	
	}
		

?>