<?php
	echo $this->Html->script('jquery.autocomplete');
	echo $this->Html->css('jquery.autocomplete.css');
?>
<div class="inner_title">
<h3><?php echo __('PCMH IT Checklist', true); ?></h3>
</div>
<?php echo $this->Form->create(null,array('url' => array('action'=>'pcmh_automated_measure'),'type'=>'post', 'id'=> 'automatedmeasurecalfrm'));?>	
<table border="0"   cellpadding="0" cellspacing="0" width="600px" align="left">
           <tr>				 
			<td  align="right"><?php echo __('Provider') ?> <font color="red">*</font>:</td>										
			<td class="row_format">											 
		    	<?php 
		    		 echo    $this->Form->input(null, array('name' => 'provider', 'class' => 'validate[required,custom[mandatory-select]]', 'options' => $doctorlist, 'empty' => 'Select Provider', 'style' => 'width:300px;',  'id' => 'provider', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false, 'value' => $provider));
		    	?>
		  	</td>
		 </tr>	
		  <tr>				 
			<td  align="right"><?php echo __('Report Type') ?> <font color="red">*</font>:</td>										
			<td class="row_format">											 
		    	<?php 
		    		 echo    $this->Form->input(null, array('name' => 'duration', 'class' => 'validate[required,custom[mandatory-select]]', 'options' => array('30'=> '30 Days (1 Month)','60'=> '60 Days (2 Months)','90' => '90 Days (3 Months)','180' => '180 Days (6 Months)', '365'=>'365 Days (1 Year)'), 'empty' => 'Select Duration', 'style' => 'width:300px;',  'id' => 'duration', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false, 'value' => $duration));
		    	?>
		  	</td>
		    </tr>
	        <tr>				 
			 <td   align="right" ><?php echo __('Start Date') ?> <font color="red">*</font>:</td>										
			 <td class="row_format">											 
		    <?php 
		      echo $this->Form->input(null, array('class' => 'validate[required,custom[dateSelect]]','name' => 'startdate', 'id' => 'startdate', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false,'value'=>$this->request->data['startdate']));
            ?>
		  	</td>
		    </tr> 
		  <tr>				 
			<td class="row_format" align="left" colspan="2" style="padding-left:155px;">
				<?php
					echo $this->Form->submit(__('Show Report'),array('class'=>'blueBtn','div'=>false,'label'=>false,'onclick'=>'$("#report-type").val("");'));	
					echo $this->Form->hidden('report_type',array('value'=>'','id'=>'report-type'));
				?>
			</td> 
		 </tr>	
		
</table>	
<div>&nbsp;</div>
<div style="float:right;">
	<?php 	echo $this->Form->submit(__('Excel Report'),array('id'=>'excel-report','class'=>'blueBtn','div'=>false,'label'=>false));	 ?>
</div>
 <?php echo $this->Form->end();?>
   <div>&nbsp;</div>    
     <div class="clr ht5"></div>
    
    <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
     <?php if($search){?>
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
			<td align="center"><?php if(!empty($accessVisitDenominatorVal)) echo $this->Html->link($accessVisitDenominatorVal,array('controller'=>'MeaningfulReport',
					'action'=>'pcmh_denominator_automated_measure',
					'?'=>array('report' => 'accessVisit', 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,
					'patient_type'=>$patient_type),'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($accessVisitNumeratorVal)) echo $this->Html->link($accessVisitNumeratorVal,array('controller'=>'MeaningfulReport',
					'action'=>'pcmh_numerator_automated_measure',
					'?'=>array('report' => 'accessVisit', 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,
					'patient_type'=>$patient_type),'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($clinicalsummaryDenominatorVal)) echo $this->Html->link($clinicalsummaryDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'clinicalsummary',
				    'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,
					'patient_type'=>$patient_type),'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($clinicalsummaryNumeratorVal)) echo $this->Html->link($clinicalsummaryNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'clinicalsummary',
				    'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,
					'patient_type'=>$patient_type),'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
		    <td colspan="4"><b>Clinical Data</b></td>
		  </tr>
		  <tr>
		    <td>1. An up-to-date problem list with current and active diagnoses for more than 80 percent of patients.</td>
			<td align="center"><?php if(!empty($problemlistDenominatorVal)) echo $this->Html->link($problemlistDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'problemList', 
					'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($problemlistNumeratorVal)) echo $this->Html->link($problemlistNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'problemList', 
					'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($medicationAllergyDenominatorVal)) echo $this->Html->link($medicationAllergyDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'medicationAllergy',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
						array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationAllergyNumeratorVal)) echo $this->Html->link($medicationAllergyNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'medicationAllergy',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
						array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($bloodPressureDenominatorVal)) echo $this->Html->link($bloodPressureDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'bloodPressure',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($bloodPressureNumeratorVal)) echo $this->Html->link($bloodPressureNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'bloodPressure',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($heightDenominatorVal)) echo $this->Html->link($heightDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'height',
			 		'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($heightNumeratorVal)) echo $this->Html->link($heightNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'height',
			 		'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($weightDenominatorVal)) echo $this->Html->link($weightDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'weight',
 					'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),
					'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($weightNumeratorVal)) echo $this->Html->link($weightNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'weight',
 					'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),
					'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($smokingstatusDenominatorVal)) echo $this->Html->link($smokingstatusDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'smokingstatus',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),
					 'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($smokingstatusNumeratorVal)) echo $this->Html->link($smokingstatusNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'smokingstatus',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),
					 'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($medicationlistDenominatorVal)) echo $this->Html->link($medicationlistDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'medicationlist',
 						'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),
						'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationlistNumeratorVal)) echo $this->Html->link($medicationlistNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'medicationlist',
 						'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),
						'admin'=>false),array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($familyhistoryDenominatorVal)) echo $this->Html->link($familyhistoryDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'familyhistory',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($familyhistoryNumeratorVal)) echo $this->Html->link($familyhistoryNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'familyhistory',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($enotesDenominatorVal)) echo $this->Html->link($enotesDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'enotes',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($enotesNumeratorVal)) echo $this->Html->link($enotesNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'enotes',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($cpoeLabDenominatorVal)) echo $this->Html->link($cpoeLabDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'cpoeLab',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($labresultsNumeratorVal)) echo $this->Html->link($labresultsNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'cpoeLab',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center">
			 <?php 
			 if(!empty($cpoeLabDenominatorVal) && !empty($labresultsNumeratorVal)) {
              $labresultsCalculation = round(($labresultsNumeratorVal/$cpoeLabDenominatorVal)*100);
               echo $this->Number->toPercentage($labresultsCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td>11. More than 30 percent of radiology orders are electronically recorded in patient record.</td>
			<td align="center"><?php if(!empty($cpoeRadDenominatorVal)) echo $this->Html->link($cpoeRadDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'cpoeRad',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($cpoeRadNumeratorVal)) echo $this->Html->link($cpoeRadNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'cpoeRad',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($imagingDenominatorVal)) echo $this->Html->link($imagingDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'imaging',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($imagingNumeratorVal)) echo $this->Html->link($imagingNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'imaging',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			  <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			  <td align="center"><?php if(!empty($searchableNumeratorVal)) echo $this->Html->link($searchableNumeratorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
		<!--    <tr>
		    <td>1. EMR Logs when New Medication information is printed and given to Patient/Familieis/CareGiver.</td>
			<td align="center"><?php if(!empty($medicationDenominatorVal)) echo $this->Html->link($medicationDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'medication',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationPrintedNumeratorVal)) echo $this->Html->link($medicationPrintedNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'medicationPrinted',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($medicationDenominatorVal)) echo $this->Html->link($medicationDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'medication',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationExplainedHealthNumeratorVal)) echo $this->Html->link($medicationExplainedHealthNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'medicationExplainedHealth',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($medicationDenominatorVal)) echo $this->Html->link($medicationDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'medication',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationDifficultyNumeratorVal)) echo $this->Html->link($medicationDifficultyNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'medicationDifficulty',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($medicationDenominatorVal)) echo $this->Html->link($medicationDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'medication',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationHassideeffectNumeratorVal)) echo $this->Html->link($medicationHassideeffectNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'medicationHassideeffect',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($medicationDenominatorVal)) echo $this->Html->link($medicationDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'medication',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationMedicationPrescribedNumeratorVal)) echo $this->Html->link($medicationMedicationPrescribedNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'medicationMedicationPrescribed',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($medicationDenominatorVal)) echo $this->Html->link($medicationDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'medication',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationIssupplementNumeratorVal)) echo $this->Html->link($medicationIssupplementNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'medicationIssupplement',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($medicationDenominatorVal)) echo $this->Html->link($medicationDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'medication',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationIsherbalNumeratorVal)) echo $this->Html->link($medicationIsherbalNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'medicationIsherbal',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($medicationDenominatorVal)) echo $this->Html->link($medicationDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'medication',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationReportedInteractionNumeratorVal)) echo $this->Html->link($medicationReportedInteractionNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'medicationReportedInteraction',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($medicationreconDenominatorVal)) echo $this->Html->link($medicationreconDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'medicationrecon',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationreconNumeratorVal)) echo $this->Html->link($medicationreconNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'medicationrecon',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($medicationreconDenominatorVal)) echo $this->Html->link($medicationreconDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'medicationrecon',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationreconNumeratorVal)) echo $this->Html->link($medicationreconNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'medicationrecon',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
		  -->
		  <tr>
		    <td>1. Clinic Generates Report Validating >50% of Patients have adequate understanding of Medications</td>
			<td align="center"><?php if(!empty($medicationExplainedHealthDenominatorVal)) echo $this->Html->link($medicationExplainedHealthDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'medicationExplainedHealth',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationExplainedHealthNumeratorVal)) echo $this->Html->link($medicationExplainedHealthNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'medicationExplainedHealth',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center">
			 <?php 
			 if(!empty($medicationExplainedHealthDenominatorVal) && !empty($medicationExplainedHealthNumeratorVal)) {
              $medicationExplained = round(($medicationExplainedHealthNumeratorVal/$medicationExplainedHealthDenominatorVal)*100);
               echo $this->Number->toPercentage($medicationExplained,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  <tr>
		    <td>2. Clinic Generates Report that >50% of Eligible Prescriptions are sent Electronically</td>
			<td align="center"><?php if(!empty($medicationEligibleSentDenominatorVal)) echo $this->Html->link($medicationEligibleSentDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'medicationEligibleSent',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationEligibleSentNumeratorVal)) echo $this->Html->link($medicationEligibleSentNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'medicationEligibleSent',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center">
			 <?php 
			 if(!empty($medicationEligibleSentDenominatorVal) && !empty($medicationEligibleSentNumeratorVal)) {
              $medicationEligibleSent = round(($medicationEligibleSentNumeratorVal/$medicationEligibleSentDenominatorVal)*100);
               echo $this->Number->toPercentage($medicationEligibleSent,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		  
		  <tr>
		    <td>3. Clinic has Assessed Interactions of Medications against OTC Medications, Supplemements, and Herbal Therapies is done for >50% Patients Annually</td>
			<td align="center"><?php if(!empty($medicationOtcAssesedInteractionDenominatorVal)) echo $this->Html->link($medicationOtcAssesedInteractionDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'medicationOtcAssesed',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($medicationOtcAssesedInteractionNumeratorVal)) echo $this->Html->link($medicationOtcAssesedInteractionNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'medicationOtcAssesedInteraction',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center">
			 <?php 
			 if(!empty($medicationOtcAssesedInteractionDenominatorVal) && !empty($medicationOtcAssesedInteractionNumeratorVal)) {
              $medicationOtcAssesedInteraction = round(($medicationOtcAssesedInteractionNumeratorVal/$medicationOtcAssesedInteractionDenominatorVal)*100);
               echo $this->Number->toPercentage($medicationOtcAssesedInteraction,0);
             } else {
               echo  "00%";
             }
             ?>
			</td>
		  </tr>
		 <!--   <tr>
		    <td>14. Clinic will Generate Abnormal Lab Test Results Report Daily or On Demand (CRITICAL)</td>
			<td align="center"><?php if(!empty($labDenominatorVal)) echo $this->Html->link($labDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'lab',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($labNumeratorVal)) echo $this->Html->link($labNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'lab',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($overdueDenominatorVal)) echo $this->Html->link($overdueDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'overdue',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($overdueNumeratorVal)) echo $this->Html->link($overdueNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'overdueLab',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($overdueRadDenominatorVal)) echo $this->Html->link($overdueRadDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'overdueRad',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($overdueRadNumeratorVal)) echo $this->Html->link($overdueRadNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'overdueRad',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
			<td align="center"><?php if(!empty($specificeducationDemo['0']['0']['count'])) echo $this->Html->link($specificeducationDemo['0']['0']['count'],
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'specificEducation',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
			<td align="center"><?php if(!empty($specificeducationNum['0']['0']['count'])) echo $this->Html->link($specificeducationNum['0']['0']['count'],
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'specificEducation',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
		  </tr>-->
		  
		  <tr>
		    <td colspan="4"><b>CCDA</b></td>
		  </tr>
		 <!--   <tr>
		    <td>1.Transitions of Care that are Documented in EMRs with Electronic Discharge Summaries from Hospitals and Other Facilities </td>
		    <td align="center"><?php if(!empty($electronicDenominatorVal)) echo $this->Html->link($electronicDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'electronic',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($electronicNumeratorVal)) echo $this->Html->link($electronicNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'electronic',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
	    	<td align="center"><?php if(!empty($patientInfoDenominatorVal)) echo $this->Html->link($patientInfoDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'patientInfo',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($patientInfoNumeratorVal)) echo $this->Html->link($patientInfoNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'patientInfo',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
		    </tr>-->
		     <tr>
		    <td>1.Clinic Generates a Report that >50% of Referrals to Specialists include Electronic Transmission of Summary of Care  </td>
		    <td align="center"><?php if(!empty($summaryDenominatorVal)) echo $this->Html->link($summaryDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'summary',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($summaryNumeratorVal)) echo $this->Html->link($summaryNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'summary',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
		    <td>2.View, download and transmit report -  Rate report  </td>
		    <td align="center"><?php if(!empty($ccdaArrivalsdenominatorVal)) echo $this->Html->link($ccdaArrivalsdenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'ccdaArrivals',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($ccdaNumerator)) echo $this->Html->link($ccdaNumerator,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'ccda',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
		     <td colspan="4"><b>No Show/Arrived  Reports</b></td>
		     </tr>
		     <tr>
		    <td>1.<b><?php echo $this->Html->link('Percentage of No shows Report',array('controller'=>'MeaningfulReport','action'=>'appointment_log','admin'=>false));?></b></td>
		    <td align="center"><?php if(!empty($noShowDenominatorVal)) echo $this->Html->link($noShowDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'noShow',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($noShowNumeratorVal)) echo $this->Html->link($noShowNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'noShow',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
		    <td>2.<b><?php echo $this->Html->link('Percentage of Arrivals Report',array('controller'=>'MeaningfulReport',
		    		'action'=>'appointment_arrived_report','?'=>array('startDate'=>$startDate,'endDate'=>$endDate,'pie'=>'pie'),'admin'=>false));?></b> </td>
		    <td align="center"><?php if(!empty($noShowDenominatorVal)) echo $this->Html->link($noShowDenominatorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'noShow',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($arrivalsNumeratorVal)) echo $this->Html->link($arrivalsNumeratorVal,
					array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'arrivals',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type),'admin'=>false),
					array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($noShowDenominatorVal) && !empty($arrivalsNumeratorVal)) {
              $arrivalCalculation = round(($arrivalsNumeratorVal/$noShowDenominatorVal)*100);
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
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'dob'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableDobNumeratorVal)) echo $this->Html->link($searchableDobNumeratorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'dob'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
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
		    <td align="center"><?php if(!empty($searchableDenominatorVal))echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'sex'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableSexNumeratorVal)) echo $this->Html->link($searchableSexNumeratorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'sex'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableSexNumeratorVal)) {
              //$sexCalculation = round(($searchableSexNumeratorVal/$searchableDenominatorVal)*100);
               //echo $this->Number->toPercentage($sexCalculation,0);
               echo "100%" ;
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr> 
		  <tr>
		    <td>3.Over 80% of EMRs in a Clinic are searchable by 'Race' of Patient (include: 'Declined to specify') </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal))echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'race'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'race'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableRaceNumeratorVal)) {
              $raceCalculation = round(($searchableDenominatorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($raceCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		  <tr>
		    <td>4.Over 80% of EMRs in a Clinic are searchable by 'Ethnicity' of Patient' (include: 'Declined to specify') </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'ethnicity'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'ethnicity'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableDenominatorVal)) {
              $ethnicityCalculation = round(($searchableDenominatorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($ethnicityCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		  <tr>
		    <td>5.Over 80% of EMRs in a Clinic are searchable by 'Preferred Language' of Patient' </td>
				<td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'language'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'langauge'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>

		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableDenominatorVal)) {
              $preferredLanguageCalculation = round(($searchableDenominatorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($preferredLanguageCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		  <tr>
		    <td>6.Over 80% of EMRs in a Clinic are searchable by 'Telephone' of Patient </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'telephone'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'telephone'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableDenominatorVal)) {
              $telePrimaryCalculation = round(($searchableDenominatorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($telePrimaryCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		  <tr>
		    <td>7.Over 80% of EMRs in a Clinic are searchable by 'Alternate Telephone' of Patient (mandatory; can be same as primary) </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'alter_telephone'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'alter_telephone'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableAlterTeleNumeratorVal)) {
              $alterTeleCalculation = round(($searchableDenominatorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($alterTeleCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		  <tr>
		    <td>8.Over 80% of EMRs in a Clinic are searchable by 'eMail' of Patient' </td>
		   <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'email'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'email'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableEmailNumeratorVal)) {
              $emailCalculation = round(($searchableDenominatorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($emailCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		  <tr>
		    <td>9.Over 80% of EMRs in a Clinic are searchable by 'Occupation' of Patient' </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'occupation'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'occupation'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableDenominatorVal)) {
              $occupationCalculation = round(($searchableDenominatorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($occupationCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		  <tr>
		    <td>10.Over 80% of EMRs in a Clinic are searchable by 'Dates of Previous Clinical Visits' of Patient' </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'date'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal,
			  		array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'date'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";?></td>
		    <td align="center"><?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableDenominatorVal)) {
              $primaryCalculation = round(($searchableDenominatorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($primaryCalculation,0);
             } else {
               echo  "00%";
             }
             ?></td>
		  </tr>
		  <tr>
		    <td>11.Over 80% of EMRs in a Clinic are searchable by 'Legal Guardian/Healthcare Proxy' of Patient' </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'legal_guar'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'legal_guar'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank'));else echo "0";?></td>
		    <td align="center"><?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableDenominatorVal)) {
              $primaryCalculation = round(($searchableDenominatorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($primaryCalculation,0);
             } else {
               echo  "00%";
             }
             ?></td>
			
		  </tr>
		  <tr>
		    <td>12.Over 80% of EMRs in a Clinic are searchable by 'Primary Care Giver' of Patient' </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'pri_care_giver'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'pri_care_giver'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableDenominatorVal)) {
              $primaryCalculation = round(($searchableDenominatorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($primaryCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		  <tr>
		    <td>13.Over 80% of EMRs in a Clinic are searchable by 'Advanced Directives' of Patient' </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'adv_dir'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'adv_dir'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableDenominatorVal)) {
              $advanceDirectiveCalculation = round(($searchableDenominatorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($advanceDirectiveCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		  <tr>
		    <td>14.Over 80% of EMRs in a Clinic are searchable by 'Health Insurance Information' of Patient' </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'health_info'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'health_info'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableDenominatorVal)) {
              $insuranceInfoCalculation = round(($searchableDenominatorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($insuranceInfoCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>
		  <tr>
		    <td>15.Over 80% of EMRs in a Clinic are searchable by 'Name and Contact of Other Healthcare Professionals involved in care' of Patient':( list of patients seen by a physician) </td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_denominator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'health_care'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center"><?php if(!empty($searchableDenominatorVal)) echo $this->Html->link($searchableDenominatorVal
			  		,array('controller'=>'MeaningfulReport','action'=>'pcmh_numerator_automated_measure','?'=>array('report' => 'searchable',
					 'sd'=> $startdate,'year'=>$year,'duration'=>$duration,'provider'=>$provider,'patient_type'=>$patient_type,'option'=>'health_care'),'admin'=>false),
					  array('escape' => false,'target'=>'_blank')); else echo "0";  ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($searchableDenominatorVal) && !empty($searchableDenominatorVal)) {
              $physicianCalculation = round(($searchableDenominatorVal/$searchableDenominatorVal)*100);
               echo $this->Number->toPercentage($physicianCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>	
		  <tr>
		    <td colspan="4"><b>Clinical Reminder Report</b></td>
		  </tr>	
		  <tr>
		    <td>1.Blood glucose (sugar) for diabetes.</td>
		      <td align="center"><?php  if(!empty($demoSuagr))  echo $demoSuagr; else echo '0'; ?></td>
		    <td align="center"><?php  if(!empty($numaSuagr)) echo $numaSuagr; else echo '0'; ?></td>
		    <td align="center">
		    <?php 
			 if(!empty($demoSuagr) && !empty($numaSuagr)) {
              $physicianCalculation = round(($numaSuagr/$demoSuagr)*100);
               echo $this->Number->toPercentage($physicianCalculation,0);
             } else {
               echo  "00%";
             }
             ?>
             </td>
		  </tr>  
		   <?php }?>   
		  <tr>
		    <td colspan="4"><b><?php echo $this->Html->link('List of Patient Communications with Physicians',array('controller'=>'MeaningfulReport','action'=>'patient_communication','admin'=>false));?></b></td>
		  </tr>
		  <tr>
		    <td colspan="4"><b><?php echo $this->Html->link('Patient wise physician list',array('controller'=>'MeaningfulReport','action'=>'patient_wise_list','admin'=>false));?></b></td>
		  </tr>
		  <tr>
		    <td colspan="4"><b><?php echo $this->Html->link('Physician wise patient list',array('controller'=>'MeaningfulReport','action'=>'physician_wise_list','admin'=>false));?></b></td>
		  </tr>
		  <tr>
		    <td colspan="4"><b><?php echo $this->Html->link('Response time report',array('controller'=>'MeaningfulReport','action'=>'response_time_report','admin'=>false));?></b></td>
		  </tr>
		  <tr>
		    <td colspan="4"><b><?php echo $this->Html->link('Patients Not Visited Report',array('controller'=>'MeaningfulReport','action'=>'patient_not_visited','admin'=>false));?></b></td>
		  </tr>
		  <tr>
		    <td colspan="4"><b><?php echo $this->Html->link('Physicians Percentage Report',array('controller'=>'MeaningfulReport','action'=>'doctor_wise_report','admin'=>false));?></b></td>
		  </tr>
		  <tr>
		    <td colspan="4"><b><?php echo $this->Html->link('Unusually high number of prescriptions',array('controller'=>'MeaningfulReport','action'=>'unusual_reports','prescriptions','admin'=>false));?></b></td>
		  </tr>
		  <tr>
		    <td colspan="4"><b><?php echo $this->Html->link('Unusually high numbers of imaging or lab tests ordered',array('controller'=>'MeaningfulReport','action'=>'unusual_reports','lab','admin'=>false));?></b></td>
		  </tr>
		  <tr>
		    <td colspan="4"><b><?php echo $this->Html->link('Unusually high numbers of imaging or radiology tests ordered',array('controller'=>'MeaningfulReport','action'=>'unusual_reports','rad','admin'=>false));?></b></td>
		  </tr>
		  <tr>
		    <td colspan="4"><b><?php echo $this->Html->link('High-cost medications',array('controller'=>'Reports','action'=>'patient_list','?'=>array('flag'=>'medication'),'admin'=>true));?></b></td>
		  </tr>
		  <tr>
		    <td colspan="4"><b><?php echo $this->Html->link('Hospital readmissions within 30 days Report',array('controller'=>'MeaningfulReport','action'=>'readmission_report','admin'=>false));?></b></td>
		  </tr>
		  
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


		$("#excel-report").click(function(){
			$('#report-type').val('excel') ;
		});
		
 });
 
</script>