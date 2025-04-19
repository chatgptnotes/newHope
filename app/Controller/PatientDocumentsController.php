<?php
/**
 * PatientCentricDepartmentsController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class PatientDocumentsController extends AppController {
	public $name = 'PatientDocuments';
	public $uses = array('PatientDocument');
	public $helpers = array('Html','Form', 'Js','DateFormat','General');
	public $components = array('RequestHandler','Email','Cookie','ImageUpload','QRCode','dateFormat','GibberishAES');

	/**
	 * operation theature listing
	 *
	*/

	public function index($id = null) {
		$this->layout = 'advance';	
		$this->set('patientId',$id); 
		$this->uses = array('PatientDocumentType','Patient','TariffList','Radiology');		
		if($id){
			$this->patient_info($id);
			$conditions = array('PatientDocument.patient_id'=>$id,'PatientDocument.is_deleted' => 0,'PatientDocument.location_id' => $this->Session->read("locationid"));
		}else{
			$id =0;
			$patient['Patient']['id'] = $id;
			$this->set('patient', $patient);
			$conditions = array('PatientDocument.is_deleted' => 0,'PatientDocument.location_id' => $this->Session->read("locationid"));
		}
		$this->Patient->unbindModel(array('hasMany'=>array('PharmacySalesBill' ,'InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array('belongsTo' => array(
				'PatientDocument' =>array('foreignKey'=>false, 'conditions' => array('Patient.id=PatientDocument.patient_id')),
				'Person' =>array('foreignKey'=>false, 'conditions' => array('Person.id=Patient.person_id')),
				'Diagnosis' =>array('foreignKey'=>false, 'conditions' => array('Diagnosis.patient_id=Patient.id')),
				'TariffStandard'=>array('foreignKey'=>false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),	
		)),false);
		$patientData=$this->Patient->find('first',array('fields'=>array('TariffStandard.name','Patient.patient_id','Patient.lookup_name','Patient.admission_id','Person.dob','Diagnosis.final_diagnosis'),'conditions'=>array('Patient.id'=>$id)));
		
		$this->set('patientData',$patientData);
		//debug($this->request->query);
		if(!empty($this->request->query['lookup_name'])){
			$search_key['PharmacyMaster.Pharmacy_Fax like '] = trim($this->params->query['fax'])."%" ;
			$conditions = array('PatientDocument.is_deleted' => 0,
					'PatientDocument.location_id' => $this->Session->read("locationid"),
					'PatientDocument.patient_id' => trim($this->request->query['patient_id']));
			
		}
		//exit;
		$this->PatientDocument->bindModel(array('belongsTo' => array(
				'Patient' =>array('foreignKey'=>false, 'conditions' => array('Patient.id=PatientDocument.patient_id')),
				'Person' =>array('foreignKey'=>false, 'conditions' => array('Person.id=Patient.person_id')),
		)),false);
		$data=$this->PatientDocument->find('all',array('fields'=>array('PatientDocument.type','PatientDocument.size','PatientDocument.type_report','PatientDocument.size_report','PatientDocument.document_id','PatientDocument.filename_report','PatientDocument.date','PatientDocument.comment','PatientDocument.filename','Person.dob','Person.photo','PatientDocument.id','PatientDocument.name','PatientDocument.document_description','PatientDocument.patient_id','PatientDocument.create_time','PatientDocument.sign_document','PatientDocument.bill_amount'),'conditions' => $conditions,'order' => array('PatientDocument.id' => 'DESC')));

		

		/*$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('PatientDocument.id' => 'DESC'),
				'fields'=>array('PatientDocument.type','PatientDocument.size','PatientDocument.type_report','PatientDocument.size_report','PatientDocument.document_id','PatientDocument.filename_report','PatientDocument.date','PatientDocument.comment','PatientDocument.filename','Person.dob','Person.photo','PatientDocument.id','PatientDocument.name','PatientDocument.document_description','PatientDocument.patient_id','PatientDocument.create_time','PatientDocument.sign_document','PatientDocument.bill_amount'),
				'conditions' => $conditions
		);
		
		$data=$this->paginate('PatientDocument');	*/	
		foreach($data as $key=>$datass){		
			$getUnSerDoc[$datass['PatientDocument']['id']]=unserialize($datass['PatientDocument']['document_id']);
			
			$getUnSerDoc[$datass['PatientDocument']['id']]=array_filter($getUnSerDoc[$datass['PatientDocument']['id']]);
			//$getUnSerDoc[$datass['PatientDocument']['id']]=array_reverse($getUnSerDoc[$datass['PatientDocument']['id']]);
			$this->set('getUnSerDoc',$getUnSerDoc);
			$tariffListData[$datass['PatientDocument']['id']]= $this->Radiology->findRadiologyListByIds($getUnSerDoc[$datass['PatientDocument']['id']]);
		
		
		}

		//debug($tariffListData);
	
		$this->set('tariffListData',$tariffListData);
		

		//$this->PatientDocument->recursive = 0;
		if(empty($data)){	

			if($id=='0' || empty($id)){
				$id=$this->request->query['patient_id'];
			}
			if($this->params->query['flagBack']=='1'){
				$this->set('data', $data);
			}else{
				$this->redirect(array("controller" => "PatientDocuments", "action" => "add",$id));			
			}
				
		}else{
			$this->set('data', $data);
		}	
	}

	public function add($id = null){		
		$this->uses = array('ServiceProvider','ServiceCategory','PatientDocument','Patient','PatientDocumentType','User','Message','RadiologyTestOrder','Configuration');
		$this->set('patientId',$id);
		$this->layout = 'advance';			
		//if($id != 0) {
			$this->patient_info($id);
		/*}else{
			$id =0;
			$patient['Patient']['id'] = $id;
			$this->set('patient', $patient);
		} */
		$this->Patient->unbindModel(array('hasMany'=>array('PharmacySalesBill' ,'InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array('belongsTo' => array(
				'PatientDocument' =>array('foreignKey'=>false, 'conditions' => array('Patient.id=PatientDocument.patient_id')),
				'Person' =>array('foreignKey'=>false, 'conditions' => array('Person.id=Patient.person_id')),
				'Diagnosis' =>array('foreignKey'=>false, 'conditions' => array('Diagnosis.patient_id=Patient.id')),
				'TariffStandard'=>array('foreignKey'=>false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
		)),false);
		
		$patientData=$this->Patient->find('first',array('fields'=>array('PatientDocument.id','TariffStandard.name','Patient.patient_id','Patient.lookup_name','Person.dob','Diagnosis.final_diagnosis'),'conditions'=>array('Patient.id'=>$id)));
		
		$this->set('patientData',$patientData);
		//BOF-For Fetch already put radiology services from billing page
		if(empty($patientData['PatientDocument']['id'])){
			$getHopeProvider=$this->ServiceProvider->getServiceProviderIdAllByCateggoryAndName(Configure::read('radiologyservices'),Configure::read('service_providers'));	
			
			$this->RadiologyTestOrder->bindModel(array('belongsTo' => array(
					'Radiology' =>array('foreignKey'=>false, 'conditions' => array('Radiology.id=RadiologyTestOrder.radiology_id')),
			)),false);
			
			$radiologyNameData=$this->RadiologyTestOrder->find('all',array('fields'=>array('Radiology.id','Radiology.name','RadiologyTestOrder.id'),'conditions'=>array('RadiologyTestOrder.patient_id'=>$id,'RadiologyTestOrder.service_provider_id'=>$getHopeProvider)));
			$this->set('radiologyNameData',$radiologyNameData);
		}
		//EOF-For Fetch already put radiology services from billing page
		
	
		if ($this->request->is('post')) {			
			$this->request->data['document_id']=array_values($this->request->data['document_id']);
			$this->request->data['filename']=array_values($this->request->data['filename']);
			$this->request->data['filename_report']=array_values($this->request->data['filename_report']);			
			foreach($this->request->data['filename'] as $key=>$file1){				
				if(!empty($file1['name'])){
				//creating runtime image name
				$original_image_extension[$key]  = explode(".",$file1['name']);				
				if(!isset($original_image_extension[$key][1])){					
					$imagename[$key]= $file1['name']."_img_".mktime().'.'.$original_image_extension[$key][0];
				}else{
					$imagename[$key]= $file1['name']."_img_".mktime().'.'.$original_image_extension[$key][1];
				}
				
				$requiredArray[$key]  = array('data' =>array('PatientDocument'=>array('filename'=>$file1)));			
			
				$showError[$key] = $this->ImageUpload->uploadFile($requiredArray[$key],'filename','uploads/user_images',$imagename[$key],2048);				
				}
				//debug($this->ImageUpload);
				//exit;
			if(empty($showError[$key])) {
				// making thumbnail of 100X100
				$this->ImageUpload->load($file1['tmp_name']);
				$this->ImageUpload->resize(100,100);
				$this->ImageUpload->save('uploads/user_images/thumbnail/'.$imagename[$key]);					
			}

			if(!empty($this->request->data['filename_report'][$key]['name'])){

				$original_image_extension1[$key]  = explode(".",$this->request->data['filename_report'][$key]['name']);				
				if(!isset($original_image_extension1[$key][1])){
					$imagename1[$key]= $this->request->data['filename_report'][$key]['name'].'_doc_'.mktime().'.'.$original_image_extension1[$key][0];
				}else{
					$imagename1[$key]= $this->request->data['filename_report'][$key]['name'].'_doc_'.mktime().'.'.$original_image_extension1[$key][1];
				}
				//debug($imagename);
				$requiredArray1[$key]  = array('data' =>array('PatientDocument'=>array('filename_report'=>$this->request->data['filename_report'][$key])));			
			
				$showError1[$key] = $this->ImageUpload->uploadFile($requiredArray1[$key],'filename_report','uploads/user_images',$imagename1[$key],2048);
				
			}
			if(empty($showError1[$key])) {
				// making thumbnail of 100X100
				$this->ImageUpload->load($this->request->data['filename_report'][$key]['tmp_name']);
				$this->ImageUpload->resize(100,100);
				$this->ImageUpload->save('uploads/user_images/thumbnail/'.$imagename1[$key]);					
			}
			$file_tmp[$key] = $file1['tmp_name'];
			$filesize[$key] = $file1['size'];
			$fileType[$key] = $file1['type'];

			$file_tmp1[$key] = $this->request->data['filename_report'][$key]['tmp_name'];
			$filesize1[$key] = $this->request->data['filename_report'][$key]['size'];
			$fileType1[$key] = $this->request->data['filename_report'][$key]['type'];
			}
			
			//debug($showError);exit;
			//$file_name = $this->request->data['PatientDocument']['document']['name'];
			//$dob = $this->DateFormat->formatDate2STD($this->request->data["PatientDocument"]['dob'],Configure::read('date_format'));
			//if(empty($dob))$dob=$patientData["Person"]['dob'];
			$date = $this->DateFormat->formatDate2STD($this->request->data["PatientDocument"]['date'],Configure::read('date_format'));
		
		
			$this->request->data['PatientDocument']['location_id'] = $this->Session->read("locationid");
			$this->request->data['PatientDocument']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['PatientDocument']['created_by'] = $this->Auth->user('id');
			$this->request->data['PatientDocument']['patient_id'] = $this->request->data['PatientDocument']['patient_id'];

			$this->request->data['PatientDocument']['date'] =$date;
			//$this->request->data['PatientDocument']['dob']=$dob;
			$this->request->data['PatientDocument']['type'] = serialize($fileType);
			$this->request->data['PatientDocument']['document_description'] = trim($this->request->data['PatientDocument']['document_description']);
			$this->request->data['PatientDocument']['size'] = serialize($filesize);
			$this->request->data['PatientDocument']['size_report'] = serialize($filesize1);
			$this->request->data['PatientDocument']['type_report'] = serialize($fileType1);

		
			$this->request->data['PatientDocument']['filename'] = serialize($imagename);
			$this->request->data['PatientDocument']['filename_report'] = serialize($imagename1);
			//$this->request->data['PatientDocument']['name'] = $patientData["Patient"]['lookup_name'];
			$this->request->data['PatientDocument']['patient_id'] = $id;

			$this->request->data['PatientDocument']['document_id'] = serialize($this->request->data['document_id']);
			if(!empty($this->request->data['rad_test_order_id'])){
				$this->request->data['PatientDocument']['rad_test_order_id'] = serialize($this->request->data['rad_test_order_id']);
			}
			$this->request->data['PatientDocument']['note'] = $this->request->data['RadiologyResult']['note'];
			
			$this->PatientDocument->create();
				
			$this->PatientDocument->save($this->request->data);
			/*$log = $this->PatientDocument->getDataSource()->getLog(false, false);
			debug($log);*/
			$errors = $this->PatientDocument->invalidFields();
			//debug($errors);
			//exit;
			
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
					///BOF-Mahalaxmi-For send SMS to Physician and Patient					
				/*	$smsActive=$this->Configuration->getConfigSmsValue('External Radiology Request');				
					if($smsActive){											
						$getFullUserName=$this->Session->read("first_name")." ".$this->Session->read("last_name");
						if(empty($patientData['Diagnosis']['final_diagnosis'])){
							$showMsg= sprintf(Configure::read('upload_withoutdia'),$getFullUserName,$patientData['Patient']['lookup_name']);
						}else{
							$showMsg= sprintf(Configure::read('upload'),$getFullUserName,$patientData['Patient']['lookup_name'],$patientData['Diagnosis']['final_diagnosis']);
						}						
						$getResuSms4=$this->Message->sendToSms($showMsg,Configure::read('upload_mobile_no')); //for admit to send SMS to Patient					
					}	*/		
					///EOF-Mahalaxmi-For send SMS to Physician And Patient
			}
	
			
			$this->Session->setFlash(__('The Patient Documents has been saved', true));
			$this->redirect(array("controller" => "PatientDocuments", "action" => "index",$id));		
		}		
	}
	public function edit($id = null,$documentID = null) {

		$this->layout = 'advance';
		/*if(!isset($id) && !isset($documentID)){			
			$this->Session->setFlash(__('Invalid ID', true));
			$this->redirect(array("controller" => "patient_documents", "action" => "index",$id));
		}*/


		$this->uses =array('PatientDocumentType','User','Patient','ServiceCategory','Radiology');
		//$radiologyCategoryId = $this->ServiceCategory->getServiceGroupId('radiologyservices'); //Radiology is name of config variable		
		//$this->set('radiologyCategoryId',$radiologyCategoryId);

		$this->Patient->bindModel(array(
				'belongsTo'=>array(		
							'TariffStandard'=>array('foreignKey'=>false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),	
							'Diagnosis' =>array('foreignKey'=>false, 'conditions' => array('Diagnosis.patient_id=Patient.id')),
				)),false);	
		$patientData  = $this->Patient->find('first',array('fields'=>array('Diagnosis.final_diagnosis','TariffStandard.name','Patient.lookup_name','Patient.patient_id'),'conditions' => array('Patient.id'=>$id)));
		$this->set('patientData',$patientData);
		$this->set('patientId',$id);	

		$this->PatientDocument->bindModel(array('belongsTo' => array(
				'PatientDocumentType' =>array('foreignKey'=>false, 'conditions' => array('PatientDocumentType.id=PatientDocument.document_id')),
		)),false);

		
		$data = $this->PatientDocument->read(null,$documentID);		
					
		$getUnSerDoc[$data['PatientDocument']['id']]=unserialize($data['PatientDocument']['document_id']);
		
		$getUnSerDoc=array_filter($getUnSerDoc);				
		//$tariffListData= $this->TariffList->find('list',array('fields'=>array('id','name'),'conditions' => array('TariffList.id'=>$getUnSerDoc[$data['PatientDocument']['id']])));
		$tariffListData= $this->Radiology->findRadiologyListByIds($getUnSerDoc[$data['PatientDocument']['id']]);
		
		$this->set('tariffListData',$tariffListData);
		
		$this->set('data', $data);


		$this->set('title_for_layout', __('Edit Patient Documents', true));
		if ($this->request->is('post')) {
			//debug($this->request->data);
			if($this->request->data['type'] == "document" && (empty($this->data['PatientDocument']['document']['tmp_name']) && empty($data['PatientDocument']['filename']))){
				$errors["name"] = array(0=>"Please Upload the Document.");
			}/*else if($this->request->data['type'] == "url" && empty($this->data['PatientDocument']['link'])){
				$this->set('forUrl', "true");
				$errors["name"] = array(0=>"Please Enter the URL for the Document.");
			}*/else if (!empty($this->data['PatientDocument']['document']['tmp_name']) && !is_uploaded_file($this->data['PatientDocument']['document']['tmp_name'])) {
				$errors["name"] = array(0=>"Some error Occur while Uploading the Document.");
			}else{
				$imagename=array();
				$imagename1=array();
				$img1Arr=array();
				$img2Arr=array();
				foreach($this->request->data['filename'] as $key=>$file1){
					
				if(!empty($file1['name'])){
				//if($this->request->data['type']){					
					$file_name = $this->request->data['PatientDocument']['document']['name'];					
					$file_tmp = $this->data['PatientDocument']['document']['tmp_name'];
					$filesize = $this->request->data['PatientDocument']['document']['size'];
					$extract = fopen($file_tmp, 'r');
					$content = fread($extract, $filesize);
					$path_parts = pathinfo($file_name);
					$file_name = mt_rand().".".$path_parts['extension'];
					
					fclose($extract);
						
						
					//if(!empty($file1['name'])){
						//creating runtime image name
						$original_image_extension[$key]  = explode(".",$file1['name']);
						if(!isset($original_image_extension[$key][1])){
							$imagename[$key]= $file1['name']."_img_".mktime().'.'.$original_image_extension[$key][0];
						}else{
							$imagename[$key]= $file1['name']."_img_".mktime().'.'.$original_image_extension[$key][1];
						}
						$requiredArray[$key]  = array('data' =>array('PatientDocument'=>array('filename'=>$file1)));		
			
				$showError1[$key] = $this->ImageUpload->uploadFile($requiredArray[$key],'filename','uploads/user_images',$imagename[$key],2048);		//}
					if(empty($showError1[$key])) {
						// making thumbnail of 100X100
						$this->ImageUpload->load($file1['tmp_name']);
						$this->ImageUpload->resize(100,100);
						$this->ImageUpload->save("uploads/user_images/thumbnail/".$imagename[$key]);
							
					}
					
				}else{
					$this->request->data['filename1']=array_values($this->request->data['filename1']);		
				}



				if(!empty($this->request->data['filename_report'][$key]['name'])){
					if(!empty($this->request->data['filename_report'][$key]['name'])){
						//creating runtime image name
						$original_image_extension1[$key]  = explode(".",$this->request->data['filename_report'][$key]['name']);
						if(!isset($original_image_extension1[$key][1])){
							$imagename1[$key]= $this->request->data['filename_report'][$key]['name']."_doc_".mktime().'.'.$original_image_extension1[$key][0];
						}else{
							$imagename1[$key]= $this->request->data['filename_report'][$key]['name']."_doc_".mktime().'.'.$original_image_extension1[$key][1];
						}
						$requiredArray2[$key]  = array('data' =>array('PatientDocument'=>array('filename_report'=>$this->request->data['filename_report'][$key])));		
			
				$showError2[$key] = $this->ImageUpload->uploadFile($requiredArray2[$key],'filename_report','uploads/user_images',$imagename1[$key],2048);		
				}
					if(empty($showError2[$key])) {
						// making thumbnail of 100X100
						$this->ImageUpload->load($this->request->data['filename_report'][$key]['tmp_name']);
						$this->ImageUpload->resize(100,100);
						$this->ImageUpload->save("uploads/user_images/thumbnail/".$imagename1[$key]);
							
					}
					
				}else{
					$this->request->data['filename_report1']=array_values($this->request->data['filename_report1']);	
				
				}
				}
				//$this->request->data["PatientDocument"]['dob'] = $this->DateFormat->formatDate2STD($this->request->data["PatientDocument"]['don'],Configure::read('date_format'));
			$imagename=array_filter($imagename);
			$this->request->data['filename1']=array_filter($this->request->data['filename1']);
			$imagename1=array_filter($imagename1);
			$this->request->data['filename_report1']=array_filter($this->request->data['filename_report1']);
			
			$img1Arr=$imagename+$this->request->data['filename1'];
			$img2Arr=$imagename1+$this->request->data['filename_report1'];
			//$img1Arr=array_merge($imagename,$this->request->data['filename1']);
			//debug($imagename1);
			//debug($this->request->data['filename_report1']);
			//$img2Arr=array_merge($imagename1,$this->request->data['filename_report1']);
			//debug($img1Arr);
			//debug($img2Arr);
			//$img1Arr=array_values($img1Arr);
			//$img2Arr=array_values($img2Arr);
			
			$this->request->data['PatientDocument']['filename'] = serialize($img1Arr);
			$this->request->data['PatientDocument']['filename_report'] =  serialize($img2Arr);
				$date = $this->DateFormat->formatDate2STD($this->request->data["PatientDocument"]['date'],Configure::read('date_format'));
				$this->request->data['document_id']=array_values($this->request->data['document_id']);
				$this->request->data['PatientDocument']['document_id'] = serialize($this->request->data['document_id']);
		
				$this->request->data['PatientDocument']['modify_time'] = date('Y-m-d H:i:s');
				$this->request->data['PatientDocument']['modified_by'] = $this->Auth->user('id');
				$this->request->data['PatientDocument']['date'] = $date;
				$this->request->data['PatientDocument']['document_description'] = trim($this->request->data['PatientDocument']['document_description']);
				
				$this->request->data['PatientDocument']['note'] = $this->request->data['RadiologyResult']['note'];
			
		
				$this->PatientDocument->id = $documentID;
		//debug($this->request->data);
		//exit;
				$this->PatientDocument->save($this->request->data);
				$errors = $this->PatientDocument->invalidFields();				
			}
				

			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				
				$this->Session->setFlash(__('The Patient Documents has been saved', true));
				$this->redirect(array("controller" => "PatientDocuments", "action" => "index",$id));
			}
		}
		if($id != 0){
			$this->patient_info($id);
		}else{
			$id =0;
			$patient['Patient']['id'] = $id;
			$this->set('patient', $patient);
		}


	}

	public function view($id = null,$documentID = null) {
		$this->layout = 'advance';
		$this->uses =array('PatientDocumentType','User','Patient');
		if($id == null || $documentID == null){
			$this->Session->setFlash(__('Invalid ID', true));
			$this->redirect(array("controller" => "patient_documents", "action" => "index",$id));
		}
		if($id != 0){
			$this->patient_info($id);
		}else{
			$id =0;
			$patient['Patient']['id'] = $id;
			$this->set('patient', $patient);
		}
		

		$patientData  = $this->Patient->find('first',array('fields'=>array('lookup_name','patient_id'),'conditions' => array('Patient.id'=>$id)));
		$this->set('patientData',$patientData);
		//$document_list  = $this->PatientDocumentType->find('list',array('fields'=>array('name'),'order' => array('name ASC')));
		//pr($document_list);
		//$this->set('document_list',$document_list);
		//$this->set('registrar',$this->User->getDoctorsByLocation($this->Session->read('locationid')));
		$this->PatientDocument->bindModel(array('belongsTo' => array(
				'PatientDocumentType' =>array('foreignKey'=>false, 'conditions' => array('PatientDocumentType.id=PatientDocument.document_id')),
		)),false);

		/*$this->PatientDocument->bindModel(array('belongsTo' => array(
				'User' =>array('foreignKey'=>false, 'conditions' => array('User.id=PatientDocument.sb_registrar')),
		)),false);*/


		$data = $this->PatientDocument->read(null,$documentID);		
		$this->set('data', $data);

	}


	public function download($id = null,$documentID = null,$itemId=null,$flag=null) {		
		$this->layout = false ;
		$this->autoRender = false ;
		$data = $this->PatientDocument->read(null,$documentID);
		//header("Content-Disposition: attachment; filename=".basename($data['PatientDocument']['filename']));
		/*ob_clean();
		 ob_start();
		//header("Content-type:".$data['PatientDocument']['type']."");
		//header('Content-Type: image/png');
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($data['PatientDocument']['filename']).'"'); //<<< Note the " " surrounding the file name
		//header('Content-Transfer-Encoding: binary');
		header('Cache-Control: max-age=0');
		header("Pragma:public");
		header("Content-length: ".$data['PatientDocument']['size']);
		//header('Content-Length: ' . filesize($file));
		//ob_clean();
		//flush();
		readfile("uploads".DS."user_images".DS.$data['PatientDocument']['filename']) ;
		//exit();*/

		if($flag=="docreport2"){
		$file1=unserialize($data['PatientDocument']['filename_report']);
		$fileType1=unserialize($data['PatientDocument']['type_report']);
		$fileSize1=unserialize($data['PatientDocument']['size_report']);
		
		
		foreach($file1 as $key=>$files1){
			if($key==$itemId){
				$file = $files1;
				$filetype=$fileType1[$key];
				$filelength=$fileSize1[$key];
			}else{
				continue;
			}
		}
		}else{
			$file1=unserialize($data['PatientDocument']['filename']);
		$fileType1=unserialize($data['PatientDocument']['type']);
		$fileSize1=unserialize($data['PatientDocument']['size']);
		
		
		foreach($file1 as $key=>$files1){
			if($key==$itemId){
				$file = $files1;
				$filetype=$fileType1[$key];
				$filelength=$fileSize1[$key];
			}else{
				continue;
			}
		}
		}
		
		//$file = $documentID;
		header('Content-disposition: attachment; filename='.$file);
		//header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-type:".$filetype."");
		header('Content-Length: ' . $filelength);
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		ob_clean();
		flush();
		readfile("uploads".DS."user_images".DS.$file);

		exit;

	}
	/**
	 * operation theature delete
	 *
	 */
	public function delete($id = null,$documentID = null) {

		if ($id || $id == 0) {
			$this->PatientDocument->id = $documentID;
			$this->request->data['PatientDocument']['is_deleted'] =1;
			$this->PatientDocument->save($this->request->data);
			$this->Session->setFlash(__('Patient Documents deleted', true));
		}else{
			$this->Session->setFlash(__('Invalid id for Patient Documents', true));
		}
		$this->redirect($this->referer());
	}

	public function sign_document($id = null,$documentID = null) {
		if ($id || $id == 0) {
			$this->PatientDocument->id = $documentID;

			$this->request->data['PatientDocument']['sign_document'] =1;
			$this->PatientDocument->save($this->request->data);
			$this->Session->setFlash(__('Patient Documents Signed', true));
		}else{
			$this->Session->setFlash(__('Invalid id for Patient Documents', true));
		}
		$this->redirect($this->referer());
	}

	public function unsign_document($id = null,$documentID = null) {
		if ($id || $id == 0) {
			$this->PatientDocument->id = $documentID;
			$this->request->data['PatientDocument']['sign_document'] =0;
			$this->PatientDocument->save($this->request->data);
			$this->Session->setFlash(__('Patient Documents Unsigned', true));
		}else{
			$this->Session->setFlash(__('Invalid id for Patient Documents', true));
		}
		$this->redirect($this->referer());
	}



	public function view_document($id = null,$documentID = null) {
		if($id == null || $documentID == null){
			$this->Session->setFlash(__('Invalid ID', true));
			$this->redirect(array("controller" => "patient_documents", "action" => "index",$id));
		}
		$this->uses =array('PatientDocumentType','User');
		$document_list  = $this->PatientDocumentType->find('list',array('fields'=>array('name'),'order' => array('name ASC')));

		$this->set('document_list',$document_list);
		$this->set('registrar',$this->User->getDoctorsByLocation($this->Session->read('locationid')));


		$this->PatientDocument->bindModel(array('belongsTo' => array(
				'PatientDocumentType' =>array('foreignKey'=>false, 'conditions' => array('PatientDocumentType.id=PatientDocument.document_id')),
		)),false);

		$this->PatientDocument->bindModel(array('belongsTo' => array(
				'User' =>array('foreignKey'=>false, 'conditions' => array('User.id=PatientDocument.sb_registrar')),
		)),false);


		$data = $this->PatientDocument->read(null,$documentID);
		$this->set('data', $data);
		$this->patient_info($id);
	}

	/**
	 * patient document master listing
	 *
	 */

	function patient_document_master($id=null)
	{
		//debug($data);exit;

		$this->uses = array('PatientDocumentMaster','PatientDocument');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'PatientDocumentMaster.name' => 'asc'
				),
				'conditions' => array('PatientDocumentMaster.is_deleted' => 0,'PatientDocumentMaster.location_id'=> $this->Session->read("locationid"))
		);
		$this->set('title_for_layout', __('Patient Document Master', true));
		$this->PatientDocumentMaster->recursive = 0;
		$data = $this->paginate('PatientDocumentMaster');
		//debug($data);
		$this->set('data', $data);
		//$order_category = $this->OrderCategory->find('list', array('fields'=> array('OrderCategory.id','OrderCategory.order_category'),'conditions'=>array('OrderCategory.is_active'=>1)));
		//debug($order_category);exit;
		//$this->set('order_category',$order_category);
	}

	function add_patient_document_master($id=null)
	{
				
		$this->uses = array('PatientDocument','PatientDocumentMaster');
		//debug ($this->request->data);exit;
		$this->loadModel('PatientDocument');
		$this->set('title_for_layout', __('Add Patient Document Master ', true));
		if ($this->request->is('post')) {
			$this->request->data['PatientDocumentMaster']['location_id'] = $this->Session->read("locationid");
			$this->request->data['PatientDocumentMaster']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['PatientDocumentMaster']['created_by'] = $this->Auth->user('id');
			//$this->PatientDocumentMaster->create();
			$this->PatientDocumentMaster->save($this->request->data);
			//$errors = $this->PatientDocumentMaster->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The Patient Document Master has been saved', true));
				$this->redirect(array("controller" => "patient_documents", "action" => "patient_document_master"));
			}
		}
		//debug ($this->request->data);
		//$patient_document = $this->PatientDocument->find('list', array('fields'=> array('PatientDocument.id','PatientDocument.document_type')));
		//'conditions'=>array('PatientDocument.is_active'=>1)));
		//debug($order_category);exit;
		//$this->set('patient_document',$patient_document);
	
	}
	
	
	

	function edit_patient_document_master($id=null)
	{
		$this->loadModel('PatientDocumentMaster');
		$this->loadModel('PatientDocumentMaster');
		$this->set('title_for_layout', __('Edit Patient Dpcument Master', true));
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Patient Document Master', true));
			$this->redirect(array("controller" => "patient_documents", "action" => "patient_document_master"));
		}
		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->request->data['PatientDocumentMaster']['location_id'] = $this->Session->read("locationid");
			$this->request->data['PatientDocumentMaster']['modify_time'] = date('Y-m-d H:i:s');
			$this->request->data['PatientDocumentMaster']['modified_by'] = $this->Auth->user('id');
			$this->PatientDocumentMaster->id = $this->request->data["PatientDocumentMaster"]['id'];
			$this->PatientDocumentMaster->save($this->request->data);
			$errors = $this->PatientDocumentMaster->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The Patient Document Master has been updated', true));
				$this->redirect(array("controller" => "patient_documents", "action" => "patient_document_master"));
			}
		} else {
			$this->request->data = $this->PatientDocumentMaster->read(null, $id);
		}

	}


	function view_patient_document_master($id = null) {
		$this->loadModel('PatientDocumentMaster');
		//$this->loadModel('patientDocumentMaster');
		$this->set('title_for_layout', __('Patient Document Master Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Patient Document Master', true));
			$this->redirect(array("controller" => "patient_documents", "action" => "patient_document_master"));
		}
		$this->set('opt', $this->PatientDocumentMaster->read(null, $id));
		//debug($patient_document_master);
		//$this->PatientDocumentMaster->Find

	}

	function delete_patient_document_master($id = null) {
		$this->loadModel('PatientDocumentMaster');
		$this->set('title_for_layout', __('Delete Patient Document Master', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Patient Document Master', true));
			$this->redirect(array("controller" => "patient_documents", "action" => "patient_document_master"));
		}
		if ($id) {
			$this->PatientDocumentMaster->id = $id;
			$this->request->data['PatientDocumentMaster']['id'] = $id;

			$this->request->data['PatientDocumentMaster']['is_deleted'] = 1;
			$this->request->data['PatientDocumentMaster']['modified_by'] = $this->Auth->user('id');
			$this->request->data['PatientDocumentMaster']['modify_time'] = date('Y-m-d H:i:s');
			$this->PatientDocumentMaster->save($this->request->data);
			$this->Session->setFlash(__('Patient Document Master deleted', true));
			$this->redirect(array("controller" => "patient_documents", "action" => "patient_document_master"));
		}
	}


	function patient_doc($id = null) {
		$this->loadModel('PatientDocumentMaster');
		$this->set('title_for_layout', __('Delete Patient Document Master', true));

	}
	/**
     * for External radiologists dashboard
     * By Mahalaxmi
     * return result to all child file
     */
	public function radiologistDashboard(){
		$this->layout = 'advance';		
	}
	/**
     * for External radiologists dashboard child
     * By Mahalaxmi
     * return show child file
     */	
	public function patientDocDashboard($future_apt=null,$patient_id=null,$opt=null,$aptId=null){
		$this->layout = 'ajax' ;
		$this->uses = array('Patient','ServiceProvider','User','Radiology');
	//	Configure::write('debug',2) ;

		$getHopeProvider=$this->ServiceProvider->getServiceProviderIdByCateggoryAndName(Configure::read('radiologyservices'),Configure::read('service_provider_hope'));	
		$getUserEnable=$this->User->getUserRestrictedById(Configure::read('external_radiology_user_ids'));
		$this->set('radiologyServices',$this->Radiology->findRadiologyList());
		$this->Patient->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$conditions = array('Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_deleted'=>0) ;
		if($getUserEnable){
			$getUserFullName=$this->Session->read('first_name')." ".$this->Session->read('last_name');
			if(Configure::read('radiologyUser')==$getUserFullName){
				$conditions['RadiologyTestOrder.service_provider_id']='19';
			}else{
				$conditions['RadiologyTestOrder.service_provider_id']=$getHopeProvider;
			}
		}
		$this->Patient->bindModel(array(
				'belongsTo'=>array(		
							'Person' => array('foreignKey'=>false,'conditions'=> array('Person.id=Patient.person_id')),
							'Note' => array('foreignKey'=>false,'conditions'=> array('Note.patient_id=Patient.id')),
							/*'PatientDocument' => array('foreignKey'=>false,'conditions'=> array('PatientDocument.patient_id=Patient.id','PatientDocument.is_deleted'=>0)),		*/		
							'RadiologyTestOrder' => array('type'=>'INNER','foreignKey'=>false,'conditions'=> array('RadiologyTestOrder.patient_id=Patient.id','RadiologyTestOrder.is_deleted'=>0)),		
							'ExternalRequisition' => array('type'=>'INNER','foreignKey'=>false,'conditions'=> array('ExternalRequisition.radiology_test_order_id=RadiologyTestOrder.id')),
							'User' => array('foreignKey'=>false,'conditions'=> array('User.id=ExternalRequisition.created_by')),	
							'TariffStandard'=>array('foreignKey'=>false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),	
				),
				'hasMany'=>array(						
							'PatientDocument' => array('foreignKey'=>'patient_id','fields'=>array('PatientDocument.id','PatientDocument.document_id','PatientDocument.note','PatientDocument.date','PatientDocument.rad_test_order_id')/*,'conditions'=> array('PatientDocument.patient_id=Patient.id','PatientDocument.is_deleted'=>0)*/),)
							),false);		
		
		
		if(!empty($this->params->query['dateFrom'])){
			$from = $this->DateFormat->formatDate2STD($this->params->query['dateFrom'],Configure::read('date_format'))." 00:00:00";
		}
		if(!empty($this->params->query['dateTo'])){
			$to = $this->DateFormat->formatDate2STD($this->params->query['dateTo'],Configure::read('date_format'))." 23:59:59";
		}

		if($to)
			$conditions['ExternalRequisition.created_time <='] = $to;
		if($from)
			$conditions['ExternalRequisition.created_time >='] = $from;
	
	 	if(isset($this->request->data['User']['Patient Name']) && !empty($this->request->data['User']['Patient Name'])){
	 		$patientName=explode('-',$this->request->data['User']['Patient Name']);	 		
	 		$conditions['Patient.lookup_name LIKE'] =  "%".$patientName[0]."%";
	 		$conditions['Patient.admission_id LIKE'] =  "%".$patientName[1]."%";
	 	}
	 	
	 	$this->paginate = array(
				'limit' => '10',
				'fields'=> array('TariffStandard.name','Patient.id','Patient.lookup_name','Patient.admission_id','Person.sex','Person.dob','User.first_name','User.last_name','ExternalRequisition.created_time','RadiologyTestOrder.id','RadiologyTestOrder.radiology_id','Note.id'), 		
				'conditions'=>array($conditions),'order'=>array('ExternalRequisition.created_time'=>'DESC'),'group'=>('Patient.id'));
		$data = $this->paginate('Patient') ;
		
		if(!empty($data)){
			foreach($data as $patientKey => $patientValue){				
				$customArray[$patientValue['Patient']['id']]['Patient'] = $patientValue ;
				$patientAddId[]=$patientValue['Patient']['admission_id'];
			}		
		}
		
		 /* patient link to pasc*/
				// to image array inside a patient array..
		$imagesArry=$this->linkPacsImages($patientAddId);//IHH16B222
			
					$cnt=1;
				
				if(!empty($data)){
					
					//
					//foreach ($testOrder as $keyVal => $patientData){
				
						foreach ($imagesArry as $key => $value){
									
							//echo "<pre>";
							//print_r($value);
							$studyvalue=explode("~~",$value);
							//print_r($studyvalue);
							
							foreach ($data as $keyVal => $patientData){
								//print_r($patientData);
								//echo "key".$key."<br/>";
								//echo "patientdata".$patientData['Patient']['admission_id']."<br>";
								
								
							if($patientData['Patient']['admission_id']==$key){
								$customArray[$patientData['Patient']['id']]['Patient']['Patient']['studyuid']=$studyvalue[0];
								$customArray[$patientData['Patient']['id']]['Patient']['Patient']['patientfk']=$studyvalue[1];
								break;

							}else{
																
								$cnt++;
							}
						}
						}
					//}
							
				}
				//eod..WW
				
			//debug($customArray);
		$this->set(array('data'=>$customArray));
		
	
	}
	public function newPatientDocDashboard($future_apt=null,$patient_id=null,$opt=null,$aptId=null){
		$this->layout = 'advance_ajax' ;
		$this->uses = array('Patient','ServiceProvider','User');

		$getHopeProvider=$this->ServiceProvider->getServiceProviderIdByCateggoryAndName(Configure::read('radiologyservices'),Configure::read('service_provider_hope'));	
		$getUserEnable=$this->User->getUserRestrictedById(Configure::read('external_radiology_user_ids'));
		
		$this->Patient->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$conditions = array('Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_deleted'=>0) ;
		if($getUserEnable){
			$conditions['RadiologyTestOrder.service_provider_id']=$getHopeProvider;
		}
		$this->Patient->bindModel(array(
				'belongsTo'=>array(		
							'Person' => array('foreignKey'=>false,'conditions'=> array('Person.id=Patient.person_id')),
							'PatientDocument' => array('foreignKey'=>false,'conditions'=> array('PatientDocument.patient_id=Patient.id','PatientDocument.is_deleted'=>0)),				
							'RadiologyTestOrder' => array('type'=>'INNER','foreignKey'=>false,'conditions'=> array('RadiologyTestOrder.patient_id=Patient.id')),		
							'ExternalRequisition' => array('type'=>'INNER','foreignKey'=>false,'conditions'=> array('ExternalRequisition.radiology_test_order_id=RadiologyTestOrder.id')),
							'User' => array('foreignKey'=>false,'conditions'=> array('User.id=ExternalRequisition.created_by')),	
							'TariffStandard'=>array('foreignKey'=>false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),	
				)),false);		
		debug($this->params->query);
		
		if(!empty($this->params->query['dateFrom'])){
			$from = $this->DateFormat->formatDate2STD($this->params->query['dateFrom'],Configure::read('date_format'))." 00:00:00";
		}
		if(!empty($this->params->query['dateTo'])){
			$to = $this->DateFormat->formatDate2STD($this->params->query['dateTo'],Configure::read('date_format'))." 23:59:59";
		}

		if($to)
			$conditions['ExternalRequisition.created_time <='] = $to;
		if($from)
			$conditions['ExternalRequisition.created_time >='] = $from;
	
	 	if(isset($this->request->data['User']['Patient Name']) && !empty($this->request->data['User']['Patient Name'])){
	 		$patientName=explode('-',$this->request->data['User']['Patient Name']);
	 		$conditions['Patient.lookup_name LIKE'] =  "%".$patientName[0]."%";
	 	}
	 	$data =$this->Patient->find('all',array('fields'=> array('TariffStandard.name','Patient.id','Patient.lookup_name','Patient.admission_id','Person.sex','Person.dob','PatientDocument.id','User.first_name','User.last_name','PatientDocument.note','PatientDocument.date','ExternalRequisition.created_time','RadiologyTestOrder.id','RadiologyTestOrder.radiology_id'),	 		
				'conditions'=>array($conditions),'order'=>array('ExternalRequisition.created_time'=>'DESC'),'group'=>('Patient.id')));
	 	/*$this->paginate = array(
				'limit' => '10',
				'fields'=> array('TariffStandard.name','Patient.id','Patient.lookup_name','Patient.admission_id','Person.sex','Person.dob','PatientDocument.id','User.first_name','User.last_name','PatientDocument.note','PatientDocument.date','ExternalRequisition.created_time','RadiologyTestOrder.id','RadiologyTestOrder.radiology_id'),	 		
				'conditions'=>array($conditions),'order'=>array('ExternalRequisition.created_time'=>'DESC'),'group'=>('Patient.id'));
		$data = $this->paginate('Patient') ;*/
			
		if(!empty($data)){
			foreach($data as $patientKey => $patientValue){				
				$customArray[$patientValue['Patient']['id']]['Patient'] = $patientValue ;
				$patientAddId[]=$patientValue['Patient']['admission_id'];
			}		
		}
		
		 /* patient link to pasc*/
				// to image array inside a patient array..
		//$imagesArry=$this->linkPacsImages($patientAddId);//IHH16B222
				
		//print_r($imagesArry);	
					$cnt=1;
					//print_r($customArray);
				
				if(!empty($data)){
					
					
					//foreach ($testOrder as $keyVal => $patientData){
						foreach ($imagesArry as $key => $value){
							foreach ($data as $keyVal => $patientData){
							//print_r($patientData);	
							if($patientData['Patient']['admission_id']==$key){
								//echo $keyVal;
								$customArray[$patientData['Patient']['id']]['Patient']['studyuid']=$value;
								break;

							}else{
																
								$cnt++;
							}
						}
						}
					//}
							
				}
				//eod..WW
			//print_r($customArray);	
				
		$this->set(array('data'=>$customArray));
		
	
	}

	public function all_dashboard(){
		$this->layout = 'advance';
		$this->redirect(array("controller" => "Users", "action" => "doctor_dashboard",'?'=>array('type'=>'slideone')));
	} 
	
	public function docup(){
		$this->layout= 'advance' ;
		$this->autoRender = false ;
		if(!empty($this->request->data)){ 
			//debug($this->request->data); 
		}
	}
	//function to save service package for RGJAY patients
	function saveServicePackage($service_id=null,$patient_id=null){
		$this->layout = 'ajax' ;
		$this->autoRender  = false ;
		if($this->request->data['tariff_list_id'] && $patient_id){
			$this->loadModel('ServiceBill');
			$this->loadModel('TariffList');
			$serviceData = $this->TariffList->find('first',array('conditions'=>array('TariffList.id'=>$this->request->data['tariff_list_id'])));//find group id
	
			//check if package already added
			if(!empty($service_id)){
				$isExist = $this->ServiceBill->find('first',array('conditions'=>array('ServiceBill.patient_id'=>$patient_id,'ServiceBill.service_id'=>$service_id)));
			}
			$result  = $this->ServiceBill->save(array(
					'id'=>$isExist['ServiceBill']['id'],
					'patient_id'=>$patient_id,
					'tariff_list_id'=>$this->request->data['tariff_list_id'],
					'tariff_standard_id'=>$this->request->data['tariff_standard_id'],
					'service_id'=>$serviceData['TariffList']['service_category_id'],
					'date'=>date('Y-m-d H:i:s'),
					'location_id'=>1,
					'amount'=>$this->request->data['amount'],
					'no_of_times'=>1,
					'create_time'=>date('Y-m-d H:i:s'),
					'created_by'=>1	));
			if($result) return true ;
		}
		return false  ;
		exit;
	}
	//function for save documnet for rgjay package(claim submission/Pre Auth)
	public function rgjay_package_master(){
		$this->layout='advance';
		$this->uses=array('RgjayPackageMaster','ServiceCategory','TariffList','Bed');
		$rgjayPackage = $this->ServiceCategory->getServiceGroupIdFromAlias('RGJAY Package');
		
		if(!empty($this->request->data)){
			$created_by = $this->Session->read('userid');
			$created_time = date("Y-m-d");
			//debug($this->request->data);exit;
			$this->RgjayPackageMaster->save($this->request->data['rgjaypackage']);
			
			$this->Session->setFlash(__('Save successfully!!!'));
			$this->redirect($this->referer());
				
		}
			//debug($this->request->data);
			$this->Bed->bindModel(array(
					'belongsTo' => array(
							'ServiceBill' =>array('foreignKey' => false,'conditions'=>array('ServiceBill.patient_id =Patient.id','ServiceBill.service_id='.$rgjayPackage)),	false)));
			
		$tarifficid = $this->TariffList->find('First',array('fields'=>array('TariffList.id')));
	
		$this->set('rgjayPackage',$rgjayPackage);
	}
	
	
	public function rgjay_list() {
		$this->uses = array('RgjayPackageMaster');
		$this->RgjayPackageMaster->bindModel(array('belongsTo'=>array(
					'TariffList' =>array('foreignKey' => false,'conditions'=>array('TariffList.id =RgjayPackageMaster.tariff_list_id'))
				)));
		$result=$this->RgjayPackageMaster->find('all',array('fields'=>array('RgjayPackageMaster.*','TariffList.name'),'conditions'=>array('RgjayPackageMaster.is_deleted'=>'0')));
		$this->set('result',$result);
	}

	public function rgjay_add($id) {
		$this->layout='advance';
		$this->uses=array('RgjayPackageMaster','ServiceCategory','TariffList','TariffStandard');

		if(!empty($this->request->data)){
			$created_by = $this->Session->read('userid');
			$created_time = date("Y-m-d");
			$this->request->data["rgjaypackage"]["tariff_list_id"]=$this->request->data["rgjaypackage"]['package_id'];
			if(!empty($id)){
				$this->RgjayPackageMaster->id = $id;					
				$this->request->data["rgjaypackage"]["modify_time"] = date("Y-m-d H:i:s");
			}				
			$this->RgjayPackageMaster->save($this->request->data['rgjaypackage']);
			$this->Session->setFlash(__('RGJAY Package has been save successfully!!!'));
			$this->redirect(array('action'=>'rgjay_list'));
		}


		$rgjayPackage = $this->ServiceCategory->getServiceGroupId('RGJAY Package');
		$rgjayTariffId = $this->TariffStandard->getTariffStandardID('rgjay');

		$this->set('rgjayPackage',$rgjayPackage);
		$this->set('rgjayTariffId',$rgjayTariffId);
		if($id){
			$data = $this->RgjayPackageMaster->read(null,$id);
			$this->set('data',$data);
		}
	}

	public function rgjay_delete($id = null) {
		$this->set('title_for_layout', __('- Delete ', true));
		$this->uses = array("RgjayPackageMaster");
		if (!$id) {
			$this->Session->setFlash(__('Invalid id '),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'rgjay_list'));
		}
		if ($this->RgjayPackageMaster->delete($id)) {
			$this->Session->setFlash(__('deleted successfully'),'default',array('class'=>'message'));
			$this->redirect(array('action'=>'rgjay_list'));
		}
	}

	public function rgjay_print_document($tariff_list_id=null){
		$this->uses=array('RgjayPackageMaster','ServiceCategory','TariffList','TariffStandard');
		$this->layout = 'print' ;
		$this->RgjayPackageMaster->bindModel(array('belongsTo'=>array(
					'TariffList' =>array('foreignKey' => false,'conditions'=>array('TariffList.id =RgjayPackageMaster.tariff_list_id'))
				)));
		$rgjaydoc=$this->RgjayPackageMaster->find('first',array('fields'=>array('RgjayPackageMaster.*','TariffList.name'),
															'conditions'=>array('tariff_list_id'=>$tariff_list_id)));
		$this->set('rgDoc',$rgjaydoc);







	}
	
	/*@linking pacs images with Drm patients*/
public function linkPacsImages($addmissionID){ 
//echo "hello";
	/* Code to connect with Dicom Db */
		$servername = "192.168.8.238";
		$username = "newuser2";
		$password = "password321@";
	// Create connection
	$conn = new mysqli($servername, $username, $password,'pacsdb');
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}else{
	//echo "s";		
	}
	$keyCnt=0;
	$patientUuid=array();
	foreach ($addmissionID as $key => $adId) {
		// get uuid to find study ids...
			
			$sql = "SELECT patient.pk,patient.pat_id,study_iuid FROM study LEFT JOIN patient ON study.patient_fk = patient.pk where patient.pat_id ='".$adId."' and (mods_in_study='CT' or mods_in_study='MR')";
			
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					
					$patientUuid[$row["pat_id"]]=$row["study_iuid"]."~~".$row["pk"];
					
					
				}
			}else{
				continue;
			}
		// eod
		
		
	// eod
}

return ($patientUuid);
	//return ($imageArry);
	$conn->close();
	/**/

}
	//function to print patientDocument requestion for eachtest
	//Auther @ Mahalaxmi
	function print_preview($patient_id=null,$documentId=null,$radOrderTestId=null){
		$this->layout =false;
		$this->uses=array('PatientDocument','Radiology','ServiceProvider','RadiologyTestOrder');
		//$this->patient_info($patient_id);				
		$patientDocumentdata=$this->PatientDocument->findPatientDocumentPatientData($patient_id,$documentId);
		$radTestOrderdata=$this->RadiologyTestOrder->findRadiologyDetailsById($radOrderTestId);	
		if(!empty($radTestOrderdata['RadiologyTestOrder']['service_provider_id'])){
			$serviceProviderData=$this->ServiceProvider->getServiceProviderDetails($radTestOrderdata['RadiologyTestOrder']['service_provider_id'],array('contact_person'));
		}
		$radiologyIdsArr=array();
		//foreach ($patientDocumentdata as $key => $value) {
			$unserializeRadiology=unserialize($patientDocumentdata['PatientDocument']['document_id']);
			foreach($unserializeRadiology as $unserializeRadiologys){				
				array_push($radiologyIdsArr, $unserializeRadiologys);
			}			
		//}
		$radName =  $this->Radiology->findRadiologyListByIds($radiologyIdsArr);		
		$this->set(array('radName'=>$radName,'patientDocumentdata'=>$patientDocumentdata,'serviceProviderData'=>$serviceProviderData));
	}
	public function patientAllDld($stdID,$name){
		$servername = "localhost";
		$username = "root";
		$password = "";
		// Create connection
		$conn = new mysqli($servername, $username, $password,'dicom');
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}else{
				
		}
		$keyCnt=0;
		$patientUuid=array();

			$sql = "SELECT * FROM series WHERE studyuid ="."'".$stdID."'";
			
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$seriesId[]=$row["uuid"];
				}
			}
			$seriesids="";
           foreach($seriesId as $serid)
		   {
			  $seriesids.="'".$serid."'".",";
		   }
		   $seriesids=rtrim($seriesids,",");
			$sql = "SELECT * FROM image WHERE seriesuid in (".$seriesids.")";
			
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$files[]="pacsimages/images/".$row["uuid"].".jpg";
				}
			}
			
			
			
			$zip  = new ZipArchive;
			$newName=urldecode($name);
			$newName=str_replace(" ","_",$newName);
			$newName=str_replace(":","_",$newName);
			$zipname = $newName.".zip";
			$res  = $zip->open($zipname, ZipArchive::CREATE);
			if ($res === TRUE) {
				$path = "pacsimages/images/";
				foreach ($files as $file) {
					$path = $file;
					if(file_exists($path)){
						$zip->addFile($path,$file);
					}
				}
				$zip->close();
				header('Content-type: "application/x-zip-compressed"; charset="utf8"');
				header('Content-disposition: attachment; filename="'.str_replace(" ","_",$newName).'.zip"');
				header('Content-Transfer-Encoding: binary');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				ob_clean();
				flush();
				readfile($zipname);
				@unlink($zipname); //remove temp file
					
			}else{
				echo "failed " ;
			}

	$conn->close();
	/**/
	exit;
	}

	public function showAllStudies($id,$patientfk){
		$this->layout ='advance_ajax';
		$this->uses=array('Patient','PatientDocument','Radiology');

		$this->Patient->unbindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
				$this->Patient->bindModel(array(
						'belongsTo'=>array(
								'Person'=>array('foreignKey'=>false,'conditions'=>array('Patient.person_id=Person.id')),
								'Note'=>array('foreignKey'=>false,'conditions'=>array('Patient.id=Note.patient_id')),
						)));
		$patientData=$this->Patient->find('first',array('conditions'=>array('admission_id'=>$id),'fields'=>array('Patient.lookup_name','Patient.admission_id','Patient.sex','Patient.age','Person.dob','Note.subject')));
		$this->set('patientData',$patientData);

		$servername = "192.168.8.238";
		$username = "newuser2";
		$password = "password321@";
		
		$conn = new mysqli($servername, $username, $password,'pacsdb');
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}else{
				
		}
		
		$keyCnt=0;
		$sql_patient = "SELECT pk FROM patient WHERE pat_id ="."'".$id."'";
			$result_patient = $conn->query($sql_patient);
		$patientFkids="";
		if ($result_patient->num_rows > 0) {
				while($row_patient = $result_patient->fetch_assoc()) {
					
					$patientFkids.=$row_patient['pk'].",";
				}
			}
			$patientFkids = rtrim($patientFkids, ",");
		
		$sql="select * from study where patient_fk in (".$patientFkids.") and (mods_in_study='CT' or mods_in_study='MR')";
		
		
		//SELECT patient.pat_id,study_iuid FROM study LEFT JOIN patient ON study.patient_fk = patient.pk where patient.pat_id ='IH16E06002' and (mods_in_study='CT' or mods_in_study='MR')
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$studyAll[]=$row;
				}
			}
		$this->set('studyAll',$studyAll);
		$conn->close();
	}
}
?>