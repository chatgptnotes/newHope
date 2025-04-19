<?php 
//$client = new SoapClient("https://preproduction.newcropaccounts.com/v7/WebServices/Update1.asmx?WSDL");
//var_dump($client->__getFunctions());
//var_dump($client->__getTypes());
//$params = array('accountIDTextBox' => 'demo', 'siteIDTextBox' => 'demo','patientIDTextBox'=>'UHHO13C15009','accountTextBox'=>'DrMHope','usernameTextBox'=>'demo','credentialsTextBox'=>'demo');
//$response=$client->GetPatientFullMedicationHistory6($params);
//var_dump($response);


$curlData = '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>';
$curlData.='<DrugAllergyInteractionV2 xmlns="https://secure.newcropaccounts.com/V7/webservices">';
$curlData.= '<credentials>
				<PartnerName>DrMHope</PartnerName>
				<Name>demo</Name>
				<Password>demo</Password>
				</credentials>';
$curlData.=' <accountRequest>
				<AccountId>drmhope</AccountId>
				<SiteId>1</SiteId>
				</accountRequest>';
$curlData.=' <patientRequest>
				<PatientId>UHHO13I04002</PatientId>
						</patientRequest>';
$curlData.=' <patientInformationRequester>
				<UserType>S</UserType>
				<UserId>UHHO13I04002</UserId>
		      </patientInformationRequester>';
$curlData.='<allergies>
		        <string>Sulfasalazine</string>
		      </allergies>';
$curlData.='<proposedMedications>
		        <string>Lantus 100 unit/mL Sub-Q</string>
		      </proposedMedications>';
$curlData.='<drugStandardType>R</drugStandardType>
		    </DrugAllergyInteractionV2>
		  </soap:Body>
		</soap:Envelope>';
$url='http://preproduction.newcropaccounts.com//v7/WebServices/Update1.asmx';
$curl = curl_init();

curl_setopt ($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl,CURLOPT_TIMEOUT,120);
//curl_setopt($curl,CURLOPT_ENCODING,'gzip');

curl_setopt($curl,CURLOPT_HTTPHEADER,array (
    'SOAPAction:"https://secure.newcropaccounts.com/V7/webservices/DrugAllergyInteractionV2"',
    'Content-Type: text/xml; charset=utf-8',
));

curl_setopt ($curl, CURLOPT_POST, 1);
curl_setopt ($curl, CURLOPT_POSTFIELDS, $curlData);

$result = curl_exec($curl);
//print_r($result);
curl_close ($curl);
$xml =simplexml_load_string($result);
//print_r($xml);
$xml->registerXPathNamespace("soap", "http://schemas.xmlsoap.org/soap/envelope/");
$finalxml=$xml->xpath('//soap:Body');
//print_r($finalxml[0]);

//$finalxml=(array)$finalxml[0];
//echo  echo $xmldata->ICD9_DEFINITIONS_IMO->RECORD->DEFINITION_TEXT;
$finalxml=$finalxml[0];
//echo "<pre>";print_r($finalxml);
//echo $finalxml["GetPatientFullMedicationHistory6Response"]
//$staus= $finalxml->GetPatientFullMedicationHistory6Response->GetPatientFullMedicationHistory6Result->Status;
$response= $finalxml->DrugAllergyInteractionV2Response->DrugAllergyInteractionV2Result->XmlResponse;
echo "<pre>";print_r($response);
$xmlString= base64_decode($response);
echo "<pre>";print_r($xmlString);
$xmldata = simplexml_load_string($xmlString);
print_r($xmldata);
?>