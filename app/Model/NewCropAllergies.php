<?php

/* NewCropPrescription model
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
class NewCropAllergies extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'NewCropAllergies';
	public $useTable = 'new_crop_allergies';
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
	public function drugAllergyInteraction($dataOfAllergy,$dataMedication,$allDrug=array()){

		$session = new cakeSession();
		$Facility= ClassRegistry::init('Facility');
		$Facility->unBindModel(array(
				'hasOne'=>array('FacilityDatabaseMapping','FacilityUserMapping')
		));
		$facility = $Facility->find('first', array('fields'=> array('Facility.id','Facility.name'),'conditions'=>array('Facility.is_deleted' => 0, 'Facility.is_active' => 1,'Facility.id' => $session->read("facilityid"))));

        for($k=0;$k<count($dataMedication);$k++){
			$explodeDurgId=explode('|',$dataMedication[$k]);
			$myDrugId1[]=$explodeDurgId['0'];
		}
		foreach( $allDrug as $data){
			$myDrugId[]=$data['NewCropPrescription']['drug_id'];
			
		}
		
		if(!empty($allDrug[0]['NewCropAllergies']['patient_id']))
		$id=$allDrug[0]['NewCropAllergies']['patient_id'];
		else 
			$id='007';// Not IMPORTANT THE VALUE OF ID
		/* POST /v7/WebServices/Drug.asmx HTTP/1.1
		 Host: preproduction.newcropaccounts.com
		Content-Type: text/xml; charset=utf-8
		Content-Length: length
		SOAPAction: "https://secure.newcropaccounts.com/V7/webservices/DrugAllergyInteraction" */

		$curlData='<?xml version="1.0" encoding="utf-8"?>
				<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
		  <soap:Body>
				<DrugAllergyInteraction xmlns="https://secure.newcropaccounts.com/V7/webservices">
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
				<PatientId>'.$id.'</PatientId>
						</patientRequest>
						<patientInformationRequester>
						<UserType>S</UserType>
						<UserId>'.$id.'</UserId>
		      </patientInformationRequester>
		      <allergies>';
		
		foreach($dataOfAllergy as $dataOfAllergys){
			$allergyId.='<string>'.$dataOfAllergys["NewCropAllergies"]["CompositeAllergyID"].'</string>';
		}
		$curlData.=$allergyId;
		$curlData.=' </allergies>
				<proposedMedications>';
				
		if(count($myDrugId1)>1){
			
		for($i=0;$i<=count($myDrugId1)-1;$i++){
			$medId.='<string>'.trim($myDrugId1[$i]).'</string>';
		}
		$curlData.=$medId;
		}
		else {
			
			$medId.='<string>'.trim($myDrugId1[0]).'</string>';
			$curlData.=$medId;
		}
		$curlData.='</proposedMedications>
				<drugStandardType>string</drugStandardType>
				</DrugAllergyInteraction>
		  </soap:Body>
				</soap:Envelope>';
		$url=Configure::read('newCropDrugUrl');
		$curl = curl_init();

        
		curl_setopt ($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl,CURLOPT_TIMEOUT,120);
		curl_setopt($curl,CURLOPT_HTTPHEADER,array (
		'SOAPAction:"https://secure.newcropaccounts.com/V7/webservices/DrugAllergyInteraction"',
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
			$interactionText= (string) $finalxml->DrugAllergyInteractionResponse->DrugAllergyInteractionResult->drugAllergyDetailArray->DrugAllergyDetail->InteractionText;
			$rowcount= (string) $finalxml->DrugAllergyInteractionResponse->DrugAllergyInteractionResult->result->RowCount;
			$xmlObj = $finalxml;
			$listNo=1;
			foreach($xmlObj->DrugAllergyInteractionResponse->DrugAllergyInteractionResult->drugAllergyDetailArray->DrugAllergyDetail as $key=>$data){
				//$listAllergyIneraction[]=(string) $data->InteractionText;
				$listAllergyIneraction[]='<span style="color:#000">'.$listNo++.') '.(string) $data->InteractionText.'</span>';
			}
			$rowcount=(string) $finalxml->DrugAllergyInteractionResponse->DrugAllergyInteractionResult->result->RowCount;
			$xmldata = simplexml_load_string($xmlString);
		}
		return array('rowcount'=>$rowcount,'rowDta'=>$listAllergyIneraction);

	}
	public function getAllergyHistory($patientId,$apptId){
		$get_allergies=$this->find('all',array('fields'=>array('reaction','name','note','reaction','AllergySeverityName','status'),
				'conditions'=>array('NewCropAllergies.patient_uniqueid'=>$patientId,/*'NewCropAllergies.appointment_id'=>$apptId,*/'NewCropAllergies.is_deleted'=>0,'NewCropAllergies.status'=>'A')));
		return $get_allergies;
	}
}
?>
