<?php
/**
 * SmartPhraseXmlTemplate Model
 *
 * PHP 5
 * 
 *
 * @copyright     Copyright 2014 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       SmartPhraseXmlTemplate Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
App::import('Model','SmartPhrase');
#App::uses('SmartPhrase', 'Model');
#include APP.DS.'Cake'.DS.'Model'.'SmartPhrase.php';
class SmartPhraseXmlTemplate extends SmartPhrase {
	
	public $specific = true;
	public $name = 'SmartPhraseXmlTemplate';
	public $useTable = false;
	public $diagnoses = array();
	public $allergies = array();
	public $medications = array();
	public $labs = array();
	public $rads = array();
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
	public function matchString($term,$content){
		$this->parseTemplateXml($term);
		preg_match_all("/[A-Z]{3,100}/", $content, $matches);
		if(count($matches) > 0){
			$session = new CakeSession();
			$patientId = $session->read('smartphrase_patient_id');
			$this->getPatientDetails($patientId);
		
			foreach ($matches[0] as $match){
				$method = 'get'.Inflector::camelize($match);
				$content = str_replace($match,$this->$method(),$content);				
				$content=trim($content);
			}
			
			$content = $this->multiLineSeparator($content,false);		
			return $content;
		}else{
			return $content;
		}
	}
	
	
	/**
	 * Function to parse XML Template & Convert it into array
	 * @param XML
	 * @return array
	 */
	
	function parseTemplateXml($term){//echo 'smartphrase_templates'.DS.strtolower($term).'.xml';exit;
		$xmlString = file_get_contents('smartphrase_templates'.DS.strtolower($term).'.xml');
		$xml = simplexml_load_string($xmlString);
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);
		
		$medications = $allergies = $diagnoses = array();
		foreach($array['newcropprescriptions']['NewCropPrescription'] as $key=>$value){
			$this->medications[$key]['NewCropPrescription'] = $value;
		}
		foreach($array['newcropallergies']['NewCropAllergies'] as $key=>$value){
			$this->allergies[$key]['NewCropAllergies'] = $value;
		}
		foreach($array['diagnoses']['NoteDiagnosis'] as $key=>$value){
			$this->diagnoses[$key]['NoteDiagnosis'] = $value;
		}
		
		if(!empty($array['laboratories']['Laboratory'])){
		$arrayLab1=array();	
		$arrayLab1['laboratories']['Laboratory']['0']['name'] = "Laboratory : \n";		
		if(!empty($array['laboratories']['Laboratory']['name'])){
			$array['laboratories']['Laboratory']['0']['name']=$array['laboratories']['Laboratory']['name'];
			$array['laboratories']['Laboratory']['0']['id']=$array['laboratories']['Laboratory']['id'];
		}
		$arrayLab3=array_merge($arrayLab1['laboratories']['Laboratory'],$array['laboratories']['Laboratory']);			
		foreach($arrayLab3 as $key=>$value){		
			$this->labs[$key]['Laboratory'] = $value;
		}
		}
		if(!empty($array['radiologies']['Radiology'])){
		$arrayRad1=array();
		$arrayRad1['radiologies']['Radiology']['0']['name'] = "\n Radiology :";
		if(!empty($array['radiologies']['Radiology']['name'])){
			$array['radiologies']['Radiology']['0']['name']=$array['radiologies']['Radiology']['name'];
			$array['radiologies']['Radiology']['0']['id']=$array['radiologies']['Radiology']['id'];
		}
		$arrayRad3=array_merge($arrayRad1['radiologies']['Radiology'],$array['radiologies']['Radiology']);
		foreach($arrayRad3 as $key=>$value){
			$this->rads[$key]['Radiology'] = $value;
		}
		}
		
	}
	
	/**
	 * Function to get the problems of patient
	 * @param int $patientId
	 * @return string $problems
	 */
	public function getProbl(){
		$session = new CakeSession();
		$patientId = $session->read('smartphrase_patient_id');
		$noteDiagnoses = $this->diagnoses;
		if(count($noteDiagnoses) > 0){
			foreach($noteDiagnoses as $noteDiagnosis)
				if($problems){
					if($noteDiagnosis['NoteDiagnosis']['diagnoses_name'])
						$problems .= self::MULTILINELINESEPARATOR.$this->multiLineSeparator($noteDiagnosis['NoteDiagnosis']['diagnoses_name']) . ' [' . $this->multiLineSeparator($noteDiagnosis['NoteDiagnosis']['icd_id']).']';
				}
				else{
				if($noteDiagnosis['NoteDiagnosis']['diagnoses_name'])
					$problems .= $this->multiLineSeparator($noteDiagnosis['NoteDiagnosis']['diagnoses_name']) . ' [' . $this->multiLineSeparator($noteDiagnosis['NoteDiagnosis']['icd_id']).']';
			}
			return $problems;
		}else{
			parent::getProbl();
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
		$newCropAllergies = $this->allergies;
		if(count($newCropAllergies) > 0){
			foreach($newCropAllergies as $newCropAllergy)
				if($allergies)
				$allergies .= self::MULTILINELINESEPARATOR.$this->multiLineSeparator($newCropAllergy['NewCropAllergies']['name']);//. ' [' . $this->multiLineSeparator($noteDiagnosis['NewCropAllergies']['rxnorm']).']'
			else
				$allergies .= $this->multiLineSeparator($newCropAllergy['NewCropAllergies']['name']);// . ' [' . $this->multiLineSeparator($noteDiagnosis['NewCropAllergies']['rxnorm']).']'
			return $allergies;
		}else{
			parent::getAlg();
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
		$newCropPrescriptions = $this->medications; 
		if(count($newCropPrescriptions) > 0){
			foreach($newCropPrescriptions as $newCropPrescription)
				if($medications)
				$medications .= self::MULTILINELINESEPARATOR.$this->multiLineSeparator($newCropPrescription['NewCropPrescription']['display']) .' '. $this->multiLineSeparator($noteDiagnosis['NewCropPrescription']['dose']) .' '. $this->multiLineSeparator($noteDiagnosis['NewCropPrescription']['route']) .' '. $this->multiLineSeparator($noteDiagnosis['NewCropPrescription']['frequency']);
			else
				$medications .= $this->multiLineSeparator($newCropPrescription['NewCropPrescription']['display']) .' '. $this->multiLineSeparator($noteDiagnosis['NewCropPrescription']['dose']) .' '. $this->multiLineSeparator($noteDiagnosis['NewCropPrescription']['route']) .' '. $this->multiLineSeparator($noteDiagnosis['NewCropPrescription']['frequency']);
			return $medications;
		}else{
			parent::getCmed();
		}
	}
	
	/**
	 * Function to get the current labs of patient
	 * @param int $patientId
	 * @return string $labs
	 */
	public function getLab(){
		$session = new CakeSession();
		$patientId = $session->read('smartphrase_patient_id');
		$laboratories = $this->labs;
		if(count($laboratories) > 0){			
			foreach($laboratories as $laboratory){
			if($labs){			
				if(!empty($laboratory['Laboratory']['name']))
				$labs .= self::MULTILINELINESEPARATOR.$this->multiLineSeparator(trim($laboratory['Laboratory']['name']));
			}else{					
				if(!empty($laboratory['Laboratory']['name']))			
				$labs .= $this->multiLineSeparator(trim($laboratory['Laboratory']['name']));			
			}
		
			}
			return $labs;
			
		}else{
			//parent::getCmed();
		}
	}
	public function getPhysio(){
		$session = new CakeSession();
		$patientId = $session->read('smartphrase_patient_id');
		
	}
	
	/**
	 * Function to get the current rads of patient
	 * @param int $patientId
	 * @return string $rads
	 */
	public function getRad(){
		$session = new CakeSession();
		$patientId = $session->read('smartphrase_patient_id');
		$radiologies = $this->rads;
		if(count($radiologies) > 0){
			foreach($radiologies as $radiology){
				if($rads){	
					if(!empty($radiology['Radiology']['name']))				
				$rads .= self::MULTILINELINESEPARATOR.$this->multiLineSeparator(trim($radiology['Radiology']['name']));
				}else{			
					if(!empty($radiology['Radiology']['name'])){			
				$rads .= $this->multiLineSeparator(trim($radiology['Radiology']['name']));
					}	
				}		
			}
			return $rads;
		}else{
			//parent::getCmed();
		}
	}
}