<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo __('O. T. List'); ?></title>
<style>
	body{margin:10px 0 0 0; padding:0; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000000;}
	.heading{font-size:33px; font-weight:bold; letter-spacing:-1px;}
	.tblHead{font-size:14px; font-weight:bold;}
	.boxBorder{border:1px solid #5d5d5d;}
	.boxBorderBot{border-bottom:1px solid #5d5d5d;}
	.boxBorderRight{border-right:1px solid #5d5d5d;}
	.tdBorderRtBt{border-right:1px solid #5d5d5d; border-bottom:1px solid #5d5d5d;}
	.tdBorderBt{border-bottom:1px solid #5d5d5d;}
	.tdBorderTp{border-top:1px solid #5d5d5d;}
	.tdBorderRt{border-right:1px solid #5d5d5d;}
	.tdBorderTpBt{border-bottom:1px solid #5d5d5d; border-top:1px solid #5d5d5d;}
	.tdBorderTpRt{border-top:1px solid #5d5d5d; border-right:1px solid #5d5d5d;}
	.columnPad{padding:5px;}
	.columnLeftPad{padding-left:5px;}
	.tbl{background:#CCCCCC;}
	.tbl td{background:#FFFFFF;}
	.totalPrice{font-size:14px;}
	.adPrice{border:1px solid #CCCCCC; border-top:0px; padding:3px;}
</style>
</head>
<body onload="window.print();window.close();"> 
 <table width="1100" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
   	  <td width="200" valign="top" style="padding-bottom:5px;"><?php echo $this->Html->image('/img/hope-logo.gif', array('alt' => '')); ?></td>
        <td width="" align="center" valign="middle" class="heading">O. T. LIST</td>
        
    </tr>
</table>
<table width="1100" border="0" cellspacing="0" cellpadding="3" align="center" class="boxBorder" style="border-bottom:0px;">
  <tr>
   <td width="50" align="center" class="tblHead tdBorderRtBt"><?php echo __('Sr. No.') ?></td>
   <td  width="70" align="center" class="tblHead tdBorderRtBt"><?php echo __('Time') ?></td>
   <td width="70" align="center" class="tblHead tdBorderRtBt"><?php echo __('Room No.') ?></td>
   <td width="180" align="center" class="tblHead tdBorderRtBt"><?php echo __('Table No.') ?></td>
   <td width="180" align="center" class="tblHead tdBorderRtBt"><?php echo __('Name of Patient') ?></td>
   <td width="150" align="center" class="tblHead tdBorderRtBt"><?php echo __('Diagnosis') ?></td>
   <td width="150" align="center" class="tblHead tdBorderRtBt"><?php echo __('Surgery') ?></td>
   <td width="80" align="center" class="tblHead tdBorderRtBt"><?php echo __('Major/Minor') ?></td>
   <td width="100" align="center" class="tblHead tdBorderRtBt"><?php echo __('Surgeon') ?></td>
   <td width="100" align="center" class="tblHead tdBorderRtBt"><?php echo __('Anesthetist') ?></td>
   <td width="100" align="center" class="tblHead tdBorderBt"><?php echo __('Anaesthesia') ?></td>
  </tr>
  <?php 
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $otdata): 
       $cnt++;
  ?>
   <tr>
   <td align="center" class="tdBorderRtBt"><?php echo $cnt; ?></td>
   <td align="center" class="tdBorderRtBt"><?php echo $otdata['OptAppointment']['start_time']; ?></td>
   <td align="center" class="tdBorderRtBt"><?php echo $otdata['Opt']['name']; ?></td>
   <td align="center" class="tdBorderRtBt"><?php echo $otdata['OptTable']['name']; ?></td>
   <td align="center" class="tdBorderRtBt"><?php echo $otdata['Patient']['lookup_name']; ?></td>
   <td align="center" class="tdBorderRtBt"><?php echo $otdata['OptAppointment']['diagnosis']; ?></td>
   <td align="center" class="tdBorderRtBt"><?php echo $otdata['Surgery']['name']; ?></td>
   <td align="center" class="tdBorderRtBt"><?php echo $otdata['OptAppointment']['operation_type']; ?></td>
   <td align="center" class="tdBorderRtBt"><?php echo $otdata['DoctorProfile']['doctor_name']; ?></td>
   <td align="center" class="tdBorderRtBt"><?php echo $otdata['Doctor']['full_name']; ?></td>
   <td align="center" class="tdBorderRtBt"><?php echo $otdata['OptAppointment']['anaesthesia']; ?></td>
  </tr>
  <?php 
       endforeach;
      } else {
  ?>
  <tr>
   <td colspan="11" align="center"><?php echo __('No record found', true); ?>.</td>
  </tr>
  <?php
      }
  ?>
  </table>
 <table width="1100" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
   	  <td width="200" valign="top"></td>
        
    </tr>
</table>
<?php echo $this->element('report_footer');?>
</body>
</html>
		 