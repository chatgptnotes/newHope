<?php
/**
 * WardModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       PharmacyItem Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class PharmacyItem extends AppModel {

	public $name = 'PharmacyItem';


	public $hasMany = array(
		'InventoryPurchaseItemDetail' => array(
		'className' => 'InventoryPurchaseItemDetail',
		'dependent' => true,
		'foreignKey' => 'item_id',
		)
	);
	public $hasOne = array(
		'PharmacyItemRate' => array(
		'className' => 'PharmacyItemRate',
		'dependent' => true,
		'foreignKey' => 'item_id'
		)
	);
	 public $validate = array(
		/*'name' => array(
		 'isUnique' => array (
            'rule' => array('checkUniqueName'),
				'on' => 'create',
            'message' => 'This name already exists.'
        )

		),*/
		'item_code' => array(
		 'isUnique' => array (
            'rule' => array('checkUniqueCode'),
				'on' => 'create',
            'message' => 'Item Code must be unique.'
        )
		)
    );
 
	 
	function checkUniqueName() {
		$session = new cakeSession();
		return ($this->find('count', array('conditions' => array('PharmacyItem.is_deleted'=>0,'PharmacyItem.name' => $this->data['PharmacyItem']['name'],"PharmacyItem.location_id" => $session->read('locationid')))) ==0);
	}

	function checkUniqueCode() {
	 	$session = new cakeSession();
		/*if(!empty($this->data['PharmacyItem']['item_code'])){//
			return ($this->find('count', array('conditions' => array('PharmacyItem.is_deleted'=>0,'PharmacyItem.item_code' => $this->data['PharmacyItem']['item_code'],"PharmacyItem.location_id" => $session->read('locationid')))) ==0);
		}*/ //by pankaj

		return true ;
	}
	/**
 * for delete insurance type.
 *
 */


	function beforeSave(){
		if (isset($this->data[$this->alias]['name'])) {
			$this->data[$this->alias]['name'] = trim($this->data[$this->alias]['name']);
		}
		return true ;
	}

      public function deletePharmacyItem($postData) {

      	$this->id = $postData;
      	$this->data["PharmacyItem"]["id"] =$postData;
      	$this->data["PharmacyItem"]["is_deleted"] = '1';
      	$this->save($this->data);

		//delete item rate also 
		$pharmacyItemRate= Classregistry::init('PharmacyItemRate');
		$pharmacyItemRate->updateAll(array('PharmacyItemRate.is_deleted'=>1),array('item_id'=>$postData));
      	return true;
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

	function importData(&$dataOfSheet){
 		$item_rate_master = Classregistry::init('PharmacyItemRate');
		$supplier = Classregistry::init('InventorySupplier');
		$product=ClassRegistry::init('Product');
		$manufacturer=ClassRegistry::init('ManufacturerCompany');
		$vatclass=ClassRegistry::init('VatClass');
		$configuration=ClassRegistry::init('Configuration');
 		$session = new cakeSession();
		$dataOfSheet->row_numbers=false;
		$dataOfSheet->col_letters=false;
		$dataOfSheet->sheet=0;
		$dataOfSheet->table_class='excel';
		  
		$website_service_type = $configuration->find('first',array('conditions'=>array('Configuration.name'=>'website')));
		$websiteConfig=unserialize($website_service_type['Configuration']['value']);
		
					for($row=2;$row<=$dataOfSheet->rowcount($dataOfSheet->sheet);$row++) {
						
					 $item_name = addslashes(trim( $dataOfSheet->val($row,1,$dataOfSheet->sheet))); if(!$item_name) continue;
					 $item_code = trim( $dataOfSheet->val($row,2,$dataOfSheet->sheet));
                     $mfg = trim( $dataOfSheet->val($row,3,$dataOfSheet->sheet));
                     $pack = trim( $dataOfSheet->val($row,4,$dataOfSheet->sheet));
                     $generic = (trim( $dataOfSheet->val($row,5,$dataOfSheet->sheet)));
					 $stock = trim( $dataOfSheet->val($row,6,$dataOfSheet->sheet));
                     $batch_no= trim( $dataOfSheet->val($row,7,$dataOfSheet->sheet));
                     $expiryDate = $dataOfSheet->val($row,8,$dataOfSheet->sheet);
                     
                    if(!empty($expiryDate)){
                     	$splitExpiry = explode("/",$expiryDate);
                     	$resetExpiryDate = $splitExpiry[2]."-".$splitExpiry[0]."-".$splitExpiry[1];
                     	//$resetExpiryDate = $splitExpiry[2]."-".$splitExpiry[1]."-".$splitExpiry[0];
                     }//debug($expiryDate);debug($splitExpiry);debug($resetExpiryDate);exit;
                     //$resetExpiryDate = substr($expiryDate,0,4);
                    /* $exYear = substr($expiryDate,0,4);
                     $exMonth = substr($expiryDate,4,2);
                     $exDate = substr($expiryDate,6,2);
                     $resetExpiryDate = $exYear."-".$exMonth."-".$exDate;*/
                      
                     $expiry_date=trim($resetExpiryDate);
                     $mrp = trim( $dataOfSheet->val($row,9,$dataOfSheet->sheet));
                      
                     if($websiteConfig['instance'] == "kanpur"){
                     	$vatClassName = trim( $dataOfSheet->val($row,10,$dataOfSheet->sheet));
                     }else{
                     	$tax = trim( $dataOfSheet->val($row,10,$dataOfSheet->sheet));
                     }
					 $mstpflag=trim( $dataOfSheet->val($row,11,$dataOfSheet->sheet));
					 $purchase_price = trim( $dataOfSheet->val($row,12,$dataOfSheet->sheet));
					 $cst = trim( $dataOfSheet->val($row,13,$dataOfSheet->sheet));
					 $costprice = trim( $dataOfSheet->val($row,14,$dataOfSheet->sheet));
					 $saleprice = trim( $dataOfSheet->val($row,15,$dataOfSheet->sheet));

                     $code = (trim( $dataOfSheet->val($row,16,$dataOfSheet->sheet)));
					 $supplier_name = addslashes(trim( $dataOfSheet->val($row,17,$dataOfSheet->sheet)));
					 $address = addslashes(trim( $dataOfSheet->val($row,18,$dataOfSheet->sheet)));
					 $dl = (trim( $dataOfSheet->val($row,19,$dataOfSheet->sheet)));
                     $dl_21 = (trim( $dataOfSheet->val($row,20,$dataOfSheet->sheet)));
					 $stax = (trim( $dataOfSheet->val($row,21,$dataOfSheet->sheet)));
					 $cst_supplier = (trim( $dataOfSheet->val($row,22,$dataOfSheet->sheet)));
					 $phone = (trim( $dataOfSheet->val($row,23,$dataOfSheet->sheet)));
					 $crlimit = (trim( $dataOfSheet->val($row,24,$dataOfSheet->sheet)));
					 $crday = (trim( $dataOfSheet->val($row,25,$dataOfSheet->sheet)));
					 $bank = (trim( $dataOfSheet->val($row,26,$dataOfSheet->sheet)));
					 $pin = (trim( $dataOfSheet->val($row,27,$dataOfSheet->sheet)));
					 $mobile = (trim( $dataOfSheet->val($row,28,$dataOfSheet->sheet)));
					 $email = (trim( $dataOfSheet->val($row,29,$dataOfSheet->sheet)));
					 $expensive_product = (trim($dataOfSheet->val($row,30,$dataOfSheet->sheet)));
					 $vat = (trim($dataOfSheet->val($row,31,$dataOfSheet->sheet)));
					 $sat = (trim($dataOfSheet->val($row,32,$dataOfSheet->sheet)));
					 $productName = (trim($dataOfSheet->val($row,33,$dataOfSheet->sheet)));
					 $is_implant = (trim($dataOfSheet->val($row,34,$dataOfSheet->sheet)));

					 $supplier_id= "";
					 $item_id="";
					 $vat_class_id = "";
					 
					  
					// MSU Stock calculation
					 $myStock = floor($stock/$pack);
					 $myLooseStock = $stock % $pack;
					 // END
					 
					 //debug($stock);
					 //debug($totalStock);
					 /* debug($myStock);
					 debug($myLooseStock);
					 
					exit;  */
					 
					if(empty( $myStock))
						 $myStock = "0";
					if(empty($mrp))
						$mrp = "0.00";
					if(empty($tax))
						$tax = "0";
					if(empty($purchase_price))
						$purchase_price = "0.00";
					if(empty($costprice))
						$costprice = "0.00";
					if(empty($saleprice))
						$saleprice = "0.00";

					 $createtime = date("Y-m-d H:i:s");
					 $createdby = $session->read('userid');
						
					 /* In Kanpur for VatClass */
					 $vat_class = $vatclass->find('first',array('conditions'=>array('VatClass.vat_of_class'=>$vatClassName,
					 							/* 'VatClass.location_id'=>$session->read('locationid') */)));
					 
					 if(!empty($vat_class)){
					 	$vat_class_id = $vat_class['VatClass']['id'];
					 }else{
					 	$vatclass->create();
					 	$vatclass->save(array(
					 			/* "location_id"=>$session->read('locationid'), */
					 			"vat_of_class"=>$vatClassName,
					 			"vat_percent"=>$vat,
					 			"sat_percent"=>$sat,
					 			"created_by"=>$createdby,
					 			"created_time"=>$createtime,
					 			));
					 	$vat_class_id = $vatclass->id;
					 }
					 
					 
					 /* for Supplier*/ ;
					 $supplier_in = $supplier->find("first",array("conditions" =>array("InventorySupplier.name"=>$supplier_name,
					 		"InventorySupplier.location_id"=>$session->read('locationid'))));
					 if(!empty($supplier_in)){
						$supplier_id = $supplier_in['InventorySupplier']['id'];
					 }else{
						$supplier->create();
						$supplier->save(array(
							"location_id"=>$session->read('locationid'),
							"name"=>$supplier_name,
							"code"=>$code,
							"credit_limit"=>$crlimit,
							"credit_day"=>$crday,
							"bank"=>$bank,
							"pin"=>$pin,
							"mobile"=>$mobile,
							"email"=>$email,
							"create_time"=> $createtime,
							"created_by"=>$createdby,
							"phone"=>$phone,
							"cst" =>$cst_supplier,
							"stax_no" =>$stax,
							"dl_no" =>$dl ,
                            "dl21_no" =>$dl_21 ,
							"address" =>$address
							));
						$supplier_id = $supplier->id;
					 }
					 
					 /* for manufacturer */ ; 
					 //BOF manu					 
					 $manufacturer->id= '';
					 if(!empty($mfg)){
					 	$manuRec = $manufacturer->find('first',array('conditions'=>array('name'=>$mfg,'is_deleted'=>0,'location_id'=>$session->read('locationid'))));
					 	if(!empty($manuRec['ManufacturerCompany']['id'])){
					 		$manufacturer_id = $manuRec['ManufacturerCompany']['id'];
					 	}else{
					 		$manufacturer_id = $manufacturer->insertManufacturer(array('name'=>$mfg,'location_id'=>$session->read('locationid')));
					 	}
					 }
					 
					 //if(!$manufacturer_id) return ;
					 
					 
					 
					 //echo "manu=".$manufacturer_id."<br>" ; 
					 //EOF manu 
					  

					 /* For finding the product */
					 $drug_id='';
					 $productid=$product->find('first',array('conditions'=>array('Product.name'=>$item_name,'Product.location_id'=>$session->read('locationid'))));
					 			
					 	
					 if(!empty($productid)){
					 	
					 		$productData = array();
					 		$drug_id = $productid['Product']['id'];
					 		$productData['Product']['id'] = $productid['Product']['id'];
					 		$productData['Product']['name'] = $productid['Product']['name'];
					 		$productData['Product']['quantity'] = (int)$productid['Product']['quantity']+$myStock;
					 		$productData['Product']['manufacturer_id'] = $manufacturer_id;
					 		$productData['Product']['supplier_id']=$supplier_id;
					 		$productData['Product']['minimum']="10";
					 		//$productData['Product']['maximum']=$reorderLevel;
					 		$productData['Product']['pack'] =  $pack;
					 		$productData['Product']['mrp'] =  $mrp;
					 		$productData['Product']['sale_price'] =  $saleprice;
					 		$productData['Product']['cost_price'] =  $costprice;
					 		//$productData['Product']['generic'] =  $generic;
					 		$productData['Product']['cst'] =  $cst;
					 		$productData['Product']['stock'] =  (int)$productid['Product']['stock']+$myStock;
					 		$productData['Product']['loose_stock'] = (int)$productid['Product']['loose_stock']+$myLooseStock;
					 		$productData['Product']['vat_class_id'] = $vat_class_id;
					 		$productData['Product']['expensive_product'] = $expensive_product;
					 		$productData['Product']['is_implant'] = $is_implant;
					 		$productData['Product']['location_id'] = $productid['Product']['location_id'];
					 		
					 		$product->save($productData);
					 		
					 }else if(!empty($item_name)){
					 	
					 	$product->id='';
					 	$product->save(array(
					 			"date"=>date('Y-m-d'),
					 			"name"=>$item_name,
					 			"quantity"=>$myStock,
					 			"supplier_id"=>$supplier_id,
					 			"pack"=>$pack,
					 			"minimum"=>"10",//defualt qty for minimum qty
					 			"maximum"=>"10",//default qty for requistion order qty 
					 			"reorder_level"=>"0",
					 			"target"=>$myStock,
					 			"product_code"=>$item_code,
					 			"location_id"=>$session->read('locationid'),
					 			"generic"=>$generic,
					 			"expiry_date"=>$expiry_date,
					 			"mrp"=>$mrp,
					 			"purchase_price"=>$purchase_price,
					 			"cst"=>$cst,
					 			"cost_price"=>$costprice,
					 			"sale_price"=>$saleprice,					 			
					 			"manufacturer_id"=>$manufacturer_id,					 				 			
					 			"expensive_product"=>$expensive_product,
					 			"is_implant"=>$is_implant,
					 			"vat_class_id"=>$vat_class_id,
					 			"stock"=>$mystock,
					 			"loose_stock"=>$myLooseStock
					 	));
					 	$drug_id = $product->getLastInsertID();
					 }
					 
					 
					 
					 /* for Pharmacy Item*/
					 $item = $this->find("first",array("conditions" =>array("PharmacyItem.name"=>$item_name,"PharmacyItem.item_code"=>$item_code,
					 		"PharmacyItem.location_id"=>$session->read('locationid'))));
						
					 if(!empty($item)){
						$item_id = $item['PharmacyItem']['id'];
						//$item['PharmacyItem']['product_name'] = $productName; // for Kanpur MARG
                        $item['PharmacyItem']['manufacturer'] =  $mfg;
                        $item['PharmacyItem']['manufacturer_company_id'] = $manufacturer_id;
                        $item['PharmacyItem']['supplier_id']=$supplier_id;
                        $item['PharmacyItem']['drug_id']=$drug_id;
                        $item['PharmacyItem']['pack'] =  $pack;
                        //$item['PharmacyItem']['generic'] =  $generic;
                        $item['PharmacyItem']['stock'] =  (int)$item['PharmacyItem']['stock']+$myStock;
                        $item['PharmacyItem']['loose_stock'] = (int)$item['PharmacyItem']['loose_stock']+$myLooseStock;
                        $item['PharmacyItem']['vat_class_id'] = $vat_class_id;
                        $item['PharmacyItem']['expensive_product'] = $expensive_product;
                        $item['PharmacyItem']['is_implant'] = $is_implant;
                        
                        $this->save($item);
					 }else{ 
						$this->create();
						$this->save(array(
							"location_id"=>$session->read('locationid'),
							"name"=>$item_name,
							"product_name"=>$productName,                  // This Product name for Kanpur MARG
							"supplier_id"=>$supplier_id,
							"item_code"=>$item_code,
							"drug_id"=>$drug_id,
							"pack"=>$pack,
						 	"manufacturer"=>$mfg,
							"manufacturer_company_id"=>$manufacturer_id,
							"generic"=>$generic,
							"stock"=>$myStock,
							"loose_stock"=>$myLooseStock,
							"create_time"=> $createtime,
							"created_by"=>$createdby,
							"expensive_product"=>$expensive_product,
							"is_implant"=>$is_implant,
							"vat_class_id"=>$vat_class_id
							 ));
						$item_id = $this->id;
					 }
					
					
					 

                        $rate = $item_rate_master->find("first",array("conditions" =>array("PharmacyItemRate.item_id"=>$item_id,
                        		"PharmacyItemRate.batch_number"=>$batch_no,
                        		"PharmacyItemRate.location_id"=>$session->read('locationid'))));
                       
                         if(!empty($rate)){
                             $item_rate_master->save(array(
    							"id"=>$rate['PharmacyItemRate']['id'],
    							"mrp"=>$mrp,
    							"tax"=>$tax,
    							"purchase_price"=>$purchase_price,
    							"cst"=>$cst,
                             	"stock"=>$rate['PharmacyItemRate']['stock']+$myStock,
                             	"loose_stock"=>$myLooseStock,
                             	"expiry_date"=>$expiry_date,
    							"cost_price"=>$costprice,
    							"sale_price"=> $saleprice,
                                "mstpflag"=>$mstpflag,
                             	"vat_class_id"=>$vat_class_id,
								"location_id"=>$session->read('locationid'),
    						 ));
						
                         }else{
    						 $item_rate_master->create();
    						 $item_rate_master->save(array(
    						 	"location_id"=>$session->read('locationid'),
    							"item_id"=>$item_id,
    							"mrp"=>$mrp,
                                "batch_number"=>$batch_no,
                                "expiry_date"=>$expiry_date,
    							"tax"=>$tax,
    							"purchase_price"=>$purchase_price,
    							"cst"=>$cst,
    						 	"stock"=>$myStock,
    						 	"loose_stock"=>$myLooseStock,
    							"cost_price"=>$costprice,
    							"sale_price"=> $saleprice,
                                "mstpflag"=>$mstpflag,
    						 	"vat_class_id"=>$vat_class_id

    						 ));
                        }

				}
			 
				return true ;

			}
			
			public function updateStockInPharmacy($data,$locationId){
				
				$PharmacyItem = $this->find('first',array('fields'=>array('id','drug_id','stock'),'conditions'=>array('PharmacyItem.drug_id'=>$data['product_id'],'PharmacyItem.location_id'=>$locationId,'PharmacyItem.is_deleted'=>0)));
				//if name is there withour drug id
					
				if(empty($PharmacyItem['PharmacyItem']['id'])){
					$PharmacyItem = $this->find('first',array('fields'=>array('id','drug_id','stock'),'conditions'=>array('PharmacyItem.name'=>trim($data['name']),'PharmacyItem.location_id'=>$locationId,'PharmacyItem.is_deleted'=>0)));
				}
				
				$pharmacyItemRateDetail  =array();
				$PharmacyItemDetail  =array();
				if(empty($data['return_qty'])){
					$return_Qty = $data['return_quantity']; 
				}else{
					$return_Qty = $data['return_qty'];
				}
				if(!empty($PharmacyItem['PharmacyItem']['id'])){	//if drug_id == product_id
					$this->PharmacyItemRate->id = '';
					$PharmacyItemRateData = $this->PharmacyItemRate->find('first',array('conditions'=>array('batch_number'=>$data['batch_number'],'item_id'=>$PharmacyItem['PharmacyItem']['id'])));
					$pack = (int)$data['pack'];
					
					if(!empty($PharmacyItemRateData['PharmacyItemRate']['id'])){
						//update stock having same batch number in pharmacy rate
						$pharmacyItemRateDetail['id']= $PharmacyItemRateData['PharmacyItemRate']['id'];
							
						$itemRateWholeStock = (($PharmacyItemRateData['PharmacyItemRate']['stock'] * $pack) + $PharmacyItemRateData['PharmacyItemRate']['loose_stock']) - $return_Qty;
						$pharmacyItemRateDetail['stock'] = floor($itemRateWholeStock / $pack);
						$pharmacyItemRateDetail['loose_stock'] = floor($itemRateWholeStock % $pack);
						//debug($pharmacyItemRateDetail);exit;
						$this->PharmacyItemRate->save($pharmacyItemRateDetail);		//save or update into pharmacy_item_reate
						$this->PharmacyItemRate->id = '';
					}
					$itemWholeStock = (($PharmacyItem['PharmacyItem']['stock'] * $pack) + $PharmacyItem['PharmacyItem']['loose_stock']) - $return_Qty;
						
					$PharmacyItemDetail['PharmacyItem']['stock'] = floor($itemWholeStock / $pack);
					$PharmacyItemDetail['PharmacyItem']['loose_stock'] = floor($itemWholeStock % $pack);
					
					$PharmacyItemDetail['PharmacyItem']['id'] = $PharmacyItem['PharmacyItem']['id'];
					$PharmacyItemDetail['PharmacyItem']['drug_id'] = $data['product_id'];
					$this->save($PharmacyItemDetail);
					$this->id = '';
				}
			}
			
			
			
		/*public function getCompOpeningStock($fromDate,$toDate) {
			$this->find('all',array('conditions'=>array('PharmacyItem.')))
		}// END of function	getCompOpeningStock*/
	}
?>