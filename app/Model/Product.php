<?php
App::uses('AppModel', 'Model');
/**
 * Product Model file
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 Drmhope Softwares  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Hope
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
*/
class Product extends AppModel {
 
	public $specific = true; 

	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
	/*public $belongsTo = array(
			'PurchaseOrderItem' => array(
					'className' => 'PurchaseOrderItem',
					'foreignKey' => false,
					'conditions'=>array('PurchaseOrderItem.product_id=Product.id','PurchaseOrderItem.quantity<Product.reorder_level')
			)
	);*/
	
	
	public function generateRandomBillNo(){
		$characters = array(
				"A","B","C","D","E","F","G","H","J","K","L","M",
				"N","P","Q","R","S","T","U","V","W","X","Y","Z",
				"1","2","3","4","5","6","7","8","9");
		$keys = array();
		$random_chars ='';
		while(count($keys) < 7) {
			$x = mt_rand(0, count($characters)-1);
			if(!in_array($x, $keys)) {
				$keys[] = $x;
			}
		}
		foreach($keys as $key){
			$random_chars .= $characters[$key];
		}
		return $random_chars;
	}

	public function UpdateStock($id,$data)
	{
		$product = $this->find('first',array('conditions'=>array('Product.id'=>$id)));
		$pack = $product['Product']['pack'];
		
		$old_quantity = ($product['Product']['quantity'] * $pack) + $product['Product']['loose_stock'];
		$totalStockinMSU = $old_quantity + $data['stock'];
		
		$data['quantity'] = floor($totalStockinMSU / $pack);			//pack stock
		$data['loose_stock'] = $totalStockinMSU % $pack;					//loose stock
		
		$this->id = $id; 
		$this->save($data);
		$this->id = '';
	} 
	
	public function updateStockReturn($id,$quantity){
		
		$product = $this->find('first',array('conditions'=>array('Product.id'=>$id)));
		$pack = $product['Product']['pack'];
		
		$old_quantity = ($product['Product']['quantity'] * $pack) + $product['Product']['loose_stock']; //104
		$totalStockinMSU = $old_quantity + $quantity;				// 104 - 10
		
		$data['quantity'] = floor($totalStockinMSU / $pack);		//94/10 = 9.4
		$data['loose_stock'] = $totalStockinMSU % $pack;			//
		
		$this->id = $id;
		$this->save($data);
		$this->id = '';
	}
	
	
	/* this function use for imprt the Lab in the master*/
	function importData(&$dataOfSheet){
		$products = Classregistry::init('Product');
		$manufacturerCompany = Classregistry::init('ManufacturerCompany');
		$inventorySupplier = Classregistry::init('InventorySupplier');
		$service_category = Classregistry::init('Product');
		$session = new cakeSession();
		$dataOfSheet->row_numbers=false;
		$dataOfSheet->col_letters=false;
		$dataOfSheet->sheet=0;
		$dataOfSheet->table_class='excel'; 
		try
		{
			for($row=2;$row<=$dataOfSheet->rowcount($dataOfSheet->sheet);$row++) { 
				$serviceC = trim($dataOfSheet->val($row,1,$dataOfSheet->sheet));
				$serviceSC = trim($dataOfSheet->val($row,2,$dataOfSheet->sheet));	
				$data['name'] = addslashes(trim($dataOfSheet->val($row,2,$dataOfSheet->sheet)));
				$data['product_code'] = trim($dataOfSheet->val($row,1,$dataOfSheet->sheet));
	
				$manufacturer = trim($dataOfSheet->val($row,3,$dataOfSheet->sheet));
				$manufacturerCompany->id= '';
				if(!empty($manufacturer)){
					$manuRec = $manufacturerCompany->find('first',array('conditions'=>array('name'=>$manufacturer,'is_deleted'=>0)));
					if(!empty($manuRec['ManufacturerCompany']['id'])){
						$data['manufacturer_id'] = $manuRec['ManufacturerCompany']['id'];
					}else{
						$data['manufacturer_id'] = $manufacturerCompany->insertManufacturer(array('name'=>$manufacturer,'location_id'=>$session->read('locationid')));
					}
				}	
				$data['pack'] = addslashes(trim($dataOfSheet->val($row,4,$dataOfSheet->sheet)));
				$data['generic'] = trim($dataOfSheet->val($row,5,$dataOfSheet->sheet));
				$data['quantity'] = trim($dataOfSheet->val($row,6,$dataOfSheet->sheet));
				$data['batch_number'] = trim($dataOfSheet->val($row,7,$dataOfSheet->sheet));
				$expiryDate = $dataOfSheet->val($row,8,$dataOfSheet->sheet);
				if(!empty($expiryDate)){
					$splitExpiry = explode("/",$expiryDate);
					$resetExpiryDate = $splitExpiry[2]."-".$splitExpiry[1]."-".$splitExpiry[0];
				}
				$data['expiry_date'] = trim($resetExpiryDate);
				$data['mrp'] = trim($dataOfSheet->val($row,9,$dataOfSheet->sheet));
				$data['tax'] = trim($dataOfSheet->val($row,10,$dataOfSheet->sheet));
				$data['purchase_price'] = trim($dataOfSheet->val($row,12,$dataOfSheet->sheet));
				$data['cst'] = trim($dataOfSheet->val($row,13,$dataOfSheet->sheet));
				$data['cost_price'] = trim($dataOfSheet->val($row,14,$dataOfSheet->sheet));
				$data['sale_price'] = trim($dataOfSheet->val($row,15,$dataOfSheet->sheet));
				$data['location_id'] = $session->read('locationid');
	
				$supplier_code = trim($dataOfSheet->val($row,16,$dataOfSheet->sheet));
				$supplier_name = trim($dataOfSheet->val($row,17,$dataOfSheet->sheet));
				$inventorySupplier->id='' ;
				if(!empty($supplier_code)){
					$suppplierRec = $inventorySupplier->find('first',array('conditions'=>array('code'=>$supplier_code,'is_deleted'=>0)));
					if(!empty($suppplierRec['InventorySupplier']['id'])){
						$data['supplier_id'] = $suppplierRec['InventorySupplier']['id'];
					}else{
						$inventorySupplier->insertSupplier(array('name'=>$supplier_name,'code'=>$supplier_code,
								'dl_no'=>trim($dataOfSheet->val($row,19,$dataOfSheet->sheet)),
								'dl21_no'=>trim($dataOfSheet->val($row,20,$dataOfSheet->sheet)),
								'credit_limit'=>trim($dataOfSheet->val($row,24,$dataOfSheet->sheet)),
								'credit_day'=>trim($dataOfSheet->val($row,25,$dataOfSheet->sheet)),
								'location_id'=>$session->read('location_id')));
						$data['supplier_id'] = $inventorySupplier->getLastInsertID() ;
					}
				}
				$products->save($data);
				$products->id = '' ;
			}
			return true;
		}catch(Exception $e){
			//print_r($e);
			return $e;
		}
	}
	
	function updatePurchasePriceFromPurchaseOrder($id,$data){
		$product = $this->find('first',array('conditions'=>array('id'=>$id)));
		if($product['Product']['purchase_price'] != $data){
			$val['id'] = $id;
			$val['purchase_price'] = $data;
			$this->save($val);
		}
	}

	function saveRates($data){
		$this->id = $data['product_id'];
		$value['purchase_price'] = $data['purchase_price'];
		$value['mrp'] = $data['mrp'];
		$value['sale_price'] = $data['selling_price'];
		$value['tax'] = $data['tax'];
		$value['batch_number'] = $data['batch_number'];
		$value['expiry_date'] = DateFormatComponent::formatDate2STD($data['expiry_date'],Configure::read('date_format'));
		$this->save($value);
		$this->id = '';
	}

}