<?php
/**
 * AutoCompletesController file
 *
 * PHP 5
 * 
 *
 * @copyright     Copyright 2015 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       DrM
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram (PUT ALL AUTOCOMPLETE HERE)
 */
class AutoCompletesController extends Controller {
	public $name = 'AutoCompletes';
	public $uses = false;
	public $helpers = array('Html','Form', 'Js','Session','Navigation','DateFormat', 'WorldTime');
	public $components = array('RequestHandler','Email','Auth','Session','Acl','DateFormat','AclFilter',"Menu",'DebugKit.Toolbar');
	public $autocompleteActionsComponent = array('autocompleteForPatient'=>array('Auth'),'autocompleteForService'=>array('Auth','Session','DateFormat'),
			'lab_dashboard'=>array('Auth','DateFormat','Session')
	);
	public $autocompleteActionsHelper = array('lab_dashboard'=>array ('Html','Form','Js','DateFormat','General','Paginator')
	);
	public $autoCompleteComponentLoader = array(
			'default'=>array('autocompleteForService','autocompleteForPatient'),
			'session'=> array(''),
			'date'=> array(''),
			'dateSession'=> array('lab_dashboard'),
			'exceptionsForAjaxMenu'=>array('loadPermissions')
	);
	public $autoCompleteHelperLoader = array(
			'default'=>array('autocompleteForService','autocompleteForPatient'),
			'session'=> array(''),
			'date'=> array(''),
			'dateSession'=> array('lab_dashboard'),
			'exceptionsForAjaxMenu'=>array('loadPermissions')
	);
	
	
	
	 public function beforeFilter() {
		if ($this->request->is('ajax')) {
			if(!$this->Auth->user()){
				return;
			}
		}
	} 
	/**
	 * @author Pawan Meshram
	 * This Autocomplete is used on Lab Manager Dashboard to search services
	 */
	function autocompleteForService() {
		$this->autoRender = false;
		$this->layout = false;
		$this->uses = array (
				'Laboratory','labDashboardServiceSearch'
		);
	
		$searchKey = $this->params->query;
		$result = $this->Laboratory->query('select * from labDashboardServiceSearch as Laboratory where Laboratory.name  LIKE "%'.$searchKey[term].'%" group by Laboratory.id order by laboratory.name asc');
		foreach ( $result as $key => $value ) {
			$returnArray [] = array (
					'id' => $value ['Laboratory'] ['id'],
					'value' => $value ['Laboratory'] ['name']
			);
		}
		echo json_encode ( $returnArray );
		exit ();
	}
	
	/**
	 * @author Pawan Meshram
	 * This Autocomplete is used on Lab Manager Dashboard to search patients
	 */
	function autocompleteForPatient() {
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->isAutocomplete = true;
		$this->uses = array ( 'LaboratoryTestOrder' );
		$searchKey = $this->params->query;
		$this->LaboratoryTestOrder->bindModel ( array (
				'belongsTo' => array (
						'Patient' => array (
								'foreignKey' => false,
								'conditions' => array (
										'LaboratoryTestOrder.patient_id = Patient.id'
								)
						)
				)
		) );
		$result = $this->LaboratoryTestOrder->query('select * from  labDashboardPatientSearch as Patient where Patient.lookup_name  LIKE "%'.$searchKey[term].'%"  GROUP BY `Patient`.`id` ORDER BY `Patient`.`lookup_name` ASC');
		foreach ( $result as $key => $value ) {
				
			$returnArray [] = array (
					'id' => $value ['Patient'] ['id'],
					'value' => $value ['Patient'] ['lookup_name'] . ' ' . '(' . $value ['Patient'] ['admission_id'] . ')'
			);
		}
		echo json_encode ( $returnArray );
		exit ();
	}
	
	/**
	 * @author Pawan Meshram
	 * This Autocomplete is used on Lab Manager Dashboard to search patients
	 */
	/*public function admissionComplete(){
		$this->layout = "ajax";
		$this->uses = array('Patient');
		$conditions =array();
		$searchKey = $this->params->query['term'] ;
		//$conditions["Patient.admission_id like"] = $searchKey."%";
		$testArray = $this->Patient->query('select * from billingPatientSearch as Patient where Patient.admission_id  LIKE "'.$searchKey.'%"');
		/* $testArray = $this->Patient->find('list', array('fields'=> array('Patient.id', 'Patient.admission_id'),'conditions'=>array($conditions,
		 'Patient.is_deleted=0','Patient.admission_type'=>array('IPD','OPD','LAB','RAD')),'order'=>array("Patient.lookup_name ASC"))); * /
		foreach ($testArray as $key=>$value) {
			$returnArray[]=array('id'=>$value['Patient']['id'],'value'=>$value['Patient']['admission_id']);
		}
		echo json_encode($returnArray);
		exit;
	
	}*/
        
        /**
	 * @author Pawan Meshram
	 * This Autocomplete is used on Lab Manager Dashboard to search patients
	 */
	function autocompleteForAdmissionID() {
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->isAutocomplete = true;
		$this->uses = array ( 'LaboratoryTestOrder' );
		$searchKey = $this->params->query;
		$this->LaboratoryTestOrder->bindModel ( array (
				'belongsTo' => array (
						'Patient' => array (
								'foreignKey' => false,
								'conditions' => array (
										'LaboratoryTestOrder.patient_id = Patient.id'
								)
						)
				)
		) );
		$result = $this->LaboratoryTestOrder->query('select * from  labDashboardPatientSearch as Patient where Patient.admission_id  LIKE "%'.$searchKey[term].'%"  GROUP BY `Patient`.`id`');
		foreach ( $result as $key => $value ) {
				
			$returnArray [] = array (
					'id' => $value ['Patient'] ['id'],
					'value' => $value ['Patient'] ['admission_id'] . ' ' . '(' . $value ['Patient'] ['lookup_name'] . ')'
			);
		}
		echo json_encode ( $returnArray );
		exit ();
                
        }
        
        /**
	 * @author Pawan Meshram
	 * This Autocomplete is used on Lab Manager Dashboard to search templates
	 */
	function autocompleteForHistoTemplates($departmentId=null) {
		$this->layout = 'ajax';
		$this->uses = array ( 'DoctorTemplate' );
		$searchKey = $this->params->query['term'];
                if($searchKey){
                    $conditions['DoctorTemplate.template_name LIKE '] = "%$searchKey%";
                }
                if($departmentId){
                    $conditions['DoctorTemplate.department_id'] = $departmentId;
                }
                $conditions['DoctorTemplate.template_type'] = "histo_pathology";
                $this->DoctorTemplate->unbindModel ( array (
				'belongsTo' => array ('User','Location'
                                    )));
		$this->DoctorTemplate->bindModel ( array (
				'belongsTo' => array (
						'DoctorTemplateText' => array (
								'foreignKey' => false,
								'conditions' => array (
										'DoctorTemplate.id = DoctorTemplateText.template_id'
                                                                )
						)
				)
		) );
		$result = $this->DoctorTemplate->find('all',array('fields'=>array('DoctorTemplate.template_name','DoctorTemplateText.template_text'),
                    'conditions'=>$conditions));
		//dpr($departmentId);exit;
                foreach ( $result as $key => $value ) {
			$returnArray [] = array (
					'value' => $value ['DoctorTemplate'] ['template_name'],
					'id' => $value ['DoctorTemplateText'] ['template_text']
			);
		}
		echo json_encode ( $returnArray );
		exit ();
                
        }
}