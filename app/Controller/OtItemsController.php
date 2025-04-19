<?php
/**
 * OtItemsController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class OtItemsController extends AppController {

	public $name = 'OtItems';
	public $uses = array('OtItem');
	public $helpers = array('Html','Form','Js');
	public $components = array('RequestHandler','Email');

	/**
	 * ot items listing
	 *
	*/

	public function index() {
		$this->OtItem->bindModel(array('belongsTo' => array('OtItemCategory' => array('foreignKey' => 'ot_item_category_id'), 'PharmacyItem' => array('foreignKey' => 'pharmacy_item_id'))));
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'OtItem.name' => 'asc'
				),
				'conditions' => array('OtItem.is_deleted' => 0,'OtItem.location_id' => $this->Session->read("locationid"))
		);
		$this->set('title_for_layout', __('OT Items', true));
		$this->OtItem->recursive = 0;
		$data = $this->paginate('OtItem');
		$this->set('data', $data);
	}

	/**
	 * ot item view
	 *
	 */
	public function view($id = null) {
		$this->set('title_for_layout', __('OT Item Detail', true));
		$this->OtItem->bindModel(array('belongsTo' => array('OtItemCategory' => array('foreignKey' => 'ot_item_category_id'))));
		if (!$id) {
			$this->Session->setFlash(__('Invalid OT Item', true));
			$this->redirect(array("controller" => "ot_items", "action" => "index"));
		}
		$this->OtItem->bindModel(array('belongsTo' => array('PharmacyItem' => array('foreignKey' => 'pharmacy_item_id'))));
		$this->set('opt', $this->OtItem->read(null, $id));
	}

	/**
	 * ot item add
	 *
	 */
	public function add() {
		$this->layout = 'advance';
		$this->uses = array('OtItemCategory', 'PharmacyItem', 'OtItem');
		$this->set('title_for_layout', __('Add New OT Item', true));

		if ($this->request->is('post')  || $this->request->is('put')) {
			$checkOtItem = $this->OtItem->find('count', array('conditions' => array('OtItem.pharmacy_item_id' => $this->request->data['OtItem']['pharmacy_item_id'])));
			if($this->request->data['OtItem']['pharmacy_item_id']) {
				if($checkOtItem > 0) {
					$this->Session->setFlash(__('This Item is already exist.'),'default',array('class'=>'error'));
					$this->redirect(array("controller" => "ot_items", "action" => "add"));
					exit;
				}
			} else {
				// save to pharmacy table //
				$this->request->data['PharmacyItem']['name'] = $this->request->data['OtItem']['name'];
				$this->request->data['PharmacyItem']['DrugInfo'] = $this->request->data['OtItem']['DrugInfo'];
				$this->request->data['PharmacyItem']['manufacturer'] = $this->request->data['OtItem']['manufacturer'];
				$this->request->data['PharmacyItem']['location_id'] = $this->Session->read("locationid");
				$this->request->data['PharmacyItem']['create_time'] = date('Y-m-d H:i:s');
				$this->request->data['PharmacyItem']['created_by'] = $this->Auth->user('id');
				$this->PharmacyItem->create();
				$this->PharmacyItem->save($this->request->data);
				$this->request->data['OtItem']['pharmacy_item_id'] = $this->PharmacyItem->getLastInsertId();
			}

			$this->request->data['OtItem']['location_id'] = $this->Session->read("locationid");
			$this->request->data['OtItem']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['OtItem']['created_by'] = $this->Auth->user('id');
			$this->OtItem->create();
			$this->OtItem->save($this->request->data);
			$errors = $this->OtItem->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The OT Item has been saved', true));
				$this->redirect(array("controller" => "ot_items", "action" => "index"));
			}
		}
		$this->set('otitemcategories', $this->OtItemCategory->find('list', array('conditions' => array('OtItemCategory.is_deleted' => 0, 'OtItemCategory.location_id' => $this->Session->read('locationid')))));
	}

	/**
	 * ot item edit
	 *
	 */
	public function edit($id = null) {
		$this->layout = 'advance';
		$this->uses = array('OtItemCategory','OtItem','PharmacyItem');
		$this->set('title_for_layout', __('Edit OT Item', true));
			
		if ($this->request->is('post') || $this->request->is('put')) {
			/*$checkOtItem = $this->OtItem->find('count', array('conditions' => array('OtItem.pharmacy_item_id <>' =>$id, 'OtItem.pharmacy_item_id' => $this->request->data['OtItem']['pharmacy_item_id'])));
			 if($this->request->data['OtItem']['pharmacy_item_id']) {
			if($checkOtItem > 0) {
			$this->Session->setFlash(__('This Item is already exist.'),'default',array('class'=>'error'));
			$this->redirect(array("controller" => "ot_items", "action" => "add"));
			exit;
			}
			} else */{
			// save to pharmacy table //
			//debug($this->request->data);exit;
			$this->request->data['PharmacyItem']['name'] = $this->request->data['OtItem']['name'];
			$this->request->data['PharmacyItem']['DrugInfo'] = $this->request->data['OtItem']['DrugInfo'];
			$this->request->data['PharmacyItem']['manufacturer'] = $this->request->data['OtItem']['manufacturer'];
			$this->request->data['PharmacyItem']['location_id'] = $this->Session->read("locationid");
			$this->PharmacyItem->id = $this->request->data['OtItem']['pharmacy_item_id'];
			$this->PharmacyItem->save($this->request->data);
		}
		$this->request->data['OtItem']['location_id'] = $this->Session->read("locationid");
		$this->request->data['OtItem']['modify_time'] = date('Y-m-d H:i:s');
		$this->request->data['OtItem']['modified_by'] = $this->Auth->user('id');
		$this->OtItem->id = $this->request->data["OtItem"]['id'];
		$this->OtItem->save($this->request->data);
		$errors = $this->OtItem->invalidFields();
		if(!empty($errors)) {
			$this->set("errors", $errors);
		} else {
			$this->Session->setFlash(__('The OT Item has been updated', true));
			$this->redirect(array("controller" => "ot_items", "action" => "index"));
		}
		} else {
			$this->OtItem->bindModel(array('belongsTo' => array('PharmacyItem' => array('foreignKey' => 'pharmacy_item_id'))));
			$this->request->data = $this->OtItem->read(null, $id);
		}
		$this->set('otitemcategories', $this->OtItemCategory->find('list', array('conditions' => array('OtItemCategory.is_deleted' => 0, 'OtItemCategory.location_id' => $this->Session->read('locationid')))));

	}

	/**
	 * ot item delete
	 *
	 */
	public function delete($id = null) {
		$this->set('title_for_layout', __('Delete OT Item', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for OT Item', true));
			$this->redirect(array("controller" => "ot_items", "action" => "index"));
		}
		if ($id) {
			$this->OtItem->id = $id;
			$this->request->data['OtItem']['id'] = $id;
			$this->request->data['OtItem']['is_deleted'] = 1;
			$this->request->data['OtItem']['modified_by'] = $this->Auth->user('id');
			$this->request->data['OtItem']['modify_time'] = date('Y-m-d H:i:s');
			$this->OtItem->save($this->request->data);
			$this->Session->setFlash(__('OT Item deleted', true));
			$this->redirect(array("controller" => "ot_items", "action" => "index"));
		}
	}

	/**
	 * ot items quantity listing
	 *
	 */

	public function ot_item_quantities() {
		$this->loadModel("OtItemQuantity");
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'OtItem.name' => 'asc'
				),
				'conditions' => array('OtItemQuantity.is_deleted' => 0,'OtItemQuantity.location_id' => $this->Session->read("locationid")),
				'fields' => array('OtItemQuantity.id','PharmacyItem.name','OtItemQuantity.quantity','OtItemCategory.name')
					
		);
		$this->set('title_for_layout', __('OT Item Quantity', true));
		$this->OtItemQuantity->recursive = 0;
		$data = $this->paginate('OtItemQuantity');

		$this->set('data', $data);
	}

	/**
	 * ot item quantity view
	 *
	 */
	public function view_ot_item_quantity($id = null) {
		$this->uses = array("OtItemQuantity");
		$this->set('title_for_layout', __('OT Item Quantity Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid OT Item Quantity', true));
			$this->redirect(array("controller" => "ot_items_quantities", "action" => "index"));
		}
		$this->set('opt', $this->OtItemQuantity->read(null, $id));
	}

	/**
	 * ot item quantity add
	 *
	 */
	public function add_ot_item_quantity() {
		$this->uses = array("OtItemQuantity","OtItem", "OtItemCategory");
		$this->set('title_for_layout', __('Add New OT Item Quantity', true));
		if ($this->request->is('post')) {
			$getExistItem = $this->OtItemQuantity->find('first', array('conditions' => array('OtItemQuantity.ot_item_id' => $this->request->data['OtItemQuantity']['ot_item_id'], 'OtItemQuantity.is_deleted' => 0)));
			if(count($getExistItem) > 0) {
				$this->OtItemQuantity->id =  $getExistItem['OtItemQuantity']['id'];
				$this->request->data['OtItemQuantity']['id'] = $getExistItem['OtItemQuantity']['id'];
				$this->request->data['OtItemQuantity']['quantity'] += $getExistItem['OtItemQuantity']['quantity'];
			}
			$this->request->data['OtItemQuantity']['location_id'] = $this->Session->read("locationid");
			$this->request->data['OtItemQuantity']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['OtItemQuantity']['created_by'] = $this->Auth->user('id');
			$this->OtItemQuantity->create();
			$this->OtItemQuantity->save($this->request->data);
			$errors = $this->OtItemQuantity->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The OT Item quantity has been saved', true));
				$this->redirect(array("controller" => "ot_items", "action" => "ot_item_quantities"));
			}
		}
		$this->set("itemcatlist", $this->OtItemCategory->find("list", array("conditions" => array('OtItemCategory.is_deleted' => 0, 'OtItemCategory.location_id' => $this->Session->read('locationid')), 'fields' => array('OtItemCategory.id', 'OtItemCategory.name'))));
	}

	/**
	 * ot item quantity edit
	 *
	 */
	public function edit_ot_item_quantity($id = null) {
		$this->uses = array("OtItemQuantity","OtItem","OtItemCategory");
		$this->set('title_for_layout', __('Edit OT Item Quantity', true));
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid OT Item Quantity', true));
			$this->redirect(array("controller" => "ot_items", "action" => "ot_item_quantities"));
		}
		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->request->data['OtItemQuantity']['location_id'] = $this->Session->read("locationid");
			$this->request->data['OtItemQuantity']['modify_time'] = date('Y-m-d H:i:s');
			$this->request->data['OtItemQuantity']['modified_by'] = $this->Auth->user('id');
			$this->OtItemQuantity->id = $this->request->data["OtItemQuantity"]['id'];
			$this->OtItemQuantity->save($this->request->data);
			$errors = $this->OtItemQuantity->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The OT Item Quantity has been updated', true));
				$this->redirect(array("controller" => "ot_items", "action" => "ot_item_quantities"));
			}
		} else {
			$this->set("itemcatlist", $this->OtItemCategory->find("list", array("conditions" => array('OtItemCategory.is_deleted' => 0, 'OtItemCategory.location_id' => $this->Session->read('locationid')))));
			$this->request->data = $this->OtItemQuantity->read(null, $id);
			$this->OtItem->bindModel(array('belongsTo' => array('PharmacyItem' => array('foreignKey' => 'pharmacy_item_id'))));
			$this->set("itemlist", $this->OtItem->find("list", array("conditions" => array('OtItem.is_deleted' => 0, 'OtItem.ot_item_category_id' => $this->request->data['OtItemQuantity']['ot_item_category_id']), 'fields' => array('OtItem.id', 'PharmacyItem.name'), 'recursive' => 1)));
		}


	}

	/**
	 * ot item quantity delete
	 *
	 */
	public function delete_ot_item_quantity($id = null) {
		$this->loadModel('OtItemQuantity');
		$this->set('title_for_layout', __('Delete OT Item Quantity', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for OT Item Quantity', true));
			$this->redirect(array("controller" => "ot_items", "action" => "ot_item_quantities"));
		}
		if ($id) {
			$this->OtItemQuantity->id = $id;
			$this->request->data['OtItemQuantity']['id'] = $id;
			$this->request->data['OtItemQuantity']['is_deleted'] = 1;
			$this->request->data['OtItemQuantity']['modified_by'] = $this->Auth->user('id');
			$this->request->data['OtItemQuantity']['modify_time'] = date('Y-m-d H:i:s');
			$this->OtItemQuantity->save($this->request->data);
			$this->Session->setFlash(__('OT Item Quantity deleted', true));
			$this->redirect(array("controller" => "ot_items", "action" => "ot_item_quantities"));
		}
	}

	/**
	 * ot item allocation
	 *
	 */
	public function ot_item_allocation($id = null) {
		$this->loadModel('OtReplace');
		$this->set('title_for_layout', __('OT Item Allocation', true));
		$this->OtReplace->bindModel(array('belongsTo' => array('Opt' => array('foreignKey' => 'opt_id'), 'OptTable' => array('foreignKey' => 'opt_table_id'), 'User' => array('foreignKey' => false, 'conditions' => array('User.id=OtReplace.created_by')), 'Initial' => array('foreignKey' => false, 'conditions' => array('Initial.id=User.initial_id')))));
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'OtReplace.create_time' => 'desc'
				),
				'conditions' => array('OtReplace.is_deleted' => 0,'OtReplace.location_id' => $this->Session->read("locationid"))
		);
		$this->set('title_for_layout', __('OT Item Allocation', true));
		$this->OtReplace->recursive = 0;
		$data = $this->paginate('OtReplace');
		$this->set('data', $data);
	}

	/**
	 * request ot item
	 *
	 */
	public function request_ot_item($id = null) {
		$this->uses = array('Opt', 'OtItemQuantity', 'OtItemAllocationDetail', 'OtItemAllocation');
		$this->set('title_for_layout', __('Request For OT Item', true));
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['OtItemAllocation']['request_id'] = $this->Auth->user('id');
			$this->request->data['OtItemAllocation']['location_id'] = $this->Session->read("locationid");
			$this->request->data['OtItemAllocation']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['OtItemAllocation']['created_by'] = $this->Auth->user('id');
			if($this->OtItemAllocation->save($this->request->data['OtItemAllocation'])) {
				$cntItemAllocation=0;
				$lastInsertId = $this->OtItemAllocation->getLastInsertId();
				foreach($this->request->data['OtItemAllocationDetail']['ot_item_id'] as $key => $val) {
					$cntItemAllocation++;
					if(@in_array($key, $this->request->data['OtItemAllocationDetail']['ot_item_check'])) {
						$this->request->data['OtItemAllocationDetail']['ot_item_allocation_id'] = $lastInsertId;
						$this->request->data['OtItemAllocationDetail']['ot_item_id'] = $key;
						$this->request->data['OtItemAllocationDetail']['request_ot_item'] = $val;
						$this->request->data['OtItemAllocationDetail']['remark'] = $this->request->data['OtItemAllocationDetail']['remark1'][$key];
						$this->request->data['OtItemAllocationDetail']['location_id'] = $this->Session->read('locationid');
						$this->OtItemAllocationDetail->save($this->request->data['OtItemAllocationDetail']);
						$this->OtItemAllocationDetail->id = false;
					}
				}
			}
			$this->Session->setFlash(__('Request For OT Items has been submitted successfully', true));
			$this->redirect(array("controller" => "ot_items", "action" => "ot_item_allocation"));
		}
		$getOtItemQuantity = $this->OtItemQuantity->find('all', array('conditions' => array('OtItemQuantity.location_id' => $this->Session->read('locationid'), 'OtItemQuantity.is_deleted'=>0), 'fields'=> array('OtItemQuantity.id', 'OtItem.name', 'SUM(OtItemQuantity.quantity) as quantity','OtItemQuantity.ot_item_id'), 'group'=> array('OtItemQuantity.ot_item_id')));
		$this->set('getOtItemQuantity', $getOtItemQuantity);
		// sorted item id with allocation //
		$getAllocatedItemIdCount = $this->OtItemAllocationDetail->find('all', array('conditions' => array('OtItemAllocationDetail.location_id' => $this->Session->read('locationid')), 'fields'=> array('OtItemAllocationDetail.ot_item_id', 'SUM(OtItemAllocationDetail.allocate_ot_item) as allocate_quantity'), 'group'=> array('OtItemAllocationDetail.ot_item_id')));
		foreach($getAllocatedItemIdCount as $getAllocatedItemIdCountVal) {
			$getAllocatedItemWithIdIndex[$getAllocatedItemIdCountVal['OtItemAllocationDetail']['ot_item_id']] = $getAllocatedItemIdCountVal[0]['allocate_quantity'];
		}

		$this->set('getAllocatedItemWithIdIndex', $getAllocatedItemWithIdIndex);
		$this->set('opts',$this->Opt->find('list', array('conditions' => array('Opt.is_deleted' => 0, 'Opt.location_id' => $this->Session->read("locationid")))));
	}

	/**
	 * view request ot item
	 *
	 */
	public function view_request_ot_item($id = null) {
		$this->uses = array('Opt', 'OtItemQuantity', 'OtReplaceDetail', 'OtReplace');
		$this->set('title_for_layout', __('View Request OT Item', true));
		$this->OtReplace->bindModel(array('belongsTo' => array('Opt' => array('foreignKey' => 'opt_id'), 'OptTable' => array('foreignKey' => 'opt_table_id'), 'User' => array('foreignKey' => false, 'conditions' => array('User.id=OtReplace.created_by')), 'Initial' => array('foreignKey' => false, 'conditions' => array('Initial.id=User.initial_id')))));
		$getOtItemAllocation = $this->OtReplace->find('first', array('conditions' => array('OtReplace.location_id' => $this->Session->read('locationid'), 'OtReplace.is_deleted'=>0, 'OtReplace.id'=>$id)));
		$this->set('getOtItemAllocation', $getOtItemAllocation);
		// get ot item allocation detail //
		$this->OtReplaceDetail->bindModel(array('belongsTo' => array('OtItem' => array('foreignKey' => 'item_id'), 'PharmacyItem' => array('foreignKey' => false, 'conditions' => array('PharmacyItem.id=OtItem.pharmacy_item_id')))));
		$getOtItemAllocationDetail = $this->OtReplaceDetail->find('all', array('conditions' => array('OtReplaceDetail.is_deleted'=>0, 'OtReplaceDetail.ot_replace_id'=>$id)));
		$this->set('getOtItemAllocationDetail', $getOtItemAllocationDetail);

		$getOtItemQuantity = $this->OtItemQuantity->find('all', array('conditions' => array('OtItemQuantity.location_id' => $this->Session->read('locationid'), 'OtItemQuantity.is_deleted'=>0), 'fields'=> array('OtItemQuantity.id', 'OtItem.name', 'SUM(OtItemQuantity.quantity) as quantity','OtItemQuantity.ot_item_id'), 'group'=> array('OtItemQuantity.ot_item_id')));
		foreach($getOtItemQuantity as $getOtItemQuantityVal) {
			$getOtItemQuantityWithIdIndex[$getOtItemQuantityVal['OtItemQuantity']['ot_item_id']] = $getOtItemQuantityVal[0]['quantity'];
		}

		$this->set('getOtItemQuantityWithIdIndex', $getOtItemQuantityWithIdIndex);
		// sorted item id with allocation //
		$getAllocatedItemIdCount = $this->OtReplaceDetail->find('all', array('conditions' => array('OtReplaceDetail.is_deleted' => 0), 'fields'=> array('OtReplaceDetail.item_id', 'SUM(OtReplaceDetail.recieved_quantity) as allocate_quantity'), 'group'=> array('OtReplaceDetail.item_id')));
		foreach($getAllocatedItemIdCount as $getAllocatedItemIdCountVal) {
			$getAllocatedItemWithIdIndex[$getAllocatedItemIdCountVal['OtReplaceDetail']['item_id']] = $getAllocatedItemIdCountVal[0]['allocate_quantity'];
		}

		$this->set('getAllocatedItemWithIdIndex', $getAllocatedItemWithIdIndex);

	}

	/**
	 * edit request ot item
	 *
	 */
	public function edit_request_ot_item($id = null) {
		$this->uses = array('Opt', 'OtItemQuantity', 'OtReplaceDetail', 'OtReplace');
		$this->set('title_for_layout', __('Allocate OT Item', true));
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->OtReplace->id = $this->request->data['OtReplace']['id'];
			$this->request->data['OtReplace']['status'] = 'A';
			$this->request->data['OtReplace']['modify_time'] = date('Y-m-d H:i:s');
			$this->request->data['OtReplace']['modified_by'] = $this->Auth->user('id');
			if($this->OtReplace->save($this->request->data)) {
				//$lastInsertId = $this->OtItemAllocation->getLastInsertId();
				foreach($this->request->data['OtReplaceDetail']['recieved_quantity'] as $key => $val) {
					$this->OtReplaceDetail->id = $this->request->data['OtReplaceDetail']['adid'][$key];
					$this->request->data['OtReplaceDetail']['id'] = $this->request->data['OtReplaceDetail']['adid'][$key];
					$this->request->data['OtReplaceDetail']['remark'] = $this->request->data['OtReplaceDetail']['remark'][$key];
					$this->request->data['OtReplaceDetail']['recieved_quantity'] = $val;
					$this->OtReplaceDetail->save($this->request->data);
				}
			}
			$this->Session->setFlash(__('Allocate For OT Items has been saved', true));
			$this->redirect(array("controller" => "ot_items", "action" => "ot_item_allocation"));
		}
		$this->OtReplace->bindModel(array('belongsTo' => array('Opt' => array('foreignKey' => 'opt_id'), 'OptTable' => array('foreignKey' => 'opt_table_id'), 'User' => array('foreignKey' => false, 'conditions' => array('User.id=OtReplace.created_by')), 'Initial' => array('foreignKey' => false, 'conditions' => array('Initial.id=User.initial_id')))));
		$getOtItemAllocation = $this->OtReplace->find('first', array('conditions' => array('OtReplace.location_id' => $this->Session->read('locationid'), 'OtReplace.is_deleted'=>0, 'OtReplace.id'=>$id)));
		$this->set('getOtItemAllocation', $getOtItemAllocation);
		// get ot item allocation detail //
		$this->OtReplaceDetail->bindModel(array('belongsTo' => array('OtItem' => array('foreignKey' => 'item_id'), 'PharmacyItem' => array('foreignKey' => false, 'conditions' => array('PharmacyItem.id=OtItem.pharmacy_item_id')))));
		$getOtItemAllocationDetail = $this->OtReplaceDetail->find('all', array('conditions' => array('OtReplaceDetail.is_deleted'=>0, 'OtReplaceDetail.ot_replace_id'=>$id)));
		$this->set('getOtItemAllocationDetail', $getOtItemAllocationDetail);

		$getOtItemQuantity = $this->OtItemQuantity->find('all', array('conditions' => array('OtItemQuantity.location_id' => $this->Session->read('locationid'), 'OtItemQuantity.is_deleted'=>0), 'fields'=> array('OtItemQuantity.id', 'OtItem.name', 'SUM(OtItemQuantity.quantity) as quantity','OtItemQuantity.ot_item_id'), 'group'=> array('OtItemQuantity.ot_item_id')));
		foreach($getOtItemQuantity as $getOtItemQuantityVal) {
			$getOtItemQuantityWithIdIndex[$getOtItemQuantityVal['OtItemQuantity']['ot_item_id']] = $getOtItemQuantityVal[0]['quantity'];
		}
		$this->set('getOtItemQuantityWithIdIndex', $getOtItemQuantityWithIdIndex);

		// sorted item id with allocation //
		$getAllocatedItemIdCount = $this->OtReplaceDetail->find('all', array('conditions' => array('OtReplaceDetail.is_deleted' => 0), 'fields'=> array('OtReplaceDetail.item_id', 'SUM(OtReplaceDetail.recieved_quantity) as allocate_quantity'), 'group'=> array('OtReplaceDetail.item_id')));
		foreach($getAllocatedItemIdCount as $getAllocatedItemIdCountVal) {
			$getAllocatedItemWithIdIndex[$getAllocatedItemIdCountVal['OtReplaceDetail']['item_id']] = $getAllocatedItemIdCountVal[0]['allocate_quantity'];
		}
		$this->set('getAllocatedItemWithIdIndex', $getAllocatedItemWithIdIndex);
	}

	/**
	 * delete requested ot items
	 *
	 */
	public function delete_request_ot_item($id = null) {
		$this->uses = array('OtReplace','OtReplaceDetail');
		$this->set('title_for_layout', __('Delete Request OT Item', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Request OT Item', true));
			$this->redirect(array("controller" => "ot_items", "action" => "request_ot_item"));
		}
		if($id) {
			$this->OtItemAllocation->id = $id;
			$this->request->data['OtReplace']['id'] = $id;
			$this->request->data['OtReplace']['is_deleted'] = 1;
			$this->request->data['OtReplace']['modified_by'] = $this->Auth->user('id');
			$this->request->data['OtReplace']['modify_time'] = date('Y-m-d H:i:s');
			if($this->OtReplace->save($this->request->data)) {
				$this->OtReplaceDetail->updateAll(array('OtReplaceDetail.is_deleted' => '1'), array('OtReplaceDetail.ot_replace_id' => $id));
			}
			$this->Session->setFlash(__('Request OT Item deleted', true));
			$this->redirect(array("controller" => "ot_items", "action" => "ot_item_allocation"));
		}
	}

	/**
	 * get all OT table listing by xmlhttprequest
	 *
	 */

	public function getOptTableList() {
		$this->loadModel("OptTable");
		$this->set('opttables',$this->OptTable->find('list', array('conditions' => array('OptTable.is_deleted' => 0, 'OptTable.opt_id' => $this->params->query['opt_id']))));
		$this->layout = false;
		$this->render('/OtItems/ajaxgetopttables');
	}

	/**
	 * ot items category listing
	 *
	 */

	public function ot_item_category() {
		$this->loadModel('OtItemCategory');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'OtItemCategory.name' => 'asc'
				),
				'conditions' => array('OtItemCategory.is_deleted' => 0,'OtItemCategory.location_id' => $this->Session->read("locationid"))
		);
		$this->set('title_for_layout', __('Item Categories', true));
		$this->OtItemCategory->recursive = 0;
		$data = $this->paginate('OtItemCategory');
		$this->set('data', $data);
	}

	/**
	 * ot item category view
	 *
	 */
	public function view_ot_item_category($id = null) {
		$this->loadModel('OtItemCategory');
		$this->set('title_for_layout', __('Item Category Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Item Category', true));
			$this->redirect(array("controller" => "ot_items", "action" => "ot_item_category"));
		}
		$this->set('opt', $this->OtItemCategory->read(null, $id));
	}

	/**
	 * ot item category add
	 *
	 */
	public function add_ot_item_category() {
		$this->loadModel('OtItemCategory');
		$this->set('title_for_layout', __('Add Item Category', true));
		if ($this->request->is('post')) {
			$this->request->data['OtItemCategory']['location_id'] = $this->Session->read("locationid");
			$this->request->data['OtItemCategory']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['OtItemCategory']['created_by'] = $this->Auth->user('id');
			$this->OtItemCategory->create();
			$this->OtItemCategory->save($this->request->data);
			$errors = $this->OtItemCategory->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The Item Category has been saved', true));
				$this->redirect(array("controller" => "ot_items", "action" => "ot_item_category"));
			}
		}

	}

	/**
	 * ot item category edit
	 *
	 */
	public function edit_ot_item_category($id = null) {
		$this->loadModel('OtItemCategory');
		$this->loadModel('OtItemCategory');
		$this->set('title_for_layout', __('Edit Item Category', true));
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Item Category', true));
			$this->redirect(array("controller" => "ot_items", "action" => "ot_item_category"));
		}
		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->request->data['OtItemCategory']['location_id'] = $this->Session->read("locationid");
			$this->request->data['OtItemCategory']['modify_time'] = date('Y-m-d H:i:s');
			$this->request->data['OtItemCategory']['modified_by'] = $this->Auth->user('id');
			$this->OtItemCategory->id = $this->request->data["OtItemCategory"]['id'];
			$this->OtItemCategory->save($this->request->data);
			$errors = $this->OtItemCategory->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The Item Category has been updated', true));
				$this->redirect(array("controller" => "ot_items", "action" => "ot_item_category"));
			}
		} else {
			$this->request->data = $this->OtItemCategory->read(null, $id);
		}


	}

	/**
	 * ot item category delete
	 *
	 */
	public function delete_ot_item_category($id = null) {
		$this->loadModel('OtItemCategory');
		$this->set('title_for_layout', __('Delete OT Item Category', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for OT Item Category', true));
			$this->redirect(array("controller" => "ot_items", "action" => "ot_item_category"));
		}
		if ($id) {
			$this->OtItem->id = $id;
			$this->request->data['OtItemCategory']['id'] = $id;
			$this->request->data['OtItemCategory']['is_deleted'] = 1;
			$this->request->data['OtItemCategory']['modified_by'] = $this->Auth->user('id');
			$this->request->data['OtItemCategory']['modify_time'] = date('Y-m-d H:i:s');
			$this->OtItemCategory->save($this->request->data);
			$this->Session->setFlash(__('OT Item Category deleted', true));
			$this->redirect(array("controller" => "ot_items", "action" => "ot_item_category"));
		}
	}

	/**
	 * get ot items sorted with category requested by xmlhttprequest
	 *
	 */

	public function getOtItemsList() {
		$this->loadModel("OtItem");
		$this->OtItem->bindModel(array('belongsTo' => array('PharmacyItem' => array('foreignKey' => 'pharmacy_item_id'))));
		$this->set('otitems',$this->OtItem->find('list', array('conditions' => array('OtItem.is_deleted' => 0, 'OtItem.ot_item_category_id' => $this->params->query['ot_item_category_id']), 'fields' => array('OtItem.id', 'PharmacyItem.name'), 'recursive' => 1)));
		$this->layout = false;
		$this->render('/OtItems/ajaxgetotitems');
	}

	/**
	 * autosearch pharmacy item with code
	 *
	 */
	public function autoSearchPharmacyItem() {
		$this->loadModel("PharmacyItem");
		$pharmacyItemArray = $this->PharmacyItem->find('all', array('fields'=> array('id', 'name', 'item_code','manufacturer'), 'conditions'=> array('PharmacyItem.is_deleted' => 0, 'PharmacyItem.location_id'=> $this->Session->read('locationid')), 'order' => array('PharmacyItem.item_code')));
			
		foreach ($pharmacyItemArray as $pharmacyItemArrayVal) {
			//$pharmacyNamewithItemCode = $pharmacyItemArrayVal['PharmacyItem']['name']."(".$pharmacyItemArrayVal['PharmacyItem']['item_code'].")";
			$pharmacyNamewithItemCode = $pharmacyItemArrayVal['PharmacyItem']['name'];
			echo "$pharmacyNamewithItemCode|{$pharmacyItemArrayVal['PharmacyItem']['id']}\n";
		}
		exit; //dont remove this
	}

	/*public function add_order_category() {
	 $this->loadModel('OrderCategory');
	$this->set('title_for_layout', __('Add Order Category', true));
	if ($this->request->is('post')) {
	$this->request->data['OrderCategory']['location_id'] = $this->Session->read("locationid");
	$this->request->data['OrderCategory']['create_time'] = date('Y-m-d H:i:s');
	$this->request->data['OrderCategory']['created_by'] = $this->Auth->user('id');
	$this->OrderCategory->create();
	$this->OrderCategory->save($this->request->data);
	$errors = $this->OrderCategory->invalidFields();
	if(!empty($errors)) {
	$this->set("errors", $errors);
	} else {
	$this->Session->setFlash(__('The I Category has been saved', true));
	$this->redirect(array("controller" => "order_category", "action" => "order_category"));
	}
	}

	}*/

	/**
	 * order category edit
	 *
	 */
	/*public function edit_order_category($id = null) {
	 $this->loadModel('OrderCategory');
	$this->loadModel('OrderCategory');
	$this->set('title_for_layout', __('Edit Order Category', true));
	if (!$id && empty($this->request->data)) {
	$this->Session->setFlash(__('Invalid Order Category', true));
	$this->redirect(array("controller" => "order_category", "action" => "order_category"));
	}
	if ($this->request->is('post') && !empty($this->request->data)) {
	$this->request->data['OrderCategory']['location_id'] = $this->Session->read("locationid");
	$this->request->data['OrderCategory']['modify_time'] = date('Y-m-d H:i:s');
	$this->request->data['OrderCategory']['modified_by'] = $this->Auth->user('id');
	$this->OrderCategory->id = $this->request->data["OrderCategory"]['id'];
	$this->OrderCategory->save($this->request->data);
	$errors = $this->OrderCategory->invalidFields();
	if(!empty($errors))
	{
	$this->set("errors", $errors);
	} else {
	$this->Session->setFlash(__('The Order Category has been updated', true));
	$this->redirect(array("controller" => "order_category", "action" => "order_category"));
	}
	} else {
	$this->request->data = $this->OrderCategory->read(null, $id);
	}
	}*/

	/**
	 * order category delete
	*
	*/
	/*function delete_order_category($id = null) {
	 $this->loadModel('OrderCategory');
	$this->set('title_for_layout', __('Delete OT Order Category', true));
	if (!$id) {
	$this->Session->setFlash(__('Invalid id for Order Category', true));
	$this->redirect(array("controller" => "order_category", "action" => "order_category"));
	}
	if ($id) {
	$this->OtItem->id = $id;
	$this->request->data['OrderCategory']['id'] = $id;
	$this->request->data['OrderCategory']['is_deleted'] = 1;
	$this->request->data['OrderCategory']['modified_by'] = $this->Auth->user('id');
	$this->request->data['OrderCategory']['modify_time'] = date('Y-m-d H:i:s');
	$this->OrderCategory->save($this->request->data);
	$this->Session->setFlash(__('Order Category deleted', true));
	$this->redirect(array("controller" => "order_category", "action" => "order_category"));
	}
	}*/


	/**
	 * ot items category listing
	*
	*/

	function order_category() {
		$this->loadModel('OrderCategory');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'OrderCategory.name' => 'asc'
				),
				'conditions' => array('OrderCategory.is_deleted' => 0,'OrderCategory.location_id'=> $this->Session->read("locationid"))
		);
		$this->set('title_for_layout', __('Order Categories', true));
		$this->OrderCategory->recursive = 0;
		$data = $this->paginate('OrderCategory');
		//debug($data); exit;
		$this->set('data', $data);
	}

	/**
	 * order category view
	 *
	 */
	function view_order_category($id = null) {
		$this->loadModel('OrderCategory');
		$this->set('title_for_layout', __('Order Category Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Order Category', true));
			$this->redirect(array("controller" => "ot_items", "action" => "order_category"));
		}
		$this->set('opt', $this->OrderCategory->read(null, $id));
	}

	/**
	 * add order category add
	 *
	 */
	function add_order_category() {
		//debug ($this->request->data);exit;
		$this->loadModel('OrderCategory');
		$this->set('title_for_layout', __('Add Order Category', true));
		if ($this->request->is('post')) {
			$this->request->data['OrderCategory']['location_id'] = $this->Session->read("locationid");
			$this->request->data['OrderCategory']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['OrderCategory']['created_by'] = $this->Auth->user('id');
			$this->OrderCategory->create();
			$this->OrderCategory->save($this->request->data);
			$errors = $this->OrderCategory->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The Order Category has been saved', true));
				$this->redirect(array("controller" => "ot_items", "action" => "order_category"));
			}
		}
		//debug ($this->request->data);exit;

	}

	/**
	 * order category edit
	 *
	 */
	function edit_order_category($id = null) {
		$this->loadModel('OrderCategory');
		$this->loadModel('OrderCategory');
		$this->set('title_for_layout', __('Edit Order Category', true));
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Order Category', true));
			$this->redirect(array("controller" => "ot_items", "action" => "order_category"));
		}
		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->request->data['OrderCategory']['location_id'] = $this->Session->read("locationid");
			$this->request->data['OrderCategory']['modify_time'] = date('Y-m-d H:i:s');
			$this->request->data['OrderCategory']['modified_by'] = $this->Auth->user('id');
			$this->OrderCategory->id = $this->request->data["OrderCategory"]['id'];
			$this->OrderCategory->save($this->request->data);
			$errors = $this->OrderCategory->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The Order Category has been updated', true));
				$this->redirect(array("controller" => "ot_items", "action" => "order_category"));
			}
		} else {
			$this->request->data = $this->OrderCategory->read(null, $id);
		}


	}

	/**
	 * order category delete
	 *
	 */
	function delete_order_category($id = null) {
		$this->loadModel('OrderCategory');
		$this->set('title_for_layout', __('Delete Order Category', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Order Category', true));
			$this->redirect(array("controller" => "ot_items", "action" => "order_category"));
		}
		if ($id) {
			$this->OrderCategory->id = $id;
			$this->request->data['OrderCategory']['id'] = $id;
			$this->request->data['OrderCategory']['is_deleted'] = 1;
			$this->request->data['OrderCategory']['modified_by'] = $this->Auth->user('id');
			$this->request->data['OrderCategory']['modify_time'] = date('Y-m-d H:i:s');
			$this->OrderCategory->save($this->request->data);
			$this->Session->setFlash(__('Order Category deleted', true));
			$this->redirect(array("controller" => "ot_items", "action" => "order_category"));
		}
	}

	/**
	 * get order sorted with category requested by xmlhttprequest
	 *
	 */

	function getOrderList() {
		$this->loadModel("OrderCategory");
		$this->OrderCategory->bindModel(array('belongsTo' => array('PharmacyItem' => array('foreignKey' => 'pharmacy_item_id'))));
		$this->set('ordercategory',$this->OrderCategory->find('list', array('conditions' => array('OrderCategory.is_deleted' => 0, 'OrderCategory.order_category_id' => $this->params->query['order_category_id']), 'fields' => array('OtItem.id', 'PharmacyItem.name'), 'recursive' => 1)));
		$this->layout = false;
		$this->render('/OrderCategory/ajaxgetordercategory');
	}

	/**
	 * order data master listing
	 *
	 */


	function order_data_master($id=null){
		$this->uses = array('OrderDataMaster','OrderCategory');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'OrderDataMaster.name' => 'asc'
				),
				'conditions' => array('OrderDataMaster.is_deleted' => 0,'OrderDataMaster.location_id'=> $this->Session->read("locationid"))
		);
		$this->set('title_for_layout', __('Order Data Master', true));
		$this->OrderDataMaster->recursive = 0;
		$data = $this->paginate('OrderDataMaster');
		$this->set('data', $data);

		$getOrderCateRecord=$this->OrderCategory->find('list',array('fields'=>array('id','order_description'),'conditions'=>array('OrderCategory.is_active'=>'0')));

		$this->set('getOrderCateRecord', $getOrderCateRecord);





		//$diagnosis = $this->Diagnosis->find('all',array('fields'=>array('Diagnosis.height,Diagnosis.weight,Diagnosis.bmi,Diagnosis.patient_id,Diagnosis.create_time,
		//Patient.age,Person.sex,Patient.lookup_name'),'conditions'=>array('Diagnosis.patient_id'=>$j),'order' => array('Patient.id' => 'asc')));

	}


	function add_order_data_master($id=null)
	{
		$this->uses = array('OrderCategory');

		$this->loadModel('OrderDataMaster');
		$this->set('title_for_layout', __('Add Order Data Master ', true));
		if ($this->request->is('post')) {
			$this->request->data['OrderDataMaster']['location_id'] = $this->Session->read("locationid");
			$this->request->data['OrderDataMaster']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['OrderDataMaster']['created_by'] = $this->Auth->user('id');
			$this->request->data['OrderDataMaster']['order_category'] = $this->request->data['OrderCategory']['order_category_id'];
			$this->OrderDataMaster->create();
			//debug ($this->request->data);exit;
			$this->OrderDataMaster->save($this->request->data);
			$errors = $this->OrderDataMaster->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The Order Data Master has been saved', true));
				$this->redirect(array("controller" => "ot_items", "action" => "order_data_master"));
			}
		}
		$order_category = $this->OrderCategory->find('list', array('fields'=> array('OrderCategory.id','OrderCategory.order_description'),'conditions'=>array('OrderCategory.is_active'=>1)));

		$this->set('order_category',$order_category);

		$data = $this->OrderCategory->find('list',array('fields'=>array('id','order_description'),'conditions'=>array('is_active'=>'0','location_id'=>$this->Session->read("locationid"))));

		$this->set('data', $data);

	}
	function edit_order_data_master($id=null)
	{
		$this->loadModel('OrderDataMaster');
		$this->loadModel('OrderDataMaster');
		$this->set('title_for_layout', __('Edit Order Data Master', true));
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Order Data Master', true));
			$this->redirect(array("controller" => "ot_items", "action" => "order_data_master"));
		}
		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->request->data['OrderDataMaster']['location_id'] = $this->Session->read("locationid");
			$this->request->data['OrderDataMaster']['modify_time'] = date('Y-m-d H:i:s');
			$this->request->data['OrderDataMaster']['modified_by'] = $this->Auth->user('id');
			$this->OrderDataMaster->id = $this->request->data["OrderDataMaster"]['id'];
			$this->OrderDataMaster->save($this->request->data);
			$errors = $this->OrderDataMaster->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The Order Data Master has been updated', true));
				$this->redirect(array("controller" => "ot_items", "action" => "order_data_master"));
			}
		} else {
			$this->request->data = $this->OrderDataMaster->read(null, $id);
		}

	}

	function viewOrderDataMaster($id = null) {
		$this->loadModel('OrderDataMaster');
		$this->set('title_for_layout', __('Order Data Master Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Order Data Master', true));
			$this->redirect(array("controller" => "ot_items", "action" => "order_data_master"));
		}
		$this->set('opt', $this->OrderDataMaster->read(null, $id));
	}







	function delete_order_data_master($id = null) {
		$this->loadModel('OrderDataMaster');
		$this->set('title_for_layout', __('Delete Order Data Master', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Order Data Master', true));
			$this->redirect(array("controller" => "ot_items", "action" => "order_data_master"));
		}
		if ($id) {
			$this->OrderDataMaster->id = $id;
			$this->request->data['OrderDataMaster']['id'] = $id;
			$this->request->data['OrderDataMaster']['is_deleted'] = 1;
			$this->request->data['OrderDataMaster']['modified_by'] = $this->Auth->user('id');
			$this->request->data['OrderDataMaster']['modify_time'] = date('Y-m-d H:i:s');
			$this->OrderDataMaster->save($this->request->data);
			$this->Session->setFlash(__('Order Data Master deleted', true));
			$this->redirect(array("controller" => "ot_items", "action" => "order_data_master"));
		}
	}

}
?>