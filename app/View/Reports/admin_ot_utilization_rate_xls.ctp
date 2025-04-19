<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Ot_Utilisation_Rate".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: Generated Report" );
ob_clean();
flush();
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
  <tr><td colspan="13" align="center"><h2><?php echo __("OT Utilisation Rate")." - ".$reportYear; ?></h2></td></tr>
          <tr>
           <td width='30%'></td>
           <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
           <td height='30px' align='center' valign='middle' width='12%'><strong><?php echo $yaxisArrayVal; ?></strong></td>
           <?php } ?>
           </tr>
	  <tr>
		<td><?php echo __('Total Number of Invasive Procedure Performed', true); ?></td>   
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                <td align="center">
                   <?php 
                         if(@in_array($key, $filterProcedureDateArray)) { echo $filterProcedureCountArray[$key]; } else { echo "0"; }
                   ?>
                </td>
          <?php } ?>
          </tr>
          <tr>
		<td><?php  echo __('Total Time Taken for Invasive Procedure(Min)', true);  ?></td>   
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                 <td align="center">
                  <?php 
                         if(@in_array($key, $filterTotalTimeDateArray)) { echo $filterTotalTimeArray[$key]; } else { echo "0"; }
                   ?>
                 </td>
          <?php } ?>
          </tr>
		   <tr>
		<td><?php  echo __('Total Delays(Min)', true);  ?></td>   
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                 <td align="center">
                  <?php 
                         if(@in_array($key, $filterTotalTimeDateArray)) { 
		                    if($filterTotalTimeTakenArray[$key] > $filterTotalTimeArray[$key]) {
                               $totalDelays = ($filterTotalTimeTakenArray[$key]-$filterTotalTimeArray[$key]);
							   echo $totalDelays;
							} else {
		                     echo "0"; 
							}
						 } else { 
							 echo "0"; 
						 }
                   ?>
                 </td>
          <?php } ?>
          </tr>
		  <tr>
		<td><?php  echo __('Time Spent with Patient(Min)', true);  ?></td>   
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                 <td align="center">
                   <?php 
                         if(@in_array($key, $filterTotalTimeDateArray)) { 
		                    if($filterTotalTimeTakenArray[$key] > $filterTotalTimeArray[$key]) {
                               $totalDelays = ($filterTotalTimeTakenArray[$key]-$filterTotalTimeArray[$key]);
							   echo ($filterTotalTimeArray[$key] - $totalDelays);
							} else {
		                       echo $filterTotalTimeArray[$key];
							}
						 } else { 
							 echo "0"; 
						 }
                   ?>
                 </td>
          <?php } ?>
          </tr>
         <tr>
		<td><b><?php  echo __('OT Utilisation Rate', true); ?></b></td>   
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                <td align="center">
                    <?php 
                         if(@in_array($key, $filterTotalTimeDateArray)) { 
		                    if($filterTotalTimeTakenArray[$key] > $filterTotalTimeArray[$key]) {
                               $totalDelays = ($filterTotalTimeTakenArray[$key]-$filterTotalTimeArray[$key]);
							   $spentTime = ($filterTotalTimeArray[$key] - $totalDelays);
							} else {
		                       $spentTime =  $filterTotalTimeArray[$key];
							}
							$otutirate = ($spentTime/$filterTotalTimeArray[$key])*100;
							echo $this->Number->toPercentage($otutirate);
						 } else { 
							 echo "0"; 
						 }
                   ?>
                </td>
          <?php } ?>
          </tr>
        </table>

