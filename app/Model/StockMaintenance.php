<?php
class StockMaintenance extends AppModel{
	public $name = 'StockMaintenance ';
    public $specific = true;    		
	public $useTable = "stock_maintenances";  
	 
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
    	App::import('Component', 'DateFormat');
    	$dateformat = new DateFormatComponent();
    	$flag=false;
    	$StockDetails = Classregistry::init('StockMaintenanceDetail');
    	//For making an entry for the requested department stock ie $storeLocId ;
    	if(!empty($subDepartId)){
    		$id=$this->find('first',array('fields'=>array('id'),'conditions'=>array('sub_department_id'=>$subDepartId)));
    	}else{
    		$id=$this->find('first',array('fields'=>array('id'),'conditions'=>array('StockMaintenance.store_location_id'=>$storeLocId)));
    	}
    	
    	if(!empty($id)){
    		$stockMainData['id']=$id['StockMaintenance']['id'];
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
    		$lastId=$id['StockMaintenance']['id'];
    	else 
    		$lastId=$this->getLastInsertId();
    	
    		for($i=0;$i<count($data['item_name']);$i++){
	    		$proId = $StockDetails->find('first',array('fields'=>array('id','stock_qty'),
	    				'conditions'=>array('stock_maintenance_id'=>$lastId,'product_id'=>$data['item_id'][$i])));
	    		//if the product is available for the selected department.
	    		if(!empty($proId)){
	    			$stockMainDetail['id']=$proId['StockMaintenanceDetail']['id'];
	    			$stockMainDetail['stock_qty']=$proId['StockMaintenanceDetail']['stock_qty']+$data['issued_qty'][$i];
	    			$stockMainDetail['modified']=date('Y-m-d H:i:s');
	    		}else{
	    			$stockMainDetail['id']='';
	    			$stockMainDetail['stock_maintenance_id']=$lastId;
	    			$stockMainDetail['product_id']=$data['item_id'][$i];
	    			$stockMainDetail['product_expiry']=$dateformat->formatDate2STD($data['expiry_date'][$i],Configure::read('date_format'));;
	    			$stockMainDetail['product_batch']=$data['batch_no'][$i];
	    			$stockMainDetail['mrp']=$data['mrp'][$i];
	    			$stockMainDetail['product_name']=$data['item_name'][$i];
	    			$stockMainDetail['stock_qty']=$data['issued_qty'][$i];
	    			$stockMainDetail['created']=date('Y-m-d H:i:s');
	    		} 
	    		if($StockDetails->save($stockMainDetail))
	    		$flag=true ;
	    		else $flag=false;  		
    	    }
    	    if($flag==true)
    	    	return true;
    	}
    	
    	function issueDepartmentStock($data,$issueDepId=NULL){
    		$session = new cakeSession();
    		$flag=false;
    		$StockDetails = Classregistry::init('StockMaintenanceDetail');
    		$singleStock = Classregistry::init('StockIssueDetail');
    		$fromDepartId=$data['Department']['issued_from'];
    		if($data['Department']['is_patient']=='0'){
    		$toDepartId=$data['Department']['issued_to'];
    		}else{
    			$toDepartId=$data['Department']['patient_id'];
    		}
    		if(!empty($data['StoreRequisition']['ward'])){
    			$subDepartId=$data['StoreRequisition']['ward'];
    		}else if(!empty($data['StoreRequisition']['ot'])){
    			$subDepartId=$data['StoreRequisition']['ot'];
    		}else if(!empty($data['StoreRequisition']['chamber'])){
    			$subDepartId=$data['StoreRequisition']['chamber'];
    		}
    		if(!empty($subDepartId)){
    			$id=$this->find('first',array('fields'=>array('id'),'conditions'=>array('StockMaintenance.store_location_id'=>$fromDepartId,'sub_department_id'=>$subDepartId)));
    		}else{
    			$id=$this->find('first',array('fields'=>array('id'),'conditions'=>array('StockMaintenance.store_location_id'=>$fromDepartId,'sub_department_id'=>$subDepartId)));
    		}

    		foreach($data['product'] as $proKey=>$proData){  
    			
    			$departStock = $StockDetails->find('first',array('conditions'=>array('StockMaintenanceDetail.stock_maintenance_id'=>$id['StockMaintenance']['id'],'StockMaintenanceDetail.product_id'=>$data['product_id'][$proKey])));
	       		$individualStock = $singleStock->find('first',array('conditions'=>array('StockIssueDetail.id'=>$issueDepId)));	       		
	       		
	       		//Main logic of maintaining stock in both tables(StockIssueDetail and stockMaintenenceDetails)
	       		//StockMaintainanceDetail when StockIssueDetail is not empty
	       		if(!empty($individualStock['StockIssueDetail']['id'])){
	       			//for maintaining main stock qty in stockMaintenenceDetails
	       			$departStock['StockMaintenanceDetail']['stock_qty']=$departStock['StockMaintenanceDetail']['stock_qty']+$individualStock['StockIssueDetail']['issued_qty'];
	       			$departStock['StockMaintenanceDetail']['stock_qty']=$departStock['StockMaintenanceDetail']['stock_qty']-$data[$proKey]['issue_qty'];
	       			
	       			//for maintaining issued stock qty in stockMaintenenceDetails
	       			$departStock['StockMaintenanceDetail']['issued_qty']=$departStock['StockMaintenanceDetail']['issued_qty']-$individualStock['StockIssueDetail']['issued_qty'];
	       			$departStock['StockMaintenanceDetail']['issued_qty']=$departStock['StockMaintenanceDetail']['issued_qty']+$data[$proKey]['issue_qty'];
	       			
	       			//for maintaining issued stock qty in StockIssueDetails
	       			$individualStock['StockIssueDetail']['issued_qty']=$data[$proKey]['issue_qty'];
	       			$individualStock['StockIssueDetail']['closing_stock']=$departStock['StockMaintenanceDetail']['stock_qty'];
	       			$individualStock['StockIssueDetail']['modified_by']=$session->read('userid');
	       			$individualStock['StockIssueDetail']['modified']=date('Y-m-d H:i:s');
	       			
	       		}else{ 
	       			 //For maintaining stock of individual product 
	       			$individualStock['StockIssueDetail']['stock_maintenance_detail_id']=$departStock['StockMaintenanceDetail']['id'];
	       			$individualStock['StockIssueDetail']['product_id']=$data['product_id'][$proKey];
	       			$individualStock['StockIssueDetail']['issued_qty']=$data['issue_qty'][$proKey];
		       		/*if($data['Department']['is_patient']=='0'){
		    			$individualStock['StockIssueDetail']['issued_to']=$data['Department']['issued_to'];
		    			$individualStock['StockIssueDetail']['is_patient']='0';	    			
		    		}else{
		    			$individualStock['StockIssueDetail']['issued_to']=$data['Department']['patient_id'];
		    			$individualStock['StockIssueDetail']['is_patient']='1';
		    		}*/
		    		$individualStock['StockIssueDetail']['created_by']=$session->read('userid');
		    		$individualStock['StockIssueDetail']['create_time']=date('Y-m-d H:i:s');
		    		 
		    		//Stock maintained at  stockMaintenenceDetails
		    		$departStock['StockMaintenanceDetail']['stock_qty']=$departStock['StockMaintenanceDetail']['stock_qty']-$data['issue_qty'][$proKey];
		    		$departStock['StockMaintenanceDetail']['issued_qty']=$departStock['StockMaintenanceDetail']['issued_qty']+$data['issue_qty'][$proKey];
		    		$departStock['StockMaintenanceDetail']['modify_time']=date('Y-m-d H:i:s');
		    		
		    		$individualStock['StockIssueDetail']['closing_stock']=$departStock['StockMaintenanceDetail']['stock_qty'];
	       		}
	       		if($singleStock->save($individualStock)){
	       			if($StockDetails->save($departStock)){
	       				$flag=true;
	       			}else{
	       				$flag=false;
	       			}
	       		}else{
	       			$flag=false;
	       		}
	       		$singleStock->id = '';
	       		$StockDetails->id='';
    		}
       		    return $flag;
    	}
}?>