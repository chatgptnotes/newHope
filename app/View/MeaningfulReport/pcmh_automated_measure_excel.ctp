<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT"); 
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"PCMH IT Checklist - ".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
header ("Content-Description: Generated Report" ); 
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');
ob_clean();
flush();



?>
<STYLE type="text/css">
	.tableTd {
	   	border-width: 0.5pt; 
		border: solid; 
	}
	.tableTdContent{
		border-width: 0.5pt; 
		border: solid;
	}
	#titles{
		font-weight: bolder;
	}
   
</STYLE>
   <div>&nbsp;</div>    
     <div class="clr ht5"></div>
    <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
          <tr>
           <th><?php echo __('Measures Name', true); ?></th>
	       <th style="text-align:center;"><?php echo __('Denominator', true); ?></th>
	       <th style="text-align:center;"> <?php echo __('Numerator', true); ?></th>
           <th style="text-align:center;"> <?php echo __('Ratio of N/D', true); ?></th>
          </tr>
	      <tr>
		    <td colspan="4"><b>Electronic Access</b></td>
		  </tr>
		  <tr>
		    <td>1. More than 50 percent of patients have online access to their health information within four business days of when the information is available to the practice.
		    </td>
			<td align="center"><?php if(!empty($accessVisitDenominatorVal)) echo $accessVisitDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($accessVisitNumeratorVal)) echo $accessVisitNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($accessVisitDenominatorVal) && !empty($accessVisitNumeratorVal)) {
              $accessVisitCalculation = round(($accessVisitNumeratorVal/$accessVisitDenominatorVal)*100);
               echo $this->Number->toPercentage($accessVisitCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td>2. Clinical summaries are provided within 1business day for more than 50 percent of office visit.</td>
			<td align="center"><?php if(!empty($clinicalsummaryDenominatorVal)) echo $clinicalsummaryDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($clinicalsummaryNumeratorVal)) echo $clinicalsummaryNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($clinicalsummaryDenominatorVal) && !empty($clinicalsummaryNumeratorVal)) {
              $clinicalsummaryCalculation = round(($clinicalsummaryNumeratorVal/$problemlistDenominatorVal)*100);
               echo $this->Number->toPercentage($clinicalsummaryCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td colspan="4"><b>Clinical Data</b></td>
		  </tr>
		  <tr>
		    <td>1. An up-to-date problem list with current and active diagnoses for more than 80 percent of patients.</td>
			<td align="center"><?php if(!empty($problemlistDenominatorVal)) echo $problemlistDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($problemlistNumeratorVal)) echo $problemlistNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($problemlistDenominatorVal) && !empty($problemlistNumeratorVal)) {
              $problemlistCalculation = round(($problemlistNumeratorVal/$problemlistDenominatorVal)*100);
               echo $this->Number->toPercentage($problemlistCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td>2. Allergies, including medication allergies and adverse reactions for more than 80 percent of patients</td>
			<td align="center"><?php if(!empty($medicationAllergyDenominatorVal)) echo $medicationAllergyDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationAllergyNumeratorVal)) echo $medicationAllergyNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($medicationAllergyDenominatorVal) && !empty($medicationAllergyNumeratorVal)) {
              $medicationAllergyCalculation = round(($medicationAllergyNumeratorVal/$medicationAllergyDenominatorVal)*100);
               echo $this->Number->toPercentage($medicationAllergyCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td>3. Blood pressure, with the date of update, for more than 80 percent of patients 3 years and older.</td>
			<td align="center"><?php if(!empty($bloodPressureDenominatorVal)) echo $bloodPressureDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($bloodPressureNumeratorVal)) echo $bloodPressureNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($bloodPressureDenominatorVal) && !empty($bloodPressureNumeratorVal)) {
              $bloodPressureCalculation = round(($bloodPressureNumeratorVal/$bloodPressureDenominatorVal)*100);
               echo $this->Number->toPercentage($bloodPressureCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td>4. Height/Length for more than 80 percent of patients.</td>
			<td align="center"><?php if(!empty($heightDenominatorVal)) echo $heightDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($heightNumeratorVal)) echo $heightNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($heightDenominatorVal) && !empty($heightNumeratorVal)) {
              $heightCalculation = round(($heightNumeratorVal/$heightDenominatorVal)*100);
               echo $this->Number->toPercentage($heightCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td>5. Weight for more than 80 percent of patients</td>
			<td align="center"><?php if(!empty($weightDenominatorVal)) echo $weightDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($weightNumeratorVal)) echo $weightNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($weightDenominatorVal) && !empty($weightNumeratorVal)) {
              $weightCalculation = round(($weightNumeratorVal/$weightDenominatorVal)*100);
               echo $this->Number->toPercentage($weightCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td>6. Status of tobacco use for patients 13 years and older for more than 80 percent of patients.</td>
			<td align="center"><?php if(!empty($smokingstatusDenominatorVal)) echo $smokingstatusDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($smokingstatusNumeratorVal)) echo $smokingstatusNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($smokingstatusDenominatorVal) && !empty($smokingstatusNumeratorVal)) {
              $smokingstatusCalculation = round(($smokingstatusNumeratorVal/$smokingstatusDenominatorVal)*100);
               echo $this->Number->toPercentage($smokingstatusCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td>7. List of prescription medications with date of updates for more than 80 percent of patients.</td>
			<td align="center"><?php if(!empty($medicationlistDenominatorVal)) echo $medicationlistDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationlistNumeratorVal)) echo $medicationlistNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($medicationlistDenominatorVal) && !empty($medicationlistNumeratorVal)) {
              $medicationlistCalculation = round(($medicationlistNumeratorVal/$medicationlistDenominatorVal)*100);
               echo $this->Number->toPercentage($medicationlistCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td>8. More than 20 percent of patients have family history recorded as structured data.</td>
			<td align="center"><?php if(!empty($familyhistoryDenominatorVal)) echo $familyhistoryDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($familyhistoryNumeratorVal)) echo $familyhistoryNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($familyhistoryDenominatorVal) && !empty($familyhistoryNumeratorVal)) {
              $familyhistoryCalculation = round(($familyhistoryNumeratorVal/$familyhistoryDenominatorVal)*100);
               echo $this->Number->toPercentage($familyhistoryCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td>9. At least one electronic progress note, created, edited and signed by an eligible professional for more than 30 percent of patients with at least one office visit.</td>
			<td align="center"><?php if(!empty($enotesDenominatorVal)) echo $enotesDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($enotesNumeratorVal)) echo $enotesNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($enotesDenominatorVal) && !empty($enotesNumeratorVal)) {
              $enotesCalculation = round(($enotesNumeratorVal/$enotesDenominatorVal)*100);
               echo $this->Number->toPercentage($enotesCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td>10. More than 30 percent of laboratory orders are electronically recorded in patient record.</td>
			<td align="center"><?php if(!empty($labresultsDenominatorVal)) echo $labresultsDenominatorVal ; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($labresultsNumeratorVal)) echo $labresultsNumeratorVal ; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($labresultsDenominatorVal) && !empty($labresultsNumeratorVal)) {
              $labresultsCalculation = round(($labresultsNumeratorVal/$labresultsDenominatorVal)*100);
               echo $this->Number->toPercentage($labresultsCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td>11. More than 30 percent of radiology orders are electronically recorded in patient record.</td>
			<td align="center"><?php if(!empty($cpoeRadDenominatorVal)) echo $cpoeRadDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($cpoeRadNumeratorVal)) echo $cpoeRadNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($cpoeRadDenominatorVal) && !empty($cpoeRadNumeratorVal)) {
              $radCalculation = round(($cpoeRadNumeratorVal/$cpoeRadDenominatorVal)*100);
               echo $this->Number->toPercentage($radCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td>12. More than 10 percent of scans and tests that result in an image are accessible electronically.</td>
			<td align="center"><?php if(!empty($imagingDenominatorVal)) echo $imagingDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($imagingNumeratorVal)) echo $imagingNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($imagingDenominatorVal) && !empty($imagingNumeratorVal)) {
              $imagingCalculation = round(($imagingNumeratorVal/$imagingDenominatorVal)*100);
               echo $this->Number->toPercentage($imagingCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td colspan="4"><b>Searchable Sturctured Data</b></td></tr>		    
		  <tr>
			  <td>1.EMR records 1-14 structured elements (searchable) data for more than 80% of its patients (Standard)</td>
			  <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $searchableDenominatorVal; else echo "0";  ?></td>
			  <td align="center"><?php if(!empty($searchableNumeratorVal)) echo $searchableNumeratorVal; else echo "0"; ?></td>
			  <td align="center">
				 <?php 
				 if(!empty($searchableDenominatorVal) && !empty($searchableNumeratorVal)) {
	              $searchable = round(($searchableNumeratorVal/$searchableDenominatorVal)*100);
	               echo $this->Number->toPercentage($searchable,0);
	             } else {
	               echo  "00%";
	             }
	             ?>
			  </td>
		  </tr>
		  <tr>
		    <td colspan="4"><b>Medication Management</b></td>
		  </tr>
		  <tr>
		    <td>1. EMR Logs when New Medication information is printed and given to Patient/Familieis/CareGiver.</td>
			<td align="center"><?php if(!empty($medicationDenominatorVal)) echo $medicationDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationPrintedNumeratorVal)) echo $medicationPrintedNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($medicationDenominatorVal) && !empty($medicationPrintedNumeratorVal)) {
              $medicationPrinted = round(($medicationPrintedNumeratorVal/$medicationDenominatorVal)*100);
               echo $this->Number->toPercentage($medicationPrinted,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  	  <tr>
		    <td>2. EMR Logs when Medication Information is Explained to the Patient considering their health literacy and date stamps assessment.</td>
			<td align="center"><?php if(!empty($medicationDenominatorVal)) echo $medicationDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationExplainedHealthNumeratorVal)) echo $medicationExplainedHealthNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($medicationDenominatorVal) && !empty($medicationExplainedHealthNumeratorVal)) {
              $medicationExplained = round(($medicationExplainedHealthNumeratorVal/$medicationDenominatorVal)*100);
               echo $this->Number->toPercentage($medicationExplained,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  	  <tr>
		    <td>3. EMR Logs when Patient has Difficulty in taking Medications as prescribed with Date Stamp.</td>
			<td align="center"><?php if(!empty($medicationDenominatorVal)) echo $medicationDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationDifficultyNumeratorVal)) echo $medicationDifficultyNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($medicationDenominatorVal) && !empty($medicationDifficultyNumeratorVal)) {
              $medicationHasdifficulty = round(($medicationDifficultyNumeratorVal/$medicationDenominatorVal)*100);
               echo $this->Number->toPercentage($medicationHasdifficulty,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  	  <tr>
		    <td>4. EMR Logs when Patient has Side Effects when taking Medications as prescribed with Date Stamp.</td>
			<td align="center"><?php if(!empty($medicationDenominatorVal)) echo $medicationDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationHassideeffectNumeratorVal)) echo $medicationHassideeffectNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($medicationDenominatorVal) && !empty($medicationHassideeffectNumeratorVal)) {
              $medicationHassideeffect = round(($medicationHassideeffectNumeratorVal/$medicationDenominatorVal)*100);
               echo $this->Number->toPercentage($medicationHassideeffect,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  	  <tr>
		    <td>5. EMR Logs whether Patient is taking Medications as prescribed with Date Stamp</td>
			<td align="center"><?php if(!empty($medicationDenominatorVal)) echo $medicationDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationMedicationPrescribedNumeratorVal)) echo $medicationMedicationPrescribedNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($medicationDenominatorVal) && !empty($medicationMedicationPrescribedNumeratorVal)) {
              $medicationAsprescribed = round(($medicationMedicationPrescribedNumeratorVal/$medicationDenominatorVal)*100);
               echo $this->Number->toPercentage($medicationAsprescribed,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  	  <tr>
		    <td>6. EMR Logs in Initial Assessment Section, all Supplements.</td>
			<td align="center"><?php if(!empty($medicationDenominatorVal)) echo $medicationDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationIssupplementNumeratorVal)) echo $medicationIssupplementNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($medicationDenominatorVal) && !empty($medicationIssupplementNumeratorVal)) {
              $medicationIssupplement = round(($medicationIssupplementNumeratorVal/$medicationDenominatorVal)*100);
               echo $this->Number->toPercentage($medicationIssupplement,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  
		  <tr>
		    <td>7. EMR Logs in Initial Assessment Section, all Herbal Therapies.</td>
			<td align="center"><?php if(!empty($medicationDenominatorVal)) echo $medicationDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationIsherbalNumeratorVal)) echo $medicationIsherbalNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($medicationDenominatorVal) && !empty($medicationIsherbalNumeratorVal)) {
              $medicationIsherbal = round(($medicationIsherbalNumeratorVal/$medicationDenominatorVal)*100);
               echo $this->Number->toPercentage($medicationIsherbal,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  
		  <tr>
		    <td>8. EMR Logs when Clinic Assesses the interactions of Medictions with OTC Medications, Supplements, and Herbal Therapies</td>
			<td align="center"><?php if(!empty($medicationDenominatorVal)) echo $medicationDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationReportedInteractionNumeratorVal)) echo $medicationReportedInteractionNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($medicationDenominatorVal) && !empty($medicationReportedInteractionNumeratorVal)) {
              $medicationInteraction = round(($medicationReportedInteractionNumeratorVal/$medicationDenominatorVal)*100);
               echo $this->Number->toPercentage($medicationInteraction,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  
		  <tr>
		    <td>9. EMR Adds a Structured Data Element on how Non-Formularies are Handeld by Physician</td>
			<td align="center"><?php if(!empty($medicationreconDenominatorVal)) echo $medicationreconDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationreconNumeratorVal)) echo $medicationreconNumeratorVal; else echo "0";  ?></td>
			<td align="center">
			 <?php 
			 if(!empty($medicationreconDenominatorVal) && !empty($medicationreconNumeratorVal)) {
              $medicationreconCalculation = round(($medicationreconNumeratorVal/$medicationreconDenominatorVal)*100);
               echo $this->Number->toPercentage($medicationreconCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  
		  <tr>
		    <td>10. Physician Assesses the Use of Non-Formularies and Changes Order if needed (Structured Data Element -- All are Formularies, Continued with Non-Formulary, Changed to Formulary)</td>
			<td align="center"><?php if(!empty($medicationreconDenominatorVal)) echo $medicationreconDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationreconNumeratorVal)) echo $medicationreconNumeratorVal; else echo "0";  ?></td>
			<td align="center">
			 <?php 
			 if(!empty($medicationreconDenominatorVal) && !empty($medicationreconNumeratorVal)) {
              $medicationreconCalculation = round(($medicationreconNumeratorVal/$medicationreconDenominatorVal)*100);
               echo $this->Number->toPercentage($medicationreconCalculation,0);
             } else {
               echo  "00%";
             }s
             ?>
			</td>
		  </tr>
		  
		  <tr>
		    <td>11. Clinic Generates Report Validating >50% of Patients have adequate understanding of Medications</td>
			<td align="center"><?php if(!empty($medicationDenominatorVal)) echo $medicationDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationExplainedHealthNumeratorVal)) echo $medicationExplainedHealthNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($medicationDenominatorVal) && !empty($medicationExplainedHealthNumeratorVal)) {
              $medicationExplained = round(($medicationExplainedHealthNumeratorVal/$medicationDenominatorVal)*100);
               echo $this->Number->toPercentage($medicationExplained,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td>12. Clinic Generates Report that >50% of Eligible Prescriptions are sent Electronically</td>
			<td align="center"><?php if(!empty($medicationDenominatorVal)) echo $medicationDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationEligibleSentNumeratorVal)) echo $medicationEligibleSentNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($medicationDenominatorVal) && !empty($medicationEligibleSentNumeratorVal)) {
              $medicationEligibleSent = round(($medicationEligibleSentNumeratorVal/$medicationDenominatorVal)*100);
               echo $this->Number->toPercentage($medicationEligibleSent,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  
		  <tr>
		    <td>13. Clinic has Assessed Interactions of Medications against OTC Medications, Supplemements, and Herbal Therapies is done for >50% Patients Annually</td>
			<td align="center"><?php if(!empty($medicationDenominatorVal)) echo $medicationDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationOtcAssesedInteractionNumeratorVal)) echo $medicationOtcAssesedInteractionNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($medicationDenominatorVal) && !empty($medicationOtcAssesedInteractionNumeratorVal)) {
              $medicationOtcAssesedInteraction = round(($medicationOtcAssesedInteractionNumeratorVal/$medicationDenominatorVal)*100);
               echo $this->Number->toPercentage($medicationOtcAssesedInteraction,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		   <tr>
		    <td>14. Clinic will Generate Abnormal Lab Test Results Report Daily or On Demand (CRITICAL)</td>
			<td align="center"><?php if(!empty($labDenominatorVal)) echo $labDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($labNumeratorVal)) echo $labNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($labDenominatorVal) && !empty($labNumeratorVal)) {
              $labResult = round(($labNumeratorVal/$labDenominatorVal)*100);
               echo $this->Number->toPercentage($labResult,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td>15. Clinic will Generate Over Due Lab Test Results Report Daily or On Demand (CRITICAL)</td>
			<td align="center"><?php if(!empty($overdueDenominatorVal)) echo $overdueDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($overdueNumeratorVal)) echo $overdueNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($overdueDenominatorVal) && !empty($overdueNumeratorVal)) {
              $overdueResult = round(($overdueNumeratorVal/$overdueDenominatorVal)*100);
               echo $this->Number->toPercentage($overdueResult,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td>16. Clinic will Generate Over Due Radiology Test Results Report Daily or On Demand (CRITICAL)</td>
			<td align="center"><?php if(!empty($overdueRadDenominatorVal)) echo $overdueRadDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($overdueRadNumeratorVal)) echo $overdueRadNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($overdueRadDenominatorVal) && !empty($overdueRadNumeratorVal)) {
              $overdueRadResult = round(($overdueRadNumeratorVal/$overdueRadDenominatorVal)*100);
               echo $this->Number->toPercentage($overdueRadResult,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td>17. Patient specific education report.</td>
			<td align="center"><?php if(!empty($specificeducationDemo['0']['0']['count'])) echo $specificeducationDemo['0']['0']['count']; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($specificeducationNum['0']['0']['count'])) echo $specificeducationNum['0']['0']['count']; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($specificeducationDemo['0']['0']['count']) && !empty($specificeducationNum['0']['0']['count'])) {
              $specificeducationResult = round(($specificeducationNum['0']['0']['count']/$specificeducationDemo['0']['0']['count'])*100);
               echo $this->Number->toPercentage($specificeducationResult,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  
		  <tr>
		    <td colspan="4"><b>CCDA</b></td>
		  </tr>
		  <tr>
		    <td>1.Transitions of Care that are Documented in EMRs with Electronic Discharge Summaries from Hospitals and Other Facilities </td>
		    <td align="center"><?php if(!empty($electronicDenominatorVal)) echo $electronicDenominatorVal; else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($electronicNumeratorVal)) echo $electronicNumeratorVal; else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($electronicDenominatorVal) && !empty($electronicNumeratorVal)) {
              $electronicCalculation = round(($electronicNumeratorVal/$electronicDenominatorVal)*100);
               echo $this->Number->toPercentage($electronicCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		    </tr>
		    <tr>
	    	<td>2. Patient Hospitalizations during which Clinic Exchanged Patient Information with Hospital </td>
	    	<td align="center"><?php if(!empty($patientInfoDenominatorVal)) echo $patientInfoDenominatorVal; else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($patientInfoNumeratorVal)) echo $patientInfoNumeratorVal; else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($patientInfoDenominatorVal) && !empty($patientInfoNumeratorVal)) {
              $patientInfoCalculation = round(($patientInfoNumeratorVal/$patientInfoDenominatorVal)*100);
               echo $this->Number->toPercentage($patientInfoCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		    </tr>
		     <tr>
		    <td>3.Clinic Generates a Report that >50% of Referrals to Specialists include Electronic Transmission of Summary of Care  </td>
		    <td align="center"><?php if(!empty($summaryDenominatorVal)) echo $summaryDenominatorVal; else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($summaryNumeratorVal)) echo $summaryNumeratorVal; else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($summaryDenominatorVal) && !empty($summaryNumeratorVal)) {
              $summaryCalculation = round(($summaryNumeratorVal/$summaryDenominatorVal)*100);
               echo $this->Number->toPercentage($summaryCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		    </tr>
		     <tr>
		    <td>4.View, download and transmit report -  Rate report  </td>
		    <td align="center"><?php if(!empty($ccdaArrivalsdenominatorVal)) echo $ccdaArrivalsdenominatorVal; else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($ccdaNumerator)) echo $ccdaNumerator; else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($ccdaArrivalsdenominatorVal) && !empty($ccdaNumerator)) {
              $ccdaCalculation = round(($ccdaNumerator/$ccdaArrivalsdenominatorVal)*100);
               echo $this->Number->toPercentage($ccdaCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		    </tr>
		    <tr>
		     <td colspan="4"><b>No Show Reports</b></td>
		     </tr>
		     <tr>
		    <td>1.<b><?php echo 'Percentage of No shows Report' ;?></b></td>
		    <td align="center"><?php if(!empty($noShowDenominatorVal)) echo $noShowDenominatorVal; else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($noShowNumeratorVal)) echo $noShowNumeratorVal; else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($noShowDenominatorVal) && !empty($noShowNumeratorVal)) {
              $noShowCalculation = round(($noShowNumeratorVal/$noShowDenominatorVal)*100);
               echo $this->Number->toPercentage($noShowCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		   <tr>
		    <td>2.<b><?php echo  'Percentage of Arrivals Report' ;?></b> </td>
		    <td align="center"><?php if(!empty($noShowDenominatorVal)) echo $noShowDenominatorVal; else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($arrivalsNumeratorVal)) echo $arrivalsNumeratorVal; else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($noShowDenominatorVal) && !empty($arrivalsNumeratorVal)) {
              $arrivalCalculation = round(($arrivalsNumeratorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($arrivalCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		    
		  
		  <tr>
		    <td colspan="4"><b>Searchable Data Elements</b></td>
		  </tr>
		  <tr>
		    <td>1.Over 80% of EMRs in a Clinic are searchable by 'Date of Birth' of Patient </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $searchableDenominatorVal; else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableDobNumeratorVal)) echo $searchableDobNumeratorVal; else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableDobNumeratorVal)) {
              $dobCalculation = round(($searchableDobNumeratorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($dobCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		  <tr>
		    <td>2.Over 80% of EMRs in a Clinic are searchable by 'Sex' of Patient' </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $searchableDenominatorVal; else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableSexNumeratorVal)) echo $searchableSexNumeratorVal; else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableSexNumeratorVal)) {
              $sexCalculation = round(($searchableSexNumeratorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($sexCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr> 
		  <tr>
		    <td>3.Over 80% of EMRs in a Clinic are searchable by 'Race' of Patient (include: 'Declined to specify') </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $searchableDenominatorVal; else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableRaceNumeratorVal)) echo $searchableRaceNumeratorVal; else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableRaceNumeratorVal)) {
              $raceCalculation = round(($searchableRaceNumeratorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($raceCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		  <tr>
		    <td>4.Over 80% of EMRs in a Clinic are searchable by 'Ethnicity' of Patient' (include: 'Declined to specify') </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $searchableDenominatorVal; else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableEthnicityNumeratorVal)) echo $searchableEthnicityNumeratorVal; else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableEthnicityNumeratorVal)) {
              $ethnicityCalculation = round(($searchableEthnicityNumeratorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($ethnicityCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		  <tr>
		    <td>5.Over 80% of EMRs in a Clinic are searchable by 'Preferred Language' of Patient' </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $searchableDenominatorVal; else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchablePreferredLanguageNumeratorVal)) echo $searchablePreferredLanguageNumeratorVal; else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchablePreferredLanguageNumeratorVal)) {
              $preferredLanguageCalculation = round(($searchablePreferredLanguageNumeratorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($preferredLanguageCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		  <tr>
		    <td>6.Over 80% of EMRs in a Clinic are searchable by 'Telephone' of Patient </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $searchableDenominatorVal; else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableTelePrimaryNumeratorVal)) echo $searchableTelePrimaryNumeratorVal; else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableTelePrimaryNumeratorVal)) {
              $telePrimaryCalculation = round(($searchableTelePrimaryNumeratorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($telePrimaryCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		  <tr>
		    <td>7.Over 80% of EMRs in a Clinic are searchable by 'Alternate Telephone' of Patient (mandatory; can be same as primary) </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $searchableDenominatorVal; else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableAlterTeleNumeratorVal)) echo $searchableAlterTeleNumeratorVal; else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableAlterTeleNumeratorVal)) {
              $alterTeleCalculation = round(($searchableAlterTeleNumeratorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($alterTeleCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		  <tr>
		    <td>8.Over 80% of EMRs in a Clinic are searchable by 'eMail' of Patient' </td>
		   <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $searchableDenominatorVal; else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableEmailNumeratorVal)) echo $searchableEmailNumeratorVal; else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableEmailNumeratorVal)) {
              $emailCalculation = round(($searchableEmailNumeratorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($emailCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		  <tr>
		    <td>9.Over 80% of EMRs in a Clinic are searchable by 'Occupation' of Patient' </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $searchableDenominatorVal; else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableOccupationNumeratorVal)) echo $searchableOccupationNumeratorVal; else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableOccupationNumeratorVal)) {
              $occupationCalculation = round(($searchableOccupationNumeratorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($occupationCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		  <tr>
		    <td>10.Over 80% of EMRs in a Clinic are searchable by 'Dates of Previous Clinical Visits' of Patient' </td>
		    <td align="center">0</td>
		    <td align="center">0</td>
		    <td align="center">0%</td>
		  </tr>
		  <tr>
		    <td>11.Over 80% of EMRs in a Clinic are searchable by 'Legal Guardian/Healthcare Proxy' of Patient' </td>
		    <td align="center">0</td>
		    <td align="center">0</td>
		    <td align="center">0%</td>
		  </tr>
		  <tr>
		    <td>12.Over 80% of EMRs in a Clinic are searchable by 'Primary Care Giver' of Patient' </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $searchableDenominatorVal; else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchablePrimaryCareGiverNumeratorVal)) echo $searchablePrimaryCareGiverNumeratorVal; else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchablePrimaryCareGiverNumeratorVal)) {
              $primaryCalculation = round(($searchablePrimaryCareGiverNumeratorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($primaryCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		  <tr>
		    <td>13.Over 80% of EMRs in a Clinic are searchable by 'Advanced Directives' of Patient' </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $searchableDenominatorVal; else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableAdvanceDirectiveNumeratorVal)) echo $searchableAdvanceDirectiveNumeratorVal; else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableAdvanceDirectiveNumeratorVal)) {
              $advanceDirectiveCalculation = round(($searchableAdvanceDirectiveNumeratorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($advanceDirectiveCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		  <tr>
		    <td>14.Over 80% of EMRs in a Clinic are searchable by 'Health Insurance Information' of Patient' </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $searchableDenominatorVal; else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableInsuranceInfoNumeratorVal)) echo $searchableInsuranceInfoNumeratorVal; else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableInsuranceInfoNumeratorVal)) {
              $insuranceInfoCalculation = round(($searchableInsuranceInfoNumeratorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($insuranceInfoCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		  <tr>
		    <td>15.Over 80% of EMRs in a Clinic are searchable by 'Name and Contact of Other Healthcare Professionals involved in care' of Patient':( list of patients seen by a physician) </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $searchableDenominatorVal; else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchablePhysicianNumeratorVal)) echo $searchablePhysicianNumeratorVal; else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchablePhysicianNumeratorVal)) {
              $physicianCalculation = round(($searchablePhysicianNumeratorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($physicianCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>		
		  <!--      
		  <tr>
		    <td colspan="4"><b><?php //echo $this->Html->link('List of Patient Communications with Physicians',array('controller'=>'MeaningfulReport','action'=>'patient_communication','admin'=>false));?></b></td>
		  </tr>
		  <tr>
		    <td colspan="4"><b><?php //echo $this->Html->link('Patient wise physician list',array('controller'=>'MeaningfulReport','action'=>'patient_wise_list','admin'=>false));?></b></td>
		  </tr>
		  <tr>
		    <td colspan="4"><b><?php //echo $this->Html->link('Physician wise patient list',array('controller'=>'MeaningfulReport','action'=>'physician_wise_list','admin'=>false));?></b></td>
		  </tr>
		  <tr>
		    <td colspan="4"><b><?php //echo $this->Html->link('Response time report',array('controller'=>'MeaningfulReport','action'=>'response_time_report','admin'=>false));?></b></td>
		  </tr>
		   -->
		 </table>
		 <br />
 <script>
	$(function() {
		$("#startdate").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat: 'mm/dd/yy',			
		});	

	});
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#automatedmeasurecalfrm").validationEngine();
		
 });
 
</script>