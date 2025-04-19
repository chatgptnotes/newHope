<?php 
class ContractsController extends AppController 
{	
	var $name = "Contracts";
	public $helpers = array('Html','Form', 'Js','DateFormat','Number','General');
	public $components = array('Number');
	public $uses = array("Contract","Product","ContractProduct");
	
	public function add_contract($contract_id = null)
    {
    	$this->layout = 'advance';
    	
    	if($this->request->data)
    	{
    		$last_id = $this->Contract->CreateContract($this->request->data);
    		if(!empty($last_id))
    		{
    			$this->redirect(array("controller" => "Contracts", "action" => "add_contract",$last_id));
    		}
    	}
    	
    	$this->loadModel("Company");
    	$this->set('company',$this->Company->find('list',array('fields'=>array('Company.id','Company.name'))));
    	if(!empty($contract_id))
    	{
    		$this->Contract->bindModel(array('belongsTo'=>array('InventorySupplier'=>array('foreignKey'=>'supplier_id',
											'fields'=>array('InventorySupplier.name')))));
    		
    		$contracts = $this->Contract->find('first',array('conditions'=>array('Contract.id'=>$contract_id),'fields'=>array('Contract.*','InventorySupplier.name')));	
    		$this->set('contracts',$contracts);
    	}
    }
    
    public function getProducts($id)
    {
    	$this->layout = 'ajax';
    	$this->loadModel("ManufacturerCompany");
    	$con = $this->Contract->find('first',array('conditions'=>array('Contract.id'=>$id)));
    	if(!empty($con))
    	{
    		$this->Product->bindModel(array('belongsTo'=>array(
    				'ManufacturerCompany'=>array('foreignKey'=>'manufacturer_id'))));
    		
    		$supplier_id = $con['Contract']['supplier_id'];
    		
    		$products = $this->Product->find('all',array('conditions'=>array('Product.supplier_id'=>$supplier_id)));
    		
    		//debug($products);
    		$this->set('products',$products);
    	}
    	$this->render('ajax_contract_product',false);
    }
    
    public function addProductPrice($contract_id,$product_id,$price)
    {
    	$this->autoRender = false;
    	$this->layout = false;
    	if(!empty($product_id))
    	{
    		$find = $this->ContractProduct->find('first',array('conditions'=>array('ContractProduct.contract_id'=>$contract_id,'ContractProduct.product_id'=>$product_id)));
    		if(count($find)>0)
    		{
    			$this->ContractProduct->id = $find['ContractProduct']['id'];
    		}
    		$data = array();
    		$data['contract_id'] = $contract_id;
    		$data['product_id'] = $product_id;
    		$data['purchase_price'] = $price;
    		$data['create_time'] = date("Y-m-d H:i:s");
    		$data['modify_time'] = date("Y-m-d H:i:s");
    		$this->ContractProduct->save($data);
    	}
    }
    
    public function findContracts($id)
    {
    	$this->autoRender = false;
    	$contracts = $this->Contract->find('list',array('conditions'=>array('Contract.supplier_id'=>$id))); 
    	echo json_encode($contracts);
		exit;
    }
	
    //function to return min n max PO amount with currency symbol and number
    public function findContractDetails($id)
    {
    	$this->autoRender = false;
    	$con = $this->Contract->find('first',array('conditions'=>array('Contract.id'=>$id)));
    	$rangeSentence = "This purchase order is valid if total amount is in between " ;
    	$rangeSentence .= $this->Number->currency($con['Contract']['min_po_amount'])." To ".$this->Number->currency($con['Contract']['max_po_amount']);
    	$minMaxArray  = array(  'minWithCurrency'=>$rangeSentence,
						    	'minPOAmt'=>$con['Contract']['min_po_amount'],
						    	'maxPOAmt'=>$con['Contract']['max_po_amount']);

    	return json_encode($minMaxArray) ;
    	
    }
    
    public function index()
    {
    	$this->layout = "advance";
    	$this->Contract->bindModel(array('belongsTo'=>array(
    	
    			'InventorySupplier'=>array('foreignKey'=>'supplier_id',
											'fields'=>array('InventorySupplier.name')),
    			'Company'=>array('foreignKey'=>'company_id',
    										'fields'=>array('Company.name')),
    			'Location'=>array('foreignKey'=>'facility_id',
    										'fields'=>array('Location.name'))
    			)));
    			
    	$this->paginate = array('limit' => Configure::read('number_of_rows'));
		$contracts = $this->paginate('Contract');
		
		
    	//$contracts = $this->Contract->find('all',array());
    	$this->set('contracts',$contracts);
    }
    
    public function view_contract_products($id)
    {
    	$this->layout = 'advance';
    	$this->loadModel("ManufacturerCompany");
    	if(!empty($id))
    	{
    		$this->Contract->bindModel(array('belongsTo'=>array(
    					
    			'InventorySupplier'=>array('foreignKey'=>'supplier_id',
											'fields'=>array('InventorySupplier.name')),
    			'Company'=>array('foreignKey'=>'company_id',
    										'fields'=>array('Company.name')),
    			'Location'=>array('foreignKey'=>'facility_id',
    										'fields'=>array('Location.name'))
    			)));
    		
    		$contracts = $this->Contract->find('first',array('conditions'=>array('Contract.id'=>$id),'fields'=>array('Contract.*','InventorySupplier.name','Company.name','Location.name')));	
    		//pr($contracts);
    		$this->set('contracts',$contracts);

    		$this->ContractProduct->bindModel(array('belongsTo'=>array(
    				'Product'=>array('foreignKey'=>'product_id'),
    				'ManufacturerCompany'=>array('foreignKey'=>false,'conditions'=>array('Product.manufacturer_id = ManufacturerCompany.id'))
    			)));
    		
    		$con = $this->ContractProduct->find('all',array('conditions'=>array('ContractProduct.contract_id'=>$id)));
    		//debug($con);
    		$this->set('products',$con);
    	}
    }
}
?>