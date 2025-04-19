




<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __(' Patient XML', true); ?>
	</h3>
	<span> <?php echo $this->Html->link(__('Back'),array('action' => 'index' ), array('class'=>'blueBtn'));
			 ?>
	</span>


</div>
<?php

	echo $this->Form->create('Review',array('type' => 'file','name'=>'register','id'=>'personfrm','inputDefaults' => array('label' => false, 'div' => false, 'error' => false	))); 
	
	?>
<?php 
		  if(!empty($errors)) {
	?>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center background: none repeat scroll 0 0 #3E474A;">
	<tr>
		<td colspan="2" align="left" class="error">
			<?php 
		     foreach($errors as $errorsval){
		         echo $errorsval[0];
		         echo "<br />";
		     }
		   ?>
		</td>
	</tr>
</table>
<?php } ?>
<div class="inner_left">
	<?php //BOF new form design ?>
	<!-- form start here -->
	<div class="btns">
		<input class="blueBtn" type=submit value="Export"> <input
			class="blueBtn" name="reset" type="reset"
			onclick="resetForm('personfrm'); return false;" />



	</div>
	<div class="clr"></div>

	<!-- Patient Information start here -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr>
			<th colspan="5">
				<?php echo __("Form") ; ?>
			</th>
		</tr>
		<tr>
		<tr>
			
			<td valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __('Select User:');?>
			</td>
			<td>
			<?php echo $this->Form->input('user_name',array('empty'=>__('Select'),'options'=>$users,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','style'=>'width:550px'));?>
			</td>
		</tr>
		</tr>
		<tr>
			<td width="30%" valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __("Patient Name");?>
				<font color="red">*</font>
			</td>
			<td width="30%"><table width="100%" cellpadding="0"
					cellspacing="0" border="0">
					<tr>
						<td>
							<?php echo $this->Form->input('initial_id', array('empty'=>__('Select'),'options'=>$initails,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'initials','style'=>'width:80px')); ?>
						</td>
						<td>
							<?php echo $this->Form->input('patient_name', array('id' => 'patient_name')); ?>
						</td>
					</tr>
				</table></td>
			<td width="">&nbsp;</td>

		</tr>

		<tr>
			<td valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __('Type');?>
			</td>
			<td>
				<?php echo $this->Form->input('type_name', array('id' => 'type_name')); ?>
			</td>
			<td width="19%" class="tdLabel" id="boxSpace">
				<?php echo __('To :');?>
			</td>
			<td width="30%">
				<?php
                        	 $To = array('None'=>'None','Provider'=>'Provider','Patient'=>'Patient','Others'=>'Others');
                        	  echo $this->Form->input('to_person', array('style'=>'width:150px; float:left;','options'=>$To,'empty'=>__('Please select'), 'id'=>'to_person')); ?>
			</td>

			<td>&nbsp;</td>
		</tr>



	</table>

	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr>
			<th colspan="5">
				<?php echo __("Person Detail") ; ?>
			</th>
		</tr>
		<tr>
			<td valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __('First Name');?>
			</td>
			<td>
				<?php echo $this->Form->input('first_name', array('class' => 'textBoxExpnd','id' => 'first_name')); ?>
			</td>
			<td class="tdLabel" id="boxSpace">Last Name</td>
			<td>
				<?php echo $this->Form->input('last_name', array('class' => 'validate[required,custom[patient_last_name],custom[onlyLetterNumber]] textBoxExpnd','id' => 'last_name')); ?>
			</td>
			<td>&nbsp;</td>

		
		</tr>

		<tr>
			<td class="tdLabel" id="boxSpace">Add Line1</td>
			<td>
				<?php echo $this->Form->input('add_line1', array('class' => 'validate[required,custom[patient_last_name],custom[onlyLetterNumber]] textBoxExpnd','id' => 'add_line1')); ?>
			</td>
			<td class="tdLabel" id="boxSpace">Add Line2</td>
			<td>
				<?php echo $this->Form->input('add_line2', array('class' => 'validate[required,custom[patient_last_name],custom[onlyLetterNumber]] textBoxExpnd','id' => 'add_line2')); ?>
			</td>
		</tr>

		<tr>
			<td class="tdLabel" id="boxSpace">City</td>
			<td>
				<?php echo $this->Form->input('city', array('class' => 'validate[required,custom[patient_last_name],custom[onlyLetterNumber]] textBoxExpnd','id' => 'city')); ?>
			</td>
			<td class="tdLabel" id="boxSpace">Zip</td>
			<td>
				<?php echo $this->Form->input('zip', array('class' => 'validate[required,custom[patient_last_name],custom[onlyLetterNumber]] textBoxExpnd','id' => 'zip')); ?>
			</td>
		</tr>

		<tr>
			<td class="tdLabel" id="boxSpace">Work Tel</td>
			<td>
				<?php echo $this->Form->input('work_tel', array('class' => 'validate[required,custom[patient_last_name],custom[onlyLetterNumber]] textBoxExpnd','id' => 'work_tel')); ?>
			</td>
			<td class="tdLabel" id="boxSpace">Cell Phone</td>
			<td>
				<?php echo $this->Form->input('cell_phone', array('class' => 'validate[required,custom[patient_last_name],custom[onlyLetterNumber]] textBoxExpnd','id' => 'cell_phone')); ?>
			</td>
		</tr>

		<tr>
			<td class="tdLabel" id="boxSpace">Fax</td>
			<td>
				<?php echo $this->Form->input('fax', array('class' => 'validate[required,custom[patient_last_name],custom[onlyLetterNumber]] textBoxExpnd','id' => 'fax')); ?>
			</td>
			<td class="tdLabel" id="boxSpace">Email</td>
			<td>
				<?php echo $this->Form->input('email', array('class' => 'validate[required,custom[patient_last_name],custom[onlyLetterNumber]] textBoxExpnd','id' => 'email')); ?>
			</td>
		</tr>
	</table>

	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr>
			<th colspan="5">
				<?php echo __("Clinic Detail") ; ?>
			</th>
		</tr>

		<tr>
			<td class="tdLabel" id="boxSpace">Clinic Name</td>
			<td>
				<?php echo $this->Form->input('clinic_name', array('class' => 'validate[required,custom[patient_last_name],custom[onlyLetterNumber]] textBoxExpnd','id' => 'clinic_name')); ?>
			</td>
			<td class="tdLabel" id="boxSpace">Add Line1</td>
			<td>
				<?php echo $this->Form->input('clinic_add1', array('class' => 'validate[required,custom[patient_last_name],custom[onlyLetterNumber]] textBoxExpnd','id' => 'clinic_add1')); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace">Add Line2</td>
			<td>
				<?php echo $this->Form->input('clinic_add2', array('class' => 'validate[required,custom[patient_last_name],custom[onlyLetterNumber]] textBoxExpnd','id' => 'clinic_add2')); ?>
			</td>
			<td class="tdLabel" id="boxSpace">City</td>
			<td>
				<?php echo $this->Form->input('clinic_city', array('class' => 'validate[required,custom[patient_last_name],custom[onlyLetterNumber]] textBoxExpnd','id' => 'clinic_city')); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace">Zip</td>
			<td>
				<?php echo $this->Form->input('clinic_zip', array('class' => 'validate[required,custom[patient_last_name],custom[onlyLetterNumber]] textBoxExpnd','id' => 'clinic_zip')); ?>
			</td>
			<td class="tdLabel" id="boxSpace">Work Tel</td>
			<td>
				<?php echo $this->Form->input('clinic_tel', array('class' => 'validate[required,custom[patient_last_name],custom[onlyLetterNumber]] textBoxExpnd','id' => 'clinic_tel')); ?>
			</td>
		</tr>

		<tr>
			<td class="tdLabel" id="boxSpace">Fax</td>
			<td>
				<?php echo $this->Form->input('clinic_fax', array('class' => 'validate[required,custom[patient_last_name],custom[onlyLetterNumber]] textBoxExpnd','id' => 'clinic_fax')); ?>
			</td>
			<td valign="top" class="tdLabel" id="boxSpace">
				<?php echo __('Purpose');?>
			</td>
			<td>
				<?php echo $this->Form->textarea('purpose', array('class' => 'textBoxExpnd','id' => 'purpose','row'=>'3')); ?>
			</td>
		</tr>

		<div class="inner_left">
			<?php //BOF new form design ?>
			<!-- form start here -->
	</table>
	<div class="btns">
		<input class="blueBtn" type="submit" value="Export"> <input
			class="blueBtn" name="reset" type="reset"
			onclick="resetForm('personfrm'); return false;" />

	</div>
	<!-- Patient Information end here -->


	<script type="text/javascript">
		function resetForm(personfrm) {
			var myForm = document.getElementById(personfrm);

			for ( var i = 0; i < myForm.elements.length; i++) {
				if ('submit' != myForm.elements[i].type
						&& 'reset' != myForm.elements[i].type) {
					myForm.elements[i].checked = false;
					myForm.elements[i].value = '';
					myForm.elements[i].selectedIndex = 0;
				}
			}
		}
	</script>