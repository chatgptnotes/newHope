<?php
App::uses('AppModel', 'Model');
/**
 * XmlNote Model file
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 Drmhope Softwares  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Hope
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gulshan Trivedi
*/
class XmlNote extends AppModel {

	public $name = 'XmlNote';
	public $uses = array('XmlNote');
	public $specific = true;
	public $string = "#";
	public $numXml = "0";


	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
			
	}


	public function generateCcdaHeader($id=null,$note_id=null,$person_id=null,$consolidated=false,$permissions=array(),$check_e2=false){

		$headerString = "";
		$headerNumXml = "";
		$session = new cakeSession();

		$xml = ClassRegistry::init('XmlNote');
		$mode1 = ClassRegistry::init('Note');
		$mode2 = ClassRegistry::init('Patient');
		$mode3 = ClassRegistry::init('Person');
		$mode4 = ClassRegistry::init('Country');
		$mode5 = ClassRegistry::init('State');
		$mode6 = ClassRegistry::init('City');
		$mode7 = ClassRegistry::init('User');
		$guardian = ClassRegistry::init('Guardian');
		$noteDiagnosis = ClassRegistry::init('NoteDiagnosis');


		$guardian->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array('foreignKey'=>false,
								'conditions'=>array('Initial.id = Guardian.guar_initial_id')),
				)));

		$mode1->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>false,
								'conditions'=>array('Patient.id = Note.patient_id')),
				)));


		$mode2->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));

		$mode2->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey'=>false,
								'conditions'=>array('Patient.doctor_id = User.id')),
				)));

		$patientname = $mode2->find('all',array('fields'=>array('lookup_name','patient_id','doctor_id','User.first_name','User.last_name','form_received_on','discharge_date'),
				'conditions'=>array('Patient.person_id'=>$person_id)));
		//debug($patientname);exit;
		$mode3->bindModel(array(
				'belongsTo' => array(
						'Race' =>array('foreignKey'=>false,
								'conditions'=>array('Race.value_code = Person.race')),
						'Country' =>array('foreignKey'=>false,
								'conditions'=>array('Country.id = Person.country')),
				)));

		$documentCreated=$xml->find('first',array('fields'=>array('modified','id','created'),'conditions'=>array('XmlNote.patient_id'=>$id),
				'order'=>array('XmlNote.id DESC'),'limit'=>1));

		$patient_info= $mode3->find('first',array('fields'=>array('Race.race_name','first_name','middle_name','last_name',
				'sex','maritail_status','dob',
				'suffix1','religion','patient_uid','ssn_us','city','Country.name','state','pin_code','home_phone','ethnicity',
				'patient_owner','plot_no','name_type'),'conditions'=>array('Person.patient_uid'=>$patientname[0]['Patient']['patient_id'])));
		$guardian_info=$guardian->find('first',array('fields'=>array('Initial.name','guar_first_name','guar_last_name',
				'guar_phone','guar_address1','guar_relation','guar_country','guar_state','guar_city','guar_zip'),
				'conditions'=>array('Guardian.person_id'=>$person_id)));
		$country=$mode4->find('first',array('fields'=>array('name'),'conditions'=>array('Country.id'=>$_SESSION['Auth']['User']['country_id'])));
		$state=$mode5->find('first',array('fields'=>array('name'),'conditions'=>array('State.id'=>$_SESSION['Auth']['User']['state_id'])));
		//$city=$mode6->find('first',array('fields'=>array('name'),'conditions'=>array('City.id'=>$_SESSION['location'])));

		/* 	$doctor=$mode7->find('first',array('fields'=>array('initial_id','first_name','last_name'),
		 'conditions'=>array('User.id'=>$patientname[0]['Patient']['doctor_id'],
		 		'Patient.patient_id'=>$patientname[0]['Patient']['patient_id'])));  */


		$patient_uid=$patientname[0]['Patient']['patient_id'];
		$date=date("ymd"."000000+0500");
		$facilityid=$session->read('facilityid');
		$fac=$session->read('facility');
		$address1=($_SESSION['Auth']['User']['address1']);
		$postal1=($_SESSION['Auth']['User']['zipcode']);
		$phone1=($_SESSION['Auth']['User']['phone1']);

		if($consolidated){

			$encounters=$noteDiagnosis->find('first',array('fields'=>array('diagnoses_name','start_dt','end_dt','snowmedid'),
					'order'=>array('NoteDiagnosis.id DESC'),'limit'=>1,
					'conditions'=>array('NoteDiagnosis.patient_id'=>$id)));
		}else{
			$encounters=$noteDiagnosis->find('first',array('fields'=>array('diagnoses_name','start_dt','end_dt','snowmedid'),
					'conditions'=>array('NoteDiagnosis.note_id'=>$note_id,'NoteDiagnosis.patient_id'=>$id)));
		}

		$stDate = $this->customStrtoTime($encounters['NoteDiagnosis']['start_dt']);
		$startdt=date ("Ymd" , $stDate );
		$edDate = $this->customStrtoTime($encounters['NoteDiagnosis']['end_dt']);
		$enddt=date ("Ymd" , $edDate );
		$dateOfBirth=str_replace("-","",$patient_info['Person']['dob']);
 
		//---if empty ----
		$snowCode = ($condition == $encounters['NoteDiagnosis']['snowmedid']) ? $headerNumXml : $encounters['NoteDiagnosis']['snowmedid']  ; // if snowmedid empty
		$startDate = ($condition == $encounters['NoteDiagnosis']['start_dt']) ? $headerNumXml : $encounters['NoteDiagnosis']['start_dt']  ; // if start dateis empty
		$endDate = ($condition == $encounters['NoteDiagnosis']['end_dt']) ? $headerNumXml : $encounters['NoteDiagnosis']['end_dt']  ; // if end date is empty
		$problemName = ($condition == $encounters['NoteDiagnosis']['diagnoses_name']) ? $headerString : $encounters['NoteDiagnosis']['diagnoses_name']  ; // if diagnoses_name is empty
		$facility = ($condition == $fac) ? $headerString : $fac  ; // if facility is empty
		$ssn = ($condition == $patient_info['Person']['ssn_us']) ? $headerNumXml : $patient_info['Person']['ssn_us']  ; // if facility is empty
		$patientPlotNo = ($condition == $patient_info['Person']['plot_no']) ? $headerString : $patient_info['Person']['plot_no']  ; // if streetAddressLine is empty
		$patientCity = ($condition == $patient_info['Person']['city']) ? $headerString : $patient_info['Person']['city']  ; // if city is empty
		$patientState = ($condition == $patient_info['Person']['state']) ? $headerString : $patient_info['Person']['state']  ; // if state is empty
		$patientPostal = ($condition == $patient_info['Person']['pin_code']) ? $headerNumXml : $patient_info['Person']['pin_code']  ; // if pincode is empty
		$patientCountry = ($condition == $patient_info['Country']['name']) ? $headerString : $patient_info['Country']['name']  ; // if country is empty
		$patientTell= ($condition == $patient_info['Person']['home_phone']) ? $headerNumXml :$patient_info['Person']['home_phone']  ; // if phone no is empty
		$dob = ($condition == $dateOfBirth) ? $headerNumXml : $dateOfBirth  ; // if dob is empty
		$nameType = ($condition == $patient_info['Person']['name_type']) ? $headerString : $patient_info['Person']['name_type']  ; // if name type is empty
		$patientFirstName = ($condition == $patient_info['Person']['first_name']) ? $headerString : $patient_info['Person']['first_name']  ; // if First name is empty
		$patientLastName = ($condition == $patient_info['Person']['last_name']) ? $headerString : $patient_info['Person']['last_name']  ; // if last name is empty
		$patientReligion = ($condition == $patient_info['Person']['religion']) ? $headerString : $patient_info['Person']['religion']  ; // if religion is empty
		$race = ($condition == $patient_info['Race']['race_name']) ? $headerString : $patient_info['Race']['race_name']  ; // if race is empty
		$ethnicity = ($condition == $patient_info['Person']['ethnicity']) ? $headerString : $patient_info['Person']['ethnicity']  ; // if ethnicity is empty
		$guardianInitial = ($condition == $guardian_info['Initial']['name']) ? $headerString : $guardian_info['Initial']['name']  ; // if guardian initial is empty
		$guardianRelation = ($condition == $guardian_info['Guardian']['guar_relation']) ? $headerString : $guardian_info['Guardian']['guar_relation']  ; // if guardian relation is empty
		$guardianAddress = ($condition == $guardian_info['Guardian']['guar_address1']) ? $headerString : $guardian_info['Guardian']['guar_address1']  ; // if guardian address is empty
		$guardianCountry = ($condition == $guardian_info['Guardian']['guar_country']) ? $headerString : $guardian_info['Guardian']['guar_country']  ; // if Guardian Country is empty
		$guardianPhoneNo = ($condition == $guardian_info['Guardian']['guar_phone']) ? $headerNumXml : $guardian_info['Guardian']['guar_phone']  ; // if guardian home phone is empty
		$guar_first_name = ($condition == $guardian_info['Guardian']['guar_first_name']) ? $headerString : $guardian_info['Guardian']['guar_first_name']  ; // if guardian middle name is empty
		$guardianLastName = ($condition == $guardian_info['Guardian']['guar_last_name']) ? $headerString : $guardian_info['Guardian']['guar_last_name']  ; // if guardian last name is empty
		$guardianState = ($condition == $guardian_info['Guardian']['guar_state']) ? $headerString : $guardian_info['Guardian']['guar_state']  ; // if guardian state is empty
		$guardianCity = ($condition == $guardian_info['Guardian']['guar_city']) ? $headerString : $guardian_info['Guardian']['guar_city']  ; // if guardian city is empty
		$guardianZip = ($condition == $guardian_info['Guardian']['guar_zip']) ? $headerNumXml : $guardian_info['Guardian']['guar_zip']  ; // if guardian last name is empty
		$phone = ($condition == $phone1) ? $headerNumXml : $phone1  ; // if facility phone is empty
		$address = ($condition == $address1) ? $headerString : $address1  ; // if facility address is empty
		$facilityCity = ($condition == $_SESSION['location']) ? $headerString : $_SESSION['location']  ; // if facility city is empty
		$facilityState = ($condition == $state['State']['name']) ? $headerString : $state['State']['name']  ; // if facility state is empty
		$postal = ($condition == $postal1) ? $headerString : $postal1  ; // if facility zip is empty
		$facilityCountry = ($condition == $country['Country']['name']) ? $headerString : $country['Country']['name']  ; // if facility country is empty
		$doctorFirstName= ($condition == $patientname[0]['User']['first_name']) ? $headerString : $patientname[0]['User']['first_name']  ; // if facility first name is empty
		$doctorLastName = ($condition == $patientname[0]['User']['last_name']) ? $headerString : $patientname[0]['User']['last_name']  ; // if facility last name is empty
		//eof
		
		$docCreatedTime  = strtotime("now") ; 
		 
		$zone = "-0000" ;//$session->read('timezone');
		$createdTime=date ("YmdHis" , $docCreatedTime  );
		 
		$strheader.='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
				<?xml-stylesheet type="text/xsl" href="CDA.xsl"?>
				<ClinicalDocument xmlns="urn:hl7-org:v3" xmlns:cda="urn:hl7-org:v3"
				xmlns:gsd="http://aurora.regenstrief.org/GenericXMLSchema"
				xmlns:sch="http://www.ascc.net/xml/schematron" xmlns:xlink="http://www.w3.org/TR/WD-xlink"
				xmlns:sdtc="urn:hl7-org:sdtc" xmlns:mif="urn:hl7-org:v3/mif"
				xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
				xsi:schemaLocation="urn:hl7-org:v3
				CDA_Schema_Files\infrastructure\cda\CDA_SDTC.xsd">
				<realmCode code="US"/>
				<typeId root="2.16.840.1.113883.1.3" extension="POCD_HD000040"/>
				<templateId root="2.16.840.1.113883.10.20.22.1.1"/>
				<templateId root="2.16.840.1.113883.10.20.22.1.2"/>
				<id extension="CCDA" root="1.1.1.1.1.1.1.1.1"/>
				<code codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC" code="34133-9"
				displayName="Summarization of Episode Note"/>
				<title>'.$facility.': Health Summary</title>';
						$strheader.='<effectiveTime value="'.$createdTime.$zone.'"/>
								<confidentialityCode code="N" codeSystem="2.16.840.1.113883.5.25"/>
								<languageCode code="en-US"/>
								<recordTarget>
								<patientRole>';
		$str='';
		if($consolidated){
			$str.='<id extension="'.$id.'" root="2.16.840.1.113883.4.6"/>';
		}else{
			$str.='<id extension="'.$id.'-'.$note_id.'" root="2.16.840.1.113883.4.6"/>';
		}
		$strheader.=$str ;
		$strheader.='<id extension="'.$ssn.'" root="2.16.840.1.113883.4.1"/>
				<addr use="HP">';
		 
		$addressLine =($patientPlotNo != "")?'<streetAddressLine>'.$patientPlotNo.'</streetAddressLine>':'<streetAddressLine nullFlavor="UNK"></streetAddressLine>' ;
		$cityNode = ($patientCity != "")?'<city>'.$patientCity.'</city>':'<city nullFlavor="UNK"></city>' ;
		$stateNode =($patientState != "")?'<state>'.$patientState.'</state>':'<state nullFlavor="UNK"></state>';
		$postalNode =($patientPostal != "")?'<postalCode>'.$patientPostal.'</postalCode>':'<postalCode nullFlavor="UNK"></postalCode>';
		$countryNode =($patientCountry != "")?'<country>'.$patientCountry.'</country>':'<country nullFlavor="UNK"></country>';
		$strheader.=   $addressLine.$cityNode.$stateNode.$postalNode.$countryNode.'</addr>
		<telecom value="'.$patientTell.'" use="HP"/>';
				
		$medText='';
		//----------gender------------
		if ($patient_info[Person][sex]=="Male")
		{
		 	$genderCode="M";
		}
		elseif ($patient_info[Person][sex]=="Female")
		{
			 $genderCode="F";
		}
		elseif ($patient_info[Person][sex]=="Ambiguous")
		{
			 $genderCode="A";
		}
		elseif ($patient_info[Person][sex]=="Not Applicable")
		{
			 $genderCode="N A";
		}
		elseif ($patient_info[Person][sex]=="Unknown")
		{
			 $genderCode="U";
		}
		else
		{
			 $genderCode="O";
		}

		//------maritail status------

		if ($patient_info[Person][maritail_status]=="A")
		{
		 $codeMaritail="Separated";
		}
		elseif ($patient_info[Person][maritail_status]=="B")
		{
		 $codeMaritail="Unmarried";
		}
		elseif ($patient_info[Person][maritail_status]=="C")
		{
		 $codeMaritail="Common law";
		}
		elseif ($patient_info[Person][maritail_status]=="D")
		{
			$codeMaritail="Divorced";
		}
		elseif ($patient_info[Person][smaritail_statusex]=="E")
		{
		 $codeMaritail="Legally Separated";
		}
		elseif ($patient_info[Person][maritail_status]=="G")
		{
		 $codeMaritail="Living together";
		}
		elseif ($patient_info[Person][maritail_status]=="I")
		{
		 $codeMaritail="Interlocutory";
		}
		elseif ($patient_info[Person][maritail_status]=="M")
		{
		 $codeMaritail="Married";
		}
		elseif ($patient_info[Person][maritail_status]=="N")
		{
		 $codeMaritail="Annulled";
		}
		elseif ($patient_info[Person][maritail_status]=="O")
		{
		 $codeMaritail="Other";
		}
		elseif ($patient_info[Person][maritail_status]=="P")
		{
		 $codeMaritail="Domestic partner";
		}
		elseif ($patient_info[Person][maritail_status]=="R")
		{
		 $codeMaritail="Registered domestic partner";
		}
		elseif ($patient_info[Person][maritail_status]=="S")
		{
		 $codeMaritail="Single";
		}
		elseif ($patient_info[Person][maritail_status]=="T")
		{
		 $codeMaritail="Unreported";
		}
		elseif ($patient_info[Person][maritail_status]=="U")
		{
		 $codeMaritail="Widowed";
		}

		else
		{
		 $codeMaritail="Unknown";
		}
		//----------guardian relation--------
		if ($guardian_info['Guardian']['guar_relation']=="SELF")
		{
		 $displayGuardian="Self";
		}
		elseif ($guardian_info['Guardian']['guar_relation']=="FTH")
		{
		 $displayGuardian="Father";$code='PRN';
		}
		elseif ($guardian_info['Guardian']['guar_relation']=="MTH")
		{
		 $displayGuardian="Mother";$code='PRN';
		}
		elseif ($guardian_info['Guardian']['guar_relation']=="BRO")
		{
		 $displayGuardian="Brother";
		}
		elseif ($guardian_info['Guardian']['guar_relation']=="SIS")
		{
		 $displayGuardian="Sister";
		}
		elseif ($guardian_info['Guardian']['guar_relation']=="FCH")
		{
			$displayGuardian="Foster child";$code='CHLDFOST';
		}
		elseif ($guardian_info['Guardian']['guar_relation']=="GRD")
		{
			$displayGuardian="Guardian";
		}
		elseif ($guardian_info['Guardian']['guar_relation']=="GRP")
		{
			$displayGuardian="Grandparent";$code='GPARNT';
		}
		elseif ($guardian_info['Guardian']['guar_relation']=="PAR")
		{
			$displayGuardian="Parent";
		}
		elseif ($guardian_info['Guardian']['guar_relation']=="SCH")
		{
			$displayGuardian="Stepchild";
		}
		elseif ($guardian_info['Guardian']['guar_relation']=="SIB")
		{
			$displayGuardian="Sibling";$code='SIB ';
		}
		elseif ($guardian_info['Guardian']['guar_relation']=="SPO")
		{
			$displayGuardian="Spouse";$code='SPS';
		}
		elseif ($guardian_info['Guardian']['guar_relation']=="CGV")
		{
		 $displayGuardian="Care giver";
		}
		elseif ($guardian_info['Guardian']['guar_relation']=="OTH")
		{
			$displayGuardian="Other";
		}
		else 
		{
			$displayGuardian="Unrelated Friend";$code='FRND ';
		}

		if(empty($code)) $code = 'FAMMEMB';
		//------------------------
		$medText .= '<patient>

				<name use="'.$nameType.'">
							
				<given>'.$patientFirstName.'</given>

				<family>'.$patientLastName.'</family>
				</name>
				<administrativeGenderCode code="'.$genderCode.'" codeSystem="2.16.840.1.113883.5.1"
				displayName="'.$patient_info['Person']['sex'].'"/>
				<birthTime value="'.$dob.'"/>
				<maritalStatusCode code="'.$patient_info['Person']['maritail_status'].'" displayName="'.$codeMaritail.'" codeSystem="2.16.840.1.113883.5.2"
				codeSystemName="MaritalStatusCode"/>';
			
		$strheader .=  $medText ;
		$strheader .= '<religiousAffiliationCode code="1013"
				displayName="'.$patientReligion.'"
				codeSystemName="HL7 Religious Affiliation "
				codeSystem="2.16.840.1.113883.5.1076"/>
				<raceCode code="2106-3" displayName="'.$race.'" codeSystem="2.16.840.1.113883.6.238"
				codeSystemName="Race and Ethnicity - CDC"/>
				<ethnicGroupCode code="2186-5" displayName="'.$ethnicity.'"
				codeSystem="2.16.840.1.113883.6.238" codeSystemName="Race and Ethnicity - CDC"/>
				<guardian>
				<code code="'.$code.'" displayName="'.$displayGuardian .'"
				codeSystem="2.16.840.1.113883.5.111" codeSystemName="HL7 Role code"/>
				<addr use="HP">';
		$addressGua =($guardianAddress != "")?'<streetAddressLine>'.$guardianAddress.'</streetAddressLine>':'<streetAddressLine nullFlavor="UNK"></streetAddressLine>' ;
		$cityGua = ($guardianCity != "")?'<city>'.$guardianCity.'</city>':'<city nullFlavor="UNK"></city>' ;
		$stateGua =($guardianState != "")?'<state>'.$guardianState.'</state>':'<state nullFlavor="UNK"></state>';
		$postalGua =($guardianZip != "")?'<postalCode>'.$guardianZip.'</postalCode>':'<postalCode nullFlavor="UNK"></postalCode>';
		$countryGua =($guardianCountry != "")?'<country>'.$guardianCountry.'</country>':'<country nullFlavor="UNK"></country>';
		$strheader.= $addressGua.$cityGua.$stateGua.$postalGua.$countryGua.'</addr>';
				
				$strheader.='<telecom value="'.$guardianPhoneNo.'" use="HP"/>
				<guardianPerson>
				<name>
				<given>'.$guar_first_name.'</given>
				<family>'.$guardianLastName.'</family>
				</name>
				</guardianPerson>
				</guardian>
				<birthplace>
				<place>
				<addr>';
		$cityNode = ($patientCity != "")?'<city>'.$patientCity.'</city>':'<city nullFlavor="UNK"></city>' ;
		$stateNode =($patientState != "")?'<state>'.$patientState.'</state>':'<state nullFlavor="UNK"></state>';
		$postalNode =($patientPostal != "")?'<postalCode>'.$patientPostal.'</postalCode>':'<postalCode nullFlavor="UNK"></postalCode>';
		$countryNode =($patientCountry != "")?'<country>'.$patientCountry.'</country>':'<country nullFlavor="UNK"></country>';
		$strheader.=   $cityNode.$stateNode.$postalNode.$countryNode.'</addr>';
				$strheader.='</place>
				</birthplace>
				<languageCommunication>
				<languageCode code="eng"/>
				<modeCode code="ESP" displayName="Expressed spoken"
				codeSystem="2.16.840.1.113883.5.60" codeSystemName="LanguageAbilityMode"/>
				<preferenceInd value="true"/>
				</languageCommunication> 
				</patient>
				<providerOrganization>
				<id root="2.16.840.1.113883.4.6"/>
				<name>'.$facility.'</name>
				<telecom use="WP" value="'.$phone.'"/>
				<addr>';
				$addressFcLine =($address != "")?'<streetAddressLine>'.$address.'</streetAddressLine>':'<streetAddressLine nullFlavor="UNK"></streetAddressLine>' ;
		$cityFcNode = ($facilityCity != "")?'<city>'.$facilityCity.'</city>':'<city nullFlavor="UNK"></city>' ;
		$stateFcNode =($facilityState != "")?'<state>'.$facilityState.'</state>':'<state nullFlavor="UNK"></state>';
		$postalFcNode =($postal != "")?'<postalCode>'.$postal.'</postalCode>':'<postalCode nullFlavor="UNK"></postalCode>';
		$countryFcNode =($facilityCountry != "")?'<country>'.$facilityCountry.'</country>':'<country nullFlavor="UNK"></country>';
		$strheader.=   $addressFcLine.$cityFcNode.$stateFcNode.$postalFcNode.$countryFcNode.'</addr>';		
				
				
				$strheader.='</providerOrganization>
				</patientRole>
				</recordTarget>';
				//if((array_key_exists('1',$permissions) && !empty($permissions) && $check_e2 == false) || $check_e2=="yes" || ($check_e2=="no" && empty($permissions))){
					$strheader .= '<author>
							<time nullFlavor="UNK"/>
							<assignedAuthor>
							<id extension="111111" root="2.16.840.1.113883.4.6"/>
							<addr>';
					$addressFcLine =($address != "")?'<streetAddressLine>'.$address.'</streetAddressLine>':'<streetAddressLine nullFlavor="UNK"></streetAddressLine>' ;
					$cityFcNode = ($facilityCity != "")?'<city>'.$facilityCity.'</city>':'<city nullFlavor="UNK"></city>' ;
					$stateFcNode =($facilityState != "")?'<state>'.$facilityState.'</state>':'<state nullFlavor="UNK"></state>';
					$postalFcNode =($postal != "")?'<postalCode>'.$postal.'</postalCode>':'<postalCode nullFlavor="UNK"></postalCode>';
					$countryFcNode =($facilityCountry != "")?'<country>'.$facilityCountry.'</country>':'<country nullFlavor="UNK"></country>';
					$strheader.=   $addressFcLine.$cityFcNode.$stateFcNode.$postalFcNode.$countryFcNode.'</addr>';
					$strheader .= '<telecom use="WP" value="'.$phone.'"/>
							<assignedPerson>
							<name>
							<prefix>Dr</prefix>
							<given>'.$doctorFirstName.'</given>
									<family>'.$doctorLastName.'</family>
											</name>
											</assignedPerson>
											</assignedAuthor>
											</author>';
				//}
			//	if((array_key_exists('1',$permissions) || $check_e2=="yes") || ($check_e2=="no" && empty($permissions))){
					$strheader .= '<custodian>
							<assignedCustodian>
							<representedCustodianOrganization>
							<id extension="99999999" root="2.16.840.1.113883.4.6"/>
							<name>'.$facility.'</name>
									<telecom value="tel: '.$phone.'" use="WP"/>
											<addr use="WP">';
					$addressFcLine =($address != "")?'<streetAddressLine>'.$address.'</streetAddressLine>':'<streetAddressLine nullFlavor="UNK"></streetAddressLine>' ;
					$cityFcNode = ($facilityCity != "")?'<city>'.$facilityCity.'</city>':'<city nullFlavor="UNK"></city>' ;
					$stateFcNode =($facilityState != "")?'<state>'.$facilityState.'</state>':'<state nullFlavor="UNK"></state>';
					$postalFcNode =($postal != "")?'<postalCode>'.$postal.'</postalCode>':'<postalCode nullFlavor="UNK"></postalCode>';
					$countryFcNode =($facilityCountry != "")?'<country>'.$facilityCountry.'</country>':'<country nullFlavor="UNK"></country>';
					$strheader.=   $addressFcLine.$cityFcNode.$stateFcNode.$postalFcNode.$countryFcNode.'</addr>';
					$strheader .= '</representedCustodianOrganization>
							</assignedCustodian>
							</custodian>';
			//	}
				$strheader .= '<participant typeCode="IND">
				<associatedEntity classCode="PRS">
				<code code="'.$code.'" displayName="'.$displayGuardian .'" codeSystem="2.16.840.1.113883.1.11.19563"
				codeSystemName="Personal Relationship Role Type Value Set"/>
				<addr use="HP">';
		$addressLine =($patientPlotNo != "")?'<streetAddressLine>'.$patientPlotNo.'</streetAddressLine>':'<streetAddressLine nullFlavor="UNK"></streetAddressLine>' ;
		$cityNode = ($patientCity != "")?'<city>'.$patientCity.'</city>':'<city nullFlavor="UNK"></city>' ;
		$stateNode =($patientState != "")?'<state>'.$patientState.'</state>':'<state nullFlavor="UNK"></state>';
		$postalNode =($patientPostal != "")?'<postalCode>'.$patientPostal.'</postalCode>':'<postalCode nullFlavor="UNK"></postalCode>';
		$strheader.=   $addressLine.$cityNode.$stateNode.$postalNode.'</addr>';
				$strheader.='<telecom value="'.$patientTell.'" use="WP"/>
				<associatedPerson>
				<name>
				<prefix>'.$guardianInitial.'</prefix>
				<given>'.$guar_first_name.'</given>
				<family>'.$guardianLastName.'</family>
				</name>
				</associatedPerson>
				</associatedEntity>
				</participant>
				<documentationOf typeCode="DOC">
				<serviceEvent classCode="PCPR">
				<code code="233604007" codeSystem="2.16.840.1.113883.6.96" codeSystemName="SNOMED-CT"
				displayName="'.$problemName.'"/>';
				$strheader.='<effectiveTime>';
				$str3='';
		$date = $this->customStrtoTime($encounters['NoteDiagnosis']['start_dt']);
		$startdt=date ("Ymd" , $date );
		if(!empty($startDate)){
			$str3.='<low value="'.$startdt.'"/>';
		}else{
			$str3.='<low nullFlavor="UNK"/>';

		}
		$date2 = $this->customStrtoTime($encounters['NoteDiagnosis']['end_dt']);//zend_logo_guid();
		$enddt=date ("Ymd" , $date2 );
		if(!empty($endDate)){
			$str3.='<high value="'.$enddt.'"/>';
		}else{
			$str3.='<high nullFlavor="UNK"/>';

		}
		$strheader .=  $str3 ;
		$strheader .='</effectiveTime>';

		foreach($patientname as $key => $doctorDetails){

			$docFirstName = $doctorDetails['User']['first_name'] ;
			$docLastName = $doctorDetails['User']['last_name'] ;
			$strheader .= '';
		}
		$strheader .= '<performer typeCode="PRF">
				<functionCode code="PP" displayName="Primary Care Provider"
					codeSystem="2.16.840.1.113883.12.443" codeSystemName="Provider Role">
					<originalText>Primary Care Provider</originalText>
				</functionCode>
					<time>';
			$str2='';
			$date = $this->customStrtoTime($encounters['NoteDiagnosis']['start_dt']);
			$startdt=date ("Ymd" , $date );
			if(!empty($startDate)){
				$str2.='<low value="'.$startdt.'"/>';
			}else{
				$str2.='<low nullFlavor="UNK"/>';

			}
			$date2 = $this->customStrtoTime($encounters['NoteDiagnosis']['end_dt']);
			$enddt=date ("Ymd" , $date2 );
			if(!empty($endDate)){
				$str2.='<high value="'.$enddt.'"/>';
			}else{
				$str2.='<high nullFlavor="UNK"/>';

			}
			$strheader .=  $str2 ;
			$strheader .='</time>
				<assignedEntity>
					<id extension="'.$facilityid.'" root="2.16.840.1.113883.4.6"/>
					<code code="208D00000X" displayName="'.$facility.'"
						codeSystemName="Provider Codes" codeSystem="2.16.840.1.113883.6.101"/>
					<addr>
						<streetAddressLine>'.$address.'</streetAddressLine>
					<city>'. $facilityCity .'</city>
					<state>'.$facilityState.'</state>
					<postalCode>'.$postal.'</postalCode>
					<country>'.$facilityCountry.'</country>
					</addr>
					<telecom value="'.$phone.'" use="WP"/>
					<assignedPerson>
						<name>
							<prefix>Dr</prefix>
					<given>'.$doctorFirstName.'</given>
					<family>'.$doctorLastName.'</family>
						</name>
					</assignedPerson>
					<representedOrganization>
						<id root="2.16.840.1.113883.19.5.9999.1393"/>
						<name>'.$facility.'</name>
						<telecom value="tel:+1-555-555-5000" use="WP"/>
						<addr>
							<streetAddressLine>'.$address.'</streetAddressLine>
					<city>'. $facilityCity .'</city>
					<state>'.$facilityState.'</state>
					<postalCode>'.$postal.'</postalCode>
					<country>'.$facilityCountry.'</country>
						</addr>
					</representedOrganization>
				</assignedEntity>
			</performer>' ;
			
		$strheader .= '</serviceEvent>
				</documentationOf>
				<componentOf>';
		$str1='';
		if($consolidated){
			$display_name=$problemName;
		}else{
			$display_name=$problemName;
		}
			
		$str1 .= '<encompassingEncounter>';
				if((array_key_exists('3',$permissions) || $check_e2=="yes") || ($check_e2=="no" && empty($permissions))){
			$str1 .= '<id extension="1" root="2.16.840.1.113883.4.6"/>
				<code code="'.$snowCode.'" codeSystem="2.16.840.1.113883.6.96" codeSystemName="SNOMED-CT"
				displayName="'.$display_name.'"/>';
				}
		$strheader.= $str1 ;
		$strheader.='<effectiveTime>';
		$str3='';
		$date = $this->customStrtoTime($encounters['NoteDiagnosis']['start_dt']);
		$startdt=date ("Ymd" , $date );
		if(!empty($startDate)){
			$str3.='<low value="'.$startdt.'"/>';
		}else{
			$str3.='<low nullFlavor="UNK"/>';

		}
		$date2 = $this->customStrtoTime($encounters['NoteDiagnosis']['end_dt']);
		$enddt=date ("Ymd" , $date2 );
		if(!empty($endDate)){
			$str3.='<high value="'.$enddt.'"/>';
		}else{
			$str3.='<high nullFlavor="UNK"/>';

		}
		$strheader .=  $str3 ;
		$strheader .='</effectiveTime>
				<responsibleParty>
				<assignedEntity>
					<id root="2.16.840.1.113883.4.6"/>
					<assignedPerson>
						<name>
							<prefix>Dr</prefix>
							<given>'.$docFirstName.'</given>
						<family>'.$docLastName.'</family>
						</name>
					</assignedPerson>
				</assignedEntity>
			</responsibleParty>
				
						<encounterParticipant typeCode="ATND">
						<assignedEntity>
						<id root="2.16.840.1.113883.4.6"/>
						<assignedPerson>
						<name>
						<prefix>Dr</prefix>
						<given>'.$docFirstName.'</given>
						<family>'.$docLastName.'</family>
												</name>
												</assignedPerson>
												</assignedEntity>
												</encounterParticipant>
												<location >
												<healthCareFacility >
												<id root="2.16.840.1.113883.4.6"/>
												</healthCareFacility>
												</location>
												</encompassingEncounter>
												</componentOf>';
		return $strheader;
	}
	//============body for single record=============
	public function singleCcdaBody($id=null,$uid=null,$note_id=null){
		$mode1 = ClassRegistry::init('Patient');
		$mode1->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patient_uid = $mode1->find('first',array('fields'=>array('patient_id','lookup_name','person_id','admission_id'),'conditions'=>array('Patient.id'=>$id)));
		$person_id=$patient_uid['Patient']['person_id'];
		$get_ccda_header=$this->generateCcdaHeader($id,$note_id,$person_id,$uid);
		$today = date('d-m-Y h:i:s');

		$strbody.='<component>';
		$strbody.='<structuredBody>';
		$allergies=$this->ccdaAllergies($id);
		$encounters=$this->Encounters($id,$note_id);
		$immunization=$this->Immunization($id);
		$medication=$this->Medication($id);
	//	$plan_fore_care=$this->PlanForCare($id,$note_id);
		$discharge_medication=$this->DischargeMedication($id,$uid);
		$referral=$this->singleReferral($id);
		$problem=$this->Problem($id,$uid,$note_id);
	//	$procedure=$this->Procedure($id);
	//	$functional_status=$this->FunctionalStatus($id);
		$results=$this->Results($id,$uid);
		$socialhistory=$this->SocialHistory($id);
		$vital=$this->VitalSign($id,$note_id);
	//	$discharge_inst=$this->DischargeInstructions($id);
		$chiefComplaints=$this->chiefComplaints();

		$strbody1.='  </structuredBody>';
		$strbody1.='</component>';
		$strbody1.='</ClinicalDocument>';
		$body=$get_ccda_header.$strbody.$allergies.$encounters.$immunization.$medication.$plan_fore_care.
		$discharge_medication.$referral.$problem.$procedure.$functional_status.$results.$socialhistory.$vital.$discharge_inst.$strbody1;

		$ourFileName = "files/note_xml/".$patient_uid[Patient]['lookup_name']."_".$patient_uid[Patient]['admission_id']."_".single.".xml";

		$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
		fwrite($ourFileHandle, $body);
		fclose($ourFileHandle);
		return $body;
	}

	//============body for multiple record=============
	public function generateCcdaBody($id=null,$uid=null,$ambulatory=false,$permissions=array(),$check_e2="no"){
			

			
		$mode1 = ClassRegistry::init('Patient');
		$personModel = ClassRegistry::init('Person');
		$mode1->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$data = $mode1->find('first',array('fields'=>array('patient_id','lookup_name','person_id','admission_id'),'conditions'=>array('Patient.id'=>$id)));
		$person_id=$data['Patient']['person_id'];

		$getLastEncounter = $mode1->find('first',array('conditions'=>array('person_id'=>$person_id),'order'=>'Patient.id DESC'));
		//$get_ccda_header=$this->generateCcdaHeader($getLastEncounter['Patient']['id'],null,$person_id,true,$permissions,$check_e2); // work arround last patient id
		$get_ccda_header=$this->generateCcdaHeader($id,null,$person_id,true,$permissions,$check_e2); // work arround last patient id
		$strbody.='<component>';
		$strbody.='<structuredBody>'; 

	 	$allergies=$this->ccdaAllergies($id,$data['Patient']['person_id']);
		/* $encounters=$this->Encounters($id,null,true);*/
		
		if(array_key_exists('4',$permissions) || empty($permissions) || $check_e2=="yes"){
			$immunization=$this->Immunization($id,$person_id);
		}
		$medication=$this->Medication($id,$person_id);
	//	$plan_fore_care=$this->PlanForCare($id,null,true,$person_id); // forth is the person id
		$plan=$this->Plan($id,$uid);
		$problem=$this->Problem($id,$uid,$note_id,true);
	//	$procedure=$this->Procedure($id);
    //	$functional_status=$this->FunctionalStatus($id);
		$results=$this->Results($id,$uid);
		$socialhistory=$this->SocialHistory($id,$person_id);
		$vital=$this->VitalSign($id,$note_id,true,$person_id);
		
	 	//if(empty($permissions) && $check_e2=="no"){
		if(array_key_exists('3',$permissions) || empty($permissions) || $check_e2=="yes"){
			$chiefComplaints=$this->chiefComplaints($id); //reason of visit 
		}
		
		//if(array_key_exists('8',$permissions) || $check_e2=="yes" || (empty($permissions) && $ambulatory)){
		if($ambulatory){  //temp cond for b7
			$referralToOtherProviders=$this->referralToOtherProviders($id);
		} 
		 
		$products=array('0'=>'Common MU Data set','1'=>'Provider\'s name and office contact information','2'=>'Date and location of visit',
				'3'=>'Reason for visit','4'=>'Immunizations and/or medications administered during the visit','5'=>'Diagnostic tests pending',
				'6'=>'Clinical Instructions','7'=>'Future appointments','8'=>'Referrals to other providers',
				'9'=>'Future scheduled tests','10'=>'Recommended patient decision aids');
		
		
		if(!$ambulatory){
			$discharge_medication=$this->DischargeMedication($id,$uid); 
		}
		if((empty($permissions) && $check_e2=="no")){
		//	$discharge_inst=$this->dischargeInstructions($id);
		}
		if(array_key_exists('6',$permissions) || $check_e2=="yes" ){
	//		$discharge_inst= $this->clinicalInstructions($id) ; 
		}
		if(empty($permissions) && $check_e2=="no"){
			$discharge_medication=$this->DischargeMedication($id,$uid); //clinical instruction for e2 criteria
		}
		
		if((empty($permissions) && $ambulatory) ||  $check_e2=="yes"){
			//$referral=$this->singleReferral($id);
		}

		if(array_key_exists('5',$permissions) ||   $check_e2=="yes"){
			$diagnosticTestsPending=$this->diagnosticTestsPending($id);
		} 
		if(array_key_exists('9',$permissions) || $check_e2=="yes"){
	 		$futureScheduledTests=$this->futureScheduledTests($id);
		}
		if(array_key_exists('10',$permissions) || $check_e2=="yes"){
	 	//	$recommendedPatient=$this->recommendedPatient($id);
		}
		if(array_key_exists('7',$permissions) || $check_e2=="yes"){
	 		$futureAppointment =  $this->futureAppointment($id);
		}  

		$strbody1.='  </structuredBody>';
		$strbody1.='</component>';
		$strbody1.='</ClinicalDocument>';
			
		$body=$get_ccda_header.$strbody. $allergies.$encounters. $immunization. $medication. $plan_fore_care.$plan.
		$discharge_medication.$referral.$problem.$procedure.$functional_status. $results. $socialhistory. $vital. $discharge_inst.$diagnosticTestsPending.$futureScheduledTests.$futureAppointment.$chiefComplaints.$referralToOtherProviders.$recommendedPatient.$strbody1;
		//temp commented 
		if($check_e2=='yes'){
			$ourFileName = "files/note_xml/e2_".$data['Patient']['lookup_name']."_".$data['Patient']['admission_id'].".xml";
		}else if($check_e2 =='no' && !empty($permissions)){
			$ourFileName = "files/note_xml/patient_e2_".$data['Patient']['lookup_name']."_".$data['Patient']['admission_id'].".xml";
		}else{
			$ourFileName = "files/note_xml/".$data['Patient']['lookup_name']."_".$data['Patient']['admission_id'].".xml";
		}
			$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file"); 
		
		fwrite($ourFileHandle, $body);
		fclose($ourFileHandle);
		return $body;
	}
	//================Allergies =========

	public function ccdaAllergies($id=null,$person_id=null){
		$NewCropAllergies = ClassRegistry::init('NewCropAllergies');
		$get_allergies=$NewCropAllergies->find('all',array('conditions'=>array('NewCropAllergies.patient_id'=>$person_id,'NewCropAllergies.is_deleted'=>0)));
	
		$strallergies.='<component>';
		$strallergies.='<section>
				<templateId
				root="2.16.840.1.113883.10.20.22.2.6.1"/>
				<!-- Alerts section template -->
				<code
				code="48765-2"
				codeSystem="2.16.840.1.113883.6.1"/>
				<title>ALLERGIES, ADVERSE REACTIONS, ALERTS</title>
				<text>
				<table
				border="1"
				width="100%">
				<thead>
				<tr>
				<th>Code</th>
				<th>CodeSystem</th>
				<th>Substance</th>
				<th>Reaction</th>
				<th>Severity</th>
				<th>Status</th>
				</tr>
				</thead>
				<tbody>';
		$medText='';
		$i=1;
		 
		foreach ($get_allergies as  $Val){
			
			if($Val['NewCropAllergies']['is_ccda']==1){
				$reaction = ($condition == $Val['NewCropAllergies']['reaction']) ? "" : $Val['NewCropAllergies']['reaction']; // if Reaction is empty
			}else{
				$reaction = ($condition == $Val['NewCropAllergies']['note']) ? "" : $Val['NewCropAllergies']['note']; // if Reaction is empty
			}
			
			$code = ($condition == $Val['NewCropAllergies']['rxnorm']) ? "": $Val['NewCropAllergies']['rxnorm']  ; // if code is empty
			$substance1 = ($condition == $Val['NewCropAllergies']['name']) ? "" : $Val['NewCropAllergies']['name']; // if Substance is empty
			$table = $this->get_html_translation_table_CP1252();
			$substance = strtr($substance1,$table) ;
			$severity = ($condition == $Val['NewCropAllergies']['AllergySeverityName']) ? "" : $Val['NewCropAllergies']['AllergySeverityName']; // if Severity is empty
			$status = ( $Val['NewCropAllergies']['status']=="A") ? "Active" : "Inactive"; // if Status is empty
			$allergiesId = ($condition == $Val['NewCropAllergies']['allergies_id']) ? "" : $Val['NewCropAllergies']['allergies_id']; // if allergies is empty

			$codeXml = ($condition == $Val['NewCropAllergies']['rxnorm']) ? $this->numXml: $Val['NewCropAllergies']['rxnorm']  ; // if code is empty
			$substanceXml1 = ($condition == $Val['NewCropAllergies']['name']) ? $this->string : $Val['NewCropAllergies']['name']; // if Substance is empty
			$table = $this->get_html_translation_table_CP1252();
			$substanceXml = strtr($substanceXml1,$table) ;
			$reactionXml = ($condition == $Val['NewCropAllergies']['note']) ? $this->string : $Val['NewCropAllergies']['note']; // if Reaction is empty
			$severityXml = ($condition == $Val['NewCropAllergies']['AllergySeverityName']) ? $this->string : $Val['NewCropAllergies']['AllergySeverityName']; // if Severity is empty
			$allergiesIdXml = ($condition == $Val['NewCropAllergies']['allergies_id']) ? $this->string : $Val['NewCropAllergies']['allergies_id']; // if allergies is empty


			if(!empty($Val['NewCropAllergies']['name'])){
				if(!empty($Val['NewCropAllergies']['rxnorm'])){

					$startingTime = $this->customStrtoTime($Val['NewCropAllergies']['start_date']);
					$startdt=$this->customStrtoDate($startingTime, "Ymd");

					$endTime = $this->customStrtoTime($Val['NewCropAllergies']['end_date']);
					$enddt=$this->customStrtoDate($endTime, "Ymd");
					$medText .= '<tr>
							<td>'.$code.'</td>
									<td>RxNorm</td>
									<td><content ID="product'.$i.'">'.$substance.'</content></td>
											<td><content ID="reaction'.$i.'">'.$reaction.'</content></td>
													<td><content ID="severity'.$i.'">'.$severity.'</content></td>
															<td>'.$status.'</td>
																	</tr>';


					if(!empty($Val['NewCropAllergies']['start_date'])){
						$startDateForAllergies ='<low value="'.$startdt.'"/>';
					}else{
						$startDateForAllergies ='<low nullFlavor="UNK"/>';
					}
					if(!empty($Val['NewCropAllergies']['end_date'])){
						$endDateForAllergies ='<high value="'.$enddt.'"/>';
					}else{
						$endDateForAllergies ='<high nullFlavor="UNK"/>';
					}

				}else{
					$medText .= '<tr>
							<td></td>
							<td>RxNorm</td>
							<td><content ID="product'.$i.'">'.$substance.'</content></td>
									<td><content ID="reaction'.$i.'">'.$reaction.'</content></td>
											<td><content ID="severity'.$i.'">'.$severity.'</content></td>
													<td>'.$status.'</td>
															</tr>';

					if(!empty($Val['NewCropAllergies']['start_date'])){
						$startDateForAllergies ='<low value="'.$startdt.'"/>';
					}else{
						$startDateForAllergies ='<low nullFlavor="UNK"/>';
					}
					if(!empty($Val['NewCropAllergies']['end_date'])){
						$endDateForAllergies ='<high value="'.$enddt.'"/>';
					}else{
						$endDateForAllergies ='<high nullFlavor="UNK"/>';
					}



				}
				/*else{
				 $medText .= '<tr>
				<td></td>
				<td></td>
				<td><content ID="product"></content></td>
				<td><content ID="reaction"></content></td>
				<td><content ID="severity"></content></td>
				<td></td>
				</tr>'; */

				//}
					
				$allergyXml .= '<entry typeCode="DRIV">
						<act classCode="ACT" moodCode="EVN">
						<templateId root="2.16.840.1.113883.10.20.22.4.30"/>
						<!-- ** Allergy problem act ** -->
						<id root="36e3e930-7b14-11db-9fe1-0800200c9a66" extension="1000"/>
						<code code="48765-2" codeSystem="2.16.840.1.113883.6.1"
						codeSystemName="LOINC"
						displayName="Allergies, adverse reactions, alerts"/>
						<statusCode code="completed"/>
						<effectiveTime nullFlavor="UNK">
						'.$startDateForAllergies.'
								'.$endDateForAllergies.'
										</effectiveTime>
										<entryRelationship typeCode="SUBJ">
										<observation classCode="OBS" moodCode="EVN">
										<!-- allergy observation template -->
										<templateId root="2.16.840.1.113883.10.20.22.4.7"/>
										<id root="4adc1020-7b14-11db-9fe1-0800200c9a66" extension="1001"/>
										<code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4"/>
										<statusCode code="completed"/>
										<effectiveTime>
										'.$startDateForAllergies.'
												'.$endDateForAllergies.'
														</effectiveTime>
														<value xsi:type="CD" code="419511003"
														displayName="Propensity to adverse reaction to drug"
														codeSystem="2.16.840.1.113883.6.96"
														codeSystemName="SNOMED CT">
														<originalText>
														<reference value="#reaction'.$i.'"/>
																</originalText>
																</value>
																<participant typeCode="CSM">
																<participantRole classCode="MANU">
																<playingEntity classCode="MMAT">
																<code code="'.$codeXml.'"
																displayName="'.$substanceXml.'"
																		codeSystem="2.16.840.1.113883.6.88"
																		codeSystemName="RxNorm">
																		<originalText>
																		<reference value="#product'.$i.'"/>
																				</originalText>
																				</code>
																				</playingEntity>
																				</participantRole>
																				</participant>
																				<entryRelationship typeCode="SUBJ" inversionInd="true">
																				<observation classCode="OBS" moodCode="EVN">
																				<templateId root="2.16.840.1.113883.10.20.22.4.28"/>
																				<!-- Allergy status observation template -->
																				<code code="33999-4" codeSystem="2.16.840.1.113883.6.1"
																				codeSystemName="LOINC" displayName="Status"/>
																				<statusCode code="completed"/>
																				<value xsi:type="CE" code="73425007"
																				codeSystem="2.16.840.1.113883.6.96"
																				displayName="'.$status.'"/>
																						</observation>
																						</entryRelationship>
																						<entryRelationship typeCode="MFST" inversionInd="true">
																						<observation classCode="OBS" moodCode="EVN">
																						<templateId root="2.16.840.1.113883.10.20.22.4.9"/>
																						<!-- Reaction observation template -->
																						<id root="4adc1020-7b14-11db-9fe1-0800200c9a64"
																						extension="1002"/>
																						<code nullFlavor="NA"/>
																						<text>
																						<reference value="#reaction'.$i.'"/>
																								</text>
																								<statusCode code="completed"/>
																								<effectiveTime>
																								<low nullFlavor="UNK"/>
																								<high nullFlavor="UNK"/>
																								</effectiveTime>
																								<value xsi:type="CD" code="'.$allergiesIdXml.'"
																										codeSystem="2.16.840.1.113883.6.96"
																										displayName="'.$reactionXml.'"/>
																												</observation>
																												</entryRelationship>
																												<entryRelationship typeCode="SUBJ" inversionInd="true">
																												<observation classCode="OBS" moodCode="EVN">
																												<templateId root="2.16.840.1.113883.10.20.22.4.8"/>
																												<!-- ** Severity observation template ** -->
																												<code xsi:type="CE" code="SEV"
																												displayName="Severity Observation"
																												codeSystem="2.16.840.1.113883.5.4"
																												codeSystemName="ActCode"/>
																												<text>
																												<reference value="#severity'.$i.'"/>
																														</text>
																														<statusCode code="completed"/>
																														<value xsi:type="CD" code="371924009"
																														displayName="'.$severityXml.'"
																																codeSystem="2.16.840.1.113883.6.96"
																																codeSystemName="SNOMED CT"/>
																																</observation>
																																</entryRelationship>
																																</observation>
																																</entryRelationship>
																																</act>
																																</entry>';
			}
			$i++;
		}
		if(trim($medText) == ""){
			$strallergies .='<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
		}else{
			//	echo "here"; debug($medText);exit;
			$strallergies .=  $medText;
		}
		$strallergies .='  </tbody>
				</table>
				</text>';
		$strallergies .=  $allergyXml;
		$strallergies .= '</section>';
		$strallergies.=' </component>';
		//print_r($strallergies); exit;

		return $strallergies;
	}


	//=============end

	//patient_id
	public function Immunization($id=null,$person_id=null){

		$immunization = ClassRegistry::init('Immunization');
		$immunization->bindModel(array(
				'belongsTo' => array(
						'PhvsVaccinesMvx' =>array('foreignKey'=>false,
								'conditions'=>array('PhvsVaccinesMvx.id = Immunization.manufacture_name')),
						'PhvsMeasureOfUnit' =>array('foreignKey'=>false,
								'conditions'=>array('PhvsMeasureOfUnit.id = Immunization.phvs_unitofmeasure_id')),
						'PhvsAdminsRoute' =>array('foreignKey'=>false,
								'conditions'=>array('PhvsAdminsRoute.id = Immunization.route')),
						'Imunization' =>array('foreignKey'=>false,
								'conditions'=>array('Imunization.id = Immunization.vaccine_type'))) ,
				'hasOne'=>array(
						'Patient' =>array('foreignKey'=>false,
								'conditions'=>array('Patient.id = Immunization.patient_id'))
				)));

		$immunization_details=$immunization->find('all',array('fields'=>array('Imunization.cpt_description','presented_date','PhvsVaccinesMvx.description','amount',
				'PhvsMeasureOfUnit.value_code','PhvsAdminsRoute.description','PhvsAdminsRoute.code_system','Imunization.value_code','Imunization.code_system'),
				'conditions'=>array( 'Immunization.is_deleted'=>0,'Patient.person_id'=>$person_id)));

			
		$strimmu.=' <component>
				<section>
				<templateId root="2.16.840.1.113883.10.20.22.2.2.1"/>
				<!-- Entries Required -->
				<!--  ********  Immunizations section template   ******** -->
				<code code="11369-6" codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC"
				displayName="History of immunizations"/>
				<title>IMMUNIZATIONS</title>
				<text>
				<content ID="immunSect"/>
				<table border="1" width="100%">
				<thead>
				<tr>
				<th>Vaccine</th>
				<th>Date</th>
				<th>Status</th>
				</tr>
				</thead>
				<tbody>';
		$medText1='';
		$i=1;
		foreach ($immunization_details as  $details){
			$vaccine_type= (!$details['Imunization']['cpt_description']) ? $this->string :$details['Imunization']['cpt_description']; // if Height is empty
			$amount= (!$details['Immunization']['amount']) ? $this->numXml :$details['Immunization']['amount']; // if value is empty
			$unit= (!$details['PhvsMeasureOfUnit']['value_code']) ? $this->string :$details['PhvsMeasureOfUnit']['value_code']; // if unit is empty
			$manufacturerOrganization= (!$details['PhvsVaccinesMvx']['description']) ? $this->string :$details['PhvsVaccinesMvx']['description']; // if manufacturer Organization is empty
			$originalText= (!$details['Imunization']['cpt_description']) ? $this->string :$details['Imunization']['cpt_description']; // if  originalText is empty
			$route= (!$details['PhvsAdminsRoute']['description']) ? $this->string :$details['PhvsAdminsRoute']['description']; // if route is empty
			$codeSystem= (!$details['PhvsAdminsRoute']['code_system']) ? $this->string :$details['PhvsAdminsRoute']['code_system']; // if route is empty
			$code= (!$details['Imunization']['value_code']) ? $this->string :$details['Imunization']['value_code']; // if code is empty
			$code_system= (!$details['Imunization']['code_system']) ? $this->string :$details['Imunization']['code_system']; // if code_system is empty

			if(!empty($details['Imunization']['cpt_description'])){
				if(!empty($details['Immunization']['presented_date']) && $details['Immunization']['presented_date'] != "0000-00-00"){
					
					$immuTimestamp = $this->customStrtoTime($details['Immunization']['presented_date']);
					$dt=$this->customStrtoDate($immuTimestamp, "d F Y");
					
					$medText1 .= '<tr>
							<td>
							<content ID="immun'.$i.'"/>'.$vaccine_type.'</td>
									<td>'.$dt.'</td>
											<td>Completed</td>
											</tr>';


					$immuTimestamp = $this->customStrtoTime($details['Immunization']['presented_date']);
					$dt=$this->customStrtoDate($immuTimestamp, "Ymd");
					
					$effectiveTimeForImmu='<effectiveTime xsi:type="IVL_TS" value="'.$dt.'"/>';

				}else{
					$medText1 .= '<tr>
							<td>
							<content ID="immun'.$i.'"/>'.$vaccine_type.'</td>
									<td></td>
									<td>Completed</td>
									</tr>';
					$effectiveTimeForImmu='	<effectiveTime nullFlavor="UNK"/>';
				}
			}
			$immuXml .='<entry typeCode="DRIV">
					<substanceAdministration classCode="SBADM" moodCode="EVN"
					negationInd="false">
					<templateId root="2.16.840.1.113883.10.20.22.4.52"/>
					<!--  ********   Immunization activity template    ******** -->
					<id root="e6f1ba43-c0ed-4b9b-9f12-f435d8ad8f92" extension="3000"/>
					<text>
					<reference value="#immun'.$i.'"/>
							</text>
							<statusCode code="completed"/>
							'.$effectiveTimeForImmu.'
									<routeCode code="C28161" codeSystem="2.16.840.1.113883.3.26.1.1"
									codeSystemName="'.$codeSystem.'"
											displayName="'.$route.'"/>
													<doseQuantity value="'.$amount.'" unit="'.$unit.'"/>
															<consumable>
															<manufacturedProduct classCode="MANU">
															<templateId root="2.16.840.1.113883.10.20.22.4.54"/>
															<!--  ********   Immunization Medication Information    ******** -->
															<manufacturedMaterial>
															<code code="'.$code.'" codeSystem="2.16.840.1.113883.12.292"
																	displayName="'.$originalText.'"
																			codeSystemName="'.$code_system.'">
																					<originalText>'.$originalText.'</originalText>
																							</code>
																							</manufacturedMaterial>
																							<manufacturerOrganization>
																							<name>'.$manufacturerOrganization.'</name>
																									</manufacturerOrganization>
																									</manufacturedProduct>
																									</consumable>
																									<entryRelationship typeCode="SUBJ" inversionInd="true">
																									<act classCode="ACT" moodCode="INT">
																									<templateId root="2.16.840.1.113883.10.20.22.4.20"/>
																									<!-- ** Instructions Template ** -->
																									<code xsi:type="CE" code="171044003"
																									codeSystem="2.16.840.1.113883.6.96"
																									displayName="immunization education"/>
																									<text>
																									<reference value="#immunSect"/>Injection site reactions
																									(e.g., pain, redness, swelling, hard lump), muscle/joint
																									aches, or fever may occur. Ask your doctor whether you
																									should take a fever/pain reducer (e.g., acetaminophen) to
																									help treat these symptoms. Nausea and vomiting may also
																									occur. If any of these effects persist or worsen, tell your
																									doctor or pharmacist promptly.</text>
																									<statusCode code="completed"/>
																									</act>
																									</entryRelationship>
																									</substanceAdministration>
																									</entry>';
			$i++;
		}if(trim($medText1) == ""){
			$strimmu .='<tr><td></td><td></td><td></td></tr>';
		}else{
			$strimmu .=  $medText1 ;
		}
		$strimmu .= ' </tbody></table></text>';
		$strimmu .=  $immuXml ;
		$strimmu .='</section>';
		$strimmu .='</component>';
		return 	$strimmu;
	}

	//patient_id
	function FunctionalStatus($id=null){

		$cognitive = ClassRegistry::init('CognitiveFunction');

		$cognitiveData=$cognitive->find('all',array('fields'=>array('cog_name','cog_date','cog_snomed_code','is_cognitive'),'conditions'=>array('CognitiveFunction.patient_id'=>$id)));

		$function.='<component>';
		$function.='<section>
				<templateId root="2.16.840.1.113883.10.20.22.2.14"/>
				<code code="47420-5" codeSystem="2.16.840.1.113883.6.1"/>
				<title>FUNCTIONAL STATUS</title>
				<text>
				<table border="1" width="100%">
				<thead>
				<tr>
				<th>Functional Condition</th>
				<th>Effective Dates</th>
				<th>Condition Status</th>
				</tr>
				</thead>
				<tbody>';
		$medText1='';
		$i=1;
		foreach($cognitiveData as $key => $display){
			$cognitiveName= ($condition == $display['CognitiveFunction']['cog_name']) ? $this->string : $display['CognitiveFunction']['cog_name']; // if Cognitive name is empty
			$cognitiveDate= ($condition == $display['CognitiveFunction']['cog_date']) ? $this->numXml : $display['CognitiveFunction']['cog_date']; // if Cognitive date is empty
			$cognitiveSnomed= ($condition == $display['CognitiveFunction']['cog_snomed_code']) ? $this->numXml : $display['CognitiveFunction']['cog_snomed_code']; // if Cognitive snomed is empty

			if(!empty($display['CognitiveFunction']['cog_name'])){
					
				$timestamp = $this->customStrtoTime($display['CognitiveFunction']['cog_date']);
				$dt=$this->customStrtoDate($timestamp, "Ymd");
				
				$timestampp = $this->customStrtoTime($display['CognitiveFunction']['cog_date']);
				$tdDate=$this->customStrtoDate($timestampp, "d F Y");
					
				if(!empty($cognitiveDate)){



					$medText1 .= '<tr>
							<td><content ID="fs'.$i.'">'.$cognitiveName.'</content></td>
									<td>'.$tdDate.'</td>
											<td>Active</td>
											</tr>';
					$i++;
				}else{
					$medText1 .= '<tr>
							<td><content ID="fs'.$i.'">'.$functionalCondition.'</content></td>
									<td></td>
									<td>Active</td>
									</tr>';
					$i++;
				}
			}
		}if(trim($medText1) == ""){
			$function .='<tr><td></td><td></td><td></td></tr>';
		}else{
			$function .=  $medText1 ;
		}
		$function .= ' </tbody>	</table></text>';

		$medText2='';
		$extensionCount=8000;
		$valueCount=1;

			
		//--empty conditiopn----
		/* $functionalCondition= ($condition == $detail['disability']) ? $this->string : $detail['Diagnosis']['disability']; // if Functional Condition is empty
			$effectiveDates= ( $condition == $detail['Diagnosis']['effective_date']) ? $this->numXml : $detail['Diagnosis']['effective_date']; // if Effective Dates is empty */
		foreach($cognitiveData as $key => $display){
			$cognitiveName= ($condition == $display['CognitiveFunction']['cog_name']) ? $this->string : $display['CognitiveFunction']['cog_name']; // if Cognitive name is empty
			$cognitiveDate= ($condition == $display['CognitiveFunction']['cog_date']) ? $this->numXml : $display['CognitiveFunction']['cog_date']; // if Cognitive date is empty
			$cognitiveSnomed= ($condition == $display['CognitiveFunction']['cog_snomed_code']) ? $this->numXml : $display['CognitiveFunction']['cog_snomed_code']; // if Cognitive snomed is empty
			//eof
			if(!empty($display['CognitiveFunction']['cog_name'])){
				$timestamp = $this->customStrtoTime($display['CognitiveFunction']['cog_date']);
				$dt=$this->customStrtoDate($timestamp, "Y");
				if($display['CognitiveFunction']['is_cognitive']==1){
					$displayName = "Cognitive Function Finding";
					$displayNameCode = '409586006';
				}else{
					$displayName = 'Complaints' ;
					$displayNameCode = '373930000';
				}
				$medText2 .='	<entry typeCode="DRIV">
						<observation classCode="OBS" moodCode="EVN">
						<!-- Cognitive Status Problem observation template -->
						<templateId root="2.16.840.1.113883.10.20.22.4.73"/>
						<id root="ab1791b0-5c71-11db-b0de-0800200c9a66" extension="'.$extensionCount.'"/>
								<code xsi:type="CE" code="'.$displayNameCode.'" codeSystem="2.16.840.1.113883.6.96"
										displayName="'.$displayName.'"/>
												<text>
												<reference value="#fs'.$valueCount.'"/>
														</text>
														<statusCode code="completed"/>';
					
				$str='';
				$str.='<effectiveTime>';
				if(!empty($cognitiveDate)){
					$str.='	<low value="'.$dt.'"/>';
				}else{
					$str.='	<low nullFlavor="UNK"/>';
				}
				$medText2 .=  $str ;
				$medText2 .='<high nullFlavor="UNK"/>
						</effectiveTime>
						<value xsi:type="CD" code="'.$cognitiveSnomed.'" codeSystem="2.16.840.1.113883.6.96"
								displayName="'.$cognitiveName.'"/>
										</observation>
										</entry>';
				$extensionCount++;
				$valueCount++;
					
			}
		}
		$function .=  $medText2 ;
		$function .='</section>';
		$function .=' </component>';
		return $function;
	}


	public function Encounters($id=null,$note_id=null,$consolidated=false){
			
		$session = new cakeSession();
		$user = ClassRegistry::init('User');
		$patient = ClassRegistry::init('Patient');
		$mode4 = ClassRegistry::init('Country');
		$mode5 = ClassRegistry::init('State');
		$mode6 = ClassRegistry::init('City');
		$noteDiagnosis = ClassRegistry::init('NoteDiagnosis');

		$patientname = $patient->find('first',array('fields'=>array('lookup_name','patient_id','doctor_id'),'conditions'=>array('Patient.id'=>$id)));
		$doctor=$user->find('first',array('fields'=>array('initial_id','first_name','last_name'),'conditions'=>array('User.id'=>$patientname['Patient']['doctor_id'])));
		$country=$mode4->find('first',array('fields'=>array('name'),'conditions'=>array('Country.id'=>$_SESSION['Auth']['User']['country_id'])));
		$state=$mode5->find('first',array('fields'=>array('name'),'conditions'=>array('State.id'=>$_SESSION['Auth']['User']['state_id'])));
		//$city=$mode6->find('first',array('fields'=>array('name'),'conditions'=>array('City.id'=>$_SESSION['Auth']['User']['city_id'])));
		$address=($_SESSION['Auth']['User']['address1']);
		$postal=($_SESSION['Auth']['User']['zipcode']);
		$facility=$session->read('facility');

		if($consolidated){
			//echo 'last encounter data';
			$encounters=$noteDiagnosis->find('first',array('fields'=>array('diagnoses_name','created','start_dt'),
					'order'=>array('NoteDiagnosis.id DESC'),'limit'=>1,
					'conditions'=>array('NoteDiagnosis.patient_id'=>$id)));
		}else{
			//echo'sing';
			$encounters=$noteDiagnosis->find('first',array('fields'=>array('diagnoses_name','created','start_dt'),
					'conditions'=>array('NoteDiagnosis.note_id'=>$note_id,'NoteDiagnosis.patient_id'=>$id)));
		}
		//------empty condition-----
		$encounter1 = ($condition == $encounters['NoteDiagnosis']['diagnoses_name']) ? $this->string: $encounters['NoteDiagnosis']['diagnoses_name']  ; // if Encounter is empty
		$performer = ($condition == $doctor['User']['first_name'].$doctor['User']['last_name']) ? $this->string : $doctor['User']['first_name'].$doctor['User']['last_name']; // if Performer is empty
		$location = ($condition == "$facility") ? $this->string: "$facility"; // if Location is empty
		
		$address = ($condition == $address) ? $headerString : $address  ; // if facility address is empty
		$facilityCity = ($condition == $_SESSION['location']) ? $headerString : $_SESSION['location']  ; // if facility city is empty
		$facilityState = ($condition == $state['State']['name']) ? $headerString : $state['State']['name']  ; // if facility state is empty
		$postal = ($condition == $postal) ? $headerString : $postal  ; // if facility zip is empty
		$facilityCountry = ($condition == $country['Country']['name']) ? $headerString : $country['Country']['name']  ; // if facility country is empty
		

		//eof
		$encounter.='<component>
				<section>
				<templateId root="2.16.840.1.113883.10.20.22.2.22.1"/>
				<!-- Encounters Section - required entries -->
				<code code="46240-8" codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC"
				displayName="History of encounters"/>
				<title>ENCOUNTERS</title>
				<text>
				<table border="1" width="100%">
				<thead>
				<tr>
				<th>Encounter</th>
				<th>Performer</th>
				<th>Location</th>
				<th>Date</th>
				</tr>
				</thead>
				<tbody>';
		$str='';
		if(!empty($encounters['NoteDiagnosis']['diagnoses_name'])){
			if(!empty($encounters['NoteDiagnosis']['start_dt'])){
				$dateForTd = $this->customStrtoTime($encounters['NoteDiagnosis']['start_dt']);
				$tdDate=$this->customStrtoDate($dateForTd, "d F Y");
				
				$date = $this->customStrtoTime($encounters['NoteDiagnosis']['start_dt']);
				$dt=$this->customStrtoDate($date, "Ymd");
				
				$str.='<tr>
						<td>
						<content ID="Encounter1"/> '.$encounter1.'</td>
								<td>Dr '.$performer.'</td>
										<td>'.$location.'</td>
												<td>'.$tdDate.'</td>
														</tr>';
				if(!empty($encounters['NoteDiagnosis']['created'])){
					$startDateForEncounter ='<low value="'.$dt.'"/>';
				}else{
					$startDateForEncounter ='<low nullFlavor="UNK"/>';
				}
				if(!empty($encounters['NoteDiagnosis']['created'])){
					$effectiveDateForEncounter ='<effectiveTime value="'.$dt.'"/>';
				}else{
					$effectiveDateForEncounter ='<effectiveTime nullFlavor="UNK"/>';
				}

			}else{
				$str.='<tr>
						<td>
						<content ID="Encounter1"/> '.$encounter1.'</td>
								<td>Dr '.$performer.'</td>
										<td>'.$location.'</td>
												<td></td>
												</tr>';
				$startDateForEncounter ='<low nullFlavor="UNK"/>';
				$effectiveDateForEncounter ='<effectiveTime nullFlavor="UNK"/>';
			}


			$xmlEncounter .='<entry typeCode="DRIV">
					<encounter classCode="ENC" moodCode="EVN">
					<templateId root="2.16.840.1.113883.10.20.22.4.49"/>
					<!-- Encounter Activities -->
					<!--  ********  Encounter activity template   ******** -->
					<id root="2a620155-9d11-439e-92b3-5d9815ff4de8" extension="2000"/>
					<code code="99222" displayName="InPatient Admission"
					codeSystemName="CPT" codeSystem="2.16.840.1.113883.6.12"
					codeSystemVersion="4">
					<originalText>Mild Fever<reference value="#Encounter1"/>
					</originalText>
					</code>'.$effectiveDateForEncounter.'<performer>
							<assignedEntity>
							<id root="2a620155-9d11-439e-92a3-5d9815ff4de8" extension="2001"/>
							<code code="59058001" codeSystem="2.16.840.1.113883.6.96"
							codeSystemName="SNOMED CT" displayName="General Physician"/>
							</assignedEntity>
							</performer>
							<participant typeCode="LOC">
							<participantRole classCode="SDLOC">
							<templateId root="2.16.840.1.113883.10.20.22.4.32"/>
							<!-- Service Delivery Location template -->
							<code code="1160-1" codeSystem="2.16.840.1.113883.6.259"
							codeSystemName="HealthcareServiceLocation"
							displayName="Urgent Care Center"/>
							<addr>';
							$addressFcLine =($address != "")?'<streetAddressLine>'.$address.'</streetAddressLine>':'<streetAddressLine nullFlavor="UNK"></streetAddressLine>' ;
		$cityFcNode = ($facilityCity != "")?'<city>'.$facilityCity.'</city>':'<city nullFlavor="UNK"></city>' ;
		$stateFcNode =($facilityState != "")?'<state>'.$facilityState.'</state>':'<state nullFlavor="UNK"></state>';
		$postalFcNode =($postal != "")?'<postalCode>'.$postal.'</postalCode>':'<postalCode nullFlavor="UNK"></postalCode>';
		$countryFcNode =($facilityCountry != "")?'<country>'.$facilityCountry.'</country>':'<country nullFlavor="UNK"></country>';
		$xmlEncounter.=   $addressFcLine.$cityFcNode.$stateFcNode.$postalFcNode.$countryFcNode.'</addr>';		
																	
																	$xmlEncounter .='<telecom nullFlavor="UNK"/>
																	<playingEntity classCode="PLC">
																	<name>'.$location.'</name>
																			</playingEntity>
																			</participantRole>
																			</participant>
																			<entryRelationship typeCode="RSON">
																			<observation classCode="OBS" moodCode="EVN">
																			<templateId root="2.16.840.1.113883.10.20.22.4.19"/>
																			<id root="db734647-fc99-424c-a864-7e3cda82e703"
																			extension="45665"/>
																			<code code="404684003" displayName="Finding"
																			codeSystem="2.16.840.1.113883.6.96"
																			codeSystemName="SNOMED CT"/>
																			<statusCode code="completed"/>
																			<effectiveTime>'.$startDateForEncounter.'</effectiveTime>
																					<value xsi:type="CD" code="233604007" displayName="'.$encounter1.'"
																							codeSystem="2.16.840.1.113883.6.96"/>
																							</observation>
																							</entryRelationship>
																							<entryRelationship typeCode="SUBJ" inversionInd="false">
																							<act classCode="ACT" moodCode="EVN">
																							<!--Encounter diagnosis act -->
																							<templateId root="2.16.840.1.113883.10.20.22.4.80"/>
																							<id root="5a784260-6856-4f38-9638-80c751aff2fb" extension="2002"/>
																							<code xsi:type="CE" code="29308-4"
																							codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC"
																							displayName="ENCOUNTER DIAGNOSIS"/>
																							<statusCode code="active"/>
																							<effectiveTime>'.$startDateForEncounter.'</effectiveTime>
																									<entryRelationship typeCode="SUBJ" inversionInd="false">
																									<observation classCode="OBS" moodCode="EVN"
																									negationInd="false">
																									<templateId root="2.16.840.1.113883.10.20.22.4.4"/>
																									<!-- Problem Observation -->
																									<id root="ab1791b0-5c71-11db-b0de-0800200c9a66"
																									extension="2003"/>
																									<code code="409586006"
																									codeSystem="2.16.840.1.113883.6.96"
																									displayName="Complaint"/>
																									<statusCode code="completed"/>
																									<effectiveTime>'.$startDateForEncounter.'</effectiveTime>
																											<value xsi:type="CD" code="233604007"
																											codeSystem="2.16.840.1.113883.6.96"
																											displayName="'.$encounter1.'"/>
																													</observation>
																													</entryRelationship>
																													</act>
																													</entryRelationship>
																													</encounter>
																													</entry>';
		}
		if(trim($str) == ""){
			$encounter .='<tr><td></td><td></td><td></td><td></td></tr>';
		}else{
			$encounter.=$str;
		}
		$encounter.='</tbody>
				</table>
				</text>';
		$encounter .=  $xmlEncounter ;
		$encounter .='</section>
				</component>';
		return $encounter;

	}
	public function Plan($id=null,$patientUid=null){
		
			$patient = ClassRegistry::init('Patient');
			$note = ClassRegistry::init('Note');
			$patientIdArray = $patient->find('list',array('fields'=>array('id'),'conditions'=>array('Patient.patient_id'=>$patientUid)));
			$planData=$note->find('all',array('fields'=>array('plan','create_time','patient_id'),'conditions'=>array('Note.patient_id'=>$patientIdArray),'order'=>array('Note.id Desc')));
			$plan.='<component>';
			$plan.='<section>
		
				<templateId root="2.16.840.1.113883.10.20.22.2.10"/>
				<!-- Entries Required -->
				<code code="18776-5" codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC" displayName="Treatment plan"/>
				<title>CARE PLAN</title>
				<text>
				<table
				border="1"
				width="100%">
				<thead>
				<tr>
				<th>Planned Activity</th>
				<th>Planned Date</th>
				</tr>
				</thead>
				<tbody>';
				
			if(!empty($planData)){
				foreach ($planData as $labKey => $planValue){
					if(!empty($planValue['Note']['plan'])){
						$immuTimestamp = $this->customStrtoTime($planValue['Note']['create_time']);
						$pendingDate=$this->customStrtoDate($immuTimestamp, "d F Y");
						$plan .= '<tr><td>'.$planValue['Note']['plan'].'</td>
									  <td>'.$pendingDate.'</td>
								  </tr>' ;
					}
				}
			}else{
				$plan .= '<tr><td></td><td></td></tr>';
			}
			$plan.=	'</tbody>
				</table>
				</text>
				</section>
				</component>';
			return $plan;
		
		
	}


	public function PlanForCare($id=null,$note_id=null,$consolidated=false,$person_id){

		$plannedProblem = ClassRegistry::init('PlannedProblem');
		if($consolidated){
			$plannedProblem->bindModel(array(
					'belongsTo' => array(
							'Patient' =>array('foreignKey'=>false,
									'conditions'=>array('Patient.id = PlannedProblem.patient_id'),'group'=>'patient_id'),
					)));
			
			$result= $plannedProblem->find('all',array('fields'=> array('snomed_description','instruction','sct_concept_id','plan_date'),
					'conditions'=>array('Patient.person_id'=>$person_id,'PlannedProblem.is_deleted'=>0),'group'=>array('PlannedProblem.sct_concept_id'))); //bring all the encounters with single patient entry
		}else{
			
			$result= $plannedProblem->find('first',array('fields'=> array('snomed_description','instruction','sct_concept_id','plan_date'),
					'conditions'=>array('PlannedProblem.id'=>$note_id,'PlannedProblem.is_deleted'=>0),'group'=>array('PlannedProblem.sct_concept_id'),'order'=>'PlannedProblem.id Desc'));
		}

		$strplan = '' ;
		$strplan.=' <component>';
		$strplan.=' <section>
				<templateId
				root="2.16.840.1.113883.10.20.22.2.10"/>
				<!--  **** Plan of Care section template  **** -->
				<code code="18776-5" codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC" displayName="Treatment plan"/>
				<title>CARE PLAN</title>
				<text>
				<table
				border="1"
				width="100%">
				<thead>
				<tr>
				<th>Planned Activity</th>
				<th>Planned Date</th>
				</tr>
				</thead>
				<tbody>';
				//<th>Planned Date</th>
		$medText='';
		foreach ($result as $singlekey => $singleVal){
			if($consolidated){
				$data= $singleVal['PlannedProblem'] ;
			}else{
				$data= $singleVal ;
			}
			$carePlanText = (!$data['snomed_description']) ? "" :$data['snomed_description']; // if Activity is empty
			$carePlanXml = (!$data['snomed_description']) ? $this->string  :$data['snomed_description']; // if Activity is empty

			$instructionText = (!$data['instruction']) ? "":$data['instruction']; // if Activity is empty
			$instructionXml = (!$data['instruction']) ? $this->string  :$data['instruction']; // if Activity is empty
			$snowMedCode = (!$data['sct_concept_id']) ? $this->string  :$data['sct_concept_id']; // if Activity is empty

			if(!empty($data['snomed_description']) || !empty($data['instruction'])){
				if(!empty($data['plan_date'])){
					
					$dateForPlann = $this->customStrtoTime($data['plan_date']);
					$planCareDate=$this->customStrtoDate($dateForPlann, "Ymd");
					
					$dateForPlan = $this->customStrtoTime($data['plan_date']);
					$planCareTdDate=$this->customStrtoDate($dateForPlan, "d F Y");
					
					$goalText = ($carePlanText)?"Goal: ".nl2br($carePlanText):"" ;
					$medText .= '<tr><td>'.$goalText.'<br/>' ;
					$medText .= ($instructionText)?"Instruction: ".nl2br($instructionText):"" ;
					$medText .= '</td>';
					$medText .= '<td>'.$planCareTdDate.'</td></tr>';
					$centerValue='	<center value="'.$planCareDate.'"/>';
				}else{
					$goalText = ($carePlanText)?"Goal: ".nl2br($carePlanText):"" ;
					$medText .= '<tr><td>'.$goalText.'<br/>' ;
					$medText .= ($instructionText)?"Instruction: ".nl2br($instructionText):"" ;
					$medText .= '</td><td></td></tr>';
					$centerValue='	<center nullFlavor="UNK"/>';
				}
			}

			$craeForPlanXml.='<entry>
					<encounter moodCode="INT" classCode="ENC">
					<templateId root="2.16.840.1.113883.10.20.22.4.40"/>
					<!--  ****  Plan of Care Activity Encounter template  **** -->
					<id root="9a6d1bac-17d3-4195-89a4-1121bc809b4d" extension="5000"/>
					<code code="'.$snowMedCode.'" displayName="'.$carePlanXml.'"
							codeSystemName="SNOMED-CT" codeSystem="2.16.840.1.113883.6.12"/>
							<effectiveTime>'.$centerValue.'</effectiveTime>
									<entryRelationship typeCode="SUBJ" inversionInd="true">
									<act classCode="ACT" moodCode="INT">
									<templateId root="2.16.840.1.113883.10.20.22.4.20"/>
									<!-- ** Instructions Template ** -->
									<code xsi:type="CE" code="409073007"
									codeSystem="2.16.840.1.113883.6.96"
									displayName="instruction"/>
									<text>'.nl2br($instructionXml).'</text>
											<statusCode code="completed"/>
											</act>
											</entryRelationship>
											</encounter>
											</entry>';

			/* <entry typeCode="DRIV">
			 <observation classCode="OBS" moodCode="RQO">
			<!-- ** Plan of care activity observation ** -->
			<templateId root="2.16.840.1.113883.10.20.22.4.44"/>
			<id root="9a6d1bac-17d3-4195-89a4-1121bc809b4a"/>
			<code code="73761001" codeSystem="2.16.840.1.113883.6.96"
			codeSystemName="SNOMED CT" displayName="'.$activity.'"/>
			<statusCode code="new"/>
			<effectiveTime>
			'.$centerValue.'</effectiveTime>
			</observation>
			</entry><entry>
			<act moodCode="RQO" classCode="ACT">
			<!-- ** Plan of care activity act ** -->
			<templateId root="2.16.840.1.113883.10.20.22.4.39"/>
			<id root="9a6d1bac-17d3-4195-89a4-1121bc809a5c"/>
			<code code="73761001" codeSystem="2.16.840.1.113883.6.96"
			codeSystemName="SNOMED CT" displayName="'.$activity.'"/>
			<statusCode code="new"/>
			<effectiveTime>
			'.$centerValue.'
			</effectiveTime>
			</act>
			</entry><entry>
			<encounter moodCode="INT" classCode="ENC">
			<!-- ** Plan of care activity encounter ** -->
			<templateId root="2.16.840.1.113883.10.20.22.4.40"/>
			<id root="9a6d1bac-17d3-4195-89a4-1121bc809b4d"/>
			<code code="73761001" codeSystem="2.16.840.1.113883.6.96"
			codeSystemName="SNOMED CT" displayName="'.$activity.'"/>
			<statusCode code="new"/>
			<effectiveTime>
			'.$centerValue.'
			</effectiveTime>
			</encounter>
			</entry>
			<entry>
			<procedure moodCode="RQO" classCode="PROC">
			<!-- ** Plan of care activity procedure ** -->
			<templateId root="2.16.840.1.113883.10.20.22.4.41"/>
			<id root="9a6d1bac-17d3-4195-89c4-1121bc809b5a"/>
			<code code="73761001" codeSystem="2.16.840.1.113883.6.96"
			codeSystemName="SNOMED CT" displayName="'.$activity.'"/>
			<statusCode code="new"/>
			<effectiveTime>
			'.$centerValue.'
			</effectiveTime>
			</procedure>
			</entry>  */
		}if(trim($medText) == ""){
			$strplan .='<tr><td></td><td></td></tr>';
		}else{
			$strplan .=  $medText ;
		}
		$strplan .='</tbody></table></text>';
		$strplan .= $craeForPlanXml ;
		$strplan .='</section>';
		$strplan .='</component>';

		return $strplan;
	}


	//======== medication========
	public function Medication($id=null,$person_id=null){
		$session = new cakeSession();
		$mode1 = ClassRegistry::init('Note');
		$mode2 = ClassRegistry::init('Patient');
		$mode3 = ClassRegistry::init('Person');
		$mode4 = ClassRegistry::init('Country');
		$mode5 = ClassRegistry::init('State');
		$mode6 = ClassRegistry::init('City');
		$mode7 = ClassRegistry::init('User');
		$noteDiagnosis = ClassRegistry::init('NoteDiagnosis');
		$NewCropPrescription = ClassRegistry::init('NewCropPrescription');


		$mode2->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));

		$patientname = $mode2->find('first',array('fields'=>array('lookup_name','person_id','doctor_id'),'conditions'=>array('Patient.id'=>$id)));
		$patient_info= $mode3->find('first',array('fields'=>array('first_name','middle_name','last_name','sex','maritail_status','dob','suffix1',
				'religion','patient_uid','ssn_us','city','country','state','pin_code','home_phone','race','ethnicity','patient_owner','plot_no'),
				'conditions'=>array('Person.patient_uid'=>$patientname['Patient']['patient_id'])));

		$country=$mode4->find('first',array('fields'=>array('name'),'conditions'=>array('Country.id'=>$_SESSION[Auth][User][country_id])));
		$state=$mode5->find('first',array('fields'=>array('name'),'conditions'=>array('State.id'=>$_SESSION[Auth][User][state_id])));
		//$city=$mode6->find('first',array('fields'=>array('name'),'conditions'=>array('City.id'=>$_SESSION[Auth][User][city_id])));

		$doctor=$mode7->find('first',array('fields'=>array('initial_id','first_name','last_name'),'conditions'=>array('User.id'=>$patientname['Patient']['doctor_id'])));

		$address=($_SESSION[Auth][User][address1]);
		$postal=($_SESSION[Auth][User][zipcode]);
		$facility=$session->read('facility');

		$encounters=$noteDiagnosis->find('first',array('fields'=>array('diagnoses_name','end_dt'),
				'order'=>array('NoteDiagnosis.id DESC'),'limit'=>1,
				'conditions'=>array('NoteDiagnosis.patient_id'=>$id)));

		$get_medication=$NewCropPrescription->find('all',array('conditions'=>array('NewCropPrescription.patient_id'=>$person_id,
				'NewCropPrescription.is_discharge_medication'=>0,'NewCropPrescription.is_deleted'=>0)));
		 
		$strmedication.=' <component>';
		$strmedication.='  <section>
				<templateId
				root="2.16.840.1.113883.10.20.22.2.1.1"/>
				<code
				code="10160-0"
				codeSystem="2.16.840.1.113883.6.1"
				codeSystemName="LOINC"
				displayName="HISTORY OF MEDICATION USE"/>
				<title>MEDICATIONS</title>
				<text>
				<table
				border="1"
				width="100%">
				<thead>
				<tr>
				<th>Code</th>
				<th>CodeSystem</th>
				<th>Medication</th>
				<th>Directions</th>
				<th>Start Date</th>
				<th>Status</th>
				<th>Fill Instructions</th>
				</tr>
				</thead>
				<tbody>';

		$medText='';
		$i=1;
		$table = $this->get_html_translation_table_CP1252();
		
		foreach($get_medication as $value){

			//--empty conditiopn----
			$medication = $value['NewCropPrescription']['description']  ;
			if(!empty($medication)){
				$medication = strtr($medication,$table) ;
			}
			$doseValue = (!$value['NewCropPrescription']['dose']) ? $this->numXml: ($value['NewCropPrescription']['dose'])  ; // if code is empty
			$doseUnit = (!$value['NewCropPrescription']['dose_unit']) ? $this->string: ($value['NewCropPrescription']['dose_unit'])  ; // if code is empty
			$displayName= (!$medication) ? $this->string: ($medication)  ; // if code is empty
			$code = (!$value['NewCropPrescription']['rxnorm']) ? "" : $value['NewCropPrescription']['rxnorm']  ; // if code is empty
			$codeXml = (!$value['NewCropPrescription']['rxnorm']) ? $this->numXml: $value['NewCropPrescription']['rxnorm']  ; // if code is empty 
			$medication = (!$medication) ? $this->string : $medication; // if Medication is empty 
			
			$status = ($value['NewCropPrescription']['archive']=="N") ? "Active" : "Inactive"  ; // if Status is empty
			$statusResult=(!$status)? $this->string : $status;
			$representedOrganization= ( !"$facility") ? $this->string  : $facility ; // if representedOrganization is empty
			$route=( !$value['NewCropPrescription']['route']) ? $this->string : $value['NewCropPrescription']['route']; // if route is empty
			$problem= (!$value['NoteDiagnosis']['diagnoses_name']) ? $this->string : $value['NoteDiagnosis']['diagnoses_name']; // if diagnoses_name is empty
			//	$problemDate = (!$value['NoteDiagnosis']['end_dt']) ? $this->numXml : $value['NoteDiagnosis']['end_dt']; // if end_dt is empty
			$frequency = (!$value['NewCropPrescription']['frequency']) ? $this->string :  $value['NewCropPrescription']['frequency']; // if frequency is empty
			$dose = (!$value['NewCropPrescription']['dose']) ? $this->numXml: $value['NewCropPrescription']['dose'] ; // if dose is empty

			$directions =  $medication." ".$value['NewCropPrescription']['dose']." ".$value['NewCropPrescription']['route']." ".$value['NewCropPrescription']['frequency']; // if Directions is empty
			//eof
			if(!empty($medication)){
				if(!empty($value['NewCropPrescription']['archive']) && $value['NewCropPrescription']['archive'] == 'N'){
					
					if(!empty($value['NewCropPrescription']['date_of_prescription'])){
						$val_date = explode('T',$value['NewCropPrescription']['date_of_prescription']);
						
						$mediTimeStamp = $this->customStrtoTime($val_date[0]);
						$tdDate=$this->customStrtoDate($mediTimeStamp,"d F Y");
						
						
						$mediTimeStampp = $this->customStrtoTime($val_date[0]);
						$dt=$this->customStrtoDate($mediTimeStampp,"Ymd");

						$endTimestamp = $this->customStrtoTime($value['NoteDiagnosis']['end_dt']);
						$endDate=$this->customStrtoDate($endTimestamp,"Ymd");
							
						$medText .= '<tr>
								<th>'.$code.'</th>
										<th>RxNorm</th>
										<td><content ID="Med'.$i.'">'.stripslashes($medication).'</content></td>
												<td>'.stripslashes($directions).'</td>
														<td>'.$tdDate.'</td>
																<td>'.$statusResult.'</td>
																		<td>Generic Substitition Allowed </td>
																		</tr>';


						if(!empty($value['NewCropPrescription']['created'])){
							$startDateForMedic='<low value="'.$dt.'"/>';
						}else{
							$startDateForMedic='low nullFlavor="UNK"/>';
						}
						if(!empty($value['NoteDiagnosis']['end_dt'])){
							$endDateForMedi='<high value="'.$endDate.'"/>';
						}else{
							$endDateForMedi='<high nullFlavor="UNK"/>';
						}
					}else{
						$medText .= '<tr>
								<th>'.$code.'</th>
										<th>RxNome</th>
										<td><content ID="Med'.$i.'">'.$medication.'</content></td>
												<td>'.$directions.'</td>
														<td></td>
														<td>'.$statusResult.'</td>
																<td>Generic Substitition Allowed </td>
																</tr>';


						if(!empty($value['NewCropPrescription']['created'])){
							$startDateForMedic='<low value="'.$dt.'"/>';
						}else{
							$startDateForMedic='low nullFlavor="UNK"/>';
						}
						if(!empty($value['NoteDiagnosis']['end_dt'])){
							$endDateForMedi='<high value="'.$endDate.'"/>';
						}else{
							$endDateForMedi='<high nullFlavor="UNK"/>';
						}
					}

					$mediXml .= '<entry typeCode="DRIV">
							<substanceAdministration classCode="SBADM" moodCode="EVN">
							<templateId root="2.16.840.1.113883.10.20.22.4.16"/>
							<!-- ** MEDICATION ACTIVITY -->
							<id root="cdbd33f0-6cde-11db-9fe1-0800200c9a66" extension="4000"/>
							<text>
							<reference value="#Med'.$i.'"/>'.$medication.'</text>
									<statusCode code="completed"/>
									<effectiveTime xsi:type="IVL_TS">
									'.$startDateForMedic.'
											'.$endDateForMedi.'
													</effectiveTime>
													<effectiveTime xsi:type="PIVL_TS" institutionSpecified="true"
													operator="A">
													<period value="'.$dose.'" unit="d"/>
															</effectiveTime>
															<routeCode code="C38288" codeSystem="2.16.840.1.113883.3.26.1.1"
															codeSystemName="NCI Thesaurus" displayName="'.$route.'"/>
																	<doseQuantity value="'.$doseValue.'" unit="'.$doseUnit.'"/>
																			<administrationUnitCode code="C42744" displayName="'.$route.'"
																					codeSystem="2.16.840.1.113883.3.26.1.1"
																					codeSystemName="NCI Thesaurus"/>
																					<consumable>
																					<manufacturedProduct classCode="MANU">
																					<templateId root="2.16.840.1.113883.10.20.22.4.23"/>
																					<id root="2a620155-9d11-439e-92b3-5d9815ff4ee8" extension="4001"/>
																					<manufacturedMaterial>
																					<code code="'.$codeXml.'" codeSystem="2.16.840.1.113883.6.88"
																							displayName="'.$medication.'">
																									<originalText>
																									<reference value="#Med'.$i.'"/>
																											</originalText>

																											</code>
																											</manufacturedMaterial>
																											<manufacturerOrganization>
																											<name nullFlavor="UNK"/>
																											</manufacturerOrganization>
																											</manufacturedProduct>
																											</consumable>
																											<performer>
																											<assignedEntity>
																											<id nullFlavor="NI"/>
																											<addr nullFlavor="UNK"/>
																											<telecom nullFlavor="UNK"/>
																											<representedOrganization>
																											<id root="2.16.840.1.113883.19.5.9999.1393"/>
																											<name>'.$representedOrganization.'</name>
																													<telecom nullFlavor="UNK"/>
																													<addr nullFlavor="UNK"/>
																													</representedOrganization>
																													</assignedEntity>
																													</performer>
																													<participant typeCode="CSM">
																													<participantRole classCode="MANU">
																													<templateId root="2.16.840.1.113883.10.20.22.4.24"/>
																													<code code="412307009" displayName="drug vehicle"
																													codeSystem="2.16.840.1.113883.6.96"/>
																													<playingEntity classCode="MMAT">
																													<code code="10311" displayName="'.$displayName.'"
																															codeSystem="2.16.840.1.113883.6.88"
																															codeSystemName="RxNorm"/>
																															<name>'.$displayName.'</name>
																																	</playingEntity>
																																	</participantRole>
																																	</participant>
																																	<entryRelationship typeCode="RSON">';
																																	$mediXml .='<observation classCode="OBS" moodCode="EVN">
																																	<templateId root="2.16.840.1.113883.10.20.22.4.19"/>
																																	<id root="db734647-fc99-424c-a864-7e3cda82e703"
																																	extension="45665"/>
																																	<code code="404684003" displayName="Finding"
																																	codeSystem="2.16.840.1.113883.6.96"
																																	codeSystemName="SNOMED CT"/>
																																	<statusCode code="completed"/>
																																	<effectiveTime>
																																	'.$startDateForMedic.'
																																			'.$endDateForMedi.'
																																					</effectiveTime>
																																					<value xsi:type="CD" code="233604007" displayName="sss"
																																					codeSystem="2.16.840.1.113883.6.96"/>  
																																					</observation>
																																					</entryRelationship>
																																					</substanceAdministration>
																																					</entry>';
				}
			}
			$i++;
		}if(trim($medText) == ""){
			$strmedication .='<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
		}else{
			$strmedication .=  $medText;
		}
		$strmedication.='  </tbody></table></text>';
		$strmedication .=  $mediXml;
		$strmedication.='</section>';
		$strmedication.='</component>'; //echo $strmedication;// exit;
		return $strmedication;
	}
	//===========end==========


	public function dischargeInstructions($id=null){  //-----------for single Discharge Instructions-----
		$session = new cakeSession();
		$billing = ClassRegistry::init('DischargeSummary');
		$patientModel = ClassRegistry::init('Patient');
		$dischargeInstructions = $billing->find('first',array('fields'=>array('care_plan')
				,'conditions'=>array('DischargeSummary.patient_id'=>$id)));
		 
		$instruction =$dischargeInstructions['DischargeSummary']['care_plan'] ;
	 	$replaceStr= strip_tags($instruction);
	 	$table = $this->get_html_translation_table_CP1252();
	 	$replaceStr = strtr($replaceStr,$table) ;
	 	$replaceStr= nl2br($replaceStr);
	 	
		//$strReplace=str_replace("<p>","<paragraph>",$instruction);
		// str_replace("</p>","</paragraph>",$strReplace);
	 	$patientModel->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patientType  =  $patientModel->find('first',array('fields'=>array('admission_type'),'conditions'=>array('id'=>$id)));
		
		if($patientType['Patient']['admission_type'] == "IPD"){
			$instructionLabel = "Hospital Discharge Instructions"; 
			$secondLabel = "HOSPITAL DISCHARGE INSTRUCTIONS " ;
		}else{
			$instructionLabel = "Clinical Instructions" ;
			$secondLabel = "CLINICAL INSTRUCTIONS " ;
		}
		$strdis.='<component>
				<section>
				<templateId root="2.16.840.1.113883.10.20.22.2.41"/>
				<code code="8653-8" codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC"
				displayName="HOSPITAL DISCHARGE INSTRUCTIONS"/>
				<title>'.$secondLabel.'</title>
				<text>
				<table border="1" width="100%">
				<thead>
				<tr>
				<th>'.$instructionLabel.'</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>'.$replaceStr.'</td>
				</tr>
				</tbody>
				</table>
				</text>
						</section>
						</component>';
		return $strdis ;
			
	}//----------eof ------

	public function clinicalInstructions($id=null){  //-----------for single Discharge Instructions-----
		$session = new cakeSession();
		$billing = ClassRegistry::init('DischargeSummary');
		$patientModel = ClassRegistry::init('Patient');
		$dischargeInstructions = $billing->find('first',array('fields'=>array('care_plan')
				,'conditions'=>array('DischargeSummary.patient_id'=>$id)));
			
		$instruction =$dischargeInstructions['DischargeSummary']['care_plan'] ;
		$replaceStr= strip_tags($instruction);
		$table = $this->get_html_translation_table_CP1252();
		$replaceStr = strtr($replaceStr,$table) ;
		$replaceStr= nl2br($replaceStr);
		 
		//$strReplace=str_replace("<p>","<paragraph>",$instruction);
		// str_replace("</p>","</paragraph>",$strReplace);
		$patientModel->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patientType  =  $patientModel->find('first',array('fields'=>array('admission_type'),'conditions'=>array('id'=>$id)));
	
		 
		$instructionLabel = "Clinical Instructions" ;
		$secondLabel = "CLINICAL INSTRUCTIONS " ;
		 
		$strdis.='<component>
				<section>
				<templateId root="2.16.840.1.113883.10.20.22.2.45"/>
				<code code="69730-0" codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC"
				displayName="CLINICAL INSTRUCTIONS"/>
				<title>'.$secondLabel.'</title>
				<text>
				<table border="1" width="100%">
				<thead>
				<tr>
				<th>'.$instructionLabel.'</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>'.$replaceStr.'</td>
				</tr>
				</tbody>
				</table>
				</text>';
		$strdis .= '<entry>
					<act classCode="ACT" moodCode="EVN">
					  <id root="MDHT" extension="1349140423"/>
					  <code code="181147282"/> 
					  <effectiveTime>
						<low nullFlavor="UNK"/>
						<high nullFlavor="UNK" />
					  </effectiveTime>
					</act>
				  </entry>' ;
		
				$strdis .='</section>
						</component>';
		return $strdis ;
			
	}//----------eof ------

	//-----discharge medication --
	public function DischargeMedication($id=null,$uid=null){
		$session = new cakeSession();
		$mode1 = ClassRegistry::init('Note');
		$mode2 = ClassRegistry::init('Patient');
		$mode3 = ClassRegistry::init('Person');
		$mode4 = ClassRegistry::init('Country');
		$mode5 = ClassRegistry::init('State');
		$mode6 = ClassRegistry::init('City');
		$mode7 = ClassRegistry::init('User');
		$newCropPrescription = ClassRegistry::init('NewCropPrescription');
		$noteDiagnosis = ClassRegistry::init('NoteDiagnosis');

		/* $dischargeDrug->bindModel(array(
		 'belongsTo' => array( 'DischargeSummary' =>array('foreignKey'=>true),
		 ))); */

		$mode2->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patientname = $mode2->find('first',array('fields'=>array('lookup_name','patient_id','doctor_id'),'conditions'=>array('Patient.id'=>$id)));

		$patient_info= $mode3->find('first',array('fields'=>array('first_name','middle_name','last_name','sex','maritail_status','dob',
				'suffix1','religion','patient_uid','ssn_us','city','country','state','pin_code','home_phone','race','ethnicity','patient_owner',
				'plot_no'),'conditions'=>array('Person.patient_uid'=>$patientname[Patient][patient_id])));

		$country=$mode4->find('first',array('fields'=>array('name'),'conditions'=>array('Country.id'=>$_SESSION[Auth][User][country_id])));
		$state=$mode5->find('first',array('fields'=>array('name'),'conditions'=>array('State.id'=>$_SESSION[Auth][User][state_id])));
		//$city=$mode6->find('first',array('fields'=>array('name'),'conditions'=>array('City.id'=>$_SESSION[Auth][User][city_id])));
		$doctor=$mode7->find('first',array('fields'=>array('initial_id','first_name','last_name'),'conditions'=>array('User.id'=>$patientname[Patient][doctor_id])));

		$address=($_SESSION[Auth][User][address1]);
		$postal=($_SESSION[Auth][User][zipcode]);
		$facility=$session->read('facility');

		$get_medication=$newCropPrescription->find('all',array('conditions'=>array('NewCropPrescription.patient_uniqueid'=>$id,
				'NewCropPrescription.is_discharge_medication'=>1,'NewCropPrescription.is_deleted'=>0)));
	//	pr($get_medication);exit;
		$encounters=$noteDiagnosis->find('first',array('fields'=>array('diagnoses_name','end_dt'),
				'order'=>array('NoteDiagnosis.id DESC'),
				'conditions'=>array('NoteDiagnosis.patient_id'=>$id)));

		$strdischarge.='<component>';
		$strdischarge.='<section>

				<templateId root="2.16.840.1.113883.10.20.22.2.11"/>
				<!-- Entries Required -->
				<!-- Hospital Discharge Summary templateId -->
				<code code="10183-2" codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC" displayName="HOSPITAL DISCHARGE MEDICATIONS"/>
				<title>HOSPITAL DISCHARGE MEDICATIONS</title>

				<text>
				<table border="1" width="100%">
				<thead>
				<tr>
				<th>Medication</th>
				<th>Directions</th>
				<th>Start Date</th>
				<th>Status</th>
				<th>Indications</th>
				<th>Fill Instructions</th>
				</tr>
				</thead>
				<tbody>';


		$medText='';
		$i=1;
		$table = $this->get_html_translation_table_CP1252();
		foreach($get_medication as $value){

			//--empty conditiopn----

			$medication = ($condition == $value['NewCropPrescription']['description']) ? $this->string : $value['NewCropPrescription']['description']; // if Medication is empty
		 	$medication = strtr($medication,$table) ; 
		 	$directions = ($condition == $medication.$value['NewCropPrescription']['dose'].$value['NewCropPrescription']['route'].$value['NewCropPrescription']['frequency']) ?
			$this->string : $medication.$value['NewCropPrescription']['dose'].$value['NewCropPrescription']['route'].$value['NewCropPrescription']['frequency']; // if Directions is empty
			$startDate = ($condition == $value['NewCropPrescription']['date_of_prescription']) ? $this->numXml : $value['NewCropPrescription']['date_of_prescription']; // if date is empty
			$indications = ($condition == $value['NewCropPrescription']['route']) ? $this->string: $value['NewCropPrescription']['route']  ; // if Indications is empty
			$status = ($value['NewCropPrescription']['archive']=="N") ? "Active" : "InActive"  ; // if Status is empty
			$statusResult=($condition == $status)? $this->string : $status;
  			//eof
  			
			if($medication != ''){
				if(!empty($value['NewCropPrescription']['archive']) && $value['NewCropPrescription']['archive'] == 'N'){
					$val_date = explode("T",$value['NewCropPrescription']['date_of_prescription']) ;
					
					$timestamp = $this->customStrtoTime($val_date[0]);
					$tdDate=$this->customStrtoDate($timestamp,"d F Y");
					
					$timestamp = $this->customStrtoTime($splittedDate);
					$dt=$this->customStrtoDate($timestamp,"Ymd");

					$medText .= '<tr>
							<td><content ID="DM'.$i.'">'.$medication.'</content></td>
									<td>'.$directions.'</td>
											<td>'.$tdDate.'</td>
													<td>'.$statusResult.'</td>
															<td>'.$indications.'</td>
																	<td>Generic Substitition Allowed </td>
																	</tr>';
					$i++;
				}
			}
		}
		if(trim($medText) == ""){
			$strdischarge .='<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
		}else{
			$strdischarge .=  $medText;
		}
		$strdischarge.='</tbody>
				</table>
				</text>';
		$medText1='';
		$i=1;
		foreach($get_medication as $value){
			if(!empty($value['NewCropPrescription']['archive']) && $value['NewCropPrescription']['archive'] == 'N'){
				$doseValue = (!$value['NewCropPrescription']['dose']) ? $this->numXml: ($value['NewCropPrescription']['dose'])  ; // if code is empty
			$doseUnit = (!$value['NewCropPrescription']['dose_unit']) ? $this->string: ($value['NewCropPrescription']['dose_unit'])  ; // if code is empty
			$displayName= (!$medication) ? $this->string: ($medication)  ; // if code is empty
				//	debug($val_unit);exit;

				//--empty conditiopn----
				$medication = ($condition == $medication) ? $this->string : $medication; // if Medication is empty
				$directions = ($condition == $medication.$value['NewCropPrescription']['dose'].$value['NewCropPrescription']['route'].$value['NewCropPrescription']['frequency']) ?
				$this->string : $medication.$value['NewCropPrescription']['dose'].$value['NewCropPrescription']['route'].$value['NewCropPrescription']['frequency']; // if Directions is empty

				$indications = ($condition == $value['NewCropPrescription']['route']) ? $this->string: $value['NewCropPrescription']['route']  ; // if Indications is empty
				$representedOrganization= ( $condition == "$facility") ? $this->string : "$facility"; // if representedOrganization is empty
				$startDate = ($condition == $value['NewCropPrescription']['created']) ? $this->numXml : $value['NewCropPrescription']['created']; // if date is empty
				$diagnoses = ($condition == $encounters['NoteDiagnosis']['diagnoses_name']) ? $this->string : $encounters['NoteDiagnosis']['diagnoses_name']; // if date is empty
				$diagnosesDate = ($condition == $encounters['NoteDiagnosis']['end_dt']) ? $this->numXml : $encounters['NoteDiagnosis']['end_dt']; // if date is empty
				$frequency = ($condition == $value['NewCropPrescription']['frequency']) ? $this->string :  $value['NewCropPrescription']['frequency']; // if frequency is empty
				$dose = ($condition == $value['NewCropPrescription']['dose']) ? $this->numXml: $value['NewCropPrescription']['dose'] ; // if dose is empty
				//eof
				if($medication != ''){
					$extension=6000;
					$medText1 .= '<entry typeCode="DRIV">
							<substanceAdministration classCode="SBADM" moodCode="EVN">
							<templateId root="2.16.840.1.113883.10.20.22.4.16"/>
							<!-- ** MEDICATION ACTIVITY -->
							<id root="cdbd33f0-6cde-11db-9fe1-0800200c9a66" extension="'.$extension.'"/>
									<text>
									<reference value="#DM'.$i.'"/>'.$medication.'</text>
											<statusCode code="completed"/>
											<effectiveTime xsi:type="IVL_TS">';
						
					$str1='';
					$timestampp = $this->customStrtoTime($startDate);
					$dt=$this->customStrtoDate($timestampp,"Ymd");

					if($startDate != '0'){
						$str1.='<low value="'.$dt.'"/>';
					}else{
						$str1.='<low nullFlavor="UNK"/>';
					}
					$medText1 .=$str1 ;
						
					$medText1.='<high value="'.$this->numXml.'"/>
							</effectiveTime>
							<effectiveTime xsi:type="PIVL_TS" institutionSpecified="true"
							operator="A">
							<period value="'.$dose.'" unit="d"/>
									</effectiveTime>
									<routeCode code="C38288" codeSystem="2.16.840.1.113883.3.26.1.1"
									codeSystemName="NCI Thesaurus" displayName="'.$indications.'"/>
											<doseQuantity value="'.$doseValue.'" unit="'.$doseUnit.'"/>
													<administrationUnitCode code="C42744" displayName="'.$indications.'"
															codeSystem="2.16.840.1.113883.3.26.1.1"
															codeSystemName="NCI Thesaurus"/>
															<consumable>
															<manufacturedProduct classCode="MANU">
															<templateId root="2.16.840.1.113883.10.20.22.4.23"/>';
						
					$str2='';
					$extension++;
					$medText1 .=$str2 ;
					$medText1.='<id root="2a620155-9d11-439e-92b3-5d9815ff4ee8" extension="'.$extension.'"/>
							<manufacturedMaterial>
							<code code="309309" codeSystem="2.16.840.1.113883.6.88"
							displayName="'.$medication.'">
									<originalText>
									<reference value="#DM'.$i.'"/>
											</originalText>
											</code>
											</manufacturedMaterial>
											<manufacturerOrganization>
											<name nullFlavor="UNK"/>
											</manufacturerOrganization>
											</manufacturedProduct>
											</consumable>
											<performer>
											<assignedEntity>
											<id nullFlavor="NI"/>
											<addr nullFlavor="UNK"/>
											<telecom nullFlavor="UNK"/>
											<representedOrganization>
											<id root="2.16.840.1.113883.19.5.9999.1393"/>
											<name>'.$representedOrganization.'</name>
													<telecom nullFlavor="UNK"/>
													<addr nullFlavor="UNK"/>
													</representedOrganization>
													</assignedEntity>
													</performer>
													<participant typeCode="CSM">
													<participantRole classCode="MANU">
													<templateId root="2.16.840.1.113883.10.20.22.4.24"/>
													<code code="412307009" displayName="drug vehicle"
													codeSystem="2.16.840.1.113883.6.96"/>
													<playingEntity classCode="MMAT">
													<code code="10311" displayName="'.$displayName.'"
															codeSystem="2.16.840.1.113883.6.88"
															codeSystemName="RxNorm"/>
															<name>'.$displayName.'</name>
																	</playingEntity>
																	</participantRole>
																	</participant>
																	<entryRelationship typeCode="RSON">
																	<observation classCode="OBS" moodCode="EVN">
																	<templateId root="2.16.840.1.113883.10.20.22.4.19"/>
																	<id root="db734647-fc99-424c-a864-7e3cda82e703"
																	extension="45665"/>
																	<code code="404684003" displayName="Finding"
																	codeSystem="2.16.840.1.113883.6.96"
																	codeSystemName="SNOMED CT"/>
																	<statusCode code="completed"/>
																	<effectiveTime>
																	<low nullFlavor="UNK"/>';
					$strr='';
					$timestamp = $this->customStrtoTime($encounters['NoteDiagnosis']['end_dt']);
					$dt=$this->customStrtoDate($timestamp,"Ymd");
						
					if($diagnosesDate != '0'){
						$strr.='<high value="'.$dt.'"/>';
					}else{
						$strr.='<high nullFlavor="UNK"/>';
					}
					$medText1 .=$strr;
					$medText1 .= '</effectiveTime>
							<value xsi:type="CD" code="233604007" displayName="sss"
							codeSystem="2.16.840.1.113883.6.96"/>
							</observation>
							</entryRelationship>
							</substanceAdministration>
							</entry>';
					$i++;
						
				}
			}
		}
			
		$strdischarge .=  $medText1;
		$strdischarge.='</section>';
		$strdischarge.='</component>';
		return $strdischarge;

	}



	//---eof---
	//-------- Social History----

	public function SocialHistory($id=null,$person_id=null){

		$history = ClassRegistry::init('PatientSmoking');
		$history->bindModel(array(
				'belongsTo' => array(
						'Patient'=>array('foreignKey'=>'patient_id'),
						'SmokingStatusOncs'=>array('className'=>'SmokingStatusOncs','conditions'=>array('SmokingStatusOncs.id=PatientSmoking.current_smoking_fre'),'foreignKey'=>false),
						'SmokingStatusOncs1'=>array('className'=>'SmokingStatusOncs','conditions'=>array('SmokingStatusOncs1.id=PatientSmoking.smoking_fre'),'foreignKey'=>false),
						'PatientPersonalHistory'=>array('foreignKey'=>false,'conditions'=>array('PatientPersonalHistory.diagnosis_id= PatientSmoking.diagnosis_id'))
				)
		));
		//for all patient id's with last record
		$detail = $history->find('all',array('fields'=>array('PatientSmoking.patient_id','PatientSmoking.current_smoking_fre','PatientSmoking.smoking_fre',
				'SmokingStatusOncs.description','SmokingStatusOncs1.description','SmokingStatusOncs.detail','SmokingStatusOncs1.detail','SmokingStatusOncs.snomed_id',
				'SmokingStatusOncs1.snomed_id','PatientPersonalHistory.alcohol_desc','PatientPersonalHistory.alcohol_fre','pre_to','pre_from','current_to','current_from'),
				'conditions'=>array('Patient.person_id'=>$person_id),'order'=>array('PatientSmoking.id asc')));
		//debug($detail);exit;
			
		$currentElement= ($condition ==$detail['SmokingStatusOncs']['description']) ? $this->string :$detail['SmokingStatusOncs']['description']; // if Social History Element is empty
		$currentDescription = ($condition == $detail['SmokingStatusOncs']['detail']) ? 	 $this->string : $detail['SmokingStatusOncs']['detail']; // if Description is empty
		$elementAlcohol= ($condition ==$detail['PatientPersonalHistory']['alcohol_fre']) ? $this->string :$detail['PatientPersonalHistory']['alcohol_fre']; // if Social History Element is empty
		$startDateAlcohol = ($condition == $detail['PatientPersonalHistory']['alcohol_desc']) ? $this->numXml : $detail['PatientPersonalHistory']['alcohol_desc']; // if Date is empty

		$social.='<component>';
		$social.='<section>
				<templateId root="2.16.840.1.113883.10.20.22.2.17"/>
					
				<code code="29762-2" codeSystem="2.16.840.1.113883.6.1"
				displayName="Social History"/>
				<title>SOCIAL HISTORY</title>
				<text>
				<table border="1" width="100%">
				<thead>
				<tr>
				<th>Social History Element</th>
				<th>Description</th>
				<th>Effective Dates</th>
				</tr>
				</thead>
				<tbody>';
		$str='';
			
		$smok['SmokingStatusOncs'] = array( 'description'=>"", 'detail'=>"", 'snomed_id'=>"" 	) ;
		$smok['SmokingStatusOncs1'] = array( 	'description'=>"", 	'detail'=>"" , 	'snomed_id'=>""  ) ;
		$smok['PatientPersonalHistory'] = array( 	'description'=>""  , 'detail'=>""  ) ;
 
		foreach($detail as $detailKey => $detailsVal){
			if(!empty($detailsVal['SmokingStatusOncs']['description']))
				$smok['SmokingStatusOncs']['description'] = $detailsVal['SmokingStatusOncs']['description'];

			if(!empty($detailsVal['SmokingStatusOncs']['detail']))
				$smok['SmokingStatusOncs']['detail'] = $detailsVal['SmokingStatusOncs']['detail'];

			if(!empty($detailsVal['SmokingStatusOncs']['snomed_id']))
				$smok['SmokingStatusOncs']['snomed_id']= $detailsVal['SmokingStatusOncs']['snomed_id'];

			if(!empty($detailsVal['SmokingStatusOncs1']['description']))
				$smok['SmokingStatusOncs1']['description'] = $detailsVal['SmokingStatusOncs1']['description'];

			if(!empty($detailsVal['SmokingStatusOncs1']['detail']))
				$smok['SmokingStatusOncs1']['detail'] = $detailsVal['SmokingStatusOncs1']['detail'];

			if(!empty($detailsVal['SmokingStatusOncs1']['snomed_id']))
				$smok['SmokingStatusOncs1']['snomed_id']= $detailsVal['SmokingStatusOncs1']['snomed_id'];

			if(!empty($detailsVal['PatientPersonalHistory']['description']))
				$smok['PatientPersonalHistory']['description'] = $detailsVal['PatientPersonalHistory']['description'];

			if(!empty($detailsVal['PatientPersonalHistory']['detail']))
				$smok['PatientPersonalHistory']['detail']= $detailsVal['PatientPersonalHistory']['detail'];

			if(!empty($detailsVal['PatientSmoking']['pre_to']))
				$smok['PatientSmoking']['pre_to'] = $detailsVal['PatientSmoking']['pre_to'];

			if(!empty($detailsVal['PatientSmoking']['pre_from']))
				$smok['PatientSmoking']['pre_from']= $detailsVal['PatientSmoking']['pre_from'];

		}
			
		$currentElement= (!$smok['SmokingStatusOncs']['description']) ? $this->string :$smok['SmokingStatusOncs']['description']; // if Social History Element is empty
		$currentDescription = (!$smok['SmokingStatusOncs']['detail']) ? 	 $this->string : $smok['SmokingStatusOncs']['detail']; // if Description is empty
		$currentSnomed = (!$smok['SmokingStatusOncs']['snomed_id']) ? 	 $this->string : $smok['SmokingStatusOncs']['snomed_id']; // if snomed is empty

		$preSnomed = (!$smok['SmokingStatusOncs1']['snomed_id']) ? 	 $this->string : $smok['SmokingStatusOncs1']['snomed_id']; // if snomed is empty
		$preElement= (!$smok['SmokingStatusOncs1']['description']) ? $this->string :$smok['SmokingStatusOncs1']['description']; // if Social History Element is empty
		$preDescription = (!$smok['SmokingStatusOncs1']['detail']) ? 	 $this->string : $smok['SmokingStatusOncs1']['detail']; // if Description is empty

		$elementAlcohol= (!$smok['PatientPersonalHistory']['alcohol_fre']) ? $this->string :$smok['PatientPersonalHistory']['alcohol_fre']; // if Social History Element is empty
		$startDateAlcohol = (!$smok['PatientPersonalHistory']['alcohol_desc']) ? $this->numXml : $smok['PatientPersonalHistory']['alcohol_desc']; // if Date is empty


		if(!empty($smok['PatientSmoking']['pre_to'])){
			$currentToDate=date ("d F Y" , $this->customStrtoTime($smok['PatientSmoking']['pre_to']));
		}else{
			$currentToDate="";
		}
		$timestamp = $this->customStrtoTime($smok['PatientSmoking']['pre_to']);
		$highDate=$this->customStrtoDate($timestamp,"Ymd");
		
		if(!empty($smok['PatientSmoking']['pre_from']))	{
			$currentFromDate=date ("d F Y" ,$this->customStrtoTime($smok['PatientSmoking']['pre_from']));
		}else{
			$currentFromDate="";
		}
		$timestampp = $this->customStrtoTime($smok['PatientSmoking']['pre_from']);
		$lowDate=$this->customStrtoDate($timestampp,"Ymd");

		if(!empty($smok['PatientSmoking']['pre_to'])){
			$currentToCompleteDate=date ("d F Y" , $this->customStrtoTime($smok['PatientSmoking']['pre_to']));
		}else{
			$currentToCompleteDate="";
		}
		if(!empty($smok['PatientSmoking']['pre_from']))	{
			$currentFromCompleteDate=date ("d F Y" ,$this->customStrtoTime($smok['PatientSmoking']['pre_from']));
		}else{
			$currentFromCompleteDate="";
		}
 
			
		if(!empty($smok['SmokingStatusOncs']['snomed_id'])){

			if(!empty($smok['PatientSmoking']['pre_from'])){
				$smokeDuration  = $currentFromDate ;
				$startDateForSmoke = '<low value="'.$lowDate.'"/>';
				$smokeDuration .= ($currentToDate)?' to '.$currentToDate:"" ;
			}else{
				$startDateForSmoke = '<low nullFlavor="UNK"/>'; //adding null flovour
			}

			if(!empty($currentToDate)){
				$endDateForSmoke = '<high value="'.$highDate.'"/>';
			}else{
				$endDateForSmoke = '<high nullFlavor="UNK"/>'; //adding null flovour
			}

			$social .='<tr>
					<td><content ID="soc1"/>'.$currentElement.'</td>
							<td>'.$currentDescription.' '.$smokeDuration.'</td>';

			if(!empty ($currentFromCompleteDate)){
				$socialTd .='<td>'.$currentFromCompleteDate;
				$socialTd .= ($currentToCompleteDate)?' to '.$currentToCompleteDate:"";
				$socialTd .= '</td>';
			}else{
				$socialTd .='<td></td>';
			}
			$social .= $socialTd.'</tr> ';

			$smokeXml ='<entry typeCode="DRIV"><observation classCode="OBS" moodCode="EVN">

					<templateId root="2.16.840.1.113883.10.20.22.4.78"/>
					<id extension="123456789" root="2.16.840.1.113883.19"/>
					<code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4"/>
					<statusCode code="completed"/>
					<effectiveTime>';
			$smokeXml .= $startDateForSmoke ;
			$smokeXml .= $endDateForSmoke ;
			$smokeXml .=			'</effectiveTime>
					<value xsi:type="CD" code="'.$currentSnomed.'" displayName="'.$currentElement.'"
							codeSystem="2.16.840.1.113883.6.96">
							<originalText>
							<reference value="#soc1"/>
							</originalText>
							</value>
							</observation></entry>';
		}

		$str1='';
		if(!empty($detail['PatientPersonalHistory']['alcohol_fre'])){
			//foreach ($detail as $key => $smoking){
			$smoking = $detail ;
			$Element= ($condition ==$smoking['PatientPersonalHistory']['alcohol_fre']) ? $this->string :$smoking['PatientPersonalHistory']['alcohol_fre']; // if Social History Element is empty
			$alcohol_date = ($condition == $smoking['PatientPersonalHistory']['alcohol_desc']) ? $this->numXml : $smoking['PatientPersonalHistory']['alcohol_desc']    ; // if Date is empty

			$timestamp = $this->customStrtoTime($smoking['PatientPersonalHistory']['alcohol_desc']);

			$alco_Date=$this->customStrtoDate($timestamp,"Ymd");
			if(!empty($alcohol_date)){
				$str1.='<tr>
						<td><content ID="soc2"/>'.$Element.'</td>
								<td>None</td>
								<td>'.$alco_Date.'</td>
										</tr>';
			}else{
				$str1.='<tr>
						<td>'.$Element.'</td>
								<td>None</td>
								<td></td>
								</tr>';
			}
		}

		$social .=  $str1;
		$social .='</tbody></table></text>';
		$social .= $smokeXml ; //from above
			
		//-----alcohol-------
		if(!empty($detail['PatientPersonalHistory']['alcohol_fre'])){
			$social .='<entry typeCode="DRIV">
					<observation classCode="OBS" moodCode="EVN">
					<!-- ** Social history observation ** -->
					<templateId root="2.16.840.1.113883.10.20.22.4.38"/>
					<id root="37f76c51-6411-4e1d-8a37-957fd49d2cef"/>
					<code code="160573003" codeSystem="2.16.840.1.113883.6.96"
					displayName="'.$elementAlcohol.'">
							<originalText>
							<reference value="#soc2"/>
							</originalText>
							</code>
							<statusCode code="completed"/>
							<effectiveTime>';
			$timestam = $this->customStrtoTime($detail['PatientPersonalHistory']['alcohol_desc']);
			$frommDate=$this->customStrtoDate($timestam,"Ymd");
			if(!empty($startDateAlcohol)){
				$social .='<low value="'.$frommDate.'"/>';
			}else{
				$social .='<low nullFlavor="UNK"/>';
			}
			$social .='<high nullFlavor="UNK"/>';
			$social .='</effectiveTime>
					<value xsi:type="ST">None</value>
					</observation>
					</entry>';
		}
			
		$social .=	'</section>';
		$social .=' </component>';
			
		return $social;
	}//-----eof----


	//result for last encounter
	public function Results($id=null,$uid=null){
		$laboratoryTestOrder = ClassRegistry::init('LaboratoryTestOrder');

		$laboratoryTestOrder->bindModel(array(
				'belongsTo' => array(
						'Laboratory'=>array('foreignKey'=>'laboratory_id')
				),
				'hasOne' => array('LaboratoryResult'=>array('foreignKey'=>'laboratory_test_order_id','type'=>'inner'),
						'LaboratoryHl7Result'=>array('foreignKey'=>false,
								'conditions'=>array('LaboratoryResult.id =LaboratoryHl7Result.laboratory_result_id')))));

			
		$labResult= $laboratoryTestOrder->find('all',array('conditions'=>array('LaboratoryTestOrder.patient_id'=>$id,
				'LaboratoryTestOrder.is_deleted'=>0),'group'=>array('LaboratoryTestOrder.laboratory_id')));
		$result.='<component>';
		$result.='<section>

				<templateId root="2.16.840.1.113883.10.20.22.2.3.1"/>
				<!-- Entries Required -->
				<code code="30954-2" codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC"
				displayName="RESULTS"/>
				<title>RESULTS</title>
				<text>
				<table border="1" width="100%">
				<thead>
				<tr>
				<th colspan="2">LABORATORY INFORMATION</th>
				</tr>
				<tr>
				<th colspan="2">Chemistries and drug levels</th>
				</tr>
				</thead>
				<tbody>';

		$resultCounter=1;
		$extensionCounter=9001;
		foreach($labResult as $key => $detail){
			$name= ($condition == $detail['Laboratory']['name']) ? $this->string : $detail['Laboratory']['name']; // if name is empty
			$range = ($condition ==$detail['LaboratoryHl7Result']['range']) ?$this->numXml: $detail['LaboratoryHl7Result']['range']; // if range is empty
			$value = ($condition ==$detail['LaboratoryHl7Result']['result']) ?$this->numXml: $detail['LaboratoryHl7Result']['result']; // if value is empty
			$unit = ($condition ==$detail['LaboratoryHl7Result']['unit']) ?$this->numXml:$detail['LaboratoryHl7Result']['unit']; // if unit is empty
			$lonic = ($condition ==$detail['Laboratory']['lonic_code']) ?$this->numXml:$detail['Laboratory']['lonic_code']; // if value is empty
			$date = ($condition ==$detail['LaboratoryHl7Result']['date_time_of_observation']) ?$this->numXml: $detail['LaboratoryHl7Result']['date_time_of_observation']; // if value is empty
			
			$table = $this->get_html_translation_table_CP1252();
			$replaceStr = strtr($range,$table) ;
			
			
			if(!empty($detail['Laboratory']['name'])){
				$resultText.='<tr>';
				if(!empty($detail['LaboratoryHl7Result']['range'])){
					$resultText.='<td><content ID="result'.$resultCounter.'">'.$name.'('. $replaceStr.')</content></td>';
					$rangeText='<text>'.$replaceStr.'</text>';
				}else{
					$resultText.='<td><content ID="result'.$resultCounter.'">'.$name.'</content></td>';
					$rangeText='<text></text>';
				}
				if(!empty($detail['LaboratoryHl7Result']['result'])){
					$resultText.='<td>'.$detail['LaboratoryHl7Result']['result'].'</td>';
					$valueText='<value xsi:type="PQ" value="'.$value.'" unit="'.$unit.'"/>';

				}else{
					$resultText.='<td></td>';
					$valueText='<value xsi:type="PQ" value="'.$this->numXml.'" unit="'.$this->string.'"/>';
					//	<value xsi:type="PQ" value="10.2" unit="g/dl"/>
					//  <value xsi:type="PQ" value="'.$this->numXml.'" unit="'.$this->string.'"/>
				}
				$resultTimeStamp = $this->customStrtoTime($detail['LaboratoryHl7Result']['date_time_of_observation']);
				$effectiveTime=$this->customStrtoDate($resultTimeStamp,"Ymd");
				if(!empty($detail['LaboratoryHl7Result']['date_time_of_observation'])){
					$effectiveDateForResult= '<effectiveTime value="'.$effectiveTime.'"/>';
				}else{
					$effectiveDateForResult= '<effectiveTime nullFlavor="UNK"/>';
				}

				$resultText.='</tr>';
		/*	} else{
				$resultText.='<tr>
						<td><content ID="result'.$resultCounter.'"></content></td>
								<td></td>
								</tr>';
				$resultTimeStamp = $this->customStrtoTime($detail['LaboratoryHl7Result']['date_time_of_observation']);
				$effectiveTime=date ("Ymd" , $resultTimeStamp  );
				if(!empty($detail['LaboratoryHl7Result']['date_time_of_observation'])){
					$effectiveDateForResult= '<effectiveTime value="'.$effectiveTime.'"/>';
				}else{
					$effectiveDateForResult= '<effectiveTime nullFlavor="UNK"/>';
				}
			} */


			$resultXml .= '<component>
					<observation classCode="OBS" moodCode="EVN">
					<!-- Result observation template -->
					<templateId root="2.16.840.1.113883.10.20.22.4.2"/>
					<id root="107c2dc0-67a5-11db-bd13-0800200c9a66" extension="'.$extensionCounter.'"/>
							<code xsi:type="CE" code="'.$lonic.'" displayName="'.$name.'"
									codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC"> </code>
									<text>
									<reference value="#result'.$resultCounter.'"/>
											</text>
											<statusCode code="completed"/>
											'.$effectiveDateForResult.'
													'.$valueText.'
															<interpretationCode code="N" codeSystem="2.16.840.1.113883.5.83"/>
															<methodCode/>
															<targetSiteCode/>
															<author>
															<time/>
															<assignedAuthor>
															<id root="2a620155-9d11-439e-92b3-5d9816ff4de8"/>
															</assignedAuthor>
															</author>
															<referenceRange>
															<observationRange>
															'.$rangeText.'
																	</observationRange>
																	</referenceRange>
																	</observation>
																	</component>';
			$resultCounter++;
		}
		}if(trim($resultText) == ""){
			$result.='<tr><td></td><td></td></tr>';
		}else{

			$result .=  $resultText ;
		}
		$result .= ' </tbody></table></text>';
		
		$result1 .= '<entry typeCode="DRIV">
				<organizer classCode="BATTERY" moodCode="EVN">
				<!-- Result organizer template -->
				<templateId root="2.16.840.1.113883.10.20.22.4.1"/>
				<id root="7d5a02b0-67a4-11db-bd13-0800200c9a66" extension="9000"/>
				<code xsi:type="CE" code="43789009" displayName="CBC WO DIFFERENTIAL"
				codeSystem="2.16.840.1.113883.6.96" codeSystemName="SNOMED CT"/>
				<statusCode code="completed"/>';
		
		$result .=$result1;
		$result .=  $resultXml ;
		
		$result .='</organizer>
				</entry>';
				
			$result .='
				</section>';
		$result .=' </component>';
		return $result;
		
	}//---------eof-----------


	//--------Procedure  ------
	public function Procedure($id=null){
		$session = new cakeSession();

		$procedurePerform  = ClassRegistry::init('ProcedurePerform');
		$mode4 = ClassRegistry::init('Country');
		$mode5 = ClassRegistry::init('State');
		$mode6 = ClassRegistry::init('City');
		$mode7 = ClassRegistry::init('User');
		$country=$mode4->find('first',array('fields'=>array('name'),'conditions'=>array('Country.id'=>$_SESSION[Auth][User][country_id])));
		$state=$mode5->find('first',array('fields'=>array('name'),'conditions'=>array('State.id'=>$_SESSION[Auth][User][state_id])));
		//$city=$mode6->find('first',array('fields'=>array('name'),'conditions'=>array('City.id'=>$_SESSION[Auth][User][city_id])));
		$address=($_SESSION[Auth][User][address1]);
		$phone=($_SESSION['Auth']['User']['phone1']);
		$postal=($_SESSION['Auth']['User']['zipcode']);
		$facility=$session->read('facility');

		$procedureData= $procedurePerform->find('all',array('fields'=> array('procedure_name','snowmed_code','procedure_date'),
				'conditions'=>array('ProcedurePerform.patient_id'=>$id,'ProcedurePerform.procedure_date <='=>date('Y-m-d'),'is_deleted'=>0)));
		
		$strprocedure.=' <component>';
		$strprocedure.='  <section>
				<templateId
				root="2.16.840.1.113883.10.20.22.2.7.1"/>
				<!-- Procedures section template -->
				<code
				code="47519-4"
				codeSystem="2.16.840.1.113883.6.1"
				codeSystemName="LOINC"
				displayName="HISTORY OF PROCEDURES"/>
				<title>PROCEDURES</title>
				<text>
				<table
				border="1"
				width="100%">
				<thead>
				<tr>
				<th>Procedure</th>
				<th>Date</th>
				</tr>
				</thead>
				<tbody>';
		$medText='';
		$i=1;
		 
		foreach($procedureData as $procedureKey=>$detail){
			 
			$detail = $detail['ProcedurePerform'] ;
			//--empty conditiopn----
			
			$procedure= ($condition == $detail['procedure_name']) ? $this->string : $detail['procedure_name']; // if Procedure is empty
			
			$table = $this->get_html_translation_table_CP1252(); 
			$procedure = strtr($procedure,$table) ;
			
			
			$representedOrganization= ( $condition == "$facility") ? $this->string : "$facility"; // if representedOrganization is empty
			$snowmed_code= ( $condition == $detail['snowmed_code']) ? $this->numXml : $detail['snowmed_code']; // if snowmed code is empty
			
			
			$address = ($condition == $address) ? $headerString : $address  ; // if facility address is empty
			$facilityCity = ($condition == $_SESSION['location']) ? $headerString : $_SESSION['location']  ; // if facility city is empty
			$facilityState = ($condition == $state['State']['name']) ? $headerString : $state['State']['name']  ; // if facility state is empty
			$postal = ($condition == $postal) ? $headerString : $postal  ; // if facility zip is empty
			$facilityCountry = ($condition == $country['Country']['name']) ? $headerString : $country['Country']['name']  ; // if facility country is empty
					
			//eof
 
			if(!empty($detail['procedure_name'])) {
				if(!empty($detail['procedure_date'])){

					$radioTimeStamp = $this->customStrtoTime($detail['procedure_date']);
					$sdt=$this->customStrtoDate($radioTimeStamp,"Ymd");
					
					$radioTimeStampp = $this->customStrtoTime($detail['procedure_date']);
					$tdSdt=$this->customStrtoDate($radioTimeStampp,"d F Y");
					
					$medText .= '<tr>
							<td><content ID="Proc'.$i.'">'.$procedure.'</content></td>
									<td>'.$tdSdt.'</td>
											</tr>';


					$startDate='<effectiveTime value="'.$sdt.'"/>';
				}else{
					$medText .= '<tr>
							<td><content ID="Proc'.$i.'">'.$procedure.'</content></td>
									<td></td>
									</tr>';
					$startDate='<effectiveTime nullFlavor="UNK"/>';
				}
			}
			$radiologyXml.= '<entry
					typeCode="DRIV">
					<procedure
					classCode="PROC"
					moodCode="EVN">
					<templateId
					root="2.16.840.1.113883.10.20.22.4.14"/>
					<!-- Procedure Activity Observation -->
					<id
					extension="123456789"
					root="2.16.840.1.113883.19"/>
					<code
					code="'.$snowmed_code.'"
					codeSystem="2.16.840.1.113883.6.96"
					displayName="'.$procedure.'"
							codeSystemName="SNOMED-CT">
							<originalText>
							<reference
							value="#Proc'.$i.'"/>
									</originalText>
									</code>
									<statusCode
									code="completed"/>
									'.$startDate.'
											<priorityCode code="CR" codeSystem="2.16.840.1.113883.5.7"
								codeSystemName="ActPriority" displayName="Callback results"/>
							<methodCode nullFlavor="UNK"/>
							<targetSiteCode code="82094008" codeSystem="2.16.840.1.113883.6.96"
								codeSystemName="SNOMED CT"
								displayName="Lower Respiratory Tract Structure"/>
											<performer>
											<assignedEntity>
											<id
											root="2.16.840.1.113883.19.5"
											extension="1234"/>
											<addr>';
											$addressFcLine =($address != "")?'<streetAddressLine>'.$address.'</streetAddressLine>':'<streetAddressLine nullFlavor="UNK"></streetAddressLine>' ;
		$cityFcNode = ($facilityCity != "")?'<city>'.$facilityCity.'</city>':'<city nullFlavor="UNK"></city>' ;
		$stateFcNode =($facilityState != "")?'<state>'.$facilityState.'</state>':'<state nullFlavor="UNK"></state>';
		$postalFcNode =($postal != "")?'<postalCode>'.$postal.'</postalCode>':'<postalCode nullFlavor="UNK"></postalCode>';
		$countryFcNode =($facilityCountry != "")?'<country>'.$facilityCountry.'</country>':'<country nullFlavor="UNK"></country>';
		$radiologyXml.=   $addressFcLine.$cityFcNode.$stateFcNode.$postalFcNode.$countryFcNode.'</addr>';		
																					$radiologyXml.= '<telecom
																					use="WP"
																					value="'.$phone.'"/>
																							<representedOrganization>
																							<id
																							root="2.16.840.1.113883.19.5"/>
																							<name>'.$representedOrganization.'</name>
																									<telecom
																									nullFlavor="UNK"/>
																									<addr
																									nullFlavor="UNK"/>
																									</representedOrganization>
																									</assignedEntity>
																									</performer>
																									<participant
																									typeCode="LOC">
																									<participantRole
																									classCode="SDLOC">
																									<templateId
																									root="2.16.840.1.113883.10.20.22.4.32"/>
																									<!-- Service Delivery Location template -->
																									<code
																									code="1160-1"
																									codeSystem="2.16.840.1.113883.6.259"
																									codeSystemName="HealthcareServiceLocation"
																									displayName="Urgent Care Center"/>
																									<addr>';
																									$addressFcLine =($address != "")?'<streetAddressLine>'.$address.'</streetAddressLine>':'<streetAddressLine nullFlavor="UNK"></streetAddressLine>' ;
		$cityFcNode = ($facilityCity != "")?'<city>'.$facilityCity.'</city>':'<city nullFlavor="UNK"></city>' ;
		$stateFcNode =($facilityState != "")?'<state>'.$facilityState.'</state>':'<state nullFlavor="UNK"></state>';
		$postalFcNode =($postal != "")?'<postalCode>'.$postal.'</postalCode>':'<postalCode nullFlavor="UNK"></postalCode>';
		$countryFcNode =($facilityCountry != "")?'<country>'.$facilityCountry.'</country>':'<country nullFlavor="UNK"></country>';
		$radiologyXml.=   $addressFcLine.$cityFcNode.$stateFcNode.$postalFcNode.$countryFcNode.'</addr>';		
																																			$radiologyXml.= '<telecom
																																			nullFlavor="UNK"/>
																																			<playingEntity
																																			classCode="PLC">
																																			<name>'.$representedOrganization.'</name>
																																					</playingEntity>
																																					</participantRole>
																																					</participant>
																																					</procedure>
																																					</entry>';
			$i++;
		}if(trim($medText) == ""){
			$strprocedure .='<tr><td></td><td></td></tr>';
		}else{
			$strprocedure .=  $medText ;
		}
		$strprocedure.='</tbody></table></text>';
		$i++;
		$strprocedure .=  $radiologyXml ;
		$strprocedure .='</section>';
		$strprocedure.=' </component>';
		return $strprocedure;
	}//----------eof-----
	//========== problems========
	public function Problem($id=null,$uid=null,$note_id=null,$consolidated=false){
		$noteDiagnosis = ClassRegistry::init('NoteDiagnosis');
		$noteDiagnosis->unBindModel(array('belongsTo'=>array('icds')));
		if($consolidated){
			$problems=$noteDiagnosis->find('all',array('fields'=>array('icd_id','diagnoses_name','start_dt','end_dt','disease_status','snowmedid','disease_status'),
					'conditions'=>array('NoteDiagnosis.u_id'=>$uid,'is_deleted'=>0),'group'=>array('NoteDiagnosis.diagnoses_name')));
		}else{
			$problems=$noteDiagnosis->find('first',array('fields'=>array('icd_id','diagnoses_name','start_dt','end_dt','disease_status','snowmedid'),
					'conditions'=>array('NoteDiagnosis.note_id'=>$note_id,'NoteDiagnosis.patient_id'=>$id,'is_deleted'=>0),'group'=>array('NoteDiagnosis.diagnoses_name')));
		}
		 
		$strproblem.='<component>';
		$strproblem.='<section>
				<templateId
				root="2.16.840.1.113883.10.20.22.2.5.1"/>
				<code
				code="11450-4"
				codeSystem="2.16.840.1.113883.6.1"
				codeSystemName="LOINC"
				displayName="PROBLEM LIST"/>
				<title>PROBLEMS</title>
				<text>
				<table
				border="1"
				width="100%">
				<thead>
				<tr>
				<th>Code</th>
				<th>CodeSystem</th>
				<th>Problem Name</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Status</th>
				</tr>
				</thead>
				<tbody>';
		$medText='';
		$i=1;
		foreach($problems as $key => $prob){

			if($consolidated){
				$data= $prob['NoteDiagnosis'] ;
			}else{
				$data= $prob ;
			}
			//--empty conditiopn----
 
		 	$code= ($condition == $data['snowmedid']) ? $this->numXml :$data['snowmedid']; // if code is empty
			$problemName = ($condition == $data['diagnoses_name']) ? $this->string : $data['diagnoses_name']; // if name is empty
			$status = ($data['disease_status']!="resolved") ? "Active":"Resolved"; // if  status is empty
			$snowmedid = ($condition == $data['snowmedid']) ? $this->numXml : $data['snowmedid']; // if snowmedid is empty

			if(!empty($data['diagnoses_name']) && $status != 'Resolved'){
				
				if($status == 'Active'){

					$startdat = $this->customStrtoTime($data['start_dt']);
					$tdSdt=$this->customStrtoDate($startdat,"d F Y");
					
					if(!empty($data['start_dt'])){
						$startda = $this->customStrtoTime($data['start_dt']);
						$sdt=$this->customStrtoDate($startda,"Ymd");
					}
					
					
					$tdEdt ="";
					$edt ="" ;
					if((!empty($data['end_dt']) &&   $data['end_dt'] != '')){
					
					 	$timestamp = $this->customStrtoTime($data['end_dt']);
					 	$edt=$this->customStrtoDate($timestamp,"Ymd");					 	 
					 	$tdEdt=$this->customStrtoDate($timestamp,"d F Y");
					}
					$medText .= '<tr>
							<td>'.$code.'</td>
									<td>SNOMEDCT</td>
									<td><content ID="problem'.$i.'">'.$problemName.'</content></td>
											<td>'.$tdSdt.'</td>
													<td>'.$tdEdt.'</td>
													<td>'.$status.'</td>
															</tr>';

					if(!empty($data['start_dt'])){
						$startDateForProblem='<low value="'.$sdt.'"/>';
					}else{
						$startDateForProblem='<low nullFlavor="UNK"/>';
					}
					if(!empty($data['end_dt'])){
						$endDateForProblem='<high value="'.$edt.'"/>';
					}else{
						$endDateForProblem='<high nullFlavor="UNK"/>';
					}
				}
				/*}else{
					$startdat = $this->customStrtoTime($data['start_dt']);
					$tdSdt=date ("F Y" , $startdat  );
					
					$startdat = $this->customStrtoTime($data['start_dt']);
					$sdt=date ("Ymd" , $startdat  );
					
					$time = $this->customStrtoTime($data['end_dt']);
					$tdEdt=date ("Ymd" , $time);
					
					$time = $this->customStrtoTime($data['end_dt']);
					$edt=date ("Ymd" , $time);
					$medText .= '<tr>
							<td>'.$code.'</td>
									<td>SNOMEDCT</td>
									<td><content ID="problem'.$i.'">'.$problemName.'</content></td>
											<td>'.$tdSdt.'</td>
													<td>'.$tdEdt.'</td>
															<td>'.$status.'</td>
																	</tr>';
					if(!empty($data['start_dt']) || $data['start_dt'] != '0000-00-00'){
						$startDateForProblem='<low value="'.$sdt.'"/>';
					}else{
						$startDateForProblem='<low nullFlavor="UNK"/>';
					}
					if(!empty($data['end_dt']) || $data['end_dt'] != '0000-00-00'){
						$endDateForProblem='<high value="'.$edt.'"/>';
					}else{
						$endDateForProblem='<high nullFlavor="UNK"/>';
					}
				}*/
			}
			if($consolidated){
				$data= $prob['NoteDiagnosis'] ;
			}else{
				$data= $prob ;
			}
			$problemXml.='<entry typeCode="DRIV">
					<act classCode="ACT" moodCode="EVN">
					<!-- Problem act template -->
					<templateId root="2.16.840.1.113883.10.20.22.4.3"/>
					<id root="ec8a6ff8-ed4b-4f7e-82c3-e98e58b45de7" extension="7002"/>
					<code code="CONC" codeSystem="2.16.840.1.113883.5.6"
					displayName="Concern"/>
					<statusCode code="active"/>
					<effectiveTime>
					'.$startDateForProblem.'
							'.$endDateForProblem.'
									</effectiveTime>
									<entryRelationship typeCode="SUBJ">
									<observation classCode="OBS" moodCode="EVN">
									<!-- Problem observation template -->
									<templateId root="2.16.840.1.113883.10.20.22.4.4"/>
									<id root="ab1791b0-5c71-11db-b0de-0800200c9a66" extension="7003"/>
									<code code="409586006" codeSystem="2.16.840.1.113883.6.96"
									displayName="Complaint"/>
									<text>
									<reference value="#problem'.$i.'"/>
											</text>
											<statusCode code="completed"/>
											<effectiveTime>
											'.$startDateForProblem.'
													'.$endDateForProblem.'
													</effectiveTime>
													<value xsi:type="CD" code="'.$snowmedid.'"
															codeSystem="2.16.840.1.113883.6.96" displayName="'.$problemName.'"/>
																	<entryRelationship typeCode="SUBJ" inversionInd="true">
																	<observation classCode="OBS" moodCode="EVN">
																	<templateId root="2.16.840.1.113883.10.20.22.4.31"/>
																	<!--    Age observation template   -->
																	<code code="445518008"
																	codeSystem="2.16.840.1.113883.6.96"
																	displayName="Age At Onset"/>
																	<statusCode code="completed"/>
																	<value xsi:type="PQ" value="65" unit="a"/>
																	</observation>
																	</entryRelationship>

																	<entryRelationship typeCode="REFR">
																	<observation classCode="OBS" moodCode="EVN">
																	<!-- Status observation template -->
																	<templateId root="2.16.840.1.113883.10.20.22.4.6"/>
																	<code xsi:type="CE" code="33999-4"
																	codeSystem="2.16.840.1.113883.6.1"
																	codeSystemName="LOINC" displayName="Status"/>
																	<text>
																	<reference value="#problem'.$i.'"/>
																			</text>
																			<statusCode code="completed"/>
																			<value xsi:type="CD" code="55561003"
																			codeSystem="2.16.840.1.113883.6.96"
																			codeSystemName="SNOMED CT" displayName ="'.$status.'"/>
																					</observation>
																					</entryRelationship>
																					</observation>
																					</entryRelationship>
																					</act>
																					</entry>';
			$i++;
		}
		
		if(trim($medText) == ""){
			$strproblem .='<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
		}else{
			$strproblem .=  $medText ;
		}
		$strproblem.='</tbody></table></text>';
	
		 
		$strproblem .=  $problemXml ;
		$strproblem .='</section>';
		$strproblem.=' </component>';
		return $strproblem;
	}
	//=============end======

	//--------Referral --------
	public function singleReferral($id=null){
		$patientReferral = ClassRegistry::init('PatientReferral');
		$reason=$patientReferral->find('first',array('field'=>array('resion_refer'),'conditions'=>array('PatientReferral.patient_id'=>$id),'order'=>array('PatientReferral.id DESC'),'limit'=>1,));

		$strreferral.='<component>
				<section>
				<templateId root="1.3.6.1.4.1.19376.1.5.3.1.3.1"/>
				<!-- ** Reason for Referral Section Template ** -->
				<code codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC" code="42349-1"
				displayName="REASON FOR REFERRAL"/>
				<title>REASON FOR REFERRAL</title>
				<text>
				<paragraph>'.$reason['PatientReferral']['complaints'].'</paragraph>
						</text>
						</section>
						</component>';

		return $strreferral;

	}//-----------eof------
	//========== vital==========
	public function VitalSign($id=null,$note_id=null,$consolidated=false,$person_id=null){
		$bmiResult = ClassRegistry::init('BmiResult');

		if($consolidated){
			//last entry
			/* $vitals = $mode1->find('first',array('fields' => array('patient_id','ht','wt','bp','create_time','bmi','finalization_date','vital_date'),
			 'order'=>array('Note.id DESC'),'limit'=>1,
					'conditions' => array('Note.patient_id'=>$id))); */

			$bmiResult->bindModel(array(
					'belongsTo' => array(
							'BmiBpResult' =>array('foreignKey'=>false,
									'conditions'=>array('BmiBpResult.bmi_result_id = BmiResult.id')),
							'Patient' =>array('foreignKey'=>false,
									'conditions'=>array('Patient.id = BmiResult.patient_id')),
					)));
			 
			$result =$bmiResult->find('first',array('fields'=> array('BmiResult.id','BmiResult.patient_id','BmiResult.height_result','BmiResult.weight_result','BmiResult.created_time','BmiResult.bmi','BmiResult.date','BmiBpResult.id','BmiBpResult.systolic','BmiBpResult.diastolic'),
					'conditions'=>array('Patient.person_id'=>$person_id),'order'=>array('BmiBpResult.id Desc'))); //bring all the encounters with single patient entry

		}else{
			/* $result = $mode1->find('first',array('fields' => array('patient_id','ht','wt','bp','create_time','bmi'),
					'order'=>array('Note.id DESC'),'limit'=>1,
					'conditions' => array('Note.id'=>$note_id, 'Note.patient_id'=>$id))); */
		}
	
		$strvital = '' ; //init
		$strvital.='   <component>';
		$strvital.='  <section>
				<templateId
				root="2.16.840.1.113883.10.20.22.2.4.1"/>
				<code
				code="8716-3"
				codeSystem="2.16.840.1.113883.6.1"
				codeSystemName="LOINC"
				displayName="VITAL SIGNS"/>
				<title>VITAL SIGNS</title>
				<text>
				<table
				border="1"
				width="100%">
				<thead>
				<tr>
				 
				<th>Height</th>
				<th>Weight</th>
				<th>Blood Pressure</th>
				<th>BMI</th>
				</tr>
				</thead>
				<tbody>';
		$medText1='';
		$countreHt=2;
		$countreWt=4;
		$countreBp=6;
		$countreBmi=8;
		$vitals =array('BmiResult'=>array('bp'=>"",'height_result'=>"",'weight_result'=>"",'bmi'=>"","date"=>"",'created_time'=>""));
		$bpResult =array('BmiBpResult'=>array('systolic'=>"",'diastolic'=>""));
			

	//	foreach ($result as $singlekey => $singleVal){
			
			if(!empty($result['BmiBpResult']['systolic']))
				$bpResult['BmiBpResult']['systolic']  = $result['BmiBpResult']['systolic'] ;
			
			if(!empty($result['BmiBpResult']['diastolic']))
				$bpResult['BmiBpResult']['diastolic']  = $result['BmiBpResult']['diastolic'] ;

			if(!empty($result['BmiResult']['height_result']))
				$vitals['BmiResult']['height_result']  = $result['BmiResult']['height_result'] ;

			if(!empty($result['BmiResult']['weight_result']))
				$vitals['BmiResult']['weight_result']  = $result['BmiResult']['weight_result'] ;

			if(!empty($result['BmiResult']['bmi']))
				$vitals['BmiResult']['bmi']  = $result['BmiResult']['bmi'] ;

			if(!empty($result['BmiResult']['date']))
				$vitals['BmiResult']['date']  = $result['BmiResult']['date'] ;

			if(!empty($result['BmiResult']['create_time']))
				$vitals['BmiResult']['created_time'] = $result['BmiResult']['created_time'];
	//	}
			
			
		//	foreach ($vitals as $singlekey => $result){
		$systolic=($condition == $bpResult['BmiBpResult']['systolic']) ? $this->numXml :$bpResult['BmiBpResult']['systolic'];
		$diastolic=($condition == $bpResult['BmiBpResult']['diastolic']) ? $this->numXml :$bpResult['BmiBpResult']['diastolic'];
		$height= ($condition == $vitals['BmiResult']['height_result']) ? $this->numXml :$vitals['BmiResult']['height_result']; // if Height is empty
		$weight = ($condition == $vitals['BmiResult']['weight_result']) ? $this->numXml : $vitals['BmiResult']['weight_result']; // if Weight is empty
		$bmi = ($condition == $vitals['BmiResult']['bmi']) ? $this->numXml : $vitals['BmiResult']['bmi']; // if BMI is empty
		//eof
		if(!empty($vitals['BmiResult']['created_time'])){
			$timestamp = $this->customStrtoTime($vitals['BmiResult']['created_time'],'yyyy-mm-dd');
			$dt=$this->customStrtoDate($timestamp,"F d, Y");
			$vitalTimeStamp = $this->customStrtoTime($vitals['BmiResult']['created_time'],'yyyy-mm-dd');
			if(!empty($vitals['BmiResult']['date'])){
				$vitalDate = $this->customStrtoTime($vitals['BmiResult']['date']);
				$effectiveDate=$this->customStrtoDate($vitalDate,"Ymd");
				$effectiveVitalDate='<effectiveTime value="'.$effectiveDate.'"/>';
				
			}else {
				$effectiveVitalDate= '<effectiveTime nullFlavor="UNK"/>';
			}
			if(!empty($vitals['BmiResult']['date'])){
				$bpDate = $this->customStrtoTime($vitals['BmiResult']['date']);
				$efectiveBPDate =date ("Ymd" ,$bpDate);
				$effectiveBPDate='<effectiveTime value="'.$efectiveBPDate.'"/>';
			}else {
				$effectiveBPDate = '<effectiveTime nullFlavor="UNK"/>';
			}
			//$medText1 .='<td>'.$dt.'</td>';
		}/* else{
			$medText1 .='<td></td>';
		} */
		//------for ht------
		if(!empty($vitals['BmiResult']['height_result'])){
			$medText1 .='<td><content ID="vit'.$countreHt.'">'.$height.'</content></td>';
		}else{
			$medText1 .='<td><content ID="vit'.$countreHt.'"></content></td>';
		}
		//-----for wt-----------
		if(!empty($vitals['BmiResult']['weight_result'])){
			$medText1 .='<td><content ID="vit'.$countreWt.'">'.$weight.'</content></td>';
		}else{
			$medText1 .='<td><content ID="vit'.$countreWt.'"></content></td>';
		}
		//-----for bp-----------
		if(!empty($bpResult['BmiBpResult']['systolic']) && ($bpResult['BmiBpResult']['diastolic'])){
			$vitalDate = ($vitals['BmiResult']['date'])?"(".$vitals['BmiResult']['date'].")":"" ;
			if(!empty($vitalDate)){
				$vitalTimestamp = $this->customStrtoTime($vitals['BmiResult']['date']);
				$vitalDat=$this->customStrtoDate($vitalTimestamp, "d F Y");
			
			$medText1 .='<td><content ID="vit'.$countreBp.'">'.$systolic.'/'.$diastolic.' mmHg ('.$vitalDat.')</content></td>';
			}else{
				$medText1 .='<td><content ID="vit'.$countreBp.'">'.$systolic.'/'.$diastolic.' mmHg </content></td>';
			}
		}else{
			$medText1 .='<td><content ID="vit'.$countreBp.'"></content></td>';
		}
		//-----for bmi-----------
		if(!empty($vitals['BmiResult']['bmi'])){ 
			$finalizationDate = ($vitals['BmiResult']['date'])?"(".$vitals['BmiResult']['date'].")":"" ;
			if(!empty($finalizationDate)){
			$bmiTimestamp = $this->customStrtoTime($vitals['BmiResult']['date']);
			$bmiDate=$this->customStrtoDate($bmiTimestamp, "d F Y");
			
			$medText1 .='<td><content ID="vit'.$countreBmi.'">'.$bmi .' Kg/m.sq.;   ('.$bmiDate.')</content></td>';
			}else{
				$medText1 .='<td><content ID="vit'.$countreBmi.'">'.$bmi .' Kg/m.sq.</content></td>';
			}
		}else{
			$medText1 .='<td><content ID="vit'.$countreBmi.'"></content></td>';
		}
		$vitalXml .='<entry typeCode="DRIV">
				<organizer classCode="CLUSTER" moodCode="EVN">
				<templateId root="2.16.840.1.113883.10.20.22.4.26"/>
				<!-- Vital signs organizer template -->
				<id root="c6f88320-67ad-11db-bd13-0800200c9a66" extension="1100"/>
				<code code="46680005" codeSystem="2.16.840.1.113883.6.96"
				codeSystemName="SNOMED -CT" displayName="Vital signs"/>
				<statusCode code="completed"/>
				'.$effectiveVitalDate.'
						<component>
						<observation classCode="OBS" moodCode="EVN">
						<templateId root="2.16.840.1.113883.10.20.22.4.27"/>
						<!-- Vital Sign Observation template -->
						<id root="c6f88321-67ad-11db-bd13-0800200c9a66" extension="1101"/>
						<code code="8302-2" codeSystem="2.16.840.1.113883.6.1"
						codeSystemName="LOINC" displayName="Height"/>
						<text>
						<reference value="#vit'.$countreHt.'"/>
								</text>
								<statusCode code="completed"/>
								'.$effectiveVitalDate.'
										<value xsi:type="PQ" value="'.$height.'" unit="in"/>
												<interpretationCode code="N" codeSystem="2.16.840.1.113883.5.83"
												/>
												</observation>
												</component>
												<component>
												<observation classCode="OBS" moodCode="EVN">
												<templateId root="2.16.840.1.113883.10.20.22.4.27"/>
												<!-- Vital Sign Observation template -->
												<id root="c6f88321-67ad-11db-bd13-0800200c9a66" extension="1102"/>
												<code code="3141-9" codeSystem="2.16.840.1.113883.6.1"
												codeSystemName="LOINC"
												displayName="Patient Body Weight - Measured"/>
												<text>
												<reference value="#vit'.$countreWt.'"/>
														</text>
														<statusCode code="completed"/>
														'.$effectiveVitalDate.'
																<value xsi:type="PQ" value="'.$weight.'" unit="lbs"/>
																		<interpretationCode code="N" codeSystem="2.16.840.1.113883.5.83"
																		/>
																		</observation>
																		</component>
																		<component>
																		<observation classCode="OBS" moodCode="EVN">
																		<templateId root="2.16.840.1.113883.10.20.22.4.27"/>
																		<!-- Vital Sign Observation template -->
																		<id root="c6f88321-67ad-11db-bd13-0800200c9a66" extension="1103"/>
																		<code code="8480-6" codeSystem="2.16.840.1.113883.6.1"
																		codeSystemName="LOINC" displayName="Intravascular Systolic"/>
																		<text>
																		<reference value="#vit'.$countreBp.'"/>
																				</text>
																				<statusCode code="completed"/>
																				'.$effectiveBPDate.'
																						<value xsi:type="PQ" value="'.$systolic.'" unit="mm[Hg]"/>
																								<interpretationCode code="N" codeSystem="2.16.840.1.113883.5.83"
																								/>
																								</observation>
																								</component>
																								<component>
																								<observation classCode="OBS" moodCode="EVN">
																								<templateId root="2.16.840.1.113883.10.20.22.4.27" />
																								<id root="c6f88321-67ad-11db-bd13-0800200c9a66" extension="1104" />
																								<code code="8462-4"  codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC" displayName="Intravascular Diastolic"/>
																								<text><reference value="#vit'.$countreBp.'" />
																										</text><statusCode code="completed" />
																										'.$effectiveBPDate.'
																												<value xsi:type="PQ" value="'.$diastolic.'" unit="mm[Hg]" />
																														<interpretationCode code="N" codeSystem="2.16.840.1.113883.5.83" />
																														</observation>
																														</component>
																														<component>
																														<observation classCode="OBS" moodCode="EVN">
																														<templateId root="2.16.840.1.113883.10.20.22.4.27" />
																														<id root="c6f88321-67ad-11db-bd13-0800200c9a66" extension="1105" />
																														<code code="41909-3"  codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC" displayName="Body Mass Index" />
																														<text><reference value="#vit'.$countreBmi.'" /></text>
																																<statusCode code="completed" />
																																'.$effectiveVitalDate.'
																																		<value xsi:type="PQ" value="'.$bmi.'" unit="Kg/m.sq.;" />
																																				<interpretationCode code="N" codeSystem="2.16.840.1.113883.5.83" /></observation>
																																				</component>
																																					
																																				</organizer>
																																				</entry>';
		$countreHt++;
		$countreWt++;
		$countreBp++;
		$countreBmi++;
		//	}

		//$strvital .=  "<tr>".$medText1."</tr>" ;
		if(trim($medText1) == ""){
			$strvital .='<tr><td></td><td></td><td></td><td></td><td></td></tr>';
		}else{
			$strvital .=  "<tr>".$medText1."</tr>" ;
		}
		$strvital .= '</tbody></table></text>';
		$strvital .=  $vitalXml ;
		$strvital .='</section>';
		$strvital .=' </component>';
		return $strvital;
	}


	//==========end=========<templateId root="2.16.840.1.113883.10.20.2.8"/>
	public function chiefComplaints($id){
		$note = ClassRegistry::init('Note');
		
		$chiefData=$note->find('first',array('fields'=>array('cc','id'),'conditions'=>array('Note.patient_id'=>$id),'order'=>array('Note.id Desc')));
		
		$chief.='<component>
				<section>				
				<templateId root="2.16.840.1.113883.10.20.22.2.13"/>				
				<!-- ** Chief Complaints Section Template ** -->
				<code codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC" code="15450"
				displayName="CHIEF COMPLAINTS"/>
				<title>CHIEF COMPLAINTS</title>
				<text>
				<paragraph>'.$chiefData['Note']['cc'].'</paragraph>
						</text>
						</section>
						</component>';
		
		return $chief;
		

	}

	public function autoGeneratedCcrID($id=null){

		$unique_id = rand(0,100000);
		$get_unique_id="CCDA".$unique_id;

		return $get_unique_id ;

	}

	public function customStrtoTime($date=null,$format=null){
			
		/* if($format == ""){
			$format = Configure::read('date_format');
		} */
		
		if(strpos($date,"-")=== false ) $format =  Configure::read('date_format'); 
		else $format ="yyyy-mm-dd";
		
		$convertedDate   = DateFormatComponent::formatDate2STD($date,$format) ;
		return strtotime($convertedDate) ;
	}
	
	public function customStrtoDate($date=null, $formate="Ymd"){
			
		$convertedDate   = date($formate , $date) ;
	
		return $convertedDate ;
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
	function  diagnosticTestsPending($id) {
		$laboratoryTestOrder = ClassRegistry::init('LaboratoryTestOrder');

		$laboratoryTestOrder->unBindModel(array('belongsTo'=>array('LaboratoryToken')));
		$laboratoryTestOrder->bindModel(array(
				'belongsTo' => array(
						'Laboratory'=>array('foreignKey'=>'laboratory_id'),
				 		'LaboratoryResult'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.laboratory_test_order_id=LaboratoryTestOrder.id'),'type'=>'RIGHT'))));

			
		$labResult= $laboratoryTestOrder->find('all',array('conditions'=>array('LaboratoryTestOrder.patient_id'=>$id,'LaboratoryTestOrder.is_deleted'=>0,
				'LaboratoryTestOrder.start_date <= '=>date('Y-m-d')),'fields'=>array('Laboratory.name','LaboratoryTestOrder.laboratory_id','LaboratoryTestOrder.start_date')));
		$diagnostic.='<component>';
		$diagnostic.='<section>
		
				<templateId root="2.16.840.1.113883.10.20.22.2.3.2"/>
				<!-- Entries Required -->
				<code code="30954-2" codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC"
				displayName="DIAGNOSTIC TESTS PENDING"/>
				<title>DIAGNOSTIC TESTS PENDING</title>
				<text>
				<table border="1" width="100%">
				<thead>
				<tr>
				<th>Diagnostic Tests Pending</th>
				</tr>
				</thead>
				<tbody>';
		 
		if(!empty($labResult)){
				foreach ($labResult as $labKey => $labValue){
					$immuTimestamp = $this->customStrtoTime($labValue['LaboratoryTestOrder']['start_date']);
					$pendingDate=$this->customStrtoDate($immuTimestamp, "d F Y");
					$diagnostic .= '<tr><td>'.$labValue['Laboratory']['name'].'('.$pendingDate.')</td></tr>' ;
				}		
		}else{
			$diagnostic .= '<tr><td></td></tr>';
		}
			$diagnostic.=	'</tbody>
				</table>
				</text>
				</section>
				</component>';
		return $diagnostic;
	}
	
	function  futureScheduledTests($id) {
		$laboratoryTestOrder = ClassRegistry::init('LaboratoryTestOrder');
		$radiologyTestOrder  = ClassRegistry::init('RadiologyTestOrder');
		$procedurePerform  = ClassRegistry::init('ProcedurePerform');
		
		$laboratoryTestOrder->unBindModel(array('belongsTo'=>array('LaboratoryToken')));
		$laboratoryTestOrder->bindModel(array(
				'belongsTo' => array(
						'Laboratory'=>array('foreignKey'=>'laboratory_id'))));
		
		
		$labData = $laboratoryTestOrder->find('all',array('conditions'=>array('LaboratoryTestOrder.patient_id'=>$id,'LaboratoryTestOrder.is_deleted'=>0,
								'LaboratoryTestOrder.start_date > '=>date('Y-m-d')),'fields'=>array('Laboratory.name','LaboratoryTestOrder.laboratory_id','LaboratoryTestOrder.start_date')));
		

		$radiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('type'=>'inner','foreignKey'=>'radiology_id'),
				)));
		
		$radiologyTestOrderData= $radiologyTestOrder->find('all',array(
				'conditions'=>array('RadiologyTestOrder.patient_id'=>$id,'RadiologyTestOrder.is_deleted'=>0,'RadiologyTestOrder.start_date >'=>date('Y-m-d')
				)));
		
		$procedureData= $procedurePerform->find('all',array('fields'=> array('procedure_name','snowmed_code','procedure_date'),
				'conditions'=>array('ProcedurePerform.patient_id'=>$id,'ProcedurePerform.procedure_date >'=>date('Y-m-d'))));

		$future.='<component>';
		$future.='<section>
		
				<templateId root="2.16.840.1.113883.10.20.22.2.3.3"/>
				<!-- Entries Required -->
				<code code="30954-2" codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC"
				displayName="FUTURE SCHEDULED TESTS"/>
				<title>FUTURE SCHEDULED TESTS</title>
				<text>
					<table border="1" width="100%">
					<thead>
					<tr>
						<th>Scheduled Lab Tests</th>
						<th>Scheduled Imaging </th>
						<th>Scheduled Procedures</th>
					</tr>
					</thead>
				<tbody>
				<tr> '; 
		$labList = "<td>" ;
		foreach ($labData as $labKey =>$labValue){  
			$immuTimestamp = $this->customStrtoTime($labValue['LaboratoryTestOrder']['start_date']);
			$futureDate=$this->customStrtoDate($immuTimestamp, "d F Y"); 
			$labName=$labValue['Laboratory']['name']; 
			$table = $this->get_html_translation_table_CP1252();
			$replaceStr = strtr($labName,$table) ; 
			$labList .= $replaceStr.'('.$futureDate.')<br/>';
		}
	 
		$radiology = "</td><td>" ;
		foreach ($radiologyTestOrderData as $radKey =>$radValue){
			$immuTimestamp = $this->customStrtoTime($radValue['RadiologyTestOrder']['start_date']);
			$futureRadioDate=$this->customStrtoDate($immuTimestamp, "d F Y");  
			$radioName=$radValue['Radiology']['name']; 
			$table = $this->get_html_translation_table_CP1252();
			$replaceRadioStr = strtr($radioName,$table) ; 
			$radiology .=   $replaceRadioStr.'('.$futureRadioDate.')<br/>'; ;
				
		}
		$procedure = "</td><td>" ;
		foreach ($procedureData as $procedureKey =>$procedureValue){
			$immuTimestamp = $this->customStrtoTime($procedureValue['ProcedurePerform']['procedure_date']);
			$futureProcedureDate=$this->customStrtoDate($immuTimestamp, "d F Y");
			
			$proName=$procedureValue['ProcedurePerform']['procedure_name'];
			 
			$table = $this->get_html_translation_table_CP1252();
			$replaceProStr = strtr($proName,$table) ; 
			
			$procedure .=  $replaceProStr.'('.$futureProcedureDate.')<br/>';
		} 
		$procedure .= "</td>" ;
		
		$future .= $labList.$radiology.$procedure ;
		
		 
		$future .=' </tr>
				</tbody>
				</table>
				</text>
				</section>
				</component>';
		return $future;
	}
	function  recommendedPatient($id) {
		$note = ClassRegistry::init('Note');
		$note->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>false,
								'conditions'=>array('Patient.id = Note.patient_id'),'group'=>'patient_id'),
				)));
		
		$result =$note->find('first',array('fields'=> array('decision_aids','modify_time'),
				'conditions'=>array('Patient.id'=>$id),'group'=>'Note.patient_id asc'));
		
		$recoTimestamp = $this->customStrtoTime($result['Note']['modify_time']);
		$recommendedDate=$this->customStrtoDate($recoTimestamp, "Y");
		//<templateId root="2.16.840.1.113883.10.20.22.2.20"/>
		//<code codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC" code="11348-0"
		$recommendedAids .='<component>
		<section xmlns="urn:hl7-org:v3"> 
		<templateId root="2.16.840.1.113883.10.20.22.2.12"/>
		<!-- ** Reason for Referral Section Template ** -->
		<code codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC" code="29299-5"
				displayName="Recommended Patient Decision Aids"/>
						<title>RECOMMENDED PATIENT DECISION AIDS</title>
						<text>
						<paragraph>'.nl2br($result['Note']['decision_aids']).'</paragraph>
						</text>
					<entry>
					<act classCode="ACT" moodCode="EVN">
					  <id root="MDHT" extension="321313773"/>
					  <code code="1666565892"/> 
					  <effectiveTime>
						<low value="'.$recommendedDate.'"/>
						<high nullFlavor="UNK" />
					  </effectiveTime>
					</act>
				  </entry>
						</section>
						</component>';
		return $recommendedAids ;
	
	}
	
	function referralToOtherProviders($id){
		$raferral = ClassRegistry::init('PatientReferral');
		$getData =$raferral->find('all',array('fields'=> array('complaints','dr_name','doctor_detail','date_of_issue'),'conditions'=>array('PatientReferral.patient_id'=>$id)));
		
		$referralToOtherProviders .='<component>
		<section>
		<templateId root="1.3.6.1.4.1.19376.1.5.3.1.3.1"/>
		<!-- ** Referral To Other Providers Section Template ** -->
		<code codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC" code="42349-1"
				displayName="Referral To Other Providers"/>
						<title>REFERRAL TO OTHER PROVIDERS</title>';
				foreach($getData as $key => $displayData){
					
					$immuTimestamp = $this->customStrtoTime($displayData['PatientReferral']['date_of_issue']);
					$referralDate=$this->customStrtoDate($immuTimestamp, "d F Y");
					
	$referralToOtherProviders .='<text><paragraph>Dr. '.$displayData['PatientReferral']['dr_name'].' '.$displayData['PatientReferral']['doctor_detail'].' on '.$referralDate.'</paragraph></text>';
			}
					$referralToOtherProviders .='	</section>
						</component>';
		
		return  $referralToOtherProviders ;
		
	}
	
	function futureAppointment($id){
		$appointment = ClassRegistry::init('Appointment');
		$user = ClassRegistry::init('User');
		$dateFormat  = new DateFormatComponent();
		$session = new cakeSession();
		$appointment->bindModel(array('belongsTo' => array(  
						'User' => array('foreignKey'   => false,'conditions'=>array('User.id=Appointment.appointment_with')),
		)));
		
		$appointment->virtualFields = array(
				'full_name' => 'CONCAT(User.first_name," ", User.last_name)'
		);
		$appointmentResult = $appointment->find('all',array('conditions'=>array('Appointment.patient_id'=>$id,'Appointment.is_deleted'=>0,'Appointment.is_future_app' => 1),
															'fields'=>array('full_name','Appointment.date'))) ;
		
		//Dr. Henry Seven, 1007 Healthcare Dr., Portland, OR 99123 on
		//Test Date + 3 weeks
		foreach ($appointmentResult as $appKey => $appValue) {		 
			//echo Configure::read('date_format') ;
			$appTimestamp = $this->customStrtoTime($appValue['Appointment']['date']);
			$appDate=$this->customStrtoDate($appTimestamp, "d F Y");
			
			$completeStr .= '<paragraph>Dr. ' ;
		 	$fullName = $appValue['Appointment']['full_name'] ;
			$hospitalAddress = $session->read('Auth.User.address1')." , ".$session->read('Auth.User.zipcode') ; 
			$date = " on ".$appDate;
			$completeStr .=  $fullName.$hospitalAddress.$date  ;
			$completeStr .= '</paragraph>' ;
		}
		
		$appointmentHtml .='<component>
		<section>
		<templateId root="1.3.6.1.4.1.19376.1.5.3.1.3.1.1.2.3"/>
		<!-- ** Future appointment Section Template ** -->
		<code codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC" code="42349-1"
				displayName="future appointments"/>
						<title>FUTURE APPOINTMENT</title>
						<text>'.$completeStr.'</text>
						</section>
						</component>';
		
		return  $appointmentHtml ; 
	}
	
}
?>