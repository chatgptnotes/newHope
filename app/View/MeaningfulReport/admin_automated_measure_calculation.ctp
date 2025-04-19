<?php
	echo $this->Html->script('jquery.autocomplete');
	echo $this->Html->css('jquery.autocomplete.css');
?>
<div class="inner_title">
<h3><?php echo __('Automated Measure Calculation', true); ?></h3>
</div>
<?php echo $this->Form->create(null,array('url' => array('action'=>'automated_measure_calculation'),'type'=>'post', 'id'=> 'automatedmeasurecalfrm'));?>	
<table border="0"   cellpadding="0" cellspacing="0" width="600px" align="left">
           <tr>				 
	    <td  align="right" style="font-size:13px;"><?php echo __('Stage Type') ?><font color="red">*</font>:</td>										
	    <td class="row_format">											 
		    	<?php 
		    		 echo    $this->Form->input(null, array('name' => 'stage_type','class' => 'validate[required,custom[mandatory-select]]',  'options' => array('Stage1' => 'Stage1', 'Stage2' => 'Stage2'), 'empty' => 'Select Stage', 'style' => 'width:300px;',  'id' => 'stage_type', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false, 'value' => $stage_type));
		    	?>
	    </td>
	  </tr>	
           <tr>				 
			<td  align="right" style="font-size:13px;"><?php echo __('Provider') ?> <font color="red">*</font>:</td>										
			<td class="row_format">											 
		    	<?php 
		    		 echo    $this->Form->input(null, array('name' => 'provider', 'class' => 'validate[required,custom[mandatory-select]]', 'options' => $doctorlist, 'empty' => 'Select Provider', 'style' => 'width:300px;',  'id' => 'provider', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false, 'value' => $provider));
		    	?>
		  	</td>
		 </tr>	
		  <tr>				 
			<td  align="right" style="font-size:13px;"><?php echo __('Report Type') ?> <font color="red">*</font>:</td>										
			<td class="row_format">											 
		    	<?php 
		    		 echo    $this->Form->input(null, array('name' => 'duration', 'class' => 'validate[required,custom[mandatory-select]]', 'options' => array('90' => '90 Days', '01-01_12-31' => 'Full Year', '01-01_03-31' => 'First Quarter', '04-01_06-30' => 'Second Quarter', '07-01_09-30' => 'Third Quarter', '10-01_12-31' => 'Fourth Quarter'), 'empty' => 'Select Duration', 'style' => 'width:300px;',  'id' => 'duration', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false, 'value' => $duration));
		    	?>
		  	</td>
		    </tr>
	       <tr id="showyear" style="<?php if($duration != "90" && $duration != "") echo "display:block important;";  else echo "display:none;"; ?>">				 
			<td  align="right" style="font-size:13px;"><?php echo __('Year') ?><font color="red">*</font>:</td>										
			<td class="row_format">											 
		    	<?php 
			         $currentYear = date("Y");
			         for($i=0;$i<=10;$i++) {
				    $lastTenYear[$currentYear] = $currentYear;
				    $currentYear--;
			         }
		    		 echo    $this->Form->input(null, array('name' => 'year', 'options' => $lastTenYear, 'empty' => 'Select Year', 'class' => 'validate[required,custom[mandatory-select]]',  'style' => 'width:300px;',  'id' => 'year', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false, 'value' => $year));
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
  

<?php $expDate=explode('/',$startdate);
//debug($expDate);
$startdate=$expDate[2].'-'.$expDate[0].'-'.$expDate[1];
if($ispost) { ?>
    <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
          <tr>
           <th><?php echo __('Measures Name', true); ?></th>
	       <th style="text-align:center;"><?php echo __('Denominator', true); ?></th>
	       <th style="text-align:center;"><?php echo __('Numerator', true); ?></th>
           <th style="text-align:center;"><?php echo __('Ratio of N/D', true); ?></th>
           <th style="text-align:center;"><?php echo __('Minimum', true); ?> %</th>
          </tr>
	  <?php if($stage_type != "Stage2") { ?> 
	  <tr>
		    <td><b>Problem List</b></td><?php ?>
			<td align="center"><?php if(!empty($problemlistDenominatorVal)) echo $this->Html->link($problemlistDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report' => 'problemlist', 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($problemlistNumeratorVal)) echo $this->Html->link($problemlistNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report' => 'problemlist', 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
		  <tr>
		    <td><b>Medication List</b></td>
			<td align="center"><?php if(!empty($medicationlistDenominatorVal)) echo $this->Html->link($medicationlistDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'medicationlist','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationlistNumeratorVal)) echo $this->Html->link($medicationlistNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report' => 'medicationlist', 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
		  
		  <tr>
		    <td><b>Medication Allergy List</b></td>
			<td align="center"><?php if(!empty($medicationAllergyDenominatorVal)) echo $this->Html->link($medicationAllergyDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'medicationAllergy','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationAllergyNumeratorVal)) echo $this->Html->link($medicationAllergyNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report' => 'medicationAllergy', 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
<?php } ?>
          <tr>
		    <td>
		    <b>Computerized provider order entry (CPOE) for medication orders</b>
		    </td>
			<td align="center"><?php if(!empty($cpoeMedicationDenominatorVal)) echo $this->Html->link($cpoeMedicationDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'cpoeMedication','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($cpoeMedicationNumeratorVal)) echo $this->Html->link($cpoeMedicationNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report' => 'cpoeMedication', 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
		  <tr>
		    <td>
		    <b>Computerized provider order entry (CPOE) for laboratory orders</b>
		    </td>
			<td align="center"><?php if(!empty($cpoeLabDenominatorVal)) echo $this->Html->link($cpoeLabDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'cpoeLab','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($cpoeLabNumeratorVal)) echo $this->Html->link($cpoeLabNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report'=>'cpoeLab','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
			<td align="center"><?php //print_r($cpoeLabNumeratorVal); ?>
			 <?php 
			 if(!empty($cpoeLabDenominatorVal) && !empty($cpoeLabNumeratorVal)) {
              $cpoeLabCalculation = round(($cpoeLabNumeratorVal/$cpoeLabDenominatorVal)*100);
               echo $this->Number->toPercentage($cpoeLabCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
		  <tr>
		    <td>
		    <b>Computerized provider order entry (CPOE) for radiology orders</b>
		    </td>
			<td align="center"><?php if(!empty($cpoeRadDenominatorVal)) echo $this->Html->link($cpoeRadDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'cpoeRad','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($cpoeRadNumeratorVal)) echo $this->Html->link($cpoeRadNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report'=>'cpoeRad','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
		  <?php if($stage_type == "Stage2") { ?>
		  <tr>
		    <td>
		    <b>Generate and transmit permissible prescriptions electronically (e-Rx)</b></td>
			<td align="center"><?php if(!empty($erxstage2DenominatorVal)) echo $this->Html->link($erxstage2DenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'erxstage2','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($erxstage2NumeratorVal)) echo $this->Html->link($erxstage2NumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report'=>'erxstage2','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($erxstage2DenominatorVal) && !empty($erxstage2NumeratorVal)) {
              $erxstage2Calculation = round(($erxstage2NumeratorVal/$erxstage2DenominatorVal)*100);
               echo $this->Number->toPercentage($erxstage2Calculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
		  <?php } ?>
		  <?php if($stage_type == "Stage1") { ?>
		  <tr>
		    <td>
		    <b>Generate and transmit permissible prescriptions electronically (e-Rx)</b></td>
			<td align="center"><?php if(!empty($erxstage1DenominatorVal)) echo $this->Html->link($erxstage1DenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'erxstage1','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($erxstage1NumeratorVal)) echo $this->Html->link($erxstage1NumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report'=>'erxstage1','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
			<td align="center">
			 <?php 
			 if(!empty($erxstage1DenominatorVal) && !empty($erxstage1NumeratorVal)) {
              $erxstage1Calculation = round(($erxstage1NumeratorVal/$erxstage1DenominatorVal)*100);
               echo $this->Number->toPercentage($erxstage1Calculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
		  <?php } ?>
		  <tr>
		    <td><b>Demographics</b></td>
			<td align="center"><?php if(!empty($demographicDenominatorVal)) echo $this->Html->link($demographicDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'demographic','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($demographicNumeratorVal)) echo $this->Html->link($demographicNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report'=>'demographic','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
		  <tr>
		    <td><b>Vital signs</b></td>
			<td align="center"><?php if(!empty($vitalsignDenominatorVal)) echo $this->Html->link($vitalsignDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'vitalsign','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($vitalsignNumeratorVal)) echo $this->Html->link($vitalsignNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report'=>'vitalsign','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
		  <tr>
		    <td><b>Smoking status</b></td>
			<td align="center"><?php if(!empty($smokingstatusDenominatorVal)) echo $this->Html->link($smokingstatusDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'smokingstatus','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($smokingstatusNumeratorVal)) echo $this->Html->link($smokingstatusNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report'=>'smokingstatus','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
		  <tr>
		    <td><b>Lab Results</b></td>
			<td align="center"><?php if(!empty($labresultsDenominatorVal)) echo $this->Html->link($labresultsDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'labresults','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($labresultsNumeratorVal)) echo $this->Html->link($labresultsNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report'=>'labresults','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
		  <tr>
		    <td><b>Patient Reminders</b></td>
			<td align="center"><?php if(!empty($patientreminderDenominatorVal)) echo $this->Html->link($patientreminderDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'patientreminder','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($patientreminderNumeratorVal)) echo $this->Html->link($patientreminderNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report'=>'patientreminder','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
		  <tr>
		    <td><b>View, Download, Transmit</b></td>
			<td align="center"><?php 
			if(!empty($viewdownloadDenominatorVal)) echo $this->Html->link($viewdownloadDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'viewdownload','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($viewdownloadNumeratorVal)) echo $this->Html->link($viewdownloadNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report'=>'viewdownload','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
		  <tr>
		    <td><b>Clinical Summary</b></td>
			<td align="center"><?php if(!empty($clinicalsummaryDenominatorVal)) echo $this->Html->link($clinicalsummaryDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'clinicalsummary','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($clinicalsummaryNumeratorVal)) echo $this->Html->link($clinicalsummaryNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report'=>'clinicalsummary','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
		  <tr>
		    <td><b>Patient Education</b></td>
			<td align="center"><?php if(!empty($patienteducationDenominatorVal)) echo $this->Html->link($patienteducationDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'patienteducation','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($patienteducationNumeratorVal)) echo $this->Html->link($patienteducationNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report'=>'patienteducation','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
		  <tr>
		    <td><b>Medical Reconcilation</b></td>
			<td align="center"><?php if(!empty($medicationreconDenominatorVal)) echo $this->Html->link($medicationreconDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'medicationrecon','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationreconNumeratorVal)) echo $this->Html->link($medicationreconNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report'=>'medicationrecon','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
<?php if($stage_type != "Stage1") { ?>
		  
		  <tr>
		    <td><b>Summary of Care</b></td>
			<td align="center"><?php if(!empty($summarycareDenominatorVal)) echo $this->Html->link($summarycareDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'summarycare','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($summarycareNumeratorVal)) echo $this->Html->link($summarycareNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report'=>'summarycare','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
		  <tr>
		    <td><b>Secure Messaging</b></td>
			<td align="center"><?php if(!empty($securemsgDenominatorVal)) echo $this->Html->link($securemsgDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'securemsg','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($securemsgNumeratorVal)) echo $this->Html->link($securemsgNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report'=>'securemsg','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
		  <tr>
		    <td><b>Imaging</b></td>
			<td align="center"><?php if(!empty($imagingDenominatorVal)) echo $this->Html->link($imagingDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'imaging','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($imagingNumeratorVal)) echo $this->Html->link($imagingNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report'=>'imaging','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
		  <tr>
		    <td><b>Family History</b></td>
			<td align="center"><?php if(!empty($familyhistoryDenominatorVal)) echo $this->Html->link($familyhistoryDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'familyhistory','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'familyhistory','admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($familyhistoryNumeratorVal)) echo $this->Html->link($familyhistoryNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report'=>'familyhistory','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
		  <tr>
		    <td><b>e-Notes</b></td>
			<td align="center"><?php if(!empty($enotesDenominatorVal)) echo $this->Html->link($enotesDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'enotes','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($enotesNumeratorVal)) echo $this->Html->link($enotesNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report'=>'enotes','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
		  <tr>
		    <td><b>Advance Directives</b></td>
			<td align="center"><?php if(!empty($advdirectiveDenominatorVal)) echo $this->Html->link($advdirectiveDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'advdirective','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'advdirective','admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($advdirectiveNumeratorVal)) echo $this->Html->link($advdirectiveNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report'=>'advdirective','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
         <tr>
		    <td><b>Lab EH to EP</b></td>
			<td align="center"><?php if(!empty($labehtoeaDenominatorVal)) echo $this->Html->link($labehtoeaDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'labehtoea','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($labehtoeaNumeratorVal)) echo $this->Html->link($labehtoeaNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report'=>'labehtoea','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
		  </tr>
		  <tr>
		    <td><b>e-MAR</b></td>
			<td align="center"><?php if(!empty($emarDenominatorVal)) echo $this->Html->link($emarDenominatorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_denominator_automated_measure','report'=>'emar','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($emarNumeratorVal)) echo $this->Html->link($emarNumeratorVal,array('controller'=>'MeaningfulReport','action'=>'minimum_numerator_automated_measure','report'=>'emar','sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'stage_type'=>$stage_type,'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0"; ?></td>
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
			<td><?php //Minimum % column
			echo " ";?></td>
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
			dateFormat: 'mm/dd/yy',			
		});	

	});
	
  
 jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#automatedmeasurecalfrm").validationEngine();
		
 });
 jQuery("#duration").change(function() {
	if(jQuery("#duration").val() == 90) {
	  jQuery("#showdate").show();
	  jQuery("#year").val("");
	  jQuery("#showyear").hide(); 
	} else {
	  jQuery("#showdate").hide();
	  jQuery("#startdate").val("");
	  jQuery("#showyear").show();
	}
}); 
</script>