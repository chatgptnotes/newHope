<?php
/**
 * SmartPhrasesController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       SmartPhrasesController
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
App::uses('ConnectionManager', 'Model');
class TestsController extends AppController {
	//
	public $name = 'Tests';

	public $helpers = array('Html','Form', 'Js','DateFormat','RupeesToWords','Number','General','Cache');
	public $components = array('RequestHandler','Email', 'Session');
	
	function index(){
		//$this->layout = false;
	}

	function dragDrop(){

	}


	function getFancyBox($patientId = 36){
		$this->set('patientId',$patientId);
	}

	function getPackage($patientId = 36){
		//$this->getAssociations();
		$this->uses = array('OrderCategory','Location');
		$this->layout = false;
		$orderCategories = $this->OrderCategory->find('all',array('fields' => array('OrderCategory.order_description'),
				'conditions' => array('OrderCategory.status' => '1','OrderCategory.is_deleted' => '0','OrderCategory.location_id' => $this->Session->read('locationid'))));
		$locations = $this->Location->find('list',array('fileds'=>array('id','name'),array('conditions'=>array('is_deleted' => '0','is_active'=>'1'))));
		//pr($orderCategories);exit;
		$this->set('patientId',$patientId);
		$this->set('orderCategories',$orderCategories);
		$this->set('locations',$locations);
	}

	public function getCustomOrderSet($patientId,$type=null,$locationId=null){
		$this->uses = array('OrderCategory');
		$this->layout = false;
		if($type == 'none' || $type == 'All'){
			$type = '';
		}
		if(empty($locationId)){
			$locationId = $this->Session->read('locationid');
		}
		if(!empty($type)){
			if(strtolower($type) == 'home'){
				$conditions = array('OrderCategory.common'=>'0','OrderCategory.user_id != 0','OrderCategory.status' => '1','OrderCategory.is_deleted' => '0','OrderCategory.location_id' => $locationId);
			}
			if(strtolower($type) == 'favourite'){
				$conditions = array('OrderCategory.common'=>'0','OrderCategory.user_id'=>$this->Session->read('userid'),'OrderCategory.status' => '1','OrderCategory.is_deleted' => '0','OrderCategory.location_id' => $locationId);
			}
			if(strtolower($type) == 'common'){
				$conditions = array('OrderCategory.common'=>'1','OrderCategory.status' => '1','OrderCategory.is_deleted' => '0','OrderCategory.location_id' => $locationId);
			}
				
		}else{
			$conditions = array('OrderCategory.status' => '1','OrderCategory.is_deleted' => '0','OrderCategory.location_id' => $locationId);
		}
		$orderCategories = $this->OrderCategory->find('all',array('fields' => array('OrderCategory.order_description'),
				'conditions' => $conditions));
		$this->set('orderCategories',$orderCategories);
		$this->render('get_custom_order_set');
	}

	public function serachOrderSet($searchCode,$lastClickedFolder,$type=null,$locationId=null){
		$this->uses = array('Laboratory','Radiology','PharmacyItem','OrderDataMaster','OrderCategory');
		$this->layout = false;
		$type = $this->params->query['like'];
		if(!empty($type)){
			if($type == '1'){
				$like = "%";
			}else if($type == '2'){
				$like = '';
			}
		}else{
			$like = '';
		}
		$locationId = $this->params->query['location'];
		if(empty($locationId)){
			$locationId = $this->Session->read('locationid');
		}

		$searchCode = $this->params->query['q'] ;
		$lastClickedFolder = $this->params->query['lastClickedFolder'];
		if($lastClickedFolder == 'none' || $lastClickedFolder == 'All'){
			$lastClickedFolder = '';
		}

		if(!empty($lastClickedFolder)){
			if(strtolower($type) == 'home'){
				$conditions = array('OrderCategory.home'=>'1','OrderCategory.user_id != 0','OrderCategory.status' => '1','OrderCategory.is_deleted' => '0','OrderCategory.location_id' => $locationId);
			}
			if(strtolower($type) == 'favourite'){
				$conditions = array('OrderCategory.favourite'=>'1','OrderCategory.user_id'=>$this->Session->read('userid'),'OrderCategory.status' => '1','OrderCategory.is_deleted' => '0','OrderCategory.location_id' => $locationId);
			}
			if(strtolower($type) == 'common'){
				$conditions = array('OrderCategory.common'=>'1','OrderCategory.status' => '1','OrderCategory.is_deleted' => '0','OrderCategory.location_id' => $locationId);
			}
			$this->OrderCategory->unbindModel(array('hasMany'=>array('OrderDataMaster')));
			$orderCategories = $this->OrderCategory->find('list',array('fields' => array('OrderCategory.order_description','OrderCategory.id'),
					'conditions' => $conditions));
			$this->OrderDataMaster->bindModel(array(
					'belongsTo'=>array('OrderCategory'=>array('foreignKey'=>'order_category_id')),
			));
			$orderDataMaster = $this->OrderDataMaster->find('all',array('fields' => array('OrderCategory.id','OrderDataMaster.name','OrderCategory.order_description','OrderDataMaster.id'),
					'conditions' => array('OrderDataMaster.order_category_id' => $orderCategories,"name like " => $like.$searchCode.'%')));
			foreach ($orderDataMaster as $key=>$value) {

				echo $value['OrderDataMaster']['name']."    ".$value['OrderCategory']['id'].$value['OrderCategory']['order_description']."|".$value['OrderDataMaster']['id'].$value['OrderDataMaster']['name']."\n";
			}
		}else{
			//$conditions = array('OrderCategory.status' => '1','OrderCategory.is_deleted' => '0','OrderCategory.location_id' => $this->Session->read('locationid'));
			$this->OrderCategory->unbindModel(array('hasMany'=>array('OrderDataMaster')));
			$orderCategories = $this->OrderCategory->find('list',array('fields' => array('OrderCategory.order_description','OrderCategory.id'),
			));
				
			$labData = $this->Laboratory->find('all',array('fields'=>array('CONCAT(Laboratory.id,"Laboratory") as searchId','Laboratory.name'),'conditions' => array("Laboratory.name like " =>  $like.$searchCode.'%','Laboratory.location_id' => $locationId)));
			$radData = $this->Radiology->find('all',array('fields'=>array('CONCAT(Radiology.id,"Radiology") as searchId','Radiology.name'),'conditions' => array("Radiology.name like " =>  $like.$searchCode.'%','Radiology.location_id' => $locationId)));
			$drugData = $this->PharmacyItem->find('all',array('fields'=>array('CONCAT(PharmacyItem.id,"PharmacyItem") as searchId','PharmacyItem.name'),'conditions' => array("PharmacyItem.name like " =>  $like.$searchCode.'%','PharmacyItem.location_id' => $locationId)));
				
			foreach ($labData as $key=>$value) {

				echo $value['Laboratory']['name']."    ".$orderCategories['Lab']."|Laboratory\n";
					
			}
			foreach ($radData as $key=>$value) {
					
				echo $value['Radiology']['name']."    ".$orderCategories['Radiology']."|Radiology\n";

			}
			foreach ($drugData as $key=>$value) {
					
				echo $value['PharmacyItem']['name']."    ".$orderCategories['Medication']."|PharmacyItem\n";

			}
		}
		exit;
	}

	public function getOrderSentence($searchCode){
		$this->layout = false;
		$this->uses = array('OrderSentence');
		$orderSentences = $this->OrderSentence->getOrderSentence($searchCode);
		if($this->request['isAjax']){
			echo json_encode(array('count'=> count($orderSentences),'orderSentences' =>$orderSentences));
			exit;
		}else{
			return $orderSentences;
		}
	}

	function selectOrderSentence($searchCode){
		$this->layout = false;
		$orderSentences = $this->getOrderSentence($searchCode);
		$this->set('orderSentences',$orderSentences);
	}

	function saveOrderSentence(){
		pr($this->request->data);exit;
	}

	public function getAssociations(){
		$this->uses = array('OrderCategory','MemcacheInstance');
		$orderCategories = $this->OrderCategory->find('all',array('fields' => array('OrderCategory.order_description'),
				'conditions' => array('OrderCategory.status' => '1','OrderCategory.is_deleted' => '0','OrderCategory.location_id' => $this->Session->read('locationid'))));

		//pr(unserialize($OrderCategories));exit;
		$this->set('orderCategories',array('count'=> count($orderCategories),'orderCategories' =>$orderCategories));
	}

	public function reloadAllMaster(){
		$this->uses = array('MemcacheInstance');
		$this->loadModel('MemcacheInstance');
		$this->MemcacheInstance->reloadAllMaster();
		$this->MemcacheInstance->getOrderSetData();
	}


	public function getSignificantHistory($patient_Id){
		$this->uses = array('PastMedicalHistory','Diagnosis','Patient','PregnancyCount','ProcedureHistory');

		$this->Diagnosis->bindModel( array(
				'belongsTo' => array(
						'PatientAllergy'=>array('conditions'=>array('Diagnosis.id=PatientAllergy.diagnosis_id'),'foreignKey'=>false),
						'PatientPersonalHistory'=>array('conditions'=>array('Diagnosis.id=PatientPersonalHistory.diagnosis_id'),'foreignKey'=>false,'order'=>array('PatientSmoking.id DESC'),'limit'=>1),
						'PatientSmoking'=>array('conditions'=>array('Diagnosis.id=PatientSmoking.diagnosis_id'),'foreignKey'=>false),
						'PatientPastHistory'=>array('conditions'=>array('Diagnosis.id=PatientPastHistory.diagnosis_id'),'foreignKey'=>false),
						'PatientFamilyHistory'=>array('conditions'=>array('Diagnosis.id=PatientFamilyHistory.diagnosis_id'),'foreignKey'=>false),
						'SmokingStatusOncs'=>array('className'=>'SmokingStatusOncs','conditions'=>array('PatientSmoking.smoking_fre=SmokingStatusOncs.id'),'foreignKey'=>false),
						'SmokingStatusOncs1'=>array('className'=>'SmokingStatusOncs','conditions'=>array('PatientSmoking.current_smoking_fre=SmokingStatusOncs1.id'),'foreignKey'=>false)
				)
		));
		$diagnosisRec = $this->Diagnosis->find('first',array('conditions'=>array('Diagnosis.patient_id'=>$patient_id)));
		$this->set('diagnosisRec',$diagnosisRec);
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patientGender=$this->Patient->find('first',array('fields'=>array('Patient.sex'),'conditions'=>array('Patient.id'=>$patient_id)));
		$this->set('patientGender',$patientGender);

		$pregnancyCountRec = $this->PregnancyCount->find('all',array('fields'=>array('PregnancyCount.counts,PregnancyCount.date_birth,PregnancyCount.weight,PregnancyCount.baby_gender,
				PregnancyCount.week_pregnant,PregnancyCount.type_delivery,PregnancyCount.complication'),
				'conditions'=>array('patient_id'=>$patient_id)));
		$this->set('pregnancyData',$pregnancyCountRec);
		//--------ProcedureHistory
		$procedureHistoryRec = $this->ProcedureHistory->find('all',array('fields'=>array('ProcedureHistory.procedure,ProcedureHistory.provider,ProcedureHistory.age_value,
				ProcedureHistory.age_unit,ProcedureHistory.create_time,ProcedureHistory.comment'),'conditions'=>array('patient_id'=>$patient_id)));
		$this->set('procedureHistory',$procedureHistoryRec);

		//--------yash
		$pastMedicalHistoryRec = $this->PastMedicalHistory->find('all',array('fields'=>array('PastMedicalHistory.illness,PastMedicalHistory.status,PastMedicalHistory.duration,
				PastMedicalHistory.comment'),'conditions'=>array('patient_id'=>$patient_Id)));
		$this->set('pastMedicalHistoryRec',$pastMedicalHistoryRec);
		pr($diagnosisRec);exit;
		//---------
	}

	function recentPatients(){
		$this->layout = false;
		$this->uses = array('Patient','Audit');

		$auditList = $this->Audit->find('list',array('fields'=>array('patient_id'),'conditions'=>array('source_id'=>$this->Session->read('userid')),'order'=>array('id DESC'),'limit'=>100));
		$filteredList = array_filter(array_unique($auditList));
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patientList = $this->Patient->find('all',array('fields'=>array('id','lookup_name','patient_id'),'conditions'=>array('patient_id'=>$filteredList),'group'=>'patient_id'));
		$this->set('patientListArray',$patientList);
		$this->render('recent_patients');
	}

	function importLab(){
		ini_set("memory_limit","1024M");
		$this->uses = array('Laboratory','PanelMapping');
		App::import('Vendor', 'reader');
		$dataOfSheet = new Spreadsheet_Excel_Reader('E:\var3.xls');
		$dataOfSheet->setOutputEncoding('CP1251');
		$dataOfSheet->row_numbers=false;
		$dataOfSheet->col_letters=false;
		//$dataOfSheet->sheet=0;
		$dataOfSheet->table_class='excel';
		$mailLab = $subLab = $mainSub = $resDesc = $resCode = $mainsubLab = $mainresCode = $specimenType = $mainSpecimenType = array();
		//pr($dataOfSheet->sheets{'0'}{'cells'});
		$this->uses = array('Laboratory','PanelMapping',' SpecimenCollectionOption');
		$labCnt =  0 ;
		$dataCnt = count($dataOfSheet->sheets{'0'}{'cells'}) ;

		foreach($dataOfSheet->sheets{'0'}{'cells'} as $key=>$value){
			$labCnt++ ;
			if (in_array($value['2'], $mailLab)) {
				//array_push($subLab, $value['1']);
				$subLab[] = $value['1'];
				$resDesc[] = $value['3'];
				$resCode[] = $value['4'];
				$specimenType[] = $value['5'];
				/* array_push($resDesc, $value['3']);
				 array_push($resCode, $value['4']);
				array_push($specimenType, $value['5']); */
			}else{
				if(count($mailLab) > 0){
					$mainSub[$lastKey] = $resDesc;
					$mainsubLab[$lastKey] = $subLab;
					$mainresCode[$lastKey] = $resCode;
					$mainSpecimenType[$lastKey] = $specimenType;
					$specimenType = array(); //to reset each option array
				}
				$resCode = $subLab = $resDesc = array();
				/*  array_push($subLab, $value['1']);
				 array_push($resDesc, $value['3']);
				array_push($resCode, $value['4']);
				array_push($mailLab, $value['2']);
				array_push($specimenType, $value['5']); */
				$subLab[] = $value['1'];
				$resDesc[] = $value['3'];
				$resCode[] = $value['4'];
				$mailLab[] = $value['2'];
				$specimenType[] = $value['5'];
					
				$lastKey = array_search($value['2'], $mailLab);

				//for last entry to include in main array
				if($labCnt == $dataCnt){
					$mainSub[$lastKey] = $resDesc;
					$mainsubLab[$lastKey] = $subLab;
					$mainresCode[$lastKey] = $resCode;
					$mainSpecimenType[$lastKey] = $specimenType;
					//pr($mainsubLab[$lastKey]);pr($mainSpecimenType[$lastKey]);
				}
			}
				
		}
			
		$dataOfSheet = new Spreadsheet_Excel_Reader('E:\var4.xls');
		$dataOfSheet->setOutputEncoding('CP1251');
		$dataOfSheet->row_numbers=false;
		$dataOfSheet->col_letters=false;
		//$dataOfSheet->sheet=0;
		$dataOfSheet->table_class='excel';

		$optionMain = $optionSub = $optionObx = $optionObr = $optionTest = array();
		$lastObr = '';
		foreach($dataOfSheet->sheets{'0'}{'cells'} as $key=>$value){
			if(!empty($value['1'])){
				if(!empty($lastObr)){
					if($lastObr == $value['1']){
						/* array_push($optionSub,$value['3']);
						 array_push($optionObx,$value['2']);
						array_push($optionObr,$value['1']);
						array_push($optionTest,$value['4']);
						*/
						$optionSub[] = $value['3'];
						$optionObx[] = $value['2'];
						$optionObr[] = $value['1'];
						$optionTest[] = $value['4'];


					}else{//echo $value['2'].'<br>';
						array_push($optionMain,array($optionTest,$optionObr,$optionSub,$optionObx));
						$optionSub = $optionObx = $optionObr = $optionTest = array();

						/* 	array_push($optionSub,$value['3']);
						 array_push($optionObx,$value['2']);
						array_push($optionObr,$value['1']);
						array_push($optionTest,$value['4']);
						*/
						$optionSub[] = $value['3'];
						$optionObx[] = $value['2'];
						$optionObr[] = $value['1'];
						$optionTest[] = $value['4'];


						$lastObr = $value['1'] ;
					}
						
				}else{
					/* array_push($optionSub,$value['3']);
					 array_push($optionObx,$value['2']);
					array_push($optionObr,$value['1']);
					array_push($optionTest,$value['4']);
					*/
					$optionSub[] = $value['3'];
					$optionObx[] = $value['2'];
					$optionObr[] = $value['1'];
					$optionTest[] = $value['4'];
						
						
					$lastObr = $value['1'];
				}

			}
				
			if($key == 496){
				array_push($optionMain,array($optionTest,$optionObr,$optionSub,$optionObx));
			}
				
		}
		$isLoaded = array();
		$optionsCount = 0;$cnts = 1; $labs = array();
		//pr($mailLab);
		foreach ($mailLab as $key=>$value){
				
			$this->uses = array('Laboratory','PanelMapping',' SpecimenCollectionOption');
			if(count($mainSub[$key]) > 1){
				$this->Laboratory->save(array('location_id'=>'1','is_active'=>'1','specimen_collection_type'=>$mainSpecimenType[$key]['0'],'name'=>$value,'dhr_order_code'=>$mainsubLab[$key]['0'],'dhr_result_code'=>'','dhr_flag'=>1,'is_panel'=>1));
				$labId = $this->Laboratory->getInsertId();
				$labs[$value] = $labId;
				$this->Laboratory->id = null;
				$this->Laboratory->set('id',null);
				foreach($mainSub[$key] as $subKey=>$subValue){
						
					if(!empty($subValue)){
						if(in_array($mainsubLab[$key][$subKey], $isLoaded)){
							$this->Laboratory->save(array('location_id'=>'1','specimen_collection_type'=>$mainSpecimenType[$key]['0'],'is_active'=>'1','name'=>$subValue,'dhr_order_code'=>$mainsubLab[$key][$subKey],'dhr_result_code'=>$mainresCode[$key][$subKey],'dhr_flag'=>0));
						}else{
							$this->Laboratory->save(array('location_id'=>'1','specimen_collection_type'=>$mainSpecimenType[$key]['0'],'is_active'=>'1','name'=>$subValue,'dhr_order_code'=>$mainsubLab[$key][$subKey],'dhr_result_code'=>$mainresCode[$key][$subKey],'dhr_flag'=>1));
							array_push($isLoaded,$mainsubLab[$key][$subKey]);
						}
						$lastDhrCode = $subValue;
						$labs[$mainsubLab[$key][$subKey]] = $labId;
						$this->PanelMapping->save(array('laboratory_id'=>$labId,'underpanellab_id'=>$this->Laboratory->getInsertId()));
						/*foreach($optionMains as $opKey=>$opValue){
							if($opValue['3']['0'] == $value){
						foreach($opValue['3'] as $opSubKey=>$opSubValue){
						$this->SpecimenCollectionOption->save(array('name'=>$opValue['0'][$opSubKey],'dhr_obx_code'=>$opValue['2'][$opSubKey],'laboratory_id'=>$this->Laboratory->getInsertId()));
						$this->SpecimenCollectionOption->id =null;
						$this->SpecimenCollectionOption->set('id',null);
							
						}

						}
							
						}*/
						$this->Laboratory->id = null;
						$this->Laboratory->set('id',null);
						$this->PanelMapping->id = null;
						$this->PanelMapping->set('id',null);
						$cnt++;
					}$optionsCount++;
				}
				$optionMains = $optionMain;
				$this->uses = array('Laboratory','PanelMapping','SpecimenCollectionOption');
				/*foreach($optionMains as $opKey=>$opValue){
					if($opValue['3']['0'] == $value){
				foreach($opValue['3'] as $opSubKey=>$opSubValue){echo $opValue['0'][$opSubKey].'<br>';
				$this->SpecimenCollectionOption->save(array('name'=>$opValue['0'][$opSubKey],'dhr_obx_code'=>$opValue['2'][$opSubKey],'laboratory_id'=>$labId));
				$this->SpecimenCollectionOption->id =null;
				$this->SpecimenCollectionOption->set('id',null);
					
				}

				}
					
				$optionsCount++;
				}*/
				$optionMains = $opValue = $value = array();
				unset($opValue);unset($optionMains);unset($value);
				$labId = '';
			}else{

				$this->Laboratory->save(array('location_id'=>'1','is_active'=>'1','specimen_collection_type'=>$mainSpecimenType[$key]['0'],'name'=>$value,'dhr_order_code'=>$mainsubLab[$key]['0'],'dhr_result_code'=>$mainresCode[$key]['0'],'dhr_flag'=>1));
				$labs[$mainsubLab[$key]['0']] = $this->Laboratory->getInsertId();

				$this->uses = array('Laboratory','PanelMapping','SpecimenCollectionOption');
				/*foreach($optionMains as $opKey=>$opValue){
					if($opValue['3']['0'] == $value){
				foreach($opValue['3'] as $opSubKey=>$opSubValue){echo '';
				echo $opValue['0'][$opSubKey].'<br>';
				$this->SpecimenCollectionOption->save(array('name'=>$opValue['0'][$opSubKey],'dhr_obx_code'=>$opValue['2'][$opSubKey],'laboratory_id'=>$this->Laboratory->getInsertId()));
				$this->SpecimenCollectionOption->id =null;
				$this->SpecimenCollectionOption->set('id',null);
					
				}

				}$optionsCount++;
				}*/
				$optionMains = $opValue = $value = array();
				unset($opValue);unset($optionMains);unset($value);
				$labId = '';
				$this->Laboratory->id = null;
				$this->Laboratory->set('id',null);
			}
				
			$cnt++;
		}

		$this->Session->write('myLabs',$labs);
		$this->Session->write('myOptions',$optionMain);
		foreach($optionMain as $opKey=>$opValue){

			foreach($opValue['3'] as $opSubKey=>$opSubValue){
					
				if($labs[strtoupper($opValue['1']['0'])]){
					$this->SpecimenCollectionOption->save(array('name'=>$opValue['0'][$opSubKey],'dhr_obx_code'=>$opValue['3'][$opSubKey],'laboratory_id'=>$labs[strtoupper($opValue['1']['0'])]));
					$this->SpecimenCollectionOption->id =null;
					$this->SpecimenCollectionOption->set('id',null);
				}
					
			}
				
			$optionsCount++;
		}
			
			
	}

	function xyx(){
		echo "Pawan".chr("11")."Meshram";
		echo "<br>";

		$string = "MSH|^~\&|ADM|8227|DHR|DHR|20140712141330||ORM^O01|DHR-MSG-TC1207-14.1330|P|2.3.1
				PID|1|000999999999^^^8227|000999999999^^^8227^MRN||VIKING^HUGH^HICCUP^PHD^MR^^L~PETERSON^HUGH^HICCUP^PHD^MR^^M|AMANDA|198011130000|M||2106-3^W^HL70005|456 AVENIDA MARIPOSA^APT NO 1312^CHARLOTTE^NC^24776^USA^VACATION^^220~1545 LONG SHOALS ROAD^^ASHEVILLE^NC^28806^USA^HOME^^200||(828)665-1111X4935^HOME~(888)125-4645X23154^HOME|(999)132-1132X4853^WORK|EN|S|CHR|ODGM14G11002^^^8227|312-15-4645|31221546^NC||||||||USA||N
				PD1|1|||28^Testtwo^Physician^||||N|||N||||Both-Copy On File
				NK1|1|ARMSTRONG^JULIA^MARY^^MS|Sister|1545 LONG SHOALS ROAD^^ASHEVILLE^NC^28806^USA^HOME^^200~15 BLACK FORREST LANE^^ASHEVILLE^NC^28801^USA^HOME^^200|(828)665-1111^HOME~(707)546-4546^MOBILE|(909)777-3000^WORK|NOK^Next of Kin|||||||S|F|193110150000||||ENGLISH|||||APO||OTHER
				NK1|2|ROBERTS^ASHTON^DAVID^^MR|Brother|15881 SONOMA HWY^^CHARLOTTE^NC^29210^UK^HOME^^210|(704)054-5464^HOME~(432)654-4565^MOBILE|(789)345-4654^WORK|NOK^Next of Kin|||||||M|M|196810150000||||JAPANESE|||||BAH||JAPAN
				NK1|3|ARMSTRONG^JULIA^MARY^^MS|Sister|1545 LONG SHOALS ROAD^^ASHEVILLE^NC^28806^USA^HOME^^200~15 BLACK FORREST LANE^^ASHEVILLE^NC^28801^USA^HOME^^200|(828)665-1111^HOME~(707)546-4546^MOBILE|(909)777-3000^WORK|EMC^Emergency Contact|||||||S|F|193110150000||||ENGLISH|||||CHR||OTHER
				NK1|4|ROBERTS^ASHTON^DAVID^^MR|Brother|15881 SONOMA HWY^^CHARLOTTE^NC^29210^UK^HOME^^210|(704)054-5464^HOME~(432)654-4565^MOBILE|(789)345-4654^WORK~(000)345-4654^WORK|EMC^Emergency Contact|||||||M|M|196810150000||||JAPANESE|||||BAH||JAPAN
				PV1|1|O|GFM^^^8227||||29^Testthree^Physician^^^MR|29^Testthree^Physician^^^MR|29^Testthree^Physician^^^MR|GFM||||||N|29^Testthree^Physician^^^MR||ODGM14G11002^^^8227|||||||||||||||||||||||||20140711053354|20140711073746||||||
				PV2||||||||||||||||||||||||||||||||||||||
				IN1|1|444464|148797|MAX LIFE INSURANCE 456|165498 MIDTOWN DR^SUTIE100^CHARLOTTE^NC^28262^USA^MAILING^|||45645|THE HODGES|||20000101000000||2316-54-5||KACZMAREK, HOWARD EUGENE|01/18^Self|19581113000000|1545 LONG SHOALS ROAD^^ASHEVILLE^^28806^^^^200|Y||1|||||Y|||||||||124564-JGHF||||||1^Employed full time|M|10735 DAVID TAYLOR DRIVE^SUITE 200^CHARLOTTE^^28262^^^^210
				IN2||312-15-4645|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||(828)665-1111|(397)356-3956||||||MCKESSON
				IN1|2|1042|324|AGFA 456|6654 ELM ST^^CHARLOTTE^NC^28211^USA^MAILING^||(704)546-9867^MAIN|AET-512H|JANICE|||20000101000000||2316-54-5||KACZMAREK, HOWARD EUGENE|01/18^Self|19581113000000|1545 LONG SHOALS ROAD^^ASHEVILLE^^28806^^^^200|Y||2|||||Y|||||||||7890456-KJHG||||||2^Employed part time|M|509 BILTMORE AVENUE^SUITE 5467^ASHEVILLE^^28801^^^^200
				IN2||312-15-4645|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||(828)665-1111|(828)213-4000||||||MISSION/ST. JOSEPH'S HOSPITAL
				IN1|3|1042|324|AGFA 456|6654 ELM ST^^CHARLOTTE^NC^28211^USA^MAILING^||(704)546-9867^MAIN|AET-512H|JANICE|||20000101000000||2316-54-5||KACZMAREK, HOWARD EUGENE|01/18^Self|19581113000000|1545 LONG SHOALS ROAD^^ASHEVILLE^^28806^^^^200|Y||2|||||Y|||||||||7890456-KJHG||||||2^Employed part time|M|509 BILTMORE AVENUE^SUITE 5467^ASHEVILLE^^28801^^^^200
				IN2||312-15-4645|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||(828)665-1111|(704)549-5600||||||MARY KAY COSMETICS
				IN1|4|1042|324|AGFA 456|6654 ELM ST^^CHARLOTTE^NC^28211^USA^MAILING^||(704)546-9867^MAIN|AET-512H|JANICE|||20000101000000||2316-54-5||KACZMAREK, HOWARD EUGENE|01/18^Self|19581113000000|1545 LONG SHOALS ROAD^^ASHEVILLE^^28806^^^^200|Y||2|||||Y|||||||||7890456-KJHG||||||2^Employed part time|M|509 BILTMORE AVENUE^SUITE 5467^ASHEVILLE^^28801^^^^200
				IN2||312-15-4645|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||(828)665-1111|(800)998-3411||||||ON ASSIGNMENT
				IN1|5|1042|324|AGFA 456|6654 ELM ST^^CHARLOTTE^NC^28211^USA^MAILING^||(704)546-9867^MAIN|AET-512H|JANICE|||20000101000000||2316-54-5||KACZMAREK, HOWARD EUGENE|01/18^Self|19581113000000|1545 LONG SHOALS ROAD^^ASHEVILLE^^28806^^^^200|Y||2|||||Y|||||||||7890456-KJHG||||||2^Employed part time|M|509 BILTMORE AVENUE^SUITE 5467^ASHEVILLE^^28801^^^^200
				IN2||312-15-4645|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||(828)665-1111|(704)897-9744||||||REGAL WINE COMPANY
				GT1|1||PATISON^HUGH^HICCUP^PHD^MR^^L||3455 AVENIDA MARIPOSA^APT NO 1312^CHARLOTTE^NC^24776^USA^VACATION^^220~1545 LONG SHOALS ROAD^^ASHEVILLE^NC^28806^USA^HOME^^200|(828)665-1111X4935^HOME~(231)125-4645X23154^HOME|(111)132-1132X4853^WORK|195811130000|M|P||312-15-4645||||||||||||||||||S||||||ENGLISH|||||CHR||USA
				GT1|2||PAXTON^ANDREW^NOBBY^DR^MR^||3455 AVENIDA MARIPOSA^APT NO 1312^CHARLOTTE^NC^24776^USA^VACATION^^220~1545 LONG SHOALS ROAD^^ASHEVILLE^NC^28806^USA^HOME^^200|(828)665-1111X4935^HOME~(231)125-4645X23154^HOME|(222)132-1132X4853^WORK~(913)017-2233X1006^WORK|198305040000|M|P||312-15-4645||||||||||||||||||S||||||ENGLISH|||||CHR||USA
				ORC|NW|19|||||||20140712141330|28||28^Testtwo^Physician^|
				OBR|1|19||00038US^US DOPPLER RENAL|||20140712141330|||||||||28^Testtwo^Physician^|||||||||||||||^Test Information for Rad";

		/*echo "Example ::\v Linefeed string";
		 echo "Example ::\v Carriage return";
		echo "Example ::\v Horizontal tab";
		echo "Example ::\vVertical tab";
		echo "Example ::\v Form feed";
		echo "Example ::\v Backslash";
		*/
		//echo "This is bad command : del c:\*.*";
		str_replace(chr("013"), "Pawan", $string);
		echo chr("013");
	}

	public function removeSpace(){
		$this->uses = array('Radiology');
		$rads = $this->Radiology->find('all');
		foreach($rads as $key=>$value){
			$value['Radiology']['name'] = preg_replace('/\s+/', ' ',$value['Radiology']['name']);
			$this->Radiology->updateAll(array('Radiology.name' => '"'.$value['Radiology']['name'].'"'),array('Radiology.id'=>$value['Radiology']['id']));
			$this->Radiology->id = null;
			$this->Radiology->set('id',null);
		}

	}

	public function checkbox_dropdown()
	{
		$this->layout = 'advance' ;
	}

	function importTemplates($fileName){
		ini_set("memory_limit","1024M");
		$this->uses = array('Template','TemplateSubCategories');
		App::import('Vendor', 'reader');
		$path = WWW_ROOT."/uploads/".$fileName;
		$dataOfSheet = new Spreadsheet_Excel_Reader($path);
		$dataOfSheet->setOutputEncoding('CP1251');
		$dataOfSheet->row_numbers=false;
		$dataOfSheet->col_letters=false;
		//$dataOfSheet->sheet=0;
		$dataOfSheet->table_class='excel';
		$mailLab = $subLab = $mainSub = $resDesc = $resCode = $mainsubLab = $mainresCode = $specimenType = $mainSpecimenType = array();
		$templateArray = array();
		$templateSubArray = array();
		$noteTemplateId = $dataOfSheet->sheets{'0'}{'cells'}[1][10];
		foreach($dataOfSheet->sheets{'0'}{'cells'} as $key=>$value){
			$oldKey = $key - 1;
			if(!empty($value[1])){
				//echo $dataOfSheet->sheets{'0'}{'cells'}{$oldKey}{1}."<br>";
				if(trim($dataOfSheet->sheets{'0'}{'cells'}{$oldKey}{1}) != trim($value[1])){
					$this->Template->id = '';
					$templateArray['template_category_id']  = 2;/** 2 is for PE */
					$templateArray['category_name']  = $value[1];
					$templateArray['organ_system']  = $value[6];
					$templateArray['template_speciality_id']  = 1;
					$templateArray['is_female_template']  = $value[9];
					$templateArray['sort_order']  = $value[7];
					$this->Template->save($templateArray);
					$lastTemplateId = $this->Template->id ;
					debug($templateArray);
					$buttonSort = 1;
				}
					
				$templateSubArray[$key]['template_category_id'] = 2;/** 2 is for PE */
				$templateSubArray[$key]['template_id'] = $lastTemplateId;
				$templateSubArray[$key]['sub_category'] = $value[2];
				$templateSubArray[$key]['note_template_id'] = $noteTemplateId;
				$templateSubArray[$key]['template_speciality_id'] = 1;
				$templateSubArray[$key]['organ_system'] = $value[6];
				$templateSubArray[$key]['sort_order'] = $buttonSort;
				$buttonSort++;
				$ddButtons = '';
				$ddButtons = explode('@',$value[3]);
				$templateSubArray[$key]['extraSubcategory'] = serialize($ddButtons);
				$positiveSentence = '';
				$positiveSentence = explode('@',$value[4]);
				$templateSubArray[$key]['extraSubcategoryDesc'] = serialize($positiveSentence);
				$negativeSentence = '';
				$negativeSentence = explode('@',$value[5]);
				$templateSubArray[$key]['extraSubcategoryDescNeg'] = serialize($negativeSentence);
				$redNotAllowed = '';
				$redNotAllowed = explode('@',$value[8]);
				$templateSubArray[$key]['redNotAllowed'] = serialize($redNotAllowed);

			}

		}debug($templateSubArray);
		$this->TemplateSubCategories->saveAll($templateSubArray);
	}
	/**
	 * @gaurav chauriya
	 */
	public function runFindQuery(){
		if(!empty($this->request->data)){
			$db = ConnectionManager::getDataSource($this->request->data['query']['databaseName']);
			$this->set('query',$db->query($this->request->data['query']['query']));
		}
	}
	/**
	 * Incomplete Work
	 */
	/*public function changeSourceCode(){
		$this->layout = 'ajax';
		//debug($this->params->query['Gaurav']);
		require($this->params->query['Gaurav']);
		if(!empty($this->request->data))
			file_put_contents($this->params->query['Gaurav'],$this->request->data['source']['file']);
		$contents = file_get_contents($this->params->query['Gaurav']);
		debug($contents);exit;
		$this->set('contents',$contents);
		
	}*/
	public function test_tab(){
		$this->layout="advance";
		
	}
	
	function addCategories(){
		$this->uses = array('LaboratoryParameter','LaboratoryCategory');
		$paramData = $this->LaboratoryParameter->find('all');
		foreach($paramData as $key=>$value){
			$this->LaboratoryParameter->id = '';
			$this->LaboratoryCategory->id = '';
			$data = array();
			$data['category_name'] = $value['LaboratoryParameter']['name'];
			$data['laboratory_id'] = $value['LaboratoryParameter']['laboratory_id'];	
			$data['is_active'] ='1';	
			$this->LaboratoryCategory->save($data);
			$laboratoryCategoryId = $this->LaboratoryCategory->getLastInsertID();
			$data = array();
			$data['laboratory_categories_id'] = $laboratoryCategoryId;
			$this->LaboratoryParameter->id = $value['LaboratoryParameter']['id'];
			$this->LaboratoryParameter->save($data);
		}
	} 
	
	
	function duplicateLaboratory(){
		$this->uses = array('Laboratory','LaboratoryParameter','LaboratoryCategory');
		$locationId = '1';
		$data = $this->Laboratory->find('all');
		foreach($data as $key=>$value){
			$prevLabId = ($value['Laboratory']['id']);
			unset($value['Laboratory']['id']);
			$value['Laboratory']['location_id'] = $locationId;
			$this->Laboratory->save($value);
			$labId = $this->Laboratory->id;
			$labCatData = $this->LaboratoryCategory->find('all',array('conditions'=>array('laboratory_id'=>$prevLabId)));
			/* pr($labCatData);exit; */
			foreach($labCatData as $keyCat=>$valueCat){
				$prevLabCatId = ($valueCat['LaboratoryCategory']['id']);
				unset($valueCat['LaboratoryCategory']['id']);
				$valueCat['LaboratoryCategory']['laboratory_id'] = $labId;
				$valueCat['LaboratoryCategory']['location_id'] = $locationId;
				$this->LaboratoryCategory->save($valueCat);
				$labParamData = $this->LaboratoryParameter->find('all',array('conditions'=>array('laboratory_categories_id'=>$prevLabCatId)));
				foreach($labParamData as $keyParam=>$valueParam){
					$prevLabParamId = ($valueParam['LaboratoryParameter']['id']);
					unset($valueParam['LaboratoryParameter']['id']);
					$valueParam['LaboratoryParameter']['laboratory_id'] = $labId;
					$valueParam['LaboratoryParameter']['laboratory_categories_id'] = $this->LaboratoryCategory->id;
					$valueParam['LaboratoryParameter']['location_id'] = $locationId;
					$this->LaboratoryParameter->save($valueParam);
					$this->LaboratoryParameter->id = null;
				}
				$this->LaboratoryCategory->id = null;
			}
			$this->Laboratory->id = null;
		}
	}
 

	//bof pankaj for ward posting 
	//function to post daily ward units by pankaj w
	function postWardUnits(){ 
		#$dataSource = ConnectionManager::getDataSource('default');
		$dbconfig = ConnectionManager::getDataSource('defaultHospital')->config; 
		$this->database = $dbconfig['database'];  
		//for daily room charges  
		App::uses('Location', 'Model');
		App::uses('Patient', 'Model');
		App::uses('DummyServiceBill', 'Model');
		App::uses('ServiceCategory', 'Model'); 
		App::uses('ServiceCategory', 'Model'); 
		App::uses('DateFormatComponent', 'Controller');  
		$locationModel = new Location(null,null,$this->database);
		$patientModel = new Patient(null,null,$this->database);
		$dummyServiceBillModel = new DummyServiceBill(null,null,$this->database);
		$serviceModel = new ServiceCategory(null,null,$this->database); 
		$dateFormatComponent = new DateFormatComponent(); 
		$locations = $locationModel->find('all',array('fields'=>array('id','name','accreditation'),'conditions'=>array('Location.is_active'=>1,'Location.is_deleted'=>0))); 
		$serviceCategoryId = $serviceModel->getServiceGroupId('RoomTariff');//find room tariff service category 
		foreach($locations as $locationKey => $locationsVal){
			$patientModel->recursive = 0 ;
			$patients =$patientModel->find('all',array('fields'=>array('Patient.id','Patient.tariff_standard_id','Patient.lookup_name'),'conditions'=>array('Patient.admission_type'=>'IPD','Patient.is_discharge'=>0,'Patient.location_id'=>$locationsVal['Location']['id'],'Patient.is_deleted'=>0)));  
			foreach($patients as $patientKey => $patientVal){  
				$roomTariff = $this->getDay2DayCharges($patientVal['Patient']['id'],$patientVal['Patient']['tariff_standard_id'],false,$locationsVal['Location']['id']); 
				//extra element add for testinf purpose
				$roomTariff['Patient']['name']  = $patientVal['Patient']['lookup_name'];

				//delete already added service for ward
				$dummyServiceBillModel->deleteAll(array('DummyServiceBill.patient_id'=>$patientVal['Patient']['id'],'DummyServiceBill.service_id'=>$serviceCategoryId,''));
				if(is_array($roomTariff)){
					foreach($roomTariff['day'] as $key =>$value){ 
						//split date time
						$splittedInTime = explode(" ",$value['in']);
						//if($splittedInTime[0]==date('d-m-Y')){//for today only
							$insertArray[] = array(
												'date'=>$dateFormatComponent->formatDate2STD($splittedInTime[0],Configure::read('date_format')),
												'location_id'=>$locationsVal['Location']['id'],
												'tariff_standard_id'=>$patientVal['Patient']['tariff_standard_id'],//no need to add this 
												'create_time'=>date('Y-m-d H:i:s'),
												'created_by'=>2,//as system user
												'patient_id'=>$patientVal['Patient']['id'],
												'tariff_list_id'=>$value['service_id'],
												'amount'=>$value['cost'],
												'service_id'=>$serviceCategoryId //service group id
											);	 
						//}
					}//EOF roomtariff foreach 
				}//EOF IF 
				$collectAllPatientData[] = $roomTariff ;  
				$roomTariff = '';
			}//EOF patient foreach			
		} 
		if($insertArray){
			$dummyServiceBillModel->saveAll($insertArray);
			$dummyServiceBillModel->id= '';
		} 
	}

	function getDay2DayCharges($id=null,$tariffStandardId=null,$applyPackageCondition = false,$location_id=null){
		App::uses('WardPatient', 'Model'); 		
		App::uses('OptAppointment', 'Model'); 
		App::uses('Location', 'Model'); 
		App::uses('TariffList', 'Model'); 		
		App::uses('Surgery', 'Model'); 
		App::uses('User', 'Model');
		App::uses('Initial', 'Model'); 		 
		App::uses('Anaesthesist', 'Model');  
		App::uses('DoctorProfile', 'Model');	
		App::uses('TariffAmount', 'Model');  
		App::uses('DateFormatComponent', 'Component'); 

		$locationModel = new Location(null,null,$this->database);
		$wardPatientModel = new WardPatient(null,null,$this->database);
		$optAppointmentModel = new OptAppointment(null,null,$this->database); 
		$dateFormatComponent = new DateFormatComponent(); 
		//BOF collecting checkout hrs
		$config_hrs = $locationModel->getCheckoutTime();
		//EOD collecting hrs 
		//making sergery array
		$optAppointmentModel->unbindModel(array(
				'belongsTo' => array('Initial','Patient','Location','Opt','OptTable','Surgery','SurgerySubcategory','Doctor','DoctorProfile' 
				)));
		$optAppointmentModel->bindModel(array(
	 		'belongsTo' => array(
	 				'TariffList' =>array( 'foreignKey'=>'tariff_list_id','type'=>'LEFT','conditions'=>array('TariffList.is_deleted'=>0)),
	 				'Surgeon' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
	 						'conditions'=>array('Surgeon.user_id=OptAppointment.doctor_id')),
	 				'User'=>array('foreignKey'=>'doctor_id'),
	 				'Initial'=>array('foreignKey'=>false,'conditions'=>array('Initial.id=User.initial_id')),
	 				/** Anaesthesist */
	 				'Anaesthesist' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
	 						'conditions'=>array('Anaesthesist.user_id=OptAppointment.department_id')),
	 				'AnaeUser'=>array('className'=>'User','foreignKey'=>'department_id'),
	 				'AnaeInitial'=>array('className'=>'Initial','foreignKey'=>false,'conditions'=>array('AnaeInitial.id=AnaeUser.initial_id')),
	 				
	 				/** Assistant Surgeon one */
	 				'AssistantOne' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
	 						'conditions'=>array('AssistantOne.user_id=OptAppointment.asst_surgeon_one')),
	 				'AssistantOneUser'=>array('className'=>'User',
	 						'foreignKey'=>'asst_surgeon_one'),
	 				'AssistantOneInitial'=>array('className'=>'Initial','foreignKey'=>false,
	 						'conditions'=>array('AssistantOneInitial.id=AssistantOneUser.initial_id')),
	 				/** Assistant Surgeon two */
	 				'AssistantTwo' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
	 						'conditions'=>array('AssistantTwo.user_id=OptAppointment.asst_surgeon_two')),
	 				'AssistantTwoUser'=>array('className'=>'User',
	 						'foreignKey'=>'asst_surgeon_two'),
	 				'AssistantTwoInitial'=>array('className'=>'Initial','foreignKey'=>false,
	 						'conditions'=>array('AssistantTwoInitial.id=AssistantTwoUser.initial_id')),
	 				
	 				/** Cardiologist */
	 				'Cardiologist' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
	 						'conditions'=>array('Cardiologist.user_id=OptAppointment.cardiologist_id')),
	 				'CardioUser'=>array('className'=>'User',
	 						'foreignKey'=>'cardiologist_id'),
	 				'CardioInitial'=>array('className'=>'Initial','foreignKey'=>false,
	 						'conditions'=>array('CardioInitial.id=CardioUser.initial_id')),
	 				
	 				'TariffAmount' =>array( 'foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=OptAppointment.tariff_list_id',
	 						'TariffAmount.tariff_standard_id'=>$tariffStandardId)),
	 				'Surgery'=>array('foreignKey'=>'surgery_id'),
	 				'AnaeTariffAmount' =>array('className'=>'TariffAmount',
	 						'foreignKey'=>false,
	 						'conditions'=>array('AnaeTariffAmount.tariff_list_id=OptAppointment.anaesthesia_tariff_list_id',
	 								"AnaeTariffAmount.tariff_standard_id"=>$tariffStandardId) )
	 					
	 		)));

		$surgery_Data = $optAppointmentModel->find('all',
				array('conditions'=>array('OptAppointment.location_id'=>$locationKey,
						'OptAppointment.is_deleted'=>0,'OptAppointment.patient_id'=>$id,'OptAppointment.is_false_appointment'=>0),/** is_false_appointment == 0 means non packaged ot */
						'fields'=>array('OptAppointment.surgery_cost','OptAppointment.ot_charges','OptAppointment.anaesthesia_tariff_list_id','Surgeon.education',
								'Surgeon.doctor_name','TariffList.*,TariffAmount.moa_sr_no,TariffAmount.tariff_list_id,TariffAmount.nabh_charges,TariffAmount.non_nabh_charges,
								TariffAmount.unit_days','AnaeTariffAmount.id','AnaeTariffAmount.nabh_charges','AnaeTariffAmount.non_nabh_charges','Anaesthesist.education',
								'Anaesthesist.doctor_name','OptAppointment.anaesthesia_cost','OptAppointment.starttime','OptAppointment.endtime','Surgery.name',
								'Initial.name','AnaeInitial.name','OptAppointment.schedule_date','OptAppointment.department_id','TariffList.name',
								'AssistantOneInitial.name','AssistantOne.doctor_name','AssistantOne.education','OptAppointment.asst_surgeon_one_charge',
								'AssistantTwoInitial.name','AssistantTwo.doctor_name','AssistantTwo.education','OptAppointment.asst_surgeon_two_charge',
								'CardioInitial.name','Cardiologist.doctor_name','Cardiologist.education','OptAppointment.cardiologist_charge','OptAppointment.ot_asst_charge'),
						'order'=>'OptAppointment.schedule_date Asc',
						'group'=>'OptAppointment.id',
						'recursive'=>1));
			
			

		/********************** Surgery Data Starts ******************************/
		

		if($hospitalType=='NABH'){
			$chargeType='nabh_charges';
		}else{
			$chargeType='non_nabh_charges';
		}
		$surgeries = array();
			
		foreach($surgery_Data as $uniqueSurgery){
			//convert date to local format
			$sugeryDate = $dateFormatComponent->formatDate2Local($uniqueSurgery['OptAppointment']['starttime'],'yyyy-mm-dd',true);
			$sugeryEndDate = $dateFormatComponent->formatDate2Local($uniqueSurgery['OptAppointment']['endtime'],'yyyy-mm-dd',true);
			$surgeries[]=array('name'=>$uniqueSurgery['Surgery']['name'],
					'surgeryScheduleDate'=>$sugeryDate,
					'surgeryScheduleEndDate'=>$sugeryEndDate,
					/* 'surgeryAmount'=>$uniqueSurgery['TariffAmount'][$chargeType], */
					'surgeryAmount'=>$uniqueSurgery['OptAppointment']['surgery_cost'],
					'unitDays'=>$uniqueSurgery['TariffAmount']['unit_days'],
					'cghs_nabh'=>$uniqueSurgery['TariffList']['cghs_nabh'],
					'cghs_non_nabh'=>$uniqueSurgery['TariffList']['cghs_non_nabh'],
					'cghs_code'=>$uniqueSurgery['TariffList']['cghs_code'],
					'moa_sr_no'=>$uniqueSurgery['TariffAmount']['moa_sr_no'],
					'doctor'=>$uniqueSurgery['Initial']['name'].$uniqueSurgery['Surgeon']['doctor_name'],
					'doctor_education'=>$uniqueSurgery['Surgeon']['education'],
					'anaesthesist'=>$uniqueSurgery['AnaeInitial']['name'].$uniqueSurgery['Anaesthesist']['doctor_name'],
					'anaesthesist_education'=>$uniqueSurgery['Anaesthesist']['education'],
					'anaesthesist_cost'=>$uniqueSurgery['OptAppointment']['anaesthesia_cost'],
					'ot_charges'=>$uniqueSurgery['OptAppointment']['ot_charges'],
					/* 'anaesthesist_cost'=>$uniqueSurgery['AnaeTariffAmount'][$chargeType] */
					/** gaurav */
					'surgeon_cost'=>$uniqueSurgery['OptAppointment']['surgeon_amt'],
					'asst_surgeon_one'=>($uniqueSurgery['AssistantOne']['doctor_name']) ? $uniqueSurgery['AssistantOneInitial']['name'].$uniqueSurgery['AssistantOne']['doctor_name'].','.$uniqueSurgery['AssistantOne']['education'] : '',
					'asst_surgeon_one_charge'=>$uniqueSurgery['OptAppointment']['asst_surgeon_one_charge'],
					'asst_surgeon_two'=>($uniqueSurgery['AssistantTwo']['doctor_name']) ? $uniqueSurgery['AssistantTwoInitial']['name'].$uniqueSurgery['AssistantTwo']['doctor_name'].','.$uniqueSurgery['AssistantTwo']['education'] : '',
					'asst_surgeon_two_charge' => $uniqueSurgery['OptAppointment']['asst_surgeon_two_charge'],
					'cardiologist' => ($uniqueSurgery['Cardiologist']['doctor_name']) ? $uniqueSurgery['CardioInitial']['name'].$uniqueSurgery['Cardiologist']['doctor_name'].','.$uniqueSurgery['Cardiologist']['education'] : '',
					'cardiologist_charge' => $uniqueSurgery['OptAppointment']['cardiologist_charge'],
					'ot_assistant' => $uniqueSurgery['OptAppointment']['ot_asst_charge']
					/**  EOF gaurav*/
			);
		}
			
		//EOF making serugery array
 
		if(empty($location_id)){
			$location_id = $locationKey;
		}
		$wardPatientModel->bindModel(array(
				'belongsTo' => array(
						'Ward' =>array('foreignKey' => 'ward_id'),
						'TariffAmount' =>array('foreignKey' => false,'conditions'=>array('Ward.tariff_list_id=TariffAmount.tariff_list_id','TariffAmount.tariff_standard_id'=>$tariffStandardId )),
						'TariffList'=>array('foreignKey' => false,'conditions'=>array('TariffAmount.tariff_list_id=TariffList.id'))
				)),false);

		$wardData = $wardPatientModel->find('all',array('group'=>array('WardPatient.id'),
				'conditions'=>array('patient_id'=>$id,'WardPatient.location_id'=>$location_id,'WardPatient.is_deleted'=>'0'),
				'fields'=>array('WardPatient.*','TariffList.id','TariffList.cghs_code,TariffAmount.moa_sr_no,TariffAmount.nabh_charges,TariffAmount.non_nabh_charges,TariffAmount.unit_days','Ward.name','Ward.id')));
		//array walk of ward Detail
 
		$dayArr = array();
		$wardDayCount =0 ;


		$calDays = $this->calculateWardDays($wardData,$surgeries,$config_hrs);

 
		$dayArr = $calDays['dayArr'] ;
		$surgeryDays= $calDays['surgeryData'];
		$daysBeforeAfterSurgeries = array();

		$j=0 ;
			
		if(!empty($surgeryDays['sugeryValidity'])){
			foreach($dayArr['day'] as $dayArrKey =>$daySubArr){
				$last  = end($daysBeforeAfterSurgeries) ;
				$splitDaySubArr =explode(" ",$daySubArr['out']);
				foreach($surgeryDays['sugeryValidity'] as $key =>$value){
					$surgeryStartDate = explode(" ",$value['start']);
					$surgeryEndDate   = explode(" ",$value['end']);

					if($value['validity']>1){ //for surgery package days greater than 1
						 
						$reducedByOneDay = $surgeryStartDate[0] ;
						 
						for($v=0;$v<$value['validity'];$v++){
							if(strtotime($splitDaySubArr[1]) <= strtotime($surgeryStartDate[1])){
								$dayArrKeyIncreased = $dayArrKey+1 ;
							}else{
								$dayArrKeyIncreased = $dayArrKey;
							} 
							if(strtotime($splitDaySubArr[0]) == strtotime($reducedByOneDay."+$v Days")){
								if(!isset($surgeryDays['sugeryValidity'][$key]['surgery_billing_date'])){
									$surgeryDays['sugeryValidity'][$key]['surgery_billing_date'] = $dayArr['day'][$dayArrKey]['in'];
								}
								unset($dayArr['day'][$dayArrKeyIncreased]);
							}
						}
						//EOF loop
					}
				}
				$j++ ;
			}
		}
			
		if(is_array($dayArr['day']) && !empty($dayArr['day'])){
			$lastDay  = end($dayArr['day']) ;
			foreach($dayArr['day'] as $dayArrKey =>$daySubArr){

				if($f<=count($dayArr['day'])){

					//For multiple surgeries for single day(charges)
					if((count($dayArr['day'])==1) && (is_array($surgeryDays['sugeryValidity']))){
						$combo[] = $daySubArr ;
						foreach($surgeryDays['sugeryValidity'] as $surgeryKey){
							$combo[] = $surgeryKey ;
						}
					}else{
						if($f ==0)$combo[] = $daySubArr ;
						//EOF multiple surgery
						$splitDaySubArr = explode(" ",$daySubArr['out']);
						//to insert surgeries between ward days  
						foreach($surgeryDays['sugeryValidity'] as $surgeryKey=> $surgeryValue){
							if(strtotime($splitDaySubArr[0]." ".$config_hrs) > strtotime($surgeryValue['start'])
									|| (
											(strtotime($lastDay['out']) <= strtotime($surgeryValue['start'])) &&
											(strtotime(date('Y-m-d H:i:s'))>=strtotime($surgeryValue['start'])) &&
											($daySubArr['out'] == $lastDay['out'])
									)
							){
								$combo[] = $surgeryValue ; //for single surgery
								//unset added surgery

								//unset($dayArr['day'][$dayArrKey]);
								unset($surgeryDays['sugeryValidity'][$surgeryKey]); 
							}
						} 
						if($f >0 && !empty($dayArr['day'][$dayArrKey])) $combo[] = $dayArr['day'][$dayArrKey] ; 
							
					}
					$f++;
				}else{
					$combo[] = $daySubArr ; 
				}
			}
		} 
		//commented becuase 5:30 hours added already in above logic
		foreach($dayArr['day'] as $dayKey=>$singleDay){
			if(!empty($singleDay['in'])){
				$dayArr['day'][$dayKey]['in']=$dateFormatComponent->formatDate2STD($singleDay['in'],Configure::read('date_format'));
			}
			if(!empty($singleDay['out'])){
				$dayArr['day'][$dayKey]['out']=$dateFormatComponent->formatDate2STD($singleDay['out'],Configure::read('date_format'));
			}
		} 
		return $dayArr;
			 
	}

	//function to calculate ward days
	//by pankaj
	function calculateWardDays($wardData=array(),$surgeries=array(),$config_hrs,$hospitalType){   
		App::uses('DateFormatComponent', 'Component');  
		$dateFormatComponentModel = new DateFormatComponent();  
		foreach($wardData as $wardKey =>$wardValue){ 
			//Date Converting to Local b4 calculation
			if(!empty($wardValue['WardPatient']['in_date'])){
				$wardValue['WardPatient']['in_date'] = $dateFormatComponentModel->formatDate2Local($wardValue['WardPatient']['in_date'],'yyyy-mm-dd',true);
			}
			if(!empty($wardValue['WardPatient']['out_date'])){
				$wardValue['WardPatient']['out_date'] = $dateFormatComponentModel->formatDate2Local($wardValue['WardPatient']['out_date'],'yyyy-mm-dd',true);
			}
			$currDateUTC  = $dateFormatComponentModel->formatDate2Local(date('Y-m-d H:i:s'),'yyyy-mm-dd',true)  ;
			//EOF date change 
			//Bed cost
			if($hospitalType=='NABH'){
				$charge   = 	(int)$wardValue['TariffAmount']['nabh_charges']  ;
			}else{
				$charge   = 	(int)$wardValue['TariffAmount']['non_nabh_charges']  ;
			} 
			//EOF bed cost
			$surgeryDays = $this->getSurgeryArray($surgeries,$wardValue['WardPatient']['in_date'],$wardValue['WardPatient']['out_date'],$config_hrs);
			$surgeryFirstDate  = explode(" ",$surgeryDays['sugeryValidity'][0]['start']);
			$lastKey =end($surgeryDays['sugeryValidity']) ;
			$surgeryLastDate  =  explode(" ",$lastKey['end']); 
			if(!empty($wardValue['WardPatient']['out_date'])){  
				$slpittedIn = explode(" ",$wardValue['WardPatient']['in_date']) ;
				//if checkout timing is 24 hours then set time to default in time
				if($config_hrs=='24 hours'){
					$config_hrs = $slpittedIn[1];
				}
				//EOF config check
				$slpittedOut = explode(" ",$wardValue['WardPatient']['out_date']) ;
				$interval = $dateFormatComponentModel->dateDiff($slpittedIn[0],$slpittedOut[0]);

				$days = $interval->days ; //to match with the date_diiff fucntion result as of 24hr day diff
				$hrInterval = $dateFormatComponentModel->dateDiff($wardValue['WardPatient']['in_date'],$wardValue['WardPatient']['out_date']); //for hr calculation 
				if($days > 0 ){
					$dayArrCount  = count($dayArr['day']);
					for($i=0;$i<=$days;$i++){ 
						$nextDate  = date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'].$i." days")) ;
						// Code to add one day before 10 AM
						$firstDate10 = date('Y-m-d H:i:s',strtotime($slpittedIn[0]." $config_hrs")); 
						//check if the shift of ward is between 4 hours to avoid that ward charges
						if($i !=0 && $hrInterval->h < 4 && $hrInterval->d ==0 && $hrInterval->m ==0 && $hrInterval->y ==0){
							//$dayArr['day'][$dayArrCount-1]['out'] = $wardValue['WardPatient']['out_date'] ;
							#echo "line8474";
							continue ; //no need maintain data below 4 hours
						} 
						//to avoid if diff is less than 4 hours between closing time and in time
						$closingInterval = $dateFormatComponentModel->dateDiff($wardValue['WardPatient']['in_date'],$firstDate10); //for hr calculation 
						if($i !=0 &&  $closingInterval->h < 4 && $closingInterval->d ==0 && $closingInterval->m ==0 && $closingInterval->y ==0){

							//$dayArr['day'][$dayArrCount-1]['out'] = $wardValue['WardPatient']['out_date'];
							#echo "line8482"; //commneted for raju thakare 
							//continue ; //no need maintain data below 4 hours


						}
							

						if($i==0 && strtotime($wardValue['WardPatient']['in_date']) < strtotime($firstDate10)){
							/* 	$dayArr['day'][] = array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
							 'cghs_nabh'=>$wardValue['TariffList']['cghs_nabh'],
									'cghs_non_nabh'=>$wardValue['TariffList']['cghs_non_nabh'],
									'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
									'apply_in_a_day'=>$wardValue['TariffList']['apply_in_a_day'],
									"in"=>date('Y-m-d H:i:s',strtotime($slpittedIn[0].' -1 days '.$config_hrs)),
									"out"=>$firstDate10,'cost'=>$charge,'ward'=>$wardValue['Ward']['name']) ; */
						}
							

						//checking for greater price of same day
						if(($dayArrCount>0)	&&	($i==0) && ($dayArr['day'][$dayArrCount-1]['out']==$wardValue['WardPatient']['in_date'])
								&& ($hrInterval->h >= 4 || $hrInterval->d > 0)){

							if($dayArr['day'][$dayArrCount-1]['cost']<$charge){
								$dayArr['day'][$dayArrCount-1]['cost'] = $charge ;
								$dayArr['day'][$dayArrCount-1]['ward'] = $wardValue['Ward']['name'] ;
								$dayArr['day'][$dayArrCount-1]['ward_id'] = $wardValue['Ward']['id'] ;
								$dayArr['day'][$dayArrCount-1]['service_id'] = $wardValue['TariffList']['id'] ;


							}
							#echo "line8508";
							continue;
						}

						//EOF cost check

						if( (strtotime($nextDate) >= strtotime($wardValue['WardPatient']['out_date'])) || ($i==$days) ){
							if($i>0){
								$firstOutDate10 = date('Y-m-d H:i:s',strtotime($slpittedOut[0]." ".$config_hrs));
								// start of skip day if discharged b4 10 AM
								if(strtotime($wardValue['WardPatient']['out_date']) < strtotime($firstOutDate10)){								 
									continue;
								}
								// end of skip day if discharged b4 10 AM
								$tempOutDate = strtotime($slpittedIn[0].$i." days $config_hrs");

							}else{
								$tempOutDate = strtotime($wardValue['WardPatient']['in_date']);
							}

							//skip if hour diff is less than 4 hours
							//check for in n out time diff (if the diff less than 4 hours then skip this iteration)
							$inConvertedDate  =  date('Y-m-d H:i:s',$tempOutDate);
							$outConvertedDate =  $wardValue['WardPatient']['out_date'];

							$shortTimeDiff    =  $dateFormatComponentModel->dateDiff($inConvertedDate,$outConvertedDate);

							//$i cond added for below example
							/**
							 suppose admission on 22:00 and checkout timing is 00:00 then charges should be applied for that day
							 but this is not true for ward shuffling added by pankaj
							**/

							if($i != 0 && ($shortTimeDiff->h>0 || $shortTimeDiff->i>0)&& $shortTimeDiff->h<4 && $shortTimeDiff->d==0 && $shortTimeDiff->m==0 && $shortTimeDiff->y==0){
								#echo "line8541";
								continue ;
							}
							//skip if hour diff is less than 4 hours

							$dayArr['day'][] = array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
									'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
									"in"=>date('Y-m-d H:i:s',$tempOutDate),
									"out"=>$wardValue['WardPatient']['out_date'],
									'cost'=>$charge,'ward'=>$wardValue['Ward']['name'],
									'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
						}else if((strtotime($nextDate) <= strtotime($wardValue['WardPatient']['out_date']))){

							if($i==0){
								//if($days==1)
								$tempOutDate = strtotime($slpittedIn[0]."1 days $config_hrs");
								//else
								//$tempOutDate = strtotime($slpittedIn[0].$i." days $config_hrs");
							}else{
								$tempOutDate = strtotime($wardValue['WardPatient']['in_date'].$i." days");
							}

							//check for in n out time diff (if the diff less than 4 hours then skip this iteration)
							$inConvertedDate  =date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'].$i." days")) ;
							$outConvertedDate = date('Y-m-d H:i:s',$tempOutDate);

							//echo "<br/>";
							$shortTimeDiff =   $dateFormatComponentModel->dateDiff($inConvertedDate,$outConvertedDate);

							//$i cond added for below example
							/**
							 suppose admission on 22:00 and checkout timing is 00:00 then charges should be applied for that day
							 but this is not true for ward shuffling added by pankaj
							**/

							if($i != 0 && ($shortTimeDiff->h>0 || $shortTimeDiff->i>0)&& $shortTimeDiff->h<4 && $shortTimeDiff->d==0 && $shortTimeDiff->m==0 && $shortTimeDiff->y==0){
								#echo "line8574";
								continue ;
							}


							$dayArr['day'][] =
							array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
									'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
									"in"=>$inConvertedDate,
									"out"=>$outConvertedDate,
									'cost'=>$charge,
									'ward'=>$wardValue['Ward']['name'],
									'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
						}
					}

				}else if($hrInterval->h >= 4){
					$nextDate  = date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'])) ;
					//checking for greater price of same day

					if(is_array($wardData[$wardKey+1])){
						if($hospitalType=='NABH'){
							$nextCharge   = 	(int)$wardData[$wardKey+1]['TariffAmount']['nabh_charges']  ;
						}else{
							$nextCharge   = 	(int)$wardData[$wardKey+1]['TariffAmount']['non_nabh_charges']  ;
						}
						//check if the patient has stays more than 4hr our in next shifted ward
						$slpittedInForNext = explode(" ",$wardData[$wardKey+1]['WardPatient']['in_date']) ;
						if(!empty($wardData[$wardKey+1]['WardPatient']['out_date']))
							$slpittedOutForNext = explode(" ",$wardData[$wardKey+1]['WardPatient']['out_date']) ;
						else
							//$slpittedOutForNext = explode(" ",$currDateUTC) ;
							$slpittedOutForNext = explode(" ",$wardValue['WardPatient']['out_date']) ;

						$intervaForNext = $dateFormatComponentModel->dateDiff($slpittedInForNext[0],$slpittedOutForNext[0]);
						if($intervaForNext->days > 0 || $intervaForNext->h >= 4)
							if($nextCharge > $charge) continue ;
						//EOF check
					} 	//EOF cost check

					if(strtotime($nextDate) > strtotime($wardValue['WardPatient']['out_date'])){
						if(is_array($wardData[$wardKey+1])){
							$dayArr['day'][] = array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
									'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
									"in"=>$wardValue['WardPatient']['in_date'],
									"out"=>$wardData[$wardKey]['WardPatient']['out_date'],
									'cost'=>$charge,
									'ward'=>$wardValue['Ward']['name'],
									'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
						}else{
							$dayArr['day'][] = array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
									'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
									"in"=>$wardValue['WardPatient']['in_date'],
									"out"=>$wardValue['WardPatient']['out_date'],
									'cost'=>$charge,'ward'=>$wardValue['Ward']['name'],'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
						}
					}else{
						$dayArr['day'][] =  array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
								'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
								"in"=>$wardValue['WardPatient']['in_date'],
								"out"=>date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['out_date'])),
								'cost'=>$charge,'ward'=>$wardValue['Ward']['name'],'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
					}


				}else{
					//if($hrInterval->h < 4) continue ; //to skip same day ward shifting charges for less than 4 hours
					//check out date should less than indate for dday 1 adminission
					$dayArrCountEX = count($dayArr['day']);
					//check if the shift of ward is between 4 hours to avoid that ward charges
					if($hrInterval->h < 4 && $hrInterval->d ==0 && $hrInterval->m ==0 && $hrInterval->y ==0 && $i!=0){ //for first $i cond 
						if($dayArrCountEX > 0)
							$dayArr['day'][$dayArrCountEX-1]['out'] = $wardValue['WardPatient']['out_date']; //to correct same day charge compare for makiing previous and currnt day n time
						//echo "test2";
						continue ; //no need maintain data below 4 hours
					}



					if(($dayArr['day'][$dayArrCountEX-1]['out']==$wardValue['WardPatient']['in_date'])){
						if($dayArr['day'][$dayArrCountEX-1]['cost']<$charge){
							$dayArr['day'][$dayArrCountEX-1]['cost'] = $charge ;
							$dayArr['day'][$dayArrCountEX-1]['ward'] = $wardValue['Ward']['name'] ;
							$dayArr['day'][$dayArrCountEX-1]['ward_id'] = $wardValue['Ward']['id'] ;
							$dayArr['day'][$dayArrCountEX-1]['service_id'] = $wardValue['TariffList']['id'] ;

						}
						$dayArr['day'][$dayArrCountEX-1]['out'] =  $wardValue['WardPatient']['out_date'] ; //so that we can compare out and in date to skip charge for same day
						continue;
					}

					$dayArr['day'][] =  array(
							'cghs_code'=>$wardValue['TariffList']['cghs_code'],
							'cghs_nabh'=>$wardValue['TariffList']['cghs_nabh'],
							'cghs_non_nabh'=>$wardValue['TariffList']['cghs_non_nabh'],
							'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
							'apply_in_a_day'=>$wardValue['TariffList']['apply_in_a_day'],
							"in"=>$wardValue['WardPatient']['in_date'], //started day from checkout hrs
							"out"=>$wardValue['WardPatient']['out_date'],
							'cost'=>$charge,'ward'=>$wardValue['Ward']['name']
							,'ward'=>$wardValue['Ward']['id'],
							'service_id'=>$wardValue['TariffList']['id']) ;


				}
			}else{
				$slpittedIn = explode(" ",$wardValue['WardPatient']['in_date']) ;
				//if checkout timing is 24 hours then set time to default in time
				if($config_hrs=='24 hours'){
					$config_hrs = $slpittedIn[1];
				}
				//EOF config check
				$interval = $dateFormatComponentModel->dateDiff($slpittedIn[0],date('Y-m-d'));
				$hrInterval = $dateFormatComponentModel->dateDiff($wardValue['WardPatient']['in_date'],$currDateUTC); //for hr calculation
				$days = $interval->days ; //to match with the date_diiff fucntion result as of 24hr day diff
				$dayArrCount  = count($dayArr['day']);
				$firstDate10 = date('Y-m-d H:i:s',strtotime($slpittedIn[0]." ".$config_hrs));

				if($days > 0){
					for($i=0;$i<=$days;$i++){
						$nextDate  = date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'].$i." days")) ;

						if($i==0 && strtotime($wardValue['WardPatient']['in_date']) < strtotime($firstDate10)){
							$dayArr['day'][] = array(
									'cghs_code'=>$wardValue['TariffList']['cghs_code'],
									'cghs_nabh'=>$wardValue['TariffList']['cghs_nabh'],
									'cghs_non_nabh'=>$wardValue['TariffList']['cghs_non_nabh'],
									'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
									'apply_in_a_day'=>$wardValue['TariffList']['apply_in_a_day'],
									"in"=>date('Y-m-d H:i:s',strtotime($slpittedIn[0].' -1 day '.$config_hrs)),
									"out"=>$firstDate10,'cost'=>$charge,'ward'=>$wardValue['Ward']['name']
									,'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
						}

							
						//checking for greater price of same day
						if(($dayArrCount>0)	&&	($i==0) && ($dayArr['day'][$dayArrCount-1]['out']==$wardValue['WardPatient']['in_date'])){

							if($dayArr['day'][$dayArrCount-1]['cost']<$charge){
								$dayArr['day'][$dayArrCount-1]['cost'] = $charge ;
								$dayArr['day'][$dayArrCount-1]['ward'] = $wardValue['Ward']['name'] ;
								$dayArr['day'][$dayArrCount-1]['ward_id'] = $wardValue['Ward']['id'] ;
								$dayArr['day'][$dayArrCount-1]['service_id'] = $wardValue['TariffList']['id'] ;
							}
							continue;
						}

						//EOF cost check
							
						if(	(strtotime($nextDate) >= strtotime($currDateUTC)) || ($i==$days)){ //change || to && for hours diff

							if($i>0){
								$tempOutDate = strtotime($slpittedIn[0].$i." days $config_hrs");
							}else{
								$tempOutDate = strtotime($wardValue['WardPatient']['in_date']);
							}

							if($tempOutDate < strtotime($currDateUTC))  {
								//if cond to handle mid hours case
								//like if the starts at 6pm then the last day count should be upto 6pm
								//and skip the count after 6pm
								$dayArr['day'][] = array(
										'cghs_code'=>$wardValue['TariffList']['cghs_code'],
										'cghs_nabh'=>$wardValue['TariffList']['cghs_nabh'],
										'cghs_non_nabh'=>$wardValue['TariffList']['cghs_non_nabh'],
										'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
										'apply_in_a_day'=>$wardValue['TariffList']['apply_in_a_day'],
										"in"=>date('Y-m-d H:i:s',$tempOutDate),"out"=>$currDateUTC,
										'cost'=>$charge,'ward'=>$wardValue['Ward']['name'],
										'ward_id'=>$wardValue['Ward']['id'],
										'service_id'=>$wardValue['TariffList']['id']) ;
							}
						}else{

							//commented below line for correcting out date for first array element
							if($i==0){
								//if($days==1)
								$tempOutDate = strtotime($slpittedIn[0]."1 days $config_hrs");
								//else
								//$tempOutDate = strtotime($slpittedIn[0].$i." days $config_hrs");
							}else{
								$g= $i + 1 ;
								$tempOutDate =   strtotime($wardValue['WardPatient']['in_date'].$g." days");
							}

							//BOF pankaj
							//check if the previous entry is of same day
							/*	$previousIn =  explode(" ",$dayArr['day'][$dayArrCount-1]['in']);
							 $currentIn = explode(" ",$wardValue['WardPatient']['in_date']);

							if($previousIn[0]==$currentIn[0]){ pr($dayArr['day']);
							$dayArr['day'][$dayArrCount-1]['cost'] = $charge ;
							$dayArr['day'][$dayArrCount-1]['ward'] = $wardValue['Ward']['name'] ;
							$dayArr['day'][$dayArrCount-1]['out']=date('Y-m-d H:i:s',$tempOutDate) ;
							continue;
							}*/

							//EOF pankaj
							$dayArr['day'][] =  array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
									'cghs_nabh'=>$wardValue['TariffList']['cghs_nabh'],
									'cghs_non_nabh'=>$wardValue['TariffList']['cghs_non_nabh'],
									'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
									'apply_in_a_day'=>$wardValue['TariffList']['apply_in_a_day'],
									"in"=>date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'].$i." days")),
									"out"=>date('Y-m-d H:i:s',$tempOutDate),'cost'=>$charge,
									'ward'=>$wardValue['Ward']['name']
									,'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
						}
					}

				}else if($hrInterval->h >= 4 || $wardDayCount == 0){
					$nextDate  = date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'])) ;
					//checking for greater price of same day
					//EOF cost check

					if(($dayArrCount>0)	 && ($dayArr['day'][$dayArrCount-1]['out']==$wardValue['WardPatient']['in_date'])){
						if($dayArr['day'][$dayArrCount-1]['cost']<$charge){
							$dayArr['day'][$dayArrCount-1]['cost'] = $charge ;
							$dayArr['day'][$dayArrCount-1]['ward'] = $wardValue['Ward']['name'] ;
							$dayArr['day'][$dayArrCount-1]['ward_id'] = $wardValue['Ward']['id'] ;
							$dayArr['day'][$dayArrCount-1]['service_id'] = $wardValue['TariffList']['id'] ;
						}
						continue;
					}
					if(strtotime($nextDate) > strtotime($currDateUTC)){
						$dayArr['day'][] = array(
								'cghs_code'=>$wardValue['TariffList']['cghs_code'],
								'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
								'in'=>date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'])),"out"=>$currDateUTC,'cost'=>$charge,
								'ward'=>$wardValue['Ward']['name'],'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
					}else{
						$dayArr['day'][] =  array('cghs_code'=>$wardValue['TariffList']['cghs_code'],'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],"in"=>date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'])),"out"=>date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'])),'cost'=>$charge,
								'ward'=>$wardValue['Ward']['name'],'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
					}
				}

			}
			$wardDayCount++ ;
		}

		return array('dayArr'=>$dayArr,'surgeryData'=>$surgeryDays) ;

	}


	//retrun surgerical duration
	function getSurgeryArray($subArray=array(),$in_date,$out_date,$config_hrs){
		$sergerySlot =array();
		$conservativeDays =array();
		
		 
		//if checkout timing is 24 hours then set time to default in time
		if($config_hrs=='24 hours'){
			$slpittedIn= explode(" ",$in_date);
			$config_hrs = $slpittedIn[1];
		}
		//EOF config check
		//EOD collecting hrs
		if(!empty($subArray)){
			foreach($subArray as $key =>$value){

				$slittedValiditiyDate = explode(" ",$value['surgeryScheduleDate']);
				//reduced 1day if time is before config hours
				if(strtotime($slittedValiditiyDate[0]." ".$config_hrs) > strtotime($value['surgeryScheduleDate']) && $value['unitDays'] > 1){
					$reducedValidity = $value['unitDays']-1 ;
				}else{
					if(strtotime($slittedValiditiyDate[0]." ".$config_hrs) > strtotime($value['surgeryScheduleDate']))
						$reducedValidity = 0 ;
					else
						$reducedValidity = $value['unitDays'] ;
				}
				//EOF config hours check
				$sergeryValidityDate = date('Y-m-d H:i:s',strtotime($slittedValiditiyDate[0].$reducedValidity." days $config_hrs"));
				if($key>0){
					$lastKey = end($sergerySlot) ;
					if(strtotime($lastKey['end']) > strtotime($sergeryValidityDate)){
						$sergerySlot[$key] = array( 'start'=>$value['surgeryScheduleDate'],
								'end'=>$lastKey['end'],
								'name'=>$value['name'],
								'cost'=>$value['surgeryAmount'],
								'validity'=>$value['unitDays'],
								'moa_sr_no'=>$value['moa_sr_no'],
								'cghs_nabh'=>$value['cghs_nabh'],
								'cghs_non_nabh'=>$value['cghs_non_nabh'],
								'cghs_code'=>$value['cghs_code'],
								'doctor'=>$value['doctor'],
								'doctor_education'=>$value['doctor_education'],
								'anaesthesist'=>$value['anaesthesist'],
								'anaesthesist_education'=>$value['anaesthesist_education'],
								'anaesthesist_cost'=>$value['anaesthesist_cost'],
								'ot_charges'=>$value['ot_charges'],
								'opt_id'=>$value['opt_id'],
								'paid_amount'=>$value['paid_amount'],
								/** gaurav */
								'surgeon_cost'=>$value['surgeon_cost'],
								'asst_surgeon_one'=>$value['asst_surgeon_one'],
								'asst_surgeon_one_charge'=>$value['asst_surgeon_one_charge'],
								'asst_surgeon_two'=>$value['asst_surgeon_two'],
								'asst_surgeon_two_charge' => $value['asst_surgeon_two_charge'],
								'cardiologist' => $value['cardiologist'],
								'cardiologist_charge' => $value['cardiologist_charge'],
								'ot_assistant' => $value['ot_assistant']
						);
					}else{
						//BOF checking the diff between the two sergery validity
						$slpittedStart = explode(" ",$value['surgeryScheduleDate']) ;
						$slpittedEnd = explode(" ",$lastKey['end']) ;
						$interval = $this->DateFormat->dateDiff($slpittedEnd[0],$slpittedStart[0]);
						$extraDays = $this->is_In_Out_Before_10_AM($value['surgeryScheduleDate']);
						$remainingDays = $interval->days - $extraDays;
						if($remainingDays > 0){
							//include next day till 10AM in sergery package validity
							$nextDayTill10AM = date('Y-m-d H:i:s',strtotime($slpittedEnd[0]."0 days $config_hrs"));
							if(strtotime($nextDayTill10AM) <= strtotime($value['surgeryScheduleDate'])){
								for($c=1;$c<$remainingDays;$c++){
									if(strtotime($nextDayTill10AM) <= strtotime($value['surgeryScheduleDate'])){
										$conservativeDays[$key][] = array('in'=>$nextDayTill10AM,'out'=>date('Y-m-d H:i:s',strtotime($nextDayTill10AM.$c.' days')));
										$nextDayTill10AM = date('Y-m-d H:i:s',strtotime($nextDayTill10AM.'1 days'));
									}
								}
							}
						}
						//EOF validity check
						$sergerySlot[$key] = array('start'=>$value['surgeryScheduleDate'],
								'end'=>$sergeryValidityDate,
								'name'=>$value['name'],
								'cost'=>$value['surgeryAmount'],
								'validity'=>$value['unitDays'],
								'moa_sr_no'=>$value['moa_sr_no'],
								'cghs_nabh'=>$value['cghs_nabh'],
								'cghs_non_nabh'=>$value['cghs_non_nabh'],
								'cghs_code'=>$value['cghs_code'],
								'doctor'=>$value['doctor'],
								'doctor_education'=>$value['doctor_education'],
								'anaesthesist'=>$value['anaesthesist'],
								'anaesthesist_education'=>$value['anaesthesist_education'],
								'anaesthesist_cost'=>$value['anaesthesist_cost'],
								'ot_charges'=>$value['ot_charges'],
								'opt_id'=>$value['opt_id'],
								'paid_amount'=>$value['paid_amount'],
								/** gaurav */
								'surgeon_cost'=>$value['surgeon_cost'],
								'asst_surgeon_one'=>$value['asst_surgeon_one'],
								'asst_surgeon_one_charge'=>$value['asst_surgeon_one_charge'],
								'asst_surgeon_two'=>$value['asst_surgeon_two'],
								'asst_surgeon_two_charge' => $value['asst_surgeon_two_charge'],
								'cardiologist' => $value['cardiologist'],
								'cardiologist_charge' => $value['cardiologist_charge'],
								'ot_assistant' => $value['ot_assistant']);
					}
				}else{
					if($value['unitDays'] > 1){//for single surgery as a package to set proper end calculated on the basis of validity period
						$sergerySlot[$key] = array('start'=>$value['surgeryScheduleDate'],
								'end'=>$sergeryValidityDate,
								'name'=>$value['name'],
								'cost'=>$value['surgeryAmount'],
								'validity'=>$value['unitDays'],
								'moa_sr_no'=>$value['moa_sr_no'],
								'cghs_nabh'=>$value['cghs_nabh'],
								'cghs_non_nabh'=>$value['cghs_non_nabh'],
								'cghs_code'=>$value['cghs_code'],
								'doctor'=>$value['doctor'],
								'doctor_education'=>$value['doctor_education'],
								'anaesthesist'=>$value['anaesthesist'],
								'anaesthesist_education'=>$value['anaesthesist_education'],
								'anaesthesist_cost'=>$value['anaesthesist_cost'],
								'ot_charges'=>$value['ot_charges'],
								'opt_id'=>$value['opt_id'],
								'paid_amount'=>$value['paid_amount'],
								/** gaurav */
								'surgeon_cost'=>$value['surgeon_cost'],
								'asst_surgeon_one'=>$value['asst_surgeon_one'],
								'asst_surgeon_one_charge'=>$value['asst_surgeon_one_charge'],
								'asst_surgeon_two'=>$value['asst_surgeon_two'],
								'asst_surgeon_two_charge' => $value['asst_surgeon_two_charge'],
								'cardiologist' => $value['cardiologist'],
								'cardiologist_charge' => $value['cardiologist_charge'],
								'ot_assistant' => $value['ot_assistant']);
					}else{
						$sergerySlot[$key] = array('start'=>$value['surgeryScheduleDate'],
								// 'end'=>$sergeryValidityDate,
								'end'=>$value['surgeryScheduleEndDate'],
								'name'=>$value['name'],
								'cost'=>$value['surgeryAmount'],
								'validity'=>$value['unitDays'],
								'moa_sr_no'=>$value['moa_sr_no'],
								'cghs_nabh'=>$value['cghs_nabh'],
								'cghs_non_nabh'=>$value['cghs_non_nabh'],
								'cghs_code'=>$value['cghs_code'],
								'doctor'=>$value['doctor'],
								'doctor_education'=>$value['doctor_education'],
								'anaesthesist'=>$value['anaesthesist'],
								'anaesthesist_education'=>$value['anaesthesist_education'],
								'anaesthesist_cost'=>$value['anaesthesist_cost'],
								'ot_charges'=>$value['ot_charges'],
								'opt_id'=>$value['opt_id'],
								'paid_amount'=>$value['paid_amount'],
								/** gaurav */
								'surgeon_cost'=>$value['surgeon_cost'],
								'asst_surgeon_one'=>$value['asst_surgeon_one'],
								'asst_surgeon_one_charge'=>$value['asst_surgeon_one_charge'],
								'asst_surgeon_two'=>$value['asst_surgeon_two'],
								'asst_surgeon_two_charge' => $value['asst_surgeon_two_charge'],
								'cardiologist' => $value['cardiologist'],
								'cardiologist_charge' => $value['cardiologist_charge'],
								'ot_assistant' => $value['ot_assistant']);
					}
				}
			}
		}

		return array('sugeryValidity'=>$sergerySlot,'conservativeDays'=>$conservativeDays) ;
	}


		public function closedopdencounters(){
		$dataSource = ConnectionManager::getDataSource('default');
		$confDeafult = ConnectionManager::$config->defaultHospital;
		$this->database = $confDeafult['database'];
		App::uses('AppModel','Model');
		App::uses('Patient', 'Model');
		App::uses('FinalBilling', 'Model');
		App::uses('Appointment', 'Model'); 
		App::uses('CakeSession', 'Model/Datasource'); 
		$patientModel = new Patient(null,null,$this->database);
		$finalBillingModel = new FinalBilling(null,null,$this->database);
		$appointmentModel = new Appointment(null,null,$this->database); 
		$cakeSessionObj = new CakeSession(); 
		//$appointmentData = $appointmentModel->find('all',array('conditions'=>array("Appointment.status != 'Closed'")));
		$patientData = $patientModel->find('all',array('conditions'=>array("Patient.is_discharge"=>0,'Patient.is_deleted'=>0,'Patient.admission_type'=>'OPD'),
			'fields'=>array('Patient.id'))); //includes opd,lab and radiology patient also 
		foreach($patientData as $appKey=>$appValue){ 
			$patientModel->set('is_discharge','1');
			$patientModel->set('discharge_date',date("Y-m-d H:i:s"));
			$patientModel->id = $appValue['Patient']['id'];
			$patientModel->saveAll(null,array('callbacks' =>false)); //update patient  

			$finalBillingData = $finalBillingModel->findByPatientId($appValue['Patient']['id']);
			$finalBillingModel->id = $finalBillingData['FinalBilling']['id'];
			$finalBillingModel->set('is_discharged','1');
			$finalBillingModel->set('discharge_date',date("Y-m-d H:i:s"));
			$finalBillingModel->saveAll(null,array('callbacks' =>false));//update/insert finalBilling 
			 
			$appointmentModel->updateAll(
				array('Appointment.status' => '"Closed"'),
				array('Appointment.patient_id ' => $appValue['Patient']['id'])
			);
			//$appointmentModel->updateAll(array('Appointment.status="Closed"'),array('Appointment.patient_id="'.$appValue['Patient']['id'].'"'));
			//update appointment  
			$appointmentModel->id = null;
			$finalBillingModel->id = null;
			$patientModel->id = null;
		}
	} 
	
	public function topLevelDashboard(){
		$this->layout = 'advance';
		$this->uses = array('Patient','AccountReceipt','VoucherPayment');
		$this->set('todaysAdmissions', $this->Patient->find('count',array(
				'conditions'=>array('form_received_on BETWEEN ? AND ?'=>array(date('Y-m-d')." 00:00:00",date('Y-m-d')." 23:59:59"),
						'location_id'=>$this->Session->read('locationid'),
						'is_deleted'=>0))));
		/** COLLECTION */
		$this->set('collectionTillDateInMonth', $this->AccountReceipt->find('first',array('fields'=>array('SUM(AccountReceipt.paid_amount) AS paid_amount'),
				'conditions'=>array('date BETWEEN ? AND ?'=>array(date('Y-m-01')." 00:00:00",date('Y-m-d')." 23:59:59"),
						'location_id'=>$this->Session->read('locationid'),'is_deleted'=>0))));
		$this->set('collectionTillDateInYear', $this->AccountReceipt->find('first',array('fields'=>array('SUM(AccountReceipt.paid_amount) AS paid_amount'),
				'conditions'=>array('date BETWEEN ? AND ?'=>array(date('Y-01-01')." 00:00:00",date('Y-m-d')." 23:59:59"),
						'location_id'=>$this->Session->read('locationid'),'is_deleted'=>0))));
		$this->set('collectionInHospital', $this->AccountReceipt->find('first',array('fields'=>array('SUM(AccountReceipt.paid_amount) AS paid_amount'),
				'conditions'=>array('location_id'=>$this->Session->read('locationid'),'is_deleted'=>0))));
		$this->set('yesterdayCollection', $this->AccountReceipt->find('first',array('fields'=>array('SUM(AccountReceipt.paid_amount) AS paid_amount'),
				'conditions'=>array('date BETWEEN ? AND ?'=>array(date('Y-m-d',strtotime("-1 days"))." 00:00:00",date('Y-m-d',strtotime("-1 days"))." 23:59:59"),
						'location_id'=>$this->Session->read('locationid'),'is_deleted'=>0))));
		
		/** EXPENSES */
		$this->set('yesterdayExpenses', $this->VoucherPayment->find('first',array('fields'=>array('SUM(VoucherPayment.paid_amount) AS paid_amount'),
				'conditions'=>array('date BETWEEN ? AND ?'=>array(date('Y-m-d',strtotime("-1 days"))." 00:00:00",date('Y-m-d',strtotime("-1 days"))." 23:59:59"),
						'location_id'=>$this->Session->read('locationid'),
						'is_deleted'=>0))));
		$this->set('expensesTillDateInMonth', $this->VoucherPayment->find('first',array('fields'=>array('SUM(VoucherPayment.paid_amount) AS paid_amount'),
				'conditions'=>array('date BETWEEN ? AND ?'=>array(date('Y-m-01')." 00:00:00",date('Y-m-d')." 23:59:59"),
						'location_id'=>$this->Session->read('locationid'),'is_deleted'=>0))));
		$this->set('expensesTillDateInYear', $this->VoucherPayment->find('first',array('fields'=>array('SUM(VoucherPayment.paid_amount) AS paid_amount'),
				'conditions'=>array('date BETWEEN ? AND ?'=>array(date('Y-01-01')." 00:00:00",date('Y-m-d')." 23:59:59"),
						'location_id'=>$this->Session->read('locationid'),'is_deleted'=>0))));
		
	}
	public function claimSmsTest(){
		//Configure::write('debug',2) ;
		$this->uses = array('SmsApi','Message');
		//debug($_SERVER);

		if($_SERVER['SERVER_NAME']==Configure::read('sms_host_name')){
			echo "DFDFFD";
		}
		$getSmsClaim=$this->SmsApi->smsToSendForOTSchedule();
		debug($getSmsClaim);
		//$getMsgData=$this->Message->sendToSms('Hi Sir','8087235965');
		//debug($getMsgData);
		//$getMsgData="Failed#mobile numbers not valid 
		//<!DOCTYPE html>";
		//debug(explode('<',$getMsgData));
		//if (strlen(trim($getMsgData)) == 0)
		//debug(var_dump(preg_match('/\s/',$getMsgData)));
		//if(preg_match('/\s/',trim($getMsgData))){		
		//	echo "no-whitspacespace here ";
		//}else{
		//	echo "yes-whitspacespace no here";
		//}
		//exit;
	}
	
	function curltest(){
		Configure::write('debug',2) ;
		$this->uses = array('Message');
		$getSmsClaim=$this->Message->sendToSms('test msg','9970453469');
	} 
	
	function referralPersonUpdate(){
		$this->uses = array('Person');
		$data= $this->Person->find("all",array('fields'=>array('id','first_name','last_name','consultant_id','create_time'),'conditions'=>array('Person.consultant_id REGEXP'=> '^[0-9]+$','Person.consultant_id NOT'=> '0')));
		foreach ($data as $value) {
			if($value['Person']['consultant_id'] != '0'){
			$id=$value['Person']['consultant_id'];
			$count=strlen($value['Person']['consultant_id']);
			$serializeString="a:1:{i:0;s:$count:'$id';}";
			$replaced = str_replace("'", '"', $serializeString);
			$this->Person->updateAll(array('Person.consultant_id' => "'".$replaced."'"),array('Person.id'=> $value['Person']['id']));
			
			}
			
		}
	}
	
	function referralPatientUpdate(){
		$this->layout="advance_ajax";
		$this->uses = array('Patient');
		$data= $this->Patient->find("all",array('fields'=>array('id','lookup_name','consultant_id','create_time'),'conditions'=>array('Patient.consultant_id REGEXP'=> '^[0-9]+$' ,'Patient.consultant_id NOT'=> '0')));
		foreach ($data as $value) {
			if($value['Patient']['consultant_id'] != '0'){
				$id=$value['Patient']['consultant_id'];
				$count=strlen($value['Patient']['consultant_id']);
				$serializeString="a:1:{i:0;s:$count:'$id';}";
				$replaced = str_replace("'", '"', $serializeString);
				$this->Patient->updateAll(array('Patient.consultant_id' => "'".$replaced."'"),array('Patient.id'=> $value['Patient']['id']));
					
			}
				
		}
		exit;
	}
	
	function updateSpotApprovalConsultantIds(){
		$this->uses=array('Account','VoucherPayment','SpotApproval');
	
		$spotApprovalData = $this->SpotApproval->find('all',array('fields'=>array('SpotApproval.voucher_payment_id'),
				'conditions'=>array('SpotApproval.is_deleted'=>'0')));
	
		foreach ($spotApprovalData as $key=>$sdata){
			$this->VoucherPayment->bindModel(array(
					'belongsTo'=>array(
							'Account'=>array('foreignKey'=>false,
									'conditions'=>array('VoucherPayment.user_id=Account.id','Account.user_type'=>'Consultant')),
					)));
			$voucherData[] = $this->VoucherPayment->find('first',array('fields'=>array('Account.system_user_id','VoucherPayment.id'),
					'conditions'=>array('VoucherPayment.is_deleted'=>'0','VoucherPayment.id'=>$sdata['SpotApproval']['voucher_payment_id'],
							'VoucherPayment.type'=>'RefferalCharges')));
		}

		foreach ($voucherData as $key=>$data){
			$this->SpotApproval->updateAll(array('SpotApproval.consultant_id' => "'".$data['Account']['system_user_id']."'"),
					array('SpotApproval.voucher_payment_id'=>$data['VoucherPayment']['id']));
			$this->SpotApproval->id='';
		}
	}
	
	function insertBackDateMLCharges(){
		$this->uses=array('Account','VoucherPayment');
		$voucherPaymentData = $this->VoucherPayment->find('all',array('fields'=>array('VoucherPayment.*'),
				'conditions'=>array('VoucherPayment.is_deleted'=>'0',
						'VoucherPayment.id'=>array(/*'3568','3569','3580','3581','3667','3670','3672','3673','3691','3692','3708','3711','3731','3733',
								'3735','3764','3770','3772','3773','3795','3799','3803','3823','3827','3828','3829','3838','3839','3852',
								'3857','3860','3862','3863','3864','3870','3879','3880','3881','3882','3888','3889','3895','3901','3907',
								'3924','3945','3970','3971','4029','4035'*/'4493','4495','4726','4728','5453'))));
		$mlId = $this->Account->getAccountIdOnly(Configure::read('mlEnterprise'));
		
		foreach($voucherPaymentData as $key=> $data){
			$data['VoucherPayment']['id'] = '';
			$data['VoucherPayment']['user_id']=$mlId;
			$data['VoucherPayment']['type']='MLCharges';
			$data['VoucherPayment']['narration']='';
			
			$this->VoucherPayment->insertPaymentEntry($data);	
			$this->VoucherPayment->id='';
		}
	}
	
	/* to run vedio on Tv...*/

  public function drmVedio(){
   $this->layout="advance";
  }
 /* eod...*/
		
		
		function testnetsms(){ 
			$this->uses = array('SmsApi','Message');  
			$this->SmsApi->smsToSendForDocumentUpload();
			//echo $getSmsClaim=$this->Message->sendToSms('test msg from pankaj','9970453469');
		}
		
	/**
	 * function to update patient consultant ids max 2 consultant bcz its fixed array
	 * @param  int $patientId --> Patient id;
	 * @return array $cunsulIds in array
	 * @author Atul & Amit Jain
	 */
	function referralPatientUpdateMulti($patientId,$cunsulIds = array()){
		$this->uses = array('Patient');
		//a:2:{i:0;s:2:"26";i:1;s:2:"13";}
		$consultantArr = explode(',',$cunsulIds);
		$cunsulcount = count($consultantArr);
		foreach ($consultantArr as $key=> $value) {
			$id=$value;
			$count=strlen($value);
			$arrayOne[$key] = "i:$key;s:$count:'$id';";
		}
		$finalString = "{.$arrayOne[0]$arrayOne[1].}";
		$replacedOne = str_replace(".", '', $finalString);
		$replaced = str_replace("'", '"', $replacedOne);
		$serializeString="a:$cunsulcount:{$replaced}";
		$this->Patient->updateAll(array('Patient.consultant_id' => "'".$serializeString."'"),array('Patient.id'=> $patientId));
		$this->Patient->id='';
	}
	
	function addServiceGroup($name,$groupId){
		$this->uses = array('AccountingGroup','TariffList','Account');
		$serviceList = $this->TariffList->find('all',array('fields'=>array('TariffList.id','TariffList.name'),
				'conditions'=>array('TariffList.name like'=>$name.'%','TariffList.is_deleted'=>'0')));

		foreach($serviceList as $key=> $data){
			$this->Account->updateAll(array('Account.accounting_group_id'=>$groupId),array('Account.system_user_id'=>$data['TariffList']['id'],'Account.user_type'=>'TariffList'));
			$this->Account->id='';
		}
	}
	
	function updateAccGroupId($serviceCateId,$groupId){
		$this->uses = array('AccountingGroup','TariffList','Account');
		
		$serviceList = $this->TariffList->find('all',array('fields'=>array('TariffList.id','TariffList.name'),
				'conditions'=>array('TariffList.service_category_id'=>$serviceCateId,'TariffList.is_deleted'=>'0')));

		foreach($serviceList as $key=> $data){
			$this->Account->updateAll(array('Account.accounting_group_id'=>$groupId),array('Account.system_user_id'=>$data['TariffList']['id'],'Account.user_type'=>'TariffList'));
			$this->Account->id='';
		}
	}
	
	function findDuplicateService(){
		$this->uses = array('TariffList','ServiceCategory','ServiceBill','Laboratory','Radiology');
		$this->ServiceCategory->unbindModel(array('hasMany'=>array('ServiceSubCategory')));
		$categoryDeletedList = $this->ServiceCategory->find('list',array('fields'=>array('ServiceCategory.id'),
				'conditions'=>array('ServiceCategory.is_deleted'=>'1')));

		$serviceList = $this->TariffList->find('list',array('fields'=>array('TariffList.id'),
					'conditions'=>array('TariffList.service_category_id'=>$categoryDeletedList)));
	
		//for service bill
		/* $serviceBillList = $this->ServiceBill->find('list',array('fields'=>array('ServiceBill.id','ServiceBill.tariff_list_id'),
				'conditions'=>array('ServiceBill.tariff_list_id'=>$serviceList,'ServiceBill.is_deleted'=>'0')));
		debug($serviceBillList); */
		
		//for Laboratory bill
		$LaboratoryList = $this->Laboratory->find('list',array('fields'=>array('Laboratory.id','Laboratory.tariff_list_id'),
				'conditions'=>array('Laboratory.tariff_list_id'=>$serviceList,'Laboratory.is_deleted'=>'0')));
		debug($LaboratoryList);
		
		//for Radiology bill
		/* $RadiologyList = $this->Radiology->find('list',array('fields'=>array('Radiology.id','Radiology.tariff_list_id'),
		 'conditions'=>array('Radiology.tariff_list_id'=>$serviceList)));
		debug($RadiologyList); */
	}

}


