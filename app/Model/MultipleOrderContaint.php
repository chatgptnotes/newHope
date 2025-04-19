<?php

/* MultipleOrderContaint model
 *
* PHP 5
*
* @copyright     Copyright 2011 KloudData Inc.  (http://www.drmhope.com/)
* @link          http://www.drmhope.com/
* @package       Languages.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Pankaj Mankar
*/ 
class MultipleOrderContaint extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'MultipleOrderContaint';


	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	//save order data in multipe order table

	function insertOrder($data=array(),$isMultiple=null){
		$session = new cakeSession();
		$data['isMultiple']=$isMultiple;
		if(!empty($data['patient_order_id'])){
			//find that order is to be edited or not
			$isExistOrder=$this->find('first',array('fields'=>array('id'),'conditions'=>array('order_data_master_id'=>$data["order_data_master_id"],'patient_id'=>$data["patient_id"],'order_category_id'=>$data["order_category_id"])));

			if(empty($isExistOrder)){
				$this->save($data);
				return 'save';
			}
			else{
				$data['id']=$isExistOrder['MultipleOrderContaint']['id'];
				$this->save($data);
				return 'update';

			}

		}


		return true;

	}
	function saveOtherData($id=null,$data=array(),$personId,$lastInsertPatientOrderEncounterId){
		
		$PatientOrder= ClassRegistry::init('PatientOrder');
		$NewCropPrescription= ClassRegistry::init('NewCropPrescription');
		$LaboratoryTestOrder= ClassRegistry::init('LaboratoryTestOrder');
		$RadiologyTestOrder= ClassRegistry::init('RadiologyTestOrder');
		$pharmacyItem= ClassRegistry::init('PharmacyItem');
		$Laboratory= ClassRegistry::init('Laboratory');
		$Radiology= ClassRegistry::init('Radiology');
		
		$session = new cakeSession();
		$batchIdentifier=time();
		/* foreach($data as $subData){ // to save data in multiple order contain table
			$expData=explode('|',$subData);
		if(($expData[1]!=33) && ($expData[1]!=34) && ($expData[1]!=36) ){
		$this->saveAll(array('patient_id'=>$id,'order_data_master_id'=>$expData[0],'name'=>$expData[2],
				'sentence'=>$expData[4],'order_category_id'=>$expData[1]));
		$this->id=null;
		}
		} */
		//$PatientOrder->deleteAll(array('patient_id'=>$id,'note_id'=>$_SESSION['noteId'],'isMultiple'=>'Yes')); //commented by ml
		
		foreach($data as $subData){ // to save data in patient order contain table
			$expData=explode('|',$subData);
			if($expData['1']=='33'){
				$type='med';
			}
			elseif($expData['1']=='34'){
				$type='lab';
			}
			elseif($expData['1']=='36'){
				$type='rad';
			}
			elseif($expData['1']=='27'){
				$type='cond';
			}
			elseif($expData['1']=='28'){
				$type='vits';			
			}
			elseif($expData['1']=='29'){
				$type='act';			
			}
			elseif($expData['1']=='30'){
				$type='diet';					
			}
			elseif($expData['1']=='31'){
				$type='ptcare';					
			}
			elseif($expData['1']=='32'){
				$type='cond';					
			}
				
			$PatientOrder->saveAll(array('patient_order_encounter_id'=>$lastInsertPatientOrderEncounterId,'note_id'=>$_SESSION['noteId'],'patient_id'=>$id,'isMultiple'=>'Yes','name'=>$expData[2],
					'sentence'=>$expData[4],'type'=>$type,'order_category_id'=>$expData[1],'create_time'=>date('Y-m-d')));
			if($expData[1]=='33'){
				$lastinsid=$PatientOrder->getInsertId();
				$arrayOFMedication=explode(',',$expData[4]);
				
			
				if($arrayOFMedication[4]=='T;N' or $explSenctence[0]==""){
					$dateOfPrescription=date('Y-m-d H:i:s');
				}
				else{
					$dateOfPrescription=$explSenctence[0];
				}
				
				
				
				$strength = Configure::read('selected_strength');
				$dosageForm = Configure::read('selected_roop');
				$route = Configure::read('selected_route_administration');
				$frequencyArray = Configure::read('selected_frequency');
				
				$DosageForm=explode(",",strtoupper($strength[1]));
				
				$sentences_split_ds=explode(" ",$arrayOFMedication[0]);
				
				$DosageForm=explode(",",strtoupper($sentences_split_ds[1]));
			
				//$sentences_split_firstdosedate=explode("dose : ",$arrayOFMedication[4]);
				//set each values
				//split intake
				//$sentences_split_intake=explode("take: ",$arrayOFMedication[5]);
				$sentences_split_intake=explode("take: ",$arrayOFMedication[3]);
				$quantity=explode("Quantity: ",$arrayOFMedication[4]);
				
				//$reviewSubCategory = explode(':',$arrayOFMedication[3]);
				//$reviewSubCategorylabel = strtolower(str_replace(' ','',trim($reviewSubCategory[1])));
				
				if(strtolower($sentences_split_intake[1]) == 'continuous infusion')
				   $reviewSubCategoryId = Configure::read('continuousinfusion');
				else if(strtolower($sentences_split_intake[1]) == 'medications')
					$reviewSubCategoryId = Configure::read('medications');
				else if(strtolower($sentences_split_intake[1]) == 'parenteral')
					$reviewSubCategoryId = Configure::read('Parenteral');
				
				if($reviewSubCategoryId=='Medications')
					$reviewSubCategoryId="27";
			

				$isExistOrderMed=$NewCropPrescription->find('first',array('fields'=>array('id'),'conditions'=>array('patient_uniqueid'=>$id,'description'=>$expData[2])));
				//find drug id to insert in newcrop table
				
				$drugId=$pharmacyItem->find('first',array('fields'=>array('id'),'conditions'=>array('name'=>$expData[2])));
				
				if(empty($isExistOrderMed)){

					$NewCropPrescription->saveAll(array('note_id'=>$_SESSION['noteId'],'patient_id'=>$personId,'drug_name'=>$expData[2],
							'description'=>$expData[2],'date_of_prescription'=>$dateOfPrescription,'patient_order_id'=>$lastinsid,
							'patient_uniqueid'=>$id,'archive'=>'N','is_ccda'=>'1','firstdose'=>$dateOfPrescription,'DosageForm'=>$dosageForm[trim(strtoupper($sentences_split_ds[1]))],
							'dose'=>$sentences_split_ds[0],'strength'=>$strength[trim($DosageForm[0])],'route'=>$route[trim(strtoupper($arrayOFMedication[1]))],'frequency'=>$frequencyArray[trim(strtoupper($arrayOFMedication[2]))],'special_instruction'=>$arrayOFMedication[6],
							'location_id'=>$session->read('locationid'),'review_sub_category_id'=>$reviewSubCategoryId,'drug_id'=>$drugId['PharmacyItem']['id'],'by_nurse'=>"1",'status'=>"0",'batch_identifier'=>$batchIdentifier,'quantity'=>trim($quantity[1])));

					$this->id=null;
					$PatientOrder->updateAll(array('note_id'=>$_SESSION['noteId'],'status'=>"'".Ordered."'"),array('id'=>$lastinsid));
					$this->id=null;
				}
			}
			if($expData[1]=='34'){
				$lastLabId=$PatientOrder->getInsertId();
				$labId=$Laboratory->find('first',array('fields'=>array('id'),'conditions'=>array('name'=>$expData['2'])));
				$isExistOrderLab=$LaboratoryTestOrder->find('first',array('fields'=>array('id'),'conditions'=>array('patient_id'=>$id,'laboratory_id'=>$labId['Laboratory']['id'])));
				if(empty($isExistOrderLab)){
					$explLabData=explode('|',$subData);
					$expLabSenctence=explode(', ',$explLabData[4]);
					$dataLab['Laboratory']['patient_id']=$id;
					$dataLab['Laboratory']['name']=$explLabData[2];
					$dataLab['LaboratoryTestOrder']['patient_id']=$id;
					$dataLab['LaboratoryTestOrder']['patient_order_id']=$lastLabId;
					$dataLab['LaboratoryTestOrder']['specimen_type_id']=$expLabSenctence[0];
					if($expLabSenctence[4]=='T;N'){
						$collected_date=date('Y-m-d');

					}
					else{
						$collected_date=$expLabSenctence[4];

					}
					$dataLab['LaboratoryTestOrder']['collection_priority']=$expLabSenctence[1];
					$dataLab['LaboratoryTestOrder']['collected_date']=$collected_date;
					$dataLab['LaboratoryTestOrder']['frequency_l']=$expLabSenctence[1];
					$expUnit=explode(' ',$expLabSenctence[3]);
					$dataLab['LaboratoryTestOrder']['duration_l']=$expUnit[0];
					$dataLab['LaboratoryTestOrder']['duration_unit']=$expUnit[1];
					$dataLab['LaboratoryTestOrder']['laboratory_id']=$labId['Laboratory']['id'];
					$PatientOrder->updateAll(array('note_id'=>$_SESSION['noteId'],'status'=>"'".Ordered."'"),array('id'=>$lastLabId));
					$this->id=null;
					$LaboratoryTestOrder->insertTestOrder($dataLab);


				}
				$this->id=null;
			}
			
			if($expData[1]=='36'){
				
				
				$lastRadId=$PatientOrder->getInsertId();
				$radId=$Radiology->find('first',array('fields'=>array('id'),'conditions'=>array('name'=>trim($expData['2']),'location_id'=>$session->read("locationid"))));
				$isExistOrderrad=$RadiologyTestOrder->find('first',array('fields'=>array('id'),'conditions'=>array('patient_id'=>$id,'radiology_id'=>$radId['Radiology']['id'])));
				if(empty($isExistOrderrad)){
					$explLabData=explode('|',$subData);
					$expLabSenctence=explode(', ',$explLabData[4]);
					$dataRad['RadiologyTestOrder']['patient_id'] =$id;
					$dataRad['RadiologyTestOrder']['patient_order_id'] = $lastRadId;
					$dataRad['RadiologyTestOrder'] ['name'] = trim($expData['2']);
					$dataRad['RadiologyTestOrder']['radiology_id']=$radId['Radiology']['id'];
					$PatientOrder->updateAll(array('note_id'=>$_SESSION['noteId'],'status'=>"'".Ordered."'"),array('id'=>$lastRadId));
					$this->id=null;
					$RadiologyTestOrder->insertRadioTestOrder_orderset($dataRad);
					$this->id=null;
				}
			}
			else{
				$lastotherId=$PatientOrder->getInsertId();
				//find that order is to be edited or not
				$isExistOrder=$this->find('first',array('fields'=>array('id'),'conditions'=>array('order_data_master_id'=>$expData['0'],'patient_id'=>$id,'order_category_id'=>$expData['1'])));
				if(empty($isExistOrder)){
					$this->saveAll(array('note_id'=>$_SESSION['noteId'],'patient_id'=>$id,'order_data_master_id'=>$expData['0'],'name'=>$expData['2'],'sentence'=>$expData['4'],'isMultiple'=>'Yes','patient_order_id'=>$lastotherId));
					$this->id=null;
					$PatientOrder->updateAll(array('note_id'=>$_SESSION['noteId'],'status'=>"'".Ordered."'"),array('id'=>$lastotherId));
					$this->id=null;
				}
				else{
					$data['id']=$isExistOrder['MultipleOrderContaint']['id'];
					$data['patient_id']=$id;
					$data['order_data_master_id']=$expData['0'];
					$data['name']=$expData['2'];
					$data['sentence']=$expData['4'];
					$data['isMultiple']='Yes';
					$data['patient_order_id']=$lastotherId;
					$this->save($data);

				}



			}

		}
		return true;
	}

}

?>