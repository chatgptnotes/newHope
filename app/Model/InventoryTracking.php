<?php 
/*
* @created : 18.01.2016
* @created by : Swapnil Sharma
* model for tracking inventory products
*/

class InventoryTracking extends AppModel {
  public $name = 'InventoryTracking'; 

  public $specific = true;
  function __construct($id = false, $table = null, $ds = null) {
      $session = new cakeSession();
  $this->db_name =  $session->read('db_name');
      parent::__construct($id, $table, $ds);
  }
  
  public function updateInventoryTracking($purchaseOrderId,$storeLocationId){
      $PurchaseOrder = Classregistry::init ( 'PurchaseOrder' );
      $PurchaseOrderItem = Classregistry::init ( 'PurchaseOrderItem' );
      $this->uses = array("PurchaseOrderItem","PurchaseOrder");
      
      $PurchaseOrderItem->bindModel(array(
        'belongsTo'=>array(
            'PurchaseOrder'=>array(
              'foreignKey'=>'purchase_order_id',
              'type'=>'inner',
              'recursive'=>'1')
            ) 
        ),false);

      $data = $PurchaseOrderItem->find('all',array(
        'fields'=>array('PurchaseOrder.id, PurchaseOrder.supplier_id, PurchaseOrder.order_for',
          'PurchaseOrderItem.id, PurchaseOrderItem.product_id, PurchaseOrderItem.purchase_order_id, PurchaseOrderItem.purchase_price,
          PurchaseOrderItem.grn_no, PurchaseOrderItem.quantity_received'),
        'conditions'=>array('purchase_order_id'=>$purchaseOrderId)));
       
      $conditions['PurchaseOrder.is_deleted'] = '0';
      $conditions['PurchaseOrder.order_for'] = $storeLocationId;

      foreach ($data as $key => $value) { 
          
        $returnData[$key]['purchase_order_item_id'] = $value['PurchaseOrderItem']['id']; 
        $returnData[$key]['current_supplier_id'] = $value['PurchaseOrder']['supplier_id']; 
        $returnData[$key]['product_id'] = $value['PurchaseOrderItem']['product_id'];
        $returnData[$key]['current_rate'] = $value['PurchaseOrderItem']['purchase_price'];
        $returnData[$key]['current_quantity_received'] = $value['PurchaseOrderItem']['quantity_received'];
        $returnData[$key]['store_location_id'] = $storeLocationId;

        $result[$key] = $PurchaseOrderItem->find('first',array(
          'fields'=>array('PurchaseOrderItem.id, PurchaseOrderItem.purchase_price, PurchaseOrder.supplier_id, PurchaseOrderItem.quantity_received, PurchaseOrderItem.received_date'),
          'conditions'=>array($conditions,
            'PurchaseOrderItem.product_id'=>$value['PurchaseOrderItem']['product_id'],
          'PurchaseOrderItem.purchase_price NOT LIKE '=>$value['PurchaseOrderItem']['purchase_price']
          ),
          'order'=>array('PurchaseOrderItem.id'=>'DESC'))); 
        
        $returnData[$key]['previous_purchase_order_item_id'] = $result[$key]['PurchaseOrderItem']['id'];
        $returnData[$key]['previous_rate'] = $result[$key]['PurchaseOrderItem']['purchase_price'];
        $returnData[$key]['previous_supplier_id'] = $result[$key]['PurchaseOrder']['supplier_id'];
        $returnData[$key]['previous_quantity_received'] = $result[$key]['PurchaseOrderItem']['quantity_received'];
        $returnData[$key]['created_time'] = date("Y-m-d H:i:s"); 
        $returnData[$key]['previous_received_date'] = $result[$key]['PurchaseOrderItem']['received_date']; 

        if(!empty($result[$key])){  
          $this->insertIntoInventoryTracking($returnData[$key]);
        } 
      }   
    return true;
  }

  public function insertIntoInventoryTracking($prevData){ 
    $prevInventoryData = $this->find('first',array('conditions'=>array('product_id'=>$prevData['product_id'],
      'store_location_id'=>$prevData['store_location_id']),'order'=>array('InventoryTracking.id'=>'DESC')));
    $saveData = array();
    $saveData['InventoryTracking'] = $prevData; 
    
    if(!empty($prevInventoryData)){
      $this->id = $prevInventoryData['InventoryTracking']['id'];
    }

    $this->save($saveData);
    $this->id = '';
    return true;
  } 

  public function updateTest($order_id){
    $result = $this->query('CALL set_inventory_tracking("'.$order_id.'");'); 
    if($result == true){
      debug("yes");
    }else{
      debug("no");
    }
  }
}
?>