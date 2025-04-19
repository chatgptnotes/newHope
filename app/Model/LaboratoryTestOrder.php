<?php
/**
 * LaboratoryTestOrder model
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 Drmhope Softwares.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       LaboratoryParameter Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gaurav Chauriya
 * @functions 	 : Add test respective to patient
 */
class LaboratoryTestOrder extends AppModel {
	public $name = 'LaboratoryTestOrder';
	/*
	 * public $hasMany = array(
	 * 'LaboratoryParameter' => array(
	 * 'className' => 'LaboratoryParameter'
	 * )
	 * );
	 */
	public $specific = true;
	//public $actsAs = array ('Auditable' );
	function __construct($id = false, $table = null, $ds = null) {
		if (empty ( $ds )) {
			$session = new cakeSession ();
			$this->db_name = $session->read ( 'db_name' );
		} else {
			$this->db_name = $ds;
		}
		parent::__construct ( $id, $table, $ds );
	}
	function beforeFind($queryData){
		$queryData['conditions']['LaboratoryTestOrder.is_deleted']='0';
		return $queryData;
	}
	// insert test order per patient
	function insertTestOrder($data = array(), $action = 'insert') {
		$session = new cakeSession ();
		$laboratoryToken = ClassRegistry::init ( 'LaboratoryToken' );
		$Laboratory = ClassRegistry::init ( 'Laboratory' );
		$data ['LaboratoryTestOrder'] ['batch_identifier'] = time (); // maintaining for grouping tests those at once .
		if (empty ( $data ['LaboratoryTestOrder'] ['id'] )) {
			$orderArr ['created_by'] = $session->read ( 'userid' );
			$orderArr ['create_time'] = date ( "Y-m-d H:i:s" );
			$LaboratTest ['created_by'] = $session->read ( 'userid' );
			$LaboratTest ['create_time'] = date ( "Y-m-d H:i:s" );
		} else {
			$this->id = $data ['LaboratoryTestOrder'] ['id'];
			$orderArr ['modified_by'] = $session->read ( 'userid' );
			$orderArr ['modify_time'] = date ( "Y-m-d H:i:s" );
			$LaboratTest ['modified_by'] = $session->read ( 'userid' );
			$LaboratTest ['modify_time'] = date ( "Y-m-d H:i:s" );
		}
		$orderArr ['location_id'] = $session->read ( 'locationid' );
		$orderArr ['patient_id'] = $data ['LaboratoryTestOrder'] ['patient_id'];
		$orderArr ['id'] = $data ['LaboratoryTestOrder'] ['id'];
		$orderArr ['is_external'] = $data ['LaboratoryTestOrder'] ['is_external'];
		$orderArr ['service_provider_id'] = $data ['LaboratoryTestOrder'] ['service_provider_id'];
		$orderArr ['batch_identifier'] = $data ['LaboratoryTestOrder'] ['batch_identifier'];
		$orderArr ['service_provider_id'] = $data ['LaboratoryTestOrder'] ['service_provider_id'];
		$orderArr ['doctor_id'] = $data ['LaboratoryTestOrder'] ['doctor_id'];
		$orderArr ['specimen_type_option'] = $data ['LaboratoryToken'] ['specimen_type_option'];
		$orderArr ['order_id'] = $data ['LaboratoryToken'] ['ac_id'];
		$orderArr ['note_id'] = $session->read ( 'noteId' );
		/**
		 * Generating lab requisition Qr
		 */
		$this->getLabRequsitionQR ( $data ['LaboratoryToken'] ['ac_id'] );
		
		if (empty ( $data ['LaboratoryTestOrder'] ['start_date'] )) {
			$orderArr ['start_date'] = date ( 'Y-m-d' );
		} else {
			$orderArr ['start_date'] = DateFormatComponent::formatDate2STD ( $data ["LaboratoryTestOrder"] ["start_date"], Configure::read ( 'date_format' ) );
		}
		$orderArr ['lab_order'] = $data ['LaboratoryTestOrder'] ['lab_order'];
		$orderArr ['lab_order_date'] = DateFormatComponent::formatDate2STD ( $data ["LaboratoryTestOrder"] ["lab_order_date"], Configure::read ( 'date_format' ) );
		
		// aditya
		// For assessment entry
		if (isset ( $data ['LaboratoryTestOrder'] ['from_assessment'] ) && ! (empty ( $data ['LaboratoryTestOrder'] ['from_assessment'] )))
			$orderArr ['from_assessment'] = $data ['LaboratoryTestOrder'] ['from_assessment'];
		
		if (! empty ( $data ['LaboratoryTestOrder'] ['patient_order_id'] )) {
			$LaboratTest ['name'] = $data ["Laboratory"] ["name"];
			$orderArr ['patient_id'] = $data ["LaboratoryTestOrder"] ["patient_id"];
		} else {
			$LaboratTest ['name'] = $data ["LaboratoryToken"] ["testname"];
		}
		$LaboratTest ['test_code'] = $data ["LaboratoryTestOrder"] ["testcode"];
		$LaboratTest ['lonic_code'] = $data ["LaboratoryTestOrder"] ["lonic_code"];
		$LaboratTest ['sct_concept_id'] = $data ["LaboratoryTestOrder"] ["sct_concept_id"];
		$LaboratTest ['location_id'] = $session->read ( 'locationid' );
		// gaurav new lab construct
		if (empty ( $data ['LaboratoryTestOrder'] ['patient_order_id'] )) {
			$orderArr ['laboratory_id'] = $data ["LaboratoryTestOrder"] ["lab_id"];
		} else {
			$orderArr ['laboratory_id'] = $data ["LaboratoryTestOrder"] ["laboratory_id"];
		}
		$LaboratCheck = $Laboratory->find ( 'first', array (
				'fields' => array (
						'id',
						'lonic_code' 
				),
				'conditions' => array (
						'name' => trim ( $data ['Laboratory'] ['name'] ) 
				) 
		) );
		if (! $orderArr ['laboratory_id'])
			$orderArr ['laboratory_id'] = $LaboratCheck ["Laboratory"] ["id"];
		
		$orderArr ['patient_order_id'] = $data ["LaboratoryTestOrder"] ["patient_order_id"];
		$result = $this->save ( $orderArr );
		// aditya
		if (! empty ( $data ['LaboratoryTestOrder'] ['patient_order_id'] )) {
			
			$data ['LaboratoryToken'] ['laboratory_id'] = $LaboratCheck ["Laboratory"] ["id"];
			$data ['LaboratoryTestOrder'] ['laboratory_test_order_id'] = $this->id;
			$data ['LaboratoryTestOrder'] ['laboratory_id'] = $LaboratCheck ["Laboratory"] ["id"];
			$data ['LaboratoryTestOrder'] ['lonic_code'] = $LaboratCheck ["Laboratory"] ["lonic_code"];
			$updateDataOfLabToken = $laboratoryToken->find ( 'first', array (
					'fields' => array (
							'id' 
					),
					'conditions' => array (
							'laboratory_id' => $LaboratCheck ["Laboratory"] ["id"],
							'patient_id' => $data ["Laboratory"] ["patient_id"] 
					) 
			) );
			
			$data ['LaboratoryToken'] ['question'] = serialize ( $data ['LaboratoryTokenSerialize'] );
			
			if (empty ( $updateDataOfLabToken )) {
				$data ['LaboratoryToken'] = $data ['LaboratoryTestOrder'];
				$laboratoryToken->save ( $data ['LaboratoryToken'] );
				$dbState = 'save';
			} else {
				
				$laboratoryToken->updateAll ( 

				array (
						'patient_id' => "'" . $data ['LaboratoryTestOrder'] ['patient_id'] . "'",
						'patient_order_id' => "'" . $data ['LaboratoryTestOrder'] ['patient_order_id'] . "'",
						'question' => "'" . $data ['LaboratoryToken'] ['question'] . "'",
						'diagnosis' => "'" . $data ['LaboratoryToken'] ['diagnosis'] . "'",
						'specimen_type_id' => "'" . $data ['LaboratoryTestOrder'] ['specimen_type_id'] . "'",
						'collection_priority' => "'" . $data ['LaboratoryTestOrder'] ['collection_priority'] . "'",
						'collected_date' => "'" . $data ['LaboratoryTestOrder'] ['collected_date'] . "'",
						'frequency_l' => "'" . $data ['LaboratoryTestOrder'] ['frequency_l'] . "'",
						'duration_l' => "'" . $data ['LaboratoryTestOrder'] ['duration_l'] . "'",
						'service_provider_id' => "'" . $data ['LaboratoryTestOrder'] ['service_provider_id'] . "'",
						'duration_unit' => "'" . $data ['LaboratoryTestOrder'] ['duration_unit'] . "'",
						'end_date' => "'" . $data ['LaboratoryTestOrder'] ['end_date'] . "'",
						'nurse_collect' => "'" . $data ['LaboratoryTestOrder'] ['nurse_collect'] . "'",
						'special_instruction' => "'" . $data ['LaboratoryTestOrder'] ['special_instruction'] . "'",
						'ac_id' => "'" . $data ['LaboratoryToken'] ['ac_id'] . "'",
						
						'frequency' => "'" . $data ['LaboratoryToken'] ['frequency'] . "'",
						'priority' => "'" . $data ['LaboratoryToken'] ['priority'] . "'",
						
						// 'batch_identifier'=>"'".$data['LaboratoryTestOrder']['batch_identifier']."'",
						'relevant_clinical_info' => "'" . $data ['LaboratoryToken'] ['LaboratoryToken'] . "'",
						'laboratory_test_order_id' => "'" . $data ['LaboratoryTestOrder'] ['laboratory_test_order_id'] . "'" 
				), array (
						'laboratory_id' => $data ['LaboratoryTestOrder'] ['laboratory_id'],
						'patient_id' => $data ['LaboratoryTestOrder'] ['patient_id'] 
				) );
				$dbState = 'update';
			}
		} else {
			
			$collected_date = DateFormatComponent::formatDate2STD ( $data ["LaboratoryToken"] ["collected_date"], Configure::read ( 'date_format' ) );
			// $this->DateFormat->formatDate2Local($data['LaboratoryToken']['collected_date'],Configure::read('date_format'));
			$end_date = DateFormatComponent::formatDate2STD ( $data ["LaboratoryToken"] ["end_date"], Configure::read ( 'date_format' ) );
			// $this->DateFormat->formatDate2Local($data['LaboratoryToken']['end_date'],Configure::read('date_format'));
			// ******************Check if order id is already genrated*********************************************************************
			// *****************************************************************************************************************************
			// debug($data['LaboratoryToken']);exit;
			$sampleData = array ();
			foreach ( $data ['LaboratoryToken'] as $key => $value ) {
				$sampleData [$key] = str_replace ( '&gt;', '', $value );
			}
			$data ['LaboratoryToken'] = $sampleData;
			// echo $collected_date;exit;
			$collected_date = '';
			$data ['LaboratoryToken'] ['question'] = serialize ( $data ['LaboratoryTokenSerialize'] );
			$getR = $laboratoryToken->saveAll ( array (
					'laboratory_id' => $orderArr ['laboratory_id'],
					'patient_id' => $data ['LaboratoryToken'] ['patient_id'],
					'laboratory_test_order_id' => $this->id,
					'specimen_condition_id' => $data ['LaboratoryToken'] ['specimen_condition_id'],
					'cond_org_txt' => $data ['LaboratoryToken'] ['cond_org_txt'],
					'alt_spec' => $data ['LaboratoryToken'] ['alt_spec'],
					'diagnosis' => $data ['LaboratoryToken'] ['diagnosis'],
					'question' => $data ['LaboratoryToken'] ['question'],
					'frequency' => $data ['LaboratoryToken'] ['frequency'],
					'priority' => $data ['LaboratoryToken'] ['priority'],
					'starthours' => $data ['LaboratoryToken'] ['starthours'],
					'rej_reason_txt' => $data ['LaboratoryToken'] ['rej_reason_txt'],
					'alt_spec_cond' => $data ['LaboratoryToken'] ['alt_spec_cond'],
					'account_no' => $data ['LaboratoryToken'] ['account_no'],
					'specimen_action_id' => $data ['LaboratoryToken'] ['specimen_action_id'],
					'relevant_clinical_info' => $data ['LaboratoryToken'] ['relevant_clinical_info'],
					'specimen_rejection_id' => $data ['LaboratoryToken'] ['specimen_rejection_id'],
					'ac_id' => $data ['LaboratoryToken'] ['ac_id'],
					'primary_care_pro' => $data ['LaboratoryToken'] ['primary_care_pro'],
					'created_by' => $session->read ( 'userid' ),
					'create_time' => date ( "Y-m-d H:i:s" ) 
			) );
			if (! empty ( $data ['LaboratoryToken'] ['sbar'] )) {
				$dbState = 'sbar';
			} else {
				$dbState = 'save';
			}
		}
		
		// generate lab id for each new test ordered
		$laboratoryToken->id = '';
		
		// create once
		// $labOrderId = $this->autoGeneratedLabID($this->id);
		// $this->save(array('order_id'=>$labOrderId));
		$this->id = '';
		
		return array (
				'labOrderId' => $labOrderId,
				'dbState' => $dbState 
		);
	}
	/*
	 *
	 * 'specimen_type_id'=>$data['LaboratoryToken']['specimen_type_option'],'collected_date'=>$collected_date,
	 * 'status'=>$data['LaboratoryToken']['status'],'sample'=>$data['LaboratoryToken']['sample'],'bill_type'=>$data['LaboratoryToken']['bill_type'],'end_date'=>$end_date,
	 * ,,
	 */
	
	// insert test order per patient for order set
	function insertTestOrder_orderset($data = array()) {
		$session = new cakeSession ();
		$laboratoryToken = ClassRegistry::init ( 'LaboratoryToken' );
		$Laboratory = ClassRegistry::init ( 'Laboratory' );
		
		if (empty ( $data ['LaboratoryTestOrder'] ['id'] )) {
			$orderArr ['created_by'] = $session->read ( 'userid' );
			$orderArr ['create_time'] = date ( "Y-m-d H:i:s" );
			$LaboratTest ['created_by'] = $session->read ( 'userid' );
			$LaboratTest ['create_time'] = date ( "Y-m-d H:i:s" );
		} else {
			$this->id = $data ['LaboratoryTestOrder'] ['id'];
			$orderArr ['modified_by'] = $session->read ( 'userid' );
			$orderArr ['modify_time'] = date ( "Y-m-d H:i:s" );
			$LaboratTest ['modified_by'] = $session->read ( 'userid' );
			$LaboratTest ['modify_time'] = date ( "Y-m-d H:i:s" );
		}
		$orderArr ['patient_id'] = $data ['Laboratory'] ['patient_id'];
		
		// for inserting multiple lab result for orderset
		
		for($i = 0; $i < count ( $data ['Laboratory'] ['name'] ); $i ++) {
			if ($data ['Laboratory'] ['name'] [$i] != '0') {
				$LaboratCheck = $Laboratory->find ( 'first', array (
						'fields' => array (
								'id' 
						),
						'conditions' => array (
								'name' => $data ['Laboratory'] ['name'] [$i],
								'is_orderset' => 1 
						) 
				) );
				$batchidentifier = time (); // maintaining for grouping tests those at once .
				$orderArr ['batch_identifier'] = $data ['LaboratoryTestOrder'] ['batch_identifier'];
				$orderArr ['start_date'] = date ( 'Y-m-d' );
				// $orderArr['lab_order_date'] = DateFormatComponent::formatDate2STD($orderArr["start_date"],Configure::read('date_format')) ;
				
				$result = $this->saveAll ( array (
						'laboratory_id' => $LaboratCheck ['Laboratory'] ['id'],
						'patient_order_id' =>  $data ['LaboratoryTestOrder'] ['patient_order_id'],
						'start_date' => date ( 'Y-m-d' ),
						'patient_id' => $data ['Laboratory'] ['patient_id'],
						'batch_identifier' => $batchidentifier,
						'is_orderset' => '1',
						'created_by' => $orderArr ['created_by'] 
				) );
				$lastinsid = $this->getInsertId ();
				$labOrderId = $this->autoGeneratedLabID ( $lastinsid );
				$this->updateAll ( array (
						'order_id' => "'$labOrderId'" 
				), array (
						'id' => $this->id 
				) );
				
				// now insert data in laboratory token
				$laboratoryToken->saveAll ( array (
						'laboratory_id' => $LaboratCheck ['Laboratory'] ['id'],
						'patient_id' => $data ['Laboratory'] ['patient_id'],
						'laboratory_test_order_id' => $this->id,
						'created_by' => $session->read ( 'userid' ),
						'create_time' => date ( "Y-m-d H:i:s" ) 
				) );
				$this->id = '';
				$LaboratoryToken->id = '';
				$labOrderId = "";
				$lastinsid = "";
			}
		}
		return true;
	}
	
	/**
	 * Called after inserting lab data
	 *
	 * @param
	 *        	id:latest LaboratoryTestOrder table ID
	 *        	
	 * @return lab ID
	 *        
	 */
	public function autoGeneratedLabID($id = null) {
		// $patient_info=array('Patient'=>array('first_name'=>'Pankaj','admission_type'=>'IPD','location_id'=>1));
		$Location = ClassRegistry::init ( 'Location' );
		$session = new cakeSession ();
		$count = $this->find ( 'count', array (
				'conditions' => array (
						'LaboratoryTestOrder.create_time like' => "%" . date ( "Y-m-d" ) . "%" 
				) 
		) );
		$count = $count + 1;
		
		if ($count == 0) {
			$count = "001";
		} else if ($count < 10) {
			$count = "00$count";
		} else if ($count >= 10 && $count < 100) {
			$count = "0$count";
		}
		$month_array = array (
				'A',
				'B',
				'C',
				'D',
				'E',
				'F',
				'G',
				'H',
				'I',
				'J',
				'K',
				'L' 
		);
		// find the Hospital name.
		
		$Location->unbindModel ( array (
				'belongsTo' => array (
						'City',
						'State',
						'Country' 
				) 
		) );
		
		// $hospital = $Location->read('Facility.name,Location.name',$session->read('locationid'));
		
		// creating patient ID
		$unique_id = 'LAB';
		$facility = $session->read ( 'facility' );
		$location = $session->read ( 'location' );
		$unique_id .= substr ( $facility, 0, 1 ); // first letter of the hospital name
		$unique_id .= substr ( $location, 0, 2 ) . $session->read ( 'locationid' ); // first 2 letter of d location // location id appended be'coz of same locations first word--gaurav
		$unique_id .= date ( 'y' ); // year
		$unique_id .= $month_array [date ( 'n' ) - 1]; // first letter of month
		$unique_id .= date ( 'd' ); // day
		$unique_id .= $count;
		return strtoupper ( $unique_id );
	}
	// function to return all laboratory tests done on patient
	public function labDetails($patient_id = null) {
		if (empty ( $patient_id ))
			return false;
		$LaboratoryTestOrder = Classregistry::init ( 'LaboratoryTestOrder' );
		$LaboratoryTestOrder->bindModel ( array (
				'belongsTo' => array (
						'Laboratory' => array (
								'type' => 'inner',
								'foreignKey' => 'laboratory_id' 
						),
						'Patient' => array (
								'foreignKey' => 'patient_id' 
						),
						'User' => array (
								'foreignKey' => false,
								'conditions' => array (
										'User.id=Patient.doctor_id' 
								) 
						),
						'TariffAmount' => array (
								'foreignKey' => false,
								'conditions' => array (
										'TariffAmount.tariff_list_id=Laboratory.tariff_list_id',
										'TariffAmount.tariff_standard_id=Patient.tariff_standard_id' 
								) 
						) 
				),
				'hasOne' => array (
						'LaboratoryResult' => array (
								'foreignKey' => 'laboratory_test_order_id' 
						) 
				) 
		), false );
		// $this->LaboratoryTestOrder->bindModel(array(
		// 'hasOne' => array('LaboratoryToken'=>array('foreignKey'=>'laboratory_test_order_id'),
		// )),false);
		$laboratoryTestOrderData = $LaboratoryTestOrder->find ( 'all', array (
				'fields' => array (
						'LaboratoryResult.confirm_result','LaboratoryResult.id',
						'LaboratoryTestOrder.id,LaboratoryTestOrder.patient_id,LaboratoryTestOrder.create_time,Laboratory.name,
	    							 TariffAmount.nabh_charges,TariffAmount.non_nabh_charges',
						'LaboratoryTestOrder.amount',
						'LaboratoryTestOrder.paid_amount' 
				),
				'conditions' => array (
						'LaboratoryTestOrder.patient_id' => $patient_id,
						'LaboratoryTestOrder.is_deleted' => 0,
						'LaboratoryTestOrder.from_assessment' => 0 
				),
				'order' => array (
						'LaboratoryTestOrder.id' => 'asc' 
				),
				'group' => 'LaboratoryTestOrder.id' 
		) );
		return $laboratoryTestOrderData;
	}
	
	// function to overwrite the paginator count '
	// commented by pankaj w as no one know why we overwrite paginateCount
	/*
	 * public function PaginateCount($conditions = null, $recursive =0, $extra = array()) {
	 *
	 * //setting group element if $extra->group is set
	 * if(!empty($extra['group'])){
	 * $group=$extra['group'][0];
	 * } else{
	 * $group = array('LaboratoryTestOrder.patient_id');
	 * }
	 * if(is_array($conditions)){
	 * $rec = empty($extra['extra']['recursive']) ? $recursive : $extra['extra']['recursive'];
	 * return $this->find('count', array(
	 * 'conditions' => $conditions,
	 * 'fields'=>array('COUNT(DISTINCT(LaboratoryTestOrder.patient_id)) as count'),
	 * 'recursive' => $rec,
	 * 'group'=>$group
	 * ));
	 * }
	 * }
	 */
	
	// function to remove entries after discharged date
	function deleteAfterDischargeRecords($date, $patient_id) {
		if (empty ( $patient_id ))
			return;
		$session = new CakeSession ();
		$this->updateAll ( array (
				'is_deleted' => 1,
				'modified_by' => $session->read ( 'userid' ) 
		), array (
				"create_time > " => $date,
				'patient_id' => $patient_id 
		) );
	}
	function insertTestOrderPanel($panelData = array(), $data = array()) {
		/*
		 * debug($panelData);
		 * debug($data);
		 */
		// exit;
		$session = new cakeSession ();
		$laboratoryToken = ClassRegistry::init ( 'LaboratoryToken' );
		$Laboratory = ClassRegistry::init ( 'Laboratory' );
		$data ['LaboratoryTestOrder'] ['batch_identifier'] = time (); // maintaining for grouping tests those at once .
		if (empty ( $data ['LaboratoryTestOrder'] ['id'] )) {
			$orderArr ['created_by'] = $session->read ( 'userid' );
			$orderArr ['create_time'] = date ( "Y-m-d H:i:s" );
			$LaboratTest ['created_by'] = $session->read ( 'userid' );
			$LaboratTest ['create_time'] = date ( "Y-m-d H:i:s" );
		} else {
			$this->id = $data ['LaboratoryTestOrder'] ['id'];
			$orderArr ['modified_by'] = $session->read ( 'userid' );
			$orderArr ['modify_time'] = date ( "Y-m-d H:i:s" );
			$LaboratTest ['modified_by'] = $session->read ( 'userid' );
			$LaboratTest ['modify_time'] = date ( "Y-m-d H:i:s" );
		}
		$orderArr ['location_id'] = $session->read ( 'locationid' );
		$orderArr ['patient_id'] = $data ['LaboratoryTestOrder'] ['patient_id'];
		$orderArr ['id'] = $data ['LaboratoryTestOrder'] ['id'];
		$orderArr ['service_provider_id'] = $data ['LaboratoryTestOrder'] ['service_provider_id'];
		$orderArr ['is_external'] = $data ['LaboratoryTestOrder'] ['is_external'];
		$orderArr ['service_provider_id'] = $data ['LaboratoryTestOrder'] ['service_provider_id'];
		$orderArr ['batch_identifier'] = $data ['LaboratoryTestOrder'] ['batch_identifier'];
		$orderArr ['start_date'] = $data ['LaboratoryTestOrder'] ['start_date'];
		$orderArr ['lab_order'] = $data ['LaboratoryTestOrder'] ['lab_order'];
		$orderArr ['lab_order_date'] = DateFormatComponent::formatDate2STD ( $data ["LaboratoryTestOrder"] ["lab_order_date"], Configure::read ( 'date_format' ) );
		
		// aditya
		// For assessment entry
		if (isset ( $data ['LaboratoryTestOrder'] ['from_assessment'] ) && ! (empty ( $data ['LaboratoryTestOrder'] ['from_assessment'] )))
			$orderArr ['from_assessment'] = $data ['LaboratoryTestOrder'] ['from_assessment'];
		if (! empty ( $data ['LaboratoryTestOrder'] ['patient_order_id'] )) {
			$LaboratTest ['name'] = $data ["Laboratory"] ["name"];
		} else {
			$LaboratTest ['name'] = $data ["LaboratoryToken"] ["testname"];
		}
		$LaboratTest ['test_code'] = $data ["LaboratoryTestOrder"] ["testcode"];
		$LaboratTest ['lonic_code'] = $data ["LaboratoryTestOrder"] ["lonic_code"];
		$LaboratTest ['sct_concept_id'] = $data ["LaboratoryTestOrder"] ["sct_concept_id"];
		$LaboratTest ['location_id'] = $session->read ( 'locationid' );
		// gaurav new lab construct
		$orderArr ['laboratory_id'] = $data ["LaboratoryTestOrder"] ["lab_id"];
		debug ( $data ["LaboratoryTestOrder"] );
		/*
		 * $LaboratCheck = $Laboratory->find('first',array('fields'=>array('id'),'conditions'=>array('test_code'=>$LaboratTest['test_code'],'lonic_code'=>$LaboratTest['lonic_code'],'sct_concept_id'=>$LaboratTest['sct_concept_id'])));
		 * $orderArr['Laboratory_id'] = $LaboratCheck['Laboratory']['id'];
		 * if(empty($orderArr['laboratory_id'])){
		 * //$Laboratory->save($LaboratTest);
		 * $radid =	$Laboratory->find('first',array('fields'=>array('id'),'order'=>array('Laboratory.id' => 'desc')));
		 * $orderArr['laboratory_id'] = $radid['Laboratory']['id'];
		 * }
		 */
		$result = $this->save ( $orderArr );
		// aditya
		if (! empty ( $data ['LaboratoryTestOrder'] ['patient_order_id'] )) {
			$data ['LaboratoryTestOrder'] ['laboratory_id'] = $radid ['Laboratory'] ['id'];
			$data ['LaboratoryTestOrder'] ['laboratory_test_order_id'] = $this->id;
			$laboratoryToken->save ( $data ['LaboratoryTestOrder'] );
		} else {
			
			$data ['LaboratoryTestOrder'] ['laboratory_id'] = $orderArr ['laboratory_id'];
			$data ['LaboratoryTestOrder'] ['patient_id'] = $data ['LaboratoryTestOrder'] ['patient_id'];
			$data ['LaboratoryTestOrder'] ['laboratory_test_order_id'] = $this->id;
			$data ['LaboratoryTestOrder'] ['specimen_type_id'] == $data ['LaboratoryToken'] ['specimen_type_id'];
			$data ['LaboratoryTestOrder'] ['ac_id'] == $data ['LaboratoryToken'] ['ac_id'];
			$data ['LaboratoryTestOrder'] ['collected_date'] == $data ['LaboratoryToken'] ['collected_date'];
			$data ['LaboratoryTestOrder'] ['status'] == $data ['LaboratoryToken'] ['status'];
			$data ['LaboratoryTestOrder'] ['sample'] == $data ['LaboratoryToken'] ['sample'];
			$data ['LaboratoryTestOrder'] ['bill_type'] == $data ['LaboratoryToken'] ['bill_type'];
			$data ['LaboratoryTestOrder'] ['specimen_rejection_id'] = $data ['LaboratoryToken'] ['specimen_rejection_id'];
			$data ['LaboratoryTestOrder'] ['rej_reason_txt'] = $data ['LaboratoryToken'] ['rej_reason_txt'];
			$data ['LaboratoryTestOrder'] ['specimen_condition_id'] = $data ['LaboratoryToken'] ['specimen_condition_id'];
			$data ['LaboratoryTestOrder'] ['cond_org_txt'] = $data ['LaboratoryToken'] ['cond_org_txt'];
			$data ['LaboratoryTestOrder'] ['alt_spec_cond'] = $data ['LaboratoryToken'] ['alt_spec_cond'];
			$data ['LaboratoryTestOrder'] ['account_no'] = $data ['LaboratoryToken'] ['account_no'];
			$data ['LaboratoryTestOrder'] ['specimen_action_id'] = $data ['LaboratoryToken'] ['specimen_action_id'];
			$data ['LaboratoryTestOrder'] ['created_by'] = $session->read ( 'userid' );
			$data ['LaboratoryTestOrder'] ['create_time'] = date ( "Y-m-d H:i:s" );
			$data ['LaboratoryTestOrder'] ['service_provider_id'] = $data ['LaboratoryTestOrder'] ['service_provider_id'];
			
			exit ();
			
			for($i = 0; $i < count ( PanelMapping ); $i ++) {
			}
			$laboratoryToken->save ( array (
					'laboratory_id' => $orderArr ['laboratory_id'],
					'patient_id' => $data ['LaboratoryTestOrder'] ['patient_id'],
					'laboratory_test_order_id' => $this->id,
					'specimen_type_id' => $data ['LaboratoryToken'] ['specimen_type_id'],
					'ac_id' => $data ['LaboratoryToken'] ['ac_id'],
					'collected_date' => $data ['LaboratoryToken'] ['collected_date'],
					'status' => $data ['LaboratoryToken'] ['status'],
					'sample' => $data ['LaboratoryToken'] ['sample'],
					'bill_type' => $data ['LaboratoryToken'] ['bill_type'],
					'end_date' => $data ['LaboratoryToken'] ['end_date'],
					'specimen_rejection_id' => $data ['LaboratoryToken'] ['specimen_rejection_id'],
					'alt_spec' => $data ['LaboratoryToken'] ['alt_spec'],
					'rej_reason_txt' => $data ['LaboratoryToken'] ['rej_reason_txt'],
					'specimen_condition_id' => $data ['LaboratoryToken'] ['specimen_condition_id'],
					'cond_org_txt' => $data ['LaboratoryToken'] ['cond_org_txt'],
					'alt_spec_cond' => $data ['LaboratoryToken'] ['alt_spec_cond'],
					'account_no' => $data ['LaboratoryToken'] ['account_no'],
					'specimen_action_id' => $data ['LaboratoryToken'] ['specimen_action_id'],
					'created_by' => $session->read ( 'userid' ),
					'create_time' => date ( "Y-m-d H:i:s" ) 
			) );
		}
		// generate lab id for each new test ordered
		$laboratoryToken->id = '';
		// create once
		$labOrderId = $this->autoGeneratedLabID ( $this->id );
		$this->save ( array (
				'order_id' => $labOrderId 
		) );
		$this->id = '';
		
		return $labOrderId;
	}
	/**
	 * generate
	 */
public function getLabRequsitionQR($getReqNo, $patientId) {
		App::uses ( 'BarcodeHelper', 'Vendor' );
		/*
		 * $patient = ClassRegistry::init('Patient');
		 * $race = ClassRegistry::init('Race');
		 * $patient->bindModel(array('hasOne'=>array('Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id = Patient.person_id')))));
		 * $patientData = $patient->find('first',array('fields'=>array('Patient.lookup_name','Person.dob','Person.ethnicity','Person.race'),'conditions'=>array('Patient.id'=>$patientId)));
		 * $raceData = $race->find('list',array('fields'=>array('value_code','race_name')));
		 * $races = explode(',',$patientData['Person']['race']);
		 * for($i=1;$i<=count($races);$i++){
		 * $seperator = ($i == 1) ? "" : ", ";
		 * $raceString .= $raceData[$races[0]].$seperator;
		 * }
		 */
		// sample data to encode
		
		// $data_to_encode = "Requisition/ Ctrl Number(CD-):".$getReqNo/*." Patient Name:".$patientData['Patient']['lookup_name']." DOB:".DateFormatComponent::formatDate2Local($patientData['Person']['dob'],Configure::read('date_format')).
		// " Ethnicity:".$patientData['Person']['ethnicity']." Race:".$raceString */;
		$data_to_encode = $getReqNo;
		$barcode = new BarcodeHelper ();
		// Generate Barcode data
		$barcode->barcode ();
		$barcode->setType ( 'C128' );
		$barcode->setCode ( $data_to_encode );
		$barcode->setSize ( 80, 200 );
		$file = 'uploads/qrcodes/labOrderQrCard/' . $getReqNo . '.png';
		// Generates image file on server
		$barcode->writeBarcodeFile ( $file );
		return true;
	}
	
	/**
	 * function to save multiple lab test
	 *
	 * @param array $data        	
	 * @param int $patientId        	
	 * @return array
	 */
	function insertMultipleTestOrder($data = array(), $patientId,$noteId) { // inserting lab from smart note
		$session = new cakeSession ();
		$laboratoryToken = ClassRegistry::init ( 'LaboratoryToken' );
		$ac_id = $this->autoGeneratedLabID ( null );
		
		 
		foreach ( $data as $key => $labArray ) {
			if ($key == 'LaboratoryTestOrder') {
				for($i = 0; $i < count ( $labArray ); $i ++) {
					
					$orderArr = '';		
					/******BOF-Mahalaxmi***/
					$getNoteIdSession=$session->read ( 'noteId' );
					$getNoteId = (!empty($getNoteIdSession))?$getNoteIdSession:$noteId;					
					
					if(!empty($getNoteId) && !empty($labArray [$i] ["lab_id"]) && !empty($patientId))
						$this->deleteAll(array('patient_id'=>$patientId,'laboratory_id'=>$labArray [$i] ["lab_id"],'note_id'=>$getNoteId,false)); //For Smart Note Lab order -Mahalaxmi
					/******EOF-Mahalaxmi***/
					$orderArr ['note_id'] =$getNoteId;
					$orderArr ['created_by'] = $session->read ( 'userid' );
					$orderArr ['create_time'] = date ( "Y-m-d H:i:s" );
					$orderArr ['location_id'] = $session->read ( 'locationid' );
					$orderArr ['batch_identifier'] = time ();
					$orderArr ['patient_id'] = $patientId;
					$orderArr ['laboratory_id'] = $labArray [$i] ["lab_id"];
					$orderArr ['amount'] = $labArray [$i] ["amount"];
					$orderArr ['start_date'] = DateFormatComponent::formatDate2STD ( date ( 'd-m-Y H:i:s' ), Configure::read ( 'date_format' ) );
					$orderArr ['lab_order_date'] = DateFormatComponent::formatDate2STD ( $labArray [$i] ["lab_order_date"], Configure::read ( 'date_format' ) );
					$orderArr ['specimen_type_option'] = $labArray [$i] ['specimen_type_option'];
					$orderArr ['specimen_description'] = $labArray [$i] ['specimen_description'];
					$orderArr ['order_id'] = $ac_id;
					$this->save ( $orderArr );
					if ($i == 0) {
						$parentId = 0;
						$lastId = $this->id;
					} else {
						$parentId = $lastId;
					}
					$testOrderId [$i] = $this->id;
					$this->updateAll ( array (
							'parent_id' => $parentId 
					), array (
							'id' => $this->id 
					) );
					$this->id = '';
				}
			}
		}
		foreach ( $data as $key => $labArray ) {
			if ($key == 'LaboratoryToken') {
				for($i = 0; $i < count ( $labArray ); $i ++) {
					
					$tokenArray = '';
					$tokenArray ['created_by'] = $session->read ( 'userid' );
					$tokenArray ['create_time'] = date ( "Y-m-d H:i:s" );
					$tokenArray ['location_id'] = $session->read ( 'locationid' );
					$tokenArray ['patient_id'] = $patientId;
					$tokenArray ['laboratory_id'] = $labArray [$i] ["lab_id"];
					$tokenArray ['ac_id'] = $ac_id;
					$tokenArray ['priority'] = $labArray [$i] ["priority"];
					$tokenArray ['frequency'] = $labArray [$i] ["frequency"];
					$tokenArray ['relevant_clinical_info'] = $labArray [$i] ["relevant_clinical_info"];
					$tokenArray ['primary_care_pro'] = $labArray [$i] ["primary_care_pro"];
					$tokenArray ['diagnosis'] = $labArray [$i] ["diagnosis"];
					$tokenArray ['icd9_code'] = $labArray [$i] ["icd9_code"];
					$tokenArray ['question'] = serialize ( $labArray [$i] ["LaboratoryTokenSerialize"] );
					$tokenArray ['laboratory_test_order_id'] = $testOrderId [$i];
					$laboratoryToken->save ( $tokenArray );
					if ($i == 0) {
						$parentId = 0;
						$lastId = $laboratoryToken->id;
					} else {
						$parentId = $lastId;
					}
					$laboratoryToken->updateAll ( array (
							'parent_id' => $parentId 
					), array (
							'id' => $laboratoryToken->id 
					) );
					$laboratoryToken->id = '';
				}
			}
		}
		/**
		 * Generating lab requisition BarCode
		 */
		$this->getLabRequsitionQR ( $ac_id, $patientId );
		
		return array (
				'labOrderId' => $ac_id,
				'dbState' => 'save' 
		);
	}
	/**
	 * To genrate Specimen Id *
	 */
	public function autoGeneratedSpecimenID($key, $id) {
		// $patient_info=array('Patient'=>array('first_name'=>'Pankaj','admission_type'=>'IPD','location_id'=>1));
		$Location = ClassRegistry::init ( 'Location' );
		$session = new cakeSession ();
		$count = $key . $id;
		$month_array = array (
				'A',
				'B',
				'C',
				'D',
				'E',
				'F',
				'G',
				'H',
				'I',
				'J',
				'K',
				'L' 
		);
		// find the Hospital name.
		
		$Location->unbindModel ( array (
				'belongsTo' => array (
						'City',
						'State',
						'Country' 
				) 
		) );
		
		// $hospital = $Location->read('Facility.name,Location.name',$session->read('locationid'));
		
		// creating patient ID
		$unique_id = 'SP';
		$facility = $session->read ( 'facility' );
		$location = $session->read ( 'location' );
		$unique_id .= substr ( $facility, 0, 1 ); // first letter of the hospital name
		$unique_id .= substr ( $location, 0, 2 ) . $session->read ( 'locationid' ); // first 2 letter of d location // location id appended be'coz of same locations first word--gaurav
		$unique_id .= date ( 'y' ); // year
		$unique_id .= $month_array [date ( 'n' ) - 1]; // first letter of month
		$unique_id .= date ( 'd' ); // day
		$unique_id .= $count;
		return strtoupper ( $unique_id );
	}
	public function GenerateReqNo() {
		/* $count = $this->find ( 'count', array (
				'conditions' => array (
						'patient_id' => $patientId,
						'req_no != ' => NULL 
				) 
		) );
		$req_no = '';
		if ($count > 0) {
			$result = $this->find ( 'first', array (
					'fields' => 'req_no',
					'conditions' => array (
							'patient_id' => $patientId,
							'req_no != ' => NULL 
					) 
			) );
			$req_no = ($result ['LaboratoryTestOrder'] ['req_no']);
		} else { */
			$result = $this->find ( 'first', array (
					'fields' => array (
							'MAX(req_no) AS max' 
					) 
			) );
			$max = $result [0] ['max'];
			if (empty ( $max )) {
				$req_no = 100001;
			} else {
				$req_no = ++ $max;
			}
		//}
		return ($req_no);
	}
        
        public function generateReqLaboratoryRequestNo() {
		$count = $this->find ( 'first', array (
				'conditions' => array (
						'req_no != ' => NULL,
                                                
				) ,
                                'order'=>array('id'=>'DESC'),
                                'field'=>array('req_no')
		) );
		return (++$count['LaboratoryTestOrder']['req_no']);
	}
	
	//BOF for sum of total amount, return patient wise total charges by amit jain
	function getPatientWiseCharges($patientId=array()){
		$session     = new cakeSession();
		if(!$patientId) return false ;
		$amountDetails = $this->find(all,array('conditions'=>array('is_deleted'=>'0','location_id'=>$session->read('locationid'),'patient_id'=>$patientId),
				'fields'=>array('sum(amount) AS totalAmount','patient_id'),'group'=>array("patient_id")));
		return $amountDetails ;
	}
	//EOF
	
	//BOF for sum of paid amount and discount amount, return patient wise service name by amit jain
	function getServiceWiseCharges($patientId=null,$date=null,$userId=null){
		$session     = new cakeSession();
		if(!$patientId) return false ;
		$serviceCategoryObj = ClassRegistry::init('ServiceCategory');
		$serviceId = $serviceCategoryObj->getServiceGroupId('laboratoryservices',$session->read('locationid'));
		$this->bindModel(array(
				'belongsTo' => array(
						'Laboratory' =>array('foreignKey' => false,'conditions'=>array('LaboratoryTestOrder.laboratory_id=Laboratory.id')),
						'ServiceCategory' =>array('foreignKey' => false,'conditions'=>array('ServiceCategory.id'=>$serviceId)),
						'Billing' =>array('foreignKey' => false,'conditions'=>array('LaboratoryTestOrder.billing_id=Billing.id')))),false);
		$amountDetails = $this->find(all,array('conditions'=>array('LaboratoryTestOrder.is_deleted'=>'0','LaboratoryTestOrder.location_id'=>$session->read('locationid'),
				'LaboratoryTestOrder.patient_id'=>$patientId,'LaboratoryTestOrder.paid_amount NOT'=>'0','DATE_FORMAT(Billing.date,"%Y-%m-%d")'=>$date,
				'Billing.created_by'=>$userId,'Billing.mode_of_payment'=>'Cash'),
				'fields'=>array('LaboratoryTestOrder.paid_amount','LaboratoryTestOrder.discount','Laboratory.name','ServiceCategory.name')));
		return $amountDetails ;
	}
	//EOF

	/**
	 * Function getLaboratories
	 * All services of according to the conditions such as all services of specific patient_id
	 * @param unknown_type $superBillId
	 * @param unknown_type $tariffStandardId
	 * @return multitype:
	 * Pooja Gupta
	 */
	public function getLaboratories($condition=array(),$superBillId=NULL){
	
		if($superBillId){
			$this->bindModel(array(
					'belongsTo' => array(
							'Laboratory'=>array('foreignKey'=>false,'type'=>'INNER','conditions'=>array('Laboratory.id=LaboratoryTestOrder.laboratory_id')),
							'TariffList' =>array( 'foreignKey'=>false,'type'=>'INNER','conditions'=>array('Laboratory.tariff_list_id=TariffList.id')),
							/*'CorporateSuperBill'=>array('foreignKey'=>false,'type'=>'INNER','conditions'=>array('LaboratoryTestOrder.corporate_super_bill_id=CorporateSuperBill.id'))*/
					)),false);
			$condition['OR']=array('LaboratoryTestOrder.paid_amount <='=>'0','LaboratoryTestOrder.paid_amount'=>NULL);
			//$condition['LaboratoryTestOrder.corporate_super_bill_id']=$superBillId;
		}else{
			$this->bindModel(array(
					'belongsTo' => array(
							'Laboratory'=>array('foreignKey'=>false,'type'=>'INNER','conditions'=>array('Laboratory.id=LaboratoryTestOrder.laboratory_id')),
							'TariffList' =>array( 'foreignKey'=>false,'type'=>'INNER','conditions'=>array('Laboratory.tariff_list_id=TariffList.id')),
					)),false);
		}
	
		$labArray=$this->find('all',array('fields'=>array('LaboratoryTestOrder.id','LaboratoryTestOrder.laboratory_id','LaboratoryTestOrder.patient_id','LaboratoryTestOrder.amount',
				'LaboratoryTestOrder.paid_amount','LaboratoryTestOrder.discount','LaboratoryTestOrder.corporate_super_bill_id','TariffList.cghs_code',
				'Laboratory.name','Laboratory.tariff_list_id'),
				'conditions'=>array('LaboratoryTestOrder.is_deleted'=>'0',$condition)));
	
		return $labArray;
	
	}
	
	function labServicesUpdate($serviceData,$encId,$catKey,$billId,$percent,$modified){
		$session = new cakeSession();
		$modified_by=$session->read('userid');
		foreach($serviceData as $serviceKey=>$eachData){
			$singleServiceData='';
			$amtToPay=0;
			$serDiscount=0;
			$serpaid=0;
			$singleServiceData=$this->find('first',array(
					'fields'=>array('LaboratoryTestOrder.amount','LaboratoryTestOrder.paid_amount',
							'LaboratoryTestOrder.discount'),
					'conditions'=>array('LaboratoryTestOrder.id'=>$serviceKey,
							'LaboratoryTestOrder.patient_id'=>$encId,)));
	
			$billTariffId[$catKey][]=$serviceKey; //tariff_list_id serialize array
	
			$amtToPay=($eachData['balAmt']*$percent)/100;
	
			$serpaid=$amtToPay+$singleServiceData['LaboratoryTestOrder']['paid_amount'];
	
			$serDiscount=$singleServiceData['LaboratoryTestOrder']['amount']-($serpaid);
	
			$this->updateAll(
					array('LaboratoryTestOrder.paid_amount'=>"'$serpaid'",
							'LaboratoryTestOrder.discount'=>"'$serDiscount'",
							'LaboratoryTestOrder.billing_id'=>"'$billId'",
							'LaboratoryTestOrder.modified_bill_by'=>"'$modified_by'",
							'LaboratoryTestOrder.modified_bill_date'=>"'$modified'"),
					array('LaboratoryTestOrder.id'=>$serviceKey,'LaboratoryTestOrder.patient_id'=>$encId));
				
		}
		return $billTariffId;
	}
	
	// function to return all laboratory tests done on patient
	/**
	 *
	 * @param int $patient_id
	 * @return array
	 * @author pankaj wanjari
	 */
	public function getLabDetails($condition=array()) {
			
		if(empty($condition)) return false ;
		$LaboratoryTestOrder = Classregistry::init ( 'LaboratoryTestOrder' );
		$LaboratoryTestOrder->bindModel ( array (
				'belongsTo' => array (
						'Laboratory' => array (
								'type' => 'inner',
								'foreignKey' => 'laboratory_id'
						) ,
	
				),
				'hasOne' => array (
						'LaboratoryResult' => array (
								'foreignKey' => 'laboratory_test_order_id'
						)
				)
		), false );
	
		$laboratoryTestOrderData = $LaboratoryTestOrder->find ( 'all', array (
				'fields' => array ('LaboratoryResult.confirm_result','LaboratoryResult.is_authenticate',
						'LaboratoryTestOrder.id','LaboratoryTestOrder.patient_id','LaboratoryTestOrder.create_time','Laboratory.id','Laboratory.name',
						'LaboratoryTestOrder.amount','LaboratoryTestOrder.paid_amount','LaboratoryTestOrder.start_date','LaboratoryTestOrder.batch_identifier'),
				'conditions' => array_merge($condition,array(
						'LaboratoryTestOrder.is_deleted' => 0,
						'LaboratoryTestOrder.from_assessment' => 0
				)),
				'order' => array (
						'LaboratoryTestOrder.start_date' => 'desc'
				),
				'group' => 'LaboratoryTestOrder.id'
		) );
		return $laboratoryTestOrderData;
	}
	public function getLabHistory($patientId){
		$this->bindModel(array(
					'belongsTo' => array(
					'Laboratory'=>array('foreignKey'=>'laboratory_id'))));
				
		$labData = $this->find('all',array('conditions'=>array('LaboratoryTestOrder.patient_id'=>$patientId,'LaboratoryTestOrder.is_deleted'=>0),
					'fields'=>array('Laboratory.name',
						'LaboratoryTestOrder.start_date','LaboratoryTestOrder.order_id',
						'LaboratoryTestOrder.start_date')));
		return $labData;
	}
	
}