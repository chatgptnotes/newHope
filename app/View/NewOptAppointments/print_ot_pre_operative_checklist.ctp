<style>
	.heading{padding:5px 7px; font-size:17px; color:#FFFFFF; background-color:#000000; width:270px; border-radius:15px; -moz-border-radius:15px; -webkit-border-radius:15px;  -o-border-radius:15px; font-weight:bold;}
	.itemChkBox {float:right; margin-left:25px; margin-right:20px; border:1px solid #666666; width:25px;}
	.subhead{font-size:19px; text-decoration:underline;}
	.boxBorder{border:1px solid #999999;}
	.boxBorderBot{border-bottom:1px solid #999999;}
	.boxBorderRight{border-right:1px solid #999999;}
	.tdBorderRtBt{border-right:1px solid #999999; border-bottom:1px solid #999999;}
	.tdBorderBt{border-bottom:1px solid #999999;}
	.tdBorderTp{border-top:1px solid #999999;}
	.tdBorderRt{border-right:1px solid #999999;}
	.tdBorderTpBt{border-bottom:1px solid #999999; border-top:1px solid #999999;}
	.tdBorderTpRt{border-top:1px solid #999999; border-right:1px solid #999999;}
	.tdBorderTp{border-top:1px solid #999999;}
	.itemChkBox1 {float:right; margin-left:25px; margin-right:10px;}
	
</style>


<div style="float:right" id="printButton">
					<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
				  </div>&nbsp;<div>
				  </div>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="100%" align="center" valign="top" style="padding-bottom:10px;"><?php //echo $this->Html->image('/img/hope-logo.gif', array('alt' => '')); ?></td>
  </tr>
  <tr>
  	<td width="100%" align="center" style="padding-bottom:5px;">
         <?php echo $this->Html->image('/img/pre-operative.gif', array('alt' => '')); ?>
    </td>
  </tr>
 <tr>
    <td width="100%" height="20" align="left" valign="top">&nbsp;</td>
  </tr>
  
  <tr>
    <td width="100%" align="left" valign="top">
    	<table width="100%" cellpadding="0" cellspacing="0" border="0">
        	<tr>
            	<td width="93" valign="top">Patient Name:</td>
           	  <td width="476" style="border-bottom:1px solid #000000;"><?php echo $patientPOCheckListDetails['PatientInitial']['name']." ".$patientPOCheckListDetails['Patient']['lookup_name']; ?></td>
                <td width="61" valign="top">Age / Sex:</td>
           	  <td width="70" style="border-bottom:1px solid #000000;"><?php echo $patientPOCheckListDetails['Person']['age']." / ".ucfirst($patientPOCheckListDetails['Patient']['sex']); ?></td>
            </tr>
        </table>    </td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" style="padding-top:10px;">
    	<table width="95%" cellpadding="0" cellspacing="0" border="0">
        	<tr>
           	  <td width="62" valign="top">Reg. No.:</td>
              	<td width="269" style="border-bottom:1px solid #000000;"><?php echo $patientPOCheckListDetails['Patient']['admission_id']; ?></td>
                <td width="89" valign="top">Date of Birth:</td>
           	  <td width="245" style="border-bottom:1px solid #000000;"><?php if($patientPOCheckListDetails['Person']['dob']) echo $this->DateFormat->formatDate2Local($patientPOCheckListDetails['Person']['dob'],Configure::read('date_format'));?></td>
          </tr>
        </table>    </td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" style="padding-top:10px;">
    	<table width="95%" cellpadding="0" cellspacing="0" border="0">
        	<tr>
           	  <td width="62" valign="top">Surgery:</td>
              	<td width="269" style="border-bottom:1px solid #000000;"><?php echo $patientPOCheckListDetails['Surgery']['name']; ?></td>
                <td width="89" valign="top">&nbsp;</td>
           	  <td width="245"></td>
          </tr>
        </table>    </td>
  </tr>
  <tr>
    <td width="100%" height="20" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" height="25" align="left" valign="top">
    	<table width="100%" border="0" cellspacing="0" cellpadding="4" class="boxBorder">
                   	  <tr>
                   	    <th colspan="2" align="left" class="tdBorderRtBt"><?php echo __('CHECK EVENING BEFORE SURGERY'); ?></th>
                         <th class="tdBorderRtBt">&nbsp;</th>
                         <th width="337" class="tdBorderRtBt" colspan="2"><?php echo __('INSTRUCTIONS FOR OP CHECK'); ?></th>
		  			  </tr>
                      <tr>
                        <td width="35"  class="tdBorderBt">1.</td>
                        <td width="338" class="tdBorderRtBt">Surgery permit signed</td>
                        <td width="48" class="tdBorderRtBt"><?php  if($patientPOCheckListDetails['PreOperativeChecklist']['sp_signed'] == 1) echo __('Yes'); else  echo __('No'); ?></td>
                      	<td rowspan="23" align="left" valign="top" class="tdBorderBt">
                        	<table width="100%" cellpadding="5" cellspacing="0" border="0">
                            	<tr>
                                    <td width="20" valign="top">1.</td>
                                    <td valign="top" style="padding-bottom:10px;">OT intimation regarding operation should be sent a day prior to surgery.</td>
                                </tr>
                            	<tr>
                            	  <td valign="top">2.</td>
                            	  <td valign="top" style="padding-bottom:10px;">Attach to I. P. file when item completed.</td>
                          	  </tr>
                            	<tr>
                            	  <td valign="top">3.</td>
                            	  <td valign="top" style="padding-bottom:10px;">If blood work urine analysis has been done but results not available</td>
                          	  </tr>
                            	<tr>
                            	  <td valign="top">4.</td>
                            	  <td valign="top" style="padding-bottom:10px;">Nurse preparing patient will check all items listed carefully</td>
                          	  </tr>
                            	<tr>
                            	  <td valign="top">a.</td>
                            	  <td valign="top" style="padding-bottom:10px;">All jewellery rings must be removed.</td>
                          	  </tr>
                            	<tr>
                            	  <td valign="top">b.</td>
                            	  <td valign="top" style="padding-bottom:10px;">Glasses / contact lenses, dentures and false eyes-lashes etc. must be removed.</td>
                          	  </tr>
                            	<tr>
                            	  <td valign="top">c. </td>
                            	  <td valign="top" style="padding-bottom:10px;">All make up, nailpolish, hairpins, false eye-lasher etc. must be removed.</td>
                          	  </tr>
                            	<tr>
                            	  <td valign="top">d.</td>
                            	  <td valign="top" style="padding-bottom:10px;">Artificial limbs must be removed.</td>
                          	  </tr>
                            	<tr>
                            	  <td valign="top">e.</td>
                            	  <td valign="top" style="padding-bottom:10px;">Patient must empty bladder within one hour of going to surgery.</td>
                          	  </tr>
                            	<tr>
                            	  <td valign="top">f. </td>
                            	  <td valign="top" style="padding-bottom:10px;">Clean hospital cap and gown are only clothing to be worn to surgery.</td>
                          	  </tr>
                            	<tr>
                            	  <td valign="top">g. </td>
                            	  <td valign="top" style="padding-bottom:10px;">Consult doctor's order for any special procedures ordered to prepare patient for surgery.</td>
                          	  </tr>
                            	<tr>
                            	  <td valign="top">h.</td>
                            	  <td valign="top" style="padding-bottom:10px;">Check doctor's order for pre-op medication (Time to be given, dose and route)</td>
                          	  </tr>
                            	<tr>
                            	  <td valign="top">&nbsp;</td>
                            	  <td valign="top" style="padding-bottom:10px;">SPECIAL INFORMATION</td>
                          	  </tr>
                            	<tr>
                            	  <td valign="top">&nbsp;</td>
                            	  <td valign="top">&nbsp;</td>
                          	  </tr>
                            	
                            	
                            	<tr>
                            	  <td valign="top">&nbsp;</td>
                            	  <td height="40" valign="bottom">Signature<br />
                           	      (Nurse's on duty)</td>
                          	  </tr>
                        </table>                        </td>
                      </tr>
                      <tr>
                        <td width="35" class="tdBorderBt">2.</td>
                        <td width="338" class="tdBorderRtBt">History and physical done</td>
                        <td width="48" class="tdBorderRtBt"><?php  if($patientPOCheckListDetails['PreOperativeChecklist']['hp_done'] == 1) echo __('Yes'); else  echo __('No'); ?></td>
          </tr>
                      <tr>
                        <td class="tdBorderBt">3.</td>
                        <td class="tdBorderRtBt">Consultation (if requested)</td>
                        <td width="48" class="tdBorderRtBt"><?php  if($patientPOCheckListDetails['PreOperativeChecklist']['consultation'] == 1) echo __('Yes'); else  echo __('No'); ?></td>
          </tr>
                      <tr>
                        <td class="tdBorderBt">4.</td>
                        <td class="tdBorderRtBt">Blood work done, result or chart</td>
                        <td width="48" class="tdBorderRtBt"><?php  if($patientPOCheckListDetails['PreOperativeChecklist']['bw_done'] == 1) echo __('Yes'); else  echo __('No'); ?></td>
          </tr>
                      <tr>
                        <td class="tdBorderBt">5.</td>
                        <td class="tdBorderRtBt">Urine analysis done, result or chart</td>
                        <td width="48" class="tdBorderRtBt"><?php  if($patientPOCheckListDetails['PreOperativeChecklist']['ua_done'] == 1) echo __('Yes'); else  echo __('No'); ?></td>
          </tr>
                      <tr>
                        <td class="tdBorderBt">6.</td>
                        <td class="tdBorderRtBt">Operative part are prepared</td>
                        <td width="48" class="tdBorderRtBt"><?php  if($patientPOCheckListDetails['PreOperativeChecklist']['op_prepare'] == 1) echo __('Yes'); else  echo __('No'); ?></td>
          </tr>
                      <tr>
                        <td class="tdBorderBt">7.</td>
                        <td class="tdBorderRtBt">Enema given, if ordered</td>
                        <td width="48" class="tdBorderRtBt"><?php  if($patientPOCheckListDetails['PreOperativeChecklist']['enema_given'] == 1) echo __('Yes'); else  echo __('No'); ?></td>
          </tr>
                     <tr>
                        <td class="tdBorderBt">8.</td>
                        <td class="tdBorderRtBt">N. P. O. notice at bedside</td>
                        <td width="48" class="tdBorderRtBt"><?php  echo $patientPOCheckListDetails['PreOperativeChecklist']['npo_notice_time']; ?></td>
          </tr>
                      
                      
                      <tr>
                        <td valign="top" class="tdBorderBt">9.</td>
                        <td class="tdBorderRtBt">Type and crossmatch done number of blood (units) arranged</td>
                        <td width="48" class="tdBorderRtBt"><?php  if($patientPOCheckListDetails['PreOperativeChecklist']['tc_done'] == 1) echo __('Yes'); else  echo __('No'); ?></td>
          </tr>
                      <tr>
                        <td height="30" colspan="2" valign="middle" class="tdBorderRtBt"><strong>DAY OF SURGERY MORNING SHIFT</strong></td>
                        <td class="tdBorderRtBt">&nbsp;</td>
                      </tr>
                      <tr>
                        <td valign="top" class="tdBorderBt">10.</td>
                        <td valign="top" class="tdBorderRtBt">N.P.O. after midnight or since</td>
                        <td class="tdBorderRtBt"><?php  echo $patientPOCheckListDetails['PreOperativeChecklist']['npo_midnight']; ?></td>
                      </tr>
                      <tr>
                        <td valign="top" class="tdBorderBt">11.</td>
                        <td valign="top" class="tdBorderRtBt">Identification band or wrist, with name, room, hospital number.</td>
                        <td class="tdBorderRtBt"><?php  echo $patientPOCheckListDetails['PreOperativeChecklist']['identification_band']; ?></td>
                      </tr>
                      <tr>
                        <td valign="top" class="tdBorderBt">12.</td>
                        <td valign="top" class="tdBorderRtBt">Name plate with chart</td>
                        <td class="tdBorderRtBt"><?php  echo $patientPOCheckListDetails['PreOperativeChecklist']['name_plate']; ?></td>
                      </tr>
                      <tr>
                        <td valign="top" class="tdBorderBt">13.</td>
                        <td valign="top" class="tdBorderRtBt">Glasses / contact lenses removed</td>
                        <td width="48" class="tdBorderRtBt"><?php  if($patientPOCheckListDetails['PreOperativeChecklist']['glassess_removed'] == 1) echo __('Yes'); else  echo __('No'); ?></td>
          </tr>
                      <tr>
                        <td valign="top" class="tdBorderBt">14.</td>
                        <td valign="top" class="tdBorderRtBt">Dentures removed</td>
                        <td width="48" class="tdBorderRtBt"><?php  if($patientPOCheckListDetails['PreOperativeChecklist']['dentures_removed'] == 1) echo __('Yes'); else  echo __('No'); ?></td>
          </tr>
                      <tr>
                        <td valign="top" class="tdBorderBt">15.</td>
                        <td valign="top" class="tdBorderRtBt">Jewellery removed and secured</td>
                        <td width="48" class="tdBorderRtBt"><?php  if($patientPOCheckListDetails['PreOperativeChecklist']['jewellery_removed'] == 1) echo __('Yes'); else  echo __('No'); ?></td>
          </tr>
                      <tr>
                        <td valign="top" class="tdBorderBt">16.</td>
                        <td valign="top" class="tdBorderRtBt">Hairpins, makeup, nailpolish removed</td>
                        <td width="48" class="tdBorderRtBt"><?php  if($patientPOCheckListDetails['PreOperativeChecklist']['hairpins_removed'] == 1) echo __('Yes'); else  echo __('No'); ?></td>
          </tr>
                      <tr>
                        <td valign="top" class="tdBorderBt">17.</td>
                        <td valign="top" class="tdBorderRtBt">Head cap and hospital gown on</td>
                       <td width="48" class="tdBorderRtBt"><?php  if($patientPOCheckListDetails['PreOperativeChecklist']['headcap_hp_gown_on'] == 1) echo __('Yes'); else  echo __('No'); ?></td>
          </tr>
                      <tr>
                        <td valign="top" class="tdBorderBt">18.</td>
                        <td valign="top" class="tdBorderRtBt">Voided within an hour of surgery</td>
                        <td width="48" class="tdBorderRtBt"><?php  if($patientPOCheckListDetails['PreOperativeChecklist']['voided_surgery'] == 1) echo __('Yes'); else  echo __('No'); ?></td>
          </tr>
                      <tr>
                        <td valign="top" class="tdBorderBt">19.</td>
                        <td valign="top" class="tdBorderRtBt">Cathetrised Time</td>
                        <td width="48" class="tdBorderRtBt"><?php  echo $patientPOCheckListDetails['PreOperativeChecklist']['cathertrised_time']; ?></td>
          </tr>
                      
                      <tr>
                        <td colspan="2" valign="top" class="tdBorderRtBt">
                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
               	  <tr>
                                	<td width="49" valign="bottom">Temp. :</td>
                    <td width="61" valign="bottom" class="tdBorderBt"><?php  echo $patientPOCheckListDetails['PreOperativeChecklist']['temp']; ?></td>
                                  <td width="19" valign="bottom">&nbsp;</td>
                                  <td width="57" valign="bottom">Pulse:</td>
                    <td width="60" valign="bottom" class="tdBorderBt"><?php  echo $patientPOCheckListDetails['PreOperativeChecklist']['pulse']; ?></td>
                    <td width="19" valign="bottom">&nbsp;</td>
                                  <td width="47" valign="bottom">Resp. :</td>
                                  <td width="66" valign="bottom" class="tdBorderBt"><?php  echo $patientPOCheckListDetails['PreOperativeChecklist']['resp']; ?></td>
                                  <td width="4">&nbsp;</td>
                              </tr>
                            	<tr>
                            	  <td height="20" valign="bottom">B.P. :</td>
                            	  <td valign="bottom" class="tdBorderBt"><?php  echo $patientPOCheckListDetails['PreOperativeChecklist']['blood_pressure']; ?></td>
                            	  <td valign="bottom">&nbsp;</td>
                            	  <td valign="bottom">Weight :</td>
                            	  <td valign="bottom" class="tdBorderBt"><?php  echo $patientPOCheckListDetails['PreOperativeChecklist']['weight']; ?></td>
                            	  <td valign="bottom">&nbsp;</td>
                            	  <td valign="bottom">&nbsp;</td>
                            	  <td valign="bottom">&nbsp;</td>
                            	  <td>&nbsp;</td>
                          	  </tr>
                            	<tr>
                            	  <td height="30" colspan="9" valign="bottom"><strong>PRE-OPERATIVE MEDICATION ORDER</strong></td>
                           	  </tr>
                            </table>                         </td>
                        <td class="tdBorderRtBt">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3" valign="top" class="tdBorderRtBt">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3" valign="top" class="tdBorderRt">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                          <!--<tr>
                            <td width="50">&nbsp;</td>
                            <td width="70">&nbsp;</td>
                            <td width="20">&nbsp;</td>
                            <td width="70" valign="bottom">AM</td>
                            <td width="">&nbsp;</td>
                          </tr>-->
                          <tr>
                            <td height="25" valign="bottom">Given :</td>
                            <td valign="bottom" class="tdBorderBt"><?php  echo $patientPOCheckListDetails['PreOperativeChecklist']['pre_given']; ?></td>
                            <td valign="bottom">&nbsp;</td>
                            <td valign="bottom">PM Date :</td>
                            <td valign="bottom" class="tdBorderBt"><?php  
                           		 echo $this->DateFormat->formatDate2Local($patientPOCheckListDetails['PreOperativeChecklist']['pre_date'],Configure::read('date_format')); 
                             ?></td>
                          </tr>
                          <tr>
                            <td height="30" colspan="3" valign="bottom">Nurse's Signature:</td>
                            <td colspan="2" valign="bottom" class="tdBorderBt">&nbsp;</td>
                          </tr>
                          <tr>
                          	
                          </tr>
                        </table></td>
                        <td valign="bottom" style="padding:0 0 10px 10px;">Patient Identification</td>
                      </tr>
                    </table>
    </td>
  </tr>
  <!--<tr>
    <td align="center" valign="top" style="font-size:11px; padding-top:5px; padding-bottom:10px;">
    	51, Second Right Lane from Lakmat Square, Near Jaipuria Banglow, Dhantoli Nagpur - 440 012 Tel. : 0712 - 2420951, 2420869, 6627900, Fax : 0712 - 2432551<br /> 
   	  E-mail : info@hopehospitals.in Visit us : www.hopehospitals.in    </td>
  </tr>-->
  
</table>

