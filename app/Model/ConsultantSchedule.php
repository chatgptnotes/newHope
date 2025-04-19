<?php
class ConsultantSchedule extends AppModel {

	public $name = 'ConsultantSchedule';
	
	

	public $belongsTo = array('Consultant' => array('className'    => 'Consultant',
                                                  'foreignKey'    => 'consultant_id'
                                                 )
                                  );
/**
 * save appointment time of  consultant
 *
 */	
        public function saveConsultantSchedule($postData) {
            $consultantid = $postData['consultantid'];
            
            foreach($postData['schedule'] as $keyindex => $valindex) {
                          foreach($valindex as $key => $val) {
                             foreach($val as $keyactual => $valactual) {
                             	$startTime = $postData['schedule'][$keyindex]['startdate'][$keyactual];
                             	$endTime = $postData['schedule'][$keyindex]['enddate'][$keyactual];
                             	$dateVal = $keyactual;
                            }
                          }
                 
                   if(!empty($startTime) && !empty($endTime)) {
                          $this->data['ConsultantSchedule']['consultant_id'] = $consultantid;
                          $this->data['ConsultantSchedule']['schedule_date'] = date("Y-m-d", strtotime(str_replace("_","-",$dateVal)));
                          $this->data['ConsultantSchedule']['schedule_time'] = $startTime;
                          $this->data['ConsultantSchedule']['end_schedule_time'] = $endTime;
                          $this->data['ConsultantSchedule']['created_by'] = AuthComponent::user('id');
                          $this->data['ConsultantSchedule']['create_time'] = date("Y-m-d H:i:s");
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