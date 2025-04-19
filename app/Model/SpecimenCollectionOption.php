<?php
/**
 * Specimen Collection Option Model
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       SpecimenCollectionOption Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
class SpecimenCollectionOption extends AppModel {

	public $specific = true;
	public $name = 'SpecimenCollectionOption';
	
	function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds)){
        	$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	 	}else{
	 		$this->db_name =  $ds;
	 	}
		parent::__construct($id, $table, $ds);
	}
	
	public function getSpecimenOptions($laboratoryId){
		$specimenOptions = $this->find('list',array('fields'=>array('id','name'),'conditions'=>array('SpecimenCollectionOption.laboratory_id'=>$laboratoryId,'SpecimenCollectionOption.is_deleted'=>'0')));
		$laboratoryModel = ClassRegistry::init('Laboratory');
		$laboratoryData = $laboratoryModel->find('first',array('fields'=>array('id','specimen_collection_type'),'conditions'=>array('Laboratory.id'=>$laboratoryId)));
		return array($specimenOptions,$laboratoryData['Laboratory']['specimen_collection_type']);
	} 
	
}