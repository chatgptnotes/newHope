<style>
.container{border: 1px solid #4C5E64;}
.comman{margin-top:20px;}
li{list-style: none;}
*{margin: 0px; padding: 0px;}
.cc_ul{border: 1px solid #4C5E64; height: 25px;}
.cc_ul li{float: left; list-style: none; margin-left: 20px;}
.cc_l1{background: #363F42;}
.health_stats{margin-left: 20px;}
.health_stats ul{margin-left: 20px;}</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Power Notes', true); ?>
	</h3>
	<span><?php 
	echo $this->Html->link(__('Back'), array('action' => '',$patient['Patient']['id']), array('escape' => false,'class'=>'blueBtn'));
	?>
	</span>

</div>


<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#").validationEngine();
	});
 
 </script>

<div class="clr ht5"></div>
<?php echo $this->element('patient_information');?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<?php echo $this->Form->create('PatientDocument',array('type' => 'file'));?>

<div class="container">
<div class="comman"><h3><?php echo ("Basic Information [Show Structure]")?></h3>
	<ul><li><strong><?php echo("Source of history:")?></strong><?php echo("Self")?></li>
		<li><strong><?php echo("Referral source:")?></strong><?php echo("Self")?></li>
		<li><strong><?php echo("History limitation:")?></strong><?php echo("None")?></li>
		</ul>
</div>
<div class="comman"><h3><?php echo ("Chief Complaint [Hide Structure]")?></h3>
	<ul class="cc_ul"><li class="cc_l1"><strong><?php echo("Chief complaint")?></strong></li>
		<li><strong><?php echo("Include CC from nursing intake/OTHER")?></strong></li>
		
		</ul>
</div>
<div class="comman"><h3><?php echo ("History of Present Illness [Show Structure]")?></h3>
	<ul><li><strong><?php echo("The patient present with complaints of chest pain")?></strong><?php echo("Self")?></li>
		<li><strong><?php echo("He has has symptoms for three weeks. The chest pain is musculoskeletal and atypical in nature")?></strong><?php echo("Self")?></li>
		<li><strong><?php echo("His past history is significant for problem listed in problem list")?></strong><?php echo("None")?></li>
		<li><strong><?php echo("He has the additional compaint of_")?></strong><?php echo("None")?></li>
		</ul>
</div>
<div class="comman"><h3><?php echo ("Review Of Systems [Show Structure]")?></h3>
	<ul><li><strong><?php echo("Constitutional:")?></strong><?php echo("Negative except as documented in history of present illeness")?></li>
		<li><strong><?php echo("Eye:")?></strong><?php echo("Negative except as documented in history of present illeness")?></li>
		<li><strong><?php echo("Ear/Nose/Mouse/Throat:")?></strong><?php echo("Negative except as documented in history of present illeness")?></li>
		<li><strong><?php echo("Respiratory:")?></strong><?php echo("Negative except as documented in history of present illeness")?></li>
		</ul>
</div>

<div class="comman"><h3><?php echo ("Health Status [Show Structure]")?></h3>
	<ul class="health_stats"><li><strong><?php echo("Allergies:")?></strong>
			<ul ><li><?php echo("Alergic reaction(All)")?></li></ul>
		</li>
	
		<li><strong><?php echo("Current Medication:")?></strong>
			<ul><li><b><?php echo("Inpatient Medication")?></b>
					<ul><li><?php echo("Sodium Chronic")?></li><li><?php echo("dextrose")?></li></ul>
				</li>
				<li><b><?php echo("Documented Medication")?></b>
					<ul><li><?php echo("Documented")?></li><li><?php echo("enalapril")?></li></ul></li>
					
			</ul></li>
			
		
		</ul>
</div>

<div class="comman"><h3><?php echo ("Histories [Hide Structure]")?></h3>
	<ul class="cc_ul"><li class="cc_l1"><strong><?php echo("Family History")?></strong></li>
		<li><strong><?php echo("Free Text Family history")?></strong></li>
		</ul>
		
		<ul class="cc_ul"><li class="cc_l1"><strong><?php echo("Procedure History")?></strong></li>
		<li><strong><?php echo("Free Text Procedure history")?></strong></li>
		</ul>
		<ul class="cc_ul"><li class="cc_l1"><strong><?php echo("Social History")?></strong></li>
		<li><strong><?php echo("Free Text Social history/Negative/Unknown/Denies alchohol, tobacco and drug use/Alchohol Use+/Tobacco use+/Drug use+/Occupation/Family/Social situation+/OTHER")?></strong></li>
		</ul>
</div >

<div class="comman"><h3><?php echo ("Physical Examination [Show Structure]")?></h3>
	<ul><li><strong><?php echo("General")?></strong><?php echo("Alert and oriented, No acute distress")?></li>
		<li><strong><?php echo("Eye")?></strong><?php echo("Pupils are equal, round and reactive to light, Extraocular movements are intact.")?></li>
		<li><strong><?php echo("His past history is significant for problem listed in problem list")?></strong><?php echo("None")?></li>
		<li><strong><?php echo("Hent")?></strong><?php echo("Normocephallic")?></li>
		<li><strong><?php echo("Neck")?></strong><?php echo("Supple")?></li>
		<li><strong><?php echo("Respiratory")?></strong><?php echo("Lungs are clear to ausculation")?></li>
		</ul>
</div>

<div class="comman">
	<ul class="cc_ul"><li class="cc_l1"><strong><?php echo("Cardiovascular")?></strong></li>
		<li><strong><?php echo("Normal Rate")?></strong></li>
		<li><strong><?php echo("Regular rhythm")?></strong></li>
		<li><strong><?php echo("No mumur")?></strong></li>
		<li><strong><?php echo("No gallo")?></strong></li>
		</ul>
		
		
</div>
<div class="comman">
	<ul class="health_stats"><li><strong><?php echo("Gastrointestinal")?></strong><?php echo("Soft, Non-tender, Normal bowel sound")?></li>
		<li><strong><?php echo("Genitourinary")?></strong><?php echo("No costovertebral angel lenderness.")?></li>
		<li><strong><?php echo("Lymphatics")?></strong><?php echo("No lymphadenopathy neck, axilla, groin")?></li>
		<li><strong><?php echo("Musculosketal")?></strong><ul><li><?php echo("Normal range of motion")?></li></ul></li>
		<li><strong><?php echo("Neurologic")?></strong><?php echo("Alert, Oriented")?></li>
		<li><strong><?php echo("Cognition and Speech")?></strong><?php echo("Speech clear and coherent")?></li>
		<li><strong><?php echo("Psychiatric")?></strong><?php echo("Cooperative")?></li>
		</ul>
</div>

<div class="comman"><h3><?php echo ("Health maintenence [Show Structure]")?></h3>
	<ul><li><strong><?php //echo("General")?></strong><?php //echo("Alert and oriented, No acute distress")?></li>
		<li><strong><?php //echo("Eye")?></strong><?php //echo("Pupils are equal, round and reactive to light, Extraocular movements are intact.")?></li>
		<li><strong><?php //echo("His past history is significant for problem listed in problem list")?></strong><?php //echo("None")?></li>
		<li><strong><?php //echo("Hent")?></strong><?php //echo("Normocephallic")?></li>
		<li><strong><?php //echo("Neck")?></strong><?php //echo("Supple")?></li>
		<li><strong><?php //echo("Respiratory")?></strong><?php //echo("Lungs are clear to ausculation")?></li>
		</ul>
</div>

<div class="comman"><h3><?php echo ("Review /Managment [Show Structure]")?></h3>
	<ul><li><strong><?php //echo("General")?></strong><?php //echo("Alert and oriented, No acute distress")?></li>
		<li><strong><?php //echo("Eye")?></strong><?php //echo("Pupils are equal, round and reactive to light, Extraocular movements are intact.")?></li>
		<li><strong><?php //echo("His past history is significant for problem listed in problem list")?></strong><?php //echo("None")?></li>
		<li><strong><?php //echo("Hent")?></strong><?php //echo("Normocephallic")?></li>
		<li><strong><?php //echo("Neck")?></strong><?php //echo("Supple")?></li>
		<li><strong><?php //echo("Respiratory")?></strong><?php //echo("Lungs are clear to ausculation")?></li>
		</ul>
</div>

<div class="comman"><h3><?php echo ("Impression and Plan [Hide Structure]")?></h3>
	<ul class=""><li class=""><strong><?php echo("")?></strong></li>
		<li><strong><?php echo("General Admission")?></strong></li>
		</ul>
		
		<ul class="cc_ul"><li class="cc_l1"><strong><?php echo("Diagnosis")?></strong></li>
			<li><?php echo("Other Diagnosis")?></li>
			<li><?php echo("Other")?></li>
		</ul>
		<ul class="cc_ul"><li class="cc_l1"><strong><?php echo("Course")?></strong></li>
				<li><?php echo("Worsening")?></li>
				<li><?php echo("Im proving")?></li>
				<li><?php echo("progressing as expected")?></li>
				<li><?php echo("Well controlled")?></li>
				<li><?php echo("Unchange")?></li>
				<li><?php echo("Other")?></li>
		</ul>
		<ul class="cc_ul"><li class="cc_l1"><strong><?php echo("orders")?></strong></li>
				<li><?php echo("Worsening")?></li>
				<li><?php echo("Im proving")?></li>
				<li><?php echo("progressing as expected")?></li>
				<li><?php echo("Well controlled")?></li>
				<li><?php echo("Unchange")?></li>
				<li><?php echo("Other")?></li>
		</ul>
		
		<ul class=""><li class=""><strong><?php echo("")?></strong></li>
		<li><strong><?php echo("Dx and Plan(repeat)")?></strong></li>
		</ul>
		<ul class="cc_ul"><li class="cc_l1"><strong><?php echo("Course")?></strong></li>
				<li><?php echo("Order profile")?></li>
				
				<li><?php echo("Other")?></li>
		</ul>
		<ul class="cc_ul"><li class="cc_l1"><strong><?php echo("orders")?></strong></li>
				<li><?php echo("Order profile")?></li>
				<li><?php echo("Other")?></li>
				
		</ul>
</div>

</div>


<?php echo $this->Form->end();?>


