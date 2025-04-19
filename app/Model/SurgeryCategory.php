<?php
class SurgeryCategory extends AppModel {

	public $name = 'SurgeryCategory';
	
        public $validate = array(
		        'name' => array(
			    'rule' => "notEmpty",
			    'message' => "Please enter name."
			    ),
                'description' => array(
			    'rule' => "notEmpty",
			    'message' => "Please enter description."
			    )
		        
                );
	
/**
 * for delete surgery subcategory.
 *
 */

      public function deleteSurgeryCategory($postData) {
      	$this->id = $postData['pass'][0];
      	$this->data["SurgeryCategory"]["id"] = $postData['pass'][0];
      	$this->data["SurgeryCategory"]["is_deleted"] = '1';
      	$this->save($this->data);
      	return true;
      }		
      
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
    
    function getServiceCategoryID(){
    	$session = new cakeSession();
    	$tariffList = ClassRegistry::init('TariffList');
    	$serviceCategory = ClassRegistry::init('ServiceCategory');
    	$tariffList->bindModel(array(
    			'belongsTo' => array(
    					'ServiceCategory' =>array('foreignKey'=>false,
    							'conditions'=>array('ServiceCategory.id = TariffList.service_category_id')),
    			)));
    	 
    	
    	$serviceLabel = Configure::read('ServiceCategoryLable');
    	$result = $tariffList->find("first",array("conditions"=>array("ServiceCategory.name"=>$serviceLabel,'ServiceCategory.location_id'=>$session->read('locationid')),'fields'=>array('TariffList.service_category_id')));
    	return $result['TariffList']['service_category_id'];
    }
	
}
?>