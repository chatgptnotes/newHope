<div style="float:right;" id="printButton">
	<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
</div>
<div class="clr ht5"></div>
<?php echo $this->element('print_patient_info');?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>

<style>
body {
margin:auto !important;
}
.page-break  { display: block; page-break-before: always; }
	.patientHub{width:70%;margin-left:20%}
	.boxBorder{border:1px solid #000000;}
	.boxBorderBot{border-bottom:1px solid #000000;}
	.boxBorderRight{border-right:1px solid #000000;}
	.tdBorderRtBt{border-right:1px solid #000000; border-bottom:1px solid #000000;}
	.tdBorderBt{border-bottom:1px solid #000000;}
	.tdBorderTp{border-top:1px solid #000000;}
	.tdBorderRt{border-right:1px solid #000000;}
	.tdBorderTpBt{border-bottom:1px solid #000000; border-top:1px solid #000000;}
	.tdBorderTpRt{border-top:1px solid #000000; border-right:1px solid #000000;}
	.columnPad{padding:5px;}
	.columnLeftPad{padding-left:5px;}
	.tbl{background:#CCCCCC;}
	.tbl td{background:#FFFFFF;}
	.totalPrice{font-size:14px;}
	.adPrice{border:1px solid #CCCCCC; border-top:0px; padding:3px;}
	input{cursor:pointer;}
</style>
 <div align="center">
	<h3><?php echo __('Blood Transfusion'); ?></h3>
 </div>
 <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>
    <td width="100%" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" height="25" align="left" valign="top" style="font-size:12px;"><strong>BLOOD TRANSFUSION PROGRAM NOTES</strong></td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="450" class="boxBorder" valign="top" style="padding:5px; ">&nbsp;<?php echo $bloodTransusion['PatientBloodTransfusion']['tranfusion_note'];?></td>
            <td width="5">&nbsp;</td>
            <td valign="top">
            	<table width="100%" cellpadding="5" cellspacing="0" border="0" class="boxBorder">
                	<tr>
                    	<td width="100%" class="tdBorderBt" style="padding:3px 10px;"><strong>PART A - (To be filled by Doctors)</strong></td>
                    </tr>
                    <tr>
                    	<td width="100%"  style="padding:5px 10px;">
                    	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="100%" align="left" valign="top">
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="160" height="23" valign="bottom">Date and time of starting transfusion :</td>
                                      <td valign="bottom" style="border-bottom:1px solid #000000;">&nbsp;<?php echo $this->DateFormat->formatDate2local($bloodTransusion['PatientBloodTransfusion']['transfusion_date'],Configure::read('date_format'),true);?></td>
                                    </tr>
                                  </table>                                </td>
                            </tr>
                            <tr>
                              <td width="100%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="65" height="23" valign="bottom">Bag No. :</td>
                                  <td valign="bottom" style="border-bottom:1px solid #000000;">&nbsp;<?php echo $bloodTransusion['PatientBloodTransfusion']['bag_no'];?></td>
                                </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td width="100%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="100" height="23" valign="bottom">Blood Group :</td>
                                  <td width="50" height="20" valign="bottom">Patient</td>
                                  <td width="65" valign="bottom" style="border-bottom:1px solid #000000;">&nbsp;<?php echo $blood_group;?></td>
                                  <td width="10">&nbsp;</td>
                                  <td width="40" height="20" valign="bottom">Doner</td>
                                  <td valign="bottom" style="border-bottom:1px solid #000000;">&nbsp;<?php echo $bloodTransusion['PatientBloodTransfusion']['blood_group_donor'];?></td>
                                </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td width="100%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="100" height="23" valign="bottom">Expiry Date :</td>
                                  <td valign="bottom" style="border-bottom:1px solid #000000;"><?php echo $this->DateFormat->formatDate2local($bloodTransusion['PatientBloodTransfusion']['expiry_date'],Configure::read('date_format'),false);?></td>
                                </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td width="100%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="110" height="23" valign="bottom">Clots, turbidity :</td>
                                  <td valign="bottom" style="border-bottom:1px solid #000000;">&nbsp;<?php echo $bloodTransusion['PatientBloodTransfusion']['clot_or_turbidity'];?></td>
                                </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="250" height="23" valign="bottom">Unusual discoloration (if any)</td>
                                  <td valign="bottom" style="border-bottom:1px solid #000000;word-wrap:break-word">&nbsp;<?php echo $bloodTransusion['PatientBloodTransfusion']['unusual_discoloration'];?></td>
                                </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="250" height="23" valign="bottom">Premedication given (if any)</td>
                                  <td valign="bottom" style="border-bottom:1px solid #000000;word-wrap:break-word">&nbsp;<?php echo $bloodTransusion['PatientBloodTransfusion']['premedication_given'];?></td>
                                </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="top" style="border-bottom:1px solid #000000;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="100" height="23" valign="bottom">To transfuse @</td>
                                  <td valign="bottom" style="border-bottom:1px solid #000000;">&nbsp;<?php echo $bloodTransusion['PatientBloodTransfusion']['to_transfuse'];?></td>
                                </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="160" height="23" valign="bottom">Time of termination of transfusion :</td>
                                  <td valign="bottom" style="border-bottom:1px solid #000000;">&nbsp;<?php echo $this->DateFormat->formatDate2local($bloodTransusion['PatientBloodTransfusion']['time_termination_of_tranfusion'],Configure::read('date_format'),true);?></td>
                                </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td align="left" valign="top">&nbsp;</td>
                            </tr>
                      </table></td>
                  </tr>
                </table>
            </td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" style="padding:10px 0;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="110">Consent taken :</td>
        <td width="100">&nbsp;
		<?php if($bloodTransusion['PatientBloodTransfusion']['is_consent_taken'])
			echo "Yes";
			else
				echo "No";
		?></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
   <?php
					$systemic_examination = unserialize($bloodTransusion['PatientBloodTransfusion']['systemic_examination']);
				    $other_detail = unserialize($bloodTransusion['PatientBloodTransfusion']['other_detail']);

   ?>
  <tr>
    <td width="100%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="">
      <tr>
        <td colspan="6">Systemic Examination</td>
      </tr>
      <tr>
        <td width="30" height="25" valign="bottom">RS</td>
        <td width="300" valign="bottom" style="border-bottom:1px solid #000000;">&nbsp;&nbsp;<?php echo $systemic_examination['rs'];?></td>
        <td width="10">&nbsp;</td>
        <td width="30" valign="bottom">CVS</td>
        <td width="300" valign="bottom" style="border-bottom:1px solid #000000;">&nbsp;&nbsp;<?php echo $systemic_examination['cvs'];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" valign="bottom">PA</td>
        <td valign="bottom" style="border-bottom:1px solid #000000;">&nbsp;&nbsp;<?php echo $systemic_examination['pa'];?></td>
        <td>&nbsp;</td>
        <td valign="bottom">CNS</td>
        <td valign="bottom" style="border-bottom:1px solid #000000;">&nbsp;&nbsp;<?php echo $systemic_examination['cns'];?></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
   <tr>
    <td width="100%" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top">

  </td>
  </tr>
   <tr>
    <td width="100%" align="left" valign="top">
    <table width="100%" cellpadding="5" cellspacing="0" border="0" class="boxBorder" style="border-bottom:none;">
      <tr>
        <th colspan="9" align="left" class="boxBorderBot">PART B</th>
      </tr>
      <tr>
        <td width="110" class="tdBorderRtBt">&nbsp;</td>
        <td width="120" class="tdBorderRtBt">Vitals</td>
        <td width="140" valign="middle" align="center" class="tdBorderRtBt">At Commencement</td>
        <td width="90" valign="top" align="center" class="tdBorderRtBt">Next 15 min</td>
        <td width="70" valign="middle" align="center" class="tdBorderRtBt">Next</td>
        <td width="70" valign="middle" align="center" class="tdBorderRtBt">Next</td>
        <td width="70" valign="middle" align="center" class="tdBorderRtBt">Next</td>
        <td width="70" valign="middle" align="center" class="tdBorderRtBt">Next</td>
        <td width="90" valign="middle" align="center" class="tdBorderBt">At the end</td>
      </tr>
      <tr>
        <td class="tdBorderRtBt">Temp (/F)</td>
        <td class="tdBorderRtBt">&nbsp;&nbsp;<?php echo $other_detail['0'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['1'];?></td>
        <td valign="top" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['2'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['3'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['4'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['5'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['6'];?></td>
        <td valign="middle" align="center" class="tdBorderBt">&nbsp;<?php echo $other_detail['7'];?></td>
      </tr>
      <tr>
        <td class="tdBorderRtBt">Pulse (/min)</td>
        <td class="tdBorderRtBt">&nbsp;<?php echo $other_detail['8'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['9'];?></td>
        <td valign="top" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['10'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['11'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['12'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['13'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['14'];?></td>
        <td valign="middle" align="center" class="tdBorderBt">&nbsp;<?php echo $other_detail['15'];?></td>
      </tr>
      <tr>
        <td class="tdBorderRtBt">BP (mm/hg)</td>
        <td class="tdBorderRtBt">&nbsp;<?php echo $other_detail['16'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['17'];?></td>
        <td valign="top" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['18'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['19'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['20'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['21'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['22'];?></td>
        <td valign="middle" align="center" class="tdBorderBt">&nbsp;<?php echo $other_detail['23'];?></td>
      </tr>
      <tr>
        <td class="tdBorderRtBt">RR (/min)</td>
        <td class="tdBorderRtBt">&nbsp;<?php echo $other_detail['24'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['25'];?></td>
        <td valign="top" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['26'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['27'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['28'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['29'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['30'];?></td>
        <td valign="middle" align="center" class="tdBorderBt">&nbsp;<?php echo $other_detail['31'];?></td>
      </tr>
      <tr>
        <td class="tdBorderRtBt">Others</td>
        <td class="tdBorderRtBt">&nbsp;<?php echo $other_detail['32'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['33'];?></td>
        <td valign="top" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['34'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['35'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['36'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['37'];?></td>
        <td valign="middle" align="center" class="tdBorderRtBt">&nbsp;<?php echo $other_detail['38'];?></td>
        <td valign="middle" align="center" class="tdBorderBt">&nbsp;<?php echo $other_detail['39'];?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" style="height:7px;"></td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top">
    <table width="100%" cellpadding="5" cellspacing="0" border="0" class="boxBorder">
      <tr>
        <td width="600" class="tdBorderRt"><strong>Adverse events(if any) during BT</strong></td>
        <td width="400"><strong>Action Taken</strong></td>
      </tr>
      <tr>
        <td height="70" valign="top" class="tdBorderRt">&nbsp;<?php echo $bloodTransusion['PatientBloodTransfusion']['adverse_events'];?></td>
        <td valign="top">&nbsp;<?php echo $bloodTransusion['PatientBloodTransfusion']['action_taken'];?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0" class="">
      <tr>
        <td width="40" valign="top">Note:</td>
        <td width="20" valign="top">1) </td>
        <td>Recommended transfusion timing. (PRC - 1hrs, FFP-1/2hr - 1 hr Platelets - 30 min, Cryoplatelet - 30 min.)</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">2) </td>
        <td>In case of major transfusion reaction blood bag should be sealed. Blood sample and 1st voided urine sample of recipient along with the sealed blood bag should be sent to the blood bank. </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="100%" height="30" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50">&nbsp;</td>
        <td width="150" align="left" valign="middle">Name and Sign of Doctor</td>
        <td width="200" align="left" valign="middle" style="border-bottom:1px solid #000000;">&nbsp;</td>
        <td width="50" align="left" valign="middle">&nbsp;</td>
        <td width="150" align="left" valign="middle">Name and Sign of Nurse</td>
        <td width="200" align="left" valign="middle" style="border-bottom:1px solid #000000;">&nbsp;</td>
        <td align="left" valign="middle">&nbsp;</td>
      </tr>
    </table></td>
  </tr>

</table>
</div>
<br><br>
<div class="page-break">
 My/the patient's doctor <?php echo ucfirst($treating_consultant[0]['fullname']) ;?> has advised me that due to my / the patient medical conditions, the chances for my/the patient's improvement or recovery will be significantly helped by receiving blood product by transfusion; Such as packed red blood cell, fresh frozen plasma, platelets or cryoprecipitate.
<br>
The doctor has explained the benefit that are expected from my/the patient being transfused and as well, the risk. I understand that although the blood products to be administered have been prepared and tested in accordance with strict rules established by the Drugs and Cosmetic Rules, 1945 (and its subsequent) amendments there is still a very small (one in a thousand) chance the blood product will be incompatible with my/the patient's body reaction (Hemolytic Transfusion Reaction) can occur . If if occur the transfusion to be stopped. There is a small chance the blood product may contain a virus that will enter my/ patient's system and may not be recognized as an infection for many month or years.
 <br>

I have had an opportunity to ask question regarding transfusion of blood products for myself or for the patient. I agree this informed consent may serve for consent to give additional necessary blood product during the hospitalization or for the complete course of this illness if I have been advised that the future need for transfusion of blood products is quite likely and possibly on a recurrent basis still related ti this same illness.

<Table>
<tr><td>Patient's Name&nbsp;</td><td> <?php echo ucfirst($patient['Initial']['name'])." ".ucfirst($patient['Patient']['lookup_name']) ; ?></td></tr>
<tr><td>Witness&nbsp;</td><td>___________________________________________________________________</td></tr>
<tr><td>Time&nbsp;</td><td> <?php $time =  explode(" ",$this->DateFormat->formatDate2local(date("Y-m-d H:i"),Configure::read('date_format'),true)); echo  $time[1]; ?> </td> </li>
</Table>

<br><br>

Emergent / Life - threatening circumstances (informed consent not obtained reason patient cannot sing) Because of a life - threatning / emergent medical condition, I have not provided the patient with information sifficient to be considered inormed consent and I have proceeded with ordering blood products to be administered in sufficient quantity to alter, Imorove or reserve a life - threatning / emergent medical condition.

<br><br>

<br><br>

<Table>
<tr><td>Name of Doctor&nbsp;</td><td> <?php echo ucfirst($treating_consultant[0]['fullname']) ;?></td><td width="200"></td><td >Signature of Doctor</td></tr></tr>
<tr><td>Time&nbsp;</td><td> <?php $time =  explode(" ",$this->DateFormat->formatDate2local(date("Y-m-d H:i"),Configure::read('date_format'),true)); echo  $time[1]; ?></td>
<td width="200"></td><td >Signature of Relative</td></tr>
</tr>
<tr><td>Date&nbsp;</td><td> <?php echo  $time[0];?> </td> </li>
</Table>

</div>