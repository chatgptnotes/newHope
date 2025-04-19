<?php
/**
 * Pharmacy Controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.drmhope.com/
 * @package       Store.Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj Wanjari
 */
class StoreController extends AppController {

	public $name = 'Stores';
	public $uses = array('Product','ProductRate');
	public $components = array('RequestHandler','Email','DateFormat','Number','General');
	public $helpers = array('Html','Form', 'Js','DateFormat','Number','General');


	/**
	 * list page
	*/

	
	public function index(){
		$this->set('title_for_layout', __('Products', true));
		//$this->layout ='advance';
		$this->uses = array("ServiceProvider","ManufacturerCompany","InventorySupplier","Location");
		$this->Product->bindModel(array('belongsTo' => array(
				'ServiceProvider'=>array('foreignKey'=>'supplier_id'),
				'InventorySupplier'=>array('foreignKey'=>'supplier_id'),
				'ManufacturerCompany'=>array('foreignKey'=>'manufacturer_id'))),false);
		
		$this->request->data = $this->request->query;
		//debug($this->request->data);
		$itemName = $this->request->data['name'];   
		$manufacturer = $this->request->data['manufacturer']; 
		
		$supplier_name = $this->request->data['supplier_name'];
	
		$apamLocation = $this->Location->getLocationIdByName(Configure::read('apamCode'));
		
		if(!empty($itemName)){
			$conditions['Product.name'] = $itemName;
		}
		if(!empty($manufacturer)){
			$conditions['ManufacturerCompany.name'] = $manufacturer;
		}
		if(!empty($supplier_name)){
			$conditions['InventorySupplier.name'] = $supplier_name;
		}
		$conditions['Product.location_id !='] = $apamLocation; 
		$this->paginate = array(
				'limit' => 15,
				'fields'=>array('PharmacyItem.id','PharmacyItem.name','PharmacyItem.item_code','PharmacyItemRate.batch_number','PharmacyItemRate.purchase_price',
						'PharmacyItemRate.mrp','PharmacyItemRate.sale_price','PharmacyItemRate.tax','PharmacyItemRate.expiry_date'),
				'conditions' =>array($conditions,'PharmacyItem.location_id !='=>$apamLocation)
		);
		
		$this->paginate = array('limit' => Configure::read('number_of_rows'),
				'fields'=>array('Product.*','ServiceProvider.id','ServiceProvider.name','ManufacturerCompany.name','InventorySupplier.name'),
				'order'=>array('Product.name'=>'ASC'),
				'conditions'=>array($conditions));
		
		$results = $this->paginate('Product');  
		$this->set('results',$results);
	}


	public function addProduct()
	{
		$this->layout ='advance';
		$this->set('title_for_layout', __('Add Product', true));
		$this->uses=array('ServiceProvider','StoreLocation','Department','ProductRate','Location','Configuration','VatClass','PharmacyItem','GenericComponent');
		$service=$this->ServiceProvider->getServiceProvider('other');
		
		$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website')));
		$websiteConfig=unserialize($website_service_type['Configuration']['value']);
		$this->set('websiteConfig',$websiteConfig);
		
		$this->set('serviceProviders',$service);
		$this->set('allProductCode',$this->Product->find('list',array('fields'=>array('Product.product_code'))));
		$this->set('departments',$this->StoreLocation->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_deleted'=>'0'))));
		$this->set('locations',$this->Location->find('list',array('fields'=>array('id','name'))));
		
		$this->loadModel('ManufacturerCompany');
		if(!empty($this->request->data))
		{
			
			if(empty($this->request->data['Product']['manufacturer_id'])){
				$isManufacturer = $this->ManufacturerCompany->find('first',array('conditions'=>array('ManufacturerCompany.name'=>$this->request->data['Product']['manufacturer'])));
				if(!empty($isManufacturer['ManufacturerCompany']['id'])){
					$this->request->data['Product']['manufacturer_id'] = $isManufacturer['ManufacturerCompany']['id'];
				}else{
					$data['name'] = $this->request->data['Product']['manufacturer'];
					$data['location_id'] = $this->request->data['Product']['location_id'];
					$this->request->data['Product']['manufacturer_id'] = $this->ManufacturerCompany->insertManufacturer($data);
				}
			}
			/*add generic name if not exist*/
			if(!empty($this->request->data['Product']['generic_id'])){
				$generic_name = $this->request->data['Product']['generic'] ;
			}else{
				$data['generic_name'] = $this->request->data['Product']['generic'];
				$this->GenericComponent->insertGenericName($data);
				$generic_name = $this->request->data['Product']['generic'] ;
			}
			#debug($this->request->data);exit;
			
			$this->request->data['Product']['generic'] = $generic_name ;

			$this->request->data['Product']['date']=$this->DateFormat->formatDate2STDForReport($this->request->data['date'],Configure::read('date_format'));
			$this->request->data['Product']['expiry_date']=$this->DateFormat->formatDate2STDForReport($this->request->data['Product']['expiry_date'],Configure::read('date_format'));
			$exists = false;
			$count = $this->Product->find('count',array('conditions'=>array('Product.product_code'=>$this->request->data['Product']['product_code'])));
			if($count >0 && $this->request->data['Product']['product_code']!=''){
				$exists = true;
			}
			
			$nameCount = $this->Product->find('count',array('conditions'=>array('Product.name'=>$this->request->data['Product']['name'],'Product.location_id'=>$this->request->data['Product']['location_id'])));
			if($nameCount >0){
				$exists = true;
			} 
			if($exists == true){
				$this->Session->setFlash(__('Product code or Product name is already exists'), 'default',array('class'=>'error'));
				$this->data = $this->request->data; 
			}
			else
			{
				if($this->Product->save($this->request->data['Product']))
				{
					$productID = $this->Product->getLastInsertID();
					//add on pharmacy table if product loaction is APAM
					$apamlocationId = $this->Location->getLocationIdByName(Configure::read('apamCode'));
					if(!empty($productID) && $this->request->data['Product']['location_id'] == $apamlocationId){
						$this->PharmacyItem->save(array(
								"location_id"=>$this->request->data['Product']['location_id'],
								"expensive_product"=> $this->request->data['Product']['expensive_product'],
								"name"=>$this->request->data['Product']['name'],
								"item_code"=>$this->request->data['Product']['product_code'],
								"drug_id"=>$productID,
								"date"=>$this->DateFormat->formatDate2STD($this->request->data['Product']['date'],Configure::read('date_format')),
								"minimum"=>$this->request->data['Product']['minimum'],
								"maximum"=>$this->request->data['Product']['maximum'],
								"doseForm"=>$this->request->data['Product']['doseForm'],
								"vat_class_id"=>$this->request->data['Product']['vat_class_id'],
								'supplier_id'=>$this->request->data['Product']['supplier_id'],
								"pack"=>$this->request->data['Product']['pack'],
								"manufacturer"=>$this->request->data['Product']['manufacturer'],
								"manufacturer_company_id"=>$this->request->data['Product']['manufacturer_id'],
								"generic"=>$this->request->data['Product']['generic'],
								"stock"=>$this->request->data['Product']['quantity'],
								"gen_ward_discount"=>$this->request->data['Product']['gen_ward_discount'],
								"spcl_ward_discount"=>$this->request->data['Product']['spcl_ward_discount'],
								"dlx_ward_discount"=>$this->request->data['Product']['dlx_ward_discount'],
								"semi_spcl_ward_discount"=>$this->request->data['Product']['semi_spcl_ward_discount'],
								"islolation_ward_discount"=>$this->request->data['Product']['islolation_ward_discount'],
								"create_time"=> date('Y-m-d'),
								"created_by"=>$this->Session->read('userid'),
						));
					}
					//$this->ProductRate->insertRate($this->request->data['Product'],$productID);
					$this->Session->setFlash(__($this->request->data['Product']['name'].' has been saved successfully', true));
					$this->redirect(array('action'=>'index'));
				}
				else
				{
					$this->Session->setFlash(__('Could not add', false));
				}
			}
		}
		$vatData = $this->VatClass->find('list',array(
				'conditions'=>array('VatClass.is_delete'=>'0'),
				'fields'=>array('id','vat_of_class'),
				/*'order'=>array('VatClass.create_time'=>'desc')*/));
			
		
		$this->set(compact(array('data','vatData')));
	}

	public function editProduct($id=null){
		$this->layout = 'advance';
		$this->set('title_for_layout', __('Edit Products', true));
		$this->loadModel('ServiceProvider');
		$this->loadModel('Department');
		$this->loadModel('Location');
		$this->set('serviceProviders',$this->ServiceProvider->getServiceProvider('other'));
		$this->set('locations',$this->Location->find('list',array('fields'=>array('id','name'))));
		
		//debug($this->request->data);
		
		if($this->request->data['Product'])
		{
			$this->request->data['Product']['date']=$this->DateFormat->formatDate2STD($this->request->data['Product']['date'],Configure::read('date_format'));
			$this->request->data['Product']['expiry_date']=$this->DateFormat->formatDate2STD($this->request->data['Product']['expiry_date'],Configure::read('date_format'));
			$this->request->data['Product']['id'] = $id;
			$this->Product->save($this->request->data['Product']);
			$this->Session->setFlash(__($this->request->data['Product']['name']." has been updated successfully", true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('departments',$this->Department->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_active'=>'1',
				'location_id'=>$this->Session->read('locationid')))));
		$this->Product->bindModel(array('belongsTo'=>array('ManufacturerCompany'=>array('foreignKey'=>'manufacturer_id','fields'=>array('ManufacturerCompany.name')),
								'InventorySupplier'=>array('foreignKey'=>'supplier_id','fields'=>array('InventorySupplier.name')))));
		$data =  $this->Product->find('first',array('conditions' => array("Product.id"=>$id)));
		$data['Product']['manufacturer'] = $data['ManufacturerCompany']['name'];
		$data['Product']['supplier_name'] = $data['InventorySupplier']['name'];
		$this->data=$data;
	}
	
	/*
	 * 		View Product with batches 
	 * 		by Swapnil G.Sharma
	 */
	public function viewProduct($id=null){
		$this->layout = 'advance_ajax';
		$this->set('title_for_layout', __('View Products', true));
		if(!empty($id)){
			$this->Product->bindModel(array('hasMany'=>array('ProductRate'=>array('foreignKey'=>"product_id"))));
			$data = $this->Product->find('first',array('conditions' => array("Product.id"=>$id)));	 
			$this->set('datas',$data);
		}
	}
	//eof viewProduct

	public function delete($id=null)
	{
		$this->set('title_for_layout', __('Delete Product', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Product'),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Product->delete($id)) {
			$this->Session->setFlash(__('Product has been deleted successfully'),'default',array('class'=>'message'));
			$this->redirect(array('action'=>'index'));
		}
	}


	public function GetValue(){
		$this->autoRender = false;
		$this->Layout = false;
		$this->uses=array('Product');
		$id = $this->request->query['id'];
		$result = $this->Product->find('first',array('conditions'=>array('Product.id'=>$id)));
			
		return($result);
	}


	/**BOF yash**/

	public function purchase_receipt() {
		$this->layout='advance';
		$this->loadModel('ProductDetail');
		$this->uses=array('Account','VoucherEntry','ProductItemDetail');
		$this->set('title_for_layout', __('Pharmacy Management - Purchase Receipt ', true));
		if ($this->request->is('post')) {
			$this->request->data['PurchaseDetail']['vr_date'] = $this->DateFormat->formatDate2STD($this->request->data['PurchaseDetail']['vr_date'],Configure::read('date_format'));
			$this->request->data['PurchaseDetail']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['PurchaseDetail']['created_by'] = $this->Auth->user('id');
			$this->request->data['PurchaseDetail']['location_id'] = $this->Session->read('locationid');

			$datasource = $this->ProductDetail->getDataSource();
			$datasource->begin();

			$this->ProductDetail->save($this->request->data['PurchaseDetail']);
			$this->ProductDetail->getLastInsertID();	//To get the latest inserted Id
			$userId = $this->request->data['PurchaseDetail']['party_id'];//retriving userid for accounting by amit jain
			$errors = $this->ProductDetail->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$accountArray = $this->Account->getAccountID($userId,Configure::read('InventorySupplier')); //for retriving AccountID to display legder creation entry. by amit jain
				if(empty($accountArray)){
					$this->Session->setFlash(__('The supplier account does not exit. Please create Account first to proceed', true),'default',array('class'=>'error'));
					$datasource->rollback();
				}else{
					$datasource->commit();
					//journal entry by amit
					$jvData = array('date'=>$this->request->data['PurchaseDetail']['vr_date'],
							'user_id'=>$accountArray['Account']['id'],
							'debit_amount'=>$this->request->data['PurchaseDetail']['total_amount']) ;
					//debug($jvData);
					//exit;
					if(!($this->VoucherEntry->insertJournalEntry($jvData,'Product'))){
						$datasource->rollback();
					}else{
						$datasource->commit();
						//EOF JV
						$insertDetails = $this->ProductItemDetail->saveDetails($this->request->data,$this->ProductDetail->id,$this->request->data['PrurchaseDetail']['party_id']);
						//$itemPrice = $this->PharmacyItemRate->insertRate($this->request->data);
						/*if(!$insertDetails && $itemPrice){
						 $this->ProductDetail->delete($this->ProductDetail->id);
						for($i=0;$i<count($itemPrice);$i++){
						$this->PharmacyItemRate->delete($itemPrice[$i]);
						}
						$this->Session->setFlash(__('Some Fields are missing', true));
						}else if($insertDetails && !$itemPrice){
						$this->ProductDetail->delete($this->ProductDetail->id);
						$this->ProductDetail->delete($itemPrice);
						}else{*/
						if(!$insertDetails){
							$datasource->rollback();
						}
						else{
							$datasource->commit();
							$this->Session->setFlash(__('Receipt Added successfully', true));
							if($this->request->data['print']){
								$url = Router::url(array("controller" => "Product", "action" => "print_view",'PurchaseReceipt',$this->ProductDetail->id));
									
								echo "<script>window.open('".$url."','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true );window.location.href=window.location.href;</script>";
							}else{
								$this->redirect(array("controller" => "Product", "action" => "get_product_details",'purchase',$this->ProductDetail->id));
							}
						}
					}
				}
			}
		}
		$this->set('vr_no',"PDR-".$this->Product->generateRandomBillNo());
	}


	public function issue_requisition($requisitionID=null){ 
		$this->layout='advance';
		$this->uses = array('StoreRequisition','Product',"PharmacyItemRate",'StoreLocation',"ProductRate","PatientCentricDepartment","Ward","Opt","Chamber",'StoreRequisitionParticular','StockMaintenance','PurchaseOrderitem');
		$status=$this->params->pass['1'];
		$this->set('status',$status);
		
		if($requisitionID !=null ){
			
			$StoreRequisition = $this->StoreRequisition->read(null,$requisitionID);
			//Requisition From
			$storeLocation = $this->StoreLocation->find('first',array('conditions'=>array('StoreLocation.id'=>$StoreRequisition['StoreRequisition']['requisition_for']))); 
			//Requisition To
			$requisitionTo = $this->StoreLocation->find('first',array('conditions'=>array('StoreLocation.id'=>$StoreRequisition['StoreRequisition']['store_location_id'])));
			
		if($this->request->data){  
			//debug($this->request->data); exit;
			$stockm=$this->StockMaintenance->find('all');	 
			$this->request->data['StoreRequisition']['id']=$requisitionID;
			$this->request->data['StoreRequisition']['updated_by']=$this->Session->read('userid');
			$this->request->data['StoreRequisition']['issue_date']=$this->DateFormat->formatDate2STD($this->request->data['StoreRequisition']['issue_date'],Configure::read('date_format'));
			$this->request->data['StoreRequisition']['updated_time']=date('Y-m-d H:i:s'); 
			
			$this->StoreRequisition->save($this->request->data['StoreRequisition']);
			
				if($StoreRequisition['StoreRequisition']['requisition_for']&&!empty($StoreRequisition['StoreRequisition']['requister_id'])){
					$depart_id=$StoreRequisition['StoreRequisition']['requisition_for'];
					$subdepartID=$StoreRequisition['StoreRequisition']['requister_id'];
				}else if(empty($StoreRequisition['StoreRequisition']['requister_id'])){
					$depart_id=$StoreRequisition['StoreRequisition']['requisition_for'];
				} 
				$loc = $this->Session->read('locationid');
				$userId = $this->Session->read('userid');
				$pharmacy = array('pharmacy'=>'pharmacy');
				//pr($this->request->data['StoreRequisition']);
				$saveResult = $this->StoreRequisitionParticular->saveParticulars($this->request->data['StoreRequisition']['slip_detail'],$requisitionID,$status,$this->request->query['pharmacy'],$userId,$loc,$requisitionTo);
 				
			if(!empty($saveResult) && $saveResult == 1){
				if($this->StockMaintenance->setStock($depart_id,$subdepartID,$requisitionID,$this->request->data['StoreRequisition']['slip_detail'])){
				$this->Session->setFlash(__('The requisition has been issued succesfully', true),'default',array('class'=>'message'));
					if($this->params->query['pharmacy']){
						//redirect change by pankaj initially set to 'store_requisition_list'
						$this->redirect(array("controller" => "InventoryCategories", "action" => "store_inbox_requistion_list",'?'=>array('pharmacy'=>'pharmacy')));
					}else{
						$this->redirect(array("controller" => "InventoryCategories", "action" => "store_inbox_requistion_list",'?'=>array('requisitionId'=>$requisitionID)));
					}
				}else{
					$this->Session->setFlash(__('Please try again', true),'default',array('class'=>'error'));
				}
			}
			else {  
				$this->set("errors", $saveResult);
			} 
		}
		
		
			if(strtolower($requisitionTo['StoreLocation']['name']) == strtolower(Configure::read('OT Pharmacy'))){
				$this->StoreRequisitionParticular->unbindModel(array('belongsTo'=>array('Product','PurchaseOrderItem')));
	
				$this->StoreRequisitionParticular->bindModel(array(
					'belongsTo'=>array(
						'PharmacyItemRate'=>array('foreignKey'=>false,'conditions'=>array('StoreRequisitionParticular.purchase_order_item_id = PharmacyItemRate.id')),
						'PharmacyItem'=>array('foreignKey'=>false,'conditions'=>array('PharmacyItemRate.item_id = PharmacyItem.id')),
						'Product'=>array('foreignKey'=>false,'conditions'=>array('PharmacyItem.drug_id=Product.id')),
						'ManufacturerCompany'=>array('foreignKey'=>false,'conditions'=>array('ManufacturerCompany.id=Product.manufacturer_id'))
							)));
				$storeDetails = $this->StoreRequisitionParticular->find('all',array('conditions'=>array('StoreRequisitionParticular.store_requisition_detail_id'=>$requisitionID)));
				
				foreach($storeDetails as $key => $value){
					$storeDetails[$key]['ProductRate']['batch_number']= $value['PharmacyItemRate']['batch_number'];
					$storeDetails[$key]['ProductRate']['expiry_date']= $value['PharmacyItemRate']['expiry_date'];
					$storeDetails[$key]['ProductRate']['stock']= $value['PharmacyItemRate']['stock'];
					$storeDetails[$key]['ProductRate']['mrp']= $value['PharmacyItemRate']['mrp'];
					$storeDetails[$key]['ProductRate']['sale_price']= $value['PharmacyItemRate']['sale_price'];
					
				}
			}
			
			
			
			else if(strtolower($requisitionTo['StoreLocation']['name']) == strtolower(Configure::read('Pharmacy'))){
				//by swapnil to fetch the records from pharmacy 
				$this->StoreRequisitionParticular->unbindModel(array('belongsTo'=>array('Product','PurchaseOrderItem')));
	
				$this->StoreRequisitionParticular->bindModel(array(
					'belongsTo'=>array(
						'PharmacyItem'=>array('foreignKey'=>false,'conditions'=>array('StoreRequisitionParticular.purchase_order_item_id = PharmacyItem.id')),
						'PharmacyItemRate'=>array('foreignKey'=>false,'conditions'=>array('PharmacyItemRate.item_id = PharmacyItem.id')),
						'Product'=>array('foreignKey'=>false,'conditions'=>array('PharmacyItem.drug_id=Product.id')),
						'ManufacturerCompany'=>array('foreignKey'=>false,'conditions'=>array('ManufacturerCompany.id=Product.manufacturer_id'))
							)));
				
				$storeDetails = $this->StoreRequisitionParticular->find('all',array(
						'conditions'=>array('StoreRequisitionParticular.store_requisition_detail_id'=>$requisitionID),
						'group'=>array('StoreRequisitionParticular.id')));
				 
				foreach($storeDetails as $key => $value){
					//only created an array of ProductRate 
					$storeDetails[$key]['ProductRate']['batch_number']= $value['PharmacyItemRate']['batch_number'];
					$storeDetails[$key]['ProductRate']['expiry_date']= $value['PharmacyItemRate']['expiry_date'];
					$storeDetails[$key]['ProductRate']['stock']= $value['PharmacyItemRate']['stock'];
					$storeDetails[$key]['ProductRate']['mrp']= $value['PharmacyItemRate']['mrp'];
					$storeDetails[$key]['ProductRate']['sale_price']= $value['PharmacyItemRate']['sale_price'];
				}
			}
			
			//APAM ISSUE
			else if(strtolower($requisitionTo['StoreLocation']['name']) == strtolower(Configure::read('apamCode'))){
				//by swapnil to fetch the records from pharmacy where location_id is apam
				$this->StoreRequisitionParticular->unbindModel(array('belongsTo'=>array('Product','PurchaseOrderItem')));
	
				$this->StoreRequisitionParticular->bindModel(array(
					'belongsTo'=>array(
						'PharmacyItem'=>array('foreignKey'=>false,'conditions'=>array('StoreRequisitionParticular.purchase_order_item_id = PharmacyItem.id')),
						'PharmacyItemRate'=>array('foreignKey'=>false,'conditions'=>array('PharmacyItemRate.item_id = PharmacyItem.id')),
						'Product'=>array('foreignKey'=>false,'conditions'=>array('PharmacyItem.drug_id=Product.id')),
						'ManufacturerCompany'=>array('foreignKey'=>false,'conditions'=>array('ManufacturerCompany.id=Product.manufacturer_id'))
							)));
							
				$storeDetails = $this->StoreRequisitionParticular->find('all',array(
								'conditions'=>array('StoreRequisitionParticular.store_requisition_detail_id'=>$requisitionID),
								'group'=>array('StoreRequisitionParticular.id')));

				foreach($storeDetails as $key => $value){
					//only created an array of ProductRate 
					$storeDetails[$key]['ProductRate']['batch_number']= $value['PharmacyItemRate']['batch_number'];
					$storeDetails[$key]['ProductRate']['expiry_date']= $value['PharmacyItemRate']['expiry_date'];
					$storeDetails[$key]['ProductRate']['stock']= $value['PharmacyItem']['stock'];
					$storeDetails[$key]['ProductRate']['loose_stock']= $value['PharmacyItem']['loose_stock'];
					$storeDetails[$key]['ProductRate']['mrp']= $value['PharmacyItemRate']['mrp'];
					$storeDetails[$key]['ProductRate']['sale_price']= $value['PharmacyItemRate']['sale_price'];
				}
			}else{
				
				
				$this->StoreRequisitionParticular->unbindModel(array('belongsTo'=>array('PurchaseOrderItem','Product','StoreRequisition')));	//by swapnil
				$this->StoreRequisitionParticular->bindModel(array(
						'belongsTo'=>array( 
							'StoreRequisition'=>array('foreignKey'=>'store_requisition_detail_id'), 
							'Product'=>array('foreignKey'=>'purchase_order_item_id' ),
							'ManufacturerCompany'=>array('foreignKey'=>false,'conditions'=>array('ManufacturerCompany.id=Product.manufacturer_id')),
							'ProductRate'=>array(
								'foreignKey'=>false,
								'conditions'=>array('ProductRate.product_id = Product.id')),
							
			//'PurchaseOrderItem'=>array('foreignKey'=>false,'conditions'=>array('StoreRequisitionParticular.purchase_order_item_id = PurchaseOrderItem.id')),
						)),false);
						
				$storeDetails = $this->StoreRequisitionParticular->find('all',array(
									'conditions'=>array('StoreRequisitionParticular.store_requisition_detail_id'=>$requisitionID),
									'group'=>array('StoreRequisitionParticular.id')));

				foreach($storeDetails as $key => $value){ 
					//only created an array of ProductRate  
					$storeDetails[$key]['ProductRate']['stock']= $value['Product']['quantity'];
					$storeDetails[$key]['ProductRate']['loose_stock']= $value['Product']['loose_stock']; 
				} 
			} 
			
		$requsition_for='';
		//If the requisition is for Pharmacy form Normal requisitions--Pooja
		if(strtolower($storeLocation['StoreLocation']['code_name'])==strtolower(Configure::read('pharmacyCode'))){
			$requisitionForName=Configure::read('pharmacyCode');
		}
		
		
		if($requisitionForName == Configure::read('pharmacyCode')){
			$roleId=$this->Session->read('roleid'); 
			$pharmaDepart = $this->StoreLocation->find('first',
					array('conditions'=>array('StoreLocation.is_deleted' =>'0','StoreLocation.code_name' => Configure::read('pharmacyCode'),'StoreLocation.role_id LIKE'=>'%'.$roleId.'%')),
					array('fields'=>array('StoreLocation.id')));
			//$this->set('pharmaDepart',$pharmaDepart['StoreLocation']['id']);		
			$requsition_for = $pharmaDepart['StoreLocation']['name']; 
		}else{
			if($storeLocation['StoreLocation']['name'] == "Other"){
				$this->LoadModel("PatientCentricDepartment");
				$for = $this->PatientCentricDepartment->read(null,$StoreRequisition['StoreRequisition']['requister_id']);
				$requsition_for =$for['PatientCentricDepartment']['name'];
			}else if($storeLocation['StoreLocation']['name'] == "OT"){
				$for = $this->Opt->read(null,$StoreRequisition['StoreRequisition']['requister_id']);
				$requsition_for =$for['Opt']['name'];
			}else if($storeLocation['StoreLocation']['name'] == "Chamber"){
				$this->LoadModel("Chamber");
				$for = $this->Chamber->read(null,$StoreRequisition['StoreRequisition']['requister_id']);
				$requsition_for =$for['Chamber']['name'];
			}else if($storeLocation['StoreLocation']['name'] == "Ward"){
				$this->LoadModel("Ward");
				$for = $this->Ward->read(null,$StoreRequisition['StoreRequisition']['requister_id']);
				$requsition_for =$for['Ward']['name'];
			}
		} 
			if(!empty($requsition_for))
				$data['for'] =  $requsition_for;
			else{
				$data['for']=$StoreRequisition['StoreRequisition']['requisition_for'];
				$requsition_for=$storeLocation['StoreLocation']['name'];
			}
			
			/*$slip_detail  = unserialize($StoreRequisition['StoreRequisition']['slip_detail']);
				foreach($slip_detail['item_name'] as $key=>$value){
			$slipData[$value]=$this->Product->find('first',array('conditions'=>array('Product.name like'=>'%'.$value.'%')));
			}
			$i=0;
			foreach($slipData as $key=>$data){
			$details[$i]['product']= $key;
			$details[$i]['product_id']= $data['Product']['id'];
			$details[$i]['req_quantity']=$slip_detail['qty'][$i];
			$details[$i]['mrp']=$data['Product']['mrp'];
			$details[$i]['price']=$data['Product']['sale_price'];
			$details[$i]['item_code']=$data['Product']['product_code'];
			$details[$i]['manufacturer']=$data['Product']['manufacturer'];
			$details[$i]['pack']=$data['Product']['pack'];
			$details[$i]['batch_no']=$data['Product']['batch_number'];
			$details[$i]['expiry']=$data['Product']['expiry_date'];
			$details[$i]['amt']=$slip_detail['qty'][$i]*$data['Product']['sale_price'];
			$req['req_qty'][]=$slip_detail['qty'][$i];
			$remark['remark'][]=$slip_detail['remark'][$i];
			$i++;
			}*///debug($storeDetails);
			$data['for'] =  $requsition_for; 
			$this->set("StoreRequisition",$StoreRequisition);
			$this->set("storeDetails",$storeDetails);
			$this->set("requisition_for",$requsition_for);

		}
	} 

	/* for autocomplete */
	public function autocomplete_product($field=null){
		$searchKey = $this->params->query['q'];
		$filedOrder = array('id');
		if($field == "name"){
			array_push( $filedOrder,'product_code','name');
		}else{
			array_push( $filedOrder,'name','product_code');
		}
		$conditions[$field." like"] = $searchKey."%";
		$conditions["Product.location_id"] =$this->Session->read('locationid');
		//$conditions["PharmacyItem.supplier_id <>"] ="";
		$conditions["Product.is_deleted"] ='0';
		if(!isset($this->params->query['list']) && !isset($this->params->query['salesReturn']))
			$conditions["Product.quantity >"] ='0';
		$items = $this->Product->find('list', array('fields'=> $filedOrder,'conditions'=>$conditions,'group' => 'Product.product_code'));

		foreach ($items as $key=>$value) {
			$output ='';
			$output .= "$key|";
			foreach ($value as $k=>$v) {
				$output .= "$k|$v";
			}
			$output .= "|$field\n";
			echo $output;
		}
		exit;//dont remove this
	}


	/* for autocomplete */
	public function fetch_rate_for_item(){
		$this->uses = array('Product') ;
		if(!isset($_POST['name'])){
			$item = $this->Product->find('first',
					array('conditions'=>array('Product.id' =>$this->request->data['item_id'],'Product.location_id'=>$this->Session->read('locationid'))));
		}else{
			$item = $this->Product->find('first',
					array('conditions'=>array('Product.name' =>$this->request->data['item_name'],'Product.location_id'=>$this->Session->read('locationid'))));
		}
		/* 	if(!empty($item['Product']['expiry_date']))
		 $item['Product']['expiry_date'] = $this->DateFormat->formatDate2Local($item['Product']['expiry_date'],Configure::read('date_format'),false);
		if(!empty($item['Product']['date']))
			$item['Product']['date'] = $this->DateFormat->formatDate2Local($item['Product']['date'],Configure::read('date_format'),true); */

		echo json_encode($item);exit;
	}

	public function return_product($reqId=null, $status=null){
		$this->layout='advance';
		$this->uses=array('Product', 'StoreRequisition','StoreRequisitionParticular','User','StoreLocation','ProductRate','PharmacyItem','PharmacyItemRate');
		$StoreRequisition = $this->StoreRequisition->read(null,$reqId);
		$storeLocation = $this->StoreLocation->find('first',array('conditions'=>array('StoreLocation.id'=>$StoreRequisition['StoreRequisition']['requisition_for'])));
		$requisitionTo = $this->StoreLocation->find('first',array('conditions'=>array('StoreLocation.id'=>$StoreRequisition['StoreRequisition']['store_location_id'])));
		
		if($this->request->data){
			if($this->request->data){
				//debug($this->request->data);exit;
				//save/update data in StoreRequisition
				
				$loc = $this->Session->read('locationid');
				$userId = $this->Session->read('userid');
				
				//$this->request->data['StoreRequisition']['status']=$status;
				$this->request->data['StoreRequisition']['id']=$reqId;
				$this->request->data['StoreRequisition']['returned_by']=$this->request->data['StoreRequisition']['return_by'];
				$this->request->data['StoreRequisition']['updated_by']=$this->Session->read('userid');
				$this->request->data['StoreRequisition']['issue_date']=$this->DateFormat->formatDate2STD($this->request->data['StoreRequisition']['issue_date'],Configure::read('date_format'));
				$this->request->data['StoreRequisition']['return_date']=$this->DateFormat->formatDate2STD($this->request->data['StoreRequisition']['return_date'],Configure::read('date_format'));
				$this->request->data['StoreRequisition']['updated_time']=date('Y-m-d H:i:s');
				$this->request->data['StoreRequisition']['status'] = "Issued";
				
				$this->StoreRequisition->save($this->request->data['StoreRequisition']);
				if ($this->StoreRequisitionParticular->saveParticulars($this->request->data['StoreRequisition']['slip_detail'],$reqId,$status,null,$userId,$loc,$requisitionTo)) {
					$this->Session->setFlash(__('The products has been returned succesfully', true),'default',array('class'=>'message'));
					if ($this->params->query['pharmacy']) {
						$this->redirect(array("controller" => "InventoryCategories", "action" => "store_requisition_list",'?'=>array('pharmacy'=>'pharmacy')));
					} else {
						$this->redirect(array("controller" => "InventoryCategories", "action" => "store_requisition_list"));
					}
				} else {
					if (!empty($this->StoreRequisitionParticular->error)) {
						$this->Session->setFlash(__($this->StoreRequisitionParticular->error, true),'default',array('class'=>'error'));
					} else {
						$errors=$this->StoreRequisitionParticular->invalidFields();
						if (!empty($errors)) {
							$this->set("errors", $errors);
						}
					}
				}
			}
		}
			
		if(strtolower($requisitionTo['StoreLocation']['name']) == strtolower(Configure::read('Pharmacy'))){
			//by swapnil to fetch the records from pharmacy
			$this->StoreRequisitionParticular->unbindModel(array('belongsTo'=>array('Product','PurchaseOrderItem')));
			$this->StoreRequisitionParticular->bindModel(array(
				'belongsTo'=>array(
					'PharmacyItemRate'=>array('foreignKey'=>false,'conditions'=>array('StoreRequisitionParticular.purchase_order_item_id = PharmacyItemRate.item_id')),
					'PharmacyItem'=>array('foreignKey'=>false,'conditions'=>array('PharmacyItemRate.item_id = PharmacyItem.id')),
					'Product'=>array('foreignKey'=>false,'conditions'=>array('PharmacyItem.drug_id=Product.id')),
					'ManufacturerCompany'=>array('foreignKey'=>false,'conditions'=>array('ManufacturerCompany.id=Product.manufacturer_id'))
						)));
				$storeDetails = $this->StoreRequisitionParticular->find('all',array(
						'conditions'=>array('StoreRequisitionParticular.store_requisition_detail_id'=>$reqId),
						'group'=>array('StoreRequisitionParticular.id')
						));
				foreach($storeDetails as $key => $value){
					$storeDetails[$key]['PurchaseOrderItem']['batch_number']= $value['PharmacyItemRate']['batch_number'];
					$storeDetails[$key]['PurchaseOrderItem']['expiry_date']= $value['PharmacyItemRate']['expiry_date'];
				}
			}else{
				$this->StoreRequisitionParticular->bindModel(array(
					'belongsTo'=>array('ManufacturerCompany'=>array('foreignKey'=>false,'conditions'=>array('ManufacturerCompany.id=Product.manufacturer_id')),
					'ProductRate'=>array('foreignKey'=>false,'conditions'=>array('StoreRequisitionParticular.purchase_order_item_id = ProductRate.id')),
							)));
				$storeDetails = $this->StoreRequisitionParticular->find('all',array('conditions'=>array('StoreRequisitionParticular.store_requisition_detail_id'=>$reqId)));
				foreach($storeDetails as $key => $value){
					$storeDetails[$key]['PurchaseOrderItem']['batch_number']= $value['ProductRate']['batch_number'];
					$storeDetails[$key]['PurchaseOrderItem']['expiry_date']= $value['ProductRate']['expiry_date'];
				}
			}
			
		$requsition_for='';
			if($storeLocation['StoreLocation']['name'] == "Other"){
				$this->LoadModel("PatientCentricDepartment");
				$for = $this->PatientCentricDepartment->read(null,$StoreRequisition['StoreRequisition']['requister_id']);
				$requsition_for =$for['PatientCentricDepartment']['name'];
			}else if($storeLocation['StoreLocation']['name'] == "OT"){
				$this->LoadModel("Opt");
				$for = $this->Opt->read(null,$StoreRequisition['StoreRequisition']['requister_id']);
				$requsition_for =$for['Opt']['name'];
			}else if($storeLocation['StoreLocation']['name'] == "Chamber"){
				$this->LoadModel("Chamber");
				$for = $this->Chamber->read(null,$StoreRequisition['StoreRequisition']['requister_id']);
				$requsition_for =$for['Chamber']['name'];
			}else if($storeLocation['StoreLocation']['name'] == "Ward"){
				$this->LoadModel("Ward");
				$for = $this->Ward->read(null,$StoreRequisition['StoreRequisition']['requister_id']);
				$requsition_for =$for['Ward']['name'];
			}
			if(!empty($requsition_for))
				$data['for'] =  $requsition_for;
			else{
				$data['for']=$StoreRequisition['StoreRequisition']['requisition_for'];
				$requsition_for=$storeLocation['StoreLocation']['name'];
			}
		$issueBy=$this->User->find('first',array('fields'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id'=>$StoreRequisition['StoreRequisition']['issue_by'])));
		$this->set("StoreRequisition",$StoreRequisition);
		$this->set("storeDetails",$storeDetails);
		$this->set("requisition_for",$requsition_for);
		$this->set('issueBy',$issueBy);
	}


	public function manufacturingCompany($id=null){
		
		if($this->params->query['flag']=='1'){  //open in fancybox without header
			$this->layout ='advance_ajax'; //to include all js and css with ajax layout
			$this->set('flagForBack',1);// it include to display fancybox without back btn
		}
		
		$this->uses=array('ManufacturerCompany');
		if($this->request->data){
			$this->request->data['ManufacturerCompany']['location_id']=$this->Session->read('locationid');
			if(!empty($id)){
				$this->request->data['ManufacturerCompany']['id']=$id;
				$this->request->data['ManufacturerCompany']['modified']=date('Y-m-d H:i:s');
			}else{
				$this->request->data['ManufacturerCompany']['created']=date('Y-m-d H:i:s');
			}
			
			$isExist = $this->ManufacturerCompany->find('count',array('conditions'=>array('ManufacturerCompany.name'=>$this->request->data['ManufacturerCompany']['name'],'is_deleted'=>'0','location_id'=>$this->Session->read('locationid'))));
			if($isExist > 0){
				$this->Session->setFlash(__("This manufacturer is already Exists", true),'default',array('class'=>'error'));	
			}else{
				if($this->ManufacturerCompany->save($this->request->data)){
					$this->Session->setFlash(__("Manufacturer added Succesffully", true));
					$this->set('setManufacturerFlag',true);		//to close the manufacturer fancy box by Swapnil G.Sharma
				}
			}	
		}
			
		if(!empty($id)){
			$edit=$this->ManufacturerCompany->find('all',array('conditions'=>array('id'=>$id,'is_deleted'=>'0','location_id'=>$this->Session->read('locationid'))));
			$this->data=$edit;
		}
		$company=$this->ManufacturerCompany->find('all',array('conditions'=>array('is_deleted'=>'0','location_id'=>$this->Session->read('locationid')),'order'=>array('name'=>"ASC")));
		$this->set('company',$company);

	}

	public function deleteManufacturer($id){
		$this->uses=array('ManufacturerCompany');
		if(!empty($id)){
			$date=date('Y-m-d H:i:s');
			$updateArray=array('is_deleted'=>"'1'",'modified'=>"'$date'");
			$this->ManufacturerCompany->updateAll($updateArray,array('id'=>$id));
		}
		$this->redirect($this->referer());
	}

        /*
         * function to generate the current stock/ expensive stock/ MOL/ reorder Level
         * 
         */
	public function currentStock(){
            $this->layout='advance';
            $this->uses = array('PharmacyItem','PharmacyItemRate'); 

            if($this->request->query){
                $conditions = $having = array();
                if($this->request->query['is_zero'] == "1"){
                    $having = "total_Stock = 0"; 
                    $heading = "Empty Stock";
                }
                if($this->request->query['is_MOL'] == "1"){
                    $having = "total_Stock > PharmacyItem.maximum"; 
                    $conditions = "PharmacyItem.maximum > 0";
                    $heading = "Maximum Order Limit";
                }
                if($this->request->query['is_reorder'] == "1"){
                    $having = "total_Stock <= PharmacyItem.reorder_level"; 
                    $heading = "Reorder Level";
                }
                if($this->request->query['is_expensive'] == "1"){
                    $having = "total_Stock > 0";
                    $conditions = "PharmacyItemRate.purchase_price > 1000"; 
                    $heading = "Expensive Product";
                }  
                 
                $this->PharmacyItemRate->bindModel(array(
                    'belongsTo'=>array(
                        'PharmacyItem'=>array(
                            'foreignKey'=>'item_id'
                        )
                    )
                ),false);
                
                if(!empty($this->request->query['generate_report'])){ 
                    $results = $this->PharmacyItemRate->find('all',array(
                        'fields'=>array(
                            'PharmacyItem.name, PharmacyItem.pack, PharmacyItem.maximum, PharmacyItem.reorder_level',
                            'PharmacyItemRate.stock, PharmacyItemRate.loose_stock, PharmacyItemRate.purchase_price',
                            'SUM((PharmacyItemRate.stock*PharmacyItem.pack)+PharmacyItemRate.loose_stock) as total_Stock'
                        ),
                        'conditions'=>array(
                            'PharmacyItemRate.is_deleted'=>'0','PharmacyItem.is_deleted'=>'0','PharmacyItem.drug_id IS NOT NULL',
                            $conditions
                        ),
                        'group'=>array(
                            'PharmacyItemRate.item_id HAVING '.$having
                        )
                    )); 
                    $this->set(compact(array('results','heading'))); 
                    $this->layout = false;
                    $this->render('current_stock_excel');
                }else{
                    $this->paginate = array(
                        'limit'=>  Configure::read('number_of_rows'),
                        'fields'=>array(
                            'PharmacyItem.name, PharmacyItem.pack, PharmacyItem.maximum, PharmacyItem.reorder_level',
                            'PharmacyItemRate.stock, PharmacyItemRate.loose_stock, PharmacyItemRate.purchase_price',
                            'SUM((PharmacyItemRate.stock*PharmacyItem.pack)+PharmacyItemRate.loose_stock) as total_Stock'
                        ),
                        'conditions'=>array(
                            'PharmacyItemRate.is_deleted'=>'0','PharmacyItem.is_deleted'=>'0','PharmacyItem.drug_id IS NOT NULL',
                            $conditions
                        ),
                        'group'=>array(
                            'PharmacyItemRate.item_id HAVING '.$having
                        )
                    ); 
                    $results = $this->paginate('PharmacyItemRate',null,array('fields'=>array('count(*) as count','PharmacyItem.name, PharmacyItem.pack, PharmacyItem.maximum, PharmacyItem.reorder_level',
                            'PharmacyItemRate.stock, PharmacyItemRate.loose_stock, PharmacyItemRate.purchase_price',
                            'SUM((PharmacyItemRate.stock*PharmacyItem.pack)+PharmacyItemRate.loose_stock) as total_Stock')));
                    $this->set(compact('results')); 
                } 
                
            } 	  
	}

	public function searchFromProduct($conditions,$limit,$report=null){ 
		$this->uses = array('Product','PurchaseOrderItem','PharmacyItem','Location','StoreLocation');
		if(empty($limit)){ 
			$limit=Configure::read('number_of_rows');
		}
		
		if(!empty($report) && $report == "report"){
			return $this->Product->find('all',array('conditions'=>array($conditions,'Product.is_deleted'=>0),
					'order'=>array('Product.name ASC'),
					'group'=>array('Product.id')));
		}else{
			$this->paginate = array('limit'=>$limit,
					'fields'=>array('Product.*' ),
					'conditions'=>array('Product.is_deleted'=>'0',$conditions),
					'order'=>array('Product.name ASC'),
					'group'=>array('Product.id')
			);
			return $this->paginate('Product');
		} 
		
	}

	public function searchFromPharmacy($conditions,$limit,$report=null){ 
		$this->uses = array('Product','PharmacyItem');
		$isLimit = array();
		if(empty($limit)){
			$limit=Configure::read('number_of_rows');
		}
		if(!empty($report) && $report == "report"){
			return $this->PharmacyItem->find('all',array('conditions'=>array($conditions,'PharmacyItem.is_deleted'=>0),
					'order'=>array('PharmacyItem.name ASC'),
					'group'=>array('PharmacyItem.id')));
		}else{
			$this->paginate = array('limit'=>$limit,
				'fields'=>array('PharmacyItem.*' ),
				'conditions'=>array('PharmacyItem.is_deleted'=>'0',$conditions),
				'order'=>array('PharmacyItem.name ASC'),
				'group'=>array('PharmacyItem.id')
			);
			return $this->paginate('PharmacyItem');
		}
		
	}
	
	public function searchFromOTPharmacy($conditions,$limit,$report=null){
		$this->uses = array('Product','OtPharmacyItem');
		$isLimit = array();
		if(empty($limit)){
			$limit=Configure::read('number_of_rows');
		}
		if(!empty($report) && $report == "report"){
			return $this->OtPharmacyItem->find('all',array('conditions'=>array($conditions,'OtPharmacyItem.is_deleted'=>0),
					'order'=>array('OtPharmacyItem.name ASC'),
					'group'=>array('OtPharmacyItem.id')));
		}else{
			$this->paginate = array('limit'=>$limit,
				'fields'=>array('OtPharmacyItem.*' ),
				'conditions'=>array('OtPharmacyItem.is_deleted'=>'0',$conditions),
				'order'=>array('OtPharmacyItem.name ASC'),
				'group'=>array('OtPharmacyItem.id')
			);
			return $this->paginate('OtPharmacyItem');
		}
	}
	
	public function stockLedger(){
		$this->layout='advance';
		$this->uses=array('Product','ProductCategory', 'StoreRequisition','StoreRequisitionParticular','User');
			
		$testList = $this->ProductCategory->find('list' ,array('conditions'=>array('is_deleted'=>0,'location_id'=> $this->Session->read('locationid')),'fields'=>array('name')) );

		$this->set(array('testList'=>$testList));
			
		$this->Product->bindModel(array('hasOne' => array(
				'StoreRequisitionParticular'=>array('foreignKey'=>false,'conditions'=>array('Product.name=StoreRequisitionParticular.item_name')),
				'StoreRequisition'=>array('foreignKey'=>false,'conditions'=>array('StoreRequisitionParticular.store_requisition_detail_id=StoreRequisition.id'),'fields'=>array('StoreRequisition.issue_date')),
		)),false);

			
		if($this->request->data){
			$conditions['Product.is_deleted']=0;
			if(!empty($this->request->data['StoreRequisition']['from'])){
				$from = $this->DateFormat->formatDate2STDForReport($this->request->data['StoreRequisition']['from'],Configure::read('date_format'))." 00:00:00";
					
			}
			if(!empty($this->request->data['StoreRequisition']['to'])){
				$to = $this->DateFormat->formatDate2STDForReport($this->request->data['StoreRequisition']['to'],Configure::read('date_format'))." 23:59:59";
			}

			$equation=$this->request->data['Product']['cur_eqtn'];

			if(!empty($this->request->data['Product']['quantity'])){
				if(!empty($this->request->data['Product']['quantity']))
					$conditions["Product.quantity $equation"]= $this->request->data['Product']['quantity'];
			}
			if(!empty($this->request->data['Product']['manufacturer'])){
				$conditions['Product.manufacturer'] = $this->request->data['Product']['manufacturer'];
			}
			if($this->request->data['Product']['name']){
				$conditions['Product.name LIKE ']=$this->request->data['Product']['name'].'%';
			}
			if($this->request->data['Product']['generic']){
				$conditions['Product.generic LIKE']=$this->request->data['Product']['generic'].'%';
			}
			 
			$equation_issueQty=$this->request->data['Product']['issue_eqtn'];
			 
			if($this->request->data['StoreRequisitionParticular']['issued_qty']){
				$conditions["StoreRequisitionParticular.issued_qty $equation_issueQty"]=$this->request->data['StoreRequisitionParticular']['issued_qty'];
			}
			if($this->request->data['Product']['product_category']){
				$conditions['Product.product_category_id']=$this->request->data['Product']['product_category'];
			}
			 

			if($to)
				$conditions['StoreRequisition.issue_date <='] = $to;

			if($from)
				$conditions['StoreRequisition.issue_date >='] = $from;

			$this->paginate = array('limit' => Configure::read('number_of_rows'),
					'fields'=> array('Product.name','Product.id','Product.quantity','Product.cost_price','Product.minimum','Product.reorder_level',
							'StoreRequisitionParticular.issued_qty','StoreRequisitionParticular.store_requisition_detail_id',
							'StoreRequisition.issue_date'),
					'conditions'=>$conditions);

			$result=$this->paginate('Product');
		}
			
			
		$this->set('result',$result);

	}


	public function stock_ledger_xls(){
		$this->layout='advance';
		$this->uses=array('Product','ProductCategory', 'StoreRequisition','StoreRequisitionParticular','User');

		$testList = $this->ProductCategory->find('list' ,array('conditions'=>array('is_deleted'=>0,'location_id'=> $this->Session->read('locationid')),'fields'=>array('name')) );
		$this->set(array('testList'=>$testList));
		$this->Product->bindModel(array('hasOne' => array(
				'StoreRequisitionParticular'=>array('foreignKey'=>false,'conditions'=>array('Product.name=StoreRequisitionParticular.item_name')),
				'StoreRequisition'=>array('foreignKey'=>false,'conditions'=>array('StoreRequisitionParticular.store_requisition_detail_id=StoreRequisition.id'),'fields'=>array('StoreRequisition.issue_date')),
		)),false);


		$this->request->data = unserialize($this->request->query['q']);
		if($this->request->data){
			$conditions['Product.is_deleted']=0;
			if(!empty($this->request->data['StoreRequisition']['from'])){
				$from = $this->DateFormat->formatDate2STDForReport($this->request->data['StoreRequisition']['from'],Configure::read('date_format'))." 00:00:00";

			}
			if(!empty($this->request->data['StoreRequisition']['to'])){
				$to = $this->DateFormat->formatDate2STDForReport($this->request->data['StoreRequisition']['to'],Configure::read('date_format'))." 23:59:59";
			}
			$equation=$this->request->data['Product']['cur_eqtn'];

			if(!empty($this->request->data['Product']['quantity'])){
				if(!empty($this->request->data['Product']['quantity']))
					$conditions["Product.quantity $equation"]= $this->request->data['Product']['quantity'];
			}
			if(!empty($this->request->data['Product']['manufacturer'])){
				$conditions['Product.manufacturer'] = $this->request->data['Product']['manufacturer'];
			}
			if($this->request->data['Product']['name']){
				$conditions['Product.name LIKE ']=$this->request->data['Product']['name'].'%';
			}
			if($this->request->data['Product']['generic']){
				$conditions['Product.generic LIKE']=$this->request->data['Product']['generic'].'%';
			}
			$equation_issueQty=$this->request->data['Product']['issue_eqtn'];
			 
			if($this->request->data['StoreRequisitionParticular']['issued_qty']){
				$conditions["StoreRequisitionParticular.issued_qty $equation_issueQty"]=$this->request->data['StoreRequisitionParticular']['issued_qty'];
			}
			if($this->request->data['Product']['product_category']){
				$conditions['Product.product_category_id']=$this->request->data['Product']['product_category'];
			}
				

			if($to)
				$conditions['StoreRequisition.issue_date <='] = $to;

			if($from)
				$conditions['StoreRequisition.issue_date >='] = $from;

			$result=$this->Product->find('all',array(
					'fields'=> array('Product.name','Product.id','Product.quantity','Product.cost_price','Product.minimum','Product.reorder_level',
							'StoreRequisitionParticular.issued_qty','StoreRequisitionParticular.store_requisition_detail_id',
							'StoreRequisition.issue_date'),
					'conditions'=>$conditions));

		}


		$this->set('result',$result);
		$this->render('stock_ledger_xls',false);

	}
			

	public function stockTracking(){

	}

	public function stockAdjustment(){

		$this->layout='advance';
		$this->uses=array('Product','StockAdjustment','StoreLocation');
			
		$this->Product->bindModel(array('hasOne' => array(
		                 	'StockAdjustment'=>array('foreignKey'=>false,'conditions'=>array('Product.id=StockAdjustment.product_id')),
				           )),false);
	 
		$roleId = $this->Session->read('roleid');
		$mylocations = $this->StoreLocation->find('all',array('fields'=>array('id','name','role_id'),'conditions' => array('StoreLocation.is_deleted' =>'0','StoreLocation.code_name NOT'=>array(Configure::read("wardCode"),Configure::read("otCode")))));
		$returnArray = array();
		foreach($mylocations as $dept){
			$deptRolesArray = explode("|",$dept['StoreLocation']['role_id']);
			if(in_array($roleId,$deptRolesArray)){
				$returnArray[$dept['StoreLocation']['id']] = $dept['StoreLocation']['name'];
			}
		}
		$this->set('department',$returnArray);
		
		if($this->request->data){
			//debug($this->request->data);
			if(!empty($this->request->data['StockAdjustment']['from'])){
				$from = $this->DateFormat->formatDate2STDForReport($this->request->data['StockAdjustment']['from'],Configure::read('date_format'))." 00:00:00";
					
			}
			if(!empty($this->request->data['StockAdjustment']['to'])){
				$to = $this->DateFormat->formatDate2STDForReport($this->request->data['StockAdjustment']['to'],Configure::read('date_format'))." 23:59:59";
			}
			if(!empty($this->request->data['StockAdjustment']['adjusted_date'])){
				$adjusted_date=$this->DateFormat->formatDate2STDForReport($this->request->data['StockAdjustment']['adjusted_date'],Configure::read('date_format'))." 00:00:00";
			}
		
			if(!empty($this->request->data['Product']['product_code'])){
				$conditions['Product.product_code'] = $this->request->data['Product']['product_code'];
			}
			if($this->request->data['Product']['description']){
				$conditions['Product.description LIKE ']=$this->request->data['Product']['description'].'%';
			}
			
			if($this->request->data['Product']['current_stock']){
				$conditions['Product.quantity =']=$this->request->data['Product']['current_stock'];
			}
			
			if($to)
				$conditions['StockAdjustment.adjusted_date <='] = $to;//debug($to);
		
			if($from)
				$conditions['StockAdjustment.adjusted_date >='] = $from;//debug($from);
			
			if($adjusted_date)
				$conditions['StockAdjustment.adjusted_date >='] = $adjusted_date;
			//debug($conditions);
			$this->paginate = array('limit' => Configure::read('number_of_rows'),
					'fields'=> array('Product.name','Product.id','Product.product_code','Product.description','Product.quantity','Product.cost_price','Product.minimum',
							'StockAdjustment.adjusted_date','StockAdjustment.adjusted_qty'),
					'conditions'=>$conditions);
		
			$result=$this->paginate('Product');
		
		}
		$this->set('result',$result);
	}
	//EOF stockAdjustment
	
	
	public function stockAdjustment_xls(){
	
		$this->layout='advance';
		$this->uses=array('Product','StockAdjustment');
			
		$this->Product->bindModel(array('hasOne' => array(
				'StockAdjustment'=>array('foreignKey'=>false,'conditions'=>array('Product.id=StockAdjustment.product_id')),
		)),false);
		
		$this->request->data = unserialize($this->request->query['q']);
		if($this->request->data){
			
			if(!empty($this->request->data['StockAdjustment']['from'])){
				$from = $this->DateFormat->formatDate2STDForReport($this->request->data['StockAdjustment']['from'],Configure::read('date_format'))." 00:00:00";
					
			}
			if(!empty($this->request->data['StockAdjustment']['to'])){
				$to = $this->DateFormat->formatDate2STDForReport($this->request->data['StockAdjustment']['to'],Configure::read('date_format'))." 23:59:59";
			}
			if(!empty($this->request->data['StockAdjustment']['adjusted_date'])){
				$adjusted_date=$this->DateFormat->formatDate2STDForReport($this->request->data['StockAdjustment']['adjusted_date'],Configure::read('date_format'))." 00:00:00";
			}
	
			if(!empty($this->request->data['Product']['product_code'])){
				$conditions['Product.product_code'] = $this->request->data['Product']['product_code'];
			}
			if($this->request->data['Product']['description']){
				$conditions['Product.description LIKE ']=$this->request->data['Product']['description'].'%';
			}
				
			if($this->request->data['Product']['current_stock']){
				$conditions['Product.quantity =']=$this->request->data['Product']['current_stock'];
			}
				
			if($to)
				$conditions['StockAdjustment.adjusted_date <='] = $to;//debug($to);
	
			if($from)
				$conditions['StockAdjustment.adjusted_date >='] = $from;//debug($from);
				
			if($adjusted_date)
				$conditions['StockAdjustment.adjusted_date >='] = $adjusted_date;
			//debug($conditions);
			$result=$this->Product->find('all',array(
					'fields'=> array('Product.name','Product.id','Product.product_code','Product.description','Product.quantity','Product.cost_price','Product.minimum',
							'StockAdjustment.adjusted_date','StockAdjustment.adjusted_qty'),
					'conditions'=>$conditions));
	
		}
			
			
		$this->set('result',$result);
		$this->render('stockAdjustment_xls',false);
	
	}
	
	
	public function stock_adjustment_inside($selected=NULL,$stockAdjID=NULL){

		$this->layout = 'advance';
		$this->uses=array('Product','ProductCategory', 'StoreRequisition','StoreRequisitionParticular','StockAdjustment');
			
		$this->Product->bindModel(array('hasOne' => array(
				'StockAdjustment'=>array('foreignKey'=>false,'conditions'=>array('Product.id=StockAdjustment.product_id')),
		)),false);
	
		
		if($this->request->data){
			if(empty($this->request->data['StockAdjustment']['from']) && empty($this->request->data['StockAdjustment']['to']))
			{
			if(!empty($stockAdjID)){
				$this->request->data['StockAdjustment']['id']=$stockAdjID;
				$this->request->data['StockAdjustment']['modified_by']=$this->Session->read('roleid');
				
			}else{
				$this->request->data['StockAdjustment']['created_by']=$this->Session->read('roleid');
			}
			
			$this->request->data['StockAdjustment']['adjusted_date']=date('Y-m-d');

			//To edit quantity in Product table
				
			$quantity=$this->request->data['Product']['quantity'];
				
			$adjusted_qty=$this->request->data['StockAdjustment']['adjusted_qty'];
				
			if($this->request->data['StockAdjustment']['type']=='S')
			{
				$this->request->data['Product']['quantity']=$quantity+$adjusted_qty;
			}
			else if($this->request->data['StockAdjustment']['type']=='D'||$this->request->data['StockAdjustment']['type']=='Dmg'||$this->request->data['StockAdjustment']['type']=='E')
			{
				$this->request->data['Product']['quantity']=$quantity-$adjusted_qty;
			}
				
			//To set respective field to 1
				
			$type = $this->request->data['StockAdjustment']['type'];
			$selected = array('S'=>'is_surplus','D'=>'is_deficit','Dmg'=>'is_damaged','E'=>'is_expired');
			if(array_key_exists($type, $selected))
			{
				$this->request->data['StockAdjustment']["$selected[$type]"] = 1;
				//debug($selected[$type]);
			}

			//for retaining quantity in Product and updating it on edit
			
			if(!empty($stockAdjID)){
			
				$edit=$this->Product->find('first',array('fields'=> array('Product.name','Product.id','Product.batch_number','Product.quantity','Product.mrp','Product.minimum',
						'StockAdjustment.id','StockAdjustment.adjusted_date','StockAdjustment.adjusted_qty','StockAdjustment.is_deleted'),
						'conditions'=>array('StockAdjustment.id'=>$stockAdjID,'StockAdjustment.is_deleted'=>'0')));
				
				if($this->request->data['StockAdjustment']['type']=='S')
				{
				$original_qty=$edit['Product']['quantity']-$edit['StockAdjustment']['adjusted_qty'];
				
				//$this->request->data['Product']['quantity']=$original_qty;
				
				$new_qty=$original_qty+$this->request->data['StockAdjustment']['adjusted_qty'];
			
			    $this->request->data['Product']['quantity'] = $new_qty;
					
				}
				else if($this->request->data['StockAdjustment']['type']=='D'||$this->request->data['StockAdjustment']['type']=='Dmg'||$this->request->data['StockAdjustment']['type']=='E')
				{
					$original_qty=$edit['Product']['quantity']+$edit['StockAdjustment']['adjusted_qty'];
				
				//$this->request->data['Product']['quantity']=$original_qty;
				
				$new_qty=$original_qty-$this->request->data['StockAdjustment']['adjusted_qty'];
			
			    $this->request->data['Product']['quantity'] = $new_qty;
				}
			
			}
			
			$this->Product->save($this->request->data['Product']);
				
			$this->request->data['StockAdjustment']['product_id'] = $this->request->data['Product']['id'];
			//debug($this->request->data);exit;
			if($this->StockAdjustment->save($this->request->data['StockAdjustment'])){
				$this->redirect(array('controller'=>'store','action'=>'stock_adjustment_inside',$this->request->data['StockAdjustment']['type']));
			}
			
		}
		
			
		}
		
		//fetch data to display in textboxes on edit
       
		if(!empty($stockAdjID)){
			$edit=$this->Product->find('all',array('fields'=> array('Product.name','Product.id','Product.batch_number','Product.quantity','Product.mrp','Product.minimum',
					     'StockAdjustment.id','StockAdjustment.adjusted_date','StockAdjustment.adjusted_qty','StockAdjustment.is_deleted'),
					     'conditions'=>array('StockAdjustment.id'=>$stockAdjID,'StockAdjustment.is_deleted'=>'0')));
				
			$this->data=$edit;
			
			}
		
		if($selected || $this->request->data['StockAdjustment']['from'] || $this->request->data['StockAdjustment']['to']){
			if($selected=='S')
				$condition['StockAdjustment.is_surplus'] = '1';
			if($selected=='D')
				$condition['StockAdjustment.is_deficit'] = '1';
			if($selected=='Dmg')
				$condition['StockAdjustment.is_damaged'] = '1';
			if($selected=='E')
				$condition['StockAdjustment.is_expired'] = '1';
			
			if(!empty($this->request->data['StockAdjustment']['from'])){
				$from = $this->DateFormat->formatDate2STDForReport($this->request->data['StockAdjustment']['from'],Configure::read('date_format'))." 00:00:00";
					
			}
			if(!empty($this->request->data['StockAdjustment']['to'])){
				$to = $this->DateFormat->formatDate2STDForReport($this->request->data['StockAdjustment']['to'],Configure::read('date_format'))." 23:59:59";
			}
			if($to)
				$condition['StockAdjustment.adjusted_date <='] = $to;//debug($to);
			
			if($from)
				$condition['StockAdjustment.adjusted_date >='] = $from;//debug($from);
					
				$this->paginate = array('limit' => Configure::read('number_of_rows'),
					'fields'=> array('Product.name','Product.id','Product.description','Product.batch_number','Product.quantity','Product.mrp','Product.minimum',
							'StockAdjustment.id','StockAdjustment.adjusted_date','StockAdjustment.adjusted_qty','StockAdjustment.is_deleted','StockAdjustment.modified_by','StockAdjustment.created_by'),
					'conditions'=>array($condition,'StockAdjustment.is_deleted'=>0,'OR'=>array('StockAdjustment.created_by'=>$this->Session->read('roleid'),'StockAdjustment.modified_by'=>$this->Session->read('roleid'))));

			$result=$this->paginate('Product');
		}
		$this->set('result',$result);
  }
	
	
	
	public function stock_adjustment_inside_xls($selected=NULL,$stockAdjID=NULL){

		$this->layout = 'advance';
		$this->uses=array('Product','ProductCategory', 'StoreRequisition','StoreRequisitionParticular','StockAdjustment');
			
		$this->Product->bindModel(array('hasOne' => array(
				'StockAdjustment'=>array('foreignKey'=>false,'conditions'=>array('Product.id=StockAdjustment.product_id')),
		)),false);
		
		//$this->request->data = unserialize($this->request->query['q']);
		if($this->request->data){
			
			if(!empty($stockAdjID)){
				$this->request->data['StockAdjustment']['id']=$stockAdjID;
				$this->request->data['StockAdjustment']['modified_by']=$this->Session->read('roleid');
				
			}else{
				$this->request->data['StockAdjustment']['created_by']=$this->Session->read('roleid');
			}
			
			$this->request->data['StockAdjustment']['adjusted_date']=date('Y-m-d');

			//To edit quantity in Product table
				
			$quantity=$this->request->data['Product']['quantity'];
				
			$adjusted_qty=$this->request->data['StockAdjustment']['adjusted_qty'];
				
			if($this->request->data['StockAdjustment']['type']=='S')
			{
				$this->request->data['Product']['quantity']=$quantity+$adjusted_qty;
			}
			else if($this->request->data['StockAdjustment']['type']=='D'||$this->request->data['StockAdjustment']['type']=='Dmg'||$this->request->data['StockAdjustment']['type']=='E')
			{
				$this->request->data['Product']['quantity']=$quantity-$adjusted_qty;
			}
				
			//To set respective field to 1
				
			$type = $this->request->data['StockAdjustment']['type'];
			$selected = array('S'=>'is_surplus','D'=>'is_deficit','Dmg'=>'is_damaged','E'=>'is_expired');
			if(array_key_exists($type, $selected))
			{
				$this->request->data['StockAdjustment']["$selected[$type]"] = 1;
				//debug($selected[$type]);
			}

			//for retaining quantity in Product and updating it on edit
			
			if(!empty($stockAdjID)){
			
				$edit=$this->Product->find('first',array('fields'=> array('Product.name','Product.id','Product.batch_number','Product.quantity','Product.mrp','Product.minimum',
						'StockAdjustment.id','StockAdjustment.adjusted_date','StockAdjustment.adjusted_qty','StockAdjustment.is_deleted'),
						'conditions'=>array('StockAdjustment.id'=>$stockAdjID,'StockAdjustment.is_deleted'=>'0')));
				
				if($this->request->data['StockAdjustment']['type']=='S')
				{
				$original_qty=$edit['Product']['quantity']-$edit['StockAdjustment']['adjusted_qty'];
				
				//$this->request->data['Product']['quantity']=$original_qty;
				
				$new_qty=$original_qty+$this->request->data['StockAdjustment']['adjusted_qty'];
			
			    $this->request->data['Product']['quantity'] = $new_qty;
					
				}
				else if($this->request->data['StockAdjustment']['type']=='D'||$this->request->data['StockAdjustment']['type']=='Dmg'||$this->request->data['StockAdjustment']['type']=='E')
				{
					$original_qty=$edit['Product']['quantity']+$edit['StockAdjustment']['adjusted_qty'];
				
				//$this->request->data['Product']['quantity']=$original_qty;
				
				$new_qty=$original_qty-$this->request->data['StockAdjustment']['adjusted_qty'];
			
			    $this->request->data['Product']['quantity'] = $new_qty;
				}
			
			}
			$this->Product->save($this->request->data['Product']);
				
			$this->request->data['StockAdjustment']['product_id'] = $this->request->data['Product']['id'];
			//debug($this->request->data);exit;
			if($this->StockAdjustment->save($this->request->data['StockAdjustment'])){
				$this->redirect(array('controller'=>'store','action'=>'stock_adjustment_inside',$this->request->data['StockAdjustment']['type']));
			}
			
			
		}

		if($selected){
			if($selected=='S')
				$condition['StockAdjustment.is_surplus'] = '1';
			if($selected=='D')
				$condition['StockAdjustment.is_deficit'] = '1';
			if($selected=='Dmg')
				$condition['StockAdjustment.is_damaged'] = '1';
			if($selected=='E')
				$condition['StockAdjustment.is_expired'] = '1';
			
			
        }
						
			$result=$this->Product->find('all',array(
					'fields'=> array('Product.name','Product.id','Product.description','Product.batch_number','Product.quantity','Product.mrp','Product.minimum',
							'StockAdjustment.id','StockAdjustment.adjusted_date','StockAdjustment.adjusted_qty','StockAdjustment.is_deleted','StockAdjustment.modified_by','StockAdjustment.created_by',
							 'StockAdjustment.is_surplus','StockAdjustment.is_deficit','StockAdjustment.is_damaged','StockAdjustment.is_expired'),
					'conditions'=>array($condition,'StockAdjustment.is_deleted'=>0,'OR'=>array('StockAdjustment.created_by'=>$this->Session->read('roleid'),'StockAdjustment.modified_by'=>$this->Session->read('roleid')))));

		/* 	}else{ */
			/* $result=$this->Product->find('all',array(
					'fields'=> array('Product.name','Product.id','Product.description','Product.batch_number','Product.quantity','Product.mrp','Product.minimum',
							'StockAdjustment.id','StockAdjustment.adjusted_date','StockAdjustment.adjusted_qty','StockAdjustment.is_deleted','StockAdjustment.modified_by','StockAdjustment.created_by'),
					'conditions'=>array('StockAdjustment.is_deleted'=>0,'OR'=>array('StockAdjustment.created_by'=>$this->Session->read('roleid'),'StockAdjustment.modified_by'=>$this->Session->read('roleid'))))); 
			
			$this->set('result',$result);*/
			
			
		$this->set('result',$result);
		$this->render('stock_adjustment_inside_xls',false);
  }
	
	
	public function deleteStockAdj($id=null)
	{
		$this->uses = array('StockAdjustment');
		$this->request->data['StockAdjustment']['is_deleted']=1;
		$this->StockAdjustment->id= $id;
		if($this->StockAdjustment->save($this->request->data['StockAdjustment'])){
			$this->Session->setFlash(__('Stock deleted successfully'),true);
			$this->redirect($this->referer());
			
		}
	}
	
	
	

	public function product_stock_old_pooja($deparementId = null){
		
		$this->uses = array('Product');
		/*if($deparementId) $departmentConditiond = "Product.department_id = $deparementId";*/
		
		$this->loadModel('StoreLocation');
		$storeLocation = $this->StoreLocation->find('first',array('fields'=>array('StoreLocation.id'),'conditions'=>array('StoreLocation.code_name'=>Configure::read("centralStoreCode"))));
		$storeLocationId = $storeLocation['StoreLocation']['id'];
		//$this->set('storeLocation',$storeLocation);
		
		$this->Product->bindModel(array('belongsTo'=>array(
				'PurchaseOrderItem'=>array('foreignKey'=>false,'conditions'=>array('PurchaseOrderItem.product_id=Product.id')),
				'PurchaseOrder'=>array('foreignKey'=>false,'conditions'=>array('PurchaseOrderItem.purchase_order_id=PurchaseOrder.id')))));
		
		$productStock= $this->Product->find('all',array(
				'fields'=> array('Product.name','Product.id','PurchaseOrderItem.id','PurchaseOrderItem.stock_available','Product.pack','Product.maximum','PurchaseOrderItem.amount','PurchaseOrderItem.batch_number','PurchaseOrderItem.expiry_date'),
				'conditions'=>array('Product.is_deleted'=>0,'Product.name like'=>'%'.$this->params->query['term'].'%','PurchaseOrderItem.expiry_date >'=>date('Y-m-d'),'PurchaseOrderItem.status'=>'0',$departmentConditiond,
							'Product.location_id'=>$this->Session->read('locationid'),'PurchaseOrder.order_for'=>$storeLocationId,'PurchaseOrderItem.stock_available >'=>0),
				'order'=>array('Product.id ASC','PurchaseOrderItem.expiry_date ASC'),
				
				));
		foreach ($productStock as $key=>$value) {
			$dateSplit=explode('-',$value['PurchaseOrderItem']['expiry_date']);
			$date=$dateSplit[2].'/'.$dateSplit[1].'/'.$dateSplit[0];
			$returnArray[] = array( 'id'=>$value['Product']['id'],
					'value'=>$value['Product']['name'].'('.$date.')',
					'pId'=>$value['PurchaseOrderItem']['id'],
					'quantity'=>$value['PurchaseOrderItem']['stock_available'],
					'pack'=>$value['Product']['pack'],'max'=>$value['Product']['maximum'],
					'mrp'=>$value['PurchaseOrderItem']['amount'],
					'batch_no'=>$value['PurchaseOrderItem']['batch_number'],
					'expiry'=>$value['PurchaseOrderItem']['expiry_date']) ;
		}
		echo json_encode($returnArray);			
		exit;
	}
	
	
	public function product_stock($locationId = null){
		
		$this->uses = array("StoreLocation","Product","ProductRate","PharmacyItem","PharmacyItemRate","Location");
		$isPharmacy = false;
		
		$allStore = $this->StoreLocation->find('list',array('conditions'=>array('StoreLocation.is_deleted'=>0),'fields'=>array('StoreLocation.id','StoreLocation.code_name')));
		$PharmacyId = $this->StoreLocation->find('first',array('conditions'=>array('StoreLocation.code_name'=>Configure::read('pharmacyCode')),'fields'=>'StoreLocation.id'));
		
		$location_id = $this->Session->read('locationid');
		
		if($PharmacyId['StoreLocation']['id'] == $locationId){
			$isPharmacy = true;
		}
		 
		if(array_search(Configure::read('apamCode'), $allStore) == $locationId){
			//to search products from pharmacy where location is APAM
			$isPharmacy = true;
			$location_id = $this->Location->getLocationIdByName(Configure::read('apamCode'));
		}else{
			$location_id = $this->Session->read('locationid');
		}

		if(!empty($isPharmacy)){
			//search from pharmacy Item
			$this->PharmacyItem->unbindModel(array('hasOne'=>array('PharmacyItemRate'),'hasMany'=>array('InventoryPurchaseItemDetail')));
			
			$this->PharmacyItem->bindModel(array('hasMany'=>array('PharmacyItemRate'=>array('foreignKey'=>'item_id'))));
			
			$items = $this->PharmacyItem->find('all', array('conditions'=>array('PharmacyItem.name like'=>$this->params->query['term'].'%','PharmacyItem.location_id'=>$location_id),'limit'=>Configure::read('number_of_rows')));
			
			$returnArray = array();
			foreach ($items as $key => $value) {
				$pharRate = '';
				foreach($value['PharmacyItemRate'] as $pKey => $rate){
					$pharRate = $rate['sale_price'];		//recent product_rate price (sale_price)	by Swapnil 18.03.2015
				}
				
				$returnArray[] = array( 
						'id'       => $value['PharmacyItem']['id'],
						'value'    => $value['PharmacyItem']['name'],
						'pId'      => $value['PharmacyItem']['id'],
						'quantity' => $value['PharmacyItem']['stock'],
						'loose_stock'=> !empty($value['PharmacyItem']['loose_stock'])?$value['PharmacyItem']['loose_stock']:0,
						'pack'     => $value['PharmacyItem']['pack'],
						//'max'      => $value['Product']['maximum'],
						'max'	   => !empty($value['PharmacyItem']['reorder_level'])?$value['PharmacyItem']['reorder_level']:0,
						'rate'     => $pharRate ) ;
			}
			
		}else{ 
			
			$this->Product->bindModel(array('hasMany'=>array('ProductRate'=>array('foreignKey'=>'product_id','type'=>'INNER'/*,'conditions'=>array('Product.id=ProductRate.product_id')*/))));
			//$products = $this->Product->find('all',array('conditions'=>array('Product.quantity >'=>0,'ProductRate.stock >'=>0,'Product.is_deleted'=>0,'Product.name like'=>'%'.$this->params->query['term'].'%')));
			
			//search from central store
			$products = $this->Product->find('all',array('conditions'=>array(
						'Product.quantity >'=>0,'Product.is_deleted'=>0,
						'Product.name like'=>$this->params->query['term'].'%',
						'Product.location_id NOT' => $this->Location->getLocationIdByName(Configure::read('apamCode'))),
						'limit'=>Configure::read('number_of_rows'))); 
			 
			$returnArray = array();
			foreach($products as $key=>$value){
				
				$productRate = '';
				foreach($value['ProductRate'] as $pKey => $rate){
					$productRate = $rate['sale_price'];		//recent product_rate price (sale_price)	by Swapnil 18.03.2015
				}
				
				$returnArray[] = array( 
						'id'       => $value['Product']['id'],
						'value'    => $value['Product']['name'],
						'pId'      => $value['Product']['id'],
						'quantity' => $value['Product']['quantity'],
						'loose_stock'=> !empty($value['Product']['loose_stock'])?$value['Product']['loose_stock']:0,
						'pack'     => $value['Product']['pack'],
						//'max'      => $value['Product']['maximum'],
						'max'	   => !empty($value['Product']['reorder_level'])?$value['Product']['reorder_level']:0,
						'rate'     => $productRate ) ;
			}
		} 
		echo json_encode($returnArray);			
		exit;
	}
	/**
	 * function to search Stock Items Requisition
	 * @author Mahalaxmi
	 */
	public function pharmacy_stock($locationIdFrm = null,$locationIdTo = null){
		
		$this->uses = array("Location","StoreLocation","Product","ProductRate","PharmacyItem","PharmacyItemRate");
		$locationsName=$this->Location->find('first',array('fields'=>array('id','name'),'conditions'=>array('Location.is_deleted'=>0,'Location.id'=>$locationIdFrm)));
		
		$itemsFrm = $this->PharmacyItem->find('all', array('PharmacyItem.','conditions'=>array('PharmacyItem.name like'=>$this->params->query['term']."%",'PharmacyItem.location_id'=>$locationIdFrm,'PharmacyItem.location_id'=>$locationIdFrm),'limit'=>15));
		
		$fromArr=array();
		foreach($itemsFrm as $keyFrm=>$itemsFrms){
			$fromArr[$itemsFrms['PharmacyItem']['name']]=$itemsFrms;
		}
		//debug($itemsFrm);
			
		//search from pharmacy Item
			$itemsTo = $this->PharmacyItem->find('all', array('conditions'=>array('PharmacyItem.name like'=>$this->params->query['term']."%",'PharmacyItem.location_id'=>$locationIdTo,'PharmacyItem.location_id'=>$locationIdTo),'limit'=>15));
			foreach($itemsTo as $keyTo=>$itemsTos){
				$toArr[$itemsTos['PharmacyItem']['name']]=$itemsTos;
			}
			//debug($itemsTo);
			$returnArray = array();
			//$value=$itemsTo;	
			$getTabQuintityFrm=0;
			$getTabQuintityTo=0;
			foreach ($toArr as $key => $value) {	
				$getTabQuintityFrm=$fromArr[$key]['PharmacyItem']['stock']*$fromArr[$key]['PharmacyItem']['pack']+$fromArr[$key]['PharmacyItem']['loose_stock'];
				
				$getTabQuintityTo=$value['PharmacyItem']['stock']*$value['PharmacyItem']['pack']+$value['PharmacyItem']['loose_stock'];
				if(empty($itemsFrm)){
					$getTabQuintityFrm="FlagNotExist";
				}
				$returnArray[] = array('id'=>$value['PharmacyItem']['id'],
						'value'=>$value['PharmacyItem']['name'],
						'pId'=>$value['PharmacyItem']['id'],
						'quantity'=>$getTabQuintityTo,
						'pack'=>$value['PharmacyItem']['pack'],
						'max'=>$value['PharmacyItem']['maximum'],
						'mrp'=>$value['PharmacyItemRate']['mrp'],
						'batch_no'=>$value['PharmacyItemRate']['batch_number'],
						'expiry'=>$value['PharmacyItemRate']['expiry_date'],
						'quantityFrm'=>$getTabQuintityFrm,
						'stockFrm'=>$fromArr[$key]['PharmacyItem']['stock'],
						'packFrm'=>$fromArr[$key]['PharmacyItem']['pack'],
						'looseStockFrm'=>$fromArr[$key]['PharmacyItem']['loose_stock'],
						'pItemIdFrm'=>$fromArr[$key]['PharmacyItem']['id'],
						'locationfrmName'=>$locationsName['Location']['name']) ;
		   }
	
		//debug($returnArray);
		echo json_encode($returnArray);
		exit;
	}
	

	public function generateOrderList(){
		$this->layout='advance';
		$this->uses = array('Product');
		$productList='';
		if($this->request->data){
			//Making conditions with respect to request->data to search a product
			/*if($this->request->data['Product']['name']){
			 $condition['Product.name LIKE ']=$this->request->data['Product']['name'].'%';
			}
			if($this->request->data['Product']['batch_number']){
			$condition['Product.batch_number']=$this->request->data['Product']['batch_number'];
			}
			if($this->request->data['Product']['generic']){
			$condition['Product.generic']=$this->request->data['Product']['generic'];
			}
			if($this->request->data['Product']['is_zero']=='1'){
			$condition['Product.quantity']='0';
			}*/
				
			if($this->request->data['Product']['supplier_id']){
				$condition['Product.supplier_id']=$this->request->data['Product']['supplier_id'];
			}
			if($this->request->data['issuePo']){
				$poList=implode('-',$this->request->data['check']);
				if(!empty($poList))
					$this->redirect(array('controller'=>'PurchaseOrders','action'=>'add_order','?'=>array('Orderlist'=>$poList)));
				else
					$this->Session->setFlash(__('Please Select Product for purchase order!'),'default',array('class'=>'error'));

			}
			if($condition){
				$this->Product->bindModel(array('belongsTo'=>array(
						'StoreRequisitionParticular'=>array('foreignKey'=>false,'conditions'=>array('StoreRequisitionParticular.item_id=Product.id')),
						'StoreRequisition'=>array('foreignKey'=>false,'conditions'=>array('StoreRequisition.id=StoreRequisitionParticular.store_requisition_detail_id')))));

				$this->paginate = array('limit' => Configure::read('number_of_rows'),
						'fields'=>array('Product.*','sum(StoreRequisitionParticular.requested_qty) as req'),
						'conditions'=>array('Product.is_deleted'=>'0','Product.quantity<Product.reorder_level',$condition),
						'order'=>array('Product.reorder_level ASC'),
						'group'=>array('Product.id'));

				$productList=$this->paginate('Product');
			}
		}
		$this->set('productList',$productList);

	}
	
	public function productConsumption(){
		$this->layout='advance';
		$this->uses=array('Department','StoreLocation','Ward','Opt','Chamber','StockMaintenance');
		$this->set('department',$this->Department->find('list',array('fields'=>array('id','name'),'conditions'=>array('location_id'=>$this->Session->read('locationid'),'is_active'=>'1' ))));
		$roleId = $this->Session->read('roleid');
		
		//by swapnil 18.03.2015
		$mylocations = $this->StoreLocation->find('all',array('fields'=>array('id','name','role_id'),'conditions' => array('StoreLocation.is_deleted' =>'0','StoreLocation.is_consumable'=>0)));
		$returnArray = array();
		foreach($mylocations as $dept){ 
			$deptRolesArray = explode("|",$dept['StoreLocation']['role_id']); 
			if(in_array($roleId,$deptRolesArray)){
				$returnArray[$dept['StoreLocation']['id']] = $dept['StoreLocation']['name'];
			}
		} 
		$this->set('location',$returnArray);
		
		//$this->set('location',$this->StoreLocation->getOtherStore()); //get all location except pharmacy & store.. by swapnil
		//$this->set('location',$this->StoreLocation->find('list',array('fields'=>array('id','name'),'conditions'=>array('location_id'=>$this->Session->read('locationid'),'role_id LIKE'=>'%'.$this->Session->read('roleid').'%'))));
		$this->set('wards',$this->Ward->find('list',
				array('conditions' => array('Ward.is_deleted' => 0, 'Ward.location_id' =>
						$this->Session->read("locationid")))));
		$this->set('ot',$this->Opt->find('list',
				array('conditions' => array('Opt.is_deleted' => 0, 'Opt.location_id' =>
						$this->Session->read("locationid")))));
		$this->set('chambers',$this->Chamber->find('list',
				array('conditions' => array('Chamber.is_deleted' => 0, 'Chamber.location_id' =>
						$this->Session->read("locationid")))));
		if($this->request->data){ 
			if($this->StockMaintenance->issueDepartmentStock($this->request->data)){
				$this->Session->setFlash(__('The Item has been issued', true));	
			$fromDepartId=$this->request->data['Department']['issued_from'];
			
			if($this->request->data['Department']['is_patient']=='0'){
				$toDepartId=$this->request->data['Department']['issued_to'];
			}else{
				$toDepartId=$this->request->data['Department']['patient_id'];
			}
			if(!empty($this->request->data['StoreRequisition']['ward'])){
				$subDepartId=$this->request->data['StoreRequisition']['ward'];
			}else if(!empty($this->request->data['StoreRequisition']['ot'])){
				$subDepartId=$this->request->data['StoreRequisition']['ot'];
			}else if(!empty($this->request->data['StoreRequisition']['chamber'])){
				$subDepartId=$this->request->data['StoreRequisition']['chamber'];
			}else{
				$subDepartId='';
			}
			}else{
				$this->Session->setFlash(__('Please Try Again', true));
			}
			$this->redirect($this->render());
		}
		$this->StockMaintenance->bindModel(array('belongsTo'=>array(
				'StockMaintenanceDetail'=>array('foreignKey'=>false,'conditions'=>array('StockMaintenanceDetail.stock_maintenance_id=StockMaintenance.id')),
				'Product'=>array('foreignKey'=>false,'conditions'=>array('StockMaintenanceDetail.product_id=Product.id')),
				'StockIssueDetail'=>array('foreignKey'=>false,'conditions'=>array('StockIssueDetail.stock_maintenance_detail_id=StockMaintenanceDetail.id')))));
			
		$detailList=$this->StockMaintenance->find('all',array('conditions'=>array('StockMaintenance.store_location_id'=>$fromDepartId,
				'StockMaintenance.sub_department_id'=>$subDepartId,'StockIssueDetail.issued_to'=>$toDepartId)));
		$this->set('detailList',$detailList);
		
	}
	
	/**
	 *  department level stock item list autocomplete	 * 
	 * @param unknown_type $deparementId
	 * @param unknown_type $subDepartId
	 */
	
	public function consumption_stock($deparementId = null,$subDepartId=null){
		$this->uses = array('StockMaintenanceDetail','PharmacyItem');
		if($deparementId) $departmentConditiond = "StockMaintenance.store_location_id = $deparementId";
		if($subDepartId) $subDepartCondition = "StockMaintenance.sub_department_id = $subDepartId";
		 
		$this->StockMaintenanceDetail->bindModel(array(
				
				'belongsTo'=>array(
				
					'StockMaintenance'=>array(
							'foreignKey'=>false,
							'conditions'=>array('StockMaintenance.id = StockMaintenanceDetail.stock_maintenance_id')),
					
					'PharmacyItem'=>array(
							'foreignKey'=>false,
							'recursive'=>'1',
							'conditions'=>array('StockMaintenanceDetail.product_id = PharmacyItem.id' ))
					
				)),false);
		 
		$productStock= $this->StockMaintenanceDetail->find('all',array(
				'fields'=> array('StockMaintenanceDetail.mrp','StockMaintenanceDetail.stock_qty','PharmacyItem.name','PharmacyItem.id',
						'PharmacyItem.stock','PharmacyItem.pack','PharmacyItem.maximum' ,'PharmacyItem.expiry_date'),
				'conditions'=>array('PharmacyItem.is_deleted'=>0,'StockMaintenanceDetail.stock_qty >'=>0,
						'PharmacyItem.name like'=>'%'.$this->params->query['term'].'%',$departmentConditiond,$subDepartCondition)));
		
		foreach ($productStock as $key=>$value) {
			$returnArray[] = array( 'id'=>$value['PharmacyItem']['id'],
					'stock'=>$value['StockMaintenanceDetail']['stock_qty'],
					'sMrp'=>$value['StockMaintenanceDetail']['mrp'],
					'value'=>$value['PharmacyItem']['name'],
					'quantity'=>$value['PharmacyItem']['stock'],
					'pack'=>$value['PharmacyItem']['pack'],
					'max'=>$value['PharmacyItem']['maximum'],  
					'expiry'=>$value['PharmacyItem']['expiry_date'],) ;
		}
		echo json_encode($returnArray);
			
		exit;
	}
	
	
	/**
	 * supplier list
	 *
	 */
	public function supplierList() {
		$this->uses=array('InventorySupplier');
		$this->layout ='advance';
		$this->set('title_for_layout', __('Store Management - Supplier List ', true));
	//debug($this->params->query);exit;
		if(isset($this->params->query) && !empty($this->params->query)){
			if(!empty($this->params->query['supplier_id']))
				$conditions["InventorySupplier.id"] = $this->params->query['supplier_id']; 
		}
		
		//debug($this->params->query['supplier_id']);
		
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'InventorySupplier.name' => 'asc'
				),
				'conditions' => array($conditions,'InventorySupplier.is_deleted' => 0,"InventorySupplier.location_id" =>$this->Session->read('locationid'))
		);	
		
		$data = $this->paginate('InventorySupplier');
	//debug($data);
		$this->set('data', $data);
		

	}
	
	/**
	 * Add Supplier
	 */
	
	public function add_supplier() {
		if($this->params->query['flag']=='1'){  //open in fancybox without header
			$this->layout ='advance_ajax'; //to include all js and css with ajax layout
			$this->set('flagForBack',1);// it include to display fancybox without back btn
		}
		$this->set('title_for_layout', __('Pharmacy Management - Add New Supplier', true));
		$this->uses=array('PharmacySalesBill','InventorySupplier');
	
		if ($this->request->is('post')) {
			$this->request->data['InventorySupplier']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['InventorySupplier']['created_by'] = $this->Auth->user('id');
			$this->request->data['InventorySupplier']['location_id'] = $this->Session->read('locationid');
			//$this->request->data['InventorySupplier']['code'] = "SC".$this->PharmacySalesBill->generateRandomBillNo();
				
			$this->InventorySupplier->create();
				
			$this->InventorySupplier->save($this->request->data);
				
			$errors = $this->InventorySupplier->invalidFields();
			if(!empty($errors)) {
	
				$this->set("errors", $errors);
			} else {
				// code by mrunal to close add supplier window on submit btn
				if($this->params->query['flag']=='1'){
					$this->set('setFlash',1);
					$this->Session->setFlash(__('The Supplier has been saved', true));
				}else{
					$this->Session->setFlash(__('The Supplier has been saved', true));
					//$this->redirect(array("controller" => "pharmacy", "action" => "supplier_list" ,'inventory'=>true));
				}
				// end of code
			}
		}else{
			$code = "PH".$this->PharmacySalesBill->generateRandomBillNo();
			$this->uses=array('AccountingGroup');
			$this->set('group',$this->AccountingGroup->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_deleted'=>'0'),'order'=>array('name ASC'))));
				
			$this->set('code',$code);
		}
	
	}
	
	/**
	 * Edit Supplier
	 *
	 */
	public function edit_supplier($id = null) {
		$this->uses=array('PharmacySalesBill','InventorySupplier');
		$this->set('title_for_layout', __('Pharmacy Management - Edit Supplier', true));
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Supplier ID', true));
			$this->redirect(array("controller" => "Store", "action" => "supplierList",'inventory'=>true));
		}
		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->request->data['InventorySupplier']['modify_time'] = date('Y-m-d H:i:s');
			$this->request->data['InventorySupplier']['modified_by'] = $this->Auth->user('id');
			$this->request->data['InventorySupplier']['id']=$id;
			$this->request->data['InventorySupplier']['location_id']=$this->Session->read('locationid');
			$this->InventorySupplier->id = $id;
			$this->InventorySupplier->save($this->request->data);
			$errors = $this->InventorySupplier->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('Supplier has been updated', true));
				$this->redirect(array("controller"=>'Store',"action" => "supplierList"));
			}
		} else {
			$this->set('data',$this->InventorySupplier->read(null, $id,array('conditions' => array("InventorySupplier.location_id" =>$this->Session->read('locationid')))));
			$this->uses=array('AccountingGroup');
			$this->set('group',$this->AccountingGroup->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_deleted'=>'0'),'order'=>array('name ASC'))));
	
		}
	}
	
	/**
	 *  view  Supplier
	 *
	 */
	public function view_supplier($id = null, $isAjax=null) {
		$this->uses=array('InventorySupplier');
		$this->InventorySupplier->unbindModel(array('hasMany' => array('InventoryPurchaseDetail','PharmacyItem')),false);
		$this->set('title_for_layout', __('Store Management - Supplier Detail', true));
		if (!$id && !$this->request->is('post')) {
			$this->Session->setFlash(__('Invalid Supplier', true));
			$this->redirect(array("controller"=>'Store',"action" => "supplierList"));
		}else{
			if($this->request->is('post') && $this->request->data['id']){
	
				echo json_encode($this->InventorySupplier->read(null, $this->request->data['id']));
				exit;
			}else if($this->request->is('get') &&  $isAjax!=null){
				echo json_encode($this->InventorySupplier->read(null,$id));
				exit;
			}else{
				$this->set('data', $this->InventorySupplier->read(null, $id,array('conditions' => array("InventorySupplier.location_id" =>$this->Session->read('locationid'),"InventorySupplier.is_deleted"=>0))));
			}
		}
	}
	
	/**
	 * Supplier delete
	 *
	 */
	public function supplier_delete($id = null) {
		$this->uses=array('InventorySupplier');
		$this->set('title_for_layout', __('Store Management - Delete Supplier ', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid ID	', true));
			$this->redirect(array("controller"=>'Store',"action" => "supplierList"));
		}
		if ($id) {
			$this->InventorySupplier->deleteInventorySupplierItem($id);
			$this->Session->setFlash(__('Supplier deleted', true));
			$this->redirect(array("controller"=>'Store',"action" => "supplierList"));
		}
	}
	
	
	/**
	 * Department wise stock List
	 * 
	 */
	public function departmental_stock(){
	$this->layout ='advance';
		$this->uses=array('StoreLocation','StockMaintenance','StockMaintenanceDetail','Ward','Opt','Chamber','PharmacyItem');
		$roleId=$this->Session->read('roleid');	
		
		$mylocations = $this->StoreLocation->find('all',array('fields'=>array('id','name','role_id'),'conditions' => array('StoreLocation.is_deleted' =>'0','StoreLocation.is_consumable' =>'0')));
		$returnArray = array();
		foreach($mylocations as $dept){ 
			$deptRolesArray = explode("|",$dept['StoreLocation']['role_id']); 
			if(in_array($roleId,$deptRolesArray)){
				$returnArray[$dept['StoreLocation']['id']] = $dept['StoreLocation']['name'];
			}
		} 
		$this->set('department',$returnArray);
		
		/*$this->set('department',$this->StoreLocation->find('list',
				array('conditions' => array('StoreLocation.is_deleted' =>'0','StoreLocation.role_id LIKE'=>'%'.$roleId.'%'))));*/
		$this->StockMaintenance->bindModel(array('belongsTo'=>array(
				'StockMaintenanceDetail'=>array('foreignKey'=>false,'conditions'=>array('StockMaintenanceDetail.stock_maintenance_id=StockMaintenance.id')),
				'StoreLocation'=>array('foreignKey'=>false,'conditions'=>array('StoreLocation.id=StockMaintenance.store_location_id')),
				'PharmacyItem'=>array('foreignKey'=>false,'conditions'=>array('StockMaintenanceDetail.product_id=PharmacyItem.id')),
				'Product'=>array('foreignKey'=>false,'conditions'=>array('PharmacyItem.drug_id=Product.id')),
				'ManufacturerCompany'=>array('foreignKey'=>false,'conditions'=>array('ManufacturerCompany.id=Product.manufacturer_id')))));
		if($this->request->data){
			if($this->request->data['StoreLocation']['ward']){
				$condition['StockMaintenance.sub_department_id']=$this->request->data['StoreLocation']['ward'];
			}else if($this->request->data['StoreLocation']['ot']){
				$condition['StockMaintenance.sub_department_id']=$this->request->data['StoreLocation']['ot'];
			}else if($this->request->data['StoreLocation']['chamber']){
				$condition['StockMaintenance.sub_department_id']=$this->request->data['StoreLocation']['chamber'];
			}
			$this->paginate = array(		
				'limit' => Configure::read('number_of_rows'),
				//'fields'=>array('StockMaintenance.id'),
				'conditions' => array('StockMaintenance.store_location_id' => $this->request->data['StoreLocation']['department'],$condition)
			);	
			$results = $this->paginate('StockMaintenance');
			$this->set('results',$results);
		}
		$this->set('wards',$this->Ward->find('list',
				array('conditions' => array('Ward.is_deleted' => 0, 'Ward.location_id' =>
						$this->Session->read("locationid")))));
		$this->set('ot',$this->Opt->find('list',
				array('conditions' => array('Opt.is_deleted' => 0, 'Opt.location_id' =>
						$this->Session->read("locationid")))));
		$this->set('chambers',$this->Chamber->find('list',
				array('conditions' => array('Chamber.is_deleted' => 0, 'Chamber.location_id' =>
						$this->Session->read("locationid")))));
		
	}
	
	
	function saveReorder($id=null){
		$this->uses=array('StoreLocation','StockMaintenance','StockMaintenanceDetail');
		$this->StockMaintenanceDetail->save($this->request->data);
		exit;
		
	}
	
	public function department_store(){
		// echo "hello"; exit;
		$this->layout='advance';
	}
	/**
	 * function for Stock Transfer
	 * @param unknown_type $requisitionID
	 * by Mahalaxmi
	 */
	public function issue_stock_requisition($requisitionID=null){
			
		$this->layout='advance';
		$this->uses = array('PharmacyItem','Location','StoreRequisition','Product',"PharmacyItemRate",'StoreLocation',"ProductRate","PatientCentricDepartment","Ward","Opt","Chamber",'StoreRequisitionParticular','StockMaintenance','PurchaseOrderitem');
		$status=$this->params->pass['1'];
		$this->set('status',$status);
	
		if($requisitionID !=null ){
			$StoreRequisition = $this->StoreRequisition->read(null,$requisitionID);
			//Requisition From
			$storeLocationFrom = $this->Location->find('first',array('fields'=>array('Location.id','Location.name'),'conditions'=>array('Location.id'=>$StoreRequisition['StoreRequisition']['requisition_by'])));
			//Requisition To
			$requisitionTo = $this->Location->find('first',array('fields'=>array('Location.id','Location.name'),'conditions'=>array('Location.id'=>$StoreRequisition['StoreRequisition']['requisition_for'])));
			//if(strtolower($requisitionTo['StoreLocation']['name']) == strtolower(Configure::read('OT Pharmacy'))){
				$this->StoreRequisitionParticular->unbindModel(array('belongsTo'=>array('Product','PurchaseOrderItem')));
	
				$this->StoreRequisitionParticular->bindModel(array(
						'belongsTo'=>array(
					/*To*/	'PharmacyItem'=>array('foreignKey'=>false,'conditions'=>array('StoreRequisitionParticular.purchase_order_item_id = PharmacyItem.id','PharmacyItem.location_id'=>$StoreRequisition['StoreRequisition']['requisition_for'])),
					/*From*/'PharmacyItemAlias'=>array('foreignKey'=>false,'className'=>'PharmacyItem','conditions'=>array('StoreRequisitionParticular.existing_stock_order_item_id = PharmacyItemAlias.id','PharmacyItemAlias.location_id'=>$StoreRequisition['StoreRequisition']['requisition_by'])),
							),
				));
				$storeDetails = $this->StoreRequisitionParticular->find('all',array('conditions'=>array('StoreRequisitionParticular.store_requisition_detail_id'=>$requisitionID,'StoreRequisitionParticular.is_deleted'=>0)));
				foreach($storeDetails as $key => $value){
					$pharmacyItemToId[]= $value['PharmacyItem']['id'];
					$storeDetails[$key]['ProductRate']['toId']= $value['PharmacyItem']['id'];
					
					$storeDetails[$key]['ProductRate']['FromItemId']= $value['StoreRequisitionParticular']['existing_stock_order_item_id'];		
					$storeDetails[$key]['ProductRate']['ToItemId']= $value['StoreRequisitionParticular']['purchase_order_item_id'];						
					$storeDetails[$key]['ProductRate']['id']= $value['PharmacyItemAlias']['id'];
					$storeDetails[$key]['ProductRate']['name']= $value['PharmacyItem']['name'];		
					$storeDetails[$key]['ProductRate']['stock']= $value['PharmacyItem']['stock']*$value['PharmacyItem']['pack']+$value['PharmacyItem']['loose_stock'];					
					$storeDetails[$key]['ProductRate']['stockfrom']= $value['PharmacyItemAlias']['stock']*$value['PharmacyItemAlias']['pack']+$value['PharmacyItemAlias']['loose_stock'];
				}
				$pharmacyItemBatches = $this->PharmacyItemRate->find('all',array('fields'=>array('PharmacyItemRate.id','PharmacyItemRate.location_id','PharmacyItemRate.item_id','PharmacyItemRate.batch_number','PharmacyItem.id'),'conditions'=>array('PharmacyItemRate.item_id'=>$pharmacyItemToId,'PharmacyItemRate.location_id'=>$StoreRequisition['StoreRequisition']['requisition_for'],'PharmacyItemRate.batch_number <>'=>null),'order'=>array('PharmacyItemRate.expiry_date'=>'ASC')));
				/*$log = $this->PharmacyItemRate->getDataSource()->getLog(false, false);;
				debug($log);*/
				//debug($pharmacyItemBatches);
				foreach($pharmacyItemBatches as $key=>$pharmacyItemBatchess){
					$commArr[$pharmacyItemBatchess['PharmacyItemRate']['item_id']][$pharmacyItemBatchess['PharmacyItemRate']['id']]=$pharmacyItemBatchess;
				}
				
			//}
			$requsition_for='';
			if(strtolower($storeLocation['StoreLocation']['code_name'])==strtolower(Configure::read('pharmacyCode'))){
				$requisitionForName=Configure::read('pharmacyCode');
			}
	
			if($requisitionForName == Configure::read('pharmacyCode')){
				$roleId=$this->Session->read('roleid');
				$pharmaDepart = $this->StoreLocation->find('first',
						array('conditions'=>array('StoreLocation.is_deleted' =>'0','StoreLocation.code_name' => Configure::read('pharmacyCode'),'StoreLocation.role_id LIKE'=>'%'.$roleId.'%')),
						array('fields'=>array('StoreLocation.id')));
				$requsition_for = $pharmaDepart['StoreLocation']['name'];
			}else{
				if($storeLocation['StoreLocation']['name'] == "Other"){
					$this->LoadModel("PatientCentricDepartment");
					$for = $this->PatientCentricDepartment->read(null,$StoreRequisition['StoreRequisition']['requister_id']);
					$requsition_for =$for['PatientCentricDepartment']['name'];
				}else if($storeLocation['StoreLocation']['name'] == "OT"){
					$for = $this->Opt->read(null,$StoreRequisition['StoreRequisition']['requister_id']);
					$requsition_for =$for['Opt']['name'];
				}else if($storeLocation['StoreLocation']['name'] == "Chamber"){
					$this->LoadModel("Chamber");
					$for = $this->Chamber->read(null,$StoreRequisition['StoreRequisition']['requister_id']);
					$requsition_for =$for['Chamber']['name'];
				}else if($storeLocation['StoreLocation']['name'] == "Ward"){
					$this->LoadModel("Ward");
					$for = $this->Ward->read(null,$StoreRequisition['StoreRequisition']['requister_id']);
					$requsition_for =$for['Ward']['name'];
				}
			}
			if(!empty($requsition_for))
				$data['for'] =  $requsition_for;
			else{
				$data['for']=$StoreRequisition['StoreRequisition']['requisition_for'];
				$requsition_for=$storeLocation['StoreLocation']['name'];
			}
			
			$data['for'] =  $requsition_for;
			$this->set("StoreRequisition",$StoreRequisition);
			$this->set("commArr",$commArr);
			$this->set("storeDetails",$storeDetails);
			$this->set("requisition_from",$storeLocationFrom);
			$this->set("requisition_to",$requisitionTo);
	
		}
	
	
	
		if($this->request->data){			
			$stockm=$this->StockMaintenance->find('all');
			$this->request->data['StoreRequisition']['id']=$requisitionID;
			$this->request->data['StoreRequisition']['updated_by']=$this->Session->read('userid');
			$this->request->data['StoreRequisition']['issue_date']=$this->DateFormat->formatDate2STD($this->request->data['StoreRequisition']['issue_date'],Configure::read('date_format'));
			$this->request->data['StoreRequisition']['updated_time']=date('Y-m-d H:i:s');

			
			$this->StoreRequisition->save($this->request->data['StoreRequisition']);
			
			if($StoreRequisition['StoreRequisition']['requisition_for']&&!empty($StoreRequisition['StoreRequisition']['requister_id'])){
				$depart_id=$StoreRequisition['StoreRequisition']['requisition_for'];
				$subdepartID=$StoreRequisition['StoreRequisition']['requister_id'];
			}else if(empty($StoreRequisition['StoreRequisition']['requister_id'])){
				$depart_id=$StoreRequisition['StoreRequisition']['requisition_for'];
			}
	
			$loc = $this->Session->read('locationid');
			$userId = $this->Session->read('userid');
			$pharmacy = array('pharmacy'=>'pharmacy');
			
			//update pharmacy stock of requisition from and requisition to location
			$cnt=0;
			foreach($this->request->data['StoreRequisition']['slip_detail']['item_name'] as $keyN=>$storeRequisitionParticular){
				//debug($this->request->data['StoreRequisition']['slip_detail']['batch'][$keyN]);
						  
			   /*************************for location which will fulfill request- Stock needs to be deducted*********************/
			    $phramacyItemRequestedto_location=$this->PharmacyItem->find('first', array(
			    'fields'=>array('PharmacyItem.id','PharmacyItem.stock','PharmacyItem.loose_stock','PharmacyItem.pack','PharmacyItem.location_id'),
			    'conditions'=>array('PharmacyItem.location_id'=>$StoreRequisition['StoreRequisition']['requisition_for'],
			    		'PharmacyItem.name'=>$storeRequisitionParticular)));	    
				$totalTab=($phramacyItemRequestedto_location['PharmacyItem']['stock']*$phramacyItemRequestedto_location['PharmacyItem']['pack'])+$phramacyItemRequestedto_location['PharmacyItem']['loose_stock'];
			    $stockUpdatedTab=$totalTab-$this->request->data['StoreRequisition']['slip_detail']['issued_qty'][$cnt];
			    $stockUpdated=$stockUpdatedTab/$phramacyItemRequestedto_location['PharmacyItem']['pack'];
			    $loosestockUpdated=$stockUpdatedTab%$phramacyItemRequestedto_location['PharmacyItem']['pack'];
			    $exploStockUpdated=explode('.',$stockUpdated);
				 //$loosestockUpdated=floor($loosestockUpdated);
			    //$stockUpdated=floor($stockUpdated);			
				
					//update request TO location
				$updateArrayPharmacyItemTo['id']=$phramacyItemRequestedto_location['PharmacyItem']['id'];
				$updateArrayPharmacyItemTo['stock']=$exploStockUpdated[0];
				$updateArrayPharmacyItemTo['loose_stock']=$loosestockUpdated;		
				$this->PharmacyItem->save($updateArrayPharmacyItemTo);
				$this->PharmacyItem->id="";
				
				//for To location which will fulfill request- Stock needs to be deducted For PharmacyItemRate
							
				////$this->request->data['StoreRequisition']['slip_detail']['batch'][$keyN]--Item rate id
				$phramacyItemRateRequestedto_location=$this->PharmacyItemRate->find('first', array('fields'=>array('PharmacyItemRate.id','PharmacyItemRate.stock','PharmacyItemRate.loose_stock','PharmacyItemRate.location_id','PharmacyItemRate.batch_number','PharmacyItemRate.expiry_date'),'conditions'=>array('PharmacyItemRate.location_id'=>$StoreRequisition['StoreRequisition']['requisition_for'],'PharmacyItemRate.id'=>$this->request->data['StoreRequisition']['slip_detail']['batch'][$keyN],'PharmacyItemRate.item_id'=>$phramacyItemRequestedto_location['PharmacyItem']['id']),'order'=>array('PharmacyItemRate.expiry_date'=>'ASC')));
				$totalTabPharmacyItemRateTo=($phramacyItemRateRequestedto_location['PharmacyItemRate']['stock']*$phramacyItemRequestedto_location['PharmacyItem']['pack'])+$phramacyItemRateRequestedto_location['PharmacyItemRate']['loose_stock'];
				$stockUpdatedTabPharmacyItemRateTo=$totalTabPharmacyItemRateTo-$this->request->data['StoreRequisition']['slip_detail']['issued_qty'][$cnt];
					
					$stockUpdatedPharmacyItemRateTo=$stockUpdatedTabPharmacyItemRateTo/$phramacyItemRequestedto_location['PharmacyItem']['pack'];
					$loosestockUpdatedTo=$stockUpdatedTabPharmacyItemRateTo%$phramacyItemRequestedto_location['PharmacyItem']['pack'];
					$exploStockUpdatedPharmacyItemRateTo=explode('.',$stockUpdatedPharmacyItemRateTo);
					//$loosestockUpdatedTo=floor($loosestockUpdatedTo);
					//$stockUpdatedPharmacyItemRateTo=floor($stockUpdatedPharmacyItemRateTo);
					//update request TO location For PharmacyItemRate 
					$updateArrayPharmacyItemRateTo['id']=$phramacyItemRateRequestedto_location['PharmacyItemRate']['id'];
					$updateArrayPharmacyItemRateTo['stock']=$exploStockUpdatedPharmacyItemRateTo[0];
					$updateArrayPharmacyItemRateTo['loose_stock']=$loosestockUpdatedTo;
					$this->PharmacyItemRate->save($updateArrayPharmacyItemRateTo);
					$this->PharmacyItemRate->id="";
					
					
					
				//debug($StoreRequisition['StoreRequisition']['requisition_by']);
				/********************for location which will fulfill request- Stock needs to be added*********************************/
				/*$phramacyItemRequestedfrom_location=$this->PharmacyItem->find('first', array('fields'=>array('PharmacyItem.id','PharmacyItem.stock','PharmacyItem.loose_stock','PharmacyItem.pack','PharmacyItem.location_id'),'conditions'=>array('PharmacyItem.location_id'=>$StoreRequisition['StoreRequisition']['requisition_by'],'PharmacyItem.name'=>$storeRequisitionParticular)));
				$totalTabFrom=($phramacyItemRequestedfrom_location['PharmacyItem']['stock']*$phramacyItemRequestedfrom_location['PharmacyItem']['pack'])+$phramacyItemRequestedfrom_location['PharmacyItem']['loose_stock'];
				$stockUpdatedTabFrom=$totalTabFrom+$this->request->data['StoreRequisition']['slip_detail']['issued_qty'][$cnt];
				$stockUpdatedFrom=$stockUpdatedTabFrom/$phramacyItemRequestedfrom_location['PharmacyItem']['pack'];
				$loosestockUpdatedFrom=$stockUpdatedTabFrom%$phramacyItemRequestedfrom_location['PharmacyItem']['pack'];
				$loosestockUpdatedFrom=floor($loosestockUpdatedFrom);
				$stockUpdatedFrom=floor($stockUpdatedFrom);*/
				
				//update request TO location
				
				/*$updateArrayPharmacyItemFrom['id']=$phramacyItemRequestedfrom_location['PharmacyItem']['id'];
				$updateArrayPharmacyItemFrom['stock']=$stockUpdatedFrom;
				$updateArrayPharmacyItemFrom['loose_stock']=$loosestockUpdatedFrom;
				
				$this->PharmacyItem->save($updateArrayPharmacyItemFrom);
				$this->PharmacyItem->id="";*/

				//for To location which will fulfill request- Stock needs to be added For PharmacyItemRate
					
				
				//$phramacyItemRateRequestedFrom_location=$this->PharmacyItemRate->find('first', array('fields'=>array('PharmacyItemRate.id','PharmacyItemRate.stock','PharmacyItemRate.loose_stock','PharmacyItemRate.location_id'),'conditions'=>array('PharmacyItemRate.item_id'=>$phramacyItemRequestedfrom_location['PharmacyItem']['id'],'PharmacyItemRate.location_id'=>$StoreRequisition['StoreRequisition']['requisition_by'],'PharmacyItemRate.batch_number'=>trim($phramacyItemRateRequestedto_location['PharmacyItemRate']['batch_number']))/*,'order'=>array('PharmacyItemRate.expiry_date'=>'ASC')*/));
			
				
				//update request From location For PharmacyItemRate
					
				
				/*if(empty($phramacyItemRateRequestedFrom_location['PharmacyItemRate']['id'])){
					//new batch add
					$getStock=$this->request->data['StoreRequisition']['slip_detail']['issued_qty'][$cnt]/$phramacyItemRequestedfrom_location['PharmacyItem']['pack'];
					$getLooseStock=$this->request->data['StoreRequisition']['slip_detail']['issued_qty'][$cnt]%$phramacyItemRequestedfrom_location['PharmacyItem']['pack'];
					$getLooseStock=floor($getLooseStock);
					$getStockNew=floor($getStock);
						
					$updateArrayPharmacyItemRateFrom['expiry_date']=$phramacyItemRateRequestedto_location['PharmacyItemRate']['expiry_date'];				
					$updateArrayPharmacyItemRateFrom['batch_number']=trim($phramacyItemRateRequestedto_location['PharmacyItemRate']['batch_number']);				
					$updateArrayPharmacyItemRateFrom['location_id']=$phramacyItemRequestedfrom_location['PharmacyItem']['location_id'];
					$updateArrayPharmacyItemRateFrom['item_id']=trim($phramacyItemRequestedfrom_location['PharmacyItem']['id']);
					$updateArrayPharmacyItemRateFrom['stock']=$getStockNew;
					$updateArrayPharmacyItemRateFrom['loose_stock']=$getLooseStock;
				}else{
					///Update Batch
					$totalTabPharmacyItemRateFrom=($phramacyItemRateRequestedFrom_location['PharmacyItemRate']['stock']*$phramacyItemRequestedfrom_location['PharmacyItem']['pack'])+$phramacyItemRateRequestedFrom_location['PharmacyItemRate']['loose_stock'];
					$stockUpdatedTabPharmacyItemRateFrom=$totalTabPharmacyItemRateFrom+$this->request->data['StoreRequisition']['slip_detail']['issued_qty'][$cnt];
					$stockUpdatedPharmacyItemRateFrom=$stockUpdatedTabPharmacyItemRateFrom/$phramacyItemRequestedfrom_location['PharmacyItem']['pack'];
					$loosestockUpdatedPharmacyItemRateFrom=$stockUpdatedTabPharmacyItemRateFrom%$phramacyItemRequestedfrom_location['PharmacyItem']['pack'];
					$loosestockUpdatedPharmacyItemRateFrom=floor($loosestockUpdatedPharmacyItemRateFrom);
					$stockUpdatedPharmacyItemRateFrom=floor($stockUpdatedPharmacyItemRateFrom);
						
					$updateArrayPharmacyItemRateFrom['id']=$phramacyItemRateRequestedFrom_location['PharmacyItemRate']['id'];
					$updateArrayPharmacyItemRateFrom['stock']=$stockUpdatedPharmacyItemRateFrom;
					$updateArrayPharmacyItemRateFrom['loose_stock']=$loosestockUpdatedPharmacyItemRateFrom;						
				}
				$this->PharmacyItemRate->save($updateArrayPharmacyItemRateFrom);
				
				$this->PharmacyItemRate->id="";		*/		
				
				$cnt++;
				
			    
			}
		
			if($this->StoreRequisitionParticular->saveParticulars($this->request->data['StoreRequisition']['slip_detail'],$requisitionID,$status,$this->request->query['pharmacy'],$userId,$loc,$requisitionTo)){
				
				if($this->StockMaintenance->setStock($depart_id,$subdepartID,$requisitionID,$this->request->data['StoreRequisition']['slip_detail'])){
					$this->Session->setFlash(__('The requisition has been issued succesfully', true),'default',array('class'=>'message'));
					if($this->params->query['pharmacy']){
						//redirect change by pankaj initially set to 'store_requisition_list'
						$this->redirect(array("controller" => "InventoryCategories", "action" => "stock_inbox_requistion_list",'?'=>array('pharmacy'=>'pharmacy')));
					}else{
						$this->redirect(array("controller" => "InventoryCategories", "action" => "stock_inbox_requistion_list"));
					}
				}else{
					$this->Session->setFlash(__('Please try again', true),'default',array('class'=>'error'));
				}
			}
			else{
				
				if(!empty($this->StoreRequisitionParticular->error)){
					$this->Session->setFlash(__($this->StoreRequisitionParticular->error, true),'default',array('class'=>'error'));
				}else{
					$errors=$this->StoreRequisitionParticular->invalidFields();
					if(!empty($errors)){
						$this->set("errors", $errors);
					}
				}
			}
		}
	}
	
	//by swapnil - display consumption list according to departments 24.03.2015
	public function getConsumptionProducts($department,$subDepartment = null){
		$this->autoRender = false;
		$this->layout = "ajax"; 
		$this->uses=array('StockMaintenance','PharmacyItem'); 	
		
		$conditions = array();
		$conditions = array('StockMaintenance.store_location_id'=>$department);
		
		if(!empty($subDepartment)){
			$conditions = array('StockMaintenance.sub_department_id'=>$subDepartment);
		}
		
		$this->StockMaintenance->bindModel(array('belongsTo'=>array(
				'StockMaintenanceDetail'=>array('foreignKey'=>false,'conditions'=>array('StockMaintenanceDetail.stock_maintenance_id=StockMaintenance.id','StockMaintenanceDetail.issued_qty >'=>0)),
				'PharmacyItem'=>array('foreignKey'=>false,'conditions'=>array('StockMaintenanceDetail.product_id=PharmacyItem.id')),
				'StockIssueDetail'=>array('foreignKey'=>false,'conditions'=>array('StockIssueDetail.stock_maintenance_detail_id=StockMaintenanceDetail.id')))));
		
		$detailList = $this->StockMaintenance->find('all',array(
						'fields'=>array('PharmacyItem.name','StockIssueDetail.issued_qty','StockIssueDetail.closing_stock','StockIssueDetail.created'),
						'conditions'=>$conditions));
		$this->set('detailList',$detailList);
		$this->render('get_consumptiom_product');
	}	

	
	//by swapnil - to search the items from various department on 15.04.2015
	public function item_search_autocomplete($locationId){
		$this->autoRender = false;
		$this->layout = "ajax";
		$this->uses = array("StoreLocation","Location");

		$searchKey = $this->params->query['term'];
		
		$allStore = $this->StoreLocation->find('list',array('conditions'=>array('StoreLocation.is_deleted'=>0),'fields'=>array('StoreLocation.id','StoreLocation.code_name')));
		if(array_search(Configure::read('pharmacyCode'), $allStore) == $locationId){
			$location = $this->Session->read('locationid');
			$data = $this->searchPharmacyProduct($searchKey,$location);
		}
		else if(array_search(Configure::read('apamCode'), $allStore) == $locationId){ 
			$location = $this->Location->getLocationIdByName(Configure::read('apamCode'));
			$data = $this->searchPharmacyProduct($searchKey,$location);
		}
		else if(array_search(Configure::read('centralStoreCode'), $allStore) == $locationId){
			$data = $this->searchProductProduct($searchKey);
		}
		else if(array_search(Configure::read('otpharmacycode'), $allStore) == $locationId){
			$data = $this->searchOTProduct($searchKey);
		}
		
		echo json_encode($data);
		exit;
	}
	//End of function
	
	
	public function searchPharmacyProduct($searchKey,$location_id){
		$this->uses = array('PharmacyItem','PharmacyItemRate'); 
		$data = $this->PharmacyItem->find('all',array( 
								'fields'=>array('PharmacyItem.id','PharmacyItem.drug_id','PharmacyItem.name'),
								'conditions'=>array('PharmacyItem.location_id'=>$location_id,'PharmacyItem.is_deleted'=>0,'PharmacyItem.name LIKE'=>$searchKey."%",'PharmacyItem.drug_id IS NOT NULL'),
								'limit'=>Configure::read('number_of_rows'),
								'group'=>'PharmacyItem.id',
								'order'=>array('PharmacyItem.name'=>"ASC")));
		
		foreach($data as $key => $value){
			$returnArray[] = array('id'=>$value['PharmacyItem']['id'],'product_id'=>$value['PharmacyItem']['drug_id'],'value'=>$value['PharmacyItem']['name']);
		}
		return $returnArray;
	}
	//End of function
	
	
	public function searchProductProduct($searchKey){
		$this->uses = array('Product','ProductRate','Location');
		$data = $this->Product->find('all',array(
				'fields'=>array('Product.id','Product.name'),
				'conditions'=>array('Product.is_deleted'=>0,'Product.name LIKE'=>$searchKey."%",
						'Product.location_id NOT' => $this->Location->getLocationIdByName(Configure::read('apamCode'))),
				'limit'=>Configure::read('number_of_rows'),
				'group'=>'Product.id',
				'order'=>array('Product.name'=>"ASC")));
		
		foreach($data as $key => $value){
			$returnArray[] = array('id'=>$value['Product']['id'],'product_id'=>$value['Product']['id'],'value'=>$value['Product']['name']);
		}
		return $returnArray;
	}
	//End of function
	
	
	public function searchOTProduct($searchKey){
		$this->uses = array('OtPharmacyItem','OtPharmacyItemRate'); 
		$data = $this->OtPharmacyItem->find('all',array(
				'fields'=>array('OtPharmacyItem.id','OtPharmacyItem.product_id','OtPharmacyItem.name'),
				'conditions'=>array('OtPharmacyItem.is_deleted'=>0,'OtPharmacyItem.name LIKE'=>$searchKey."%"),
				'limit'=>Configure::read('number_of_rows'),
				'group'=>'OtPharmacyItem.id',
				'order'=>array('OtPharmacyItem.name'=>"ASC")));
		
		foreach($data as $key => $value){
			$returnArray[] = array('id'=>$value['OtPharmacyItem']['id'],'product_id'=>$value['OtPharmacyItem']['product_id'],'value'=>$value['OtPharmacyItem']['name']);
		}
		return $returnArray;
	}
	//End of function
	
	//by swapnil
	public function fetch_rate_for_items(){
		$this->autoRender = false;
		$this->layout = "ajax";
		$this->uses = array("StoreLocation","Location",'PharmacyItem','PharmacyItemRate','Product','ProductRate','OtPharmacyItem','OtPharmacyItemRate');
	
		if(!empty($this->request->data)){
			$department = $this->request->data['department'];
			$productId = $this->request->data['product_id'];
		}
			
		$allStore = $this->StoreLocation->find('list',array('conditions'=>array('StoreLocation.is_deleted'=>0),'fields'=>array('StoreLocation.id','StoreLocation.code_name')));
		if(array_search(Configure::read('pharmacyCode'), $allStore) == $department || array_search(Configure::read('apamCode'), $allStore) == $department){
				
			if(isset($productId) && !empty($productId)){
				$this->PharmacyItem->unbindModel(array('hasMany'=>array('InventoryPurchaseItemDetail'),'hasOne'=>array('PharmacyItemRate')));
				$this->PharmacyItem->bindModel(array(
						'hasMany'=>array(
								'PharmacyItemRate'=>array('foreignKey'=>'item_id',
										'conditions'=>array('PharmacyItemRate.is_deleted'=>0,'PharmacyItemRate.location_id'=>$this->Session->read('locationid'))))));
	
				$item = $this->PharmacyItem->find('first',array(
						'fields'=>array('PharmacyItem.item_code','PharmacyItem.pack','PharmacyItem.name','PharmacyItem.doseForm','PharmacyItem.generic'),
						'conditions'=>array('PharmacyItem.id' =>$productId,	'PharmacyItem.drug_id !='=>NULL),
				)); 
				$pack = $item['PharmacyItem']['pack']?$item['PharmacyItem']['pack']:1;
				$stock=0;
				foreach($item['PharmacyItemRate'] as $key => $val){
					$item['PharmacyItem']['total']+= ($val['stock'] * $pack) + $val['loose_stock']; 
				}   
			}
		} else
			if(array_search(Configure::read('centralStoreCode'), $allStore) == $department){
	
			if(isset($productId) && !empty($productId)){
				$this->Product->bindModel(array(
						'hasMany'=>array(
								'ProductRate'=>array('foreignKey'=>'product_id',
										'conditions'=>array('ProductRate.is_deleted'=>0)))));
	
				$item = $this->Product->find('first',array(
						'fields'=>array('Product.id','Product.name'),
						'conditions'=>array('Product.id' =>$productId),
				));
				$item['PharmacyItem'] = $item['Product'];
				$item['PharmacyItemRate'] = $item['ProductRate'];
				foreach($item['PharmacyItemRate'] as $key => $val){
					$item['PharmacyItem']['total'] += $val['stock'];	//total stock (ALL ProductRate stock)
				}
			}
		}else
			if(array_search(Configure::read('otpharmacycode'), $allStore) == $department){
	
			if(isset($productId) && !empty($productId)){
				$item = $this->OtPharmacyItem->find('first',array(
						'fields'=>array('OtPharmacyItem.id','OtPharmacyItem.name'),
						'conditions'=>array('OtPharmacyItem.id' =>$productId),
				));
				$item['PharmacyItem'] = $item['OtPharmacyItem'];
				$item['PharmacyItemRate'] = $item['OtPharmacyItemRate'];
				foreach($item['PharmacyItemRate'] as $key => $val){
					$item['PharmacyItem']['total'] += $val['stock'];	//total stock (ALL ProductRate stock)
				}
			}
		}
		//debug($item); exit;
		echo (json_encode($item));
		exit;
	}
	//End of function
	
	
	public function fetch_batch_for_item(){
		$this->autoRender = false;
		$this->layout = "ajax";
		$this->uses = array("StoreLocation","Location",'PharmacyItem','PharmacyItemRate','Product','ProductRate','OtPharmacyItem','OtPharmacyItemRate');
	
		if(!empty($this->request->data)){
			$department = $this->request->data['department'];
			$rate_id = $this->request->data['rate_id'];
		}
	
		$allStore = $this->StoreLocation->find('list',array('conditions'=>array('StoreLocation.is_deleted'=>0),'fields'=>array('StoreLocation.id','StoreLocation.code_name')));
		if(array_search(Configure::read('pharmacyCode'), $allStore) == $department || array_search(Configure::read('apamCode'), $allStore) == $department){
			if(isset($rate_id) && !empty($rate_id)){
				$data = $this->PharmacyItemRate->find('first',array('fields'=>array('PharmacyItemRate.id','PharmacyItemRate.loose_stock','PharmacyItemRate.stock','PharmacyItem.pack'),'conditions'=>array('PharmacyItemRate.id'=>$rate_id)));
				$data['PharmacyItem']['pack'] = $data['PharmacyItem']['pack']!=''?$data['PharmacyItem']['pack']:1;
				$data['PharmacyItemRate']['rate_total'] = ($data['PharmacyItemRate']['stock'] * $data['PharmacyItem']['pack'])+$data['PharmacyItemRate']['loose_stock'];
			}
		}else
			if(array_search(Configure::read('centralStoreCode'), $allStore) == $department){
			if(isset($rate_id) && !empty($rate_id)){
				$data = $this->ProductRate->find('first',array('conditions'=>array('ProductRate.id'=>$rate_id)));
			}
			$data['PharmacyItemRate'] = $data['ProductRate'];
		}else
			if(array_search(Configure::read('otpharmacycode'), $allStore) == $department){
			if(isset($rate_id) && !empty($rate_id)){
				$data = $this->OtPharmacyItemRate->find('first',array('conditions'=>array('OtPharmacyItemRate.id'=>$rate_id)));
			}
			$data['PharmacyItemRate'] = $data['OtPharmacyItemRate'];
		}
		echo json_encode($data);
		exit;
	}
	//End of function
	
	
	public function updateItem(){
		$this->autoRender = false;
		$this->layout = "ajax";
		$this->uses = array("StoreLocation","Location",'PharmacyItem','PharmacyItemRate','Product','ProductRate','OtPharmacyItem','OtPharmacyItemRate');
	
		$allStore = $this->StoreLocation->find('list',array('conditions'=>array('StoreLocation.is_deleted'=>0),'fields'=>array('StoreLocation.id','StoreLocation.code_name')));
	
		if(!empty($this->request->data)){
				
			$department = $this->request->data['department'];
			$productName =  $this->request->data['product_name'];
			$addProductQty = $this->request->data['add_qty'];
			$substractProductQty = $this->request->data['substract_qty'];
			$productId = $this->request->data['product_id'];
			$rateId = $this->request->data['batch_number'];
			 
			if(array_search(Configure::read('pharmacyCode'), $allStore) == $department || array_search(Configure::read('apamCode'), $allStore) == $department){
	
				$pharmacyItemRateData = $this->PharmacyItemRate->find('first',array('fields'=>array('PharmacyItem.pack','PharmacyItem.id','PharmacyItemRate.id','PharmacyItemRate.stock','PharmacyItemRate.loose_stock'),'conditions'=>array('PharmacyItemRate.id'=>$rateId,'PharmacyItemRate.item_id'=>$productId)));
				 
				$savePharmacyItem = array();
				$savePharmacyItemRate = array();
	
				$pack = $pharmacyItemRateData['PharmacyItem']['pack'];
				if(!empty($addProductQty)){
					$totalStock = (($pharmacyItemRateData['PharmacyItemRate']['stock'] * $pack ) + $pharmacyItemRateData['PharmacyItemRate']['loose_stock']) + $addProductQty;
				}
				if(!empty($substractProductQty)){
					$totalStock = (($pharmacyItemRateData['PharmacyItemRate']['stock'] * $pack ) + $pharmacyItemRateData['PharmacyItemRate']['loose_stock']) - $substractProductQty;
				}
				
				$savePharmacyItemRate['stock'] = floor($totalStock / $pharmacyItemRateData['PharmacyItem']['pack']);
				$savePharmacyItemRate['loose_stock'] = floor($totalStock%$pharmacyItemRateData['PharmacyItem']['pack']);
	
				$this->PharmacyItemRate->id = $rateId;
				$this->PharmacyItemRate->save($savePharmacyItemRate);
				
				$totalRate = $this->PharmacyItemRate->find('first',array('fields'=>array('SUM(PharmacyItemRate.stock) as totalStock','SUM(PharmacyItemRate.loose_stock) as totalLooseStock'),'conditions'=>array('PharmacyItemRate.item_id'=>$productId)));
				$totalRateStock = ($totalRate[0]['totalStock'] * $pack) + $totalRate[0]['totalLooseStock'];
				
				$savePharmacyItem['stock'] = floor($totalRateStock / $pack);
				$savePharmacyItem['loose_stock'] = floor($totalRateStock % $pack);
				
				$this->PharmacyItem->id = $productId; 
				if($this->PharmacyItem->save($savePharmacyItem)){
					$this->saveStockAdjustment($this->request->data);
					echo "<strong>".$productName." updated successfully..!!</strong>";
				} 
			}
				
				
			else if(array_search(Configure::read('centralStoreCode'), $allStore) == $department){
	
				$productRateData = $this->ProductRate->find('first',array('conditions'=>array('ProductRate.id'=>$rateId,'ProductRate.product_id'=>$productId)));
					
				$saveProduct = array();
				$saveProductRate = array();
					
				if(!empty($addProductQty)){
					$saveProductRate['stock'] = $productRateData['ProductRate']['stock'] + $addProductQty;
				}
				if(!empty($substractProductQty)){
					$saveProductRate['stock'] = $productRateData['ProductRate']['stock'] - $substractProductQty;
				}
					
				$this->ProductRate->id = $rateId;
				$this->ProductRate->save($saveProductRate);
				$totalRateStock = $this->ProductRate->find('first',array('fields'=>array('SUM(ProductRate.stock) as total'),'conditions'=>array('ProductRate.product_id'=>$productId)));
					
				$saveProduct['quantity'] = $totalRateStock[0]['total'];
				$this->Product->id = $productId;
				if($this->Product->save($saveProduct)){
					$this->saveStockAdjustment($this->request->data);
					echo "<strong>".$productName." updated successfully..!!</strong>";
				}
			}
				
				
			else if(array_search(Configure::read('otpharmacycode'), $allStore) == $department){
	
				$otPharmacyRateData = $this->OtPharmacyItemRate->find('first',array('conditions'=>array('OtPharmacyItemRate.id'=>$rateId,'OtPharmacyItemRate.item_id'=>$productId)));
					
				$saveOTPharmacy = array();
				$saveOTPharmacyRate = array();
					
				if(!empty($addProductQty)){
					$saveOTPharmacyRate['stock'] = $otPharmacyRateData['OtPharmacyItemRate']['stock'] + $addProductQty;
				}
				if(!empty($substractProductQty)){
					$saveOTPharmacyRate['stock'] = $otPharmacyRateData['OtPharmacyItemRate']['stock'] - $substractProductQty;
				}
					
				$this->OtPharmacyItemRate->id = $rateId;
				$this->OtPharmacyItemRate->save($saveOTPharmacyRate);
				$totalRateStock = $this->OtPharmacyItemRate->find('first',array('fields'=>array('SUM(OtPharmacyItemRate.stock) as total'),'conditions'=>array('OtPharmacyItemRate.item_id'=>$productId)));
					
				$saveOTPharmacy['stock'] = $totalRateStock[0]['total'];
				$this->OtPharmacyItem->id = $productId;
				if($this->OtPharmacyItem->save($saveOTPharmacy)){
					$this->saveStockAdjustment($this->request->data);
					echo "<strong>".$productName." updated successfully..!!</strong>";
				}
			}
		}
	}
	//End of function
	
	//to save surplus/surminus into stock adjustment of department
	public function saveStockAdjustment($data){
		$this->uses = array('StockAdjustment');
		$this->autoRender = false;
		$data['batch_number'] = $data['batch'];
		$data['product_id'] = $data['drug_id'];
		$data['department_id'] = $data['department'];
		$data['sur_plus'] = $data['add_qty'];
		$data['sur_minus'] = $data['substract_qty'];
		$data['created_by'] = $this->Auth->user('id');
		$data['adjusted_date'] = date('Y-m-d H:i:s');
		$data['created'] = date('Y-m-d H:i:s');
		if($this->StockAdjustment->save($data)){
			return true;
		}
	}
        
    /*
     * function for inventory tracking
     * @author: Swapnil Sharma
     * @created : 16.03.2016
     */
    public function inventoryTracking(){
    	$this->set('title_for_layout',__(": Inventory Tracking"));
    	$this->uses = array('InventoryTracking','Product','InventorySupplier','StoreLocation');
    	$this->layout = "advance";  
        $pharmacyDetail = $this->StoreLocation->find('first',array('conditions'=>array("StoreLocation.code_name"=>Configure::read('pharmacyCode'))));
        $this->set('pharmacyId',$pharmacyDetail['StoreLocation']['id']);
        //Store Locations
        $storeLocation = ($this->StoreLocation->find('list',array('fields'=>array('id','name'),'conditions'=>array('allow_purchase'=>1))));
        $this->set('storeLocation',$storeLocation);
        
    	$this->InventoryTracking->bindModel(array(
    		'belongsTo'=>array(
    			'Product'=>array(
                            'foreignKey'=>'product_id',
                            'type'=>'inner'
                        ),
                        'PurchaseOrderItem'=>array(
                            'foreignKey'=>'purchase_order_item_id' 
                        ),
                        'PurchaseOrder'=>array(
                            'foreignKey'=>false,
                            'conditions'=>array(
                                'PurchaseOrderItem.purchase_order_id = PurchaseOrder.id'
                            ),
                            'type'=>'inner'
                        ), 
                        'PurchaseOrderItemAlias'=>array(
                            'foreignKey'=>'previous_purchase_order_item_id',
                            'className'=>'PurchaseOrderItem',
                            'type'=>'inner'
                        ),
                        'PurchaseOrderAlias'=>array(
                            'foreignKey'=>false,
                            'conditions'=>array(
                                'PurchaseOrderItemAlias.purchase_order_id = PurchaseOrderAlias.id'
                            ), 
                            'className'=>'PurchaseOrder',
                            'type'=>'inner'
                        ),
    			'InventorySupplier'=>array(
                            'foreignKey'=>false,
                            'conditions'=>array(
                                'PurchaseOrder.supplier_id = InventorySupplier.id'
                            ),
                            'className'=>'InventorySupplier',
                            'type'=>'inner'
                        ),
    			'InventorySupplierAlias'=>array(
                            'foreignKey'=>false,
                            'conditions'=>array(
                                'PurchaseOrderAlias.supplier_id = InventorySupplierAlias.id'
                            ),
                            'className'=>'InventorySupplier',
                            'type'=>'inner' 
                        )
                    )),false);
        $conditions = array();
        if(!empty($this->request->query)){
            if(!empty($this->request->query['order_for'])){
                $conditions['InventoryTracking.store_location_id'] = $this->request->query['order_for'];
            }
            if(!empty($this->request->query['supplier_id'])){
                $conditions[] = array('OR'=>array('InventoryTracking.previous_supplier_id'=>$this->request->query['supplier_id'],'InventoryTracking.current_supplier_id'=>$this->request->query['supplier_id']));
            }
            if(!empty($this->request->query['product_id'])){
                $conditions['InventoryTracking.product_id'] = $this->request->query['product_id'];
            }
            if(!empty($this->request->query['from']) || !empty($this->request->query['to'])){
            	$from = date("Y-m-d")." 00:00:00";
            	if(!empty($this->request->query['from'])){
                    $from = $this->DateFormat->formatDate2STDForReport($this->request->query['from'],Configure::read('date_format'))." 00:00:00"; 
            	}
            	$to = date("Y-m-d")." 23:59:59";
            	if(!empty($this->request->query['to'])){
                    $to = $this->DateFormat->formatDate2STDForReport($this->request->query['from'],Configure::read('date_format'))." 23:59:59"; 
            	}
            	$conditions['InventoryTracking.created_time between ? and ?']=array($from,$to); 
            }
        }

        if(!empty($this->request->query['generate_excel'])){
            $results = $this->InventoryTracking->find('all',array('fields'=>array(
                    'InventoryTracking.*','Product.name','InventorySupplier.name','InventorySupplierAlias.name'),
                    'conditions'=>array($conditions)));
            $this->set(compact('results'));
            $this->layout = false;
            $this->render('inventory_tracking_xls');
        }else{
            $this->paginate = array(
                'limit'=>  Configure::read('number_of_rows'),
                'fields'=>array(
                    'InventoryTracking.*','Product.name',
                    'PurchaseOrderItem.received_date, PurchaseOrderItem.quantity_received, PurchaseOrderItem.purchase_price',
                    'PurchaseOrderItemAlias.received_date, PurchaseOrderItemAlias.quantity_received, PurchaseOrderItemAlias.purchase_price', 
                    'InventorySupplier.name','InventorySupplierAlias.name'),
                    'conditions'=>array($conditions)
            );
            $results = $this->paginate('InventoryTracking');  
            $this->set(compact('results'));
        }  
    }
}