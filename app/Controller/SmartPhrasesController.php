<?php
/**
 * SmartPhrasesController file
 *
 * PHP 5
 * 
 *
 * @copyright     Copyright 2013 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       SmartPhrasesController
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */

class SmartPhrasesController extends AppController {
	public $name = 'SmartPhrases';
	public $uses = array('SmartPhrase');
	public $helpers = array('Html','Form', 'Js','DateFormat','General');
	public $components = array('RequestHandler','Email', 'Session','DateFormat');

	function getSmartPhrase(){
		$this->layout = "ajax";
		$this->uses = array('SmartPhrase','SmartPhraseMultiple','SmartPhraseXmlTemplate');
		if(is_array($this->params->query['q'])){
			$this->params->query['q'] = $this->params->query['q'][0];
		}
		$smartPhrases = $this->SmartPhrase->find('all', array('fields'=> array('phrase','phrase_text','has_multiple'),
				'conditions'=>array('phrase like "'.$this->params->query['q'].'"')));	
		if((count($smartPhrases) == 1) && $smartPhrases[0]['SmartPhrase']['has_multiple'] ==1){
			$this->getMultipleSmartPhraseList($this->params->query['q']);
		}else{
			foreach ($smartPhrases as $key=>$smartPhrase) {
				echo strtolower($smartPhrase['SmartPhrase']['phrase'])."|".$this->SmartPhraseXmlTemplate->matchString($smartPhrase['SmartPhrase']['phrase'],$smartPhrase['SmartPhrase']['phrase_text'])."\n";
			}
		}
		
		exit;
	}

	public function getMultipleSmartPhraseList($searchKey){
		$smartPhrases = $this->SmartPhraseMultiple->find('all', array('fields'=> array('list_content','list_name','phrase_id'),
				'conditions'=>array('phrase_id' => $searchKey)));
		foreach ($smartPhrases as $key=>$smartPhrase) {
			echo $smartPhrase['SmartPhraseMultiple']['list_content']."|".$smartPhrase['SmartPhraseMultiple']['list_content']."\n";

		}
		exit;
	}

	public function admin_index($phraseid=null,$patientIdNew=null,$appointmentIdNew=null,$noteIdNew=null){	
		//debug($this->request->data);exit;
		if($this->params->query['flag']=="service_combo"){
			$this->layout='advance_ajax';
			$this->set('fromSoapNote',$this->params->query['flag']);
		}else if($this->params->query['flag']=="med_combo"){
			$this->layout='advance_ajax';
			$this->set('fromSoapNote',$this->params->query['flag']);
		}else{
			$this->layout='advance';
		}
		
		$this->uses = array('Department','SmartPhraseMultiple');
		$this->set('title_for_layout', __('Doctor Templates', true));
		$this->set('patientIdNew',$this->params->query['patientId']);
		$this->set('appointmentIdNew',$this->params->query['appointmentId']);
		$this->set('noteIdNew',$this->params->query['noteId']);
		$this->set('departments',$this->Department->find('list',array('fields'=>array('id','name'),'order' => array('Department.name'),
				'group'=>'Department.name')));
	
		if(!empty($this->request->query['phrase'])){			
			$conditionArray = array('is_deleted'=>0,'SmartPhrase.phrase'=>$this->request->query['phrase'],'NOT'=>array('location_id'=>null));
		}else if(!empty($this->request->query['nursePriscription'])){ /* New condition for nurse prescription -- Pooja*/
			$conditionArray = array('is_nursing'=>'1','is_deleted'=>0,'NOT'=>array('location_id'=>null));
		}else{
			$conditionArray = array('is_deleted'=>0,'NOT'=>array('location_id'=>null));
		}
		$this->paginate = array(
				'evalScripts' => true,
				'limit' => Configure::read('number_of_rows'),
				'conditions' => $conditionArray
		);
		
		$this->set('dataTest',$this->paginate('SmartPhrase'));
		//debug($this->request->data);exit;
		if(!empty($this->request->data['SmartPhrase'])){
			
			/** Adity- dynamic lab rad save for pharse **/
		 		if(!empty($this->request->data['labCode']) || !empty($this->request->data['radCode']) || !empty($this->request->data['serviceCode'])){
					$this->SmartPhrase->createDynTempLabRad($this->request->data['labCode'],$this->request->data['radCode'],$this->request->data['serviceCode'],$this->request->data['SmartPhrase']['phrase'],$this->request->data['chief_complaints']);
		 		}
			
				if(empty($this->request->data['labCode']) && empty($this->request->data['radCode']) && !empty($this->request->data['serviceCode']) &&empty($this->request->data['chief_complaints'])){					
					if(!empty($this->request->data['SmartPhrase']['phrase'])){
						$file ="smartphrase_templates".DS.trim($this->request->data['SmartPhrase']['phrase']."inv").".xml";						
						if (!unlink($file))
						{
							//echo ("Error deleting $file");
						}
						else
						{
							//echo ("Deleted $file");
						}
					}
				}
			/** Adity- dynamic lab rad save for pharse EOD **/
			
			/** link diagnosis remove -Aditya **/
				if(!empty($this->request->data['diaCodeDelete'])){
					$this->SmartPhrase->linkDiaDelete($this->request->data['diaCodeDelete'],$this->request->data['SmartPhrase']['phrase']);
				}
				/** EOD**/
			
			/** link diagnosis -Aditya **/
				if(!empty($this->request->data['diaCode'])){
					$this->SmartPhrase->linkDia($this->request->data['diaCode'],$this->request->data['SmartPhrase']['phrase']);
				}
			/** EOD**/
				
			
			$this->set('patientIdNew',$this->request->data['SmartPhrase']['patientId']);
			$this->set('noteIdNew',$this->request->data['SmartPhrase']['noteId']);
			if(isset($this->request->data['0']) && !empty($this->request->data['0']['SmartPhraseMultiple']['list_name'])){
				$this->request->data['SmartPhrase']['has_multiple']= 1;
				for($i=0;$i<=(count($this->request->data)-2);$i++){
					$this->request->data[$i]['SmartPhraseMultiple']['phrase_id']= $this->request->data['SmartPhrase']['phrase'];
					$this->SmartPhraseMultiple->insertMultiplePhrase($this->request->data[$i]);
				}
			}
			$this->SmartPhrase->insertPhrase($this->request->data);
			$errors = $this->SmartPhrase->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
		//	$this->redirect('/admin/smart_phrases/index');
				if(!empty($this->request->query['nursePriscription'])){ /* redirect condition for nurse prescription -- Pooja*/
					$this->redirect(array('controller' => 'Notes', 'action' => 'addNurseMedication',$this->request->query['nursePriscription'],'?' => array('from'=>'Nurse'),'admin'=>false));
				}else if(!empty($this->request->data['flag'])){
					echo "<script> parent.$.fancybox.close();</script>";
				}else{
					$this->redirect(array('controller'=>'SmartPhrases','action'=>'index','admin'=>true,'?'=>array('patientId'=>$this->request->data['SmartPhrase']['patientId'],'appointmentId'=>$this->request->data['SmartPhrase']['appointmentId'],'noteId'=>$this->request->data['SmartPhrase']['noteId'])));
				}
			}
			
		}
		if(!empty($phraseid)){
			$this->data = $this->SmartPhrase->read(null,$phraseid);
			$this->set('data',$this->data);
			$this->set('phrase_text_array',$this->data['SmartPhrase']['phrase_text']);
			/** LabRad**/
			$getArrayLabRad=$this->loadLinkPharse($this->data['SmartPhrase']['phrase'],'nonAjax');		
			$this->set('getArrayLabRad',$getArrayLabRad);				
			
			/** Diagnosis**/
			$getArrayDia=$this->loadLinkDiaPharse($this->data['SmartPhrase']['phrase']);
			$this->set('getArrayDia',$getArrayDia);
		}
	}

	public function admin_phrase_delete($id=null){
		if(!empty($id)){
			$this->SmartPhrase->id= $id ;
			$this->SmartPhrase->save(array('is_deleted'=>1));
			//$this->NoteTemplateText->updateAll(array('is_deleted'=>1),array('template_id'=>$id));
			$smartPhrases = $this->SmartPhrase->find('first', array('fields'=> array('phrase'),
					'conditions'=>array('id' => $id)));
			if(!empty($smartPhrases['SmartPhrase']['phrase'])){
				//debug($medData['pharse_name']);exit;
				$file ="smartphrase_templates".DS.trim($smartPhrases['SmartPhrase']['phrase']).".xml";
				$file1 ="smartphrase_templates".DS.trim($smartPhrases['SmartPhrase']['phrase']."inv").".xml";
				if (!unlink($file)){
					//echo ("Error deleting $file");
				}else{
					//echo ("Deleted $file");
				}
				if (!unlink($file1)){
					//echo ("Error deleting $file");
				}else{
					//echo ("Deleted $file");
				}
			}
			$this->Session->setFlash(__('Smart Phrase have been deleted', true, array('class'=>'message')));
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
		}
		$this->redirect($this->referer());
	}

	public function test(){//echo Inflector::camelize("pawan");exit;
		$data = $this->SmartPhrase->getPatientDetails(2097);
		//$content = " PA MESHRAM mesHRAm ssss 2134";
		//preg_match_all("/\s\.\w+/", $content, $output_array);
		//preg_match_all("/[A-Z]{3,100}/", $content, $output_array);
		//echo '<pre>';print_r($this->SmartPhrase->getZipCode());exit;
		//$this->SmartPhrase->getPatientInfo();
		
		

	}

	public function ajaxMedicationList($namePharse=null){
		$this->layout=false;
		if(isset($this->request->data['drugText']) && !empty($this->request->data['drugText'])){
	    $result=$this->SmartPhrase->createDynTempMed($this->request->data);
	    echo $result;
		}else{
			/** Medication**/
			if(!empty($namePharse)){
				$getArrayMedication=$this->loadLinkMedications($namePharse);
				$this->set('getArrayMedication',$getArrayMedication);
				$this->set('namePharse',$namePharse);
			}
		} 
                $this->render('vadodaraAjaxMedicationList'); 
	}
	 
	//function to check SamrtPhrasename availability
	function admin_ajaxValidateSamrtPhrasename(){
		$this->layout = 'ajax';
		$this->autoRender =false ;
		$smartPhrasename = $this->params->query['fieldValue'];
		if($smartPhrasename == ''){
			return;
		}
		$smartPhrasename = $this->params->query['fieldValue'];
		$count = $this->SmartPhrase->find('count',array('conditions'=>array('phrase'=>$smartPhrasename,'SmartPhrase.is_deleted' => 0)));
		if(!$count){
			//return json_encode(array('template_type',true,'* This Smartphrase name is available')) ; //template_type-is the id of that textbox
			return json_encode(array('template_type',true,'')) ;
		}else{ 
			return json_encode(array('template_type',false,'* This Smartphrase name is already taken')) ;
		}
	
		exit;
	}
	/** read Xml with inv-Aditya **/ 
	public function loadLinkPharse($name,$recive){
		$xmlString = file_get_contents('smartphrase_templates'.DS.strtolower($name).'inv.xml');
		$xml = simplexml_load_string($xmlString);	
		foreach($xml->ChiefComplaints->ChiefComplaint as $key=>$data){	
			$newArry=(array) $data;
			$returnAtty['ChiefComplaint'][]=$newArry;
		}		
		foreach($xml->laboratories->Laboratory as $key=>$data){
			$newArry=(array) $data;
				$returnAtty['Laboratory'][]=$newArry;
		}
		foreach($xml->radiologies->Radiology as $key=>$dataRad){
			$newArryRad=(array) $dataRad;
			$returnAtty['Radiology'][]=$newArryRad;
		}	
		foreach($xml->tariffList->TariffList as $key=>$dataTariff){
			$newArry=(array) $dataTariff;
			$returnAtty['TariffList'][]=$newArry;
		}
		if(!empty($recive)){
			return $returnAtty;
		}else{
			echo json_encode($returnAtty);
			exit;
		}
			
	}
	
	/** read Xml with inv-Mahalaxmi**/
	public function loadLinkPharsePhysio($name,$recive){
	$xmlString = file_get_contents('smartphrase_templates'.DS.strtolower($name).'.xml');
		$xml = simplexml_load_string($xmlString);
		$cnt="0";		
		foreach($xml->TariffLists->TariffList as $key=>$data){
			$newArry=(array) $data;		
			if(!empty($newArry['idTariffList'])){
			$returnAtty[$cnt]['display']=$newArry['display'];
			$returnAtty[$cnt]['idTariffList']=$newArry['idTariffList'];
			}		
			$cnt++;
		}
		if(!empty($recive)){
			return $returnAtty;
		}else{
			echo json_encode($returnAtty);exit;
		}
	
	}
	
  public function loadLinkPharseF($name,$noteId,$diaId,$patientId) {
		$xmlString = file_get_contents('smartphrase_templates'.DS.strtolower($name).'.xml');
		$xml = simplexml_load_string($xmlString);
		
		foreach($xml->newcropprescriptions->NewCropPrescription as $key=>$data){
			
			$newArry=(array) $data;
			$returnAtty['NewCropPrescription'][]=$newArry;
		}	
		
			echo json_encode($returnAtty);exit;
	
		}
	
	
	/** read Xml without inv-Mahalaxmi **/
 /*public function loadLinkPharseF($name,$noteId,$diaId,$patientId){	
		$this->uses = array('Note','NoteDiagnosis','SnomedMappingMaster');	
		$getSnomedMappingMaster=$this->SnomedMappingMaster->find('first',array('fields'=>array('icd9name'),'conditions'=>array('id'=>$diaId,'is_deleted'=>0)));
		$getNoteDiagnosis=$this->NoteDiagnosis->find('first',array('fields'=>array('diagnoses_name'),'conditions'=>array('patient_id'=>$patientId,'diagnosis_id'=>$diaId,'is_deleted'=>0,'note_id'=>$noteId,'code_system'=>null)));
		if(empty($getNoteDiagnosis['NoteDiagnosis']['diagnoses_name'])){		
			$this->request->data['NoteDiagnosis']['diagnoses_name']=$getSnomedMappingMaster['SnomedMappingMaster']['icd9name'];
			$this->request->data['NoteDiagnosis']['patient_id']=$patientId;
			$this->request->data['NoteDiagnosis']['note_id']=$noteId;
			$this->request->data['NoteDiagnosis']['diagnosis_id']=$diaId;
			$this->NoteDiagnosis->save($this->request->data['NoteDiagnosis']);			
		}
		
		$result1 = $this->Note->find('first',array('fields'=>array('Note.template_full_text'),'conditions'=>array('Note.id'=>$noteId))); //find
		
		if(!empty($result1['Note']['template_full_text'])){		
			$strMed= preg_split("/\r\n|\n|\r/", $result1['Note']['template_full_text']);			
			$strMed=str_replace("<p><b>Rx</b></p>","", $strMed);
			$strMed=str_replace("<p><strong>Rx</strong></p>","", $strMed);
			$strMed=str_replace("<p><strong>RX</strong></p>","", $strMed);
			
			$strMed=str_replace("<p><b>DIAGNOSIS :</b></p>","", $strMed);
			$strMed=str_replace("<p><strong>DIAGNOSIS :</strong></p>","", $strMed);
			
		}
		$strMed=array_filter($strMed);			
		$strMed=array_values($strMed);
		
		if(strstr($strMed['0'], 'DIAGNOSIS :')){
			unset($strMed['0']);
		}
		$strMed=array_filter($strMed);
		$strMed=array_values($strMed);
		$flag=false;
		$dataPhysio=array();
		foreach($strMed as $key=>$data){			
			if($data=='<p><b>PHYSIOTHERAPY :</b></p>' || $flag || $data=='<p>PHYSIOTHERAPY :</p>' || $data=='<p><strong>PHYSIOTHERAPY :</strong></p>'){
				$flag=true;
				$dataPhysio[$key]=$data;
				unset($strMed[$key]);
			}
		
		}
		
		$xmlString = file_get_contents('smartphrase_templates'.DS.strtolower($name).'.xml');
		$xml = simplexml_load_string($xmlString);
		$getFinalData=array();	
	
		foreach($xml->newcropprescriptions->NewCropPrescription as $keyNew=>$data){		
			$newArry=(array) $data;	
			$newArry['display'] =str_replace("@@","&",$newArry['display']);
			
			
			$getFinalData[]=$newArry['display'];
		}
		
		
		if(!empty($result1['Note']['template_full_text'])){
		$getFinalData=array_merge($strMed,$getFinalData);			
		}
		foreach($xml->TariffLists->TariffList as $keyTariff=>$dataTariffList){
			$newTariffArry=(array) $dataTariffList;
			$getTariffArry[]=$newTariffArry['display'];
		}
		
		if(!empty($getTariffArry) && !empty($dataPhysio)){
			$getFinalPhysio=array_merge($getTariffArry,$dataPhysio);
		}else if(!empty($getTariffArry)){
			$getFinalPhysio=$getTariffArry;
		}else if(!empty($dataPhysio)){
			$getFinalPhysio=$dataPhysio;
		}
		
		if(empty($getFinalData)){		
			$getFinalData="";
		}
		if(empty($getFinalPhysio)){
			$getFinalPhysio="";
		}
		echo $getSnomedMappingMaster['SnomedMappingMaster']['icd9name']."_".json_encode(array($getFinalData,$getFinalPhysio));exit;
	}
*/
	public function loadLinkPharseDiagnosisF(){		
		$this->uses = array('SnomedMappingMaster');
		$snomedMappingMasterData = $this->SnomedMappingMaster->find('first',array('fields'=>array('SnomedMappingMaster.id','SnomedMappingMaster.icd9name'),'conditions'=>array('SnomedMappingMaster.id'=>trim($this->request->data['diagnosesId'])))); //find
		
		echo $snomedMappingMasterData['SnomedMappingMaster']['id']."_".$snomedMappingMasterData['SnomedMappingMaster']['icd9name'];exit;
	}
	public function loadLinkPharsePrecription($noteId){
		$this->uses = array('Note');		
		$result1 = $this->Note->find('first',array('fields'=>array('Note.template_full_text'),'conditions'=>array('Note.id'=>$noteId))); //find
		if(!empty($result1['Note']['template_full_text'])){		
			$strMed= preg_split("/\r\n|\n|\r/", $result1['Note']['template_full_text']);			
		//	$strMed =str_replace("<p><b>Rx</b></p>","",$strMed);			
		//	$strMed =str_replace("<p><strong>Rx</strong></p>","",$strMed);	
				
			$strMed=array_filter($strMed);
			$strMed=array_values($strMed);			
			echo json_encode($strMed);exit;
		}
	}
	
	/** read the diagnosis link to pharse**/
	
	public function loadLinkDiaPharse($name){	
		$this->uses = array('SnomedMappingMaster');
		$getDiaSmart=$this->SnomedMappingMaster->find('all',array('fields'=>array('id','is_smart','icd9name'),'conditions'=>array('is_smart LIKE'=>"%".$name."%")));
		return $getDiaSmart;
	}	
	
	/** read Xml with inv-Aditya **/
	public function loadLinkMedications($name){
		$xmlString = file_get_contents('smartphrase_templates'.DS.strtolower($name).'.xml');
		
		$xml = simplexml_load_string($xmlString);
		
		$cnt="0";
		
		foreach($xml->newcropprescriptions->NewCropPrescription as $key=>$data){
			$newArry=(array) $data;			
			$newArry['description'] =str_replace("@@","&",$newArry['description']);
			/*$newArry['description'] =str_replace("plus@@","+",$newArry['description']);
			$newArry['description'] =str_replace("minus@@","-",$newArry['description']);
			$newArry['description'] =str_replace("great@@",">",$newArry['description']);
			$newArry['description'] =str_replace("less@@","<",$newArry['description']);*/
			
			$returnAtty['NewCropPrescription'][$cnt]['description']=$newArry['description'];
			$returnAtty['NewCropPrescription'][$cnt]['drug_id']=$newArry['drug_id'];
			$returnAtty['NewCropPrescription'][$cnt]['dose']=$newArry['dose'];
			$returnAtty['NewCropPrescription'][$cnt]['doseForm']=$newArry['doseForm'];
			$returnAtty['NewCropPrescription'][$cnt]['route']=$newArry['route'];
			$returnAtty['NewCropPrescription'][$cnt]['frequency']=$newArry['frequency'];
			$returnAtty['NewCropPrescription'][$cnt]['days']=$newArry['days'];
			$returnAtty['NewCropPrescription'][$cnt]['strength']=$newArry['strength'];				
			$returnAtty['NewCropPrescription'][$cnt]['quantity']=$newArry['quantity'];
			$returnAtty['NewCropPrescription'][$cnt]['dosage']=$newArry['dosage'];			
			$returnAtty['NewCropPrescription'][$cnt]['Active']=$newArry['Active'];			
			$cnt++;
		}
	
		return ($returnAtty);
	}
	/** **/
public function diagnosis_list()
	{
			
		$this->layout = 'advance';
	
		$this->uses=array('SnomedMappingMaster');
		$this->set('title_for_layout', __('Diagnosis List ', true));
		
		$searchId='';
		if(isset($this->request->data) && isset($this->request->data) && $this->request->data['SnomedMappingMaster']['hiddenId']!=''){
			$searchId = $this->request->data['SnomedMappingMaster']['hiddenId'];
			$conditions['SnomedMappingMaster']['id'] = $searchId;
		}
		
		$conditions['SnomedMappingMaster']['is_deleted'] = '0';
	//	$conditions['SnomedMappingMaster']['active'] = '1';
	//$conditions['SnomedMappingMaster']['location_id'] = $this->Session->read('locationid');
		
		$conditions = $this->postConditions($conditions);
		
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'fields'=>array('SnomedMappingMaster.icd9name','SnomedMappingMaster.active','SnomedMappingMaster.id'),
				'order' => array(
						'SnomedMappingMaster.icd9name' => 'DESC'
				),
				'conditions' => $conditions
		);
		$data = $this->paginate('SnomedMappingMaster');
		$this->set('data', $data);
	
	
	
	}
	
	public function add_diagnosis() {
		//$this->layout = 'advance';
		$this->set('title_for_layout', __('Add Diagnosis', true));
		$this->uses=array('SnomedMappingMaster');
		//pr($this->request->data);exit;
		if(isset($this->request->data) && !empty($this->request->data)){
	
			$this->request->data['SnomedMappingMaster']['location_id']=$this->Session->read('locationid');
			$this->request->data['SnomedMappingMaster']['created_by']=$this->Session->read('userid');
			$this->request->data['SnomedMappingMaster']['create_time']=date("Y-m-d H:i:s");
			
			if($this->SnomedMappingMaster->save($this->request->data['SnomedMappingMaster']))
			{
				//$this->Session->setFlash(__($this->request->data['SnomedMappingMaster']['name'].' has been saved successfully', true));
				$this->redirect(array('action'=>'diagnosis_list'));
			}
			else
			{
				$this->Session->setFlash(__('Could not add', false));
			}
		}
	}
	public function edit_diagnosis($id = null) {
		//$this->layout = 'advance';
		$this->set('title_for_layout', __('Edit Diagnosis', true));
		$this->uses=array('SnomedMappingMaster');
		$this->SnomedMappingMaster->id = $id;
		
		if(isset($this->request->data) && !empty($this->request->data)){
			$this->request->data['SnomedMappingMaster']['modified_by']=$this->Session->read('userid');
			$this->request->data['SnomedMappingMaster']['modifiy_time']=date("Y-m-d H:i:s");
			
			if($this->SnomedMappingMaster->save($this->request->data['SnomedMappingMaster']))
			{
				//$this->Session->setFlash(__($this->request->data['SnomedMappingMaster']['name'].' has been saved successfully', true));
				$this->redirect(array('action'=>'diagnosis_list'));
			}
			else
			{
				$this->Session->setFlash(__('Could not add', false));
			}
		}
		$this->data = $this->SnomedMappingMaster->read(null,$id);
	}
	public function delete_diagnosis($id = null) {
		$this->uses = array('SnomedMappingMaster');
		$this->request->data['SnomedMappingMaster']['is_deleted']=1;
		$this->SnomedMappingMaster->id= $id;
		if($this->SnomedMappingMaster->save($this->request->data['SnomedMappingMaster'])){
			$this->Session->setFlash(__('Diagnosis deleted successfully'),true);
			$this->redirect(array("action" => "diagnosis_list"));
		}
	}
	
	public function fetchEpenXml($id = null) {
		$this->uses = array('SmartPhrase','Patient');
		//$this->autoRender=false;
		$dirOutput = $this->SmartPhrase->listdirs('output');
		$labData=array();
		$radData=array();
		foreach($dirOutput as $dirsub)
		{
		     $dir = $dirsub."/";
             if (is_dir($dir)) 
             {
                if ($dh = opendir($dir))
                {
                   while (($file = readdir($dh)) !== false) 
                   {
                     if (($file !== '.') && ($file !== '..') ) 
                     {                 
	                    $xmlString = file_get_contents($dir . $file);
	                    $xml = simplexml_load_string($xmlString);
	                   //loop through pageNo_1 for pathology, labaoratory and diagnosis
	                  $patientId=$xml->PageNo_1['PatientUID'];
	                  	                   
	                   //foreach($xml->PageNo_1 as $key=>$data){
	                    	$dataArray=(array) $xml->PageNo_1;
	                    	//debug($dataArray);
	                    	debug($dataArray[PatientUID]);
	                    	$admission_id= $this->Patient->find('first', array('fields'=> array('id'),
				'conditions'=>array('Patient.admission_id'=>$dataArray[PatientUID])));
	                    	
	                    
	                    	if(empty($admission_id['Patient']['id']))
	                    		continue;
	                    	
	                    	 //for pathology loop through 10
	                    	for($i=1;$i<=10;$i++)
	                    	{
	                    		if(empty($dataArray['PathologyTest'.$i]))
	                    			continue;
	                    		
	                    		$islabSave=$this->SmartPhrase->saveLabEpen($dataArray['PathologyTest'.$i],$admission_id['Patient']['id']);
	                    	                    	                    		
	                    	   	
	                    	}
	                    	//for radiology loop through 10
	                    	for($i=1;$i<=5;$i++)
	                    	{
	                    	if(empty($dataArray['RadiologyTest'.$i]))
	                    		continue;
	                    	
	                    	$isRadSave=$this->SmartPhrase->saveRadEpen($dataArray['RadiologyTest'.$i],$admission_id['Patient']['id']);
	                    		                    	
	                    	}
	                    	
	                    //}
	                    
	                    //loop through pageNo_2 for medication
	              	     // foreach($xml->PageNo_2 as $key=>$dataMed){
	                    	$dataMedArray=(array) $xml->PageNo_2;
	                      //for medication loop through 15
	                    	for($j=1;$j<=15;$j++)
	                    	{
	                    	if(empty($dataMedArray['MedicineName'.$j]))
	                    		continue;
	                    	
	                    	$isMedSave=$this->SmartPhrase->saveMedEpen($dataMedArray['MedicineName'.$j],$admission_id['Patient']['id']);
	                    	
	                    
	                    	}
	                    
	                   // }
	                    
	                 }
                   }
               closedir($dh);
           }
          }
			
		}
		
		
	}
	
	public function phraseMedication($name){
		$this->uses=array('PharmacyItem','SmartPhrase');
		$returnArray=$this->loadLinkMedications($name);
		
		$phrase_array=$this->SmartPhrase->find('list',array('fields'=>array('phrase','phrase'),
				'conditions'=>array('is_deleted'=>'0','location_id NOT'=>NULL)));
                $phraseId = $this->SmartPhrase->find('first',array('conditions'=>array('SmartPhrase.phrase'=>$name))); 
		$this->set('phrase_array',$phrase_array);
		
		$this->PharmacyItem->unbindModel(array('hasOne'=>array('PharmacyItemRate')),false);
		$this->PharmacyItem->bindModel(array('hasMany'=>array('PharmacyItemRate'=>array('foreignKey'=>'item_id'))),false);
		
		foreach ($returnArray['NewCropPrescription'] as $key=>$value) {
			$returnArray['NewCropPrescription'][$key]['amount']=0;
			$returnArray['NewCropPrescription'][$key]['salePrice']=0;
			$totalStock=0;
			$medData=$this->PharmacyItem->find('first',array('conditions'=>array('PharmacyItem.id'=>$value['drug_id'])));
			foreach($medData['PharmacyItemRate'] as $k=>$data){
				$totalStock += ((int)$medData['PharmacyItem']['pack'] * $data['stock'] )+ $data['loose_stock'];
				
			//$totalStock = ((int)$medData['PharmacyItem']['pack']*$medData['PharmacyItem']['stock'] )+ $medData['PharmacyItem']['loose_stock'];
				$returnArray['NewCropPrescription'][$key]['drugStock']=$totalStock;
			//debug($medData['PharmacyItemRate'][0]['sale_price']);
				if(!empty($medData['PharmacyItemRate'][$k]['sale_price'])){
					$price = $medData['PharmacyItemRate'][$k]['sale_price'] / (int)$medData['PharmacyItem']['pack'];
				}else{
					$price = $medData['PharmacyItemRate'][$k]['mrp'] / (int)$medData['PharmacyItem']['pack'];
				}
			}
			
			$returnArray['NewCropPrescription'][$key]['salePrice']=$price;
			$returnArray['NewCropPrescription'][$key]['amount']=$value['quantity']*$price;		
		}
		
		$this->set('returnArray',$returnArray);		
		$this->set('namePharse',$name);
                $this->set('smart_phrase_id',$phraseId['SmartPhrase']['id']);
	}
	
	
}