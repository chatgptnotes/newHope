<?php
/**
 * AnesthesiasController file
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
class AnesthesiasController extends AppController {

	public $name = 'Anesthesias';
	public $uses = array('Anesthesia');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email');
	
/**
 * Anesthesia listing
 *
 */	
	
	public function index() {
				$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'Anesthesia.create_time' => 'desc'
			        ),
			        'conditions' => array('Anesthesia.is_deleted' => 0, 'Anesthesia.location_id' => $this->Session->read("locationid"))
   				);
                $this->set('title_for_layout', __('Anesthesia', true));
                $this->Anesthesia->recursive = 0;
                $data = $this->paginate('Anesthesia');
                $this->set('data', $data);
	}

/**  
 * Anesthesia view
 *
 */
	public function view($id = null) {
		$this->uses = array('ServiceCategory', 'TariffList');
        $this->set('title_for_layout', __('Anesthesia Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Anesthesia', true));
			$this->redirect(array("controller" => "anesthesias", "action" => "index"));
		}
		$this->Anesthesia->bindModel(array(
								'belongsTo' => array( 										 
													'ServiceCategory' =>array('foreignKey' => 'service_group'),
													'TariffList'=>array('foreignKey'=>'tariff_list_id')	,
		                                            'AnesthesiaCategory'=>array('foreignKey'=>'anesthesia_category_id'),
		                                            'AnesthesiaSubcategory'=>array('foreignKey'=>'anesthesia_subcategory_id')													
													
												)),false); 
				
                $this->set('anesthesia', $this->Anesthesia->read(null, $id));
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
 * Anesthesia add
 *
 */
	public function add() {
                $this->uses=array('TariffList','ServiceCategory', 'AnesthesiaCategory');
                $this->set('title_for_layout', __('Add New Anesthesia', true));
                if ($this->request->is('post')) {
                        $this->request->data['Anesthesia']['location_id'] = $this->Session->read("locationid");
                        $this->request->data['Anesthesia']['create_time'] = date('Y-m-d H:i:s');
                        $this->request->data['Anesthesia']['created_by'] = $this->Auth->user('id');
                        $this->Anesthesia->create();
                      //  debug($this->request->data);exit;
                        $this->Anesthesia->save($this->request->data);
                        $errors = $this->Anesthesia->invalidFields();
			if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The Anesthesia has been saved', true));
			   $this->redirect(array("controller" => "anesthesias", "action" => "index"));
                        }
		} 
			   $servicegroup = $this->ServiceCategory->find('list',array('conditions'=>array('ServiceCategory.is_deleted'=>0,'ServiceCategory.location_id'=>$this->Session->read('locationid'))));
			  
			   $getTariffList = $this->TariffList->find('list', array('conditions' => array('TariffList.service_group' => array('anesthesia', 'package'), 'TariffList.is_deleted' => 0)));
			  // debug($getTariffList);exit;
			   $anesthesiacategory = $this->AnesthesiaCategory->find('list',array('conditions'=>array('AnesthesiaCategory.is_deleted'=>0,'AnesthesiaCategory.location_id'=>$this->Session->read('locationid'))));
              // debug($anesthesiacategory);exit;
               $this->set('getTariffList', $getTariffList);
               $this->set('servicegroup', $servicegroup);
               $this->set('anesthesiacategory', $anesthesiacategory);

	}

/**
 * Anesthesia edit
 *
 */
	public function edit($id = null) {
                $this->uses=array('TariffList','ServiceCategory', 'AnesthesiaCategory', 'AnesthesiaSubcategory');
                $this->set('title_for_layout', __('Edit Anesthesia Detail', true));
                if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Anesthesia', true));
                        $this->redirect(array("controller" => "anesthesias", "action" => "index"));
		}
                if ($this->request->is('post') && !empty($this->request->data)) {
                        $this->request->data['Anesthesia']['location_id'] = $this->Session->read("locationid");
                        $this->request->data['Anesthesia']['modify_time'] = date('Y-m-d H:i:s');
                        $this->request->data['Anesthesia']['modified_by'] = $this->Auth->user('id');
                        $this->Anesthesia->id = $this->request->data["Anesthesia"]['id'];
                        $this->Anesthesia->save($this->request->data);
			            $errors = $this->Anesthesia->invalidFields();
                        if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The Anesthesia has been updated', true));
			   $this->redirect(array("controller" => "anesthesias", "action" => "index"));
                        }
		} else {
                        $this->request->data = $this->Anesthesia->read(null, $id);
                       
                }
               
                $servicegroup = $this->ServiceCategory->find('list',array('conditions'=>array('ServiceCategory.is_deleted'=>0,'ServiceCategory.location_id'=>$this->Session->read('locationid'))));
				$this->set('servicegroup', $servicegroup);
				 $getTariffList = $this->TariffList->find('list', array('conditions' => array('TariffList.service_category_id' => $this->request->data['Surgery']['service_group'], 'TariffList.is_deleted' => 0, 'TariffList.location_id'=> $this->Session->read('locationid'))));
                $this->set('getTariffList', $getTariffList);
                 $getAnaesthesiaTariffList = $this->TariffList->find('list', array('conditions' => array('TariffList.service_category_id' => $this->request->data['Surgery']['anaesthesia_service_group'], 'TariffList.is_deleted' => 0, 'TariffList.location_id'=> $this->Session->read('locationid'))));
                $this->set('getAnaesthesiaTariffList', $getAnaesthesiaTariffList);
                $anesthesiacategory = $this->AnesthesiaCategory->find('list',array('conditions'=>array('AnesthesiaCategory.is_deleted'=>0,'AnesthesiaCategory.location_id'=>$this->Session->read('locationid'))));
                $this->set('anesthesiacategory', $anesthesiacategory);
                $anesthesiasubcategory = $this->AnesthesiaSubcategory->find('list',array('conditions'=>array('AnesthesiaSubcategory.is_deleted'=>0,'AnesthesiaSubcategory.anesthesia_category_id'=>$this->request->data['Anesthesia']['anesthesia_category_id'])));
                $this->set('anesthesiasubcategory', $anesthesiasubcategory);
	}

/**
 * Anesthesia location delete
 *
 */
	public function delete($id = null) {
                $this->set('title_for_layout', __('Delete Anesthesia', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Anesthesia', true));
			$this->redirect(array("controller" => "anesthesias", "action" => "index"));
		}
		if ($id) {
                        $this->Anesthesia->deleteAnesthesia($this->request->params);
                        $this->Session->setFlash(__('Anesthesia location deleted', true));
			$this->redirect(array("controller" => "anesthesias", "action" => "index"));
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
                   $this->render('/Anesthesias/ajaxgetservices');
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
                   $this->render('/Anesthesias/ajaxget_anaesthesia_services');
                }  
	}

/**
 * get Anesthesia subcategory by xmlhttprequest
 *
 */
	public function getAnesthesiaSubcategory() {
                $this->loadModel('AnesthesiaSubcategory');
                if($this->params['isAjax']) {
                   if($this->params->query['anesthesia_category']) {
                    $this->set('anesthesia_subcategory', $this->AnesthesiaSubcategory->find('all', array('fields'=> array('id', 'name'),'conditions' => array('AnesthesiaSubcategory.is_deleted' => 0, 'AnesthesiaSubcategory.anesthesia_category_id' => $this->params->query['anesthesia_category']))));
                   } else {
                   	$this->set('anesthesia_subcategory', "");
                   }
                   $this->layout = 'ajax';
                   $this->render('/Anesthesias/ajaxget_subcategories');
                }  
	}
	
	//function to add anaesthesia note 
	//Develoeped by Pranali S.
	public function anae($patient_id=null,$surgery_id=null){
		//fetch ot for selected patient.
		$this->uses = array('OptAppointment','AnaesthesiaNote','Department','Opt','Patient','ServiceCategory','Diagnosis') ;
		
		if($this->params->isAjax=='1'){
			$this->layout='ajax';
			$this->OptAppointment->bindModel(array('belongsTo' => array('Surgery' =>array('foreignKey' => 'surgery_id'))));
			
			$rgjayPackage = $this->ServiceCategory->getServiceGroupIdFromAlias('RGJAY Package');
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'Person' =>array('foreignKey' => false,'conditions'=>array('Patient.person_id=Person.id' )),
							'DoctorProfile' =>array('foreignKey' => false,'conditions'=>array('DoctorProfile.user_id =Patient.doctor_id')),
 							'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id =Patient.tariff_standard_id')),
							'ServiceBill' =>array('foreignKey' => false,'conditions'=>array('ServiceBill.patient_id =Patient.id','ServiceBill.service_id='.$rgjayPackage)),
							'TariffList' =>array('foreignKey' => false,'conditions'=>array('TariffList.id =ServiceBill.tariff_list_id')),
							'Diagnosis' =>array('foreignKey' => false,'conditions'=>array('Diagnosis.patient_id =Patient.id'))
					)),false);
			$MuraliData=$this->Patient->find('first',array('conditions'=>array('Patient.id'=>$patient_id)/*,'fields'=>array('DoctorProfile.doctor_name','TariffList.TariffList','Diagnosis.final_diagnosis')*/));
			
			$loadData=$this->AnaesthesiaNote->find('first',array('conditions'=>array('AnaesthesiaNote.patient_id'=>$patient_id,'AnaesthesiaNote.surgery_id'=>$MuraliData['TariffList']['id'])));
			//debug($loadData);

			$autocompleteRes=$this->OptAppointment->find('all',array('fields'=>array('OptAppointment.id','Surgery.name'),
				'conditions'=>array('OptAppointment.patient_id'=>$patient_id)));
	
			$returnArray = array();
			foreach ($autocompleteRes as $key=>$value) {
				$returnArray[$value['OptAppointment']['id']]=$value['Surgery']['name'];
			}//debug($MuraliData);
			$this->set('loadData',$loadData);
			$this->set('MuraliData',$MuraliData);
			$this->set('returnArray',$returnArray);
		}else{
			$this->layout='advance';
		}
		//after form submit
		if(!empty($this->request->data)){
			$subOne=$this->request->data['anae'];
			unset($this->request->data['anae']);
			$subTwo=$this->request->data;
			$final=array_merge($subOne,$subTwo);
			$final['surgery_id']=$final['surgeryname'];
			$result = $this->AnaesthesiaNote->saveAnaesthesiaNote($final);
			if($result){
				$this->Session->setFlash(__('Record added successfully', true));
			}else{
				$this->Session->setFlash(__('Please try again', true));
			}
			$this->redirect($this->referer()) ;
		}
		$problemData=$this->Diagnosis->find('list',array('fields'=>array('id','final_diagnosis'),'conditions'=>array('patient_id'=>$patient_id)));
		$this->set('problemData',$problemData);

		$data =$this->AnaesthesiaNote->find('first',array('conditions'=>array('AnaesthesiaNote.patient_id'=>$patient_id,'AnaesthesiaNote.surgery_id'=>$surgery_id)));
		
		$loadData1['AnaesthesiaNote']['anae_date']=$this->DateFormat->formatDate2Local($loadData1['AnaesthesiaNote']['anae_date'],Configure::read('date_format')); //if reacord is already added 
		
		if(!empty($data)){
			$this->request->data = $data  ;
		}	
		 
		$this->patient_info($patient_id); //retrive patient details
		//get department
		$otList= $this->OptAppointment->getSurgeryDetailsByID($surgery_id);
		$department = $this->Department->getDepartmentByID($this->patient_details['Patient']['department_id']);
		$this->set(array('department'=>$department,'otList'=>$otList,'otRoom'=>$otRoom,''));
	}
	//EOD operative notes
	
	public function anae_ajx($patient_id=null,$surgery_id=null){
		$this->uses=array('AnaesthesiaNote');
		$this->layout='ajax';
		$loadData1=$this->AnaesthesiaNote->find('first',array('conditions'=>array('AnaesthesiaNote.patient_id'=>$patient_id,'AnaesthesiaNote.surgery_id'=>$surgery_id)));
		$loadData1['AnaesthesiaNote']['anae_date']=$this->DateFormat->formatDate2Local($loadData1['AnaesthesiaNote']['anae_date'],Configure::read('date_format'));
			
		echo json_encode($loadData1['AnaesthesiaNote']);
		exit;
	}
	
	function anae_print($patient_id=null,$surgery_id=null){
	
		$this->anae($patient_id,$surgery_id) ;
		$this->layout = 'print' ;
	}
	function surgeryAutocomplete($patient_id){
		$location_id = $this->Session->read('locationid');
		$this->layout = "ajax";
		$this->uses = array('OptAppointment');
		$this->OptAppointment->bindModel(array('belongsTo' => array('Surgery' =>array('foreignKey' => 'surgery_id'))));
	
		$autocompleteRes=$this->OptAppointment->find('all',array('fields'=>array('OptAppointment.id','Surgery.name'),
				'conditions'=>array('Surgery.name like'=>'%'.$this->params->query['term'].'%','OptAppointment.patient_id'=>$patient_id)));
	
		$returnArray = array();
		foreach ($autocompleteRes as $key=>$value) {
			$returnArray[] = array( 'id'=>$value['OptAppointment']['id'],'value'=>$value['Surgery']['name']) ;
		}
		echo json_encode($returnArray);
		exit;
	}
}
?>