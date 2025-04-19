<style>
.formError .formErrorContent{
width:60px;
}
.tabularForm {

    margin: 10px;
}
.tabularForm tr td .textBoxExpnd{
    width:50px;
}
</style>
 <div class="inner_title">
	<h3><?php echo __('Blood Transfusion Program Form - Edit'); ?></h3>
	<span> <?php  echo $this->Html->link(__('Back'), array('action' => 'patient_blood_transfusion_list', $patient['Patient']['id']), array('escape' => false,'class'=>"blueBtn"));?></span>
 </div>

<div class="clr ht5"></div>
<?php echo $this->element('patient_information');?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<?php echo $this->Form->create('PatientBloodSugarMonitoring');?>

<?php


?>
				<table width="98%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                      <tr>
                   		<th width="190">BLOOD TRANSFUSION NOTES</th>
                      </tr>
                      <tr>
                      		<td><textarea name="PatientBloodTransfusion[tranfusion_note]" id="tranfusion" style="width:98%"><?php echo $bloodTransusion['PatientBloodTransfusion']['tranfusion_note'];?></textarea> </td>
                      </tr>
                   </table>
                   <div class="clr ht5"></div>
                   <div class="clr ht5"></div>
                   <table width="98%" border="0" cellspacing="0" cellpadding="0" class="tdLabel2" style="margin:10px">
                   		<tr>
                       	  <td width="110">Consent taken :</td>
                            <td width="20"><input type="radio" name="PatientBloodTransfusion[is_consent_taken]" value="1" <?php if($bloodTransusion['PatientBloodTransfusion']['is_consent_taken'] == "1"){echo ' checked="checked"';}?>/></td>
                            <td width="30">Yes</td>
                            <td width="20"><input type="radio" name="PatientBloodTransfusion[is_consent_taken]" value="0" <?php if($bloodTransusion['PatientBloodTransfusion']['is_consent_taken'] == "0"){echo ' checked="checked"';}?>/></td>
                            <td width="20">No</td>
                            <td>&nbsp;</td>
                        </tr>
                   </table>
				   <?php
					$systemic_examination = unserialize($bloodTransusion['PatientBloodTransfusion']['systemic_examination']);
				    $other_detail = unserialize($bloodTransusion['PatientBloodTransfusion']['other_detail']);

				   ?>
				 <div class="clr ht5"></div>
                   <table width="98%" border="0" cellspacing="0" cellpadding="0" class="tdLabel2" style="margin:10px">
                   		<tr>
                        	<td colspan="6" height="30">Systemic Examination</td>
                        </tr>
                        <tr>
                        	<td width="30">RS</td>
                            <td width="300"><input name="PatientBloodTransfusion[systemic_examination][rs]" type="text" class="textBoxExpnd" id="rs" style="width:300px;" value="<?php echo $systemic_examination['rs'];?>" /></td>
                            <td width="10">
                            <td width="30">CVS</td>
                            <td width="300"><input name="PatientBloodTransfusion[systemic_examination][cvs]" type="text" class="textBoxExpnd" id="cvs" style="width:300px;" value="<?php echo $systemic_examination['cvs'];?>" /></td>
                            <td>&nbsp;</td>
                        </tr>
                   		<tr>
                   		  <td>PA</td>
                   		  <td><input name="PatientBloodTransfusion[systemic_examination][pa]" type="text" class="textBoxExpnd" id="pa" style="width:300px;" value="<?php echo $systemic_examination['pa'];?>" /></td>
                   		  <td>
                   		  <td>CNS</td>
                   		  <td><input name="PatientBloodTransfusion[systemic_examination][cns]" type="text" class="textBoxExpnd" id="cns" style="width:300px;" value="<?php echo $systemic_examination['cns'];?>" /></td>
                   		  <td>&nbsp;</td>
           		     </tr>
                   </table>
			   <div class="clr ht5"></div>
               <div class="clr ht5"></div>
			  <table width="98%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                      <tr>
                      		<th width="">PART A - (To be filled by Doctors)</th>
                      </tr>
                      <tr>
                      		<td>
                            	 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tdLabel2">
                                 	<tr>
                                    	<td width="100%">
                                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="230">Date and time of starting transfusion:<font color="red">*</font></td>
                                                    <td width="230">
                                                    	<table width="190" border="0" cellspacing="0" cellpadding="0" >
                                                          <tr>
                                                            <td width="150"><input name="PatientBloodTransfusion[transfusion_date]" type="text" class="textBoxExpnd validate[required]" id="transfusion_date" style="width:130px;" value="<?php echo $this->DateFormat->formatDate2local($bloodTransusion['PatientBloodTransfusion']['transfusion_date'],Configure::read('date_format'),true);?>"/></td>

                                                          </tr>
                                                      </table>                                                    </td>
                                                    <td width="60">Bag No.:<font color="red">*</font></td>
                                                    <td><input name="PatientBloodTransfusion[bag_no]" type="text" class="textBoxExpnd validate[required]" id="bag_no" style="width:150px;" value="<?php echo $bloodTransusion['PatientBloodTransfusion']['bag_no'];?>"/></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            </table>                                        </td>
                                    </tr>
                                    <tr>
                                    	<td width="100%">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="100">Blood Group:<font color="red">*</font></td>
                                            <td width="50">Patient</td>
                                            <td width="100">
													<select name="data[PatientBloodTransfusion][blood_group_patient]" class="textBoxExpnd validate[required]" id="blood_group_patient"  <?php if(!empty($blood_group)){echo " disabled=disabled";}?> style="width:80px">
											<option value="">Please Select</option>
											<option value="A+" <?php if($blood_group == "A+"){echo " selected=selected";}?>>A+</option>
											<option value="A-" <?php if($blood_group == "A-"){echo " selected=selected";}?>>A-</option>
											<option value="B+" <?php if($blood_group == "B+"){echo " selected=selected";}?>>B+</option>
											<option value="B-" <?php if($blood_group == "B-"){echo " selected=selected";}?>>B-</option>
											<option value="AB+" <?php if($blood_group == "AB+"){echo " selected=selected";}?>>AB+</option>
											<option value="AB-" <?php if($blood_group == "AB-"){echo " selected=selected";}?>>AB-</option>
											<option value="O+" <?php if($blood_group == "O+"){echo " selected=selected";}?>>O+</option>
											<option value="O-" <?php if($blood_group == "O-"){echo " selected=selected";}?>>O-</option>
											</select>



											</td>
                                            <td width="45">Doner</td>
                                            <td width="145">
												<select name="data[PatientBloodTransfusion][blood_group_donor]" class="textBoxExpnd validate[required]" id="blood_group_donor" style="width:80px">
											<option value="">Please Select</option>
											<option value="A+" <?php if($bloodTransusion['PatientBloodTransfusion']['blood_group_donor'] == "A+"){echo " selected=selected";}?>>A+</option>
											<option value="A-" <?php if($bloodTransusion['PatientBloodTransfusion']['blood_group_donor'] == "-A"){echo " selected=selected";}?>>A-</option>
											<option value="B+" <?php if($bloodTransusion['PatientBloodTransfusion']['blood_group_donor'] == "B+"){echo " selected=selected";}?>>B+</option>
											<option value="B-" <?php if($bloodTransusion['PatientBloodTransfusion']['blood_group_donor'] == "-B"){echo " selected=selected";}?>>B-</option>
											<option value="AB+" <?php if($bloodTransusion['PatientBloodTransfusion']['blood_group_donor'] == "AB+"){echo " selected=selected";}?>>AB+</option>
											<option value="AB-" <?php if($bloodTransusion['PatientBloodTransfusion']['blood_group_donor'] == "AB-"){echo " selected=selected";}?>>AB-</option>
											<option value="O+" <?php if($bloodTransusion['PatientBloodTransfusion']['blood_group_donor'] == "O+"){echo " selected=selected";}?>>O+</option>
											<option value="O-" <?php if($bloodTransusion['PatientBloodTransfusion']['blood_group_donor'] == "-O"){echo " selected=selected";}?>>O-</option>
											</select>


											</td>
                                            <td width="80">&nbsp;</td>
                                            <td width="190">&nbsp;</td>
                                            <td>&nbsp;</td>
                                          </tr>
                                        </table></td>
                                    </tr>
                                    <tr>
                                    	<td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="100">Expiry Date:<font color="red">*</font></td>
                                            <td width="260"><table width="200" border="0" cellspacing="0" cellpadding="0" >
                                              <tr>
                                                <td width="150"><input name="PatientBloodTransfusion[expiry_date]" type="text" class="textBoxExpnd validate[required]" id="expiry_date" style="width:120px;" value="<?php echo $this->DateFormat->formatDate2local($bloodTransusion['PatientBloodTransfusion']['expiry_date'],Configure::read('date_format'),false);?>"/></td>

                                              </tr>
                                            </table></td>
                                            <td width="70">&nbsp;</td>
                                            <td width="92" style="min-width:90px;">Clots, turbidity:</td>
                                            <td><input name="PatientBloodTransfusion[clot_or_turbidity]" type="text" class="textBoxExpnd" id="clot_or_turbidity" style="width:200px;" value="<?php echo $bloodTransusion['PatientBloodTransfusion']['clot_or_turbidity'];?>"/></td>
                                            <td>&nbsp;</td>
                                          </tr>
                                        </table></td>
                                    </tr>
                                    <tr>
                                    	<td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="22"><input type="checkbox" name="PatientBloodTransfusion[is_unusual_discoloration]" value="1" <?php if($bloodTransusion['PatientBloodTransfusion']['is_unusual_discoloration'] == "1"){echo " checked=checked";}?> id="is_unusual_discoloration"/></td>
                                            <td width="130">Unusual discoloration:</td>
                                            <td><input name="PatientBloodTransfusion[unusual_discoloration]" type="text" class="textBoxExpnd" id="unusual_discoloration" style="width:97%;<?php if($bloodTransusion['PatientBloodTransfusion']['is_unusual_discoloration'] == "1"){echo " display:inline;";}else{ echo " display:none;";}?> " value="<?php echo $bloodTransusion['PatientBloodTransfusion']['unusual_discoloration'];?>" id="unusual_discoloration"/></td>
                                          </tr>
                                        </table></td>
                                    </tr>
                                    <tr>
                                    	<td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="22"><input type="checkbox" name="PatientBloodTransfusion[is_premedication_given]" value="1" <?php if($bloodTransusion['PatientBloodTransfusion']['is_premedication_given'] == "1"){echo " checked=checked";}?> id="is_premedication_given"/></td>
                                            <td width="130">Premedication given:</td>
                                            <td><input name="PatientBloodTransfusion[premedication_given]" type="text" class="textBoxExpnd" id="premedication_given" style="width:97%;<?php if($bloodTransusion['PatientBloodTransfusion']['is_premedication_given'] == "1"){echo " display:inline;";}else{ echo " display:none;";}?>" value="<?php echo $bloodTransusion['PatientBloodTransfusion']['premedication_given'];?>" id="premedication_given"/></td>
                                          </tr>
                                        </table></td>
                                    </tr>
                                    <tr>
                                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="152">To transfuse @</td>
                                          <td width="260"><input name="PatientBloodTransfusion[to_transfuse]" type="text" class="textBoxExpnd" id="to_transfuse" style="width:200px;" value="<?php echo $bloodTransusion['PatientBloodTransfusion']['to_transfuse'];?>"/></td>
                                          <td width="200">Time of termination of transfusion<font color="red">*</font></td>
                                          <td><input name="PatientBloodTransfusion[time_termination_of_tranfusion]" type="text" class="textBoxExpnd validate[required]" id="time_termination_of_tranfusion" style="width:105px;" value="<?php echo $this->DateFormat->formatDate2local($bloodTransusion['PatientBloodTransfusion']['time_termination_of_tranfusion'],Configure::read('date_format'),true);?>"/></td>
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

                   <table   border="0" class="tabularForm" width="98%"  >
                   		<tr>
                        	<th colspan="9">PART B</th>
                        </tr>
                        <tr>
                       	  	<td width="110">&nbsp;</td>
                            <td width="120"><strong>Vitals</strong></td>
                            <td width="140" valign="middle" align="center"><strong>At Commencement</strong></td>
                            <td width="90" valign="top" align="center"><strong>Next 15 min</strong></td>
                            <td width="70" valign="middle" align="center"><strong>Next</strong></td>
                            <td width="70" valign="middle" align="center"><strong>Next</strong></td>
                            <td width="70" valign="middle" align="center"><strong>Next</strong></td>
                            <td width="70" valign="middle" align="center"><strong>Next</strong></td>
                          	<td width="90" valign="middle" align="center"><strong>At the end</strong></td>
                        </tr>
                        <tr>
                          <td>Temp (/F)</td>
                          <td><input name="PatientBloodTransfusion[other_detail][0]" type="text" class="textBoxExpnd" id="textfield14" value="<?php echo $other_detail['0'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][1]" type="text" class="textBoxExpnd" id="textfield15" value="<?php echo $other_detail['1'];?>"/></td>
                          <td valign="top" align="center"><input name="PatientBloodTransfusion[other_detail][2]" type="text" class="textBoxExpnd" id="textfield16"  value="<?php echo $other_detail['2'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][3]" type="text" class="textBoxExpnd" id="textfield17" value="<?php echo $other_detail['3'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][4]" type="text" class="textBoxExpnd" id="textfield18" value="<?php echo $other_detail['4'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][5]" type="text" class="textBoxExpnd" id="textfield19" value="<?php echo $other_detail['5'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][6]" type="text" class="textBoxExpnd" id="textfield20" value="<?php echo $other_detail['6'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][7]" type="text" class="textBoxExpnd" id="textfield21" value="<?php echo $other_detail['7'];?>"/></td>
                        </tr>
                        <tr>
                          <td>Pulse (/min)</td>
                          <td><input name="PatientBloodTransfusion[other_detail][8]" type="text" class="textBoxExpnd" id="textfield22"  value="<?php echo $other_detail['8'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][9]" type="text" class="textBoxExpnd" id="textfield23" value="<?php echo $other_detail['9'];?>"/></td>
                          <td valign="top" align="center"><input name="PatientBloodTransfusion[other_detail][10]" type="text" class="textBoxExpnd" id="textfield24" value="<?php echo $other_detail['10'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][11]" type="text" class="textBoxExpnd" id="textfield25" value="<?php echo $other_detail['11'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][12]" type="text" class="textBoxExpnd" id="textfield26" value="<?php echo $other_detail['12'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][13]" type="text" class="textBoxExpnd" id="textfield27" value="<?php echo $other_detail['13'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][14]" type="text" class="textBoxExpnd" id="textfield28" value="<?php echo $other_detail['14'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][15]" type="text" class="textBoxExpnd" id="textfield29" value="<?php echo $other_detail['15'];?>"/></td>
                        </tr>
                        <tr>
                          <td>BP (mm/hg)</td>
                          <td><input name="PatientBloodTransfusion[other_detail][16]" type="text" class="textBoxExpnd" id="textfield30"  value="<?php echo $other_detail['16'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][17]" type="text" class="textBoxExpnd" id="textfield31" value="<?php echo $other_detail['17'];?>"/></td>
                          <td valign="top" align="center"><input name="PatientBloodTransfusion[other_detail][18]" type="text" class="textBoxExpnd" id="textfield32" value="<?php echo $other_detail['18'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][19]" type="text" class="textBoxExpnd" id="textfield33" value="<?php echo $other_detail['19'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][20]" type="text" class="textBoxExpnd" id="textfield34" value="<?php echo $other_detail['20'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][21]" type="text" class="textBoxExpnd" id="textfield35" value="<?php echo $other_detail['21'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][22]" type="text" class="textBoxExpnd" id="textfield36" value="<?php echo $other_detail['22'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][23]" type="text" class="textBoxExpnd" id="textfield37" value="<?php echo $other_detail['23'];?>"/></td>
                        </tr>
                        <tr>
                          <td>RR (/min)</td>
                          <td><input name="PatientBloodTransfusion[other_detail][24]" type="text" class="textBoxExpnd" id="textfield38" value="<?php echo $other_detail['24'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][25]" type="text" class="textBoxExpnd" id="textfield39" value="<?php echo $other_detail['25'];?>"/></td>
                          <td valign="top" align="center"><input name="PatientBloodTransfusion[other_detail][26]" type="text" class="textBoxExpnd" id="textfield40" value="<?php echo $other_detail['26'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][27]" type="text" class="textBoxExpnd" id="textfield41" value="<?php echo $other_detail['27'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][28]" type="text" class="textBoxExpnd" id="textfield42" value="<?php echo $other_detail['28'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][29]" type="text" class="textBoxExpnd" id="textfield43" value="<?php echo $other_detail['29'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][30]" type="text" class="textBoxExpnd" id="textfield44" value="<?php echo $other_detail['30'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][31]" type="text" class="textBoxExpnd" id="textfield45" value="<?php echo $other_detail['31'];?>"/></td>
                        </tr>
                        <tr>
                          <td>Others</td>
                          <td><input name="PatientBloodTransfusion[other_detail][32]" type="text" class="textBoxExpnd" id="textfield46" value="<?php echo $other_detail['32'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][33]" type="text" class="textBoxExpnd" id="textfield47" value="<?php echo $other_detail['33'];?>"/></td>
                          <td valign="top" align="center"><input name="PatientBloodTransfusion[other_detail][34]" type="text" class="textBoxExpnd" id="textfield48" value="<?php echo $other_detail['34'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][35]" type="text" class="textBoxExpnd" id="textfield49" value="<?php echo $other_detail['35'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][36]" type="text" class="textBoxExpnd" id="textfield50" value="<?php echo $other_detail['36'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][37]" type="text" class="textBoxExpnd" id="textfield51" value="<?php echo $other_detail['37'];?>" /></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][38]" type="text" class="textBoxExpnd" id="textfield52" value="<?php echo $other_detail['38'];?>"/></td>
                          <td valign="middle" align="center"><input name="PatientBloodTransfusion[other_detail][39]" type="text" class="textBoxExpnd" id="textfield53" value="<?php echo $other_detail['39'];?>"/></td>
                        </tr>
                   </table>



                   <table  cellpadding="0" cellspacing="1" border="0" class="tabularForm" width="98%">
                   	<tr>
                    	<td width="600"><strong>Adverse events(if any) during BT</strong></td>
                        <td width="400"><strong>Action Taken</strong></td>
                    </tr>
                   	<tr>
                   	  <td><textarea name="PatientBloodTransfusion[adverse_events]" rows="5" class="textBoxExpnd" id="adverse_events" style="width:97%;"><?php echo $bloodTransusion['PatientBloodTransfusion']['adverse_events'];?></textarea></td>
                   	  <td><textarea name="PatientBloodTransfusion[action_taken]" rows="5" class="textBoxExpnd" id="action_taken" style="width:96%;"><?php echo $bloodTransusion['PatientBloodTransfusion']['action_taken'];?></textarea></td>
               	     </tr>
                   </table>

                   <div class="clr ht5"></div>
                   <table width="100%" cellpadding="0" cellspacing="0" border="0" class="tdLabel2">
                   		<tr>
                        	<td width="50" valign="top">Note:</td>
                            <td>1) Recommended transfusion timing. (PRC - 1hrs, FFP-1/2hr - 1 hr Platelets - 30 min, Cryoplatelet - 30 min.)<br />
                            2) In case of major transfusion reaction blood bag should be sealed. Blood sample and 1st voided urine sample of recipient along with the sealed blood bag should be sent to the blood bank.
                            </td>
                        </tr>
                   </table>
                   <!-- billing activity form end here -->
                    <div class="btns">
                         
						  <input type="button" value="Print" onclick="window.open('<?php echo
							   $this->Html->url(array('action' => 'patient_blood_transfusion',$patient['Patient']['id'],$bloodTransusion['PatientBloodTransfusion']['id'],true ));
							   ?>');"
								class="blueBtn">
								 <input type="Submit" value="Save" class="blueBtn" id="submitbtn"/>
                             
                     </div>
                    <!-- Right Part Template ends here -->                   </td>
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
			onSelect:function(){$(this).focus();}
			 
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
			onSelect:function(){$(this).focus();}
			 
		});
 $( "#expiry_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
              onSelect: function(date) {
             var expDate =date.split("/");
             var expiryDate = new Date(expDate[2],expDate[1]-1,expDate[0]);
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
			minDate: new Date(),
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
			onSelect:function(){$(this).focus();}
			 
		});
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#PatientBloodSugarMonitoringPatientBloodTransfusionForm").validationEngine();
	});
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
                }
            };

        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);

 </script>
