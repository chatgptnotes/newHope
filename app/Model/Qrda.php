<?php 
App::uses('AppModel', 'Model');
/**
 * Qrda Model file
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
class Qrda extends AppModel {

	public $name = 'Qrda';
	public $uses = array('Qrda');
	public $specific = true;

	public function qrdaHeader($f_name=null){
		if($f_name=='Controlling High Blood Presure'){
			$measure_id='0018';
		}
		if($f_name=='Use of Imageing studies for Low Back Pain'){
			$measure_id='0052';
		}
		if($f_name=='Documentation of current Medications in the Medical Record'){
			$measure_id='0419';
		}
		if($f_name=='Prevention Care and Screeing Tobacco Use Screening and Cessation Intervention'){
			$measure_id='0028';
			//debug($measure_id);
			//exit;
		}
		if($f_name=='Prevention Care and Screeing Screeningfor Clinical Depression and Follow-up Plan'){
			$measure_id='0418';
		}
		if($f_name=='Prevention Care and Screeing Body Mass Index Screening and Flow-UpA'){
			$measure_id='0421';
		}
		if($f_name=='Prevention Care and Screeing Body Mass Index Screening and Flow-UpB'){
			$measure_id='0421';
		}
		if($f_name=='Pregnant women that has HBsAg testing'){
			$measure_id='0421';
		}
		if($f_name=='Use of High-Risk Medications in the Elderly'){
			$measure_id='0421';
		}
		if($f_name=='Controlling High Blood Presure'){
			$measure_id='0421';
		}
		$Doctime = date("Ymd");
		//$zone = "-0000" ;//$session->read('timezone');

		//$createdTime=date ("Ymd" , $Doctime  );

		$strHeader.='<?xml version="1.0" encoding="utf-8"?>
				<?xml-stylesheet type="text/xsl" href="qrda.xsl"?>
				<ClinicalDocument xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
				xsi:schemaLocation="urn:hl7-org:v3 ../../CDASchema/CDA.xsd" xmlns="urn:hl7-org:v3"
				xmlns:voc="urn:hl7-org:v3/voc">
				<!--
				Title: Example Category III Sample File
				Original Filename: CDAR2_IG_QRDA_CATIII_RI_NOV.xml
				Version: 1.0
				Revision History:
				11/27/2012 Release date

				Description: This sample file was developed to show the various types of measure scoring as currently used in HQMF eMeasures,
				including proportion and continuous variable. The two measures used as examples are
				NQF 0436: Anticoagulation Therapy for Atrial Fibrillation/Flutter, a proportion eMeasure
				NQF 0496: Median Time from ED Arrival to ED Departure for Discharged ED Patients, a continuous variable eMeasure

				-->
				<!--
				********************************************************
				CDA Header
				********************************************************
				-->
				<realmCode code="US"/>
				<typeId root="2.16.840.1.113883.1.3" extension="POCD_HD000040"/>
				<!-- QRDA Category III Release 1 template ID  -->
				<templateId root="2.16.840.1.113883.10.20.27.1.1"/>
				<id root="26a42253-99f5-48e7-9274-b467c6c7f623"/>
				<!-- SHALL QRDA III document type code -->
				<code code="55184-6" codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC"
				displayName="Quality Reporting Document Architecture Calculated Summary Report"/>
				<!-- SHALL Title, content optional -->
				<title>QRDA Calculated Summary Report NQF "'.$measure_id.'"</title>
						<!-- SHALL  -->

						<effectiveTime value="'.$Doctime.'"/>
								<confidentialityCode codeSystem="2.16.840.1.113883.5.25" code="N"/>
								<languageCode code="en-US"/>
								<!-- SHOULD The version of the file being submitted. -->
								<versionNumber value="1"/>
								<!-- SHALL contain recordTarget and ID - but ID is nulled to NA. This is an aggregate summary report. Therefore CDA required patient identifier is nulled. -->
								<recordTarget>
								<patientRole>
								<id nullFlavor="NA"/>
								</patientRole>
								</recordTarget>
								<!-- SHALL have 1..* author. SHALL have at least one device and/or one person.
								The author of the CDA document in this element is a device. -->
								<author>
								<time value="20120811"/>
								<assignedAuthor>
								<!-- author ID. This may be an NPI, or any other type of ID. -->
								<id root="2.16.840.1.113883.4.6" extension="111111111" assigningAuthorityName="NPI"/>
								<assignedAuthoringDevice>
								<softwareName></softwareName>
								</assignedAuthoringDevice>
								<representedOrganization>
								<!-- The organization id is optional, but the name is required -->
								<id root="2.16.840.1.113883.19.5" extension="98765"/>
								<name>DrmHope Software</name>
								</representedOrganization>
								</assignedAuthor>
								</author>
								<!-- person author example -->
								<author>
								<time value="20050329224411+0500"/>
								<assignedAuthor>
								<!-- author ID. This may be an NPI, or any other type of ID. -->
								<id root="2.16.840.1.113883.4.6" extension="111111112" assigningAuthorityName="NPI"/>
								<assignedPerson>
								<name>
								<given></given>
								<family></family>
								</name>
								</assignedPerson>
								<representedOrganization>
								<!-- The organization id is optional -->
								<id root="2.16.840.1.113883.19.5" extension="5454545"/>
								<name>DrmHope Software</name>
								</representedOrganization>
								</assignedAuthor>
								</author>
								<!-- The custodian of the CDA document is the same as the legal authenticator in this
								example and represents the reporting organization. -->
								<!-- SHALL -->
								<custodian>
								<assignedCustodian>
								<representedCustodianOrganization>
								<!-- SHALL have an id - This is an example root -->
								<id root="2.16.840.1.113883.19.5"/>
								<!-- SHOULD Name not required -->
								<name>DrmHope Software</name>
								</representedCustodianOrganization>
								</assignedCustodian>
								</custodian>
								<!-- The legal authenticator of the CDA document is a single person who is at the
								same organization as the custodian in this example. This element must be present. -->
								<!-- SHALL -->
								<legalAuthenticator>
								<!-- SHALL -->
								<time value="20120811"/>
								<!-- SHALL -->
								<signatureCode code="S"/>
								<assignedEntity>
								<!-- SHALL ID -->
								<id root="bc01a5d1-3a34-4286-82cc-43eb04c972a7"/>
								<!-- SHALL -->
								<representedOrganization>
								<!-- SHALL Id -->
								<!-- example root -->
								<id root="2.16.840.1.113883.19.5"/>
								<!-- SHOULD Name not required -->
								<name>DrmHope Software</name>
								</representedOrganization>
								</assignedEntity>
								</legalAuthenticator>
								<!-- MAY - Device Participant Medical Record Device
								EHR Certification Number, represented by RGPR = regulated product: A product regulated by some governmental orgnization.  -->
								<participant typeCode="DEV">
								<associatedEntity classCode="RGPR">
								<!-- SHALL have at least one id, form can vary -->
								<!-- if the EHR has an ONC certification number, SHOULD use it here -->
								<id root="2.16.840.1.113883.3.2074.1" extension="1a2b3c" assigningAuthorityName="ONC"/>
								<!-- if the EHR has a CMS Security Code, MAY use it here -->
								<id root="2.16.840.1.113883.3.249.21" extension="98765"/>
								<code code="129465004" displayName="medical record, device"
								codeSystem="2.16.840.1.113883.6.96" codeSystemName="SNOMED-CT"/>
								</associatedEntity>
								</participant>
								<!-- MAY: information about the service provider -->
								<documentationOf typeCode="DOC">
								<serviceEvent classCode="PCPR">
								<!-- care provision -->
								<effectiveTime>
								<low value="20120601"/>
								<high value="20120915"/>
								</effectiveTime>
								<!-- You can include multiple performers, each with optional NPI, TIN, CCN. -->
								<performer typeCode="PRF">
								<time>
								<low value="20120101"/>
								<high value="20120331"/>
								</time>
								<assignedEntity>
								<!-- SHALL contain at least one id -->
								<!-- This is the optional provider NPI -->
								<id root="2.16.840.1.113883.4.6" extension="111111111"
								assigningAuthorityName="NPI"/>
								<!-- MAY: The email address of the provider data submitted -->
								<telecom value="mailto:user@hostname"/>
								<representedOrganization>
								<!-- This is the optional organization TIN -->
								<id root="2.16.840.1.113883.4.2" extension="1234567"
								assigningAuthorityName="TIN"/>
								<!-- This is the optional organization CCN -->
								<id root="2.16.840.1.113883.4.336" extension="54321"
								assigningAuthorityName="CCN"/>
								</representedOrganization>
								</assignedEntity>
								</performer>
								</serviceEvent>
								</documentationOf>
								<!--   MAY: participation waiver indicates the eligible professional has given the DSV (data submission vendor)
								permission to submit data on their behalf-->
								<authorization>
								<consent>
								<id root="84613250-e75e-11e1-aff1-0800200c9a66"/>
								<!-- SHALL single value binding -->
								<code code="425691002" displayName="consent given for electronic record sharing"
								codeSystem="2.16.840.1.113883.6.96" codeSystemName="SNOMED-CT"/>
								<statusCode code="completed"/>
								</consent>
								</authorization>';
		return $strHeader;

	}
	public function qrdaBody($doc_id=null,$type=null,$startdate=null,$enddate=null){
		$qrdaHeader=$this->consolidated_header($doc_id,$type,$startdate,$enddate);
		$qrdabody=$this->consolidated_Ep_Measure($doc_id,$type);
		//$strBody.='<component><structuredBody>';
		//$reportingParameters=$this->reportingParameters($s_date,$e_date);
		//$measureSection=$this->measureSection($num,$deno,$f_name);
		$qrdafooter.='</section>
				</component>
				</structuredBody>
				</component>
				</ClinicalDocument>';

		$body=$qrdaHeader.$qrdabody.$qrdafooter;

		$ourFileName = "files/note_xml/"."DrmHope_".$type."_".$doc_id."_qrda3".".xml";

		$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
		fwrite($ourFileHandle, $body);
		fclose($ourFileHandle);

	}
	//======================================EH qrda Body==============================================================================================================================
	public function eh_qrdaBody($ehdata=null,$sdate=null,$e_date=null){
		$type="EH";
		$qrdaHeader=$this->eh_consolidated_header($type,$sdate,$e_date);
		$qrdabody=$this->consolidated_EH_Measure($ehdata);
		/* debug($qrdabody);
		exit; */
		//$strBody.='<component><structuredBody>';
		//$reportingParameters=$this->reportingParameters($s_date,$e_date);
		//$measureSection=$this->measureSection($num,$deno,$f_name);
		$qrdafooter.='</section>
				</component>
				</structuredBody>
				</component>
				</ClinicalDocument>';

		$body=$qrdaHeader.$qrdabody.$qrdafooter;

		$ourFileName = "files/note_xml/"."DrmHope_".$type."_qrda3".".xml";

		$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
		fwrite($ourFileHandle, $body);
		fclose($ourFileHandle);

	}
	//=================================================================================================================================================================================
	public function qrdaContinuousBody(){
		$qrdaHeader=$this->qrdaHeader();
		$strBody.='<component>
				<structuredBody>';
		$reportingParameters=$this->reportingParameters();
		$measureSection=$this->measureSectionContinuous();
		$strBody1.='</structuredBody>
				</component>
				</ClinicalDocument>';

		$body=$qrdaHeader.$strBody. $reportingParameters. $measureSection.$strBody1;

		$ourFileName = "files/note_xml/".Qrda_Continuous.".xml";

		$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
		fwrite($ourFileHandle, $body);
		fclose($ourFileHandle);

	}
	public function consolidated_header($doc=null,$type=null,$start_date=null,$end_date=null){
		$CqmReport = ClassRegistry::init('CqmReport');
		$CqmList = ClassRegistry::init('CqmList');
		$recive_entry=$CqmReport->find('all',array('conditions'=>array('doctor_id'=>$doc,'measure_type'=>$type)));
		$tsr="";
		$tsr1="";
		$cnt=0;
		$mycnt=0;
$today=Date('Y-m-d');
$today=explode('-',Date('Y-m-d'));
$today1=$today[0].$today[1].$today[2];
$s_date=explode('-',$start_date);
$s_date=$s_date[2]."/".$s_date[1]."/".$s_date[0];
$e_date=explode('-',$end_date);
$e_date=$e_date[2]."/".$e_date[1]."/".$e_date[0];

		$tsr1='<?xml version="1.0"  encoding="utf-8"?>
				<?xml-stylesheet type="text/xsl" href="qrda.xsl"?>
				<ClinicalDocument xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
				xsi:schemaLocation="urn:hl7-org:v3 ../../CDASchema/CDA.xsd" xmlns="urn:hl7-org:v3"
				xmlns:voc="urn:hl7-org:v3/voc">
				<realmCode code="US" />
				<typeId root="2.16.840.1.113883.1.3" extension="POCD_HD000040" />
				<templateId root="2.16.840.1.113883.10.20.27.1.1" />
				<id root="19149370-10CA-11E3-A304-4F5CFDE95199" />
				<code code="55184-6" codeSystem="2.16.840.1.113883.6.1"
				codeSystemName="LOINC"
				displayName="Quality Reporting Document Architecture Calculated Summary Report" />
				<title>QRDA Calculated Summary Report for NQF0018
				NQF0419,
				NQF0421,
				NQF0028,
				NQF0022,
				NQF0608,
				NQF0018,
				NQF0052
				</title>
				<effectiveTime value="'.$today1.'" />
				<confidentialityCode code="N" codeSystem="2.16.840.1.113883.5.25" />
				<languageCode code="en-US" />
				<recordTarget>
				<patientRole>
				<id nullFlavor="NA" />
				</patientRole>
				</recordTarget>
				<author>
				<time value="'.$today1.'" />
				<assignedAuthor>
				<id extension="DWM" />
				<assignedAuthoringDevice>
				<softwareName>DrmHope Softwares</softwareName>
				</assignedAuthoringDevice>
				<representedOrganization>
				<id extension="DWM" />
				<name>DrmHope Softwares Qrda Cat-3</name>
				</representedOrganization>
				</assignedAuthor>
				</author>
				<custodian>
				<assignedCustodian>
				<representedCustodianOrganization>
				<id extension="DWM" />
				<name>DrmHope Softwares Qrda Cat-3</name>
				</representedCustodianOrganization>
				</assignedCustodian>
				</custodian>
				<legalAuthenticator>
				<time value="'.$today1.'" />
				<signatureCode code="S" />
				<assignedEntity>
				<id nullFlavor="NI" />
				<representedOrganization>
				<id extension="DWM" />
				<name>DrmHope Softwares Qrda Cat-3</name>
				</representedOrganization>
				</assignedEntity>
				</legalAuthenticator>
				<component>
				<structuredBody>
				<component>
				<section>
				<templateId root="2.16.840.1.113883.10.20.17.2.1" />
				<templateId root="2.16.840.1.113883.10.20.27.2.2" />
				<code code="55187-9" codeSystem="2.16.840.1.113883.6.1" />
				<title>Reporting Parameters</title>
				<text>
				<list>
				<item>Reporting Period: '.$s_date.' - '.$e_date.'</item>
				</list>
				</text>
				<entry typeCode="DRIV">
				<act classCode="ACT" moodCode="EVN">
				<templateId root="2.16.840.1.113883.10.20.17.3.8" />
				<id root="1914F838-10CA-11E3-A304-4F5CFDE95199" />
				<code code="252116004" codeSystem="2.16.840.1.113883.6.96"
				displayName="Observation Parameters" />
				<effectiveTime xsi:type="IVL_TS">
				<low value="20120101" />
				<high value="20121212" />
				</effectiveTime>
				</act>
				</entry>
				</section>
				</component>
				<component>
				<section>
				<templateId root="2.16.840.1.113883.10.20.24.2.2" />
				<templateId root="2.16.840.1.113883.10.20.27.2.1" />
				<code code="55186-1" codeSystem="2.16.840.1.113883.6.1"
				displayName="measure section" />
				<title>Measure Section</title>
				<text>';
		foreach($recive_entry as $recive_enrtries){
			$cnt++;

				

			$moredata=$CqmList->find('all',array('conditions'=>array('nqf_number'=>$recive_enrtries['CqmReport']['measure_id'])));
				
			$str.='<table border="1" width="100%">
					<thead>
					<tr>
					<th>eMeasure Title</th>
					<th>Version neutral identifier</th>
					<th>eMeasure Version Number</th>
					<th>NQF eMeasure Number</th>
					<th>eMeasure Identifier (MAT)</th>
					<th>Version specific identifier</th>
					</tr>
					</thead>
					<tbody>
					<tr>
					<td>'.$moredata[$mycnt]['CqmList']['title'].'</td>
							<td>'.$moredata[$mycnt]['CqmList']['guid'].'</td>
									<td>'.$moredata[$mycnt]['CqmList']['emeasure_version_no'].'</td>
											<td>'.$moredata[$mycnt]['CqmList']['nqf_number'].'</td>
													<td>'.$moredata[$mycnt]['CqmList']['emeasure_identifier'].'</td>
															<td>'.$moredata[$mycnt]['CqmList']['measure_rootid'].'</td>
																	</tr>
																	</tbody>
																	</table>
																	<list>
																	<item>
																	<content styleCode="Bold">Initial Patient Population</content>
																	:'.$recive_enrtries[CqmReport][ipp_count].'
																			<list>
																			<item>
																			<content styleCode="Bold">American Indian or Alaska Native
																			</content>
																			: '.$recive_enrtries[CqmReport][race_count].'
																					</item>
																					<item>
																					<content styleCode="Bold">Not Hispanic or Latino</content>
																					:'.$recive_enrtries[CqmReport][ethnicity_count].'
																							</item>
																							<item>
																							<content styleCode="Bold">Male</content>
																							:'.$recive_enrtries[CqmReport][male_count].'
																									</item>
																									<item>
																									<content styleCode="Bold">Female</content>
																									:'.$recive_enrtries[CqmReport][female_count].'
																											</item>
																											</list>
																											</item>
																											<item>
																											<content styleCode="Bold">Denominator</content>
																											: '.$recive_enrtries[CqmReport][ipp_count].'
																													<list>

																													<item>
																													<content styleCode="Bold">American Indian or Alaska Native
																													</content>
																													:  '.$recive_enrtries[CqmReport][race_count].'
																															</item>
																															<item>
																															<content styleCode="Bold">Not Hispanic or Latino</content>
																															: '.$recive_enrtries[CqmReport][ethnicity_count].'
																																	</item>
																																	<item>
																																	<content styleCode="Bold">Male</content>
																																	: '.$recive_enrtries[CqmReport][male_count].'
																																			</item>
																																			<item>
																																			<content styleCode="Bold">Female</content>
																																			:'.$recive_enrtries[CqmReport][female_count].'
																																					</item>
																																					</list>
																																					</item>
																																					<item>
																																					<content styleCode="Bold">Numerator</content>
																																					: '.$recive_enrtries[CqmReport][numerator].'
																																							<list>
																																							<item>
																																							<content styleCode="Bold">American Indian or Alaska Native
																																							</content>
																																							: '.$recive_enrtries[CqmReport][num_race].'
																																									</item>
																																									<item>
																																									<content styleCode="Bold">Not Hispanic or Latino</content>
																																									: '.$recive_enrtries[CqmReport][num_ethnicity].'
																																											</item>
																																											<item>
																																											<content styleCode="Bold">Male</content>
																																											:'.$recive_enrtries[CqmReport][num_male].'
																																													</item>
																																													<item>
																																													<content styleCode="Bold">Female</content>
																																													:'.$recive_enrtries[CqmReport][num_female].'
																																															</item>
																																															</list>
																																															</item>
																																															<item>
																																															<content styleCode="Bold">Denominator Exclusions</content>
																																															:'.$recive_enrtries[CqmReport][den_exclusion].'
																																																	</item>
																																																	<item>
																																																	<content styleCode="Bold">Denominator Exceptions</content>
																																																	: '.$recive_enrtries[CqmReport][den_exception].'
																																																			</item>
																																																			</list>';
				
		}
		return $tsr1.$str.'</text>';
	}
	//===============================================================EH consolidated header===============================================================================================================
	public function eh_consolidated_header($type=null,$start_date=null,$end_date=null){
	$CqmReportEh = ClassRegistry::init('CqmReportEh');
		$CqmList = ClassRegistry::init('CqmList');
		$recive_entry=$CqmReportEh->find('all');
		$tsr="";
		$tsr1="";
		$strED="";
		$cnt=0;
		$mycnt=0;
$today=Date('Y-m-d');
$today=explode('-',Date('Y-m-d'));
$today1=$today[0].$today[1].$today[2];
$s_date=explode('-',$start_date);
$s_date=$s_date[2]."/".$s_date[1]."/".$s_date[0];
$e_date=explode('-',$end_date);
$e_date=$e_date[2]."/".$e_date[1]."/".$e_date[0];

		$tsr1='<?xml version="1.0"  encoding="utf-8"?>
				<?xml-stylesheet type="text/xsl" href="qrda.xsl"?>
				<ClinicalDocument xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
				xsi:schemaLocation="urn:hl7-org:v3 ../../CDASchema/CDA.xsd" xmlns="urn:hl7-org:v3"
				xmlns:voc="urn:hl7-org:v3/voc">
				<realmCode code="US" />
				<typeId root="2.16.840.1.113883.1.3" extension="POCD_HD000040" />
				<templateId root="2.16.840.1.113883.10.20.27.1.1" />
				<id root="19149370-10CA-11E3-A304-4F5CFDE95199" />
				<code code="55184-6" codeSystem="2.16.840.1.113883.6.1"
				codeSystemName="LOINC"
				displayName="Quality Reporting Document Architecture Calculated Summary Report" />
				<title>QRDA Calculated Summary Report for NQF0371_VTE1, NQF0372_VTE2,
				NQF0373_VTE3, NQF0374_VTE4, NQF0375_VTE5, NQF0376_VTE6,
				NQF0435_Stroke02, NQF0436_Stroke03, NQF0437_Stroke04,
				NQF0438_Stroke05, NQF0439_Stroke06, NQF0440_Stroke08,
				NQF0441_Stroke10, NQF0495_ED1, NQF0496_ED3, NQF0497_ED2
				</title>
				<effectiveTime value="'.$today1.'" />
				<confidentialityCode code="N" codeSystem="2.16.840.1.113883.5.25" />
				<languageCode code="en-US" />
				<recordTarget>
				<patientRole>
				<id nullFlavor="NA" />
				</patientRole>
				</recordTarget>
				<author>
				<time value="'.$today1.'" />
				<assignedAuthor>
				<id extension="DWM" />
				<assignedAuthoringDevice>
				<softwareName>DrmHope Softwares</softwareName>
				</assignedAuthoringDevice>
				<representedOrganization>
				<id extension="DWM" />
				<name>DrmHope Softwares Qrda Cat-3</name>
				</representedOrganization>
				</assignedAuthor>
				</author>
				<custodian>
				<assignedCustodian>
				<representedCustodianOrganization>
				<id extension="DWM" />
				<name>DrmHope Softwares Qrda Cat-3</name>
				</representedCustodianOrganization>
				</assignedCustodian>
				</custodian>
				<legalAuthenticator>
				<time value="'.$today1.'" />
				<signatureCode code="S" />
				<assignedEntity>
				<id nullFlavor="NI" />
				<representedOrganization>
				<id extension="DWM" />
				<name>DrmHope Softwares Qrda Cat-3</name>
				</representedOrganization>
				</assignedEntity>
				</legalAuthenticator>
				<component>
				<structuredBody>
				<component>
				<section>
				<templateId root="2.16.840.1.113883.10.20.17.2.1" />
				<templateId root="2.16.840.1.113883.10.20.27.2.2" />
				<code code="55187-9" codeSystem="2.16.840.1.113883.6.1" />
				<title>Reporting Parameters</title>
				<text>
				<list>
				<item>Reporting Period: '.$s_date.' - '.$e_date.'</item>
				</list>
				</text>
				<entry typeCode="DRIV">
				<act classCode="ACT" moodCode="EVN">
				<templateId root="2.16.840.1.113883.10.20.17.3.8" />
				<id root="1914F838-10CA-11E3-A304-4F5CFDE95199" />
				<code code="252116004" codeSystem="2.16.840.1.113883.6.96"
				displayName="Observation Parameters" />
				<effectiveTime xsi:type="IVL_TS">
				<low value="20120101" />
				<high value="20121212" />
				</effectiveTime>
				</act>
				</entry>
				</section>
				</component>
				<component>
				<section>
				<templateId root="2.16.840.1.113883.10.20.24.2.2" />
				<templateId root="2.16.840.1.113883.10.20.27.2.1" />
				<code code="55186-1" codeSystem="2.16.840.1.113883.6.1"
				displayName="measure section" />
				<title>Measure Section</title>
				<text>';
		foreach($recive_entry as $recive_enrtries){
			$cnt++;
			$moredata=$CqmList->find('all',array('conditions'=>array('nqf_number'=>$recive_enrtries['CqmReportEh']['measure_id'])));
			//debug($moredata);
			//exit;
			if($moredata[$mycnt]['CqmList']['guid']!='3fd13096-2c8f-40b5-9297-b714e8de9133'){
		
			$str.='<table border="1" width="100%">
					<thead>
					<tr>
					<th>eMeasure Title</th>
					<th>Version neutral identifier</th>
					<th>eMeasure Version Number</th>
					<th>NQF eMeasure Number</th>
					<th>eMeasure Identifier (MAT)</th>
					<th>Version specific identifier</th>
					</tr>
					</thead>
					<tbody>
					<tr>
<td>'.$moredata[$mycnt]['CqmList']['title'].'</td>
<td>'.$moredata[$mycnt]['CqmList']['guid'].'</td>
<td>'.$moredata[$mycnt]['CqmList']['emeasure_version_no'].'</td>
<td>'.$moredata[$mycnt]['CqmList']['nqf_number'].'</td>
<td>'.$moredata[$mycnt]['CqmList']['emeasure_identifier'].'</td>
<td>'.$moredata[$mycnt]['CqmList']['measure_rootid'].'</td>
</tr>
</tbody>
</table>
<list>
<item>
<content styleCode="Bold">Initial Patient Population</content>
:'.$recive_enrtries[CqmReportEhEh][ipp_count].'
		<list>
		<item>
		<content styleCode="Bold">American Indian or Alaska Native
		</content>
		: '.$recive_enrtries[CqmReportEh][ipp_race].'
				</item>
<item>
<content styleCode="Bold">Not Hispanic or Latino</content>
:'.$recive_enrtries[CqmReportEh][ipp_eth].'
		</item>
		<item>
		<content styleCode="Bold">Male</content>
		:'.$recive_enrtries[CqmReportEh][ipp_male].'
				</item>
				<item>
				<content styleCode="Bold">Female</content>
				:'.$recive_enrtries[CqmReportEh][ipp_female].'
						</item>
						</list>
						</item>
						<item>
<content styleCode="Bold">Denominator</content>
: '.$recive_enrtries[CqmReportEh][denominator_count].'
<list>

<item>
<content styleCode="Bold">American Indian or Alaska Native
</content>
:  '.$recive_enrtries[CqmReportEh][denominator_race].'
		</item>
<item>
<content styleCode="Bold">Not Hispanic or Latino</content>
: '.$recive_enrtries[CqmReportEh][denominator_eth].'
		</item>
		<item>
		<content styleCode="Bold">Male</content>
		: '.$recive_enrtries[CqmReportEh][denominator_male].'
				</item>
				<item>
				<content styleCode="Bold">Male</content>
				:'.$recive_enrtries[CqmReportEh][denominator_female].'
						</item>
						</list>
						</item>
<item>
<content styleCode="Bold">Numerator</content>
: '.$recive_enrtries[CqmReportEh][numerator_count].'
		<list>
		<item>
		<content styleCode="Bold">American Indian or Alaska Native
		</content>
		: '.$recive_enrtries[CqmReportEh][numerator_race].'
				</item>
				<item>
				<content styleCode="Bold">Not Hispanic or Latino</content>
				: '.$recive_enrtries[CqmReportEh][numerator_eth].'
						</item>
						<item>
						<content styleCode="Bold">Male</content>
						:'.$recive_enrtries[CqmReportEh][numerator_male].'
								</item>
								<item>
								<content styleCode="Bold">Male</content>
								:'.$recive_enrtries[CqmReportEh][numerator_female].'
										</item>
										</list>
										</item>
										<item>
										<content styleCode="Bold">Denominator Exclusions</content>
										:'.$recive_enrtries[CqmReportEh][exclusion_denominator].'
												</item>
												<item>
												<content styleCode="Bold">Denominator Exceptions</content>
												: '.$recive_enrtries[CqmReportEh][exception_denominator].'
														</item>
														</list>';

		}
		}
		//$moredata1=$CqmList->find('all',array('conditions'=>array('nqf_number'=>$recive_enrtries['CqmReportEh']['measure_id'])));
		
		$strED.='<table border="1" width="100%">
							<thead>
								<tr>
									<th>eMeasure Title</th>
									<th>Version neutral identifier</th>
									<th>eMeasure Version Number</th>
									<th>NQF eMeasure Number</th>
									<th>eMeasure Identifier (MAT)</th>
									<th>Version specific identifier</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Median Time from ED Arrival to ED Departure for Discharged
										ED Patients</td>
									<td>3fd13096-2c8f-40b5-9297-b714e8de9133</td>
									<td>3</td>
									<td>0496</td>
									<td>32</td>
									<td>40280381-3D27-5493-013D-61073DA32A30</td>
								</tr>
							</tbody>
						</table><list>
							<item><content styleCode="Bold">Initial Patient Population</content>:
								'.$recive_entry[15][CqmReportEh][ipp_count].' <list>
									<item><content styleCode="Bold">Reporting Stratum 1</content>:
										'.$recive_entry[16][CqmReportEh][ipp_count].'</item>
									<item><content styleCode="Bold">Reporting Stratum 2</content>:
										'.$recive_entry[17][CqmReportEh][ipp_count].'</item>
									<item><content styleCode="Bold">Reporting Stratum 3</content>:
										'.$recive_entry[18][CqmReportEh][ipp_count].'</item>
									<item><content styleCode="Bold">Reporting Stratum 4</content>:
										'.$recive_entry[19][CqmReportEh][ipp_count].'</item>
									<item><content styleCode="Bold">Male</content>: '.$recive_entry[15][CqmReportEh][ipp_male].'</item>
									<item><content styleCode="Bold">Female</content>: '.$recive_entry[15][CqmReportEh][ipp_female].'</item>
									<item><content styleCode="Bold">Not Hispanic or
										Latino</content>:  '.$recive_entry[15][CqmReportEh][ipp_eth].'</item>
									<item><content styleCode="Bold">Hispanic or Latino</content>:
										0</item>
												<item><content styleCode="Bold">Measure Population</content>: '.$recive_entry[15][CqmReportEh][measure_pop].' </item>
									<item><content styleCode="Bold">American Indian or Native Alaska</content>: '.$recive_entry[15][CqmReportEh][ipp_race].'</item>
											<item><content styleCode="Bold">Reporting Stratum 1</content>:
										'.$recive_entry[16][CqmReportEh][measure_pop].'</item>
									<item><content styleCode="Bold">Reporting Stratum 2</content>:
										'.$recive_entry[17][CqmReportEh][measure_pop].'</item>
									<item><content styleCode="Bold">Reporting Stratum 3</content>:
										'.$recive_entry[18][CqmReportEh][measure_pop].'</item>
									<item><content styleCode="Bold">Reporting Stratum 4</content>:
										'.$recive_entry[19][CqmReportEh][measure_pop].'</item>
									<item><content styleCode="Bold">Male</content>: '.$recive_entry[15][CqmReportEh][ipp_male].'</item>
									<item><content styleCode="Bold">Female</content>:'.$recive_entry[15][CqmReportEh][ipp_female].'</item>
									<item><content styleCode="Bold">Not Hispanic or
										Latino</content>:'.$recive_entry[15][CqmReportEh][ipp_eth].'</item>
									
									<item><content styleCode="Bold">American Indian or Native Alaska</content>: '.$recive_entry[15][CqmReportEh][ipp_race].'</item>
									
									<item><content styleCode="Bold">Median Admit Decision Time to ED
											Departure Time for Admitted Patients</content>: '.$recive_entry[15][CqmReportEh][measure_observation].'</item>
								</list>
							</item>
							<item><content styleCode="Bold">Measure Population</content>: '.$recive_entry[15][CqmReportEh][measure_pop].' <list>
									<item><content styleCode="Bold">Reporting Stratum 1</content>:
										'.$recive_entry[16][CqmReportEh][measure_pop].'</item>
									<item><content styleCode="Bold">Reporting Stratum 2</content>:
										'.$recive_entry[17][CqmReportEh][measure_pop].'</item>
									<item><content styleCode="Bold">Reporting Stratum 3</content>:
										'.$recive_entry[18][CqmReportEh][measure_pop].'</item>
									<item><content styleCode="Bold">Reporting Stratum 4</content>:
										'.$recive_entry[19][CqmReportEh][measure_pop].'</item>
									<item><content styleCode="Bold">Male</content>: '.$recive_entry[15][CqmReportEh][ipp_male].'</item>
									<item><content styleCode="Bold">Female</content>:'.$recive_entry[15][CqmReportEh][ipp_female].'</item>
									<item><content styleCode="Bold">Not Hispanic or
										Latino</content>:'.$recive_entry[15][CqmReportEh][ipp_eth].'</item>
									<item><content styleCode="Bold">Hispanic or Latino</content>:
										150</item>
									<item><content styleCode="Bold">American Indian or Native Alaska</content>: '.$recive_entry[15][CqmReportEh][ipp_race].'</item>
									
									<item><content styleCode="Bold">Median Admit Decision Time to ED
											Departure Time for Admitted Patients</content>: '.$recive_entry[15][CqmReportEh][measure_observation].'</item>
								</list>
							</item>
						</list>';		
		return $tsr1.$str.$strED.'</text>';
		
	}
	//=====================================================================================================================================================================================================
	public function consolidated_Ep_Measure($doc_id=null,$type=null){
		//$this->uses=array('CqmReportEh');
		$CqmReport = ClassRegistry::init('CqmReport');
		$CqmList = ClassRegistry::init('CqmList');
		$recive_entry=$CqmReport->find('all',array('conditions'=>array('doctor_id'=>$doc_id,'measure_type'=>$type)));
		// debug($recive_entry);
		//exit;  */
		$highBp_measure="";
		$cnt=0;
		foreach($recive_entry as $recive_enrtries){
			$cnt++;
			debug($recive_enrtries);
				
			$moredata=$CqmList->find('all',array('conditions'=>array('nqf_number'=>$recive_enrtries['CqmReport']['measure_id'])));
			if($moredata[0]['CqmList']['nqf_number']=='0419'){
				$payer=$recive_enrtries['CqmReport']['ipp_count']/2;

			}
			else{
				$payer=$recive_enrtries['CqmReport']['ipp_count'];
			}
			//debug($moredata);
			//debug($moredata[0]['CqmList']['nqf_number']);
				
			$highBp_measure.='<entry>
					<organizer classCode="CLUSTER" moodCode="EVN">
					<!-- Implied template Measure Reference templateId -->
					<templateId root="2.16.840.1.113883.10.20.24.3.98"/>
					<!-- SHALL 1..* (one for each referenced measure) Measure Reference and Results template -->
					<templateId root="2.16.840.1.113883.10.20.27.3.1"/>
					<statusCode code="completed"/>
					<reference typeCode="REFR">
					<externalDocument classCode="DOC" moodCode="EVN">

					<id root="'.$moredata[0]['CqmList']['measure_rootid'].'"/>

							<id root="2.16.840.1.113883.3.560.1" extension="'.$moredata[0]['CqmList']['nqf_number'].'"/>

									<id root="2.16.840.1.113883.3.560.101.2" extension="'.$moredata[0]['CqmList']['emeasure_identifier'].'"/>
											<code code="57024-2" codeSystem="2.16.840.1.113883.6.1"
											codeSystemName="LOINC"
											displayName="Health Quality Measure
											Document"/>

											<text>'.$moredata[0]['CqmList']['title'].'</text>

													<setId root="'.$moredata[0]['CqmList']['guid'].'"/>

															<versionNumber value="'.$moredata[0]['CqmList']['emeasure_version_no'].'"/>
																	</externalDocument>
																	</reference>
																	<!-- SHOULD Reference the measure set it is a member of-->
																	<reference typeCode="REFR">
																	<externalObservation>
																	<!-- SHALL contain id -->
																	<id root="b6ac13e2-beb8-4e4f-94ed-fcc397406cd8"/>
																	<!-- SHALL single value binding -->
																	<code code="55185-3" displayName="measure set"
																	codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC"/>
																	<!-- SHALL text which should be the title of the measures set -->
																	<text>Clinical Quality Measure Set 2011-2012</text>
																	</externalObservation>
																	</reference>
																	<!-- Optional performance rate template -->
																	<component>
																	<observation classCode="OBS" moodCode="EVN">
																	<!-- MAY 0..1 Performance Rate for Proportion Measure template -->
																	<templateId root="2.16.840.1.113883.10.20.27.3.14"/>
																	<code code="72510-1" codeSystem="2.16.840.1.113883.6.1"
																	displayName="Performance Rate"
																	codeSystemName="2.16.840.1.113883.6.1"/>
																	<statusCode code="completed"/>
																	<value xsi:type="REAL" value="0.833"/>
																	<!-- MAY 0..1  (Note: this is the reference to the specific Numerator included in the calculation) -->
																	<reference typeCode="REFR">
																	<externalObservation classCode="OBS" moodCode="EVN">
																	<!--
																	The externalObservationID contains the ID of the numerator in the referenced eMeasure.
																	-->
																	<id root="6B818F6C-ED51-41B6-BE3B-FFBAD0BC1E34"/>
																	<code code="NUMER" displayName="Numerator"
																	codeSystem="2.16.840.1.113883.5.1063"
																	codeSystemName="ObservationValue"/>
																	</externalObservation>
																	</reference>
																	<!-- MAY 0..1 Used to represent the predicted rate based on the measure risk-adjustment model. -->
																	<referenceRange>
																	<observationRange>
																	<value xsi:type="REAL" value="0.625"/>
																	</observationRange>
																	</referenceRange>
																	</observation>
																	</component>
																	<!-- Optional reporting rate template -->
																	<component>
																	<observation classCode="OBS" moodCode="EVN">
																	<!-- MAY 0..1 Reporting Rate for Proportion Measure template -->
																	<templateId root="2.16.840.1.113883.10.20.27.3.15"/>
																	<code code="72509-3" codeSystem="2.16.840.1.113883.6.1"
																	displayName="Reporting Rate"
																	codeSystemName="2.16.840.1.113883.6.1"/>
																	<statusCode code="completed"/>
																	<value xsi:type="REAL" value="0.84"/>
																	</observation>
																	</component>';
			/*<!-- SHALL 1..* (one for each population) Measure Data template -->
			 <!-- NOTE AT THE BOTTOM OF THIS ORGANIZER is the reference for the entire population that starts with the first component
			observation at the top within the measure data template.  There are other external references contained within the
			entryRelationships below.  -->
			<!-- This is the population as in IPP, numerator, denominator, etc. If there are multiple
			populations, use the same method, but refer to IPP1, numerator1, IPP2, numerator2, etc -->*/

			//IPP COMPONENT
			$highBp_measure.='<component>
					<observation classCode="OBS" moodCode="EVN">
					<!-- Measure Data template -->
					<templateId root="2.16.840.1.113883.10.20.27.3.5"/>
					<code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4"
					displayName="Assertion" codeSystemName="ActCode"/>
					<statusCode code="completed"/>
					<!-- SHALL value with SHOULD be from valueSetName="ObservationPopulationInclusion"
					valueSetOid="2.16.840.1.113883.1.11.20369"	Binding: Dynamic
					-->
					<value xsi:type="CD" code="IPP"
					codeSystem="2.16.840.1.113883.5.1063"
					displayName="initial patient population"
					codeSystemName="ObservationValue"/>
					<!-- SHALL contain aggregate count template -->
					<entryRelationship typeCode="SUBJ" inversionInd="true">
					<!-- Aggregate Count (2.16.840.1.113883.10.20.27.3.3) -->
					<observation classCode="OBS" moodCode="EVN">
					<!-- Aggregate Count template -->
					<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
					<!-- SHALL single value binding -->
					<code code="MSRAGG" displayName="rate aggregation"
					codeSystem="2.16.840.1.113883.5.4"
					codeSystemName="ActCode"/>
					<!--  SHALL value xsi:type="INT"-->
					<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['ipp_count'].'"/>
							<methodCode code="COUNT" displayName="Count"
							codeSystem="2.16.840.1.113883.5.84"
							codeSystemName="ObservationMethod"/>
							</observation>
							</entryRelationship>
							<entryRelationship typeCode="COMP">
							<!-- Postal Code Supplemental Data Element (2.16.840.1.113883.10.20.27.3.10)-->
							<!-- Repeat for each postal code that has any data -->
							<observation classCode="OBS" moodCode="EVN">
							<!-- Postal Code Supplemental Data Element template ID -->
							<templateId root="2.16.840.1.113883.10.20.27.3.10"/>
							<!-- SHALL single value binding -->
							<code code="184102003" displayName="patient postal code"
							codeSystem="2.16.840.1.113883.6.96"
							codeSystemName="SNOMED-CT"/>
							<statusCode code="completed"/>
							<!-- SHALL be xsi:type="ST"-->
							<value xsi:type="ST">92543</value>

							<entryRelationship typeCode="SUBJ" inversionInd="true">
							<observation classCode="OBS" moodCode="EVN">
							<!-- Aggregate Count template -->
							<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
							<code code="MSRAGG" displayName="rate aggregation"
							codeSystem="2.16.840.1.113883.5.4"
							codeSystemName="ActCode"/>
							<!--  SHALL value xsi:type="INT"-->
							<value xsi:type="INT" value="15"/>
							<methodCode code="COUNT" displayName="Count"
							codeSystem="2.16.840.1.113883.5.84"
							codeSystemName="ObservationMethod"/>
							</observation>
							</entryRelationship>
							</observation>
							</entryRelationship>
							<entryRelationship typeCode="COMP">
							<!-- Ethnicity Supplemental Data Element (2.16.840.1.113883.10.20.27.3.7) -->
							<observation classCode="OBS" moodCode="EVN">
							<!-- Ethnicity Supplemental Data Element template ID -->
							<templateId root="2.16.840.1.113883.10.20.27.3.7"/>
							<!-- SHALL single value binding -->
							<code code="364699009" displayName="Ethnic Group"
							codeSystem="2.16.840.1.113883.6.96"
							codeSystemName="SNOMED CT"/>
							<statusCode code="completed"/>
							<!-- SHALL be bound to CDC Ethnicity group Value Set OID 2.16.840.1.114222.4.11.837 - dynamic -->
							<!-- Not hispanic -->
							<value xsi:type="CD" code="2186-5"
							displayName="Not Hispanic or Latino"
							codeSystem="2.16.840.1.113883.6.238"
							codeSystemName="Race &amp; Ethnicity - CDC"/>
							<!-- SHALL 1..1 Aggregate Count template -->
							<entryRelationship typeCode="SUBJ" inversionInd="true">
							<observation classCode="OBS" moodCode="EVN">
							<!-- Aggregate Count template -->
							<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
							<code code="MSRAGG" displayName="rate aggregation"
							codeSystem="2.16.840.1.113883.5.4"
							codeSystemName="ActCode"/>
							<!--  SHALL value xsi:type="INT"-->
							<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['ethnicity_count'].'"/>
									<methodCode code="COUNT" displayName="Count"
									codeSystem="2.16.840.1.113883.5.84"
									codeSystemName="ObservationMethod"/>
									</observation>
									</entryRelationship>
									</observation>
									</entryRelationship>
									<entryRelationship typeCode="COMP">
									<!-- Ethnicity Supplemental Data Element (2.16.840.1.113883.10.20.27.3.7) -->
									<observation classCode="OBS" moodCode="EVN">
									<!-- Ethnicity Supplemental Data Element template ID -->
									<templateId root="2.16.840.1.113883.10.20.27.3.7"/>
									<code code="364699009" displayName="Ethnic Group"
									codeSystem="2.16.840.1.113883.6.96"
									codeSystemName="SNOMED CT"/>
									<statusCode code="completed"/>
									<!-- SHALL be bound to CDC Ethnicity group Value Set OID 2.16.840.1.114222.4.11.837 - dynamic -->
									<!-- Hispanic -->
									<value xsi:type="CD" code="2135-2"
									displayName="Hispanic or Latino"
									codeSystem="2.16.840.1.113883.6.238"
									codeSystemName="Race &amp; Ethnicity - CDC"/>
									<!-- SHALL 1..1 Aggregate Count template -->
									<entryRelationship typeCode="SUBJ" inversionInd="true">
									<observation classCode="OBS" moodCode="EVN">
									<!-- Aggregate Count template -->
									<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
									<code code="MSRAGG" displayName="rate aggregation"
									codeSystem="2.16.840.1.113883.5.4"
									codeSystemName="ActCode"/>
									<!--  SHALL value xsi:type="INT"-->
									<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['ethnicity_count'].'"/>
											<methodCode code="COUNT" displayName="Count"
											codeSystem="2.16.840.1.113883.5.84"
											codeSystemName="ObservationMethod"/>
											</observation>
											</entryRelationship>
											</observation>
											</entryRelationship>
											<entryRelationship typeCode="COMP">
											<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
											<observation classCode="OBS" moodCode="EVN">
											<!-- Race Supplemental Data Element template ID -->
											<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
											<code code="103579009" displayName="Race"
											codeSystem="2.16.840.1.113883.6.96"
											codeSystemName="SNOMED-CT"/>
											<statusCode code="completed"/>
											<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
											<value xsi:type="CD" code="1002-5"
											displayName="American Indian or Alaska Native"
											codeSystem="2.16.840.1.113883.6.238"
											codeSystemName="Race &amp; Ethnicity - CDC"/>
											<entryRelationship typeCode="SUBJ" inversionInd="true">
											<observation classCode="OBS" moodCode="EVN">
											<!-- SHALL 1..1 Aggregate Count template -->
											<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
											<code code="MSRAGG" displayName="rate aggregation"
											codeSystem="2.16.840.1.113883.5.4"
											codeSystemName="ActCode"/>
											<!--  SHALL value xsi:type="INT" to be changed-->
											<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['race_count'].'"/>
													<methodCode code="COUNT" displayName="Count"
													codeSystem="2.16.840.1.113883.5.84"
													codeSystemName="ObservationMethod"/>
													</observation>
													</entryRelationship>
													</observation>
													</entryRelationship>
													<entryRelationship typeCode="COMP">
													<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
													<observation classCode="OBS" moodCode="EVN">
													<!-- Race Supplemental Data Element template ID -->
													<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
													<code code="103579009" displayName="Race"
													codeSystem="2.16.840.1.113883.6.96"
													codeSystemName="SNOMED CT"/>
													<statusCode code="completed"/>
													<value xsi:type="CD" code="2131-1" displayName="White"
													codeSystem="2.16.840.1.113883.6.238"
													codeSystemName="Race &amp; Ethnicity - CDC"/>
													<entryRelationship typeCode="SUBJ" inversionInd="true">
													<observation classCode="OBS" moodCode="EVN">
													<!-- SHALL 1..1 Aggregate Count template -->
													<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
													<code code="MSRAGG" displayName="rate aggregation"
													codeSystem="2.16.840.1.113883.5.4"
													codeSystemName="ActCode"/>
													<!--  SHALL value xsi:type="INT"-->
													<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['ethnicity_count'].'"/>
															<methodCode code="COUNT" displayName="Count"
															codeSystem="2.16.840.1.113883.5.84"
															codeSystemName="ObservationMethod"/>
															</observation>
															</entryRelationship>
															</observation>
															</entryRelationship>
															<entryRelationship typeCode="COMP">
															<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
															<observation classCode="OBS" moodCode="EVN">
															<!-- Race Supplemental Data Element template ID -->
															<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
															<code code="103579009" displayName="Race"
															codeSystem="2.16.840.1.113883.6.96"
															codeSystemName="SNOMED CT"/>
															<statusCode code="completed"/>
															<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
															<value xsi:type="CD" code="2028-9" displayName="Asian"
															codeSystem="2.16.840.1.113883.6.238"
															codeSystemName="Race &amp; Ethnicity - CDC"/>
															<entryRelationship typeCode="SUBJ" inversionInd="true">
															<observation classCode="OBS" moodCode="EVN">
															<!-- SHALL 1..1 Aggregate Count template -->
															<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
															<code code="MSRAGG" displayName="rate aggregation"
															codeSystem="2.16.840.1.113883.5.4"
															codeSystemName="ActCode"/>
															<!--  SHALL value xsi:type="INT"-->
															<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['ethnicity_count'].'"/>
																	<methodCode code="COUNT" displayName="Count"
																	codeSystem="2.16.840.1.113883.5.84"
																	codeSystemName="ObservationMethod"/>
																	</observation>
																	</entryRelationship>
																	</observation>
																	</entryRelationship>
																	<entryRelationship typeCode="COMP">
																	<!-- Sex Supplemental Data Element (2.16.840.1.113883.10.20.27.3.6) -->
																	<observation classCode="OBS" moodCode="EVN">
																	<!-- Sex Supplemental Data Element template ID -->
																	<templateId root="2.16.840.1.113883.10.20.27.3.6"/>
																	<!-- SHALL be single value binding to: -->
																	<code code="184100006" displayName="patient sex"
																	codeSystem="2.16.840.1.113883.6.96"
																	codeSystemName="SNOMED-CT"/>
																	<statusCode code="completed"/>
																	<!-- SHALL be drawn from  Value Set: Administrative Gender (HL7 V3) 2.16.840.1.113883.1.11.1 DYNAMIC-->
																	<!-- Female -->
																	<value xsi:type="CD" code="F"
																	codeSystem="2.16.840.1.113883.5.1"
																	codeSystemName="HL7AdministrativeGenderCode"/>
																	<entryRelationship typeCode="SUBJ" inversionInd="true">
																	<observation classCode="OBS" moodCode="EVN">
																	<!-- SHALL 1..1 Aggregate Count template -->
																	<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
																	<code code="MSRAGG" displayName="rate aggregation"
																	codeSystem="2.16.840.1.113883.5.4"
																	codeSystemName="ActCode"/>
																	<!--  SHALL value xsi:type="INT"-->
																	<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['female_count'].'"/>
																			<methodCode code="COUNT" displayName="Count"
																			codeSystem="2.16.840.1.113883.5.84"
																			codeSystemName="ObservationMethod"/>
																			</observation>
																			</entryRelationship>
																			</observation>
																			</entryRelationship>
																			<entryRelationship typeCode="COMP">
																			<!-- Sex Supplemental Data Element (2.16.840.1.113883.10.20.27.3.6) -->
																			<observation classCode="OBS" moodCode="EVN">
																			<!-- Sex Supplemental Data Element template ID -->
																			<templateId root="2.16.840.1.113883.10.20.27.3.6"/>
																			<!-- SHALL be single value binding to: -->
																			<code code="184100006" displayName="patient sex"
																			codeSystem="2.16.840.1.113883.6.96"
																			codeSystemName="SNOMED-CT"/>
																			<statusCode code="completed"/>
																			<!-- SHALL be drawn from  Value Set: Administrative Gender (HL7 V3) 2.16.840.1.113883.1.11.1 DYNAMIC-->
																			<!-- Male -->
																			<value xsi:type="CD" code="M"
																			codeSystem="2.16.840.1.113883.5.1"
																			codeSystemName="HL7AdministrativeGenderCode"/>
																			<entryRelationship typeCode="SUBJ" inversionInd="true">
																			<observation classCode="OBS" moodCode="EVN">
																			<!-- SHALL 1..1 Aggregate Count template -->
																			<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
																			<code code="MSRAGG" displayName="rate aggregation"
																			codeSystem="2.16.840.1.113883.5.4"
																			codeSystemName="ActCode"/>
																			<!--  SHALL value xsi:type="INT" to be changed-->
																			<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['male_count'].'"/>
																					<methodCode code="COUNT" displayName="Count"
																					codeSystem="2.16.840.1.113883.5.84"
																					codeSystemName="ObservationMethod"/>
																					</observation>
																					</entryRelationship>
																					</observation>
																					</entryRelationship>
																					<entryRelationship typeCode="COMP">
																					<!-- Payer Supplemental Data Element (2.16.840.1.113883.10.20.27.3.9) -->
																					<observation classCode="OBS" moodCode="EVN">
																					<!-- Conforms to Patient Characteristic Payer -->
																					<templateId root="2.16.840.1.113883.10.20.24.3.55"/>
																					<!-- Payer Supplemental Data Element template ID -->
																					<templateId root="2.16.840.1.113883.10.20.27.3.9"/>
																					<!-- implied template requires ID -->
																					<id nullFlavor="NA"/>
																					<!-- SHALL be single value binding to: -->
																					<code code="48768-6" displayName="Payment source"
																					codeSystem="2.16.840.1.113883.6.1"
																					codeSystemName="SNOMED-CT"/>
																					<statusCode code="completed"/>
																					<!-- SHALL be drawn from  Value Set: PHDSC Source of Payment Typology 2.16.840.1.114222.4.11.3591 DYNAMIC-->
																					<value xsi:type="CD" code="349"
																					codeSystem="2.16.840.1.113883.3.221.5"
																					codeSystemName="Source of Payment Typology"
																					displayName="Medicare"/>
																					<entryRelationship typeCode="SUBJ" inversionInd="true">
																					<observation classCode="OBS" moodCode="EVN">
																					<!-- SHALL 1..1 Aggregate Count template -->
																					<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
																					<code code="MSRAGG" displayName="rate aggregation"
																					codeSystem="2.16.840.1.113883.5.4"
																					codeSystemName="ActCode"/>
																					<!--  SHALL value xsi:type="INT"-->
																					<value xsi:type="INT" value="'.$payer.'"/>
																							<methodCode code="COUNT" displayName="Count"
																							codeSystem="2.16.840.1.113883.5.84"
																							codeSystemName="ObservationMethod"/>
																							</observation>
																							</entryRelationship>
																							</observation>
																							</entryRelationship>
																							<entryRelationship typeCode="COMP">
																							<!-- Payer Supplemental Data Element (2.16.840.1.113883.10.20.27.3.9) -->
																							<observation classCode="OBS" moodCode="EVN">
																							<!-- Conforms to Patient Characteristic Payer -->
																							<templateId root="2.16.840.1.113883.10.20.24.3.55"/>
																							<!-- Payer Supplemental Data Element template ID -->
																							<templateId root="2.16.840.1.113883.10.20.27.3.9"/>
																							<!-- implied template requires ID -->
																							<id nullFlavor="NA"/>
																							<!-- SHALL be single value binding to: -->
																							<code code="48768-6" displayName="Payment source"
																							codeSystem="2.16.840.1.113883.6.1"
																							codeSystemName="SNOMED-CT"/>
																							<statusCode code="completed"/>
																							<!-- SHALL be drawn from  Value Set: PHDSC Source of Payment Typology 2.16.840.1.114222.4.11.3591 DYNAMIC-->
																							<value xsi:type="CD" code="349"
																							codeSystem="2.16.840.1.113883.3.221.5"
																							codeSystemName="Source of Payment Typology"
																							displayName="Medicaid"/>
																							<entryRelationship typeCode="SUBJ" inversionInd="true">
																							<observation classCode="OBS" moodCode="EVN">
																							<!-- SHALL 1..1 Aggregate Count template -->
																							<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
																							<code code="MSRAGG" displayName="rate aggregation"
																							codeSystem="2.16.840.1.113883.5.4"
																							codeSystemName="ActCode"/>
																							<!--  SHALL value xsi:type="INT" to be changed-->
																							<value xsi:type="INT" value="'.$payer.'"/>
																									<methodCode code="COUNT" displayName="Count"
																									codeSystem="2.16.840.1.113883.5.84"
																									codeSystemName="ObservationMethod"/>
																									</observation>
																									</entryRelationship>
																									</observation>
																									</entryRelationship>
																									<!-- SHALL 1..1  (Note: this is the reference for the entire population starting with the first component
																									observation at the top within the measure data template-->
																									<reference typeCode="REFR">
																									<!-- reference to the relevant population in the eMeasure -->
																									<externalObservation classCode="OBS" moodCode="EVN">
																									<id root="'.$moredata[0]['CqmList']['ipp_rootid'].'"/>
																											</externalObservation>
																											</reference>
																											</observation>
																											</component>
																											';

			//end of IPP COMPONENT

			//Start of DENOM Component
			$highBp_measure.='<component>
					<observation classCode="OBS" moodCode="EVN">
					<!-- Measure Data template -->
					<templateId root="2.16.840.1.113883.10.20.27.3.5"/>
					<code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4"
					displayName="Assertion" codeSystemName="ActCode"/>
					<statusCode code="completed"/>
					<!-- SHALL value with SHOULD be from valueSetName="ObservationPopulationInclusion "	valueSetOid="2.16.840.1.113883.1.11.20369"	Binding: Dynamic
					-->
					<value xsi:type="CD" code="DENOM"
					codeSystem="2.16.840.1.113883.5.1063"
					displayName="Denominator" codeSystemName="ObservationValue"/>
					<!-- SHALL contain aggregate count template -->
					<entryRelationship typeCode="SUBJ" inversionInd="true">
					<!-- Aggregate Count (2.16.840.1.113883.10.20.27.3.3) -->
					<observation classCode="OBS" moodCode="EVN">
					<!-- Aggregate Count template -->
					<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
					<!-- SHALL single value binding -->
					<code code="MSRAGG" displayName="rate aggregation"
					codeSystem="2.16.840.1.113883.5.4"
					codeSystemName="ActCode"/>
					<!--  SHALL value xsi:type="INT"-->
					<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['denominator'].'"/>
							<methodCode code="COUNT" displayName="Count"
							codeSystem="2.16.840.1.113883.5.84"
							codeSystemName="ObservationMethod"/>
							</observation>
							</entryRelationship>
							<entryRelationship typeCode="COMP">
							<!-- Postal Code Supplemental Data Element (2.16.840.1.113883.10.20.27.3.10)-->
							<observation classCode="OBS" moodCode="EVN">
							<!-- Postal Code Supplemental Data Element template ID -->
							<templateId root="2.16.840.1.113883.10.20.27.3.10"/>
							<!-- SHALL single value binding -->
							<code code="184102003" displayName="patient postal code"
							codeSystem="2.16.840.1.113883.6.96"
							codeSystemName="SNOMED-CT"/>
							<statusCode code="completed"/>
							<!-- SHALL be xsi:type="ST"-->
							<value xsi:type="ST">92543</value>
							<!-- SHALL 1..1 Aggregate Count template -->
							<entryRelationship typeCode="SUBJ" inversionInd="true">
							<observation classCode="OBS" moodCode="EVN">
							<!-- Aggregate Count template -->
							<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
							<code code="MSRAGG" displayName="rate aggregation"
							codeSystem="2.16.840.1.113883.5.4"
							codeSystemName="ActCode"/>
							<!--  SHALL value xsi:type="INT"-->
							<value xsi:type="INT" value="15"/>
							<methodCode code="COUNT" displayName="Count"
							codeSystem="2.16.840.1.113883.5.84"
							codeSystemName="ObservationMethod"/>
							</observation>
							</entryRelationship>
							</observation>
							</entryRelationship>
							<entryRelationship typeCode="COMP">
							<!-- Ethnicity Supplemental Data Element (2.16.840.1.113883.10.20.27.3.7) -->
							<observation classCode="OBS" moodCode="EVN">
							<!-- Ethnicity Supplemental Data Element template ID -->
							<templateId root="2.16.840.1.113883.10.20.27.3.7"/>
							<!-- SHALL single value binding -->
							<code code="364699009" displayName="Ethnic Group"
							codeSystem="2.16.840.1.113883.6.96"
							codeSystemName="SNOMED CT"/>
							<statusCode code="completed"/>
							<!-- SHALL be bound to CDC Ethnicity group Value Set OID 2.16.840.1.114222.4.11.837 - dynamic -->
							<!-- Not hispanic -->
							<value xsi:type="CD" code="2186-5"
							displayName="Not
							Hispanic or Latino"
							codeSystem="2.16.840.1.113883.6.238"
							codeSystemName="Race &amp; Ethnicity - CDC"/>
							<!-- SHALL 1..1 Aggregate Count template -->
							<entryRelationship typeCode="SUBJ" inversionInd="true">
							<observation classCode="OBS" moodCode="EVN">
							<!-- Aggregate Count template -->
							<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
							<code code="MSRAGG" displayName="rate aggregation"
							codeSystem="2.16.840.1.113883.5.4"
							codeSystemName="ActCode"/>
							<!--  SHALL value xsi:type="INT" need to change-->
							<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['ethnicity_count'].'"/>
									<methodCode code="COUNT" displayName="Count"
									codeSystem="2.16.840.1.113883.5.84"
									codeSystemName="ObservationMethod"/>
									</observation>
									</entryRelationship>
									</observation>
									</entryRelationship>
									<entryRelationship typeCode="COMP">
									<!-- Ethnicity Supplemental Data Element (2.16.840.1.113883.10.20.27.3.7) -->
									<observation classCode="OBS" moodCode="EVN">
									<!-- Ethnicity Supplemental Data Element template ID -->
									<templateId root="2.16.840.1.113883.10.20.27.3.7"/>
									<code code="364699009" displayName="Ethnic Group"
									codeSystem="2.16.840.1.113883.6.96"
									codeSystemName="SNOMED CT"/>
									<statusCode code="completed"/>
									<!-- SHALL be bound to CDC Ethnicity group Value Set OID 2.16.840.1.114222.4.11.837 - dynamic -->
									<!-- Hispanic -->
									<value xsi:type="CD" code="2135-2"
									displayName="Hispanic or Latino"
									codeSystem="2.16.840.1.113883.6.238"
									codeSystemName="Race &amp; Ethnicity - CDC"/>
									<!-- SHALL 1..1 Aggregate Count template -->
									<entryRelationship typeCode="SUBJ" inversionInd="true">
									<observation classCode="OBS" moodCode="EVN">
									<!-- Aggregate Count template -->
									<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
									<code code="MSRAGG" displayName="rate aggregation"
									codeSystem="2.16.840.1.113883.5.4"
									codeSystemName="ActCode"/>
									<!--  SHALL value xsi:type="INT"-->
									<value xsi:type="INT" value="325"/>
									<methodCode code="COUNT" displayName="Count"
									codeSystem="2.16.840.1.113883.5.84"
									codeSystemName="ObservationMethod"/>
									</observation>
									</entryRelationship>
									</observation>
									</entryRelationship>
									<entryRelationship typeCode="COMP">
									<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
									<observation classCode="OBS" moodCode="EVN">
									<!-- Race Supplemental Data Element template ID -->
									<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
									<code code="103579009" displayName="Race"
									codeSystem="2.16.840.1.113883.6.96"
									codeSystemName="SNOMED CT"/>
									<statusCode code="completed"/>
									<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
									<value xsi:type="CD" code="1002-5"
									displayName="American Indian or Alaska Native"
									codeSystem="2.16.840.1.113883.6.238"
									codeSystemName="Race &amp; Ethnicity - CDC"/>
									<entryRelationship typeCode="SUBJ" inversionInd="true">
									<observation classCode="OBS" moodCode="EVN">
									<!-- SHALL 1..1 Aggregate Count template -->
									<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
									<code code="MSRAGG" displayName="rate aggregation"
									codeSystem="2.16.840.1.113883.5.4"
									codeSystemName="ActCode"/>
									<!--  SHALL value xsi:type="INT" to be changed-->
									<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['race_count'].'"/>
											<methodCode code="COUNT" displayName="Count"
											codeSystem="2.16.840.1.113883.5.84"
											codeSystemName="ObservationMethod"/>
											</observation>
											</entryRelationship>
											</observation>
											</entryRelationship>
											<entryRelationship typeCode="COMP">
											<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
											<observation classCode="OBS" moodCode="EVN">
											<!-- Race Supplemental Data Element template ID -->
											<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
											<code code="103579009" displayName="Race"
											codeSystem="2.16.840.1.113883.6.96"
											codeSystemName="SNOMED CT"/>
											<statusCode code="completed"/>
											<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
											<value xsi:type="CD" code="2131-1" displayName="White"
											codeSystem="2.16.840.1.113883.6.238"
											codeSystemName="Race &amp; Ethnicity - CDC"/>
											<entryRelationship typeCode="SUBJ" inversionInd="true">
											<observation classCode="OBS" moodCode="EVN">
											<!-- SHALL 1..1 Aggregate Count template -->
											<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
											<code code="MSRAGG" displayName="rate aggregation"
											codeSystem="2.16.840.1.113883.5.4"
											codeSystemName="ActCode"/>
											<!--  SHALL value xsi:type="INT"-->
											<value xsi:type="INT" value="175"/>
											<methodCode code="COUNT" displayName="Count"
											codeSystem="2.16.840.1.113883.5.84"
											codeSystemName="ObservationMethod"/>
											</observation>
											</entryRelationship>
											</observation>
											</entryRelationship>
											<entryRelationship typeCode="COMP">
											<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
											<observation classCode="OBS" moodCode="EVN">
											<!-- Race Supplemental Data Element template ID -->
											<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
											<code code="103579009" displayName="Race"
											codeSystem="2.16.840.1.113883.6.96"
											codeSystemName="SNOMED CT"/>
											<statusCode code="completed"/>
											<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
											<value xsi:type="CD" code="2028-9" displayName="Asian"
											codeSystem="2.16.840.1.113883.6.238"
											codeSystemName="Race &amp; Ethnicity - CDC"/>
											<entryRelationship typeCode="SUBJ" inversionInd="true">
											<observation classCode="OBS" moodCode="EVN">
											<!-- SHALL 1..1 Aggregate Count template -->
											<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
											<code code="MSRAGG" displayName="rate aggregation"
											codeSystem="2.16.840.1.113883.5.4"
											codeSystemName="ActCode"/>
											<!--  SHALL value xsi:type="INT"-->
											<value xsi:type="INT" value="175"/>
											<methodCode code="COUNT" displayName="Count"
											codeSystem="2.16.840.1.113883.5.84"
											codeSystemName="ObservationMethod"/>
											</observation>
											</entryRelationship>
											</observation>
											</entryRelationship>
											<entryRelationship typeCode="COMP">
											<!-- Sex Supplemental Data Element (2.16.840.1.113883.10.20.27.3.6) -->
											<observation classCode="OBS" moodCode="EVN">
											<!-- Sex Supplemental Data Element template ID -->
											<templateId root="2.16.840.1.113883.10.20.27.3.6"/>
											<!-- SHALL be single value binding to: -->
											<code code="184100006" displayName="patient sex"
											codeSystem="2.16.840.1.113883.6.96"
											codeSystemName="SNOMED-CT"/>
											<statusCode code="completed"/>
											<!-- SHALL be drawn from  Value Set: Administrative Gender (HL7 V3) 2.16.840.1.113883.1.11.1 DYNAMIC-->
											<!-- Example female -->
											<value xsi:type="CD" code="F"
											codeSystem="2.16.840.1.113883.5.1"
											codeSystemName="HL7AdministrativeGenderCode"/>
											<entryRelationship typeCode="SUBJ" inversionInd="true">
											<observation classCode="OBS" moodCode="EVN">
											<!-- SHALL 1..1 Aggregate Count template -->
											<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
											<code code="MSRAGG" displayName="rate aggregation"
											codeSystem="2.16.840.1.113883.5.4"
											codeSystemName="ActCode"/>
											<!--  SHALL value xsi:type="INT"-->
											<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['female_count'].'"/>
													<methodCode code="COUNT" displayName="Count"
													codeSystem="2.16.840.1.113883.5.84"
													codeSystemName="ObservationMethod"/>
													</observation>
													</entryRelationship>
													</observation>
													</entryRelationship>
													<entryRelationship typeCode="COMP">
													<!-- Sex Supplemental Data Element (2.16.840.1.113883.10.20.27.3.6) -->
													<observation classCode="OBS" moodCode="EVN">
													<!-- Sex Supplemental Data Element template ID -->
													<templateId root="2.16.840.1.113883.10.20.27.3.6"/>
													<!-- SHALL be single value binding to: -->
													<code code="184100006" displayName="patient sex"
													codeSystem="2.16.840.1.113883.6.96"
													codeSystemName="SNOMED-CT"/>
													<statusCode code="completed"/>
													<!-- SHALL be drawn from  Value Set: Administrative Gender (HL7 V3) 2.16.840.1.113883.1.11.1 DYNAMIC-->
													<value xsi:type="CD" code="M"
													codeSystem="2.16.840.1.113883.5.1"
													codeSystemName="HL7AdministrativeGenderCode"/>
													<entryRelationship typeCode="SUBJ" inversionInd="true">
													<observation classCode="OBS" moodCode="EVN">
													<!-- SHALL 1..1 Aggregate Count template -->
													<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
													<code code="MSRAGG" displayName="rate aggregation"
													codeSystem="2.16.840.1.113883.5.4"
													codeSystemName="ActCode"/>
													<!--  SHALL value xsi:type="INT" to be changed-->
													<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['male_count'].'"/>
															<methodCode code="COUNT" displayName="Count"
															codeSystem="2.16.840.1.113883.5.84"
															codeSystemName="ObservationMethod"/>
															</observation>
															</entryRelationship>
															</observation>
															</entryRelationship>
															<entryRelationship typeCode="COMP">
															<!-- Payer Supplemental Data Element (2.16.840.1.113883.10.20.27.3.9) -->
															<observation classCode="OBS" moodCode="EVN">
															<!-- Conforms to Patient Characteristic Payer -->
															<templateId root="2.16.840.1.113883.10.20.24.3.55"/>
															<!-- Payer Supplemental Data Element template ID -->
															<templateId root="2.16.840.1.113883.10.20.27.3.9"/>
															<!-- implied template requires ID -->
															<id nullFlavor="NA"/>
															<!-- SHALL be single value binding to: -->
															<code code="48768-6" displayName="Payment source"
															codeSystem="2.16.840.1.113883.6.1"
															codeSystemName="SNOMED-CT"/>
															<statusCode code="completed"/>
															<!-- SHALL be drawn from  Value Set: PHDSC Source of Payment Typology 2.16.840.1.114222.4.11.3591 DYNAMIC-->
															<value xsi:type="CD" code="349"
															codeSystem="2.16.840.1.113883.3.221.5"
															codeSystemName="Source of Payment Typology"
															displayName="Medicare"/>
															<entryRelationship typeCode="SUBJ" inversionInd="true">
															<observation classCode="OBS" moodCode="EVN">
															<!-- SHALL 1..1 Aggregate Count template -->
															<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
															<code code="MSRAGG" displayName="rate aggregation"
															codeSystem="2.16.840.1.113883.5.4"
															codeSystemName="ActCode"/>
															<value xsi:type="INT" value="'.$payer.'"/>
																	<methodCode code="COUNT" displayName="Count"
																	codeSystem="2.16.840.1.113883.5.84"
																	codeSystemName="ObservationMethod"/>
																	</observation>
																	</entryRelationship>
																	</observation>
																	</entryRelationship>
																	<entryRelationship typeCode="COMP">
																	<!-- Payer Supplemental Data Element (2.16.840.1.113883.10.20.27.3.9) -->
																	<observation classCode="OBS" moodCode="EVN">
																	<!-- Conforms to Patient Characteristic Payer -->
																	<templateId root="2.16.840.1.113883.10.20.24.3.55"/>
																	<!-- Payer Supplemental Data Element template ID -->
																	<templateId root="2.16.840.1.113883.10.20.27.3.9"/>
																	<!-- implied template requires ID -->
																	<id nullFlavor="NA"/>
																	<!-- SHALL be single value binding to: -->
																	<code code="48768-6" displayName="Payment source"
																	codeSystem="2.16.840.1.113883.6.1"
																	codeSystemName="SNOMED-CT"/>
																	<statusCode code="completed"/>
																	<!-- SHALL be drawn from  Value Set: PHDSC Source of Payment Typology 2.16.840.1.114222.4.11.3591 DYNAMIC-->
																	<value xsi:type="CD" code="349"
																	codeSystem="2.16.840.1.113883.3.221.5"
																	codeSystemName="Source of Payment Typology"
																	displayName="Medicaid"/>
																	<entryRelationship typeCode="SUBJ" inversionInd="true">
																	<observation classCode="OBS" moodCode="EVN">
																	<!-- SHALL 1..1 Aggregate Count template -->
																	<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
																	<code code="MSRAGG" displayName="rate aggregation"
																	codeSystem="2.16.840.1.113883.5.4"
																	codeSystemName="ActCode"/>
																	<!--  SHALL value xsi:type="INT" to be changed-->
																	<value xsi:type="INT" value="'.$payer.'"/>
																			<methodCode code="COUNT" displayName="Count"
																			codeSystem="2.16.840.1.113883.5.84"
																			codeSystemName="ObservationMethod"/>
																			</observation>
																			</entryRelationship>
																			</observation>
																			</entryRelationship>
																			<!-- SHALL 1..1  (Note: this is the reference for the entire population starting with the first component
																			observation at the top within the measure data template-->
																			<reference typeCode="REFR">
																			<!-- reference to the relevant population in the eMeasure -->
																			<externalObservation classCode="OBS" moodCode="EVN">
																			<id root="'.$moredata[0]['CqmList']['denominator_rootid'].'"/>
																					</externalObservation>
																					</reference>
																					</observation>
																					</component>';
			//End of DENOM component
//---------
			//Start of NUMER component
			$highBp_measure.='<component>
					<observation classCode="OBS" moodCode="EVN">
					<!-- Measure Data template -->
					<templateId root="2.16.840.1.113883.10.20.27.3.5"/>
					<code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4"
					displayName="Assertion" codeSystemName="ActCode"/>
					<statusCode code="completed"/>
					<!-- SHALL value with SHOULD be from valueSetName="ObservationPopulationInclusion "	valueSetOid="2.16.840.1.113883.1.11.20369"	Binding: Dynamic
					-->
					<value xsi:type="CD" code="NUMER"
					codeSystem="2.16.840.1.113883.5.1063"
					displayName="Numerator" codeSystemName="ObservationValue"/>
					<!-- SHALL contain aggregate count template -->
					<entryRelationship typeCode="SUBJ" inversionInd="true">
					<!-- Aggregate Count (2.16.840.1.113883.10.20.27.3.3) -->
					<observation classCode="OBS" moodCode="EVN">
					<!-- Aggregate Count template -->
					<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
					<code code="MSRAGG" displayName="rate aggregation"
					codeSystem="2.16.840.1.113883.5.4"
					codeSystemName="ActCode"/>
					<!--  SHALL value xsi:type="INT"-->
					<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['numerator'].'"/>
							<methodCode code="COUNT" displayName="Count"
							codeSystem="2.16.840.1.113883.5.84"
							codeSystemName="ObservationMethod"/>
							<!-- MAY 0..1 Used to represent the predicted count based on the measures risk-adjustment model. -->
							<referenceRange>
							<observationRange>
							<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['numerator'].'"/>
									</observationRange>
									</referenceRange>
									</observation>
									</entryRelationship>
									<entryRelationship typeCode="COMP">
									<!-- Postal Code Supplemental Data Element (2.16.840.1.113883.10.20.27.3.10)-->
									<observation classCode="OBS" moodCode="EVN">
									<!-- Postal Code Supplemental Data Element template ID -->
									<templateId root="2.16.840.1.113883.10.20.27.3.10"/>
									<!-- SHALL single value binding -->
									<code code="184102003" displayName="patient postal code"
									codeSystem="2.16.840.1.113883.6.96"
									codeSystemName="SNOMED-CT"/>
									<statusCode code="completed"/>
									<!-- SHALL be xsi:type="ST"-->
									<value xsi:type="ST">92543</value>
									<!-- SHALL 1..1 Aggregate Count template -->
									<entryRelationship typeCode="SUBJ" inversionInd="true">
									<observation classCode="OBS" moodCode="EVN">
									<!-- Aggregate Count template -->
									<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
									<code code="MSRAGG" displayName="rate aggregation"
									codeSystem="2.16.840.1.113883.5.4"
									codeSystemName="ActCode"/>
									<!--  SHALL value xsi:type="INT"-->
									<value xsi:type="INT" value="6"/>
									<methodCode code="COUNT" displayName="Count"
									codeSystem="2.16.840.1.113883.5.84"
									codeSystemName="ObservationMethod"/>
									</observation>
									</entryRelationship>
									</observation>
									</entryRelationship>
									<entryRelationship typeCode="COMP">
									<!-- Ethnicity Supplemental Data Element (2.16.840.1.113883.10.20.27.3.7) -->
									<observation classCode="OBS" moodCode="EVN">
									<!-- Ethnicity Supplemental Data Element template ID -->
									<templateId root="2.16.840.1.113883.10.20.27.3.7"/>
									<!-- SHALL single value binding -->
									<code code="364699009" displayName="Ethnic Group"
									codeSystem="2.16.840.1.113883.6.96"
									codeSystemName="SNOMED CT"/>
									<statusCode code="completed"/>
									<!-- SHALL be bound to CDC Ethnicity group Value Set OID 2.16.840.1.114222.4.11.837 - dynamic -->
									<!-- Not hispanic -->
									<value xsi:type="CD" code="2186-5"
									displayName="Not Hispanic or Latino"
									codeSystem="2.16.840.1.113883.6.238"
									codeSystemName="Race &amp; Ethnicity - CDC"/>
									<!-- SHALL 1..1 Aggregate Count template -->
									<entryRelationship typeCode="SUBJ" inversionInd="true">
									<observation classCode="OBS" moodCode="EVN">
									<!-- Aggregate Count template -->
									<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
									<code code="MSRAGG" displayName="rate aggregation"
									codeSystem="2.16.840.1.113883.5.4"
									codeSystemName="ActCode"/>
									<!--  SHALL value xsi:type="INT" need to change-->
									<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['num_ethnicity'].'"/>
											<methodCode code="COUNT" displayName="Count"
											codeSystem="2.16.840.1.113883.5.84"
											codeSystemName="ObservationMethod"/>
											</observation>
											</entryRelationship>
											</observation>
											</entryRelationship>
											<entryRelationship typeCode="COMP">
											<!-- Ethnicity Supplemental Data Element (2.16.840.1.113883.10.20.27.3.7) -->
											<observation classCode="OBS" moodCode="EVN">
											<!-- Ethnicity Supplemental Data Element template ID -->
											<templateId root="2.16.840.1.113883.10.20.27.3.7"/>
											<code code="364699009" displayName="Ethnic Group"
											codeSystem="2.16.840.1.113883.6.96"
											codeSystemName="SNOMED CT"/>
											<statusCode code="completed"/>
											<!-- SHALL be bound to CDC Ethnicity group Value Set OID 2.16.840.1.114222.4.11.837 - dynamic -->
											<!-- Hispanic -->
											<value xsi:type="CD" code="2135-2"
											displayName="Hispanic or Latino"
											codeSystem="2.16.840.1.113883.6.238"
											codeSystemName="Race &amp; Ethnicity - CDC"/>
											<!-- SHALL 1..1 Aggregate Count template -->
											<entryRelationship typeCode="SUBJ" inversionInd="true">
											<observation classCode="OBS" moodCode="EVN">
											<!-- Aggregate Count template -->
											<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
											<code code="MSRAGG" displayName="rate aggregation"
											codeSystem="2.16.840.1.113883.5.4"
											codeSystemName="ActCode"/>
											<!--  SHALL value xsi:type="INT"-->
											<value xsi:type="INT" value="260"/>
											<methodCode code="COUNT" displayName="Count"
											codeSystem="2.16.840.1.113883.5.84"
											codeSystemName="ObservationMethod"/>
											</observation>
											</entryRelationship>
											</observation>
											</entryRelationship>
											<entryRelationship typeCode="COMP">
											<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
											<observation classCode="OBS" moodCode="EVN">
											<!-- Race Supplemental Data Element template ID -->
											<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
											<code code="103579009" displayName="Race"
											codeSystem="2.16.840.1.113883.6.96"
											codeSystemName="SNOMED CT"/>
											<statusCode code="completed"/>
											<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
											<value xsi:type="CD" code="1002-5"
											displayName="American Indian or Alaska Native"
											codeSystem="2.16.840.1.113883.6.238"
											codeSystemName="Race &amp; Ethnicity - CDC"/>
											<entryRelationship typeCode="SUBJ" inversionInd="true">
											<observation classCode="OBS" moodCode="EVN">
											<!-- SHALL 1..1 Aggregate Count template -->
											<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
											<code code="MSRAGG" displayName="rate aggregation"
											codeSystem="2.16.840.1.113883.5.4"
											codeSystemName="ActCode"/>
											<!--  SHALL value xsi:type="INT" to be changed  need to check why value needs to be changed here-->
											<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['num_race'].'"/>
													<methodCode code="COUNT" displayName="Count"
													codeSystem="2.16.840.1.113883.5.84"
													codeSystemName="ObservationMethod"/>
													</observation>
													</entryRelationship>
													</observation>
													</entryRelationship>
													<entryRelationship typeCode="COMP">
													<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
													<observation classCode="OBS" moodCode="EVN">
													<!-- Race Supplemental Data Element template ID -->
													<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
													<code code="103579009" displayName="Race"
													codeSystem="2.16.840.1.113883.6.96"
													codeSystemName="SNOMED CT"/>
													<statusCode code="completed"/>
													<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
													<value xsi:type="CD" code="2131-1" displayName="White"
													codeSystem="2.16.840.1.113883.6.238"
													codeSystemName="Race &amp; Ethnicity - CDC"/>
													<entryRelationship typeCode="SUBJ" inversionInd="true">
													<observation classCode="OBS" moodCode="EVN">
													<!-- SHALL 1..1 Aggregate Count template -->
													<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
													<code code="MSRAGG" displayName="rate aggregation"
													codeSystem="2.16.840.1.113883.5.4"
													codeSystemName="ActCode"/>
													<!--  SHALL value xsi:type="INT"-->
													<value xsi:type="INT" value="140"/>
													<methodCode code="COUNT" displayName="Count"
													codeSystem="2.16.840.1.113883.5.84"
													codeSystemName="ObservationMethod"/>
													</observation>
													</entryRelationship>
													</observation>
													</entryRelationship>
													<entryRelationship typeCode="COMP">
													<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
													<observation classCode="OBS" moodCode="EVN">
													<!-- Race Supplemental Data Element template ID -->
													<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
													<code code="103579009" displayName="Race"
													codeSystem="2.16.840.1.113883.6.96"
													codeSystemName="SNOMED CT"/>
													<statusCode code="completed"/>
													<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
													<value xsi:type="CD" code="2028-9" displayName="Asian"
													codeSystem="2.16.840.1.113883.6.238"
													codeSystemName="Race &amp; Ethnicity - CDC"/>
													<entryRelationship typeCode="SUBJ" inversionInd="true">
													<observation classCode="OBS" moodCode="EVN">
													<!-- SHALL 1..1 Aggregate Count template -->
													<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
													<code code="MSRAGG" displayName="rate aggregation"
													codeSystem="2.16.840.1.113883.5.4"
													codeSystemName="ActCode"/>
													<!--  SHALL value xsi:type="INT"-->
													<value xsi:type="INT" value="140"/>
													<methodCode code="COUNT" displayName="Count"
													codeSystem="2.16.840.1.113883.5.84"
													codeSystemName="ObservationMethod"/>
													</observation>
													</entryRelationship>
													</observation>
													</entryRelationship>
													<entryRelationship typeCode="COMP">
													<!-- Sex Supplemental Data Element (2.16.840.1.113883.10.20.27.3.6) -->
													<observation classCode="OBS" moodCode="EVN">
													<!-- Sex Supplemental Data Element template ID -->
													<templateId root="2.16.840.1.113883.10.20.27.3.6"/>
													<!-- SHALL be single value binding to: -->
													<code code="184100006" displayName="patient sex"
													codeSystem="2.16.840.1.113883.6.96"
													codeSystemName="SNOMED-CT"/>
													<statusCode code="completed"/>
													<!-- SHALL be drawn from  Value Set: Administrative Gender (HL7 V3) 2.16.840.1.113883.1.11.1 DYNAMIC-->
													<!-- Example female -->
													<value xsi:type="CD" code="F"
													codeSystem="2.16.840.1.113883.5.1"
													codeSystemName="HL7AdministrativeGenderCode"/>
													<entryRelationship typeCode="SUBJ" inversionInd="true">
													<observation classCode="OBS" moodCode="EVN">
													<!-- SHALL 1..1 Aggregate Count template -->
													<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
													<code code="MSRAGG" displayName="rate aggregation"
													codeSystem="2.16.840.1.113883.5.4"
													codeSystemName="ActCode"/>
													<!--  SHALL value xsi:type="INT"-->
													<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['num_female'].'"/>
															<methodCode code="COUNT" displayName="Count"
															codeSystem="2.16.840.1.113883.5.84"
															codeSystemName="ObservationMethod"/>
															</observation>
															</entryRelationship>
															</observation>
															</entryRelationship>
															<entryRelationship typeCode="COMP">
															<!-- Sex Supplemental Data Element (2.16.840.1.113883.10.20.27.3.6) -->
															<observation classCode="OBS" moodCode="EVN">
															<!-- Sex Supplemental Data Element template ID -->
															<templateId root="2.16.840.1.113883.10.20.27.3.6"/>
															<!-- SHALL be single value binding to: -->
															<code code="184100006" displayName="patient sex"
															codeSystem="2.16.840.1.113883.6.96"
															codeSystemName="SNOMED-CT"/>
															<statusCode code="completed"/>
															<!-- SHALL be drawn from  Value Set: Administrative Gender (HL7 V3) 2.16.840.1.113883.1.11.1 DYNAMIC-->
															<value xsi:type="CD" code="M"
															codeSystem="2.16.840.1.113883.5.1"
															codeSystemName="HL7AdministrativeGenderCode"/>
															<entryRelationship typeCode="SUBJ" inversionInd="true">
															<observation classCode="OBS" moodCode="EVN">
															<!-- SHALL 1..1 Aggregate Count template -->
															<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
															<code code="MSRAGG" displayName="rate aggregation"
															codeSystem="2.16.840.1.113883.5.4"
															codeSystemName="ActCode"/>
															<!--  SHALL value xsi:type="INT" to be changed-->
															<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['num_male'].'"/>
																	<methodCode code="COUNT" displayName="Count"
																	codeSystem="2.16.840.1.113883.5.84"
																	codeSystemName="ObservationMethod"/>
																	</observation>
																	</entryRelationship>
																	</observation>
																	</entryRelationship>
																	<entryRelationship typeCode="COMP">
																	<!-- Payer Supplemental Data Element (2.16.840.1.113883.10.20.27.3.9) -->
																	<observation classCode="OBS" moodCode="EVN">
																	<!-- Conforms to Patient Characteristic Payer -->
																	<templateId root="2.16.840.1.113883.10.20.24.3.55"/>
																	<!-- Payer Supplemental Data Element template ID -->
																	<templateId root="2.16.840.1.113883.10.20.27.3.9"/>
																	<!-- implied template requires ID -->
																	<id nullFlavor="NA"/>
																	<!-- SHALL be single value binding to: -->
																	<code code="48768-6" displayName="Payment source"
																	codeSystem="2.16.840.1.113883.6.1"
																	codeSystemName="SNOMED-CT"/>
																	<statusCode code="completed"/>
																	<!-- SHALL be drawn from  Value Set: PHDSC Source of Payment Typology 2.16.840.1.114222.4.11.3591 DYNAMIC-->
																	<value xsi:type="CD" code="349"
																	codeSystem="2.16.840.1.113883.3.221.5"
																	codeSystemName="Source of Payment Typology"
																	displayName="Medicare"/>
																	<entryRelationship typeCode="SUBJ" inversionInd="true">
																	<observation classCode="OBS" moodCode="EVN">
																	<!-- SHALL 1..1 Aggregate Count template -->
																	<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
																	<code code="MSRAGG" displayName="rate aggregation"
																	codeSystem="2.16.840.1.113883.5.4"
																	codeSystemName="ActCode"/>
																	<!--  SHALL value xsi:type="INT"-->
																	<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['numerator'].'"/>
																			<methodCode code="COUNT" displayName="Count"
																			codeSystem="2.16.840.1.113883.5.84"
																			codeSystemName="ObservationMethod"/>
																			</observation>
																			</entryRelationship>
																			</observation>
																			</entryRelationship>
																			<entryRelationship typeCode="COMP">
																			<!-- Payer Supplemental Data Element (2.16.840.1.113883.10.20.27.3.9) -->
																			<observation classCode="OBS" moodCode="EVN">
																			<!-- Conforms to Patient Characteristic Payer -->
																			<templateId root="2.16.840.1.113883.10.20.24.3.55"/>
																			<!-- Payer Supplemental Data Element template ID -->
																			<templateId root="2.16.840.1.113883.10.20.27.3.9"/>
																			<!-- implied template requires ID -->
																			<id nullFlavor="NA"/>
																			<!-- SHALL be single value binding to: -->
																			<code code="48768-6" displayName="Payment source"
																			codeSystem="2.16.840.1.113883.6.1"
																			codeSystemName="SNOMED-CT"/>
																			<statusCode code="completed"/>
																			<!-- SHALL be drawn from  Value Set: PHDSC Source of Payment Typology 2.16.840.1.114222.4.11.3591 DYNAMIC-->
																			<value xsi:type="CD" code="349"
																			codeSystem="2.16.840.1.113883.3.221.5"
																			codeSystemName="Source of Payment Typology"
																			displayName="Medicaid"/>
																			<entryRelationship typeCode="SUBJ" inversionInd="true">
																			<observation classCode="OBS" moodCode="EVN">
																			<!-- SHALL 1..1 Aggregate Count template -->
																			<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
																			<code code="MSRAGG" displayName="rate aggregation"
																			codeSystem="2.16.840.1.113883.5.4"
																			codeSystemName="ActCode"/>
																			<!--  SHALL value xsi:type="INT" to be changed-->
																			<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['numerator'].'"/>
																					<methodCode code="COUNT" displayName="Count"
																					codeSystem="2.16.840.1.113883.5.84"
																					codeSystemName="ObservationMethod"/>
																					</observation>
																					</entryRelationship>
																					</observation>
																					</entryRelationship>
																					<!-- SHALL 1..1  (Note: this is the reference for the entire population starting with the first component
																					observation at the top within the measure data template-->
																					<reference typeCode="REFR">
																					<!-- reference to the relevant population in the eMeasure -->
																					<externalObservation classCode="OBS" moodCode="EVN">
																					<id root="'.$moredata[0]['CqmList']['numerator_rootid'].'"/>
																							</externalObservation>
																							</reference>
																							</observation>
																							</component>';
			//end of NUMER component

			//start of DENEX component
			if($moredata[0]['CqmList']['exclusions_rootid']!="")
			{
				$highBp_measure.='<component>
						<observation classCode="OBS" moodCode="EVN">
						<!-- Measure Data template -->
						<templateId root="2.16.840.1.113883.10.20.27.3.5"/>
						<code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4"
						displayName="Assertion" codeSystemName="ActCode"/>
						<statusCode code="completed"/>
						<!-- SHALL value with SHOULD be from valueSetName="ObservationPopulationInclusion "	valueSetOid="2.16.840.1.113883.1.11.20369"	Binding: Dynamic
						-->
						<value xsi:type="CD" code="DENEX"
						codeSystem="2.16.840.1.113883.5.1063"
						displayName="Denominator Exclusions"
						codeSystemName="ObservationValue"/>
						<!-- SHALL contain aggregate count template -->
						<entryRelationship typeCode="SUBJ" inversionInd="true">
						<!-- Aggregate Count (2.16.840.1.113883.10.20.27.3.3) -->
						<observation classCode="OBS" moodCode="EVN">
						<!-- Aggregate Count template -->
						<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
						<code code="MSRAGG" displayName="rate aggregation"
						codeSystem="2.16.840.1.113883.5.4"
						codeSystemName="ActCode"/>
						<!--  SHALL value xsi:type="INT"-->
						<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['den_exclusion'].'"/>
								<methodCode code="COUNT" displayName="Count"
								codeSystem="2.16.840.1.113883.5.84"
								codeSystemName="ObservationMethod"/>
								</observation>
								</entryRelationship>
								<entryRelationship typeCode="COMP">
								<!-- Postal Code Supplemental Data Element (2.16.840.1.113883.10.20.27.3.10)-->
								<observation classCode="OBS" moodCode="EVN">
								<!-- Postal Code Supplemental Data Element template ID -->
								<templateId root="2.16.840.1.113883.10.20.27.3.10"/>
								<!-- SHALL single value binding -->
								<code code="184102003" displayName="patient postal code"
								codeSystem="2.16.840.1.113883.6.96"
								codeSystemName="SNOMED-CT"/>
								<statusCode code="completed"/>
								<!-- SHALL be xsi:type="ST"-->
								<value xsi:type="ST">92543</value>
								<!-- SHALL 1..1 Aggregate Count template -->
								<entryRelationship typeCode="SUBJ" inversionInd="true">
								<observation classCode="OBS" moodCode="EVN">
								<!-- Aggregate Count template -->
								<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
								<code code="MSRAGG" displayName="rate aggregation"
								codeSystem="2.16.840.1.113883.5.4"
								codeSystemName="ActCode"/>
								<!--  SHALL value xsi:type="INT"-->
								<value xsi:type="INT" value="0"/>
								<methodCode code="COUNT" displayName="Count"
								codeSystem="2.16.840.1.113883.5.84"
								codeSystemName="ObservationMethod"/>
								</observation>
								</entryRelationship>
								</observation>
								</entryRelationship>
								<entryRelationship typeCode="COMP">
								<!-- Ethnicity Supplemental Data Element (2.16.840.1.113883.10.20.27.3.7) -->
								<observation classCode="OBS" moodCode="EVN">
								<!-- Ethnicity Supplemental Data Element template ID -->
								<templateId root="2.16.840.1.113883.10.20.27.3.7"/>
								<!-- SHALL single value binding -->
								<code code="364699009" displayName="Ethnic Group"
								codeSystem="2.16.840.1.113883.6.96"
								codeSystemName="SNOMED CT"/>
								<statusCode code="completed"/>
								<!-- SHALL be bound to CDC Ethnicity group Value Set OID 2.16.840.1.114222.4.11.837 - dynamic -->
								<!-- Not hispanic -->
								<value xsi:type="CD" code="2186-5"
								displayName="Not Hispanic or Latino"
								codeSystem="2.16.840.1.113883.6.238"
								codeSystemName="Race &amp; Ethnicity - CDC"/>
								<!-- SHALL 1..1 Aggregate Count template -->
								<entryRelationship typeCode="SUBJ" inversionInd="true">
								<observation classCode="OBS" moodCode="EVN">
								<!-- Aggregate Count template -->
								<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
								<code code="MSRAGG" displayName="rate aggregation"
								codeSystem="2.16.840.1.113883.5.4"
								codeSystemName="ActCode"/>
								<!--  SHALL value xsi:type="INT"-->
								<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['exclu_ethnicity'].'"/>
										<methodCode code="COUNT" displayName="Count"
										codeSystem="2.16.840.1.113883.5.84"
										codeSystemName="ObservationMethod"/>
										</observation>
										</entryRelationship>
										</observation>
										</entryRelationship>
										<entryRelationship typeCode="COMP">
										<!-- Ethnicity Supplemental Data Element (2.16.840.1.113883.10.20.27.3.7) -->
										<observation classCode="OBS" moodCode="EVN">
										<!-- Ethnicity Supplemental Data Element template ID -->
										<templateId root="2.16.840.1.113883.10.20.27.3.7"/>
										<code code="364699009" displayName="Ethnic Group"
										codeSystem="2.16.840.1.113883.6.96"
										codeSystemName="SNOMED CT"/>
										<statusCode code="completed"/>
										<!-- SHALL be bound to CDC Ethnicity group Value Set OID 2.16.840.1.114222.4.11.837 - dynamic -->
										<!-- Hispanic -->
										<value xsi:type="CD" code="2135-2"
										displayName="Hispanic or Latino"
										codeSystem="2.16.840.1.113883.6.238"
										codeSystemName="Race &amp; Ethnicity - CDC"/>
										<!-- SHALL 1..1 Aggregate Count template -->
										<entryRelationship typeCode="SUBJ" inversionInd="true">
										<observation classCode="OBS" moodCode="EVN">
										<!-- Aggregate Count template -->
										<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
										<code code="MSRAGG" displayName="rate aggregation"
										codeSystem="2.16.840.1.113883.5.4"
										codeSystemName="ActCode"/>
										<!--  SHALL value xsi:type="INT"-->
										<value xsi:type="INT" value="13"/>
										<methodCode code="COUNT" displayName="Count"
										codeSystem="2.16.840.1.113883.5.84"
										codeSystemName="ObservationMethod"/>
										</observation>
										</entryRelationship>
										</observation>
										</entryRelationship>
										<entryRelationship typeCode="COMP">
										<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
										<observation classCode="OBS" moodCode="EVN">
										<!-- Race Supplemental Data Element template ID -->
										<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
										<code code="103579009" displayName="Race"
										codeSystem="2.16.840.1.113883.6.96"
										codeSystemName="SNOMED CT"/>
										<statusCode code="completed"/>
										<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
										<value xsi:type="CD" code="1002-5"
										displayName="American Indian or Alaska Native"
										codeSystem="2.16.840.1.113883.6.238"
										codeSystemName="Race &amp; Ethnicity - CDC"/>
										<entryRelationship typeCode="SUBJ" inversionInd="true">
										<observation classCode="OBS" moodCode="EVN">
										<!-- SHALL 1..1 Aggregate Count template -->
										<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
										<code code="MSRAGG" displayName="rate aggregation"
										codeSystem="2.16.840.1.113883.5.4"
										codeSystemName="ActCode"/>
										<!--  SHALL value xsi:type="INT"-->
										<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['exclu_race'].'"/>
												<methodCode code="COUNT" displayName="Count"
												codeSystem="2.16.840.1.113883.5.84"
												codeSystemName="ObservationMethod"/>
												</observation>
												</entryRelationship>
												</observation>
												</entryRelationship>
												<entryRelationship typeCode="COMP">
												<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
												<observation classCode="OBS" moodCode="EVN">
												<!-- Race Supplemental Data Element template ID -->
												<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
												<code code="103579009" displayName="Race"
												codeSystem="2.16.840.1.113883.6.96"
												codeSystemName="SNOMED CT"/>
												<statusCode code="completed"/>
												<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
												<value xsi:type="CD" code="2131-1" displayName="White"
												codeSystem="2.16.840.1.113883.6.238"
												codeSystemName="Race &amp; Ethnicity - CDC"/>
												<entryRelationship typeCode="SUBJ" inversionInd="true">
												<observation classCode="OBS" moodCode="EVN">
												<!-- SHALL 1..1 Aggregate Count template -->
												<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
												<code code="MSRAGG" displayName="rate aggregation"
												codeSystem="2.16.840.1.113883.5.4"
												codeSystemName="ActCode"/>
												<!--  SHALL value xsi:type="INT"-->
												<value xsi:type="INT" value="7"/>
												<methodCode code="COUNT" displayName="Count"
												codeSystem="2.16.840.1.113883.5.84"
												codeSystemName="ObservationMethod"/>
												</observation>
												</entryRelationship>
												</observation>
												</entryRelationship>
												<entryRelationship typeCode="COMP">
												<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
												<observation classCode="OBS" moodCode="EVN">
												<!-- Race Supplemental Data Element template ID -->
												<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
												<code code="103579009" displayName="Race"
												codeSystem="2.16.840.1.113883.6.96"
												codeSystemName="SNOMED CT"/>
												<statusCode code="completed"/>
												<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
												<value xsi:type="CD" code="2028-9" displayName="Asian"
												codeSystem="2.16.840.1.113883.6.238"
												codeSystemName="Race &amp; Ethnicity - CDC"/>
												<entryRelationship typeCode="SUBJ" inversionInd="true">
												<observation classCode="OBS" moodCode="EVN">
												<!-- SHALL 1..1 Aggregate Count template -->
												<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
												<code code="MSRAGG" displayName="rate aggregation"
												codeSystem="2.16.840.1.113883.5.4"
												codeSystemName="ActCode"/>
												<!--  SHALL value xsi:type="INT"-->
												<value xsi:type="INT" value="7"/>
												<methodCode code="COUNT" displayName="Count"
												codeSystem="2.16.840.1.113883.5.84"
												codeSystemName="ObservationMethod"/>
												</observation>
												</entryRelationship>
												</observation>
												</entryRelationship>
												<entryRelationship typeCode="COMP">
												<!-- Sex Supplemental Data Element (2.16.840.1.113883.10.20.27.3.6) -->
												<observation classCode="OBS" moodCode="EVN">
												<!-- Sex Supplemental Data Element template ID -->
												<templateId root="2.16.840.1.113883.10.20.27.3.6"/>
												<!-- SHALL be single value binding to: -->
												<code code="184100006" displayName="patient sex"
												codeSystem="2.16.840.1.113883.6.96"
												codeSystemName="SNOMED-CT"/>
												<statusCode code="completed"/>
												<!-- SHALL be drawn from  Value Set: Administrative Gender (HL7 V3) 2.16.840.1.113883.1.11.1 DYNAMIC-->
												<!-- Example female -->
												<value xsi:type="CD" code="F"
												codeSystem="2.16.840.1.113883.5.1"
												codeSystemName="HL7AdministrativeGenderCode"/>
												<entryRelationship typeCode="SUBJ" inversionInd="true">
												<observation classCode="OBS" moodCode="EVN">
												<!-- SHALL 1..1 Aggregate Count template -->
												<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
												<code code="MSRAGG" displayName="rate aggregation"
												codeSystem="2.16.840.1.113883.5.4"
												codeSystemName="ActCode"/>
												<!--  SHALL value xsi:type="INT"-->
												<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['exclu_female'].'"/>
														<methodCode code="COUNT" displayName="Count"
														codeSystem="2.16.840.1.113883.5.84"
														codeSystemName="ObservationMethod"/>
														</observation>
														</entryRelationship>
														</observation>
														</entryRelationship>
														<entryRelationship typeCode="COMP">
														<!-- Sex Supplemental Data Element (2.16.840.1.113883.10.20.27.3.6) -->
														<observation classCode="OBS" moodCode="EVN">
														<!-- Sex Supplemental Data Element template ID -->
														<templateId root="2.16.840.1.113883.10.20.27.3.6"/>
														<!-- SHALL be single value binding to: -->
														<code code="184100006" displayName="patient sex"
														codeSystem="2.16.840.1.113883.6.96"
														codeSystemName="SNOMED-CT"/>
														<statusCode code="completed"/>
														<!-- SHALL be drawn from  Value Set: Administrative Gender (HL7 V3) 2.16.840.1.113883.1.11.1 DYNAMIC-->
														<value xsi:type="CD" code="M"
														codeSystem="2.16.840.1.113883.5.1"
														codeSystemName="HL7AdministrativeGenderCode"/>
														<entryRelationship typeCode="SUBJ" inversionInd="true">
														<observation classCode="OBS" moodCode="EVN">
														<!-- SHALL 1..1 Aggregate Count template -->
														<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
														<code code="MSRAGG" displayName="rate aggregation"
														codeSystem="2.16.840.1.113883.5.4"
														codeSystemName="ActCode"/>
														<!--  SHALL value xsi:type="INT"-->
														<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['exclu_male'].'"/>
																<methodCode code="COUNT" displayName="Count"
																codeSystem="2.16.840.1.113883.5.84"
																codeSystemName="ObservationMethod"/>
																</observation>
																</entryRelationship>
																</observation>
																</entryRelationship>
																<entryRelationship typeCode="COMP">
																<!-- Payer Supplemental Data Element (2.16.840.1.113883.10.20.27.3.9) -->
																<observation classCode="OBS" moodCode="EVN">
																<!-- Conforms to Patient Characteristic Payer -->
																<templateId root="2.16.840.1.113883.10.20.24.3.55"/>
																<!-- Payer Supplemental Data Element template ID -->
																<templateId root="2.16.840.1.113883.10.20.27.3.9"/>
																<!-- implied template requires ID -->
																<id nullFlavor="NA"/>
																<!-- SHALL be single value binding to: -->
																<code code="48768-6" displayName="Payment source"
																codeSystem="2.16.840.1.113883.6.1"
																codeSystemName="SNOMED-CT"/>
																<statusCode code="completed"/>
																<!-- SHALL be drawn from  Value Set: PHDSC Source of Payment Typology 2.16.840.1.114222.4.11.3591 DYNAMIC-->
																<value xsi:type="CD" code="349"
																codeSystem="2.16.840.1.113883.3.221.5"
																codeSystemName="Source of Payment Typology"
																displayName="Medicare"/>
																<entryRelationship typeCode="SUBJ" inversionInd="true">
																<observation classCode="OBS" moodCode="EVN">
																<!-- SHALL 1..1 Aggregate Count template -->
																<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
																<code code="MSRAGG" displayName="rate aggregation"
																codeSystem="2.16.840.1.113883.5.4"
																codeSystemName="ActCode"/>
																<!--  SHALL value xsi:type="INT"-->
																<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['den_exclusion'].'"/>
																		<methodCode code="COUNT" displayName="Count"
																		codeSystem="2.16.840.1.113883.5.84"
																		codeSystemName="ObservationMethod"/>
																		</observation>
																		</entryRelationship>
																		</observation>
																		</entryRelationship>
																		<entryRelationship typeCode="COMP">
																		<!-- Payer Supplemental Data Element (2.16.840.1.113883.10.20.27.3.9) -->
																		<observation classCode="OBS" moodCode="EVN">
																		<!-- Conforms to Patient Characteristic Payer -->
																		<templateId root="2.16.840.1.113883.10.20.24.3.55"/>
																		<!-- Payer Supplemental Data Element template ID -->
																		<templateId root="2.16.840.1.113883.10.20.27.3.9"/>
																		<!-- implied template requires ID -->
																		<id nullFlavor="NA"/>
																		<!-- SHALL be single value binding to: -->
																		<code code="48768-6" displayName="Payment source"
																		codeSystem="2.16.840.1.113883.6.1"
																		codeSystemName="SNOMED-CT"/>
																		<statusCode code="completed"/>
																		<!-- SHALL be drawn from  Value Set: PHDSC Source of Payment Typology 2.16.840.1.114222.4.11.3591 DYNAMIC-->
																		<value xsi:type="CD" code="349"
																		codeSystem="2.16.840.1.113883.3.221.5"
																		codeSystemName="Source of Payment Typology"
																		displayName="Medicaid"/>
																		<entryRelationship typeCode="SUBJ" inversionInd="true">
																		<observation classCode="OBS" moodCode="EVN">
																		<!-- SHALL 1..1 Aggregate Count template -->
																		<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
																		<code code="MSRAGG" displayName="rate aggregation"
																		codeSystem="2.16.840.1.113883.5.4"
																		codeSystemName="ActCode"/>
																		<!--  SHALL value xsi:type="INT"-->
																		<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['den_exclusion'].'"/>
																				<methodCode code="COUNT" displayName="Count"
																				codeSystem="2.16.840.1.113883.5.84"
																				codeSystemName="ObservationMethod"/>
																				</observation>
																				</entryRelationship>
																				</observation>
																				</entryRelationship>
																				<!-- SHALL 1..1  (Note: this is the reference for the entire population starting with the first component
																				observation at the top within the measure data template-->
																				<reference typeCode="REFR">
																				<!-- reference to the relevant population in the eMeasure -->
																				<externalObservation classCode="OBS" moodCode="EVN">
																				<id root="'.$moredata[0]['CqmList']['exclusions_rootid'].'"/>
																						</externalObservation>
																						</reference>
																						</observation>
																						</component>';
			}

			//end of DENEX component

			//start of DENEXCEP component
			if($moredata[0]['CqmList']['denexcep_rootid']!="")
			{
				$highBp_measure.='<component>
						<observation classCode="OBS" moodCode="EVN">
						<!-- Measure Data template -->
						<templateId root="2.16.840.1.113883.10.20.27.3.5"/>
						<code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4"
						displayName="Assertion" codeSystemName="ActCode"/>
						<statusCode code="completed"/>
						<!-- SHALL value with SHOULD be from valueSetName="ObservationPopulationInclusion "	valueSetOid="2.16.840.1.113883.1.11.20369"	Binding: Dynamic
						-->
						<value xsi:type="CD" code="DENEXCEP"
						codeSystem="2.16.840.1.113883.5.1063"
						displayName="Denominator Exceptions"
						codeSystemName="ObservationValue"/>
						<!-- SHALL contain aggregate count template -->
						<entryRelationship typeCode="SUBJ" inversionInd="true">
						<!-- Aggregate Count (2.16.840.1.113883.10.20.27.3.3) -->
						<observation classCode="OBS" moodCode="EVN">
						<!-- Aggregate Count template -->
						<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
						<code code="MSRAGG" displayName="rate aggregation"
						codeSystem="2.16.840.1.113883.5.4"
						codeSystemName="ActCode"/>
						<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['den_exception'].'"/>
								<methodCode code="COUNT" displayName="Count"
								codeSystem="2.16.840.1.113883.5.84"
								codeSystemName="ObservationMethod"/>
								</observation>
								</entryRelationship>

								<entryRelationship typeCode="COMP">
								<!-- Postal Code Supplemental Data Element (2.16.840.1.113883.10.20.27.3.10)-->
								<observation classCode="OBS" moodCode="EVN">
								<!-- Postal Code Supplemental Data Element template ID -->
								<templateId root="2.16.840.1.113883.10.20.27.3.10"/>
								<!-- SHALL single value binding -->
								<code code="184102003" displayName="patient postal code"
								codeSystem="2.16.840.1.113883.6.96"
								codeSystemName="SNOMED-CT"/>
								<statusCode code="completed"/>
								<!-- SHALL be xsi:type="ST"-->
								<value xsi:type="ST">92543</value>
								<!-- SHALL 1..1 Aggregate Count template -->
								<entryRelationship typeCode="SUBJ" inversionInd="true">
								<observation classCode="OBS" moodCode="EVN">
								<!-- Aggregate Count template -->
								<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
								<code code="MSRAGG" displayName="rate aggregation"
								codeSystem="2.16.840.1.113883.5.4"
								codeSystemName="ActCode"/>
								<!--  SHALL value xsi:type="INT"-->
								<value xsi:type="INT" value="0"/>
								<methodCode code="COUNT" displayName="Count"
								codeSystem="2.16.840.1.113883.5.84"
								codeSystemName="ObservationMethod"/>
								</observation>
								</entryRelationship>
								</observation>
								</entryRelationship>
								<entryRelationship typeCode="COMP">
								<!-- Ethnicity Supplemental Data Element (2.16.840.1.113883.10.20.27.3.7) -->
								<observation classCode="OBS" moodCode="EVN">
								<!-- Ethnicity Supplemental Data Element template ID -->
								<templateId root="2.16.840.1.113883.10.20.27.3.7"/>
								<!-- SHALL single value binding -->
								<code code="364699009" displayName="Ethnic Group"
								codeSystem="2.16.840.1.113883.6.96"
								codeSystemName="SNOMED CT"/>
								<statusCode code="completed"/>
								<!-- SHALL be bound to CDC Ethnicity group Value Set OID 2.16.840.1.114222.4.11.837 - dynamic -->
								<!-- Not hispanic -->
								<value xsi:type="CD" code="2186-5"
								displayName="Not Hispanic or Latino"
								codeSystem="2.16.840.1.113883.6.238"
								codeSystemName="Race &amp; Ethnicity - CDC"/>
								<!-- SHALL 1..1 Aggregate Count template -->
								<entryRelationship typeCode="SUBJ" inversionInd="true">
								<observation classCode="OBS" moodCode="EVN">
								<!-- Aggregate Count template -->
								<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
								<code code="MSRAGG" displayName="rate aggregation"
								codeSystem="2.16.840.1.113883.5.4"
								codeSystemName="ActCode"/>
								<!--  SHALL value xsi:type="INT"-->
								<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['excep_ethnicity'].'"/>
										<methodCode code="COUNT" displayName="Count"
										codeSystem="2.16.840.1.113883.5.84"
										codeSystemName="ObservationMethod"/>
										</observation>
										</entryRelationship>
										</observation>
										</entryRelationship>
										<entryRelationship typeCode="COMP">
										<!-- Ethnicity Supplemental Data Element (2.16.840.1.113883.10.20.27.3.7) -->
										<observation classCode="OBS" moodCode="EVN">
										<!-- Ethnicity Supplemental Data Element template ID -->
										<templateId root="2.16.840.1.113883.10.20.27.3.7"/>
										<code code="364699009" displayName="Ethnic Group"
										codeSystem="2.16.840.1.113883.6.96"
										codeSystemName="SNOMED CT"/>
										<statusCode code="completed"/>
										<!-- SHALL be bound to CDC Ethnicity group Value Set OID 2.16.840.1.114222.4.11.837 - dynamic -->
										<!-- Hispanic -->
										<value xsi:type="CD" code="2135-2"
										displayName="Hispanic or Latino"
										codeSystem="2.16.840.1.113883.6.238"
										codeSystemName="Race &amp; Ethnicity - CDC"/>
										<!-- SHALL 1..1 Aggregate Count template -->
										<entryRelationship typeCode="SUBJ" inversionInd="true">
										<observation classCode="OBS" moodCode="EVN">
										<!-- Aggregate Count template -->
										<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
										<code code="MSRAGG" displayName="rate aggregation"
										codeSystem="2.16.840.1.113883.5.4"
										codeSystemName="ActCode"/>
										<!--  SHALL value xsi:type="INT"-->
										<value xsi:type="INT" value="13"/>
										<methodCode code="COUNT" displayName="Count"
										codeSystem="2.16.840.1.113883.5.84"
										codeSystemName="ObservationMethod"/>
										</observation>
										</entryRelationship>
										</observation>
										</entryRelationship>
										<entryRelationship typeCode="COMP">
										<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
										<observation classCode="OBS" moodCode="EVN">
										<!-- Race Supplemental Data Element template ID -->
										<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
										<code code="103579009" displayName="Race"
										codeSystem="2.16.840.1.113883.6.96"
										codeSystemName="SNOMED CT"/>
										<statusCode code="completed"/>
										<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
										<value xsi:type="CD" code="1002-5"
										displayName="American Indian or Alaska Native"
										codeSystem="2.16.840.1.113883.6.238"
										codeSystemName="Race &amp; Ethnicity - CDC"/>
										<entryRelationship typeCode="SUBJ" inversionInd="true">
										<observation classCode="OBS" moodCode="EVN">
										<!-- SHALL 1..1 Aggregate Count template -->
										<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
										<code code="MSRAGG" displayName="rate aggregation"
										codeSystem="2.16.840.1.113883.5.4"
										codeSystemName="ActCode"/>
										<!--  SHALL value xsi:type="INT"-->
										<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['excep_race'].'"/>
												<methodCode code="COUNT" displayName="Count"
												codeSystem="2.16.840.1.113883.5.84"
												codeSystemName="ObservationMethod"/>
												</observation>
												</entryRelationship>
												</observation>
												</entryRelationship>
												<entryRelationship typeCode="COMP">
												<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
												<observation classCode="OBS" moodCode="EVN">
												<!-- Race Supplemental Data Element template ID -->
												<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
												<code code="103579009" displayName="Race"
												codeSystem="2.16.840.1.113883.6.96"
												codeSystemName="SNOMED CT"/>
												<statusCode code="completed"/>
												<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
												<value xsi:type="CD" code="2131-1" displayName="White"
												codeSystem="2.16.840.1.113883.6.238"
												codeSystemName="Race &amp; Ethnicity - CDC"/>
												<entryRelationship typeCode="SUBJ" inversionInd="true">
												<observation classCode="OBS" moodCode="EVN">
												<!-- SHALL 1..1 Aggregate Count template -->
												<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
												<code code="MSRAGG" displayName="rate aggregation"
												codeSystem="2.16.840.1.113883.5.4"
												codeSystemName="ActCode"/>
												<!--  SHALL value xsi:type="INT"-->
												<value xsi:type="INT" value="7"/>
												<methodCode code="COUNT" displayName="Count"
												codeSystem="2.16.840.1.113883.5.84"
												codeSystemName="ObservationMethod"/>
												</observation>
												</entryRelationship>
												</observation>
												</entryRelationship>
												<entryRelationship typeCode="COMP">
												<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
												<observation classCode="OBS" moodCode="EVN">
												<!-- Race Supplemental Data Element template ID -->
												<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
												<code code="103579009" displayName="Race"
												codeSystem="2.16.840.1.113883.6.96"
												codeSystemName="SNOMED CT"/>
												<statusCode code="completed"/>
												<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
												<value xsi:type="CD" code="2028-9" displayName="Asian"
												codeSystem="2.16.840.1.113883.6.238"
												codeSystemName="Race &amp; Ethnicity - CDC"/>
												<entryRelationship typeCode="SUBJ" inversionInd="true">
												<observation classCode="OBS" moodCode="EVN">
												<!-- SHALL 1..1 Aggregate Count template -->
												<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
												<code code="MSRAGG" displayName="rate aggregation"
												codeSystem="2.16.840.1.113883.5.4"
												codeSystemName="ActCode"/>
												<!--  SHALL value xsi:type="INT"-->
												<value xsi:type="INT" value="7"/>
												<methodCode code="COUNT" displayName="Count"
												codeSystem="2.16.840.1.113883.5.84"
												codeSystemName="ObservationMethod"/>
												</observation>
												</entryRelationship>
												</observation>
												</entryRelationship>
												<entryRelationship typeCode="COMP">
												<!-- Sex Supplemental Data Element (2.16.840.1.113883.10.20.27.3.6) -->
												<observation classCode="OBS" moodCode="EVN">
												<!-- Sex Supplemental Data Element template ID -->
												<templateId root="2.16.840.1.113883.10.20.27.3.6"/>
												<!-- SHALL be single value binding to: -->
												<code code="184100006" displayName="patient sex"
												codeSystem="2.16.840.1.113883.6.96"
												codeSystemName="SNOMED-CT"/>
												<statusCode code="completed"/>
												<!-- SHALL be drawn from  Value Set: Administrative Gender (HL7 V3) 2.16.840.1.113883.1.11.1 DYNAMIC-->
												<!-- Example female -->
												<value xsi:type="CD" code="F"
												codeSystem="2.16.840.1.113883.5.1"
												codeSystemName="HL7AdministrativeGenderCode"/>
												<entryRelationship typeCode="SUBJ" inversionInd="true">
												<observation classCode="OBS" moodCode="EVN">
												<!-- SHALL 1..1 Aggregate Count template -->
												<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
												<code code="MSRAGG" displayName="rate aggregation"
												codeSystem="2.16.840.1.113883.5.4"
												codeSystemName="ActCode"/>
												<!--  SHALL value xsi:type="INT"-->
												<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['excep_female'].'"/>
														<methodCode code="COUNT" displayName="Count"
														codeSystem="2.16.840.1.113883.5.84"
														codeSystemName="ObservationMethod"/>
														</observation>
														</entryRelationship>
														</observation>
														</entryRelationship>
														<entryRelationship typeCode="COMP">
														<!-- Sex Supplemental Data Element (2.16.840.1.113883.10.20.27.3.6) -->
														<observation classCode="OBS" moodCode="EVN">
														<!-- Sex Supplemental Data Element template ID -->
														<templateId root="2.16.840.1.113883.10.20.27.3.6"/>
														<!-- SHALL be single value binding to: -->
														<code code="184100006" displayName="patient sex"
														codeSystem="2.16.840.1.113883.6.96"
														codeSystemName="SNOMED-CT"/>
														<statusCode code="completed"/>
														<!-- SHALL be drawn from  Value Set: Administrative Gender (HL7 V3) 2.16.840.1.113883.1.11.1 DYNAMIC-->
														<value xsi:type="CD" code="M"
														codeSystem="2.16.840.1.113883.5.1"
														codeSystemName="HL7AdministrativeGenderCode"/>
														<entryRelationship typeCode="SUBJ" inversionInd="true">
														<observation classCode="OBS" moodCode="EVN">
														<!-- SHALL 1..1 Aggregate Count template -->
														<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
														<code code="MSRAGG" displayName="rate aggregation"
														codeSystem="2.16.840.1.113883.5.4"
														codeSystemName="ActCode"/>
														<!--  SHALL value xsi:type="INT"-->
														<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['excep_male'].'"/>
																<methodCode code="COUNT" displayName="Count"
																codeSystem="2.16.840.1.113883.5.84"
																codeSystemName="ObservationMethod"/>
																</observation>
																</entryRelationship>
																</observation>
																</entryRelationship>
																<entryRelationship typeCode="COMP">
																<!-- Payer Supplemental Data Element (2.16.840.1.113883.10.20.27.3.9) -->
																<observation classCode="OBS" moodCode="EVN">
																<!-- Conforms to Patient Characteristic Payer -->
																<templateId root="2.16.840.1.113883.10.20.24.3.55"/>
																<!-- Payer Supplemental Data Element template ID -->
																<templateId root="2.16.840.1.113883.10.20.27.3.9"/>
																<!-- implied template requires ID -->
																<id nullFlavor="NA"/>
																<!-- SHALL be single value binding to: -->
																<code code="48768-6" displayName="Payment source"
																codeSystem="2.16.840.1.113883.6.1"
																codeSystemName="SNOMED-CT"/>
																<statusCode code="completed"/>
																<!-- SHALL be drawn from  Value Set: PHDSC Source of Payment Typology 2.16.840.1.114222.4.11.3591 DYNAMIC-->
																<value xsi:type="CD" code="349"
																codeSystem="2.16.840.1.113883.3.221.5"
																codeSystemName="Source of Payment Typology"
																displayName="Medicare"/>
																<entryRelationship typeCode="SUBJ" inversionInd="true">
																<observation classCode="OBS" moodCode="EVN">
																<!-- SHALL 1..1 Aggregate Count template -->
																<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
																<code code="MSRAGG" displayName="rate aggregation"
																codeSystem="2.16.840.1.113883.5.4"
																codeSystemName="ActCode"/>
																<!--  SHALL value xsi:type="INT"-->
																<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['den_exception'].'"/>
																		<methodCode code="COUNT" displayName="Count"
																		codeSystem="2.16.840.1.113883.5.84"
																		codeSystemName="ObservationMethod"/>
																		</observation>
																		</entryRelationship>
																		</observation>
																		</entryRelationship>
																		<entryRelationship typeCode="COMP">
																		<!-- Payer Supplemental Data Element (2.16.840.1.113883.10.20.27.3.9) -->
																		<observation classCode="OBS" moodCode="EVN">
																		<!-- Conforms to Patient Characteristic Payer -->
																		<templateId root="2.16.840.1.113883.10.20.24.3.55"/>
																		<!-- Payer Supplemental Data Element template ID -->
																		<templateId root="2.16.840.1.113883.10.20.27.3.9"/>
																		<!-- implied template requires ID -->
																		<id nullFlavor="NA"/>
																		<!-- SHALL be single value binding to: -->
																		<code code="48768-6" displayName="Payment source"
																		codeSystem="2.16.840.1.113883.6.1"
																		codeSystemName="SNOMED-CT"/>
																		<statusCode code="completed"/>
																		<!-- SHALL be drawn from  Value Set: PHDSC Source of Payment Typology 2.16.840.1.114222.4.11.3591 DYNAMIC-->
																		<value xsi:type="CD" code="349"
																		codeSystem="2.16.840.1.113883.3.221.5"
																		codeSystemName="Source of Payment Typology"
																		displayName="Medicaid"/>
																		<entryRelationship typeCode="SUBJ" inversionInd="true">
																		<observation classCode="OBS" moodCode="EVN">
																		<!-- SHALL 1..1 Aggregate Count template -->
																		<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
																		<code code="MSRAGG" displayName="rate aggregation"
																		codeSystem="2.16.840.1.113883.5.4"
																		codeSystemName="ActCode"/>
																		<!--  SHALL value xsi:type="INT"-->
																		<value xsi:type="INT" value="'.$recive_enrtries['CqmReport']['den_exception'].'"/>
																				<methodCode code="COUNT" displayName="Count"
																				codeSystem="2.16.840.1.113883.5.84"
																				codeSystemName="ObservationMethod"/>
																				</observation>
																				</entryRelationship>
																				</observation>
																				</entryRelationship>

																				<reference typeCode="REFR">
																				<externalObservation classCode="OBS" moodCode="EVN">
																				<id root="'.$moredata[0]['CqmList']['denexcep_rootid'].'"/>
																						</externalObservation>
																						</reference>
																						</observation>
																						</component>';
			}
				
			$highBp_measure.='</organizer>
					</entry>';
		}
		return $highBp_measure;
	}
	//==========================================================For EH=======================================================================================================================
	public function consolidated_EH_Measure($ehdata=null){
		//$this->uses=array('CqmReport');
		$CqmReportEh = ClassRegistry::init('CqmReportEh');
		$CqmList = ClassRegistry::init('CqmList');
		$eh_measure="";
		$cnt=0;
		//debug($ehdata);
		
		foreach($ehdata as $ehdatas){
			$cnt++;
			

			$moredata=$CqmList->find('all',array('conditions'=>array('nqf_number'=>$ehdatas['CqmReportEh']['measure_id'])));
			//debug($moredata);
			//exit;
			//debug($moredata[0]['CqmList']['nqf_number']);

			$eh_measure.='<entry>
					<organizer classCode="CLUSTER" moodCode="EVN">
					<!-- Implied template Measure Reference templateId -->
					<templateId root="2.16.840.1.113883.10.20.24.3.98"/>
					<!-- SHALL 1..* (one for each referenced measure) Measure Reference and Results template -->
					<templateId root="2.16.840.1.113883.10.20.27.3.1"/>
					<statusCode code="completed"/>
					<reference typeCode="REFR">
					<externalDocument classCode="DOC" moodCode="EVN">

					<id root="'.$moredata[0]['CqmList']['measure_rootid'].'"/>

							<id root="2.16.840.1.113883.3.560.1" extension="'.$moredata[0]['CqmList']['nqf_number'].'"/>

									<id root="2.16.840.1.113883.3.560.101.2" extension="'.$moredata[0]['CqmList']['emeasure_identifier'].'"/>
											<code code="57024-2" codeSystem="2.16.840.1.113883.6.1"
											codeSystemName="LOINC"
											displayName="Health Quality Measure
											Document"/>

											<text>'.$moredata[0]['CqmList']['title'].'</text>

													<setId root="'.$moredata[0]['CqmList']['guid'].'"/>

															<versionNumber value="'.$moredata[0]['CqmList']['emeasure_version_no'].'"/>
																	</externalDocument>
																	</reference>
																	<!-- SHOULD Reference the measure set it is a member of-->
																	<reference typeCode="REFR">
																	<externalObservation>
																	<!-- SHALL contain id -->
																	<id root="b6ac13e2-beb8-4e4f-94ed-fcc397406cd8"/>
																	<!-- SHALL single value binding -->
																	<code code="55185-3" displayName="measure set"
																	codeSystem="2.16.840.1.113883.6.1" codeSystemName="LOINC"/>
																	<!-- SHALL text which should be the title of the measures set -->
																	<text>Clinical Quality Measure Set 2011-2012</text>
																	</externalObservation>
																	</reference>
																	<!-- Optional performance rate template -->
																	<component>
																	<observation classCode="OBS" moodCode="EVN">
																	<!-- MAY 0..1 Performance Rate for Proportion Measure template -->
																	<templateId root="2.16.840.1.113883.10.20.27.3.14"/>
																	<code code="72510-1" codeSystem="2.16.840.1.113883.6.1"
																	displayName="Performance Rate"
																	codeSystemName="2.16.840.1.113883.6.1"/>
																	<statusCode code="completed"/>
																	<value xsi:type="REAL" value="0.833"/>
																	<!-- MAY 0..1  (Note: this is the reference to the specific Numerator included in the calculation) -->
																	<reference typeCode="REFR">
																	<externalObservation classCode="OBS" moodCode="EVN">
																	<!--
																	The externalObservationID contains the ID of the numerator in the referenced eMeasure.
																	-->
																	<id root="6B818F6C-ED51-41B6-BE3B-FFBAD0BC1E34"/>
																	<code code="NUMER" displayName="Numerator"
																	codeSystem="2.16.840.1.113883.5.1063"
																	codeSystemName="ObservationValue"/>
																	</externalObservation>
																	</reference>
																	<!-- MAY 0..1 Used to represent the predicted rate based on the measures risk-adjustment model. -->
																	<referenceRange>
																	<observationRange>
																	<value xsi:type="REAL" value="0.625"/>
																	</observationRange>
																	</referenceRange>
																	</observation>
																	</component>
																	<!-- Optional reporting rate template -->
																	<component>
																	<observation classCode="OBS" moodCode="EVN">
																	<!-- MAY 0..1 Reporting Rate for Proportion Measure template -->
																	<templateId root="2.16.840.1.113883.10.20.27.3.15"/>
																	<code code="72509-3" codeSystem="2.16.840.1.113883.6.1"
																	displayName="Reporting Rate"
																	codeSystemName="2.16.840.1.113883.6.1"/>
																	<statusCode code="completed"/>
																	<value xsi:type="REAL" value="0.84"/>
																	</observation>
																	</component>';
			/*<!-- SHALL 1..* (one for each population) Measure Data template -->
			 <!-- NOTE AT THE BOTTOM OF THIS ORGANIZER is the reference for the entire population that starts with the first component
			observation at the top within the measure data template.  There are other external references contained within the
			entryRelationships below.  -->
			<!-- This is the population as in IPP, numerator, denominator, etc. If there are multiple
			populations, use the same method, but refer to IPP1, numerator1, IPP2, numerator2, etc -->*/

			//IPP COMPONENT
			$eh_measure.='<component>
					<observation classCode="OBS" moodCode="EVN">
					<!-- Measure Data template -->
					<templateId root="2.16.840.1.113883.10.20.27.3.5"/>
					<code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4"
					displayName="Assertion" codeSystemName="ActCode"/>
					<statusCode code="completed"/>
					<!-- SHALL value with SHOULD be from valueSetName="ObservationPopulationInclusion"
					valueSetOid="2.16.840.1.113883.1.11.20369"	Binding: Dynamic
					-->
					<value xsi:type="CD" code="IPP"
					codeSystem="2.16.840.1.113883.5.1063"
					displayName="initial patient population"
					codeSystemName="ObservationValue"/>
					<!-- SHALL contain aggregate count template -->
					<entryRelationship typeCode="SUBJ" inversionInd="true">
					<!-- Aggregate Count (2.16.840.1.113883.10.20.27.3.3) -->
					<observation classCode="OBS" moodCode="EVN">
					<!-- Aggregate Count template -->
					<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
					<!-- SHALL single value binding -->
					<code code="MSRAGG" displayName="rate aggregation"
					codeSystem="2.16.840.1.113883.5.4"
					codeSystemName="ActCode"/>
					<!--  SHALL value xsi:type="INT"-->
					<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['ipp_count'].'"/>
							<methodCode code="COUNT" displayName="Count"
							codeSystem="2.16.840.1.113883.5.84"
							codeSystemName="ObservationMethod"/>
							</observation>
							</entryRelationship>
							<entryRelationship typeCode="COMP">
							<!-- Postal Code Supplemental Data Element (2.16.840.1.113883.10.20.27.3.10)-->
							<!-- Repeat for each postal code that has any data -->
							<observation classCode="OBS" moodCode="EVN">
							<!-- Postal Code Supplemental Data Element template ID -->
							<templateId root="2.16.840.1.113883.10.20.27.3.10"/>
							<!-- SHALL single value binding -->
							<code code="184102003" displayName="patient postal code"
							codeSystem="2.16.840.1.113883.6.96"
							codeSystemName="SNOMED-CT"/>
							<statusCode code="completed"/>
							<!-- SHALL be xsi:type="ST"-->
							<value xsi:type="ST">92543</value>

							<entryRelationship typeCode="SUBJ" inversionInd="true">
							<observation classCode="OBS" moodCode="EVN">
							<!-- Aggregate Count template -->
							<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
							<code code="MSRAGG" displayName="rate aggregation"
							codeSystem="2.16.840.1.113883.5.4"
							codeSystemName="ActCode"/>
							<!--  SHALL value xsi:type="INT"-->
							<value xsi:type="INT" value="15"/>
							<methodCode code="COUNT" displayName="Count"
							codeSystem="2.16.840.1.113883.5.84"
							codeSystemName="ObservationMethod"/>
							</observation>
							</entryRelationship>
							</observation>
							</entryRelationship>
							<entryRelationship typeCode="COMP">
							<!-- Ethnicity Supplemental Data Element (2.16.840.1.113883.10.20.27.3.7) -->
							<observation classCode="OBS" moodCode="EVN">
							<!-- Ethnicity Supplemental Data Element template ID -->
							<templateId root="2.16.840.1.113883.10.20.27.3.7"/>
							<!-- SHALL single value binding -->
							<code code="364699009" displayName="Ethnic Group"
							codeSystem="2.16.840.1.113883.6.96"
							codeSystemName="SNOMED CT"/>
							<statusCode code="completed"/>
							<!-- SHALL be bound to CDC Ethnicity group Value Set OID 2.16.840.1.114222.4.11.837 - dynamic -->
							<!-- Not hispanic -->
							<value xsi:type="CD" code="2186-5"
							displayName="Not Hispanic or Latino"
							codeSystem="2.16.840.1.113883.6.238"
							codeSystemName="Race &amp; Ethnicity - CDC"/>
							<!-- SHALL 1..1 Aggregate Count template -->
							<entryRelationship typeCode="SUBJ" inversionInd="true">
							<observation classCode="OBS" moodCode="EVN">
							<!-- Aggregate Count template -->
							<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
							<code code="MSRAGG" displayName="rate aggregation"
							codeSystem="2.16.840.1.113883.5.4"
							codeSystemName="ActCode"/>
							<!--  SHALL value xsi:type="INT"-->
							<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['ipp_eth'].'"/>
									<methodCode code="COUNT" displayName="Count"
									codeSystem="2.16.840.1.113883.5.84"
									codeSystemName="ObservationMethod"/>
									</observation>
									</entryRelationship>
									</observation>
									</entryRelationship>
									<entryRelationship typeCode="COMP">
									<!-- Ethnicity Supplemental Data Element (2.16.840.1.113883.10.20.27.3.7) -->
									<observation classCode="OBS" moodCode="EVN">
									<!-- Ethnicity Supplemental Data Element template ID -->
									<templateId root="2.16.840.1.113883.10.20.27.3.7"/>
									<code code="364699009" displayName="Ethnic Group"
									codeSystem="2.16.840.1.113883.6.96"
									codeSystemName="SNOMED CT"/>
									<statusCode code="completed"/>
									<!-- SHALL be bound to CDC Ethnicity group Value Set OID 2.16.840.1.114222.4.11.837 - dynamic -->
									<!-- Hispanic -->
									<value xsi:type="CD" code="2135-2"
									displayName="Hispanic or Latino"
									codeSystem="2.16.840.1.113883.6.238"
									codeSystemName="Race &amp; Ethnicity - CDC"/>
									<!-- SHALL 1..1 Aggregate Count template -->
									<entryRelationship typeCode="SUBJ" inversionInd="true">
									<observation classCode="OBS" moodCode="EVN">
									<!-- Aggregate Count template -->
									<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
									<code code="MSRAGG" displayName="rate aggregation"
									codeSystem="2.16.840.1.113883.5.4"
									codeSystemName="ActCode"/>
									<!--  SHALL value xsi:type="INT"-->
									<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['ipp_eth'].'"/>
											<methodCode code="COUNT" displayName="Count"
											codeSystem="2.16.840.1.113883.5.84"
											codeSystemName="ObservationMethod"/>
											</observation>
											</entryRelationship>
											</observation>
											</entryRelationship>
											<entryRelationship typeCode="COMP">
											<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
											<observation classCode="OBS" moodCode="EVN">
											<!-- Race Supplemental Data Element template ID -->
											<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
											<code code="103579009" displayName="Race"
											codeSystem="2.16.840.1.113883.6.96"
											codeSystemName="SNOMED-CT"/>
											<statusCode code="completed"/>
											<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
											<value xsi:type="CD" code="1002-5"
											displayName="American Indian or Alaska Native"
											codeSystem="2.16.840.1.113883.6.238"
											codeSystemName="Race &amp; Ethnicity - CDC"/>
											<entryRelationship typeCode="SUBJ" inversionInd="true">
											<observation classCode="OBS" moodCode="EVN">
											<!-- SHALL 1..1 Aggregate Count template -->
											<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
											<code code="MSRAGG" displayName="rate aggregation"
											codeSystem="2.16.840.1.113883.5.4"
											codeSystemName="ActCode"/>
											<!--  SHALL value xsi:type="INT" to be changed-->
											<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['ipp_race'].'"/>
													<methodCode code="COUNT" displayName="Count"
													codeSystem="2.16.840.1.113883.5.84"
													codeSystemName="ObservationMethod"/>
													</observation>
													</entryRelationship>
													</observation>
													</entryRelationship>
													<entryRelationship typeCode="COMP">
													<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
													<observation classCode="OBS" moodCode="EVN">
													<!-- Race Supplemental Data Element template ID -->
													<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
													<code code="103579009" displayName="Race"
													codeSystem="2.16.840.1.113883.6.96"
													codeSystemName="SNOMED CT"/>
													<statusCode code="completed"/>
													<value xsi:type="CD" code="2131-1" displayName="White"
													codeSystem="2.16.840.1.113883.6.238"
													codeSystemName="Race &amp; Ethnicity - CDC"/>
													<entryRelationship typeCode="SUBJ" inversionInd="true">
													<observation classCode="OBS" moodCode="EVN">
													<!-- SHALL 1..1 Aggregate Count template -->
													<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
													<code code="MSRAGG" displayName="rate aggregation"
													codeSystem="2.16.840.1.113883.5.4"
													codeSystemName="ActCode"/>
													<!--  SHALL value xsi:type="INT"-->
													<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['ipp_race'].'"/>
															<methodCode code="COUNT" displayName="Count"
															codeSystem="2.16.840.1.113883.5.84"
															codeSystemName="ObservationMethod"/>
															</observation>
															</entryRelationship>
															</observation>
															</entryRelationship>
															<entryRelationship typeCode="COMP">
															<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
															<observation classCode="OBS" moodCode="EVN">
															<!-- Race Supplemental Data Element template ID -->
															<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
															<code code="103579009" displayName="Race"
															codeSystem="2.16.840.1.113883.6.96"
															codeSystemName="SNOMED CT"/>
															<statusCode code="completed"/>
															<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
															<value xsi:type="CD" code="2028-9" displayName="Asian"
															codeSystem="2.16.840.1.113883.6.238"
															codeSystemName="Race &amp; Ethnicity - CDC"/>
															<entryRelationship typeCode="SUBJ" inversionInd="true">
															<observation classCode="OBS" moodCode="EVN">
															<!-- SHALL 1..1 Aggregate Count template -->
															<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
															<code code="MSRAGG" displayName="rate aggregation"
															codeSystem="2.16.840.1.113883.5.4"
															codeSystemName="ActCode"/>
															<!--  SHALL value xsi:type="INT"-->
															<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['ipp_race'].'"/>
																	<methodCode code="COUNT" displayName="Count"
																	codeSystem="2.16.840.1.113883.5.84"
																	codeSystemName="ObservationMethod"/>
																	</observation>
																	</entryRelationship>
																	</observation>
																	</entryRelationship>
																	<entryRelationship typeCode="COMP">
																	<!-- Sex Supplemental Data Element (2.16.840.1.113883.10.20.27.3.6) -->
																	<observation classCode="OBS" moodCode="EVN">
																	<!-- Sex Supplemental Data Element template ID -->
																	<templateId root="2.16.840.1.113883.10.20.27.3.6"/>
																	<!-- SHALL be single value binding to: -->
																	<code code="184100006" displayName="patient sex"
																	codeSystem="2.16.840.1.113883.6.96"
																	codeSystemName="SNOMED-CT"/>
																	<statusCode code="completed"/>
																	<!-- SHALL be drawn from  Value Set: Administrative Gender (HL7 V3) 2.16.840.1.113883.1.11.1 DYNAMIC-->
																	<!-- Female -->
																	<value xsi:type="CD" code="F"
																	codeSystem="2.16.840.1.113883.5.1"
																	codeSystemName="HL7AdministrativeGenderCode"/>
																	<entryRelationship typeCode="SUBJ" inversionInd="true">
																	<observation classCode="OBS" moodCode="EVN">
																	<!-- SHALL 1..1 Aggregate Count template -->
																	<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
																	<code code="MSRAGG" displayName="rate aggregation"
																	codeSystem="2.16.840.1.113883.5.4"
																	codeSystemName="ActCode"/>
																	<!--  SHALL value xsi:type="INT"-->
																	<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['ipp_female'].'"/>
																			<methodCode code="COUNT" displayName="Count"
																			codeSystem="2.16.840.1.113883.5.84"
																			codeSystemName="ObservationMethod"/>
																			</observation>
																			</entryRelationship>
																			</observation>
																			</entryRelationship>
																			<entryRelationship typeCode="COMP">
																			<!-- Sex Supplemental Data Element (2.16.840.1.113883.10.20.27.3.6) -->
																			<observation classCode="OBS" moodCode="EVN">
																			<!-- Sex Supplemental Data Element template ID -->
																			<templateId root="2.16.840.1.113883.10.20.27.3.6"/>
																			<!-- SHALL be single value binding to: -->
																			<code code="184100006" displayName="patient sex"
																			codeSystem="2.16.840.1.113883.6.96"
																			codeSystemName="SNOMED-CT"/>
																			<statusCode code="completed"/>
																			<!-- SHALL be drawn from  Value Set: Administrative Gender (HL7 V3) 2.16.840.1.113883.1.11.1 DYNAMIC-->
																			<!-- Male -->
																			<value xsi:type="CD" code="M"
																			codeSystem="2.16.840.1.113883.5.1"
																			codeSystemName="HL7AdministrativeGenderCode"/>
																			<entryRelationship typeCode="SUBJ" inversionInd="true">
																			<observation classCode="OBS" moodCode="EVN">
																			<!-- SHALL 1..1 Aggregate Count template -->
																			<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
																			<code code="MSRAGG" displayName="rate aggregation"
																			codeSystem="2.16.840.1.113883.5.4"
																			codeSystemName="ActCode"/>
																			<!--  SHALL value xsi:type="INT" to be changed-->
																			<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['ipp_male'].'"/>
																					<methodCode code="COUNT" displayName="Count"
																					codeSystem="2.16.840.1.113883.5.84"
																					codeSystemName="ObservationMethod"/>
																					</observation>
																					</entryRelationship>
																					</observation>
																					</entryRelationship>
																					<entryRelationship typeCode="COMP">
																					<!-- Payer Supplemental Data Element (2.16.840.1.113883.10.20.27.3.9) -->
																					<observation classCode="OBS" moodCode="EVN">
																					<!-- Conforms to Patient Characteristic Payer -->
																					<templateId root="2.16.840.1.113883.10.20.24.3.55"/>
																					<!-- Payer Supplemental Data Element template ID -->
																					<templateId root="2.16.840.1.113883.10.20.27.3.9"/>
																					<!-- implied template requires ID -->
																					<id nullFlavor="NA"/>
																					<!-- SHALL be single value binding to: -->
																					<code code="48768-6" displayName="Payment source"
																					codeSystem="2.16.840.1.113883.6.1"
																					codeSystemName="SNOMED-CT"/>
																					<statusCode code="completed"/>
																					<!-- SHALL be drawn from  Value Set: PHDSC Source of Payment Typology 2.16.840.1.114222.4.11.3591 DYNAMIC-->
																					<value xsi:type="CD" code="349"
																					codeSystem="2.16.840.1.113883.3.221.5"
																					codeSystemName="Source of Payment Typology"
																					displayName="Medicare"/>
																					<entryRelationship typeCode="SUBJ" inversionInd="true">
																					<observation classCode="OBS" moodCode="EVN">
																					<!-- SHALL 1..1 Aggregate Count template -->
																					<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
																					<code code="MSRAGG" displayName="rate aggregation"
																					codeSystem="2.16.840.1.113883.5.4"
																					codeSystemName="ActCode"/>
																					<!--  SHALL value xsi:type="INT"-->
																					<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['ipp_count'].'"/>
																							<methodCode code="COUNT" displayName="Count"
																							codeSystem="2.16.840.1.113883.5.84"
																							codeSystemName="ObservationMethod"/>
																							</observation>
																							</entryRelationship>
																							</observation>
																							</entryRelationship>
																							<entryRelationship typeCode="COMP">
																							<!-- Payer Supplemental Data Element (2.16.840.1.113883.10.20.27.3.9) -->
																							<observation classCode="OBS" moodCode="EVN">
																							<!-- Conforms to Patient Characteristic Payer -->
																							<templateId root="2.16.840.1.113883.10.20.24.3.55"/>
																							<!-- Payer Supplemental Data Element template ID -->
																							<templateId root="2.16.840.1.113883.10.20.27.3.9"/>
																							<!-- implied template requires ID -->
																							<id nullFlavor="NA"/>
																							<!-- SHALL be single value binding to: -->
																							<code code="48768-6" displayName="Payment source"
																							codeSystem="2.16.840.1.113883.6.1"
																							codeSystemName="SNOMED-CT"/>
																							<statusCode code="completed"/>
																							<!-- SHALL be drawn from  Value Set: PHDSC Source of Payment Typology 2.16.840.1.114222.4.11.3591 DYNAMIC-->
																							<value xsi:type="CD" code="349"
																							codeSystem="2.16.840.1.113883.3.221.5"
																							codeSystemName="Source of Payment Typology"
																							displayName="Medicaid"/>
																							<entryRelationship typeCode="SUBJ" inversionInd="true">
																							<observation classCode="OBS" moodCode="EVN">
																							<!-- SHALL 1..1 Aggregate Count template -->
																							<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
																							<code code="MSRAGG" displayName="rate aggregation"
																							codeSystem="2.16.840.1.113883.5.4"
																							codeSystemName="ActCode"/>
																							<!--  SHALL value xsi:type="INT" to be changed-->
																							<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['ipp_count'].'"/>
																									<methodCode code="COUNT" displayName="Count"
																									codeSystem="2.16.840.1.113883.5.84"
																									codeSystemName="ObservationMethod"/>
																									</observation>
																									</entryRelationship>
																									</observation>
																									</entryRelationship>
																									<!-- SHALL 1..1  (Note: this is the reference for the entire population starting with the first component
																									observation at the top within the measure data template-->
																									<reference typeCode="REFR">
																									<!-- reference to the relevant population in the eMeasure -->
																									<externalObservation classCode="OBS" moodCode="EVN">
																									<id root="'.$moredata[0]['CqmList']['ipp_rootid'].'"/>
																											</externalObservation>
																											</reference>
																											</observation>
																											</component>
																											';

			//end of IPP COMPONENT

			//Start of DENOM Component
			$eh_measure.='<component>
					<observation classCode="OBS" moodCode="EVN">
					<!-- Measure Data template -->
					<templateId root="2.16.840.1.113883.10.20.27.3.5"/>
					<code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4"
					displayName="Assertion" codeSystemName="ActCode"/>
					<statusCode code="completed"/>
					<!-- SHALL value with SHOULD be from valueSetName="ObservationPopulationInclusion "	valueSetOid="2.16.840.1.113883.1.11.20369"	Binding: Dynamic
					-->
					<value xsi:type="CD" code="DENOM"
					codeSystem="2.16.840.1.113883.5.1063"
					displayName="Denominator" codeSystemName="ObservationValue"/>
					<!-- SHALL contain aggregate count template -->
					<entryRelationship typeCode="SUBJ" inversionInd="true">
					<!-- Aggregate Count (2.16.840.1.113883.10.20.27.3.3) -->
					<observation classCode="OBS" moodCode="EVN">
					<!-- Aggregate Count template -->
					<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
					<!-- SHALL single value binding -->
					<code code="MSRAGG" displayName="rate aggregation"
					codeSystem="2.16.840.1.113883.5.4"
					codeSystemName="ActCode"/>
					<!--  SHALL value xsi:type="INT"-->
					<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['denominator_count'].'"/>
							<methodCode code="COUNT" displayName="Count"
							codeSystem="2.16.840.1.113883.5.84"
							codeSystemName="ObservationMethod"/>
							</observation>
							</entryRelationship>
							<entryRelationship typeCode="COMP">
							<!-- Postal Code Supplemental Data Element (2.16.840.1.113883.10.20.27.3.10)-->
							<observation classCode="OBS" moodCode="EVN">
							<!-- Postal Code Supplemental Data Element template ID -->
							<templateId root="2.16.840.1.113883.10.20.27.3.10"/>
							<!-- SHALL single value binding -->
							<code code="184102003" displayName="patient postal code"
							codeSystem="2.16.840.1.113883.6.96"
							codeSystemName="SNOMED-CT"/>
							<statusCode code="completed"/>
							<!-- SHALL be xsi:type="ST"-->
							<value xsi:type="ST">92543</value>
							<!-- SHALL 1..1 Aggregate Count template -->
							<entryRelationship typeCode="SUBJ" inversionInd="true">
							<observation classCode="OBS" moodCode="EVN">
							<!-- Aggregate Count template -->
							<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
							<code code="MSRAGG" displayName="rate aggregation"
							codeSystem="2.16.840.1.113883.5.4"
							codeSystemName="ActCode"/>
							<!--  SHALL value xsi:type="INT"-->
							<value xsi:type="INT" value="15"/>
							<methodCode code="COUNT" displayName="Count"
							codeSystem="2.16.840.1.113883.5.84"
							codeSystemName="ObservationMethod"/>
							</observation>
							</entryRelationship>
							</observation>
							</entryRelationship>
							<entryRelationship typeCode="COMP">
							<!-- Ethnicity Supplemental Data Element (2.16.840.1.113883.10.20.27.3.7) -->
							<observation classCode="OBS" moodCode="EVN">
							<!-- Ethnicity Supplemental Data Element template ID -->
							<templateId root="2.16.840.1.113883.10.20.27.3.7"/>
							<!-- SHALL single value binding -->
							<code code="364699009" displayName="Ethnic Group"
							codeSystem="2.16.840.1.113883.6.96"
							codeSystemName="SNOMED CT"/>
							<statusCode code="completed"/>
							<!-- SHALL be bound to CDC Ethnicity group Value Set OID 2.16.840.1.114222.4.11.837 - dynamic -->
							<!-- Not hispanic -->
							<value xsi:type="CD" code="2186-5"
							displayName="Not
							Hispanic or Latino"
							codeSystem="2.16.840.1.113883.6.238"
							codeSystemName="Race &amp; Ethnicity - CDC"/>
							<!-- SHALL 1..1 Aggregate Count template -->
							<entryRelationship typeCode="SUBJ" inversionInd="true">
							<observation classCode="OBS" moodCode="EVN">
							<!-- Aggregate Count template -->
							<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
							<code code="MSRAGG" displayName="rate aggregation"
							codeSystem="2.16.840.1.113883.5.4"
							codeSystemName="ActCode"/>
							<!--  SHALL value xsi:type="INT" need to change-->
							<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['denominator_eth'].'"/>
									<methodCode code="COUNT" displayName="Count"
									codeSystem="2.16.840.1.113883.5.84"
									codeSystemName="ObservationMethod"/>
									</observation>
									</entryRelationship>
									</observation>
									</entryRelationship>
									<entryRelationship typeCode="COMP">
									<!-- Ethnicity Supplemental Data Element (2.16.840.1.113883.10.20.27.3.7) -->
									<observation classCode="OBS" moodCode="EVN">
									<!-- Ethnicity Supplemental Data Element template ID -->
									<templateId root="2.16.840.1.113883.10.20.27.3.7"/>
									<code code="364699009" displayName="Ethnic Group"
									codeSystem="2.16.840.1.113883.6.96"
									codeSystemName="SNOMED CT"/>
									<statusCode code="completed"/>
									<!-- SHALL be bound to CDC Ethnicity group Value Set OID 2.16.840.1.114222.4.11.837 - dynamic -->
									<!-- Hispanic -->
									<value xsi:type="CD" code="2135-2"
									displayName="Hispanic or Latino"
									codeSystem="2.16.840.1.113883.6.238"
									codeSystemName="Race &amp; Ethnicity - CDC"/>
									<!-- SHALL 1..1 Aggregate Count template -->
									<entryRelationship typeCode="SUBJ" inversionInd="true">
									<observation classCode="OBS" moodCode="EVN">
									<!-- Aggregate Count template -->
									<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
									<code code="MSRAGG" displayName="rate aggregation"
									codeSystem="2.16.840.1.113883.5.4"
									codeSystemName="ActCode"/>
									<!--  SHALL value xsi:type="INT"-->
									<value xsi:type="INT" value="325"/>
									<methodCode code="COUNT" displayName="Count"
									codeSystem="2.16.840.1.113883.5.84"
									codeSystemName="ObservationMethod"/>
									</observation>
									</entryRelationship>
									</observation>
									</entryRelationship>
									<entryRelationship typeCode="COMP">
									<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
									<observation classCode="OBS" moodCode="EVN">
									<!-- Race Supplemental Data Element template ID -->
									<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
									<code code="103579009" displayName="Race"
									codeSystem="2.16.840.1.113883.6.96"
									codeSystemName="SNOMED CT"/>
									<statusCode code="completed"/>
									<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
									<value xsi:type="CD" code="1002-5"
									displayName="American Indian or Alaska Native"
									codeSystem="2.16.840.1.113883.6.238"
									codeSystemName="Race &amp; Ethnicity - CDC"/>
									<entryRelationship typeCode="SUBJ" inversionInd="true">
									<observation classCode="OBS" moodCode="EVN">
									<!-- SHALL 1..1 Aggregate Count template -->
									<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
									<code code="MSRAGG" displayName="rate aggregation"
									codeSystem="2.16.840.1.113883.5.4"
									codeSystemName="ActCode"/>
									<!--  SHALL value xsi:type="INT" to be changed-->
									<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['denominator_race'].'"/>
											<methodCode code="COUNT" displayName="Count"
											codeSystem="2.16.840.1.113883.5.84"
											codeSystemName="ObservationMethod"/>
											</observation>
											</entryRelationship>
											</observation>
											</entryRelationship>
											<entryRelationship typeCode="COMP">
											<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
											<observation classCode="OBS" moodCode="EVN">
											<!-- Race Supplemental Data Element template ID -->
											<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
											<code code="103579009" displayName="Race"
											codeSystem="2.16.840.1.113883.6.96"
											codeSystemName="SNOMED CT"/>
											<statusCode code="completed"/>
											<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
											<value xsi:type="CD" code="2131-1" displayName="White"
											codeSystem="2.16.840.1.113883.6.238"
											codeSystemName="Race &amp; Ethnicity - CDC"/>
											<entryRelationship typeCode="SUBJ" inversionInd="true">
											<observation classCode="OBS" moodCode="EVN">
											<!-- SHALL 1..1 Aggregate Count template -->
											<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
											<code code="MSRAGG" displayName="rate aggregation"
											codeSystem="2.16.840.1.113883.5.4"
											codeSystemName="ActCode"/>
											<!--  SHALL value xsi:type="INT"-->
											<value xsi:type="INT" value="175"/>
											<methodCode code="COUNT" displayName="Count"
											codeSystem="2.16.840.1.113883.5.84"
											codeSystemName="ObservationMethod"/>
											</observation>
											</entryRelationship>
											</observation>
											</entryRelationship>
											<entryRelationship typeCode="COMP">
											<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
											<observation classCode="OBS" moodCode="EVN">
											<!-- Race Supplemental Data Element template ID -->
											<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
											<code code="103579009" displayName="Race"
											codeSystem="2.16.840.1.113883.6.96"
											codeSystemName="SNOMED CT"/>
											<statusCode code="completed"/>
											<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
											<value xsi:type="CD" code="2028-9" displayName="Asian"
											codeSystem="2.16.840.1.113883.6.238"
											codeSystemName="Race &amp; Ethnicity - CDC"/>
											<entryRelationship typeCode="SUBJ" inversionInd="true">
											<observation classCode="OBS" moodCode="EVN">
											<!-- SHALL 1..1 Aggregate Count template -->
											<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
											<code code="MSRAGG" displayName="rate aggregation"
											codeSystem="2.16.840.1.113883.5.4"
											codeSystemName="ActCode"/>
											<!--  SHALL value xsi:type="INT"-->
											<value xsi:type="INT" value="175"/>
											<methodCode code="COUNT" displayName="Count"
											codeSystem="2.16.840.1.113883.5.84"
											codeSystemName="ObservationMethod"/>
											</observation>
											</entryRelationship>
											</observation>
											</entryRelationship>
											<entryRelationship typeCode="COMP">
											<!-- Sex Supplemental Data Element (2.16.840.1.113883.10.20.27.3.6) -->
											<observation classCode="OBS" moodCode="EVN">
											<!-- Sex Supplemental Data Element template ID -->
											<templateId root="2.16.840.1.113883.10.20.27.3.6"/>
											<!-- SHALL be single value binding to: -->
											<code code="184100006" displayName="patient sex"
											codeSystem="2.16.840.1.113883.6.96"
											codeSystemName="SNOMED-CT"/>
											<statusCode code="completed"/>
											<!-- SHALL be drawn from  Value Set: Administrative Gender (HL7 V3) 2.16.840.1.113883.1.11.1 DYNAMIC-->
											<!-- Example female -->
											<value xsi:type="CD" code="F"
											codeSystem="2.16.840.1.113883.5.1"
											codeSystemName="HL7AdministrativeGenderCode"/>
											<entryRelationship typeCode="SUBJ" inversionInd="true">
											<observation classCode="OBS" moodCode="EVN">
											<!-- SHALL 1..1 Aggregate Count template -->
											<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
											<code code="MSRAGG" displayName="rate aggregation"
											codeSystem="2.16.840.1.113883.5.4"
											codeSystemName="ActCode"/>
											<!--  SHALL value xsi:type="INT"-->
											<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['denominator_female'].'"/>
													<methodCode code="COUNT" displayName="Count"
													codeSystem="2.16.840.1.113883.5.84"
													codeSystemName="ObservationMethod"/>
													</observation>
													</entryRelationship>
													</observation>
													</entryRelationship>
													<entryRelationship typeCode="COMP">
													<!-- Sex Supplemental Data Element (2.16.840.1.113883.10.20.27.3.6) -->
													<observation classCode="OBS" moodCode="EVN">
													<!-- Sex Supplemental Data Element template ID -->
													<templateId root="2.16.840.1.113883.10.20.27.3.6"/>
													<!-- SHALL be single value binding to: -->
													<code code="184100006" displayName="patient sex"
													codeSystem="2.16.840.1.113883.6.96"
													codeSystemName="SNOMED-CT"/>
													<statusCode code="completed"/>
													<!-- SHALL be drawn from  Value Set: Administrative Gender (HL7 V3) 2.16.840.1.113883.1.11.1 DYNAMIC-->
													<value xsi:type="CD" code="M"
													codeSystem="2.16.840.1.113883.5.1"
													codeSystemName="HL7AdministrativeGenderCode"/>
													<entryRelationship typeCode="SUBJ" inversionInd="true">
													<observation classCode="OBS" moodCode="EVN">
													<!-- SHALL 1..1 Aggregate Count template -->
													<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
													<code code="MSRAGG" displayName="rate aggregation"
													codeSystem="2.16.840.1.113883.5.4"
													codeSystemName="ActCode"/>
													<!--  SHALL value xsi:type="INT" to be changed-->
													<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['denominator_male'].'"/>
															<methodCode code="COUNT" displayName="Count"
															codeSystem="2.16.840.1.113883.5.84"
															codeSystemName="ObservationMethod"/>
															</observation>
															</entryRelationship>
															</observation>
															</entryRelationship>
															<entryRelationship typeCode="COMP">
															<!-- Payer Supplemental Data Element (2.16.840.1.113883.10.20.27.3.9) -->
															<observation classCode="OBS" moodCode="EVN">
															<!-- Conforms to Patient Characteristic Payer -->
															<templateId root="2.16.840.1.113883.10.20.24.3.55"/>
															<!-- Payer Supplemental Data Element template ID -->
															<templateId root="2.16.840.1.113883.10.20.27.3.9"/>
															<!-- implied template requires ID -->
															<id nullFlavor="NA"/>
															<!-- SHALL be single value binding to: -->
															<code code="48768-6" displayName="Payment source"
															codeSystem="2.16.840.1.113883.6.1"
															codeSystemName="SNOMED-CT"/>
															<statusCode code="completed"/>
															<!-- SHALL be drawn from  Value Set: PHDSC Source of Payment Typology 2.16.840.1.114222.4.11.3591 DYNAMIC-->
															<value xsi:type="CD" code="349"
															codeSystem="2.16.840.1.113883.3.221.5"
															codeSystemName="Source of Payment Typology"
															displayName="Medicare"/>
															<entryRelationship typeCode="SUBJ" inversionInd="true">
															<observation classCode="OBS" moodCode="EVN">
															<!-- SHALL 1..1 Aggregate Count template -->
															<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
															<code code="MSRAGG" displayName="rate aggregation"
															codeSystem="2.16.840.1.113883.5.4"
															codeSystemName="ActCode"/>
															<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['denominator_count'].'"/>
																	<methodCode code="COUNT" displayName="Count"
																	codeSystem="2.16.840.1.113883.5.84"
																	codeSystemName="ObservationMethod"/>
																	</observation>
																	</entryRelationship>
																	</observation>
																	</entryRelationship>
																	<entryRelationship typeCode="COMP">
																	<!-- Payer Supplemental Data Element (2.16.840.1.113883.10.20.27.3.9) -->
																	<observation classCode="OBS" moodCode="EVN">
																	<!-- Conforms to Patient Characteristic Payer -->
																	<templateId root="2.16.840.1.113883.10.20.24.3.55"/>
																	<!-- Payer Supplemental Data Element template ID -->
																	<templateId root="2.16.840.1.113883.10.20.27.3.9"/>
																	<!-- implied template requires ID -->
																	<id nullFlavor="NA"/>
																	<!-- SHALL be single value binding to: -->
																	<code code="48768-6" displayName="Payment source"
																	codeSystem="2.16.840.1.113883.6.1"
																	codeSystemName="SNOMED-CT"/>
																	<statusCode code="completed"/>
																	<!-- SHALL be drawn from  Value Set: PHDSC Source of Payment Typology 2.16.840.1.114222.4.11.3591 DYNAMIC-->
																	<value xsi:type="CD" code="349"
																	codeSystem="2.16.840.1.113883.3.221.5"
																	codeSystemName="Source of Payment Typology"
																	displayName="Medicaid"/>
																	<entryRelationship typeCode="SUBJ" inversionInd="true">
																	<observation classCode="OBS" moodCode="EVN">
																	<!-- SHALL 1..1 Aggregate Count template -->
																	<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
																	<code code="MSRAGG" displayName="rate aggregation"
																	codeSystem="2.16.840.1.113883.5.4"
																	codeSystemName="ActCode"/>
																	<!--  SHALL value xsi:type="INT" to be changed-->
																	<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['denominator_count'].'"/>
																			<methodCode code="COUNT" displayName="Count"
																			codeSystem="2.16.840.1.113883.5.84"
																			codeSystemName="ObservationMethod"/>
																			</observation>
																			</entryRelationship>
																			</observation>
																			</entryRelationship>
																			<!-- SHALL 1..1  (Note: this is the reference for the entire population starting with the first component
																			observation at the top within the measure data template-->
																			<reference typeCode="REFR">
																			<!-- reference to the relevant population in the eMeasure -->
																			<externalObservation classCode="OBS" moodCode="EVN">
																			<id root="'.$moredata[0]['CqmList']['denominator_rootid'].'"/>
																					</externalObservation>
																					</reference>
																					</observation>
																					</component>';
			//End of DENOM component

			//Start of NUMER component
			$eh_measure.='<component>
					<observation classCode="OBS" moodCode="EVN">
					<!-- Measure Data template -->
					<templateId root="2.16.840.1.113883.10.20.27.3.5"/>
					<code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4"
					displayName="Assertion" codeSystemName="ActCode"/>
					<statusCode code="completed"/>
					<!-- SHALL value with SHOULD be from valueSetName="ObservationPopulationInclusion "	valueSetOid="2.16.840.1.113883.1.11.20369"	Binding: Dynamic
					-->
					<value xsi:type="CD" code="NUMER"
					codeSystem="2.16.840.1.113883.5.1063"
					displayName="Numerator" codeSystemName="ObservationValue"/>
					<!-- SHALL contain aggregate count template -->
					<entryRelationship typeCode="SUBJ" inversionInd="true">
					<!-- Aggregate Count (2.16.840.1.113883.10.20.27.3.3) -->
					<observation classCode="OBS" moodCode="EVN">
					<!-- Aggregate Count template -->
					<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
					<code code="MSRAGG" displayName="rate aggregation"
					codeSystem="2.16.840.1.113883.5.4"
					codeSystemName="ActCode"/>
					<!--  SHALL value xsi:type="INT"-->
					<value xsi:type="INT" value="1"/>
					<methodCode code="COUNT" displayName="Count"
					codeSystem="2.16.840.1.113883.5.84"
					codeSystemName="ObservationMethod"/>
					<!-- MAY 0..1 Used to represent the predicted count based on the measures risk-adjustment model. -->
					<referenceRange>
					<observationRange>
					<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['numerator_count'].'"/>
							</observationRange>
							</referenceRange>
							</observation>
							</entryRelationship>
							<entryRelationship typeCode="COMP">
							<!-- Postal Code Supplemental Data Element (2.16.840.1.113883.10.20.27.3.10)-->
							<observation classCode="OBS" moodCode="EVN">
							<!-- Postal Code Supplemental Data Element template ID -->
							<templateId root="2.16.840.1.113883.10.20.27.3.10"/>
							<!-- SHALL single value binding -->
							<code code="184102003" displayName="patient postal code"
							codeSystem="2.16.840.1.113883.6.96"
							codeSystemName="SNOMED-CT"/>
							<statusCode code="completed"/>
							<!-- SHALL be xsi:type="ST"-->
							<value xsi:type="ST">92543</value>
							<!-- SHALL 1..1 Aggregate Count template -->
							<entryRelationship typeCode="SUBJ" inversionInd="true">
							<observation classCode="OBS" moodCode="EVN">
							<!-- Aggregate Count template -->
							<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
							<code code="MSRAGG" displayName="rate aggregation"
							codeSystem="2.16.840.1.113883.5.4"
							codeSystemName="ActCode"/>
							<!--  SHALL value xsi:type="INT"-->
							<value xsi:type="INT" value="6"/>
							<methodCode code="COUNT" displayName="Count"
							codeSystem="2.16.840.1.113883.5.84"
							codeSystemName="ObservationMethod"/>
							</observation>
							</entryRelationship>
							</observation>
							</entryRelationship>
							<entryRelationship typeCode="COMP">
							<!-- Ethnicity Supplemental Data Element (2.16.840.1.113883.10.20.27.3.7) -->
							<observation classCode="OBS" moodCode="EVN">
							<!-- Ethnicity Supplemental Data Element template ID -->
							<templateId root="2.16.840.1.113883.10.20.27.3.7"/>
							<!-- SHALL single value binding -->
							<code code="364699009" displayName="Ethnic Group"
							codeSystem="2.16.840.1.113883.6.96"
							codeSystemName="SNOMED CT"/>
							<statusCode code="completed"/>
							<!-- SHALL be bound to CDC Ethnicity group Value Set OID 2.16.840.1.114222.4.11.837 - dynamic -->
							<!-- Not hispanic -->
							<value xsi:type="CD" code="2186-5"
							displayName="Not Hispanic or Latino"
							codeSystem="2.16.840.1.113883.6.238"
							codeSystemName="Race &amp; Ethnicity - CDC"/>
							<!-- SHALL 1..1 Aggregate Count template -->
							<entryRelationship typeCode="SUBJ" inversionInd="true">
							<observation classCode="OBS" moodCode="EVN">
							<!-- Aggregate Count template -->
							<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
							<code code="MSRAGG" displayName="rate aggregation"
							codeSystem="2.16.840.1.113883.5.4"
							codeSystemName="ActCode"/>
							<!--  SHALL value xsi:type="INT" need to change-->
							<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['numerator_eth'].'"/>
									<methodCode code="COUNT" displayName="Count"
									codeSystem="2.16.840.1.113883.5.84"
									codeSystemName="ObservationMethod"/>
									</observation>
									</entryRelationship>
									</observation>
									</entryRelationship>
									<entryRelationship typeCode="COMP">
									<!-- Ethnicity Supplemental Data Element (2.16.840.1.113883.10.20.27.3.7) -->
									<observation classCode="OBS" moodCode="EVN">
									<!-- Ethnicity Supplemental Data Element template ID -->
									<templateId root="2.16.840.1.113883.10.20.27.3.7"/>
									<code code="364699009" displayName="Ethnic Group"
									codeSystem="2.16.840.1.113883.6.96"
									codeSystemName="SNOMED CT"/>
									<statusCode code="completed"/>
									<!-- SHALL be bound to CDC Ethnicity group Value Set OID 2.16.840.1.114222.4.11.837 - dynamic -->
									<!-- Hispanic -->
									<value xsi:type="CD" code="2135-2"
									displayName="Hispanic or Latino"
									codeSystem="2.16.840.1.113883.6.238"
									codeSystemName="Race &amp; Ethnicity - CDC"/>
									<!-- SHALL 1..1 Aggregate Count template -->
									<entryRelationship typeCode="SUBJ" inversionInd="true">
									<observation classCode="OBS" moodCode="EVN">
									<!-- Aggregate Count template -->
									<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
									<code code="MSRAGG" displayName="rate aggregation"
									codeSystem="2.16.840.1.113883.5.4"
									codeSystemName="ActCode"/>
									<!--  SHALL value xsi:type="INT"-->
									<value xsi:type="INT" value="260"/>
									<methodCode code="COUNT" displayName="Count"
									codeSystem="2.16.840.1.113883.5.84"
									codeSystemName="ObservationMethod"/>
									</observation>
									</entryRelationship>
									</observation>
									</entryRelationship>
									<entryRelationship typeCode="COMP">
									<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
									<observation classCode="OBS" moodCode="EVN">
									<!-- Race Supplemental Data Element template ID -->
									<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
									<code code="103579009" displayName="Race"
									codeSystem="2.16.840.1.113883.6.96"
									codeSystemName="SNOMED CT"/>
									<statusCode code="completed"/>
									<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
									<value xsi:type="CD" code="1002-5"
									displayName="American Indian or Alaska Native"
									codeSystem="2.16.840.1.113883.6.238"
									codeSystemName="Race &amp; Ethnicity - CDC"/>
									<entryRelationship typeCode="SUBJ" inversionInd="true">
									<observation classCode="OBS" moodCode="EVN">
									<!-- SHALL 1..1 Aggregate Count template -->
									<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
									<code code="MSRAGG" displayName="rate aggregation"
									codeSystem="2.16.840.1.113883.5.4"
									codeSystemName="ActCode"/>
									<!--  SHALL value xsi:type="INT" to be changed  need to check why value needs to be changed here-->
									<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['numerator_race'].'"/>
											<methodCode code="COUNT" displayName="Count"
											codeSystem="2.16.840.1.113883.5.84"
											codeSystemName="ObservationMethod"/>
											</observation>
											</entryRelationship>
											</observation>
											</entryRelationship>
											<entryRelationship typeCode="COMP">
											<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
											<observation classCode="OBS" moodCode="EVN">
											<!-- Race Supplemental Data Element template ID -->
											<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
											<code code="103579009" displayName="Race"
											codeSystem="2.16.840.1.113883.6.96"
											codeSystemName="SNOMED CT"/>
											<statusCode code="completed"/>
											<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
											<value xsi:type="CD" code="2131-1" displayName="White"
											codeSystem="2.16.840.1.113883.6.238"
											codeSystemName="Race &amp; Ethnicity - CDC"/>
											<entryRelationship typeCode="SUBJ" inversionInd="true">
											<observation classCode="OBS" moodCode="EVN">
											<!-- SHALL 1..1 Aggregate Count template -->
											<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
											<code code="MSRAGG" displayName="rate aggregation"
											codeSystem="2.16.840.1.113883.5.4"
											codeSystemName="ActCode"/>
											<!--  SHALL value xsi:type="INT"-->
											<value xsi:type="INT" value="140"/>
											<methodCode code="COUNT" displayName="Count"
											codeSystem="2.16.840.1.113883.5.84"
											codeSystemName="ObservationMethod"/>
											</observation>
											</entryRelationship>
											</observation>
											</entryRelationship>
											<entryRelationship typeCode="COMP">
											<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
											<observation classCode="OBS" moodCode="EVN">
											<!-- Race Supplemental Data Element template ID -->
											<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
											<code code="103579009" displayName="Race"
											codeSystem="2.16.840.1.113883.6.96"
											codeSystemName="SNOMED CT"/>
											<statusCode code="completed"/>
											<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
											<value xsi:type="CD" code="2028-9" displayName="Asian"
											codeSystem="2.16.840.1.113883.6.238"
											codeSystemName="Race &amp; Ethnicity - CDC"/>
											<entryRelationship typeCode="SUBJ" inversionInd="true">
											<observation classCode="OBS" moodCode="EVN">
											<!-- SHALL 1..1 Aggregate Count template -->
											<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
											<code code="MSRAGG" displayName="rate aggregation"
											codeSystem="2.16.840.1.113883.5.4"
											codeSystemName="ActCode"/>
											<!--  SHALL value xsi:type="INT"-->
											<value xsi:type="INT" value="140"/>
											<methodCode code="COUNT" displayName="Count"
											codeSystem="2.16.840.1.113883.5.84"
											codeSystemName="ObservationMethod"/>
											</observation>
											</entryRelationship>
											</observation>
											</entryRelationship>
											<entryRelationship typeCode="COMP">
											<!-- Sex Supplemental Data Element (2.16.840.1.113883.10.20.27.3.6) -->
											<observation classCode="OBS" moodCode="EVN">
											<!-- Sex Supplemental Data Element template ID -->
											<templateId root="2.16.840.1.113883.10.20.27.3.6"/>
											<!-- SHALL be single value binding to: -->
											<code code="184100006" displayName="patient sex"
											codeSystem="2.16.840.1.113883.6.96"
											codeSystemName="SNOMED-CT"/>
											<statusCode code="completed"/>
											<!-- SHALL be drawn from  Value Set: Administrative Gender (HL7 V3) 2.16.840.1.113883.1.11.1 DYNAMIC-->
											<!-- Example female -->
											<value xsi:type="CD" code="F"
											codeSystem="2.16.840.1.113883.5.1"
											codeSystemName="HL7AdministrativeGenderCode"/>
											<entryRelationship typeCode="SUBJ" inversionInd="true">
											<observation classCode="OBS" moodCode="EVN">
											<!-- SHALL 1..1 Aggregate Count template -->
											<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
											<code code="MSRAGG" displayName="rate aggregation"
											codeSystem="2.16.840.1.113883.5.4"
											codeSystemName="ActCode"/>
											<!--  SHALL value xsi:type="INT"-->
											<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['numerator_female'].'"/>
													<methodCode code="COUNT" displayName="Count"
													codeSystem="2.16.840.1.113883.5.84"
													codeSystemName="ObservationMethod"/>
													</observation>
													</entryRelationship>
													</observation>
													</entryRelationship>
													<entryRelationship typeCode="COMP">
													<!-- Sex Supplemental Data Element (2.16.840.1.113883.10.20.27.3.6) -->
													<observation classCode="OBS" moodCode="EVN">
													<!-- Sex Supplemental Data Element template ID -->
													<templateId root="2.16.840.1.113883.10.20.27.3.6"/>
													<!-- SHALL be single value binding to: -->
													<code code="184100006" displayName="patient sex"
													codeSystem="2.16.840.1.113883.6.96"
													codeSystemName="SNOMED-CT"/>
													<statusCode code="completed"/>
													<!-- SHALL be drawn from  Value Set: Administrative Gender (HL7 V3) 2.16.840.1.113883.1.11.1 DYNAMIC-->
													<value xsi:type="CD" code="M"
													codeSystem="2.16.840.1.113883.5.1"
													codeSystemName="HL7AdministrativeGenderCode"/>
													<entryRelationship typeCode="SUBJ" inversionInd="true">
													<observation classCode="OBS" moodCode="EVN">
													<!-- SHALL 1..1 Aggregate Count template -->
													<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
													<code code="MSRAGG" displayName="rate aggregation"
													codeSystem="2.16.840.1.113883.5.4"
													codeSystemName="ActCode"/>
													<!--  SHALL value xsi:type="INT" to be changed-->
													<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['numerator_male'].'"/>
															<methodCode code="COUNT" displayName="Count"
															codeSystem="2.16.840.1.113883.5.84"
															codeSystemName="ObservationMethod"/>
															</observation>
															</entryRelationship>
															</observation>
															</entryRelationship>
															<entryRelationship typeCode="COMP">
															<!-- Payer Supplemental Data Element (2.16.840.1.113883.10.20.27.3.9) -->
															<observation classCode="OBS" moodCode="EVN">
															<!-- Conforms to Patient Characteristic Payer -->
															<templateId root="2.16.840.1.113883.10.20.24.3.55"/>
															<!-- Payer Supplemental Data Element template ID -->
															<templateId root="2.16.840.1.113883.10.20.27.3.9"/>
															<!-- implied template requires ID -->
															<id nullFlavor="NA"/>
															<!-- SHALL be single value binding to: -->
															<code code="48768-6" displayName="Payment source"
															codeSystem="2.16.840.1.113883.6.1"
															codeSystemName="SNOMED-CT"/>
															<statusCode code="completed"/>
															<!-- SHALL be drawn from  Value Set: PHDSC Source of Payment Typology 2.16.840.1.114222.4.11.3591 DYNAMIC-->
															<value xsi:type="CD" code="349"
															codeSystem="2.16.840.1.113883.3.221.5"
															codeSystemName="Source of Payment Typology"
															displayName="Medicare"/>
															<entryRelationship typeCode="SUBJ" inversionInd="true">
															<observation classCode="OBS" moodCode="EVN">
															<!-- SHALL 1..1 Aggregate Count template -->
															<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
															<code code="MSRAGG" displayName="rate aggregation"
															codeSystem="2.16.840.1.113883.5.4"
															codeSystemName="ActCode"/>
															<!--  SHALL value xsi:type="INT"-->
															<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['numerator_count'].'"/>
																	<methodCode code="COUNT" displayName="Count"
																	codeSystem="2.16.840.1.113883.5.84"
																	codeSystemName="ObservationMethod"/>
																	</observation>
																	</entryRelationship>
																	</observation>
																	</entryRelationship>
																	<entryRelationship typeCode="COMP">
																	<!-- Payer Supplemental Data Element (2.16.840.1.113883.10.20.27.3.9) -->
																	<observation classCode="OBS" moodCode="EVN">
																	<!-- Conforms to Patient Characteristic Payer -->
																	<templateId root="2.16.840.1.113883.10.20.24.3.55"/>
																	<!-- Payer Supplemental Data Element template ID -->
																	<templateId root="2.16.840.1.113883.10.20.27.3.9"/>
																	<!-- implied template requires ID -->
																	<id nullFlavor="NA"/>
																	<!-- SHALL be single value binding to: -->
																	<code code="48768-6" displayName="Payment source"
																	codeSystem="2.16.840.1.113883.6.1"
																	codeSystemName="SNOMED-CT"/>
																	<statusCode code="completed"/>
																	<!-- SHALL be drawn from  Value Set: PHDSC Source of Payment Typology 2.16.840.1.114222.4.11.3591 DYNAMIC-->
																	<value xsi:type="CD" code="349"
																	codeSystem="2.16.840.1.113883.3.221.5"
																	codeSystemName="Source of Payment Typology"
																	displayName="Medicaid"/>
																	<entryRelationship typeCode="SUBJ" inversionInd="true">
																	<observation classCode="OBS" moodCode="EVN">
																	<!-- SHALL 1..1 Aggregate Count template -->
																	<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
																	<code code="MSRAGG" displayName="rate aggregation"
																	codeSystem="2.16.840.1.113883.5.4"
																	codeSystemName="ActCode"/>
																	<!--  SHALL value xsi:type="INT" to be changed-->
																	<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['numerator_count'].'"/>
																			<methodCode code="COUNT" displayName="Count"
																			codeSystem="2.16.840.1.113883.5.84"
																			codeSystemName="ObservationMethod"/>
																			</observation>
																			</entryRelationship>
																			</observation>
																			</entryRelationship>
																			<!-- SHALL 1..1  (Note: this is the reference for the entire population starting with the first component
																			observation at the top within the measure data template-->
																			<reference typeCode="REFR">
																			<!-- reference to the relevant population in the eMeasure -->
																			<externalObservation classCode="OBS" moodCode="EVN">
																			<id root="'.$moredata[0]['CqmList']['numerator_rootid'].'"/>
																					</externalObservation>
																					</reference>
																					</observation>
																					</component>';
			//end of NUMER component

			//start of DENEX component
			if($moredata[0]['CqmList']['exclusions_rootid']!="")
			{
				$eh_measure.='<component>
						<observation classCode="OBS" moodCode="EVN">
						<!-- Measure Data template -->
						<templateId root="2.16.840.1.113883.10.20.27.3.5"/>
						<code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4"
						displayName="Assertion" codeSystemName="ActCode"/>
						<statusCode code="completed"/>
						<!-- SHALL value with SHOULD be from valueSetName="ObservationPopulationInclusion "	valueSetOid="2.16.840.1.113883.1.11.20369"	Binding: Dynamic
						-->
						<value xsi:type="CD" code="DENEX"
						codeSystem="2.16.840.1.113883.5.1063"
						displayName="Denominator Exclusions"
						codeSystemName="ObservationValue"/>
						<!-- SHALL contain aggregate count template -->
						<entryRelationship typeCode="SUBJ" inversionInd="true">
						<!-- Aggregate Count (2.16.840.1.113883.10.20.27.3.3) -->
						<observation classCode="OBS" moodCode="EVN">
						<!-- Aggregate Count template -->
						<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
						<code code="MSRAGG" displayName="rate aggregation"
						codeSystem="2.16.840.1.113883.5.4"
						codeSystemName="ActCode"/>
						<!--  SHALL value xsi:type="INT"-->
						<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['exclusion_denominator'].'"/>
								<methodCode code="COUNT" displayName="Count"
								codeSystem="2.16.840.1.113883.5.84"
								codeSystemName="ObservationMethod"/>
								</observation>
								</entryRelationship>
								<entryRelationship typeCode="COMP">
								<!-- Postal Code Supplemental Data Element (2.16.840.1.113883.10.20.27.3.10)-->
								<observation classCode="OBS" moodCode="EVN">
								<!-- Postal Code Supplemental Data Element template ID -->
								<templateId root="2.16.840.1.113883.10.20.27.3.10"/>
								<!-- SHALL single value binding -->
								<code code="184102003" displayName="patient postal code"
								codeSystem="2.16.840.1.113883.6.96"
								codeSystemName="SNOMED-CT"/>
								<statusCode code="completed"/>
								<!-- SHALL be xsi:type="ST"-->
								<value xsi:type="ST">92543</value>
								<!-- SHALL 1..1 Aggregate Count template -->
								<entryRelationship typeCode="SUBJ" inversionInd="true">
								<observation classCode="OBS" moodCode="EVN">
								<!-- Aggregate Count template -->
								<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
								<code code="MSRAGG" displayName="rate aggregation"
								codeSystem="2.16.840.1.113883.5.4"
								codeSystemName="ActCode"/>
								<!--  SHALL value xsi:type="INT"-->
								<value xsi:type="INT" value="0"/>
								<methodCode code="COUNT" displayName="Count"
								codeSystem="2.16.840.1.113883.5.84"
								codeSystemName="ObservationMethod"/>
								</observation>
								</entryRelationship>
								</observation>
								</entryRelationship>
								<entryRelationship typeCode="COMP">
								<!-- Ethnicity Supplemental Data Element (2.16.840.1.113883.10.20.27.3.7) -->
								<observation classCode="OBS" moodCode="EVN">
								<!-- Ethnicity Supplemental Data Element template ID -->
								<templateId root="2.16.840.1.113883.10.20.27.3.7"/>
								<!-- SHALL single value binding -->
								<code code="364699009" displayName="Ethnic Group"
								codeSystem="2.16.840.1.113883.6.96"
								codeSystemName="SNOMED CT"/>
								<statusCode code="completed"/>
								<!-- SHALL be bound to CDC Ethnicity group Value Set OID 2.16.840.1.114222.4.11.837 - dynamic -->
								<!-- Not hispanic -->
								<value xsi:type="CD" code="2186-5"
								displayName="Not Hispanic or Latino"
								codeSystem="2.16.840.1.113883.6.238"
								codeSystemName="Race &amp; Ethnicity - CDC"/>
								<!-- SHALL 1..1 Aggregate Count template -->
								<entryRelationship typeCode="SUBJ" inversionInd="true">
								<observation classCode="OBS" moodCode="EVN">
								<!-- Aggregate Count template -->
								<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
								<code code="MSRAGG" displayName="rate aggregation"
								codeSystem="2.16.840.1.113883.5.4"
								codeSystemName="ActCode"/>
								<!--  SHALL value xsi:type="INT"-->
								<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['exclud_eth'].'"/>
										<methodCode code="COUNT" displayName="Count"
										codeSystem="2.16.840.1.113883.5.84"
										codeSystemName="ObservationMethod"/>
										</observation>
										</entryRelationship>
										</observation>
										</entryRelationship>
										<entryRelationship typeCode="COMP">
										<!-- Ethnicity Supplemental Data Element (2.16.840.1.113883.10.20.27.3.7) -->
										<observation classCode="OBS" moodCode="EVN">
										<!-- Ethnicity Supplemental Data Element template ID -->
										<templateId root="2.16.840.1.113883.10.20.27.3.7"/>
										<code code="364699009" displayName="Ethnic Group"
										codeSystem="2.16.840.1.113883.6.96"
										codeSystemName="SNOMED CT"/>
										<statusCode code="completed"/>
										<!-- SHALL be bound to CDC Ethnicity group Value Set OID 2.16.840.1.114222.4.11.837 - dynamic -->
										<!-- Hispanic -->
										<value xsi:type="CD" code="2135-2"
										displayName="Hispanic or Latino"
										codeSystem="2.16.840.1.113883.6.238"
										codeSystemName="Race &amp; Ethnicity - CDC"/>
										<!-- SHALL 1..1 Aggregate Count template -->
										<entryRelationship typeCode="SUBJ" inversionInd="true">
										<observation classCode="OBS" moodCode="EVN">
										<!-- Aggregate Count template -->
										<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
										<code code="MSRAGG" displayName="rate aggregation"
										codeSystem="2.16.840.1.113883.5.4"
										codeSystemName="ActCode"/>
										<!--  SHALL value xsi:type="INT"-->
										<value xsi:type="INT" value="13"/>
										<methodCode code="COUNT" displayName="Count"
										codeSystem="2.16.840.1.113883.5.84"
										codeSystemName="ObservationMethod"/>
										</observation>
										</entryRelationship>
										</observation>
										</entryRelationship>
										<entryRelationship typeCode="COMP">
										<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
										<observation classCode="OBS" moodCode="EVN">
										<!-- Race Supplemental Data Element template ID -->
										<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
										<code code="103579009" displayName="Race"
										codeSystem="2.16.840.1.113883.6.96"
										codeSystemName="SNOMED CT"/>
										<statusCode code="completed"/>
										<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
										<value xsi:type="CD" code="1002-5"
										displayName="American Indian or Alaska Native"
										codeSystem="2.16.840.1.113883.6.238"
										codeSystemName="Race &amp; Ethnicity - CDC"/>
										<entryRelationship typeCode="SUBJ" inversionInd="true">
										<observation classCode="OBS" moodCode="EVN">
										<!-- SHALL 1..1 Aggregate Count template -->
										<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
										<code code="MSRAGG" displayName="rate aggregation"
										codeSystem="2.16.840.1.113883.5.4"
										codeSystemName="ActCode"/>
										<!--  SHALL value xsi:type="INT"-->
										<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['exclud_race'].'"/>
												<methodCode code="COUNT" displayName="Count"
												codeSystem="2.16.840.1.113883.5.84"
												codeSystemName="ObservationMethod"/>
												</observation>
												</entryRelationship>
												</observation>
												</entryRelationship>
												<entryRelationship typeCode="COMP">
												<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
												<observation classCode="OBS" moodCode="EVN">
												<!-- Race Supplemental Data Element template ID -->
												<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
												<code code="103579009" displayName="Race"
												codeSystem="2.16.840.1.113883.6.96"
												codeSystemName="SNOMED CT"/>
												<statusCode code="completed"/>
												<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
												<value xsi:type="CD" code="2131-1" displayName="White"
												codeSystem="2.16.840.1.113883.6.238"
												codeSystemName="Race &amp; Ethnicity - CDC"/>
												<entryRelationship typeCode="SUBJ" inversionInd="true">
												<observation classCode="OBS" moodCode="EVN">
												<!-- SHALL 1..1 Aggregate Count template -->
												<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
												<code code="MSRAGG" displayName="rate aggregation"
												codeSystem="2.16.840.1.113883.5.4"
												codeSystemName="ActCode"/>
												<!--  SHALL value xsi:type="INT"-->
												<value xsi:type="INT" value="7"/>
												<methodCode code="COUNT" displayName="Count"
												codeSystem="2.16.840.1.113883.5.84"
												codeSystemName="ObservationMethod"/>
												</observation>
												</entryRelationship>
												</observation>
												</entryRelationship>
												<entryRelationship typeCode="COMP">
												<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
												<observation classCode="OBS" moodCode="EVN">
												<!-- Race Supplemental Data Element template ID -->
												<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
												<code code="103579009" displayName="Race"
												codeSystem="2.16.840.1.113883.6.96"
												codeSystemName="SNOMED CT"/>
												<statusCode code="completed"/>
												<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
												<value xsi:type="CD" code="2028-9" displayName="Asian"
												codeSystem="2.16.840.1.113883.6.238"
												codeSystemName="Race &amp; Ethnicity - CDC"/>
												<entryRelationship typeCode="SUBJ" inversionInd="true">
												<observation classCode="OBS" moodCode="EVN">
												<!-- SHALL 1..1 Aggregate Count template -->
												<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
												<code code="MSRAGG" displayName="rate aggregation"
												codeSystem="2.16.840.1.113883.5.4"
												codeSystemName="ActCode"/>
												<!--  SHALL value xsi:type="INT"-->
												<value xsi:type="INT" value="7"/>
												<methodCode code="COUNT" displayName="Count"
												codeSystem="2.16.840.1.113883.5.84"
												codeSystemName="ObservationMethod"/>
												</observation>
												</entryRelationship>
												</observation>
												</entryRelationship>
												<entryRelationship typeCode="COMP">
												<!-- Sex Supplemental Data Element (2.16.840.1.113883.10.20.27.3.6) -->
												<observation classCode="OBS" moodCode="EVN">
												<!-- Sex Supplemental Data Element template ID -->
												<templateId root="2.16.840.1.113883.10.20.27.3.6"/>
												<!-- SHALL be single value binding to: -->
												<code code="184100006" displayName="patient sex"
												codeSystem="2.16.840.1.113883.6.96"
												codeSystemName="SNOMED-CT"/>
												<statusCode code="completed"/>
												<!-- SHALL be drawn from  Value Set: Administrative Gender (HL7 V3) 2.16.840.1.113883.1.11.1 DYNAMIC-->
												<!-- Example female -->
												<value xsi:type="CD" code="F"
												codeSystem="2.16.840.1.113883.5.1"
												codeSystemName="HL7AdministrativeGenderCode"/>
												<entryRelationship typeCode="SUBJ" inversionInd="true">
												<observation classCode="OBS" moodCode="EVN">
												<!-- SHALL 1..1 Aggregate Count template -->
												<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
												<code code="MSRAGG" displayName="rate aggregation"
												codeSystem="2.16.840.1.113883.5.4"
												codeSystemName="ActCode"/>
												<!--  SHALL value xsi:type="INT"-->
												<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['exclud_female'].'"/>
														<methodCode code="COUNT" displayName="Count"
														codeSystem="2.16.840.1.113883.5.84"
														codeSystemName="ObservationMethod"/>
														</observation>
														</entryRelationship>
														</observation>
														</entryRelationship>
														<entryRelationship typeCode="COMP">
														<!-- Sex Supplemental Data Element (2.16.840.1.113883.10.20.27.3.6) -->
														<observation classCode="OBS" moodCode="EVN">
														<!-- Sex Supplemental Data Element template ID -->
														<templateId root="2.16.840.1.113883.10.20.27.3.6"/>
														<!-- SHALL be single value binding to: -->
														<code code="184100006" displayName="patient sex"
														codeSystem="2.16.840.1.113883.6.96"
														codeSystemName="SNOMED-CT"/>
														<statusCode code="completed"/>
														<!-- SHALL be drawn from  Value Set: Administrative Gender (HL7 V3) 2.16.840.1.113883.1.11.1 DYNAMIC-->
														<value xsi:type="CD" code="M"
														codeSystem="2.16.840.1.113883.5.1"
														codeSystemName="HL7AdministrativeGenderCode"/>
														<entryRelationship typeCode="SUBJ" inversionInd="true">
														<observation classCode="OBS" moodCode="EVN">
														<!-- SHALL 1..1 Aggregate Count template -->
														<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
														<code code="MSRAGG" displayName="rate aggregation"
														codeSystem="2.16.840.1.113883.5.4"
														codeSystemName="ActCode"/>
														<!--  SHALL value xsi:type="INT"-->
														<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['exclud_male'].'"/>
																<methodCode code="COUNT" displayName="Count"
																codeSystem="2.16.840.1.113883.5.84"
																codeSystemName="ObservationMethod"/>
																</observation>
																</entryRelationship>
																</observation>
																</entryRelationship>
																<entryRelationship typeCode="COMP">
																<!-- Payer Supplemental Data Element (2.16.840.1.113883.10.20.27.3.9) -->
																<observation classCode="OBS" moodCode="EVN">
																<!-- Conforms to Patient Characteristic Payer -->
																<templateId root="2.16.840.1.113883.10.20.24.3.55"/>
																<!-- Payer Supplemental Data Element template ID -->
																<templateId root="2.16.840.1.113883.10.20.27.3.9"/>
																<!-- implied template requires ID -->
																<id nullFlavor="NA"/>
																<!-- SHALL be single value binding to: -->
																<code code="48768-6" displayName="Payment source"
																codeSystem="2.16.840.1.113883.6.1"
																codeSystemName="SNOMED-CT"/>
																<statusCode code="completed"/>
																<!-- SHALL be drawn from  Value Set: PHDSC Source of Payment Typology 2.16.840.1.114222.4.11.3591 DYNAMIC-->
																<value xsi:type="CD" code="349"
																codeSystem="2.16.840.1.113883.3.221.5"
																codeSystemName="Source of Payment Typology"
																displayName="Medicare"/>
																<entryRelationship typeCode="SUBJ" inversionInd="true">
																<observation classCode="OBS" moodCode="EVN">
																<!-- SHALL 1..1 Aggregate Count template -->
																<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
																<code code="MSRAGG" displayName="rate aggregation"
																codeSystem="2.16.840.1.113883.5.4"
																codeSystemName="ActCode"/>
																<!--  SHALL value xsi:type="INT"-->
																<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['exclusion_denominator'].'"/>
																		<methodCode code="COUNT" displayName="Count"
																		codeSystem="2.16.840.1.113883.5.84"
																		codeSystemName="ObservationMethod"/>
																		</observation>
																		</entryRelationship>
																		</observation>
																		</entryRelationship>
																		<entryRelationship typeCode="COMP">
																		<!-- Payer Supplemental Data Element (2.16.840.1.113883.10.20.27.3.9) -->
																		<observation classCode="OBS" moodCode="EVN">
																		<!-- Conforms to Patient Characteristic Payer -->
																		<templateId root="2.16.840.1.113883.10.20.24.3.55"/>
																		<!-- Payer Supplemental Data Element template ID -->
																		<templateId root="2.16.840.1.113883.10.20.27.3.9"/>
																		<!-- implied template requires ID -->
																		<id nullFlavor="NA"/>
																		<!-- SHALL be single value binding to: -->
																		<code code="48768-6" displayName="Payment source"
																		codeSystem="2.16.840.1.113883.6.1"
																		codeSystemName="SNOMED-CT"/>
																		<statusCode code="completed"/>
																		<!-- SHALL be drawn from  Value Set: PHDSC Source of Payment Typology 2.16.840.1.114222.4.11.3591 DYNAMIC-->
																		<value xsi:type="CD" code="349"
																		codeSystem="2.16.840.1.113883.3.221.5"
																		codeSystemName="Source of Payment Typology"
																		displayName="Medicaid"/>
																		<entryRelationship typeCode="SUBJ" inversionInd="true">
																		<observation classCode="OBS" moodCode="EVN">
																		<!-- SHALL 1..1 Aggregate Count template -->
																		<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
																		<code code="MSRAGG" displayName="rate aggregation"
																		codeSystem="2.16.840.1.113883.5.4"
																		codeSystemName="ActCode"/>
																		<!--  SHALL value xsi:type="INT"-->
																		<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['exclusion_denominator'].'"/>
																				<methodCode code="COUNT" displayName="Count"
																				codeSystem="2.16.840.1.113883.5.84"
																				codeSystemName="ObservationMethod"/>
																				</observation>
																				</entryRelationship>
																				</observation>
																				</entryRelationship>
																				<!-- SHALL 1..1  (Note: this is the reference for the entire population starting with the first component
																				observation at the top within the measure data template-->
																				<reference typeCode="REFR">
																				<!-- reference to the relevant population in the eMeasure -->
																				<externalObservation classCode="OBS" moodCode="EVN">
																				<id root="'.$moredata[0]['CqmList']['exclusions_rootid'].'"/>
																						</externalObservation>
																						</reference>
																						</observation>
																						</component>';
			}

			//end of DENEX component

			//start of DENEXCEP component
			if($moredata[0]['CqmList']['denexcep_rootid']!="")
			{
				$eh_measure.='<component>
						<observation classCode="OBS" moodCode="EVN">
						<!-- Measure Data template -->
						<templateId root="2.16.840.1.113883.10.20.27.3.5"/>
						<code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4"
						displayName="Assertion" codeSystemName="ActCode"/>
						<statusCode code="completed"/>
						<!-- SHALL value with SHOULD be from valueSetName="ObservationPopulationInclusion "	valueSetOid="2.16.840.1.113883.1.11.20369"	Binding: Dynamic
						-->
						<value xsi:type="CD" code="DENEXCEP"
						codeSystem="2.16.840.1.113883.5.1063"
						displayName="Denominator Exceptions"
						codeSystemName="ObservationValue"/>
						<!-- SHALL contain aggregate count template -->
						<entryRelationship typeCode="SUBJ" inversionInd="true">
						<!-- Aggregate Count (2.16.840.1.113883.10.20.27.3.3) -->
						<observation classCode="OBS" moodCode="EVN">
						<!-- Aggregate Count template -->
						<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
						<code code="MSRAGG" displayName="rate aggregation"
						codeSystem="2.16.840.1.113883.5.4"
						codeSystemName="ActCode"/>
						<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['exception_denominator'].'"/>
								<methodCode code="COUNT" displayName="Count"
								codeSystem="2.16.840.1.113883.5.84"
								codeSystemName="ObservationMethod"/>
								</observation>
								</entryRelationship>

								<entryRelationship typeCode="COMP">
								<!-- Postal Code Supplemental Data Element (2.16.840.1.113883.10.20.27.3.10)-->
								<observation classCode="OBS" moodCode="EVN">
								<!-- Postal Code Supplemental Data Element template ID -->
								<templateId root="2.16.840.1.113883.10.20.27.3.10"/>
								<!-- SHALL single value binding -->
								<code code="184102003" displayName="patient postal code"
								codeSystem="2.16.840.1.113883.6.96"
								codeSystemName="SNOMED-CT"/>
								<statusCode code="completed"/>
								<!-- SHALL be xsi:type="ST"-->
								<value xsi:type="ST">92543</value>
								<!-- SHALL 1..1 Aggregate Count template -->
								<entryRelationship typeCode="SUBJ" inversionInd="true">
								<observation classCode="OBS" moodCode="EVN">
								<!-- Aggregate Count template -->
								<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
								<code code="MSRAGG" displayName="rate aggregation"
								codeSystem="2.16.840.1.113883.5.4"
								codeSystemName="ActCode"/>
								<!--  SHALL value xsi:type="INT"-->
								<value xsi:type="INT" value="0"/>
								<methodCode code="COUNT" displayName="Count"
								codeSystem="2.16.840.1.113883.5.84"
								codeSystemName="ObservationMethod"/>
								</observation>
								</entryRelationship>
								</observation>
								</entryRelationship>
								<entryRelationship typeCode="COMP">
								<!-- Ethnicity Supplemental Data Element (2.16.840.1.113883.10.20.27.3.7) -->
								<observation classCode="OBS" moodCode="EVN">
								<!-- Ethnicity Supplemental Data Element template ID -->
								<templateId root="2.16.840.1.113883.10.20.27.3.7"/>
								<!-- SHALL single value binding -->
								<code code="364699009" displayName="Ethnic Group"
								codeSystem="2.16.840.1.113883.6.96"
								codeSystemName="SNOMED CT"/>
								<statusCode code="completed"/>
								<!-- SHALL be bound to CDC Ethnicity group Value Set OID 2.16.840.1.114222.4.11.837 - dynamic -->
								<!-- Not hispanic -->
								<value xsi:type="CD" code="2186-5"
								displayName="Not Hispanic or Latino"
								codeSystem="2.16.840.1.113883.6.238"
								codeSystemName="Race &amp; Ethnicity - CDC"/>
								<!-- SHALL 1..1 Aggregate Count template -->
								<entryRelationship typeCode="SUBJ" inversionInd="true">
								<observation classCode="OBS" moodCode="EVN">
								<!-- Aggregate Count template -->
								<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
								<code code="MSRAGG" displayName="rate aggregation"
								codeSystem="2.16.840.1.113883.5.4"
								codeSystemName="ActCode"/>
								<!--  SHALL value xsi:type="INT"-->
								<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['excepn_eth'].'"/>
										<methodCode code="COUNT" displayName="Count"
										codeSystem="2.16.840.1.113883.5.84"
										codeSystemName="ObservationMethod"/>
										</observation>
										</entryRelationship>
										</observation>
										</entryRelationship>
										<entryRelationship typeCode="COMP">
										<!-- Ethnicity Supplemental Data Element (2.16.840.1.113883.10.20.27.3.7) -->
										<observation classCode="OBS" moodCode="EVN">
										<!-- Ethnicity Supplemental Data Element template ID -->
										<templateId root="2.16.840.1.113883.10.20.27.3.7"/>
										<code code="364699009" displayName="Ethnic Group"
										codeSystem="2.16.840.1.113883.6.96"
										codeSystemName="SNOMED CT"/>
										<statusCode code="completed"/>
										<!-- SHALL be bound to CDC Ethnicity group Value Set OID 2.16.840.1.114222.4.11.837 - dynamic -->
										<!-- Hispanic -->
										<value xsi:type="CD" code="2135-2"
										displayName="Hispanic or Latino"
										codeSystem="2.16.840.1.113883.6.238"
										codeSystemName="Race &amp; Ethnicity - CDC"/>
										<!-- SHALL 1..1 Aggregate Count template -->
										<entryRelationship typeCode="SUBJ" inversionInd="true">
										<observation classCode="OBS" moodCode="EVN">
										<!-- Aggregate Count template -->
										<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
										<code code="MSRAGG" displayName="rate aggregation"
										codeSystem="2.16.840.1.113883.5.4"
										codeSystemName="ActCode"/>
										<!--  SHALL value xsi:type="INT"-->
										<value xsi:type="INT" value="13"/>
										<methodCode code="COUNT" displayName="Count"
										codeSystem="2.16.840.1.113883.5.84"
										codeSystemName="ObservationMethod"/>
										</observation>
										</entryRelationship>
										</observation>
										</entryRelationship>
										<entryRelationship typeCode="COMP">
										<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
										<observation classCode="OBS" moodCode="EVN">
										<!-- Race Supplemental Data Element template ID -->
										<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
										<code code="103579009" displayName="Race"
										codeSystem="2.16.840.1.113883.6.96"
										codeSystemName="SNOMED CT"/>
										<statusCode code="completed"/>
										<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
										<value xsi:type="CD" code="1002-5"
										displayName="American Indian or Alaska Native"
										codeSystem="2.16.840.1.113883.6.238"
										codeSystemName="Race &amp; Ethnicity - CDC"/>
										<entryRelationship typeCode="SUBJ" inversionInd="true">
										<observation classCode="OBS" moodCode="EVN">
										<!-- SHALL 1..1 Aggregate Count template -->
										<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
										<code code="MSRAGG" displayName="rate aggregation"
										codeSystem="2.16.840.1.113883.5.4"
										codeSystemName="ActCode"/>
										<!--  SHALL value xsi:type="INT"-->
										<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['excepn_race'].'"/>
												<methodCode code="COUNT" displayName="Count"
												codeSystem="2.16.840.1.113883.5.84"
												codeSystemName="ObservationMethod"/>
												</observation>
												</entryRelationship>
												</observation>
												</entryRelationship>
												<entryRelationship typeCode="COMP">
												<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
												<observation classCode="OBS" moodCode="EVN">
												<!-- Race Supplemental Data Element template ID -->
												<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
												<code code="103579009" displayName="Race"
												codeSystem="2.16.840.1.113883.6.96"
												codeSystemName="SNOMED CT"/>
												<statusCode code="completed"/>
												<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
												<value xsi:type="CD" code="2131-1" displayName="White"
												codeSystem="2.16.840.1.113883.6.238"
												codeSystemName="Race &amp; Ethnicity - CDC"/>
												<entryRelationship typeCode="SUBJ" inversionInd="true">
												<observation classCode="OBS" moodCode="EVN">
												<!-- SHALL 1..1 Aggregate Count template -->
												<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
												<code code="MSRAGG" displayName="rate aggregation"
												codeSystem="2.16.840.1.113883.5.4"
												codeSystemName="ActCode"/>
												<!--  SHALL value xsi:type="INT"-->
												<value xsi:type="INT" value="7"/>
												<methodCode code="COUNT" displayName="Count"
												codeSystem="2.16.840.1.113883.5.84"
												codeSystemName="ObservationMethod"/>
												</observation>
												</entryRelationship>
												</observation>
												</entryRelationship>
												<entryRelationship typeCode="COMP">
												<!-- Race Supplemental Data Element (2.16.840.1.113883.10.20.27.3.8) -->
												<observation classCode="OBS" moodCode="EVN">
												<!-- Race Supplemental Data Element template ID -->
												<templateId root="2.16.840.1.113883.10.20.27.3.8"/>
												<code code="103579009" displayName="Race"
												codeSystem="2.16.840.1.113883.6.96"
												codeSystemName="SNOMED CT"/>
												<statusCode code="completed"/>
												<!-- SHALL be bound to CDC Race Category Value Set OID 2.16.840.1.114222.4.11.836 - dynamic -->
												<value xsi:type="CD" code="2028-9" displayName="Asian"
												codeSystem="2.16.840.1.113883.6.238"
												codeSystemName="Race &amp; Ethnicity - CDC"/>
												<entryRelationship typeCode="SUBJ" inversionInd="true">
												<observation classCode="OBS" moodCode="EVN">
												<!-- SHALL 1..1 Aggregate Count template -->
												<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
												<code code="MSRAGG" displayName="rate aggregation"
												codeSystem="2.16.840.1.113883.5.4"
												codeSystemName="ActCode"/>
												<!--  SHALL value xsi:type="INT"-->
												<value xsi:type="INT" value="7"/>
												<methodCode code="COUNT" displayName="Count"
												codeSystem="2.16.840.1.113883.5.84"
												codeSystemName="ObservationMethod"/>
												</observation>
												</entryRelationship>
												</observation>
												</entryRelationship>
												<entryRelationship typeCode="COMP">
												<!-- Sex Supplemental Data Element (2.16.840.1.113883.10.20.27.3.6) -->
												<observation classCode="OBS" moodCode="EVN">
												<!-- Sex Supplemental Data Element template ID -->
												<templateId root="2.16.840.1.113883.10.20.27.3.6"/>
												<!-- SHALL be single value binding to: -->
												<code code="184100006" displayName="patient sex"
												codeSystem="2.16.840.1.113883.6.96"
												codeSystemName="SNOMED-CT"/>
												<statusCode code="completed"/>
												<!-- SHALL be drawn from  Value Set: Administrative Gender (HL7 V3) 2.16.840.1.113883.1.11.1 DYNAMIC-->
												<!-- Example female -->
												<value xsi:type="CD" code="F"
												codeSystem="2.16.840.1.113883.5.1"
												codeSystemName="HL7AdministrativeGenderCode"/>
												<entryRelationship typeCode="SUBJ" inversionInd="true">
												<observation classCode="OBS" moodCode="EVN">
												<!-- SHALL 1..1 Aggregate Count template -->
												<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
												<code code="MSRAGG" displayName="rate aggregation"
												codeSystem="2.16.840.1.113883.5.4"
												codeSystemName="ActCode"/>
												<!--  SHALL value xsi:type="INT"-->
												<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['excepn_female'].'"/>
														<methodCode code="COUNT" displayName="Count"
														codeSystem="2.16.840.1.113883.5.84"
														codeSystemName="ObservationMethod"/>
														</observation>
														</entryRelationship>
														</observation>
														</entryRelationship>
														<entryRelationship typeCode="COMP">
														<!-- Sex Supplemental Data Element (2.16.840.1.113883.10.20.27.3.6) -->
														<observation classCode="OBS" moodCode="EVN">
														<!-- Sex Supplemental Data Element template ID -->
														<templateId root="2.16.840.1.113883.10.20.27.3.6"/>
														<!-- SHALL be single value binding to: -->
														<code code="184100006" displayName="patient sex"
														codeSystem="2.16.840.1.113883.6.96"
														codeSystemName="SNOMED-CT"/>
														<statusCode code="completed"/>
														<!-- SHALL be drawn from  Value Set: Administrative Gender (HL7 V3) 2.16.840.1.113883.1.11.1 DYNAMIC-->
														<value xsi:type="CD" code="M"
														codeSystem="2.16.840.1.113883.5.1"
														codeSystemName="HL7AdministrativeGenderCode"/>
														<entryRelationship typeCode="SUBJ" inversionInd="true">
														<observation classCode="OBS" moodCode="EVN">
														<!-- SHALL 1..1 Aggregate Count template -->
														<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
														<code code="MSRAGG" displayName="rate aggregation"
														codeSystem="2.16.840.1.113883.5.4"
														codeSystemName="ActCode"/>
														<!--  SHALL value xsi:type="INT"-->
														<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['excepn_male'].'"/>
																<methodCode code="COUNT" displayName="Count"
																codeSystem="2.16.840.1.113883.5.84"
																codeSystemName="ObservationMethod"/>
																</observation>
																</entryRelationship>
																</observation>
																</entryRelationship>
																<entryRelationship typeCode="COMP">
																<!-- Payer Supplemental Data Element (2.16.840.1.113883.10.20.27.3.9) -->
																<observation classCode="OBS" moodCode="EVN">
																<!-- Conforms to Patient Characteristic Payer -->
																<templateId root="2.16.840.1.113883.10.20.24.3.55"/>
																<!-- Payer Supplemental Data Element template ID -->
																<templateId root="2.16.840.1.113883.10.20.27.3.9"/>
																<!-- implied template requires ID -->
																<id nullFlavor="NA"/>
																<!-- SHALL be single value binding to: -->
																<code code="48768-6" displayName="Payment source"
																codeSystem="2.16.840.1.113883.6.1"
																codeSystemName="SNOMED-CT"/>
																<statusCode code="completed"/>
																<!-- SHALL be drawn from  Value Set: PHDSC Source of Payment Typology 2.16.840.1.114222.4.11.3591 DYNAMIC-->
																<value xsi:type="CD" code="349"
																codeSystem="2.16.840.1.113883.3.221.5"
																codeSystemName="Source of Payment Typology"
																displayName="Medicare"/>
																<entryRelationship typeCode="SUBJ" inversionInd="true">
																<observation classCode="OBS" moodCode="EVN">
																<!-- SHALL 1..1 Aggregate Count template -->
																<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
																<code code="MSRAGG" displayName="rate aggregation"
																codeSystem="2.16.840.1.113883.5.4"
																codeSystemName="ActCode"/>
																<!--  SHALL value xsi:type="INT"-->
																<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['exception_denominator'].'"/>
																		<methodCode code="COUNT" displayName="Count"
																		codeSystem="2.16.840.1.113883.5.84"
																		codeSystemName="ObservationMethod"/>
																		</observation>
																		</entryRelationship>
																		</observation>
																		</entryRelationship>
																		<entryRelationship typeCode="COMP">
																		<!-- Payer Supplemental Data Element (2.16.840.1.113883.10.20.27.3.9) -->
																		<observation classCode="OBS" moodCode="EVN">
																		<!-- Conforms to Patient Characteristic Payer -->
																		<templateId root="2.16.840.1.113883.10.20.24.3.55"/>
																		<!-- Payer Supplemental Data Element template ID -->
																		<templateId root="2.16.840.1.113883.10.20.27.3.9"/>
																		<!-- implied template requires ID -->
																		<id nullFlavor="NA"/>
																		<!-- SHALL be single value binding to: -->
																		<code code="48768-6" displayName="Payment source"
																		codeSystem="2.16.840.1.113883.6.1"
																		codeSystemName="SNOMED-CT"/>
																		<statusCode code="completed"/>
																		<!-- SHALL be drawn from  Value Set: PHDSC Source of Payment Typology 2.16.840.1.114222.4.11.3591 DYNAMIC-->
																		<value xsi:type="CD" code="349"
																		codeSystem="2.16.840.1.113883.3.221.5"
																		codeSystemName="Source of Payment Typology"
																		displayName="Medicaid"/>
																		<entryRelationship typeCode="SUBJ" inversionInd="true">
																		<observation classCode="OBS" moodCode="EVN">
																		<!-- SHALL 1..1 Aggregate Count template -->
																		<templateId root="2.16.840.1.113883.10.20.27.3.3"/>
																		<code code="MSRAGG" displayName="rate aggregation"
																		codeSystem="2.16.840.1.113883.5.4"
																		codeSystemName="ActCode"/>
																		<!--  SHALL value xsi:type="INT"-->
																		<value xsi:type="INT" value="'.$ehdatas['CqmReportEh']['exception_denominator'].'"/>
																				<methodCode code="COUNT" displayName="Count"
																				codeSystem="2.16.840.1.113883.5.84"
																				codeSystemName="ObservationMethod"/>
																				</observation>
																				</entryRelationship>
																				</observation>
																				</entryRelationship>

																				<reference typeCode="REFR">
																				<externalObservation classCode="OBS" moodCode="EVN">
																				<id root="'.$moredata[0]['CqmList']['denexcep_rootid'].'"/>
																						</externalObservation>
																						</reference>
																						</observation>
																						</component>';
			}
		
				
			$eh_measure.='</organizer>
					</entry>';
			
			
		}
		
	
		$recive_entry1=$CqmReportEh->find('all',array('conditions'=>array('measure_type'=>'continuous')));
		 $eh_measure1='<entry>
                        <organizer classCode="CLUSTER" moodCode="EVN">
                            <templateId root="2.16.840.1.113883.10.20.24.3.98"/>
                            <templateId root="2.16.840.1.113883.10.20.27.3.1"/>
                            <statusCode code="completed"/>
                            <reference typeCode="REFR">
                                <externalDocument classCode="DOC" moodCode="EVN">
                                    <id root="40280381-3d27-5493-013d-61073da32a30"/>
                                    <id root="2.16.840.1.113883.3.560.1" extension="0496"/>
                                    <text>Emergency Department Throughput</text>
                                    <setId root="3FD13096-2C8F-40B5-9297-B714E8DE9133"/>
                                    <versionNumber value="3"/>
                                </externalDocument>
                            </reference>
                            <component>
                                <observation classCode="OBS" moodCode="EVN">
                                    <templateId root="2.16.840.1.113883.10.20.27.3.5"/>
                                    <code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="Assertion"/>
                                    <statusCode code="completed"/>
                                    <value xsi:type="CD" code="IPP" codeSystem="2.16.840.1.113883.5.1063" codeSystemName="ObservationValue" displayName="Initial Patient 

Population"/>
                                    <entryRelationship typeCode="SUBJ" inversionInd="true">
                                        <observation classCode="OBS" moodCode="EVN">
                                            <templateId root="2.16.840.1.113883.10.20.27.3.3"/>
                                            <code code="MSRAGG" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="rate aggregation"/>
                                            <value xsi:type="INT" value="'.$recive_entry1[0][CqmReportEh][ipp_count].'"/>
                                            <methodCode code="COUNT" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Count"/>
                                        </observation>
                                    </entryRelationship>
                                    <entryRelationship typeCode="COMP">
                                        <observation classCode="OBS" moodCode="EVN">
                                            <templateId root="2.16.840.1.113883.10.20.27.3.4"/>
                                            <code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="Assertion"/>
                                            <statusCode code="completed"/>
                                            <value xsi:type="CD" nullFlavor="OTH">
                                                <originalText>Stratum</originalText>
                                            </value>
                                            <entryRelationship typeCode="SUBJ" inversionInd="true">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.3"/>
                                                    <code code="MSRAGG" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="rate aggregation"/>
                                                    <value xsi:type="INT" value="'.$recive_entry1[1][CqmReportEh][ipp_count].'"/>
                                                    <methodCode code="COUNT" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Count"/>
                                                </observation>
                                            </entryRelationship>
                                            <entryRelationship typeCode="COMP">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.2"/>
                                                    <code nullFlavor="OTH">
                                                        <originalText>Time Difference</originalText>
                                                    </code>
                                                    <statusCode code="completed"/>
                                                    <value xsi:type="PQ" value="'.$recive_entry1[1][CqmReportEh][measure_observation].'" unit="min"/>
                                                    <methodCode code="MEDIAN" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Median"/>
                                                    <reference typeCode="REFR">
                                                        <externalObservation classCode="OBS" moodCode="EVN">
                                                            <id root="b63f908e-5308-424e-948c-b28e5dc22613"/>
                                                        </externalObservation>
                                                    </reference>
                                                </observation>
                                            </entryRelationship>
                                            <reference typeCode="REFR">
                                                <externalObservation classCode="OBS" moodCode="EVN">
                                                    <id root="A9240D7F-91BD-4A17-B6DA-6B72E0682EDD"/>
                                                </externalObservation>
                                            </reference>
                                        </observation>
                                    </entryRelationship>
                                    <entryRelationship typeCode="COMP">
                                        <observation classCode="OBS" moodCode="EVN">
                                            <templateId root="2.16.840.1.113883.10.20.27.3.4"/>
                                            <code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="Assertion"/>
                                            <statusCode code="completed"/>
                                            <value xsi:type="CD" nullFlavor="OTH">
                                                <originalText>Stratum</originalText>
                                            </value>
                                            <entryRelationship typeCode="SUBJ" inversionInd="true">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.3"/>
                                                    <code code="MSRAGG" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="rate aggregation"/>
                                                    <value xsi:type="INT" value="'.$recive_entry1[2][CqmReportEh][ipp_count].'"/>
                                                    <methodCode code="COUNT" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Count"/>
                                                </observation>
                                            </entryRelationship>
                                            <entryRelationship typeCode="COMP">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.2"/>
                                                    <code nullFlavor="OTH">
                                                        <originalText>Time Difference</originalText>
                                                    </code>
                                                    <statusCode code="completed"/>
                                                    <value xsi:type="PQ" value="'.$recive_entry1[2][CqmReportEh][measure_observation].'" unit="min"/>
                                                    <methodCode code="MEDIAN" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Median"/>
                                                    <reference typeCode="REFR">
                                                        <externalObservation classCode="OBS" moodCode="EVN">
                                                            <id root="b63f908e-5308-424e-948c-b28e5dc22613"/>
                                                        </externalObservation>
                                                    </reference>
                                                </observation>
                                            </entryRelationship>
                                            <reference typeCode="REFR">
                                                <externalObservation classCode="OBS" moodCode="EVN">
                                                    <id root="6145DA04-EF4F-46A9-8A13-AADDE550DDBC"/>
                                                </externalObservation>
                                            </reference>
                                        </observation>
                                    </entryRelationship>
                                    <entryRelationship typeCode="COMP">
                                        <observation classCode="OBS" moodCode="EVN">
                                            <templateId root="2.16.840.1.113883.10.20.27.3.4"/>
                                            <code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="Assertion"/>
                                            <statusCode code="completed"/>
                                            <value xsi:type="CD" nullFlavor="OTH">
                                                <originalText>Stratum</originalText>
                                            </value>
                                            <entryRelationship typeCode="SUBJ" inversionInd="true">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.3"/>
                                                    <code code="MSRAGG" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="rate aggregation"/>
                                                    <value xsi:type="INT" value="'.$recive_entry1[3][CqmReportEh][ipp_count].'"/>
                                                    <methodCode code="COUNT" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Count"/>
                                                </observation>
                                            </entryRelationship>
                                            <entryRelationship typeCode="COMP">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.2"/>
                                                    <code nullFlavor="OTH">
                                                        <originalText>Time Difference</originalText>
                                                    </code>
                                                    <statusCode code="completed"/>
                                                    <value xsi:type="PQ" value="'.$recive_entry1[3][CqmReportEh][measure_observation].'" unit="min"/>
                                                    <methodCode code="MEDIAN" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Median"/>
                                                    <reference typeCode="REFR">
                                                        <externalObservation classCode="OBS" moodCode="EVN">
                                                            <id root="b63f908e-5308-424e-948c-b28e5dc22613"/>
                                                        </externalObservation>
                                                    </reference>
                                                </observation>
                                            </entryRelationship>
                                            <reference typeCode="REFR">
                                                <externalObservation classCode="OBS" moodCode="EVN">
                                                    <id root="B00F05BD-0326-4298-BD7F-409B97931AFF"/>
                                                </externalObservation>
                                            </reference>
                                        </observation>
                                    </entryRelationship>
                                    <entryRelationship typeCode="COMP">
                                        <observation classCode="OBS" moodCode="EVN">
                                            <templateId root="2.16.840.1.113883.10.20.27.3.4"/>
                                            <code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="Assertion"/>
                                            <statusCode code="completed"/>
                                            <value xsi:type="CD" nullFlavor="OTH">
                                                <originalText>Stratum</originalText>
                                            </value>
                                            <entryRelationship typeCode="SUBJ" inversionInd="true">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.3"/>
                                                    <code code="MSRAGG" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="rate aggregation"/>
                                                    <value xsi:type="INT" value="'.$recive_entry1[4][CqmReportEh][ipp_count].'"/>
                                                    <methodCode code="COUNT" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Count"/>
                                                </observation>
                                            </entryRelationship>
                                            <entryRelationship typeCode="COMP">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.2"/>
                                                    <code nullFlavor="OTH">
                                                        <originalText>Time Difference</originalText>
                                                    </code>
                                                    <statusCode code="completed"/>
                                                    <value xsi:type="PQ" value="'.$recive_entry1[4][CqmReportEh][measure_observation].'" unit="min"/>
                                                    <methodCode code="MEDIAN" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Median"/>
                                                    <reference typeCode="REFR">
                                                        <externalObservation classCode="OBS" moodCode="EVN">
                                                            <id root="b63f908e-5308-424e-948c-b28e5dc22613"/>
                                                        </externalObservation>
                                                    </reference>
                                                </observation>
                                            </entryRelationship>
                                            <reference typeCode="REFR">
                                                <externalObservation classCode="OBS" moodCode="EVN">
                                                    <id root="E03F0D95-8AB5-4A88-9FE6-0560F6A0BEE0"/>
                                                </externalObservation>
                                            </reference>
                                        </observation>
                                    </entryRelationship>
                                    <entryRelationship typeCode="COMP">
                                        <observation classCode="OBS" moodCode="EVN">
                                            <templateId root="2.16.840.1.113883.10.20.27.3.2"/>
                                            <code nullFlavor="OTH">
                                                <originalText>Time Difference</originalText>
                                            </code>
                                            <statusCode code="completed"/>
                                            <value xsi:type="PQ" value="'.$recive_entry1[0][CqmReportEh][measure_observation].'" unit="min"/>
                                            <methodCode code="MEDIAN" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Median"/>
                                            <reference typeCode="REFR">
                                                <externalObservation classCode="OBS" moodCode="EVN">
                                                    <id root="b63f908e-5308-424e-948c-b28e5dc22613"/>
                                                </externalObservation>
                                            </reference>
                                        </observation>
                                    </entryRelationship>
                                    <entryRelationship typeCode="COMP">
                                        <observation classCode="OBS" moodCode="EVN">
                                            <templateId root="2.16.840.1.113883.10.20.24.3.55"/>
                                            <templateId root="2.16.840.1.113883.10.20.27.3.9"/>
                                            <id nullFlavor="NA"/>
                                            <code code="48768-6" codeSystem="2.16.840.1.113883.6.1" codeSystemName="SNOMED-CT" displayName="Payment source"/>
                                            <statusCode code="completed"/>
                                            <value xsi:type="CD" code="349" codeSystem="2.16.840.1.113883.3.221.5" codeSystemName="Source of Payment Topology" 

displayName="Other"/>
                                            <entryRelationship typeCode="SUBJ" inversionInd="true">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.3"/>
                                                    <code code="MSRAGG" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="rate aggregation"/>
                                                    <value xsi:type="INT" value="2"/>
                                                    <methodCode code="COUNT" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Count"/>
                                                </observation>
                                            </entryRelationship>
                                        </observation>
                                    </entryRelationship>
                                    <entryRelationship typeCode="COMP">
                                        <observation classCode="OBS" moodCode="EVN">
                                            <templateId root="2.16.840.1.113883.10.20.27.3.8"/>
                                            <code code="103579009" codeSystem="2.16.840.1.113883.6.96" codeSystemName="SNOMED-CT" displayName="Race"/>
                                            <statusCode code="completed"/>
                                            <value xsi:type="CD" code="1002-5" codeSystem="2.16.840.1.113883.6.238" codeSystemName="Race &amp; Ethnicity - CDC" 

displayName="American Indian or Alaska Native"/>
                                            <entryRelationship typeCode="SUBJ" inversionInd="true">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.3"/>
                                                    <code code="MSRAGG" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="rate aggregation"/>
                                                    <value xsi:type="INT" value="'.$recive_entry1[0][CqmReportEh][ipp_race].'"/>
                                                    <methodCode code="COUNT" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Count"/>
                                                </observation>
                                            </entryRelationship>
                                        </observation>
                                    </entryRelationship>
                                    <entryRelationship typeCode="COMP">
                                        <observation classCode="OBS" moodCode="EVN">
                                            <templateId root="2.16.840.1.113883.10.20.27.3.7"/>
                                            <code code="364699009" codeSystem="2.16.840.1.113883.6.96" codeSystemName="SNOMED-CT" displayName="Ethnic Group"/>
                                            <statusCode code="completed"/>
                                            <value xsi:type="CD" code="2186-5" codeSystem="2.16.840.1.113883.6.238" codeSystemName="Race &amp; Ethnicity - CDC" 

displayName="Not Hispanic or Latino"/>
                                            <entryRelationship typeCode="SUBJ" inversionInd="true">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.3"/>
                                                    <code code="MSRAGG" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="rate aggregation"/>
                                                    <value xsi:type="INT" value="'.$recive_entry1[0][CqmReportEh][ipp_eth].'"/>
                                                    <methodCode code="COUNT" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Count"/>
                                                </observation>
                                            </entryRelationship>
                                        </observation>
                                    </entryRelationship>
                                    <entryRelationship typeCode="COMP">
                                        <observation classCode="OBS" moodCode="EVN">
                                            <templateId root="2.16.840.1.113883.10.20.27.3.6"/>
                                            <code code="184100006" codeSystem="2.16.840.1.113883.6.96" codeSystemName="SNOMED-CT" displayName="patient sex"/>
                                            <statusCode code="completed"/>
                                            <value xsi:type="CD" code="M" codeSystem="2.16.840.1.113883.5.1" codeSystemName="AdministrativeGenderCode" displayName="Male"/>
                                            <entryRelationship typeCode="SUBJ" inversionInd="true">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.3"/>
                                                    <code code="MSRAGG" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="rate aggregation"/>
                                                    <value xsi:type="INT" value="'.$recive_entry1[0][CqmReportEh][ipp_male].'"/>
                                                    <methodCode code="COUNT" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Count"/>
                                                </observation>
                                            </entryRelationship>
                                        </observation>
                                    </entryRelationship>
                                    <reference typeCode="REFR">
                                        <externalObservation classCode="OBS" moodCode="EVN">
                                            <id root="8F80DBD0-0816-4E64-8E26-350FEDBA9AE8"/>
                                        </externalObservation>
                                    </reference>
                                </observation>
                            </component>
                            <component>
                                <observation classCode="OBS" moodCode="EVN">
                                    <templateId root="2.16.840.1.113883.10.20.27.3.5"/>
                                    <code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="Assertion"/>
                                    <statusCode code="completed"/>
                                    <value xsi:type="CD" code="MSRPOPL" codeSystem="2.16.840.1.113883.5.1063" codeSystemName="ObservationValue" displayName="Measure 

Population"/>
                                    <entryRelationship typeCode="SUBJ" inversionInd="true">
                                        <observation classCode="OBS" moodCode="EVN">
                                            <templateId root="2.16.840.1.113883.10.20.27.3.3"/>
                                            <code code="MSRAGG" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="rate aggregation"/>
                                            <value xsi:type="INT" value="2"/>
                                            <methodCode code="COUNT" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Count"/>
                                        </observation>
                                    </entryRelationship>
                                    <entryRelationship typeCode="COMP">
                                        <observation classCode="OBS" moodCode="EVN">
                                            <templateId root="2.16.840.1.113883.10.20.27.3.4"/>
                                            <code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="Assertion"/>
                                            <statusCode code="completed"/>
                                            <value xsi:type="CD" nullFlavor="OTH">
                                                <originalText>Stratum</originalText>
                                            </value>
                                            <entryRelationship typeCode="SUBJ" inversionInd="true">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.3"/>
                                                    <code code="MSRAGG" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="rate aggregation"/>
                                                    <value xsi:type="INT" value="2"/>
                                                    <methodCode code="COUNT" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Count"/>
                                                </observation>
                                            </entryRelationship>
                                            <entryRelationship typeCode="COMP">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.2"/>
                                                    <code nullFlavor="OTH">
                                                        <originalText>Time Difference</originalText>
                                                    </code>
                                                    <statusCode code="completed"/>
                                                    <value xsi:type="PQ" value="240.00" unit="min"/>
                                                    <methodCode code="MEDIAN" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Median"/>
                                                    <reference typeCode="REFR">
                                                        <externalObservation classCode="OBS" moodCode="EVN">
                                                            <id root="b63f908e-5308-424e-948c-b28e5dc22613"/>
                                                        </externalObservation>
                                                    </reference>
                                                </observation>
                                            </entryRelationship>
                                            <reference typeCode="REFR">
                                                <externalObservation classCode="OBS" moodCode="EVN">
                                                    <id root="A9240D7F-91BD-4A17-B6DA-6B72E0682EDD"/>
                                                </externalObservation>
                                            </reference>
                                        </observation>
                                    </entryRelationship>
                                    <entryRelationship typeCode="COMP">
                                        <observation classCode="OBS" moodCode="EVN">
                                            <templateId root="2.16.840.1.113883.10.20.27.3.4"/>
                                            <code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="Assertion"/>
                                            <statusCode code="completed"/>
                                            <value xsi:type="CD" nullFlavor="OTH">
                                                <originalText>Stratum</originalText>
                                            </value>
                                            <entryRelationship typeCode="SUBJ" inversionInd="true">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.3"/>
                                                    <code code="MSRAGG" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="rate aggregation"/>
                                                    <value xsi:type="INT" value="0"/>
                                                    <methodCode code="COUNT" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Count"/>
                                                </observation>
                                            </entryRelationship>
                                            <entryRelationship typeCode="COMP">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.2"/>
                                                    <code nullFlavor="OTH">
                                                        <originalText>Time Difference</originalText>
                                                    </code>
                                                    <statusCode code="completed"/>
                                                    <value xsi:type="PQ" value="0.00" unit="min"/>
                                                    <methodCode code="MEDIAN" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Median"/>
                                                    <reference typeCode="REFR">
                                                        <externalObservation classCode="OBS" moodCode="EVN">
                                                            <id root="b63f908e-5308-424e-948c-b28e5dc22613"/>
                                                        </externalObservation>
                                                    </reference>
                                                </observation>
                                            </entryRelationship>
                                            <reference typeCode="REFR">
                                                <externalObservation classCode="OBS" moodCode="EVN">
                                                    <id root="6145DA04-EF4F-46A9-8A13-AADDE550DDBC"/>
                                                </externalObservation>
                                            </reference>
                                        </observation>
                                    </entryRelationship>
                                    <entryRelationship typeCode="COMP">
                                        <observation classCode="OBS" moodCode="EVN">
                                            <templateId root="2.16.840.1.113883.10.20.27.3.4"/>
                                            <code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="Assertion"/>
                                            <statusCode code="completed"/>
                                            <value xsi:type="CD" nullFlavor="OTH">
                                                <originalText>Stratum</originalText>
                                            </value>
                                            <entryRelationship typeCode="SUBJ" inversionInd="true">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.3"/>
                                                    <code code="MSRAGG" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="rate aggregation"/>
                                                    <value xsi:type="INT" value="0"/>
                                                    <methodCode code="COUNT" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Count"/>
                                                </observation>
                                            </entryRelationship>
                                            <entryRelationship typeCode="COMP">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.2"/>
                                                    <code nullFlavor="OTH">
                                                        <originalText>Time Difference</originalText>
                                                    </code>
                                                    <statusCode code="completed"/>
                                                    <value xsi:type="PQ" value="0.00" unit="min"/>
                                                    <methodCode code="MEDIAN" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Median"/>
                                                    <reference typeCode="REFR">
                                                        <externalObservation classCode="OBS" moodCode="EVN">
                                                            <id root="b63f908e-5308-424e-948c-b28e5dc22613"/>
                                                        </externalObservation>
                                                    </reference>
                                                </observation>
                                            </entryRelationship>
                                            <reference typeCode="REFR">
                                                <externalObservation classCode="OBS" moodCode="EVN">
                                                    <id root="B00F05BD-0326-4298-BD7F-409B97931AFF"/>
                                                </externalObservation>
                                            </reference>
                                        </observation>
                                    </entryRelationship>
                                    <entryRelationship typeCode="COMP">
                                        <observation classCode="OBS" moodCode="EVN">
                                            <templateId root="2.16.840.1.113883.10.20.27.3.4"/>
                                            <code code="ASSERTION" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="Assertion"/>
                                            <statusCode code="completed"/>
                                            <value xsi:type="CD" nullFlavor="OTH">
                                                <originalText>Stratum</originalText>
                                            </value>
                                            <entryRelationship typeCode="SUBJ" inversionInd="true">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.3"/>
                                                    <code code="MSRAGG" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="rate aggregation"/>
                                                    <value xsi:type="INT" value="2"/>
                                                    <methodCode code="COUNT" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Count"/>
                                                </observation>
                                            </entryRelationship>
                                            <entryRelationship typeCode="COMP">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.2"/>
                                                    <code nullFlavor="OTH">
                                                        <originalText>Time Difference</originalText>
                                                    </code>
                                                    <statusCode code="completed"/>
                                                    <value xsi:type="PQ" value="240.00" unit="min"/>
                                                    <methodCode code="MEDIAN" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Median"/>
                                                    <reference typeCode="REFR">
                                                        <externalObservation classCode="OBS" moodCode="EVN">
                                                            <id root="b63f908e-5308-424e-948c-b28e5dc22613"/>
                                                        </externalObservation>
                                                    </reference>
                                                </observation>
                                            </entryRelationship>
                                            <reference typeCode="REFR">
                                                <externalObservation classCode="OBS" moodCode="EVN">
                                                    <id root="E03F0D95-8AB5-4A88-9FE6-0560F6A0BEE0"/>
                                                </externalObservation>
                                            </reference>
                                        </observation>
                                    </entryRelationship>
                                    <entryRelationship typeCode="COMP">
                                        <observation classCode="OBS" moodCode="EVN">
                                            <templateId root="2.16.840.1.113883.10.20.27.3.2"/>
                                            <code nullFlavor="OTH">
                                                <originalText>Time Difference</originalText>
                                            </code>
                                            <statusCode code="completed"/>
                                            <value xsi:type="PQ" value="240.00" unit="min"/>
                                            <methodCode code="MEDIAN" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Median"/>
                                            <reference typeCode="REFR">
                                                <externalObservation classCode="OBS" moodCode="EVN">
                                                    <id root="b63f908e-5308-424e-948c-b28e5dc22613"/>
                                                </externalObservation>
                                            </reference>
                                        </observation>
                                    </entryRelationship>
                                    <entryRelationship typeCode="COMP">
                                        <observation classCode="OBS" moodCode="EVN">
                                            <templateId root="2.16.840.1.113883.10.20.24.3.55"/>
                                            <templateId root="2.16.840.1.113883.10.20.27.3.9"/>
                                            <id nullFlavor="NA"/>
                                            <code code="48768-6" codeSystem="2.16.840.1.113883.6.1" codeSystemName="SNOMED-CT" displayName="Payment source"/>
                                            <statusCode code="completed"/>
                                            <value xsi:type="CD" code="349" codeSystem="2.16.840.1.113883.3.221.5" codeSystemName="Source of Payment Topology" 

displayName="Other"/>
                                            <entryRelationship typeCode="SUBJ" inversionInd="true">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.3"/>
                                                    <code code="MSRAGG" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="rate aggregation"/>
                                                    <value xsi:type="INT" value="2"/>
                                                    <methodCode code="COUNT" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Count"/>
                                                </observation>
                                            </entryRelationship>
                                        </observation>
                                    </entryRelationship>
                                    <entryRelationship typeCode="COMP">
                                        <observation classCode="OBS" moodCode="EVN">
                                            <templateId root="2.16.840.1.113883.10.20.27.3.8"/>
                                            <code code="103579009" codeSystem="2.16.840.1.113883.6.96" codeSystemName="SNOMED-CT" displayName="Race"/>
                                            <statusCode code="completed"/>
                                            <value xsi:type="CD" code="1002-5" codeSystem="2.16.840.1.113883.6.238" codeSystemName="Race &amp; Ethnicity - CDC" 

displayName="American Indian or Alaska Native"/>
                                            <entryRelationship typeCode="SUBJ" inversionInd="true">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.3"/>
                                                    <code code="MSRAGG" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="rate aggregation"/>
                                                    <value xsi:type="INT" value="'.$recive_entry1[0][CqmReportEh][ipp_race].'"/>
                                                    <methodCode code="COUNT" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Count"/>
                                                </observation>
                                            </entryRelationship>
                                        </observation>
                                    </entryRelationship>
                                    <entryRelationship typeCode="COMP">
                                        <observation classCode="OBS" moodCode="EVN">
                                            <templateId root="2.16.840.1.113883.10.20.27.3.7"/>
                                            <code code="364699009" codeSystem="2.16.840.1.113883.6.96" codeSystemName="SNOMED-CT" displayName="Ethnic Group"/>
                                            <statusCode code="completed"/>
                                            <value xsi:type="CD" code="2186-5" codeSystem="2.16.840.1.113883.6.238" codeSystemName="Race &amp; Ethnicity - CDC" 

displayName="Not Hispanic or Latino"/>
                                            <entryRelationship typeCode="SUBJ" inversionInd="true">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.3"/>
                                                    <code code="MSRAGG" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="rate aggregation"/>
                                                    <value xsi:type="INT" value="'.$recive_entry1[0][CqmReportEh][ipp_eth].'"/>
                                                    <methodCode code="COUNT" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Count"/>
                                                </observation>
                                            </entryRelationship>
                                        </observation>
                                    </entryRelationship>
                                    <entryRelationship typeCode="COMP">
                                        <observation classCode="OBS" moodCode="EVN">
                                            <templateId root="2.16.840.1.113883.10.20.27.3.6"/>
                                            <code code="184100006" codeSystem="2.16.840.1.113883.6.96" codeSystemName="SNOMED-CT" displayName="patient sex"/>
                                            <statusCode code="completed"/>
                                            <value xsi:type="CD" code="M" codeSystem="2.16.840.1.113883.5.1" codeSystemName="AdministrativeGenderCode" displayName="Male"/>
                                            <entryRelationship typeCode="SUBJ" inversionInd="true">
                                                <observation classCode="OBS" moodCode="EVN">
                                                    <templateId root="2.16.840.1.113883.10.20.27.3.3"/>
                                                    <code code="MSRAGG" codeSystem="2.16.840.1.113883.5.4" codeSystemName="ActCode" displayName="rate aggregation"/>
                                                    <value xsi:type="INT" value="'.$recive_entry1[0][CqmReportEh][ipp_male].'"/>
                                                    <methodCode code="COUNT" codeSystem="2.16.840.1.113883.5.84" codeSystemName="ObservationMethod" displayName="Count"/>
                                                </observation>
                                            </entryRelationship>
                                        </observation>
                                    </entryRelationship>
                                    <reference typeCode="REFR">
                                        <externalObservation classCode="OBS" moodCode="EVN">
                                            <id root="DC5D9773-531C-44B5-9583-8A3BA5975FD6"/>
                                        </externalObservation>
                                    </reference>
                                </observation>
                            </component>
                        </organizer>
                    </entry>';
		
		//debug($eh_measure.$eh_measure1);exit;
		return $eh_measure.$eh_measure1;
	}

	//==================================================================End of EH=============================================================================================================
	public function reportingParameters($s_date=null,$e_date=null){
		$strReporting.='<component>
				<section>
				<!-- QRDA Reporting Parameters Section template -->
				<templateId root="2.16.840.1.113883.10.20.17.2.1"/>
				<!-- QRDA Category III Reporting Parameters templateId -->
				<templateId root="2.16.840.1.113883.10.20.27.2.2"/>
				<code code="55187-9" codeSystem="2.16.840.1.113883.6.1"/>
				<title>Reporting Parameters</title>
				<text>
				<list>
				<item>Reporting period: '.$s_date.' '.to.' '.$e_date.'</item>
						</list>
						</text>
						<entry typeCode="DRIV">
						<act classCode="ACT" moodCode="EVN">
						<templateId root="2.16.840.1.113883.10.20.17.3.8"/>
						<id root="55a43e20-6463-46eb-81c3-9a3a1ad41225"/>
						<code code="252116004" codeSystem="2.16.840.1.113883.6.96"
						displayName="Observation Parameters"/>
						<!-- This reporting period shows that Good Health Clinic is sending data for the first quarter of the year.
						The referenced measure definition may be valid for the entire year or more-->
						<effectiveTime>
						<low value="20120101"/>
						<!-- The first day of the period reported. -->
						<high value="20120331"/>
						<!-- The last day of the period reported. -->
						</effectiveTime>
						</act>
						</entry>
						<entry>
						<encounter classCode="ENC" moodCode="EVN">
						<!-- Optional encounter dates in the reporting period -->
						<templateId root="2.16.840.1.113883.10.20.27.3.11"/>
						<!-- Optional id of the first encounter of the reporting period-->
						<id root="4fd7e43d-e21d-45b3-a0ed-fe122efb96a9"/>
						<effectiveTime>
						<!-- The month, day and year of the first service
						encounter of the reporting period (From date) -->
						<low value="20120105"/>
						</effectiveTime>
						</encounter>
						</entry>
						<entry>
						<encounter classCode="ENC" moodCode="EVN">
						<!-- Optional encounter dates in the reporting period -->
						<templateId root="2.16.840.1.113883.10.20.27.3.11"/>
						<!-- Optional id of the last encounter of the reporting period-->
						<id root="3e2b00b6-f846-4941-adb6-53eb88876a30"/>
						<effectiveTime>
						<!-- The month, day and year of the last service
						encounter of the reporting period (To date) -->
						<high value="20120324"/>
						</effectiveTime>
						</encounter>
						</entry>
						</section>
						</component>';
		return $strReporting;

	}
	public function measureSection($num=null,$deno=null,$f_name=null){
		debug($f_name);
		debug($num);
		debug($deno);
		//exit;
		$expl_deno=explode(',',$deno);

		$expl_num=explode(',',$num);

		if($f_name=='Controlling High Blood Presure'){
			$measure_id='0018';
		}
		if($f_name=='Use of Imageing studies for Low Back Pain'){
			$measure_id='0052';
		}
		if($f_name=='Documentation of current Medications in the Medical Record'){
			$measure_id='0419';
		}
		if($f_name=='Prevention Care and Screeing Tobacco Use Screening and Cessation Intervention'){
			$measure_id='0028';
			//debug($measure_id);
			//exit;
		}
		if($f_name=='Prevention Care and Screeing Screeningfor Clinical Depression and Follow-up Plan'){
			$measure_id='0418';
		}
		if($f_name=='Prevention Care and Screeing Body Mass Index Screening and Flow-UpA'){
			$measure_id='0421';
		}
		if($f_name=='Prevention Care and Screeing Body Mass Index Screening and Flow-UpB'){
			$measure_id='0421';
		}
		if($f_name=='Pregnant women that has HBsAg testing'){
			$measure_id='0608';
		}
		if($f_name=='Use of High-Risk Medications in the Elderly'){
			$measure_id='0022';
		}
		if($f_name=='Controlling High Blood Presure'){
			$measure_id='0421';
		}
		$strmeasure.='<component>
				<section>
				<!-- QRDA Measure Section template -->
				<templateId root="2.16.840.1.113883.10.20.24.2.2"/>
				<!-- QRDA Category III Measure Section template -->
				<templateId root="2.16.840.1.113883.10.20.27.2.1"/>
				<code code="55186-1" displayName="measure section"
				codeSystem="2.16.840.1.113883.6.1"/>
				<title>Measure Section</title>
				<text>
				<table border="1" width="100%">
				<thead>
				<tr>
				<th>eMeasure Title</th>
				<th>Version neutral identifier</th>
				<th>eMeasure Version Number</th>
				<th>NQF eMeasure Number</th>
				<th>eMeasure Identifier (MAT)</th>
				<th>Version specific identifier</th>
				</tr>
				</thead>
				<tbody>
				<tr>
				<td>'.$f_name.'</td>
						<td>03876d69-085b-415c-ae9d-9924171040c2</td>
						<td>1</td>
						<td>'.$measure_id.'</td>
								<td>71</td>
								<td>8a4d92b2-3887-5df3-0139-013b0c87524a</td>
								</tr>
								</tbody>
								</table>
								<content styleCode="Bold">Member of Measure Set: Clinical Quality Measure
								Set 2011-2012 - b6ac13e2-beb8-4e4f-94ed-fcc397406cd8</content>
								<list>
								<item style="list-style:none">
								</item>
								<item style="list-style:none"></item>
								<item style="list-style:none">
								<list>
									
								</list>
								</item>
								<item><content styleCode="Bold">Denominator</content>: '.$expl_deno[7].' <list>
										<item><content styleCode="Bold">Male</content>: '.$expl_deno[0].'</item>
												<item><content styleCode="Bold">Female</content>: '.$expl_deno[1].'</item>
														<item><content styleCode="Bold">Not Hispanic or
														Latino</content>: '.$expl_deno[6].'</item>
																<item><content styleCode="Bold">Hispanic or Latino</content>:
																'.$expl_deno[5].'</item>
																		<item><content styleCode="Bold">Black</content>: '.$expl_deno[3].'</item>
																				<item><content styleCode="Bold">White</content>: '.$expl_deno[2].'</item>
																						<item><content styleCode="Bold">Asian</content>: '.$expl_deno[4].'</item>
																									
																								</list>
																								</item>
																								<item><content styleCode="Bold">Numerator</content>: '.$expl_num[7].' <list>
																										<item><content styleCode="Bold">Male</content>: '.$expl_num[0].'</item>
																												<item><content styleCode="Bold">Female</content>: '.$expl_num[1].'</item>
																														<item><content styleCode="Bold">Not Hispanic or
																														Latino</content>: '.$expl_num[6].'</item>
																																<item><content styleCode="Bold">Hispanic or Latino</content>:
																																'.$expl_num[5].'</item>
																																		<item><content styleCode="Bold">Black</content>: '.$expl_num[3].'</item>
																																				<item><content styleCode="Bold">White</content>: '.$expl_num[2].'</item>
																																						<item><content styleCode="Bold">Asian</content>: '.$expl_num[4].'</item>
																																									
																																								</list>

																																								</item>
																																								<item><list>
																																									
																																								</list>
																																								</item>
																																								</list>';

		$strmeasure.='</text>';
		$proportionMeasureExample=$this->proportionMeasureExample(); // 1st
		$strmeasure .=  $proportionMeasureExample ;// 1st

		$strmeasure.='</section>
				</component>';
		return $strmeasure;

	}




	public function patientQrdaBody(){
		$patientQrdaHeader=$this->patientQrdaHeader();
		$strBody .='<component>
				<structuredBody>';
		$measureSection=$this->measureSectionPatient();
		$reportingParameters=$this->reportingParametersPatient ();
		$patientData=$this->patientData ();

		$strBody1 .='</structuredBody>';
		$strBody1 .='</component>';
		$strHeader.='</ClinicalDocument>';

		$body=$patientQrdaHeader.$strBody. $measureSection. $patientData.$strBody1.$strHeader;

		$ourFileName = "files/note_xml/".Qrda_patient.".xml";

		$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
		fwrite($ourFileHandle, $body);
		fclose($ourFileHandle);

	}
	public function patientData(){
		$patientData.='<component>
				<section>
				<!-- This is the templateId for Patient Data section -->
				<templateId root="2.16.840.1.113883.10.20.17.2.4"/>
				<!-- This is the templateId for Patient Data QDM section -->
				<templateId root="2.16.840.1.113883.10.20.24.2.1"/>
				<code code="55188-7" codeSystem="2.16.840.1.113883.6.1"/>
				<title>Patient Data</title>
				<text>





				</text>';
		$physicalExamFinding=$this->physicalExamFinding ();
		$encounterActivities=$this->encounterActivities ();
		$problemObservation=$this->problemObservation ();
		$patientCharacteristicPayer=$this->patientCharacteristicPayer ();

		$patientData .=  $physicalExamFinding ;
		$patientData .=  $encounterActivities ;
		$patientData .=  $problemObservation ;
		$patientData .=  $patientCharacteristicPayer ;

		$patientData.='</section>
				</component>';
		return $patientData;
	}
	public function patientCharacteristicPayer(){
		$patientCharacteristicPayer.=' <entry>
				<!-- Patient Characteristic Payer -->
				<observation classCode="OBS" moodCode="EVN">
				<templateId root="2.16.840.1.113883.10.20.24.3.55"/>
				<id root="1.3.6.1.4.1.115" extension="5204e371a64ecc6d06000257"/>
				<code code="48768-6" codeSystemName="LOINC" codeSystem="2.16.840.1.113883.6.1" displayName="Payment source"/>
				<statusCode code="completed"/>
				<value code="349" codeSystem="2.16.840.1.113883.3.221.5" xsi:type="CD" sdtc:valueSet="2.16.840.1.114222.4.11.3591"></value>
				</observation>
				</entry>';

		return $patientCharacteristicPayer;

	}





}
?>