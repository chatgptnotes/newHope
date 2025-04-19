<?php  echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));      
echo $this->Html->script(array('jquery.fancybox-1.3.4'));?>


<style>
.container {
	border: 1px solid #4C5E64;
	padding-left: 5px;
}

/*.title {
	background: none repeat scroll 0 0 #4C5E64;
}*/
.comman {
	margin-top: 10px;
	margin-left: 10px;
	border-bottom: 1px solid #4C5E64;
}

li {
	list-style: none;
	margin: 10px 0 0;
	font-size: 13px;
}

* {
	margin: 0px;
	padding: 0px;
}

.cc_ul {
	height: 25px;
}

.cc_ul li {
	float: left;
	list-style: none;
	margin-left: 20px;
}

.cc_l1 {
	background: #363F42;
}

.health_stats { /*margin-left: 20px;*/
	
}

.health_stats ul { /*margin-left: 20px;*/
	border: 1px solid #4C5E64;
	border-right: none;
	margin-bottom: 10px;
	margin-top: 10px;
}

.health_stats ul li {
	margin-bottom: 5px;
	margin-top: 5px;
}

.ros_li1 {
	float: left;
	margin-left: 10px;
	width: 170px;
}

.ros_li {
	float: left;
	margin-left: 10px;
}

.comman>h3 {
	background: none repeat scroll 0 0 #D2EBF2;
	border-bottom: 1px solid #3E474A;
	color: #31859C !important;
	font-size: 13px;
	padding: 5px 7px;
}
</style>
<div class="inner_title">
	<h3 class="title">
		&nbsp;
		<?php echo __('Initial Assessment', true); ?>
	</h3>
	<span><?php echo $this->Html->link(__('Back', true),array('controller' => 'PatientsTrackReports', 'action' => 'sbar',$this->request->query['patientId']), array('escape' => false,'class'=>'blueBtn'));?></span>

</div>
<?php echo $this->element('patient_information');?>

<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#").validationEngine();
	});
 
 </script>

<div class="clr ht5"></div>
<?php //echo $this->element('patient_information');
	?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<?php echo $this->Form->create('PatientDocument',array('type' => 'file'));?>


	<div class="comman">
		<h3>
			<font style="text-decoration: underline"><?php  echo ("Chief Complaint")?>
			</font>
		</h3>
		<ul class="">
			<li class=""></li>
			<?php  if(!empty($ccDiagnoses['Diagnosis']['complaints'])) {?>
			<li><?php echo str_ireplace($search,'<font color="green">' .$search .'</font>',$ccDiagnoses['Diagnosis']['complaints']); ?>
			</li>
			<?php }else{?>
			<li><strong><?php echo ("No record found") ?> </strong></li>
			<?php }?>
		</ul>
	</div>
	<div class="comman">
		<h3>
			<font style="text-decoration: underline"><?php  echo ("Test Results")?>
			</font>
		</h3>
		<ul class="">
			<li class=""></li>
			<?php  if(!empty($ccDiagnoses['Diagnosis']['lab_report'])) {?>
			<li><?php echo str_ireplace($search,'<font color="green">' .$search .'</font>',$ccDiagnoses['Diagnosis']['lab_report']); ?>
			</li>
			<?php }else{?>
			<li><strong><?php echo ("No record found") ?> </strong></li>
			<?php }?>
		</ul>
	</div>
	<div class="comman">
		<h3>
			<font style="text-decoration: underline"><?php  echo ("Current Medication")?>
			</font>
		</h3>
		<ul class="">
			<li class=""></li>
			<?php  
			foreach($getMedicationRecords as $key => $dataMedicationRecords){
			if(!empty($dataMedicationRecords['NewCropPrescription']['description'])) {?>
			<li><?php echo str_ireplace($search,'<font color="green">' .$search .'</font>',$dataMedicationRecords['NewCropPrescription']['description']); ?>
			</li>
			<?php }else{?>
			<li><strong><?php echo ("No record found") ?> </strong></li>
			<?php }}?>
		</ul>
	</div>
	<div class="comman">
		<h3>
			<font style="text-decoration: underline"><?php  echo ("Medication History")?>
			</font>
		</h3>
		<ul class="">
			<li class=""></li>
			<?php 
			foreach($getMedicationHistory as $key => $dataMedicationHistory){
			if(!empty($dataMedicationHistory['NewCropPrescription']['description'])) {?>
			<li><?php echo str_ireplace($search,'<font color="green">' .$search .'</font>',$dataMedicationHistory['NewCropPrescription']['description']); ?>
			</li>
			<?php }else{?>
			<li><strong><?php echo ("No record found") ?> </strong></li>
			<?php }}?>
		</ul>
	</div>
	<div class="comman">
		<h3>
			<font style="text-decoration: underline"><?php  echo ("Other Treatment")?>
			</font>
		</h3>
		<ul class="">
			<li class=""></li>
			<?php  if(!empty($getTreatmentRecords['OtherTreatment']['chemotherapy_drug_name'])) {?>
			<li><?php echo str_ireplace($search,'<font color="green">' .$search .'</font>',$getTreatmentRecords['OtherTreatment']['chemotherapy_drug_name']); ?>
			</li>
			<?php }else{?>
			<li><strong><?php echo ("No record found") ?> </strong></li>
			<?php }?>
		</ul>
	</div>
	<div class="comman">
		<h3>
			<font style="text-decoration: underline"><?php  echo ("Immunizations")?>
			</font>
		</h3>
		<ul class="">
			<li class=""></li>
			<?php 
			foreach($immunizationData as $key => $dataImmunizationData){
			if(!empty($dataImmunizationData['Imunization']['cpt_description'])) {?>
			<li><?php echo str_ireplace($search,'<font color="green">' .$search .'</font>',$dataImmunizationData['Imunization']['cpt_description']); ?>
			</li>
			<?php }else{?>
			<li><strong><?php echo ("No record found") ?> </strong></li>
			<?php }}?>
		</ul>
	</div>
	<div class="comman">
		<h3>
			<font style="text-decoration: underline"><?php  echo ("Vitals ")?>
			</font>
		</h3>
		<ul class="">
			<li class=""><strong><?php //echo("Chief complaint")?> </strong></li>
			<?php  if(!empty($get_vital['BmiResult'])) {?>
			<?php if(!empty($get_vital['BmiResult']['temperature'])){?>			<!-- temp -->
			<li><?php echo "Temperature: ".$get_vital['BmiResult']['temperature'].' F'; ?>
			</li>
			<?php }?>
			<?php if(!empty($get_vital['BmiResult']['height_result'])){?>		<!-- height_result -->
			<li><?php echo "Height: ".$get_vital['BmiResult']['height_result'].' F'; ?>
			</li>
			<?php }?>
			<?php if(!empty($get_vital['BmiResult']['weight_result'])){?>		<!--weight_result  -->
			<li><?php echo "Weight: ".$get_vital['BmiResult']['weight_result'].' F'; ?>
			</li>
			<?php }?>
			<?php if(!empty($get_vital['BmiResult']['bmi'])){?>
			<li><?php echo "BMI: ".$get_vital['BmiResult']['bmi'].' Kg/m.sq.'; ?> <!-- bmi -->
			</li>
			<?php } ?>
				<?php 
				foreach($get_vital['BmiBpResult'] as $key => $BmiBpResult){
				
				if(!empty($BmiBpResult['pulse_text'])){?>
			<li><?php echo "Pluse Rate: ".$BmiBpResult['pulse_text'].' '.$BmiBpResult['pulse_volume'].' '; ?>
			</li>
			<?php }?>
			
			<?php }}else{?>
			<li><strong><?php echo ("No record found") ?> </strong></li>
			<?php }?>
		</ul>
	</div>
	<div class="comman">
		<h3>
			<font style="text-decoration: underline"><?php  echo ("Allergies")?>
			</font>
		</h3>
		<ul class="">
			<li class=""></li>
			<?php 
			foreach($allergies_data as $key => $allergiesData){
			if(!empty($allergiesData['NewCropAllergies']['name'])) {?>
			<li><?php echo str_ireplace($search,'<font color="green">' .$search .'</font>',$allergiesData['NewCropAllergies']['name']); ?>
			</li>
			<?php }else{?>
			<li><strong><?php echo ("No record found") ?> </strong></li>
			<?php }}?>
		</ul>
	</div>
	
<?php echo $this->Form->end();?>



