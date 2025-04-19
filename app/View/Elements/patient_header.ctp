<style>
table td {
    font-size: 12px;
}
</style>
<p class="ht5"></p> 
<div>&nbsp;</div>
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="tbl">
          <tr>
            <td width="107"><strong>Name:</strong></td>
            <td width="327" align="left"><?php  if(empty($patient[0]['lookup_name'])) echo $patient['Initial']['name'].' '.$patient['Patient']['lookup_name']; else echo $patient[0]['lookup_name'];?></td>
            <td width="176" align="left"><strong>Visit ID:</strong></td>
            <td width="267"><?php echo $patient['Patient']['admission_id'];?></td>
            </tr>
          <tr>
            <td valign="top"><strong>Address:</strong></td>
            <td><?php echo $address;?></td>
            <td align="left" valign="top"><strong>Age/Sex:</strong></td>
            <td align="left" valign="top"><?php echo $age." / ".ucfirst($sex);?></td>
            </tr>
          <tr>
            <td valign="top"><strong>Consultant:</strong></td>
            <td><?php echo $treating_consultant[0]['fullname'] ;?></td>
           <!--  <td valign="top"><strong>DrM Patient Reg.</strong></td>
            <td><?php echo $patient['Person']['patient_uid']; ;?></td> -->
          <td align="left" valign="top"><strong>Result Published On:</strong></td>
        <td align="left" valign="top">
			<?php  
						$resultDatVal = isset($data[0]['RadiologyResult']['result_publish_date'])?$this->DateFormat->formatDate2Local($data[0]['RadiologyResult']['result_publish_date'],Configure::read('date_format'),true):'' ;
						echo $resultDatVal; ?>
			<?php //echo $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);?></td> 
          </tr>
          
          <!--<tr>
            <td valign="top"><strong>Bill No.:</strong></td>
            <td><?php echo $patient['FinalBilling']['bill_number'];?></td>
            <td align="left" valign="top"><strong>DOD:</strong></td>
            <td align="left" valign="top"><?php echo $this->DateFormat->formatDate2Local($patient['FinalBilling']['discharge_date'],Configure::read('date_format'),true); ?></td>
          </tr>
        -->
</table>
<div>&nbsp;</div>