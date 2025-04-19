<div id="printButton">
  <?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));?>
</div>
<body class="print_form"  onload="window.print();"> <!-- onload="window.print();window.close();" -->
<div class="ht5">&nbsp;</div>
<?php 
	echo $this->element('patient_header') ;
?>

<div class="clr ht5"></div>
	<table width="100%" cellpadding="5" cellspacing="0" border="1" id="displayIntrinsicRiskFactorId">
<tr>
<th colspan="8"><?php echo __('Intrinsic Risk Factors',true); ?></th>
</tr>
<tr>
<td valign="middle"><?php echo __('Antibiotic',true); ?></td>
<td valign="middle">
<?php 
     echo $getIntrinsic['IntrinsicRiskFactor']['antibiotic'];
 ?>
</td>
<td valign="middle"><?php echo __('Prophylaxis Therapy',true); ?> </td>
<td valign="middle">
<?php 
    echo $getIntrinsic['IntrinsicRiskFactor']['prophylaxis_therapy'];
?>
</td>
<td valign="middle" ><?php echo __('Diabetes',true); ?></td>
<td valign="middle">
<?php 
   echo $getIntrinsic['IntrinsicRiskFactor']['diabetes']; 
?>
</td>
<td valign="middle"><?php echo __('Alcoholism',true); ?></td>
<td valign="middle">
<?php 
      echo $getIntrinsic['IntrinsicRiskFactor']['alcoholism']; 
?>
</td>
</tr>

<tr>
<td valign="middle"><?php echo __('Smoking',true); ?> </td>
<td valign="middle">
<?php 
      echo $getIntrinsic['IntrinsicRiskFactor']['smoking']; 
?>
</td>
<td valign="middle"><?php echo __('Hypertension',true); ?> </td>
<td valign="middle">
 <?php
    echo $getIntrinsic['IntrinsicRiskFactor']['hypertension']; 
 ?>
</td>
<td valign="middle"><?php echo __('Anaemia',true); ?></td>
<td valign="middle">
<?php 
   echo $getIntrinsic['IntrinsicRiskFactor']['anaemia'];
?>
</td>
<td valign="middle"><?php echo __('Malignancy',true); ?> </td>
<td valign="middle">
<?php 
    echo $getIntrinsic['IntrinsicRiskFactor']['malignancy'];
?>
</td>
</tr>

<tr>
<td valign="middle"><?php echo __('Trauma',true); ?> </td>
<td valign="middle">
<?php 
     echo $getIntrinsic['IntrinsicRiskFactor']['trauma'];
?>
</td>
<td valign="middle"><?php echo __('Cirrhosis',true); ?> </td>
<td valign="middle">
<?php
      echo $getIntrinsic['IntrinsicRiskFactor']['cirrhosis']; 
?>
</td>
<td valign="middle"><?php echo __('Steroids',true); ?> </td>
<td valign="middle">
<?php
     echo $getIntrinsic['IntrinsicRiskFactor']['steroids'];
?>
</td>
<td valign="middle"><?php echo __('Immunosuppression',true); ?> </td>
<td valign="middle">
<?php 
      echo $getIntrinsic['IntrinsicRiskFactor']['immunosuppression'];
?>
</td>
</tr>
</table>

<div>&nbsp;</div>
<div class="clr ht5"></div>
<table width="100%" cellpadding="5" cellspacing="0" border="1" id="displayPatientExposureId">
<tr>
<th colspan="4"><?php echo __('Patient Exposure',true); ?></th>
</tr>
 
<tr>
<td width="250" ><?php echo __('Date',true); ?></td>
<?php 
    for($i=0; $i < count($dateArray); $i++) {
?>
	<td width="100" >
	<table width="100" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td width="75">
	<?php echo date("d/m/Y", strtotime($dateArray[$i])); ?></td>
	<td width="25" align="right">&nbsp;</td>
	</tr>
	</table>
        </td>
 <?php 
    } 
 ?>
</tr>

<?php 
     $patientExposure = array('Surgical procedure', 'Urinary catheter', 'Mechanical ventilation', 'Central Line', 'Peripheral Line');
     $patientExposureTableField = array('surgical_procedure', 'urinary_catheter', 'mechanical_ventilation', 'central_line', 'peripheral_line');
     foreach($getPatientExposure as $getPatientExposureVal) { 
	       $patientExpSubmitDate[] = $getPatientExposureVal['PatientExposure']['submit_date'];

		   $patientExpStoreWithDate['PatientExposure']['surgical_procedure'][$getPatientExposureVal['PatientExposure']['submit_date']] = $getPatientExposureVal['PatientExposure']['surgical_procedure'];

		   $patientExpStoreWithDate['PatientExposure']['urinary_catheter'][$getPatientExposureVal['PatientExposure']['submit_date']] = $getPatientExposureVal['PatientExposure']['urinary_catheter'];

		   $patientExpStoreWithDate['PatientExposure']['mechanical_ventilation'][$getPatientExposureVal['PatientExposure']['submit_date']] = $getPatientExposureVal['PatientExposure']['mechanical_ventilation'];

		   $patientExpStoreWithDate['PatientExposure']['central_line'][$getPatientExposureVal['PatientExposure']['submit_date']] = $getPatientExposureVal['PatientExposure']['central_line'];

		   $patientExpStoreWithDate['PatientExposure']['peripheral_line'][$getPatientExposureVal['PatientExposure']['submit_date']] = $getPatientExposureVal['PatientExposure']['peripheral_line'];
     }
	 
     for($i=0; $i<count($patientExposure); $i++) {
?>
     <tr>
      <td valign="middle"><?php echo $patientExposure[$i]; ?></td>
       <?php 
		
		for($j=0; $j < count($dateArray); $j++) {
		  if(in_array($dateArray[$j], $patientExpSubmitDate)) {
        ?>
	       <td width="100" >
	         <table width="100" border="0" cellspacing="0" cellpadding="0" >
	          <tr>
	           <td width="75">
                <?php echo $patientExpStoreWithDate['PatientExposure'][$patientExposureTableField[$i]][$dateArray[$j]]; ?>
	           </td>
	           <td width="25" align="right">&nbsp;</td>
	           </tr>
	          </table>
            </td>
       <?php  
	      } else {
	   ?>
	        <td width="100" >
	         <table width="100" border="0" cellspacing="0" cellpadding="0" >
	          <tr>
	           <td width="75">
                <?php 
				 if($dateArray[$j] > date("Y-m-d")) { 
	              // echo $this->Form->input('PatientExposure.'.$patientExposureTableField[$i].'.'.$dateArray[$j], array('options' => $options, 'id' => $patientExposureTableField[$i], 'label'=> false, 'div' => false, 'error' => false));
	             } else {
					//echo __('No Record Found');
				 }
				?>
	           </td>
	           <td width="25" align="right">&nbsp;</td>
	          </tr>
	         </table>
            </td>
	   <?php 
	      }
	   ?>
       <?php 
	      }
	   ?>
	   </tr>
	   <?php
	    }
	   ?>
	
</table>


<div>&nbsp;</div>
<div class="clr ht5"></div>

<table width="100%" cellpadding="5" cellspacing="0" border="1" id="displaySignSymptomId">

<tr>
<th colspan="4"><?php echo __('Signs and Symptoms',true); ?></th>
</tr>
 
<tr>
<td width="250" ><?php echo __('Date',true); ?></td>
<?php 
    for($i=0; $i < count($dateArray); $i++) {
?>
	<td width="100" >
	<table width="100" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td width="75">
	<?php echo date("d/m/Y", strtotime($dateArray[$i])); ?></td>
	<td width="25" align="right">&nbsp;</td>
	</tr>
	</table>
        </td>
 <?php 
    } 
 ?>
</tr>

<?php 
     $signSymptom = array('Fever', 'Chills', 'Local Pain', 'Swelling', 'Redness', 'Pus/Discharge', 'Urinary Frequency', 'Respiratory Secretion', 'Dysuria', 'Suprapubic Tenderness', 'Oliguria', 'Pyuria', 'Cough', 'Blood clot', 'Other');
     $signSymptomTableField = array('fever', 'chills', 'local_pain', 'swelling', 'redness', 'pus_discharge', 'urinary_frequency', 'respiratory_secretion', 'dysuria', 'suprapubic_tenderness', 'oliguria', 'pyuria', 'cough', 'blood_clot', 'other');

	 foreach($getSignSymptom as $getSignSymptomVal) { 
	       $signSymptomSubmitDate[] = $getSignSymptomVal['SignSymptom']['submit_date'];

		   $signSymptomWithDate['SignSymptom']['fever'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['fever'];
		   $signSymptomWithDate['SignSymptom']['chills'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['chills'];
		   $signSymptomWithDate['SignSymptom']['local_pain'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['local_pain'];
		   $signSymptomWithDate['SignSymptom']['swelling'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['swelling'];
		   $signSymptomWithDate['SignSymptom']['redness'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['redness'];
		   $signSymptomWithDate['SignSymptom']['pus_discharge'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['pus_discharge'];
		   $signSymptomWithDate['SignSymptom']['urinary_frequency'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['urinary_frequency'];
		   $signSymptomWithDate['SignSymptom']['respiratory_secretion'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['respiratory_secretion'];
		   $signSymptomWithDate['SignSymptom']['dysuria'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['dysuria'];
		   $signSymptomWithDate['SignSymptom']['suprapubic_tenderness'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['suprapubic_tenderness'];
		   $signSymptomWithDate['SignSymptom']['oliguria'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['oliguria'];
		   $signSymptomWithDate['SignSymptom']['pyuria'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['pyuria'];
		   $signSymptomWithDate['SignSymptom']['cough'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['cough'];
		   $signSymptomWithDate['SignSymptom']['blood_clot'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['blood_clot'];
		   $signSymptomWithDate['SignSymptom']['other'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['other'];

		   
     }

     for($i=0; $i<count($signSymptom); $i++) {
?>
     <tr>
      <td valign="middle"><?php echo $signSymptom[$i]; ?></td>
       <?php 
		
		for($j=0; $j < count($dateArray); $j++) {
		  if(in_array($dateArray[$j], $signSymptomSubmitDate)) {
        ?>
	       <td width="100" >
	         <table width="100" border="0" cellspacing="0" cellpadding="0" >
	          <tr>
	           <td width="75">
                <?php echo $signSymptomWithDate['SignSymptom'][$signSymptomTableField[$i]][$dateArray[$j]]; ?>
	           </td>
	           <td width="25" align="right">&nbsp;</td>
	           </tr>
	          </table>
            </td>
       <?php  
	      } else {
	   ?>
	        <td width="100" >
	         <table width="100" border="0" cellspacing="0" cellpadding="0" >
	          <tr>
	           <td width="75">
                <?php 
				 if($dateArray[$j] > date("Y-m-d")) { 
	               //echo $this->Form->input('SignSymptom.'.$signSymptomTableField[$i].'.'.$dateArray[$j], array('options' => $options, 'id' => $signSymptomTableField[$i], 'label'=> false, 'div' => false, 'error' => false));
	             } else {
					//echo __('No Record Found');
				 }
				?>
	           </td>
	           <td width="25" align="right">&nbsp;</td>
	          </tr>
	         </table>
            </td>
	   <?php 
	      }
	   ?>
       <?php 
	      }
	   ?>
	   </tr>
	   <?php
	    }
	   ?>
</table>



<div>&nbsp;</div>
<div class="clr ht5"></div>

<table width="100%" cellpadding="5" cellspacing="0" border="1"  id="displayNosocomialInfectionId">
<tr>
<th colspan="2"><?php echo __('Nosocomial Infection',true); ?></th>
</tr>
<tr>
<td valign="middle"><?php echo __('Surgical site infection',true); ?></td>
<td valign="middle" width="138">
<?php
      echo $getNosocomialInfections['NosocomialInfection']['surgical_site_infection'];
?>
</td>
</tr>
<tr>
<td valign="middle"><?php echo __('Urinary tract infection',true); ?></td>
<td valign="middle">
<?php 
        echo $getNosocomialInfections['NosocomialInfection']['urinary_tract_infection'];
?>
</td>
</tr>
<tr>
<td valign="middle"><?php echo __('Ventilator Associated
Pneumonia',true); ?></td>
<td valign="middle">
<?php 
      echo $getNosocomialInfections['NosocomialInfection']['ventilator_associated_pneumonia'];
?>
</td>
</tr>
<tr>
<td valign="middle"><?php echo __('CLABSI',true); ?></td>
<td valign="middle">
<?php 
       echo $getNosocomialInfections['NosocomialInfection']['clabsi'];
?>
</td>
</tr>
<tr>
<td valign="middle"><?php echo __('Thrombophlebitis',true); ?></td>
<td valign="middle">
<?php 
       echo $getNosocomialInfections['NosocomialInfection']['thrombophlebitis'];
?>
</td>
</tr>
<tr>
<td valign="middle"><?php echo __('Other Nosocomial Infection',true);
?></td>
<td valign="middle">
<?php  
        echo $getNosocomialInfections['NosocomialInfection']['other_nosocomial_infection'];
?>
</td>
</tr>
</table>



<div>&nbsp;</div>
<div class="clr ht5"></div>
<table width="100%" cellpadding="5" cellspacing="0" border="1"
 id="displayMicroOrganismId">
<tr>
<th colspan="2" ><?php echo __('Micro Organism',true); ?></th>
</tr>
<tr>
<td valign="middle"><?php echo __('MRSA',true); ?></td>
<td valign="middle" width="138">
<?php echo $getMicroOrganism['MicroOrganism']['mrsa']; ?>
</td>
</tr>
<tr>
<td valign="middle"><?php echo __('VRE',true); ?></td>
<td valign="middle">
<?php 
      echo $getMicroOrganism['MicroOrganism']['vre'];
?>
</td>
</tr>
</table>
<div>&nbsp;</div>
<div class="clr ht5"></div>
				   <div class="clr ht5"></div> 
</body>