<?php
/**
 * SmsApi Model
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       SmsApi Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mahalaxmi 
 */
 

App::uses('CakeSession', 'Model/Datasource');
App::uses('Component', 'Controller');
App::uses('DateFormatComponent', 'Controller/Component');  
class ClaimsmsShell extends AppShell {
	public $name = 'Claimsms';
	public $uses = array('SmsApi','Session','cakeSession'); 
	public $component = array('Session') ;
	
	public function main() {
		$this->sendToSmsForClaim();		
	}
	/**
	 * function for send SMS related to claim Approved or Rejected.
	 * @param unknown_type .
	 * @Mahalaxmi
	 */
	public function sendToSmsForClaim(){
		App::uses('Patient', 'Model');
		App::uses('PharmacySalesBill', 'Model');
		App::uses('InventoryPharmacySalesReturn', 'Model');
		App::uses('TariffStandard', 'Model');
		$dbconfig = ConnectionManager::getDataSource('defaultHospital')->config; 
		$this->database = $dbconfig['database']; 

		$patientModel = new Patient(null,null,$this->database);
		$tariffStandardModel = new TariffStandard(null,null,$this->database);

			
		$patientModel->unBindModel(array(
					'hasMany' => array(new PharmacySalesBill(null,null,$this->database),
							new InventoryPharmacySalesReturn(null,null,$this->database))));


		$getTariffRgjayId=$tariffStandardModel->getTariffStandardID('RGJAY');			
		$patientDataAll =$patientModel->find('all',array('fields'=>array('Patient.id','Patient.lookup_name','Patient.claim_status','Patient.claim_status_change_date'),'conditions'=>array('Patient.tariff_standard_id'=>$getTariffRgjayId,'Patient.is_discharge'=>1,'Patient.is_deleted'=>0)));
	
		foreach($patientDataAll as $key=>$patientDataAlls){			
			$date=strtotime($patientDataAlls['Patient']['claim_status_change_date']);
			$newDateThirtyAfterDays = date('Y-m-d',strtotime('+30 days',$date));
			$newDateThirteenAfterDays1 = date('Y-m-d',strtotime('+13 days',$date));
			$newDateFourteenAfterDays2 = date('Y-m-d',strtotime('+14 days',$date));
			$newDateFifteenAfterDays = date('Y-m-d',strtotime('+15 days',$date)); //It should be  on 15 day only			
			$newDateThirteenAfterDays4 = date('Y-m-d',strtotime('+16 days',$date));
			$newDateThirteenAfterDays5 = date('Y-m-d',strtotime('+17 days',$date));
			$newDateThirteenAfterDays6 = date('Y-m-d',strtotime('+18 days',$date));
			$newDateThirteenAfterDays7 = date('Y-m-d',strtotime('+19 days',$date));
			$newDateTwentyAfterDays = date('Y-m-d',strtotime('+20 days',$date));
			

			$newDateTenAfterDays = date('Y-m-d',strtotime('+10 days',$date));
			$getClaimSatusChangeDate=explode(" ",$patientDataAlls['Patient']['claim_status_change_date']);
			$patientDataAlls['Patient']['claim_status_change_date'] =DateFormatComponent::formatDate2LocalForReport($patientDataAlls['Patient']['claim_status_change_date'],Configure::read('date_format'));

			$newDateTwentyAfterDays1 =DateFormatComponent::formatDate2LocalForReport($newDateTwentyAfterDays,Configure::read('date_format'));
			
			$newDateThirtyAfterDays =DateFormatComponent::formatDate2LocalForReport($newDateThirtyAfterDays,Configure::read('date_format'));			
			
			
			if(($patientDataAlls['Patient']['claim_status']=="Preauth Approved" || $patientDataAlls['Patient']['claim_status']=="Pre-authorization (Approved)") && $newDateFifteenAfterDays==date('Y-m-d')){
				$showMsg= sprintf(Configure::read('claimSmsPreAuth'),$patientDataAlls['Patient']['lookup_name'],$patientDataAlls['Patient']['claim_status_change_date'],$newDateThirtyAfterDays,Configure::read('hosp_details'));
				$this->SmsApi->sendToSms($showMsg,Configure::read('cordinator_rgjay_mobile_no')); //for admit to send SMS to All cordinators of RGJAY.
			}else if($patientDataAlls['Patient']['claim_status']=="Claim Doctor Rejected" && $newDateTenAfterDays==date('Y-m-d')){		//10th		
				$d_start    = new DateTime($getClaimSatusChangeDate[0]);
				$d_end      = new DateTime($newDateTenAfterDays);
				$diff = $d_start->diff($d_end);					
				$getDays= (int) $diff->days;	
				$showMsg= sprintf(Configure::read('claimSmsClaimRej'),$getDays,$patientDataAlls['Patient']['lookup_name'],$patientDataAlls['Patient']['claim_status_change_date'],$newDateTwentyAfterDays1,Configure::read('hosp_details'));				
				$this->SmsApi->sendToSms($showMsg,Configure::read('cordinator_rgjay_mobile_no')); //for admit to send SMS to All cordinators of RGJAY.
			}else if($patientDataAlls['Patient']['claim_status']=="Claim Doctor Rejected" &&  $newDateThirteenAfterDays1==date('Y-m-d')){ //13th	
				$d_start    = new DateTime($getClaimSatusChangeDate[0]);
				$d_end      = new DateTime($newDateThirteenAfterDays1);
				$diff = $d_start->diff($d_end);					
				$getDays= (int) $diff->days;	
				$showMsg= sprintf(Configure::read('claimSmsClaimRej'),$getDays,$patientDataAlls['Patient']['lookup_name'],$patientDataAlls['Patient']['claim_status_change_date'],$newDateTwentyAfterDays1,Configure::read('hosp_details'));			
				$this->SmsApi->sendToSms($showMsg,Configure::read('cordinator_rgjay_mobile_no')); //for admit to send SMS to All cordinators of RGJAY.
			}else if($patientDataAlls['Patient']['claim_status']=="Claim Doctor Rejected" && $newDateFifteenAfterDays==date('Y-m-d')){		//15th			
				$d_start    = new DateTime($getClaimSatusChangeDate[0]);
				$d_end      = new DateTime($newDateFifteenAfterDays);
				$diff = $d_start->diff($d_end);						
				$getDays= (int) $diff->days;
				$showMsg= sprintf(Configure::read('claimSmsClaimRej'),$getDays,$patientDataAlls['Patient']['lookup_name'],$patientDataAlls['Patient']['claim_status_change_date'],$newDateTwentyAfterDays1,Configure::read('hosp_details'));				
				$this->SmsApi->sendToSms($showMsg,Configure::read('cordinator_rgjay_mobile_no')); //for admit to send SMS to All cordinators of RGJAY.
			}else if($patientDataAlls['Patient']['claim_status']=="Claim Doctor Rejected" && $newDateThirteenAfterDays4==date('Y-m-d')){ //16th
				$d_start    = new DateTime($getClaimSatusChangeDate[0]);
				$d_end      = new DateTime($newDateThirteenAfterDays4);
				$diff = $d_start->diff($d_end);					
				$getDays= (int) $diff->days;
				$showMsg= sprintf(Configure::read('claimSmsClaimRej'),$getDays,$patientDataAlls['Patient']['lookup_name'],$patientDataAlls['Patient']['claim_status_change_date'],$newDateTwentyAfterDays1,Configure::read('hosp_details'));			
				$this->SmsApi->sendToSms($showMsg,Configure::read('cordinator_rgjay_mobile_no')); //for admit to send SMS to All cordinators of RGJAY.
			}else if($patientDataAlls['Patient']['claim_status']=="Claim Doctor Rejected" && $newDateThirteenAfterDays5==date('Y-m-d')){ //17th
				$d_start    = new DateTime($getClaimSatusChangeDate[0]);
				$d_end      = new DateTime($newDateThirteenAfterDays5);
				$diff = $d_start->diff($d_end);					
				$getDays= (int) $diff->days;
				$showMsg= sprintf(Configure::read('claimSmsClaimRej'),$getDays,$patientDataAlls['Patient']['lookup_name'],$patientDataAlls['Patient']['claim_status_change_date'],$newDateTwentyAfterDays1,Configure::read('hosp_details'));				
				$this->SmsApi->sendToSms($showMsg,Configure::read('cordinator_rgjay_mobile_no')); //for admit to send SMS to All cordinators of RGJAY.
			}else if($patientDataAlls['Patient']['claim_status']=="Claim Doctor Rejected" && $newDateThirteenAfterDays6==date('Y-m-d')){ //18th	
				$d_start    = new DateTime($getClaimSatusChangeDate[0]);
				$d_end      = new DateTime($newDateThirteenAfterDays6);
				$diff = $d_start->diff($d_end);					
				$getDays= (int) $diff->days;
				$showMsg= sprintf(Configure::read('claimSmsClaimRej'),$getDays,$patientDataAlls['Patient']['lookup_name'],$patientDataAlls['Patient']['claim_status_change_date'],$newDateTwentyAfterDays1,Configure::read('hosp_details'));					
				$this->SmsApi->sendToSms($showMsg,Configure::read('cordinator_rgjay_mobile_no')); //for admit to send SMS to All cordinators of RGJAY.
			}else if($patientDataAlls['Patient']['claim_status']=="Claim Doctor Rejected" && $newDateThirteenAfterDays7==date('Y-m-d')){ //19th	
				$d_start    = new DateTime($getClaimSatusChangeDate[0]);
				$d_end      = new DateTime($newDateThirteenAfterDays7);
				$diff = $d_start->diff($d_end);					
				$getDays= (int) $diff->days;
				$showMsg= sprintf(Configure::read('claimSmsClaimRej'),$getDays,$patientDataAlls['Patient']['lookup_name'],$patientDataAlls['Patient']['claim_status_change_date'],$newDateTwentyAfterDays1,Configure::read('hosp_details'));			
				$this->SmsApi->sendToSms($showMsg,Configure::read('cordinator_rgjay_mobile_no')); //for admit to send SMS to All cordinators of RGJAY.
			}else if($patientDataAlls['Patient']['claim_status']=="Claim Doctor Rejected" && $newDateTwentyAfterDays==date('Y-m-d')){   //20th	
				$d_start    = new DateTime($getClaimSatusChangeDate[0]);
				$d_end      = new DateTime($newDateTwentyAfterDays);
				$diff = $d_start->diff($d_end);					
				$getDays= (int) $diff->days;
				$showMsg= sprintf(Configure::read('claimSmsClaimRej'),$getDays,$patientDataAlls['Patient']['lookup_name'],$patientDataAlls['Patient']['claim_status_change_date'],$newDateTwentyAfterDays1,Configure::read('hosp_details'));					
				$this->SmsApi->sendToSms($showMsg,Configure::read('cordinator_rgjay_mobile_no')); //for admit to send SMS to All cordinators of RGJAY.
			}																																																	
		}	
	}
}