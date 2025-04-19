<?php
/**
 * SurgeriesController file
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
class SurgeriesController extends AppController {

	public $name = 'Surgeries';
	public $uses = array('Surgery');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email','ImageUpload');

	/**
	 * surgery listing
	 *
	*/

	public function index() {

		if($this->request->data){
			$conditions=array('Surgery.name LIKE'=>$this->request->data['Surgery']['surgery_name'].'%');
		}

		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'Surgery.create_time' => 'desc'
				),
				'conditions' => array('Surgery.is_deleted' => 0, 'Surgery.location_id' => $this->Session->read("locationid"),$conditions)
		);
		$this->set('title_for_layout', __('Surgery', true));
		$this->Surgery->recursive = 0;
		$data = $this->paginate('Surgery');
		$this->set('data', $data);
	}

	/**
	 * surgery view
	 *
	 */
	public function view($id = null) {
		$this->uses = array('ServiceCategory', 'TariffList');
		$this->set('title_for_layout', __('Surgery Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Surgery', true));
			$this->redirect(array("controller" => "surgeries", "action" => "index"));
		}
		$this->Surgery->bindModel(array(
				'belongsTo' => array(
						'ServiceCategory' =>array('foreignKey' => 'service_group'),
						'TariffList'=>array('foreignKey'=>'tariff_list_id')	,
						'SurgeryCategory'=>array('foreignKey'=>'surgery_category_id'),
						'SurgerySubcategory'=>array('foreignKey'=>'surgery_subcategory_id')
							
				)),false);

		$this->set('surgery', $this->Surgery->read(null, $id));
		$servicegroup = $this->ServiceCategory->find('all',array('conditions'=>array('ServiceCategory.is_deleted'=>0,'ServiceCategory.location_id'=>$this->Session->read('locationid'))));
		foreach($servicegroup as $servicegroupVal) {
			$getServiceGroup[$servicegroupVal['ServiceCategory']['id']] = $servicegroupVal['ServiceCategory']['name'];
		}
		$this->set('getServiceGroup', $getServiceGroup);
		$tarifflist = $this->TariffList->find('all', array('conditions' => array('TariffList.is_deleted' => 0, 'TariffList.location_id'=> $this->Session->read('locationid'))));
		foreach($tarifflist as $tarifflistVal) {
			$getTariffList[$tarifflistVal['TariffList']['id']] = $tarifflistVal['TariffList']['name'];
		}
		$this->set('getTariffList', $getTariffList);
	}

	/**
	 * surgery add
	 *
	 */
	public function add() {
		$this->uses=array('TariffList','ServiceCategory', 'SurgeryCategory');
		$this->set('title_for_layout', __('Add New Surgery', true));
		if ($this->request->is('post')) {
			$uploadFile = false;
			//debug($this->request->data);debug($_FILES['surgery_info_file_name']);
			/*if ($_FILES["surgery_info_file_name"]["size"] > 20000000) {
				$errors['0'] = "Sorry, your file is too large.";
			}else*/{
				$this->request->data['Surgery']['location_id'] = $this->Session->read("locationid");
				$this->request->data['Surgery']['create_time'] = date('Y-m-d H:i:s');
				$this->request->data['Surgery']['created_by'] = $this->Auth->user('id');
				$this->request->data['Surgery']['surgery_info_file_name'] = null;
				$this->Surgery->create();
				$this->Surgery->save($this->request->data);
				if(!empty($_FILES['surgery_info_file_name']['name'])){
					$originalImageExtension  = explode(".",$_FILES['surgery_info_file_name']['name']);
					if(!isset($originalImageExtension[1])){
						$fileName= "surgeryInfo_".$this->Surgery->id.".".$originalImageExtension[0];
					}else{
						$fileName= "surgeryInfo_".$this->Surgery->id.".".$originalImageExtension[1];
					}
					$_FILES['surgery_info_file_name']['name'] = $fileName;
					$uploadFile = true;
				}
			}
			if($uploadFile)
				$this->uploadSurgeryDoc();
			$errors = $this->Surgery->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {

				$this->Session->setFlash(__('The surgery has been saved', true));
				$this->redirect(array("controller" => "surgeries", "action" => "index"));
			}
		}
		$servicegroup = $this->ServiceCategory->find('list',array('conditions'=>array('ServiceCategory.is_deleted'=>0,'ServiceCategory.location_id'=>$this->Session->read('locationid'))));

		$getTariffList = $this->TariffList->find('list', array('conditions' => array('TariffList.service_group' => array('surgery', 'package'), 'TariffList.is_deleted' => 0)));

		$getService = $this->TariffList->find('list', array('conditions' => array('TariffList.service_category_id' => $this->ServiceCategory->getServiceGroupId("surgeryservices"), 'TariffList.is_deleted' => 0),'fields'=>array('id','name'),'order'=>array('name ASC')));

		$surgerycategory = $this->SurgeryCategory->find('list',array('conditions'=>array('SurgeryCategory.is_deleted'=>0,'SurgeryCategory.location_id'=>$this->Session->read('locationid'))));
		//  debug($surgerycategory);exit;
		$this->set('getTariffList', $getTariffList);
		$this->set('servicegroup', $servicegroup);
		$this->set('getService', $getService);
		$this->set('surgerycategory', $surgerycategory);


	}



	/**
	 * surgery edit
	 *
	 */
	public function edit($id = null) {
		$this->uses=array('TariffList','ServiceCategory', 'SurgeryCategory', 'SurgerySubcategory');
		$this->set('title_for_layout', __('Edit Surgery Detail', true));
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Surgery', true));
			$this->redirect(array("controller" => "surgeries", "action" => "index"));
		}
		if ($this->request->is('post') && !empty($this->request->data)) {
			$uploadFile = false;
			$this->request->data['Surgery']['location_id'] = $this->Session->read("locationid");
			$this->request->data['Surgery']['modify_time'] = date('Y-m-d H:i:s');
			$this->request->data['Surgery']['modified_by'] = $this->Auth->user('id');
			
			$this->Surgery->id = $this->request->data["Surgery"]['id'];
			$this->Surgery->save($this->request->data);
			if(!empty($_FILES['surgery_info_file_name']['name'])){
				$originalImageExtension  = explode(".",$_FILES['surgery_info_file_name']['name']);
				if(!isset($originalImageExtension[1])){
					$fileName= "surgeryInfo_".$this->Surgery->id.".".$originalImageExtension[0];
				}else{
					$fileName= "surgeryInfo_".$this->Surgery->id.".".$originalImageExtension[1];
				}
				$_FILES['surgery_info_file_name']['name'] = $fileName;
				$uploadFile = true;
			}
			if($uploadFile)
				$this->uploadSurgeryDoc();
			$errors = $this->Surgery->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The surgery has been updated', true));
				$this->redirect(array("controller" => "surgeries", "action" => "index"));
			}
		} else {
			$this->request->data = $this->Surgery->read(null, $id);
             
		}
		$getService = $this->TariffList->find('list', array('conditions' => array('TariffList.service_category_id' => $this->ServiceCategory->getServiceGroupId("surgeryservices"), 'TariffList.is_deleted' => 0),'fields'=>array('id','name'),'order'=>array('name ASC')));
		$this->set('getService',$getService);
		$servicegroup = $this->ServiceCategory->find('list',array('conditions'=>array('ServiceCategory.is_deleted'=>0,'ServiceCategory.location_id'=>$this->Session->read('locationid'))));
		$this->set('servicegroup', $servicegroup);
		$getTariffList = $this->TariffList->find('list', array('conditions' => array('TariffList.service_category_id' => $this->request->data['Surgery']['service_group'], 'TariffList.is_deleted' => 0, 'TariffList.location_id'=> $this->Session->read('locationid'))));
		$this->set('getTariffList', $getTariffList);
		$getAnaesthesiaTariffList = $this->TariffList->find('list', array('conditions' => array('TariffList.service_category_id' => $this->request->data['Surgery']['anaesthesia_service_group'], 'TariffList.is_deleted' => 0, 'TariffList.location_id'=> $this->Session->read('locationid'))));
		$this->set('getAnaesthesiaTariffList', $getAnaesthesiaTariffList);
		$surgerycategory = $this->SurgeryCategory->find('list',array('conditions'=>array('SurgeryCategory.is_deleted'=>0,'SurgeryCategory.location_id'=>$this->Session->read('locationid'))));
		$this->set('surgerycategory', $surgerycategory);
		$surgerysubcategory = $this->SurgerySubcategory->find('list',array('conditions'=>array('SurgerySubcategory.is_deleted'=>0,'SurgerySubcategory.surgery_category_id'=>$this->request->data['Surgery']['surgery_category_id'])));
		$this->set('surgerysubcategory', $surgerysubcategory);
	}

	/**
	 * surgery location delete
	 *
	 */
	public function delete($id = null) {
		$this->set('title_for_layout', __('Delete Surgery', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for surgery', true));
			$this->redirect(array("controller" => "surgeries", "action" => "index"));
		}
		if ($id) {
			$this->Surgery->deleteSurgery($this->request->params);
			$this->Session->setFlash(__('Surgery location deleted', true));
			$this->redirect(array("controller" => "surgeries", "action" => "index"));
		}
	}

	/**
	 * get services by xmlhttprequest
	 *
	 */
	public function getServices() {
		$this->loadModel('TariffList');
		if($this->params['isAjax']) {
			if($this->params->query['service_group']) {
				$this->set('services', $this->TariffList->find('all', array('fields'=> array('id', 'name'),'conditions' => array('TariffList.is_deleted' => 0, 'TariffList.service_category_id' => $this->params->query['service_group'], 'TariffList.location_id' => $this->Session->read('locationid')))));
			} else {
				$this->set('services', "");
			}
			$this->layout = 'ajax';
			$this->render('/Surgeries/ajaxgetservices');
		}
	}
	/**
	 * get anaesthesia services by xmlhttprequest
	 *
	 */
	public function getAnaesthesiaServices() {
		$this->loadModel('TariffList');
		if($this->params['isAjax']) {
			if($this->params->query['anaesthesia_service_group']) {
				$this->set('services', $this->TariffList->find('all', array('fields'=> array('id', 'name'),'conditions' => array('TariffList.is_deleted' => 0, 'TariffList.service_category_id' => $this->params->query['anaesthesia_service_group'], 'TariffList.location_id' => $this->Session->read('locationid')))));
			} else {
				$this->set('services', "");
			}
			$this->layout = 'ajax';
			$this->render('/Surgeries/ajaxget_anaesthesia_services');
		}
	}

	/**
	 * get surgery subcategory by xmlhttprequest
	 *
	 */
	public function getSurgerySubcategory() {
		$this->loadModel('SurgerySubcategory');
		if($this->params['isAjax']) {
			if($this->params->query['surgery_category']) {
				$this->set('surgery_subcategory', $this->SurgerySubcategory->find('all', array('fields'=> array('id', 'name'),'conditions' => array('SurgerySubcategory.is_deleted' => 0, 'SurgerySubcategory.surgery_category_id' => $this->params->query['surgery_category']))));
			} else {
				$this->set('surgery_subcategory', "");
			}
			$this->layout = 'ajax';
			$this->render('/Surgeries/ajaxget_subcategories');
		}
	}

	public function uploadSurgeryDoc(){
		//ini_set("post_max_size","10M");debug($_FILES);
		$target_dir = "uploads/surgeries_files/";
		$target_file = $target_dir . basename($_FILES["surgery_info_file_name"]["name"]);
		/*$uploadOk = 1;
		 $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);*/
		// Check if image file is a actual image or fake image

		/*$check = getimagesize($_FILES["surgery_info_file_name"]["tmp_name"]);
			if($check !== false) {
		echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
		} else {
		echo "File is not an image.";
		$uploadOk = 0;
		}*/
		// Check if file already exists
		/*if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
		$uploadOk = 0;
		}*/
		// Check file size
		/*if ($_FILES["surgery_info_file_name"]["size"] > 20000000) {
			echo "Sorry, your file is too large.";
		$uploadOk = 0;
		}*/
		// Allow certain file formats
		/*if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		 && $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
		}*/
		// Check if $uploadOk is set to 0 by an error
		/*if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {*/
		move_uploaded_file($_FILES["surgery_info_file_name"]["tmp_name"], $target_file);
		$this->Surgery->updateAll(array('surgery_info_file_name'=>"'".$_FILES["surgery_info_file_name"]["name"]."'"),
				array('id'=>$this->Surgery->id));
		/*	if (move_uploaded_file($_FILES["surgery_info_file_name"]["tmp_name"], $target_file)) {
		 echo "The file ". basename( $_FILES["surgery_info_file_name"]["name"]). " has been uploaded.";
		} else {
		echo "Sorry, there was an error uploading your file.";
		}*/
		//}
	}

}
?>