<?php
class DietaryAssessment extends AppModel {

	public $name = 'DietaryAssessment';
        		
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }

	public $hasMany = array(
		'DietryNote' => array(
			'className' => 'DietryNote',
			'foreignKey' => 'dietry_assessment_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)	
	); 
}