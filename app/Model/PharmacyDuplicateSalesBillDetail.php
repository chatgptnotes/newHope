<?php
class PharmacyDuplicateSalesBillDetail extends AppModel {	
	public $name = 'PharmacyDuplicateSalesBillDetail';	
	public $belongsTo = array(
		'PharmacyItem' => array(
			'className' => 'PharmacyItem',
			'foreignKey' => 'item_id',
			'dependent'=> true
		),
		'PharmacyDuplicateSalesBill' => array(
			'className' => 'PharmacyDuplicateSalesBill',
			'foreignKey' => 'pharmacy_duplicate_sales_bill_id',
			'dependent'=> true
		)
	); 

	/* this method store bill details*/
   public function saveBillDetails($data,$id){
	   App::import('Component', 'DateFormat');
	   $dateformat = new DateFormatComponent();
	   
	   $session = new cakeSession();
	   $flag = true;
		$array_id = array();
		$pharmacyItem = Classregistry::init('PharmacyItem');
		$pharmacyItemRate = Classregistry::init('PharmacyItemRate');
		for($i=0;$i<count($data['item_id']);$i++){
			$field = array();		
			$field['qty'] = $data['qty'][$i];
			$item = $pharmacyItem->find('first',array('conditions' =>array("PharmacyItem.id"=>$data['item_id'][$i],"PharmacyItem.location_id" => $session->read('locationid'))));
			$itemRate = $pharmacyItemRate->find('first',array('conditions' => array("PharmacyItemRate.id" => $data['pharmacyItemId'][$i])));
			$field['item_id'] = $data['item_id'][$i];
			$field['batch_number'] = $itemRate['PharmacyItemRate']['batch_number'];
			$field['mrp'] = $data['mrp'][$i];
			$field['qty_type'] = $data['itemType'][$i];
			$field['pack'] = $data['pack'][$i];
			$field['sale_price'] = $data['rate'][$i];
			$field['expiry_date'] = DateFormatComponent::formatDate2STD($data['expiry_date'][$i],Configure::read('date_format'));
			$field['tax'] = $data['tax'][$i];
			$field['pharmacy_duplicate_sales_bill_id'] = $id;
			$this->create();
			$this->save($field);
		 	$errors = $this->invalidFields();
		 	if(!empty($errors)) {
		 		$flag =  false;
		 	}else{
		 		
			 	/* decrease the stock by quantity*/
				$stock = (double)$item['PharmacyItem']['stock']-(double)$data['qty'][$i];
				$pharmacyItem->id =   $item['PharmacyItem']['id'];
				//$pharmacyItem->saveField('stock', $stock);
				
				$stockRate = (double)$itemRate['PharmacyItemRate']['stock']-(double)$data['qty'][$i];
				$pharmacyItemRate->id = $itemRate['PharmacyItemRate']['id'];
				//$pharmacyItemRate->saveField('stock', $stockRate);
			}
		}
	}
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
	}
?>