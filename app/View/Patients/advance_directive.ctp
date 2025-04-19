<?php 
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
?>
<?php echo $this->Html->script(array('jquery.signaturepad.min'));
  	echo $this->Html->css(array('jquery.signaturepad'));?>
<script>
    $(document).ready(function() {
      $('.sigPad').signaturePad();
    });
  </script>
<style>
.tdclass {
	padding-left: 10px;
}
</style>
<div class="inner_title">
	<h3>Advance Directive</h3>
	<span ><?php echo $this->Html->link(__('Back'),array('controller'=>'patients','action' => 'patient_information',$patientDetails['Patient']['id']), array('escape' => false,'class'=>'blueBtn'));?></span>
</div>

<?php echo $this->Form->create('advance_directive',array('type' => 'file','id'=>'advance_directive','inputDefaults' => array(
		'label' => false,'action'=> 'advance_directive',	'div' => false,	'error' => false))); ?>


<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody>
		<tr>
			<td width="49%" valign="top" align="left">
				<table width="100%" cellspacing="0" cellpadding="0" border="0"
					class="formFull">
					<tbody>
						<tr>
							<th colspan="3"><strong><?php echo __('Patient Information'); ?>
							</strong></th>
						</tr>
						<tr>
							<td width="19%" valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Name'); ?></td>
							<td width="30%"><?php echo $this->Form->input('AdvanceDirective.patient_name', array('class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'patient_name', 'value'=>$patientDetails['Patient']['lookup_name'],'label'=> false,'div' => false, 'error' => false,'readonly' => 'readonly')); ?>
							</td>
							<td></td>
		
						</tr>
						<tr>
							<td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Sex'); ?></td>
							<td align="left"><?php	echo $this->Form->input('AdvanceDirective.patient_sex', array('class'=>'textBoxExpnd','id' => 'patient_sex', 'value'=>$patientDetails['Patient']['sex'],'readonly' => 'readonly')); ?>
							</td>
						</tr>
						<tr>
							<td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Age'); ?></td>
							<td align="left"><?php echo $this->Form->input('AdvanceDirective.patient_age', array('class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd','id' => 'patient_age', 'value'=>$patientDetails['Patient']['age'], 'label'=> false,'div' => false, 'error' => false,'readonly' => 'readonly')); ?>
							</td>
						</tr>
						<tr>
							<td valign="middle" id="boxSpace" class="tdLabel"></td>
							<td align="left"><?php echo $this->Form->hidden('AdvanceDirective.patient_id', array('class' => 'validate[required,custom[mandatory-enter-only]]','type'=>'text','id' => 'patient_id', 
									'value'=>$patientDetails['Patient']['id'], 'label'=> false,'div' => false, 'error' => false,'readonly' => 'readonly','hiddenField' => true,)); ?>


							</td>
						</tr>

					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>


<table width="100%" cellspacing="0" cellpadding="0" border="0"
	class="formFull">
	<tbody>
		<tr>
			<th colspan="2" font-size="16px"><strong><?php echo __('Part 1. My Durable Power of Attorney for Health Care'); ?>
			</strong></th>
		</tr>


		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel" width="440px">I
				appoint this person to make decisions about my medical care if there
				ever comes a time when I cannot make those decision myself. I want
				the person I have appointed, my doctors, my family and others to be
				guided by the decisions I have made in the parts of the form that
				follows,</td>
		</tr>
	</tbody>
</table>


<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody>
		<tr>
			<td><table width="100%" cellspacing="0" cellpadding="0" border="0"
					class="formFull">
					<tbody>
						<tr>
						
						
						<tr>
							<td width="19%" valign="middle" id="boxSpace" class="tdLabel" width="19%"><?php echo __('Name'); ?><font
								color="red">*</font></td>
							<td width="30%"><?php echo $this->Form->input('AdvanceDirective.person1_name', array('id' => 'person1_name','class' => 'validate[required,custom[name],custom[onlyLetterSp]] textBoxExpnd', 'label'=> false,'value'=>$advanceData['AdvanceDirective']['person1_name'], 'div' => false, 'error' => false)); ?>
							</td><td></td>
						</tr>

						<tr>
							<td width="19%"valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Home telephone'); ?><font color="red">*</font>
							</td>
							<td width="30%" valign="middle" ><?php echo $this->Form->input('AdvanceDirective.p1home_telephone', array('id' => 'p1home_telephone', 'class' => 'validate[required,custom[phone]] textBoxExpnd','label'=> false,'value'=>$advanceData['AdvanceDirective']['p1home_telephone'],'div' => false, 'error' => false,'Maxlength'=>'20')); ?>
							</td>
						</tr>

						<tr>
							<td width="19%" valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Work telephone'); ?><font color="red">*</font>
							</td>
							<td width="30%" valign="middle"><?php echo $this->Form->input('AdvanceDirective.p1work_telephone', array('id' => 'p1work_telephone','class' => 'validate[required,custom[phone]] textBoxExpnd ', 'label'=> false,'div' => false,'value'=>$advanceData['AdvanceDirective']['p1work_telephone'], 'error' => false,'Maxlength'=>'20')); ?>
							</td>
						</tr>



						<tr>
							<td width="19%" valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address 1'); ?>
							</td>
							<td width="30%" valign="left" ><?php echo $this->Form->input('AdvanceDirective.p1address1', array('id' => 'p1address1', 'label'=> false,'value'=>$advanceData['AdvanceDirective']['p1address1'],'div' => false, 'error' => false, 'class'=>'textBoxExpnd'
							)); ?>
							</td>
						</tr>
						<tr>
							<td width="19%" valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address 2'); ?>
							</td>
							<td width="30%" valign="left" ><?php echo $this->Form->input('AdvanceDirective.p1address2', array('id' => 'p1address2', 'value'=>$advanceData['AdvanceDirective']['p1address2'],'label'=> false,'div' => false, 'error' => false, 'class'=>'textBoxExpnd'
							)); ?>
							</td>
						</tr>
				
				</table>
			</td>
		</tr>
	</tbody>
</table>



<table width="100%" cellspacing="0" cellpadding="0" border="0"
	class="formFull">
	<tbody>
		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel">If the person above
				cannot or will not make decisions for me, I appoint this person:</td>
		</tr>
	</tbody> 
</table>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody>
		<tr>
			<td><table width="100%" cellspacing="0" cellpadding="0" border="0"
					class="formFull">
					<tbody>
						<tr>
							<td width="19%"valign="middle" id="boxSpace" class="tdLabel" width="100px"><?php echo __('Name'); ?><font
								color="red">*</font>
							
							<td width="30%"valign="left"><?php echo $this->Form->input('AdvanceDirective.person2_name', array('id' => 'person2_name','class' => 'validate[required,custom[name],custom[onlyLetterSp]] textBoxExpnd', 'value'=>$advanceData['AdvanceDirective']['person2_name'],'label'=> false,'div' => false, 'error' => false)); ?>
							</td><td></td>
						</tr>

						<tr>
							<td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Home telephone'); ?><font color="red">*</font>
							</td>
							<td valign="left" ><?php echo $this->Form->input('AdvanceDirective.p2home_telephone', array('id' => 'p2home_telephone','class' => 'validate[required,custom[phone]] textBoxExpnd ','value'=>$advanceData['AdvanceDirective']['p2home_telephone'],'label'=> false,'div' => false, 'error' => false,'Maxlength'=>'20')); ?>
							</td>
						</tr>

						<tr>
							<td width="19%" valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Work telephone'); ?><font color="red">*</font>
							</td>
							<td width="30%" valign="left" ><?php echo $this->Form->input('AdvanceDirective.p2work_telephone', array('class' => 'validate[required,custom[phone]] textBoxExpnd ','id' => 'p2work_telephone', 'label'=> false,'value'=>$advanceData['AdvanceDirective']['p2work_telephone'],'div' => false, 'error' => false,'Maxlength'=>'20')); ?>
							</td>
						</tr>



						<tr>
							<td width="19%" valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address 1 '); ?>
							</td>
							<td width="30%" valign="left" ><?php echo $this->Form->input('AdvanceDirective.p2address1', array('id' => 'p2address1', 'label'=> false,'value'=>$advanceData['AdvanceDirective']['p2address1'],'div' => false, 'error' => false,'class'=>'textBoxExpnd'
							)); ?>
							</td>
						</tr>
						<tr>
							<td width ="19%"valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address 2'); ?>
							
							<td width="30%" valign="left"><?php echo $this->Form->input('AdvanceDirective.p2address2', array('id' => 'p2address2', 'label'=> false,'value'=>$advanceData['AdvanceDirective']['p2address2'],'div' => false, 'error' => false, 'class'=>'textBoxExpnd')); ?>
							</td>
						</tr>
					</tbody>

				</table>
		
		</tr>
	</tbody>
</table>

<table width="100%" cellspacing="0" cellpadding="0" border="0"
	class="formFull">
	<tbody>
		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel">I have not
				appointed anyone to make health care decisions for me in this or any
				other document.</td>
		</tr>
	</tbody>
</table>










<table width="100%" cellspacing="0" cellpadding="0" border="0"
	class="formFull">
	<tbody>
		<tr>
			<th colspan="2" font-size="16px"><strong><?php echo __(' Part 2. My Living Will'); ?>
			</strong></th>
		</tr>


<tr>

		<td valign="middle" id="boxSpace" class="tdLabel">These are my wishes
			for my future medical care if there ever comes a times when I can't
			make these decisions myself.</td>
		</tr>

		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('A. These are my wishes if I have a terminal condition,'); ?>
			</td>
		</tr>

		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel"><strong>Life-sustaining
					treatments</strong></td>
		</tr>

		<tr>
			<td width="140" valign="middle" id="boxSpace" class="tdLabel"></td>
		</tr>


		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel"><?php 

			if($advanceData['AdvanceDirective']['terminal_check1'] == 1){
	echo $this->Form->checkbox('AdvanceDirective.terminal_check1', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{
	echo $this->Form->checkbox('AdvanceDirective.terminal_check1');
}


//echo $this->Form->checkbox('terminal_check1',array('value'=>$patientDetails1['AdvanceDirective']['terminal_check1'])); 	?>
				I do not want life-sustaining treatment (including CPR) started. If
				life-sustaining treatments are started, I want them stopped.</td>
		</tr>

		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel"><?php 
			if($advanceData['AdvanceDirective']['terminal_check2'] == 1){
	echo $this->Form->checkbox('AdvanceDirective.terminal_check2', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{
	echo $this->Form->checkbox('AdvanceDirective.terminal_check2');
}

//echo $this->Form->checkbox('terminal_check2',array('value'=>$patientDetails1['AdvanceDirective']['terminal_check1'])); 	?>
				I want the life-sustaining treatments that my doctors think are best
				for me.</td>
			
		</tr>

		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel"><?php 

			if($advanceData['AdvanceDirective']['terminal_check3'] == 1){
  	echo $this->Form->checkbox('AdvanceDirective.terminal_check3', array('checked' => 'checked', 'disabled' => 'disabled'));
  }else{
  	echo $this->Form->checkbox('AdvanceDirective.terminal_check3');
  }


  //echo $this->Form->checkbox('terminal_check3',array('value'=>$patientDetails1['AdvanceDirective']['terminal_check3'])); 	?>
				Other wishes</td>
		
		</tr>

		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel"><strong>Artificial
					nutrition and hydration</strong></td>
		</tr>
		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel"><?php 
			if($advanceData['AdvanceDirective']['terminal_check4'] == 1){
	echo $this->Form->checkbox('AdvanceDirective.terminal_check4', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{
	echo $this->Form->checkbox('AdvanceDirective.terminal_check4');
}


//echo $this->Form->checkbox('terminal_check4',array('value'=>$patientDetails1['AdvanceDirective']['terminal_check4'])); 	?>
				I do not want artificial nutrition and hydration started if they
				would be the main treatments keep me alive. If artificial nutrition
				and hydration are started, I want them stopped.</td>
		</tr>

		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel"><?php 
			if($advanceData['AdvanceDirective']['terminal_check5'] == 1){
	echo $this->Form->checkbox('AdvanceDirective.terminal_check5', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{
	echo $this->Form->checkbox('AdvanceDirective.terminal_check5');
}



//echo $this->Form->checkbox('terminal_check5',array('value'=>$patientDetails1['AdvanceDirective']['terminal_check5'])); 	?>
				I do not want artificial nutrition and hydration started if they are
				main treatments keeping me alive.</td>
		</tr>
</tbody>
</table>





<table width="100%" cellspacing="0" cellpadding="0" border="0"
	class="formFull">
	<tr>
		<th colspan="2" font-size="16px"><strong><?php echo __(' Part 3. Other Wishes'); ?>
		</strong></th>
	</tr>
	<tbody>




		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel"><strong><?php echo __('A. Organ donation'); ?>
			</strong></td>
		</tr>

		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel"><?php 
			if($advanceData['AdvanceDirective']['organ_donate1'] == 1){
	echo $this->Form->checkbox('AdvanceDirective.organ_donate1', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{
	echo $this->Form->checkbox('AdvanceDirective.organ_donate1');
}

//echo $this->Form->checkbox('organ_donate1',array('value'=>$patientDetails1['AdvanceDirective']['organ_donate1'])); 	?>
				I do not wish to donate any of my organs or tissues.</td>
		</tr>


		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel"><?php
			if($advanceData['AdvanceDirective']['organ_donate2'] == 1){
	echo $this->Form->checkbox('AdvanceDirective.organ_donate2', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{
	echo $this->Form->checkbox('AdvanceDirective.organ_donate2');
}
//echo $this->Form->checkbox('organ_donate2',array('value'=>$patientDetails1['AdvanceDirective']['organ_donate2'])); 	?>
				I want to donate all of my organs and tissue.</td>
		</tr>

		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel">I only want to
				donate these organs and tissue.</td>
		</tr>
		<tr>
			<td width="41%" valign="left"><?php echo $this->Form->input('AdvanceDirective.organ_name', array('id' => 'organ_name', 'label'=> false,'div' => false,'value'=>$advanceData['AdvanceDirective']['organ_name'], 'class'=>'textBoxExpnd','style'=>'margin: 7px 0 0 19px; padding:5px','error' => false)); ?>
			</td><td width="40%"></td> 
		 </tr>

		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel"><strong><?php echo __('B. Autopsy'); ?>
			</strong></td>
		</tr>
		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel"><?php   if($advanceData['AdvanceDirective']['consent_for1'] == 1){
				echo $this->Form->checkbox('AdvanceDirective.consent_for1', array('checked' => 'checked', 'disabled' => 'disabled'));
			}else{
	echo $this->Form->checkbox('AdvanceDirective.consent_for1');
}
//echo $this->Form->checkbox('consent_for1'); 	?> I do not want an
				autopsy.</td>
		</tr>
		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel"><?php     if($advanceData['AdvanceDirective']['consent_for2'] == 1){
				echo $this->Form->checkbox('AdvanceDirective.consent_for2', array('checked' => 'checked', 'disabled' => 'disabled'));
			}else{
	echo $this->Form->checkbox('consent_for2');
}	?> I agree to an autopsy if my doctors wish it.</td>
		</tr>
		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel"><?php     if($advanceData['AdvanceDirective']['consent_for3'] == 1){
				echo $this->Form->checkbox('AdvanceDirective.consent_for3', array('checked' => 'checked', 'disabled' => 'disabled'));
			}else{
	echo $this->Form->checkbox('AdvanceDirective.consent_for3');
}	?> Other wishes.</td>
		</tr>

		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel"><strong><?php echo __('C. Other statement about your medical care'); ?>
			</strong></td>
		</tr>
		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel">If you wish to say
				more about any of the choices you have made or if you have any other
				statements to make about your medical care, you may do so on a
				separate piece of paper. If you do so, put here the number of pages
				you added:</td>
		</tr>
</tbody>
</table>





<table width="100%" cellspacing="0" cellpadding="0" border="0"
	class="formFull">
	<tbody>
		<tr>
			<th colspan="2" font-size="16px"><strong><?php echo __(' Part 4. Signatures'); ?>
			</strong></th>
		</tr>

		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel">You and two
				witnesses must sign this document before it will be legal.</td>
		</tr>

		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel"><strong><?php echo __('A. Your Signature'); ?>
			</strong></td>
		</tr>
		<tr>
			<td valign="middle" id="boxSpace" class="tdLabel">By my signature
				below, I show that I understnd the purpose and the effect of this
				document.</td>
		</tr>


		<table width="100%" cellspacing="0" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td><table width="100%" cellspacing="0" cellpadding="0" border="0"
							class="formFull">
							<tbody>
								<tr>
									<td width="187" valign="left" id="boxSpace" class="tdLabel"><?php echo __('Signature.'); ?><font
										color="red">*</font>
									</td>
									<td align="left"> <div >
                            	
                              
                                <div class="sigPad">
	                               <ul class="sigNav">
	                                <li class="drawIt" ><a href="#draw-it"><font color="white">Draw It</font></a></li>
	                                <li class="clearButton"><a href="#clear"><font color="white">Clear</font></a></li>
	                               </ul>
                                <div>
                                <div class="typed"></div>
                                 <canvas class="pad" width="290" height="150"></canvas>
                                 <?php echo $this->Form->input('AdvanceDirective.patient_output', array('type' =>'text', 'id' => 'output', 'class' =>'output validate[required,custom[mandatory-enter-only]]','style'=>'visibility:hidden')); ?>
                                 </div>
                               </div>  
                            
                               </div></td>
								</tr>

								<tr> 
									<td valign="left" id="boxSpace" class="tdLabel"><?php echo __('Address'); ?><font
										color="red">*</font>
									</td>
									<td width="33%" align=middle><?php echo $this->Form->input('AdvanceDirective.patient_address1', array('class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd','id' => 'patient_address1','value'=>$advanceData['AdvanceDirective']['patient_address1'], 'label'=> false,'div' => false, 'error' => false)); ?>
									</td><td></td>
								</tr>
								<tr>
									<td valign="middle" id="boxSpace" class="tdLabel">&nbsp;</td>
									<td align="left"><?php echo $this->Form->input('AdvanceDirective.patient_address2', array('id' => 'patient_address2', 'label'=> false,'div' => false,'value'=>$advanceData['AdvanceDirective']['patient_address1'], 'error' => false, 'class'=>'textBoxExpnd')); ?>
									</td>
								</tr>


								<tr>
									<td valign="left" id="boxSpace" class="tdLabel"><?php echo __('Date'); ?><font
										color="red">*</font>
									</td>
									<td align="left"><?php echo $this->Form->input('AdvanceDirective.patient_date', array('class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd','type' => 'text', 'id' => 'patient_date','value'=>$advanceData['AdvanceDirective']['patient_date'], 'label'=> false,'div' => false, 'error' => false)); ?>

									</td>
								</tr>
							</tbody>
						</table>


						<table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
							<tr>
								<td valign="middle" id="boxSpace" class="tdLabel"><strong><?php echo __('B. Your witnesses signature'); ?>
								</strong></td>
								
							</tr>
							<tr>
								<td valign="middle" id="boxSpace" class="tdLabel">I believe the
									person who has signed this advance directive to be of sound
									mind, that he/she signed or acknowledged this advance directive
									in my presence and that he/she appears not to be acting under
									pressure duress, fraud or undur influence. I am not related to
									the person making this advance directive by blood, marriage or
									adoption nor, to the best of my knowledge, am I named in
									his/her will. I am not the person appointed in this advance
									directive. I am not a health care provider or an employee of a
									health care provider who is now, or has been in the past,
									responsible for the care of the person making this advance
									directive.</td>
							</tr>
						</table>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
							<tbody>
								<tr>
									<td><table width="100%" cellspacing="0" cellpadding="0"
											border="0" class="formFull">
											<tbody>
												<tr>
													<th colspan="2"><?php echo __('Witness 1'); ?></th>
												</tr>
												<tr>
													<td width="178" valign="middle" id="boxSpace"
														class="tdLabel"><?php echo __('Signature.'); ?><font
										color="red">*</font></td>
													<td align="left"><div class="sigPad">
	                               <ul class="sigNav">
	                                <li class="drawIt" ><a href="#draw-it"><font color="white">Draw It</font></a></li>
	                                <li class="clearButton"><a href="#clear"><font color="white">Clear</font></a></li>
	                               </ul>
                                <div>
                                <div class="typed"></div>
                                 <canvas class="pad" width="290" height="150"></canvas>
                                 <?php echo $this->Form->input('AdvanceDirective.witnesses_output1', array('type' =>'text', 'id' => 'output','class'=>'output validate[required,custom[mandatory-enter-only]]','style'=>'visibility:hidden')); ?>
                                 </div>
                               </div></td>
												</tr>

												<tr>
													<td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address'); ?>
													</td>
													<td align="left"><?php echo $this->Form->input('AdvanceDirective.witness1_address1', array('id' => 'witness1_address1', 'label'=> false,'div' => false,'value'=>$advanceData['AdvanceDirective']['witness1_address1'], 'error' => false, 'class'=>'textBoxExpnd')); ?>
													</td>
												</tr>
												<tr>
													<td valign="middle" id="boxSpace" class="tdLabel">&nbsp;</td>
													<td align="left"><?php echo $this->Form->input('AdvanceDirective.witness1_address2', array('id' => 'witness1_address2', 'label'=> false,'div' => false,'value'=>$advanceData['AdvanceDirective']['witness1_address2'], 'error' => false, 'class'=>'textBoxExpnd')); ?>
													</td>
												</tr>


												<tr>
													<td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Date'); ?>
													</td>
													<td align="left"><?php echo $this->Form->input('AdvanceDirective.witness1_date', array('class'=>'textBoxExpnd','type' => 'text', 'id' => 'witness1_date', 'value'=>$advanceData['AdvanceDirective']['witness1_date'],'label'=> false,'div' => false, 'error' => false)); ?>

													</td>
												</tr>
											</tbody>
										</table></td>
										
									
								
									<td><table width="100%" cellspacing="0" cellpadding="0"
											border="0" class="formFull">
											<tbody>
												<tr>
													<th colspan="2"><?php echo __('Witness 2'); ?></th>
												</tr>
												<tr>
													<td width="178" valign="middle" id="boxSpace"
														class="tdLabel"><?php echo __('Signature.'); ?></td>
													<td align="left"><div class="sigPad">
	                               <ul class="sigNav">
	                                <li class="drawIt" ><a href="#draw-it"><font color="white">Draw It</font></a></li>
	                                <li class="clearButton"><a href="#clear"><font color="white">Clear</font></a></li>
	                               </ul>
                                <div>
                                <div class="typed"></div>
                                 <canvas class="pad" width="290" height="150"></canvas>
                                 <?php echo $this->Form->input('AdvanceDirective.witnesses_output2', array('type' =>'text', 'id' => 'output','class'=>'output','style'=>'visibility:hidden')); ?>
                                 </div>
                               </div></td>
												</tr>

												<tr>
													<td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address'); ?>
													</td>
													<td align="left"><?php echo $this->Form->input('AdvanceDirective.witness2_address1', array('id' => 'witness2_address1', 'label'=> false,'div' => false,'value'=>$advanceData['AdvanceDirective']['witness2_address1'], 'error' => false, 'class'=>'textBoxExpnd')); ?>
													</td>
												</tr>
												<tr>
													<td valign="middle" id="boxSpace" class="tdLabel">&nbsp;</td>
													<td align="left"><?php echo $this->Form->input('AdvanceDirective.witness2_address2', array('id' => 'witness2_address2', 'label'=> false,'div' => false,'value'=>$advanceData['AdvanceDirective']['witness2_address2'], 'error' => false, 'class'=>'textBoxExpnd')); ?>
													</td>
												</tr>


												<tr>
													<td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Date'); ?>
													</td>
													<td align="left"><?php echo $this->Form->input('AdvanceDirective.witness2_date', array('class'=>'textBoxExpnd','type' => 'text', 'id' => 'witness2_date', 'value'=>$advanceData['AdvanceDirective']['witness2_date'],'label'=> false,'div' => false, 'error' => false)); ?>

													</td>
												</tr>
											</tbody>
										</table></td>
										
						</table>
						<div class="btns">
							<input class="grayBtn" type="button" value="Clear"
								onclick="window.location='<?php echo $this->Html->url(array("controller" => $this->params['controller'],
                           	"action" => "advance_directive",$patientDetails['Patient']['id']));   // echo "<pre>"; print_r($patientDetails); exit;?>'">
							<input class="blueBtn" type="submit" value="Submit">
						</div>
		
		</table>

		</form>


</tbody></table>


		<script>
	
	$(document).ready(function(){
    
		jQuery("#advance_directive").validationEngine();
 	});
	
	
	
	
	
	$( "#patient_date" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: "-80:+0",			 
		dateFormat:'<?php echo $this->General->GeneralDate();?>',
		buttonText:'Date of Incident',
		onSelect: function(){
			var dateval = $("#intrinsic_date").val();
			var patientid = $("#patientid").val();
			$(this).focus();
			//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
           // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
			//alert($( "#intrinsic_date" ).val());
		}

	});
	
	
	
	
	
	$( "#witness1_date" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: "-80:+0",			 
		dateFormat:'<?php echo $this->General->GeneralDate();?>',
		buttonText:'Date of Incident',
		onSelect: function(){
			var dateval = $("#intrinsic_date").val();
			var patientid = $("#patientid").val();
			
			//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
           // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
			//alert($( "#intrinsic_date" ).val());
		}
	});
	
	
	
	
	
	
	
	
	
	$( "#witness2_date" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: "-80:+0",		 
		dateFormat:'<?php echo $this->General->GeneralDate();?>',
		buttonText:'Date of Incident',
		onSelect: function(){
			var dateval = $("#intrinsic_date").val();
			var patientid = $("#patientid").val();
			
			//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
           // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
			//alert($( "#intrinsic_date" ).val());
		}
	});</script>
