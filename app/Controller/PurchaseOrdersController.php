<?php 
class PurchaseOrdersController extends AppController 
{	
	var $name = "PurchaseOrders";
	public $uses = array("InventorySupplier","PurchaseOrder","PurchaseOrderItem","Product","StockAdjustment","ContractProduct","Contract","ProductRate");
	public $helpers = array('Html','Form', 'Js','DateFormat','Number','General','PhpExcel');
	public $components = array('General');
	//for adding the good received note use ctp - (ajax_add_purchase_receipt_items) from getDetails function
	
	
	/*
	 * 
		Add Purchase Order 
		by Swapnil G.Sharma
	 *  
	 */ 
	public function add_order()
	{
		$this->layout='advance';
		$this->set('purchase_order_number',$this->PurchaseOrder->GeneratePurchaseOrderId()); //set the purchase_order_number
		
		$this->loadModel('StoreLocation');
		$this->loadModel('Configuration');
		$this->loadModel('VatClass');
		
		//Store Locations
		$storeLocation = ($this->StoreLocation->find('list',array('fields'=>array('id','name'),'conditions'=>array('allow_purchase'=>1))));
		$this->set('storeLocation',$storeLocation);
		
		//website Instance
		$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website'))); 
		$websiteConfig=unserialize($website_service_type['Configuration']['value']);
		$this->set('websiteConfig',$websiteConfig);
		
		//Vat Classes
		$vatAllData = $this->VatClass->find('all',array('fields'=>array('VatClass.id','VatClass.vat_of_class','VatClass.sat_percent','VatClass.vat_percent'),'conditions'=>array('VatClass.is_delete'=>'0')));
		
		foreach ($vatAllData as $key=>$val){
			$vatAllDataOption[$val['VatClass']['id']] = $val['VatClass']['vat_of_class'];
			$vatAllDatavalue[$val['VatClass']['id']] = $val['VatClass']['vat_percent']+$val['VatClass']['sat_percent'];
		}
		
		$this->set('dataValue',json_encode($vatAllDatavalue));
		$this->set('vatAllData',json_encode($vatAllDataOption));
		$this->set('vatAll',$vatAllDataOption);
		
		if(!empty($this->params->query['Orderlist']))
		{
			$query_id = explode("-",$this->params->query['Orderlist']);
			$product = $this->Product->find('all',array('conditions'=>array('Product.id'=>$query_id)));
			$this->set('products',$product);	
		}
		
		if(!empty($this->request->data))
		{ 
			$orderFor = $this->request->data['order_for'];	// 1 for store location & 2 for pharmacy
			$generatePONo = $this->PurchaseOrder->GeneratePurchaseOrderId();
			$this->request->data['purchase_order']['purchase_order_number'] = $generatePONo;
			$POdata = $this->request->data['purchase_order'];
			$lastInsertedId = $this->PurchaseOrder->Insert($POdata);   //last id of purchase order
			
			if(!empty($lastInsertedId))
			{
				if(!empty($this->request->data['purchase_order']['contract_id']))
				{
					$contracts = $this->Contract->find('first',array('conditions'=>array('Contract.id'=>$this->request->data['purchase_order']['contract_id'])));
					$minAmount = $contracts['Contract']['min_po_amount'];	//fetch the minimum amount for this contract from contrct table
					$maxAmount = $contracts['Contract']['max_po_amount'];
					$totalAmount = $this->request->data['purchase_order']['total_amount']; 
					if($totalAmount  >= $minAmount && $totalAmount  <= $maxAmount)
					{
						foreach($this->request->data['purchase_order_item'] as $key => $value)
						{
							if(!empty($value['product_id']))
							{
								$value['purchase_order_id'] = $lastInsertedId;
								$value['purchase_price'] = $value['purchase_price'];
								$value['status'] = 1;		//in open state
								$this->PurchaseOrderItem->save($value);
								$this->PurchaseOrderItem->id = '';
							}
						}
					}	
				}else{
					//do something for non contract
					foreach($this->request->data['purchase_order_item'] as $key => $value)
					{	
						/*if(empty($value['product_id']) || $value['product_id']==0){
							//add into product if product doesnot exists
							$isExistProduct = $this->Product->find('first',array('conditions'=>array('Product.name'=>$value['product_name'])));
							if($isExistProduct['Product']['id']){
								$value['product_id'] = $isExistProduct['Product']['id']; 
							}else{
								//insert into product and fetch lastinserted id and update to drug_id in pharmacy item
								$pData = array();
								$pData['name'] = $value['product_name'];
								$pData['pack'] = $value['pack'];
								$pData['batch_number'] = $value['batch_number'];
								$pData['mrp'] = $value['mrp'];
								$pData['purchase_price'] = $value['purchase_price'];
								$pData['tax'] = $value['product_name'];
								$this->Product->save($pData);
								$this->Product->id = '';
								$value['product_id'] = $this->Product->getLastInsertID();
							}
						}*/ 
						
						if(!empty($value['product_id']))
						{
							//$this->Product->updatePurchasePriceFromPurchaseOrder($value['product_id'],$value['purchase_price']); //update purchase Price in product
							$KeyData['purchase_order_id'] = $lastInsertedId;
							$KeyData['product_id'] = $value['product_id'];
							$KeyData['mrp'] = $value['mrp'];
							$KeyData['selling_price'] = $value['selling_price'];
							$KeyData['purchase_price'] = $value['purchase_price'];
							$KeyData['quantity_order'] = $value['quantity_order'];
							$KeyData['batch_number'] = $value['batch_number'];
							$KeyData['expiry_date'] = $value['expiry_date'];
							$KeyData['tax'] = $value['tax'];
							$KeyData['vat_class_id'] = $value['vat_class_id'];
							$KeyData['amount'] = $value['amount'];
							$KeyData['status'] = 1;
							$this->PurchaseOrderItem->save($KeyData);
							$this->PurchaseOrderItem->id = '';
						}else{
							$this->Session->setFlash(__('Product doesnot exist'), 'default', array('class'=>'error'));
							$this->redirect($this->referer());
						}
					}
				}	
			}	
				 
			/*$url = Router::url(array("controller" => "PurchaseOrders", "action" => "printPurchaseOrder",$lastInsertedId,'admin'=>false));
			echo "<script>window.open('".$url."','','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true )</script>";
			exit;*/
			/* Redirect to GRN */
			if($this->request->data['receive']){
				$this->Session->setFlash(__("Purchase Order has been saved successfully for PO No: <b>".$generatePONo."</b>", true),'default',array('class'=>'stillSuccess','id'=>'stillFlashMessage'),'still');
				//$this->Session->setFlash(__('Purchase Order has been saved successfully', true));
				$this->redirect(array('action'=>'purchase_receipt',$lastInsertedId/* ,'?'=>array('print'=>'print','page'=>'order','id'=>$lastInsertedId) */));
			}
			
			$this->Session->setFlash(__("Purchase Order has been saved successfully for PO No: <b>".$generatePONo."</b>", true),'default',array('class'=>'stillSuccess','id'=>'stillFlashMessage'),'still');
			//$this->Session->setFlash(__('Purchase Order has been saved successfully', true));
			$this->redirect(array('action'=>'purchase_order_list'/* ,'?'=>array('print'=>'print','page'=>'order','id'=>$lastInsertedId) */));
		}  	
	}
	
	/*
	 * 
	 * Purchase Order List
	 */
	
	public function purchase_order_list()
	{  
		$this->layout ='advance';
		//$this->loadModel('StoreLocation');
		$this->PurchaseOrder->bindModel(array('belongsTo'=>array(
				'InventorySupplier'=>array('foreignKey'=>'supplier_id',
											'fields'=>array('InventorySupplier.name')),
				'StoreLocation'=>array('foreignKey'=>'order_for',
											'fields'=>array('StoreLocation.name'))
											)));
		$conditions = array();
		$conditions['PurchaseOrder.location_id'] = $this->Session->read('locationid');
		$conditions['PurchaseOrder.is_deleted'] = 0;
		
		if($this->request->query){
			$this->request->data['PurchaseOrder'] = $this->request->query; 
			if(!empty($this->request->data['PurchaseOrder']['status']) && $this->request->data['PurchaseOrder']['status']!= ""){			
				$conditions['PurchaseOrder.status'] = $this->request->data['PurchaseOrder']['status']; 
			}
			if(!empty($this->request->data['PurchaseOrder']['supplier_id']) && $this->request->data['PurchaseOrder']['supplier_id']!=""){			
				$conditions['PurchaseOrder.supplier_id'] = $this->request->data['PurchaseOrder']['supplier_id']; 
			}
			if(!empty($this->request->data['PurchaseOrder']['purchase_order_id']) && $this->request->data['PurchaseOrder']['purchase_order_id']!=""){
				$conditions['PurchaseOrder.id'] = $this->request->data['PurchaseOrder']['purchase_order_id']; 
			}
		} 
		$this->paginate = array('limit' => Configure::read('number_of_rows'),
								'order' => array('PurchaseOrder.status'=>'desc','PurchaseOrder.create_time' => 'desc'),
								'conditions' => $conditions,
								'fields'=>array('InventorySupplier.name','PurchaseOrder.*','StoreLocation.name'));
		
		$result = $this->paginate('PurchaseOrder');
		
		//$result = $this->PurchaseOrder->find('all',array('fields'=>array('InventorySupplier.name','PurchaseOrder.*')));
		
		$this->set('PurchaseOrder',$result);
	}
	
	
	/*
	 * 
	 * View Purchase Order 
	 * 
	 */
	
	public function view_purchase_order($id)
	{
		if(!$id)
		{
			throw new NotFoundException(__('Invalid Order Id'));
		}
		else
		{
			$this->PurchaseOrder->bindModel(array('belongsTo'=>array(
					'InventorySupplier'=>array('foreignKey'=>'supplier_id'),
					'StoreLocation'=>array('foreignKey'=>'order_for'))));
		
			$result = $this->PurchaseOrder->find('first',array('fields'=>array('InventorySupplier.name','PurchaseOrder.*','StoreLocation.name'),
															'conditions'=>array('PurchaseOrder.id'=>$id)));
			$this->set('PurchaseOrder',$result);
		
			$this->PurchaseOrderItem->bindModel(array('belongsTo'=>array(
			
				'Product'=>array('foreignKey'=>'product_id',
											'fields'=>array('Product.name','Product.manufacturer_id','Product.pack','Product.batch_number','Product.mrp','Product.quantity')),
				
				'ManufacturerCompany'=>array('foreignKey'=>false,
											'fields'=>array('ManufacturerCompany.name'),
											'conditions'=>array('ManufacturerCompany.id=Product.manufacturer_id')),
			
				'VatClass'=>array('foreignKey'=>false,
											'fields'=>array('VatClass.vat_of_class','VatClass.vat_percent','VatClass.sat_percent'),
											'conditions'=>array('VatClass.id=PurchaseOrderItem.vat_class_id'))
				)));
			
			$item = $this->PurchaseOrderItem->find('all',array('conditions'=>array('PurchaseOrderItem.purchase_order_id'=>$id/*,'PurchaseOrderItem.status'=>1*/)/*,'group'=>array('PurchaseOrderItem.product_id')*/));
			//debug($item);
			$this->set('items',$item);
			
		}
	}
	
	public function purchase_receipt($id=null)
	{
		$this->loadModel("Location");
		$this->layout='advance';
		$storeLocation = $this->Location->getLocationIdByHospital();
		$this->set('storeLocations',$storeLocation);

		if(!empty($this->request->data)){
			if(!empty($this->request->data['excel'])){
				$data = $this->AjaxAllPurchaseReceipts($this->request->data);
				$this->set('PurchaseOrder',$data);
				$this->layout=false;
				$this->set('filename','GRN_LIST_');
				$this->render('purchase_receipt_xls','excel'); 
			}
		}
	}

	function grn_print() {
		$this->loadModel('PurchaseReturn');
		$purchaseReturn = $this->PurchaseReturn->find('all',array('fields'=>array('PurchaseReturn.grn_no','SUM(PurchaseReturn.return_amount) as total'),
							 'group'=>array('PurchaseReturn.purchase_order_id'),'conditions'=>array('PurchaseReturn.is_deleted'=>0)
				));
		
		foreach($purchaseReturn as $key=>$value){ 
			$purchaseReturn[$value['PurchaseReturn']['grn_no']] = $value[0]['total'];
		}
		$this->set('purchaseReturn',$purchaseReturn); 
		$this->set('PurchaseOrder',$this->AjaxAllPurchaseReceipts('excel'));
		$this->render('purchase_receipt_xls','print_without_header');
	}

	public function AjaxAllPurchaseReceipts($data=array())
	{ 
		$this->uses = array('PurchaseReturn','PurchaseOrderItem','PurchaseOrder');
		$this->autoRender = false;
		$this->Layout = 'ajax';
		 
		$this->PurchaseOrderItem->bindModel(array('belongsTo'=>array(
				'PurchaseOrder'=>array('foriegnKey'=>'purchase_order_id'),
				'InventorySupplier'=>array('foreignKey'=>false,
											'conditions'=>array('PurchaseOrder.supplier_id = InventorySupplier.id')),
				'StoreLocation'=>array('foreignKey'=>false,
											'conditions'=>array('PurchaseOrder.order_for = StoreLocation.id'))
											)),false);
		 
		$conditions = array();
		if (!empty($data)) {
			$type=!empty($data['excel'])?'excel':'';
			$conditions['PurchaseOrder.is_deleted'] = 0;
		}
		if($this->request->query){ 	
			$this->request->data = $this->request->query ;
			if(!empty($this->request->data['from_date'])) {
				$fromDate = $this->DateFormat->formatDate2STDForReport($this->request->data['from_date'],Configure::read('date_format'))." 00:00:00";
				$conditions['PurchaseOrderItem.received_date >=']=$fromDate;
				$vatConditions['PurchaseOrder.received_date >='] = $fromDate ;
			} 
			
			if(!empty($this->request->data['to_date'])) {
				$toDate = $this->DateFormat->formatDate2STDForReport($this->request->data['to_date'],Configure::read('date_format'))." 23:59:59";
				$conditions['PurchaseOrderItem.received_date <='] = $toDate; 
				$vatConditions['PurchaseOrder.received_date <='] = $toDate ;
			} 
			
			if(!empty($this->request->data['supplier_id']) && $this->request->data['supplier_id']!=""){			
				$conditions['PurchaseOrder.supplier_id'] = $this->request->data['supplier_id']; 
				$vatConditions['PurchaseOrder.supplier_id'] = $this->request->data['supplier_id'];
			}
			
			if(!empty($this->request->data['grn_no']) && $this->request->data['grn_no']!=""){
				$conditions['PurchaseOrderItem.grn_no'] = $this->request->data['grn_no']; 
			}
			
			if(!empty($this->request->data['store_location']) && $this->request->data['store_location']!=""){
				$conditions['PurchaseOrder.location_id'] = $this->request->data['store_location']; 
				$vatConditions['PurchaseOrder.location_id'] = $this->request->data['store_location'];
			} 
			$conditions['PurchaseOrder.is_deleted'] = 0;
			$vatConditions['PurchaseOrder.is_deleted'] = 0;
			//debug($this->request->data);
		} 
		
		$totalAmt= $this->PurchaseOrderItem->find('all',array('fields'=>'SUM(PurchaseOrderItem.amount) as sum','conditions'=>$conditions));

		//unset($conditions['PurchaseOrderItem.received_date <=']);
		/*unset($conditions['PurchaseOrderItem.received_date >=']);
		unset($conditions['PurchaseOrderItem.grn_no']);*/

		$totalVat= $this->PurchaseOrder->find('all',array('fields'=>'SUM(PurchaseOrder.vat) as sumVat','conditions'=>$vatConditions));

		$this->set('totalVat',$totalVat);
		$this->set('totalAmt',$totalAmt);

		if ($type=='excel' || $data == 'excel') { 
			$result = $this->PurchaseOrderItem->find('all',array(
								'group' => 'PurchaseOrderItem.grn_no',
								'order'=>array('PurchaseOrderItem.received_date'=>'desc'),
								'fields'=>array('InventorySupplier.name','PurchaseOrder.*','PurchaseOrderItem.*','SUM(PurchaseOrderItem.amount) as sum','StoreLocation.name'),
								'conditions'=>array($conditions)
			 					));
			return $result;
		} else { 
			$this->paginate = array('limit' => Configure::read('number_of_rows'),
								'group' => 'PurchaseOrderItem.grn_no',
								'order' =>array('PurchaseOrderItem.received_date'=>'desc'),
								'fields'=>array('InventorySupplier.name','PurchaseOrder.*','PurchaseOrderItem.*','SUM(PurchaseOrderItem.amount) as sum','StoreLocation.name'),
								'conditions'=>array($conditions)
								 );
			$result = $this->paginate('PurchaseOrderItem');
		}
		//debug($result);
	
		$purchaseReturn = $this->PurchaseReturn->find('all',array(
				'fields'=>array('PurchaseReturn.purchase_order_id','SUM(PurchaseReturn.return_amount) as total'),
				'conditions'=>array('PurchaseReturn.purchase_order_item_id NOT'=>0),
				'group'=>array('PurchaseReturn.purchase_order_id')
		));
		
		foreach($purchaseReturn as $key=>$value){
			$purchaseReturnArray[$value['PurchaseReturn']['purchase_order_id']] = $value[0]['total'];
		}
		$this->set('purchaseReturn',$purchaseReturnArray);
		$this->set('PurchaseOrder',$result);
		$this->render('ajax_defaultPurchaseReceipt');
	}
	
	public function getPurchaseOrderNumber($id)
	{
		$this->autoRender = false;
		if(!empty($id))
		{
			$getNumber = $this->PurchaseOrder->find('list',array('conditions'=>array('PurchaseOrder.supplier_id'=>$id),
																'fields'=>array('PurchaseOrder.id','PurchaseOrder.purchase_order_number')));
			echo json_encode($getNumber);
			exit;
		}
	}
	
	public function getItems($id,$itemId = null,$return = null)	//$id holds the the purchase_order_id of purchase_order_items
	{
		// Check If Party Number Exists or not with particular supplier
		if(strtolower($this->Session->read('website.instance')) != "hope"){
			$this->checkPartyNumber($this->request->data);
		}
		//END Of Party Code
		 
		$this->loadModel('StoreLocation');
		$this->autoRender = false;
		$this->Layout = 'ajax';
		$this->loadModel('Configuration');
		$this->loadModel('VatClass');
		$this->loadModel('PurchaseReturn');
		$this->loadModel('PurchaseOrderItem');
		
		$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website'))); 
		$websiteConfig=unserialize($website_service_type['Configuration']['value']);
		$this->set('websiteConfig',$websiteConfig);
		$vatAllData = $this->VatClass->find('all',array('fields'=>array('VatClass.id','VatClass.vat_of_class','VatClass.sat_percent','VatClass.vat_percent'),'conditions'=>array('VatClass.is_delete'=>'0')));
		$this->set('grn_no',$this->PurchaseOrderItem->GenerateGRNno()); //set the purchase_order_number
		
		$this->PurchaseOrder->bindModel(array('belongsTo'=>array(
					//'PurchaseOrderItem'=>array('foreignKey'=>false,'conditions'=>array('PurchaseOrderItem.purchase_order_id = PurchaseOrder.id')),
					'InventorySupplier'=>array('foreignKey'=>'supplier_id',
												'fields'=>array('InventorySupplier.name')),
					'StoreLocation'=>array('foreignKey'=>'order_for',
											'fields'=>array('StoreLocation.name'))
											)));
		
		$PO_Detail = $this->PurchaseOrder->find('first',array('conditions'=>array('PurchaseOrder.id'=>$id)));	//heading

		$this->set('po_details',$PO_Detail);
		$grnId = $this->PurchaseOrderItem->find('first',array('conditions'=>array('PurchaseOrderItem.id'=>$itemId)));
		$this->loadModel('ManufacturerCompany');
		
		if($return == "return"){
		$this->PurchaseOrderItem->bindModel(array('belongsTo'=>array(

				'PurchaseOrder' => array('foreignKey'=>false,
											'fields'=>array('PurchaseOrder.contract_id'),
											'conditions'=>array('PurchaseOrder.id=PurchaseOrderItem.purchase_order_id')),
				'Product'=>array('foreignKey'=>'product_id'),
		
				'ManufacturerCompany'=>array('foreignKey'=>false,
											'fields'=>array('ManufacturerCompany.name'),
											'conditions'=>array('ManufacturerCompany.id=Product.manufacturer_id')),
				'VatClass'=>array('foreignKey'=>false,
											'conditions'=>array('PurchaseOrderItem.vat_class_id = VatClass.id')), 
				'PharmacyItem'=>array('foreignKey'=>false,
											'conditions'=>array('PharmacyItem.drug_id = PurchaseOrderItem.product_id') 
						)
					)));
		
		$items = $this->PurchaseOrderItem->find('all',array(
								'fields'=>array('Product.*','PurchaseOrderItem.*','ManufacturerCompany.*', 'PharmacyItem.id','PharmacyItem.drug_id','PharmacyItem.stock',
										'PharmacyItem.loose_stock','PharmacyItem.pack', 'VatClass.*'),
								'conditions'=>array('PurchaseOrderItem.grn_no'=>$grnId['PurchaseOrderItem']['grn_no']/*,'PurchaseOrderItem.status'=>1*/)));
		}else{
			$this->PurchaseOrderItem->bindModel(array('belongsTo'=>array(
			
					'PurchaseOrder' => array('foreignKey'=>false,
							'fields'=>array('PurchaseOrder.contract_id'),
							'conditions'=>array('PurchaseOrder.id=PurchaseOrderItem.purchase_order_id')),
					'Product'=>array('foreignKey'=>'product_id'),
			
					'ManufacturerCompany'=>array('foreignKey'=>false,
							'fields'=>array('ManufacturerCompany.name'),
							'conditions'=>array('ManufacturerCompany.id=Product.manufacturer_id')),
					'VatClass'=>array('foreignKey'=>false,
							'conditions'=>array('PurchaseOrderItem.vat_class_id = VatClass.id')),
					/* 'PharmacyItem'=>array('foreignKey'=>false,
					 'conditions'=>array('PharmacyItem.drug_id = PurchaseOrderItem.product_id')
					)*/
			)));
			
			$items = $this->PurchaseOrderItem->find('all',array(
					'fields'=>array('Product.*','PurchaseOrderItem.*','ManufacturerCompany.*',/* 'PharmacyItem.id','PharmacyItem.drug_id','PharmacyItem.stock',
					'PharmacyItem.loose_stock','PharmacyItem.pack', */'VatClass.*'),
					'conditions'=>array('PurchaseOrderItem.grn_no'=>$grnId['PurchaseOrderItem']['grn_no']/*,'PurchaseOrderItem.status'=>1*/)));
		}
		
		/* CODE FOR RETURN ON GRN By MRUNAL To DISPLAY RETURN VLUES FROM PURCHASE RETURN TABLE*/
		$this->PurchaseReturn->bindModel(array('belongsTo'=>array(
				'Product'=>array('foreignKey'=>false,
						'fields'=>array('Product.name','Product.purchase_price','Product.mrp','Product.sale_price'),
						'conditions'=>array('PurchaseReturn.product_id = Product.id')),
				 'PurchaseOrderItem'=>array('foreignKey'=>false,
						'conditions'=>array('PurchaseOrderItem.product_id = PurchaseReturn.product_id')), 
				
		)));
		$returnItem = $this->PurchaseReturn->find('all',array(
						'conditions'=>array('PurchaseReturn.is_deleted'=>0,'PurchaseReturn.purchase_order_item_id'=>0,'PurchaseReturn.party_invoice_number'=>$PO_Detail['PurchaseOrder']['party_invoice_number'],
								'PurchaseReturn.batch_number = PurchaseOrderItem.batch_number'),
						 'group'=>array('PurchaseReturn.batch_number')));
		/* END OF RETURN ON GRN CODE*/
		
 		$this->set('grnNos',$grnNo);
 		$this->set('receipt_items',$items);
 		$this->set('returnItem',$returnItem);
 		//$this->render('ajax_add_purchase_receipt_items');
		 
		$this->loadModel('VoucherEntry');
		$this->loadModel('Account');
		$this->loadModel('VoucherLog');
		$this->loadModel('VoucherReference');
		$this->loadModel('StoreLocation');
		$this->loadModel('Product');
		$this->loadModel('ProductRate');
		$this->loadModel('Location');
		$this->loadModel('PharmacyItem');
		$this->loadModel('PurchaseReturn');
		$locationId = $this->Session->read('locationid');
		
		$PharmacyId = $this->StoreLocation->find('first',array('conditions'=>array('StoreLocation.code_name'=>Configure::read('pharmacyCode')),'fields'=>'StoreLocation.id'));
		$apamId = $this->StoreLocation->find('first',array('conditions'=>array('StoreLocation.code_name'=>Configure::read('apamCode')),'fields'=>'StoreLocation.id'));
		$orderFor = $this->request->data['order_for'];	 
		
		if(!empty($apamId) && $orderFor == $apamId['StoreLocation']['id']){
			$PharmacyId = $apamId;
			$locationId = $this->Location->getLocationIdByName(Configure::read('apamCode'));
		}
		
		if($this->request->data)
		{  
			#debug($this->request->data);exit;
			$isPharmacy = false;
			
			/*Code For Purchase Return */
			if($return == 'return'){ 
				
				foreach ($this->request->data['Purchase_return'] as $key=>$datas){
					$productId = $datas['product_id'];
					$grnNo = $datas['grn_no'];
					$purcahseItemId = $itemId;
					
					$return_array = array();
				 	$return_array['purchase_order_id'] = $id;
				 	$return_array['purchase_order_item_id'] = $purcahseItemId;
				 	$return_array['product_id'] = $productId;
				 	$return_array['grn_no'] = $grnNo;
				 	$return_array['return_quantity'] = $datas['return_quantity'];
				 	$return_array['return_amount'] = $datas['total'];
				 	$return_array['batch_number'] = $datas['batch_number'];
				 	$return_array['remark'] = $datas['return_cause'];
				 	$return_array['created_time'] = date('Y-m-d H:i:s');
				 	$return_array['location_id'] = $this->Session->read('locationid');
				 	$return_array['pack'] = $datas['pack'];
				 	
				 	if($return_array['return_quantity'] != 0 || $return_array['return_quantity'] != ''){
				 		$this->PurchaseReturn->save($return_array);
				 		/* updation of stock in product tabel*/
					 	$this->PharmacyItem->updateStockInPharmacy($return_array,$locationId);
					 	/*END Of Updated*/
				 	}
				 }
				
			}else{
				
				$isInvoiceAlreadyExist = $this->PurchaseOrder->find('first',array(
					'fields'=>array(
						'PurchaseOrder.party_invoice_number'),
					'conditions'=>array('status'=>'Closed','party_invoice_number'=>$this->request->data['PurchaseOrder']['party_invoice_number'],
						'supplier_id'=>$this->request->data['inventory_supplier_id'])));
 
				if(!empty($isInvoiceAlreadyExist)){
					$this->Session->setFlash(__("This Invoice number is already exist, make sure you're creating duplicate GRN?<b>", true),'default',array('class'=>'stillSuccess error','id'=>'stillFlashMessage'),'still');
					$this->redirect(array('action'=>'purchase_receipt',$this->request->data['PurchaseOrder']['id']));
				}

				/** END of Purchase Return */
				$this->PurchaseOrder->id = $this->request->data['PurchaseOrder']['id'];
				$this->request->data['PurchaseOrder']['vat'] = $this->data['vat'] + $PO_Detail['PurchaseOrder']['vat'];
				$this->request->data['PurchaseOrder']['total_sgst'] = $this->data['total_sgst'] + $PO_Detail['PurchaseOrder']['total_sgst'];
				$this->request->data['PurchaseOrder']['total_cgst'] = $this->data['total_cgst'] + $PO_Detail['PurchaseOrder']['total_cgst'];
				$this->request->data['PurchaseOrder']['total'] = $this->data['total'] + $PO_Detail['PurchaseOrder']['total'];
				$this->request->data['PurchaseOrder']['discount'] = $this->data['discount'];
				$this->request->data['PurchaseOrder']['net_amount'] = $this->data['net_amount'] + $PO_Detail['PurchaseOrder']['net_amount'];
				$this->request->data['PurchaseOrder']['received_date'] = DateFormatComponent::formatDate2STD($this->request->data['PurchaseOrder']['received_date'],Configure::read('date_format'));
				$this->PurchaseOrder->save($this->request->data['PurchaseOrder']);	//update received date and party_invoice number in PurchaseOrder
			}
			//For Return Item fro GRN
			
			$generateGrnNo = $this->PurchaseOrderItem->GenerateGRNno();
			
			foreach($this->request->data['purchase_return'] as $key=>$datas){
					
				$productId = $datas['product_id'];
				$grnNo = $datas['grn_no'];
					
				$return_array = array();
				$return_array['purchase_order_id'] = $this->request->data['PurchaseOrder']['id'];
				$return_array['product_id'] = $productId;
				$return_array['batch_number'] = $datas['batch_number'];
				$return_array['return_quantity'] = $datas['return_qty'];
				$return_array['expiry_date'] = $datas['expiry_date'];
				$return_array['remark'] = $datas['remark'];
				$return_array['pack'] = $datas['pack'];
				$return_array['vat'] = $datas['vat'];
				$return_array['grn_no'] = $generateGrnNo;
				$return_array['return_amount'] = $datas['returnAmount'];
				$return_array['party_invoice_number'] = $this->request->data['PurchaseOrder']['party_invoice_number'];
				$return_array['created_time'] = date('Y-m-d H:i:s');
				$return_array['location_id'] = $locationId;
				
				$this->PurchaseReturn->save($return_array);
				$this->PurchaseReturn->id= "";
					
			}
			//END OF RETURN ITEM
			
			if(isset($orderFor) && $orderFor==$PharmacyId['StoreLocation']['id']){ //for APAM || Pharmacy purchase
				$isPharmacy = true;
				$this->ReceivedToPharmacy($this->request->data,$locationId);
			} 
			$orderStatus  =  '' ;  
			foreach($this->request->data['purchase_order_item'] as $key => $value)
			{	 
				$data = array(); 
				$product_id = $value['product_id'];
				$purchase_order_id = $this->request->data['PurchaseOrder']['id'];
				//debug($purchase_order_id);
				$val = $this->PurchaseOrderItem->find('first',array('conditions'=>array('PurchaseOrderItem.product_id'=>$product_id,
												'PurchaseOrderItem.purchase_order_id'=>$purchase_order_id),
										'fields'=>array('Sum(PurchaseOrderItem.quantity_received) as received_qty','PurchaseOrderItem.*')));
				$received_qty = $val[0]['received_qty']; 
				$quantity_required = $val['PurchaseOrderItem']['quantity_order'] ; //new quantity order from database
				$quantity_received =  $received_qty + $this->request->data['purchase_order_item'][$key]['quantity_received'] ;
				$data['purchase_order_id'] = $val['PurchaseOrderItem']['purchase_order_id'];
				$data['product_id'] = $val['PurchaseOrderItem']['product_id'];
				$data['expiry_date'] = DateFormatComponent::formatDate2STD($this->request->data['purchase_order_item'][$key]['expiry_date'],Configure::read('date_format'));
				$data['mrp'] = $value['mrp'];
				$data['purchase_price'] = $value['purchase_price'];
				$data['selling_price'] = $value['selling_price'];
				$data['batch_number'] = $value['batch_number'];
				$data['quantity_order'] = $val['PurchaseOrderItem']['quantity_order'];
				$data['quantity_received'] = !empty($this->request->data['purchase_order_item'][$key]['quantity_received'])?$this->request->data['purchase_order_item'][$key]['quantity_received']:0 ;
				$data['stock_available'] = !empty($this->request->data['purchase_order_item'][$key]['quantity_received'])?$this->request->data['purchase_order_item'][$key]['quantity_received']:0 ;
				$data['tax'] = ($this->request->data['purchase_order_item'][$key]['tax']) ? $this->request->data['purchase_order_item'][$key]['tax'] : $val['PurchaseOrderItem']['tax'] ;

				$data['sgst'] = $this->request->data['purchase_order_item'][$key]['sgst'];
				$data['cgst'] = $this->request->data['purchase_order_item'][$key]['cgst'];
				$data['gst_amount'] = $this->request->data['purchase_order_item'][$key]['vat'];; 

				$data['free'] = $value['free'];
				$data['grn_no'] = $generateGrnNo;
				$data['party_invoice_number'] = $this->request->data['PurchaseOrder']['party_invoice_number'];
				$data['received_date'] = $this->request->data['PurchaseOrder']['received_date'];
				$data['amount'] = $value['amount'];
				$data['discount'] = $value['discount'];
				$data['discount_amount'] = $value['discount_amount']; 
				$data['vat_class_id'] = $value['vat_class_id'];
				$data['reason'] = $value['reason'];
                                
                                if(!empty($value['is_hike']) && $value['is_hike']=='1'){
                                    $mailData['details'][] = $value; 
                                    $mailData['grn_no'] = $generateGrnNo;  
                                    $mailData['purchase_order_id'] = $purchase_order_id;  
                                }
				/* if($this->Session->read('website.instance') == "kanpur"){
					$data['amount'] = $value['current_amount'];
				} */
				
				if(!empty($value['free'])){
					$data['stock_available'] = $data['stock_available'] + $value['free']; 
				} 
				
				if( $quantity_received < $quantity_required )	//update stock but purchase order status remains pending
				{
					//$remaining_quantity = /*$quantity_required - */$quantity_received; 
					$remaining_quantity = !empty($this->request->data['purchase_order_item'][$key]['quantity_received']) ? $this->request->data['purchase_order_item'][$key]['quantity_received']:0;
 
					if(!empty($value['free'])){
						$remaining_quantity = $remaining_quantity + $value['free']; 
					}
					$data['status'] = 1;					//pending	
					if($quantity_required == $quantity_received){
						$orderStatus = 'Closed' ;				//to update status in purchase Order master
					}else{
						$orderStatus = 'Pending' ;
					}
					$data['stock'] = $remaining_quantity;
					//debug($data); exit;
				
				}else if( $quantity_received > $quantity_required ){	//update stock and add surplus
					//$data['status'] = 0; 						//done or completed set closed
					if($orderStatus != 'Pending') $orderStatus = 'Closed' ;
					$remaining_quantity = $quantity_received - $quantity_required; 

					if(!empty($value['free'])){
						$remaining_quantity = $remaining_quantity + $value['free']; 
					}
					$data['stock'] = $remaining_quantity;
					$this->StockAdjustment->Insert($product_id,$remaining_quantity);	//update surplus
					
				}else if( $quantity_received == $quantity_required ){
					//$data['status'] = 0; 						//done or completed set closed
					if($orderStatus != 'Pending') $orderStatus = 'Closed' ; //to check all prodcuts are received against order quantity
					$quantity_received = !empty($this->request->data['purchase_order_item'][$key]['quantity_received'])? $this->request->data['purchase_order_item'][$key]['quantity_received']:0;
					if(!empty($value['free'])){
						$quantity_received = $quantity_received + $value['free']; 
					}
					$data['stock'] = $quantity_received;
				} 
					if(empty($isPharmacy)){
						$this->Product->UpdateStock($product_id,$data);					//update purchase Order Item
						$this->ProductRate->InsertRateBatchWise($product_id,$data);
					 
					}
					$POIid = $value['id'];		//Purchase_order_id
					
					$grnId = $this->PurchaseOrderItem->UpdateItemStatus($data);			//update product status = 0 for complete, status = 1 for remaining
					 
			}
                        $isMailSend = $this->sendPurchaseHikeMail($mailData,$purchase_order_id); 
				$this->PurchaseOrder->UpdateStatus($id,$orderStatus); //update the status of the purchase order whether the order is commpleted or not by (closed or pending)
                                
                                //update inventory tracking by Swapnil - 16.03.2016
				$this->loadModel('InventoryTracking');
				$this->InventoryTracking->updateInventoryTracking($id,$orderFor);
			//}
			
			//BOF for tax and vat jv for PO and GRN by amit jain
			$vatFor = 0; $grossFor = 0; $netFor = 0;
			$vatFor5 = 0; $grossFor5 = 0; $netFor5 = 0;
			$vatFor55 = 0; $grossFor55 = 0; $netFor55 = 0;
			$vatFor12 = 0; $grossFor12 = 0; $netFor12 = 0;
			// Added by Mrunal - 30-09-2016
			$vatFor6 = 0; $grossFor6 = 0; $netFor6 = 0;
			$vatFor13 = 0; $grossFor13 = 0; $netFor13 = 0;

			foreach ($this->request->data['purchase_order_item'] as $pItem) {
				if($pItem['tax']=='5') { //for %5 vat
					$vatFor5 += $pItem['vat'];
					$grossFor5 += $pItem['amount'];
					$netFor5 += $vatFor5 + $grossFor5; 
				} else if($pItem['tax']=='5.5') { //for %5.5 vat
					$vatFor55 += $pItem['vat'];
					$grossFor55 += $pItem['amount'];
					$netFor55 += $vatFor55 + $grossFor55; 
				} else if($pItem['tax']=='12.5') {//for 12.5%
					$vatFor12 += $pItem['vat'];
					$grossFor12 += $pItem['amount'];
					$netFor12 += $vatFor12 + $grossFor12;
				} else if($pItem['tax']=='6') {//for 6%
					$vatFor6 += $pItem['vat'];
					$grossFor6 += $pItem['amount'];
					$netFor6 += $vatFor6 + $grossFor6;
				} else if($pItem['tax']=='13.5') {//for 13.5%
					$vatFor13 += $pItem['vat'];
					$grossFor13 += $pItem['amount'];
					$netFor13 += $vatFor13 + $grossFor13;
				} else {//else vat			
					$vatFor += $pItem['vat'];
					$grossFor += $pItem['amount'];
					$netFor += $vatFor + $grossFor;
				}
			}

			$totalAmount = round($grossFor + $grossFor5 + $grossFor55 + $grossFor12 + $grossFor6 + $grossFor13 + $vatFor5 + $vatFor12 + $vatFor55 + 
							$vatFor6 + $vatFor13);
			
			$medicinesSurgicalPurchase = (Configure::read('medicinesSurgicalPurchaseLabel'));
			$vatLabel = (Configure::read('inputVATLabel'));
			$batchIdentifier = strtotime("now") ;
			$doneDate  =  $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
			$narration = 'Being surgical items purchased from '.$this->request->data['inventory_supplier_name'].' as per invoice no. '.$this->request->data['PurchaseOrder']['party_invoice_number']." ".'done on '.$doneDate;
			//non vat
			$this->Account->id = '';
			$userId = $this->Account->getUserIdOnly($this->request->data['inventory_supplier_id'],'InventorySupplier',$this->request->data['inventory_supplier_name']);
			if($grossFor > 0){
				$supplierId = $this->Account->getAccountIdOnly($medicinesSurgicalPurchase[0]);
				$jvData = array(
						'date'=>date('Y-m-d H:i:s'),
						'location_id'=>$this->Session->read('locationid'),
						'account_id'=>$supplierId,
						'user_id'=>$userId,
						'type'=>'PurchaseOrder',
						'batch_identifier'=>$batchIdentifier,
						'narration'=>$narration,
						'debit_amount'=>$grossFor,
						'create_time'=>date('Y-m-d H:i:s'));
				$this->VoucherEntry->insertJournalEntry($jvData);
				$this->Account->setBalanceAmountByAccountId($supplierId,$grossFor,'debit');
				$this->VoucherEntry->id= '';
				$this->Account->id = '';
			}
			
			//for med 5%
			if($grossFor5 > 0 ){
				$supplierId = $this->Account->getAccountIdOnly($medicinesSurgicalPurchase[1]);	
				$jvData = array(
						'date'=>date('Y-m-d H:i:s', strtotime("now +1 sec")),
						'location_id'=>$this->Session->read('locationid'),
						'account_id'=>$supplierId,
						'user_id'=>$userId,
						'type'=>'PurchaseOrder',
						'batch_identifier'=>$batchIdentifier,
						'narration'=>$narration,
						'debit_amount'=>$grossFor5,
						'create_time'=>date('Y-m-d H:i:s', strtotime("now +1 sec")));
				$this->VoucherEntry->insertJournalEntry($jvData);
				$this->Account->setBalanceAmountByAccountId($supplierId,$grossFor5,'debit');
				$this->VoucherEntry->id= '';
				$this->Account->id = '';
			}
			
			//for med 5.5%
			if($grossFor55 > 0 ){
				$supplierId = $this->Account->getAccountIdOnly($medicinesSurgicalPurchase[6]);
				$jvData = array(
						'date'=>date('Y-m-d H:i:s', strtotime("now +1 sec")),
						'location_id'=>$this->Session->read('locationid'),
						'account_id'=>$supplierId,
						'user_id'=>$userId,
						'type'=>'PurchaseOrder',
						'batch_identifier'=>$batchIdentifier,
						'narration'=>$narration,
						'debit_amount'=>$grossFor55,
						'create_time'=>date('Y-m-d H:i:s', strtotime("now +1 sec")));
				$this->VoucherEntry->insertJournalEntry($jvData);
				$this->Account->setBalanceAmountByAccountId($supplierId,$grossFor55,'debit');
				$this->VoucherEntry->id= '';
				$this->Account->id = '';
			}
			
			//for vat 5% 
			if($vatFor5 > 0){
				$supplierId = $this->Account->getAccountIdOnly($vatLabel[0]);
				$jvData = array(
						'date'=>date('Y-m-d H:i:s', strtotime("now +2 sec")),
						'location_id'=>$this->Session->read('locationid'),
						'account_id'=>$supplierId,
						'user_id'=>$userId,
						'type'=>'PurchaseOrder',
						'batch_identifier'=>$batchIdentifier,
						'narration'=>$narration,
						'debit_amount'=>$vatFor5,
						'create_time'=>date('Y-m-d H:i:s', strtotime("now +2 sec")));
				$this->VoucherEntry->insertJournalEntry($jvData);
				$this->Account->setBalanceAmountByAccountId($supplierId,$vatFor5,'debit');
				$this->VoucherEntry->id= '';
				$this->Account->id = '';
			}
			
			//for vat 5%
			if($vatFor55 > 0){
				$supplierId = $this->Account->getAccountIdOnly($vatLabel[4]);
				$jvData = array(
						'date'=>date('Y-m-d H:i:s', strtotime("now +2 sec")),
						'location_id'=>$this->Session->read('locationid'),
						'account_id'=>$supplierId,
						'user_id'=>$userId,
						'type'=>'PurchaseOrder',
						'batch_identifier'=>$batchIdentifier,
						'narration'=>$narration,
						'debit_amount'=>$vatFor55,
						'create_time'=>date('Y-m-d H:i:s', strtotime("now +2 sec")));
				$this->VoucherEntry->insertJournalEntry($jvData);
				$this->Account->setBalanceAmountByAccountId($supplierId,$vatFor55,'debit');
				$this->VoucherEntry->id= '';
				$this->Account->id = '';
			}
				
			//for med 12.5%
			if($grossFor12 > 0){ 
				$supplierId = $this->Account->getAccountIdOnly($medicinesSurgicalPurchase[2]);
				$jvData = array(
						'date'=>date('Y-m-d H:i:s', strtotime("now +3 sec")),
						'location_id'=>$this->Session->read('locationid'),
						'account_id'=>$supplierId,
						'user_id'=>$userId,
						'type'=>'PurchaseOrder',
						'batch_identifier'=>$batchIdentifier,
						'narration'=>$narration,
						'debit_amount'=>$grossFor12,
						'create_time'=>date('Y-m-d H:i:s', strtotime("now +3 sec")));
				$this->VoucherEntry->insertJournalEntry($jvData);
				$this->Account->setBalanceAmountByAccountId($supplierId,$grossFor12,'debit');
				$this->VoucherEntry->id= '';
				$this->Account->id = '';
			}
			
			//for vat 12.5%
			if($vatFor12 > 0){ 
				$supplierId = $this->Account->getAccountIdOnly($vatLabel[1]);
				$jvData = array(
						'date'=>date('Y-m-d H:i:s', strtotime("now +4 sec")),
						'location_id'=>$this->Session->read('locationid'),
						'account_id'=>$supplierId,
						'user_id'=>$userId,
						'type'=>'PurchaseOrder',
						'batch_identifier'=>$batchIdentifier,
						'narration'=>$narration,
						'debit_amount'=>$vatFor12,
						'create_time'=>date('Y-m-d H:i:s', strtotime("now +4 sec")));
				$this->VoucherEntry->insertJournalEntry($jvData);
				$this->Account->setBalanceAmountByAccountId($supplierId,$vatFor12,'debit');
				$this->VoucherEntry->id= '';
				$this->Account->id = '';
			}

			//for med 6%
			if($grossFor6 > 0){ 
				$supplierId = $this->Account->getAccountIdOnly($medicinesSurgicalPurchase[7]);
				$jvData = array(
						'date'=>date('Y-m-d H:i:s', strtotime("now +5 sec")),
						'location_id'=>$this->Session->read('locationid'),
						'account_id'=>$supplierId,
						'user_id'=>$userId,
						'type'=>'PurchaseOrder',
						'batch_identifier'=>$batchIdentifier,
						'narration'=>$narration,
						'debit_amount'=>$grossFor6,
						'create_time'=>date('Y-m-d H:i:s', strtotime("now +5 sec")));
				$this->VoucherEntry->insertJournalEntry($jvData);
				$this->Account->setBalanceAmountByAccountId($supplierId,$grossFor6,'debit');
				$this->VoucherEntry->id= '';
				$this->Account->id = '';
			}
			
			//for vat 12.5%
			if($vatFor6 > 0){ 
				$supplierId = $this->Account->getAccountIdOnly($vatLabel[5]);
				$jvData = array(
						'date'=>date('Y-m-d H:i:s', strtotime("now +5 sec")),
						'location_id'=>$this->Session->read('locationid'),
						'account_id'=>$supplierId,
						'user_id'=>$userId,
						'type'=>'PurchaseOrder',
						'batch_identifier'=>$batchIdentifier,
						'narration'=>$narration,
						'debit_amount'=>$vatFor6,
						'create_time'=>date('Y-m-d H:i:s', strtotime("now +5 sec")));
				$this->VoucherEntry->insertJournalEntry($jvData);
				$this->Account->setBalanceAmountByAccountId($supplierId,$vatFor6,'debit');
				$this->VoucherEntry->id= '';
				$this->Account->id = '';
			}

			//for med 13.5%
			if($grossFor13 > 0){ 
				$supplierId = $this->Account->getAccountIdOnly($medicinesSurgicalPurchase[8]);
				$jvData = array(
						'date'=>date('Y-m-d H:i:s', strtotime("now +6 sec")),
						'location_id'=>$this->Session->read('locationid'),
						'account_id'=>$supplierId,
						'user_id'=>$userId,
						'type'=>'PurchaseOrder',
						'batch_identifier'=>$batchIdentifier,
						'narration'=>$narration,
						'debit_amount'=>$grossFor13,
						'create_time'=>date('Y-m-d H:i:s', strtotime("now +6 sec")));
				$this->VoucherEntry->insertJournalEntry($jvData);
				$this->Account->setBalanceAmountByAccountId($supplierId,$grossFor13,'debit');
				$this->VoucherEntry->id= '';
				$this->Account->id = '';
			}
			
			//for vat 13.5%
			if($vatFor13 > 0){ 
				$supplierId = $this->Account->getAccountIdOnly($vatLabel[6]);
				$jvData = array(
						'date'=>date('Y-m-d H:i:s', strtotime("now +6 sec")),
						'location_id'=>$this->Session->read('locationid'),
						'account_id'=>$supplierId,
						'user_id'=>$userId,
						'type'=>'PurchaseOrder',
						'batch_identifier'=>$batchIdentifier,
						'narration'=>$narration,
						'debit_amount'=>$vatFor13,
						'create_time'=>date('Y-m-d H:i:s', strtotime("now +6 sec")));
				$this->VoucherEntry->insertJournalEntry($jvData);
				$this->Account->setBalanceAmountByAccountId($supplierId,$vatFor13,'debit');
				$this->VoucherEntry->id= '';
				$this->Account->id = '';
			}

			$serializeArray = array('0%tax'=>$grossFor,
					'5%tax'=>round($vatFor5),
					'5%amount'=>$grossFor5,
					'14%tax'=>round($vatFor12),
					'14%amount'=>$grossFor12,
					'BatchIdentifier'=>$batchIdentifier,
					'InvoiceNo'=>$this->request->data['PurchaseOrder']['party_invoice_number']);
			//BOF voucher Log entry for purchase voucher entry
			if(!empty($totalAmount)){
				$voucherLogData = array(
						'date'=>date('Y-m-d H:i:s'),
						'created_by'=>$this->Session->read('userid'),
						'account_id'=>$supplierId,
						'user_id'=>$userId,
						'type'=>'PurchaseOrder',
						'narration'=>$narration,
						'purchase_value'=>serialize($serializeArray),
						'debit_amount'=>$totalAmount);
				$voucherLogData['voucher_no']=$this->request->data['PurchaseOrder']['id'];
				$voucherLogData['voucher_type']="Purchase";
				$this->VoucherLog->insertVoucherLog($voucherLogData);
				$this->Account->setBalanceAmountByUserId($userId,$totalAmount,'credit');
				$this->VoucherLog->id='';
			}
			//supplier 
			if(!empty($this->request->data['net_amount']) && $this->request->data['net_amount'] !='0'){
			$vrData = array('reference_type_id'=> '2',
					'voucher_id'=> $this->VoucherEntry->getLastInsertID(),
					'voucher_type'=> 'journal',
					'location_id'=> $this->Session->read('locationid'),
					'user_id'=> $userId,
					'date' => date('Y-m-d H:i:s'),
					'amount'=>$this->request->data['net_amount'],
					'credit_period'=>'45',
					'payment_type'=>'Cr',
					'reference_no'=>$this->request->data['PurchaseOrder']['party_invoice_number'],
					'parent_id' => '0');
			$this->VoucherReference->save($vrData);
			$this->VoucherReference->id= '';
			//EOF supplier
			}
			
			if($return == 'return'){
				$this->Session->setFlash(__("GRN Returned Successfully for GRN No:: <b>".$generateGrnNo."</b>", true),'default',array('class'=>'stillSuccess','id'=>'stillFlashMessage'),'still');
				$this->redirect(array('controller'=>'PurchaseOrders','action'=>'purchase_receipt'));
			}else{
				$this->Session->setFlash(__("GRN has been saved successfully for GRN No: <b>".$generateGrnNo."</b>", true),'default',array('class'=>'stillSuccess','id'=>'stillFlashMessage'),'still');
			 	$this->redirect(array('controller'=>'PurchaseOrders','action'=>'purchase_receipt','?'=>array('print'=>'print','page'=>'grn','id'=>$id,'grnID'=>$grnId)));
			}
		}	//end of else ($orderFor)
	
		$this->PurchaseOrderItem->bindModel(array('belongsTo'=>array(

				'PurchaseOrder' => array('foreignKey'=>false,
											'fields'=>array('PurchaseOrder.contract_id'),
											'conditions'=>array('PurchaseOrder.id=PurchaseOrderItem.purchase_order_id')),
		
				'Product'=>array('foreignKey'=>'product_id'),
		
				'ManufacturerCompany'=>array('foreignKey'=>false,
												'fields'=>array('ManufacturerCompany.name'),
												'conditions'=>array('ManufacturerCompany.id'=>'Product.manufacturer_id')),
				'VatClass'=>array('foreignKey'=>false,
												'conditions'=>array('PurchaseOrderItem.vat_class_id = VatClass.id')
						)
					)));
		
		$item = $this->PurchaseOrderItem->find('all',array('conditions'=>array('PurchaseOrderItem.purchase_order_id'=>$id,'PurchaseOrderItem.status'=>1)));
		$this->set('items',$item);
		if($return == 'return'){ 
			$this->render('ajax_purchase_return_items');
		}else{
			$this->render('ajax_purchase_receipt_items');
		}
		
		/** Return View */
			$this->purchaseReturnView($return,$id);
		/** End Of Return View*/
	}
	
	// To display return of purchased product
	function purchaseReturnView($returnItem,$poId){
		if($returnItem == 'viewReturnItem'){
			$this->PurchaseReturn->bindModel(array(
					'belongsTo'=>array(
							'Product'=>array('Product.id = PurchaseReturn.product_id'),
							'PurchaseOrderItem'=>array('PurchaseOrderItem.id = PurchaseReturn.purchase_order_item_id')
							)));
			$this->paginate = array('conditions'=>array('PurchaseReturn.purchase_order_id'=>$poId),
														'fields'=>array('PurchaseReturn.*','Product.id','Product.name','PurchaseOrderItem.id','PurchaseOrderItem.quantity_received')
					);
			
			$returnValues = $this->paginate('PurchaseReturn');
			$this->set('returnValues',$returnValues);
			$this->render('ajax_purchase_return_view');
		}
	}
	
	
	
	/** 
	 * Function for PO autocomplete 
	 * supplier_id is for fetch the item regarding to supplier
	 * orderFor is for pharmacy or central store location
	 */
	 
	function autocompleteForPO($supplier_id = null, $contract_id = null, $orderFor = null, $checkReturn = null){
			
		$this->autoRender = false;
		$this->layout = false;
		$this->loadModel("StoreLocation");
		$searchKey = $this->params->query['term'] ; 
		$this->uses = array("ContractProduct","Product","ProductRate","Contract","VatClass","Location","PurchaseOrderItem");		
		$isPharmacy = false;
		
		$pharmacyDetail = $this->StoreLocation->find('first',array('conditions'=>array("StoreLocation.code_name"=>Configure::read('pharmacyCode'))));
		$apamDetail = $this->StoreLocation->find('first',array('conditions'=>array("StoreLocation.code_name"=>Configure::read('apamCode'))));
		
		if($pharmacyDetail['StoreLocation']['id'] == $orderFor || $apamDetail['StoreLocation']['id'] == $orderFor){
			if($apamDetail['StoreLocation']['id'] == $orderFor){
				$locationId = $this->Location->getLocationIdByName(Configure::read('apamCode'));
			}else{
				$locationId = $this->Session->read('locationid');
			}
			echo json_encode($this->autoForPharmacy($searchKey,$locationId));
			exit;
		}
		
		if($contract_id != 'null')	//if contract id gets then fetch the price from contract_products
		{
			$this->Product->bindModel(array(
						'belongsTo'=>array(
								'ManufacturerCompany'=>array(
											'foreignKey'=>'manufacturer_id'),
		
								'Contract'=>array(
											'foreignKey'=>false,
											'conditions'=>array('Contract.supplier_id = Product.supplier_id')),
							
								'ContractProduct'=>array(
											'foreignKey'=>false,
											'conditions'=>array('ContractProduct.product_id = Product.id'))
								),
						'hasMany'=>array(
								'ProductRate'=>array(
											'foreignKey'=>'product_id')
								)
						));
					
			$productData = $this->Product->find('all',array(
												'fields'=>array('Product.*','ContractProduct.*','Contract.id','Contract.supplier_id','ManufacturerCompany.name'),
												'conditions'=>array($conditions,/*'Product.supplier_id'=>$supplier_id,*/'Contract.id'=>$contract_id,'Product.name LIKE'=>$searchKey ."%"),
												'limit' => 20,
											)); 
		}
		else //here find all products of regarding supplier 
			if($checkReturn == 1){
				$this->Product->bindModel(array('belongsTo'=>array(
								'ManufacturerCompany'=>array(
											'foreignKey'=>'manufacturer_id'),
								'VatClass' => array(
											'foreignKey'=>'vat_class_id'),
								'PurchaseOrderItem' =>array('foreignKey'=>false,'conditions'=>array('PurchaseOrderItem.product_id = Product.id'))
						),
								
						'hasMany'=>array(
								'ProductRate' => array(
											'foreignKey'=>'product_id'))
				)); 
					
 				$productData = $this->Product->find('all',array(
 						'fields'=>array('Product.*','ManufacturerCompany.name','VatClass.*','PurchaseOrderItem.*'),
 						'conditions'=>array('Product.location_id !='=>$this->Location->getLocationIdByName(Configure::read('apamCode')),/*'Product.supplier_id'=>$supplier_id,*/'Product.name LIKE'=>$searchKey ."%"),
 						'limit' => 20,
 				));
				
		}else{
			$this->Product->bindModel(array('belongsTo'=>array(
								'ManufacturerCompany'=>array(
											'foreignKey'=>'manufacturer_id'),
								'VatClass' => array(
											'fireignKey'=>'vat_class_id')),
						'hasMany'=>array(
								'ProductRate' => array(
											'foreignKey'=>'product_id'))
				)); 
				
			$productData = $this->Product->find('all',array(
												'fields'=>array('Product.*','ManufacturerCompany.name','VatClass.*'/*,'ProductRate.*'*/),
												'conditions'=>array($conditions,'Product.location_id !='=>$this->Location->getLocationIdByName(Configure::read('apamCode')),/*'Product.supplier_id'=>$supplier_id,*/'Product.name LIKE'=>$searchKey ."%"),
												'limit' => 20,
											));
		}
		 
		
		foreach ($productData as $key=>$value) { 
		
			$pack = !empty($value['Product']['pack'])?$value['Product']['pack']:1;
			if($value['ProductRate']['id']){
				$vat_class_id = $value['ProductRate']['vat_class_id'];
				$tax = $value['ProductRate']['tax'];
			}else{
				$vat_class_id = $value['Product']['vat_class_id'];
				$tax = $value['Product']['tax'];
			}
			
			if(isset($value['ContractProduct']['purchase_price']))
			{
				$value['Product']['purchase_price'] = $value['ContractProduct']['purchase_price'];
				$value['Product']['is_contract'] = '1';
			}
			else 
			{
				$value['Product']['is_contract'] = '0';
			} 
			
			$batch = $mrp = $purchase = $sale = $expiry = ''; 
			
			foreach ($value['ProductRate'] as $key => $pRate){
				$sale = $pRate['sale_price'];
				$batch = $pRate['batch_number'];
				$mrp = $pRate['mrp'];
				$purchase = $pRate['purchase_price'];
				$expiry = $pRate['expiry_date'];
			} 
			
			$returnArray[] = array( 'id'=>$value['Product']['id'],
									'value'=>$value['Product']['name'],
									'expiry_date'=>$expiry,
									'mrp'=>$mrp,
									'purchase_price'=>$purchase,
									'selling_price'=>$sale,
									'quantity'=>($value['Product']['quantity']*$pack)+$value['Product']['loose_stock'], 			//quantity or stock
									'manufacturer'=>$value['ManufacturerCompany']['name'],  // manufacturer 
									'pack'=>$pack,
									'qtyRecieve'=>$value['PurchaseOrderItem']['quantity_received'],
									'profit_percentage'=>!empty($value['Product']['profit_percentage'])?$value['Product']['profit_percentage']:0,
									'batch_number'=>$batch,
									'is_contract'=>$value['Product']['is_contract'],
									'tax'=>$tax, 							//tax not applicable for kanpur only
									'vat_class_id'=>$vat_class_id			//vat to manipulation
			);  
			
		}  
		echo json_encode($returnArray);
		exit;
	
	} 
	
	public function purchase_receipt_list()
	{
		$this->layout = "advance";
		$this->PurchaseOrder->bindModel(array('belongsTo'=>array(
								'InventorySupplier'=>array('foreignKey'=>'supplier_id'))));
		$this->set('orders',$this->PurchaseOrder->find('all'));	
	} 
	
	public function view_purchase_receipt($id)
	{
		$this->loadModel('StoreLocation');
		if(!$id)
		{
			throw new NotFoundException(__('Invalid Order Id'));
		}
		else
		{
			$this->PurchaseOrder->bindModel(array('belongsTo'=>array(
				'InventorySupplier'=>array('foreignKey'=>'supplier_id'),
				'StoreLocation'=>array('foreignKey'=>'order_for',
											'fields'=>array('StoreLocation.name')))));
		
			$result = $this->PurchaseOrder->find('first',array('fields'=>array('InventorySupplier.name','PurchaseOrder.*','StoreLocation.name'),
															'conditions'=>array('PurchaseOrder.id'=>$id)));
			$this->set('PurchaseOrder',$result);
		
			$this->PurchaseOrderItem->bindModel(array('belongsTo'=>array(
			
				'Product'=>array('foreignKey'=>'product_id',
											'fields'=>array('Product.name','Product.manufacturer_id','Product.pack','Product.batch_number')),
				
				'ManufacturerCompany'=>array('foreignKey'=>false,
											'fields'=>array('ManufacturerCompany.name'),
											'conditions'=>array('ManufacturerCompany.id=Product.manufacturer_id'))
				)));
			
			$item = $this->PurchaseOrderItem->find('all',array('conditions'=>array('PurchaseOrderItem.purchase_order_id'=>$id,'PurchaseOrderItem.status'=>1)));
 
			$this->set('items',$item);
			
		}
	} 
	
	public function getItemDetails($id)
	{
		$this->autoRender = false;
		$this->Layout = 'ajax';
		$this->loadModel('StoreLocation');
		$this->loadModel('Configuration');
		$this->loadModel('VatClass');
		$this->loadModel('PurchaseReturn');
		$this->loadModel('PharmacyItemRate');
		$this->PurchaseOrder->bindModel(array('belongsTo'=>array(
					'InventorySupplier'=>array('foreignKey'=>'supplier_id',
												'fields'=>array('InventorySupplier.name','InventorySupplier.id')),
					'StoreLocation'=>array('foreignKey'=>'order_for',
											'fields'=>array('StoreLocation.name')))));
		
		$PO_Detail = $this->PurchaseOrder->find('first',array('conditions'=>array('PurchaseOrder.id'=>$id)));
		
		$this->set('po_details',$PO_Detail);
		$this->set('grn_no',$this->PurchaseOrderItem->GenerateGRNno()); //set the purchase_order_number
		$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website'))); 
		$websiteConfig=unserialize($website_service_type['Configuration']['value']);
		$this->set('websiteConfig',$websiteConfig);
		
		/*$vatAllData = $this->VatClass->find('list',array('fields'=>array('VatClass.id','VatClass.vat_of_class'),'conditions'=>array('VatClass.is_delete'=>'0')));
		$this->set('vatAllData',$vatAllData);
		*/
		
		$vatAllData = $this->VatClass->find('all',array('fields'=>array('VatClass.id','VatClass.vat_of_class','VatClass.sat_percent','VatClass.vat_percent'),'conditions'=>array('VatClass.is_delete'=>'0')));
		
		foreach ($vatAllData as $key=>$val){
			$vatAllDataOption[$val['VatClass']['id']] = $val['VatClass']['vat_of_class'];
			$vatAllDatavalue[$val['VatClass']['id']] = $val['VatClass']['vat_percent']+$val['VatClass']['sat_percent'];
		}
		
		$this->set('dataValue',json_encode($vatAllDatavalue));
		$this->set('vatAllData',json_encode($vatAllDataOption));
		$this->set('vatAll',$vatAllDataOption);
		
		
		$this->loadModel('ManufacturerCompany');
		$this->PurchaseOrderItem->bindModel(array('belongsTo'=>array(

				'PurchaseOrder' => array('foreignKey'=>false,
											'fields'=>array('PurchaseOrder.contract_id'),
											'conditions'=>array('PurchaseOrder.id=PurchaseOrderItem.purchase_order_id')),
		
				'Product'=>array('foreignKey'=>'product_id'),
		
				'ManufacturerCompany'=>array('foreignKey'=>false,
											'fields'=>array('ManufacturerCompany.name'),
											'conditions'=>array('ManufacturerCompany.id=Product.manufacturer_id'))
					)));
		
		$results = $this->PurchaseOrderItem->find('all',array(
								'fields'=>array( 'Sum(PurchaseOrderItem.quantity_received) as sumCount', 'PurchaseOrderItem.*','PurchaseOrder.contract_id',
											'ManufacturerCompany.name','Product.*'),
								'conditions'=>array('PurchaseOrderItem.purchase_order_id'=>$id,'PurchaseOrderItem.status'=>1),
								 'group' => 'PurchaseOrderItem.product_id',
								 'order'=>array('PurchaseOrder.create_time'=>'ASC')
								 ));
                 
        //to get the previous purchase price to mail the purchase price hike list - Swapnil 30.03.2016
        foreach($results as $key => $val){
            $PurchaseOrderItemData = $this->PurchaseOrderItem->find('first',array(
                'fields'=>array(
                    'PurchaseOrderItem.purchase_price'  
                ),
                'conditions'=>array(
                    'PurchaseOrderItem.product_id'=>$val['PurchaseOrderItem']['product_id'],
                    'PurchaseOrderItem.id != '=> $val['PurchaseOrderItem']['id'] 
                ),
                'order'=>array(
                    'PurchaseOrderItem.id'=>'DESC'
                )
            ));
            $val['previous_purchase_price'] = $PurchaseOrderItemData['PurchaseOrderItem']['purchase_price'];
            $item[] = $val; 
        } 
              
		
		$this->set('items',$item); 
		$this->set('returnItem',$returnItem);
		$this->render('ajax_add_purchase_receipt_items'); 
	}
	
	
	public function printPurchaseOrder($id)
	{
		$this->layout = 'print_without_header';
		$this->loadModel('StoreLocation');
		if(!$id)
		{
			throw new NotFoundException(__('Invalid Order Id'));
		}
		else
		{
			$this->PurchaseOrder->bindModel(array('belongsTo'=>array(
				'InventorySupplier'=>array('foreignKey'=>'supplier_id'),
				'StoreLocation'=>array('foreignKey'=>'order_for',
											'fields'=>array('StoreLocation.name')))));
		
			$result = $this->PurchaseOrder->find('first',array('fields'=>array('InventorySupplier.name','PurchaseOrder.*','StoreLocation.name'),
															'conditions'=>array('PurchaseOrder.id'=>$id)));
			$this->set('PurchaseOrder',$result);
		
			$this->PurchaseOrderItem->bindModel(array('belongsTo'=>array(
			
				'Product'=>array('foreignKey'=>'product_id',
											'fields'=>array('Product.name','Product.manufacturer_id','Product.pack','Product.batch_number','Product.mrp','Product.quantity')),
				
				'ManufacturerCompany'=>array('foreignKey'=>false,
											'fields'=>array('ManufacturerCompany.name'),
											'conditions'=>array('ManufacturerCompany.id=Product.manufacturer_id'))
				)));
			
			$item = $this->PurchaseOrderItem->find('all',array('conditions'=>array('PurchaseOrderItem.purchase_order_id'=>$id/*,'PurchaseOrderItem.status'=>1*/)));
			
			$this->set('items',$item);
			
		}
	}

	
	public function printPurchaseReceived($id,$itemId = null)
	{
		$this->layout = 'print';
		$this->loadModel('StoreLocation');
		$this->loadModel('PurchaseReturn');
		if(!$id)
		{
			throw new NotFoundException(__('Invalid Order Id'));
		}
		else
		{
			$grnId = $this->PurchaseOrderItem->find('first',array('conditions'=>array('PurchaseOrderItem.id'=>$itemId)));
			$this->PurchaseOrder->bindModel(array('belongsTo'=>array(
					
					'InventorySupplier'=>array('foreignKey'=>'supplier_id',
												'fields'=>array('InventorySupplier.name')),
					'StoreLocation'=>array('foreignKey'=>'order_for',
											'fields'=>array('StoreLocation.name')))));
		
			$PO_Detail = $this->PurchaseOrder->find('first',array('conditions'=>array('PurchaseOrder.id'=>$id)));	//heading
			//debug($PO_Detail); 	
			$this->set('po_details',$PO_Detail);
		
			$this->loadModel('ManufacturerCompany');
			$this->PurchaseOrderItem->bindModel(array('belongsTo'=>array(
				'PurchaseOrder' => array('foreignKey'=>false,
											'fields'=>array('PurchaseOrder.contract_id','PurchaseOrder.total','PurchaseOrder.vat','PurchaseOrder.net_amount'),
											'conditions'=>array('PurchaseOrder.id=PurchaseOrderItem.purchase_order_id')),
		
				'Product'=>array('foreignKey'=>'product_id'),
		
				'ManufacturerCompany'=>array('foreignKey'=>false,
											'fields'=>array('ManufacturerCompany.name'),
											'conditions'=>array('ManufacturerCompany.id=Product.manufacturer_id'))
					
					)));
		
		$items = $this->PurchaseOrderItem->find('all',array(
								'conditions'=>array('PurchaseOrderItem.purchase_order_id'=>$id,'PurchaseOrderItem.grn_no'=>$grnId['PurchaseOrderItem']['grn_no']/*,'PurchaseOrderItem.status'=>1*/)));
		
		/* CODE FOR RETURN ON GRN By MRUNAL To DISPLAY RETURN VLUES FROM PURCHASE RETURN TABLE*/
		$this->PurchaseReturn->bindModel(array('belongsTo'=>array(
				'Product'=>array('foreignKey'=>false,
						'fields'=>array('Product.name','Product.purchase_price','Product.mrp','Product.sale_price'),
						'conditions'=>array('PurchaseReturn.product_id = Product.id')),
				
				'PurchaseOrderItem'=>array('foreignKey'=>false,
						'conditions'=>array('PurchaseOrderItem.product_id = PurchaseReturn.product_id')
						),
				'ManufacturerCompany'=>array('foreignKey'=>false,
						'fields'=>array('ManufacturerCompany.name'),
						'conditions'=>array('ManufacturerCompany.id=Product.manufacturer_id'))
		)));
		
		$returnItem = $this->PurchaseReturn->find('all',array(
						'conditions'=>array('PurchaseReturn.is_deleted'=>0,'PurchaseReturn.purchase_order_item_id'=>0,
								'PurchaseReturn.party_invoice_number'=>$PO_Detail['PurchaseOrder']['party_invoice_number'],
								'PurchaseReturn.batch_number = PurchaseOrderItem.batch_number'),
						'group'=>array('PurchaseReturn.batch_number')
						
				));
		/* END OF RETURN ON GRN CODE*/
		//debug($items); exit;
		//debug($returnItem);
		$this->set('receipt_items',$items);
		$this->set('returnItem',$returnItem);

		}
	}
	
	function ReceivedToPharmacy($data=array(),$locationId){
		$this->loadModel("Product");
		$this->loadModel("PharmacyItem");
		$this->loadModel("PharmacyItemRate");
		$this->loadModel("VatClass");
		$session = new cakeSession();
		$this->PharmacyItem->recursive = -1 ;
		$this->PharmacyItemRate->id = '';
		$this->PharmacyItemRate->recursive = -1 ;
		
		//For Return Item fro GRN
		//debug($data);exit;
		foreach ($data['purchase_return'] as $key=>$datas){
			$this->PharmacyItem->updateStockInPharmacy($datas,$locationId);
		}
			
		//END OF RETURN ITEM
		
		//for each products of same purchase order 
		foreach ($data['purchase_order_item'] as $value){

			$PharmacyItem = $this->PharmacyItem->find('first',array('fields'=>array('id','drug_id','stock'),'conditions'=>array('drug_id'=>$value['product_id'],'location_id'=>$locationId,'is_deleted'=>0)));
			//if name is there withour drug id 
			if(empty($PharmacyItem['PharmacyItem']['id'])){
				$PharmacyItem = $this->PharmacyItem->find('first',array('fields'=>array('id','drug_id','stock'),'conditions'=>array('name'=>trim($value['name']),'location_id'=>$locationId,'is_deleted'=>0))); 
			} 

			$pharmacyItemRateDetail  = array();
			$PharmacyItemDetail  = array();
			$pharmacyItemInsert = array();

			if(!empty($PharmacyItem['PharmacyItem']['id'])){	//if drug_id == product_id
				$this->PharmacyItemRate->id = '';
				//echo "exists in pharmacy item";	
				
				$PharmacyItemRateData = $this->PharmacyItemRate->find('first',array('conditions'=>array('batch_number'=>$value['batch_number'],'item_id'=>$PharmacyItem['PharmacyItem']['id'])));
				$vatData = $this->VatClass->find('first',array('conditions'=>array('VatClass.is_delete'=>0,'VatClass.id'=>$value['vat_class_id'])));
				$pack = (int)$value['pack'];
				 
				if(!empty($PharmacyItemRateData['PharmacyItemRate']['id'])){
					//update stock having same batch number in pharmacy rate
					$pharmacyItemRateDetail['id']= $PharmacyItemRateData['PharmacyItemRate']['id'];
					if(strtolower($this->Session->read('website.instance')) != "hope"){ 
						$itemRateWholeStock = (($PharmacyItemRateData['PharmacyItemRate']['stock'] * $pack) + $PharmacyItemRateData['PharmacyItemRate']['loose_stock']) + $value['quantity_received'];
						$pharmacyItemRateDetail['stock'] = floor($itemRateWholeStock / $pack);
						$pharmacyItemRateDetail['loose_stock'] = floor($itemRateWholeStock % $pack);
					}else{
						$pharmacyItemRateDetail['stock'] = $PharmacyItemRateData['PharmacyItemRate']['stock'] + $value['quantity_received'] + $value['free'];
					}
					$pharmacyItemRateDetail['vat_class_id'] = $value['vat_class_id'];
					$pharmacyItemRateDetail['vat_sat_sum'] = $vatData['VatClass']['vat_percent']+$vatData['VatClass']['sat_percent'];
					$pharmacyItemRateDetail['vat_class_name'] = $vatData['VatClass']['vat_of_class'];
					//echo "exists in pharmacy item rate";	
					if(!empty($value['free']) && strtolower($this->Session->read('website.instance')) != "hope"){
						$WholeStockwithFree = $itemRateWholeStock + $value['free'];
						$pharmacyItemRateDetail['stock'] = floor($WholeStockwithFree / $pack);
						$pharmacyItemRateDetail['loose_stock'] = floor($WholeStockwithFree % $pack); 
					}
					$this->PharmacyItemRate->save($pharmacyItemRateDetail);		//save or update into pharmacy_item_reate
					$this->PharmacyItemRate->id = '';
				}
				else
				{
					//insert new rate of having new batch number
					$pharmacyItemRateDetail['item_id'] = $PharmacyItem['PharmacyItem']['id'];
					$pharmacyItemRateDetail['mrp'] = $value['mrp'];
					$pharmacyItemRateDetail['tax'] = $value['tax'];
					
					$pharmacyItemRateDetail['vat_class_id'] = $value['vat_class_id'];
					$pharmacyItemRateDetail['vat_sat_sum'] = $vatData['VatClass']['vat_percent']+$vatData['VatClass']['sat_percent'];
					$pharmacyItemRateDetail['vat_class_name'] = $vatData['VatClass']['vat_of_class'];
					
					if(strtolower($this->Session->read('website.instance')) != "hope"){
						$pharmacyItemRateDetail['stock'] = floor($value['quantity_received'] / $pack);
						$pharmacyItemRateDetail['loose_stock'] = floor($value['quantity_received'] % $pack);
					}else{
						$pharmacyItemRateDetail['stock'] = $value['quantity_received'] + $value['free'];
					}
					//$pharmacyItemRateDetail['stock'] = $value['quantity_received'];
					
					$pharmacyItemRateDetail['batch_number'] = $value['batch_number'];
					$pharmacyItemRateDetail['expiry_date'] = DateFormatComponent::formatDate2STD($value['expiry_date'],Configure::read('date_format'));
					$pharmacyItemRateDetail['purchase_price'] = $value['purchase_price'];
					$pharmacyItemRateDetail['cost_price'] = $value['cost_price'];
					$pharmacyItemRateDetail['sale_price'] = $value['selling_price'];
					$pharmacyItemRateDetail['cst'] = $value['cst'];
					$pharmacyItemRateDetail['location_id'] = $locationId; 
					if(!empty($value['free']) && strtolower($this->Session->read('website.instance')) != "hope"){
						$WholeStockwithFree = $value['quantity_received'] + $value['free'];
						$pharmacyItemRateDetail['stock'] = floor($WholeStockwithFree / $pack);
						$pharmacyItemRateDetail['loose_stock'] = floor($WholeStockwithFree % $pack);
					}
					$this->PharmacyItemRate->save($pharmacyItemRateDetail);		//save or update into pharmacy_item_reate
					$this->PharmacyItemRate->id = '';
					//echo "else of pharmacy item rate";
				}
				
				$totalRatesStock = $this->PharmacyItemRate->find('first',array(
						'fields'=>array('SUM(PharmacyItemRate.stock) as totStock','SUM(PharmacyItemRate.loose_stock) as totLStock'),
						'conditions'=>array('PharmacyItemRate.item_id'=>$PharmacyItem['PharmacyItem']['id'],'PharmacyItemRate.is_deleted'=>0)));
				
				$wholeRatesTabStock = ($totalRatesStock[0]['totStock'] * $pack)+$totalRatesStock[0]['totLStock'];
				//$itemWholeStock = (($PharmacyItem['PharmacyItem']['stock'] * $pack) + $PharmacyItem['PharmacyItem']['loose_stock']) + $value['quantity_received'];
				$PharmacyItemDetail['PharmacyItem']['stock'] = floor($wholeRatesTabStock / $pack);
				$PharmacyItemDetail['PharmacyItem']['loose_stock'] = floor($wholeRatesTabStock % $pack);
				
				$PharmacyItemDetail['PharmacyItem']['id'] = $PharmacyItem['PharmacyItem']['id']; 
				$PharmacyItemDetail['PharmacyItem']['drug_id'] = $value['product_id']; 
				$this->PharmacyItem->save($PharmacyItemDetail);
				$this->PharmacyItem->id = '';
			}
			else{
				
				//save in the pharmacy_item 	
				//fetch last inserted id & save into pharmacy_item_rate 
				$pack = (int)$value['pack'];
				
				$pharmacyItemInsert['Status'] = 'A';
				$pharmacyItemInsert['drug_id'] = $value['product_id'];
				$pharmacyItemInsert['name'] = $value['name'];
				$pharmacyItemInsert['pack'] = $value['pack'];
				
				if(strtolower($this->Session->read('website.instance')) != "hope"){
					$pharmacyItemInsert['stock'] = floor($value['quantity_received'] / $pack);
					$pharmacyItemInsert['loose_stock'] = floor($value['quantity_received'] % $pack);
				}else{
					$pharmacyItemInsert['stock'] = $value['quantity_received']+$value['free'];
				}
				
				if(!empty($value['free']) && strtolower($this->Session->read('website.instance')) != "hope"){ 
					$pharmacyItemInsert['stock'] = floor(($value['quantity_received'] + $value['free'])/ $pack);
					$pharmacyItemInsert['loose_stock'] = floor(($value['quantity_received'] + $value['free']) % $pack);
				}
				
				$pharmacyItemInsert['item_code'] = $value['item_code'];
				$pharmacyItemInsert['manufacturer'] = $value['manufacturer'];
				$pharmacyItemInsert['manufacturer_company_id'] = $value['manufacturer_id'];
				$pharmacyItemInsert['supplier_id'] = $value['supplier_id'];
				$pharmacyItemInsert['create_time'] = date('Y-m-d H:i:s');
				$pharmacyItemInsert['created_by'] = $session->read('userid');;
				$pharmacyItemInsert['location_id'] = $locationId; 
				$pharmacyItemInsert['expiry_date'] = DateFormatComponent::formatDate2STD($value['expiry_date'],Configure::read('date_format'));
				
				if($this->PharmacyItem->save($pharmacyItemInsert)) 			//save into Pharmacy_item
				{	
					$lastID = $this->PharmacyItem->getLastInsertID();
					$pharmacyItemRateDetail['item_id'] = $lastID;
					$pharmacyItemRateDetail['mrp'] = $value['mrp'];
					$pharmacyItemRateDetail['tax'] = $value['tax'];
					$pharmacyItemRateDetail['batch_number'] = $value['batch_number'];
					$pharmacyItemRateDetail['expiry_date'] = DateFormatComponent::formatDate2STD($value['expiry_date'],Configure::read('date_format'));
					$pharmacyItemRateDetail['cst'] = $value['cst'];
					$pharmacyItemRateDetail['purchase_price'] = $value['purchase_price'];
					$pharmacyItemRateDetail['cost_price'] = $value['cost_price'];
					$pharmacyItemRateDetail['sale_price'] = $value['selling_price'];
					if(strtolower($this->Session->read('website.instance')) != "hope"){
						$pharmacyItemRateDetail['stock'] = floor($value['quantity_received'] / $pack);
						$pharmacyItemRateDetail['loose_stock'] = floor($value['quantity_received'] % $pack);
					}else{
						$pharmacyItemRateDetail['stock'] = ($value['quantity_received'] + $value['free']);
					}
					
					$pharmacyItemRateDetail['location_id'] = $locationId; 
					
					if(!empty($value['free']) && strtolower($this->Session->read('website.instance')) != "hope"){
						$pharmacyItemRateDetail['stock'] = floor(($value['quantity_received'] + $value['free']) / $pack);
						$pharmacyItemRateDetail['loose_stock'] = floor(($value['quantity_received'] + $value['free']) % $pack); 
					}
					$this->PharmacyItemRate->recursive = -1 ;
					$this->PharmacyItemRate->id = '';
					$this->PharmacyItemRate->save($pharmacyItemRateDetail);		//save into pharmacy_item_reate
					$this->PharmacyItemRate->recursive = -1 ;
				}
				$this->PharmacyItem->id = ''; 
				$this->PharmacyItemRate->id = '';
			}
		} 
	}//end of function
	
	function autoForPharmacy($searchKey,$locationId=null){
		$this->uses = array('PharmacyItem','ManufacturerCompany','PharmacyItemRate','VatClass');
		$this->PharmacyItem->unbindModel(array('hasMany'=>array('InventoryPurchaseItemDetail')));
		
                
		$this->PharmacyItem->bindModel(array('belongsTo'=>array(
                    'ManufacturerCompany'=>array(
                        'foreignKey'=>'manufacturer_company_id'),
                    'VatClass'=>array(
                        'foreignKey'=>'vat_class_id'))));
			
                
                $pharmacyData = $this->PharmacyItem->find('all',array(
                        'fields'=>array('PharmacyItem.id ,PharmacyItem.name','PharmacyItem.vat_class_id','PharmacyItem.pack','PharmacyItem.drug_id','PharmacyItem.profit_percentage','ManufacturerCompany.name','PharmacyItemRate.*','VatClass.*'),
                        'conditions'=>array('PharmacyItem.drug_id !=0','PharmacyItem.name LIKE'=>$searchKey ."%",'PharmacyItem.location_id'=>$locationId),
                        'group'=>array('PharmacyItem.name'),
                        'limit' => 20,
                )); 
                
                foreach($pharmacyData as $key=> $val){
                    $pharmacyItemData = $this->PharmacyItemRate->find('first',array(
                        'conditions'=>array('PharmacyItemRate.is_deleted'=>'0','PharmacyItemRate.item_id'=>$val['PharmacyItem']['id']),
                        'order'=>array('PharmacyItemRate.id'=>'DESC')
                    ));
                    $val['PharmacyItemRate'] = $pharmacyItemData['PharmacyItemRate'];
                    $result[] = $val;
                } 
                
                /*$this->PharmacyItemRate->bindModel(array(
                    'belongsTo'=>array(
                        'PharmacyItem'=>array(
                            'foreignKey'=>false,
                            'conditions'=>array(
                                'PharmacyItemRate.item_id = PharmacyItem.id'
                            )
                        ),
                        'ManufacturerCompany'=>array(
                            'foreignKey'=>false,
                            'conditions'=>array(
                                'PharmacyItem.manufacturer_company_id = ManufacturerCompany.id'
                            )),
                        'VatClass'=>array(
                            'foreignKey'=>false,
                            'conditions'=>array(
                                'PharmacyItem.vat_class_id = VatClass.id'
                            ))
                        )
                    ));
			
                
                $pharmacyData = $this->PharmacyItemRate->find('all',
                    array(
                        'fields'=>array(
                            'MAX(PharmacyItemRate.id) as maxID',
                            'PharmacyItem.name','PharmacyItem.vat_class_id','PharmacyItem.pack','PharmacyItem.drug_id','PharmacyItem.profit_percentage','ManufacturerCompany.name','PharmacyItemRate.*','VatClass.*'
                        ),
                        'conditions'=>array( 
                            'PharmacyItem.drug_id !=0','PharmacyItem.name LIKE'=>$searchKey ."%",'PharmacyItem.location_id'=>$locationId,'PharmacyItemRate.is_deleted'=>'0'
                        ),
                        'limit' => 20,
                        'order' => array(
                            'PharmacyItemRate.id'=>'DESC'
                        ), 
                        'group'=>array(
                            'PharmacyItemRate.item_id having maxID'
                        )
                ));
		*/ 
                
		foreach ($result as $key=>$value) { 
			$pack = !empty($value['PharmacyItem']['pack'])?$value['PharmacyItem']['pack']:1;
			if($value['PharmacyItemRate']['id']){
				$vat_class_id = $value['PharmacyItemRate']['vat_class_id'];
				$tax = $value['PharmacyItemRate']['tax']; 
			}else{
				$vat_class_id = $value['PharmacyItem']['vat_class_id'];
				$tax = $value['PharmacyItemRate']['tax'];
			}
			
			$returnArray[] = array( 'id'=>$value['PharmacyItem']['drug_id'],
                            'value'=>$value['PharmacyItem']['name'],
                            'mrp'=>$value['PharmacyItemRate']['mrp'],
                            'purchase_price'=>$value['PharmacyItemRate']['purchase_price'],
                            'quantity'=>($value['PharmacyItemRate']['stock']*$pack)+$value['PharmacyItemRate']['loose_stock'], 			//quantity or stock
                            'manufacturer'=>$value['ManufacturerCompany']['name'],  	// manufacturer 
                            'pack'=>$pack, 
                            'profit_percentage'=>!empty($value['PharmacyItem']['profit_percentage'])?$value['PharmacyItem']['profit_percentage']:0,
                            'batch_number'=>$value['PharmacyItemRate']['batch_number'],
                            'expiry_date'=>$value['PharmacyItemRate']['expiry_date'],
                            'selling_price'=>$value['PharmacyItemRate']['sale_price'],
                            'tax'=>$tax, 							//tax not applicable for kanpur only
                            'vat_class_id'=>$vat_class_id			//vat to manipulation
			); 
		}
		//debug($returnArray); exit;
		return $returnArray; 		
	}
	
	
	function autoForApam($searchKey){
		$this->uses = array('PharmacyItem','ManufacturerCompany','PharmacyItemRate','VatClass');
		$this->PharmacyItem->unbindModel(array('hasMany'=>array('InventoryPurchaseItemDetail')));
		
		$this->PharmacyItem->bindModel(array('belongsTo'=>array(
								'ManufacturerCompany'=>array(
											'foreignKey'=>'manufacturer_company_id'),
								'VatClass'=>array(
											'foreignKey'=>'vat_class_id'))));
			
			$pharmacyData = $this->PharmacyItem->find('all',array(
												'fields'=>array('PharmacyItem.name','PharmacyItem.vat_class_id','PharmacyItem.pack','PharmacyItem.drug_id','PharmacyItem.profit_percentage','ManufacturerCompany.name','PharmacyItemRate.*','VatClass.*'),
												'conditions'=>array('PharmacyItem.drug_id !=0','PharmacyItem.name LIKE'=>$searchKey ."%"),
												'group'=>array('PharmacyItem.name'),
												'limit' => 20,
											));
			//debug($pharmacyData);// exit;
		foreach ($pharmacyData as $key=>$value) { 
			
			if($value['PharmacyItemRate']['id']){
				$vat_class_id = $value['PharmacyItemRate']['vat_class_id'];
				$tax = $value['PharmacyItemRate']['tax'];
			}else{
				$vat_class_id = $value['PharmacyItem']['vat_class_id'];
				$tax = $value['PharmacyItemRate']['tax'];
			}
			
			$returnArray[] = array( 'id'=>$value['PharmacyItem']['drug_id'],
									'value'=>$value['PharmacyItem']['name'],
									'mrp'=>$value['PharmacyItemRate']['mrp'],
									'purchase_price'=>$value['PharmacyItemRate']['purchase_price'],
									'quantity'=>$value['PharmacyItemRate']['stock'], 			//quantity or stock
									'manufacturer'=>$value['ManufacturerCompany']['name'],  	// manufacturer 
									'pack'=>$value['PharmacyItem']['pack'], 
									'profit_percentage'=>!empty($value['PharmacyItem']['profit_percentage'])?$value['PharmacyItem']['profit_percentage']:0,
									'batch_number'=>$value['PharmacyItemRate']['batch_number'],
									'expiry_date'=>$value['PharmacyItemRate']['expiry_date'],
									'selling_price'=>$value['PharmacyItemRate']['sale_price'],
									'tax'=>$tax, 							//tax not applicable for kanpur only
									'vat_class_id'=>$vat_class_id			//vat to manipulation
			); 
		}
		//debug($returnArray); exit;
		return $returnArray; 		
	}
	
	public function edit_purchase_order($id)
	{
		$this->loadModel('StoreLocation');
		$this->loadModel('Configuration');
		$this->loadModel('VatClass');
		
		//Store Locations
		$storeLocation = ($this->StoreLocation->find('list',array('fields'=>array('id','name'),'conditions'=>array('allow_purchase'=>1))));
		$this->set('storeLocation',$storeLocation);
		
		//website Instance
		$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website')));
		$websiteConfig=unserialize($website_service_type['Configuration']['value']);
		$this->set('websiteConfig',$websiteConfig);
		
		//Vat Classes
		$vatAllData = $this->VatClass->find('all',array('fields'=>array('VatClass.id','VatClass.vat_of_class','VatClass.sat_percent','VatClass.vat_percent'),'conditions'=>array('VatClass.is_delete'=>'0')));
		
		foreach ($vatAllData as $key=>$val){
			$vatAllDataOption[$val['VatClass']['id']] = $val['VatClass']['vat_of_class'];
			$vatAllDatavalue[$val['VatClass']['id']] = $val['VatClass']['vat_percent']+$val['VatClass']['sat_percent'];
		}
		
		$this->set('dataValue',json_encode($vatAllDatavalue));
		$this->set('vatAllData',json_encode($vatAllDataOption));
		$this->set('vatAll',$vatAllDataOption);
		
		
		$this->layout = "advance";
		if(!$id)
		{
			throw new NotFoundException(__('Invalid Order Id'));
		}
		else
		{					
			$this->PurchaseOrder->bindModel(array('belongsTo'=>array(
				'InventorySupplier'=>array('foreignKey'=>'supplier_id'),
				'Contract'=>array('foreignKey'=>'contract_id'))));
		
			$result = $this->PurchaseOrder->find('first',array('fields'=>array('InventorySupplier.name','InventorySupplier.id','Contract.id','Contract.name','PurchaseOrder.*'),
															'conditions'=>array('PurchaseOrder.id'=>$id)));
			$this->set('PurchaseOrder',$result);
		
			$this->PurchaseOrderItem->bindModel(array('belongsTo'=>array(
				'Product'=>array('foreignKey'=>'product_id',
											'fields'=>array('Product.name','Product.manufacturer_id','Product.pack','Product.batch_number','Product.mrp','Product.quantity','Product.sale_price')),
				
				'ManufacturerCompany'=>array('foreignKey'=>false,
											'fields'=>array('ManufacturerCompany.name','ManufacturerCompany.id'),
											'conditions'=>array('ManufacturerCompany.id=Product.manufacturer_id'))
				)));
			
			$item = $this->PurchaseOrderItem->find('all',array('conditions'=>array('PurchaseOrderItem.purchase_order_id'=>$id/*,'PurchaseOrderItem.status'=>1*/)));
			//debug($item);
			$this->set('items',$item);
			$this->loadModel('StoreLocation');
			$storeLocation = ($this->StoreLocation->find('list',array('fields'=>array('id','name'),'conditions'=>array('allow_purchase'=>1))));
			$this->set('storeLocation',$storeLocation);
			
		if(!empty($this->request->data))
		{
			//debug($this->request->data); exit;
			$purchase_order = $this->request->data['purchase_order']['purchase_order_id']; 
			$lastInsertedId = $purchase_order;
			if($this->PurchaseOrderItem->deleteAll(array('PurchaseOrderItem.purchase_order_id' =>$purchase_order)))
			{
				if(!empty($this->request->data['purchase_order']['contract_id']))
				{
					$contracts = $this->Contract->find('first',array('conditions'=>array('Contract.id'=>$this->request->data['purchase_order']['contract_id'])));
					$minAmount = $contracts['Contract']['min_po_amount'];	//fetch the minimum amount for this contract from contrct table
					$maxAmount = $contracts['Contract']['max_po_amount'];
					$totalAmount = $this->request->data['purchase_order']['total_amount']; 
					if($totalAmount  >= $minAmount && $totalAmount  <= $maxAmount)
					{
						foreach($this->request->data['purchase_order_item'] as $key => $value)
						{
							if(!empty($value['product_id']))
							{
								$value['purchase_order_id'] = $lastInsertedId; 
								$value['status'] = 1;//in open state
								$this->PurchaseOrderItem->save($value);
								$this->PurchaseOrderItem->id = '';
							}
						}
					}	
				}else{
					//do something for non contract
					foreach($this->request->data['purchase_order_item'] as $key => $value)
					{	
						if(empty($value['product_id']) || $value['product_id']==0){
							//add into product if product doesnot exists
							$isExistProduct = $this->Product->find('first',array('conditions'=>array('Product.name'=>$value['product_name'])));
							if($isExistProduct['Product']['id']){
								$value['product_id'] = $isExistProduct['Product']['id']; 
							}else{
								//insert into product and fetch lastinserted id and update to drug_id in pharmacy item
								$pData = array();
								$pData['name'] = $value['product_name'];
								$pData['pack'] = $value['pack'];
								$pData['batch_number'] = $value['bacth_number'];
								$pData['mrp'] = $value['mrp'];
								$pData['purchase_price'] = $value['purchase_price'];
								$pData['tax'] = $value['product_name'];
								$this->Product->save($pData);
								$this->Product->id = '';
								$value['product_id'] = $this->Product->getLastInsertID();
							}
						}
						
						if(!empty($value['product_id']))
						{
							//$this->Product->updatePurchasePriceFromPurchaseOrder($value['product_id'],$value['purchase_price']); //update purchase Price in product
							$KeyData['purchase_order_id'] = $lastInsertedId;
							$KeyData['product_id'] = $value['product_id'];
							$KeyData['mrp'] = $value['mrp'];
							$KeyData['purchase_price'] = $value['purchase_price'];
							$KeyData['quantity_order'] = $value['quantity_order'];
							$KeyData['tax'] = $value['tax'];
							$KeyData['amount'] = $value['amount'];
							$KeyData['status'] = 1;
							$this->PurchaseOrderItem->save($KeyData);
							$this->PurchaseOrderItem->id = '';
						}
					}
					
				}	
				$orderData = array();
				$orderData['supplier_id'] = $this->request->data['purchase_order']['supplier_id'];
				$this->PurchaseOrder->id = $this->request->data['purchase_order']['purchase_order_id'];
				$this->PurchaseOrder->save($orderData);
				$this->PurchaseOrder->id = "";
				return $this->redirect(array("action"=>"purchase_order_list"));
			}	
		  }
		}
	}
	
	
	public function delete_order($id){
		$this->autoRender = "false";
		$this->PurchaseOrder->id = $id;
		$data['is_deleted'] = 1;
		if($this->PurchaseOrder->save($data)){
			$this->Session->setFlash(__('Purchase Order has been successfully deleted', true));
		}
		return $this->redirect(array("action"=>"purchase_order_list"));
	}
	
	function autocompletePurchaseOrder(){
		$this->autoRender = false;
		$this->layout = false;
		$searchKey = $this->params->query['term'] ; 
		$this->uses = array("PurchaseOrder");		
		$data = $this->PurchaseOrder->find('all',array('conditions'=>array('PurchaseOrder.purchase_order_number LIKE'=>"%".$searchKey."%"),'limit'=>15));
		foreach ($data as $val){
			$returnArray[] = array( 'id'=>$val['PurchaseOrder']['id'], 'value'=>$val['PurchaseOrder']['purchase_order_number']);	
		}
		//debug($returnArray);
		echo json_encode($returnArray);
		exit;
	}
	
	
	function searchGrn(){
		$this->autoRender = false;
		$this->layout = false;
		$searchKey = $this->params->query['term'] ; 
		$this->uses = array("PurchaseOrderItem");		
		$data = $this->PurchaseOrderItem->find('all',array('conditions'=>array('PurchaseOrderItem.grn_no LIKE'=>"%".$searchKey."%"),'group'=>'PurchaseOrderItem.grn_no','limit'=>15));
		foreach ($data as $val){
			$returnArray[] = array( 'id'=>$val['PurchaseOrderItem']['id'], 'value'=>$val['PurchaseOrderItem']['grn_no']);	
		}
		//debug($returnArray);
		echo json_encode($returnArray);
		exit;
	}
	
	// Validation for PartyInvoiceNumber
	function checkPartyNumber($data){
		$this->uses = array('InventorySupplier','PurchaseOrder');
		$partyNumber = $data['PurchaseOrder']['party_invoice_number'];
		$supplierName = $data['inventory_supplier_name'];
		$locationID = $this->Session->read('locationid');
		$supplierId = $this->InventorySupplier->find('first',array(
					'conditions'=>array('InventorySupplier.name'=>$supplierName,'InventorySupplier.location_id'=>$locationID),
					'fields'=>array('InventorySupplier.id')
				));
		
		$purchaseDetials = $this->PurchaseOrder->find('all',array('conditions'=>array('PurchaseOrder.supplier_id'=>$supplierId['InventorySupplier']['id'],'PurchaseOrder.party_invoice_number'=>$partyNumber)));
		if($purchaseDetials){
			$this->Session->setFlash(__('Party Invoice Number is already exist!Please Resubmit <b>'.$data['purchase_order_no'].'</b>'), 'default', array('class'=>'error'));
			$this->redirect(array('controller'=>'PurchaseOrders','action'=>'purchase_order_list'));
			exit;
		}
	}
        
        public function editGrn($id,$itemId = null)
	{
		$this->autoRender = false;
		$this->Layout = 'ajax';
		$this->loadModel('StoreLocation');
		if(!$id)
		{
			throw new NotFoundException(__('Invalid GRN Id'));
		}
		else
		{
			$grnId = $this->PurchaseOrderItem->find('first',array('conditions'=>array('PurchaseOrderItem.id'=>$itemId)));
			$this->PurchaseOrder->bindModel(array('belongsTo'=>array(
					
					'InventorySupplier'=>array('foreignKey'=>'supplier_id',
												'fields'=>array('InventorySupplier.id','InventorySupplier.name')),
					'StoreLocation'=>array('foreignKey'=>'order_for',
											'fields'=>array('StoreLocation.id','StoreLocation.name')))));
		
			$PO_Detail = $this->PurchaseOrder->find('first',array('conditions'=>array('PurchaseOrder.id'=>$id)));	//heading 
			$this->set('po_details',$PO_Detail);
		
			$this->loadModel('ManufacturerCompany');
			$this->PurchaseOrderItem->bindModel(array('belongsTo'=>array(
				'PurchaseOrder' => array('foreignKey'=>false,
											'fields'=>array('PurchaseOrder.contract_id'),
											'conditions'=>array('PurchaseOrder.id=PurchaseOrderItem.purchase_order_id')),
		
				'Product'=>array('foreignKey'=>'product_id'),
		
				'ManufacturerCompany'=>array('foreignKey'=>false,
											'fields'=>array('ManufacturerCompany.name'),
											'conditions'=>array('ManufacturerCompany.id=Product.manufacturer_id'))
					)));
		
			$items = $this->PurchaseOrderItem->find('all',array(
								'conditions'=>array('PurchaseOrderItem.purchase_order_id'=>$id,'PurchaseOrderItem.grn_no'=>$grnId['PurchaseOrderItem']['grn_no']/*,'PurchaseOrderItem.status'=>1*/)));
			 
			$this->set('items',$items);
			
			if($this->request->data){
				$this->PurchaseOrder->editPurchaseJv($this->request->data);
				$saved = false;
				$department = $this->request->data['order_for']; 
				if(!empty($this->request->data['purchase_order_item'])){
					foreach($this->request->data['purchase_order_item'] as $key => $val){
						$val['party_invoice_number'] = $this->request->data['PurchaseOrder']['party_invoice_number'];
						$this->PurchaseOrderItem->id = $val['id'];
						if($this->PurchaseOrderItem->save($val)){
							$this->updateRates($val,$department);
							$saved = true;
						}
						$this->PurchaseOrderItem->id = '';
					}
				}
				if($saved == true){
					$purchaseOrderData = $this->PurchaseOrderItem->find('all',array('fields'=>array('SUM(PurchaseOrderItem.amount) as amount','SUM((PurchaseOrderItem.amount*PurchaseOrderItem.tax)/100) as tax'),'conditions'=>array('PurchaseOrderItem.purchase_order_id'=>$this->request->data['PurchaseOrder']['id'])));
					$this->request->data['PurchaseOrder']['total'] = $purchaseOrderData[0][0]['amount'];
					$this->request->data['PurchaseOrder']['vat'] = $purchaseOrderData[0][0]['tax'];
					$this->request->data['PurchaseOrder']['net_amount'] = $purchaseOrderData[0][0]['amount']+$purchaseOrderData[0][0]['tax'];
					$this->request->data['PurchaseOrder']['received_date'] = DateFormatComponent::formatDate2STD($this->request->data['PurchaseOrder']['received_date'],Configure::read('date_format'));
					$this->request->data['PurchaseOrder']['modify_time'] = $this->Session->read('userid');
					$this->PurchaseOrder->id = $this->request->data['PurchaseOrder']['id'];
					$this->PurchaseOrder->save($this->request->data['PurchaseOrder']);
					$this->PurchaseOrder->editPurchaseJv($this->request->data);
					$this->Session->setFlash(__('GRN updated successfully..', true));
					return $this->redirect(array("action"=>"purchase_receipt"));
				}
			}
			$this->render('edit_grn');
		}
	}
        
        //function to update the mrp, purchase price and sale price while editing the grn - swapnil 	16.06.2015
	public function updateRates($data,$department){
		$this->uses = array('StoreLocation','ProductRate','PharmacyItem','PharmacyItemRate');
		$allLocations = $this->StoreLocation->find('list',array('fields'=>array('id','code_name'),'conditions'=>array('is_deleted'=>0)));
		$centralStoreId = array_search(Configure::read('centralStoreCode'), $allLocations);
		$apamId = array_search(Configure::read('apamCode'), $allLocations);
		$pharmacyId = array_search(Configure::read('pharmacyCode'), $allLocations); 
		
		if($department == $centralStoreId){ 
			$arrayToSave = array('mrp'=>$data['mrp'],'purchase_price'=>$data['purchase_price'],'sale_price'=>$data['selling_price']);
			if($this->ProductRate->updateAll($arrayToSave, array('ProductRate.product_id' => $data['product_id'],'ProductRate.batch_number'=>$data['batch_number']))){
				return true;
			} 
		}
		
		if($department == $apamId || $department == $pharmacyId){
			$pharmacyId = $this->PharmacyItem->find('first',array('fields'=>array('PharmacyItem.id'),'conditions'=>array('PharmacyItem.drug_id'=>$data['product_id'])));
			$arrayToSave = array('mrp'=>$data['mrp'],'purchase_price'=>$data['purchase_price'],'sale_price'=>$data['selling_price']);
			if($this->PharmacyItemRate->updateAll($arrayToSave, array('PharmacyItemRate.item_id' => $pharmacyId['PharmacyItem']['id'],'PharmacyItemRate.batch_number'=>$data['batch_number']))){
				return true;
			}
		}
	}

	public function checkInvoiceNumber($invoiceNumber){
		if(empty($invoiceNumber)){
			echo json_encode("1");
			exit;
		}
		$this->layout = false;
		$this->autoRender = false;
		$this->uses = array("PurchaseOrder");
		$data = $this->PurchaseOrder->find('first',array('conditions'=>array('party_invoice_number'=>$invoiceNumber)));
		if(!empty($data)){
			echo json_encode("2");
		}else{
			echo json_encode("3");
		}
		exit;
	}
        
        //function to get the stock and values of GRN
	public function productPurchaseReports(){  
		$this->set('title_for_layout',__('GRN Report'));
		$this->layout = "advance"; 
		$this->uses = array("PurchaseOrder","PurchaseOrderItem","StoreLocation"); 
		//Store Locations
		$storeLocation = ($this->StoreLocation->find('list',array('fields'=>array('id','name'),'conditions'=>array('allow_purchase'=>1))));
		$this->set('storeLocation',$storeLocation);

                $fromDate = date("Y-m-d")." 00:00:00";
                $toDate = date("Y-m-d")." 23:59:59";
		if(!empty($this->request->query)){
                    if(!empty($this->request->query['from_date'])){
                            $fromDate = $this->DateFormat->formatDate2STDForReport($this->params->query['from_date'],Configure::read('date_format'))." 00:00:00";
                    } 

                    if(!empty($this->request->query['to_date'])){
                            $toDate = $this->DateFormat->formatDate2STDForReport($this->params->query['to_date'],Configure::read('date_format'))." 23:59:59";
                    } 

                    if(!empty($this->request->query['supplier_id'])){
                            $conditions['PurchaseOrder.supplier_id'] = $this->request->query['supplier_id'];
                    }
                    
                    if(!empty($this->request->query['product_id'])){
                            $conditions['PurchaseOrderItem.product_id'] = $this->request->query['product_id'];
                    }
                    
                    if(!empty($this->request->query['store_location'])){
                            $conditions['PurchaseOrder.order_for'] = $this->request->query['store_location'];
                    } 
		} 
                $conditions['PurchaseOrder.received_date BETWEEN ? AND ?'] = array($fromDate,$toDate);
                
		$this->PurchaseOrderItem->bindModel(array(
			'belongsTo'=>array(
				'PurchaseOrder'=>array( 
					'type'=>'inner',
					'foreignKey'=>'purchase_order_id'
				),
				'Product'=>array(
					'type'=>'inner',
					'foreignKey'=>'product_id'
				),
				'InventorySupplier'=>array(
					'foreignKey'=>false,
					'type'=>'inner',
					'conditions'=>array(
						'PurchaseOrder.supplier_id = InventorySupplier.id')
				),
				'StoreLocation'=>array(
					'foreignKey'=>false,
					'type'=>'inner',
					'conditions'=>array(
						'PurchaseOrder.order_for = StoreLocation.id')
				)
			)),false); 

		$conditions['PurchaseOrderItem.grn_no !='] = NULL;
		$conditions['PurchaseOrder.is_deleted'] = '0';

                //to get the total values = totalQty * PurchasePrice
                $totalValue = $this->PurchaseOrderItem->find('first',array(
                    'fields'=>array('SUM(PurchaseOrderItem.purchase_price * PurchaseOrderItem.quantity_received) as total'),
                    'conditions'=>$conditions));
                $this->set(compact('totalValue'));
		if(!empty($this->request->query['excel']) && $this->request->query['excel'] == "Generate Excel"){
			$result = $this->PurchaseOrderItem->find('all',array(
					'order' => array('PurchaseOrderItem.received_date'=>'asc'),
					'conditions' => $conditions,
					'fields'=>array(
						'PurchaseOrderItem.received_date, PurchaseOrderItem.batch_number, PurchaseOrderItem.grn_no,
						 PurchaseOrderItem.quantity_received, PurchaseOrderItem.purchase_price',
						'PurchaseOrder.order_for','Product.name','InventorySupplier.name','StoreLocation.name')
				));
			$this->set('results',$result);
			$this->layout = false;
			$this->render('product_purchase_reports_xls');
		}else{
                    $this->paginate = array(
                                    'limit' => Configure::read('number_of_rows'),
                                    'order' => array('PurchaseOrderItem.received_date'=>'asc'),
                                    'conditions' => $conditions,
                                    'fields'=>array(
                                            'PurchaseOrderItem.received_date, PurchaseOrderItem.batch_number, PurchaseOrderItem.grn_no,
                                             PurchaseOrderItem.quantity_received, PurchaseOrderItem.purchase_price',
                                            'PurchaseOrder.order_for','Product.name','InventorySupplier.name','StoreLocation.name')
                    ); 
                    $result = $this->paginate('PurchaseOrderItem');   
                    $this->set('results',$result);
		} 
 		
	}
 
        /*
         * function to send mail if purchase price hike from previous purchase price
         * @author : Swapnil
         * @created : 31.03.2016
         */
        public function sendPurchaseHikeMail($details = array(),$POIid){ 
            if(empty($details)) return false;
            $htmlDetail = array();
            $this->loadModel('PurchaseOrder'); 
            $this->PurchaseOrder->hasMany = array();
            $this->PurchaseOrder->bindModel(array(
                'belongsTo'=>array(
                    'InventorySupplier'=>array(
                        'foreignKey'=>'supplier_id',
                        'type'=>'inner'
                    ),
                    'User'=>array(
                        'foreignKey'=>'created_by'
                    )
                )
            ));
            $poData = $this->PurchaseOrder->find('first',array(
                'fields'=>array(
                    'PurchaseOrder.id, PurchaseOrder.purchase_order_number, PurchaseOrder.party_invoice_number, PurchaseOrder.received_date',
                    'InventorySupplier.name',
                    'CONCAT(User.first_name," ",User.last_name) as full_name'
                ),
                'conditions'=>array(
                    'PurchaseOrder.id'=>$details['purchase_order_id']
                )
            )); 
            
            $text =  '<p align="center">Hike In Purchase Price</p><hr>'.
                         "<table width='100%'>".
                            "<tr>".
                                "<td>Supplier : </td><td>{$poData['InventorySupplier']['name']}</td>".
                                "<td>Invoice Number : </td><td>{$poData['PurchaseOrder']['party_invoice_number']}</td>".
                            "</tr>".
                            "<tr>".
                                "<td>GRN No : </td><td>{$details['grn_no']}</td>".
                                "<td>GRN Date : </td><td>{$poData['PurchaseOrder']['received_date']}</td>".
                            "</tr>".
                            "<tr>".
                                "<td>PO No : </td><td>{$poData['PurchaseOrder']['purchase_order_number']}</td>".
                                "<td>Created By : </td><td>{$poData['0']['full_name']}</td>".
                            "</tr>".
                        "</table><hr>";
            $text .= "<table border='1' width='100%' style='border-collapse: collapse; margin-top:20px;'>".
                        "<thead>".
                            "<tr>".
                                "<td style='padding:2px;'>Sr.No</td>".
                                "<td style='padding:2px;'>Product Name</td>".
                                "<td style='padding:2px;'>Quantity</td>".
                                "<td style='padding:2px;'>Previous Price</td>".
                                "<td style='padding:2px;'>Current Price</td>".
                                "<td style='padding:2px;'>Reason of hike</td>".
                            "</tr>".
                        "</thead>".
                        "<tbody>";
                        $cnt = 0; foreach($details['details'] as $key => $val){ $cnt++;
            $text .=        "<tr>".
                                "<td style='padding:2px;'>{$cnt}</td>".
                                "<td style='padding:2px;'>{$val['name']}</td>".
                                "<td style='padding:2px;'>{$val['quantity_received']}</td>".
                                "<td style='padding:2px;'>{$val['previous_purchase_price']}</td>".
                                "<td style='padding:2px;'>{$val['purchase_price']}</td>".
                                "<td style='padding:2px;'>{$val['reason']}</td>".
                            "</tr>"; 
                        }
            $text .=    "</tbody>";   
               
            $subject = "Hike in Purchase Price"; 
            $toSend = array("Dr.BK Murli"=>"cmd@hopehospital.com","Shrikanth Bhalerao"=>"shrikanth@thehopehospital.com","Swapnil Sharma"=>"swapnils@drmhope.com");
            //$toSend = array("Swapnil Sharma"=>"swapnils@drmhope.com","Mrunal Matey"=>"mrunalm@drmhope.com");
            //draw pdf
            App::import('Vendor', 'TCPDFLang', array('file' => 'tcpdf/config/lang/eng.php')); 
            App::import('Vendor', 'TCPDF', array('file' => 'tcpdf/tcpdf.php'));  

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false,false,true); 
            $pdf->SetCreator(PDF_CREATOR); 
            $pdf->AddPage();
            $pdf->SetFont('times', '',11);
            $pdf->setPage(1, true);   

            $pdf->writeHTML($text,1,null,null,null,null); 
            $filename = 'purchase_orders/'.$details['purchase_order_id'].'.pdf';
            $pdfdoc = $pdf->Output($filename, "F"); 

            //email stuff
            $res = $this->General->sendMailwithAttachment(array(
                'to'=>$toSend,
                'from'=>"info@hopehospital.com",
                'subject'=>"Hike in Purchase Price",
                'text'=>"<p>Please see the attachment of purchase list.</p>",
                'attachment'=>$filename
            ));    
            return $res;
        }
}
?>