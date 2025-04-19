<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Waiting_Time_for_Initial_Assessment_Of_Out-Patient".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
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
   <td colspan = "8" align="center"><h2><?php echo __('Waiting Time for Initial Assessment Of Out-Patient').' - '.$reportYear; ?></h2></td>
  </tr>
				  <tr class="row_title">
				       <td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></td>
					   <td height="30px" align="center" valign="middle" width="12%"><strong><?php echo __('MRN'); ?></strong></td>					  
					   <td height="30px" align="center" valign="middle" width="12%"><strong><?php echo __('Patient Name'); ?></strong></td>  
					   <td height="30px" align="center" valign="middle" width="8%"><strong><?php echo __('Age'); ?></strong></td>
					   <td height="30px" align="center" valign="middle" width="8%"><strong><?php echo __('Sex'); ?></strong></td>
					   <td height="30px" align="center" valign="middle" width="8%"><strong><?php echo __('Appointment Date/Time'); ?></strong></td>
					   <td height="30px" align="center" valign="middle" width="8%"><strong><?php echo __('Doc.Ini.Ass. Start Time'); ?></strong></td>
					   <td height="30px" align="center" valign="middle" width="12%"><strong><?php echo __('Duration(In Min.)'); ?></strong></td>					  
				   </tr>
		<?php  
			
	  		if(!empty($record[0])) {
			   $k = 1; 
			
	      		foreach($record as $patient){	
									
					?>
					<tr>	
					    <td align='center' height='17px'><?php echo $k; ?></td>
					    <td align='center' height='17px'><?php echo $patient['admission_id'] ?></td>					   
					    <td align='center' height='17px'><?php echo $patient['name']." ".$patient['lookup_name'] ?></td>
					    <td align='center' height='17px'><?php echo $patient['age'] ?></td>  
					    <td align='center' height='17px'><?php echo ucfirst($patient['sex']); ?></td>
						<td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($patient['apt_date'],Configure::read('date_format')).' '.$patient['apt_start_time']; ?></td>	
									
					<?php $splitDate = explode(' ',$patient['doc_ini_assess_on']);?>		    
						<td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($patient['doc_ini_assess_on'],Configure::read('date_format'),true); ?></td>
					    <td align='center' height='17px'><?php echo $patient['duration'] ?> Min</td>					   
					</tr>
					<?php   
				 $k++; 
			   }

			  ?>
			   <tr> 
			   		<td height="30px" align="center" valign="bottom" colspan="8"><strong>Total Patients:<?php echo (count($record)) ; ?></strong></td>											
							
						</tr>
				<?php 		  
				 } else {
					?> <tr>
									<td align="center" height="17px" colspan="8" > No Record Found</td>
									
								</tr>
<?php 
				 }
		?>			   		  
		</table>
		
