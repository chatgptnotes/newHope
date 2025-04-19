<?php
/**
 * InsuranceCompanies Controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       InsuranceCompany .Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class InsuranceCompany extends AppModel {
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
                'insurance_type_id' => array(
			'rule' => "notEmpty",
			'message' => "Please select insurance company type."
			),
                'name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter insurance company name."
			),
                'address' => array(
			'rule' => "notEmpty",
			'message' => "Please enter address."
			),
		'country_id' => array(
			'rule' => "notEmpty",
			'message' => "Please select country."
			),
		'state_id' => array(
			'rule' => "notEmpty",
			'message' => "Please select state."
			),
                'city_id' => array(
			'rule' => "notEmpty",
			'message' => "Please select city."
			),
                'zip' => array(
			'rule' => "notEmpty",
			'message' => "Please enter zip."
			),
                'phone' => array(
			'rule' => "notEmpty",
			'message' => "Please enter phone."
			),
                'fax' => array(
			'rule' => "notEmpty",
			'message' => "Please enter fax."
			),
                'email' => array(
			'rule' => "notEmpty",
			'message' => "Please enter email address."
			)
                );

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'city_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'state_id',
			
		),
                'Country' => array(
			'className' => 'Country',
			'foreignKey' => 'Country_id',
			
		)
	);

      public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
	  	if(empty($ds)){
        	$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	 	}else{
	 		$this->db_name =  $ds;
	 	}
        parent::__construct($id, $table, $ds);
    }  
    
	public function getInsuranceCompanyByID($id=null){
      	if(!$id) return ;
      	
      	$result  = $this->find('first',array('fields'=>array('name'),'conditions'=>array('InsuranceCompany.id'=>$id)));
      	return $result['InsuranceCompany']['name']; 
      	
      }
}

?>
