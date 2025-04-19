<?php
/**
 * OtReplace file
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
class OtReplace extends AppModel {
	
	public $name = 'OtReplace';
    public $tableName = "ot_replace";
	public $hasMany = array(
		'OtReplaceDetail' => array(
		'className' => 'OtReplaceDetail',
		'dependent' => true,
		'foreignKey' => 'ot_replace_id',
	    'order' => 'ot_item_category_id DESC'
		)
	);  
	  public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
	
	public function saveDetails($data){
		// check if category and item id does not exist in master then insert the value //
		$getOtCategoriesArray = Classregistry::init('OtItemCategory')->find('all',
							 array('conditions' => array('OtItemCategory.is_deleted' => 0, 'OtItemCategory.is_deleted' => AuthComponent::user('location_id'))
							       ));
		//$getOtItemIdArray = Classregistry::init('PharmacyItem')->find('all',
		//					 array('conditions' => array('PharmacyItem.is_deleted' => 0, 'PharmacyItem.is_deleted' => AuthComponent::user('location_id'))
		//					       ));
        foreach($getOtCategoriesArray as $getOtCategoriesArrayVal) {
        	$getOtCategories[] = $getOtCategoriesArrayVal['OtItemCategory']['id'];
        }
        
		foreach($data['item_id'] as $key => $value){	
			$createTime = date("Y-m-d H:i:s"); 
			if(!($data['item_id'][$key]) && !($data['category_id'][$key]) ) { 
				// if category and item does not exist in their repective table then insert category and item both //
				
				Classregistry::init('OtItemCategory')->set(array('name' => $data['category'][$key],
				                                                 'location_id' => AuthComponent::user('location_id'),
                                                                 'created_by' => AuthComponent::user('id'),
				                                                 'create_time' =>$createTime,
                                                           ));
                Classregistry::init('OtItemCategory')->save();
                Classregistry::init('PharmacyItem')->set(array('name' => $data['item_name'][$key],
                                                               'location_id' => AuthComponent::user('location_id'),
                                                               'created_by' => AuthComponent::user('id'),
				                                               'create_time' => $createTime,
                                                           ));
                Classregistry::init('PharmacyItem')->save();
				$data['category_id'][$key] = Classregistry::init('OtItemCategory')->getLastInsertID();
				$getPharmacyId = Classregistry::init('PharmacyItem')->getLastInsertID();
				Classregistry::init('OtItem')->set(array('ot_item_category_id' => $data['category_id'][$key],
                                                         'pharmacy_item_id' => $getPharmacyId,
				                                         'location_id' => AuthComponent::user('location_id'),
				                                         'created_by' => AuthComponent::user('id'),
				                                         'create_time' => $createTime,
                                                         ));
                Classregistry::init('OtItem')->save();
                $data['item_id'][$key] = Classregistry::init('OtItem')->getLastInsertID();
                Classregistry::init('OtItemCategory')->id = false;
                Classregistry::init('PharmacyItem')->id = false;
                Classregistry::init('OtItem')->id = false;
         	} 
         	if(!($data['item_id'][$key]) && ($data['category_id'][$key])) {
				// if item does not exist in their repective table then insert item  //
				
				Classregistry::init('PharmacyItem')->set(array('name' => $data['item_name'][$key],
				                                               'location_id' => AuthComponent::user('location_id'),
                                                               'created_by' => AuthComponent::user('id'),
				                                               'create_time' => $createTime,
                                                           ));
                Classregistry::init('PharmacyItem')->save();
				$getPharmacyId = Classregistry::init('PharmacyItem')->getLastInsertID();
				Classregistry::init('OtItem')->set(array('ot_item_category_id' => $data['category_id'][$key],
                                                         'pharmacy_item_id' => $getPharmacyId,
				                                         'location_id' => AuthComponent::user('location_id'),
				                                         'created_by' => AuthComponent::user('id'),
				                                         'create_time' => $createTime,
                                                         ));
                Classregistry::init('OtItem')->save();
                $data['item_id'][$key] = Classregistry::init('OtItem')->getLastInsertID();
                Classregistry::init('PharmacyItem')->id = false;
                Classregistry::init('OtItem')->id = false;
			}
		}				       
							       
		foreach($data['item_id'] as $key => $value){
			 if(!isset($data['OtReplaceDetail'][$key])){
			 	$datum[$key]['ot_item_category_id'] = $data['category_id'][$key];
				$datum[$key]['item_id'] = $data['item_id'][$key];
				$datum[$key]['date'] =  DateFormatComponent::formatDate2STD($data['date'][$key],Configure::read('date_format'));
				$datum[$key]['request_quantity'] = $data['qty'][$key];
				$datum[$key]['recieved_quantity'] = $data['recieved_quantity'][$key];
				$datum[$key]['recieved_date'] =DateFormatComponent::formatDate2STD($data['recieved_date'][$key],Configure::read('date_format')); 
				$datum[$key]['used_quantity'] = $data['used_quantity'][$key];
				$datum[$key]['return_date'] = DateFormatComponent::formatDate2STD($data['return_date'][$key],Configure::read('date_format'));  
				$datum[$key]['return_quantity'] = $data['return_quantity'][$key];
				
			 }
		} 
		 
 		 return $datum;
	}
	public function updateDetails($data){
		foreach($data['OtReplaceDetail'] as $key => $value){
		 if(isset($data['OtReplaceDetail'][$key])){
		 		$this->OtReplaceDetail->id =  $data['OtReplaceDetail'][$key]; 
				$datum['OtReplaceDetail']['date'] =  DateFormatComponent::formatDate2STD($data['date'][$key],Configure::read('date_format'));
				$datum['OtReplaceDetail']['request_quantity'] = $data['qty'][$key];
				$datum['OtReplaceDetail']['recieved_quantity'] = $data['recieved_quantity'][$key];
				$datum['OtReplaceDetail']['recieved_date'] =DateFormatComponent::formatDate2STD($data['recieved_date'][$key],Configure::read('date_format')); 
				$datum['OtReplaceDetail']['used_quantity'] = $data['used_quantity'][$key];
				$datum['OtReplaceDetail']['return_date'] = DateFormatComponent::formatDate2STD($data['return_date'][$key],Configure::read('date_format'));  
				$datum['OtReplaceDetail']['return_quantity'] = $data['return_quantity'][$key]; 
				$this->OtReplaceDetail->save($datum);
			 }
	  	}
	}
}
?>