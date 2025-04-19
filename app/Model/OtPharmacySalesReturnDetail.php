<?php 

class OtPharmacySalesReturnDetail extends AppModel {

	public $name = 'OtPharmacySalesReturnDetail';
	public $uses = 'ot_pharmacy_sales_return_details';
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  

	public $belongsTo = array(
			'OtPharmacySalesReturn' => array(
					'className' => 'OtPharmacySalesReturn',
					'foreignKey' => 'ot_pharmacy_sales_return_id'
			),
			'OtPharmacyItem' => array(
					'className' => 'OtPharmacyItem',
					'foreignKey' => 'item_id'
			)
	);
	
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
	
	public function saveSaleReturn($data,$id){
		
		App::import('Component', 'DateFormat');
		//$dateformat = new DateFormatComponent();
		$session = new cakeSession();
		$flag = true;
		$array_id = array();
		$pharmacyItem = Classregistry::init('OtPharmacyItem');
		$pharmacyItemRate = Classregistry::init('OtPharmacyItemRate');

		 
		for($i=0;$i<count($data['OtPharmacySalesReturn']['item_id']);$i++){
			$field = array();
			$item = $pharmacyItem->find('first',array('conditions' =>
					array("OtPharmacyItem.id"=>$data['OtPharmacySalesReturn']['item_id'][$i]/* ,"OtPharmacyItem.location_id" => $session->read('locationid')*/) ));
			
			$itemRate = $pharmacyItemRate->find('first',array('conditions' =>
					array("OtPharmacyItemRate.item_id"=>$data['OtPharmacySalesReturn']['item_id'][$i],"OtPharmacyItemRate.id" => $data['pharmacyItemId'][$i]/*,"PharmacyItemRate.location_id" => $session->read('locationid')*/)));
				
			$field['qty'] = $data['OtPharmacySalesReturn']['qty'][$i];
			$field['item_id'] = $data['OtPharmacySalesReturn']['item_id'][$i];
			$field['batch_number'] = $itemRate['OtPharmacyItemRate']['batch_number'];
			$field['mrp'] = $data['OtPharmacySalesReturn']['mrp'][$i];
			$field['discount'] = $data['OtPharmacySalesReturn']['discountAmount'][$i];
			$field['qty_type'] = $data['itemType'][$i];
			$field['pack'] = $data['OtPharmacySalesReturn']['pack'][$i];
			$field['sale_price'] = $data['OtPharmacySalesReturn']['rate'][$i];
			$field['expiry_date'] = DateFormatComponent::formatDate2STD( $data['OtPharmacySalesReturn']['expiry_date'][$i] ,Configure::read('date_format'));
			$field['ot_pharmacy_sales_return_id'] = $id;
			
			$this->create();
			$this->save($field);
			$errors = $this->invalidFields();
			if(!empty($errors)) {
				$flag =  false;
			}else{
					
			$pack = $data['OtPharmacySalesReturn']['pack'][$i];
	 		$saleQty = $data['OtPharmacySalesReturn']['qty'][$i];
	 		$type = $data['itemType'][$i];

	 		$pharmacyStock = $item['OtPharmacyItem']['stock'];
	 		$pharmacyLooseStock = $item['OtPharmacyItem']['loose_stock'];

	 		$pharmacyItemStock = $itemRate['OtPharmacyItemRate']['stock'];
	 		$pharmacyItemLooseStock = $itemRate['OtPharmacyItemRate']['loose_stock'];
	 			

	 		if($type == "Tab"){
	 			//for pharmacy Item
	 			$totalPharmacyTabs = ($pharmacyStock * $pack) + $pharmacyLooseStock;
	 			$remPharTabs = $totalPharmacyTabs + $saleQty;
	 			$currentPharStock = floor($remPharTabs / $pack);			//pack stock
	 			$loosePharStock = $remPharTabs % $pack;					//loose stock
	 				
	 			//for pharmacy Item Rate
	 			$totalPharmacyItemTabs = ($pharmacyItemStock * $pack) + $pharmacyItemLooseStock;
	 			$remPharItemTabs = $totalPharmacyItemTabs + $saleQty;
	 			$currentPharItemStock = floor($remPharItemTabs / $pack);	//pack stock
	 			$loosePharItemStock = $remPharItemTabs % $pack;			//loose stock


	 		}else{
	 			//for pharmacy Item
	 			$currentPharStock = $pharmacyStock + $saleQty;			//pack stock
	 			$loosePharStock = $pharmacyLooseStock;					//loose stock

	 			//for pharmacy Item Rate
	 			$currentPharItemStock = $pharmacyItemStock + $saleQty;	//pack stock
	 			$loosePharItemStock = $pharmacyItemLooseStock;			//loose stock
	 		}
	 			

	 		$pharData = array();
	 		$pharmacyItem->id =   $item['OtPharmacyItem']['id'];
	 		$pharData['stock'] = $currentPharStock;
	 		$pharData['loose_stock'] = $loosePharStock;
	 		$pharmacyItem->save($pharData);
	 		$pharmacyItem->id = "";
	 			
	 		$pharItemData = array();
	 		$pharmacyItemRate->id = $itemRate['OtPharmacyItemRate']['id'];
	 		$pharItemData['stock'] = $currentPharItemStock;
	 		$pharItemData['loose_stock'] = $loosePharItemStock;
	 		$pharmacyItemRate->save($pharItemData);
	 		$pharmacyItemRate->id = "";

			}
		}

		return true;
	}
}
?>