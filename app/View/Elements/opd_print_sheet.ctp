<html moznomarginboxes mozdisallowselectionprint>

<table width="100%" align="center" cellpadding="1" cellspacing="4" border="0" class="tbl" style="border: 0px solid #3e474a; margin-top: 110px" >
	<?php $plot=$patient['Person']['plot_no'];
	      $city= $patient['Person']['city'];
	      $pin= $patient['Person']['pin_code'];
	      $data= $plot." ".$city." ".$pin; 
	      $address=strip_tags($data);
	?>
<tr>
	<td valign="top" style="width: 21%"></td>
	<td align="left" valign="middle" style="width: 40%"><font size="2px" face="Verdana"><?php echo $complete_name  =  $patient['Patient']['lookup_name'] ; ?></font></td>
	<td valign="middle" id="boxSpace3"></td>
	<td  valign="middle" style="text-align: right ;padding-right: 7%" ><font size="2px" face="Verdana"><?php echo ucfirst($sex);?>/ <?php echo ucfirst($age)?></font></td>
</tr>	
<tr>
	<td valign="middle"></td>
	<td align="left" valign="middle"><font  size="2px" face="Verdana">
	<?php if(strlen($address)<=44)
      	{
      		echo $address;
      	}
      	else
      	{
      		$addressWrap=substr($address,0,44) . '...';
      		echo $addressWrap;
      	}?></font></td>
	<td valign="middle" id="boxSpace3"></td>
	<td valign="middle" style="text-align: right;padding-right: 7%" ><font size="2px" face="Verdana"><?php echo $patient['Person']['mobile'] ;?></font></td>
</tr>	

<tr>
		<td valign="middle"></td>
		<td align="left" valign="middle"><font size="2px" face="Verdana"><?php echo $patient['Patient']['patient_id']."&nbsp;&nbsp;". $patient['Patient']['admission_id'] ;?></font></td>
		<td valign="middle" id="boxSpace3"></td>
		<td  valign="middle" style="text-align: left" ><font  size="2px" face="Verdana"><?php echo $this->DateFormat->formatdate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);?></font>
		</td>
</tr>	
<tr>
		<td valign="middle" height="24"></td>
		<td align="left" valign="middle"><font size="2px" face="Verdana"><?php //echo $patient['Patient']['patient_id'] ;?></font></td>
		<td valign="middle" id="boxSpace3"></td>
		<td  valign="middle" style="text-align: left" ><font size="2px" face="Verdana"><?php //echo $this->DateFormat->formatdate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);?></font></td>
</tr>	
<tr>
		<td valign="middle"></td>
		<td align="left" valign="middle"></td>
		<td valign="middle" id="boxSpace3"></td>
		<td  valign="middle" style="text-align: left;"><font size="2px" face="Verdana"><?php echo ucfirst($doctorName[0]['fullname']) ;?></font></td>
</tr>
</table>
<?php //debug($patient);?>
<script type="text/javascript">
window.onload = function() { window.print(); }
</script>
</html>