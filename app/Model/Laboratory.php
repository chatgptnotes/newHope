<?php
/**
 * Service model
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Laboratory Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 * @functions 	 : insertService(insert/update service data).
 */
class Laboratory extends AppModel {
	public $name = 'Laboratory';

	public $validate = array(
			'name' => array(
					
					'nonEmpty' => array(
						'rule' => 'notEmpty',
						'on'=>'create',
						'required'=>true,
						'message' => "Please enter lab name.",
						'last'=>false
					),
					'unique' => array(
							'rule' => 'isUnique',
							'on'=>'create',
							'required'=>true,
							'message' => "Please enter Unique lab name.",
							'last'=>false
					),
					
					)
	);
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		if (empty ( $ds )) {
			$session = new cakeSession ();
			$this->db_name = $session->read ( 'db_name' );
		} else {
			$this->db_name = $ds;
		}
		parent::__construct ( $id, $table, $ds );
	}
	public function checkUnique($check) {
		// $check will have value: array('name' => 'some-value')
		$session = new cakeSession ();
		if (isset ( $this->data ['Laboratory'] ['id'] )) {
			$extraContions = array (
					'is_deleted' => 0,
					'id !=' => $this->data ['Laboratory'] ['id'],
					'Laboratory.location_id' => $session->read ( 'locationid' )
			);
		} else {
			$extraContions = array (
					'is_deleted' => 0
			);
		}

		$conditonsval = array_merge ( $check, $extraContions );
		$countUser = $this->find ( 'count', array (
				'conditions' => $conditonsval,
				'recursive' => - 1
		) );
		if ($countUser > 0) {
			return false;
		} else {
			return true;
		}
	}
	function insertTest($data = array()) {
		//debug($data);exit;
		$session = new cakeSession ();
		$specimenData = array ();
		$laboratoryParameter = ClassRegistry::init ( 'LaboratoryParameter' );
		$laboratoryCategory = ClassRegistry::init ( 'LaboratoryCategory' );
		$laboratoryHistopathology = ClassRegistry::init ( 'LaboratoryHistopathology' );
		$specimenType = ClassRegistry::init ( 'SpecimenType' );
		if($data ['Laboratory']['other_specimen_collection_type']){
			$specimenData['SpecimenType']['description'] = $data ['Laboratory']['other_specimen_collection_type'];
			$specimenType->save($specimenData);
			$specimenTypeID = $specimenType->getLastInsertId ();
			
			$data ['Laboratory'] ['specimen_collection_type'] = $specimenTypeID;
		}
		
		//debug($specimenTypeID);exit;
		
		$data ['Laboratory'] ['location_id'] = $session->read ( 'locationid' );
		$data ['Laboratory'] ['created_by'] = $session->read ( 'userid' );
		$data ['Laboratory'] ['create_time'] = date ( "Y-m-d H:i:s" );
		if($data ['Laboratory'] ['medication'])
			$data ['Laboratory'] ['medication'] = serialize($data ['Laboratory'] ['medication']);
		foreach ( $data ['Laboratory'] ['doctor_id'] as $key => $val ) {
			$arrey [] = $val;
		}
		$doc_id = implode ( ',', $arrey );
		$data ['Laboratory'] ['doctor_id'] = $doc_id;
		$this->save ( $data );

		$labID = $this->getLastInsertId ();
		/** gaurav for Microbiology*/
		if ($data ['Laboratory'] ['lab_type'] == 3) {
			foreach ( $data ['LaboratoryMicroBiology'] as $microBiology ) {
				$subArr = array ();
				$subArr ['name'] = $microBiology ['attribute'];
				$subArr ['parameter_text'] = ($microBiology ['parameter_text']);
				if (empty ( $microBiology ['id'] )) {
					$subArr ['laboratory_id'] = $labID;
				} else {
					$subArr ['laboratory_id'] = $data ['Laboratory'] ['id'];
					$subArr ['id'] = $microBiology ['id'];
				}
				$subArr ['location_id'] = $session->read ( 'locationid' );
				$subArr ['created_by'] = $session->read ( 'userid' );
				$subArr ['create_time'] = date ( "Y-m-d H:i:s" );
				$laboratoryParameter->save ( $subArr );
				$laboratoryParameter->id = '';
			}
			return true;
		}
		if ($data ['LaboratoryParameter'] ['0'] ['name_txt'] || $data ['LaboratoryHistopathology'] ['1'] ['parameter_text_histo']) {
			// debug($labID);exit;
			$catName = '';
			if ($data ['Laboratory'] ['lab_type'] != 2) {
				foreach ( $data ['LaboratoryCategory'] as $key => $catVal ) {
					if (empty ( $catVal ['category_name'] )) {
						$catVal ['category_name'] = ($data ['LaboratoryParameter'] [$key] ['name']) ? $data ['LaboratoryParameter'] [$key] ['name'] : $data ['LaboratoryParameter'] [$key] ['name_txt'];
						$catVal ['is_category'] = 0;
					} else {
						$catVal ['is_category'] = 1;
					}
					$catVal ['laboratory_id'] = ($labID) ? $labID : $data ['Laboratory'] ['id'];
					if (($catName != $catVal ['category_name'])) {
						$laboratoryCategory->save ( $catVal );
						$laboratoryCategory->id = '';
						$catVal ['laboratory_category_id'] = $laboratoryCategory->getLastInsertId ();
						//$catVal ['sort'] = $laboratoryCategory->sort;
						$cattDesc [$catVal ['category_name']] = $catVal;
					}
					$catName = $catVal ['category_name']; // for disctinct category
				}
				// pr($data['LaboratoryParameter']);exit;
				foreach ( $data ['LaboratoryParameter'] as $subArr ) {
					if (empty ( $subArr ['formula'] )) {
						unset ( $subArr ['formula'] );
						unset ( $subArr ['formulaSafeText'] );
					} else {
						$subArr ['formula_text'] = str_replace ( "{{", "", trim ( $subArr ['formulaSafeText'] ) );
						$subArr ['formula_text'] = str_replace ( "}}", "", $subArr ['formula_text'] );
					}
						
					$subArr ['location_id'] = $session->read ( 'locationid' );
					$subArr ['name'] = ($subArr ['name_txt']) ? $subArr ['name_txt'] : $subArr ['name'];
					$subArr ['laboratory_categories_id'] = ($cattDesc [$subArr ['category_name']]) ? $cattDesc [$subArr ['category_name']] ['laboratory_category_id'] : $cattDesc [$subArr ['name']] ['laboratory_category_id'];
						
					$subArr ['laboratory_id'] = ($cattDesc [$subArr ['category_name']]) ? $cattDesc [$subArr ['category_name']] ['laboratory_id'] : $cattDesc [$subArr ['name']] ['laboratory_id'];
					; // insert lab_id
					$subArr ['location_id'] = $session->read ( 'locationid' );
					$subArr ['created_by'] = $session->read ( 'userid' );
					$subArr ['create_time'] = date ( "Y-m-d H:i:s" );
					//$subArr ['sort'] = $cattDesc [$subArr ['category_name']] ['sort'];
						
					/* debug($subArr['by_range_between_lower_limit']);
					 debug(serialize($subArr['by_range_between_lower_limit']));
					exit; */
					$subArr ['by_range_between_lower_limit'] = serialize($subArr['by_range_between_lower_limit']);
					$subArr ['by_range_between_upper_limit'] = serialize($subArr['by_range_between_upper_limit']);
					$subArr ['by_range_between_interpretation'] = serialize($subArr['by_range_between_interpretation']);
						
					$subArr ['by_age_between_num_less_years'] = serialize($subArr['by_age_between_num_less_years']);
					$subArr ['by_age_between_num_gret_years'] = serialize($subArr['by_age_between_num_gret_years']);
					$subArr ['by_age_days_between'] = serialize($subArr['by_age_days_between']);
					$subArr ['by_age_between_years_lower_limit'] = serialize($subArr['by_age_between_years_lower_limit']);
					$subArr ['by_age_between_years_upper_limit'] = serialize($subArr['by_age_between_years_upper_limit']);
					$subArr ['by_age_between_years_default_result'] = serialize($subArr['by_age_between_years_default_result']);
					$subArr ['by_age_sex'] = serialize($subArr['by_age_sex']);
					$subArr ['by_age_days_between'] = serialize($subArr['by_age_days_between']);
						
					$laboratoryParameter->save ( $subArr ); // save parameters whose category name matches
					$laboratoryParameter->id = '';
				}

				return true;
			} else {
				foreach ( $data ['LaboratoryHistopathology'] as $histo ) {
					$subArr = array ();
					$subArr ['name'] = $histo ['attribute'];
					$subArr ['parameter_text'] = ($histo ['parameter_text_histo'])?$histo ['parameter_text_histo']:'&nbsp;';
					if (empty ( $histo ['id'] )) {
						$subArr ['laboratory_id'] = $labID;
					} else {
						$subArr ['laboratory_id'] = $data ['Laboratory'] ['id'];
						$subArr ['id'] = $histo ['id'];
					}
					$subArr ['location_id'] = $session->read ( 'locationid' );
					$subArr ['created_by'] = $session->read ( 'userid' );
					$subArr ['create_time'] = date ( "Y-m-d H:i:s" );
					$laboratoryParameter->save ( $subArr );
					$laboratoryParameter->id = '';
				}
				return true;
			}
		}
		return true;
	}
	function updateTest($data = array()) {
		$session = new cakeSession ();
		$laboratoryParameter = ClassRegistry::init ( 'LaboratoryParameter' );
		$laboratoryCategory = ClassRegistry::init ( 'LaboratoryCategory' );
		$laboratoryHistopathology = ClassRegistry::init ( 'LaboratoryHistopathology' );

		$data ['Laboratory'] ['location_id'] = $session->read ( 'locationid' );
		$data ['Laboratory'] ['created_by'] = $session->read ( 'userid' );
		$data ['Laboratory'] ['create_time'] = date ( "Y-m-d H:i:s" );
		$data ['Laboratory'] ['name'] = $data ['Laboratory'] ['name1'];
		if($data ['Laboratory'] ['medication'])
			$data ['Laboratory'] ['medication'] = serialize($data ['Laboratory'] ['medication']);
		foreach ( $data ['Laboratory'] ['doctor_id'] as $key => $val ) {
			$arrey [] = $val;
		}
		$doc_id = implode ( ',', $arrey );
		$data ['Laboratory'] ['doctor_id'] = $doc_id;
		$this->save ( $data );
		/** gaurav for Microbiology*/
		if ($data ['Laboratory'] ['lab_type'] == 3) {
			$count = 1;
			$laboratoryParameter->deleteAll ( array( 'laboratory_id'=>$data ['Laboratory']['id']) );
			foreach ( $data ['LaboratoryMicroBiology'] as $microBiology ) {
				if($microBiology ['attribute'] || $microBiology ['parameter_text']){
					$subArr = array ();
					$subArr ['name'] = $microBiology ['attribute'];
					$subArr ['parameter_text'] = ($microBiology ['parameter_text']);
					if (empty ( $microBiology ['id'] ))
						$subArr ['id'] = $microBiology ['id'];
					$subArr ['laboratory_id'] = $data ['Laboratory']['id'];
					$subArr ['location_id'] = $session->read ( 'locationid' );
					$subArr ['modified_by'] = $session->read ( 'userid' );
					$subArr ['modify_time'] = date ( "Y-m-d H:i:s" );
					$laboratoryParameter->save ( $subArr );
					$laboratoryParameter->id = '';
				}
			}
			return true;
		}
		/** EOF Gaurav */
		$catName = '';
		if ($data ['Laboratory'] ['lab_type'] != 2) {
			foreach ( $data ['LaboratoryCategory'] as $key => $catVal ) {

				if ($data ['LaboratoryParameter'] [$key] ['altCateName']) {
					$catVal ['category_name'] = $data ['LaboratoryParameter'] [$key] ['altCateName'];
					$catVal ['is_category'] = 1;
				} else {
					$catVal ['category_name'] = ($data ['LaboratoryParameter'] [$key] ['altCateName']) ? $data ['LaboratoryParameter'] [$key] ['altCateName'] : $data ['LaboratoryParameter'] [$key] ['name_txt'];
					$catVal ['is_category'] = 0;
				}

				$catVal ['laboratory_id'] = $data ['Laboratory'] ['id'];
				if (($catName != $catVal ['category_name'])) {
						
					$laboratoryCategory->save ( $catVal );
					$catVal ['laboratory_category_id'] = $laboratoryCategory->id;
					$laboratoryCategory->id = '';
					$cattDesc [$catVal ['category_name']] = $catVal;
					$lastCategoryId = $catVal ['laboratory_category_id'];
				}
				$catName = $catVal ['category_name']; // for disctinct category
			}
			// debug($data['LaboratoryParameter']);exit;
			foreach ( $data ['LaboratoryParameter'] as $key => $subArr ) {
				if (empty ( $subArr ['formula'] )) {
					unset ( $subArr ['formula'] );
					unset ( $subArr ['formulaSafeText'] );
				} else {
					$subArr ['formula_text'] = str_replace ( "{{", "", trim ( $subArr ['formulaSafeText'] ) );
					$subArr ['formula_text'] = str_replace ( "}}", "", $subArr ['formula_text'] );
				}
				
				/*GUL BOC  For deleting formula*/
				if(!$subArr['is_formula']){
					$subArr ['formula_text']='';
					$subArr ['formula']='';
					$subArr ['is_formula']='';
				}
				/*GUL EOC*/
				
				$subArr ['location_id'] = $session->read ( 'locationid' );
				$subArr ['name'] = ($subArr ['name_txt']) ? $subArr ['name_txt'] : $subArr ['name'];
				if (empty ( $subArr ['name'] )) {
					$delData = $laboratoryParameter->read ( array (
							'laboratory_categories_id'
					), $subArr ['id_new'] );
					$laboratoryCategory->delete ( $delData ['LaboratoryCategory'] ['id'] );
					$laboratoryCategory->id = null;
					$laboratoryParameter->delete ( $subArr ['id_new'] );
					$laboratoryParameter->id = null;
					continue;
				}
				if ($cattDesc [$subArr ['altCateName']] ['laboratory_category_id'] || $cattDesc [$subArr ['name_txt']] ['laboratory_category_id']) {
					$subArr ['laboratory_categories_id'] = ($cattDesc [$subArr ['altCateName']]) ? $cattDesc [$subArr ['altCateName']] ['laboratory_category_id'] : $cattDesc [$subArr ['name_txt']] ['laboratory_category_id'];
				} else {
					$subArr ['laboratory_categories_id'] = $lastCategoryId;
				}

				$subArr ['laboratory_id'] = ($cattDesc [$subArr ['altCateName']]) ? $cattDesc [$subArr ['altCateName']] ['laboratory_id'] : $cattDesc [$subArr ['name_txt']] ['laboratory_id'];
				; // insert lab_id

				$subArr ['location_id'] = $session->read ( 'locationid' );
				$subArr ['created_by'] = $session->read ( 'userid' );
				$subArr ['modify_time'] = date ( "Y-m-d H:i:s" );
				$subArr ['unit'] = ($subArr ['unit_txt']) ? $subArr ['unit_txt'] : $subArr ['unit'];
				$subArr ['unit'] = ($subArr ['unit'])?$subArr ['unit']:' ';
				$subArr ['by_range_between_lower_limit'] = serialize($subArr['by_range_between_lower_limit']);
				$subArr ['by_range_between_upper_limit'] = serialize($subArr['by_range_between_upper_limit']);
				$subArr ['by_range_between_interpretation'] = serialize($subArr['by_range_between_interpretation']);


				$subArr ['by_age_between_num_less_years'] = serialize($subArr['by_age_between_num_less_years']);
				$subArr ['by_age_between_num_gret_years'] = serialize($subArr['by_age_between_num_gret_years']);
				$subArr ['by_age_days_between'] = serialize($subArr['by_age_days_between']);
				$subArr ['by_age_between_years_lower_limit'] = serialize($subArr['by_age_between_years_lower_limit']);
				$subArr ['by_age_between_years_upper_limit'] = serialize($subArr['by_age_between_years_upper_limit']);
				$subArr ['by_age_between_years_default_result'] = serialize($subArr['by_age_between_years_default_result']);

				$subArr ['by_age_sex'] = serialize($subArr['by_age_sex']);
				$subArr ['by_age_days_between'] = serialize($subArr['by_age_days_between']);

				$laboratoryParameter->save ( $subArr ); // save parameters whose category name matches
				$laboratoryParameter->id = '';
			}
				
			return true;
		} else {
			foreach ( $data ['LaboratoryHistopathology'] as $histo ) {
				$subArr = array ();
				$subArr ['name'] = $histo ['attribute'];
				$subArr ['parameter_text'] = $histo ['parameter_text_histo'];

				$subArr ['laboratory_id'] = $data ['Laboratory'] ['id'];
				$subArr ['id'] = $histo ['id'];

				$subArr ['location_id'] = $session->read ( 'locationid' );
				$subArr ['created_by'] = $session->read ( 'userid' );
				$subArr ['modify_time'] = date ( "Y-m-d H:i:s" );
				//$subArr ['unit'] = ($subArr ['unit_txt']) ? $subArr ['unit_txt'] : $subArr ['unit'];
				$laboratoryParameter->save ( $subArr );
				$laboratoryParameter->id = '';
			}
			return true;
		}
	}
	function insertLab($data = array()) {
		$LaboratoryToken = ClassRegistry::init ( 'LaboratoryToken' );
		$this->deleteAll ( array (
				'Laboratory.is_orderset' => '1',
				false
		) );
		$session = new cakeSession ();
		$this->create ();

		for($i = 0; $i < count ( $data ['Laboratory'] ['name'] ); $i ++) {
			if ($data ['Laboratory'] ['name'] [$i] != '0') {
				$this->saveAll ( array (
						'name' => $data ['Laboratory'] ['name'] [$i],
						'is_orderset' => '1'
				) );
				$lastinsid = $this->getInsertId ();
				$LaboratoryToken->saveAll ( array (
						'laboratory_id' => $lastinsid,
						'patient_id' => $data [patientid]
				) );
				$this->id = '';
			}
		}

		return true;
	}
	public function insertInPanelMapping($lastId = null, $data = array()) {
		$PanelMapping = ClassRegistry::init ( 'PanelMapping' );
		for($i = 0; $i < count ( $data ['LaboratoryParameter'] ); $i ++) {
			$checkUpdate = $PanelMapping->find ( 'first', array (
					'fields' => array (
							'id'
					),
					'conditions' => array (
							'laboratory_id' => $lastId,
							'underpanellab_id' => $data ['LaboratoryParameter'] [$i] ['name']
					)
			) );
			if (empty ( $checkUpdate ))
				$PanelMapping->saveAll ( array (
						'underpanellab_id' => $data ['LaboratoryParameter'] [$i] ['name'],
						'laboratory_id' => $lastId
				) );
			$this->updateAll ( array (
					'lab_type' => "'" . $data ['LaboratoryParameter'] [$i] ['lab_type'] . "'",
					'type' => "'" . $data ['LaboratoryParameter'] [$i] ['type'] . "'",
					'by_gender_age' => "'" . $data ['LaboratoryParameter'] [$i] ['by_gender_age'] . "'",
					'by_gender_male' => "'" . $data ['LaboratoryParameter'] [$i] ['by_gender_male'] . "'",
					'by_gender_female' => "'" . $data ['LaboratoryParameter'] [$i] ['by_gender_female'] . "'",
					'by_gender_male_lower_limit' => "'" . $data ['LaboratoryParameter'] [$i] ['by_gender_male_lower_limit'] . "'",
					'by_gender_male_upper_limit' => "'" . $data ['LaboratoryParameter'] [$i] ['by_gender_male_upper_limit'] . "'",
					'by_gender_female_lower_limit' => "'" . $data ['LaboratoryParameter'] [$i] ['by_gender_female_lower_limit'] . "'",
					'by_gender_female_upper_limit' => "'" . $data ['LaboratoryParameter'] [$i] ['by_gender_female_upper_limit'] . "'",
					'unit' => "'" . $data ['LaboratoryParameter'] [$i] ['unit'] . "'",
					'by_age_less_years' => "'" . $data ['LaboratoryParameter'] [$i] ['by_age_less_years'] . "'",
					'by_age_num_less_years' => "'" . $data ['LaboratoryParameter'] [$i] ['by_age_num_less_years'] . "'",
					'by_age_num_less_years_lower_limit' => "'" . $data ['LaboratoryParameter'] [$i] ['by_age_num_less_years_lower_limit'] . "'",
					'by_age_num_less_years_upper_limit' => "'" . $data ['LaboratoryParameter'] [$i] ['by_age_num_less_years_upper_limit'] . "'",
					'by_age_more_years' => "'" . $data ['LaboratoryParameter'] [$i] ['by_age_more_years'] . "'",
					'by_age_num_more_years' => "'" . $data ['LaboratoryParameter'] [$i] ['by_age_num_more_years'] . "'",
					'by_age_num_gret_years_lower_limit' => "'" . $data ['LaboratoryParameter'] [$i] ['by_age_num_gret_years_lower_limit'] . "'",
					'by_age_num_gret_years_upper_limit' => "'" . $data ['LaboratoryParameter'] [$i] ['by_age_num_gret_years_upper_limit'] . "'",
					'by_age_between_years' => "'" . $data ['LaboratoryParameter'] [$i] ['by_age_between_years'] . "'",
					'by_age_between_num_less_years' => "'" . $data ['LaboratoryParameter'] [$i] ['by_age_between_num_less_years'] . "'",
					'by_age_between_num_gret_years' => "'" . $data ['LaboratoryParameter'] [$i] ['by_age_between_num_gret_years'] . "'",
					'by_age_between_years_lower_limit' => "'" . $data ['LaboratoryParameter'] [$i] ['by_age_between_years_lower_limit'] . "'",
					'by_age_between_years_upper_limit' => "'" . $data ['LaboratoryParameter'] [$i] ['by_age_between_years_upper_limit'] . "'"
			), array (
					'id' => $data ['LaboratoryParameter'] [$i] ['name']
			) );
			$this->id = null;
			$this->id = null;
		}
		// debug($data);exit;
		$this->updateAll ( array (
				'is_panel' => '1',
				'test_method' => "'" . $data ['LaboratoryParameter1'] ['test_method'] . "'",
				'notes' => "'" . $data ['LaboratoryParameter1'] ['notes'] . "'",
				'lab_type' => "'" . $data ['LaboratoryParameter1'] ['lab_type'] . "'"
		), array (
				'id' => $lastId
		) );

		return true;
	}
	public function getAoeData($laboratoryId) {
		$laboratoryAoeCodeModel = ClassRegistry::init ( 'LaboratoryAoeCode' );
		$specimenCollectionOptionModel = ClassRegistry::init ( 'SpecimenCollectionOption' );
		$laboratoryArray = $this->find ( 'first', array (
				'fields' => array (
						'Laboratory.id',
						'Laboratory.specimen_collection_type',
						'Laboratory.dhr_order_code'
				),
				'conditions' => array (
						'Laboratory.id' => $laboratoryId,
						'Laboratory.is_deleted' => '0'
				)
		) );

		$questionArray = $laboratoryAoeCodeModel->find ( 'all', array (
				'fields' => array (
						'LaboratoryAoeCode.id',
						'LaboratoryAoeCode.question',
						'LaboratoryAoeCode.is_required',
						'LaboratoryAoeCode.is_specimen_description',
						'LaboratoryAoeCode.field_type',
						'LaboratoryAoeCode.dhr_obx_code',
						'LaboratoryAoeCode.dhr_obr_code'
				),
				'conditions' => array (
						'LaboratoryAoeCode.dhr_obr_code' => $laboratoryArray ['Laboratory'] ['dhr_order_code']
				)
		) );
		$answerArray = $specimenCollectionOptionModel->find ( 'all', array (
				'fields' => array (
						'name',
						'dhr_obx_code'
				),
				'conditions' => array (
						'laboratory_id' => $laboratoryId
				)
		) );
		$queAnsArray = array ();
		$cnt = 0;
		// debug($laboratoryArray);
		foreach ( $questionArray as $question ) {
			$obxCode = $question ['LaboratoryAoeCode'] ['dhr_obx_code'];
			$queAnsArray [$cnt] ['Question'] = $question;
			foreach ( $answerArray as $answer ) {
				if ($answer ['SpecimenCollectionOption'] ['dhr_obx_code'] == $obxCode)
					$queAnsArray [$cnt] ['Question'] ['Answer'] [] = $answer ['SpecimenCollectionOption'] ['name'];
			}
			$cnt ++;
		}

		return array (
				'labArray' => $laboratoryArray,
				'queAns' => $queAnsArray
		);
	}
	function getLabProfileSubSpeciality() {
		$testGroupModel = ClassRegistry::init ( 'TestGroup' );
		$groups = $testGroupModel->find ( 'list', array (
				'fields' => array (
						'id',
						'name'
				),
				'conditions' => array (
						'is_profile_speciality' => '1',
						'is_deleted' => '0'
				)
		) );
		return $groups;
	}
	function getGroupNonPanelTest() {
		$testGroupModel = ClassRegistry::init ( 'TestGroup' );
		$testGroupModel->bindModel ( array (
				'hasMany' => array (
						'Laboratory' => array (
								'foreignKey' => 'test_group_id'
						)
				)
		) );
		$groupData = $testGroupModel->find ( 'all', array (
				'TestGroup.is_deleted' => '0'
		) );
		return $groupData;
	}

	// function to return lab charges as per hospital type
	// By aditya
	function getRate($id,$tariffId = null) {
		$session = new cakeSession ();
		$hospitalType = $session->read ( 'hospitaltype' );
		$this->bindModel ( array (
				'belongsTo' => array (
						'TariffList' => array (
								'foreignKey' => false,
								'conditions' => 'Laboratory.tariff_list_id=TariffList.id'
						),
						'TariffAmount' => array (
								'foreignKey' => false,
								'conditions' => array('TariffAmount.tariff_list_id=TariffList.id','TariffAmount.tariff_standard_id'=>$tariffId)
						)
				)
		) );

		if ($hospitalType == 'NABH') {
			$getPrice = $this->find ( 'first', array (
					'fields' => array (
							'TariffAmount.nabh_charges'
					),
					'conditions' => array (
							'Laboratory.id' => $id,
							//'Laboratory.location_id' => $session->read ( 'locationid' )
					)
			) );
			$rate = $getPrice['TariffAmount']['nabh_charges'];
		} else {
			$getPrice = $this->find ( 'first', array (
					'fields' => array (
							'TariffAmount.non_nabh_charges'
					),
					'conditions' => array (
							'Laboratory.id' => $id,
							//	'Laboratory.location_id' => $session->read ( 'locationid' )
					)
			) );
			$rate = $getPrice['TariffAmount']['non_nabh_charges'];
				
		}
		return $rate;
	}


	public function insertHistology($data) {
		// debug($data);exit;
		$laboratoryResult = ClassRegistry::init ( 'LaboratoryResult' );
		$laboratoryhL7Result = ClassRegistry::init ( 'LaboratoryHl7Result' );
		$session = new CakeSession ();

		$laboratoryResultData ['laboratory_id'] = $data ['LaboratoryHistopathology'] ['laboratory_id'];
		$laboratoryResult->save ( $laboratoryResultData );
		$labResultID = $laboratoryResult->getLastInsertID ();
		// debug($data);exit;
		$laboratoryId = $data ['LaboratoryHistopathology'] ['laboratory_id'];
		unset ( $data ['LaboratoryHistopathology'] ['laboratory_id'] );
		$hl7Data = array ();
		foreach ( $data ['LaboratoryHistopathology'] as $key => $hl7Value ) {
			$hl7Data ['laboratory_result_id'] = $labResultID;
			$hl7Data ['laboratory_id'] = $laboratoryId;
			$hl7Data ['laboratory_parameter_id'] = $key;
			$hl7Data ['observations'] = trim ( $hl7Value );
			$hl7Data ['created_by'] = $session->read ( 'userid' );
			$hl7Data ['create_time'] = date ( "Y-m-d H:i:s" );
			$hl7Data ['location_id'] = $session->read ( 'locationid' );
			$laboratoryhL7Result->save ( $hl7Data );
			$laboratoryhL7Result->id = '';
		}
	}

	/**
	 * afterSave function for saving data in account table--Amit
	 */
	// these services already saved in tarifflist model thats by its not needed ---commented by amit jain
	/*
	 * public function afterSave($created)
	* {
	* //For generating account code for account table
	* $session = new CakeSession();
	* $getAccount = Classregistry::init('Account');
	* $count = $getAccount->find('count',array('conditions'=>array('Account.create_time like'=> "%".date("Y-m-d")."%",'Account.location_id'=>$session->read('locationid'))));
	* $count++ ; //count currrent entry also
	* if($count==0){
	* $count = "001" ;
	* }else if($count < 10 ){
	* $count = "00$count" ;
	* }else if($count >= 10 && $count <100){
	* $count = "0$count" ;
	* }
	* $month_array = array('A','B','C','D','E','F','G','H','I','J','K','L');
	* //find the Hospital name.
	* $hospital = $session->read('facility');
	* //creating patient ID
	* $unique_id = 'LAB';
	* $unique_id .= ucfirst(substr($hospital,0,1)); //first letter of the hospital name
	* $unique_id .= strtoupper(substr($session->read('location'),0,2));//first 2 letter of d location
	* $unique_id .= date('y'); //year
	* $unique_id .= $month_array[date('n')-1];//first letter of month
	* $unique_id .= date('d');//day
	* $unique_id .= $count;
	* if($created){
	* if($this->data['Laboratory']['is_deleted']==1){
	* return ; //return if delete
	* }
	* $this->data['Account']['create_time']=date("Y-m-d H:i:s");
	* $this->data['Account']['account_code']=$unique_id;
	* $this->data['Account']['status']='Active';
	* $this->data['Account']['name']=$this->data['Laboratory']['name'];
	* $this->data['Account']['user_type']='Laboratory';
	* $this->data['Account']['system_user_id']=$this->data['Laboratory']['id'];
	* $this->data['Account']['location_id']=$session->read('locationid');
	* $this->data['Account']['accounting_group_id']='3';
	* $getAccount->save($this->data['Account']);
	* }else{
	* $var=$getAccount->find('first',array('fields'=>array('id'),'conditions'=>array('system_user_id'=>$this->data['Laboratory']['id'],'user_type'=>'Laboratory')));
	* //avoid delete updatation
	* if($this->data['Laboratory']['is_deleted']==1){
	* $getAccount->updateAll(array('is_deleted'=>1), array('Account.system_user_id' => $this->data['Laboratory']['id'],'Account.user_type'=>'Laboratory'));
	* return ;
	* }
	* if(empty($var['Account']['id']))
	 * {
	* $this->data['Account']['account_code']=$unique_id;
	* $this->data['Account']['create_time']=date("Y-m-d H:i:s");
	* $this->data['Account']['status']='Active';
	* }
	* $this->data['Account']['name']=$this->data['Laboratory']['name'];
	* $this->data['Account']['user_type']='Laboratory';
	* $this->data['Account']['system_user_id']=($this->data['Laboratory']['id'])?$this->data['Laboratory']['id']:$this->id;
	* $this->data['Account']['accounting_group_id']='3';
	* $this->data['Account']['id']=$var['Account']['id'];
	* $this->data['Account']['modify_time']=date("Y-m-d H:i:s");
	* $this->data['Account']['location_id'] = $session->read('locationid');
	* $getAccount->save($this->data['Account']);
	* }
	* }
	*/
	
	function importDataGlobus(&$dataOfSheet){
		$service_category = Classregistry::init('ServiceCategory');
		$service_sub_category = Classregistry::init('ServiceSubCategory');
		$tariff_list = Classregistry::init('TariffList');
		$tariff_amount = Classregistry::init('TariffAmount');
		$tariff_standard = Classregistry::init('TariffStandard');
		$laboratory = Classregistry::init('Laboratory');
	
		$session = new cakeSession();
		$dataOfSheet->row_numbers=false;
		$dataOfSheet->col_letters=false;
		$dataOfSheet->sheet=0;
		$dataOfSheet->table_class='excel';
	
		try
		{
			for($row=2;$row<=$dataOfSheet->rowcount($dataOfSheet->sheet);$row++) {
				$category_id= "";
				$tariff_standard_id="";
				$tariff_list_id ="";
				$lab_id="";
				$serviceCode = trim($dataOfSheet->val($row,1,$dataOfSheet->sheet));
				$service = addslashes(trim($dataOfSheet->val($row,2,$dataOfSheet->sheet)));
				if(!$service) continue ;
				$serviceC = trim($dataOfSheet->val($row,4,$dataOfSheet->sheet));
				$createtime = date("Y-m-d H:i:s");
				$createdby = $session->read('userid');
				if(empty($validity))
					$validity = "1";
	
				//find service group if exist
				$category = $service_category->find("first",array("conditions" =>array("ServiceCategory.name"=>$serviceC,
						"ServiceCategory.location_id"=>$session->read('locationid'),
						"ServiceCategory.is_deleted"=>'0'
				)));
	
	
				if(!empty($category)){
					$category_id = $category['ServiceCategory']['id']; //already exist
				}else{
					//or insert SC
					$service_category->create();
					$service_category->save(array("name"=>$serviceC,'location_id'=>$session->read('locationid'),"is_view"=>"1","create_time"=> $createtime,"created_by"=>$createdby));
					$category_id = $service_category->id;
				}
	
	
				/* for Tariff List/ For mapping lab charges have to create one service with same name as lab*/
				$tariffList = $tariff_list->find("first",array("conditions" =>array("TariffList.name"=>$service,
						"TariffList.service_category_id"=>$category_id,
						"TariffList.location_id"=>$session->read('locationid'))));
	
				if(!empty($tariffList)){
					$tariff_list_id = $tariffList['TariffList']['id'];
					$tariff_list->save(array(
							'id'=>$tariff_list_id, 
							"location_id"=>$session->read('locationid'),
							"name"=>$service,
							"service_category_id"=>$category_id,
							"create_time"=> $createtime,
							"created_by"=>$createdby
					));
				}else{
					$tariff_list->create();
					$tariff_list->save(array(
							"location_id"=>$session->read('locationid'),
							"name"=>$service,
							"service_category_id"=>$category_id,
							"create_time"=> $createtime,
							"created_by"=>$createdby
					));
					$tariff_list_id = $tariff_list->id;
				}
	
				$lab = $laboratory->find("first",array("conditions" =>array("Laboratory.name"=>$service,
						"Laboratory.service_group_id"=>$category_id,
						"Laboratory.location_id"=>$session->read('locationid'))));
				if(!empty($lab)){
					$lab_id = $lab['Laboratory']['id'];
					$laboratory->save(array(
							"id"=>$lab_id,
							"location_id"=>$session->read('locationid'),
							"name"=>$service,
							"is_deleted"=>"0",
							"is_active"=>"1",
							"service_group_id"=>$category_id,
							"tariff_list_id"=>$tariff_list_id,
							"test_group_id"=>$category_id,
							"create_time"=> $createtime,
							"created_by"=>$createdby
					));
				}else{
					$laboratory->create();
					$laboratory->save(array(
	
							"location_id"=>$session->read('locationid'),
							"name"=>$service,
							"is_deleted"=>"0",
							"is_active"=>"1",
							"service_group_id"=>$category_id,
							"tariff_list_id"=>$tariff_list_id,
							"test_group_id"=>$category_id,
							"create_time"=> $createtime,
							"created_by"=>$createdby
					));
					$lab_id = $laboratory->id;
				}
					
	
				$hospitalType = $session->read('hospitaltype');
	
				$check_edit_amount = $tariff_amount->find("first",array("conditions"=>array(
						"tariff_list_id"=>$tariff_list_id,
						"tariff_standard_id"=>'20'
				)));
	
				if($hospitalType=='NABH'){
					$chargeNabh = trim($dataOfSheet->val($row,3,$dataOfSheet->sheet));
					$chargeNonNabh=0;
				}else{
					$chargeNonNabh = trim($dataOfSheet->val($row,3,$dataOfSheet->sheet));;
					$chargeNabh=0;
				}
				/* for Tariff Amount*/
				if(!empty($check_edit_amount)){
					$tariff_amount->save(array(
							"id"=>$check_edit_amount['TariffAmount']['id'],
							"nabh_charges"=>$chargeNabh,
							"non_nabh_charges"=>$chargeNonNabh,
							"tariff_standard_id"=>'20',
							"moa_sr_no"=>$moa,
							"service_code"=>$serviceCode,
							"unit_days"=>$validity ,
							"create_time"=> $createtime,
							"created_by"=>$createdby
					));
				}else{
					$tariff_amount->create();
					$tariff_amount->save(array(
							"location_id"=>$session->read('locationid'),
							"tariff_list_id"=>$tariff_list_id,
							"tariff_standard_id"=>'20',
							"nabh_charges"=>$chargeNabh,
							"non_nabh_charges"=>$chargeNonNabh,
							"moa_sr_no"=>$moa,
							"service_code"=>$serviceCode,
							"unit_days"=>$validity ,
							"create_time"=> $createtime,
							"created_by"=>$createdby
					));
					$tariff_amount->id =  '' ;
				}
				
	
			}
	
			return true;
		}catch(Exception $e){
	
			return false;
		}
	
	
	}

		function getRateAndDiscount($id,$tariffId = null) {
		$session = new cakeSession ();
		$hospitalType = $session->read ( 'hospitaltype' );
		$returnArrray =array();
		$this->bindModel ( array (
				'belongsTo' => array (
						'TariffList' => array (
								'foreignKey' => false,
								'conditions' => 'Laboratory.tariff_list_id=TariffList.id'
						),
						'TariffAmount' => array (
								'foreignKey' => false,
								'conditions' => array('TariffAmount.tariff_list_id=TariffList.id','TariffAmount.tariff_standard_id'=>$tariffId)
						)
				)
		) );

		if ($hospitalType == 'NABH') {
			$getPrice = $this->find ( 'first', array (
					'fields' => array (
							'TariffAmount.nabh_charges','TariffAmount.standard_tariff'
					),
					'conditions' => array (
							'Laboratory.id' => $id,
							//'Laboratory.location_id' => $session->read ( 'locationid' )
					)
			) );
			$returnArrray['amount']= $getPrice['TariffAmount']['nabh_charges'];
            $returnArrray['discount']= $getPrice['TariffAmount']['standard_tariff'];
		} else {
			$getPrice = $this->find ( 'first', array (
					'fields' => array (
							'TariffAmount.non_nabh_charges','TariffAmount.standard_tariff'
					),
					'conditions' => array (
							'Laboratory.id' => $id,
							//	'Laboratory.location_id' => $session->read ( 'locationid' )
					)
			) );	
			$returnArrray['amount'] = $getPrice['TariffAmount']['non_nabh_charges'];
	        $returnArrray['discount'] = $getPrice['TariffAmount']['standard_tariff'];		
		}
        
		return $returnArrray;
	}
}