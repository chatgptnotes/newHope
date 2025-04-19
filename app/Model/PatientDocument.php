<?php
class PatientDocument extends AppModel {

	public $name = 'PatientDocument';
	var $useTable = 'patient_documents';
	
	
    public $specific = true;    		
	public $validate = array(
							/*	'name' => array(
									'rule' => "notEmpty",
									'message' => "Please enter Document name."
							),*/
							/*'document_description' => array(
									'rule' => "notEmpty",
									'message' => "Please enter Document Description."
							),*/	
							/*	'document_link' => array(
									'rule' => "notEmpty",
									'message' => "Please upload Document."
							),*/
							);
    
	
	public function __construct($id = false, $table = null, $ds = null) {		
		if(empty($ds)){
			$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
		}else{		
			$this->db_name =  $ds;
		}
		parent::__construct($id, $table, $ds);
	}
    /**
	 * function to get PatientDocument details
	 * @param  int $patient_id --> patient_id;
	 * @return array
	 * @author  Mahalaxmi
	 */  
    public function findPatientDocumentPatientData($patient_id=null,$documentId=null){
    	$this->bindModel(array(
				'belongsTo'=>array(								
							'User' => array('type'=>'Inner','foreignKey'=>false,'conditions'=> array('User.id=PatientDocument.created_by')),	
							'Patient' => array('type'=>'Inner','foreignKey'=>false,'conditions'=> array('Patient.id'=>$patient_id)),
				)),false);
    
    	return $this->find('first',array('fields'=>array('PatientDocument.*','CONCAT(User.first_name, " ", User.last_name) as fullname','Patient.lookup_name','Patient.admission_id','Patient.sex','Patient.age'),'conditions'=>array('PatientDocument.patient_id'=>$patient_id,'PatientDocument.id'=>$documentId)));
    }
    
   
}
?> 