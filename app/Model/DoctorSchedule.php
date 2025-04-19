<?php
class DoctorSchedule extends AppModel {

	public $name = 'DoctorSchedule';
	public $belongsTo = array('DoctorProfile' => array('className'    => 'DoctorProfile',
                                                  'foreignKey'    => 'doctor_id'
                                                 )
                                  );
/**
 * save appointment time of  doctor
 *
 */	
        public function saveDoctorSchedule($postData) {
            $doctid = $postData['doctid'];
            
            foreach($postData['schedule'] as $keyindex => $valindex) {
                          foreach($valindex as $key => $val) {
                             foreach($val as $keyactual => $valactual) {
                            $startTime = $postData['schedule'][$keyindex]['startdate'][$keyactual];
                            $endTime = $postData['schedule'][$keyindex]['enddate'][$keyactual];
                            $dateVal = $keyactual;
                            }
                          }
                 
                   if(!empty($startTime) && !empty($endTime)) {
                          $this->data['DoctorSchedule']['doctor_id'] = $doctid;
                          $this->data['DoctorSchedule']['schedule_date'] = date("Y-m-d", strtotime(str_replace("_","-",$dateVal)));
                          $this->data['DoctorSchedule']['schedule_time'] = $startTime;
                          $this->data['DoctorSchedule']['end_schedule_time'] = $endTime;
                          $this->data['DoctorSchedule']['created_by'] = AuthComponent::user('id');
                          $this->data['DoctorSchedule']['create_time'] = date("Y-m-d H:i:s");
                          $this->save($this->data);
                          $this->id = false;
                          
                   }
                          
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