<?php 
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Pharmacy_Sales_Collection_Report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
header ("Content-Description: Generated Report" );  
ob_clean();
flush();
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
   /*.row_title{
		background: #ddd;
	}
	 .rowColor{
   		background-color:gray;
   		border-bottom-color: black;
   }*/
</STYLE>

<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">	
			  <tr style='background:#3796CB;color:#FFFFFF;'>
				<td colspan = "5" align="center"><strong>Pharmacy Sales Collection Report</strong></td>
			  </tr>
			  <tr>
				<td colspan = "5" align="center"><strong><?php echo $this->DateFormat->formatDate2Local($from,Configure::read('date_format'), false); ?></strong> to <strong><?php echo $this->DateFormat->formatDate2Local($to,Configure::read('date_format'), false);?></strong></td>
			  </tr>
			  <tr style='background:#3796CB;color:#FFFFFF;'>
			   		<td height="30px" align="center" valign="middle" width="6%"><strong><?php echo __('Sr. No.'); ?></strong></td> 
			  	   <td height="30px" align="center" valign="middle" width="23%"><strong><?php echo __('Date'); ?></strong></td> 
				 		  
				   <td height="30px" align="center" valign="middle" width="25%"><strong><?php echo __('Patient Name'); ?></strong></td>  
				  
 					<td height="30px" align="center" valign="middle" width="23%"><strong><?php echo __('Credit Amount'); ?></strong></td>
 					<td height="30px" align="center" valign="middle" width="23%"><strong><?php echo __('Cash Amount'); ?></strong></td>
 					
			   </tr>
			<?php 
				if(count($recordArr)>0) {
			    $k = 0; 
					$cnt=1;
					//$totCash=0;
					//$totCredit=0;
	      		foreach($recordArr as $key=>$report){?>
						<tr>
							<td align='center' height='17px'><?php echo $cnt;?></td>
							<td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($report['PharmacySalesBill']['create_time'],Configure::read('date_format')); ?></td>
												
							
							<td align='center' height='17px'>							
							<?php
								if(empty($report['PharmacySalesBill']['patient_id']))
									echo $report['PharmacySalesBill']['customer_name'];
								else
									echo $report['Patient']['lookup_name'];
										//." (".$report['patient_id'].")";
							?> 
							</td>	
							
							<td align='center' height='17px'><?php echo round($report[0]['totalAmt'],2); ?></td>
							<td align='center' height='17px'><?php echo round($billArr[$report['PharmacySalesBill']['patient_id']],2); ?></td>
						
						</tr>
						
				
			<?php
				  $totCash=$totCash+round($billArr[$report['PharmacySalesBill']['patient_id']],2);
				  $totCredit=$totCredit+round($report[0]['totalAmt'],2);
				$cnt++;
				$k++;
				}
			
				
			
?>	

<tr  style='background:#3796CB;color:yellow;'>	
<td align="right" colspan="3"><strong></strong></td>	
	<td align="center" ><strong><?php echo round($totCredit);?></strong></td>
	<td align="center"><strong><?php echo round($totCash);?></strong></td>
</tr>

<!--<tr  style='background:#3796CB;color:yellow;'>			
	<td align="right" colspan="3"><strong>Grand Total</strong></td>	
	<td align="center" colspan="2"> <strong><?php echo round(array_sum($totCash)+array_sum($totCredit));?></strong></td>
</tr>-->
<?php }else{?>
<tr>
<td colspan="5" align="center" style='background:#B4DFF7;'>No Record Found.</td>
</tr>
<?php }?>
</table>