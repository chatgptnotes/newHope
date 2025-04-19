<?php 
/**
 * WardPosting file
 *
 * PHP 5
 * 
 *
 * @copyright     Copyright 2015 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       ScheduleJobsShell
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj Mankar
 */
	
	App::uses('ConnectionManager', 'Model');
	App::uses('AppModel', 'Model');
	App::uses('Component', 'Controller');

	

	error_reporting(~E_NOTICE && ~E_WARNING);
	class ImportEpenShell extends AppShell { 

public $database=null;
	public function main() {
		$dataSource = ConnectionManager::getDataSource('default');
		$confDeafult = ConnectionManager::$config->defaultHospital;
		$this->database = $confDeafult['database'];
		$this->fetchEpenXml();
	}
	
	public function fetchEpenXml() {
		
		App::uses('SmartPhrase', 'Model');
		App::uses('Patient', 'Model');
		App::uses('LaboratoryTestOrder', 'Model');
		App::uses('RadiologyTestOrder', 'Model');
		App::uses('NewCropPrescription', 'Model');
		App::uses('Note', 'Model');
		App::uses('Appointment', 'Model');
		App::uses('Laboratory', 'Model');
		App::uses('Radiology', 'Model');
		App::uses('Audit', 'Model');
		
		
		
		$Patient = new Patient(null,null,$this->database);
		$SmartPhrase = new SmartPhrase(null,null,$this->database);
		$LaboratoryTestOrder = new LaboratoryTestOrder(null,null,$this->database);
		$RadiologyTestOrder = new RadiologyTestOrder(null,null,$this->database);
		$NewCropPrescription = new NewCropPrescription(null,null,$this->database);
		$Laboratory = new Laboratory(null,null,$this->database);
		$Radiology = new Radiology(null,null,$this->database);
		$Audit = new Audit(null,null,$this->database);
		
		
		$Note = new Note(null,null,$this->database);
		$Appointment = new Appointment(null,null,$this->database);
		
		
		$dirOutput = $this->listdirs(WWW_ROOT.'output');
		foreach($dirOutput as $dirsub)
		{
			
			$dir = $dirsub."/";
			if (is_dir($dir))
			{
				
				if ($dh = opendir($dir))
				{
					while (($file = readdir($dh)) !== false)
					{
						$fileExt=explode(".",$file);
						
						if($fileExt['1']!='xml')
							continue;
						
						if (($file !== '.') && ($file !== '..') )
						{
							
							$xmlString = file_get_contents($dir . $file);
							
							$xml = simplexml_load_string($xmlString);
							
							//loop through pageNo_1 for pathology, labaoratory and diagnosis
							$patientId=$xml->PageNo_1['Page1PatientUID'];
							
						
								
							//foreach($xml->PageNo_1 as $key=>$data){
							$dataArray=(array) $xml->PageNo_1;
							
							 //Specifically for kanpur and only for opd patient
							 $patientUId="GC/O-".$dataArray[PatientUID];
	
							$admission_id= $Patient->find('first', array('fields'=> array('id','location_id'),
									'conditions'=>array('Patient.admission_id'=>$patientUId),'callbacks' => false));
	
							$isPatientClosed= $Appointment->find('first', array('fields'=> array('status'),
									'conditions'=>array('Appointment.patient_id'=>$patientUId)));
	
							if($isPatientClosed['Appointment']['status']=='Closed')
								continue;
							 
							if(empty($admission_id['Patient']['id']))
								continue;
	
							//for pathology loop through 10
							for($i=1;$i<=10;$i++)
							{
							if(empty($dataArray['PathologyTest'.$i]))
								continue;
										 
								$islabSave=$this->saveLabEpen($dataArray['PathologyTest'.$i],$admission_id['Patient']['id'],$admission_id['Patient']['location_id']);
	
	
							}
							//for radiology loop through 10
							for($i=1;$i<=5;$i++)
							{
							if(empty($dataArray['RadiologyTest'.$i]))
								continue;
							$isRadSave=$this->saveRadEpen($dataArray['RadiologyTest'.$i],$admission_id['Patient']['id'],$admission_id['Patient']['location_id']);
	
						}
						//find labs and radiology which are saved for this patient through epen XML
						 
								$LaboratoryTestOrder->bindModel ( array (
						'belongsTo' => array (
								'Laboratory' => array (
										'foreignKey' => 'laboratory_id',
										'conditions' => array (
						'Laboratory.is_active' => 1
						)
						)
						)
						) );
	
	
						$addedLad=$LaboratoryTestOrder->find('all',array('fields'=>array('Laboratory.name'),'conditions'=>array('LaboratoryTestOrder.patient_id'=>$admission_id['Patient']['id']),'callbacks' => false));
						$labString="Laboratory :\n";
								 
						foreach($addedLad as $addedLadData){
								$labString.=$addedLadData['Laboratory']['name']."\n";
						}
	           
	
						$RadiologyTestOrder->bindModel ( array (
						'belongsTo' => array (
								'Radiology' => array (
								'foreignKey' => 'radiology_id',
								'conditions' => array (
								'Radiology.location_id' => $admission_id['Patient']['location_id']
								)
						)
						)
						) );
						$radString="Radiology :\n";
								$addedRad=$RadiologyTestOrder->find('all',array('fields'=>array('Radiology.name'),'conditions'=>array('RadiologyTestOrder.patient_id'=>$admission_id['Patient']['id'])));
								foreach($addedRad as $addedRadData){
								$radString.=$addedRadData['Radiology']['name']."\n";
								}
	
	
								//}
								 
								 		//loop through pageNo_2 for medication
								// foreach($xml->PageNo_2 as $key=>$dataMed){
								//$dataMedArray=(array) $xml->PageNo_2;
								
								//for medication loop through 15
										$medString="<p><strong>DIAGNOSIS : </strong> ".$dataArray[Diagnosis]."</p>";
										$medString.="<p><strong>Rx</strong></p>";
										for($j=1;$j<=10;$j++)
										{
												if(empty($dataArray['MedicineName'.$j]))
														continue;
	
														$isMedSave=$this->saveMedEpen($dataArray['MedicineName'.$j],$admission_id['Patient']['id'],$admission_id['Patient']['location_id'],$dataArray['NoOfDays'.$j],$dataArray['DosageOD'.$j],$dataArray['DosageBD'.$j],$dataArray['DosageTDS'.$j],$dataArray['Remarks'.$j]);
	
														if($isMedSave=="1")
														{
															$medString.="<p>".strtoupper($dataArray['Type'.$j]).":: ".strtoupper($dataArray['MedicineName'.$j])." X ".$dataArray['NoOfDays'.$j]."</p>";
	
																	 
						}
						}
	
						//find if note exist for given patient id
						$noteId= $Note->find('first', array('fields'=> array('id'),
						'conditions'=>array('Note.patient_id'=>$admission_id['Patient']['id'])));
	
						if(!empty($noteId['Note']['id']))
							$saveArrtNote['Note']['id']=$noteId['Note']['id'];
							else
								$saveArrtNote['Note']['id']="";
	   
	                        $chiefcomplaint=$dataArray['ChiefComplaint']."\n";
	                        $physioTherapyStr="\n"."<strong>Physiotherapy</strong>"."<br/>".$dataArray['Physiotherapy1']."<br/>".$dataArray['Physiotherapy2'];
							//insert data in note table
							$small_text= $chiefcomplaint.$labString.$radString;
							$template_full_text=$medString.$physioTherapyStr;
							$saveArrtNote['Note']['small_text']=$small_text;
							$saveArrtNote['Note']['template_full_text']=$template_full_text;
									$saveArrtNote['Note']['patient_id']=$admission_id['Patient']['id'];
							$saveArrtNote['Note']['epenxmlpath']=$dir;
							$saveArrtNote['Note']['epenxml_name']=$file;
	
							$Note->saveAll($saveArrtNote,array('callbacks' =>false));
							 
							// }
							 		 
							}
	
	
	
							}
							closedir($dh);
							}
							}
	
					}
	
					
	
	
					}
	
	function saveLabEpen($labName,$patientId,$locationid)
	{
	   		
		
		App::uses('Laboratory', 'Model');
		App::uses('LaboratoryTestOrder', 'Model');
		$dataSource = ConnectionManager::getDataSource('default');
		$confDeafult = ConnectionManager::$config->defaultHospital;
		$this->database = $confDeafult['database'];
		$laboratory = new Laboratory(null,null,$this->database);
		$LaboratoryTestOrder = new LaboratoryTestOrder(null,null,$this->database);
		
		/******BOF-LAb Test Order save****///
		$getLaboratoryData=$laboratory->find('first',array('fields'=>array('id','name'),'conditions'=>array('Laboratory.name'=>$labName,'Laboratory.is_deleted'=>0)));
	
		$getLaboratoryTestOrderAllData=$LaboratoryTestOrder->find('first',array('fields'=>array('id','laboratory_id'),'conditions'=>array('LaboratoryTestOrder.is_deleted'=>0,'LaboratoryTestOrder.patient_id'=>$patientId,'LaboratoryTestOrder.laboratory_id'=>$getLaboratoryData['Laboratory']['id'])));
		/*$getLaboratoryData = array_map('strtolower', $getLaboratoryData);*/
	
		//$laboratoryTestOrderId = array_search(strtolower($value), $getLaboratoryData);
	
		//$getLaboratoryDatas['Laboratory']['id'] = $laboratoryTestOrderId;
		$rate=$this->getRate($getLaboratoryData['Laboratory']['id']);
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
		$labData['LaboratoryTestOrder']['location_id'] = $locationid;
		$labData['LaboratoryTestOrder']['created_by']="1";
		$labData['LaboratoryTestOrder']['create_time']=date("Y-m-d H:i:s");
		$labData['LaboratoryTestOrder']['start_date']=date('Y-m-d H:i:s');
		$labData['LaboratoryTestOrder']['order_id']=$this->autoGeneratedLabID ($locationid);
			
		if(!empty($getLaboratoryTestOrderAllData['LaboratoryTestOrder']['id']))
			$labData['LaboratoryTestOrder']['id']=$getLaboratoryTestOrderAllData['LaboratoryTestOrder']['id'];
		else
			$labData['LaboratoryTestOrder']['id']="";
	
	
			
		if(!empty($getLaboratoryData['Laboratory']['id']))
			$LaboratoryTestOrder->saveAll($labData['LaboratoryTestOrder'],array('callbacks' =>false));
		/*$log = $this->LaboratoryTestOrder->getDataSource()->getLog(false, false);
		 debug($log);*/
			
		return true;
	
	
	
	
	}
	
	
	function saveRadEpen($radName,$patientId,$locationid)
	{
		
		App::uses('Radiology', 'Model');
		App::uses('RadiologyTestOrder', 'Model');
		$Radiology = new Radiology(null,null,$this->database);
		$RadiologyTestOrder = new RadiologyTestOrder(null,null,$this->database);
		
		
		/******BOF-Radiology Test Order save****///
		$getRadiologyData=$Radiology->find('first',array('fields'=>array('id','name'),'conditions'=>array('Radiology.name'=>$radName,'Radiology.is_deleted'=>0,'Radiology.location_id' => $locationid)));
		$getRadiologyTestOrderAllData=$RadiologyTestOrder->find('first',array('fields'=>array('id','radiology_id'),'conditions'=>array('RadiologyTestOrder.is_deleted'=>0,'RadiologyTestOrder.patient_id'=>$patientId,'RadiologyTestOrder.radiology_id'=>$getRadiologyData['Radiology']['id'])));
	
	
		$getRateRad=$this->getRateRad($radiologyTestOrderId,$locationid);
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
		$radData['RadiologyTestOrder']['location_id'] = $locationid;
		$radData['RadiologyTestOrder']['created_by']="1";
		$radData['RadiologyTestOrder']['create_time']=date("Y-m-d H:i:s");
		$radData['RadiologyTestOrder']['radiology_order_date']=date("Y-m-d H:i:s");
		$radData['RadiologyTestOrder']['order_id']= $this->autoGeneratedRadID($locationid);
	
	
		if(!empty($getRadiologyTestOrderAllData['RadiologyTestOrder']['id']))
			$radData['RadiologyTestOrder']['id']=$getRadiologyTestOrderAllData['RadiologyTestOrder']['id'];
		else
			$radData['RadiologyTestOrder']['id']="";
	
	
		if(!empty($getRadiologyData['Radiology']['id']))
			$RadiologyTestOrder->saveAll($radData['RadiologyTestOrder'],array('callbacks' =>false));
	
		return true;
	
	}
	
	function saveMedEpen($medName,$patientId,$locationid,$nodays,$Dosageod,$Dosagebd,$Dosagetds,$remarks)
	{
		
		App::uses('Patient', 'Model');
		App::uses('PharmacyItem', 'Model');
		App::uses('NewCropPrescription', 'Model');
		App::uses('PharmacyItemRate', 'Model');
		App::uses('InventoryPurchaseItemDetail', 'Model');
		$Patient = new Patient(null,null,$this->database);
		$PharmacyItem = new PharmacyItem(null,null,$this->database);
		$NewCropPrescription = new NewCropPrescription(null,null,$this->database);
		$PharmacyItemRate = new PharmacyItemRate(null,null,$this->database);
		$InventoryPurchaseItemDetail = new InventoryPurchaseItemDetail(null,null,$this->database);
		
		if($Dosageod=='YES')
			$DosageodValue=1;
		else
			$DosageodValue=0;
		
		if($Dosagebd=='YES')
			$DosagebdValue=2;
		else
			$DosagebdValue=0;
		
		if($Dosagetds=='YES')
			$DosagetdsValue=3;
		else
			$DosagetdsValue=0;
		
			
		$tabcnt=$DosageodValue+$DosagebdValue+$DosagetdsValue;
		$qty=$tabcnt*$nodays;
		
		
		//find id from pharmacy item table from the drug name
		if($locationid=='22'){//to reduce stock from pharma extention  --Mahalaxmi
			$conditions["PharmacyItem.location_id"] = '26';
		}else if($locationid=='1'){//to reduce stock from pharma extention  --Mahalaxmi
			$conditions["PharmacyItem.location_id"] = '25';
		}else{
			$conditions["PharmacyItem.location_id"] = $locationid;
		}
		//$conditions["PharmacyItem.stock >"]='0'; ///Commented By Mahalaxmi-this condition use after new db
		$conditions["PharmacyItem.name"]=$medName;
		$conditions["PharmacyItem.is_deleted"]="0";
		$getPharmacyItemData=$PharmacyItem->find('first',array('fields'=>array('id','name','drug_id'),'conditions'=>$conditions));
		$personId=$Patient->find('first',array('fields'=>array('person_id'),'conditions'=>array('id'=>$patientId),'callbacks' => false));
		
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
		$medData['location_id']=$locationid;
		$medData['DosageForm']=$selected_strength[strtoupper($dosageStrength[1])];
		$medData['dosageValue']=trim($dosageValue[0]);
		$medData['special_instruction']=$remarks;
			
		if(!empty($getNewCropPrescriptionAllData['NewCropPrescription']['id']))
			$medData['id']=$getNewCropPrescriptionAllData['NewCropPrescription']['id'];
		else
			$medData['id']="";
	
		//calculate quantity
			
	
		$medData['day']=$nodays;
		/*if(empty($freq))
			$freq=1;*/
	if(!empty($qty))
		$medData['quantity']=$qty;
	else
		$medData['quantity']="1";
	
	
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
			$NewCropPrescription->saveAll($medData,array('callbacks' =>false));
	
		return true;
	
	
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
	
	function getRate($id) {
		
		App::uses('Laboratory', 'Model');
		App::uses('TariffList', 'Model');
		App::uses('TariffAmount', 'Model');
		
		$Laboratory = new Laboratory(null,null,$this->database);
		$TariffList = new TariffList(null,null,$this->database);
		$TariffAmount = new TariffAmount(null,null,$this->database);
		
		
		$Laboratory->bindModel ( array (
				'belongsTo' => array (
						'TariffList' => array (
								'foreignKey' => false,
								'conditions' => 'Laboratory.tariff_list_id=TariffList.id'
						),
						'TariffAmount' => array (
								'foreignKey' => false,
								'conditions' => 'TariffAmount.tariff_list_id=TariffList.id'
						)
				)
		) );
	
		if ($hospitalType == 'NABH') {
			$getPrice = $Laboratory->find ( 'first', array (
					'fields' => array (
							'TariffAmount.nabh_charges'
					),
					'conditions' => array (
							'Laboratory.id' => $id,
							//'Laboratory.location_id' => $session->read ( 'locationid' )
					)
			) );
		} else {
			$getPrice = $Laboratory->find ( 'first', array (
					'fields' => array (
							'TariffAmount.non_nabh_charges'
					),
					'conditions' => array (
							'Laboratory.id' => $id,
							//	'Laboratory.location_id' => $session->read ( 'locationid' )
					)
			) );
	
		}
	
		return $getPrice;
	}
	
	function getRateRad($id,$locationid){
		
		App::uses('Radiology', 'Model');
		App::uses('TariffList', 'Model');
		App::uses('TariffAmount', 'Model');
		
		$Radiology = new Radiology(null,null,$this->database);
		$TariffList = new TariffList(null,null,$this->database);
		$TariffAmount = new TariffAmount(null,null,$this->database);
	
		$Radiology->bindModel(array(
				'belongsTo' => array(
						'TariffList'=>array('foreignKey'=>false,'conditions'=>'Radiology.tariff_list_id=TariffList.id'),
						'TariffAmount'=>array('foreignKey'=>false,'conditions'=>'TariffAmount.tariff_list_id=TariffList.id'),
				)));
		if($hospitalType=='NABH'){
			$getPrice1=$Radiology->find('first',array('fields'=>array('TariffAmount.nabh_charges'),
					'conditions'=>array('Radiology.id'=>$id,'Radiology.location_id'=>$locationid)));
		}else{
			$getPrice1=$Radiology->find('first',array('fields'=>array('TariffAmount.non_nabh_charges'),
					'conditions'=>array('Radiology.id'=>$id,'Radiology.location_id'=>$locationid)));
		}
	
		return $getPrice1;
	}
	
	public function autoGeneratedRadID($locationid){
		App::uses('RadiologyTestOrder', 'Model');
		App::uses('Location', 'Model');
		$RadiologyTestOrder = new RadiologyTestOrder(null,null,$this->database);
		$Location = new Location(null,null,$this->database);
		$count = $RadiologyTestOrder->find('count',array('conditions'=>array('RadiologyTestOrder.create_time like'=> "%".date("Y-m-d")."%")));
		$count=$count+1;
	
		if($count==0){
			$count = "001" ;
		}else if($count < 10 ){
			$count = "00$count"  ;
		}else if($count >= 10 && $count <100){
			$count = "0$count"  ;
		}
		$month_array = array('A','B','C','D','E','F','G','H','I','J','K','L');
		//find the Hospital name.
	
		$Location->unbindModel(
				array('belongsTo' => array('City','State','Country'))
		);
			
		#$hospital = $Location->read('Facility.name,Location.name',$session->read('locationid'));
	
		//creating patient ID
		$unique_id   = 'RAD';
		
		
				$unique_id  .= substr("G",0,1); //first letter of the hospital name
				$unique_id  .= substr($location,0,2).$locationid;//first 2 letter of d location  // location id appended be'coz of same locations first word--gaurav
				$unique_id  .= date('y'); //year
				$unique_id  .= $month_array[date('n')-1];//first letter of month
				$unique_id  .= date('d');//day
				$unique_id .= $count;
				return strtoupper($unique_id) ;
	
	
	}
	
	public function autoGeneratedLabID($locationid) {
		App::uses('LaboratoryTestOrder', 'Model');
		App::uses('Location', 'Model');
		$LaboratoryTestOrder = new LaboratoryTestOrder(null,null,$this->database);
		$Location = new Location(null,null,$this->database);
		$count = $LaboratoryTestOrder->find ( 'count', array (
				'conditions' => array (
						'LaboratoryTestOrder.create_time like' => "%" . date ( "Y-m-d" ) . "%"
				)
		) );
		$count = $count + 1;
	
		if ($count == 0) {
			$count = "001";
		} else if ($count < 10) {
			$count = "00$count";
		} else if ($count >= 10 && $count < 100) {
			$count = "0$count";
		}
		$month_array = array (
				'A',
				'B',
				'C',
				'D',
				'E',
				'F',
				'G',
				'H',
				'I',
				'J',
				'K',
				'L'
		);
		// find the Hospital name.
	
		$Location->unbindModel ( array (
				'belongsTo' => array (
						'City',
						'State',
						'Country'
				)
		) );
	
		// $hospital = $Location->read('Facility.name,Location.name',$session->read('locationid'));
	
		// creating patient ID
		$unique_id = 'LAB';
		
		$unique_id .= substr ( "G", 0, 1 ); // first letter of the hospital name
		$unique_id .= substr ( $location, 0, 2 ) . $locationid; // first 2 letter of d location // location id appended be'coz of same locations first word--gaurav
		$unique_id .= date ( 'y' ); // year
		$unique_id .= $month_array [date ( 'n' ) - 1]; // first letter of month
		$unique_id .= date ( 'd' ); // day
		$unique_id .= $count;
		return strtoupper ( $unique_id );
	}
	
	
}