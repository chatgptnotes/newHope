<?php
/**
 * Pharmacy Controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Pharmacy.Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank jain
 */
App::import('Controller', 'Billings'); // by Swapnil G.Sharma
class PharmacyController extends AppController {

	public $name = 'Pharmacy';
	public $uses = array('PharmacyItem','InventorySupplier','InventoryPurchaseDetail','PharmacyItemRate','InventoryPurchaseItemDetail','PharmacySalesBillDetail','Bed','PharmacySalesBill','InventoryPharmacySalesReturn','InventoryPharmacySalesReturnsDetail','InventoryPurchaseReturn','InventoryPurchaseReturnItem','Ward','Room','HrDetail');
	public $components = array('RequestHandler','Email','DateFormat','Number','General');
	public $helpers = array('Html','Form', 'Js','DateFormat','Number','General','RupeesToWords','PhpExcel');

	/* to show the menu of Pharmacy*/  
        
	public function inventory_index(){

	}
	/* To show the menu of pharmacy department wise */
	public function department_store(){
		// echo "hello"; exit;
		$this->layout='advance';
		$this->redirect(array('controller'=>'store','action'=>'department_store')); //action moved ins tore controller by atul
	}

	/* pharmacy stock list*/
	public function inventory_stock_value(){
		$this->set('date', $this->DateFormat->formatDate2Local(date("y-m-d"),Configure::read('date_format')));
		if ($this->request->is('post')) {
			$result = array();
			$batch = array();
			$this->set('date', $this->request->data['date']);
			$date =  $this->DateFormat->formatDate2STD($this->request->data['date'],Configure::read('date_format'));
			$this->loadModel('InventoryOutwardDetail');
			$this->PharmacyItem->hasMany = array();
			$this->PharmacyItem->hasOne = array();
			$condition['PharmacyItem.is_deleted'] = 0;
			$condition['PharmacyItem.location_id'] = $this->Session->read('locationid') ;

			$items = $this->PharmacyItem->find("all",array('conditions' =>$condition));
			foreach($items as $key=>$value){
				$result[$value['PharmacyItem']['id']]['outward'] = 0;
				$result[$value['PharmacyItem']['id']]['id'] =$value['PharmacyItem']['id'];
				$result[$value['PharmacyItem']['id']]['name'] =$value['PharmacyItem']['name'];
				$result[$value['PharmacyItem']['id']]['code'] =$value['PharmacyItem']['item_code'];
				$result[$value['PharmacyItem']['id']]['pack'] =$value['PharmacyItem']['pack'];
				$result[$value['PharmacyItem']['id']]['manufacturer'] = $value['PharmacyItem']['manufacturer'];
				$result[$value['PharmacyItem']['id']]['current_stock'] = $value['PharmacyItem']['stock'];
				$total_stock = (double)$value['PharmacyItem']['stock'];
				$result[$value['PharmacyItem']['id']]['value'] = 0.00;
				/* check in purchase */
				$purchase_details = $this->InventoryPurchaseItemDetail->find("all",array("conditions"=>array("InventoryPurchaseItemDetail.item_id"=>$value['PharmacyItem']['id'],"InventoryPurchaseDetail.create_time <="=>$date)));

				if(count($purchase_details)>0){
					foreach($purchase_details as $purchase_key => $purchase_value){
						array_push($batch,$purchase_value['InventoryPurchaseItemDetail']['batch_no']);
						$total_stock =  $total_stock-(double)$purchase_value['InventoryPurchaseItemDetail']['qty'];
						$result[$value['PharmacyItem']['id']]['value'] = number_format($result[$value['PharmacyItem']['id']]['value']+((double)$purchase_value['InventoryPurchaseItemDetail']['qty']*(float)$purchase_value['InventoryPurchaseItemDetail']['price']),2);
					}
				}
				/* check in rate master*/
				$rate = $this->PharmacyItemRate->find("all",array("conditions"=>array("PharmacyItemRate.item_id"=>$value['PharmacyItem']['id'])));
				if(count($rate)>0){
					foreach($rate as $rate_key => $rate_value){
						if(count($batch) ==0 || !in_array($rate_value['PharmacyItemRate']['batch_number'],$batch)){
							$result[$value['PharmacyItem']['id']]['value'] = number_format($result[$value['PharmacyItem']['id']]['value']+($total_stock*(float)$rate_value['PharmacyItemRate']['purchase_price']),2);
						}

					}
				}

				/* for outward*/

				$this->InventoryOutwardDetail->bindModel(array(
						"belongsTo"=>array("InventoryOutward"=>array("foreignKey"=>'inventory_outward_id'))
				));
				$outwards = $this->InventoryOutwardDetail->find("all",array("conditions"=>array("InventoryOutwardDetail.item_id"=>$value['PharmacyItem']['id'],"InventoryOutward.create_time <="=>$date)));
				if(count($outwards)>0){
					$total_outward=0;
					foreach($outwards as $outward_key => $outward_value){
						$total_outward = (int)$total_outward+(int)$outward_value['InventoryOutwardDetail']['outward'];
					}
					$result[$value['PharmacyItem']['id']]['outward'] = $total_outward;
				}
			}
			$stock =0;
			$value =0;
			$outward =0;
			if($this->request->data['type']=="summary"){
				foreach($result as $result_key => $result_value){
					$stock = $stock+(int)$result_value['current_stock'];
					$value = $value+(float)$result_value['value'];
					$outward = $outward+(int)$result_value['outward'];
				}
				$this->set('summary', true);
				$this->set('stock', $stock);
				$this->set('value', $value);
				$this->set('outward', $outward);
				if(isset($this->request->data['print_report'])){
					$this->layout = "print_with_header";
					$this->render("inventory_print_stock_value");
				}
			}else{
				$this->layout = false;
				$this->set('result',$result);
				$this->render("inventory_print_stock_value");
			}

		}

	}
	/* pharmacy stock list*/
	public function inventory_stock_value_ajax(){
		$this->uses = array('InventoryOutward');
		$this->InventoryOutward->bindModel(array(
				"hasMany"=>array("InventoryOutwardDetail"=>array("foreignKey"=>'inventory_outward_id'))
		));

		$item = $this->PharmacyItem->read(null,$this->request->data['item_id']);
		$sales = $this->PharmacySalesBill->read("all",array("conditions"=>array("PharmacySalesBill")));

		exit;
	}
	/* pharmacy outward list*/
	public function inventory_outward_list(){
		$this->uses = array('InventoryOutward');
		$this->InventoryOutward->bindModel(array(
				"hasMany"=>array("InventoryOutwardDetail"=>array("foreignKey"=>'inventory_outward_id'))
		));
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'InventoryOutward.date' => 'asc'
						),
				'conditions' => array("InventoryOutward.location_id" =>$this->Session->read('locationid'))
						);
						$this->set('title_for_layout', __('Pharmacy Management - Outward', true));

						$data = $this->paginate('InventoryOutward');

						$this->set('data', $data);


	}
	/* pharmacy outward*/
	public function inventory_outward(){
		$this->uses = array('InventoryOutward');
		if ($this->request->is('post')) {
			$outward['InventoryOutward']['date'] = $this->DateFormat->formatDate2STD($this->request->data['date'],Configure::read('date_format'));
			$outward['InventoryOutward']['create_time'] = date('Y-m-d H:i:s');
			$outward['InventoryOutward']['created_by'] = $this->Auth->user('id');
			$outward['InventoryOutward']['location_id'] = $this->Session->read('locationid');
			$this->InventoryOutward->create();
			if($this->InventoryOutward->save($outward)){
				$result  = $this->InventoryOutward->saveOutward($this->request->data,$this->InventoryOutward->id);
				$this->Session->setFlash(__('Saved!', true));
				$this->redirect(array("controller" => "pharmacy", "action" => "inventory_outward_edit" ,$this->InventoryOutward->id,'inventory'=>true));

			}else {
				$errors = $this->InventoryOutward->invalidFields();
				$this->set("errors", $errors);
			}
		}

	}

	/* pharmacy outward edit*/
	public function inventory_outward_edit($id){
		$this->uses = array('InventoryOutward');
		$this->InventoryOutward->bindModel(array(
				"hasMany"=>array("InventoryOutwardDetail"=>array("foreignKey"=>'inventory_outward_id'))
		));

		if ($this->request->is('post')) {
			$this->request->data['date'] = $this->DateFormat->formatDate2STD($this->request->data['date'],Configure::read('date_format'));
			$outward['InventoryOutward']['id'] = $id;
			$outward['InventoryOutward']['date'] = $this->DateFormat->formatDate2STD($this->request->data['date'],Configure::read('date_format'));
			$outward['InventoryOutward']['modify_time'] = date('Y-m-d H:i:s');
			$outward['InventoryOutward']['modified_by'] = $this->Auth->user('id');
			if($this->InventoryOutward->save($outward)){
				$result  = $this->InventoryOutward->updateOutward($this->request->data);
				$result  = $this->InventoryOutward->saveOutward($this->request->data,$id);
				$this->Session->setFlash(__('Updated!', true));
				$this->redirect(array("controller" => "pharmacy", "action" => "inventory_outward_edit" ,$this->InventoryOutward->id,'inventory'=>true));

			}else {
				$errors = $this->InventoryOutward->invalidFields();
				$this->set("errors", $errors);
			}

		}
		$data = $this->InventoryOutward->read(null,$id);
		$this->set("data", $data);
	}
	/* to show the list of item*/
	public function inventory_item_list($list = null){
		$this->uses=array('Location');
		$this->PharmacyItem->hasMany = array();
		$this->PharmacyItem->hasOne = array();

		$this->PharmacyItem->bindModel(array('belongsTo'=>array(
				'PharmacyItemRate'=>array('foreignKey'=>false,
						'fields'=>array('SUM(PharmacyItemRate.stock) as total'),
						'conditions'=>array('PharmacyItemRate.item_id = PharmacyItem.id')),
				'Location'=>array('foreignKey'=>false,
						'conditions'=>array('PharmacyItem.location_id = Location.id'),
						'fields'=>array('Location.id','Location.name')))),false);
		
		 
		
		$location = $this->Location->find('list', array('fields'=> array('id', 'name'),'conditions'=>array('Location.is_active' => 1, 'Location.is_deleted' => 0)));
		$this->set('location',$location);

		$conditions['PharmacyItem.is_deleted'] =0;
		if($this->Session->read('website.instance')=='kanpur'){ //added by pankaj w as we dont need location filter for vadodara and hope
			$conditions['PharmacyItem.location_id'] =$this->Session->read('locationid');
		}

		if($list !== null){
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('PharmacyItem.name' => 'asc'),
					'conditions' => array($conditions,'PharmacyItemRate.is_deleted'=>0),
					'group' => 'PharmacyItemRate.item_id',
					'fields'=>array('SUM((PharmacyItem.pack * PharmacyItemRate.stock) + PharmacyItemRate.loose_stock) as msu','PharmacyItem.id','PharmacyItem.name','PharmacyItem.code','PharmacyItem.pack','PharmacyItem.stock','PharmacyItem.maximum','PharmacyItem.reorder_level')
					);
			
					$this->set('title_for_layout', __('Pharmacy Management - Add Item', true));
					$this->PharmacyItem->recursive = 0;
					$data = $this->paginate('PharmacyItem');
					//debug($data);
					$this->set('data', $data);
		}else
		{

			$this->set('list', "null");
		}

	}

	public function inventory_apam_item_list($list = null){
		$this->uses=array('Location');
		$this->PharmacyItem->hasMany = array();
		$this->PharmacyItem->hasOne = array();
			
		$locationId = $this->Location->getLocationIdByName(Configure::read('apamCode'));
		$this->PharmacyItem->unbindModel(array('hasOne'=>array('PharmacyItemRate')));
		$conditions['PharmacyItem.location_id'] = $locationId;
		$conditions['PharmacyItem.is_deleted'] = 0;
		if(isset($this->params->query['data'])){
			if(!empty($this->params->query['data']['name']))
			$conditions["PharmacyItem.name like"] = "%".$this->params->query['data']['name']."%";
			if(!empty($this->params->query['data']['item_code']))
			$conditions["PharmacyItem.item_code like"] = "%".$this->params->query['data']['item_code']."%";
		}
		$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array(
							'PharmacyItem.name' => 'asc'
							),
					'conditions' => $conditions
							);
								
							$this->set('title_for_layout', __('APAM Item List', true));
							$this->PharmacyItem->recursive = 0;
							$data = $this->paginate('PharmacyItem');
							$this->set('data', $data);
	}

	/* to add  item*/
	public function inventory_add_item(){

		$this->uses = array('Product','PharmacyItemRate','Configuration','VatClass');
		$this->layout ='advance';

		if($this->params->query['flag']=='1'){  //open in fancybox without header
			$this->layout ='advance_ajax'; //to include all js and css with ajax layout
			$this->set('flagForBack',1);// it include to display fancybox without back btn
		}

		$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website')));
		$websiteConfig=unserialize($website_service_type['Configuration']['value']);
		$this->set('websiteConfig',$websiteConfig);

		$this->set('title_for_layout', __('Pharmacy Management - Add New Item', true));
		if ($this->request->is('post')) {  
			$count = $this->PharmacyItem->find('count',array('conditions'=>array('PharmacyItem.name'=>trim($this->request->data['PharmacyItem']['name']))));
			if($count>0){
				$this->Session->setFlash(__('Already Exists'),'default',array('class'=>'error'));
				$this->data = $this->request->data;
				return $this->redirect($this->referer());
			}
			 
			$isProduct = $this->Product->find('first',array('conditions'=>array('Product.name'=>$this->request->data['PharmacyItem']['name'])));
			if(empty($this->request->data['PharmacyItem']['drug_id']) || $this->request->data['PharmacyItem']['drug_id'] == 0 ){
				if($isProduct['Product']['id']){
					$this->request->data['PharmacyItem']['drug_id'] = $isProduct['Product']['id'];
				}else{
					$productArray = array();
					$productArray['name'] = $this->request->data['PharmacyItem']['name'];
					$productArray['product_code'] = $this->request->data['PharmacyItem']['item_code'];
					$productArray['pack'] = $this->request->data['PharmacyItem']['pack'];
					$productArray['date'] = $this->DateFormat->formatDate2STD($this->request->data['PharmacyItem']['date'],Configure::read('date_format'));
					$productArray['manufacturer_id'] = $this->request->data['PharmacyItem']['manufacturer_company_id'];
					$productArray['maximum'] = $this->request->data['PharmacyItem']['maximum'];
					$productArray['minimum'] =  $this->request->data['PharmacyItem']['minimum'];
					$productArray['expensive_product'] =  $this->request->data['PharmacyItem']['expensive_product'];
					$productArray['batch_number'] =  $this->request->data['PharmacyItem']['batch_number'];
					$productArray['location_id'] =  $this->Session->read('locationid');
					$productArray['profit_percentage'] =  $this->request->data['PharmacyItem']['profit_percentage'];
					$productArray['is_implant'] =  $this->request->data['PharmacyItem']['is_implant'];	

					$this->Product->save($productArray);
					$this->Product->id = '';
					$this->request->data['PharmacyItem']['drug_id'] = $this->Product->getLastInsertID(); 
				} 
				
				if(!empty($this->request->data['PharmacyItem']['drug_id']))
				{
					$pharmaData['Pharmacy']['id'] = $lastInsertedId;
					$stockTotal = 0;
					$pharmaData['drug_id'] = $this->request->data['PharmacyItem']['drug_id'];
					$pharmaData['Status'] = 'A';
					$pharmaData['stock'] = $this->request->data['PharmacyItem']['stock'];
					$pharmaData['name'] = $this->request->data['PharmacyItem']['name'];
					$pharmaData['pack'] = $this->request->data['PharmacyItem']['pack'];
					$pharmaData['item_code'] = $this->request->data['PharmacyItem']['item_code'];
					$pharmaData['date'] = $this->DateFormat->formatDate2STD($this->request->data['PharmacyItem']['date'],Configure::read('date_format'));
					$pharmaData['manufacturmanufacturer_company_ider_id'] = $this->request->data['PharmacyItem']['manufacturer_company_id'];
					$pharmaData['maximum'] = $this->request->data['PharmacyItem']['maximum'];
					$pharmaData['minimum'] =  $this->request->data['PharmacyItem']['minimum'];
					$pharmaData['expensive_product'] =$this->request->data['PharmacyItem']['expensive_product'];
					$pharmaData['batch_number'] =  $this->request->data['PharmacyItem']['batch_number'];
					$pharmaData['is_implant'] =$this->request->data['PharmacyItem']['is_implant'];
					$pharmaData['location_id'] = $this->Session->read('locationid');
						
					$result = $this->PharmacyItem->save($pharmaData);
					$getLasInsertID = $this->PharmacyItem->getLastInsertId();
					
					if($result == true && !empty($this->request->data['PharmacyItemRate'][1]['batch_number'])){
						foreach($this->request->data['PharmacyItemRate'] as $key => $data){
							$saveData = $data;
							$saveData['item_id'] = $getLasInsertID;
							$saveData['location_id'] = $this->Session->read('locationid');
							$totalStock = $saveData['stock'];
							$saveData['stock'] = floor($totalStock/$this->request->data['PharmacyItem']['pack']);
							$saveData['loose_stock'] = floor($totalStock%$this->request->data['PharmacyItem']['pack']);
							$saveData['expiry_date'] = $this->DateFormat->formatDate2STD($data['expiry_date'],Configure::read('date_format'));
							$this->PharmacyItemRate->saveAll($saveData);
						}
					}
					$this->updatePharmacyItemStock($getLasInsertID);
				}
			} 
				
			$errors = $this->PharmacyItem->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				// code by mrunal to close add item window on submit btn
				if($this->params->query['flag']=='1'){
					$this->set('setFlash',1);
					$this->Session->setFlash(__('The Item has been saved', true));
				}else{
					$this->Session->setFlash(__('The Item has been saved', true));
					$this->redirect(array("controller" => "pharmacy", "action" => "item_list",'list' ,'inventory'=>true));
				}
			}
		}
	}
	
	
	
	/* to edit  item*/
	public function inventory_edit_item($id=null){
		$this->uses = array('Product','Configuration','VatClass');
		$this->layout ='advance';
		$this->set('title_for_layout', __('Pharmacy Management - Edit Item', true));

		$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website')));
		$websiteConfig=unserialize($website_service_type['Configuration']['value']);
		$this->set('websiteConfig',$websiteConfig);
		$this->set('vatData',$this->VatClass->find('list',array('conditions'=>array('VatClass.is_delete'=>'0'),'fields'=>array('id','vat_of_class'))));

		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Item ID', true));
			$this->redirect(array("controller" => "pharmacy", "action" => "item_list",'list','inventory'=>true));
		}
		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->request->data['PharmacyItem']['date'] = $this->DateFormat->formatDate2STD($this->request->data['PharmacyItem']['date'],Configure::read('date_format'));
			$this->request->data['PharmacyItem']['modify_time'] = date('Y-m-d H:i:s');
			$this->request->data['PharmacyItem']['modified_by'] = $this->Auth->user('id');
			#$this->request->data['PharmacyItem']['stock'] = $this->request->data['PharmacyItem']['stock'];
			#$this->request->data['PharmacyItem']['expensive_product'] = $this->request->data['PharmacyItem']['expensive_product'];
			#$this->request->data['PharmacyItem']['manufacturer_company_id'] = $this->request->data['PharmacyItem']['manufacturer_id'];
				
			$this->PharmacyItem->id = $id;
			$this->PharmacyItem->save($this->request->data);
			$isProductId = $this->Product->find('first',array('conditions'=>array('Product.name'=>$this->request->data['PharmacyItem']['nameHidden'])));

			/* code to update name & manufacturer of product on edit of pharmacy item  */
			if($isProductId['Product']['id']){
					
				$productArray = array();
				$productArray['id'] = $isProductId['Product']['id'];
				$productArray['name'] = $this->request->data['PharmacyItem']['name'];
					
				$productArray['manufacturer_id'] = $this->request->data['PharmacyItem']['manufacturer_id'];
				$this->Product->save($productArray);
				$this->Product->id = "";
			}
			// End of Code //
			$this->Product->id = $id;
			$this->Product->save($this->request->data);
				
			$errors = $this->PharmacyItem->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {

				$this->Session->setFlash(__('The Item has been updated', true));
				$this->redirect(array("controller" => "pharmacy", "action" => "item_list",'list','inventory'=>true));
			}
		} else {
			$this->PharmacyItem->bindModel(array('belongsTo'=>
			array('InventorySupplier'=>array('foreignKey'=>false,'conditions'=>array('InventorySupplier.id=PharmacyItem.supplier_id')),
			)));
			$this->set('data', $this->PharmacyItem->find('first',array('conditions' => array(/* "PharmacyItem.location_id" =>$this->Session->read('locationid'), */"PharmacyItem.id"=>$id))));
		}
	}

	/* to view  item*/
	public function inventory_view_item($id = null,$from=null) {
			
		if(isset($this->params->query['popup'])){
			$this->layout = false;
		}
		if(!empty($from) && $from == "fromFancy"){
			$this->layout = "advance_ajax";
		}
		$this->loadModel('VatClass');
		$this->loadModel('Configuration');

		$this->PharmacyItem->bindModel(array(
					'belongsTo'=> array(
						'InventorySupplier'=>array(
							'foreignKey'=>false,
							'conditions'=>array('InventorySupplier.id=PharmacyItem.supplier_id')),
						'VatClass'=>array(
							'forignKey'=>'vat_class_id')
		)));

		$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website')));
		$websiteConfig=unserialize($website_service_type['Configuration']['value']);
		$this->set('websiteConfig',$websiteConfig);
			
		if(isset($_POST['item_id'])){
			$pharmacyData = $this->PharmacyItem->find('first',array('conditions' => array("PharmacyItem.id"=>$this->request->data['item_id'],'PharmacyItem.item_code IS NOT NULL')));
			if(!empty($pharmacyData['PharmacyItemRate']['expiry_date']))
			$pharmacyData['PharmacyItemRate']['expiry_date'] = $this->DateFormat->formatDate2LOCAL($pharmacyData['PharmacyItemRate']['expiry_date'],Configure::read('date_format'),false);
			echo json_encode($pharmacyData);exit;

		}else{
			$this->set('title_for_layout', __('Pharmacy Management - Item Detail', true));
			if (!$id) {
				$this->Session->setFlash(__('Invalid Item ID', true));
				$this->redirect(array("controller" => "pharmacy", "action" => "item_list",'inventory'=>true));
			}
			$this->set('data', $this->PharmacyItem->find('first',array('conditions' => array("PharmacyItem.id" => $id))));
		}
	}
	/**
	 * Inventory Item delete
	 *
	 */
	public function inventory_item_delete($id = null,$loc = null) {
		$this->set('title_for_layout', __('Pharmacy Management - Delete Item ', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid ID	', true));
			$this->redirect(array("controller" => "pharmacy", "action" => "item_list",'list','inventory'=>true));
		}
		if ($id) {
			$this->PharmacyItem->deletePharmacyItem($id);
			$this->Session->setFlash(__('Item deleted', true));
			if(!empty($loc) && $loc == "apam"){
				$this->redirect(array("controller" => "pharmacy", "action" => "apam_item_list",'inventory'=>true));
			}else{
				$this->redirect(array("controller" => "pharmacy", "action" => "item_list",'list','inventory'=>true));
			}
		}
	}

	/**
	 * Purchase Item Receipt
	 *
	 */
	public function inventory_purchase_receipt() {

		$this->loadModel('User');
		$this->set('title_for_layout', __('Pharmacy Management - Purchase Receipt ', true));
		if ($this->request->is('post')) {
				
			$this->request->data['InventoryPurchaseDetail']['vr_date'] = $this->DateFormat->formatDate2STD($this->request->data['InventoryPurchaseDetail']['vr_date'],Configure::read('date_format'));
			$this->request->data['InventoryPurchaseDetail']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['InventoryPurchaseDetail']['created_by'] = $this->Auth->user('id');
			$this->request->data['InventoryPurchaseDetail']['location_id'] = $this->Session->read('locationid');
			$this->InventoryPurchaseDetail->save($this->request->data);
			$errors = $this->InventoryPurchaseDetail->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$insertDetails = $this->InventoryPurchaseItemDetail->saveDetails($this->request->data,$this->InventoryPurchaseDetail->id,$this->request->data['InventoryPurchaseDetail']['party_id']);
				$itemPrice = $this->PharmacyItemRate->insertRate($this->request->data);
				if(!$insertDetails && $itemPrice){
					$this->InventoryPurchaseDetail->delete($this->InventoryPurchaseDetail->id);
					for($i=0;$i<count($itemPrice);$i++){
						$this->PharmacyItemRate->delete($itemPrice[$i]);
					}
					$this->Session->setFlash(__('Some Fields are missing', true));
				}else if($insertDetails && !$itemPrice){
					$this->InventoryPurchaseDetail->delete($this->InventoryPurchaseDetail->id);
					$this->InventoryPurchaseDetail->delete($itemPrice);
				}else{
					$this->Session->setFlash(__('Receipt Added successfully', true));
					if($this->request->data['print']){
						$url = Router::url(array("controller" => "pharmacy", "action" => "inventory_print_view",'PurchaseReceipt',$this->InventoryPurchaseDetail->id,'inventory'=>true));

						echo "<script>window.open('".$url."','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true );window.location.href=window.location.href;</script>";
					}else{
						$this->redirect(array("controller" => "pharmacy", "action" => "get_pharmacy_details",'purchase',$this->InventoryPurchaseDetail->id,'inventory'=>true));
					}
						
				}
			}
				
				
		}


		$this->set('bill_no',"BL-".$this->PharmacySalesBill->generateRandomBillNo());
		$this->set('vr_no',"PR-".$this->PharmacySalesBill->generateRandomBillNo());
		$userName = $this->User->find('list',array('fields'=>array('id','username'),
				'conditions'=>array("User.is_guarantor" =>'1' ,"User.location_id" =>$this->Session->read('locationid'),"User.is_deleted"=>'0')));

		$this->set('userName',$userName);
	}


	/* purchase details list page*/
	public function inventory_purchase_details_list($search = null) {
		//	$this->layout = 'advance';
		$conditions['InventoryPurchaseDetail.location_id'] =$this->Session->read('locationid');
		if($search !== null){
			if($this->params->query['vr_no'] !==""){
				$conditions['InventoryPurchaseDetail.vr_no like '] = "%".$this->params->query['vr_no']."%";
			}

			if($this->params->query['date'] !==""){
				$date = $this->DateFormat->formatDate2STD($this->params->query['date'],Configure::read('date_format'));
				$date = explode(' ',$date);
				$conditions['InventoryPurchaseDetail.create_time >'] = $date[0]." 00:00:00";
				$conditions['InventoryPurchaseDetail.create_time <'] = $date[0]." 23:59:59";
			}
			if($this->params->query['supplier'] !==""){
				if($this->params->query['supplier_id'] !==""){
					$conditions['InventoryPurchaseDetail.party_id'] =$this->params->query['supplier_id'];
				}
			}
		}
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'InventoryPurchaseDetail.create_time' => 'desc'
						),
				'conditions' => $conditions
						);
						$this->set('title_for_layout', __('Purchase Details', true));
						$this->InventoryPurchaseDetail->recursive = 0;
						$data = $this->paginate('InventoryPurchaseDetail');
						$this->set('data', $data);
	}
	/* fetch expiry date for item*/
	public function inventory_fetch_batch_number_of_item(){
		$searchKey = $this->params->query['q'];
		$filedOrder = array('batch_no','expiry_date');
		$conditions["batch_no like"] = $searchKey."%";

		$itemId = $this->params->query['itemId'];
		$conditions["InventoryPurchaseItemDetail.item_id"] =$itemId;


		$batchnumbers = $this->InventoryPurchaseItemDetail->find('list',array('fields'=> $filedOrder,'conditions'=>$conditions));
		$batchnumbers_from_rate = $this->PharmacyItemRate->find('list',array('fields'=> array("batch_number","expiry_date"),'conditions'=>array("PharmacyItemRate.batch_number like"=> $searchKey."%", "PharmacyItemRate.item_id"=>$itemId)));
		$output ='';

		foreach ($batchnumbers as $key=>$value) {
			if(!in_array($value,$batchnumbers_from_rate)){
				$value = $this->DateFormat->formatDate2Local($value,Configure::read('date_format'));
				$output .= $key."|". $value."\n";
			}
		}

		foreach ($batchnumbers_from_rate as $key=>$value) {

			$value = $this->DateFormat->formatDate2Local($value,Configure::read('date_format'));
			$output .= $key."|". $value."\n";

		}
		echo $output;
		exit;//dont remove this

	}
	/* fetch expiry date for item*/
	public function inventory_fetch_batch_number_of_item_for_sale(){


		/*$searchKey = $this->params->query['q'];
		 $filedOrder = array('item_id','batch_number','expiry_date');
		 $conditions["batch_number like"] = $searchKey."%";
		 $itemId = $this->params->query['itemId'];
		 $conditions["PharmacyItemRate.item_id"] =$itemId;
		 $batchnumbers = $this->PharmacyItemRate->find('all',array('fields'=> $filedOrder,'conditions'=>$conditions));
		 foreach ($batchnumbers as $key=>$value) {
			$output ='';
			// $expirydate = $this->InventoryPurchaseItemDetail->find('first',array('conditions'=>array("InventoryPurchaseItemDetail.batch_no"=>$value,"InventoryPurchaseItemDetail.item_id"=>$itemId)));


			$k = date("d-m-Y",strtotime($value['PharmacyItemRate']['expiry_date']));
			$output .= $value['PharmacyItemRate']['batch_number']."|".$k;
			$output .= "\n";


			echo $output;
			}*/
		exit;//dont remove this

	}
	/**
	 * supplier list
	 *
	 */
	public function inventory_supplier_list() {
		$this->set('title_for_layout', __('Pharmacy Management - Supplier List ', true));
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'InventorySupplier.name' => 'asc'
						),
				'conditions' => array('InventorySupplier.is_deleted' => 0,"InventorySupplier.location_id" =>$this->Session->read('locationid'))
						);


						$data = $this->paginate('InventorySupplier');
						$this->set('data', $data);

	}

	/* fetch transaction supplier*/
	public function inventory_fetch_transaction(){
		$this->layout = false;
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'InventorySupplier.name' => 'asc'
						),
				'conditions' => array('InventorySupplier.is_deleted' => 0,"InventorySupplier.location_id" =>$this->Session->read('locationid'))
						);

						$this->InventorySupplier->recursive = 0;
						$data = $this->paginate('InventorySupplier');

						$this->set('data', $data);

	}
	/* fetch transaction supplier*/
	public function inventory_view_transaction($supplier_id){
		$supplier = $this->InventorySupplier->find('first',
		array('conditions' => array('InventorySupplier.id' => $supplier_id,"InventorySupplier.location_id" =>$this->Session->read('locationid'))));
		$this->layout = false;
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'InventoryPurchaseDetail.create_time' => 'asc'
						),
				'conditions' => array('InventoryPurchaseDetail.party_id' => $supplier_id,"InventoryPurchaseDetail.location_id" =>$this->Session->read('locationid'))
						);

						$this->InventoryPurchaseDetail->recursive = 0;
						$data = $this->paginate('InventoryPurchaseDetail');
						$this->set('data', $data);
						$this->set('supplier', $supplier);

	}
	/* to view  Supplier*/
	public function inventory_view_supplier($id = null, $isAjax=null) {
		$this->InventorySupplier->unbindModel(array('hasMany' => array('InventoryPurchaseDetail','PharmacyItem')),false);
		$this->set('title_for_layout', __('Pharmacy Management - Supplier Detail', true));
		if (!$id && !$this->request->is('post')) {
			$this->Session->setFlash(__('Invalid Supplier', true));
			$this->redirect(array("controller" => "pharmacy", "action" => "supplier_list",'inventory'=>true));
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
	 * Add Supplier
	 *
	 */
	public function inventory_add_supplier() {

		if($this->params->query['flag']=='1'){  //open in fancybox without header
			$this->layout ='advance_ajax'; //to include all js and css with ajax layout
			$this->set('flagForBack',1);// it include to display fancybox without back btn
		}
		$this->set('title_for_layout', __('Pharmacy Management - Add New Supplier', true));


		if ($this->request->is('post')) {
			$this->request->data['InventorySupplier']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['InventorySupplier']['created_by'] = $this->Auth->user('id');
			$this->request->data['InventorySupplier']['location_id'] = $this->Session->read('locationid');
			//$this->request->data['InventorySupplier']['code'] = "SC".$this->PharmacySalesBill->generateRandomBillNo();
				
			$this->InventorySupplier->create();
				
			$this->InventorySupplier->save($this->request->data);
			$last_user = $this->InventorySupplier->getInsertId();
			if(!empty($this->request->data['HrDetail'])){
				$this->request->data['HrDetail']['user_id']=$last_user;
				$this->request->data['HrDetail']['type_of_user']=Configure::read('inventorySupplierUser');					
				$this->HrDetail->saveData($this->request->data);
			}
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
			$this->set('group',$this->AccountingGroup->getAllGroup());
			$this->set('groupId',$this->AccountingGroup->getAccountingGroupID(Configure::read('sundry_creditors')));
			$this->set('code',$code);
		}

	}
	/* serach*/
	public function inventory_search($model = null){
		
		$this->uses=array('Location');  
		$this->PharmacyItem->unbindModel(array('belongsTo'=>array('PharmacyItemRate'))); 
		$this->PharmacyItem->bindModel(array('belongsTo'=>array('Location'=>array('foreignKey'=>false,'conditions'=>array('PharmacyItem.location_id = Location.id'),
				'fields'=>array('Location.id','Location.name')))),false);
		$location = $this->Location->find('list', array('fields'=> array('id', 'name'),'conditions'=>array('Location.is_active' => 1, 'Location.is_deleted' => 0)));
		$this->set('location',$location);
		$group = array();
		if($model == "InventorySupplier"){ 
			$this->loadModel('InventorySupplier');
			$this->set('title_for_layout', __('Pharmacy Management - Search Supplier', true)); 
			if(isset($this->params->query['data'])){
				if(!empty($this->params->query['data']['name']))
				$conditions["InventorySupplier.name LIKE"] = "%".$this->params->query['data']['name']."%";
				if(!empty($this->params->query['data']['code']))
				$conditions["InventorySupplier.code LIKE"] = "%".$this->params->query['data']['code']."%";
			} 
			$conditions['InventorySupplier.is_deleted'] = 0;
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'conditions' =>  $conditions,
					'group' => $group,
					'fields' => $fields
			);
			$data = $this->paginate('InventorySupplier');
			$this->set('model', 'InventorySupplier');
			$this->set('data', $data);
			$view = "inventory_search";
		}else if($model == "PharmacyItem"){
			$this->loadModel('PharmacyItem');
			$this->set('title_for_layout', __('Pharmacy Management - Search Item', true));
		    $this->$model->unbindModel(array('belongsTo'=>array('PharmacyItemRate'))); 
			if(isset($this->params->query['data'])){
				if(!empty($this->params->query['data']['name']))
				$conditions["PharmacyItem.name like"] = "%".$this->params->query['data']['name']."%";
				if(!empty($this->params->query['data']['item_code']))
				$conditions["PharmacyItem.item_code like"] = "%".$this->params->query['data']['item_code']."%";
				if(!empty($this->params->query['data']['generic_name']))
					$conditions["PharmacyItem.generic like"] = "%".$this->params->query['data']['generic_name']."%";
				if(!empty($this->params->query['location_id']))
				$conditions["PharmacyItem.location_id"] = $this->params->query['location_id'];
				$conditions['PharmacyItemRate.is_deleted'] = 0;
				//$group = $model.".id";
				$fields = array("PharmacyItem.*",'SUM(PharmacyItemRate.stock) as stock','SUM(PharmacyItemRate.loose_stock) as loose_stock');
				$group = "PharmacyItemRate.item_id";
			}
			$conditions['PharmacyItem.is_deleted'] = 0;
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'conditions' =>  $conditions,
					'group' => $group,
					'fields' => $fields
			);
			$data = $this->paginate('PharmacyItem');
			$view = "inventory_item_search";
			$this->set('model', 'PharmacyItem');
			$this->set('data', $data);
		}  
		$this->render($view);

	}
	/**
	 * Edit Supplier
	 *
	 */
	public function inventory_edit_supplier($id = null) {
		$this->set('title_for_layout', __('Pharmacy Management - Edit Supplier', true));
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Supplier ID', true));
			$this->redirect(array("controller" => "pharmacy", "action" => "supplier_list",'inventory'=>true));
		}
		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->request->data['InventorySupplier']['modify_time'] = date('Y-m-d H:i:s');
			$this->request->data['InventorySupplier']['modified_by'] = $this->Auth->user('id');
			$this->request->data['InventorySupplier']['id']=$id;
			$this->request->data['InventorySupplier']['location_id']=$this->Session->read('locationid');
			$this->InventorySupplier->id = $id;
			$this->InventorySupplier->save($this->request->data);
			if(!empty($this->request->data['HrDetail']) && !empty($id)){				
				$this->request->data['HrDetail']['user_id']=$id;
				$this->request->data['HrDetail']['type_of_user']=Configure::read('inventorySupplierUser');					
				$this->HrDetail->saveData($this->request->data);
			}
			$errors = $this->InventorySupplier->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('Supplier has been updated', true));
				$this->redirect(array("controller" => "pharmacy", "action" => "supplier_list",'inventory'=>true));
			}
		} else {
			$this->set('data',$this->InventorySupplier->read(null, $id,array('conditions' => array("InventorySupplier.location_id" =>$this->Session->read('locationid')))));
			$this->uses=array('AccountingGroup','HrDetail');
			$this->set('group',$this->AccountingGroup->getAllGroup());
			$this->set('groupId',$this->AccountingGroup->getAccountingGroupID(Configure::read('sundry_creditors')));
			//BOF-Mahalaxmi for Fetch the hrdetails
			$this->set('hrDetails',$this->HrDetail->findFirstHrDetails($id,Configure::read('inventorySupplierUser')));
			//EOF-Mahalaxmi for Fetch the hrdetails
		}
	}

	/**
	 * Inventory Supplier delete
	 *
	 */
	public function inventory_supplier_delete($id = null) {
		$this->set('title_for_layout', __('Pharmacy Management - Delete Supplier ', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid ID	', true));
			$this->redirect(array("controller" => "pharmacy", "action" => "supplier_list",'inventory'=>true));
		}
		if ($id) {
			$this->InventorySupplier->deleteInventorySupplierItem($id);
			$this->Session->setFlash(__('Supplier deleted', true));
			$this->redirect(array("controller" => "pharmacy", "action" => "supplier_list",'inventory'=>true));
		}
	}
	/**
	 * Inventory Sale bill
	 * @requisitionType OT or normal medicine prescription
	 */
	public function inventory_sales_bill($patient_id = null,$requisitionType=null,$billId=null,$batchId=null) {

		
		$this->set('title_for_layout', __('Pharmacy Management - Sales Bill ', true));
		$this->loadModel('Patient');
		$this->loadModel('NewCropPrescription');
		$this->loadModel('User');
		$this->loadModel('AccountReceipt');
		$this->loadModel('Account');
		$this->loadModel('VoucherLog');
		$this->loadModel('VoucherEntry');
		$this->loadModel('TariffStandard');
		$this->loadModel('DoctorProfile');
                $this->loadModel('PharmacySalesBill');
                $this->loadModel('PharmacySalesBillDetail');
                
		$this->layout = "advance";

		//mode of payment by Swapnil G.Sharma
		/* For Kanpur
		 * LocationId's and their Locations
		 * 1  - Clinic
		 * 25 - Roman Pharma
		 * 22 - Hospital
		 * 26 - Roman Pharma Ext
		 */

		$this->loadModel("Configuration");
		$configPharmacy = $this->Configuration->getPharmacyServiceType();
		$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website')));
		$websiteConfig=unserialize($website_service_type['Configuration']['value']);
		if($websiteConfig['instance']=='kanpur'){
			if($this->Session->read('locationid') == 1 || $this->Session->read('locationid') == 25){
				$mode_of_payment = array('Cash'=>'Cash');
			}else if($this->Session->read('locationid') == 22 || $this->Session->read('locationid') == 26){
				$mode_of_payment = array('Credit'=>'Credit','Cash'=>'Cash');
			}
		}else {
			$mode_of_payment = array('Credit'=>'Credit');
			if($configPharmacy['cashCounter']=="yes"){
				$mode_of_payment = array_merge($mode_of_payment,array('Cash'=>'Cash'));
			}
		}
		
		$mode_of_payment = array('Credit'=>'Credit','Cash'=>'Cash');
		$privateId = $this->TariffStandard->getTariffStandardID( 'privateTariffName');

		$this->set(compact(array('mode_of_payment','websiteConfig','privateId')));
		
		$this->Patient->bindModel(array(
				'belongsTo' => array(
                                        'DoctorProfile' =>array('foreignKey'=>false, 'conditions'=>array('DoctorProfile.user_id=Patient.doctor_id' )),
                                    'TariffStandard' =>array('foreignKey'=>false, 'conditions'=>array('Patient.tariff_standard_id=TariffStandard.id' ))
				)),false);
		
		/* $this->Patient->bindModel(array(
				'hasOne' => array(
						'User' => array('foreignKey' =>false, 'conditions'=>array('User.id = Patient.doctor_id')),

		)),false); */

		if($patient_id != null){
			$patient = $this->Patient->find('first', array('conditions'=>array("Patient.id"=>$patient_id))); 
			$this->set("patient",$patient);
		} 
		
		if($requisitionType=='editDirectView' && !empty($this->request->data)){
			$this->PharmacySalesBill->unBindModel(array('belongsTo'=>array('Patient','Doctor','Initial')));
				
			$pharmacySales = $this->PharmacySalesBill->find('first',array(
								'conditions'=>array('PharmacySalesBill.id'=>$patient_id),
								'fields'=>array('PharmacySalesBill.*')));	

			foreach($pharmacySales['PharmacySalesBillDetail'] as $value){
				$item = $this->PharmacyItem->find('first',array('conditions' =>
				array("PharmacyItem.id"=>$value['item_id'],"PharmacyItem.location_id" => $this->Session->read('locationid'))));

				$itemRate = $this->PharmacyItemRate->find('first',array('conditions' =>
				array("PharmacyItemRate.item_id"=>$value['item_id'],"PharmacyItemRate.batch_number" =>$value['batch_number'])));
					
				$item['PharmacyItem']['stock']=$item['PharmacyItem']['stock']+$value['qty'];
				$itemRate['PharmacyItemRate']['stock']=$itemRate['PharmacyItemRate']['stock']+$value['qty'];
				$this->PharmacyItem->save($item);
				$this->PharmacyItemRate->save($itemRate);
			}
				
			//$this->PharmacySalesBillDetail->deleteAll(array('PharmacySalesBillDetail.pharmacy_sales_bill_id' => $pharmacySales['PharmacySalesBill']['id']));
				
			$sales['PharmacySalesBill']['id']=$patient_id;
			$sales['PharmacySalesBill']['patient_id']=$pharmacySales['PharmacySalesBill']['patient_id'];
			$sales['PharmacySalesBill']['customer_name']=$this->request->data['party_name'];
			$sales['PharmacySalesBill']['tax']=$this->request->data['PharmacySalesBill']['tax'];
			$sales['PharmacySalesBill']['total']=$this->request->data['PharmacySalesBill']['total'];
			$sales['PharmacySalesBill']['payment_mode']=$pharmacySales['PharmacySalesBill']['payment_mode'];
			$sales['PharmacySalesBill']['credit_period']=$this->request->data['PharmacySalesBill']['credit_period'];
			$sales['PharmacySalesBill']['guarantor_id']=$this->request->data['PharmacySalesBill']['guarantor_id'];
			$sales['PharmacySalesBill']['modified_time'] = $this->DateFormat->formatDate2STD($this->request->data['sale_date'],Configure::read('date_format'));
			$sales['PharmacySalesBill']['create_time']=$pharmacySales['PharmacySalesBill']['create_time'];
			
			$this->PharmacySalesBill->save($sales);
			if(empty($sales['PharmacySalesBill']['modified_time'])){
				$this->PharmacySalesBillDetail->saveBillDetails($this->request->data,$patient_id);
			}
			$this->Session->setFlash(__('The Sales Bill has been saved', true));
				
			if(isset($this->request->data['notInItemRate'])){
				$data = array();
				for($i=0;$i<count($this->request->data['notInItemRate']['mrp']);$i++){
					$data['PharmacyItemRate'][$i]['sale_price'] = $this->request->data['rate'][$i];
					$data['PharmacyItemRate'][$i]['mrp'] = $this->request->data['mrp'][$i];
					$data['PharmacyItemRate'][$i]['item_id'] = $this->request->data['notInItemRate']['mrp'][$i+1];
				}
				$this->PharmacyItemRate->saveAll($data['PharmacyItemRate']);
			}
			$get_last_insertID = $pharmacySales['PharmacySalesBill']['id'];
			if(isset($this->request->data['redirect_to_billing'])){
				/*$url = Router::url(array("controller" => "Billings", "action" => "patient_information",$patient['Patient']['id'],"pharmacy-section",'inventory'=>false));
				 echo "<script>window.location.href='".$url."';</script>";*/
				$this->redirect(array("controller" => "pharmacy", "action" => "get_other_pharmacy_details",'sales' ,'inventory'=>true));
			}else if($this->request->data['print']){
				$url = Router::url(array("controller" => "pharmacy", "action" => "inventory_print_view",'PharmacySalesBill',$this->PharmacySalesBill->id,'inventory'=>true));
				echo "<script>window.open('".$url."','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true )</script>";
			}else{
				$this->redirect(array("controller" => "pharmacy", "action" => "get_other_pharmacy_details",'sales','?'=>array('print'=>'print','id'=>$get_last_insertID,$status), 'inventory'=>true));

			}

		}else if($requisitionType=='edit' && !empty($this->request->data)){
			
			//debug($patient_id);debug($requisitionType);debug($billId);debug($batchId);exit;
			$this->PharmacySalesBill->bindModel(array(
						'belongsTo' => array(
								'User' =>array('foreignKey' => 'guarantor_id'),array('conditions'=>array('PharmacySalesBill.guarantor_id=User.id')),
								'DoctorProfile' =>array('foreignKey' => false),array('conditions' => array('PharmacySalesBill.doctor_id = DoctorProfile.user_id')))

			),false);

			$pharmacySales = $this->PharmacySalesBill->find('first',array('conditions'=>
			array('PharmacySalesBill.id'=>$billId,"PharmacySalesBill.location_id" =>$this->Session->read('locationid'),'PharmacySalesBill.is_deleted' =>'0'),
						'fields'=>array('User.username','PharmacySalesBill.*','Patient.*','DoctorProfile.doctor_name')));


			$deletedItems = explode("_", $this->request->data['deleted_id']);
			
			/**********For restoring stock quantity of previous product*******************************/
			foreach($pharmacySales['PharmacySalesBillDetail'] as $value){
				$item = $this->PharmacyItem->find('first',array('conditions' =>
				array("PharmacyItem.id"=>$value['item_id'],"PharmacyItem.location_id" => $this->Session->read('locationid'))));

				$itemRate = $this->PharmacyItemRate->find('first',array('conditions' =>
				array("PharmacyItemRate.item_id"=>$value['item_id'],"PharmacyItemRate.batch_number" =>$value['batch_number'])));
					
				/* Tab vise calculation of stock to get loose quantity */
					
				if($value['qty_type']=="Tab"){
					$editQty = $value['qty'];
				}else{
					$editQty = (int)$value['pack']* $value['qty'];
				}		
				
			}

			$this->PharmacySalesBillDetail->deleteAll(array('PharmacySalesBillDetail.pharmacy_sales_bill_id'=>$billId,'PharmacySalesBillDetail.item_id'=>$deletedItems));

			/**************EOF restoring***********************************************************/
			/******************** Deleteing the previous records of sales bill********************************/

			//$this->PharmacySalesBillDetail->deleteAll(array('PharmacySalesBillDetail.pharmacy_sales_bill_id' => $pharmacySales['PharmacySalesBill']['id']));

			/******************** EOF Deleteing***************************************************************/
			/***************************** Updating the record of the sales bill********************************/

			$sales['PharmacySalesBill']['id']=$billId;
			$sales['PharmacySalesBill']['patient_id']=$pharmacySales['PharmacySalesBill']['patient_id'];
			$sales['PharmacySalesBill']['customer_name']=$this->request->data['party_name'];
			$sales['PharmacySalesBill']['tax']=$this->request->data['PharmacySalesBill']['tax'];
			$sales['PharmacySalesBill']['vat']=$this->request->data['PharmacySalesBill']['vat'];
			$sales['PharmacySalesBill']['total']=$this->request->data['PharmacySalesBill']['total'];
			$sales['PharmacySalesBill']['payment_mode']=$pharmacySales['PharmacySalesBill']['payment_mode'];
			$sales['PharmacySalesBill']['credit_period']=$this->request->data['PharmacySalesBill']['credit_period'];
			$sales['PharmacySalesBill']['guarantor_id']=$this->request->data['PharmacySalesBill']['guarantor_id'];
			$sales['PharmacySalesBill']['create_time'] = $this->DateFormat->formatDate2STD($this->request->data['sale_date'],Configure::read('date_format'));
			//$sales['PharmacySalesBill']['create_time'] = $pharmacySales['PharmacySalesBill']['create_time'];
			
			$this->PharmacySalesBill->save($sales);
			$this->PharmacySalesBill->id = "";

			/******************************* EOF updation*********************************************************/

			/************* again inserting the data in sales bill details agaist the sales bill**************/
			
			if(empty($sales['PharmacySalesBill']['modified_time'])){
				//$this->PharmacySalesBillDetail->saveBillDetails($this->request->data,$billId);
			}

			$this->Session->setFlash(__('The Sales Bill has been saved', true));
			if(isset($this->request->data['notInItemRate'])){
				$data = array();
				for($i=0;$i<count($this->request->data['notInItemRate']['mrp']);$i++){
					$data['PharmacyItemRate'][$i]['sale_price'] = $this->request->data['rate'][$i];
					$data['PharmacyItemRate'][$i]['mrp'] = $this->request->data['mrp'][$i];
					$data['PharmacyItemRate'][$i]['item_id'] = $this->request->data['notInItemRate']['mrp'][$i+1];
				}
				$this->PharmacyItemRate->saveAll($data['PharmacyItemRate']);
			}
			$get_last_insertID = $pharmacySales['PharmacySalesBill']['id'];
			if(isset($this->request->data['redirect_to_billing'])){
				$this->redirect(array("controller" => "pharmacy", "action" => "pharmacy_details",'sales' ,'inventory'=>true));
			}else if($this->request->data['print']){
				$url = Router::url(array("controller" => "pharmacy", "action" => "inventory_print_view",'PharmacySalesBill',$this->PharmacySalesBill->id,'inventory'=>true));
				echo "<script>window.open('".$url."','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true )</script>";
			}else{
				$this->redirect(array("controller" => "pharmacy", "action" => "pharmacy_details",'sales','?'=>array('print'=>'print','id'=>$get_last_insertID,$status), 'inventory'=>true));

			}


		}else if($requisitionType=='copy' && !empty($this->request->data)){

			if(!isset($this->request->data['item_id'])){
				$this->Session->setFlash(__('Item must be selected'), true,array('class'=>'error'));
			}else{ 
				$this->Patient->bindModel(array(
						'belongsTo' => array(
								'DoctorProfile' =>array('foreignKey'=>false, 'conditions'=>array('DoctorProfile.user_id=Patient.doctor_id' ))
						)));
				if(trim($this->request->data['party_code'])!=""){
					$patient = $this->Patient->find('first', array('conditions'=>array("Patient.admission_id"=>$this->request->data['party_code'])));
					$patientId = $patient['Patient']['id'];
					$this->request->data['PharmacySalesBill']['patient_id']  = $patientId;
				}else{
					$this->request->data['PharmacySalesBill']['customer_name']  = $this->request->data['party_name'];
				}

				if(!empty($this->request->data['sale_date'])){
					$saleDate = $this->DateFormat->formatDate2STD($this->request->data['sale_date'],Configure::read('date_format'));
				}
				if($this->request->data['PharmacySalesBill']['payment_mode'] == "Cash"){
					$this->request->data['PharmacySalesBill']['modified_time'] = $saleDate?$saleDate:date('Y-m-d H:i:s');
				}
				//for coupon/privilege card Discount -swatin
				
				$this->loadModel('ServiceCategory');
				$this->loadModel('Coupon');
				
				$patientData = $this->Patient->find('first', array('conditions'=>array("Patient.id"=>$this->request->data['PharmacySalesBill']['patient_id']),'fields'=>array('coupon_name')));
				$PharmacyGroupId = $this->ServiceCategory->getPharmacyId();
				
				if(!empty($patientData['Patient']['coupon_name'])){
					$couponDetails  = $this->Coupon->find('first',array('conditions'=>array('Coupon.batch_name'=>$patientData['Patient']['coupon_name']),'fields'=>array('id','batch_name','sevices_available','coupon_amount')));
					$sevicesAvailable = explode(',',$couponDetails['Coupon']['sevices_available']);
					$couponAMT = unserialize($couponDetails['Coupon']['coupon_amount']);
					if(in_array($PharmacyGroupId, $sevicesAvailable)){
						$discAmt=0;
						$totalPayment = $this->request->data['PharmacySalesBill']['total'];
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
				 	$this->request->data['PharmacySalesBill']['discount']=$this->request->data['PharmacySalesBill']['discount']+$discAmt;
				}
				/* end of discount code*/
				$this->request->data['PharmacySalesBill']['create_time'] = $saleDate?$saleDate:date('Y-m-d H:i:s');
				$this->request->data['PharmacySalesBill']['created_by'] = $this->Auth->user('id');
				$this->request->data['PharmacySalesBill']['location_id'] = $this->Session->read('locationid');
				if($this->Session->read('locationid')==25 || $this->Session->read('locationid')==26 ){
			    $this->request->data['PharmacySalesBill']['bill_code']  = $this->PharmacySalesBill->generateSalesBillNoForKanpur($this->Session->read('locationid'));
				}else{
				$this->request->data['PharmacySalesBill']['bill_code']  = $this->PharmacySalesBill->generateSalesBillNo();
				}
				$this->request->data['PharmacySalesBill']['itemType'] = $this->request->data['PharmacySalesBill']['item_type'];
				$this->request->data['PharmacySalesBill']['discount'] = round($this->request->data['PharmacySalesBill']['discount']);			

				if($this->request->data['PharmacySalesBill']['payment_mode'] == "Cash"){
					$this->request->data['PharmacySalesBill']['paid_amnt'] = round($this->request->data['PharmacySalesBill']['total'] - ($this->request->data['PharmacySalesBill']['discount'])); //by swapnil 20.02.2015
				}
				//debug($this->request->data);exit;
				$this->PharmacySalesBill->create();
				$this->PharmacySalesBill->save($this->request->data); 
				$lastInsertedIdOfSalesBill = $this->PharmacySalesBill->getLastInsertId();
				//$lastInsertedIdOfSalesBill = 2;
				/* End of code */

				/***** for Nurse Prescription -by Mrunal ***********/ 
				if($requisitionType == "nurse"){ 
					//function to insert,update newcropprescription data for nursing prescription
					$this->updateNursingData($this->request->data,$patient_id,$batchId,$lastInsertedIdOfSalesBill); 
				}
				//**** END OF CODE ****//
					
				/** function to check sales bill is done for nursepriscription or not by Mrunal*/
				/* if($requisitionType == "nurse"){
					$this->checkSalesBillIsDone($patient_id,$batchId);
				} */
				
				/** END of NursePrescription */
				//save in billing if payment is cash by Swapnil G.Sharma
				if($this->request->data['PharmacySalesBill']['payment_mode'] == "Cash"){
					//debug($this->request->data); exit;
					$this->loadModel('Billing');
					$this->loadModel('ServiceCategory');
					$payment_category = $this->ServiceCategory->getPharmacyId();
					$billingData = array();
					$billingData['date']=date("Y-m-d H:i:s");
					$billingData['patient_id']=$patientId;
					$billingData['payment_category']=$payment_category;
					$billingData['location_id']=$this->Session->read('locationid');
					$billingData['created_by']=$this->Session->read('userid');
					$billingData['create_time']=date("Y-m-d H:i:s");
					$billingData['mode_of_payment']=$this->request->data['PharmacySalesBill']['payment_mode'];
					$billingData['total_amount']=round($this->request->data['PharmacySalesBill']['total']);
					$billingData['amount']=round($this->request->data['PharmacySalesBill']['total'] - $this->request->data['PharmacySalesBill']['discount']);
					$billingData['pharmacy_sales_bill_id'] = $lastInsertedIdOfSalesBill;
						
					if($this->request->data['PharmacySalesBill']['is_discount']==1){
						$billingData['discount_type']=$this->request->data['PharmacySalesBill']['discount_type'];
						if($billingData['discount_type'] == "Percentage"){
							$billingData['discount_percentage'] = round($this->request->data['PharmacySalesBill']['input_discount']);
						}else
						if($billingData['discount_type'] == "Amount"){
							$billingData['discount_amount'] = round($this->request->data['PharmacySalesBill']['discount']);
						}
					}
					$billingData['discount'] = round($this->request->data['PharmacySalesBill']['discount']);
					$billingData['is_card'] = $this->request->data['PharmacySalesBill']['is_card'];
					$billingData['patient_card'] = $this->request->data['PharmacySalesBill']['patient_card'];
					$this->Billing->save($billingData);
					$lastNotesId = $this->Billing->getLastInsertID();
					$billNo= $this->Billing->generateBillNoPerPay($patientId,$lastNotesId);
					$updateBillingArray=array('Billing.bill_number'=>"'$billNo'");
					$this->Billing->updateAll($updateBillingArray,array('Billing.patient_id'=>$patientId,'Billing.id'=>$lastNotesId));
					//for accounting
						$billingDataDetails['Billing'] = $billingData;
						$this->Billing->addPartialPaymentJV($billingDataDetails,$patientId);
					//EOF a/c by amit jain
					$this->PharmacySalesBill->id = $lastInsertedIdOfSalesBill;
					$updateBillId['billing_id'] = $lastNotesId;
					$this->PharmacySalesBill->save($updateBillId);
					//$this->PharmacySalesBill->id = "";
				}
				
				/** billing credit entry for discount -- Gaurav Chauriya */
				elseif($this->request->data['PharmacySalesBill']['payment_mode'] == "Credit" && isset($this->request->data['PharmacySalesBill']['discount'])){	//updated by Swapnil (iff discount on sales bill) 26.03.2015
					$this->loadModel('Billing');
					$this->loadModel('ServiceCategory');
					$payment_category = $this->ServiceCategory->getPharmacyId();
					$billingData = array();
					$billingData['date']=date("Y-m-d H:i:s");
					$billingData['patient_id'] = $patientId;
					$billingData['payment_category'] = $payment_category;
					$billingData['location_id']=$this->Session->read('locationid');
					$billingData['created_by']=$this->Session->read('userid');
					$billingData['create_time']=date("Y-m-d H:i:s");
					$billingData['mode_of_payment']=$this->request->data['PharmacySalesBill']['payment_mode'];
					$billingData['total_amount'] = round($this->request->data['PharmacySalesBill']['total']) - $this->request->data['PharmacySalesBill']['discount'] ;
					$billingData['amount']= '0';
					$billingData['pharmacy_sales_bill_id'] = $lastInsertedIdOfSalesBill;
					
					if($this->request->data['PharmacySalesBill']['is_discount']==1){
						$billingData['discount_type'] = $this->request->data['PharmacySalesBill']['discount_type'];
						if($billingData['discount_type'] == "Percentage"){
							$billingData['discount_percentage'] = round($this->request->data['PharmacySalesBill']['input_discount']);
						}else
							if($billingData['discount_type'] == "Amount"){
							$billingData['discount_amount'] = round($this->request->data['PharmacySalesBill']['discount']);
						}
					}
					$billingData['discount'] = round($this->request->data['PharmacySalesBill']['discount']);
					$billingData['is_card'] = $this->request->data['PharmacySalesBill']['is_card'];
					$billingData['patient_card'] = $this->request->data['PharmacySalesBill']['patient_card'];
					$this->Billing->save($billingData);
					
					$lastNotesId=$this->Billing->getLastInsertID();
					$billNo= $this->Billing->generateBillNoPerPay($patientId,$lastNotesId);
					$updateBillingArray=array('Billing.bill_number'=>"'$billNo'");
					$this->Billing->updateAll($updateBillingArray,array('Billing.patient_id'=>$patientId,'Billing.id'=>$lastNotesId));
					//for accounting
						$accountData = array();
						$accountData['date']=date("Y-m-d H:i:s");
						$accountData['discount'] = round($this->request->data['PharmacySalesBill']['discount']);
						$billingDataDetails['Billing']=$accountData;
						$this->Billing->addPartialPaymentJV($billingDataDetails,$patientId);
					//EOF a/c by amit jain
					$this->PharmacySalesBill->id = $lastInsertedIdOfSalesBill;
					$updateBillId['billing_id'] = $lastNotesId;
					$this->PharmacySalesBill->save($updateBillId);
				}
				
				/* patient card code For vadodara and hope instance -Pooja Gupta*/
				if($this->Session->read('website.instance')!='kanpur'){
					if(!empty($this->request->data['PharmacySalesBill']['is_card']) &&
					!empty($this->request->data['PharmacySalesBill']['patient_card'])){

						$this->loadModel('PatientCard');
						if(empty($lastNotesId)){
							$billId=$lastInsertedIdOfSalesBill;
							$type='Payment';
						}else{
							$billId=$lastNotesId;
							$type='Payment';
						}
						$this->PatientCard->insertIntoCard($this->request->data['PharmacySalesBill']['patient_card'],
						$patient['Patient']['person_id'],$billId,$type);
					}
				}
				/* EOF patient card*/
				$errors = $this->PharmacySalesBill->invalidFields();
				
				if(!empty($errors)) {
					$this->set("errors", $errors);
				} else {;
					$nurse = false;
					if($requisitionType == nurse){
						$nurse = true;
						
					}
                                    $updateSaleBill = $this->PharmacySalesBillDetail->saveBillDetails($this->request->data,$this->PharmacySalesBill->id,$nurse);
                                    
                                    if(!empty($updateSaleBill)){ 
                                        
                                            $this->PharmacySalesBill->save($updateSaleBill); //update total & discount
                                            if(!empty($lastNotesId)){
                                                    //update discount and total in billing
                                                    $this->Billing->id = $lastNotesId;
                                                    
                                                    $billingArray['discount'] = $updateSaleBill['discount'];
                                                    $billingArray['total_amount'] = $updateSaleBill['total'];
                                                    $this->Billing->save($billingArray);
                                                     
                                            }
                                            //$this->Session->setFlash(__('The Sales Bill has been saved', true));
                                    }
                                        
                                    if($this->request->data['PharmacySalesBill']['admission_type'] == "IPD" && $this->request->data['PharmacySalesBill']['tariff']=='25'){
                                        $this->loadModel('ServiceBill');
                                        $packageAmount = $this->ServiceBill->getRgjayPackageAmount($patientId);  
                                        $oneThirdofPackage = $packageAmount/3;
                                        $oneForthofPackage = $packageAmount/4; 
                                        $getSalesPriceData = $this->getPharmacySumOfPurchasePriceOfSales($patientId);
                                        $getPharmacyTotalPurchaseAmt = $getSalesPriceData['total'] - $getSalesPriceData['paid'];
                                        $getEnableFeatureChk=$this->Session->read('sms_feature_chk');
                                        if($getEnableFeatureChk){
											$this->loadModel('Message');
                                            $getPatientDetails=$this->Patient->getPatientDetails($patientId);	 
                                            if(!empty($packageAmount) && $packageAmount > 0 && $getPharmacyTotalPurchaseAmt >= $oneThirdofPackage){
                                                $showExceedPackMsg= sprintf(Configure::read('pharmacy_exceed_msg'),$getPharmacyTotalPurchaseAmt,$getPatientDetails['Patient']['lookup_name'],"3rd",$packageAmount,$oneThirdofPackage,Configure::read('hosp_details'));                                                
                                                $ret = $this->Message->sendToSms($showExceedPackMsg,Configure::read('pharmacy_exceed_mobile_no')); //for Surgery allot for patient to send sms owner
                                             }else
                                                if(!empty($packageAmount) && $packageAmount > 0 && $getPharmacyTotalPurchaseAmt >= $oneForthofPackage){
                                                $showExceedPackMsg= sprintf(Configure::read('pharmacy_exceed_msg'),$getPharmacyTotalPurchaseAmt,$getPatientDetails['Patient']['lookup_name'],"4th",$packageAmount,$oneForthofPackage,Configure::read('hosp_details'));                                                
                                                $ret = $this->Message->sendToSms($showExceedPackMsg,Configure::read('pharmacy_exceed_mobile_no')); //for Surgery allot for patient to send sms owner
                                                //if($getPharmacyTotalPurchaseAmt >= 10000){
                                                //$showExceedPackMsg= sprintf(Configure::read('pharmacy_exceed_tenThousand_msg'),$getPatientDetails['Patient']['lookup_name'],$getPharmacyTotalPurchaseAmt,Configure::read('hosp_details'));
                                                //$ret = $this->Message->sendToSms($showExceedPackMsg,Configure::read('pharmacy_exceed_mobile_no')); //for Surgery allot for patient to send sms owner
                                             }  
                                        }
                                    } 
                                  //  $this->Session->setFlash(__('The Sales Bill has been saved', true));
                                    $this->Session->setFlash(__("The Sales Bill has been saved for Bill No: <b>".$this->request->data['PharmacySalesBill']['bill_code']."</b>", true),'default',array('class'=>'stillSuccess','id'=>'stillFlashMessage'),'still');
                                    
						
					if(isset($this->request->data['notInItemRate'])){
						$data = array();
						for($i=0;$i<count($this->request->data['notInItemRate']['mrp']);$i++){
							$data['PharmacyItemRate'][$i]['sale_price'] = $this->request->data['rate'][$i];
							$data['PharmacyItemRate'][$i]['mrp'] = $this->request->data['mrp'][$i];
							$data['PharmacyItemRate'][$i]['item_id'] = $this->request->data['notInItemRate']['mrp'][$i+1];
						}

						$this->PharmacyItemRate->saveAll($data['PharmacyItemRate']);
					}

					// for medications of patientlist Insert last Id of PharmacySalesBill in NewCrop -- By Mrunal(23/1/2015)
					$get_last_insertID = $this->PharmacySalesBill->getLastInsertId();
						
					$newCropPatienPrescription = $this->NewCropPrescription->find('list',array(
					 									'conditions'=>array('NewCropPrescription.patient_uniqueid'=>$this->request->data['PharmacySalesBill']['patient_id'],
					 														'NewCropPrescription.for_normal_med'=>0),
					 									'fields'=>array('NewCropPrescription.id','NewCropPrescription.drug_id')
					));
						
					
					$itemId = $this->request->data['item_id'];
					$deletedItemId = array_diff($newCropPatienPrescription, $itemId);
						
					foreach($itemId as $key=>$itemValue){
						$newCropAfterSalesBill = $this->NewCropPrescription->find('all',array(
								'conditions'=>array('NewCropPrescription.patient_uniqueid'=>$this->request->data['PharmacySalesBill']['patient_id'],
													'NewCropPrescription.drug_id' =>$itemValue
						),
								'fields'=>array('NewCropPrescription.id','NewCropPrescription.drug_id','NewCropPrescription.patient_uniqueid')));
							
						foreach($newCropAfterSalesBill as $newId){
							if($requisitionType == "medication"){
								$dataArray = Array();
								$dataArray['id'] = $newId['NewCropPrescription']['id'];
								$dataArray['for_normal_med'] = 1;
								$dataArray['patient_uniqueid'] = $newId['NewCropPrescription']['patient_uniqueid'];
								$dataArray['pharmacy_sales_bill_id'] = $get_last_insertID;
								
								$this->NewCropPrescription->save($dataArray);
								$this->NewCropPrescription->id = "";
							}
						}
					}
					/** END OF CODE **/
						
					/**** If item is deleted from sales bill that patient should not display on a list *******/
					foreach($deletedItemId as $key=>$itemValue){
						$newCropAfterSalesBill = $this->NewCropPrescription->find('all',array(
								'conditions'=>array('NewCropPrescription.patient_uniqueid'=>$this->request->data['PharmacySalesBill']['patient_id'],
										'NewCropPrescription.drug_id' =>$itemValue
						),
								'fields'=>array('NewCropPrescription.id','NewCropPrescription.drug_id','NewCropPrescription.patient_uniqueid')));

						foreach($newCropAfterSalesBill as $newId){
							if($requisitionType == "medication"){
								$dataArray = Array();
								$dataArray['id'] = $newId['NewCropPrescription']['id'];
								$dataArray['for_normal_med'] = 2;
								$dataArray['patient_uniqueid'] = $newId['NewCropPrescription']['patient_uniqueid'];
								$dataArray['pharmacy_sales_bill_id'] = $get_last_insertID;
									
								$this->NewCropPrescription->save($dataArray);
								$this->NewCropPrescription->id = "";
							}
						}

					}

					//End OF Code
						
					/*if(isset($this->request->data['redirect_to_billing'])){
						 
						$this->redirect(array("controller" => "pharmacy", "action" => "sales_bill", '?'=>array('print'=>'print','id'=>$get_last_insertID,$status), 'inventory'=>true));
						//$this->redirect(array("controller" => "pharmacy", "action" => "pharmacy_details",'sales' ,'inventory'=>true));
					}else */
                    if($this->request->data['print']){
						$url = Router::url(array("controller" => "pharmacy", "action" => "inventory_print_view",'PharmacySalesBill',$this->PharmacySalesBill->id,'inventory'=>true));
						echo "<script>window.open('".$url."','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true )</script>";
					}else{
                        $this->loadModel('TariffStandard');
                        $rgjayStdIds = $this->TariffStandard->find('list',array('fields'=>array('id','id'),
                            'conditions'=>array('TariffStandard.name'=>array(Configure::read('RGJAY'),Configure::read('RGJAYToday')))));
                        //disallow print for RGJAY and RGJAY (private as on today)'s corporate as per order of Murli Sir by Swapnil - 09.11.2015
	                    if(!in_array($this->request->data['PharmacySalesBill']['tariff'],$rgjayStdIds)){ 
							$this->redirect(array("controller" => "pharmacy", "action" => "sales_bill", '?'=>array('print'=>'print','id'=>$get_last_insertID,$status), 'inventory'=>true));
	                    }else{
	                            $this->redirect(array("controller" => "pharmacy", "action" => "sales_bill"));
	                    }
					} 
				}

			}


		}else if ($this->request->is('post') && !empty($this->request->data)) {
			 
			if(!isset($this->request->data['item_id'])){
				$this->Session->setFlash(__('Item must be selected'), true,array('class'=>'error'));
			}else{ 
				$this->Patient->bindModel(array(
						'belongsTo' => array(
								'DoctorProfile' =>array('foreignKey'=>false, 'conditions'=>array('DoctorProfile.user_id=Patient.doctor_id' ))
						)));
				if(trim($this->request->data['party_code'])!=""){
					$patient = $this->Patient->find('first', array('conditions'=>array("Patient.admission_id"=>$this->request->data['party_code'])));
					$patientId = $patient['Patient']['id'];
					$this->request->data['PharmacySalesBill']['patient_id']  = $patientId;
				}else{
					$this->request->data['PharmacySalesBill']['customer_name']  = $this->request->data['party_name'];
				}

				if(!empty($this->request->data['sale_date'])){
					$saleDate = $this->DateFormat->formatDate2STD($this->request->data['sale_date'],Configure::read('date_format'));
				}
				if($this->request->data['PharmacySalesBill']['payment_mode'] == "Cash"){
					$this->request->data['PharmacySalesBill']['modified_time'] = $saleDate?$saleDate:date('Y-m-d H:i:s');
				}
				//for coupon/privilege card Discount -swatin
				
				$this->loadModel('ServiceCategory');
				$this->loadModel('Coupon');
				
				$patientData = $this->Patient->find('first', array('conditions'=>array("Patient.id"=>$this->request->data['PharmacySalesBill']['patient_id']),'fields'=>array('coupon_name')));
				$PharmacyGroupId = $this->ServiceCategory->getPharmacyId();
				
				if(!empty($patientData['Patient']['coupon_name'])){
					$couponDetails  = $this->Coupon->find('first',array('conditions'=>array('Coupon.batch_name'=>$patientData['Patient']['coupon_name']),'fields'=>array('id','batch_name','sevices_available','coupon_amount')));
					$sevicesAvailable = explode(',',$couponDetails['Coupon']['sevices_available']);
					$couponAMT = unserialize($couponDetails['Coupon']['coupon_amount']);
					if(in_array($PharmacyGroupId, $sevicesAvailable)){
						$discAmt=0;
						$totalPayment = $this->request->data['PharmacySalesBill']['total'];
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
				 	$this->request->data['PharmacySalesBill']['discount']=$this->request->data['PharmacySalesBill']['discount']+$discAmt;
				}
				/* end of discount code*/
				$this->request->data['PharmacySalesBill']['create_time'] = $saleDate?$saleDate:date('Y-m-d H:i:s');
				$this->request->data['PharmacySalesBill']['created_by'] = $this->Auth->user('id');
				$this->request->data['PharmacySalesBill']['location_id'] = $this->Session->read('locationid');
				if($this->Session->read('locationid')==25 || $this->Session->read('locationid')==26 ){
			    $this->request->data['PharmacySalesBill']['bill_code']  = $this->PharmacySalesBill->generateSalesBillNoForKanpur($this->Session->read('locationid'));
				}else{
				$this->request->data['PharmacySalesBill']['bill_code']  = $this->PharmacySalesBill->generateSalesBillNo();
				}
				$this->request->data['PharmacySalesBill']['itemType'] = $this->request->data['PharmacySalesBill']['item_type'];
				$this->request->data['PharmacySalesBill']['discount'] = round($this->request->data['PharmacySalesBill']['discount']);			

				if($this->request->data['PharmacySalesBill']['payment_mode'] == "Cash"){
					$this->request->data['PharmacySalesBill']['paid_amnt'] = round($this->request->data['PharmacySalesBill']['total'] - ($this->request->data['PharmacySalesBill']['discount'])); //by swapnil 20.02.2015
				}
				//debug($this->request->data);exit;
				$this->PharmacySalesBill->create();
				$this->PharmacySalesBill->save($this->request->data); 
				$lastInsertedIdOfSalesBill = $this->PharmacySalesBill->getLastInsertId();
				//$lastInsertedIdOfSalesBill = 2;
				/* End of code */

				/***** for Nurse Prescription -by Mrunal ***********/ 
				if($requisitionType == "nurse"){ 
					//function to insert,update newcropprescription data for nursing prescription
					$this->updateNursingData($this->request->data,$patient_id,$batchId,$lastInsertedIdOfSalesBill); 
				}
				//**** END OF CODE ****//
					
				/** function to check sales bill is done for nursepriscription or not by Mrunal*/
				/* if($requisitionType == "nurse"){
					$this->checkSalesBillIsDone($patient_id,$batchId);
				} */
				
				/** END of NursePrescription */
				//save in billing if payment is cash by Swapnil G.Sharma
				if($this->request->data['PharmacySalesBill']['payment_mode'] == "Cash"){
					//debug($this->request->data); exit;
					$this->loadModel('Billing');
					$this->loadModel('ServiceCategory');
					$payment_category = $this->ServiceCategory->getPharmacyId();
					$billingData = array();
					$billingData['date']=date("Y-m-d H:i:s");
					$billingData['patient_id']=$patientId;
					$billingData['payment_category']=$payment_category;
					$billingData['location_id']=$this->Session->read('locationid');
					$billingData['created_by']=$this->Session->read('userid');
					$billingData['create_time']=date("Y-m-d H:i:s");
					$billingData['mode_of_payment']=$this->request->data['PharmacySalesBill']['payment_mode'];
					$billingData['total_amount']=round($this->request->data['PharmacySalesBill']['total']);
					$billingData['amount']=round($this->request->data['PharmacySalesBill']['total'] - $this->request->data['PharmacySalesBill']['discount']);
					$billingData['pharmacy_sales_bill_id'] = $lastInsertedIdOfSalesBill;
						
					if($this->request->data['PharmacySalesBill']['is_discount']==1){
						$billingData['discount_type']=$this->request->data['PharmacySalesBill']['discount_type'];
						if($billingData['discount_type'] == "Percentage"){
							$billingData['discount_percentage'] = round($this->request->data['PharmacySalesBill']['input_discount']);
						}else
						if($billingData['discount_type'] == "Amount"){
							$billingData['discount_amount'] = round($this->request->data['PharmacySalesBill']['discount']);
						}
					}
					$billingData['discount'] = round($this->request->data['PharmacySalesBill']['discount']);
					$billingData['is_card'] = $this->request->data['PharmacySalesBill']['is_card'];
					$billingData['patient_card'] = $this->request->data['PharmacySalesBill']['patient_card'];
					$this->Billing->save($billingData);
					$lastNotesId = $this->Billing->getLastInsertID();
					$billNo= $this->Billing->generateBillNoPerPay($patientId,$lastNotesId);
					$updateBillingArray=array('Billing.bill_number'=>"'$billNo'");
					$this->Billing->updateAll($updateBillingArray,array('Billing.patient_id'=>$patientId,'Billing.id'=>$lastNotesId));
					//for accounting
						$billingDataDetails['Billing'] = $billingData;
						$this->Billing->addPartialPaymentJV($billingDataDetails,$patientId);
					//EOF a/c by amit jain
					$this->PharmacySalesBill->id = $lastInsertedIdOfSalesBill;
					$updateBillId['billing_id'] = $lastNotesId;
					$this->PharmacySalesBill->save($updateBillId);
					//$this->PharmacySalesBill->id = "";
				}
				
				/** billing credit entry for discount -- Gaurav Chauriya */
				elseif($this->request->data['PharmacySalesBill']['payment_mode'] == "Credit" && isset($this->request->data['PharmacySalesBill']['discount'])){	//updated by Swapnil (iff discount on sales bill) 26.03.2015
					$this->loadModel('Billing');
					$this->loadModel('ServiceCategory');
					$payment_category = $this->ServiceCategory->getPharmacyId();
					$billingData = array();
					$billingData['date']=date("Y-m-d H:i:s");
					$billingData['patient_id'] = $patientId;
					$billingData['payment_category'] = $payment_category;
					$billingData['location_id']=$this->Session->read('locationid');
					$billingData['created_by']=$this->Session->read('userid');
					$billingData['create_time']=date("Y-m-d H:i:s");
					$billingData['mode_of_payment']=$this->request->data['PharmacySalesBill']['payment_mode'];
					$billingData['total_amount'] = round($this->request->data['PharmacySalesBill']['total']) - $this->request->data['PharmacySalesBill']['discount'] ;
					$billingData['amount']= '0';
					$billingData['pharmacy_sales_bill_id'] = $lastInsertedIdOfSalesBill;
					
					if($this->request->data['PharmacySalesBill']['is_discount']==1){
						$billingData['discount_type'] = $this->request->data['PharmacySalesBill']['discount_type'];
						if($billingData['discount_type'] == "Percentage"){
							$billingData['discount_percentage'] = round($this->request->data['PharmacySalesBill']['input_discount']);
						}else
							if($billingData['discount_type'] == "Amount"){
							$billingData['discount_amount'] = round($this->request->data['PharmacySalesBill']['discount']);
						}
					}
					$billingData['discount'] = round($this->request->data['PharmacySalesBill']['discount']);
					$billingData['is_card'] = $this->request->data['PharmacySalesBill']['is_card'];
					$billingData['patient_card'] = $this->request->data['PharmacySalesBill']['patient_card'];
					$this->Billing->save($billingData);
					
					$lastNotesId=$this->Billing->getLastInsertID();
					$billNo= $this->Billing->generateBillNoPerPay($patientId,$lastNotesId);
					$updateBillingArray=array('Billing.bill_number'=>"'$billNo'");
					$this->Billing->updateAll($updateBillingArray,array('Billing.patient_id'=>$patientId,'Billing.id'=>$lastNotesId));
					//for accounting
						$accountData = array();
						$accountData['date']=date("Y-m-d H:i:s");
						$accountData['discount'] = round($this->request->data['PharmacySalesBill']['discount']);
						$billingDataDetails['Billing']=$accountData;
						$this->Billing->addPartialPaymentJV($billingDataDetails,$patientId);
					//EOF a/c by amit jain
					$this->PharmacySalesBill->id = $lastInsertedIdOfSalesBill;
					$updateBillId['billing_id'] = $lastNotesId;
					$this->PharmacySalesBill->save($updateBillId);
				}
				
				/* patient card code For vadodara and hope instance -Pooja Gupta*/
				if($this->Session->read('website.instance')!='kanpur'){
					if(!empty($this->request->data['PharmacySalesBill']['is_card']) &&
					!empty($this->request->data['PharmacySalesBill']['patient_card'])){

						$this->loadModel('PatientCard');
						if(empty($lastNotesId)){
							$billId=$lastInsertedIdOfSalesBill;
							$type='Payment';
						}else{
							$billId=$lastNotesId;
							$type='Payment';
						}
						$this->PatientCard->insertIntoCard($this->request->data['PharmacySalesBill']['patient_card'],
						$patient['Patient']['person_id'],$billId,$type);
					}
				}
				/* EOF patient card*/
				$errors = $this->PharmacySalesBill->invalidFields();
				
				if(!empty($errors)) {
					$this->set("errors", $errors);
				} else {;
					$nurse = false;
					if($requisitionType == nurse){
						$nurse = true;
						
					}
                                    $updateSaleBill = $this->PharmacySalesBillDetail->saveBillDetails($this->request->data,$this->PharmacySalesBill->id,$nurse);
                                    
                                    if(!empty($updateSaleBill)){ 
                                        
                                            $this->PharmacySalesBill->save($updateSaleBill); //update total & discount
                                            if(!empty($lastNotesId)){
                                                    //update discount and total in billing
                                                    $this->Billing->id = $lastNotesId;
                                                    
                                                    $billingArray['discount'] = $updateSaleBill['discount'];
                                                    $billingArray['total_amount'] = $updateSaleBill['total'];
                                                    $this->Billing->save($billingArray);
                                                     
                                            }
                                            //$this->Session->setFlash(__('The Sales Bill has been saved', true));
                                    }
                                        
                                    if($this->request->data['PharmacySalesBill']['admission_type'] == "IPD" && $this->request->data['PharmacySalesBill']['tariff']=='25'){
                                        $this->loadModel('ServiceBill');
                                        $packageAmount = $this->ServiceBill->getRgjayPackageAmount($patientId);  
                                        $oneThirdofPackage = $packageAmount/3;
                                        $oneForthofPackage = $packageAmount/4; 
                                        $getSalesPriceData = $this->getPharmacySumOfPurchasePriceOfSales($patientId);
                                        $getPharmacyTotalPurchaseAmt = $getSalesPriceData['total'] - $getSalesPriceData['paid'];
                                        $getEnableFeatureChk=$this->Session->read('sms_feature_chk');
                                        if($getEnableFeatureChk){
											$this->loadModel('Message');
                                            $getPatientDetails=$this->Patient->getPatientDetails($patientId);	 
                                            if(!empty($packageAmount) && $packageAmount > 0 && $getPharmacyTotalPurchaseAmt >= $oneThirdofPackage){
                                                $showExceedPackMsg= sprintf(Configure::read('pharmacy_exceed_msg'),$getPharmacyTotalPurchaseAmt,$getPatientDetails['Patient']['lookup_name'],"3rd",$packageAmount,$oneThirdofPackage,Configure::read('hosp_details'));                                                
                                                $ret = $this->Message->sendToSms($showExceedPackMsg,Configure::read('pharmacy_exceed_mobile_no')); //for Surgery allot for patient to send sms owner
                                             }else
                                                if(!empty($packageAmount) && $packageAmount > 0 && $getPharmacyTotalPurchaseAmt >= $oneForthofPackage){
                                                $showExceedPackMsg= sprintf(Configure::read('pharmacy_exceed_msg'),$getPharmacyTotalPurchaseAmt,$getPatientDetails['Patient']['lookup_name'],"4th",$packageAmount,$oneForthofPackage,Configure::read('hosp_details'));                                                
                                                $ret = $this->Message->sendToSms($showExceedPackMsg,Configure::read('pharmacy_exceed_mobile_no')); //for Surgery allot for patient to send sms owner
                                                //if($getPharmacyTotalPurchaseAmt >= 10000){
                                                //$showExceedPackMsg= sprintf(Configure::read('pharmacy_exceed_tenThousand_msg'),$getPatientDetails['Patient']['lookup_name'],$getPharmacyTotalPurchaseAmt,Configure::read('hosp_details'));
                                                //$ret = $this->Message->sendToSms($showExceedPackMsg,Configure::read('pharmacy_exceed_mobile_no')); //for Surgery allot for patient to send sms owner
                                             }  
                                        }
                                    } 
                                  //  $this->Session->setFlash(__('The Sales Bill has been saved', true));
                                    $this->Session->setFlash(__("The Sales Bill has been saved for Bill No: <b>".$this->request->data['PharmacySalesBill']['bill_code']."</b>", true),'default',array('class'=>'stillSuccess','id'=>'stillFlashMessage'),'still');
                                    
						
					if(isset($this->request->data['notInItemRate'])){
						$data = array();
						for($i=0;$i<count($this->request->data['notInItemRate']['mrp']);$i++){
							$data['PharmacyItemRate'][$i]['sale_price'] = $this->request->data['rate'][$i];
							$data['PharmacyItemRate'][$i]['mrp'] = $this->request->data['mrp'][$i];
							$data['PharmacyItemRate'][$i]['item_id'] = $this->request->data['notInItemRate']['mrp'][$i+1];
						}

						$this->PharmacyItemRate->saveAll($data['PharmacyItemRate']);
					}

					// for medications of patientlist Insert last Id of PharmacySalesBill in NewCrop -- By Mrunal(23/1/2015)
					$get_last_insertID = $this->PharmacySalesBill->getLastInsertId();
						
					$newCropPatienPrescription = $this->NewCropPrescription->find('list',array(
					 									'conditions'=>array('NewCropPrescription.patient_uniqueid'=>$this->request->data['PharmacySalesBill']['patient_id'],
					 														'NewCropPrescription.for_normal_med'=>0),
					 									'fields'=>array('NewCropPrescription.id','NewCropPrescription.drug_id')
					));
						
					
					$itemId = $this->request->data['item_id'];
					$deletedItemId = array_diff($newCropPatienPrescription, $itemId);
						
					foreach($itemId as $key=>$itemValue){
						$newCropAfterSalesBill = $this->NewCropPrescription->find('all',array(
								'conditions'=>array('NewCropPrescription.patient_uniqueid'=>$this->request->data['PharmacySalesBill']['patient_id'],
													'NewCropPrescription.drug_id' =>$itemValue
						),
								'fields'=>array('NewCropPrescription.id','NewCropPrescription.drug_id','NewCropPrescription.patient_uniqueid')));
							
						foreach($newCropAfterSalesBill as $newId){
							if($requisitionType == "medication"){
								$dataArray = Array();
								$dataArray['id'] = $newId['NewCropPrescription']['id'];
								$dataArray['for_normal_med'] = 1;
								$dataArray['patient_uniqueid'] = $newId['NewCropPrescription']['patient_uniqueid'];
								$dataArray['pharmacy_sales_bill_id'] = $get_last_insertID;
								
								$this->NewCropPrescription->save($dataArray);
								$this->NewCropPrescription->id = "";
							}
						}
					}
					/** END OF CODE **/
						
					/**** If item is deleted from sales bill that patient should not display on a list *******/
					foreach($deletedItemId as $key=>$itemValue){
						$newCropAfterSalesBill = $this->NewCropPrescription->find('all',array(
								'conditions'=>array('NewCropPrescription.patient_uniqueid'=>$this->request->data['PharmacySalesBill']['patient_id'],
										'NewCropPrescription.drug_id' =>$itemValue
						),
								'fields'=>array('NewCropPrescription.id','NewCropPrescription.drug_id','NewCropPrescription.patient_uniqueid')));

						foreach($newCropAfterSalesBill as $newId){
							if($requisitionType == "medication"){
								$dataArray = Array();
								$dataArray['id'] = $newId['NewCropPrescription']['id'];
								$dataArray['for_normal_med'] = 2;
								$dataArray['patient_uniqueid'] = $newId['NewCropPrescription']['patient_uniqueid'];
								$dataArray['pharmacy_sales_bill_id'] = $get_last_insertID;
									
								$this->NewCropPrescription->save($dataArray);
								$this->NewCropPrescription->id = "";
							}
						}

					}

					//End OF Code
						
					/*if(isset($this->request->data['redirect_to_billing'])){
						 
						$this->redirect(array("controller" => "pharmacy", "action" => "sales_bill", '?'=>array('print'=>'print','id'=>$get_last_insertID,$status), 'inventory'=>true));
						//$this->redirect(array("controller" => "pharmacy", "action" => "pharmacy_details",'sales' ,'inventory'=>true));
					}else */
                                        if($this->request->data['print']){
						$url = Router::url(array("controller" => "pharmacy", "action" => "inventory_print_view",'PharmacySalesBill',$this->PharmacySalesBill->id,'inventory'=>true));
						echo "<script>window.open('".$url."','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true )</script>";
					}else{
                                            $this->loadModel('TariffStandard');
                                            $rgjayStdIds = $this->TariffStandard->find('list',array('fields'=>array('id','id'),
                                                'conditions'=>array('TariffStandard.name'=>array(Configure::read('RGJAY'),Configure::read('RGJAYToday')))));
                                            //disallow print for RGJAY and RGJAY (private as on today)'s corporate as per order of Murli Sir by Swapnil - 09.11.2015
                                            if(!in_array($this->request->data['PharmacySalesBill']['tariff'],$rgjayStdIds)){ 
						$this->redirect(array("controller" => "pharmacy", "action" => "sales_bill", '?'=>array('print'=>'print','id'=>$get_last_insertID,$status), 'inventory'=>true));
                                            }else{
                                                $this->redirect(array("controller" => "pharmacy", "action" => "sales_bill"));
                                            }
					} 
				}

			}
		}
		/* code for guarantor username list */
		$userName = $this->User->find('list',array('fields'=>array('id','username'),
				'conditions'=>array("User.is_guarantor" =>'1' ,"User.location_id" =>$this->Session->read('locationid'),"User.is_deleted"=>'0')));


		$this->set('userName',$userName);
		/* EOC */
		/**
		 * code to load patient prescriptions
		 */
		if($patient_id){
			$this->loadModel('NewCropPrescription');
			$this->loadModel('PharmacyItem');
			$this->loadModel('Preferencecard');
			$this->loadModel('OptAppointment');
			$this->loadModel('PatientCompletedSaleBill');
			$this->loadModel('Room');
				
			if($requisitionType=='ot'){ //preference card

				$this->OptAppointment->bindModel(array(
						'belongsTo' => array('Preferencecard' =>array('foreignKey' => 'preferencecard_id'))
				));
					
				$otReq = $this->OptAppointment->find('all',array('conditions'=>array('OptAppointment.patient_id'=>$patient_id),
						'fields'=>array('OptAppointment.preferencecard_id','Preferencecard.medications','Preferencecard.quantity','Preferencecard.id'))); 

				$drugId = array() ;
				$drugQty = array();
				foreach($otReq as $key => $value){
						
					$medication  = unserialize($value['Preferencecard']['medications'] );
					$quantity  = unserialize($value['Preferencecard']['quantity']) ;
					if(!empty($medication[0]))
					$drugId = array_merge($drugId,$medication[0]);
					if(!empty($quantity[0]))
					$drugQty = array_merge($drugQty,$quantity[0]);
				}//debug($drugQty);exit;
				$this->PharmacyItem->bindModel(array(
					'hasMany' => array('PharmacyItemRate' =>array('foreignKey'=>"item_id")), 
				));
					
				$pharmacyData = $this->PharmacyItem->find('all',array('fields'=>array('item_code','name','manufacturer','pack','stock','cust_name'),
						'conditions'=>array('PharmacyItem.id'=>$drugId),
						'group'=>array('PharmacyItem.id')));
				// debug($pharmacyData);exit;
			}else if($requisitionType == 'medication'){  //newcropprescription
				//debug($requisitionType);
				$this->PharmacyItem->bindModel(array(
						'belongsTo'=>array('NewCropPrescription'=>array('type'=>'INNER','foreignKey'=>false,
								'conditions'=>array('NewCropPrescription.drug_id=PharmacyItem.id','NewCropPrescription.archive="N"','NewCropPrescription.by_nurse'=>null,'patient_uniqueid'=>$patient_id))),
						'hasMany' => array('PharmacyItemRate' =>array('foreignKey'=>"item_id")),

				));

				$pharmacyData = $this->PharmacyItem->find('all',array('fields'=>array('NewCropPrescription.quantity','item_code','name','manufacturer','pack','stock'),
						'conditions'=>array('PharmacyItem.id = PharmacyItemRate.item_id','NewCropPrescription.for_normal_med'=>'0','NewCropPrescription.is_deleted'=>'0'),
						'group'=>array('PharmacyItem.id'),
						'order'=>array('PharmacyItemRate.expiry_date'=>"ASC")));

				//debug($pharmacyData);exit;
					
			} else if($requisitionType == 'nurse'){ //newcropprescription by nurse

				if($websiteConfig['instance']=='kanpur'){
					$this->PharmacyItem->bindModel(array(
						'belongsTo'=>array('NewCropPrescription'=>array('foreignKey'=>false,
								'conditions'=>array('NewCropPrescription.drug_id=PharmacyItem.id','NewCropPrescription.archive="N"',
								'NewCropPrescription.by_nurse'=>'1','patient_uniqueid'=>$patient_id)),
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id = NewCropPrescription.patient_uniqueid')),
								'Room'=>array('foreignKey'=>false,'conditions'=>array('Room.id = Patient.room_id'))),
								'hasMany' => array('PharmacyItemRate' =>array('foreignKey'=>"item_id" ),
					),
					),false);
				}else{
					$this->PharmacyItem->bindModel(array(
							'belongsTo'=>array('NewCropPrescription'=>array('foreignKey'=>false,
									'conditions'=>array('NewCropPrescription.drug_id=PharmacyItem.id','NewCropPrescription.archive="N"',
									'NewCropPrescription.by_nurse'=>'1','patient_uniqueid'=>$patient_id)),
									'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id = NewCropPrescription.patient_uniqueid')),
									'DoctorProfile' =>array('foreignKey'=>false, 'conditions'=>array('DoctorProfile.user_id=Patient.doctor_id' )),
									'Room'=>array('foreignKey'=>false,'conditions'=>array('Room.id = Patient.room_id'))),
							'hasMany' => array('PharmacyItemRate' =>array('foreignKey'=>"item_id",
                                                            'conditions'=>array("OR" => array('PharmacyItemRate.stock > '=>'0','PharmacyItemRate.loose_stock >'=>'0'))
                                                            /*,'conditions'=>array('PharmacyItemRate.stock > 0') */),
							),
					),false);
				}
				
				$pharmacyData = $this->PharmacyItem->find('all',array('fields'=>array('PharmacyItem.*','DoctorProfile.*','Room.room_type','Patient.id','Patient.room_id','Patient.tariff_standard_id','Patient.patient_id', 
                                                    'NewCropPrescription.quantity','NewCropPrescription.status','NewCropPrescription.recieved_quantity','NewCropPrescription.batch_identifier',
                                                    'item_code','name','manufacturer','pack','stock','cust_name'),
                                            'conditions'=>array('NewCropPrescription.status'=>array(1,0),'PharmacyItem.id = PharmacyItemRate.item_id',
                                                    'NewCropPrescription.batch_identifier'=>$batchId,'NewCropPrescription.is_deleted'=>'0'
                                                    ), 
                                              'group'=>array('PharmacyItem.id'), 
                                             'order'=>array('NewCropPrescription.id')
						)); 
				 
				if(isset($pharmacyData[0]['DoctorProfile']['id']) && !(empty($pharmacyData[0]['DoctorProfile']['id']))){
					$doctorData = array('id'=>$pharmacyData[0]['DoctorProfile']['user_id'],'doctor_name'=>$pharmacyData[0]['DoctorProfile']['doctor_name']);
					$this->set('doctorData',$doctorData);
				}
				
				if(isset($pharmacyData[0]['Room']['room_type']) && !(empty($pharmacyData[0]['Room']['room_type']))){
					$roomType= $pharmacyData[0]['Room']['room_type'];
					$discountType = '';
					$allRoomListarray = array(
						'opd_ward'=>'opdgeneral_ward_discount',
						'general'=>'gen_ward_discount',
						'special'=>'spcl_ward_discount',
						'semi_special'=>'semi_spcl_ward_discount',
						'Delux'=>'dlx_ward_discount',
						'Isolation'=>'islolation_ward_discount');
					$discountType = $allRoomListarray[$roomType];
				} 
				$privateId = $this->TariffStandard->getTariffStandardID( 'privateTariffName');

				foreach($pharmacyData as $key=>$val){
					
					if(strtolower($this->Session->read('website.instance')) == "vadodara" || strtolower($this->Session->read('website.instance')) == "hope" ){
						
						//calculate total stock of pharmacy item rate by swapnil 11.04.2015
						foreach($val['PharmacyItemRate'] as $rateKey => $myrate){ 
                                                   
							$totalStock[$key] += ($myrate['stock'] * (int)$val['PharmacyItem']['pack']) + $myrate['loose_stock'];
						}
						 
						foreach($val['PharmacyItemRate'] as $rateKey => $myrate){ 
							$pharmacyData[$key]['PharmacyItemRate'][$rateKey]['stock'] = $totalStock[$key];
							$pharmacyData[$key]['PharmacyItemRate'][$rateKey]['sale_price'] = $myrate['mrp'];
						}
						 
						//if private then only discount	on product		by swapnil 03.04.2015	
						if($val['Patient']['tariff_standard_id'] == $privateId){
							$pharmacyData[$key]['PharmacyItem']['itemWiseDiscount'] = $val['PharmacyItem'][$discountType];
						}
					}
				}  //EOF loop
				
		
			/***************************/
					
			}else if($requisitionType == 'edit'){
				//$this->PharmacyItem->recursive=-1;

				$this->PharmacyItem->bindModel(array(
						'hasMany' => array(
								'PharmacyItemRate' =>array('foreignKey'=>"item_id",'conditions'=>array('PharmacyItemRate.is_deleted'=>0)),
				),
				),false); 
				
				$this->PharmacySalesBill->bindModel(array(
						'belongsTo' => array(
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id = PharmacySalesBill.patient_id')),
								'Room'=>array('foreignKey'=>false,'conditions'=>array('Room.id = Patient.room_id')),
								'User' =>array('foreignKey' => 'guarantor_id'),array('conditions'=>array('PharmacySalesBill.guarantor_id=User.id')),
								'DoctorProfile' =>array('foreignKey' => false),array('conditions' => array('PharmacySalesBill.doctor_id = DoctorProfile.user_id')))

				),false);  
				
				$pharmacySales = $this->PharmacySalesBill->find('first',array('conditions'=>
				array('PharmacySalesBill.id'=>$billId,"PharmacySalesBill.location_id" =>$this->Session->read('locationid'),'PharmacySalesBill.is_deleted' =>'0'),
						'fields'=>array('User.username','PharmacySalesBill.*','Room.id','Room.room_type','Patient.id','Patient.lookup_name','Patient.admission_type',
								'Patient.tariff_standard_id','Patient.admission_id','DoctorProfile.doctor_name'/* ,'PharmacySalesBillDetail.*' */)));

				if(isset($pharmacySales['Room']['room_type']) && !(empty($pharmacySales['Room']['room_type']))){
					$roomType= $pharmacySales['Room']['room_type'];
					$allRoomListarray = array(
							'opd_ward'=>'opdgeneral_ward_discount',
							'general'=>'gen_ward_discount',
							'special'=>'spcl_ward_discount',
							'semi_special'=>'semi_spcl_ward_discount',
							'Delux'=>'dlx_ward_discount',
							'Isolation'=>'islolation_ward_discount');
					$discountType = $allRoomListarray[$roomType];
				}
				$privateId = $this->TariffStandard->getTariffStandardID( 'privateTariffName');
				
				foreach($pharmacySales['PharmacySalesBillDetail'] as $key=>$value){
					
					$pharmRateData = $this->PharmacyItemRate->find('first',array('conditions'=>array('PharmacyItemRate.item_id'=>$value['item_id'],'PharmacyItemRate.batch_number'=>$value['batch_number'])));
					$pharmItemId[]=$value['item_id'];
					$pharmBatch[$value['item_id']]=$value['batch_number'];
					$pharmaItemQty[$value['item_id']]=$value['qty'];
					$pharmaSalePrice[$value['item_id']] = $value['sale_price'];
					$pharmaMrp[$value['item_id']] = $value['mrp'];
					$pharmaItemType[$value['item_id']] = $value['qty_type'];
					$pharmaPack[$value['item_id']] = $value['pack'];
					
					if(strtolower($this->Session->read('website.instance')) == "vadodara"){
						//if private then only discount	on product		by swapnil 07.04.2015
						if($pharmacySales['Patient']['tariff_standard_id'] == $privateId){
							$itemWiseDiscount[$value['item_id']] = $pharmRateData['PharmacyItem'][$discountType];
						}
					}
					
				} 
				
				$pharmacyData = $this->PharmacyItem->find('all',array('fields'=>array('item_code','name','manufacturer','pack','stock'),
						'conditions'=>array('PharmacyItem.id'=>$pharmItemId,'PharmacyItemRate.batch_number'=>$pharmBatch), 
				/*'group'=>array('PharmacyItem.id'),*/
						'order'=>array('PharmacyItemRate.expiry_date'=>"ASC")));
				//debug($pharmacyData);
			}else if($requisitionType == 'copy'){
				//$this->PharmacyItem->recursive=-1;

				
				$this->PharmacyItem->bindModel(array(
						'hasMany' => array(
								'PharmacyItemRate' =>array('foreignKey'=>"item_id",'conditions'=>array('PharmacyItemRate.is_deleted'=>0,'PharmacyItemRate.stock > 0')),
				),
				),false); 
				
				$this->PharmacySalesBill->bindModel(array(
						'belongsTo' => array(
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id = PharmacySalesBill.patient_id')),
								'Room'=>array('foreignKey'=>false,'conditions'=>array('Room.id = Patient.room_id')),
								'User' =>array('foreignKey' =>false),array('conditions'=>array('PharmacySalesBill.doctor_id=User.id')),
								/*'DoctorProfile' =>array('foreignKey' => false),array('conditions' => array('PharmacySalesBill.doctor_id = DoctorProfile.user_id'))*/)

				),false);  
				
				$pharmacySales = $this->PharmacySalesBill->find('first',array('conditions'=>
				array('PharmacySalesBill.id'=>$billId,"PharmacySalesBill.location_id" =>$this->Session->read('locationid'),'PharmacySalesBill.is_deleted' =>'0'),
						'fields'=>array('PharmacySalesBill.*','Room.id','Room.room_type','Patient.id','Patient.lookup_name','Patient.admission_type',
								'Patient.tariff_standard_id','Patient.admission_id','User.id','CONCAT(User.first_name," ",User.last_name) as name'/* ,'PharmacySalesBillDetail.*' */)));

				if(isset($pharmacySales['Room']['room_type']) && !(empty($pharmacySales['Room']['room_type']))){
					$roomType= $pharmacySales['Room']['room_type'];
					$allRoomListarray = array(
							'opd_ward'=>'opdgeneral_ward_discount',
							'general'=>'gen_ward_discount',
							'special'=>'spcl_ward_discount',
							'semi_special'=>'semi_spcl_ward_discount',
							'Delux'=>'dlx_ward_discount',
							'Isolation'=>'islolation_ward_discount');
					$discountType = $allRoomListarray[$roomType];
				}
				$privateId = $this->TariffStandard->getTariffStandardID( 'privateTariffName');
			
				foreach($pharmacySales['PharmacySalesBillDetail'] as $key=>$value){
					
					$pharmRateData = $this->PharmacyItemRate->find('first',array('conditions'=>array('PharmacyItemRate.item_id'=>$value['item_id'],'PharmacyItemRate.batch_number'=>$value['batch_number'])));
					$pharmItemId[]=$value['item_id'];
					$pharmBatch[$value['item_id']]=$value['batch_number'];
					$pharmaItemQty[$value['item_id']]=$value['qty'];
					$pharmaSalePrice[$value['item_id']] = $value['sale_price'];
					$pharmaMrp[$value['item_id']] = $value['mrp'];
					$pharmaItemType[$value['item_id']] = $value['qty_type'];
					$pharmaPack[$value['item_id']] = $value['pack'];
					$pharmaAdmTime[$value['item_id']] = $value['administration_time'];
					
					if(strtolower($this->Session->read('website.instance')) == "vadodara"){
						//if private then only discount	on product		by swapnil 07.04.2015
						if($pharmacySales['Patient']['tariff_standard_id'] == $privateId){
							$itemWiseDiscount[$value['item_id']] = $pharmRateData['PharmacyItem'][$discountType];
						}
					}
					
				} 
				
				$pharmacyData = $this->PharmacyItem->find('all',array('fields'=>array('item_code','name','manufacturer','pack','stock'),
						'conditions'=>array('PharmacyItem.id'=>$pharmItemId,'PharmacyItemRate.batch_number'=>$pharmBatch), 
				'group'=>array('PharmacyItem.id'),
						'order'=>array('PharmacyItemRate.expiry_date'=>"ASC")));
				
			}else if($requisitionType == 'editDirectView'){
				//debug($patient_id);debug($requisitionType);debug($billId);debug($batchId);
				$this->PharmacyItem->bindModel(array(
						'hasMany' => array(
								'PharmacyItemRate' =>array('foreignKey'=>"item_id"),
				),
				),false);

				$pharmacySales = $this->PharmacySalesBill->find('first',array(
						'conditions'=>array('PharmacySalesBill.id'=>$patient_id,"PharmacySalesBill.location_id" =>$this->Session->read('locationid'),'PharmacySalesBill.is_deleted' =>'0'),
						'fields'=>array('PharmacySalesBill.*')));

				foreach($pharmacySales['PharmacySalesBillDetail'] as $value){
					$pharmItemId[]=$value['item_id'];
					$pharmBatch[]=$value['batch_number'];
					$pharmaItemQty[$value['item_id']]=$value['qty'];
					$pharmaSalePrice[$value['item_id']] = $value['sale_price'];
					$pharmaMrp[$value['item_id']] = $value['mrp'];
					$pharmaItemType[$value['item_id']] = $value['qty_type'];
					$pharmaPack[$value['item_id']] = $value['pack'];
				}
				//debug($pharmacySales);
				$pharmacyData = $this->PharmacyItem->find('all',array('fields'=>array('item_code','name','manufacturer','pack','stock'
				),
						'conditions'=>array('PharmacyItem.id'=>$pharmItemId,'PharmacyItem.id = PharmacyItemRate.item_id'), 						'group'=>array('PharmacyItem.id'),
						'order'=>array('PharmacyItemRate.expiry_date'=>"ASC")));
			}
				
		}
                
		$this->set('pharmacySales',$pharmacySales);
		$this->set('editSales',$pharmacySales);
		$this->set(compact(array('oReq','pharmacyData','pharmBatch','drugQty','patient_id','requisitionType','pharmaItemQty','pharmaMrp','pharmaSalePrice','pharmaItemType','pharmaPack','patientForMed','itemWiseDiscount','pharmaAdmTime'))); //debug($pharmacyData);
		$this->set('pharmacyData',$pharmacyData);

	}


	//edit sales bill by mrunal (Basically new function created for permission purpose)
	public function inventory_edit_sales_bill($patient_id = null,$requisitionType=null,$billId=null,$batchId=null) {
		$this->inventory_sales_bill($patient_id,$requisitionType,$billId,$batchId);
		$this->render('inventory_sales_bill');
	}

	public function inventory_other_sales_bill(){
		$this->loadModel('PharmacyItem');
		$this->loadModel('Account');
		$this->loadModel('VoucherEntry');
		$this->loadModel('VoucherReference');
		$this->loadModel('VoucherLog');
		$this->loadModel('AccountReceipt');

		/** for payment in diferent location **/
		$this->loadModel("Configuration");

		$configLeders = Configure::read('allCustomLedgers');
		$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website')));
		$websiteConfig=unserialize($website_service_type['Configuration']['value']);
		$this->set('websiteConfig',$websiteConfig);
        $mode_of_payment = array('Cash'=>'Cash','Credit'=>'Credit');  
		$this->set('mode_of_payment',$mode_of_payment);

		$this->layout = "advance";
		
		if ($this->request->is('post')) {
			if(!empty($this->request->data['Patient']['account_id'])){ 
                $userId = $this->request->data['Patient']['account_id'];
			}else{
				$userId = $this->Account->getAccountIdOnly($configLeders['Direct Pharmacy Incomes']);//for cash id
			}
				
			/* $errors = $this->PharmacyItem->invalidFields();
			 $this->PharmacyItem->save($this->request->data); */
			
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The user has been saved', true));

				if ($this->request->is('post') && !empty($this->request->data)) {
					if(!isset($this->request->data['item_id'])){
						$this->Session->setFlash(__('Item must be selected'), true,array('class'=>'error'));
					 $this->redirect(array("controller" => "pharmacy", "action" => "other_sales_bill",'inventory'=>true));
					}else{
						
					$this->request->data['PharmacySalesBill']['customer_name']  = $this->request->data['PharmacyItem']['cust_name'];
					$this->request->data['PharmacySalesBill']['create_time'] = date('Y-m-d H:i:s');
					$this->request->data['PharmacySalesBill']['created_by'] = $this->Auth->user('id');
					$this->request->data['PharmacySalesBill']['location_id'] = $this->Session->read('locationid');
					if($this->Session->read('locationid')==25 || $this->Session->read('locationid')==26 ){
						$this->request->data['PharmacySalesBill']['bill_code']  = $this->PharmacySalesBill->generateSalesBillNoForKanpur($this->Session->read('locationid'));
					}else{
						$this->request->data['PharmacySalesBill']['bill_code']  = $this->PharmacySalesBill->generateSalesBillNo();
					}
                    $this->request->data["PharmacySalesBill"]['p_dob'] = $this->DateFormat->formatDate2STD($this->request->data['PharmacySalesBill']['p_dob'],Configure::read('date_format'));
					$this->request->data['PharmacySalesBill']['itemType'] = $this->request->data['PharmacySalesBill']['item_type'];
					$this->request->data['PharmacySalesBill']['party_invoice_number']  = "OS".$this->PharmacySalesBill->generateRandomBillNo();
					$this->request->data['PharmacySalesBill']['account_id'] = $userId;
					$this->request->data['PharmacySalesBill']['total'] = $this->request->data['PharmacySalesBill']['total'];
					$this->request->data['PharmacySalesBill']['discount'] = $this->request->data['PharmacySalesBill']['discount'];
					//$this->request->data['PharmacySalesBill']['modified_time'] = $this->DateFormat->formatDate2STD($this->request->data['PharmacySalesBill']['m_date'],Configure::read('date_format'));  
					$this->PharmacySalesBill->create();
					$this->PharmacySalesBill->save($this->request->data);
					}
					$get_last_insertID = $this->PharmacySalesBill->getLastInsertId();

					if($this->request->data['PharmacySalesBill']['payment_mode'] == 'Cash'){
						if(!empty($get_last_insertID)){
							$this->request->data['PharmacySalesBill']['id'] = $get_last_insertID;
							$this->request->data['PharmacySalesBill']['paid_amnt'] = round($this->request->data['PharmacySalesBill']['total'] - $this->request->data['PharmacySalesBill']['discount']);
							$this->PharmacySalesBill->save($this->request->data);
							$this->PharmacySalesBill->id = "";
						}
							
					}

					//BOF jv accounting-amit jain
				
					$getPatientDetails = $this->Account->getAccountDetails($userId);
					$doneDate  =  $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
					$amoutPhar = round($this->request->data['PharmacySalesBill']['total']);
					if($this->request->data['PharmacySalesBill']['payment_mode']=='Credit' || $this->request->data['is_staff']==true){
						$accountId = $this->Account->getAccountIdOnly(Configure::read('pharmacy_sale_Label'));//for Account id
						$narration = 'Being pharmacy drugs charged to pt. '.$getPatientDetails['Account']['name']." ".'done on '.$doneDate;

						$jvData = array(
									'date'=> date('Y-m-d H:i:s'),
									'user_id'=>$accountId,
									'account_id'=>$userId ,
									'debit_amount'=>$amoutPhar,
									'type'=>'DirectPharmacyCharges',
									'narration'=>$narration);
						$this->VoucherEntry->insertJournalEntry($jvData);
						$this->VoucherEntry->id='';
						$this->Account->setBalanceAmountByAccountId($accountId,$amoutPhar,'debit');
						$this->Account->setBalanceAmountByUserId($userId,$amoutPhar,'credit');
							
					}


					//EOF jv
					//BOF RV
					//commented by pankaj as there should not be rv entry for direct sale

					if($this->request->data['PharmacySalesBill']['payment_mode']=='Cash' && $this->request->data['is_staff']==false){
						$cashId = $this->Account->getAccountIdOnly(Configure::read('cash'));//for cash id
						$custoName = $this->request->data['PharmacySalesBill']['customer_name'];
						$narration = "Being pharmacy drugs amount received to pt. $custoName done on $doneDate";
						$voucherLogDataFinalpayment=$rvData = array(
									'date'=>date('Y-m-d H:i:s'),
									'modified_by'=>$this->Session->read('userid'),
									'create_by'=>$this->Session->read('userid'),
									'account_id'=>$cashId,
									'user_id'=>$userId,
									'type'=>'DirectPharmacyCharges',//for tem user type for pharmacy
									'narration'=>$narration,
									'paid_amount'=>$amoutPhar);
						$lastVoucherIdRecFinal=$this->AccountReceipt->insertReceiptEntry($rvData);
						//insert into voucher_logs table added by PankajM
						$voucherLogDataFinalpayment['voucher_no']=$lastVoucherIdRecFinal;
						$voucherLogDataFinalpayment['voucher_id']=$lastVoucherIdRecFinal;
						$voucherLogDataFinalpayment['voucher_type']="Receipt";
						$this->VoucherLog->insertVoucherLog($voucherLogDataFinalpayment);
						//End
						$this->VoucherLog->id= '';
						$this->AccountReceipt->id= '';
						// ***insert into Account (By) credit manage current balance
						$this->Account->setBalanceAmountByAccountId($userId,$amoutPhar,'debit');
						$this->Account->setBalanceAmountByUserId($cashId,$amoutPhar,'credit');
					}
					//EOF rv

					$errors = $this->PharmacySalesBill->invalidFields();
					if(!empty($errors)) {
						$this->set("errors", $errors);
					} else {
						if($this->PharmacySalesBillDetail->saveBillDetails($this->request->data,$get_last_insertID)){
							//	$this->Session->setFlash(__('The Sales Bill has been saved', true));
							$this->Session->setFlash(__("The Sales Bill has been saved for Bill No: <b>".$this->request->data['PharmacySalesBill']['bill_code']."</b>", true),'default',array('class'=>'stillSuccess','id'=>'stillFlashMessage'),'still');
								
						}
						if(isset($this->request->data['notInItemRate'])){
							$data = array();
							for($i=0;$i<count($this->request->data['notInItemRate']['mrp']);$i++){
								$data['PharmacyItemRate'][$i]['sale_price'] = $this->request->data['rate'][$i];
								$data['PharmacyItemRate'][$i]['mrp'] = $this->request->data['mrp'][$i];
								$data['PharmacyItemRate'][$i]['item_id'] = $this->request->data['notInItemRate']['mrp'][$i+1];
									
							}
							$this->PharmacyItemRate->saveAll($data['PharmacyItemRate']);
						}
						if(isset($this->request->data['redirect_to_billing'])){
							$url = Router::url(array("controller" => "Billings", "action" => "patient_information",$patient['Patient']['id'],"pharmacy-section",'inventory'=>false));
							echo "<script>window.location.href='".$url."';</script>";

						}else if($this->request->data['print']){
							$url = Router::url(array("controller" => "pharmacy", "action" => "inventory_print_view",'PharmacySalesBill',$this->PharmacySalesBill->id,'inventory'=>true));
							echo "<script>window.open('".$url."','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true )</script>";
						}else{
//							$this->redirect(array("controller" => "pharmacy", "action" => "get_other_pharmacy_details",'sales','inventory'=>true));
						$this->redirect(array("controller" => "pharmacy", "action" => "other_sales_bill", '?'=>array('print'=>'print','id'=>$get_last_insertID,$status), 'inventory'=>true));
						}
					}
				}
			}
		}
	}

	/* for sales return */
	public function inventory_sales_return($type=NULL,$returnId=NULL) {
		$this->layout = 'advance';
		$this->set('title_for_layout', __('Pharmacy Management - Sales Return', true));
		$this->loadModel('Patient');
		$this->loadModel('Account');
		$this->loadModel('VoucherEntry');
		$this->loadModel("ServiceCategory");
		$this->loadModel("Billing");
		$this->loadModel("Configuration");
		
		$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website')));
		$websiteConfig = unserialize($website_service_type['Configuration']['value']);
		if($websiteConfig['instance']=='kanpur'){
			$mode_of_payment = array('Cash'=>'Cash','Credit'=>'Credit');
		}
		$this->set('mode_of_payment',$mode_of_payment);
		if ($this->request->is('post') && !empty($this->request->data)) {
			
			if($type=='sales_return_edit'){
				//Stock update on edit return
				foreach($this->request->data['item_id'] as $key=>$stockUpdate){
					$item = $this->PharmacyItem->find('first',array('conditions' =>
					array("PharmacyItem.id"=>$stockUpdate,"PharmacyItem.location_id" => $this->Session->read('locationid'))));
						
					$itemRate = $this->PharmacyItemRate->find('first',array('conditions' =>
					array("PharmacyItemRate.item_id"=>$stockUpdate,"PharmacyItemRate.batch_number" =>$this->request->data['batch_number'][$key])));
						
					$item['PharmacyItem']['stock']=$item['PharmacyItem']['stock']-$this->request->data['pre_sold_qty'][$key];
					$itemRate['PharmacyItemRate']['stock']=$itemRate['PharmacyItemRate']['stock']-$this->request->data['qty'][$key];
					$this->PharmacyItem->save($item);
					$this->PharmacyItemRate->save($itemRate);


				}
				$this->request->data['InventoryPharmacySalesReturn']['id']=$returnId;
				$this->InventoryPharmacySalesReturn->save($this->request->data);
				/******************** Deleteing the previous records of sales bill********************************/
				$this->InventoryPharmacySalesReturnsDetail->deleteAll(array('InventoryPharmacySalesReturnsDetail.inventory_pharmacy_sales_return_id' =>$returnId));
				/******************** EOF Deleteing***************************************************************/

				if($this->InventoryPharmacySalesReturnsDetail->saveSaleReturn($this->request->data,$returnId)){
					$this->Session->setFlash(__('The Sale Return Details has been updated', true));
					$this->redirect('/inventory/Pharmacy/pharmacy_details/sales_return');
				}

				//EOF stock update
					
			}else{ 
				if(trim($this->request->data['InventoryPharmacySalesReturn']['party_code'])!=""){
					
					/* patient Location id purposely removed to access patient at any loaction - Mrunal  */
					//$conditions["Patient.location_id"] =$this->Session->read('locationid');
					$conditions["Patient.admission_id"] =$this->request->data['ar']['person_id'];
					$Patient = $this->Patient->find('first', array('conditions'=>$conditions));
					$this->request->data['InventoryPharmacySalesReturn']['patient_id'] = $this->request->data['InventoryPharmacySalesReturn']['person_id'];
				}else{
					$this->request->data['InventoryPharmacySalesReturn']['customer_name']  = $this->request->data['InventoryPharmacySalesReturn']['party_name'];
				}
				
				if($this->request->data['InventoryPharmacySalesReturn']['admission_type'] != "IPD"){
					$this->request->data['InventoryPharmacySalesReturn']['modified_time'] = date('Y-m-d H:i:s');
				}
				//debug($this->request->data);exit;
				$this->request->data['InventoryPharmacySalesReturn']['total'] = round($this->request->data['InventoryPharmacySalesReturn']['total']);
				$this->request->data['InventoryPharmacySalesReturn']['discount'] = round($this->request->data['InventoryPharmacySalesReturn']['discount']);
				$this->request->data['InventoryPharmacySalesReturn']['return_date'] = date('Y-m-d H:i:s');
				$this->request->data['InventoryPharmacySalesReturn']['create_time'] = date('Y-m-d H:i:s');
				$this->request->data['InventoryPharmacySalesReturn']['created_by'] = $this->Auth->user('id');
				$this->request->data['InventoryPharmacySalesReturn']['location_id'] = $this->Session->read('locationid');
				
				if($this->Session->read('locationid')=='25'|| $this->Session->read('locationid')=='26'){
					$this->request->data['InventoryPharmacySalesReturn']['bill_code'] = $this->InventoryPharmacySalesReturn->generateSalesReturnBillNoForKanpur($this->Session->read('locationid'));
				}else{
				$this->request->data['InventoryPharmacySalesReturn']['bill_code'] = $this->InventoryPharmacySalesReturn->generateReturnBillNo();
				}
				
				$this->request->data['InventoryPharmacySalesReturn']['discount'] = $this->request->data['InventoryPharmacySalesReturn']['phar_sale_discount'];
				$this->request->data['InventoryPharmacySalesReturn']['discount_amount'] = $this->request->data['InventoryPharmacySalesReturn']['discount_amount'];
				
				$this->InventoryPharmacySalesReturn->create();
				$this->InventoryPharmacySalesReturn->save($this->request->data);
					
				/*****************Return to patient card  for vadodara and hope-Pooja**************************/
				if($this->Session->read('website.instance')!='kanpur'){
					if($this->request->data['InventoryPharmacySalesReturn']['return_card']=='1'){
						$this->loadModel('Patient');
						$this->loadModel('Account');
							
						$this->Patient->bindModel(array(
						'belongsTo'=>array('Account'=>array('foreignKey'=>false,
							'conditions'=>array('Patient.person_id=Account.system_user_id','Account.user_type'=>'Patient'))						
						)));
							
						$cardDetail=$this->Patient->find('first',array('fields'=>array('Patient.person_id','Account.id','Account.card_balance'),
											'conditions'=>array('Patient.id'=>$this->request->data['InventoryPharmacySalesReturn']['patient_id'])));
						$cardDetail['Account']['card_balance']=$cardDetail['Account']['card_balance']+$this->request->data['InventoryPharmacySalesReturn']['total'];
							
						$this->Account->updateAll(array('Account.card_balance'=>"'".$cardDetail['Account']['card_balance']."'"),
						array('Account.id'=>$cardDetail['Account']['id']));
							
						$cashId=$this->Account->getAccountIdOnly('cash');
						$this->loadModel(PatientCard);
						$this->PatientCard->save(array(
								'person_id'=>$cardDetail['Patient']['person_id'],
								'account_id'=>$cardDetail['Account']['id'],
								'type'=>'refund',
								'amount'=>$this->request->data['InventoryPharmacySalesReturn']['total'],
								'bank_id'=>$cashId,
								'mode_type'=>'Cash',
								'created_by'=>$this->Session->read('userid'),
								'create_time'=>date('Y-m-d H:i:s'),
						)
						);
					}
				}
				
				$saveIntoBilling = false; 
				$billingData = array();
				
				//if instance is kanpur and for OPD patient then direct Refund 	by Mrunal
				if($this->request->data['InventoryPharmacySalesReturn']['admission_type'] != "IPD" && strtolower($this->Session->read('website.instance')) == "kanpur"){
					$billingData['paid_to_patient'] = round($this->request->data['InventoryPharmacySalesReturn']['total']-$this->request->data['InventoryPharmacySalesReturn']['discount']);
				 	$billingData['total_amount'] = round($this->request->data['InventoryPharmacySalesReturn']['total']);
				 	$billingData['amount'] = 0;
				 	$billingData['refund'] = '1';
					$saveIntoBilling = true;
				}
				//save into billing by swapnil 02.03.2015 
				if($this->request->data['InventoryPharmacySalesReturn']['is_cash'] == 1){
					$billingData['paid_to_patient'] = round($this->request->data['InventoryPharmacySalesReturn']['cash_collected']);
				 	$billingData['total_amount'] = round($this->request->data['InventoryPharmacySalesReturn']['cash_collected']);
				 	$billingData['amount'] = round($this->request->data['InventoryPharmacySalesReturn']['cash_collected']);
				 	$billingData['refund'] = round($this->request->data['InventoryPharmacySalesReturn']['is_cash']);
					$saveIntoBilling = true;
				}
				
				if($saveIntoBilling == true){ 
					$billingData['date']=date("Y-m-d H:i:s");
					$billingData['patient_id']=$this->request->data['InventoryPharmacySalesReturn']['patient_id'];
					$billingData['payment_category']=$payment_category;
					$billingData['location_id']=$this->Session->read('locationid');
					$billingData['created_by']=$this->Session->read('userid');
					$billingData['create_time']=date("Y-m-d H:i:s");
					$billingData['mode_of_payment']="Cash"; 
				 	
				 	$this->Billing->save($billingData);
				 	//$this->Billing->id = "";
				 	$billingId = $this->Billing->getLastInsertID();
				}

				//update billing_id into sales return by swapnil	14.04.2015
				$saveData = array('id'=>$this->InventoryPharmacySalesReturn->getLastInsertId(),'billing_id'=>$billingId);
				$this->InventoryPharmacySalesReturn->save($saveData);
				 
				/*********************EOF return patient card**************************************************/
					
				//BOF jv accounting-amit jain
				/* $accountId = $this->Account->getAccountIdOnly(Configure::read('pharmacy_sale_Label'));//for Account id
				 //for person id
				 $getPatientDetails=$this->Patient->find('first',array('conditions'=>array('Patient.id'=>$this->request->data['InventoryPharmacySalesReturn']['person_id']),'fields'=>array('person_id','lookup_name','form_received_on')));
				 $personId = $getPatientDetails['Patient']['person_id'];
				 $getAccDetails = $this->Account->getAccountID($personId,'Patient');//for user id
				 $userId = $getAccDetails['Account']['id'];

				 $regDate  =  $this->DateFormat->formatDate2Local($getPatientDetails['Patient']['form_received_on'],Configure::read('date_format'),true);
				 $doneDate  =  $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
				 $narration = 'Being pharmacy drugs returned towards to patient '.$getPatientDetails['Patient']['lookup_name']." (Date of Registration :".$regDate.")".'done on '.$doneDate;

				 $jvData = array('date'=> date('Y-m-d H:i:s'),
				 'user_id'=>$userId,
				 'account_id'=>$accountId,
				 'billing_id'=>$this->InventoryPharmacySalesReturn->getLastInsertID(),
				 'debit_amount'=>$this->request->data['InventoryPharmacySalesReturn']['total'],
				 'type'=>'PharmacyCharges',
				 'narration'=>$narration,
				 'patient_id'=>$this->request->data['InventoryPharmacySalesReturn']['person_id']);
				 $this->VoucherEntry->insertJournalEntry($jvData);
				 // ***insert into Account (By) credit manage current balance
				 $this->Account->setBalanceAmountByAccountId($accountId,$this->request->data['InventoryPharmacySalesReturn']['total'],'debit');
				 $this->Account->setBalanceAmountByUserId($userId,$this->request->data['InventoryPharmacySalesReturn']['total'],'credit'); */
				//EOF jv

				$get_last_insertID = $this->PharmacySalesBill->getLastInsertId();
				
				$errors = $this->PharmacySalesBill->invalidFields();
				if(!empty($errors)) {
					$this->set("errors", $errors);
				} else {
					
					$this->InventoryPharmacySalesReturnsDetail->saveSaleReturn($this->request->data,$this->InventoryPharmacySalesReturn->id);
					$this->Session->setFlash(__('The Sale Return Details has been saved', true));

					$get_last_insertID = $this->InventoryPharmacySalesReturn->getLastInsertId();
					if($this->request->data['print']){
						$url = Router::url(array("controller" => "pharmacy", "action" => "inventory_print_view",'InventoryPharmacySalesReturn',$this->InventoryPharmacySalesReturn->id,'inventory'=>true));

						echo "<script>window.open('".$url."','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true )</script>";
					}else{
						$this->redirect(array("controller" => "pharmacy", "action" => "sales_return" ,'?'=>array('print'=>'print','id'=>$get_last_insertID),'inventory'=>true));
					}

				}
			}
		}//


		if($type=="sales_return_edit"){
			if(!empty($returnId)){
		
				$editReturn=$this->InventoryPharmacySalesReturn->find('first',array(
						'conditions'=>array('InventoryPharmacySalesReturn.id'=>$returnId,'InventoryPharmacySalesReturn.is_deleted'=>'0')));
				$this->set('editReturn',$editReturn);
				//debug($editReturn);
				$this->PharmacyItem->bindModel(array(
					'belongsTo' => array(
							'PharmacySalesBillDetail' =>array('foreignKey' => false),
				array('conditions'=>array('PharmacySalesBillDetail.item_id = PharmacyItem.id')),
							'PharmacySalesBill' =>array('foreignKey' => false),array('PharmacySalesBill.id = PharmacySalesBillDetail.pharmacy_sales_bill_id','PharmacySalesBill.is_deleted' =>'0')
				)

				));

				foreach($editReturn['InventoryPharmacySalesReturnsDetail'] as $item){
					$data=$this->PharmacyItem->find('first',array('conditions'=>array('PharmacySalesBill.patient_id'=>$editReturn['Patient']['id'],
							'PharmacyItem.id'=>$item['item_id'],'PharmacyItemRate.batch_number'=>$item['batch_no'])));
					$itemArray[$item['item_id']]['item_name']=$data['PharmacyItem']['name'];
					$itemArray[$item['item_id']]['manufacturer']=$data['PharmacyItem']['manufacturer'];
					$itemArray[$item['item_id']]['item_code']=$data['PharmacyItem']['item_code'];
					$itemArray[$item['item_id']]['sold_qty']=$data['PharmacySalesBillDetail']['qty'];
					$itemArray[$item['item_id']]['mrp']=$data['PharmacyItemRate']['mrp'];
					$itemArray[$item['item_id']]['price']=$data['PharmacyItemRate']['mrp']/*['sale_price']*/;
					$itemArray[$item['item_id']]['pack']=$data['PharmacyItem']['pack'];
					$itemArray[$item['item_id']]['stock']=$data['PharmacyItem']['stock'];
						
						
				}
				$this->set('itemArray',$itemArray);
			}
		}
	}
	/* for sales return details */
	public function inventory_sales_return_detail($sale_return_id = null) {

		if($sale_return_id !=null){
			$returnDetails = $this->InventoryPharmacySalesReturn->find('first',$sale_return_id,array('conditions' => array("InventoryPharmacySalesReturn.location_id" =>$this->Session->read('locationid'))));
			$this->set("data", $returnDetails);
		}else{
			$this->Session->setFlash(__('Invalid Sales Return', true));
			$this->set("data", array());
		}
	}

	/* for purchase details */
	public function inventory_purchase_details($autocomplete = null,$field = null) {
		$this->layout = false;
		if($autocomplete != null){
			$searchKey = $this->params->query['q'];
			$filedOrder = array($field,'id');
			$conditions[$field." like"] = $searchKey."%";
			$conditions["location_id"] =$this->Session->read('locationid');
			$items = $this->InventoryPurchaseDetail->find('list', array('fields'=> $filedOrder,'conditions'=>$conditions));
			$output ='';
			foreach ($items as $key=>$value) {
				$output .= "$key|$value";
				$output .= "\n";
			}
			echo $output;
		}else{
			$conditions["InventoryPurchaseDetail.id"] = $this->request->data['id'];
			$conditions["InventoryPurchaseDetail.location_id"] = $this->Session->read('locationid');
			$purchaseDetail = $this->InventoryPurchaseDetail->find('first', array('conditions'=>$conditions));
			$purchaseDetail['InventoryPurchaseDetail']['vr_date'] =  $this->DateFormat->formatDate2Local($purchaseDetail['InventoryPurchaseDetail']['vr_date'],Configure::read('date_format'));
			foreach($purchaseDetail['InventoryPurchaseItemDetail'] as $key=>$value){

				$purchaseDetail['InventoryPurchaseItemDetail'][$key]['expiry_date'] = $this->DateFormat->formatDate2Local($value['expiry_date'],Configure::read('date_format'));
			}
			echo json_encode($purchaseDetail);
		}
		exit;
	}
	/* for purchase return details */
	public function inventory_purchase_return_details($autocomplete = null,$field = null) {
		$this->layout = false;
		$conditions["InventoryPurchaseReturn.party_id"] = $this->request->data['supplierId'];
		$conditions["InventoryPurchaseReturn.location_id"] = $this->Session->read('locationid');
		$purchaseDetail = $this->InventoryPurchaseReturn->find('all', array('conditions'=>$conditions));
		foreach($purchaseDetail as $key=>$value){
			$purchaseDetail[$key]['InventoryPurchaseReturn']['total_amount'] = number_format($purchaseDetail[$key]['InventoryPurchaseReturn']['total_amount'],2);
			$purchaseDetail[$key]['InventoryPurchaseReturn']['create_time'] = $this->DateFormat->formatDate2Local($purchaseDetail[$key]['InventoryPurchaseReturn']['create_time'],Configure::read('date_format'),true);
		}
		echo json_encode($purchaseDetail);
		exit;
	}
	/* to rate a  item*/
	public function inventory_item_rate_master($item_id = null,$layout = null,$fieldNo = null){

		$this->layout = "advance";
		$this->loadModel('Configuration');
		$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website')));
		$websiteConfig=unserialize($website_service_type['Configuration']['value']);
		$this->set('websiteConfig',$websiteConfig);

		if($this->params->query['flag']=='1'){  //open in fancybox without header
			$this->layout ='advance_ajax'; //to include all js and css with ajax layout
			$this->set('flagForBack',1);// it include to display fancybox without back btn
		}

		if($layout!=null){
			$this->layout='default';
			$this->set("is_layout",1);
		}
		if($fieldNo!=null){
			$this->set("fieldNo",$fieldNo);
		}

		$this->set('title_for_layout', __('Pharmacy Management - Item Rate Master', true));
		
		if ($this->request->is('post') && !empty($this->request->data)) {
			if($this->request->data['item_id']){ 
				$item_id = $this->request->data['item_id'];
				
				$isBatchExist = $this->PharmacyItemRate->find('first',array('conditions'=>array(
						'PharmacyItemRate.batch_number'=>$this->request->data['PharmacyItemRate']['batch_number'],'PharmacyItemRate.item_id'=>$item_id)));
				 
				if(!empty($isBatchExist['PharmacyItemRate']['id'])){
					$this->Session->setFlash(__('Item batch is already exist, please choose another batch or edit batch'), 'default', array('class' => 'error'));
					return $this->redirect($this->referer());
				}else{
					$saveData = $this->request->data['PharmacyItemRate'];
					$saveData['item_id'] = $item_id;
					$saveData['location_id'] = $this->Session->read('locationid');
					$saveData['expiry_date'] = $this->DateFormat->formatDate2STD($saveData['expiry_date'],Configure::read('date_format'));
					$totalStock = $saveData['stock'];
					$saveData['stock'] = floor($totalStock / $this->request->data['pack']);
					$saveData['loose_stock'] = floor($totalStock % $this->request->data['pack']);
					$this->PharmacyItemRate->saveAll($saveData);
					
					if($this->updatePharmacyItemStock($item_id) == true){
						$this->Session->setFlash(__('Item batch saved successfully',true));
					}else{
						$this->Session->setFlash(__('Item batch could not saved'), 'default', array('class' => 'error'));
					}
				}
			}else{
				$this->Session->setFlash(__('Item name doesnot exist'), 'default', array('class' => 'error'));
				return $this->redirect($this->referer());
			}
			 
			$errors = $this->PharmacyItemRate->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				if($layout!=null){
					$o = "<script>parent.$.fancybox.close('ffff','fffffffff')</script>";
					echo $o;
				}else{
					$this->Session->setFlash(__('Item rate successfully added', true));
					if($this->params->query['flag']=='1'){
						$this->redirect($this->referer());
					}
					$this->redirect(array("controller" => "pharmacy", "action" => "view_item_rate",'inventory'=>false));
				}
			}
		} 
	}
	
	
	
	/* for fetch the rate from batch number*/
	public function inventory_fetch_rate_from_batch_no(){

		if($this->params->query['source'] == 'saleReturn'){
			$item = $this->PharmacyItemRate->find('first', array('conditions'=>
			array('PharmacyItemRate.batch_number' =>$this->params->query['batchno'],'PharmacyItemRate.item_id' =>$this->params->query['item_id'] )));
			if(!empty($item)){
				$item['PharmacyItemRate']['purchase_price'] = number_format($item['PharmacyItemRate']['purchase_price'],2);
				if(!empty($item['PharmacyItemRate']['expiry_date']))
				$item['PharmacyItemRate']['expiry_date'] = $this->DateFormat->formatDate2Local($item['PharmacyItemRate']['expiry_date'],Configure::read('date_format'));
				$item['PharmacyItemRate']['cost_price'] = number_format($item['PharmacyItemRate']['cost_price'],2);
				$item['PharmacyItemRate']['sale_price'] = number_format($item['PharmacyItemRate']['sale_price'],2);
				$item['PharmacyItemRate']['mrp'] = number_format($item['PharmacyItemRate']['mrp'],2);
				echo json_encode($item);
			}else{
				$this->use= array("InventoryPurchaseItemDetail");
				$item_rate_detail = $this->InventoryPurchaseItemDetail->find("first",array("conditions"=>array("InventoryPurchaseItemDetail.batch_no"=>$this->params->query['batchno'])));
				if(!empty($item_rate_detail['InventoryPurchaseItemDetail']['expiry_date']))
				$item_rate_detail['InventoryPurchaseItemDetail']['expiry_date'] = $this->DateFormat->formatDate2Local($item_rate_detail['InventoryPurchaseItemDetail']['expiry_date'],Configure::read('date_format'));

				echo json_encode($item_rate_detail);
			}
		}else{
			$this->use= array("InventoryPurchaseItemDetail");
			$item_rate_detail = $this->InventoryPurchaseItemDetail->find("first",array("conditions"=>array("InventoryPurchaseItemDetail.batch_no"=>$this->params->query['batchno'])));
			if(!empty($item_rate_detail['InventoryPurchaseItemDetail']['expiry_date']))
			$item_rate_detail['InventoryPurchaseItemDetail']['expiry_date'] =$this->DateFormat->formatDate2Local($item_rate_detail['InventoryPurchaseItemDetail']['expiry_date'],Configure::read('date_format'));

			echo json_encode($item_rate_detail);
		}
		exit;
	}
	
	/* for autocomplete */
	public function inventory_autocomplete_item($field=null){

		$searchKey = $this->params->query['term'];
		$filedOrder = array('id');
		
		if($field == "name"){
			array_push( $filedOrder,'item_code','name');
		}else{
			array_push( $filedOrder,'name','item_code');
		}
		 
		$conditions[$field." LIKE"] = "%".$searchKey."%";
		if($this->Session->read('website.instance')=='hope'){ //location id cond is not requeired for vadoaara
			$conditions["PharmacyItem.location_id"] =$this->Session->read('locationid');
			$conditions[] = array('OR'=>array("PharmacyItem.stock > 0", "PharmacyItem.loose_stock > 0"));
		}else if($this->Session->read('website.instance')=='vadodara'){
			 /* condition for vadodara */
			$conditions[] = array('OR'=>array("PharmacyItem.stock > 0", "PharmacyItem.loose_stock > 0"));
		}else if($this->Session->read('website.instance')=='kanpur'){
			$conditions["PharmacyItem.location_id"] =$this->Session->read('locationid');
		}
		$conditions[] = array("OR"=>array("PharmacyItem.drug_id !=" =>'0', "PharmacyItem.DrugInfo"=>"OR_IMPLANT"));
		$conditions["PharmacyItem.is_deleted"] ='0';
		
		$this->PharmacyItem->recursive = -1;
		$items = $this->PharmacyItem->find('all', array('fields'=> $filedOrder,'conditions'=>$conditions,'limit'=>15/*,'group' => 'PharmacyItem.item_code'*/));
		
		foreach ($items as $key=>$value) {
			foreach ($value as $k=>$v) { 
			}
			if($field == "name"){
				$output[] = array('id'=>$value['PharmacyItem']['id'],'value'=>$value['PharmacyItem']['name'],'item_code'=>$value['PharmacyItem']['item_code'],'discount'=>$value['PharmacyItem'][$discountType]);
			}else{
				$output[] = array('id'=>$value['PharmacyItem']['id'],'value'=>$value['PharmacyItem']['item_code'],'name'=>$value['PharmacyItem']['name'],'discount'=>$value['PharmacyItem'][$discountType]);
			}
		}
		echo json_encode($output);
		exit;//dont remove this
	}
	
	
	/* for autocomplete duplicate sale bill - by swapnil 07.08.2015 */
	public function inventory_autocomplete_item_for_duplicate_sales($field=null){
	
		$searchKey = $this->params->query['term'];
		$filedOrder = array('id');
	
		if($field == "name"){
			array_push( $filedOrder,'item_code','name');
		}else{
			array_push( $filedOrder,'name','item_code');
		}
			
		$conditions[$field." LIKE"] = $searchKey."%";
		if($this->Session->read('website.instance')=='hope'){ //location id cond is not requeired for vadoaara
			$conditions["PharmacyItem.location_id"] =$this->Session->read('locationid'); 
		} 
		$conditions[] = array("OR"=>array("PharmacyItem.drug_id !=" =>'0', "PharmacyItem.DrugInfo"=>"OR_IMPLANT"));
		$conditions["PharmacyItem.is_deleted"] ='0';
	
		$this->PharmacyItem->recursive = -1;
		$items = $this->PharmacyItem->find('all', array('fields'=> $filedOrder,'conditions'=>$conditions,'limit'=>15/*,'group' => 'PharmacyItem.item_code'*/));
	
		foreach ($items as $key=>$value) {
			foreach ($value as $k=>$v) {
			}
			if($field == "name"){
				$output[] = array('id'=>$value['PharmacyItem']['id'],'value'=>$value['PharmacyItem']['name'],'item_code'=>$value['PharmacyItem']['item_code'],'discount'=>$value['PharmacyItem'][$discountType]);
			}else{
				$output[] = array('id'=>$value['PharmacyItem']['id'],'value'=>$value['PharmacyItem']['item_code'],'name'=>$value['PharmacyItem']['name'],'discount'=>$value['PharmacyItem'][$discountType]);
			}
		}
		echo json_encode($output);
		exit;//dont remove this
	}
	
	

	public function vendor_autocomplete_name($field=null,$secondField=null){
		$this->uses = array('InventorySupplier');
		$searchKey = $this->params->query['q'];
		$filedOrder = array('id',$field,$secondField);
		$conditions[$field." like"] = $searchKey."%";
		$conditions["InventorySupplier.location_id"] =$this->Session->read('locationid');
		$conditions["InventorySupplier.is_deleted"] ='0';
		$items = $this->InventorySupplier->find('list', array('fields'=> $filedOrder,'conditions'=>$conditions,'group' => 'InventorySupplier.'.$field));
		foreach ($items as $key=>$value) {
			$output ='';
			foreach ($value as $k=>$v) {
				$output .= "$v|$k";
			}
			$output .= "|$key\n";
			echo $output;

		}

		exit;//dont remove this
	}

	public function inventory_sales_return_item_list($field =null){

		$this->layout = 'advance';
		$this->loadModel('Patient');
		$output ='';
		$pharmacy_item_id = array();
		$pharmacy_item_code = array();
		$pharmacy_item_name = array();
		$pharmacy_item_qty = array();
			
		if($this->params->query['patientId']!=""){
				
			$conditions["Patient.location_id"] = $this->Session->read('locationid');
			$conditions["Patient.id"] = $this->params->query['patientId'];
			$pharmacySaleItem = $this->Patient->find("first",array("conditions"=>$conditions));
			//debug($pharmacySaleItem);
			$pharmacy_sale_detail = $pharmacySaleItem['PharmacySalesBill'];
		}else{
			$this->PharmacySalesBill->unbindModel(array("belongsTo"=>array("Patient")));
			$conditions["PharmacySalesBill.customer_name"] = $this->params->query['party_name'];
			$conditions["PharmacySalesBill.location_id"] = $this->Session->read('locationid');
			$pharmacy_sale_detail = $this->PharmacySalesBill->find("all",array("conditions"=>array($conditions,'PharmacySalesBill.is_deleted' =>'0')));

		}
		if($field == "name"){
			$filedOrder = array('id','item_code','name');
		}else{
			$filedOrder = array('id','name','item_code');
		}

		if(count($pharmacy_sale_detail)>0){

			foreach ($pharmacy_sale_detail  as $value) {
				if(isset($value['PharmacySalesBill'])){
					$pharmacy_sales_bill_id = $value['PharmacySalesBill']['id'];
				}else{
					$pharmacy_sales_bill_id = $value['id'];
				}

				$saleDetails = $this->PharmacySalesBillDetail->find("all",array("conditions"=>
				array("PharmacySalesBillDetail.pharmacy_sales_bill_id"=> $pharmacy_sales_bill_id)));

				foreach ($saleDetails as $value) {
					$c["PharmacyItem.id"] = $value['PharmacyItem']['id'];

					$is_exist = in_array($value['PharmacyItem']['id'],$pharmacy_item_id);
					if($is_exist){
						foreach($pharmacy_item_id as $keyId=>$keyValue){
							if($value['PharmacyItem']['id'] == $keyValue){
								//$pharmacy_item_qty[$keyId] =$pharmacy_item_qty[$keyId]+$value['PharmacySalesBillDetail']['qty'];
								//debug($pharmacy_item_qty[$keyId]);
							}
						}

					}else{
						$items = $this->PharmacyItem->find('first', array('fields'=> $filedOrder,'conditions'=>$c,'group' => 'PharmacyItem.item_code'));
						array_push($pharmacy_item_id,$items['PharmacyItem']['id']);
						array_push($pharmacy_item_code,$items['PharmacyItem']['item_code']);
						array_push($pharmacy_item_name,$items['PharmacyItem']['name']);
						array_push($pharmacy_item_qty,$value['PharmacySalesBillDetail']['qty']);

					}
					if($field == "name"){
						$returnArray[] = array('id'=>$value['PharmacyItem']['id'],'item_code'=>$value['PharmacyItem']['item_code'],'value'=>$value['PharmacyItem']['name']);
					}else{
						$returnArray[] = array('id'=>$value['PharmacyItem']['id'],'name'=>$value['PharmacyItem']['name'],'value'=>$value['PharmacyItem']['item_code']);
					}
				}
			}
		}
		foreach($pharmacy_item_id as $keyId=>$keyValue){
			$output .= $pharmacy_item_name[$keyId]."|".$keyValue."|".$pharmacy_item_code[$keyId]."|".$pharmacy_item_qty[$keyId]."\n";
			//$returnArray[] = array( 'id'=>$pharmacy_item_id[$keyId],'value'=>$pharmacy_item_name[$keyId],'code'=>$pharmacy_item_code[$keyId],'quantity'=>$pharmacy_item_qty[$keyId]) ;
		}
		echo json_encode($returnArray);	//by swapnil
		//echo $output;
		//exit;
	}

	/* for autocomplete of Sales return*/
	public function inventory_fetch_rate_for_return_item(){
		//$this->layout = "ajax"; 
		$this->loadModel("TariffStandard");
		$this->layout = 'ajax';
		$website  = $this->Session->read('website.instance');
		if(isset($_POST['tariff'])){
			$tariff = $_POST['tariff'];
			$privateId = $this->TariffStandard->getTariffStandardID( 'privateTariffName');
		}
		if(isset($_POST['item_id'])){

			$this->PharmacySalesBillDetail->bindModel(array(
						'belongsTo'=>array(
							'PharmacySalesBill'=>array(
								'foreignKey'=>false,
								'conditions'=>array('PharmacySalesBillDetail.pharmacy_sales_bill_id=PharmacySalesBill.id')),
							'Patient'=>array('foreignKey'=>false,'conditions'=>array('PharmacySalesBill.patient_id = Patient.id')),
							'Room'=>array('foreignKey'=>false,'conditions'=>array('Patient.room_id = Room.id')))
			));
				
			$item = $this->PharmacySalesBillDetail->find('all',array(
							'fields'=>array('PharmacySalesBillDetail.*','PharmacySalesBill.discount','PharmacySalesBill.total','Patient.id','Patient.admission_type','Room.room_type'),
							'conditions'=>array('PharmacySalesBillDetail.item_id'=>$_POST['item_id'],
													'PharmacySalesBill.patient_id'=>$_POST['patient_id']),
							'order'=>array('PharmacySalesBillDetail.batch_number'=>"DESC")
			));
		
			//by Swapnil to deduct previous return Qty 			20.03.2015
			$this->InventoryPharmacySalesReturn->unbindModel(array('belongsTo'=>array('Patient'))); 
			
			$this->InventoryPharmacySalesReturn->bindModel(array(
						'belongsTo'=>array(
							'InventoryPharmacySalesReturnsDetail'=>array(
								'foreignKey'=>false,
								'conditions'=>array('InventoryPharmacySalesReturnsDetail.inventory_pharmacy_sales_return_id=InventoryPharmacySalesReturn.id')),
							'PharmacyItem'=>array('foreignKey'=>false,
									'conditions'=>array('InventoryPharmacySalesReturnsDetail.item_id = PharmacyItem.id')))));
			
			$returnList = $this->InventoryPharmacySalesReturn->find('first',array(
							'fields'=>array('InventoryPharmacySalesReturnsDetail.*','InventoryPharmacySalesReturn.*','PharmacyItem.*','sum(InventoryPharmacySalesReturnsDetail.qty) as returnSum'),
							'conditions'=>array('InventoryPharmacySalesReturnsDetail.item_id'=>$_POST['item_id'],
													'InventoryPharmacySalesReturn.patient_id'=>$_POST['patient_id'])));
			
			$returnQty = $returnList[0]['returnSum'];	//return Qty of particular product
			
			$batchVar = "";
			$totalTab = 0;
			$dataArr = array();

			foreach($item as $key => $val){
				
				$discountTotal = $val['PharmacySalesBill']['discount'] ;
				$totalPhaSale = $val['PharmacySalesBill']['total'] ;
				
				$curBatch = $val['PharmacySalesBillDetail']['batch_number'];
				if($batchVar != $curBatch){
					$batchVar = $curBatch;
				}
				if($batchVar == $curBatch){
					if($val['PharmacySalesBillDetail']['qty_type'] == "Tab"){
						$qty = $val['PharmacySalesBillDetail']['qty'];
					}else{
						//if the pack is not avaialble
						if($val['PharmacySalesBillDetail']['pack'])
						$pack = $val['PharmacySalesBillDetail']['pack'] ;
						else
						$pack = 1 ;
							
						$qty = $val['PharmacySalesBillDetail']['qty']*(int)$pack;
					}
					$totalTab += $qty;
					$discount = $val['PharmacySalesBill']['discount'] / $val['PharmacySalesBillDetail']['qty'];
				}
			}
			
			$roomType = $item[0]['Room']['room_type']; 
			if($item[0]['Patient']['admission_type'] != "IPD"){
				$roomType = "opd_ward";
			}
			
			$allRoomListarray = array(
					'opd_ward'=>'opdgeneral_ward_discount',
					'general'=>'gen_ward_discount',
					'special'=>'spcl_ward_discount',
					'semi_special'=>'semi_spcl_ward_discount',
					'Delux'=>'dlx_ward_discount',
					'Isolation'=>'islolation_ward_discount');
			
			$discountType = $allRoomListarray[$roomType];
			
			$this->PharmacyItem->unbindModel(array('hasMany'=>array('InventoryPurchaseItemDetail'),'hasOne'=>array('PharmacyItemRate')));
			$this->PharmacyItem->bindModel(array('hasMany'=>array(
						'PharmacyItemRate'=>array('foreignKey'=>'item_id',
													'order'=>array('PharmacyItemRate.expiry_date'=>'ASC'))),
												'belongsTo'=>array(
						'ManufacturerCompany'=>array('foreignKey'=>'manufacturer_company_id'))));
			
			/* Location ID Commented for Vadodara -By MRUNAL*/
			if($this->Session->read('website.instance')=='kanpur'){
				$pharmacyItemData = $this->PharmacyItem->find('first',array('conditions'=>array('PharmacyItem.id'=>$_POST['item_id']/*  ,'PharmacyItem.location_id'=>$this->Session->read('locationid') */)));
			}else{	
				$pharmacyItemData = $this->PharmacyItem->find('first',array('conditions'=>array('PharmacyItem.id'=>$_POST['item_id']/* ,'PharmacyItem.location_id'=>$this->Session->read('locationid') */ )));
			}	
			
			foreach($pharmacyItemData['PharmacyItemRate'] as $key=>$val)
			{
				$pharmacyItemData['PharmacyItemRate'][$key]['expiry_date'] = $this->DateFormat->formatDate2Local($val['expiry_date'],Configure::read('date_format'),false);
				if(strtolower($website) == "hope"/* && $privateId != $tariff*/){	//by swapnil to display sale price as MRP for corporate patient only 19.03.2015
					$pharmacyItemData['PharmacyItemRate'][$key]['sale_price'] = $pharmacyItemData['PharmacyItemRate'][$key]['mrp'];
				}
			}
			
			if(!empty($discountType)/*  && $privateId == $tariff */){
				$pharmacyItemData['PharmacyItem']['itemDiscount'] = $pharmacyItemData['PharmacyItem'][$discountType];
			}
			
			$pharmacyItemData['PharmacyItem']['totalSold'] = $totalTab - $returnQty;
			$pharmacyItemData['PharmacyItem']['itemDiscount'] = $discount;
			$pharmacyItemData['PharmacyItem']['pharmacy_sale_discount_percentage'] = round(($discountTotal*100)/$totalPhaSale);
			
			echo json_encode($pharmacyItemData) ;
			exit;
		}
	}


	/* for autocomplete og Sales bill */
	public function inventory_fetch_rate_for_item(){
		$this->uses = array("TariffStandard","PharmacyItemRate");
		$this->layout = 'ajax';
		$website  = $this->Session->read('website.instance');
		
		if(isset($_POST['tariff'])){
			$tariff = $_POST['tariff'];
			$privateId = $this->TariffStandard->getTariffStandardID( 'privateTariffName');
		}
		
		$discountType = ''; 
		if(isset($_POST['roomType'])){
			$roomType = $_POST['roomType'];
					$allRoomListarray = array(
						'opd_ward'=>'opdgeneral_ward_discount',
						'general'=>'gen_ward_discount',
						'special'=>'spcl_ward_discount',
						'semi_special'=>'semi_spcl_ward_discount',
						'Delux'=>'dlx_ward_discount',
						'Isolation'=>'islolation_ward_discount');
				$discountType = $allRoomListarray[$roomType];
		}
		if(isset($_POST['item_id'])){
			
			$salesBillCond = array();
				
			if(isset($_POST['batch_number']) && !empty($_POST['batch_number'])){
				$varBatch = explode(",",$_POST['batch_number']);
				if(count($varBatch)>1){
					$salesBillCond['PharmacyItemRate.batch_number NOT'] = $varBatch;
				}else{
					$salesBillCond['PharmacyItemRate.batch_number NOT'] = $_POST['batch_number'];
				}
			}
                        $isDuplicate = '1';
			if(!isset($this->request->data['isDuplicate'])){
                            $cond['OR'] = array("PharmacyItemRate.stock > 0","PharmacyItemRate.loose_stock > 0");
                             $isDuplicate = '0';
                        }
			$item = $this->PharmacyItemRate->find('first',array(
					'fields'=>array('PharmacyItem.id','PharmacyItem.item_code','PharmacyItem.pack','PharmacyItem.name','PharmacyItemRate.mrp','PharmacyItem.stock','PharmacyItem.loose_stock','PharmacyItem.pack','PharmacyItem.doseForm',
							'PharmacyItem.generic',"$discountTypeVar",'PharmacyItemRate.*'),
					'conditions'=>array('PharmacyItem.id' =>$this->request->data['item_id'],$salesBillCond, $cond/*'OR'=>array("PharmacyItemRate.stock > 0","PharmacyItemRate.loose_stock > 0")*/,
							'PharmacyItem.drug_id !='=>NULL),
			));
			
			$item['PharmacyItem']['discount'] = $item['PharmacyItem'][$discountType];
			
			if(!empty($item['PharmacyItemRate']))
			{
				$item['PharmacyItemRate']['expiry_date'] = $this->DateFormat->formatDate2Local($item['PharmacyItemRate']['expiry_date'],Configure::read('date_format'),false);
				$item['PharmacyItemRate']['loose_stock'] = $item['PharmacyItemRate']['loose_stock']!=""?$item['PharmacyItemRate']['loose_stock']:0;
				$item['PharmacyItemRate']['sale_price'] = $item['PharmacyItemRate']['mrp'];
			}
			$item['batches'] = $this->getBatches($_POST['item_id'],$isDuplicate);	//fetch batches array
			
			echo (json_encode($item));
			exit;
			/*$this->PharmacyItem->unbindModel(array('hasMany'=>array('InventoryPurchaseItemDetail'),'hasOne'=>array('PharmacyItemRate')));
			if($website !='kanpur'){
				$this->PharmacyItem->bindModel(array(
						'hasMany'=>array(
								'PharmacyItemRate'=>array('foreignKey'=>'item_id',
										'order'=>array('PharmacyItemRate.expiry_date'=>'ASC','PharmacyItemRate.stock'=>'DESC'),
										'conditions'=>array('PharmacyItemRate.is_deleted'=>0 , 'OR'=>array('PharmacyItemRate.stock > 0', 'PharmacyItemRate.loose_stock > 0')))),
						 ));
			}else{	
				$this->PharmacyItem->bindModel(array(
					'hasMany'=>array(
						'PharmacyItemRate'=>array('foreignKey'=>'item_id',
									'order'=>array('PharmacyItemRate.expiry_date'=>'ASC','PharmacyItemRate.stock'=>'DESC'),
									'conditions'=>array('PharmacyItemRate.is_deleted'=>0))),
					),false);
			
			}
			//if private and ward alloted
			if($discountType && $privateId == $tariff){
				$discountTypeVar = 'PharmacyItem.'.$discountType ;
			}
			
			if($website !='kanpur'){
				$item = $this->PharmacyItem->find('first',array(
						'fields'=>array('PharmacyItem.item_code','PharmacyItem.pack','PharmacyItem.name','PharmacyItem.doseForm','PharmacyItem.generic',"$discountTypeVar"),
						'conditions'=>array('PharmacyItem.id' =>$this->request->data['item_id'], 'OR'=>array("PharmacyItem.stock > 0","PharmacyItem.loose_stock > 0"), 
								'PharmacyItem.drug_id !='=>NULL),
				));
			}else if($website =='kanpur'){
				$item = $this->PharmacyItem->find('first',array(
						'fields'=>array('PharmacyItem.item_code','PharmacyItem.pack','PharmacyItem.name','PharmacyItem.doseForm','PharmacyItem.generic'),
						'conditions'=>array('PharmacyItem.id' =>$this->request->data['item_id'],
								'PharmacyItem.location_id'=>$this->Session->read('locationid'),
								'PharmacyItem.drug_id !='=>NULL),
				)); 
			}*/
			
		} 
		//debug($item);
		
		/*$item['PharmacyItem']['discount'] = $item['PharmacyItem'][$discountType];
		
		foreach($item['PharmacyItemRate'] as $key=>$val)
		{
			$item['PharmacyItemRate'][$key]['expiry_date'] = $this->DateFormat->formatDate2Local($val['expiry_date'],Configure::read('date_format'),false);
			$item['PharmacyItemRate'][$key]['loose_stock'] = $item['PharmacyItemRate'][$key]['loose_stock']!=""?$val['loose_stock']:0;
			
			 	 
		}

		if(!empty($item['PharmacyItemRate']['expiry_date'])){
			$item['PharmacyItemRate']['expiry_date'] = $this->DateFormat->formatDate2Local($item['PharmacyItemRate']['expiry_date'],Configure::read('date_format'),false);
		}
		if(!empty($item['PharmacyItem']['date']))
		$item['PharmacyItem']['date'] = $this->DateFormat->formatDate2Local($item['PharmacyItem']['date'],Configure::read('date_format'),true);
		echo (json_encode($item));
		exit;*/

	}

	
	//function to get the batches of any products
	public function getBatches($itemId,$isDuplicate){
		$pharmacyItem = $this->PharmacyItem->read('pack',$itemId);
		$this->uses = array('PharmacyItemRate'); 
                if($isDuplicate == 0){
                    $cond['OR'] = array("PharmacyItemRate.stock > 0","PharmacyItemRate.loose_stock > 0");
                }
		$rates = $this->PharmacyItemRate->find('all',array('fields'=>array(
			'PharmacyItemRate.id','PharmacyItemRate.batch_number','PharmacyItemRate.loose_stock','PharmacyItemRate.stock'),'conditions'=>array('PharmacyItemRate.item_id'=>$itemId,$cond/*, 'OR'=>array("PharmacyItemRate.stock > 0","PharmacyItemRate.loose_stock > 0")*/)));
		$pack = $pharmacyItem['PharmacyItem']['pack'];
		foreach($rates as $key => $val){
			//by swapnil to append the quantity with batch number - 03.02.2016
			$totStock = ($val['PharmacyItemRate']['stock'] * $pack) + $val['PharmacyItemRate']['loose_stock'];
			$returnArray[$val['PharmacyItemRate']['id']] = $val['PharmacyItemRate']['batch_number']." (".$totStock.")";
		}
		return $returnArray;
	}
	//EOF getBatches
	
	
	/* for fetch the patient details */
	public function inventory_fetch_patient_detail($field=null,$parConditions = null, $allEncounter = null){
		$this->loadModel('Patient');
		$this->loadModel('TariffStandard');
		$this->loadModel('Room');
		//$searchKey = $this->params->query['q'];	//by Swapnil
		
		$privateId = $this->TariffStandard->getTariffStandardID( 'privateTariffName');
		$this->Patient->bindModel(array(
				'belongsTo'=>array(
					'TariffStandard'=>array('foreignKey'=>'tariff_standard_id'),
					'Room'=>array('foreignKey'=>false,'conditions'=>array('Room.id = Patient.room_id')),
				)));
		
		$searchKey = $this->params->query['term']; 
		$paraCond = '';
		
		if($parConditions == "non-discharge" && $this->Session->read('website.instance') != "hope"){
			//$paraCond = 'Patient.is_discharge=0';
		}
		
		//by swapnil 10.04.2015
		//(non discharge and private) OR (all non_private)
		if($parConditions == "saleBill" && $this->Session->read('website.instance') != "hope"){
			//$paraCond['OR'] = array('AND'=>array('Patient.is_discharge'=>0,'Patient.tariff_standard_id'=>$privateId),'Patient.tariff_standard_id NOT'=>$privateId);
		} 
		
		$filedOrder = array();
		if($field == "admission_id"){
			$filedOrder = array('Patient.id','Room.room_type','Patient.admission_id','Patient.lookup_name','Patient.patient_id','Patient.form_received_on','Patient.admission_type','TariffStandard.id','TariffStandard.name');
		}else{
			$filedOrder = array('Patient.id','Room.room_type','Patient.lookup_name','Patient.admission_id','Patient.patient_id','Patient.form_received_on','Patient.admission_type','TariffStandard.id','TariffStandard.name');
		}
		 
		$conditions["Patient.admission_id like"] = '%'.$searchKey.'%'; 
		//$conditions["Patient.admission_id like"] = '%'.$searchKey.'%';
		$conditions["Patient.lookup_name like"] ='%'.$searchKey.'%';
		
		$this->Patient->virtualFields = array( 'patient_max_id' => 'MAX(Patient.id)' );
		$cond = array();
		
		if(!empty($allEncounter) && $allEncounter == 1){
			//to fetch alll encounter
			$cond[] = array('OR'=>$conditions,$paraCond); 
		}else{
			//to fetch only last encounter of particular patient
			$patientIDs = $this->Patient->find('list',array('fields'=>array('id','patient_max_id'),
					'conditions'=>array('Patient.is_discharge=0','Patient.is_deleted=0','OR'=>$conditions,$paraCond),
					'limit'=>Configure::read('number_of_rows'),'group'=>array('Patient.patient_id')));
			$cond[] = array('Patient.id'=>$patientIDs);
		}
		
		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						'TariffStandard'=>array('foreignKey'=>'tariff_standard_id'),
						'Room'=>array('foreignKey'=>false,'conditions'=>array('Room.id = Patient.room_id')),
				)));
		
		
		/* if($parConditions == "IPD"){
			$items = $this->Patient->find('all', array(
						'fields'=> $filedOrder,
						'conditions'=>array('OR'=>($conditions),
						'Patient.is_deleted=0',$discharge,'Patient.admission_type'=>'IPD'),'limit'=>10,'order'=>array("Patient.lookup_name ASC")));
		}else{ */
		
		$items = $this->Patient->find('all', array(
				'fields'=> $filedOrder,
				'conditions'=>array($cond,
						'Patient.is_deleted=0'),'limit'=>10,'order'=>array("Patient.id DESC"),/* 'group'=>'Patient.Person_id' */));
		
		//debug($items);
		//commneted by swapnil on 05.09.2015
			/*$items = $this->Patient->find('all', array(
						'fields'=> $filedOrder,
						'conditions'=>array('OR'=>($conditions),
						'Patient.is_deleted=0',$paraCond,/*'Patient.admission_type'=>array('IPD','OPD','LAB','RAD')*/ /*),'limit'=>10,'order'=>array("Patient.lookup_name ASC")));*/
		//}
		//debug($items);
		$output ='';
		if($this->Session->read('website.instance')=='vadodara'){
			foreach ($items as $key => $value) {
				$addDate=$this->DateFormat->formatDate2Local($value['Patient']['form_received_on'],Configure::read('date_format'));
				$id = $value['Patient']['id'];
				$admission_type = $value['Patient']['admission_type'];
				$party_code = $value['Patient']['admission_id'];
				$output = $value['Patient']['lookup_name']."-".$value['Patient']['patient_id']."-".$admission_type.' ( '.$addDate.' )';
				$tariff_id = $value['TariffStandard']['id'];
				$tariff_name = $value['TariffStandard']['name'];
				if($admission_type == "OPD" || $admission_type == "LAB" || $admission_type == "RAD"){
					$roomType = "opd_ward";
				}else{
					$roomType = $value['Room']['room_type'];
				}
				$returnArray[] = array('id'=>$id,'party_code'=>$party_code,'value'=>$output,'admission_type'=>$admission_type,'tariff_id'=>$tariff_id,'tariff_name'=>$tariff_name,'room_type'=>$roomType);	//by swapnil
			}
			/*foreach ($testArray as $key=>$value) {
				$returnArray[]=array('id'=>$value['Patient']['id'],'value'=>$value['Patient']['lookup_name'].'-'.$value['Patient']['patient_id'].' ( '.$addDate.' )');
				//echo "$value   $key|$key\n";
			}*/
		}else{
			foreach ($items as $key => $value) {
				$id = $value['Patient']['id'];
				$party_code = $value['Patient']['admission_id'];
				$output = $value['Patient']['lookup_name']."-".$value['Patient']['admission_id'];
				$tariff_id = $value['TariffStandard']['id'];
				$tariff_name = $value['TariffStandard']['name'];
				$admission_type = $value['Patient']['admission_type'];
				$roomType = $value['Room']['room_type'];
				$returnArray[] = array('id'=>$id,'party_code'=>$party_code,'value'=>$output,'admission_type'=>$admission_type,'tariff_id'=>$tariff_id,'tariff_name'=>$tariff_name,'room_type'=>$roomType);	//by swapnil
			}
		}
		
		/*foreach ($items as $key => $value) {
			$id = $value['Patient']['id'];
			$party_code = $value['Patient']['admission_id'];
			$output = $value['Patient']['lookup_name']."-".$value['Patient']['admission_id'];
			$tariff_id = $value['TariffStandard']['id'];
			$tariff_name = $value['TariffStandard']['name'];
			$admission_type = $value['Patient']['admission_type'];
			$returnArray[] = array('id'=>$id,'party_code'=>$party_code,'value'=>$output,'admission_type'=>$admission_type,'tariff_id'=>$tariff_id,'tariff_name'=>$tariff_name);	//by swapnil
		}*/


		//debug($returnArray); exit;
		/*$pharmacy_details =  $this->PharmacySalesBill->find('list', array('fields'=> array("id","customer_name"),'conditions'=>array(
		 "PharmacySalesBill.location_id"=>$this->Session->read('locationid'),'PharmacySalesBill.is_deleted' =>'0',
		 "PharmacySalesBill.customer_name like"=> "%".$searchKey)));

		 foreach ($pharmacy_details as $k=>$v) {
			$output .= "$v|$k|Pharmacy\n";
			}*/
		//debug($output);
		
		echo json_encode($returnArray);
		exit;//dont remove this
	}

	
	
	/* for fetch the other patient details */
	public function inventory_fetch_other_patient_detail($field=null){
		$this->loadModel('PharmacyItem');
		$searchKey = $this->params->query['term'];
		$filedOrder = array();
		//if($field == "admission_id"){
		//$filedOrder = array('id','admission_id','lookup_name');

		//}else{
		$filedOrder = array('cust_name');

		//}
		$conditions[$field." like"] = $searchKey."%";
		$conditions["location_id"] = $this->Session->read('locationid');
		$conditions["is_discharge"] =0;
		$conditions["is_deleted"] =0;
		$items = $this->PharmacyItem->find('list', array('fields'=> $filedOrder,'conditions'=>$conditions));
		$output ='';
		foreach ($items as $key=>$value) {

			/*if($field == "first_name")	 {
			 $fullName = $this->Person->find('first', array('conditions'=>array('Person.patient_uid'=>$key)));
			 $value = $value." ".$fullName['Person']['last_name'];

			 }else{
			 $fullName = $this->Person->find('first', array('conditions'=>array('Person.patient_uid'=>$value)));
			 $key = $key." ".$fullName['Person']['last_name'];
			 }*/

			foreach ($value as $k=>$v) {
				$output .= "$v";
			}
			$output .= "|$k|$key\n";

		}
		$pharmacy_details =  $this->PharmacySalesBill->find('list', array('fields'=> array("id","customer_name"),
				'conditions'=>array("PharmacySalesBill.location_id"=>$this->Session->read('locationid'),'PharmacySalesBill.is_deleted' =>'0',
						"PharmacySalesBill.customer_name like"=> "%".$searchKey)));

		foreach ($pharmacy_details as $k=>$v) {
			$output .= "$v|$k|Pharmacy\n";
		}

		echo $output;
		exit;//dont remove this
	}
	/* for fetch the bill  */
	public function inventory_fetch_bill($field=null){
		$this->loadModel('Person');
		$searchKey = $this->params->query['term'];
		$filedOrder = array('id','bill_code');
		$conditions[$field." like"] = "%".$searchKey."%";
		$conditions["PharmacySalesBill.location_id"] =$this->Session->read('locationid');
		$items = $this->PharmacySalesBill->find('list', array('fields'=> $filedOrder,'conditions'=>array($conditions,'PharmacySalesBill.is_deleted' =>'0'),'limit'=>10));
		$output ='';
		foreach ($items as $key=>$value) {
			$returnArray[] = array('id'=>$key,'value'=>$value);
			//$output .= "$key|$value";
			//$output .= "\n";
		}
		echo json_encode($returnArray);
		//echo $output;
		exit;//dont remove this
	}
	/* for fetch the duplicate bill  */
	public function inventory_fetch_duplicate_bill($field=null){
		$this->uses=array('PharmacyDuplicateSalesBill');
		//$this->loadModel('Person');
		$searchKey = $this->params->query['term'];
		$filedOrder = array('id','bill_code');
		$conditions[$field." like"] = "%".$searchKey."%";
		$conditions["PharmacyDuplicateSalesBill.location_id"] =$this->Session->read('locationid');
		$items = $this->PharmacyDuplicateSalesBill->find('list', array('fields'=> $filedOrder,'conditions'=>array($conditions,'PharmacyDuplicateSalesBill.is_deleted' =>'0'),'limit'=>10));
		$output ='';
		foreach ($items as $key=>$value) {
			$returnArray[] = array('id'=>$key,'value'=>$value);
			//$output .= "$key|$value";
			//$output .= "\n";
		}
		echo json_encode($returnArray);
		//echo $output;
		exit;//dont remove this
	}

	/* for fetch the direct bill  */
	public function inventory_fetch_direct_bill($field=null){
		$this->uses=array('PharmacySalesBill');
		$this->loadModel('Person');
		$searchKey = $this->params->query['term'];
		$filedOrder = array('id','bill_code');
		$conditions[$field." like"] = "%".$searchKey."%";
		$conditions["PharmacySalesBill.location_id"] =$this->Session->read('locationid');
		$items = $this->PharmacySalesBill->find('list', array('fields'=> $filedOrder,'conditions'=>array($conditions,'PharmacySalesBill.is_deleted' =>'0','PharmacySalesBill.account_id IS NOT NULL'),'limit'=>10));
		$output ='';
		foreach ($items as $key=>$value) {
			$returnArray[] = array('id'=>$key,'value'=>$value);
			//$output .= "$key|$value";
			//$output .= "\n";
		}
		echo json_encode($returnArray);
		//echo $output;
		exit;//dont remove this
	}

	/* for fetch the bill  */
	public function inventory_fetch_patient_credit_detail($patientID){
		$this->layout = false;
		$this->loadModel('Patient');
		$patient = $this->Patient->find('first', array('conditions'=>array("Patient.id"=>$patientID)));
		$this->set("patient",$patient);
		$data = $this->PharmacySalesBill->find("all",array(
				"conditions"=>array("PharmacySalesBill.patient_id"=>$patientID,'PharmacySalesBill.is_deleted' =>'0') 
		));
		$total = 0.00;
		$credit_amount = 0.00;
		$deposit = 0.00;
		foreach($data as $key=>$value){
			$total = $total+$value['PharmacySalesBill']['total'];
			if($value['PharmacySalesBill']['payment_mode'] == "credit")
			$credit_amount = $credit_amount+$value['PharmacySalesBill']['total'];
			else
			$deposit = $dipodepositsit+$value['PharmacySalesBill']['total'];
		}

		$this->loadModel('ServiceCategory');
		$pharmacy_service_type=$this->ServiceCategory->find('first',array('conditions'=>array('ServiceCategory.name'=>Configure::read('pharmacyservices'))));

		//amount paid in billing-Pooja
		$this->loadModel('Billing');
		$paid=$this->Billing->find('all',array('fields'=>array('Sum(Billing.amount) as totalPaid','Billing.patient_id'),
				'conditions'=>array('Billing.patient_id'=>$patientID,
						'Billing.payment_category'=>$pharmacy_service_type['ServiceCategory']['id']),
		/*'group'=>array('Billing.patient_id')*/));
		$paid=$paid['0']['0']['totalPaid'];


		//by pankaj for return medicine amt
		$returnList  = $this->InventoryPharmacySalesReturn->find('all',array('fields'=>array('SUM(InventoryPharmacySalesReturn.total) as total',
				'InventoryPharmacySalesReturn.patient_id'),
				'conditions'=>array('InventoryPharmacySalesReturn.patient_id'=>$patientID,'InventoryPharmacySalesReturn.is_deleted'=>'0'),'group'=>array('InventoryPharmacySalesReturn.patient_id')));
		$returnAmt=$returnList['0']['0']['total'];

		//balance amount
		$bal=$total-$returnAmt-$paid;


		$this->set('total',$total);
		$this->set('bal',$bal);
		$this->set('returnAmt',$returnAmt);
		$this->set('paid',$paid);
		$this->set('credit_amount',$credit_amount);
		$this->set('deposit',$deposit);
	}

	public function inventory_other_fetch_patient_credit_detail(){
		$this->layout = false;
		$this->loadModel('PharmacyItem');
		$patient = $this->PharmacyItem->find('first', array('conditions'=>array("Patient.id"=>$patientID)));
		$this->set("PharmacyItem",$patient);
		$data = $this->PharmacySalesBill->find("all",array(
				"conditions"=>array("PharmacySalesBill.patient_id"=>$patientID,'PharmacySalesBill.is_deleted' =>'0')
		));

		$total = 0.00;
		$credit_amount = 0.00;
		$deposit = 0.00;
		foreach($data as $key=>$value){
			$total = $total+$value['PharmacySalesBill']['total'];
			if($value['PharmacySalesBill']['payment_mode'] == "credit")
			$credit_amount = $credit_amount+$value['PharmacySalesBill']['total'];
			else
			$deposit = $dipodepositsit+$value['PharmacySalesBill']['total'];
		}
		$this->set('total',$total);
		$this->set('credit_amount',$credit_amount);
		$this->set('deposit',$deposit);
	}


	/* for fetch the sales bill details */
	public function inventory_fetch_sales_details(){
		$this->loadModel('Patient');
		if(isset($this->request->data['billId'])){
			$result = $this->PharmacySalesBill->find('first',
			array('conditions'=>array('PharmacySalesBill.id' =>$this->request->data['billId'],
							'PharmacySalesBill.location_id' =>$this->Session->read('locationid'),
							'PharmacySalesBill.is_deleted' =>'0')));
			foreach($result['PharmacySalesBillDetail'] as $key=>$value){
				$result['PharmacySalesBillDetail'][$key]['expiry_date'] = $this->DateFormat->formatDate2Local($value['expiry_date'],Configure::read('date_format'));
			}
		}else{

			if($this->params->data['patientId']!=""){
				$patient = $this->Patient->find('first',
				array('conditions'=>array('Patient.id'=>$this->request->data['patientId'],"Patient.location_id"=>$this->Session->read('locationid'))));
				$pharmacy_sale_return_detail = $patient['InventoryPharmacySalesReturn'];
			}else{
				$this->InventoryPharmacySalesReturn->unbindModel(array("belongsTo"=>array("Patient"),"hasMany"=>array("InventoryPharmacySalesReturnsDetail")));
				$conditions["InventoryPharmacySalesReturn.customer_name"] = $this->request->data['customer_name'];
				$conditions["InventoryPharmacySalesReturn.location_id"] = $this->Session->read('locationid');
				$pharmacy_sale_return_detail = $this->InventoryPharmacySalesReturn->find("all",array("conditions"=>$conditions));

			}

			foreach($pharmacy_sale_return_detail as $key=>$value){
				if(isset($value['InventoryPharmacySalesReturn'])){
					$result[$key]['id'] = 	$value['InventoryPharmacySalesReturn']['id'];
					$result[$key]['create_time'] = 	$this->DateFormat->formatDate2Local($value['InventoryPharmacySalesReturn']['create_time'],Configure::read('date_format'));
					$result[$key]['total'] = 	$value['InventoryPharmacySalesReturn']['total'];
					//$result['PharmacySalesBill'][$key]['create_time'] = $this->DateFormat->formatDate2Local($value['create_time'],Configure::read('date_format'));
				}else{
					$result[$key]['id'] = 	$value['id'];
					$result[$key]['create_time'] = 	$this->DateFormat->formatDate2Local($value['create_time'],Configure::read('date_format'));
					$result[$key]['total'] = 	$value['total'];

				}
			}
		}
		echo json_encode($result); exit;
	}

	/* this function for fetch the list of pharmacy details*/
	public function inventory_pharmacy_details($type=null,$search = null){
		$this->layout = "advance";
                $this->uses = array('InventoryPharmacySalesReturn','Patient','PharmacySalesBill');
		switch($type){
			case "sales":
				if(!empty($this->params->query)){
				$this->loadModel("Configuration");
				$configPharmacy = $this->Configuration->getPharmacyServiceType();
				$conditions['PharmacySalesBill.location_id'] =$this->Session->read('locationid');
				$conditions['PharmacySalesBill.patient_id NOT'] = NULL;
				if($search !== null){
					if($this->params->query['billno'] !==""){
						$conditions['PharmacySalesBill.bill_code LIKE'] = '%'.$this->params->query['billno'].'%';
					}

					/*if($this->params->query['date'] !==""){
						$date = $this->DateFormat->formatDate2STD($this->params->query['date'],Configure::read('date_format'));
						$date = explode(' ',$date);
						$conditions['PharmacySalesBill.create_time >'] = $date[0]." 00:00:00";
						$conditions['PharmacySalesBill.create_time <'] = $date[0]." 23:59:59";
					}
					*/
					if(!empty($this->params->query['from'])){
						$fromDate = $this->DateFormat->formatDate2STDForReport($this->request->query['from'],Configure::read('date_format'))." 00:00:00";
						$conditions['PharmacySalesBill.create_time >=']=$fromDate;
					}else{
						$fromDate=date('Y-m-d').' 00:00:00';
						//$conditions['PharmacySalesBill.create_time >=']=$fromDate;
					}
					if(!empty($this->params->query['to'])){
						$toDate = $this->DateFormat->formatDate2STDForReport($this->request->query['to'],Configure::read('date_format'))." 23:59:59";
						$conditions['PharmacySalesBill.create_time <=']=$toDate;
					}else{
						$toDate = date('Y-m-d').' 23:59:59';
						//$conditions['PharmacySalesBill.create_time <=']=$toDate;
					}
						
					if($this->params->query['customer_name'] !==""){ 
						if($this->params->query['person_id'] !==""){
							$conditions['PharmacySalesBill.patient_id'] =$this->params->query['person_id'];
						}else{
							$conditions['PharmacySalesBill.customer_name like'] = '%'.$this->params->query['customer_name'].'%';
						}
					}    
				}
				//$conditions = array('PharmacySalesBill.prescription_status' =>'Approved');
				$this->loadModel('ServiceCategory');
				 
				//$pharmacy_service_type=$this->ServiceCategory->find('first',array('conditions'=>array('ServiceCategory.name'=>Configure::read('pharmacyservices'))));

				$this->loadModel('Patient');

				//by pankaj too avoaid pagination in hope hospital only
				//Configure::write('number_of_rows',35);
				//by pankaj to add return charges in same list
					
				//EOF pankaj
				$this->PharmacySalesBill->unbindModel(array("belongsTo"=>array("Patient")));
				$this->PharmacySalesBill->bindModel(array("belongsTo"=>array(
								"Patient"=>array('type'=>'INNER','foreignKey'=>false, 'conditions'=>array('Patient.id=PharmacySalesBill.patient_id')))),false);

				$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website')));
				$websiteConfig = unserialize($website_service_type['Configuration']['value']);
				if($websiteConfig['instance']=='kanpur'){
					if($this->Session->read('locationid') == 1 || $this->Session->read('locationid') == 25){
						$condition['Patient.location_id'] = array('1','25');
					}else if($this->Session->read('locationid') == 22 || $this->Session->read('locationid') == 26){
						$condition['Patient.location_id'] = array('22','26');
					}
				}else{
					$condition['Patient.location_id'] = $this->Session->read('locationid');
				}
				$this->paginate = array(
						'limit' => Configure::read('number_of_rows'),
						  'fields'=> array('PharmacySalesBill.id','PharmacySalesBill.patient_id','PharmacySalesBill.doctor_id',
								'Sum(PharmacySalesBill.paid_amnt) as paidAmnt',
						  		'PharmacySalesBill.discount','Sum(PharmacySalesBill.total) as pharma','sum(PharmacySalesBill.discount) as disc',
						  		'Sum(PharmacySalesBill.total * PharmacySalesBill.tax /100) as pharmaTax',
				/*'Sum(Billing.amount) as amtPaid',*/
								'PharmacySalesBill.tax','PharmacySalesBill.total','PharmacySalesBill.bill_code', 'PharmacySalesBill.payment_mode',
								'PharmacySalesBill.create_time','PharmacySalesBill.credit_period','Patient.id','Patient.patient_id', 
						 		'Patient.lookup_name','Patient.payment_category','Patient.tariff_standard_id',
						 		'Patient.form_received_on','Patient.last_name', 'Patient.sex','Patient.person_id', 'Patient.admission_id',
								'Patient.form_received_on'), 
						'conditions'=>array($conditions,'PharmacySalesBill.is_deleted' =>'0'),
						'order' => array('PharmacySalesBill.id' => "DESC"),
						'group'=>array('Patient.id')
				);

				$this->set('title_for_layout', __('Sales Details', true));
				$data = $this->paginate('PharmacySalesBill'); 
				if(empty($data)){
					$this->Patient->bindModel(array('belongsTo'=>array('TariffStandard'=>array('foreignKey'=>'tariff_standard_id'))));
					$data = $this->Patient->find('all',array('fields'=>array('Patient.id','Patient.patient_id', 
						 		'Patient.lookup_name','Patient.payment_category','Patient.tariff_standard_id',
						 		'Patient.form_received_on','Patient.last_name', 'Patient.sex','Patient.person_id', 'Patient.admission_id',
								'Patient.form_received_on','TariffStandard.*'),'conditions'=>array('Patient.id' => $this->params->query['person_id'])));
					
					$patientTariff[$data[0]['Patient']['id']] = $data[0]['TariffStandard']['name']; 
				} 
				$this->set('configPharmacy',$configPharmacy); 
				$this->set('data',$data);
				
				$this->loadModel('Billing');
				//by pankaj for return medicine amt
				$returnList  = $this->InventoryPharmacySalesReturn->find('all',array('fields'=>array('SUM(InventoryPharmacySalesReturn.total) as total','SUM(InventoryPharmacySalesReturn.discount) as discount',
						'InventoryPharmacySalesReturn.patient_id','InventoryPharmacySalesReturn.discount_amount'),
						'conditions'=>array('InventoryPharmacySalesReturn.is_deleted'=>'0',
                                                    'InventoryPharmacySalesReturn.patient_id'=>$this->params->query['person_id']/*,'InventoryPharmacySalesReturn.patient_id IS NOT NULL'*/),'group'=>array('InventoryPharmacySalesReturn.patient_id')));
					
				//by swapnil
				foreach($returnList as $returnKey=>$returnValue){
					
					$returnListArray[$returnValue['InventoryPharmacySalesReturn']['patient_id']]= $returnValue[0]['total'];
					$returnDiscountArray[$returnValue['InventoryPharmacySalesReturn']['patient_id']]= $returnValue[0]['discount'];
					//return amount if billing_id exist by swapnil 09.04.2015
					$retData= $this->Billing->returnPaidAmount($returnValue['InventoryPharmacySalesReturn']['patient_id']);
					$returnAmountArray[$returnValue['InventoryPharmacySalesReturn']['patient_id']] = $retData['pharmacy'][0]['total'];
					$discAmnt[$returnValue['InventoryPharmacySalesReturn']['patient_id']] = $returnValue['InventoryPharmacySalesReturn']['discount_amount'];
				} 
				//EOF return     
				$this->set('discAmnt',$discAmnt);
				$this->set('returnListArray',$returnListArray);
				$this->set('returnDiscountArray',$returnDiscountArray);
				$this->set('returnAmountArray',$returnAmountArray);

				// amount paid for pharmacy calculations - pooja
				foreach($data as $pharmacy){
					$patientId[]=$pharmacy['PharmacySalesBill']['patient_id'];
					$tariff[]=$pharmacy['Patient']['tariff_standard_id'];
				}
				$this->Patient->bindModel(array(
						'belongsTo'=>array('TariffStandard'=>array('foreignKey'=>false, 'conditions'=>array('Patient.tariff_standard_id=TariffStandard.id')))));

				$tariffName=$this->Patient->find('all',array('fields'=>array('TariffStandard.name','Patient.id'),
						'conditions'=>array('TariffStandard.id'=>$tariff,'Patient.id'=>$patientId),
						'group'=>array('Patient.id')));  
				
				$payment_category = $this->ServiceCategory->getPharmacyId(); //by swapnil
				
				$paid=$this->Billing->find('all',array('fields'=>array('Billing.amount','Billing.discount','Billing.paid_to_patient','Billing.patient_id'),
						'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>0,
											'Billing.payment_category'=>$payment_category/*$pharmacy_service_type['ServiceCategory']['id']*/),
				/*'group'=>array('Billing.patient_id')*/));
				
				foreach($paid as $key=>$pharPaid){ //debug($pharPaid['Billing']['discount']);
					$paidAmt[$pharPaid['Billing']['patient_id']]=$paidAmt[$pharPaid['Billing']['patient_id']]+$pharPaid['Billing']['amount'];
					$refund[$pharPaid['Billing']['patient_id']] = $refund[$pharPaid['Billing']['patient_id']] + $pharPaid['Billing']['paid_to_patient'];
					$discount[$pharPaid['Billing']['patient_id']] = $discount[$pharPaid['Billing']['patient_id']] + $pharPaid['Billing']['discount'];
				}  
				 
				foreach($tariffName as $tariffStandard){
					$patientTariff[$tariffStandard['Patient']['id']]=$tariffStandard['TariffStandard']['name'];
				}

				$this->set('tariff',$patientTariff);
				$this->set('paidAmt',$paidAmt);
				$this->set('refund',$refund);
				$this->set('billDiscount',$discount);
				}
				$this->layout="advance";
				$this->render('inventory_sales_details');
				break;
				
			case "direct_return":
				
				$conditions['InventoryPharmacySalesReturn.location_id'] =$this->Session->read('locationid');
				$conditions['InventoryPharmacySalesReturn.patient_id'] = null;
				if($search !== null){
					if($this->request->query['bill_no'] !==""){
							$conditions['InventoryPharmacySalesReturn.bill_code'] = $this->request->query['bill_no'];
					}
					if(!empty($this->params->query['from_date'])){
						$fromDate = $this->DateFormat->formatDate2STDForReport($this->request->query['from_date'],Configure::read('date_format'))." 00:00:00";
							$conditions['InventoryPharmacySalesReturn.create_time >=']=$fromDate;
					}
					if(!empty($this->params->query['to_date'])){
						$toDate = $this->DateFormat->formatDate2STDForReport($this->request->query['to_date'],Configure::read('date_format'))." 23:59:59";
								$conditions['InventoryPharmacySalesReturn.create_time <=']=$toDate;
					}
					
					if($this->params->query['customer_name'] !==""){
						if($this->params->query['person_id'] !==""){
							$conditions['InventoryPharmacySalesReturn.patient_id'] =$this->params->query['person_id'];
						}else{
							$conditions['InventoryPharmacySalesReturn.customer_name like'] = '%'.$this->params->query['customer_name'].'%';
						}
					}
				}
				
				$this->paginate = array(
						'limit' => Configure::read('number_of_rows'),
										'order' => array(
												'InventoryPharmacySalesReturn.create_time' => 'desc'
										),
										'conditions'=>array($conditions,'InventoryPharmacySalesReturn.is_deleted'=>'0')
												);
						$this->set('title_for_layout', __('Sales Return Details', true));
				$data = $this->paginate('InventoryPharmacySalesReturn');
				
						$this->set('data',$data);
						$this->render('view_direct_return');
						
				break;	
			case "sales_return":
				
				$this->InventoryPharmacySalesReturn->bindModel(array(
					"belongsTo"=>array(
						"PharmacySalesBill"=>array('type'=>'INNER','foreignKey'=>false, 
				 		'conditions'=>array('InventoryPharmacySalesReturn.patient_id = PharmacySalesBill.patient_id')))),false);
				
				$conditions['InventoryPharmacySalesReturn.location_id'] =$this->Session->read('locationid');
				/* $conditions['PharmacySalesBill.account_id'] = NULL; 
				$conditions['PharmacySalesBill.patient_id Not'] = Null; */
				if($search !== null){
					if($this->request->query['bill_no'] !==""){
						$conditions['InventoryPharmacySalesReturn.bill_code'] = $this->request->query['bill_no'];
					}
					if(!empty($this->params->query['from_date'])){
						$fromDate = $this->DateFormat->formatDate2STDForReport($this->request->query['from_date'],Configure::read('date_format'))." 00:00:00";
						$conditions['InventoryPharmacySalesReturn.create_time >=']=$fromDate;
					}
					if(!empty($this->params->query['to_date'])){
						$toDate = $this->DateFormat->formatDate2STDForReport($this->request->query['to_date'],Configure::read('date_format'))." 23:59:59";
						$conditions['InventoryPharmacySalesReturn.create_time <=']=$toDate;
					}

					if($this->params->query['customer_name'] !==""){
						if($this->params->query['person_id'] !==""){
							$conditions['InventoryPharmacySalesReturn.patient_id'] =$this->params->query['person_id'];
						}else{

							$conditions['InventoryPharmacySalesReturn.customer_name like'] = '%'.$this->params->query['customer_name'].'%';
						}
					}
				}

				$this->paginate = array(
						'limit' => Configure::read('number_of_rows'),
						'order' => array(
								'InventoryPharmacySalesReturn.create_time' => 'desc'
								),
						'conditions'=>array($conditions,'InventoryPharmacySalesReturn.is_deleted'=>'0'),
						'group' =>array('InventoryPharmacySalesReturn.bill_code'),
								);
				$this->set('title_for_layout', __('Sales Return Details', true));
				$data = $this->paginate('InventoryPharmacySalesReturn');

				$this->set('data',$data);
				$this->render('inventory_sales_return_details');

				break;

			case "detail_bill":
				$this->loadModel('Configuration');
				$this->loadModel('ServiceCategory');
				$this->loadModel('Billing');
                                $this->loadModel('TariffStandard');
				
				$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website')));
				$websiteConfig=unserialize($website_service_type['Configuration']['value']);
				$roleName = $this->Session->read('role');
				
				$this->set(compact(array('websiteConfig','roleName')));
				//commnetd by pankaj w as we dont need locatio id in patient sales bill
				//$conditions['PharmacySalesBill.location_id'] =$this->Session->read('locationid');
				$conditions['PharmacySalesBill.patient_id IS NOT NULL'];
				if($search !== null){
					if($this->params->query['billno'] !==""){
						$conditions['PharmacySalesBill.bill_code LIKE' ] = '%'.$this->params->query['billno'].'%';
					}
					if($this->params->query['date'] !==""){
						$date = $this->DateFormat->formatDate2STD($this->params->query['date'],Configure::read('date_format'));
						$date = explode(' ',$date);
						$conditions['PharmacySalesBill.create_time >'] = $date[0]." 00:00:00";
						$conditions['PharmacySalesBill.create_time <'] = $date[0]." 23:59:59";
					}
				}
				if($this->params->query['customer_name'] !==""){
					if($this->params->query['person_id'] !==""){
						$conditions['PharmacySalesBill.patient_id'] = $this->params->query['person_id'];
					}else{
						$conditions['PharmacySalesBill.customer_name like'] = '%'.$this->params->query['customer_name'].'%';
					}
				}

				if($this->Session->read('website.instance')=='kanpur'){ //for kanpur instance, only received salebill will shown
					if($this->params->query['flag']=='billing'){
						//$conditions['PharmacySalesBill.is_received'] ='1';
					}
				} 
                                $rgjayStdIds = $this->TariffStandard->find('list',array('fields'=>array('id','id'),
                                    'conditions'=>array('TariffStandard.name'=>array(Configure::read('RGJAY'),Configure::read('RGJAYToday')))));
				$this->set('rgjayStdIds',$rgjayStdIds);
                                $phramacySalesData =$this->PharmacySalesBill->find('all',array(
					'order' => array(
								'PharmacySalesBill.create_time' => 'desc'),
						'fields'=> array('PharmacySalesBill.id','PharmacySalesBill.patient_id','PharmacySalesBill.doctor_id',
								'PharmacySalesBill.tax','PharmacySalesBill.total','PharmacySalesBill.bill_code', 'PharmacySalesBill.payment_mode','PharmacySalesBill.paid_amnt',
								'PharmacySalesBill.create_time','PharmacySalesBill.discount','PharmacySalesBill.credit_period','PharmacySalesBill.modified_time','Patient.id','Patient.patient_id',
								'Patient.lookup_name','Patient.payment_category','Patient.tariff_standard_id',
								'Patient.form_received_on','Patient.last_name', 'Patient.sex','Patient.person_id', 'Patient.admission_id',
								'Patient.form_received_on'),
						'conditions'=>array($conditions,'PharmacySalesBill.is_deleted' =>'0')
				));
				//by swapnil for return list 02.03.2015
                               // debug($phramacySalesData);
				if($this->params->query['customer_name'] !==""){
					if($this->params->query['person_id'] !==""){
						$returnConditions['InventoryPharmacySalesReturn.patient_id'] =$this->params->query['person_id'];
					}else{
						$returnConditions['InventoryPharmacySalesReturn.customer_name like'] = '%'.$this->params->query['customer_name'].'%';
					}
				}

				$pharmacySalesReturnData =$this->InventoryPharmacySalesReturn->find('all',array(
					'conditions'=>array($returnConditions,'InventoryPharmacySalesReturn.is_deleted'=>'0')));
			
				
				$payment_category = $this->ServiceCategory->getPharmacyId();
				$advancePay = $this->Billing->find('all',array(
						'conditions'=>array('Billing.payment_category'=>$payment_category ,'Billing.patient_id'=>$phramacySalesData[0]['Patient']['id'] 
							,'Billing.pharmacy_sales_bill_id'=>null,'Billing.is_deleted'=>0),
						'fields'=>array('Billing.id','Billing.patient_id','Billing.payment_category','Billing.amount','Billing.date','Billing.remark')
						));
				$this->set('title_for_layout', __('Sales Details', true));
				$data =  $phramacySalesData ; //$this->paginate('PharmacySalesBill');
				$this->set(compact(array('data','advancePay')));
				$this->set('returnData',$pharmacySalesReturnData);
				
				if($this->request->isAjax()){
					$this->layout = 'ajax';
				}else{
					$this->layout = 'advance_ajax';
				}
				$this->render('detailed_pharmacy_bill');
				break;
					
				//for collecting cash from pharmacy itself by Swapnil G.Sharma
			case "cash_collected":
				$conditions['PharmacySalesBill.location_id'] =$this->Session->read('locationid');
				$conditions['PharmacySalesBill.patient_id NOT'] = NULL;
				if($search !== null){
					if($this->params->query['billno'] !==""){
						$conditions['PharmacySalesBill.bill_code LIKE'] = '%'.$this->params->query['billno'].'%';
					}

					if($this->params->query['date'] !==""){
						$date = $this->DateFormat->formatDate2STD($this->params->query['date'],Configure::read('date_format'));
						$date = explode(' ',$date);
						$conditions['PharmacySalesBill.create_time >'] = $date[0]." 00:00:00";
						$conditions['PharmacySalesBill.create_time <'] = $date[0]." 23:59:59";
					}
				}
				if($this->params->query['customer_name'] !=""){
					if($this->params->query['person_id'] !=""){
						$patientId = $this->params->query['person_id'];
						$conditions['PharmacySalesBill.patient_id'] = $patientId;
					}else{

						$conditions['PharmacySalesBill.customer_name like'] = '%'.$this->params->query['customer_name'].'%';
					}
				}

				$phramacySalesData =$this->PharmacySalesBill->find('all',array(
					'order' => array(
								'PharmacySalesBill.create_time' => 'desc'),
						'fields'=> array('PharmacySalesBill.id','PharmacySalesBill.patient_id','PharmacySalesBill.doctor_id','PharmacySalesBill.paid_amnt',
								'PharmacySalesBill.tax','PharmacySalesBill.total','PharmacySalesBill.bill_code', 'PharmacySalesBill.payment_mode',
								'PharmacySalesBill.create_time','PharmacySalesBill.discount','PharmacySalesBill.credit_period','PharmacySalesBill.modified_time','Patient.id','Patient.patient_id',
								'Patient.lookup_name','Patient.payment_category',
								'Patient.form_received_on','Patient.last_name', 'Patient.sex','Patient.person_id', 'Patient.admission_id',
								'Patient.form_received_on'),
						'conditions'=>array($conditions,'PharmacySalesBill.is_deleted' =>'0')
				));

				$this->set('title_for_layout', __('Sales Details', true));
				$this->set('data',$phramacySalesData);
				//debug($phramacySalesData);

				$this->loadModel('ServiceCategory');
				$this->loadModel('Billing');
				$payment_category = $this->ServiceCategory->getPharmacyId(); //by swapnil

				$paid=$this->Billing->find('all',array('fields'=>array('Sum(Billing.amount) as total_amount','Billing.patient_id','sum(paid_to_patient)as refund',
												'sum(Billing.amount_paid) as adv_paid',
												),
											'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.pharmacy_sales_bill_id IS NULL',
											'Billing.payment_category'=>$payment_category),
												'group'=>array('Billing.patient_id')));
				
				$returnedSalesData =$this->InventoryPharmacySalesReturn->find('all',array(
						'conditions'=>array('InventoryPharmacySalesReturn.patient_id'=>$patientId,'InventoryPharmacySalesReturn.is_deleted'=>'0'),
						'fields'=>array('InventoryPharmacySalesReturn.patient_id','InventoryPharmacySalesReturn.total')));
				
				foreach($returnedSalesData as $key=>$pharReturned){ //debug($pharPaid['Billing']['discount']);
					$returnedAmnt[$pharReturned['InventoryPharmacySalesReturn']['patient_id']] = $returnedAmnt[$pharReturned['InventoryPharmacySalesReturn']['patient_id']]+$pharReturned['InventoryPharmacySalesReturn']['total'];
					
				} 
				
				$refund = $paid[0][0]['refund'];
				$paidAmt = $paid[0][0]['total_amount'];
				$billAdv = $paid[0][0]['adv_paid'];
				$this->set(compact('paidAmt','billAdv','returnedSalesData','returnedAmnt','refund'));

				/*$this->loadModel('Patient');
				 $this->PharmacySalesBill->unbindModel(array("belongsTo"=>array("Patient")));
				 $this->PharmacySalesBill->bindModel(array("belongsTo"=>array(
				 "Patient"=>array('type'=>'INNER','foreignKey'=>false, 'conditions'=>array('Patient.id=PharmacySalesBill.patient_id')))),false);

				 $pharmacyTotalSales =$this->PharmacySalesBill->find('all',array(
				 'fields'=> array('PharmacySalesBill.id','PharmacySalesBill.patient_id','PharmacySalesBill.doctor_id',
				 'sum(PharmacySalesBill.total) as total','Patient.id','Patient.patient_id','sum(PharmacySalesBill.discount) as disc',
				 'Patient.lookup_name','Patient.payment_category'),
				 'conditions'=>array($conditions,'PharmacySalesBill.is_deleted' =>'0'),'group'=>array('Patient.id')
				 ));

				 $this->loadModel('Billing');
				 foreach($pharmacyTotalSales as $pharmacy){
					$patientId[]=$pharmacy['PharmacySalesBill']['patient_id'];
					}
					$this->Patient->bindModel(array(
					'belongsTo'=>array('TariffStandard'=>array('foreignKey'=>false, 'conditions'=>array('Patient.tariff_standard_id=TariffStandard.id')))));

					$paid=$this->Billing->find('all',array('fields'=>array('Billing.amount','Billing.patient_id','sum(Billing.amount) as total_amount','sum(Billing.discount) as discount','sum(Billing.paid_to_patient) as refund'),
					'conditions'=>array('Billing.patient_id'=>$patientId,
					'Billing.payment_category'=>$payment_category ),));
					$paidAmt = $paid[0][0]['total_amount'];
					$billDiscount = $paid[0][0]['discount'];
					$billRefund = $paid[0][0]['refund'];

					$returnList  = $this->InventoryPharmacySalesReturn->find('all',array('fields'=>array('SUM(InventoryPharmacySalesReturn.total) as total',
					'InventoryPharmacySalesReturn.patient_id'),
					'conditions'=>array('InventoryPharmacySalesReturn.is_deleted'=>'0','InventoryPharmacySalesReturn.patient_id'=>$patientId),'group'=>array('InventoryPharmacySalesReturn.patient_id')));
					$returnAmt = $returnList[0][0]['total'];

					//EOF return

					$this->set('returnListArray',$returnListArray);

					$this->set('paidAmt',$paidAmt);
					$this->set('billDiscount',$billDiscount);
					$this->set('returnAmt',$returnAmt);
					$this->set('refundAmt',$billRefund);
					$this->set('title_for_layout', __('Cash Details', true));
					$this->set('data',$pharmacyTotalSales);*/
				$this->autoRender = false;
				$this->layout = 'ajax';
				$this->render('detailed_pharmacy_cash',false);
				break;
		}

	}
	/* for view the details for purchase, sale and sales return*/
	public function inventory_get_pharmacy_details($type=null,$id=null,$page=null){
            $this->uses = array('PharmacySalesBill','PharmacyItemRate','User','InventoryPharmacySalesReturn');
		switch($type){
			case "purchase":
				if($id!=null){
					$purchase = $this->InventoryPurchaseDetail->find('first',array('conditions'=>
					array('InventoryPurchaseDetail.id'=>$id,"InventoryPurchaseDetail.location_id" =>$this->Session->read('locationid'))));

					$this->set('data',$purchase);

				}
				$this->render('inventory_purchase_receipt_view');
				break;
			case "sales":
				$this->loadModel("Configuration");
				$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website')));
				$websiteConfig=unserialize($website_service_type['Configuration']['value']);
				$this->set('websiteConfig',$websiteConfig);

				if($id!=null){
					$this->PharmacySalesBill->bindModel(array(
							'belongsTo' => array(
									'User' =>array('foreignKey' => 'guarantor_id'),array('conditions'=>array('PharmacySalesBill.guarantor_id=User.id')),
									'DoctorProfile' =>array('foreignKey' => false,'conditions' => array('PharmacySalesBill.doctor_id = DoctorProfile.user_id'))),
						
					));

					$saleBill = $this->PharmacySalesBill->find('first',array('conditions'=>
					array('PharmacySalesBill.id'=>$id,"PharmacySalesBill.location_id" =>$this->Session->read('locationid'),
									'PharmacySalesBill.is_deleted' =>'0'),
							'fields'=>array('User.username','PharmacySalesBill.*','Patient.*','DoctorProfile.doctor_name'
							)));
								
							foreach($saleBill['PharmacySalesBillDetail'] as $saleDetail){
								$pharmacyRate[]= $this->PharmacyItemRate->find('first',array(
												'conditions'=>array('PharmacyItemRate.item_id'=>$saleDetail['item_id'],'PharmacyItemRate.batch_number'=>$saleDetail['batch_number'])));
								//debug($pharmacyRate);
							}//debug($pharmacyRate);exit;
							$DocName=$this->User->getUserDetails($saleBill['Patient']['doctor_id']);
							$this->set('doctorName',$DocName);
							$this->set('pharmacyRate',$pharmacyRate);
							$this->set('data',$saleBill);
				}
				if($this->params['isAjax'] == 1){
					$this->layout="ajax";
				}else{
					$this->layout="advance_ajax";
				}
				
				$this->render('inventory_sales_bill_view');
			 break;
			case "sales_edit":
				if($id!=null){

					$this->PharmacySalesBill->bindModel(array(
							'belongsTo' => array(
									'User' =>array('foreignKey' => 'guarantor_id'),array('conditions'=>array('PharmacySalesBill.guarantor_id=User.id')),
									'DoctorProfile' =>array('foreignKey' => false),array('conditions' => array('PharmacySalesBill.doctor_id = DoctorProfile.user_id')))

					));

					$saleBill = $this->PharmacySalesBill->find('first',array('conditions'=>
					array('PharmacySalesBill.id'=>$id,"PharmacySalesBill.location_id" =>$this->Session->read('locationid'),
									'PharmacySalesBill.is_deleted' =>'0'),
							'fields'=>array('User.username','PharmacySalesBill.*','Patient.*','DoctorProfile.doctor_name')));
					$this->set('data',$saleBill);

				}
				$this->render('inventory_sales_bill');
				break;
			case "purchase_return":
				if($id!=null){
					$returnDetails = $this->InventoryPurchaseReturn->find("first",
					array('conditions' => array("InventoryPurchaseReturn.id"=>$id,"InventoryPurchaseReturn.location_id" =>$this->Session->read('locationid'))));

					$this->set("data", $returnDetails);
				}
			 $this->render('inventory_purchase_return_view');
			 break;
			default:
				if(!empty($page) && $page == "salesBill"){
					$this->layout = "ajax";
				}
				if($id!=null){
					$sale_return_details = $this->InventoryPharmacySalesReturn->find('first',
					array('conditions' => array("InventoryPharmacySalesReturn.id"=>$id,"InventoryPharmacySalesReturn.location_id" =>$this->Session->read('locationid'),
											'InventoryPharmacySalesReturn.is_deleted'=>'0')));
					$this->set("data", $sale_return_details);

				}
				$this->layout="advance_ajax";
				$this->render('inventory_sales_return_view');
		}
	}

	public function inventory_get_other_pharmacy_view($type=null,$id=null){
		switch($type){
			case "salesView":
				if($id!=null){
					$saleBill = $this->PharmacySalesBill->find('first',array('conditions'=>
					array('PharmacySalesBill.id'=>$id,"PharmacySalesBill.location_id" =>$this->Session->read('locationid'),'PharmacySalesBill.is_deleted' =>'0')));

					$this->set('data',$saleBill);
				}
				$this->render('inventory_other_sales_bill_view');
				break;
		}
			
	}
	public function inventory_get_other_pharmacy_details($type=null,$search=null,$accountId=null){ 
		switch($type){
			case "sales":				
				$this->layout = "advance";
				$this->loadModel("Configuration");
				$this->loadModel("Account");
				$configPharmacy = $this->Configuration->getPharmacyServiceType();
				$this->PharmacySalesBill->unBindModel(array('belongsTo'=>array('Patient','Doctor','Initial')),false);
				$conditions['PharmacySalesBill.location_id'] =$this->Session->read('locationid');
				$conditions['PharmacySalesBill.is_deleted'] ='0';
				$conditions['PharmacySalesBill.patient_id'] = NULL;
				//$conditions['PharmacySalesBill.customer_name !='] = 'NULL';
				//debug($this->request->data['search']);//exit;
					
				if($this->request->query['search'] !== null){

					if($this->request->query['billno'] !==""){
						$conditions['PharmacySalesBill.bill_code LIKE'] = '%'.$this->request->query['billno'].'%';
					}
					if(!empty($this->params->query['fromDate'])){
						$fromDate = $this->DateFormat->formatDate2STDForReport($this->request->query['fromDate'],Configure::read('date_format'))." 00:00:00";
						$conditions['PharmacySalesBill.create_time >=']=$fromDate;
					}else{
						$fromDate=date('Y-m-d').' 00:00:00';
						//$conditions['PharmacySalesBill.create_time >=']=$fromDate;
					}
					if(!empty($this->params->query['toDate'])){
						$toDate = $this->DateFormat->formatDate2STDForReport($this->request->query['toDate'],Configure::read('date_format'))." 23:59:59";
						$conditions['PharmacySalesBill.create_time <=']=$toDate;
					}else{
						$toDate = date('Y-m-d').' 23:59:59';
						//$conditions['PharmacySalesBill.create_time <=']=$toDate;
					}
					
					if($this->request->query['customer_name'] !==""){
						$conditions['PharmacySalesBill.customer_name like'] = '%'.$this->request->query['customer_name'].'%';
					}
				}
					
					
				$this->paginate =array(
						'limit'=>10,
						'fields'=> array('PharmacySalesBill.discount','PharmacySalesBill.id','PharmacySalesBill.patient_id','PharmacySalesBill.customer_name','PharmacySalesBill.tax','PharmacySalesBill.total',
								'sum(PharmacySalesBill.total) as total','PharmacySalesBill.bill_code','PharmacySalesBill.payment_mode','PharmacySalesBill.account_id',
								'PharmacySalesBill.refund','sum(PharmacySalesBill.paid_to_patient) as refundAmount','PharmacySalesBill.create_time','PharmacySalesBill.credit_period',
								'sum(PharmacySalesBill.discount) as disc','sum(PharmacySalesBill.paid_amnt) as paidAmnt',
								),
						'conditions'=> array($conditions,'PharmacySalesBill.customer_name IS NOT NULL'),
						'order' => array('PharmacySalesBill.create_time' => 'desc'),
						'group' => array('PharmacySalesBill.account_id'),
				);
				
				$pharmacyReturns  = $this->InventoryPharmacySalesReturn->find('all',array(
								'fields'=>array('SUM(InventoryPharmacySalesReturn.total) as total','InventoryPharmacySalesReturn.pharmacy_sale_bill_id','InventoryPharmacySalesReturn.account_id'),
								'conditions'=>array('InventoryPharmacySalesReturn.is_deleted'=>'0'),
				//'group'=>array('InventoryPharmacySalesReturn.pharmacy_sale_bill_id')));
								'group'=>array('InventoryPharmacySalesReturn.account_id')));
				foreach($pharmacyReturns as $key => $value){
					$returnListArray[$value['InventoryPharmacySalesReturn']['account_id']]= $value[0]['total'];
				} 
				$this->set('returnListArray',$returnListArray);

				/* $accountData = $this->Account->find('all',array(
				 'conditions'=>array('Account.name = PharmacySalesBill.customer_name'),
				 'fields'=>array('Account.balance'))); */
				
				$saleBill = $this->paginate('PharmacySalesBill'); 
			
				$lastPharmacySaleId=$this->PharmacySalesBill->getLastInsertID();
				//debug($saleBill);exit;
				$this->set('configPharmacy',$configPharmacy);
				$this->set('saleBill',$saleBill);
				
				$this->render('inventory_other_sales_view_detail');
				break;
					
			case "detailView":
				//debug($this->params->query['customer_id']);
				$this->PharmacySalesBill->unBindModel(array('belongsTo'=>array('Patient','Doctor','Initial')));
				$conditions['PharmacySalesBill.location_id'] = $this->Session->read('locationid');
				//$conditions['PharmacySalesBill.customer_name NOT'] = NULL;
				//$conditions['PharmacySalesBill.id'] = $this->params->query['customer_id'];
				$conditions['PharmacySalesBill.is_deleted'] ='0';
				$conditions['PharmacySalesBill.account_id'] = $accountId;

				$phramacySalesData = $this->PharmacySalesBill->find('all',array(
						'order' => array('PharmacySalesBill.create_time' => 'desc'),
						'fields'=> array('PharmacySalesBill.id','PharmacySalesBill.customer_name','PharmacySalesBill.doctor_id','PharmacySalesBill.account_id',
								'PharmacySalesBill.tax','PharmacySalesBill.paid_amnt','PharmacySalesBill.total','PharmacySalesBill.discount','PharmacySalesBill.bill_code', 'PharmacySalesBill.payment_mode',
								'PharmacySalesBill.create_time','PharmacySalesBill.credit_period','PharmacySalesBill.modified_time'),
						'conditions'=>array($conditions)
				));

				$this->set('title_for_layout', __('DirectSales Details', true));
				$data =  $phramacySalesData ; //$this->paginate('PharmacySalesBill');
				//debug($data);
				$this->set('data',$data);
				$this->layout = 'ajax';
				$this->render('detailed_direct_view');
				break;

			case "cash_collected":
				$billId = $this->request->query['saleBill_id'];
				$conditions['PharmacySalesBill.location_id'] =$this->Session->read('locationid');
				//$conditions['PharmacySalesBill.account_id'] = $accountId;
				$conditions['PharmacySalesBill.id'] = $billId;
				$this->loadModel('ServiceCategory');

				$pharmacy_service_type=$this->ServiceCategory->find('first',array('conditions'=>array('ServiceCategory.name'=>Configure::read('pharmacyservices'))));

				$pharmacyTotalSales = $this->PharmacySalesBill->find('all',array(
						'fields'=> array('PharmacySalesBill.id','PharmacySalesBill.customer_name','PharmacySalesBill.payment_mode','PharmacySalesBill.paid_amnt','PharmacySalesBill.refund',
								'PharmacySalesBill.account_id','sum(PharmacySalesBill.paid_to_patient) as refundAmount','sum(PharmacySalesBill.total) as total','sum(PharmacySalesBill.discount) as disc'),
						'conditions'=>array($conditions,'PharmacySalesBill.is_deleted' =>'0'),
						'group'=>array('PharmacySalesBill.account_id')				
				));

				$returnData = $this->InventoryPharmacySalesReturn->find('all',array('conditions'=>array('InventoryPharmacySalesReturn.pharmacy_sale_bill_id'=>$billId),
							'fields'=>array('SUM(InventoryPharmacySalesReturn.total) as returnTotal','InventoryPharmacySalesReturn.pharmacy_sale_bill_id')));
				foreach($returnData as $key => $value){
					$returnListArray[$value['InventoryPharmacySalesReturn']['pharmacy_sale_bill_id']]= $value[0]['returnTotal'];
				}
				$this->set('returnData',$returnListArray);
				$this->autoRender = false;
				$this->set('title_for_layout', __('Cash Details', true));
				$this->set('data',$pharmacyTotalSales);
				$this->layout = 'advance_ajax';
				$this->render('detailed_direct_cash');  
				break;

			case "return_detials":
				$this->uses = array('Configuration','PharmacySalesBill','PharmacyItemRate','InventoryPharmacySalesReturn');
				$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website')));
				$websiteConfig = unserialize($website_service_type['Configuration']['value']);
				/*if($websiteConfig['instance']=='kanpur'){
					$mode_of_payment = array('Cash'=>'Cash','Credit'=>'Credit');
				*/
				$mode_of_payment = array('Credit'=>'Credit');
				$this->set('mode_of_payment',$mode_of_payment);
				
				$conditions['PharmacySalesBill.location_id'] =$this->Session->read('locationid');

				$billId =  $this->request->query['saleBill_id']; /* $accountId */
				$conditions['PharmacySalesBill.id'] = $billId;
				//$conditions['PharmacySalesBill.account_id'] = $accountId;
				$this->PharmacySalesBill->unBindModel(array(
						'hasMany'=>array('PharmacySalesBillDetail')));
				$this->PharmacySalesBill->bindModel(array(
					'belongsTo' => array(
						'PharmacySalesBillDetail' => array('foreignKey' => false,
															'conditions'=> array("PharmacySalesBill.id = PharmacySalesBillDetail.pharmacy_sales_bill_id")),
						'PharmacyItem' => array('foreignKey' => false,
															'conditions'=> array("PharmacySalesBillDetail.item_id = PharmacyItem.id")),
						'PharmacyItemRate' => array('foreignKey' => false,
															'conditions'=> array("PharmacyItemRate.item_id = PharmacyItem.id"))
				)));



				$items = $this->PharmacySalesBill->find('all', array(
							'fields'=>array('PharmacySalesBill.id','PharmacySalesBill.customer_name','PharmacySalesBill.discount','PharmacySalesBill.total',
											'PharmacySalesBillDetail.id','PharmacySalesBillDetail.item_id','PharmacySalesBillDetail.qty',
											'PharmacySalesBillDetail.qty_type','PharmacySalesBillDetail.pack','PharmacySalesBillDetail.batch_number',
											'PharmacySalesBillDetail.mrp','PharmacySalesBillDetail.sale_price','PharmacySalesBillDetail.expiry_date',
											'PharmacyItem.id','PharmacyItem.name','PharmacyItemRate.id','PharmacyItemRate.batch_number'),
							'conditions'=>array($conditions) ,'group' => 'PharmacyItem.id' ));

				
				foreach($items as $key => $saleData){
					$rateData = $this->PharmacyItemRate->find('first',array('conditions'=>array(
												'PharmacyItemRate.item_id'=>$saleData['PharmacyItem']['id'],'PharmacyItemRate.batch_number'=>$saleData['PharmacySalesBillDetail']['batch_number'])));
					$items[$key]['PharmacyItemRate'] = array('id' => $rateData['PharmacyItemRate']['id'],
															 'batch_number' => $rateData['PharmacyItemRate']['batch_number']);
				}

				$this->InventoryPharmacySalesReturn->unbindModel(array('hasMany'=>array('InventoryPharmacySalesReturnsDetail'),
																		'belongsTo'=>array('Patient')));

				$this->InventoryPharmacySalesReturn->bindModel(array(
					'belongsTo' => array(
						'InventoryPharmacySalesReturnsDetail' => array('foreignKey' => false,
															'conditions'=> array("InventoryPharmacySalesReturn.id = InventoryPharmacySalesReturnsDetail.inventory_pharmacy_sales_return_id")),
						'PharmacyItem' => array('foreignKey' => false,
															'conditions'=> array("InventoryPharmacySalesReturnsDetail.item_id = PharmacyItem.id")),
						'PharmacyItemRate' => array('foreignKey' => false,
															'conditions'=> array("PharmacyItemRate.item_id = PharmacyItem.id"))
				)));

				$returnItems = $this->InventoryPharmacySalesReturn->find('all', array(
									'fields'=>array('InventoryPharmacySalesReturn.id','InventoryPharmacySalesReturn.customer_name',
													'InventoryPharmacySalesReturnsDetail.id','InventoryPharmacySalesReturnsDetail.item_id',
													'InventoryPharmacySalesReturnsDetail.qty_type','InventoryPharmacySalesReturnsDetail.mrp',
													'InventoryPharmacySalesReturnsDetail.sale_price','InventoryPharmacySalesReturnsDetail.pack',
													'InventoryPharmacySalesReturnsDetail.batch_no','InventoryPharmacySalesReturnsDetail.qty',
													'PharmacyItem.id','PharmacyItem.name'),
									'conditions'=>array("InventoryPharmacySalesReturn.pharmacy_sale_bill_id" => $billId),'group' => 'InventoryPharmacySalesReturnsDetail.id'));

					
				foreach($returnItems as $key=>$val){
					$returnQty[$val['InventoryPharmacySalesReturnsDetail']['item_id']] = $returnQty[$val['InventoryPharmacySalesReturnsDetail']['item_id']]+$val['InventoryPharmacySalesReturnsDetail']['qty'];
				}

				$this->set('title_for_layout', __('Return Details', true));
				$this->set('data',$items);
				$this->set('returnQty',$returnQty);
				$this->set('returnData',$returnItems);
				$this->layout = 'advance_ajax';
				$this->render('detailed_direct_return');
				break;
		}
		
	}

	public function inventory_print_view($print_section = null,$id = null){
		
		//		$this->autoRender = false ;
		$this->layout = false;
		if($id == null){
			$this->Session->setFlash(__('Invalid Id for '.$print_section.'', true));
		}

		$this->InventoryPharmacySalesReturn->bindModel(array(
				'belongsTo' => array('Person' =>array('foreignKey' => 'patient_id'))
		));
		$this->PharmacySalesBill->bindModel(array(
				'belongsTo' => array('Person' =>array('foreignKey' => 'patient_id'))
		));
		$this->set('section',$print_section);

		if($print_section == "PurchaseReceipt"){
			$model = "InventoryPurchaseDetail";
			$data = $this->$model->find('first',
			array('conditions'=>array('InventoryPurchaseDetail.id'=>$id,"InventoryPurchaseDetail.location_id" =>$this->Session->read('locationid'))));


			$this->set('data',$data);
		}else if($print_section == "PharmacySalesBill"){
			$model = "PharmacySalesBill";

			$this->PharmacySalesBill->unBindModel(array(
					'hasOne' => array('Patient')));
			$this->PharmacySalesBill->bindModel(array(
						'belongsTo' => array(
								'User' =>array('foreignKey' => 'guarantor_id','conditions'=>array('PharmacySalesBill.guarantor_id=User.id')),
								'DoctorProfile' =>array('foreignKey' => false,'conditions' => array('PharmacySalesBill.doctor_id = DoctorProfile.user_id')),
								'Patient' =>array('foreignKey' => false,'conditions' => array('Patient.id = PharmacySalesBill.patient_id')),
								'TariffStandard' =>array('foreignKey' => false,'conditions' => array('TariffStandard.id = Patient.tariff_standard_id'))
								)

			),false);

			$data = $this->PharmacySalesBill->find('first',array('conditions'=>
			array('PharmacySalesBill.id'=>$id,"PharmacySalesBill.location_id" =>$this->Session->read('locationid'),
							'PharmacySalesBill.is_deleted' =>'0'),
					'fields'=>array( 'PharmacySalesBill.*','Patient.*','DoctorProfile.doctor_name','TariffStandard.name')));
			
			$this->Bed->bindModel(array(
						'belongsTo' => array(
								'Room' =>array('foreignKey' => false,'conditions'=>array('Bed.room_id=Room.id')),
								'Patient' =>array('foreignKey' => false,'conditions' => array('Bed.patient_id = Patient.id')))
			),false); 
			
			$bedType = $this->Bed->find('first',array(
												'conditions'=>array('Bed.room_id'=>$data['Patient']['room_id'],'Bed.patient_id'=>$data['Patient']['id']),
												'fields'=>array('Bed.id','Room.room_type','Bed.bedno')));
			
			
			$formatted_address = $this->setAddressFormat($saleBill['Person']);
			$this->set('bedType',$bedType);
			$this->set('address',$formatted_address);
			// For Kanpur -- Leena
			$userName=$this->User->getUserDetails($data['PharmacySalesBill']['created_by']);
			$DocName=$this->User->getUserDetails($data['Patient']['doctor_id']);
			$this->set('userName',$userName['User']['username']);
			$this->set('createdDate',$data['PharmacySalesBill']['create_time']);
			$this->set('doctorName',$DocName);
		}else if($print_section == "InventoryPurchaseReturn"){
			$model = "InventoryPurchaseReturn";
			$data = $this->$model->find('first',array('conditions'=>
			array('InventoryPurchaseReturn.id'=>$id,"InventoryPurchaseReturn.location_id" =>$this->Session->read('locationid'))));
				
			/*$InventoryPurchaseDetail =  $this->InventoryPurchaseDetail->find('first',array('conditions'=>
			 array('InventoryPurchaseDetail.id'=>$purchaseReturn['InventoryPurchaseReturn']['inventory_purchase_detail_id'],"InventoryPurchaseDetail.location_id" =>$this->Session->read('locationid'))));
			 */
				
			$this->set('supplier',$purchaseReturn['InventorySupplier']);
		}else if($print_section == "PharmacyDuplicateSalesBill"){
			$this->uses = array("PharmacyDuplicateSalesBill","PharmacyDuplicateSalesBillDetail");
			$model = "PharmacyDuplicateSalesBill";
				
			//$this->PharmacySalesBill->unBindModel(array('hasMany'=>array('PharmacyDuplicateSalesBillDetail')/*,'belongsTo'=>array('Patient','Doctor')*/)) ;
			/*	$this->$model->bindModel(array(
			 'belongsTo' => array(
			 'User' =>array('foreignKey' => 'guarantor_id',
			 'conditions'=>array('PharmacyDuplicateSalesBill.guarantor_id=User.id')),
			 'PharmacyDuplicateSalesBillDetail'=>array(
			 'foreignKey' => false,
			 'conditions'=>array('PharmacyDuplicateSalesBillDetail.pharmacy_duplicate_sales_bill_id=PharmacyDuplicateSalesBill.id')),
			 'PharmacyItem'=>array(
			 'foreignKey' => false ,
			 'conditions'=>array('PharmacyDuplicateSalesBillDetail.item_id=PharmacyItem.id')),
			 'PharmacyItemRate'=>array(
			 'foreignKey' => false ,
			 'conditions'=>array('PharmacyItemRate.item_id=PharmacyDuplicateSalesBillDetail.item_id','PharmacyItemRate.batch_number=PharmacyDuplicateSalesBillDetail.batch_number')),
			 'Patient'=>array(
			 'foreignKey' => false ,
			 'conditions'=>array('PharmacyDuplicateSalesBill.patient_id=Patient.id')),
			 'Doctor' =>array('foreignKey' => false,
			 'conditions'=>array('Patient.doctor_id=Doctor.id')),

			 )));
			 	
			 	
			 $data = $this->PharmacyDuplicateSalesBill->find('all',array('conditions'=>
			 array('PharmacyDuplicateSalesBill.id'=>$id,"PharmacyDuplicateSalesBill.location_id" =>$this->Session->read('locationid'),'PharmacyDuplicateSalesBill.is_deleted' =>'0'),
			 'fields'=>array('PharmacyItemRate.*','User.username','PharmacyDuplicateSalesBill.*','Patient.lookup_name','Patient.person_id','Patient.id','Patient.city','PharmacyDuplicateSalesBillDetail.*','PharmacyItem.*','Doctor.*')));
			 */
			$this->PharmacyDuplicateSalesBill->unbindModel(array("belongsTo"=>array("Patient")));
			$this->$model->bindModel(array(
							'belongsTo' => array(
									'DoctorProfile' =>array('foreignKey' => false, 'conditions' => array('PharmacyDuplicateSalesBill.doctor_id = DoctorProfile.user_id' )),
									'Patient' =>array('foreignKey' => false,'conditions' => array('Patient.id = PharmacyDuplicateSalesBill.patient_id')),
								     'TariffStandard' =>array('foreignKey' => false,'conditions' => array('TariffStandard.id = Patient.tariff_standard_id')))
			));

			$data = $this->$model->find('first',array('conditions'=>
			array('PharmacyDuplicateSalesBill.id'=>$id,"PharmacyDuplicateSalesBill.location_id" =>$this->Session->read('locationid'),
							'PharmacyDuplicateSalesBill.is_deleted' =>'0'),
					'fields'=>array( 'PharmacyDuplicateSalesBill.*','Patient.*','DoctorProfile.doctor_name','TariffStandard.name'
					)));
						
					/* $saleBill = $this->PharmacySalesBill->find('first',array('conditions'=>
					 array('PharmacySalesBill.id'=>$id,"PharmacySalesBill.location_id" =>$this->Session->read('locationid'))));  */
					//debug($data);
					$formatted_address = $this->setAddressFormat($saleBill['Person']);
					//debug($data);
					$this->set('address',$formatted_address);
						
						
		}else if($print_section =='InventoryPharmacyDirectSalesReturnsDetail'){ 
			$model = "InventoryPharmacySalesReturn";
			$this->$model->bindModel(array(
					'belongsTo' => array(
							'PharmacySalesBill' =>array('foreignKey' => false,'conditions' => array('PharmacySalesBill.id = InventoryPharmacySalesReturn.pharmacy_sale_bill_id')),
					)));
			$data = $this->$model->find('first',array('conditions'=>
			array('InventoryPharmacySalesReturn.id'=>$id,"InventoryPharmacySalesReturn.location_id" =>$this->Session->read('locationid'),'InventoryPharmacySalesReturn.is_deleted' =>'0'),
			'fields'=>array('InventoryPharmacySalesReturn.*','PharmacySalesBill.id','PharmacySalesBill.customer_name','PharmacySalesBill.bill_code','PharmacySalesBill.p_doctname','PharmacySalesBill.total','PharmacySalesBill.discount'))); 
		
		}else if($print_section == 'DirectSalesReturn'){
			$model = "InventoryPharmacySalesReturn";
			$data = $this->$model->find('first',array('conditions'=>
					array('InventoryPharmacySalesReturn.id'=>$id,"InventoryPharmacySalesReturn.location_id" =>$this->Session->read('locationid'),'InventoryPharmacySalesReturn.is_deleted' =>'0'),
					));
			$userName=$this->User->getUserDetails($data['InventoryPharmacySalesReturn']['created_by']);
			$this->set('userName',$userName['User']['username']);
			$this->set('createdDate',$data['InventoryPharmacySalesReturn']['create_time']);
			
		}else{
			$model = "InventoryPharmacySalesReturn";
			//$this->$model->unbindModel(array('hasMany'=>array('InventoryPharmacySalesReturnsDetail')));
			$this->$model->bindModel(array(
					'belongsTo' => array(
						'Patient'=>array('foreignKey' => 'patient_id'),
						'Doctor' =>array('foreignKey' => false,'conditions'=>array('Patient.doctor_id=Doctor.id')),
						'DoctorProfile' =>array('foreignKey' => false,'conditions' => array('Patient.doctor_id = DoctorProfile.user_id')),
					    'TariffStandard' =>array('foreignKey' => false,'conditions' => array('TariffStandard.id = Patient.tariff_standard_id'))
			)));
			$data = $this->$model->find('first',array('conditions'=>
			array('InventoryPharmacySalesReturn.id'=>$id,"InventoryPharmacySalesReturn.location_id" =>$this->Session->read('locationid'),'InventoryPharmacySalesReturn.is_deleted' =>'0'),
					'fields'=>array('InventoryPharmacySalesReturn.*','Patient.*','DoctorProfile.doctor_name','TariffStandard.name')));
			$formatted_address = $this->setAddressFormat($saleReturn['Person']);
			// For Kanpur -- Leena
			$userName=$this->User->getUserDetails($data['InventoryPharmacySalesReturn']['created_by']);
			$this->set('userName',$userName['User']['username']);
			$this->set('createdDate',$data['InventoryPharmacySalesReturn']['create_time']);

			$this->set('address',$formatted_address);
		}

		$this->set('data',$data);

		$website = $this->Session->read('website.instance');
		if($website == 'kanpur')
		{
			if($this->request->query['flag'] == 'header'){

				$this->render("inventory_prin_view_with_header");
			}else  {
				$this->render("inventory_print_view_kanpur");
			}
		}else if($website == 'vadodara')
		{
			if($this->request->query['flag'] == 'header'){
				$this->render("inventory_print_view_with_header_vado");
			}/*else  {
			$this->render("inventory_print_view_vado");
			}*/
				
		}
	}
	/* Purchase return*/

	public function inventory_print_view_kanpur($print_section = null,$id = null){

		if($id == null){
			$this->Session->setFlash(__('Invalid Id for '.$print_section.'', true));
		}

		$this->InventoryPharmacySalesReturn->bindModel(array(
				'belongsTo' => array('Person' =>array('foreignKey' => 'patient_id'))
		));
		$this->PharmacySalesBill->bindModel(array(
				'belongsTo' => array('Person' =>array('foreignKey' => 'patient_id'))
		));
		$this->set('section',$print_section);

		if($print_section == "PurchaseReceipt"){
			$model = "InventoryPurchaseDetail";
			$data = $this->$model->find('first',
			array('conditions'=>array('InventoryPurchaseDetail.id'=>$id,"InventoryPurchaseDetail.location_id" =>$this->Session->read('locationid'))));


			$this->set('data',$data);
		}else if($print_section == "PharmacySalesBill"){
			$model = "PharmacySalesBill";

			$this->PharmacySalesBill->unBindModel(array('hasMany'=>array('PharmacySalesBillDetail')/*,'belongsTo'=>array('Patient','Doctor')*/)) ;
			$this->$model->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey' => 'guarantor_id',
									'conditions'=>array('PharmacySalesBill.guarantor_id=User.id')),
							'PharmacySalesBillDetail'=>array(
									'foreignKey' => false,
									'conditions'=>array('PharmacySalesBillDetail.pharmacy_sales_bill_id=PharmacySalesBill.id')),
							'PharmacyItem'=>array(
									'foreignKey' => false ,
									'conditions'=>array('PharmacySalesBillDetail.item_id=PharmacyItem.id')),
							'PharmacyItemRate'=>array(
									'foreignKey' => false ,
									'conditions'=>array('PharmacyItemRate.item_id=PharmacySalesBillDetail.item_id','PharmacyItemRate.batch_number=PharmacySalesBillDetail.batch_number')),
							'Patient'=>array(
									'foreignKey' => false ,
									'conditions'=>array('PharmacySalesBill.patient_id=Patient.id')),
							'Doctor' =>array('foreignKey' => false,
									'conditions'=>array('Patient.doctor_id=Doctor.id')),

			)));


			$data = $this->PharmacySalesBill->find('all',array('conditions'=>
			array('PharmacySalesBill.id'=>$id,"PharmacySalesBill.location_id" =>$this->Session->read('locationid'),'PharmacySalesBill.is_deleted' =>'0'),
					'fields'=>array('PharmacyItemRate.*','User.username','PharmacySalesBill.*','Patient.lookup_name','Patient.person_id','Patient.id','Patient.city','PharmacySalesBillDetail.*','PharmacyItem.*','Doctor.*')));

			$formatted_address = $this->setAddressFormat($saleBill['Person']);
				
			//get username
			$this->loadModel('User');
			$userName=$this->User->getUserDetails($data['0']['PharmacySalesBill']['created_by']);
			$this->set('address',$formatted_address);
			$this->set('userName',$userName['User']['username']);
			$this->set('createdDate',$data['0']['PharmacySalesBill']['create_time']);

		}else if($print_section == "InventoryPurchaseReturn"){
			$model = "InventoryPurchaseReturn";
			$data = $this->$model->find('first',array('conditions'=>
			array('InventoryPurchaseReturn.id'=>$id,"InventoryPurchaseReturn.location_id" =>$this->Session->read('locationid'))));
			/*$InventoryPurchaseDetail =  $this->InventoryPurchaseDetail->find('first',array('conditions'=>
			 array('InventoryPurchaseDetail.id'=>$purchaseReturn['InventoryPurchaseReturn']['inventory_purchase_detail_id'],"InventoryPurchaseDetail.location_id" =>$this->Session->read('locationid'))));
			 */
			$this->set('supplier',$purchaseReturn['InventorySupplier']);
		}else{
			$model = "InventoryPharmacySalesReturn";
			$this->$model->unbindModel(array('hasMany'=>array('InventoryPharmacySalesReturnsDetail')));
			$this->$model->bindModel(array(
					'belongsTo' => array(
							'InventoryPharmacySalesReturnsDetail'=>array(
									'foreignKey' => false,
									'conditions'=>array('InventoryPharmacySalesReturnsDetail.inventory_pharmacy_sales_return_id=InventoryPharmacySalesReturn.id')),
							'PharmacyItem'=>array(
									'foreignKey' => false ,
									'conditions'=>array('InventoryPharmacySalesReturnsDetail.item_id=PharmacyItem.id')),
							'PharmacyItemRate'=>array(
									'foreignKey' => false ,
									'conditions'=>array('PharmacyItemRate.item_id=InventoryPharmacySalesReturnsDetail.item_id','PharmacyItemRate.batch_number=InventoryPharmacySalesReturnsDetail.batch_no')),
							'Patient'=>array(
									'foreignKey' => false ,
									'conditions'=>array('InventoryPharmacySalesReturn.patient_id=Patient.id')),
							'Doctor' =>array('foreignKey' => false,
									'conditions'=>array('Patient.doctor_id=Doctor.id')),

			)));

			$data = $this->$model->find('all',array('conditions'=>
			array('InventoryPharmacySalesReturn.id'=>$id,"InventoryPharmacySalesReturn.location_id" =>$this->Session->read('locationid'),'InventoryPharmacySalesReturn.is_deleted' =>'0'),
					'fields'=>array('PharmacyItemRate.*',/*'User.username',*/'InventoryPharmacySalesReturn.*','Patient.lookup_name','Patient.person_id','Patient.id',
							'Patient.city','InventoryPharmacySalesReturnsDetail.*','PharmacyItem.*','Doctor.*')));
				
			$formatted_address = $this->setAddressFormat($saleReturn['Person']);
			$this->set('address',$formatted_address);
		}

		$this->set('data',$data);
		/*
			$this->loadModel('pharmacyItem');
			foreach($data[$model] as $key=>$value){
			$item[] = $this->PharmacyItem->findById($value['item_id']);
			} */
		//$this->$model->findById();
		//$this->set('model',$model);
		$this->layout = false;
	}

	public function inventory_purchase_return(){
		$this->set('title_for_layout', __('Pharmacy Management - Purchase Return', true));
		if ($this->request->is('post')) {
			//pr($this->request->data);  exit;
			/*	$purchaseDetail =  $this->InventoryPurchaseDetail->find('first',array('conditions'=>array("InventoryPurchaseDetail.location_id" =>$this->Session->read('locationid'),"InventoryPurchaseDetail.vr_no"=>$this->request->data['InventoryPurchaseDetail']['vr_no'])));
				if(!$purchaseDetail){
				$this->Session->setFlash(__('Invalid Voucher Number', true));
				$this->redirect(array("controller" => "pharmacy", "action" => "purchase_return",'inventory'=>true));
				}*/
			//pr( $this->request->data);exit;
			$this->request->data['InventoryPurchaseReturn']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['InventoryPurchaseReturn']['created_by'] = $this->Auth->user('id');
			$this->request->data['InventoryPurchaseReturn']['location_id'] = $this->Session->read('locationid');
			// $this->request->data['InventoryPurchaseReturn']['inventory_purchase_detail_id'] = $purchaseDetail['InventoryPurchaseDetail']['id'];
			//  $this->request->data['InventoryPurchaseReturn']['total_amount'] =$this->request->data['InventoryPurchaseReturn']['grand_amount'];
			$this->InventoryPurchaseReturn->save($this->request->data);
			$errors = $this->InventoryPurchaseReturn->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$insertDetails = $this->InventoryPurchaseReturnItem->saveReturnDetails($this->request->data,$this->InventoryPurchaseReturn->id);
				$this->Session->setFlash(__('Purchase Return Data added successfully', true));
				if($this->request->data['print']){
					$url = Router::url(array("controller" => "pharmacy", "action" => "inventory_print_view",'InventoryPurchaseReturn',$this->InventoryPurchaseReturn->id,'inventory'=>true));

					echo "<script>window.open('".$url."','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true )</script>";
				}else{
					$this->redirect(array("controller" => "pharmacy", "action" => "get_pharmacy_details",'purchase_return',$this->InventoryPurchaseReturn->id,'inventory'=>true));
				}
			}
		}
	}

	/*for details of purchase return */
	public function inventory_purchase_return_item_details($prId = null){
		if($prId !=null){
			$prDetails = $this->InventoryPurchaseReturn->find('first',array('conditions'=>
			array("InventoryPurchaseReturn.id"=>$prId,"InventoryPurchaseReturn.location_id" =>$this->Session->read('locationid'))));
			$this->set("data", $prDetails);
		}else{
			$this->Session->setFlash(__('Invalid Sales Return', true));
			$this->set("data", array());
		}
	}

	/* for sales reurrn details*/
	public function inventory_sale_return_item_details($prId = null){
		if($prId !=null){
			$prDetails = $this->InventoryPharmacySalesReturn->find('first',array('conditions'=>
			array("InventoryPharmacySalesReturn.id"=>$prId,"InventoryPharmacySalesReturn.location_id" =>$this->Session->read('locationid'),
							'InventoryPharmacySalesReturn.is_deleted'=>'0')));

			$this->set("data", $prDetails);
		}else{
			$this->Session->setFlash(__('Invalid Sales Return', true));
			$this->set("data", array());
		}

	}


	public function getPack(){
		$data = $this->PharmacyItem->find('list',array('fields'=> array("id","pack"),'conditions' => array("PharmacyItem.name"=>$this->params->query['drug'],'NOT'=>array("PharmacyItem.name"=>null,"PharmacyItem.pack"=>null))));
		$output ="";
		foreach ($data as $key=>$value) {
			$output .=$value."|".$key."\n";
		}
		echo $output;
		exit;
	}

	//function to import product data
	public function admin_import_data(){
		App::import('Vendor', 'reader');
		$this->set('title_for_layout', __('Tariff- Import Data', true));
		if ($this->request->is('post')) { //pr($this->request->data);
			if($this->request->data['importData']['import_file']['error'] !="0"){
				$this->Session->setFlash(__('Please Upload the file'), 'default', array('class' => 'error'));
				$this->redirect(array("controller" => "pharmacy", "action" => "import_data","admin"=>true));
			}
			/*if($this->request->data['importData']['import_file']['size'] > "1000000"){
			 $this->Session->setFlash(__('Size exceed Please upload 1 MB size file.'), 'default', array('class' => 'error'));
			 $this->redirect(array("controller" => "pharmacy", "action" => "import_data","admin"=>true));
			 }*/
				
			$vadodaraLocations = $this->params->query['location'];
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1251');
			ini_set('memory_limit',-1);
			set_time_limit(0);
			$path = WWW_ROOT.'uploads/import/'. $this->request->data['importData']['import_file']['name'];
			move_uploaded_file($this->request->data['importData']['import_file']['tmp_name'],$path );
			chmod($data->path,777);
			$data = new Spreadsheet_Excel_Reader($path);
			$is_uploaded = $this->PharmacyItem->importData($data,$vadodaraLocations); 
			
		/*	if($is_uploaded == true){
				unlink( $path );
				$this->Session->setFlash(__('Data imported sucessfully'), 'default', array('class' => 'message'));
				//$this->redirect($this->referer());
			}else{
				unlink( $path );
				$this->Session->setFlash(__('Error Occured Please check your Excel sheet.'), 'default', array('class' => 'error'));
				$this->redirect($this->referer());
			}*/

		}

	}

	public function inventory_pharmacy_report(){

	}

	public function getPrescribedDetail($patientId){
		$this->autoRender = false;
		$this->loadModel('NewCropPrescription');
		$this->loadModel('PharmacyItem');
		$drugId = $this->NewCropPrescription->find('list',array('fields'=>array('id','drug_id'),'conditions'=>array('patient_uniqueid'=>$patientId)));
		$this->PharmacyItem->bindModel(array(
				'hasOne' => array(
						'PharmacyItemRate' =>array('foreignKey'=>false,'conditions'=>array('PharmacyItem.id = PharmacyItemRate.item_id')),
		),
		));
		$pharmacyData = $this->PharmacyItem->find('all',array('fields'=>array('drug_id','item_code','name','manufacturer','pack','stock','PharmacyItemRate.id',
				'PharmacyItemRate.batch_number','PharmacyItemRate.expiry_date','PharmacyItemRate.mrp','PharmacyItemRate.sale_price'),
				'conditions'=>array('drug_id'=>$drugId)));
		return json_encode($pharmacyData);
	}

	// added by atul for importing supplierlist in master
	public function inventory_import_data(){

		App::import('Vendor', 'reader');
		$this->set('title_for_layout', __('Supplier- Export Data', true));
		if ($this->request->is('post')) { //pr($this->request->data);
			if($this->request->data['importData']['import_file']['error'] !="0"){
				$this->Session->setFlash(__('Please Upload the file'), 'default', array('class' => 'error'));
				$this->redirect(array("controller" => "Pharmacy", "action" => "import_data","admin"=>false));
			}
			/*if($this->request->data['importData']['import_file']['size'] > "1000000"){
			 $this->Session->setFlash(__('Size exceed Please upload 1 MB size file.'), 'default', array('class' => 'error'));
			 $this->redirect(array("controller" => "Tariffs", "action" => "import_data","admin"=>true));
			 }*/
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1251');
			ini_set('memory_limit',-1);
			set_time_limit(0);
			$path = WWW_ROOT.'uploads/import/'. $this->request->data['importData']['import_file']['name'];
			move_uploaded_file($this->request->data['importData']['import_file']['tmp_name'],$path );
			chmod($data->path,777);
			$data = new Spreadsheet_Excel_Reader($path);
			$is_uploaded = $this->InventorySupplier->importData($data);
			if($is_uploaded == true){
				unlink( $path );
				$this->Session->setFlash(__('Data imported sucessfully'), 'default', array('class' => 'message'));
				$this->redirect(array("controller" => "Pharmacy", "action" => "import_data","inventory"=>true));
			}else{
				unlink( $path );
				$this->Session->setFlash(__('Error Occured Please check your Excel sheet.'), 'default', array('class' => 'error'));
				$this->redirect(array("controller" => "Pharmacy", "action" => "import_data","inventory"=>true));
			}

		}

	}

	/* Item Rate Master
	 * To display added item rate records
	 * by Mrunal
	 */
	public function view_item_rate(){

		$this->uses=array('PharmacyItem','PharmacyItemRate','Location');
		$this->PharmacyItem->unbindModel(array('hasMany' => array('InventoryPurchaseItemDetail')),false);

		$this->PharmacyItem->bindModel(array('belongsTo'=>array('Location'=>array('foreignKey'=>false,'conditions'=>array('PharmacyItem.location_id = Location.id'),'fields'=>array('Location.id','Location.name')))));

		$itemName = $this->request->query['name'];
		$itemCode = $this->request->query['item_code'];
		$locationName = $this->request->query['location_id'];
		if(!empty($itemName)){
			$conditions['PharmacyItem.name'] = $itemName;
		}
		if(!empty($itemCode)){
			$conditions['PharmacyItem.item_code'] = $itemCode;
		}
		if(!empty($locationName)){
			$conditions['PharmacyItem.location_id'] = $locationName;
		}
		if($this->Session->read('website.instance')=='kanpur'){ //added by pankaj w as we dont need location filter for vadodara and hope
			$conditions['PharmacyItem.location_id'] =$this->Session->read('locationid');
		}

		$this->paginate = array(
				'limit' => 15,
				'fields'=>array('PharmacyItem.id','PharmacyItem.name','PharmacyItem.pack','PharmacyItem.item_code','PharmacyItemRate.id','PharmacyItemRate.location_id','PharmacyItemRate.batch_number','PharmacyItemRate.purchase_price','PharmacyItemRate.mrp','PharmacyItemRate.sale_price','PharmacyItemRate.stock',
						'PharmacyItemRate.tax','PharmacyItemRate.expiry_date','PharmacyItemRate.loose_stock','PharmacyItemRate.vat_class_name','Location.id','Location.name'),
				'conditions' =>array($conditions,array('PharmacyItemRate.is_deleted'=>'0','PharmacyItemRate.batch_number IS NOT NULL','PharmacyItemRate.stock IS NOT NULL'/*,"PharmacyItemRate.location_id" =>$this->Session->read('locationid')*/)),
				'order'=>array("PharmacyItem.name"=>"ASC","PharmacyItemRate.stock"=>"DESC","PharmacyItemRate.loose_stock"=>"DESC")
		);

		$itemDetails = $this->paginate('PharmacyItem');//debug($itemDetails);
		$location = $this->Location->find('list', array('fields'=> array('id', 'name'),'conditions'=>array('Location.is_active' => 1, 'Location.is_deleted' => 0)));
		$this->set('location',$location);
		$this->set('itemDetails',$itemDetails);
	}

	/* Display of particular item rate detail
	 */
	public function view_rate($id = null){

		$this->uses=array('PharmacyItem','PharmacyItemRate');
		$this->PharmacyItem->unbindModel(array('hasMany' => array('InventoryPurchaseItemDetail')),false);
		/* locationId is added for Kanpur- By MRUNAL */
		if($this->Session->read('website.instance')=='kanpur'){
			$this->set('itemDetails', $this->PharmacyItem->find('first',array('conditions' => array("PharmacyItem.location_id" =>$this->Session->read('locationid'),"PharmacyItemRate.location_id"=>$this->Session->read('locationid'),"PharmacyItemRate.id" => $id))));
		}else{
			$this->set('itemDetails', $this->PharmacyItem->find('first',array('conditions' => array("PharmacyItemRate.id" => $id))));
		}
	}

	/* edit particular item rate details
	 */
	public function edit_item_rate($id = null){
		$this->loadModel('Configuration');
		$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website')));
		$websiteConfig=unserialize($website_service_type['Configuration']['value']);
		$this->set('websiteConfig',$websiteConfig);

		$this->uses=array('PharmacyItem','PharmacyItemRate','VatClass');
		$this->PharmacyItem->unbindModel(array('hasMany' => array('InventoryPurchaseItemDetail')),false);
		if($this->params->query['type']=='edit'){
			$id=$this->params->query['itemId'];
			$this->layout='advance_ajax';
			if(!empty($this->params->query['item_rate_id']) && $this->params->query['item_rate_id']!='null')
			$condition=array('PharmacyItemRate.id'=>$this->params->query['item_rate_id']);
				
		}

		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Item ID', true));
			$this->redirect(array("controller" => "pharmacy", "action" => "view_item_rate"));
		}
		if ($this->request->is('post') && !empty($this->request->data)) {
			
			$this->request->data['PharmacyItemRate']['expiry_date'] = $this->DateFormat->formatDate2STD($this->request->data['PharmacyItemRate']['expiry_date'],Configure::read('date_format'));
			$stock = $this->request->data['PharmacyItemRate']['stock'];
			$this->request->data['PharmacyItemRate']['stock'] = floor($stock/$this->request->data['PharmacyItemRate']['pack']);
			$this->request->data['PharmacyItemRate']['loose_stock'] = floor($stock%$this->request->data['PharmacyItemRate']['pack']);
			 
			/* By Mrunal for Kanpur
			 * For vat Calculations  */
			if(!empty($this->request->data['PharmacyItemRate']['vat_class_id'])){
				$vatDetails = $this->VatClass->find('first',array(
						'conditions'=>array('VatClass.id'=> $this->request->data['PharmacyItemRate']['vat_class_id']),
						'fields'=>array('id','vat_of_class','sat_percent','vat_percent')));

				$addVatSat = $vatDetails['VatClass']['sat_percent'] + $vatDetails['VatClass']['vat_percent'];
				$this->request->data['PharmacyItemRate']['vat_sat_sum'] = $addVatSat;  // addition of vat and sat - stors in ItemRate
				$this->request->data['PharmacyItemRate']['vat_class_name'] =  $vatDetails['VatClass']['vat_of_class'];
			}
			
			if($this->PharmacyItemRate->save($this->request->data)){
				
				$pharmaCode = $this->PharmacyItemRate->find('first',array('fields'=>array('SUM(PharmacyItemRate.stock) as stock',
						'SUM(PharmacyItemRate.loose_stock) as loose_stock'),
						'conditions'=>array('PharmacyItemRate.is_deleted'=>0,'PharmacyItemRate.item_id'=>$this->request->data['PharmacyItemRate']['item_id'])));
				
				$msu = ($pharmaCode[0]['stock'] * $this->request->data['PharmacyItemRate']['pack']) + $pharmaCode[0]['loose_stock'];
				
				$pharmaUpdateItemCode['stock'] = floor($msu / $this->request->data['PharmacyItemRate']['pack']);
				$pharmaUpdateItemCode['loose_stock'] =  floor($msu % $this->request->data['PharmacyItemRate']['pack']);
				$this->PharmacyItem->id = $this->request->data['PharmacyItemRate']['item_id'];
				$this->PharmacyItem->save($pharmaUpdateItemCode);
				$this->PharmacyItem->id = "";
			}
			
				
			$errors = $this->PharmacyItemRate->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {

				$this->Session->setFlash(__('The Item has been updated', true));
				if($this->params->query['type']=='edit'){
					echo "<script>
							var fieldNo=parent.$('#no_of_fields').val();
								parent.$('#item_code'+fieldNo).val('');
								parent.$('#item_id'+fieldNo).val('');
								parent.$('#item_name-'+fieldNo).val('');
								parent.$('#manufacturer'+fieldNo).val('');
								parent.$('#pack'+fieldNo).val('');
								parent.$('#batch_number'+fieldNo).empty();
								parent.$('#stockQty'+fieldNo).val('');
								parent.$('#expiry_date'+fieldNo).val('');
								parent.$('#mrp'+fieldNo).val('');
								parent.$('#rate'+fieldNo).val('');
								parent.$.fancybox.close();
							</script>";
				}else{
					$this->redirect(array("controller" => "pharmacy", "action" => "view_item_rate"));
				}
			}
		} else {
			$this->set('itemDetails', $this->PharmacyItem->find('first',array(
					'fields'=>array('PharmacyItem.id','PharmacyItem.pack','PharmacyItem.id','PharmacyItem.drug_id','PharmacyItem.name','PharmacyItem.code','PharmacyItem.location_id','PharmacyItemRate.*'),	
					'conditions' => array(/* "PharmacyItem.location_id" =>$this->Session->read('locationid'), */
							"PharmacyItemRate.id" => $id, $condition))));
		}
		
		$vatData = $this->VatClass->find('list',array(
								'conditions'=>array('VatClass.is_delete'=>'0'),
								'fields'=>array('id','vat_of_class'),
		/*'order'=>array('VatClass.create_time'=>'desc')*/));

		//debug($vatData);
		$this->set(compact(array('data','vatData')));


	}

	/* To delete particular item
	 */
	public function itemRate_delete($id = null) {
		$this->set('title_for_layout', __('Pharmacy Management - Delete Item Rate ', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid ID	', true));
			$this->redirect(array("controller" => "pharmacy", "action" => "view_item_rate"));
		}
		if ($id) {
			$this->PharmacyItemRate->deletePharmacyItemRate($id);
			$this->Session->setFlash(__('Item Rate deleted', true));
			$this->redirect(array("controller" => "pharmacy", "action" => "view_item_rate"));
		}
	}

	/* End of Item Rate */

	/* for autocomplete og Sales bill */
	public function inventory_fetch_batch_for_item(){
		$this->layout  = 'ajax' ;
		$this->loadModel('PharmacyItemRate');
		$item = $this->PharmacyItemRate->find('first',array('conditions'=>array('PharmacyItemRate.id'=>$this->request->query['itemRate'])));
		if(!empty($item)){
			if(strtolower($this->Session->read('website.instance')) == "hope"){
				$item['PharmacyItemRate']['sale_price'] = $item['PharmacyItemRate']['mrp'];
			}
			$item['PharmacyItemRate']['expiry_date'] = $this->DateFormat->formatDate2Local($item['PharmacyItemRate']['expiry_date'],Configure::read('date_format'));
			$item['PharmacyItemRate']['loose_stock'] = $item['PharmacyItemRate']['loose_stock']!=""?$item['PharmacyItemRate']['loose_stock']:0;
		}
		echo (json_encode($item));
		exit;
	}

	/**
	 * function to add new product from sales bill
	 * pooja
	 *
	 */
	public function add_new_product(){
		$this->layout='advance_ajax';
		$this->uses=array('Product','PharmacyItem','PharmacyItemRate','Configuration','VatClass','Location');
		$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website')));
		$websiteConfig=unserialize($website_service_type['Configuration']['value']);
		$this->set('websiteConfig',$websiteConfig);
		$this->set('locations',$this->Location->find('list',array('fields'=>array('id','name'))));
		if($this->request->data){
			//debug($this->request->data);exit;
			$expiry_date = $this->DateFormat->formatDate2STD($this->request->data['Product']['expiry_date'],Configure::read('date_format'));
			$this->request->data['Product']['expiry_date']=$expiry_date;
			$this->request->data['Product']['date']=$this->DateFormat->formatDate2STD($this->request->data['Product']['date'],Configure::read('date_format'));
			$this->request->data['Product']['expensive_product'] = $this->request->data['Product']['expensive_product'];
			$this->request->data['Product']['is_implant'] = $this->request->data['Product']['is_implant'];
			$this->request->data['Product']['location_id'] = $this->request->data['Product']['location_id'];
			//debug($this->request->data);exit;
			if($this->Product->save($this->request->data['Product'])){
				$prodId=$this->Product->getLastInsertID();
				if(!empty($prodId)){
					$this->PharmacyItem->save(array(
							"location_id"=>$this->request->data['Product']['location_id'],
							"expensive_product"=> $this->request->data['Product']['expensive_product'],
							"is_implant"=> $this->request->data['Product']['is_implant'],
							"name"=>$this->request->data['Product']['name'],
							"item_code"=>$this->request->data['Product']['product_code'],
							"drug_id"=>$prodId,
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
							"opdgeneral_ward_discount"=>$this->request->data['Product']['opdgeneral_ward_discount'],
							"create_time"=> date('Y-m-d'),
							"created_by"=>$this->Session->read('userid'),
					));
				}
					
				$pharItemId=$this->PharmacyItem->getLastInsertID();
				if(!empty($pharItemId) && !empty($this->request->data['Products']['batch_number'])){	//if batch exists then only save into itemrate by Swapnil G.Sharma
					$this->PharmacyItemRate->save(array(
							"item_id"=>$pharItemId,
    							"mrp"=>$this->request->data['Product']['mrp'],
                                "batch_number"=>$this->request->data['Product']['batch_number'],
                                "expiry_date"=>$this->request->data['Product']['expiry_date'],
    							"tax"=>$this->request->data['Product']['tax'],
    							"purchase_price"=>$this->request->data['Product']['purchase_price'],
    							"cst"=>$this->request->data['Product']['cst'],
    							"cost_price"=>$this->request->data['Product']['purchase_price'],//cost price
    							"sale_price"=> $this->request->data['Product']['sale_price'],
                                "mstpflag"=>'P',
								"stock"=>$this->request->data['Products']['quantity'],
					)
					);
						
				}
					
				$pName=$this->request->data['Product']['name'];
				$pCode=$this->request->data['Product']['product_code'];
				$pmanu=$this->request->data['Product']['manufacturer'];
				$pack=$this->request->data['Product']['pack'];
				$pbatch=$this->request->data['Product']['batch_number'];
				$stock=$this->request->data['Products']['quantity'];
				$expiry=$this->DateFormat->formatDate2Local($this->request->data['Product']['date'],Configure::read('date_format'));
				$mrp=$this->request->data['Product']['mrp'];
				$rate=$this->request->data['Product']['sale_price'];
					
				/*	echo "<script>var fieldNo=parent.$('#no_of_fields').val();
				 parent.$('#item_code'+fieldNo).val(".$pCode.");
				 parent.$('#item_name'+fieldNo).val(".$pName.");
				 parent.$('#manufacturer'+fieldNo).val(".$pmanu.");
				 parent.$('#pack'+fieldNo).val(".$pack.");
				 parent.$('#batch_number'+fieldNo).val(".$pbatch.");
				 parent.$('#stockQty'+fieldNo).val(".$stock.");
				 parent.$('#expiry_date'+fieldNo).val(".$expiry.");
				 parent.$('#mrp'+fieldNo).val(".$mrp.");
				 parent.$('#rate'+fieldNo).val(".$rate.");
				 </script>";*/
				echo "<script>
								parent.$.fancybox.close();
						</script>" ;
					
					
			}
				
		}
		$vatData = $this->VatClass->find('list',array(
					'conditions'=>array('VatClass.is_delete'=>'0'),
					'fields'=>array('id','vat_of_class'),
		/*'order'=>array('VatClass.create_time'=>'desc')*/));
			
		//debug($vatData);
		$this->set(compact(array('data','vatData')));

	}

	//fucntion to fetch doctor name from selected patient
	function inventory_fetch_patient_doctor_name(){
		$this->loadModel('Patient');
		$patient_id = $this->request->query['patient'] ;
		$this->Patient->unBindModel(array(
		'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));

		$this->Patient->bindModel(array(
		'belongsTo' => array( 
				'DoctorProfile' =>array('foreignKey'=>false, 'conditions'=>array('DoctorProfile.user_id=Patient.doctor_id' ))
		)));

		$output =$this->Patient->find('first',array('fields'=>array('DoctorProfile.doctor_name','DoctorProfile.user_id'),
			'conditions'=>array('Patient.id'=>$patient_id) ));

		$returnArray = array('id'=>$output['DoctorProfile']['user_id'],'name'=>$output['DoctorProfile']['doctor_name']);
		echo json_encode($returnArray);
		exit;//dont remove this
	}

	/**
	 * Function to delete sales bill or Sales return and update stock of pharmacy item and Pharmacy item rates
	 * @param unknown_type $type
	 * @param unknown_type $id
	 * Pooja
	 */
	function inventory_sales_delete($type,$id){

		if(empty($id)){
			$this->Session->setFlash(__('Sales bill Does not exists', true));
		}else{
			$this->loadModel('VoucherEntry');
			$this->loadModel('NewCropPrescription');
			$this->loadModel('Billing');
			if($type=='sales'){
				$this->loadModel('PharmacySalesBill');
				$this->loadModel('PharmacySalesBillDetail');
				$this->PharmacySalesBillDetail->bindModel(array(
						'belongsTo'=>array('PharmacyItemRate'=>array('foreignKey'=>false,'conditions'=>array('PharmacyItem.id=PharmacyItemRate.item_id',
								'PharmacySalesBillDetail.batch_number=PharmacyItemRate.batch_number')))));
				$itemInStock=$this->PharmacySalesBillDetail->find('all',array('conditions'=>array('PharmacySalesBillDetail.pharmacy_sales_bill_id'=>$id)));

				//update stock in pharmacy Item and Pharmacy item rates
				foreach($itemInStock as $stock){
						
					//sales details
					$salePack = $stock['PharmacySalesBillDetail']['pack'];
					$qtyType = $stock['PharmacySalesBillDetail']['qty_type'];
					$saleQty = $stock['PharmacySalesBillDetail']['qty'];
						
					if($qtyType == "Tab"){
						$soldTab = $saleQty;
					}else{
						$soldTab = (int)$salePack * $saleQty;
					}
						
					//pharmacyItem Details
					$pharStock = $stock['PharmacyItem']['stock'];
					$pharLooseStock = $stock['PharmacyItem']['loose_stock'];
					$pharPack = $stock['PharmacyItem']['pack'];
					$pharTotalTab = (int)$pharPack * $pharStock + $pharLooseStock;
					$currentPharTabs = $pharTotalTab + $soldTab;
					$newPharStock = floor($currentPharTabs / $pharPack);
					$newPharLooseStock = $currentPharTabs % $pharPack;
						
					//pharmacyItemRate Details
					$pharRateStock = $stock['PharmacyItemRate']['stock'];
					$pharRateLooseStock = $stock['PharmacyItemRate']['loose_stock'];
					$pharRateTotalTab = (int)$pharPack * $pharRateStock + $pharRateLooseStock;
					$currentPharRateTabs = $pharRateTotalTab + $soldTab;
					$newPharRateStock = floor($currentPharRateTabs / $pharPack);
					$newPharRateLooseStock = $currentPharRateTabs % $pharPack;
						
					//new PharmacyItem Stock
					$pharmacyItemStock['PharmacyItem']['stock'] = $newPharStock;
					$pharmacyItemStock['PharmacyItem']['loose_stock'] = $newPharLooseStock;
					$pharmacyItemStock['PharmacyItem']['id'] = $stock['PharmacyItem']['id'];
					$this->PharmacyItem->save($pharmacyItemStock);
					$this->PharmacyItem->id = "";
						
					//new PharmacyItemRate Stock
					$pharmacyItemRateStock['PharmacyItemRate']['stock'] = $newPharRateStock;
					$pharmacyItemRateStock['PharmacyItemRate']['loose_stock'] = $newPharRateLooseStock;
					$pharmacyItemRateStock['PharmacyItemRate']['id'] = $stock['PharmacyItemRate']['id'];
					$this->PharmacyItemRate->save($pharmacyItemRateStock);
					$this->PharmacyItemRate->id = "";
						
				}

				//$this->VoucherEntry->updateAll(array('VoucherEntry.is_deleted'=>'1'),array('VoucherEntry.billing_id'=>$id));//for accounting - amit
				$this->PharmacySalesBill->updateAll(array('PharmacySalesBill.is_deleted'=>'1'),array('PharmacySalesBill.id'=>$id));
				$this->Billing->updateAll(array('Billing.is_deleted'=>'1'),array('Billing.pharmacy_sales_bill_id'=>$id));

				$newUpdatedSalesId = $this->NewCropPrescription->find('all',
				array('conditions'=>array('NewCropPrescription.pharmacy_sales_bill_id'=>$id),
								'fields'=>array('id','pharmacy_sales_bill_id')));
				
				/* By Mrunal on delete of sales bill update Pharmacy_sales_bill_id as null */
				foreach($newUpdatedSalesId as $updated){
						
					if($updated['NewCropPrescription']['id']){
						$arrayUpdate = array();
						$arrayUpdate['id'] = $updated['NewCropPrescription']['id'];
						$arrayUpdate['status'] = 0;
						$arrayUpdate['pharmacy_sales_bill_id'] = null;
						$arrayUpdate['recieved_quantity'] = null;
						$this->NewCropPrescription->save($arrayUpdate);
						$this->NewCropPrescription->id = "";
					}
				}
				/* End Of Code */
				
			}else if($type=='return'){
				$this->loadModel('InventoryPharmacySalesReturn');
				$this->InventoryPharmacySalesReturnsDetail->bindModel(array(
						'belongsTo'=>array('PharmacyItemRate'=>array('foreignKey'=>false,'conditions'=>array('PharmacyItem.id=PharmacyItemRate.item_id',
								'InventoryPharmacySalesReturnsDetail.batch_no=PharmacyItemRate.batch_number')))));
				$returnItemInStock=$this-> InventoryPharmacySalesReturnsDetail->find('all',array('conditions'=>array('InventoryPharmacySalesReturnsDetail.inventory_pharmacy_sales_return_id'=>$id)));
				//update stock in pharmacy Item and Pharmacy item rates
				foreach($returnItemInStock as $stock){
					$pharmacyItemStock['PharmacyItem']['stock']=$stock['PharmacyItem']['stock']-$stock['InventoryPharmacySalesReturnsDetail']['qty'];
					$pharmacyItemStock['PharmacyItem']['id']=$stock['PharmacyItem']['id'];
					$this->PharmacyItem->save($pharmacyItemStock);
					$pharmacyItemRateStock['PharmacyItemRate']['stock']=$stock['PharmacyItemRate']['stock']-$stock['InventoryPharmacySalesReturnsDetail']['qty'];
					$pharmacyItemRateStock['PharmacyItemRate']['id']=$stock['PharmacyItemRate']['id'];
					$this->PharmacyItemRate->save($pharmacyItemRateStock);
				}
				//$this->VoucherEntry->updateAll(array('VoucherEntry.is_deleted'=>'1'),array('VoucherEntry.billing_id'=>$id));//for accounting - amit
				$this->InventoryPharmacySalesReturn->updateAll(array('InventoryPharmacySalesReturn.is_deleted'=>'1'),array('InventoryPharmacySalesReturn.id'=>$id));
			}else if($type=='duplicate'){
				$this->loadModel('PharmacyDuplicateSalesBill');
				$this->PharmacyDuplicateSalesBill->updateAll(array('PharmacyDuplicateSalesBill.is_deleted'=>'1'),array('PharmacyDuplicateSalesBill.id'=>$id));
			}
			$this->Session->setFlash(__('Sales bill Deleted', true));
			$this->redirect($this->referer());
		}


	}

	/**
	 * Function to update pharmacy sales bill after receiving medication by nurse
	 * @param unknown_type $type
	 * @param unknown_type $id
	 * @auther yashwant
	 */
	public function updatePharmacyReceived($patientId=null,$recID=null){
		//$this->autoRender = false;
		$this->loadModel('PharmacySalesBill');
		$this->PharmacySalesBill->updateAll(array('PharmacySalesBill.is_received'=>'1'),array('PharmacySalesBill.id'=>$recID,'PharmacySalesBill.patient_id'=>$patientId));
		$this->Session->setFlash(__('Medication received successfully', true));
		exit;
	}

	// Print with header---Leena

	public function inventory_prin_view_with_header($print_section = null,$id = null){

		if($id == null){
			$this->Session->setFlash(__('Invalid Id for '.$print_section.'', true));
		}

		$this->InventoryPharmacySalesReturn->bindModel(array(
				'belongsTo' => array('Person' =>array('foreignKey' => 'patient_id'))
		));
		$this->PharmacySalesBill->bindModel(array(
				'belongsTo' => array('Person' =>array('foreignKey' => 'patient_id'))
		));
		$this->set('section',$print_section);

		if($print_section == "PurchaseReceipt"){
			$model = "InventoryPurchaseDetail";
			$data = $this->$model->find('first',
			array('conditions'=>array('InventoryPurchaseDetail.id'=>$id,"InventoryPurchaseDetail.location_id" =>$this->Session->read('locationid'))));


			$this->set('data',$data);
		}else if($print_section == "PharmacySalesBill"){
			$model = "PharmacySalesBill";

			$this->PharmacySalesBill->unBindModel(array('hasMany'=>array('PharmacySalesBillDetail')/*,'belongsTo'=>array('Patient','Doctor')*/)) ;
			$this->$model->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey' => 'guarantor_id',
									'conditions'=>array('PharmacySalesBill.guarantor_id=User.id')),
							'PharmacySalesBillDetail'=>array(
									'foreignKey' => false,
									'conditions'=>array('PharmacySalesBillDetail.pharmacy_sales_bill_id=PharmacySalesBill.id')),
							'PharmacyItem'=>array(
									'foreignKey' => false ,
									'conditions'=>array('PharmacySalesBillDetail.item_id=PharmacyItem.id')),
							'PharmacyItemRate'=>array(
									'foreignKey' => false ,
									'conditions'=>array('PharmacyItemRate.item_id=PharmacySalesBillDetail.item_id','PharmacyItemRate.batch_number=PharmacySalesBillDetail.batch_number')),
							'Patient'=>array(
									'foreignKey' => false ,
									'conditions'=>array('PharmacySalesBill.patient_id=Patient.id')),
							'Doctor' =>array('foreignKey' => false,
									'conditions'=>array('Patient.doctor_id=Doctor.id')),
			)));


			$data = $this->PharmacySalesBill->find('all',array('conditions'=>
			array('PharmacySalesBill.id'=>$id,"PharmacySalesBill.location_id" =>$this->Session->read('locationid')),
					'fields'=>array('PharmacyItemRate.*','User.username','PharmacySalesBill.*','Patient.lookup_name','Patient.person_id','Patient.id','Patient.city','PharmacySalesBillDetail.*','PharmacyItem.*','Doctor.*')));

			/* $saleBill = $this->PharmacySalesBill->find('first',array('conditions'=>
			 array('PharmacySalesBill.id'=>$id,"PharmacySalesBill.location_id" =>$this->Session->read('locationid'))));  */
			//debug($data);
			$formatted_address = $this->setAddressFormat($saleBill['Person']);
				
			//get username
			$this->loadModel('User');
			$userName=$this->User->getUserDetails($data['0']['PharmacySalesBill']['created_by']);
			$this->set('address',$formatted_address);
			$this->set('userName',$userName['User']['username']);
			$this->set('createdDate',$data['0']['PharmacySalesBill']['create_time']);

			//debug($data);
			$this->set('address',$formatted_address);

		}else if($print_section == "InventoryPurchaseReturn"){
			$model = "InventoryPurchaseReturn";
			$data = $this->$model->find('first',array('conditions'=>
			array('InventoryPurchaseReturn.id'=>$id,"InventoryPurchaseReturn.location_id" =>$this->Session->read('locationid'))));
			/*$InventoryPurchaseDetail =  $this->InventoryPurchaseDetail->find('first',array('conditions'=>
			 array('InventoryPurchaseDetail.id'=>$purchaseReturn['InventoryPurchaseReturn']['inventory_purchase_detail_id'],"InventoryPurchaseDetail.location_id" =>$this->Session->read('locationid'))));
			 */
			$this->set('supplier',$purchaseReturn['InventorySupplier']);
		}else{
			$model = "InventoryPharmacySalesReturn";
			$data = $this->$model->find('first',array('conditions'=>
			array('InventoryPharmacySalesReturn.id'=>$id,"InventoryPharmacySalesReturn.location_id" =>$this->Session->read('locationid'))));

			$formatted_address = $this->setAddressFormat($saleReturn['Person']);
			$this->set('address',$formatted_address);

		}
		$this->set('data',$data);
		/*
			$this->loadModel('pharmacyItem');
			foreach($data[$model] as $key=>$value){
			$item[] = $this->PharmacyItem->findById($value['item_id']);
			} */
		//$this->$model->findById();
		//$this->set('model',$model);
		$this->layout = false;
	}

	public function delete_direct_sale($id = null) {

		if (!$id) {
			$this->Session->setFlash(__('Invalid ID	', true));
			$this->redirect(array("controller" => "pharmacy", "action" => "get_other_pharmacy_details",'sales'));
		}
		if ($id) {
			$this->PharmacySalesBill->deleteirectSale($id);
			$this->Session->setFlash(__('Item Rate deleted', true));
			$this->redirect(array("controller" => "pharmacy", "action" => "get_other_pharmacy_details",'sales'));
		}
	}

	public function savePharmacyPaymentIntoSaleBill($otherSaleId){
		
		$this->autoRender = false;
		$this->layout = "ajax";

		$this->loadModel('PharmacySalesBill');
		$saleData = $this->PharmacySalesBill->find('first',array(
							'conditions'=>array('PharmacySalesBill.id'=>$otherSaleId)));

		if(!empty($saleData['PharmacySalesBill']['id'])){
			
			$payAmnt = array();
			$payAmnt['id'] = $otherSaleId;
			$payAmnt['paid_amnt'] = $saleData['PharmacySalesBill']['paid_amnt'] + $this->request->data['Payment']['paid_amount'];
			$payAmnt['remark']	=  $this->request->data['Payment']['remark'];
			$payAmnt['refund'] = $this->request->data['Payment']['refund'];
			
			if($this->request->data['Payment']['refund'] == 1){
				$payAmnt['paid_to_patient'] =  $saleData['PharmacySalesBill']['paid_to_patient'] + $this->request->data['Payment']['paid_to_patient'];
			}
			if($this->request->data['Payment']['discount_type'] == "Percentage"){
				$payAmnt['discount_percentage'] = $this->request->data['Payment']['is_discount'];
			}else
			if($this->request->data['Payment']['discount_type'] == "Amount"){
				$payAmnt['discount_amount'] = $this->request->data['Payment']['discount'];
			}
			$payAmnt['discount'] = $saleData['PharmacySalesBill']['discount'] + $this->request->data['Payment']['is_discount'];
			
			$this->PharmacySalesBill->save($payAmnt);
			//BOF for accounting by amit jain
			$userId = $saleData['PharmacySalesBill']['account_id'];
			$accountingData = array('date'=>$this->DateFormat->formatDate2STD($this->request->data['Payment']['date'],Configure::read('date_format')),
					'created_by'=>$this->Session->read('userid'),
					'refund'=>$this->request->data['Payment']['refund'],
					'paid_to_patient'=>$this->request->data['Payment']['paid_to_patient'],
					'pharmacy_id'=>$otherSaleId,
					'mode_of_payment'=>"Cash",
					'amount'=>$this->request->data['Payment']['paid_amount'],
					'remark'=>$this->request->data['Payment']['remark']);
			$accountingDataDetails['Billing'] = $accountingData;
			$this->addDirectReceipt($accountingDataDetails,$userId);
			//EOF by amit jain
			$this->Session->setFlash(__('The Payment has been successfully paid', true));
			$this->PharmacySalesBill->id = '';
		}
	}

	public function savePaymentFromPharmacy($patientId){
		$this->autoRender = false;
		$this->layout = "ajax";
		$this->loadModel('Billing');
		$this->loadModel('ServiceCategory');
		$payment_category = $this->ServiceCategory->getPharmacyId();
		//debug($this->request->data); exit;
		$total_amount = $this->request->data['Payment']['total_amount'];
		$discType = $this->request->data['Payment']['discount_type'];
		$discount = $this->request->data['Payment']['discount'];
// 		/debug($this->request->data);exit;
		if($total_amount > 0){
			foreach($this->request->data['Payment']['bill_id'] as $key => $value){ 
				$saleBillData = $this->PharmacySalesBill->find('first',array('fields'=>array('PharmacySalesBill.id','PharmacySalesBill.total','PharmacySalesBill.paid_amnt','PharmacySalesBill.discount'),'conditions'=>array('PharmacySalesBill.id'=>$value)));
				$balance = $saleBillData['PharmacySalesBill']['total'] - ($saleBillData['PharmacySalesBill']['paid_amnt'] + $saleBillData['PharmacySalesBill']['discount']) ;
	
				if($discType == "Percentage"){
					$disc = round((($balance * $discount) / 100),2);
				}else{
					$discPer = ($discount * 100) / $total_amount;	//calculate percent% from total and discount amount
					$disc = round((($balance * $discPer) / 100),2);
				}
				$billAmount=$billAmount+$this->request->data['Payment']['amount'][$key];	
				$saveSalesData = array();
				$this->PharmacySalesBill->id = $saleBillData['PharmacySalesBill']['id'];
				$saveSalesData['paid_amnt'] = $saleBillData['PharmacySalesBill']['paid_amnt'] + ($balance - $disc);
				$saveSalesData['modified_time'] = date('Y-m-d H:i:s');
				if($this->Session->read('website.instance')=="vadodara" || $this->Session->read('website.instance')=="kanpur"){
					$saveSalesData['discount'] = $saleBillData['PharmacySalesBill']['discount'];
				}else{
					$saveSalesData['discount'] = $disc;
				}
				
				if(!empty($this->request->data['Payment']['is_refund']) && $this->request->data['Payment']['is_refund'] == 1){
					$saveSalesData['paid_amnt'] = $saleBillData['PharmacySalesBill']['paid_amnt'] - $this->request->data['Payment']['paid_to_patient'][$key];
					$saveSalesData['discount'] = 0;
					$saveSalesData['refund'] = $this->request->data['Payment']['is_refund'];
					$saveSalesData['paid_to_patient'] = $this->request->data['Payment']['paid_to_patient'][$key];
				} 
					
				$this->PharmacySalesBill->save($saveSalesData);
				$this->PharmacySalesBill->id = "";
				//save into billing
				$billingData = array();
				$billingData['date']=date("Y-m-d H:i:s");
				$billingData['patient_id']=$patientId;
				$billingData['payment_category']=$payment_category;
				$billingData['location_id']=$this->Session->read('locationid');
				$billingData['created_by']=$this->Session->read('userid');
				$billingData['create_time']=date("Y-m-d H:i:s");
				$billingData['mode_of_payment']="Cash";
				//$billingData['total_amount'] = $this->request->data['Payment']['total_amount'];
				//$billingData['amount']=$this->request->data['Payment']['paid_amount'] ;
				//$billingData['discount_type']=$this->request->data['Payment']['discount_type'];
				//$billingData['amount_pending']=$this->request->data['Payment']['amount_pending'];
				//$billingData['discount'] = $this->request->data['Payment']['discount'];
				$billingData['total_amount'] = $saleBillData['PharmacySalesBill']['total'];
				$billingData['amount'] = round($saveSalesData['paid_amnt']) ;
				$billingData['discount_type'] = $discType;
				$billingData['amount_pending'] = $saleBillData['PharmacySalesBill']['total'] - $saveSalesData['paid_amnt'] - $disc;
				$billingData['discount'] = $disc ;
				$billingData['refund']=$this->request->data['Payment']['is_refund'];
				if(!empty($this->request->data['Payment']['is_refund']) && $this->request->data['Payment']['is_refund'] == 1){
					$billingData['amount'] = 0 ;
					$billingData['discount'] = $saveSalesData['discount'] - $saleBillData['PharmacySalesBill']['discount'];
					$billingData['paid_to_patient'] = $this->request->data['Payment']['paid_to_patient'][$key];
				}
				$billingData['remark']=$this->request->data['Payment']['remark'];
					
				if($this->request->data['Payment']['discount_type'] == "Percentage"){
					$billingData['discount_percentage'] = $this->request->data['Payment']['is_discount'];
				}else
				if($this->request->data['Payment']['discount_type'] == "Amount"){
					$billingData['discount_amount'] = $disc;
				}
				$billingData['pharmacy_sales_bill_id']=$value;
				$billingData['is_card'] = $this->request->data['PharmacySalesBill']['is_card'];
				$billingData['patient_card'] = $this->request->data['PharmacySalesBill']['patient_card'];
				$this->Billing->save($billingData);
				$this->Billing->id = "";
				$billingDataDetails['Billing'] = $billingData; //for accounting by amit
				$this->Billing->addPartialPaymentJV($billingDataDetails,$patientId);
				$lastNotesId=$this->Billing->getLastInsertID();
				/**********************/
				 	
				 	 	
				/*************************/
				$this->PharmacySalesBill->id = $saleBillData['PharmacySalesBill']['id'];
				$saveBillId = array();
				$saveBillId['billing_id'] = $lastNotesId;
				$this->PharmacySalesBill->save($saveBillId);
				$this->PharmacySalesBill->id = "";
					
				/*Patient card entry -Pooja Gupta*/
				if($this->Session->read('websit.instance')!='kanpur'){
					if(!empty($this->request->data['PharmacySalesBill']['is_card']) && !empty($this->request->data['PharmacySalesBill']['patient_card'])){
						$this->loadModel('PatientCard');
						$this->loadModel('Patient');
						$personId=$this->Patient->find('first',array('fields'=>array('Patient.person_id'),
								'conditions'=>array('Patient.id'=>$patientId,'Patient.is_deleted'=>'0')));
						$this->PatientCard->insertIntoCard($this->request->data['PharmacySalesBill']['patient_card'],
						$personId['Patient']['person_id'],$lastNotesId,'Payment');
					}
				}
				/* EOF Patient card*/
	
				$billNo= $this->Billing->generateBillNoPerPay($patientId,$lastNotesId);
				$updateBillingArray=array('Billing.bill_number'=>"'$billNo'");
				$this->Billing->updateAll($updateBillingArray,array('Billing.patient_id'=>$patientId,'Billing.id'=>$lastNotesId));
	
			} //eof foreach
			
	
			/*************Advance***********************/
			$advanceIdArray=$this->Billing->find('all',array('fields'=>array('Billing.id','Billing.amount_paid','Billing.amount_pending','Billing.amount'),
							'conditions'=>array('patient_id'=>$patientId,'pharmacy_sales_bill_id IS NULL','payment_category'=>'4'),
			));
			//debug($billAmount);exit;
			$advaUsedAmount=$billAmount;
			$prevAdv=$this->request->data['Billing']['advance_used'];
			foreach($advanceIdArray as $maintainData){
				if($advaUsedAmount!='0'){
					if($advaUsedAmount>= $maintainData['Billing']['amount']){
						$amount_paid=$maintainData['Billing']['amount_paid']+$maintainData['Billing']['amount'];
						$amount_pending=$maintainData['Billing']['amount_pending']+$amount_paid;
						$advaUsedAmount=$advaUsedAmount-$maintainData['Billing']['amount'];
					}else{
						$amount_paid=$maintainData['Billing']['amount_paid']+$advaUsedAmount;
						$amount_pending=$maintainData['Billing']['amount_pending']+$amount_paid;
						$advaUsedAmount='0';
						//break;
					}
					$this->Billing->updateAll(array('Billing.amount_paid'=>$amount_paid,'Billing.amount_pending'=>$amount_pending),array('Billing.id'=>$maintainData['Billing']['id']));
					if($advaUsedAmount=='0'){
						break;
					}
				}
			}
				/************************************/
				$this->Session->setFlash(__('The Payment has been successfully paid', true));
				
		  }//end Of if condition
		}

		/**
		 * duplicate sales bill for corporate patients
		 * pooja
		 */
		public function inventory_duplicate_sales_details($search = null){
			$this->layout="advance";
			$this->uses=array('PharmacyDuplicateSalesBill','InventoryPharmacySalesReturn');
			$this->loadModel("Configuration");
			$configPharmacy = $this->Configuration->getPharmacyServiceType();
			$conditions['PharmacyDuplicateSalesBill.location_id'] =$this->Session->read('locationid');
			$conditions['PharmacyDuplicateSalesBill.patient_id NOT'] = NULL;
			if($search !== null){

				if(!empty($this->params->query['billno'])){
					$conditions['PharmacyDuplicateSalesBill.bill_code LIKE'] = '%'.$this->params->query['billno'].'%';
				}
				if(!empty($this->params->query['date'])){
					$date = $this->DateFormat->formatDate2STD($this->params->query['date'],Configure::read('date_format'));
					$date = explode(' ',$date);
					$conditions['PharmacyDuplicateSalesBill.create_time >'] = $date[0]." 00:00:00";
					$conditions['PharmacyDuplicateSalesBill.create_time <'] = $date[0]." 23:59:59";
				}
				if(!empty($this->params->query['customer_name'])){
					if($this->params->query['person_id'] !==""){
						$conditions['PharmacyDuplicateSalesBill.patient_id'] =$this->params->query['person_id'];
					}else{

						$conditions['PharmacyDuplicateSalesBill.customer_name like'] = '%'.$this->params->query['customer_name'].'%';
					}
				}
			}
			//$conditions = array('PharmacyDuplicateSalesBill.prescription_status' =>'Approved');
			$this->loadModel('ServiceCategory');
			$payment_category = $this->ServiceCategory->getPharmacyId(); //by swapnil
			//$pharmacy_service_type=$this->ServiceCategory->find('first',array('conditions'=>array('ServiceCategory.name'=>Configure::read('pharmacyservices'))));
			$this->loadModel('Patient');
			//by pankaj too avoaid pagination in hope hospital only
			//Configure::write('number_of_rows',35);
			//by pankaj to add return charges in same list
			//EOF pankaj
			$this->PharmacyDuplicateSalesBill->unbindModel(array("belongsTo"=>array("Patient")));
			$this->PharmacyDuplicateSalesBill->bindModel(array("belongsTo"=>array(
				"Patient"=>array('type'=>'INNER','foreignKey'=>false, 'conditions'=>array('Patient.id=PharmacyDuplicateSalesBill.patient_id')))),false);		
			$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Patient.lookup_name' => 'asc'),
				'fields'=> array('PharmacyDuplicateSalesBill.id','PharmacyDuplicateSalesBill.patient_id','PharmacyDuplicateSalesBill.doctor_id','Sum(PharmacyDuplicateSalesBill.total) as pharma',
			/*'Sum(Billing.amount) as amtPaid',*/
						'PharmacyDuplicateSalesBill.tax','PharmacyDuplicateSalesBill.total','PharmacyDuplicateSalesBill.bill_code', 'PharmacyDuplicateSalesBill.payment_mode',
						'PharmacyDuplicateSalesBill.create_time','PharmacyDuplicateSalesBill.credit_period','Patient.id','Patient.patient_id',
						'Patient.lookup_name','Patient.payment_category','Patient.tariff_standard_id',
						'Patient.form_received_on','Patient.last_name', 'Patient.sex','Patient.person_id', 'Patient.admission_id',
						'Patient.form_received_on'),
				'conditions'=>array($conditions,'PharmacyDuplicateSalesBill.is_deleted' =>'0'),
				'group'=>array('Patient.id')		
			);
			$this->set('title_for_layout', __('Sales Details', true));
			$data = $this->paginate('PharmacyDuplicateSalesBill');
			$this->set('configPharmacy',$configPharmacy);
			$this->set('data',$data);
			//by pankaj for return medicine amt
			$returnList  = $this->InventoryPharmacySalesReturn->find('all',array('fields'=>array('SUM(InventoryPharmacySalesReturn.total) as total',
				'InventoryPharmacySalesReturn.patient_id'),
				'conditions'=>array('InventoryPharmacySalesReturn.is_deleted'=>'0','InventoryPharmacySalesReturn.patient_id'=>$this->params->query['person_id']),'group'=>array('InventoryPharmacySalesReturn.patient_id')));			
			foreach($returnList as $returnKey=>$returnValue){
				$returnListArray[$returnValue['InventoryPharmacySalesReturn']['patient_id']]= $returnValue[0]['total'];
			}
			//EOF return
			$this->set('returnListArray',$returnListArray);
			// amount paid for pharmacy calculations - pooja

			$this->loadModel('Billing');
			foreach($data as $pharmacy){
				$patientId[]=$pharmacy['PharmacyDuplicateSalesBill']['patient_id'];
				$tariff[]=$pharmacy['Patient']['tariff_standard_id'];
			}
			$this->Patient->bindModel(array(
				'belongsTo'=>array('TariffStandard'=>array('foreignKey'=>false, 'conditions'=>array('Patient.tariff_standard_id=TariffStandard.id')))));

			$tariffName=$this->Patient->find('all',array('fields'=>array('TariffStandard.name','Patient.id'),
				'conditions'=>array('TariffStandard.id'=>$tariff,'Patient.id'=>$patientId),
				'group'=>array('Patient.id')));

			$paid=$this->Billing->find('all',array('fields'=>array('Billing.amount','Billing.patient_id'),
				'conditions'=>array('Billing.patient_id'=>$patientId,
						'Billing.payment_category'=>$payment_category),
			/*'group'=>array('Billing.patient_id')*/));
			foreach($paid as $key=>$pharPaid){
				$paidAmt[$pharPaid['Billing']['patient_id']]=$paidAmt[$pharPaid['Billing']['patient_id']]+$pharPaid['Billing']['amount'];
			}
			foreach($tariffName as $tariffStandard){
				$patientTariff[$tariffStandard['Patient']['id']]=$tariffStandard['TariffStandard']['name'];
			}
			$this->set('tariff',$patientTariff);
			$this->set('paidAmt',$paidAmt);



		}
		public function inventory_duplicate_sales_bill(){
			$this->uses = array("PharmacyDuplicateSalesBill","PharmacyDuplicateSalesBillDetail");
			$this->set('title_for_layout', __('Duplicate Pharmacy Management - Sales Bill ', true));
			$this->loadModel('Patient');
			$this->loadModel('User');
			$this->loadModel('Account');
			$this->layout = 'advance';
			//mode of payment by Swapnil G.Sharma
			$this->loadModel("Configuration");
			$configPharmacy = $this->Configuration->getPharmacyServiceType();
			$mode_of_payment = array('Credit'=>'Credit');
			if($configPharmacy['cashCounter']=="yes"){
				$mode_of_payment = array_merge($mode_of_payment,array('Cash'=>'Cash'));
			}
			$this->set('mode_of_payment',$mode_of_payment);

			$this->Patient->bindModel(array(
				'hasOne' => array(
						'User' => array('foreignKey' =>false, 'conditions'=>array('User.id = Patient.doctor_id')),

			)),false);

			if($patient_id != null){
				$patient = $this->Patient->find('first', array('conditions'=>array("Patient.id"=>$patient_id)));
				$this->set("patient",$patient);
			}
			if ($this->request->is('post') && !empty($this->request->data)) {

				if(!isset($this->request->data['item_id'])){
					$this->Session->setFlash(__('Item must be selected'), true,array('class'=>'error'));
					// $this->redirect(array("controller" => "pharmacy", "action" => "sales_bill",'inventory'=>true));
				}else{
					if(trim($this->request->data['party_code'])!=""){
						$patient = $this->Patient->find('first', array('conditions'=>array("Patient.admission_id"=>$this->request->data['party_code'])));
						$patientId = $patient['Patient']['id'];
						$this->request->data['PharmacyDuplicateSalesBill']['patient_id']  = $patientId;
					}else{
						$this->request->data['PharmacyDuplicateSalesBill']['customer_name']  = $this->request->data['party_name'];
					}

					if(!empty($this->request->data['sale_date'])){
						$saleDate = $this->DateFormat->formatDate2STD($this->request->data['sale_date'],Configure::read('date_format'));
					}

					$this->request->data['PharmacyDuplicateSalesBill']['create_time'] = $saleDate?$saleDate:date('Y-m-d H:i:s');
					$this->request->data['PharmacyDuplicateSalesBill']['created_by'] = $this->Auth->user('id');
					$this->request->data['PharmacyDuplicateSalesBill']['location_id'] = $this->Session->read('locationid');
					$this->request->data['PharmacyDuplicateSalesBill']['bill_code']  =  $this->PharmacyDuplicateSalesBill->generateSalesBillNo();
					$this->request->data['PharmacyDuplicateSalesBill']['itemType'] = $this->request->data['PharmacyDuplicateSalesBill']['item_type'];
					//debug($this->request->data);exit;

					$this->PharmacyDuplicateSalesBill->create();
						
					$this->PharmacyDuplicateSalesBill->save($this->request->data);
					$get_last_insertID = $this->PharmacyDuplicateSalesBill->getLastInsertId();
					$errors = $this->PharmacyDuplicateSalesBill->invalidFields();
					if(!empty($errors)) {
						$this->set("errors", $errors);
					} else {
						if($this->PharmacyDuplicateSalesBillDetail->saveBillDetails($this->request->data,$get_last_insertID)){
							$this->Session->setFlash(__('The Duplicate Sales Bill has been saved', true));
						}
						if(isset($this->request->data['redirect_to_billing'])){
							$this->redirect(array('inventory'=>true,'action'=>'duplicate_sales_details'));
							//$this->redirect($this->referer());
						}else if($this->request->data['print']){
							//$url = Router::url(array("controller" => "pharmacy", "action" => "inventory_print_view",'PharmacyDuplicateSalesBill',$this->PharmacyDuplicateSalesBill->id,'inventory'=>true));
							//echo "<script>window.open('".$url."','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true )</script>";
						}else{
							$this->redirect(array("controller" => "pharmacy", "action" => "duplicate_sales_details",'sales','?'=>array('print'=>'print','id'=>$get_last_insertID,$status), 'inventory'=>true));
						}
					}
				}
			}
			/* code for guarantor username list */
			$userName = $this->User->find('list',array('fields'=>array('id','username'),
				'conditions'=>array("User.is_guarantor" =>'1' ,"User.location_id" =>$this->Session->read('locationid'),"User.is_deleted"=>'0')));


			$this->set('userName',$userName);
		}


		public function inventory_duplicate_sales_bill_details(){
			$this->uses = array("PharmacyDuplicateSalesBill","PharmacyDuplicateSalesBillDetail");
			$this->layout = 'ajax';
			$conditions['PharmacyDuplicateSalesBill.location_id'] =$this->Session->read('locationid');
			$conditions['PharmacyDuplicateSalesBill.patient_id NOT'] = NULL;
			if($search !== null){
				if($this->params->query['billno'] !==""){
					$conditions['PharmacyDuplicateSalesBill.bill_code'] = $this->params->query['billno'];
				}

				if($this->params->query['date'] !==""){
					$date = $this->DateFormat->formatDate2STD($this->params->query['date'],Configure::read('date_format'));
					$date = explode(' ',$date);
					$conditions['PharmacyDuplicateSalesBill.create_time >'] = $date[0]." 00:00:00";
					$conditions['PharmacyDuplicateSalesBill.create_time <'] = $date[0]." 23:59:59";
				}
			}
			if($this->params->query['customer_name'] !==""){
				if($this->params->query['person_id'] !==""){
					$conditions['PharmacyDuplicateSalesBill.patient_id'] =$this->params->query['person_id'];
				}else{

					$conditions['PharmacyDuplicateSalesBill.customer_name like'] = '%'.$this->params->query['customer_name'].'%';
				}
			}
			//$conditions = array('PharmacyDuplicateSalesBill.prescription_status' =>'Approved');

			/*	$this->paginate = array(
			 'limit' => Configure::read('number_of_rows'),
				'order' => array(
				'PharmacyDuplicateSalesBill.create_time' => 'desc'),
				'fields'=> array('PharmacyDuplicateSalesBill.id','PharmacyDuplicateSalesBill.patient_id','PharmacyDuplicateSalesBill.doctor_id',
				'PharmacyDuplicateSalesBill.tax','PharmacyDuplicateSalesBill.total','PharmacyDuplicateSalesBill.bill_code', 'PharmacyDuplicateSalesBill.payment_mode',
				'PharmacyDuplicateSalesBill.create_time','PharmacyDuplicateSalesBill.credit_period','Patient.id','Patient.patient_id',
				'Patient.lookup_name','Patient.payment_category',
				'Patient.form_received_on','Patient.last_name', 'Patient.sex','Patient.person_id', 'Patient.admission_id',
				'Patient.form_received_on'),
				'conditions'=>array($conditions,'PharmacyDuplicateSalesBill.is_deleted' =>'0')

					
				);*/
			$phramacySalesData =$this->PharmacyDuplicateSalesBill->find('all',array(
				'order' => array(
						'PharmacyDuplicateSalesBill.create_time' => 'desc'),
				'fields'=> array('PharmacyDuplicateSalesBill.id','PharmacyDuplicateSalesBill.patient_id','PharmacyDuplicateSalesBill.doctor_id',
				'PharmacyDuplicateSalesBill.tax','PharmacyDuplicateSalesBill.total','PharmacyDuplicateSalesBill.bill_code', 'PharmacyDuplicateSalesBill.payment_mode',
				'PharmacyDuplicateSalesBill.create_time','PharmacyDuplicateSalesBill.credit_period','Patient.id','Patient.patient_id',
				'Patient.lookup_name','Patient.payment_category','PharmacyDuplicateSalesBill.add_charges_in_invoice',
				'Patient.form_received_on','Patient.last_name', 'Patient.sex','Patient.person_id', 'Patient.admission_id',
				'Patient.form_received_on'),
				'conditions'=>array($conditions,'PharmacyDuplicateSalesBill.is_deleted' =>'0')
			));

			$this->set('title_for_layout', __('Sales Details', true));
			$data =  $phramacySalesData ; //$this->paginate('PharmacyDuplicateSalesBill');
			$this->set('data',$data);
		}

		public function medication_detail($patientId = null,$type){
			$this->layout = "advance_ajax";
			if($type == "duplicate"){
				$this->getPharmacyDuplicateSalesBills($patientId); 
			}else if($type == "original"){
				$this->getPharmacySalesBills($patientId); 
			}  
			if(!empty($this->request->query['excel']) && $this->request->query['excel'] == "Generate Excel"){
				$this->layout = false;
				$this->render('medication_detail_excel',false);
			}
		}

		public function inventory_view_details($patientId = null,$type){

			$this->layout = "advance_ajax";
			$this->uses = array('Patient'); 
			if($patientId != null){
				$patient = $this->Patient->find('first', array('conditions'=>array("Patient.id"=>$patientId)));
				$this->set("patient",$patient); 
			}

			if($type == "duplicate"){
				$this->getPharmacyDuplicateSalesItems($patientId); 
			}else if($type == "original"){
				$this->getPharmacySalesItems($patientId); 
			}

			if(!empty($this->request->query['excel']) && $this->request->query['excel'] == "Generate Excel"){
				$this->layout = false;
				$this->render('view_detail_excel',false);
			}
		}

		//function to get the duplicate sales items 	by Swapnil - 30.12.2015
		public function getPharmacyDuplicateSalesItems($patientId){
			$this->uses = array('Patient','PharmacyDuplicateSalesBill','PharmacyDuplicateSalesBillDetail','TariffStandard','Billing','ServiceCategory',
							'InventoryPharmacySalesReturn','InventoryPharmacySalesReturnsDetail','PatientInitial');
			$this->PharmacyDuplicateSalesBill->bindModel(array(
			'belongsTo' => array(
				'PharmacyDuplicateSalesBillDetail'=>array(
								'foreignKey' => false,
								'conditions'=>array('PharmacyDuplicateSalesBillDetail.pharmacy_duplicate_sales_bill_id=PharmacyDuplicateSalesBill.id')),
				'Patient'=>array(
								'foreignKey' => false ,
								'conditions'=>array('PharmacyDuplicateSalesBill.patient_id=Patient.id')),
			)));

			$this->InventoryPharmacySalesReturn->unBindModel(array(
				'hasOne' => array('Patient')));

			$data = $this->PharmacyDuplicateSalesBill->find('all',array(
					'conditions'=>array("PharmacyDuplicateSalesBill.location_id" =>$this->Session->read('locationid'),
										'PharmacyDuplicateSalesBill.is_deleted' =>'0','PharmacyDuplicateSalesBill.patient_id'=>$patientId),
					'fields'=>array('PharmacyDuplicateSalesBill.*','Patient.lookup_name','Patient.person_id','Patient.id','Patient.city','Patient.initial_id',
									'Patient.admission_type, Patient.discharge_date','Patient.admission_id','Patient.tariff_standard_id','Patient.form_received_on'),
					'group'=>'PharmacyDuplicateSalesBill.id'));

			$this->InventoryPharmacySalesReturn->bindModel(array(
			'belongsTo' => array(
				'Patient'=>array(
								'foreignKey' => false ,
								'conditions'=>array('InventoryPharmacySalesReturn.patient_id=Patient.id')),
			)));

			$saleReturn = $this->InventoryPharmacySalesReturn->find('all',array(
						'conditions'=>array("InventoryPharmacySalesReturn.location_id" =>$this->Session->read('locationid'),
										'InventoryPharmacySalesReturn.is_deleted' =>'0','InventoryPharmacySalesReturn.patient_id'=>$patientId),
						'fields'=>array('InventoryPharmacySalesReturn.*'),
						'group'=>'InventoryPharmacySalesReturn.id'));
				
			$tariffName = $this->TariffStandard->find('first',array(
					'fields'=>array('TariffStandard.name'),
					'conditions'=>array("TariffStandard.id "=> $data[0]['Patient']['tariff_standard_id'])));	

			$initialName = $this->PatientInitial->find('first',array(
						'fields'=>array('id','name'),
						'conditions'=>array("PatientInitial.id"=> $data[0]['Patient']['initial_id']))); 		

			$payment_category = $this->ServiceCategory->getPharmacyId(); //by swapnil
			//$pharmacy_service_type=$this->ServiceCategory->find('first',array('conditions'=>array('ServiceCategory.name'=>Configure::read('pharmacyservices'))));

			$paid=$this->Billing->find('all',array('fields'=>array('Billing.amount','Billing.patient_id','sum(Billing.amount) as total_amount'),
						'conditions'=>array('Billing.patient_id'=>$patientId,
								'Billing.payment_category'=> $payment_category),
			/*'group'=>array('Billing.patient_id')*/));
			$paidAmt = $paid[0][0]['total_amount'];
			$this->set(compact(array('tariffName','paidAmt','saleReturn','tariffName','initialName')));
			$this->set(allData,$data); //debug($data);
			return true;
		}

		//function to get the pharmacy sales items 	by Swapnil - 30.12.2015
		public function getPharmacySalesItems($patientId){
			$this->uses = array('Patient','PharmacySalesBill','PharmacySalesBillDetail','TariffStandard','Billing','ServiceCategory',
							'InventoryPharmacySalesReturn','InventoryPharmacySalesReturnsDetail','PatientInitial');
			$this->PharmacySalesBill->bindModel(array(
			'belongsTo' => array(
				'PharmacySalesBillDetail'=>array(
								'foreignKey' => false,
								'conditions'=>array('PharmacySalesBillDetail.pharmacy_sales_bill_id=PharmacySalesBill.id')),
				'Patient'=>array(
								'foreignKey' => false ,
								'conditions'=>array('PharmacySalesBill.patient_id=Patient.id')),
			)));

			$this->InventoryPharmacySalesReturn->unBindModel(array(
				'hasOne' => array('Patient')));

			$data = $this->PharmacySalesBill->find('all',array(
					'conditions'=>array("PharmacySalesBill.location_id" =>$this->Session->read('locationid'),
										'PharmacySalesBill.is_deleted' =>'0','PharmacySalesBill.patient_id'=>$patientId),
					'fields'=>array('PharmacySalesBill.*','Patient.lookup_name, Patient.discharge_date','Patient.person_id','Patient.id','Patient.city','Patient.initial_id',
									'Patient.admission_type','Patient.admission_id','Patient.tariff_standard_id','Patient.form_received_on'),
					'group'=>'PharmacySalesBill.id'));
 
			$this->InventoryPharmacySalesReturn->bindModel(array(
			'belongsTo' => array(
				'Patient'=>array(
								'foreignKey' => false ,
								'conditions'=>array('InventoryPharmacySalesReturn.patient_id=Patient.id')),
			)));

			$saleReturn = $this->InventoryPharmacySalesReturn->find('all',array(
						'conditions'=>array("InventoryPharmacySalesReturn.location_id" =>$this->Session->read('locationid'),
										'InventoryPharmacySalesReturn.is_deleted' =>'0','InventoryPharmacySalesReturn.patient_id'=>$patientId),
						'fields'=>array('InventoryPharmacySalesReturn.*'),
						'group'=>'InventoryPharmacySalesReturn.id'));
				
			$tariffName = $this->TariffStandard->find('first',array(
					'fields'=>array('TariffStandard.name'),
					'conditions'=>array("TariffStandard.id "=> $data[0]['Patient']['tariff_standard_id'])));	

			$initialName = $this->PatientInitial->find('first',array(
						'fields'=>array('id','name'),
						'conditions'=>array("PatientInitial.id"=> $data[0]['Patient']['initial_id']))); 		

			$payment_category = $this->ServiceCategory->getPharmacyId(); //by swapnil
			//$pharmacy_service_type=$this->ServiceCategory->find('first',array('conditions'=>array('ServiceCategory.name'=>Configure::read('pharmacyservices'))));

			$paid=$this->Billing->find('all',array('fields'=>array('Billing.amount','Billing.patient_id','sum(Billing.amount) as total_amount'),
						'conditions'=>array('Billing.patient_id'=>$patientId,
								'Billing.payment_category'=> $payment_category),
			/*'group'=>array('Billing.patient_id')*/));
			$paidAmt = $paid[0][0]['total_amount'];
			$this->set(compact(array('tariffName','paidAmt','saleReturn','tariffName','initialName')));
			$this->set(allData,$data); //debug($data);
			return true;
		}

		//function to get the duplicate sales bills 	by Swapnil - 30.12.2015
		public function getPharmacyDuplicateSalesBills($patientId){
			$this->uses = array('PharmacyDuplicateSalesBill','PharmacyDuplicateSalesBillDetail','PatientInitial','Patient');
			$detail = $this->PharmacyDuplicateSalesBill->patientDuplicateBillDetail($patientId);

			if($patientId != null){
				$patientDetail = $this->Patient->find('first', array('conditions'=>array("Patient.id"=>$patientId),
																 'fields'=>array('Patient.id','Patient.patient_id','Patient.initial_id','Patient.form_received_on',
																 		'Patient.discharge_date','Patient.lookup_name'))); // set this to controller
			}

			$initialName = $this->PatientInitial->find('first',array(
				'fields'=>array('id','name'),
				'conditions'=>array("PatientInitial.id"=> $patientDetail['Patient']['initial_id'])));

			$this->set(compact(array('detail','initialName','patientDetail')));
			return true;
		}

		//function to get the pharmacy sales bills 	by Swapnil - 30.12.2015
		public function getPharmacySalesBills($patientId){
			$this->uses = array('PharmacySalesBill','PharmacyBillDetail','PatientInitial','Patient');
			$detail = $this->PharmacySalesBill->patientPharmacySalesBillDetail($patientId);

			if($patientId != null){
				$patientDetail = $this->Patient->find('first', array('conditions'=>array("Patient.id"=>$patientId),
																 'fields'=>array('Patient.id','Patient.patient_id','Patient.initial_id','Patient.form_received_on',
																 		'Patient.discharge_date','Patient.lookup_name'))); // set this to controller
			}

			$initialName = $this->PatientInitial->find('first',array(
				'fields'=>array('id','name'),
				'conditions'=>array("PatientInitial.id"=> $patientDetail['Patient']['initial_id'])));

			$this->set(compact(array('detail','initialName','patientDetail')));
			return true;
		}

		public function saveEditableDate($id,$val)
		{ //debug($val);exit;
			$d = explode(",",$val);
			$date = implode("/",$d);
			$this->autoRender = false;
			$this->layout = 'ajax';
			$this->uses = array('PharmacyDuplicateSalesBill');
				
			if(!empty($id))
			{
				$this->PharmacyDuplicateSalesBill->id = $id;
				$this->request->data['PharmacyDuplicateSalesBill']['modified_date'] = $date;
				$this->PharmacyDuplicateSalesBill->save($this->request->data);
			}

		}

		public function saveDate($id,$val)
		{ //debug($val);exit;
			$d = explode(",",$val);
			$date = implode("/",$d);
			$this->autoRender = false;
			$this->layout = 'ajax';
			$this->uses = array('PharmacyDuplicateSalesBillDetail');

			if(!empty($id))
			{
				$this->PharmacyDuplicateSalesBillDetail->id = $id;
				$this->request->data['PharmacyDuplicateSalesBillDetail']['modified_date'] = $date;
				$this->PharmacyDuplicateSalesBillDetail->save($this->request->data);
			}

		}

		//function to clone existing duplicate bill by pankaj
		function inventory_clone_duplicate_sales_bill($duplicateSaleBillID=null,$patient_id=null){
			$this->layout = "advance";
			$this->uses = array("PharmacyDuplicateSalesBill","PharmacyDuplicateSalesBillDetail","Patient",'PharmacyItemRate');

			$this->PharmacyItem->bindModel(array(
						'hasMany' => array(
								'PharmacyItemRate' =>array('foreignKey'=>"item_id"),
			),
			),false);
			$this->PharmacyDuplicateSalesBill->bindModel(array(
						'belongsTo' => array(
								'User' =>array('foreignKey' => 'guarantor_id'),array('conditions'=>array('PharmacyDuplicateSalesBill.guarantor_id=User.id')),
								'DoctorProfile' =>array('foreignKey' => false),array('conditions' => array('PharmacyDuplicateSalesBill.doctor_id = DoctorProfile.user_id')))

			),false);

			$pharmacySales = $this->PharmacyDuplicateSalesBill->find('first',array('conditions'=>
			array('PharmacyDuplicateSalesBill.id'=>$duplicateSaleBillID,"PharmacyDuplicateSalesBill.location_id" =>$this->Session->read('locationid'),'PharmacyDuplicateSalesBill.is_deleted' =>'0'),
						'fields'=>array('User.username','PharmacyDuplicateSalesBill.*','Patient.id','Patient.lookup_name','Patient.admission_type','Patient.admission_id','DoctorProfile.doctor_name'/* ,'PharmacySalesBillDetail.*' */)));

			//debug($pharmacySales);

			foreach($pharmacySales['PharmacyDuplicateSalesBillDetail'] as $value){
				//debug($value);
				$pharmacyRateData = $this->PharmacyItemRate->find('first',array('conditions'=>array('item_id'=>$value['item_id'],'batch_number'=>$value['batch_number'])));
				//debug($pharmacyRateData);
				$pharmItemId[]=$value['item_id'];
				$pharmBatch[$pharmacyRateData['PharmacyItemRate']['id']]=$value['batch_number'];
				$pharmStock[$value['item_id']] = $pharmacyRateData['PharmacyItemRate']['stock'];
				$pharmExpiry[$value['item_id']] = $pharmacyRateData['PharmacyItemRate']['expiry_date'];
				//$pharmBatch[$pharmacyRateData['PharmacyItemRate']['id']]=$value['batch_number'];
				$pharmaItemQty[$value['item_id']]=$value['qty']; 
				$pharmaSalePrice[$value['item_id']] = $value['sale_price'];
				$pharmaMrp[$value['item_id']] = $value['mrp'];
				$pharmaItemType[$value['item_id']] = $value['qty_type'];
				$pharmaPack[$value['item_id']] = $value['pack'];
			}
			//debug($pharmItemId);
			//debug($pharmBatch);
			$pharmacyData = $this->PharmacyItem->find('all',array('fields'=>array('id','item_code','name','manufacturer','pack','stock'),
						'conditions'=>array('PharmacyItem.id'=>$pharmItemId,/* 'PharmacyItemRate.batch_number'=>$pharmBatch */), 
						'group'=>array('PharmacyItem.id'),
						'order'=>array('PharmacyItemRate.expiry_date'=>"ASC")));
			//debug($pharmacyData);
			$this->set('editSales',$pharmacySales);
			$this->set('pharmBatch',$pharmBatch);
			$this->set(compact(array('oReq','pharmacyData','drugQty','patient_id','requisitionType','pharmaItemQty','pharmaMrp','pharmaSalePrice','pharmExpiry','pharmStock','pharmaPack'))); //debug($pharmacyData);
			$this->set('pharmacyData',$pharmacyData);


			/*$this->PharmacyDuplicateSalesBill->bindModel(array(
				'belongsTo' => array(
				//'Patient'=>array('foreignKey' => false,'conditions'=>array('PharmacyDuplicateSalesBill.patient_id=Patient.id')),
				'User' =>array('foreignKey' => 'guarantor_id'),array('conditions'=>array('PharmacyDuplicateSalesBill.guarantor_id=User.id	')),
				'DoctorProfile' =>array('foreignKey' => false),array('conditions' => array('PharmacyDuplicateSalesBill.doctor_id = DoctorProfile.user_id')))

				),false);

				$pharmacySales = $this->PharmacyDuplicateSalesBill->find('first',array('conditions'=>
				array('PharmacyDuplicateSalesBill.id'=>$duplicateSaleBillID,"PharmacyDuplicateSalesBill.location_id" =>$this->Session->read('locationid'),'PharmacyDuplicateSalesBill.is_deleted' =>'0','PharmacyDuplicateSalesBill.patient_id'=>$patient_id),
				'fields'=>array('User.username','PharmacyDuplicateSalesBill.*','Patient.id','Patient.lookup_name','Patient.admission_type','Patient.admission_id','DoctorProfile.doctor_name')));
				*/
			/*$this->PharmacyItem->bindModel(array(
				'belongsTo' => array(
				'PharmacyItemRate' =>array('foreignKey'=>false,'conditions'=>array('PharmacyItem.id = PharmacyItemRate.item_id')),
				),
				),false);*/
			//debug($pharmacySales);
			/*foreach($pharmacySales['PharmacyDuplicateSalesBillDetail'] as $value){
			 $pharmItemId[]=$value['item_id'];
			 $pharmBatch[]=$value['batch_number'];
			 $pharmaItemQty[$value['item_id']]=$value['qty'];
			 //$batchData[$value['item_id']]  = $this->PharmacyItemRate->find('list',array('fields'=>array('id','batch_number'),'conditions'=>array('item_id'=>$val['PharmacyItem']['id'])));
			 }*/
			/*$this->PharmacyItem->bindModel(array('hasMany'=>array('PharmacyItemRate'=>array('foreignKey'=>'item_id'))));

			$pharmacyData = $this->PharmacyItem->find('all',array('fields'=>array('id','item_code','name','manufacturer','pack','stock','PharmacyItemRate.id',
			'PharmacyItemRate.item_id','PharmacyItemRate.batch_number','PharmacyItemRate.expiry_date','PharmacyItemRate.mrp','PharmacyItemRate.sale_price','cust_name'),
			'conditions'=>array('PharmacyItem.id'=>$pharmItemId,'PharmacyItemRate.batch_number'=>$pharmBatch), 'group'=>array('PharmacyItem.id')));

			debug($pharmacyData);
			$this->set('editSales',$pharmacySales);
			$this->set(compact(array('oReq','pharmacyData','drugQty','patient_id','requisitionType','pharmaItemQty'))); //debug($pharmacyData);
			$this->set('pharmacyData',$pharmacyData);*/


			if($patient_id != null){

				$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
				$this->Patient->bindModel(array(
				'belongsTo' => array( 
						'DoctorProfile' =>array('foreignKey'=>false,array('conditions'=>array('DoctorProfile.user_id=Patient.doctor_id')))
				)));
					
				$patient =$this->Patient->find('first',array('fields'=>array('Patient.admission_id','Patient.lookup_name','Patient.id',
				'DoctorProfile.doctor_name','DoctorProfile.user_id'),
				'conditions'=>array('Patient.id'=>$patient_id)));


				//$patient = $this->Patient->find('first', array('conditions'=>array("Patient.id"=>$patient_id)));
				$this->set("patient",$patient);
			}


		}

		/* for autocomplete for sales return by Swapnil */
		public function inventory_autocomplete_sales_return_item($field=null){
			$searchKey = $this->params->query['term'] ;
			$filedOrder = array('PharmacyItem.id');
			if($field == "name"){
				/*if(strtolower($this->Session->read('website.instance')) == "hope"){
					$conditions["PharmacyItem.name LIKE"] = "%".$searchKey."%";
				}else{
					$conditions["PharmacyItem.name LIKE"] = $searchKey."%";
				} */
					$conditions["PharmacyItem.name LIKE"] = $searchKey."%";
				array_push( $filedOrder,'PharmacyItem.item_code','PharmacyItem.name');
			}else{
				/*if(strtolower($this->Session->read('website.instance')) == "hope"){
					$conditions["PharmacyItem.item_code LIKE"] = "%".$searchKey."%";
				}else{
					$conditions["PharmacyItem.item_code LIKE"] = $searchKey."%";
				}*/  
				$conditions["PharmacyItem.item_code LIKE"] = $searchKey."%";
				array_push( $filedOrder,'PharmacyItem.name','PharmacyItem.item_code');
			}
			$patientId = $this->request->query['patientId'];
			/* LocationID is coomented by - MRUNAL  for Vadodara*/
			//$conditions["PharmacyItem.location_id"] =$this->Session->read('locationid');
			if($this->Session->read('website.instance') == "Kanpur"){
				$conditions["PharmacyItem.location_id"] = $this->Session->read('locationid');
			}
			$conditions["PharmacyItem.is_deleted"] ='0';
			$conditions["PharmacyItem.drug_id !="] ='0';
			$conditions["PharmacySalesBill.patient_id"] = $patientId;

			$this->PharmacySalesBill->recursive = 0;
			$this->PharmacyItem->recursive = 0;
				
			$this->PharmacySalesBill->bindModel(array(
					'belongsTo' => array(
							'PharmacySalesBillDetail' => array('foreignKey' => false,
																'conditions'=>"PharmacySalesBill.id = PharmacySalesBillDetail.pharmacy_sales_bill_id"),
							'PharmacyItem' => array('foreignKey' => false,
																'conditions'=>"PharmacySalesBillDetail.item_id = PharmacyItem.id"))
			));

			$items = $this->PharmacySalesBill->find('all', array(
												'fields'=>$filedOrder,
												'conditions'=>array($conditions),
												'group' => 'PharmacyItem.id',
												'order' => array('PharmacyItem.name')));

			foreach ($items as $key=>$value) {
				if($field == "name"){
					$output[] = array('id'=>$value['PharmacyItem']['id'],'value'=>$value['PharmacyItem']['name'],'item_code'=>$value['PharmacyItem']['item_code']);
				}else{
					$output[] = array('id'=>$value['PharmacyItem']['id'],'value'=>$value['PharmacyItem']['item_code'],'name'=>$value['PharmacyItem']['name']);
				}
			}
			echo json_encode($output);
			exit;//dont remove this
		}

		public function inventory_fetch_batch_number_of_item_rate(){ //by swapnil
			$searchKey = $this->params->query['term'];
			$filedOrder = array('batch_no','expiry_date');
			$conditions["batch_no like"] = $searchKey."%";

			$itemId = $this->params->query['itemId'];
			$conditions["PharmacyItemRate.item_id"] =$itemId;


			//$batchnumbers = $this->PharmacyItemRate->find('list',array('fields'=> $filedOrder,'conditions'=>$conditions));
			$batchnumbers_from_rate = $this->PharmacyItemRate->find('all',array(
									'fields'=> array("batch_number","expiry_date","mrp","tax","purchase_price","sale_price","cost_price","stock"),
									'conditions'=>array("PharmacyItemRate.batch_number like"=> $searchKey."%", "PharmacyItemRate.item_id"=>$itemId)));
			//$output ='';
			//debug($batchnumbers_from_rate);
			/*foreach ($batchnumbers as $key=>$value) {
			 if(!in_array($value,$batchnumbers_from_rate)){
				$value = $this->DateFormat->formatDate2Local($value,Configure::read('date_format'));
				$output .= $key."|". $value."\n";
				}
				}*/

			foreach ($batchnumbers_from_rate as $key=>$value) {
				$value = $value['PharmacyItemRate'];
				$value['expiry_date'] = $this->DateFormat->formatDate2Local($value['expiry_date'],Configure::read('date_format'));
				//$output .= $key."|". $value."\n";
				$returnArray[] = array('id'=>$value['batch_number'],
									'value'=>$value['batch_number'],
									'expiry_date'=>$value['expiry_date'],
									'mrp'=>$value['mrp'],
									'purchase_price'=>$value['purchase_price'],
									'sale_price'=>$value['sale_price'],
									'tax'=>$value['tax'],
									'stock'=>$value['stock']);

			}
			//debug($returnArray);
			echo json_encode($returnArray);
			//echo $output;
			exit;//dont remove this

		}

		public function vat($vatId = null){

			$this->layout = 'advance';
			$this->uses  = array('VatClass');
			$this->set('title_for_layout', __('Pharmacy Vat Classes', true));
			//exit;
			/* To edit vat class */
			if($vatId){

				if($this->params['pass'][1] == "edit"){
					$vatEditData = $this->VatClass->find('first',array(
								'fields'=>array('id','vat_percent','sat_percent','vat_of_class','effective_from'),
								'conditions'=>array('VatClass.id'=>$vatId)));

					$this->set('vatEditData',$vatEditData);
				}
				if($this->request->data){
					if($vatEditData['VatClass']['id']){
						$vatArray= array();
						$this->VatClass->id = $vatEditData['VatClass']['id'];
						$vatArray['vat_of_class'] = $this->request->data['VatClass']['vat_of_class'];
						$vatArray['vat_percent'] = $this->request->data['VatClass']['vat_percent'];
						$vatArray['sat_percent'] = $this->request->data['VatClass']['sat_percent'];
						$vatArray['effective_from'] = $this->DateFormat->formatDate2STD($this->request->data['VatClass']['effective_from'],Configure::read('date_format'));
							
						if($this->VatClass->save($vatArray)){
							$this->Session->setFlash(__('Updated!', true));
						}
						$this->redirect(array("controller" => "pharmacy", "action" => "vat"));
						//$this->VatClass->id = " ";
					}
				}
			}else if(empty($vatId) && !empty($this->request->data)) {
					
				$vatClassName = $this->VatClass->find('list',array('fields'=>array('VatClass.id','VatClass.vat_of_class')));
					
				foreach($vatClassName as $name){
						
					if($this->request->data['VatClass']['vat_of_class'] == $name){
							
						$this->Session->setFlash(__('VatClass Name is Already Exists'),'default',array('class'=>'error'));
						return $this->redirect($this->referer());
					}
				}
					
				$this->request->data['VatClass']['create_time'] = date('Y-m-d H:i:s');
				$this->request->data['VatClass']['created_by'] = $this->Auth->user('id');
				$this->request->data['VatClass']['location_id'] = $this->Session->read('locationid');
				$this->request->data['VatClass']['effective_from'] = $this->DateFormat->formatDate2STD($this->request->data['VatClass']['effective_from'],Configure::read('date_format'));
				//$this->VatClass->create();
					
				$this->VatClass->save($this->request->data);
				$this->Session->setFlash(__('Saved!', true));

			}else {
				$errors = $this->VatClass->invalidFields();
				$this->set("errors", $errors);
			}

			$data = $this->VatClass->find('all',array(
								'conditions'=>array('VatClass.is_delete'=>'0'),
								'fields'=>array('id','vat_percent','sat_percent','vat_of_class','effective_from'),
								'order' => array('VatClass.create_time'=>'desc')
			));
			$this->set('data',$data);

		}

		public function view_vat_class($vatId){

			$this->uses = array('VatClass');

			$data = $this->VatClass->find('first',array(
								'fields'=>array('id','vat_percent','sat_percent','vat_of_class','effective_from'),
								'conditions'=>array('VatClass.id'=>$vatId)));
			$this->set('data',$data);

		}

		public function deleteVatOfClass($vatId){
			$this->uses = array('VatClass');
			if(!empty($vatId)){
					
				$delVat = array();
				$delVat['id'] =  $vatId;
				$delVat['is_delete'] = '1';
					
				$this->VatClass->save($delVat);
				$this->Session->setFlash(__('Deleted Successfully', true, array('class'=>'message')));
				$this->redirect(array('controller'=>'Pharmacy','action'=>'vat','inventory'=>false));
			}
		}

		public function inventory_generic_search($fieldNo,$generic){
			$this->layout = "advance_ajax";  
			if(!empty($this->request->data)){
				$generic = $this->request->data['PharmacyItem']['generic_name'];
			}
			$conditions[] = array('OR'=>array("PharmacyItem.stock > 0", "PharmacyItem.loose_stock > 0"));
			$this->PharmacyItem->recursive = 0;
			$data = $this->PharmacyItem->find('all',array('fields'=>array('PharmacyItem.id','PharmacyItem.name','PharmacyItem.item_code','PharmacyItem.pack','PharmacyItem.stock','PharmacyItem.loose_stock','PharmacyItem.generic'),
			'conditions'=>array($conditions,'PharmacyItem.generic'=>$generic),'group'=>"PharmacyItem.id"));
			$this->set('PharmacyData',$data);
			$this->set('field_number',$fieldNo);
		}

		public function inventory_generic_search_new($fieldNo,$generic){
		//	$this->layout = "advance_ajax"; 
			if(!empty($this->request->data)){
				$generic = $this->request->data['val'];
				$fieldNo=$this->request->data['fData'];
			}
			$conditions[] = array('OR'=>array("PharmacyItem.stock > 0", "PharmacyItem.loose_stock > 0"));
			$this->PharmacyItem->recursive = 0;
			$data = $this->PharmacyItem->find('all',array('fields'=>array('PharmacyItem.id','PharmacyItem.name','PharmacyItem.item_code','PharmacyItem.pack','PharmacyItem.stock','PharmacyItem.loose_stock','PharmacyItem.generic'),
			'conditions'=>array($conditions,'PharmacyItem.generic'=>$generic),'group'=>"PharmacyItem.id"));
			$this->set('PharmacyData',$data);
			$this->set('field_number',$fieldNo);
			$this->render('inventory_generic_search_new');
		}
		// By Aditya Vijay to use in Soap Notes as ajax function...
    	public function ajaxTreatmentSheet($patientId=null,$date=null){
    	$this->layout = "advance_ajax";
    	$this->set('title_for_layout', __('-Treatment Sheet', true));
    	$this->uses = array('Patient','TreatmentMedication','TreatmentMedicationDetail','PharmacyItem','PharmacyDuplicateSalesBill','PharmacyDuplicateSalesBillDetail');
    	if(!empty($patientId)){
    		$patientData = $this->Patient->find('first',array(
    				'fields'=>array('Patient.id, Patient.lookup_name, Patient.patient_id, Patient.patient_id, Patient.admission_type,
                     Patient.admission_id, Patient.form_received_on, Patient.doctor_id, Patient.discharge_date, Patient.tariff_standard_id'),
    				'conditions'=>array('id'=>$patientId,'is_deleted'=>'0')));
    		if(!empty($patientData)){
    			$toDate = date("Y-m-d");
    			if(!empty($patientData['Patient']['discharge_date'])){
    				$toDate = $patientData['Patient']['discharge_date'];
    			}
    			$dateListing = $this->GetDays(date("Y-m-d",strtotime($patientData['Patient']['form_received_on'])),$toDate);
    			/*TreatmentMedication*/
    			$dateChange=array();
    			foreach ($dateListing as $key => $value) {
    				$dateChange[]= $key;
    			}
    			$valDates=$this->TreatmentMedication->find('list',array('conditions'=>array('TreatmentMedication.record_date'=>$dateChange,'TreatmentMedication.patient_id'=>$patientId),
    				'fields'=>array('record_date','record_date')));
    			$dateChangeForamt=array();
    			foreach ($valDates as $key => $value) {
    				$dateChangeForamt[]= date('d/m/Y',strtotime($key));
    			}
    			
    			$this->set('dateChangeForamt',$dateChangeForamt);
    			$this->set('dateListing',array_reverse($dateListing));
    			$this->set('patientData',$patientData);
    		}
    	} 
		
    	if(!empty($this->request->data)){
    		$this->request->data['patient_id'] = $patientId;
    		$this->request->data['record_date'] = date('Y-m-d'); 
    		$treatmentMedicationId = $this->TreatmentMedication->saveRecord($this->request->data);
    		$this->Session->setFlash(__('Record Saved Successfully', true));
            echo $this->render("ajax_treatment_sheet");
    		exit;

    	}
    
    	if(!empty($patientId) && !empty($date)){
    		$this->TreatmentMedicationDetail->bindModel(array(
    				'belongsTo'=>array(
    						'TreatmentMedication'=>array(
    								'foreignKey'=>false,
    								'type'=>'inner',
    								'conditions'=>array(
    										'TreatmentMedicationDetail.treatment_medication_id = TreatmentMedication.id'
    								)
    						),
    						'PharmacyItem'=>array(
    								'foreignKey'=>false,
    								'type'=>'inner',
    								'conditions'=>array(
    										'TreatmentMedicationDetail.item_id = PharmacyItem.id'
    								)
    						)
    				)
    		),false);
    
    		$treatmentData = $this->TreatmentMedicationDetail->find('all',array(
    				'fields'=>array('TreatmentMedication.id, TreatmentMedication.duplicate_pharmacy_sale_bill_id','TreatmentMedicationDetail.item_id, TreatmentMedicationDetail.quantity, TreatmentMedicationDetail.routes, TreatmentMedicationDetail.dosage, TreatmentMedicationDetail.is_show',
    						'PharmacyItem.name'),
    				'conditions'=>array('TreatmentMedication.record_date'=>$date,'TreatmentMedication.patient_id'=>$patientId,'TreatmentMedication.is_deleted'=>'0','TreatmentMedicationDetail.is_show'=>'1')));
    
			 
    		foreach($treatmentData as $key => $val){  
				$temp[$val['TreatmentMedicationDetail']['item_id']]['quantity'] = $val['TreatmentMedicationDetail']['quantity'] + $temp[$val['TreatmentMedicationDetail']['item_id']]['quantity'];
					$treatData[$val['TreatmentMedicationDetail']['item_id']] = $val; 
					$treatData[$val['TreatmentMedicationDetail']['item_id']]['TreatmentMedicationDetail']['quantity'] = $temp[$val['TreatmentMedicationDetail']['item_id']]['quantity'];
    		}
			
			$salesBillIds = $this->TreatmentMedication->find('list',array('fields'=>array('id','duplicate_pharmacy_sale_bill_id'),'conditions'=>array('TreatmentMedication.record_date'=>$date,'TreatmentMedication.patient_id'=>$patientId)));

    		$this->PharmacyDuplicateSalesBill->hasMany = array();
    		$salesData = $this->PharmacyDuplicateSalesBill->find('all',array('fields'=>array('PharmacyDuplicateSalesBill.id, PharmacyDuplicateSalesBill.patient_id,
            			PharmacyDuplicateSalesBill.doctor_id, PharmacyDuplicateSalesBill.total, PharmacyDuplicateSalesBill.payment_mode, PharmacyDuplicateSalesBill.bill_code,
            		PharmacyDuplicateSalesBill.create_time'),
    				'conditions'=>array('PharmacyDuplicateSalesBill.id'=>array_unique($salesBillIds))));
    		$this->set('saleBillData',$salesData);
    		$this->set('treatmentData',$treatData); 
    	}
    	echo $this->render("ajax_treatment_sheet");
    	exit;
    }

		//for accounting by amit
		function addDirectReceipt($requestData=array(),$userId=null){
			$this->loadModel('Account');
			$this->loadModel('AccountReceipt');
			$this->loadModel('VoucherLog');
			$this->loadModel('VoucherPayment');

			//voucher enrty id for account_receipt of journal_entry_id by amit jain
			$cashId = $this->Account->getAccountIdOnly(Configure::read('cash'));//for cash id
			if(!empty($requestData['Billing']['amount'])){
				$voucherLogDataFinalpayment=$rvData = array('date'=>$requestData['Billing']['date'],
					'modified_by'=>$this->Session->read('userid'),
					'create_by'=>$this->Session->read('userid'),
					'account_id'=>$cashId,
					'user_id'=>$userId,
					'type'=>'DirectSaleBill',
					'narration'=>$requestData['Billing']['remark'],
					'paid_amount'=>$requestData['Billing']['amount']);
				$lastVoucherIdRecFinal=$this->AccountReceipt->insertReceiptEntry($rvData);
				//insert into voucher_logs table added by PankajM
				$voucherLogDataFinalpayment['voucher_no']=$lastVoucherIdRecFinal;
				$voucherLogDataFinalpayment['voucher_id']=$lastVoucherIdRecFinal;
				$voucherLogDataFinalpayment['voucher_type']="Receipt";
				$this->VoucherLog->insertVoucherLog($voucherLogDataFinalpayment);
				//End
				$this->VoucherLog->id= '';
				$this->AccountReceipt->id= '';
				// ***insert into Account (By) credit manage current balance
				$this->Account->setBalanceAmountByAccountId($userId,$requestData['Billing']['amount'],'debit');
				$this->Account->setBalanceAmountByUserId($cashId,$requestData['Billing']['amount'],'credit');
			}
			if($requestData['Billing']['refund'] == 1){
				if($requestData['Billing']['mode_of_payment'] == 'Cash'){
					$voucherLogDataPay=$pvData = array('date'=>$requestData['Billing']['date'],
							'modified_by'=>$this->Session->read('userid'),
							'create_by'=>$this->Session->read('userid'),
							'account_id'=>$cashId,
							'user_id'=>$userId,
							'type'=>'DirectPharmacyRefund',
							'narration'=>$requestData['Billing']['remark'],
							'paid_amount'=>round($requestData['Billing']['paid_to_patient']));
					if(!empty($pvData['paid_amount']) && ($pvData['paid_amount'] != 0)){
						$lastVoucherIdPayment=$this->VoucherPayment->insertPaymentEntry($pvData);
						//insert into voucher_logs table added by PankajM
						$voucherLogDataPay['voucher_no']=$lastVoucherIdPayment;
						$voucherLogDataPay['voucher_id']=$lastVoucherIdPayment;
						$voucherLogDataPay['voucher_type']="Payment";
						$this->VoucherLog->insertVoucherLog($voucherLogDataPay);
						$this->VoucherLog->id= '';
						$this->VoucherPayment->id= '';
						//End
						// ***insert into Account (By) credit manage current balance
						$this->Account->setBalanceAmountByAccountId($cashId,$requestData['Billing']['paid_to_patient'],'debit');
						$this->Account->setBalanceAmountByUserId($userId,$requestData['Billing']['paid_to_patient'],'credit');
					}
				}
			}
		}

		public function inventory_generic_item(){
			$this->layout = "advance_ajax";
			$searchKey = $this->params->query['term'];
			$conditions["PharmacyItem.is_deleted"] ='0';
			$conditions["PharmacyItem.drug_id !="] ='0';
			$conditions["PharmacyItem.generic LIKE"] = $searchKey."%";

			$this->PharmacyItem->recursive = 0;
			$items = $this->PharmacyItem->find('all', array('fields'=>array('PharmacyItem.id','PharmacyItem.item_code','PharmacyItem.name','PharmacyItem.stock','PharmacyItem.generic'),'conditions'=>$conditions,'limit'=>15,'group' => 'PharmacyItem.generic'));
			foreach($items as $val){
				$returnArray[] = array('id'=>$val['PharmacyItem']['id'],'value'=>$val['PharmacyItem']['generic']);
			}
			echo json_encode($returnArray);
			exit;//dont remove this
		}

	

		public function savePharmacyDirectReturn($billId){
			
			$this->autoRender = false;
			$this->layout = "ajax";
			$this->uses = array('PharmacySalesBill','InventoryPharmacySalesReturn','InventoryPharmacySalesReturnsDetail','PharmacyReturnDetail');
			$pharSaleBill = $this->PharmacySalesBill->find('first',array('conditions'=>array('PharmacySalesBill.id'=>$billId)));
			
			/* $sales_return = $this->InventoryPharmacySalesReturn->find('all',array(
			 'conditions'=>array('InventoryPharmacySalesReturn.pharmacy_sale_bill_id'=>$billId),
			 'fields'=>array('InventoryPharmacySalesReturn.id','InventoryPharmacySalesReturn.pharmacy_sale_bill_id'))); */
			$updateSalesBill = array();
			
			$this->request->data['InventoryPharmacySalesReturn']['pharmacy_sale_bill_id'] = $billId;
			if($this->Session->read('locationid')=='25'|| $this->Session->read('locationid')=='26'){
			$this->request->data['InventoryPharmacySalesReturn']['bill_code'] = $this->InventoryPharmacySalesReturn->generateSalesReturnBillNoForKanpur($this->Session->read('locationid'));
			}else{
			$this->request->data['InventoryPharmacySalesReturn']['bill_code'] = $this->InventoryPharmacySalesReturn->generateReturnBillNo($this->Session->read('locationid'));
			}
			$this->request->data['InventoryPharmacySalesReturn']['customer_name'] = $pharSaleBill['PharmacySalesBill']['customer_name'];
			$this->request->data['InventoryPharmacySalesReturn']['account_id'] = $pharSaleBill['PharmacySalesBill']['account_id'];
			$this->request->data['InventoryPharmacySalesReturn']['location_id'] = $this->Session->read('locationid');
			$this->request->data['InventoryPharmacySalesReturn']['created_by'] = $this->Session->read('userid');
			$this->request->data['InventoryPharmacySalesReturn']['create_time'] = date("Y-m-d H:i:s");
			$this->request->data['InventoryPharmacySalesReturn']['return_date'] = date("Y-m-d H:i:s");    //Date of Return
			$this->InventoryPharmacySalesReturn->create();
			if($this->InventoryPharmacySalesReturn->save($this->request->data)){
				$lastInsertedID = $this->InventoryPharmacySalesReturn->getLastInsertId();
				//BOF for accounting by amit jain
				$userId = $pharSaleBill['PharmacySalesBill']['account_id'];
				$narration = 'Being pharmacy drugs amount refund to pt. '.$pharSaleBill['PharmacySalesBill']['customer_name']." ".'done on '.$this->DateFormat->formatDate2STD($pharSaleBill['PharmacySalesBill']['create_time'],Configure::read('date_format'));
				$accountingData = array('date'=>$pharSaleBill['PharmacySalesBill']['create_time'],
						'created_by'=>$this->Session->read('userid'),
						'refund'=>'1',
						'paid_to_patient'=>$this->request->data['InventoryPharmacySalesReturn']['total'],
						'pharmacy_id'=>$billId,
						'mode_of_payment'=>"Cash",
						'remark'=>$narration,
						);
				$accountingDataDetails['Billing'] = $accountingData;
				$this->addDirectReceipt($accountingDataDetails,$userId);
				//EOF by amit jain
				
				//refund direct to direct sales return by Swapnil by 02.04.2015
				$this->PharmacySalesBill->id = $pharSaleBill['PharmacySalesBill']['id'];
				$updateSalesBill['paid_to_patient'] = $this->request->data['InventoryPharmacySalesReturn']['total'] + $pharSaleBill['PharmacySalesBill']['paid_to_patient'];
				$updateSalesBill['create_time']=$pharSaleBill['PharmacySalesBill']['create_time'];
				
				$this->PharmacySalesBill->save($updateSalesBill);
				$this->PharmacySalesBill->id = '';
				
				// Save Refund entry in PharmacyReturnDetails - By Mrunal 06/07/15
				if($this->request->data['InventoryPharmacySalesReturn']['patient_id'] == null && $pharSaleBill['PharmacySalesBill']['payment_mode'] == 'cash'){
					$returnDetail = array();
					$returnDetail['pharmacy_sales_bill_id'] = $this->request->data['InventoryPharmacySalesReturn']['pharmacy_sale_bill_id'];
					$returnDetail['pharmacy_sales_return_id'] = $lastInsertedID;
					$returnDetail['paid_to_patient'] = $this->request->data['InventoryPharmacySalesReturn']['total'];
					$returnDetail['discount'] = $this->request->data['InventoryPharmacySalesReturn']['discount'];
					$returnDetail['create_time'] = date("Y-m-d H:i:s");
					$returnDetail['created_by'] = $this->Session->read('userid');
					$returnDetail['location_id'] = $this->Session->read('locationid');
					$returnDetail['type_of_return'] = 'direct_return';
						
					$this->PharmacyReturnDetail->save($returnDetail);
					$this->PharmacyReturnDetail->id = '';
				}
				//EOF PharmacyReturnDetails
			}	
			$errors = $this->InventoryPharmacySalesReturn->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->InventoryPharmacySalesReturnsDetail->saveSaleReturn($this->request->data,$lastInsertedID);
				$this->Session->setFlash(__('The Sale Return Details has been saved', true));
				return $lastInsertedID;
			}
		}

		public function newfile(){

		}

		public function inventory_vat_liability_report(){
			$this->layout = "advance";
			$this->uses = array('StoreLocation','VatClass','PurchaseOrder','PurchaseOrderItem','PharmacyItem','PharmacyItemRate','PharmacySalesBillDetail');

			$pharmacyDetail = $this->StoreLocation->find('list',array('fields'=>array('StoreLocation.code_name','StoreLocation.id'),
								'conditions'=>array("StoreLocation.is_deleted"=>0/*"StoreLocation.code_name"=>Configure::read('pharmacyCode')*/)));
			$pharmacyId = $pharmacyDetail[Configure::read('pharmacyCode')];	//pharmacy Id

			$this->PurchaseOrderItem->bindModel(array(
				'belongsTo'=>array(
					'PurchaseOrder' => array('foriegnKey' => false,'conditions' => array('PurchaseOrder.id = PurchaseOrderItem.purchase_order_id')),
					'VatClass' => array('foreignKey' => 'vat_class_id'),
					'Product' => array('foreignKey' => 'product_id')
			/*'PharmacyItem' => array('foreignKey' => false, 'conditions' => array('PharmacyItem.drug_id = PurchaseOrderItem.product_id')),
			 'PharmacyItemRate' => array('foreignKey' => false, 'conditions' => array('PharmacyItem.id = PharmacyItemRate.item_id')),*/
			)));

			$purchaseData = $this->PurchaseOrderItem->find('all',array(
				'fields'=>array('PurchaseOrder.received_date','PurchaseOrderItem.*','VatClass.*','Product.name'/*'PharmacyItem.name','PharmacyItemRate.*'*/),
				'conditions'=>array('PurchaseOrder.order_for'=>'Closed','PurchaseOrder.order_for'=>$pharmacyId)));
			//debug($data);
			$this->set('result',$purchaseData);

			$this->PharmacySalesBillDetail->bindModel(array(
				'belongsTo' => array(
					'PharmacyItem' => array('foreignKey' => 'item_id'),
					'PharmacyItemRate' => array('foreignKey' => false, 
												'conditions' => array('PharmacyItem.id = PharmacyItemRate.item_id','PharmacyItemRate.batch_number = PharmacySalesBillDetail.batch_number')),
			)));

			$soldData = $this->PharmacySalesBillDetail->find('all',array('conditions' => array()));
			
			if ($this->request->query['flag']=='excel') {
			$this->layout = false;			
			$this->render('vat_liability_report_excel');
			}
			
		}

		public function printRefundPayment($recId=null){

		 $website=$this->Session->read('website.instance');
		 if($website == 'kanpur')
		 {
		 	if($this->request->query['header'] == 'without')
		 	{
		 		$this->layout = false;
		 	}else{
		 		$this->layout = 'print_with_header';
		 	}
		 }else{
		 	$this->layout = false;
		 }
		 $this->PharmacySalesBill->unBindModel(array('belongsTo'=>array('Patient','Doctor','Initial')));
		 $conditions['PharmacySalesBill.location_id'] = $this->Session->read('locationid');
		 //$conditions['PharmacySalesBill.customer_name NOT'] = NULL;
		 $conditions['PharmacySalesBill.id'] = $recId;
		 $conditions['PharmacySalesBill.is_deleted'] ='0';
		 //$conditions['PharmacySalesBill.account_id'] = $accountId;
		 	
		 $phramacySalesData = $this->PharmacySalesBill->find('first',array(
						'order' => array('PharmacySalesBill.create_time' => 'desc'),
						'fields'=> array('PharmacySalesBill.id','PharmacySalesBill.customer_name','PharmacySalesBill.doctor_id','PharmacySalesBill.account_id',
								'PharmacySalesBill.tax','PharmacySalesBill.paid_amnt','PharmacySalesBill.total','PharmacySalesBill.discount','PharmacySalesBill.bill_code', 'PharmacySalesBill.payment_mode',
								'PharmacySalesBill.create_time','PharmacySalesBill.credit_period','PharmacySalesBill.modified_time','PharmacySalesBill.remark','PharmacySalesBill.paid_to_patient'),
						'conditions'=>array($conditions)
		 ));

		 $this->set('title_for_layout', __('DirectSales Details', true));
		 $data =  $phramacySalesData ; //$this->paginate('PharmacySalesBill');

		 $this->set('data',$data);
		 //$this->set(array('billingData'=>$billingData,'patientData'=>$patientData));

		}

		public function get_direct_bill($patient_id){
			$this->layout = false;
			$this->loadModel('ServiceCategory');
			$this->loadModel('PharmacySalesBill');
			$this->PharmacySalesBill->bindModel(array(
				'belongsTo'=>array(
						'Patient'=>array('foreignKey'=>'patient_id'))));
			//$pharId=$this->ServiceCategory->find('first',array('conditions'=>array('ServiceCategory.name'=>Configure::read('pharmacyservices'))));
			//$payment_category = $this->ServiceCategory->getPharmacyId();
			$directPharArray=$this->PharmacySalesBill->find('all',array('fields'=>array('PharmacySalesBill.*'),
				'conditions'=>array('PharmacySalesBill.account_id'=>$patient_id,'PharmacySalesBill.is_deleted'=>0)));
			$this->set('patientId',$patient_id);
			$this->set('directPharArray',$directPharArray);

		}

		public function deleteDirectSaleEntry($recId=null){
			$this->loadModel('PharmacySalesBill');
			//$this->loadModel('ServiceBill');
			$this->loadModel('AccountReceipt');
			//debug($recId);exit;
			//$this->Billing->find('first',array('fields'=>array('payment_category','tariff_list_id'),'conditions'=>array('id'=>$recId)));
			//$this->PharmacySalesBill->updateAll(array('PharmacySalesBill.is_deleted'=>1),array('PharmacySalesBill.id'=>$recId));
			$this->AccountReceipt->updateAll(array('AccountReceipt.is_deleted'=>1),
					array('AccountReceipt.billing_id'=>$recId,'AccountReceipt.type'=>'DirectSaleBill'));

			$this->Session->setFlash(__('Record deleted successfully', true));
			$this->redirect($this->referer());
		}

		public function printDirectSaleBill(){
			//pr($this->request->query);exit;
			$website=$this->Session->read('website.instance');
			if($website == 'kanpur')
			{
				if($this->request->query['flag'] == 'without_header')
				{
					$this->layout = false;
				}
				else if($this->request->query['flag'] == 'roman_header')
				{
					$this->layout = 'roman_pharma_header';
				}
				else{
					$this->layout = 'print_with_header';
				}

			}else
			{
				$this->layout = false;
			}

			$this->uses = array('PharmacySalesBill','Patient');
			$this->Patient->bindModel(array(
				'belongsTo' => array( 'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
			)),false);

			$this->PharmacySalesBill->bindModel(array(
				'belongsTo' => array('User' =>array('foreignKey' => false,'conditions'=>array('User.id=PharmacySalesBill.created_by' )),
			)),false);

			if($this->request->params){
				$custoId = $this->request->params['pass'][0];
				$directPharData = $this->PharmacySalesBill->find('first',array('fields'=>array('PharmacySalesBill.*','User.username','User.first_name','User.last_name'),'conditions'=>array('PharmacySalesBill.id'=>$custoId,'PharmacySalesBill.is_deleted'=>'0')));
				//$patientData = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$billingData['Billing']['patient_id']), 'fields' => array('Patient.*','PatientInitial.name')));
				$this->set(array('directPharData'=>$directPharData/*,'patientData'=>$patientData*/));
				//$this->patient_info($billingData['Billing']['patient_id']);

			}
		}

		/**
		 * function to print prescriptions sold from duplicate sales
		 * @param int $patientId , string $salesBillIds , string $model
		 * @static $model can be PharmacyDuplicateSalesBill or PharmacySalesBill
		 * @author Swati Newale
		 */
		public function viewPrescription($patientId,$salesBillIds,$model){
			$this->layout = false;
			$this->uses = array('Patient','PharmacyDuplicateSalesBill','PharmacyDuplicateSalesBillDetail','PharmacySalesBill','PharmacySalesBillDetail');
			$this->Patient->bindModel(array(
				'hasOne' => array(
						'User' => array('foreignKey' =>false, 'conditions'=>array('User.id = Patient.doctor_id'))),
			));
			$this->set('patientDetail',$this->Patient->find('first', array('conditions'=>array("Patient.id"=>$patientId),
					'fields'=>array('Patient.id','Patient.admission_id','CONCAT(User.first_name," ",User.last_name) as name','Patient.lookup_name','Patient.doctor_id'))));
			$duplicateIds = explode(',',$salesBillIds);
			if($model == 'PharmacyDuplicateSalesBill')
			$phramacySalesData =$this->PharmacyDuplicateSalesBillDetail->find('all',array('fields'=> array('PharmacyDuplicateSalesBillDetail.id',
				'PharmacyDuplicateSalesBillDetail.qty, PharmacyDuplicateSalesBillDetail.pharmacy_duplicate_sales_bill_id','PharmacyItem.name','PharmacyItem.generic','PharmacyDuplicateSalesBill.create_time'),
				'order' => array('PharmacyDuplicateSalesBill.create_time' => 'ASC'),
				'conditions'=>array('PharmacyDuplicateSalesBillDetail.pharmacy_duplicate_sales_bill_id'=>$duplicateIds,'PharmacyDuplicateSalesBill.is_deleted' =>'0')));
			else if($model == 'PharmacySalesBill')
			$phramacySalesData =$this->PharmacySalesBillDetail->find('all',array('fields'=> array('PharmacySalesBillDetail.pharmacy_sales_bill_id',
					'PharmacySalesBillDetail.id','PharmacySalesBillDetail.qty','PharmacyItem.name','PharmacyItem.generic','PharmacySalesBill.create_time',
					'PharmacySalesBill.modified_time'),
					'order' => array('PharmacySalesBill.create_time' => 'ASC'),
					'conditions'=>array('PharmacySalesBillDetail.pharmacy_sales_bill_id'=>$duplicateIds,'PharmacySalesBill.is_deleted' =>'0')));
			$this->set('phramacySalesData',$phramacySalesData);
			//debug($phramacySalesData);
			$this->set('model',$model);
		}



		/**
		 * for list of inpatient
		 * @yashwant
		 */
		public function inpatientList(){
			$this->layout='advance';
			$this->loadModel('Patient');
			$this->loadModel('ServiceCategory');
			$this->set('data','');
			$pharmacyID=$this->ServiceCategory->getPharmacyId();
			$this->paginate = array(
			'limit' => Configure::read('number_of_rows')
			);
			$search_key['Patient.is_deleted'] = 0;
			$search_key['Patient.is_discharge'] = 0;
			$search_key['Patient.admission_type'] = 'IPD';
			//$search_key['Patient.location_id']=$this->Session->read('locationid');
			$this->Patient->bindModel(array(
			'belongsTo' => array(
					'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
					'Initial' =>array('foreignKey' => false,'conditions'=>array('User.initial_id=Initial.id' )),
					'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
					'Billing' =>array('foreignKey' => false,'conditions'=>array('Patient.id=Billing.patient_id','Billing.payment_category'=>$pharmacyID,
							'Billing.pharmacy_sales_bill_id'=>'')),
					'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
					'State' =>array('foreignKey' => false,'conditions'=>array('State.id =Person.state' )),
					'Country' =>array('foreignKey' => false,'conditions'=>array('Country.id =Person.country' )),
					'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id =Patient.department_id' )),
					'Location' =>array('foreignKey' => 'location_id'),
					'Ward'=>array('foreignKey' => 'ward_id'),
					'Room'=>array('foreignKey' => 'room_id')
			)),false);

			// If patient is IPD
			if(!empty($this->params->query)){
				$search_ele = $this->params->query  ;//make it get
				if(!empty($search_ele['lookup_name'])){
					$search_ele['lookup_name'] = explode(" ",$search_ele['lookup_name']);
					if(count($search_ele['lookup_name']) > 1){
						/* $search_key['SOUNDEX(Person.first_name) like'] = "%".soundex(trim($search_ele['lookup_name'][0]))."%";
							$search_key['SOUNDEX(Person.last_name) like'] = "%".soundex(trim($search_ele['lookup_name'][1]))."%"; */
							
						$search_key['Person.first_name like'] = "%".trim($search_ele['lookup_name'][0])."%";
						$search_key['Person.last_name like'] = "%".trim($search_ele['lookup_name'][1])."%";
					}else if(count($search_ele['lookup_name)']) == 0){
						$search_key['OR'] = array(
						/* 'SOUNDEX(Person.first_name)  like'  => "%".soundex(trim($search_ele['lookup_name'][0]))."%",
						 'SOUNDEX(Person.last_name)   like'  => "%".soundex(trim($search_ele['lookup_name'][0]))."%" */
									'Person.first_name like'  => "%".trim($search_ele['lookup_name'][0])."%",
									'Person.last_name like'  => "%".trim($search_ele['lookup_name'][0])."%"
									);
					}
				}if(!empty($search_ele['dob'])){
					$search_key['Person.dob like '] = "%".trim(substr($this->DateFormat->formatDate2STD($search_ele['dob'],Configure::read('date_format')),0,10));
				}
				if(!empty($search_ele['patient_id'])){
					$search_key['Patient.admission_id '] = $search_ele['patient_id'];
				}
				$conditions = $search_key;
			}else{
				$conditions = array($search_key);
			}

			// Paginate Data here
			$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => $orderstatus,
				'group' => 'Patient.person_id',
				'fields'=> array('Patient.form_received_on,Patient.form_received_on,Patient.discharge_date,CONCAT(PatientInitial.name," ",Patient.lookup_name) as lookup_name,
						Patient.id,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, User.initial_id,
						Patient.create_time, Initial.name','Person.ssn_us','Department.name','Person.sex','Person.dob','Person.first_name','Person.last_name','Person.mobile',
						'Person.plot_no','Person.city','State.name','Country.name','Sum(Billing.amount) as advance','Ward.id','Ward.name','Ward.wardid','Ward.ward_type'),
				'conditions'=>$conditions ,
			);
			$this->set('data',$this->paginate('Patient'));
		} 
		
		//function to insert,update nursing data		
		function updateNursingData($data=array(),$patient_id=null,$batchId=null,$lastInsertedIdOfSalesBill=null){
			/* 
			 * Statuts 2: Completed
			 * Status 1: partial
			 * Status 0: pending*/
			$this->request->data = $data ;//overwrite from function argument
			
			$qty = $this->request->data['qty'];
			$itemId = $this->request->data['item_id'];
			$itemName = $this->request->data['item_name'];
			$deletd_id = $this->request->data['deleted_id'];
			$fromNewCrop = $this->request->data['new_crop_itemId'];
			$cahngedQty = $this->request->data['changed_qty'];
			 
			$overrideMedId = array_diff($itemId,$fromNewCrop); //new item ids
			$oldOne = array_diff($fromNewCrop,$itemId); //overridden ids 
			$remainingId = array_intersect($fromNewCrop, $itemId);//rest of the ids expect above 2
			$deletdFromSale = explode("_",$deletd_id);	//deleted IDS
			
			$newCropData = $this->NewCropPrescription->find('all',array('conditions'=>array( 'patient_uniqueid'=>$patient_id,
					'batch_identifier'=>$batchId)));
			
			
			foreach($newCropData as $newCropkey =>$newCropValue){
				//update delted items
				
				if(!empty($deletdFromSale)){
					foreach($deletdFromSale as $delId=>$delValue){ 
						if($newCropValue['NewCropPrescription']['drug_id']==$delValue){
							$dataCrop['id'] = $newCropValue['NewCropPrescription']['id'];
							$dataCrop['is_deleted'] = 1; 
							$dataCrop['status'] = 2;
							$this->NewCropPrescription->save($dataCrop);
							$this->NewCropPrescription->id = "";
						}
					}//EOF deleted for
				}//EOF deleted if
				
				
				//update overridden items
				if(!empty($oldOne)){
					foreach($oldOne as $oldId=>$oldValue){
						if($newCropValue['NewCropPrescription']['drug_id']==$oldValue){
							$dataCrop = array();
							$dataCrop['id'] = $newCropValue['NewCropPrescription']['id'];
							$dataCrop['status'] = 2;
							$dataCrop['is_override'] = 2; 
							$this->NewCropPrescription->save($dataCrop);
							$this->NewCropPrescription->id = "";
						}
					}//EOF oldone for
				}//EOF oldone if 
				
				//insert new medcine
				if(!empty($overrideMedId)){
					foreach($overrideMedId as $overrideMedId=>$overrideMedValue){
						if($newCropValue['NewCropPrescription']['drug_id']==$overrideMedValue){
							$arrayOfNew = array();
							$arrayOfNew['drug_id'] = $overrideMedValue;
							$arrayOfNew['location_id'] = $this->Session->read('locationid');
							$arrayOfNew['drug_name'] = $itemName[$overrideMedId];
							$arrayOfNew['description'] = $itemName[$overrideMedId];
							$arrayOfNew['date_of_prescription'] = $this->DateFormat->formatDate2STD($this->request->data['PharmacySalesBill']['create_time'],Configure::read('date_format'));
							$arrayOfNew['patient_uniqueid'] = $patient_id;
							$arrayOfNew['created_by'] = $this->Auth->user('id');
							$arrayOfNew['archive'] = 'N';
							$arrayOfNew['quantity'] = $qty[$overrideMedId];
							$arrayOfNew['by_nurse'] = 1;
							$arrayOfNew['status'] = 2;
							$arrayOfNew['for_normal_med'] = 0;
							$arrayOfNew['drm_date'] = date("Y-m-d");
							$arrayOfNew['is_override'] = 1;
							$arrayOfNew['batch_identifier'] = $batchId;
							$arrayOfNew['pharmacy_sales_bill_id'] = $lastInsertedIdOfSalesBill;
							if($newCropValue['NewCropPrescription']['recieved_quantity']!="" || $newCropValue['NewCropPrescription']['recieved_quantity']!=0){
								$arrayOfNew['recieved_quantity'] = $newCropValue['NewCropPrescription']['recieved_quantity']+$qty[$overrideMedId];
							}else{
								$arrayOfNew['recieved_quantity'] = $qty[$overrideMedId];
							}
							
							$this->NewCropPrescription->save($arrayOfNew);
							$this->NewCropPrescription->id = "";
						}
					}//EOF insert new med
				}//EOF new med
				
				
				//remaining items
				if(!empty($remainingId)){ 
					foreach($remainingId as $remainingKey=>$remainingValue){ 
						if($newCropValue['NewCropPrescription']['drug_id']==$remainingValue){
							$dataCrop = array();
							//to maintain partial quantity 
							$remainingQty = (int)$newCropValue['NewCropPrescription']['quantity'] - (int)$newCropValue['NewCropPrescription']['recieved_quantity'];
							if($remainingQty==$qty[$remainingKey]){
								$dataCrop['status'] = 2;//completed
							}else{
								$dataCrop['status'] = 1;//partial
							}
						
							$dataCrop['id'] = $newCropValue['NewCropPrescription']['id']; 
							$dataCrop['pharmacy_sales_bill_id'] = $lastInsertedIdOfSalesBill;
							
							if($newCropValue['NewCropPrescription']['recieved_quantity']!="" || $newCropValue['NewCropPrescription']['recieved_quantity']!=0){
								$dataCrop['recieved_quantity'] = $newCropValue['NewCropPrescription']['recieved_quantity']+$qty[$remainingKey]; 
							}else{
								$dataCrop['recieved_quantity'] = $qty[$remainingKey];
							}
							$this->NewCropPrescription->save($dataCrop);
							$this->NewCropPrescription->id = "";
						}
					}//EOF remaining for
				}//EOF remaining if 
				//remaining items
				
				 
			} 
		}  
		
		
		/** PharmacySalesBill Money Collected Print **/
		public function money_collected_print_reciept(){
			$website=$this->Session->read('website.instance');
			if($website == 'kanpur')
			{
				if($this->request->query['flag'] == 'without_header')
				{
					$this->layout = false;
				}
				else if($this->request->query['flag'] == 'roman_header')
				{
					$this->layout = 'roman_pharma_header';
				}
				else{
					$this->layout = 'print_with_header';
				}
		
			}else
			{
				$this->layout = false;
			}
		
			$this->uses = array('Billing','Patient','PharmacySalesBill');
			$this->Patient->bindModel(array(
					'belongsTo' => array(   'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
							'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id =Patient.tariff_standard_id' )),
					)),false);
		
			$this->Billing->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Billing.created_by' )),
							'PatientCard' =>array('foreignKey' => false,'conditions'=>array('PatientCard.billing_id=Billing.id' )),
							'PharmacySalesBill'=>array('foreignKey' => false, 'conditions'=>array('Billing.pharmacy_sales_bill_id = PharmacySalesBill.id'))
					)),false);
		
			if($this->request->params){
				$salebillingId = $this->request->params['pass'][0];
				$billingData = $this->Billing->find('first',array('fields'=>array('Billing.*','User.username','User.first_name','User.last_name','PatientCard.amount','PharmacySalesBill.*'),
						'conditions'=>array('Billing.pharmacy_sales_bill_id'=>$salebillingId,'Billing.is_deleted'=>'0')));
				$patientData = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$billingData['Billing']['patient_id']),
						'fields' => array('Patient.*','PatientInitial.name','TariffStandard.name')));
					
					
				$this->set(array('billingData'=>$billingData,'patientData'=>$patientData));
				$this->patient_info($billingData['Billing']['patient_id']);
		
			}
		}
		/** END of slaes bIll MoneyCollected Print  **/
		
		//to update current stock in pharmacy item  = sum(batches stock)
		public function updatePharmacyCompleteStock(){
			$this->autoRender = false;
			$this->layout = 'ajax';
			$this->uses = array("PharmacyItem","PharmacyItemRate"); 
			$this->PharmacyItem->hasOne = array();
			$this->PharmacyItem->hasMany = array(); 
			$pharmacyData = $this->PharmacyItem->find('all',array('fields'=>array('PharmacyItem.id','PharmacyItem.pack','PharmacyItem.name','PharmacyItem.stock','PharmacyItem.loose_stock')));
			
			$count = 0;
			$name = "\n";
			foreach ($pharmacyData as $key => $val){
				
				$pack = $val['PharmacyItem']['pack'];
				$totalMSUofPharmacyItem = ($val['PharmacyItem']['stock'] * $pack) + $val['PharmacyItem']['loose_stock'];
				
				$pharmacyRateSum = $this->PharmacyItemRate->find('first',array(
						'fields'=>array('SUM(PharmacyItemRate.stock) as stock','SUM(PharmacyItemRate.loose_stock) as loose_stock'),
						'conditions'=>array('PharmacyItemRate.is_deleted'=>'0','PharmacyItemRate.item_id'=>$val['PharmacyItem']['id'])));
				
				$totalMSUofPharmacyItemRate =  ($pharmacyRateSum[0]['stock'] * $pack) + $pharmacyRateSum[0]['loose_stock'];
				//echo "---".$val['PharmacyItem']['stock']."-".$pack."-".$val['PharmacyItem']['loose_stock']."==".$totalMSUofPharmacyItem."---\n";
				if($totalMSUofPharmacyItem != $totalMSUofPharmacyItemRate){
					$this->PharmacyItem->id = $val['PharmacyItem']['id'];
					$updatePharmacyItem['stock'] = floor($totalMSUofPharmacyItemRate/$pack);
					$updatePharmacyItem['loose_stock'] = floor($totalMSUofPharmacyItemRate%$pack); 
					if($this->PharmacyItem->save($updatePharmacyItem)){
						$name .= $count++.") ".$val['PharmacyItem']['name']." = ".$totalMSUofPharmacyItem."/".$totalMSUofPharmacyItemRate.",\n";
						//$name .= $val['PharmacyItem']['name'].", ";
					}
					$this->PharmacyItem->id = '';
					//$count++;
				}
			}  
			echo "successfully updated following $count products : $name";
		}
		
		/* for fetch the bill  */
		public function inventory_fetch_return_bill_num($field=null){
			$this->loadModel('InventoryPharmacySalesReturn');
			$searchKey = $this->params->query['term'];
			$filedOrder = array('id','bill_code');
			$conditions[$field." like"] = "%".$searchKey."%";
			$conditions["InventoryPharmacySalesReturn.location_id"] =$this->Session->read('locationid');
			$items = $this->InventoryPharmacySalesReturn->find('list', array('fields'=> $filedOrder,'conditions'=>array($conditions,'InventoryPharmacySalesReturn.is_deleted' =>'0'),'limit'=>10));
			$output ='';
			foreach ($items as $key=>$value) {
				$returnArray[] = array('id'=>$key,'value'=>$value);
				//$output .= "$key|$value";
				//$output .= "\n";
			}
			echo json_encode($returnArray);
			//echo $output;
			exit;//dont remove this
		}
		
		/** Function for Kanpur DIRECT RETURN - MRUNAL */
		public function inventory_direct_sales_return(){
			$this->layout='advance';
			$this->loadModel("Configuration");
			
			$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website')));
			$websiteConfig = unserialize($website_service_type['Configuration']['value']);
			if($websiteConfig['instance']=='kanpur'){
				$mode_of_payment = array('Cash'=>'Cash','Credit'=>'Credit');
			}
			$this->set('mode_of_payment',$mode_of_payment);
			
			$this->uses = array('InventoryPharmacySalesReturn','InventoryPharmacySalesReturnsDetail');
			if($this->request->is('post') && !empty($this->request->data)) { 
				$directReturnData = array();
				
				$directReturnData['customer_name'] = $this->request->data['DirectReturn']['patient_name'];
				$directReturnData['create_time'] = date('Y-m-d H:i:s');
				$directReturnData['created_by'] = $this->Auth->user('id');
				$directReturnData['location_id'] = $this->Session->read('locationid');
				$directReturnData['return_date'] = $this->DateFormat->formatDate2STD($this->request->data['DirectReturn']['return_date'],Configure::read('date_format'));
				$directReturnData['doctor_name']  = $this->request->data['DirectReturn']['doctor_name'];
				$directReturnData['total'] =  $this->request->data['InventoryPharmacySalesReturn']['total'];
				$directReturnData['discount'] =  $this->request->data['InventoryPharmacySalesReturn']['discount'];
				$directReturnData['payment_mode'] = $this->request->data['InventoryPharmacySalesReturn']['payment_mode'];
				
				if($this->Session->read('locationid')=='25'|| $this->Session->read('locationid')=='26'){
				$directReturnData['bill_code'] = $this->InventoryPharmacySalesReturn->generateSalesReturnBillNoForKanpur($this->Session->read('locationid'));
				}else{
				$directReturnData['bill_code'] = $this->InventoryPharmacySalesReturn->generateReturnBillNo($this->Session->read('locationid'));
				}
				$this->InventoryPharmacySalesReturn->create();
				$this->InventoryPharmacySalesReturn->save($directReturnData);
			
			
				if(!empty($errors)) {
					$this->set("errors", $errors);
				} else {
						
					$this->InventoryPharmacySalesReturnsDetail->saveSaleReturn($this->request->data,$this->InventoryPharmacySalesReturn->id);
					$this->Session->setFlash(__('The Sale Return Details has been saved', true));
				
					$get_last_insertID = $this->InventoryPharmacySalesReturn->getLastInsertId();
					if($this->request->data['print']){
						$url = Router::url(array("controller" => "pharmacy", "action" => "inventory_print_view",'InventoryPharmacyDirectSalesReturnsDetail',$this->InventoryPharmacySalesReturn->id,'inventory'=>true));
					
						echo "<script>window.open('".$url."','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true )</script>";
					}else{
						$this->redirect(array("controller" => "pharmacy", "action" => "direct_sales_return" ,'?'=>array('print'=>'print','id'=>$get_last_insertID),'inventory'=>true));
					}
				}
			}
		}
		
		
		/** END OF DIRECT RETURN */
		public function admin_pharmacy_current_stock_reports(){
			$this->uses = array('PharmacyItem','PharmacyItemRate');
			if(!empty($this->request->data)){ 
				$conditions = array();
				if($this->request->data['PharmacySale']['empty_stock'] == 0){ 
					$conditions[] = array('OR'=>array('PharmacyItemRate.stock > 0','PharmacyItemRate.loose_stock > 0'));
				}
				if($this->request->data['PharmacySale']['expired_product'] == 0){
					$conditions[] = array('PharmacyItemRate.expiry_date > '=>date("Y-m-d"));
				} 
				$this->PharmacyItem->unbindModel(array('hasMany'=>array('InventoryPurchaseItemDetail')));
				$result = $this->PharmacyItem->find('all',array(
							'fields'=>array('PharmacyItem.name','PharmacyItem.pack','PharmacyItemRate.batch_number','PharmacyItemRate.purchase_price','PharmacyItemRate.sale_price','PharmacyItemRate.mrp','PharmacyItemRate.expiry_date','PharmacyItemRate.stock','PharmacyItemRate.loose_stock','((PharmacyItemRate.stock * PharmacyItem.pack) + PharmacyItemRate.loose_stock) as total_stock'),
							'conditions'=>array('PharmacyItem.is_deleted'=>0,'PharmacyItem.drug_id IS NOT NULL','PharmacyItemRate.is_deleted'=>0,$conditions)));
				$this->set(compact('result'));  
				if($this->request->data['PharmacySale']['format'] == "EXCEL"){
					$this->layout = false;
					$this->render('pharmacy_current_stock_report_xls');
				}else{
				
				}
			}
		}
		
		public function inventory_autocomplete_pharmacy_items(){
			
			$this->layout = false;
			$this->autoRender = false;
			
			$searchKey = $this->params->query['term'];
			$conditions["PharmacyItem.name LIKE"] = $searchKey."%";
			$conditions["PharmacyItem.is_deleted"] ='0';
			
			$this->PharmacyItem->recursive = -1;
			$items = $this->PharmacyItem->find('all', array('fields'=> array('PharmacyItem.id','PharmacyItem.pack','PharmacyItem.name','PharmacyItem.item_code'),'conditions'=>$conditions,'limit'=>15/*,'group' => 'PharmacyItem.item_code'*/));
			foreach ($items as $key=>$value) { 
				$output[] = array('id'=>$value['PharmacyItem']['id'],'pack'=>$value['PharmacyItem']['pack'],'value'=>$value['PharmacyItem']['name'],'item_code'=>$value['PharmacyItem']['item_code']);
			}
			echo json_encode($output);
			exit;//dont remove this
		}

		
		public function updatePharmacyItemStock($item_id){
			if(empty($item_id)){
				return false;
			}
			$this->uses = array('PharmacyItem','PharmacyItemRate');
			$this->layout = false;
			$this->autoRender = false;
			
			$result = $this->PharmacyItemRate->find('first',array('fields'=>array('SUM(PharmacyItemRate.stock) as totalStock',
							'SUM(PharmacyItemRate.loose_stock) as totalLooseStock','PharmacyItem.pack'),'conditions'=>array('PharmacyItemRate.item_id'=>$item_id)));
			$pack = $result['PharmacyItem']['pack'];
			$wholeStockinMSU = ($result[0]['totalStock'] * $pack) + $result[0]['totalLooseStock'];
			
			$saveData['stock'] = floor($wholeStockinMSU/$pack);
			$saveData['loose_stock'] = floor($wholeStockinMSU%$pack);
			
			$this->PharmacyItem->id = $item_id;
			if($this->PharmacyItem->save($saveData)){
				$this->PharmacyItem->id = '';
				return true;
			}
		}
		// To check if nurse prescribed Sales bill id Completed or not
		function checkSalesBillIsDone($patient_id,$batchId){
		
			$newCropData = $this->NewCropPrescription->find('all',array('conditions'=>array( 'patient_uniqueid'=>$patient_id,
					'batch_identifier'=>$batchId,'pharmacy_sales_bill_id NOT'=>0)));
			//debug('hi');exit;
			$arrayForStatus = array();
			$arrayCompleted = 0;
			$arrayNotCompleted = 0;
			foreach($newCropData as $newCropkey =>$newCropValue){
					
				if($newCropValue['NewCropPrescription']['status'] == 2){
					$arrayForStatus = $arrayCompleted++;				// Sales bill is completed
				}else{
					$arrayForStatus = $arrayNotCompleted++;				// if Sales bill is not completed
				}
			}
		
			if($arrayCompleted >0 && $arrayNotCompleted == 0){ /** All having status 2- Completed */
				//$this->Session->setFlash(__('Record added for - <b>'.$id['Person']['patient_uid']."</b>",true),'default',array('class'=>'stillSuccess','id'=>'stillFlashMessage'),'still');
				$this->Session->setFlash(__('<b> The sales bill has been done by another user!</b> Please select another Patient', true),array('class'=>'stillSuccess','id'=>'stillFlashMessage'),'still');
				$this->redirect(array("controller" => "Nursings", "action" => "add_prescription",'inventory'=>false));
				exit;
			}
		
		}
		//EOF nursing data
               
                
    //function to check whether the amount is greater than 1/3rd of package amount
    public function checkPharmacySalesWithPackageAmount($patientId){
        $this->uses = array('Patient','Message','ServiceBill');
        $packageAmount = $this->ServiceBill->getRgjayPackageAmount($patientId);
        //$patientObj = new PatientsController();
        //$packageAmt = $patientObj->getPatientPackageAmount($patientId);
        //$soldAmount = $this->getPharmacySalesCost($patientId) ;
        $oneThirdofPackage = $packageAmount/3;
        if($soldAmount >= $oneThirdofPackage){
			/*******BOF Mahalaxmi-For Send Sms to Owner,Administrator as well as vinod only*******/	          
            //The pharmacy amount for this patient exceed the 1/3rd of package amount
			$getEnableFeatureChk=$this->Session->read('sms_feature_chk');
	 		if($getEnableFeatureChk){
				$getPatientDetails=$this->Patient->getPatientDetails($patientId);			
				$showExceedPackMsg= sprintf(Configure::read('pharmacy_exceed_msg'),$getPatientDetails['Patient']['lookup_name'],$oneThirdofPackage,Configure::read('hosp_details'));
				//$this->Message->sendToSms($showExceedPackMsg,Configure::read('pharmacy_exceed_mobile_no')); //for Surgery allot for patient to send sms owner
			}
			/*******EOF Mahalaxmi-For Send Sms to Owner,Administrator as well as vinod only*******/	
        }else{
            return false;
        }
    }
    
    public function getPharmacySalesCost($patientId){
        $this->uses = array('PharmacySalesBill');
        $salesData = $this->PharmacySalesBill->find('first',array(
            'fields'=>array('SUM(PharmacySalesBill.total)- SUM(PharmacySalesBill.discount) as total'),
            'conditions'=>array('PharmacySalesBill.patient_id'=>$patientId,'PharmacySalesBill.is_deleted'=>'0')
        ));
        return $salesData;
    }
    
    //function to get the total purchase amount of total sales product of patient to trigger alert sms to admin by Swapnil - 12.11.2015
    public function getPharmacySumOfPurchasePriceOfSales($patientId){ 
        $this->uses = array('Patient','Message','PharmacySalesBillDetail','PharmacyItemRate','PharmacySalesBill');
        $salesBillIds = $this->PharmacySalesBill->find('list',array('conditions'=>array('PharmacySalesBill.is_deleted'=>'0','PharmacySalesBill.patient_id'=>$patientId)));
        $this->PharmacySalesBillDetail->unbindModel(array('belongsTo'=>array('PharmacySalesBill')));
        $this->PharmacySalesBillDetail->bindModel(array(
            'belongsTo'=>array(
                'PharmacyItemRate'=>array(
                    'foreignKey'=>false,
                    'conditions'=>array(
                        'PharmacySalesBillDetail.item_id = PharmacyItemRate.item_id',
                        'PharmacySalesBillDetail.batch_number = PharmacyItemRate.batch_number'
                    )
                )
            )
        )); 
        $salesData = $this->PharmacySalesBillDetail->find('all',array(
            'fields'=>array('PharmacyItem.name','PharmacySalesBillDetail.*','PharmacyItemRate.*'),
            'conditions'=>array('PharmacySalesBillDetail.pharmacy_sales_bill_id'=>$salesBillIds)));
        $paidAmount = $this->getPharmacyTotalPaid($patientId); 
        foreach($salesData as $keys => $vals){
            $packOFproduct = (int)$vals['PharmacySalesBillDetail']['pack']; 
            $price = (float)$vals['PharmacySalesBillDetail']['mrp']; 
            $qty = $vals['PharmacySalesBillDetail']['qty']; 
            $purchase_price = ($vals['PharmacyItemRate']['purchase_price']/$packOFproduct)*$qty;
            $totalPurchasePrice += $purchase_price;
            $mrp_price = ($price/$packOFproduct)*$qty;
            $totalMrp += $mrp_price;
            //to get the purchase amount from paidAmount
            if($totalMrp<=$paidAmount){
                $setPaidPurchaseAmount += $purchase_price;
            }
        } 
        //return $totalPurchasePrice; 
        //return ($totalPurchasePrice - $setPaidPurchaseAmount);  
        return (array('total'=>$totalPurchasePrice,'paid'=>$setPaidPurchaseAmount));  
    }
    
    //function to get the pharmacy total paid amount - total return amount by Swapnil - 21.11.2015
    public function getPharmacyTotalPaid($patientId){
        $this->uses = array('ServiceCategory', 'Billing','InventoryPharmacySalesReturn');
        $payment_category = $this->ServiceCategory->getPharmacyId();  

        //total Paid
        $paid = $this->Billing->find('first', array('fields' => array('SUM(Billing.amount) as total', 'SUM(Billing.discount) as discount', 'SUM(Billing.paid_to_patient) as refund'),
            'conditions' => array('Billing.patient_id' => $patientId, 'Billing.is_deleted' => 0,
                'Billing.payment_category' => $payment_category)));
        //total Return
        $this->InventoryPharmacySalesReturn->hasMany = array();
        $returnList  = $this->InventoryPharmacySalesReturn->find('first',array('fields'=>array('SUM(InventoryPharmacySalesReturn.total) as total','SUM(InventoryPharmacySalesReturn.discount) as discount'),
                        'conditions'=>array('InventoryPharmacySalesReturn.is_deleted'=>'0','InventoryPharmacySalesReturn.patient_id'=> $patientId)));
  
        return ($paid[0]['total'] - $returnList[0]['total']);
    }
    
    //function to get the total purchase amount of total sales product of patient to trigger alert sms to admin by Swapnil - 12.11.2015
    public function getPharmacySumOfPurchasePriceOfAllSales($from,$to){ 
        $this->uses = array('Patient','PharmacySalesBillDetail','PharmacyItemRate','PharmacySalesBill');
        
        $this->loadModel('TariffStandard');   
        $tariffCond['Patient.tariff_standard_id'] = $this->TariffStandard->getTariffStandardID('RGJAY');
        
        $this->PharmacySalesBill->hasMany = array();
        $this->PharmacySalesBill->belongsTo = array();
        
        $this->PharmacySalesBill->bindModel(array('belongsTo'=>array(
                'Patient'=>array(
                        'foreignKey'=>false,
                        'type'=>'inner',
                        'conditions'=>array('PharmacySalesBill.patient_id = Patient.id')
                )
        )),false);    
        
        $salesBillData = $this->PharmacySalesBill->find('all',array(
            'fields'=>array('PharmacySalesBill.id,PharmacySalesBill.patient_id'),
            'conditions'=>array('PharmacySalesBill.is_deleted'=>'0',$tariffCond,
                'PharmacySalesBill.create_time <=' => $to, 'PharmacySalesBill.create_time >=' => $from)));
        
       foreach($salesBillData as $key => $val){
            $salesBillIds[] = $val['PharmacySalesBill']['id'];
            $patientIds[] = $val['PharmacySalesBill']['patient_id'];
        } 
        
        $this->loadModel('PharmacySalesBillDetail');
        $this->PharmacySalesBillDetail->unbindModel(array('belongsTo'=>array('PharmacySalesBill')));
        $this->PharmacySalesBillDetail->bindModel(array(
            'belongsTo'=>array(
                'PharmacyItemRate'=>array(
                    'foreignKey'=>false,
                    'conditions'=>array(
                        'PharmacySalesBillDetail.item_id = PharmacyItemRate.item_id',
                        'PharmacySalesBillDetail.batch_number = PharmacyItemRate.batch_number'
                    )
                )
            )
        )); 
        
        $salesData = $this->PharmacySalesBillDetail->find('all',array(
            'fields'=>array('PharmacyItem.name',
                'PharmacySalesBillDetail.id, PharmacySalesBillDetail.pack, PharmacySalesBillDetail.mrp, PharmacySalesBillDetail.qty',
                'PharmacyItemRate.id, PharmacyItemRate.purchase_price'),
            'conditions'=>array('PharmacySalesBillDetail.pharmacy_sales_bill_id'=>$salesBillIds)));
        
        $paidAmount = 0;
        foreach(array_unique($patientIds) as $pKey => $pVal){ 
            $paidAmount += $this->getPharmacyTotalPaid($pVal);
        }
         
        foreach($salesData as $keys => $vals){
            $packOFproduct = (int)$vals['PharmacySalesBillDetail']['pack']; 
            $price = (float)$vals['PharmacySalesBillDetail']['mrp']; 
            $qty = $vals['PharmacySalesBillDetail']['qty']; 
            $purchase_price = ($vals['PharmacyItemRate']['purchase_price']/$packOFproduct)*$qty;
            $totalPurchasePrice += $purchase_price;
            $mrp_price = ($price/$packOFproduct)*$qty;
            $totalMrp += $mrp_price;
            //to get the purchase amount from paidAmount
            if($totalMrp<=$paidAmount){
                $setPaidPurchaseAmount += $purchase_price;
            }
        }  
        return (array('total'=>$totalPurchasePrice,'paid'=>$setPaidPurchaseAmount));    
    }
    
    public function getMedication(){ 
        $this->layout = "ajax";
        if(!empty($this->request->data)){
            debug($this->request->data);
        }
    }
    
    public function treatmentSheet($patientId=null,$date=null){
    	$this->layout = "advance";
    	$this->set('title_for_layout', __('-Treatment Sheet', true));
    	$this->uses = array('Patient','TreatmentMedication','TreatmentMedicationDetail','PharmacyItem','PharmacyDuplicateSalesBill','PharmacyDuplicateSalesBillDetail');
    	if(!empty($patientId)){
    		$patientData = $this->Patient->find('first',array(
    				'fields'=>array('Patient.id, Patient.lookup_name, Patient.patient_id, Patient.patient_id, Patient.admission_type,
                     Patient.admission_id, Patient.form_received_on, Patient.doctor_id, Patient.discharge_date, Patient.tariff_standard_id'),
    				'conditions'=>array('id'=>$patientId,'is_deleted'=>'0')));
    		if(!empty($patientData)){
    			$toDate = date("Y-m-d");
    			if(!empty($patientData['Patient']['discharge_date'])){
    				$toDate = $patientData['Patient']['discharge_date'];
    			}
    			$dateListing = $this->GetDays(date("Y-m-d",strtotime($patientData['Patient']['form_received_on'])),$toDate);
    			$this->set('dateListing',$dateListing);
    			$this->set('patientData',$patientData);
    		}
    	} 
		
    	if(!empty($this->request->data)){
    		$this->request->data['patient_id'] = $patientId;
    		$this->request->data['record_date'] = $date; 
    		$treatmentMedicationId = $this->TreatmentMedication->saveRecord($this->request->data);
    		/*if($treatmentMedicationId){
    			//create duplicate sales bill
    			$this->request->data['create_time'] = $date.date(" H:i:s");
    			//$this->request->data['create_time'] = date('Y-m-d H:i:s');
    			$this->request->data['doctor_id'] = $patientData['Patient']['doctor_id'];
    			$this->request->data['payment_mode'] = "Credit";
    			$this->request->data['is_treatment'] = "1";
    			$this->request->data['location_id'] = $this->Session->read('locationid');
    			$this->request->data['created_by'] = $this->Session->read('userid');
    			$this->request->data['bill_code']  =  $this->PharmacyDuplicateSalesBill->generateSalesBillNo();
    			$this->PharmacyDuplicateSalesBill->save($this->request->data);
    			$lastID = $this->PharmacyDuplicateSalesBill->id;
    			$saved = false;
    			$total = 0;
    			foreach($this->request->data['TreatmentMedicationDetail'] as $key => $value){
    				$value['qty_type'] = "Tab";
    				$value['sale_price'] = $value['mrp'];
    				$value['qty'] = $value['quantity'];
    				$value['pharmacy_duplicate_sales_bill_id'] = $lastID;
    				$pack = $value['pack'];
    				$total += (($value['mrp']/$pack)*$value['quantity']);
    				if($this->PharmacyDuplicateSalesBillDetail->saveAll($value)){
    					$saved = true;
    				}
    			}
    			 
    			if($saved == true){
    				//update total in PharmacyDuplicateSalesBill
    				$this->PharmacyDuplicateSalesBill->id = $lastID;
    				$this->PharmacyDuplicateSalesBill->saveField('total',round($total,2));
    
    				//update pharmacy sale bill id in TreatmentMedication
    				$this->TreatmentMedication->id = $treatmentMedicationId;
    				$this->TreatmentMedication->saveField('duplicate_pharmacy_sale_bill_id',$lastID);
    
    				$this->Session->setFlash(__('Record Saved Successfully', true));
    				$this->redirect(array('action'=>'treatmentSheet',$patientId,$date));
    			}
    		}*/
                $this->Session->setFlash(__('Record Saved Successfully', true));
                $this->redirect(array('action'=>'treatmentSheet',$patientId,$date));

    	}
    
    
    	if(!empty($patientId) && !empty($date)){
    		$this->TreatmentMedicationDetail->bindModel(array(
    				'belongsTo'=>array(
    						'TreatmentMedication'=>array(
    								'foreignKey'=>false,
    								'type'=>'inner',
    								'conditions'=>array(
    										'TreatmentMedicationDetail.treatment_medication_id = TreatmentMedication.id'
    								)
    						),
    						'PharmacyItem'=>array(
    								'foreignKey'=>false,
    								'type'=>'inner',
    								'conditions'=>array(
    										'TreatmentMedicationDetail.item_id = PharmacyItem.id'
    								)
    						)
    				)
    		),false);
    
    		$treatmentData = $this->TreatmentMedicationDetail->find('all',array(
    				'fields'=>array('TreatmentMedication.id, TreatmentMedication.duplicate_pharmacy_sale_bill_id','TreatmentMedicationDetail.item_id, TreatmentMedicationDetail.quantity, TreatmentMedicationDetail.routes, TreatmentMedicationDetail.dosage, TreatmentMedicationDetail.is_show',
    						'PharmacyItem.name'),
    				'conditions'=>array('TreatmentMedication.record_date'=>$date,'TreatmentMedication.patient_id'=>$patientId,'TreatmentMedication.is_deleted'=>'0','TreatmentMedicationDetail.is_show'=>'1')));
    
			 
    		foreach($treatmentData as $key => $val){  
				$temp[$val['TreatmentMedicationDetail']['item_id']]['quantity'] = $val['TreatmentMedicationDetail']['quantity'] + $temp[$val['TreatmentMedicationDetail']['item_id']]['quantity'];
					$treatData[$val['TreatmentMedicationDetail']['item_id']] = $val; 
					$treatData[$val['TreatmentMedicationDetail']['item_id']]['TreatmentMedicationDetail']['quantity'] = $temp[$val['TreatmentMedicationDetail']['item_id']]['quantity'];
    		}
			
			$salesBillIds = $this->TreatmentMedication->find('list',array('fields'=>array('id','duplicate_pharmacy_sale_bill_id'),'conditions'=>array('TreatmentMedication.record_date'=>$date,'TreatmentMedication.patient_id'=>$patientId)));

    		$this->PharmacyDuplicateSalesBill->hasMany = array();
    		$salesData = $this->PharmacyDuplicateSalesBill->find('all',array('fields'=>array('PharmacyDuplicateSalesBill.id, PharmacyDuplicateSalesBill.patient_id,
            			PharmacyDuplicateSalesBill.doctor_id, PharmacyDuplicateSalesBill.total, PharmacyDuplicateSalesBill.payment_mode, PharmacyDuplicateSalesBill.bill_code,
            		PharmacyDuplicateSalesBill.create_time'),
    				'conditions'=>array('PharmacyDuplicateSalesBill.id'=>array_unique($salesBillIds))));
    		$this->set('saleBillData',$salesData);
    		$this->set('treatmentData',$treatData); 
    	}
    }
    
    
    function GetDays($first, $last, $step = '+1 day', $output_format = 'd/m/Y' ) {
    	$dates = array();
    	$current = strtotime($first);
    	$last = strtotime($last);
    	while( $current <= $last ) {
    		$dates[date("Y-m-d ",$current)] = date($output_format, $current);
    		$current = strtotime($step, $current);
    	}
    	return $dates;
    }
    
    public function print_sheet($patientId=null,$date=null/*$treatmentMedicationID*/){
    	$this->layout = "advance_ajax";
    	if(empty($patientId) || empty($date)){
    		$this->Session->setFlash(__('Something went wrong, please try again'),'default',array('class'=>'error'));
    	}
    	$this->uses = array('TreatmentMedication','Patient','TreatmentMedicationDetail','DoctorProfile');
    	$treatmentData = $this->TreatmentMedication->read('patient_id',$treatmentMedicationID);
    	$this->Patient->bindModel(array(
            'belongsTo'=>array(
                'DoctorProfile'=>array(
                    'foreignKey'=>false,
                    'conditions'=>array('DoctorProfile.user_id = Patient.doctor_id')
                )
            )
        ));
    	$patientData = $this->Patient->find('first',array(
                'fields'=>array('Patient.id, Patient.lookup_name, Patient.patient_id, Patient.patient_id, Patient.admission_type,Patient.dob,Patient.sex,
                 Patient.admission_id, Patient.form_received_on, Patient.doctor_id, Patient.discharge_date, Patient.tariff_standard_id',
                    'DoctorProfile.doctor_name'),
                'conditions'=>array('Patient.id'=>$patientId,'Patient.is_deleted'=>'0')));
    	
        $this->loadModel('Patient');
        list($age) = explode(" ",$this->Patient->getCurrentAge($patientData['Patient']['dob']));
        $patientData['Patient']['age'] = $age;
        $this->set('patientData',$patientData); 
    	 
		
		if(!empty($patientId) && !empty($date)){
    		$this->TreatmentMedicationDetail->bindModel(array(
    				'belongsTo'=>array(
    						'TreatmentMedication'=>array(
    								'foreignKey'=>false,
    								'type'=>'inner',
    								'conditions'=>array(
    										'TreatmentMedicationDetail.treatment_medication_id = TreatmentMedication.id'
    								)
    						),
    						'PharmacyItem'=>array(
    								'foreignKey'=>false,
    								'type'=>'inner',
    								'conditions'=>array(
    										'TreatmentMedicationDetail.item_id = PharmacyItem.id'
    								)
    						)
    				)
    		),false);
    
    		$treatmentData = $this->TreatmentMedicationDetail->find('all',array(
    				'fields'=>array('TreatmentMedication.id, TreatmentMedication.duplicate_pharmacy_sale_bill_id','TreatmentMedicationDetail.item_id, TreatmentMedicationDetail.quantity, TreatmentMedicationDetail.routes, TreatmentMedicationDetail.dosage, TreatmentMedicationDetail.is_show',
    						'PharmacyItem.name'),
    				'conditions'=>array('TreatmentMedication.record_date'=>$date,'TreatmentMedication.patient_id'=>$patientId,'TreatmentMedication.is_deleted'=>'0','TreatmentMedicationDetail.is_show'=>'1')));
    
			
    		foreach($treatmentData as $key => $val){ 
				 
                    $temp[$val['TreatmentMedicationDetail']['item_id']]['quantity'] = $val['TreatmentMedicationDetail']['quantity'] + $temp[$val['TreatmentMedicationDetail']['item_id']]['quantity'];
                    $treatData[$val['TreatmentMedicationDetail']['item_id']] = $val; 
                    $treatData[$val['TreatmentMedicationDetail']['item_id']]['TreatmentMedicationDetail']['quantity'] = $temp[$val['TreatmentMedicationDetail']['item_id']]['quantity'];
				 
    		} 
    		$this->set('treatmentData',$treatData); 
    	}
    }

    public function deleteTreatmentSheet($patientId,$date){
    	$this->layout = "ajax";
    	$this->autoRender = false;
		if(empty($patientId) || empty($date))  $return = "false"; 
		$this->uses = array('TreatmentMedication');
		if($this->TreatmentMedication->updateAll(array('is_deleted'=>'1'),array('patient_id'=>$patientId,'record_date'=>$date))) {
			$return = "true";
		}
		echo ($return);
    }
    
    //function to set the add invoice
    public function setIsAddChargesInInvoice($duplicateSaleBillId, $status){
        $this->layout = "ajax";
        $this->autoRender = false;
        $this->loadModel('PharmacyDuplicateSalesBill');
        $this->PharmacyDuplicateSalesBill->id = $duplicateSaleBillId;
        if($this->PharmacyDuplicateSalesBill->saveField('add_charges_in_invoice',$status)){
            echo "true";
        }
    }
    
    /*
     * function to edit the treatment sheet
     * @author : Swapnil
     * @created : 19.03.2016
     */
    public function editTreatmentSheetAjax($saleBillId){
        $this->layout = "ajax";
        $this->uses = array('TreatmentMedicationDetail','TreatmentMedication','PharmacyItem');
        $this->TreatmentMedicationDetail->bindModel(array(
            'belongsTo'=>array(
                'TreatmentMedication'=>array(
                    'foreignKey'=>'treatment_medication_id'
                ),
                'PharmacyItem'=>array(
                    'foreignKey'=>'item_id'
                )
            )
        ));
        $results = $this->TreatmentMedicationDetail->find('all',array(
            'fields'=>array(
                'PharmacyItem.name',
                'TreatmentMedication.patient_id, TreatmentMedication.record_date',
                'TreatmentMedicationDetail.id, TreatmentMedicationDetail.is_show, TreatmentMedicationDetail.routes, TreatmentMedicationDetail.dosage'
            ),
            'conditions'=>array(
                'TreatmentMedication.duplicate_pharmacy_sale_bill_id'=>$saleBillId
            )
        )); 
        $patientId = $results[0]['TreatmentMedication']['patient_id'];
        $date = $results[0]['TreatmentMedication']['record_date'];
        $this->set(compact(array('results','patientId','date')));
    }
    
    /*
     * function to edit the treatment sheet
     * @author : Swapnil
     * @created : 19.03.2016
     */
    public function updateTreatmentSheet($patientID,$date){
        $this->autoRender = false;
        $this->uses = array('TreatmentMedicationDetail','TreatmentMedication','PharmacyItem');
        //$this->loadModel('TreatmentMedicationDetail');
        if($this->request->data){
            foreach($this->request->data['TreatmentMedicationDetail'] as $key => $val){
                if(!empty($val['id'])){
                    $val['is_show'] = $val['is_show']=='1'?$val['is_show']:'0';
                    $this->TreatmentMedicationDetail->id = $val['id'];
                    $this->TreatmentMedicationDetail->saveAll($val); 
                }
            } 
        }
        $this->redirect(array('action'=>'treatmentSheet',$patientID,$date));
    }

    //to update opening stock in pharmacy item from item stock
	public function updateOpeningStock(){
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->uses = array("PharmacyItem");
		
		$pharmacyData = $this->PharmacyItem->find('all',array('fields'=>array('PharmacyItem.id','PharmacyItem.stock','PharmacyItem.opening_stock','PharmacyItem.loose_stock','PharmacyItem.pack')));
		$count = 0;
		//$msg = '';
		foreach ($pharmacyData as $key => $val) {
		    $this->PharmacyItem->id = $val['PharmacyItem']['id'];
		    $msu = ($val['PharmacyItem']['pack']*$val['PharmacyItem']['stock'])+$val['PharmacyItem']['loose_stock'];
			if($this->PharmacyItem->updateAll(array('PharmacyItem.opening_stock'=>$msu),array('PharmacyItem.id'=>$val['PharmacyItem']['id']))){
				$count++;
			}
		}
		//echo $msg;
		echo "successfully updated $count stock";
	}// END of updateOpeningStock
	
	function dailyTreatmentSheet($patientId){
    	$this->layout = 'print_with_header';
    	$this->uses = array('Patient','PharmacySalesBillDetail','PatientCovidPackage');
    	//$patientId = '554730';

    	$patientData=$this->Patient->find('first',array('fields'=>array('Patient.id','Patient.person_id','Patient.age','Patient.sex','Patient.dob','Patient.lookup_name','Patient.patient_id','Patient.admission_id','Patient.admission_type','Patient.form_received_on'),'conditions'=>array('Patient.id'=>$patientId)));


    	$this->PharmacySalesBillDetail->bindModel(array(
					'belongsTo' => array(
						'PharmacySalesBill' => array('foreignKey' => false,
															'conditions'=> array("PharmacySalesBill.id = PharmacySalesBillDetail.pharmacy_sales_bill_id")),
															
						'User' => array('foreignKey' => false,
															'conditions'=> array("User.id = PharmacySalesBill.doctor_id")),
						
						'PharmacyItem' => array('foreignKey' => false,
															'conditions'=> array("PharmacySalesBillDetail.item_id = PharmacyItem.id")),
				)));

    	$pharmacy_sale_detail = $this->PharmacySalesBillDetail->find("all",array('fields'=>array('PharmacySalesBill.id','PharmacySalesBill.create_time','PharmacySalesBill.bill_code','PharmacyItem.id','PharmacyItem.name','PharmacySalesBillDetail.id','PharmacySalesBillDetail.qty','User.first_name','User.last_name','PharmacySalesBillDetail.administration_time'),"conditions"=>array('PharmacySalesBill.patient_id' =>$patientId,'PharmacySalesBill.is_deleted' =>'0'),'group'=>array('PharmacySalesBillDetail.id')));


    	$packageList = $this->PatientCovidPackage->find('all',array('fields'=>array('package_cost','package_start_date','package_end_date'),'conditions'=>array('PatientCovidPackage.patient_id'=>$patientId),'order'=>array('PatientCovidPackage.create_time'=>'DESC')));

    	#debug($packageList);
    	
    	foreach ($pharmacy_sale_detail as $key => $value) {
    		$explodeDate = explode(" ", $value['PharmacySalesBill']['create_time']);
    		$date = $explodeDate[0];
    		$dailyTreatment[$date][] = $value ;
    	}

    	$packageDates = array();
    	foreach ($packageList as $key => $value) {
			$packageDates[$value['PatientCovidPackage']['package_cost']]['package_start_date'] =  $value['PatientCovidPackage']['package_start_date'];
			$packageDates[$value['PatientCovidPackage']['package_cost']]['package_end_date'] =  $value['PatientCovidPackage']['package_end_date'];
		
		}

    	
    	$this->set(array('dailyTreatment'=>$dailyTreatment,'patientData'=>$patientData,'packageDates'=>$packageDates));
    }

    //edit sales bill by Atul (Basically new function created for permission purpose)
	public function inventory_copy_sales_bill($patient_id = null,$requisitionType=null,$billId=null,$batchId=null) {
		$this->inventory_sales_bill($patient_id,$requisitionType,$billId,$batchId);
		$this->render('inventory_sales_bill');
	}
}
