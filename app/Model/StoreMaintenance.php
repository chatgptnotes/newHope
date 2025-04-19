<?php
class StoreMaintenance extends AppModel{
	public $name = 'StoreMaintenance';
    public $specific = true;    		
	public $useTable = "store_maintenance";  
	 
	function __construct($id = false, $table = null, $ds = null) {
	        $session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	        parent::__construct($id, $table, $ds);
    }
    
    public $belongsTo = array(
    		'StoreRequisition' => array(
    				'className' => 'StoreRequisition',
    				'foreignKey' => 'store_requisition_detail_id'
    		),
    		'StoreLocation'=>array(
    				'className'=>'StoreLocation',
    				'foreignKey' => 'store_location_id')
    		);


    function setStock($storeLocId=NULL,$subDepartId=NULL,$requisitionId=NULL,$data){
    	
    	$StockDetails = Classregistry::init('StockMaintenanceDetail');
    	//For making an entry for the requested department stock ie $storeLocId ;
    	if(!empty($subDepartId)){
    		$id=$this->find('first',array('fields'=>array('id'),'conditions'=>array('sub_department_id'=>$subDepartId)));
    	}else{
    		$id=$this->find('first',array('fields'=>array('id'),'conditions'=>array('store_location_id'=>$storeLocId)));
    	}
    	if(!empty($id)){
    		$stockMainData['id']=$id;
    		$stockMainData['modified']=date('Y-m-d H:i:s');
    	}else{
    		$stockMainData['id']='';
    		$stockMainData['created']=date('Y-m-d H:i:s');    	
	    	$stockMainData['store_location_id']=$storeLocId;
	    	$stockMainData['sub_department_id']=$subDepartId;
	    	$stockMainData['store_requisition_detail_id']=$requisitionId;
    	}
    	$this->save($stockMainData);
    	
    	//For maintaining stock details of respective department and respective products
    	if($id)
    		$lastId=$id;
    	else 
    		$lastId=$this->getLastInsertId();
    		for($i=0;$i<count($data['item_name']);$i++){
	    		$proId = $StockDetails->find('first',array('fields'=>array('id'),
	    				'conditions'=>array('stock_maintenance_id'=>$lastId,'product_id'=>$data['item_id'][$i])));
	    		//if the product is available for the selected department.
	    		if(!empty($proId)){
	    			$stockMainDetail['id']=$proId;
	    			$stockMainDetail['stock_quantity']=$proId['StockMaintenanceDetail']['stock_quantity']+$data['issued_qty'][$i];
	    			$stockMainDetail['modified']=date('Y-m-d H:i:s');
	    		}else{
	    			$stockMainDetail['id']='';
	    			$stockMainDetail['product_id']=$data['item_id'][$i];
	    			$stockMainDetail['product_mrp']=$data['mrp'][$i];
	    			$stockMainDetail['product_name']=$data['item_name'][$i];
	    			$stockMainDetail['stock_quantity']=$data['issued_qty'][$i];
	    			$stockMainDetail['created']=date('Y-m-d H:i:s');
	    		}    		
    	    }
    	}
}?>