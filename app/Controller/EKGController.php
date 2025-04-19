<?php
/**
 * EKGController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       EKG Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gulshan Trivedi
 */

class EKGController extends AppController {
	//
	public $name = 'EKG';
	public $uses = array('EKG');
	public $helpers = array('Html','Form', 'Js','General');
	public $components = array('RequestHandler','Email', 'Session','ImageUpload');

	public function index(){
		//display default
	}
	public function add($patient_id=null){
	 	$this->layout = 'ajax' ;
		if(isset($this->request->data) && !empty($this->request->data)) {
			
			$this->request->data['EKG'] = $this->request->data;
			$this->request->data['EKG']['patient_id'] = $patient_id;
			$this->request->data['EKG']['modify_time'] = date("Y-m-d H:i:s");
			$this->request->data['EKG']['create_time'] =date('Y-m-d H:i:s');
			$this->request->data['EKG']['modified_by'] = $this->Session->read('userid');
			$this->request->data['EKG']['created_by'] = $this->Session->read('userid');
			$this->request->data['EKG']['location_id'] = $this->Session->read('locationid');
			$data= $this->EKG->save($this->request->data['EKG']);
			echo 'Record added successfully';			
		}else{
			echo 'Please enter data';			 
		}
		exit;
	}
	public function delete($ekg_id=null){
		if(!empty($ekg_id)){
			$this->loadModel('EKG');
			$this->EKG->save(array('id'=>$ekg_id,'is_deleted'=>1));
			$this->Session->setFlash(__('Record deleted successfully'),'default',array('class'=>'message'));
			$this->redirect($this->referer());
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
	}
	public function ekg_manager(){

		$this->uses=array('Patient','EKG');
		$this->set('data','');
		$role = $this->Session->read('role');
		$search_key['Patient.is_deleted'] = 0;
		$search_key['Patient.is_discharge'] = 0;

		$search_key['EKG.location_id']=$this->Session->read('locationid');

		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' ))
				)),false);
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array('foreignKey' => false,'conditions'=>array('User.initial_id=Initial.id' )),
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
						'Location' =>array('foreignKey' => 'location_id'),
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
						'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id =Patient.department_id' )),
						'EKG'=>array('foreignKey'=> false,'conditions'=>array('EKG.patient_id=Patient.id' ))
				)),false);
		$this->EKG->bindModel(array(
				'hasOne' => array(
						'Initial' =>array('foreignKey' => false,'conditions'=>array('Initial.id=User.initial_id' ))
				)),false);
		if(!empty($this->params->query)){
			$search_ele = $this->params->query  ;//make it get

			if(!empty($search_ele['lookup_name'])){
				$search_key['Patient.lookup_name like '] = "%".trim($search_ele['lookup_name'])."%" ;
			}if(!empty($search_ele['patient_id'])){
				$search_key['Patient.patient_id like '] = "%".trim($search_ele['patient_id']) ;
			}if(!empty($search_ele['admission_id'])){
				$search_key['Patient.admission_id like '] = "%".trim($search_ele['admission_id']) ;
			}if(!empty($search_ele['dob'])){
						$search_key['Person.dob like '] = "%".trim(substr($this->DateFormat->formatDate2STD($search_ele['dob'],Configure::read('date_format')),0,10));
			}if(!empty($search_ele['ssn_us'])){
						$search_key['Person.ssn_us like '] = $this->request->query['ssn_us']."%" ;
			}

			$search_key['EKG.is_deleted']=0;
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('Patient.id' => 'asc'),
					'fields'=> array('PatientInitial.name,Patient.lookup_name,history,EKG.id,cardiac_medication,pacemaker,check_one,assignment_accepted,EKG.patient_id,
							Patient.id,Patient.patient_id,Person.ssn_us,Person.dob,Department.name,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time, Initial.name'),
					'conditions'=>$search_key ,
					'group'=>array('EKG.patient_id')
			);

			$this->set('data',$this->paginate('Patient'));
		}else{
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('Patient.id' => 'asc'),
					'fields'=> array('PatientInitial.name,history,EKG.id,cardiac_medication,pacemaker,check_one,assignment_accepted,EKG.patient_id,Patient.lookup_name,
							Patient.id,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Department.name,Person.ssn_us,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time, Initial.name'),
					'conditions'=>$search_key,
					'group'=>array('EKG.patient_id')
			);

			$this->set('data',$this->paginate('Patient'));
		}
	}

	public function ekg_list($patient_id=null){
		$this->patient_info($patient_id);
		$this->uses=(array('EkgResult'));

		$this->EKG->bindModel(array(
				'hasOne' => array(
						'EkgResult' =>array('foreignKey'=>false,
								'conditions'=>array('EkgResult.ekg_id = EKG.id')),
				)));

		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'fields'=>array('EKG.id','history','pacemaker','assignment_accepted','cardiac_medication','EKG.patient_id','EkgResult.ekg_id','EkgResult.confirm_result','EkgResult.result_publish_date'),
				'conditions'=>array('EKG.patient_id'=>$patient_id,'is_deleted'=>0),
				'order' => array('EKG.id' => 'asc'),
				'group'=>'EKG.id'
		);
		$ekgData   = $this->paginate('EKG');
		$this->set(array('ekgData'=>$ekgData));
	}

	public function ekg_result($patient_id=null,$ekg_id=null){

		$this->uses=(array('EKG','EkgResult'));
		$this->patient_info($patient_id);
		$ekgData  = $this->EKG->find('all',array('conditions'=>array('patient_id'=>$patient_id,'id'=>$ekg_id,'is_deleted'=>0)));
		if(isset($this->request->data['EkgResult']['file_name']) && !empty($this->request->data['EkgResult']['file_name'])) {
			$this->request->data['EkgResult']['ekg_id'] = $this->request->data['EkgResult']['ekg_id'];
			$this->request->data['EkgResult']['patient_id'] = $patient_id;
			$this->request->data['EkgResult']['modify_time'] = date("Y-m-d H:i:s");
			$this->request->data['EkgResult']['create_time'] =date('Y-m-d H:i:s');
			$this->request->data['EkgResult']['modified_by'] = $this->Session->read('userid');
			$this->request->data['EkgResult']['created_by'] = $this->Session->read('userid');
			$this->request->data['EkgResult']['location_id'] = $this->Session->read('locationid');
			$this->request->data['EkgResult']['note'] = $this->request->data['EkgResult']['note'];
			//set publish date
			if($this->request->data['EkgResult']['confirm_result']==1){
				if(!empty($this->request->data['EkgResult']['result_publish_date'])){
					$this->request->data['EkgResult']['result_publish_date'] =
					$this->DateFormat->formatDate2STD($this->request->data['EkgResult']['result_publish_date'],Configure::read('date_format'));
				}
			}else{
				$this->request->data['EkgResult']['result_publish_date'] ='';
			}
			//--------------
			//BOF image upload
			$data  = $this->request->data ;
			$showError ='';
			if(!empty($data['EkgResult']['file_name']) && !empty($data['EkgResult']['file_name'])){
				$cntrad=0;
				foreach($data['EkgResult']['file_name'] as $uploadFiles){
					if(is_array($uploadFiles)){
						if($uploadFiles['name']) {
							$original_image_extension  = explode(".",$uploadFiles['name']);
							if(!isset($original_image_extension[1])){
								$imagename= $uploadFiles['name']."__".mktime().'.'.$original_image_extension[0];
								$imagedescription[] = $data['EkgResult']['description'][$cntrad];

							}else{
								$imagename= $original_image_extension[0]."__".mktime().'.'.$original_image_extension[1];
							}
							$requiredArray  = array('data' =>array('EKG'=>array('file_name'=>$uploadFiles,'description'=>$data['EkgResult']['description'][$cntrad])));
							$showError = $this->ImageUpload->uploadFile($requiredArray,'file_name','uploads/ekg',$imagename);

						}
						// file name is not null in table so here we put default value //
						if(empty($imagename)) {
							$imagename = '';

						}
						if(empty($data['EkgResult']['description'][$cntrad]))
						{
							$desc="";
						}
						else
						{
							$desc=$data['EkgResult']['description'][$cntrad];
						}
							
						$this->request->data["EkgResult"]['file_name']  = $imagename ;
						$this->request->data["EkgResult"]['description']  = $desc ;
							
					}
					$cntrad++;
					$data= $this->EkgResult->save($this->request->data);
					$this->EkgResult->id= '';
				}
			}else{	
				$data= $this->EkgResult->save($this->request->data);
			}
			//----------------
			$this->Session->setFlash(__('Record added successfully'),true,array('class'=>'message'));
			$this->redirect(array('action'=>'ekg_list',$patient_id));
		}
		$this->set('ekgData',$ekgData);
	
	}

	function view_result($patient_id =null,$ekg_id=null){
		$this->patient_info($patient_id);
		$this->uses=array('EkgResult');
		$resultData = $this->EkgResult->find('all',array('fields'=>array('id','patient_id','file_name','description','note','result_publish_date','ekg_id'),
				'conditions'=>array('EkgResult.patient_id'=>$patient_id,'EkgResult.ekg_id'=>$ekg_id)));
		$this->set('resultData',$resultData);
	}

	function incharge_ekg_result($patient_id =null,$ekg_id=null){
		$this->patient_info($patient_id);
		$this->uses=array('EkgResult');
		$data1 = $this->EkgResult->find('all',array('conditions'=>array('EkgResult.patient_id'=>$patient_id)));
		for($a=0;$a<count($data1);$a++){
			$b[]='"'.$this->webroot.'uploads/ekg/'.$data1[$a][EkgResult][file_name].'"';
			//	$c[]='"'.$data1[$a]['EkgResult']['description'].'"';
		}
		$this->set('data1',$data1);
		$this->set('b',$b);
		$this->set('c',$c);
		//save data
		if(!empty($this->request->data['EkgResult'])){
			$data  = $this->request->data ;
			$result =true ;
			//insert result publish date.
			if($this->request->data['EkgResult']['confirm_result']==1){
				//set publish date
				$this->request->data['EkgResult']['result_publish_date'] =
				$this->DateFormat->formatDate2STD($this->request->data['EkgResult']['result_publish_date'],Configure::read('date_format'));
			}else{
				$this->request->data['EkgResult']['result_publish_date'] ='';
			}
			$this->request->data['EkgResult']['modified_by'] = $this->Session->read('userid');
			$this->request->data['EkgResult']['modify_time'] = date("Y-m-d H:i:s");
			$this->request->data['EkgResult']['location_id'] = $this->Session->read('locationid');
			//EOF result date

			//BOF image upload
			$data  = $this->request->data ;
			$showError ='';
			if(!empty($data['EkgResult']['file_name']) && !empty($data['EkgResult']['file_name'])){
				$cntrad=0;
				foreach($data['EkgResult']['file_name'] as $uploadFiles){
					if(is_array($uploadFiles)){
						if($uploadFiles['name']) {
							$original_image_extension  = explode(".",$uploadFiles['name']);
							if(!isset($original_image_extension[1])){
								$imagename= $uploadFiles['name']."__".mktime().'.'.$original_image_extension[0];
								$imagedescription[] = $data['EkgResult']['description'][$cntrad];

							}else{
								$imagename= $original_image_extension[0]."__".mktime().'.'.$original_image_extension[1];
							}

							$requiredArray  = array('data' =>array('EKG'=>array('file_name'=>$uploadFiles,'description'=>$data['EkgResult']['description'][$cntrad])));
							$showError = $this->ImageUpload->uploadFile($requiredArray,'file_name','uploads/ekg',$imagename);

						}
						// file name is not null in table so here we put default value //
						if(empty($imagename)) {
							$imagename = '';

						}
						if(empty($data['EkgResult']['description'][$cntrad]))
						{
							$desc="";
						}
						else
						{
							$desc=$data['EkgResult']['description'][$cntrad];
						}
							
						$this->request->data["EkgResult"]['file_name']  = $imagename ;
						$this->request->data["EkgResult"]['description']  = $desc ;
							
					}
					
					$cntrad++;
					$data= $this->EkgResult->save($this->request->data);
					$this->EkgResult->id= '';
				}

			}else{
				$data= $this->EkgResult->save($this->request->data);
			}
			$this->Session->setFlash(__('Record added successfully'),true,array('class'=>'message'));
			$this->redirect(array('action'=>'ekg_list',$patient_id));
			//----------------
		}
		$data = $this->EkgResult->find('all',array('conditions'=>array('EkgResult.patient_id'=>$patient_id,'EkgResult.ekg_id'=>$ekg_id)));
		$this->set(array('data'=>$data));
	}
	public  function delete_report($patient_id=null,$ekg_id=null){
		if(!empty($patient_id) && !empty($ekg_id)){
			$this->uses = array('EkgResult');
			$queryRes = $this->EkgResult->read(array('file_name'),$ekg_id);

			$this->EkgResult->id = $ekg_id ;
			//$isRename = rename("uploads/radiology/".$queryRes['RadiologyReport']['file_name'], "uploads/radiology/"."inactive_".$queryRes['RadiologyReport']['file_name']);
			$isRename = unlink("uploads/ekg/".$queryRes['EkgResult']['file_name']);
			if($isRename){
				//$result  = $this->EkgResult->save(array('is_deleted'=>1));
				$this->EkgResult->id = $ekg_id;
				$result  = $this->EkgResult->delete();
			}else{
				$this->Session->setFlash(__('There is some problem while deleting record, please try again'),'default',array('class'=>'error'));
				$this->redirect(array('action'=>'incharge_ekg_result',$patient_id,$ekg_id));
			}
			if($result){
				$this->Session->setFlash(__('Record deleted successfully'),'default',array('class'=>'message'));
				$this->data = array('EKG'=>array('id'=>$ekg_id));
				$this->redirect(array('action'=>'incharge_ekg_result',$patient_id,$ekg_id));
			}
		}else{
			$this->Session->setFlash(__('There is some problem , please try again'),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'incharge_ekg_result',$patient_id,$ekg_id));

		}

	}
	public function edit_investigation_ekg($ekg_id,$patient_id){
		$this->layout = 'ajax' ;
		$this->uses = array('EKG'); 
		$test_data = $this->EKG->find('first',array('conditions'=>array('EKG.id'=>$ekg_id)));
		//BOF Gaurav
		echo json_encode($test_data);exit;
		/*$this->data = $test_data;
		$this->render('add');*/
		//EOF Gaurav
	}
}
