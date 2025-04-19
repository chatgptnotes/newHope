<style>

</style>
<div class="inner_title">
	<h3>
		<?php //echo __('Informed Consent to Surgery or Special Procedure');
echo __('Add Surgery Consent Form');
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
<form name="consentfrm" id="consentfrm"
	action="<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "add_surgery_consentform")); ?>"
	method="post">
	<?php 
	echo $this->Form->input('ConsentForm.patient_id', array('type' => 'hidden', 'value'=> $patient_id, 'id' => 'patient_id'));
	?>
	<table width="100%" cellpadding="0" cellspacing="0" border="0"
		class="align_text">
		<tr>
			<td width="100"><font color="red">*</font><?php echo __('Surgery'); ?>:</td>
			<td><?php echo $this->Form->input('ConsentForm.surgery_id', array('empty'=>__('Please Select'),'options'=>$surgeries,'class' => 'validate[required,custom[mandatory-select]]', 'id' => 'surgery_id', 'label'=> false, 'style'=> 'width:300px;')); ?>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="tdLabel2">

		<tr>
			<td width="30" align="left" valign="top">1.</td>
			<td width="" class="align_text" valign="top" style="padding-bottom: 20px;">This
				form is called an &quot;Informed Consent Form&quot;. It is your
				doctor's obligation to provide you with the information you need in
				order to decide whether to consent to the surgery or special
				procedure that your doctors have recommended. <em><strong>The
						purpose of this form is to verify that you have recieved this
						information and have given your consent to the surgery or special
						procedure recommended to you</strong> </em>. You should read this
				form carefully and ask questions or your doctors so that you
				understand the operation or procedure before you decide whether or
				not to give your consent. If you have questions, you are encouraged
				and expected to ask them before you sign this form. Your doctors are
				not employees or agents of the hospital.They are independent
				practitioners.
			</td>
		</tr>
		<tr>
			<td width="30" align="left" valign="top">2.</td>
			<td width="" height="30" align="left" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="25" valign="top">Your Doctors have recommended the
							following operation or procedure <font color="red">*</font>:
						</td>
					</tr>
					<tr>
						<td><?php 
						echo $this->Form->textarea('ConsentForm.doctor_recommendation', array('class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd', 'cols' => '35', 'rows' => '5', 'id' => 'doctor_recommendation', 'label'=> false, 'div' => false, 'error' => false));
						?>
						</td>
					</tr>
					<tr>
						<td class="align_text" style="padding: 10px 0 20px 0;">Upon your authorization and
							consent, this operation or pocedure, together with any different
							or further procedures, which in the opinion of the doctor(s)
							performing the procedure, may be indicated due to any emergency,
							will be performed on you.The operation and procedures will be
							performed by the doctor(s) named below ( or in the event
							substitute doctor), together with associates and assistants,
							including anesthesiologists , pathologists and radiologists from
							the medical staff of Hope Hospital to whom the doctor(s)
							performing the procedure may assign designated
							responsibilities.The hospital maintains personnel and facilities
							to assist your doctors in their performance of various surgical
							operations and other special diagnostic or therapeutic
							procedures. However,the persons in attendance for the purpose of
							performing specialized medical services such as anesthisa,
							radiology, or pathology are not employees or agents of the
							hospital or of doctor(s) performing the procedure.They are
							independent medical practitioners.</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width="30" align="left" valign="top">3.</td>
			<td width="" height="20" class="align_text" valign="top"
				style="padding-bottom: 20px;">All operations and procedures carry
				the risk of unsuccessfull results, complications, injury or even
				death, from both known and unforeseen causes, and no warranty or
				guarantee is made as to result or cure. You have the right to be
				informed of:
				<ul style="margin-left: -22px;">
					<li>The nature of the operation or procedure , including other
						care, treatment or medications.</li>
					<li>Potential benfits, risks or side effects of the operation or
						procedure, including potential problems that might occur during
						recuperation.</li>
					<li>The likelihood of achieving treatment goals.</li>
					<li>Reasonable alternatives and the relevant risks, benefits and
						side effects related to such alternatives, including the possible
						results of not recieving care or treatment.</li>
					<li>Any independent medical research or significant interests your
						doctor may have related to the performance of the proposed
						operation or procedure.</li>
				</ul> Except in cases of emergency, operations or procedures are not
				performed until you have had the opportunity to recieve this
				information and have given your consent. You have the right to give
				or refuse consent to any proposed operation or procedure at any time
				prior to its performance.
			</td>
		</tr>
		<tr>
			<td align="left" valign="top">4.</td>
			<td height="20" class="align_text" valign="top"
				style="padding-bottom: 20px;">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="25" valign="top" class="align_text" style="padding-bottom: 10px;">By your
							signature below, you authorize the pathologist to use his or her
							discretion in disposition or use of any member, organ or tissue
							removed from your person during the operation or procedure set
							forth above, subject to the following conditions (if any)<font
							color="red">*</font>:
						</td>
					</tr>
					<tr>
						<td><?php 
						echo $this->Form->textarea('ConsentForm.conditions', array('class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd', 'cols' => '35', 'rows' => '3', 'id' => 'conditions', 'label'=> false, 'div' => false, 'error' => false));
						?>
						</td>
					</tr>

				</table>
			</td>
		</tr>
		<tr>
			<td align="left" valign="top">5.</td>
			<td height="20" align="left" valign="top"
				style="padding-bottom: 20px;">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="350" valign="top"><font color="red">*</font>The practitioner who will perform
							your procedure is:
						</td>
						<td valign="top"><?php echo $this->Form->input('ConsentForm.user_id', array('empty'=>__('Please Select'),'options'=>$doctors,'class' => 'validate[required,custom[mandatory-select]]','id' => 'user_id', 'label'=> false)); ?>

						</td>
					</tr>
					<tr>
						<td class="align_text" colspan="2">You have the right to be informed of each
							practitioner who will perform &quot; significant surgical
							tasks&quot; such as opening and closing, harvesting grafts,
							dissecting tissue, removing tissue, implanting devices, and
							altering tissues. You may discuss this with your physician.</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align="left" valign="top">6.</td>
			<td height="20" class="align_text" valign="top"
				style="padding-bottom: 20px;">If your doctor determines that there
				is a reasonable possibility that you may need a blood transfusion as
				a result of the surgery or procedure to which you are consenting,
				your doctor will inform you of this and will provide you with
				information concerning the benefits and risks of the various options
				for blood transfusion, including predonation by yourself or others.
				You also have the right to have adequate time before your procedure
				to arrange for predonation , but you can waive this right if you do
				not wish to wait.<br /> <br /> Transfusion of blood or blood
				products involves certain risks, including the transmission of
				disease such as hepatitis or Human Immunodeficiency Virus (HIV), and
				you have a right to consent or refuse to consent to any
				transfusion.You should discuss any questions that you may have about
				transfusions with your doctor.
			</td>
		</tr>
		<tr>
			<td align="left" valign="top">7.</td>
			<td height="20" class="align_text" valign="top"
				style="padding-bottom: 20px;">Your signature on this form indicates
				that: 1) You have read and understand the information provided in
				this form; 2) Your doctor has adequately explained to you the
				operation or procedure set forth above, along with the risks,
				benefits, and other information described above in this form; 3) You
				have had a chance to ask your doctors questions; 4) You have
				recieved all of the information you desire concerning the operation
				or procedure; 5) You authorize and consent to the performance of the
				operation or procedure.</td>
		</tr>
	</table>
	<p class="clr ht5"></p>
	<table width="100%" cellpadding="0" cellspacing="0" border="0"
		class="tdLabel2">
		<tr>
			<td width="100%">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="100" style="padding-left: 30px">Date & Time:</td>
						<td>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td><?php 
									echo $this->Form->input('ConsentForm.date_time', array('type'=> 'text','label'=> false, 'class' => 'textBoxExpnd','id' => 'date_time', 'style'=> 'width: 170px;'));
									?>
									</td>

								</tr>
							</table>
						</td>

					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td height="25" align="left" valign="top" style="padding-left: 30px">If signed by someone other
				than patient, indicate name relationship:</td>
		</tr>
		<tr>
			<td style="padding-left: 30px"><?php 
			echo $this->Form->input('ConsentForm.patient_relative', array('label'=> false,'class' => 'textBoxExpnd','id' => 'patient_relative','style'=>'width:250px'));
			?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="60" style="padding-left: 30px">Witness:</td>
						<td><?php 
						echo $this->Form->input('ConsentForm.witness', array('label'=> false,'class' => 'textBoxExpnd','id' => 'witness','style'=>'width:250px'));
						?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<p class="ht5"></p>
	<p class="clr ht5"></p>
	<div class="btns">
		<?php 
			//echo $this->Html->link(__('Cancel', true),array('action' => 'surgery_consentform', $patient_id), array('escape' => false,'class'=>'grayBtn')); 
			echo $this->Html->link(__('Cancel', true),'javascript:void(0);', array('escape' => false,'class'=>'grayBtn Back'));
		?>
		<input type="submit" value="Submit" class="blueBtn" />
	</div>
</form>
<script>
jQuery(document).ready(function(){
      jQuery("#consentfrm").validationEngine();
      $( "#date_time" ).datepicker({
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
		url: '<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "surgery_consentform", "admin" => false,'plugin' => false, $patient_id)); ?>',
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
