<?php
//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Time_Taken_For_Discharge".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
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
				<td colspan = "8" align="center"><h2><?php echo __('Time Taken For Discharge').' - '.$reportYear; ?></h2></td>
			  </tr>
			  <tr class="row_title">
			       <td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></td>	
				   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Date of Reg.'); ?></strong></td>
				   <td height="30px" align="center" valign="middle" width="12%"><strong><?php echo __('MRN'); ?></strong></td>					  
				   <td height="30px" align="center" valign="middle" width="12%"><strong><?php echo __('Patient Name'); ?></strong></td>  
				   <td height="30px" align="center" valign="middle" width="8%"><strong><?php echo __('Age'); ?></strong></td>
				   <td height="30px" align="center" valign="middle" width="8%"><strong><?php echo __('Sex'); ?></strong></td>
				   <td height="30px" align="center" valign="middle" width="8%"><strong><?php echo __('Discharge Date'); ?></strong></td>
				   <td height="30px" align="center" valign="middle" width="8%"><strong><?php echo __('Discharge Time'); ?></strong></td>
			   </tr>
		<?php  
			
	  		if(!empty($record[0])) {
			   $k = 1; 
				$totalDischarge ='';
				$totalDischargeTime = '';
				$finalremTime=0;
	      		foreach($record as $patient){	
									
					?>
					<tr>			
					    <td align='center' height='17px'><?php echo $k ?></td>
						<td align='center' height='17px'><?php echo date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],'yyyy/mm/dd',true))); ?></td>
					    <td align='center' height='17px'><?php echo $patient['Patient']['admission_id'] ?></td>					   
					    <td align='center' height='17px'><?php echo $patient['PatientInitial']['name']." ".$patient['Patient']['lookup_name'] ?></td>
					    <td align='center' height='17px'><?php echo $patient['Person']['age'] ?></td>  
					    <td align='center' height='17px'><?php echo ucfirst($patient['Person']['sex']); ?></td>
						<td align='center' height='17px'>
						<?php
							$split = explode(' ',$patient['FinalBilling']['discharge_date']);
							echo  $this->DateFormat->formatDate2Local($patient['FinalBilling']['discharge_date'],Configure::read('date_format'),true);
						?></td>
						<td align='center' height='17px'>
						<?php 
						// Calculate time taken for discharge for each patient
							$totalDischarge = abs(strtotime($patient['DischargeSummary']['review_on'])-strtotime($patient['FinalBilling']['discharge_date']));			
							$totalDischargeTime = round($totalDischarge/60,2);
							//BOF pankaj
							$datetime1 = new DateTime($patient['FinalBilling']['discharge_date']);
							$datetime2 = new DateTime($patient['DischargeSummary']['review_on']);
							$interval = $datetime1->diff($datetime2);
							//EOF cal
							$timeDay 	= $interval->days;
							$timeDaySec = $timeDay*3600*24;
							$timeHr 	= $interval->h;
							$timeHrSec 	= $timeHr*3600;
							$timeMin 	= $interval->i;
							$timeMinSec = $timeMin*60;
							$timeSecSec	= $interval->s ;
							$timeSec 	= $interval->s;
							
						 	$finalremTime +=  (int)$timeDaySec+(int)$timeHrSec+(int)$timeMinSec+(int)$timeSecSec;
							
							echo $finalTime =  $timeDay." days ".$timeHr." hours ".$timeMin." minutes ".$timeSec." seconds " ;//EOF pankaj
						?>  </td> 		   
					</tr>
					<?php   
				 $k++; 
			   }
				//BOF avg
			 $finalremTime =  $finalremTime /(int)count($record) ; 
			//BOF 
				$days = (int) ($finalremTime/86400);
				$finalremTime = $finalremTime-($days*86400);
				$hours = (int)($finalremTime/3600);
				$finalremTime = $finalremTime-($hours*3600);
				$minutes = (int)($finalremTime/60);
				$finalremTime =(int) $finalremTime-($minutes*60);
			//EOF			
			$avgtime = ($days>0)?$days."Days ":"0 Days " ;
			$avgtime .= ($hours>0)?$hours."hrs ":"0 Hrs " ; 
			$avgtime .= ($minutes>0)?$minutes."Minutes ":"0 Minutes " ;  	
			$avgtime .= ($finalremTime>0)?$finalremTime."Sec ":"0 sec " ;
				//EOF avg
			  ?>
			   <tr> 
			   		<td height="30px" align="center" valign="bottom" colspan="8"><strong>Total Patients:<?php echo (count($record)) ; ?></strong></td>											
					 		
				</tr> 
				<tr> 
			   		<td height="30px" align="center" valign="bottom" colspan="8"><strong>Average Time Taken For Each Patient : <?php echo $avgtime ; ?> </strong></td>					 		
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
		
