<?php

/* Report model
 *
* PHP 5
*
* @copyright     Copyright 2013 Drmhope Inc.
* @package       Report.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Aditya Chitmitwar
*/
class Report extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'Report';
	public $useTable = false;



	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	 */

	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}


	public function ControllingHighBp($doctor=null,$startdate=null,$duration=null){
		
			//echo $doctor;
			//exit;
			$Patient = ClassRegistry::init('Patient');
			$Person = ClassRegistry::init('Person');
			$Note = ClassRegistry::init('Note');
			$NoteDiagnosis = ClassRegistry::init('NoteDiagnosis');
			$Doctor = ClassRegistry::init('Doctor');
			$CqmExclusionList = ClassRegistry::init('CqmExclusionList');
			$ProcedurePerform = ClassRegistry::init('ProcedurePerform');
			
			$Patient->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
			//===============================================person bind========================================================================================
			$Patient->bindModel(array('belongsTo' => array(
					'Person' =>array('foreignKey'=>'person_id'))));

			$patient_id=$Patient->find('list',array('fields'=>array('Patient.id','Patient.id'),'conditions'=>array('Patient.doctor_id'=>$doctor,'Patient.admission_type'=>'OPD',
					'OR' => array('DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 <=' => 85,
							'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >=' => 18,'Patient.form_received_on BETWEEN ? AND ?'=> array($startdate,$duration),'Patient.is_discharge !=' => '1')), 'recursive' => 1));

			//==================================================================================================================================================

			$this->set('doctor_name',$Doctor);
			$count_bp_D=$NoteDiagnosis->find('all', array('conditions'=>array('snowmedid'=>'10725009','Patient_id'=>$patient_id,
					'start_dt BETWEEN ? AND ?'=> array($startdate,$duration))));

			$countBp_D=count($count_bp_D);
			
			//debug($count_bp_D);
			//--------------------------------------------------------------------------
			for($i=0;$i<$countBp_D;$i++){
				$p_id[]= $count_bp_D[$i]['NoteDiagnosis']['patient_id'];
				if(count($count_bp_D) !="0"){
					$updatevalue=$CqmExclusionList->find('count',array('conditions'=>array('doctor_id'=>$doctor,'measure_id'=>'0018','patient_id'=>$p_id[$i])));
					if($updatevalue==0){
						$CqmExclusionList->saveAll(array('doctor_id'=>$doctor,'measure_id'=>'0018', 'patient_id'=>$p_id[$i],'location_id'=>$_SESSION['locationid'],'create_time'=>date("Y-m-d")));
					}
				}

			}
			//-------------------------------------Denominator Exclusion----------------------------------
			$ProcedurePerform->bindModel(array(
					'belongsTo'=>array(
							'Patient'=>array('foreignKey'=>false,'conditions'=>array("ProcedurePerform.patient_id=Patient.patient_id"))
					)));
			$denoexp=$ProcedurePerform->find('all',array('fields'=>array('patient_id'),'conditions'=>array('ProcedurePerform.patient_id'=>$p_id,'ProcedurePerform.snowmed_code'=>'108241001')));
			/* debug($denoexp);
			exit; */
			//-------------------------------------------------------------------------------------
			$str=implode(",",$p_id);
//debug($str);
//exit;
//to find uid
			$p=$Patient->find('all',array('fields'=>array('patient_id'),'conditions'=>array('id'=>$p_id)));
			//debug($p);
			foreach($p as $ps){
				$u_id[]=$ps['Patient']['patient_id'];
			}
			
			// to find all id related to uid find above
			$Patient->id=false;
			$p1=$Patient->find('all',array('fields'=>array('id'),'conditions'=>array('patient_id'=>$u_id)));
			
			foreach($p1 as $p1s){
				$all_id[]=$p1s['Patient']['id'];
			}
			$str1=implode(",",$all_id);
			//debug($str);
			//debug($all_id);
			//exit;
			//$this->set('count_bp_DBp',$count_bp_D);
			foreach($count_bp_D as $count_bp_Ds){
				$bp_patient_id[]=$count_bp_Ds['NoteDiagnosis']['patient_id'];
			}

			if($str!= ""){
					$count_bp_N=$Note->find('all',array('fields'=>array('bp','patient_id'),'conditions'=>array('patient_id'=>$all_id,'Note.bp <=' => '140/90','Note.bp >' => '00/00'),'order'=>'Note.bp desc','group'=>'Note.bp'));
				/*$count_bp_N=$Note->query("SELECT `Note`.`id`,`Note`.`patient_id`, `Note`.`bp`,  `Note`.`created_by`, `Note`.`modified_by`, `Note`.`create_time`, `Note`.`modify_time` FROM `notes` AS `Note` INNER JOIN(SELECT MAX(id) as id1 from notes group by Patient_id)
						notes1 on Note.id=notes1.id1 WHERE ((`bp` <= '140/90') OR (`bp` > '00/00')) AND Patient_id IN ($str1) AND `create_time` BETWEEN '$startdate' AND '$duration'  ORDER BY `Note`.`bp` desc");*/
				$countBp_N=count($count_bp_N);
			}
			else{
				$countBp_N=count($count_bp_N);
			}


			$cal_percentage=($countBp_N/$countBp_D)*100;

			return array($countBp_N,$countBp_D,$cal_percentage,$count_bp_D,$count_bp_N,$doctor,count($denoexp),0,$denoexp);

		}
	
	public function LowBackPain($doctor=null,$startdate=null,$duration=null){
	
			$Person = ClassRegistry::init('Person');
			$Patient = ClassRegistry::init('Patient');
			$RadiologyReport = ClassRegistry::init('RadiologyReport');
			$NoteDiagnosis = ClassRegistry::init('NoteDiagnosis');
			$CqmExclusionList = ClassRegistry::init('CqmExclusionList');
			$RadiologyTestOrder = ClassRegistry::init('RadiologyTestOrder');
			$Person->bindModel(array(
					'belongsTo'=>array(
							'Patient'=>array('foreignKey'=>false,'conditions'=>array("Person.id=Patient.person_id"))
					)));


			//$person_data=$Person->find('list',array('fields'=>array('Person.id','Person.id'),
			//		'conditions'=>array('OR'=>array(array('Person.admission_type'=>'OPD'),array('Person.admission_type'=>'emergency')),'Patient.doctor_id'=>$doctor,'Person.age BETWEEN ? AND ?'=> array('18','50')), 'recursive' => 1));
			$person_data=$Person->find('list',array('fields'=>array('Patient.id','Patient.id'),'conditions'=>array('Patient.doctor_id'=>$doctor,'Patient.admission_type'=>'OPD',
					'OR' => array('DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 <=' => 50,
							'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >=' => 18,
							'Patient.form_received_on BETWEEN ? AND ?'=> array($startdate,$duration)))
					, 'recursive' => 1));

			$deno_lbp=$NoteDiagnosis->find('all',array('conditions'=>array('OR'=>array(array('snowmedid'=>'161894002')),'patient_id'=>$person_data),'group'=>array('NoteDiagnosis.patient_id')));
			
			foreach($deno_lbp as $deno_lbps){
				$expec[]=$deno_lbps['NoteDiagnosis']['patient_id'];
			}
			//-------------------------------------Denominator Exclusion----------------------------------
			$this->NoteDiagnosis->id=false;
			//debug($expec);
			$denoexp=$NoteDiagnosis->find('all',array('fields'=>array('patient_id'),'conditions'=>array('NoteDiagnosis.patient_id'=>$expec,'NoteDiagnosis.snowmedid'=>'109267002'),'group' =>'NoteDiagnosis.patient_id'));
			  //debug(($denoexp));
			 //exit; 
			//-------------------------------------------------------------------------------------
			$count_notedig_D=count($deno_lbp);
			$iZero = array_values($person_data);
			foreach($deno_lbp as $deno_lbp_cal){
				$p_id1[]=$deno_lbp_cal['NoteDiagnosis']['patient_id'];
			}
			
			//--------------------------------------------------------------------------
			if($doctor!=''){
			for($i=0;$i<count($iZero);$i++){
				$p_id[]= $iZero[$i];
				if(count($iZero) !="0"){
					$updatevalue=$CqmExclusionList->find('count',array('conditions'=>array('doctor_id'=>$doctor,'measure_id'=>'0052','patient_id'=>$p_id[$i])));
					if($updatevalue==0){
						$CqmExclusionList->saveAll(array('doctor_id'=>$doctor,'measure_id'=>'0052', 'patient_id'=>$p_id[$i],'location_id'=>$_SESSION['locationid'],'create_time'=>date("Y-m-d")));
					}
				}

			}
			}
		
			//-------------------------------------------------------------------------------------
			//to find uid
			$p=$Patient->find('list',array('fields'=>array('patient_id','patient_id'),'conditions'=>array('id'=>$p_id1)));
			
		//	debug($p);
			// to find all id related to uid find above
			$Patient->id=false;
			$p1=$Patient->find('list',array('fields'=>array('id','id'),'conditions'=>array('patient_id'=>$p)));
			//debug($p1);

			
			//---------------------------------------------------------------------------
			$RadiologyTestOrder->bindModel(array(
				'belongsTo'=>array(
						'Patient'=>array('foreignKey'=>false,'conditions'=>array("RadiologyTestOrder.patient_id=Patient.id"))
				)));
			
				$numa_lbp=$RadiologyTestOrder->find('all',array('fields'=>array('patient_id'),
					'conditions'=>array('DATEDIFF(RadiologyTestOrder.start_date,Patient.form_received_on) <='=>28,'RadiologyTestOrder.patient_id'=>$p1)));
			//debug($numa_lbp);
			//exit;
			//-----------------------------------------------------------------------------------------------------
			if(empty($numa_lbp)){
				$count_notedig_N=0;
			}
			else{
				$count_notedig_N=count($numa_lbp);

			}//echo "<pre>";print_r($numa_lbp);

			//$this->set('count_notedig1',$count_notedig1);
			$cal_percentage_notedig=($count_notedig_N/$count_notedig_D)*100;

			return array($deno_lbp,$numa_lbp,$count_notedig_N,$count_notedig_D,$cal_percentage_notedig,$doctor,count($denoexp),0,$denoexp);

		}
	
	public function DocumentationOfCurrentMedication($doctor=null,$startdate=null,$duration=null){
		$Person = ClassRegistry::init('Person');
		$Patient = ClassRegistry::init('Patient');
		$NewCropPrescription = ClassRegistry::init('NewCropPrescription');
			$Note = ClassRegistry::init('Note');
		$CqmExclusionList = ClassRegistry::init('CqmExclusionList');
		

		$Person->bindModel(array(
				'belongsTo'=>array(
						'Patient'=>array('foreignKey'=>false,'conditions'=>array("Person.id=Patient.person_id"))
				)));
		$person_data=$Person->find('list',array('fields'=>array('Patient.patient_id','Patient.patient_id'),'conditions'=>array('Patient.doctor_id'=>$doctor,'Patient.admission_type'=>'OPD',
				'OR' => array('DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 <=' => 100,
						'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >=' => 18,
						'Patient.form_received_on BETWEEN ? AND ?'=> array($startdate,$duration))), 'group'=>'Patient.patient_id','recursive' => 1));
		//$iOne = array_combine(range(1, count($person_data)), array_values($person_data));
		
		$iZero = array_values($person_data);
	//	debug($iZero);
	//debug($person_data);
		$count_DCM_D=count($person_data);
		//debug(($count_DCM_D));
		//exit; 
		//------------------------------------Deniminator exclusion------------------------------------------------------------
		///debug($person_data);
		$x_id1sadf=$Patient->find('list',array('fields'=>array('id','id'),'conditions'=>array('patient_id'=>$person_data)));
		//debug($x_id1sadf);
		$doc=$Note->find('all',array('fields'=>array('patient_id'),'conditions'=>array('Note.is_documentation'=>'7','Note.patient_id'=>$x_id1sadf)));
		//debug($person_data);
		//debug($doc);
		//exit;
		//exit;
		if(empty($doc)){
			$exclusioncount=0;
		}
		else{
			$exclusioncount=count($doc);
		}
		
		//-------------------------------------------------------------------------------------------
		//--------------------------------------------------------------------------
		 for($i=0;$i<count($iZero);$i++){
			$p_id[]= $iZero[$i];
			
			if(count($iZero) !="0"){
				$updatevalue=$CqmExclusionList->find('count',array('conditions'=>array('doctor_id'=>$doctor,'measure_id'=>'0419','patient_id'=>$p_id[$i])));
				if($doctor!=''){
				if($updatevalue==0){
					$CqmExclusionList->saveAll(array('doctor_id'=>$doctor,'measure_id'=>'0419', 'patient_id'=>$p_id[$i],'location_id'=>$_SESSION['locationid'],'create_time'=>date("Y-m-d")));
				
				}
				}
			} 
			
		 }

			//-------------------------------------------------------------------------------------
			//echo "<pre>";print_r($person_data);
			$patient_data=$Patient->find('all',array('fields'=>array(id),'conditions'=>array('patient_id'=>$person_data)));
		//	debug($patient_data);
			foreach($patient_data as $patient_datas123){
				$p_id3211[]=$patient_datas123['Patient']['id'];
			}
//debug($p_id3211);
//exit;

			$countDCM_N=$Note->find('all',array('conditions'=>array('Note.patient_id'=>$p_id3211,'Note.is_documentation'=>'428191000124101'),'group'=>array('Note.patient_id')));
			//debug($countDCM_N);
			//exit;
			//	echo "<pre>";print_r($count_DCM_N);
			//echo "here";
			$count_DCM_N=count($countDCM_N);


			//$this->set('count_notedig1',$count_notedig1);
			$cal_percentage_DCM=($count_DCM_N/$count_DCM_D)*100;
			return array($count_DCM_N,$count_DCM_D,$cal_percentage_DCM,$person_data,$countDCM_N,$doctor,$exclusioncount,'0',$doc);

	
	}
	public function TobaccoScreening($doctor=null,$startdate=null,$duration=null){
		
			$NewCropPrescription = ClassRegistry::init('NewCropPrescription');
			$Patient = ClassRegistry::init('Patient');
			$Person = ClassRegistry::init('Person');
			$CqmExclusionList = ClassRegistry::init('CqmExclusionList');
			$Note = ClassRegistry::init('Note');
			$Person->bindModel(array(
					'belongsTo'=>array(
							'Patient'=>array('foreignKey'=>false,'conditions'=>array("Person.id=Patient.person_id"))
					)));
			$patient_id=$Person->find('all',array('fields'=>array('Patient.patient_id','Patient.lookup_name'),'conditions'=>array('Patient.doctor_id'=>$doctor,'Patient.admission_type'=>'OPD','DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 <=' => 100,
						'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >=' =>19,'Patient.is_deleted'=>'0','Patient.form_received_on BETWEEN ? AND ?'=> array($startdate,$duration)),'group'=>'Patient.patient_id', 'recursive' => 1));
			
			//debug($patient_id);
			//exit;  
		//$this->Patient->id=false;
			//Office Visit count
			foreach($patient_id as $pankajs){
			//echo "hello";
				$aditya_id[]=$pankajs['Patient']['patient_id'];
				//debug($aditya_id);
				$a= $Patient->find('count',array('conditions'=>array('patient_id'=>$pankajs['Patient']['patient_id'])));
				
			
				if($a>=2){
					$id_change[]=$pankajs['Patient']['patient_id'];
				}
			}
				
			//-------------------------------------Denominator Exception----------------------------------
			$expec=$Patient->find('list',array('fields'=>array('id','id'),'conditions'=>array('Patient.patient_id'=>$id_change)));
			//debug($expec);
			$Note->bindModel(array(
					'belongsTo'=>array(
							'Patient'=>array('foreignKey'=>false,'conditions'=>array("Note.patient_id=Patient.patient_id"))
					)));
			//debug($expec);
			$denoexp=$Note->find('all',array('fields'=>array('patient_id'),'conditions'=>array('Note.patient_id'=>$expec,'Note.is_documentation'=>'7'),'group' =>'Note.patient_id'));
			  
			//-------------------------------------------------------------------------------------
			/*$NewCropPrescription->bindModel(array(
					'belongsTo'=>array(
							'Patient'=>array('foreignKey'=>false,'conditions'=>array("NewCropPrescription.patient_id=Patient.patient_id"))
							
					)));*/
			//echo "<pre>";print_r($patient_id);
			if(count($patient_id)!='0'){
			//debug($id_change);
			/*	$countT=$NewCropPrescription->find('all',array('fields'=>array('NewCropPrescription.patient_id','Patient.id'),
				'conditions'=>array('NewCropPrescription.description'=>'nicotine 21mg/24hr-14mg/24hr-7mg/24hr Daily Transderm Patch',
				'Patient.patient_id'=>$id_change)));*/
				
					$countT=$NewCropPrescription->find('all',array('fields'=>array('NewCropPrescription.patient_id'),
				'conditions'=>array('NewCropPrescription.description'=>'nicotine 21mg/24hr-14mg/24hr-7mg/24hr Daily Transderm Patch',
				'NewCropPrescription.patient_id'=>$id_change)));
				
				
				$count_TS_N=count($countT);
				 //echo $count_TS_N;
				
	
				$Toca_D=count($id_change);
				//exit; */
				
				$cal_percentage_Tobacoo=($count_TS_N/$Toca_D)*100;
				return array($count_TS_N,$Toca_D,$cal_percentage_Tobacoo,$id_change,$countT,$doctor,count($denoexp),0,$denoexp);
				//nicotine 21mg/24hr-14mg/24hr-7mg/24hr Daily Transderm Patch
			}
			else{
				return array('0','0','0','0','0');
			}

		}
	public function Depression($doctor=null,$startdate=null,$duration=null){
			$NoteDiagnosis = ClassRegistry::init('NoteDiagnosis');
			$Patient = ClassRegistry::init('Patient');
			$Person = ClassRegistry::init('Person');
			$PlannedProblem = ClassRegistry::init('PlannedProblem');
			$CqmExclusionList = ClassRegistry::init('CqmExclusionList');
			$RiskCategory = ClassRegistry::init('RiskCategory');
			$Person->bindModel(array(
					'belongsTo'=>array(
							'Patient'=>array('foreignKey'=>false,'conditions'=>array("Person.id=Patient.person_id"))
					)));
			$patient_id=$Person->find('list',array('fields'=>array('Patient.patient_id','Patient.patient_id'),'conditions'=>array('Patient.doctor_id'=>$doctor,'Patient.admission_type'=>'OPD','DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 <=' => 100,
						'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >=' => 12,'Patient.form_received_on BETWEEN ? AND ?'=> array($startdate,$duration),'Patient.is_discharge !=' => '1'),'group'=>'Patient.lookup_name','recursive' => 1));
			
			if(count($patient_id)!='0'){
				$Depression_D=count($patient_id);
				$iZero = array_values($patient_id);
				for($i=0;$i<count($iZero);$i++){
					$p_id[]= $iZero[$i];
				
					if(count($iZero) !="0"){
				
						$updatevalueT=$CqmExclusionList->find('count',array('conditions'=>array('doctor_id'=>$doctor,'measure_id'=>'0418','patient_id'=>$p_id[$i])));
							
						if($updatevalueT==0){
								
							$CqmExclusionList->saveAll(array('doctor_id'=>$doctor,'measure_id'=>'0418', 'patient_id'=>$p_id[$i],'location_id'=>$_SESSION['locationid'],'create_time'=>date("Y-m-d")));
						}
					}
				
				}
				$normal_id=$Patient->find('all',array('feilds'=>array('id'),'conditions'=>array('Patient.patient_id'=>$patient_id)));
				
				foreach($normal_id as $normal_ids){
					$p_ids[]=$normal_ids['Patient']['id'];
				}
				//debug($p_ids);
				//echo "<pre>"; print_r($patient_id);
				$RiskCategory->bindModel(array(
					'belongsTo'=>array(
							'Patient'=>array('foreignKey'=>false,'conditions'=>array("RiskCategory.patient_id=Patient.id"))
					),'recursive' => -1));
				$DepressionN=$RiskCategory->find('all',array('fields'=>array('lonic_code','patient_id'),'conditions'=>array('lonic_code'=>'73831-0','RiskCategory.patient_id'=>$p_ids),'group'=>'Patient.lookup_name'));
				//--------------------------------------denominator exclusion---------------------------------------------------------
				$this->NoteDiagnosis->id=false;
				$NoteDiagnosis->bindModel(array(
						'belongsTo'=>array(
								'Patient'=>array('foreignKey'=>false,'conditions'=>array("NoteDiagnosis.patient_id=Patient.id")),
								'RiskCategory'=>array('foreignKey'=>false,'conditions'=>array("RiskCategory.patient_id=Patient.id"))
						),'recursive' => -1));
				$exclusionD=$NoteDiagnosis->find('all',array('fields'=>array('Patient_id','Patient.lookup_name'),'conditions'=>array('OR'=>array('snowmedid'=>'14183003'),
						'RiskCategory.lonic_code'=>'73832-8','NoteDiagnosis.patient_id'=>$p_ids),'group'=>'Patient.lookup_name'));
				//--------------------------------------denominator exception---------------------------------------------------------
				$RiskCategory->bindModel(array(
					'belongsTo'=>array(
							'Patient'=>array('foreignKey'=>false,'conditions'=>array("RiskCategory.patient_id=Patient.id"))
					),'recursive' => -1));
				$exceptionD=$RiskCategory->find('all',array('conditions'=>array('lonic_code'=>'7','RiskCategory.patient_id'=>$p_ids),'group'=>'Patient.lookup_name'));
				//$DepressionN=$RiskCategory->find('all',array('conditions'=>array('OR'=>array(array('icd_id'=>'41696'),array('snowmedid'=>'35489007')),'PlannedProblem.instruction !='=>'','NoteDiagnosis.patient_id'=>$patient_id,'created BETWEEN ? AND ?'=> array($startdate,$duration))));
				if(empty($exceptionD)){
					$countofDepression=0;
				}
				else{
				$countofDepression=count($exceptionD);
				}
				$Depression_N=count($DepressionN);
				//echo "<pre>";print_r($DepressionN);
				$cal_percentage_Depression=($Depression_N/$Depression_D)*100;
				return array($Depression_N,$Depression_D,$cal_percentage_Depression,$patient_id,$DepressionN,$doctor,count($exclusionD),$countofDepression,$exclusionD);
			}
			else{
				return array('0','0','0','0','0');
			}
		}
	public function BMI_A($doctor=null,$startdate=null,$duration=null){
			$Diagnosis = ClassRegistry::init('Diagnosis');
			$Person = ClassRegistry::init('Person');
			$Patient = ClassRegistry::init('Patient');
			$CqmExclusionList = ClassRegistry::init('CqmExclusionList');
			$NoteDiagnosis = ClassRegistry::init('NoteDiagnosis');
			$Person->bindModel(array(
					'belongsTo'=>array(
							'Patient'=>array('foreignKey'=>false,'conditions'=>array("Person.id=Patient.person_id"))
					)));
			$patient_id=$Person->find('list',array('fields'=>array('Patient.id','Patient.id'),'conditions'=>array('Patient.doctor_id'=>$doctor,'Patient.admission_type'=>'OPD',
					'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >=' => 65
					,'Patient.form_received_on BETWEEN ? AND ?'=> array($startdate,$duration),'Patient.is_discharge !=' => '1'), 'recursive' => 1, 'group'=>'Patient.patient_id'));

			$BMI_A_D=count($patient_id);
			//---------------------------denominator Exclusion-------------------------------------------------------------
			$bmia=$NoteDiagnosis->find('all',array('conditions'=>array('NoteDiagnosis.snowmedid'=>'51920004','NoteDiagnosis.patient_id'=>$patient_id)));
			
			if(empty($bmia)){
				$exclusioncount=0;
			}
			else{
				$exclusioncount=count($bmia);
			}
			//-------------------------------------------------------------------------------------------------------
			$iZero = array_values($patient_id);
			for($i=0;$i<count($iZero);$i++){
				$p_id[]= $iZero[$i];
			
				if(count($iZero) !="0"){
			
					$updatevalueT=$CqmExclusionList->find('count',array('conditions'=>array('doctor_id'=>$doctor,'measure_id'=>'0421-1','patient_id'=>$p_id[$i])));
						
					if($updatevalueT==0){
			
						$CqmExclusionList->saveAll(array('doctor_id'=>$doctor,'measure_id'=>'0421-1', 'patient_id'=>$p_id[$i],'location_id'=>$_SESSION['locationid'],'create_time'=>date("Y-m-d")));
					}
				}
			
			}
			if(count($patient_id)!='0'){
				$BMI_AN=$Diagnosis->find('all',array('conditions'=>array('OR'=>array(array('Diagnosis.bmi >='=>'23'),array('Diagnosis.bmi <'=>'30')),'Diagnosis.followup !='=>' ','patient_id'=>$patient_id)));

				$BMI_A_N=count($BMI_AN);

				//echo "<pre>";print_r(count($BMI_AN));
				$cal_percentage_BMI_A=($BMI_A_N/$BMI_A_D)*100;
			}
			if(count($BMI_A_D)=='0'){
				return array('0','0','0','0','0','0');
			}
			else{
				return array($BMI_A_N,$BMI_A_D,$cal_percentage_BMI_A,$patient_id,$BMI_AN,$doctor,$exclusioncount,$bmia);
			}
		}


	public function BMI_B($doctor=null,$startdate=null,$duration=null){
	
			$Diagnosis = ClassRegistry::init('Diagnosis');
			$Person = ClassRegistry::init('Person');
			$Patient = ClassRegistry::init('Patient');
			$Note = ClassRegistry::init('Note');
			$CqmExclusionList = ClassRegistry::init('CqmExclusionList');
			$NoteDiagnosis = ClassRegistry::init('NoteDiagnosis');
			/*$Patient->bindModel(array(
			//		'belongsTo'=>array(
							'Person'=>array('foreignKey'=>false,'conditions'=>array("Person.id=Patient.person_id"))
					)));
			$patient_id=$Patient->find('list',array('fields'=>array('Patient.id','Patient.id'),'conditions'=>array('OR' => array('DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 <=' =>'64',
					'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >=' => '18'),'Patient.doctor_id'=>$doctor,'Patient.admission_type'=>'OPD','Patient.create_time BETWEEN ? AND ?'=> array($startdate,$duration)),'recursive' => 1));*/
			$Person->bindModel(array(
					'belongsTo'=>array(
							'Patient'=>array('foreignKey'=>false,'conditions'=>array("Person.id=Patient.person_id"))
					)));
			$patient_id=$Person->find('list',array('fields'=>array('Patient.patient_id','Patient.patient_id'),'conditions'=>array('Patient.doctor_id'=>$doctor,'Patient.admission_type'=>'OPD',
					'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >=' => 19,'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 <=' => 64
					,'Patient.form_received_on BETWEEN ? AND ?'=> array($startdate,$duration)) ,'recursive' => 1, 'group'=>'Patient.lookup_name'));
			
			$BMI_B_D=count($patient_id);
		
			
			//------------------------------------Deniminator exclusion------------------------------------------------------------
			$x_id=$Patient->find('list',array('fields'=>array('id','id'),'conditions'=>array('patient_id'=>$patient_id)));
			$bmiB=$NoteDiagnosis->find('all',array('conditions'=>array('NoteDiagnosis.snowmedid'=>'169826009','NoteDiagnosis.patient_id'=>$x_id)));
			//debug($x_id);
			//debug($bmiB);
			//debug();
			
			if(empty($bmiB)){
				$exclusioncount=0;
			}
			else{
				$exclusioncount=count($bmiB);
			}
			//debug($exclusioncount);
			//exit;
			//-------------------------------------------------------------------------------------------
			$iZero = array_values($patient_id);
			for($i=0;$i<count($iZero);$i++){
				$p_id[]= $iZero[$i];
					
				if(count($iZero) !="0"){
						
					$updatevalueT=$CqmExclusionList->find('count',array('conditions'=>array('doctor_id'=>$doctor,'measure_id'=>'0421-2','patient_id'=>$p_id[$i])));
			
					if($updatevalueT==0){
							
						$CqmExclusionList->saveAll(array('doctor_id'=>$doctor,'measure_id'=>'0421-2', 'patient_id'=>$p_id[$i],'location_id'=>$_SESSION['locationid'],'create_time'=>date("Y-m-d")));
					}
				}
					
			}
			$pat_id=$Patient->find('all',array('fields'=>array('id'),'conditions'=>array('Patient.patient_id'=>$patient_id)));
		
			foreach($pat_id as $pat_ids){
				$pati_id[]=$pat_ids['Patient']['id'];
			}
			
			if(count($patient_id)!='0'){
				$BMI_BN=$Note->find('all',array('fields'=>array('bmi','patient_id'),'conditions'=>array('Note.bmi >='=>'18.5','Note.bmi <'=>'25','patient_id'=>$pati_id)));
				$BMI_B_N=count($BMI_BN);
				/*  debug($BMI_BN);
				exit; */ 
				$cal_percentage_BMI_B=($BMI_B_N/$BMI_B_D)*100;
			}
			if(count($patient_id)=="0"){
				return array('0','0','0','0','0','0');
			}
			else{
				return array($BMI_B_N,$BMI_B_D,$cal_percentage_BMI_B,$patient_id,$BMI_BN,$doctor,$exclusioncount,$bmiB);
			}



		}
	
	public function PragnentWomen($doctor=null,$startdate=null,$duration=null){
			$Person = ClassRegistry::init('Person');
			$Patient = ClassRegistry::init('Patient');
			$NoteDiagnosis = ClassRegistry::init('NoteDiagnosis');
			$Laboratory = ClassRegistry::init('Laboratory');
			$LaboratoryToken = ClassRegistry::init('LaboratoryToken');
			$CqmExclusionList = ClassRegistry::init('CqmExclusionList');
			$Patient->bindModel(array(
					'belongsTo'=>array(
							'Person'=>array('foreignKey'=>false,'conditions'=>array("Person.id=Patient.person_id"))
					)));
			
			$patient_id=$Patient->find('list',array('fields'=>array('Patient.id','Patient.id'),'conditions'=>array('DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >=' =>'12','Patient.doctor_id'=>$doctor,'Patient.admission_type'=>'OPD','Patient.form_received_on BETWEEN ? AND ?'=> array($startdate,$duration),'Patient.is_discharge !=' => '1'),'recursive' => 1));
			//echo "<pre>";print_r($patient_id);
			/* debug($patient_id);
			exit; */
			if(count($patient_id)!='0'){
				$D=$NoteDiagnosis->find('all',array('conditions'=>array('OR'=>array(array('NoteDiagnosis.icd_id'=>'82694'),array('NoteDiagnosis.snowmedid'=>'169826009')),'patient_id'=>$patient_id)));
				//echo "<pre>";print_r($PW_D)."<br/>";
				$PW_D=count($D);
				
				for($i=0;$i<count($D);$i++){
					$p_id[]= $D[$i]['NoteDiagnosis']['patient_id'];
					if(count($D) !="0"){
							
						$updatevalueP=$CqmExclusionList->find('count',array('conditions'=>array('doctor_id'=>$doctor,'measure_id'=>'0608','patient_id'=>$p_id[$i])));
				/* debug($updatevalueP);
				exit; */
						if($updatevalueP==0){
								
							$CqmExclusionList->saveAll(array('doctor_id'=>$doctor,'measure_id'=>'0608', 'patient_id'=>$p_id[$i],'location_id'=>$_SESSION['locationid'],'create_time'=>date("Y-m-d")));
						}
					}
						
				}
				$LaboratoryToken->bindModel(array(
						'belongsTo'=>array(
								'Laboratory'=>array('foreignKey'=>false,'conditions'=>array("Laboratory.id=LaboratoryToken.laboratory_id")),
								'NoteDiagnosis'=>array('foreignKey'=>false,'conditions'=>array("NoteDiagnosis.patient_id=LaboratoryToken.patient_id"))
						)));
				$N=$LaboratoryToken->find('all',array('conditions'=>array('OR'=>array('Laboratory.lonic_code'=>'10674-0','Laboratory.name'=>'Hepatitis B virus surface Ag'),'NoteDiagnosis.icd_id'=>'82694',
						'LaboratoryToken.patient_id'=>$patient_id),'recursive' => 1));
				//echo "<pre>";print_r($PW_N);
				
				$PW_N=count($N);
				$cal_percentage_PW=($PW_N/$PW_D)*100;
				return array($PW_N,$PW_D,$cal_percentage_PW,$D,$N,$doctor,'0');
			}
			else{
				return array('0','0','0','0','0','0');
			}
		}
	public function elderlymedication($doctor=null,$startdate=null,$duration=null){
			$Person = ClassRegistry::init('Person');
			$Patient = ClassRegistry::init('Patient');
			$NewCropPrescription = ClassRegistry::init('NewCropPrescription');
			$ElderlyMedication = ClassRegistry::init('ElderlyMedication');
			$CqmExclusionList = ClassRegistry::init('CqmExclusionList');
			$Patient->bindModel(array(
					'belongsTo'=>array(
							'Person'=>array('foreignKey'=>false,'conditions'=>array("Person.id=Patient.person_id"))
					)));
			$patient_id=$Patient->find('list',array('fields'=>array('Patient.id','Patient.id'),'conditions'=>array('DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >=' =>'66',
					'Patient.doctor_id'=>$doctor,'Patient.admission_type'=>'OPD','Patient.form_received_on BETWEEN ? AND ?'=> array($startdate,$duration),'Patient.is_discharge !=' => '1'),'recursive' => 1,'group'=>'Patient.patient_id'));
			// debug($patient_id);
			// $this->$Patient->id=false;
			 $pad_id=$Patient->find('list',array('fields'=>array('patient_id','patient_id'),'conditions'=>array('Patient.id'=>$patient_id)));
			// $this->$Patient->id=false;
			 $pad_id1=$Patient->find('all',array('fields'=>array('id'),'conditions'=>array('Patient.patient_id'=>$pad_id)));
			 foreach($pad_id1 as $pad_id1s){
			 	$p_id_1[]=$pad_id1s['Patient']['id'];
			 }
			 
			 //exit; */
			//	debug($patient_id);
			$demo_elder=count($patient_id);
			/* debug($demo_elder);
			exit; */
			$iZero = array_values($patient_id);
			for($i=0;$i<count($iZero);$i++){
				$p_id[]= $iZero[$i];
			
				if(count($iZero) !="0"){
						
					$updatevalueE=$CqmExclusionList->find('count',array('conditions'=>array('doctor_id'=>$doctor,'measure_id'=>'0022','patient_id'=>$p_id[$i])));
			
					if($updatevalueE==0){
			
						$CqmExclusionList->saveAll(array('doctor_id'=>$doctor,'measure_id'=>'0022', 'patient_id'=>$p_id[$i],'location_id'=>$_SESSION['locationid'],'create_time'=>date("Y-m-d")));
					}
				}
			
			}
			//	debug($demo_elder);
			$elderly_medication=$ElderlyMedication->find('all',array('fields'=>array('medication_name'),'group'=>'medication_name'));

			$i=0;
			foreach($elderly_medication as $elderly_medications){
				$elder_expl=explode(" ",$elderly_medications['ElderlyMedication']['medication_name']);
				$eld_str[$i]=$elder_expl[0];
				$i++;
			}
			//debug($eld_str);
			$elder_medi=$NewCropPrescription->find('all',array('conditions'=>array('NewCropPrescription.patient_uniqueid'=>$p_id_1),'group'=>'NewCropPrescription.description'));
		//debug($elder_medi);
		//exit;
			$i=0;
			foreach($elder_medi as $elder_medis){
				$elder_medis=explode(" ",$elder_medis['NewCropPrescription']['description']);
				$elder_medis_str[$i]=$elder_medis[0];
				$i++;
			}
			//debug($elder_medis_str);

			$interaction_elder=array_intersect($elder_medis_str,$eld_str);
		//debug($interaction_elder);
		//exit;
			$single_pid=$NewCropPrescription->find('all',array('conditions'=>array('NewCropPrescription.description LIKE '=>"%cyproheptadine%",
			'NewCropPrescription.patient_uniqueid'=>$p_id_1)));
			
			$numarator_elder=count($interaction_elder);
			$cal_percentage_elder=($numarator_elder/$demo_elder)*100;
			if(!empty($patient_id)){
				return array($numarator_elder,$demo_elder,$cal_percentage_elder,$patient_id,$single_pid,$doctor);

			}
			else{
				return array('0','0','0','0','0','0');
			}
	}
	public function elderlymedication2($doctor=null,$startdate=null,$duration=null){
		$Person = ClassRegistry::init('Person');
		$Patient = ClassRegistry::init('Patient');
		$NewCropPrescription = ClassRegistry::init('NewCropPrescription');
		$ElderlyMedication = ClassRegistry::init('ElderlyMedication');
		$CqmExclusionList = ClassRegistry::init('CqmExclusionList');
		$Patient->bindModel(array(
				'belongsTo'=>array(
						'Person'=>array('foreignKey'=>false,'conditions'=>array("Person.id=Patient.person_id"))
				)));
		
		$patient_id=$Patient->find('list',array('fields'=>array('Patient.id','Patient.id'),'conditions'=>array('DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >=' =>'66',
				'Patient.doctor_id'=>$doctor,'Patient.admission_type'=>'OPD','Patient.form_received_on BETWEEN ? AND ?'=> array($startdate,$duration),'Patient.is_discharge !=' => '1'),'recursive' => 1,'group'=>'Patient.patient_id'));
		
		// debug($patient_id);
		// $this->$Patient->id=false;
		$pad_id=$Patient->find('list',array('fields'=>array('patient_id','patient_id'),'conditions'=>array('Patient.id'=>$patient_id)));
		// $this->$Patient->id=false;
		$pad_id1=$Patient->find('all',array('fields'=>array('id'),'conditions'=>array('Patient.patient_id'=>$pad_id)));
		foreach($pad_id1 as $pad_id1s){
			$p_id_1[]=$pad_id1s['Patient']['id'];
		}
	
		//exit; */
		//	debug($patient_id);
		$demo_elder=count($patient_id);
		/* debug($demo_elder);
		 exit; */
		$iZero = array_values($patient_id);
		for($i=0;$i<count($iZero);$i++){
			$p_id[]= $iZero[$i];
				
			if(count($iZero) !="0"){
	
				$updatevalueE=$CqmExclusionList->find('count',array('conditions'=>array('doctor_id'=>$doctor,'measure_id'=>'0022','patient_id'=>$p_id[$i])));
					
				if($updatevalueE==0){
						
					$CqmExclusionList->saveAll(array('doctor_id'=>$doctor,'measure_id'=>'0022', 'patient_id'=>$p_id[$i],'location_id'=>$_SESSION['locationid'],'create_time'=>date("Y-m-d")));
				}
			}
				
		}
		//	debug($demo_elder);
		$elderly_medication=$ElderlyMedication->find('all',array('fields'=>array('medication_name'),'group'=>'medication_name'));
	
		$i=0;
		foreach($elderly_medication as $elderly_medications){
			$elder_expl=explode(" ",$elderly_medications['ElderlyMedication']['medication_name']);
			$eld_str[$i]=$elder_expl[0];
			$i++;
		}
		//debug($eld_str);
		$elder_medi=$NewCropPrescription->find('all',array('conditions'=>array('NewCropPrescription.patient_uniqueid'=>$p_id_1)));
		$i=0;
		foreach($elder_medi as $elder_medis){
			$elder_medis=explode(" ",$elder_medis['NewCropPrescription']['description']);
			$elder_medis_str[$i]=$elder_medis[0];
			$i++;
		}
		//debug($elder_medis_str);
	
		$interaction_elder=array_intersect($elder_medis_str,$eld_str);
		if(count($interaction_elder)>1){
		$numarator_elder=count($interaction_elder);
		}
		else{
			$numarator_elder=0;
		}
		//debug($numarator_elder);
		//exit;
		$cal_percentage_elder=($numarator_elder/$demo_elder)*100;
		if(!empty($patient_id)){
			return array($numarator_elder,$demo_elder,$cal_percentage_elder,$patient_id,$elder_medi,$doctor);
	
		}
		else{
			return array('0','0','0','0','0','0');
		}
	}
	public function ControllingHighBpImprove($doctor=null,$startdate=null,$duration=null){
	
		//echo $doctor;
		//exit;
		$Patient = ClassRegistry::init('Patient');
		$Person = ClassRegistry::init('Person');
		$Note = ClassRegistry::init('Note');
		$NoteDiagnosis = ClassRegistry::init('NoteDiagnosis');
		$Doctor = ClassRegistry::init('Doctor');
		$CqmExclusionList = ClassRegistry::init('CqmExclusionList');
		$ProcedurePerform = ClassRegistry::init('ProcedurePerform');
	
		$Patient->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		//===============================================person bind========================================================================================
		$Patient->bindModel(array('belongsTo' => array(
				'Person' =>array('foreignKey'=>'person_id'))));
	
		$patient_id=$Patient->find('list',array('fields'=>array('Patient.id','Patient.id'),'conditions'=>array('Patient.doctor_id'=>$doctor,'Patient.admission_type'=>'OPD',
				'OR' => array('DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 <=' => 85,
						'DATE_FORMAT( FROM_DAYS( TO_DAYS( CURDATE( ) ) - TO_DAYS( Person.dob ) ) , "%Y" ) +0 >=' => 18,'Patient.form_received_on BETWEEN ? AND ?'=> array($startdate,$duration),'Patient.is_discharge !=' => '1')), 'recursive' => 1));
	
		//==================================================================================================================================================
	
		$this->set('doctor_name',$Doctor);
		$NoteDiagnosis->bindModel(array(
				'belongsTo'=>array(
						'Note'=>array('foreignKey'=>false,'conditions'=>array("Note.patient_id=NoteDiagnosis.patient_id"))
				)));
		
		$count_bp_D=$NoteDiagnosis->find('all', array('fields'=>array('patient_id'),'conditions'=>array('snowmedid'=>'10725009','NoteDiagnosis.Patient_id'=>$patient_id,'Note.bp >='=>'140',
				'start_dt BETWEEN ? AND ?'=> array($startdate,$duration))));
		
		$countBp_D=count($count_bp_D);
		
		//-----------------------------Denominator Esculsion-------------------------------------------------------------------------
		foreach($count_bp_D as $count_bp_Dss){
			$x_id[]=$count_bp_Dss['NoteDiagnosis']['patient_id'];
		}
		$exce=$ProcedurePerform->find('all',array('conditions'=>array('patient_id'=>$x_id,'snowmed_code'=>'108241001')));
		if(empty($exce)){
			$excount=0;
		}
		else{
			$excount=count($exce);
		}
		//-------------------------------------------------------------------------------------------
		//--------------------------------------------------------------------------
		for($i=0;$i<$countBp_D;$i++){
			$p_id[]= $count_bp_D[$i]['NoteDiagnosis']['patient_id'];
			if(count($count_bp_D) !="0"){
				$updatevalue=$CqmExclusionList->find('count',array('conditions'=>array('doctor_id'=>$doctor,'measure_id'=>'0018-1','patient_id'=>$p_id[$i])));
				if($updatevalue==0){
					$CqmExclusionList->saveAll(array('doctor_id'=>$doctor,'measure_id'=>'0018-1', 'patient_id'=>$p_id[$i],'location_id'=>$_SESSION['locationid'],'create_time'=>date("Y-m-d")));
				}
			}
	
		}
		//-------------------------------------------------------------------------------------
		$str=implode(",",$p_id);
		//debug($str);
		//exit;
		//to find uid
		$p=$Patient->find('all',array('fields'=>array('patient_id'),'conditions'=>array('id'=>$p_id)));
		//debug($p);
		foreach($p as $ps){
			$u_id[]=$ps['Patient']['patient_id'];
		}
			
		// to find all id related to uid find above
		$Patient->id=false;
		$p1=$Patient->find('all',array('fields'=>array('id'),'conditions'=>array('patient_id'=>$u_id)));
			
		foreach($p1 as $p1s){
			$all_id[]=$p1s['Patient']['id'];
		}
		$str1=implode(",",$all_id);
		//debug($str);
		//debug($all_id);
		//exit;
		//$this->set('count_bp_DBp',$count_bp_D);
		foreach($count_bp_D as $count_bp_Ds){
			$bp_patient_id[]=$count_bp_Ds['NoteDiagnosis']['patient_id'];
		}
	
		if($str!= ""){
			$count_bp_N=$Note->find('all',array('fields'=>array('bp','patient_id'),'conditions'=>array('patient_id'=>$all_id,'bp <'=>'140','bp >'=>'0')));
		
			/*$count_bp_N=$Note->query("SELECT `Note`.`id`,`Note`.`patient_id`, `Note`.`bp`,  `Note`.`created_by`, `Note`.`modified_by`, `Note`.`create_time`, `Note`.`modify_time` FROM `notes` AS `Note` INNER JOIN(SELECT MAX(id) as id1 from notes group by Patient_id)
			 notes1 on Note.id=notes1.id1 WHERE ((`bp` <= '140/90') OR (`bp` > '00/00')) AND Patient_id IN ($str1) AND `create_time` BETWEEN '$startdate' AND '$duration'  ORDER BY `Note`.`bp` desc");*/
			$countBp_N=count($count_bp_N);
			
		}
		else{
			$countBp_N=count($count_bp_N);
		}
	
	
		$cal_percentage=($countBp_N/$countBp_D)*100;
	
		return array($countBp_N,$countBp_D,$cal_percentage,$count_bp_D,$count_bp_N,$doctor,$excount,$exce);
	
	}

}
?>