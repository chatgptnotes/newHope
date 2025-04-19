<div class="inner_title">
	<h3>
		<?php //echo __('Informed Consent to Surgery or Special Procedure');
echo __('Add Interpreter Statement Form');
?></h3>
<span>
	<?php 
		echo $this->Html->link(__('Back'),'javascript:void(0);', array('escape' => false,'class'=>"blueBtn Back"));
	?>
</span>
</div>
<div class="patient_info">
	<?php //echo $this->element('patient_information');?>
</div>
<div class="clr"></div>
<p class="ht5"></p>
<form name="interpreterstatefrm" id="interpreterstatefrm"
	action="<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "add_interpreter_statement", $patient_id)); ?>"
	method="post">
	<?php 
	echo $this->Form->input('InterpreterStatement.patient_id', array('type' => 'hidden', 'value'=> $patient_id, 'id' => 'patient_id'));
	?>
	<table width="100%" cellpadding="0" cellspacing="0" border="0"
		class="tdLabel2">
		<tr>
			<td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="60">Surgery</td>
						<td><?php echo $this->Form->input('InterpreterStatement.surgery_id', array('empty'=>__('Please Select'),'options'=>$surgeries, 'id' => 'surgery_id', 'label'=> false, 'style'=> 'width:300px;')); ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width="100%" height="25" align="left" valign="top">I have
				accurately and completely reviewed the foregoing document with
				the(patient or patient's legal representative)</td>
		</tr>
		<tr>
			<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="300"><?php 
						echo $this->Form->input('InterpreterStatement.patient_primary_lang', array('label'=> false,'class' => 'textBoxExpnd','id' => 'patient_primary_lang'));
						?>
						</td>
						<td>in the patient's or legal representative's primary language</td>
					</tr>
					<tr>
						<td><?php 
						echo $this->Form->input('InterpreterStatement.patient_identify_lang', array('label'=> false,'class' => 'textBoxExpnd','id' => 'patient_identify_lang'));
						?>
						</td>
						<td>(indentify language). He/She understood all of the terms and
							conditions and</td>
					</tr>
				</table></td>
		</tr>
		<tr>
			<td style="padding: 10px 0 25px 0;">acknowledged his/her agreement by
				signing the document in my presence.</td>
		</tr>
		<tr>
			<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="90">Date & Time:</td>
						<td style="padding-left: 10px"><?php 
						echo $this->Form->input('InterpreterStatement.date_time', array('type'=> 'text','label'=> false, 'class' => 'textBoxExpnd','id' => 'date_time', 'style'=> 'width: 170px;'));
						?>
						</td>
					</tr>
				</table></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="70">Name:</td>
						<td width="300" style="padding-left: 30px"><?php 
						echo $this->Form->input('InterpreterStatement.patient_name', array('label'=> false,'class' => 'textBoxExpnd','id' => 'patient_name'));
						?>
						</td>
						<td></td>
					</tr>
					<tr>
						<td>RN Name:</td>
						<td width="300" style="padding-left: 30px"><?php 
						echo $this->Form->input('InterpreterStatement.patient_rn_name', array('label'=> false,'class' => 'textBoxExpnd','id' => 'patient_rn_name'));
						?>
						</td>
						<td></td>
					</tr>
				</table></td>
		</tr>
		<tr>
			<td height="40">&nbsp;</td>
		</tr>
		<tr>
			<td><div class="inner_title">
					<h3>Physician Certification</h3>
				</div>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>I, the undersigned physician, hereby certify that I have
				discussed the procedure described in the consent for with this
				patient (or the patient's legal representative), including:</td>
		</tr>
		<tr>
			<td><ul style="margin-left: -22px;">
					<li>The nature of the operation or procedure, including the
						surgical site and laterality if applicable</li>
					<li>The risks and benefits or effects of the procedure</li>
					<li>Any adverse reactions that may reasonably be expected to occur</li>
					<li>Any alternative efficacious methods of treatment which may be
						medically viable and their associated benefits or effects, and
						their possible risks and complications</li>
					<li>The potential problems that may occur during recuperation</li>
					<li>The likelihood of achieving treatment goals</li>
					<li>Any research or economic interest I may have regarding this
						treatment</li>
					<li>Any limitations on the confidentiality of information learned
						from or about the patient</li>
				</ul></td>
		</tr>

		<tr>
			<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="100">Date & Time:</td>
						<td><?php 
						echo $this->Form->input('InterpreterStatement.physician_date_time', array('type'=> 'text','label'=> false, 'class' => 'textBoxExpnd','id' => 'physician_date_time', 'style'=> 'width: 170px;'));
						?>
						</td>
					</tr>
				</table></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><table width="100%" border="0" cellspacing="0" cellpadding="0">

					<tr>
						<td width="100px">Physician Name</td>
						<td ><?php 
						echo $this->Form->input('InterpreterStatement.physician_name', array('label'=> false,'class' => 'textBoxExpnd','id' => 'physician_name',style=>'width:250px'));
						?>
						</td>
						<td></td>
					</tr>
				</table></td>
		</tr>

	</table>


	<p class="clr ht5"></p>

	<p class="ht5"></p>
	<p class="clr ht5"></p>
	<div class="btns">
		<?php 
			//echo $this->Html->link(__('Cancel', true),array('action' => 'interpreter_statement', $patient_id), array('escape' => false,'class'=>'grayBtn'));
			echo $this->Html->link(__('Cancel', true),'javascript:void(0);', array('escape' => false,'class'=>'grayBtn Back'));
		 ?>
		<input type="submit" value="Submit" class="blueBtn" />
	</div>
</form>
<script>
jQuery(document).ready(function(){
      jQuery("#interpreterstatefrm").validationEngine();
      $( "#date_time" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
		});
      $( "#physician_date_time" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
		});
 });


$(".Back").click(function(){
	$.ajax({
		url: '<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "interpreter_statement", 'plugin' => false, $patient_id)); ?>',
		beforeSend:function(data){
			$('#busy-indicator').show();
		},
		success: function(data){
			$('#busy-indicator').hide();
			$("#render-ajax").html(data);
	     }
	});
 });
</script>
