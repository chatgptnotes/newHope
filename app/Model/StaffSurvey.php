<?php
/**
 * StaffSurveyModel file
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
class StaffSurvey extends AppModel {

	public $name = 'StaffSurvey';
		
/**
 * association with users table.
 *
 */
	public $belongsTo = array('User' => array('className'    => 'User',
                                                  'foreignKey'    => 'user_id'
                                                 )
                                  );
    
/**
 * save staff survey
 *
 */	
        public function saveStaffSurveyQuest($postData) {
		                   $countQuest = 0;
						   for($i=0; $i<count($postData['StaffSurvey']['question_id']); $i++) {
						     $countQuest++;
						     $this->data['StaffSurvey']['question_id'] = $countQuest;
							 $this->data['StaffSurvey']['location_id'] = AuthComponent::user('location_id');
							 $this->data['StaffSurvey']['answer'] = $postData['StaffSurvey']['question_id'][$countQuest];
							 $this->data['StaffSurvey']['user_id'] = AuthComponent::user('id');
							 $this->data['StaffSurvey']['create_time'] = $postData['StaffSurvey']['create_time'];
							 $this->data['StaffSurvey']['created_by'] = AuthComponent::user('id');
							 $this->data['StaffSurvey']['modified_by'] = AuthComponent::user('id');
							 Classregistry::init('StaffSurvey')->save($this->data);
							 Classregistry::init('StaffSurvey')->id = false;
						   }
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