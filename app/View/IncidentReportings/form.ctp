<script>
	$(function() {
			
	 $("#date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>',			
		});

		$("#visitDate").datepicker({
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
</script>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?></div>
  </td>
 </tr>
</table>
<?php } ?>
<div class="inner_title">
<center><h3>&nbsp; <?php echo __('Incident Reporting Form', true); ?></h3></center>

</div>
<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
	<tr>
		<td width="15%" valign="middle" align="left" id="boxSpace">Who was Harmed or Nearly Harmed(Circle One)?<font color="red">*</font></td>
	</tr>
	<tr>
		<td width="50%" align="left"><?php 
			$options = array('1'=>'Patient','2'=>'Employee','3'=>'Visitor','4'=>'Doctor');
			echo $this->Form->input('LaundryItem.harm', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, 'options'=>$options,'empty'=>'Please Select'));?></td>
	 </tr>
	 <tr>
		<td width="15%" valign="middle" align="left" id="boxSpace">Inpatient/Outpatient Incident<font color="red">*</font></td>
	</tr>
	<tr>
		<td width="50%" align="left"><?php 
			$options = array('1'=>'Inpatient','2'=>'Outpatient');
			echo $this->Form->input('LaundryItem.incident', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, 'options'=>$options,'empty'=>'Please Select'));?></td>
	 </tr>
	<tr>
		<td width="15%" valign="middle" align="left" id="boxSpace">How did you learn about the incident?(Check All the apply) <font color="red">*</font></td>
	</tr>
	<tr>
		<td width="50%" align="left"><?php 
			$options = array('1'=>'Witnessed/Involved',
							 '2'=>'Report by Patient',
							 '3'=>'Report by Family or Visitors',
							 '4'=>'Report by Another Staff Member',
							 '5'=>'Assesment after Incident',
							 '6'=>'Review of Record or Chart');
			echo $this->Form->input('LaundryItem.incident', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, 'options'=>$options,'empty'=>'Please Select'));?></td>
	 </tr>

	
	<tr>
		<td width="32%" valign="middle" align="left" id="boxSpace">Name of the person Affected<font color="red">*</font></td>
	</tr>
	<tr>
		<td width="50%" align="left">
			<table width="100%">
				<tr>
					<td width="13%" style="padding-right:8px;">First Name<font color="red">*</font></td>
				
					<td><?php echo $this->Form->input('LaundryItem.reg', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
					<td width="16%">Middle Name<font color="red">*</font></td>
					<td align="left">
					<?php echo $this->Form->input('LaundryItem.reg', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?>
					</td>
					<td width="13%" style="padding-right:9px;">Last Name<font color="red">*</font></td>
					<td><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
				</tr>
			</table>
		</td>
		
	 </tr>
	 <tr>
		
		<td width="50%" align="left">
			<table>
				<tr>
					<td style="padding-right:8px" width="11%">Reg No<font color="red">*</font></td>
				
					<td><?php echo $this->Form->input('LaundryItem.reg', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
					<td  width="12%" ><?php echo __('Sex'); ?><font color="red">*</font></td>
					<td align="left">
					<?php 
						$options = array('1'=>'Male','2'=>'Female');
						echo $this->Form->input('LaundryItem.incident', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, 'options'=>$options,'empty'=>'Please Select'));?>
					</td>
					<td width="15%" align="right">Age<font color="red">*</font></td>
					<td><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
				</tr>
			</table>
		</td>
		
	 </tr>
	</table>
	<table>
	 <tr>
		<td width="15%" valign="middle" align="left" id="boxSpace">Date of OP visit/Admission<font color="red">*</font></td>
	<!-- </tr>
	<tr> -->
		<td width="15%" valign="middle" align="left" id="boxSpace"><?php echo $this->Form->input('LaundryItem.reg', array('id' => 'visitDate', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	</tr>
	<tr>
		<td width="15%" valign="middle" align="left" id="boxSpace">Location of Incident<font color="red">*</font></td>
	<!-- </tr>
	<tr> -->
		<td width="50%" align="left"><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	 </tr>
	<tr>
		<td width="15%" valign="middle" align="left" id="boxSpace">Date of Incident<font color="red">*</font></td>
	<!-- </tr>
	<tr> -->	
		<td align="left"><?php echo $this->Form->input('LaundryItem.reg', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	</tr>
	<tr>
		
		<td width="15%" valign="middle" align="left" id="boxSpace">Time of Incident<font color="red">*</font></td>
	<!-- </tr>
	<tr> -->
		<td align="left"><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	</tr>
	<tr>
		<td width="15%" valign="middle" align="left" id="boxSpace" valign="top" colspan="2">Describe the incident in your own word?(Max. 1000 Charecters)<font color="red">*</font></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="left"><textarea rows="4" cols="4">Description Here</textarea></td>
		
	</tr>
	<tr>
		
		<td width="15%" valign="middle" align="left" id="boxSpace">Patient clinical Service/Specilty at the time of incident<font color="red">*</font></td>
	<!-- </tr>
	<tr> -->
		<td align="left"><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	</tr>
	<tr>
		
		<td width="15%" valign="middle" align="left" id="boxSpace">Who was the notified of the incident/<font color="red">*</font></td>
	<!-- </tr>
	<tr> -->
		<td align="left"><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	</tr>

	<tr>
		<td width="15%" valign="middle" align="left" id="boxSpace">Covering Consultant<font color="red">*</font></td>
	<!-- </tr>
	<tr> -->
		<td width="50%" align="left"><?php 
			$options = array('1'=>'YES','2'=>'NO','3'=>'N/A');
			echo $this->Form->input('LaundryItem.harm', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, 'options'=>$options,'empty'=>'Please Select'));?></td>
	 </tr>
	<tr>
		
		<td width="15%" valign="middle" align="left" id="boxSpace">Date<font color="red">*</font></td>
	<!-- </tr>
	<tr> -->
		<td align="left"><?php echo $this->Form->input('LaundryItem.age', array('id' => 'date', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	</tr>
	<tr>
		<td width="15%" valign="middle" align="left" id="boxSpace">Family Contact Number<font color="red">*</font></td>
	<!-- </tr>
	<tr> -->
		<td width="50%" align="left"><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	 </tr>
	 <tr>
		<td width="15%" valign="middle" align="left" id="boxSpace">Doctor Contact Number<font color="red">*</font></td>
	<!-- </tr>
	<tr> -->
		<td width="50%" align="left"><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	 </tr>
	 <tr>
		<td width="15%" valign="middle" align="left" id="boxSpace">Administrator Contact Number<font color="red">*</font></td>
	<!-- </tr>
	<tr> -->
		<td width="50%" align="left"><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	 </tr>
	 <tr>
		<td width="15%" valign="middle" align="left" id="boxSpace">Security Contact Number<font color="red">*</font></td>
	<!-- </tr>
	<tr> -->
		<td width="50%" align="left"><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	 </tr>
	 <tr>
		<td width="15%" valign="middle" align="left" id="boxSpace">Other Contact Number<font color="red">*</font></td>
	<!-- </tr>
	<tr> -->
		<td width="50%" align="left"><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	 </tr>
	 <tr>
		<td width="15%" valign="middle" align="left" id="boxSpace">Reporter's Role<font color="red">*</font></td>
	<!-- </tr>
	<tr> -->
		<td width="50%" align="left"><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	 </tr>
	 
	 <tr>
		<td width="15%" valign="middle" align="left" id="boxSpace">Person Submitting Report<font color="red">*</font></td>
	<!-- </tr>
	<tr> -->
		<td width="50%" align="left"><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	 </tr>
	 <tr>
		<td width="15%" valign="middle" align="left" id="boxSpace">Contact Number<font color="red">*</font></td>
	<!-- </tr>
	<tr> -->
		<td width="50%" align="left"><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	 </tr>
	<tr>
		<td width="15%" valign="middle" align="left" id="boxSpace">Recomendations<font color="red">*</font></td>
	<!-- </tr>
	<tr> -->
		<td width="50%" align="left"><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	 </tr>
 </table>
 
