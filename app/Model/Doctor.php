<?php
/**
 * DoctorsModel file
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
class Doctor extends AppModel {

	public $name = 'Doctor';
	var $useTable = 'users';
        
	
/**
 * association with city, state, country, role and initial table.
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
                                                 ),
                                  'Role' => array('className'    => 'Role',
                                                     'foreignKey'    => 'role_id'
                                                 ),
                                  'Initial' => array('className'    => 'Initial',
                                                     'foreignKey'    => 'initial_id'
                                                 )
                                  );
       public $hasOne = array('DoctorProfile' => array('className'    => 'DoctorProfile',
                                                  'foreignKey'    => 'user_id'
                                                 )
                                  
                                  );

       public $virtualFields = array(
    							'full_name' => 'CONCAT(Doctor.first_name, " ", Doctor.last_name)'
							);


/**
 * this code is executed after addition
 *
 */	
        public function saveDoctorProfile($postData) {
        	$dateFormat = ClassRegistry::init('DateFormatComponent');
        	 
              if(!empty($postData['DoctorProfile']['id'])) {
                           Classregistry::init('DoctorProfile')->id = $postData['DoctorProfile']['id'];
                           $this->data['DoctorProfile']['id'] = $postData['DoctorProfile']['id'];
                           $this->data['DoctorProfile']['doctor_name'] = $postData['DoctorProfile']['doctor_name'];
                           $this->data['DoctorProfile']['first_name'] = ucfirst($postData['DoctorProfile']['first_name']);
                           $this->data['DoctorProfile']['token_alphabet'] = $postData['DoctorProfile']['token_alphabet'];
                           $this->data['DoctorProfile']['middle_name'] = ucfirst($postData['DoctorProfile']['middle_name']);
                           $this->data['DoctorProfile']['last_name'] = ucfirst($postData['DoctorProfile']['last_name']);
                           $this->data['DoctorProfile']['charges'] = $postData['DoctorProfile']['charges'];
                           $this->data['DoctorProfile']['surgery_charges'] = $postData['DoctorProfile']['surgery_charges'];
                           $this->data['DoctorProfile']['anaesthesia_charges'] = $postData['DoctorProfile']['anaesthesia_charges'];
                           $this->data['DoctorProfile']['other_charges'] = $postData['DoctorProfile']['other_charges'];
                           $this->data['DoctorProfile']['education'] = $postData['DoctorProfile']['education'];
                           $this->data['DoctorProfile']['haspecility'] = $postData['DoctorProfile']['haspecility'];
                           $this->data['DoctorProfile']['specility_keyword'] = $postData['DoctorProfile']['specility_keyword'];
                           $this->data['DoctorProfile']['experience'] = $postData['DoctorProfile']['experience'];
                           $this->data['DoctorProfile']['department_id'] = $postData['DoctorProfile']['department_id'];
                           $this->data['DoctorProfile']['is_registrar'] = $postData['DoctorProfile']['is_registrar'];
                           $this->data['DoctorProfile']['profile_description'] = $postData['DoctorProfile']['profile_description'];
                           $this->data['DoctorProfile']['dateofbirth'] = $postData['DoctorProfile']['dateofbirth']; 
                           $this->data['DoctorProfile']['height_weight'] = $postData['DoctorProfile']['height_weight'];
                           $this->data['DoctorProfile']['bp'] = $postData['DoctorProfile']['bp'];
                           $this->data['DoctorProfile']['npi'] = $postData['DoctorProfile']['npi_no'];
                           $this->data['DoctorProfile']['dea'] = $postData['DoctorProfile']['dea'];
                           $this->data['DoctorProfile']['upin'] = $postData['DoctorProfile']['upin'];
                           $this->data['DoctorProfile']['state'] = $postData['DoctorProfile']['state'];  
                           $this->data['DoctorProfile']['caqh_provider_id'] = $postData['DoctorProfile']['caqh_provider_id'];
                           $this->data['DoctorProfile']['enrollment_status'] = $postData['DoctorProfile']['enrollment_status'];
                           $this->data['DoctorProfile']['licensure_type'] = $postData['DoctorProfile']['licensure_type'];
                           $this->data['DoctorProfile']['licensure_no'] = $postData['DoctorProfile']['licensure_no'];
                           //$this->data['DoctorProfile']['expiration_date'] = $postData['DoctorProfile']['expiration_date'];
                           $this->data['DoctorProfile']['present_event_color'] = $postData['DoctorProfile']['present_event_color'];
                           $this->data['DoctorProfile']['past_event_color'] = isset($postData['DoctorProfile']['past_event_color'])?$postData['DoctorProfile']['past_event_color']:'';
                           $this->data['DoctorProfile']['future_event_color'] = isset($postData['DoctorProfile']['future_event_color'])?$postData['DoctorProfile']['future_event_color']:'';
                           $this->data['DoctorProfile']['is_surgeon'] = $postData['DoctorProfile']['is_surgeon'];
               		       $this->data['DoctorProfile']['modified_by'] = AuthComponent::user('id');
               		       $this->data['DoctorProfile']['modify_time'] = date("Y-m-d H:i:s");
               		       if(!empty($postData["DoctorProfile"]['expiration_date'])){
               		       	$this->data["DoctorProfile"]['expiration_date'] = $postData["DoctorProfile"]['expiration_date'];
               		       		
               		       }
               		       
                           Classregistry::init('DoctorProfile')->save($this->data);

                          if(isset($postData['DoctorProfile']['first_name']) || isset($postData['DoctorProfile']['last_name']) || isset($postData['DoctorProfile']['middle_name']) || isset($postData['DoctorProfile']['dateofbirth'])) {
                           $this->data['User']['first_name'] = "'".ucfirst($postData['DoctorProfile']['first_name'])."'";
                           $this->data['User']['last_name'] = "'".ucfirst($postData['DoctorProfile']['last_name'])."'";
                           $this->data['User']['middle_name'] = "'".ucfirst($postData['DoctorProfile']['middle_name'])."'";
                           $this->data['User']['department_id'] = "'".$postData['DoctorProfile']['department_id']."'";
                           $this->data['User']['address1'] = "'".$postData['DoctorProfile']['address1']."'";
                           $this->data['User']['address2'] = "'".$postData['DoctorProfile']['address2']."'";
                           $this->data['User']['country_id'] = "'".$postData['DoctorProfile']['country_id']."'";
                           $this->data['User']['state_id'] = "'".$postData['DoctorProfile']['state_id']."'";
                           $this->data['User']['city_id'] = "'".$postData['DoctorProfile']['city_id']."'";
                           $this->data['User']['zipcode'] = "'".$postData['DoctorProfile']['zipcode']."'";
                           $this->data['User']['email'] = "'".$postData['DoctorProfile']['email']."'";
                           $this->data['User']['phone1'] = "'".$postData['DoctorProfile']['phone1']."'";
                           $this->data['User']['phone2'] = "'".$postData['DoctorProfile']['phone2']."'";
                           $this->data['User']['mobile'] = "'".$postData['DoctorProfile']['mobile']."'";
                           $this->data['User']['fax'] = "'".$postData['DoctorProfile']['fax']."'";                        
                           $this->data['User']['dob'] = "'".$postData['DoctorProfile']['dateofbirth']."'";
                           $this->data['User']['npi'] = "'".$postData['DoctorProfile']['npi']."'";
                           $this->data['User']['dea'] = "'".$postData['DoctorProfile']['dea']."'";
                           $this->data['User']['upin'] = "'".$postData['DoctorProfile']['upin']."'";
                           $this->data['User']['state'] = "'".$postData['DoctorProfile']['state']."'";
                           $this->data['User']['licensure_type'] = "'".$postData['DoctorProfile']['licensure_type']."'";
                           $this->data['User']['licensure_no'] = "'".$postData['DoctorProfile']['licensure_no']."'";
                           $this->data['User']['caqh_provider_id'] = "'".$postData['DoctorProfile']['caqh_provider_id']."'";
                           $this->data['User']['enrollment_status'] = "'".$postData['DoctorProfile']['enrollment_status']."'";
                           $this->data['User']['modified_by'] = "'".AuthComponent::user('id')."'";
               	           $this->data['User']['modify_time'] = "'".date("Y-m-d H:i:s")."'";
                           Classregistry::init('User')->unbindModel(array('belongsTo' => array('City', 'State', 'Country', 'Role', 'Initial')));
                           Classregistry::init('User')->updateAll($this->data['User'], array('User.id' => $postData['Doctor']['id']));
                          }
                }
                
                return true;
        }
/**
 * for delete doctor profile as well as in users table 
 *
 */

      public function deleteDoctor($postData) {
                        $this->id = $postData['pass'][0];
                        $this->data["Doctor"]["id"] = $postData['pass'][0];
                        $this->data["Doctor"]["is_deleted"] = '1';
                        $this->save($this->data);
                        // update doctor profile table //
                        Classregistry::init('DoctorProfile')->unbindModel(array('belongsTo' => array('Department', 'User')));
                        $this->data['DoctorProfile']['is_deleted'] = "'1'";
                        $this->data['DoctorProfile']['modified_by'] = "'".AuthComponent::user('id')."'";
               	        $this->data['DoctorProfile']['modify_time'] = "'".date("Y-m-d H:i:s")."'";
                        Classregistry::init('DoctorProfile')->updateAll($this->data['DoctorProfile'],array('DoctorProfile.user_id' => $postData['pass'][0]));

                        return true;
      }
      
       public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }     
    

}
?>