<?php
/**
 * WardModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       InventoryPharmacySalesReturn Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class InventoryPharmacySalesReturn extends AppModel {
	
	public $name = 'InventoryPharmacySalesReturn';
	
	 public $hasMany = array(
		'InventoryPharmacySalesReturnsDetail' => array(
		'className' => 'InventoryPharmacySalesReturnsDetail',
		'foreignKey' => 'inventory_pharmacy_sales_return_id',
		'dependent'=> true
		)
		);  
 
	 public $belongsTo = array(
		'Patient' => array(
		'className' => 'Patient',
		'foreignKey' => 'patient_id',
		'dependent'=> true
		)
		); 
	/* this method store bill details*/
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

	public function generateReturnBillNo(){		//by swapnil
		$getBillCount = $this->find('count'); 
		return "SR-".str_pad($getBillCount, 4, '0', STR_PAD_LEFT);	
	}
	
	public function generateSalesReturnBillNoForKanpur($locationID){ //  for kanpur return reciept number-Atul
	
		$getBillCount = $this->find('count',array('conditions'=>array('InventoryPharmacySalesReturn.location_id'=>$locationID,'InventoryPharmacySalesReturn.create_time >'=>'2015-06-02 23:59:59')));
	
		if($locationID=='25'){
			$sbNo= "RR-".str_pad($getBillCount, 5, '0', STR_PAD_LEFT); // for ROMAN PHARMA
			$getBillNum = $this->find('first',array('fields'=>array('InventoryPharmacySalesReturn.bill_code'),'conditions'=>array('InventoryPharmacySalesReturn.bill_code'=>$sbNo)));
			if($getBillNum['PharmacySalesBill']['bill_code']==$sbNo){
				$sbNo = "RR-".str_pad($getBillCount+1, 5, '0', STR_PAD_LEFT);
			}
		}else{
			$sbNo = "ER-".str_pad($getBillCount, 5, '0', STR_PAD_LEFT); // FOR ROMAN PHARMA EXTENTION
			$getBillNum = $this->find('first',array('fields'=>array('InventoryPharmacySalesReturn.bill_code'),'conditions'=>array('InventoryPharmacySalesReturn.bill_code'=>$sbNo)));
			if($getBillNum['PharmacySalesBill']['bill_code']==$sbNo){
				$sbNo = "ER-".str_pad($getBillCount+1, 5, '0', STR_PAD_LEFT);
			}
		}
		return $sbNo;
	}
	
   public function saveBillDetails($data,$id){
  
   $flag = true;
		$array_id = array();
		$pharmacyItem = Classregistry::init('PharmacyItem');
		for($i=0;$i<count($data['item_id']);$i++){
			$field = array();		
			$field['qty'] = $data['qty'][$i];
			$item = $pharmacyItem->findById($data['item_id'][$i]);
			$field['item_id'] = $data['item_id'][$i];
			$field['pharmacy_sales_bill_id'] = $id;
			$this->create();
			$this->save($field);
			 $errors = $this->invalidFields();
			 if(!empty($errors)) {
			 	$flag =  false;
			 }else{
			 	/* decrease the stock by quantity*/
				$stock = (double)$item['PharmacyItem']['stock']-(double)$data['qty'][$i];
				$pharmacyItem->id =   $item['PharmacyItem']['id'];
				$pharmacyItem->saveField('stock', $stock);
				
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