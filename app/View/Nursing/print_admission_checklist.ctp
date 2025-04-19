<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>
		<?php echo __('Hope', true); ?>
		<?php echo $title_for_layout; ?>
</title>
<style>
.ht5 {
    height: 10px;
    margin: 0;
    padding: 0;
}
</style>
</head>
<body class="print_form"  onload=" "> <!-- onload="window.print();window.close();" -->
<div class="ht5">&nbsp;</div>
<div class="clr ht5"></div>
<?php echo $this->element('print_patient_info');?>
<div class="clr ht5"></div>
<div align="center">
		
	<h3>Registration Check List</h3>
</div>
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="right">
	<tr>
		<td width="8%" class="tdLabel2" align="right"><b><font color="#000"> <?php echo __('Date :')?></font>&nbsp;</b></td>
		<td width="90%"><?php echo $this->DateFormat->formatDate2Local($lastEntry['AdmissionChecklist']['date'],Configure::read('date_format'))." ".$lastEntry['AdmissionChecklist']['time']; ?></td>
	</tr>
</table>
<div class="ht5">&nbsp;</div>
<table width="99%" border="1" cellspacing="1" cellpadding="0" class="tabularForm">
  <tr>
	 <th width="1%">Sr. No.</th>
	 <th width="15%">Particulars</th>
	 <th width="2%">Complition</th>
	 <th width="27%">Remark</th>
  </tr>
  <tr>
	<td align="center">1.</td>
	<td align="left">Patient's File</td>
	<td align="center"><?php echo $lastEntry['AdmissionChecklist']['patient_file'];?></td>
	<td style="padding-left:10px;"><?php echo $lastEntry['AdmissionChecklist']['patient_file_remark'];?></td>
  </tr>
  <tr>
	<td align="center">2.</td>
	<td align="left">Deposit Receipt</td>
	<td align="center"><?php echo $lastEntry['AdmissionChecklist']['deposit_receipt'];?></td>
	<td style="padding-left:10px;"><?php echo $lastEntry['AdmissionChecklist']['deposit_receipt_remark'];?></td>
  </tr>
  <tr>
	<td align="center">3.</td>
	<td align="left">Identification Band</td>
	<td align="center"><?php echo $lastEntry['AdmissionChecklist']['identification_band'];?></td>
	<td style="padding-left:10px;"><?php echo $lastEntry['AdmissionChecklist']['identification_band_remark'];?></td>
  </tr>
  <tr>
	<td align="center">4.</td>
	<td align="left">Assessment Form</td>
	<td align="center"><?php echo $lastEntry['AdmissionChecklist']['assessment_form'];?></td>
	<td style="padding-left:10px;"><?php echo $lastEntry['AdmissionChecklist']['assessment_form_remark'];?></td>
  </tr>
  <tr>
	<td align="center">5.</td>
	<td align="left">Unit Readiness</td>
	<td align="center"><?php echo $lastEntry['AdmissionChecklist']['unit_readiness'];?></td>
	<td style="padding-left:10px;"><?php echo $lastEntry['AdmissionChecklist']['unit_readiness_remark'];?></td>
  </tr>
  <tr>
	<td align="center">6.</td>
	<td align="left">Orientation to Patient</td>
	<td align="center"><?php echo $lastEntry['AdmissionChecklist']['orientation_to_patient'];?></td>
	<td style="padding-left:10px;"><?php echo $lastEntry['AdmissionChecklist']['orientation_to_patient_remark'];?></td>
  </tr>
  <tr>
	<td align="center">7.</td>
	<td align="left">Orientation to Relative</td>
	<td align="center"><?php echo $lastEntry['AdmissionChecklist']['orientation_to_relative'];?></td>
	<td style="padding-left:10px;"><?php echo $lastEntry['AdmissionChecklist']['orientation_to_relative_remark'];?></td>
  </tr>
  <tr>
	<td align="center">8.</td>
	<td align="left">Patient Uniform</td>
	<td align="center"><?php echo $lastEntry['AdmissionChecklist']['patient_uniform'];?></td>
	<td style="padding-left:10px;"><?php echo $lastEntry['AdmissionChecklist']['patient_uniform_remark'];?></td>
  </tr>
  <tr>
	<td align="center">9.</td>
	<td align="left">Drinking Water</td>
	<td align="center"><?php echo $lastEntry['AdmissionChecklist']['drinking_water'];?></td>
	<td style="padding-left:10px;"><?php echo $lastEntry['AdmissionChecklist']['drinking_water_remark'];?></td>
  </tr>
  <tr>
	<td align="center">10.</td>
	<td align="left">Glass with Cover</td>
	<td align="center"><?php echo $lastEntry['AdmissionChecklist']['glass_with_cover'];?></td>
	<td style="padding-left:10px;"><?php echo $lastEntry['AdmissionChecklist']['glass_with_cover_remark'];?></td>
  </tr>
  <tr>
	<td align="center">11.</td>
	<td align="left">Information to RMO</td>
	<td align="center"><?php echo $lastEntry['AdmissionChecklist']['information_to_rmo'];?></td>
	<td style="padding-left:10px;"><?php echo $lastEntry['AdmissionChecklist']['information_to_rmo_remark'];?></td>
  </tr>
  <tr>
	<td align="center">12.</td>
	<td align="left">Information to Consultant</td>
	<td align="center"><?php echo $lastEntry['AdmissionChecklist']['information_to_consultant'];?></td>
	<td style="padding-left:10px;"><?php echo $lastEntry['AdmissionChecklist']['information_to_consultant_remark'];?></td>
  </tr>
  <tr>
	<td align="center">13.</td>
	<td align="left">Vital Sings Checked</td>
	<td align="center"><?php echo $lastEntry['AdmissionChecklist']['vital_sign_checked'];?></td>
	<td style="padding-left:10px;"><?php echo $lastEntry['AdmissionChecklist']['vital_sign_checked_remark'];?></td>
  </tr>
  <tr>
	<td align="center">14.</td>
	<td align="left">Preparation for OT</td>
	<td align="center"><?php echo $lastEntry['AdmissionChecklist']['preparation_for_ot'];?></td>
	<td style="padding-left:10px;"><?php echo $lastEntry['AdmissionChecklist']['preparation_for_ot_remark'];?></td>
  </tr>
  <tr>
	<td align="center">15.</td>
	<td align="left">Information to Dietician</td>
	<td align="center"><?php echo $lastEntry['AdmissionChecklist']['information_to_dieticion'];?></td>
	<td style="padding-left:10px;"><?php echo $lastEntry['AdmissionChecklist']['information_to_dieticion_reamrk'];?></td>
  </tr>
  <tr>
	<td align="center">16.</td>
	<td align="left">Diet Given in Time</td>
	<td align="center"><?php echo $lastEntry['AdmissionChecklist']['diet_given_time'];?></td>
	<td style="padding-left:10px;"><?php echo $lastEntry['AdmissionChecklist']['diet_given_time_remark'];?></td>
  </tr>
  <tr>
	<td align="center">17.</td>
	<td align="left">Sate Medication Given</td>
	<td align="center"><?php echo $lastEntry['AdmissionChecklist']['set_medication_given'];?></td>
	<td style="padding-left:10px;"><?php echo $lastEntry['AdmissionChecklist']['set_medication_given_reamrk'];?></td>
  </tr>
</table>
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
	  <td width="140" height="35"  align="left"><b><font color="#000"> <?php echo __('Name of Staff Nurse')?></font></b></td>
	  <TD width="10"><?php echo __(':')?></TD>
	  <td  align="left">&nbsp;<?php echo $lastEntry['AdmissionChecklist']['staff_nurse'];?></td>
	  <td>&nbsp;</td>
	</tr>
	<tr>
	  <td height="35"  align="left"><b><font color="#000"> <?php echo __('Name of Floor In Charge')?></font></b></td>
	  <TD><?php echo __(':')?></TD>
	  <td  align="left">&nbsp;<?php echo $lastEntry['AdmissionChecklist']['floor_incharge'];?></td>
	  <td>&nbsp;</td>
  </tr>
</table>  
</body>