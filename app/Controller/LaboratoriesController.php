<?php
	/**
 * Laboratory controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 DrmHope Softwares  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Laboratory controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 * $function 	  :AEVD
 */
	class LaboratoriesController extends AppController {
		public $name = 'Laboratories';
		public $uses = array (
				'Laboratory',
				'LaboratoryParameter' 
		);
		public $helpers = array (
				'Html',
				'Form',
				'Js',
				'DateFormat',
				'RupeesToWords',
				'Number',
				'General' 
		);
		public $components = array (
				'RequestHandler',
				'Email' 
		);
		function index() {
		}
		function admin_index() {
			$conditionsSearch ['Laboratory'] = array (
					//'location_id' => $this->Session->read ( 'locationid' ) 
			);
			if (isset ( $this->request->data ) && isset ( $this->request->data ) && $this->request->data ['lab_name'] != '') {
				$conditionsSearch ["Laboratory"] = array (
						"name LIKE" => "" . $this->request->data ['lab_name'] . "%",
						'is_deleted'=>0
						//'location_id' => $this->Session->read ( 'locationid' ) 
				);
			}
			if (isset ( $this->request->data ) && isset ( $this->request->data ) && $this->request->data ['cbt_search_code'] != '') {
				$conditionsSearch ["Laboratory"] = array (
						"cbt LIKE" => "" . $this->request->data ['cbt_search_code'] . "%",
						'is_deleted'=>0
						//'location_id' => $this->Session->read ( 'locationid' ) 
				);
			}
			
			$conditionsSearch = $this->postConditions ( $conditionsSearch );
			
			$this->Laboratory->bindModel ( array (
					'hasOne' => array (
							'LaboratoryCategory' => array (
									'foreignKey' => 'laboratory_id' 
							) 
					) 
			), false );
			$this->paginate = array (
					'limit' => Configure::read ( 'number_of_rows' ),
					'order' => array (
							'Laboratory.name' => 'asc' 
					),
					'group' => 'Laboratory.id',
					'conditions' => $conditionsSearch 
			);
			
			$testData = $this->paginate ( 'Laboratory' ); // pr($testData);exit;
			$this->set ( 'testData', $testData );
		}
		function admin_add($lab_id = null, $category_id = null) {
			 
				 				 
				 
				 
			 
			
			/*  if($this->request->data){
				 debug($this->request->data); exit;
			}  */
			
			// $this->layout = 'Advance';
			$this->uses = array (
					'ServiceCategory',
					'TariffList',
					'TestGroup',
					'Ucums',
					'SpecimenType' 
			);
		if (isset ( $this->request->data ) && ! empty ( $this->request->data )) {
				if (empty ( $this->request->data ['Laboratory'] ['name'] )) {
					$this->Session->setFlash (__( 'Please enter lab name' ), 'default', array ( 'class' => 'error' ));
					$this->redirect ($this->referer());
				}
				$this->Laboratory->set($this->request->data['Laboratory']);
				$errors = $this->Laboratory->invalidFields();


				if(!empty($errors)) {
					$this->set("errors", $errors);
				} else {
					if (($this->Laboratory->insertTest ( $this->request->data ))) {
						$this->Session->setFlash ( __ ( 'Test has been added successfully' ), 'default', array (
								'class' => 'message'
						) );
							
						$this->redirect ( array (
								"action" => "index"
						) );
					}
				}


				if (! empty ( $errors )) {
					$this->set ( "errors", $errors );
					$this->request->data ['LaboratoryParameter'] = "";
					// $this->redirect($this->referer());
				}
			}
			if (! empty ( $lab_id )) {
				$testQuery = $this->Laboratory->read ( 'id,name,service_group_id,tariff_list_id,test_group_id', $lab_id );
				$this->set ( 'test_name', $testQuery ['Laboratory'] ['name'] );
				$this->data = $testQuery;
				$this->set ( 'serviceGroup', $this->ServiceCategory->getServiceGroup () );
				$tariffList = $this->TariffList->getServiceByGroupId ( $this->data ['Laboratory'] ['service_group_id'] );
				$this->set ( 'tariffList', $tariffList );
			}
			$specimentTypes = $this->SpecimenType->find ( 'list', array (
					'fields' => array (
							'id',
							'description' 
					),
					'conditions' => array (
							'SpecimenType.is_deleted' => '0' 
					) 
			) );
			$this->set ( 'specimentTypes', $specimentTypes );
			$this->set ( 'serviceGroup', $this->ServiceCategory->getServiceGroup () );
			$this->set ( 'labId', $this->ServiceCategory->getServiceGroupId ( "laboratoryservices" ) );
			$this->set ( 'testGroup', $this->TestGroup->getAllGroups ( 'laboratory' ) );
			
			$this->Laboratory->bindModel ( array (
					'hasMany' => array (
							'LaboratoryCategory' => array (
									'foreignKey' => 'laboratory_id' 
							),
							'LaboratoryParameter' => array (
									'foreignKey' => 'laboratory_id' 
							) 
					) 
			), false );
			$data = $this->Laboratory->read ( null, $lab_id );
			// debug($data);
			$this->data = $data;
		}
		function cmp($a, $b) {
			return $a ["laboratory_categories_id"] - $b ["laboratory_categories_id"];
		}
		function admin_edit($lab_id = null, $category_id = null) {
			/*
			 * if($this->request->data){
			 * debug($this->request->data);
			 * exit;
			 * }
			 */
			$this->uses = array (
					'Laboratory',
					'PanelMapping',
					'Ucums',
					'TestGroup',
					'SpecimenType',
					'ServiceCategory',
					'TariffList',
					'LaboratoryCategory',
					'User' 
			);
			$optUcums = $this->Ucums->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					) 
			) );
			
			$details = $this->User->find ( 'all', array (
					'fields' => array (
							'User.full_name',
							'User.id' 
					),
					'order' => array (
							'User.first_name Asc' 
					) 
			) );
			$doctor_id = array ();
			foreach ( $details as $key => $value ) {
				foreach ( $details [$key] as $lastnode ) {
					$doctor_id [$lastnode ['id']] = $lastnode ['full_name'];
				}
			}
			$this->set ( 'doctor_id', $doctor_id );
			$this->set ( 'optUcums', $optUcums );
			$optTestGroup = $this->TestGroup->find ( 'list', array (
					'fields' => array (
							'id',
							'name' 
					) 
			) );
			$this->set ( 'optTestGroup', $optTestGroup );
			
			if (isset ( $this->request->data ) && ! empty ( $this->request->data )) { // echo '<pre>';print_r($this->request->data);exit;
				if (($this->Laboratory->updateTest ( $this->request->data ))) {
					if (empty ( $this->request->data ['Laboratory'] ['name'] )) {
						$this->request->data ['Laboratory'] ['name'] = $this->request->data ['Laboratory'] ['name1'];
					}
					$this->Session->setFlash ( __ ( 'Test record updated successfully' ), 'default', array (
							'class' => 'message' 
					) );
					
					/*$this->redirect ( array (
							"action" => "index" 
					) );*/
				}
			}
			
			$this->Laboratory->bindModel ( array (
					'hasMany' => array (
							//'LaboratoryCategory' =>array('foreignKey' => 'laboratory_id','order' => 'sort ASC'),
							'LaboratoryParameter' => array (
									'foreignKey' => 'laboratory_id',
								//	'order' => 'sort_category ASC'
							) 
					) 
			), false );
			
			if (! empty ( $lab_id )) {
				
				$this->Laboratory->bindModel ( array (
						'hasMany' => array (
								
								 //'LaboratoryCategory' =>array('foreignKey' => 'laboratory_id','order' => 'sort ASC'),
								'LaboratoryParameter' => array (
										'foreignKey' => 'laboratory_id',
									//	'order' => 'sort_category ASC'
								) 
						) 
				), false );
				$data = $this->Laboratory->read ( null, $lab_id );
				//debug($data);exit;
				$prArray = $data ['LaboratoryParameter'];
				//debug($prArray);//exit;
				//~~COmmented by gulshan because for sort order
				usort ( $prArray, create_function ( '$a, $b', 'if ($a["laboratory_categories_id"] == $b["laboratory_categories_id"]) return 0; return ($a["laboratory_categories_id"] < $b["laboratory_categories_id"]) ? -1 : 1;' ) );
				$categoryList = $this->LaboratoryCategory->find ( 'list', array (
						'fields' => array (
								'id',
								'category_name' 
						),
						'conditions' => array (
								'LaboratoryCategory.is_category' => '1' 
						) 
				) );
				$data ['LaboratoryParameter'] = $prArray;
				//debug($data ['LaboratoryParameter']);exit;
				// $varData = Set::classicExtract($prArray, '{n}.id.{n}.id');
				// pr($varData);exit;
				$this->data = $data;
				// $data = $this->Laboratory->read(null,$lab_id);
				$this->set ( array (
						'test_id' => $lab_id,
						'cat_id' => $category_id,
						'setData' => $data,
						'categoryList' => $categoryList 
				) );
				$this->set ( 'serviceGroup', $this->ServiceCategory->getServiceGroup () );
				$tariffList = $this->TariffList->getServiceByGroupId ( $data ['Laboratory'] ['service_group_id'] );
				$this->set ( 'testGroup', $this->TestGroup->getAllGroups ( 'laboratory' ) );
				$this->set ( 'tariffList', $tariffList );
			}
			$this->loadModel ( "ServiceCategory" );
			$specimentTypes = $this->SpecimenType->find ( 'list', array (
					'fields' => array (
							'id',
							'description' 
					),
					'conditions' => array (
							'SpecimenType.is_deleted' => '0' 
					) 
			) );
			$this->set ( 'specimentTypes', $specimentTypes );
			$this->set ( 'serviceGroup', $this->ServiceCategory->getServiceGroup () );
			$this->set ( 'labId', $this->ServiceCategory->getServiceGroupId ( "laboratoryservices" ) );
			$this->set ( 'testGroup', $this->TestGroup->getAllGroups ( 'laboratory' ) );
			$this->set('histopathologyConfigDataGroup',json_encode(Configure::read('lab_histo_template_sub_groups')));
			$this->set('histopathologyConfigData',json_encode(Configure::read('histopathology_data')));
			$this->set('histopathologyConfigSubGroupData',json_encode(Configure::read('lab_histo_template_sub_groups_mapping')));
				
		}
		function admin_delete($id) {
			if (! $id)
				return;
				// for updating account legder is deleted by amit
			$this->request->data ["Laboratory"] ["id"] = $id;
			$this->request->data ["Laboratory"] ["is_deleted"] = '1';
			$this->Laboratory->save ( $this->request->data );
			// EOF
			if ($this->Laboratory->delete ( $id )) {
				$this->Session->setFlash ( __ ( 'Test deleted successfully' ), 'default', array (
						'class' => 'message' 
				) );
				$this->redirect ( $this->referer () );
			} else {
				$this->Session->setFlash ( __ ( 'There is some problem' ), 'default', array (
						'class' => 'error' 
				) );
			}
		}
		function admin_change_status($test_id = null, $status = null) {
			if ($test_id == '') {
				$this->Session->setFlash ( __ ( 'There is some problem' ), 'default', array (
						'class' => 'error' 
				) );
				$this->redirect ( $this->referer () );
			}
			$this->Laboratory->id = $test_id;
			$this->Laboratory->save ( array (
					'is_active' => $status 
			) );
			$this->Session->setFlash ( __ ( 'Status has been changed successfully' ), 'default', array (
					'class' => 'message' 
			) );
			$this->redirect ( $this->referer () );
		}
		// function to add new test attribute block with ajax
		function ajax_add_block() {
			$this->layout = false;
			$this->set ( array (
					'counter' => $_GET ['counter'],
					'radioId' => $_GET ['radioId'],
					'CategoryValue' => $_GET ['CategoryValue'],
					'hideCatCheckBox' => $_GET ['hideCatCheckBox'],
					'categorySort' => $_GET ['categorySort'],
					'sortCategory' => $_GET ['sortCategory'],
					'field' => $_GET ['field'] 
			) );
		}
		function ajax_edit_block() {
			$this->layout = false;
			$this->set ( array (
					'counter' => $_GET ['counter'],
					'radioId' => $_GET ['radioId'],
					'CategoryValue' => $_GET ['CategoryValue'],
					'altCateName' => $_GET ['altCateName'],
					'isCategoryAllowed' => $_GET ['isCategoryAllowed'] ,
					'hideCatCheckBox' => $_GET ['hideCatCheckBox'],
					'categorySort' => $_GET ['categorySort'],
					'sortCategory' => $_GET ['sortCategory'],
					'categoryValueCount' => $_GET ['categoryValueCount']
			) );
		}
		
		// function to add new test attribute block with ajax histopathology_data
		function ajax_add_histopathology() {
			$this->layout = false;
			// debug($_GET['counter']);
			$this->set ( array (
					'counter' => $_GET ['counter'] 
			) );
		}
		function admin_ajaxValidateTestName() {
			$this->layout = 'ajax';
			$this->autoRender = false;
			$username = $this->params->query ['fieldValue'];
			if ($username == '') {
				return;
			}
			$username = $this->params->query ['fieldValue'];
			$count = $this->Laboratory->find ( 'count', array (
					'conditions' => array (
							'name' => $username,
							'Laboratory.location_id' => $this->Session->read ( 'locationid' ) 
					) 
			) );
			if (! $count) {
				return json_encode ( array (
						'name',
						true,
						'alertTextOk' 
				) );
			} else
				return json_encode ( array (
						'name',
						false,
						'alertText' 
				) );
			
			exit ();
		}
		/**
		 * function to add lab rate respective to compnies
		 *
		 * @return unknown_type
		 */
		function admin_corporate_lab_rate() {
			$this->uses = array (
					'TariffStandard',
					'CorporateLabRate',
					'Radiology',
					'Histology' 
			);
			$locationId = $this->Session->read ( 'locationid' );
			$this->TariffStandard->bindModel ( array (
					'hasOne' => array (
							'CorporateLabRate' => array (
									'type' => 'LEFT',
									'foreignKey' => 'tariff_standard_id',
									'conditions' => array () 
							) 
					) 
			) );
			
			$corporatesRate = $this->TariffStandard->find ( 'all', array (
					'fields' => array (
							'CorporateLabRate.id',
							'CorporateLabRate.nabh_rate',
							'CorporateLabRate.non_nabh_rate',
							'CorporateLabRate.tariff_standard_id',
							'TariffStandard.name',
							'TariffStandard.id' 
					),
					'conditions' => array (
							'laboratory_id' => 4,
							'department' => 'lab',
							'CorporateLabRate.location_id' => $locationId,
							'TariffStandard.location_id' => $locationId 
					) 
			) );
			
			if ($this->RequestHandler->isAjax ()) {
				// $this->layout = 'ajax';
				// retrive all coporates.
				$dept = $this->data ['Laboratory'] ['department'];
				
				if ($dept == 'lab') {
					$model = 'Laboratory';
				} else if ($dept == 'radiology') {
					$model = 'Radiology';
				} else if ($dept == 'histology') {
					$model = 'Histology';
				}
				
				// $corporates = $this->TariffStandard->find('all',array('fields'=>array('id','name'),'conditions'=>array('TariffStandard.is_deleted'=>0)));
				$this->TariffStandard->bindModel ( array (
						'hasOne' => array (
								'CorporateLabRate' => array (
										'type' => 'LEFT',
										'foreignKey' => 'tariff_standard_id',
										'conditions' => array (
												'laboratory_id' => $this->data ['Laboratory'] ['laboratory_id'],
												'department' => $dept,
												'CorporateLabRate.location_id' => $this->Session->read ( 'locationid' ) 
										) 
								) 
						) 
				) );
				
				$corporatesRate = $this->TariffStandard->find ( 'all', array (
						'fields' => array (
								'CorporateLabRate.id',
								'CorporateLabRate.nabh_rate',
								'CorporateLabRate.non_nabh_rate',
								'CorporateLabRate.tariff_standard_id',
								'TariffStandard.name',
								'TariffStandard.id' 
						),
						'conditions' => array (
								'TariffStandard.is_deleted' => 0,
								'TariffStandard.location_id' => $locationId 
						) 
				) );
				
				$testName = $this->$model->find ( 'first', array (
						'fields' => array (
								'name' 
						),
						'conditions' => array (
								'id' => $this->data ['Laboratory'] ['laboratory_id'] 
						) 
				) );
				$this->set ( array (
						'corporates_rate' => $corporatesRate,
						'test_name' => ucfirst ( $testName [$model] ['name'] ),
						'department' => $this->data ['Laboratory'] ['department'],
						'labId' => $this->data ['Laboratory'] ['laboratory_id'] 
				) );
				$this->render ( 'ajax_corporate_rate_list' );
			} else {
				if (isset ( $this->request->data ) && ! empty ( $this->request->data )) {
					if (($this->CorporateLabRate->insertLabRate ( $this->request->data ))) {
						$this->Session->setFlash ( __ ( 'Rates has been added successfully' ), 'default', array (
								'class' => 'message' 
						) );
						$this->redirect ( $this->referer () );
					}
					$errors = $this->Laboratory->invalidFields ();
					if (! empty ( $errors )) {
						$this->set ( "errors", $errors );
					}
				}
			}
		} // EOF function
		
		/**
		 * Funtion for lab order
		 *
		 * @param $patient_id :patient
		 *        	id
		 * @return unknown_type
		 */
		function lab_order($patient_id = null) {
			$this->uses = array (
					'Person',
					'Patient',
					'ServiceProvider',
					'Consultant',
					'User',
					'LaboratoryTestOrder',
					'LaboratoryResult',
					'RadiologyTestOrder',
					'Radiology',
					'RadiologyReport',
					'RadiologyResult' 
			);
			
			if (! empty ( $patient_id )) {
				$this->patient_info ( $patient_id ); // patient details
				                                     // BOF referer link
				$sessionReturnString = $this->Session->read ( 'labReturn' );
				$currentReturnString = $this->params->query ['return'];
				if (($currentReturnString != '') && ($currentReturnString != $sessionReturnString)) {
					$this->Session->write ( 'labReturn', $currentReturnString );
				}
				// EOF referer link
				// lab tests
				$data1 = $this->RadiologyReport->find ( 'all', array (
						'fields' => array (
								'RadiologyReport.id',
								'RadiologyReport.patient_id',
								'RadiologyReport.file_name',
								'RadiologyReport.description' 
						),
						'conditions' => array (
								'RadiologyReport.patient_id' => $patient_id,
								'RadiologyReport.is_deleted' => '0' 
						) 
				) );
				for($a = 0; $a < count ( $data1 ); $a ++) {
					// $b[]= '"../../uploads/radiology/'.$data1[$a][RadiologyReport][file_name].'"';
					$b [] = '"' . $this->webroot . 'uploads/radiology/' . $data1 [$a] [RadiologyReport] [file_name] . '"';
					$c [] = '"' . $data1 [$a] ['RadiologyReport'] ['description'] . '"';
				}
				// debug($b);
				$this->set ( 'data1', $data1 );
				$this->set ( 'b', $b );
				$this->set ( 'c', $c );
				
				$dept = ! empty ( $this->params->query ['dept'] ) ? $this->params->query ['dept'] : '';
				if ($dept == 'radiology') {
					// $this->set($this->requestAction('radiologies/radiology_order/'.$patient_id));
					// calling service provider for labs
					$this->set ( 'serviceProviders', $this->ServiceProvider->getServiceProvider ( 'radiology' ) );
					// BOF code from radiology controller
					$dept = isset ( $this->params->query ['dept'] ) ? $this->params->query ['dept'] : '';
					$testDetails = $this->RadiologyTestOrder->find ( 'count', array (
							'conditions' => array (
									'patient_id' => $patient_id 
							) 
					) );
					
					if ($testDetails) {
						// BOF new code
						$testArray = $testDetails ['RadiologyTestOrder'] ['radiology_id'];
						$this->RadiologyTestOrder->bindModel ( array (
								'belongsTo' => array (
										'Radiology' => array (
												'type' => 'inner',
												'foreignKey' => 'radiology_id' 
										) 
								),
								'hasOne' => array (
										'RadiologyResult' => array (
												'foreignKey' => 'radiology_test_order_id' 
										) 
								) 
						), false );
						
						$this->paginate = array (
								'limit' => Configure::read ( 'number_of_rows' ),
								'fields' => array (
										'RadiologyTestOrder.batch_identifier',
										'RadiologyResult.confirm_result',

										'RadiologyTestOrder.id',
										'RadiologyTestOrder.create_time',
										'RadiologyTestOrder.order_id',
										'Radiology.id',
										'Radiology.name' 
								),
								'conditions' => array (
										'RadiologyTestOrder.patient_id' => $patient_id,
										'RadiologyTestOrder.is_deleted' => 0 
								),
								'order' => array (
										'Radiology.name' => 'desc' 
								),
								'group' => array (
										'RadiologyTestOrder.id' 
								) 
						);
						$testOrdered = $this->paginate ( 'RadiologyTestOrder' );
						
						$TestOrderedlabId = implode ( ',', $this->RadiologyTestOrder->find ( 'list', array (
								'fields' => array (
										'radiology_id' 
								),
								'conditions' => array (
										'RadiologyTestOrder.patient_id' => $patient_id,
										'RadiologyTestOrder.is_deleted' => 0 
								) 
						) ) );
						
						$labTest = $this->Radiology->find ( 'list', array (
								'fields' => array (
										'Radiology.id',
										'Radiology.name' 
								),
								'conditions' => array (
										'is_active' => 1,
										'Radiology.location_id' => $this->Session->read ( 'locationid' ) 
								),
								'order' => array (
										'Radiology.name' 
								) 
						) );
						
						// EOD new code
					} else {
						$labTest = $this->Radiology->find ( 'list', array (
								'fields' => array (
										'id',
										'name' 
								),
								'conditions' => array (
										'is_active' => 1,
										'Radiology.location_id' => $this->Session->read ( 'locationid' ) 
								),
								'order' => array (
										'Radiology.name' 
								) 
						) );
						$testOrdered = '';
					}
					$this->set ( array (
							'test_data' => $labTest,
							'test_ordered' => $testOrdered 
					) );
					// EOF code form radiology controller
				} else if ($dept == 'histology') {
					$this->set ( $this->requestAction ( 'histologies/histology_order/' . $patient_id ) );
				} else {
					$testDetails = $this->LaboratoryTestOrder->find ( 'count', array (
							'conditions' => array (
									'patient_id' => $patient_id 
							) 
					) );
					// calling service provider for labs
					$this->set ( 'serviceProviders', $this->ServiceProvider->getServiceProvider ( 'lab' ) );
					if ($testDetails) {
						
						$testArray = $testDetails ['LaboratoryTestOrder'] ['laboratory_id'];
						$this->LaboratoryTestOrder->bindModel ( array (
								'belongsTo' => array (
										'Laboratory' => array (
												'foreignKey' => 'laboratory_id',
												'conditions' => array (
														'Laboratory.location_id' => $this->Session->read ( 'locationid' ) 
												) 
										) 
								),
								'hasOne' => array (
										'LaboratoryResult' => array (
												'foreignKey' => 'laboratory_test_order_id' 
										) 
								) 
						), false );
						/* $testOrdered = $this->LaboratoryTestOrder->find('list',array('fields'=>array('Laboratory.id','Laboratory.name'),'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patient_id),"recursive" => 1 )); */
						
						$this->paginate = array (
								'limit' => Configure::read ( 'number_of_rows' ),
								'fields' => array (
										'LaboratoryTestOrder.batch_identifier',
										'LaboratoryResult.confirm_result',
										'LaboratoryResult.is_whatsapp_sent',
										'LaboratoryTestOrder.id',
										'LaboratoryTestOrder.create_time',
										'LaboratoryTestOrder.order_id',
										'Laboratory.id',
										'Laboratory.name' 
								),
								'conditions' => array (
										'LaboratoryTestOrder.patient_id' => $patient_id,
										'LaboratoryTestOrder.is_deleted' => 0 
								),
								'order' => array (
										'Laboratory.name' => 'desc' 
								),
								'group' => array (
										'LaboratoryTestOrder.id' 
								) 
						);
						$testOrdered = $this->paginate ( 'LaboratoryTestOrder' );
						
						$TestOrderedlabId = implode ( ',', $this->LaboratoryTestOrder->find ( 'list', array (
								'fields' => array (
										'laboratory_id' 
								),
								'conditions' => array (
										'LaboratoryTestOrder.patient_id' => $patient_id,
										'LaboratoryTestOrder.is_deleted' => 0 
								) 
						) ) );
						
						$labTest = $this->Laboratory->find ( 'list', array (
								'fields' => array (
										'Laboratory.id',
										'Laboratory.name' 
								),
								'conditions' => array (
										'is_active' => 1,
										'Laboratory.location_id' => $this->Session->read ( 'locationid' ) 
								),
								'order' => array (
										'Laboratory.name' 
								) 
						) );
						
						/* $labTest = $this->Laboratory->find('list',array('fields'=>array('Laboratory.id','Laboratory.name'),'conditions'=>array("id not in ($TestOrderedlabId)",'is_active'=>1))); */
					} else {
						$labTest = $this->Laboratory->find ( 'list', array (
								'order' => array (
										'Laboratory.name' 
								),
								'fields' => array (
										'id',
										'name' 
								),
								'conditions' => array (
										'is_active' => 1,
										'Laboratory.location_id' => $this->Session->read ( 'locationid' ) 
								) 
						) );
						$testOrdered = '';
					}
					$this->set ( array (
							'test_data' => $labTest,
							'test_ordered' => $testOrdered 
					) );
				}
			} else {
				$this->Session->setFlash ( __ ( 'Please try again' ), 'default', array (
						'class' => 'error' 
				) );
				$this->redirect ( $this->referer () );
			}
		}
		function ajax_sort_test() {
			$this->layout = false;
			$this->uses = array (
					'LaboratoryTestOrder' 
			);
			
			$this->LaboratoryTestOrder->bindModel ( array (
					'belongsTo' => array (
							'Laboratory' => array (
									'foreignKey' => 'laboratory_id',
									'conditions' => array (
											'Laboratory.is_active' => 1 
									) 
							) 
					) 
			) );
			
			$TestOrderedlabId = implode ( ',', $this->LaboratoryTestOrder->find ( 'list', array (
					'fields' => array (
							'laboratory_id' 
					),
					'conditions' => array (
							'is_deleted' => 0 
					) 
			) ) );
			
			if (! empty ( $_GET ['searchParam'] )) {
				$cond = array (
						'Laboratory.is_active' => 1,
						'Laboratory.location_id' => $this->Session->read ( 'locationid' ),
						"Laboratory.name like '" . $_GET ['searchParam'] . "%'" 
				);
			} else {
				$cond = array (
						'Laboratory.is_active' => 1,
						'Laboratory.location_id' => $this->Session->read ( 'locationid' ) 
				);
			}
			
			$testData = $this->Laboratory->find ( 'list', array (
					'fields' => array (
							'id',
							'name' 
					),
					'conditions' => $cond,
					'order' => array (
							'Laboratory.name' 
					) 
			) );
			$testOrdered = '';
			
			echo json_encode ( $testData );
			exit ();
		}
		function lab_test_order($patient_id = null) {
			if (! empty ( $patient_id ) && isset ( $this->request->data ) && ! empty ( $this->request->data )) {
				$this->uses = array (
						'LaboratoryTestOrder' 
				);
				
				if (empty ( $this->request->data ['LaboratoryTestOrder'] ['id'] ) && empty ( $this->request->data ['LaboratoryTestOrder'] ['laboratory_id'] )) {
					$this->Session->setFlash ( __ ( 'Please select test' ), 'default', array (
							'class' => 'error' 
					) );
					$this->redirect ( array (
							"action" => "lab_order",
							$patient_id 
					) );
				} else {
					if ($this->LaboratoryTestOrder->insertTestOrder ( $this->request->data )) { // save patient's required test
						$this->Session->setFlash ( __ ( 'Submitted Successfully' ), 'default', array (
								'class' => 'message' 
						) );
					} else {
						$this->Session->setFlash ( __ ( 'Unable to submit , Please try again' ), 'default', array (
								'class' => 'error' 
						) );
					}
					$this->redirect ( array (
							"action" => "lab_order",
							$patient_id 
					) );
				}
			}
		}
		
		// function to dispaly list of test list
		function lab_test_list($patient_id = null) {
			$this->uses = array (
					'Person',
					'Patient',
					'Consultant',
					'User',
					'LabManager',
					'LaboratoryResult',
					'RadiologyTestOrder',
					'RadiologyReport',
					'RadiologyResult',
					'Radiology' 
			);
			if (! empty ( $patient_id )) {
				// BOF referer link
				$data1 = $this->RadiologyReport->find ( 'all', array (
						'fields' => array (
								'RadiologyReport.id',
								'RadiologyReport.patient_id',
								'RadiologyReport.file_name',
								'RadiologyReport.description' 
						),
						'conditions' => array (
								'RadiologyReport.patient_id' => $patient_id,
								'RadiologyReport.is_deleted' => '0' 
						) 
				) );
				for($a = 0; $a < count ( $data1 ); $a ++) {
					// $b[]= '"../../uploads/radiology/'.$data1[$a][RadiologyReport][file_name].'"';
					$b [] = '"' . $this->webroot . 'uploads/radiology/' . $data1 [$a] [RadiologyReport] [file_name] . '"';
					$c [] = '"' . $data1 [$a] ['RadiologyReport'] ['description'] . '"';
				}
				// debug($b);
				$this->set ( 'data1', $data1 );
				$this->set ( 'b', $b );
				$this->set ( 'c', $c );
				
				$sessionReturnString = $this->Session->read ( 'labResultReturn' );
				$currentReturnString = $this->params->query ['return'];
				if (($currentReturnString != '') && ($currentReturnString != $sessionReturnString)) {
					$this->Session->write ( 'labResultReturn', $currentReturnString );
				}
				// EOF referer link
				// debug($patient_id);
				$this->patient_info ( $patient_id );
				
				$this->LabManager->bindModel ( array (
						'belongsTo' => array (
								'Laboratory' => array (
										'foreignKey' => 'laboratory_id',
										'conditions' => array (
												'Laboratory.is_active' => 1 
										) 
								) 
						),
						'hasOne' => array (
								'LaboratoryResult' => array (
										'foreignKey' => 'laboratory_test_order_id' 
								),
								'LaboratoryToken' => array (
										'foreignKey' => 'laboratory_test_order_id' 
								) 
						) 
				), false );
				
				$this->paginate = array (
						'limit' => Configure::read ( 'number_of_rows' ),
						'fields' => array (
								'LaboratoryResult.result_publish_date',
								'LaboratoryResult.confirm_result',
								'LaboratoryResult.is_whatsapp_sent',
								'LabManager.id',
								'LabManager.create_time',
								'LabManager.patient_id',
								'LabManager.order_id',
								'Laboratory.id',
								'Laboratory.name',
								'LaboratoryToken.ac_id',
								'LaboratoryToken.sp_id' 
						),
						'conditions' => array (
								'LabManager.patient_id' => $patient_id,
								'LabManager.is_deleted' => 0 
						),
						'order' => array (
								'LabManager.id' => 'asc' 
						),
						'group' => 'LabManager.id' 
				);
				$testOrdered = $this->paginate ( 'LabManager' );
				$this->set ( array (
						'testOrdered' => $testOrdered 
				) );
				// echo '<pre>';print_r($testOrdered);exit;
				/*
				 * if($this->Session->read('role')=='doctor'){
				 * $this->render('doctor_test_list');
				 * }
				 */
			} else {
				$this->Session->setFlash ( __ ( 'Please try again' ), 'default', array (
						'class' => 'error' 
				) );
				$this->redirect ( $this->referer () );
			}
		}
		
		// function lab-result for lab-manager as well as doctors
		function lab_result($patient_id = null, $lab_id = null, $order_id = null) {
			$this->uses = array (
					'LaboratoryTestOrder',
					'LaboratoryParameter',
					'LaboratoryCategory',
					'LaboratoryResult',
					'LaboratoryToken',
					'Laboratory',
					'TestGroup' 
			);
			if (! empty ( $patient_id )) {
				$this->patient_info ( $patient_id );
				// test assign to patient
				$testDetails = $this->LaboratoryTestOrder->find ( 'first', array (
						'fields' => array (
								'id',
								'patient_id',
								'laboratory_id' 
						),
						'conditions' => array (
								'patient_id' => $patient_id,
								'LaboratoryTestOrder.is_deleted' => 0 
						) 
				) );
				
				if (! empty ( $testDetails ['LaboratoryTestOrder'] ['laboratory_id'] )) {
					$testArray = $testDetails ['LaboratoryTestOrder'] ['laboratory_id'];
					$this->LaboratoryTestOrder->bindModel ( array (
							'belongsTo' => array (
									'Laboratory' => array (
											'foreignKey' => 'laboratory_id',
											'conditions' => array (
													'Laboratory.is_active' => 1 
											) 
									) 
							) 
					), false );
					/* $testOrdered = $this->LaboratoryTestOrder->find('list',array('fields'=>array('Laboratory.id','Laboratory.name'),'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patient_id),'recursive'=>1)); */
					// for lab test name
					$labNameResult = $this->Laboratory->read ( 'name,test_group_id', $lab_id );
					$this->set ( 'labTest', $labNameResult ['Laboratory'] ['name'] );
					$this->set ( array (
							'lab_id' => $lab_id,
							'order_id' => $order_id 
					) );
					// test attributs
					if (! empty ( $lab_id )) {
						$testId = $lab_id;
						if (! empty ( $testId )) {
							$this->LaboratoryCategory->bindModel ( array (
									'hasMany' => array (
											'LaboratoryParameter' => array (
													'foreignKey' => 'laboratory_categories_id' 
											),
											'LaboratoryResult' => array (
													'foreignKey' => 'laboratory_categories_id',
													'conditions' => array (
															'LaboratoryResult.patient_id' => $patient_id,
															'LaboratoryResult.laboratory_test_order_id' => $order_id 
													) 
											) 
									) 
							) );
							
							$testAtrributes = $this->LaboratoryCategory->find ( 'all', array (
									'conditions' => array (
											'laboratory_id' => $testId 
									) 
							) );
							
							$token = $this->LaboratoryToken->find ( 'first', array (
									'fields' => array (
											'sp_id',
											'ac_id',
											'collected_date' 
									),
									'conditions' => array (
											'LaboratoryToken.laboratory_id' => $testId,
											'LaboratoryToken.laboratory_test_order_id' => $order_id,
											'LaboratoryToken.patient_id' => $patient_id 
									) 
							) );
							
							$testCat = $this->LaboratoryCategory->find ( 'list', array (
									'fields' => array (
											'category_name' 
									),
									'conditions' => array (
											'laboratory_id' => $testId 
									) 
							) );
							$testOrder = $this->LaboratoryTestOrder->read ( null, $order_id );
							
							$pathologist = $this->User->getPathologist ();
							$testGroup = $this->TestGroup->getGroupByID ( $labNameResult ['Laboratory'] ['test_group_id'] );
							
							$this->set ( array (
									'test_atrributes' => $testAtrributes,
									'category' => $testCat,
									'token' => $token,
									'testOrder' => $testOrder,
									'lab_id' => $lab_id,
									'lab_test_order_id' => $order_id,
									'pathologist' => $pathologist,
									'testGroup' => $testGroup ['TestGroup'] ['name'] 
							) );
						}
					} else if (isset ( $this->request->data ['LaboratoryResult'] )) {
						if ($this->request->data ['LaboratoryResult'] ['confirm_result'] == 1) {
							// set publish date
							if (! empty ( $this->request->data ['LaboratoryResult'] ['result_publish_date'] )) {
								$this->request->data ['LaboratoryResult'] ['result_publish_date'] = $this->DateFormat->formatDate2STD ( $this->request->data ['LaboratoryResult'] ['result_publish_date'], 'dd/mm/yyyy' );
							}
						} else {
							$this->request->data ['LaboratoryResult'] ['result_publish_date'] = '';
						}
						$this->request->data ['LaboratoryTestOrder'] ['id'] = $order_id;
						$this->request->data ['LaboratoryResult'] ['patient_id'] = $patient_id;
						$this->request->data ['LaboratoryResult'] ['laboratory_id'] = $lab_id;
						
						// echo '<pre>';print_r($this->request->data);exit;
						if ($this->LaboratoryResult->insertLabResults ( $this->request->data )) {
							$this->Session->setFlash ( __ ( 'Lab result save successfully' ), 'default', array (
									'class' => 'message' 
							) );
							$this->redirect ( array (
									'action' => 'lab_test_list',
									$patient_id 
							) );
						} else {
							$this->Session->setFlash ( __ ( 'There is some problem , please try again' ), 'default', array (
									'class' => 'error' 
							) );
						}
					}
				} else {
					$testOrdered = '';
				}
				
				if ($this->Session->read ( 'role' ) == Configure::read ( 'doctor' )) {
					$this->render ( 'doctor_lab_result' );
				} else {
					$this->render ( 'lab_result' );
				}
			} else {
				$this->Session->setFlash ( __ ( 'Please try again' ), 'default', array (
						'class' => 'error' 
				) );
				$this->redirect ( $this->referer () );
			}
		}
		
		// dummy action to allow edit incharge
		function incharge_lab_result($patient_id = null, $lab_id = null, $order_id = null) {
			$this->lab_result ( $patient_id, $lab_id, $order_id );
		}
		function ajax_test_categories() {
			$this->uses = array (
					'LaboratoryCategory' 
			);
			$testCat = $this->LaboratoryCategory->find ( 'list', array (
					'fields' => array (
							'category_name' 
					),
					'conditions' => array (
							'laboratory_id' => $_GET ['lab_id'] 
					) 
			) );
			echo json_encode ( $testCat );
			exit ();
		}
		
		// ajax function to display test order form with SPID and ACID
		function lab_manager_test_order($testid = null, $patient_id = null) {
			$layout = 'ajax';
			$this->uses = array (
					'Patient',
					'LaboratoryTestOrder',
					'LaboratoryToken' 
			);
			
			// save data
			if (! empty ( $this->request->data )) {
				if ($this->LaboratoryToken->insertToken ( $this->request->data )) {
					
					$this->Session->setFlash ( __ ( 'Record added successfully' ), true, array (
							'class' => 'message' 
					) );
					$this->redirect ( $this->referer () );
				} else {
					$this->Session->setFlash ( __ ( 'There is some problem while saving data,Please try again' ), true, array (
							'class' => 'error' 
					) );
					$this->redirect ( $this->referer () );
				}
			}
			
			$this->LaboratoryTestOrder->bindModel ( array (
					'belongsTo' => array (
							'Laboratory' => array (
									'foreignKey' => 'laboratory_id' 
							),
							'Patient' => array (
									'foreignKey' => 'patient_id' 
							),
							'LaboratoryToken' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryToken.laboratory_test_order_id= LaboratoryTestOrder.id' 
									) 
							) 
					) 
			), false );
			$data = $this->LaboratoryTestOrder->find ( 'all', array (
					'fields' => array (
							'LaboratoryTestOrder.id',
							'LaboratoryToken.id',
							'LaboratoryToken.laboratory_test_order_id',
							'LaboratoryToken.sp_id',
							'LaboratoryToken.ac_id',
							'LaboratoryToken.collected_date',
							'Patient.id',
							'Patient.lookup_name',
							'Patient.admission_id',
							'Patient.patient_id',
							'Laboratory.id',
							'Laboratory.name' 
					),
					'conditions' => array (
							'LaboratoryTestOrder.id' => $testid,
							'LaboratoryTestOrder.is_deleted' => 0 
					) 
			) );
			$patient = $this->Patient->find ( 'first', array (
					'fields' => array (
							'form_received_on' 
					),
					'conditions' => array (
							'Patient.id' => $patient_id 
					) 
			) );
			// if(!empty($tokens)){*/
			// original query
			/*
			 * $this->LaboratoryToken->bindModel(array(
			 * 'belongsTo' => array(
			 * 'Laboratory'=>array('type'=>'RIGHT','foreignKey'=>'laboratory_id' ,'conditions'=>array('Laboratory.is_active'=>1)),
			 * 'LaboratoryTestOrder'=>array('type'=>'RIGHT','foreignKey'=>'laboratory_test_order_id'),
			 * 'Patient'=>array('type'=>'RIGHT','foreignKey'=>'patient_id'),
			 * )),false);
			 * $data = $this->LaboratoryToken->find('all',array('fields'=>array('LaboratoryToken.id','LaboratoryToken.laboratory_test_order_id','LaboratoryToken.sp_id','LaboratoryToken.ac_id','Patient.id','Patient.lookup_name','Patient.admission_id','Patient.patient_id','Laboratory.id','Laboratory.name'),'conditions'=>array('LaboratoryToken.laboratory_test_order_id'=>$testid),'recursive'=>1,'Laboratory.is_active'=>1));
			 */
			/*
			 * }else{
			 * $data = $this->LaboratoryTestOrder->find('all',array('fields'=>array('Patient.id','Patient.lookup_name','Patient.admission_id','Patient.patient_id','Laboratory.id','Laboratory.name'),
			 * 'conditions'=>array('Patient.id'=>$patient_id),'recursive'=>1,'Laboratory.is_active'=>1));
			 *
			 * }
			 */
			// pr($patient);
			// echo '<pre>';print_r($data);exit;
			
			$this->set ( array (
					'data' => $data,
					'patient_id' => $patient_id,
					'patient' => $patient 
			) );
		}
		function departmentwise_testlist() {
			$dept = $this->data ['dept'];
			
			if ($dept == 'lab') {
				$this->uses = array (
						'Laboratory' 
				);
				$data = $this->Laboratory->find ( 'list', array (
						'conditions' => array (
								'is_active' => 1,
								'location_id' => $this->Session->read ( 'locationid' ) 
						),
						'fields' => array (
								'id',
								'name' 
						) 
				) );
			} else if ($dept == 'radiology') {
				$this->uses = array (
						'Radiology' 
				);
				$data = $this->Radiology->find ( 'list', array (
						'conditions' => array (
								'is_active' => 1,
								'location_id' => $this->Session->read ( 'locationid' ) 
						),
						'fields' => array (
								'id',
								'name' 
						) 
				) );
			} else if ($dept == 'histology') {
				$this->uses = array (
						'Histology' 
				);
				$data = $this->Histology->find ( 'list', array (
						'conditions' => array (
								'is_active' => 1,
								'location_id' => $this->Session->read ( 'locationid' ) 
						),
						'fields' => array (
								'id',
								'name' 
						) 
				) );
			}
			echo json_encode ( $data );
			exit ();
		}
		
		// fucntion to print lab result for eachtest
		function print_preview($patient_id = null, $lab_id = null, $order_id = null) {
			$this->layout = "print";
			$this->uses = array (
					'Person',
					'Patient',
					'Consultant',
					'User',
					'LaboratoryTestOrder',
					'LaboratoryParameter',
					'LaboratoryCategory',
					'LaboratoryResult',
					'LaboratoryToken',
					'TestGroup' 
			);
			if (! empty ( $patient_id )) {
				$this->patient_info ( $patient_id );
				// test assign to patient
				$testDetails = $this->LaboratoryTestOrder->find ( 'first', array (
						'fields' => array (
								'id',
								'patient_id',
								'laboratory_id',
								'order_id' 
						),
						'conditions' => array (
								'patient_id' => $patient_id,
								'id' => $order_id,
								'LaboratoryTestOrder.is_deleted' => 0 
						) 
				) );
				
				if (! empty ( $testDetails ['LaboratoryTestOrder'] ['laboratory_id'] )) {
					$testArray = $testDetails ['LaboratoryTestOrder'] ['laboratory_id'];
					$this->LaboratoryTestOrder->bindModel ( array (
							'belongsTo' => array (
									'Laboratory' => array (
											'foreignKey' => 'laboratory_id',
											'conditions' => array (
													'Laboratory.is_active' => 1 
											) 
									) 
							) 
					), false );
					/* $testOrdered = $this->LaboratoryTestOrder->find('list',array('fields'=>array('Laboratory.id','Laboratory.name'),'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patient_id),'recursive'=>1)); */
					
					// test attributs
					if (! empty ( $lab_id )) {
						$testId = $lab_id;
						if (! empty ( $testId )) {
							$this->LaboratoryCategory->bindModel ( array (
									'belongsTo' => array (
											'Laboratory' => array (
													'foreignKey' => 'laboratory_id' 
											) 
									),
									'hasMany' => array (
											'LaboratoryParameter' => array (
													'foreignKey' => 'laboratory_categories_id' 
											),
											'LaboratoryResult' => array (
													'foreignKey' => 'laboratory_categories_id',
													'conditions' => array (
															'LaboratoryResult.patient_id' => $patient_id 
													) 
											) 
									) 
							) );
							
							$testAtrributes = $this->LaboratoryCategory->find ( 'all', array (
									'fields' => array (
											'LaboratoryCategory.*,Laboratory.name',
											'Laboratory.test_group_id' 
									),
									'conditions' => array (
											'LaboratoryCategory.laboratory_id' => $testId 
									) 
							) );
							
							$token = $this->LaboratoryToken->find ( 'first', array (
									'fields' => array (
											'sp_id',
											'ac_id',
											'collected_date' 
									),
									'conditions' => array (
											'LaboratoryToken.laboratory_id' => $testId,
											'LaboratoryToken.laboratory_test_order_id' => $order_id,
											'LaboratoryToken.patient_id' => $patient_id 
									) 
							) );
							
							$testCat = $this->LaboratoryCategory->find ( 'list', array (
									'fields' => array (
											'category_name' 
									),
									'conditions' => array (
											'laboratory_id' => $testId 
									) 
							) );
							// $labResult = $this->LaboratoryResult->find('all',array('conditions'=>array('laboratory_id'=>$testId,'LaboratoryResult.patient_id'=>$patient_id)));
							$pathFields = array (
									'User.full_name' 
							);
							$pathologist = $this->User->getUserByID ( $testAtrributes [0] ['LaboratoryResult'] [0] ['user_id'], $pathFields );
							// $this->set(array('test_atrributes'=>$testAtrributes,'category'=>$testCat,'labResult'=>$labResult));
							
							$testGroup = $this->TestGroup->getGroupByID ( $testAtrributes [0] ['Laboratory'] ['test_group_id'] );
							$testOrder = $this->LaboratoryTestOrder->read ( null, $order_id );
							$this->set ( array (
									'test_atrributes' => $testAtrributes,
									'category' => $testCat,
									'token' => $token,
									'lab_id' => $lab_id,
									'testOrder' => $testOrder,
									'lab_test_order_id' => $order_id,
									'pathologist' => $pathologist,
									'testGroup' => $testGroup ['TestGroup'] ['name'] 
							) );
						}
					}
				} else {
					$testOrdered = '';
				}
			} else {
				$this->Session->setFlash ( __ ( 'Please try again' ), 'default', array (
						'class' => 'error' 
				) );
				$this->redirect ( $this->referer () );
			}
		}
		
		// function returns list of patient whose receipts has to be generated
		function receipts() {
			$this->uses = array (
					'Patient',
					'LaboratoryTestOrder',
					'LaboratoryToken' 
			);
			$this->set ( 'data', '' );
			$this->paginate = array (
					'limit' => Configure::read ( 'number_of_rows' ),
					'order' => array (
							'Patient.id' => 'asc' 
					) 
			);
			
			$role = $this->Session->read ( 'role' );
			$search_key ['Patient.is_deleted'] = 0;
			$search_key ['Laboratory.location_id'] = $this->Session->read ( 'locationid' );
			$search_key ['LaboratoryTestOrder.is_deleted'] = 0;
			$this->Patient->bindModel ( array (
					'belongsTo' => array (
							'User' => array (
									'foreignKey' => false,
									'conditions' => array (
											'User.id=Patient.doctor_id' 
									) 
							) 
					) 
			), false );
			$this->LaboratoryTestOrder->bindModel ( array (
					'belongsTo' => array (
							'Laboratory' => array (
									'foreignKey' => 'laboratory_id',
									'conditions' => array (
											'Laboratory.is_active' => 1 
									) 
							),
							'Patient' => array (
									'foreignKey' => 'patient_id' 
							),
							'Person' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Person.id=Patient.person_id' 
									) 
							),
							'PatientInitial' => array (
									'foreignKey' => false,
									'conditions' => array (
											'PatientInitial.id =Person.initial_id' 
									) 
							),
							'User' => array (
									'foreignKey' => false,
									'conditions' => array (
											'User.id=Patient.doctor_id' 
									) 
							),
							'LabTestPayment' => array (
									'type' => 'inner',
									'foreignKey' => false,
									'conditions' => array (
											'LabTestPayment.patient_id=LaboratoryTestOrder.patient_id' 
									) 
							) 
					) 
			), false );
			
			$this->LaboratoryTestOrder->bindModel ( array (
					'hasOne' => array (
							'LaboratoryToken' => array (
									'foreignKey' => 'laboratory_test_order_id' 
							) 
					) 
			), false );
			$this->LaboratoryTestOrder->bindModel ( array (
					'hasOne' => array (
							'Initial' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Initial.id=User.initial_id' 
									) 
							) 
					) 
			), false );
			if (! empty ( $this->params->query )) {
				$search_ele = $this->params->query; // make it get
				
				if (! empty ( $search_ele ['lab_test_name'] )) {
					$search_key ['Laboratory.name'] = $search_ele ['lab_test_name'];
				}
				if (! empty ( $search_ele ['radiology_test_name'] )) {
				}
				if (! empty ( $search_ele ['histology_test_name'] )) {
				}
				
				if (! empty ( $search_ele ['lookup_name'] )) {
					$search_key ['Patient.lookup_name like '] = "%" . trim ( $search_ele ['lookup_name'] ) . "%";
				}
				if (! empty ( $search_ele ['patient_id'] )) {
					$search_key ['Patient.patient_id like '] = "%" . trim ( $search_ele ['patient_id'] );
				}
				if (! empty ( $search_ele ['admission_id'] )) {
					$search_key ['Patient.admission_id like '] = "%" . trim ( $search_ele ['admission_id'] );
				}
				
				if (! empty ( $search_ele ['from'] ) && ! empty ( $search_ele ['to'] )) {
					
					$formDate = $this->DateFormat->formatDate2STDForReport ( $search_ele ['from'], Configure::read ( 'date_format' ) );
					$toDate = $this->DateFormat->formatDate2STDForReport ( $search_ele ['to'], Configure::read ( 'date_format' ) );
					// $search_key['LaboratoryTestOrder.create_time BETWEEN ? AND ? '] = array(trim($formDate),trim($toDate)) ;
					
					// get record between two dates. Make condition
					$search_key ['LaboratoryTestOrder.create_time <='] = $toDate . " 23:59:59";
					$search_key ['LaboratoryTestOrder.create_time >='] = $formDate;
				} else if (! empty ( $search_ele ['from'] )) {
					$search_key ['LaboratoryTestOrder.create_time > '] = "%" . trim ( $search_ele ['from'] );
				}
				
				$this->paginate = array (
						'limit' => Configure::read ( 'number_of_rows' ),
						'order' => array (
								'Patient.id' => 'asc' 
						),
						'fields' => array (
								'Laboratory.name,PatientInitial.name,Patient.lookup_name,LaboratoryTestOrder.order_id,LaboratoryToken.ac_id,LaboratoryToken.sp_id,LaboratoryTestOrder.id,LaboratoryTestOrder.create_time,
							Patient.id,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time, Initial.name' 
						),
						'conditions' => $search_key,
						'group' => array (
								'Patient.id' 
						) 
				);
				
				$this->set ( 'data', $this->paginate ( 'LaboratoryTestOrder' ) );
			} else {
				$search_key ['LaboratoryTestOrder.create_time like'] = date ( "Y-m-d" ) . "%";
				// BOF New code
				$this->paginate = array (
						'limit' => Configure::read ( 'number_of_rows' ),
						'order' => array (
								'Patient.id' => 'asc' 
						),
						'fields' => array (
								'Laboratory.name,PatientInitial.name,Patient.lookup_name,LaboratoryTestOrder.order_id,LaboratoryTestOrder.id,LaboratoryTestOrder.create_time,LaboratoryToken.ac_id,LaboratoryToken.sp_id,
							Patient.id,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time, Initial.name' 
						),
						'group' => array (
								'Patient.id' 
						),
						'conditions' => array (
								'LaboratoryTestOrder.is_deleted' => 0 
						) 
				);
				$this->LaboratoryTestOrder->PaginateCount ();
				$this->set ( 'data', $this->paginate ( 'LaboratoryTestOrder' ) );
				// EOF new code
			}
		}
		
		// function returns list of patient whose receipts has to be generated
		function payment() {
			$this->uses = array (
					'Patient',
					'LaboratoryTestOrder',
					'LaboratoryToken',
					'LabTestPayment' 
			);
			$this->set ( 'data', '' );
			$this->paginate = array (
					'limit' => Configure::read ( 'number_of_rows' ),
					'order' => array (
							'Patient.id' => 'asc' 
					) 
			);
			
			$role = $this->Session->read ( 'role' );
			$search_key ['Patient.is_deleted'] = 0;
			$search_key ['Laboratory.location_id'] = $this->Session->read ( 'locationid' );
			$this->Patient->bindModel ( array (
					'belongsTo' => array (
							'User' => array (
									'foreignKey' => false,
									'conditions' => array (
											'User.id=Patient.doctor_id' 
									) 
							) 
					) 
			), false );
			$this->LaboratoryTestOrder->bindModel ( array (
					'belongsTo' => array (
							'Laboratory' => array (
									'foreignKey' => 'laboratory_id',
									'conditions' => array (
											'Laboratory.is_active' => 1 
									) 
							),
							'Patient' => array (
									'foreignKey' => 'patient_id' 
							),
							'Person' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Person.id=Patient.person_id' 
									) 
							),
							'PatientInitial' => array (
									'foreignKey' => false,
									'conditions' => array (
											'PatientInitial.id =Person.initial_id' 
									) 
							),
							'User' => array (
									'foreignKey' => false,
									'conditions' => array (
											'User.id=Patient.doctor_id' 
									) 
							) 
					) 
			), false );
			/* 'LabTestPayment'=>array('foreignKey' => false,'conditions'=>array('LabTestPayment.patient_id=LaboratoryTestOrder.patient_id')) */
			$this->LaboratoryTestOrder->bindModel ( array (
					'hasOne' => array (
							'LaboratoryToken' => array (
									'foreignKey' => 'laboratory_test_order_id' 
							) 
					) 
			), false );
			$this->LaboratoryTestOrder->bindModel ( array (
					'hasOne' => array (
							'Initial' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Initial.id=User.initial_id' 
									) 
							) 
					) 
			), false );
			// cond for to remove patient from listing after full payment
			// $search_key['LabTestPayment.status !='] = 'paid' ;
			if (! empty ( $this->params->query )) {
				$search_ele = $this->params->query; // make it get
				$search_key ['LaboratoryTestOrder.is_deleted'] = 0;
				$search_key ['LaboratoryTestOrder.from_assessment'] = 0;
				if (! empty ( $search_ele ['lab_test_name'] )) {
					$search_key ['Laboratory.name'] = $search_ele ['lab_test_name'];
				}
				if (! empty ( $search_ele ['radiology_test_name'] )) {
				}
				if (! empty ( $search_ele ['histology_test_name'] )) {
				}
				
				if (! empty ( $search_ele ['lookup_name'] )) {
					$search_key ['Patient.lookup_name like '] = "%" . trim ( $search_ele ['lookup_name'] ) . "%";
				}
				if (! empty ( $search_ele ['patient_id'] )) {
					$search_key ['Patient.patient_id like '] = "%" . trim ( $search_ele ['patient_id'] );
				}
				if (! empty ( $search_ele ['admission_id'] )) {
					$search_key ['Patient.admission_id like '] = "%" . trim ( $search_ele ['admission_id'] );
				}
				
				if (! empty ( $search_ele ['from'] ) && ! empty ( $search_ele ['to'] )) {
					
					$formDate = $this->DateFormat->formatDate2STDForReport ( $search_ele ['from'], Configure::read ( 'date_format' ) );
					$toDate = $this->DateFormat->formatDate2STDForReport ( $search_ele ['to'], Configure::read ( 'date_format' ) );
					// $search_key['LaboratoryTestOrder.create_time BETWEEN ? AND ? '] = array(trim($formDate),trim($toDate)) ;
					
					// get record between two dates. Make condition
					$search_key ['LaboratoryTestOrder.create_time <='] = $toDate . " 23:59:59";
					$search_key ['LaboratoryTestOrder.create_time >='] = $formDate;
				} else if (! empty ( $search_ele ['from'] )) {
					$search_key ['LaboratoryTestOrder.create_time > '] = "%" . trim ( $search_ele ['from'] );
				}
				
				$this->paginate = array (
						'limit' => Configure::read ( 'number_of_rows' ),
						'order' => array (
								'LaboratoryTestOrder.id' => 'desc' 
						),
						'fields' => array (
								'Laboratory.name,PatientInitial.name,Patient.lookup_name,LaboratoryTestOrder.order_id,LaboratoryToken.ac_id,LaboratoryToken.sp_id,LaboratoryTestOrder.id,LaboratoryTestOrder.create_time,
							Patient.id,Patient.sex,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time, Initial.name' 
						),
						'conditions' => $search_key,
						'group' => array (
								'LaboratoryTestOrder.patient_id' 
						) 
				);
				
				$this->set ( 'data', $this->paginate ( 'LaboratoryTestOrder' ) );
			} else {
				// $search_key['LaboratoryTestOrder.create_time like'] = date("Y-m-d")."%";
				$search_key ['LaboratoryTestOrder.is_deleted'] = 0;
				$search_key ['LaboratoryTestOrder.from_assessment'] = 0;
				
				// BOF New code
				$this->paginate = array (
						'limit' => Configure::read ( 'number_of_rows' ),
						'order' => array (
								'LaboratoryTestOrder.id' => 'desc' 
						),
						'fields' => array (
								'Laboratory.name,PatientInitial.name,Patient.lookup_name,LaboratoryTestOrder.order_id,LaboratoryTestOrder.id,LaboratoryTestOrder.create_time,LaboratoryToken.ac_id,LaboratoryToken.sp_id,
							Patient.id,Patient.sex,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time, Initial.name' 
						),
						'conditions' => $search_key,
						'group' => array (
								'LaboratoryTestOrder.patient_id' 
						) 
				);
				
				$this->set ( 'data', $this->paginate ( 'LaboratoryTestOrder' ) );
				// EOF new code
			}
		}
		
		// fucntion to save advance/final payment of lab
		function lab_test_payment($patient_id = null) {
			$this->uses = array (
					'LaboratoryTestOrder',
					'LabTestPayment' 
			);
			$this->set ( 'patient_id', $patient_id );
			
			if (! empty ( $this->request->data )) {
				// save data
				$this->request->data ['LabTestPayment'] ['location_id'] = $this->Session->read ( 'locationid' );
				$this->request->data ['LabTestPayment'] ['create_time'] = date ( "Y-m-d H:i:s" );
				$this->request->data ['LabTestPayment'] ['created_by'] = $this->Session->read ( 'userid' );
				$totalPaidAmt = $this->request->data ['LabTestPayment'] ['paid_amount'] + $this->request->data ['LabTestPayment'] ['before_paid'];
				
				if ($this->request->data ['LabTestPayment'] ['paid_amount'] == 0 || empty ( $this->request->data ['LabTestPayment'] ['paid_amount'] ) || $totalPaidAmt > $this->request->data ['LabTestPayment'] ['total_amount']) {
					$this->Session->setFlash ( __ ( 'Please enter valid amount' ), 'default', array (
							'class' => 'error' 
					) );
					$this->redirect ( $this->referer () );
				}
				// checking if paid amt is equal to total amount
				$chPayment = $this->LabTestPayment->find ( 'first', array (
						'fields' => array (
								'id',
								'sum(paid_amount) as paid_amount ' 
						),
						'conditions' => array (
								'LabTestPayment.patient_id' => $patient_id 
						),
						'order' => array (
								'LabTestPayment.id DESC' 
						) 
				) );
				$combine = ( int ) $chPayment [0] ['paid_amount'] + $this->request->data ['LabTestPayment'] ['paid_amount'];
				if ($combine == $this->request->data ['LabTestPayment'] ['total_amount']) {
					$this->request->data ['LabTestPayment'] ['status'] = 'paid';
				}
				$result = $this->LabTestPayment->save ( $this->request->data ['LabTestPayment'] );
				if ($result) {
					$this->Session->setFlash ( __ ( 'Payment done successfully' ), 'default', array (
							'class' => 'message' 
					) );
					$this->redirect ( '/Laboratories/payment/?payment=done&id=' . $this->LabTestPayment->getLastInsertId () );
				} else {
					$this->Session->setFlash ( __ ( 'Please try again' ), 'default', array (
							'class' => 'error' 
					) );
					$this->redirect ( $this->referer () );
				}
			}
			if ($patient_id) {
				$this->patient_info ( $patient_id ); // patient details
				$tariff_standard_id = $this->patient_details ['Patient'] ['tariff_standard_id'];
				// BOF lab billing
				$this->uses = array (
						'LabTestPayment',
						'ServiceProvider',
						'LaboratoryTestOrder' 
				);
				// calling test details
				// BOF lab order
				$testDetails = $this->LaboratoryTestOrder->find ( 'count', array (
						'conditions' => array (
								'patient_id' => $patient_id 
						) 
				) );
				// calling service provider for labs
				$this->set ( 'serviceProviders', $this->ServiceProvider->getServiceProvider ( 'lab' ) );
				if ($testDetails) {
					
					$testArray = $testDetails ['LaboratoryTestOrder'] ['laboratory_id'];
					$this->LaboratoryTestOrder->bindModel ( array (
							'belongsTo' => array (
									'Laboratory' => array (
											'type' => 'inner',
											'foreignKey' => 'laboratory_id',
											'conditions' => array (
													'Laboratory.location_id' => $this->Session->read ( 'locationid' ) 
											) 
									) 
							),
							'hasOne' => array (
									'LaboratoryResult' => array (
											'foreignKey' => 'laboratory_test_order_id' 
									) 
							) 
					), false );
					/* $testOrdered = $this->LaboratoryTestOrder->find('list',array('fields'=>array('Laboratory.id','Laboratory.name'),'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patient_id),"recursive" => 1 )); */
					
					$this->paginate = array (
							'limit' => Configure::read ( 'number_of_rows' ),
							'fields' => array (
									'LaboratoryTestOrder.batch_identifier',
									'LaboratoryResult.confirm_result',
									'LaboratoryResult.is_whatsapp_sent',
									'LaboratoryTestOrder.id',
									'LaboratoryTestOrder.create_time',
									'LaboratoryTestOrder.order_id',
									'Laboratory.id',
									'Laboratory.name' 
							),
							'conditions' => array (
									'LaboratoryTestOrder.patient_id' => $patient_id,
									'LaboratoryTestOrder.is_deleted' => 0,
									'LaboratoryTestOrder.from_assessment' => 0 
							),
							'order' => array (
									'LaboratoryTestOrder.id' => 'desc' 
							),
							'group' => array (
									'LaboratoryTestOrder.id' 
							) 
					);
					$testOrdered = $this->paginate ( 'LaboratoryTestOrder' );
					
					$TestOrderedlabId = implode ( ',', $this->LaboratoryTestOrder->find ( 'list', array (
							'fields' => array (
									'laboratory_id' 
							),
							'conditions' => array (
									'LaboratoryTestOrder.patient_id' => $patient_id,
									'LaboratoryTestOrder.is_deleted' => 0 
							) 
					) ) );
					
					$labTest = $this->Laboratory->find ( 'list', array (
							'fields' => array (
									'Laboratory.id',
									'Laboratory.name' 
							),
							'conditions' => array (
									'is_active' => 1,
									'Laboratory.location_id' => $this->Session->read ( 'locationid' ) 
							) 
					) );
					
					/* $labTest = $this->Laboratory->find('list',array('fields'=>array('Laboratory.id','Laboratory.name'),'conditions'=>array("id not in ($TestOrderedlabId)",'is_active'=>1))); */
				} else {
					$labTest = $this->Laboratory->find ( 'list', array (
							'fields' => array (
									'id',
									'name' 
							),
							'conditions' => array (
									'Laboratory.location_id' => $this->Session->read ( 'locationid' ) 
							) 
					) );
					$testOrdered = '';
				}
				$this->set ( array (
						'test_data' => $labTest,
						'test_ordered' => $testOrdered 
				) );
				// EOF lab order
				
				// laboratory only
				/*
				 * $this->LaboratoryTestOrder->bindModel(array(
				 * 'belongsTo' => array(
				 * 'Laboratory'=>array('foreignKey'=>'laboratory_id','conditions'=>array('Laboratory.is_active'=>1) ),
				 * 'Patient'=>array('foreignKey'=>'patient_id'),
				 * 'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
				 * 'CorporateLabRate'=>array('foreignKey' => false,'conditions'=>
				 * array('CorporateLabRate.laboratory_id=LaboratoryTestOrder.laboratory_id',
				 * 'CorporateLabRate.tariff_standard_id=Patient.tariff_standard_id','CorporateLabRate.department="lab"'))
				 * )),false);
				 */
				// Commented as now rate of test are coming from services instead of corporate_lab_rates table
				
				$this->LaboratoryTestOrder->bindModel ( array (
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
												'TariffAmount.tariff_standard_id=' . $tariff_standard_id 
										) 
								) 
						) 
				), false );
				
				$this->LaboratoryTestOrder->bindModel ( array (
						'hasOne' => array (
								'LaboratoryToken' => array (
										'foreignKey' => 'laboratory_test_order_id',
										'conditions' => array (
												'(LaboratoryToken.ac_id !="" OR LaboratoryToken.sp_id !="" )' 
										) 
								) 
						) 
				), false );
				$laboratoryTestOrderData = $this->LaboratoryTestOrder->find ( 'all', array (
						'fields' => array (
								'Laboratory.name,LaboratoryToken.ac_id,LaboratoryToken.sp_id,TariffAmount.nabh_charges,TariffAmount.non_nabh_charges' 
						),
						'conditions' => array (
								'LaboratoryTestOrder.patient_id' => $patient_id,
								'LaboratoryTestOrder.batch_identifier' => $this->params->query ['identifier'],
								'LaboratoryTestOrder.is_deleted' => 0,
								'LaboratoryTestOrder.from_assessment' => 0 
						),
						'group' => array (
								'LaboratoryTestOrder.id' 
						) 
				) );
				
				// retrive data from lab_test_payment if has any
				$payment = $this->LabTestPayment->find ( 'first', array (
						'fields' => array (
								'id',
								'sum(paid_amount) as paid_amount ',
								'total_amount',
								'patient_id',
								'remark' 
						),
						'conditions' => array (
								'LabTestPayment.patient_id' => $patient_id,
								'LabTestPayment.batch_identifier' => $this->params->query ['identifier'] 
						),
						'order' => array (
								'LabTestPayment.id DESC' 
						) 
				) );
				// $this->data = $payment;
				
				$this->set ( array (
						'labRate' => $laboratoryTestOrderData,
						'labPayment' => $payment 
				) );
				// EOF laboratory
			} else {
				$this->Session->setFlash ( __ ( 'Please try again' ), 'default', array (
						'class' => 'error' 
				) );
				$this->redirect ( $this->referer () );
			}
			$this->set ( 'paymentDone', 'no' );
			
			$this->set ( 'lastEntry', $this->LabTestPayment->getLastInsertId () );
		}
		
		// function to dispaly paymetn receipt
		function lab_test_payment_receipt($patient_id = null) {
			$this->uses = array (
					'LabTestPayment' 
			);
			if (! empty ( $patient_id )) {
				$this->patient_info ( $patient_id ); // patient details
				                                     
				// laboratory only
				$this->LabTestPayment->bindModel ( array (
						'belongsTo' => array (
								'Patient' => array (
										'foreignKey' => 'patient_id' 
								) 
						) 
				) );
				$this->paginate = array (
						'limit' => Configure::read ( 'number_of_rows' ),
						'order' => array (
								'LabTestPayment.batch_identifier' => 'asc' 
						),
						'fields' => array (
								'LabTestPayment.batch_identifier',
								'LabTestPayment.id',
								'LabTestPayment.paid_amount ',
								'LabTestPayment.total_amount',
								'LabTestPayment.patient_id',
								'Patient.lookup_name',
								'Patient.admission_id' 
						),
						'conditions' => array (
								'LabTestPayment.patient_id' => $patient_id 
						) 
				);
				
				$this->set ( 'receiptData', $this->paginate ( 'LabTestPayment' ) );
			} else {
				$this->Session->setFlash ( __ ( 'Please try again' ), 'default', array (
						'class' => 'error' 
				) );
				$this->redirect ( array (
						'action' => 'receipts' 
				) );
			}
		}
		function lab_test_payment_receipt_print($receipt_id = null) {
			$this->layout = 'print_with_header';
			$this->uses = array (
					'LabTestPayment' 
			);
			if (! empty ( $receipt_id )) {
				// laboratory only
				$this->LabTestPayment->bindModel ( array (
						'belongsTo' => array (
								'Patient' => array (
										'foreignKey' => 'patient_id' 
								),
								'Person' => array (
										'foreignKey' => false,
										'conditions' => array (
												'Person.id=Patient.person_id' 
										) 
								),
								'PatientInitial' => array (
										'foreignKey' => false,
										'conditions' => array (
												'PatientInitial.id =Person.initial_id' 
										) 
								) 
						) 
				) );
				$data = $this->LabTestPayment->find ( 'first', array (
						'fields' => array (
								'LabTestPayment.id',
								'LabTestPayment.paid_amount ',
								'LabTestPayment.total_amount',
								'LabTestPayment.patient_id',
								'LabTestPayment.remark',
								'PatientInitial.name',
								'Patient.lookup_name',
								'Patient.admission_id',
								'LabTestPayment.create_time' 
						),
						'conditions' => array (
								'LabTestPayment.id' => $receipt_id 
						) 
				) );
				
				$this->set ( 'receiptData', $data );
				$this->investigation_print ( $data ['LabTestPayment'] ['patient_id'], $this->params->query ['identifier'] );
			} else {
				$this->Session->setFlash ( __ ( 'Please try again' ), 'default', array (
						'class' => 'error' 
				) );
				$this->redirect ( array (
						'action' => 'receipts' 
				) );
			}
		}
		
		// BOF new corporate rate list interface
		public function admin_view_tariff() {
			$this->uses = array (
					'TariffStandard' 
			);
			$this->paginate = array (
					'limit' => Configure::read ( 'number_of_rows' ),
					'order' => array (
							'TariffStandard.name' => 'desc' 
					),
					'conditions' => array (
							'TariffStandard.is_deleted' => 0,
							'TariffStandard.location_id' => $this->Session->read ( 'locationid' ) 
					) 
			);
			$data = $this->paginate ( 'TariffStandard' );
			$this->set ( 'data', $data );
		}
		public function admin_edit_tariff_amount($standardId = null) {
			if ($standardId) {
				$locationid = $this->Session->read ( 'locationid' );
				// BOF copy from
				if (! empty ( $this->request->data ['TariffStandard'] ['standardName'] )) {
					$standardIdForQuery = $this->request->data ['TariffStandard'] ['standardName'];
					$this->Laboratory->bindModel ( array (
							'belongsTo' => array (
									'CorporateLabRate' => array (
											'foreignKey' => false,
											'conditions' => array (
													'CorporateLabRate.laboratory_id=Laboratory.id',
													'department' => 'lab',
													'tariff_standard_id' => $standardIdForQuery 
											) 
									) 
							) 
					), false );
					$copyData = $this->Laboratory->Find ( 'all', array (
							'conditions' => array (
									'Laboratory.location_id' => $locationid,
									'Laboratory.is_active' => 1 
							) 
					) );
					$this->set ( 'copyData', $copyData );
				}
				// EOF copy from
				$this->uses = array (
						'CorporateLabRate',
						'Laboratory',
						'TariffStandard' 
				);
				
				$this->Laboratory->bindModel ( array (
						'belongsTo' => array (
								'CorporateLabRate' => array (
										'foreignKey' => false,
										'conditions' => array (
												'CorporateLabRate.laboratory_id=Laboratory.id',
												'department' => 'lab',
												'tariff_standard_id' => $standardId 
										) 
								) 
						) 
				), false );
				$data = $this->Laboratory->Find ( 'all', array (
						'conditions' => array (
								'Laboratory.location_id' => $locationid,
								'Laboratory.is_active' => 1 
						) 
				) );
				
				/*
				 * $this->paginate = array(
				 * 'limit' => Configure::read('number_of_rows'),
				 * 'order' => array(
				 * 'Laboratory.name' => 'desc',
				 *
				 * ),'conditions'=>$searchKey
				 * );
				 * $data = $this->paginate('Laboratory');
				 */
				$this->set ( array (
						'labData' => $data,
						'tariffStandardId' => $standardId 
				) );
				$tariffStandards = $this->TariffStandard->find ( 'list', array (
						'conditions' => array (
								'is_deleted' => 0,
								'TariffStandard.location_id' => $this->Session->read ( 'locationid' ) 
						) 
				) );
				$this->set ( 'tariffStandards', $tariffStandards );
			} else {
				$this->Session->setFlash ( __ ( 'Please try again' ), 'default', array (
						'class' => 'error' 
				) );
				$this->redirect ( $this->referer () );
			}
		}
		
		// EOF new corporate rate list interface
		public function patient_search() {
			$this->uses = array (
					'Patient' 
			);
			$this->set ( 'data', '' );
			
			$role = $this->Session->read ( 'role' );
			// Search patient as per the url request
			if (! empty ( $this->params->query ['type'] )) {
				if (strtolower ( $this->params->query ['type'] ) == 'emergency') {
					$search_key ['Patient.admission_type'] = "IPD";
					$search_key ['Patient.is_emergency'] = "1";
				} else if ($this->params->query ['type'] == 'IPD') {
					$search_key ['Patient.admission_type'] = $this->params->query ['type'];
					$search_key ['Patient.is_emergency'] = "0";
				} else {
					$search_key ['Patient.admission_type'] = $this->params->query ['type'];
				}
			}
			// EOF patient search as per category
			
			$search_key ['Patient.is_deleted'] = 0;
			$search_key ['Patient.is_discharge'] = 0; // display only non-discharge patient
			if ($role == 'admin') {
				
				// $search_key['Location.facility_id']=$this->Session->read('facilityid');
				$this->Patient->bindModel ( array (
						'belongsTo' => array (
								'User' => array (
										'foreignKey' => false,
										'conditions' => array (
												'User.id=Patient.doctor_id' 
										) 
								),
								'Initial' => array (
										'foreignKey' => false,
										'conditions' => array (
												'User.initial_id=Initial.id' 
										) 
								),
								'Location' => array (
										'foreignKey' => 'location_id' 
								),
								'Person' => array (
										'foreignKey' => false,
										'conditions' => array (
												'Person.id=Patient.person_id' 
										) 
								),
								'PatientInitial' => array (
										'foreignKey' => false,
										'conditions' => array (
												'PatientInitial.id =Person.initial_id' 
										) 
								) 
						) 
				), false );
			} else {
				$search_key ['Patient.location_id'] = $this->Session->read ( 'locationid' );
				$this->Patient->bindModel ( array (
						'belongsTo' => array (
								'User' => array (
										'foreignKey' => false,
										'conditions' => array (
												'User.id=Patient.doctor_id' 
										) 
								),
								'Initial' => array (
										'foreignKey' => false,
										'conditions' => array (
												'User.initial_id=Initial.id' 
										) 
								),
								'Person' => array (
										'foreignKey' => false,
										'conditions' => array (
												'Person.id=Patient.person_id' 
										) 
								),
								'PatientInitial' => array (
										'foreignKey' => false,
										'conditions' => array (
												'PatientInitial.id =Person.initial_id' 
										) 
								) 
						) 
				), false );
			}
			
			// Anand's Code //
			// If Search is for emergency patient
			if (isset ( $this->params ['named'] ['searchFor'] ) and $this->params ['named'] ['searchFor'] == 'emergency') {
				// Condition is here
				$conditions = array (
						$search_key,
						'Patient.is_discharge' => 0,
						'Patient.admission_type' => 'IPD',
						'Patient.is_emergency' => 1 
				);
			} else {
				// If patient is OPD
				if (! empty ( $this->params->query )) {
					$search_ele = $this->params->query; // make it get
					if (! empty ( $search_ele ['lookup_name'] )) {
						$search_key ['Patient.lookup_name like '] = "%" . trim ( $search_ele ['lookup_name'] ) . "%";
					}
					if (! empty ( $search_ele ['patient_id'] )) {
						$search_key ['Patient.patient_id like '] = "%" . trim ( $search_ele ['patient_id'] );
					}
					if (! empty ( $search_ele ['admission_id'] )) {
						$search_key ['Patient.admission_id like '] = "%" . trim ( $search_ele ['admission_id'] );
					}
					// Condition is here
					$conditions = $search_key;
				} else {
					// For IPD patient
					// Condition is here
					$conditions = array (
							$search_key,
							'Patient.is_discharge' => 0,
							'Patient.admission_type' => 'IPD' 
					);
				}
			}
			// Paginate Data here
			$this->paginate = array (
					'limit' => Configure::read ( 'number_of_rows' ),
					'order' => array (
							'Patient.id' => 'desc' 
					),
					'fields' => array (
							'CONCAT(PatientInitial.name," ",Patient.lookup_name) as lookup_name,Patient.form_received_on,
						Patient.id,Patient.sex,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(Initial.name," ",User.first_name," ",User.last_name) as name, Patient.create_time' 
					),
					'conditions' => $conditions 
			);
			
			$this->set ( 'data', $this->paginate ( 'Patient' ) );
			// EOF Anand's Code //
		}
		
		// BOF pankaj
		public function deleteLabTest($testId) {
			if (! empty ( $testId )) {
				$this->loadModel ( 'LaboratoryTestOrder' );
				$this->LaboratoryTestOrder->save ( array (
						'id' => $testId,
						'is_deleted' => 1 
				) );
				$this->Session->setFlash ( __ ( 'Record deleted successfully' ), 'default', array (
						'class' => 'message' 
				) );
				$this->redirect ( $this->referer () );
			} else {
				$this->Session->setFlash ( __ ( 'Please try again' ), 'default', array (
						'class' => 'error' 
				) );
				$this->redirect ( $this->referer () );
			}
		}
		// EOF pankaj
		
		// print investigation requisition slip
		// time with which can diff one time ordered test
		function investigation_print($patient_id = null, $batch_identifier = null) {
			$this->layout = 'print_without_header';
			// $this->print_patient_info($patient_id);//called function will return patient info
			$this->uses = array (
					'LaboratoryTestOrder',
					'Laboratory',
					'NewCropAllergies',
					'Patient',
					'Facility',
					'User',
					'NewInsurance',
					'InsuranceCompany',
					'State',
					'Person',
					'NoteDiagnosis',
					'LaboratoryAoeCode',
					'Consultant' 
			);
			/*
			 * $this->LaboratoryTestOrder->bindModel(array(
			 * 'belongsTo' => array('Laboratory'=>array('foreignKey'=>'laboratory_id','conditions'=>array('Laboratory.is_active'=>1)),
			 * 'ServiceProvider'=>array('foreignKey'=>'service_provider_id')
			 * ),
			 * 'hasOne' => array('LaboratoryResult'=>array('foreignKey'=>'laboratory_test_order_id'),
			 * 'LaboratoryToken'=>array('foreignKey'=>'laboratory_test_order_id'),
			 * 'NoteDiagnosis'=>array('foreignKey'=>false,'conditions'=>array('NoteDiagnosis.patient_id=LaboratoryTestOrder.patient_id'))
			 * ),
			 * 'hasMany'=>array('LaboratoryAoeCode'=>array('foreignKey'=>false))
			 * ),false);
			 *
			 * $testOrdered= $this->LaboratoryTestOrder->find('all',array('fields'=>array('LaboratoryToken.primary_care_pro','LaboratoryTestOrder.start_date','LaboratoryTestOrder.lab_order_date',
			 * 'LaboratoryTestOrder.is_external','LaboratoryResult.dhr_laboratory_patient_id','LaboratoryResult.confirm_result','LaboratoryTestOrder.id','NoteDiagnosis.snowmedid','Laboratory.dhr_order_code',
			 * 'LaboratoryTestOrder.create_time','LaboratoryTestOrder.order_id','Laboratory.id','Laboratory.name','ServiceProvider.*',
			 * 'LaboratoryToken.ac_id','LaboratoryToken.frequency','LaboratoryToken.diagnosis','LaboratoryToken.priority','LaboratoryToken.icd9_code',
			 * 'LaboratoryToken.relevant_clinical_info','LaboratoryToken.question','NoteDiagnosis.diagnoses_name','NoteDiagnosis.icd_id',
			 * ),
			 * 'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patient_id,'LaboratoryTestOrder.is_deleted'=>0,'LaboratoryTestOrder.batch_identifier '=>$batch_identifier),
			 * 'order' => array('LaboratoryTestOrder.id' => 'asc'),
			 * 'group'=>array('Laboratory.name')));
			 */
			$this->LaboratoryTestOrder->bindModel ( array (
					'belongsTo' => array (
							'Laboratory' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryTestOrder.laboratory_id= Laboratory.id' 
									) 
							),
							'LaboratoryResult' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryResult.laboratory_test_order_id= LaboratoryTestOrder.id' 
									) 
							),
							'LaboratoryHl7Result' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryHl7Result.laboratory_result_id= LaboratoryResult.id' 
									) 
							) 
					) 
			) );
			$testOrdered = $this->LaboratoryTestOrder->find ( 'all', array (
					'fields' => array (
							'LaboratoryTestOrder.id',
							'Laboratory.name',
							'Laboratory.id',
							'LaboratoryTestOrder.patient_id',
							'LaboratoryTestOrder.batch_identifier',
							'LaboratoryResult.id',
							'LaboratoryHl7Result.unit',
							'LaboratoryHl7Result.result' 
					),
					'conditions' => array (
							'LaboratoryTestOrder.patient_id' => $patient_id 
					) ,'group'=>array('LaboratoryTestOrder.id')  ) );
			$this->set ( "test_ordered", $testOrdered );
			
			$getPId = $this->Patient->find ( 'first', array (
					'fields' => array (
							'person_id',
							'Patient.*' 
					),
					'conditions' => array (
							'Patient.id' => $patient_id 
					) 
			) );
			$pId = $this->Patient->find ( 'list', array (
					'fields' => array (
							'Patient.id',
							'Patient.id' 
					),
					'conditions' => array (
							'person_id' => $getPId ['Patient'] ['person_id'] 
					) 
			) );
			$search_key1 ['NewCropAllergies.is_reconcile'] = 0;
			$search_key1 ['NewCropAllergies.status'] = 'A';
			$search_key1 ['NewCropAllergies.patient_uniqueid'] = $pId;
			$allergies_data = $this->NewCropAllergies->find ( 'all', array (
					'fields' => array (
							'name',
							'reaction',
							'AllergySeverityName',
							'onset_date' 
					),
					'conditions' => $search_key1 
			) );
			$this->set ( "allergies_data", $allergies_data );
			$this->Patient->bindModel ( array (
					'belongsTo' => array (
							'Initial' => array (
									'foreignKey' => 'initial_id' 
							),
							'Consultant' => array (
									'foreignKey' => 'consultant_treatment' 
							),
							'TariffStandard' => array (
									'foreignKey' => 'tariff_standard_id' 
							) 
					),
					'hasOne' => array (
							'FinalBilling' => array (
									'foreignKey' => 'patient_id' 
							) 
					) 
			) );
			$patient_details = $this->Patient->getPatientDetailsByIDWithTariff ( $getPId ['Patient'] ['id'], 'bill_number' );
			/**
			 * BOF-Geting initial name**
			 */
			$this->User->bindModel ( array (
					'belongsTo' => array (
							'Initial' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Initial.id=User.initial_id' 
									) 
							) 
					) 
			)
			, false );
			$treatingConsultantData = $this->User->find ( 'first', array (
					'fields' => array (
							'CONCAT(User.first_name, " ", User.last_name) as fullname',
							'Initial.name as initial_name' 
					),
					'conditions' => array (
							'User.id' => $patient_details ['Patient'] ['doctor_id'] 
					) 
			) );
			$this->set ( "treatingConsultantData", $treatingConsultantData );
			// retrive other consultant name
			$getOtherConsultant = unserialize ( $patient_details ['Patient'] ['other_consultant'] );
			$commonArr = array ();
			$doctorArr = array ();
			$consultantArr = array ();
			foreach ( $getOtherConsultant as $key => $getUnserializeDatas ) {
				$commonArr [$key] = explode ( '_', $getUnserializeDatas );
				if ($commonArr [$key] ['0'] == 'consultant') {
					$consultantArr [] = $commonArr [$key] ['1'];
				} else if ($commonArr [$key] ['0'] == 'doctor') {
					$doctorArr [] = $commonArr [$key] ['1'];
				}
			}
			$this->Consultant->bindModel ( array (
					'belongsTo' => array (
							'ReffererDoctor' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Consultant.refferer_doctor_id=ReffererDoctor.id' 
									) 
							),
							'Initial' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Consultant.initial_id=Initial.id' 
									) 
							) 
					) 
			), false );
			$consultantData = $this->Consultant->find ( 'all', array (
					'fields' => array (
							'Initial.name as nameInitial',
							'Consultant.id',
							'full_name' => 'CONCAT(Consultant.first_name," ",Consultant.last_name) as name' 
					),
					'conditions' => array (
							'Consultant.id' => $consultantArr,
							'Consultant.is_deleted' => 0,
							'Consultant.location_id' => $this->Session->read ( 'locationid' ),
							'ReffererDoctor.is_referral' => 'N' 
					) 
			) );
			$patientDataUser = $this->User->find ( 'all', array (
					'fields' => array (
							'Initial.name as nameInitial',
							'User.mobile',
							'User.id',
							'full_name' => 'CONCAT(User.first_name," ",User.last_name) as name' 
					),
					'conditions' => array (
							'User.id' => $doctorArr,
							'User.is_deleted' => 0 
					) 
			) );
			$otherConsultantData = array_merge ( $consultantData, $patientDataUser );
			/*
			 * $otherConsultant = $this->User->find('all',array('fields'=>array('full_name'),'conditions'=>array('User.id'=>unserialize($patient_details['Patient']['other_consultant']))));
			 */
			$this->set ( 'otherConsultantData', $otherConsultantData );
			// EOF other consultant
			$this->set ( "patient", $patient_details );
			/* } */
			/*
			 * else{
			 * $batchId=explode(',',$this->params->query['labToPrint']);
			 * $testOrdered= $this->LaboratoryTestOrder->find('all',array('fields'=>array('LaboratoryTestOrder.is_external','LaboratoryResult.confirm_result','LaboratoryTestOrder.id',
			 * 'LaboratoryTestOrder.create_time','LaboratoryTestOrder.order_id','Laboratory.id','Laboratory.name','ServiceProvider.*'),
			 * 'conditions'=>array('LaboratoryTestOrder.patient_id'=>77,'LaboratoryTestOrder.is_deleted'=>0,'LaboratoryTestOrder.batch_identifier '=>$batchId),
			 * 'order' => array('LaboratoryTestOrder.id' => 'asc'),
			 * 'group'=>array('LaboratoryTestOrder.id')));
			 * $this->set("test_ordered",$testOrdered);
			 *
			 * }
			 */
			
			$accountID = $this->Person->find ( 'first', array (
					'fields' => array (
							'id',
							'alternate_patient_uid' 
					),
					'conditions' => array (
							'id' => $getPId ['Patient'] ['person_id'] 
					) 
			) );
			$this->set ( "accountID", $accountID );
			
			$clientInfo = $this->Facility->find ( 'first', array (
					'fields' => array (
							'Facility.*' 
					),
					'conditions' => array (
							'Facility.name' => $this->Session->read ( 'facility' ) 
					) 
			) );
			$this->set ( "clientInfo", $clientInfo );
			/*
			 * if($this->Session->read('role')=='Primary Care Provider'){
			 * $phyInfo=$this->User->find('first',array('fields'=>array('User.*'),'conditions'=>array('User.id'=>$this->Session->read('userid'))));
			 * $this->set("phyInfo",$phyInfo);
			 * }else{
			 */
			$phyInfo = $this->User->find ( 'first', array (
					'fields' => array (
							'User.*' 
					),
					'conditions' => array (
							'User.id' => $getPId ['Patient'] ['doctor_id'] 
					) 
			) );
			$this->set ( "phyInfo", $phyInfo );
			// }
			
			$this->NewInsurance->bindModel ( array (
					'belongsTo' => array (
							'InsuranceCompany' => array (
									'foreignKey' => false,
									'conditions' => array (
											'InsuranceCompany.id=NewInsurance.insurance_company_id' 
									) 
							),
							'State' => array (
									'foreignKey' => false,
									'conditions' => array (
											'State.id=InsuranceCompany.state_id' 
									) 
							) 
					) 
			), false );
			
			$insInfo = $this->NewInsurance->find ( 'all', array (
					'fields' => array (
							'NewInsurance.*',
							'State.*',
							'InsuranceCompany.*' 
					),
					'conditions' => array (
							'NewInsurance.patient_id' => $patient_id 
					) 
			) );
			$this->set ( "insInfo", $insInfo );
			// debug($testOrdered);exit;
			// $aoeCodes = $this->LaboratoryAoeCode->find('list',array('fields'=>array('id','question'),'conditions'=>array('dhr_obr_code'=>$testOrdered['Laboratory']['dhr_order_code'])));
			// $this->set('aoeCodes',$aoeCodes);
			
			/*
			 * $diagnosisID=$this->NoteDiagnosis->find('first',array('fields'=>array('NoteDiagnosis.*'),'conditions'=>array('NoteDiagnosis.patient_id'=>$patient_id)));
			 * $this->set("diagnosisID",$diagnosisID);
			 * /*$companyInfo=$this->InsuranceCompany->find('first',array('fields'=>array('InsuranceCompany.*'),'conditions'=>array('InsuranceCompany.id'=>$insInfo['NewInsurance']['insurance_company_id'])));
			 * $this->set("companyInfo",$companyInfo);
			 */
		}
		function admin_view_groups() {
			$this->uses = array (
					'TestGroup' 
			);
			$this->paginate = array (
					'limit' => Configure::read ( 'number_of_rows' ),
					'order' => array (
							'TestGroup.name' => 'desc' 
					),
					'conditions' => array (
							'type' => 'laboratory' 
					) 
			);
			$this->set ( 'data', $this->paginate ( 'TestGroup' ) );
		}
		function admin_add_group($id) {
			$this->uses = array (
					'TestGroup' 
			);
			if (! empty ( $this->request->data ['TestGroup'] )) {
				if ($this->TestGroup->saveRecord ( $this->request->data, 'laboratory' )) {
					$this->Session->setFlash ( __ ( 'Record added successfully' ), 'default', array (
							'class' => 'message' 
					) );
					$this->redirect ( 'view_groups' );
				} else {
					$errors = $this->TestGroup->invalidFields ();
					if (! empty ( $errors )) {
						$this->set ( "errors", $errors );
					}
				}
			}
			if (! empty ( $id )) {
				$this->data = $this->TestGroup->getGroupByID ( $id );
			}
		}
		function admin_delete_group($id) {
			if (! $id)
				return;
			$this->uses = array (
					'TestGroup' 
			);
			if ($this->TestGroup->delete ( $id )) {
				$this->Session->setFlash ( __ ( 'Record added successfully' ), 'default', array (
						'class' => 'message' 
				) );
				$this->redirect ( 'view_groups' );
			} else {
				$this->Session->setFlash ( __ ( 'There is problem while deleting record, Plese try again' ), 'default', array (
						'class' => 'error' 
				) );
			}
		}
		function labHl7Result($testid = null, $patient_id = null) {
			$this->uses = array (
					'LaboratoryToken',
					'Hl7Message',
					'Hl7AdmissionType',
					'Hl70004PatientClass',
					'Hl7Result',
					'LaboratoryResult',
					'LaboratoryHl7Result',
					'Patient',
					'Person',
					'Race',
					'SpecimenActionCode0065',
					'ResultStatus0123',
					'SnomedSctHl7',
					'SpecimenRejectReason0490',
					'SpecimenCondition0493',
					'ObservationInterpretation0078',
					'ObservationResultStatus0085',
					'LoincLnHl7',
					'LabManager',
					'User',
					'Hl7Unit',
					'Ucums',
					'State',
					'Initial',
					'NameType',
					'Hl7ObservationMethod',
					'Hl7IdentifierType',
					'Hl7_0190_address_types',
					'Hl7_0201_phvs_telecommunications',
					'hl7_0202_telecommunication_equipment_types',
					'Hl7LaboratoryCodedObservation',
					'PHVS_ModifierOrQualifier_CDC',
					'Specimen_activities',
					'Specimen_role',
					'Body_site_value_set',
					'AdverseEventTrigger',
					'LaboratoryTestOrder' 
			);
			$labResultArr = array ();
			$tempArr = array ();
			$this->Patient->unbindModel ( array (
					'hasMany' => array (
							'PharmacySalesBill',
							'InventoryPharmacySalesReturn' 
					) 
			) );
			$this->Patient->bindModel ( array (
					'hasOne' => array (
							'Person' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Person.patient_uid=Patient.patient_id' 
									) 
							),
							'LaboratoryTestOrder' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryTestOrder.patient_id=Patient.id' 
									) 
							),
							'Laboratory' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryTestOrder.laboratory_id=Laboratory.id' 
									) 
							),
							'Note' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Note.patient_id=Patient.id' 
									) 
							) 
					) 
			), false );
			
			$patientData = $this->Patient->find ( 'first', array (
					'fields' => array (
							'Patient.id',
							'Patient.doctor_id',
							'Patient.lookup_name',
							'Patient.form_received_on',
							'Person.patient_uid',
							'Person.first_name',
							'Person.last_name',
							'Person.sex',
							'Person.dob',
							'Person.race',
							'LaboratoryTestOrder.*',
							'Laboratory.name',
							'Laboratory.lonic_code',
							'Note.cc' 
					),
					'conditions' => array (
							'Patient.id' => $patient_id 
					) 
			) );
			/*
			 * $specimenData = $this->LaboratoryToken->find('first',array('fields'=>array('specimen_type_id','specimen_action_id','specimen_condition_id','specimen_condition_id',
			 * 'collected_date','LaboratoryTestOrder.start_date','Laboratory.name','Laboratory.lonic_code','SnomedSctHl7.display_name','SnomedSctHl7.code'),
			 * 'conditions'=>array('LaboratoryToken.patient_id' => $patient_id,'LaboratoryToken.laboratory_test_order_id'=>$testid,'LaboratoryTestOrder.id'=>$testid)));
			 * $this->set('specimenData',$specimenData);
			 */
			$this->set ( 'patientData', $patientData );
			
			$countNumber = $this->getLastMessageId ();
			$fillerOderNumber = "FN-" . ($countNumber + 1);
			$this->set ( 'fillerOderNumber', $fillerOderNumber );
			
			$doctorData = $this->User->find ( 'first', array (
					'fields' => array (
							'User.id',
							'User.first_name',
							'User.last_name' 
					),
					'conditions' => array (
							'User.id' => $patientData ['Patient'] ['doctor_id'] 
					) 
			) );
			$this->set ( 'doctorData', $doctorData );
			$this->Laboratory->bindModel ( array (
					'belongsTo' => array (
							
							'LaboratoryTestOrder' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryTestOrder.laboratory_id=Laboratory.id' 
									) 
							) 
					) 
			)
			, false );
			$LabName = $this->Laboratory->find ( 'first', array (
					'fields' => array (
							'Laboratory.name',
							'Laboratory.lonic_code' 
					),
					'conditions' => array (
							'LaboratoryTestOrder.id' => $testid 
					) 
			) ); // print_r($LabName);exit;
			$this->set ( 'LabName', $LabName );
			$Race = $this->Race->find ( 'list', array (
					'fields' => array (
							'value_code',
							'race_name' 
					) 
			) );
			$this->set ( 'race', $Race );
			
			$speciemtActionCode0065 = $this->SpecimenActionCode0065->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					) 
			) );
			$resultStatus0123 = $this->ResultStatus0123->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$units_option = $this->Hl7Unit->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			
			$initial_option = $this->Initial->find ( 'list', array (
					'fields' => array (
							'name' 
					) 
			) );
			$nameType_option = $this->NameType->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$identifier_type_option = $this->Hl7IdentifierType->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$address_type_option = $this->Hl7_0190_address_types->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$tele_code_option = $this->Hl7_0201_phvs_telecommunications->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$tele_equip_type_option = $this->hl7_0202_telecommunication_equipment_types->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$hl7_coded_observation_option = $this->Hl7LaboratoryCodedObservation->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			
			$hl7PatientClass = $this->Hl70004PatientClass->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$hl7AdmissionType = $this->Hl7AdmissionType->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			
			$specimenRejectReason = $this->SpecimenRejectReason0490->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$specimenConditionReason = $this->SpecimenCondition0493->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			
			$labResultStatus = $this->ObservationResultStatus0085->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$state_options = $this->State->find ( 'list', array (
					'fields' => array (
							'state_code',
							'name' 
					),
					'conditions' => array (
							'State.country_id' => "2" 
					),
					'order' => array (
							'State.name' 
					) 
			) );
			$sp_type_modifier_options = $this->PHVS_ModifierOrQualifier_CDC->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$specimen_role_options = $this->Specimen_role->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$body_site_options = $this->Body_site_value_set->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			
			/*
			 * $this->LabManager->bindModel(array(
			 * 'belongsTo' => array(
			 * 'Laboratory'=>array('foreignKey'=>'laboratory_id','conditions'=>array('Laboratory.is_active'=>1))
			 * ),
			 * 'hasOne' => array( 'LaboratoryResult'=>array('foreignKey'=>'laboratory_test_order_id') ,
			 * 'LaboratoryToken'=>array('foreignKey'=>'laboratory_test_order_id')
			 * )),false);
			 *
			 * $this->paginate = array(
			 * 'limit' => Configure::read('number_of_rows'),
			 * 'fields'=>array('LaboratoryResult.result_publish_date','LaboratoryResult.confirm_result','LabManager.id','LabManager.create_time',
			 * 'LabManager.patient_id','LabManager.order_id','Laboratory.id','Laboratory.name','LaboratoryToken.ac_id','LaboratoryToken.sp_id'),
			 * 'conditions'=>array('LabManager.patient_id'=>$patient_id,'LabManager.is_deleted'=>0),
			 * 'order' => array(
			 * 'LabManager.id' => 'asc'
			 * ),
			 * 'group'=>'LabManager.id'
			 * );
			 * $testOrdered = $this->paginate('LabManager');
			 *
			 * $this->set(array('testOrdered'=>$testOrdered));
			 */
			
			$this->set ( array (
					'speciemtActionCode0065' => $speciemtActionCode0065,
					'resultStatus0123' => $resultStatus0123,
					'hl7AdmissionType' => $hl7AdmissionType,
					'specimenRejectReason' => $specimenRejectReason,
					'specimenConditionReason' => $specimenConditionReason,
					'labResultStatus' => $labResultStatus,
					'units_option' => $units_option,
					'state_options' => $state_options,
					'initial_option' => $initial_option,
					'nameType_option' => $nameType_option,
					'obsMethod_option' => $obsMethod_option,
					'identifier_type_option' => $identifier_type_option,
					'address_type_option' => $address_type_option,
					'tele_code_option' => $tele_code_option,
					'tele_equip_type_option' => $tele_equip_type_option,
					'hl7_coded_observation_option' => $hl7_coded_observation_option,
					'sp_type_modifier_options' => $sp_type_modifier_options,
					'specimen_role_options' => $specimen_role_options,
					'body_site_options' => $body_site_options,
					'hl7PatientClass' => $hl7PatientClass 
			) );
			
			// echo '<pre>';print_r($this->request->data);exit;
			if (! empty ( $this->request->data )) {
				$this->request->data ['labHl7Result'] ['create_time'] = date ( "Y-m-d H:i:s" );
				$this->request->data ['labHl7Result'] ['patient_id'] = $patient_id;
				$this->request->data ['labHl7Result'] ['user_id'] = $this->Session->read ( 'userid' );
				$this->request->data ['labHl7Result'] ['laboratory_test_order_id'] = $testid;
				$this->request->data ['labHl7Result'] ['confirm_result'] = '1';
				$this->request->data ['labHl7Result'] ['result_publish_date'] = $patientData ['LaboratoryTestOrder'] ['start_date'];
				// BOF adeverse event
				$adverse_event = 0;
				if (! empty ( $this->request->data ['labHl7Result'] ['sn_result_0'] )) {
					$this->LaboratoryTestOrder->bindModel ( array (
							'belongsTo' => array (
									'Laboratory' => array (
											'foreignKey' => 'laboratory_id',
											'conditions' => array (
													'Laboratory.is_active' => 1 
											) 
									) 
							) 
					), false );
					$snowmedArray = $this->LaboratoryTestOrder->find ( 'first', array (
							'fields' => array (
									'Laboratory.sct_concept_id' 
							),
							'conditions' => array (
									'LaboratoryTestOrder.is_deleted' => 0,
									'LaboratoryTestOrder.id' => $this->request->data ['labHl7Result'] ['laboratory_test_order_id'] 
							) 
					) );
					$adverseArray = $this->AdverseEventTrigger->getEventTriggers ( array (
							'snowmed' 
					), array (
							'section' => 'labs' 
					) );
					
					if (in_array ( $snowmedArray ['Laboratory'] ['sct_concept_id'], $adverseArray )) {
						$adverse_event = 1;
					}
				}
				$this->request->data ['labHl7Result'] ['adverse_event'] = $adverse_event;
				// EOF adverse event
				$this->request->data ['labHl7Result'] ['laboratory_id'] = $patientData ['LaboratoryTestOrder'] ['laboratory_id']; // echo '<pre>';print_r($patientData);exit;
				if ($this->LaboratoryResult->save ( $this->request->data ['labHl7Result'] )) {
					$tempArr ['observations'] = $this->request->data ['labHl7Result'] ['observation_0'];
					$tempArr ['result'] = $this->request->data ['labHl7Result'] ['result_0'];
					if (! empty ( $this->request->data ['labHl7Result'] ['sn_result_0'] )) {
						$tempArr ['result'] = $this->request->data ['labHl7Result'] ['sn_result_0'];
					}
					$tempArr ['laboratory_id'] = $this->request->data ['labHl7Result'] ['laboratory_id'];
					$tempArr ['unit'] = $this->request->data ['labHl7Result'] ['unit_0'];
					$tempArr ['uom'] = $this->request->data ['labHl7Result'] ['uom_0'];
					$tempArr ['range'] = $this->request->data ['labHl7Result'] ['range_0'];
					$tempArr ['abnormal_flag'] = $this->request->data ['labHl7Result'] ['abnormal_flag_0'];
					$tempArr ['status'] = $this->request->data ['labHl7Result'] ['status_0'];
					$tempArr ['date_time_of_observation'] = $this->request->data ['labHl7Result'] ['date_time_of_observation_0'];
					$tempArr ['notes'] = $this->request->data ['labHl7Result'] ['notes_0'];
					$tempArr ['laboratory_result_id'] = $this->LaboratoryResult->id;
					$tempArr ['location_id'] = $this->Session->read ( 'locatioid' );
					$tempArr ['created_by'] = $this->Session->read ( 'userid' );
					$tempArr ['create_time'] = date ( 'Y-m-d H:i:s' );
					$tempArr ['sn_value'] = $this->request->data ['labHl7Result'] ['sn_value_0'];
					$tempArr ['observation_method'] = $this->request->data ['labHl7Result'] ['observation_method_0'];
					
					$tempArr ['sn_separator'] = $this->request->data ['labHl7Result'] ['sn_separator_0'];
					$tempArr ['sn_result2'] = $this->request->data ['labHl7Result'] ['sn_result2_0'];
					$tempArr ['create_time'] = date ( "Y-m-d H:i:s" );
					
					$labResultArr [] = $tempArr; // echo '<pre>';print_r($this->request->data);exit;
					for($i = 1; $i <= $this->request->data ['labcount']; $i ++) {
						$tempArr ['observations'] = $this->request->data ['observation_' . $i];
						$tempArr ['unit'] = $this->request->data ['unit_' . $i];
						$tempArr ['result'] = $this->request->data ['result_' . $i];
						if (! empty ( $this->request->data ['sn_result_' . $i] )) {
							$tempArr ['result'] = $this->request->data ['sn_result_' . $i];
						}
						$tempArr ['uom'] = $this->request->data ['uom_' . $i];
						$tempArr ['range'] = $this->request->data ['range_' . $i];
						$tempArr ['abnormal_flag'] = $this->request->data ['abnormal_flag_' . $i];
						$tempArr ['status'] = $this->request->data ['status_' . $i];
						$tempArr ['date_time_of_observation'] = $this->request->data ['date_time_of_observation_' . $i];
						$tempArr ['notes'] = $this->request->data ['notes_' . $i];
						$tempArr ['laboratory_result_id'] = $this->LaboratoryResult->id;
						$tempArr ['location_id'] = $this->Session->read ( 'locationid' );
						$tempArr ['created_by'] = $this->Session->read ( 'userid' );
						$tempArr ['create_time'] = date ( 'Y-m-d H:i:s' );
						$tempArr ['sn_value'] = $this->request->data ['sn_value_' . $i];
						$tempArr ['observation_method'] = $this->request->data ['observation_method_' . $i];
						
						$tempArr ['sn_separator'] = $this->request->data ['sn_separator_' . $i];
						$tempArr ['sn_result2'] = $this->request->data ['sn_result2_' . $i];
						$tempArr ['create_time'] = date ( "Y-m-d H:i:s" );
						$labResultArr [] = $tempArr;
					}
					$this->LaboratoryHl7Result->saveAll ( $labResultArr );
				}
				if (isset ( $this->request->data ['Submit_&_Add_More'] ) && ! empty ( $this->request->data ['Submit_&_Add_More'] )) {
					$this->redirect ( array (
							'controller' => 'laboratories',
							'action' => 'labHl7Result',
							$testid,
							$patient_id 
					) );
				} else {
					// $this->redirect(array('controller' => 'laboratories', 'action' => 'lab_manager',$patient_id));
					
					// ----------------------------------------------- HL&7 Result---------------------------------------------
					
					$this->LaboratoryResult->bindModel ( array (
							'hasMany' => array (
									'LaboratoryHl7Result' => array (
											'foreignKey' => 'laboratory_result_id' 
									) 
							) 
					) );
					// LaboratoryHl7Result
					$model = ClassRegistry::init ( 'Hl7Result' ); // debug($this->request->data); exit;
					$modelMes = ClassRegistry::init ( 'Hl7Message' );
					
					$get_lab_result = $this->LaboratoryResult->find ( 'all', array (
							'conditions' => array (
									'LaboratoryResult.laboratory_test_order_id' => $testid,
									'patient_id' => $patient_id 
							) 
					) );
					
					$msg = $model->genrateHL7ELR ( $get_lab_result, $this->request->data ['labHl7Result'] );
					
					// $modelMes->saveAll(array('message'=>$msg,'message_from'=>'LAB_RESULT_ELR','create_time' => date('Y-m-d H:i:s'),'patient_id'=>$patientData['Person']['patient_uid']));
					$modelMes->saveAll ( array (
							'subject' => 'Submission of Reportable Lab Results',
							'message_to' => "Registry",
							'patient_name' => $patientData ['Patient'] ['lookup_name'],
							'message' => $msg,
							'message_from' => 'LAB_RESULT_ELR',
							'create_time' => date ( 'Y-m-d H:i:s' ),
							'patient_id' => $patientData ['Person'] ['patient_uid'] 
					) );
					$this->Session->setFlash ( __ ( 'Lab Result Saved successfully', true ), 'default', array (
							'class' => 'message' 
					) );
					$this->redirect ( array (
							'controller' => 'laboratories',
							'action' => 'viewLabHl7Result',
							$patient_id,
							$testid 
					) );
					// ==============================================================================================================
				}
			}
		}
		function labTestHl7List($patient_id = null) {
			
// 			debug($patient_id); exit;
			$this->uses = array (
					'Person',
					'Patient',
					'Consultant',
					'User',
					'LabManager',
					'LaboratoryResult',
					'RadiologyTestOrder',
					'RadiologyReport',
					'RadiologyResult',
					'Radiology' 
			);
			if (! empty ( $patient_id )) {
				// BOF referer link
				$data1 = $this->RadiologyReport->find ( 'all', array (
						'fields' => array (
								'RadiologyReport.id',
								'RadiologyReport.patient_id',
								'RadiologyReport.file_name',
								'RadiologyReport.description' 
						),
						'conditions' => array (
								'RadiologyReport.patient_id' => $patient_id,
								'RadiologyReport.is_deleted' => '0' 
						) 
				) );
				for($a = 0; $a < count ( $data1 ); $a ++) {
					// $b[]= '"../../uploads/radiology/'.$data1[$a][RadiologyReport][file_name].'"';
					$b [] = '"' . $this->webroot . 'uploads/radiology/' . $data1 [$a] [RadiologyReport] [file_name] . '"';
					$c [] = '"' . $data1 [$a] ['RadiologyReport'] ['description'] . '"';
				}
				$this->set ( 'data1', $data1 );
				$this->set ( 'b', $b );
				$this->set ( 'c', $c );
				
				$sessionReturnString = $this->Session->read ( 'labResultReturn' );
				$currentReturnString = $this->params->query ['return'];
				if (($currentReturnString != '') && ($currentReturnString != $sessionReturnString)) {
					$this->Session->write ( 'labResultReturn', $currentReturnString );
				}
				// EOF referer link
				
				$this->patient_info ( $patient_id );
				
				$this->LaboratoryResult->bindModel ( array (
						'belongsTo' => array (
								'Laboratory' => array (
										'foreignKey' => false,
										'conditions' => array (
												'Laboratory.is_active' => 1,
												'Laboratory.id=LaboratoryResult.laboratory_id' 
										) 
								),
								
								// 'LaboratoryCategory'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryCategory.laboratory_id=Laboratory.id')),
								// 'LaboratoryParameter'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryCategory.id=LaboratoryParameter.laboratory_categories_id')),
								'LabManager' => array (
										'foreignKey' => false,
										'type' => 'right',
										'conditions' => array (
												'LaboratoryResult.laboratory_test_order_id=LabManager.id' 
										) 
								),
								'LaboratoryAlias' => array (
										'className' => 'Laboratory',
										'foreignKey' => false,
										'conditions' => array (
												'LaboratoryAlias.is_active' => 1,
												'LaboratoryAlias.id=LabManager.laboratory_id' 
										) 
								) 
						),
						
						// 'LabManager'=>array('foreignKey'=>false,'conditions'=>array('LabManager.laboratory_id=Laboratory.id')),
						// 'LaboratoryResult'=>array('foreignKey'=>false,'conditions'=>array('LabManager.id = LaboratoryResult.laboratory_test_order_id'))
						'hasOne' => array (
								'LaboratoryToken' => array (
										'foreignKey' => false,
										'conditions' => array (
												'LaboratoryResult.laboratory_test_order_id=LaboratoryToken.laboratory_test_order_id' 
										) 
								) 
						),
						
						// 'LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryHl7Result.laboratory_result_id=LaboratoryResult.id'))// aditya added bind LaboratoryHl7Result
						'hasMany' => array (
								'LaboratoryHl7Result' => array (
										'foreignKey' => 'laboratory_result_id' 
								) 
						) 
				) // aditya added bind LaboratoryHl7Result

				, false );
				
				$this->paginate = array (
						'limit' => Configure::read ( 'number_of_rows' ),
						'fields' => array (
								'LaboratoryResult.upload',
								'LaboratoryResult.dhr_laboratory_patient_id',
								'LaboratoryResult.od_universal_service_text',
								'LaboratoryResult.id',
								'LaboratoryResult.laboratory_test_order_id',
								'LaboratoryAlias.id',
								'LaboratoryAlias.name',
								'LaboratoryResult.laboratory_id',
								'LaboratoryResult.tqi_start_date_time',
								'LaboratoryResult.od_observation_start_date_time',
								'LaboratoryResult.re_notes_comments',
								'LaboratoryResult.result_publish_date',
								'LaboratoryResult.confirm_result',
								'LaboratoryResult.is_whatsapp_sent',
								'LabManager.id',
								'LabManager.start_date',
								'LabManager.patient_id',
								'LabManager.order_id',
								'Laboratory.id',
								'Laboratory.name',
								'Laboratory.lonic_code',
								'LaboratoryToken.ac_id',
								'LaboratoryToken.sp_id',
								'LabManager.start_date' 
						),
						'conditions' => array (
								'LabManager.patient_id' => $patient_id,
								'LabManager.is_deleted' => 0 
						),
						'order' => array (
								'LabManager.id' => 'desc' 
						) 
				);
				// 'group'=>array('Laboratory.id')
				
				
				$testOrdered = $this->paginate ( 'LaboratoryResult' );
				$this->set ( array (
						'testOrdered' => $testOrdered 
				) ); // echo '<pre>';print_r($testOrdered);exit;
				$this->set ( '$patient_id', $patient_id );
			} else {
				$this->Session->setFlash ( __ ( 'Please try again' ), 'default', array (
						'class' => 'error' 
				) );
				$this->redirect ( $this->referer () );
			}
		}
		public function hlseven() {
			$this->uses = array (
					'Hl7Result' 
			);
			if (isset ( $this->request->data ['hlseven'] ['message'] ) && ! empty ( $this->request->data ['hlseven'] ['message'] )) {
				
				$getdata = explode ( "\n", $this->request->data ['hlseven'] ['message'] );
				
				$getdata1 = explode ( "|", $getdata [1] );
				$getdata2 = explode ( "^", $getdata1 ['3'] );
				$id = $getdata2 ['0'];
				
				$fromName = explode ( "|", $getdata [0] );
				$this->Hl7Result->saveAll ( array (
						'patient_uid' => "$id",
						'message' => $this->request->data ['hlseven'] ['message'] 
				) );
				
				$outboxModel = ClassRegistry::init ( 'AmbulatoryResult' );
				$outboxModel->save ( array (
						'message' => $this->request->data ['hlseven'] ['message'],
						'uid' => $id,
						'from' => $fromName [3],
						'create_time' => date ( 'Y-m-d H:i:s' ) 
				) );
				echo $this->Session->setFlash ( "Succesfully Saved" );
			}
		}
		public function labTestResultsHl7($testid, $patient_id, $lab_id = null) {
			$this->layout = 'advance_ajax';
			$this->uses = array (
					'Hl7Message',
					'Hl7LaboratoryCodedObservation',
					'Hl7Result',
					'LaboratoryResult',
					'LaboratoryHl7Result',
					'Patient',
					'Person',
					'Race',
					'SpecimenActionCode0065',
					'ResultStatus0123',
					'SnomedSctHl7',
					'SpecimenRejectReason0490',
					'SpecimenCondition0493',
					'ObservationInterpretation0078',
					'ObservationResultStatus0085',
					'LoincLnHl7',
					'LabManager',
					'User',
					'Hl7Unit',
					'Ucums',
					'State',
					'Initial',
					'NameType',
					'Hl7ObservationMethod',
					'Hl7IdentifierType',
					'Hl7_0190_address_types',
					'AdverseEventTrigger',
					'LaboratoryTestOrder',
					'LaboratoryToken',
					'PanelMapping',
					'LaboratoryParameter',
					'LaboratoryCategory',
					'LaboratoryParameter' 
			);
			$optUcums = $this->Ucums->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					) 
			) );
			$this->set ( 'optUcums', $optUcums );
			$this->set ( 'noteId', $this->params->query ['noteId'] );
			$labResultArr = array ();
			$tempArr = array ();
			$this->Patient->bindModel ( array (
					'hasOne' => array (
							'Person' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Person.patient_uid=Patient.patient_id' 
									) 
							),
							'LaboratoryTestOrder' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryTestOrder.patient_id=Patient.id' 
									) 
							),
							'Note' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Note.patient_id=Patient.id' 
									),
									'fields' => array (
											'cc' 
									) 
							) 
					) 
			)
			, false );
			// ----specimenData--(vikas)--
			$this->LaboratoryToken->bindModel ( array (
					'hasOne' => array (
							'Laboratory' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Laboratory.id=LaboratoryToken.laboratory_id' 
									) 
							),
							'LaboratoryTestOrder' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryTestOrder.id=LaboratoryToken.laboratory_test_order_id' 
									) 
							),
							'SnomedSctHl7' => array (
									'foreignKey' => false,
									'conditions' => array (
											'SnomedSctHl7.display_name=LaboratoryToken.specimen_type_id' 
									) 
							),
							'LaboratoryHl7Result' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryHl7Result.id=Laboratory.id' 
									),
									'fields' => array (
											'cc' 
									) 
							) 
					) 
			), false );
			$specimenData = $this->LaboratoryToken->find ( 'first', array (
					'fields' => array (
							'specimen_type_id',
							'specimen_action_id',
							'specimen_condition_id',
							'specimen_condition_id',
							'collected_date',
							'LaboratoryTestOrder.start_date',
							'Laboratory.name',
							'Laboratory.lonic_code',
							'SnomedSctHl7.display_name',
							'SnomedSctHl7.code' 
					),
					'conditions' => array (
							'LaboratoryToken.patient_id' => $patient_id,
							'LaboratoryToken.laboratory_test_order_id' => $testid,
							'LaboratoryTestOrder.id' => $testid 
					) 
			) );
			$this->set ( 'specimenData', $specimenData );
			
			// -------------
			$patientData = $this->Patient->find ( 'first', array (
					'fields' => array (
							'Person.first_name',
							'Person.last_name',
							'Person.dob',
							'Person.sex',
							'Person.race',
							'LaboratoryTestOrder.order_id',
							'LaboratoryTestOrder.laboratory_id',
							'LaboratoryTestOrder.start_date',
							'Patient.doctor_id',
							'Note.cc' 
					),
					'conditions' => array (
							'Patient.id' => $patient_id 
					) 
			) );
			// debug($patientData);
			
			$countNumber = $this->getLastMessageId ();
			$fillerOderNumber = "FN-" . ($countNumber + 1);
			$this->set ( 'fillerOderNumber', $fillerOderNumber );
			
			$this->set ( 'patientData', $patientData );
			$doctorData = $this->User->find ( 'first', array (
					'type' => 'inner',
					'fields' => array (
							'User.id',
							'User.first_name',
							'User.last_name' 
					),
					'conditions' => array (
							'User.id' => $patientData ['Patient'] ['doctor_id'] 
					) 
			) );
			$this->set ( 'doctorData', $doctorData );
			$this->Laboratory->bindModel ( array (
					'belongsTo' => array (
							'LaboratoryTestOrder' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryTestOrder.laboratory_id=Laboratory.id' 
									) 
							) 
					) 
			)
			, false );
			$LabName = $this->Laboratory->find ( 'first', array (
					'fields' => array (
							'Laboratory.id',
							'Laboratory.name',
							'Laboratory.lonic_code',
							'Laboratory.is_panel',
							'Laboratory.lab_type',
							'Laboratory.histopathology_data' 
					),
					'conditions' => array (
							'LaboratoryTestOrder.id' => $testid 
					) 
			) );
			
			if ($LabName ['Laboratory'] ['is_panel'] != '1') {
				
				$getPanelRecords = $this->PanelMapping->find ( 'list', array (
						'fields' => array (
								'underpanellab_id' 
						),
						'conditions' => array (
								'laboratory_id' => $LabName ['Laboratory'] ['id'] 
						),
						'group' => array (
								'underpanellab_id' 
						) 
				) );
				// debug($getPanelRecords);exit;
				$this->Laboratory->bindModel ( array (
						'belongsTo' => array (
								'Hl7Unit' => array (
										'foreignKey' => false,
										'conditions' => array (
												'Hl7Unit.code=Laboratory.unit' 
										) 
								),
								'LaboratoryParameter' => array (
										'foreignKey' => false,
										'conditions' => array (
												'LaboratoryParameter.location_id=Laboratory.id' 
										) 
								) 
						) 
				)
				, false );
				
				if (count ( $getPanelRecords ) == 0) {
					array_push ( $getPanelRecords, $LabName ['Laboratory'] ['id'] );
				}
				
				$getPanelSubLab = $this->LaboratoryParameter->find ( 'all', array (
						'fields' => array (
								'id',
								'name',
								'by_gender_age',
								'by_gender_male',
								'by_gender_female',
								'by_gender_male_lower_limit',
								'by_gender_male_upper_limit',
								'by_gender_female_lower_limit',
								'by_gender_female_upper_limit',
								'unit',
								'unit',
								'by_age_num_less_years',
								'by_age_num_less_years_lower_limit',
								'by_age_num_less_years_upper_limit',
								'by_age_more_years',
								'by_age_num_more_years',
								'by_age_num_gret_years_lower_limit',
								'by_age_num_gret_years_upper_limit',
								'by_age_between_years',
								'by_age_between_num_less_years',
								'by_age_between_num_gret_years',
								'by_age_between_years_lower_limit',
								'by_age_between_years_upper_limit',
								'parameter_text',
								'parameter_text_histo',
								'by_age_less_years',
								'type',/* 'notes','test_method', 'Hl7Unit.display_name'*/),
						'conditions' => array (
								'LaboratoryParameter.laboratory_id' => $getPanelRecords 
						) 
				) );
				$this->set ( 'getPanelSubLab', $getPanelSubLab );
				$this->set ( 'LabName', $LabName );
			} else {
				$this->set ( 'LabName', $LabName );
			}
			
			$Race = $this->Race->find ( 'list', array (
					'fields' => array (
							'value_code',
							'race_name' 
					),
					'order' => array (
							'race_name ASC' 
					) 
			) );
			$this->set ( 'race', $Race );
			
			$speciemtActionCode0065 = $this->SpecimenActionCode0065->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$resultStatus0123 = $this->ResultStatus0123->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$units_option = $this->Hl7Unit->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$initial_option = $this->Initial->find ( 'list', array (
					'fields' => array (
							'name' 
					) 
			) );
			$nameType_option = $this->NameType->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$obsMethod_option = $this->Hl7ObservationMethod->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$identifier_type_option = $this->Hl7IdentifierType->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$address_type_option = $this->Hl7_0190_address_types->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$hl7_coded_observation_option = $this->Hl7LaboratoryCodedObservation->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$specimenRejectReason = $this->SpecimenRejectReason0490->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$specimenConditionReason = $this->SpecimenCondition0493->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$labResultStatus = $this->ObservationResultStatus0085->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$state_options = $this->State->find ( 'list', array (
					'fields' => array (
							'state_code',
							'name' 
					),
					'conditions' => array (
							'State.country_id' => "2" 
					),
					'order' => array (
							'State.name ASC' 
					) 
			) );
			$this->set ( array (
					'hl7_coded_observation_option' => $hl7_coded_observation_option,
					'speciemtActionCode0065' => $speciemtActionCode0065,
					'resultStatus0123' => $resultStatus0123,
					'specimenRejectReason' => $specimenRejectReason,
					'specimenConditionReason' => $specimenConditionReason,
					'labResultStatus' => $labResultStatus,
					'units_option' => $units_option,
					'state_options' => $state_options,
					'address_type_option' => $address_type_option,
					'initial_option' => $initial_option,
					'nameType_option' => $nameType_option,
					'obsMethod_option' => $obsMethod_option,
					'identifier_type_option' => $identifier_type_option 
			) );
			
			if (! empty ( $this->request->data )) {
				$this->request->data ['labHl7Result'] ['create_time'] = date ( "Y-m-d H:i:s" );
				$this->request->data ['labHl7Result'] ['patient_id'] = $patient_id;
				$this->request->data ['labHl7Result'] ['user_id'] = $this->Session->read ( 'userid' );
				$this->request->data ['labHl7Result'] ['laboratory_test_order_id'] = $testid;
				// $this->request->data['labHl7Result']['rct_name'] = $this->request->data['labHl7Result']['rct_prefix']." ".$this->request->data['labHl7Result']['rct_name'];
				$this->request->data ['labHl7Result'] ['confirm_result'] = '1';
				$this->request->data ['labHl7Result'] ['result_publish_date'] = $patientData ['LaboratoryTestOrder'] ['start_date'];
				// debug($this->request->data);exit;
				// echo "<pre>";print_r($this->request->data);exit;
				$this->set ( 'send_result_to_facility', $this->request->data ['labHl7Result'] ['send_result_to_facility'] );
				// BOF adeverse event
				$adverse_event = 0;
				if (! empty ( $this->request->data ['labHl7Result'] ['sn_result_0'] )) {
					$this->LaboratoryTestOrder->bindModel ( array (
							'belongsTo' => array (
									'Laboratory' => array (
											'foreignKey' => 'laboratory_id',
											'conditions' => array (
													'Laboratory.is_active' => 1 
											) 
									) 
							) 
					), false );
					$snowmedArray = $this->LaboratoryTestOrder->find ( 'first', array (
							'fields' => array (
									'Laboratory.sct_concept_id' 
							),
							'conditions' => array (
									'LaboratoryTestOrder.is_deleted' => 0,
									'LaboratoryTestOrder.id' => $this->request->data ['labHl7Result'] ['laboratory_test_order_id'] 
							) 
					) );
					$adverseArray = $this->AdverseEventTrigger->getEventTriggers ( array (
							'snowmed' 
					), array (
							'section' => 'labs' 
					) );
					
					if (in_array ( $snowmedArray ['Laboratory'] ['sct_concept_id'], $adverseArray )) {
						$adverse_event = 1;
					}
				}
				$this->request->data ['labHl7Result'] ['adverse_event'] = $adverse_event;
				// EOF adverse event
				$this->request->data ['labHl7Result'] ['laboratory_id'] = $LabName ['Laboratory'] ['id'];
				$this->request->data ['labHl7Result'] ['histopathology_data'] = serialize ( $this->request->data ['labHl7Result1'] );
				
				$this->LaboratoryResult->save ( $this->request->data ['labHl7Result'] );
				$labSavedResultId = $this->LaboratoryResult->id;
				if (($this->LaboratoryResult->save ( $this->request->data ['labHl7Result'] ) && empty ( $this->request->data ['Panel'] ))) {
					$tempArr ['observations'] = $this->request->data ['labHl7Result'] ['observation_0'];
					$tempArr ['result'] = $this->request->data ['labHl7Result'] ['result_0'];
					if (! empty ( $this->request->data ['labHl7Result'] ['sn_result_0'] )) {
						$tempArr ['result'] = $this->request->data ['labHl7Result'] ['sn_result_0'];
					}
					$tempArr ['laboratory_id'] = $LabName ['Laboratory'] ['id'];
					$tempArr ['unit'] = $this->request->data ['labHl7Result'] ['unit_0'];
					$tempArr ['uom'] = $this->request->data ['labHl7Result'] ['uom_0'];
					$tempArr ['range'] = $this->request->data ['labHl7Result'] ['range_0'];
					$tempArr ['abnormal_flag'] = $this->request->data ['labHl7Result'] ['abnormal_flag_0'];
					$tempArr ['status'] = $this->request->data ['labHl7Result'] ['status_0'];
					$tempArr ['date_time_of_observation'] = $this->DateFormat->formatDate2STD ( $this->request->data ['labHl7Result'] ['od_observation_start_date_time'], Configure::read ( 'date_format_us' ) );
					$tempArr ['notes'] = $this->request->data ['labHl7Result'] ['notes_0'];
					$tempArr ['laboratory_result_id'] = $this->LaboratoryResult->id;
					$tempArr ['location_id'] = $this->Session->read ( 'locatioid' );
					$tempArr ['created_by'] = $this->Session->read ( 'userid' );
					$tempArr ['create_time'] = date ( 'Y-m-d H:i:s' );
					$tempArr ['sn_value'] = $this->request->data ['labHl7Result'] ['sn_value_0'];
					$tempArr ['observation_mehtod'] = $this->request->data ['labHl7Result'] ['observation_method_0'];
					$tempArr ['alt_identifier'] = $this->request->data ['labHl7Result'] ['alt_identifier_0'];
					$tempArr ['alt_text'] = $this->request->data ['labHl7Result'] ['alt_text_0'];
					$tempArr ['alt_coding_name'] = $this->request->data ['labHl7Result'] ['alt_coding_name_0'];
					$tempArr ['code_system_id'] = $this->request->data ['labHl7Result'] ['code_system_id_0'];
					$tempArr ['alt_code_system_id'] = $this->request->data ['labHl7Result'] ['alt_code_system_id_0'];
					$tempArr ['original_text'] = $this->request->data ['labHl7Result'] ['original_text_0'];
					$tempArr ['location_id'] = $this->Session->read ( 'locationid' );
					$tempArr ['create_time'] = date ( "Y-m-d H:i:s" );
					// if($this->request->data['labcount'] == 1)
					// $this->request->data['labcount'] = 0;
					$labResultArr [] = $tempArr;
					$this->LaboratoryHl7Result->saveAll ( $labResultArr [0] );
				}
				
				/*
				 * for($i=1;$i<=$this->request->data['labcount']; $i++){
				 * if(!empty($this->request->data['observation_'.$i]) && empty($this->request->data['Panel'])){
				 * $tempArr['observations'] = $this->request->data['observation_'.$i];
				 * $tempArr['unit'] = $this->request->data['unit_'.$i];
				 * $tempArr['result'] = $this->request->data['result_'.$i];
				 * if(!empty($this->request->data['sn_result_'.$i])){
				 * $tempArr['result'] = $this->request->data['sn_result_'.$i];
				 * }
				 * $tempArr['uom'] = $this->request->data['uom_'.$i];
				 * $tempArr['range'] = $this->request->data['range_'.$i];
				 * $tempArr['abnormal_flag'] = $this->request->data['abnormal_flag_'.$i];
				 * $tempArr['status'] = $this->request->data['status_'.$i];
				 * $tempArr['date_time_of_observation'] = $this->request->data['labHl7Result'][0]['od_observation_start_date_time'] = $this->request->data['labHl7Result'][0]['od_observation_start_date_time'];
				 * $tempArr['notes'] = $this->request->data['notes_'.$i];
				 * $tempArr['laboratory_result_id'] = $this->LaboratoryResult->id;
				 * $tempArr['location_id'] = $this->Session->read('locationid');
				 * $tempArr['created_by'] = $this->Session->read('userid');
				 * $tempArr['create_time'] = date('Y-m-d H:i:s');
				 * $tempArr['sn_value'] = $this->request->data['sn_value_'.$i];
				 * $tempArr['observation_mehtod'] = $this->request->data['observation_method_'.$i];
				 * $tempArr['alt_identifier'] = $this->request->data['alt_identifier_'.$i];
				 * $tempArr['alt_text'] = $this->request->data['alt_text_'.$i];
				 * $tempArr['alt_coding_name'] = $this->request->data['alt_coding_name_'.$i];
				 * $tempArr['code_system_id'] = $this->request->data['code_system_id_'.$i];
				 * $tempArr['alt_code_system_id'] = $this->request->data['alt_code_system_id_'.$i];
				 * $tempArr['original_text'] = $this->request->data['original_text_'.$i];
				 * $tempArr['create_time'] = date("Y-m-d H:i:s");
				 * $labResultArr[]=$tempArr;
				 * $this->LaboratoryHl7Result->saveAll($labResultArr);
				 * }
				 * }
				 */
				
				if (! empty ( $this->request->data ['Panel'] )) {
					/*
					 * debug($this->request->data['Panel']);
					 * exit;
					 */
					for($i = 0; $i < count ( $this->request->data ['Panel'] ['observationDisplay_0'] ); $i ++) {
						$tempArr1 ['observations'] = $this->request->data ['observation_' . $i]; // $this->request->data['Panel']['observationDisplay_0'][$i];
						$tempArr1 ['uom'] = $this->request->data ['Panel'] ['uomDisplay_0_id'] [$i];
						// debug($tempArr1['uom']);exit;
						$spcialIncrement = $i;
						$spcialIncrement = $spcialIncrement + $spcialIncrement + 1;
						$tempArr1 ['result'] = $this->request->data ['Panel'] ['sn_value_0'] [$i];
						$tempArr1 ['unit'] = $this->request->data ['Panel'] ['unit_0'] [$i];
						$tempArr1 ['range'] = $this->request->data ['Panel'] ['range_0'] [$i];
						$tempArr1 ['abnormal_flag'] = $this->request->data ['Panel'] ['abnormal_flagDisplay_0_id'] [$i];
						$tempArr1 ['status'] = $this->request->data ['Panel'] ['status_0'] [$i];
						$tempArr1 ['date_time_of_observation'] = $this->request->data ['labHl7Result'] [0] ['od_observation_start_date_time'] = $this->request->data ['labHl7Result'] [0] ['od_observation_start_date_time'];
						$tempArr1 ['notes'] = $this->request->data ['notes_0'] [$i];
						$tempArr1 ['laboratory_result_id'] = $this->LaboratoryResult->id;
						$tempArr1 ['location_id'] = $this->Session->read ( 'locationid' );
						$tempArr1 ['created_by'] = $this->Session->read ( 'userid' );
						$tempArr1 ['create_time'] = date ( 'Y-m-d H:i:s' );
						$tempArr1 ['sn_value'] = $this->request->data ['sn_value_0'] [$i];
						$tempArr1 ['laboratory_id'] = $this->request->data ['Panel'] ['obs_id'] [$i];
						$tempArr1 ['create_time'] = date ( "Y-m-d H:i:s" );
						$labResultArr1 [] = $tempArr1; // debug($labResultArr1); exit;
						$this->LaboratoryHl7Result->saveAll ( $labResultArr1 );
						unset ( $labResultArr1 );
						$this->id = null;
					}
				}
				
				if (isset ( $this->request->data ['Submit_&_Add_More'] ) && ! empty ( $this->request->data ['Submit_&_Add_More'] )) {
					$this->redirect ( array (
							'controller' => 'laboratories',
							'action' => 'labTestResultsHl7',
							$testid,
							$patient_id 
					) );
				} else {
					
					// ----------------------------------------------- HL&7 Result---------------------------------------------
					
					$this->LaboratoryResult->bindModel ( array (
							'hasMany' => array (
									'LaboratoryHl7Result' => array (
											'foreignKey' => 'laboratory_result_id' 
									) 
							) 
					) );
					
					/*
					 * $this->LaboratoryResult->bindModel(array(
					 * /*'hasMany' => array(
					 * 'LaboratoryHl7Result' =>array('foreignKey'=>'laboratory_result_id')),
					 * 'belongsTo' => array(
					 * 'LaboratoryHl7Result1' => array('className'=>'LaboratoryHl7Result','foreignKey' => false,
					 * 'fields'=>array('laboratory_result_id','id','laboratory_id','unit','result'),
					 * 'conditions' => array('LaboratoryHl7Result1.laboratory_result_id = LaboratoryResult.id'),
					 * ),
					 */
					
					// LaboratoryHl7Result
					
					$model = ClassRegistry::init ( 'Hl7Result' );
					$modelMes = ClassRegistry::init ( 'Hl7Message' );
					$get_lab_result = $this->LaboratoryResult->find ( 'all', array (
							'conditions' => array (
									'laboratory_test_order_id' => $testid,
									'patient_id' => $patient_id 
							) 
					) );
					// debug($get_lab_result);exit;
					$msg = $model->genratelabResultIPDtoOPD ( $get_lab_result, $this->request->data ['labHl7Result'] [current_time] );
					$modelMes->saveAll ( array (
							'subject' => 'Report of the Lab Order',
							'message_to' => $get_lab_result [0] ['LaboratoryResult'] ['send_result_to_facility'],
							'patient_name' => $patientData ['Patient'] ['lookup_name'],
							'message' => $msg,
							'message_from' => 'LAB_RESULT_LRI',
							'create_time' => date ( 'Y-m-d H:i:s' ),
							'patient_id' => $patientData ['Person'] ['patient_uid'] 
					) );
					
					$this->Session->setFlash ( __ ( 'Lab Result Saved successfully', true ), 'default', array (
							'class' => 'message' 
					) );
					if (empty ( $this->request->data ['labHl7Result'] ['noteId'] )) {
						$this->redirect ( array (
								'controller' => 'laboratories',
								'action' => 'viewLabTestResultsHl7',
								$patient_id,
								$testid,
								$labSavedResultId,
								'?' => array (
										'from' => 'list',
										'patientId' => $patient_id 
								) 
						) );
					} else {
						$this->redirect ( array (
								'controller' => 'notes',
								'action' => 'soapNote',
								$patient_id,
								$this->request->data ['labHl7Result'] ['noteId'] 
						) );
					}
					
					// ==============================================================================================================
				}
			}
			
			$this->Patient->unbindModel ( array (
					'hasOne' => array (
							'Person' 
					) 
			), false );
			$this->patient_info ( $patient_id );
		}
		public function editLabTestResultLri($testid, $patient_id) {
			$this->uses = array (
					'Hl7Message',
					'Hl7LaboratoryCodedObservation',
					'Hl7Result',
					'LaboratoryResult',
					'LaboratoryHl7Result',
					'Patient',
					'Person',
					'Race',
					'SpecimenActionCode0065',
					'ResultStatus0123',
					'SnomedSctHl7',
					'SpecimenRejectReason0490',
					'SpecimenCondition0493',
					'ObservationInterpretation0078',
					'ObservationResultStatus0085',
					'LoincLnHl7',
					'LabManager',
					'User',
					'Hl7Unit',
					'Ucums',
					'State',
					'Initial',
					'NameType',
					'Hl7ObservationMethod',
					'Hl7IdentifierType',
					'Hl7_0190_address_types',
					'AdverseEventTrigger',
					'LaboratoryTestOrder',
					'Person' 
			);
			$this->patient_info ( $patient_id );
			$labResultArr = array ();
			$tempArr = array ();
			$this->LaboratoryResult->bindModel ( array (
					'hasMany' => array (
							'LaboratoryHl7Result' => array (
									'foreignKey' => 'laboratory_result_id' 
							) 
					),
					'hasOne' => array (
							'Patient' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryResult.patient_id=Patient.id' 
									) 
							),
							'Person' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Person.id=Patient.person_id' 
									) 
							),
							'LaboratoryTestOrder' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryTestOrder.id=LaboratoryResult.laboratory_test_order_id' 
									) 
							),
							'Laboratory' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryTestOrder.laboratory_id=Laboratory.id' 
									) 
							),
							'releventInfo' => array (
									'className' => 'SnomedSctHl7',
									'foreignKey' => false,
									'conditions' => array (
											'releventInfo.code=LaboratoryResult.od_relevant_clinical_information' 
									) 
							),
							'siType' => array (
									'className' => 'SnomedSctHl7',
									'foreignKey' => false,
									'conditions' => array (
											'siType.code=LaboratoryResult.si_specimen_type' 
									) 
							) 
					) 
			), false );
			$patientData = $this->LaboratoryResult->find ( 'all', array (
					'fields' => array (
							'Patient.id',
							'Patient.doctor_id',
							'Person.first_name',
							'Person.last_name',
							'Person.dob',
							'Person.sex',
							'Person.race',
							'LaboratoryTestOrder.order_id',
							'LaboratoryTestOrder.laboratory_id',
							'LaboratoryResult.id',
							'LaboratoryResult.ogi_filler_order_number',
							'LaboratoryResult.laboratory_test_order_id',
							'LaboratoryResult.ogi_placer_group_number',
							'LaboratoryResult.od_universal_service_identifier',
							'LaboratoryResult.od_observation_start_date_time',
							'LaboratoryResult.od_observation_end_date_time',
							'LaboratoryResult.od_specimen_action_code',
							'LaboratoryResult.od_relevant_clinical_information',
							'LaboratoryResult.od_relevent_clinical_information_original_text',
							'LaboratoryResult.ori_result_status',
							'LaboratoryResult.rct_prefix',
							'LaboratoryResult.rct_prefix',
							'LaboratoryResult.rct_name',
							'LaboratoryResult.rct_middle_name',
							'LaboratoryResult.rct_last_name',
							'LaboratoryResult.rct_identifier',
							'LaboratoryResult.rh_standard',
							'LaboratoryResult.rh_local',
							'LaboratoryResult.on_notes_comments',
							'LaboratoryResult.tqi_start_date_time',
							'LaboratoryResult.tqi_end_date_time',
							'LaboratoryResult.si_specimen_type',
							'LaboratoryResult.si_specimen_original_text',
							'LaboratoryResult.send_result_to_facility',
							'LaboratoryResult.si_start_date_time',
							'LaboratoryResult.si_specimen_reject_reason',
							'LaboratoryResult.si_reject_reason_original_text',
							'LaboratoryResult.si_specimen_condition',
							'LaboratoryResult.si_condition_original_text',
							'LaboratoryResult.re_notes_comments',
							'LaboratoryResult.rct_suffix',
							'Laboratory.name',
							'Laboratory.lonic_code',
							'releventInfo.code',
							'releventInfo.display_name',
							'siType.code',
							'siType.display_name' 
					),
					'conditions' => array (
							'LaboratoryResult.laboratory_test_order_id' => $testid,
							'LaboratoryResult.patient_id' => $patient_id 
					),
					'recursive' => 1 
			) );
			
			$this->set ( 'patientData', $patientData );
			$doctorData = $this->User->find ( 'first', array (
					'fields' => array (
							'User.id',
							'User.first_name',
							'User.last_name' 
					),
					'conditions' => array (
							'User.id' => $patientData [0] ['Patient'] ['doctor_id'] 
					) 
			) );
			$this->set ( 'doctorData', $doctorData );
			/*
			 * $LabName = $this->Laboratory->find('first',array('fields'=>array('Laboratory.name','Laboratory.lonic_code'),
			 * 'conditions'=>array('Laboratory.id'=>$patientData['LaboratoryTestOrder']['laboratory_id']),'order'=>array('Laboratory.name ASC')));
			 * $this->set('LabName',$LabName);
			 */
			$Race = $this->Race->find ( 'list', array (
					'fields' => array (
							'value_code',
							'race_name' 
					),
					'order' => array (
							'race_name ASC' 
					) 
			) );
			$this->set ( 'race', $Race );
			$speciemtActionCode0065 = $this->SpecimenActionCode0065->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$resultStatus0123 = $this->ResultStatus0123->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$specimenTypeSnomedSct = $this->SnomedSctHl7->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$units_option = $this->Hl7Unit->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$ucums_option = $this->Ucums->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$initial_option = $this->Initial->find ( 'list', array (
					'fields' => array (
							'name' 
					) 
			) );
			$nameType_option = $this->NameType->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$obsMethod_option = $this->Hl7ObservationMethod->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$identifier_type_option = $this->Hl7IdentifierType->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$address_type_option = $this->Hl7_0190_address_types->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$hl7_coded_observation_option = $this->Hl7LaboratoryCodedObservation->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$specimenRejectReason = $this->SpecimenRejectReason0490->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$specimenConditionReason = $this->SpecimenCondition0493->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$abnormalFlag = $this->ObservationInterpretation0078->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$labResultStatus = $this->ObservationResultStatus0085->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$loincCode = $this->LoincLnHl7->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$state_options = $this->State->find ( 'list', array (
					'fields' => array (
							'state_code',
							'name' 
					),
					'conditions' => array (
							'State.country_id' => "2" 
					),
					'order' => array (
							'State.name ASC' 
					) 
			) );
			
			$this->set ( array (
					'hl7_coded_observation_option' => $hl7_coded_observation_option,
					'speciemtActionCode0065' => $speciemtActionCode0065,
					'resultStatus0123' => $resultStatus0123,
					'specimenTypeSnomedSct' => $specimenTypeSnomedSct,
					'specimenRejectReason' => $specimenRejectReason,
					'specimenConditionReason' => $specimenConditionReason,
					'abnormalFlag' => $abnormalFlag,
					'labResultStatus' => $labResultStatus,
					'loincCode' => $loincCode,
					'units_option' => $units_option,
					'ucums_option' => $ucums_option,
					'state_options' => $state_options,
					'initial_option' => $initial_option,
					'nameType_option' => $nameType_option,
					'obsMethod_option' => $obsMethod_option,
					'identifier_type_option' => $identifier_type_option,
					'address_type_option' => $address_type_option 
			) );
			
			if (! empty ( $this->request->data )) { // debug($this->request->data);exit;
				foreach ( $this->request->data ['labHl7Result'] as $labResult ) {
					$labResult ['modify_time'] = date ( "Y-m-d H:i:s" );
					$labResult ['modified_by'] = $this->Session->read ( 'userid' );
					$labResult ['laboratory_id'] = $patientData [0] ['LaboratoryTestOrder'] ['laboratory_id'];
					$this->LaboratoryResult->save ( $labResult );
				}
				foreach ( $this->request->data [0] as $labHl7Result ) {
					$labHl7Result ['LaboratoryHl7Result'] ['modify_time'] = date ( "Y-m-d H:i:s" );
					$labHl7Result ['LaboratoryHl7Result'] ['create_time'] = date ( "Y-m-d H:i:s" );
					$labHl7Result ['LaboratoryHl7Result'] ['modified_by'] = $this->Session->read ( 'userid' );
					$labHl7Result ['LaboratoryHl7Result'] ['date_time_of_observation'] = $this->request->data ['labHl7Result'] [0] ['LaboratoryResult'] ['od_observation_start_date_time'];
					
					if (! empty ( $labHl7Result ['LaboratoryHl7Result'] ['sn_result'] )) {
						$labHl7Result ['LaboratoryHl7Result'] ['result'] = $labHl7Result ['LaboratoryHl7Result'] ['sn_result'];
					}
					
					$this->LaboratoryHl7Result->save ( $labHl7Result );
					$this->id = null;
				}
				$this->LaboratoryResult->bindModel ( array (
						'hasMany' => array (
								'LaboratoryHl7Result' => array (
										'foreignKey' => 'laboratory_result_id' 
								) 
						) 
				) );
				// LaboratoryHl7Result
				
				$model = ClassRegistry::init ( 'Hl7Result' );
				$modelMes = ClassRegistry::init ( 'Hl7Message' );
				$get_lab_result = $this->LaboratoryResult->find ( 'all', array (
						'conditions' => array (
								'laboratory_test_order_id' => $testid,
								'LaboratoryResult.patient_id' => $patient_id 
						) 
				) );
				$msg = $model->genratelabResultIPDtoOPD ( $get_lab_result, $this->request->data ['labHl7Resulttime'] [current_time] );
				$modelMes->saveAll ( array (
						'subject' => 'Report of the Lab Order',
						'message_to' => $get_lab_result [0] ['LaboratoryResult'] ['send_result_to_facility'],
						'patient_name' => $patientData ['Patient'] ['lookup_name'],
						'message' => $msg,
						'message_from' => 'LAB_RESULT_EDIT_LRI',
						'create_time' => date ( 'Y-m-d H:i:s' ),
						'patient_id' => $patientData ['Patient'] ['patient_id'] 
				) );
				$this->Session->setFlash ( __ ( 'Lab Result Saved successfully', true ), 'default', array (
						'class' => 'message' 
				) );
				$this->redirect ( array (
						'controller' => 'laboratories',
						'action' => 'viewLabTestResultsHl7',
						$patient_id,
						$testid 
				) );
			}
			$this->Patient->unbindModel ( array (
					'hasOne' => array (
							'Person' 
					) 
			), false );
			
			$this->patient_info ( $patient_id );
		}
		function viewLabTestResultsHl7($patientid, $testId, $resultId = null) {
			$this->uses = array (
					'Facility',
					'PanelMapping',
					'NewCropAllergies',
					'Race',
					'SnomedSctHl7',
					'Patient',
					'LaboratoryResult',
					'LaboratoryHl7Result',
					'LoincLnHl7',
					'Hl7Unit',
					'Ucums',
					'ObservationInterpretation0078',
					'ObservationResultStatus0085',
					'User' 
			);
			$this->layout = 'print_without_header';
			$loincCode = $this->LoincLnHl7->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					) 
			) );
			$units_option = $this->Hl7Unit->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					) 
			) );
			$ucums_option = $this->Ucums->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					) 
			) );
			$abnormalFlag = $this->ObservationInterpretation0078->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					) 
			) );
			$labResultStatus = $this->ObservationResultStatus0085->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					) 
			) );
			$specimenTypeSnomedSct = $this->SnomedSctHl7->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					) 
			) );
			$this->set ( 'loincCode', $loincCode );
			$this->set ( 'units_option', $units_option );
			$this->set ( 'ucums_option', $ucums_option );
			$this->set ( 'abnormalFlag', $abnormalFlag );
			$this->set ( 'labResultStatus', $labResultStatus );
			$this->set ( 'specimenTypeSnomedSct', $specimenTypeSnomedSct );
			$this->set ( 'noteId', $this->params->query ['noteId'] );
			
			$this->Patient->bindModel ( array (
					'hasOne' => array (
							'Person' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Person.patient_uid=Patient.patient_id' 
									) 
							),
							'LaboratoryTestOrder' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryTestOrder.patient_id=Patient.id' 
									) 
							),
							'Laboratory' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryTestOrder.laboratory_id=Laboratory.id' 
									),
									'fields' => array (
											'Laboratory.name' 
									) 
							) 
					) 
			), false );
			// echo "<pre>";print_r($this->request->data);exit;
			$Race = $this->Race->find ( 'list', array (
					'fields' => array (
							'value_code',
							'race_name' 
					),
					'order' => array (
							'race_name ASC' 
					) 
			) );
			$this->set ( 'race', $Race );
			$userSignImage = $this->User->find ( 'first', array (
					'fields' => array (
							'User.sign' 
					),
					'conditions' => array (
							'User.id' => $this->Session->read ( 'userid' ) 
					) 
			) );
			$this->set ( 'userSignImage', $userSignImage ["User"] ["sign"] );
			$patientData = $this->Patient->find ( 'first', array (
					'conditions' => array (
							'Patient.id' => $patientid 
					) 
			) );
			
			$this->set ( 'patientData', $patientData );
			$pId = $this->Patient->find ( 'list', array (
					'fields' => array (
							'Patient.id',
							'Patient.id' 
					),
					'conditions' => array (
							'person_id' => $patientData ['Patient'] ['person_id'] 
					) 
			) );
			$search_key1 ['NewCropAllergies.is_reconcile'] = 0;
			$search_key1 ['NewCropAllergies.status'] = 'A';
			$search_key1 ['NewCropAllergies.patient_uniqueid'] = $pId;
			$allergies_data = $this->NewCropAllergies->find ( 'all', array (
					'fields' => array (
							'name',
							'reaction',
							'AllergySeverityName',
							'onset_date' 
					),
					'conditions' => $search_key1 
			) );
			$this->set ( "allergies_data", $allergies_data );
			
			$this->LaboratoryResult->bindModel ( array(
				/*'hasMany' => array(
						'LaboratoryHl7Result' =>array('foreignKey'=>'laboratory_result_id')),*/
				'belongsTo' => array (
							'LaboratoryHl7Result1' => array (
									'className' => 'LaboratoryHl7Result',
									'foreignKey' => false,
									'fields' => array (
											'laboratory_result_id',
											'id',
											'laboratory_id',
											'unit',
											'result' 
									),
									'conditions' => array (
											'LaboratoryHl7Result1.laboratory_result_id = LaboratoryResult.id' 
									) 
							),
							'Laboratory' => array (
									'className' => 'Laboratory',
									'foreignKey' => false,
									'fields' => array (
											'name',
											'id',
											'lonic_code',
											'dhr_result_code',
											'lab_type' 
									),
									'conditions' => array (
											'Laboratory.id = LaboratoryResult.laboratory_id' 
									) 
							),
							'LaboratoryToken' => array (
									'className' => 'LaboratoryToken',
									'foreignKey' => false,
									'fields' => array (
											'ac_id',
											'id',
											'primary_care_pro',
											'question' 
									),
									'conditions' => array (
											'LaboratoryResult.laboratory_test_order_id = LaboratoryToken.laboratory_test_order_id' 
									) 
							),
							'LaboratoryTestOrder' => array (
									'className' => 'LaboratoryTestOrder',
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryTestOrder.id = LaboratoryResult.laboratory_test_order_id' 
									) 
							) 
					) 
			) );
			if ($resultId) {
				$conds = array (
						'LaboratoryResult.laboratory_test_order_id' => $testId,
						'LaboratoryResult.id' => $resultId,
						'LaboratoryResult.patient_id' => $patientid 
				);
			} else {
				$conds = array (
						'LaboratoryResult.laboratory_test_order_id' => $testId,
						'LaboratoryResult.patient_id' => $patientid 
				);
			}
			$get_lab_result = $this->LaboratoryResult->find ( 'first', array (
					'conditions' => $conds,
					'group' => array (
							'LaboratoryResult.id' 
					) 
			) );
			
			$this->set ( 'get_lab_result_main', $get_lab_result );
			$this->LaboratoryHl7Result->bindModel ( array (
					'hasOne' => array (
							'Laboratory' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryHl7Result.laboratory_id = Laboratory.id' 
									) 
							) 
					) 
			) );
			$labHl7Result = $this->LaboratoryHl7Result->find ( 'all', array (
					'fields' => array (
							'LaboratoryHl7Result.*',
							'Laboratory.id',
							'Laboratory.name',
							'Laboratory.dhr_result_code',
							'Laboratory.dhr_result_code',
							'Laboratory.dhr_result_description' 
					),
					'conditions' => array (
							'laboratory_result_id' => $get_lab_result ['LaboratoryResult'] ['id'] 
					) 
			) );
			
			$get_lab_result ['LaboratoryHl7Result'] = $labHl7Result;
			$this->PanelMapping->bindModel ( array (
					'belongsTo' => array (
							'Laboratory' => array (
									'foreignKey' => false,
									'conditions' => array (
											'PanelMapping.underpanellab_id = Laboratory.id' 
									) 
							) 
					) 
			), false );
			// debug($get_lab_result);
			// $panelTests = $this->PanelMapping->find('all',array('fields'=>array('Laboratory.id','Laboratory.name'),'conditions'=>array('PanelMapping.laboratory_id'=>$get_lab_result['LaboratoryResult']['laboratory_id'])));
			$panelTests = $this->Laboratory->find ( 'list', array (
					'fields' => array (
							'id',
							'name' 
					) 
			) );
			$this->set ( 'panelTests', $panelTests );
			
			$this->set ( 'get_lab_result', $get_lab_result ); // ObservationInterpretation0078
			$this->Patient->unbindModel ( array (
					'hasOne' => array (
							'Person' 
					) 
			), false );
			$this->patient_info ( $patientid );
			$clientInfo = $this->Facility->find ( 'first', array (
					'fields' => array (
							'Facility.*' 
					),
					'conditions' => array (
							'Facility.name' => $this->Session->read ( 'facility' ) 
					) 
			) );
			$this->set ( "clientInfo", $clientInfo );
			// echo '<pre>';print_r($get_lab_result);exit;
		}
		public function viewLabHl7Result($patientid, $testId) {
			$this->uses = array (
					'Hl70004PatientClass',
					'Hl7AdmissionType',
					'Patient',
					'Hl7ObservationMethod',
					'SnomedSctHl7',
					'PHVS_ModifierOrQualifier_CDC',
					'LaboratoryResult',
					'LaboratoryHl7Result',
					'LoincLnHl7',
					'Hl7Unit',
					'Ucums',
					'ObservationInterpretation0078',
					'ObservationResultStatus0085' 
			);
			$loincCode = $this->LoincLnHl7->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					) 
			) );
			$units_option = $this->Hl7Unit->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					) 
			) );
			$ucums_option = $this->Ucums->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					) 
			) );
			$abnormalFlag = $this->ObservationInterpretation0078->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					) 
			) );
			$labResultStatus = $this->ObservationResultStatus0085->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					) 
			) );
			$specimenTypeSnomedSct = $this->SnomedSctHl7->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					) 
			) );
			$phpvsModifier = $this->PHVS_ModifierOrQualifier_CDC->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					) 
			) );
			$obsMethod_option = $this->Hl7ObservationMethod->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					) 
			) );
			
			$hl7PatientClass = $this->Hl70004PatientClass->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					) 
			) );
			$hl7AdmissionType = $this->Hl7AdmissionType->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					) 
			) );
			
			$this->set ( 'loincCode', $loincCode );
			$this->set ( 'units_option', $units_option );
			$this->set ( 'ucums_option', $ucums_option );
			$this->set ( 'abnormalFlag', $abnormalFlag );
			$this->set ( 'labResultStatus', $labResultStatus );
			$this->set ( 'specimenTypeSnomedSct', $specimenTypeSnomedSct );
			$this->set ( 'phpvsModifier', $phpvsModifier );
			$this->set ( 'obsMethod_option', $obsMethod_option );
			$this->set ( 'hl7PatientClass', $hl7PatientClass );
			$this->set ( 'hl7AdmissionType', $hl7AdmissionType );
			
			$this->Patient->bindModel ( array (
					'hasOne' => array (
							'Person' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Person.patient_uid=Patient.patient_id' 
									) 
							),
							'LaboratoryTestOrder' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryTestOrder.patient_id=Patient.id' 
									) 
							) 
					) 
			), false );
			// echo "<pre>";print_r($this->request->data);exit;
			
			$patientData = $this->Patient->find ( 'first', array (
					'conditions' => array (
							'Patient.id' => $patientid 
					) 
			) );
			$this->set ( 'patientData', $patientData );
			
			$this->LaboratoryResult->bindModel ( array (
					'hasMany' => array (
							'LaboratoryHl7Result' => array (
									'foreignKey' => 'laboratory_result_id' 
							) 
					),
					'belongsTo' => array (
							
							'LaboratoryHl7Result1' => array (
									'className' => 'LaboratoryHl7Result',
									'foreignKey' => false,
									'fields' => array (
											'laboratory_result_id',
											'id' 
									),
									'conditions' => array (
											'LaboratoryHl7Result1.laboratory_result_id = LaboratoryResult.id' 
									) 
							),
							
							'Laboratory' => array (
									'foreignKey' => false,
									'fields' => array (
											'name',
											'id' 
									),
									'conditions' => array (
											'LaboratoryHl7Result1.observations = Laboratory.lonic_code' 
									) 
							),
							'LoincLnHl7' => array (
									'className' => 'Laboratory',
									'foreignKey' => false,
									'fields' => array (
											'id',
											'lonic_code',
											'name' 
									),
									'conditions' => array (
											'LaboratoryHl7Result1.observations = LoincLnHl7.lonic_code' 
									) 
							),
							'SpecimenActionCode0065' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryResult.od_specimen_action_code = SpecimenActionCode0065.code' 
									) 
							),
							'SnomedSctHl7' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryResult.od_relevant_clinical_information = SnomedSctHl7.id' 
									) 
							),
							'ResultStatus0123' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryResult.ori_result_status = ResultStatus0123.code' 
									) 
							),
							'SpecimenRejectReason0490' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryResult.si_specimen_reject_reason = SpecimenRejectReason0490.code' 
									) 
							),
							'SpecimenCondition0493' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryResult.si_specimen_condition = SpecimenCondition0493.code' 
									) 
							),
							'PHVS_ModifierOrQualifier_CDC' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryResult.si_specimen_type_modifier = PHVS_ModifierOrQualifier_CDC.value_code' 
									) 
							),
							'Specimen_activities' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryResult.si_specimen_type_activities = Specimen_activities.value_code' 
									) 
							),
							'Body_site_value_set' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryResult.si_specimen_source = Body_site_value_set.value_code' 
									) 
							),
							'Specimen_role' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryResult.si_specimen_role = Specimen_role.value_code' 
									) 
							)
							,
						/*'Ucums' => array('foreignKey' => false,
						 'conditions' => array('LaboratoryResult.si_specimen_col_amount = Ucums.code'),

						),*/

				) 
			) );
			$get_lab_result = $this->LaboratoryResult->find ( 'all', array (
					'conditions' => array (
							'laboratory_test_order_id' => $testId,
							'patient_id' => $patientid 
					) 
			) );
			$this->Patient->unbindModel ( array (
					'hasOne' => array (
							'Person' 
					) 
			), false );
			$this->patient_info ( $patientid );
			$this->set ( 'get_lab_result', $get_lab_result ); // Ucums
		}
		public function editLabHl7Result($patient_id, $testid) {
			$this->uses = array (
					'Hl7AdmissionType',
					'Hl70004PatientClass',
					'Hl7Result',
					'LaboratoryResult',
					'LaboratoryHl7Result',
					'Patient',
					'Person',
					'Race',
					'SpecimenActionCode0065',
					'ResultStatus0123',
					'SnomedSctHl7',
					'SpecimenRejectReason0490',
					'SpecimenCondition0493',
					'ObservationInterpretation0078',
					'ObservationResultStatus0085',
					'LoincLnHl7',
					'LabManager',
					'User',
					'Hl7Unit',
					'Ucums',
					'State',
					'Initial',
					'NameType',
					'Hl7ObservationMethod',
					'Hl7IdentifierType',
					'Hl7_0190_address_types',
					'Hl7_0201_phvs_telecommunications',
					'hl7_0202_telecommunication_equipment_types',
					'Hl7LaboratoryCodedObservation',
					'PHVS_ModifierOrQualifier_CDC',
					'Specimen_activities',
					'Specimen_role',
					'Body_site_value_set' 
			);
			
			$labResultArr = array ();
			$tempArr = array ();
			$this->Patient->unbindModel ( array (
					'hasMany' => array (
							'PharmacySalesBill',
							'InventoryPharmacySalesReturn' 
					) 
			) );
			$this->Patient->bindModel ( array (
					'hasOne' => array (
							'Person' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Person.patient_uid=Patient.patient_id' 
									) 
							),
							'LaboratoryTestOrder' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryTestOrder.patient_id=Patient.id' 
									) 
							),
							'Laboratory' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryTestOrder.laboratory_id=Laboratory.id' 
									) 
							) 
					) 
			), false );
			
			$patientData = $this->Patient->find ( 'first', array (
					'fields' => array (
							'Patient.id',
							'Patient.doctor_id',
							'Patient.lookup_name',
							'Patient.patient_id',
							'Person.patient_uid',
							'Person.first_name',
							'Person.last_name',
							'Person.sex',
							'Person.dob',
							'Person.race',
							'LaboratoryTestOrder.*',
							'Laboratory.name',
							'Laboratory.lonic_code' 
					),
					'conditions' => array (
							'Patient.id' => $patient_id,
							'LaboratoryTestOrder.id' => $testid 
					) 
			) );
			$this->set ( 'patientData', $patientData );
			$doctorData = $this->User->find ( 'first', array (
					'fields' => array (
							'User.id',
							'User.first_name',
							'User.last_name' 
					),
					'conditions' => array (
							'User.id' => $patientData ['Patient'] ['doctor_id'] 
					) 
			) );
			$this->set ( 'doctorData', $doctorData );
			/*
			 * $LabName = $this->Laboratory->find('first',array('fields'=>array('Laboratory.name','Laboratory.lonic_code'),'conditions'=>array('Laboratory.id'=>$patientData['LaboratoryTestOrder']['laboratory_id'])));
			 * $this->set('LabName',$LabName);
			 */
			$Race = $this->Race->find ( 'list', array (
					'fields' => array (
							'value_code',
							'race_name' 
					) 
			) );
			$this->set ( 'race', $Race );
			
			$speciemtActionCode0065 = $this->SpecimenActionCode0065->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					) 
			) );
			$resultStatus0123 = $this->ResultStatus0123->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			// debug($resultStatus0123);exit;
			// $specimenTypeSnomedSct= $this->SnomedSctHl7->find('list',array('fields' => array('code','display_name'),'order'=>array('display_name ASC')));
			$units_option = $this->Hl7Unit->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$ucums_option = $this->Ucums->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$initial_option = $this->Initial->find ( 'list', array (
					'fields' => array (
							'name' 
					) 
			) );
			$nameType_option = $this->NameType->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$obsMethod_option = $this->Hl7ObservationMethod->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$identifier_type_option = $this->Hl7IdentifierType->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$address_type_option = $this->Hl7_0190_address_types->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$tele_code_option = $this->Hl7_0201_phvs_telecommunications->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$tele_equip_type_option = $this->hl7_0202_telecommunication_equipment_types->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$hl7_coded_observation_option = $this->Hl7LaboratoryCodedObservation->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$hl7PatientClass = $this->Hl70004PatientClass->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$hl7AdmissionType = $this->Hl7AdmissionType->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$specimenRejectReason = $this->SpecimenRejectReason0490->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$specimenConditionReason = $this->SpecimenCondition0493->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$abnormalFlag = $this->ObservationInterpretation0078->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$labResultStatus = $this->ObservationResultStatus0085->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$loincCode = $this->LoincLnHl7->find ( 'list', array (
					'fields' => array (
							'code',
							'display_name' 
					),
					'order' => array (
							'display_name ASC' 
					) 
			) );
			$state_options = $this->State->find ( 'list', array (
					'fields' => array (
							'state_code',
							'name' 
					),
					'conditions' => array (
							'State.country_id' => "2" 
					),
					'order' => array (
							'State.name' 
					) 
			) );
			$sp_type_modifier_options = $this->PHVS_ModifierOrQualifier_CDC->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			// $specimen_activities_options = $this->Specimen_activities->find('list',array('fields' => array('value_code','description'),'order'=>array('description ASC')));
			$specimen_role_options = $this->Specimen_role->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			$body_site_options = $this->Body_site_value_set->find ( 'list', array (
					'fields' => array (
							'value_code',
							'description' 
					),
					'order' => array (
							'description ASC' 
					) 
			) );
			
			/*
			 * $this->LabManager->bindModel(array(
			 * 'belongsTo' => array(
			 * 'Laboratory'=>array('foreignKey'=>'laboratory_id','conditions'=>array('Laboratory.is_active'=>1))
			 * ),
			 * 'hasOne' => array( 'LaboratoryResult'=>array('foreignKey'=>'laboratory_test_order_id') ,
			 * 'LaboratoryToken'=>array('foreignKey'=>'laboratory_test_order_id')
			 * )),false);
			 *
			 * $this->paginate = array(
			 * 'limit' => Configure::read('number_of_rows'),
			 * 'fields'=>array('LaboratoryResult.result_publish_date','LaboratoryResult.confirm_result','LabManager.id','LabManager.create_time',
			 * 'LabManager.patient_id','LabManager.order_id','Laboratory.id','Laboratory.name','LaboratoryToken.ac_id','LaboratoryToken.sp_id'),
			 * 'conditions'=>array('LabManager.patient_id'=>$patient_id,'LabManager.is_deleted'=>0),
			 * 'order' => array(
			 * 'LabManager.id' => 'asc'
			 * ),
			 * 'group'=>'LabManager.id'
			 * );
			 * $testOrdered = $this->paginate('LabManager');
			 *
			 * $this->set(array('testOrdered'=>$testOrdered));
			 */
			
			$this->set ( array (
					'speciemtActionCode0065' => $speciemtActionCode0065,
					'resultStatus0123' => $resultStatus0123,
					'specimenTypeSnomedSct' => $specimenTypeSnomedSct,
					'specimenRejectReason' => $specimenRejectReason,
					'specimenConditionReason' => $specimenConditionReason,
					'abnormalFlag' => $abnormalFlag,
					'labResultStatus' => $labResultStatus,
					'loincCode' => $loincCode,
					'units_option' => $units_option,
					'ucums_option' => $ucums_option,
					'state_options' => $state_options,
					'initial_option' => $initial_option,
					'nameType_option' => $nameType_option,
					'obsMethod_option' => $obsMethod_option,
					'identifier_type_option' => $identifier_type_option,
					'address_type_option' => $address_type_option,
					'tele_code_option' => $tele_code_option,
					'tele_equip_type_option' => $tele_equip_type_option,
					'hl7_coded_observation_option' => $hl7_coded_observation_option,
					'sp_type_modifier_options' => $sp_type_modifier_options,
					'specimen_activities_options' => $specimen_activities_options,
					'specimen_role_options' => $specimen_role_options,
					'body_site_options' => $body_site_options,
					'hl7PatientClass' => $hl7PatientClass,
					'hl7AdmissionType' => $hl7AdmissionType 
			) );
			
			if (! empty ( $this->request->data )) {
				for($cnt = 0; $cnt <= $this->request->data ['0'] ['labHl7Result'] ['resultcount']; $cnt ++) {
					$this->request->data [$cnt] ['labHl7Result'] ['modify_time'] = date ( "Y-m-d H:i:s" );
					$this->request->data [$cnt] ['labHl7Result'] ['create_time'] = date ( "Y-m-d H:i:s" );
					$this->request->data [$cnt] ['labHl7Result'] ['patient_id'] = $patient_id;
					$this->request->data [$cnt] ['labHl7Result'] ['modified_by'] = $this->Session->read ( 'userid' );
					$this->request->data [$cnt] ['labHl7Result'] ['laboratory_test_order_id'] = $testid;
					$this->request->data [$cnt] ['labHl7Result'] ['confirm_result'] = '1';
					$this->request->data [$cnt] ['labHl7Result'] ['laboratory_id'] = $patientData [0] ['LaboratoryTestOrder'] ['laboratory_id'];
					// debug($this->request->data[$cnt]['labHl7Result']);exit;
					if ($this->LaboratoryResult->save ( $this->request->data [$cnt] ['labHl7Result'] )) {
						for($i = 0; $i < $this->request->data [$cnt] ['labHl7Result'] ['labcount']; $i ++) {
							$tempArr ['result'] = $this->request->data [$cnt] ['labHl7Result'] ['result_' . $i];
							if (! empty ( $this->request->data [$cnt] ['labHl7Result'] ['sn_result_' . $i] )) {
								$tempArr ['result'] = $this->request->data [$cnt] ['labHl7Result'] ['sn_result_' . $i];
							}
							$tempArr ['id'] = $this->request->data [$cnt] ['labHl7Result'] ['id_' . $i];
							$tempArr ['observations'] = $this->request->data [$cnt] ['labHl7Result'] ['observation_' . $i];
							$tempArr ['unit'] = $this->request->data [$cnt] ['labHl7Result'] ['unit_' . $i];
							$tempArr ['uom'] = $this->request->data [$cnt] ['labHl7Result'] ['uom_' . $i];
							$tempArr ['range'] = $this->request->data [$cnt] ['labHl7Result'] ['range_' . $i];
							$tempArr ['abnormal_flag'] = $this->request->data [$cnt] ['labHl7Result'] ['abnormal_flag_' . $i];
							$tempArr ['status'] = $this->request->data [$cnt] ['labHl7Result'] ['status_' . $i];
							$tempArr ['date_time_of_observation'] = $this->request->data [$cnt] ['labHl7Result'] ['date_time_of_observation_' . $i];
							$tempArr ['notes'] = $this->request->data [$cnt] ['labHl7Result'] ['notes_' . $i];
							$tempArr ['sn_value'] = $this->request->data [$cnt] ['labHl7Result'] ['sn_value_' . $i];
							$tempArr ['observation_method'] = $this->request->data [$cnt] ['labHl7Result'] ['observation_method_' . $i];
							$tempArr ['sn_separator'] = $this->request->data [$cnt] ['labHl7Result'] ['sn_separator_' . $i];
							$tempArr ['sn_result2'] = $this->request->data [$cnt] ['labHl7Result'] ['sn_result2_' . $i];
							$tempArr ['laboratory_result_id'] = $this->LaboratoryResult->id;
							$tempArr ['location_id'] = $this->Session->read ( 'locatioid' );
							$tempArr ['modified_by'] = $this->Session->read ( 'userid' );
							$tempArr ['modify_time'] = date ( "Y-m-d H:i:s" );
							$tempArr ['create_time'] = date ( "Y-m-d H:i:s" );
							$this->LaboratoryHl7Result->id = $tempArr ['id'];
							$this->LaboratoryHl7Result->save ( $tempArr );
							unset ( $tempArr );
							$this->LaboratoryHl7Result->id = '';
						}
					}
				}
				// ----------------------------------------------- HL&7 Result---------------------------------------------
				$this->LaboratoryResult->bindModel ( array (
						'hasMany' => array (
								'LaboratoryHl7Result' => array (
										'foreignKey' => 'laboratory_result_id' 
								) 
						) 
				) );
				// LaboratoryHl7Result
				$model = ClassRegistry::init ( 'Hl7Result' );
				$modelMes = ClassRegistry::init ( 'Hl7Message' );
				$get_lab_result = $this->LaboratoryResult->find ( 'all', array (
						'conditions' => array (
								'LaboratoryResult.laboratory_test_order_id' => $testid,
								'patient_id' => $patient_id 
						) 
				) );
				$msg = $model->genrateHL7ELR ( $get_lab_result, $this->request->data ['labHl7Result'] );
				// $modelMes->saveAll(array('message'=>$msg,'message_from'=>'LAB_RESULT_EDIT_ELR','create_time' => date('Y-m-d H:i:s'),'patient_id'=>$patientData['Person']['patient_uid']));
				$modelMes->saveAll ( array (
						'subject' => 'Submission of Reportable Lab Results',
						'message_to' => "Registry",
						'patient_name' => $patientData ['Patient'] ['lookup_name'],
						'message' => $msg,
						'message_from' => 'LAB_RESULT_EDIT_ELR',
						'create_time' => date ( 'Y-m-d H:i:s' ),
						'patient_id' => $patientData ['Patient'] ['patient_id'] 
				) );
				$this->Session->setFlash ( __ ( 'Lab Result Saved successfully', true ), 'default', array (
						'class' => 'message' 
				) );
				$this->redirect ( array (
						'controller' => 'laboratories',
						'action' => 'viewLabHl7Result',
						$patient_id,
						$testid 
				) );
				// ==============================================================================================================
			}
			// /------------------Edit Form
			$this->LaboratoryResult->bindModel ( array (
					'hasMany' => array (
							'LaboratoryHl7Result' => array (
									'foreignKey' => 'laboratory_result_id' 
							) 
					),
					'hasOne' => array (
							'siType' => array (
									'className' => 'SnomedSctHl7',
									'foreignKey' => false,
									'conditions' => array (
											'siType.code=LaboratoryResult.si_specimen_type' 
									) 
							),
							'specimenColMethod' => array (
									'className' => 'SnomedSctHl7',
									'foreignKey' => false,
									'conditions' => array (
											'specimenColMethod.code=LaboratoryResult.si_specimen_col_method' 
									) 
							),
							'Specimen_activities' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Specimen_activities.value_code=LaboratoryResult.si_specimen_type_activities' 
									) 
							),
							'Ucums' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Ucums.code=LaboratoryResult.si_specimen_col_amount' 
									) 
							) 
					) 
			) );
			$get_lab_result = $this->LaboratoryResult->find ( 'all', array (
					'conditions' => array (
							'laboratory_test_order_id' => $testid,
							'patient_id' => $patient_id 
					),
					'order' => array (
							'LaboratoryResult.id Asc' 
					) 
			) );
			$this->Patient->unbindModel ( array (
					'hasOne' => array (
							'Person' 
					) 
			), false );
			$this->patient_info ( $patient_id );
			$this->set ( 'get_lab_result', $get_lab_result );
			// ---------------------------
		}
		public function labOrderReceived() {
			$this->uses = array (
					'OutsideLabOrder' 
			);
			$this->paginate = array (
					'limit' => Configure::read ( 'number_of_rows' ),
					'order' => array (
							'Laboratory.name' => 'desc' 
					) 
			);
			$data = $this->paginate ( 'OutsideLabOrder' );
			$this->set ( 'data', $data );
		}
		public function createOutsideLabOrder() {
			$this->uses = array (
					'OutsideLabOrder',
					'Laboratory',
					'Patient',
					'LaboratoryTestOrder',
					'LaboratoryToken' 
			);
			$labTest = $this->Laboratory->find ( 'list' );
			asort ( $labTest );
			$this->set ( array (
					'labTest' => $labTest 
			) );
			if ($this->request->data) {
				$this->request->data ['OutsideLabOrder'] ['dob'] = $this->DateFormat->formatDate2STD ( $this->request->data ['OutsideLabOrder'] ['dob'], Configure::read ( 'date_format_us' ) );
				$dob = explode ( " ", $this->request->data ['OutsideLabOrder'] ['dob'] );
				$this->request->data ['OutsideLabOrder'] ['dob'] = $dob [0];
				$this->request->data ['OutsideLabOrder'] ['create_time'] = date ( "Y-m-d H:i:s" );
				$this->request->data ['OutsideLabOrder'] ['created_by'] = $this->Session->read ( 'userid' );
				$this->request->data ['OutsideLabOrder'] ['date_of_requisition'] = $this->DateFormat->formatDate2STD ( $this->request->data ['OutsideLabOrder'] ['date_of_requisition'], Configure::read ( 'date_format_us' ) );
				$this->OutsideLabOrder->save ( $this->request->data );
				
				$this->Patient->unbindModel ( array (
						'hasMany' => array (
								'PharmancySalesBill',
								'InventoryPharmacySalesReturn' 
						) 
				) );
				$patient_id = $this->Patient->find ( 'first', array (
						'fields' => array (
								'id' 
						),
						'conditions' => array (
								'patient_id' => $this->request->data ['OutsideLabOrder'] ['registration_number'] 
						),
						'order' => array (
								'id' => 'Desc' 
						) 
				) );
				
				$testOrder ['LaboratoryTestOrder'] ['patient_id'] = $patient_id ['Patient'] ['id'];
				$testOrder ['LaboratoryTestOrder'] ['order_id'] = $this->LaboratoryTestOrder->autoGeneratedLabID ();
				$testOrder ['LaboratoryTestOrder'] ['laboratory_id'] = $this->request->data ['OutsideLabOrder'] ['laboratory_id'];
				$testOrder ['LaboratoryTestOrder'] ['start_date'] = date ( "Y-m-d" );
				$testOrder ['LaboratoryTestOrder'] ['lab_order_date'] = date ( "Y-m-d" );
				$testOrder ['LaboratoryTestOrder'] ['create_time'] = date ( "Y-m-d H:i:s" );
				$testOrder ['LaboratoryTestOrder'] ['created_by'] = $this->Session->read ( 'userid' );
				$this->LaboratoryTestOrder->save ( $testOrder );
				
				$laboratoryToken ['LaboratoryToken'] ['patient_id'] = $patient_id ['Patient'] ['id'];
				$laboratoryToken ['LaboratoryToken'] ['laboratory_test_order_id'] = $this->LaboratoryTestOrder->getLastInsertID ();
				$laboratoryToken ['LaboratoryToken'] ['laboratory_id'] = $this->request->data ['OutsideLabOrder'] ['laboratory_id'];
				$laboratoryToken ['LaboratoryToken'] ['create_time'] = date ( "Y-m-d H:i:s" );
				$laboratoryToken ['LaboratoryToken'] ['created_by'] = $this->Session->read ( 'userid' );
				$this->LaboratoryToken->save ( $laboratoryToken );
				$this->redirect ( array (
						'controller' => 'laboratories',
						'action' => 'labOrderReceived' 
				) );
			}
		}
		public function labOrderReceivedInbox() {
			$this->uses = array (
					'OutsideLabOrder' 
			);
			$this->paginate = array (
					'limit' => Configure::read ( 'number_of_rows' ),
					'order' => array (
							'Laboratory.name' => 'desc' 
					) 
			);
			$data = $this->paginate ( 'OutsideLabOrder' );
			$this->set ( 'data', $data );
		}
		public function editOutsideLabOrder($id) {
			$this->uses = array (
					'OutsideLabOrder',
					'Laboratory' 
			);
			$labTest = $this->Laboratory->find ( 'list' );
			asort ( $labTest );
			$this->set ( array (
					'labTest' => $labTest 
			) );
			if ($this->request->data) {
				$this->request->data ['OutsideLabOrder'] ['dob'] = $this->DateFormat->formatDate2STD ( $this->request->data ['OutsideLabOrder'] ['dob'], Configure::read ( 'date_format_us' ) );
				$dob = explode ( " ", $this->request->data ['OutsideLabOrder'] ['dob'] );
				$this->request->data ['OutsideLabOrder'] ['dob'] = $dob [0];
				$this->request->data ['OutsideLabOrder'] ['modify_time'] = date ( "Y-m-d H:i:s" );
				$this->request->data ['OutsideLabOrder'] ['created_by'] = $this->Session->read ( 'userid' );
				$this->request->data ['OutsideLabOrder'] ['date_of_requisition'] = $this->DateFormat->formatDate2STD ( $this->request->data ['OutsideLabOrder'] ['date_of_requisition'], Configure::read ( 'date_format_us' ) );
				$this->OutsideLabOrder->id = $this->request->data ['OutsideLabOrder'] ['id'];
				$this->OutsideLabOrder->save ( $this->request->data );
				$this->redirect ( array (
						'controller' => 'laboratories',
						'action' => 'labOrderReceived' 
				) );
				// echo '<pre>';print_r($this->request->data);exit;
			}
			$data = $this->OutsideLabOrder->read ( null, $id ); // echo '<pre>';print_r($data);exit;
			$this->data = $data;
		}
		public function getLastMessageId() {
			// $this->uses = array('Hl7Message');
			$count = $this->LaboratoryResult->find ( 'count' );
			return $count;
		}
		public function laboratories_management() {
			$this->uses = array (
					'Patient',
					'LabManager',
					'LaboratoryToken' 
			);
			$this->set ( 'data', '' );
			$this->paginate = array (
					'limit' => Configure::read ( 'number_of_rows' ),
					'order' => array (
							'Patient.id' => 'asc' 
					) 
			);
			
			$role = $this->Session->read ( 'role' );
			$search_key ['Patient.is_deleted'] = 0;
			
			$search_key ['Laboratory.location_id'] = $this->Session->read ( 'locationid' );
			$search_key ['LabManager.is_deleted'] = 0;
			$this->Patient->bindModel ( array (
					'belongsTo' => array (
							'User' => array (
									'foreignKey' => false,
									'conditions' => array (
											'User.id=Patient.doctor_id' 
									) 
							) 
					) 
			), false );
			// }
			
			$this->LabManager->bindModel ( array (
					'belongsTo' => array (
							'Laboratory' => array (
									'foreignKey' => 'laboratory_id',
									'conditions' => array (
											'Laboratory.is_active' => 1 
									) 
							),
							'Patient' => array (
									'foreignKey' => 'patient_id' 
							),
							'Person' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Person.id=Patient.person_id' 
									) 
							),
							'PatientInitial' => array (
									'foreignKey' => false,
									'conditions' => array (
											'PatientInitial.id =Person.initial_id' 
									) 
							),
							'User' => array (
									'foreignKey' => false,
									'conditions' => array (
											'User.id=Patient.doctor_id' 
									) 
							) 
					) 
			), false );
			$this->LabManager->bindModel ( array (
					'hasOne' => array (
							'LaboratoryToken' => array (
									'foreignKey' => 'laboratory_test_order_id' 
							) 
					) 
			), false );
			$this->LabManager->bindModel ( array (
					'hasOne' => array (
							'Initial' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Initial.id=User.initial_id' 
									) 
							) 
					) 
			), false );
			$this->LabManager->bindModel ( array (
					'hasOne' => array (
							'LaboratoryResult' => array (
									'foreignKey' => 'laboratory_test_order_id' 
							),
							'LaboratoryToken' => array (
									'foreignKey' => 'laboratory_test_order_id' 
							) 
					) 
			), false );
			if (! empty ( $this->params->query )) {
				$search_ele = $this->params->query; // make it get
				
				if (! empty ( $search_ele ['lab_test_name'] )) {
					$search_key ['Laboratory.name'] = $search_ele ['lab_test_name'];
				}
				if (! empty ( $search_ele ['radiology_test_name'] )) {
				}
				if (! empty ( $search_ele ['histology_test_name'] )) {
				}
				
				if (! empty ( $search_ele ['lookup_name'] )) {
					$search_key ['Patient.lookup_name like '] = "%" . trim ( $search_ele ['lookup_name'] ) . "%";
				}
				if (! empty ( $search_ele ['patient_id'] )) {
					$search_key ['Patient.patient_id like '] = "%" . trim ( $search_ele ['patient_id'] );
				}
				if (! empty ( $search_ele ['admission_id'] )) {
					$search_key ['Patient.admission_id like '] = "%" . trim ( $search_ele ['admission_id'] );
				}
				
				if (! empty ( $search_ele ['from'] ) && ! empty ( $search_ele ['to'] )) {
					
					$formDate = $this->DateFormat->formatDate2STD ( $search_ele ['from'], Configure::read ( 'date_format' ) );
					$toDate = $this->DateFormat->formatDate2STD ( $search_ele ['to'], Configure::read ( 'date_format' ) );
					// $search_key['LabManager.create_time BETWEEN ? AND ? '] = array(trim($formDate),trim($toDate)) ;
					
					// get record between two dates. Make condition
					$search_key ['LabManager.start_date <='] = $toDate;
					$search_key ['LabManager.start_date >='] = $formDate;
				} else if (! empty ( $search_ele ['from'] )) {
					$search_key ['LabManager.start_date > '] = "%" . trim ( $search_ele ['from'] );
				}
				
				$this->paginate = array (
						'limit' => Configure::read ( 'number_of_rows' ),
						'order' => array (
								'Patient.id' => 'asc' 
						),
						'fields' => array (
								'Laboratory.name,PatientInitial.name,Patient.lookup_name,LabManager.start_date,LabManager.order_id,LaboratoryToken.ac_id,LaboratoryToken.sp_id,LabManager.id,LabManager.create_time,
							Patient.id,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time, Initial.name' 
						),
						'conditions' => $search_key 
				);
				// 'group'=>array('Patient.id')
				
				
				$this->set ( 'data', $this->paginate ( 'LabManager' ) );
			} else {
				// $search_key['LabManager.create_time like'] = date("Y-m-d")."%";
				
				// BOF New code
				$this->paginate = array (
						'limit' => Configure::read ( 'number_of_rows' ),
						'order' => array (
								'Patient.id' => 'asc' 
						),
						'fields' => array (
								'LaboratoryResult.result_publish_date',
								'LaboratoryResult.confirm_result',
								'LaboratoryResult.is_whatsapp_sent',
								'LabManager.patient_id',
								'LabManager.id',
								'Laboratory.name,PatientInitial.name,Patient.lookup_name,LabManager.order_id,LabManager.id,LabManager.start_date,LaboratoryToken.ac_id,LaboratoryToken.sp_id,LaboratoryToken.patient_id,
							Patient.id,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time, Initial.name' 
						),
						'conditions' => $search_key 
				);
				// 'group'=>array('Patient.id')
				
				
				$this->set ( 'data', $this->paginate ( 'LabManager' ) );
				// EOF new code
			}
		}
		function lab_manager_test_order_dashboard($testid = null, $patient_id = null) {
			$layout = 'ajax';
			$this->layout = false;
			$this->uses = array (
					'Patient',
					'LaboratoryTestOrder',
					'LaboratoryToken' 
			);
			
			// save data
			if (! empty ( $this->request->data )) {
				if ($this->LaboratoryToken->insertToken ( $this->request->data )) {
					
					$this->Session->setFlash ( __ ( 'Record added successfully' ), true, array (
							'class' => 'message' 
					) );
					// $this->redirect(array("controller" => "Laboratories", "action" => "laboratories_management"));
					// echo "<script> parent.lab_manager_test_order_dashboard.reload();parent.$.fancybox.close();</script>" ;
				} else {
					$this->Session->setFlash ( __ ( 'There is some problem while saving data,Please try again' ), true, array (
							'class' => 'error' 
					) );
					$this->redirect ( $this->referer () );
				}
			}
			
			$this->LaboratoryTestOrder->bindModel ( array (
					'belongsTo' => array (
							'Laboratory' => array (
									'foreignKey' => 'laboratory_id' 
							),
							'Patient' => array (
									'foreignKey' => 'patient_id' 
							),
							'LaboratoryToken' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryToken.laboratory_test_order_id= LaboratoryTestOrder.id' 
									) 
							) 
					) 
			), false );
			$data = $this->LaboratoryTestOrder->find ( 'all', array (
					'fields' => array (
							'LaboratoryTestOrder.id',
							'LaboratoryToken.id',
							'LaboratoryToken.laboratory_test_order_id',
							'LaboratoryToken.sp_id',
							'LaboratoryToken.ac_id',
							'LaboratoryToken.collected_date',
							'Patient.id',
							'Patient.lookup_name',
							'Patient.admission_id',
							'Patient.patient_id',
							'Laboratory.id',
							'Laboratory.name' 
					),
					'conditions' => array (
							'LaboratoryTestOrder.id' => $testid,
							'LaboratoryTestOrder.is_deleted' => 0 
					) 
			) );
			$patient = $this->Patient->find ( 'first', array (
					'fields' => array (
							'form_received_on' 
					),
					'conditions' => array (
							'Patient.id' => $patient_id 
					) 
			) );
			
			$this->set ( array (
					'data' => $data,
					'patient_id' => $patient_id,
					'patient' => $patient 
			) );
		}
		public function labTestHl7ListDateTime($startDate = null, $endDate = null) {
			echo " hi";
			$this->autoRender = false;
		}
		public function getSubLabPanelData($labId = null, $key = null) {
			$this->layout = false;
			$labName = $this->request->data ['labName_' . $key];
			$this->uses = array (
					'PanelMapping' 
			);
			$this->PanelMapping->bindModel ( array (
					'belongsTo' => array (
							'Laboratory' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Laboratory.id=PanelMapping.underpanellab_id' 
									) 
							),
							'LaboratoryHl7Result' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryHl7Result.laboratory_id=Laboratory.id' 
									) 
							) 
					) 
			), false );
			$getsubData = $this->PanelMapping->find ( 'all', array (
					'fields' => array (
							'Laboratory.name',
							'Laboratory.lonic_code',
							'PanelMapping.underpanellab_id',
							'LaboratoryHl7Result.*' 
					),
					'conditions' => array (
							'PanelMapping.laboratory_id' => $labId 
					) 
			) );
			$this->set ( 'getsubData', $getsubData );
			$this->set ( 'labName', $labName );
			echo $this->render ( 'get_sub_lab_panel_data' );
			exit ();
		}
		// EOF
		function lab_manager() {
			$this->uses = array (
					'Patient',
					'LabManager',
					'LaboratoryToken' 
			);
			$this->set ( 'data', '' );
			$this->paginate = array (
					'limit' => Configure::read ( 'number_of_rows' ),
					'order' => array (
							'Patient.id' => 'asc' 
					) 
			);
			
			$role = $this->Session->read ( 'role' );
			$search_key ['Patient.is_deleted'] = 0;
			// $search_key['Patient.is_discharge'] = 0;
			$search_key ['LabManager.location_id'] = $this->Session->read ( 'locationid' );
			$search_key ['LabManager.is_deleted'] = 0;
			$this->Patient->bindModel ( array (
					'belongsTo' => array (
							'User' => array (
									'foreignKey' => false,
									'conditions' => array (
											'User.id=Patient.doctor_id' 
									) 
							) 
					) 
			), false );
			$this->LabManager->bindModel ( array (
					'belongsTo' => array (
							'Laboratory' => array (
									'foreignKey' => 'laboratory_id',
									'conditions' => array (
											'Laboratory.is_active' => 1 
									) 
							),
							'Patient' => array (
									'foreignKey' => 'patient_id' 
							),
							'Person' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Person.id=Patient.person_id' 
									) 
							),
							'PatientInitial' => array (
									'foreignKey' => false,
									'conditions' => array (
											'PatientInitial.id =Person.initial_id' 
									) 
							),
							'Department' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Department.id =Patient.department_id' 
									) 
							),
							'User' => array (
									'foreignKey' => false,
									'conditions' => array (
											'User.id=Patient.doctor_id' 
									) 
							) 
					) 
			), false );
			$this->LabManager->bindModel ( array (
					'hasOne' => array (
							'LaboratoryToken' => array (
									'foreignKey' => 'laboratory_test_order_id' 
							) 
					) 
			), false );
			$this->LabManager->bindModel ( array (
					'hasOne' => array (
							'Initial' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Initial.id=User.initial_id' 
									) 
							) 
					) 
			), false );
			if (! empty ( $this->params->query )) {
				$search_ele = $this->params->query; // make it get
				
				if (! empty ( $search_ele ['lab_test_name'] )) {
					$search_key ['Laboratory.name'] = $search_ele ['lab_test_name'];
				}
				if (! empty ( $search_ele ['radiology_test_name'] )) {
				}
				if (! empty ( $search_ele ['histology_test_name'] )) {
				}
				
				$search_ele ['lookup_name'] = explode ( " ", $search_ele ['lookup_name'] );
				if (count ( $search_ele ['lookup_name'] ) > 1) {
					$search_key ['SOUNDEX(Person.first_name) like'] = "%" . soundex ( trim ( $search_ele ['lookup_name'] [0] ) ) . "%";
					$search_key ['SOUNDEX(Person.last_name) like'] = "%" . soundex ( trim ( $search_ele ['lookup_name'] [1] ) ) . "%";
				} else if (count ( $search_ele ['lookup_name)'] ) == 0) {
					$search_key ['OR'] = array (
							'SOUNDEX(Person.first_name)  like' => "%" . soundex ( trim ( $search_ele ['lookup_name'] [0] ) ) . "%",
							'SOUNDEX(Person.last_name)   like' => "%" . soundex ( trim ( $search_ele ['lookup_name'] [0] ) ) . "%" 
					);
				}
				if (! empty ( $search_ele ['patient_id'] )) {
					$search_key ['Patient.patient_id like '] = "%" . trim ( $search_ele ['patient_id'] );
				}
				if (! empty ( $search_ele ['admission_id'] )) {
					$search_key ['Patient.admission_id like '] = "%" . trim ( $search_ele ['admission_id'] );
				}
				if (! empty ( $search_ele ['dob'] )) {
					$search_key ['Person.dob like '] = "%" . trim ( substr ( $this->DateFormat->formatDate2STD ( $search_ele ['dob'], Configure::read ( 'date_format' ) ), 0, 10 ) );
				}
				if (! empty ( $search_ele ['ssn_us'] )) {
					$search_key ['Person.ssn_us like '] = "%" . trim ( $search_ele ['ssn_us'] ) . "%";
				}
				
				if (! empty ( $search_ele ['from'] ) && ! empty ( $search_ele ['to'] )) {
					
					$formDate = $this->DateFormat->formatDate2STD ( $search_ele ['from'], Configure::read ( 'date_format' ) );
					$toDate = $this->DateFormat->formatDate2STD ( $search_ele ['to'], Configure::read ( 'date_format' ) );
					// $search_key['LabManager.create_time BETWEEN ? AND ? '] = array(trim($formDate),trim($toDate)) ;
					
					// get record between two dates. Make condition
					$search_key ['LabManager.start_date <='] = $toDate;
					$search_key ['LabManager.start_date >='] = $formDate;
				} else if (! empty ( $search_ele ['from'] )) {
					$search_key ['LabManager.start_date > '] = "%" . trim ( $search_ele ['from'] );
				}
				$this->paginate = array (
						'limit' => Configure::read ( 'number_of_rows' ),
						'order' => array (
								'Patient.id' => 'desc' 
						),
						'fields' => array (
								'Laboratory.name,PatientInitial.name,Patient.lookup_name,LabManager.start_date,LabManager.order_id,LaboratoryToken.ac_id,LaboratoryToken.sp_id,LabManager.id,LabManager.create_time,
							Patient.id,Patient.sex,Patient.patient_id,Department.name,Patient.admission_id,Person.ssn_us,Person.dob,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time, Initial.name' 
						),
						'conditions' => $search_key,
						'group' => array (
								'Patient.id' 
						) 
				);
				$this->set ( 'data', $this->paginate ( 'LabManager' ) );
			} else {
				// $search_key['LabManager.create_time like'] = date("Y-m-d")."%";
				// BOF New code
				$this->paginate = array (
						'limit' => Configure::read ( 'number_of_rows' ),
						'order' => array (
								'Patient.id' => 'desc' 
						),
						'fields' => array (
								'Laboratory.name,PatientInitial.name,Patient.lookup_name,LabManager.order_id,LabManager.id,LabManager.start_date,LaboratoryToken.ac_id,LaboratoryToken.sp_id,
							Patient.id,Patient.sex,Patient.patient_id,Patient.admission_id,Department.name,Person.ssn_us,Person.dob,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time, Initial.name' 
						),
						'conditions' => $search_key,
						'group' => array (
								'Patient.id' 
						) 
				);
				
				$this->set ( 'data', $this->paginate ( 'LabManager' ) );
				// EOF new code
			}
		}
		public function labDashBoard() {
			$this->uses = array (
					'Person',
					'Patient',
					'Consultant',
					'User',
					'LabManager',
					'LaboratoryResult',
					'TariffStandard',
					'RadiologyTestOrder',
					'RadiologyReport',
					'RadiologyResult',
					'Radiology',
					'ServiceCategory',
					'Billing',
					'ServiceCategory' 
			);
			// $this->autoRender = false ;
			$this->layout = 'advance';
			$this->Patient->bindModel ( array (
					'belongsTo' => array (
							'User' => array (
									'foreignKey' => false,
									'conditions' => array (
											'User.id=Patient.doctor_id' 
									) 
							) 
					) 
			), false );
			
			// Payment category Id Of "laboratory" -- Pooja
			$this->ServiceCategory->unbindModel ( array (
					'hasMany' => array (
							'ServiceSubCategory' 
					) 
			) );
			$paymentCategoryId = $this->ServiceCategory->find ( 'first', array (
					'fields' => array (
							'id' 
					),
					'conditions' => array (
							'ServiceCategory.name Like' => Configure::read ( 'laboratoryservices' ) 
					) 
			) );
			
			// tariff List "Private" Id--Pooja
			$privateID = $this->TariffStandard->getPrivateTariffID (); // retrive private ID
			$this->set ( 'privateId', $privateID );
			
			$this->LabManager->bindModel ( array (
					'belongsTo' => array (
							'Laboratory' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Laboratory.id=LabManager.laboratory_id',
											'Laboratory.is_active=1' 
									) 
							),
							'Patient' => array (
									'type' => 'right',
									'foreignKey' => false,
									'conditions' => array (
											'Patient.id = LabManager.patient_id' 
									) 
							),
							'Person' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Person.id=Patient.person_id' 
									) 
							),
							'Billing' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Patient.id=Billing.patient_id',
											'Billing.payment_category' => $paymentCategoryId ['ServiceCategory'] ['id'] 
									) 
							),
							'PatientInitial' => array (
									'foreignKey' => false,
									'conditions' => array (
											'PatientInitial.id =Person.initial_id' 
									) 
							),
							'User' => array (
									'foreignKey' => false,
									'conditions' => array (
											'User.id=Patient.doctor_id' 
									) 
							) 
					) 
			)
			// 'Billing'=>array('foreignKey'=>false,'conditions'=>array('Billing.patient_id=LabManager.patient_id','Billing.payment_category'=>'2')),
			// 'ServiceCategory'=>array('foreignKey'=>false,'conditions'=>array('ServiceCategory.id=Billing.payment_category')),
			
			, false );
			
			$this->LabManager->bindModel ( array (
					'hasOne' => array (
							'Initial' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Initial.id=User.initial_id' 
									) 
							) 
					) 
			), false );
			
			if (isset ( $this->request->data ) && ! empty ( $this->request->data )) {
				// $this-> layout = "ajax";
				
				if ($this->request->data ['from'])
					$startDate = explode ( " ", $this->DateFormat->formatDate2STDForReport ( $this->request->data ['from'], Configure::read ( 'date_format' ) ) );
				
				if ($this->request->data ['to'])
					$endDate = explode ( " ", $this->DateFormat->formatDate2STDForReport ( $this->request->data ['to'], Configure::read ( 'date_format' ) ) );
				
				if (! (trim ( $this->request->data ['to'] ))) { // if end date is empty
					$endDate = $startDate;
				}
				$condition = array (); // for patient name
				$patientName = array ();
				$patientAdmission_id = array ();
				
				if (! empty ( $this->request->data ['lookup_name'] )) {
					$patientName = array (
							'Patient.lookup_name LIKE' => $this->request->data ['lookup_name'] . "%" 
					);
				}
				if (! empty ( $this->request->data ['admission_id'] )) {
					$patientAdmission_id = array (
							'Patient.admission_id' => trim ( $this->request->data ['admission_id'] ) 
					);
				}
				// EOF patient name search
				
				if (! empty ( $startDate [0] ) || ! empty ( $endDate [0] )) {
					// $condition = array_merge($patientName,array('LabManager.start_date BETWEEN ? AND ?' => array($startDate[0]." 00:00:00",$endDate[0]." 23:59:59"))) ;
					$condition = array_merge ( $patientName, array (
							'Patient.form_received_on BETWEEN ? AND ?' => array (
									$startDate [0] . " 00:00:00",
									$endDate [0] . " 23:59:59" 
							) 
					) );
				}
				if (! empty ( $patientAdmission_id )) {
					$condition = $patientAdmission_id;
				}
				if (! empty ( $patientName )) {
					$condition = $patientName;
				}
				if (! empty ( $patientName ) && ! empty ( $patientAdmission_id )) {
					$condition = array_merge ( $patientName, $patientAdmission_id );
				}
				// if(empty($condition)) $condition = array('Patient.form_received_on Like'=>date('Y-m-d')."%" );
				
				if (empty ( $condition )) // $condition = //array();
					$condition = array (
							'Laboratory.name NOT' => '',
							'LabManager.start_date NOT' => '',
							'LabManager.order_id NOT' => NULL,
							'OR' => array (
									'Patient.admission_type' => "Lab",
									'LabManager.start_date Like' => date ( 'Y-m-d' ) . "%",
									'AND' => array (
											'Billing.total_amount' => NULL,
											'Person.vip_chk' => '1' 
									),
									'AND' => array (
											'Billing.total_amount NOT' => NULL,
											'Person.vip_chk' => '0' 
									) 
							) 
					);
				
				if ($_SESSION ['role'] == Configure::read ( 'doctorLabel' )) {
					
					$this->paginate = array (
							'limit' => 6,
							'order' => array (
									'Patient.id' => 'desc' 
							),
							'fields' => array (
									'Laboratory.name,LabManager.start_date,sum(LabManager.amount) as totalAmount,Patient.form_received_on,Patient.lookup_name,Patient.admission_id,LabManager.order_id,LabManager.id,
							LabManager.labDash_date,LabManager.labDash_status,LabManager.showEdit,Patient.sex ,Billing.amount,Billing.total_amount,Person.vip_chk,Patient.tariff_standard_id,
							Person.dob,Patient.id,Patient.patient_id,Patient.admission_id,CONCAT(User.first_name," ",User.last_name) as name' 
							),
							'conditions' => $condition,
							'group' => array (
									'Patient.id' 
							) 
					);
					$testOrdered = $this->paginate ( 'LabManager' );
					foreach ( $testOrdered as $key => $listPatientId ) {
						$patientIdAry [] = $listPatientId ['Patient'] ['id'];
					}
					$billingData = $this->Billing->find ( 'all', array (
							'fields' => array (
									'Billing.id',
									'Billing.amount',
									'patient_id',
									'sum(Billing.amount) as paidAmount' 
							),
							'conditions' => array (
									'Billing.payment_category' => '2',
									'patient_id' => $patientIdAry 
							),
							'order' => 'id ASC',
							'group' => 'patient_id' 
					) );
					foreach ( $billingData as $billingAmt ) {
						$billing [$billingAmt ['Billing'] ['patient_id']] = $billingAmt ['0'];
					}
					
					$this->set ( array (
							'testOrdered' => $testOrdered,
							'billingData' => $billing 
					) );
					// $this->render('lab_dash_board');
				} else {
					
					$this->paginate = array (
							'limit' => 6,
							'order' => array (
									'Patient.id' => 'desc' 
							),
							'fields' => array (
									'Laboratory.name,LabManager.start_date,sum(LabManager.amount) as totalAmount,Patient.form_received_on,Patient.lookup_name,Patient.admission_id,LabManager.order_id,LabManager.id,
							LabManager.labDash_date,LabManager.labDash_status,LabManager.showEdit,Patient.sex ,Billing.amount,Billing.total_amount,Person.vip_chk,Patient.tariff_standard_id,
							Person.dob,Patient.id,Patient.patient_id,Patient.admission_id,CONCAT(User.first_name," ",User.last_name) as name' 
							),
							'conditions' => $condition,
							'group' => array (
									'Patient.id' 
							) 
					);
					$testOrdered = $this->paginate ( 'LabManager' );
					foreach ( $testOrdered as $key => $listPatientId ) {
						$patientIdAry [] = $listPatientId ['Patient'] ['id'];
					}
					$billingData = $this->Billing->find ( 'all', array (
							'fields' => array (
									'Billing.id',
									'Billing.amount',
									'patient_id',
									'sum(Billing.amount) as paidAmount' 
							),
							'conditions' => array (
									'Billing.payment_category' => '2',
									'patient_id' => $patientIdAry 
							),
							'order' => 'id ASC',
							'group' => 'patient_id' 
					) );
					foreach ( $billingData as $billingAmt ) {
						$billing [$billingAmt ['Billing'] ['patient_id']] = $billingAmt ['0'];
					}
					$this->set ( array (
							'testOrdered' => $testOrdered,
							'billingData' => $billing 
					) );
					// $this->render('lab_dash_board');
				}
			} else {
				if ($_SESSION ['role'] == Configure::read ( 'doctorLabel' )) {
					$this->paginate = array (
							'limit' => 6,
							'order' => array (
									'Patient.id' => 'desc' 
							),
							'fields' => array (
									'Laboratory.name,LabManager.start_date,sum(LabManager.amount) as totalAmount,Patient.form_received_on,Patient.lookup_name,Patient.admission_id,LabManager.order_id,LabManager.id,
							LabManager.labDash_date,LabManager.labDash_status,LabManager.showEdit,Patient.sex ,Billing.amount,Billing.total_amount,Person.vip_chk,Patient.tariff_standard_id,
							Person.dob,Patient.id,Patient.patient_id,Patient.admission_id,CONCAT(User.first_name," ",User.last_name) as name' 
							),
							'conditions' => array (
									'Laboratory.name NOT' => '',
									'LabManager.start_date NOT' => '',
									'LabManager.order_id NOT' => NULL,
									'OR' => array (
											'Patient.admission_type' => "Lab",
											'LabManager.start_date Like' => date ( 'Y-m-d' ) . "%" 
									) 
							),
							'group' => array (
									'Patient.id' 
							) 
					);
					$testOrdered = $this->paginate ( 'LabManager' );
					foreach ( $testOrdered as $key => $listPatientId ) {
						$patientIdAry [] = $listPatientId ['Patient'] ['id'];
					}
					$billingData = $this->Billing->find ( 'all', array (
							'fields' => array (
									'Billing.id',
									'Billing.amount',
									'patient_id',
									'sum(Billing.amount) as paidAmount' 
							),
							'conditions' => array (
									'Billing.payment_category' => '2',
									'patient_id' => $patientIdAry 
							),
							'order' => 'id ASC',
							'group' => 'patient_id' 
					) );
					
					foreach ( $billingData as $billingAmt ) {
						$billing [$billingAmt ['Billing'] ['patient_id']] = $billingAmt ['0'];
					}
					
					// debug($billingData); exit;
					$this->set ( array (
							'testOrdered' => $testOrdered,
							'billingData' => $billing 
					) );
					// $this->render('lab_dash_board');
				} else {
					$this->paginate = array (
							'limit' => 6,
							'order' => array (
									'Patient.id' => 'desc' 
							),
							'fields' => array (
									'Laboratory.name,LabManager.start_date,sum(LabManager.amount) as totalAmount,Patient.form_received_on,Patient.lookup_name,Patient.admission_id,LabManager.order_id,LabManager.id,
							LabManager.labDash_date,LabManager.labDash_status,LabManager.showEdit,Patient.sex ,Patient.admission_type,LabManager.start_date,Billing.amount,Billing.total_amount,
							Person.vip_chk,Patient.tariff_standard_id,
							Person.dob,Patient.id,Patient.patient_id,Patient.admission_id,CONCAT(User.first_name," ",User.last_name) as name' 
							),
							
							// 'conditions'=> array('OR'=>array('Patient.admission_type' =>"Lab" ,'Patient.id' => 'LabManager.patient_id' )),
							'conditions' => array (
									'Laboratory.name NOT' => NULL,
									'LabManager.start_date NOT' => '',
									'LabManager.order_id NOT' => NULL,
									'OR' => array (
											'Patient.admission_type' => "Lab",
											'LabManager.start_date Like' => date ( 'Y-m-d' ) . "%" 
									) 
							),
							'group' => array (
									'Patient.id' 
							) 
					);
					$testOrdered = $this->paginate ( 'LabManager' ); // debug($testOrdered);//exit;
					foreach ( $testOrdered as $key => $listPatientId ) {
						$patientIdAry [] = $listPatientId ['Patient'] ['id'];
					}
					$billingData = $this->Billing->find ( 'all', array (
							'fields' => array (
									'Billing.id',
									'Billing.amount',
									'patient_id',
									'sum(Billing.amount) as paidAmount' 
							),
							'conditions' => array (
									'Billing.payment_category' => '2',
									'patient_id' => $patientIdAry 
							),
							'order' => 'id ASC',
							'group' => 'patient_id' 
					) );
					foreach ( $billingData as $billingAmt ) {
						$billing [$billingAmt ['Billing'] ['patient_id']] = $billingAmt ['0'];
					}
					$this->set ( array (
							'testOrdered' => $testOrdered,
							'billingData' => $billing 
					) );
					// $this->render('lab_dash_board');
				}
			}
			$this->testOrdered = $this->request->data;
		}
		public function labDashBoardUpdate($labId, $status) {
			$this->uses = array (
					'LaboratoryTestOrder' 
			);
			$labDash_date = $this->DateFormat->formatDate2STD ( $this->request->data ['Laboratory'] ['to'], Configure::read ( 'date_format' ) );
			$checkStatus = $this->LaboratoryTestOrder->updateAll ( array (
					'labDash_status' => "'$status'",
					'labDash_date' => "'$labDash_date'" 
			), array (
					'order_id' => $labId 
			) );
			echo $checkStatus;
			exit ();
		}
		function overdueLabRadTest($patientId, $source) {
			$this->layout = 'advance_ajax';
			$this->uses = array (
					'LaboratoryTestOrder',
					'LaboratoryResult',
					'Laboratory',
					'RadiologyTestOrder',
					'RadiologyResult',
					'Radiology' 
			);
			if (! empty ( $patientId )) {
				$this->patient_info ( $patientId );
				if ($source == 'labOverDue') {
					$this->LaboratoryTestOrder->bindModel ( array (
							'belongsTo' => array (
									'Laboratory' => array (
											'foreignKey' => 'laboratory_id',
											'conditions' => array (
													'Laboratory.is_active' => 1 
											) 
									),
									'LaboratoryResult' => array (
											'foreignKey' => false,
											'conditions' => array (
													'LaboratoryResult.laboratory_test_order_id=LaboratoryTestOrder.id' 
											) 
									) 
							) 
					), false );
					
					$this->paginate = array (
							'limit' => Configure::read ( 'number_of_rows' ),
							'fields' => array (
									'LaboratoryResult.id',
									'Laboratory.name',
									'LaboratoryTestOrder.start_date',
									'LaboratoryTestOrder.order_id',
									'LaboratoryTestOrder.create_time' 
							),
							'conditions' => array (
									'LaboratoryTestOrder.patient_id' => $patientId,
									'LaboratoryTestOrder.is_deleted' => 0 
							),
							'order' => array (
									'LaboratoryTestOrder.id' => 'desc' 
							) 
					);
					$this->set ( array (
							'testOrdered' => $this->paginate ( 'LaboratoryTestOrder' ) 
					) );
				} else {
					$this->RadiologyTestOrder->bindModel ( array (
							'belongsTo' => array (
									'Radiology' => array (
											'foreignKey' => 'radiology_id',
											'conditions' => array (
													'Radiology.is_active' => 1 
											) 
									),
									'RadiologyResult' => array (
											'foreignKey' => false,
											'conditions' => array (
													'RadiologyResult.radiology_test_order_id=RadiologyTestOrder.id' 
											) 
									) 
							) 
					) );
					$this->paginate = array (
							'limit' => Configure::read ( 'number_of_rows' ),
							'fields' => array (
									'RadiologyResult.id',
									'Radiology.name',
									'RadiologyTestOrder.start_date',
									'RadiologyTestOrder.order_id' 
							),
							'conditions' => array (
									'RadiologyTestOrder.patient_id' => $patientId,
									'RadiologyTestOrder.is_deleted' => 0 
							),
							'order' => array (
									'RadiologyTestOrder.id' => 'desc' 
							) 
					);
					$this->set ( array (
							'testOrdered' => $this->paginate ( 'RadiologyTestOrder' ) 
					) );
				}
			}
		}
		function labOverdueTestReport() {
			$this->layout = 'advance';
			$this->uses = array (
					'LaboratoryTestOrder' 
			);
			$this->LaboratoryTestOrder->bindModel ( array (
					'belongsTo' => array (
							'Laboratory' => array (
									'foreignKey' => 'laboratory_id',
									'conditions' => array (
											'Laboratory.is_active' => 1 
									) 
							),
							'LaboratoryResult' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryResult.laboratory_test_order_id=LaboratoryTestOrder.id' 
									) 
							),
							'Patient' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Patient.id=LaboratoryTestOrder.patient_id' 
									) 
							) 
					) 
			), false );
			if (! empty ( $this->request->query )) {
				$fromDate = $this->DateFormat->formatDate2STD ( $this->request->query ['from_date'], Configure::read ( 'date_format' ) );
				$toDate = $this->DateFormat->formatDate2STD ( $this->request->query ['to_date'], Configure::read ( 'date_format' ) );
				$conditions = array (
						'LaboratoryTestOrder.start_date >=' => $fromDate,
						'LaboratoryTestOrder.start_date <=' => $toDate 
				);
				if ($this->request->query ['patient_id']) {
					$conditions ['LaboratoryTestOrder.patient_id'] = $this->request->query ['patient_id'];
				}
				$conditions ['LaboratoryTestOrder.is_deleted'] = 0;
				$conditions ['LaboratoryTestOrder.location_id'] = $this->Session->read ( 'locationid' );
				$this->paginate = array (
						'limit' => Configure::read ( 'number_of_rows' ),
						'fields' => array (
								'LaboratoryResult.id',
								'Laboratory.name',
								'LaboratoryTestOrder.start_date',
								'LaboratoryTestOrder.order_id',
								'LaboratoryTestOrder.patient_id',
								'Patient.lookup_name',
								'LaboratoryTestOrder.create_time' 
						),
						'conditions' => $conditions,
						'order' => array (
								'LaboratoryTestOrder.patient_id' => 'desc' 
						) 
				);
				$this->set ( array (
						'testOrdered' => $this->paginate ( 'LaboratoryTestOrder' ) 
				) );
			}
		}
		function labAbnormalTestReport() {
			$this->layout = 'advance';
			$this->uses = array (
					'LaboratoryTestOrder' 
			);
			$this->LaboratoryTestOrder->bindModel ( array (
					'belongsTo' => array (
							'Laboratory' => array (
									'foreignKey' => 'laboratory_id',
									'conditions' => array (
											'Laboratory.is_active' => 1 
									) 
							),
							'LaboratoryResult' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryResult.laboratory_test_order_id=LaboratoryTestOrder.id' 
									) 
							),
							'LaboratoryHl7Result' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryHl7Result.laboratory_result_id=LaboratoryResult.id' 
									) 
							),
							'Patient' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Patient.id=LaboratoryTestOrder.patient_id' 
									) 
							) 
					) 
			), false );
			if (! empty ( $this->request->query )) {
				$fromDate = $this->DateFormat->formatDate2STD ( $this->request->query ['from_date'] . " 00:00:00", Configure::read ( 'date_format' ) );
				$toDate = $this->DateFormat->formatDate2STD ( $this->request->query ['to_date'] . " 23:59:59", Configure::read ( 'date_format' ) );
				$conditions = array (
						'LaboratoryResult.create_time >=' => $fromDate,
						'LaboratoryResult.create_time <=' => $toDate 
				);
				if ($this->request->query ['patient_id']) {
					$conditions ['LaboratoryTestOrder.patient_id'] = $this->request->query ['patient_id'];
				}
				$conditions ['LaboratoryTestOrder.is_deleted'] = 0;
				$conditions ['LaboratoryTestOrder.location_id'] = $this->Session->read ( 'locationid' );
				$conditions ['LaboratoryHl7Result.abnormal_flag'] = array (
						'A',
						'H',
						'L' 
				);
				$this->paginate = array (
						'limit' => Configure::read ( 'number_of_rows' ),
						'fields' => array (
								'LaboratoryResult.id',
								'Laboratory.name',
								'LaboratoryTestOrder.start_date',
								'LaboratoryTestOrder.order_id',
								'LaboratoryTestOrder.patient_id',
								'Patient.lookup_name',
								'LaboratoryTestOrder.create_time',
								'LaboratoryHl7Result.abnormal_flag',
								'LaboratoryHl7Result.create_time' 
						),
						'conditions' => $conditions,
						'order' => array (
								'LaboratoryTestOrder.patient_id' => 'desc' 
						) 
				);
				// debug($conditions);
				$this->set ( array (
						'testOrdered' => $this->paginate ( 'LaboratoryTestOrder' ) 
				) );
			}
		}
		function labdash($patient_id = null) {
			$this->layout = 'advance_ajax';
			
			$this->uses = array (
					'LabManager' 
			);
			$this->LabManager->bindModel ( array (
					'belongsTo' => array (
							'Laboratory' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Laboratory.id=LabManager.laboratory_id',
											'Laboratory.is_active=1' 
									) 
							),
							'Patient' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Patient.id=LabManager.patient_id' 
									) 
							) 
					) 
			), false );
			
			$getData = $this->LabManager->find ( 'all', array (
					'fields' => array (
							'LabManager.id',
							'LabManager.order_id',
							'Laboratory.name' 
					),
					'conditions' => array (
							'LabManager.patient_id' => $patient_id 
					),
					'group' => array (
							'Laboratory.id' 
					) 
			) );
			// debug($getData);exit;
			$this->set ( 'data', $getData );
		}
		public function specimenBarCode($patientId) {
			// debug($patientId);exit;
			$this->layout = 'advance';
			$this->uses = array (
					'LaboratoryToken',
					'LaboratoryTestOrder' 
			);
			// $this->set('patientId',$patientId);
			/**
			 * *
			 */
			$this->LaboratoryTestOrder->updateAll ( array (
					'showEdit' => '1' 
			), array (
					'patient_id' => $patientId 
			) );
			/**
			 * *
			 */
			$tocreateBarcode = $this->LaboratoryTestOrder->find ( 'all', array (
					'fields' => array (
							'id',
							'patient_id',
							'specimen_id',
							'order_id',
							'create_time' 
					),
					'conditions' => array (
							'patient_id' => $patientId,
							'OR' => array (
									array (
											'specimen_id' => NULL 
									),
									array (
											'specimen_id' => '' 
									) 
							) 
					) 
			) );
			foreach ( $tocreateBarcode as $key => $createRecords ) {
				$explodeTime = explode ( ' ', $createRecords ['LaboratoryTestOrder'] ['create_time'] );
				$getSpecimenId = $this->LaboratoryTestOrder->autoGeneratedSpecimenID ( $key, $createRecords ['LaboratoryTestOrder'] ['id'] );
				$this->LaboratoryTestOrder->getLabRequsitionQR ( $getSpecimenId, $patientId );
				$this->LaboratoryTestOrder->updateAll ( array (
						'specimen_id' => "'$getSpecimenId'" 
				), array (
						'id' => $createRecords ['LaboratoryTestOrder'] ['id'] 
				) );
			}
			/**
			 * display Data *
			 */
			$this->LaboratoryTestOrder->bindModel ( array (
					'belongsTo' => array (
							'Laboratory' => array (
									'foreignKey' => 'laboratory_id',
									'conditions' => array (
											'Laboratory.is_active' => 1 
									) 
							) 
					) 
			) );
			$genratedBarcode = $this->LaboratoryTestOrder->find ( 'all', array (
					'fields' => array (
							'LaboratoryTestOrder.id',
							'LaboratoryTestOrder.order_id',
							'LaboratoryTestOrder.patient_id',
							'LaboratoryTestOrder.specimen_id',
							'Laboratory.name' 
					),
					'conditions' => array (
							'patient_id' => $patientId 
					),
					'group' => array (
							'Laboratory.id' 
					) 
			) );
			// debug($genratedBarcode);exit;
			
			$this->set ( 'genratedBarcode', $genratedBarcode );
		}
		public function printSp($id) {
			// debug($id);exit;
			$this->layout = 'advance_ajax';
			$this->uses = array (
					'LaboratoryToken',
					'LaboratoryTestOrder' 
			);
			$this->LaboratoryTestOrder->bindModel ( array (
					'belongsTo' => array (
							'Laboratory' => array (
									'foreignKey' => 'laboratory_id',
									'conditions' => array (
											'Laboratory.is_active' => 1 
									) 
							),
							'Patient' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Patient.id=LaboratoryTestOrder.patient_id' 
									) 
							) 
					) 
			) );
			// debug($id);
			$explodeArray = explode ( ",", $id );
			// debug(count($explodeArray));exit;
			if (count ( $explodeArray ) != '1') {
				unset ( $explodeArray [count ( $explodeArray ) - 1] );
			}
			$getData = $this->LaboratoryTestOrder->find ( 'all', array (
					'conditions' => array (
							'LaboratoryTestOrder.id' => $explodeArray 
					),
					'fields' => array (
							'Patient.lookup_name',
							'LaboratoryTestOrder.specimen_id',
							'Laboratory.name' 
					) 
			) );
			// debug($getData);exit;
			$this->set ( 'getData', $getData );
		}
		public function turnAroundTime() {
			$this->uses = array (
					'LaboratoryResult' 
			);
			$this->LaboratoryResult->bindModel ( array (
					'belongsTo' => array (
							'Laboratory' => array (
									'foreignKey' => 'laboratory_id',
									'conditions' => array (
											'Laboratory.is_active' => 1 
									) 
							),
							'LaboratoryTestOrder' => array (
									'foreignKey' => false,
									'conditions' => array (
											'LaboratoryTestOrder.id=LaboratoryResult.laboratory_test_order_id' 
									) 
							),
							'Patient' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Patient.id=LaboratoryResult.patient_id' 
									) 
							) 
					) 
			) );
			$this->paginate = array (
					'limit' => Configure::read ( 'number_of_rows' ),
					'fields' => array (
							'LaboratoryResult.result_publish_date',
							'Laboratory.name',
							'LaboratoryTestOrder.start_date',
							'LaboratoryTestOrder.order_id',
							'Patient.lookup_name',
							'Patient.admission_id' 
					),
					'order' => array (
							'Patient.id' => 'desc' 
					) 
			);
			/*
			 * $a=$this->LaboratoryResult->find('all',array('fields'=>array('LaboratoryResult.result_publish_date','Laboratory.name','LaboratoryTestOrder.start_date','LaboratoryTestOrder.order_id'
			 * ,'Patient.lookup_name')));
			 */
			// $r= $this->paginate(LaboratoryResult); debug($r); exit;
			$this->set ( array (
					'testOrdered' => $this->paginate ( 'LaboratoryResult' ) 
			) );
		}
		public function admin_addProfileTest($laboratoryId = null) {
			$this->uses = array (
					'Laboratory',
					'TestGroup' 
			);
			$groupTests = $this->Laboratory->getGroupNonPanelTest ();
			$labProfileSpecialityList = $this->Laboratory->getLabProfileSubSpeciality ();
			$this->set ( array (
					'groupTests' => $groupTests,
					'labProfileSpecialityList' => $labProfileSpecialityList 
			) );
		}
		function adminViewProfileTest() {
		}
		public function sampleTypes($specimenType = null) {
			$this->layout = 'advance';
			$this->uses = array (
					'SpecimenType' 
			);
			$this->set ( 'title_for_layout', __ ( 'Sample Types', true ) );
			if ($this->request->data ['SpecimenType']) {
				$this->SpecimenType->save ( $this->request->data ['SpecimenType'] );
				$message = ($this->request->data ['SpecimenType'] ['id']) ? 'Updated Sucessfully' : 'Added Sucessfully';
				$this->Session->setFlash ( __ ( $message, true, array (
						'class' => 'message' 
				) ) );
			}
			if ($this->params->query ['description']) {
				$searchByName ['SpecimenType.description Like'] = $this->params->query ['description'] . '%';
			}
			$this->paginate = array (
					'evalScripts' => true,
					'limit' => Configure::read ( 'number_of_rows' ),
					'order' => array (
							'SpecimenType.id' => 'DESC' 
					),
					'fields' => array (
							'SpecimenType.id',
							'SpecimenType.description' 
					),
					'conditions' => array (
							'SpecimenType.is_deleted' => 0,
							$searchByName 
					) 
			);
			$data = $this->paginate ( 'SpecimenType' );
			if ($specimenType) {
				$this->data = $this->SpecimenType->read ( null, $specimenType );
				$this->set ( 'action', 'edit' );
			}
			$this->set ( 'data', $data );
		}
		public function deleteSampleType($specimenType) {
			$this->uses = array (
					'SpecimenType' 
			);
			$deleteArray ['id'] = $specimenType;
			$deleteArray ['is_deleted'] = 1;
			$this->SpecimenType->save ( $deleteArray );
			$this->Session->setFlash ( __ ( 'Deleted Sucessfully', true, array (
					'class' => 'message' 
			) ) );
			$this->redirect ( array (
					'controller' => 'Laboratories',
					'action' => 'sampleTypes' 
			) );
		}
		public function addDoc($labManagerId = NULL, $patientId = NULL, $labId = NULL) {
			$this->uses = array (
					'LaboratoryResult' 
			);
			$this->layout = 'advance_ajax';
			if ($this->request->data) {
				// debug($this->request->data);exit;
				$this->LaboratoryResult->create ();
				$img1 = explode ( '.', $this->data ['laboratory'] ['upload'] ['name'] );
				$img = $img1 [0] . '_' . mktime () . '.' . $img1 [1];
				$filename = WWW_ROOT . DS . 'uploads' . DS . 'laboratory' . DS . $img;
				move_uploaded_file ( $this->data ['laboratory'] ['upload'] ['tmp_name'], $filename );
				$id = $this->LaboratoryResult->find ( 'first', array (
						'fields' => array (
								'id' 
						),
						'conditions' => array (
								'LaboratoryResult.patient_id' => $patientId,
								'LaboratoryResult.laboratory_test_order_id' => $labManagerId 
						) 
				) );
				if (! empty ( $id ))
					$this->request->data ['laboratory'] ['id'] = $id ['LaboratoryResult'] ['id'];
				else {
					$this->request->data ['laboratory'] ['laboratory_test_order_id'] = $labManagerId;
					$this->request->data ['laboratory'] ['patient_id'] = $patientId;
					$this->request->data ['laboratory'] ['laboratory_id'] = $labId;
				}
				$this->request->data ['laboratory'] ['upload'] = $img;
				
				if ($this->LaboratoryResult->save ( $this->request->data ['laboratory'] )) {
					$this->Session->setFlash ( 'Your Document has been uploaded.' );
					$this->set ( 'status', 'success' );
					
					// $this->redirect(array('action' => 'labTestHl7List',$patientId,'?'=>array('return'=>'laboratories')));
				} else {
					$this->Session->setFlash ( 'Unable to upload your document.' );
				}
			}
		}
		// added by atul for importing lab in master
		public function import_data() {
			$this->uses = array('TariffStandard','Tariff');
			$website=$this->Session->read("website.instance");
			App::import ( 'Vendor', 'reader' );
			$this->set ( 'title_for_layout', __ ( 'Laboratory- Export Data', true ) );
			if ($this->request->is ( 'post' )) { // pr($this->request->data);
				if ($this->request->data ['importData'] ['import_file'] ['error'] != "0") {
					$this->Session->setFlash ( __ ( 'Please Upload the file' ), 'default', array (
							'class' => 'error' 
					) );
					$this->redirect ( array (
							"controller" => "Laboratories",
							"action" => "import_data",
							"admin" => false 
					) );
				}
				/*
				 * if($this->request->data['importData']['import_file']['size'] > "1000000"){
				 * $this->Session->setFlash(__('Size exceed Please upload 1 MB size file.'), 'default', array('class' => 'error'));
				 * $this->redirect(array("controller" => "Tariffs", "action" => "import_data","admin"=>true));
				 * }
				 */
				$tariff=$this->request->data['importData']['tariffId'];
				$data = new Spreadsheet_Excel_Reader ();
				$data->setOutputEncoding ( 'CP1251' );
				ini_set ( 'memory_limit', - 1 );
				set_time_limit ( 0 );
				$path = WWW_ROOT . 'uploads/import/' . $this->request->data ['importData'] ['import_file'] ['name'];
				move_uploaded_file ( $this->request->data ['importData'] ['import_file'] ['tmp_name'], $path );
				chmod ( $data->path, 777 );
				$data = new Spreadsheet_Excel_Reader ( $path );
				$is_uploaded = $this->Laboratory->importDataGlobus($data);
				if ($is_uploaded == true) {
					unlink ( $path );
					$this->Session->setFlash ( __ ( 'Data imported sucessfully' ), 'default', array (
							'class' => 'message' 
					) );
					$this->redirect ( array (
							"controller" => "Laboratories",
							"action" => "import_data",
							"admin" => false 
					) );
				} else {
					unlink ( $path );
					$this->Session->setFlash ( __ ( 'Error Occured Please check your Excel sheet.' ), 'default', array (
							'class' => 'error' 
					) );
					$this->redirect ( array (
							"controller" => "Laboratories",
							"action" => "import_data",
							"admin" => false 
					) );
				}
			}
			$privateID = $this->TariffStandard->getPrivateTariffID();
			$this->set('privateID',$privateID);
			$tariffStandard=$this->TariffStandard->find("list",array(array('id','name'),"conditions"=>
					array("TariffStandard.is_deleted"=>0,
							'TariffStandard.location_id'=>$this->Session->read('locationid')
					)
			));
			$this->set('tariffStandard',$tariffStandard);
		}
		public function histology($laboratoryTestOrderId) {
			$this->layout = "advance";
			$this->uses = array (
					'LaboratoryHistopathology',
					'LaboratoryTestOrder' 
			);
			$this->LaboratoryTestOrder->bindModel ( array (
					'belongsTo' => array (
							'Laboratory' => array (
									'foreignKey' => 'laboratory_id' 
							) 
					) 
			), false );
			if (! empty ( $id )) {
				$result = $this->LaboratoryHistopathology->find ( 'all', array (
						'conditions' => array (
								'LaboratoryHistopathology.laboratory_id' => $id 
						) 
				) );
				$this->set ( 'results', $result );
				// debug($result);
			}
			if ($this->request->data) {
				$this->Laboratory->insertHistology ( $this->request->data );
			}
		}
		/**
		 * check unique lab name during creation of lab on client side.
		 *
		 */
		function admin_checkduplabname(){
			$this->autoRender =false ;
			$labname = $this->params->query['fieldValue'];
			if($labname == ''){
				return;
			}
			$count = $this->Laboratory->find('count',array('conditions'=>array('Laboratory.name'=>trim($labname))));
			if(!$count){
				return json_encode(array('name',true,'alertTextOk')) ;
			}else return json_encode(array('name',false,'alertText')) ;
		
			exit;
		}
		
		/**
		 * function for new patient hub
		 * Pooja Gupta
		 */
		
		function labDetailsPatientHub($patient_id){
			$this->layout='ajax';
			$this->loadModel('LaboratoryTestOrder');
			$labs=$this->LaboratoryTestOrder->labDetails($patient_id);
			$this->loadModel('RadiologyTestOrder');
			$rads=$this->RadiologyTestOrder->radDetails($patient_id);
			$this->set('labs',$labs);
			$this->set('rads',$rads);
			$this->loadModel('Patient');
			$encounters=$this->Patient->getPersonAllEncounterList($patient_id);
			$this->set('encounterId',$encounters);
		}
	}


//EOF class