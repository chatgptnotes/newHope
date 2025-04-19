<?php
	echo $this->Html->script('jquery.autocomplete');
	echo $this->Html->css('jquery.autocomplete.css');
?>
<div class="inner_title">
<h3><?php echo __('Automated Measure Calculation', true); ?></h3>
</div>
<?php echo $this->Form->create(null,array('url' => array('action'=>'hospital_automated_measure_calculation'),'type'=>'post', 'id'=> 'automatedmeasurecalfrm'));?>	
<table border="0"   cellpadding="0" cellspacing="0" width="600px" align="left">
           <tr>				 
	    <td  align="right"><?php echo __('Stage Type') ?><font color="red">*</font>:</td>										
	    <td class="row_format">											 
		    	<?php 
		    		 echo    $this->Form->input(null, array('name' => 'stage_type','class' => 'validate[required,custom[mandatory-select]]',  'options' => array('Stage1' => 'Stage1', 'Stage2' => 'Stage2'), 'empty' => 'Select Stage', 'style' => 'width:300px;',  'id' => 'stage_type', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false, 'value' => $stage_type));
		    	?>
	    </td>
	  </tr>	
           
		  <tr>				 
			<td  align="right"><?php echo __('Report Type') ?> <font color="red">*</font>:</td>										
			<td class="row_format">											 
		    	<?php 
		    		 echo    $this->Form->input(null, array('name' => 'duration', 'class' => 'validate[required,custom[mandatory-select]]', 'options' => array('90' => '90 Days', '10-01_09-30' => 'Full Year', '10-01_12-31' => 'First Quarter', '01-01_03-31' => 'Second Quarter', '04-01_06-30' => 'Third Quarter', '07-01_09-30' => 'Fourth Quarter'), 'empty' => 'Select Duration', 'style' => 'width:300px;',  'id' => 'duration', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false, 'value' => $duration));
		    	?>
		  	</td>
		    </tr>
	       <tr id="showyear" style="<?php if($duration != "90" && $duration != "") echo "display:block important;";  else echo "display:none;"; ?>">				 
			<td  align="right"><?php echo __('Year') ?>:</td>										
			<td class="row_format">											 
		    	<?php 
			         $currentYear = date("Y");
			         for($i=0;$i<=10;$i++) {
				      $lastTenYear[$currentYear] = $currentYear;
				      $currentYear--;
			         }
		    		 echo    $this->Form->input(null, array('name' => 'year', 'options' => $lastTenYear,  'style' => 'width:300px;',  'id' => 'year', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false, 'value' => $year));
		    	?>
		  	</td>
		    </tr>
	         <tr id="showdate" style="<?php if($duration == "90" && $duration != "") echo "display:block important;";  else echo "display:none;"; ?>">				 
			
			<td   align="right" ><?php echo __('Start Date') ?> <font color="red">*</font>:</td>										
			<td class="row_format">											 
		    <?php 
		    if($startdate) {
			 echo $this->Form->input(null, array('class' => 'validate[required,custom[dateSelect]]','name' => 'startdate', 'id' => 'startdate', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false, value => date("m/d/Y", strtotime($startdate))));
			} else {
                         echo $this->Form->input(null, array('class' => 'validate[required,custom[dateSelect]]','name' => 'startdate', 'id' => 'startdate', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false));
            }
			?>
		  	</td>
		    </tr>
             
		  <tr>				 
			<td class="row_format" align="left" colspan="2" style="padding-left:155px;">
				<?php
					echo $this->Form->submit(__('Show Report'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
				?>
			</td>
		 
		 </tr>	
		
</table>	
 <?php echo $this->Form->end();?>
   <div>&nbsp;</div>    
     <div class="clr ht5"></div>
       <div style="float: right;border:none;" class="inner_title">
   <?php  
                //echo $this->Form->create('MeaningfulReport',array('action'=>'print_automated_measure_calculation','type'=>'post', 'id'=> 'aumotmatedmeasurecal', 'style'=> 'float:left;'));
		        //echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'from', 'value' => $from));
		        //echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'to', 'value' => $to));
		        //echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'provider', 'value' => $provider));
                //echo $this->Form->submit(__('Print'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
		        // echo $this->Form->end();
   ?>
  
  </div> 
  

<?php if($ispost) { ?>
    <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
          <tr>
           <th><?php echo __('Measures Name', true); ?></th>
	       <th style="text-align:center;"><?php echo __('Denominator', true); ?></th>
	       <th style="text-align:center;"> <?php echo __('Numerator', true); ?></th>
           <th style="text-align:center;"> <?php echo __('Ratio of N/D', true); ?></th>
          </tr>
	  <?php if($stage_type != "Stage2") { ?>
	  <tr>
		    <td><b>Problem List</b></td>
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
		    <td><b>Medication List</b></td>
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
		    <td><b>Medication Allergy List</b></td>
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
<?php } ?>
          <tr>
		    <td>
		    <b>Computerized provider order entry (CPOE) for medication orders</b>
		    </td>
			<td align="center"><?php if(!empty($cpoeMedicationDenominatorVal)) echo $cpoeMedicationDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($cpoeMedicationNumeratorVal)) echo $cpoeMedicationNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($cpoeMedicationDenominatorVal) && !empty($cpoeMedicationNumeratorVal)) {
              $cpoeMedicationCalculation = round(($cpoeMedicationNumeratorVal/$cpoeMedicationDenominatorVal)*100);
               echo $this->Number->toPercentage($cpoeMedicationCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td>
		    <b>Computerized provider order entry (CPOE) for laboratory orders</b>
		    </td>
			<td align="center"><?php if(!empty($cpoeLabDenominatorVal)) echo $cpoeLabDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($cpoeLabNumeratorVal)) echo $cpoeLabNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($cpoeLabDenominatorVal) && !empty($cpoeLabNumeratorVal)) {
              $cpoeLabCalculation = round(($cpoeLabNumeratorVal/$cpoeLabDenominatorVal)*100);
               echo $this->Number->toPercentage($cpoeLabCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td>
		    <b>Computerized provider order entry (CPOE) for radiology orders</b>
		    </td>
			<td align="center"><?php if(!empty($cpoeRadDenominatorVal)) echo $cpoeRadDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($cpoeRadNumeratorVal)) echo $cpoeRadNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($cpoeRadDenominatorVal) && !empty($cpoeRadNumeratorVal)) {
              $cpoeRadCalculation = round(($cpoeRadNumeratorVal/$cpoeRadDenominatorVal)*100);
               echo $this->Number->toPercentage($cpoeRadCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		   <tr>
		    <td>
		    <b>Generate and transmit permissible prescriptions electronically (e-Rx)</b></td>
			<td align="center"><?php if(!empty($erxDenominatorVal)) echo $erxDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($erxNumeratorVal)) echo $erxNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($erxDenominatorVal) && !empty($erxNumeratorVal)) {
              $erxCalculation = round(($erxNumeratorVal/$erxDenominatorVal)*100);
               echo $this->Number->toPercentage($erxCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td><b>Demographics</b></td>
			<td align="center"><?php if(!empty($demographicDenominatorVal)) echo $demographicDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($demographicNumeratorVal)) echo $demographicNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($demographicDenominatorVal) && !empty($demographicNumeratorVal)) {
              $demographicCalculation = round(($demographicNumeratorVal/$demographicDenominatorVal)*100);
               echo $this->Number->toPercentage($demographicCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td><b>Vital signs</b></td>
			<td align="center"><?php if(!empty($vitalsignDenominatorVal)) echo $vitalsignDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($vitalsignNumeratorVal)) echo $vitalsignNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($vitalsignDenominatorVal) && !empty($vitalsignDenominatorVal)) {
              $vitalCalculation = round(($vitalsignNumeratorVal/$vitalsignDenominatorVal)*100);
               echo $this->Number->toPercentage($vitalCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td><b>Smoking status</b></td>
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
		    <td><b>Lab Results</b></td>
			<td align="center"><?php if(!empty($labresultsDenominatorVal)) echo $labresultsDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($labresultsNumeratorVal)) echo $labresultsNumeratorVal; else echo "0"; ?></td>
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
		    <td><b>Patient Reminders</b></td>
			<td align="center"><?php if(!empty($patientreminderDenominatorVal)) echo $patientreminderDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($patientreminderNumeratorVal)) echo $patientreminderNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($patientreminderDenominatorVal) && !empty($patientreminderNumeratorVal)) {
              $patientreminderCalculation = round(($patientreminderNumeratorVal/$patientreminderDenominatorVal)*100);
               echo $this->Number->toPercentage($patientreminderCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td><b>View, Download, Transmit</b></td>
			<td align="center"><?php if(!empty($viewdownloadDenominatorVal)) echo $viewdownloadDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($viewdownloadNumeratorVal)) echo $viewdownloadNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($viewdownloadDenominatorVal) && !empty($viewdownloadNumeratorVal)) {
              $viewdownloadCalculation = round(($viewdownloadNumeratorVal/$viewdownloadDenominatorVal)*100);
               echo $this->Number->toPercentage($viewdownloadCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td><b>Clinical Summary</b></td>
			<td align="center"><?php if(!empty($clinicalsummaryDenominatorVal)) echo $clinicalsummaryDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($clinicalsummaryNumeratorVal)) echo $clinicalsummaryNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($clinicalsummaryDenominatorVal) && !empty($clinicalsummaryNumeratorVal)) {
              $clinicalsummaryCalculation = round(($clinicalsummaryNumeratorVal/$clinicalsummaryDenominatorVal)*100);
               echo $this->Number->toPercentage($clinicalsummaryCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td><b>Patient Education</b></td>
			<td align="center"><?php if(!empty($patienteducationDenominatorVal)) echo $patienteducationDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($patienteducationNumeratorVal)) echo $patienteducationNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($patienteducationDenominatorVal) && !empty($patienteducationNumeratorVal)) {
              $patienteducationCalculation = round(($patienteducationNumeratorVal/$patienteducationDenominatorVal)*100);
               echo $this->Number->toPercentage($patienteducationCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td><b>Medical Reconcilation</b></td>
			<td align="center"><?php if(!empty($medicationreconDenominatorVal)) echo $medicationreconDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationreconNumeratorVal)) echo $medicationreconNumeratorVal; else echo "0"; ?></td>
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
<?php if($stage_type != "Stage1") { ?>
		  
		  <tr>
		    <td><b>Summary of Care</b></td>
			<td align="center"><?php if(!empty($summarycareDenominatorVal)) echo $summarycareDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($summarycareNumeratorVal)) echo $summarycareNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($summarycareDenominatorVal) && !empty($summarycareNumeratorVal)) {
              $summarycareCalculation = round(($summarycareNumeratorVal/$summarycareDenominatorVal)*100);
               echo $this->Number->toPercentage($summarycareCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td><b>Secure Messaging</b></td>
			<td align="center"><?php if(!empty($securemsgDenominatorVal)) echo $securemsgDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($securemsgNumeratorVal)) echo $securemsgNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($securemsgDenominatorVal) && !empty($securemsgNumeratorVal)) {
              $securemsgCalculation = round(($securemsgNumeratorVal/$securemsgDenominatorVal)*100);
               echo $this->Number->toPercentage($securemsgCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td><b>Imaging</b></td>
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
		    <td><b>Family History</b></td>
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
		    <td><b>e-Notes</b></td>
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
		    <td><b>Advance Directives</b></td>
			<td align="center"><?php if(!empty($advdirectiveDenominatorVal)) echo $advdirectiveDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($advdirectiveNumeratorVal)) echo $advdirectiveNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($advdirectiveDenominatorVal) && !empty($advdirectiveNumeratorVal)) {
              $advdirectiveCalculation = round(($advdirectiveNumeratorVal/$advdirectiveDenominatorVal)*100);
               echo $this->Number->toPercentage($advdirectiveCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
         <tr>
		    <td><b>Lab EH to EP</b></td>
			<td align="center"><?php if(!empty($labehtoeaDenominatorVal)) echo $labehtoeaDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($labehtoeaNumeratorVal)) echo $labehtoeaNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($labehtoeaDenominatorVal) && !empty($labehtoeaNumeratorVal)) {
              $labehtoeaCalculation = round(($labehtoeaNumeratorVal/$labehtoeaDenominatorVal)*100);
               echo $this->Number->toPercentage($labehtoeaCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td><b>e-MAR</b></td>
			<td align="center"><?php if(!empty($emarDenominatorVal)) echo $emarDenominatorVal; else echo "0";  ?></td>
			<td align="center"><?php if(!empty($emarNumeratorVal)) echo $emarNumeratorVal; else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($emarDenominatorVal) && !empty($emarNumeratorVal)) {
              $emarCalculation = round(($emarNumeratorVal/$emarDenominatorVal)*100);
               echo $this->Number->toPercentage($emarCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
<?php } ?>		  
		 </table>
<?php } ?>
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
			dateFormat:'<?php echo $this->General->GeneralDate();?>',			
		});	

	});
	
  
 jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#automatedmeasurecalfrm").validationEngine();
		
 });
 jQuery("#duration").change(function() {
	if(jQuery("#duration").val() == 90) {
	  jQuery("#showdate").show();
	  jQuery("#showyear").hide();
	} else {
	  jQuery("#showdate").hide();
	  jQuery("#showyear").show();
	}
});
</script>