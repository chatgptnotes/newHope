<?php
/**
 * SmartPhrase Model
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       SmartPhrase Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
class SmartPhrase extends AppModel {

	public $specific = true;
	public $name = 'SmartPhrase';
	public $useTable = 'smart_phrases';
	public $patientData = array();
	const MULTILINELINESEPARATOR = '!!!!!!!!!!';
	
	
	
  	public function __call($method, $arguments) {	
    	list ($name , $var ) = split ('get' , $method );
    	$orgContent = $var;
    	$method = strtolower($var);
    	$name = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $var));
    	if(isset($this->patientData->Patient->$method)){
    		return $this->patientData->Patient->$method;
    	}else
    	if(isset($this->patientData->Person->$method)){
    		return $this->patientData->Person->$method;
    	}else
    	if(isset($this->patientData->Patient->$name)){
    			return $this->patientData->Patient->$name;
    	}else
    	if(isset($this->patientData->Person->$name)){
    		return $this->patientData->Person->$name;
    	}else {
    		return $orgContent;
    	}
    	
    }
	
	function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds)){
        	$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	 	}else{
	 		$this->db_name =  $ds;
	 	}
		parent::__construct($id, $table, $ds);
	}
	
	public function getAge(){
		$date1 = new DateTime($this->patientData->Person->dob);
		$date2 = new DateTime();
		$interval = $date1->diff($date2);
		if($interval->y){
			return $interval->y . " Year";
		}else if($interval->m){
			return $interval->m . " Month";
		}else if($interval->d){
			return $interval->d . " Day";
		}else{
			return "Age not recorded";
		}
	}
	
	public function getPatientDetails($patientId){
		$patientModel = ClassRegistry::init('Patient');
		$this->patientData = $patientModel->getPatientDetailsByIDWithTariff($patientId);
		$this->patientData = json_encode($this->patientData);
		$this->patientData = json_decode($this->patientData);
		$this->patientData->Patient->name = $this->patientData->PatientInitial->name.' '.$this->patientData->Person->first_name.' '.$this->patientData->Person->last_name;
	}
	
	public function matchString($term,$content){
		
		preg_match_all("/[A-Z]{3,100}/", $content, $matches);
		if(count($matches) > 0){
			$session = new CakeSession();
			$patientId = $session->read('smartphrase_patient_id');
			
			$this->getPatientDetails($patientId);
			foreach ($matches[0] as $match){
				$method = 'get'.Inflector::camelize($match);
				$content = str_replace($match,$this->$method(),$content);
			}
			$content = $this->multiLineSeparator($content,false);
           return $content;
		}else{
			return $content;
		}
	}
	
	/**
	 * Function to replace line breaks with self::MULTILINELINESEPARATOR
	 * @param string $string
	 * @return string $string
	 */
	
	public function multiLineSeparator($string,$flag=true){
		if($flag)
		$string = strtoupper($string);
		if(!empty($string)){			
		$string = str_replace("\r\n","",$string);	
		$string = str_replace("RADIOLOGY :","\nRADIOLOGY :",$string);	
		$string = str_replace("\n",self::MULTILINELINESEPARATOR,str_replace("\r\n",self::MULTILINELINESEPARATOR,$string));
		}
		return $string;
	
	}
	
	
	/**
	 * Function to get the problems of patient
	 * @param int $patientId
	 * @return string $problems
	 */
	public function getProbl(){
		$session = new CakeSession();
		$patientId = $session->read('smartphrase_patient_id');
		$noteDiagnosisModel = ClassRegistry::init('NoteDiagnosis');
		$noteDiagnoses = $noteDiagnosisModel->find('all',array('fields'=>array('NoteDiagnosis.diagnoses_name','NoteDiagnosis.icd_id'),'conditions' => array('NoteDiagnosis.patient_id' =>$patientId)));
		if(count($noteDiagnoses) > 0){
			foreach($noteDiagnoses as $noteDiagnosis)
				if($problems)
					$problems .= self::MULTILINELINESEPARATOR.$this->multiLineSeparator($noteDiagnosis['NoteDiagnosis']['diagnoses_name']) . ' [' . $this->multiLineSeparator($noteDiagnosis['NoteDiagnosis']['icd_id']).']';
			else
				$problems .= $this->multiLineSeparator($noteDiagnosis['NoteDiagnosis']['diagnoses_name']) . ' [' . $this->multiLineSeparator($noteDiagnosis['NoteDiagnosis']['icd_id']).']';
			return $problems;
		}else{
			return "No Problems recorded for patient";
		}
	}
	
	/**
	 * Function to get the allergies of patient
	 * @param int $patientId
	 * @return string $allergies
	 */
	public function getAlg(){
		$session = new CakeSession();
		$patientId = $session->read('smartphrase_patient_id');
		$newCropAllergyModel = ClassRegistry::init('NewCropAllergies');
		$newCropAllergies = $newCropAllergyModel->find('all',array('fields'=>array('NewCropAllergies.name','NewCropAllergies.rxnorm'),'conditions' => array('NewCropAllergies.patient_uniqueid' =>$patientId,'NewCropAllergies.status'=>'A')));
		//pr($newCropAllergies);exit;
		if(count($newCropAllergies) > 0){
			foreach($newCropAllergies as $newCropAllergy)
				if($allergies)
				$allergies .= self::MULTILINELINESEPARATOR.$this->multiLineSeparator($newCropAllergy['NewCropAllergies']['name']) ;//. ' [' . $this->multiLineSeparator($noteDiagnosis['NewCropAllergies']['rxnorm']).']'
			else
				$allergies .= $this->multiLineSeparator($newCropAllergy['NewCropAllergies']['name']) ;//. ' [' . $this->multiLineSeparator($noteDiagnosis['NewCropAllergies']['rxnorm']).']'
			return $allergies;
		}else{
			return "No Allergies recorded for patient";
		}
	}
	
	/**
	 * Function to get the current medications of patient
	 * @param int $patientId
	 * @return string $medications
	 */
	public function getCmed(){
		$session = new CakeSession();
		$patientId = $session->read('smartphrase_patient_id');
		$newCropPrescriptionModel = ClassRegistry::init('NewCropPrescription');
		$newCropPrescriptions = $newCropPrescriptionModel->find('all',array('fields'=>array('NewCropPrescription.description','NewCropPrescription.dose','NewCropPrescription.route','NewCropPrescription.frequency'),'conditions' => array('NewCropPrescription.patient_uniqueid' =>$patientId,'NewCropPrescription.archive'=>'N')));
		if(count($newCropPrescriptions) > 0){
			foreach($newCropPrescriptions as $newCropPrescription)
				if($medications)
					$medications .= self::MULTILINELINESEPARATOR.$this->multiLineSeparator($newCropPrescription['NewCropPrescription']['description']) .' '. $this->multiLineSeparator($noteDiagnosis['NewCropPrescription']['dose']) .' '. $this->multiLineSeparator($noteDiagnosis['NewCropPrescription']['route']) .' '. $this->multiLineSeparator($noteDiagnosis['NewCropPrescription']['frequency']);
			else
				$medications .= $this->multiLineSeparator($newCropPrescription['NewCropPrescription']['description']) .' '. $this->multiLineSeparator($noteDiagnosis['NewCropPrescription']['dose']) .' '. $this->multiLineSeparator($noteDiagnosis['NewCropPrescription']['route']) .' '. $this->multiLineSeparator($noteDiagnosis['NewCropPrescription']['frequency']);
			return $medications;
		}else{
			return "No Medications recorded for patient";
		}
	}
	
	/**
	 * Function to get the past medications of patient
	 * @param int $patientId
	 * @return string $pastMedications
	 */
	public function getPmh(){
		$session = new CakeSession();
		$patientId = $session->read('smartphrase_patient_id');
		$newCropPrescriptionModel = ClassRegistry::init('NewCropPrescription');
		$newCropPrescriptions = $newCropPrescriptionModel->find('all',array('fields'=>array('NewCropPrescription.description','NewCropPrescription.dose','NewCropPrescription.route','NewCropPrescription.frequency'),'conditions' => array('NewCropPrescription.patient_uniqueid' =>$patientId,'NewCropPrescription.archive'=>'Y')));
		if(count($newCropPrescriptions) > 0){
			foreach($newCropPrescriptions as $newCropPrescription)
				if($pastMedications)
					$pastMedications .= self::MULTILINELINESEPARATOR.$this->multiLineSeparator($newCropPrescription['NewCropPrescription']['description']) .' '. $this->multiLineSeparator($noteDiagnosis['NewCropPrescription']['dose']) .' '. $this->multiLineSeparator($noteDiagnosis['NewCropPrescription']['route']) .' '. $this->multiLineSeparator($noteDiagnosis['NewCropPrescription']['frequency']);
			else
				$pastMedications .= $this->multiLineSeparator($newCropPrescription['NewCropPrescription']['description']) .' '. $this->multiLineSeparator($noteDiagnosis['NewCropPrescription']['dose']) .' '. $this->multiLineSeparator($noteDiagnosis['NewCropPrescription']['route']) .' '. $this->multiLineSeparator($noteDiagnosis['NewCropPrescription']['frequency']);
			return $pastMedications;
		}else{
			return "No Past Medications recorded for patient";
		}
	}
	
	/**
	 * Function to get the family history of patient
	 * @param int $patientId
	 * @return string $familyHistory
	 */
	public function getFamhx (){
		$session = new CakeSession();
		$patientId = $session->read('smartphrase_patient_id');
		$encounterIds=$this->encounterHandler($patientId);
		$familyHistoryModel = ClassRegistry::init('FamilyHistory');
		$familyHistories = $familyHistoryModel->find('all',array('conditions' => array('FamilyHistory.patient_id' =>$encounterIds)));
		
		if(count($familyHistories) > 0){
			foreach($familyHistories as $familyHistory){
				$father=unserialize(stripslashes($familyHistory['FamilyHistory']['problemf']));
				$mother=unserialize(stripslashes($familyHistory['FamilyHistory']['problemm']));
				$brother=unserialize(stripslashes($familyHistory['FamilyHistory']['problemb']));
				$sister=unserialize(stripslashes($familyHistory['FamilyHistory']['problems']));
				$son=unserialize(stripslashes($familyHistory['FamilyHistory']['problemson']));
				$daughter=unserialize(stripslashes($familyHistory['FamilyHistory']['problemd']));
				if($father['0']){
					if($familyHistoryFather)
						$familyHistoryFather .= self::MULTILINELINESEPARATOR.$this->multiLineSeparator(implode(",",unserialize(stripslashes($familyHistory['FamilyHistory']['problemf'])))).'				Father';
					else 
						$familyHistoryFather .= $this->multiLineSeparator(implode(",",unserialize(stripslashes($familyHistory['FamilyHistory']['problemf'])))).'				Father';
				}
				
				if($mother['0']){
					if($familyHistoryMother)
						$familyHistoryMother .= self::MULTILINELINESEPARATOR.$this->multiLineSeparator(implode(",",unserialize(stripslashes($familyHistory['FamilyHistory']['problemm'])))).'				Mother';
					else
						$familyHistoryMother .= $this->multiLineSeparator(implode(",",unserialize(stripslashes($familyHistory['FamilyHistory']['problemm'])))).'				Mother';
				}
				
				if($brother['0']){
					if($familyHistoryBrother)
						$familyHistoryBrother .= self::MULTILINELINESEPARATOR.$this->multiLineSeparator(implode(",",unserialize(stripslashes($familyHistory['FamilyHistory']['problemb'])))).'				Brother';
					else
						$familyHistoryBrother .= $this->multiLineSeparator(implode(",",unserialize(stripslashes($familyHistory['FamilyHistory']['problemb'])))).'				Brother';
				}
				if($sister['0']){
					if($familyHistorySister)
						$familyHistorySister .= self::MULTILINELINESEPARATOR.$this->multiLineSeparator(implode(",",unserialize(stripslashes($familyHistory['FamilyHistory']['problems'])))).'				Sister';
					else
						$familyHistorySister .= $this->multiLineSeparator(implode(",",unserialize(stripslashes($familyHistory['FamilyHistory']['problems'])))).'				Sister';
				}
				
				if($son['0']){
					if($familyHistorySon)
						$familyHistorySon .= self::MULTILINELINESEPARATOR.$this->multiLineSeparator(implode(",",unserialize(stripslashes($familyHistory['FamilyHistory']['problemson'])))).'				Son';
					else
						$familyHistorySon .= $this->multiLineSeparator(implode(",",unserialize(stripslashes($familyHistory['FamilyHistory']['problemson'])))).'				Son';
				}
				
				if($daughter['0']){
					if($familyHistoryDaughter)
						$familyHistoryDaughter .= self::MULTILINELINESEPARATOR.$this->multiLineSeparator(implode(",",unserialize(stripslashes($familyHistory['FamilyHistory']['problemd'])))).'				Daughter';
					else
						$familyHistoryDaughter .= $this->multiLineSeparator(implode(",",unserialize(stripslashes($familyHistory['FamilyHistory']['problemd'])))).'				Daughter';
				}
			}
			
			return $familyHistoryFather.$separator.$familyHistoryMother.$separator.$familyHistoryBrother.$separator.$familyHistorySister.$separator.$familyHistorySon.$separator.$familyHistoryDaughter;
		}else{
			return "No Past Family Histories recorded for patient";
		}
	}
	
	/**
	 * Function to get the past surgical history of patient
	 * @param int $patientId
	 * @return string $surgeries
	 */
	public function getPsh(){
		$session = new CakeSession();
		$patientId = $session->read('smartphrase_patient_id');
		$diagnosisModel = ClassRegistry::init('ProcedureHistory');
		$diagnosisSurgeries = $diagnosisModel->find('all',array('fields'=>array('ProcedureHistory.procedure_name'),'conditions' => array('ProcedureHistory.patient_id' =>$patientId)));
		if(count($diagnosisSurgeries) > 0){
			foreach($diagnosisSurgeries as $diagnosisSurgery)
				if($surgeries)
				$surgeries .= self::MULTILINELINESEPARATOR.$this->multiLineSeparator($diagnosisSurgery['ProcedureHistory']['procedure_name'],false);
			else
				$surgeries .= $this->multiLineSeparator($diagnosisSurgery['ProcedureHistory']['procedure_name'],false);
			
			return $surgeries;
		}else{
			return "No Past Surgeries recorded for patient";
		}
	}
	
	/**
	 * Function to insert Smart Phrase to master
	 * @param request array
	 * @return boolean true 
	 */
	public function insertPhrase($data = array()){
		
		$session     = new cakeSession();
		//$userid 	 = $session->read('userid') ;
		//$locationId  = $session->read('locationid') ;
			
	/*	if(!empty($data["SmartPhrase"]["id"])){
			$data["SmartPhrase"]["modify_time"] = date("Y-m-d H:i:s");
			$data["SmartPhrase"]["modified_by"] = empty($userid)?'1':$userid;
			$data["SmartPhrase"]["location_id"] = $locationId ;
		}else{
			$data["SmartPhrase"]["create_time"] = date("Y-m-d H:i:s");
			$data["SmartPhrase"]["modify_time"] = date("Y-m-d H:i:s");
			$data["SmartPhrase"]["created_by"]  = empty($userid)?'1':$userid;
			$data["SmartPhrase"]["modified_by"] = empty($userid)?'1':$userid;
			$data["SmartPhrase"]["location_id"] = $locationId ;
		}*/
		
		
		//pr($data['Person']) ;
		$this->create();
		$data['SmartPhrase']['phrase']=strtolower($data['SmartPhrase']['phrase']);
		$data['SmartPhrase']['location_id']=$_SESSION['Auth']['User']['location_id'];
	
		$value = $this->save($data['SmartPhrase']);
		unset($data['SmartPhrase']['location_id']);
		$this->id=null;	
		
		if(empty($data['SmartPhrase']['id'])){		
			$data['SmartPhrase']['phrase']=strtolower($data['SmartPhrase']['phrase'])."inv";
			$value = $this->save($data['SmartPhrase']);
			$this->id=null;
		}else{	
				
			$getinvId=$this->find('first',array('fields'=>array('SmartPhrase.id'),'conditions'=>array('SmartPhrase.phrase'=>$data['SmartPhrase']['phrase']."inv")));
			if(empty($getinvId)){
				$getinvId1=$this->find('first',array('fields'=>array('SmartPhrase.id','SmartPhrase.phrase'),'conditions'=>array('SmartPhrase.phrase'=>$data['SmartPhrase']['phrase'])));					
				$getinvId['SmartPhrase']['id']=$getinvId1['SmartPhrase']['id']+1;
				$updateData['SmartPhrase']['phrase']=$getinvId1['SmartPhrase']['phrase']."inv";
			}
			$updateData['SmartPhrase']['id']=$getinvId['SmartPhrase']['id'];
			$updateData['SmartPhrase']['phrase_text']=$data['SmartPhrase']['phrase_text'];	
				
			$value = $this->save($updateData);
		}
		return $value;
		
	}
	/** Adity- dynamic lab rad save for pharse **/
	public function createDynTempLabRad($labData=null,$radData=null,$name,$chiefComplaint=null){
	
		$Laboratory = ClassRegistry::init('Laboratory');
		$Radiology = ClassRegistry::init('Radiology');
	
		$strHead='<?xml version="1.0" encoding="UTF-8"?><template>';
		$strTial='</template>';
		$strLab='';
		$strRad='';		
		$arryLab=explode(',',$labData);
		/**  To unlike the file **/
		$file ="smartphrase_templates".DS.$name."inv.xml";
		if (!unlink($file))
		{
			//echo ("Error deleting $file");
		}
		else
		{
			//echo ("Deleted $file");
		}
		// debug($name);exit;
		/** **/
		if(!empty($chiefComplaint)){
		$strChiefComp.='<ChiefComplaints>'."\n";
		$strChiefComp.='<ChiefComplaint>';
		$strChiefComp.='<name>';
		$strChiefComp.=$chiefComplaint;
		$strChiefComp.='</name>';
		$strChiefComp.='</ChiefComplaint>'."\n";
		$strChiefComp.='</ChiefComplaints>';
		}
		$labData=$Laboratory->find('all',array('fields'=>array('id','name'),'conditions'=>array('id'=>array_filter($arryLab))));
		$strLab.='<laboratories>'."\n";
		foreach($labData as $data){
			$table = $this->get_html_translation_table_CP1252();
			$substance = strtr($data['Laboratory']['name'],$table) ;
			$strLab.='<Laboratory>';
			$strLab.='<name>';
			$strLab.=$substance;
			$strLab.='</name>';
			$strLab.='<id>';
			$strLab.=$data['Laboratory']['id'];
			$strLab.='</id>';
			$strLab.='</Laboratory>'."\n";
		}
		/*if(count(array_filter($arryLab))==1){
			$strLab.='<Laboratory>';
			$strLab.='<name>';
			$strLab.=" ";
			$strLab.='</name>';
			$strLab.='<id>';
			$strLab.=" ";
			$strLab.='</id>';
			$strLab.='</Laboratory>'."\n";
		}*/
		$strLab.='</laboratories>';
		$arryRad=explode(',',$radData);
		$rabData=$Radiology->find('all',array('fields'=>array('id','name'),'conditions'=>array('id'=>array_filter($arryRad))));
		$strRad.='<radiologies>'."\n";
		foreach($rabData as $dataRad){
			$table = $this->get_html_translation_table_CP1252();
			$substanceRad = strtr($dataRad['Radiology']['name'],$table) ;
			$strRad.='<Radiology>';
			$strRad.='<id>';
			$strRad.=$dataRad['Radiology']['id'];
			$strRad.='</id>';
			$strRad.='<name>';
			$strRad.=$substanceRad;
			$strRad.='</name>';
			$strRad.='</Radiology>'."\n";
		}
	/*	if(count(array_filter($arryRad))==1){
			$strRad.='<Radiology>';
			$strRad.='<id>';
			$strRad.=" ";
			$strRad.='</id>';
			$strRad.='<name>';
			$strRad.=" ";
			$strRad.='</name>';
			$strRad.='</Radiology>'."\n";
		}*/
		$strRad.='</radiologies>';
		$mainStr=$strHead. "\n".$strChiefComp. "\n".$strLab."\n".$strRad."\n".$strTial;
		file_put_contents("smartphrase_templates".DS.strtolower($name)."inv.xml", $mainStr);		
		/*************/		
			return true;
		
	}
	/** Adity- dynamic lab rad save for pharse EOD **/
	public function createDynTempMed($medData=array(),$name){	
	
		if(empty($medData['smartName'])){
			$medData['smartName']=$medData['phraseName'];
		}
		
		$TariffList = ClassRegistry::init('TariffList');
		$count=count($medData['drugText']);
		$PharmacyItem = ClassRegistry::init('PharmacyItem'); // MED_STRENGTH(10) MED_STRENGTH_UOM(mg) MED_ROUTE_ABBR(oral)
		$route=Configure::read('route_administration');
		$dose_type=Configure::read('dose_type');
		$strength1=Configure::read('strength');
		$frequencyConfig=Configure::read('frequency');
		$roopCongif=Configure::read('roop');
		/**  To unlike the file **/
		
		if(!empty($medData['pharse_name'])){
			//debug($medData['pharse_name']);exit;
			$file ="smartphrase_templates".DS.trim($medData['pharse_name']).".xml";
			if (!unlink($file))
			{
				//echo ("Error deleting $file");
			}
			else
			{
				//echo ("Deleted $file");
			}
		}
		// debug($name);exit;
		/** **/
	
		$strHead='<?xml version="1.0" encoding="UTF-8"?><template>';
		$strTial='</template>';
		$strMed='';
		$strMed.='<newcropprescriptions>'."\n";
		//$physiocnt=0;
		$strPhy="";
		for($i=0;$i<$count;$i++){
			
			if(empty($medData['drug_id'][$i])) continue ; //if there is no drug exist in post data then no need to insert into xml.
			$medicationName =str_replace("&","@@",$medData['drugText'][$i]);
		/*	$medicationName =str_replace("+","plus@@",$medData['drugText'][$i]);
			$medicationName =str_replace("-","minus@@",$medData['drugText'][$i]);
			$medicationName =str_replace(">","great@@",$medData['drugText'][$i]);
			$medicationName =str_replace("<","less@@",$medData['drugText'][$i]);*/
			
			$table = $this->get_html_translation_table_CP1252();
			$substanceMed = strtr($medicationName,$table) ;
			$strMed.='<NewCropPrescription><id>';
			$strMed.=$i;
			$strMed.='</id>'."\n";
			// name
			$strMed.='<description>';
			$strMed.=$substanceMed;
			$strMed.='</description>'."\n";
			//dose
			$strMed.='<dose>';
			if(empty($medData['dose_type'][$i])){
				$dose_type='0';
			}else{
				$dose_type=$medData['dose_type'][$i];
			}
			$strMed.=$dose_type;
			$strMed.='</dose>'."\n";
			//doseForm
			if(empty($medData['DosageForm'][$i])){
				$DosageForm='1';
			}else{
				$DosageForm=$medData['DosageForm'][$i];
			}
			$strMed.='<doseForm>';
			$strMed.=$DosageForm;
			$strMed.='</doseForm>'."\n";
			//route
			if(empty($medData['route_administration'][$i])){
				$route_administration='2';
			}else{
				$route_administration=$medData['route_administration'][$i];
			}
			$strMed.='<route>';
			$strMed.=$route_administration;
			$strMed.='</route>'."\n";
			//route
			if(empty($medData['frequency'][$i])){
				$frequency='2';
			}else{
				$frequency=$medData['frequency'][$i];
			}
			$strMed.='<frequency>';
			$strMed.=$frequency;
			$strMed.='</frequency>'."\n";
			
			if(empty($medData['strength'][$i])){
				$medData['strength'][$i]='1';
			}
			if(empty($frequencyConfig[$medData['frequency'][$i]])){
				$frequencyConfig[$medData['frequency'][$i]]='2';
			}
			if(empty($medData['route_administration'][$i])){
				$medData['route_administration'][$i]='1';
			}
			
			/*$freq_val = Configure::read('frequency_value');
			$qty=$DosageForm*$freq_val[$frequency];*/
			
			
			$strMed.='<quantity>';
			$strMed.=$medData['quantity'][$i];
			$strMed.='</quantity>'."\n";
			//display on text
			$defaultTabletcount=$medData['dosageValue'][$i];//1 inj.:: symbol 50 inj 1*1 - 50 mg : oral / fortnightly x 30
			if(!empty($medData['strength'][$i])){
			$strMed.='<display>';
			$strMed.=$defaultTabletcount." ".$roopCongif[$medData['strength'][$i]].":: ".$medicationName." --- ".$medData['dose_type'][$i]." ".$strength1[$medData['DosageForm'][$i]]." : ".$route[$medData['route_administration'][$i]]." / ".$frequencyConfig[$medData['frequency'][$i]]." X ".trim($medData['days'][$i])." # ".$medData['quantity'][$i] ;
			$strMed.='</display>'."\n";
			}
			/*if(!empty($physioAllData[$i]['TariffList']['id'])){
				$physiocnt=$physiocnt+$count;
			$strPhy.='<idPhysiotherapy>';
			$strPhy.=$physiocnt ;
			$strPhy.='</idPhysiotherapy>'."\n";
			$strPhy.='<displayPhysiotherapy>';
			$strPhy.="Physiotherapy : \n".$physioAllData[$i]['TariffList']['name'] ;
			$strPhy.='</displayPhysiotherapy>'."\n";
			}*/
			//drug_id
			$strMed.='<drug_id>';
			$strMed.=trim($medData['drug_id'][$i]);
			$strMed.='</drug_id>';
			//days
			$strMed.='<days>';
			$strMed.=trim($medData['days'][$i]);
			$strMed.='</days>';
			$strMed.='<strength>';
			$strMed.=trim($medData['strength'][$i]);
			$strMed.='</strength>';
			
			$strMed.='<dosage>';
			$strMed.=trim($medData['dosageValue'][$i]);
			$strMed.='</dosage>';			
			
			$strMed.='<Active>';
			$strMed.=trim($medData['isactive'][$i]);
			$strMed.='</Active></NewCropPrescription>'."\n";
		}
		$strMed.='</newcropprescriptions>';
		
		$strPhy.='<TariffLists>'."\n";
		$arryPhysio=explode(',',$medData['physioCodestr']);
		$arryPhysio=array_filter($arryPhysio);
		$physioAllData=$TariffList->find('all',array('fields'=>array('id','name'),'conditions'=>array('id'=>array_filter($arryPhysio))));
	
		$countTarif=count($arryPhysio);
		for($j=0;$j<$countTarif;$j++){
			$table = $this->get_html_translation_table_CP1252();
			//$substancePhy = strtr($arryPhysio[$j],$table) ;
			$strPhy.='<TariffList><id>';
			$strPhy.=$j;
			$strPhy.='</id>'."\n";		
			$strPhy.='<idTariffList>';
			$strPhy.=$physioAllData[$j]['TariffList']['id'];
			$strPhy.='</idTariffList>'."\n";
			$strPhy.='<display>';
			$strPhy.=$physioAllData[$j]['TariffList']['name'];
			$strPhy.='</display>'."\n";			
			$strPhy.='</TariffList>'."\n";		
		}
		$strPhy.='</TariffLists>';
		$mainStrMed=$strHead. "\n".$strMed."\n".$strPhy."\n".$strTial;
		
		if(file_put_contents("smartphrase_templates".DS.strtolower($medData['smartName']).".xml", $mainStrMed)){
			return 'Smart Phase created';
		}else{
			return 'Smart Phase not created';
		}
		

		return true;
	}
	public function linkDia($diaIds,$name){
		$SnomedMappingMaster = ClassRegistry::init('SnomedMappingMaster');
		$expArrayDai=explode(',',$diaIds);
	
	
		if(count($expArrayDai)==1){
			$getR=$SnomedMappingMaster->find('first',array('fields'=>array("is_smart"),'conditions'=>array('id'=>$diaIds)));
			$arry['SnomedMappingMaster']['id']=$diaIds;
	
			if(!empty($getR['SnomedMappingMaster']['is_smart'])){
				$getIsSmartExp=explode("|",$getR['SnomedMappingMaster']['is_smart']);
				foreach($getIsSmartExp as $key=>$dataName){
					if(trim($dataName)==trim($name)){
						$arry['SnomedMappingMaster']['is_smart']=$getR['SnomedMappingMaster']['is_smart'];
					}elseif (trim($dataName)!=trim($name)){
						$getAddName=trim($name);
						$arry['SnomedMappingMaster']['is_smart']=$getR['SnomedMappingMaster']['is_smart']." | ".$getAddName;
					}
						
				}
					
			}else{
				$arry['SnomedMappingMaster']['is_smart']=trim($name);
					
			}
			$SnomedMappingMaster->save($arry['SnomedMappingMaster']);
			$SnomedMappingMaster->id="";
		
		}else{
			$expArrayDai=array_filter($expArrayDai);
			foreach($expArrayDai as $data){
				$getR=$SnomedMappingMaster->find('first',array('fields'=>array("is_smart"),'conditions'=>array('id'=>$data)));
				$arry['SnomedMappingMaster']['id']=$data;
				if(!empty($getR['SnomedMappingMaster']['is_smart'])){
					$getIsSmartExp=explode("|",$getR['SnomedMappingMaster']['is_smart']);
					//debug($getIsSmartExp);//exit;
					foreach($getIsSmartExp as $key=>$dataName){
						if(trim($dataName)==trim($name)){
							$arry['SnomedMappingMaster']['is_smart']=$getR['SnomedMappingMaster']['is_smart'];
						}elseif (trim($dataName)!=trim($name)){
							$getAddName=trim($name);
							$arry['SnomedMappingMaster']['is_smart']=$getR['SnomedMappingMaster']['is_smart']." | ".$getAddName;
						}
							
					}
	
				}else{
					$arry['SnomedMappingMaster']['is_smart']=trim($name);
	
				}
				$SnomedMappingMaster->save($arry['SnomedMappingMaster']);
				$SnomedMappingMaster->id="";
			}
				
		}
	
	}

	
	function get_html_translation_table_CP1252() {
		$trans = get_html_translation_table(HTML_ENTITIES);
		$trans[chr(130)] = '&sbquo;';    // Single Low-9 Quotation Mark
		$trans[chr(131)] = '&fnof;';    // Latin Small Letter F With Hook
		$trans[chr(132)] = '&bdquo;';    // Double Low-9 Quotation Mark
		$trans[chr(133)] = '&hellip;';    // Horizontal Ellipsis
		$trans[chr(134)] = '&dagger;';    // Dagger
		$trans[chr(135)] = '&Dagger;';    // Double Dagger
		$trans[chr(136)] = '&circ;';    // Modifier Letter Circumflex Accent
		$trans[chr(137)] = '&permil;';    // Per Mille Sign
		$trans[chr(138)] = '&Scaron;';    // Latin Capital Letter S With Caron
		$trans[chr(139)] = '&lsaquo;';    // Single Left-Pointing Angle Quotation Mark
		$trans[chr(140)] = '&OElig;    ';    // Latin Capital Ligature OE
		$trans[chr(145)] = '&lsquo;';    // Left Single Quotation Mark
		$trans[chr(146)] = '&rsquo;';    // Right Single Quotation Mark
		$trans[chr(147)] = '&ldquo;';    // Left Double Quotation Mark
		$trans[chr(148)] = '&rdquo;';    // Right Double Quotation Mark
		$trans[chr(149)] = '&bull;';    // Bullet
		$trans[chr(150)] = '&ndash;';    // En Dash
		$trans[chr(151)] = '&mdash;';    // Em Dash
		$trans[chr(152)] = '&tilde;';    // Small Tilde
		$trans[chr(153)] = '&trade;';    // Trade Mark Sign
		$trans[chr(154)] = '&scaron;';    // Latin Small Letter S With Caron
		$trans[chr(155)] = '&rsaquo;';    // Single Right-Pointing Angle Quotation Mark
		$trans[chr(156)] = '&oelig;';    // Latin Small Ligature OE
		$trans[chr(159)] = '&Yuml;';    // Latin Capital Letter Y With Diaeresis
		$trans['&nbsp;'] = '&#160;';    // Latin Capital Letter Y With Diaeresis
		$trans['<'] = '&#60;';			// less then "<"
		$trans['>'] = '&#62;';			// less then ">"
	
		ksort($trans);
		return $trans;
	}
function linkDiaDelete($diaId,$namePharse){
	$SnomedMappingMaster = ClassRegistry::init('SnomedMappingMaster');
	$idArry=explode(',',$diaId);
	$listData=$SnomedMappingMaster->find('all',array('fields'=>array('id','is_smart'),'conditions'=>array('id'=>$idArry)));
	foreach($listData as $data){
		$is_smartExp=explode('|',$data['SnomedMappingMaster']['is_smart']);
		foreach($is_smartExp as $key=>$removeData){
			if(trim($removeData)==$namePharse){
				unset($is_smartExp[$key]);
			}
		}	
		$saveImplodeData=implode('|',$is_smartExp);
		$listData=$SnomedMappingMaster->updateAll(array('is_smart'=>"'.$saveImplodeData.'"),array('id'=>$data['SnomedMappingMaster']['id']));
	}
	
	
}

function listdirs($dir) {
	static $alldirs = array();
	$dirs = glob($dir . '/*', GLOB_ONLYDIR);
	if (count($dirs) > 0) {
		foreach ($dirs as $d) $alldirs[] = $d;
	}
	foreach ($dirs as $dir) $this->listdirs($dir);
	return $alldirs;
}

function saveLabEpen($labName,$patientId)
{
	
	$session = new cakeSession();
	$laboratory = ClassRegistry::init('Laboratory');
	$LaboratoryTestOrder = ClassRegistry::init('LaboratoryTestOrder');
	/******BOF-LAb Test Order save****///
	$getLaboratoryData=$laboratory->find('first',array('fields'=>array('id','name'),'conditions'=>array('Laboratory.name'=>$labName,'Laboratory.is_deleted'=>0)));
	
	$getLaboratoryTestOrderAllData=$LaboratoryTestOrder->find('first',array('fields'=>array('id','laboratory_id'),'conditions'=>array('LaboratoryTestOrder.is_deleted'=>0,'LaboratoryTestOrder.patient_id'=>$patientId,'LaboratoryTestOrder.laboratory_id'=>$getLaboratoryData['Laboratory']['id'])));
	/*$getLaboratoryData = array_map('strtolower', $getLaboratoryData);*/

		//$laboratoryTestOrderId = array_search(strtolower($value), $getLaboratoryData);
	
			//$getLaboratoryDatas['Laboratory']['id'] = $laboratoryTestOrderId;
			$rate=$laboratory->getRate($getLaboratoryData['Laboratory']['id']);
			$labData['LaboratoryTestOrder']['laboratory_id']=$getLaboratoryData['Laboratory']['id'];
			if(empty($rate['TariffAmount']['nabh_charges'])){
				$charge="0.00";
			}else{
				$charge=$rate['TariffAmount']['nabh_charges'];
			}
			$labData['LaboratoryTestOrder']['amount']=$charge;
			$labData['LaboratoryTestOrder']['editor_lab_chk']='1';
			$labData['LaboratoryTestOrder']['note_id']=$noteId;
			$labData['LaboratoryTestOrder']['patient_id']=$patientId;
			$labData['LaboratoryTestOrder']['batch_identifier'] = time ();
			$labData['LaboratoryTestOrder']['location_id'] = $session->read('locationid');
			$labData['LaboratoryTestOrder']['created_by']=$session->read('userid');
			$labData['LaboratoryTestOrder']['create_time']=date("Y-m-d H:i:s");
			$labData['LaboratoryTestOrder']['start_date']=date('Y-m-d H:i:s');
			$labData['LaboratoryTestOrder']['order_id']=$LaboratoryTestOrder->autoGeneratedLabID ( null );
			
			if(!empty($getLaboratoryTestOrderAllData['LaboratoryTestOrder']['id']))
				$labData['LaboratoryTestOrder']['id']=$getLaboratoryTestOrderAllData['LaboratoryTestOrder']['id'];
			else
				$labData['LaboratoryTestOrder']['id']="";
				
				
			
			if(!empty($getLaboratoryData['Laboratory']['id']))
			   $LaboratoryTestOrder->saveAll($labData['LaboratoryTestOrder']);
			/*$log = $this->LaboratoryTestOrder->getDataSource()->getLog(false, false);
				debug($log);*/
			
			return true;
		

	 
	
}


function saveRadEpen($radName,$patientId)
{
	$session = new cakeSession();
	$Radiology = ClassRegistry::init('Radiology');
	$RadiologyTestOrder = ClassRegistry::init('RadiologyTestOrder');
	/******BOF-Radiology Test Order save****///
		$getRadiologyData=$Radiology->find('first',array('fields'=>array('id','name'),'conditions'=>array('Radiology.name'=>$radName,'Radiology.is_deleted'=>0,'Radiology.location_id' => $session->read('locationid'))));
		$getRadiologyTestOrderAllData=$RadiologyTestOrder->find('first',array('fields'=>array('id','radiology_id'),'conditions'=>array('RadiologyTestOrder.is_deleted'=>0,'RadiologyTestOrder.patient_id'=>$patientId,'RadiologyTestOrder.radiology_id'=>$getRadiologyData['Radiology']['id'])));
	
		
			$getRateRad=$Radiology->getRate($radiologyTestOrderId);
				if(empty($getRateRad['TariffAmount']['nabh_charges'])){
					$putRate1="0.00";
				}else{
					$putRate1=$getRateRad['TariffAmount']['nabh_charges'];
				}
				//echo $putRate1." Rs";
				$radData['RadiologyTestOrder']['amount']=$putRate1;
				$radData['RadiologyTestOrder']['note_id']=$noteId;
				$radData['RadiologyTestOrder']['patient_id']=$patientId;
				$radData['RadiologyTestOrder']['radiology_id']=$getRadiologyData['Radiology']['id'];
				$radData['RadiologyTestOrder']['editor_rad_chk']='1';
				$radData['RadiologyTestOrder']['location_id'] = $session->read('locationid');
				$radData['RadiologyTestOrder']['created_by']=$session->read('userid');
				$radData['RadiologyTestOrder']['create_time']=date("Y-m-d H:i:s");
				$radData['RadiologyTestOrder']['radiology_order_date']=date("Y-m-d H:i:s");
				$radData['RadiologyTestOrder']['order_id']= $RadiologyTestOrder->autoGeneratedRadID();
				
								
				if(!empty($getRadiologyTestOrderAllData['RadiologyTestOrder']['id']))
					$radData['RadiologyTestOrder']['id']=$getRadiologyTestOrderAllData['RadiologyTestOrder']['id'];
				else
					$radData['RadiologyTestOrder']['id']="";
				
				
				if(!empty($getRadiologyData['Radiology']['id']))
				   $RadiologyTestOrder->saveAll($radData['RadiologyTestOrder']);
				
				return true;
	
}

function saveMedEpen($medName,$patientId)
{
	$session = new cakeSession();
	$Patient = ClassRegistry::init('Patient');
	$PharmacyItem = ClassRegistry::init('PharmacyItem');
	$NewCropPrescription=ClassRegistry::init('NewCropPrescription');
	//find id from pharmacy item table from the drug name
	if($session->read('website.instance')=='kanpur' && $session->read('locationid')=='22'){//to reduce stock from pharma extention  --Mahalaxmi
		$conditions["PharmacyItem.location_id"] = '26';
	}else if($session->read('website.instance')=='kanpur' && $session->read('locationid')=='1'){//to reduce stock from pharma extention  --Mahalaxmi
		$conditions["PharmacyItem.location_id"] = '25';
	}else{
		$conditions["PharmacyItem.location_id"] = $session->read('locationid');
	}
	//$conditions["PharmacyItem.stock >"]='0'; ///Commented By Mahalaxmi-this condition use after new db
	$conditions["PharmacyItem.name"]=$medName;
	$conditions["PharmacyItem.is_deleted"]="0";
	$getPharmacyItemData=$PharmacyItem->find('first',array('fields'=>array('id','name','drug_id'),'conditions'=>$conditions));
	$personId=$Patient->find('first',array('conditions'=>array('id'=>$patientId),array('fields'=>array('person_id'))));
	$getNewCropPrescriptionAllData=$NewCropPrescription->find('first',array('fields'=>array('id','drug_id'),'conditions'=>array('NewCropPrescription.is_deleted'=>0,'NewCropPrescription.drug_name'=>$medName,'NewCropPrescription.patient_uniqueid'=>$patientId,'NewCropPrescription.archive'=>'N')));
	//$getPharmacyItemData = array_map('strtolower', $getPharmacyItemData);*/
	
	//$cnt=0;
	
	
			$drugName[1] =str_replace("&amp;","&",$medName);
			$drugName[1] =str_replace("&#39;","'",$medName);
			$medData['drug_name']=trim($drugName[1]);
			$medData['description']=trim($drugName[1]);
			$medData['dose']=$dosageStrength[0];
			$medData['strength']=$selected_roop[trim(strtoupper($dosageValue[1]))];
			$medData['route']=$selected_route[trim(strtoupper($route[0]))];
			$medData['frequency']=$selected_frequency[trim(strtoupper($frequency[0]))];
			$getDayValue=explode("#",trim($frequency[1]));
			$medData['day']=$getDayValue['0'];
			$medData['archive']="N";
			$medData['patient_uniqueid']=$patientId;
			$medData['patient_id']=$personId['Patient']['person_id'];
			$medData['location_id']=$session->read('locationid');
			$medData['DosageForm']=$selected_strength[strtoupper($dosageStrength[1])];
			$medData['dosageValue']=trim($dosageValue[0]);
			
			if(!empty($getNewCropPrescriptionAllData['NewCropPrescription']['id']))
				$medData['id']=$getNewCropPrescriptionAllData['NewCropPrescription']['id'];
			else 
				$medData['id']="";
				
	
			//calculate quantity
			
	
			if(empty($medData['day']))
				$medData['day']=30;
			if(empty($freq))
				$freq=1;
				
	
			if(!empty($getQuantityForDisp['1'])){
				$medData['quantity']=$getQuantityForDisp['1'];
			}else{
				$qty=$medData['dosageValue']*$freq*$medData['day'];
				$medData['quantity']=$qty;
			}
	
			$medData['date_of_prescription']=date("Y-m-d H:i:s");
			$medData['drm_date']=date("Y-m-d");
			$medData['note_id'] = $id;
			$medData['editor_med_chk'] = "1";
			$medData['for_normal_med'] = '0';
			$medData['drug_id']=$getPharmacyItemData['PharmacyItem']['drug_id'];
			//eof
	
			//check if drug already present for this patient
				
		
		//save in newcropprescription
		if(!empty($getPharmacyItemData['PharmacyItem']['id']))
		   $NewCropPrescription->saveAll($medData);
		
		return true;
		
	
}
	

}
?>