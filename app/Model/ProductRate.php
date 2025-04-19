<?php

class ProductRate extends AppModel {
	
	public $name = 'ProductRate';

	
	  public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
	  	if(empty($ds)){
        	$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	 	}else{
	 		$this->db_name =  $ds;
	 	}
        parent::__construct($id, $table, $ds);
   	 } 
	 public $belongsTo = array(
		'Product' => array(
		'className' => 'Product',
		'foreignKey' => 'product_id'
		)
	);  
	
	
	 /* add the rate of item in rate table*/
	 public function insertRate($data,$id){
	 	$rateData = array();
	 	$session = new cakeSession();
		$productItem = Classregistry::init('Product');
		if(empty($id)){
			return false;
		}
		if(!empty($data['batch_number']) && !empty($id)){
			$rateData['product_id'] = $id;
			$rateData['batch_number'] = $data['batch_number'];
			$rateData['expiry_date'] = $data['expiry_date'];
			$rateData['mrp'] = $data['mrp'];
			$rateData['tax'] = $data['tax'];
			$rateData['purchase_price'] = $data['purchase_price'];
			$rateData['cost_price'] = $data['cost_price'];
			$rateData['sale_price'] = $data['sale_price'];
			$rateData['stock'] = $data['quantity'];
			$rateData['location_id'] = $session->read('locationid');
			if($this->save($rateData)){
				return true;
			}else{
				return false;
			}
		}
		$this->id = "";
	}		
	
	public function InsertRateBatchWise($id,$data){
		/* debug($data); 
		debug($id);  exit; */
		$session = new cakeSession();
		$productItem = Classregistry::init('Product');
		if(empty($id)){
			return false;
		}
		if(!empty($id)){
			$dataArr = array();
			$prodRate = $this->find('first',array('conditions'=>array('ProductRate.product_id'=>$id,'ProductRate.batch_number'=>$data['batch_number'])));

			if(!empty($prodRate['ProductRate']['id'])){

				$pack = $prodRate['Product']['pack'];
				$this->id = $prodRate['ProductRate']['id'];
				$dataArr['stock'] = $data['stock'] + $prodRate['ProductRate']['stock'];
				
				$old_quantity = ($prodRate['ProductRate']['stock'] * $pack) + $prodRate['ProductRate']['loose_stock'];
				$totalStockinMSU = $old_quantity + $data['stock'];
				
				$dataArr['stock'] = floor($totalStockinMSU / $pack);			//pack stock
				$dataArr['loose_stock'] = $totalStockinMSU % $pack;					//loose stock
				
				$dataArr['product_id'] = $id;
				$dataArr['mrp'] = $data['mrp'];
				$dataArr['purchase_price'] = $data['purchase_price'];
				$dataArr['sale_price'] = $data['selling_price'];
				$dataArr['batch_number'] = $data['batch_number'];
				$dataArr['expiry_date'] = $data['expiry_date'];
				$this->save($dataArr);		
				$this->id = "";
			}else{ 
				
				$productData = $productItem->find('first',array('conditions'=>array('Product.id'=>$data['product_id'])));
				$pack = $productData['Product']['pack'];
				
				$totalStockinMSU = $data['stock'];
				
				$dataInsertArr['stock'] = floor($totalStockinMSU / $pack);			//pack stock
				$dataInsertArr['loose_stock'] = $totalStockinMSU % $pack;					//loose stock
				
				$dataInsertArr['product_id'] = $id;
				$dataInsertArr['mrp'] = $data['mrp'];
				$dataInsertArr['purchase_price'] = $data['purchase_price'];
				$dataInsertArr['sale_price'] = $data['selling_price'];
				$dataInsertArr['batch_number'] = $data['batch_number'];
				$dataInsertArr['expiry_date'] = $data['expiry_date'];
				$dataInsertArr['location_id'] = $session->read('locationid');
				$this->save($dataInsertArr);	
				$this->id = "";
			}
		}
	}
	
}
?>