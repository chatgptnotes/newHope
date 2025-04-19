<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#surgicalsitefrm").validationEngine();
	});
	
</script>
<div class="inner_title">
	<h3>
		<?php echo __('Edit Surgical Site Infections', true); ?>
	</h3>
</div>

<div class="patient_info">
	<?php echo $this->element('patient_information');?>
</div>
<div class="clr"></div>
<div
	style="text-align: right;" class="clr inner_title"></div>
<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><div class="alert">
				<?php 
				foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     ?>
			</div>
		</td>
	</tr>
</table>
<?php } ?>
<!-- two column table end here -->
<form name="surgicalsitefrm" id="surgicalsitefrm"
	action="<?php echo $this->Html->url(array("controller" => "hospital_acquire_infections", "action" => "edit_ssi", "admin" => false,"superadmin" => false)); ?>"
	method="post">
	<?php 
	echo $this->Form->input('SurgicalSiteInfection.patient_id', array('type' => 'hidden', 'value' => $patient['Patient']['id']));
	echo $this->Form->input('SurgicalSiteInfection.id', array('type' => 'hidden'));
	?>
	<div>&nbsp;</div>
	<div class="clr ht5"></div>

	<table width="100%" cellpadding="0" cellspacing="1" border="0"
		class="tabularForm">
		<tr>
			<th colspan="7"><?php echo __('Operation',true); ?></th>
		</tr>
		<tr>
			<td width="250"><?php echo __('Type Of Operation',true); ?><font
				color="red">*</font></td>
			<td><?php 
			echo $this->Form->input('SurgicalSiteInfection.operation_type', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => array('Emergency' => 'Emergency', 'Elective' => 'Elective'),'empty' => 'Select', 'id' => 'operation_type', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
	</table>
	<div>&nbsp;</div>
	<div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0"
		class="tabularForm">
		<tr>
			<th colspan="7"><?php echo __('Wound',true); ?></th>
		</tr>
		<tr>
			<td width="250"><?php echo __('Location',true); ?><font color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->input('SurgicalSiteInfection.wound_location', array('class' => 'validate[required,custom[woundlocation]]', 'id' => 'location', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td width="250"><?php echo __('Type',true); ?><font color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->input('SurgicalSiteInfection.wound_type', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => array('Clean' => 'Clean', 'Contaminated' => 'Contaminated', 'Clean-Contaminated' => 'Clean-Contaminated', 'Dirty/Infected' => 'Dirty/Infected'), 'empty' => 'Select', 'id' => 'type', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
	</table>
	<div>&nbsp;</div>
	<div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0"
		class="tabularForm">
		<tr>
			<th colspan="7"><?php echo __('Advance Surgical Associates(ASA) score',true); ?>
			</th>
		</tr>
		<tr>
			<td width="250"><?php echo __('Score Type',true); ?><font color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->input('SurgicalSiteInfection.asa_scoretype', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'), 'empty' => 'Select', 'id' => 'score_type', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
	</table>
	<div>&nbsp;</div>
	<div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0"
		class="tabularForm">
		<tr>
			<th colspan="2"><?php echo __('Antibiotics',true); ?></th>
		</tr>
		<tr>
			<td width="250"><?php echo __('Antimicrobial Prophylaxis ',true); ?><font
				color="red">*</font></td>
			<td><?php 
			echo $this->Form->input('SurgicalSiteInfection.antimicrobial_prophylaxis', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => array('No' => 'No', 'Yes' => 'Yes'), 'empty' => 'Select', 'id' => 'antimicrobial_prophylaxis', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
	</table>
	<div>&nbsp;</div>
	<div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0"
		class="tabularForm">
		<tr>
			<th colspan="7"><?php echo __('Surgical Site Snfection',true); ?></th>
		</tr>
		<tr>
			<td width="250"><?php echo __('Infection Site',true); ?><font
				color="red">*</font></td>
			<td><?php 
			echo $this->Form->input('SurgicalSiteInfection.ssi_infection', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => array('Superficial' => 'Superficial', 'Deep' => 'Deep', 'Organ Space' => 'Organ Space'), 'empty' => 'Select', 'id' => 'infection_site', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td width="250"><?php echo __('Microorganism 1',true); ?></td>
			<td><?php 
			echo $this->Form->input('SurgicalSiteInfection.ssi_micro1', array('id' => 'microorganism_1', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td width="250"><?php echo __('Microorganism 2',true); ?></td>
			<td><?php 
			echo $this->Form->input('SurgicalSiteInfection.ssi_micro2', array('id' => 'microorganism_2', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td width="250"><?php echo __('Date of last contact',true); ?></td>
			<td><?php 
			echo $this->Form->input('SurgicalSiteInfection.ssi_lastcontact', array('type' => 'text', 'id' => 'date_of_last_contact', 'label'=> false, 'div' => false, 'error' => false, 'value' => $this->DateFormat->formatDate2Local($this->request->data['SurgicalSiteInfection']['ssi_lastcontact'],Configure::read('date_format'))));
			?>
			</td>
		</tr>
		<tr>
			<td width="250"><?php echo __('Comments',true); ?></td>
			<td><?php 
			echo $this->Form->textarea('SurgicalSiteInfection.comments', array('rows' => '5','cols' => '15', 'id' => 'comments', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
	</table>
	<div>&nbsp;</div>
	<div class="clr ht5"></div>
	<div class="btns">
		<?php echo $this->Html->link(__('Cancel'),array('controller'=>'hospital_acquire_infections','action'=>'surgical_site_infections',$patient['Patient']['id']),array('class'=>'blueBtn','div'=>false)); ?>
		<?php echo $this->Form->submit(__('Submit'), array('class'=>'blueBtn','div'=>false)); ?>
	</div>
	<?php echo $this->Form->end(); ?>
	<script>
$(document).ready(function(){
	    //script to include datepicker
            $(function() {
            //var dateminmax = new Date(new Date().getFullYear()-100, 0, 0)+':'+new Date(new Date().getFullYear()-20, 0, 0);
            $( "#date_of_last_contact" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
            dateFormat:'<?php echo $this->General->GeneralDate();?>',
            
		});		
		});
	});
</script>