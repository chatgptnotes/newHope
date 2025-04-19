<?php
/**
 * FacilityModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope Hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class Facility extends AppModel {

	public $name = 'Facility';
/**
 * Facility table binding with city , state and country tables
 *
 */	
        public $belongsTo = array('City' => array('className'    => 'City',
                                                  'foreignKey'    => 'city_id'
                                                 ),
                                  'State' => array('className'    => 'State',
                                                   'foreignKey'    => 'state_id'
                                                 ),
                                  'Country' => array('className'    => 'Country',
                                                     'foreignKey'    => 'country_id'
                                                 )
                                 );
								 
		public $hasOne = array('FacilityDatabaseMapping' => array('className'    => 'FacilityDatabaseMapping',
                                                  'foreignKey'    => 'facility_id'
                                                 ),
                                'FacilityUserMapping' => array('className'    => 'FacilityUserMapping',
                                                  'foreignKey'    => 'facility_id'
                                                 ),
                                 );
        
/**
 * server side validation
 *
 */	
		
	public $validate = array(
		'name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter name."
			),
		'address1' => array(
			'rule' => "notEmpty",
			'message' => "Please enter address."
			),
		'zipcode' => array(
			'rule' => "notEmpty",
			'message' => "Please enter zip."
			),
                'country_id' => array(
			'rule' => "notEmpty",
			'message' => "Please select country."
			),
                'state_id' => array(
			'rule' => "notEmpty",
			'message' => "Please select state."
			),
                'city_id' => array(
			'rule' => "notEmpty",
			'message' => "Please select city."
			),
                'email' => array(
			'rule' => "notEmpty",
			'message' => "Please enter email."
			),
                'phone1' => array(
			'rule' => "notEmpty",
			'message' => "Please enter phone1."
			),
                'mobile' => array(
			'rule' => "notEmpty",
			'message' => "Please enter mobile."
			),
                'fax' => array(
			'rule' => "notEmpty",
			'message' => "Please enter fax."
			),
                'contactperson' => array(
			'rule' => "notEmpty",
			'message' => "Please enter contact person."
			),
                'maxlocations' => array(
			'rule' => "notEmpty",
			'message' => "Please enter maximum locations."
			)
                );

	
/**
 * history of every update and delete
 *
 */
       
       public function beforeSave() {
            if(($this->data['Facility']['id']) && !($this->data['Facility']['is_deleted'])) {
             $arrayKeys = array_keys($_REQUEST);
             $actionUrl = $arrayKeys[0];
             $getOldVal = $this->find('first', array('order' => array('Facility.create_time DESC'), 'conditions' => array('Facility.id' => $this->data['Facility']['id']), 'recursive' => -1));
             $auditdata['AuditTrail']['user_id'] = AuthComponent::user('id');
             $auditdata['AuditTrail']['model_id'] = $this->data['Facility']['id'];
             $auditdata['AuditTrail']['controller_name'] = $actionUrl;
             $auditdata['AuditTrail']['controller_action'] = "edit";
             $auditdata['AuditTrail']['old_value'] = serialize($getOldVal);
             $auditdata['AuditTrail']['new_value'] = serialize($this->data);
             $auditdata['AuditTrail']['create_time'] = date("Y-m-d H:i:s");
             Classregistry::init('AuditTrail')->save($auditdata);
             
            }
            if(($this->data['Facility']['id']) && isset($this->data['Facility']['is_deleted'])) {
             $arrayKeys = array_keys($_REQUEST);
             $actionUrl = $arrayKeys[0];
             $getCurrentVal = $this->find('first', array('order' => array('Facility.create_time DESC'), 'conditions' => array('Facility.id' => $this->data['Facility']['id']),'recursive' => -1));
             $auditdata['AuditTrail']['user_id'] = AuthComponent::user('id');
             $auditdata['AuditTrail']['model_id'] = $this->data['Facility']['id'];
             $auditdata['AuditTrail']['controller_name'] = $actionUrl;
             $auditdata['AuditTrail']['controller_action'] = "delete";
             $auditdata['AuditTrail']['old_value'] = serialize($getCurrentVal);
             $auditdata['AuditTrail']['create_time'] = date("Y-m-d H:i:s");
             Classregistry::init('AuditTrail')->save($auditdata);
            
            }
            return true;
       }

/**
 * save to location table just after hospitals add
 *
 */
 

	public function addDeafaultLocation($db,$id,$data) {
		 $db_connection = new DrmhopeDB($db);
	  	 $location = Classregistry::init('Location');
         $db_connection->makeConnection($location);				
    	 $facility = $this->find("first",array("conditions"=>array("Facility.id"=>$id)));
         $locationdata['Location']['name'] =$facility['Facility']['name'];
         $locationdata['Location']['alias'] = $facility['Facility']['alias'];
         $locationdata['Location']['address1'] =$facility['Facility']['address1'];
         $locationdata['Location']['address2'] = $facility['Facility']['address2'];
         $locationdata['Location']['zipcode'] = $facility['Facility']['zipcode'];
         $locationdata['Location']['city_id'] = $facility['Facility']['city_id'];
         $locationdata['Location']['state_id'] = $facility['Facility']['state_id'];
         $locationdata['Location']['country_id'] = $facility['Facility']['country_id'];
         $locationdata['Location']['email'] = $facility['Facility']['email'];
         $locationdata['Location']['phone1'] = $facility['Facility']['phone1'];
         $locationdata['Location']['phone2'] =$facility['Facility']['phone2'];
         $locationdata['Location']['mobile'] = $facility['Facility']['mobile'];
         $locationdata['Location']['fax'] =$facility['Facility']['fax'];
         $locationdata['Location']['contactperson'] =$facility['Facility']['contactperson'];
         $locationdata['Location']['is_active'] = $facility['Facility']['is_active'];
         $locationdata['Location']['currency_id'] = $data['Facility']['currency_id'];
         $locationdata['Location']['create_time'] = date("Y-m-d H:i:s");
         $location->save($locationdata);
         return true;
       } 
       
       

       
}
?>