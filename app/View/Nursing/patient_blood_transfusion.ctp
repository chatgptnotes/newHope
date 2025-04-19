<style>
.formError .formErrorContent {
	width: 60px;
}

.tabularForm {
	margin: 10px;
}

.tabularForm tr td .textBoxExpnd {
	width: 50px;
}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Blood Transfusion Program Form'); ?>
	</h3>
	<span><?php  echo $this->Html->link(__('Back'), array('action' => 'patient_blood_transfusion_list', $patient['Patient']['id']), array('escape' => false,'class'=>"blueBtn"));?>
	</span>
</div>

<div class="clr ht5"></div>
<?php echo $this->element('patient_information');?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<?php echo $this->Form->create('PatientBloodSugarMonitoring');?>
<table width="98%" border="0" cellspacing="1" cellpadding="0"
	class="tabularForm">
	<tr>
		<th width="190">BLOOD TRANSFUSION NOTES</th>
	</tr>
	<tr>
		<td><textarea name="PatientBloodTransfusion[tranfusion_note]"
				id="tranfusion" style="width: 98%"></textarea></td>
	</tr>
</table>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<table width="98%" border="0" cellspacing="0" cellpadding="0"
	class="tdLabel2" style="margin: 10px">
	<tr>
		<td width="110">Consent taken :</td>
		<td width="20"><input type="radio"
			name="PatientBloodTransfusion[is_consent_taken]" value="1"
			checked="checked" /></td>
		<td width="30">Yes</td>
		<td width="20"><input type="radio"
			name="PatientBloodTransfusion[is_consent_taken]" value="0" /></td>
		<td width="20">No</td>
		<td>&nbsp;</td>
	</tr>
</table>
<div class="clr ht5"></div>
<table width="98%" border="0" cellspacing="0" cellpadding="0"
	class="tdLabel2" style="margin: 10px">
	<tr>
		<td colspan="6" height="30">Systemic Examination</td>
	</tr>
	<tr>
		<td width="30">RS</td>
		<td width="300"><input
			name="PatientBloodTransfusion[systemic_examination][rs]" type="text"
			class="textBoxExpnd" id="rs" style="width: 300px;" value="" /></td>
		<td width="10">
		
		<td width="30">CVS</td>
		<td width="300"><input
			name="PatientBloodTransfusion[systemic_examination][cvs]" type="text"
			class="textBoxExpnd" id="cvs" style="width: 300px;" value="" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>PA</td>
		<td><input name="PatientBloodTransfusion[systemic_examination][pa]"
			type="text" class="textBoxExpnd" id="pa" style="width: 300px;"
			value="" /></td>
		<td>
		
		<td>CNS</td>
		<td><input name="PatientBloodTransfusion[systemic_examination][cns]"
			type="text" class="textBoxExpnd" id="cns" style="width: 300px;"
			value="" /></td>
		<td>&nbsp;</td>
	</tr>
</table>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<table width="98%" border="0" cellspacing="1" cellpadding="0"
	class="tabularForm">
	<tr>
		<th width="">PART A - (To be filled by Doctors)</th>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0"
				class="tdLabel2">
				<tr>
					<td width="100%">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="235">Date and time of starting transfusion :<font
									color="red">*</font>
								</td>
								<td width="230">
									<table width="190" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="162"><input
												name="PatientBloodTransfusion[transfusion_date]" type="text"
												class="textBoxExpnd validate[required,custom[mandatory-enter-only]]"
												id="transfusion_date" readonly='readonly' style='width:134px' /></td>

										</tr>
									</table>
								</td>
								<td width="215" align="right">Bag No. :<font color="red">*</font>
								</td>
								<td><input name="PatientBloodTransfusion[bag_no]" type="text"
									class="validate[required,custom[onlyLetterNumber]] textBoxExpnd"
									id="bag_no" style="width: 289px;" /></td>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td width="100%">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="245">Blood Group :<font color="red">*</font>
								<span style="margin-left: 76px;">Patient :</span>
								</td>
								
								<td width="151"><select
									name="data[PatientBloodTransfusion][blood_group_patient]"
									class="textBoxExpnd validate[required,custom[mandatory-select]]"
									id="blood_group_patient" 
									<?php if(!empty($blood_group)){echo " disabled=disabled";}?>
									style="width: 145px">
										<option value="">Please Select</option>
										<option value="A+"
										<?php if($blood_group == "A+"){echo " selected=selected";}?>>A+</option>
										<option value="A-"
										<?php if($blood_group == "A-"){echo " selected=selected";}?>>A-</option>
										<option value="B+"
										<?php if($blood_group == "B+"){echo " selected=selected";}?>>B+</option>
										<option value="B-"
										<?php if($blood_group == "B-"){echo " selected=selected";}?>>B-</option>
										<option value="AB+"
										<?php if($blood_group == "AB+"){echo " selected=selected";}?>>AB+</option>
										<option value="AB-"
										<?php if($blood_group == "AB-"){echo " selected=selected";}?>>AB-</option>
										<option value="O+"
										<?php if($blood_group == "O+"){echo " selected=selected";}?>>O+</option>
										<option value="O-"
										<?php if($blood_group == "O-"){echo " selected=selected";}?>>O-</option>
								</select>
								</td>
							</tr>
							<tr>
								<td width="245" align="right"><span style="margin-right: 34px;">Donor :</span></td>

								<td width="145"><select
									name="data[PatientBloodTransfusion][blood_group_donor]"
									class="textBoxExpnd validate[required,custom[mandatory-select]]"
									id="blood_group_donor" style="width: 280px">
										<option value="">Please Select</option>
										<option value="A+">A+</option>
										<option value="A-">A-</option>
										<option value="B+">B+</option>
										<option value="B-">B-</option>
										<option value="AB+">AB+</option>
										<option value="AB-">AB-</option>
										<option value="O+">O+</option>
										<option value="O-">O-</option>
								</select>
								</td>
								<td width="80">&nbsp;</td>
								<td width="190">&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td width="100%"><table width="100%" border="0" cellspacing="0"
							cellpadding="0">
							<tr>
								<td width="236">Expiry Date :<font color="red">*</font>
								</td>
								<td width="260"><table width="200" border="0" cellspacing="0"
										cellpadding="0">
										<tr>
											<td width="150"><input
												name="PatientBloodTransfusion[expiry_date]" type="text"
												class="textBoxExpnd validate[required,custom[mandatory-enter-only]]"
												id="expiry_date" style='width:134px' readonly='readonly'/></td>

										</tr>
									</table></td>

								<td width="185" style="min-width: 90px;" align="right">Clots,
									turbidity :</td>
								<td><input name="PatientBloodTransfusion[clot_or_turbidity]"
									type="text" class="textBoxExpnd" id="clot_or_turbidity"
									style="width: 290px;" /></td>
								<td>&nbsp;</td>
							</tr>
						</table></td>
				</tr>
				<tr>
					<td width="100%"><table width="100%" border="0" cellspacing="0"
							cellpadding="0">
							<tr>
								<td width="22"><input type="checkbox"
									name="PatientBloodTransfusion[is_unusual_discoloration]"
									value="1" id="is_unusual_discoloration" /></td>
								<td width="150">Unusual discoloration</td>
								<td><input name="PatientBloodTransfusion[unusual_discoloration]"
									type="text" class="textBoxExpnd" id="unusual_discoloration"
									style="width: 97%; display: none;" id="unusual_discoloration" />
								</td>
							</tr>
						</table></td>
				</tr>
				<tr>
					<td width="100%"><table width="100%" border="0" cellspacing="0"
							cellpadding="0">
							<tr>
								<td width="22"><input type="checkbox"
									name="PatientBloodTransfusion[is_premedication_given]"
									value="1" id="is_premedication_given" /></td>
								<td width="150">Premedication given</td>
								<td><input name="PatientBloodTransfusion[premedication_given]"
									type="text" class="textBoxExpnd" id="premedication_given"
									style="width: 97%; display: none;" id="premedication_given" />
								</td>
							</tr>
						</table></td>
				</tr>
				<tr>
					<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="245">To transfuse @</td>
								<td width="225"><input
									name="PatientBloodTransfusion[to_transfuse]" type="text"
									class="textBoxExpnd" id="to_transfuse" style="width:264px;" />
								</td>
								<td width="220">Time of termination of transfusion :<font
									color="red">*</font>
								</td>
								<td><input
									name="PatientBloodTransfusion[time_termination_of_tranfusion]"
									type="text"
									class="textBoxExpnd validate[required,custom[mandatory-enter-only]]"
									id="time_termination_of_tranfusion" style='width:134px' readonly='readonly' /></td>
								<td>&nbsp;</td>
							</tr>
						</table></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<div class="clr ht5"></div>
<div class="clr ht5"></div>

<table border="0" class="tabularForm" width="98%">
	<tr>
		<th colspan="9">PART B</th>
	</tr>
	<tr>
		<td width="110">&nbsp;</td>
		<td width="120" align="center"><strong>Vitals</strong></td>
		<td width="140" valign="middle" align="center"><strong>At Commencement</strong>
		</td>
		<td width="90" valign="top" align="center"><strong>Next 15 min</strong>
		</td>
		<td width="70" valign="middle" align="center"><strong>Next</strong></td>
		<td width="70" valign="middle" align="center"><strong>Next</strong></td>
		<td width="70" valign="middle" align="center"><strong>Next</strong></td>
		<td width="70" valign="middle" align="center"><strong>Next</strong></td>
		<td width="90" valign="middle" align="center"><strong>At the end</strong>
		</td>
	</tr>
	<tr>
		<td>Temp (/&#8457;)</td>
		<td align="center"><input
			name="PatientBloodTransfusion[other_detail][0]" type="text"
			class="validate[optional,custom[onlyNumber]] textBoxExpnd" style="width:134px"
			id="textfield14" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][1]" type="text"
			class="validate[optional,custom[onlyNumber]] textBoxExpnd" style="width:134px"
			id="textfield15" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][2]" type="text"
			class="validate[optional,custom[onlyNumber]] textBoxExpnd" style="width:134px"
			id="textfield16" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][3]" type="text"
			class="validate[optional,custom[onlyNumber]] textBoxExpnd" style="width:134px"
			id="textfield17" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][4]" type="text"
			class="validate[optional,custom[onlyNumber]] textBoxExpnd" style="width:134px"
			id="textfield18" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][5]" type="text"
			class="validate[optional,custom[onlyNumber]] textBoxExpnd" style="width:134px"
			id="textfield19" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][6]" type="text"
			class="validate[optional,custom[onlyNumber]] textBoxExpnd" style="width:134px"
			id="textfield20" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][7]" type="text"
			class="validate[optional,custom[onlyNumber]] textBoxExpnd" style="width:134px"
			id="textfield21" /></td>
	</tr>
	<tr>
		<td>Pulse (/min)</td>
		<td align="center"><input
			name="PatientBloodTransfusion[other_detail][8]" type="text"
			class="validate[optional,custom[onlyNumber]] textBoxExpnd" style="width:134px"
			id="textfield22" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][9]" type="text"
			class="validate[optional,custom[onlyNumber]] textBoxExpnd" style="width:134px"
			id="textfield23" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][10]" type="text"
			class="validate[optional,custom[onlyNumber]] textBoxExpnd" style="width:134px"
			id="textfield24" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][11]" type="text"
			class="validate[optional,custom[onlyNumber]] textBoxExpnd" style="width:134px"
			id="textfield25" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][12]" type="text"
			class="validate[optional,custom[onlyNumber]] textBoxExpnd" style="width:134px"
			id="textfield26" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][13]" type="text"
			class="validate[optional,custom[onlyNumber]] textBoxExpnd" style="width:134px"
			id="textfield27" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][14]" type="text"
			class="validate[optional,custom[onlyNumber]] textBoxExpnd" style="width:134px"
			id="textfield28" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][15]" type="text"
			class="validate[optional,custom[onlyNumber]] textBoxExpnd" style="width:134px"
			id="textfield29" /></td>
	</tr>
	<tr>
		<td>BP (mm/hg)</td>
		<td align="center"><input
			name="PatientBloodTransfusion[other_detail][16]" type="text"
			class="validate[optional,custom[bp]] textBoxExpnd" style="width:134px" id="textfield30" />
		</td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][17]" type="text"
			class="validate[optional,custom[bp]] textBoxExpnd" style="width:134px" id="textfield31" />
		</td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][18]" type="text"
			class="validate[optional,custom[bp]] textBoxExpnd" style="width:134px" id="textfield32" />
		</td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][19]" type="text"
			class="validate[optional,custom[bp]] textBoxExpnd" style="width:134px" id="textfield33" />
		</td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][20]" type="text"
			class="validate[optional,custom[bp]] textBoxExpnd" style="width:134px" id="textfield34" />
		</td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][21]" type="text"
			class="validate[optional,custom[bp]] textBoxExpnd" style="width:134px" id="textfield35" />
		</td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][22]" type="text"
			class="validate[optional,custom[bp]] textBoxExpnd" style="width:134px" id="textfield36" />
		</td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][23]" type="text"
			class="validate[optional,custom[bp]] textBoxExpnd" style="width:134px" id="textfield37" />
		</td>
	</tr>
	<tr>
		<td>RR (/min)</td>
		<td align="center"><input
			name="PatientBloodTransfusion[other_detail][24]" type="text"
			class="validate[optional,custom[integer]] textBoxExpnd" style="width:134px"
			id="textfield38" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][25]" type="text"
			class="validate[optional,custom[integer]] textBoxExpnd" style="width:134px"
			id="textfield39" /></td>
		<td valign="top" align="center"><input
			name="PatientBloodTransfusion[other_detail][26]" type="text"
			class="validate[optional,custom[integer]] textBoxExpnd" style="width:134px"
			id="textfield40" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][27]" type="text"
			class="validate[optional,custom[integer]] textBoxExpnd" style="width:134px"
			id="textfield41" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][28]" type="text"
			class="validate[optional,custom[integer]] textBoxExpnd" style="width:134px"
			id="textfield42" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][29]" type="text"
			class="validate[optional,custom[integer]] textBoxExpnd" style="width:134px"
			id="textfield43" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][30]" type="text"
			class="validate[optional,custom[integer]] textBoxExpnd" style="width:134px"
			id="textfield44" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][31]" type="text"
			class="validate[optional,custom[integer]] textBoxExpnd" style="width:134px"
			id="textfield45" /></td>
	</tr>
	<tr>
		<td>Others</td>
		<td align="center"><input
			name="PatientBloodTransfusion[other_detail][32]" type="text"
			class="textBoxExpnd" style="width:134px" id="textfield46" /></td>
		<td  width="19%"valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][33]" type="text"
			class="textBoxExpnd" style="width:134px" id="textfield47" /></td>
		<td valign="top" align="center"><input
			name="PatientBloodTransfusion[other_detail][34]" type="text"
			class="textBoxExpnd" style="width:134px" id="textfield48" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][35]" type="text"
			class="textBoxExpnd" style="width:134px" id="textfield49" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][36]" type="text"
			class="textBoxExpnd" style="width:134px" id="textfield50" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][37]" type="text"
			class="textBoxExpnd" style="width:134px" id="textfield51" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][38]" type="text"
			class="textBoxExpnd" style="width:134px" id="textfield52" /></td>
		<td valign="middle" align="center"><input
			name="PatientBloodTransfusion[other_detail][39]" type="text"
			class="textBoxExpnd" style="width:134px" id="textfield53" /></td>
	</tr>
</table>



<table cellpadding="0" cellspacing="1" border="0" class="tabularForm"
	width="98%">
	<tr>
		<td width="600"><strong>Adverse events(if any) during BT</strong></td>
		<td width="400"><strong>Action Taken</strong></td>
	</tr>
	<tr>
		<td><textarea name="PatientBloodTransfusion[adverse_events]" rows="5"
				class="textBoxExpnd" id="adverse_events" style="width: 97%;"></textarea>
		</td>
		<td><textarea name="PatientBloodTransfusion[action_taken]" rows="5"
				class="textBoxExpnd" id="action_taken" style="width: 96%;"></textarea>
		</td>
	</tr>
</table>

<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	class="tdLabel2">
	<tr>
		<td width="50" valign="top">Note:</td>
		<td>1) Recommended transfusion timing. (PRC - 1hrs, FFP-1/2hr - 1 hr
			Platelets - 30 min, Cryoplatelet - 30 min.)<br /> 2) In case of major
			transfusion reaction blood bag should be sealed. Blood sample and 1st
			voided urine sample of recipient along with the sealed blood bag
			should be sent to the blood bank.
		</td>
	</tr>
</table>
<!-- billing activity form end here -->
<div class="btns">
	<input type="Submit" value="Save" class="blueBtn" id="submitbtn" />

</div>
<!-- Right Part Template ends here -->
</td>
</table>
<!-- Left Part Template Ends here -->

</div>
</td>
<td width="5%">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td class="footStrp">&nbsp;</td>
	<td>&nbsp;</td>
</tr>
</table>
<?php echo $this->Form->end();?>

<script>
$("#is_unusual_discoloration").click(function(){
	if($(this).attr("checked")){
		$("#unusual_discoloration").show();
	}else{
		$("#unusual_discoloration").hide();	
	}
});
$("#is_premedication_given").click(function(){
	if($(this).attr("checked")){
		$("#premedication_given").show();
	}else{
		$("#premedication_given").hide();	
	}
});
 $( ".datetime" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate("HH:mm");?>',
			minDate: new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']); ?>),
		});
 $( "#transfusion_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
              onSelect: function(date) {
                var trnsDateOnlyt = date.split(" ");
                var trnDate = trnsDateOnlyt[0].split("/");
                var transfusion_date =new Date(trnDate[2],trnDate[1]-1,trnDate[0]);
                $(this).focus();
             if($("#expiry_date").val() != ""){
             var expDate =$("#expiry_date").val().split("/");
             var expiryDate = new Date(expDate[2],expDate[1]-1,expDate[0]);

                if (expiryDate < transfusion_date || expiryDate == transfusion_date ) {
                      alert ("Expiry Date should be prior to Transfusion Date." ) ;
                      $("#submitbtn").attr('disabled','disabled');
                      return false;
                   }else{
                        $("#submitbtn").removeAttr('disabled');
                   }
             }
              $("#submitbtn").removeAttr('disabled');

        },
			dateFormat:'<?php echo $this->General->GeneralDate("HH:mm");?>',
			minDate: new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']); ?>),
			
		});
 $( "#expiry_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
             onSelect: function(date) {
             var expDate =date.split("/");
             var expiryDate = new Date(expDate[2],expDate[1]-1,expDate[0]);
             $(this).focus();
             if($("#transfusion_date").val() != ""){
                var trnsDateOnlyt =$("#transfusion_date").val().split(" ");
                var trnDate = trnsDateOnlyt[0].split("/");
                var transfusion_date =new Date(trnDate[2],trnDate[1]-1,trnDate[0]);
                if (expiryDate < transfusion_date  || expiryDate == transfusion_date ) {
                      alert ("Expiry Date should be prior to Transfusion Date." ) ;
                      $("#submitbtn").attr('disabled','disabled');
                      return false;
                   }else{
                            $("#submitbtn").removeAttr('disabled');
                   }
             }
              $("#submitbtn").removeAttr('disabled');

        },
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			minDate: new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']); ?>),
		});
 $( "#time_termination_of_tranfusion" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate("HH:mm");?>',
			minDate: new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']); ?>),
			onSelect:function(){$(this).focus();}
		});
 jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#PatientBloodSugarMonitoringPatientBloodTransfusionForm").validationEngine();
	});
/*
(function($){
    $.fn.validationEngineLanguage = function(){
    };
    $.validationEngineLanguage = {
        newLang: function(){
            $.validationEngineLanguage.allRules = {
                "required": { // Add your regex rules here, you can take telephone as an example
                    "regex": "none",
                    "alertText":"Required.",
                    "alertTextCheckboxMultiple": "* Please select an option",
                    "alertTextCheckboxe": "* This checkbox is required"
                },
                "onlyNumberSp": {
                    "regex": "/^[0-9\ ]+$/",
                    "alertText": "Numbers only"
                },
            
            };

        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);
*/
 </script>
