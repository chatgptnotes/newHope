<div id="printButton">
  <?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));?>
</div>
<body class="print_form"  onload="window.print();"> <!-- onload="window.print();window.close();" -->
<div class="ht5">&nbsp;</div>
<?php 
	echo $this->element('patient_header') ;
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="right">
	<tr>
		<td width="8%" class="" align=""><b>Date :&nbsp;</b></td>
		<td width="90%"><?php echo $this->DateFormat->formatDate2Local($patientPhysioAssessDetails['PhysiotherapyAssessment']['submit_date'],Configure::read('date_format'), true) ?></td>
	</tr>
</table>
<div class="clr ht5"></div>
	<table width="100%" border="1" cellspacing="0" cellpadding="5" class="">
                      <tr>
                      	 <th colspan="2">Basic Information</th>
                      </tr>
                      <tr>
                        <td width="50%" align="left" valign="top" style="padding-top:7px;">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                              <tr>
                                <td width="40%" height="25" valign="top">Physiotherapist </td>
                                <td align="left" valign="top">
                                 <?php echo $patientPhysioAssessDetails['PhysiotherapyAssessment']['physiotherapist_incharge']; ?>
                                </td>
                               </tr>
                              <tr>
                                <td valign="top" height="25">Chief Complaints</td>
                                <td align="left" valign="top">
                                 <?php echo $patientPhysioAssessDetails['PhysiotherapyAssessment']['chief_complaints']; ?>
                                </td>
                              </tr>
                              <tr>
                                <td  valign="top" height="25">Observation</td>
                                <td align="left" valign="top">
                                 <?php echo $patientPhysioAssessDetails['PhysiotherapyAssessment']['observation']; ?>
                                </td>
                              </tr>
                              <tr>
                                <td height="25" valign="top">Sensory</td>
                                <td align="left" valign="top">
                                 <?php echo $patientPhysioAssessDetails['PhysiotherapyAssessment']['sensory']; ?>
                                </td>
                               </tr>
                              
                               
                       	  </table>
                        </td>
                        <td  align="left" valign="top" style="padding-top:7px;" width="50%">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                                <tr>
                                <td height="25" valign="top">Reflexes</td>
                                <td align="left" valign="top">
                                 <?php echo $patientPhysioAssessDetails['PhysiotherapyAssessment']['reflexes']; ?>
                                </td>
                               </tr>
                                <tr>
                                <td height="25" valign="top">Motor</td>
                                <td align="left" valign="top">
                                 <?php echo $patientPhysioAssessDetails['PhysiotherapyAssessment']['motor']; ?>
                                </td>
                               </tr>
                               <tr>
                                <td height="25" valign="top">Notes</td>
                                <td align="left" valign="top">
                                 <?php echo $patientPhysioAssessDetails['PhysiotherapyAssessment']['notes']; ?>
                                </td>
                               </tr>
                               <tr>
                                <td height="25" valign="top">Chest PT</td>
                                <td align="left" valign="top">
                                 <?php echo $patientPhysioAssessDetails['PhysiotherapyAssessment']['chest_pt']; ?>
                                </td>
                               </tr>
                               <tr>
                                <td height="25" valign="top">Limb PT</td>
                                <td align="left" valign="top">
                                 <?php echo $patientPhysioAssessDetails['PhysiotherapyAssessment']['limb_pt']; ?>
                                </td>
                               </tr>
                       	  </table>
                        </td>
                      </tr>
                    </table> <div class="clr ht5"></div> 
</body>