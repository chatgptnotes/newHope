<?php
class PhysiotherapyAssessment extends AppModel {

	public $name = 'PhysiotherapyAssessment';
         public $actsAs = array('Cipher' => array('autoDecypt' => true,'cipher'=>array('physiotherapist_incharge','chief_complaints','observation'
	 ,'reflexes','motor','notes','chest_pt','limb_pt')));  		
 
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
 
        
	
}