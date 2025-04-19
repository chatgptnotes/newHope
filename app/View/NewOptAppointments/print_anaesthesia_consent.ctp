
 <div style="float:right" id="printButton">
					<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
				  </div>&nbsp;<div>
				  </div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%" align="left" valign="top">
    	<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
        	<tr>
            	<!--  <td width="200"><?php echo $this->Html->image('/img/hope-hospitals-gray-logo.gif', array('alt' => '')); ?></td>-->
                <td style="font-size:19px; padding-left:35px;text-align:center;"><?php echo __('Anesthesia Consent Form'); ?></td>
            </tr>
        </table>    </td>
  </tr>
  <tr>
    <td width="100%" height="20" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" height="25" align="left" valign="top"><strong><?php echo __('Basic Information:'); ?></strong></td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top">
    	<table width="100%" cellpadding="0" cellspacing="0" border="0">
        	<tr>
            	<td width="93" valign="top">Patient Name:</td>
           	  <td width="476" style="border-bottom:1px solid #000000;"><?php echo $patientConsentDetails['PatientInitial']['name']." ".$patientConsentDetails['Patient']['lookup_name']; ?></td>
                <td width="61" valign="top">Age/Sex:</td>
           	  <td width="70" style="border-bottom:1px solid #000000;"><?php echo $patientConsentDetails['Person']['age']."/".ucfirst($patientConsentDetails['Patient']['sex']); ?></td>
            </tr>
        </table>    </td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" style="padding-top:10px;">
    	<table width="95%" cellpadding="0" cellspacing="0" border="0">
        	<tr>
           	  <td width="62" valign="top">Reg. No.:</td>
              	<td width="269" style="border-bottom:1px solid #000000;"><?php echo $patientConsentDetails['Patient']['admission_id']; ?></td>
                <td width="89" valign="top">Date of Birth:</td>
           	  <td width="245" style="border-bottom:1px solid #000000;"><?php if($patientConsentDetails['Person']['dob']) echo $this->DateFormat->formatDate2Local($patientConsentDetails['Person']['dob'],Configure::read('date_format'));?></td>
          </tr>
        </table>    </td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" style="padding-top:10px; padding-bottom:15px;">
    	<table width="100%" cellpadding="0" cellspacing="0" border="0">
        	<tr>
           	  <td width="170" valign="top">Name of Anesthesiologist:</td>
              <td style="border-bottom:1px solid #000000;"><?php echo $patientConsentDetails['User']['full_name']; ?></td>                
          </tr>
        </table>     </td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" style="padding-top:10px; padding-bottom:15px;">
    	<table width="100%" cellpadding="0" cellspacing="0" border="0">
        	<tr>
           	  <td width="170" valign="top">Surgery:</td>
              <td style="border-bottom:1px solid #000000;"><?php echo $patientConsentDetails['Surgery']['name']; ?></td>                
          </tr>
        </table>     </td>
  </tr>
  <tr>
    <td align="left" valign="top">
    	<table width="100%" cellpadding="0" cellspacing="0" border="0" class="" style="border:0;">
                    	<tr>
                        	<td width="100%" colspan="2">&nbsp;</td>
                      </tr>
                        <tr>
                       	  <td width="30" valign="top" align="left">I.</td>
                            <td style="padding-bottom:17px;">The Proposed Type of Anesthesia Technique (explain briefly in non-medical terms):<br />
                              <div style="padding-top:3px;  padding-left:30px;">
                              	1. Surgical intervention to be administered by the surgeons:<br />
                                2. Proposed anesthesia technique(s):
                                <div style="padding-top:3px; padding-left:40px;">
                                	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    	<?php if($patientConsentDetails['AnaesthesiaConsentForm']['general_anaesthesia'] == 1) { ?>
                                    	<tr>
                                        	<td width="25" valign="middle"><!--  <input type="checkbox" name="data[AnaesthesiaConsentForm][general_anaesthesia]" value="1" id="general_anaesthesia" <?php //if($patientConsentDetails['AnaesthesiaConsentForm']['general_anaesthesia'] == 1) echo "checked"; ?> disabled/>--></td>
                                            <td>General Anesthesia</td>
                                        </tr>
                                       <?php } ?>
                                       <?php if($patientConsentDetails['AnaesthesiaConsentForm']['regional_anaesthesia'] == 1) { ?>
                                        <tr>
                                        	<td valign="middle"><!-- <input type="checkbox" name="data[AnaesthesiaConsentForm][regional_anaesthesia]" value="1" id="regional_anaesthesia" <?php //if($patientConsentDetails['AnaesthesiaConsentForm']['regional_anaesthesia'] == 1) echo "checked"; ?> disabled />--></td>
                                            <td>Regional Anesthesia</td>
                                        </tr>
                                        <?php } ?>
                                        <?php if($patientConsentDetails['AnaesthesiaConsentForm']['nerve_block'] == 1) { ?>
                                        <tr>
                                        	<td valign="middle"><!--<input type="checkbox" name="data[AnaesthesiaConsentForm][nerve_block]" value="1" id="nerve_block" <?php //if($patientConsentDetails['AnaesthesiaConsentForm']['nerve_block'] == 1) echo "checked"; ?> disabled />--></td>
                                            <td>Nerve block</td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                              </div>                          </td>
                      </tr>
                        <tr>
                          <td valign="top" align="left">II. </td>
                          <td style="padding-bottom:17px;">
                          		Physician's Statements
                                <div style="padding-top:3px; padding-left:30px;">
                              	1. I have adequately assessed the patient's physical condition prior to the anesthesia<br />
                                2. I have verbally explained to the patient in the way that the patient can understand, concerning the anesthesia intervention to be carried out, as following:
                                <div style="padding-top:3px; padding-left:40px;">
                                	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    	<?php if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_procedure'] == 1) { ?>
                                    	<tr>
                                        	<td width="25" valign="middle"><!-- <input type="checkbox" name="data[AnaesthesiaConsentForm][anaesthesia_procedure]" value="1" id="anaesthesia_procedure" <?php //if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_procedure'] == 1) echo "checked"; ?> disabled />--></td>
                                            <td>Anesthesia procedure</td>
                                        </tr>
                                       <?php } ?>
                                       <?php if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_risks'] == 1) { ?>
                                        <tr>
                                        	<td valign="middle"><!-- <input type="checkbox" name="data[AnaesthesiaConsentForm][anaesthesia_risks]" value="1" id="anaesthesia_risks" <?php //if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_risks'] == 1) echo "checked"; ?> disabled />--></td>
                                            <td>Anesthesia-related risks</td>
                                        </tr>
                                       <?php } ?>
                                       <?php if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_symptoms'] == 1) { ?>
                                        <tr>
                                        	<td valign="middle"><!-- <input type="checkbox" name="data[AnaesthesiaConsentForm][anaesthesia_symptoms]" value="1" id="anaesthesia_symptoms" <?php //if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_symptoms'] == 1) echo "checked"; ?> disabled />--></td>
                                            <td>The potential adverse symptoms following the anesthesia</td>
                                        </tr>
                                        <?php  } ?>
                                        <?php if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_suppliment'] == 1) { ?>
                                        <tr>
                                          <td valign="middle"><!--  <input type="checkbox"  name="data[AnaesthesiaConsentForm][anaesthesia_suppliment]" value="1" id="anaesthesia_suppliment" <?php //if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_suppliment'] == 1) echo "checked"; ?> disabled />--></td>
                                          <td>I have rendered the patient with supplementary information regarding the anesthesia</td>
                                        </tr>
                                       <?php } ?>
                                    </table>                                   
                                </div>
                                3. I have also provided the patient with sufficient time to inquire for the following questions concerning the anesthesia to be undertaken in this surgery.                            </div>                          </td>
                        </tr>
                        <tr>
                          <td colspan="2" valign="top" align="left" style="padding-bottom:20px;">
                          	  <table width="70%" cellpadding="0" cellspacing="0" border="0">
                                   <tr>
                                    	<td width="200">Signature of Anesthesiologist :</td>
                                        <td style="border-bottom:1px solid #000000;">&nbsp;</td>
                                   </tr>                                                                      
                              </table>
                                <div style="height:5px;"></div>
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                    	<td width="40">Date:</td>
                                        <?php 
                                          if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_time'] && $patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_time'] !="0000-00-00 00:00:00") {
                                          	  $changeDate = $this->DateFormat->formatDate2Local($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_time'],Configure::read('date_format'),true);
	                                          $expAnaesthesiaTime = explode(" ",$changeDate); 
	                                          $extractDate = explode("/", $expAnaesthesiaTime[0]);
	                                          $extractTime = explode(":", $expAnaesthesiaTime[1]);
                                          }
                                        ?>
                                        <td width="40" style="border-bottom:1px solid #000000;"><?php echo $extractDate[0]; ?></td>
                                        <td width="10" align="center">/</td>
                                        <td width="40" style="border-bottom:1px solid #000000;"><?php echo $extractDate[1]; ?></td>
                                        <td width="10" align="center">/</td>
                                        <td width="40" style="border-bottom:1px solid #000000;"><?php echo $extractDate[2]; ?></td>
                                        <td width="10">&nbsp;</td>
                                        <td width="40">Time:</td>
                                        <td width="40" style="border-bottom:1px solid #000000;"><?php echo $extractTime[0]; ?></td>
                                        <td width="10" align="center">:</td>
                                        <td width="40" style="border-bottom:1px solid #000000;"><?php echo $extractTime[1]; ?></td>
                                      	<td>&nbsp;</td>
                                    </tr>
                                </table>                          </td>                          
                      </tr>
                        <tr>
                          <td valign="top" align="left">III.</td>
                          <td style="padding-bottom:7px;">
                          		Patient's Statements
                                <div style="padding-top:3px; padding-left:30px;">
                                	1. I understand that the anesthesia procedure is necessary for undertaking this surgery in order to alleviate pain and fear during the operation<br />
                                    2. The anesthesia doctor has explained the risk and procedure of anesthesia to me<br />
                                    3. I fully understand the information provided relating to the anesthesia<br />
                                    4. I had addressed my concerns and doubts regarding the anesthesia to the anesthesia doctor and he/she has given me satisfactory responses.                                </div>                          </td>
                        </tr>
                    </table>    </td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" align="left" valign="top">Relationship to the Patient:</td>
  </tr>
  <tr>
    <td align="left" valign="top">
    	<table width="100%" cellpadding="0" cellspacing="0" border="0">
        	<tr>
            	<td width="142" valign="top">Authorized Signature:</td>
       	      <td width="302" style="border-bottom:1px solid #000000;">&nbsp;</td>
              <td width="150" valign="top">Relationship to Patient:</td>
           	  <td width="106" style="border-bottom:1px solid #000000;"><?php echo $patientConsentDetails['AnaesthesiaConsentForm']['relationship_to_patient']; ?></td>
          </tr>
        </table>    </td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" style="padding-top:10px;">
    	<table width="95%" cellpadding="0" cellspacing="0" border="0">
        	<tr>
           	  <td width="60" valign="top">Address.:</td>
              	<td width="312" style="border-bottom:1px solid #000000;"><?php echo $patientConsentDetails['AnaesthesiaConsentForm']['relationship_to_address']; ?></td>
                <td width="51" valign="top">Tel No.:</td>
       	      <td width="242" style="border-bottom:1px solid #000000;"><?php echo $patientConsentDetails['AnaesthesiaConsentForm']['relationship_to_telephone']; ?></td>
          </tr>
        </table>    </td>
  </tr>
  <tr>
    <td align="left" valign="top" style="padding-top:10px;">
    	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                    	<td width="40">Date:</td>
                                         <?php 
                                          if($patientConsentDetails['AnaesthesiaConsentForm']['relationship_to_date'] && $patientConsentDetails['AnaesthesiaConsentForm']['relationship_to_date'] !="0000-00-00 00:00:00") {
                                          		$changeDate = $this->DateFormat->formatDate2Local($patientConsentDetails['AnaesthesiaConsentForm']['relationship_to_date'],Configure::read('date_format'),true);
                                          		$expRelationshipDate = explode(" ",$changeDate); 
	                                            $extractDate = explode("/", $expRelationshipDate[0]);
	                                            $extractTime = explode(":", $expRelationshipDate[1]);
                                          }
                                        ?>
                                        <td width="40" style="border-bottom:1px solid #000000;"><?php echo $extractDate[0]; ?></td>
                                        <td width="10" align="center">/</td>
                                        <td width="40" style="border-bottom:1px solid #000000;"><?php echo $extractDate[1]; ?></td>
                                        <td width="10" align="center">/</td>
                                        <td width="40" style="border-bottom:1px solid #000000;"><?php echo $extractDate[2]; ?></td>
                                        <td width="10">&nbsp;</td>
                                        <td width="40">Time:</td>
                                        <td width="40" style="border-bottom:1px solid #000000;"><?php echo $extractTime[0]; ?></td>
                                        <td width="10" align="center">:</td>
                                        <td width="40" style="border-bottom:1px solid #000000;"><?php echo $extractTime[1]; ?></td>
                                      	<td>&nbsp;</td>
                                    </tr>
                                </table>    </td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top">Note 1. Please specify the relationship to the patient if the authorized signer is not the patient himself/herself</td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
</table>