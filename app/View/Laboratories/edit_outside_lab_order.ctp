<?php
echo $this->Html->script ( array (
		'jquery-1.5.1.min',
		'validationEngine.jquery',
		'jquery.validationEngine',
		'/js/languages/jquery.validationEngine-en',
		'jquery-ui-1.8.16.custom.min',
		'ui.datetimepicker.3.js' 
) );
echo $this->Html->css ( array (
		'datePicker.css',
		'jquery-ui-1.8.16.custom',
		'validationEngine.jquery.css',
		'jquery.ui.all.css',
		'internal_style.css' 
) );
?>
<?php

echo $this->Form->create ( 'OutsideLabOrder', array (
		'type' => 'file',
		'id' => 'OutsideLabOrder',
		'inputDefaults' => array (
				'label' => false,
				'div' => false,
				'error' => false,
				'legend' => false,
				'fieldset' => false 
		) 
) );
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Lab Requisition") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Doctor Name/Contact Person");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('doctor_name', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'doctor_name')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Adddress");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('address', array('type'=>'textarea','rows'=>'3','label'=>false,'style'=>'width:250px','id' => 'address')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Facility/Clinic Name");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('facility_name', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'facility_name')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Lab Order");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('laboratory_id', array('empty'=>'Please Select','options'=>$labTest,'label'=>false,'style'=>'width:250px','id' => 'laboratory_id')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("MRN");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('registration_number', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'registration_number')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("First Name");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('first_name', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'first_name')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Last Name");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('last_name', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'last_name')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Date of Birth");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('dob', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'dob','value'=>$this->DateFormat->formatDate2Local($this->request->data['OutsideLabOrder']['dob'],Configure::read('date_format_us'),false))); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Sex");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('sex', array('style'=>'width:250px','options'=>array(''=>__('Please Select Gender'),'Male'=>__('Male'),'Female'=>__('Female'),'Ambiguous'=>__('Ambiguous'),'Not applicable'=>__('Not applicable'),'Unknown'=>__('Unknown'),'Other'=>__('Other')),'class' => 'textBoxExpnd','id' => 'sex','selected'=>$this->request->data['OutsideLabOrder']['sex'])); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Date of Requisition");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('date_of_requisition', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'date_of_requisition','value'=>$this->DateFormat->formatDate2Local($this->request->data['OutsideLabOrder']['date_of_requisition'],Configure::read('date_format_us'),true))); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("No. of Orders");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('no_of_orders', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'no_of_orders')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Received From");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'received_from', array (
				'style' => 'width:250px',
				'options' => array (
						'InPatient Setting' => __ ( 'InPatient Setting' ),
						'Ambulatory Setting' => __ ( 'Ambulatory Setting' ),
						'ED Setting' => __ ( 'ED Setting' ) 
				),
				'class' => 'textBoxExpnd',
				'id' => 'received_from',
				'selected' => $this->request->data ['OutsideLabOrder'] ['received_from'] 
		) );
		
		?>
		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Clinical Lab Result");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'clinical_lab_result', array (
				'type' => 'text',
				'label' => false,
				'style' => 'width:250px',
				'id' => 'clinical_lab_result' 
		) );
		echo $this->Form->hidden ( 'id', array (
				'type' => 'text',
				'label' => false,
				'style' => 'width:250px',
				'id' => 'id' 
		) );
		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Clinical Result Confirmed");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'confirm_result', array (
				'style' => 'width:250px',
				'options' => array (
						'0' => __ ( 'No' ),
						'1' => __ ( 'Yes' ) 
				),
				'class' => 'textBoxExpnd',
				'id' => 'confirm_result',
				'selected' => $this->request->data ['OutsideLabOrder'] ['confirm_result'] 
		) );
		
		?>
		</td>
	</tr>


</table>
<input class="blueBtn" type=submit value="Submit" name="Submit"
	id="Submit">
<?php
echo $this->Html->link ( __ ( 'Cancel', true ), array (
		'controller' => 'laboratories',
		'action' => 'labOrderReceived' 
), array (
		'escape' => false,
		'class' => 'grayBtn' 
) );
?>
<?php echo $this->Form->end();?>
<script>
$(function() { 
	$( "#date_of_requisition" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,  		
		yearRange: '1950',			 
		dateFormat:'mm/dd/yy HH:II:SS',
	});

});
$(function() { 
	$( "#dob" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,  		
		yearRange: '1950',			 
		dateFormat:'mm/dd/yy',
	});

});
</script>