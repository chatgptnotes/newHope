<?php
/**
 * This is roles controller file.
 *
 * Use to create/edit/view/delete roles
 * created : 16 Nov
 */
class InventoryCategoriesController extends AppController {

	public $name = 'InventoryCategories';
	public $uses = array('InventoryCategory');
	public $helpers = array('Html','Form', 'Js','General');
	public $components = array('RequestHandler','Email','General');


	/***
	 @Action: Admin_index
	@access : Public
	@created : 1/18/2012
	@modified:
	***/

	public function admin_index(){
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'InventoryCategory.name' => 'asc'
				)
		);
		$this->set('title_for_layout', __('Manage Category', true));
		$this->InventoryCategory->bindModel(array(
				'belongsTo' => array(
						'User' =>array(
								'fields'=>'User.first_name,User.last_name',
								'foreignKey'=>'created_by',

						)
				)));
		$data = $this->paginate('InventoryCategory');
		//pr($data);exit;
		$this->set('data', $data);
	}

	/***
	 @Action: admin_add
	@access : Public
	@created : 1/18/2012
	@modified:
	***/

	public function admin_add(){

		$this->set('title_for_layout', __('Add Category', true));

		if (!empty($this->request->data)) {
			// check if the category already exists
			$old_data = $this->InventoryCategory->find('count',array('conditions'=>array('name'=>$this->request->data['InventoryCategory']['name'] ) ));
			if($old_data){

				$this->Session->setFlash(__('This Inventory Category is already exist.'),'default',array('class'=>'error'));
				return false;
				$this->redirect(array('action'=>'add'));
			}
			// change date to sql format
			$this->request->data["InventoryCategory"]["created"] = date("Y-m-d H:i:s");
			$this->request->data["InventoryCategory"]["modified"] = date("Y-m-d H:i:s");
			// Get the user creating the category
			$this->request->data["InventoryCategory"]["created_by"] = $this->Session->read('userid');
			$this->request->data["InventoryCategory"]["modified_by"] = $this->Session->read('userid');
			// pr($this->request->data);exit;
			$this->InventoryCategory->create();
			// Save Here
			$this->InventoryCategory->save($this->request->data);

			$errors = $this->InventoryCategory->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('Inventory Category has been added successfully'),'default',array('class'=>'message'));
				$this->redirect(array("controller" => "inventory_categories", "action" => "index", "admin" => true));
			}
		}

	}

	/***
	 @Action: admin_edit
	@access : Public
	@created : 1/18/2012
	@modified:
	***/

	public function admin_edit($id=null){

		$this->set('title_for_layout', __('Edit Category', true));
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid InventoryCategory'),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'index'));
		}

		if (!empty($this->data)) {
			// check if the category already exists
			$old_data = $this->InventoryCategory->find('count',array('conditions'=>array('name'=>$this->request->data['InventoryCategory']['name'],'id !=' =>$this->request->data["InventoryCategory"]['id']) ));
			if($old_data){

				$this->Session->setFlash(__('This InventoryCategory is already exist.'),'default',array('class'=>'error'));
				$this->redirect(array('action'=>'edit',$this->request->data['InventoryCategory']['id']));
				//$this->redirect(array('action'=>'add'));
			}

			// change date to sql format
			$this->request->data["InventoryCategory"]["modified"] = date("Y-m-d H:i:s");
			// Modified entry by
			$this->request->data["InventoryCategory"]["modified_by"] = $this->Session->read('userid');

			// Save Here
			if ($this->InventoryCategory->save($this->data)) {
				$this->Session->setFlash(__('Inventory Category has been update successfully'),'default',array('class'=>'message'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Inventory Category could not be saved. Please, try again.'),'default',array('class'=>'error'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->InventoryCategory->read(null, $id);
		}
		$this->set('id', $id);

	}

	/***
	 @Action: admin_delete
	@access : Public
	@created : 1/18/2012
	@modified:
	***/

	public function admin_delete($id=null){

		$this->set('title_for_layout', __('- Delete Category', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Inventory Category'),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->InventoryCategory->delete($id)) {
			$this->Session->setFlash(__('Inventory Category deleted successfully'),'default',array('class'=>'message'));
			$this->redirect(array('action'=>'index'));
		}

	}
	
	
	
	public function store_requisition($formID = null,$print = false,$view = false,$status = "Requesting"){ 
		$this->layout='advance';
		if($this->params->pass[4] == 1){
			$this->layout = 'advance_ajax' ;
		}
		$this->uses = array('StoreRequisition','OtPharmacyItem',"Department","Ward","Opt","Chamber","User",'StoreRequisitionParticular','Product','StoreLocation');
		
		$allStores = $this->StoreLocation->find('list',array('conditions'=>array('StoreLocation.is_deleted' => '0'),
															'fields'=>array('id','code_name')));
		
		if((strTolower($this->Session->read('role_code_name'))==strTolower(Configure::read('pharmacyCode')))){
			$identifyRole =  Configure::read('pharmacyCode');
		    $this->set('identifyRole',$identifyRole);
		}
		
		if($this->request->is('post') || $this->request->is('put')){
			//debug($this->request->data); exit;
		$data=$this->InventoryCategory->findRequisitionCodeName($this->request->data['StoreRequisition']['requisition_for_name']);

		/* if(strtolower($this->request->data['StoreRequisition']['requisition_for_name'])==strTolower(Configure::read('Pharmacy'))) */
			if(strtolower($data['StoreLocation']['code_name'])==strTolower(Configure::read('pharmacyCode')))
				$requisitionFrom = Configure::read('pharmacyCode');
			else if(strtolower($data['StoreLocation']['code_name'])==strTolower(Configure::read('otpharmacycode'))) 
				$requisitionFrom = Configure::read('otpharmacycode');
			
			if($requisitionFrom == Configure::read('otpharmacycode')){
				$otLocationId = $this->StoreLocation->find('first',
						array('conditions'=>array('StoreLocation.is_deleted' =>'0','StoreLocation.code_name' => Configure::read('otpharmacycode'),'StoreLocation.role_id LIKE'=>'%'.$roleId.'%')),
						array('fields'=>array('StoreLocation.id')));
				$this->request->data['StoreRequisition']['requisition_for'] = $otLocationId['StoreLocation']['id'];
				
			}else if($requisitionFrom == Configure::read('pharmacyCode')){
				$pharmaDepart = $this->StoreLocation->find('first',
						array('conditions'=>array('StoreLocation.is_deleted' =>'0','StoreLocation.code_name' => Configure::read('pharmacyCode'),'StoreLocation.role_id LIKE'=>'%'.$roleId.'%')),
						array('fields'=>array('StoreLocation.id')));		
						
				$this->request->data['StoreRequisition']['requisition_for'] = $pharmaDepart['StoreLocation']['id'];
			}else{
				if($this->request->data['StoreRequisition']['requisition_for_name'] == "other"){
					$this->request->data['StoreRequisition']['requister_id'] =  $this->request->data['StoreRequisition']['other'];
				}else if($this->request->data['StoreRequisition']['requisition_for_name'] == "OT"){
					$this->request->data['StoreRequisition']['requister_id'] =  $this->request->data['StoreRequisition']['ot'];
				}else if($this->request->data['StoreRequisition']['requisition_for_name'] == "Chamber"){
					$this->request->data['StoreRequisition']['requister_id'] =  $this->request->data['StoreRequisition']['chamber'];
				}else{
					$this->request->data['StoreRequisition']['requister_id'] =  $this->request->data['StoreRequisition']['ward'];
				}
				$this->request->data['StoreRequisition']['requisition_for'] =  $this->request->data['StoreRequisition']['requisition_for'];
			}
			
			if($formID == null){ 
				$this->request->data['StoreRequisition']['created_time'] = date('Y-m-d h:i:s');
				$this->request->data['StoreRequisition']['created_by'] = $this->Session->read('userid');
				$this->request->data['StoreRequisition']['location_id'] = $this->Session->read('locationid');
			}
			if($formID != null){
				$this->StoreRequisition->id = $formID;
				$this->request->data['StoreRequisition']['updated_time'] = date('Y-m-d h:i:s');
				$this->request->data['StoreRequisition']['updated_by'] = $this->Session->read('userid');
				if(isset($this->request->data['status'])){
					$status=$this->request->data['status'];
					$this->request->data['StoreRequisition']['status'] = $this->request->data['status'];
				}
			}
			
			if(!empty($this->request->data['StoreRequisition']['issue_date'])){
				$this->request->data['StoreRequisition']['entered_date'] = $this->DateFormat->formatDate2STD($this->request->data['StoreRequisition']['entered_date'],Configure::read('date_format'));
			}
			if(!empty($this->request->data['StoreRequisition']['req_expiry'])){
				$this->request->data['StoreRequisition']['requisition_expiry_date'] = $this->DateFormat->formatDate2STDForReport($this->request->data['StoreRequisition']['req_expiry'],Configure::read('date_format'));
			}
			if(!empty($this->request->data['StoreRequisition']['requisition_date'])){
				$this->request->data['StoreRequisition']['requisition_date'] = $this->DateFormat->formatDate2STD($this->request->data['StoreRequisition']['requisition_date'],Configure::read('date_format'));
			}
			if(!empty($this->request->data['StoreRequisition']['issue_date'])){
				$this->request->data['StoreRequisition']['issue_date'] = $this->DateFormat->formatDate2STD($this->request->data['StoreRequisition']['issue_date'],Configure::read('date_format'));
			}
			if(!empty($this->request->data['StoreRequisition']['entered_date'])){
				$this->request->data['StoreRequisition']['entered_date'] = $this->DateFormat->formatDate2STD($this->request->data['StoreRequisition']['entered_date'],Configure::read('date_format'));
			}
			
			$this->StoreRequisition->save($this->request->data);
			$errors=$this->StoreRequisitionParticular->invalidFields();

			if(!empty($formID)){
				$lastId=$formID;
			}else{
				$lastId=$this->StoreRequisition->getLastInsertID();	//To get the latest inserted Id
			}
			if(!empty($errors)){
				$this->set("errors", $errors);
			}else{
				if($this->StoreRequisitionParticular->saveParticulars($this->request->data['StoreRequisition']['slip_detail'],$lastId,$status)){
					
					$this->Session->setFlash(__('Requisition added successfully!'),'default',array('class'=>'message'));
					//Pharmacy Store requisition
					$this->redirect(array('action'=>'store_requisition','?'=>array('storeId'=>$lastId))); 
				}else{
					if(!empty($this->StoreRequisitionParticular->error)){
						$this->Session->setFlash(__($this->StoreRequisitionParticular->error, true),'default',array('class'=>'error'));
					}else{
						$errors=$this->StoreRequisitionParticular->invalidFields();
						if(!empty($errors)){
							$this->set("errors", $errors);
						}
					}
					if($formID != null){
						$this->redirect(array('action'=>'store_requisition',$formID));
					}else{
						$this->redirect(array('action'=>'store_requisition'));
					}				
				}
			}
		} 
		
		$apamId = array_search(Configure::read("apamCode"), $allStores);
		$otPharId = array_search(Configure::read("otpharmacycode"), $allStores); 
		$this->set(compact('apamId','otPharId')); 
		
		if($this->params->query['list']){	//by swapnil to send request from current stock page  05.04.2015
			
			$to = $this->params->query['to'];
			$from = $this->params->query['from'];
			
			$prodIds = explode("-",$this->params->query['list']);
			$this->Product->bindModel(array('hasMany'=>array('ProductRate'=>array('foreignKey'=>'product_id','fields'=>array('ProductRate.id','ProductRate.sale_price')))));
			$prodData = $this->Product->find('all',array('conditions'=>array('Product.id'=>$prodIds)));
 			
			//debug($prodData);
			if($from == $otPharId){
				$otData = $this->OtPharmacyItem->find('all',array('conditions'=>array('OtPharmacyItem.product_id'=>$prodIds),
							'fields'=>array(/* 'sum(OtPharmacyItem.reorder_level - OtPharmacyItem.stock) as qty', */'OtPharmacyItem.*')));
			
				foreach ($otData as $key => $data){ 
					if($data['OtPharmacyItem']['reorder_level'] != $data['OtPharmacyItem']['stock']){
						$prodData[$key]['Product']['req_quantity'] = $data['OtPharmacyItem']['reorder_level'] - $data['OtPharmacyItem']['stock'];
					}else{
						unset($prodData[$key]);
					} 
				}
			} 
			
			//fetch only last sale_price from product rates list
			foreach($prodData as $key=>$data){
				foreach($data['ProductRate'] as $rateKey => $rateVal){
					$prodData[$key]['ProductRate'] = $rateVal;
				} 
			}  
			//debug($prodData);
			$this->set('to',$to);
			$this->set('from',$from);
			$this->set('itemData',$prodData);
		}
		//store locations selecting role wise
		if($this->Session->read('website.instance') == "hope"){
			$centralStoreDepart = $this->StoreLocation->find('list',
					array('conditions'=>array('StoreLocation.is_deleted' =>'0','StoreLocation.code_name'=>array(Configure::read("pharmacyCode")))),
					array('fields'=>array('StoreLocation.id','StoreLocation.name')));
		}else{
			$centralStoreDepart = $this->StoreLocation->find('list',
				array('conditions'=>array('StoreLocation.is_deleted' =>'0','StoreLocation.code_name'=>array(Configure::read("centralStoreCode"),Configure::read("apamCode")))),
				array('fields'=>array('StoreLocation.id','StoreLocation.name')));
		}
		/* if($this->params->query['pharmacy']){
			$roleId=$this->Session->read('roleid');

			$this->set('department',$this->StoreLocation->find('list',
					array('conditions' => array('StoreLocation.is_deleted' =>'0','StoreLocation.role_id LIKE'=>'%'.$roleId.'%'))));
					
			/*$this->set('department',$this->StoreLocation->find('list',
					array('conditions' => array('StoreLocation.is_deleted' =>'0','StoreLocation.role_id LIKE'=>'%'.$roleId.'%'))));*/ //commented by swapnil
			
			/* $pharmaDepart = $this->StoreLocation->find('first',
					array('conditions'=>array('StoreLocation.is_deleted' =>'0','StoreLocation.name' => Configure::read('Pharmacy'),'StoreLocation.role_id LIKE'=>'%'.$roleId.'%')),
					array('fields'=>array('StoreLocation.id'))); */
			
			/*$centralStoreDepart = $this->StoreLocation->find('list',
				array('conditions'=>array('StoreLocation.is_deleted' =>'0','StoreLocation.code_name'=>Configure::read("centralStoreCode"))),
				array('fields'=>array('StoreLocation.id','StoreLocation.name')));
				
			$this->set('pharmaDepart',$pharmaDepart['StoreLocation']['id']);
			
			
		}else { */ 
				
		$roleId = $this->Session->read('roleid'); 
		//by swapnil 16.03.2015
		$mylocations = $this->StoreLocation->find('all',array('fields'=>array('id','name','role_id'),'conditions' => array('StoreLocation.is_deleted' =>'0',
				'StoreLocation.is_consumable' =>'0')));
		
		$returnArray = array();
		foreach($mylocations as $dept){ 
			$deptRolesArray = explode("|",$dept['StoreLocation']['role_id']); 
			if(in_array($roleId,$deptRolesArray)){
				$returnArray[$dept['StoreLocation']['id']] = $dept['StoreLocation']['name'];
			}
		} 
		/*$this->set('department',$this->StoreLocation->find('list',
				array('conditions' => array('StoreLocation.is_deleted' =>'0','StoreLocation.role_id LIKE'=>'%'.$roleId.'%'))));*/
		$this->set('department',$returnArray);
		//}
		
		$this->set('centralStoreDepart',$centralStoreDepart);
		$this->set('wards',$this->Ward->find('list',
				array('conditions' => array('Ward.is_deleted' => 0, 'Ward.location_id' =>
						$this->Session->read("locationid")))));
		$this->set('ot',$this->Opt->find('list',
				array('conditions' => array('Opt.is_deleted' => 0, 'Opt.location_id' =>
						$this->Session->read("locationid")))));
		$this->set('chambers',$this->Chamber->find('list',
				array('conditions' => array('Chamber.is_deleted' => 0, 'Chamber.location_id' =>
						$this->Session->read("locationid")))));
		$centralStore = $this->StoreLocation->find('first',
					array('conditions'=>array('StoreLocation.is_deleted' =>'0','StoreLocation.name' => Configure::read('centralStore'),'StoreLocation.role_id LIKE'=>'%'.$roleId.'%')),
					array('fields'=>array('StoreLocation.id')));
		$this->set('centralId',$centralStore['StoreLocation']['id']);
		
		if($formID!=null){
			
			$StoreRequisition = $this->StoreRequisition->read(null,$formID);  
			
			$storeLocation = $this->StoreLocation->find('first',array('conditions'=>array('StoreLocation.id'=>$StoreRequisition['StoreRequisition']['requisition_for'])));
			//Requisition To
			$requisitionTo = $this->StoreLocation->find('first',array('conditions'=>array('StoreLocation.id'=>$StoreRequisition['StoreRequisition']['store_location_id'])));
				
			//pharmacy
			if(strtolower($requisitionTo['StoreLocation']['code_name']) == strtolower(Configure::read('pharmacyCode')) ){
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
						'conditions'=>array('StoreRequisitionParticular.store_requisition_detail_id'=>$formID),
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
			
			$this->StoreRequisitionParticular->unbindModel(array('belongsTo'=>array('PurchaseOrderItem')));	//by swapnil
			$this->StoreRequisitionParticular->bindModel(array(
				'belongsTo'=>array(
						'ProductRate'=>array(
							'foreignKey'=>false,
							'conditions'=>array('StoreRequisitionParticular.item_id = ProductRate.product_id')),
						)),false);		
							
			$storeDetails= $this->StoreRequisitionParticular->find('all',array('fields'=>array('Product.*','ProductRate.*',/*'PurchaseOrderItem.batch_number',
					'PurchaseOrderItem.expiry_date','PurchaseOrderItem.id','PurchaseOrderItem.stock_available',*/'StoreRequisitionParticular.*'),
					'conditions'=>array('StoreRequisitionParticular.store_requisition_detail_id'=>$formID),'group'=>array('StoreRequisitionParticular.id')));
			}
			
			$storeLocation=$this->StoreLocation->find('first',array('conditions'=>array('StoreLocation.id'=>$StoreRequisition['StoreRequisition']['requisition_for'])));
			$status=$StoreRequisition['StoreRequisition']['status'];
			$req_by=$this->User->find('first',array('field'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id'=>$StoreRequisition['StoreRequisition']['requisition_by'])));
			$req_by_name=$req_by['User']['first_name'].' '.$req_by['User']['last_name'];
			$issue_by=$this->User->find('first',array('field'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id'=>$StoreRequisition['StoreRequisition']['issue_by'])));
			$issue_by_name=$issue_by['User']['first_name'].' '.$issue_by['User']['last_name'];
			$entered_by=$this->User->find('first',array('field'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id'=>$StoreRequisition['StoreRequisition']['entered_by'])));
			$entered_by_name=$entered_by['User']['first_name'].' '.$entered_by['User']['last_name'];
			$this->set(array('entered_by_name'=>$entered_by_name,'issue_by_name'=>$issue_by_name,'req_by_name'=>$req_by_name ));
			$this->set('requestedTo',$StoreRequisition['StoreRequisition']['store_location_id']);	//by swapnil
			$toRequisLoc=$this->StoreLocation->find('first',array('fields'=>array('id','name'),'conditions'=>array('StoreLocation.id'=>$StoreRequisition['StoreRequisition']['store_location_id'])));
			$this->set('toRequisLoc',$toRequisLoc);
			 
			$requsition_for='';
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
			if(!empty($requsition_for))
				$data['for'] =  $requsition_for;
			else{
				$data['for']=$StoreRequisition['StoreRequisition']['requisition_for'];
				$requsition_for=$storeLocation['StoreLocation']['name'];
			}  
			$this->set("StoreRequisition",$StoreRequisition);
			$this->set("storeDetails",$storeDetails);
			$this->set('storeLocation',$storeLocation);
			$this->set("requisition_for",$requsition_for);
			
			if($print !=false && $status != "Requesting"){
				/*for pharmacy Print*/
				
				$this->layout = "print_with_header";
				$this->render('requisition_after_issue_print');
				//$this->render('store_requisition_print');
				/*EOPrint*/
			}else if($view !=false){
				if($status=='Returned'){
					//Only when the Product is returned
				$StoreRequisition = $this->StoreRequisition->read(null,$formID);
				$storeLocation = $this->StoreLocation->find('first',array('conditions'=>array('StoreLocation.id'=>$StoreRequisition['StoreRequisition']['requisition_for'])));
				$requisitionTo = $this->StoreLocation->find('first',array('conditions'=>array('StoreLocation.id'=>$StoreRequisition['StoreRequisition']['store_location_id'])));
				//debug($StoreRequisition);
						
					$storeDetails= $this->StoreRequisitionParticular->find('all',array('fields'=>array('Product.quantity','Product.name','StoreRequisitionParticular.*'),
							'conditions'=>array('StoreRequisitionParticular.store_requisition_detail_id'=>$formID,'StoreRequisitionParticular.is_denied'=>'0'),
							'group'=>array('StoreRequisitionParticular.id')));
					
					$this->set("storeDetails",$storeDetails);
					$this->layout=false;
					$this->render('store_requisition_edit_returned');
				}else{
					$this->layout=false;
					$this->render('store_requisition_view');
					/*End of view*/
				}
				
			}else{
				switch($status){
					case "Requesting": 
						 if($this->params->query['pharmacy']){
							$this->render('store_requisition_edit');
						}else{ 
						   $this->layout = "print_with_header";
							$this->render('requisition_before_issue_print');
						}
				 	break;
					case "Returned":
						$this->render('store_requisition_edit_returned');
						break;
						/* case "Approved":
				 		$this->render('store_requisition_edit_approved');
				 	break;*/
					case "Issued":
						$this->render('store_requisition_edit_issued');
				 	break;
				}
			}
		}
		
		$this->set(array('reqFirstName'=>$this->Session->read('first_name'),'reqLastName'=>$this->Session->read('last_name'),'reqId'=>$this->Session->read('userid')));
	}
	
	
	
	
	
	
	
	public function store_requisition_status_approved($formID = null,$status = "Requesting"){

		$this->uses = array('StoreRequisition',"PatientCentricDepartment","Ward","Opt","Chamber");


		if($formID!=null){
			$StoreRequisition = $this->StoreRequisition->read(null,$formID);
			$requsition_for='';
			if($StoreRequisition['StoreRequisition']['requisition_for'] == "other"){
				$this->LoadModel("PatientCentricDepartment");
				$for = $this->PatientCentricDepartment->read(null,$StoreRequisition['StoreRequisition']['requister_id']);
				$requsition_for =$for['PatientCentricDepartment']['name'];
			}else if($StoreRequisition['StoreRequisition']['requisition_for'] == "ot"){
				$for = $this->Opt->read(null,$StoreRequisition['StoreRequisition']['requister_id']);
				$requsition_for =$for['Opt']['name'];
			}else if($StoreRequisition['StoreRequisition']['requisition_for'] == "chamber"){
				$this->LoadModel("Chamber");
				$for = $this->Chamber->read(null,$StoreRequisition['StoreRequisition']['requister_id']);
				$requsition_for =$for['Chamber']['name'];
			}else{
				$this->LoadModel("Ward");
				$for = $this->Ward->read(null,$StoreRequisition['StoreRequisition']['requister_id']);
				$requsition_for =$for['Ward']['name'];

			}
			$data['for'] =  $requsition_for;
			$this->set("StoreRequisition",$StoreRequisition);
			$this->set("requisition_for",$requsition_for);
			$this->render('store_requisition_edit_approved');

		}

	}
	public function store_requisition_status_issued($formID = null,$status = "Requesting"){

		$this->uses = array('StoreRequisition',"PatientCentricDepartment","Ward","Opt","Chamber");

		if($formID!=null){
			$StoreRequisition = $this->StoreRequisition->read(null,$formID);
			$requsition_for='';
			if($StoreRequisition['StoreRequisition']['requisition_for'] == "other"){
				$this->LoadModel("PatientCentricDepartment");
				$for = $this->PatientCentricDepartment->read(null,$StoreRequisition['StoreRequisition']['requister_id']);
				$requsition_for =$for['PatientCentricDepartment']['name'];
			}else if($StoreRequisition['StoreRequisition']['requisition_for'] == "ot"){
				$for = $this->Opt->read(null,$StoreRequisition['StoreRequisition']['requister_id']);
				$requsition_for =$for['Opt']['name'];
			}else if($StoreRequisition['StoreRequisition']['requisition_for'] == "chamber"){
				$this->LoadModel("Chamber");
				$for = $this->Chamber->read(null,$StoreRequisition['StoreRequisition']['requister_id']);
				$requsition_for =$for['Chamber']['name'];
			}else{
				$this->LoadModel("Ward");
				$for = $this->Ward->read(null,$StoreRequisition['StoreRequisition']['requister_id']);
				$requsition_for =$for['Ward']['name'];

			}
			$data['for'] =  $requsition_for;
			$this->set("StoreRequisition",$StoreRequisition);
			$this->set("requisition_for",$requsition_for);
			$this->render('store_requisition_edit_issued');

		}

	}
	public function store_requisition_list(){
		$this->uses = array('StoreRequisition','User');
		$conditions = array();
		
		//cond added by pankaj w 
		if($this->Session->read('role')==Configure::read('storemanager') || $this->Session->read('role')==Configure::read('admin')){
			$conditions   = array();
		}else{
			//$conditions['requisition_by'] = $this->Session->read('userid');
		}
		//EOF pankaj w 
		 
		if(!empty($this->request->query))
		{
			$this->request->data = $this->request->query;
			if(!empty($this->request->data['from'])) {
				$fromDate = $this->DateFormat->formatDate2STDForReport($this->request->data['from'],Configure::read('date_format'))." 00:00:00";
				$conditions['StoreRequisition.requisition_date >=']=$fromDate;
			} 
			
			if(!empty($this->request->data['to'])) {
				$toDate = $this->DateFormat->formatDate2STDForReport($this->request->data['to'],Configure::read('date_format'))." 23:59:59";
				$conditions['StoreRequisition.requisition_date <=']=$toDate; 
			} 
			
			if(!empty($this->request->data['status'])) {
				$status = $this->request->data['status'];
				$conditions['StoreRequisition.status'] = $status;
			}
		}else{
			$conditions['StoreRequisition.requisition_date LIKE']= date('Y-m-d')."%";	//for current date
		}
		
		$this->StoreRequisition->bindModel(array('belongsTo'=>array(
				'StoreLocation'=>array('foreignKey'=>false,'conditions'=>array('StoreLocation.id=StoreRequisition.store_location_id')),
				"StoreLocationAlias"=>array('className'=>'StoreLocation',"foreignKey"=>false,'conditions'=>array('StoreLocationAlias.id=StoreRequisition.requisition_for'))
		)));

		 
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('StoreRequisition.effective_from' => 'asc'
				),
				'conditions'=>array($conditions,"StoreRequisition.is_deleted"=>'0'/*,"StoreRequisition.location_id"=>$this->Session->read('locationid')*/)
				//location id cond commented by pankaj as it not required for now.
		);
    
		$data = $this->paginate('StoreRequisition'); 
		
		foreach($data as $key=>$value){	
			$requsition_for='';
		if($value['StoreLocationAlias']['name'] == "Other"){
				$this->LoadModel("PatientCentricDepartment");
				$for = $this->PatientCentricDepartment->read(null,$value['StoreRequisition']['requister_id']);
				$requsition_for =$for['PatientCentricDepartment']['name'];
			}else if($value['StoreLocationAlias']['name'] == "OT"){
				//$for = $this->Opt->read(null,$value['StoreRequisition']['requister_id']);
				//$requsition_for =$for['Opt']['name'];
			}else if($value['StoreLocationAlias']['name'] == "Chamber"){
				$this->LoadModel("Chamber");
				$for = $this->Chamber->read(null,$value['StoreRequisition']['requister_id']);
				$requsition_for =$for['Chamber']['name'];
			}else if($value['StoreLocationAlias']['name'] == "Ward"){							
				$this->LoadModel("Ward");
				$for = $this->Ward->read(null,$value['StoreRequisition']['requister_id']);
				$requsition_for =$for['Ward']['name'];
			}
			if(!empty($requsition_for))
			$data[$key]['StoreRequisition']['for'] =$requsition_for;
			
			$requistion_by=$this->User->find('first',array('fields'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id'=>$value['StoreRequisition']['requisition_by'])));
			$data[$key]['StoreRequisition']['requested_by']=$requistion_by['User']['first_name'].' '.$requistion_by['User']['last_name'];
		}
		$this->set('data', $data);
		
	}

	public function search(){

		$this->set('data','');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'Patient.id' => 'asc'
				)
		);

		$role = $this->Session->read('role');

		//Search patient as per the url request
		if(!empty($this->params->query['type'])){
			if(strtolower($this->params->query['type'])=='emergency'){
				$search_key['Patient.admission_type'] = "IPD";
				$search_key['Patient.is_emergency'] = "1";
			}else if($this->params->query['type']=='IPD'){
				$search_key['Patient.admission_type'] = $this->params->query['type'];
				$search_key['Patient.is_emergency'] = "0";
			}else{
				$search_key['Patient.admission_type'] = $this->params->query['type'];
			}
		}
		if(!empty($this->params->query['dept_id'])){
			$search_key['Patient.department_id'] = $this->params->query['dept_id'];
		}
		if($this->params->query['patientstatus']=='discharged' || $this->params->query['patientstatus']=='processed') {
			$search_key['Patient.is_discharge'] = 1;//display only non-discharge patient
		} else {
			$search_key['Patient.is_discharge'] = 0;//display only non-discharge patient
		}
		//EOF patient search as per category

		$search_key['Patient.is_deleted'] = 0;

		if(($role == 'admin') ){

			$search_key['Patient.location_id']=$this->Session->read('locationid');

			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
							'Initial' =>array('foreignKey' => false,'conditions'=>array('User.initial_id=Initial.id' )),
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
							'Location' =>array('foreignKey' => 'location_id')
					)),false);
		}else if($role==Configure::read('doctorLabel')){
			$search_key['Patient.location_id']=$this->Session->read('locationid');
			$search_key['Patient.doctor_id']=$this->Session->read('userid');
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
							'Initial' =>array('foreignKey' => false,'conditions'=>array('User.initial_id=Initial.id' )),
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
					)),false);
		}

		// Anand's Code //
		// If Search is for emergency patient
		if(isset($this->params['named']['searchFor']) AND $this->params['named']['searchFor'] == 'emergency'){
			// Condition is here
			$conditions = array($search_key,'Patient.is_discharge'=>0,'Patient.admission_type'=>'IPD','Patient.is_emergency'=>1);

		} else {
			// If patient is OPD
			if(!empty($this->params->query)){
				$search_ele = $this->params->query  ;//make it get
				if(!empty($search_ele['lookup_name'])){
					$search_key['Patient.lookup_name like '] = "%".trim($search_ele['lookup_name'])."%" ;
				}if(!empty($search_ele['patient_id'])){
					$search_key['Patient.patient_id like '] = "%".trim($search_ele['patient_id']) ;
				}if(!empty($search_ele['admission_id'])){
					$search_key['Patient.admission_id like '] = "%".trim($search_ele['admission_id']) ;
				}
				// Condition is here
				$conditions = $search_key;
			}else{
				// For IPD patient
				// Condition is here
				$conditions = array($search_key,'Patient.is_discharge'=>0,'Patient.admission_type'=>'IPD');
			}

		}
		// Paginate Data here

		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Patient.id' => 'desc'),
				'fields'=> array('Patient.form_received_on,Patient.form_received_on,Patient.discharge_date,CONCAT(PatientInitial.name," ",Patient.lookup_name) as lookup_name,
						Patient.id,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, User.initial_id, Patient.create_time, Initial.name'),
				'conditions'=>$conditions
		);

		$this->set('data',$this->paginate('Patient'));
		//EOF Anand's Code //
	}
	function store_inbox_requistion_list(){

		$this->uses = array('StoreRequisition','User','StoreLocation');  

		
		$this->StoreRequisition->bindModel(array('belongsTo'=>array(
				'StoreLocation'=>array('foreignKey'=>false,'conditions'=>array('StoreLocation.id=StoreRequisition.store_location_id')),
				 "StoreLocationAlias"=>array('className'=>'StoreLocation',"foreignKey"=>false,'conditions'=>array('StoreLocationAlias.id=StoreRequisition.requisition_for')) 
		))); 
		
		$this->request->data['StoreRequisition'] = $this->request->query;  //by swapnil 25.03.2015
		//cond added by pankaj w
		if($this->request->data['StoreRequisition']['status']!=""){
			$conditions['StoreRequisition.status']=  $this->request->data['StoreRequisition']['status'];
		}
		
		if($this->request->data['StoreRequisition']['store_location_id']!=""){
			$conditions['StoreRequisition.requisition_for']=  $this->request->data['StoreRequisition']['store_location_id'];
		} 
		if($this->Session->read('role_code_name')==Configure::read('storemanager') || $this->Session->read('role')==Configure::read('admin')){ 
				$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'StoreRequisition.requisition_date' => 'desc' 
				),
				'conditions'=>array($conditions,"StoreRequisition.is_deleted"=>'0'/*"StoreRequisition.location_id"=>$this->Session->read('locationid'),'StoreRequisition.store_location_id'=>$storeId*/)
		);
		  }else{
		  	//by swapnil 18.03.2015
		  	$roleId=$this->Session->read('roleid');	
		  	$mylocations = $this->StoreLocation->find('all',array('fields'=>array('id','name','role_id'),'conditions' => array('StoreLocation.is_deleted' =>'0')));
			$storeId = array();
			foreach($mylocations as $dept){ 
				$deptRolesArray = explode("|",$dept['StoreLocation']['role_id']); 
				if(in_array($roleId,$deptRolesArray)){
					$storeId[] = $dept['StoreLocation']['id'];
				}
			}  
			//$storeId=$this->StoreLocation->find('list',array('fields'=>array('id'),'conditions'=>array('StoreLocation.role_id LIKE'=>'%'.$this->Session->read('roleid').'%')));
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array(
							'StoreRequisition.requisition_date' => 'desc'
					),
					'conditions'=>array($conditions,'StoreRequisition.requisition_for'=>$storeId, "StoreRequisition.is_deleted"=>'0'/*"StoreRequisition.location_id"=>$this->Session->read('locationid'),'StoreRequisition.store_location_id'=>$storeId*/)
			);
		}  
		
		$data = $this->paginate('StoreRequisition'); 
		foreach($data as $key=>$value){ 
			/*if($value['StoreRequisition']['requisition_for'] == "other"){
				$this->LoadModel("PatientCentricDepartment");
				$for = $this->PatientCentricDepartment->read(null,$value['StoreRequisition']['requister_id']);
				$requsition_for =$for['PatientCentricDepartment']['name'];
			}else if($value['StoreRequisition']['requisition_for'] == "ot"){
				$this->LoadModel("Opt");
				$for = $this->Opt->read(null,$value['StoreRequisition']['requister_id']);
				$requsition_for =$for['Opt']['name'];
			}else if($value['StoreRequisition']['requisition_for'] == "chamber"){
				$this->LoadModel("Chamber");
				$for = $this->Chamber->read(null,$value['StoreRequisition']['requister_id']);
				$requsition_for =$for['Chamber']['name'];
			}else{
				$this->LoadModel("Ward");
				$for = $this->Ward->read(null,$value['StoreRequisition']['requister_id']);
				$requsition_for =$for['Ward']['name'];

			}
			$data[$key]['StoreRequisition']['for'] =$requsition_for;
			$requistion_by=$this->User->find('first',array('fields'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id'=>$value['StoreRequisition']['requisition_by'])));
			$data[$key]['StoreRequisition']['requested_by']=$requistion_by['User']['first_name'].' '.$requistion_by['User']['last_name'];
		*/
			
			$requsition_for='';
			if($value['StoreLocationAlias']['name'] == "Other"){
				$this->LoadModel("PatientCentricDepartment");
				$for = $this->PatientCentricDepartment->read(null,$value['StoreRequisition']['requister_id']);
				$requsition_for =$for['PatientCentricDepartment']['name'];
			}else if($value['StoreLocationAlias']['name'] == "OT"){
				//$for = $this->Opt->read(null,$value['StoreRequisition']['requister_id']);
				$requsition_for =$for['Opt']['name'];
			}else if($value['StoreLocationAlias']['name'] == "Chamber"){
				$this->LoadModel("Chamber");
				$for = $this->Chamber->read(null,$value['StoreRequisition']['requister_id']);
				$requsition_for =$for['Chamber']['name'];
			}else if($value['StoreLocationAlias']['name'] == "Ward"){
				$this->LoadModel("Ward");
				$for = $this->Ward->read(null,$value['StoreRequisition']['requister_id']);
				$requsition_for =$for['Ward']['name'];
			}
			
			if(!empty($requsition_for))
				$data[$key]['StoreRequisition']['for'] =$requsition_for;
				
			$requistion_by=$this->User->find('first',array('fields'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id'=>$value['StoreRequisition']['requisition_by'])));
			$data[$key]['StoreRequisition']['requested_by']=$requistion_by['User']['first_name'].' '.$requistion_by['User']['last_name'];
			
		}
		
		$this->set('data', $data); 
		$this->set('storeLoc',$this->StoreLocation->find('list',array('fields'=>array('id','name'),'conditions'=>array('StoreLocation.is_deleted'=>'0'))));
		
		
	}
	
		public function stock_requisition($formID = null,$print = false,$view = false,$status = "Requesting"){	
			if($this->params->pass[4] == 1){
				$this->layout ='advance_ajax';
			}
			$this->layout='advance';
			
			$this->uses = array('PharmacyItem','Location','StoreRequisition',"Department","Ward","Opt","Chamber","User",'StoreRequisitionParticular','Product','StoreLocation');
			$accessableLocation = $this->Location->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_deleted'=>0,'is_active'=>1)));
			$this->set('accessableLocation',$accessableLocation);
		
			if((strTolower($this->Session->read('role_code_name'))==strTolower(Configure::read('pharmacyCode')))){
				$identifyRole =  Configure::read('pharmacyCode');
				$this->set('identifyRole',$identifyRole);
			}
			if($this->request->is('post') || $this->request->is('put')){
				
				$data=$this->InventoryCategory->findRequisitionCodeName($this->request->data['StoreRequisition']['requisition_for_name']);
	
				/* if(strtolower($this->request->data['StoreRequisition']['requisition_for_name'])==strTolower(Configure::read('Pharmacy'))) */
				if(strtolower($data['StoreLocation']['code_name'])==strTolower(Configure::read('pharmacyCode')))
					$requisitionFrom = Configure::read('pharmacyCode');
				else if(strtolower($data['StoreLocation']['code_name'])==strTolower(Configure::read('otpharmacycode')))
					$requisitionFrom = Configure::read('otpharmacycode');
					
				if($requisitionFrom == Configure::read('otpharmacycode')){
					$otLocationId = $this->StoreLocation->find('first',
							array('conditions'=>array('StoreLocation.is_deleted' =>'0','StoreLocation.code_name' => Configure::read('otpharmacycode'),'StoreLocation.role_id LIKE'=>'%'.$roleId.'%')),
							array('fields'=>array('StoreLocation.id')));
					//$this->request->data['StoreRequisition']['requisition_for'] = $otLocationId['StoreLocation']['id'];
				}else if($requisitionFrom == Configure::read('pharmacyCode')){
					$pharmaDepart = $this->StoreLocation->find('first',
							array('conditions'=>array('StoreLocation.is_deleted' =>'0','StoreLocation.code_name' => Configure::read('pharmacyCode'),'StoreLocation.role_id LIKE'=>'%'.$roleId.'%')),
							array('fields'=>array('StoreLocation.id')));
		
					//$this->request->data['StoreRequisition']['requisition_for'] = $pharmaDepart['StoreLocation']['id'];
				}else{
					if($this->request->data['StoreRequisition']['requisition_for_name'] == "other"){
						$this->request->data['StoreRequisition']['requister_id'] =  $this->request->data['StoreRequisition']['other'];
					}else if($this->request->data['StoreRequisition']['requisition_for_name'] == "OT"){
						$this->request->data['StoreRequisition']['requister_id'] =  $this->request->data['StoreRequisition']['ot'];
					}else if($this->request->data['StoreRequisition']['requisition_for_name'] == "Chamber"){
						$this->request->data['StoreRequisition']['requister_id'] =  $this->request->data['StoreRequisition']['chamber'];
					}else{
						$this->request->data['StoreRequisition']['requister_id'] =  $this->request->data['StoreRequisition']['ward'];
					}
					$this->request->data['StoreRequisition']['requisition_for'] =  $this->request->data['StoreRequisition']['requisition_for'];
				}
					
				if($formID == null){
					$this->request->data['StoreRequisition']['created_time'] = date('Y-m-d h:i:s');
					$this->request->data['StoreRequisition']['created_by'] = $this->Session->read('userid');
					$this->request->data['StoreRequisition']['location_id'] = $this->Session->read('locationid');
				}
				if($formID != null){
					$this->StoreRequisition->id = $formID;
					$this->request->data['StoreRequisition']['updated_time'] = date('Y-m-d h:i:s');
					$this->request->data['StoreRequisition']['updated_by'] = $this->Session->read('userid');
					if(isset($this->request->data['status'])){
						$status=$this->request->data['status'];
						$this->request->data['StoreRequisition']['status'] = $this->request->data['status'];
					}
				}
					
				if(!empty($this->request->data['StoreRequisition']['issue_date'])){
					$this->request->data['StoreRequisition']['entered_date'] = $this->DateFormat->formatDate2STD($this->request->data['StoreRequisition']['entered_date'],Configure::read('date_format'));
				}
				if(!empty($this->request->data['StoreRequisition']['req_expiry'])){
					$this->request->data['StoreRequisition']['requisition_expiry_date'] = $this->DateFormat->formatDate2STDForReport($this->request->data['StoreRequisition']['req_expiry'],Configure::read('date_format'));
				}
				if(!empty($this->request->data['StoreRequisition']['requisition_date'])){
					$this->request->data['StoreRequisition']['requisition_date'] = $this->DateFormat->formatDate2STD($this->request->data['StoreRequisition']['requisition_date'],Configure::read('date_format'));
				}
				if(!empty($this->request->data['StoreRequisition']['issue_date'])){
					$this->request->data['StoreRequisition']['issue_date'] = $this->DateFormat->formatDate2STD($this->request->data['StoreRequisition']['issue_date'],Configure::read('date_format'));
				}
				if(!empty($this->request->data['StoreRequisition']['entered_date'])){
					$this->request->data['StoreRequisition']['entered_date'] = $this->DateFormat->formatDate2STD($this->request->data['StoreRequisition']['entered_date'],Configure::read('date_format'));
				}
				$this->request->data['StoreRequisition']['requisition_by'] =  $this->request->data['StoreRequisition']['location_from_id'];
				
				
				$this->StoreRequisition->save($this->request->data);
				$errors=$this->StoreRequisitionParticular->invalidFields();
	
				if(!empty($formID)){
					$lastId=$formID;
				}else{
					$lastId=$this->StoreRequisition->getLastInsertID();	//To get the latest inserted Id
				}
				if(!empty($errors)){
					$this->set("errors", $errors);
				}else{					
					if($this->StoreRequisitionParticular->saveParticulars($this->request->data['StoreRequisition']['slip_detail'],$lastId,$status)){
							
						$this->Session->setFlash(__('Details saved!'),'default',array('class'=>'message'));
						//Pharmacy Store requisition
						$this->redirect(array('action'=>'stock_requisition_list'));
					}else{
						if(!empty($this->StoreRequisitionParticular->error)){
							$this->Session->setFlash(__($this->StoreRequisitionParticular->error, true),'default',array('class'=>'error'));
						}else{
							$errors=$this->StoreRequisitionParticular->invalidFields();
							if(!empty($errors)){
								$this->set("errors", $errors);
							}
						}
						if($formID != null){
							$this->redirect(array('action'=>'store_requisition',$formID));
						}else{
							$this->redirect(array('action'=>'store_requisition'));
						}
					}
				}
			}
			//store locations selecting role wise
			$centralStoreDepart = $this->StoreLocation->find('list',
					array('conditions'=>array('StoreLocation.is_deleted' =>'0','StoreLocation.code_name'=>Configure::read("centralStoreCode"))),
					array('fields'=>array('StoreLocation.id','StoreLocation.name')));		
			
			$roleId=$this->Session->read('roleid');
	
			$this->set('department',$this->StoreLocation->find('list',
					array('conditions' => array('StoreLocation.is_deleted' =>'0','StoreLocation.role_id LIKE'=>'%'.$roleId.'%'))));
			//}
		
			$this->set('centralStoreDepart',$centralStoreDepart);
			$this->set('wards',$this->Ward->find('list',
					array('conditions' => array('Ward.is_deleted' => 0, 'Ward.location_id' =>
							$this->Session->read("locationid")))));
			$this->set('ot',$this->Opt->find('list',
					array('conditions' => array('Opt.is_deleted' => 0, 'Opt.location_id' =>
							$this->Session->read("locationid")))));
			$this->set('chambers',$this->Chamber->find('list',
					array('conditions' => array('Chamber.is_deleted' => 0, 'Chamber.location_id' =>
							$this->Session->read("locationid")))));
			$centralStore = $this->StoreLocation->find('first',
					array('conditions'=>array('StoreLocation.is_deleted' =>'0','StoreLocation.name' => Configure::read('centralStore'),'StoreLocation.role_id LIKE'=>'%'.$roleId.'%')),
					array('fields'=>array('StoreLocation.id')));
			$this->set('centralId',$centralStore['StoreLocation']['id']);
		
				
			if($formID!=null){
				
				$StoreRequisition = $this->StoreRequisition->read(null,$formID);
				
				//Requisition From
				$storeLocationFrom = $this->Location->find('first',array('fields'=>array('Location.id','Location.name'),'conditions'=>array('Location.id'=>$StoreRequisition['StoreRequisition']['requisition_by'])));
					
				//Requisition To
				$requisitionTo = $this->Location->find('first',array('fields'=>array('Location.id','Location.name'),'conditions'=>array('Location.id'=>$StoreRequisition['StoreRequisition']['requisition_for'])));
				
				//if(strtolower($requisitionTo['StoreLocation']['name']) == strtolower(Configure::read('OT Pharmacy'))){
				$this->StoreRequisitionParticular->unbindModel(array('belongsTo'=>array('Product','PurchaseOrderItem')));
				
				$this->StoreRequisitionParticular->bindModel(array(
						'belongsTo'=>array(
								'PharmacyItem'=>array('foreignKey'=>false,'conditions'=>array('StoreRequisitionParticular.purchase_order_item_id = PharmacyItem.id'/*,'PharmacyItemRate.item_id = PharmacyItem.id'*/,'PharmacyItem.location_id'=>$StoreRequisition['StoreRequisition']['requisition_for'])),
								'PharmacyItemAlias'=>array('foreignKey'=>false,'className'=>'PharmacyItem','conditions'=>array('StoreRequisitionParticular.existing_stock_order_item_id = PharmacyItemAlias.id'/*'PharmacyItemRateAlias.item_id = PharmacyItemAlias.id'*/,'PharmacyItemAlias.location_id'=>$StoreRequisition['StoreRequisition']['requisition_by'])),
					)));
				$storeDetails = $this->StoreRequisitionParticular->find('all',array('conditions'=>array('StoreRequisitionParticular.store_requisition_detail_id'=>$StoreRequisition['StoreRequisition']['id'],'StoreRequisitionParticular.is_deleted'=>0)));
			
				
				/*$storeDetails= $this->StoreRequisitionParticular->find('all',array('fields'=>array('Product.*','PurchaseOrderItem.batch_number',
						'PurchaseOrderItem.expiry_date','PurchaseOrderItem.id','PurchaseOrderItem.stock_available','StoreRequisitionParticular.*'),
						'conditions'=>array('StoreRequisitionParticular.store_requisition_detail_id'=>$formID)));*/
					
				$storeLocation=$this->StoreLocation->find('first',array('conditions'=>array('StoreLocation.id'=>$StoreRequisition['StoreRequisition']['requisition_for'])));
				$status=$StoreRequisition['StoreRequisition']['status'];
				$req_by=$this->User->find('first',array('field'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id'=>$StoreRequisition['StoreRequisition']['created_by'])));
				$req_by_name=$req_by['User']['first_name'].' '.$req_by['User']['last_name'];
				$issue_by=$this->User->find('first',array('field'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id'=>$StoreRequisition['StoreRequisition']['issue_by'])));
				$issue_by_name=$issue_by['User']['first_name'].' '.$issue_by['User']['last_name'];
				$entered_by=$this->User->find('first',array('field'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id'=>$StoreRequisition['StoreRequisition']['entered_by'])));
				$entered_by_name=$entered_by['User']['first_name'].' '.$entered_by['User']['last_name'];
				$this->set(array('entered_by_name'=>$entered_by_name,'issue_by_name'=>$issue_by_name,'req_by_name'=>$req_by_name ));
				$this->set('requestedTo',$StoreRequisition['StoreRequisition']['store_location_id']);	//by swapnil
		
									
				//find to request is sent
				//******Bof-request To*****/
				$requsition_for_location=$this->Location->find('first',array('fields'=>array('Location.name'),'conditions'=>array('Location.id'=>$StoreRequisition['StoreRequisition']['requisition_for'])));
				
				//******Bof-request From*****/
				$requsition_by_location = $this->Location->find('first',array('fields'=>array('Location.name'),'conditions'=>array('Location.id'=>$StoreRequisition['StoreRequisition']['requisition_by'])));
				$this->set('requsition_for_location',$requsition_for_location);
				$this->set('requsition_by_location',$requsition_by_location);
				
		
				$this->set("StoreRequisition",$StoreRequisition);
				$this->set("storeDetails",$storeDetails);
				$this->set('storeLocation',$storeLocation);
				
			
					
				if($print !=false && $status != "Requesting"){
					/*for pharmacy Print*/		
					//$this->layout = "print_with_header";
					$this->layout = 'roman_pharma_header';
					$this->render('stock_requisition_print');
					/*EOPrint*/
				}else if($view !=false){
					if($status=='Returned'){
				
						//Only when the Product is returned
						$StoreRequisition = $this->StoreRequisition->read(null,$formID);
						$storeLocation = $this->StoreLocation->find('first',array('conditions'=>array('StoreLocation.id'=>$StoreRequisition['StoreRequisition']['requisition_for'])));
						$requisitionTo = $this->StoreLocation->find('first',array('conditions'=>array('StoreLocation.id'=>$StoreRequisition['StoreRequisition']['store_location_id'])));
					
		
						$storeDetails= $this->StoreRequisitionParticular->find('all',array('fields'=>array('Product.quantity','Product.name','StoreRequisitionParticular.*'),
								'conditions'=>array('StoreRequisitionParticular.store_requisition_detail_id'=>$formID,'StoreRequisitionParticular.is_denied'=>'0')));
							
						$this->set("storeDetails",$storeDetails);
						$this->render('store_requisition_edit_returned');
					}else{		
						
						$this->layout=false;
						$this->render('stock_requisition_view');
						
						/*End of view*/
					}
		
				}else{
					
					switch($status){
						case "Requesting":														
							$this->render('stock_requisition_edit');
							break;
						case "Returned":
							$this->render('store_requisition_edit_returned');
							break;							
						case "Issued":								
							$this->render('stock_requisition_edit_issued');
							break;
		
					}
				}
			}
		
			$this->set(array('reqFirstName'=>$this->Session->read('first_name'),'reqLastName'=>$this->Session->read('last_name'),'reqId'=>$this->Session->read('userid')));
		
		}
		public function deleteStockRequestList($id=null){
			$this->uses = array('StoreRequisition');
			$this->request->data['StoreRequisition']['is_deleted']=1;
			$this->request->data['StoreRequisition']['id']=$id;
			$this->StoreRequisition->id= $id;
			if($this->StoreRequisition->save($this->request->data['StoreRequisition'])){
				$this->redirect(array("controller" => "InventoryCategories", "action" => "stock_inbox_requistion_list"));
			}
		
		}
		
	public function stock_requisition_list(){
		$this->uses = array('StoreRequisition','User','Location');
		$conditions = array();
		
		//cond added by pankaj w 
		/*if($this->Session->read('role')==Configure::read('storemanager') || $this->Session->read('role')==Configure::read('admin')){
			$conditions   = array();
		}else{
			$conditions['requisition_by'] = $this->Session->read('userid');
		}*/
		//EOF pankaj w 
		 
		if(!empty($this->request->query))
		{
			$this->request->data = $this->request->query;
			if(!empty($this->request->data['from'])) {
				$fromDate = $this->DateFormat->formatDate2STDForReport($this->request->data['from'],Configure::read('date_format'))." 00:00:00";
				//$conditions['StoreRequisition.requisition_date >=']=$fromDate;
			} 
			
			if(!empty($this->request->data['to'])) {
				$toDate = $this->DateFormat->formatDate2STDForReport($this->request->data['to'],Configure::read('date_format'))." 23:59:59";
				//$conditions['StoreRequisition.requisition_date <=']=$toDate; 
			} 
			
			if(!empty($this->request->data['status'])) {
				$status = $this->request->data['status'];
				$conditions['StoreRequisition.status'] = $status;
			}
			$conditions['StoreRequisition.stock_requisition_flag']= '1'; ///From Stock Transfer
		}else{
			//$conditions['StoreRequisition.requisition_date LIKE']= date('Y-m-d')."%";	//for current date
			$conditions['StoreRequisition.stock_requisition_flag']= '1'; ///From Stock Transfer
		}
		$conditions['StoreRequisition.is_deleted']='0';
		$conditions['StoreRequisition.requisition_by']= $this->Session->read("locationid");
		
		$this->StoreRequisition->bindModel(array('belongsTo'=>array(
				'StoreLocation'=>array('foreignKey'=>false,'conditions'=>array('StoreLocation.id=StoreRequisition.store_location_id')),
				"StoreLocationAlias"=>array('className'=>'StoreLocation',"foreignKey"=>false,'conditions'=>array('StoreLocationAlias.id=StoreRequisition.requisition_for'))
		)));

		 
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'StoreRequisition.id' => 'DESC'
				),
				'conditions'=>array($conditions/*,"StoreRequisition.location_id"=>$this->Session->read('locationid')*/)
				//location id cond commented by pankaj as it not required for now.
		);

		$data = $this->paginate('StoreRequisition');
		
		foreach($data as $key=>$value){	
			$requsition_for='';
		if($value['StoreLocationAlias']['name'] == "Other"){
				$this->LoadModel("PatientCentricDepartment");
				$for = $this->PatientCentricDepartment->read(null,$value['StoreRequisition']['requister_id']);
				$requsition_for =$for['PatientCentricDepartment']['name'];
			}else if($value['StoreLocationAlias']['name'] == "OT"){
				$for = $this->Opt->read(null,$value['StoreRequisition']['requister_id']);
				$requsition_for =$for['Opt']['name'];
			}else if($value['StoreLocationAlias']['name'] == "Chamber"){
				$this->LoadModel("Chamber");
				$for = $this->Chamber->read(null,$value['StoreRequisition']['requister_id']);
				$requsition_for =$for['Chamber']['name'];
			}else if($value['StoreLocationAlias']['name'] == "Ward"){							
				$this->LoadModel("Ward");
				$for = $this->Ward->read(null,$value['StoreRequisition']['requister_id']);
				$requsition_for =$for['Ward']['name'];
			}
			$requistion_by=$this->Location->find('first',array('fields'=>array('Location.name'),'conditions'=>array("AND"=>array('Location.id'=>$value['StoreRequisition']['requisition_for'],'Location.id'=>$value['StoreRequisition']['requisition_by']))));
			
			/*if(!empty($requsition_for))
			$data[$key]['StoreRequisition']['for'] =$requsition_for;
			
			$requistion_by=$this->User->find('first',array('fields'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id'=>$value['StoreRequisition']['requisition_by'])));*/
		
			$data[$key]['StoreRequisition']['requested_by']=$requistion_by['Location']['name'];
			$requistion_for=$this->Location->find('first',array('fields'=>array('Location.name'),'conditions'=>array('Location.id'=>$value['StoreRequisition']['requisition_for'])));
			$data[$key]['StoreRequisition']['requested_for']=$requistion_for['Location']['name'];
		}
	
		$this->set('data', $data);
		
	}
	public function recievedStock(){
		$this->uses = array('StoreRequisition','StoreRequisitionParticular','PharmacyItemRate','PharmacyItem','Location');
		
		$StoreRequisition = $this->StoreRequisition->read(null,$this->request->data['id']);
		//Requisition From
		$storeLocationFrom = $this->Location->find('first',array('fields'=>array('Location.id','Location.name'),'conditions'=>array('Location.id'=>$StoreRequisition['StoreRequisition']['requisition_by'])));
		//Requisition To
		$requisitionTo = $this->Location->find('first',array('fields'=>array('Location.id','Location.name'),'conditions'=>array('Location.id'=>$StoreRequisition['StoreRequisition']['requisition_for'])));
		//if(strtolower($requisitionTo['StoreLocation']['name']) == strtolower(Configure::read('OT Pharmacy'))){
		$this->StoreRequisitionParticular->unbindModel(array('belongsTo'=>array('Product','PurchaseOrderItem')));
		
		$this->StoreRequisitionParticular->bindModel(array(
				'belongsTo'=>array(
						/*To*/	'PharmacyItem'=>array('foreignKey'=>false,'conditions'=>array('StoreRequisitionParticular.purchase_order_item_id = PharmacyItem.id','PharmacyItem.location_id'=>$StoreRequisition['StoreRequisition']['requisition_for'])),
						/*From*/ 'PharmacyItemAlias'=>array('foreignKey'=>false,'className'=>'PharmacyItem','conditions'=>array('StoreRequisitionParticular.existing_stock_order_item_id = PharmacyItemAlias.id','PharmacyItemAlias.location_id'=>$StoreRequisition['StoreRequisition']['requisition_by'])),
				),
		));
		$storeDetails = $this->StoreRequisitionParticular->find('all',array('conditions'=>array('StoreRequisitionParticular.store_requisition_detail_id'=>$this->request->data['id'],'StoreRequisitionParticular.is_deleted'=>0)));
		foreach($storeDetails as $key => $value){
			$pharmacyItemToId[]= $value['PharmacyItem']['id'];
			$pharmacyItemToItemName[]= $value['StoreRequisitionParticular']['item_name'];
			$pharmacyItemToBatchId[]= $value['StoreRequisitionParticular']['batch_id'];				
			$storeDetails[$key]['ProductRate']['toId']= $value['PharmacyItem']['id'];				
			$storeDetails[$key]['ProductRate']['FromItemId']= $value['StoreRequisitionParticular']['existing_stock_order_item_id'];
			$storeDetails[$key]['ProductRate']['ToItemId']= $value['StoreRequisitionParticular']['purchase_order_item_id'];
			$storeDetails[$key]['ProductRate']['id']= $value['PharmacyItemAlias']['id'];
			$storeDetails[$key]['ProductRate']['name']= $value['PharmacyItem']['name'];
			$storeDetails[$key]['ProductRate']['stock']= $value['PharmacyItem']['stock']*$value['PharmacyItem']['pack']+$value['PharmacyItem']['loose_stock'];
			$storeDetails[$key]['ProductRate']['stockfrom']= $value['PharmacyItemAlias']['stock']*$value['PharmacyItemAlias']['pack']+$value['PharmacyItemAlias']['loose_stock'];
		}
		
		
		
		$storeRequisitionParticular=$storeDetails;
		$cnt=0;
		$updateArrayPharmacyItemRateFrom1=null;
		$updateArrayPharmacyItemFrom1=null;
		$phramacyItemRateRequestedFrom_location=null;
		$phramacyItemRequestedto_location=null;
		$phramacyItemRateRequestedto_location=null;
		foreach($pharmacyItemToItemName as $keyN=>$pharmacyItemToItemNames){		
			$phramacyItemRequestedto_location=$this->PharmacyItem->find('first', array(
					'fields'=>array('PharmacyItem.id','PharmacyItem.stock','PharmacyItem.loose_stock','PharmacyItem.pack','PharmacyItem.location_id'),
					'conditions'=>array('PharmacyItem.location_id'=>$StoreRequisition['StoreRequisition']['requisition_for'],
							'PharmacyItem.name'=>$pharmacyItemToItemNames)));
				
			$phramacyItemRateRequestedto_location=$this->PharmacyItemRate->find('first', array(
					'fields'=>array('PharmacyItemRate.id','PharmacyItemRate.stock','PharmacyItemRate.loose_stock','PharmacyItemRate.location_id',
							'PharmacyItemRate.batch_number','PharmacyItemRate.expiry_date'),
					'conditions'=>array('PharmacyItemRate.location_id'=>$StoreRequisition['StoreRequisition']['requisition_for'],
							'PharmacyItemRate.id'=>$storeRequisitionParticular[$cnt]['StoreRequisitionParticular']['batch_id'],
							'PharmacyItemRate.item_id'=>$phramacyItemRequestedto_location['PharmacyItem']['id'])));
					
		//debug($StoreRequisition['StoreRequisition']['requisition_by']);
		/********************for location which will fulfill request- Stock needs to be added*********************************/
			
		$phramacyItemRequestedfrom_location=$this->PharmacyItem->find('first', array('fields'=>array('PharmacyItem.id','PharmacyItem.stock','PharmacyItem.loose_stock','PharmacyItem.pack','PharmacyItem.location_id'),
				'conditions'=>array('PharmacyItem.location_id'=>$StoreRequisition['StoreRequisition']['requisition_by'],'PharmacyItem.name'=>$pharmacyItemToItemNames)));
		$totalTabFrom=($phramacyItemRequestedfrom_location['PharmacyItem']['stock']*$phramacyItemRequestedfrom_location['PharmacyItem']['pack'])+$phramacyItemRequestedfrom_location['PharmacyItem']['loose_stock'];
		$stockUpdatedTabFrom=$totalTabFrom+$storeRequisitionParticular[$cnt]['StoreRequisitionParticular']['issued_qty'];
		$stockUpdatedFrom=$stockUpdatedTabFrom/$phramacyItemRequestedfrom_location['PharmacyItem']['pack'];
		$loosestockUpdatedFrom=$stockUpdatedTabFrom%$phramacyItemRequestedfrom_location['PharmacyItem']['pack'];
		//$loosestockUpdatedFrom=floor($loosestockUpdatedFrom);
		$exploStockUpdatedFrom=explode('.',$stockUpdatedFrom);
		//$stockUpdatedFrom=floor($stockUpdatedFrom);
		
		//update request TO location
		
		 $updateArrayPharmacyItemFrom['id']=$phramacyItemRequestedfrom_location['PharmacyItem']['id'];
		 $updateArrayPharmacyItemFrom['stock']=$exploStockUpdatedFrom[0];
		 $updateArrayPharmacyItemFrom['loose_stock']=$loosestockUpdatedFrom;
		$this->PharmacyItem->save($updateArrayPharmacyItemFrom);
		$this->PharmacyItem->id="";
		
		//for To location which will fulfill request- Stock needs to be added For PharmacyItemRate
			
		
		$phramacyItemRateRequestedFrom_location=$this->PharmacyItemRate->find('first', array('fields'=>array('PharmacyItemRate.id','PharmacyItemRate.stock','PharmacyItemRate.loose_stock','PharmacyItemRate.location_id'),'conditions'=>array('PharmacyItemRate.item_id'=>$phramacyItemRequestedfrom_location['PharmacyItem']['id'],'PharmacyItemRate.location_id'=>$StoreRequisition['StoreRequisition']['requisition_by'],'PharmacyItemRate.batch_number'=>trim($phramacyItemRateRequestedto_location['PharmacyItemRate']['batch_number']))/*,'order'=>array('PharmacyItemRate.expiry_date'=>'ASC')*/));
			
		//update request From location For PharmacyItemRate
			
		
		if(empty($phramacyItemRateRequestedFrom_location['PharmacyItemRate']['id'])){
		 //new batch add
		 $getStock=$storeRequisitionParticular[$cnt]['StoreRequisitionParticular']['issued_qty']/$phramacyItemRequestedfrom_location['PharmacyItem']['pack'];
		 $getLooseStock=$storeRequisitionParticular[$cnt]['StoreRequisitionParticular']['issued_qty']%$phramacyItemRequestedfrom_location['PharmacyItem']['pack'];
		// $getLooseStock=floor($getLooseStock);
		 $exploGetStock=explode('.',$getStock);
		// $getStockNew=floor($getStock);
		 $updateArrayPharmacyItemRateFrom1['id']=null;
		 $updateArrayPharmacyItemRateFrom1['expiry_date']=$phramacyItemRateRequestedto_location['PharmacyItemRate']['expiry_date'];
		 $updateArrayPharmacyItemRateFrom1['batch_number']=trim($phramacyItemRateRequestedto_location['PharmacyItemRate']['batch_number']);
		 $updateArrayPharmacyItemRateFrom1['location_id']=$phramacyItemRequestedfrom_location['PharmacyItem']['location_id'];
		 $updateArrayPharmacyItemRateFrom1['item_id']=trim($phramacyItemRequestedfrom_location['PharmacyItem']['id']);
		 $updateArrayPharmacyItemRateFrom1['stock']=$exploGetStock[0];
		 $updateArrayPharmacyItemRateFrom1['loose_stock']=$getLooseStock;
		 $this->PharmacyItemRate->save($updateArrayPharmacyItemRateFrom1);
		 $this->PharmacyItemRate->id="";
		 }else{
		 ///Update Batch
		 $totalTabPharmacyItemRateFrom=($phramacyItemRateRequestedFrom_location['PharmacyItemRate']['stock']*$phramacyItemRequestedfrom_location['PharmacyItem']['pack'])+$phramacyItemRateRequestedFrom_location['PharmacyItemRate']['loose_stock'];
		 $stockUpdatedTabPharmacyItemRateFrom=$totalTabPharmacyItemRateFrom+$storeRequisitionParticular[$cnt]['StoreRequisitionParticular']['issued_qty'];
		 $stockUpdatedPharmacyItemRateFrom=$stockUpdatedTabPharmacyItemRateFrom/$phramacyItemRequestedfrom_location['PharmacyItem']['pack'];
		 $loosestockUpdatedPharmacyItemRateFrom=$stockUpdatedTabPharmacyItemRateFrom%$phramacyItemRequestedfrom_location['PharmacyItem']['pack'];
		 //$loosestockUpdatedPharmacyItemRateFrom=floor($loosestockUpdatedPharmacyItemRateFrom);
		 $exploStockUpdatedPharmacyItemRateFrom=explode('.',$stockUpdatedPharmacyItemRateFrom);
		// $stockUpdatedPharmacyItemRateFrom=floor($stockUpdatedPharmacyItemRateFrom);
		
		 $updateArrayPharmacyItemRateFrom2['id']=$phramacyItemRateRequestedFrom_location['PharmacyItemRate']['id'];
		 $updateArrayPharmacyItemRateFrom2['stock']=$exploStockUpdatedPharmacyItemRateFrom[0];
		 $updateArrayPharmacyItemRateFrom2['loose_stock']=$loosestockUpdatedPharmacyItemRateFrom;
		 $this->PharmacyItemRate->save($updateArrayPharmacyItemRateFrom2);
		 $this->PharmacyItemRate->id="";
		}
		
		
		$cnt++;
		}
		//**BOf-For Update status of recieved **/
		$updateArraystoreRequisitionParticular['id']=$StoreRequisition['StoreRequisition']['id'];
		$updateArraystoreRequisitionParticular['status']='recieved';
		$this->StoreRequisition->save($updateArraystoreRequisitionParticular);
		$this->StoreRequisition->id="";
		exit;
		
	}
	function stock_inbox_requistion_list(){
	
		$this->uses = array('StoreRequisition','User','StoreLocation','Location');
	
		$accessableLocation = $this->Location->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_deleted'=>0,'is_active'=>1)));
		$this->set('accessableLocation',$accessableLocation);
		if(!empty($this->request->query['status'])){
			$conditions['StoreRequisition']['status'] =$this->request->query['status'];
		}
		if(!empty($this->request->query['location_to'])){
			$conditions['StoreRequisition']['requisition_for'] =$this->request->query['location_to'];
		}
		if(!empty($this->request->query['location_from_id'])){
			$conditions['StoreRequisition']['requisition_by'] =$this->request->query['location_from_id'];			
		}else{
			$conditions['StoreRequisition']['requisition_for'] =$this->Session->read('locationid');
		}
		//$conditions['StoreRequisition']['stock_requisition_flag']= '1'; ///From Stock Transfer
		$conditions['StoreRequisition']['is_deleted']= '0';
		$conditions = $this->postConditions($conditions);
		
		$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array(
							'StoreRequisition.requisition_date' => 'desc'
					),
					'conditions'=>$conditions
			);
	
	
	
		$data = $this->paginate('StoreRequisition');
	
		
			
		foreach($data as $key=>$value){
			
			$requsition_for='';
			if($value['StoreLocationAlias']['name'] == "Other"){
				$this->LoadModel("PatientCentricDepartment");
				$for = $this->PatientCentricDepartment->read(null,$value['StoreRequisition']['requister_id']);
				$requsition_for =$for['PatientCentricDepartment']['name'];
			}else if($value['StoreLocationAlias']['name'] == "OT"){
				$for = $this->Opt->read(null,$value['StoreRequisition']['requister_id']);
				$requsition_for =$for['Opt']['name'];
			}else if($value['StoreLocationAlias']['name'] == "Chamber"){
				$this->LoadModel("Chamber");
				$for = $this->Chamber->read(null,$value['StoreRequisition']['requister_id']);
				$requsition_for =$for['Chamber']['name'];
			}else if($value['StoreLocationAlias']['name'] == "Ward"){
				$this->LoadModel("Ward");
				$for = $this->Ward->read(null,$value['StoreRequisition']['requister_id']);
				$requsition_for =$for['Ward']['name'];
			}
			//if(!empty($requsition_for))
			//	$data[$key]['StoreRequisition']['for'] =$requsition_for;
	
			//$requistion_by=$this->User->find('first',array('fields'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id'=>$value['StoreRequisition']['requisition_by'])));
		//	$data[$key]['StoreRequisition']['requested_by']=$requistion_by['User']['first_name'].' '.$requistion_by['User']['last_name'];

			$requistion_by=$this->Location->find('first',array('fields'=>array('Location.name'),'conditions'=>array("AND"=>array('Location.id'=>$value['StoreRequisition']['requisition_for'],'Location.id'=>$value['StoreRequisition']['requisition_by']))));
				
			$data[$key]['StoreRequisition']['requested_by']=$requistion_by['Location']['name'];
			$requistion_for=$this->Location->find('first',array('fields'=>array('Location.name'),'conditions'=>array('Location.id'=>$value['StoreRequisition']['requisition_for'])));
			$data[$key]['StoreRequisition']['requested_for']=$requistion_for['Location']['name'];
		}
	
		$this->set('data', $data);
	
	}
	
	function printRequisitionBeforeIssue($storeID=NULL){
		
	    $this->uses = array('StoreRequisition',"Department","Ward","Opt","Chamber","User",'StoreRequisitionParticular','Product','StoreLocation');
	    $this->layout = "print_with_header";
	   
	    $StoreRequisition = $this->StoreRequisition->read(null,$storeID);
	    $storeLocation=$this->StoreLocation->find('first',array('conditions'=>array('StoreLocation.id'=>$StoreRequisition['StoreRequisition']['requisition_for'])));
	    $toRequisLoc=$this->StoreLocation->find('first',array('fields'=>array('id','name'),'conditions'=>array('StoreLocation.id'=>$StoreRequisition['StoreRequisition']['store_location_id'])));
	    $this->set('toRequisLoc',$toRequisLoc);
	    $requsition_for='';
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
	    if(!empty($requsition_for))
	    	$data['for'] =  $requsition_for;
	    else{
	    	$data['for']=$StoreRequisition['StoreRequisition']['requisition_for'];
	    	$requsition_for=$storeLocation['StoreLocation']['name'];
	    }
	    //by Swapnil 24.03.2015
	    $allStores = $this->StoreLocation->find('list',array('conditions'=>array('StoreLocation.is_deleted'=>0),'fields'=>array('StoreLocation.id','StoreLocation.code_name')));
	    if($StoreRequisition['StoreRequisition']['store_location_id'] == array_search(Configure::read("apamCode"), $allStores)){
			//Requested to APAM
			$this->StoreRequisitionParticular->unbindModel(array('belongsTo'=>array('Product','PurchaseOrderItem')));
				$this->StoreRequisitionParticular->bindModel(array(
					'belongsTo'=>array(
						'PharmacyItem'=>array('foreignKey'=>false,'conditions'=>array('StoreRequisitionParticular.purchase_order_item_id = PharmacyItem.id')),
						'PharmacyItemRate'=>array('foreignKey'=>false,'conditions'=>array('PharmacyItemRate.item_id = PharmacyItem.id')),
						'Product'=>array('foreignKey'=>false,'conditions'=>array('PharmacyItem.drug_id=Product.id')),
						'ManufacturerCompany'=>array('foreignKey'=>false,'conditions'=>array('ManufacturerCompany.id=Product.manufacturer_id'))
							)));
							
			$storeDetails= $this->StoreRequisitionParticular->find('all',array('fields'=>array('Product.*','StoreRequisitionParticular.*','PharmacyItem.*','PharmacyItemRate.*'),
	    		'conditions'=>array('StoreRequisitionParticular.store_requisition_detail_id'=>$storeID),
				'group'=>array('StoreRequisitionParticular.id')));
			
	    	foreach($storeDetails as $key => $value){
					//only created an array of Product 
					$storeDetails[$key]['Product']['batch_number']= $value['PharmacyItemRate']['batch_number'];
					$storeDetails[$key]['Product']['expiry_date']= $value['PharmacyItemRate']['expiry_date'];
					$storeDetails[$key]['Product']['quantity']= $value['PharmacyItem']['stock'];
					$storeDetails[$key]['Product']['loose_stock']= $value['PharmacyItem']['loose_stock'];
					$storeDetails[$key]['Product']['mrp']= $value['PharmacyItemRate']['mrp'];
					$storeDetails[$key]['Product']['sale_price']= $value['PharmacyItemRate']['sale_price'];
				} 
	    }else{

	    	$this->StoreRequisitionParticular->unbindModel(array('belongsTo'=>array('Product','PurchaseOrderItem')));
	    	$this->StoreRequisitionParticular->bindModel(array(
	    			'belongsTo'=>array(
	    					'PharmacyItem'=>array('foreignKey'=>false,'conditions'=>array('StoreRequisitionParticular.purchase_order_item_id = PharmacyItem.id')),
	    					'PharmacyItemRate'=>array('foreignKey'=>false,'conditions'=>array('PharmacyItemRate.item_id = PharmacyItem.id')),
	    					'Product'=>array('foreignKey'=>false,'conditions'=>array('PharmacyItem.drug_id=Product.id')),
	    					'ManufacturerCompany'=>array('foreignKey'=>false,'conditions'=>array('ManufacturerCompany.id=Product.manufacturer_id'))
	    			)));
	    	
		  $storeDetails= $this->StoreRequisitionParticular->find('all',array('fields'=>array('Product.*','StoreRequisitionParticular.*','PharmacyItem.*','PharmacyItemRate.*'),
	    		'conditions'=>array('StoreRequisitionParticular.store_requisition_detail_id'=>$storeID),
				'group'=>array('StoreRequisitionParticular.id')));
	    }
	    
	    
	    $this->set('StoreRequisition',$StoreRequisition);
	    $this->set('storeDetails',$storeDetails);
	    $this->set('storeLocation',$storeLocation);
	    $this->set("requisition_for",$requsition_for);
	    $req_by=$this->User->find('first',array('field'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id'=>$StoreRequisition['StoreRequisition']['requisition_by'])));
	    $req_by_name=$req_by['User']['first_name'].' '.$req_by['User']['last_name'];
	    $issue_by=$this->User->find('first',array('field'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id'=>$StoreRequisition['StoreRequisition']['issue_by'])));
	    $issue_by_name=$issue_by['User']['first_name'].' '.$issue_by['User']['last_name'];
	    $entered_by=$this->User->find('first',array('field'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id'=>$StoreRequisition['StoreRequisition']['entered_by'])));
	    $entered_by_name=$entered_by['User']['first_name'].' '.$entered_by['User']['last_name'];
	    $this->set(array('entered_by_name'=>$entered_by_name,'issue_by_name'=>$issue_by_name,'req_by_name'=>$req_by_name ));
	    $this->set('requestedTo',$StoreRequisition['StoreRequisition']['store_location_id']);
	    
		$this->render('requisition_before_issue_print');
		
	}
	
	function printRequisitionAfterIssue($storeID=NULL){
	
		$this->uses = array('StoreRequisition',"Department","Ward","Opt","Chamber","User",'StoreRequisitionParticular','Product','StoreLocation');
		$this->layout = "print_with_header";
		
		$StoreRequisition = $this->StoreRequisition->read(null,$storeID);
		$storeLocation=$this->StoreLocation->find('first',array('conditions'=>array('StoreLocation.id'=>$StoreRequisition['StoreRequisition']['requisition_for'])));
		$toRequisLoc=$this->StoreLocation->find('first',array('fields'=>array('id','name'),'conditions'=>array('StoreLocation.id'=>$StoreRequisition['StoreRequisition']['store_location_id'])));
		$this->set('toRequisLoc',$toRequisLoc);
		$requsition_for='';
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
		if(!empty($requsition_for))
			$data['for'] =  $requsition_for;
		else{
			$data['for']=$StoreRequisition['StoreRequisition']['requisition_for'];
			$requsition_for=$storeLocation['StoreLocation']['name'];
		}
		
		 //by Swapnil 24.03.2015
	    $allStores = $this->StoreLocation->find('list',array('conditions'=>array('StoreLocation.is_deleted'=>0),'fields'=>array('StoreLocation.id','StoreLocation.code_name')));
	  
	    if($StoreRequisition['StoreRequisition']['store_location_id'] == array_search(Configure::read("pharmacyCode"), $allStores)){
			//Requested to APAM
			$this->StoreRequisitionParticular->unbindModel(array('belongsTo'=>array('Product','PurchaseOrderItem')));
	
				$this->StoreRequisitionParticular->bindModel(array(
					'belongsTo'=>array(
						'PharmacyItem'=>array('foreignKey'=>false,'conditions'=>array('StoreRequisitionParticular.purchase_order_item_id = PharmacyItem.id')),
						'PharmacyItemRate'=>array('foreignKey'=>false,'conditions'=>array('PharmacyItemRate.item_id = PharmacyItem.id')),
						'Product'=>array('foreignKey'=>false,'conditions'=>array('PharmacyItem.drug_id=Product.id')),
						'ManufacturerCompany'=>array('foreignKey'=>false,'conditions'=>array('ManufacturerCompany.id=Product.manufacturer_id'))
							)));
							
			$storeDetails= $this->StoreRequisitionParticular->find('all',array('fields'=>array('Product.*','StoreRequisitionParticular.*','PharmacyItem.*','PharmacyItemRate.*'),
	    		'conditions'=>array('StoreRequisitionParticular.store_requisition_detail_id'=>$storeID),
				'group'=>array('StoreRequisitionParticular.id')));
			
	    	foreach($storeDetails as $key => $value){
					//only created an array of Product 
					$storeDetails[$key]['Product']['batch_number']= $value['PharmacyItemRate']['batch_number'];
					$storeDetails[$key]['Product']['expiry_date']= $value['PharmacyItemRate']['expiry_date'];
					$storeDetails[$key]['Product']['quantity']= $value['PharmacyItem']['stock'];
					$storeDetails[$key]['Product']['loose_stock']= $value['PharmacyItem']['loose_stock'];
					$storeDetails[$key]['Product']['mrp']= $value['PharmacyItemRate']['mrp'];
					$storeDetails[$key]['Product']['sale_price']= $value['PharmacyItemRate']['sale_price'];
				} 
	    }else{
	    	$storeDetails= $this->StoreRequisitionParticular->find('all',array('fields'=>array('Product.*','PurchaseOrderItem.batch_number',
				'PurchaseOrderItem.expiry_date','PurchaseOrderItem.id','PurchaseOrderItem.stock_available','StoreRequisitionParticular.*'),
				'conditions'=>array('StoreRequisitionParticular.store_requisition_detail_id'=>$storeID)));
	    }
	    
	    
		$req_by=$this->User->find('first',array('field'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id'=>$StoreRequisition['StoreRequisition']['requisition_by'])));
		$req_by_name=$req_by['User']['first_name'].' '.$req_by['User']['last_name'];
		$issue_by=$this->User->find('first',array('field'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id'=>$StoreRequisition['StoreRequisition']['issue_by'])));
		$issue_by_name=$issue_by['User']['first_name'].' '.$issue_by['User']['last_name'];
		$entered_by=$this->User->find('first',array('field'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id'=>$StoreRequisition['StoreRequisition']['entered_by'])));
		$entered_by_name=$entered_by['User']['first_name'].' '.$entered_by['User']['last_name'];
		$this->set(array('entered_by_name'=>$entered_by_name,'issue_by_name'=>$issue_by_name,'req_by_name'=>$req_by_name ));
		$this->set('requestedTo',$StoreRequisition['StoreRequisition']['store_location_id']);
		
		$this->set('StoreRequisition',$StoreRequisition);
		$this->set('storeDetails',$storeDetails);
		$this->set('storeLocation',$storeLocation);
		$this->set("requisition_for",$requsition_for);
		 
		$this->render('requisition_after_issue_print');
	
	}
	/**
	 * function to delete requested Medications
	 * @author Mahalaxmi
	 */
	public function deleteItems($modelName,$preRecordId){
		$this->uses=array('StoreRequisitionParticular');	
	
		if($modelName=='stock'){
			$this->StoreRequisitionParticular->updateAll(array('StoreRequisitionParticular.is_deleted'=>'1'),array('StoreRequisitionParticular.id'=>$preRecordId));
			exit;
		}else{
	
		}
	
	}
        
        
        /**
	 * function to delete requisition if requisition is pending
	 * @author Swapnil
	 */
	public function deleteRequisition($id){
            $this->autoRender = false;
            $this->layout = false;
            $this->uses=array('StoreRequisition','StoreRequisitionParticular');
            if(empty($id)){
                $this->Session->setFlash(__('Could not found record to delete!'),'default',array('class'=>'error'));
                $this->redirect($this->referer());
            }
            $isIssued = $this->StoreRequisition->read('status',$id);
            if(strtolower($isIssued['StoreRequisition']['status']) === "requesting"){
                $this->StoreRequisition->id = $id;
                if($this->StoreRequisition->saveField('is_deleted','1')){
                    $this->StoreRequisitionParticular->updateAll(array('is_deleted'=>'1'),array('store_requisition_detail_id'=>$id));
                        $this->Session->setFlash(__('Record deleted successfully!'),'default',array('class'=>'message'));
                        $this->redirect(array("controller" => "InventoryCategories", "action" => "store_requisition_list"));
                } 
            } 
            $this->Session->setFlash(__('Could not delete the record!'),'default',array('class'=>'error'));
            $this->redirect($this->referer());
        }  
}
?>