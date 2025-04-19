<?php
class PatientDocumentType extends AppModel {

	public $name = 'PatientDocumentType';
    public $specific = true;    		
	
    
	
	function __construct($id = false, $table = null, $ds = null) {
	        $session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	        parent::__construct($id, $table, $ds);
    }  
  /**
   * get list of document type
   * @return list
   */  
    public function getDocumentType(){
    	$subCategoryList = $this->find('list',array(
    			'fields'=>array('id','name'),
    			'order'=>array('PatientDocumentType.name'=>'asc')));
    	
    	return $subCategoryList;
    
    }
   
}
?> 