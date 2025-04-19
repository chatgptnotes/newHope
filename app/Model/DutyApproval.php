<?php
/**
 * Shift file
 *
 * PHP 5 
 * @author        Swapnil Sharma
 * @createdOn	  20.02.2016	
 */
class DutyApproval extends AppModel {

	public $name = 'DutyApproval'; 
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
    
    //function to insert/update shift
    public function saveDutyApproval($year,$month,$approval){
        if(empty($year) || empty($month)) return false; 
        $session = new cakeSession();
        $prevData = $this->find('first',array(
            'conditions'=>array('YEAR(record_date)'=>$year,'MONTH(record_date)'=>$month,'location_id'=>$session->read('locationid'))));  
        $data['record_date'] = date("$year-$month-d");
        $data['is_approved'] = $approval;
        if(!empty($prevData['DutyApproval']['id'])){
            $this->id = $prevData['DutyApproval']['id'];
            $data['modified_by'] = $session->read('userid'); 
            $data['modified_time'] = date("Y-m-d H:i:s");
        }else{ 
            $data['created_by'] = $session->read('userid');
            $data['location_id'] = $session->read('locationid');
            $data['created_time'] = date("Y-m-d H:i:s"); 
        }
        if($this->save($data)){
            return true;
        } 
    } 
    
    //check the approval
    public function checkApproval($year,$month){
        $session = new cakeSession();
        $data = $this->find('first',array('fields'=>array('is_approved'),'conditions'=>array('YEAR(record_date)'=>$year,'MONTH(record_date)'=>$month,'location_id'=>$session->read('locationid'))));
        return $data['DutyApproval']['is_approved'];
    }
}