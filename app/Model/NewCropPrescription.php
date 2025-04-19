<?php
 
/** NewCropPrescription model
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Languages.Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Aditya Chitmitwar
 */
class NewCropPrescription extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'NewCropPrescription';
	public $useTable = 'new_crop_prescription';
	//public $actsAs = array('Auditable');


	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	*/

	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds)){
        	$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	 	}else{
	 		$this->db_name =  $ds;
	 	}
		parent::__construct($id, $table, $ds);
	}
	function insertMedication($data =array()){
		$session = new cakeSession();
		$this->deleteAll(array('NewCropPrescription.is_orderset'=>'1',false));
		//debug($a);
		//$log = $this->getDataSource()->getLog(false, false);
		///debug($log);
		for($i=0;$i<count($data['NewCropPrescription']['description']);$i++){
			if($data['NewCropPrescription']['description'][$i]!='0'){
				$this->saveAll(array('description'=>$data['NewCropPrescription']['description'][$i],'rxnorm'=>$data['NewCropPrescription']['rxnorm_code'][$i],'date_of_prescription'=>date('Y-m-d'),'is_orderset'=>'1','archive'=>'N','is_ccda'=>'1','patient_uniqueid'=>$data['NewCropPrescription']['patient_uniqueid']));
				$this->id='';
			}
		}
		//debug($medName);
		//exit;
		$this->create();
		//debug($medName);
		//$this->saveAll(array('description'=>$medName,'patient_uniqueid'=>$data['NewCropPrescription']['patient_uniqueid']));
		//$lastinsid=$this->getInsertId();
		return true;
	}

	function insertMedication_new($data =array()){
		$session = new cakeSession();
		$this->deleteAll(array('NewCropPrescription.is_orderset'=>'1',false));
		//debug($a);
		//$log = $this->getDataSource()->getLog(false, false);
		///debug($log);
		for($i=0;$i<count($data['NewCropPrescription']['description']);$i++){
			if($data['NewCropPrescription']['description'][$i]!='0'){
				$this->saveAll(array('description'=>$data['NewCropPrescription']['description'][$i],'rxnorm'=>$data['NewCropPrescription']['rxnorm_code'][$i],'date_of_prescription'=>date('Y-m-d'),'is_orderset'=>'1','archive'=>'N','is_ccda'=>'1','patient_uniqueid'=>$data['NewCropPrescription']['patient_uniqueid']));
				$this->id='';
			}
		}
		//debug($medName);
		//exit;
		$this->create();
		//debug($medName);
		//$this->saveAll(array('description'=>$medName,'patient_uniqueid'=>$data['NewCropPrescription']['patient_uniqueid']));
		//$lastinsid=$this->getInsertId();
		return true;
	}

	function insertMedication_order($data =array(),$dataAlerrgy=array()){
		$session = new cakeSession();
		$rxnatom= ClassRegistry::init('PharmacyItem');
		$patientOrder= ClassRegistry::init('PatientOrder');
		//$ReviewCategory= ClassRegistry::init('ReviewSubCategory');
		$NewCropAllergies= ClassRegistry::init('NewCropAllergies');
		$Patient= ClassRegistry::init('Patient');
		$getPersonId=$Patient->find('first',array('fields'=>array('person_id'),'conditions'=>array('id'=>$session->read('patientId'))));
		$getOrderSentence=$patientOrder->find('first',array('fields'=>array('review_id'),'conditions'=>array('id'=>$data['NewCropPrescription']['patient_order_id'])));
		/*$getId=$ReviewCategory->find('first',array('fields'=>array('id'),
				'conditions'=>array('name'=>trim($getOrderSentence['PatientOrder']['review_id']))));
		$reviewId=$getId['ReviewSubCategory']['id'];*/
		// conditions Checks
		if($data['NewCropPrescription']['checkoverride']!='1'){
			//to check interaction
		 $getAllMedicationTocheckInteraction=$this->find('all',array('fields'=>array('drug_id'),'conditions'=>array('patient_uniqueid'=>$data['NewCropPrescription']['patient_uniqueid'],'archive'=>'N')));
		 for($i=0;$i<count($getAllMedicationTocheckInteraction);$i++){
		 	$id[]=$getAllMedicationTocheckInteraction[$i]['NewCropPrescription']['drug_id'];
		 	 
		 }
		 $getID=$rxnatom->find('first',array('fields'=>array('PharmacyItem.drug_id'),'conditions'=>array('PharmacyItem.name'=>$data['NewCropPrescription']['description'])));
		 $id[]=$getID['PharmacyItem']['drug_id'];
		 $patientId=$data['NewCropPrescription']['patient_uniqueid'];
		 	$getInteractionResult=$this->drugdruginteracton($id,$patientId);
		 	
		 	// Specail For Allergy
		 	$DrugId[0]=$getID['PharmacyItem']['drug_id'];
		 	$getInteractionAllergy=$NewCropAllergies->drugAllergyInteraction($dataAlerrgy,$DrugId[0]);
		 	$getCount=$getInteractionResult['rowcount'];
		 	if($getCount!=0 || $getInteractionAllergy['rowcount']==1){
		 		for($i=0;$i<count($getCount);$i++){
		 			
		 			$interactionData['AllDataChk'][$i]=$getInteractionResult['rowDta']->DrugInteraction[$i];
		 			
		 		}
		 		
		 		return array('interactionData'=>$interactionData,'allergyInteraction'=>$getInteractionAllergy);
		 		exit;
		 	}
		 	else{
		 	$data['NewCropPrescription']['archive']='N';
			$data['NewCropPrescription']['date_of_prescription']=date('Y-m-d');
			$data['NewCropPrescription']['is_ccda']='1';
			//$data['NewCropPrescription']['review_sub_category_id']=$reviewId;
			//$data['NewCropPrescription']['review_sub_category_id']=$data['NewCropPrescription'][]
			$rxnorm= $rxnatom->find('first',array('fields'=>array('rxcui','rxcui'),'conditions'=>array('name'=>$data['NewCropPrescription']['description'])));//imp
			$getID=$rxnatom->find('first',array('fields'=>array('PharmacyItem.drug_id'),'conditions'=>array('PharmacyItem.name'=>$data['NewCropPrescription']['description'])));//Drug_id
			$data['NewCropPrescription']['rxnorm']=$rxnorm['PharmacyItem']['rxcui'];
			$data['NewCropPrescription']['drug_id']=$getID['PharmacyItem']['drug_id'];
			$data['NewCropPrescription']['drug_name']=$data['NewCropPrescription']['description'];

			$session = new cakeSession();
			$getDataToUpdate=$this->find('first',array('conditions'=>array('patient_order_id'=>$data['NewCropPrescription']['patient_order_id'],
					'patient_uniqueid'=>$data['NewCropPrescription']['patient_uniqueid'])));
			$data['NewCropPrescription']['location_id'] = $session->read('locationid');
			$data['NewCropPrescription']['medication_administering_time'] = $data['NewCropPrescription']['firstdose'];
			if(empty($getDataToUpdate)){
				$data['NewCropPrescription']['drug_name'] = $data['NewCropPrescription']['description'];
				$data['NewCropPrescription']['note_id'] =$session->read('noteId');
				$data['NewCropPrescription']['patient_id'] =$getPersonId['Patient']['person_id'];
				//generate medication QrCode
				$data['NewCropPrescription']['qrcode_image'] = $this->getMedicationQrCode($data);
				$this->save($data);
				$rValue="save";
				return trim($rValue);
				exit;
			}
			else{
				//Update medication QrCode
				//$data['NewCropPrescription']['review_sub_category_id']=$reviewId;
				$data['NewCropPrescription']['qrcode_image'] = $this->getMedicationQrCode($data);
				$data['NewCropPrescription']['medication_administering_time'] = $data['NewCropPrescription']['firstdose'];
				$this->updateAll(array('patient_uniqueid'=>"'".$data['NewCropPrescription']['patient_uniqueid']."'",'description'=>"'".$data['NewCropPrescription']['description']."'",
						'drug_name'=>"'".$data['NewCropPrescription']['description']."'",'qrcode_image'=>"'".$data['NewCropPrescription']['qrcode_image']."'",
						'patient_id'=>$getPersonId['Patient']['person_id'],'note_id'=>$session->read('noteId'),'patient_order_id'=>"'".$data['NewCropPrescription']['patient_order_id']."'",'dose'=>"'".$data['NewCropPrescription']['dose']."'",
						'strength'=>"'".$data['NewCropPrescription']['strength']."'",'route'=>"'".$data['NewCropPrescription']['route']."'",'frequency'=>"'".$data['NewCropPrescription']['frequency']."'",
						'duration'=>"'".$data['NewCropPrescription']['duration']."'",'refills'=>"'".$data['NewCropPrescription']['refills']."'",'prn'=>"'".$data['NewCropPrescription']['prn']."'",
						'daw'=>"'".$data['NewCropPrescription']['daw']."'",'special_instruction'=>"'".$data['NewCropPrescription']['special_instruction']."'",
						'firstdose'=>"'".$data['NewCropPrescription']['firstdose']."'",'stopdose'=>"'".$data['NewCropPrescription']['stopdose']."'",'DosageForm'=>"'".$data['NewCropPrescription']['DosageForm']."'",
						'archive'=>"'".$data['NewCropPrescription']['archive']."'",'date_of_prescription'=>"'".$data['NewCropPrescription']['date_of_prescription']."'",'is_ccda'=>"'".$data['NewCropPrescription']['is_ccda']."'",
						'rxnorm'=>"'".$data['NewCropPrescription']['rxnorm']."'",'drug_id'=>"'".$data['NewCropPrescription']['drug_id']."'",'location_id'=>"'".$data['NewCropPrescription']['location_id']."'",
						'review_sub_category_id'=>"'".$data['NewCropPrescription']['review_sub_category_id']."'",'medication_administering_time'=>"'".$data['NewCropPrescription']['medication_administering_time']."'"),//,'medication_administering_time'=>"'".$data['NewCropPrescription']['medication_administering_time']."'"),

						array('patient_order_id'=>$data['NewCropPrescription']['patient_order_id']));
				$rValue="update";
				return trim($rValue);
				exit;
			}

			return true;
		}
		}
		//EOF
		else{ 
			
			
			$data['NewCropPrescription']['archive']='N';
			$data['NewCropPrescription']['date_of_prescription']=date('Y-m-d');
			$data['NewCropPrescription']['is_ccda']='1';
			$data['NewCropPrescription']['review_sub_category_id']=$reviewId;
			$rxnorm= $rxnatom->find('first',array('fields'=>array('rxcui','rxcui'),'conditions'=>array('name'=>$data['NewCropPrescription']['description'])));//imp
			$getID=$rxnatom->find('first',array('fields'=>array('PharmacyItem.drug_id'),'conditions'=>array('PharmacyItem.name'=>$data['NewCropPrescription']['description'])));//Drug_id
			$data['NewCropPrescription']['rxnorm']=$rxnorm['PharmacyItem']['rxcui'];
			$data['NewCropPrescription']['drug_id']=$getID['PharmacyItem']['drug_id'];
			$data['NewCropPrescription']['medication_administering_time'] = $data['NewCropPrescription']['firstdose'];
			$data['NewCropPrescription']['drug_name']=$data['NewCropPrescription']['description'];

			$session = new cakeSession();

			$getDataToUpdate=$this->find('first',array('conditions'=>array('patient_order_id'=>$data['NewCropPrescription']['patient_order_id'])));
			$data['NewCropPrescription']['location_id'] = $session->read('locationid');
			$data['NewCropPrescription']['created_by'] = $session->read('userid');
			$data['NewCropPrescription']['modified_by'] = $session->read('userid');
			$data['NewCropPrescription']['medication_administering_time'] = $data['NewCropPrescription']['firstdose'];
			if(empty($getDataToUpdate)){
				$data['NewCropPrescription']['drug_name'] = $data['NewCropPrescription']['description'];
				//generate medication QrCode
				$data['NewCropPrescription']['qrcode_image'] = $this->getMedicationQrCode($data);

				$this->save($data);
				$rValue="save";
				return trim($rValue);
				exit;
			}
			else{
				//Update medication QrCode
				$data['NewCropPrescription']['qrcode_image'] = $this->getMedicationQrCode($data);
				$data['NewCropPrescription']['medication_administering_time'] = $data['NewCropPrescription']['firstdose'];
				$this->updateAll(array('patient_uniqueid'=>"'".$data['NewCropPrescription']['patient_uniqueid']."'",'description'=>"'".$data['NewCropPrescription']['description']."'",
						'drug_name'=>"'".$data['NewCropPrescription']['description']."'",'qrcode_image'=>"'".$data['NewCropPrescription']['qrcode_image']."'",
						'patient_order_id'=>"'".$data['NewCropPrescription']['patient_order_id']."'",'dose'=>"'".$data['NewCropPrescription']['dose']."'",
						'strength'=>"'".$data['NewCropPrescription']['strength']."'",'route'=>"'".$data['NewCropPrescription']['route']."'",'frequency'=>"'".$data['NewCropPrescription']['frequency']."'",
						'duration'=>"'".$data['NewCropPrescription']['duration']."'",'refills'=>"'".$data['NewCropPrescription']['refills']."'",'prn'=>"'".$data['NewCropPrescription']['prn']."'",
						'daw'=>"'".$data['NewCropPrescription']['daw']."'",'special_instruction'=>"'".$data['NewCropPrescription']['special_instruction']."'",
						'firstdose'=>"'".$data['NewCropPrescription']['firstdose']."'",'stopdose'=>"'".$data['NewCropPrescription']['stopdose']."'",
						'archive'=>"'".$data['NewCropPrescription']['archive']."'",'date_of_prescription'=>"'".$data['NewCropPrescription']['date_of_prescription']."'",'is_ccda'=>"'".$data['NewCropPrescription']['is_ccda']."'",
						'rxnorm'=>"'".$data['NewCropPrescription']['rxnorm']."'",'drug_id'=>"'".$data['NewCropPrescription']['drug_id']."'",'location_id'=>"'".$data['NewCropPrescription']['location_id']."'",
						'modified_by'=>"'".$data['NewCropPrescription']['modified_by']."'",'medication_administering_time'=>"'".$data['NewCropPrescription']['medication_administering_time']."'",
						'review_sub_category_id'=>"'".$data['NewCropPrescription']['review_sub_category_id']."'"),

						array('patient_order_id'=>$data['NewCropPrescription']['patient_order_id']));
				$rValue="update";
				return trim($rValue);
				exit;
			}

			return true; 
		}
	}
	public function drugdruginteracton($durgId=array(),$id=null,$allDrugId=array()){
		$session     = new cakeSession();
		foreach( $allDrugId as $data){
			$myDrugId[]=$data['NewCropPrescription']['drug_id'];
			
		}
		for($k=0;$k<count($durgId);$k++){
			$explodeDurgId=explode('|',$durgId[$k]);
			$myDrugId2[]=$explodeDurgId['0'];
		}
	 /*	echo "<pre>";print_r($myDrugId);
		echo "<pre>";print_r($myDrugId2);exit; */
		$NewCropPrescription = ClassRegistry::init('NewCropPrescription');
		$NewCropAllergies = ClassRegistry::init('NewCropAllergies');
		$Facility= ClassRegistry::init('Facility');
		$Facility->unBindModel(array(
				'hasOne'=>array('FacilityDatabaseMapping','FacilityUserMapping')
		));
		$facility = $Facility->find('first', array('fields'=> array('Facility.id','Facility.name'),'conditions'=>array('Facility.is_deleted' => 0, 'Facility.is_active' => 1,'Facility.id' => $session->read("facilityid"))));
			
		$locationId  = $session->read('locationid') ;
		$curlData='<?xml version="1.0" encoding="utf-8"?>
				<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
				<soap:Body>
				<DrugDrugInteraction xmlns="https://secure.newcropaccounts.com/V7/webservices">
				<credentials>
				<PartnerName>DrMHope</PartnerName>
				<Name>'.Configure::read('uname').'</Name>
				<Password>'.Configure::read('passw').'</Password>
				</credentials>
				<accountRequest>
				<AccountId>drmhope</AccountId>
				<SiteId>1</SiteId>
				</accountRequest>
				<patientRequest>
				<PatientId>'.$allDrugId['NewCropPrescription'][0]['patient_id'].'</PatientId>
						</patientRequest>
						<patientInformationRequester>
						<UserType>S</UserType>
						<UserId>'.$allDrugId['NewCropPrescription'][0]['patient_id'].'</UserId>
								</patientInformationRequester>
								<currentMedications>';
		for($i=0;$i<count($myDrugId);$i++){
			$medId.='<string>'.$myDrugId[$i].'</string>';
		}
		$curlData.=$medId;
		$curlData.= '</currentMedications>
				<proposedMedications>';
		for($i=0;$i<count($myDrugId2);$i++){
			$medId1.='<string>'.trim($myDrugId2[$i]).'</string>';
		}
		$curlData.=$medId1;
				$curlData.='</proposedMedications>
				<drugStandardType>F</drugStandardType>
				</DrugDrugInteraction>
				</soap:Body>
				</soap:Envelope>';
		$url=Configure::read('newCropDrugUrl');
		$curl = curl_init();
			
		curl_setopt ($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl,CURLOPT_TIMEOUT,120);
		curl_setopt($curl,CURLOPT_HTTPHEADER,array (
		'SOAPAction:"https://secure.newcropaccounts.com/V7/webservices/DrugDrugInteraction"',
		'Content-Type: text/xml; charset=utf-8',
		));
		curl_setopt ($curl, CURLOPT_POST, 1);
		curl_setopt ($curl, CURLOPT_POSTFIELDS, $curlData);
		$finalxml=$finalxml[0];
		$result = curl_exec($curl);
		curl_close ($curl);
		if($result!="")
		{
			$xml =simplexml_load_string($result);
			$xml->registerXPathNamespace("soap", "http://schemas.xmlsoap.org/soap/envelope/");
			$finalxml=$xml->xpath('//soap:Body');
			$finalxml=$finalxml[0];
			//debug($finalxml);
			//exit;
			$rowData= $finalxml->DrugDrugInteractionResponse->DrugDrugInteractionResult->drugInteractionArray;
			$rowcount= (string) $finalxml->DrugDrugInteractionResponse->DrugDrugInteractionResult->result->RowCount;
			$rowcount=(string) $finalxml->DrugDrugInteractionResponse->DrugDrugInteractionResult->result->RowCount;
			$xmldata = simplexml_load_string($xmlString);
		}		
		return array('rowcount'=>$rowcount,'rowDta'=>$rowData);
	}

	
	/**
	 * @name getMedicationQrCode
	 * @method to generate medication Qrcode for individual meds
	 * @param  NewCropPrescription data
	 * @return void
	 * @author Yashwant C.
	 */
	public function getMedicationQrCode($medicationData = array()){
		App::import('Component', 'QRCode');
		//$QRCode = new QRCodeComponent();

		$patientId = $medicationData['NewCropPrescription']['patient_uniqueid'];
			
		$qrText .= $medicationData['NewCropPrescription']['description']."^~~^".$medicationData['NewCropPrescription']['route']
		."^~~^".$medicationData['NewCropPrescription']['frequency']."^~~^".$medicationData['NewCropPrescription']['dose'];
		QRCodeComponent::text($qrText);
		// display new QR code image to temporary folder
		QRCodeComponent::draw(150, "uploads/qrcodes/medicationQrCode/medicationQR/".$patientId.$medicationData['NewCropPrescription']['description'].".png");

		return $patientId.$medicationData['NewCropPrescription']['description'].".png";
	}
	public function findDurgForPatient($patient_id){
		$getDrug=$this->find('all',array('conditions'=>array('patient_uniqueid'=>$patient_id)));
		return $getDrug;
	}

	
	//BOF yashwant quick patient reg.------//
	public function insertDrugFromQuickReg($data=array(),$id){
		$session = new cakeSession();
		$drug	= ClassRegistry::init('PharmacyItem');
		$note	= ClassRegistry::init('Note');
		$suggestedDrug	= ClassRegistry::init('SuggestedDrug');
		$newcropprescription= ClassRegistry::init('NewCropPrescription');
		//insert blank entry in note table so that prescription will appear in soap note
		$note->save(array('patient_id'=>$id,'create_time'=>date("Y-m-d H:i:s"),'created_by'=>$session->read('userid'),
				'subject'=>$data['Patient']['advice'],'note_date'=>$data['Patient']['form_received_on'],'note_type'=>'general',
				'sb_registrar'=>$data['Patient']['doctor_id']));
		
		$data['Note']['create_time'] = date("Y-m-d H:i:s");
		$data['Note']["created_by"]  =  $session->read('userid');
	
		$note_id = $note->getInsertId();
		
		//BOF check and insert drugs
		if(!(empty($note_id)))
		{
			$suggestedDrug->deleteAll(array('SuggestedDrug.note_id' => $note_id,'SuggestedDrug.patient_id'=>$data['Note']['patient_id']), false);
			$newcropprescription->deleteAll(array('NewCropPrescription.note_id' => $note_id,'NewCropPrescription.patient_uniqueid'=>$data['Note']['patient_id']), false);
		}
		
		foreach($data['drugText'] as $key =>$value){
			if(!empty($value)){
				//$drugResult= $drug->find('first',array('fields'=>array('id','name'),'conditions'=>array('PharmacyItem.name'=>$value,"PharmacyItem.pack"=>$data['Pack'][$key],"PharmacyItem.location_id"=> $session->read('locationid'))));
				 
				$drugResult= $drug->find('first',array('fields'=>array('id','name','code'),'conditions'=>array('PharmacyItem.name'=>$value,"PharmacyItem.location_id"=> $session->read('locationid'))));
				$drug->id ='';
				$suggestedDrug->id = '';
				if($drugResult){
					$data['SuggestedDrug']['drug_id'] = $drugResult['PharmacyItem']['id'];
					$data['NewCropPrescription']['drug_id'] = $drugResult['PharmacyItem']['id'];
				}else{
					$drug->save(array('name'=>$value,'location_id'=> $session->read('locationid')));
					$data['SuggestedDrug']['drug_id']= $drug->getInsertID();
					$data['NewCropPrescription']['drug_id'] = $drug->getInsertID();;
				}
				//BOF check and insert diagnosis drugs of patient
				 
				//explode drug name
				$drug_name=explode(" ",$value);
				$data['SuggestedDrug']['note_id']=$note_id;
				$data['SuggestedDrug']['route']=  $data['route_administration'][$key];
				$data['SuggestedDrug']['dose']= $data['dose_type'][$key];
				$data['SuggestedDrug']['frequency']= $data['frequency'][$key];
				$data['SuggestedDrug']['strength']= $data['strength'][$key];
				$data['SuggestedDrug']['refills']= $data['refills'][$key];
				$data['SuggestedDrug']['quantity']= $data['quantity'][$key];
				$data['SuggestedDrug']['prn']= $data['prn'][$key];
				$data['SuggestedDrug']['daw']= $data['daw'][$key];
				$data['SuggestedDrug']['day']= $data['day'][$key];
				$data['SuggestedDrug']['isactive']= $data['isactive'][$key];
				$data['SuggestedDrug']['special_instruction']= $data['special_instruction'][$key];
				$data['SuggestedDrug']['batch_identifier'] = time(); //maintaining for grouping medication those at once .
				$data['SuggestedDrug']['start_date']=DateFormatComponent::formatDate2STD($data['start_date'][$key],Configure::read('date_format')) ;
				$data['SuggestedDrug']['end_date']= DateFormatComponent::formatDate2STD($data['end_date'][$key],Configure::read('date_format')) ;
				$data['SuggestedDrug']['rxnorm_code']= $drugResult['PharmacyItem']['code'];
				$data['SuggestedDrug']['patient_id'] = $id;
				//set session value here for updating note_id
				$session->write('med_batch_identifier',$data['SuggestedDrug']['batch_identifier'] );
				$data['NewCropPrescription']['note_id']=$note_id;
				$data['NewCropPrescription']['location_id']=$session->read('locationid');;
				$data['NewCropPrescription']['route']=  $data['route_administration'][$key];
				$data['NewCropPrescription']['dose']= $data['dose_type'][$key];
				$data['NewCropPrescription']['frequency']= $data['frequency'][$key];
				$data['NewCropPrescription']['strength']= $data['strength'][$key];
				$data['NewCropPrescription']['refills']= $data['refills'][$key];
				$data['NewCropPrescription']['quantity']= $data['quantity'][$key];
				$data['NewCropPrescription']['prn']= $data['prn'][$key];
				$data['NewCropPrescription']['daw']= $data['daw'][$key];
				$data['NewCropPrescription']['day']= $data['day'][$key];
				$data['NewCropPrescription']['special_instruction']= $data['special_instruction'][$key];
				$data['NewCropPrescription']['batch_identifier'] = time(); //maintaining for grouping medication those at once .
				$data['NewCropPrescription']['firstdose']=DateFormatComponent::formatDate2STD($data['start_date'][$key],Configure::read('date_format')) ;
				$data['NewCropPrescription']['stopdose']= DateFormatComponent::formatDate2STD($data['end_date'][$key],Configure::read('date_format')) ;
				$data['NewCropPrescription']['rxnorm']= $drugResult['PharmacyItem']['code'];
				$data['NewCropPrescription']['patient_id'] = $data ['Patient']['person_id'];
				$data['NewCropPrescription']['patient_uniqueid'] = $id;
				$data['NewCropPrescription']['drug_name'] = $drug_name[0];
				$data['NewCropPrescription']['description'] = $value;
				$data['NewCropPrescription']['drug_id'] = $data['drug_id'][$key];
				$data['NewCropPrescription']['date_of_prescription'] = date("Y-m-d H:i:s");
				$data['NewCropPrescription']['medication_administering_time'] = $data['NewCropPrescription']['firstdose'];
				if($data['isactive'][$key]==1)
					$data['NewCropPrescription']['archive'] = "N";
				else
					$data['NewCropPrescription']['archive'] = "Y";
				
				/*if(is_array($data['drugTime'][$key])){
				 $data['SuggestedDrug']['first']=  isset($data['drugTime'][$key][0])?$data['drugTime'][$key][0]:'';
				$data['SuggestedDrug']['second']= isset($data['drugTime'][$key][1])?$data['drugTime'][$key][1]:'';
				$data['SuggestedDrug']['third']= isset($data['drugTime'][$key][2])?$data['drugTime'][$key][2]:'';
				$data['SuggestedDrug']['forth']= isset($data['drugTime'][$key][3])?$data['drugTime'][$key][3]:'';
				}*/
		
				$suggestedDrug->save($data['SuggestedDrug']);
				$newcropprescription->saveAll(Array($data['NewCropPrescription']));
				 
				unset($data['SuggestedDrug']);
				unset($data['NewCropPrescription']);
				$suggestedDrug->id="";
				$newcropprescription->id="";
				//EOF check and insert diagnosis drugs of patient
			}
		}
		return true  ; 
	} ///------EOF pt. quick reg.-------////
	
	
	public function alternateDrugWithFormulary($patient_id=null,$drugId=null,$healthPlanId=null,$healthPlanTypeId=null){
		$session     = new cakeSession();
		$healthPlanTypeId="S";
		$Facility= ClassRegistry::init('Facility');
		$Facility->unBindModel(array(
				'hasOne'=>array('FacilityDatabaseMapping','FacilityUserMapping')
		));
		$facility = $Facility->find('first', array('fields'=> array('Facility.id','Facility.name'),'conditions'=>array('Facility.is_deleted' => 0, 'Facility.is_active' => 1,'Facility.id' => $session->read("facilityid"))));
			
		$locationId  = $session->read('locationid') ;
		$curlData='<?xml version="1.0" encoding="utf-8"?>
				<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
				<soap:Body>
				<FormularyAlternativesWithDrugInfo2 xmlns="https://secure.newcropaccounts.com/V7/webservices">
				<credentials>
				<PartnerName>DrMHope</PartnerName>
				<Name>'.Configure::read('uname').'</Name>
				<Password>'.Configure::read('passw').'</Password>
				</credentials>
				<accountRequest>
				<AccountId>'.$facility[Facility][name].'</AccountId>
				<SiteId>'.$facility[Facility][id].'</SiteId>
				</accountRequest>
				<patientRequest>
				<PatientId>'.$patient_id.'</PatientId>
						</patientRequest>
						<patientInformationRequester>
						<UserType>S</UserType>
						<UserId>'.$patient_id.'</UserId>
								</patientInformationRequester>
								<healthplanID>'.$healthPlanId.'</healthplanID>
								<healthplanTypeID>'.$healthPlanTypeId.'</healthplanTypeID>
								<eligibilityIndex>0</eligibilityIndex>
								<drugConcept>'.$drugId.'</drugConcept>
								<drugConceptType>F</drugConceptType>
								';
		$curlData.='</FormularyAlternativesWithDrugInfo2>
				</soap:Body>
				</soap:Envelope>';
			
		$url=Configure::read('SOAPUrl');
		$curl = curl_init();
			
		curl_setopt ($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl,CURLOPT_TIMEOUT,120);
		curl_setopt($curl,CURLOPT_HTTPHEADER,array (
		'SOAPAction:"https://secure.newcropaccounts.com/V7/webservices/FormularyAlternativesWithDrugInfo2"',
		'Content-Type: text/xml; charset=utf-8',
		));
		curl_setopt ($curl, CURLOPT_POST, 1);
		curl_setopt ($curl, CURLOPT_POSTFIELDS, $curlData);
		$finalxml=$finalxml[0];
		$result = curl_exec($curl);
		
		curl_close ($curl);
		if($result!="")
		{
			$xml =simplexml_load_string($result);
			$xml->registerXPathNamespace("soap", "http://schemas.xmlsoap.org/soap/envelope/");
			$finalxml=$xml->xpath('//soap:Body');
			$finalxml=$finalxml[0];
					
			$rowData= $finalxml->FormularyAlternativesWithDrugInfo2Response->FormularyAlternativesWithDrugInfo2Result->drugFormularyDetailArray->DrugFormularyDetail;
			$rowcount= (string) $finalxml->FormularyAlternativesWithDrugInfo2Response->FormularyAlternativesWithDrugInfo2Result->result->RowCount;		
			
		}
		return array('rowData'=>$rowData);
	}
	
	public function formularyCoverage($patient_id=null,$drugId=null,$healthPlanId=null,$healthPlanTypeId=null){
		$session     = new cakeSession();
		$healthPlanTypeId="S";
		$Facility= ClassRegistry::init('Facility');
		$Facility->unBindModel(array(
				'hasOne'=>array('FacilityDatabaseMapping','FacilityUserMapping')
		));
		$facility = $Facility->find('first', array('fields'=> array('Facility.id','Facility.name'),'conditions'=>array('Facility.is_deleted' => 0, 'Facility.is_active' => 1,'Facility.id' => $session->read("facilityid"))));
			
		$locationId  = $session->read('locationid') ;
		$curlData='<?xml version="1.0" encoding="utf-8"?>
				<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
				<soap:Body>
				<FormularyCoverage xmlns="https://secure.newcropaccounts.com/V7/webservices">
				<credentials>
				<PartnerName>DrMHope</PartnerName>
				<Name>'.Configure::read('uname').'</Name>
				<Password>'.Configure::read('passw').'</Password>
				</credentials>
				<accountRequest>
				<AccountId>'.$facility[Facility][name].'</AccountId>
				<SiteId>'.$facility[Facility][id].'</SiteId>
				</accountRequest>
				<patientRequest>
				<PatientId>'.$patient_id.'</PatientId>
						</patientRequest>
						<patientInformationRequester>
						<UserType>S</UserType>
						<UserId>'.$patient_id.'</UserId>
								</patientInformationRequester>
								<healthplanID>'.$healthPlanId.'</healthplanID>
								<healthplanTypeID>'.$healthPlanTypeId.'</healthplanTypeID>
								<eligibilityIndex>0</eligibilityIndex>
								<drugConcept><string>'.$drugId.'</string></drugConcept>
								<drugConceptType>F</drugConceptType>
								';
		$curlData.='</FormularyCoverage>
				</soap:Body>
				</soap:Envelope>';
			
		$url=Configure::read('formularyUrl');
		$curl = curl_init();
			
		curl_setopt ($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl,CURLOPT_TIMEOUT,120);
		curl_setopt($curl,CURLOPT_HTTPHEADER,array (
		'SOAPAction:"https://secure.newcropaccounts.com/V7/webservices/FormularyCoverage"',
		'Content-Type: text/xml; charset=utf-8',
		));
		curl_setopt ($curl, CURLOPT_POST, 1);
		curl_setopt ($curl, CURLOPT_POSTFIELDS, $curlData);
		$finalxml=$finalxml[0];
		$result = curl_exec($curl);
		
	
		curl_close ($curl);
		if($result!="")
		{
			$xml =simplexml_load_string($result);
			$xml->registerXPathNamespace("soap", "http://schemas.xmlsoap.org/soap/envelope/");
			$finalxml=$xml->xpath('//soap:Body');
			$finalxml=$finalxml[0];
			
			$rowData= $finalxml->FormularyCoverageResponse->FormularyCoverageResult->formularyCoverageDetailArray->FormularyCoverageDetail->FormularyStatus;
			
				
		}
		return $rowData;
	}
	
        public function checkPreviousPhraseTaken($patientId,$smartPhraseId){ 
            $data = $this->find('first',array('conditions'=>array('is_deleted'=>'0','smart_pharse_id'=>$smartPhraseId,'patient_uniqueid'=>$patientId)));
            if(!empty($data['NewCropPrescription']['id'])){
                return true;
            }else{
                return false;
            }
        }
        
        /**
         * function to return patient medications
         * @param  unknown_type $patientId
         * @author Atul T. Chandankhede
         */
        public function getSmartMed($patientId){
        	$this->bindModel(array(
        			'belongsTo' => array(
        					'PharmacyItem'=>array('type'=>'INNER','foreignKey' => false,'conditions'=>array('PharmacyItem.id=NewCropPrescription.drug_id')),
        					'PharmacyItemRate'=>array('type'=>'INNER','foreignKey' => false,'conditions'=>array('PharmacyItemRate.item_id=PharmacyItem.id')),
        			)),false);
        	 
        	$getMedData=$this->find('all',array('fields'=>array('NewCropPrescription.id','NewCropPrescription.description','NewCropPrescription.quantity',
        			'NewCropPrescription.frequency','NewCropPrescription.day','NewCropPrescription.is_override','NewCropPrescription.drug_id','NewCropPrescription.drug_name',
        			'NewCropPrescription.date_of_prescription','NewCropPrescription.patient_id','NewCropPrescription.patient_uniqueid','NewCropPrescription.pharmacy_sales_bill_id',
        			'NewCropPrescription.is_deleted','NewCropPrescription.status','NewCropPrescription.recieved_quantity','NewCropPrescription.special_instruction','PharmacyItem.id',
        			'PharmacyItem.stock','PharmacyItem.opdgeneral_ward_discount','PharmacyItemRate.mrp','PharmacyItemRate.sale_price'),
        			'conditions'=>array('NewCropPrescription.patient_uniqueid'=>$patientId,'NewCropPrescription.is_discharge_medication'=>'0','NewCropPrescription.is_deleted'=>0),
        			'group'=>array('NewCropPrescription.id')));
        
        
        	return $getMedData;
        }
		
		public function getMedicationHistory($patientId,$apptId){
		$getMedicationRecords=$this->find('all',array('fields'=>array('drug_name','description','date_of_prescription','route','dose','frequency','dose_unit','DosageForm','created','refills','strength','strength_unit','firstdose','stopdose'),
				'conditions'=>array('NewCropPrescription.patient_uniqueid'=>$patientId/*,'NewCropPrescription.appointment_id'=>$apptId,*/,'archive'=>'N','NewCropPrescription.is_deleted'=>0,'NewCropPrescription.is_assessment' =>'0')));
		return $getMedicationRecords;

		}
		public function getPastMedicationHistory($patientId,$apptId){
		$getMedicationRecords=$this->find('all',array('fields'=>array('id','description','date_of_prescription','route','dose','frequency','dose_unit','stopdose','refills'),
				'conditions'=>array('NewCropPrescription.patient_uniqueid'=>$patientId/*,'NewCropPrescription.appointment_id'=>$apptId,*/,'archive'=>'Y','NewCropPrescription.is_deleted'=>0)));
		return $getMedicationRecords;
	
	}
}
?>
