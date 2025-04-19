<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Particular_Incident_Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
header ("Content-Description: Generated Report" );
?>
<STYLE type='text/css'>
	.tableTd {
	   	border-width: 0.5pt; 
		border: solid; 
	}
	.tableTdContent{
		border-width: 0.5pt; 
		border: solid;
	}
	#titles{
		font-weight: bolder;
	}
   
</STYLE>
 
			<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">	
			  <tr class="row_title">
				<td colspan = "10" align="center"><h2><?php echo ('Particular Incident Report').' - '.$reportYear; ?></h2></td>
			  </tr>
			  <tr class="row_title">
			       <td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></td>
				   <td height="30px" align="center" valign="middle" width="12%"><strong><?php echo __('Date of Reg.'); ?></strong></td>	
				   <td height="30px" align="center" valign="middle" width="12%"><strong><?php echo __('MRN'); ?></strong></td>					  
				   <td height="30px" align="center" valign="middle" width="12%"><strong><?php echo __('Patient Name'); ?></strong></td>  
				   <td height="30px" align="center" valign="middle" width="8%"><strong><?php echo __('Age'); ?></strong></td>
				   <td height="30px" align="center" valign="middle" width="8%"><strong><?php echo __('Sex'); ?></strong></td>
				   <td height="30px" align="center" valign="middle" width="8%"><strong><?php echo __('Incident Type'); ?></strong></td>
				   <td height="30px" align="center" valign="middle" width="8%"><strong><?php echo __('Incident Name'); ?></strong></td>
				   <td height="30px" align="center" valign="middle" width="8%"><strong><?php echo __('Incident Date'); ?></strong></td>
				   <td height="30px" align="center" valign="middle" width="12%"><strong><?php echo __('Incident Time'); ?></strong></td>					  
			   </tr>
		<?php  
			
	  		if(!empty($record[0])) {
			   $k = 1; 
			
	      		foreach($record as $patient){	
									
					?>
					<tr>	
					    <td align='center' height='17px'><?php echo $k; ?></td>	
						<td align='center' height='17px'><?php echo date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],'yyyy/mm/dd', true))); ?></td>
					    <td align='center' height='17px'><?php echo $patient['Patient']['admission_id'] ?></td>					   
					    <td align='center' height='17px'><?php echo $patient['PatientInitial']['name']." ".$patient['Patient']['lookup_name'] ?></td>
					    <td align='center' height='17px'><?php echo $patient['Person']['age'] ?></td>  
					    <td align='center' height='17px'><?php echo ucfirst($patient['Person']['sex']); ?></td>
						<td align='center' height='17px'><?php echo $incidentType; ?></td>
					<?php if($incidentType == 'medication_error'){?>
						<td align='center' height='17px'><?php echo ucfirst($patient['Incident']['medication_error']) ?></td>
					<?php } else { ?>
						<td align='center' height='17px'><?php echo ucfirst($patient['Incident']['analysis_option']) ?></td>
					<?php } ?>
						<td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($patient['Incident']['incident_date'],Configure::read('date_format')); ?></td> 
						<td align='center' height='17px'><?php echo $patient['Incident']['incident_time']; ?></td>
					    					   
					</tr>
					<?php   
				 $k++; 
			   }

			  ?>
			   <tr> 
			   		<td height="30px" align="center" valign="bottom" colspan="10"><strong>Total Patients:<?php echo (count($record)) ; ?></strong></td>											
							
						</tr>
				<?php 		  
				 } else {
					?> <tr>
									<td align="center" height="17px" colspan="10" > No Record Found</td>
									
								</tr>
<?php 
				 }
		?>			   		  
		</table>
		
