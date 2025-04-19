<?php
//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Incidence_Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
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
<table border='1' class='table_format'  cellpadding='0' cellspacing='0' width='100%' style='text-align:left;padding-top:50px;'>		
<tr class="row_title">
   <td colspan = "<?php echo count($incidentType)+2; ?>" align="center"><h2><?php echo __('Incident Report')." - ".$year; ?></h2></td>
  </tr>
	  <tr class='row_title'>
		   
		   <td height='30px' align='center' valign='middle'><strong>Month</strong></td>		
		   <td height='30px' align='center' valign='middle'><strong>Medication errors</strong></td>
		   <?php 
		   		foreach($incidentType as $typeName){ 
		   ?>			   
		   <td height='30px' align='center' valign='middle'><strong><?php echo $typeName['IncidentType']['name']; ?></strong></td>
		   <?php } ?>
		   
	  </tr>
 	<?php  		      
			 
			 $month =array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
			 $fullMonth =array('January','February','March','April','May','June','July','August','September','October','November','December');
			 $j=0;
  
			foreach($month as $mon){ 
				$fullMon =  $fullMonth[$j] ;
			 ?>
			<tr>
				<td align='center' height='17px'><?php echo $fullMon ; ?>
				</td>
		  		<td align='center' height='17px'><?php echo round($record[$fullMon]['medication_error']/$discharge[$fullMon],2); ?></td>
	    	<?php 
	    		foreach($incidentType as $typeName){ 
	    	?>
	    		<td align='center' height='17px'><?php echo  ($discharge[$fullMon]>0)?round($record[$fullMon][$typeName['IncidentType']['name']]/$discharge[$fullMon],2):0; ?> </td>
	    	<?php
	    	}
	    ?>	   
	    
	 </tr> 
	 <?php $j++;
	
			 } ?>		   		  
</table>
