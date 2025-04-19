<?php
/**
 * This is Laundries Controller file.
 *
 * Use to Manage Laundries Controller function and there views
 * created : 20/01/2012
 */
class LaundriesController extends AppController {

	public $name = 'Laundries';
	public $uses = array('InventoryLaundry','InventoryCategory','User','LaundryManager','InstockLaundry','Ward','LaundryItem');
	public $helpers = array('Html','Form', 'Js','General'); 
	
	public $components = array('RequestHandler','Email');

/***
	@Action: inventory_index
	@access : Public
	@created : 1/18/2012
	@modified:
***/

	public function inventory_index(){
	
		$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'InventoryLaundry.id' => 'desc'
			        )
			    );
	 $conditions = array('InventoryLaundry.is_deleted' =>0,'InventoryLaundry.location_id'=>$this->Session->read('locationid'));		
                $this->set('title_for_layout', __('Manage Category', true));
	 			$this->InventoryLaundry->bindModel(array(
 												'belongsTo' => array( 											 
												'User' =>array(
															'fields'=>'User.first_name,User.last_name',
															'foreignKey'=>'created_by',
															 
												)
 										)));
                $data = $this->paginate($conditions);
				 
                $this->set('data', $data);
	
	}
	
/***
	@Action: inventory_add
	@access : Public
	@created : 1/18/2012
	@modified:
***/
	public function inventory_add(){
	
		$this->set('title_for_layout', __('Add Item', true));
             // Get the wards list for dropdown
				$wards = $this->Ward->find('list',array('conditions'=>array('Ward.location_id'=>$this->Session->read('locationid'))));
			
			// Get the item list for dropdown
				$items = $this->LaundryItem->find('list',array('conditions'=>array('LaundryItem.is_deleted'=>0,'LaundryItem.location_id'=>$this->Session->read('locationid')),'fields'=>array('LaundryItem.name','LaundryItem.name')));
				
				$this->set(compact('items'));
				$this->set(compact('wards'));
		   // Get Item Code
			
				if($this->params['isAjax']) {
					$id = $this->params->query['item_id'];
					//pr($id);exit;
					if(!empty($id)){
					// The required data from table	of those whose status is active i.e. 1
						$getData = $this->LaundryItem->field('item_code',array('LaundryItem.name'=>$id));
						//pr($getData);exit;
					
						$this->set('item',$getData);
						
					//$this->layout = 'ajax';
						$this->render('ajaxgetitemcode');
					} else {

						$this->set('item','');
						$this->render('ajaxgetitemcode');
					}
				}
			
			if (!empty($this->request->data)) {  
					// check if the category already exists
						$old_data = $this->InventoryLaundry->find('count',array('conditions'=>array('InventoryLaundry.name'=>$this->request->data['InventoryLaundry']['name'],'InventoryLaundry.item_code'=>$this->request->data['InventoryLaundry']['item_code'],'InventoryLaundry.ward_id'=> $this->request->data["InventoryLaundry"]["ward_id"],'InventoryLaundry.is_deleted'=>0,'InventoryLaundry.location_id'=>$this->Session->read('locationid'))));
						if($old_data){
						 
							$this->Session->setFlash(__('This item is already exist in ward!'),'default',array('class'=>'error'));
							return false;
							$this->redirect(array('action'=>'add'));
						}
					//pr($this->request->data);exit;
			
					// change date to sql format
					    $this->request->data["InventoryLaundry"]["date"] = date("Y-m-d");
                        $this->request->data["InventoryLaundry"]["create_time"] = date("Y-m-d H:i:s");
                        $this->request->data["InventoryLaundry"]["modify_time"] = date("Y-m-d H:i:s");
                        $this->request->data["InventoryLaundry"]["is_deleted"] = 0;
					// Get the user creating the category
                        $this->request->data["InventoryLaundry"]["created_by"] = $this->Session->read('userid');
                        $this->request->data["InventoryLaundry"]["modified_by"] = $this->Session->read('userid'); 
						 $this->request->data["InventoryLaundry"]["location_id"] = $this->Session->read('locationid'); 
                   // pr($this->request->data);exit;
                        $this->InventoryLaundry->create();
					// Save Here
                        $this->InventoryLaundry->save($this->request->data);
						
						$errors = $this->InventoryLaundry->invalidFields();
                        if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           		$this->Session->setFlash(__('Item has been alloted successfully'),'default',array('class'=>'message'));
  							 	$this->redirect(array("controller" => "laundries", "action" => "index", "inventory" => true));
			            }
			} 

			
			
			
	}


/***
	@Action: inventory_edit
	@access : Public
	@created : 1/18/2012
	@modified:
***/
	public function inventory_edit($id = null){
		
		$this->set('title_for_layout', __('Edit Item', true));
			if (!$id && empty($this->request->data)) {
				$this->Session->setFlash(__('Invalid Item'),'default',array('class'=>'error'));
				$this->redirect(array('action'=>'index'));
			}
			 
		   // Get Item Code
			
				if($this->params['isAjax']) {
					$id = $this->params->query['item_id'];
					
					if(!empty($id)){
					// The required data from table	of those whose status is active i.e. 1
						$getData = $this->LaundryItem->field('item_code',array('LaundryItem.name'=>$id,'LaundryItem.location_id'=>$this->Session->read('locationid')));
						
						$this->set('item',$getData);
						
					
					}  else {

						$this->set('item','');
						$this->render('ajaxgetitemcode');
					}

					$this->layout = false;
						$this->render('ajaxgetitemcode');
				}
			if (!empty($this->request->data)) {
				// check if the category already exists	 
					/*$old_data = $this->InventoryLaundry->find('count',array('conditions'=>array('InventoryLaundry.name'=>$this->request->data['InventoryLaundry']['name'],'InventoryLaundry.item_code'=>$this->request->data['InventoryLaundry']['item_code'],'InventoryLaundry.ward_id'=> $this->request->data["InventoryLaundry"]["ward_id"],'InventoryLaundry.is_deleted'=>0)));
						if($old_data){
						  
							$this->Session->setFlash(__('This Inventory Item is already exist.'),'default',array('class'=>'error'));
							return false;
							$this->redirect(array('action'=>'edit',$id));
					}*/
		  
                  // change date to sql format	
                    $this->request->data["InventoryLaundry"]["modify_time"] = date("Y-m-d H:i:s");
				 // Modified entry by
                    $this->request->data["InventoryLaundry"]["modified_by"] = $this->Session->read('userid'); 
					 $this->request->data["InventoryLaundry"]["location_id"] = $this->Session->read('locationid'); 
                  //pr($this->request->data);exit;
				 // Save Here					  
					if ($this->InventoryLaundry->save($this->data)) {
						$this->Session->setFlash(__('Item has been updated successfully'),'default',array('class'=>'message'));
						$this->redirect(array('action'=>'index'));
					} else {
						$this->Session->setFlash(__('Item could not be saved. Please, try again.'),'default',array('class'=>'error'));
					}
			}
			if (empty($this->data)) {
			 // Get the wards list for dropdown
				$wards = $this->Ward->find('list',array('conditions'=>array('Ward.location_id'=>$this->Session->read('locationid'))));
				$this->set(compact('wards'));
				
				// Get the item list for dropdown
				$items = $this->LaundryItem->find('list',array('conditions'=>array('LaundryItem.is_deleted'=>0,'LaundryItem.location_id'=>$this->Session->read('locationid')),'fields'=>array('LaundryItem.name','LaundryItem.name')));
				
				$this->set(compact('items'));

				$this->data = $this->InventoryLaundry->read(null, $id);			 
			}
			$this->set('id', $id);
	}

/***
	@Action: inventory_view
	@access : Public
	@created : 1/18/2012
	@modified:
***/
	
	public function inventory_view($id = null){
	
		$this->set('title_for_layout', __('View Item Detail', true));
	    //$this->uses = array('InventoryLaundry');
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Item.', true));
			$this->redirect(array('action'=>'index'));
		}
		//pr();exit;
		
		$this->set('items', $this->InventoryLaundry->find('first',array('conditions'=>array('InventoryLaundry.id'=>$id,'InventoryLaundry.location_id'=>$this->Session->read('locationid')))));
	}

/***
	@Action: inventory_delete
	@access : Public
	@created : 1/18/2012
	@modified:
***/
	
	public function inventory_delete($id = null){
	
		$this->set('title_for_layout', __('Delete Item', true));
			if (!$id) {
				$this->Session->setFlash(__('Invalid id for Item'),'default',array('class'=>'error'));
				$this->redirect(array('action'=>'index'));
			} else {
				$status = $this->InventoryLaundry->field('is_deleted',array('InventoryLaundry.id'=>$id));
				$this->request->data['InventoryLaundry']['id'] = $id;
			// Modified entry by
                    $this->request->data["InventoryLaundry"]["modified_by"] = $this->Session->read('userid'); 

				if($status == 0){
					$this->request->data['InventoryLaundry']['is_deleted'] = 1;
				} else {
					$this->request->data['InventoryLaundry']['is_deleted'] = 0;
				}
			}
			
			if ($this->InventoryLaundry->save($this->request->data)) {
				$this->Session->setFlash(__('Item deleted successfully'),'default',array('class'=>'message'));
				$this->redirect(array('action'=>'index'));
			}
	}

/***
	@Action: inventory_manager
	@access : Public
	@created : 1/18/2012
	@modified: 1/23/2012
***/
	public function inventory_manager(){

		$this->set('title_for_layout', __('Add Item', true));
         if($this->params['isAjax']) {
			$location_id = $this->Session->read('locationid');
			$id = $this->params->query['ward_id'];
		if(!empty($id)){
		// The required data from table	of those whose status is active i.e. 1
			$getData = $this->InventoryLaundry->find('all',array('conditions'=>array('InventoryLaundry.is_deleted'=>0,'InventoryLaundry.ward_id'=>$id,'InventoryLaundry.location_id'=>$location_id)));
			$count = count($getData);
			
			$submit = true;
		} else {
			$getData = '';
			$submit = false;
		}
		//pr($getData);exit;
			$this->set('laundries',$getData);
			$this->set(compact('count'));
			$this->set(compact('submit'));
			$wards = $this->Ward->find('list',array('conditions'=>array('Ward.location_id'=>$this->Session->read('locationid'))));
			$this->set(compact('wards'));
		//$this->layout = 'ajax';
			$this->render('ajaxgetitemlist');

	} else {
		$getData = '';
		//$submit = false;
		$this->set(compact('submit'));
		$this->set('laundries',$getData);	
	}
		// Set flag for error- 0 stands for no error

		  $error = 0;
			
			if (!empty($this->request->data)) { 
			  // Initialise variable as empty
				$item = '';
				$quantity = '';
				$code = '';
				$description = '';
				$in_stock = '';
				$j=1;
				$k = 0;
				$list = $this->request->data['LaundryManager']['list'];
				
				//pr($this->request->data);exit;
				for($i=1;$i<=$list;$i++){
				
				// Create date to be stored in table as a each row for each item
					$data[$k]['LaundryManager']['item_name'] = $this->request->data['LaundryManager']['item'.$j];
					
					$data[$k]['LaundryManager']['item_code'] = $this->request->data['LaundryManager']['code'.$j];
					
					$data[$k]['LaundryManager']['total_quantity'] = $this->request->data['LaundryManager']['total_quantity'.$j];
					
					$data[$k]['LaundryManager']['quantity'] = $this->request->data['LaundryManager']['quantity'.$j];
					
					$data[$k]['LaundryManager']['description'] = $this->request->data['LaundryManager']['description'.$j];

					//$data[$k]['LaundryManager']['min_quantity'] = $this->request->data['LaundryManager']['min_quantity'.$j];
					
					$data[$k]['LaundryManager']['type'] = $this->request->data['LaundryManager']['type'];

					$data[$k]['LaundryManager']['ward_id'] = $this->request->data['LaundryManager']['ward_id'];

					$data[$k]['LaundryManager']['date'] = date("Y-m-d H:i:s");

			// Get the user creating the category
                $data[$k]["LaundryManager"]["created_by"] = $this->Session->read('userid');

			
			
			// Get the user creating the category
					$this->request->data["LaundryManager"]["created_by"] = $this->Session->read('userid');
					
				//pr($this->request->data);exit;
			// Increament the key 				
					$j++; 
					$k++;
					
				}  
			// Save data in row to create new row each time 		
				foreach($data as $value){
				// Unset tghe field if the quantity is emty	
				if($value['LaundryManager']['quantity'] == ''){
						unset($value);
				}
				 // Get in stock--call function
				 if(isset($value)){
					$responce = $this->__in_stock($value);
				 }
				 //pr($responce);exit;
				if(isset($value) && $responce == 0 && $value['LaundryManager'] !=''){
					// change date to sql format
					$value["LaundryManager"]["create_time"] = date("Y-m-d H:i:s");
					$value["LaundryManager"]["modify_time"] = date("Y-m-d H:i:s");
					
					if($this->LaundryManager->saveAll($value)){
						$error = 0;						
					} 
				} 
			} 
				
				if($responce == 0){
					$this->Session->setFlash(__('Item Added successfully'),'default',array('class'=>'message'));
					$this->redirect(array('controller'=>'laundries','action'=>'manager','inventory'=>true));
				} else {
					$this->Session->setFlash(__('Invalid Entry! Please check the stock and type of entry.'),'default',array('class'=>'error'));
					$this->redirect(array('controller'=>'laundries','action'=>'manager','inventory'=>true));
				}
			
			}
	

	
	// Get the wards list for dropdown
		$wards = $this->Ward->find('list',array('conditions'=>array('Ward.location_id'=>$this->Session->read('locationid'))));
		$this->set(compact('wards'));

		//pr($wards);exit;
	
	}

/***
	@Action: getitemlist
	@access : Public
	@created : 1/18/2012
	@modified: 1/23/2012
***/

/* public function getitemlist(){
	if($this->params['isAjax']) {
		$id = $this->params->query['ward_id'];
	 // The required data from table	of those whose status is active i.e. 1
		$getData = $this->InventoryLaundry->find('all',array('conditions'=>array('InventoryLaundry.is_deleted'=>0,'InventoryLaundry.ward_id'=>$id)));
		//pr($getData);exit;
		$this->set('laundries',$getData);	
		
		$this->layout = 'ajax';
        $this->render('ajaxgetitemlist');
	}
 }*/


/***
	@Action: __in_stock
	@access : Public
	@created : 1/18/2012
	@modified: 1/23/2012
	Created by : Anand
***/
	public function __in_stock($get){
	
	
	foreach($get as $value){
// Get last stock of item  
	$itemCode = $value['item_code'];
	$itemName = $value['item_name'];
	$type = $value['type'];
	$ward = $value['ward_id'];
	$last_entry = $value['quantity'];
	$total_quantity = $value['total_quantity'];

// Set the flag for error
	$error = 0;
// Get previous entry id
	$getid = $this->InstockLaundry->find('first',array('conditions'=>array('InstockLaundry.item_code'=>$itemCode),'fields'=>'MAX(id) as id'));
// Fetch the previous entry
	$getStock = $this->InstockLaundry->find('first',array('conditions'=>array('InstockLaundry.id'=>$getid[0]['id'], 'InstockLaundry.item_code'=>$itemCode)));
	//pr($getStock);
	if(!empty($getStock)){

		$in_stock = $getStock['InstockLaundry']['in_stock'];
		
// Condition to check type of entry. if type = out lenan(Subtract) AND check the out lenan IF going aout of quantity
		if($type == 'Out Linen' && $in_stock != 0){
		// Calculate the new stock
		    $newStock['InstockLaundry']['in_stock'] = $in_stock - $last_entry;
	   // Collect other data	
			$newStock['InstockLaundry']['item_code'] = $itemCode;
			$newStock['InstockLaundry']['item_name'] = $itemName;
			$newStock['InstockLaundry']['total_quantity'] = $total_quantity;			
			$newStock['InstockLaundry']['ward_id'] = $ward;
			$newStock['InstockLaundry']['type'] = $type;
			$newStock['InstockLaundry']['last_entry'] = $last_entry;
			$newStock['InstockLaundry']['date'] = date('Y-m-d');
			$newStock['InstockLaundry']["create_time"] = date("Y-m-d H:i:s");
			$newStock['InstockLaundry']["created_by"] = $this->Session->read('userid');
			$newStock["InstockLaundry"]["location_id"] = $this->Session->read('locationid'); 
			//pr($in_stock);exit;
	 // Is type in in lenan(Addition)
	   } else if($type == 'In Linen' && $in_stock < $total_quantity){
			$newStock['InstockLaundry']['in_stock'] = $in_stock + $last_entry;
			$newStock['InstockLaundry']['item_code'] = $itemCode;
			$newStock['InstockLaundry']['item_name'] = $itemName;
			$newStock['InstockLaundry']['total_quantity'] = $total_quantity;			
			$newStock['InstockLaundry']['ward_id'] = $ward;
			$newStock['InstockLaundry']['type'] = $type;
			$newStock['InstockLaundry']['last_entry'] = $last_entry;
			$newStock['InstockLaundry']['date'] = date('Y-m-d');
			$newStock['InstockLaundry']["create_time"] = date("Y-m-d H:i:s");
			$newStock['InstockLaundry']["created_by"] = $this->Session->read('userid');
			$newStock["InstockLaundry"]["location_id"] = $this->Session->read('locationid');
			
	   } else {
			$error = 1;
	   }
	   
	  // pr($newStock);
	  // Save here
		if($error != 1 AND $last_entry != ''){
		
			$this->InstockLaundry->saveAll($newStock);
			$error = 0;
		} else {
			$error = 1;
		}
	// If the previous entry is not in table
	} else {
		if($type == 'Out Linen'){
       // If entering new entry. Deduct quantity from total quantity
		    $newStock['InstockLaundry']['in_stock'] = $total_quantity - $last_entry;

			$newStock['InstockLaundry']['item_code'] = $itemCode;
			$newStock['InstockLaundry']['item_name'] = $itemName;
			$newStock['InstockLaundry']['total_quantity'] = $total_quantity;
			$newStock['InstockLaundry']['ward_id'] = $ward;
			$newStock['InstockLaundry']['type'] = $type;
			$newStock['InstockLaundry']['last_entry'] = $last_entry;
			$newStock['InstockLaundry']['date'] = date('Y-m-d');
			$newStock['InstockLaundry']["create_time"] = date("Y-m-d H:i:s");
			$newStock['InstockLaundry']["created_by"] = $this->Session->read('userid');
			$newStock["InstockLaundry"]["location_id"] = $this->Session->read('locationid');

	   } 
	   //pr($newStock);exit;
	  // Save Here 

	  if($error != 1){ 
		if($this->InstockLaundry->saveAll($newStock)){
			$error = 0;
		} else {
			$error = 1;
		}
	   }
	 }
    }
	//pr($error);exit;
	return($error);
  }


/***
	@Action: inventory_laundry_report
	@access : Public
	@created : 1/18/2012
	@modified: 1/23/2012
***/
	/*public function inventory_laundry_report(){
	 
	$this->InventoryLaundry->create();	
		
				$wards = $this->Ward->find('list',array('conditions'=>array('Ward.location_id'=>$this->Session->read('locationid'))));
				$this->set(compact('wards'));				
	}*/

/***
	@Action: inventory_laundry_pdf
	@access : Public
	@created : 1/18/2012
	@modified: 1/23/2012
	Created by : Anand
***/
	public function inventory_laundry_report(){
	// Collecte all possible record for the dates range 
		 if (!empty($this->request->data)) { 
			//pr($this->request->data);exit;
				$from = $this->DateFormat->formatDate2STD($this->request->data['LaundryReport']['from'],Configure::read('date_format'));
				$to = $this->DateFormat->formatDate2STD($this->request->data['LaundryReport']['to'],Configure::read('date_format'));				
				$ward_id = $this->request->data['LaundryReport']['ward_id'];
				$type = $this->request->data['LaundryReport']['type'];
				$record = '';
				$linenType = '';
				$format = $this->request->data['LaundryReport']['format'];;
				$location_id = $this->Session->read('locationid');
			// Condition Here
				
				$search_key = array('InstockLaundry.date <=' => $to, 'InstockLaundry.date >=' => $from,'InstockLaundry.location_id'=>$location_id);
				
				if(!(empty($ward_id))){
					$search_key['InstockLaundry.ward_id'] =  $ward_id;
				}
				
				if(!(empty($type))){
					$search_key['InstockLaundry.type'] =  $type;
				}


				$record = $this->InstockLaundry->find('all',array('conditions' =>$search_key));

			//pr($record);exit;
			if($format == 'PDF'){
				$this->set(compact('linenType'));
				$this->set('reports',$record);
				 //$this->layout = 'pdf'; //this will use the pdf.ctp layout
				$this->render('inventory_laundry_pdf','pdf');   
			} else {
				$this->set(compact('linenType'));
				$this->set('reports', $record);
				$this->render('inventory_excel','');
			}
		}
	    $wards = $this->Ward->find('list',array('conditions'=>array('Ward.location_id'=>$this->Session->read('locationid'))));
		$this->set(compact('wards'));
	  
	}	

/***
	@Action: admin_item_index
	@access : Public
	@created : 1/18/2012
	@modified: 1/23/2012
***/
	public function admin_item_index(){
		$this->set('title_for_layout', __('Item List', true));

		$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'LaundryItem.id' => 'asc'
			        )
			    );
				
                $this->set('title_for_layout', __('Manage Category', true));
	 			$this->LaundryItem->bindModel(array(
 												'belongsTo' => array( 											 
												'User' =>array(
															'fields'=>'User.first_name,User.last_name',
															'foreignKey'=>'created_by',
															 
												)
 										)));
				$conditions = array('LaundryItem.is_deleted' =>0,'LaundryItem.location_id'=>$this->Session->read('locationid'));		
                $data = $this->paginate('LaundryItem',$conditions);
				 
                $this->set('data', $data);
	

	}



/***
	@Action: admin_item_add
	@access : Public
	@created : 1/18/2012
	@modified: 1/23/2012
***/
	public function admin_item_add(){
		$this->set('title_for_layout', __('Add Item', true));

		if (!empty($this->request->data)) {  
		// Trim spaces			
			//trim($this->request->data['LaundryItem']['name']);
			//trim($this->request->data['LaundryItem']['name']);
			
		// check if the category already exists
			$old_data = $this->LaundryItem->find('count',array('conditions'=>array('LaundryItem.name'=>$this->request->data['LaundryItem']['name'],'LaundryItem.is_deleted'=>0,'LaundryItem.location_id'=>$this->Session->read('locationid'))));
			if($old_data){			 
				$this->Session->setFlash(__('This Laundry Item is already exist.'),'default',array('class'=>'error'));
				return false;
				$this->redirect(array('action'=>'item_add'));
			}
			//pr($old_data);exit;
			
		// change date to sql format
			$this->request->data["LaundryItem"]["create_time"] = date("Y-m-d H:i:s");
			$this->request->data["LaundryItem"]["modify_time"] = date("Y-m-d H:i:s");
		// Get Item Code 			
			$this->request->data["LaundryItem"]["item_code"] = 'LI'.substr('12345' . rand(1, 9999), -3);
		
			
		// Set deleted false
			$this->request->data["LaundryItem"]["is_deleted"] = 0;
			
		// Get the user creating the category
			$this->request->data["LaundryItem"]["created_by"] = $this->Session->read('userid');
			$this->request->data["LaundryItem"]["modified_by"] = $this->Session->read('userid');
			$this->request->data["LaundryItem"]["location_id"] =$this->Session->read('locationid');
		//pr($this->request->data);exit;
			$this->LaundryItem->create();
		// Save Here
			$this->LaundryItem->save($this->request->data);
			
			$errors = $this->LaundryItem->invalidFields();
			if(!empty($errors)) {
			   $this->set("errors", $errors);
			} else {
					$this->Session->setFlash(__('Laundry Item has been added successfully'),'default',array('class'=>'message'));
					$this->redirect(array("controller" => "laundries", "action" => "item_index", "admin" => true));
			}
		}
	}


/***
	@Action: item_delete
	@access : Public
	@created : 1/18/2012
	@modified:
***/
	
	public function admin_item_delete($id = null){
	
		$this->set('title_for_layout', __('Delete Item', true));
			if (!$id) {
				$this->Session->setFlash(__('Invalid id for Item'),'default',array('class'=>'error'));
				$this->redirect(array('action'=>'index'));
			} else {
				$status = $this->LaundryItem->field('is_deleted',array('LaundryItem.id'=>$id));
				$this->request->data['LaundryItem']['id'] = $id;
			// Modified entry by
                    $this->request->data["LaundryItem"]["modified_by"] = $this->Session->read('userid'); 

				if($status == 0){
					$this->request->data['LaundryItem']['is_deleted'] = 1;
				} else {
					$this->request->data['LaundryItem']['is_deleted'] = 0;
				}
			}
			
			if ($this->LaundryItem->save($this->request->data)) {
				$this->Session->setFlash(__('Item deleted successfully'),'default',array('class'=>'message'));
				$this->redirect(array('controller'=>'laundries','action'=>'item_index','admin'=>true));
			}
	}

/***
	@Action: admin_item_edit
	@access : Public
	@created : 1/18/2012
	@modified: 1/23/2012
***/
	public function admin_item_edit($id=null){
		$this->set('title_for_layout', __('Add Item', true));

		if (!empty($this->request->data)) {  
		// check if the category already exists
			/*$old_data = $this->LaundryItem->find('count',array('conditions'=>array('LaundryItem.name'=>$this->request->data['LaundryItem']['name'],'LaundryItem.item_code'=>$this->request->data['LaundryItem']['item_code'],'LaundryItem.is_deleted'=>0)));
			if($old_data){
			 
				$this->Session->setFlash(__('This Laundry Item is already exist.'),'default',array('class'=>'error'));
				return false;
				$this->redirect(array('action'=>'item_add'));
		}*/

		// change date to sql format			

			$this->request->data["LaundryItem"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["LaundryItem"]["is_deleted"] = 0;
		// Get the user creating the category			

			$this->request->data["LaundryItem"]["modified_by"] = $this->Session->read('userid'); 
			$this->request->data["LaundryItem"]["location_id"] =$this->Session->read('locationid');

		//pr($this->request->data);exit;
			$this->LaundryItem->create();
		// Save Here
			$this->LaundryItem->save($this->request->data);
			
			$errors = $this->LaundryItem->invalidFields();
			if(!empty($errors)) {
			   $this->set("errors", $errors);
			} else {
					$this->Session->setFlash(__('Laundry Item has been edited successfully'),'default',array('class'=>'message'));
					$this->redirect(array("controller" => "laundries", "action" => "item_index", "admin" => true));
			}
		} 

		if(empty($this->request->data)){
			$this->data = $this->LaundryItem->read(null, $id);	
		}
	}

public function inventory_excel() {
	$excel_data = array();

   	$excel_data = $this->LaundryItem->find('all',array('condition'=>array('LaundryItem.location_id'=>$this->Session->read('locationid'))));

	
       
    /*if($this->Session->check('Order.excel'))
      {
        $excel_data = $this->Session->read('Order.excel');
      }*/
        $this->set('excel_data', $excel_data);

          $this->render('inventory_excel','export');
   }



	/**All Functions End Here**/
}