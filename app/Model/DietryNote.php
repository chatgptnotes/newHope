<?php
class DietryNote extends AppModel {

	public $name = 'DietryNote';
        		
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }

	public $belongsTo = array(
		'DietaryAssessment' => array(
			'className' => 'DietaryAssessment',
			'foreignKey' => 'dietry_assessment_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}