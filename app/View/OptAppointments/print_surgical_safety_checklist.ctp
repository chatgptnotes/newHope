<style>
 	.boxBorder{border:1px solid #999999;}
	.boxBorderBot{border-bottom:1px solid #999999;}
	.boxBorderRight{border-right:1px solid #999999;}
	.tdBorderRtBt{border-right:1px solid #999999; border-bottom:1px solid #999999;}
	.tdBorderBt{border-bottom:1px solid #999999;}
	.tdBorderTp{border-top:1px solid #999999;}
	.tdBorderRt{border-right:1px solid #999999;}
	.tdBorderTpBt{border-bottom:1px solid #999999; border-top:1px solid #999999;}
	.tdBorderTpRt{border-top:1px solid #999999; border-right:1px solid #999999;}
	.columnPad{padding:5px;}
	.columnLeftPad{padding-left:5px;}
	.tbl{background:#CCCCCC;}
	.tbl td{background:#FFFFFF;}
	.totalPrice{font-size:14px;}
	.adPrice{border:1px solid #CCCCCC; border-top:0px; padding:3px;}
</style>
<div style="float:right" id="printButton">
					<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
				  </div>&nbsp;<div>
				  </div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="100%" align="left" valign="top">
    	<table width="100%" cellpadding="0" cellspacing="0" border="0">
        	<tr>
            	<td width="200"><?php //echo $this->Html->image('/img/hope-logo-sm.gif', array('alt' => '')); ?></td>
                <td align="center" valign="bottom" style="font-size:23px; font-weight:bold;"><?php echo __('SURGICAL SAFETY CHECKLIST'); ?></td>
                <td width="200" align="right">&nbsp;</td>
            </tr>
        </table>    </td>
  </tr>
  <tr>
    <td width="100%" height="20" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" height="25" align="left" valign="top" class="boxBorder" style="padding:10px 20px;">
    	<table width="100%" cellpadding="0" cellspacing="0" border="0">
        	<tr>
           	  <td width="46%" valign="top">
               	  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                   	  <tr>
                       	  <td width="110" valign="top"><?php echo __('Patient\'s Name :'); ?></td>
                            <td valign="top" style="border-bottom:1px solid #000000;"><?php echo $patient['Patient']['lookup_name']; ?></td>
                        </tr>
                </table>              </td>
                <td width="" height="40">&nbsp;</td>
              	<td width="46%" valign="top">
              		<table width="100%" cellpadding="0" cellspacing="0" border="0">
                   	  <tr>
                       	  <td width="65" valign="top">Bed No. :</td>
                            <td valign="top" style="border-bottom:1px solid #000000;"><?php echo $patientData['Room']['bed_prefix'].$patientData['Bed']['bedno']; ?></td>
                      </tr>
                	</table>              	</td>
            </tr>
        	<tr>
        	  <td valign="top">
              		<table width="100%" cellpadding="0" cellspacing="0" border="0">
                   	  <tr>
                       	  <td width="110" valign="top">Registration No. :</td>
                            <td valign="top" style="border-bottom:1px solid #000000;"><?php echo $patient['Patient']['admission_id']; ?></td>
                        </tr>
                </table>              </td>
        	  <td height="25">&nbsp;</td>
        	  <td valign="top">
              		<table width="100%" cellpadding="0" cellspacing="0" border="0">
                   	  <tr>
                       	  <td width="120" valign="top">Surgery :</td>
                            <td valign="top" style="border-bottom:1px solid #000000;"><?php echo $patientSSCheckListDetails['Surgery']['name']; ?></td>
                      </tr>
                    </table>              </td>
      	  </tr>
        </table>    </td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" style="padding-top:10px;">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top">
    	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                    	<tr>
                        	<td width="250" height="30" valign="top"  style="text-align:center;"><strong>Sign In</strong></td>
                            <td width="30">&nbsp;</td>
                            <td width="250" align="left"  style="text-align:center;"><strong>Time Out</strong></td>
                            <td width="30">&nbsp;</td>
                            <td width="250" align="left"  style="text-align:center;"><strong>Sign Out</strong></td>
                        </tr>
                    	<tr>
                    	  <td align="left" valign="top">
                          		<table width="100%" border="0" cellspacing="1" cellpadding="0">
                                	<tr>
                                    	<th class="boxBorder" style="text-align:center; padding:5px; font-size:17px;">Before induction of anesthesia</th>
                                    </tr>
                                </table>                          </td>
                    	  <td>&nbsp;</td>
                    	  <td align="left" valign="top">
                          		<table width="100%" border="0" cellspacing="1" cellpadding="0">
                                	<tr>
                                    	<th class="boxBorder" style="text-align:center; padding:5px; font-size:17px;">Before Skin incision</th>
                                    </tr>
                                </table>                          </td>
                    	  <td>&nbsp;</td>
                    	  <td align="left" valign="top">
                          		<table width="100%" border="0" cellspacing="1" cellpadding="0">
                                	<tr>
                                    	<th class="boxBorder" style="text-align:center; padding:5px; font-size:17px;">Before Patient leaves operating room</th>
                                    </tr>
                                </table>                          </td>
                  	  </tr>
                    	<tr>
                    	  <td height="35" align="left" valign="middle"  style="text-align:center;">(with atleast nurse and anaesthetists)</td>
                    	  <td>&nbsp;</td>
                    	  <td align="left" valign="middle"  style="text-align:center;">(with nurse and surgeon)</td>
                    	  <td>&nbsp;</td>
                    	  <td align="left" valign="middle"  style="text-align:center;">(with nurse, anaesthetists and surgeon)</td>
                  	  </tr>
                    	<tr>
                    	  <td align="left" valign="top" class="boxBorder">
                          		<table width="100%" border="0" cellspacing="0" cellpadding="5">
                                	<tr>
                                    	<td valign="top" class="tdBorderBt">
                                        	<strong>Has the patient confirmed his/her indentify, site, procedure and consent?</strong>
                                          	<div style="padding-top:5px;">
                                            	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                	<tr>
                                                   	  	<td width="30"><?php if($patientSSCheckListDetails['SurgicalSafetyChecklist']['signin_confirmed'] == 1) echo __('Yes'); else  echo __('No'); ?></td>
                                                        <td width="30"></td>
                                                        <td>&nbsp;</td>                                                        
                                                    </tr>
                                                </table>
                                          </div>                                         </td>
                                    </tr>
                                    <tr>
                                    	<td valign="top" class="tdBorderBt">
                                        	<strong>Is the site marked? </strong>
                                        	<div style="padding-top:15px;">
                                            	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                	<tr>
                                                   	  <td width="100"><?php if($patientSSCheckListDetails['SurgicalSafetyChecklist']['signin_marked_yes'] == 1) echo __('Yes'); else echo __('Not Applicable'); ?></td>
                                                        <td  ></td>
                                                        <td >&nbsp;</td>
                                                      	<td width="95"></td>
                                                        <td width="30" ></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </div>                                      </td>
                                    </tr>
                                    <tr>
                                      <td valign="top">
                                        	<strong>Are the equipments check complete? </strong>
                                        	<div style="padding-top:15px;">
                                            	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                	<tr>
                                                   	  	<td width="100"><?php if($patientSSCheckListDetails['SurgicalSafetyChecklist']['signin_marked_yes'] == 1) echo __('Yes'); else echo __('Not Applicable'); ?></td>
                                                        <td  ></td>
                                                        <td>&nbsp;</td>                                                        
                                                    </tr>
                                                </table>
                                            </div>                                      </td>
                                    </tr>
                                </table>                          </td>
                    	  <td>&nbsp;</td>
                    	  <td align="left" valign="top" class="boxBorder">
                          		<table width="100%" border="0" cellspacing="0" cellpadding="5">
                                	<tr>
                                    	<td valign="top" height="65" class="tdBorderBt">
                                        	<div style="float:right; margin-left:10px; margin-top:5px; width:30px; height:20px;" >
                                             <?php if($patientSSCheckListDetails['SurgicalSafetyChecklist']['timeout_confirmed'] == 1) echo __('Yes'); else echo __('No'); ?>
                                       </div>
                                            <strong>Confirm patient's name, Procedures, and where the incision will be made</strong>                                        </td>
                                    </tr>
                                    <tr>
                                    	<td valign="top" height="60"  class="tdBorderBt">
                                        	<strong>Is essential Imaging displayed? </strong>
                                        	<div style="padding-top:15px;">
                                            	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                	<tr>
                                                   	  <td width="100"><?php if($patientSSCheckListDetails['SurgicalSafetyChecklist']['timeout_displayed_yes'] == 1) echo __('Yes'); else echo  __('Not Applicable'); ?></td>
                                                        <td  >
                                                         
                                                        </td>
                                                        <td width="20">&nbsp;</td>
                                                      	<td width="95"></td>
                                                        <td width="30" ></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </div>                                      </td>
                                    </tr>
                                    <tr>
                                      <td valign="top" height="60">&nbsp;</td>
                                    </tr>
                                </table>                          </td>
                    	  <td>&nbsp;</td>
                    	  <td align="left" valign="top" class="boxBorder">
                          		<table width="100%" border="0" cellspacing="0" cellpadding="5">
                                	<tr>
                                    	<td valign="top" height="65" class="tdBorderBt">
                                        	<div style="float:right; margin-left:10px; margin-top:5px; width:30px; height:20px;" >
                                                 <?php if($patientSSCheckListDetails['SurgicalSafetyChecklist']['signout_confirmed'] == 1) echo __('Yes'); else echo __('No'); ?>
                                                </div>
                                            <strong>Nurse verbally confirms:</strong>
                                            <div class="clr"></div>
                                            <strong>Name of the procedure</strong> <br /><?php echo $patientSSCheckListDetails['SurgicalSafetyChecklist']['signout_procedure_name']; ?>                                       </td>
                                    </tr>
                                    <tr>
                                   	  <td valign="top" height="60" class="tdBorderBt">
                                   	  	<div style="float:right; margin-left:10px; margin-top:5px; width:30px; height:20px;" >
                                                  <?php if($patientSSCheckListDetails['SurgicalSafetyChecklist']['signout_specimen'] == 1) echo __('Yes'); else echo __('No'); ?>
                                                </div>
                                        <strong>Is there is specimen the nurse reads specimens label including patients name? </strong>                                     </td>
                                    </tr>
                                    <tr>
                                      <td valign="top" height="60">
                                      <div style="float:right; margin-left:10px; margin-top:5px; width:30px; height:20px;" >
                                        <?php if($patientSSCheckListDetails['SurgicalSafetyChecklist']['signout_instrument'] == 1) echo __('Yes'); else echo __('No'); ?>
                                      </div>
                                   	  <strong>No. of  instruments, sponge and needle counts</strong></td>
                                    </tr>
                                </table>                             </td>
                  	  	</tr>
                    	<tr>
                    	  <td align="center" style="padding-top:80px;"><strong>Signature</strong></td>
                    	  <td>&nbsp;</td>
                    	  <td align="center" style="padding-top:80px;"><strong>Signature</strong></td>
                    	  <td>&nbsp;</td>
                    	  <td align="center" style="padding-top:80px;"><strong>Signature</strong></td>
                  	  </tr>
                    </table>    </td>
  </tr>
  <tr>
    <td height="25" align="left" valign="top">&nbsp;</td>
  </tr>
  <!--<tr>
    <td align="center" valign="top" class="tdBorderTp" style="font-size:10px; letter-spacing:-0.4px; padding-top:5px;">
    	51, Second Right Lane from Lakmat Square, Near Jaipuria Banglow, Dhantoli Nagpur - 440 012 Tel. : 0712 - 2420951, 2420869, 6627900, Fax : 0712 - 2432551 E-mail : info@hopehospitals.in Visit us : www.hopehospitals.in    </td>
  </tr> -->
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
</table>
