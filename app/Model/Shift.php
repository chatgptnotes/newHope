<?php
/**
 * Shift file
 *
 * PHP 5 
 * @author        Swapnil Sharma
 * @createdOn	  13.02.2016	
 */
class Shift extends AppModel {

	public $name = 'Shift'; 
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
    
    //function to insert/update shift
    public function saveShift($data){
        if(empty($data['name'])) return false;
        $session = new cakeSession(); 
        if(!empty($data['id'])){
            $this->id = $data['id'];
            $data['modified_by'] = $session->read('userid'); 
            $data['modified_time'] = date("Y-m-d H:i:s");
        }else{ 
            $data['created_by'] = $session->read('userid');
            $data['location_id'] = $session->read('locationid');
            $data['create_time'] = date("Y-m-d H:i:s"); 
        }
        if($this->save($data)){
            return true;
        } 
    }
    
    public function getAllShifts(){
        return $this->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_active'=>'1')));
    }
    
    public function getAllShiftDetails(){
        return $this->find('all',array('conditions'=>array('is_active'=>'1')));
    }
    
}