<?php
/**
 * Diagnosis file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj wanajari
 */
class Diagnosis extends AppModel {

	public $name = 'Diagnosis';


	public $actsAs = array('Cipher' => array('autoDecypt' => true,'cipher'=>array(/*'general_examine','final_diagnosis','provisional_diagnosis'
			,'surgery','register_note','consultant_note','plancare_desc','Auditable'*/))); //Commented by Pooja

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
	public function insertDiagnosis($data=array()){
	//debug($data);exit;
		$session = new cakeSession();
		$drug			= ClassRegistry::init('PharmacyItem');
		$diagnosisDrug	= ClassRegistry::init('DiagnosisDrug');
		$drugallergy			= ClassRegistry::init('DrugAllergy');
		$pastmedicalrecord			= ClassRegistry::init('PastMedicalRecord');
		$familyhistory			= ClassRegistry::init('FamilyHistory');
		$lmprecord		= ClassRegistry::init('LmpRecord');
		$dateFormat = ClassRegistry::init('DateFormatComponent');
		$datePerson = ClassRegistry::init('Person');
		$dataPatient = ClassRegistry::init('Patient');
		//first check for a patient record is exist?
		$result= $this->find('first',array('fields'=>array('id','patient_id'),'conditions'=>array('patient_id'=>$data['Diagnosis']['patient_id'])));
		
		//debug($result);exit;//BOF check and insert diagnosis of patient

		if($result){
			//set id for update d record
			$data['Diagnosis']['modify_time']= date("Y-m-d H:i:s");
			$data['Diagnosis']['modify_time']= date("Y-m-d H:i:s");
			$data['Diagnosis']["modified_by"] =  $session->read('userid');
			$this->id = $result['Diagnosis']['id'];
			$diagnosis_id =$result['Diagnosis']['id'] ;
		}else{
			$data['Diagnosis']['create_time'] = date("Y-m-d H:i:s");
			$data['Diagnosis']["created_by"]  =  $session->read('userid');
		}//debug($data);exit;
		
		$this->save($data);
		if(empty($diagnosis_id)){
			$diagnosis_id = $this->getInsertID();
		}
		//EOF check and insert diagnosis of patient
		$diagnosisDrug->deleteAll(array('DiagnosisDrug.diagnosis_id' => $diagnosis_id), false);
 
		//BOF check and insert drugs
			
		foreach($data['drug'] as $key =>$value){
			if(!empty($value)){
				$drugResult= $drug->find('first',array('fields'=>array('id','name'),'conditions'=>array('PharmacyItem.name'=>$value,"PharmacyItem.pack"=>$data['Pack'][$key],"PharmacyItem.location_id"=> $session->read('locationid'))));
				$drug->id ='';
				$diagnosisDrug->id = '';
				if($drugResult){
					$data['DiagnosisDrug']['drug_id'] = $drugResult['PharmacyItem']['id'];
				}else{
					$drug->save(array('name'=>$value,'pack'=>$data['Pack'][$key],'location_id'=> $session->read('locationid')));
					$data['DiagnosisDrug']['drug_id']= $drug->getInsertID();
				}
				 
				//BOF check and insert diagnosis drugs of patient
				//$diagnosisDrugResult  = $diagnosisDrug->find('first',array('fields'=>array('id','diagnosis_id'),'conditions'=>array('diagnosis_id'=>$diagnosis_id,'drug_id'=>$data['DiagnosisDrug']['drug_id'])));
				$data['DiagnosisDrug']['diagnosis_id']=$diagnosis_id;
				/*if($diagnosisDrugResult){
				 $data['DiagnosisDrug']['mode']=  "'".$data['mode'][$key]."'";
				$data['DiagnosisDrug']['tabs_per_day']= "'".$data['tabs_per_day'][$key]."'";
				$diagnosisDrug->updateAll($data['DiagnosisDrug'],array('diagnosis_id'=>$diagnosis_id,'drug_id'=>$data['DiagnosisDrug']['drug_id']));
				}else{ */
				$data['DiagnosisDrug']['mode']=  $data['mode'][$key];
				$data['DiagnosisDrug']['tabs_per_day']= $data['tabs_per_day'][$key];
				$data['DiagnosisDrug']['tabs_frequency']= $data['tabs_frequency'][$key];
				$data['DiagnosisDrug']['quantity']= $data['quantity'][$key];
					
				if(is_array($data['drugTime'][$key])){
					$data['DiagnosisDrug']['first']=  isset($data['drugTime'][$key][0])?$data['drugTime'][$key][0]:'';
					$data['DiagnosisDrug']['second']= isset($data['drugTime'][$key][1])?$data['drugTime'][$key][1]:'';
					$data['DiagnosisDrug']['third']= isset($data['drugTime'][$key][2])?$data['drugTime'][$key][2]:'';
					$data['DiagnosisDrug']['forth']= isset($data['drugTime'][$key][3])?$data['drugTime'][$key][3]:'';
				}
				//$diagnosisDrug->save($data['DiagnosisDrug']);
				 
				//}
				//EOF check and insert diagnosis drugs of patient
			}
		}
		//debug($data['drugfrom']);
		//debug($data['drugreaction']);
		//exit;
		
		foreach($data['drugfrom'] as $key =>$value){
			if(!empty($value)){
				$drugResult= $drug->find('first',array('fields'=>array('id','name'),'conditions'=>array('PharmacyItem.name'=>$value,"PharmacyItem.location_id"=> $session->read('locationid'))));
				//debug($drugResult);
				$drug->id ='';
				$diagnosisDrug->id = '';
				$drugexist="";
				if($drugResult){
					$data['DiagnosisDrug']['drug_id'] = $drugResult['PharmacyItem']['id'];
					$drugexist="yes";

				}else{
					$drug->save(array('name'=>$value,'pack'=>$data['Pack'][$key],'location_id'=> $session->read('locationid')));
					$data['DiagnosisDrug']['drug_id']= $drug->getInsertID();
					$drugexist="no";
				}
				;
					
				 
				//BOF check and insert diagnosis drugs of patient
				//$diagnosisDrugResult  = $diagnosisDrug->find('first',array('fields'=>array('id','diagnosis_id'),'conditions'=>array('diagnosis_id'=>$diagnosis_id,'drug_id'=>$data['DiagnosisDrug']['drug_id'])));
				$data['DiagnosisDrug']['diagnosis_id']=$diagnosis_id;

					
				//now save into patient_allergy table

					
				$data['DiagnosisDrug']['from']=  $data['drugfrom'][$key];
				$data['DiagnosisDrug']['reaction']= $data['drugreaction'][$key];
				$fromd=$data['DiagnosisDrug']['from'];
				$reactiond=$data['DiagnosisDrug']['reaction'];
					
				if($fromd!="")
				{
					if($data["Diagnosis"]["drugallergyid".$key]=="")
						$drugallergy->saveAll($data['DiagnosisDrug'],array('diagnosis_id'=>$diagnosis_id,'drug_id'=>$data['DiagnosisDrug']['drug_id']));
					else
						$drugallergy->updateAll(array('diagnosis_id' => $diagnosis_id,'drug_id'=>$data['DiagnosisDrug']['drug_id'],'from'=>"'$fromd'",'reaction'=>"'$reactiond'"),array('DrugAllergy.id' => $data["Diagnosis"]["drugallergyid".$key]));
				}
				else
				{
					$drugallergy->deleteAll(array('DrugAllergy.id' => $data["Diagnosis"]["drugallergyid".$key]), false);
				}
					
					
					
					

				//}
				//EOF check and insert diagnosis drugs of patient
			}
			 
			 

		}
		//----------------------------------------------------------------------------------------------------------------------------------------------
		//for saving into past medical record
		$getpatient_id=$pastmedicalrecord->find('count' ,array('conditions' => array('patient_id' => $data['Diagnosis']['patient_id'])));
		//$data['Diagnosis']['lmp'] = DateFormatComponent::formatDate2Local($data["Diagnosis"]["lmp"],Configure::read('date_format')) ;
	

		if($getpatient_id > 0){

			$apptID= $data['Diagnosis']['appointment_id'];
			$age_menses= $data['Diagnosis']['age_menses'];
			$length_period= $data['Diagnosis']['length_period'];
			$days_betwn_period= $data['Diagnosis']['days_betwn_period'];
			$recent_change_period= $data['Diagnosis']['recent_change_period'];
			$age_menopause= $data['Diagnosis']['age_menopause'];
			$present_symptom= $data['Diagnosis']['present_symptom'];
			$past_infection= $data['Diagnosis']['past_infection'];
			$hx_abnormal_pap= $data['PastMedicalRecord']['hx_abnormal_pap']; 
			$last_mammography= $data['PastMedicalRecord']['last_mammography'];
			$hx_cervical_bx= $data['Diagnosis']['hx_cervical_bx'];
			$hx_fertility_drug= $data['Diagnosis']['hx_fertility_drug'];
			$hx_hrt_use= $data['Diagnosis']['hx_hrt_use'];
			$hx_irregular_menses= $data['Diagnosis']['hx_irregular_menses'];
			//$lmp= $data['Diagnosis']['lmp'];
			$symptom_lmp= $data['Diagnosis']['symptom_lmp'];				
			$lmp= $dateFormat->formatDate2STD($data['Diagnosis']['lmp'],Configure::read('date_format'));
			$birth_expiry_date= $dateFormat->formatDate2STD($data['Diagnosis']['birth_expiry_date'],Configure::read('date_format'));
			$last_PPD_yes= $dateFormat->formatDate2STD($data['PastMedicalRecord']['last_PPD_yes'],Configure::read('date_format'));			
			$hxAbnormalPap_yes= $dateFormat->formatDate2STD($data['PastMedicalRecord']['hx_abnormal_pap_yes'],Configure::read('date_format'));
			$last_mammography_yes= $dateFormat->formatDate2STD($data['PastMedicalRecord']['last_mammography_yes'],Configure::read('date_format'));
			$sexually_active= $data['Diagnosis']['sexually_active'];
			$with= $data['Diagnosis']['with'];
			$birth_controll= $data['Diagnosis']['birth_controll'];
			$breast_self_exam= $data['Diagnosis']['breast_self_exam'];
			$new_partner= $data['Diagnosis']['new_partner'];
			$partner_notification= $data['Diagnosis']['partner_notification'];
			$hiv_education= $data['Diagnosis']['hiv_education'];
			$pap_education= $data['Diagnosis']['pap_education'];
			$gyn_referral= $data['Diagnosis']['gyn_referral'];
			$abortions_miscarriage= $data['Diagnosis']['abortions_miscarriage'];
			$preventive_care= $data['Diagnosis']['preventive_care'];
			$last_PPD= $data['PastMedicalRecord']['last_PPD'];
			$is_pregnent= $data['PastMedicalRecord']['is_pregnent'];
			$is_pregnent_weeks= $data['PastMedicalRecord']['is_pregnent_weeks'];
			
			$pastmedicalrecord->updateAll(array('appointment_id'=>"'$apptID'",'age_menses'=>"'$age_menses'",'length_period'=>"'$length_period'",'days_betwn_period'=>"'$days_betwn_period'",'recent_change_period'=>"'$recent_change_period'",'age_menopause'=>"'$age_menopause'",
					'present_symptom'=>"'$present_symptom'",
					'past_infection'=>"'$past_infection'",
					'hx_abnormal_pap'=>"'$hx_abnormal_pap'",
					'last_mammography'=>"'$last_mammography'",
					'hx_cervical_bx'=>"'$hx_cervical_bx'",
					'hx_fertility_drug'=>"'$hx_fertility_drug'",
					'hx_hrt_use'=>"'$hx_hrt_use'",
					'hx_irregular_menses'=>"'$hx_irregular_menses'",
					'lmp'=>"'$lmp'",
					'last_PPD_yes'=>"'$last_PPD_yes'",					
					'hx_abnormal_pap_yes'=>"'$hxAbnormalPap_yes'",
					'last_mammography_yes'=>"'$last_mammography_yes'",
					'symptom_lmp'=>"'$symptom_lmp'",
					'sexually_active'=>"'$sexually_active'",
					'with'=>"'$with'",
					'birth_controll'=>"'$birth_controll'",
					'birth_expiry_date'=>"'$birth_expiry_date'",
					
					'breast_self_exam'=>"'$breast_self_exam'",
					'new_partner'=>"'$new_partner'",
					'partner_notification'=>"'$partner_notification'",
					'hiv_education'=>"'$hiv_education'",
					'pap_education'=>"'$pap_education'",
					'gyn_referral'=>"'$gyn_referral'",
					'preventive_care'=>"'$preventive_care'",
					'last_PPD'=>"'$last_PPD'",
					'is_pregnent'=>"'$is_pregnent'",
					'is_pregnent_weeks'=>"'$is_pregnent_weeks'",
					'abortions_miscarriage'=>"'$abortions_miscarriage'"),array('patient_id'=> $data['Diagnosis']['patient_id']));
			
		}
		else {
			$lmp= $dateFormat->formatDate2STD($data['Diagnosis']['lmp'],Configure::read('date_format'));
			$birth_expiry_date= $dateFormat->formatDate2STD($data['Diagnosis']['birth_expiry_date'],Configure::read('date_format'));
			$last_PPD_yes= $dateFormat->formatDate2STD($data['PastMedicalRecord']['last_PPD_yes'],Configure::read('date_format'));
			$hxAbnormalPap_yes= $dateFormat->formatDate2STD($data['PastMedicalRecord']['hx_abnormal_pap_yes'],Configure::read('date_format'));
			$last_mammography_yes= $dateFormat->formatDate2STD($data['PastMedicalRecord']['last_mammography_yes'],Configure::read('date_format'));
		
			$pastmedicalrecord->saveAll(array('appointment_id'=>$data['Diagnosis']['appointment_id'],'age_menses'=>$data['Diagnosis']['age_menses'],'length_period'=>$data['Diagnosis']['length_period'],'days_betwn_period'=>$data['Diagnosis']['days_betwn_period'],'recent_change_period'=>$data['Diagnosis']['recent_change_period'],'age_menopause'=>$data['Diagnosis']['age_menopause'],
					'present_symptom'=>$data['Diagnosis']['present_symptom'],
					'past_infection'=>$data['Diagnosis']['past_infection'],
					'hx_abnormal_pap'=>$data['PastMedicalRecord']['hx_abnormal_pap'],
					'last_mammography'=>$data['PastMedicalRecord']['last_mammography'],
					'hx_cervical_bx'=>$data['Diagnosis']['hx_cervical_bx'],
					'hx_fertility_drug'=>$data['Diagnosis']['hx_fertility_drug'],
					'hx_hrt_use'=>$data['Diagnosis']['hx_hrt_use'],
					'hx_irregular_menses'=>$data['Diagnosis']['hx_irregular_menses'],
					'lmp'=>$lmp,
					'last_PPD_yes'=>$last_PPD_yes,
					'is_pregnent'=>$data['PastMedicalRecord']['is_pregnent'],
					'is_pregnent_weeks'=>$data['PastMedicalRecord']['is_pregnent_weeks'],
					'hx_abnormal_pap_yes'=>$hxAbnormalPap_yes,
					'last_mammography_yes'=>$last_mammography_yes,
					//mp'=>$this=>DateFormat=>formatDate2STD($this=>request=>data['Diagnosis']['lmp'],
					//		Configure::read('date_format')),
					 
					'sexually_active'=>$data['Diagnosis']['sexually_active'],
					'with'=>$data['Diagnosis']['with'],
					'birth_controll'=>$data['Diagnosis']['birth_controll'],
					'birth_expiry_date'=>$birth_expiry_date,
					'breast_self_exam'=>$data['Diagnosis']['breast_self_exam'],
					'new_partner'=>$data['Diagnosis']['new_partner'],
					'partner_notification'=>$data['Diagnosis']['partner_notification'],
					'hiv_education'=>$data['Diagnosis']['hiv_education'],
					'pap_education'=>$data['Diagnosis']['pap_education'],
					'gyn_referral'=>$data['Diagnosis']['gyn_referral'],
					'abortions_miscarriage'=>$data['Diagnosis']['abortions_miscarriage'],
					'preventive_care'=>$data['Diagnosis']['preventive_care'],
					'last_PPD'=>$data['PastMedicalRecord']['last_PPD'],
					'symptom_lmp'=>$data['Diagnosis']['symptom_lmp'],
					'appointment_id'=>$data['Diagnosis']['appointment_id'],
					'patient_id' =>$data['Diagnosis']['patient_id']));
			
			
		}
	
		//---------------------------------------------------------------------------------------------------------------------------------------------------
		//  		$LaboratoryToken->save($this->request->data);
		//$LaboratoryToken->saveAll(array('patient_id' =>$data['LaboratoryToken']['patient_id'],'laboratory_test_order_id'=>$data["LaboratoryToken"]["laboratory_test_order_id"],'laboratory_id'=>$data["LaboratoryToken"]["laboratory_id"],
		//	'sp_id'=>$data["LaboratoryToken"]["sp_id"],'ac_id'=>$data["LaboratoryToken"]["ac_id"],'collected_data'=>$data["LaboratoryToken"]["collected_data"],'status'=>$data["LaboratoryToken"]["status"],
		//'sample'=>$data["LaboratoryToken"]["sample"],'bill_type'=>$data["LaboratoryToken"]["bill_type"],'account_no'=>$data["LaboratoryToken"]["account_no"]));

		 

		//for saving into LMP record
		$getlmprecord=$lmprecord->find('count' ,array('conditions' => array('patient_id' => $data['Diagnosis']['patient_id'])));


		if($getlmprecord > 0){
			$lmp= $data[Diagnosis][lmp];
			$menarche= $data[Diagnosis][menarche];
			$regular= $data[Diagnosis][regular];
			$pregnancies= $data[Diagnosis][pregnancies];
			$tbirths= $data[Diagnosis][tbirths];
			$pbirths= $data[Diagnosis][pbirths];
			$children= $data[Diagnosis][children];
			$miscarriage= $data[Diagnosis][miscarriage];
			 
			$lmprecord->updateAll(array('lmp'=>"'$lmp'",'menarche'=>"'$menarche'",
					'regular'=>"'$regular'",
					'pregnancies'=>"'$pregnancies'",'tbirths'=>"'$tbirths'",'pbirths'=>"'$pbirths'",'miscarriage'=>"'$miscarriage'",'children'=>"'$children'"),array('patient_id'=> $data['Diagnosis']['patient_id']));


		}
		else {
			$lmprecord->saveAll(array('lmp'=>$data[Diagnosis][lmp],'menarche'=>$data[Diagnosis][menarche],
					'regular'=>$data[Diagnosis][regular],
					'pregnancies'=>$data[Diagnosis][pregnancies],'tbirths'=>$data[Diagnosis][tbirths],'pbirths'=>$data[Diagnosis][miscarriage],'children'=>$data[Diagnosis][children],'patient_id' =>$data['Diagnosis']['patient_id']));
		}
		//--------maritail_status--
		
			$maritailStatus=$data['Diagnosis']['maritail_status'];
			$ethnicity=$data['Diagnosis']['ethnicity'];
			$pID=$dataPatient->find('first',array('fields'=>array('person_id'),'conditions'=>array('id'=>$data['Diagnosis']['patient_id'])));
			$datePerson->updateAll(array('maritail_status'=>"'$maritailStatus'",'ethnicity'=>"'$ethnicity'"),array('id'=> $pID['Patient']['person_id']));
		
		//------------------------------------------------------------------------------------------------------------------------------------------------
		//for saving into family history record
		$getfamilyhistory=$familyhistory->find('count',array('conditions' => array('patient_id' => $data['Diagnosis']['patient_id'])));
		
		if($getfamilyhistory > 0){
			$capture_date=$dateFormat->formatDate2STD($data['Diagnosis']['capture_date'],Configure::read('date_format'));
			$problemf=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['problemf']):'' );
			//debug($problemf);exit;
			$statusf=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['statusf']):'' );
			$commentsf=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['commentsf']):'' );
			 
			$problemm=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['problemm']):'' );
			$statusm=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['statusm']):'' );
			$commentsm=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['commentsm']):'' );
			 
			$problemb=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['problemb']):'' );
			$statusb=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['statusb']):'' );
			$commentsb=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['commentsb']):'' );
			 
			$problems=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['problems']):'' );
			$statuss=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['statuss']):'' );
			$commentss=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['commentss']):'' );
			 
			$problemson=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['problemson']):'' );
			$statusson=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['statusson']):'' );
			$commentsson=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['commentsson']):'' );
			 
			$problemd=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['problemd']):'' );
			$statusd=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['statusd']):'' );
			$commentsd=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['commentsd']):'' );
			
			$problemuncle=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['problemuncle']):'' );
			$statusuncle=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['statusuncle']):'' );
			$commentsuncle=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['commentsuncle']):'' );
			
			$problemaunt=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['problemaunt']):'' );
			$statusaunt=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['statusaunt']):'' );
			$commentsaunt=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['commentsaunt']):'' );
			
			$problemgrandmother=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['problemgrandmother']):'' );
			$statusgrandmother=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['statusgrandmother']):'' );
			$commentsgrandmother=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['commentsgrandmother']):'' );
			
			$problemgrandfather=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['problemgrandfather']):'' );
			$statusgrandfather=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['statusgrandfather']):'' );
			$commentsgrandfather=addslashes(isset($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['commentsgrandfather']):'' );
			$apptID = $data['Diagnosis']['appointment_id'];
			$isPositiveFamily=$data['Diagnosis']['is_positive_family'];
			
			if($data['Diagnosis']['is_positive_family'] == '0' || $data['Diagnosis']['is_positive_family'] == ''){
				$familyhistory->updateAll(array('problemf'=>"'$problemf'",'statusf'=>"'$statusf'",'commentsf'=>"'$commentsf'",
						'problemm'=>"'$problemm'",'statusm'=>"'$statusm'",'commentsm'=>"'$commentsm'",
						'problemb'=>"'$problemb'",'statusb'=>"'$statusb'",'commentsb'=>"'$commentsb'",
						'problems'=>"'$problems'",'statuss'=>"'$statuss'",'commentss'=>"'$commentss'",'capture_date'=>"'$capture_date'",
						'problemson'=>"'$problemson'",'statusson'=>"'$statusson'",'commentsson'=>"'$commentsson'",
						'problemd'=>"'$problemd'",'statusd'=>"'$statusd'",'commentsd'=>"'$commentsd'",
						'problemuncle'=>"'$problemuncle'",'statusuncle'=>"'$statusuncle'",'commentsuncle'=>"'$commentsuncle'",
						'problemaunt'=>"'$problemaunt'",'statusaunt'=>"'$statusaunt'",'commentsaunt'=>"'$commentsaunt'",
						'problemgrandmother'=>"'$problemgrandmother'",'statusgrandmother'=>"'$statusgrandmother'",'commentsgrandmother'=>"'$commentsgrandmother'",
						'problemgrandfather'=>"'$problemgrandfather'",'statusgrandfather'=>"'$statusgrandfather'",'commentsgrandfather'=>"'$commentsgrandfather'",'is_positive_family'=>"0",
				'appointment_id'=>"'$apptID'"),array('patient_id'=> $data['Diagnosis']['patient_id']));
				
			}else{
				$familyhistory->updateAll(array('appointment_id'=>$data['Diagnosis']['appointment_id'],'problemf'=>'null','statusf'=>'null','commentsf'=>'null',
						'problemm'=>'null','statusm'=>'null','commentsm'=>'null',
						'problemb'=>'null','statusb'=>'null','commentsb'=>'null',
						'problems'=>'null','statuss'=>'null','commentss'=>'null','capture_date'=>'null',
						'problemson'=>'null','statusson'=>'null','commentsson'=>'null',
						'problemd'=>'null','statusd'=>'null','commentsd'=>'null',
						'problemuncle'=>'null','statusuncle'=>'null','commentsuncle'=>'null',
						'problemaunt'=>'null','statusaunt'=>'null','commentsaunt'=>'null',
						'problemgrandmother'=>'null','statusgrandmother'=>'null','commentsgrandmother'=>'null',
						'problemgrandfather'=>'null','statusgrandfather'=>'null','commentsgrandfather'=>'null','is_positive_family'=>"1"
				),array('patient_id'=> $data['Diagnosis']['patient_id']));
				}
				
		}else{
			$capture_date=$dateFormat->formatDate2STD($data['Diagnosis']['capture_date'],Configure::read('date_format'));
			if($data['Diagnosis']['is_positive_family'] == '0' || $data['Diagnosis']['is_positive_family'] == ''){
				 array_filter($data['Diagnosis']['problemf']);
				 array_filter($data['Diagnosis']['statusf']);
				 array_filter($data['Diagnosis']['commentsf']);
				
				 array_filter($data['Diagnosis']['problemm']);
				 array_filter($data['Diagnosis']['statusm']);
				 array_filter($data['Diagnosis']['commentsm']);
				
				 array_filter($data['Diagnosis']['problemb']);
				 array_filter($data['Diagnosis']['statusb']);
				 array_filter($data['Diagnosis']['commentsb']);
				
				 array_filter($data['Diagnosis']['problems']);
				 array_filter($data['Diagnosis']['statuss']);
				 array_filter($data['Diagnosis']['commentss']);
				
				 array_filter($data['Diagnosis']['problemson']);
				 array_filter($data['Diagnosis']['statusson']);
				 array_filter($data['Diagnosis']['commentsson']);
				
				 array_filter($data['Diagnosis']['problemd']);
				 array_filter($data['Diagnosis']['statusd']);
				 array_filter($data['Diagnosis']['commentsd']);

				 array_filter($data['Diagnosis']['problemuncle']);
				 array_filter($data['Diagnosis']['statusuncle']);
				 array_filter($data['Diagnosis']['commentsuncle']);
				
				 array_filter($data['Diagnosis']['problemaunt']);
				 array_filter($data['Diagnosis']['statusaunt']);
				 array_filter($data['Diagnosis']['commentsaunt']);
				
				 array_filter($data['Diagnosis']['problemgrandmother']);
				 array_filter($data['Diagnosis']['statusgrandmother']);
				 array_filter($data['Diagnosis']['commentsgrandmother']);
				
				 array_filter($data['Diagnosis']['problemgrandfather']);
				 array_filter($data['Diagnosis']['statusgrandfather']);
				 array_filter($data['Diagnosis']['commentsgrandfather']);
				
			//	debug($data['Diagnosis']['problemf']);
				$familyhistory->saveAll(array('appointment_id'=>$data['Diagnosis']['appointment_id'],'capture_date'=>$capture_date,'patient_id' =>$data['Diagnosis']['patient_id'],
						'problemf'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['problemf']):'' ),
						'statusf'=>addslashes(!empty($data['Diagnosis']['statusf'])?serialize($data['Diagnosis']['statusf']):'' ),
						'commentsf'=>addslashes(!empty($data['Diagnosis']['commentsf'])?serialize($data['Diagnosis']['commentsf']):'' ),
								
						'problemm'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['problemm']):'' ),
						'statusm'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['statusm']):'' ),
						'commentsm'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['commentsm']):'' ),
				
						'problemb'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['problemb']):'' ),
						'statusb'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['statusb']):'' ),
						'commentsb'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['commentsb']):'' ),
				
						'problems'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['problems']):'' ),
						'statuss'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['statuss']):'' ),
						'commentss'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['commentss']):'' ),
						
						'problemson'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['problemson']):'' ),
						'statusson'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['statusson']):'' ),
						'commentsson'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['commentsson']):'' ),
				
						'problemd'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['problemd']):'' ),
						'statusd'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['statusd']):'' ),
						'commentsd'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['commentsd']):'' ),
							
						'problemuncle'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['problemuncle']):'' ),
						'statusuncle'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['statusuncle']):'' ),
						'commentsuncle'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['commentsuncle']):'' ),
							
						'problemaunt'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['problemaunt']):'' ),
						'statusaunt'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['statusaunt']):'' ),
						'commentsaunt'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['commentsaunt']):'' ),
							
						'problemgrandmother'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['problemgrandmother']):'' ),
						'statusgrandmother'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['statusgrandmother']):'' ),
						'commentsgrandmother'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['commentsgrandmother']):'' ),
							
						'problemgrandfather'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['problemgrandfather']):'' ),
						'statusgrandfather'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['statusgrandfather']):'' ),
						'commentsgrandfather'=>addslashes(!empty($data['Diagnosis']['problemf'])?serialize($data['Diagnosis']['commentsgrandfather']):'' ),
								
						'is_positive_family'=>'0'
							
				));
				
			}else{
				$familyhistory->saveAll(array('appointment_id'=>$data['Diagnosis']['appointment_id'],'problemf'=>'','statusf'=>'',
						'capture_date'=>'','commentsf'=>'','problemm'=>'','statusm'=>'',
						'commentsm'=>'','problemb'=>'','statusb'=>'',
						'commentsb'=>'','problems'=>'','statuss'=>'',
						'commentss'=>'','patient_id' =>$data['Diagnosis']['patient_id'],'problemson'=>'','statusson'=>'',
						'commentsson'=>'','problemd'=>'','statusd'=>'','commentsd'=>'','problemuncle'=>'','statusuncle'=>'',
						'commentsuncle'=>'','problemaunt'=>'','statusaunt'=>'','commentsaunt'=>'','problemgrandmother'=>'','statusgrandmother'=>'',
						'commentsgrandmother'=>'','problemgrandfather'=>'','statusgrandfather'=>'','commentsgrandfather'=>'','is_positive_family'=>'1'
							
				));
				
			}
			
		}
		
		return $diagnosis_id  ;
		
		//EOF check and insert drugs
	}


	//update some  entries from disachrge summery page
	function updateFromDischargeSummery($data =array()){
		$session  = new cakeSession();
		$data['modify_time']= date("Y-m-d H:i:s");
		$data["modified_by"] =  $session->read('userid');
		$this->save($data) ;
	}


	public function insertPregnancyCount($data=array(),$patient_id)
	{
	//	debug($data);
		$pregnancyCount = ClassRegistry::init('PregnancyCount');
		$size = count($data['date_birth']);
		$dateFormat = ClassRegistry::init('DateFormatComponent');
		//$gotpatient_id=$pregnancyCount->find('all' ,array('conditions' => array('patient_id' => $data['PregnancyCount']['patient_id'])));
		$pregnancyCount->deleteAll(array('PregnancyCount.patient_id' => $patient_id), false);
		 
		for($x=0;$x<$size;$x++)
		{
			if(!empty($data['date_birth'][$x])){
				$resetData['PregnancyCount'][$x]['appointment_id'] = $data['appointment_id'] ;
				$dob=$data['date_birth'][$x];
				$date[$x]= $dateFormat->formatDate2STD($dob,Configure::read('date_format'));
				$resetData['PregnancyCount'][$x]['patient_id'] = $patient_id ;
				$resetData['PregnancyCount'][$x]['counts']=  $data['counts'][$x];
				$resetData['PregnancyCount'][$x]['date_birth']= $date[$x];
				$resetData['PregnancyCount'][$x]['weight']= $data['weight'][$x];
				$resetData['PregnancyCount'][$x]['baby_gender']= $data['baby_gender'][$x];
				$resetData['PregnancyCount'][$x]['week_pregnant']=  $data['week_pregnant'][$x];
				$resetData['PregnancyCount'][$x]['type_delivery']= $data['type_delivery'][$x];
				$resetData['PregnancyCount'][$x]['complication']= $data['complication'][$x];
			}
		}
		//debug($resetData['PregnancyCount']);exit;
		$pregnancyCount->saveAll($resetData['PregnancyCount']);
	}


	public function insertPastMedicalHistory($history=array(),$patient_id,$appointmentID){
		$session = new cakeSession();
		$dateFormat = ClassRegistry::init('DateFormatComponent');
		$pastMedisalHistory = ClassRegistry::init('PastMedicalHistory');
		$size = count(array_filter($history['illness']));
		$pastMedisalHistory->deleteAll(array('PastMedicalHistory.patient_id' => $patient_id), false);
//		debug($appointmentID);exit;
//	debug($history);exit;
		if($history['no_known_problems'] != 1){
			for($x=0;$x<$size;$x++){
				$addData = array() ;
				if($history['ancounter'][$x] == 'yes'){ 
					//$pastMedisalHistory->deleteAll(array('PastMedicalHistory.patient_id' => $history['id'][$x]), false);
					$date=$history['recoverd_date'][$x];
					$recover_date[$x]= $dateFormat->formatDate2STD($date,Configure::read('date_format'));
					$addData['PastMedicalHistory']['appointment_id'] = $history['appointment_id'][$x] ;
					$addData['PastMedicalHistory']['patient_id'] = $history['patient_id'][$x] ;
					$addData['PastMedicalHistory']['illness']=  $history['illness'][$x];
					$addData['PastMedicalHistory']['status']= $history['status'][$x];
					$addData['PastMedicalHistory']['duration']= $history['duration'][$x];
					$addData['PastMedicalHistory']['month']= $history['month'][$x];
					$addData['PastMedicalHistory']['week']= $history['week'][$x];
					$addData['PastMedicalHistory']['comment']=  $history['comment'][$x];
					$addData['PastMedicalHistory']['recoverd_date']=  $recover_date[$x];
					$addData['PastMedicalHistory']['id']= $history['id'][$x];
					$addData['PastMedicalHistory']['create_time']=  date("Y-m-d H:i:s");
					$addData['PastMedicalHistory']['created_by']=  $session->read('userid');
					$addData['PastMedicalHistory']['modified_time']=  date("Y-m-d H:i:s");
					$addData['PastMedicalHistory']['modified_by']=  $session->read('userid');
				//	debug($addData['PastMedicalHistory']);exit;
					$pastMedisalHistory->save($addData['PastMedicalHistory']);
					$pastMedisalHistory->id = '' ;
				}
				
				if($history['ancounter'][$x] == 'no' || $history['ancounter'][$x] == ''){
					$date=$history['recoverd_date'][$x];
					$recover_date[$x]= $dateFormat->formatDate2STD($date,Configure::read('date_format'));
					$addData['PastMedicalHistory']['patient_id'] = $patient_id ;
					$addData['PastMedicalHistory']['appointment_id'] = $appointmentID;
					$addData['PastMedicalHistory']['illness']=  $history['illness'][$x];
					$addData['PastMedicalHistory']['status']= $history['status'][$x];
					$addData['PastMedicalHistory']['duration']= $history['duration'][$x];
					$addData['PastMedicalHistory']['month']= $history['month'][$x];
					$addData['PastMedicalHistory']['week']= $history['week'][$x];
					$addData['PastMedicalHistory']['comment']=  $history['comment'][$x];
					$addData['PastMedicalHistory']['recoverd_date']=  $recover_date[$x];
					$addData['PastMedicalHistory']['create_time']=  date("Y-m-d H:i:s");
					$addData['PastMedicalHistory']['created_by']=  $session->read('userid');
					$addData['PastMedicalHistory']['modified_time']=  date("Y-m-d H:i:s");
					$addData['PastMedicalHistory']['modified_by']=  $session->read('userid');
				//	debug($addData['PastMedicalHistory']);exit;
					$pastMedisalHistory->save($addData['PastMedicalHistory']);
					$pastMedisalHistory->id = '' ;
				}  
			}  
		}else{
			
			$addData['PastMedicalHistory']['patient_id'] = $patient_id;
			$addData['PastMedicalHistory']['appointment_id'] = $appointmentID ;
			$addData['PastMedicalHistory']['no_known_problems'] = $history['no_known_problems'];  
			$addData['PastMedicalHistory']['create_time']=  date("Y-m-d H:i:s");
			$addData['PastMedicalHistory']['created_by']=  $session->read('userid');
			$addData['PastMedicalHistory']['modified_time']=  date("Y-m-d H:i:s");
			$addData['PastMedicalHistory']['modified_by']=  $session->read('userid');
			//debug($addData['PastMedicalHistory']);exit;
			$pastMedisalHistory->save($addData['PastMedicalHistory']);
		}
	}


	public function insertProcedureHistory($procedure=array(),$patient_id){

	//	debug($procedure);exit;
		$session = new cakeSession();
		$procedureHistory= ClassRegistry::init('ProcedureHistory');
		$size = count($procedure['procedure']);
		$dateFormat = ClassRegistry::init('DateFormatComponent');
		 
		$procedureHistory->deleteAll(array('ProcedureHistory.patient_id' => $patient_id), false);
		if($procedure['no_surgical'] != 1){
			for($x=0;$x<$size;$x++){
				if(!empty($procedure['procedure'][$x])){
					$date=$procedure['procedure_date'][$x];
					$date_create[$x]=$dateFormat->formatDate2STD($date,Configure::read('date_format'));
					$Data['ProcedureHistory'][$x]['patient_id'] = $patient_id ;
					$Data['ProcedureHistory'][$x]['appointment_id'] = $procedure['appointment_id'] ;
					$Data['ProcedureHistory'][$x]['procedure']=  $procedure['procedure'][$x];
					$Data['ProcedureHistory'][$x]['provider']= $procedure['provider'][$x];
					$Data['ProcedureHistory'][$x]['procedure_name']=  $procedure['procedure_name'][$x];
					$Data['ProcedureHistory'][$x]['provider_name']= $procedure['provider_name'][$x];
					$Data['ProcedureHistory'][$x]['age_value']=$procedure['age_value'][$x];
					$Data['ProcedureHistory'][$x]['age_unit']= $procedure['age_unit'][$x];
					$Data['ProcedureHistory'][$x]['procedure_date']= $date_create[$x];
					$Data['ProcedureHistory'][$x]['comment']=  $procedure['comment'][$x];
					$Data['ProcedureHistory'][$x]['create_time']=  date("Y-m-d H:i:s");
					$Data['ProcedureHistory'][$x]['created_by']=  $session->read('userid');
					$Data['ProcedureHistory'][$x]['modified_time']=  date("Y-m-d H:i:s");
					$Data['ProcedureHistory'][$x]['modified_by']=  $session->read('userid');
				}
			} //$Data['ProcedureHistory']['appointment_id'] = $procedure['appointment_id'] ;
		}else{
			$Data['ProcedureHistory']['patient_id'] = $patient_id;
			$Data['ProcedureHistory']['appointment_id'] = $procedure['appointment_id'] ;
			$Data['ProcedureHistory']['no_surgical'] = $procedure['no_surgical'];
			$Data['ProcedureHistory']['create_time']=  date("Y-m-d H:i:s");
			$Data['ProcedureHistory']['created_by']=  $session->read('userid');
			$Data['ProcedureHistory']['modified_time']=  date("Y-m-d H:i:s");
			$Data['ProcedureHistory']['modified_by']=  $session->read('userid');
		}
		$procedureHistory->saveAll($Data['ProcedureHistory']);
	}

	//returns patient id only if current encounter dose'nt have record for initial assessment
	public function getPrevEncounterID($patient_id=null,$person_id=null){
		$result = $this->find('first',array('fields'=>array('Diagnosis.id',),'conditions'=>array('Diagnosis.patient_id'=>$patient_id,'Diagnosis.is_deleted'=>0))) ;
		 
		if(empty($result['Diagnosis']['id'])){
				
			$patientObj = ClassRegistry::init('Patient');
			$patientRec = $patientObj->find('first',array('conditions'=>array('Patient.person_id'=>$person_id,'Patient.is_deleted'=>0),'fields'=>array('Patient.id','Patient.person_id'),'order'=>array('Patient.id Asc'))) ;
			return $patientRec['Patient']['id'] ; //return last record for patient
		}
		return ''; // null
	}


	public function insertCurrentTreatment($current=array())
	{
		$session = new cakeSession();
		$drugPharmacyItem			= ClassRegistry::init('PharmacyItem');
		$pharmacyItem	= ClassRegistry::init('PharmacyItemDetail');
		$newCropPrescription = ClassRegistry::init('NewCropPrescription');
		$size = count($current['drug_name']);
		$psychyHistoryId = $current['psychology_history_id'];
		//$newCropPrescription->deleteAll(array('NewCropPrescription.patient_uniqueid' => $patient_id), false);
		/* $getDrugIneraction=$newCropPrescription->drugdruginteracton($current['drug_id']); */
		
	//	debug($current);exit;
				$this->addBlankEntry($current['patient_uniqueid']);
		for($x=0;$x<$size;$x++)
		{
			if(!empty($current['drug_name'][$x])){
				
				//patch to find drug id on the basis of drug name - Important in case of failure in fetching drug id - Pankaj M
				$drugIDOrg= $drugPharmacyItem->find('first',array('fields'=>array('drug_id'),'conditions'=>array('PharmacyItem.name'=>$current['drug_name'][$x])));
				$current['drug_id'][$x]=$drugIDOrg['PharmacyItem']['drug_id'];// set drug id
				
					
				
				$rxCode= $drugPharmacyItem->find('first',array('fields'=>array('id','name','drug_id','rxnorm_code'),'conditions'=>array('PharmacyItem.drug_id'=>$current['drug_id'][$x],"PharmacyItem.location_id"=> $session->read('locationid'))));
				
				$pharmacyDetail= $pharmacyItem->find('first',array('fields'=>array('id','MEDID','MED_REF_GEN_DRUG_NAME_CD','MED_REF_FED_LEGEND_IND_DESC'),'conditions'=>array('PharmacyItemDetail.MEDID'=>$current['drug_id'][$x])));
				
				$currentData['NewCropPrescription'][$x]['appointment_id'] = $current['appointment_id'] ;
				$currentData['NewCropPrescription'][$x]['patient_id'] = $current['patientUId'] ;
				$currentData['NewCropPrescription'][$x]['patient_uniqueid'] = $current['patient_uniqueid'] ;
				$drug_name=explode(" ",$current['drug_name'][$x]);
				$currentData['NewCropPrescription'][$x]['drug_name']=  $drug_name[0];
				$currentData['NewCropPrescription'][$x]['description']=  addslashes($current['drug_name'][$x]);	
				$currentData['NewCropPrescription'][$x]['created_by']=$session->read('userid');
				
				$currentData['NewCropPrescription'][$x]['is_med_administered'] = '0';
				$currentData['NewCropPrescription'][$x]['refusetotakeimmunization'] = '';// aditya
				$currentData['NewCropPrescription'][$x]['firstdose']= date("Y-m-d H:i:s");
				$currentData['NewCropPrescription'][$x]['drug_id']=  $current['drug_id'][$x];
				$currentData['NewCropPrescription'][$x]['dose']= $current['dose'][$x];
				$currentData['NewCropPrescription'][$x]['strength']= $current['DosageForm'][$x];
				$currentData['NewCropPrescription'][$x]['route']=  $current['route'][$x];
				$currentData['NewCropPrescription'][$x]['frequency']=  $current['frequency'][$x];
				$currentData['NewCropPrescription'][$x]['day']= $current['day'][$x];
				$currentData['NewCropPrescription'][$x]['quantity']= $current['quantity'][$x];
				$currentData['NewCropPrescription'][$x]['refills']=  $current['refills'][$x];
				$currentData['NewCropPrescription'][$x]['prn']=  $current['prn'][$x];
				$currentData['NewCropPrescription'][$x]['daw']= $current['daw'][$x];
				$currentData['NewCropPrescription'][$x]['firstdose']=DateFormatComponent::formatDate2STD($current['start_date'][$x],Configure::read('date_format')) ;
				$currentData['NewCropPrescription'][$x]['stopdose']= DateFormatComponent::formatDate2STD($current['end_date'][$x],Configure::read('date_format')) ;
				$currentData['NewCropPrescription'][$x]['last_dose']= DateFormatComponent::formatDate2STD($current['last_dose'][$x],Configure::read('date_format')) ;
				$currentData['NewCropPrescription'][$x]['special_instruction']= $current['special_instruction'][$x];
				$currentData['NewCropPrescription'][$x]['rxnorm']= $rxCode['PharmacyItem']['rxnorm_code'];
				$currentData['NewCropPrescription'][$x]['location_id']= $_SESSION['locationid'];
				$currentData['NewCropPrescription'][$x]['psychology_history_id']= $psychyHistoryId;
				$currentData['NewCropPrescription'][$x]['PrescriptionGuid']= $current['PrescriptionGuid'][$x];
				$currentData['NewCropPrescription'][$x]['is_posted'] = 'no';
				$currentData['NewCropPrescription'][$x]['DeaGenericNamedCode'] = $pharmacyDetail['PharmacyItemDetail']['MED_REF_GEN_DRUG_NAME_CD'];
				$currentData['NewCropPrescription'][$x]['DeaLegendDescription'] = $pharmacyDetail['PharmacyItemDetail']['MED_REF_FED_LEGEND_IND_DESC'];
				
				$currentData['NewCropPrescription'][$x]['DosageForm']= $current['DosageForm'][$x];
				if($current['prescribed_from'][$x]!='NewCrop' or $current['prescribed_from'][$x]=="")
				   $currentData['NewCropPrescription'][$x]['prescribed_from']= "CurTreat";				
				if($current['is_active'][$x]=='1'){
					$currentData['NewCropPrescription'][$x]['archive']= 'N';
					$currentData['NewCropPrescription'][$x]['is_assessment']= "0";
				}else{
					$currentData['NewCropPrescription'][$x]['archive']='Y';
					$currentData['NewCropPrescription'][$x]['is_assessment']= "1";
				}
				$currentData['NewCropPrescription'][$x]['DosageRouteTypeId']= $current['route'][$x];
				$prescriptionDataCount = $newCropPrescription->find('first',array('fields'=>array('id'),'conditions' =>array('patient_uniqueid'=>$patient_id,'drug_id'=> $current['drug_id'][$x])));
				
				if(!empty($prescriptionDataCount['NewCropPrescription']['id']))
				{
					$currentData['NewCropPrescription'][$x]['id']= $prescriptionDataCount['NewCropPrescription']['id'];
					$currentData['NewCropPrescription'][$x]['modified']=date('Y-m-d H:i:s');
				}
				else if(!empty($current['newcroptableid'][$x]))
				{
					$currentData['NewCropPrescription'][$x]['id']= $current['newcroptableid'][$x];
					$currentData['NewCropPrescription'][$x]['modified']=date('Y-m-d H:i:s');
				}
				else
				{
					if(empty($current['date_of_prescription'][$x]))
						$currentData['NewCropPrescription'][$x]['date_of_prescription'] = date("Y-m-d H:i:s");
					else
						$currentData['NewCropPrescription'][$x]['date_of_prescription'] = $current['date_of_prescription'][$x];
					
					$currentData['NewCropPrescription'][$x]['created']=date('Y-m-d H:i:s');
					$currentData['NewCropPrescription'][$x]['modified']="";
				}
				
				
				
				
				//$newCropPrescription->$patient_uniqueid=null;
				$newCropPrescription->id=null;
				
			}
			
			
		}
		$newCropPrescription->saveAll($currentData['NewCropPrescription']);
		return true;
		
	}
	//**************************************Intal Assement Functions******************************************
	public function getTemplateCC($templateId){
		$NoteTemplateText	= ClassRegistry::init('NoteTemplateText');
		$getcc=$NoteTemplateText->find('all',array('conditions'=>array('template_id'=>$templateId,'context_type'=>array('ChiefCompalint','subjective')),
				));
		return $getcc;
		 
		 
	}
	public function getSignificantTests($templateId){
		$NoteTemplateText	= ClassRegistry::init('NoteTemplateText');
		$getText=$NoteTemplateText->find('all',array('conditions'=>array('template_id'=>$templateId,'context_type'=>SignificantTests),
				'fields'=>array('template_text','template_id','id')));
		return $getText;
	}
	//*********************EOF**************************************************************************
	public function getDiagnosisData($patientId,$id,$appointmentID){
		if($appointmentID){
			$getDiagnosis = $this->find('first',array('conditions'=>array('patient_id'=>$patientId,'appointment_id'=>$appointmentID)));
		}else{
			$getDiagnosis = $this->find('first',array('conditions'=>array('patient_id'=>$patientId)));
		}
		return $getDiagnosis;
	}
	
	public function addBlankEntry($patient_id=null){
		
		$session = new cakeSession();
		$Diagnosis	= ClassRegistry::init('Diagnosis');
		if(!$patient_id) return ; 
		//check if patient id is exist
		$getDiagnosisCount = $this->find('first',array('fields'=>'id','conditions'=>array('patient_id'=>$patient_id)));
		if(!$getDiagnosisCount){
			//set id for update d record
			$data['Diagnosis']['create_time'] = date("Y-m-d H:i:s");
			$data['Diagnosis']["created_by"]  =  $session->read('userid');
			$data['Diagnosis']['patient_id'] = $patient_id ;
			$data['Diagnosis']['location_id'] = $session->read('locationid');
			$this->save($data['Diagnosis']);
			$diagnosesId=$this->id;
		}else{
			$diagnosesId = $getDiagnosisCount['Diagnosis']['id'];
		} 
		return $diagnosesId;
	}
	
	
	//checkbox action for active/inactive medication--------------
	public function setNoActiveMedByNurse($patientid=null,$checkrx=null,$patient_uid=null){
		$session = new cakeSession();
		$Diagnosis	= ClassRegistry::init('Diagnosis');
		$Note	= ClassRegistry::init('Note');
		$rec=$Diagnosis->find('first',array('fields'=>array('id','no_med_flag','patient_id'),'conditions'=>array('Diagnosis.patient_id'=> $patientid)));
		if(empty($rec)){
			$ChecktTest= array();
			$ChecktTest['Diagnosis']['no_med_flag'] = 'yes';
			$ChecktTest['Diagnosis']['location_id'] = $session->read('locationid');
			$ChecktTest['Diagnosis']['patient_id'] = $patientid;
			$ChecktTest['Diagnosis']['create_time'] = date("Y-m-d H:i:s");
			$ChecktTest['Diagnosis']["created_by"]  = $session->read('userid');
			$Diagnosis->save($ChecktTest);
		}else{
			$Diagnosis->updateAll(array('no_med_flag'=>'"yes"','modify_time'=>"'".date("Y-m-d H:i:s")."'"),array('Diagnosis.patient_id'=> $patientid));
		}
		$noteRec=$Note->find('first',array('fields'=>array('id','no_med_flag','patient_id'),'conditions'=>array('Note.patient_id'=> $patientid)));
		if(!empty($noteRec)){
			$Note->updateAll(array('no_med_flag'=>'"yes"','modify_time'=>"'".date("Y-m-d H:i:s")."'"),array('Note.patient_id'=> $patientid));
		}
	}
	
	//checkbox action for active/inactive medication--------------
	public function unsetNoActiveMedByNurse($patientid=null,$checkrx=null,$patient_uid=null){
		$session = new cakeSession();
		$Diagnosis	= ClassRegistry::init('Diagnosis');
		$Note	= ClassRegistry::init('Note');
		$Diagnosis->updateAll(array('no_med_flag'=>'"no"','modify_time'=>"'".date("Y-m-d H:i:s")."'"),array('Diagnosis.patient_id'=> $patientid));
		$noteRec=$Note->find('first',array('fields'=>array('id','no_med_flag','patient_id'),'conditions'=>array('Note.patient_id'=> $patientid)));
		if(!empty($noteRec)){
			$Note->updateAll(array('no_med_flag'=>'"no"','modify_time'=>"'".date("Y-m-d H:i:s")."'"),array('Note.patient_id'=> $patientid));
		}
	}
	
	
	//checkbox action for active/inactive Allergy--------------
	public function setNoActiveAllergyByNurse($patientid=null,$checkall=null,$patient_uid=null){
		$session = new cakeSession();
		$Diagnosis	= ClassRegistry::init('Diagnosis');
		$Note	= ClassRegistry::init('Note');
		$rec=$Diagnosis->find('first',array('fields'=>array('id','no_allergy_flag','patient_id'),'conditions'=>array('Diagnosis.patient_id'=> $patientid)));
		if(empty($rec)){
			$ChecktTest= array();
			$ChecktTest['Diagnosis']['no_allergy_flag'] = 'yes';
			$ChecktTest['Diagnosis']['location_id'] = $session->read('locationid');
			$ChecktTest['Diagnosis']['patient_id'] = $patientid;
			$ChecktTest['Diagnosis']['create_time'] = date("Y-m-d H:i:s");
			$ChecktTest['Diagnosis']["created_by"]  = $session->read('userid');
			$Diagnosis->save($ChecktTest);
		}else{
			$Diagnosis->updateAll(array('no_allergy_flag'=>'"yes"','modify_time'=>"'".date("Y-m-d H:i:s")."'"),array('Diagnosis.patient_id'=> $patientid));
		}
		$noteRec=$Note->find('first',array('fields'=>array('id','no_allergy_flag','patient_id'),'conditions'=>array('Note.patient_id'=> $patientid)));
		if(!empty($noteRec)){
			$Note->updateAll(array('no_allergy_flag'=>'"yes"','modify_time'=>"'".date("Y-m-d H:i:s")."'"),array('Note.patient_id'=> $patientid));
		}
	}
	
	//checkbox action for active/inactive Allergy--------------
	public function unsetNoActiveAllergyByNurse($patientid=null,$checkall=null,$patient_uid=null){
		$session = new cakeSession();
		$Diagnosis	= ClassRegistry::init('Diagnosis');
		$Note	= ClassRegistry::init('Note');
		$Diagnosis->updateAll(array('no_allergy_flag'=>'"no"','modify_time'=>"'".date("Y-m-d H:i:s")."'"),array('Diagnosis.patient_id'=> $patientid));
		
		$noteRec=$Note->find('first',array('fields'=>array('id','no_allergy_flag','patient_id'),'conditions'=>array('Note.patient_id'=> $patientid)));
		if(!empty($noteRec)){
			$Note->updateAll(array('no_allergy_flag'=>'"no"','modify_time'=>"'".date("Y-m-d H:i:s")."'"),array('Note.patient_id'=> $patientid));
		}
	}
	
	public function updateFinalDiagnosis($data=array()){ 
		if(!empty($data['diagnosis_id'])){
			$this->id = $data['diagnosis_id'];
			$this->updateAll(array('Diagnosis.final_diagnosis'=>"'".$data['final_diagnosis']."'"),array('Diagnosis.id'=>$data['diagnosis_id']));
		}else{ 
			$this->save($data);
		}
	}	
	public function getProblemHistory($patientId){
		$chiefComplaintData=$this->find('first',array('fields'=>array('complaints','family_tit_bit','flag_event','id','nursing_notes')
			,'conditions'=>array('Diagnosis.patient_id'=>$patientId),'order'=>array('id DESC')));
		return $chiefComplaintData;
	}	
	
}

?>
