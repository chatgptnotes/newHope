<div class="inner_title">
 <h3><?php echo __('Pre Operative Check List'); ?></h3>
<span> <a class="blueBtn" href="<?php echo $this->Html->url("/opt_appointments/ot_pre_operative_checklist/". $patient_id); ?>"><?php echo __('Back'); ?></a></span>
</div>
<div class="patient_info">
 <?php echo $this->element('patient_information');?>
</div> 
<div class="clr"></div>
<div style="text-align: right;" class="clr inner_title"></div>
<p class="ht5"></p>  
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
 <td>
 <strong><?php echo __('Surgery : '); ?></strong>
 </td>
 <td>
 <?php 
		          echo $patientPOCheckListDetails['Surgery']['name'];
?>
 </td>
</tr>
<tr>
 <td colspan="2">&nbsp;</td>
</tr>
 </table>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
 <tr>
  <th colspan="2"><?php echo __('CHECK EVENING BEFORE SURGERY'); ?></th>
  <th>&nbsp;</th>
  <th><?php echo __('INSTRUCTIONS FOR OP CHECK'); ?></th>
 </tr>
 <tr>
   <td width="35">1.</td>
   <td width="380"><?php echo __('Surgery permit signed'); ?></td>
   <td width="110">
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
     <tr>
      <td width="25" align="left">
       <?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['sp_signed'])) { if($patientPOCheckListDetails['PreOperativeChecklist']['sp_signed'] == 1) echo __('Yes');  else  echo __('No'); } ?>
      </td>
      <td width="35"></td>
      <td width="25"></td>
      <td></td>
      </tr>
    </table>
   </td>
   <td rowspan="22" align="left" valign="top">
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
</table>
   </td>
                      </tr>
                      <tr>
                        <td width="35">2.</td>
                        <td width="350"><?php echo __('History and physical done'); ?></td>
                        <td width="110">
                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td width="25" align="left">
                                         <?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['hp_done'])) { if($patientPOCheckListDetails['PreOperativeChecklist']['hp_done'] == 1) echo __('Yes'); else echo __('No'); } ?>
                                        </td>
                                    <td width="35"></td>
                                    <td width="25">
                                       
                                    </td>
                                    <td></td>
                                </tr>
                            </table>                        </td>
                      </tr>
                      <tr>
                        <td>3.</td>
                        <td>Consultation (if requested)</td>
                        <td width="110">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                  <td width="25" align="left">
                                   <?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['consultation'])) { if($patientPOCheckListDetails['PreOperativeChecklist']['consultation'] == 1) echo __('Yes'); else echo __('No'); }  ?>
                                  </td>
                                  <td width="35"></td>
                                   <td width="25">
                                   </td>
                                  <td></td>
                                </tr>
                            </table>                        </td>
                      </tr>
                      <tr>
                        <td>4.</td>
                        <td>Blood work done, result or chart</td>
                        <td width="110">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                  <td width="25" align="left">
                                  <?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['bw_done'])) { if($patientPOCheckListDetails['PreOperativeChecklist']['bw_done'] == 1) echo __('Yes'); else echo __('No'); } ?>
                                  </td>
                                  <td width="35"></td>
                                  <td width="25">
                                   
                                  </td>
                                  <td></td>
                                </tr>
                            </table>                        </td>
                      </tr>
                      <tr>
                        <td>5.</td>
                        <td>Urine analysis done, result or chart</td>
                        <td width="110">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                  <td width="25" align="left"><?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['ua_done'])) { if($patientPOCheckListDetails['PreOperativeChecklist']['ua_done'] == 1) echo __('Yes'); else echo __('No'); } ?></td>
                                  <td width="35"></td>
                                  <td width="25"></td>
                                  <td></td>
                                </tr>
                            </table>                        </td>
                      </tr>
                      <tr>
                        <td>6.</td>
                        <td>Operative part are prepared</td>
                        <td width="110">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                  <td width="25" align="left"><?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['op_prepare'])) { if($patientPOCheckListDetails['PreOperativeChecklist']['op_prepare'] == 1) echo __('Yes'); else echo __('No'); } ?></td>
                                  <td width="35"></td>
                                  <td width="25"></td>
                                  <td></td>
                                </tr>
                            </table>                        </td>
                      </tr>
                      <tr>
                        <td>7.</td>
                        <td>Enema given, if ordered</td>
                        <td width="110">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                  <td width="25" align="left"><?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['enema_given'])) { if($patientPOCheckListDetails['PreOperativeChecklist']['enema_given'] == 1) echo __('Yes'); else ('No'); } ?></td>
                                  <td width="35"></td>
                                  <td width="25"></td>
                                  <td></td>
                                </tr>
                            </table>                        </td>
                      </tr>
                     <tr>
                        <td valign="top">8.</td>
                        <td valign="top">N. P. O. notice at bedside</td>
                        <td style="padding-left:15px;">
                        <?php echo $patientPOCheckListDetails['PreOperativeChecklist']['npo_notice_time']; ?>
                        </td>
                      </tr>
                                         
                      <tr>
                        <td valign="top">9.</td>
                        <td>Type and crossmatch done number of blood (units) arranged</td>
                        <td width="110">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                  <td width="25" align="left"><?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['tc_done'])) { if($patientPOCheckListDetails['PreOperativeChecklist']['tc_done'] == 1) echo __('Yes'); else echo __('No'); } ?></td>
                                  <td width="35"></td>
                                  <td width="25"></td>
                                  <td></td>
                                </tr>
                            </table>                        </td>
                      </tr>
                      <tr>
                        <td valign="top">10.</td>
                        <td valign="top">N.P.O. after midnight or since</td>
                        <td style="padding-left:15px;">
                         <?php echo $patientPOCheckListDetails['PreOperativeChecklist']['npo_midnight']; ?>
                        </td>
                      </tr>
                      <tr>
                        <td valign="top">11.</td>
                        <td valign="top">Identification band or wrist, with name, room, hospital number.</td>
                        <td style="padding-left:15px;"><?php echo $patientPOCheckListDetails['PreOperativeChecklist']['identification_band']; ?></td>
                      </tr>
                      <tr>
                        <td valign="top">12.</td>
                        <td valign="top">Name plate with chart</td>
                        <td style="padding-left:15px;">
                         <?php echo $patientPOCheckListDetails['PreOperativeChecklist']['name_plate']; ?>
                        </td>
                      </tr>
                      <tr>
                        <td valign="top">13.</td>
                        <td valign="top">Glasses / contact lenses removed</td>
                        <td width="110">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                  <td width="25" align="left">
                                    <?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['glassess_removed'])) { if($patientPOCheckListDetails['PreOperativeChecklist']['glassess_removed'] == 1) echo __('Yes'); else echo __('No'); } ?>
                                  </td>
                                  <td width="35"></td>
                                  <td width="25">
                                   
                                  </td>
                                  <td></td>
                                </tr>
                            </table>                        </td>
                      </tr>
                      <tr>
                        <td valign="top">14.</td>
                        <td valign="top">Dentures removed</td>
                        <td width="110">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                  <td width="25" align="left">
                                   <?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['dentures_removed'])) { if($patientPOCheckListDetails['PreOperativeChecklist']['dentures_removed'] == 1) echo __('Yes'); else echo __('No'); } ?>
                                  </td>
                                  <td width="35"></td>
                                  <td width="25">
                                  </td>
                                  <td></td>
                                </tr>
                            </table>                         </td>
                      </tr>
                      <tr>
                        <td valign="top">15.</td>
                        <td valign="top">Jewellery removed and secured</td>
                        <td width="110">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                  <td width="25" align="left">
                                   <?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['jewellery_removed'])) { if($patientPOCheckListDetails['PreOperativeChecklist']['jewellery_removed'] == 1) echo __('Yes'); else echo __('No'); } ?>
                                  </td>
                                  <td width="35"></td>
                                  <td width="25">
                                   
                                  </td>
                                  <td></td>
                                </tr>
                            </table>                        </td>
                      </tr>
                      <tr>
                        <td valign="top">16.</td>
                        <td valign="top">Hairpins, makeup, nailpolish removed</td>
                        <td width="110">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                  <td width="25" align="left">
                                  <?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['hairpins_removed'])) { if($patientPOCheckListDetails['PreOperativeChecklist']['hairpins_removed'] == 1) echo __('Yes'); else echo __('No'); } ?>
                                  </td>
                                  <td width="35"></td>
                                  <td width="25">
                                  </td>
                                  <td></td>
                                </tr>
                            </table>                        </td>
                      </tr>
                      <tr>
                        <td valign="top">17.</td>
                        <td valign="top">Head cap and hospital gown on</td>
                       <td width="110">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                  <td width="25" align="left">
                                   <?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['headcap_hp_gown_on'])) { if($patientPOCheckListDetails['PreOperativeChecklist']['headcap_hp_gown_on'] == 1) echo __('Yes'); else echo __('No'); } ?>
                                  </td>
                                  <td width="35"></td>
                                  <td width="25">
                                   
                                  </td>
                                  <td></td>
                                </tr>
                            </table>                        </td>
                      </tr>
                      <tr>
                        <td valign="top">18.</td>
                        <td valign="top">Voided within an hour of surgery</td>
                        <td width="110">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                  <td width="25" align="left">
                                   <?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['voided_surgery'])) { if($patientPOCheckListDetails['PreOperativeChecklist']['voided_surgery'] == 1) echo __('Yes'); else echo __('No'); } ?>
                                  </td>
                                  <td width="35"></td>
                                  <td width="25">
                                  </td>
                                  <td></td>
                                </tr>
                            </table>                        </td>
                      </tr>
                     <tr>
                        <td valign="top">19.</td>
                        <td valign="top">Cathetrised Time</td>
                        <td style="padding-left:15px;">
                        <?php echo $patientPOCheckListDetails['PreOperativeChecklist']['cathertrised_time']; ?>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" valign="top">
                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td width="45" height="35">Temp.&nbsp;:</td>
                                    <td width="70">
                                     <?php echo $patientPOCheckListDetails['PreOperativeChecklist']['temp']; ?>
                                    </td>
                                    <td width="20">&nbsp;</td>
                                    <td width="49">Pulse</td>
                                    <td width="70">
                                     <?php echo $patientPOCheckListDetails['PreOperativeChecklist']['pulse']; ?>
                                    </td>
                                    <td width="20">&nbsp;</td>
                                    <td width="43">Resp.&nbsp;:</td>
                                    <td width="70">
                                     <?php echo $patientPOCheckListDetails['PreOperativeChecklist']['resp']; ?>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            	<tr>
                            	  <td height="35">B.P. :</td>
                            	  <td>
                                   <?php echo $patientPOCheckListDetails['PreOperativeChecklist']['blood_pressure']; ?>
                                  </td>
                            	  <td>&nbsp;</td>
                            	  <td>Weight&nbsp;:</td>
                            	  <td>
                                  <?php echo $patientPOCheckListDetails['PreOperativeChecklist']['weight']; ?>
                                  </td>
                            	  <td>&nbsp;</td>
                            	  <td>&nbsp;</td>
                            	  <td>&nbsp;</td>
                            	  <td>&nbsp;</td>
                          	  </tr>
                            	<tr>
                            	  <td height="35" colspan="9">PRE-OPERATIVE MEDICATION ORDER</td>
                           	  </tr>
                            </table>
                         </td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                            <td width="50" height="35">&nbsp;</td>
                            <td width="70">&nbsp;</td>
                            <td width="20">&nbsp;</td>
                            <td width="70"></td>
                            <td width=""></td>                                                       
                          </tr>
                          <tr>
                            <td height="35">Given&nbsp;:</td>
                            <td>
                            <?php echo $patientPOCheckListDetails['PreOperativeChecklist']['pre_given']; ?>
                            </td>
                            <td></td>
                            <td>&nbsp;</td>
                            <td><table width="275" border="0" cellspacing="0" cellpadding="0" >
                              <tr>
                               <td>Date&nbsp;:</td>
                                <td>
                                 <?php if(!empty($patientPOCheckListDetails['PreOperativeChecklist']['pre_date']) && $patientPOCheckListDetails['PreOperativeChecklist']['pre_date'] != "0000-00-00" ) echo $this->DateFormat->formatDate2Local($patientPOCheckListDetails['PreOperativeChecklist']['pre_date'],Configure::read('date_format'));?>
                                </td>
                                
                              </tr>
                            </table></td>
                          </tr>

                        </table></td>
                        
                        <td valign="bottom"></td>
                      </tr>
                    </table>
                    <div class="clr ht5"></div>
                    <div class="btns">
                          <?php echo $this->Html->link('Print','#',
			 array('class'=>'blueBtn', 'escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('admin' => false, 'action'=>'print_ot_pre_operative_checklist',$patientPOCheckListDetails['PreOperativeChecklist']['id']))."', '_blank',
			 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,left=400,top=400,height=600,width=800');  return false;"));
   			 ?>
                         
		    </div>
                    <div class="clr ht5"></div>

