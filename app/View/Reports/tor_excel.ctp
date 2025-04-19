<?php
//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
//header ("Content-Disposition: attachment; filename=\"TOR_report_".date('d-m-Y').".xls");
header ("Content-Disposition: attachment; filename=\"Hospital_Turnover_Rate".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: TOR Report" );
?>
<?php //echo $content_for_layout ?> 

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
<table border='1' class='table_format'  cellpadding='0' cellspacing='0' width='100%' style='text-align:left;padding-top:50px;'>
	  <tr class='row_title'> 
		   <td colspan="3" width="100%" height='30px' align='center' valign='middle'><h2><?php echo __('Hospital Turnover Rate').' - '.$reportYear; ?></h2></td>
	  </tr>
	  				  
	  <tr class='row_title'> 
		   <td height='30px' align='center' valign='middle'><strong>Month</strong></td>					   
		   <td height='30px' align='center' valign='middle'><strong>Discharges+Deaths</strong></td>
		   <td height='30px' align='center' valign='middle'><strong>TOR</strong></td>  
	  </tr>
 	  <?php  
			 foreach($data as $monKey=>$mon){ 
			 
			?>
				<tr>
					<td align='center' height='17px'><?php echo $monKey ; ?></td>
					<td align='center' height='17px'><?php echo $mon['dischargeCount'] ; ?></td>
					<td align='center' height='17px'><?php echo $mon['tor'] ; ?></td>
				 </tr> 
				 <?php  
	
			 } ?>	
	 <tr class='row_title'> 
		   <td colspan="3" width="100%" height='30px' align='center' valign='middle'><strong>Total Beds -<?php echo $bedCount;?></strong></td>
	  </tr>	   		  
</table>
