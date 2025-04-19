<style>
	body{margin:120px 0 0 0; padding:0;}
</style>
<table align="center" border="0" width="100%">
	<tr height="70px"><td style="color: red;font-size: 18px;text-align: center; margin:0 auto;" colspan="3"><u><?php echo strtoupper($radData['ServiceProvider']['name']);?> REQUISITION</u></td></tr>
	<tr>
         <td align="left">Date : <b><?php echo $this->DateFormat->formatDate2local($radData['RadiologyTestOrder']['radiology_order_date'],Configure::read('date_format'));?></b>
         <td align="right">Tariff : <b><?php echo $radData['TariffStandard']['name']; ?></b>
         <td align="right">Mode : <b><?php echo $radData['ExternalRequisition']['mode']!=''?$radData['ExternalRequisition']['mode']:$tariff; ?></b>
	</tr>
</table>
<table align="center" width="100%" border="0" cellpadding="5" cellspacing="10">
	<tr><td align="left" width="35%">Name : </td><td align="left"><?php echo $radData['Patient']['lookup_name']; ?></td><td width="10%">Patient Id : </td><td><?php echo ucfirst($radData['Patient']['admission_id']); ?></td></tr>
	<tr>
		<td align="left" width="35%">Age : </td><td width="25%"><?php echo explode("Y",$radData['Patient']['age'])[0]." yrs"; ?></td>
		<td width="10%">Sex : </td><td><?php echo ucfirst($radData['Patient']['sex']); ?></td></tr>
	<tr><td align="left" width="35%">Referring Doctor : </td><td colspan="3"><?php echo "Dr. BK Murali MBBS"; ?></td></tr>
	<tr><td align="left" width="35%">Clinical Details : </td><td colspan="3"><?php echo $radData['ExternalRequisition']['clinical_details'];?></td></tr>
	<tr><td align="left" width="35%">Diagnosis : </td><td colspan="3"><?php echo $radData['Diagnosis']['final_diagnosis'];?></td></tr>
	<tr><td align="left" width="35%">Detail of Investigation required : </td><td colspan="3"><?php echo $radData['RadiologyTestOrder']['testname'];?></td></tr>
	<tr><td></td><td colspan="3"><?php  echo $radData['ExternalRequisition']['investigation_details'];?></td>
</table>
<table align="left" border="0">
	<tr>
		<td align="left" rowspan="4" valign="top"><?php echo __("Provider Name and Address : ");?></td>
	</tr>
	<tr>
        <td align="left"><?php echo strtoupper($radData['ServiceProvider']['name']);?></td>
	</tr>
	<tr> 
         <td align="left"><?php echo strtoupper($radData['ServiceProvider']['contact_person']);?></td>
	</tr>
	<tr> 
         <td align="left"><?php echo strtoupper($radData['ServiceProvider']['location']);?></td>
	</tr>
</table>
<table align="center" border="0" width="100%">
	<tr>
         <td align="center"><div align="right" id="printBtn"><a class="blueBtn" href="#" onclick="this.style.display='none';window.print();">Print</a></div></td>
	</tr>
</table>

