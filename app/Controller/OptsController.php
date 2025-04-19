<?php
/**
 * OptsController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class OptsController extends AppController {

	public $name = 'Opts';
	public $uses = array('Opt');
	public $helpers = array('Html','Form', 'Js','General');
	public $components = array('RequestHandler','Email');

/**
 * operation theature listing
 *
 */

	public function index() {
				$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'Opt.name' => 'asc'
			        ),
			        'conditions' => array('Opt.is_deleted' => 0,'Opt.location_id' => $this->Session->read("locationid"))
   				);
                $this->set('title_for_layout', __('OT', true));
                $this->Opt->recursive = 0;
                $data = $this->paginate('Opt');
                $this->set('data', $data);
	}

 	public function import_data(){
        $this->loadModel("Surgery");
    	 App::import('Vendor', 'reader');
		 $this->set('title_for_layout', __('Surgery- Import Data', true));
		  if ($this->request->is('post')) { //pr($this->request->data);
				 if($this->request->data['importData']['import_file']['error'] !="0"){
					 $this->Session->setFlash(__('Please Upload the file'), 'default', array('class' => 'error'));
					 $this->redirect(array("controller" => "pharmacy", "action" => "import_data","admin"=>true));
				 }
				 /*if($this->request->data['importData']['import_file']['size'] > "1000000"){
					 $this->Session->setFlash(__('Size exceed Please upload 1 MB size file.'), 'default', array('class' => 'error'));
					 $this->redirect(array("controller" => "pharmacy", "action" => "import_data","admin"=>true));
				 }*/
				 $data = new Spreadsheet_Excel_Reader();
		  		 $data->setOutputEncoding('CP1251');
				 ini_set('memory_limit',-1);
				 set_time_limit(0);
				 $path = WWW_ROOT.'uploads/import/'. $this->request->data['importData']['import_file']['name'];
				 move_uploaded_file($this->request->data['importData']['import_file']['tmp_name'],$path );
				  chmod($data->path,777);
		   		  $data = new Spreadsheet_Excel_Reader($path);
		   		   $is_uploaded = $this->Surgery->importSurgeryData($data);
				 if($is_uploaded == true){
				 	   unlink( $path );
				 	 $this->Session->setFlash(__('Data imported sucessfully'), 'default', array('class' => 'message'));
					 $this->redirect(array("controller" => "opts", "action" => "import_data","admin"=>false));
				 }else{
				 	   unlink( $path );
				 	 $this->Session->setFlash(__('Error Occured Please check your Excel sheet.'), 'default', array('class' => 'error'));
					 $this->redirect(array("controller" => "opts", "action" => "import_data","admin"=>false));
				 }

		  }

	}


/**
 * operation theature view
 *
 */
	public function view($id = null) {
                $this->set('title_for_layout', __('OT Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid OT', true));
			$this->redirect(array("controller" => "opts", "action" => "index"));
		}
                $this->set('opt', $this->Opt->read(null, $id));
        }

/**
 * operation theature add
 *
 */
	public function add() {
		
                $this->set('title_for_layout', __('Add New OT', true));
                if ($this->request->is('post')) {
                        $this->request->data['Opt']['location_id'] = $this->Session->read("locationid");
                        $this->request->data['Opt']['create_time'] = date('Y-m-d H:i:s');
                        $this->request->data['Opt']['created_by'] = $this->Auth->user('id');
                        $this->Opt->create();
                        $this->Opt->save($this->request->data);
                        $errors = $this->Opt->invalidFields();
			if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The OT has been saved', true));
			   $this->redirect(array("controller" => "opts", "action" => "index"));
                        }
		}

	}

/**
 * operation theature edit
 *
 */
	public function edit($id = null) {
                $this->set('title_for_layout', __('Edit OT Detail', true));
                if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid OT', true));
                        $this->redirect(array("controller" => "opts", "action" => "index"));
		}
                if ($this->request->is('post') && !empty($this->request->data)) {
                        $this->request->data['Opt']['location_id'] = $this->Session->read("locationid");
                        $this->request->data['Opt']['modify_time'] = date('Y-m-d H:i:s');
                        $this->request->data['Opt']['modified_by'] = $this->Auth->user('id');
                        $this->Opt->id = $this->request->data["Opt"]['id'];
                        $this->Opt->save($this->request->data);
			            $errors = $this->Opt->invalidFields();
                        if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The OT has been updated', true));
			               $this->redirect(array("controller" => "opts", "action" => "index"));
                        }
		} else {
                        $this->request->data = $this->Opt->read(null, $id);
                }


	}

/**
 * operation theature delete
 *
 */
	public function delete($id = null) {
                $this->set('title_for_layout', __('Delete OT', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for OT', true));
			$this->redirect(array("controller" => "opts", "action" => "index"));
		}
		if ($id) {
                        $this->Opt->deleteOpt($this->request->params);
                        $this->Session->setFlash(__('OT deleted', true));
			$this->redirect(array("controller" => "opts", "action" => "index"));
		}
	}

/**
 * list of all link required for OT modules
 *
 */
	public function listAllOt(){

	}
/***
	list of all OT replace
*/
	public function ot_replace_list(){
		$this->uses = array("OtReplace");
		$this->OtReplace->bindModel(array('belongsTo' =>
				 array('Opt' => array('foreignKey' => 'opt_id'), 'OptTable' =>
				  	array('foreignKey' => 'opt_table_id'), 'User' => array('foreignKey' => false, 'conditions' =>
				  		array('User.id=OtReplace.created_by')), 'Initial' =>
							array('foreignKey' => false, 'conditions' => array('Initial.id=User.initial_id')))));
		$this->paginate = array(
						'limit' => Configure::read('number_of_rows'),
						'order' => array(
							'OtReplace.create_time' => 'asc'
						),
						'conditions' => array('OtReplace.location_id' => $this->Session->read("locationid"))
					);
		$this->set('title_for_layout', __('OT', true));

		$ot_replace_lists = $this->paginate('OtReplace');
		$this->set('ot_replace_lists', $ot_replace_lists);

	}
	/***
	Add , Edit and print for a medical replacement
*/
	 public function otReplacement($id = null, $screen = null){

	 		$this->uses = array("OtReplace","OtReplaceDetail","Opt","OptTable","OtItemCategory");
	 		if($this->request->is('post') || $this->request->is('put')){

				if($id == null) {
					$data['OtReplace']['replacement_number'] =  $this->request->data['replacement_number'];
					$data['OtReplace']['opt_id'] =  $this->request->data['OtReplace']['opt_id'];
					$data['OtReplace']['opt_table_id'] =  $this->request->data['OtItemAllocation']['opt_table_id'];
					$data['OtReplace']['location_id'] = $this->Session->read('locationid');
					$data['OtReplace']['created_by'] =  $this->Session->read('userid');
					$data['OtReplace']['create_time'] =  date('Y-m-d h:i:s');
					$data['OtReplaceDetail'] = $this->OtReplace->saveDetails($this->request->data);
					if( $this->OtReplace->saveAll($data)){
						$this->Session->setFlash(__('Details saved!'),'default',array('class'=>'message'));
						$this->redirect(array('action'=>'ot_replace_list'));
					}else{
						$this->Session->setFlash(__('Details could not be saved!'),'default',array('class'=>'error'));
						$this->redirect(array('action'=>'otReplacement'));
					}
				}else{

					$data['OtReplace']['id'] =  $id;
					$data['OtReplace']['modified_by'] =  $this->Session->read('userid');
					$data['OtReplace']['modify_time'] =  date('Y-m-d h:i:s');
					$data['OtReplace']['opt_id'] =  $this->request->data['OtReplace']['opt_id'];
					if(isset($this->request->data['OtItemAllocation']))
						$data['OtReplace']['opt_table_id'] =  $this->request->data['OtItemAllocation']['opt_table_id'];
					else
						$data['OtReplace']['opt_table_id'] =  $this->request->data['OtReplace']['opt_table_id'];
				    $data['OtReplaceDetail'] = $this->OtReplace->saveDetails($this->request->data);
				 	if( $this->OtReplace->saveAll($data)){
						$this->OtReplace->updateDetails($this->request->data);
						$this->Session->setFlash(__('Details updated!'),'default',array('class'=>'message'));
						$this->redirect(array('action'=>'ot_replace_list'));
					}else{
					    $this->Session->setFlash(__('Details could not be saved!'),'default',array('class'=>'error'));
						$this->redirect(array('action'=>'otReplacement',$id));
					}
				}
			}
			$this->set('opts',$this->Opt->find('list', array('conditions' => array('Opt.is_deleted' => 0, 'Opt.location_id' => $this->Session->read("locationid")))));
			if($id == null){
			    $this->set('replacement_number',$this->renadomNumber());
				$this->render('ot_replacement');
			}else{
				$this->OtReplace->bindModel(array('belongsTo' =>
				 		array('Opt' => array('foreignKey' => 'opt_id'), 'OptTable' =>
				  			array('foreignKey' => 'opt_table_id'), 'User' => array('foreignKey' => false, 'conditions' =>
				  				array('User.id=OtReplace.created_by')), 'Initial' =>
									array('foreignKey' => false, 'conditions' => array('Initial.id=User.initial_id')))));
				$data = $this->OtReplace->read(null,$id);
				//$data = $this->OtReplace->find('first', array('conditions' => array('OtReplace.id' => $id), 'order' => array('OtReplaceDetail.ot_item_category_id')));
				// bind otreplacedetail to pharmacy item //
				$this->OtReplaceDetail->bindModel(array('belongsTo' =>
				 		array('OtItem' => array('foreignKey' => 'item_id'),  'PharmacyItem' => array('foreignKey' => false, 'conditions' =>
				  				array('PharmacyItem.id=OtItem.pharmacy_item_id')))));

				 foreach($data['OtReplaceDetail'] as $key=>$value){
				 $this->OtReplaceDetail->bindModel(array('belongsTo' =>
				 		array('OtItem' => array('foreignKey' => 'item_id'),  'PharmacyItem' => array('foreignKey' => false, 'conditions' =>
				  				array('PharmacyItem.id=OtItem.pharmacy_item_id')))));
				 	$OtReplaceDetail = $this->OtReplaceDetail->read(null,$value['id']);
					$item = $this->OtItemCategory->read(null, $OtReplaceDetail['OtItem']['ot_item_category_id']);
					if($lastCategoryId != $item['OtItemCategory']['id']) {
						$rowspan[$item['OtItemCategory']['id']] = 1;
					} else {
						$rowspan[$item['OtItemCategory']['id']] += 1;
					}
				 	$data['OtReplaceDetail'][$key]["category"]['name'] = $item['OtItemCategory']['name'];
					$data['OtReplaceDetail'][$key]["category"]['id'] = $item['OtItemCategory']['id'];
					$data['OtReplaceDetail'][$key]["item"]['name'] = $OtReplaceDetail['PharmacyItem']['name'];
					$data['OtReplaceDetail'][$key]["item"]['id'] = $OtReplaceDetail['PharmacyItem']['id'];
					$lastCategoryId = $item['OtItemCategory']['id'];
				 }

				$this->set('OptTable',$this->OptTable->find('list', array('conditions' => array('OptTable.is_deleted' => 0, 'OptTable.opt_id' =>$data['Opt']['id'] ))));
				$this->set('rowspan',$rowspan);
				$this->set('data',$data);
				 switch($screen){
				 	case 'edit':
						$this->render('ot_replacement_edit');
					break;
					case 'view':
						$this->render('ot_replacement_print');
					break;
					case 'print';
						 $this->layout = "print_with_header";
						 $this->set('print',"true");
						$this->render('ot_replacement_print');
					break;
					default:
						$this->render('ot_replacement_print');
				 }
			}
	 }
	/***
	deelte for a medical replacement
*/

	 public function delete_medical_replace_detail(){
	 	$this->layout =false;
		$this->uses = array( "OtReplaceDetail");
		if($this->request->is('post') || $this->request->is('put')){
			if($this->OtReplaceDetail->delete($this->request->data['id'])){
				echo "Deleted!";
			}else{
			    echo "Something went wrong.";
			}
		}
		exit;
	 }
	/*
	list of all Medical Requisition
*/
	public function medical_requisition_list(){
		$this->uses = array("MedicalRequisition");

		$this->paginate = array(
						'limit' => Configure::read('number_of_rows'),
						'order' => array(
							'MedicalRequisition.create_time' => 'asc'
						),
						'conditions' => array('MedicalRequisition.location_id' => $this->Session->read("locationid"))
					);
		$this->set('title_for_layout', __('Medical Requisition', true));
        $requsition_for ='';
		$medical_requisition_list = $this->paginate('MedicalRequisition');
	 	 foreach($medical_requisition_list as $key=>$value){
                 if($value['MedicalRequisition']['requisition_for'] == "other"){
                    $this->LoadModel("PatientCentricDepartment");
                    $for = $this->PatientCentricDepartment->read(null,$value['MedicalRequisition']['requister_id']);
                    $requsition_for =$for['PatientCentricDepartment']['name'];
                }else if($value['MedicalRequisition']['requisition_for'] == "ot"){
                    $for = $this->Opt->read(null,$value['MedicalRequisition']['requister_id']);
                    $requsition_for =$for['Opt']['name'];
                }else if($value['MedicalRequisition']['requisition_for'] == "chamber"){
                    $this->LoadModel("Chamber");
                    $for = $this->Chamber->read(null,$value['MedicalRequisition']['requister_id']);
                    $requsition_for =$for['Chamber']['name'];
                }else{
                     $this->LoadModel("Ward");
                     $for = $this->Ward->read(null,$value['MedicalRequisition']['requister_id']);
                     $requsition_for =$for['Ward']['name'];

                }
            $medical_requisition_list[$key]['MedicalRequisition']['for'] =$requsition_for;
		}

	 	# pr($medical_requisition_list);exit;
		$this->set('medical_requisition_list', $medical_requisition_list);

	}
	 /**
	 medical requisition
	 **/

	  public function medical_requisition($id = null, $screen = null){
	  		 $this->set('title_for_layout', __('Medical Requisition', true));
	 		$this->uses = array("MedicalRequisition","MedicalRequisitionDetail","PatientCentricDepartment","OtReplace","OtItemCategory","MedicalItem","Ward","Chamber");
	 		if($this->request->is('post') || $this->request->is('put')){
                if($this->request->data['requisition_for'] == "other"){
                    $data['MedicalRequisition']['requister_id'] =  $this->request->data['MedicalRequisition']['other'];
                }else if($this->request->data['requisition_for'] == "OT"){
                    $data['MedicalRequisition']['requister_id'] =  $this->request->data['MedicalRequisition']['ot'];
                }else if($this->request->data['requisition_for'] == "Exam Room"){
                    $data['MedicalRequisition']['requister_id'] =  $this->request->data['MedicalRequisition']['chamber'];
                }else{
                    $data['MedicalRequisition']['requister_id'] =  $this->request->data['MedicalRequisition']['ward'];
                }
				if($id == null){
 					$data['MedicalRequisition']['requisition_for'] =  $this->request->data['requisition_for'];

 					$data['MedicalRequisition']['location_id'] = $this->Session->read('locationid');
					$data['MedicalRequisition']['created_by'] =  $this->Session->read('userid');
					$data['MedicalRequisition']['create_time'] =  date('Y-m-d h:i:s');
					$data['MedicalRequisitionDetail'] = $this->MedicalRequisition->saveDetails($this->request->data);
					if( $this->MedicalRequisition->saveAll($data)){
						$this->Session->setFlash(__('Details saved!'),'default',array('class'=>'message'));
						$this->redirect(array('action'=>'medical_requisition_list'));
					}else{
						$this->Session->setFlash(__('Details could not be saved!'),'default',array('class'=>'error'));
						$this->redirect(array('action'=>'medical_requisition'));
					}
				}else{
					$data['MedicalRequisition']['id'] =  $id;
                    $data['MedicalRequisition']['requisition_for'] =  $this->request->data['requisition_for'];
					$data['MedicalRequisition']['modified_by'] =  $this->Session->read('userid');
					$data['MedicalRequisition']['modify_time'] =  date('Y-m-d h:i:s');
				    $data['MedicalRequisitionDetail'] = $this->MedicalRequisition->saveDetails($this->request->data);
				 	if( $this->MedicalRequisition->saveAll($data)){
						$this->MedicalRequisition->updateDetails($this->request->data);
						$this->Session->setFlash(__('Details updated!'),'default',array('class'=>'message'));
						$this->redirect(array('action'=>'medical_requisition_list'));
					}else{
					    $this->Session->setFlash(__('Details could not be saved!'),'default',array('class'=>'error'));
						$this->redirect(array('action'=>'medical_requisition',$id));
					}
				}
			}


        	$this->set('PatientCentricDepartment',$this->PatientCentricDepartment->find('list',
							 array('conditions' => array('PatientCentricDepartment.is_deleted' => 0, 'PatientCentricDepartment.location_id' =>
							 				$this->Session->read("locationid")))));
            $this->set('ot',$this->Opt->find('list',
							 array('conditions' => array('Opt.is_deleted' => 0, 'Opt.location_id' =>
							 				$this->Session->read("locationid")))));
            $this->set('chambers',$this->Chamber->find('list',
							 array('conditions' => array('Chamber.is_deleted' => 0, 'Chamber.location_id' =>
							 				$this->Session->read("locationid")))));
            $this->set('wards',$this->Ward->find('list',array('conditions'=>array('Ward.location_id'=>$this->Session->read('locationid')))));


			if($id == null){
			    $this->set('replacement_number',$this->renadomNumber());
				$this->render('medical_requisition');
			}else{
				$data = $this->MedicalRequisition->read(null,$id);
				foreach($data['MedicalRequisitionDetail'] as $key=>$value){
					 $this->MedicalItem->bindModel(array('belongsTo' =>
				 		         array('OtItemCategory' => array('foreignKey' => 'ot_item_category_id') )));
					 $this->MedicalItem->bindModel(array('belongsTo' =>
				 	      	     array('PharmacyItem' => array('foreignKey' => 'pharmacy_item_id ') )));
				 	 $MedicalItem = $this->MedicalItem->read(null,$value['medical_item_id']);
					 $data['MedicalRequisitionDetail'][$key]["item"]['name'] = $MedicalItem['PharmacyItem']['name'];
					 $data['MedicalRequisitionDetail'][$key]["item"]['id'] = $MedicalItem['PharmacyItem']['id'];
					 $data['MedicalRequisitionDetail'][$key]["category"]['name'] = $MedicalItem['OtItemCategory']['name'];
					 $data['MedicalRequisitionDetail'][$key]["category"]['id'] = $MedicalItem['OtItemCategory']['id'];
                     $requsition_for='';
                     if($data['MedicalRequisition']['requisition_for'] == "other"){
                        $this->LoadModel("PatientCentricDepartment");
                        $for = $this->PatientCentricDepartment->read(null,$data['MedicalRequisition']['requister_id']);
                        $requsition_for =$for['PatientCentricDepartment']['name'];
                    }else if($data['MedicalRequisition']['requisition_for'] == "OR"){
                        $for = $this->Opt->read(null,$data['MedicalRequisition']['requister_id']);
                        $requsition_for =$for['Opt']['name'];
                    }else if($data['MedicalRequisition']['requisition_for'] == "Exam Room"){
                        $this->LoadModel("Chamber");
                        $for = $this->Chamber->read(null,$data['MedicalRequisition']['requister_id']);
                        $requsition_for =$for['Chamber']['name'];
                    }else{
                         $this->LoadModel("Ward");
                         $for = $this->Ward->read(null,$data['MedicalRequisition']['requister_id']);
                         $requsition_for =$for['Ward']['name'];

                    }
                     $data['MedicalRequisition']['for'] =  $requsition_for;
				 }

 				$this->set('data',$data);
				 switch($screen){
				 	case 'edit':
						$this->render('medical_requisition_edit');
					break;
					case 'view':
						$this->render('medical_requisition_print');
					break;
					case 'print';
						 $this->layout = "print_with_header";
						 $this->set('print',"true");
						$this->render('medical_requisition_print');
					break;
					default:
						$this->render('medical_requisition_print');
				 }
			}
	 }
	 	/***
	deelte for a medical replacement
*/

	 public function delete_medical_requisition_detail(){
	 	$this->layout =false;
		$this->uses = array( "MedicalRequisitionDetail");
		if($this->request->is('post') || $this->request->is('put')){
			if($this->MedicalRequisitionDetail->delete($this->request->data['id'])){
				echo "Deleted!";
			}else{
			    echo "Something went wrong.";
			}
		}
		exit;
	 }
	 private function renadomNumber(){
	 	$characters = array(
		"A","B","C","D","E","F","G","H","J","K","L","M",
		"N","P","Q","R","S","T","U","V","W","X","Y","Z",
		"1","2","3","4","5","6","7","8","9");
		$keys = array();
		$random_chars ='';
		while(count($keys) < 7) {
			$x = mt_rand(0, count($characters)-1);
			if(!in_array($x, $keys)) {
			   $keys[] = $x;
			}
		}
		foreach($keys as $key){
		   $random_chars .= $characters[$key];
		}
		return "MRSLIP-".$random_chars;
	 }

/**
 * autosearch  item with code
 *
 */
	public function autoSearchItem() {

				$this->uses = array("OtItem","MedicalItem");
				$this->OtItem->bindModel(array('belongsTo' => array('PharmacyItem' => array('foreignKey' => 'pharmacy_item_id'))));
				$this->MedicalItem->bindModel(array('belongsTo' => array('PharmacyItem' => array('foreignKey' => 'pharmacy_item_id'))));
				if($this->params->query['model'] == "MedicalItem"){
					$getOtItem = $this->MedicalItem->find('all', array('conditions' =>
								 array('MedicalItem.ot_item_category_id'=>$this->params->query['category'],'MedicalItem.is_deleted' => 0)));
					 foreach ($getOtItem as $getOtItemVal) {
						 //$pharmacyNamewithItemCode = $getOtItemVal['PharmacyItem']['name']."(".$getOtItemVal['PharmacyItem']['item_code'].")";
						 $pharmacyNamewithItemCode = $getOtItemVal['PharmacyItem']['name'];
						 echo  $getOtItemVal['PharmacyItem']['name']."|". $getOtItemVal['MedicalItem']['id']."\n";
					 }

				}else{
                 	$getOtItem = $this->OtItem->find('all', array('conditions' => array('OtItem.ot_item_category_id'=>$this->params->query['category'],'OtItem.is_deleted' => 0)));
					 foreach ($getOtItem as $getOtItemVal) {
						 //$pharmacyNamewithItemCode = $getOtItemVal['PharmacyItem']['name']."(".$getOtItemVal['PharmacyItem']['item_code'].")";
						 $pharmacyNamewithItemCode = $getOtItemVal['PharmacyItem']['name'];
						 echo "$pharmacyNamewithItemCode|{$getOtItemVal['OtItem']['id']}\n";
					 }
				 }


		 exit; //dont remove this
	}

	/* for add,   medical Item*/
	function admin_medical_item_add(){
 		 $this->uses = array('OtItemCategory', 'PharmacyItem', 'MedicalItem');
		 $this->MedicalItem->bindModel(array('belongsTo' =>
		 							 array('OtItemCategory' => array('foreignKey' => 'ot_item_category_id'),
									 'PharmacyItem' => array('foreignKey' => 'pharmacy_item_id'))));
		if($this->request->is('post') || $this->request->is('put')){
			 	   $this->request->data['MedicalItem']['location_id'] = $this->Session->read("locationid");
                   $this->request->data['MedicalItem']['create_time'] = date('Y-m-d H:i:s');
                   $this->request->data['MedicalItem']['created_by'] = $this->Auth->user('id');
				   $this->MedicalItem->create();
                        $this->MedicalItem->save($this->request->data);
                        $errors = $this->MedicalItem->invalidFields();
					if(!empty($errors)) {
                           $this->set("errors", $errors);
                    } else {
                           $this->Session->setFlash(__('The Medical Item has been saved', true));
			               $this->redirect(array( "action" => "medical_item_list","admin"=>true));
                    }

		}
		$this->set('otitemcategories',
			$this->OtItemCategory->find('list', array('conditions' =>
					 array('OtItemCategory.is_deleted' => 0, 'OtItemCategory.location_id' => $this->Session->read('locationid')))));

	}

	/* for edit medical Item*/
	function admin_medical_item_edit($id=null){
			if($id == null){
				  $this->Session->setFlash(__('Invalid ID', true));
			      $this->redirect(array( "action" => "medical_item_list","admin"=>true));

			}
		 $this->uses = array('OtItemCategory', 'PharmacyItem', 'MedicalItem');
		 $this->MedicalItem->bindModel(array('belongsTo' =>
		 							 array('OtItemCategory' => array('foreignKey' => 'ot_item_category_id'),
									 'PharmacyItem' => array('foreignKey' => 'pharmacy_item_id'))));
		if($this->request->is('post') || $this->request->is('put')){
                   $this->request->data['MedicalItem']['modify_time'] = date('Y-m-d H:i:s');
                   $this->request->data['MedicalItem']['modified_by'] = $this->Auth->user('id');
				   $this->MedicalItem->id = $id;
                   $this->MedicalItem->save($this->request->data);
                   $errors = $this->MedicalItem->invalidFields();
				   if(!empty($errors)) {
                           $this->set("errors", $errors);
                    } else {
                           $this->Session->setFlash(__('The Medical Item has been saved', true));
			               $this->redirect(array( "action" => "medical_item_list","admin"=>true));
                    }

		}
		$this->set('otitemcategories',
			$this->OtItemCategory->find('list', array('conditions' =>
					 array('OtItemCategory.is_deleted' => 0, 'OtItemCategory.location_id' => $this->Session->read('locationid')))));
	   $this->request->data = $this->MedicalItem->read(null, $id);
	}
	/**
 * ot item view
 *
 */
	public function admin_medical_item_view($id = null) {
		$this->uses = array('OtItemCategory', 'PharmacyItem', 'MedicalItem');
        $this->set('title_for_layout', __('Medical Item Detail', true));
        $this->MedicalItem->bindModel(array('belongsTo' => array('OtItemCategory' => array('foreignKey' => 'ot_item_category_id'))));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Medical Item', true));
			  $this->redirect(array( "action" => "medical_item_list","admin"=>true));
		}
		        $this->MedicalItem->bindModel(array('belongsTo' => array('PharmacyItem' => array('foreignKey' => 'pharmacy_item_id'))));
                $this->set('MedicalItem', $this->MedicalItem->read(null, $id));
        }


/**
 * ot item delete
 *
 */
	public function admin_medical_item_delete($id = null) {
		$this->uses = array('MedicalItem');
                $this->set('title_for_layout', __('Delete Medical Item', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Medical Item', true));
			$this->redirect(array(  "action" => "medical_item_list","admin"=>true));
		}
		if ($id) {
			            $this->MedicalItem->id = $id;
			            $this->request->data['MedicalItem']['id'] = $id;
			            $this->request->data['MedicalItem']['is_deleted'] = 1;
			            $this->request->data['MedicalItem']['modified_by'] = $this->Auth->user('id');
			            $this->request->data['MedicalItem']['modify_time'] = date('Y-m-d H:i:s');
			            $this->MedicalItem->save($this->request->data);
                        $this->Session->setFlash(__('Medical Item deleted', true));
			$this->redirect(array(  "action" => "medical_item_list","admin"=>true));
		}
	}


		/* for list medical Item*/
	function admin_medical_item_list(){
		 $this->loadModel("MedicalItem");

		 $this->MedicalItem->bindModel(array('belongsTo' =>
		 							 array('OtItemCategory' => array('foreignKey' => 'ot_item_category_id'),
									 'PharmacyItem' => array('foreignKey' => 'pharmacy_item_id'))));
 			$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'OtItemCategory.name' => 'asc'
			        ),
			        'conditions' => array('MedicalItem.is_deleted' => 0,'MedicalItem.location_id' => $this->Session->read("locationid"))
   				);
                $this->set('title_for_layout', __('Medical Items', true));
                $this->MedicalItem->recursive = 0;
                $data = $this->paginate('MedicalItem');
                $this->set('data', $data);

	}
	/* for list medical Item*/
	function admin_medical_item_allocation(){
		 $this->loadModel("MedicalItem");

		 $this->MedicalItem->bindModel(array('belongsTo' =>
		 							 array('OtItemCategory' => array('foreignKey' => 'ot_item_category_id'),
									 'PharmacyItem' => array('foreignKey' => 'pharmacy_item_id'))));
 			$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'MedicalItem.name' => 'asc'
			        ),
			        'conditions' => array('MedicalItem.is_deleted' => 0,'MedicalItem.location_id' => $this->Session->read("locationid"))
   				);
                $this->set('title_for_layout', __('Medical Items', true));
                $this->MedicalItem->recursive = 0;
                $data = $this->paginate('MedicalItem');
                $this->set('data', $data);

	}
	 public function admin_medical_requisition_allocation($id = null, $screen = null){
	  		 $this->set('title_for_layout', __('Medical Requisition Allocation.', true));
	 		$this->uses = array("MedicalRequisition","MedicalRequisitionDetail","PatientCentricDepartment","OtReplace","OtItemCategory","MedicalItem");
	 		if($this->request->is('post') || $this->request->is('put')){
				 	 foreach($this->request->data['MedicalRequisitionDetail'] as $key => $value){
						 if(isset($this->request->data['MedicalRequisitionDetail'][$key])){
 							if($this->request->data['instock'][$key]< $this->request->data['recieved_quantity'][$key]){
								$this->Session->setFlash(__('Quantity is not available in Stock.'),'default',array('class'=>'error'));
								$this->redirect(array('action'=>'medical_requisition_allocation',$id,"edit","admin"=>true));

							}
						  }
	  				 }

					$data['MedicalRequisition']['id'] =  $id;
					$data['MedicalRequisition']['modified_by'] =  $this->Session->read('userid');
					$data['MedicalRequisition']['modify_time'] =  date('Y-m-d h:i:s');
					$data['MedicalRequisition']['status'] =  "Approved";
 			  		$data['MedicalRequisition']['patient_centric_department_id'] =  $this->request->data['MedicalRequisition']['patient_centric_department_id'];
				  #  $data['MedicalRequisitionDetail'] = $this->MedicalRequisition->saveDetails($this->request->data);

				 	if( $this->MedicalRequisition->saveAll($data)){

						$this->MedicalRequisition->acceptAllocation($this->request->data);

						$this->Session->setFlash(__('Details updated!'),'default',array('class'=>'message'));
						$this->redirect(array('action'=>'medical_requisition_list',"admin"=>true));
					}else{
					    $this->Session->setFlash(__('Details could not be saved!'),'default',array('class'=>'error'));
						$this->redirect(array('action'=>'medical_requisition_allocation',$id,"admin"=>true));
					}

			}


			$this->set('PatientCentricDepartment',$this->PatientCentricDepartment->find('list',
							 array('conditions' => array('PatientCentricDepartment.is_deleted' => 0, 'PatientCentricDepartment.location_id' =>
							 				$this->Session->read("locationid")))));
			if($id == null){
			    $this->set('replacement_number',$this->renadomNumber());
				$this->render('medical_requisition');
			}else{
			//	$this->MedicalRequisition->bindModel(array('belongsTo' =>
				 	//	array('PatientCentricDepartment' => array('foreignKey' => 'patient_centric_department_id') )));
				$data = $this->MedicalRequisition->read(null,$id);
				foreach($data['MedicalRequisitionDetail'] as $key=>$value){
					 $this->MedicalItem->bindModel(array('belongsTo' =>
				 		array('OtItemCategory' => array('foreignKey' => 'ot_item_category_id') )));
					 $this->MedicalItem->bindModel(array('belongsTo' =>
				 		array('PharmacyItem' => array('foreignKey' => 'pharmacy_item_id ') )));
				 	$MedicalItem = $this->MedicalItem->read(null,$value['medical_item_id']);
					 $data['MedicalRequisitionDetail'][$key]["item"]['name'] = $MedicalItem['PharmacyItem']['name'];
					$data['MedicalRequisitionDetail'][$key]["item"]['id'] = $MedicalItem['PharmacyItem']['id'];
					 $data['MedicalRequisitionDetail'][$key]["category"]['name'] = $MedicalItem['OtItemCategory']['name'];
					$data['MedicalRequisitionDetail'][$key]["category"]['id'] = $MedicalItem['OtItemCategory']['id'];
					$data['MedicalRequisitionDetail'][$key]["instock"]  = $MedicalItem['MedicalItem']['in_stock'];
                    $requsition_for='';
                     if($data['MedicalRequisition']['requisition_for'] == "other"){
                        $this->LoadModel("PatientCentricDepartment");
                        $for = $this->PatientCentricDepartment->read(null,$data['MedicalRequisition']['requister_id']);
                        $requsition_for =$for['PatientCentricDepartment']['name'];
                    }else if($data['MedicalRequisition']['requisition_for'] == "ot"){
                        $for = $this->Opt->read(null,$data['MedicalRequisition']['requister_id']);
                        $requsition_for =$for['Opt']['name'];
                    }else if($data['MedicalRequisition']['requisition_for'] == "chamber"){
                        $this->LoadModel("Chamber");
                        $for = $this->Chamber->read(null,$data['MedicalRequisition']['requister_id']);
                        $requsition_for =$for['Chamber']['name'];
                    }else{
                         $this->LoadModel("Ward");
                         $for = $this->Ward->read(null,$data['MedicalRequisition']['requister_id']);
                         $requsition_for =$for['Ward']['name'];

                    }
                     $data['MedicalRequisition']['for'] =  $requsition_for;
				 }

            //pr($data);exit;
 				$this->set('data',$data);
				 switch($screen){
				 	case 'edit':
						$this->render('admin_medical_requisition_allocation');
					break;
					case 'view':
						$this->render('medical_requisition_print');
					break;
					case 'print';
						 $this->layout = "print_with_header";
						 $this->set('print',"true");
						$this->render('medical_requisition_print');
					break;
					default:
						$this->render('medical_requisition_print');
				 }
			}
	 }
	 public function admin_medical_requisition_list(){
		$this->uses = array("MedicalRequisition");

		$this->paginate = array(
						'limit' => Configure::read('number_of_rows'),
						'order' => array(
							'MedicalRequisition.create_time' => 'asc'
						),
						'conditions' => array('MedicalRequisition.location_id' => $this->Session->read("locationid"))
					);
		$this->set('title_for_layout', __('Medical Requisition Allocation', true));

		$medical_requisition_list = $this->paginate('MedicalRequisition');
	    foreach($medical_requisition_list as $key=>$value){
                 if($value['MedicalRequisition']['requisition_for'] == "other"){
                    $this->LoadModel("PatientCentricDepartment");
                    $for = $this->PatientCentricDepartment->read(null,$value['MedicalRequisition']['requister_id']);
                    $requsition_for =$for['PatientCentricDepartment']['name'];
                }else if($value['MedicalRequisition']['requisition_for'] == "ot"){
                    $for = $this->Opt->read(null,$value['MedicalRequisition']['requister_id']);
                    $requsition_for =$for['Opt']['name'];
                }else if($value['MedicalRequisition']['requisition_for'] == "chamber"){
                    $this->LoadModel("Chamber");
                    $for = $this->Chamber->read(null,$value['MedicalRequisition']['requister_id']);
                    $requsition_for =$for['Chamber']['name'];
                }else{
                     $this->LoadModel("Ward");
                     $for = $this->Ward->read(null,$value['MedicalRequisition']['requister_id']);
                     $requsition_for =$for['Ward']['name'];

                }
            $medical_requisition_list[$key]['MedicalRequisition']['for'] =$requsition_for;
		}
		$this->set('medical_requisition_list', $medical_requisition_list);

	}
	public function get_sub_department($id = null){
		$this->uses = array("PatientCentricDepartment");
		$output = '';
		if($id != null){
		$patient_centric_department = $this->PatientCentricDepartment->read(null, $id);
		if(!isset($patient_centric_department['PatientCentricDepartment']['linked_with']) || trim($patient_centric_department['PatientCentricDepartment']['linked_with'])===''){
		 	$output .='<option value=""></option>';
		}else{
				$this->uses = array($patient_centric_department['PatientCentricDepartment']['linked_with']);
				$data = $this->$patient_centric_department['PatientCentricDepartment']['linked_with']->find("all",
								array('conditions' => array(
														$patient_centric_department['PatientCentricDepartment']['linked_with'].'.is_deleted' => 0,
														$patient_centric_department['PatientCentricDepartment']['linked_with'].'.location_id' => $this->Session->read("locationid"))
						 ));

					foreach($data as $key=>$value){
						$output .='<option value="'.$value[$patient_centric_department['PatientCentricDepartment']['linked_with']]["id"].'">'.$value[$patient_centric_department['PatientCentricDepartment']['linked_with']]["name"].'</option>';
					}

			}
			echo $output ;
		}else{
			echo "wrong ID";
		}
		exit;
	}
	
	/**
	 * not in use (Not required )
	 * @param unknown_type $optRuleId
	 * @author Gaurav Chauriya
	public function optRuleMaster($optRuleId = null){
		$this->layout = 'advance';
		$this->uses  = array('OptRule','ServiceCategory','TariffList');
		$this->set('title_for_layout', __('OT Rule', true));
		if($this->request->data['OptRule']){
			$this->OptRule->saveOptRule($this->request->data['OptRule']);
			$message = ($this->request->data['OptRule']['id']) ? 'Updated Successfully' : 'Added Successfully';
			$this->Session->setFlash(__($message, true, array('class'=>'message')));
		}
		if($this->params->query['name'])
			$searchByName['OptRule.name Like'] = $this->params->query['name'].'%';
		$this->paginate = array(
				'evalScripts' => true,
				'limit' => Configure::read('number_of_rows'),
				'order' => array('OptRule.id'=>'DESC'),
				'fields'=> array('OptRule.id','OptRule.name'),
				'conditions' => array('OptRule.is_deleted' => 0,$searchByName)
		);
		$data = $this->paginate('OptRule');
		if($optRuleId){
			$this->data  = $this->OptRule->read(null,$optRuleId);
			$this->set('action','edit');
		}
		$this->set('data', $data);
		$anesthesiaCategoryId = $this->ServiceCategory->find('first',array('fields'=>array('id'),
				'conditions'=>array('ServiceCategory.name LIKE'=>Configure::read('anesthesiaservices'),'ServiceCategory.location_id'=>$this->Session->read('locationid'))));
		$this->set('anaesthesiaSeviceList' , $this->TariffList->find('list', array('fields'=> array('id', 'name'),
				'conditions' => array('TariffList.is_deleted' => 0, 'TariffList.service_category_id' =>$anesthesiaCategoryId['ServiceCategory']['id'],
						'TariffList.location_id' => $this->Session->read('locationid')),
				'order'=>array('TariffList.name'=>'ASC'))));
	}
	
	/**
	 * Delete Opt Rule
	 * @param unknown_type $optRuleId
	 * @author Gaurav Chauriya
	 *
	public function deleteOptRule($optRuleId){
		$this->uses  = array('OptRule');
		$deleteArray['id'] = $optRuleId;
		$deleteArray['is_deleted'] = 1;
		$this->OptRule->saveOptRule($deleteArray);
		$this->Session->setFlash(__('Deleted Successfully', true, array('class'=>'message')));
		$this->redirect(array('controller'=>'opts','action'=>'optRuleMaster'));
	}
	*/
}