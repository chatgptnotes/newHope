<?php
/**
 * MedicalRequisition file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       PharmacyItem Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class MedicalRequisition extends AppModel {

	public $name = 'MedicalRequisition';
 	public $hasMany = array(
		'MedicalRequisitionDetail' => array(
		'className' => 'MedicalRequisitionDetail',
		'dependent' => true,
		'foreignKey' => 'medical_requisition_id',
		)
	);
	/*	public $belongsTo = array(
		'PatientCentricDepartment' => array(
			'className' => 'PatientCentricDepartment',
			'foreignKey' => 'patient_centric_department_id'
			)
		);  */
	  public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }

	public function saveDetails($data){
		foreach($data['item_id'] as $key => $value){
			 if(!isset($data['MedicalRequisitionDetail'][$key])){
				$datum[$key]['medical_item_id'] = $data['item_id'][$key];
				$datum[$key]['date'] =  DateFormatComponent::formatDate2STD($data['date'][$key],Configure::read('date_format'));
				$datum[$key]['request_quantity'] = $data['qty'][$key];
				$datum[$key]['recieved_quantity'] = $data['recieved_quantity'][$key];
				$datum[$key]['recieved_date'] =DateFormatComponent::formatDate2STD($data['recieved_date'][$key],Configure::read('date_format'));
				$datum[$key]['used_quantity'] = $data['used_quantity'][$key];
				$datum[$key]['return_date'] = DateFormatComponent::formatDate2STD($data['return_date'][$key],Configure::read('date_format'));
				$datum[$key]['return_quantity'] = $data['return_quantity'][$key];

			 }
		}

 		 return $datum;
	}
	public function updateDetails($data){
		foreach($data['MedicalRequisitionDetail'] as $key => $value){
		 if(isset($data['MedicalRequisitionDetail'][$key])){
		 		$this->MedicalRequisitionDetail->id =  $data['MedicalRequisitionDetail'][$key];
				$datum['MedicalRequisitionDetail']['date'] =  DateFormatComponent::formatDate2STD($data['date'][$key],Configure::read('date_format'));
				$datum['MedicalRequisitionDetail']['request_quantity'] = $data['qty'][$key];
				$datum['MedicalRequisitionDetail']['recieved_quantity'] = $data['recieved_quantity'][$key];
				$datum['MedicalRequisitionDetail']['recieved_date'] =DateFormatComponent::formatDate2STD($data['recieved_date'][$key],Configure::read('date_format'));
				$datum['MedicalRequisitionDetail']['used_quantity'] = $data['used_quantity'][$key];
				$datum['MedicalRequisitionDetail']['return_date'] = DateFormatComponent::formatDate2STD($data['return_date'][$key],Configure::read('date_format'));
				$datum['MedicalRequisitionDetail']['return_quantity'] = $data['return_quantity'][$key];

				$this->MedicalRequisitionDetail->save($datum);
			 }
	  	}
	}

 public function acceptAllocation($data){
 		$MedicalItem = Classregistry::init('MedicalItem');
		foreach($data['MedicalRequisitionDetail'] as $key => $value){
		 if(isset($data['MedicalRequisitionDetail'][$key])){
		 		$this->MedicalRequisitionDetail->id =  $data['MedicalRequisitionDetail'][$key];
				$datum['MedicalRequisitionDetail']['recieved_quantity'] = $data['recieved_quantity'][$key];
				$datum['MedicalRequisitionDetail']['recieved_date'] =DateFormatComponent::formatDate2STD($data['recieved_date'][$key],Configure::read('date_format'));
				$this->MedicalRequisitionDetail->save($datum);
				$stock = (double)$data['instock'][$key]-(double)$data['recieved_quantity'][$key];
				$item['MedicalItem']['id'] =  $data['item_id'][$key];
				 $item['MedicalItem']['in_stock'] =  $stock;
				$MedicalItem->save($item);

			 }
	  	}
	}
}
?>