
<?php
/**
 * WardModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       PharmacySalesBillDetail Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class PharmacySalesBillDetail extends AppModel {	
	public $name = 'PharmacySalesBillDetail';	
	public $belongsTo = array(
		'PharmacyItem' => array(
			'className' => 'PharmacyItem',
			'foreignKey' => 'item_id',
			'dependent'=> true
		),
		'PharmacySalesBill' => array(
			'className' => 'PharmacySalesBill',
			'foreignKey' => 'pharmacy_sales_bill_id',
			'dependent'=> true
		)
	); 
	
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

	/* this method store bill details*/
   public function saveBillDetails($data,$id,$nurse=null){
	
	   App::import('Component', 'DateFormat');
	   $dateformat = new DateFormatComponent();
	   $session = new cakeSession();
	   $flag = true;
		$array_id = array();
		$pharmacyItem = Classregistry::init('PharmacyItem');
		$pharmacyItemRate = Classregistry::init('PharmacyItemRate');
		$storeRequisition = Classregistry::init('StoreRequisition');
		$Patient = Classregistry::init('Patient');
		$Coupon = Classregistry::init('Coupon');
		$ServiceCategory = Classregistry::init('ServiceCategory');
		$totalAmount = 0;
		//for nurse prescription by swapnil 13.04.2015
		if($nurse == true){
            return $this->saveSaleBillthroughNurse($data,$id);
		}
	$patientData = $Patient->find('first', array('conditions'=>array("Patient.id"=>$data['PharmacySalesBill']['patient_id']),'fields'=>array('coupon_name')));
			$PharmacyGroupId = $ServiceCategory->getPharmacyId();
	
		for($i=0;$i<count($data['item_id']);$i++){
			$field = array();	
			$discAmt=0;
			$field['qty'] = $data['qty'][$i];
			//$field['discount']=0;
			$item = $pharmacyItem->find('first',array('conditions' =>
						 array("PharmacyItem.id"=>$data['item_id'][$i]/*,"PharmacyItem.location_id" => $session->read('locationid')*/)));
			
			$itemRate = $pharmacyItemRate->find('first',array('conditions' =>
						 array("PharmacyItemRate.item_id"=>$data['item_id'],"PharmacyItemRate.id" => $data['pharmacyItemId'][$i]/*,"PharmacyItemRate.location_id" => $session->read('locationid')*/)));
			
			$field['item_id'] = $data['item_id'][$i];
			$field['batch_number'] = $itemRate['PharmacyItemRate']['batch_number'];
			$field['mrp'] = $data['mrp'][$i];
			$field['qty_type'] = $data['itemType'][$i];						
			$field['pack'] = $data['pack'][$i];
			$field['sale_price'] = $data['rate'][$i];
			$field['expiry_date'] = DateFormatComponent::formatDate2STD($data['expiry_date'][$i],Configure::read('date_format'));
			$field['tax'] = $data['tax'][$i];
			$field['pharmacy_sales_bill_id'] = $id;
			$field['administration_time'] = $data['administration_time'][$i];
			
                        $calculatedTotalAmount = ($field['mrp']/$field['pack'])*$data['qty'][$i]; 
                        $totalAmount += $calculatedTotalAmount;
           //for coupon/privilege card Discount -swatin
                        if(!empty($patientData['Patient']['coupon_name'])){
                        	$couponDetails  = $Coupon->find('first',array('conditions'=>array('Coupon.batch_name'=>$patientData['Patient']['coupon_name']),'fields'=>array('id','batch_name','sevices_available','coupon_amount')));
                        	$sevicesAvailable = explode(',',$couponDetails['Coupon']['sevices_available']);
                        	$couponAMT = unserialize($couponDetails['Coupon']['coupon_amount']);
                        	if(in_array($PharmacyGroupId, $sevicesAvailable)){                        		
                        		$totalPayment = $calculatedTotalAmount;
                        		$Coupontype = $couponAMT[$PharmacyGroupId]['type'];
                        		$CoupontypeAmount = $couponAMT[$PharmacyGroupId]['value'];
                        		if($Coupontype == 'Percentage'){
                        			$perSentAmt = ($totalPayment/100)*$CoupontypeAmount;
                        			$pending = $totalPayment - $perSentAmt;
                        			$discAmt = $perSentAmt;
                        		}else if($Coupontype == 'Amount'){
                        			$pending = $totalPayment - $CoupontypeAmount;
                        			$discAmt = $CoupontypeAmount;
                        		}
                        	}
                        	$data['itemWiseDiscountAmount'][$i] = $data['itemWiseDiscountAmount'][$i] + $discAmt;
                        }   
                    /* end of discount code*/
                  $field['discount'] = $data['itemWiseDiscountAmount'][$i];
                       
               $discountAmount = $discountAmount + $field['discount']; 
               
			$this->create();
			$this->save($field); 
		 	$errors = $this->invalidFields();
		 	if(!empty($errors)) {
		 		$flag =  false;
		 	}else{
			 	/* decrease the stock by quantity by Swapnil G.Sharma */ 
		 		$pack = $data['pack'][$i];
		 		$saleQty = $data['qty'][$i];
		 		$type = $data['itemType'][$i];
		 		
		 		$pharmacyStock = $item['PharmacyItem']['stock'];
		 		$pharmacyLooseStock = $item['PharmacyItem']['loose_stock'];
		 		
		 		$pharmacyItemStock = $itemRate['PharmacyItemRate']['stock'];
		 		$pharmacyItemLooseStock = $itemRate['PharmacyItemRate']['loose_stock'];
		 		
		 		if($type == "Tab"){
		 			//for pharmacy Item
					$totalPharmacyTabs = ($pharmacyStock * $pack) + $pharmacyLooseStock;
					$remPharTabs = $totalPharmacyTabs - $saleQty;
					$currentPharStock = floor($remPharTabs / $pack);			//pack stock
					$loosePharStock = $remPharTabs % $pack;					//loose stock
		 			
					//for pharmacy Item Rate					
					$totalPharmacyItemTabs = ($pharmacyItemStock * $pack) + $pharmacyItemLooseStock;
					$remPharItemTabs = $totalPharmacyItemTabs - $saleQty;	
					$currentPharItemStock = floor($remPharItemTabs / $pack);		//pack stock
					$loosePharItemStock = $remPharItemTabs % $pack;					//loose stock
					$reorderLevel = $item['PharmacyItem']['reorder_level'] * $pack; // TabletWise reorderLevel 
		 		}else{
		 			
		 			//for pharmacy Item
					$currentPharStock = $pharmacyStock - $saleQty;			//pack stock
					$loosePharStock = $pharmacyLooseStock;					//loose stock
					
					//for pharmacy Item Rate	
					$currentPharItemStock = $pharmacyItemStock - $saleQty;	//pack stock
					$loosePharItemStock = $pharmacyItemLooseStock;			//loose stock
					$totalPharmacyTabs = $currentPharStock;
					$reorderLevel = $item['PharmacyItem']['reorder_level']; // pack wise reorderLevel
				}
				
				$pharData = array();
				$pharmacyItem->id =   $item['PharmacyItem']['id'];
				$pharData['stock'] = $currentPharStock;
				$pharData['loose_stock'] = $loosePharStock;
				$pharmacyItem->save($pharData);
				$pharmacyItem->id = "";
				
				$pharItemData = array();
				$pharmacyItemRate->id = $itemRate['PharmacyItemRate']['id'];
				$pharItemData['stock'] = $currentPharItemStock;
				$pharItemData['loose_stock'] = $loosePharItemStock;
				$pharmacyItemRate->save($pharItemData);
				$pharmacyItemRate->id = "";
			}
		}
		//debug($totalAmount);
		//debug($discountAmount); exit;
		$returnArray = array('total'=>$totalAmount,'discount'=>$discountAmount);
		return $returnArray;
	}
	
	
	public function saveSaleBillthroughNurse($data,$id){ 
		  
	 	App::import('Component', 'DateFormat');
	 	$dateformat = new DateFormatComponent();
	 	$session = new cakeSession(); 
	 	$array_id = array();
	 	$pharmacyItem = Classregistry::init('PharmacyItem');
	 	$pharmacyItemRate = Classregistry::init('PharmacyItemRate'); 
	 	$conditionsPharmaItemRateArr=array();
	 	$totalAmount = 0;
                
		for($i=0;$i<count($data['item_id']);$i++){
			
			$qty = $data['qty'][$i];
			$conditionsPharmaItemRateArr=array();
			 
			$item = $pharmacyItem->find('first',array('conditions' => array("PharmacyItem.id"=>$data['item_id'][$i]))); 
			///***BOF-Mahalaxmi *****/// 
			$conditionsPharmaItemRateArr=array("PharmacyItemRate.item_id"=>$data['item_id'][$i],
				'PharmacyItemRate.is_deleted = 0',/*"PharmacyItemRate.id" => $data['pharmacyItemId'][$i],*/
				"OR" => array("PharmacyItemRate.stock > 0","PharmacyItemRate.loose_stock > 0"));
			///***EOF-Mahalaxmi *****///
			
			$pharmacyItemRate->recursive = -1;
			$itemRate = $pharmacyItemRate->find('all',array('conditions' => $conditionsPharmaItemRateArr,
				'order'=>array('PharmacyItemRate.expiry_date'=>'ASC'))); 

		 	$pack = (int)$item['PharmacyItem']['pack'];  
		 	$type = $data['itemType'][$i];
		 	 
			$deductStock = 0;
			foreach($itemRate as $pkey => $pValue){
				$field = array();
				if($qty!=0){
					$myRateStock = ($pValue['PharmacyItemRate']['stock'] * $pack) + $pValue['PharmacyItemRate']['loose_stock']; 
					$pharmacyItemRate->id = $pValue['PharmacyItemRate']['id'];
					if($myRateStock < $qty){
						$qty = $qty - $myRateStock;
						$saveStock = $myRateStock; 
					}else{
						$saveStock = $qty;
						$qty = 0;
					}
					
					
					//update pharmacy Item rate stock
					$myPharmacyRateStock = $myRateStock - $saveStock;

					$savePharData = array();
					$savePharData['stock'] = floor($myPharmacyRateStock / $pack);
					$savePharData['loose_stock'] = floor($myPharmacyRateStock % $pack);
					 
					$pharmacyItemRate->save($savePharData);
					$pharmacyItemRate->id = '';
					
					$mrp = $pValue['PharmacyItemRate']['mrp'];
					$calculatedTotalAmount = ($saveStock * $mrp)/$pack;
					 
					//$calculatedDiscount = ($calculatedTotalAmount * $actualDiscount)/100;
					//insert into sales bill details
					$field['item_id'] = $data['item_id'][$i];
					$field['qty'] = $saveStock;
					$field['pharmacy_item_rate_id'] = $pValue['PharmacyItemRate']['id'];
					$field['batch_number'] = $pValue['PharmacyItemRate']['batch_number'];
					$field['mrp'] = $mrp;
					$field['qty_type'] = $data['itemType'][$i];
					//$field['discount'] = $calculatedDiscount;
					$field['pack'] = $data['pack'][$i];
					$field['sale_price'] = $pValue['PharmacyItemRate']['mrp'];	//for vadodara sale price always a MRP
					$field['expiry_date'] = $pValue['PharmacyItemRate']['expiry_date'];
					$field['tax'] = $data['tax'][$i];
					$field['pharmacy_sales_bill_id'] = $id;
					
					//$discountAmount += $calculatedDiscount;
					$totalAmount += $calculatedTotalAmount;
					
					$this->create(); 
					if($this->save($field)){
						
						//update pharmacy Item
						$deductStock = $deductStock+$saveStock;//10 40
						$pharmacyStock = $item['PharmacyItem']['stock'] ; //60
						$pharmacyLooseStock = $item['PharmacyItem']['loose_stock'];
							
						if($type == "Tab"){
							//for pharmacy Item
							$totalPharmacyTabs = ($pharmacyStock * $pack) + $pharmacyLooseStock;
							$remPharTabs = $totalPharmacyTabs - $deductStock;
							$currentPharStock = floor($remPharTabs / $pack);			//pack stock
							$loosePharStock = $remPharTabs % $pack;					//loose stock
						}else{
							//for pharmacy Item
							$currentPharStock = $pharmacyStock - $deductStock;			//pack stock
							$loosePharStock = $pharmacyLooseStock;					//loose stock
						}
						
						$pharData = array();
						$pharmacyData['stock'] = $currentPharStock;
						$pharmacyData['loose_stock'] = $loosePharStock;

						$pharmacyItem->id = $item['PharmacyItem']['id']; 
						$pharmacyItem->save($pharmacyData);
						$pharmacyItem->id = ""; 
						$this->id = '';
					}
				}else{ //if $qty == 0
		 			break;
		 		} 
			}


				/*$field = array();
				if($qty!=0){
					//insert into sales bill details
					$field['item_id'] = $data['item_id'][$i];
					$field['qty'] = $qty;
					$field['batch_number'] = $itemRate['PharmacyItemRate']['batch_number'];
					$field['mrp'] = $data['mrp'][$i];
					$field['qty_type'] = $data['itemType'][$i];
					$field['discount'] = $data['itemWiseDiscountAmount'][$i];
					$field['pack'] = $data['pack'][$i];
					$field['sale_price'] = $data['rate'][$i];
					$field['expiry_date'] = DateFormatComponent::formatDate2STD($data['expiry_date'][$i],Configure::read('date_format'));
					$field['tax'] = $data['tax'][$i];
					$field['pharmacy_sales_bill_id'] = $id;
				
                                        $calculatedTotalAmount = ($field['mrp']/$field['pack'])*$field['qty']; 
                                        $totalAmount += $calculatedTotalAmount;
					$this->create(); 
					if($this->save($field)){
						$pack = $data['pack'][$i];
						$pharmacyStock = $item['PharmacyItem']['stock'];
						$pharmacyLooseStock = $item['PharmacyItem']['loose_stock']; 
						 
						$pharmacyItemStock = $itemRate['PharmacyItemRate']['stock'];
						$pharmacyItemLooseStock = $itemRate['PharmacyItemRate']['loose_stock'];
						
						if($type == "Tab"){
							//for pharmacy Item
							$totalPharmacyTabs = ($pharmacyStock * $pack) + $pharmacyLooseStock;
							$remPharTabs = $totalPharmacyTabs - $qty;
							$currentPharStock = floor($remPharTabs / $pack);			//pack stock
							$loosePharStock = $remPharTabs % $pack;			
							
							//for pharmacy Item Rate
							$totalPharmacyItemTabs = ($pharmacyItemStock * $pack) + $pharmacyItemLooseStock;
							$remPharItemTabs = $totalPharmacyItemTabs - $qty;
							$currentPharItemStock = floor($remPharItemTabs / $pack);		//pack stock
							$loosePharItemStock = $remPharItemTabs % $pack;					//loose stock
							$reorderLevel = $item['PharmacyItem']['reorder_level'] * $pack; // TabletWise reorderLevel
						}else{
						
							//for pharmacy Item
							$currentPharStock = $pharmacyStock - $qty;			//pack stock
							$loosePharStock = $pharmacyLooseStock;					//loose stock
								
							//for pharmacy Item Rate
							$currentPharItemStock = $pharmacyItemStock - $qty;	//pack stock
							$loosePharItemStock = $pharmacyItemLooseStock;			//loose stock
							$totalPharmacyTabs = $currentPharStock;
							$reorderLevel = $item['PharmacyItem']['reorder_level']; // pack wise reorderLevel
						}
						
						$pharData = array();
						$pharmacyItem->id =   $item['PharmacyItem']['id'];
						$pharData['stock'] = $currentPharStock;
						$pharData['loose_stock'] = $loosePharStock;
						
						$pharmacyItem->save($pharData);
						$pharmacyItem->id = "";
						
						$pharItemData = array();
						$pharmacyItemRate->id = $itemRate['PharmacyItemRate']['id'];
						$pharItemData['stock'] = $currentPharItemStock;
						$pharItemData['loose_stock'] = $loosePharItemStock;
						$pharmacyItemRate->save($pharItemData);
						$pharmacyItemRate->id = "";
					}
				}else{ //if $qty == 0
		 			break;
		 		}  */
		}  
        $returnArray = array('total'=>$totalAmount,'discount'=>$discountAmount); 
		return $returnArray; 
	}

}
?>