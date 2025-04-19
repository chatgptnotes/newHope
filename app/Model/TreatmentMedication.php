<?php
/**
 * TreatmentMedication file
 * PHP 5
 * @author  	Swapnil Sharma
 * @created 	22.12.2015	
 */
class TreatmentMedication extends AppModel {

	public $name = 'TreatmentMedication';
	
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
    
    public function saveRecord($data=array()){
        if(empty($data)) return false;
        $treatmentMedicationDetail = ClassRegistry::init('TreatmentMedicationDetail');
        $session = new cakeSession();
        $data['created_by'] = $session->read('userid');
        $data['create_time'] = date('Y-m-d H:i:s');
        if($this->save($data)){
            $lastId = $this->id;
            foreach ($data['TreatmentMedicationDetail'] as $key => $val){
                $val['treatment_medication_id'] = $lastId;
                $val['created_time'] = $data['create_time'];
                $val['is_show'] = '1';
                $treatmentMedicationDetail->saveAll($val);
            }
            return $lastId;
        } 
    }
}	 
