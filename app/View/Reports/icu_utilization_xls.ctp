<?php
header ("Expires: Mon, 28 Oct 2020 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"ICU_Utilization_Rate".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: Generated Report" );
?>
<STYLE type="text/css">
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
  <tr><td colspan="13" align="center"><h2><?php echo __("ICU Utilization Rate").' - '.$reportYear; ?></h2></td></tr>
          <tr>
           <td width='30%'></td>
           <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
           <td height='30px' align='center' valign='middle' width='12%'><strong><?php echo $yaxisArrayVal; ?></strong></td>
           <?php } ?>
           </tr>
          <tr>
		<td height='30px' align='left' valign='middle'><strong><?php  echo __('ICU Utilization Rate', true);  ?></strong></td>  
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                 <td height='30px' align='center' valign='middle'>
                  <?php 
                         if(@in_array($key, $filterdischargeDeathDateArray)) { echo $filterdischargeDeathCountArray[$key]; } else { echo "0"; }
                   ?>%
                 </td>
          <?php } ?>
         </tr>
		 
        <tr>
			<td><strong>Total ICU Utilization Rate</strong></td> 
			<td><?php echo $icuUtilizationRate; ?></td>
			<td><strong>Out Of</strong></td>
			<td colspan="10"><?php echo $totalHoursIcu; ?>  ICU Hours</td>
		</tr>
		<tr>
			<td><strong>Total IPD Hours</strong></td> 
			<td colspan="12"><?php echo $totalHoursIpd; ?>  Hours</td>
		</tr>
        </table>

