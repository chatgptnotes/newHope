<?php
/**
 * RadiologyDoctorNote model
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       LaboratoryParameter Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj wanjari
 * @functions 	 : AE RadiologyDoctorNote	
 */
class RadiologyDoctorNote extends AppModel {
	public $name = 'RadiologyDoctorNote'; 
	
	function insertDoctorsNote($data=array()){
		$session = new cakeSession();
	    $data['RadiologyDoctorNote']['location_id'] = $session->read('locationid');
	    //enter doctor's id after checking logged in user's role
	    $curRole = $session->read('role') ;
	    if(strtotime($curRole)=='treating consultant'){
	    	$data['RadiologyDoctorNote']['doctor_id'] = $session->read('userid');	
	    }	    
	    
		if(empty($data['RadiologyDoctorNote']['id'])){
			$data['RadiologyDoctorNote']['created_by'] = $session->read('userid');
			$data['RadiologyDoctorNote']['create_time'] = date("Y-m-d H:i:s");
		}else{
			  
			$data['RadiologyDoctorNote']['modified_by'] = $session->read('userid');
			$data['RadiologyDoctorNote']['modify_time'] = date("Y-m-d H:i:s");
		}  
		$result =  $this->save($data['RadiologyDoctorNote']); 
		return $result ;
	}
 public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    } 	
}