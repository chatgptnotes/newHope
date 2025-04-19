<?php
class InventoryOutward extends AppModel {

	 public $name = 'InventoryOutward';
     public $useTable = "inventory_outwards";
          public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
    public function saveOutward($responsedata,$id){
        $errors = array();
        $item_rate_master = Classregistry::init('PharmacyItem');
        $outward_detail = Classregistry::init('InventoryOutwardDetail');
        if(count($responsedata['item_id'])>0){
            foreach($responsedata['item_id'] as $key => $value){
                $data['inventory_outward_id'] = $id;
                $data['outward'] = (double)$responsedata['outward'][$key];
               	$item = $item_rate_master->find('first',array('conditions' =>array("PharmacyItem.id"=>$value )));
                $stock = (double)$item['PharmacyItem']['stock'];
                $data['current_stock'] =  $stock;
                $data['item_id'] =  $value;
                $outward_detail->create();
                $outward_detail->save($data);
                $item['PharmacyItem']['stock'] = $stock - $data['outward'];
                $item_rate_master->save($item);
                $errors = $item_rate_master->invalidFields();
            }

        }
            return $errors;
    }

 public function updateOutward($responsedata){
        $errors = array();
        $item_rate_master = Classregistry::init('PharmacyItem');
        $outward_detail = Classregistry::init('InventoryOutwardDetail');
        foreach($responsedata['outwarddetail'] as $key => $value){

            $outward = $outward_detail->find('first',array('conditions' =>array("InventoryOutwardDetail.id"=>$value )));
           	$item = $item_rate_master->find('first',array('conditions' =>array("PharmacyItem.id"=>$value )));

            $stock = (double)$outward['InventoryOutwardDetail']['current_stock'];
            $outward['InventoryOutwardDetail']['outward'] = (double)$responsedata['preoutward'][$key];

             $outward_detail->save($outward);
            $item['PharmacyItem']['stock'] = $stock - (double)$responsedata['preoutward'][$key];
           $item_rate_master->save($item);
            $errors = $item_rate_master->invalidFields();
        }
            return $errors;


    }
}
?>